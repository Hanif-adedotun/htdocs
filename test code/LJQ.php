<?php
require 'login.php';

echo <<<_END
<html>
<head><title>Database with PHP and Mysql</title></head>
<script type=text/javascript>
function refresh(){
    location.reload(true);
}
</script>
<body>
<form action='LJQ.php' method='post'>
<span>Enter Username: <input type='text' name='user'></span><br>
<span>Enter Password: <input type='password' name='pass'></span><br>
<input type='submit' onclick='refresh()' value='Enter'><br>
</form>
</body>
</html>
_END;


function showvalues(){
    require 'login.php';
    $query2 = "SELECT * FROM users";
       $result = $conn->query($query2);
       if (!$result) die("Fatal Error<br>");
    
    $rows = $result->num_rows;
    
    $info = mysqli_fetch_field_direct($result, 0);
    $info2 = mysqli_fetch_field_direct($result, 1);
    
    for($i=0; $i<$rows; ++$i)
    {
        $row = $result->fetch_array(MYSQLI_ASSOC);
    
        echo 'Username: '.htmlspecialchars($row['Username']).'<br>';
        echo 'Password: '.htmlspecialchars($row['Password']).'<br>';
        echo 'Type of username: ' .$info->type.'<br>';//type 10 == Date, 253 $ 254 == char
        echo 'Type of password: ' .$info2->type.'<br><br>';
    }
    }
showvalues();

if ((isset($_POST['user']) && isset($_POST['pass'])) && !($_POST['user']=='' || $_POST['pass']=='')){
    $username = $_POST['user'];
    $password = $_POST['pass'];
    $query = "INSERT INTO users VALUES" . "('$username', '$password')";
    $result = $conn->query($query);
   if(!$result){
    echo'Error writing to database<br>';
}
   else{
      echo'succssfully updated databse<br>';
}
}else{
    echo'Enter username or/and password<br><br>';
    
}

if (isset($_POST['delpass'])){
$deletepassword = $_POST['delpass'];
$delete = "DELETE FROM users WHERE Password='$deletepassword'";
$result = $conn->query($delete);

if(!$result){
 echo'Error deleting User<br>';
}
else{
   echo'Successfully deleted<br>';
}
} else
echo'Enter password to delete';

echo <<<_END
<form action='LJQ.php' method='post'>
<span> Delete User from password</span><br>
<span>Password: <input type='text' name='delpass'></span>
<input type='submit' onclick='refresh()' value='Delete User'>
</form>
_END;

?>