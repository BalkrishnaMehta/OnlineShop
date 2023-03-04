<?php
        ini_set("display_errors", "1");
        if(!preg_match("/^[a-zA-Z\s]+$/", $_REQUEST['name'])) {
            echo 0;
        } else if(!(strpos($_REQUEST['email'], "@") !== false && strpos($_REQUEST['email'], ".") !== false && !strpos($_REQUEST['email'], " ") !== false)) {
            echo 0;
        } else if(!preg_match("/^[6789][0-9]{9}$/", $_REQUEST['contact'])) {
            echo 0;
        } else if(!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[+@!$#])[0-9-a-z-A-Z+@!$#]{8,}$/", $_REQUEST['password'])) {
            echo 0;
        }else  {
            $conn = new mysqli("localhost","root","","neel");
            $conn -> query("INSERT INTO users values('".$_REQUEST['name']."','".$_REQUEST['email']."','".$_REQUEST['contact']."','".$_REQUEST['password']."', 'User')");
            $conn -> close();
            echo 1;
        }

?>