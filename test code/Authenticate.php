<?php
require_once 'login.php';
$conn = new mysqli($db_hostname, $db_username, $db_password);
if ($conn->connect_error) die('Error Loading Database');

mysqli_select_db($conn, $db_database) or die("Unable to select database: " . mysqli_error());
$query = 'CREATE TABLE users(
    firstname VARCHAR(32) NOT NULL,
    surname VARCHAR(32) NOT NULL,
    username VARCHAR(32) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL, 
    )';

    $result = $conn->query($query);
    if(!$result) die('fatal error');

$firstname = 'Hanif';
$surname = 'Adedotun';
$username = 'voltex';
$password = 'v.mysql';
$hash = password_hash($password, PASSWORD_DEFAULT);

add_user($conn, $firstname, $surname, $username, $hash);

$firstname = 'Khairah';
$surname = 'Oyinade';
$username = 'kCrochete';
$password = 'k.db';
$hash = password_hash($password, PASSWORD_DEFAULT);
add_user($conn, $firstname, $surname, $username, $hash);

function add_user($conn, $fn, $sn, $un, $pw)
{
$stmt = $conn->prepare('INSERT INTO users VALUES(?,?,?,?)');
$stmt->bind_param('ssss', $fn, $sn, $un, $pw);
$stmt->execute();
$stmt->close();
}
?>