<?php
    switch($_REQUEST['type']) {
        case "name": {
            if(preg_match("/^[a-zA-Z\s]+$/", $_REQUEST['value'])) {
                echo 1;
            } else {
                echo 0;
            }
            break;
        }

        case "email": {
            if(str_contains($_REQUEST['value'], "@") && str_contains($_REQUEST['value'], ".") && !str_contains($_REQUEST['value'], " ")) {
                echo 1;
            } else {
                echo 0;
            }
            break;
        }

        case "password": {
            if(preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[+@!$#])[0-9-a-z-A-Z+@!$#]{8,}$/", $_REQUEST['value'])) {
                echo 1;
            } else {
                echo 0;
            }
            break;
        }

        case "contact": {
            if(preg_match("/^[6789][0-9]{9}$/", $_REQUEST['value'])) {
                echo 1;
            } else {
                echo 0;
            }
            break;
        }
    }
?>