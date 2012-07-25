<?php 
//Judas Gutenberg August 2008
//Searches through a database looking for changes since a set point
//of course, it doesn't bother searching through its own tables (or any other tableform tables)
//This code is covered under the GNU General Public License
//info here: http://www.gnu.org/copyleft/gpl.html
//the digest is as follows: you cannot modify this code without
//publishing your source code under the same license
//contact the developer at gus@asecular.com   

include_once('tf_functions_core.php');
include_once('tf_core_table_creation.php'); 
include_once('tf_functions_backup.php');
include_once('tf_functions_sql_parsing.php');
include_once('tf_functions_frontend_db.php');


echo main();

function main()
{
	if(!IsExtraSecure())
	{
		die(ExtraSecureFailure());
	}

	
	//$olderror=error_reporting(0);
	$mode=$_REQUEST[qpre . "mode"];
	$submitsave=$_REQUEST[qpre . "submit_save"];
	$showsave=$_REQUEST[qpre . "submit_show"];
	$mode=$_REQUEST[qpre . "mode"];
	$dbdiff_id=$_REQUEST["dbdiff_id"];
	$strDatabase=deMoronizeDB(gracefuldecay($_REQUEST[qpre . "db"],our_db));
	$strColumn=$_REQUEST[qpre . "column"];
	$comprehensivesearch=gracefuldecay($_REQUEST[qpre . "comprehensivesearch"],0);
	error_reporting($olderror);
	$strPHP=$_SERVER['PHP_SELF'];
	$out="";
	//echo $id . " " .$idfield ;
	$out=LoginDecisions($strDatabase,  $strPHP, $strUser, true);
	
	if ($strUser!="")
	{
		MakeTableIfNotThere($strDatabase, tfpre . "dbdiff", "MakeDBDiffTables");
		$intAdminType= AdministerType($strDatabase, $strTable, $strUser);
 
		if ($intAdminType>1)
		{
				 
			if ($intSearchType=="")
			{
				$intSearchType=0;
			}
			if ($intRecord=="")
			{
				$intRecord=0;
			}
			$out.= SetPointForm($strDatabase);
			if($submitsave!="")
			{
				$out.="<div class='feedback'>" . SetChanged($strDatabase) . "</div>";
			}
			else if($showsave!="" || $dbdiff_id!="")
			{

				$out.=  WhatChanged($strDatabase, $dbdiff_id);
			}
			else if ($mode=="othersetpoints")
			{
				$out.=  OtherSetPointsList($strDatabase);
			}
			else if ($mode=="clearallsetpoints")
			{
				$out.= "<div class='feedback'>" . ClearAllSetpoints($strDatabase). "</div>";
			}
			
			
		}
	}
	$out =  PageHeader($strDatabase . " : database difference analyzer", $strConfigBehave, "", true, false, "", $strDatabase) . $out . PageFooter();
	
	return $out;
}
	
function WhatChanged($strDatabase, $dbdiff_id, $intMaxColumns=10, $bwlTruncate=true)
{
 
	$bwlSortTableOrder=true;//dude i can handle this bitch now
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strOtherBgClass="bgclassother";
	$strLineClass="bgclassline";
	$strThisBgClass=$strClassFirst;
	$strTableBgClass=$strClassFirst;
	$sql=conDB(); 
 	$strFieldName="Tables_in_" . str_replace("`", "", $strDatabase);
	$tables=TableList($strDatabase);
	if($dbdiff_id=="")
	{
		$strSQL="SELECT  dbdiff_id, diff_performed FROM " . $strDatabase  . "." . tfpre . "dbdiff ORDER BY diff_performed DESC LIMIT 0,1";
	}
	else
	{
		$strSQL="SELECT  dbdiff_id, diff_performed FROM " . $strDatabase  . "." . tfpre . "dbdiff WHERE dbdiff_id='" . $dbdiff_id . "'";
	}
	//echo $strSQL . " " . sql_error() . "<p>";
	$rs = $sql->query($strSQL);
	
	$r=$rs[0];
	$id=$r["dbdiff_id"];
	$dtmDiffperformed=$r["diff_performed"];

	$out="";
	$preout="";
	if($id=="")
	{
		$preout.= adminbreadcrumb(false,  $strDatabase, "tf.php"  . qpre . "db=" . $strDatabase,  "db tools", "tf_dbtools.php" . qpre . "db=" . $strDatabase, "no set points stored") ;
 		
	}
	else
	{
		$preout.= adminbreadcrumb(false,  $strDatabase, "tf.php"  . qpre . "db=" . $strDatabase,  "db tools", "tf_dbtools.php" . qpre . "db=" . $strDatabase, "tables changed since set point set at " . $dtmDiffperformed, "") ;
		$preout.= "<script src=\"tf_tablesort.js\"><!-- --></script>";
 		
		if($bwlSortTableOrder)//the following code won't work unless SortTable is expanded to deal with interleaved table rows
		{
			$out.=htmlrow("bgclassline", 
			"<a href=\"javascript: SortTable('idsorttable', 0)\">table</a>",
			"<a href=\"javascript: SortTable('idsorttable', 1)\">old checksum</a>",
			"<a href=\"javascript: SortTable('idsorttable', 2)\">new checksum</a>",
			 "<a href=\"javascript: SortTable('idsorttable', 3)\">records</a>",
			  "<a href=\"javascript: SortTable('idsorttable', 4)\">columns</a>",
			  "&nbsp;",
			   "&nbsp;",
			    "&nbsp;",
				 "&nbsp;",
				  "&nbsp;",
				   "&nbsp;");
		}
		else
		{
			$out.=htmlrow("bgclassline", 
			"table",
			"old checksum",
			"new checksum",
			 "records",
			  "columns",
			  "&nbsp;",
			   "&nbsp;",
			    "&nbsp;",
				 "&nbsp;",
				  "&nbsp;",
				   "&nbsp;");
		
		}
		$intColspan=11;
		$bwlTableMakerExists=file_exists("tf_table_maker.php");
		
		$tablecount=0;
		foreach ($tables as  $k=>$v )
		{
		
			$tablename=$v[$strFieldName];
			$newcount = countrecords($strDatabase , $tablename );
			$newchecksum=tablechecksum($strDatabase, $tablename );
			$strSQL="SELECT * FROM " . $strDatabase . "." . tfpre . "dbdiff_table WHERE dbdiff_id='" . $id . "' AND table_name='" . $tablename . "'";
			//echo $strSQL . " " . sql_error() . "<p>";
			$rs = $sql->query($strSQL);
			$r=$rs[0];
			$oldcount=$r["table_rowcount"];
			
			$oldchecksum=$r["table_checksum"];
			$old_max_id=$r["max_id"];
			//echo $oldcount . "+-+" . $newcount . "<br>";
			if ($oldchecksum!=$newchecksum  && !beginswith($tablename,  tfpre ))
			{
				//okay show me the changed tables:
				//$new_max_id=highestprimarykey($strDatabase, $tablename);
				$intDelta=$newcount-$oldcount;
				$strDelta="";
				if($oldcount<$newcount)
				{
					$strDelta="+" . $intDelta;
				}
				else
				{
					$strDelta=$intDelta;
				}
				if( $strDelta!=""  && $intDelta!=0 )
				{
					$strDelta="(<span style='color:#ff0000'>" . $strDelta . "</span>)";
				}
				else
				{
					$strDelta="";
				}
				$strTableBgClass=Alternate($strClassFirst, $strClassSecond, $strTableBgClass);
				$count = countrecords($strDatabase , $tablename );
				$fieldcount=FieldCount($strDatabase, $tablename);
				
				if ($bwlTableMakerExists)
				{
					$tablemakerlink= "<nobr>[<a href=\"" . qbuild("tf_table_maker.php", $strDatabase, $tablename , "", "", "") . "\">edit def.</a>]</nobr>";
				}
				else
				{
					$tablemakerlink= "&nbsp;";
				} 
				$out.=htmlrow
				(
					$strTableBgClass, 
					"<a href=\"" . qbuild("tf.php", $strDatabase, $tablename , "view", "", "") . "\">" . $tablename . "</a>", 
	
					$oldchecksum,
					$newchecksum,
					$count . " " . $strDelta,
					$fieldcount,
						$tablemakerlink,
					"[<a onclick=\"return(tableconfirm('drop', '" .  $tablename . "'))\" href=\"" . qbuild("tf_dbtools.php", $strDatabase, $tablename , "drop", "", "") . "\">drop</a>]",
					"[<a onclick=\"return(tableconfirm('empty', '" .  $tablename . "'))\" href=\"" . qbuild("tf_dbtools.php", $strDatabase, $tablename , "empty", "", "") . "\">empty</a>]",
					"[<a target=\"_new\" href=\"" . qbuild("tablexml.php", $strDatabase, $tablename , "view", "", "") . "\">XML</a>]",
					"[<a href=\"" . qbuild("tf_dbtools.php", $strDatabase, $tablename , "backup", "", "") . "\">SQL</a>]",
					"[<a href=\"" . qbuild("tf_dump.php", $strDatabase, $tablename , "", "", "") . "\">export</a>]",
					"[<a href=\"" . qbuild("tf_import.php", $strDatabase, $tablename , "", "", "") . "\">import</a>]"
				);
				
				//now show additional records as editable lines!!!!
				$pk=PKLookup($strDatabase, $tablename);
				
				if(!hasautocount($strDatabase, $tablename))
				{
					
					//usually returns freshest rows in a complex non-autoincrement table
					//$firstdatefield=FirstDateTimeField($strDatabase, $tablename);
					//if($firstdatefield!="")
					//{
						//$strSQL="SELECT * FROM " . $strDatabase . "." . $tablename . " ORDER BY " . $firstdatefield . " DESC  LIMIT 0, " .$intDelta;
					//}
					//else
					{
						//this seems to work okay with the xcart customer table
						$strSQL="SELECT * FROM " . $strDatabase . "." . $tablename . " LIMIT " . intval($newcount-1). ", " .$intDelta;
					}
					//echo $strSQL . "<p>";
			
					
				}
				else
				{
					$strSQL="SELECT * FROM " . $strDatabase . "." . $tablename . " WHERE " . $pk . ">'" . $old_max_id . "'";
					
				}
				if( $old_max_id!="")
				{
					if(!is_array($pk))//don't worry about compound pks for this case, too complicated
					{
						//to do this, we're going to need to insert a row with a colspan
						$out.="<tr><td>&nbsp;</td><td colspan=\"" . $intColspan . "\">";
						//echo $strSQL;
						
						$delta_rs = $sql->query($strSQL);
						$intRowCount=0;
						foreach($delta_rs as $delta_r)
						{
						
						
							//header for the data:
							if($intRowCount==0)
							{
								$intHeadfieldCount=0;
								foreach($delta_r as $k=>$v)
								{
									$strQHTMLOut.="<td valign=\"top\">";
									$strQHTMLOut.="<a href=\"javascript: SortTable('idsorttable" . $tablecount ."', " . $intHeadfieldCount . ")\">" . $k . "</a>";
									$strQHTMLOut.="</td>";
									$intHeadfieldCount++;
									if($intHeadfieldCount>$intMaxColumns-1)
									{
										break;
									}
								}
								$strQHTMLOut.="<td>&nbsp;</td>";//for delete part of the table
								$strQHTMLOut.="</tr>\n";
								$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
								$strQHTMLOut.= "<tr class=\"" . $strThisBgClass . "\">\n";
							}
						
						
							
							$strThisSubBgClass=Alternate($strClassFirst, $strClassSecond, $strThisSubBgClass);
							$strQHTMLOut.="<tr class=\"" . $strThisSubBgClass . "\">\n";
							$intFieldCount=0;
							foreach($delta_r as $k=>$v)
							{
							
								
								$strQHTMLOut.="<td valign=\"top\">";
			
								$thisatag="";
								
								if($k==$pk)
								{
									$thisatag="<a href=\"" . qbuild("tf.php", $strDatabase, $tablename, "edit",  $k, $v) . "\">";
									$pkval=$v;
								}	
					
								
								
								if(!$bwlTruncate)
								{
									$strQHTMLOut.= $thisatag . str_replace(chr(10), chr(10) . "<br/>" , $v) . IfAThenB($thisatag, "</a>");
								}
								else
								{
									$strQHTMLOut.=$thisatag . simplelinkbody($v) . IfAThenB($thisatag, "</a>");
								}
								
								$strQHTMLOut.="</td>\n";
								$intFieldCount++;
								if($intFieldCount>$intMaxColumns-1)
								{
									break;
								}
							}
							//http://threethirty.com/~mcertified/tf.php?x_db=mcertified&x_table=tf_dbdiff&x_mode=delete&x_idfield=dbdiff_id&dbdiff_id=1&x_displaytype=&x_filterid=&x_column=dbdiff_id&x_direction=&x_rec=0
							
							$strQHTMLOut.="<td>\n";
							$strQHTMLOut.="<a onclick=\"javascript:return(confirm('Are you sure you want to delete " . $strTable . " number " . $pkval . "?'))\" href='" . qbuild("tf.php", $strDatabase, $tablename, "delete", $pk, $pkval) . "&" . "'>Delete</a>";
						
							$strQHTMLOut.="</td>\n";
							$strQHTMLOut.="</tr>\n";		
							$intRowCount++;
						
						}
						
						$strQHTMLOut =TableEncapsulate($strQHTMLOut, true, "100%", "idsorttable" . $tablecount);
						
						$out.=$strQHTMLOut;
						$strQHTMLOut="";
						
						$out.="</td></tr>\n";
						$tablecount++;
					}
				} 
			
			}
			
			//echo $strSQL . " " . sql_error() . "<p>";
		}
		
		
		//for now we're not going to bother with dynamically sorting table order, too complex!
	}
 	$out=$preout . TableEncapsulate($out, $bwlSortTableOrder);
	return $out;

}

function OtherSetPointsList($strDatabase)
{
	//GenericRSDisplay($strDatabase, $strPHP,$strLabel, $strSQL, $truncate, $intWidth, $strLinkFieldName="", $strLinkIDName="", $strAdditionalLink="", $strSuppressFields="", $bwlSuppressHeader=false, $bwlPrettyUpFieldNames=true)
	$strSQL= "SELECT * FROM " . $strDatabase . "." . tfpre . "dbdiff ORDER BY diff_performed DESC LIMIT 0,20";
	$out=GenericRSDisplay($strDatabase, "tf_db_difference.php","Select a past set point:",$strSQL, true, 400, "dbdiff_id", "dbdiff_id");
	$out=str_replace("diff performed", "time check point set", $out);
	return $out;
}


function ClearAllSetpoints($strDatabase)
{
	$out=emptyTable($strDatabase, tfpre . "dbdiff");
	$out.="<br>/n";
	$out.=emptyTable($strDatabase, tfpre . "dbdiff_table");
	return $out;
}


function SetPointForm($strDatabase)
{
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strPHP="tf.php";
	$preout= adminbreadcrumb(false, $strDatabase, $strPHP . "?" . qpre . "db=" . $strDatabase,"db tools","tf_dbtools.php?" . qpre . "db=" . $strDatabase,  "analyze database changes", "");
	$preout.="<form enctype=\"multipart/form-data\" name=\"BForm\" action=\"tf_db_difference.php\" method=\"post\">\n";
	$preout.="<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"12000000\" />";

 
	$out="<tr class=\"bgclassline\"><td colspan=\"2\">\n";
	$strButtonLabel= "Search";
	$out.="</strong>\n</td></tr>\n";
	//$out.=htmlrow($strClassFirst, 
	//	"field to search for: ",
	//	GenericInput(qpre . "column", $strColumn, false, "",  "", "", "text", "44")
	//	);

	
	$out.=htmlrow("bgclassline", 
		GenericInput(qpre . "submit_save",   "Create database set point for this instant"),
		GenericInput(qpre . "submit_show",  "Show changes since last set point"),
		"<a href=\"tf_db_difference.php?" . qpre . "mode=othersetpoints\">earlier set points</a>" .
		"<br>" . 
		"<a onclick=\"return(confirm('Are you certain you want to clear all set points?'))\" href=\"tf_db_difference.php?" . qpre . "mode=clearallsetpoints\">clear all set points</a>"
		);

	$out.= HiddenInputs(array("db"=>$strDatabase));
	$out.="</td></tr>\n";
	$out=  $preout . TableEncapsulate($out, false);
	$out.="</form>\n";
	return $out;
}

function FirstDateTimeField($strDatabase, $strTable)
//Give me the first date or time field, useful for ranking freshness of rows in tables with no autoincrement.
{
	$sql=conDB();
	$arrOut=Array();
	$records=TableExplain($strDatabase, $strTable);
	//echo "<B>" . $strTable  . "</b><br>";
	foreach ($records as $k => $v )
	{
		//echo $v["Type"] . " " . $v["Field"] . "<br>";
		if(contains($v["Type"], "date") || contains($v["Type"], "time"))
		return $v["Field"];
	}
}

?>