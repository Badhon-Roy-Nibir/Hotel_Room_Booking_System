<?php

session_start();

include_once("../Model/SupervisorModel.php");

header("Content-Type: application/json");

$supervisorModel = new SupervisorModel();



// =========================
// POST REQUESTS
// =========================
if($_SERVER["REQUEST_METHOD"] === "POST"){

    $action = $_POST["action"] ?? "";



    // =========================
    // ADD RECEPTIONIST
    // =========================
    if($action == "AddSupervisor"){

        $name = $_POST["name"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $phone = $_POST["phone"];
        $nationality = $_POST["nationality"];
        $id_number = $_POST["id_number"];
        $is_active = $_POST["is_active"];

        $imageData = null;
        $imageType = null;

        if(isset($_FILES["profile_pic"]) && $_FILES["profile_pic"]["size"] > 0){

            $imageData = file_get_contents($_FILES["profile_pic"]["tmp_name"]);
            $imageType = $_FILES["profile_pic"]["type"];
        }

        $result = $supervisorModel->addSupervisor(
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
    if($action == "UpdateSupervisor"){

        $id = $_POST["id"];

        $name = $_POST["name"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $phone = $_POST["phone"];
        $nationality = $_POST["nationality"];
        $id_number = $_POST["id_number"];
        $is_active = $_POST["is_active"];

        $old = $supervisorModel->getSupervisorById($id);

        if(!$old){
            echo json_encode([
                "status" => "fail",
                "message" => "Receptionist not found"
            ]);
            exit;
        }

        $imageData = $old["profile_pic"];
        $imageType = $old["profile_pic_type"];

        if(isset($_FILES["profile_pic"]) && $_FILES["profile_pic"]["size"] > 0){

            $imageData = file_get_contents($_FILES["profile_pic"]["tmp_name"]);
            $imageType = $_FILES["profile_pic"]["type"];
        }

        if($password == ""){
            $password = $old["password_hash"];
        }

        $result = $supervisorModel->updateSupervisor(
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



    // GET ALL
    if($action == "GetSupervisors"){

        $data = $supervisorModel->getAllSupervisors();

        echo json_encode([
            "status" => "success",
            "data" => $data
        ]);
        exit;
    }



    // GET BY ID
    if($action == "GetSupervisorById"){

        $id = $_GET["id"];

        $data = $supervisorModel->getSupervisorById($id);

        echo json_encode([
            "status" => $data ? "success" : "fail",
            "data" => $data
        ]);
        exit;
    }



    // DEACTIVATE
    if($action == "DeactivateSupervisor"){

        $id = $_GET["id"];

        $result = $supervisorModel->deactivateSupervisor($id);

        echo json_encode([
            "status" => $result ? "success" : "fail",
            "message" => $result ? "Receptionist deactivated" : "Failed to deactivate"
        ]);

        exit;
    }
}

?>