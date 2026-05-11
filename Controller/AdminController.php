<?php
    session_start();
    include_once("../Model/AdminModel.php");

    if($_SERVER["REQUEST_METHOD"]==="POST"){
        if(isset($_POST["action"]) && $_POST["action"]== "Login"){
            $email = $_POST["email"];
            $password = $_POST["password"];

            $AdminModel = new AdminModel();
            $result = $AdminModel->LoginAdmin($email, $password);

            if($result == true){

                $_SESSION["email"] = $email; 

                echo json_encode(array("status" => "success"));

            }else{

                echo json_encode(array("status" => "fail"));
            }


        }


    }


?>