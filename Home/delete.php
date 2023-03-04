<?php
    $email = $_REQUEST['email'];
    $title = $_REQUEST['title'];
    $connection = new mysqli("localhost","root","","neel") or die("Connection failed: " . $connection->connect_error);
    $connection->query("DELETE FROM cart WHERE title = '$title' and email='$email';");
?>