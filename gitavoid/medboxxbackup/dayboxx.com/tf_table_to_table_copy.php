<?php
//Judas Gutenberg September 2008
//copies records from one table to another based on a saved regime of column links
//This code is covered under the GNU General Public License
//info here: http://www.gnu.org/copyleft/gpl.html
//the digest is as follows: you cannot modify this code without
//publishing your source code under the same license
//contact the developer at gus@asecular.com  http://asecular.com

set_time_limit(900);
include('tf_functions_backup.php');
include('tf_functions_core.php');
include('tf_functions_frontend_db.php');
include('tf_core_table_creation.php'); 

echo main();

function main()
{
	if(!IsExtraSecure())
	{
		die(ExtraSecureFailure());
	}
	ini_set('memory_limit','450M');
	$strTable1=$_REQUEST[qpre . "table1"];
	$strTable2=$_REQUEST[qpre . "table2"];
	$mode=strtolower($_REQUEST[qpre . "mode"]);
	$maxfield=$_REQUEST[qpre . "maxfield"];
	$strMapName=$_REQUEST[qpre . "mapname"];
	$tablecopymap_id=$_REQUEST["tablecopymap_id"];
	$bwlMerge=$_REQUEST[qpre . "merge"]!="";
	//a merge is a regime where fields from the source table are copied into blank fields in the rows of the destination table
	//based on a match of a foreign key in the source table to a primary key in the destination table
	$strDatabase=deMoronizeDB(gracefuldecay($_REQUEST[qpre . "db"],our_db));
	//$quotecontent=false;
	$strPHP=$_SERVER['PHP_SELF'];
	$supressheaders=false;
	$out=LoginDecisions($strDatabase,  $strPHP, $strUser, $supressheaders);
	$out.= "<script src=\"tf_tablesort.js\"><!-- --></script>";
	if ($strUser!="")
	{
		$intAdminType= AdministerType($strDatabase, $strTable, $strUser);
		
		if ($intAdminType>1)
			{
				if(contains($mode, "delete selected regimes"))
				{
					EnsureNonRemote();
					$out.="<div class='feedback'>" . RegimeDelete($strDatabase) . "</div>";
					$mode="";
				}
				if(contains($mode, "copy"))
				{
					EnsureNonRemote();
					$out.= "<div class='feedback'>"  . CopyData($strDatabase, $strTable1, $strTable2, $tablecopymap_id) . "</div>";
				}
				if(contains($mode, "link"))
				{
					EnsureNonRemote();
					$out.="<div class='feedback'>" . StoreFieldLinks($strDatabase, $strTable1, $strTable2, $maxfield, $strMapName, $tablecopymap_id) . "</div>";
					$mode="selectrows";
				}
				if($mode=="transpose")
				{
					EnsureNonRemote();
					$out.= "<div class='feedback'>"  . RegimeTranspose($strDatabase,  $tablecopymap_id) . "</div>";
					$mode="";
				}
				if(contains($mode, "edit") || contains($mode, "choose"))
				{
					EnsureNonRemote();
					$mode="edit";
					$out.= LinkFields($strDatabase, $strTable1, $strTable2, $tablecopymap_id, $bwlMerge);
				}
				else if ($mode=="selectrows")
				{
					
					//echo $fields;
					//die();
					//fielddel rowdel  quotecontent
					
					$out.=SelectRows($strDatabase, $strTable1, $strTable2, $tablecopymap_id);
			 
				}
				else
				{
					$out.= adminbreadcrumb(false, $strDatabase, "tf.php" . "?" . qpre . "db=" . $strDatabase,"db tools","tf_dbtools.php". qpre . "db=" . $strDatabase,  "table to table copy", "tf_table_to_table_copy.php", "create regime or use existing regime", "");
					$out.="<p/>\n";
					$out.="<div class='heading'>Choose a source and destination table for copying:</div>\n";
					
					$out.= PickTables($strDatabase, $strTable1, $strTable2);
					$out.="<p/>or...<p/>\n";
					$out.=OtherLinkRegimeList($strDatabase);
					
				}
				
				$strTitle="table to table copy" . IfAThenB($strTable1, " : ") . $strTable1 . IfAThenB($strTable2, " to ") . $strTable2  ;
				$strTitle.=IfAThenB($tablecopymap_id, " : ");
				if($tablecopymap_id!="")
				{
					$strTitle.=IfAThenB($strTable1, "(");
					$strTitle.=IfAThenB($tablecopymap_id, "map# ") . $tablecopymap_id;
					$strTitle.=IfAThenB($strTable1, ")");
				}
				$strTitle.=IfAThenB($mode, " : ") . $mode;
				$out =  PageHeader($strTitle,  "") . $out . "\n<script>\nvalidationconfig='';\nTextAreaScan();\n</script>\n" . PageFooter();
				return $out;
			}
	}
}

function PickTables($strDatabase, $strTable1, $strTable2)
{
	//TableDropdown($strDatabase, $strDefaultTable, $strTableFormName, $strOurFormName='BForm', $strFieldFormName="")
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strOtherLineClass="bgclassother";
	$out="";
	$strTabledropdown1=TableDropdown($strDatabase, $strTable1, qpre . "table1",  '', "");
	$strTabledropdown2=str_replace("name=\"" . qpre . "table1\"", "name=\"" . qpre . "table2\"", $strTabledropdown1);//less work for the db
	//$strTabledropdown2=TableDropdown($strDatabase, $strTable2, qpre . "table2",  '', "");
	$out.="<form name=\"BForm\" action=\"tf_table_to_table_copy.php\" method=\"post\">\n";
	$out.=htmlrow($strClassFirst, "source table",
		 $strTabledropdown1
		);
	$out.=htmlrow($strClassSecond, "destination table",
		 $strTabledropdown2
		);
	$out.=htmlrow($strClassFirst, "is a merge",
			boolcheck(qpre . "merge",false)
		);
		
	$out.=htmlrow($strOtherLineClass, "&nbsp;", GenericInput(qpre . "mode", "Choose"));
	$out.= HiddenInputs(array("db"=>$strDatabase  ));
	$out.="</form>\n";
	$out=TableEncapsulate($out, false);
	return $out;
}

function LinkFields($strDatabase, $strTable1, $strTable2, $tablecopymap_id, $bwlMerge)
{
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strOtherLineClass="bgclassother";
	$strLineClass="bgclassline";
	$arrDefault=Array();
	$sql=conDB();
	$strBreadcrumblabel="link columns";
	if($tablecopymap_id!="")
	{
		$rs=GenericDBLookup($strDatabase, tfpre . "tablecopymap",  "tablecopymap_id",   $tablecopymap_id, "", false, false);
		$strTable1=$rs["source_tablename"];
		$strTable2=$rs["dest_tablename"];
		$strRegimeName=$rs["name"];
		$strFKColumn=$rs["fk_column_name"];
		$postcopy_script=$rs["postcopy_script"];
		$merge_source_fk=$rs["merge_source_fk"];
		$merge_dest_pk=$rs["merge_dest_pk"];
		if($merge_dest_pk!=""  || $merge_source_fk!="")
		{
			$bwlMerge=true;
		}
	 
	}
	$preout="";
	$out="";
	$overallout="";
	if($strRegimeName!="")
	{
		$preout.= adminbreadcrumb(false, $strDatabase, "tf.php" . "?" . qpre . "db=" . $strDatabase,"db tools","tf_dbtools.php". qpre . "db=" . $strDatabase,  "table to table copy", "tf_table_to_table_copy.php?tablecopymap_id=" . $tablecopymap_id, $strRegimeName, "", $strBreadcrumblabel, "");
	}
	else
	{
		$preout.= adminbreadcrumb(false, $strDatabase, "tf.php" . "?" . qpre . "db=" . $strDatabase,"db tools","tf_dbtools.php". qpre . "db=" . $strDatabase,  "table to table copy", "tf_table_to_table_copy.php?tablecopymap_id=" . $tablecopymap_id, $strBreadcrumblabel, "");
	}
	$preout.="<p/>\n";
	$preout.="<a href=\"javascript:concordanceviewer()\">view sample data for this regime</a>";
	$preout.="<div class='heading'>Map columns of source " . $strTable1 . " to columns of destination " . $strTable2 . "</div>";
	$out.="<form name=\"BForm\" action=\"tf_table_to_table_copy.php\" method=\"post\">\n";
 
	$out.=htmlrow($strLineClass, 
		"copy regime name</a>", 
		TextInput(qpre . "mapname", 
		$strRegimeName, 40)
	);
	$i=0;
	$overallout.=$preout . TableEncapsulate($out, false);
	$out="";
	$arrThisRow=Array($strThisBgClass,  
		"<a href=\"javascript: SortTable('idsorttable', 0)\">column in " . $strTable1 . "</a>", 
		"<a href=\"javascript: SortTable('idsorttable', 1)\">type</a>",
		"<a href=\"javascript: SortTable('idsorttable', 2)\">percentage used", 
		"<a href=\"javascript: SortTable('idsorttable', 3)\">column in " .  $strTable2 . "</a>",
		"<div align=\"right\"><a href=\"javascript: SortTable('idsorttable', 4)\">conversion formula</a></div>" 
	);
	if($bwlMerge)
	{
		$arrThisRow[]= "&nbsp;FK to PK relationship for merge";
	}
	$out.=call_user_func_array("htmlrow", $arrThisRow);
	$arrPercentages=PercentageOfNotNullsInTable($strDatabase, $strTable1);
	$records=TableExplain($strDatabase, $strTable1);
	//$modelFieldDropdown=FieldDropdown($strDatabase, $strTable2, qpre. "field_<number/>", "<dest/>"); //easier on the db to just generate the dropdown once and sub-in pieces
	foreach ($records as $k => $info )
	{
		
		$strSourceField=$info["Field"];
		//echo $strSourceField . "<br>";
		//GenericDBLookupWhere($strDB, $strTable,   $strIDFieldName . " = '" . $strThisID . "' ORDER BY " .  $pk. " DESC", $strResultFieldName, false);
		if($tablecopymap_id!="")
		{
			$rs=GenericDBLookupWhere($strDatabase, tfpre . "tablecopymap_fieldlink", "tablecopymap_id='". $tablecopymap_id . "' AND source_column_name='" . $strSourceField . "'" , "", false, false);
		///echo "<P>";
			$strDestColumn=$rs["dest_column_name"];
			$strFormula=$rs["conversion_formula"];
		}
	
		$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
		//echo $merge_source_fk. " " . $strSourceField . "<br>";
		if($merge_source_fk==$strSourceField)
		{
			$strDestColumn=$merge_dest_pk;
			//echo $strDestColumn . " <P>";
		}
		$strFieldDropdown=FieldDropdown($strDatabase, $strTable2, qpre. "field_" . $i, $strDestColumn);
		//$strFieldDropdown=str_replace("<number/>", $i, $modelFieldDropdown); //never mind - no defaults!!!
		//$strFieldDropdown=str_replace("<dest/>", $strDestColumn, $strFieldDropdown);
		$conversionInput=TextInput(qpre . "formula_" . $i, $strFormula, 30);
		$arrThisRow=Array($strThisBgClass,  
			$strSourceField, 
			$info["Type"],
			$arrPercentages[$strSourceField],
			$strFieldDropdown, 
			$conversionInput
		);
		if($bwlMerge)
		{
			$arrThisRow[]= RadioInput(qpre . "mergerelation", $strSourceField, $merge_source_fk == $strSourceField);
		}
		$out.=call_user_func_array("htmlrow", $arrThisRow);
		$hiddensources.=$strSourceField . "|" . $i . "~";
		$i++;
		
		 
 	}
	$hiddensources=RemoveEndCharactersIfMatch($strValuesSQL, "~");
	//$out.=htmlrow($strOtherLineClass, "&nbsp;", GenericInput(qpre . "mode", "Link Fields", false, 'if(document.BForm.' . qpre . 'mapname==\"\"){alert(\"You must provide a name\"); return false;}';
	 
	$overallout.= TableEncapsulate($out);
	$out="";
	$strFKColumnDropdown=FieldDropdown($strDatabase, $strTable1, qpre. "fkcolumn", $strFKColumn);
	if(!$bwlMerge)
	{
		$out.=htmlrow($strOtherLineClass, "<nobr>Populate this column in " . $strTable1. " with the PK of the insert:</nobr>",$strFKColumnDropdown);
	}
	// GenericInput($name, $default, $bwlChecked=false, $onClick="",  $strStyle="", $strClass="", $type="submit", $size="", $strStrayJS="", $height=1)
	$out.=htmlrow($strLineClass, "Script to run after each row copied:",GenericInput(qpre . "postcopy_script",deescape($postcopy_script),false, "", "", "", "", 90, "", 5));
	
	$out.=htmlrow($strOtherLineClass, "&nbsp;" , GenericInput(qpre . "mode", "Save Regime Links"));
	$out.= HiddenInputs(array("db"=>$strDatabase, "maxfield"=>$i ));
	$out.= HiddenInputs(array("table1"=>$strTable1, "table2"=>$strTable2 ));
	$out.= HiddenInputs(array("tablecopymap_id"=>$tablecopymap_id), "");
	$out.= HiddenInputs(array("sources"=>$hiddensources));
	
	$overallout.= TableEncapsulate($out,false);
	$out="";
	$out.="</form>\n";
	
	$out.= "<script src=\"tf_tabletotableconcordanceviewer.js\"><!-- --></script>";
	 
	$overallout.=$out;
	return $overallout;
}

function StoreFieldLinks($strDatabase, $strTable1, $strTable2, $maxfield, $strMapName, &$intGrandPK )
{
	if( $strMapName!="")
	{
		MakeTableIfNotThere($strDatabase, tfpre . "tablecopymap", "MakeTableCopyMapTables");
		$postcopy_script=$_REQUEST[qpre . "postcopy_script"];
		$fkcolumn=$_REQUEST[qpre . "fkcolumn"];
		$mergerelation=$_REQUEST[qpre . "mergerelation"];
		$arrAlteredValuePairs=Array("postcopy_script"=> singlequoteescape($postcopy_script),"fk_column_name"=>$fkcolumn, "name"=>$strMapName,"source_tablename"=>$strTable1, "dest_tablename"=>$strTable2);
		if($intGrandPK=="")
		{
 
		
			
			$arrAlteredValuePairs["create_date"]=date("Y-m-d H:i:s");  //only save create date if it's a create
		}
		$arrIDPairs="";
		if($intGrandPK!="")
		{
			$arrIDPairsForGrand=Array("tablecopymap_id"=>$intGrandPK);
			$sql=conDB();
			$strTable=tfpre . "tablecopymap_fieldlink";
			$strPKColumn="tablecopymap_id";
			//delete the old links
			$strSQL="DELETE FROM " . $strDatabase . "." . $strTable . " WHERE " . $strPKColumn . "='" . $intGrandPK . "'";
			$records = $sql->query($strSQL);
		}
		$pk=UpdateOrInsert($strDatabase,  tfpre . "tablecopymap", $arrIDPairsForGrand, $arrAlteredValuePairs);
		$arrFields=FieldArray($strDatabase, $strTable1);
		$pk=gracefuldecay($intGrandPK, $pk); 
		for($i=0; $i<$maxfield; $i++)
		{
			//save the field links
			//$arrIDPairs=Array("tablecopymap_id"=>$pk);
			$strPossibleDestName=$_REQUEST[qpre . "field_" . $i];
			if($mergerelation==$arrFields[$i])//then it's a merge we're saving and this is actually a FK for a PK in the destination
			{
				if(!is_array($arrIDPairsForGrand))
				{
					$arrIDPairsForGrand=Array("tablecopymap_id"=>$pk);
				}
				$arrAlteredValuePairs=Array("merge_dest_pk"=>$strPossibleDestName, "merge_source_fk"=>$arrFields[$i]);
				UpdateOrInsert($strDatabase,  tfpre . "tablecopymap", $arrIDPairsForGrand, $arrAlteredValuePairs);
			}
			else
			{
				$arrIDPairs="";
				//echo $pk;
				
				$conversion_formula=str_replace("'", "&#39;", $_REQUEST[qpre . "formula_" . $i]);
				if($strPossibleDestName!="")
				{
					$arrAlteredValuePairs=Array("tablecopymap_id"=>$pk,"source_column_name"=>$arrFields[$i], "dest_column_name"=> $strPossibleDestName, "conversion_formula"=>$conversion_formula);
					UpdateOrInsert($strDatabase,tfpre . "tablecopymap_fieldlink", $arrIDPairs, $arrAlteredValuePairs  );
				}
			}
		}
		$intGrandPK=$pk;
		$out="Copy regime saved.";
	}
	else
	{
		$out="Copy regime must be named.";
	}
	return $out;
}

function FieldArray($strDatabase, $strTable)
{
	$arrOut=Array();
	$records=TableExplain($strDatabase, $strTable);
	$i=0;
	foreach ($records as $k => $info )
	{
		$arrOut[$i]=$info["Field"];
		$i++;
 	}
	return $arrOut;
}

function SelectRows($strDatabase, $strTable1, $strTable2,$tablecopymap_id)
{
//GenericRSDisplay($strDatabase, $strPHP,$strLabel, $strSQL, $truncate, $intWidth, $strLinkFieldName="", $strLinkIDName="", $strAdditionalLink="", $strSuppressFields="", $bwlSuppressHeader=false, $bwlPrettyUpFieldNames=true)
	$strBreadcrumblabel="select rows";
	if($strTable1=="")
	{
		$rs=GenericDBLookup($strDatabase, tfpre . "tablecopymap",  "tablecopymap_id",   $tablecopymap_id, "", false, false);
		//the following are transposed directly
		$strTable2=$rs["source_tablename"];
		$strTable1=$rs["dest_tablename"];
		$strRegimeName=$rs["name"];
		//$strBreadcrumblabel.= ": ". $strRegimeName;
	}
	$strSQL="SELECT * FROM " .  $strDatabase . "." . $strTable1 ;
	$out="";
	$strCheckboxName="listid";
	
	if($strRegimeName!="")
	{
		$out.= adminbreadcrumb(false, $strDatabase, "tf.php" . "?" . qpre . "db=" . $strDatabase,"db tools","tf_dbtools.php",  "table to table copy", "tf_table_to_table_copy.php". qpre . "db=" . $strDatabase, $strRegimeName, "tf_table_to_table_copy.php?" . qpre . "mode=edit&tablecopymap_id=" . $tablecopymap_id, $strBreadcrumblabel, "");
	}
	else
	{
		$out.= adminbreadcrumb(false, $strDatabase, "tf.php" . "?" . qpre . "db=" . $strDatabase,"db tools","tf_dbtools.php",  "table to table copy", "tf_table_to_table_copy.php". qpre . "db=" . $strDatabase, $strBreadcrumblabel, "");
	}
	$out.="<p/>\n";
	//$checkcell=CheckboxInput(qpre .$strCheckboxName . "[]", "<replace/>",  false);
	$checkcell="<input type='checkbox' name='" . qpre . $strCheckboxName  . "[]' value='<replace/>'>";
	$checkcell.="<a href=\"javascript:alldumpcheckboxes('" . $strCheckboxName ."[]', 'rev', 0, " . "<rowcount/>" .")\">&#94;</a> ";
	$checkcell.="<a href=\"javascript:alldumpcheckboxes('" . $strCheckboxName ."[]', 'rev', " . "<rowcount/>".")\">v</a>";
	$out.="<form name=\"BForm\" action=\"tf_table_to_table_copy.php\" method=\"post\">\n";
	$out.=GenericRSDisplay($strDatabase, "tf_table_to_table_copy.php","Select Rows to Copy from " . $strTable1 . " to " . $strTable2, $strSQL, 1, 850, "", "", $checkcell, "", false, true);
	$out.= HiddenInputs(array("db"=>$strDatabase  ));
	$out.= HiddenInputs(array("table1"=>$strTable1, "table2"=>$strTable2 ));
	$out.= HiddenInputs(array("tablecopymap_id"=>$tablecopymap_id), "");
	$out.=GenericInput(qpre . "mode", "Copy Selected Rows from " . $strTable1  . " to " . $strTable2 );
	$out.=" <a href=\"javascript:alldumpcheckboxes('" . $strCheckboxName . "[]', true)\">select all</a> | <a href=\"javascript:alldumpcheckboxes('" . $strCheckboxName  . "[]', false)\">select none</a>";
	$out.="</form>";
	return $out;

}

function CopyData($strDatabase, $strTable1, $strTable2, $tablecopymap_id)
{
//the function that applies a copy regime
//this bad boy also handles merges as of September 30, 2008
	$sql=conDB();
	//echo $tablecopymap_id;
	$strSQL="SELECT * FROM " . $strDatabase . "." . tfpre . "tablecopymap WHERE tablecopymap_id='" . $tablecopymap_id . "'";
	//echo $strSQL . " " . sql_error() . "<p>";
	$rs = $sql->query($strSQL);
	$r=$rs[0];
	$postcopy_script=$r["postcopy_script"];
	$fk_column_name=$r["fk_column_name"];
	$merge_dest_pk=$r["merge_dest_pk"];
	$merge_source_fk=$r["merge_source_fk"];
	$strSQL="SELECT * FROM " . $strDatabase . "." . tfpre . "tablecopymap_fieldlink WHERE tablecopymap_id='" . $tablecopymap_id . "'";
	$pk=PKLookup($strDatabase, $strTable1);
	$rsMap = $sql->query($strSQL);
	//echo sql_error(). "<br>";
	$out=0;
	$error="";
	if(is_array($_REQUEST[qpre . "listid"]))
	{
		foreach($_REQUEST[qpre . "listid"] as $listid)
		{
			$strSQL="SELECT * FROM " . $strDatabase . "." . $strTable1 . " WHERE " . $pk . "='" . $listid . "'";
			//echo $pk . " " . $listid . "<br>";
			$arrID=Array($pk=>$listid);
			//echo "---" . $strSQL . "<br>";
			$rsData = $sql->query($strSQL);
			//echo sql_error(). "<br>";
			$rsDatum=$rsData[0];
			$strSQL="";
			$strUpdateSQL="";
			$strValuesSQL="Values(";
			$strFieldListSQL=$strDatabase  . "." . $strTable2 . "(" ;
			$strExistingSQL="";
			foreach($rsMap as $rMap)
			{
				//echo "!";
				$destcolumnname=$rMap["dest_column_name"];
				$sourcecolumnname=$rMap["source_column_name"];
				$strFormula=$rMap["conversion_formula"];
				$value=$rsDatum[$sourcecolumnname];
				if($strFormula!="")
				{
					if(beginswith($strFormula, "&"))  //for case where the formula is actually just a list of additional fields to get identical data from single source field
					{
						$strFormula=RemoveEndCharactersIfMatch($strFormula, "&");
						$strFormula=str_replace(",",  " ", $strFormula);
						$strFormula=str_replace(";",  " ", $strFormula);
						$strFormula=deMultiple(trim($strFormula), " ");
						$arrFormula=explode(" ", $strFormula);
						foreach($arrFormula as $thisextrafield)
						{
							$strFieldListSQL.=$thisextrafield . ",";
							$strValuesSQL.="'" . singlequoteescape($value) . "',";
						}
						
					
					}
					else
					{
						$strFormula=FixFormulaForEval($strFormula);
						$strFormula=str_replace("this", "\"" . singlequoteescape($value) . "\"", $strFormula);
						$strFormula='$returnval=' . $strFormula . ";";
						//echo $strFormula . "=form<P>";
						eval($strFormula );
						//echo $returnval ."=rval<P>";
						//echo $value . "=val<P>";
						$value=$returnval;
					}
				}
		 
				$strFieldListSQL.=$destcolumnname . ",";
				$strValuesSQL.="'" . singlequoteescape($value) . "',";
				$strExistingSQL.="AND " . $destcolumnname . "='" . singlequoteescape($value) . "'";
				$strUpdateSQL=", "  . $destcolumnname . "='" . singlequoteescape($value) . "'";
			
			}
			$strWhereclause=" WHERE " . substr($strExistingSQL, 3);
			$strExistingSQL="SELECT * FROM " . $strDatabase  . "." . $strTable2 . $strWhereclause;
			$strValuesSQL=RemoveEndCharactersIfMatch($strValuesSQL, ",");
			$strUpdateSQL=RemoveEndCharactersIfMatch($strUpdateSQL, ",");
			$strFieldListSQL=RemoveEndCharactersIfMatch($strFieldListSQL, ",");
			
			$strValuesSQL.=")";
			$strFieldListSQL.=")";
			$rs = $sql->query($strExistingSQL);
			if(count($rs)<1  || $merge_dest_pk!="")  //don't put derived dupes into the dest table
			{
				if($merge_dest_pk!="")
				{
					//it's a merge we're doing, thus it will be an update
					$strSQL="UPDATE " . $strTable2 . " SET " . $strUpdateSQL;
					//echo $merge_source_fk . "<br>";
					$strSQL.=" WHERE " . $merge_dest_pk . "='" . $rsDatum[$merge_source_fk] ."'";
				}
				else
				{
					$strSQL="INSERT INTO " . $strFieldListSQL . " " . $strValuesSQL;
					//echo sql_error() . "<p/>";
					$out++;
				}
				//echo $strSQL . "<p/>";
				$rs = $sql->query($strSQL);
				if($merge_dest_pk!="")
				{
					//it's not technically an insertid because we did an update, but the id is something we might need for the postcopy_script
					$insertid=$rsDatum[$merge_source_fk];
				}
				else
				{
					$insertid=mysql_insert_id();
				}
				if($fk_column_name!="")
				{
					//backfill the ID of the insert in cases where a relationship needs to be maintained
					//we wouldn't need to do this after a merge
					$arrAlteredValuePairs=Array($fk_column_name=>$insertid);
					UpdateOrInsert($strDatabase,  $strTable1, $arrID, $arrAlteredValuePairs, false, false);
				}
			}
			if($postcopy_script!="")
			{
				$arrSQL=ParseStringToArraySkippingQuotedRegions($postcopy_script);
				foreach($arrSQL as $strSQL)
				{
					$strSQL=trim($strSQL);
					if($strSQL!="")
					{
						//sql is tokenized at this point; expansions are needed
						$strSQL=str_replace("&#39;",  "'", $strSQL);
						$strSQL=str_replace("\'",  "'", $strSQL);
						$strSQL=str_replace("<id>", $insertid, $strSQL);
						$strSQL=str_replace("<timestamp>", time(), $strSQL);
						//echo $strSQL . "<BR>";
						$sql->query($strSQL);
						$error.=IFAThenB(sql_error(), "<br/>". sql_error());
						
					}
				}
			}
		}
	}
	$out.= " " .  PluralizeIfNecessary("record", $out) . " were copied.";
	$out.=IFAThenB($error,  "<br/>" . $error);
	return $out;
}

function OtherLinkRegimeList($strDatabase)
{
	//provides the master list of copy regimes
	$out="";
	$out.="<form name=\"BForm\" action=\"tf_table_to_table_copy.php\" method=\"post\">\n";
	$strSQL= "SELECT * FROM " . $strDatabase . "." . tfpre . "tablecopymap ORDER BY create_date DESC LIMIT 0,30";
	$checkboxtag="<input type='checkbox' name='" . qpre . "regimedelete[]' value='<replace/>'>";
	
	$checkboxtag.=" [<a href=\"tf_table_to_table_copy.php?" . qpre . "mode=transpose&tablecopymap_id=<replace/>\">create transposition</a>]";
	$checkboxtag.=" [<a href=\"tf_table_to_table_copy.php?" . qpre . "mode=edit&tablecopymap_id=<replace/>\">edit</a>]";
	$checkboxtag.=" [<a href=\"tf_table_to_table_copy.php?" . qpre . "mode=selectrows&tablecopymap_id=<replace/>\">use</a>]";
	$out.=GenericRSDisplay($strDatabase, "tf_table_to_table_copy.php?" . qpre . "mode=edit","Select an existing copy regime:",$strSQL, true, "100%", "tablecopymap_id", "tablecopymap_id", $checkboxtag);
	$out.= HiddenInputs(array("db"=>$strDatabase  ));
	$out.= HiddenInputs(array("table1"=>$strTable1, "table2"=>$strTable2 ));
	$out.= HiddenInputs(array("tablecopymap_id"=>$tablecopymap_id), "");
	// GenericInput($name, $default, $bwlChecked, $onClick
	$out.=GenericInput(qpre . "mode", "Delete Selected Regimes", false, "return(confirm(\"Are you certain you want to delete the selected regimes?\"))" );
	$out.="</form>";
	return $out;
}

function RegimeDelete($strDatabase)
{
	$sql=conDB();
	$error="";
	$out=0;
	if(is_array($_REQUEST[qpre . "regimedelete"]))
	{
		foreach($_REQUEST[qpre . "regimedelete"] as $regimeid)
		{
		 	$strSQL="DELETE FROM " . $strDatabase . ".tf_tablecopymap WHERE tablecopymap_id='" . $regimeid . "'";
			$rs = $sql->query($strSQL);
			$error.=sql_error();
			$strSQL="DELETE FROM " . $strDatabase . ".tf_tablecopymap_fieldlink WHERE tablecopymap_id='" . $regimeid . "'";
			$rs = $sql->query($strSQL);
			$error.=sql_error();
			$out++;
		}
	}
	return intval($out) . " " . PluralizeIfNecessary("regime", $out) . " were deleted." . $error;
}

function RegimeTranspose($strDatabase,  $tablecopymap_id)
{
//September 13 2008 Judas Gutenberg
//swaps the links and source/destination tables in a copy regime
//if you made a regime to copy from users to customers, this allows you to copy from customers to users
	$sql=conDB();
	if($tablecopymap_id!="")
	{
		//$arrIDPairs=Array("tablecopymap_id"=>$tablecopymap_id);  /we are explicitly creating something new
		$strTable=tfpre . "tablecopymap_fieldlink";
		$strPKColumn="tablecopymap_id";
		$rs=GenericDBLookup($strDatabase, tfpre . "tablecopymap",  $strPKColumn,   $tablecopymap_id, "", false, false);
		//the following are read into variables pre-transposed 
		$strTable2=$rs["source_tablename"];
		$strTable1=$rs["dest_tablename"];
		$fk_column_name=$r["fk_column_name"]; //this would have to be repicked from scratch after a transposition - no way to know what it should be
		$merge_source_fk=$rs["merge_dest_pk"]; //i don't really know what a transposed merge entails
		$merge_dest_pk=$rs["merge_source_fk"]; //but i'm allowing for it anyway
		$oldname=$rs["name"];
		$strRegimeName="transposed_" . $rs["name"];
	}
	$arrAlteredValuePairs=Array("name"=>$strRegimeName,"source_tablename"=>$strTable1, "dest_tablename"=>$strTable2,"merge_source_fk"=>$merge_source_fk, "merge_dest_pk"=>$merge_dest_pk);
	$arrAlteredValuePairs["create_date"]=date("Y-m-d H:i:s");  //only save create date if it's a create
	$arrIDPairs="";
	$newpk=UpdateOrInsert($strDatabase,  tfpre . "tablecopymap", $arrIDPairs, $arrAlteredValuePairs);
	$arrFields=FieldArray($strDatabase, $strTable1);
 	$strSQL="SELECT * FROM " . $strDatabase . "." . tfpre . "tablecopymap_fieldlink WHERE tablecopymap_id='" . $tablecopymap_id . "'";
	$rs = $sql->query($strSQL);
	foreach($rs as $r)
	{
		//echo "$";
		//save the field links
		//$arrIDPairs=Array("tablecopymap_id"=>$pk);
		$arrIDPairs="";
		$strSourceColumn=$r["source_column_name"];
		$strDestColumn=$r["dest_column_name"];
		//$conversion_formula=$_REQUEST[qpre . "formula_" . $i];
		if($strDestColumn!="")
		{
			$arrAlteredValuePairs=Array("tablecopymap_id"=>$newpk,"source_column_name"=>$strDestColumn, "dest_column_name"=> $strSourceColumn);
			//, "conversion_formula"=>$conversion_formula would take some crazy parsing!
			UpdateOrInsert($strDatabase,tfpre . "tablecopymap_fieldlink", $arrIDPairs, $arrAlteredValuePairs );
		}
	}
	$out="Copied regime " . $oldname . " transposed to " . $strRegimeName. ".";
	return $out;
}

?>