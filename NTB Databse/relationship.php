<?php
//The file for all the relationships in the NTB Database

include 'login.php'; //Connect to database
include 'tableNames.php';//Import table names


$sql = "SELECT * FROM (`$table3`) NATURAL JOIN (`$table2`) ON `$table3.SBU/CSU Abbreviation` = `$table2.SBU/CSU ID`";

// FROM schools_left AS lt LEFT JOIN schools_right AS rt
// ON lt.id = rt.id;

//SELECT `SBU/CSU Abbreviation` FROM `$table3`
// 

$resultNew = $conn->query($sql);

if(!$resultNew){
  echo '<b>Cannot carry out query</b><br>';
  echo $conn->error;

}else{
  echo '<ul>';

while($optionRow=mysqli_fetch_array($resultNew, MYSQLI_NUM)){//while the rows are available in the database
  
    foreach ($optionRow as $option){//to render each value to the option tag
     
      echo '<li>'.$option.'</li>';

     }
    
  }
  echo '</ul>';
}
?>