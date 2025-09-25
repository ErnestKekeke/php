# Students REST API (PHP + MySQL)

Author:
The Author of this project is Ernest Kekeke.
more about the author visit: https://www.youtube.com/@ernestKekeke

About 
This project is a simple RESTful API built in PHP using the MVC architecture. It connects to a MySQL database (studentsdb) and performs CRUD operations on a users table.

The API endpoint is structured as: localhost/api/posts

Each student record contains:
- `id` (auto-increment)
- `name`
- `age`
- `subj_one`
- `subj_two`
- `message`
- `reg_date` (auto-set to current datetime)

## 📁 Project Structure

     /api
        └── posts.php
    /config
        └── Database.php
     /models
        └── Users post.php
     /controls
        └── read_posts.php
        └── read_post.php
        └── create_post.php
        └── update_post.php
        └── delete.php
    ── index.php
    ── .htaccess

users
Column	Type	Description
id	INT (PK, AI)	Primary key, auto-incremented
name	VARCHAR	Student's name
age	INT	Student's age
subj_one	VARCHAR	First subject
subj_two	VARCHAR	Second subject
message	TEXT	Optional message
reg_date	DATETIME	Registration date (default NOW())



🔌 API Endpoints
Action	Method	Endpoint	Description
Read All Users	GET	/api/posts	Fetch all users
Read One User	GET	/api/posts/{id}	Fetch user by ID
Create User	POST	/api/posts	Add a new User
Update User	PUT	/api/posts/{id}	Update a new user by ID
Delete User	DELETE	/api/posts/{id}	Delete a new user by ID


🔧 Setup Instructions

1. Clone the Repository
git clone https://github.com/yourusername/php-rest-api-mvc.git
cd php-rest-api-mvc

2. Configure Database

Create a database and table using the following SQL:

CREATE DATABASE IF NOT EXISTS studentsdb;

USE studentsdb;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  age INT,
  subj_one VARCHAR(100),
  subj_two VARCHAR(100),
  message TEXT,
  reg_date DATETIME DEFAULT CURRENT_TIMESTAMP
);

3. Update DB Credentials

Edit /api/config/Database.php if your DB credentials differ:

private $username = "root";
private $password = "";

4. Serve the API

You can use Apache or PHP's built-in server:

Then visit:

http://localhost/api/posts — List all users
http://localhost/api/posts/1 — View user with ID = 1

or

php -S localhost:8000

http://localhost:8000/api/posts — List all users
http://localhost:8000/api/posts/1 — View user with ID = 1



📝 Sample JSON Response
✅ GET /api/posts
[
  {
    "id": 1,
    "name": "John",
    "age": 20,
    "subjects": ["Math", "Phy"],
    "message": "I love my school",
    "reg_date": "2025-09-25 12:30:45"
  }
]