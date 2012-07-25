<?php
//Judas Gutenberg February 2007
//recent raw sql queries

include('core_functions.php');
include('coretablecreation.php');

echo main();

function main()
{
	if(!IsExtraSecure())
	{
		die(ExtraSecureFailure());
	}
	
	//$olderror=error_reporting(0);

	$strDatabase=deMoronizeDB(gracefuldecay($_REQUEST[qpre . "db"],our_db));
	$strPHP=$_SERVER['PHP_SELF'];
	$out="";

	//echo $id . " " .$idfield ;
	$out=LoginDecisions($strDatabase,  $strPHP, $strUser, true);
	if ($strUser!="")
	{
	
		$intAdminType= AdministerType($strDatabase, $strTable, $strUser);
		
		if ($intAdminType>1)
			{
			 	if ($_REQUEST["clear"]=="true")
				{
					$sql=conDB();
					$strSQL="DELETE FROM " . $strDatabase . "." .tfpre . "sqllog";
					$records = $sql->query($strSQL);
				}
				$out.= RecentSQL($strDatabase, 0, 50);
			}
	}
	$out =  PageHeader($strDatabase . " : Foreign Referrals", $strConfigBehave) . $out . PageFooter();
	
	return $out;
}

	
function  RecentSQL($strDatabase, $start, $count)
{
	$sql=conDB();
	if(!TableExists($strDatabase, tfpre . "sqllog"))
	{
	
		echo MakeSQLLogTable($strDatabase);
	}
	$strLineClass="bgclassline";
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strOtherBgClass="bgclassother";
	$strOtherLineClass="bgclassline";
	$strThisBgClass=$strClassFirst;
	$strSQL="SELECT * FROM " . $strDatabase . "." .tfpre . "sqllog ORDER BY sqllog_id DESC LIMIT " . $start . "," . $count ;
	$records = $sql->query($strSQL);
 	echo sql_error();
	$out.="<span class=\"heading\">Recent SQL queries </span> (<a href=\"recentsql.php?clear=true\">clear</a>)";
	$out.= "<table border=\"0\" cellspacing=\"1\" cellpadding=\"2\" class=\"" .$strLineClass  . "\"  >\n";
 
	foreach($records as $record)
	{
		
		$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
		$strSQL=$record["sql_string"];
		$strSQLForJS= str_replace("'", "^", $strSQL) ;
		$strSQLForJS= str_replace(chr(34), "\\" . chr(34), $strSQLForJS) ;
		$strPHPText=$record["php_script"];
		
		$strPHPText= str_replace("'", "^", $strPHPText) ;
		$strPHPText= str_replace(chr(34), "\\" . chr(34), $strPHPText) ;
		//echo $strPHPText;
		$out.=htmlrow($strThisBgClass,   "<a href='javascript:sqlhandback(\"" . $strSQLForJS . "\",\"" . $strPHPText . "\")'>" . $strSQL . "</a>");
	
	}
	$out.= "</table>";
	return $out;
}
?>