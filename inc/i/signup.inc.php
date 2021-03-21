<?php
    include_once "ss.inc.php";
    if(isset($_POST["submit"]) and $_POST["submit"] === 'signup' and !isset($_SESSION["korisnik"])){
        include_once "../../classes/dbh.class.php";
        include_once "../../classes/nalog.class.php";
        $sKey = "6LfpjHgaAAAAAPP4EagMduYf5M5kPGmuEq0xmuzV";
        $rKey = $_POST["reCaptchaResponseSignUp"];
        $userIP = $_SERVER["REMOTE_ADDR"];
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=$sKey&response=$rKey&remoteip=$userIP";
        $recaptchaResponse = json_decode(file_get_contents($url));
        if($recaptchaResponse->success){

        } else{
            header("HTTP/1.0 700 Recaptcha failed");
            exit();
        }
    } else{
        header("HTTP/1.0 404 Not found");
        exit();
    }