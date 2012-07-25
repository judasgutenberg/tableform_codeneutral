<? 
//Gus Mueller January 2006
//provides a web front end admin tool for any mysql db
//i've modified txtsql to be aware of foreign keys so this tool can dynamically build complicated tools

include('tf_functions_core.php');

echo main();

function main()
	{
	
		
		//$olderror=error_reporting(0);
		$mode=$_REQUEST[qpre . "mode"];
		$idfield=$_REQUEST[qpre . "idfield"];
		$id=$_REQUEST[qpre . "iddefault"];
		$strTable=$_REQUEST[qpre . "table"];
		$strTheirTable=$_REQUEST[qpre . "theirtable"];
		$strDatabase=deMoronizeDB(gracefuldecay($_REQUEST[qpre . "db"],our_db));
		$strColumn=$_REQUEST[qpre . "column"];
		$strDirection=$_REQUEST[qpre . "direction"];
		$strExtrajs=$_REQUEST[qpre . "extrajs"];
		$rec=$_REQUEST[qpre . "rec"];
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
				 
					$out.= ForeignKeyReferralLists($strDatabase, $strTable,$idfield , $id, "tf.php", $strTheirTable, $rec, 200);
				}
		}
		$out =  PageHeader($strDatabase . " : Foreign Referrals", $strExtrajs) . $out . PageFooter();
		
		return $out;
	}


function ForeignKeyReferralLists($strDatabase, $strOurTable, $strIDField, $strOurID, $strPHP, $strSpecificFKTable="", $intRecord=0, $intRecsPerPage=50)
	{
	//inside a particular database, find all the tables that have a foreign key relationship with the given item and list them in grouped clusters, complete with various editing options
		$out="";
		$bwlEnableSortTools=true;
		$strClassFirst="bgclassfirst";
		$strClassSecond="bgclasssecond";
		$strOtherBgClass="bgclassother";
		$strOtherLineClass="bgclassline";
		$strThisBgClass=$strClassFirst;
		$numout=0;
		$thisset=0;
		//echo $strOurID . "-";
		if ($strOurID!="")
		{
		$sql=conDB();
		if ($strSpecificFKTable=="")
		{
		
		//the following query makes everything easy because I have a relation table!!!
		$strSQL="SELECT column_name, table_name, f_column_name FROM " . $strDatabase . "." .  tfpre . "relation WHERE f_table_name='" . $strOurTable . "' AND relation_type_id=0 ORDER BY table_name ASC";
 
 
 		}
		else //if we pass in a specific table, then that's all we care about
		{
			$strSQL="SELECT column_name, table_name, f_column_name FROM " . $strDatabase . "." .  tfpre . "relation WHERE f_table_name='" . $strOurTable . "' AND  table_name='" . $strSpecificFKTable . "'  AND relation_type_id=0 ORDER BY table_name ASC";
			 
		}
		//echo $strSQL;
		$fkrecords = $sql->query($strSQL);
		$intUnnameditemcount=1;
		$oldTable="";

		foreach ($fkrecords as $fkrecord)
	 
			{

				$strTheirTable=$fkrecord["table_name"];

			    //now we have a tablename, let's look to see if there are foreign keys pointing back to our table
				$thistableinfo="";
				
				$strSQLThis="SELECT COUNT(*) as COUNTed FROM " . $strDatabase . "." .  $strTheirTable . " WHERE " . $fkrecord["column_name"] . " =  " . $strOurID;
				$xrecords = $sql->query( $strSQLThis);
				$xrecord=$xrecords[0];
				$intCount=$xrecord["COUNTed"];
				//echo $intCount . "<br>";
				$strTheirNameColumn=firstnonidcolumname($strDatabase,  $strTheirTable);
				$strTheirIDColumnName=idcolumname($strDatabase, $strTheirTable);
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

				$strSQL="SELECT * FROM " . $strDatabase . "." .  $strTheirTable . " WHERE " . $fkrecord["column_name"] . " =  " . $strOurID;
				if ($strSortColumn!="")
				{
					$strSQL.=" ORDER BY " . $strSortColumn;
				}

				$strSQL.=" LIMIT " . $intRecord . "," . $intRecsPerPage;
				//echo $strSQL . "<br>";
				if  ($strIDField !="")
				{
					
					$strTableToUse= $strTheirTable;
					
					$deletemethod="delete";
					$addmethod="new";
					$strMappedTable="";
					$records = $sql->query($strSQL);
					if ($strTheirNameColumn=="")//then we have a mapping table on our hands!
					{
						$intFKcount=countforeignkeycolumns($strDatabase, $strTheirTable,  $strOurTable);
						if ($intFKcount>1)//if a mapping table has two or more foreign keys beyond
														//the one to our table, it's too complex to treat as a
														//pure mapping table
						{
							 
							$arrFKInfo=Array();
							//echo "#" . $intFKcount;
							for ($intFKCounter=0; $intFKCounter<$intFKcount+1; $intFKCounter++)
							{
								//echo $intFKCounter . "<br>";
								$arrFKInfo[$intFKCounter]=Nthforeignkeycolumn($strDatabase, $strTheirTable,$strOurTable, $intFKCounter);
								//echo $arrFKInfo[$intFKCounter][0] . " " . $arrFKInfo[$intFKCounter][1] . " " . $arrFKInfo[$intFKCounter][2] . " "  . $intFKCounter . "<br>";
							}
							//$arrMapInfo=firstforeignkeycolumn($strDatabase, $strTheirTable, $strOurTable);
						}
						else
						{
							$arrMapInfo=firstforeignkeycolumn($strDatabase, $strTheirTable, $strOurTable);
							
							$strForeignColumn=$arrMapInfo[0];
							$strMappedTable=$arrMapInfo[1];
						}
					}
					//echo $strIDField . " " . $namecolumn . "<br>";
					$strMappedIDColumn=idcolumname($strDatabase, $strMappedTable);
					$strMappedNameColumn=firstnonidcolumname($strDatabase, $strMappedTable);
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
						
					 
						if ($strMappedTable!="") //in the case where we are looking at a mapped table
						{
								//if we find ourselves in here, we're not looking at the
								//referring table for names and eidts but instead 
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
								$strTableToUse=$strMappedTable;
								$deletemethod="unlink";
								$addmethod="link";
							}
							if ($strNameToUse=="")//in which i handle the case of complex mapping tables
							{
								//$strNameToUse="Unnamed Item # " . $intUnnameditemcount;
								//$strNameToUse = LookupName($strDatabase,$strTableToUse,$strTheirIDColumnName, $idToUse);
								//$strNameToUse="";
								//echo $intFKcount . "+<br>";
								for ($intFKCounter=0; $intFKCounter<$intFKcount+1; $intFKCounter++)
								{
									//echo $arrFKInfo[$intFKCounter][1] . "<br>";
									if ($arrFKInfo[$intFKCounter][1]!=$strOurTable)
									{
										$strNameToUse.= " " .  LookupName($strDatabase,$arrFKInfo[$intFKCounter][1],$arrFKInfo[$intFKCounter][2], $record[$arrFKInfo[$intFKCounter][0]]);
									}
								//echo $arrFKInfo[$intFKCounter][1] . " " . $arrFKInfo[$intFKCounter][2] . "<br>";
									//echo $strNameToUse . "-<br>";
								}
								if (trim($strNameToUse)=="")
								{
									$strNameToUse="name unavailable";
								}
								//echo "x" . $strNameToUse . "x";
								$intUnnameditemcount++;
							}
							
							//actually display tiny thumbnails if this is a pic
							$strNameForJS=ltrim(simplelinkbody($strNameToUse));
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
										$strNameToUse=   simplelinkbody($strNameToUse);
									}

								} 
								else
								{
								
									$strNameToUse=   simplelinkbody($strNameToUse);
								} 
							
							}
							else
							{
					
								$strNameToUse= simplelinkbody($strNameToUse);
							}
			 
							//$strNameToUse=simplelinkbody($strNameToUse);
							if($sorttools!="")
							{
								$js=" onclick='MAtrselectfromline(this,\"" . $thisset . "\");' onfocus='groovify(this, \"black\");' onmouseover='groovify(this, \"orange\");' onmouseout='degroovify(this);' onblur='degroovify(this);' " ;
							}
							$thistableinfo.="<tr ><td " . $js . ">&nbsp;</td><td width=\"20\">[<a onclick=\"javascript:return(popwindowwithconfirm('" .  qbuild($strPHP, $strDatabase, $strTheirTable, "delete", $strTheirIDColumnName,  $record[$strTheirIDColumnName]) . "&" . qpre . "extrajs=closeclickrecycle" . "',100,'" . $strNameForJS . "','" . $deletemethod . "'))\">x</a>]</td>";
							$thistableinfo.="<td " . $js . "><a onclick=\"javascript:return(popwindow('" . qbuild($strPHP, $strDatabase, $strTableToUse, "edit",  $strColumnNameToUse, $idToUse)   . "&" . qpre . "extrajs=closeclickrecycle',300))\">" . $strNameToUse  . "</a>";
							if($bwlEnableSortTools  && $sorttools!="")
							{
								//$thistableinfo.=HiddenInputs(Array("swapfieldd-" . $thisset . "-" . $sortitemcounter =>""),"");
								$thistableinfo.=RadioInput("swapfieldd-"  . $thisset . "-" . $sortitemcounter,  $idToUse, false,"",  "display:none");
							}
							$thistableinfo.="</td>\n";
							$thistableinfo.="</tr>\n";
							$numout++;
							$sortitemcounter++;
						}
						 
						$strMappedTable="";
						if (DuplicatesInThisField($fkrecords, "table_name", $strTheirTable))
							{
								$strTableToUse = $strTableToUse . " - " . ReturnNonIDPartOfName($fkrecord["column_name"]);
							
							}
						$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
						$out.="<tr><td colspan=\"2\" class=\"" . $strOtherLineClass . "\">";
						$out.=SpacerGif(1, 1);
						$out.="</td></tr>\n";
						$out.="<tr class=\"" . $strThisBgClass . "\"><td >\n";
						$out.="<p><b>" . $strTableToUse. ":</b>\n</td><td align=\"right\">"; 
						
						//$out.="</td></tr>\n";
						//echo $oldTable . " " . $strTheirTable . "<br>";
						

						$oldTable=$strTheirTable;
	 
						$out.="<a onclick=\"javascript:return(popwindow('" . qbuild($strPHP, $strDatabase, $strTheirTable, "new", $fkrecord["column_name"], $strOurID) . "&" . qpre . "extrajs=closeclickrecycle',300))\">(" . $addmethod  . ")</a>\n";


						//$out.="<a onclick=\"pickerwindow('". $strDatabase . "','" . $strTheirTable . "','".  $strFieldNamePrefix . $fkrecord["column_name"] ."','" . $strIDField . "','" . $strOurID ."')\">(add)</a>\n";
						//$out.=<a onclick=\"javascript:return(popwindow('" . qbuild($strPHP, $strDatabase, $strTheirTable, "new", $fkrecord["column_name"], $strOurID) . "&" . qpre . "extrajs=closeclickrecycle',300))\">(add" . " ". $strTableToUse . ")</a>\n";
						$out.="</td></tr><tr class=\"" . $strThisBgClass . "\"><td colspan=\"2\" >\n";
						$out.="<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">\n";
						$out.=$thistableinfo;
						$out.="</table>\n";
						if($numout>1)
						{
							$out.=$sorttools;
						}
						$out.="</td></tr>\n";
					}

						//end the inside of the if ($info["foreign"]==$strOurTable) 
			}
 
			if ($out!="")
			{
					$strDsiplayThisTable=$strSpecificFKTable;
					if ($strSpecificFKTable=="")
					{
						$strDsiplayThisTable="all";
					}
					$fkbase = qbuild("tf_foreign.php", $strDatabase, $strOurTable, "", $strIDField, $strOurID) . "&" . qpre . "extrajs=noextras&" . qpre . "iddefault=" . $strOurID;
					$outpre="<script src=\"multipleanswer_js.js\"><!-- --></script>\n";
					$outpre.="\n<form name=\"BForm\"><table class=\"" . $strOtherBgClass . "\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\">\n" . "<tr><td colspan=\"2\">";
					$outpre.=adminbreadcrumb(false,"Associated Items", $fkbase, $strDsiplayThisTable, "");
//<a href=\"" .$fkbase . "\" class=\"heading\">Associated Items</a> : <span class=\"heading\">" . $strDsiplayThisTable . "</span>
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
					$out.="</table></form>\n";
					
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