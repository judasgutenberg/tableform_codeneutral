<?php
$strPathPre="tf/";
$urlroot="http://www.featurewell.com/";
include($strPathPre . "tf_constants.php");
include($strPathPre . "tf_functions_core.php");
include($strPathPre . "tf_functions_editor.php");
include($strPathPre . "tf_functions_frontend_db.php");
include_once($strPathPre . "tf_functions_odbc.php");
echo   main();

 


function main()
{
	GLOBAL $db_type;
	if(!IsExtraSecure())
	{
		die("!!"  . ExtraSecureFailure());
	}
 	$db_type= '';
	$strDatabase=our_db;
	//$olderror=error_reporting(0);
	$mode=$_REQUEST["mode"];
	$strDatabase=our_db;
	$strColumn=$_REQUEST[qpre . "column"];
	$comprehensivesearch=gracefuldecaynumeric($_REQUEST[qpre . "comprehensivesearch"],0);
	error_reporting($olderror);
	$strPHP=$_SERVER['PHP_SELF'];
	$strValDefault=$_REQUEST["ID"];
	$strTable=articletable ;
	$out="";
	//echo $id . " " .$idfield ;
	$out=LoginDecisions($strDatabase,  $strPHP, $strUser, false);
	$sql=conDB();
 	//$strUser="";
	if ($strUser!="")
	{
		//die( $db_type);
		$intAdminType= AdministerType($strDatabase, $strTable, $strUser);

		if ($intAdminType>1)
		{
			
		 	$db_type= 'odbc';
			$strDatabase="dbo";
			if($mode=="refresh")
			{
				$tasktype=4;
				$db_type= '';
				$strDatabase=our_db;
				UpdateOrInsert( $strDatabase, "server_task", "", Array("task_type"=>$tasktype, "datetime_done"=> date("Y-m-d H:i:s")));
				$db_type= 'odbc';
				$strDatabase="dbo";
				$sql->query("fw_client_emails_active_user" );
				$db_type= '';
				$strDatabase=our_db;
				header("location: " . $strPHP);
			
			}
			$records=$sql->query("fw_client_emails" );
			 //echo function_exists("GenericRSDisplayFromRS");
			$out.="<div align='right'><a href=\"" . $strPHP . "?mode=refresh\">refresh</a></div>";
			$out.=GenericRSDisplayFromRS($strPHP,"most active users", $records, 1, 999);
	 
		}
		
	}
	$out =  PageHeader($strDatabase . " : mssql browser", $strConfigBehave) . $out . PageFooter();
	//echo $out;
	return $out;
}

 

	
	

    ?>