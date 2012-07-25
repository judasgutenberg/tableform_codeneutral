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

include('core_functions.php');
include('coretablecreation.php');
include('htmlconversion.php');
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
	$dbmap_id=$_REQUEST["dbmap_id"];
	$bypass=$_REQUEST[qpre . "bypass"];
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
		
		if ($intAdminType>1 )
			{
				if($mode=="delete")
				{
					$feedback.=TotalDelete($strDatabase,$strTable,  $dbmap_id, "dbmap_id");
					$dbmap_id="";
				
				}
				if($mode=="exportpdf")//doesn't seem to work and it would be doubtful to see how it ever would
				{
					$content=MapForm($strDatabase, $dbmap_id);
					$htmltopdf = new HTML_TO_PDF();
					$htmltopdf->downloadFile($mapname . "map.pdf");
					$result = $htmltopdf->convertHTML($content);
					//$htmltodoc->createDoc("reference1.html","test");
					echo $result;
					die();
				}
				if($_REQUEST[qpre . "savemap"]!="")
				{
					MakeTableIfNotThere($strDatabase, $strTable, "MakeDBMapTables");
					$dbmap_id=GenericDBLookup($strDatabase, $strTable,"map_name", $mapname,"dbmap_id");
					if($mapname=="")
					{
						$mapname=GenericDBLookup($strDatabase,$strTable,"dbmap_id", $dbmap_id,"map_name");
					}
					UpdateOrInsert($strDatabase,$strTable, Array("map_name"=>$mapname, "dbmap_id"=>$dbmap_id), "");
				 
					if($dbmap_id=="")
					{
						$dbmap_id=highestprimarykey($strDatabase,$strTable);
					}
					$arrPos=explode("|", $positions);
					foreach($arrPos as $thistable)
					{
						//echo $thistable . "<br>";
						$thisArr=explode(" ", $thistable);
						$strTable=$thisArr[0];
						$top=$thisArr[1];
						$left=$thisArr[2];
						if($strTable!="")
						{
							UpdateOrInsert($strDatabase,tfpre . "dbmap_table", Array("dbmap_id"=>$dbmap_id, "table_name"=>$strTable ), Array("`top`"=>$top, "`left`"=>$left));
						}
					}
					$feedback.="The database map named " . $mapname . " was saved.<br/>";
				}
				if(($_REQUEST[qpre . "maptron"]!=""  || $dbmap_id!="")  && $mode!="changetables")
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
					else
					{
						$tablelist=TableListInMap($strDatabase, $dbmap_id);
					}
					
					$out.=DBMap($strDatabase, $strPHP, $tablelist, $dbmap_id);
				}
				else
				{
					$maplist=MapList($strDatabase);
					$out.= "<div class=\"heading\"  style=\"position: absolute;top:40px;left: 600px; z-index: 100;\">";
					$out.= IFAThenB($maplist!="", "View a saved map:<br/>");
					$out.= IFAThenB($maplist=="", "No maps have been saved.");
					$out.= $maplist;
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
	$out.=IfAThenB($feedback, "<div class=\"feedback\">" . $feedback . "</div>");
	$out=  PageHeader($strDatabase . " : relationship map", $strConfigBehave) . $out . PageFooter();
	return $out;
}

function DBMap($strDatabase, $strPHP, $tablelist, $dbmap_id="")
{
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strOtherBgClass="bgclassother";
	$strLineClass="bgclassline";
	$out="";
	if($dbmap_id!="")
	{
		$mapname=GenericDBLookup($strDatabase, tfpre . "dbmap","dbmap_id", $dbmap_id, "map_name");
 
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
	$intPixPerChr=7;
	$intColMax=0;
	$tables=TableList($strDatabase);
	
	$out.= "<form method=\"post\" name=\"BForm\" action=\"dbmap.php\" onsubmit='return(MapSave())'>\n";
	$out.= "<script type=\"text/javascript\" src=\"dom-drag.js\"></script>\n";
	$out.="\n<div id='idmap' style='position:absolute;top:0px;left:0px; '>\n";
	$out.="</div>";
	$mapname=gracefuldecay($mapname, "New Map");
	$out.= adminbreadcrumb(false,  $strDatabase, "tableform.php" . "?" . qpre . "db=" . $strDatabase,  "Database Maps", $strPHP . "?" . qpre . "db=" . $strDatabase, $mapname, "") ;
	$strTableFieldName="Tables_in_" . str_replace("`", "", $strDatabase);
	$bwlTableMakerExists=file_exists("tablemaker.php");
	foreach($tables as  $k=>$v )
	{
		$strTable=$v[$strTableFieldName];
		if(inList($tablelist, $strTable)  || $tablelist=="")
		{
			$count = countrecords($strDatabase , $strTable );
			$fieldcount=FieldCount($strDatabase, $strTable);
			$arrSort[$tablecount]=str_pad($fieldcount, 3, "0", STR_PAD_LEFT) . " " . $strTable . " ". MaxColNameLength($strDatabase, $strTable);
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
		$records=DBExplain($strDatabase, $strTable);
		$thistableHTML="";
		$thistableHTML.= "\n<table id='idtable" .  $strTable . "' border=\"0\" cellspacing=\"1\" cellpadding=\"2\" class=\"" .$strLineClass  . "\" >\n";
		$thistableHTML.=htmlrow($strLineClass,"<b>" . $strTable . "</b>");
		$strThisBgClass=$strClassFirst;
		foreach ($records as $k1 => $v1 )
		{
			$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
			$strFieldName=$v1["Field"] ;
			$thistableHTML.="<tr class=\"" . $strThisBgClass  . "\"><td id=\"idfield-" .$strTable . "-" .$strFieldName  . "\">" . $strFieldName . "</td></tr>\n";
		}
		$thistableHTML.="</table>"; 

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
			$out.="\n<div id=\"iddiv-" .  $strTable . "\" style=\"position: absolute;top:" . $y . "px;left: " . $x . "px; \">" . $thistableHTML . "</div>";
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
		$out.="Drag.init(document.getElementById('iddiv-" .  $strTable . "'));\n";
		$out.="</script>";
	}
	$out.="<div>  map name: ";
	$out.=TextInput(qpre . "mapname", $mapname, 15) . " ";
	$out.= GenericInput(qpre . "savemap", "save map");
	$out.= " <a href=\"" . $strPHP . "?" . qpre . "db=" .$strDatabase . "&" . qpre . "mode=changetables&dbmap_id=" . $dbmap_id . "\">add/remove tables</a>";
	$out.= " | <a href=\"" . $strPHP . "?" . qpre . "db=" .$strDatabase . "&" . qpre . "mode=exportpdf&dbmap_id=" . $dbmap_id . "\">export PDF</a></div>";
	$out.= HiddenInputs(array("db"=>$strDatabase, "tablelist"=> $tablelist, "positions"=> ""));
	$out.= "</form>";
	$out.=RelationDump($strDatabase, $tablelist);
	return $out;
}

function MapList($strDatabase)
//Creates a space and pipe delimited string containing the essence of the tf_relation's FK data
//This is used by the javascript in drawrelationships.js to draw all the relationships between tables.
//This all has to be in javascript to allow the user to move things around and such.
{
	$sql=conDB();
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$out="";
	$strSQL="SELECT * FROM " . $strDatabase . "." . tfpre . "dbmap";
	$records = $sql->query($strSQL);
	$strThisBgClass=$strClassFirst;
	
	foreach($records as $record)
	{
		$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
		$dbmap_id=$record["dbmap_id"];
		$name=$record["map_name"];
		
		$out.=htmlrow($strThisBgClass, 
			$dbmap_id, 
			"<a href=\"dbmap.php?" . qpre. "db=" . $strDatabase . "&dbmap_id=" . $dbmap_id . "\">" .  $name . "</a>",
			"[<a onclick=\"return(confirm('Are you certain you want to delete this map?'))\" href=\"dbmap.php?" . qpre . "mode=delete&" . qpre. "db=" . $strDatabase . "&dbmap_id=" . $dbmap_id . "\">delete</a>]"
			);
	}
	if($out!="")
	{
		$out=htmlrow("bglineclass", "id", "map name", "&nbsp;"). $out;
		$out=$out ."\n</table>\n";
		$out="\n<table id=\"idsorttable2\"  class=\"bgclassline\" cellpadding=\"0\" cellspacing=\"1\" border=\"0\" width=\"300\">\n". $out;
	}
 	
	return $out;
}


function RelationDump($strDatabase, $tablelist)
//Creates a space and pipe delimited string containing the essence of the tf_relation's FK data
//This is used by the javascript in drawrelationships.js to draw all the relationships between tables.
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
			$out.=$strTable . " " . $strColumn . " " . $strFKTable . " " . $strFKColumn . "|";
		}
	}
	$out="\n<script type=\"text/javascript\">relationshipdata='" . $out . "'</script>\n";
	$out.= "<script type=\"text/javascript\" src=\"drawrelationships.js\"></script>\n";
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

function MapForm($strDatabase, $dbmap_id)
{
	$sql=conDB();
	$intFindCount=1;
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strPHP="tableform.php";
	$out="";
	$out.= adminbreadcrumb(false, $strDatabase, $strPHP . "?" . qpre . "db=" . $strDatabase,  "Choose Tables to Map", "");
	$tableheader="<table id=\"idsorttable\"  class=\"bgclassline\" cellpadding=\"0\" cellspacing=\"1\" border=\"0\" width=\"500\">\n"; 
	//echo $strSQL;
	$tables=TableList($strDatabase);
	$tableheader="<table id=\"idsorttable\"  class=\"bgclassline\" cellpadding=\"0\" cellspacing=\"1\" border=\"0\" width=\"500\">\n";
	$out.= "<script src=\"tablesort_js.js\"><!-- --></script>";
	$out.= "<form method=\"post\" name=\"BForm\" action=\"dbmap.php\">\n";
	$out.=$tableheader;
	$out.=htmlrow("bgclassline", "<a href=\"javascript: SortTable('idsorttable', 0)\">table</a>", "<a href=\"javascript: SortTable('idsorttable', 1)\">records</a>",  "<a href=\"javascript: SortTable('idsorttable', 2)\">columns</a>", "include in map");
	$strFieldName="Tables_in_" . str_replace("`", "", $strDatabase);
	$outcount=0;
	foreach ( $tables as  $k=>$v )
	{
		$tablename=$v[$strFieldName];
		$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
 		$count = countrecords($strDatabase , $tablename );
		$fieldcount=FieldCount($strDatabase, $tablename);
		$checked=false;
		if($dbmap_id!="")
		{
			$strSQL="SELECT table_name FROM " . our_db . "." . tfpre . "dbmap_table WHERE table_name='" . $tablename . "' AND dbmap_id='" . $dbmap_id . "'";
			 $recs=$sql->query($strSQL);
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
	$out.="</table>\n";
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
	$out.="</table>\n";
	$out.="</form>\n";
	$out.="<script>NumberRows('idsorttable',1);</script>";
	return $out;
}
?>