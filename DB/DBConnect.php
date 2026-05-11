<?php
    class DBConnect{
        private $db_host = "Localhost";
        private $db_username = 'root';
        private $db_password = '';
        private $db_name = "Hotel_Room_Booking_System";
        

        public function connect(){
           return new mysqli($this->db_host,$this->db_username, $this->db_password, $this->db_name);

        }
    }
    
?>