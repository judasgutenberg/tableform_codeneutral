<?php
//Judas Gutenberg September 2008
//copies records from one table to another based on a saved regime of column links
//This code is covered under the GNU General Public License
//info here: http://www.gnu.org/copyleft/gpl.html
//the digest is as follows: you cannot modify this code without
//publishing your source code under the same license
//contact the developer at gus@asecular.com  http://asecular.com

 
include('tf_functions_backup.php');
include('tf_functions_core.php');
include('tf_functions_frontend_db.php');
include('tf_core_table_creation.php'); 

echo main();

function main()
{
	if(!IsExtraSecure())
	{
		die(ExtraSecureFailure());
	}
 
 
 
	//a merge is a regime where fields from the source table are copied into blank fields in the rows of the destination table
	//based on a match of a foreign key in the source table to a primary key in the destination table
	$strDatabase=deMoronizeDB(gracefuldecay($_REQUEST[qpre . "db"],our_db));
	//$quotecontent=false;
	$strPHP=$_SERVER['PHP_SELF'];
	$supressheaders=false;
	$strTitle="databases";
	$out=LoginDecisions($strDatabase,  $strPHP, $strUser, $supressheaders);
	if ($strUser!="")
	{
		$intAdminType= AdministerType($strDatabase, $strTable, $strUser);
		
		if ($intAdminType>1)
		{
			
			$out.= adminbreadcrumb(false );
		
		 
			$out.= PickDatabases();
			$out =  PageHeader($strTitle,  "") .   $out .  PageFooter();
			return $out;
			}
	}
}

function PickDatabases()
{
	//TableDropdown($strDatabase, $strDefaultTable, $strTableFormName, $strOurFormName='BForm', $strFieldFormName="")
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
 
	$sql=conDB();
 	$strSQL="SHOW DATABASES";
	$records = $sql->query($strSQL);
	//$strTabledropdown2=TableDropdown($strDatabase, $strTable2, qpre . "table2",  '', "");
	$out="<form name=\"BForm\" action=\"tf_databases.php\" method=\"post\">\n";
	$preout= "<script src=\"tf_tablesort.js\"><!-- --></script>";
	 
	$out.=htmlrow("+" . "bgclassline", "<a href=\"javascript: SortTable('idsorttable', 0)\">database</a>" , "<a href=\"javascript: SortTable('idsorttable', 1)\">number of tables</a>");

	foreach($records as $record)
	{
		$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
		$strDatabase=$record["Database"];
		$out.=htmlrow($strThisBgClass, "<a href=\"tf.php?" . qpre . "db=" . $strDatabase . "\">" . $record["Database"] . "</a>",  DatabaseTableInfo($strDatabase,  "count"));
	}
 
 
	$out.="</form>\n";
	$out=$preout . TableEncapsulate($out);
 
	return $out;
}



function DatabaseTableInfo($strDatabase, $strType="count")
{
	$sql=conDB();
	if($strType=="count");
	{
		$strSQL="SELECT count(TABLE_SCHEMA) as 'thisinfo' FROM information_schema.TABLES WHERE TABLE_SCHEMA='" . $strDatabase . "'";
	}
	$records = $sql->query($strSQL);
	//echo $strSQL . "<br>";
	//echo mysql_error();
	$record =$records[0];
	return $record["thisinfo"];
}
?>