<?php
require("scriptheader.php");
require("frontendheader.php");

$name=$_REQUEST["n"];

$strSQL="SELECT * FROM content  WHERE name='" . singlequoteescape($name) . "'";
$sql=conDB();
$out="";
//echo $strSQL;
$records = $sql->query($strSQL);
 
$record=$records[0];

 
echo "<tr><td  valign='top'>\n";
//echo "<div class='leaftitle'>" . $record["title"] . "</div>";
echo "<div class='taskheading'>(" . $record["title"] . ")</div>";
//echo "<div class='leafbyline'>" . "by " . $record["FIRST_NAME"] . " " .  $record["LAST_NAME"] . "</div>";
if($name!="xxaboutus")
{
	echo  "<div class='leafbody'>"  . fw_textprocess($record["content"]) . "</div>";
}
else
{
	echo  "<div class='leafbody'>"  . fw_textprocess($record["content"]) . "</div>";
}
echo "</td></tr>\n";
?>













<?php
require("frontendfooter.php");
?>