<?php
//Gus Mueller August 2006
//a generic manual item sorter for tables, including a certain amount of join-awareness and filter fields/ids.

include('tf_functions_core.php');
include('tf_itemsorter_functions.php');
echo main();

function main()
{
	if(!IsExtraSecure())
	{
		die(ExtraSecureFailure());
	}	//http://localhost/hudson/tf_item_sorter.php?x_table=hud_game_message&x_fromforeigntable=hud_game_group&x_idfield=hud_game_message_id&x_filterfield=hud_game_group_id&x_namefield=message&x_filterid=1&x_toforeigntable=

	$strSortField=gracefuldecay($_REQUEST[qpre . "sortfield"],"sort_id");
	$strIDField=gracefuldecay($_REQUEST[qpre . "idfield"],"hud_game_group_map_id");
	$strTable=gracefuldecay($_REQUEST[qpre . "table"],"hud_game_group_map");
	$intID=gracefuldecay($_REQUEST[$strIDField],"1");
	$strFilterField=gracefuldecay($_REQUEST[qpre . "filterfield"],"hud_game_id");
	$intFilterID=gracefuldecay($_REQUEST[$strFilterField], "1");
	$strNameField=gracefuldecay($_REQUEST[qpre . "namefield"], "game_group_name");  
	$strToForeignTable=gracefuldecay($_REQUEST[qpre . "toforeigntable"], "");  //hud_game_group
	$strFromForeignTable=gracefuldecay($_REQUEST[qpre . "fromforeigntable"], "hud_game");  
	$strToJoinField=gracefuldecay($_REQUEST[qpre . "toJoinField"], "hud_game_group_id");
	$strFromJoinField=gracefuldecay($_REQUEST[qpre . "fromJoinField"], "hud_game_id");
	$mode=$_REQUEST[qpre . "mode"];
	$DeleteItems=$_REQUEST[qpre . "delete"];
	$repositions=$_REQUEST[qpre . "repositions"];
	$strDatabase=deMoronizeDB(gracefuldecay($_REQUEST[qpre . "db"],our_db));
	$strConfigBehave=$_REQUEST[qpre . "behave"];
	error_reporting($olderror);
	$strPHP=$_SERVER['PHP_SELF'];
	$out="";
	//echo $repositions . "<br>";
	if ($rec=="")
	{
		$rec=0;
	}
	//echo $id . " " .$strIDField ;
	$out=LoginDecisions($strDatabase,  $strPHP, $strUser, false);

	if ($strUser!="")
	{
		$intAdminType= AdministerType($strDatabase, $strTable, $strUser);
		if ($DeleteItems!="")
		{
			//echo "##". $DeleteItems;
			DeleteItems($strDatabase, $strTable,$strIDField, $DeleteItems);
		}
		if ($intAdminType>1)
			{
			 	if ($mode=="save")
				{  
					$out.=  AlterItems($strDatabase, $strTable,  $strIDField, $strSortField);
				}
 
				$out.= ItemSorter($strDatabase, $strTable, $strIDField, $intID, $strSortField, $strFilterField, $intFilterID, $strNameField, $strToJoinField, $strToForeignTable, $strFromJoinField, $strFromForeignTable);
				
			}
	}
	$out =  PageHeader("Item Sorter", $strConfigBehave) . $out . PageFooter();
	return $out;
}

	
	//<a href=javascript:domdumpwindow()>dump</a>
?>





