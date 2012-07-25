<?php
require("scriptheader.php");
?>

<?php
$article_id=$_REQUEST["ID"];
$strSQL="SELECT *, u.ID as AUTHOR_ID  FROM article a LEFT JOIN USERS u ON a.AUTHOR_ID=u.ID  WHERE a.ACTIVE=1 AND a.ID=" . intval($article_id);
$out="";
//echo $strSQL;
$records = $sql->query($strSQL);
echo mysql_error();
$record=$records[0];
?>
<html>
<head>
<title><?=$record["TITLE"]?> : Featurewell.com</title>
</head>
<body>
<?php
$authorname=$record["FIRST_NAME"] . " " .  $record["LAST_NAME"];
$catname=GenericDBLookup(our_db,"CATEGORY", "ID", $record["CATEGORY_ID"], "NAME");
//echo "<div style='position:absolute;top:463px;left:200px;'>";

echo "<h4><i>This story is protected by copyright and may be used only after purchase from Featurewell.com.</i></h4>";
echo "<h3>(Featurewell.com: " . $catname. ")</h3>";
echo "<h2>" . strtoupper($record["TITLE"] ). "</h2>";
echo "<h3><i>" .strtoupper( "by " .  $authorname). "</i></h3>";
//echo "</div>";
echo "<br  />";
echo "<div><b>" .$record["NOTES"]. "</b></div>";
echo "<br  />";
echo  "<div>"  . fw_textprocess($record["TEXT"]) . "</div>";
echo  "<div>* * *</div>";
echo  "<h2>Also by "  . $authorname . ":</h2>";

$strSQL="SELECT   a.ID as ARTICLE_ID,  a.CATEGORY_ID, a.TITLE, a.NOTES, a.SUBJECT, u.FIRST_NAME, u.LAST_NAME   FROM article a JOIN USERS u ON a.AUTHOR_ID=u.ID  WHERE a.AUTHOR_ID =" .intval($record["AUTHOR_ID"]) . " AND a.ACTIVE=1 ORDER BY a.TIMESTAMP DESC LIMIT 0, 10";
//echo $strSQL;
$arecords = $sql->query($strSQL);
 
foreach($arecords as $arecord)
{
	if($article_id!=$arecord["ARTICLE_ID"])
	{
		echo "<div><a href='article.php?ID=" . $arecord["ARTICLE_ID"] . "'>" . strtoupper($arecord["TITLE"] ). "</a> " . $arecord["SUBJECT"] . "</div>\n\n";
	}
}
 
$price= FWPrice($user["ID"], $article_id);

?>
 </body>
 </html>