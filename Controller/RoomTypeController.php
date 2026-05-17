
<?php

    session_start();
    if(!isset($_SESSION["email"])){
    echo json_encode(["status" => "fail", "message" => "Unauthorized"]);
    exit;
}

    include_once("../Model/RoomTypeModel.php");

    // header("Content-Type: application/json");

    $RoomTypeModel = new RoomTypeModel();



    // ADD ROOM TYPE
    if($_SERVER["REQUEST_METHOD"] === "POST"){

        if(isset($_POST["action"]) && $_POST["action"] == "AddRoomType"){

            $name = $_POST["name"];
            $description = $_POST["description"];
            $price = $_POST["price"];
            $capacity = $_POST["capacity"];
            $amenities = $_POST["amenities"];

            
     
            $image = $_FILES["thumbnail"]["tmp_name"];
            $imageType = $_FILES["thumbnail"]["type"];
            $imageData = file_get_contents($image);



            $result = $RoomTypeModel->addRoomType(
                $name,
                $description,
                $price,
                $capacity,
                $amenities,
                $imageData,
                $imageType
            );

            if($result){

                echo json_encode([
                    "status" => "success",
                    "message" => "Room Type Added Successfully"
                ]);

            }else{

                echo json_encode([
                    "status" => "fail",
                    "message" => "Failed to Add Room Type"
                ]);
            }
        }
        // UPDATE ROOM TYPE
        if(isset($_POST["action"]) && $_POST["action"] == "UpdateRoomType"){

            $id = $_POST["id"];

            $name = $_POST["name"];
            $description = $_POST["description"];
            $price = $_POST["price"];
            $capacity = $_POST["capacity"];
            $amenities = $_POST["amenities"];



            // GET OLD IMAGE FIRST
            $room = $RoomTypeModel->getRoomTypeById($id);

            $imageData = $room["thumbnail"];
            $imageType = $room["thumbnail_type"];



            // IF NEW IMAGE SELECTED
            if(isset($_FILES["thumbnail"]) && $_FILES["thumbnail"]["size"] > 0){

                $image = $_FILES["thumbnail"]["tmp_name"];

                $imageType = $_FILES["thumbnail"]["type"];

                $imageData = file_get_contents($image);
    }



            $result = $RoomTypeModel->updateRoomType(
                $id,
                $name,
                $description,
                $price,
                $capacity,
                $amenities,
                $imageData,
                $imageType
            );



            if($result){

                echo json_encode([
                    "status" => "success",
                    "message" => "Room Type Updated Successfully"
                ]);

            }else{

                echo json_encode([
                    "status" => "fail",
                    "message" => "Failed to Update Room Type"
                ]);
            }
        }
    }
        



    // GET REQUESTS
    if($_SERVER["REQUEST_METHOD"] === "GET"){


        // GET ALL ROOM TYPES
        if(isset($_GET["action"]) && $_GET["action"] == "GetRoomTypes"){

            $data = $RoomTypeModel->getAllRoomTypes();

            echo json_encode([
                "status" => "success",
                "data" => $data
            ]);
        }

        // GET ROOM TYPE BY ID
        if(isset($_GET["action"]) && $_GET["action"] == "GetRoomTypeById"){

            $id = $_GET["id"];

            $data = $RoomTypeModel->getRoomTypeById($id);

            echo json_encode([
                "status" => "success",
                "data" => $data
            ]);
        }

        // DELETE ROOM TYPE
        if(isset($_GET["action"]) && $_GET["action"] == "DeleteRoomType"){

            $id = $_GET["id"];

            $result = $RoomTypeModel->deleteRoomType($id);

            if($result){

                echo json_encode([
                    "status" => "success",
                    "message" => "Room Type Deleted Successfully"
                ]);

            }else{

                echo json_encode([
                    "status" => "fail",
                    "message" => "Failed to Delete Room Type"
                ]);
            }
        }
    }

?>