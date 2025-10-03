# NG WEATHER APP (OOP PHP + MySQL + API)

Author:
The Author of this project is Ernest Kekeke.
more about the author visit: https://www.youtube.com/@ernestKekeke
github: https://github.com/ErnestKekeke/


🇳🇬 Nigeria Weather Web Application
A lightweight weather application for Nigerian cities and towns built with PHP MVC architecture, featuring real-time weather updates from Open-Meteo API.
📋 Features

CRUD Operations: Add, update, delete cities/towns with coordinates
Real-time Weather: Live weather data using Open-Meteo free API
Auto-Update: Configurable automatic weather refresh (3-600 seconds)
Theme Support: Light and dark mode with Nigerian-inspired design
Responsive Design: Mobile-friendly interface

🛠️ Technology Stack

Backend: PHP (OOP, MVC Pattern)
Database: MySQL
Frontend: HTML5, CSS3, JavaScript
AJAX: XMLHttpRequest for async updates
API: Open-Meteo (free, no API key required)
Server: XAMPP (Apache + MySQL)

📁 Project Structure
        nigeria-weather-app/
        ├── index.php
        ├── style.css
        ├── script.js
        ├── controllers/
        │   └── api_controller.php
        |   └── auto_update_controllerr.php
        |   └── update_controller.php
        |   └── user_controller.php
        ├── models/
        │   └── api_curlsession.php
        |   └── coordinates.php
        ├── config/
        │   └── database.php
        └── images/
            └── favicon.ico

🚀 Installation
Prerequisites

XAMPP installed (Download here)
Web browser (Chrome, Firefox, Edge)

Setup Steps

    1.  Clone the Repository:
                git clone https://github.com/ErnestKekeke/php.git
                cd php/ng_weather_app

    2.   Start XAMPP:
                Open XAMPP Control Panel
                Start Apache and MySQL

    3.  Create Database:
                Go to http://localhost/phpmyadmin
                Create new database: weatherdb
                Run this SQL:
                        CREATE TABLE geo_coords (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        city VARCHAR(100) NOT NULL UNIQUE,
                        lat DECIMAL(6, 4) NOT NULL,
                        lon DECIMAL(6, 4) NOT NULL,
                        upd_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                        );

                        -- Sample data
                        INSERT INTO geo_coords (city, lat, lon) VALUES
                        ('Lagos', 6.5244, 3.3792),
                        ('Abuja', 9.0765, 7.3986),
                        ('Ibadan', 7.3775, 3.9470),
                        ('Kano', 12.0022, 8.5920),
                        ('Port Harcourt', 4.8156, 7.0498);

    4.  Configure Database (config/database.php):

    5. Access Application:
            http://localhost/
                or
            try: http://localhost/ng_weather_app/

💻 Usage
Add City/Town

Enter city name, latitude, and longitude
Click SAVE button
System validates and saves to database

Search Weather

Type city name in search field
Click SEARCH button (floating animation)
Weather data displays via AJAX

Auto-Update

Set refresh interval (3-600 seconds)
Click START button
Weather updates automatically

Theme Toggle

Click theme button (top-right)
Switches between light/dark mode

🌐 API Information
Provider: Open-Meteo

Free: No API key required
No rate limits for personal use
Endpoint: https://api.open-meteo.com/v1/forecast

🗂️ MVC Architecture
Model (models/City.php)

Database operations (CRUD)
City data validation
Connection management

View (index.php)

User interface
Form inputs
Weather display

Controller (controllers/user_controller.php)

Request handling
Business logic
API calls coordination

🎨 Design Features

Nigerian Theme: Green (#008751) and white colors
Floating Buttons: Search and auto-update buttons
Smooth Animations: CSS transitions and keyframes
Card Layout: Modern, clean interface
Responsive: Works on all screen sizes

🔧 Configuration
Database Connection
Edit config/database.php for custom settings
Weather Update Interval
Default: 5 seconds (Min: 3, Max: 600)
API Timeout
XMLHttpRequest timeout: 10 seconds
🐛 Troubleshooting
Database Connection Failed

Verify MySQL is running in XAMPP
Check credentials in config/database.php

Weather Not Loading

Check internet connection
Verify coordinates are valid
Check browser console for errors

XAMPP Apache Won't Start

Port 80 might be in use
Stop Skype or other services using port 80

📝 Input Validation

City Name: Letters and spaces only (3-60 characters)
Latitude: Format XX.XXXX (e.g., 6.5244)
Longitude: Format XX.XXXX (e.g., 3.3792)

🔐 Security Notes

Input sanitization with PHP filters
SQL injection prevention (prepared statements)
XSS protection (htmlspecialchars)

📄 License
Free to use for educational purposes.


//.......................
👨‍💻 Author
Ernest Kekeke