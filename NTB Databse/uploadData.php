<?php

require 'openUploadDB.php'; //Control the functions in this file

function sanitizeString($server, $var){
    
  $var = mysqli_real_escape_string($server, $var);
  $var = stripslashes($var);
  $var = strip_tags($var);
  $var = htmlentities($var);
  return $var;
  }


function addRecord($databaseName){ //in the other script add addRecord('directive)
  require_once 'login.php';
  require 'tableNames.php';
  include_once 'recordError.php';//function that cointains error file 
  
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
      $conn->query("START TRANSACTION");

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
      echo "Added to database";
      
      echo "The id number of " .$party." is " .$sbu_id;
      echo "<br><b>The id for the new row is " . mysqli_insert_id($conn). "</b>";
     
      //COMMIT
      $conn->query("COMMIT");
    } 
    catch (\Throwable $th) {
      //ROLLBACK
      $conn->query("ROLLBACK");

      $error = $conn->errno . ' ' . $conn->error ;
      recordError($error);//record error to error.log file
      recordError($th);//record error to error.log file
      echo "Unable to enter values into database";
      
      
    }
     
    
  $conn->close();

}
function addRecord2($databaseName){

  require_once 'login.php';
  require 'tableNames.php';
  include_once 'recordError.php';//function that cointains error file 

  
  $DirectName = sanitizeString($conn, $_POST['DirectorateName']);
  $SBUID = sanitizeString($conn, $_POST['SBU/CSUID']);

  try {
      //START TRANSACTION;
      $conn->query("START TRANSACTION");

      $sql = $conn->prepare("INSERT INTO `$databaseName`(`Directorate Name`, `SBU/CSU ID`) VALUES(?,?)");
      $sql->bind_param('ss', $DirectName, $SBUID);
      $sql->execute();//insert into directorate table
      $table2_id = mysqli_insert_id($conn);//insert id of the value in directorate table


      $sql2 = "SELECT `Directorate ID` FROM `$table3` WHERE `SBU/CSU Abbreviation`= '$SBUID'";//To get the id number of sbu/csu to add it to the table last column
      $result = $conn->query($sql2);
      while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
        foreach($row as $row_value){
          $Directorate_id = $row_value;//id number of sbu/csu to join tables
        }
      }
      
      if ($Directorate_id == NULL){//if the value of the sbu/csu is null, ask dad for details

        if ($table2_id != 0){//as long as the value has been inserted in the directorate table
          //Update the sbu/csu table to add the directorate id
        $sql =  "UPDATE `$table3` SET `Directorate ID` = '$table2_id' WHERE `SBU/CSU Abbreviation` = '$SBUID'";
        $result = $conn->query($sql);
        
        echo "Added to database";

        //COMMIT
        $conn->query("COMMIT");
        }
      }

   
  } 
  catch (\Throwable $th) {
    //ROLLBACK
    $conn->query("ROLLBACK");

    $error = $conn->errno . ' ' . $conn->error ;
    recordError($error);//record error to error.log file
    recordError($th);//record error to error.log file

    echo "Unable to enter values into database";
  }



}

function addRecord3($databaseName){
  require_once 'login.php';
  include_once 'recordError.php';//function that cointains error file 
  include 'tableNames.php';

  //START TRANSACTION;
  $conn->query("START TRANSACTION");

  $DirectorateName = sanitizeString($conn, $_POST['SBU/CSUAbbreviation']);
  $SBUFullName = sanitizeString($conn, $_POST['SBUFullName']);
  $HeadofSBU = sanitizeString($conn, $_POST['HeadofSBU']);
  $Name = sanitizeString($conn, $_POST['Name']);


  try {
    $sql = "SELECT `ID` FROM `$table2` WHERE `SBU/CSU ID` = '$DirectorateName'";
    $resultNew = $conn->query($sql);
    $row = mysqli_fetch_array($resultNew, MYSQLI_ASSOC);
    $option = $row['ID'];

    if (empty($option)){//if the sbu does not exist in the directorate table, it adds the value of NULL 

      $sql = $conn->prepare("INSERT INTO `$databaseName`(`SBU/CSU Abbreviation`, `SBU-CSU Name full`, `Head of SBU`, `Name`) VALUES(?,?,?,?)");
      $sql->bind_param('ssss', $DirectorateName, $SBUFullName, $HeadofSBU, $Name);
      $sql->execute();
      echo "Added to database";
      
    }else{//if it exists, it gets the id number and add its to the last row
     $sql = $conn->prepare("INSERT INTO `$databaseName`(`SBU/CSU Abbreviation`, `SBU-CSU Name full`, `Head of SBU`, `Name`, `Directorate ID`) VALUES(?,?,?,?,?)");
    $sql->bind_param('ssssi', $DirectorateName, $SBUFullName, $HeadofSBU, $Name, $option);
    $sql->execute();
    echo "Added to database";
    }

    
    

     //COMMIT
     $conn->query("COMMIT");
  } 
  catch (\Throwable $th) {
    //ROLLBACK
    $conn->query("ROLLBACK");

    $error = $conn->errno . ' ' . $conn->error ;
    recordError($error);//record error to error.log file
    recordError($th);//record error to error.log file
    
    echo "Unable to enter values into database";
  }


}
function addRecord4($databaseName){

  require_once 'login.php';
  include_once 'recordError.php';//function that cointains error file 
 
  //START TRANSACTION;
  $conn->query("START TRANSACTION");
 
  $FullName = sanitizeString($conn, $_POST['Fullname']);
  $Department = sanitizeString($conn, $_POST['Department']);

  try {
    $sql = $conn->prepare("INSERT INTO `$databaseName`(`Full name`, `Department`) VALUES(?,?)");
    $sql->bind_param('ss', $FullName, $Department);
    $sql->execute();
    echo "Added to database";
    
    //COMMIT
    $conn->query("COMMIT");

  } 
  catch (\Throwable $th) {
    //ROLLBACK
    $conn->query("ROLLBACK");

    $error = $conn->errno . ' ' . $conn->error ;
    recordError($error);//record error to error.log file
    recordError($th);//record error to error.log file
    
    echo "Unable to enter values into database";
  }

}
?>