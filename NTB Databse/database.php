<?php
//This is the function file to show all Database
require 'openDB.php';//command to call each function

function SBUTable(){//To show the SBU Table Abbreviations
  require 'tableNames.php';//Import table names
  require 'login.php';//Connect to the database
  include_once 'recordError.php'; //Error file

  $sql = "SELECT `SBU/CSU Abbreviation`,`ID` FROM `$table3`";
  $resultNew = $conn->query($sql);
  if(!$resultNew) {
  echo '<b class="derror">Cannot see SBU database</b>';
  recordError($conn->error);//record error to error.log file
}

while($optionRow=mysqli_fetch_array($resultNew, MYSQLI_BOTH)){//while the rows are available in the database
  
    $sbu_abbreviation = $optionRow['SBU/CSU Abbreviation'];
    $sbu_id = $optionRow['ID'];
    
     echo '<option value='.$sbu_abbreviation.'>'.$sbu_id.' - '.$sbu_abbreviation.'</option>';//Show options in the values
  
 }
 
}

function ShowDatabase($databaseName){

require_once 'login.php'; //To connect to database, it will connect only once, call in other functions also
include_once 'recordError.php'; //Error file

$query = "SELECT * FROM `$databaseName`";
$result = $conn->query($query);

if (!$result){
echo "<b class='derror'>Server: Cannot see database with name (". $databaseName . ")";
recordError($conn->error);//record error to error.log file

}else{
  
   echo "<h2 id='".$databaseName."' class='dbnames'>" .strtoupper($databaseName) . "</h2>";

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

         //To check if value is a date
          $rtype = mysqli_fetch_field_direct($result, $i);//Check type of variable in a field
          if ($rtype->type == 10){ //10 is a date type
            echo "<td><input type='date' placeholder='yyyy-mm-dd' value ='" .$value. "'/></td>";
          } 
          // else if($rtype->name == 'Action Party'){//if the field name is action party
            
          //   echo "<td>";//create row
          //   echo '<select name="SBU/CSU" class="SBUCSU">';//create select element for each column
          //   SBUTable();//Call the values in option form.
          //   echo '</select>';
          //   echo "</td>";


          // }
          else{
            echo "<td>" . $value .  "</td>";
          }
            $i++;
         } 

        }
        //The delete button for each row in each table
        echo "<td contenteditable='false'><button  value='". $primaryKey . "'class='delete' onclick='delTable(this.value, `".$databaseName."`); return false;'>Delete</button></td>";
       
    }
    echo "</tr>";
    echo "</table>";
    
}



$conn->close();
}


//Get it to delete the particular element in the a particular table
function delvalues($database, $position, $delkey){
  require_once 'login.php'; //To connect to database, it will connect only once, call in other functions also
  include_once 'recordError.php';

try {
  
$query = "DELETE FROM `$database` WHERE `$database`.`$position` = $delkey";//id number tied from js delete value
$result = $conn->query($query);
echo 'Succesfully Deleted!';


} catch (\Throwable $th) {
  echo "Unable to delete row from database";

  //recordError($conn->error);//record error to error.log file
  recordError($th);//record error to error.log file
}

$conn->close();
}

?>