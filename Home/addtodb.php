<?php
    $email = $_REQUEST['email'];
    $name = $_REQUEST['name'];
    $title = $_REQUEST['title'];
    $quantity = $_REQUEST['quantity'];
    $data = array();
    $connection = new mysqli("localhost","root","","neel") or die("Connection failed: " . $connection->connect_error);
    if($quantity != 0){
        $result = $connection->query("SELECT * FROM cart where title='$title' and email='$email'");
        $row = $result->fetch_assoc();
        if($row){
            $connection->query("UPDATE cart set quantity=$quantity where title='$title' and email='$email'");
        }
        else{
            $connection->query("INSERT INTO cart VALUES('$email','$name','$title',$quantity);") or die("Error Inserting data in table: " . mysqli_error($connection));
        }
    }
    else{
        $connection->query("DELETE FROM cart WHERE email = '$email' and title = '$title';");
    }
    $result = $connection->query("SELECT * FROM cart WHERE email = '$email';");
    while($row = $result->fetch_assoc()){
        $data[] = $row;
    }
    echo count($data);
?>