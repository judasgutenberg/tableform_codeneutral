<?php
//Judas Gutenberg Dec 21 2007
//
//displays a linked map of table relationships in the database
//
//This code is covered under the GNU General Public License
//info here: http://www.gnu.org/copyleft/gpl.html
//the digest is as follows: you cannot modify this code without
//publishing your source code under the same license
//contact the developer at gus@asecular.com  http://asecular.com

include('tf_functions_core.php');
include('tf_core_table_creation.php');
if(file_exists('htmlconversion.php'))
{
	include('htmlconversion.php');
}
//echo "<a href=\"javascript:domdumpwindow()\">dump</a>";
echo main();
 

function main()
{
	if(!IsExtraSecure())
	{
		die(ExtraSecureFailure());
	}
	//$olderror=error_reporting(0);
	$mode=$_REQUEST[qpre . "mode"];
	$mapname=$_REQUEST[qpre . "mapname"];
	$positions=$_REQUEST[qpre . "positions"];
	$tabledeletes=$_REQUEST[qpre . "tabledeletes"];
	$dbmap_id=$_REQUEST["dbmap_id"];
	$bypass=$_REQUEST[qpre . "bypass"];
	$relationshipdata=$_REQUEST[qpre . "relationshipdata"];
	$relationdeletes=$_REQUEST[qpre . "relationdeletes"];
	$strDatabase=deMoronizeDB(gracefuldecay($_REQUEST[qpre . "db"],our_db));
	$strPHP=$_SERVER['PHP_SELF'];
	$out="";
	$feedback="";
	$tablelist="";
	$strTable=tfpre . "dbmap";
	if($bypass=="")
	{
		$out.=LoginDecisions($strDatabase,  $strPHP, $strUser, false);
	}
	else
	{
		$strUser="root";
	}
	if ($strUser!=""  )
	{
	
		$intAdminType= AdministerType($strDatabase, $strTable, $strUser);
		
		if ($intAdminType>1)
			{
			
				if($mode=="delete")
				{
				 
					$feedback =JoinList("<br/>\n",$feedback, TotalDelete($strDatabase,$strTable,  $dbmap_id, "dbmap_id"));
					$dbmap_id="";
				
				}
				if($mode=="exportpdf")//doesn't seem to work and it would be doubtful to see how it ever would
				{
					if(file_exists('htmlconversion.php'))
					{
						$content=MapForm($strDatabase, $dbmap_id);
						$htmltopdf = new HTML_TO_PDF();
						$htmltopdf->downloadFile($mapname . "map.pdf");
						$result = $htmltopdf->convertHTML($content);
						//$htmltodoc->createDoc("reference1.html","test");
						//echo $result;
						die();
					}
				}
				if($_REQUEST[qpre . "savemap"]!="")
				{
					if(CanChange())
					{
						EnsureNonRemote();
						MakeTableIfNotThere($strDatabase, $strTable, "MakeDBMapTables");
						//die($positions);
						$arrSpec="";
						if($dbmap_id!="")
						{
							$arrSpec=Array("dbmap_id"=>$dbmap_id);
						}
						$dbmap_id=gracefuldecay($dbmap_id, GenericDBLookup($strDatabase, $strTable,"map_name", $mapname,"dbmap_id"));
						//echo $dbmap_id;
						if($mapname=="")
						{
							$mapname=GenericDBLookup($strDatabase,$strTable,"dbmap_id", $dbmap_id,"map_name");
						}
						//echo "$$" .$dbmap_id;
						$dbmap_id_out=UpdateOrInsert($strDatabase,$strTable, $arrSpec,Array("map_name"=>$mapname), true, true);
						//echo mysql_error() ."#<br>";
					 
						if($dbmap_id=="")
						{
							$dbmap_id=gracefuldecay($dbmap_id_out, highestprimarykey($strDatabase,$strTable))  ;
						}
						$arrPos=explode("|", $positions);
						foreach($arrPos as $thistable)
						{
							//echo $thistable . "<br>";
							$thisArr=explode(" ", $thistable);
							$strTable=$thisArr[0];  
							$top=$thisArr[1];
							$left=$thisArr[2];
							if($strTable!=""  )
							{
								 
								if(!inList($tabledeletes, $strTable))
								{
									//echo mysql_error() ."+<br>";
									//echo   $dbmap_id . " " . $strTable . "<br>";  
									if($strTable !="")
									{
										UpdateOrInsert($strDatabase,tfpre . "dbmap_table", Array("dbmap_id"=>$dbmap_id, "table_name"=>$strTable ), Array("`top`"=>$top, "`left`"=>$left) );
									}
									//echo mysql_error() ."-<br>";
								}
		
							//echo  $strDatabase . " " . $strTable . "<BR>";
							}
						}
						if($tabledeletes!="")
						{
							$arrTableDeletes=explode(" " , $tabledeletes);
							foreach($arrTableDeletes as $strTable)
							{	
								//echo  $strDatabase . " " . $strTable . "<BR>";
								$feedback =JoinList("<br/>\n",$feedback, rowdelete($strDatabase,tfpre ."dbmap_table", "table_name",$strTable));
							}
						}
						//die($dbmap_id);
						//now go through the relations and save any that don't exist (since some might have been created interactively)
						$arrRelations=explode("|", $relationshipdata);
						if(is_array($arrRelations))
						{
							foreach($arrRelations as $thisrelation)
							{
								if($thisrelation!="")
								{	
									$arrRelationParts=explode(" ", $thisrelation);
									$relationfeedback=NewRelation($strDatabase, $arrRelationParts[0],$arrRelationParts[1], $arrRelationParts[2], $arrRelationParts[3], 0);
									//$feedback =JoinList("<br/>\n",$feedback,$relationfeedback);
								
								}
							}
						}
						//now go through relation deletes and get rid of those
						$arrRelationDeletes=explode("|", $relationdeletes);
						if(is_array($arrRelationDeletes))
						{
							foreach($arrRelationDeletes as $thisrelation)
							{
								if($thisrelation!="")
								{	
									$arrRelationParts=explode(" ", $thisrelation);
									$strSQL="DELETE FROM " . $strDatabase . "." . tfpre . "relation WHERE 
										table_name='" . $arrRelationParts[0] . "' AND
										column_name='" . $arrRelationParts[1] . "' AND
										f_table_name='" . $arrRelationParts[2] . "' AND
										f_column_name='" . $arrRelationParts[3] . "' AND
										relation_type_id='0'";
									
									$sql=conDB();
									$sql->query($strSQL);
									//$feedback =JoinList("<br/>\n",$feedback,$relationfeedback);
								
								}
							}
						}
					}
					else
					{
						$feedback =JoinList("<br/>\n",$feedback ,"Database is read-only.<br/>");
					}
					$feedback =JoinList("<br/>\n",$feedback ,"The database map named " . $mapname . " was saved.<br/>");
				}
				if(($_REQUEST[qpre . "maptron"]!=""  || $dbmap_id!="")  && $mode!="changetables"  || $mode=="allrelated")
				{
					
					$tablelist="";
					if($_REQUEST[qpre . "maptron"]!="")
					{
						foreach($_REQUEST[qpre . "map"] as $accept)
						{
							$tablelist.=$accept . " ";
						}
						$tablelist=trim($tablelist);
					}
					else if($mode=="allrelated")
					{
						$tablelist=AllRelatedTables($strDatabase);
					}
					else
					{
						$tablelist=TableListInMap($strDatabase, $dbmap_id);
					}
					//die("##" .  $dbmap_id . $_REQUEST[qpre . "maptron"] ."*" .  $mode);
					$out.=DBMap($strDatabase, $strPHP, $tablelist, $dbmap_id);
				}
				else
				{
				 
					$maplist=MapList($strDatabase);
					$out.= "<div class=\"heading\"  style=\"position: absolute;top:40px;left: 600px; z-index: 100;\">";
					$out.= IFAThenB($maplist!="", "View a saved map:<br/>");
					$out.= IFAThenB($maplist=="", "No maps have been saved.");
					$out.= $maplist;
					$out.=  "<br>[<a href=\"" . $strPHP . "?" . qpre . "db=" .$strDatabase . "&" . qpre . "mode=allrelated&dbmap_id=" . $dbmap_id . "\">map all related tables</a>]";
					$out.= "</div>";
					//$out.= "<div class=\"heading\">Create a new map:</div>";
					
					if($mode!="changetables")
					{
						$dbmap_id="";
					}
					$out.=MapForm($strDatabase, $dbmap_id);
				}
			}
	}
	$out.=userfeedback($feedback);
	//$out.= "\n<script>drawrelationships(relationshipdata);</script>\n";
	$out=  PageHeader($strDatabase . " : relationship map", $strConfigBehave, "", true, false, "", $strDatabase) . $out . PageFooter();
	
	return $out;
}

function DBMap($strDatabase, $strPHP, $tablelist, $dbmap_id="")
{
	//echo $tablelist;
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strOtherBgClass="bgclassother";
	$strLineClass="bgclassline";
	$out="";
	if($dbmap_id!="")
	{
		$mapname=GenericDBLookup($strDatabase, tfpre . "dbmap","dbmap_id", $dbmap_id, "map_name");
 		//die($mapname);
		$out.=PositionDump($strDatabase, $dbmap_id);
	
	}
	$strThisBgClass=$strClassFirst;
	$sql=conDB(); 
	$arrSort=Array();
	$tablecount=0;
	$xbase=30;
	$x=$xbase; 
	$y=70;
	$z=50;
	$intPixPerLine=18;
	$intPixPerChr=8;
	$intColMax=0;
	if( $dbmap_id=="")
	{
		$tables=ListTables($strDatabase);
	}
	else
	{
		if($tablelist!="")
		{
			$tables=explode(" ", $tablelist);
	 	}
		else
		{
			$tables=TablesInMap($strDatabase, $dbmap_id);
		}
	}
	$out.= "<form method=\"post\" name=\"BForm\" action=\"tf_db_map.php\" onsubmit='return(MapSave())'>\n";
	$out.= "<script type=\"text/javascript\" src=\"tf_domdrag.js\"></script>\n";
	$out.="\n<div id='idmap' style='position:absolute;top:0px;left:0px; '>\n";
	$out.="</div>";
	$mapname=gracefuldecay($mapname, "New Map");
	$out.= adminbreadcrumb(false,  $strDatabase, "tf.php" . "?" . qpre . "db=" . $strDatabase,  "Database Maps", $strPHP . "?" . qpre . "db=" . $strDatabase, $mapname, "") ;
	$bwlTableMakerExists=file_exists("tf_table_maker.php");
	foreach($tables as  $strTable)
	{
		if(inList($tablelist, $strTable)  || $tablelist=="")
		{
			
			$count = countrecords($strDatabase , $strTable );
			$fieldcount=FieldCount($strDatabase, $strTable);
			$intMaxSize=MaxColNameLength($strDatabase, $strTable, $bwlWasTableName);
			$intFontMultFactor=1;
			if( $bwlWasTableName)
			{
				$intFontMultFactor=1.2;
			}
			$arrSort[$tablecount]=str_pad($fieldcount, 3, "0", STR_PAD_LEFT) . " " . $strTable . " ". $intFontMultFactor * $intMaxSize;
			if($fieldcount>$intOverallColMax)
			{
				$intOverallColMax=$fieldcount;
			}
			$tablecount++;
		}
	}
	$intColMax=0;
	arsort($arrSort);
	$strDifString="";
	foreach($arrSort as  $item)
	{
		$arrTemp=explode(" ", $item);
		$intCols=intval($arrTemp[0]);
		$intPreviousCols=$intCols;
		$intColLength=$arrTemp[2];
		if($intCols>$intColMax)
		{
			$intColMax=$intCols;
		}
		$intDif=  $intColMax-$intCols-3;
		//$intDif=  $intOverallColMax-$intCols-2;
		$strTable=$arrTemp[1];
		$records=TableExplain($strDatabase, $strTable);
		$thistableHTML="";
		//$thistableHTML.=htmlrow($strLineClass,"<b>" . $strTable . "</b>");
		
		//actually need to give the header a name so i can single it out for dragging
		$thistableHTML.="<tr class=\"" . $strLineClass  . "\"><td><a class=\"mapdragbar\" id=\"iddrag-" . $strTable . "\">" .  $strTable   . "</a></td></tr>\n";
		$strThisBgClass=$strClassFirst;
		foreach ($records as $k1 => $v1 )
		{
			$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
			$strFieldName=$v1["Field"] ;
			$thisfieldDivName="idfield-" .$strTable . "-" .$strFieldName;
			$thistableHTML.="<tr class=\"" . $strThisBgClass  . "\"><td id=\"" .$thisfieldDivName  . "\"><a onmousedown='mrstart(\"" .$thisfieldDivName . "\")' onmouseup='mrdone(\"" .$thisfieldDivName . "\")' onmouseover='mrdrag(\"" .$thisfieldDivName . "\")'  onmouseout='mrdragno(\"" .$thisfieldDivName . "\")' class='mapfield'>" . $strFieldName . "</a></td></tr>\n";
		}
  
		$thistableHTML=TableEncapsulate($thistableHTML, false,"","idtable" .  $strTable);
		//put in empty spaces if available
		//search dif string to see if this one will fit
		if(contains($strDifString, "|"))
		{
			$arrDif=explode("|", $strDifString);
			$bwlLocated=false;
			for($i=0; $i<count($arrDif); $i++)
			{ 
				if(contains($arrDif[$i], " "))
				{
					$arrDifInfo=explode(" ", $arrDif[$i]);
					$testDif=$arrDifInfo[3];
					$thisx=$arrDifInfo[0];
					$thiscollen=$arrDifInfo[5];
					if($testDif>$intCols +2  && !$bwlLocated  && $thiscollen>=$intColLength)
					{
						$thisy=$arrDifInfo[1] + ($arrDifInfo[4] + 2) * $intPixPerLine ;
						$out.="\n<div id=\"iddiv-" .  $strTable . "\" style=\"position: absolute;top:" .$thisy . "px;left: " . $thisx . "px;\">" . $thistableHTML . "</div>";
						$z++;
						$bwlLocated=true;
						$arrDif[$i]=$thisx . " " . $thisy . " " . $z . " " .intval(-1+   $arrDifInfo[3]  -($intCols)) .  " " . $intCols . " " . $thiscollen;
					}
				}
			}
		}
		if($bwlLocated)
		{
	 		$strDifString=implode("|", $arrDif);
		}
		//okay then make a new space
		else   
		{
			//only add to the dif string if taking new ground
			$out.="\n<div id=\"iddiv-" .  $strTable . "\" style=\"position: absolute;top:" . $y . "px;left: " . $x . "px;\">" . $thistableHTML . "</div>";
			if($intDif>0)
			{
				$strDifString.=$x . " " . $y . " " . $z . " " . $intDif .  " " . $intCols . " " . $intColLength .  "|";
			}
			$x+=($intPixPerChr*$intColLength);
			if($x>1000)
			{
				$y+=($intColMax + 2)*$intPixPerLine ;
				$x=$xbase;
				$intColMax=0;
				$intPreviousCols=0;
			}
			$z+=1;
		}
		$out.="<script type=\"text/javascript\">";
		//old way:
		//$out.="Drag.init(document.getElementById('iddiv-" .  $strTable . "'));\n";
		$out.="Drag.init(document.getElementById('iddrag-" .  $strTable . "'));\n";
		$out.="</script>";
	}
	$out.="<div>  map name: ";
	$out.=TextInput(qpre . "mapname", $mapname, 15) . " ";
	$out.= GenericInput(qpre . "savemap", "save map");
	$out.= " <a href=\"" . $strPHP . "?" . qpre . "db=" .$strDatabase . "&" . qpre . "mode=changetables&dbmap_id=" . $dbmap_id . "\">add/remove tables</a>";
	$out.= " | <a href=\"javascript:RemoveUnrelatedTables()\">strip out unrelated tables</a>";
	$out.= " | <a href=\"" . $strPHP . "?" . qpre . "db=" .$strDatabase . "&" . qpre . "mode=exportpdf&dbmap_id=" . $dbmap_id . "\">export PDF</a></div>";
	$out.= HiddenInputs(array("db"=>$strDatabase, "tablelist"=> $tablelist, "positions"=> ""));
	$out.= HiddenInputs(array("dbmap_id"=>$dbmap_id),"");
	$out.= HiddenInputs(array("tabledeletes"=>""),qpre);
	$out.= HiddenInputs(array("relationdeletes"=>""),qpre);
	$out.= HiddenInputs(array("relationshipdata"=>""),qpre);
	$out.= "</form>";
	$out.=RelationDump($strDatabase, $tablelist);
	return $out;
}

function MapList($strDatabase)
//Creates a space and pipe delimited string containing the essence of the tf_relation's FK data
//This is used by the javascript in tf_drawrelationships.js to draw all the relationships between tables.
//This all has to be in javascript to allow the user to move things around and such.
{
	$sql=conDB();
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$out="";
	$strSQL="SELECT * FROM " . $strDatabase . "." . tfpre . "dbmap";
	//echo $strSQL;
	$records = $sql->query($strSQL);
	$strThisBgClass=$strClassFirst;
	
	foreach($records as $record)
	{
		$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
		$dbmap_id=$record["dbmap_id"];
		$name=$record["map_name"];
		
		$out.=htmlrow($strThisBgClass, 
			$dbmap_id, 
			"<a href=\"tf_db_map.php?" . qpre. "db=" . $strDatabase . "&dbmap_id=" . $dbmap_id . "\">" .  $name . "</a>",
			"[<a onclick=\"return(confirm('Are you certain you want to delete this map?'))\" href=\"tf_db_map.php?" . qpre . "mode=delete&" . qpre. "db=" . $strDatabase . "&dbmap_id=" . $dbmap_id . "\">delete</a>]"
			);
	}
	if($out!="")
	{
		$out=htmlrow("bglineclass", "id", "map name", "&nbsp;"). $out;
		$out=TableEncapsulate($out, false);
	}
 	
	return $out;
}


function RelationDump($strDatabase, $tablelist)
//Creates a space and pipe delimited string containing the essence of the tf_relation's FK data
//This is used by the javascript in tf_drawrelationships.js to draw all the relationships between tables.
//This all has to be in javascript to allow the user to move things around and such.
{
	$sql=conDB();
	$out="";
	$strSQL="SELECT * FROM " . $strDatabase . "." . tfpre . "relation  WHERE relation_type_id='0'";
	$records = $sql->query($strSQL);
	foreach($records as $record)
	{
		$strTable=$record["table_name"];
		$strFKTable=$record["f_table_name"];
		if(inList($tablelist, $strTable) &&  inList($tablelist, $strFKTable)  || $tablelist=="")
		{
			$strColumn=$record["column_name"];
			$strFKColumn=$record["f_column_name"];
			$relation_id=$record["relation_id"];
			//$out.=$strTable . " " . $strColumn . " " . $strFKTable . " " . $strFKColumn .  " " . $relation_id . "|";
			$out.=$strTable . " " . $strColumn . " " . $strFKTable . " " . $strFKColumn  . "|";
			$idstring.=$strTable . "~" . $strColumn . " " . $relation_id . "|";
		}
	}
	$out="\n<script type=\"text/javascript\">relationshipdata='" . $out . "'</script>\n";
	$out.="\n<script type=\"text/javascript\">relationshipiddata='" . $idstring . "'</script>\n";
	$out.= "<script type=\"text/javascript\" src=\"tf_drawrelationships.js\"></script>\n";
	return $out;
}

function PositionDump($strDatabase, $dbmap_id)
//Creates a space and pipe delimited string containing position info for a dbMap
{
	$sql=conDB();
	$out="";
	$strSQL="SELECT * FROM " . $strDatabase . "." . tfpre . "dbmap_table  WHERE dbmap_id='" . $dbmap_id ."'";
	//echo $strSQL;
	$records = $sql->query($strSQL);
	foreach($records as $record)
	{
		$strTable=$record["table_name"];
		$top=$record["top"];
		$left=$record["left"];

		$out.=$strTable . " " . $top . " " . $left . "|";
		 
	}
	$out="\n<script type=\"text/javascript\">positiondata='" . $out . "'</script>\n";
	return $out;
}

function TableListInMap($strDatabase, $dbmap_id)
//Creates a space delimited string containing table in a dbMap
{
	$sql=conDB();
	$out="";
	$strSQL="SELECT * FROM " . $strDatabase . "." . tfpre . "dbmap_table  WHERE dbmap_id='" . $dbmap_id ."'";
	$records = $sql->query($strSQL);
	foreach($records as $record)
	{
		$strTable=$record["table_name"];
		$out.=$strTable . " ";
		 
	}
	$out=trim($out);
	return $out;
}

function AllRelatedTables($strDatabase)
//Creates a space delimited string containing table in a dbMap
{
	$sql=conDB();
	$out="";
	$strSQL="SELECT * FROM " . $strDatabase . "." . tfpre . "relation";
	$records = $sql->query($strSQL);
	foreach($records as $record)
	{
		$strTable=$record["table_name"];
		$strFKTable=$record["f_table_name"];
		$out.=$strTable . " " . $strFKTable . " ";
	}
	$out=trim($out);
	return $out;
}

function TablesInMap($strDatabase, $dbmap_id)
{
	$sql=conDB();
	$arrOut=Array();
	$intOut=0;
	$strSQL="SELECT table_name FROM " . $strDatabase . "." . tfpre . "dbmap_table WHERE dbmap_id='" . $dbmap_id . "'";
	//die($strSQL);
	$records=$sql->query($strSQL);
	foreach ( $records as  $record )
	{
		$arrOut[$intOut]=$record["table_name"];
		$intOut++;
	}
	return $arrOut;
}

function MapForm($strDatabase, $dbmap_id)
{
	$sql=conDB();
	$intFindCount=1;
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strPHP="tf.php";
	$out="";
	$preout="";
	$preout.= adminbreadcrumb(false, $strDatabase, $strPHP . "?" . qpre . "db=" . $strDatabase,  "Choose Tables to Map", "");
	$tables=ListTables($strDatabase);
	$preout.= "<script src=\"tf_tablesort.js\"><!-- --></script>";
	$preout.= "<form method=\"post\" name=\"BForm\" action=\"tf_db_map.php\">\n";
	$out.=htmlrow("bgclassline", "<a href=\"javascript: SortTable('idsorttable', 0)\">table</a>", "<a href=\"javascript: SortTable('idsorttable', 1)\">records</a>",  "<a href=\"javascript: SortTable('idsorttable', 2)\">columns</a>", "include in map");
	$outcount=0;
	foreach ( $tables as  $tablename )
	{
		$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
 		$count = countrecords($strDatabase , $tablename );
		$fieldcount=FieldCount($strDatabase, $tablename);
		$checked=false;
		if($dbmap_id!="")
		{
			$strSQL="SELECT table_name FROM " . $strDatabase . "." . tfpre . "dbmap_table WHERE table_name='" . $tablename . "' AND dbmap_id='" . $dbmap_id . "'";
			
			 $recs=$sql->query($strSQL);
			 //echo $strSQL . "<br>" . count( $recs) . "<p>";
			 if(count($recs)>0)
			 {
			 	$checked=true;
			 }
		
		}
		$checkcell=CheckboxInput(qpre . "map[]", $tablename,  $checked);
		$checkcell.="<a href=\"javascript:alldumpcheckboxes('map[]', 'rev', 0, " . $outcount .")\">^</a> ";
		$checkcell.="<a href=\"javascript:alldumpcheckboxes('map[]', 'rev', " . $outcount .")\">v</a>";
		$out.=htmlrow($strThisBgClass, 
			$tablename, 
			$count,
			$fieldcount,
			$checkcell
			);
		$outcount++;
	}
	$overallout=$preout. TableEncapsulate($out, true);
	$out="";
	$out.=str_replace("idsorttable", "idsorttable2", $tableheader);
	$out.="<tr name=\"sortavoid\"><td>\n";
	$out.="</td>\n";
	$out.="<td valign=\"top\" align=\"right\">\n";
	$out.="<a href=\"javascript:alldumpcheckboxes('map[]', true)\">select all</a> | <a href=\"javascript:alldumpcheckboxes('map[]', false)\">select none</a>";
	$out.="</td>\n";
	$out.="</tr>\n";
	$out.="<tr name=\"sortavoid\">\n";
	$out.= HiddenInputs(array("db"=>$strDatabase));
	$out.= "<input type='hidden' name='dbmap_id' value='" . $dbmap_id . "'>\n";
	$out.= "<td colspan=\"2\" align=\"right\">";
	$out.=GenericInput(qpre . "maptron", "map selected tables");
	$out.="</td>\n";
	$out.="</tr>\n";
	$overallout.=  TableEncapsulate($out, false);
	$overallout.="</form>\n";
	return $overallout;
}
?>