<?php
    include_once "ss.inc.php";
    include_once 'rmvTmp.inc.php';
    if(isset($_POST["submit"]) and $_POST["submit"] == "mailver" and !isset($_SESSION["korisnik"])){
        $sKey = "6LfpjHgaAAAAAPP4EagMduYf5M5kPGmuEq0xmuzV";
        $rKey = $_POST["reCaptchaResponseMailVer"];
        $userIP = $_SERVER["REMOTE_ADDR"];
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=$sKey&response=$rKey&remoteip=$userIP";
        $recaptchaResponse = json_decode(file_get_contents($url));
        if($recaptchaResponse->success){
            include_once '../../classes/dbh.class.php';
            include_once '../../classes/nalog.class.php';
            $email = $_POST["email"];
            $id = -1;
            $con = Dbh::connect();
            if(!Nalog::invalidEmail($email)){
                $id = Nalog::getUserId($con,$email);
                if($id !== -1){
                    if(Nalog::userVerified($con,$id) !== 1){
                        Nalog::sendVerifyMail($con,$id,$email);
                        echo '<div class="mailverForm mx-auto" style="font-size:20px;font-weight:bold;"><center>
                                Линк са кодом за верификацију је послат на <em>'.$email.'</em>.<br>
                                Притисните на линк који сте добили у поруци и потврдите свој налог.
                             </center></div>';
                    } else{
                        header('HTTP/1.0 703 acc already verified');
                        exit();
                    }
                } else{
                    header('HTTP/1.0 702 user doesnt exists');
                    exit();
                }
            } else{
                header('HTTP/1.0 701 invalid email');
                exit();
            }
        } else{
            header('HTTP/1.0 700 Wrong captcha');
            exit();
        }
    } else{
        header('HTTP/1.0 404 not found');
        exit();
    }