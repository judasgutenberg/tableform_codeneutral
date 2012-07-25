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

include('tf_functions_core.php');

echo main();

function main()
	{
	
		
		//$olderror=error_reporting(0);
		$mode=$_REQUEST[qpre . "mode"];
 
		$strPHP=$_SERVER['PHP_SELF'];
 		echo "-" . IsExtraSecure() . "-";
		die("<br>XX");
		$out=LoginDecisions($strDatabase,  $strPHP, $strUser, true);
		if ($strUser!="")
		{
	
			$intAdminType= AdministerType($strDatabase, $strTable, $strUser);
			
			if ($intAdminType>1)
				{
				 	
					$out.= main($strDatabase);
				}
		}
		$out =  PageHeader($strDatabase . " : Foreign Referrals", $strConfigBehave) . $out . PageFooter();
		
		return $out;
	}



?>