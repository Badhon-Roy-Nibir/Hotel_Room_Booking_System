<?php

session_start();

include_once("../Model/ReportModel.php");

header("Content-Type: application/json");

$FinancialModel = new ReportModel();


// ===============================
// GET REQUEST
// ===============================
if ($_SERVER["REQUEST_METHOD"] === "GET") {

    $from_date = $_GET["from_date"] ?? "";
    $to_date   = $_GET["to_date"] ?? "";
    $period    = $_GET["period"] ?? "day";


    // ===============================
    // TOTAL REVENUE
    // ===============================
    $total_revenue = $FinancialModel->getTotalRevenue($from_date, $to_date);


    // ===============================
    // PERIOD WISE REVENUE
    // ===============================
    $period_data = $FinancialModel->getRevenueByPeriod(
        $from_date,
        $to_date,
        $period
    );


    // ===============================
    // ROOM TYPE REVENUE
    // ===============================
    $room_data = $FinancialModel->getRevenueByRoomType(
        $from_date,
        $to_date
    );


    // ===============================
    // SERVICES REVENUE
    // ===============================
    $service_data = $FinancialModel->getRevenueByServices(
        $from_date,
        $to_date
    );


    // ===============================
    // RESPONSE
    // ===============================
    echo json_encode([
        "status" => "success",
        "total_revenue" => $total_revenue,
        "period_data" => $period_data,
        "room_data" => $room_data,
        "service_data" => $service_data
    ]);

    exit;
}


// ===============================
// DEFAULT RESPONSE
// ===============================
echo json_encode([
    "status" => "fail",
    "message" => "Invalid request"
]);

?>