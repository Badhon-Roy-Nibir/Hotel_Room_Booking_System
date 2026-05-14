<?php

include_once("../DB/DBConnect.php");

class BookingModel {

    private $conn;

    public function __construct(){

        $db = new DBConnect();
        $this->conn = $db->connect();
    }

    
    // ===============================
    // GET FILTERED BOOKINGS
    // ===============================
    public function getFilteredBookings(
        $status,
        $room_type_id,
        $source,
        $from_date,
        $to_date
    ){

        $sql = "
            SELECT 
                b.id,
                b.guest_id,
                b.room_id,
                b.room_type_id,
                b.checkin_date,
                b.checkout_date,
                b.num_guests,
                b.total_price,
                b.status,
                b.source,
                b.created_at,
                u.name AS guest_name
            FROM bookings b
            LEFT JOIN users u
            ON b.guest_id = u.id
            WHERE 1=1
        ";

        $params = [];
        $types = "";


        // STATUS FILTER
        if(!empty($status)){

            $sql .= " AND b.status = ?";

            $params[] = $status;

            $types .= "s";
        }


        // ROOM TYPE FILTER
        if(!empty($room_type_id)){

            $sql .= " AND b.room_type_id = ?";

            $params[] = $room_type_id;

            $types .= "i";
        }


        // SOURCE FILTER
        if(!empty($source)){

            $sql .= " AND b.source = ?";

            $params[] = $source;

            $types .= "s";
        }


        // DATE FILTER
        if(!empty($from_date) && !empty($to_date)){

            $sql .= " AND b.checkin_date BETWEEN ? AND ?";

            $params[] = $from_date;
            $params[] = $to_date;

            $types .= "ss";
        }


        $stmt = $this->conn->prepare($sql);

        if(!$stmt){
            die($this->conn->error);
        }


        if(!empty($params)){

            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();

        $result = $stmt->get_result();

        $data = [];

        while($row = $result->fetch_assoc()){

            $data[] = $row;
        }

        return $data;
    }
}
?>