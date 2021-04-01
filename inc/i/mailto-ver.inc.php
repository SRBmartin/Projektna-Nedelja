<?php 
    use PHPMailer\PHPMailer\PHPMailer;
    include_once "ss.inc.php";
    if(isset($_SESSION["x-mailto-vkey"]) and isset($_SESSION["x-mailto-email"]) and !isset($_SESSION["korisnik"])){
        include_once '../../classes/phpMailer/vendor/autoload.php';
                    $vkey = $_SESSION["x-mailto-vkey"];
                    $email = $_SESSION["x-mailto-email"];
                    unset($_SESSION["x-mailto-vkey"]);
                    unset($_SESSION["x-mailto-email"]);
                    $mail = new PHPMailer();
                    $mail->CharSet = 'UTF-8';
                    $mail->Encoding = 'base64';
                    $mail->SMTPDebug = 0;
                    $mail->isSMTP();
                    $mail->Host = 'mail.muharemovic.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'muharemo';
                    $mail->Password = 'QiIe764fm4';
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
    } else{
        header('HTTP/1.0 404 Not found');
        exit();
    }