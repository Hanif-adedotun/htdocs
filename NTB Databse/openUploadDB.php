<?php

//call the upload functions for the table

include 'tableNames.php';

$errorMessage = "<br><b class='derror'>One or more fields are empty</b><br>";


if (!empty($_POST['description'])){
    addRecord($table1);//To add a field to the database
  }
else if(!empty($_POST['SBU/CSUID'])){
  addRecord2($table2);//To add a field to the database
}
else if(!empty($_POST['DirectiveID'])){
  addRecord3($table3);
}
else if(!empty($_POST['Department'])){
   addRecord4($table4);
}
else{
     echo $errorMessage;
}

?>