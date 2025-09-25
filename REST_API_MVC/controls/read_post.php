<?php

declare(strict_types=1);
// require_once("../config/database.php");
// require_once("../models/post.php"); 
?>

<?php

function readPost(int $id): array
{
    $datas = array();
    $datas['status'] = 204;

    $post = new Post();
    $user = $post->user($id);

    if (!empty($user)) {
        http_response_code(200);
        $datas['status'] = 200;
        // print_r($user);  echo "<br/>";

        // // method A
        // $data['id'] = $user['id'];
        // $data['name'] = $user['name'];
        // $data['age'] = $user['age'];

        // method B
        extract($user);
        $data['id'] = $id;
        $data['name'] = $name;
        $data['age'] = $age;

        // $subject = ["subj_one" => $user['subj_one'],  "subj_two" => $user ['subj_two']];
        $subjects = array();
        array_push($subjects, $user['subj_one']);
        array_push($subjects, $user['subj_two']);
        // print_r($subject); echo "<br/><br/>";

        $data['subjects'] = $subjects;
        $data['message'] = html_entity_decode($user['message']);
        $data['reg_date'] = $user['reg_date'];
        // print_r($data); echo "<br/>";
        $datas['data'] = $data;
    } else {
        // echo "The array is empty.";
        $datas['data'] = [];
    }
    return $datas;
}

// header('Content-Type: application/json'); 
// echo json_encode(readPost(2));
?>