<?php

include_once("../DB/DBConnect.php");

class SupervisorModel{

    private $conn;

    public function __construct(){
        $db = new DBConnect();
        $this->conn = $db->connect();
    }



    // =========================
    // ADD SUPERVISOR
    // =========================
    public function addSupervisor(
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

    $role = "housekeeping";

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



    // =========================
    // GET ALL SUPERVISORS
    // =========================
    public function getAllSupervisors(){

        $sql = "
            SELECT *
            FROM users
            WHERE role = 'housekeeping'
        ";

        $result = $this->conn->query($sql);

        $data = [];

        if($result && $result->num_rows > 0){

            while($row = $result->fetch_assoc()){

                if(!empty($row["profile_pic"])){
                    $row["profile_pic"] = base64_encode($row["profile_pic"]);
                }

                $data[] = $row;
            }
        }

        return $data;
    }



    // =========================
    // GET BY ID (SAFE)
    // =========================
    public function getSupervisorById($id){

    $sql = "
        SELECT *
        FROM users
        WHERE id = ?
        AND role = 'housekeeping'
        LIMIT 1
    ";

    $stmt = $this->conn->prepare($sql);

    if(!$stmt){
        die($this->conn->error);
    }

    $stmt->bind_param("i", $id);

    $stmt->execute();

    $result = $stmt->get_result();

    if($result && $result->num_rows > 0){

        $row = $result->fetch_assoc();

        if(!empty($row["profile_pic"])){

            $row["profile_pic"] =
                base64_encode($row["profile_pic"]);
        }

        return $row;
    }

    return null;
}



    // =========================
    // UPDATE SUPERVISOR
    // =========================
    public function updateSupervisor(
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

    $role = "housekeeping";

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



    // =========================
    // DEACTIVATE SUPERVISOR
    // =========================
    public function deactivateSupervisor($id){

        $sql = "
            UPDATE users
            SET is_active = 0
            WHERE id = ?
            AND role = 'housekeeping'
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }
}

?>