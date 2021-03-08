<?php
    session_start();
    include_once "classes/dbh.class.php";
    include_once "classes/header.class.php";
    $_SESSION["page_index_navbar_active"] = 0; //određuje na kojoj je stranici da bi se link u navigaciji promenio
    include_once "inc/header.php";
?>
</body>
<?php
    include_once "inc/footer.php";
?>