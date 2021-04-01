<?php
    include_once "ss.inc.php";
    include_once 'rmvTmp.inc.php';
    if(isset($_POST["submit"]) and $_POST["submit"] === 'signup' and !isset($_SESSION["korisnik"])){
        include_once "../../classes/dbh.class.php";
        include_once "../../classes/nalog.class.php";
        $sKey = "6LfpjHgaAAAAAPP4EagMduYf5M5kPGmuEq0xmuzV";
        $rKey = $_POST["reCaptchaResponseSignUp"];
        $userIP = $_SERVER["REMOTE_ADDR"];
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=$sKey&response=$rKey&remoteip=$userIP";
        $recaptchaResponse = json_decode(file_get_contents($url));
        if($recaptchaResponse->success){
            $ime = preg_split('//u',$_POST["ime"],-1,PREG_SPLIT_NO_EMPTY);
            $prezime = preg_split('//u',$_POST["prezime"],-1,PREG_SPLIT_NO_EMPTY);
            $kIme = preg_split('//u',$_POST["kIme"],-1,PREG_SPLIT_NO_EMPTY);
            $email = $_POST["email"];
            $password = $_POST["password"];
            $rptPassword = $_POST["passwordRpt"];
            $email = rtrim($email," ");
            if(count($ime) < 3 or count($ime) > 63){
                header('HTTP/1.0 711 long name');
                exit();
            } else if(count($prezime) < 3 or count($prezime) > 63){
                header('HTTP/1.0 712 long surname');
                exit();
            } else if(count($kIme) < 3 or count($kIme) > 31){
                header('HTTP/1.0 713 long username');
                exit();
            } else if(strlen($email) < 3 or strlen($email) > 127){
                header('HTTP/1.0 714 long email');
                exit();
            }
            $con = Dbh::connect();
            if(!Nalog::emptySignup($ime,$prezime,$kIme,$email,$password,$rptPassword)){
                switch(Nalog::invalidInicijali($ime,$prezime)){
                    case 702:
                        header("HTTP/1.0 702 Invalid both name surname");
                        exit();
                    case 703:
                        header("HTTP/1.0 703 Invalid name");
                        exit();
                    case 704:
                        header("HTTP/1.0 704 Invalid surname");
                        exit();
                    case 200:
                        if(!Nalog::invalidUsername($kIme)){
                            if(!Nalog::invalidEmail($email)){
                                if(!Nalog::invalidPassword($password)){
                                    if(Nalog::passwordsMatch($password,$rptPassword)){
                                        if(!Nalog::userExists($con,$email)){
                                            if(!Nalog::usernameExists($con,rtrim(Nalog::p_split_array2string($kIme)," "))){
                                                Nalog::createUser($con,$ime,$prezime,$kIme,$email,$password);
                                                echo '<div class="signupForm mx-auto" style="font-size:26px;font-weight:bold;overflow:scrollable;"><center>Ваш налог је регистрован. Да бисте довршили регистрацију морате да 
                                                     потврдите свој налог притиском на линк послат на <em>'.$email.'</em>.<br>
                                                     Након тога можете да се пријавите на свој налог.</center><div>';
                                            } else{
                                                header('HTTP/1.0 710 Username exists');
                                                exit();
                                            }
                                        } else{
                                            header("HTTP/1.0 709 User exists");
                                            exit();
                                        }
                                    } else{
                                        header("HTTP/1.0 708 Passwords dont match");
                                        exit();
                                    }
                                } else{
                                    header("HTTP/1.0 707 Bad password");
                                    exit();
                                }
                            } else{
                                header("HTTP/1.0 706 Bad email");
                                exit();
                            }
                        } else{
                            header("HTTP/1.0 705 Bad username");
                            exit();
                        }
                        break;
                    default:
                        header("HTTP/1.0 400 Bad error");
                        exit();
                }
            } else{
                header("HTTP/1.0 701 Empty inputs");
                exit();
            }
        } else{
            header("HTTP/1.0 700 Recaptcha failed");
            exit();
        }
    } else{
        header("HTTP/1.0 404 Not found");
        exit();
    }