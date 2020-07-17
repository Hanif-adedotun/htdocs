<?php

addRecord('directive');//To add a field to the database

function addRecord($databaseName){ //in the other script add addRecord('directive)
  include_once 'login.php';
  // error_reporting(E_ALL);
  // ini_set('display_errors', 1);
 
function sanitizeString($server, $var){
    
$var = mysqli_real_escape_string($server, $var);
$var = stripslashes($var);
$var = strip_tags($var);
$var = htmlentities($var);
return $var;
}

    $description = sanitizeString($conn, $_POST['description']);
    $party =  sanitizeString($conn, $_POST['party']);
    $directiveDate = $_POST['directiveDate'];
    $meetingNum = sanitizeString($conn, $_POST['meetingNumber']);
    $directiveDeadline = $_POST['directiveDeadline'];
    $revertDate = $_POST['revertDate'];
    $remark = sanitizeString($conn, $_POST['remark']);
    $status = sanitizeString($conn, $_POST['status']);
    $keyNumber = sanitizeString($conn, $_POST['keyNumber']);

    try {
      $sql = $conn->prepare("INSERT INTO `$databaseName`(`Directive Description`, `Action Party`, `Directive Date`, `NTB Meeting Number`, `Directive Deadline`, `Revert Date`, `Remark`, `Status Update`, `Key Number`) VALUES(?,?,?,?,?,?,?,?,?)");
      $sql->bind_param('sssissssi', $description, $party, $directiveDate, $meetingNum, $directiveDeadline, $revertDate, $remark, $status, $keyNumber);
      $sql->execute();
      echo "<b id='successful' >Added to database</b>";
    } 
    catch (\Throwable $th) {
      $error = $conn->errno . ' ' . $conn->error ;
      echo $error;
      echo "<br><b class='derror'>Unable to enter values into database</b><br>";
    }
     
    
  $conn->close();
 
}

?>