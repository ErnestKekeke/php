<?php
declare(strict_types=1);
require_once("../models/api_curlsession.php");
require_once("./api_controller.php");
?>

<?php
//...............................................
if (isset($_GET['save'])) {
    $newCity = $_GET['city'];
    $newLat = (float)$_GET['lat'];
    $newLon = (float)$_GET['lon'];

    try {
        if (NigeriaWeatherAPI::addCity($newCity, $newLat, $newLon) == 1){
            header("location: ../index.php?nc={$newCity} added Succeffully !");
            exit();
        }else{
            header("location: ../index.php?err= Already Save or Unable to add {$newCity}!!!");
            exit();
        }
    
    } catch (Exception $e) {
        // echo 'ERROR: ' . $e->getMessage();
        $err = $e->getMessage();
        header("location: ../index.php?err={$err}");
        exit();
    }
}

//.................................................
if (isset($_GET['update'])) {
    $city = $_GET['city'];
    $newLat = (float)$_GET['lat'];
    $newLon = (float)$_GET['lon'];

    try {
        $uc = NigeriaWeatherAPI::updateCity($city, $newLat, $newLon);
        header("location: ../index.php?uc={$uc}&city={$city}");
        exit();
    
    } catch (Exception $e) {
        // echo 'ERROR: ' . $e->getMessage();
        $err = $e->getMessage();
        header("location: ../index.php?err={$err}");
        exit();
    }
}


//.................................................
if (isset($_GET['delete'])) {
    $city = $_GET['city'];
    try {
        header("location: ../index.php?del= Contact Administrator for this operation");
        exit(); 
    } catch (Exception $e) {
        // echo 'ERROR: ' . $e->getMessage();
        $err = $e->getMessage();
        header("location: ../index.php?err={$err}");
        exit();
    }
}

//.................................................
// if (isset($_GET['btnSearch'])) {
//     $city = $_GET['city'];
//     try {
//         $weatherData = cityWeather($city, 3);
//         if(empty($weatherData)) {
//             $city = ucwords(trim(strtolower($city)));
//             header("location: ../index.php?err={$city} Record NOT FOUND!");
//             exit();
//         }
//         $ct = $weatherData->city;
//         $lat = $weatherData->latitude;
//         $lon = $weatherData->longitude;
//         $d = $weatherData->date;
//         $t = $weatherData->time;
//         $T = $weatherData->temperature;
//         $ws = $weatherData->windSpeed;
//         $wd = $weatherData->windDirection;
//         $ds = $weatherData->description;
//         header("location: ../index.php?ct={$ct}&lat={$lat}&lon={$lon}&d={$d}&t={$t}&T={$T}&ws={$ws}&wd={$wd}&ds={$ds}");
//         exit();
//     } catch (Exception $e) {
//         // echo 'ERROR: ' . $e->getMessage();
//         $err = $e->getMessage();
//         header("location: ../index.php?err={$err}");
//         exit();
//     }
// }


//...................................................
//...................................................
header("location: ../index.php?err=Unknown or Url Error"); 
exit();
?>