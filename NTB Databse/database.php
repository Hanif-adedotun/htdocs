<?php

include 'login.php';

$conn = new mysqli($db_hostname, $db_username, $db_password);

mysqli_select_db($conn, $db_database) or die('Unable to load Databse');

if($conn->connect_error)
echo 'Cannot connect to Server, check connection' . mysqli_error();
 
$query = "SELECT * FROM directive";
$result = $conn->query($query);

if (!$result){
echo "Cannot see database";
}else{
    if (isset($_GET['document']) == "table" ? $_GET['document'] : "table"){

    echo "<table border='1' >";

    $info = $result->fetch_fields();

    echo "<tr>";
    foreach ($info as $val){
        echo "<td class='thead'><b>" .$val->name . "</b></td>";
    }
    echo "</tr>"; 
    
    
    
    while($row=mysqli_fetch_array($result, MYSQLI_ASSOC)){
        echo "<tr contenteditable='true'>";
        foreach ($row as $value){ 
            echo "<td>" . $value .  "</td>";

          /*foreach ($info as $val){
            if ($val->name == 'Directive Date' || $val->name == 'Directive Deadline' || $val->name == 'Revert Date'){
            echo "<td><input type='date' placeholder='yyyy-mm-dd' value ='" .$value. "'/></td>";
          }   */      
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
?>