<?php
    class Nalog
    {
        /**************************** LOGIN FUNKCIJE *************************/
        public static function emptyLogin($email,$password){
            if(empty($email)){
                if(!isset($_SESSION["login-error"])){
                    $_SESSION["login-error"] = array();
                }
                $_SESSION["login-error"]["email"] = "Нисте унели мејл."; 
            }
            if(empty($password)){
                if(!isset($_SESSION["login-error"])){
                    $_SESSION["login-error"] = array();
                }
                $_SESSION["login-error"]["password"] = "Нисте унели шифру."; 
            }
            if(isset($_SESSION["login-error"])){
                return true;
            } else{
                return false;
            }
        }

    }