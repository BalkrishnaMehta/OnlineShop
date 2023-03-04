<?php
    session_start();
    include('../../Assets/modules/accFetch.php');
    $row = login($_REQUEST['username'], $_REQUEST['password']);

    if($row) {
        $_SESSION['username'] = $_REQUEST['username'];
        setcookie("username",  $_REQUEST['username'], time() + 3600*24*30, "/");
        $_SESSION['password'] = $_REQUEST['password'];
        setcookie("password",  $_REQUEST['password'], time() + 3600*24*30, "/");
        echo $row['Role'];
    } else {
        echo 0;
    }
?>
