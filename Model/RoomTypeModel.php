
<?php

include_once("../DB/DBConnect.php");

class RoomTypeModel{

    private $conn = null;

    public function __construct()
    {
        $db_obj = new DBConnect();
        $this->conn = $db_obj->connect();
    }

    // GET ALL ROOM TYPES
    public function getAllRoomTypes(){

        $sql = "SELECT * FROM room_types";

        $result = $this->conn->query($sql);

        $roomTypes = [];

        if($result && $result->num_rows > 0){

            while($row = $result->fetch_assoc()){

                
                $row["thumbnail"] = base64_encode($row["thumbnail"]);

                $roomTypes[] = $row;
            }
        }

        return $roomTypes;
    }

    // GET ROOM TYPE BY ID
    public function getRoomTypeById($id){

        $sql = "
            SELECT * 
            FROM room_types
            WHERE id = '$id'
        ";

        $result = $this->conn->query($sql);

        if($result && $result->num_rows > 0){

                        
            $row = $result->fetch_assoc();
            $row["thumbnail"] = base64_encode($row["thumbnail"]);

            return $row;
        }

        return null;
    }


    // ADD ROOM TYPE    
public function addRoomType(
    $name,
    $description,
    $price,
    $capacity,
    $amenities,
    $thumbnail,
    $thumbnailType
){

    $sql = "
        INSERT INTO room_types
        (
            name,
            description,
            price_per_night,
            max_capacity,
            amenities,
            thumbnail,
            thumbnail_type
        )
        VALUES
        (
            ?, ?, ?, ?, ?, ?, ?
        )
    ";

    $stmt = $this->conn->prepare($sql);

    $stmt->bind_param(
        "ssdisss",
        $name,
        $description,
        $price,
        $capacity,
        $amenities,
        $thumbnail,
        $thumbnailType
    );

    return $stmt->execute();
}

    // UPDATE ROOM TYPE    
public function updateRoomType(
    $id,
    $name,
    $description,
    $price,
    $capacity,
    $amenities,
    $thumbnail,
    $thumbnailType
){

    $sql = "
        UPDATE room_types
        SET
            name = ?,
            description = ?,
            price_per_night = ?,
            max_capacity = ?,
            amenities = ?,
            thumbnail = ?,
            thumbnail_type = ?
        WHERE id = ?
    ";

    $stmt = $this->conn->prepare($sql);

    $stmt->bind_param(
        "ssdisssi",
        $name,
        $description,
        $price,
        $capacity,
        $amenities,
        $thumbnail,
        $thumbnailType,
        $id
    );

    return $stmt->execute();
}
    // DELETE ROOM TYPE
    public function deleteRoomType($id){

        $sql = "
            DELETE FROM room_types
            WHERE id = '$id'
        ";

        return $this->conn->query($sql);
    }

}

?>