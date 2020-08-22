<?php
//The file for all the relationships in the NTB Database

require 'login.php'; //Connect to database
require 'tableNames.php';//Import table names



//$sql = "SELECT `SBU/CSU Abbreviation`,`Directorate Name`,`SBU-CSU Name full`, `Directorate ID` FROM `$table3`  LEFT JOIN `$table2` ON `SBU/CSU Abbreviation` = `SBU/CSU ID` ORDER BY `Directorate ID`";

//$sql = "SELECT `Directorate Name`, `SBU/CSU Abbreviation`, `SBU-CSU Name full` FROM `$table2`, `$table3` WHERE `$table2`.ID = `$table3`.`Directorate ID`";

//$sql = "SELECT `Directive Description`, `Action Party`, `SBU-CSU Name full` FROM `$table1`, `$table3` WHERE `$table1`.`SBU/CSU ID` = `$table3`.ID";

//$sql = "ALTER TABLE `$table3` ADD FOREIGN KEY (`Directorate ID`) REFERENCES `$table2` (ID)"; //Use once only

//$sql = "ALTER TABLE `$table3` DROP FOREIGN KEY	`sbu/csu table_ibfk_3`"; //to drop a foreign key

// $sql = "ALTER TABLE `$table2` AUTO_INCREMENT = 1"; CArry out after delete query



$tables_array = array($table1, $table2, $table3, $table4);

//$writeToFile = fopen('Database.txt', 'w') or die('Unable to open file');

//foreach($tables_array as $value){

//$sql = "SHOW CREATE table `$table1`";


// $sql = "START TRANSACTION";
// $conn->query($sql);

//$sql = "UPDATE `$table2` SET `Directorate name` = `Voltex Oil and Cylinder` WHERE `Directorate name` = `Voltex Oil and Gas`";


$sql = "SELECT `ID` FROM `$table2` WHERE `SBU/CSU ID` = 'Aramco'";
$resultNew = $conn->query($sql);


if(!$resultNew){
  echo '<b>Cannot carry out query</b><br>';
  //echo $conn->error;
  include_once 'recordError.php';
  recordError($conn->error);
  

}else{
  
    
  //echo '<br><b>'.$value.'</b>';
   // echo 'Successful';

//     echo "<table class='tables' border='1' >";

//     $info = $resultNew->fetch_fields();
   
//     //show table headers
//     echo "<tr>";
//     foreach ($info as $val){
//         echo "<td><b>" .$val->name . "</b></td>";
//     }
//     echo "</tr>";  

  $optionRow=mysqli_fetch_array($resultNew, MYSQLI_ASSOC);//while the rows are available in the database
//   $res = $optionRow[0]; 
//   echo "<tr>";
     //foreach ($optionRow as $option){//to render each value to the option tag
     $option = $optionRow['ID'];

      if (!empty($option)){
        echo $option;
        
      }else{
        echo 'There is no id number';
      }

//       echo '<td>'.$option.'</td>';
      
   
//   echo "</tr>";
  

 //}
// echo "</table>";
}
//}

$conn->close();

?>