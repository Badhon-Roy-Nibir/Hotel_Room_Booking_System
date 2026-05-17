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
            id,
            room_number,
            room_type_id,
            floor,
            status
        FROM rooms
    ";

    $result = $this->conn->query($sql);

    $rooms = [];

    while($row = $result->fetch_assoc()){
        $rooms[] = $row;
    }

    return $rooms;
    }


    // GET ROOM BY ID
    public function getRoomById($id){

        $sql = "SELECT * from rooms WHERE id=$id;";

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
        VALUES (?, ?, ?, ?)
    ";

    $stmt = $this->conn->prepare($sql);

    if(!$stmt){
        die("Prepare Error: " . $this->conn->error);
    }

    $stmt->bind_param(
        "siis",
        $roomNumber,
        $roomTypeId,
        $floor,
        $status
    );

    if(!$stmt->execute()){
        die("Execute Error: " . $stmt->error);
    }

    return true;
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
    if(!$stmt){
        error_log("Prepare failed: " . $this->conn->error);
        return false;
    }

    $stmt->bind_param(
        "siisi",
        $roomNumber,
        $roomTypeId,
        $floor,
        $status,
        $id
    );
    

    $exec = $stmt->execute();

    if(!$exec){
        error_log("Execute failed: " . $stmt->error);
    }
    return $exec;
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