<script src="https://skolskabiblioteka.muharemovic.com/scripts/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://skolskabiblioteka.muharemovic.com/scripts/header-funcs.js"></script>
<?php
    if(!isset($_SESSION["korisnik"])){
        echo '<script src="https://skolskabiblioteka.muharemovic.com/scripts/login-funcs.js"></script>';
    }
    if(isset($_SESSION["page_index_navbar_active"]) and $_SESSION["page_index_navbar_active"] === 6){
        echo '<script src="../scripts/signup-funcs.js"></script>';
    }
?>
</html>