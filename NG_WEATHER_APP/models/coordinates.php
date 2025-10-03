<?php
declare(strict_types=1);
// require_once("../config/database.php");
?>

<?php
class Coordinates extends Database
{
    // Read A CITY or TOWN
    public function allCities(): array
    {
        try {
            $sql = "SELECT city FROM geo_coords";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $cities = [];

            while($city = $stmt->fetch()){
                // echo $city['city'] . "<br/>";
                array_push($cities, $city['city']);
            }
            if($cities){
                return $cities;
            }else{
                return []; // empty array
            }
            
        } catch (PDOException $e) {
            die("Failed MYSQL: " . $e->getMessage());
        }
    }

    // Read A CITY or TOWN Coordinates 
    public function getCoords(string $city): array
    {
        try {
            $sql = "SELECT * FROM geo_coords WHERE city = :city";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':city', $city, PDO::PARAM_STR);
            $stmt->execute();
            $coord = $stmt->fetch();
            if($coord){
                // print_r($coord);
                // echo $city . " City or Town Found!";
                return $coord;
            }else{
                // echo $city . "City or Town NOT-Found!";
                return []; // empty array
            }
            
        } catch (PDOException $e) {
            die("Failed MYSQL: " . $e->getMessage());
        }
    }

    // Add a new CITY or TOWN Coordinates  
    public function newCoords(
        string $city,
        float $lat,
        float $lon
    ): int {
        try {
            $sql = "INSERT INTO geo_coords(city, lat, lon) 
                            VALUES(:city, :lat, :lon)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':city', $city, PDO::PARAM_STR);
            $stmt->bindParam(':lat', $lat, PDO::PARAM_STR);
            $stmt->bindParam(':lon', $lon, PDO::PARAM_STR);

            if ($stmt->execute()) {
            // echo $city . " added successfully!";
            return 1;
            } else {
            // echo "Failed to Add new City or Town.";
            return -1;
            }
 
        } catch (PDOException $e) {
            $this->pdo = null;
            // die("Insert Failed: " . $e->getMessage());
            return -1;
        }
    }

    // Update CITY or TOWN Coordinates  
    public function updateCoords(
        string $city,
        float $lat,
        float $lon
    ):int{
        try {
            $sql = "UPDATE geo_coords SET lat = :lat, lon = :lon WHERE city = :city";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':city', $city, PDO::PARAM_STR);
            $stmt->bindParam(':lat', $lat, PDO::PARAM_STR);
            $stmt->bindParam(':lon', $lon, PDO::PARAM_STR);

            if ($stmt->execute()){
                if ($stmt->rowCount() > 0) {
                    // echo "City or Town: " . $city . " Updated successfully";
                    return 1;
                } else {
                    // echo "{$city} latitude and longitude Remains unchanged!";
                    return 0;
                }
            }else{
                // echo "Failed to update City or Town.";
                return -1;
            }
      
        } catch (PDOException $e) {
            $this->pdo = null;
            die($city . "Update Failed: " . $e->getMessage());
        }
    }

    // Delete a CITY or TOWN  
    public function deleteCoords(string $city): int{
        try {
            $sql = "DELETE FROM geo_coords WHERE city = :city";
            $stmt = $this->pdo->prepare($sql);

            $stmt->bindParam(':city', $city, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount()) {
                // echo "City or Town: " . $city . " deleted successfully";
                return 1;
            } else {
                // echo "No user found with the given city or town named: " . $city;
                return 0;
            }
          
        } catch (PDOException $e) {
            die("Failed MYSQL: " . $e->getMessage());
        }
    }
}


// $coordinates = new Coordinates;
// $cities = $coordinates->allCities();
// print_r($cities);
// echo count($cities);

// $coord = $coordinates->getCoords('port harcourt');
// print_r($coord); echo "<br/>";
// echo empty($coord);
// echo $coord['city'] . ", lat: " . $coord['lat'] . ", lon:" . $coord['lon'] . "<br/><br/>";

// echo $coordinates->newCoords('calabar', 4.9517, 8.3417);
// echo $coordinates->updateCoords('calabar', 4.9517, 8.3417);


// echo $coordinates->deleteCoords('calabar');
