<?php
    declare(strict_types=1);
    include('./database/studentsdb.php');
?>

<?php
    class User extends StudentsDb{

        public function getUser(int $id){
            $user = null;
            $sql = "SELECT * FROM users Where id = ?";

            //create a prepend stmt
            $stmt = mysqli_stmt_init($this->conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                die("preprend statement failed");
            } 

            //bind parameters to place holder
            mysqli_stmt_bind_param($stmt, "i", $id);

            // //assign values to bind parameters
            // $id = 2;

            // execute stmt
            if (!mysqli_stmt_execute($stmt)) {
            die("failed to execute");
            } 
        
            $result = mysqli_stmt_get_result($stmt);
            // print_r($result); 
            // echo "<br/>";

            $num_row = mysqli_num_rows($result);
            if($num_row > 0){
                $user = mysqli_fetch_assoc($result);
                // echo $user["id"] . "<br/>";
                // echo $user["firstname"] . "<br/>";
                // echo $user["lastname"] . "<br/>";
                // echo $user["gpa"] . "<br/>";
            }
            $this->closeConn();
            return $user;
        }
    }
    //...........................................

    // $user = new User;
    // echo $user->getUser(2)['firstname'];
?>


