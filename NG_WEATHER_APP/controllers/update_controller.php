<?php
declare(strict_types=1);
// require_once("../config/database.php");
require_once("../models/api_curlsession.php");
require_once("./api_controller.php");
?>

<?php
//...............................................

    if(isset($_POST['city'])){
        
    $city = $_POST['city'];

    try {
        $weatherData = cityWeather((string)$city, 3); 
        if(empty($weatherData)) {
            die();
        }
        $ct = $weatherData->city;
        $lat = $weatherData->latitude;
        $lon = $weatherData->longitude;
        $d = $weatherData->date;
        $t = $weatherData->time;
        $T = $weatherData->temperature;
        $ws = $weatherData->windSpeed;
        $wd = $weatherData->windDirection;
        $ds = $weatherData->description;

        echo $ct . ",";    
        echo $lat . ",";  
        echo $lon . ",";              
        echo $d . ",";
        echo $t . ",";
        echo $T . ",";
        echo $ws . ",";
        echo $wd . ",";
        echo $ds;
        die();
    } catch (Exception $e) {
        echo 'ERROR: ' . $e->getMessage();
        die();
    }
  }
?>