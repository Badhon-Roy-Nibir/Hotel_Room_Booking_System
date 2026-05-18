<?php
session_start();
include_once("../DB/DBConnect.php");

class AdminModel {

    private $conn = null;

    public function __construct() {
        $db_obj = new DBConnect();
        $this->conn = $db_obj->connect();
    }


    // =========================
    // LOGIN
    // =========================
    public function LoginAdmin(string $email, string $password) {
        $sql = "SELECT password_hash FROM users WHERE email = ? AND role = 'admin' LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($password == $row["password_hash"]) {
                return true;
            }
        }
        return false;
    }


    // =========================
    // OCCUPANCY RATE
    // =========================
    public function getOccupancyRate() {
        $sql = "
            SELECT ROUND(SUM(status = 'occupied') * 100.0 / COUNT(*), 2) AS occupancy_rate
            FROM rooms
        ";
        $result = $this->conn->query($sql);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row["occupancy_rate"] ?? 0;
        }
        return 0;
    }
    // =========================
    // AVAILABLE ROOMS
    // =========================
    public function getAvailableRoom() {
        $sql = "
            SELECT room_number
            FROM rooms
            WHERE status = 'available'
        ";
        $result = $this->conn->query($sql);
        $rooms = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $rooms[] = $row;
            }
        }
        return $rooms;
    }
    // =========================
    // TODAY'S TOTAL REVENUE
    // =========================
    public function getTodayRevenue() {
        $sql = "
            SELECT SUM(total_amount) AS todays_total_revenue
            FROM billing
            WHERE DATE(paid_at) = CURDATE()
            AND payment_status = 'paid'
        ";
        $result = $this->conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row["todays_total_revenue"] ?? 0;
        }
        return 0;
    }
    public function getOccupiedRooms(){
        $sql = "SELECT room_number FROM rooms WHERE status = 'occupied';";
        $result = $this->conn->query($sql);
        $rooms = [];

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $rooms[] = $row;
            }
        }
        return $rooms;
    }
    public function getActiveMaintenanceIssues(){

    $sql = "
        SELECT *
        FROM maintenance_reports
        WHERE status IN ('open', 'in_progress')
        ORDER BY reported_at DESC
    ";

    $result = $this->conn->query($sql);

    $issues = [];

    if ($result && $result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {
            $issues[] = $row;
        }
    }
    return $issues;
}
public function getPendingGuestReviews(){

    $sql = "
        SELECT 
            id,
            booking_id,
            guest_id,
            overall_rating,
            cleanliness_rating,
            service_rating,
            review_text,
            created_at
        FROM reviews
        WHERE admin_reply IS NULL
        ORDER BY created_at DESC
    ";

    $result = $this->conn->query($sql);
    $reviews = [];

    if (!$result) {
        return [];
    }

    while ($row = $result->fetch_assoc()) {
        $reviews[] = $row;
    }
    return $reviews;
}
}
?>