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
  include 'tableNames.php';
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
      
      //START TRANSACTION;
      $sql = "SELECT `ID` FROM `$table3` WHERE `SBU/CSU Abbreviation`= '$party'";//To get the id number of sbu/csu to add it to the table last column
      $result = $conn->query($sql);
      while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
        foreach($row as $row_value){
          $sbu_id = $row_value;//id number of sbu/csu to join tables
        }
      }

      $sql = $conn->prepare("INSERT INTO `$databaseName` (`Directive Description`, `Action Party`, `Directive Date`, `NTB Meeting Number`, `Directive Deadline`, `Revert Date`, `Remark`, `Status Update`, `SBU/CSU ID`) VALUES(?,?,?,?,?,?,?,?,?)");
      $sql->bind_param('sssissssi', $description, $party, $directiveDate, $meetingNum, $directiveDeadline, $revertDate, $remark, $status, $sbu_id);
      $sql->execute();
      echo "<b id='successful' >Added to database</b>";
    
      
      echo "The id number of " .$party." is " .$sbu_id;
      echo "<br><b>The id for the new row is " . mysqli_insert_id($conn). "</b>";
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
    // $sql = $conn->prepare("INSERT INTO `$databaseName`(`Directorate Name`, `SBU/CSU ID`) VALUES(?,?)");
    // $sql->bind_param('ss', $DirectName, $SBUID);
    // $sql->execute();

    echo mysqli_insert_id($conn) .' '. $SBUID;
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

 
  $DirectorateName = sanitizeString($conn, $_POST['SBU/CSUAbbreviation']);
  $SBUFullName = sanitizeString($conn, $_POST['SBUFullName']);
  $HeadofSBU = sanitizeString($conn, $_POST['HeadofSBU']);
  $Name = sanitizeString($conn, $_POST['Name']);


  try {
    $sql = $conn->prepare("INSERT INTO `$databaseName`(`SBU/CSU Abbreviation`, `SBU-CSU Name full`, `Head of SBU`, `Name`, `Directorate ID`) VALUES(?,?,?,?,?)");
    $sql->bind_param('sssss', $DirectorateName, $SBUFullName, $HeadofSBU, $Name, NULL);
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