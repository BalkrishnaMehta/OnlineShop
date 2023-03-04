<?php
    $conn = new mysqli("localhost","root","","neel");
    $conn -> query('delete from orders where name="'.$_REQUEST['name'].'"');
?>