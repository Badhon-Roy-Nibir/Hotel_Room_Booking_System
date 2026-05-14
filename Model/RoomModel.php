<?php

include_once("../DB/DBConnect.php");

class RoomModel{

    private $conn = null;

    public function __construct()
    {
        $db_obj = new DBConnect();
        $this->conn = $db_obj->connect();
    }


    // GET ALL ROOMS (WITH ROOM TYPE NAME)
    public function getAllRooms(){

        $sql = "
            SELECT 
                rooms.id,
                rooms.room_number,
                rooms.floor,
                rooms.status,
                rooms.room_type_id,
                room_types.name AS room_type
            FROM rooms
            INNER JOIN room_types 
            ON rooms.room_type_id = room_types.id
        ";

        $result = $this->conn->query($sql);

        $rooms = [];

        if($result && $result->num_rows > 0){

            while($row = $result->fetch_assoc()){
                $rooms[] = $row;
            }
        }

        return $rooms;
    }


    // GET ROOM BY ID
    public function getRoomById($id){

        $sql = "
            SELECT 
                rooms.id,
                rooms.room_number,
                rooms.floor,
                rooms.status,
                rooms.room_type_id,
                room_types.name AS room_type
            FROM rooms
            INNER JOIN room_types 
            ON rooms.room_type_id = room_types.id
            WHERE rooms.id = '$id'
        ";

        $result = $this->conn->query($sql);

        if($result && $result->num_rows > 0){
            return $result->fetch_assoc();
        }

        return null;
    }


    // ADD ROOM
    public function addRoom($roomNumber, $roomTypeId, $floor, $status){

    $sql = "
        INSERT INTO rooms 
        (room_number, room_type_id, floor, status)
        VALUES 
        (?, ?, ?, ?)
    ";

    $stmt = $this->conn->prepare($sql);

    $stmt->bind_param(
        "siss",
        $roomNumber,
        $roomTypeId,
        $floor,
        $status
    );

    return $stmt->execute();
}


    // UPDATE ROOM
    public function updateRoom($id, $roomNumber, $roomTypeId, $floor, $status){

    $sql = "
        UPDATE rooms SET
            room_number = ?,
            room_type_id = ?,
            floor = ?,
            status = ?
        WHERE id = ?
    ";

    $stmt = $this->conn->prepare($sql);

    $stmt->bind_param(
        "sissi",
        $roomNumber,
        $roomTypeId,
        $floor,
        $status,
        $id
    );

    return $stmt->execute();
}


    // DELETE ROOM
    public function deleteRoom($id){

        $sql = "DELETE FROM rooms WHERE id = '$id'";

        return $this->conn->query($sql);
    }


    // CHECK ACTIVE BOOKING (SAFE DELETE RULE)
    public function hasActiveBooking($id){

        $sql = "
            SELECT * FROM bookings
            WHERE room_id = '$id'
            AND status IN ('pending','confirmed','checked_in')
        ";

        $result = $this->conn->query($sql);

        return ($result && $result->num_rows > 0);
    }
}

?>