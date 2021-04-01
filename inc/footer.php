
<div class="footer mx-auto">
    <div class="footer-cont">
        <div class="row frow">
            <div class="col-sm-6 col-md-3 item">
                <h3>Брзе везе</h3>
                <ul>
                    <li><a href="https://skolskabiblioteka.muharemovic.com/">Почетна</a></li>
                    <li><a href="https://skolskabiblioteka.muharemovic.com/p/k/lirika">Лирика</a></li>
                    <li><a href="https://skolskabiblioteka.muharemovic.com/p/k/epika">Епика</a></li>
                    <li><a href="https://skolskabiblioteka.muharemovic.com/p/k/drama">Драма</a></li>
                    <li><a href="https://skolskabiblioteka.muharemovic.com/p/citati">Цитати</a></li>
                </ul>
            </div>
            <div class="col-sm-6 col-md-3 item">
                <h3>О нама</h3>
                <ul>
                    <li><a href="">Пошаљите повратну информацију</a></li>
                    <li><a href="">Треба ми помоћ</a></li>
                </ul>
            </div>
            <div class="col item social">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-linkedin"></i></a>
            </div>
        </div>
         <p class="copyright mx-auto">Школска библиотека © 2021 - <?php echo date("Y");?></p>
         </div>
    </div>
</body>
<script src="https://skolskabiblioteka.muharemovic.com/scripts/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://skolskabiblioteka.muharemovic.com/scripts/header-funcs.js"></script>
<script src="https://skolskabiblioteka.muharemovic.com/scripts/footer-funcs.js"></script>
<?php
    if(isset($_SESSION["page_index_navbar_active"]) and $_SESSION["page_index_navbar_active"] === 9){
        echo '<script src="../scripts/cres.js"></script>';
        unset($_SESSION["page_index_navbar_active"]);
    }
    if(!isset($_SESSION["korisnik"])){
        echo '<script src="https://skolskabiblioteka.muharemovic.com/scripts/login-funcs.js"></script>';
    }
    if(isset($_SESSION["page_index_navbar_active"]) and $_SESSION["page_index_navbar_active"] === 6){
        echo '<script src="../scripts/signup-funcs.js"></script>';
    }
    if(isset($_SESSION["page_index_navbar_active"]) and $_SESSION["page_index_navbar_active"] === 8 and !isset($_GET["vkey"])){
        echo '<script src="../scripts/mailver-funcs.js"></script>';
    }
    if(isset($_SESSION["page_index_navbar_active"]) and $_SESSION["page_index_navbar_active"] === 7 and !isset($_SESSION["fpass-verify"]) and (!isset($_GET["fkey"]) or !isset($_GET["auth"]))){
        echo '<script src="../scripts/fpass-funcs.js"></script>';
    } else if(isset($_SESSION["fpass-verify"]) and $_SESSION["page_index_navbar_active"] === 7){
        echo '<script src="../scripts/x-fpass-funcs.js"></script>';
    }
?>
</html>