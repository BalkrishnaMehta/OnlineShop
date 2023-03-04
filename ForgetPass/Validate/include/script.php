<?php
    session_start();
    if($_REQUEST['otp'] == $_SESSION['otp']) {
        $conn = new mysqli("localhost","root","","neel");
        $result = $conn -> query('UPDATE users SET Password="'.$_REQUEST['passwordc'].'" where Email="'.$_SESSION['id'].'"');
        $conn -> close();
        session_unset();
        echo 1;
    } else {
        echo 0;
    }
?>