<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

$mail = new PHPMailer(true);

try {                  
    $mail->isSMTP();                                        
    $mail->Host       = 'smtp.gmail.com';                   
    $mail->SMTPAuth   = true;                               
    $mail->Username   = 'private24112003@gmail.com';             
    $mail->Password   = 'xezdqrufqibaqszr';                 
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;                                

    $mail->setFrom('private24112003@gmail.com');
    $mail->isHTML(true);
    $mail->Subject = 'Password Reset';
    $mail->addReplyTo('no-reply@gmail.com');

    $mail->send();
} catch (Exception $e) {}

?>

