<?php
    include_once "ss.inc.php";
    include_once 'rmvTmp.inc.php';
    if(isset($_POST["submit"]) and $_POST["submit"] === 'login' and !isset($_SESSION["korisnik"])){
        include_once "../../classes/dbh.class.php";
        include_once "../../classes/nalog.class.php";
        $sKey = "6LfpjHgaAAAAAPP4EagMduYf5M5kPGmuEq0xmuzV";
        $rKey = $_POST["reCaptchaResponse"];
        $userIP = $_SERVER["REMOTE_ADDR"];
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=$sKey&response=$rKey&remoteip=$userIP";
        $recaptchaResponse = json_decode(file_get_contents($url));
        if($recaptchaResponse->success){
            $email = $_POST["email"];
            $password = $_POST["password"];  
            $empty = Nalog::emptyLogin($email,$password);
            if(!$empty){
                Nalog::loginUser($email,$password);
                    if(isset($_SESSION["korisnik"]["admin"]) and $_SESSION["korisnik"]["admin"] > 0){
                        echo '<li class="nav-item">
                            <a class="nav-link" href="https://skolskabiblioteka.muharemovic.com/p/urpan">Уреднички панел</a>
                            </li>';
                    }
                    echo '<li class="nav-item dropdown" id="User-CP-Navbar">
                            <a class="nav-link dropdown-toggle" id="NavBarDropDownKorisnik" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'. $_SESSION["korisnik"]["korisnicko_ime"] .'</a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="NavBarDropDownKorisnik">
                            <a class="dropdown-item" href="#">Профил</a>
                            <a class="dropdown-item" href="#">Моје књиге</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" data-toggle="modal" data-target="#logout-modal" id="logout-profile">Одјави се</a>
                            </div>
                        </li>';
                }else{
                    $error = $_SESSION["login-greska"];
                    unset($_SESSION["login-greska"]);
                    switch($error){
                        case 707:
                            header('HTTP/1.0 707 Empty email and password'); //oba polja su prazna
                            exit();
                            break;
                        case 706:
                            header('HTTP/1.0 706 Empty password'); //prazna sifra
                            exit();
                            break;
                        case 705:
                            header('HTTP/1.0 705 Empty email'); //prazan email
                            exit();
                            break;
                        default:
                            header("HTTP/1.0 400 Bad error");
                            exit();
                            break;
                }
            }
        } else{
            header("HTTP/1.0 702 Wrong recaptcha");
            exit();
        }
    } else{
        header("Location: https://skolskabiblioteka.muharemovic.com");
        exit();
    }