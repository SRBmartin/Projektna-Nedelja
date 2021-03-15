<?php
    include_once "../inc/i/ss.inc.php";
    if(isset($_SESSION["korisnik"])){
        session_unset();
        session_destroy();
        setcookie("ussid",$_SESSION["korisnik"]["ussid"],time()-3600,"/");
        header("Location: https://skolskabiblioteka.muharemovic.com");
        exit();
    } else{
        header("Location: https://skolskabiblioteka.muharemovic.com");
        exit();
    }