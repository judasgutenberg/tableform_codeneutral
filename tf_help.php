<?php 
//Gus Mueller September 20 2006
//provides help in the tableform system admin tool for any mysql db

include_once('tf_functions_core.php');
include_once('tf_core_table_creation.php');
echo main();

function main()
{
	if(!IsExtraSecure())
	{
		die(ExtraSecureFailure());
	}
	
	//$olderror=error_reporting(0);
	$mode=$_REQUEST[qpre . "mode"];
	$strField=$_REQUEST[qpre . "field"];
	$strTable=$_REQUEST[qpre . "table"];
	$strHelpText=$_REQUEST["help_text"];
	$strLabel=$_REQUEST["label"];
	$strDatabase=deMoronizeDB(gracefuldecay($_REQUEST[qpre . "db"],our_db));
	$strConfigBehave=$_REQUEST[qpre . "behave"];
	$feedbackspanstag="<span class=\"feedback\">";
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
				if ($strHelpText!="")
				{
					$message=SaveHelp($strDatabase, $strTable,$strField, $strHelpText, $strLabel);
					$out.=$feedbackspanstag . $message . "</span>";
				}
				$out.= ShowHelp($strDatabase, $strTable,$strField, $strUser);
	 
			}
	}
	$out =  PageHeader("Help for " . $strField . " in " . $strTable , $strConfigBehave, "", true, false, "", $strDatabase) . $out . PageFooter();
	
	return $out;
}

	
	
function ShowHelp($strDatabase, $strTable,$strField, $strUser)
{
	$out="";
	$sql=conDB();
	$strSQL="SELECT  * FROM " . $strDatabase . "." .  tfpre . "column_info where table_name='" . $strTable . "' AND column_name='". $strField. "'";
	//echo $strSQL;
	$records = $sql->query($strSQL);
	$record=$records[0];
	$strHelpText=$record["help_text"];
	$strLabel=$record["label"];
	$length =60;
	$intDefaultLength=9;
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strOtherBgClass="bgclassother";
	$preout="";
	$out="";
	if ($strHelpText=="")
	{
		$strHelpText="There is no help available for this item.";
	}
	if ($strUser=="root"  || 1==1)
	{
		$preout.="<form name=\"BForm\" method=\"post\" action=\"" . $strPHP . "\" onSubmit=\" return validate_form();\">\n";
		$out.="<tr>\n";
		$out.=htmlrow($strClassFirst, "User-friendly label", TextInput("label", $strLabel, 20));
		$out.=htmlrow($strClassSecond,"Edit the Help Text for " . $strField . " in " .  $strTable . " here","<textarea cols=\"" . $length . "\" rows=\"" .$intDefaultLength . "\"  name=\"help_text\">" .  $strHelpText . "</textarea>\n");
		$out.=htmlrow($strOtherBgClass,"<input type=\"Submit\" value=\"Save Help Text\">\n"," <input onclick=\"window.close();\" type=\"submit\" value=\"Close Window\">\n");
		$out.="</tr>\n";
		$out=$preout . TableEncapsulate($out, false);
		$out.=HiddenInputs(Array("db"=>$strDatabase));
		$out.="</form>";
		
	 
	
	
	}
	else
	{
		$out=$strHelpText;
	}
	return $out;
}


function SaveHelp($strDatabase, $strTable,$strField, $strHelpText, $strLabel)
{
	//echo function_exists("MakeColumnInfoTables") . "-";
	$out.=MakeTableIfNotThere($strDatabase, tfpre . "column_info", "MakeColumnInfoTables");
	$message= GenericDBSave(array("table_name"=>$strTable, "column_name"=>$strField), array("help_text"=>$strHelpText, "label"=>$strLabel), $strDatabase,  tfpre . "column_info");
	return $message;
}



function GenericDBSave($arrAlwaysParams, $arrSometimesParams, $strDatabase, $strTable)
{
	$strWhere="";
	foreach ($arrAlwaysParams as $k=>$v)
	{
		if ($strWhere!="")
		{
			$strWhere .=" AND ";
			
		}
		$strWhere .= $k . "='" . htmlcodify($v) . "'";
		$strTestReturn=$k;
	}
 
	$sql=conDB();
	$strSQL="select  * from " . $strDatabase . "." .  $strTable . " where " . $strWhere;
	//echo $strSQL;
	$records = $sql->query($strSQL);
	$record=$records[0];
	$strSQL="";
	//echo $strTestReturn. "=" . $record[$strTestReturn] . "<br>";
	if($record[$strTestReturn]!=""  || count($records)>1 )
	{
		//UPDATE
		$strPreSQL="UPDATE  " . $strDatabase . "." .  $strTable . " SET ";
		//foreach ($arrAlwaysParams as $k=>$v)
		//{
			//if ($strSQL!="")
			//{
			//	$strSQL .=" , ";
			
			//}
			//$strSQL .= $k . "='" . htmlcodify($v) . "'";
		//}
		foreach ($arrSometimesParams as $k=>$v)
		{
			if ($strSQL!="")
			{
				$strSQL .=" ,";
			
			}
			if ($v!="")
			{
				$strSQL .= $k . "='" . htmlcodify($v) . "'";
			}
		}
		 

		if (substr( $strSQL, strlen($strSQL)-2)==" ,")
		{

			$strSQL=substr($strSQL, 0, strlen($strSQL)-2);
		
		}
		$strSQL=$strPreSQL. $strSQL . " WHERE " . $strWhere;
		$message= "Column info altered.";
	}
	else
	{
		//INSERT
		$strPreSQL="INSERT INTO  " . $strDatabase . "." .  $strTable . " SET ";
		
		foreach ($arrAlwaysParams as $k=>$v)
		{
			if ($strSQL!="")
			{
				$strSQL .=" , ";
			
			}
			$strSQL .= $k . "='" . htmlcodify($v) . "'";
		}
		foreach ($arrSometimesParams as $k=>$v)
		{
			if ($strSQL!="")
			{
				$strSQL .=" ,";
			
			}
			if ($v!="")
			{
				$strSQL .= $k . "='" . htmlcodify($v) . "'";
			}
		}
 
		if (substr( $strSQL, strlen($strSQL)-2)==" ,")
		{

			$strSQL=substr($strSQL, 0, strlen($strSQL)-2);
		
		}
		$strSQL=$strPreSQL. $strSQL;
		$message= "Column info added.";
		
	}
	
	//echo $strSQL;
	$records = $sql->query($strSQL);
	//echo mysql_error();
	return $message;
}
?>