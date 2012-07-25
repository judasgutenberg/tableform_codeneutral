<?php
//Judas Gutenberg, nov 26 2006
//tools for a tableform mysql db
//This code is covered under the GNU General Public License
//info here: http://www.gnu.org/copyleft/gpl.html
//the digest is as follows: you cannot modify this code without
//publishing your source code under the same license
//contact the developer at gus@asecular.com  http://asecular.com

set_time_limit(9000);
include('tf_functions_core.php');
include('tf_functions_frontend_db.php');
include('tf_functions_backup.php');
include_once('tf_functions_sql_parsing.php');
include('tf_core_table_creation.php');
include('tf_functions_color_math.php');
if (file_exists('tf_odbc_functions.php'))
{
	include_once('tf_odbc_functions.php');
}

echo main();

function main()
{
	if(!IsExtraSecure())
	{
		die(ExtraSecureFailure());
	}
	$mode=$_REQUEST[qpre . "mode"];
	//for some reason single quotes are escaped when coming in off the $_REQUEST collection
	$actsql=deescape($_REQUEST[qpre . "actscript"]);
	$language_id=$_REQUEST[qpre . "language_id"];
	//echo "-" . $language_id;
	$strPostRunScript=deescape($_REQUEST[qpre . "postrunscript"]);
	$truncate=deescape($_REQUEST[qpre . "truncate"]);
	if(!array_key_exists(qpre . "truncate", $_REQUEST))
	{
		//$truncate=true;
	}
	$strTable=$_REQUEST[qpre . "table"];
	$strDatabase=deMoronizeDB(gracefuldecay($_REQUEST[qpre . "db"],our_db));
	$strPHP=$_SERVER['PHP_SELF'];
	$bwlAddSlashes=false;
	$bwlDirectediting=IfAThenB($_REQUEST[qpre . "directediting"], true);
	if($_REQUEST[qpre . "addslashes"]!="")
	{
		$bwlAddSlashes=true;
	}
	$feedbackspanstag="<div class=\"feedback\">";
	$redoFKScan=deescape($_REQUEST[qpre . "redofkscan"]);
	$out="";
	//echo $id . " " .$idfield ;
	if($mode!="backup")
	{
		$out=LoginDecisions($strDatabase,  $strPHP, $strUser, false);
	}
	else
	{
		//i have to do this to backup
		$strUser=WhoIsLoggedIn();
		if (IsSuperAdmin($strDatabase, $strUser))
		{
			backupDBtoSQL($strDatabase, $strTable, $bwlAddSlashes);
			die();
		}
	}
	if (IsSuperAdmin($strDatabase, $strUser)  && $strUser!="")
	{
	
		$intAdminType= AdministerType($strDatabase, $strTable, $strUser);
		$feedback="";
		if ($intAdminType>1)
			{
				$sql=conDB();
			 	if ($mode=="drop")
				{
					EnsureNonRemote();
					$feedback.= dropTable($strDatabase, $strTable). "<br/>";
				}
		 		if($mode=="resetautoincrement")
				{
					EnsureNonRemote();
					$feedback.= ResetAutoIncrement($strDatabase, $strTable). "<br/>";
				}
 				if ($mode=="empty")
				{
					EnsureNonRemote();
					$feedback.=    emptyTable($strDatabase, $strTable) . "<br/>";
				}
				if ($mode=="create")
				{
					EnsureNonRemote();
					$feedback.= createAuxillaryTable($strDatabase, $strTable) . "<br/>";
				}
		
				//handle the creation of auxillary tables
				if(is_array($_REQUEST[qpre . "auxtables"]))
				{
					//read each auxillary table package checkoff and add them to the database
					foreach($_REQUEST[qpre . "auxtables"] as $auxtable)
					{
						//echo $auxtable . "<br>";
						EnsureNonRemote();
						$feedback.=   createAuxillaryTable($strDatabase,$auxtable) . "<br/>";
					}
		
				}
				
				if($_REQUEST[qpre . "editresults"]!="")
				{
					$saveout=SaveDataEdits($strDatabase);
					if($saveout=="error")
					{
						$feedback.= "Result data was too complex to edit.";
					}
					else
					{
						$feedback.= $saveout;
					}
				}
				if(is_array($_REQUEST[qpre . "killrelation"]))
				{
					EnsureNonRemote();
					foreach($_REQUEST[qpre . "killrelation"] as $kill)
					{
						$arrKill=explode("|", $kill);
						$strSQL="DELETE  FROM " . $strDatabase . "." .  tfpre . "relation WHERE relation_id=" .  $arrKill[4];
						if(CanChange())
						{
							$tables = $sql->query($strSQL);
							$feedback.=  "An invalid relationship between the " . $arrKill[1] . " column in " . $arrKill[0] . " and the " . $arrKill[3] . " column in " . $arrKill[2] . " table was removed.<br/>";
						}
						else
						{
							$feedback.=  "Database is read-only.<br/>";
						}
		 
						
					}
				}
				if(is_array($_REQUEST[qpre . "acceptrelation"]))
				{
					EnsureNonRemote();
					MakeTableIfNotThere($strDatabase, tfpre . "relation", "MakeRelationTables");
		
				
					//remove any invalid relations

					//read each accepted relation from relation scanner and add it to the relation table
					foreach($_REQUEST[qpre . "acceptrelation"] as $accept)
					{
						//echo $accept . "<br>";
						$arrAccept=explode("|", $accept);
						$strSQL="SELECT table_name FROM " . $strDatabase . "." .  tfpre . "relation WHERE table_name='" . $arrAccept[0] . "' AND column_name='" . $arrAccept[1] . "' AND f_table_name='" . $arrAccept[2] . "' AND f_column_name='" . $arrAccept[3] . "' AND relation_type_id=0";
						$rs = $sql->query($strSQL);
						if (count($rs)<1)
						{
							$strSQL="INSERT INTO " . $strDatabase . "." .  tfpre . "relation (table_name, column_name, f_table_name, f_column_name,relation_type_id) VALUES ('" . $arrAccept[0] . "','" . $arrAccept[1] . "','" . $arrAccept[2] . "','" . $arrAccept[3] . "'," . "0);";

							//echo $strSQL . "<br>";
							//echo sql_error();
							
							
							if(CanChange())
							{
								$tables = $sql->query($strSQL);
								$feedback.=  "A relationship was created between the " . $arrAccept[1] . " column in " . $arrAccept[0] . " and the " . $arrAccept[3] . " column in " . $arrAccept[2] . " table.<br/>";
							}
							else
							{
								$feedback.=  "Database is read-only.<br/>";
							}
						
						
					 
							
						}
					}
				
				}
				if($feedback!="")
				{
					$feedback = $feedbackspanstag . $feedback . "</div>";
				}
				$out.= $feedback;
				if ($mode=="entersql")
				{
				
					$out.= EnterSQL($strDatabase, $strPHP, $actsql, $truncate, $bwlDirectediting, $strPostRunScript, $language_id);
				}
				else if($mode=="stats")
				{
					$out.=  DBStats($strDatabase);
				
				}
				else if ($mode=="fkscan")
				{
					EnsureNonRemote();
					if($redoFKScan!="")
					{
						$out.= FKscan($strDatabase, $strPHP, true);
					}
					else
					{
						$out.= FKscan($strDatabase, $strPHP, false);
					}
				}
				else if ($mode=="auxpick")
				{
					$out.= AuxillaryTablePicker($strDatabase, $strPHP);
				}
				else
				{
					$out.= AdminTableBrowser($strDatabase, $strPHP);
					//$out.= "<p/>";
					
					
				}
				if ($actsql!="")
				{
					$out.= ActSQL($strDatabase, $strPHP, $actsql, $truncate, false, $bwlDirectediting, $strPostRunScript, $language_id);
				
				}
				$out.= "<p/>";
				//$out.= OtherTools($strDatabase, $strPHP);
			}
	}
	else if($strUser!="")
	{
		$out.=  "You do not have permissions to see this content.";
	}
	$out =  PageHeader($strDatabase . IfAThenB($strTable, " : ") . $strTable . IfAThenB($mode, " : ") . $mode . " : db tools", $strConfigBehave, "", true, false, "", $strDatabase) . $out . PageFooter();
	
	return $out;
}



	
function AdminTableBrowser($strDatabase, $strPHP)
//Shows all the tables in $strDatabase and allows an admin to drop and clear all data, as well as other table-level DBA things
{
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strOtherBgClass="bgclassother";
	$strLineClass="bgclassline";
	$strThisBgClass=$strClassFirst; 
	$tables=TableList($strDatabase);
	$preout="";
	$preout.= adminbreadcrumb(false,  $strDatabase, "tf.php?" . qpre . "db=" . $strDatabase,  "db tools", "", "table tools", "") ;
	$preout.= "<script src=\"tf_tablesort.js\"><!-- --></script>";

	$out=htmlrow("bgclassline", 
	"<a href=\"javascript: SortTable('idsorttable', 0)\">table</a>",
	 "<a href=\"javascript: SortTable('idsorttable', 1)\">records</a>",
	  "<a href=\"javascript: SortTable('idsorttable', 2)\">columns</a>",
	  "&nbsp;",
	   "&nbsp;",
	    "&nbsp;",
		 "&nbsp;",
		  "&nbsp;",
		  "&nbsp;",
		  "&nbsp;",
		  "&nbsp;",
		  "&nbsp;",
		   "&nbsp;");
	$strFieldName="Tables_in_" . str_replace("`", "", $strDatabase);
	$bwlTableMakerExists=file_exists("tf_table_maker.php");
	foreach ( $tables as  $k=>$v )
	{
		$tablename=$v[$strFieldName];
		$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
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
			$strThisBgClass, 
			"<a href=\"" . qbuild("tf.php", $strDatabase, $tablename , "view", "", "") . "\">" . $tablename . "</a>", 
			$count,
			$fieldcount,
 			$tablemakerlink,
			"[<a onclick=\"return(tableconfirm('drop', '" .  $tablename . "'))\" href=\"" . qbuild($strPHP, $strDatabase, $tablename , "drop", "", "") . "\">drop</a>]",
			"[<a onclick=\"return(tableconfirm('empty', '" .  $tablename . "'))\" href=\"" . qbuild($strPHP, $strDatabase, $tablename , "empty", "", "") . "\">empty</a>]",
			"[<a target=\"_new\" href=\"" . qbuild("tablexml.php", $strDatabase, $tablename , "view", "", "") . "\">XML</a>]",
			"[<a href=\"" . qbuild("tf_dbtools.php", $strDatabase, $tablename , "backup", "", "") . "\">SQL</a>]",
			"[<a href=\"" . qbuild("tf_dump.php", $strDatabase, $tablename , "", "", "") . "\">export</a>]",
			"[<a href=\"" . qbuild("tf_import.php", $strDatabase, $tablename , "", "", "") . "\">import</a>]",
			"[<a href=\"" .  qbuild("tf.php", $strDatabase, $tablename , "viewrelated", "", ""). "\">related</a>]",
			"[<a href=\"" . qbuild("tf_dbtools.php", $strDatabase, $tablename , "resetautoincrement", "", "") . "\">reset++</a>]",
			"[<a href=\"" . qbuild("tf.php", $strDatabase, $tablename , "columnanalysis", "", "") . "\">analysis</a>]"
		);
		 
	}
 
	$out=$preout . TableEncapsulate($out, true, '700');
	return $out;
}
	
function AuxillaryTablePicker($strDatabase, $strPHP)
//allows an admin to pick and pre-build certain important tables in a tableform mysql db.
{
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strOtherBgClass="bgclassother";
	$strLineClass="bgclassline";
	$strThisBgClass=$strClassFirst;
	$strConfig="admin|Allows the creation of user rights and superusers.-relation|Allows crosstable browsing and editing.-permission|Allows users to be given specific tables to control.-column_info|Allows column help, aliasing, and hiding.-browsescheme|Allows special and customizable views/editors of data.-page|A prerequisite for stats and ad.-calendar|A parallel calendaring system.-stats|A web stats system.-ad|An advertisement placement and logging system.";
	$preout= "";
	$arrConfig=explode("-", $strConfig);
	$preout.= "<script src=\"tf_tablesort.js\"><!-- --></script>";
	$preout.= adminbreadcrumb(false,  $strDatabase,"tf.php?" . qpre . "db=" . $strDatabase,  "db tools", $strPHP . "?" . qpre . "db=" . $strDatabase, "install table packages", "") ;
	$out= "<form method=\"post\" name=\"BForm\" action=\"" .  $strPHP . "\">\n";
 	$out.= "\n" . HiddenInputs(array( "db"=>$strDatabase));
	$out.="<tr>\n";
	$out.="<td colspan=\"3\">\n";
	$out.="<span class=\"heading\">Add Table Package(s)</span>";
	$out.="</td>\n";
	$out.="</tr>\n";
	$out.=htmlrow($strLineClass, "<a href=\"javascript: SortTable('idsorttable', 0)\">table system</a>", "<a href=\"javascript: SortTable('idsorttable', 1)\">info</a>", "add");
	for($i=0; $i<count($arrConfig); $i++)
	{
		$arrThisTable=explode("|", $arrConfig[$i]);
		$strThisTable=$arrThisTable[0];
		$strAbout=$arrThisTable[1];
		$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
		$strTableToLookup=$strThisTable;
		$bwlChecked=false;
		if ($strThisTable=="stats")
		{
			$strTableToLookup="website_hithour";
		}
		else if  (!inList("ad calendar page", $strThisTable))
		{
			$strTableToLookup=tfpre . $strThisTable;
		
		}
		if (TableExists($strDatabase, $strTableToLookup))
		{
			$bwlChecked=true;
		}
		$out.=htmlrow($strThisBgClass, $strThisTable, $strAbout, CheckboxInput(qpre . "auxtables[]", $strThisTable, $bwlChecked, "", "", ""));
	} 
	$out.="<tr>\n";
	$out.="<td colspan=\"2\">\n";
	$out.="Clicking 'Add' will add the checked table packages to the database.\n<br>\n";
	$out.="<a href=\"javascript:alldumpcheckboxes('auxtables[]', true)\">select all</a> | <a href=\"javascript:alldumpcheckboxes('auxtables[]', false)\">select none</a>";
	$out.="</td>\n";
	$out.="<td>\n";
	$out.="<input type=\"Submit\" class=\"btn\" onmouseover=\"this.className='btn btnhov'\" onmouseout=\"this.className='btn'\" value=\"Add\">";
	$out.="</td>\n";
	$out.="</tr>\n";
	
	
	
	$out.="</form>";
	$out=$preout . TableEncapsulate($out);
	//$out.= "<a href=\"javascript:domdumpwindow()\">dump</a>";
	return $out;
}

function createAuxillaryTable($strDatabase, $strTable)
{
//pre-build certain important tables in a tableform mysql db.
//lots of embedded sql here!
	//creates the calendar set
	if ($strTable=="calendar")
	{
		$error=MakeCalendarTables($strDatabase);
	}
	if ($strTable== "admin")
	{
		$error=MakeAdminTable($strDatabase);

	}
	if ($strTable=="relation")
	{
		$error=MakeRelationTables($strDatabase);
	}
	if ($strTable=="column_info")
	{
		$error=MakeColumnInfoTables($strDatabase);
	}
	if ($strTable=="permission")
	{
		$error=MakePermissionTables($strDatabase);
	}
	if ($strTable=="browsescheme")
	{
		$error=MakeBrowseSchemeTable($strDatabase);
	}
	if ($strTable=="page")
	{
		$error=MakePageTable($strDatabase);
	}
	if ($strTable=="stats")
	{
 		$error=MakeStatsTables($strDatabase);
	}
	if ($strTable=="ad")
	{
		$error=MakeAdTables($strDatabase);
	}
	//echo $error;
	return "The auxillary tables set named " . $strTable . " was created.";

}

function ImpossibleRelationScan($strDatabase, $strPHP)
{
//looks for invalid entries in the relation table
	$out="";
	$bwlChecked=true;
	$checkboxHTML="";
	$strLineClass="bgclassline";
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strOtherBgClass="bgclassother";
	$strOtherLineClass="bgclassline";
	$strThisBgClass=$strClassFirst;
	$sql=conDB();
	$strSQL="SELECT * FROM " . $strDatabase . "." .  tfpre . "relation ORDER BY table_name, column_name";
	$records = $sql->query($strSQL);
	foreach ($records as $record)
	{
		if(!TableExists($strDatabase, $record["table_name"])  || !TableExists($strDatabase, $record["f_table_name"]) 
		|| !FieldExists($strDatabase,  $record["table_name"], $record["column_name"])
		|| !FieldExists($strDatabase,  $record["f_table_name"], $record["f_column_name"])
		)
		{
		
			$reccount = countrecords($strDatabase , $record["f_table_name"] );
			$fieldcount = FieldCount($strDatabase, $strTable);
			
 			$strValueString=$record["table_name"]  . "|" . $record["column_name"] . "|" . $record["f_table_name"] . "|".  $record["f_column_name"] . "|" . $record["relation_id"];
			$strCB=CheckboxInput(qpre . "killrelation[]", $strValueString, $bwlChecked, "", "", "");
			$checkboxHTML.=htmlrow($strThisBgClass,  
			$record["table_name"], 
			$record["column_name"], 
			$record["f_table_name"], 
			$record["f_column_name"] , 
			"X", 
			$fieldcount, 
			$reccount,  
			$strCB
			);
 
		
		}
	}
	if($strCB!="")
	{
		$out.= "<tr class=\"" . $strOtherBgClass . "\"><td colspan=\"8\">\n";
		$out.= "The following relations are no longer valid.  Checked relations in this section will be deleted." ;
		$out.= "</td></tr>\n";
		$out.= $checkboxHTML;
	}
	return $out;
}
	
function FKscan($strDatabase, $strPHP, $bwlRebuild=true)
{
	//Judas Gutenberg, late 2006
	//inside a particular database, scan through all the field names and propose possible relations based on them
	//12/3/2007: liberalized to allow varchar and other kinds of FKs.
	//12/4/2007: added color-coding to help admin quickly spot useful relations 
	//(ones to tables with lots of columns or foreign in many other relations)
	$out="";
	$root=imagepath;
	if(defined(temppath))
	{
		$root=temppath;
	}
	$filelocation=$root . "/"  . "fkscan_tmp_array.ser";
	$arrGather=Array();
	$strLineClass="bgclassline";
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strOtherBgClass="bgclassother";
	$strOtherLineClass="bgclassline";
	$strThisBgClass=$strClassFirst;
	$strIntList="int bigint smallint mediumint";
	$strOverlyGeneralSkipList="name type text id number count";
	$sql=conDB();
	$tables=TableList($strDatabase);
	$out.= "<script src=\"tf_tablesort.js\"><!-- --></script>
\n";
	$out.= "<form method=\"post\" name=\"BForm\" action=\"" .  $strPHP . "\">\n";
	$out.= HiddenInputs(array("mode"=>"fkscan", "db"=>$strDatabase));
	$out.= adminbreadcrumb(false,  $strDatabase, "tf.php?" . qpre . "db=" . $strDatabase,  "db tools", $strPHP . "?" . qpre . "db=" . $strDatabase, "Relation Scan", "") ;
	$out.=" [<a href=\"" . $strPHP . "?" . qpre . "mode=fkscan&" . qpre . "redofkscan=redo\" onclick=\"return(confirm('A relation scan can take several minutes.  This is only necessary if new tables have been added or their definitions modified since the last scan. Are you sure you want to rescan?'))\">rescan database</a>]";
 	$out.=TableBegin("630", "idsorttable2");
	$strLables=htmlrow("+bgclassline", 
		"<a href=\"javascript: SortTable('idsorttable', 0)\">table</a>", 
		"<a href=\"javascript: SortTable('idsorttable', 1)\">column</a>", 
		"<a href=\"javascript: SortTable('idsorttable', 2)\">foreign table</a>", 
		"<a href=\"javascript: SortTable('idsorttable', 3)\">foreign PK</a>", 
		"<a href=\"javascript: SortTable('idsorttable', 4)\"># of relations</a>", 
		"<a href=\"javascript: SortTable('idsorttable', 5)\"># of cols</a>", 
		"<a href=\"javascript: SortTable('idsorttable', 6)\"># of recs</a>", 
		"accept");
	
	$out.=$strLables;
	//echo "-" . count($tables) . "-" ;

	if($bwlRebuild  || !file_exists($filelocation))
	{
	
		$strFieldName="Tables_in_" . str_replace("`", "", $strDatabase);
		//loop through the tables
		$totalout=0;
		foreach ($tables as  $k=>$v)
		{
			$ReferenceTable=$v[$strFieldName];
			$descr=TableExplain($strDatabase, $ReferenceTable);
			//and their FKs
			foreach ($descr as $nom=>$info)
			{
				$strReferenceFieldName=$info["Field"];
				$strReferenceType=TypeParse($info["Type"], 0);
				//the following restriction was too narrow. pks can be varchar,etc.
				//if (inList($strIntList,$strReferenceType)) 
				{
					$fktables=TableList($strDatabase);
					//looking at foreign tables
					foreach ($fktables as  $fkk=>$fkv)
					{
						$FKTable=$fkv[$strFieldName];
						if ($ReferenceTable!= $FKTable)
						{
							$strSQL="SELECT count(table_name) as fkscale FROM " . $strDatabase . "." .  tfpre . "relation WHERE f_table_name='" . $FKTable . "' AND relation_type_id=0";
							//echo $strSQL ."<br>";
							$rsFKScale = $sql->query($strSQL);
							//echo sql_error()."=<br>";
							$rsFKScale=$rsFKScale[0];
							$intFKScale= $rsFKScale["fkscale"];
							$intFKRecords = countrecords($strDatabase , $FKTable);
							
						
							$fkdescr=TableExplain($strDatabase, $FKTable);
							//and foreign PKs
							$bwlAlreadyHadAPKFromThisTable=false;
							$bwlRejectThisFKtable=false;
							$outForThisTable="";
							$outNumberForthisTable=0;
							
							foreach ($fkdescr as $fknom=>$fkinfo)
							{	
								if ($fkinfo["Key"]=="PRI" )
								{
									if(!$bwlAlreadyHadAPKFromThisTable)
									{
										$strPKFieldName=$fkinfo["Field"];
										$strPKType=TypeParse($fkinfo["Type"], 0);
										//old test:if (inList($strIntList,$strPKType) &&  $strReferenceFieldName==$strPKFieldName )
										if (!inList($strOverlyGeneralSkipList,$strPKFieldName) && $strReferenceFieldName==$strPKFieldName   && $strPKType==$strReferenceType)
										{
											//put the results in an array so I can save it to the file system
											//and not have to regenerate it every time.
											$arrGather[$totalout]=
											Array($ReferenceTable,$strReferenceFieldName,$FKTable,$strPKFieldName,count($fkdescr), $intFKScale, $intFKRecords);
											
											$outNumberForthisTable++;
											$totalout++;
										}
									}
									else
									{
										$bwlRejectThisFKtable=true;
										$totalout=$totalout-$outNumberForthisTable;
									}
									$bwlAlreadyHadAPKFromThisTable=true;
								}
							}
						}
					}
				}
			}
		}
		BuildPathPiecesAsNecessary($filelocation);
		$handle=fopen ($filelocation, "w");
		$content=fwrite($handle, serialize($arrGather));
		fclose($handle);
	}
	else //need to read the array in
	{
		$handle=fopen ($filelocation, "r");
		$content=fread($handle, filesize($filelocation));
		fclose($handle);
		$arrGather=unserialize($content);
	}
	
	foreach($arrGather as $thisGather)
	{
		$strSizeColor="ffffff";
		$ReferenceTable=$thisGather[0];
		$strReferenceFieldName=$thisGather[1];
		$FKTable=$thisGather[2];
		$strPKFieldName=$thisGather[3];
		$intFieldsInPKTable=$thisGather[4];
		$intFKScale=$thisGather[5];
		$intFKRecords=$thisGather[6];
		
		$intSizeFactor=intval($intFieldsInPKTable/2);
		for($i=0; $i<$intSizeFactor; $i++)
		{
			$strSizeColor =colorSubtract($strSizeColor, "060000", 2);
		
		}
		for($i=0; $i<$intFKScale; $i++)
		{
			$strSizeColor =colorSubtract($strSizeColor, "000006", 2);
		
		}
		
		for($i=0; $i<intval($intFKRecords/10); $i++)
		{
			$strSizeColor =colorSubtract($strSizeColor, "000600", 2);
		
		}
		
		$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
		$bwlChecked=false;
		$strSQL="SELECT table_name FROM " . $strDatabase . "." .  tfpre . "relation WHERE table_name='" . $ReferenceTable . "' AND column_name='" .  $strReferenceFieldName . "' AND f_table_name='" .  $FKTable . "' AND f_column_name='" . $strPKFieldName . "' AND relation_type_id=0";
		//echo $strSQL . "<br>";
		$rstest = $sql->query($strSQL);
		if (count($rstest)>0)
		{
			$bwlChecked=true;
		}
		
		$strValueString=$ReferenceTable  . "|" . $strReferenceFieldName . "|" . $FKTable . "|".  $strPKFieldName;;
		
		$strTableSizeIndication="<span style=\"background-color:#" .  $strSizeColor . "\">&nbsp;";
		
		$strCB=$strTableSizeIndication . CheckboxInput(qpre . "acceptrelation[]", $strValueString, $bwlChecked, "", "", "") . "&nbsp;</span>";
		
		$out.=htmlrow($strThisBgClass, 
			"<a href=\"tf_table_maker.php?" . qpre . "db=" . $strDatabase . "&" . qpre . "table=" . $ReferenceTable . "\">" . $ReferenceTable . "</a>", 
			$strReferenceFieldName, 
			"<a href=\"tf_table_maker.php?" . qpre . "db=" . $strDatabase . "&" . qpre . "table=" . $FKTable . "\">" . $FKTable . "</a>", 
			$strPKFieldName, 
			$intFKScale,
			$intFieldsInPKTable,
			$intFKRecords,
			$strCB);
 
		
	}
	$out.="</table>";
	$strInvalidEntries=ImpossibleRelationScan($strDatabase, $strPHP);
	if($strInvalidEntries!="")
	{
		$strFoundInvalid=", while deleting invalid entries found in the bottom section";
		$out.= "<p/>" .TableBegin("630", "idsorttable2"). "\n";
		$out.=$strLables;
		$out.=$strInvalidEntries;
		$out.=TableEnd();
	}
	$out.= "<p/>" . TableBegin("630", "idsorttable3").  "\n";
	$out.="<tr>\n";
	$out.="<td>\n";
	$out.="Clicking 'Accept' will add the checked relations in the top section to the <strong>relation</strong> table" . $strFoundInvalid . ".\n";
	$out.="<br><a href=\"javascript:alldumpcheckboxes('acceptrelation[]', true);alldumpcheckboxes('killrelation[]', true)\">select all</a> | <a href=\"javascript:alldumpcheckboxes('acceptrelation[]', false);alldumpcheckboxes('killrelation[]', false) \">select none</a>";
	$out.="</td>\n";
	$out.="<td>\n";
	$out.="<input type=\"Submit\" class=\"btn\" onmouseover=\"this.className='btn btnhov'\" onmouseout=\"this.className='btn'\" value=\"Accept\">";
	$out.="</td>\n";
	$out.="</tr>\n";
	$out.="</form>";
	$out.=TableEnd();
	
 
	$out.="<script>NumberRows('idsorttable2', 4);</script>";
	return $out;
}


function EnterSQL($strDatabase, $strPHP, $strSQL, $trunc, $bwlDirectediting, $strPostRunScript="", $language_id="")
{
	//a form for entering free-form SQL.  defaults to last command run
	//gus mueller, nov 26 2006
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strLineClass="bgclassline";
	$strOtherBgClass="bgclassother";
	//echo $language_id . "-";
	$preout="";
	$preout.= adminbreadcrumb(false,  $strDatabase, "tf.php?" . qpre . "db=" . $strDatabase,  "db tools", $strPHP . "?" . qpre . "db=" . $strDatabase, "Enter Raw SQL", "") ;
	//$out.= AdminNav(true);
	
	$preout.= "<form method=\"post\" name=\"BForm\" action=\"" .  $strPHP . "\">\n";
 
	
	//$out.= "</td></tr>\n";
	$out= HiddenInputs(array("db"=>$strDatabase, "mode"=>"entersql", "language_id"=>$language_id));
	$out.="<tr>\n";
	
	$out.="<td style='font-size:10px'  valign=\"top\" class=\"" . $strClassFirst . "\">\n";

	$out.="<textarea name=\"" . qpre . "actscript\" style='width:100%' rows=\"20\"  >" .  $strSQL . "</textarea>\n";
	$out.="<br/>SQL script.  Use the   names of fields prepended with '$' to refer to the data of those fields to be processed by subqueries enclosed in {}, which can nest inside other subqueries.";
	$out.="</td>\n";
	$out.="<td valign=\"top\" class=\"" . $strClassFirst . "\">\n";
	$out.="\n<iframe frameborder=\"0\" marginwidth=\"0\" marginheight=\"0\"  style='width:100%' height=\"400\" name=\"recentscript\" src=\"tf_recent_script.php?" . qpre . "type=sql" . "&" . qpre . "db=" . $strDatabase . "\"></iframe>\n";
	$out.="</td>\n";
	$out.="</tr>\n";
	
	$out.="<tr>\n";
	
	$out.="<td style='font-size:10px' valign=\"top\" colspan=\"2\" class=\"" . $strClassSecond . "\">\n";
	$out.="PHP script to run on displayed columns. Use the names of fields prepended with '$' to refer to the data of those fields to be processed by the script.<br/>";
	$out.="<textarea name=\"" . qpre . "postrunscript\" style='width:100%' rows=\"2\"  >" .  $strPostRunScript . "</textarea>\n";
	$out.="</td>\n";
	$out.="</tr>\n";

	$out.="<tr>\n";
	$out.="<td align=\"right\" colspan=\"2\">\n";
	$out.="<a href=\"" .  AllRequestToURL() . "\">URL of this page's state</a> ";
	if(TableExists($strDatabase, "language"))
	{
	
		$out.="Provide fields for this language translation:" . foreigntablepulldown($strDatabase, "language", "language_id", $language_id, qpre . "language_id", $namereturn,  false, "language_name",  "");
	
	}
	$out.=CheckboxInput(qpre . "directediting", 1, $bwlDirectediting, "", "", "") . "allow direct editing of results  ";
	$out.="&nbsp;&nbsp;&nbsp;&nbsp;";
 	$out.=CheckboxInput(qpre . "truncate", 1, $trunc, "", "", "") . "truncate fields";
	$out.="<input type=\"Submit\" class=\"btn\" onmouseover=\"this.className='btn btnhov'\" onmouseout=\"this.className='btn'\" value=\"Execute\">";
	$out.="</td>\n";
	$out.="</tr>\n";
 
	$out.="</form>";
	$out=$preout . TableEncapsulate($out ,false, "100%");
	return $out;
}

function DBStats($strDatabase)
{
	//display DB server stats
	//judas gutenberg, feb 23 2008
	$strClassFirst="bgclassfirst";
	$strLineClass="bgclassline";
	$strOtherBgClass="bgclassother";
	$preout="";
	$preout.= adminbreadcrumb(false,  $strDatabase,"tf.php?" . qpre . "db=" . $strDatabase,  "db tools", $strPHP . "?" . qpre . "db=" . $strDatabase, "Server Stats", "") ;
	//$out.= AdminNav(true);
	
	$out= "<form method=\"post\" name=\"BForm\" action=\"" .  $strPHP . "\">\n";
 
	
	//$out.= "</td></tr>\n";
	$out.="<tr>\n";
	$out.="<td valign=\"top\" class=\"" . $strClassFirst . "\">\n";
	$out.= "MySQL version: " . mysql_get_server_info();
	$out.="<p/>";
	$out.=mysql_stat();
	$out.="<p/>";
	
	$result = mysql_list_processes();
	
	while ($row = mysql_fetch_assoc($result))
	{
		$out.=sprintf("%s %s %s %s %s\n", $row["Id"], $row["Host"], $row["db"], $row["Command"], $row["Time"]);
	}
	mysql_free_result($result);
	$out.="</td>\n";
	$out.="</tr>\n";
	$out.="<tr>\n";
	$out.="<td align=\"right\" colspan=\"2\">\n";
 	//$out.=CheckboxInput(qpre . "truncate", 1, $trunc, "", "", "") . "truncate fields";
	//$out.="<input type=\"Submit\" class=\"btn\" onmouseover=\"this.className='btn btnhov'\" onmouseout=\"this.className='btn'\" value=\"Execute\">";
	$out.="</td>\n";
	$out.="</tr>\n";
	 
	$out.="</form>";
	$out=$preout . TableEncapsulate($out);
	return $out;
}


//echo "<a href=\"javascript:domdumpwindow()\">dump</a>";
?>

