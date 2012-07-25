<? 
//Judas Gutenberg August 2008
//Searches through a database looking for changes since a set point
//of course, it doesn't bother searching through its own tables (or any other tableform tables)
//This code is covered under the GNU General Public License
//info here: http://www.gnu.org/copyleft/gpl.html
//the digest is as follows: you cannot modify this code without
//publishing your source code under the same license
//contact the developer at gus@asecular.com  http://asecular.com

include('core_functions.php');
include('coretablecreation.php'); 
include('backup_functions.php');
include('sqlparsing_functions.php');
include('frontenddbfunctions.php');


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
	$out =  PageHeader($strDatabase . " : database difference analyzer", $strConfigBehave) . $out . PageFooter();
	
	return $out;
}
	
function WhatChanged($strDatabase, $dbdiff_id, $intMaxColumns=10, $bwlTruncate=true)
{
	$bwlSortTableOrder=false;
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strOtherBgClass="bgclassother";
	$strLineClass="bgclassline";
	$strThisBgClass=$strClassFirst;
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

	if($id=="")
	{
		$out.= adminbreadcrumb(false,  $strDatabase, "tableform.php",  "db tools", "dbtools.php", "no set points stored") ;
	}
	else
	{
		$out.= adminbreadcrumb(false,  $strDatabase, "tableform.php",  "db tools", "dbtools.php", "tables changed since set point set at " . $dtmDiffperformed, "") ;
		$out.= "<script src=\"tablesort_js.js\"><!-- --></script>";
		$out.= "<table  id=\"idsorttable\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\" class=\"" .$strLineClass  . "\" width=\"730\">\n";
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
		$bwlTableMakerExists=file_exists("tablemaker.php");
		
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
				$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
				$count = countrecords($strDatabase , $tablename );
				$fieldcount=FieldCount($strDatabase, $tablename);
				
				if ($bwlTableMakerExists)
				{
					$tablemakerlink= "<nobr>[<a href=\"" . qbuild("tablemaker.php", $strDatabase, $tablename , "", "", "") . "\">edit def.</a>]</nobr>";
				}
				else
				{
					$tablemakerlink= "&nbsp;";
				} 
				$out.=htmlrow
				(
					$strThisBgClass, 
					"<a href=\"" . qbuild("tableform.php", $strDatabase, $tablename , "view", "", "") . "\">" . $tablename . "</a>", 
	
					$oldchecksum,
					$newchecksum,
					$count . " " . $strDelta,
					$fieldcount,
						$tablemakerlink,
					"[<a onclick=\"return(tableconfirm('drop', '" .  $tablename . "'))\" href=\"" . qbuild("dbtools.php", $strDatabase, $tablename , "drop", "", "") . "\">drop</a>]",
					"[<a onclick=\"return(tableconfirm('empty', '" .  $tablename . "'))\" href=\"" . qbuild("dbtools.php", $strDatabase, $tablename , "empty", "", "") . "\">empty</a>]",
					"[<a target=\"_new\" href=\"" . qbuild("tablexml.php", $strDatabase, $tablename , "view", "", "") . "\">XML</a>]",
					"[<a href=\"" . qbuild("dbtools.php", $strDatabase, $tablename , "backup", "", "") . "\">SQL</a>]",
					"[<a href=\"" . qbuild("dump.php", $strDatabase, $tablename , "", "", "") . "\">export</a>]",
					"[<a href=\"" . qbuild("import.php", $strDatabase, $tablename , "", "", "") . "\">import</a>]"
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
						$out.="<table id=\"idsorttable" . $tablecount . "\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\" class=\"" .$strLineClass  . "\" width=\"100%\">\n";
						
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
							$out.="<tr class=\"" . $strThisSubBgClass . "\">\n";
							$intFieldCount=0;
							foreach($delta_r as $k=>$v)
							{
							
								
								$strQHTMLOut.="<td valign=\"top\">";
			
								$thisatag="";
								
								if($k==$pk)
								{
									$thisatag="<a href=\"" . qbuild("tableform.php", $strDatabase, $tablename, "edit",  $k, $v) . "\">";
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
							//http://threethirty.com/~mcertified/tableform.php?x_db=mcertified&x_table=tf_dbdiff&x_mode=delete&x_idfield=dbdiff_id&dbdiff_id=1&x_displaytype=&x_filterid=&x_column=dbdiff_id&x_direction=&x_rec=0
							
							$strQHTMLOut.="<td>\n";
							$strQHTMLOut.="<a onclick=\"javascript:return(confirm('Are you sure you want to delete " . $strTable . " number " . $pkval . "?'))\" href='" . qbuild("tableform.php", $strDatabase, $tablename, "delete", $pk, $pkval) . "&" . "'>Delete</a>";
						
							$strQHTMLOut.="</td>\n";
							$out.=$strQHTMLOut;
							$strQHTMLOut="";
							$out.="</tr>\n";
							//$strQHTMLOut .= $thislashatag;
							$strQHTMLOut.="</td>";
							$intRowCount++;
						}
						
						$out.="</table></td></tr>\n";
						
						
						$out.="<script>NumberRows('idsorttable" . $tablecount ."', 4);</script>";
						$tablecount++;
					}
				} 
			
			}
			//echo $strSQL . " " . sql_error() . "<p>";
		}
		 
		$out.="</table>"; 
		//for now we're not going to bother with dynamically sorting table order, too complex!
		if($bwlSortTableOrder)
		{
			$out.="<script>NumberRows('idsorttable', 4);</script>";
		}
	}
	return $out;

}

function OtherSetPointsList($strDatabase)
{
	//GenericRSDisplay($strDatabase, $strPHP,$strLabel, $strSQL, $truncate, $intWidth, $strLinkFieldName="", $strLinkIDName="", $strAdditionalLink="", $strSuppressFields="", $bwlSuppressHeader=false, $bwlPrettyUpFieldNames=true)
	$strSQL= "SELECT * FROM " . $strDatabase . "." . tfpre . "dbdiff ORDER BY diff_performed DESC LIMIT 0,20";
	$out=GenericRSDisplay($strDatabase, "dbdiff.php","Select a past set point:",$strSQL, true, 400, "dbdiff_id", "dbdiff_id");
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
	$strPHP="tableform.php";
	$out.= adminbreadcrumb(false, $strDatabase, $strPHP . "?" . qpre . "db=" . $strDatabase,"db tools","dbtools.php",  "analyze database changes", "");
	$out.="<form enctype=\"multipart/form-data\" name=\"BForm\" action=\"dbdiff.php\" method=\"post\">\n";
	$out.="<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"12000000\" />";

	$tableheader="<table class=\"bgclassline\" cellpadding=\"0\" cellspacing=\"1\" border=\"0\" width=\"700\">\n";
	$out.=$tableheader;
	$out.="<tr class=\"bgclassline\"><td colspan=\"2\">\n";
	$strButtonLabel= "Search";
	$out.="</strong>\n</td></tr>\n";
	//$out.=htmlrow($strClassFirst, 
	//	"field to search for: ",
	//	GenericInput(qpre . "column", $strColumn, false, "",  "", "", "text", "44")
	//	);

	
	$out.=htmlrow("bgclassline", 
		GenericInput(qpre . "submit_save",   "Create database set point for this instant"),
		GenericInput(qpre . "submit_show",  "Show changes since last set point"),
		"<a href=\"dbdiff.php?" . qpre . "mode=othersetpoints\">earlier set points</a>" .
		"<br>" . 
		"<a onclick=\"return(confirm('Are you certain you want to clear all set points?'))\" href=\"dbdiff.php?" . qpre . "mode=clearallsetpoints\">clear all set points</a>"
		);

	$out.= HiddenInputs(array("db"=>$strDatabase));
	$out.="</td></tr>\n";
	$out.="</table>\n";
	$out.="</form>\n";
	return $out;
}

function FirstDateTimeField($strDatabase, $strTable)
//Give me the first date or time field, useful for ranking freshness of rows in tables with no autoincrement.
{
	$sql=conDB();
	$arrOut=Array();
	$records=DBExplain($strDatabase, $strTable);
	//echo "<B>" . $strTable  . "</b><br>";
	foreach ($records as $k => $v )
	{
		//echo $v["Type"] . " " . $v["Field"] . "<br>";
		if(contains($v["Type"], "date") || contains($v["Type"], "time"))
		return $v["Field"];
	}
}

?>