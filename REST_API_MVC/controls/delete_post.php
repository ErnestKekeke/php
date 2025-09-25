<?php
declare(strict_types=1);
// require_once("../config/database.php");
// require_once("../models/post.php"); 
?>

<?php

function deletePost(int $id): array
{
    $datas = array();
    $datas['status'] = 404;

    $post = new Post();
    $checkId = $post->deleteUser((int)$id);

    $newData = array();
    if((int)$checkId == (int)$id){
        http_response_code(200);
        $datas['status'] = 200;
        $newData['id'] = $id;
        $newData['message'] = $id . " deleted successfully";
        $datas['data'] = $newData;

    }else{
        $datas['data'] = [];
    }
    return ($datas);
}

// header('Content-Type: application/json'); 
// echo json_encode(deletePost(9));
?>