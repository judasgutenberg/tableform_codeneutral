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
 	$action=$_REQUEST["action"];//"Users";
	$strTableSource=$_REQUEST["tablesource"];//"FMCustomers";
	$strTableDest=$_REQUEST["tabledest"];//"Users";
	$start=gracefuldecaynumeric($_REQUEST["start"],0);
	$total=gracefuldecaynumeric($_REQUEST["total"],50);
	$strDatabase="filemaker";
	error_reporting($olderror);
	$strPHP=$_SERVER['PHP_SELF'];
	
 
	$out=LoginDecisions($strDatabase,  $strPHP, $strUser, false, "nobottomnav");
	$out.="<script src=\"tf_tablesort.js\"><!-- --></script> ";
	if ($strUser!="")
	{
	
		$intAdminType= AdministerType($strDatabase,"", $strUser);
		
		if ($intAdminType>1)
		{
			//false, $strDatabase, "tf.php?" . qpre . "db=" . $strDatabase,  "db tools", tfpre  . "dbtools.php" . "?" . qpre . "db=" . $strDatabase,
			$breadcrumbparams=Array( true, "HFJ Comparator");
			if($action=="generatefixes"  && strtolower($_REQUEST["accept"])=="save notes" )
			{
				saveNotes($strDatabase);
				$out="<div class='feedback'>Notes saved.</div>";
			}
			else if($action=="generatefixes")
			{
				//echo "EE";
				//echo $count;
				saveNotes($strDatabase);
				$out="<div class='feedback'>Notes saved.  Fixes compiled into SQL.</div>";
				$strFixSQL="";
				$strClauseSQL="";
				$oldPKID="";
				$correctiveAction="";
				for($i=0; $i<=$count; $i++)
				{
					$thisAccept=$_REQUEST["accept|" . $i];
					$strFixSQLItem="";
					if($thisAccept!="" )
					{
						//echo $thisAccept . "=<br>";
						$arrAccept=explode("|", $thisAccept);
						$inconsistency_id=$arrAccept[0];
						$strChosenTable =$arrAccept[1];
						$strChosenPKName =$arrAccept[2];
						$strChosenPKID=$arrAccept[3];
						$strChosenColumn=$arrAccept[4];
						$strDestColumn=$arrAccept[5];
						$strDestPKName=$arrAccept[6];
						$strDestPKID=$arrAccept[7];
						$strSuggested=$arrAccept[8];
						//$sourceInputName="freeform|" . $inconsistency_id . "|" .  $source_table_name ."|" . $count;
						//$destInputName="freeform|" . $inconsistency_id . "|" .  $dest_table_name . "|".  $count;
						$possiblyEditedValue =str_replace("|", "", $_REQUEST["freeform|" . $inconsistency_id . "|" . $strChosenTable ."|" . $i]);
						//echo "freeform|" . $inconsistency_id . "|" . $strChosenTable ."|" . $i . "="  .  $possiblyEditedValue  . "<br>";
						
						$strChosenValue= GenericDBLookup($strDatabase, $strChosenTable, $strChosenPKName, $strChosenPKID, $strChosenColumn);
						
						if($strDestPKID!=$oldPKID  && $oldPKID!="")
						{
							$strFixSQLItem="UPDATE " .   $strTableDest . " SET " . RemoveLastCharacterIfMatch($strClauseSQL, ",") . $whereClause . ";\n";
							$strClauseSQL="";
							$strFixSQL.=$strFixSQLItem;
							updateSynchronizationGlitchRecord($strDatabase, $old_inconsistency_id, $correctiveAction, $strFixSQLItem);
							$correctiveAction="";
						}
						else
						{
							//echo "<br>". $strDestPKID . "<br>";
							
						}
						$whereClause="  WHERE " . $strDestPKName . "=" . $strDestPKID;
						if($strSuggested!="")
						{
							$strChosenValue=$strSuggested;
						}
						$correctiveAction.= $thisAccept ."|" . $possiblyEditedValue .  chr(13);
						$strClauseSQL.=" " . $strDestColumn . "='" . addslashes($possiblyEditedValue) ."'," ;
						$oldPKID=$strDestPKID;
						$old_inconsistency_id=$inconsistency_id;
					}
				}
				//pick up any final updates from the tail end of the accepts
				$strFixSQLItem="UPDATE " . $strTableDest . " SET " . RemoveLastCharacterIfMatch($strClauseSQL, ",") .$whereClause . ";\n";
				$strClauseSQL="";
				$strFixSQL.=$strFixSQLItem;
				updateSynchronizationGlitchRecord($strDatabase, $inconsistency_id, $correctiveAction, $strFixSQLItem);
			
				//echo $strFixSQL;
			}
			else if($action=="sqldump")
			{
				$out=sqlDump($strDatabase);
				$len=strlen($out);
				$backupFile = date("Y-m-d") . "-" . $strDatabase  . '-HFJFilemakerMigration.sql';
				header("Pragma: public");
				header("Expires: 0");
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header("Cache-Control: public"); 
				header("Content-Description: File Transfer");
				header("Content-Type: application/gzip");
				header("Content-Disposition: attachment; filename=" . $backupFile.  ";");
				header("Content-Transfer-Encoding: binary");
				if ($len!="")
				{
					header("Content-Length: ".$len);
				}
				echo $out;
				die();
			}
 			//echo $action;
			if($action=="delete" )
			{
				DeleteBySpec($strDatabase, $strTableDest, Array($strTableDest."_id" =>$_REQUEST[$strTableDest."_id"]) );
				//echo mysql_error();
				$out.="<div style='color:009900;text-weight:bold'>Item deleted " . $intSourceTotal. ".</div>";
				$action="editcoltrans";
			}
			
			if($action=="fixbrowser" || $action=="generatefixes")
			{
				//die($action);
				$breadcrumbparams = array_merge($breadcrumbparams, Array($strPHP , "Examine " . $strTableDest . " Inconsistencies"));
				$out.= "<div>" . fixBrowser($strDatabase, $strTableDest, $searchterm) . "</div>";
			}
			else if ($action=="clearinconsistencies")
			{
				$breadcrumbparams = array_merge($breadcrumbparams, Array($strPHP , "Inconsistencies Cleared for " .  $strTableDest));
				$out.= clearInconsistencies($strDatabase, $strTableDest);
			}
			else if ($action=="editcoltrans")
			{
				$breadcrumbparams = array_merge($breadcrumbparams, Array($strPHP , "Column Translations"));
				$out.= columnTranslations($strDatabase);
			}
			else if($strTableSource=="")
			{
				$breadcrumbparams = array_merge($breadcrumbparams, Array( $strPHP ,  $strTableDest, $strPHP . "?tablesource=" . $strTableSource . "&tabledest=" . $strTableDest));
				$out.="<div style='width:600px; margin:40px;font-size:12px'>This is the <strong>Hoefler & Frere-Jones data comparison tool</strong>. <p/>To scan through the FMCustomers table and look for inconsistencies with linked Users table data, click  <strong>[Scan FMCustomers/Users]</strong>. To scan through the FMOrders table and look for inconsistencies with linked Orders table data, click  <strong>[Scan FMOrders/Orders]</strong>. Those both require this window to refresh multiple times to scan through the entire tables and compare the columns. Let that run until you get a message that says <span style='color:009900;text-weight:bold'>Inconsitency scan completed</span>.<p/>Then, to examine inconsistencies and choose actions, click either <strong>[Examine Users Inconsistencies]</strong>  or <strong>[Examine Orders Inconsistencies]</strong>.  After that, you can  <strong>[Download Fix SQL]</strong>.  If you want to re-run the process from scratch, you can <strong>[Clear Inconsistencies]</strong>.  To edit how columns in source tables map to columns in destination tables, click <strong>[Edit Column Translations]</strong>.";
			}
			
			$preout= "<br/><span class='topnav_notselected'>[<a href=\"" . $strPHP . "\">Home</a>]</span>  <span class='topnav_notselected'>[<a  onclick='return(confirm(\"Are you sure you want to initiate a scan? It could take 2 hours or more and you will have to leave this page open to until you get the message saying it has finished.\"))' href=\"" . $strPHP . "?tablesource=FMCustomers&tabledest=Users\">Scan FMCustomers/Users</a>]</span> ";
	   		$preout.= " <span class='topnav_notselected'>[<a  onclick='return(confirm(\"Are you sure you want to initiate a scan? It could take 2 hours  or more and you will have to leave this page open to until you get the message saying it has finished.\"))'  href=\"" . $strPHP . "?tablesource=FMOrders&tabledest=Orders\">Scan FMOrders/Orders</a>]</span>   ";
			$preout.= " <span class='topnav_notselected'>[<a href=\"" . $strPHP . "?action=fixbrowser&tabledest=Users\">Examine Users Inconsistencies</a>]</span> <span class='topnav_notselected'>[<a href=\"" . $strPHP . "?action=fixbrowser&tabledest=Orders\">Examine Orders Inconsistencies</a>]</span> <span class='topnav_notselected'>[<a href=\"" . $strPHP . "?action=sqldump\">Download Fix SQL</a>]</span>  ";

			//$preout.= "<span class='topnav_notselected'>[<a onclick='return(confirm(\"Are you sure you want to clear Inconsistencies?  To calculate them again you will  have to rerun the comparison scans.  You will also lose your notes.\"))' href=\"" . $strPHP . "?action=clearinconsistencies\">Clear Inconsistencies</a>]</span> ";
			$preout.= "<span class='topnav_notselected'>[<a href=\"" . $strPHP . "?action=editcoltrans\">Edit Column Translations</a>]</span>";
			$out=$preout . $out;
			$out= call_user_func_array("adminbreadcrumb", $breadcrumbparams) . $out;
			if($action=="")
			
			{
				
				if($strTableSource!="")
				{
					$out.=comparator($strDatabase, $strTableSource, $strTableDest, $start, $total);
					$intSourceTotal=sourceTotal($strDatabase, $strTableSource);
				 
					if($start + $total <= $intSourceTotal)
					{
						$out.="<script>window.location.href='" . $strPHP . "?tablesource=" . $strTableSource . "&tabledest=" . $strTableDest . "&start=" . intval($start + $total) . "&total=" . $total . "';</script>";
					}
					else
					{
						$out.="<div style='color:009900;text-weight:bold'>Inconsitency scan completed at " . $intSourceTotal. ".</div>";
					}
				}
			}
			
		}
	}
	
	$out =  PageHeader("HFJ comparator", $strConfigBehave, "", true, false, "", $strDatabase) . $strAddedJSTag . $out . PageFooter();
	
	return $out;
}
 

function comparator($strDatabase, $strTableSource, $strTableDest, $start=0, $total=10000)
{
	$strDelimiters=" |, |,|-";
	//$start=18001;
	//$total=9000;
	$arrDelimiters=explode("|", $strDelimiters);
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$destPK=PKLookup($strDatabase, $strTableDest, true);
	$sourcePK=PKLookup($strDatabase, $strTableSource, true);
	$doneColumns=0;
	$out="";
	$preout="";
	$sql=conDB();

	$strSQL="SELECT * FROM " . $strDatabase . ".field_translation WHERE source_table_name='" . $strTableSource . "' AND dest_table_name='" . $strTableDest. "' AND (inactive IS NULL OR inactive=0)" ;
	//echo $strSQL;
	$recFieldTranslations = $sql->query($strSQL);
	//echo mysql_error();
	//echo count($recFieldTranslations);
	if($strTableSource=="FMOrders")
	{
		//$strSQL="SELECT * FROM " . $strDatabase . "." . $strTableSource . " t JOIN   " . $strDatabase . ".inconsistency i on i.dest_pk_id=t." . $destPK . " WHERE dest_pk_id is NULL  LIMIT ". $start . ", " . $total;
		$strSQL="SELECT * FROM " . $strDatabase . "." . $strTableSource . "     LIMIT ". $start . ", " . $total;
	}
	else
	{
		$strSQL="SELECT * FROM " . $strDatabase . "." . $strTableSource . " c JOIN " . $strDatabase . ".UserMappings m on c.FM_Customer_Number=m.Um_Customer_Number LIMIT ". $start . ", " . $total;
	}
	//echo $strSQL;
	//die($strSQL);
	$sourceRecords = $sql->query($strSQL);
	//echo mysql_error();
	//echo count($sourceRecords);
	$failCount=0;
	
	foreach($sourceRecords as $sourceRecord)
	{
		$deltaScraps="";
		$sourcePKID=$sourceRecord[$sourcePK];
		$inconsistent_dest_columns="";
		if($strTableSource=="FMOrders")
		{
			//don't know thisPK yet!
		}
		else
		{
			$thisPK= $sourceRecord["Um_UserID"];
		}
		if($strTableSource=="FMOrders")
		{
			//echo $strTableSource . "<br>";
			$destRecord =GenericDBLookup($strDatabase, $strTableDest, "Order_FMOrderID", $sourceRecord["Invoice_Number"], "" );
			//var_dump($destRecord);
			//die();
			//die($destPK);
			$thisPK= $destRecord[$destPK];
			//die($thisPK);
		}
		else
		{
			$destRecord =GenericDBLookup($strDatabase, $strTableDest, $destPK, $thisPK);
		
		}
		$bwlNoRecord=false;
		if($destRecord=="")
		{
			$bwlNoRecord=true;
		}
		$failedColumns="";
		//echo "D";
		$bwlFail=false;
		if(!$bwlNoRecord)
		{
			foreach($recFieldTranslations as $recFieldTranslation)
			{
				$sourceFieldToCompare=$sourceRecord[ $recFieldTranslation["source_column_name"]];
				$destFieldToCompare=$destRecord[$recFieldTranslation["dest_column_name"]];
				
				foreach($arrDelimiters as $thisDelimiter)
				{
					//records in dest_column_name can be multiple column names separated by  delimiters such as a space
					//those delimiters are then used to separate items recombined for a comparison with source_column_name
	
					if(contains($recFieldTranslation["dest_column_name"], $thisDelimiter))
					{ 
						//echo  $recFieldTranslation["dest_column_name"]  ."^^<br>";
						$arrFields=explode($thisDelimiter, $recFieldTranslation["dest_column_name"]);
						$destFieldToCompare="";
						foreach($arrFields as $thisField)
						{
							$destFieldToCompare.=$destRecord[$thisField] . $thisDelimiter;
						}
						//echo $destFieldToCompare ."*" . $sourceFieldToCompare . "<br>";
						$destFieldToCompare= RemoveLastCharacterIfMatch($destFieldToCompare, $thisDelimiter);
						$deltaScrap="";
						//echo substr($sourceFieldToCompare, 0, strlen($destFieldToCompare)) . "^" . strlen( substr($sourceFieldToCompare, 0, strlen($destFieldToCompare))) . "**" . $destFieldToCompare. "^" . strlen($destFieldToCompare) . "**" . intval(substr($sourceFieldToCompare, 0, strlen($destFieldToCompare))==$destFieldToCompare) . "&&" . $destRecord[$arrFields[1]] . "<BR>";
						//echo   $arrFields[1] . "****" . trim($destRecord[$arrFields[1]]) . "<BR>";
						//echo  substr($sourceFieldToCompare, 0, strlen($destFieldToCompare)-5) . "&&&&" . 
						if(substr($sourceFieldToCompare, 0, strlen($destFieldToCompare)-5)==substr($destFieldToCompare, 0,  strlen($destFieldToCompare)-5) && trim($destRecord[$arrFields[1]])=="") //for some reason i have to compare all but the last five characters to see if we're talking about the same data //  
						{
							$deltaScrap=substr($sourceFieldToCompare, strlen($destFieldToCompare)-1);
						}
						//put together a deltascrap descriptor for use in suggesting data for the second part
						//of multiple columns being generated from data in one column
						if(strlen($deltaScrap)>1)
						{
							$deltaScraps.= $arrFields[1] . "|" . str_replace(chr(13), " ", str_replace("|", "", $deltaScrap)) . chr(13);
						}
						//echo $destFieldToCompare . "------" . $deltaScrap . "<br>";
					 	//$fieldsToIgnoreInComparison;
						break 1; //get out of the delimiter loop
					}
				}
				//echo $recFieldTranslation["source_column_name"] . ":" .  $sourceFieldToCompare . "++" .  $recFieldTranslation["dest_column_name"] . ":" . $destFieldToCompare . "<br>";
				//if($recFieldTranslation["case_insensitive"]==1)  //good for email comparisons
				//{
				$sourceFieldToCompare=strtolower($sourceFieldToCompare);
				$destFieldToCompare=strtolower($destFieldToCompare);
				//}

				
				//do the same for multiple source columns that end up becoming just one column in the dest
				foreach($arrDelimiters as $thisDelimiter)
				{
					//records in source_column_name can be multiple column names separated by  delimiters such as a space
					//those delimiters are then used to separate items recombined for a comparison with dest_column_name
	
					if(contains($recFieldTranslation["source_column_name"], $thisDelimiter))
					{ 
						//echo  $recFieldTranslation["dest_column_name"]  ."^^<br>";
						$arrFields=explode($thisDelimiter, $recFieldTranslation["source_column_name"]);
						$sourceFieldToCompare="";
						foreach($arrFields as $thisField)
						{
							$sourceFieldToCompare.=$sourceRecord[$thisField] . $thisDelimiter;
						}
			 
						$sourceFieldToCompare= RemoveLastCharacterIfMatch($sourceFieldToCompare, $thisDelimiter);
						
						
						if(contains($sourceFieldToCompare, "/")  && contains($sourceFieldToCompare, ":"))
						{
							//probably a messed-up date.
							$arrDate=explode(" ", $sourceFieldToCompare);
							$datepart=$arrDate[0];
							$timepart=join(" ", Array($arrDate[1], $arrDate[2]));
							if(contains($datepart, "/"))
							{
								$arrDatePart=explode("/", $datepart);
								$month=$arrDatePart[0];
								$day=$arrDatePart[1];
								$year=$arrDatePart[2];
								//a retroactive Y2K fix!
								if($year<50)
								{
									$year=2000+$year;
								}
								else if($year<100)
								{
									$year=1900+$year;
								}
								$datepart=$day . "-" . $month . "-" . $year;
								$date=$datepart . " " . $timepart;
								//die(  strtotime($date) . "="  . $date);
								$possibledate=strtotime($date);
								if($possibledate>0)
								{
									$sourceFieldToCompare=date("Y-m-d H:i:s", $possibledate);
								}
							}
							 
						}
						break 1; //get out of the delimiter loop
					}
				}

				 
				//you can try different comparison regimes here. essentialEquality is less fussy about spaces and weird characters
				$bwlFail=!essentialEquality($sourceFieldToCompare, $destFieldToCompare) && $sourceFieldToCompare!="";
				//$bwlFail=$sourceFieldToCompare!=$destFieldToCompare  && $sourceFieldToCompare!="";
		 
				if(FieldExists($strDatabase, $strTableSource, $recFieldTranslation["dest_column_name"]))
				{
					//we have a field in the source table that is the same as one in the dest table
					if($sourceRecord[$recFieldTranslation["dest_column_name"]]==$destRecord[ $recFieldTranslation["dest_column_name"]])
					{
						//echo "Source column named the same as one in the destination table doesn't match destination table.<br>";
					}
				}
				if($bwlFail)
				{
					if($failedColumns!="")
					{
						$failedColumns.="<hr noshade width='80%'/>";
					}
					$failedColumns.="<nobr> " . $recFieldTranslation["source_column_name"] . " is " . $sourceFieldToCompare;
					$failedColumns.=" but " ;
					$failedColumns.=" " . $recFieldTranslation["dest_column_name"] . " is " . $destFieldToCompare . "</nobr>";
					$inconsistent_dest_columns.=$recFieldTranslation["dest_column_name"]  . " ";
	
				}
			 
				//echo $sourceRecord["FM_Name"] . "=". $destRecord["User_FirstName"] . " " . $destRecord["User_LastName"] . "<br>";
			}
		}
		else//no matching record
		{
			$failedColumns="No matching record.";
		}
		$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
		//$failedColumns="sffs";
		if($failedColumns!="")
		{
			//don't overwrite old data written by the scanner
			$existingRecordID=GenericDBLookupWhere($strDatabase, "inconsistency", "dest_pk_name='" .$destPK."' AND  dest_pk_id='"  . $thisPK. "' AND dest_table_name='" . $strTableDest . "'", "inconsistency_id" );
			//echo $destPK . "=" . $thisPK.   "=" . intval($existingRecordID) . "=<br>";
			
			if(intval($existingRecordID)>0  || intval($thisPK)<1)
			{
				$doneColumns++;
			}
			else
			{
				//echo ".";
				$link="<a href=\"javascript:editpopup('" . $strDatabase . "','" . $strTableDest . "','" . $destPK . "','" . $thisPK . "','','','nobottomnav','')\">" .  $thisPK . "</a>";
	
				$out.=htmlrow($strThisBgClass, $link , $failedColumns);
				$failCount++;
				//add an item to sychronization glitch
				$arrAlteredValuePairs=Array(
					"dest_table_name"=>$strTableDest,
					"inconsistent_dest_columns"=>trim($inconsistent_dest_columns),
					"dest_pk_id"=>$thisPK,
					"dest_pk_name"=>$destPK,
					
					"source_table_name"=>$strTableSource,
					"source_pk_id"=>$sourcePKID,
					"source_pk_name"=>$sourcePK,
					"delta_scraps"=>$deltaScraps,
					"no_dest_match"=>intval($bwlNoRecord),
					"discovered_datetime"=>date("Y-m-d H:i:s")
					 );
				UpdateOrInsert($strDatabase, "inconsistency", "", $arrAlteredValuePairs);
			}
	
			$inconsistent_dest_columns="";
		}
		
	}
	$out=$preout . TableEncapsulate($out,  true, "", "idsorttable1");
	$out="Inconsistent records: " . $failCount . " out of " . $total . ".<br>Previously-found inconsistent records: " . $doneColumns. " our of " . $total . ".<br> Currently on record " . intval($start + $total) . ".". $out;
	return $out;
}



 
function saveNotes($strDatabase)
{
	foreach($_REQUEST as $key=>$thisRequest)
	{
		//echo "M";
		if(beginswith($key, "notes|"))
		{
			//echo "W";
			$arrRequest=explode("|", $key);
			$inconsistency_id=$arrRequest[1];
			$notes=$_REQUEST["notes|" . $inconsistency_id];
			if($notes!="")
			{
				//echo $notes . "**" . $inconsistency_id . "<br>";
				$arrAlteredValuePairs=Array(
				"notes"=>$notes
					 );
				UpdateOrInsert($strDatabase, "inconsistency", Array("inconsistency_id"=>$inconsistency_id), $arrAlteredValuePairs);
			}
		}
	}
	

}

function columnTranslations($strDatabase)
{
	$strTable="field_translation";
	$strPKName=$strTable . "_id";
	//GenericRSDisplay($strDatabase, $strPHP,$strLabel, $strSQL, $truncate, $intWidth, $strLinkFieldName="", $strLinkIDName="", $strAdditionalLink="", $strSuppressFields="", $bwlSuppressHeader=false, $bwlPrettyUpFieldNames=true, $intFieldLimit=10, $idencryptionstring="", $arrPostProcessing="", $arrFieldLabels="", $bwlSuppressLinksWhereNoData=true, $bwlNoTableEncapsulate=false, $hrefTarget="", $bwlPaginated=false)
	$link="javascript:editpopup('" . $strDatabase . "','" . $strTable . "','" . $strPKName . "','<replace/>','','','nobottomnav','')";
	$deleteLink="<a onclick='return(confirm(\"Are you sure you want to delete this column translation #<replace/>?\"))' href='comparator.php?action=delete&tabledest=" . $strTable . "&" . $strPKName . "=<replace/>'>delete</a>";
	$out=GenericRSDisplay($strDatabase, $link,"Column Translations", "SELECT * FROM " .$strDatabase . "." . $strTable, true, 800, "",  "", $deleteLink, "",  false, true,  10,  "" );
 
	$out.="[<a href=\"" . str_replace("<value/>", "", $link) . "\">create a new column translation</a>]";
	return $out;
}
 
function clearInconsistencies($strDatabase, $strTable)
{
	//emptyTable($strDatabase, "inconsistency");
	DeleteBySpec($strDatabase, "inconsistency", Array("dest_table_name" =>$strTable));
	echo mysql_error();
	return "<div class='feedback'>" . $strTable . " Inconsistencies were cleared.</div>";
}

function sqlDump($strDatabase)
{
	$sql=conDB();
	$strSQL="SELECT corrective_sql FROM " . $strDatabase . ".inconsistency";
	$records = $sql->query($strSQL);
	$out="";
	foreach($records as $record)
	{
		$out.=$record["corrective_sql"];
	}
	return $out;
}
 
function updateSynchronizationGlitchRecord($strDatabase, $inconsistency_id, $actions_taken, $corrective_sql)
{
	$arrAlteredValuePairs=Array(
		"actions_taken"=>$actions_taken,
		"corrective_sql"=>$corrective_sql,
		"correction_datetime"=>date("Y-m-d H:i:s")
				 );
	UpdateOrInsert($strDatabase, "inconsistency", Array("inconsistency_id"=>$inconsistency_id), $arrAlteredValuePairs);
}
 
function sourceTotal($strDatabase, $strTableSource)
{
	$sql=conDB();
	$countSQL="SELECT COUNT(*) as thiscount FROM " . $strDatabase . "." . $strTableSource;
	$recCounts = $sql->query($countSQL);
	$recCount=$recCounts[0];
	$sourceTotal=$recCount["thiscount"];
	return $sourceTotal;
}

 


function sourceInfoFromDestColumn($strDatabase, $destTable, $destColumn)
{
	//GenericDBLookupWhere($strDB, $strTable,   $strIDFieldName . " = '" . $strThisID . "'", $strResultFieldName, $bwlDebug,  $bwlWorkUntilFound, $language_id);
	//have to use LIKE in the following SQL because of the complexities of the whole multicolumn merge capability
	$source_info=GenericDBLookupWhere($strDatabase, "field_translation", "dest_column_name LIKE '%" .  $destColumn . "%' AND dest_table_name='" . $destTable. "'" );
	return $source_info;
}



function fixBrowser($strDatabase, $strThisTable,  $searchterm)
{
	$strDelimiters=" |, |,|-";
	//$start=18001;
	//$total=9000;
	//$recordCount=sourceTotal($strDatabase, "inconsistency");
 	$strPHP=$_SERVER['PHP_SELF'];
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
 	$strLimitspec="48-57 32 39 a-z A-Z _ ";
	$intRecsPerPage=100;
	$out="";

	$sql=conDB();

	$destPK=PKLookup($strDatabase, $strThisTable, true);
	if($searchterm!="")
	{

		$arrColumnsUsers=GetFieldTypeArray($strDatabase, "Users");
		
 

		$arrColumns=GetFieldTypeArray($strDatabase, $strThistable);
		foreach($arrColumnsUsers as $k=>$v)
		{
			$whereClause.=" OR r." .  $k . " LIKE '%" . $searchterm . "%' ";
		}
		$whereClause= RemoveFirstCharacterIfMatch($whereClause, " OR");
			
		 
		$strSQL="SELECT * FROM " . $strDatabase . ".inconsistency i JOIN  " . $strDatabase . "." . $strThisTable . " r ON i.dest_pk_id=r." . $destPK  . " WHERE " . $whereClause  . " AND dest_table_name='" .  $strThisTable . "'";
		$recordCount=CountSQLRecords($strSQL);
		$strSQL.=" LIMIT " .gracefuldecaynumeric($_REQUEST["start"],0) . "," . $intRecsPerPage ;
	}
	else
	{
		$strSQL="SELECT * FROM " . $strDatabase . ".inconsistency WHERE dest_table_name='" .  $strThisTable . "'" ;
		$recordCount=CountSQLRecords($strSQL);
		$strSQL.=" LIMIT " .gracefuldecaynumeric($_REQUEST["start"],0) . "," . $intRecsPerPage;
	}
	$preout.=paginatelinks($recordCount, $intRecsPerPage,$_REQUEST["start"], $strPHP, "start","", "Go to Page: ");
	$preout.=Searchform($strThisTable, $searchterm);
	$preout.="<form name='BForm' method='post' action='" . $strPHP . "'>";
	//echo $recordCount;
	//echo $strSQL;
 
	$records = $sql->query($strSQL);
	$out.=htmlrow("bgclassline", "<x href=\"javascript: SortTable('idsorttable2', 0)\">source</x>", "<x href=\"javascript: SortTable('idsorttable2', 1)\">destination</x>",  "<x href=\"javascript: SortTable('idsorttable2', 2)\">source value</x> &nbsp;&nbsp;existing administrative fixes in <span style='background-color:ffffcc'>manilla</span>", "<x href=\"javascript: SortTable('idsorttable2', 2)\">current destination value</x> (proposed additions in <span style='background-color:99cc99'>green</span>)", "notes");
	$count=0;
	if(count($records)<1)
	{
		$out.="<tr class='". $strClassFirst. "'><td colspan='5'>No items were found.</td></tr>";
	}
	else
	{
	foreach($records as $record)
	{
	 
		 
		$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
		
		$inconsistency_id=$record["inconsistency_id"];
	 	$inconsistent_dest_columns=$record["inconsistent_dest_columns"];
		
		$source_table_name=$record["source_table_name"];
		$source_pk_id=$record["source_pk_id"];
		$source_pk_name=$record["source_pk_name"];
		
		$dest_table_name=$record["dest_table_name"];
		$dest_pk_id=$record["dest_pk_id"];
		$dest_pk_name=$record["dest_pk_name"];
		$discovered_datetime=$record["discovered_datetime"];
		$correction_datetime=$record["correction_datetime"];
		$corrective_sql=$record["corrective_sql"];
		$delta_scraps=$record["delta_scraps"];
	 	$notes=$record["notes"];
		$actions_taken=$record["actions_taken"];
		$no_dest_match=$record["no_dest_match"];
		//$sourceLink="<a target=_new href='tf.php?" . qpre . "db=" . $strDatabase . "&" . qpre . "table=" . $source_table_name . "&" . qpre . "mode=edit&" . qpre . "idfield=" . $source_pk_name . "&" . $source_pk_name . "=" . $source_pk_id . "'>" . $source_pk_id . "</a>";
		//$destLink="<a  target=_new  href='tf.php?" . qpre . "db=" . $strDatabase . "&" . qpre . "table=" . $dest_table_name . "&" . qpre . "mode=edit&" . qpre . "idfield=" . $dest_pk_name . "&" . $dest_pk_name . "=" . $dest_pk_id . "'>" . $dest_pk_id . "</a>";
		//editpopup(db, table, idfield, id, arrNames , arrValues, behave,  kosherfields, widthguidance, heightguidance)
		$sourceLink="<a href=\"javascript:editpopup('" . $strDatabase . "','" . $source_table_name . "','" . $source_pk_name . "','" . $source_pk_id . "','','','nobottomnav','')\">" .  $source_pk_id . "</a>";
		$destLink="";
		if(!$no_dest_match)
		{
			$destLink="<a href=\"javascript:editpopup('" . $strDatabase . "','" . $dest_table_name . "','" . $dest_pk_name . "','" . $dest_pk_id . "','','','nobottomnav','')\">" .  $dest_pk_id . "</a>";

		}

		$arrInconsistentColumns=explode(" ", $inconsistent_dest_columns);
		$strInconsistentLinks="";
		$sourceValueLinks="";
		$destValueLinks="";
		$sourceColumnsDone="";
		$height=1;
		$arrActionsTaken=Array();
	 	if($actions_taken!="")
		{
			$arrActionsTaken=explode(chr(13), $actions_taken);
		}
		
		$columnNumber=0;
	 
		$strSuggestedTaken="";
		$strSuggestedForNext="";
		foreach($arrInconsistentColumns as $thisCol)
		{
			$thisActionTaken=$arrActionsTaken[$columnNumber];
			$arrAccept=explode("|", $thisActionTaken);
			//echo "<hr><font color=red>" . $thisActionTaken . " ---" . $columnNumber . "</font><br>";
			//reference:
			$strChosenTableTaken =$arrAccept[1];
			$strChosenPKNameTaken =$arrAccept[2];
			$strChosenPKIDTaken=$arrAccept[3];
			$strChosenColumnTaken=$arrAccept[4];
			$strDestColumnTaken=$arrAccept[5];
			$strDestPKNameTaken=$arrAccept[6];
			$strDestPKIDTaken=$arrAccept[7];
			$strSuggestedTaken=$arrAccept[8];
			$strEditedValue=$arrAccept[9];
			
						
			$chosenPKName==genericdata($thisCol,0, 1, $delta_scraps, chr(13), "|");
			$sourceRecord=sourceInfoFromDestColumn($strDatabase, $dest_table_name, $thisCol);
			
			$thisSourceColumn=$sourceRecord["source_column_name"];
			
			if($thisSourceColumn=="")
			{
				//die($strDatabase . "=" . $dest_table_name . "=" . $thisCol);
			}
 			
			$suggested=genericdata($thisCol,0, 1, $delta_scraps, chr(13), "|");

			$source_value= GenericDBLookup($strDatabase, $source_table_name, $source_pk_name, $source_pk_id, $thisSourceColumn);
			if($suggested!="")
			{
				$dest_value=$suggested;
				$spanBgColor="99ff99";
				
			}
			else
			{
				$dest_value=GenericDBLookup($strDatabase, $dest_table_name, $dest_pk_name, $dest_pk_id, $thisCol);
				$spanBgColor="";
			}
			if($strChosenTableTaken ==$source_table_name && $strEditedValue!="")
			{
				$source_value=$strEditedValue;
			}
			if($strChosenTableTaken ==$dest_table_name && $strEditedValue!="")
			{
				$dest_value=$strEditedValue;
			}
			//let's calculate the most likely item to be valid for this. generally longer items have more information, although later items with totally different information are more valuable even if they are shorter.
			//of course, this is only to provide hints to an admin
			$source_value_for_comparison=strtolower(trim(FilterString($source_value, $strLimitspec, "")));
			$dest_value_for_comparison=strtolower(trim(FilterString($dest_value, $strLimitspec, "")));
			$bwlSourceBetter=false;
	 
			$debug=1;
			if(substr($source_value_for_comparison, 0, 9)==substr($dest_value_for_comparison, 0, 9))
			{
				//echo $source_value_for_comparison . "--------" . $dest_value_for_comparison  . "<br>";
				if(strlen($source_value_for_comparison)>strlen($dest_value_for_comparison))
				{
					$bwlSourceBetter=true;
					$debug=2;
				}
				else
				{
					$bwlSourceBetter=false;
					$debug=3;
				}
			}
			else
			{
				$bwlSourceBetter=false;
				$debug=4;
			}
			if($bwlSourceBetter)
			{
				$sourceCheck=true;
				$destCheck=false;
			}
			else
			{
				$sourceCheck=false;
				$destCheck=true;
			}
			$sourceCheck=false;
			$destCheck=false;
			if($dest_value==$suggested  && $suggested!="")
			{
				//this will autocheck all suggested items for cases where columns from source become multiple columns for dest
				$destCheck=true;
			}
			if(!$no_dest_match)
			{
				$sourceInput=RadioInput("accept|" . $count, $inconsistency_id . "|" . $source_table_name . "|" . $source_pk_name . "|" . $source_pk_id . "|" . $thisSourceColumn . "|" . $thisCol . "|" . $dest_pk_name . "|" . $dest_pk_id . "|", $sourceCheck);
				$colorSurroundSource="";
				$colorSurroundDest="";
				if($strChosenPKIDTaken==$source_pk_id && $strChosenPKNameTaken==$source_pk_name && $strChosenTableTaken==$source_table_name)
				{
					//a choice had been made for source
					$colorSurroundSource="ffffcc";
				}
			
				$destInput=RadioInput("accept|" . $count,  $inconsistency_id . "|" .  $dest_table_name . "|" . $dest_pk_name . "|" . $dest_pk_id. "|" . $thisCol . "|" . $thisCol . "|" . $dest_pk_name . "|" . $dest_pk_id . "|" . $suggested, $destCheck);
				/*
				//echo "<hr>";
				echo $inconsistency_id . "<BR>";
				echo $strChosenPKIDTaken . "--". $dest_pk_id . "<br>";
				echo $strChosenPKNameTaken . "--". $dest_pk_name . "<br>";
				echo $strChosenTableTaken . "--". $strChosenTableTaken . "<br>";
				echo $strSuggestedTaken . "---" . $suggested . "<br>";
				*/
				if($strChosenPKIDTaken==$dest_pk_id && $strChosenPKNameTaken==$dest_pk_name && $strChosenTableTaken==$dest_table_name || $strSuggestedForNext==$suggested && $suggested!="")
				{
					//a choice had been made for dest
			
					if($strSuggestedTaken=="" || $strSuggestedForNext==$suggested && $suggested!="")
					{
						$colorSurroundDest="ffffcc";
						//$bwlHighlightNextDestItemAsAdministrated=false;
					}
					
					// User_ShipAddress2  No. 37-S for user 	50307
				}
				if($strSuggestedForNext==$suggested)
				{
					//$bwlHighlightNextDestItemAsAdministrated=true;
					$strSuggestedForNext="";
				}
				if($strSuggestedTaken!="")
				{
					//echo "FF<br>";
					//$bwlHighlightNextDestItemAsAdministrated=true;
					$strSuggestedForNext=$strSuggestedTaken;
				}
				
			
				
			}
			$lineheight ="21px";
			$linewidth ="210px";
			$linewidthform ="180px";
			$inputsize=22;
			//echo $sourceColumnsDone . "<br>";
			$sourceInputName="freeform|" . $inconsistency_id . "|" .  $source_table_name ."|" . $count;
			$destInputName="freeform|" . $inconsistency_id . "|" .  $dest_table_name . "|".  $count;
			if(!inList($sourceColumnsDone, $thisSourceColumn) )
			{
				
				// TextInput($name, $default, $size, $onClick="",  $strClass="", $strStyle="")
				$sourceValueLinks.="<div style='background-color:#" . $colorSurroundSource . "'>" . "<div style='float:left;width:" . $linewidth . ";height:" . $lineheight . ";color:#990000'>" .  $sourceInput . $thisSourceColumn  . "</div> <div  style='float:right;width:" . $linewidthform . ";height:" . $lineheight . ";background-color:#'>" . TextInput($sourceInputName, $source_value, $inputsize,"", "comparatoritem") .  "</div></div>";
				$sourceColumnsDone.=" " . $thisSourceColumn;
			//$strInconsistentLinks.=" | ";
			}
			else
			{
				$sourceValueLinks.="<br clear='all'/><div style='float:left;width:" . $linewidth . ";height:" . $lineheight . ";background-color:#" . $colorSurroundSource . "'>" . $sourceInput . "<span style='color:#990000'>NONE</span></div>";

				//$sourceValueLinks.= "<br/>";
			}
			if(!$no_dest_match)
			{
				$destValueLinks.=  "<div style='background-color:#" . $colorSurroundDest . "'>" .   "<div style='float:left;width:" . $linewidth . ";height:" . $lineheight . ";color:#990000'>" . $destInput . $thisCol . "</div> <div  style='float:right;width:" . $linewidthform . ";height:" . $lineheight . ";background-color:#" . $spanBgColor . "'>" .TextInput($destInputName,  $dest_value, $inputsize,"", "comparatoritem") . "</div></div>";
			}
			//$strInconsistentLinks.="<br/>";
			$count++;
			$height++;
			$columnNumber++;
		}
		if($no_dest_match)
		{
			$destValueLinks="No match found.";
		}
		if($height>1)
		{
			$height--;
		}
		$notesInput=GenericInput("notes|" . $inconsistency_id, $notes,  false,  "",  $strStyle="border:1px solid",  "",  "text", $size="30", "", $height);
		//$notesInput=TextInput("notes|" . $inconsistency_id , $notes,20);
		$out.=htmlrow($strThisBgClass,$sourceLink, $destLink , $sourceValueLinks, $destValueLinks, $notesInput);
 
		
	}
	}
	$out.="<tr  name='sortavoid'><td colspan='5'><div style='text-align:right'><nobr>" .  GenericInput("accept", "Generate Fix Script/Save Notes") .  " " . GenericInput("accept", "Save Notes") ."</nobr></div></td></tr>";
	$out.=HiddenInputs(Array("action"=>"generatefixes", "count"=>$count, "tabledest"=>$dest_table_name), ""); 
	$out=$preout . TableEncapsulate($out,  true, "1200", "idsorttable2");
	$out.="</form>";
	 
 
	return $out;
}

function essentialEquality($itemOne, $itemTwo)
{
	$strLimitspec="48-57 a-z A-Z ";
	$itemOne=strtolower(trim(FilterString($itemOne, $strLimitspec, "")));
	$itemTwo=strtolower(trim(FilterString($itemTwo, $strLimitspec, "")));
	if($itemOne==$itemTwo)
	{
		return true;
	}
	return false;
}

function Searchform( $strThisTable, $searchterm)
{
	$out="
	<form name='SForm' action='comparator.php' method='get'><nobr><span class=\"tf_search\">";
	$out.=TextInput("searchterm" ,  $searchterm,20);
	$out.=GenericInput("search", "Search") ;
	$out.=HiddenInputs(Array("action"=>"fixbrowser", "tabledest"=> $strThisTable),"");
	$out.="This search looks through every column of the " . $strThisTable . " table for a match to any record that has resulted in a discovered inconsistency.";
	$out.="</form>";
	return $out;
}
?>