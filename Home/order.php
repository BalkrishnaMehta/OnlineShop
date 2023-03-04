<?php
    session_start();
    $conn = new mysqli("localhost","root","","neel");
    $result = $conn -> query('SELECT * FROM cart where email="'.$_SESSION['username'].'"');
    $conn -> query('DELETE FROM cart where email="'.$_SESSION['username'].'"');
    while($row = $result -> fetch_assoc()) {
        $conn -> query('INSERT INTO orders values("'.$row['email'].'","'.$row['name'].'","'.$row['title'].'", "'.$row['quantity'].'")');
    }
?>