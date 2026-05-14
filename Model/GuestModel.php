<?php

include_once("../DB/DBConnect.php");

class GuestModel {

    private $conn;

    public function __construct() {
        $db = new DBConnect();
        $this->conn = $db->connect();
    }


    // =========================
    // GET ALL GUESTS
    // =========================
    public function getAllGuests() {

        $sql = "
            SELECT *
            FROM users
            WHERE role = 'guest'
            ORDER BY id DESC
        ";

        $result = $this->conn->query($sql);

        $data = [];

        if ($result && $result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {

                // Convert image to base64 for frontend
                if (!empty($row["profile_pic"])) {
                    $row["profile_pic"] = base64_encode($row["profile_pic"]);
                }

                $data[] = $row;
            }
        }

        return $data;
    }


    // =========================
    // GET GUEST BY ID
    // =========================
    public function getGuestById($id) {

        $sql = "
            SELECT *
            FROM users
            WHERE id = ?
            AND role = 'guest'
            LIMIT 1
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {

            if (!empty($row["profile_pic"])) {
                $row["profile_pic"] = base64_encode($row["profile_pic"]);
            }

            return $row;
        }

        return null;
    }


    // =========================
    // DEACTIVATE GUEST (POLICY VIOLATION)
    // =========================
    public function deactivateGuest($id) {

        $sql = "
            UPDATE users
            SET is_active = 0
            WHERE id = ?
            AND role = 'guest'
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }
}

?>