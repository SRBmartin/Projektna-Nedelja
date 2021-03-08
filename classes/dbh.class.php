<?php
    class Dbh
    {
        private static $servername = "localhost";
        private static $username = "root";
        private static $password = "";
        private static $dbname = "projekat";

        //vGq~y(+W&8j5
        public static function connect()
        {
            $conn = new mysqli(self::$servername,self::$username,self::$password,self::$dbname);
            return $conn;
        }
    }