<?php
include_once('tf_functions_core.php');
include_once('tf_core_table_creation.php');
$infunction=$_REQUEST["infunction"];
$search=$_REQUEST["search"];
$out.= "<script type=\"text/javascript\" src=\"tf_drawrelationships.js\"></script>\n";
$out.= "<script>\n";
$out.= "document.write(colortable('" . $infunction . "'));\n";
$out.= "</script>\n";
if($search!="" && $search!="undefined")
{
 
	$out.= "<form name='BForm' onsubmit='" .   $search . ";return false'>\n";
	$out.= "Pick a color, enter a search term, and then click \"search.\"<br>\n";
	$out.= "<input type=text name='search'>\n";
	$out.= "<input type=submit value='search'  > \n";
	$out.= "</form>\n";
 
}
$out.= "<div align='right'>[<a href='javascript:window.close()'>close window</a>]</div>";
$out=  PageHeader($strDatabase . " : color picker", $strConfigBehave, "", true, false, "", $strDatabase) . $out . PageFooter();
echo $out;

?>