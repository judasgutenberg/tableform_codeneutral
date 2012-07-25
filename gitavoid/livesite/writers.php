<?php
require("scriptheader.php");
require("frontendheader.php");

$thischarin=gracefuldecay($_REQUEST["c"], "A");
$ID=gracefuldecay($_REQUEST["ID"]);

$thischar =substr($thischar, 0, 1);











 

 
echo "<tr><td  valign='top'>\n";
//echo "<div class='leaftitle'>" . $record["title"] . "</div>";
echo "<div class='taskheading'>(Writers)</div>";
//echo "<div class='leafbyline'>" . "by " . $record["FIRST_NAME"] . " " .  $record["LAST_NAME"] . "</div>";

if($ID=="")
{
	$strSQL="SELECT FIRST_NAME, LAST_NAME, ID FROM USERS  WHERE    ACTIVE=1 AND ROLES LIKE '%A%' AND SUBSTRING(LAST_NAME, 1, 1)='" . $thischarin . "' ORDER BY LAST_NAME, FIRST_NAME";
	
	$out="";
	//echo $strSQL;
	$records = $sql->query($strSQL);
	$reccount=count($records);
	echo "<div class='alphaline'  >" ;
	$outcount=0;
	for($chr=0; $chr<26; $chr++)
	{
	
		$thischar=chr(intval(65+$chr)) ;
		if($thischar==$thischarin)
		{
			echo "<span class='alphanavon'  >" .$thischar  . "</a>\n";
		}
		else
		{
			echo "<a class='alphanav' href='writers.php?i=6&c=" . $thischar . "'>" .$thischar  . "</a>\n";
		}
	}
	echo "</div >" ;
	echo "<table width='100%'><tr><td valign='top'>\n";
	foreach($records as $record)
	{
	
		echo "<a class='writerlist' href='" . $homepage . "?i=6&w=" . $record["ID"] . "'>" . $record["FIRST_NAME"] . " " . $record["LAST_NAME"] . "</a><br>";
	
		$outcount++;
		if($outcount>($reccount/3))
		{
			echo "</td><td valign='top'>";
			$outcount=0;
		}
	}
	
	echo "</td></tr></table>\n";
}
else 
{

	
	
}
echo "</td></tr>\n";
?>













<?php
require("frontendfooter.php");
?>