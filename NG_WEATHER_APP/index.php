<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="Author" content="Ernest Kekeke">
    <meta name="desciption" content="Technology at the best">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nigeria Weather by Ernest Kekeke</title>
    <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <button class="theme-toggle" onclick="toggleTheme()">
        <span id="theme-icon">🌙</span>
        <span id="theme-text">Dark Mode</span>
    </button>

    <p>Application Authored by Ernest Kekeke</p> 
    <h2>Nigeria Cities and Town Weather App</h2>

    <div>
        <form action="./controllers/user_controller.php" method="GET">
            <span>Add, Update and Delete a CITY or TOWN </span>
            <input name="city" placeholder="new City or Town" pattern="[a-zA-Z]{1,20}[a-zA-Z _]{1,20}[a-zA-Z]{1,20}" title="use words" required />
            <input name="lat" placeholder="Latitude" pattern="([1-9][0-9]?).[0-9]{4}"
                title="Must be a number with (4) decimal point" required />
            <input name="lon" placeholder="Longitude" pattern="([1-9][0-9]?).[0-9]{4}"
                title="Must be a number with (4) decimal point" required />

            <button type="submit" name="save" value="save">Save</button>
            <button type="submit" name="update" value="update">Update</button>
            <button type="submit" name="delete" value="delete">Delete</button>
        </form>
    </div>


    <div class="card weather-info">
        <p>Online Weather Information</p>
        <p>City/Town: <b id="ct"><?php echo isset($_GET['ct']) ? $_GET['ct'] : "nill"; ?> </b> </p>
        <p>Latitude: <b id="lat"><?php echo isset($_GET['lat']) ? $_GET['lat'] : "nill"; ?> </b> </p>
        <p>Longitude: <b id="lon"><?php echo isset($_GET['lon']) ? $_GET['lon'] : "nill"; ?> </b> </p>
        <p>Temperature: <b id="T"><?php echo isset($_GET['T']) ? $_GET['T'] : "nill"; ?> </b> </p>
        <p>Wind Speed: <b id="ws"><?php echo isset($_GET['ws']) ? $_GET['ws'] : "nill"; ?> </b> </p>
        <p>Wind Direction: <b id="wd"><?php echo isset($_GET['wd']) ? $_GET['wd'] : "nill"; ?> </b> </p>
        <p>Description: <b id="ds"><?php echo isset($_GET['ds']) ? $_GET['ds'] : "nill"; ?> </b> </p>
        <p>@ date: <b id="d"><?php echo isset($_GET['d']) ? $_GET['d'] : "nill"; ?> </b> </p>
        <p>@ time: <b id ="t"><?php echo isset($_GET['t']) ? $_GET['t'] : "nill"; ?> </b> </p>
    </div>

    <?php
    if (isset($_GET['err'])) {
        $err = $_GET['err'];
        msg($msg, 'red');
    }

    if (isset($_GET['del'])) {
        $msg = $_GET['del'];
        msg($msg, 'black');
    }
    if (isset($_GET['nc'])) {
        $msg = $_GET['nc'];
        msg($msg, 'green');
    }

    if (isset($_GET['uc'])) {
        $uc = (int)$_GET['uc'];
        $city = $_GET['city'];

        if ($uc == 1) {
            $msg = "City or Town: " . $city . " Updated successfully";
            msg($msg, "green");
        } elseif ($uc == 0) {
            $msg = "{$city} latitude and longitude Remains unchanged!";
            msg($msg, "darkgoldenrod");
        } else {
            $msg = "Failed to update City or Town.";
            msg($msg, "red");
        }
    }

    function msg(string $msg, string $color) {
        echo "<script> alert('$msg'); </script>";
        echo "<p id = 'p_msg' style='color:{$color}'>{$msg}</p>";
    }
    ?>


    <div>
        <span>Search CITY or TOWN 
            <input id="search_city" type="text" pattern="[a-zA-Z]{1,20}[a-zA-Z _]{1,20}[a-zA-Z]{1,20}" title="use words" required/>
            <button id="search_btn" value="search">Search</button> 
        </span> 
        <span>
            Auto update, please enter secs 
            <input id="upd_sec" type="number" value="5" step="1" min="3" max="600"/>
            <button id="auto_btn" value="stop">START</button>
        </span>
    </div>

    <script>
        // Theme toggle functionality
        function toggleTheme() {
            const html = document.documentElement;
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            html.setAttribute('data-theme', newTheme);
            
            const themeIcon = document.getElementById('theme-icon');
            const themeText = document.getElementById('theme-text');
            
            if (newTheme === 'dark') {
                themeIcon.textContent = '☀️';
                themeText.textContent = 'Light Mode';
            } else {
                themeIcon.textContent = '🌙';
                themeText.textContent = 'Dark Mode';
            }
        }

        // Load saved theme on page load
        window.addEventListener('DOMContentLoaded', () => {
            const savedTheme = 'light';
            document.documentElement.setAttribute('data-theme', savedTheme);
        });
    </script>
    <script src="script.js"></script>
</body>

</html>