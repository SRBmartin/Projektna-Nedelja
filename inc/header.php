<?php 
    Header::set_header_carousel_cookie();
    Nalog::set_login_cookie();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>
    <?php echo Header::get_title(); ?>
    </title>
    <link rel="icon" href="https://skolskabiblioteka.muharemovic.com/img/logo.png" sizes="16x16">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://skolskabiblioteka.muharemovic.com/styles/main.css">
    <script src="https://kit.fontawesome.com/49616ed0d1.js" crossorigin="anonymous"></script>
    <?php
        include_once 'i/rmvTmp.inc.php';
        if(isset($_SESSION["grcap"])){
            echo '<script src="../scripts/signup-capt.js"></script>
                 <script src="https://www.google.com/recaptcha/api.js?onload=g_recapFunc&render=explicit" async defer></script>';
        } else{
            echo '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
        }
    ?>
</head>
<body>
    <noscript>Ваш интернет прегледач не подржава JavaScript-у. Због тога Вам овај сајт неће бити доступан.</noscript>
    <div class="header">
        <?php 
            Header::set_header_carousel();
            Header::set_navbar(); 
            if(!isset($_SESSION["korisnik"])){
                echo '<div id="m-target"></div>';
            }
        ?>
    </div>