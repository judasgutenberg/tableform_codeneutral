<?php
//Gus Mueller August 2006
//a generic manual item sorter for tables, including a certain amount of join-awareness and filter fields/ids.

include('tf_functions_core.php');
 
echo main();

function main()
{
 
	if(!IsExtraSecure())
	{
		die(ExtraSecureFailure());
	}	//http://localhost/hudson/tf_item_sorter.php?x_table=hud_game_message&x_fromforeigntable=hud_game_group&x_idfield=hud_game_message_id&x_filterfield=hud_game_group_id&x_namefield=message&x_filterid=1&x_toforeigntable=


 
	$strPHP=$_SERVER['PHP_SELF'];
	$strDatabase=deMoronizeDB(gracefuldecay($_REQUEST[qpre . "db"],our_db));
	$strPrimaryTable= $_REQUEST[qpre . "primarytable"];
	$strDeleteTable=$_REQUEST[qpre . "deletetable"];
	$strKeyField= $_REQUEST[qpre . "keyfield"];
	$strDeleteKeyField= $_REQUEST[qpre . "deletekeyfield"];
	$mode=gracefuldecay( $_REQUEST[qpre . "mode"]);
	$out="";
	//echo $repositions . "<br>";
	if ($rec=="")
	{
		$rec=0;
	}
	//echo $id . " " .$strIDField ;
	$out=LoginDecisions($strDatabase,  $strPHP, $strUser, false);
	$errors="";
	if ($strUser!="")
	{
		$intAdminType= AdministerType($strDatabase, $strTable, $strUser);
		if ($mode=="dosubtract")
		{
			//echo "##". $DeleteItems;
			
			
			$errors="<div class=\"feedback\">" . DeleteItems($strDatabase, $strPrimaryTable,$strDeleteTable, $strKeyField, $strDeleteKeyField)  . "</div>";
		}
		if ($intAdminType>1)
			{
	 
 
				$out.= SubtractTableForm($strDatabase, $strPrimaryTable, $strDeleteTable, $strKeyField, $strDeleteKeyField);
				
			}
	}
	$out =  PageHeader("Table Subtract", $strConfigBehave, "", true, false, "", $strDatabase) . $errors . $out . PageFooter();
	return $out;
}

function DeleteItems($strDatabase, $strPrimaryTable,$strDeleteTable, $strKeyField, $strDeleteKeyField)
{
	$sql=conDB();  
	$strSQL="SELECT " . $strDeleteKeyField ." FROM " . $strDatabase . "." . $strDeleteTable;
	$records = $sql->query($strSQL);
	//echo $strSQL;
	$deletecount=0;
	$failurecount=0;
	foreach($records as $record)
	{	
		$strDeleteSQL="DELETE FROM " .  $strDatabase . "." . $strPrimaryTable . " WHERE " .  $strKeyField . "='" . $record[ $strDeleteKeyField] . "'";
	 	//echo $strDeleteSQL . "<BR>";
		$sql->query($strDeleteSQL);
		if(mysql_affected_rows()>-1)
		{
			$deletecount=$deletecount+mysql_affected_rows();
		}
		else
		{
			$failurecount++;
		}
	}
	return $deletecount  . " " .  PluralizeIfNecessary("record", $deletecount) . "  deleted. " .  $failurecount  . " " .  PluralizeIfNecessary("deletion", $failurecount) . " failed.";
}


function SubtractTableForm($strDatabase, $strPrimaryTable, $strDeleteTable, $strKeyField, $strDeleteKeyField)
{
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strPHP="tf.php";
	$preout="";
	$out="";
	$preout.= adminbreadcrumb(false, $strDatabase, $strPHP . "?" . qpre . "db=" . $strDatabase, "table subtract", "");
	$preout.="<form enctype=\"multipart/form-data\" name=\"BForm\" action=\"tf_tablesubtract.php\" method=\"post\">\n";
 
	$strButtonLabel="do eliminations";
	//$out.=$tableheader;
 
	$out.=htmlrow($strClassFirst, 
	"original table: ",
	TableDropdown($strDatabase, $strPrimaryTable, qpre. "primarytable", 'BForm', qpre."keyfield" )
	);
	$out.=htmlrow($strClassSecond, 
	"key field: ",
	FieldDropdown($strDatabase, $strPrimaryTable,  qpre."keyfield",$strKeyField)
	);
	$out.=htmlrow($strClassFirst, 
	"table of deletes: ",
	TableDropdown($strDatabase, $strDeleteTable,  qpre."deletetable" ,  'BForm', qpre."deletekeyfield")
	);
	$out.=htmlrow($strClassSecond, 
	"delete key field: ",
	FieldDropdown($strDatabase, $strDeleteTable,  qpre."deletekeyfield",$strDeleteKeyField)
	);
	
 
	$out.=htmlrow("bgclassline", "&nbsp;",GenericInput(qpre . "submit",   $strButtonLabel));
	$out.= HiddenInputs(array("db"=>$strDatabase, "mode"=>"dosubtract" ));
	$out.="</td></tr>\n";
	$out=   $preout . TableEncapsulate($out, false);
	$out.="</form>\n";
	return $out;

}
	//<a href=javascript:domdumpwindow()>dump</a>
?>





