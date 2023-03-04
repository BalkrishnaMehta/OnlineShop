<?php
    session_start();
    include('Assets/modules/accFetch.php');

    if(isset($_SESSION['username']) || isset($_COOKIE['username'])) {
        if(isset($_SESSION['password']) || isset($_COOKIE['password'])) {

            $username = (isset($_SESSION['username']))? $_SESSION['username']: $_COOKIE['username'];
            $password = (isset($_SESSION['password']))? $_SESSION['password']: $_COOKIE['password'];

            $row = login($username, $password);

            if($row['Role'] == 'Admin') {
                header('location: Admin/');
            } else {
                header('location: Home/');
            }
        }
    } else {
        header('location: Login/');
    }
?>