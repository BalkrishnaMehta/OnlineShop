<?php
    $quantity = $_REQUEST['qty'];
    $title = $_REQUEST['title'];
    $email = $_REQUEST['email'];
    $connection = new mysqli("localhost","root","","neel") or die("Connection failed: " . $connection->connect_error);
    $connection->query("UPDATE cart set quantity=$quantity where title='$title' and email='$email'");
?>