<?php //login.php
$db_hostname = 'localhost';
$db_database = 'publications';
$db_username = 'hanif';
$db_password = 'hanif_mysql';

$conn = new mysqli($db_hostname, $db_username, $db_password);
if ($conn->connect_error) die('Error Loading Database');

mysqli_select_db($conn, $db_database) or die("Unable to select database: " . mysqli_error());
?>