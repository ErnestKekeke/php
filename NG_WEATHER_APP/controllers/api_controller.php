<?php 
    declare(strict_types=1);
    require_once("../config/database.php");
    require_once("../models/coordinates.php");
    require_once("../models/api_curlsession.php");
?>

<?php 
    // echo (new CurlSession)->setUrl('https://api.open-meteo.com/v1/forecast?latitude=6.5244&longitude=3.3792&current_weather=true&temperature_unit=celsius')
    // ->requestMethod('GET')->execute()['data'];


    // $curlSessionJsonString = (new CurlSession)->setUrl('https://api.open-meteo.com/v1/forecast?latitude=6.5244&longitude=3.3792&current_weather=true&temperature_unit=celsius')
    // ->requestMethod('GET')->execute()['data'];
    // $data = json_decode($curlSessionJsonString);
    // echo $data->current_weather->time;

class NigeriaWeatherAPI extends Coordinates{
    private string $apiProvider;
    private mixed $apiKey; 
    private string $baseUrl;
    private $coordinates;

    // // Major Nigerian cities with coordinates
    // public static $cities = [
    //     'lagos' => ['lat' => 6.5244, 'lon' => 3.3792],
    //     'abuja' => ['lat' => 9.0765, 'lon' => 7.3986],
    //     'kano' => ['lat' => 12.0022, 'lon' => 8.5919],
    //     'port harcourt' => ['lat' => 4.8156, 'lon' => 7.0498],
    //     'ibadan' => ['lat' => 7.3775, 'lon' => 3.9470],
    //     'kaduna' => ['lat' => 10.5105, 'lon' => 7.4165],
    //     'benin city' => ['lat' => 6.3350, 'lon' => 5.6037],
    //     'warri' => ['lat' => 5.5494, 'lon' => 5.7666],
    //     'enugu' => ['lat' => 6.5244, 'lon' => 7.5105],
    //     'jos' => ['lat' => 9.8965, 'lon' => 8.8583],
    //     'calabar' => ['lat' => 4.9517, 'lon' => 8.3417]
    // ];
   
    public function __construct($apiProvider = 'open-meteo', $apiKey = null)
    {
        $this->apiProvider = $apiProvider;
        $this->apiKey = $apiKey;
        $this->coordinates = new Coordinates();
        switch($this->apiProvider){
            // case 'open-meteo': $baseUrl = 'https://api.open-meteo.com/v1/forecast';
            //     break;
            case 'openweathermap': $this->baseUrl = 'https://api.openweathermap.org/data/2.5/weather';
                break;
            case 'weatherapi': $this->baseUrl = 'http://api.weatherapi.com/v1/current.json';
                break;
            default: $this->baseUrl = 'https://api.open-meteo.com/v1/forecast';
                $this->apiProvider = 'open-meteo';
                $this->apiKey = null;
                break;
        }
    }

    public static function addCity(string $city, float $lat, float $lon): int{
        // Latitude must be between -90 and 90 degrees.
        // Longitude must be between -180 and 180 degrees.
        // Nigeria Geographic Bounds:
        //     Latitude: 4.2 to 13.9
        //     Longitude: Range: 2.7 to 14.7
            $city = strtolower(trim($city, " \n\t\r\!\."));

            if(isset($city) && isset($lat) && isset($lon)){
                if(strlen($city) >= 3 && strlen($city) <= 20 && 
                                $lat >= 4.2 && $lat <= 13.9 && 
                                $lon >= 2.7 && $lon <= 14.7){

                    return (new Coordinates)->newCoords($city, $lat, $lon);
                } 
            }
            return 0;   
    }

    public static function updateCity(string $city, float $lat, float $lon): int{

            $city = strtolower(trim($city, " \n\t\r\!\."));

            if(isset($city) && isset($lat) && isset($lon)){
                if(strlen($city) >= 3 && strlen($city) <= 20 && 
                                $lat >= 4.2 && $lat <= 13.9 && 
                                $lon >= 2.7 && $lon <= 14.7){
                    return (new Coordinates)->updateCoords($city, $lat, $lon);
                } 
            }
            return 0;   
    }


    public function cities(): array{
        return $this->coordinates->allCities();
    }

    public function getUrlByCity(string $city): string{
        $lat = 6.5244;
        $lon = 3.3792;
        // $coordinates = new Coordinates();
        $coord = $this->coordinates->getCoords($city);
        if(!empty($coord)){
            $lat = $coord['lat'];
            $lon = $coord['lon'];
        }

        return $this->getUrlByCoordinate((float)$lat, (float)$lon);
    }

    public function getUrlByCoordinate(float $lat, float $lon): string{
        $apiUrl = null;
        if($this->apiProvider == "openweathermap"){     
            $apiUrl = $this->baseUrl . "?lat={$lat}&lon={$lon}&appid={$this->apiKey}&units=metric";
        }elseif($this->apiProvider == "weatherapi"){
            $apiUrl = $this->baseUrl . "?key={$this->apiKey}&q={$lat},{$lon}";
        }else{
            $apiUrl = $this->baseUrl . "?latitude={$lat}&longitude={$lon}&current_weather=true&temperature_unit=celsius";
        }
        return $apiUrl;
    }

    public static function getWeatherDescription($code): string{
        $codes = [
            0 => 'Clear sky',
            1 => 'Mainly clear',
            2 => 'Partly cloudy',
            3 => 'Overcast',
            45 => 'Foggy',
            48 => 'Depositing rime fog',
            51 => 'Light drizzle',
            61 => 'Slight rain',
            63 => 'Moderate rain',
            65 => 'Heavy rain',
            80 => 'Slight rain showers',
            95 => 'Thunderstorm'
        ];      
        return $codes[$code] ?? 'Unknown';
    }

    public static function getDirection(float|int $bearing): string{
        $windDir = null;
        $bearing = round($bearing, 1);

        if($bearing == 0){
            $windDir = 'NORTH';
        }
        elseif($bearing > 0 && $bearing <= 45){
            $windDir = 'N ' . $bearing . '° E';
        }
        elseif($bearing > 45 && $bearing <90){
            $bearing = 90 - $bearing;
            $windDir = 'E ' . $bearing . '° N';
        }
        elseif($bearing == 90){
            $windDir = 'EAST';
        }
        elseif($bearing > 90 && $bearing < 135){
            $bearing = $bearing - 90;
            $windDir = 'E ' . $bearing . '° S';
        }
        elseif($bearing >= 135 && $bearing < 180){
            $bearing = 180 - $bearing;
            $windDir = 'S ' . $bearing . '° E';
        }

        elseif($bearing == 180){
            $windDir = 'SOUTH';
        }
        elseif($bearing > 180 && $bearing <= 225){
            $bearing = $bearing - 180;
            $windDir = 'S ' . $bearing . '° W';
        }
        elseif($bearing > 225 && $bearing < 270){
            $bearing = 270 - $bearing;
            $windDir = 'W ' . $bearing . '° S';
        }
        elseif($bearing == 270){
            $windDir = 'WEST';
        }
        elseif($bearing > 270 && $bearing < 315){
            $bearing = $bearing - 270;
            $windDir = 'W ' . $bearing . '° N';
        }
        elseif($bearing >= 315 && $bearing < 360){
            $bearing = 360 - $bearing;
            $windDir = 'N ' . $bearing . '° W';
        }
        return $windDir;
    }

    public static function convertDateTime(string $dateTime, int $dtFormat = 1, int $gmt = 1): array{

        $MONTH = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        $dateTimeArr = explode("T", $dateTime);
        $ymd = explode("-", $dateTimeArr[0]);
        $year = $ymd[0];
        $month = $ymd[1];
        $day = $ymd[2];
        $hm = explode(":", $dateTimeArr[1]);
        $hrs = (float)$hm[0] + $gmt;
        $hrs = !($hrs >= 24)? $hrs : $hrs - 24; 
        $mins = (float)$hm[1];
        // echo $mins;

        switch($dtFormat){
            case 1: {
                //........................
                $month = ($month < 10)? "0".(string)(int)$month : (string)(int)$month;
                $day = ($day < 10)? "0".(string)(int)$day : (string)(int)$day;
                $date = $year . "-" . $month . "-" . $day;

                //.........................
                $hrs = ($hrs < 10)? "0".(string)$hrs : (string)$hrs;
                $mins = ($mins < 10)? "0".(string)$mins: (string)$mins; 
                $time  = $hrs . ":" . $mins;
                break;
            }

                case 2: {
                //..................... Abrrev    
                $month = $MONTH[(int)$month-1];
                $day = ($day < 10)? "0".(string)(int)$day : (string)(int)$day;
                $date = $day. " " . $month . " " . $year;

                //...........................
                $hrs = ($hrs < 10)? "0".(string)$hrs : (string)$hrs;
                $mins = ($mins < 10)? "0".(string)$mins: (string)$mins; 
                $time  = $hrs . ":" . $mins;
                break;
            }

            case 3: {
                //..................... Abrrev
                $month = $MONTH[(int)$month-1];
                $day = ($day < 10)? "0".(string)(int)$day : (string)(int)$day;
                $date = $day. " " . $month . " " . $year;

                //.........................AM PM
                $ampm = null;  
                if($hrs == 0) {
                    $hrs = 12;
                    $ampm = "AM";
                }elseif($hrs < 12) {
                    $hrs = $hrs;
                    $ampm = "AM";
                }
                elseif($hrs == 12){
                    $ampm = "PM";
                }elseif($hrs > 12){
                     $hrs = $hrs - 12;
                    $ampm = "PM";
                }
                $mins = ($mins < 10)? "0".(string)$mins: (string)$mins; 
                $time  = $hrs . ":" . $mins . $ampm;
                break;
            }

            case 4: {
                //..............................
                $month = ($month < 10)? "0".(string)(int)$month : (string)(int)$month;
                $day = ($day < 10)? "0".(string)(int)$day : (string)(int)$day;
                $date = $year . "-" . $month . "-" . $day;

                //.........................AM PM
                $ampm = null;
                if($hrs == 0) {
                    $hrs = 12;
                    $ampm = "AM";
                }elseif($hrs < 12) {
                    $hrs = $hrs;
                    $ampm = "AM";
                }
                elseif($hrs == 12){
                    $ampm = "PM";
                }elseif($hrs > 12){
                     $hrs = $hrs - 12;
                    $ampm = "PM";
                }
                $mins = ($mins < 10)? "0".(string)$mins: (string)$mins; 
                $time  = $hrs . ":" . $mins . $ampm;
                break;
            }
            default: {
                //.......................
                $date = $year . "-" . $month . "-" . $day; 

                //.........................
                $time  = $hrs . ":" . $mins;
                break;
            }
        }
        // echo $date . "<br/>";
        // echo $time . "<br/>";
        return [$date, $time];
    }
}
//............................  END NigeriaWeatherAPI .........................
//............................................................................


// Seperate Function for City Weather
function cityWeather(string $city, int $dtF): mixed{
    $city = strtolower(trim($city, " \n\t\r\!\."));

    $coordinates = new Coordinates();
    $coord = $coordinates->getCoords($city);

    if(empty($coord)){
        // echo $city . " Not added yet";
        return null;
    }
    $apiUrl =  (new NigeriaWeatherAPI)->getUrlByCity($city); // get api url
    $apiString = (new ApiCurlSession)->setUrl($apiUrl)->requestMethod('GET')->execute()['data'];

    // echo $apiString;
    $apiData = json_decode($apiString);
    // print_r($apiData); echo "<br/><br/>";

    $info = new stdClass();
    $info->city = ucwords(strtolower($coord['city']));
    $info->latitude = round((float)$coord['lat'], 2) . "°";
    $info->longitude = round((float)$coord['lon'], 2) . "°";
        $dateTime = NigeriaWeatherAPI::convertDateTime($apiData->current_weather->time, $dtF);  
    $info->date = $dateTime[0];
    $info->time = $dateTime[1];
    $info->temperature = $apiData->current_weather->temperature . "°C";
    $info->windSpeed = $apiData->current_weather->windspeed . "km/h";
    $info->windDirection = NigeriaWeatherAPI::getDirection(
                (float)$apiData->current_weather->winddirection);
    $info->description = NigeriaWeatherAPI::getWeatherDescription(
                    (int) $apiData->current_weather->weathercode);          
    // echo $info->city . "<br/>";    
    // echo $info->latitude . "<br/>";  
    // echo $info->longitude . "<br/>";              
    // echo $info->date . "<br/>";
    // echo $info->time . "<br/>";
    // echo $info->temperature . "°C" . "<br/>";
    // echo $info->windSpeed . "km/h". "<br/>";
    // echo $info->windDirection . "<br/>";
    // echo $info->description . "<br/>";
    return $info;
}

//............................  end cityWeather  .........................
//............................................................................

    // echo NigeriaWeatherAPI::addCity("Sapele", 5.8751, 5.6931);
    // echo NigeriaWeatherAPI::updateCity("Sapele", 5.8751, 5.6931);

    // print_r($weatherData = cityWeather('port harcourt', 3));

?>