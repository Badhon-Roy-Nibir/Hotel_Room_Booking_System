<?php
session_start();
include_once("../DB/DBConnect.php");

class AdminModel{
    private $conn = null;

    public function __construct()
    {
        $db_obj = new DBConnect();
        $this->conn = $db_obj->connect();
    }

    public function LoginAdmin(string $email, string $password){

        // STEP 1: get user by email only
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $this->conn->query($sql);

        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                if($row["password_hash"] === $password){
                    return true;
                }  
            }

        }

        return false;
    }
}

?>