<?php
    function login($username, $password) {
        $conn = new mysqli("localhost","root","","neel");
        $result = $conn -> query('SELECT * FROM users where email="'.$username.'" and password ="'.$password.'"');
        $row = $result -> fetch_assoc();
        return $row;
    }
?>