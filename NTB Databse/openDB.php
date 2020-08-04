<?php

//This file is to control all the functions that displays on our database

include 'tableNames.php';

//Open all the Tables in the database
if ($_GET['document'] == "table1" ){
ShowDatabase($table1);
}

if($_GET['document'] == "table2"){
  ShowDatabase($table2);
}

if($_GET['document'] == "table3"){
  ShowDatabase($table3);
}

if($_GET['document'] == "table4"){
  ShowDatabase($table4);
}

//Get SBU/CSU Values from the ShowDatabase
if($_GET['document'] == "SBUoptions"){
  SBUTable();
}

//Delete the tables
if($_GET['document'] == "delete"){
    delvalues($_GET['database'], 'ID', $_GET['deletekey']);
  } 
?>