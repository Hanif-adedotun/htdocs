<?php
//This is the function file to show all Database
include 'openDB.php';

function ShowDatabase($databaseName){

include_once 'login.php'; //To connect to database, it will connect only once, call in other functions also
  
$query = "SELECT * FROM `$databaseName`";
$result = $conn->query($query);

if (!$result){
echo "<b class='derror'>Server: Cannot see database with name (". $databaseName . ")";
echo "<br>Error: " . $conn->error . "</b>";

}else{
    
  
    //  function selectDB(){
    //    $database2 = 'sbu/csu table';
    //    include_once 'login.php';
    //    $sql = "SELECT `SBU/CSU Abbreviation` FROM `$database2`";
    //    $resultNew = $conn->query($sql);
    //    if(!$resultNew) 
    //    echo '<b class="derror">Cannot see SBU database</b>';
    //  }
  
  
   echo "<h2>" .strtoupper($databaseName) . "</h2>";

    echo "<table class='tables' border='1' >";

    $info = $result->fetch_fields();
   
    //show table headers
    echo "<tr>";
    foreach ($info as $val){
        echo "<td class='thead'><b>" .$val->name . "</b></td>";
    }
    echo "</tr>"; 

    
   
    while($row=mysqli_fetch_array($result, MYSQLI_NUM)){//while all the rows are true
       
      $primaryKey = $row[0];

      echo "<tr>"; 
        
        for($i = 0; $i < mysqli_num_fields($result);){ //loop through the table to check is a particular field is a date
        
         foreach ($row as $value){ //To loop through each field and input the value
          
          // if ($databaseName == 'directive table'){

          // }

         //To check if value is a date
          $rtype = mysqli_fetch_field_direct($result, $i);//Check type of variable in a field
          if ($rtype->type == 10){ //10 is a date type
            echo "<td><input type='date' placeholder='yyyy-mm-dd' value ='" .$value. "'/></td>";
          } else{
            echo "<td>" . $value .  "</td>";
          }
           $i++;
         } 

        }
        //The delete button for each row in each table
        echo "<td contenteditable='false'><button value='". $primaryKey . "'class='delete' onmouseover='delTable(this.value, ".$databaseName."); return false' >Delete</button></td>";
       
    }
    echo "</tr>";
    echo "</table>";
    
}



$conn->close();
}


//Get it to delete the particular element in the a particular table
function delvalues($database, $position, $delkey){
  include_once 'login.php'; //To connect to database, it will connect only once, call in other functions also


$query = "DELETE FROM `$database` WHERE `$database`.`$position` = $delkey";//id number tied from js delete value
$result = $conn->query($query);
$consoleError = 'console.log("This executed")';
echo '<script>'. $consoleError . '</script>';

if(!$result){
  echo "<br><b class='derror'>Unable to delete row from database<br>";
  echo "Error description: ". $conn->error . "</b>";
 }
 else{
  echo '<b id="successful">Succesfully Deleted!</b>';
 }

$conn->close();
}







?>