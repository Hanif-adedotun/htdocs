<?php

//This file is to control all the functions that displays on our database

if ($_GET['document'] == "table" ){
ShowDatabase('directive');
}

if($_GET['document'] == "delete"){
    delvalues('directive', 'Key Number', $_GET['deletekey']);
  } 
?>