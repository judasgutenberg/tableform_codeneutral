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
	$type=$_REQUEST[qpre . "type"];
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
					$strSQL="DELETE FROM " . $strDatabase . "." .tfpre . "scriptlog WHERE type='" . $type .  "'";
					$records = $sql->query($strSQL);
				}
				$out.= RecentScript($strDatabase, 0, 50, $type);
			}
	}
	$out =  PageHeader($strDatabase . " : Script", $strConfigBehave, "", true, true) . $out . PageFooter(true, false, true);
	
	return $out;
}

	
function  RecentScript($strDatabase, $start, $count, $type="sql")
{
	$sql=conDB();
	$strTable="scriptlog";
	if(!TableExists($strDatabase, tfpre . $strTable))
	{
	
		echo MakeScriptLogTable($strDatabase);
	
	}
	$postscript="post_script";
	$prescript="pre_script";

	$strLineClass="bgclassline";
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strOtherBgClass="bgclassother";
	$strOtherLineClass="bgclassline";
	$strThisBgClass=$strClassFirst;
	//NEED TO INCLUDE TYPE!!
	$strSQL="SELECT * FROM " . $strDatabase . "." .tfpre . $strTable . " WHERE type='" . $type ."' ORDER BY scriptlog_id DESC LIMIT " . $start . "," . $count ;
	$records = $sql->query($strSQL);
 	echo sql_error();
	$out.="<span class=\"heading\">Recent " . strtoupper($type) . " queries </span> (<a href=\"recentscript.php?" . qpre . "type=" . $type . "&clear=true\">clear</a>)";
	$out.= "<table border=\"0\" cellspacing=\"1\" cellpadding=\"2\" class=\"" .$strLineClass  . "\"  >\n";
 
	foreach($records as $record)
	{
		
		$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
		$strSQL=$record[$prescript];
		$strScriptForJS= str_replace("'", "^", $strSQL) ;
		$strScriptForJS= str_replace(chr(34), "\\" . chr(34), $strScriptForJS) ;
		$strPHPText=$record[$postscript];
		
		$strPHPText= str_replace("'", "^", $strPHPText) ;
		$strPHPText= str_replace(chr(34), "\\" . chr(34), $strPHPText) ;
		//echo $strPHPText;
		$out.=htmlrow($strThisBgClass,   "<a href='javascript:scripthandback(\"" . $strScriptForJS . "\",\"" . $strPHPText . "\")'>" . $strSQL . "</a>");
	
	}
	$out.= "</table>";
	return $out;
}
?>