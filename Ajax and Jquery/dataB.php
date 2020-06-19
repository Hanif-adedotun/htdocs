<?php
require_once 'login.php';
$xml = <<< PROLOG
<?xml version='1.0' encoding='iso-8859-1'?>
PROLOG;
try{
$conn = new mysqli($db_hostname, $db_username, $db_password);

mysqli_select_db($conn, $db_database);
$query2 = "SELECT * FROM users";
   $result = $conn->query($query2);
   if (!$result){
     $xml .= '<err>Unable to select users</err>';
   } 

   $rows = $result->num_rows;
   $xml .= '<results>';
   
   for($i=0; $i<$rows; ++$i)
   {
    $row = $result->fetch_array(MYSQLI_ASSOC);
       
    $xml .= "<result>";
        $xml .= "<Username>{$row['Username']}</Username><br>";
        $xml .= "<Password>{$row['Password']}</Password>";
        $xml .= "</result>";
    }
    $xml .= '</results>';


}catch(Exception $e){
    $xml .= '<error>There was an error in retreiving users</error>';
}

header('Content-Type: text/xml');
echo $xml;
?>