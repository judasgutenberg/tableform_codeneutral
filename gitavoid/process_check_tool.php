<?php
//Gus Mueller April 2012
//compares data from two tables and flags what might need fixing
//set_time_limit(900);
ini_set('memory_limit','4050M');

include_once('tf_functions_core.php');
include_once('tf_functions_backup.php');
include_once('tf_functions_sql_parsing.php');
include_once('tf_functions_frontend_db.php');
ini_set('display_errors', 1); 
/*
			ini_set('log_errors', 1); 
			ini_set('error_log', dirname(__FILE__) . '/error_log.txt'); 
			error_reporting(E_ALL);
*/

echo main();
 

function main()
{
	if(!IsExtraSecure())
	{
		die(ExtraSecureFailure());
	}
	//$olderror=error_reporting(0);
	$searchterm=$_REQUEST["searchterm"];
 	$count=$_REQUEST["count"];
 	$action=gracefuldecay($_REQUEST["action"], "editprocesschecks");//"Users";
 	$process_check_id=$_REQUEST["process_check_id"];
 
	$strDatabase="try";
	error_reporting($olderror);
	$strPHP=$_SERVER['PHP_SELF'];
	
 
	$out=LoginDecisions($strDatabase,  $strPHP, $strUser, false, "nobottomnavnotopnav");
	$out.="<script src=\"tf_tablesort.js\"><!-- --></script> ";
	if ($strUser!="")
	{
	
		$intAdminType= AdministerType($strDatabase,"", $strUser);
		
		if ($intAdminType>1)
		{
			//false, $strDatabase, "tf.php?" . qpre . "db=" . $strDatabase,  "db tools", tfpre  . "dbtools.php" . "?" . qpre . "db=" . $strDatabase,
			$breadcrumbparams=Array( true, "H&FJ Process Check Editor");
			if($action=="generatefixes"  && strtolower($_REQUEST["accept"])=="save notes" )
			{
		 
				//$out="<div class='feedback'>Notes saved.</div>";
			}
			else if($action=="generatefixes")
			{
				
				
				
			 
				//echo $strFixSQL;
			}
 
 			//echo $action;
			if($action=="delete" )
			{
				//DeleteBySpec($strDatabase, $strTableDest, Array($strTableDest."_id" =>$_REQUEST[$strTableDest."_id"]) );
				//echo mysql_error();
				$out.="<div style='color:009900;text-weight:bold'>Item deleted " . $intSourceTotal. ".</div>";
				$action="editcoltrans";
			}
			
			if ($action=="editprocesschecks")
			{
		 		$out.=editProcessChecks($strDatabase);
			}
			else if ($action=="editobjectactions")
			{
		 		$out.=editObjectActions($strDatabase);
			}
			else if ($action=="editcheckobjects")
			{
		 		$out.=editCheckObjects($strDatabase);
			}
			else if ($action=="viewerrors")
			{
		 		$out.=viewErrors($strDatabase, $process_check_id);
			}
			
			$preout= "<br>";

			$preout.= "<span class='topnav_notselected'>[<a href=\"" . $strPHP . "?action=editprocesschecks\">Edit Process Checks</a>]</span>   ";
			
			$preout.= "<span class='topnav_notselected'>[<a href=\"" . $strPHP . "?action=editcheckobjects\">Edit Check Objects</a>]</span> ";
			$preout.= "<span class='topnav_notselected'>[<a href=\"" . $strPHP . "?action=editobjectactions\">Edit Check Actions</a>]</span> ";
			$out=$preout . $out;
			$out= call_user_func_array("adminbreadcrumb", $breadcrumbparams) . $out;
			if($action=="")
			
			{
				
				 
			}
			
		}
	}
	
	$out =  PageHeader("H&FJ Process Check Editor", $strConfigBehave, "", true, false, "", $strDatabase) . $strAddedJSTag . $out . PageFooter();
	
	return $out;
}
 
 
function viewErrors($strDatabase,$process_check_id)
{
	$strTable="process_check_result";
	$strPKName=$strTable . "_id";
	//GenericRSDisplay($strDatabase, $strPHP,$strLabel, $strSQL, $truncate, $intWidth, $strLinkFieldName="", $strLinkIDName="", $strAdditionalLink="", $strSuppressFields="", $bwlSuppressHeader=false, $bwlPrettyUpFieldNames=true, $intFieldLimit=10, $idencryptionstring="", $arrPostProcessing="", $arrFieldLabels="", $bwlSuppressLinksWhereNoData=true, $bwlNoTableEncapsulate=false, $hrefTarget="", $bwlPaginated=false)
	//editpopup(db, table, idfield, id, arrNames , arrValues, behave,  kosherfields, widthguidance, heightguidance)
	$link="javascript:editpopup('" . $strDatabase . "','" . $strTable . "','" . $strPKName . "','<replace/>','','','nobottomnav','','1000')";
	//$deleteLink="<a onclick='return(confirm(\"Are you sure you want to delete the process check #<replace/>?\"))' href='process_check_tool.php?action=delete&tabledest=" . $strTable . "&" . $strPKName . "=<replace/>'>delete</a>";
 	$strSQL="SELECT * FROM " .$strDatabase . "." . $strTable . " WHERE process_check_id=" . intval($process_check_id) . " AND result_of_check<>'A' ORDER BY process_check_result_id DESC";
	//echo $strSQL;
	$processCheckName=GenericDBLookup($strDatabase, "process_check", "process_check_id", $process_check_id, "name");
	$out=GenericRSDisplay($strDatabase, $link,"Recent Process Check Errors for '" . $processCheckName . "'", $strSQL, 1, 800, "",  "", "", "",  false, true,  10,  "" );
 
	//$out.="[<a href=\"" . str_replace("<value/>", "", $link) . "\">create a new process check</a>]";
	return $out;
}
  
function editProcessChecks($strDatabase)
{
	$strTable="process_check";
	$strPKName=$strTable . "_id";
	$link="javascript:editpopup('" . $strDatabase . "','" . $strTable . "','" . $strPKName . "','<replace/>','','','nobottomnav','','1000')";
	$deleteLink="<a onclick='return(confirm(\"Are you sure you want to delete the process check #<replace/>?\"))' href='process_check_tool.php?action=delete&tabledest=" . $strTable . "&" . $strPKName . "=<replace/>'>delete</a>";
	$viewErrorsLink="<a   href='process_check_tool.php?action=viewerrors&tabledest=" . $strTable . "_result" . "&" . $strPKName . "=<replace/>'>failures</a>";
	$out=GenericRSDisplay($strDatabase, $link,"Process Checks", "SELECT process_check_id, name, object_name, check_php, action_name, disabled, sort_order_id FROM " .$strDatabase . "." . $strTable . " a LEFT JOIN " . $strDatabase . ".object_action b ON a.object_action_id=b.object_action_id ORDER BY sort_order_id ASC", 1, 1100, "",  "", $viewErrorsLink . " - " . $deleteLink, "",  false, true,  10,  "" );
 
	$out.="[<a href=\"" . str_replace("<value/>", "", $link) . "\">create a new process check</a>]";
	return $out;
}
  
function editObjectActions($strDatabase)
{
	$strTable="object_action";
	$strPKName=$strTable . "_id";
	$link="javascript:editpopup('" . $strDatabase . "','" . $strTable . "','" . $strPKName . "','<replace/>','','','nobottomnav','','1000')";
	$deleteLink="<a onclick='return(confirm(\"Are you sure you want to delete the check action #<replace/>?\"))' href='process_check_tool.php?action=delete&tabledest=" . $strTable . "&" . $strPKName . "=<replace/>'>delete</a>";
	$out=GenericRSDisplay($strDatabase, $link,"Check Actions", "SELECT * from " .  $strDatabase . "." . $strTable, 1, 800, "",  "", $deleteLink, "",  false, true,  10,  "" );
 
	$out.="[<a href=\"" . str_replace("<value/>", "", $link) . "\">create a new check action</a>]";
	return $out;
}

function editCheckObjects($strDatabase)
{
	$strTable="process_object";
	$strPKName=$strTable . "_id";
	//GenericRSDisplay($strDatabase, $strPHP,$strLabel, $strSQL, $truncate, $intWidth, $strLinkFieldName="", $strLinkIDName="", $strAdditionalLink="", $strSuppressFields="", $bwlSuppressHeader=false, $bwlPrettyUpFieldNames=true, $intFieldLimit=10, $idencryptionstring="", $arrPostProcessing="", $arrFieldLabels="", $bwlSuppressLinksWhereNoData=true, $bwlNoTableEncapsulate=false, $hrefTarget="", $bwlPaginated=false)
	//editpopup(db, table, idfield, id, arrNames , arrValues, behave,  kosherfields, widthguidance, heightguidance)
	$link="javascript:editpopup('" . $strDatabase . "','" . $strTable . "','" . $strPKName . "','<replace/>','','','nobottomnav','','1000')";
	$deleteLink="<a onclick='return(confirm(\"Are you sure you want to delete the check object #<replace/>?\"))' href='process_check_tool.php?action=delete&tabledest=" . $strTable . "&" . $strPKName . "=<replace/>'>delete</a>";
	$out=GenericRSDisplay($strDatabase, $link,"Check Objects", "SELECT * from " .  $strDatabase . "." . $strTable, 1, 800, "",  "", $deleteLink, "",  false, true,  10,  "" );
 
	$out.="[<a href=\"" . str_replace("<value/>", "", $link) . "\">create a new check object</a>]";
	return $out;

} 




?>