<?php
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
                $stmt->bind_param("s",$email);
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
            if(self::userExists($con,$email)){
                if($id = self::getUserId($con, $email) !== -1){
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

    }