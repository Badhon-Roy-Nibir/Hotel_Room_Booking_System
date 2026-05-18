<?php


include_once("../Model/AdminModel.php");

header("Content-Type: application/json");

$AdminModel = new AdminModel();


// =========================
// POST - LOGIN
// =========================
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST["action"]) && $_POST["action"] === "Login") {

        $email    = $_POST["email"];
        $password = $_POST["password"];

        $result = $AdminModel->LoginAdmin($email, $password);

        if ($result) {
            $_SESSION["email"] = $email;
            echo json_encode([
                "status"  => "success",
                "message" => "Login successful"
            ]);
        } else {
            echo json_encode([
                "status"  => "fail",
                "message" => "Invalid email or password"
            ]);
        }

        exit;
    }
}


// =========================
// GET ACTIONS
// =========================
if ($_SERVER["REQUEST_METHOD"] === "GET") {

    $action = $_GET["action"] ?? "";

    if ($action === "GetTodaysRevenue") {

        $revenue = $AdminModel->getTodayRevenue();

        echo json_encode([
            "status"         => "success",
            "todays_revenue" => $revenue ?? 0
        ]);

        exit;
    }

    if ($action === "GetOccupancyRate") {

        $rate = $AdminModel->getOccupancyRate();

        echo json_encode([
            "status"        => "success",
            "occupancy_rate" => $rate ?? 0
        ]);

        exit;
    }
    if ($action === "GetAvailableRooms") {

        $rooms = $AdminModel->getAvailableRoom();

        echo json_encode([
            "status" => "success",
            "data"   => $rooms
        ]);

        exit;
    }
    if ($action == "GetOccupiedRooms") {

        $data = $AdminModel->getOccupiedRooms();

        echo json_encode([
            "status" => "success",
            "data" => $data
        ]);

        exit;
    }
    if($action == "GetActiveIssues"){

        $issues = $AdminModel->getActiveMaintenanceIssues();

        echo json_encode([
            "status" => "success",
            "count" => count($issues),
            "data" => $issues
        ]);

        exit;
    }
    if ($action === "GetActiveIssues") {

        $issues = $AdminModel->getActiveMaintenanceIssues();

        echo json_encode([
            "status" => "success",
            "count" => count($issues ?? []),
            "data" => $issues ?? []
        ]);

        exit;
    }
    if ($action === "GetPendingReviews") {

    $reviews = $AdminModel->getPendingGuestReviews();

    echo json_encode([
        "status" => "success",
        "count"  => count($reviews),
        "data"   => $reviews
    ]);

    exit;
}
}
?>