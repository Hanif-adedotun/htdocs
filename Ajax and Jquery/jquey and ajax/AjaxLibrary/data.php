<?php
header("Content-type: text/xml");
/*if ($_GET["data"] == "1")
$colors = array('Red', 'Green', 'Blue');
if ($_GET["data"] == "2")*/
$colors = array('Orange', 'Navy', 'Viridian');

/*Start writing to .xml file*/
echo '<?xml version="1.0" ?>';
echo '<colors>';
foreach ($colors as $value)
{
echo '<color>';
echo $value;
echo '</color>';
}
echo '</colors>';
?>