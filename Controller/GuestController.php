<?php

session_start();
if(!isset($_SESSION["email"])){
    echo json_encode(["status" => "fail", "message" => "Unauthorized"]);
    exit;
}

include_once("../Model/GuestModel.php");

header("Content-Type: application/json");

$GuestModel = new GuestModel();


// =========================
// GET REQUESTS
// =========================
if ($_SERVER["REQUEST_METHOD"] === "GET") {

    $action = $_GET["action"] ?? "";



    // =========================
    // GET ALL GUESTS
    // =========================
    if ($action == "GetGuests") {

        $data = $GuestModel->getAllGuests();

        echo json_encode([
            "status" => "success",
            "data" => $data
        ]);

        exit;
    }



    // =========================
    // GET GUEST BY ID
    // =========================
    if ($action == "GetGuestById") {

        $id = $_GET["id"];

        $data = $GuestModel->getGuestById($id);

        echo json_encode([
            "status" => $data ? "success" : "fail",
            "data" => $data
        ]);

        exit;
    }



    // =========================
    // DEACTIVATE GUEST (POLICY VIOLATION)
    // =========================
    if ($action == "DeactivateGuest") {

        $id = $_GET["id"];

        $result = $GuestModel->deactivateGuest($id);

        echo json_encode([
            "status" => $result ? "success" : "fail",
            "message" => $result
                ? "Guest account deactivated due to policy violation"
                : "Failed to deactivate guest"
        ]);

        exit;
    }
}

?>