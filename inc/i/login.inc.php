<?php
    session_start();
    include_once "../../classes/dbh.class.php";
    include_once "../../classes/nalog.class.php";

    if(isset($_POST["submit"]) and $_POST["submit"] === 'login'){
        $email = $_POST["email"];
        $password = $_POST["password"];
        if(!Nalog::emptyLogin($email,$password)){

        } else{
            
        }
    }