<?php
//Judas Gutenberg Dec 15 2007
//
//allows us to look at PHP libaries and see what the functions are, how big they are, what params they take
//
//This code is covered under the GNU General Public License
//info here: http://www.gnu.org/copyleft/gpl.html
//the digest is as follows: you cannot modify this code without
//publishing your source code under the same license
//contact the developer at gus@asecular.com  http://asecular.com

include('core_functions.php');
include('meta_functions.php');
include('coretablecreation.php');
echo main();
 

function main()
{
	//$olderror=error_reporting(0);
	$mode=$_REQUEST[qpre . "mode"];
	$strDatabase=deMoronizeDB(gracefuldecay($_REQUEST[qpre . "db"],our_db));
	$strTable=$_REQUEST[qpre . "table"];
	$strPHP=$_SERVER['PHP_SELF'];
	$strFilename= $_REQUEST[qpre."filename"] ;
	$out="";


	$out.=LoginDecisions($strDatabase,  $strPHP, $strUser, false);
	if ($strUser!="")
	{
	
		$intAdminType= AdministerType($strDatabase, $strTable, $strUser);
		
		if ($intAdminType>1)
			{
				if($mode=="reference")
				{
					$out.=PopulatePHPFunctionReferenceTable($strDatabase);
				}
				else
				{
					$out.=ScanPHPLibrary($strDatabase, $strFilename, $strPHP);
				}
			}
	}
	$out=  PageHeader($strDatabase . " : library tools", $strConfigBehave) . $out . PageFooter();
	
	return $out;
}


	
	
?>