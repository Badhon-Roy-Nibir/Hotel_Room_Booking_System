<?php

session_start();

include_once("../Model/ReceptionistModel.php");

header("Content-Type: application/json");

$ReceptionistModel = new ReceptionistModel();



// =========================
// POST REQUESTS
// =========================
if($_SERVER["REQUEST_METHOD"] === "POST"){

    $action = $_POST["action"] ?? "";



    // =========================
    // ADD RECEPTIONIST
    // =========================
    if($action == "AddReceptionist"){

        $name = $_POST["name"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $phone = $_POST["phone"];
        $nationality = $_POST["nationality"];
        $id_number = $_POST["id_number"];
        $is_active = $_POST["is_active"];



        // IMAGE UPLOAD
        $imageData = null;
        $imageType = null;

        if(isset($_FILES["profile_pic"]) && $_FILES["profile_pic"]["size"] > 0){

            $imageData = file_get_contents($_FILES["profile_pic"]["tmp_name"]);
            $imageType = $_FILES["profile_pic"]["type"];
        }



        $result = $ReceptionistModel->addReceptionist(
            $name,
            $email,
            $password,
            $phone,
            $nationality,
            $id_number,
            $is_active,
            $imageData,
            $imageType
        );



        echo json_encode([
            "status" => $result ? "success" : "fail",
            "message" => $result ? "Receptionist added successfully" : "Failed to add receptionist"
        ]);

        exit;
    }



    // =========================
    // UPDATE RECEPTIONIST
    // =========================
    if($action == "UpdateReceptionist"){

        $id = $_POST["id"];

        $name = $_POST["name"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $phone = $_POST["phone"];
        $nationality = $_POST["nationality"];
        $id_number = $_POST["id_number"];
        $is_active = $_POST["is_active"];



        // GET OLD DATA
        $old = $ReceptionistModel->getReceptionistById($id);

        if(!$old){
            echo json_encode([
                "status" => "fail",
                "message" => "Receptionist not found"
            ]);
            exit;
        }



        $imageData = base64_decode($old["profile_pic"]);
        $imageType = $old["profile_pic_type"];



        // IF NEW IMAGE UPLOADED
        if(isset($_FILES["profile_pic"]) && $_FILES["profile_pic"]["size"] > 0){

            $imageData = file_get_contents($_FILES["profile_pic"]["tmp_name"]);
            $imageType = $_FILES["profile_pic"]["type"];
        }



        // IF PASSWORD EMPTY → KEEP OLD PASSWORD
        if($password == ""){
            $password = $old["password_hash"];
        }



        $result = $ReceptionistModel->updateReceptionist(
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
        );



        echo json_encode([
            "status" => $result ? "success" : "fail",
            "message" => $result ? "Receptionist updated successfully" : "Failed to update receptionist"
        ]);

        exit;
    }
}



// =========================
// GET REQUESTS
// =========================
if($_SERVER["REQUEST_METHOD"] === "GET"){

    $action = $_GET["action"] ?? "";



    // =========================
    // GET ALL
    // =========================
    if($action == "GetReceptionists"){

        $data = $ReceptionistModel->getAllReceptionists();

        echo json_encode([
            "status" => "success",
            "data" => $data
        ]);

        exit;
    }



    // =========================
    // GET BY ID
    // =========================
    if($action == "GetReceptionistById"){

        $id = $_GET["id"];

        $data = $ReceptionistModel->getReceptionistById($id);

        echo json_encode([
            "status" => $data ? "success" : "fail",
            "data" => $data
        ]);

        exit;
    }



    // =========================
    // DEACTIVATE
    // =========================
    if($action == "DeactivateReceptionist"){

        $id = $_GET["id"];

        $result = $ReceptionistModel->deactivateReceptionist($id);

        echo json_encode([
            "status" => $result ? "success" : "fail",
            "message" => $result ? "Receptionist deactivated" : "Failed to deactivate"
        ]);

        exit;
    }
}
?>