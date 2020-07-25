<?php

include 'openUploadDB.php'; //Control the functions in this file

function sanitizeString($server, $var){
    
  $var = mysqli_real_escape_string($server, $var);
  $var = stripslashes($var);
  $var = strip_tags($var);
  $var = htmlentities($var);
  return $var;
  }


function addRecord($databaseName){ //in the other script add addRecord('directive)
  include_once 'login.php';
  // error_reporting(E_ALL);
  // ini_set('display_errors', 1);
 


    $description = sanitizeString($conn, $_POST['description']);
    $party =  sanitizeString($conn, $_POST['party']);
    $directiveDate = $_POST['directiveDate'];
    $meetingNum = sanitizeString($conn, $_POST['meetingNumber']);
    $directiveDeadline = $_POST['directiveDeadline'];
    $revertDate = $_POST['revertDate'];
    $remark = sanitizeString($conn, $_POST['remark']);
    $status = sanitizeString($conn, $_POST['status']);


    try {
      $sql = $conn->prepare("INSERT INTO `$databaseName` (`Directive Description`, `Action Party`, `Directive Date`, `NTB Meeting Number`, `Directive Deadline`, `Revert Date`, `Remark`, `Status Update`) VALUES(?,?,?,?,?,?,?,?)");
      $sql->bind_param('sssissss', $description, $party, $directiveDate, $meetingNum, $directiveDeadline, $revertDate, $remark, $status);
      $sql->execute();
      echo "<b id='successful' >Added to database</b>";
    } 
    catch (\Throwable $th) {
      $error = $conn->errno . ' ' . $conn->error ;
      echo "<b class='derror'>" . $error;
      echo "<br>Unable to enter values into database</b><br>";
    }
     
    
  $conn->close();

}
function addRecord2($databaseName){

  include_once 'login.php';

  
  $DirectName = sanitizeString($conn, $_POST['DirectorateName']);
  $SBUID = sanitizeString($conn, $_POST['SBU/CSUID']);

  try {
    $sql = $conn->prepare("INSERT INTO `$databaseName`(`Directorate Name`, `SBU/CSU ID`) VALUES(?,?)");
    $sql->bind_param('ss', $DirectName, $SBUID);
    $sql->execute();
    echo "<b id='successful' >Added to database</b>";
  } 
  catch (\Throwable $th) {
    $error = $conn->errno . ' ' . $conn->error ;
    echo $error;
    echo "<br><b class='derror'>Unable to enter values into database</b><br>";
  }



}

function addRecord3($databaseName){
  include_once 'login.php';

 
  $DirectorateName = sanitizeString($conn, $_POST['DirectorateName']);
  $SBUFullName = sanitizeString($conn, $_POST['SBUFullName']);
  $HeadofSBU = sanitizeString($conn, $_POST['HeadofSBU']);
  $Name = sanitizeString($conn, $_POST['Name']);
  $DirectiveID = sanitizeString($conn, $_POST['DirectiveID']);

  try {
    $sql = $conn->prepare("INSERT INTO `$databaseName`(`SBU/CSU Abbreviation`, `SCU-SBU Name full`, `Head of SBU`, `Name`, `Directive ID`) VALUES(?,?,?,?,?)");
    $sql->bind_param('ssssi', $DirectorateName, $SBUFullName, $HeadofSBU, $Name, $DirectiveID);
    $sql->execute();
    echo "<b id='successful' >Added to database</b>";
  } 
  catch (\Throwable $th) {
    $error = $conn->errno . ' ' . $conn->error ;
    echo $error;
    echo "<br><b class='derror'>Unable to enter values into database</b><br>";
  }


}
function addRecord4($databaseName){

  include_once 'login.php';

 
  $FullName = sanitizeString($conn, $_POST['Fullname']);
  $Department = sanitizeString($conn, $_POST['Department']);

  try {
    $sql = $conn->prepare("INSERT INTO `$databaseName`(`Full name`, `Department`) VALUES(?,?)");
    $sql->bind_param('ss', $FullName, $Department);
    $sql->execute();
    echo "<b id='successful' >Added to database</b>";
  } 
  catch (\Throwable $th) {
    $error = $conn->errno . ' ' . $conn->error ;
    echo $error;
    echo "<br><b class='derror'>Unable to enter values into database</b><br>";
  }

}
?>