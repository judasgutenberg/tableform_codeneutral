<?php
include("core_functions.php");
//This code is covered under the GNU General Public License
//info here: http://www.gnu.org/copyleft/gpl.html
//the digest is as follows: you cannot modify this code without
//publishing your source code under the same license
//contact the developer at gus@asecular.com  http://asecular.com

if(!IsExtraSecure())
{
	die(ExtraSecureFailure());
}

$strUser=WhoIsLoggedIn();
$strDatabase=deMoronizeDB(gracefuldecay($_REQUEST[qpre . "db"],our_db));
$strTable=$_REQUEST[qpre . "table"];
if (IsSuperUser($strDatabase, $strUser)  || ($_REQUEST["passcode"]=="spider12"  && !beginswith($strTable, "tf_")  ))
{
	$strWhereclause=$_REQUEST[qpre . "where"];
	$strXML= XMLselect(our_db, $strTable, $strWhereclause);
	$out= makeXMLNode(our_db, "", $strXML);
	header('Content-Type: text/xml');
	header("Content-Length: ". strlen($out));
	echo $out;
}

?>