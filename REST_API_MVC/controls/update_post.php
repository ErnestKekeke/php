<?php

declare(strict_types=1);
// require_once("../config/database.php");
// require_once("../models/post.php"); 
?>

<?php

function updatePost(int $id, stdClass $updUser): array
{
    $datas = array();
    $datas['status'] = 404;

    $post = new Post();
    $user = $post->user($id); // read a user from POST CLASS

    if(empty($user)){
        http_response_code(404);
        $newData['id'] = $id;
        $newData['message'] = $id . " No user found with the given ID.";
        $datas['data'] = $newData;
        return ($datas);
    }

    extract($user);
    $name;
    $age;
    $subj_one;
    $subj_two;
    $message;

    $name = isset($updUser->name) ? $updUser->name : $name;
    $age = isset($updUser->age) ? $updUser->age : $age;
    $message = isset($updUser->message) ? $updUser->message : $message;
    $subj_one = isset($updUser->subjects[0]) ? $updUser->subjects[0] : $subj_one;
    $subj_two = isset($updUser->subjects[1]) ? $updUser->subjects[1] : $subj_two;

    $name = htmlspecialchars(strip_tags($name));
    $age = (int)$age;
    $subj_one = htmlspecialchars(strip_tags($subj_one));
    $subj_two = htmlspecialchars(strip_tags($subj_two));
    $message = htmlspecialchars(strip_tags($message));

    // echo $name . "<br/>";
    // echo $age . "<br/>";
    // echo $subj_one. "<br/>";
    // echo $subj_two. "<br/>";
    // echo $message . "<br/>";

    $checkId = $post->updateUser((int)$id, $name, (int)$age, $subj_one, $subj_two, $message);
    // echo $checkId;

    $newData = array();

    if((int)$checkId == (int)$id){
        http_response_code(200);
        $datas['status'] = 200;
        $newData['id'] = $id;
        $newData['message'] = $id . " updated successfully";
    }elseif((int)$checkId == 0){
        http_response_code(304);
        $datas['status'] = 304;
        $newData['id'] = $id;
        $newData['message'] = $id . "No changes made. (Maybe the data is the same, or user not found.)";
    }else{
        http_response_code(404);
        $newData['id'] = $id;
        $newData['message'] = $id . " No user found with the given ID.";
    }

    $datas['data'] = $newData;
    return ($datas);
}

// $updUser = new stdClass();
// $updUser->name = "Rick";
// $updUser->age = 49;
// $updUser->subjects = [null, null];
// $updUser->message = "I love music class";

// header('Content-Type: application/json'); 
// echo json_encode(updatePost(6, $updUser));
?>