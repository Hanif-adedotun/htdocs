<?php
//The file for all the relationships in the NTB Database

include 'login.php'; //Connect to database
include 'tableNames.php';//Import table names


//$sql = "SELECT `SBU/CSU Abbreviation`,`Directorate Name`,`SBU-CSU Name full`, `Directorate ID` FROM `$table3`  LEFT JOIN `$table2` ON `SBU/CSU Abbreviation` = `SBU/CSU ID` ORDER BY `Directorate ID`";

$sql = "SELECT `Directorate Name`, `SBU/CSU Abbreviation`, `SBU-CSU Name full` FROM `$table2`, `$table3` WHERE `$table2`.ID = `$table3`.`Directorate ID`";

//$sql = "UPDATE `$table3` SET  `Directorate ID` REFERENCES `$table2`(ID) ON DELETE CASCADE CONSTRAINT registration_key PRIMARY KEY (registration_id, license_id)";

//LEFT JOIN `$table2` USING(`ID`)
// $sql = "ALTER TABLE `$table2` AUTO_INCREMENT = 1";
// NATURAL JOIN `$table2`

//SELECT `SBU/CSU Abbreviation` FROM `$table3`

$resultNew = $conn->query($sql);

if(!$resultNew){
  echo '<b>Cannot carry out query</b><br>';
  echo $conn->error;

}else{
    echo 'successfull<br>';

    echo "<table class='tables' border='1' >";

while($optionRow=mysqli_fetch_array($resultNew, MYSQLI_NUM)){//while the rows are available in the database
   echo "<tr>";
    foreach ($optionRow as $option){//to render each value to the option tag
     
      echo '<td>'.$option.'</td>';

     }
    echo "</tr>";
  }
  echo '</ul>';
 echo "</table>";
}
?>