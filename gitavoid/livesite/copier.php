<?php
$strPathPre="tf/";
$urlroot="http://www.featurewell.com/";
include($strPathPre . "tf_constants.php");
include($strPathPre . "tf_functions_core.php");
include($strPathPre . "tf_functions_editor.php");
include($strPathPre . "tf_functions_frontend_db.php");
$errorlevel=error_reporting(0);
	include("editor_files/config.php");
	include("editor_files/editor_class.php");
error_reporting($errorlevel);


 


function main()
{
	GLOBAL $db_type;
	if(!IsExtraSecure())
	{
		die(ExtraSecureFailure());
	}
 	
	//$olderror=error_reporting(0);
	//$mode=$_REQUEST[qpre . "mode"];
	$strDatabase="dbo";
	$strColumn=$_REQUEST[qpre . "column"];
	$comprehensivesearch=gracefuldecaynumeric($_REQUEST[qpre . "comprehensivesearch"],0);
	error_reporting($olderror);
	$strPHP=$_SERVER['PHP_SELF'];
	$strValDefault=$_REQUEST["ID"];
	$strTable="article";
	$out="";
	//echo $id . " " .$idfield ;
	$out=LoginDecisions($strDatabase,  $strPHP, $strUser, true);
	$db_type= 'odbc';
 echo db_type;
	if ($strUser!="")
	{
	
		$intAdminType= AdministerType($strDatabase, $strTable, $strUser);
 
		if ($intAdminType>1)
		{
			
			if($strTable==""  || $strValDefault=="")
			{
		
				$records=odbc_query("select * from 	article where id<600" );
				$out.=GenericRSDisplayFromRS($strPHP,"old way", $records, 1, 999);
			}
			else
			{
				
				$out.=TableForm("dbo", $strTable, "ID", $strValDefault, $strPHP,  "","", "",  "", "", "", "odbc");
			}
			//$records=odbc_DBExplain("dbo", "article");
			//$out.=GenericRSDisplayFromRS($strPHP,"old way", $records, 1, 999);
			//echo count($records);
			//foreach($records as $record)
			{
				//$out.=GenericRSDisplayFromRS($strPHP,"old way", $record, 1, 999);
			}
		}
		
	}
	$out =  PageHeader($strDatabase . " : mssql browser", $strConfigBehave) . $out . PageFooter();
	//echo $out;
	return $out;
}

 

	
	

    ?>