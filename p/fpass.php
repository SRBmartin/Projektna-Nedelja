<?php
    include_once "../inc/i/ss.inc.php";
    if(!isset($_SESSION["korisnik"])){
        include_once "../classes/dbh.class.php";
        include_once "../classes/header.class.php";
        include_once "../classes/nalog.class.php";
        $_SESSION["page_index_navbar_active"] = 7; //određuje na kojoj je stranici da bi se link u navigaciji promenio
        include_once "../inc/header.php";
        echo '</body>';
        include_once "../inc/footer.php";
    } else{
        header("Location: https://skolskabiblioteka.muharemovic.com");
    }
