<?php
session_start();

    // base url and root 
    //customize for every one
    define('URL', "http://127.0.0.1/php/PHP_Restaurant/"); // for links and urls - project folder
   

    // include function files

    require_once "./includes/common/Database.php";
    require_once "./includes/common/Functions.php";
    require_once "./includes/common/validations.php";
    
   
    $db = new Database();



   

