<?php
//////////////////////////////////////////////////////////////
//Judas Gutenberg December 13 2007///////////////////////////
////////////////////////////////////////////////////////////
/////sql parsing library///////////////////////////////////
//////////////////////////////////////////////////////////
//allows the PHP to make some decisions based on the/////
//SQL passed to it, either by some other PHP process////
//or directly from an administratron///////////////////
//////////////////////////////////////////////////////
//This code is covered under the GNU General Public License
//info here: http://www.gnu.org/copyleft/gpl.html
//the digest is as follows: you cannot modify this code without
//publishing your source code under the same license
//contact the developer at gus@asecular.com  http://asecular.com
////

//FindTables("select * from ecoperks.user u join ecoperks.ot_answer a on u.user_id=a.answer_id");

function FindTables($strSQL, $bwlStripDatabase=true)
{
	//returns an array of table names from a select statement and possibly other forms of SQL
	$strSQL=$strSQL . " ";
	$strSQL=deMultiple($strSQL, " ");
	$arrOut=Array();
	if(contains(strtolower($strSQL), "insert into"))
	{
		$strBeingSought="insert into";
		$strSelectStatementKeywords="(";
		$strEndKeywords="values (";
	}
	else if(contains(strtolower($strSQL), "create table"))
	{
		return Array(); //cop out on this case
	}
	else if(contains(strtolower($strSQL), "drop table"))
	{
		return Array(); //cop out on this case
	}
	else if(contains(strtolower($strSQL), "truncate table"))
	{
		return Array(); //cop out on this case
	}
	else
	{
		$strBeingSought="from";
		$strSelectStatementKeywords="join";
		$strEndKeywords="where group having order limit procedure into for";
	}
	
	$strSelectStatementNixFollow="on";
	$strSelectStatementNixPre="on join";
	
	$bwlNixfollow=false;
	$out= FindSQLClause($strSQL, $strBeingSought, $strEndKeywords);
	//echo $out . "==initialwhere<br>";
	$out=trim($out);
	$tablecount=0;
	$intFromFromCounter=0; //counts how many terms are between the from statement and the on, join, or where
	//echo $out . "==initialwhere<br>";
	$out=AllWhiteSpaceToSpace($out);
	//echo $out . "==initialwhere<br>";
	if(contains($out, " "))
	{
		$out=deMultiple($out, " ");//might want to leave whitespace in quoted areas alone in a future version
		$arrTable=explode(" ", $out);
		
		foreach($arrTable as $thispart)
		{
			//echo $thispart . "==thispart<br>";
			if(PosInList($strSelectStatementNixPre, $thispart,  " ",  true, $quotechar="'")>-1)
			{  
				//echo "prenix<br>";
				//echo $intFromFromCounter . "==fromfrom<br>";
				if($intFromFromCounter==2) //in other words, if there is, due to the count of terms since the from, clearly a synonymn after the table name
				{
					//these sql terms mean what preceded was not a table
					//this code once assumed that join-containing sql will always have a synonym for the table after it 
					//but it no longer has this liability
					$tablecount--;
					array_pop($arrOut);
					//time to process $intFromFromCounter;
				}
				$intFromFromCounter=0;
			}
			if(PosInList($strSelectStatementKeywords, $thispart,  " ",  true, $quotechar="'")>-1)
			{
				$bwlNixfollow=false;
				//echo "nixfollowfalse1<br>";
			}
			else if(PosInList($strSelectStatementNixFollow, $thispart,  " ",  true, $quotechar="'")>-1)
			{
				//echo "nixfollowtrue1<br>";
				$bwlNixfollow=true;
			}
			else if(!$bwlNixfollow)
			{
				$intFromFromCounter++;
				$bwlNixfollow=false;
				$arrOut[$tablecount]=StripDBfromTableSpecIfThere($thispart, $bwlStripDatabase);
				$tablecount++;
			}
			else
			{
				//echo "else<br>";
			}
		}
	}
	else
	{
		$arrOut[$tablecount]=StripDBfromTableSpecIfThere($out, $bwlStripDatabase);
	}
	//echo join("<br>", $arrOut) . "==tables<p>";
	return $arrOut;
}

function StripDBfromTableSpecIfThere($strTableSpec, $bwlStripDatabase=true)
{
	if( $bwlStripDatabase)
	{
		if(contains($strTableSpec, "."))
		{
			$arrParts=explode(".", $strTableSpec);
			$strTableSpec=$arrParts[1];
		}
	}
	$strTableSpec=FilterString($strTableSpec,"a-z A-Z 0-9 _-_ .-.", "");
	return $strTableSpec;	
}

function FindWhereClause($strSQL)
{
	$strBeingSought="where";
	$strEndKeywords="group having order limit procedure into for";
	return FindSQLClause($strSQL, $strBeingSought, $strEndKeywords);
}

function FindSQLClause($strSQL, $strBeingSought, $strEndKeywords)
{
	//finds and returns the where condition in SQL
	set_time_limit(10);
	//$strBeingSought="where";
	//$strEndKeywords="group having order limit procedure into for";
	$strLcaseSQL=strtolower($strSQL);
	$intSoughtPos=strpos($strLcaseSQL, $strBeingSought);
	
	$strPossibleClause=substr($strSQL, $intSoughtPos + strlen($strBeingSought));
	$intPostEnd=strlen($strPossibleClause);
	//echo $intPostEnd; 
	$intOldPostEnd=-900;
	while($intPostEnd>0  && $intOldPostEnd!=$intPostEnd)
	{
		$intOldPostEnd=$intPostEnd;
		$intPostEnd=PosInList($strEndKeywords, $strPossibleClause,  " ",  true, $quotechar="'");
		//echo $intPostEnd . "=poswhere<br>";
		$strPossibleClause=substr($strPossibleClause, 0, $intPostEnd);
		//echo $strPossibleClause . "=posclaus<br>"; 
	}
	//echo  $strPossibleClause;
	return $strPossibleClause;
}	

function IsolateWhereClause($strSQL)
{
	//finds and returns the where condition in SQL
	set_time_limit(10);
	$strBeingSought="where";
	$strEndKeywords="limit group having order procedure into";
	$strLcaseSQL=strtolower($strSQL);
	$intSoughtPos=strpos($strLcaseSQL, $strBeingSought);
	$strPossibleWhereClause=substr($strSQL, $intSoughtPos + strlen($strBeingSought));
	$intPostEndWhere=strlen($intPostEndWhere);
	while($intPostEndWhere>-1)
	{
		$intPostEndWhere=PosInList($strBeingSought, $strPossibleWhereClause,  " ",  true, $quotechar="'");
		//echo $intPostEndWhere . "=poswhere<br>";
		$strPossibleWhereClause=substr($strPossibleWhereClause, 0, $intPostEndWhere);
	}
	return $strPossibleWhereClause;
}	

function ActSQL($strDatabase, $strPHP, $strSQL, $bwlTruncate, $bwlSuppressLogging=false, $bwlEditableResults=false, $strPostRunScript="")
//runs $strSQL (handling every line if they are separated by ";") and displays results in labeled HTML tables
//also shows errors if there are problems
//Judas Gutenberg, nov 26 2006
{
	$sql=conDB();
	mysql_select_db($strDatabase);
	$strLineClass="bgclassline";
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strOtherBgClass="bgclassother";
	$strOtherLineClass="bgclassline";
	$strThisBgClass=$strLineClass;
	$arrTablePKs=Array();
	$arrPKPositions=Array();
	$specialMessage="";
	$arrSQL =ParseStringToArraySkippingQuotedRegions($strSQL);
	$out= "<script src=\"tablesort_js.js\"><!-- --></script>";
	
	$out.="<form name=\"SForm\" action=\"" . $strPHP . "\" method=\"post\">";
	if( $strSQL!=""  && count($arrSQL)<1)
	{
		$specialMessage="The SQL you entered isn't parseable.  Check for an imbalance amongst quotes.";
	}
	for($i=0; $i<count($arrSQL); $i++) 
	{
		
		$strSQL=$arrSQL[$i];
		if(!$bwlSuppressLogging  && count($arrSQL)<5)
		{
			LogAdminScriptIfNovel($strDatabase, $strSQL, $strPostRunScript, "sql");
		}

		$strQHTMLOut="";
		//echo "<br>" . strlen(trim($strSQL)) . "===<br>";
		$strSQL=trim($strSQL);
		if ($strSQL!="")
		{	
			$bwlCanRunSQL=true;
			if(!CanChange())
			{
				$analyzesql=strtolower($strSQL);
				
				if(contains($analyzesql, "update")  || contains($analyzesql, "insert") || contains($analyzesql, "truncate")  || contains($analyzesql, "alter") || contains( $analyzesql, "delete") || contains($analyzesql,"create") || contains($analyzesql,"grant")  || contains($analyzesql,"lock"))
				{
					$bwlCanRunSQL=false;

				}
				
			}
			if($bwlCanRunSQL)
			{
				$rows =  $sql->query($strSQL);
				//echo sql_error() . "=<br>";
				$strErrors=sql_error();
				$intAffectedRows=mysql_affected_rows();
				$tablesaffected=FindTables($strSQL, true);
				for($tablecount=0; $tablecount<count($tablesaffected); $tablecount++)
				{
					$arrTablePKs[$tablecount]=PKLookup($strDatabase, $tablesaffected[$tablecount]);
					if(contains($arrTablePKs[$tablecount], " "))
					{
						$strPKList=$arrTablePKs[$tablecount];
					}
				}
				$intRowCount=0;
				
				if ($strErrors=="")
				{
					foreach ($rows as $record )
					{
						$strQHTMLOut.= "\n<tr class=\"" . $strThisBgClass . "\">\n";
						if($intRowCount==0)
						{
							$intHeadfieldCount=0;
							foreach($record as $k=>$v)
							{
								if(in_array($k, $arrTablePKs))
								{
									
									$pkpos=array_search($k, $arrTablePKs);
									$arrPKPositions[$pkpos]=$intHeadfieldCount;
									//echo $pkpos. " == " . $intHeadfieldCount . "<br>";
								}
								
								//so now we have three parallel arrays:
								//$tablesaffected, $arrTablePKs, and $arrPKPositions
								//so later when we want to link the data we have all the info we need to make the right links
								$strQHTMLOut.="<td valign=\"top\">";
								$strQHTMLOut.="<a href=\"javascript: SortTable('idsorttable" . $i ."', " . $intHeadfieldCount . ")\">" . $k . "</a>";
								$strQHTMLOut.="</td>";
								$intHeadfieldCount++;
							}
							$strQHTMLOut.="</tr>\n";
							$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
							$strQHTMLOut.= "<tr class=\"" . $strThisBgClass . "\">\n";
						}
						$intFieldCount=0;
						foreach($record as $k=>$v)
						{
							$strQHTMLOut.="<td valign=\"top\">";
							
							//$tablesaffected, $arrTablePKs, and $arrPKPositions
							$thisatag="";
							//$thislashatag="";
							//echo $intRowCount . "<br>";
							if(in_array($intFieldCount, $arrPKPositions)  || inList($strPKList, $k))//if this position is the name of PK
							{
								//echo $intFieldCount. " == "    ."<br>";
								//echo $strPKList  . "<br>";
								if($strPKList!="")
								{
									$keyserialized='&' . qpre . 'ks=' . urlencode(serialize(ArraySubsetFromList($strPKList, $record)));
								}
								$fieldhit=array_search($intFieldCount, $arrPKPositions);
								//$keyserialized="";//dont worry about compound pks for now
								$thislinktable=$tablesaffected[$fieldhit];
								$thislinkpk=$arrTablePKs[$fieldhit];
								$thisPK=$v;
								//echo $keyserialized . "<br>";
								$thisatag="<a href=\"" . qbuild("tableform.php", $strDatabase, $thislinktable, "edit", urlencode($thislinkpk), $v)  .   $keyserialized . "\">";
								//$thislashatag="</a>";
							}
							//$strQHTMLOut .= $thisatag;
						 
							//$strQHTMLOut.=str_replace(chr(10), chr(10) . "<br/>" , $v);
					
							//TextInput($name, $default, $size, $onClick="",  $strClass="", $strStyle="")
							if($bwlEditableResults)
							{
								$thislinkpk=str_replace(" ", "|", $thislinkpk);
								//echo $thislinkpk . " " . $record[$thislinkpk] . "--<br>";
								$strThisPKVal=DelimitPKValues($record, $thislinkpk, "|");
								//echo $strThisPKVal. "++<br>";
								if($strThisPKVal=="error")
								{
									if($bwlTruncate)
									{
										$strQHTMLOut.= $thisatag . str_replace(chr(10), chr(10) . "<br/>" , $v) . IfAThenB($thisatag, "</a>");
									}
									else
									{
										$strQHTMLOut.=$thisatag . simplelinkbody($v) . IfAThenB($thisatag, "</a>");
									}
									$bwlEditableResults=false;
									$specialMessage="Query must select all components of the table's primary key in order to produce editable results.";
								}
								else
								{
									$formitemname=qpre . "field-" . $thislinktable . "-" .  $thislinkpk . "-" . $strThisPKVal . "-" . $k ;
									$strQHTMLOut.=TextInput($formitemname, $v, 20, "", "inlineedit") . "\n";
								}
							}
							else
							{
								if($strPostRunScript==""  || !contains($strPostRunScript, $k))//if there is no mention of the field name in the script, spit it out the usual way
								{
									if(!$bwlTruncate)
									{
										$strQHTMLOut.= $thisatag . str_replace(chr(10), chr(10) . "<br/>" , $v) . IfAThenB($thisatag, "</a>");
									}
									else
									{
										$strQHTMLOut.=$thisatag . simplelinkbody($v) . IfAThenB($thisatag, "</a>");
									}
								}
								else
								{
									$strFormula=FixFormulaForEval($strPostRunScript);
									$strFormula=FixFormulaForEval($strFormula);
									$v=str_replace(chr(39), "&#39;", $v);
									//$v=str_replace("\\", "\\\\", $v);
									$strFormula=str_replace($k, "\"" . $v . "\"", $strFormula);
									$strFormula='$returnval=' . $strFormula . ";";
									//echo $strFormula . "=form<P>";
									eval($strFormula );
									//echo $returnval ."=rval<P>";
									//echo $value . "=val<P>";
									$v=$returnval;
									$strQHTMLOut.=$thisatag . $v . IfAThenB($thisatag, "</a>");
								}
							}
							 
							//$strQHTMLOut .= $thislashatag;
							$strQHTMLOut.="</td>";
							$intFieldCount++;
						}
						$intRowCount++;
						$strQHTMLOut.="</tr>\n";
						$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
						
					}
					if($strQHTMLOut!="")
					{
						$head= "\n<table id=\"idsorttable" . $i . "\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\" class=\"" .$strLineClass  . "\"  >\n";
					 	if(!$bwlSuppressLogging)
						{
							$head.= "<tr name=\"sortavoid\"><td colspan=\"" .  $intFieldCount . "\">\n";
							$head.="<b>Results of Query #" . intval($i+1) . "</b>";
							$head.= "</td></tr>\n";
						}
					
						$strQHTMLOut=$head . $strQHTMLOut . "</table>";
						$strQHTMLOut.="<script>NumberRows('idsorttable" . $i . "', " . intval(intval($intHeadfieldCount)-1) . ");</script><p/>";
						$out.=$strQHTMLOut;
					}
					$out.="<br>" . $intAffectedRows . " " . PluralizeIfNecessary("row", $intAffectedRows) . " affected. " . mysql_info() . "<br>" . mysql_stat();
				}
				else
				{
					$out.= "<p><table border=\"0\" cellspacing=\"1\" cellpadding=\"2\" class=\"" .$strLineClass  . "\"  >\n";
					$out.= "<tr>\n";
					$out.="<td valign=\"top\" class=\"" .$strLineClass  . "\" >";
					$out.="<span class=\"heading\">Errors:</span>";
					$out.= "</td></tr>\n";
					$out.= "<tr class=\"" . $strClassFirst . "\">\n";
					$out.="<td valign=\"top\"  >";
					$out.=$strErrors;
				
					$out.= "</td></tr>\n";
					$out.="</table></p>";
				}
			}
			else
			{
				$out.= "<p><table border=\"0\" cellspacing=\"1\" cellpadding=\"2\" class=\"" .$strLineClass  . "\"  >\n";
				$out.= "<tr>\n";
				$out.="<td valign=\"top\" class=\"" .$strLineClass  . "\" >";
				$out.="<span class=\"heading\">Errors:</span>";
				$out.= "</td></tr>\n";
				$out.= "<tr class=\"" . $strClassFirst . "\">\n";
				$out.="<td valign=\"top\"  >";
				$out.="Query contained forbidden actions for read-only mode.";
			
				$out.= "</td></tr>\n";
				$out.="</table></p>";
			}
		}
	}
	if($bwlEditableResults)
	{
		$out.= HiddenInputs(array("actscript"=>$strSQL, "mode"=>"entersql", "directediting"=>$bwlEditableResults));
		$out.="<div align=\"right\">";
		
		$out.=GenericInput(qpre . "editresults", "Save Data Edits");
		$out.="</div>";
	}
	if($specialMessage!="")
	{
		$out.="<div class=\"feedback\">" . $specialMessage . "</div>";
	}
	$out.="</form>";
	//$out.= "<a href=\"javascript:domdumpwindow()\">dump</a>";
	return $out;
}

function DelimitPKValues($record, $strDelimitedPKNames, $delimiter)
//if $strDelimitedPKNames is a $delimiter-delimited list of PK components, this returns a $delimiter-delimited
//list of values from those components read from $record.  Otherwise returns $record[$strDelimitedPKNames].
{
	$strOut="";
	if(contains($strDelimitedPKNames, $delimiter))
	{
		$arrThisPK=explode($delimiter, $strDelimitedPKNames);
		{
			foreach($arrThisPK as $thisPKPiece)
			{
				//echo $record[$thisPKPiece] . " " . $thisPKPiece . "<br>";
				///echo $thisPKPiece . "<br>";
				if($record[$thisPKPiece]!=""  && $thisPKPiece!="")
				{
					$strOut.=$record[$thisPKPiece] . $delimiter;
				}
				else
				{
					//echo "z<br>";
					return "error";
				}
			}
			$strOut=RemoveLastCharacterIfMatch($strOut, $delimiter);
		}
	}
	else
	{
		//echo $record[$thisPKPiece] . " " . $thisPKPiece . "<br>";
		if($record[$strDelimitedPKNames]!=""  && $strDelimitedPKNames!="")
		{
			$strOut=$record[$strDelimitedPKNames];
			
		}
		else
		{
			//echo "$";
			return "error";
		}
	}
	return $strOut;
}
		
function DelimitedPKToWhereComponent($strDelimitedPKName, $strDelimitedPK, $delimiter)
//takes two strings delimited by $delimiter, one a set of keys the other a set of values,
//and makes a SQL where clause out of them (minus the actual WHERE).
{
	$strOut="";
	$arrPKName=explode( $delimiter, $strDelimitedPKName);
	$arrPKVal=explode( $delimiter, $strDelimitedPK);
	for($i=0; $i<count($arrPKName); $i++)
	{
		$strOut.=" " . $arrPKName[$i] . "='" . $arrPKVal[$i] . "'";
		if($i<count($arrPKName)-1)
		{
			$strOut.=" AND";
		}
		if($arrPKVal[$i]=="")
		{
			return "error";
		}
	}
	return $strOut;
}
		
						
function SaveDataEdits($strDatabase)
{
	$sql=conDB();
	$strBeingSought= qpre. "field-";
	$strOldTable="";
	$strOldThisPK="";
	$strSQL="";
	$out="";
		
	foreach($_REQUEST as $k=>$v)
	{
		//echo $k . "<br>";
		if(beginswith($k, $strBeingSought))
		{
			 
			//really have a fucking dataedit form
			//$formitemname=qpre . "field-" . $thislinktable . "-" .  $thislinkpk . "-" . $thisPK . "-" . $k ;
			
			$strToWorkWith=substr($k, strlen($strBeingSought) );
			$arrK=explode("-", $strToWorkWith);
			$strTable=$arrK[0];
			$strThisPK=$arrK[2];
			//echo $strThisPK . "<br>";
			$strPKName=$arrK[1];
			$strFieldName=$arrK[3];
			if($strThisPK!=$strOldThisPK )
			{
				//echo $k . " " . $strBeingSought . "<br>";
				//finalize created sql...
				if($strSQL!="")
				{
					$strSQL= RemoveLastCharacterIfMatch($strSQL, ",");
					$strSQL="UPDATE " . $strDatabase . "." . $strOldTable . " SET " . $strSQL;
					$strWhereComponent=DelimitedPKToWhereComponent($strOldPKName, $strOldThisPK, "|");
					if($strWhereComponent=="error")
					{
						return "error";
					}
					else
					{
						$strSQL.= " WHERE " . $strWhereComponent;
						
						//execute sql...
						//echo $strSQL . "<br>";
						$records =  $sql->query($strSQL);
						$out.=sql_error() . "<br>\n";
						//clear $strSQL
					}
					
				}
				$strSQL=$strFieldName . "='" . $v . "',";
				
				//echo "<br>";
			}
			else
			{
				//echo "$";
				//if($k!=$strPKName)
				{
					$strSQL.=$strFieldName . "='" . $v . "',";
				}
			}
			$strOldTable=$strTable;
			$strOldPKName=$strPKName;
			$strOldThisPK=$strThisPK;
		
		}
	}
	
	if($strSQL!="") //pick up that last one
	{
		$strSQL= RemoveLastCharacterIfMatch($strSQL, ",");
		$strWhereComponent=DelimitedPKToWhereComponent($strOldPKName, $strOldThisPK, "|");
		$strSQL="UPDATE " . $strDatabase . "." . $strOldTable . " SET " . $strSQL;
		$strSQL.= " WHERE " . $strWhereComponent;
		
		//execute sql...
		//echo $strSQL . "<br>";
		$records =  $sql->query($strSQL);
		$out.=sql_error() . "<br>\n";
		//clear $strSQL
		$strSQL="";
	}
	return $out;
}
//$thatter='Some left over pics from when I was in Japan. Eating sushi is all the rage. Especially when it\'s the size of a whale.[img:f6efbefd47]http://www.hudsonent.com/images/misc/behind14.jpg';
//echo parseTwoPartBetween($thatter, '[img:', ']', '[/img');
//die();
 

?>