<?php
   $conn = new mysqli("localhost","root","","neel");
   $conn -> query('delete from data where title="'.$_REQUEST['title'].'"');
?>