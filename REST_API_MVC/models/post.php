<?php
declare(strict_types=1);
// require_once("../config/database.php");
?>

<?php
class Post extends Database
{
    // READ USERS
    public function users(): array
    {
        try {
            $sql = "SELECT * FROM users ";
            $stmt = $this->pdo->query($sql);
            $users = $stmt->fetchAll();
            if($users){
                // print_r($users);
                return $users;
            }else{
                // echo $id . "User NOT Found !";
                return []; // empty array
            }

        } catch (PDOException $e) {
            die("Failed MYSQL: " . $e->getMessage());
        }
    }

    // READ USER
    public function user(int $id): array
    {
        try {
            $sql = "SELECT * FROM users WHERE id = $id";
            $stmt = $this->pdo->query($sql);
            $user = $stmt->fetch();
            if($user){
                // print_r($user);
                // echo $id . " User Found !";
                return $user;
            }else{
                // echo $id . "User NOT Found !";
                return []; // empty array
            }
            
        } catch (PDOException $e) {
            die("Failed MYSQL: " . $e->getMessage());
        }
    }

    // CREATE NEW USER 
    public function newUser(
        string $name,
        int $age,
        string $subj_one,
        string $subj_two,
        string $message
    ): int {
        try {
            $sql = "INSERT INTO users(name, age, subj_one, subj_two, message) 
                            VALUES(:name, :age, :subj_one, :subj_two, :message)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':age', $age);
            $stmt->bindParam(':subj_one', $subj_one);
            $stmt->bindParam(':subj_two', $subj_two);
            $stmt->bindParam(':message', $message);

            if ($stmt->execute()) {
            // echo "User added successfully! ID: " . $this->pdo->lastInsertId();
            return (int)$this->pdo->lastInsertId();
            } else {
            // echo "Failed to create user.";
            return (int)-1;
            }
 
        } catch (PDOException $e) {
            $this->pdo = null;
            die("Insert Failed: " . $e->getMessage());
        }
    }


    // UPADATE A USER 
    public function updateUser(
        int $id,
        string $name,
        int $age,
        string $subj_one,
        string $subj_two,
        string $message
    ):int{
        try {

            $sql = "UPDATE users SET name = :name, age = :age, subj_one = :subj_one, 
            subj_two = :subj_two, message = :message WHERE id = :id";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':age', $age, PDO::PARAM_INT);
            $stmt->bindParam(':subj_one', $subj_one);
            $stmt->bindParam(':subj_two', $subj_two);
            $stmt->bindParam(':message', $message, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if ($stmt->execute()){
                if ($stmt->rowCount() > 0) {
                    // echo "id: " . $id . " Updated successfully <br/>";
                    return (int)$id;
                } else {
                    // echo "No changes made. (Maybe the data is the same, or user not found.)";
                    return 0;
                }
            }else{
                // echo "Failed to update user.";
                return -1;
            }



        } catch (PDOException $e) {
            $this->pdo = null;
            die($id . "Updaed Failed: " . $e->getMessage());
        }
    }

    // DELETE A USER
    public function deleteUser(int $id): int{
        try {
            $sql = "DELETE FROM users WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);

            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount()) {
                // echo "id: " . $id . " deleted successfully <br/>";
                return $id;
            } else {
                // echo "No user found with the given ID.";
                return 0;
            }
          
        } catch (PDOException $e) {
            die("Failed MYSQL: " . $e->getMessage());
        }
    }
}


$post01 = new Post();

// $users = $post01->users();
// print_r($users);

// $user = $post01->user(1);
// print_r($user);
// echo $user['name'];

// echo $post01->newUser("James", 21, "Bio", "Chem", "no message yet");

// echo $post01->updateUser(6, "Annn", 12, "Bio", "Chem", "no message yet");

// echo $post01->deleteUser(11);
