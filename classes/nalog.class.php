<?php
    use PHPMailer\PHPMailer\PHPMailer;
    class Nalog
    {
        /**************************** LOGIN FUNKCIJE *************************/
        public static function emptyLogin($email,$password){
            $eEmail = false;
            $ePassword = false;
            if(empty($email)){
                $eEmail = true;
            }
            if(empty($password)){
                $ePassword = true; 
            }
            if($eEmail and $ePassword){
                $_SESSION["login-greska"] = 707; // oba fale
                return true;
            } else if($eEmail){
                $_SESSION["login-greska"] = 705; //email fali
                return true;
            } else if($ePassword){
                $_SESSION["login-greska"] = 706; //sifra fali
                return true;
            } else{
                return false;
            }
        }

        public static function userExists($con,$email){
            $sql = "SELECT korisnicko_ime FROM korisnici WHERE email=?;";
            $stmt = $con->stmt_init();
            if(!$stmt->prepare($sql)){
                header('HTTP/1.0 400 Bad error'); //stmt greska
                exit();
            } else{
                $stmt->bind_param("s",rtrim($email," "));
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();
                if($result->fetch_assoc()){
                    return true;
                } else{
                    return false;
                }
            }
        }

        public static function getUserId($con,$email){
            $sql = "SELECT id FROM korisnici WHERE email=?;";
            $stmt = $con->stmt_init();
            if(!$stmt->prepare($sql)){
                header('HTTP/1.0 400 Bad error'); //stmt greska
                exit();
            } else{
                $stmt->bind_param("s",$email);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();
                if($result->num_rows !== 0){
                    $inf = $result->fetch_assoc();
                    return (int)$inf["id"];
                } else{
                    return -1;
                }
            }
        }

        public static function getUserEmail($con,$id){
            $sql = "SELECT email FROM korisnici WHERE id=?;";
            $stmt = $con->stmt_init();
            if(!$stmt->prepare($sql)){
                header('HTTP/1.0 400 Bad error'); //stmt greska
                exit();
            } else{
                $stmt->bind_param("i",$id);
                $stmt->execute();
                $result = $stmt->get_result();
                $inf = $result->fetch_assoc();
                $stmt->close();
                return $inf["email"];
            }
        }

        public static function userVerified($con,$id){
            $sql = "SELECT verifikovan FROM korisnici WHERE id=?;";
            $stmt = $con->stmt_init();
            if(!$stmt->prepare($sql)){
                header('HTTP/1.0 400 Bad error'); //stmt greska
                exit();
            } else{
                $stmt->bind_param("i",$id);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();
                if($result->num_rows !== 0){
                    $inf = $result->fetch_assoc();
                    $verifikovan = $inf["verifikovan"];
                    if($verifikovan === 'y'){
                        return 1;
                    } else{
                        return -1;
                    }
                } else{
                    return 'x';
                }
            }
        }

        public static function loginUser($email, $password){
            $con = Dbh::connect();
            $exists = true;
            $id = -1;
            if(self::userExists($con,$email)){
                $id = self::getUserId($con, $email);
                if($id !== -1){
                    $sql = "SELECT sifra,salt FROM korisnici WHERE id=?;";
                    $stmt = $con->stmt_init();
                    if(!$stmt->prepare($sql)){
                        header('HTTP/1.0 400 Bad error'); //stmt greska
                        exit();
                    }else{
                        $stmt->bind_param("i",$id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $stmt->close();
                        $inf = $result->fetch_assoc();
                        $pwdCheck = $inf["salt"].$password.$inf["salt"];
                        if(password_verify($pwdCheck,$inf["sifra"])){
                            $ver = self::userVerified($con,$id);
                            if($ver !== 'x'){
                                if($ver === 1){
                                    $sql = "SELECT korisnicko_ime,ssid FROM korisnici WHERE id=?;";
                                    $stmt = $con->stmt_init();
                                    if(!$stmt->prepare($sql)){
                                        header('HTTP/1.0 400 Bad error'); //stmt greska
                                        exit();
                                    } else{
                                        $stmt->bind_param("i",$id);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        $stmt->close();
                                        $inf = $result->fetch_assoc();
                                        if(isset($_SESSION["korisnik"])){
                                            unset($_SESSION["korisnik"]);
                                        }
                                        $_SESSION["korisnik"] = array();
                                        $_SESSION["korisnik"]["korisnicko_ime"] = $inf["korisnicko_ime"];
                                        $_SESSION["korisnik"]["email"] = $email;
                                        $_SESSION["korisnik"]["id"] = $id;
                                        $_SESSION["korisnik"]["ussid"] = $inf["ssid"];
                                        $_SESSION["cookie_check"] = "ovojetajnaporuka2708инаћирилициисто";
                                    }
                                } else{
                                    header('HTTP/1.0 703 Not verified'); //nije verifikovan
                                    exit();
                                }
                            } else{
                                $exists = false;
                            }
                        } else{
                            header('HTTP/1.0 701 Wrong pass'); //pogresna sifra
                            exit();
                        }
                    }
                    
                } else{
                    $exists = false;
                }
            } else{
                $exists = false;
            }
            if(!$exists){
                header('HTTP/1.0 704 Acc doesnt exist'); //nalog ne postoji
                exit();
            } else{
                return true;
            }
        }

        public static function set_login_cookie(){
            if(isset($_SESSION["cookie_check"]) and $_SESSION["cookie_check"] === "ovojetajnaporuka2708инаћирилициисто" and isset($_SESSION["korisnik"]["ussid"])){
                setcookie("ussid",$_SESSION["korisnik"]["ussid"],time()+30,"/");
                unset($_SESSION["cookie_check"]);
            }
        }

        /*--------------------- РЕГИСТРАЦИЈА ---------------------*/

        public static function emptySignup($ime,$prezime,$kIme,$email,$password,$rptPassword){
            if(empty($ime) or empty($prezime) or empty($kIme) or empty($email) or empty($password) or empty($rptPassword)){
                return true;
            } else{
                return false;
            }
        }

        private static function checkCyrilic($string){
            $cirilicaM = array("а","б","в","г","д","ђ","е","ж","з","и","ј","к","л","љ","м","н","њ","о","п","р","с","т","ћ","у","ф","х","ц","ч","џ","ш");
            $cirilicaV = array("А","Б","В","Г","Д","Ђ","Е","Ж","З","И","Ј","К","Л","Љ","М","Н","Њ","О","П","Р","С","Т","Ћ","У","Ф","Х","Ц","Ч","Џ","Ш");
            for($i=0;$i<count($string);$i++){
                $check = false;
                for($j = 0; $j<30;$j++){
                    if($string[$i] == $cirilicaM[$j] or $string[$i] == $cirilicaV[$j]){
                        $check = true;
                        break;
                    }
                    if($i == count($string)-1 and !$check){
                        if($string[$i] == " "){
                            $check = true;
                        }
                    }
                }
                if(!$check){
                    return false;
                }
            }
            return true;
        }

        public static function invalidInicijali($ime,$prezime){
            $boolIme = true;
            $boolPrezime = true;
            if(!self::checkCyrilic($ime)){
                $boolIme = false;
            }
            if(!self::checkCyrilic($prezime)){
                $boolPrezime = false;
            }
            if(!$boolIme and !$boolPrezime){
                return 702; //oba nisu na cirilici
            } else if(!$boolIme){
                return 703; //ime nije na cirilici
            } else if(!$boolPrezime){
                return 704; // prezime nije na cirilici
            } else{
                return 200; //uspesno
            }
        }

        public static function invalidUsername($kIme){
            $cirilicaM = array("а","б","в","г","д","ђ","е","ж","з","и","ј","к","л","љ","м","н","њ","о","п","р","с","т","ћ","у","ф","х","ц","ч","џ","ш","1","2","3","4","5","6","7","8","9","0",".");
            $cirilicaV = array("А","Б","В","Г","Д","Ђ","Е","Ж","З","И","Ј","К","Л","Љ","М","Н","Њ","О","П","Р","С","Т","Ћ","У","Ф","Х","Ц","Ч","Џ","Ш","1","2","3","4","5","6","7","8","9","0",".");
            for($i = 0;$i < count($kIme); $i++){
                $check = false;
                for($j=0;$j<41;$j++){
                    if($kIme[$i] == $cirilicaM[$j] or $kIme[$i] == $cirilicaV[$j]){
                        $check = true;
                        break;
                    }
                    if($i == count($kIme)-1 and !$check){
                        if($kIme[$i] == " "){
                            $check = true;
                        }
                    }
                }
                if(!$check){
                    return true;
                }
            }
            return false;
        }

        public static function mergePSArray($string){ //spoji u string niz od preg_split
            $tmp = array();
            $tmp[0] = $string[0];
            for($i=1;$i<count($string);$i++){
                $tmp[$i] .= $string[$i];
            }
            return $tmp;
        }

        public static function invalidEmail($email){
            if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                return true;
            } else{
                return false;
            }
        }

        private static function str_contains_number($string){
            $brojNiz = array("1","2","3","4","5","6","7","8","9","0");
            for($i=0;$i<strlen($string);$i++){
                for($j=0;$j<10;$j++){
                    if($string[$i] == $brojNiz[$j]){
                        return true;
                    }
                }
            }
            return false;
        }

        public static function str_contains_alpha($string){
            $latinicaM = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z");
            $latinicaV = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
            for($i=0;$i<strlen($string);$i++){
                for($j=0;$j<26;$j++){
                    if($string[$i] == $latinicaM[$j] or $string[$i] == $latinicaV[$j]){
                        return true;
                    }
                }
            }
            return false;
        }

        public static function str_contains_signup($string,$what){
            for($i=0;$i<strlen($string);$i++){
                if($string[$i] == $what){
                    return true;
                }
            }
            return false;
        }

        public static function invalidPassword($password){
            if(strlen($password) >= 4 and strlen($password) <= 32){
                if(self::str_contains_signup($password,".") or self::str_contains_signup($password,",")){
                    if(self::str_contains_number($password)){
                        if(self::str_contains_alpha($password)){
                            return false;
                        } else{
                            return true;
                        }
                    } else{
                        return true;
                    }
                } else{
                    return true;
                }
            } else{
                return true;
            }
        }

        public static function passwordsMatch($pass1,$pass2){
            if($pass1 === $pass2){
                return true;
            } else{
                return false;
            }
        }

        public static function p_split_array2string($array){
            $string = $array[0];
            for($i = 1; $i < count($array); $i++){
                $string .= $array[$i];
            }
            return $string;
        }

        public static function usernameExists($con,$kIme){
            $sql = "SELECT id FROM korisnici WHERE korisnicko_ime=?";
            $stmt = $con->stmt_init();
            if(!$stmt->prepare($sql)){
                header('HTTP/1.0 400 Bad stmt error');
                exit();
            } else{
                $stmt->bind_param("s",$kIme);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();
                if($result->fetch_assoc()){
                    return true;
                } else{
                    return false;
                }
            }
        }

        public static function createUser($con,$ime,$prezime,$kIme,$email,$password){
            $sql = 'INSERT INTO korisnici (email,
                                            ime,
                                            prezime,
                                            korisnicko_ime,
                                            sifra,
                                            salt,
                                            datum_registracije,
                                            verifikovan,
                                            ssid)
                                     VALUES(?,?,?,?,?,?,?,\'n\',?);';
            $stmt = $con->stmt_init();
            if(!$stmt->prepare($sql)){
                header('HTTP/1.0 400 Bad stmt error');
                exit();
            } else{
                $salt = md5(time().$email);
                $ime = rtrim(self::p_split_array2string($ime)," ");
                $prezime = rtrim(self::p_split_array2string($prezime)," ");
                $kIme = rtrim(self::p_split_array2string($kIme)," ");
                $sifra = password_hash($salt.$password.$salt,PASSWORD_DEFAULT);
                $datum_reg = date("Y/m/d");
                $ssid = md5(time().$ime.$prezime);
                $stmt->bind_param("ssssssss",$email,$ime,$prezime,$kIme,$sifra,$salt,$datum_reg,$ssid);
                $stmt->execute();
                $stmt->close();
                $sql = "INSERT INTO ver VALUES(?,?);";
                $stmt = $con->stmt_init();
                if(!$stmt->prepare($sql)){
                    header('HTTP/1.0 400 Bad stmt error');
                    exit();
                } else{
                    $vkey = md5($email.time().$datum_reg);
                    $id = self::getUserId($con,$email);
                    $stmt->bind_param("ss",$id,$vkey);
                    $stmt->execute();
                    $stmt->close();
                    include_once '../../classes/phpMailer/vendor/autoload.php';
                    $mail = new PHPMailer();
                    $mail->CharSet = 'UTF-8';
                    $mail->Encoding = 'base64';
                    $mail->SMTPDebug = 0;
                    $mail->isSMTP();
                    $mail->Host = 'mail.muharemovic.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = '';
                    $mail->Password = '';
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;

                    $mail->setFrom('verify@muharemovic.com','Верификација');
                    $mail->addAddress($email);

                    $mail->isHTML(true);
                    $mail->Subject = 'Верификујте свој налог на skolskabiblioteka.muharemovic.com';
                    $mail->Body  = 'Покренута је регистрација налога на skolskabiblioteka.muharemovic.com <br>';
                    $mail->Body .= 'Ако ово нисте били Ви, игноришите овај мејл. Уколико јесте, притисните ово дугме';
                    $mail->Body .= ' како бисте довршили регистрацију свог налога и потврдили своју мејл адресу. <br>';
                    $mail->Body .= '<a href="https://skolskabiblioteka.muharemovic.com/p/mailver?vkey='.$vkey.'">Притисните овде за потврду</a>';
                    $mail->send();
                    return true;
                }
            }
        }

        public static function sendVerifyMail($con,$id,$email){
            $sql = "SELECT vkey FROM ver WHERE id=?;";
            $stmt = $con->stmt_init();
            if(!$stmt->prepare($sql)){
                header('HTTP/1.0 400 bad stmt error');
                exit();
            } else{
                $stmt->bind_param("i",$id);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();
                $inf = $result->fetch_assoc();
                $vkey = $inf["vkey"];
                include_once '../../classes/phpMailer/vendor/autoload.php';
                    $mail = new PHPMailer();
                    $mail->CharSet = 'UTF-8';
                    $mail->Encoding = 'base64';
                    $mail->SMTPDebug = 0;
                    $mail->isSMTP();
                    $mail->Host = 'mail.muharemovic.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = '';
                    $mail->Password = '';
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;

                    $mail->setFrom('verify@muharemovic.com','Верификација');
                    $mail->addAddress($email);

                    $mail->isHTML(true);
                    $mail->Subject = 'Верификујте свој налог на skolskabiblioteka.muharemovic.com';
                    $mail->Body  = 'Покренута је регистрација налога на skolskabiblioteka.muharemovic.com <br>';
                    $mail->Body .= 'Ако ово нисте били Ви, игноришите овај мејл. Уколико јесте, притисните ово дугме';
                    $mail->Body .= ' како бисте довршили регистрацију свог налога и потврдили своју мејл адресу. <br>';
                    $mail->Body .= '<a href="https://skolskabiblioteka.muharemovic.com/p/mailver?vkey='.$vkey.'">Притисните овде за потврду</a>';
                    $mail->send();
                    return true;
            }
        }

        public static function checkVkey($con,$vkey){
            $sql = "SELECT id FROM ver WHERE vkey=?;";
            $stmt = $con->stmt_init();
            $id = -1;
            if(!$stmt->prepare($sql)){
                header('HTTP/1.0 400 bad stmt error');
                exit();
            } else{
                $stmt->bind_param("s",$vkey);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();
                $inf = $result->fetch_assoc();
                if($inf){
                    $id = (int)$inf["id"];
                    $sql = "UPDATE korisnici SET verifikovan='y' WHERE id=?;";
                    $stmt = $con->stmt_init();
                    if(!$stmt->prepare($sql)){
                        header('HTTP/1.0 400 bad stmt error');
                        exit();
                    } else{
                            $stmt->bind_param("i",$id);
                            $stmt->execute();
                            $stmt->close();
                            $sql = "DELETE FROM ver WHERE id=? AND vkey=?;";
                            $stmt = $con->stmt_init();
                            if(!$stmt->prepare($sql)){
                                header('HTTP/1.0 400 bad stmt error');
                                exit();
                            } else{
                                $stmt->bind_param("is",$id,$vkey);
                                $stmt->execute();
                                $stmt->close();
                                return 1;
                            }
                        }
                } else{
                    return 0;
                }
            }
        }

        public static function setForgottenPass($con,$id,$email){
            $sql = "SELECT datum_isteka FROM forgot_pass WHERE id=?;";
            $stmt = $con->stmt_init();
            if(!$stmt->prepare($sql)){
                header('HTTP/1.0 400 bad stmt error');
                exit();
            } else{
                $stmt->bind_param("i",$id);
                $stmt->execute();
                $result = $stmt->get_result();
                $inf = $result->fetch_assoc();
                $stmt->close();
                if($inf){
                    $sql = "DELETE FROM forgot_pass WHERE id=?;";
                    $stmt = $con->stmt_init();
                    if(!$stmt->prepare($sql)){
                        header('HTTP/1.0 400 bad stmt error');
                        exit();
                    } else{
                        $stmt->bind_param("i",$id);
                        $stmt->execute();
                        $stmt->close();
                    }
                }
                        $sql = "INSERT INTO forgot_pass VALUES(?,?,?,date_add(DATE_FORMAT(NOW(),\"%Y/%m/%d %H:%i:%s\"), INTERVAL 15 MINUTE));";
                        $stmt = $con->stmt_init();
                        if(!$stmt->prepare($sql)){
                            header('HTTP/1.0 400 bad stmt error');
                            exit();
                        } else{
                            $fkey = md5($email.time());
                            $auth = md5(password_hash($email.time(),PASSWORD_DEFAULT).time());
                            $stmt->bind_param("iss",$id,$fkey,$auth);
                            $stmt->execute();
                            $stmt->close();
                            include_once '../../classes/phpMailer/vendor/autoload.php';
                            $mail = new PHPMailer();
                            $mail->CharSet = 'UTF-8';
                            $mail->Encoding = 'base64';
                            $mail->SMTPDebug = 0;
                            $mail->isSMTP();
                            $mail->Host = 'mail.muharemovic.com';
                            $mail->SMTPAuth = true;
                            $mail->Username = '';
                            $mail->Password = '';
                            $mail->SMTPSecure = 'tls';
                            $mail->Port = 587;

                            $mail->setFrom('verify@muharemovic.com','Школска библиотека');
                            $mail->addAddress($email);

                            $mail->isHTML(true);
                            $mail->Subject = 'Захтев за промену шифре на skolskabiblioteka.muharemovic.com';
                            $mail->Body  = 'Покренут је захтев за промену шифре на сајту skolskabiblioteka.muharemovic.com <br>';
                            $mail->Body .= 'Ако ово нисте били Ви, игноришите овај мејл. Уколико јесте, притисните ово дугме';
                            $mail->Body .= ' како бисте могли да промените своју шифру.<br>Овај код истиче за 15 минута.';
                            $mail->Body .= '<a href="https://skolskabiblioteka.muharemovic.com/p/fpass?fkey='.$fkey.'&auth='.$auth.'">Притисните овде за промену шифре</a>';
                            $mail->send();
                            return true;
                        }
            }
            
        }

        public static function checkFpass($con, $fkey, $auth){
            $sql = "SELECT id,datum_isteka FROM forgot_pass WHERE fkey=? AND auth=?;";
            $stmt = $con->stmt_init();
            if(!$stmt->prepare($sql)){
                header('HTTP/1.0 400 bad stmt error');
                exit();
            } else{
                $stmt->bind_param("ss",$fkey,$auth);
                $stmt->execute();
                $result = $stmt->get_result();
                $inf = $result->fetch_assoc();
                $stmt->close();
                if($inf){
                    if($inf["datum_isteka"] < date("Y-m-d H:i:s")){
                        $sql = "DELETE FROM forgot_pass WHERE fkey=? AND auth=?;";
                        $stmt = $con->stmt_init();
                        if(!$stmt->prepare($sql)){
                           header('HTTP/1.0 400 bad stmt error');
                            exit(); 
                        } else{
                            $stmt->bind_param("ss",$fkey,$auth);
                            $stmt->execute();
                            $stmt->close();
                        }
                        return -2;
                    } else{
                        return 1;
                    }
                } else{
                    return -1;
                }
            }
        }

        public static function auth_verify_fpass($fkey,$auth){
            if($_SESSION["fpass-verify"]["fkey"] == $fkey and $_SESSION["fpass-verify"]["auth"] == $auth){
                return true;
            } else{
                return false;
            }
        }

        public static function change_passFpass($con,$newPass,$fk,$au){
            $sql = "SELECT id FROM forgot_pass WHERE fkey=? AND auth=?;";
            $stmt = $con->stmt_init();
            $id = -1;
            if(!$stmt->prepare($sql)){
                header('HTTP/1.0 400 bad stmt err');
                exit();
            } else{
                $stmt->bind_param("ss",$fk,$au);
                $stmt->execute();
                $result = $stmt->get_result();
                $inf = $result->fetch_assoc();
                $stmt->close();
                $id = (int)$inf["id"];
                $sql = "UPDATE korisnici SET salt=?,sifra=? WHERE id=?;";
                $stmt = $con->stmt_init();
                if(!$stmt->prepare($sql)){
                    header('HTTP/1.0 400 bad stmt err');
                    exit();
                } else{
                    $salt = md5(time().$fk);
                    $sifra = password_hash($salt.$newPass.$salt,PASSWORD_DEFAULT);
                    $stmt->bind_param("ssi",$salt,$sifra,$id);
                    $stmt->execute();
                    $stmt->close();
                    $sql = "DELETE FROM forgot_pass WHERE id=?;";
                    $stmt = $con->stmt_init();
                    if(!$stmt->prepare($sql)){
                        header('HTTP/1.0 400 bad stmt err');
                        exit();
                    } else{
                        $stmt->bind_param("i",$id);
                        $stmt->execute();
                        $stmt->close();
                        $email = self::getUserEmail($con,$id);
                        include_once '../../classes/phpMailer/vendor/autoload.php';
                            $mail = new PHPMailer();
                            $mail->CharSet = 'UTF-8';
                            $mail->Encoding = 'base64';
                            $mail->SMTPDebug = 0;
                            $mail->isSMTP();
                            $mail->Host = 'mail.muharemovic.com';
                            $mail->SMTPAuth = true;
                            $mail->Username = '';
                            $mail->Password = '';
                            $mail->SMTPSecure = 'tls';
                            $mail->Port = 587;

                            $mail->setFrom('verify@muharemovic.com','Школска библиотека');
                            $mail->addAddress($email);

                            $mail->isHTML(true);
                            $mail->Subject = 'Промењена шифра на skolskabiblioteka.muharemovic.com';
                            $mail->Body  = 'Обавештавамо Вас да је на сајту skolskabiblioteka.muharemovic.com успешно промењена шифра.<br>';
                            $mail->Body .= 'Ако ово нисте били Ви, одмах пријавите проблем нашој подршци.<br>';
                            $mail->Body .= 'Шифра је промењена са следеће IP адресе: <strong>'.$_SERVER["REMOTE_ADDR"].'</strong>';
                            $mail->send();
                            return true;
                    }
                }
            }
        }

    }
