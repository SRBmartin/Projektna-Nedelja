<?php
    include_once "../inc/i/ss.inc.php";
    unset($_SESSION["page_index_navbar_active"]);
    $_SESSION["grcap"] = 'a';
    if(isset($_GET["fkey"]) and isset($_GET["auth"]) and !isset($_SESSION["korisnik"])){
        include_once "../classes/dbh.class.php";
        include_once "../classes/header.class.php";
        include_once "../classes/nalog.class.php";
        $con = DBh::connect();
        $fpass = Nalog::checkFpass($con,$_GET["fkey"],$_GET["auth"]);
        if($fpass == 1){
            $_SESSION["fpass-verify"] = array();
            $_SESSION["fpass-verify"]["fkey"] = $_GET["fkey"];
            $_SESSION["fpass-verify"]["auth"] = $_GET["auth"];
            $_SESSION["page_index_navbar_active"] = 7;
        }
        include_once "../inc/header.php";
        echo '<div class="fpass-container mx-auto">';
        switch($fpass){
            case 1: //uspesno prikazati uspesan obrazac
                echo '<form method="post" class="fpassForm mx-auto" style="text-align:center;">
                        <input type="text" style="display:none;" autocomplete="username">
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="fpassPass">Унесите нову шифру</label>
                                <input type="password" class="form-control" id="fpassPass" style="margin-top:15px;" autocomplete="new-password">
                                <div class="text-danger xFpassGErr" id="invxFpass" style="display:none;"><small>Ваша лозинка мора да има латинична слова, број и тачку или зарез.</small></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="fpassPassRpt">Поновите нову шифру</label>
                                <input type="password" class="form-control" id="fpassPassRpt" style="margin-top:15px;" autocomplete="new-password">
                                <div class="text-danger xFpassGErr" id="ntmtchxFpass" style="display:none;"><small>Шифре нису исте.</small></div>
                            </div>
                        </div>
                        <center><div id="signRecap"></div></center>
                        <div class="text-danger xFpassGErr" id="captxFPassErr" style="display:none;"><small>Нисте означили безбедносни образац.</small></div>
                        <div class="text-danger xFpassGErr" id="XfPass4VerErr" style="display:none;"><small>Дошло је до грешке.</small></div>
                        <button type="button" id="x-fpass-submit" style="margin-top:15px;" class="btn btn-primary">Промени шифру</button>
                    </form>';
                break;
            case -1: //podaci nisu pronadjeni
                echo '<div class="fpassForm mx-auto" style="font-size:18px;font-weight:bold;text-align:center;">
                        Није могуће пронаћи важећи код за везу коју сте проследили.
                        </div>';
                break;
            case -2: //kod je istekao 
                echo '<div class="fpassForm mx-auto" style="font-size:18px;font-weight:bold;text-align:center;">
                        Код који сте проследили је истекао. <br>Можете да покренете нови код притиском
                        на ову везу: <a href="https://skolskabiblioteka.muharemovic.com/p/fpass" class="btn btn-default">Заборављена шифра</a>
                     </div>';    
                break;
            default: //doslo je do greske
                echo '<div class="fpassForm mx-auto" style="font-size:18px;font-weight:bold;">
                        Дошло је до грешке, молимо пробајте касније опет.
                    </div>';
                break;
        }
        echo '</div>';
        include_once "../inc/footer.php";
    } else if((!isset($_GET["fkey"]) or !isset($_GET["auth"])) and !isset($_SESSION["korisnik"])){
        include_once "../classes/dbh.class.php";
        include_once "../classes/header.class.php";
        include_once "../classes/nalog.class.php";
        include_once "../classes/main.class.php";
        $_SESSION["page_index_navbar_active"] = 7; //određuje na kojoj je stranici da bi se link u navigaciji promenio
        include_once "../inc/header.php";
        Main::set_fpass();
        include_once "../inc/footer.php";
    } else{
        header("Location: https://skolskabiblioteka.muharemovic.com");
        exit();
    }
