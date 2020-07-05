<?php

$db_hostname = 'localhost';
  $db_database = 'ntb directive register';
  $db_username = 'hanif';
  $db_password = 'hanif_mysql';
  
  $conn = new mysqli($db_hostname, $db_username, $db_password);
  
  mysqli_select_db($conn, $db_database) or die('Unable to load Databse');
    
  if($conn->connect_error)
    echo 'Cannot connect to Server, check connection' . mysqli_error();

?>