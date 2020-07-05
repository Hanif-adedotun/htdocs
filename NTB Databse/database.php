<?php

include 'openDB.php';

function ShowDatabase($databaseName){

include_once 'login.php'; //To connect to database, it will connect only once, call in other functions also
  
$query = "SELECT * FROM $databaseName";
$result = $conn->query($query);

if (!$result){
echo "Cannot see database";
}else{
    if (isset($_GET['document']) == "table" ? $_GET['document'] : "table"){

    echo "<table border='1' >";

    $info = $result->fetch_fields();
   
    //show table headers
    echo "<tr>";
    foreach ($info as $val){
        echo "<td class='thead'><b>" .$val->name . "</b></td>";
    }
    echo "</tr>"; 
    
    
   //show all rows
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
        echo "<td><button class='delete' onclick='delTable()' >Delete</button></td>";
       
    }
    echo "</tr>";
    }
    echo "</table>";
}


//Get it to delete the particular element in the directive table
//  if(isset($_GET['document']) == "delete"){
//     $query = "DELETE FROM directive WHERE ";
//     $result = $conn->query($query);
//     if(!$result)
//     echo "<p>Cannot delete from database</p>" ;
// } 


$conn->close();
}

/*
function addRecord(){
 after all codes

 ShowDatabase("directives");
 Refresh/show the table, but check without this code first
} 
*/
?>