<?php
    session_start();
    $conn = new mysqli("localhost","root","","neel");
    $result = $conn -> query('SELECT * from users where email="'.$_REQUEST['email'].'"');
    $row = $result -> fetch_assoc();
    $conn -> close();
    if($row) {
        include('../../Assets/modules/phpmailer/sendmail.php');
        $otp = rand(100000, 999999);
        $_SESSION['otp'] = $otp;
        $_SESSION['id'] = $_REQUEST['email'];
        $mail->addAddress($_REQUEST['email']);
        $mail->Body = 'Your OTP for password reset request is <b>'.$otp.'</b>';
        $mail->send();
        echo 1;
    } else {
        echo 0;
    }
?>