<?php
declare(strict_types=1);
?>

<?php
class Database
{
    private string $host = "localhost";
    private string $dbname = "studentsdb";
    private string $username = "root";
    private string $password = "";
    protected mixed $pdo;

    public function __construct(){
        $this->connect();
    }

    private function connect(){
        try {
            $dsn = "mysql:host=$this->host;dbname=$this->dbname;charset=utf8mb4";
            $this->pdo = new PDO($dsn, $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->pdo = null;
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getDBConnection(): PDO {
        return $this->pdo;
    }
}
?>
