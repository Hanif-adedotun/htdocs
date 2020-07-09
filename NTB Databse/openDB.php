<?php

//This file is to control all the functions that displays on our database
ShowDatabase('directive');

if ($_GET['document'] == 'addvalue'){
    addRecord('directive');
}
?>