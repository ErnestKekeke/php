<?php

declare(strict_types=1);
require_once("../config/database.php");
require_once("../models/post.php");
require_once("../controls/read_posts.php");
require_once("../controls/read_post.php");
require_once("../controls/create_post.php");
require_once("../controls/update_post.php");
require_once("../controls/delete_post.php");

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Origin, Authorization, X-Request-With');
//
?>

<?php
// echo $_SERVER["REQUEST_METHOD"] . "<br/>";

// READ A SINGLE POST.............................................
if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['id'])) {
    $id = preg_match("/^\d+$/m", $_GET['id']) ? $_GET['id'] : "0";
    // echo "id: " . $id . "<br/>"; 
    if ($id < 1) {
        http_response_code(404);
        die(json_encode(["message" => "No user id"]));
    }
    //....
    try {
        http_response_code(204);
        echo json_encode(readPost((int)$id));
    } catch (Error $e) {
        http_response_code(404);
        die(json_encode(["message" => $e->getMessage()]));
    }
    die();
}
// READ ALL POSTS..................................................
elseif ($_SERVER['REQUEST_METHOD'] == "GET") {
    try {
        http_response_code(404);
        echo json_encode(readPosts());
        // echo json_encode(["name" => "John", "age"=> 12]);
    } catch (Error $e) {
        http_response_code(404);
        die(json_encode(["message" => $e->getMessage()]));
    }
    die();
}

// CREATE A NEW POST.................................................
elseif ($_SERVER['REQUEST_METHOD'] == "POST" && !isset($_GET['id'])) {
    try {
        http_response_code(201);
        $jsonString = file_get_contents("php://input");
        $data = json_decode($jsonString);

        http_response_code(400);
        if (empty($data)) die(json_encode(["message" => "invalid json"]));

        echo json_encode(createPost($data));
    } catch (Error $e) {
        http_response_code(404);
        die(json_encode(["message" => $e->getMessage()]));
    }
    die();
}

// UPADATE A POST....................................................
elseif ($_SERVER['REQUEST_METHOD'] == "PUT" && isset($_GET['id'])) {
    $id = preg_match("/^\d+$/m", $_GET['id']) ? $_GET['id'] : "0";
    // echo "id: " . $id . "<br/>"; 
    if ($id < 1) {
        http_response_code(404);
        die(json_encode(["message" => "invalid user id"]));
    }

    try {
        $jsonString = file_get_contents("php://input");
        $data = json_decode($jsonString);

        http_response_code(400);
        if (empty($data)) die(json_encode(["message" => "invalid json"]));

        echo json_encode(updatePost((int)$id, $data));
    } catch (Error $e) {
        http_response_code(404);
        die(json_encode(["message" => $e->getMessage()]));
    }
    die();
}


// DELETE A POST....................................................
elseif ($_SERVER['REQUEST_METHOD'] == "DELETE" && isset($_GET['id'])) {
    $id = preg_match("/^\d+$/m", $_GET['id']) ? $_GET['id'] : "0";
    // echo "id: " . $id . "<br/>"; 
    if ($id < 1) {
        http_response_code(404);
        die(json_encode(["message" => "invalid user id"]));
    }

    try {
        http_response_code(404);
        echo json_encode(deletePost((int)$id));
    } catch (Error $e) {
        http_response_code(404);
        die(json_encode(["message" => $e->getMessage()]));
    }
    die();
}


http_response_code(400);
echo json_encode(["msg" => "NOT FOUND !!!"]);
die();
?>