<?php // sqltest.php
require_once 'login.php';
$conn = new mysqli($db_hostname, $db_username, $db_password);
if ($conn->connect_error) die('Error Loading Database');

mysqli_select_db($conn, $db_database) or die("Unable to select database: " . mysqli_error());
if (isset($_POST['delete']) && isset($_POST['isbn']))
{
$isbn = get_post($conn, 'isbn');
$query = "DELETE FROM classics WHERE isbn='$isbn'";
$result = $conn->query($query);
if (!$result) echo "DELETE failed<br><br>";
}
if (isset($_POST['author']) &&
isset($_POST['title']) &&
isset($_POST['type']) &&
isset($_POST['year']) &&
isset($_POST['isbn']))
{
$author = get_post($conn, 'author');
$title = get_post($conn, 'title');
$type = get_post($conn, 'type');
$year = get_post($conn, 'year');
$isbn = get_post($conn, 'isbn');
$query = "INSERT INTO classics VALUES" .
"('$author', '$title', '$type', '$year', '$isbn')";
$result = $conn->query($query);
if (!$result) echo "INSERT failed<br><br>";
}
echo <<<_END
<form action="sqltest.php" method="post"><pre>
Author <input type="text" name="author">
Title <input type="text" name="title">
Type <input type="text" name="type">
Year <input type="text" name="year">
ISBN <input type="text" name="isbn">
<input type="submit" value="ADD RECORD">
</pre></form>
_END;
$query = "SELECT * FROM classics";
$result = $conn->query($query);
if (!$result) die ("Database access failed");
$rows = $result->num_rows;
for ($j = 0 ; $j < $rows ; ++$j)
{
$row = $result->fetch_array(MYSQLI_NUM);
$r0 = htmlspecialchars($row[0]);
$r1 = htmlspecialchars($row[1]);
$r2 = htmlspecialchars($row[2]);
$r3 = htmlspecialchars($row[3]);
$r4 = htmlspecialchars($row[4]);
echo <<<_END
<pre>
Author $r0
Title $r1
Category $r2
Year $r3
ISBN $r4
</pre>
<form action='sqltest.php' method='post'>
<input type='hidden' name='delete' value='yes'>
<input type='hidden' name='isbn' value='$r4'>
<input type='submit' value='DELETE RECORD'></form>
_END;
}
$result->close();
$conn->close();
function get_post($conn, $var)
{
return $conn->real_escape_string($_POST[$var]);
}
?>