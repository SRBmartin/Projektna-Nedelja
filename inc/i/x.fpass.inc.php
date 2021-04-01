<?php
    include_once 'ss.inc.php';
    if(isset($_POST["submit"]) and $_POST["submit"] == 'x-fpass' and isset($_SESSION["fpass-verify"])){
        $sKey = "6LfpjHgaAAAAAPP4EagMduYf5M5kPGmuEq0xmuzV";
        $rKey = $_POST["reCaptchaResponsexFpass"];
        $userIP = $_SERVER["REMOTE_ADDR"];
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=$sKey&response=$rKey&remoteip=$userIP";
        $recaptchaResponse = json_decode(file_get_contents($url));
        if($recaptchaResponse->success){
            include_once '../../classes/dbh.class.php';
            include_once '../../classes/nalog.class.php';
            if(Nalog::auth_verify_fpass($_POST["fk"],$_POST["au"])){
                $pass = $_POST["passfp"];
                $passRpt = $_POST["passRptfp"];
                if(!Nalog::invalidPassword($pass)){
                    if(Nalog::passwordsMatch($pass,$passRpt)){
                        Nalog::change_passFpass(Dbh::connect(),$pass,$_POST["fk"],$_POST["au"]);
                        unset($_SESSION["fpass-verify"]);
                        echo '<div class="fpassForm mx-auto" style="text-align:center;font-size:18px;font-weight:bold;">
                             Успешно сте променили своју шифру, сада можете да се пријавите.
                             </div>';
                    } else{
                        header('HTTP/1.0 702 password doesnt match');
                        exit();
                    }
                } else{
                    header('HTTP/1.0 701 invalid password');
                    exit();
                }
            } else{
                echo '<div class="fpassForm mx-auto" style="text-align:center;font-size:18px;font-weight:bold;">
                        Дошло је до грешке приликом аутентикације, покушајте поново касније.
                    </div>';
                    header('HTTP/1.0 200 auth prob');
                    exit();
            }
        } else{
            header('HTTP/1.0 700 wrong captcha');
            exit();
        }
    } else{
        header('HTTP/1.0 404 not found');
        exit();
    }