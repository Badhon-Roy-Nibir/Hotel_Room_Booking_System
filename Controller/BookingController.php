<?php

session_start();
if(!isset($_SESSION["email"])){
    echo json_encode(["status" => "fail", "message" => "Unauthorized"]);
    exit;
}

include_once("../Model/BookingModel.php");

header("Content-Type: application/json");

$BookingModel = new BookingModel();



// ===============================
// GET BOOKINGS WITH FILTERS
// ===============================
if($_SERVER["REQUEST_METHOD"] === "GET"){

    $status = $_GET["status"] ?? "";

    $room_type_id = $_GET["room_type_id"] ?? "";

    $source = $_GET["source"] ?? "";

    $from_date = $_GET["from_date"] ?? "";

    $to_date = $_GET["to_date"] ?? "";


    $data = $BookingModel->getFilteredBookings(
        $status,
        $room_type_id,
        $source,
        $from_date,
        $to_date
    );


    echo json_encode([
        "status" => "success",
        "data" => $data
    ]);

    exit;
}



// ===============================
// INVALID REQUEST
// ===============================
echo json_encode([
    "status" => "fail",
    "message" => "Invalid Request"
]);

?>