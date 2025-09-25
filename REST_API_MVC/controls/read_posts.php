<?php

declare(strict_types=1);
// require_once("../config/database.php");
// require_once("../models/post.php");
?>

<?php

function readPosts(): array
{
    $post = new Post();
    $users = $post->users();
    $datas = array();
    $datas['status'] = 404;
    $datas['data'] = array();

    if (!empty($users)) {

        // print_r($users);
        http_response_code(200);
        $datas['status'] = 200;
        foreach ($users as $user) {
            // print_r($user);  echo "<br/>";
            $data['id'] = $user['id'];
            $data['name'] = $user['name'];
            $data['age'] = $user['age'];

            // $subject = ["subj_one" => $user['subj_one'],  "subj_two" => $user ['subj_two']];
            $subjects = array();
            array_push($subjects, $user['subj_one']);
            array_push($subjects, $user['subj_two']);

            // print_r($subject); echo "<br/><br/>";

            $data['subjects'] = $subjects;
            $data['message'] = html_entity_decode($user['message']);
            $data['reg_date'] = $user['reg_date'];
            // print_r($data); echo "<br/>";

            array_push($datas['data'], $data);
        }
        return $datas;
    }else{
          array_push($datas['data'], []);
          return $datas;
    }

}

// header('Content-Type: application/json'); 
// echo json_encode(readPosts());

?>