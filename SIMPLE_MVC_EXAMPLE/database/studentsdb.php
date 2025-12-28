<?php
    // $db_host = "localhost";
    // $db_user = "root";
    // $db_password = "";
    // 

    // $conn = mysqli_connect($db_host, $db_user, $db_password, $database);

    // if(!$conn) die("Connection Failed  " . mysqli_connect_error());

    class StudentsDb{
        private string $db_host = "localhost";
        private string $db_user = "root";
        private string $db_password = "";
        private string $database = "students";
        public $conn = null;

        public function __construct()
        {
            $this->conn = mysqli_connect($this->db_host, 
                                $this->db_user, 
                                $this->db_password, 
                                $this->database);
            if(!$this->conn) die("Connection Failed  " . mysqli_connect_error());
        }
        
        public function closeConn(){
             mysqli_close($this->conn);
        }
        
    }
?>
