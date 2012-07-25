<?php
//Judas Gutenberg January 2006
//provides a web front end admin tool for any mysql db
//this page appears in an iframe to show links to rows in  tables to which the parent table is foreign
//i've modified txtsql to be aware of foreign keys so this tool can dynamically build complicated tools
//This code is covered under the GNU General Public License
//info here: http://www.gnu.org/copyleft/gpl.html
//the digest is as follows: you cannot modify this code without
//publishing your source code under the same license
//contact the developer at gus@asecular.com  http://asecular.com

include('tf_functions_core.php');

echo main();

function main()
	{
	
		if(!IsExtraSecure())
		{
			die(ExtraSecureFailure());
		}
		//$olderror=error_reporting(0);
		$mode=$_REQUEST[qpre . "mode"];
		$idfield=$_REQUEST[qpre . "idfield"];
		$id=$_REQUEST[qpre . "iddefault"];
		$strTable=$_REQUEST[qpre . "table"];
		$strTheirTable=$_REQUEST[qpre . "theirtable"];
		$strDatabase=deMoronizeDB(gracefuldecay($_REQUEST[qpre . "db"],our_db));
		$strColumn=$_REQUEST[qpre . "column"];
		$strDirection=$_REQUEST[qpre . "direction"];
		$strConfigBehave=$_REQUEST[qpre . "behave"];
		$strForeignLimit=$_REQUEST[qpre . "foreignlimit"];
		$rec=$_REQUEST[qpre . "rec"];
		$strDisplayMode= $_REQUEST[qpre . "suppressmetalink"];
		error_reporting($olderror);
		$strPHP=$_SERVER['PHP_SELF'];
		$out="";
		if ($rec=="")
		{
			$rec=0;
		}
		//echo $id . " " .$idfield ;
		$out=LoginDecisions($strDatabase,  $strPHP, $strUser, true);
		if ($strUser!="")
		{
	
			$intAdminType= AdministerType($strDatabase, $strTable, $strUser);
			
			if ($intAdminType>1)
				{
				 	
					$out.= ForeignKeyReferralLists($strDatabase, $strTable,$idfield , $id, "tf.php", $strTheirTable, $rec, 200, $strDisplayMode, $strForeignLimit);
				}
		}
		//($strTitle, $strConfigBehave,$strForBackField="", $bwlIsStandalone=true, $bwlSuppressExternalHeader=false)
		$out =  PageHeader($strDatabase . " : Foreign Referrals", $strConfigBehave, "", true, true, "", $strDatabase) . $out . PageFooter(true, false, true);
		
		return $out;
	}


function ForeignKeyReferralLists($strDatabase, $strOurTable, $strIDField, $strOurID, $strPHP, $strSpecificFKTable="", $intRecord=0, $intRecsPerPage=50, $strDisplayMode=false, $strForeignLimit="")
{
//inside a particular database, find all the tables that have a foreign key relationship with the given item and list them in grouped clusters, complete with various editing options
	$out="";
	$bwlEnableSortTools=true;
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strOtherBgClass="bgclassother";
	$strOtherLineClass="bgclassline";
	$strThisBgClass=$strClassFirst;
	$linklength=45;
	$numout=0;
	$thisset=0;
	$sql=conDB();
	$strParentTableReadableName= LookupName($strDatabase,$strOurTable,$strIDField, $strOurID);
	//echo $strOurID . "-";
	if ($strOurID!="")
	{
		
		if ($strSpecificFKTable=="")
		{
		
			//the following query makes everything easy because I have a relation table!!!
			$strSQL="SELECT * FROM " . $strDatabase . "." .  tfpre . "relation WHERE f_table_name='" . $strOurTable . "' AND relation_type_id=0 ORDER BY table_name ASC";

		}
		else //if we pass in a specific table, then that's all we care about
		{
			$strSQL="SELECT * FROM " . $strDatabase . "." .  tfpre . "relation WHERE f_table_name='" . $strOurTable . "' AND  table_name='" . $strSpecificFKTable . "'  AND relation_type_id=0 ORDER BY table_name ASC";
			 
		}
		//echo $strSQL;
		$fkrecords = $sql->query($strSQL);
		$intUnnameditemcount=1;
		$oldTable="";
		foreach ($fkrecords as $fkrecord)
		{
			$strTheirTable=$fkrecord["table_name"];
			if($strForeignLimit=="" || $strForeignLimit!=""  && inList($strForeignLimit,  $strTheirTable)) //limit associated items to those indicated by restriction if there is one
			{
			 
				//echo $strTheirTable . "<br>";
				$strTheirNameColumn=$fkrecord["display_column_name"]; 
				//echo $strTheirNameColumn;
			    //now we have a tablename, let's look to see if there are foreign keys pointing back to our table
				$thistableinfo="";
				
				$strSQLThis="SELECT COUNT(*) as COUNTed FROM " . $strDatabase . "." .  $strTheirTable . " WHERE " . $fkrecord["column_name"] . " =  " . $strOurID;
				$xrecords = $sql->query( $strSQLThis);
				$xrecord=$xrecords[0];
				$intCount=$xrecord["COUNTed"];
				//echo $intCount . "<br>";
				if($strTheirNameColumn=="")
				{
					
					$strTheirNameColumn=firstnonidcolumname($strDatabase,  $strTheirTable);
				}
				$strTheirIDColumnName=PKLookup($strDatabase, $strTheirTable);
				if($strTheirIDColumnName=="")
				//no pk?  no problem! just use all the columns in combination as a pk!  tf handles this
				//automatically when you supply it a pkname as a space-delimited string of column names
				{
					$strTheirIDColumnName=join(" ", GetFieldArray($strDatabase, $strTheirTable));
				}
				//look to see if (by an obvious column name) there is an actual sort column and order by that. otherwise order by alpha
				$strSortColumn="";
				$sorttools="";
				$strSortColumn=SortColumn($strDatabase, $strTheirTable);
				//echo "!" . $strSortColumn;
				if ($strSortColumn!="")
				{
				
					if($bwlEnableSortTools)
					{
						$thisset++;
						$sorttools=SortTools($thisset, $strDatabase, $strTheirTable, $strTheirIDColumnName, $strSortColumn);
						
						$sortitemcounter=1;
						//echo $sorttools;
					}
				}
				//echo "!" . $strSortColumn;
				$strSortColumn=gracefuldecay($strSortColumn, $strTheirNameColumn);
				if($strIDField== $fkrecord["f_column_name"] )
				{
					$strOurDataToUse=$strOurID;
				}
				else
				{
					//this is in case the table to which our data is foreign is referencing our data by something other than its PK
					$strOurDataToUse= GenericDBLookup($strDatabase, $strOurTable, $strIDField, $strOurID, $fkrecord["f_column_name"]);
				}
				$bwlForceMap=false;
				$strSQL="SELECT * FROM " . $strDatabase . "." .  $strTheirTable . " WHERE " . $fkrecord["column_name"] . " =  '" . $strOurDataToUse . "'";
				if ($strSortColumn!="" )
				{
					if(FieldExists($strDatabase, $strTheirTable, DelimitedStringToOrderBySubclause($strSortColumn)))
					{
 
						$strSQL.=" ORDER BY " . DelimitedStringToOrderBySubclause($strSortColumn);
					}
					else
					{
						$bwlForceMap=true;  //need to do this if passing in a display_column_name on a mapping table, since it refers 
						//to columns in the mapped table, not in the mapping table
					}
				}
				else 
				{
					 
				}
	
				$strSQL.=" LIMIT " . $intRecord . "," . $intRecsPerPage;
				//echo $strSQL . "<BR>";
				//echo $fkrecord["f_column_name"] . "<BR>";
				//echo $strSQL . "<p>";
				if  ($strIDField !="")
				{
					
					$strTableToUse= $strTheirTable;
					
					$deletemethod="delete";
					$addmethod="new";
					$strMappedTable="";
					$records = $sql->query($strSQL);
					//echo $strTheirNameColumn ;
					if ($strTheirNameColumn==""  || $bwlForceMap)//then we have a mapping table on our hands!
					{
						$intFKcount=countforeignkeycolumns($strDatabase, $strTheirTable,  $strOurTable);
						if ($intFKcount>1)//if a mapping table has two or more foreign keys beyond
														//the one to our table, it's too complex to treat as a
														//pure mapping table
						{
							
							$arrFKInfo=Array();
							//echo "#" . $intFKcount;
							//echo $strTheirTable . " " . $strOurTable . "<BR>";
							for ($intFKCounter=0; $intFKCounter<$intFKcount+1; $intFKCounter++)
							{
								//echo $intFKCounter . "<br>";
								//the following returns an array 
								$arrFKInfo[$intFKCounter]=Nthforeignkeycolumn($strDatabase, $strTheirTable,$strOurTable, $intFKCounter);
								//var_dump($arrFKInfo[$intFKCounter]);
								//echo $arrFKInfo[$intFKCounter][0] . " " . $arrFKInfo[$intFKCounter][1] . " " . $arrFKInfo[$intFKCounter][2] . " "  . $intFKCounter . "<br>";
								//echo implode("," . $arrFKInfo[$intFKCounter]) . "<br>";
							}
							//$arrMapInfo=firstforeignkeycolumn($strDatabase, $strTheirTable, $strOurTable);
							// echo $arrFKInfo . "=<br>";
						}
						else
						{
							$arrMapInfo=firstforeignkeycolumn($strDatabase, $strTheirTable, $strOurTable);
							
							$strForeignColumn=$arrMapInfo[0];
							$strMappedTable=$arrMapInfo[1];
							$strMappedNameColumn=$arrMapInfo[3];
							//echo implode("," . $arrMapInfo) . "<br>";
							//echo $strMappedNameColumn . "=<br>";
						}
					}
					//echo $strIDField . " " . $namecolumn . "<br>";
					$strMappedIDColumn=PKLookup($strDatabase, $strMappedTable);
					//if($strMappedIDColumn=="")
					//{
						//$strMappedIDColumn=join(" ", GetFieldArray($strDatabase, $strMappedTable));
					//}
					//echo "-" . $strMappedIDColumn . " ..." .  $strMappedTable;
					if($strMappedNameColumn=="")
					{
						$strMappedNameColumn=firstnonidcolumname($strDatabase, $strMappedTable);
						//echo "//" . $strMappedNameColumn . "<br>";
					}
					foreach ($records as $record )
					{
						
						$olderror=error_reporting(0);
						$strNameToUse= $record[$strTheirNameColumn];
						//echo "@" . $strNameToUse . "*" . $strTheirNameColumn . "<br>";
						$idToUse=$record[$strTheirIDColumnName];
						$strColumnNameToUse= $strTheirIDColumnName;
						$strTableToUse= $strTheirTable;
			
						error_reporting($olderror);
						//$strTableForNewAndLabel=$strTheirTable;
						
					 	//echo "-" . $strMappedTable . "-<br>";
						if ($strMappedTable!="") //in the case where we are looking at a mapped table
						{
							//if we find ourselves in here, we're not looking at the
							//referring table for names and ids but instead 
							//a third table mapped by a mapping table
							//though any deletions or insertions called from HTML generated here
							//will just be from or to the mapping table (an 'unlink' or a 'link')
							
							//echo $strMappedTable . "<br>";
							
							//echo $strMappedNameColumn . "<br>";
							//echo $strMappedIDColumn . "<br>";
							//echo $strMappedIDColumn;
							$strSQL="SELECT * FROM " . $strDatabase . "." .  $strMappedTable . " WHERE " . $strMappedIDColumn . " =  " . $record[$strMappedIDColumn];
							//echo $strSQL . "<br>";
							$mappedrecords = $sql->query($strSQL);
							$mappedrecord=$mappedrecords[0];
							 
							$strNameToUse= $mappedrecord[$strMappedNameColumn];
							$idToUse=$mappedrecord[$strMappedIDColumn];
							$strColumnNameToUse=$strMappedIDColumn;
							if($strMappedTable!= $strOurTable)
							{
								$strTableToUse=$strMappedTable;
							}
							//echo $strTableToUse . "<br>";
							$deletemethod="unlink";
							$addmethod="link";
						}
						if ($strNameToUse=="")//in which i handle the case of complex mapping tables
						{
							//$strNameToUse="Unnamed Item # " . $intUnnameditemcount;
							//$strNameToUse = LookupName($strDatabase,$strTableToUse,$strTheirIDColumnName, $idToUse);
							//$strNameToUse="";
							//echo $intFKcount . "+<br>";
							$strFallback="";
							$strRecursiveLink="";
							for ($intFKCounter=0; $intFKCounter<$intFKcount+1; $intFKCounter++)
							{
								//echo $arrFKInfo[$intFKCounter][0] . "." . $arrFKInfo[$intFKCounter][1] . "," . $arrFKInfo[$intFKCounter][2] . "-" . $arrFKInfo[$intFKCounter][3] . "+" . $strOurTable . "==<br>";
								//echo $arrFKInfo[$intFKCounter][3] . "<br>";
								$strNameFieldFromRelationTable=$arrFKInfo[$intFKCounter][3];
								//echo $arrFKInfo[$intFKCounter] . " " . $intFKCounter . "<BR>";
								//echo $strNameFieldFromRelationTable . "<BR>";
								//echo $strPartOfNameToUse . "<br>";
								//echo $arrFKInfo[$intFKCounter][1] . "." . $arrFKInfo[$intFKCounter][2] . "," . $record[$arrFKInfo[$intFKCounter][0]] . "<br>";
								$strPartOfNameToUse= LookupName($strDatabase,$arrFKInfo[$intFKCounter][1],$arrFKInfo[$intFKCounter][2], $record[$arrFKInfo[$intFKCounter][0]], gracefuldecay($strNameFieldFromRelationTable, $strTheirNameColumn));
								//echo "-" . $strNameFieldFromRelationTable ."+" . $strTheirNameColumn;
								if($strPartOfNameToUse!="" && $strParentTableReadableName!=$strPartOfNameToUse && $arrFKInfo[$intFKCounter][1]!=$strOurTable)
								{
									$strNameToUse.= " " . $strPartOfNameToUse;
								}
								else if ($strPartOfNameToUse!="" && $strParentTableReadableName!=$strPartOfNameToUse)  //sometimes we really do need it
								{
									$strFallback.= " " . $strPartOfNameToUse;
								}
								if($arrFKInfo[$intFKCounter][1]==$strOurTable  && $strParentTableReadableName!=$strPartOfNameToUse)
								{
									//now we can make a link for a fun recursive jump
									 
									$strRecursiveLink="<td>[<a onclick=\"javascript:top.location.href='" . qbuild($strPHP, $strDatabase, $strOurTable, "edit",  $strIDField,  $record[$arrFKInfo[$intFKCounter][0]])   . "&" . qpre . "behave=" .  "'\">^</a>]</td>";
								}
							//echo $arrFKInfo[$intFKCounter][1] . " " . $arrFKInfo[$intFKCounter][2] . "<br>";
								//echo $strNameToUse . "-<br>";
							}
							$strNameToUse=gracefuldecay(trim($strNameToUse), trim($strFallback), "name unavailable");
							
							//echo "x" . $strNameToUse . "x";
							$intUnnameditemcount++;
						}
							
						//actually display tiny thumbnails if this is a pic
						$strNameForJS=ltrim(simplelinkbody($strNameToUse, $linklength));
						if (isImageFileName($strNameToUse))
						{
							
							$path=fieldNameToFolderPath($strColumnNameToUse, imagepath) . $strNameToUse;
							//echo $path . "<br>";
							if (file_exists($path))
							{
								$strPossiblePic= PictureIfThere($path, "50");
								//echo $strPossiblePic. "<br>";
								if ($strPossiblePic!="")
								{
									$strNameToUse=  $strPossiblePic;
									
								}
								else
								{
									$strNameToUse=   simplelinkbody($strNameToUse, $linklength);
								}
	
							} 
							else
							{
							
								$strNameToUse=   simplelinkbody($strNameToUse, $linklength);
							} 
						
						}
						else
						{
				
							$strNameToUse= simplelinkbody($strNameToUse, $linklength);
						}
			 
						//$strNameToUse=simplelinkbody($strNameToUse);
						$keyserialized="";
							
						if(contains($strTheirIDColumnName, " "))
						{
							$keyserialized=$qpre . "&" . qpre . "ks=" . urlencode(serialize(ArraySubsetFromList($strTheirIDColumnName, $record )));
						}
						if($sorttools!="")
						{
						
			
							//sort tools for items in a foreign table, if needed
							$js=" onclick='MAtrselectfromline(this,\"" . $thisset . "\");' onfocus='groovify(this, \"black\");' onmouseover='groovify(this, \"orange\");' onmouseout='degroovify(this);' onblur='degroovify(this);' " ;
						}
						//i have a problem here! i'm not getting editable links in some mapped tables
						//oh i know why - they have de factor compound pks with no ACTUAL pks. whoops!
						//well, that's a schema problem, not a prob with this code.
						//delete link for a row in a foreign table
						$thistableinfo.="<tr ><td " . $js . ">&nbsp;</td><td width=\"20\">[<a onclick=\"javascript:return(popwindowwithconfirm('" .  qbuild($strPHP, $strDatabase, $strTheirTable, "delete", $strTheirIDColumnName,  $record[$strTheirIDColumnName]) . "&" . qpre . "suppressmetalink="  . $strDisplayMode .  "&" . qpre . "behave=closeclickrecycle" . $keyserialized . "',100,'" . $strNameForJS . "','" . $deletemethod . "'))\">x</a>]" . $strRecursiveLink . "</td>";
	
						//clickable row link in a foreign table:
						$thistableinfo.="<td " . $js . "><a onclick=\"javascript:return(popwindow('" . qbuild($strPHP, $strDatabase, $strTableToUse, "edit",  $strColumnNameToUse, $idToUse)  . "&" . qpre . "suppressmetalink="  . $strDisplayMode .  "&" . qpre . "behave=closeclickrecycle" .  $keyserialized .  "',300))\">" . $strNameToUse  . "</a>";
						//$thistableinfo.="<td " . $js . "><a onclick=\"javascript:return(popwindow('" . qbuild($strPHP, $strDatabase, $strTableToUse, "edit",  $strTheirIDColumnName,  $record[$strTheirIDColumnName])  . "&" . qpre . "suppressmetalink="  . $strDisplayMode .  "&" . qpre . "behave=closeclickrecycle" .  $keyserialized .  "',300))\">" . $strNameToUse  . "</a>";
						if($bwlEnableSortTools  && $sorttools!="")
						{
							//$thistableinfo.=HiddenInputs(Array("swapfieldd-" . $thisset . "-" . $sortitemcounter =>""),"");
							$thistableinfo.=RadioInput("swapfieldd-"  . $thisset . "-" . $sortitemcounter,  $idToUse, false,"",  "display:none");
						}
						$thistableinfo.="</td>\n";
						$thistableinfo.="</tr>\n";
						$numout++;
						$sortitemcounter++;
						//echo ".";
						 
					}
						 
					$strMappedTable="";
					if (DuplicatesInThisField($fkrecords, "table_name", $strTheirTable))
					{
						//in cases like this, the thing being listed should be described not 
						//in terms of our item's relation to it, but in terms of that item's relation to us,
						//thus, the way we don't want to do it is:
						//$strTableToUse = $strTableToUse . " - " . ReturnNonIDPartOfName($fkrecord["column_name"]);
						//the preferred way is this:
						//echo $fkrecord["table_name"] . " " . $fkrecord["column_name"] . "<br>";
						$wadedname=WadeAcrossRelationToGetOtherColumnName($strDatabase, $fkrecord["table_name"], $fkrecord["column_name"]);

						$strTableToUse = $strTableToUse . " - " . ReturnNonIDPartOfName($wadedname);
					}
					$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
					$out.="\n<tr><td colspan=\"2\" class=\"" . $strOtherLineClass . "\">";
					$out.=SpacerGif(1, 1);
					$out.="</td></tr>\n";
					$out.="<tr class=\"" . $strThisBgClass . "\"><td >\n";
					//the foreign table
					$out.="<p><b>" . $strTableToUse. ":</b>\n</td><td align=\"right\">"; 
					
					//$out.="</td></tr>\n";
					//echo $oldTable . " " . $strTheirTable . "<br>";
					
	
					$oldTable=$strTheirTable;
	
					$out.="<a onclick=\"javascript:return(popwindow('" . qbuild($strPHP, $strDatabase, $strTheirTable, "new", $fkrecord["column_name"], $strOurID) . "&" . qpre . "suppressmetalink="  . $strDisplayMode . "&" . qpre . "behave=closeclickrecycle',300))\">(" . $addmethod  . ")</a>\n";
	
	
					//$out.="<a onclick=\"pickerwindow('". $strDatabase . "','" . $strTheirTable . "','".  $strFieldNamePrefix . $fkrecord["column_name"] ."','" . $strIDField . "','" . $strOurID ."')\">(add)</a>\n";
					//$out.=<a onclick=\"javascript:return(popwindow('" . qbuild($strPHP, $strDatabase, $strTheirTable, "new", $fkrecord["column_name"], $strOurID) . "&" . qpre . "behave=closeclickrecycle',300))\">(add" . " ". $strTableToUse . ")</a>\n";
					$out.="</td></tr>\n";
					if($thistableinfo!="")
					{ 
						$out.= "<tr class=\"" . $strThisBgClass . "\"><td colspan=\"2\" >\n";
						$out.=  TableEncapsulate($thistableinfo, false, "100%", "",0,0,0, "");
						if($numout>1)
						{
							$out.=$sorttools;
						}
						$out.="</td></tr>\n";
					}

				 
				}
			}

					//end the inside of the if ($info["foreign"]==$strOurTable) 
		}

		if ($out!="")
		{
			$strDisplayThisTable=$strSpecificFKTable;
			if ($strSpecificFKTable=="")
			{
				$strDisplayThisTable="all";
			}
			$fkbase = qbuild("tf_foreign.php", $strDatabase, $strOurTable, "", $strIDField, $strOurID) . "&" . qpre . "behave=noextras&" . qpre . "iddefault=" . $strOurID;
			$outpre="<script src=\"tf_multipleanswer.js\"><!-- --></script>\n";
			$outpre.="\n<form name=\"BForm\">";
			$outpre.=TableBegin("100%", "",0,0,0, $strOtherBgClass);
			$outpre.="<tr><td colspan=\"2\">";
			$outpre.=adminbreadcrumb(false,"Associated Items", $fkbase, $strDisplayThisTable, "");
//<a href=\"" .$fkbase . "\" class=\"heading\">Associated Items</a> : <span class=\"heading\">" . $strDisplayThisTable . "</span>
			$outpre.="</td></tr>";
			$out= $outpre . $out; 

			if ($intCount>$intRecsPerPage)
			{
				$out.="\n<tr><td align=\"left\" colspan=\"2\" class=\"" . $strThisBgClass . "\">\n";
				$moreurlbase=$fkbase . "&" . qpre . "theirtable=" . $strTheirTable;
				if ($strSpecificFKTable=="")
				{
					$out.="--<a href=\"" . $moreurlbase . "\">more...</a>";
				}
				else
				
				{
					$out.=paginatelinks($intCount, $intRecsPerPage, $intRecord, $moreurlbase,  qpre . "rec");
				
				}
				$out.="\n</td></tr>\n";
			}
			$out.=TableEnd() . "</form>\n";
				
		}
	}
	if($bwlEnableSortTools)
	{
		//$out.="<a href=\"javascript:domdumpwindow()\">dump</a>";
	}
	return $out;
}

	
function SortTools($thisset, $strDB, $strTable, $strPKID, $strSortField)
{
	$out="";
	//$out.="move selected: ";
	//$out.="<a  href=\"javascript:MATRaction('up', '" . $thisset . "')\"><img  onmouseover=\"glow(this, 'on')\"  onmouseout=\"glow(this, 'off')\" border=\"0\" src=\"" . imagepath . "/uparrow.gif\"></a>";
	$out.="<a  href=\"javascript:MATRaction('up', '" . $thisset . "')\"><img src=\"" . imagepath . "/uparrow.gif\" alt=\"^\" border=\"0\"/></a>";
	$out.="   \n";
	//$out.="<a   href=\"javascript:MATRaction('down', '" . $thisset . "')\"><img onmouseover=\"glow(this, 'on')\"  onmouseout=\"glow(this, 'off')\" border=\"0\" src=\"" . imagepath . "/downarrow.gif\"></a>";
	$out.="<a   href=\"javascript:MATRaction('down', '" . $thisset . "')\"><img src=\"" . imagepath . "/downarrow.gif\" alt=\"v\" border=\"0\"/></a>";
	$out.="   \n";
	//$out.="<a   href=\"javascript:MATRaction('delete', '" . $thisset . "')\"><img onmouseover=\"glow(this, 'on')\"  onmouseout=\"glow(this, 'off')\" border=\"0\" src=\"" . imagepath . "/delete.gif\"></a>";
	//$out.="<a   href=\"javascript:MATRaction('delete', '" . $thisset . "')\">x</a>";
	//$out.="<a   href=\"javascript:MATRaction('delete', '" . $thisset . "')\"><img onmouseover=\"glow(this, 'on')\"  onmouseout=\"glow(this, 'off')\" border=\"0\" src=\"" . imagepath . "/delete.gif\"></a>";
	$out.="   \n";
	$out.="<a   href=\"javascript:SortSave('" . $thisset . "','" . $strDB . "','" . $strTable . "','" .  $strPKID . "','" .  $strSortField . "')\"><img src=\"" . imagepath . "/saveorder.gif\" alt=\"save order\" border=\"0\"/></a>";
 	return $out;
}

?>