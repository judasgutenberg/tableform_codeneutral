<?php
//Judas Gutenberg January 2006
//provides a web front end admin tool for any mysql db
//this page appears in an iframe to show links to rows in  tables to which the parent table is foreign
//i've modified txtsql to be aware of foreign keys so this tool can dynamically build complicated tools
//This code is covered under the GNU General Public License
//info here: http://www.gnu.org/copyleft/gpl.html
//the digest is as follows: you cannot modify this code without
//publishing your source code under the same license
//contact the developer at gus@asecular.com  http://asecular.com

include('core_functions.php');

echo main();

function main()
{
	
	if(!IsExtraSecure())
	{

	}
	//$olderror=error_reporting(0);
	$mode=$_REQUEST[qpre . "mode"];

	$strDatabase=deMoronizeDB(gracefuldecay($_REQUEST[qpre . "db"],our_db));

	$strPHP=$_SERVER['PHP_SELF'];
	$out="";
	if ($rec=="")
	{
		$rec=0;
	}
	//echo $id . " " .$idfield ;
	$out.=   GetAndClean("homesteaddata.htm");
	$out =  PageHeader($strDatabase . " : Foreign Referrals", $strExtrajs) . $out . PageFooter();
	
	return $out;
}





?>