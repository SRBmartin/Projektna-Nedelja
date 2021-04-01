<?php
    include_once "../inc/i/ss.inc.php";
    unset($_SESSION["page_index_navbar_active"]);
    $_SESSION["grcap"] = 'a';
    if(isset($_GET["vkey"]) and !isset($_SESSION["korisnik"])){
        include_once "../classes/dbh.class.php";
        include_once "../classes/header.class.php";
        include_once "../classes/nalog.class.php";
        include_once "../inc/header.php";
        $con = Dbh::connect();
        $ret = Nalog::checkVkey($con,$_GET["vkey"]); //ret = return
        echo '<div class="mailver-container mx-auto"><div class="mailverForm mx-auto">
             <div style="font-size:22px; font-weight:bold;"><center>';
        switch($ret){
            case 0: 
                echo 'Овај верификациони кључ не постоји.'; 
                break;
            case 1:
                echo 'Успешно сте верификовали свој налог. <br>Сада можете да се пријавите.';
                break;
        }
        echo '</center></div></div></div></body>';
        include_once "../inc/footer.php";
    } else if(!isset($_GET["vkey"]) and !isset($_SESSION["korisnik"])){
        include_once "../classes/dbh.class.php";
        include_once "../classes/header.class.php";
        include_once "../classes/nalog.class.php";
        include_once "../classes/main.class.php";
        $_SESSION["page_index_navbar_active"] = 8;
        include_once "../inc/header.php";
        Main::set_mailver();
        include_once "../inc/footer.php";
    } else{
        header('HTTP/1.0 404 not found');
        exit();
    }