
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
public function addRoomType($name, $description, $price, $capacity, $amenities, $thumbnail,$thumbnailType){

    $sql = "
        INSERT INTO room_types
        (name,description,price_per_night,max_capacity,amenities,thumbnail,thumbnail_type)
        VALUES
        (
            '$name',
            '$description',
            '$price',
            '$capacity',
            '$amenities',
            '$thumbnail',
            '$thumbnailType'
        )
    ";

    return $this->conn->query($sql);
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

        name = '$name',
        description = '$description',
        price_per_night = '$price',
        max_capacity = '$capacity',
        amenities = '$amenities',
        thumbnail = '$thumbnail',
        thumbnail_type = '$thumbnailType'

        WHERE id = '$id'
    ";

    return $this->conn->query($sql);
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