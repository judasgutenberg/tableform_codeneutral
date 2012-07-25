<?php
//////////////////////////////////////////////////////////////
//Judas Gutenberg December 13 2007///////////////////////////
////////////////////////////////////////////////////////////
//This code is covered under the GNU General Public License
//info here: http://www.gnu.org/copyleft/gpl.html
//the digest is as follows: you cannot modify this code without
//publishing your source code under the same license
//contact the developer at gus@asecular.com  http://asecular.com
////

function SearchTypeToSQLPhrase($intSearchType, $strSearchField, $strSearchString)
{
//Given a $intSearchType (derived from a hardcoded double-delimited string), $strSearchField and $strSearchString, make a SQL search phrase)
	$strSQL="";
	if ($strSearchString!="" &&  $strSearchField!="")
	{
		if ($intSearchType==0)
		{
			$strSQL=" WHERE " . $strSearchField . " LIKE '" . $strSearchString . "%'";
		}
		elseif ($intSearchType==1)
		{
			$strSQL=" WHERE " . $strSearchField . " LIKE '%" . $strSearchString . "%'";
		}
		elseif ($intSearchType==2)
		{
			$strSQL=" WHERE " . $strSearchField . " LIKE '%" . $strSearchString . "'";
		}
		elseif ($intSearchType==3)
		{
			$strSQL=" WHERE " . $strSearchField . " = '" . $strSearchString . "'";
		}
	}
	return $strSQL;
}


function DisplayDataTable($strDatabase, $strTable, $strIDFieldName, $strSortColumn, $strPHP, $strDirection, $intRecord, $strSearchString, $strSearchField, $intSearchType,$intRecsPerPage=50, $strFieldConfig="", $intFieldLimitLo=1,$intFieldLimitHi=5, $bwlShowDelete=true, $bwlHandback=false, $bwlSuppressHeaderLinks=false, $launcherfield="", $displaytype="", $intThisFilterID, $UserID="", $bwlSuperAdmin=false, $bwlAlwaysAllowNewLink=false, $bwlShowCountRelated=true)
//displays the entire contents of a given table.  $strIDFieldName allows for editing by primary key reference
//$strSortColumn allows for picking a column to sort by (ASC or DESC depending on $strDirection)
//i admit this function is becoming unmaintainable due to the many scenarios i have forced it to handle
{
 	//this loop is kind of awkward, but it allows me to pass a variable through to this function through the query string
	foreach($_GET as $k=>$v)
	{
		if (!beginswith($k, qpre))
		{
			$extraqsk=$k;
			$extraqsv=$v;
		}
	
	}
	$modeaddition="";
	if($bwlShowCountRelated)
	{
		$modeaddition="related";
	}
	$bwlSortRelated=false;
	$intTruncSize=30;
	$strBgClassFirst="bgclassfirst";
	$strBgClassSecond="bgclasssecond";
	$strBgClassOther="bgclassother";
	$strLineClass="bgclassline";
	$strActionStyle="font-size:9px";
	$strThisBgClass=$strBgClassFirst;
	$bwlShowEdit=true;
	$strGraphClassFirst="graph1";
	$strGraphClassSecond="graph2";
	$bwlBrowseMode=false;
	$strPHPForRows=$strPHP;
	$intSpacerColumns=2;
	$strOriginalTable=$strTable;
	$strWidthSpecialOther="";
	$sql=conDB();
	$ToolRecord=BrowseExtraTool($strDatabase, $strTable, $displaytype);
	//echo "<br>--<br>" . var_dump($ToolRecord);
	$descr=TableExplain($strDatabase, $strTable);
	$whereadditional="";
	$strCountSearch="count(*)";
	$strNameColumn=firstnonidcolumname($strDatabase,  $strTable);
	$strAdminIDRangeAddendum=UserIDToSelectAddendum($strDatabase, $strTable, $strIDFieldName, $UserID);
 	$out="";
	//$out.=AdminNav($bwlSuperAdmin);
	//$strSQL=" FROM  " .  $strDatabase . "." . $strTable ;
	//the following block of code is specific to a type of view called a graph.  i have to handle the specifics of its display in a non-generic way,
	//as i will have to do with every type of view
	
	
	$strSQLThis="SELECT * FROM " . $strDatabase. "." . tfpre . "browsescheme WHERE table_name='" . $strTable . "'";
	$records = $sql->query( $strSQLThis);
	$record=$records[0];
	$strGivenLabelField=$record["label_field"];
	$display_field_list=$record["display_field_list"];
	//die($strGivenLabelField);
	//5-4-2006: actually, it is to any type of browser scheme, some of which will be graphs
	if ($displaytype!="")   //it's a graph
	{

		//die($display_field_list);
		$strPHPForRows=gracefuldecay($record["toolpage"], $strPHP);
		$strGivenQuantityField_x=$record["quantity_field_x"];
		$strGivenFilterField=$record["filter_field"];
		$strSQLThis="SELECT MAX(" . $strGivenQuantityField_x . ") as MAX FROM " . $strDatabase. "." . $strTable . " WHERE " . $strGivenFilterField . " = " . $intThisFilterID;
		$strSQLThis=ProperlyAppendSQLWherePhrase($strSQLThis, $strAdminIDRangeAddendum);
		
		$records = $sql->query( $strSQLThis);
		$record=$records[0];
		$intMaxVal=$record["MAX"];
		$arrFKLookup=foreignKeyLookup($strDatabase, $strTable, $strGivenFilterField);
		$FKtable=$arrFKLookup[0];
		$FKIDField=$arrFKLookup[1];
		$strFieldConfig=$strTable . "|" . $strGivenLabelField . "|" . $strGivenQuantityField_x;
		$intFieldLimitLo=intval(-1);
		$intFieldLimitHi=4;
		$bwlShowDelete=false;
		$bwlShowEdit=false;
		$intSpacerColumns=0;
		if ($intThisFilterID!="")
		{
			$whereadditional=" WHERE " . $strGivenFilterField  . " = " . $intThisFilterID;
		}
		else
		{
			//if we don't have an id to filter on and there needs to be one, then we need to generate a conventional data browser for the filter id's table,
			//which is to be found in the table it is a foreign key for.
			
			$arrFKLookup=foreignKeyLookup($strDatabase, $strTable, $strGivenFilterField);
			$FKtable=$arrFKLookup[0];
			if ($FKtable!="")
			{
				//$strSQL=" FROM " .   $strDatabase. "." . $FKtable;
				$descr=TableExplain($strDatabase, $FKtable); 
				$strNameColumn=firstnonidcolumname($strDatabase,  $FKtable);
				$strTable=$FKtable;
			}
			//for now i'll just turn off fieldconfig in these special data browser situations
			$strFieldConfig="";
			$bwlBrowseMode=true;
		}
	}
	$strSQL.=SearchTypeToSQLPhrase($intSearchType, $strSearchField, $strSearchString);
	$strSQL=ProperlyAppendSQLWherePhrase($strSQL, $strAdminIDRangeAddendum);
	$strSQL.=$whereadditional;
	//added some code to default to sort by pk
 
	if ($strIDFieldName=="")
	{
		$strIDFieldName=PKLookup($strDatabase, $strTable);
	}
	if ($strSortColumn=="")
	{
	 
		$strSortColumn=str_replace(" ", ",", $strIDFieldName);
	}
	elseif(beginswith($strSortColumn, qpre))
	{
		$strSortColumn=str_replace(" ", ",", $strIDFieldName);
		$bwlSortRelated=true;
	}
 
	//echo "-" . $strSortColumn . "-<br>+" .  $strIDFieldName . "+<br>";
	if ($strSortColumn!="")
	{
		$strSQL.=" ORDER BY " . $strSortColumn . " " . $strDirection;
	}
	//echo "SELECT " . $strCountSearch . "  FROM " .   $strDatabase. "." . $strTable . $strSQL;
	$records = $sql->query("SELECT " . $strCountSearch . "  FROM " .   $strDatabase. "." . $strTable . $strSQL);
	$record=$records[0];
	$count=$record[$strCountSearch];
	//echo "<br>" . $count;
	//$strDoSQL=" FROM " .   $strDatabase. "." . $strTable;
	//$strDoSQL="SELECT * " . $strDoSQL . $strSQL;
	$strDoSQLAdditional.=GetLimitClause($intRecord,$intRecsPerPage);
	
	$strDoSQL=FleshedOutFKSelect($strDatabase, $strTable, $strSQL . " " .$strDoSQLAdditional, $arrDescr, "", true);
	
	//echo "<br>" . $strDatabase  . " ------- " .  $strDoSQL;
	$records = $sql->query($strDoSQL);
	if (sql_error()!="" )
	{
		$strDoSQL="SELECT *  FROM " .   $strDatabase. "." . $strTable.  $strSQL . $strDoSQLAdditional;
		$records = $sql->query($strDoSQL);
	}
	//echo $strDoSQL . "<br>";
	//echo sql_error();
	

	$strISQL="SELECT * FROM " . $strDatabase . "." .  tfpre . "column_info WHERE table_name='" . $strOriginalTable . "'"; 
	//echo $strISQL. "<br>";
	$irecords = $sql->query($strISQL);
	//echo $strIDFieldName . "--" ;
	

	$out.=   TableColumnHeader($strDatabase,$strOriginalTable, $strPHP, $strDirection, $strLineClass, $strBgClassOther, $strSortColumn, $strSearchString, $strSearchField, $intSearchType,  $intFieldLimitHi, $intFieldLimitLo, $strFieldConfig, $bwlSuppressHeaderLinks, $launcherfield, $displaytype, addBwls($bwlShowEdit, $bwlShowDelete, $ToolRecord!=""), $intThisFilterID, $FKIDField, $FKtable, $bwlBrowseMode, $records[0], $irecords, $bwlAlwaysAllowNewLink, $display_field_list, $bwlShowCountRelated);
 	$strPHP=$strPHPForRows;
	foreach ($records as $key=>$value )
	{
	
		$keyserialized="";

		if(contains($strIDFieldName, " "))
		{
			$keyserialized=$qpre . "&" . qpre . "ks=" . urlencode(serialize(ArraySubsetFromList($strIDFieldName, $value)));
		}
	
	
		$strThisBgClass=Alternate($strBgClassFirst, $strBgClassSecond, $strThisBgClass);
		$out.= "<tr class=\"" . $strThisBgClass . "\">\n";
		$intFieldCount=0;
		
		foreach ( $value as $key1 => $value1 )
		{
			$type=$arrDescr[$columnname];
			
			$bwlForceHide=false;
			foreach($irecords as $irecord)
			{
				if($irecord["column_name"]==$key1 && $irecord["invisible"]==1)
				{
					$bwlForceHide=true;
				
				}
			}
			if (GreaterFieldDisplayLogic($strTable, $strFieldConfig, $key1, $intFieldCount, $intFieldLimitLo, $intFieldLimitHi, $display_field_list) && !$bwlForceHide || ($strSearchField==$key1))
			{
				$strWidthSpecial=$strWidthSpecialOther; //a clever trick allowing a bars in graph mode to slam the other columns narrow
				switch ($type)
				{
					case "date":
					{
						if ($value1!="")
						{
							if (!is_numeric($value1)  && $value1!="")
								{	
									$value1=strtotime($value1);
								}
							$value1 = date('m/j/y', $value1);
						}
						else
						{
							$value1="";
						}
						break;
					}
					case "tinyint":
					{
						if (!$arrForce_binary[$nameforhelp]  && !(abs($value1)>1))
						{
							$value1=IntToSQLBoul($value1);
							break;
						}
					}
				}
				if ($bwlBrowseMode && $strNameColumn== $key1)  //we're in browser mode and this is a name column, so time for a hyperlink
				{
				
	
					

					$strDataToDisplay="<a href=\"" . qbuild($strPHP, $strDatabase, $strOriginalTable , "view" . $modeaddition, $strIDFieldName, $value[$strIDFieldName]) . "&" . qpre . "displaytype=" . $displaytype . "&" . qpre . "filterid=" . $value[$strIDFieldName] .  $keyserialized . "\">" . trunchandler( $value1, $intTruncSize) . "</a>";
				
				}
				elseif ($key1==$strGivenQuantityField_x  && $displaytype==1)  //then this is a graphable quantity
				{
					//this block of code only makes sense with 2-d graphs!
					$graphwidth=400;
					$strThisGraphClass=Alternate($strGraphClassFirst, $strGraphClassSecond, $strThisGraphClass);
					$strDataToDisplay=GraphValue($value1, $intMaxVal, $graphwidth, 13, $strThisGraphClass, false);
					$strWidthSpecial=" width=\"" .  intval($graphwidth + 59). "\"";
					$strWidthSpecialOther=" width=\"50\"";
				}
				elseif ($key1=="password")
				{
					
					$strDataToDisplay=passworddisplay($value1);
				}
				else
				{
					$strDataToDisplay=trunchandler($value1, $intTruncSize);
				}
				$out.= "<td valign=\"top\"" . $strWidthSpecial . ">".   $strDataToDisplay  ."</td>\n";
				if ($strNameColumn==$key1)
				{
					$strPrettyName=trunchandler($value1, $intTruncSize);
				}
				$intFieldCount++;
			}
		}
		if($bwlShowCountRelated)
		{
			$countrelated=CountRelated($strDatabase, $strTable, $value[$strIDFieldName], $strIDFieldName, $tfrecords);
			$out.= "<td  valign=\"top\">\n";
			$out.= $countrelated;
			$out.= "</td>\n";
		}
		if ($bwlShowDelete)
			{
				$out.= "<td valign=\"top\">\n";
				$out.= "<a style=\"" . $strActionStyle . "\" onclick=\"javascript:return(confirm('Are you sure you want to delete " . $strTable . " number " . $value[$strIDFieldName] . "?'))\" href='" . qbuild($strPHP, $strDatabase, $strTable, "delete" . $modeaddition , $strIDFieldName, $value[$strIDFieldName]) . "&" . qpre . "displaytype=" . $displaytype  ."&" . qpre . "filterid=" . $intThisFilterID .  "&" . qpre . "column=" . $strSortColumn  . "&" . qpre . "direction=" . $strDirection . "&" . qpre . "rec=" . $intRecord . $keyserialized . "'>Delete</a>";
				//enabling the following line allows users to do a recursive delete of this row and all dependent rows in the DB.
				//$out.= " <a style=\"" . $strActionStyle . "\" onclick=\"javascript:return(confirm('Are you sure you want to delete " . $strTable . " number " . $value[$strIDFieldName] . " and ALL ITS ASSOCIATED ITEMS in the database?'))\" href='" . qbuild($strPHP, $strDatabase, $strTable, "superdelete", $strIDFieldName, $value[$strIDFieldName]) . "&" . qpre . "displaytype=" . $displaytype  ."&" . qpre . "filterid=" . $intThisFilterID .  "&" . qpre . "column=" . $strSortColumn  . "&" . qpre . "direction=" . $strDirection . "&" . qpre . "rec=" . $intRecord . $keyserialized . "'>XKill</a>";
				$out.= "</td>\n";
			}

		if ($bwlShowEdit)
		{
			$out.= "<td  valign=\"top\">\n";
			if ($bwlHandback)
			{
				$out.= "<a style=\"" . $strActionStyle . "\" href='javascript:handback(\"" .  $strTable . "\",\"" . $strIDFieldName . "\",\"" . $value[$strIDFieldName]  . "\",\"" .  $strPrettyName  . "\",\"" . $extraqsk . "\",\"" .  $extraqsv . "\")'>Select</a>";
			}
			else
			{
				$out.= "<a style=\"" . $strActionStyle . "\" href='" . qbuild($strPHP, $strDatabase, $strTable, "edit" . $modeaddition, $strIDFieldName, $value[$strIDFieldName])  . "&" . qpre . "displaytype=" . $displaytype  ."&" . qpre . "filterid=" . $intThisFilterID . "&" . qpre . "rec=" . $intRecord . "&" . qpre . "column=" . $strSortColumn  . "&" . qpre . "direction=" . $strDirection . $keyserialized . "'>Edit</a>";
			}

			
			$out.= "</td>\n";
			
			if ($ToolRecord!="")
			{
				//echo $ToolRecord["toolpage"] . "<br>";
				$out.= "<td>\n";
				$out.= "<a style=\"" . $strActionStyle . "\" href='" . qbuild(gracefuldecay($ToolRecord["toolpage"], $strPHP), $strDatabase, $strTable, "specificview", $strIDFieldName, $value[$strIDFieldName])  . "&" . qpre . "displaytype=" . $displaytype  . "&" . qpre . "rec=" . $intRecord . $keyserialized . "'>" . gracefuldecay($ToolRecord["integration_label"], "More..."). "</a>";
				$out.= "</td>\n";
			
			}
	 	}

		$out.= "</tr>\n";
	}
	if ($count>$intRecsPerPage)
	{
		$paginate="";
		$paginate.= "<tr name='sortavoid2'>\n";
		$paginate.= "<td colspan=\"" . intval(($intFieldCount)+2) . "\">\n";
		$paginate.=paginatelinks($count, $intRecsPerPage, $intRecord, $strPHP, qpre . "rec");
		$paginate.= "</td>\n";
		$paginate.= "</tr>\n";
		$out.=$paginate;
		//$out.=TableEncapsulate($paginate, false, "");
	}
	$preout="";
	if($bwlShowCountRelated)
	{
		$preout= "<script src=\"tf_tablesort.js\"><!-- --></script>";
	}
	$out=   $preout .TableEncapsulate($out, $bwlShowCountRelated, "100%");
	return $out;
}

function TableColumnHeader($strDatabase, $strTable, $strPHP, $strDirection, $strHeaderStyle,$strNewStyle, $strSortColumn, $strSearchString, $strSearchField, $intSearchType,  $intFieldLimitHi, $intFieldLimitLo, $strFieldConfig, $bwlSuppressHeaderLinks, $launcherfield="", $displaytype="", $intSpacerColumns=2, $intThisFilterID="",   $strFilterIDField, $strFilterTable, $bwlBrowseMode=false, $samplerecord="", $rsColumnInfo="", $bwlAlwaysAllowNewLink=false, $display_field_list="", $bwlShowCountRelated=false)
//provides a set of clickable headers for a display of table data. those clicks determine the sort order
//breaking this out into a separate function probably wasn't the wisest idea, but i had to get stuff out of DisplayDataTable
{
	$first=true;
	$out= "<form name=\"searchform\" action=\"" .  $strPHP . "\"><tr class=\"" . $strHeaderStyle . "\">\n";
	$strATag="a";
	$strATag2="x";
	$strOriginalTable= $strTable;//i have to store the original table so i have for later when i make the clickable column headings
	if ($intThisFilterID!="" )
	{
		$strTableLink = qbuild($strPHP, $strDatabase, $strTable, "view", $strIDFieldName, $value[$strIDFieldName])   . "&" . qpre . "displaytype=" . $displaytype;
	}
	
	$out.= adminbreadcrumb($bwlSuppressHeaderLinks,  $strDatabase, $strPHP . "?" . qpre . "db=" . $strDatabase,   $strTable,  $strTableLink);
	if ($displaytype!="")
	{
		$viewtypelabel=LookupName($strDatabase,tfpre . "browsetype","browsetype_id", $displaytype);
		$out.= "<span class=\"heading\">(" . $viewtypelabel . ")</span>";
	}
	if ($intThisFilterID!="")
	{
		$strFilterName = LookupName($strDatabase,$strFilterTable,$strFilterIDField, $intThisFilterID);
		$out.= " : <span class=\"heading\">" . $strFilterName . "</span>\n" ;
	}
	elseif ($displaytype!="")
	{
		$out.= " : <span class=\"heading\">select a " . $strFilterTable. "</span>" ;
	}
	$out2.= "</td>\n";
	$strSearch.= HiddenInputs(array("column"=>$strSortColumn, "table"=>$strTable,"table"=>$strTable,"db"=>$strDatabase,"filterid"=>$intThisFilterID,"direction"=>$strDirection,"displaytype"=>$displaytype,"mode"=>"view","launcherfield"=>$launcherfield));

	if ($strFilterTable!=""  && $intThisFilterID=="")//if we are in browser mode for a view, then from now on it's all about the picker table we passed in
	{
		$strTable=$strFilterTable;
	}
	$sql=conDB();
	
	//if there is no data in the table then we have to look at the table's description
	$arrDesc=$samplerecord;
	if(count($arrDesc)<1)
	{
		$arrDesc=GetFieldTypeArray($strDatabase, $strTable);
	}

	$out3="";
	if (!$bwlSuppressHeaderLinks  || $bwlAlwaysAllowNewLink)
	{
		//$out3.= "<td width=\"40\" colspan=\"2\" width=\"0\" align=\"right\" class=\"" . $strLabelStyle . "\">\n";
		$out3.= "<a href='" . qbuild($strPHP, $strDatabase, $strTable, "new".$modeaddition, "", "")  . "&" . qpre . "displaytype=" . $displaytype  . "&" . qpre . "filterid=" . $intThisFilterID . "'>New <b>" .  forceSingular($strTable) . "</b></a>";
		//$out3.= "</td>\n";
	}
 
 
	$out2.="<tr name='sortavoid'>\n";
	$strDirection=ReverseDirectionSQL($strDirection);
	$strSearch.="<nobr><span class=\"tf_search\"><input name=\"" . qpre . "searchstring\" size=\"10\" type=\"text\" value=\"" . $strSearchString . "\">\n";
	$strConfig="0|at the beginning of-1|within-2|at the end of-3|as";
	//GenericDataPulldown($strConfig, $intIDField, $intLabelField, $strQueryVariableName, $strDefault, $strPHP, $strFormName, $strConnector ="?", $bwlAcceptWild=true, $strEmptyText="-none-", $rowdelimiter="-", $fielddelimiter="|", $strExtraValPairs="")
	$strSearch.=  GenericDataPulldown($strConfig,0, 1, qpre . "searchtype", $intSearchType, "", "",  "?", true, "-none-", "-", "|", "class='searchselect'");
	$strSearch.=   " the ";
	$strSearch.="<select name=\"" . qpre . "searchfield\" class=\"searchselect\">\n";
	$intFieldCount=0;
	$strLinkBasis=qbuild($strPHP, $strDatabase, $strOriginalTable, "view", $strIDFieldName, $value[$strIDFieldName]) . "&" . qpre . "displaytype=" . $displaytype   . "&" . qpre . "filterid=" . $intThisFilterID . "&" . qpre . "launcherfield=" . $launcherfield . "&" . qpre . "direction=" . $strDirection . "&" . qpre . "column=";
	foreach ($arrDesc as $name=>$info)
		{
 			//xx
			//$name=$that;  
			$bwlForceHide=false;
			foreach($rsColumnInfo as $irecord)
			{
				if($irecord["column_name"]==$name && $irecord["invisible"]==1)
				{
					$bwlForceHide=true;
				
				}
			}
			$strSel="";	
			if (GreaterFieldDisplayLogic($strTable, $strFieldConfig, $name, $intFieldCount, $intFieldLimitLo, $intFieldLimitHi, $display_field_list)  && !$bwlForceHide  || ($strSearchField==$name))
			{

				$out2.="<td>\n";
				if ($name==$strSearchField)
				{
					$strSel=" selected";
				}
				$strSearch.="<option" . $strSel . ">" . $name . "</option>\n";
				$displayname=$name;
				//if the field is called simply "name" then the table is a more useful description
				//if ($name=="name")
				//{
					//$displayname=$strTable;
				//}
				$out2.="<a href=\"". $strLinkBasis . $name . "\">" . $displayname . "</a>\n";
				$out2.="</td>\n";
				$intFieldCount++;
			}
			else
			{
				$strSearch.="<option" . $strSel . ">" . $name . "</option>\n";
			
			}
		}
	$strSearch.="</select>\n field\n: <input class=\"btn\"
   onmouseover=\"this.className='btn btnhov'\" onmouseout=\"this.className='btn'\" name=\"" . qpre . "searchbutton\" value=\"search\" type=\"submit\"></span></nobr>\n";

	//for ($i=$intSpacerColumns; $i<0; $i--)
	//{
		//$out2.="<td width=\"20\">&nbsp;</td>";
	//}
	if($bwlShowCountRelated)
	{
		//$out2.="<td><a href=\"" . $strLinkBasis . qpre . "related\">related rows</td>";
		$out2.="<td><a href=\"javascript: SortTable('idsorttable', " . $intFieldCount . ")\">related rows</a></td>
";
	}
	$out2.="<td width=\"80\" colspan=\"" . $intSpacerColumns . "\" align=\"right\" class=\"" . $strNewStyle . "\">" . $out3 . "</td>";
	if ($intThisFilterID=="")
	{
		$out=$out.$strSearch . $out2;
	}
	else
	{
		$out=$out. $out2;
	}
	return($out);
}

function GraphValue($intVal, $intMax, $intFullWidth, $intHeight, $strClass, $bwlFormat="", $intTotal=1)
{
	//im going to assume the existence of a spacer gif called spacer.gif in the images directory
	$intVal=intval($intVal);
	$intRenderLength=intval(($intVal/$intMax) *$intFullWidth);
	
	$out.= "<tr>\n";
	$out.= "<td width=\"54\" align=\"right\" class=\"graphlabel\">\n";
	if ($bwlFormat=="percent")
	{
		$out.= intval(100* ($intVal/$intTotal)) . "%";
	}
	else if ($bwlFormat=="")
	{
		$out.= $intVal;
	}
	$out.= "</td>\n";
	$out.= "<td  align=\"right\">\n";
	$out.= "&nbsp;";
	$out.= "</td>\n";
	$out.= "<td class=\"" . $strClass . "\">\n";
	$out.= SpacerGif($intRenderLength, $intHeight);
	$out.= "</td>\n";
	$out.= "</tr>\n";
	$out= TableEncapsulate($out, false, "", "","0", "0", "0");
	return $out;
}

function BrowseExtraTool($strDatabase, $strTable, $browsetype_id=7)
{
	$strTFTable=tfpre . "browsescheme";
	if (TableExists($strDatabase, $strTFTable))
	{
		$sql=conDB();
		$strSQL="SELECT * FROM " . $strDatabase . "." . $strTFTable . " WHERE table_name='" . $strTable . "' AND browsetype_id=" . intval($browsetype_id);
		//echo $strSQL . "<br>";
		$records = $sql->query($strSQL); 
		$record=$records[0];
		//$url=$record["toolpage"];
		return $record;
	}
	return false;
}


function DetermineVersion()
{
//comes back with a version numbers for admin scripts based on mod dates
//the base version is set as the first items in $versionconfig, corresponding to the timestamp of the mod date, the second items
//this base is added to the results of some wacky math designed to keep the calculated version after that base timestamp low.
//the result versions (to be added to the base) tend to be smaller than "0.001" unless the file is very much beyond the base timestamp for that version.
//this system will automatically scan through the list of files given in the ddl called $strConfig, labeling them with the second fields in that ddl.
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$releaseinfo="";
	$releaseinfo.="<p/>This comprehensive web-based MySQL visualization tool is released  under the GNU General Public License.  Info about this license is available here: <a href='http://www.gnu.org/copyleft/gpl.html' target='this'>http://www.gnu.org/copyleft/gpl.html</a>.  If you are unable or unwilling to abide by the terms of this license you probably should not be here.";
	$releaseinfo.="<p/>Judas Gutenberg can be reached through his website, <a href='http://asecular.com' target='asecu'>asecular.com</a>.";
	$releaseinfo.="<p/><strong>Features for Version 1.1:</strong> Compound PK support, CSV import, Full-DB search, DHTML display sorts, Serialized data editor, Xcart integration, Improved Foreign Key scanner.";
	$releaseinfo.="<p/><strong>Features for Version 1.2:</strong> Interactive graphical table map, Configurable SQL import/export, Table-to-table copy, Database state analyzer, Database field name search, Relation-following ID range delete.";
	$strConfig="tf.php|Tableform-tf_functions_core.php|Core function library-tf.js|Core javascript  library-tf_table_maker.php|Tablemaker-tf_tablemaker.js|Tablemaker javascript-tf_save_form.php|Tableform saver library-tf_dbtools.php|Database tools-tf_dump.php|CSV tools-tf_functions_backup.php|Backup functions-tf_functions_frontend_db.php|Frontend db functions-tf_generic_user_functions.php|Generic user functions";
	$versionconfig="0.5|1182650153-1|1191945058-1.1|1196911057-1.2|1228931859-1.21|1233755567-1.22|1265291598 ";
	$date=filemtime("tf_functions_core.php");
	$datearray=getdate($date);
	$thisyear=$datearray["year"];
	$previousversion="0.5";
	$arrVersions=explode("-", $versionconfig);
	$thismonth=str_pad($datearray["month"], 2, "0", STR_PAD_LEFT);
	$thisday=str_pad($datearray["mday"], 2, "0", STR_PAD_LEFT);
	//$thishour=str_pad($datearray["hours"], 2, "0", STR_PAD_LEFT);
	//$thisminute=str_pad($datearray["minutes"], 2, "0", STR_PAD_LEFT);
	//$thissecond=str_pad($datearray["seconds"], 2, "0", STR_PAD_LEFT);
	//$basis=intval($thisyear . $thismonth . $thisday);
	$out="";
	$out.="<tr><td class=\"heading\" colspan=\"2\">Tableform Database Tool</td></tr>\n";
	$out.="<tr class=\"bgclassother\"><td colspan=\"1\" >Engineering: Judas Gutenberg   </td><td>Project Management: Michael Chu </td></tr>\n";
	$out.="<tr class=\"bgclassline\"><td colspan=\"2\">&copy; January 2006-" . $thisday . " " .$thismonth . " ".  $thisyear . "</td></tr>\n";
	$arrConfig=explode("-", $strConfig);
	foreach($arrConfig as $thisConfig)
	{
		$arrData=explode("|", $thisConfig);
		$strFile=tf_dir . $arrData[0];
		$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
		$out.="<tr class=\"" . $strThisBgClass . "\"><td>";
		if (file_exists($strFile))
		{
			$moddate=filemtime($strFile);
			//echo $moddate . "<BR>";
			for($i=0; $i<count($arrVersions); $i++)  
			{
				$thisversion=$arrVersions[$i];
	 
				$bwlWeHaveAnother=false;
				if($i<count($arrVersions)-1)
				{
					$arrnextVersionData=explode("|", $arrVersions[$i+1]);
					$bwlWeHaveAnother=true;
				}
				//echo $thisversion . "--<br>";
				$arrVersionData=explode("|", $thisversion);
				if($bwlWeHaveAnother)
				{
					//echo "*<br>";
					if (intval($arrVersionData[1])<intval($moddate)  && intval($arrnextVersionData[1])>intval($moddate))
					{
						$baseversion=$arrVersionData[0];
						$basemoddate=$arrVersionData[1];
						//echo $basemoddate . "++<br>";
						break;
					}
				}
				else
				{
					if (intval($arrVersionData[1])<intval($moddate))
					{
						$baseversion=$arrVersionData[0];
						$basemoddate=$arrVersionData[1];
						
						break;
						//echo $basemoddate . "&&<br>";
					}
					else
					{
						$baseversion=0;
						$basemoddate=1000650153;
						break;
					}
				
				}
			}
			//echo $moddate . "..." . $basemoddate . "---" . $baseversion . "<br>";
			$version= $baseversion + pow(($moddate - $basemoddate)/100000000000,.5);
			$out.= $arrData[1] . "</td><td>&nbsp; version: " . NanHandler(substr($version, 0, 8), $previousversion);// . " " . $moddate;
	
		}
		else
		{
			$out.= $arrData[1] . "</td><td>&nbsp; not present" ;
		
		}
		
		$out.="</td></tr>\n";
 	}
	$out.="<tr><td colspan=\"2\" class=\"bgclassline\">\n";
	$out.=$releaseinfo;
	$out.="</td></tr>\n";
	$out=TableEncapsulate($out);
	$out.="\n<p/><br>";
	
	return $out;
}



function DisplayDataForARow($strDatabase, $strTable, $strIDField, $strValDefault, $strPHP)
{
//a simple display-only dump of a row (derived from tableform)
//an improved method of doing this would take advantage of my FleshedOutFKSelect sql function
//this could use some trimming down
	$sql=conDB();
	$out="";
	$length=50;
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strOtherBgClass="bgclassother";
	$strThisBgClass=$strClassFirst;
	$intNestTable=0;
	$strNest=""; 
	if  ($strIDField=="")
	{
		$strIDField= PKLookup($strDatabase, $strTable);
	}
	
	 


	$descr=TableExplain($strDatabase, $strTable); 
 
	$out.= "<tr class=\"" . $strOtherBgClass . "\">\n";
	$out.= "<td colspan=\"" . intval(count($descr))  . "\">";
	$intDefaultWide=50;
 
	if (!contains($strConfigBehave, "noheader")  && !contains($strConfigBehave, "notopnav"))
	{
		if ($strConfigBehave!="closeclickrecycle")
			{
				
				$intDefaultWide=90;
				$secondarytoollable=$strDatabase;
				$closebutton="";
				$disablelink=false;
			}
			else
			{
				$secondarytoollable="Secondary Editor";
				$closebutton="  [<a href=\"tf_message.php\">close this tool</a>]";
				$disablelink=true;
			}

		$out.=adminbreadcrumb($disablelink,  $secondarytoollable, $strPHP . "?" . qpre . "db=" . $strDatabase,  $strTable, qbuild($strPHP, $strDatabase, $strTable, "view", "", "")) . $closebutton;
	}
	
	$out.= "</td>\n";
	$out.= "</tr>\n";
  
	$record="";
	if ($strValDefault!="")
	{
	
		$strSQL="SELECT * FROM " . $strDatabase . "." . $strTable . " WHERE " .  $strIDField . " = '" . $strValDefault . "'";
		//echo $strSQL;
		$records = $sql->query($strSQL);
		$record=$records[0];
		$strOtherButtonText="New " . forceSingular($strTable);
		$strButtonText="Save " . $strTable;
		
		$strMode=appendwordifnotthere($strMode, "save");
		
	}
	else
	{
		$strButtonText="Create " . $strTable;
		$strMode=appendwordifnotthere($strMode, "create");
	}
 	if ($strConfigBehave=="closeclickrecycle")
	{
		$strConfigBehave.="complete";
		
	}
 	$futurelabel="";
	$strFromMulti="";
	foreach ($descr as $nom=>$info)
		{
 				$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
				$strPickerLink="";
				$skip=false;
				$fieldlabel=$info["Field"];
				$name=$fieldlabel;
				
				$strDefault="";
				//$strType=$info["Type"];
				//echo $info["Type"] . "<br>";
				$strType=TypeParse($info["Type"], 0);
				$intLen=intval(TypeParse($info["Type"], 1));
				$length=$intLen;
				$bwlInvisible=false;
				$strPseudo="";
				//echo $strTable;
				$strMSQL="select * from " . $strDatabase . "." .  tfpre . "column_info WHERE table_name='" . $strTable . "' AND column_name='" . $name . "'"; 
				//echo $strMSQL. "<br>";
				$mrecords = $sql->query($strMSQL);
				//echo count($mrecords) . "<br>";
				if (count($mrecords)>0)
				{
					$mrecord=$mrecords[0];
					$fieldlabel=gracefuldecay($mrecord["label"], $fieldlabel);
					//echo $mrecord["invisible"]. " " . $mrecord["column_info_id"] . "<br>";
					if ($mrecord["invisible"]==1)
					{
						$bwlInvisible=true;
						 
					//echo "!" . "<br>";
					}
					if ($mrecord["data_from_multitable_relation"]==1)
					{
						 $strDefault="[multi-placeholder]";
						//echo $strFromMulti . "-";
					//echo "!" . "<br>";
					}
				}
				if (!$bwlInvisible)
				{
				
					$arrPseudo=RelationLookup($strDatabase, $strTable, $name, 3);
					//a pseudo-field is a "field" that is actually a formula in a field belonging to a parent table
					//it is found at this point only so it knows to display it after this field is displayed in another way
					if (count($arrPseudo)>0)
					{
						
						$strRTable=$arrPseudo[0];
						$strRField=$arrPseudo[1];
						$strIDFieldName = PKLookup($strDatabase, $strRTable);
						//in a pseudotable, what you get is a formula
						$strFormula=GenericDBLookup($strDatabase, $strRTable, $strIDFieldName, $arrRelationTemp[$strRTable], $strRField);
						if ($strFormula!="")
						{
							
							//a sample formula:
							//wordencode($strValDefault, 6, time());
							//echo  $strFormula;
							//echo $futureid . "*" .  $strValDefault;
							//$idtouse=gracefuldecay($futureid,  $strValDefault);
							$idtouse=$strValDefault;
							if ($idtouse>0)
							{
								$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
								$strFormula = str_replace("\$id", $idtouse, $strFormula);
								//echo $strFormula . "<br>";
								//echo wordencode(1, 6, 1);
								$strPseudoContent=   eval("return " .  $strFormula);
								//$strPseudoContent = wordencode($strValDefault, 6, time());
								//echo $futurelabel;
								$strPseudoLabel=gracefuldecay($futurelabel, $strTable) . " " . $strRField;
								
								$strPseudo.="<tr class=\"" .  $strThisBgClass . "\">\n";
								$strPseudo.="<td valign=\"top\">\n";
								$strPseudo.=$strPseudoLabel . "\n";
								$strPseudo.="</td>\n";
								$strPseudo.="<td class=\"heading\">\n";
								$strPseudo.=$strPseudoContent; 
								$strPseudo.="</td>\n";
								$strPseudo.="</tr>\n";
								$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
							}
						}
					
					}
					if (is_array($record))
					{
						//echo $record[0];
						//echo "!" . $info["Field"];
						$strDefault=$record[$info["Field"]];
						
						$strDefault=substr($strDefault, 0, strlen($strDefault));
						
						//i have a real problem with single quotes!!!
						$strDefault=deendquote($strDefault);
					
					}
					
					if ($strDefault=="")
					{
						if (array_key_exists($name, $_GET))
						{
							//echo "#" . $name . " " . $_GET[$name];
							$strDefault=$_GET[$name];
						}
					}
					$bwlHypLabel=false;
					
	
					
					if ($strType=="int")
					{
						$length=5;
						//echo $info["Key"];
	
						
						$arrMK=RelationLookup($strDatabase, $strTable, $name, 1);
						if (count($arrMK)>0)
						{
							$bwlHypLabel=true;
							//if we are dealing with a multi-table lookup, then things get really weird at that point.  
							//suddenly the row we're looking at becomes just the husk for a field in a totally different table
							//but first we need to know what that table is and what field it is.  we don't find that table directly;
							//we have to look it up using the arrFK we just retrieved
							//right all we now is that the primary key for that field in that other table is the integer in this field
							//and that the table and field containing the name of the distant table was just retrieved.
							

							
							//first:  that table
							$strRTable=$arrMK[0];
							$strRField=$arrMK[1];
							
							//get the primary key of the $strRTable that applies to this specific row
							//it actually will have probably been determined earlier (to put one of the dropdowns in the right spot)
							//at this point i assume that the pk of $strRTable is what we need
							
							if($strRTable== $strTable)//we're dealing with a "direct multi-table relation" where there is no "relation type" table; the table name of the type is right there with the data
							{
								$strDistantTable=$record[$strRField];
							}
							else
							{
								$strIDFieldName = PKLookup($strDatabase, $strRTable);
								$strDistantTable=GenericDBLookup($strDatabase, $strRTable, $strIDFieldName, $arrRelationTemp[$strRTable], $strRField);
							}
						
							//echo "=" . $strDistantTable . "=" ;
							
							$intDistantPK = PKLookup($strDatabase, $strDistantTable);
							$intNestTable++;
							$strNest.="|" . $intNestTable;
							//just for shits im gonna get all recursive right now...
							//$out.= TableForm($strDatabase,$strDistantTable,$intDistantPK,  $strDefault, $strPHP,  "noheader noextra noform", "zzz|" . $intNestTable / . "|");
							//ok i chickened out
							$skip=true;
							$fieldlabel=$strDistantTable;
							//if i have a multi-table relation, chances are i'll want to use the name of the wild table and its pk somewhere later in the tool.
							$futurelabel=$strDistantTable;
							$futureid=$strDefault;
							//$fieldform=foreigntablepulldown($strDatabase,$strDistantTable, $intDistantPK, $strDefault, $strFieldNamePrefix .$name, $strFromMulti, true);
							$fieldform=LookupName($strDatabase, $strDistantTable, $intDistantPK, $strDefault);
							$strFieldLabelLink=qbuild($strPHP, $strDatabase, $strDistantTable, "edit", $intDistantPK, $strDefault). "&" . qpre . "behave=closeclickrecycle";
								
						}
						$arrFK=RelationLookup($strDatabase, $strTable, $name,0);
						//echo $arrFK[0] . " " . $arrFK[1] . " " .  $name .  "<br>";
						if (count($arrFK)>0)
						{
							$bwlHypLabel=true;
							//i capture this info in case i need it later for a MultiTable lookup
						
					 		$arrRelationTemp[$arrFK[0]]=$strDefault;
							$skip=true;
							//echo $strDefault;
							$count = countrecords($strDatabase,$arrFK[0]);
							//if $count <101 do a dropdown for a foreign key.  otherwise slap down a link to a searchable picker
							//because i'm all cool like that
			 
							if ($count<101)
							{
								$fieldlabel=ReturnNonIDPartOfName($fieldlabel);
								$fieldform=LookupName($strDatabase, $arrFK[0], $arrFK[1], $strDefault);
								//$fieldform=foreigntablepulldown($strDatabase,$arrFK[0], $arrFK[1], $strDefault, $strFieldNamePrefix .$name);
						 
							}
							else
							{
								$skip=false;
								$length =5;
								//$strPrettyLabelField=firstnonidcolumname($strDatabase, $arrFK[0]);
								$strPickerLabel=LabelForID($strDatabase, $arrFK[0], $arrFK[1], $strDefault,$arrFK[4]);
								$strPickerLink= "<input style=\"font-size:9px; border:0px;\" class=\"" . $strThisBgClass . "\" type=\"text\" name=\"" . $strFieldNamePrefix .  qpre . "a|" .  $name . "\" size=\"20\" value=\"" . deescape($strPickerLabel)  . "\">\n";
								$strPickerLink.=" [<a href=\"#\" onclick=\"pickerwindow('". $strDatabase . "','" . $arrFK[0] . "','".  $strFieldNamePrefix . $name ."')\">browse</a>]\n";
								
							}
							//$fieldlabel=$info["foreign"]; //for foreign keys with dropdowns, label them with table name
							//add a link to an editor for the foreign key label because i'm all cool like that
							
							$strFieldLabelLink= qbuild($strPHP, $strDatabase, $arrFK[0], "edit", $arrFK[1], $strDefault) . "&" . qpre . "behave=closeclickrecycle";

						}
						if ($bwlHypLabel==true)
						{
							if (!contains($strConfigBehave,"complete"))
							{
								$fieldlabel="<a target=\"secondarytool\" href=\"". $strFieldLabelLink . "\">" . $fieldlabel . "</a>\n";
							}
							else
							{
								$fieldlabel="<a onclick=\"javascript:return(popdetachedwindow('" . $strFieldLabelLink . "','300','500'))\">" . $fieldlabel . "</a>\n";
							}
						}
					}


				elseif ((($strType=="tinyint" && !contains($name, "_id")  || $arrForce_binary[$nameforhelp]) || $strType=="bit") && !$arrForce_text_input[$nameforhelp]  &&  !(abs(intval($strDefault))>1))
				{
					
					$skip=true;
					//checked
					$fieldform=boolcheck($strFieldNamePrefix . $name, $strDefault, "", true);
				}
				else 
				{
					$length=intval($length * ($intDefaultWide/90));
				}
				//($v["Extra"]=="auto_increment")
				if ($info["Extra"]!="auto_increment"  && !$skip)
				//if ($info["Key"]=="PRI" && !$skip)
				{
					$strFormType="text";
					
					if ($name=="password")
					{
						$fieldform=passworddisplay($strDefault);
					}
		 
					else
					{
						$fieldform="";
						$strAboveForm="";
						$strValString=forinputform($strDefault)  ;
						//i determine whether or not we make this form item an upload based entirely on its field name, not its type,
						//as in, does the field name contain either the string "filename" or "banner" 
						//(alter the NeedsUpload function to change this behavior)
				
						if (NeedsUpload($name))
						{	
							$path=fieldNameToFolderPath($strFieldNamePrefix . $name, tf_dir . imagepath) . $strDefault;
							
							$ahtml="";
							$slasha="";
							
							if (tf_file_exists($path))
							{
								$ahtml="<a href=\"#\" onclick=\"popwindow('" . $path . "', '" . 200 . "', '" . 500 . "','picwindow'); \">";
								$slasha="</a>";
							}
							$fieldform=   PictureIfThere($path, "100") . "\n";
							$length=intval($length*.5);
				 
					 		$strAboveForm="&nbsp;&nbsp;&nbsp;" . $ahtml . $strDefault . $slasha . "<br>";
							$name=$strFieldNamePrefix . qpre . "u|" . $name;
							$strValString="";
						}
						$fieldform=$strAboveForm  . " " . deescape($strValString)   . $fieldform . $strPickerLink;
					}
				}
			
				elseif ($info["Extra"]=="auto_increment"  && $strValDefault=="")
				{
					$fieldform="&nbsp;&nbsp;&nbsp;<strong>autoincrement:</strong> \n";
				}
				elseif ($info["Extra"]=="auto_increment" && $strValDefault!="")
				{
					$fieldform="&nbsp;&nbsp;&nbsp;<strong>" .  $strValDefault. "</strong> \n";
				}
				
				$out.="<tr class=\"" .  $strThisBgClass . "\">\n";
				$out.="<td valign=\"top\">\n";
				$out.=$fieldlabel . "\n";
				$out.="</td>\n";
				$out.="<td>\n";
				$out.=$fieldform ; 
				$out.="</td>\n";
				$out.="</tr>\n";
				$out.=$strPseudo;
				if ($strPseudo!="")
				{
					$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
				}
			 
			}
	}
	$out.="<tr>\n<td colspan=2 align=\"right\">\n";
	$out.="</td>\n</tr>\n";
	$out=TableEncapsulate($out, false);
	$out.="\n<p>";
	if(!contains($strConfigBehave, "notopnav"))
	{
		$out.="<a target=\"_new\" href=\"" . qbuild($strPHP, $strDatabase, $strTable, "edit", $strIDField, $strValDefault) . "\">Edit this " . $strTable . " and <em>its</em> Associated Items</a> starting in a new window.</a>";
	}
	return $out;
}

function tablebrowser($strDatabase, $strPHP, $strUser)
//shows all the tables in $strDatabase
{
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strOtherBgClass="bgclassother";
	$strLineClass="bgclassline";
	$strThisBgClass=$strClassFirst;
	$bwlViewsPossible=  TableExists($strDatabase,  tfpre . "browsescheme");
	$sql=conDB();
	//$tables = $sql->showtables(array("db" => $strDatabase)); 
	$bwlSuperAdmin=IsSuperAdmin($strDatabase, $strUser);
	if (IsSuperuser($strDatabase,  $strUser)  || $bwlSuperAdmin)
	{
		$tables=TableList($strDatabase);
	}
	else
	{
		$intAdminID=GetAdminID($strDatabase, $strUser);
		//echo "SELECT table_name AS " . "Tables_in_" . $strDatabase . " from " .  $strDatabase . ".permission  WHERE admin_id=" .  $intAdminID ;
		$strSQL="SELECT table_name AS " . "Tables_in_" . $strDatabase . " from " .  $strDatabase . "." . tfpre . "permission WHERE admin_id=" .  $intAdminID . " ORDER BY table_name ASC "; 
		$tables = $sql->query($strSQL);
	
	}
	//echo $strSQL;
	//echo sql_error();
	//asort($tables);
	$preout="";
	$out="";
	$preout.= adminbreadcrumb(false,  $strDatabase, "",  "tables", "") ;
	//$out.= AdminNav($bwlSuperAdmin);
	$preout.= "\n<script src=\"" . tf_dir . "tf_tablesort.js\"><!-- --></script>\n";
	//$out.= "</td></tr>\n";
	
	$out.=htmlrow("bgclassline", "<a href=\"javascript: SortTable('idsorttable', 0)\">table</a>", "<a href=\"javascript: SortTable('idsorttable', 1)\">records</a>",  "<a href=\"javascript: SortTable('idsorttable', 2)\">columns</a>", "other views", "&nbsp;", "&nbsp;" , "&nbsp;", "&nbsp;");

	//echo "-" . count($tables) . "-" ;
	$strFieldName="Tables_in_" . str_replace("`", "", $strDatabase);
	//echo $strFieldName;
	$bwlTableMakerExists=file_exists("tf_table_maker.php");
	foreach ( $tables as  $k=>$v )
	{
		
		$tablename=$v[$strFieldName];
		$bwlBeginsWithTF=beginswith($tablename,  tfpre );
		if (($bwlBeginsWithTF &&  $bwlSuperAdmin) || !$bwlBeginsWithTF)
		{
			//echo $k;
			$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
			$count = countrecords($strDatabase , $tablename );
			if ($bwlViewsPossible)
			{
				$otherviews=ListViews($strDatabase , $tablename, $strPHP);
			}
			if ($bwlSuperAdmin  && $bwlTableMakerExists)
			{
				$tablemakerlink= "[<a href=\"" . qbuild("tf_table_maker.php", $strDatabase, $tablename , "", "", "") . "\">edit def.</a>]";
			}
			else
			{
				$tablemakerlink= "&nbsp;";
			}
			$fieldcount=FieldCount($strDatabase, $tablename);
			$out.=htmlrow(
				$strThisBgClass,
				"<a href=\"" . qbuild($strPHP, $strDatabase, $tablename , "view", "", "") . "\">" . $tablename . "</a>",
				$count,
				$fieldcount,
				$otherviews, 
				$tablemakerlink,
				"[<a href=\"" . qbuild("tf_dump.php", $strDatabase, $tablename , "", "", "") . "\">export</a>]",
				"[<a href=\"" . qbuild("tf_import.php", $strDatabase, $tablename , "", "", "") . "\">import</a>]",
				"[<a href=\"" . qbuild("tf.php", $strDatabase, $tablename , "columnanalysis", "", "") . "\">analysis</a>]"
 			);
		}
	}
	$out=$preout. TableEncapsulate($out);
	return $out;
}

function ListViews($strDatabase , $strTable, $strPHP)
{
	
	$sql=conDB();
	$strSQL="SELECT * FROM " . $strDatabase . "." .  tfpre . "browsescheme b JOIN " . $strDatabase . "." .  tfpre . "browsetype t ON b.browsetype_id=t.browsetype_id WHERE b.table_name='" . $strTable . "'";
	//echo $strSQL . "<br>";
	$records = $sql->query($strSQL); 
	foreach($records as $record)
	{
		$toolpage=$record["toolpage"];
		//echo $toolpage . "<br>";
		if ($record["browsetype_id"]==7 && $toolpage!=""  && file_exists($toolpage))
		{
			//if we have a browser of type 7 then just link directly to the tool with the params we know about
			$out.= " <a href=\"" . qbuild($toolpage, $strDatabase, $strTable , "view", "", "") . "&" . qpre . "displaytype=" . $record["browsetype_id"] . "\">" .  pluralize($strTable) . "</a>\n";
		}
		else
		{
			$out.= " <a href=\"" . qbuild($strPHP, $strDatabase, $strTable , "view", "", "") . "&" . qpre . "displaytype=" . $record["browsetype_id"] . "\">" . $record["name"] . "</a>\n";
		}
	
	}
	return $out;

}

function TableForm($strDatabase, $strTable, $strIDField, $strValDefault, $strPHP,  $strConfigBehave="", $strFieldNamePrefix="", $strUser="",  $arrPK="", $strDisplayMode="", $strKosherFields="", $breadcrumboverride="")
{
 
//a generic form generator that looks at the table's description in the db and then dynamically builds an editor form
	$sql=conDB();
 
	
	$out="";
	$preout="";
	$strValidationJS="";
	$width=50;
	$bwlSkipHiddenIDvalue=false;
	//the following two lines apply when there is integration with wysiwygpro
	$editorcount=0;
	$editor=Array();
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strOtherBgClass="bgclassother";
	$strLineClass="bgclassline";
	$strThisBgClass=$strClassFirst;
	$noshowfields=$_REQUEST[qpre . "noshow"];


	//the following 4 lines are sort of a hack to enable the form to return to the right page in the pagination when finished
	$strMode=$_GET[qpre . "mode"];
	$intRecord=$_GET[qpre . "rec"];
	$strSort=$_GET[qpre . "column"];
	$strDirection=$_GET[qpre . "direction"];
	$strBackfield=$_GET[qpre . "backfield"];
 	$arrHelpText=Array();
	$arrPrettyName=Array();
	$arrValidationType=Array();
	$arrValidationPattern=Array();
	$arrWidth=Array();
	$arrHeight=Array();
	$arrIsPassword=Array();
	$arrIsFileUpload=Array();
	$arrForce_no_wysiwg=Array();
	$arrForce_wysiwg=Array();
	$arrForce_text_input=Array();
	$arrForce_binary=Array();
	$intNestTable=0;
	$strNest=""; 
	$needtoencrypt="";
	$bwlSuperAdmin=IsSuperAdmin($strDatabase, $strUser);
	$bwlFoundLabel=false;
	
	//for at the bottom just above the submit buttons:  certain kinds of relation-based editors can be integrated with this one using tf_relation 
	$strRelationSQL="SELECT * FROM " . tfpre . "relation WHERE f_table_name='" .$strTable . "'";
	 
	$relationalrecords=$sql->query($strRelationSQL);
	
	
	if(TableExists($strDatabase, "language")  &&  $strTable!="translation")
	{
		$languagerecords=$sql->query("SELECT * FROM " . $strDatabase . ".language", $connectiontype);
	}
	else
	{
		$languagerecords=Array(Array("language_name"=>"eng", "language_id"=>1));
	}
	
	if($bwlSuperAdmin)
	{
	//echo "!";
	}
	if($strIDField=="")
	{
		$strIDField=PKLookup($strDatabase, $strTable);
	}
	$typeofIDField=TypeParse(GetFieldType($strDatabase, $strTable, $strIDField),0);
	//i'm not proud of this, but it allows me to pass in a human-readable id string and then just parse off the id at the end
	if(contains($typeofIDField, "int")  && !is_numeric($strValDefault))
	{
		if(contains($strValDefault, ":"))
		{
			$arrValDefault=explode(":", $strValDefault);
			{
				$strValDefault=$arrValDefault[1];
			}
		}
	}
	if(contains($strIDField, " ")   && !is_array($arrPK))
	{
			//echo "<p>&&&" . $strIDField ."&&&<br>";
		$arrPK=ArraySubsetFromList($strIDField, "");
	}
	$intDefaultWide=60;//changed from '50' jan 29 2009
 	
	if (!contains($strConfigBehave, "noheader")  && !contains($strConfigBehave, "notopnav"))
	{
		if (!contains($strConfigBehave,"closeclickrecycle"))
		{
			//$preout.=AdminNav($bwlSuperAdmin);
			$intDefaultWide=90;
			$secondarytoollable=$strDatabase;
			$closebutton=" <a href=\"javascript: changetableeditorcollapse()\">+/-</a>";
			$disablelink=false;
		}
		else
		{
			$secondarytoollable="Secondary Editor";
			$closebutton="  [<a href=\"tf_message.php\">close this tool</a>]";
			$disablelink=true;
		}
 		$strDBLink=$strPHP . "?" . qpre . "db=" . $strDatabase;
		if(contains($strConfigBehave, "nolink"))
		{
			$disablelink=true;
		}
		if(contains($strConfigBehave, "nodblink"))
		{
			$strDBLink=""; 
		}
		if($breadcrumboverride=="")
		{
			$preout.=adminbreadcrumb($disablelink,  $secondarytoollable, $strDBLink,  $strTable, qbuild($strPHP, $strDatabase, $strTable, "view", "", "")) . $closebutton;
		}
		else
		{
			$preout.=$breadcrumboverride;
		}
		
	}

	if (!contains($strConfigBehave, "noform"))
	{
		$out.="<form enctype=\"multipart/form-data\" name=\"BForm\" method=\"post\" action=\"" . $strPHP . "\" onSubmit=\" return validate_form();\">\n";
	}

	$out.= "<input type=\"hidden\" name=\"" . $strFieldNamePrefix . "MAX_FILE_SIZE\" value=\"12000000\" />\n";
	$descr=TableExplain($strDatabase, $strTable, false); 
	 
	$record="";
	if ($strValDefault!=""  || $arrPK!="")
	{
		if($arrPK!="")
		{
			$strSQL="SELECT * FROM " . $strDatabase . "." . $strTable . " WHERE " . ArrayToWhereClause($arrPK);
		}
		else
		{
			$strSQL="SELECT * FROM " . $strDatabase . "." . $strTable . " WHERE " .  $strIDField . " = '" . $strValDefault . "'";
		}
		//echo $strSQL;
		$records = $sql->query($strSQL);
		//echo "-" . count($records) . "-";
		$record=$records[0];
		$strOtherButtonText="New " . forceSingular($strTable);
		$strButtonText="Save " . forceSingular($strTable);
		
		$strMode=appendwordifnotthere($strMode, "save", "edit");
		
	}
	else
	{
		$strButtonText="Create " . forceSingular($strTable);
		$strMode=appendwordifnotthere($strMode, "create", "edit");
	}
 	if (contains($strConfigBehave,"closeclickrecycle"))
	{
		$strConfigBehave.="complete";
		
	}
	//echo $strSQL;
 	$futurelabel="";
	$strFromMulti="";
	$strTableLookingOutWith="";
	//echo count($descr);
	foreach ($descr as $nom=>$info)
		{
		
			//echo $nom . " " . $info . "<br>";
			$bwlPasswordObfuscationOverride=false;
			$strPickerLink="";
			
			$skip=false; //skip means the form was handled by some other code, so don't do a standard input
			$fieldlabel=$info["Field"];
			$name=$fieldlabel;
			$idforlabel="idl-" . $name;
			$nameforhelp=$name;
			if(!inList($noshowfields, $name)  && $strKosherFields==""   || inList($strKosherFields, $name))
			{
			
				$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
				$strDefault="";
				$strType=TypeParse($info["Type"], 0);
				$intLen=intval(TypeParse($info["Type"], 1));
				$width=$intLen;
				$bwlInvisible=false;
				$strPseudo="";
				$strMSQL="select * from " . $strDatabase . "." .  tfpre . "column_info WHERE table_name='" . $strTable . "' AND column_name='" . $name . "'"; 
				//echo $strMSQL . "<P>";
				$mrecords = $sql->query($strMSQL);
				if (count($mrecords)>0)
				{
					$mrecord=$mrecords[0];
					$fieldlabel=gracefuldecay($mrecord["label"], $fieldlabel);
					$helptext=$mrecord["help_text"];
					$arrValidationType[$nameforhelp]=$mrecord["validation_type_id"];
					
					$arrWidth[$nameforhelp]=$mrecord["width"];;
					$arrHeight[$nameforhelp]=$mrecord["height"];
					$arrIsPassword[$nameforhelp]=$mrecord["password"];
					$arrIsFileUpload[$nameforhelp]=$mrecord["fileupload"];
					$arrIsDateCreated[$nameforhelp]=$mrecord["datecreated"];
					$arrIsDateModified[$nameforhelp]=$mrecord["datemodified"];
					$arrForce_wysiwg[$nameforhelp]=$mrecord["force_wysiwg"];
					$arrForce_no_wysiwg[$nameforhelp]=$mrecord["force_no_wysiwg"];
					$arrForce_binary[$nameforhelp]=$mrecord["force_binary"];
					$arrForce_text_input[$nameforhelp]=$mrecord["force_text_input"];
					//echo "*" .  $mrecord["force_binary"] . "*<br>" ;
					//echo "*" .  $mrecord["force_text_input"] . "*<br>" ;
	
					$arrValidationPattern[$nameforhelp]=GenericDBLookup($strDatabase,  tfpre . "validation_pattern",  "validation_pattern_id",$mrecord["validation_pattern_id"], "pattern");
					$arrHelpText[$nameforhelp]=$helptext;
					$arrPrettyName[$nameforhelp]=$fieldlabel;
					if ($mrecord["invisible"]==1)
					{
						$bwlInvisible=true;
					}
					if ($mrecord["data_from_multitable_relation"]==1)
					{
						 $strDefault="[multi-placeholder]";
					}
				}
			
				if ($bwlInvisible)
				{
					$out.="<input type=\"hidden\" name=\"" .$strFieldNamePrefix . $name . "\"   value=\"".  $strDefault . "\">\n";
				}
				else
				{

					$arrPseudo=RelationLookup($strDatabase, $strTable, $name, 3);
					//a pseudo-field is a "field" that is actually a formula in a field belonging to a parent table
					//it is found at this point only so it knows to display it after this field is displayed in another way
					if (count($arrPseudo)>0)
					{
						
						$strRTable=$arrPseudo[0];
						$strRField=$arrPseudo[1];
						$strIDFieldName = PKLookup($strDatabase, $strRTable);
						//in a pseudotable, what you get is a formula
						$strFormula=GenericDBLookup($strDatabase, $strRTable, $strIDFieldName, $arrRelationTemp[$strRTable], $strRField);
						if ($strFormula!="")
						{
							
							//a sample formula:
							//wordencode($strValDefault, 6, time());
							//$idtouse=gracefuldecay($futureid,  $strValDefault);
							$idtouse=$strValDefault;
							if ($idtouse>0)
							{
								$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
								$strFormula = str_replace("\$id", $idtouse, $strFormula);
								$strPseudoContent=   eval("return " .  $strFormula);
								$strPseudoLabel=gracefuldecay($futurelabel, $strTable) . " " . $strRField;
								$strPseudo.="<tr class=\"" .  $strThisBgClass . "\">\n";
								$strPseudo.="<td valign=\"top\">\n";
								$strPseudo.=$strPseudoLabel . "\n";
								$strPseudo.="</td>\n";
								$strPseudo.="<td class=\"heading\">\n";
								$strPseudo.=$strPseudoContent; 
								$strPseudo.="</td>\n";
								$strPseudo.="</tr>\n";
								$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
							}
						}
					
					}
					//echo $info["Field"] . " " . is_array($record) . "<BR>";
					if (is_array($record))
					{
						$strDefault=$record[$info["Field"]];
						
						$strDefault=substr($strDefault, 0, strlen($strDefault));
						
						//i have a real problem with single quotes!!!
						$strDefault=deendquote($strDefault);
					}
					$strDefault=gracefuldecay($_GET[$name], $strDefault);
					$bwlHypLabel=false;
					if(strlen($strDefault)>32)//maybe 34
					{
						if(contains($strDefault, "-") && !contains(trim($strDefault), " "))
						{
							if(function_exists(xcartpwdencrypt))
							{
								$strDefault=xcartpwddecrypt($strDefault);
								$needtoencrypt.= " " . $name;
							}
						
						}
					
					}
					if($strDefault!=""  && (!$bwlFoundLabel || is_numeric($strRowLabel))  && (contains($strType, "char")  || contains($strType, "text"))  ) //i allow it to overwrite a found label if it's numeric and a non-numeric comes along
					{
						$bwlFoundLabel=true;
						$strRowLabel=$strDefault;
					}
					//a good place to put various data-type editors
					if(probableserialized($strDefault))
					{
						//SerializeExpand($strDatabase, $stTable, $strIDField, $strID, $strPHP)
						//$fieldform=$strDefault . "<br/>";
						$fieldform= SerializeForm($strDefault, qpre . "serialized|" . $name, $strThisBgClass);
						$skip=true; //here we skip because we use SerializeForm to make this part of the form
					}
					else if (inlist("bigint mediumint int smallint tinyint", $strType))
					{
						$width=5;
						//return array( $record["f_table_name"],  $record["f_column_name"])
						$arrMK=RelationLookup($strDatabase, $strTable, $name, 1);
						//echo $strTable . "-" . $name . "<br>";
						if (count($arrMK)>0)
						{
							$bwlHypLabel=true;
							//if we are dealing with a multi-table lookup, then things get really weird at that point.  
							//suddenly the row we're looking at becomes just the husk for a field in a totally different table
							//but first we need to know what that table is and what field it is.  we don't find that table directly;
							//we have to look it up using the arrFK we just retrieved
							//right all we now is that the primary key for that field in that other table is the integer in this field
							//and that the table and field containing the name of the distant table was just retrieved.
							
							
							//WHEN TO SET UP A MULTI-TABLE RELATIONSHIP
							//When you have a relationship in one of your tables (we'll call it the "start" table) in which 
							//	the content of a column determines the table that the value in another column is an FK for.  
							//	Essentially, in a multitable relationship, one column indicates the foreign table and another 
							//	contains the value of foreign PKs.
							//HOW TO SET UP A MULTI-TABLE RELATIONSHIP
							//1.  Pick a column in your "start" table whose content will determine the foreign table.  
							//	Typically the name of such a column contains the word "type" and typically it is made to 
							//	hold an integer that is a foreign key to a table we are about to create
							//2. make a table foreign to the column you created in step 1.
							//3. In this new table, include a column to hold the name of a table.  
							//	If you give this column the name "table_name," TF will automatically give you a dropdown 
							//	of tablenames in the editor for populating it.
							//4. Add a conventional foreign key relationship in tf_relation for the table created in #2
							//5. Pick a column in your "start" table whose content will be a PK of some foreign table.
							//6. Add a multi-table relationship in tf_relation.  
							//	table_name is the name of your "start" table, 
							//	column_name is the name of the column you just added for holding PKs of other foreign tables.  
							//	f_table_name is the name of the table created in step 2.  
							//	f_column_name is the name of the column created in step 3.
							
							//first:  that table
							$strRTable=$arrMK[0];
							$strRField=$arrMK[1];
							
							//get the primary key of the $strRTable that applies to this specific row
							//it actually will have probably been determined earlier (to put one of the dropdowns in the right spot)

							
							
							if($strRTable== $strTable)//we're dealing with a "direct multi-table relation" where there is no "relation type" table; the table name of the type is right there with the data
							{
								$strIDFieldName = $name;
								//echo $strRField;
								$strDistantTable=$record[$strRField];
							}
							else
							{
								//at this point i assume that the pk of $strRTable is what we need
								$strIDFieldName = PKLookup($strDatabase, $strRTable);
								$strDistantTable=GenericDBLookup($strDatabase, $strRTable, $strIDFieldName, $arrRelationTemp[$strRTable], $strRField);
							}
 							//echo $strDistantTable . "<br>";
							$intDistantPK = PKLookup($strDatabase, $strDistantTable);
							$intNestTable++;
							$strNest.="|" . $intNestTable;
							//just for shits im gonna get all recursive right now...
							//$out.= TableForm($strDatabase,$strDistantTable,$intDistantPK,  $strDefault, $strPHP,  "noheader noextra noform", "zzz|" . $intNestTable / . "|");
							//okay, so i chickened out!  but i could have
							
							$skip=true;//here we skip because we have a dropdown
							$fieldlabel=gracefuldecay($strDistantTable, $fieldlabel);
							
							//if i have a multi-table relation, chances are i'll want to use the name of the wild table and its pk somewhere later in the tool.
							$futurelabel=$strDistantTable;
							$futureid=$strDefault;
							//2009 COMMENTARY: IT WOULD BE AWESOME IF THE FOLLOWING PULLDOWN COULD BE AJAX-altered BY THE PULLDOWN OF THE PRECEDING TYPE TABLE//UPDATE: DID IT!!!
							//id of select we need to add an event for: "id" . $strIDFieldName;
					 
							$fieldform=foreigntablepulldown($strDatabase,$strDistantTable, $intDistantPK, $strDefault, $strFieldNamePrefix .$name, $strFromMulti, true);
							// AddEventToSelect(selectid, db, table, selecttorepopulate)
					 
							$fieldform.="<script>AddMultitableEventToSelect('" ."id" . $strIDFieldName . "','" .$strDatabase . "','" .$strDistantTable . "','" . $name . "','" . $intDistantPK . "','','','" . $strRTable . "','" . $strIDFieldName . "','" . $strRField ."');</script>";
							//"<div id=\"idmultitablelabel\">"
							$idforlabel="idmultitablelabel";
							$strFieldLabelLink=  qbuild($strPHP, $strDatabase, $strDistantTable, "edit", $intDistantPK, $strDefault). "&" . qpre . "backfield=" . $nameforhelp . "&" . qpre . "behave=closeclickrecycle";
						}
						$arrFK=RelationLookup($strDatabase, $strTable, $name,0);
						if (count($arrFK)>0)
						{
						
							$bwlHypLabel=true;
							//i capture this info in case i need it later for a MultiTable lookup
							
					 		$arrRelationTemp[$arrFK[0]]=$strDefault;
							$skip=true; //here we skip because we have a dropdown
							$count = countrecords($strDatabase,$arrFK[0]);
							//if $count <101 do a dropdown for a foreign key.  otherwise slap down a link to a searchable picker
							//because i'm all cool like that
							//echo $name . " " . $strIDField . "<br>";
			 				if($name==$strIDField)
							{
								//added this code 10/17/2008 to deal with cases where the PK of our table is also an FK to another table
								$bwlSkipHiddenIDvalue=true;
							}
							if ($count<101)
							{
								$fieldlabel=ReturnNonIDPartOfName($fieldlabel);
								//bleh is necessary because it is by reference, but i have nothing i want to do with it
								//echo $strDatabase . " " . $arrFK[0] . " " . $arrFK[1];
								////foreigntablepulldown(our_db,  $thistablename, $thistablepk, $strThisDefault, $thislocalfieldname, $namereturn,  false, $thistablelabelfield, "", $whereclause);
								$fieldform=foreigntablepulldown($strDatabase,$arrFK[0], $arrFK[1], $strDefault, $strFieldNamePrefix .$name, $bleh, false, $arrFK[4]);
								//idl-
								$fieldform.="<script>AddLabelLinkUpdateToPulldown('" . $name  . "')</script>\n";
							}
							else
							{
								$skip=false; //don't skip because it's a regular input
								$width =5;
								//$strPrettyLabelField=firstnonidcolumname($strDatabase, $arrFK[0]);
								//LabelForID($strDatabase, $arrFK[0], $arrFK[1], $strDefault,$arrFK[4]);
								 
								$strPickerLabel=LabelForID($strDatabase, $arrFK[0], $arrFK[1], $strDefault,$arrFK[4]);
								$strPickerLink= "<input style=\"font-size:9px; border:0px;\" class=\"" . $strThisBgClass . "\" type=\"text\" name=\"" . $strFieldNamePrefix .  qpre . "a|" .  $name . "\" size=\"20\" value=\"" . deescape($strPickerLabel)  . "\">\n";
								$strPickerLink.=" [<a href=\"#\" onclick=\"pickerwindow('". $strDatabase . "','" . $arrFK[0] . "','".  $strFieldNamePrefix . $name ."')\">browse</a>]\n";
								
							}
							//$fieldlabel=$info["foreign"]; //for foreign keys with dropdowns, label them with table name
							//add a link to an editor for the foreign key label because i'm all cool like that
							
							$strFieldLabelLink= qbuild($strPHP, $strDatabase, $arrFK[0], "edit", $arrFK[1], $strDefault) ."&" . qpre . "backfield=" . $nameforhelp . "&" . qpre . "behave=closeclickrecycle";
						 
						}
						else
						{
							//just fucking around 2-12-2009
							//echo $strDefault . " " . $arrFK[0] . "-=<br>";
							//$arrRelationTemp[$strIDField]=$strDefault;
						}
						if ($bwlHypLabel==true)
						{
							if (!contains($strConfigBehave,"complete"))
							{
								$fieldlabel="<a id=\"" . $idforlabel . "\" target=\"secondarytool\" href=\"". $strFieldLabelLink . "\">" . $fieldlabel . "</a>\n";
							}
							else
							{
								$fieldlabel="<a  id=\"" . $idforlabel . "\" onclick=\"javascript:return(popdetachedwindow('" . $strFieldLabelLink . "','300','500'))\">" . $fieldlabel . "</a>\n";
							}
						}
					}
				elseif  (contains($strType,"text") || $intLen>100  && !(NeedsUpload($name)  || $arrIsFileUpload[$nameforhelp]==1))
				{
					//echo $strType . " " . $intLen . " " .  $name . "<br>";
					$outfieldform="";
					$skip=true; //we skip here because now we need a textarea
					foreach($languagerecords as $languagerecord)
					{
						$languagelabel= "<br/>" . $languagerecord["language_name"] . ":<br/>";
						if($languagerecord["language_id"]!=1)
						{
							$languagepostfix="!" . $languagerecord["language_id"];
							$strDefault=GenericDBLookupWhere($strDatabase, "translation", "table_name='" . $strTable .  "' AND field_name='" .  $name ."' AND entity_id='" . $strValDefault . "' AND language_id='" . $languagerecord["language_id"] . "'","translation_value",  false,  true);
							
						}
						if(count($languagerecords)<2  && $languagerecord["language_id"]==1)
						{
							
							$languagelabel="";
						}
						if($languagerecord["language_id"]==1)
						{
							
							$languagepostfix="";
							
						}
						//$width=gracefuldecay($arrWidth[$nameforhelp],intval($intDefaultWide *.9));
					 
						//$height=gracefuldecay($arrHeight[$nameforhelp], intval(strlen($strDefault)/80)+0);
						CalculateProbableTextAreaDimensions($strDefault, &$width, &$height, gracefuldecay($arrWidth[$nameforhelp],intval($intDefaultWide *.9)), $intDefaultWide);
						if (!$arrForce_wysiwg[$nameforhelp] && ($arrForce_no_wysiwg[$nameforhelp] || textarea=="textarea" || !contains($strType,"text") || !class_exists("wysiwygPro")))
						{
							//old way: with textarea.  do this if no wysiwyg installed or the field type isn't actually text
							$fieldform=$languagelabel . "<textarea name=\"" . $strFieldNamePrefix . $name . $languagepostfix . "\" cols=\"" . $width . "\" rows=\"" .$height . "\">" .  $strDefault . "</textarea>\n";
						}
						else
						{
							//using wysiwygPro
					 
							$editorcount++;
							if($width<10)
							{
								$width=10;
							}
							if($height<40)
							{
								$height=40;
							}
							//echo $width;
							$editor[$editorcount]= new wysiwygPro();
							$editor[$editorcount]->set_code($strDefault);
							$editor[$editorcount]->set_name($strFieldNamePrefix . $name . $languagepostfix );
							$fieldform=$languagelabel . $editor[$editorcount]->return_editor(gracefuldecay($arrWidth[$nameforhelp],$width *10),gracefuldecay($arrHeight[$nameforhelp],$height*5));
							 
						}
						$outfieldform.=$fieldform;
					}
					$fieldform=$outfieldform;
				}
				elseif  ($strType=="date")
				{
				
					$skip=true;
					$fieldform=datepulldowns($strFieldNamePrefix . $name, $strDefault);
				}
				elseif  ((($strType=="tinyint" && !contains($name, "_id")  || $arrForce_binary[$nameforhelp]) || $strType=="bit") && !$arrForce_text_input[$nameforhelp] && !(abs(intval($strDefault))>1))
				{
					$skip=true;
					//echo "-" . $arrForce_text_input[$nameforhelp] . "-";
					$fieldform=boolcheck($strFieldNamePrefix . $name, $strDefault);
				}
				else 
				{
					$width=intval($width * ($intDefaultWide/90));
					
				}   
                               
				
				//echo $name . " -" . $info["Extra"] . "+ " . $skip .   " " . $strIDField . "<br>";
				//i had this code inside the if ($info["Extra"]!="auto_increment"  && !$skip) test
				//and it was failing to work for  PKs that happened to be large strings or textareas Nov 16 2009
				if($name== $strIDField  && $info["Extra"]!="auto_increment")
				{
					$bwlSkipHiddenIDvalue=true;	
					//echo "$";
				}
					
				if ($info["Extra"]!="auto_increment"  && !$skip)
				{
					
					//echo $name . " -" . $info["Extra"] . "+ " . $skip .  "<br>";

					$strFormType="text";
					
					if (($name=="password"  || $arrIsPassword[$nameforhelp]==1))
					{
						if($_REQUEST[qpre . "passwordoverride"]!="")
						{
							$bwlPasswordObfuscationOverride=true;
						}
						else
						{
						
							
							$strFormType="password";
						}
					}
					
					if($strTableLookingOutWith !="" && (!contains($name, "display_column")  && contains($name, "column") || contains($name, "field")))
					{
						//echo  $strTableLookingOutWith$name . "<br>";
						//echo $strType . "-" . $strTableLookingOutWith . "<br>";
						//echo  $strTableLookingOutWith;
						
						$fieldform=FieldDropdown($strDatabase, $strTableLookingOutWith, $name, $strDefault);
						//$strTableLookingOutWith="";
						//TableDropdown($strDatabase, $strDefault,$strFieldNamePrefix . $name, "BForm","column_name");
					
					}
					elseif (contains($name, "table_name")) //special case for references to tables
					{
						// TableDropdown($strDatabase, $strDefaultTable, $strTableFormName, $strOurFormName='BForm', $strFieldFormName="")
						
						//time to speculate about the field names for the fields that goes with this table dropdown:
						//i have it so my primitive ajax tech can update all the selects automatically with a change of the table dropdown
						$bwlNextColumn=false;
						$associatedColumnName="";
						foreach($descr as $fnom=>$finfo)
						{
							
							$fname=$finfo["Field"];
							//echo $fname . "=<br>";
							//echo $bwlNextColumn . "%<br>";
							if ($fname==$name)
							{
								$bwlNextColumn=true;
							}
							elseif ($bwlNextColumn  && contains($fname, "_table"))
							{
								$bwlNextColumn=false;
								break;
								
							}
							if ($bwlNextColumn  && (!contains($fname, "display_column")  && contains($fname, "column") || contains($fname, "field")))
							{
								//i use plus here because i happen to know it is urlencoded space and i will later split on space on my hidden ajax page
								//and then cycle through all the select dropdowns that need to have their fields updated to reflect the new table
								$associatedColumnName.=$fname . "+" ;
								//$bwlNextColumn=false;
								
							}
							
						}
						$associatedColumnName=RemoveEndCharactersIfMatch($associatedColumnName, "+" );
						//if associatedColumnName doesn't contain anything, then none of the fancy ajax stuff is turned on for this table select
						$fieldform=TableDropdown($strDatabase, $strDefault,$strFieldNamePrefix . $name, "BForm",$associatedColumnName);
						//i use a space here to force a fielddropdown if we have a tabledropdown
						$strTableLookingOutWith=gracefuldecay($strDefault, " ");
					
					}
					else
					{
						 
						$fieldform="";
						$strAboveForm="";
				
						$strValString="value=\"". forinputform($strDefault) . "\"";
						//i determine whether or not we make this form item an upload based entirely on its field name, not its type,
						//as in, does the field name contain either the string "filename" or "banner" 
						//(alter the NeedsUpload function to change this behavior)
						//echo $name . "++ --" . NeedsUpload($name)  . "-- ==" . $arrIsFileUpload[$nameforhelp] . "<br>";
						if (NeedsUpload($name)  || $arrIsFileUpload[$nameforhelp]==1)
						{	
							$path=fieldNameToFolderPath($strFieldNamePrefix . $name, tf_dir . imagepath) . $strDefault;
							//echo $path;
							$ahtml="";
							$slasha="";
							$strDeleteCheckbox="";
							if (tf_file_exists($path))
							{
								$ahtml="<a href=\"#\" onclick=\"popwindow('" . $path . "', '" . 200 . "', '" . 500 . "','picwindow'); \">";
								$slasha="</a>";
								
							}
							if($strDefault!="")
							{
								$strDeleteCheckbox=" &nbsp;&nbsp;"  . CheckboxInput($strFieldNamePrefix . qpre . "ux|" . $name,"1", false) . "delete";
							}
							$fieldform=   PictureIfThere($path, "100") . "\n";
							$width=intval($width*.5);
							$strFormType="file";
							
					 		$strAboveForm="&nbsp;&nbsp;&nbsp;" . $ahtml . $strDefault . $slasha . $strDeleteCheckbox . "<br>" . "<input type=\"hidden\" name=\"" .$strFieldNamePrefix . $name . "\"   value=\"".  $strDefault . "\">\n";
							
							$name=$strFieldNamePrefix . qpre . "u|" . $name;
							$strValString="";
						}
						$fieldform=$strAboveForm . "<input type=\"" . $strFormType . "\" name=\"" . $strFieldNamePrefix . $name . "\" size=\"" . gracefuldecay($arrWidth[$nameforhelp],$width) . "\" " . deescape($strValString) . ">\n" . $fieldform . $strPickerLink;
						//EXPERIMENTAL Dec 4 2009:
						//echo($name . " " . $strFormType . "<br>");
						if($bwlPasswordObfuscationOverride)
						{
							//die($strFormType  . "**" . $_REQUEST[qpre . "passwordoverride"]);
							$fieldform.="<input name=\"" . qpre . "phpprocess\" type=\"text\" size=\"40\" value=\"\" onBlur=\"javascript:phpprocess( 'document.BForm." .  qpre . "phpprocess','md5($" . "value)')\">";
							//$fieldform.="<input name=\"" . qpre . "phpprocess\" type=\"text\" size=\"40\" value=\"\" onBlur=\"javascript:phpprocess('document.BForm." . $strFieldNamePrefix . $name . "','md5($" . "value)', 'document.BForm." .  qpre . "phpprocess')\">";
						}
					}
					if($arrIsDateCreated[$nameforhelp] || $arrIsDateModified[$nameforhelp])
					{
						$fieldform=$strDefault; //don't allow an edit for a timestamp
					}  
				}
			
				elseif ($info["Extra"]=="auto_increment"  && $strValDefault=="")
				{
					$fieldform="&nbsp;&nbsp;&nbsp;<strong>autoincrement:</strong> \n";
				}
				elseif ($info["Extra"]=="auto_increment" && $strValDefault!="")
				{
					$bwlSkipHiddenIDvalue=false;  //added 10-23-2008 to make sure we get a hidden id if we're not supplying a form item for the PK
					$fieldform="&nbsp;&nbsp;&nbsp;<strong>" .  $strValDefault. "</strong> \n";
				}
				
				$out.="<tr class=\"" .  $strThisBgClass . "\">\n";
				$out.="<td valign=\"top\">\n";
				if ($bwlSuperAdmin)
				{
				
					$strHelpLink="help('" .$strDatabase . "','" . $strTable  . "','" . $nameforhelp. "')";
				}	
				else
				{
				
					$strHelpLink="return(false)";
				}
				if ($arrHelpText[$nameforhelp]!="")
				{
					$out.="<span class=\"helplink\" onmouseover='return escape(\"" . htmlcodify($arrHelpText[$nameforhelp]) . "\")' href=\"" . $strHelpLink . "\">?</span>";
				}
				else if ($bwlSuperAdmin)
				{
					$out.="<span  class=\"helplink\" onclick=\"" . $strHelpLink . "\">?!</span>";
				}
				$out.=$fieldlabel . "\n";
	
				
				$out.="</td>\n";
				$out.="<td>\n";
				$out.=$fieldform ; 
				
				//help link/text
	
				if ($arrValidationType[$nameforhelp]!="")
				{
					//echo HexDump($arrValidationPattern[$nameforhelp]);
					if (!$bwlInvisible)
					{
						$strValidationJS.= $nameforhelp . "~" . $arrValidationType[$nameforhelp] . "~"  . $arrPrettyName[$nameforhelp]  ."~"  . html_entity_decode(decode_entities($arrValidationPattern[$nameforhelp])) . "<validata/>"; 
					}
				}

				$out.="</td>\n";
				$out.="</tr>\n";
				$out.=$strPseudo;
				if ($strPseudo!="")
				{
					$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
				}
			}
			
	 	}
	}
	if($strValDefault!=$strRowLabel)
	{
		$strRowLabel = $strValDefault . ": " . $strRowLabel;
	}
	$out.="<tr class=\"" . $strClassFirst ."\" style=\"display:none\">\n<td colspan=2>\n";
	$out.="<a href=\"javascript: changetableeditorcollapse()\">";
	$out.=$strRowLabel;
	$out.="</a></td>";
	$out.="</tr>\n";
	//place to put additional relational tools
	$additionalToolContent="";
	if(is_array($relationalrecords))
	{
		
		foreach($relationalrecords as $record)
		{
			//echo "*";
			$related_table=$record["table_name"];
			$related_table_fk=$record["column_name"];
			$tool_guidance=$record["tool_guidance_id"];
			$relation_type_id=$record["relation_type_id"];
			
			if($tool_guidance==1 && $relation_type_id==0)
			{
				//echo "##";
				//checkbox scenario
				//first lookup remote table, which we don't yet know
				// $strIDField, $strValDefault,
				// LimitedOptionList(our_db,58, "ARTICLE_CATEGORY", "ARTICLE_ID", "ARTICLE", "CATEGORY_ID", "CATEGORY", "ID","checkboxes", "");
				$additionalToolContent.=LimitedOptionList($strDatabase,  $strValDefault,$related_table, $related_table_fk,  $strTable, $relation_pk, $relationname, $ok,"checkboxes-horizontal", "");
			
			}
		}
	}
	if($additionalToolContent!="")
	{
		$out.=htmlrow("bgclassline", $relationname, $additionalToolContent);
	}
	
	$out.="<tr class=\"bgclassline\">\n<td colspan=2 align=\"right\">\n";

	if (($strValDefault!=""  || is_array($arrPK)) && !contains($strConfigBehave,"nonewbutton"))
	{
		$out.="<input class=\"btn\"
   onmouseover=\"this.className='btn btnhov'\" onmouseout=\"this.className='btn'\" name=\"" . qpre . "submit_clearid\" type=\"submit\" value=\"" . $strOtherButtonText ."\">\n";
	
	}
	$out.="<input class=\"btn\"
   onmouseover=\"this.className='btn btnhov'\" onmouseout=\"this.className='btn'\" name=\"" . qpre . "submit\" type=\"submit\" value=\"" . $strButtonText ."\">\n";
	$out.="</td>\n</tr>\n";
	$out.=HiddenInputs(array("needtoencryptonsave"=>trim($needtoencrypt),"dropdowntextvalue"=>"", "rec"=>$intRecord, "column"=>$strSort, "direction"=>$strDirection, "backfield"=>$strBackfield));
	$out.=HiddenInputs(array("table"=>$strTable,"table"=>$strTable,"db"=>$strDatabase,"mode"=>$strMode,"idfield"=>$strIDField,"behave"=>$strConfigBehave, "ks"=>serialize($arrPK),qpre, $strFieldNamePrefix));

	
	if(!$bwlSkipHiddenIDvalue  && !is_array($arrPK))
	{
		$out.="<input type=\"hidden\" name=\"" . $strFieldNamePrefix . $strIDField . "\"   value=\"".  $strValDefault . "\">\n";
		 
	}                                                                                
	$out.="<input type=\"hidden\" name=\"" . $strFieldNamePrefix . qpre. "oldid\"   value=\"".  $strValDefault . "\">\n";
	if (strpos(" " . $strConfigBehave, "noform")<1)
	{
		$out.="</form>";
	}
	$out= $preout . TableEncapsulate($out, false);
	$strLowerLeftContent="\n<iframe frameborder=\"0\" marginwidth=\"0\" marginheight=\"0\" width=\"340\" height=\"400\" name=\"foreignstuff\" src=\"" . tf_dir . qbuild("tf_foreign.php", $strDatabase, $strTable, "", $strIDField, $strValDefault). "&" . qpre . "behave=noextras&" . qpre . "iddefault=" .  $strValDefault . "&" . qpre . "suppressmetalink=" . $strDisplayMode . "&" . qpre . "foreignlimit=" . $_REQUEST[qpre . "foreignlimit"] . "\"></iframe>";

	$strLowerRightContent="\n<iframe frameborder=\"0\" marginwidth=\"0\" marginheight=\"0\" width=\"490\" height=\"400\" name=\"secondarytool\" id=\"idsecondarytool\" src=\"" . tf_dir . "tf_message.php\"></iframe>";
	
	//$out.= ForeignKeyReferralLists($strDatabase, $strTable,$strIDField , $strValDefault, $strPHP);
	if (!contains($strConfigBehave, "noextra")  && !contains($strConfigBehave, "notopnav"))
	{
		if ($strConfigBehave!="noextras"  && !contains($strConfigBehave,"complete"))
		{
			$out=FormEncapsulate($out, $strLowerLeftContent, $strLowerRightContent);
		}
		elseif ($strValDefault!=""  && !contains($strDisplayMode, "nometalink"))
		{
			$out.="<p>\n";
			$out.="<a target=\"_new\" href=\"" . qbuild($strPHP, $strDatabase, $strTable, "edit", $strIDField, $strValDefault) . "\">Edit this " . $strTable . " and <em>its</em> Associated Items</a> starting in a new window.</a>";
			
		}
	}
	$out.="\n<script>\nvalidationconfig='" . $strValidationJS . "';  TextAreaScan();\n</script>\n";
	if($_REQUEST[qpre . "collapse"]!="")
	{
		$out.="\n<script>\nchangetableeditorcollapse();\n</script>\n";
	
	}
	return $out;
}
 
function FormEncapsulate($strMainFormContent, $strLowerLeftContent, $strLowerRightContent)
//throws an editor into a three-pane editor for real down-and dirty editing possibilities
{
	$out.="<tr>\n<td colspan=\"2\" valign=\"top\">\n";
	$out.=$strMainFormContent;
	$out.="</td>\n";
	$out.="<tr>\n";
	$out.="<td valign=\"top\">\n";
	$out.=$strLowerLeftContent;
	$out.="</td>\n";
	$out.="<td valign=\"top\">";
	$out.=$strLowerRightContent;
	$out.="</td>\n</tr>\n";
	$out.="</tr>\n";
	$out=TableEncapsulate($out, false,"840","",0,0,0,"");
	return $out;
}


function probableserialized($value)
{
 
	if((beginswith($value, "a:") || beginswith($value, "O:"))  && contains($value, ":{")  &&  contains($value, ";}"))
	{
		return true;
	
	}
	return false;
}
?>