<?php

include_once("../DB/DBConnect.php");

class ReportModel {

    private $conn;

    public function __construct() {
        $db = new DBConnect();
        $this->conn = $db->connect();
    }


    // ===============================
    // TOTAL REVENUE
    // ===============================
    public function getTotalRevenue($from_date, $to_date) {

        $sql = "
            SELECT SUM(total_price) AS total
            FROM bookings
            WHERE status IN ('confirmed','checked_in','checked_out')
        ";

        if (!empty($from_date) && !empty($to_date)) {
            $sql .= " AND DATE(created_at) BETWEEN ? AND ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ss", $from_date, $to_date);
        } else {
            $stmt = $this->conn->prepare($sql);
        }

        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        return $result["total"] ?? 0;
    }


    // ===============================
    // REVENUE BY PERIOD (DAY/WEEK/MONTH)
    // ===============================
    public function getRevenueByPeriod($from_date, $to_date, $period) {

        // Choose grouping format
        if ($period == "week") {
            $groupBy = "YEARWEEK(created_at)";
            $label = "CONCAT(YEAR(created_at), '-W', WEEK(created_at))";
        } elseif ($period == "month") {
            $groupBy = "YEAR(created_at), MONTH(created_at)";
            $label = "DATE_FORMAT(created_at, '%Y-%m')";
        } else {
            $groupBy = "DATE(created_at)";
            $label = "DATE(created_at)";
        }

        $sql = "
            SELECT 
                $label AS period,
                SUM(total_price) AS revenue
            FROM bookings
            WHERE status IN ('confirmed','checked_in','checked_out')
        ";

        $params = [];
        $types = "";

        if (!empty($from_date) && !empty($to_date)) {
            $sql .= " AND DATE(created_at) BETWEEN ? AND ?";
            $params[] = $from_date;
            $params[] = $to_date;
            $types .= "ss";
        }

        $sql .= " GROUP BY $groupBy ORDER BY created_at ASC";

        $stmt = $this->conn->prepare($sql);

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }


    // ===============================
    // REVENUE BY ROOM TYPE
    // ===============================
    public function getRevenueByRoomType($from_date, $to_date) {

        $sql = "
            SELECT 
                r.room_type AS room_type,
                SUM(b.total_price) AS revenue
            FROM bookings b
            JOIN rooms r ON b.room_id = r.id
            WHERE b.status IN ('confirmed','checked_in','checked_out')
        ";

        $params = [];
        $types = "";

        if (!empty($from_date) && !empty($to_date)) {
            $sql .= " AND DATE(b.created_at) BETWEEN ? AND ?";
            $params[] = $from_date;
            $params[] = $to_date;
            $types .= "ss";
        }

        $sql .= " GROUP BY r.room_type";

        $stmt = $this->conn->prepare($sql);

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }


    // ===============================
    // REVENUE FROM SERVICES / EXTRAS
    // (Assuming booking_services table exists)
    // ===============================
    public function getRevenueByServices($from_date, $to_date) {

        $sql = "
            SELECT 
                s.service_name AS service_name,
                SUM(bs.price) AS revenue
            FROM booking_services bs
            JOIN services s ON bs.service_id = s.id
            JOIN bookings b ON bs.booking_id = b.id
            WHERE b.status IN ('confirmed','checked_in','checked_out')
        ";

        $params = [];
        $types = "";

        if (!empty($from_date) && !empty($to_date)) {
            $sql .= " AND DATE(b.created_at) BETWEEN ? AND ?";
            $params[] = $from_date;
            $params[] = $to_date;
            $types .= "ss";
        }

        $sql .= " GROUP BY s.service_name";

        $stmt = $this->conn->prepare($sql);

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $data = [];

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }
}

?>