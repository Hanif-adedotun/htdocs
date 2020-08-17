<?php

//call the upload functions for the table

include 'tableNames.php';

$errorMessage = "<br><b class='derror'>SERVER: One or more fields are empty</b><br>";

if(!empty($_POST['DatabaseName'])){//provided the database key is not empty 

  if ($_POST['DatabaseName'] == $table1){
    addRecord($table1);//To add a field to the database
  }
else if($_POST['DatabaseName'] == $table2){
  addRecord2($table2);//To add a field to the database
}
else if($_POST['DatabaseName'] == $table3){
  addRecord3($table3);
}
else if($_POST['DatabaseName'] == $table4){
   addRecord4($table4);
}
}
else{
     echo $errorMessage;
}

?>