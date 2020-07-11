<?php

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
    echo "</table>";
    
    
}


//Get it to delete the particular element in the directive table
//  if(isset($_GET['document']) == "delete"){
//     $query = "DELETE FROM directive WHERE ";id number tied from js delete value+1
//     $result = $conn->query($query);
//     if(!$result)
//     echo "<p>Cannot delete from database</p>" ;
// } 


$conn->close();
}


function addRecord($databaseName){ //in the other script add addRecord('directive)
  include_once 'login.php';

  //Add if Delete Element was set
 
  if(isset($_GET['submit']) && !($_GET['submit']== '')){
    $description = sanitizeString($conn, $_GET['description']);
    $party =  sanitizeString($conn, $_GET['party']);
    $directiveDate = sanitizeString($conn, $_GET['directiveDate']);
    $meetingNum = sanitizeString($conn, $_GET['meetingNumber']);
    $directiveDeadline = sanitizeString($conn, $_GET['directiveDeadline']);
    $revertDate = sanitizeString($conn, $_GET['revertDate']);
    $remark = sanitizeString($conn, $_GET['remark']);
    $status = sanitizeString($conn, $_GET['status']);
    $keyNumber = sanitizeString($conn, $_GET['keyNumber']);

    $sql = $conn->prepare("INSERT INTO '$databaseName'('Directive Description', 'Action Party', 'Directive Date', 'NTB Meeting Number', 'Directive Deadline', 'Revert Date', 'Remark', 'Status Update', 'Key Number') VALUES(?,?,?,?,?,?,?,?,?)");
    $sql->bind_param('ssiiiissi', $description, $party, $directiveDate, $meetingNum, $directiveDeadline, $revertDate, $remark, $status, $keyNumber);
    $sql->execute();
    

    if(!$sql){
      echo "<b class='derror'>Unable to enter values into database</b><br>";
    }else{
      echo "<b>Added to database</b>";
    }
    
  } else{
    echo "<b class='derror'>Enter a Value: from the Server</b><br>";
  }
 // $sql->close();
 function sanitizeString($server, $var)
{
if (get_magic_quotes_gpc())
$var = mysqli_real_escape_string($server, $var);
$var = stripslashes($var);
$var = strip_tags($var);
$var = htmlentities($var);
return $var;
}
}


 



/*
function {
 after all codes

 ShowDatabase("directives");
 Refresh/show the table, but check without this code first
} 
*/
?>