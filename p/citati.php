<?php
    include_once "../inc/i/ss.inc.php";
    include_once "../classes/dbh.class.php";
    include_once "../classes/header.class.php";
    include_once "../classes/nalog.class.php";
    include_once "../classes/main.class.php";
    $_SESSION["page_index_navbar_active"] = 9; //određuje na kojoj je stranici da bi se link u navigaciji promenio
    include_once "../inc/header.php";
    Main::set_citati();
    include_once "../inc/footer.php";
?>