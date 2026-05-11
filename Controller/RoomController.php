<?php
    session_start();
    include_once("../Model/RoomModel.php");

    header("Content-Type: application/json");

    $RoomModel = new RoomModel();


    // =========================
    // ADD ROOM
    // =========================
    if($_SERVER["REQUEST_METHOD"] === "POST"){

        if(isset($_POST["action"]) && $_POST["action"] == "AddRoom"){

            $roomNumber  = $_POST["roomNumber"];
            $roomTypeId  = $_POST["roomTypeId"];
            $floor       = $_POST["floor"];
            $status      = $_POST["status"];

            $result = $RoomModel->addRoom(
                $roomNumber,
                $roomTypeId,
                $floor,
                $status
            );

            if($result){
                echo json_encode([
                    "status" => "success",
                    "message" => "Room added successfully"
                ]);
            }else{
                echo json_encode([
                    "status" => "fail",
                    "message" => "Failed to add room"
                ]);
            }
        }


        // =========================
        // UPDATE ROOM
        // =========================
        if(isset($_POST["action"]) && $_POST["action"] == "UpdateRoom"){

            $id          = $_POST["id"];
            $roomNumber  = $_POST["roomNumber"];
            $roomTypeId  = $_POST["roomTypeId"];
            $floor       = $_POST["floor"];
            $status      = $_POST["status"];

            $result = $RoomModel->updateRoom(
                $id,
                $roomNumber,
                $roomTypeId,
                $floor,
                $status
            );

            if($result){
                echo json_encode([
                    "status" => "success",
                    "message" => "Room updated successfully"
                ]);
            }else{
                echo json_encode([
                    "status" => "fail",
                    "message" => "Failed to update room"
                ]);
            }
        }
    }


    // =========================
    // GET ALL ROOMS
    // =========================
    if($_SERVER["REQUEST_METHOD"] === "GET"){

        if(isset($_GET["action"]) && $_GET["action"] == "GetRooms"){

            $rooms = $RoomModel->getAllRooms();

            echo json_encode([
                "status" => "success",
                "data" => $rooms
            ]);
        }


        // =========================
        // GET SINGLE ROOM
        // =========================
        if(isset($_GET["action"]) && $_GET["action"] == "GetRoomById"){

            $id = $_GET["id"];

            $room = $RoomModel->getRoomById($id);

            echo json_encode([
                "status" => "success",
                "data" => $room
            ]);
        }


        // =========================
        // DELETE ROOM (SAFE CHECK)
        // =========================
        if(isset($_GET["action"]) && $_GET["action"] == "DeleteRoom"){

            $id = $_GET["id"];

            if($RoomModel->hasActiveBooking($id)){

                echo json_encode([
                    "status" => "fail",
                    "message" => "Cannot delete room. Active booking exists."
                ]);

            }else{

                $result = $RoomModel->deleteRoom($id);

                if($result){
                    echo json_encode([
                        "status" => "success",
                        "message" => "Room deleted successfully"
                    ]);
                }else{
                    echo json_encode([
                        "status" => "fail",
                        "message" => "Failed to delete room"
                    ]);
                }
            }
        }
    }

?>