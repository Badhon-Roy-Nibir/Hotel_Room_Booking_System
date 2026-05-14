<?php

include_once("../DB/DBConnect.php");

class ReceptionistModel{

    private $conn;

    public function __construct(){
        $db = new DBConnect();
        $this->conn = $db->connect();
    }


    // ADD RECEPTIONIST
    public function addReceptionist(
    $name,
    $email,
    $password,
    $phone,
    $nationality,
    $id_number,
    $is_active,
    $imageData,
    $imageType
) {

    $sql = "
        INSERT INTO users
        (
            name,
            email,
            password_hash,
            phone,
            nationality,
            id_number,
            role,
            profile_pic,
            profile_pic_type,
            is_active
        )
        VALUES
        (
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
        )
    ";

    $stmt = $this->conn->prepare($sql);

    $role = "receptionist";

    $stmt->bind_param(
        "sssssssssi",
        $name,
        $email,
        $password,
        $phone,
        $nationality,
        $id_number,
        $role,
        $imageData,
        $imageType,
        $is_active
    );

    return $stmt->execute();
}


    // GET ALL RECEPTIONISTS
    public function getAllReceptionists(){

        $sql = "
            SELECT *
            FROM users
            WHERE role = 'receptionist'
        ";

        $result = $this->conn->query($sql);

        $data = [];

        if($result && $result->num_rows > 0){

            while($row = $result->fetch_assoc()){

                // convert BLOB → base64 for frontend
                if(!empty($row["profile_pic"])){

                    $row["profile_pic"] = base64_encode($row["profile_pic"]);
                }

                $data[] = $row;
            }
        }

        return $data;
    }

    // GET RECEPTIONIST BY ID
    public function getReceptionistById($id){

        $sql = "
            SELECT *
            FROM users
            WHERE id = '$id'
            AND role = 'receptionist'
        ";

        $result = $this->conn->query($sql);

        if($result && $result->num_rows > 0){

            $row = $result->fetch_assoc();

            if(!empty($row["profile_pic"])){

                $row["profile_pic"] = base64_encode($row["profile_pic"]);
            }

            return $row;
        }

        return null;
    }


    // UPDATE RECEPTIONIST
    public function updateReceptionist(
    $id,
    $name,
    $email,
    $password,
    $phone,
    $nationality,
    $id_number,
    $is_active,
    $imageData,
    $imageType
){


    $sql = "
        UPDATE users
        SET
            name = ?,
            email = ?,
            password_hash = ?,
            phone = ?,
            nationality = ?,
            id_number = ?,
            profile_pic = ?,
            profile_pic_type = ?,
            is_active = ?
        WHERE id = ?
        AND role = ?
    ";

    $stmt = $this->conn->prepare($sql);

    $role = "receptionist";

    $stmt->bind_param(
        "ssssssssiss",
        $name,
        $email,
        $password,
        $phone,
        $nationality,
        $id_number,
        $imageData,
        $imageType,
        $is_active,
        $id,
        $role
    );

    return $stmt->execute();
}


    // DEACTIVATE RECEPTIONIST
    public function deactivateReceptionist($id){

        $sql = "
            UPDATE users
            SET is_active = 0
            WHERE id = '$id'
            AND role = 'receptionist'
        ";

        return $this->conn->query($sql);
    }
}

?>