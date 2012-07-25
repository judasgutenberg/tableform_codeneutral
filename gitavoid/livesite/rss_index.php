<?php
require("scriptheader.php");
require("frontendheader.php");

$article_id=$_REQUEST["ID"];

$strSQL="SELECT * FROM CATEGORY";

$out="";
//echo $strSQL;
$records = $sql->query($strSQL);
echo mysql_error();
 
?>

 


<?php
 
echo "<tr><td valign='top'>\n";
//echo "<div style='position:absolute;top:463px;left:200px;'>";
 
echo "<div class='taskheading'>(RSS Help)</div>";
 

 

echo "<div class='instructions'>" . GenericDBLookup(our_db,"content", "name", "RSS Help", "content") . "</div>";
 
echo "<br/>";
//echo "</div>";

echo "<div class='rsslinklist' ><a class='rsslinklist' href='rss.php'>Home</a> : " . "<a class='bottomlistlink' href='rss.php'>http://featurewell.com/rss.php</a></div>\n\n";

 
$arecords = $sql->query($strSQL);
 
foreach($records as $record)
{

	echo "<div style='padding-top:3px' class='rsslinklist' ><a class='rsslinklist' href='rss.php?c=" . $record["ID"] . "'>" .  $record["NAME"]  . "</a> : " . "<a class='bottomlistlink' href='rss.php?c=" . $record["ID"] . "'>http://featurewell.com/rss.php?c=" . $record["ID"] . "</a></div>\n\n";
	
}
echo "<BR>";
echo "</td></tr>\n";

 


 
?>

 

<?php
require("frontendfooter.php");
?>