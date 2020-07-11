<?php

//This file is to control all the functions that displays on our database
if (isset($_GET['document']) == "table" ){
ShowDatabase('directive');
}

if ($_GET['document'] == 'addvalue'){
    addRecord('directive');
}
?>