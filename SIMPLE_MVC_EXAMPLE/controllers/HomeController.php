<?php
require_once("./models/User.php");

class HomeController{
    public function index(){
        $user = new User;
        $result = $user->getUser(2);
        $id = $result["id"];
        $firstname = $result["firstname"];
        $lastname = $result["lastname"];
        $gpa = $result["gpa"];

        require './views/home.php';
    }
}

// $homecontroller = new HomeController;
// $homecontroller->index();