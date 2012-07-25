<?php
//Gus Mueller January 2006
//provides a web front end admin tool for any mysql db
//i've modified txtsql to be aware of foreign keys so this tool can dynamically build complicated tools
//This code is covered under the GNU General Public License
//info here: http://www.gnu.org/copyleft/gpl.html
//the digest is as follows: you cannot modify this code without
//publishing your source code under the same license
//contact the developer at gus@asecular.com  http://asecular.com

include('tf_functions_core.php');

echo main();

function main()
{
	if(!IsExtraSecure())
	{
		die(ExtraSecureFailure());
	}
	$strTable=$_REQUEST[qpre . "table"];
	$strFieldFormName=$_REQUEST[qpre . "fieldformname"];
	$strDatabase=deMoronizeDB(gracefuldecay($_REQUEST[qpre . "db"],our_db));
	$out.="<html><body>";
	$out.="<form name=\"BForm\" method=\"post\">\n";
	$records=TableExplain($strDatabase, $strTable);
	foreach ($records as $k => $info )
	{
		$fields.=  $info["Field"] . " ";
 	}
	$fields=RemoveEndCharactersIfMatch($fields, " " );
	//$out.="<input type=\"hidden\" name=\"fields\" value=\"" . $fields . "\">\n";
	//$out.="</form>";
	//ookay, once we've loaded the fields into that hidden field, time to build a dropdown in the launcher window
	$out.="<script>\n";
	$out.="ourfields='" . $fields . "'\n";
	$out.="arrFields=ourfields.split(' ');\n";
	//$out.="alert(parent.document.BForm." . $strFieldFormName . ".type)\n";
	$out.="ourreturnfields='" . $strFieldFormName . "'\n";
	$out.="arrreturnfields=ourreturnfields.split(' ');\n";
	
	$out.="for(j=0; j<arrreturnfields.length; j++)\n";
	$out.="{\n";
	$out.="thisreturnfield=arrreturnfields[j]\n";
	$out.="parent.document.BForm[thisreturnfield].length=0\n";
	$out.="if(parent.document.BForm[thisreturnfield].type=='text')\n";
	$out.="{\n";
	$out.="parent.document.BForm[thisreturnfield].type='select';\n";
	$out.="}\n";
	//$out.="alert(parent.document.BForm." . $strFieldFormName . ".type)\n";
	$out.="for(i=0; i<arrFields.length; i++)\n";
	$out.="{\n";
	$out.="if(!parent.document.BForm[thisreturnfield][i])\n";
	$out.="{\n";
	$out.="parent.document.BForm[thisreturnfield].length++;\n";
	$out.="}\n";
	$out.="parent.document.BForm[thisreturnfield][i].text=arrFields[i];\n";
	$out.="parent.document.BForm[thisreturnfield][i].value=arrFields[i];\n";
	$out.="}\n";
	$out.="}\n";
	$out.="</script>\n";
	$out.="</body></html>\n";
	return $out;
}

?>