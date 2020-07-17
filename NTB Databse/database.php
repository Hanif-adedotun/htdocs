<?php
//This is the function file to show all Database
include 'openDB.php';

function ShowDatabase($databaseName){

include_once 'login.php'; //To connect to database, it will connect only once, call in other functions also
  
$query = "SELECT * FROM $databaseName";
$result = $conn->query($query);

if (!$result){
echo "Cannot see database";
}else{
    //? $_GET['document'] : "table" : to set it to document:table

    echo "<table class='tables' border='1' >";

    $info = $result->fetch_fields();
   
    //show table headers
    echo "<tr>";
    foreach ($info as $val){
        echo "<td class='thead'><b>" .$val->name . "</b></td>";
    }
    echo "</tr>"; 
    
    
   //show all rows
   //$k = 1;//This is for the delete function, to get each row to delete
    while($row=mysqli_fetch_array($result, MYSQLI_ASSOC)){
        echo "<tr contenteditable='true'>";
        
        for($i = 0; $i < mysqli_num_fields($result);){ //for date checker
        foreach ($row as $value){ 
          
         //To check if value is a date
          $rtype = mysqli_fetch_field_direct($result, $i);
          if ($rtype->type == 10){ //10 is a date type
            echo "<td><input type='date' placeholder='yyyy-mm-dd' value ='" .$value. "'/></td>";
          } else{
            echo "<td>" . $value .  "</td>";
          } $i++;
         } 

        }
        echo "<td contenteditable='false'><button value='". $value . "'class='delete' onclick='delTable(this.value); return false' >Delete</button></td>";
       
    }
    echo "</tr>";
    echo "</table>";
    
    
}



$conn->close();
}

//Get it to delete the particular element in the directive table


function delvalues($database, $position, $delkey){
  include_once 'login.php'; //To connect to database, it will connect only once, call in other functions also


$query = "DELETE FROM `$database` WHERE `$database`.`$position` = $delkey";//id number tied from js delete value
$result = $conn->query($query);

if(!$result){
  echo "<br><b class='derror'>Unable to delete row from database<br>";
  echo "Error description: ".$conn->error . "</b>";
  //check for the correct syntax of MariaDB sql delete 
 }
 else{
  echo '<b id="successful">Succesfully Deleted!</b>';
 }


$conn->close();
}







?>