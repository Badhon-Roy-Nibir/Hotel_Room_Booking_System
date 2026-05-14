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

    $sql = "
        SELECT password_hash
        FROM users
        WHERE email = ?
        AND role = ?
        LIMIT 1
    ";

    $stmt = $this->conn->prepare($sql);

    $role = "admin";

    $stmt->bind_param("ss", $email, $role);

    $stmt->execute();

    $result = $stmt->get_result();

    if($result->num_rows > 0){

        $row = $result->fetch_assoc();

        if($row["password_hash"] === $password){
            return true;
        }
    }

    return false;
}
}

?>