<?php
    function getDirection(float|int $bearing): string{
        $windDir = null;
        $bearing = round($bearing, 1);

        if($bearing == 0){
            $windDir = 'NORTH';
        }
        elseif($bearing > 0 && $bearing <= 45){
            $windDir = 'N' . $bearing . 'E';
        }
        elseif($bearing > 45 && $bearing <90){
            $bearing = 90 - $bearing;
            $windDir = 'E' . $bearing . 'N';
        }
        elseif($bearing == 90){
            $windDir = 'EAST';
        }
        elseif($bearing > 90 && $bearing < 135){
            $bearing = $bearing - 90;
            $windDir = 'E' . $bearing . 'S';
        }
        elseif($bearing >= 135 && $bearing < 180){
            $bearing = 180 - $bearing;
            $windDir = 'S' . $bearing . 'E';
        }

        elseif($bearing == 180){
            $windDir = 'SOUTH';
        }
        elseif($bearing > 180 && $bearing <= 225){
            $bearing = $bearing - 180;
            $windDir = 'S' . $bearing . 'W';
        }
        elseif($bearing > 225 && $bearing < 270){
            $bearing = 270 - $bearing;
            $windDir = 'W' . $bearing . 'S';
        }
        elseif($bearing == 270){
            $windDir = 'WEST';
        }
        elseif($bearing > 270 && $bearing < 315){
            $bearing = $bearing - 270;
            $windDir = 'W' . $bearing . 'N';
        }
        elseif($bearing >= 315 && $bearing < 360){
            $bearing = 360 - $bearing;
            $windDir = 'N' . $bearing . 'W';
        }
        return $windDir;
    }

    echo getDirection(238) . "<br/>";


    // echo getDirection(0) . "<br/>";



?>