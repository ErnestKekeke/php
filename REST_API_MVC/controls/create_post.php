<?php
declare(strict_types=1);
// require_once("../config/database.php");
// require_once("../models/post.php");
?>

<?php

function createPost(mixed $data): array
{
    $datas = array();
    $datas['status'] = 201;

    $name = !empty($data->name) ? $data->name : "unknown";
    $age = !empty($data->age) ? $data->age : 0;
    $subjects = !empty($data->subjects) ? $data->subjects : ["", ""];
    $subj_one = !empty($subjects[0]) ? $subjects[0] : "";
    $subj_two = !empty($subjects[1]) ? $subjects[1] : "";
    $message = !empty($data->message) ? $data->message : "no message";

    $name = htmlspecialchars(strip_tags($name));
    $age = htmlspecialchars(strip_tags($age));
    $subj_one = htmlspecialchars(strip_tags($subj_one));
    $subj_two = htmlspecialchars(strip_tags($subj_two));
    $message = htmlspecialchars(strip_tags($message));

    // echo $name . "<br/>";
    // echo $age . "<br/>";
    // echo $subj_one. "<br/>";
    // echo $subj_two. "<br/>";
    // echo $message . "<br/>";
    $post = new Post();
    $id = $post->newUser($name, (int)$age, $subj_one, $subj_two, $message);

    $newData = array();

    if((int)$id){
        http_response_code(201);
        $newData['id'] = $id;
        $newData['message'] = $id . " created successfully";
    }else{
        http_response_code(400);
        $newData['id'] = $id;
        $newData['message'] = $id . "Failed to create user.";
    }



    $datas['data'] = $newData;
    return ($datas);
}
?>
