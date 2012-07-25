<?php
//Judas Gutenberg January 2006
//provides a web front end admin tool for any mysql db
//this page appears in popup to confirm row deletes as well as to allow more options
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
	//$olderror=error_reporting(0);
	$mode=$_REQUEST[qpre . "mode"];
	$idfield=$_REQUEST[qpre . "idfield"];
	$id=$_REQUEST[qpre . "iddefault"];
	$strTable=$_REQUEST[qpre . "table"];
	$strTheirTable=$_REQUEST[qpre . "theirtable"];
	$strDatabase=deMoronizeDB(gracefuldecay($_REQUEST[qpre . "db"],our_db));
	$strColumn=$_REQUEST[qpre . "column"];
	$strDirection=$_REQUEST[qpre . "direction"];
	$strConfigBehave=$_REQUEST[qpre . "behave"];
	$rec=$_REQUEST[qpre . "rec"];
	error_reporting($olderror);
	$strPHP=$_SERVER['PHP_SELF'];
	$out="";
	if ($rec=="")
	{
		$rec=0;
	}
	//echo $id . " " .$idfield ;
	$out=LoginDecisions($strDatabase,  $strPHP, $strUser, true);
	if ($strUser!="")
	{

		$intAdminType= AdministerType($strDatabase, $strTable, $strUser);
		
		if ($intAdminType>1)
			{
			 	
				$out.= deleteconfirm();
			}
	}

	return $out;
}


function deleteconfirm()
{

}
 
?>