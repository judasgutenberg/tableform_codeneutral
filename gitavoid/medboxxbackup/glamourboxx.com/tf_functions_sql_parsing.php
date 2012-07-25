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

 
function ParseInsertIntoStatement($strSQL)
//returns an associative array of info
//return table name keyed to qpre . "tablename"
{
	$strSQL=deMultiple($strSQL, " ");
	$arrOut=Array();
	$strLen=strlen($strSQL);
	$firstparenloc=strpos($strSQL, "(");
	$secondparenloc=strpos($strSQL, ")", $firstparenloc);
	$thirdparenloc=strpos($strSQL, "(", $secondparenloc);
	$fourthparenloc=strpos($strSQL, ")", $thirdparenloc);
	$strRawFieldnames=substr($strSQL, $firstparenloc+1, $secondparenloc-$firstparenloc-1);
	$strRawFieldvalues=substr($strSQL, $thirdparenloc+1, $fourthparenloc-(1+$thirdparenloc));
	$spacebeforefirstparen=strrpos($strSQL, " ",  -($strLen- $firstparenloc));
	//echo $firstparenloc . "=" . $spacebeforefirstparen . "=<br>";
	if($spacebeforefirstparen+1==$firstparenloc)
	{
		$spacebeforefirstparen=strrpos($strSQL, " ", -($strLen- (1+ $firstparenloc)));
		
	}
	$tablename=substr($strSQL, $spacebeforefirstparen+1, ($firstparenloc-$spacebeforefirstparen-1));
	//echo $tablename . "*<br>";
	//echo  "*" . $thirdparenloc . " " .$fourthparenloc . " " .  $strRawFieldvalues. "*<br>";
	$strRawFieldnames=str_replace(" ", "", $strRawFieldnames);
	$arrFieldNames=ParseStringToArraySkippingQuotedRegions($strRawFieldnames,  "'\"",  ",");
	$arrValues=ParseStringToArraySkippingQuotedRegions($strRawFieldvalues,  "'\"",  ",");
	$i=0;
	foreach($arrFieldNames as $thisfieldname)
	{
	 	if($thisfieldname!="")
		{
			$arrOut[$thisfieldname]=trim($arrValues[$i]);
			$i++;
		}
	}
	$arrOut[qpre . "table"]=$tablename;
	return $arrOut;
}



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
	//echo  $strBeingSought . " " . $strEndKeywords . "<br>";
	//echo $out . "==initialwhere<br>";
	$out=trim($out);
	$tablecount=0;
	$intFromFromCounter=0; //counts how many terms are between the from statement and the on, join, or where
	//echo $out . "==initialwhere<br>";
	$out=AllWhiteSpaceToSpace($out);
	//echo $out . "==initialwhere<br>";
	if(contains($out, "(")  && strpos($out, "(")>0)//seems to fix not-working for insert sql
	{
		$arrOut[0]=substr( $out, 0, strpos($out, "("));
	}
	else if(contains($out, " "))
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
	///set_time_limit(10);
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

function ActSQL($strDatabase, $strPHP, $strSQL, $bwlTruncate, $bwlSuppressLogging=false, $bwlEditableResults=false, $strPostRunScript="", $intForeignLanguageID="", $bwlSuppressOutputIfNoResults=false, $bwlSuppressStatus=false, $sortappend="")
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
	$arrTablePKs=Array();
	$arrPKPositions=Array();
	$specialMessage="";
	$intThisSortLevel=intval($sortappend);
	$strSQLForLog=$strSQL;
	$subquerytablelist="";
	//echo $strSQL . "^^<p>";
	//GetBracketedContent(&$strIn, $chrStartBracket, $strEndBracket, $strQuote="' \"", $bwlRefHandback=false)
	$potentialSQL=GetBracketedContent($strSQL, "{", "}", "' \"", true);
	$arrSQL =ParseStringToArraySkippingQuotedRegions($strSQL);
	//dont log subquery bits or large sets of queries
	if(!$bwlSuppressLogging  && count($arrSQL)<5  && $sortappend=="") 
	{
		LogAdminScriptIfNovel($strDatabase, $strSQLForLog, $strPostRunScript, "sql");
	}
	if($sortappend=="")
	{
		$out= "<script src=\"tf_tablesort.js\"><!-- --></script>";
		$out.="<form name=\"SForm\" action=\"" . $strPHP . "\" method=\"post\">";
	}
	if( $strSQL!=""  && count($arrSQL)<1)
	{
		$specialMessage="The SQL you entered isn't parseable.  Check for an imbalance amongst quotes.";
	}
	//echo count($arrSQL) . "---<br>";
	for($i=0; $i<count($arrSQL); $i++) 
	{
 		$strThisBgClass=$strLineClass;
		$strSQL=$arrSQL[$i];
		//echo "<b>" . $sortappend . "</b><br>";
		//echo $strSQL . "<p>";
		//$strSQLForLog=$strSQL;
		//if($strSQL!="")
		//{
			//i used to extract this after the semicolon split, but what if i wanted multiple subqueries?
			//$potentialSQL=GetBracketedContent($strSQL, "{", "}");
			
			//if($potentialSQL!="")
			//{
				//get rid of the subquery
				//i do this now with the refhandback capabilitity of GetBracketedContent
				//$strSQL=str_replace("{". $potentialSQL . "}", "", $strSQL);
			//}
		//}
		//echo "<br>=" . $potentialSQL;
		//echo "<br>#" . $strSQL;


		$strQHTMLOut="";
		//echo "<br>" . strlen(trim($strSQL)) . "===<br>";
		$strSQL=trim($strSQL);
		if ($strSQL!="")
		{	
			$bwlCanRunSQL=true;
			if(!CanChange() || !IsRefererTheSameAsHost())
			{
				$analyzesql=strtolower($strSQL);
				
				if(contains($analyzesql, "update")  || contains($analyzesql, "insert") || contains($analyzesql, "truncate")  || contains($analyzesql, "alter") || contains( $analyzesql, "delete") || contains($analyzesql,"create") || contains($analyzesql,"grant")  || contains($analyzesql,"lock"))
				{
					if(!beginswith($analyzesql, "show "))
					{
						$bwlCanRunSQL=false;
					}

				}
				
			}
			if($bwlCanRunSQL)
			{
				//echo $strDatabase . "<br>";
				$rows =  $sql->query($strSQL, true, $strDatabase);
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
						$strQHTMLOut.= "\n\n<tr class=\"" . $strThisBgClass . "\">";
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
								$strQHTMLOut.="<td valign=\"top\">\n";
								$strQHTMLOut.="<a href=\"javascript: SortTable('idsorttable"  . $i . $sortappend . "', " . $intHeadfieldCount . ")\">" . $k . "</a>";
								$strQHTMLOut.="</td>";
								$intHeadfieldCount++;
							}
							//for delete:
							$strQHTMLOut.="\n<td>&nbsp;</td>\n";
							$strQHTMLOut.="\n</tr>\n";
							$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
							$strQHTMLOut.= "\n\n<tr class=\"" . $strThisBgClass . "\">";
						}
						$intFieldCount=0;
						$knownfieldcount=count($record);
						$extrasubqueryresult="";
						foreach($record as $k=>$v)
						{
					 
					 
							$strQHTMLOut.="\n<td valign=\"top\">";
							
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
								$thisatag="<a href=\"" . qbuild("tf.php", $strDatabase, $thislinktable, "edit", urlencode($thislinkpk), $v)  .   $keyserialized . "\">";
								//$thislashatag="</a>";
							}
							//$strQHTMLOut .= $thisatag;
						 
							//$strQHTMLOut.=str_replace(chr(10), chr(10) . "<br/>" , $v);
					
							//TextInput($name, $default, $size, $onClick="",  $strClass="", $strStyle="")
							if($bwlEditableResults)
							{
								if(contains($k, "_id") || beginswith($k,"sort" ) ||  endswith($k,"id" ) )  //a wee bit hacky to make editable forms more reasonable
								{
									$editableformlength=5;
								}
								elseif(strlen($v)==1)
								{
									$editableformlength=2;
								}
								else
								{
									$editableformlength=abs(20-$knownfieldcount)*4;
								}
								//there's a bug here that causes $thislinkpk to come up empty if it isn't mentioned first in the select list
								$thislinkpk=str_replace(" ", "|", $thislinkpk);
								//echo $thislinkpk . " " . $record[$thislinkpk] . "--<br>";
								$strThisPKVal=DelimitPKValues($record, $thislinkpk, "|");
								//echo $strThisPKVal. "++<br>";
								$formitemname=qpre . "field-" . $thislinktable . "-" .  $thislinkpk . "-" . $strThisPKVal . "-" . $k ;
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
									//$formitemname=qpre . "field-" . $thislinktable . "-" .  $thislinkpk . "-" . $strThisPKVal . "-" . $k ;
									$strQHTMLOut.=TextInput($formitemname, $v, $editableformlength, "", "inlineedit") . "\n";
								}
								if($intForeignLanguageID!="")//provide a form item for a translation
								{
									$translatedtext=GetTranslation($thislinktable, $k,  $record[$thislinkpk],  $intForeignLanguageID, "", true);
									$strQHTMLOut.="<br>" . TextInput($formitemname. "-lang-" . $intForeignLanguageID, $translatedtext, $editableformlength, "", "inlineedit") . "\n";
								
								
								}
							}
							else
							{
								if($strPostRunScript==""  || !contains($strPostRunScript, "$" . $k))//if there is no mention of the field name in the script, spit it out the usual way
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
									
									
									
									//ideally i'd make this so every field can refer to any other instead of just jumping if this field is mentioned
									$v=str_replace(chr(39), "&#39;", $v);
									//$v=str_replace("\\", "\\\\", $v);
									//$strFormula=str_replace("$" . $k, "\"" . $v . "\"", $strFormula);
									
									
									
									//echo $strPostRunScript . ":" .count($arrVars) ."=<BR>" ;
									
									$strFormula=FixFormulaForEval($strPostRunScript, true);
									$arrVars=FindDollarVariables($strFormula);
									//echo $strFormula . ":" .count($arrVars)."<BR>" ;
									if(is_array($arrVars))
									{
									//echo "+";
										foreach($arrVars as $thisinputvar)
										{
										 
						
											if($thisinputvar!="")
											{
												//echo $thisinputvar . " " . $record[$thisinputvar]  . "<br>";
												$strFormula=str_replace("$" . $thisinputvar, "\"" . $record[$thisinputvar] . "\"", $strFormula);
											}
											//echo $strFormula . "<br>";
										}
									}
									
									
									
									
									
									
									
									
									
									
									
								//	echo "-" .  $strFormula . "-<br>";
									if(trim($strFormula)!="")
									{
										$strFormula='$returnval=' . $strFormula . ";";
										//echo $strFormula . "=form<P>";
										eval($strFormula );
										//echo $returnval ."=rval<P>";
										//echo $value . "=val<P>";
										$v=$returnval;
										$strQHTMLOut.=$thisatag . $v . IfAThenB($thisatag, "</a>");
									}
									else
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
								}
							}
							$strFormula="";
							//$strQHTMLOut .= $thislashatag;
	
							$strQHTMLOut.="</td>";
							$intFieldCount++;
						}
						$strQHTMLOut.="<td><a onclick=\"javascript:return(confirm('Are you sure you want to delete " . $thislinktable . " number " . $record[$thislinkpk] . "?'))\" href='" . qbuild("tf.php", $strDatabase,$thislinktable, "delete", $thislinkpk, $record[$thislinkpk]) .$keyserialized  . "&" . "'>Delete</a></td>";

						$intRowCount++;
						$strQHTMLOut.="\n</tr>\n";
						
			
						//$potentialSQL=FixFormulaForEval($potentialSQL, true);
						//echo "<br>----" . $potentialSQL . "---<br>";
						if($potentialSQL!="")
						{	
						
							$arrTableSQL =ParseStringToArraySkippingQuotedRegions($potentialSQL);
							$subquerytablelist="";
							$subquerytablesfound=0;
							foreach($arrTableSQL as $thisSQL)
							{
								if(trim($thisSQL)!="")
								{
			 						$tables=FindTables($thisSQL, true);
									$subquerytablelist.= "<br>" . join("<br>", $tables);
									$subquerytablesfound+=count($tables);
								}
							}
							$potentialSQLRaw=$potentialSQL;
							//echo $potentialSQL . "&&<br>";
							
							//
							$firstBracket=strpos($potentialSQL, "{");
							$varSQL=$potentialSQL;
							if($firstBracket>0)
							{
								$varSQL=substr($potentialSQL, 0, $firstBracket );
							}
							$arrVars=FindDollarVariables($varSQL);
							$subquerySQL=$potentialSQL;
							if(is_array($arrVars))
							{
								foreach($arrVars as $thisinputvar)
								{
								
									//echo $thisinputvar . "=<br>";
									if($thisinputvar!="")
									{
										 //echo $thisinputvar . " " . $record[$thisinputvar]  . "<br>";
										$subquerySQL=str_replace("$" . $thisinputvar, "'" . $record[$thisinputvar] . "'", $subquerySQL);
										//echo $subquerySQL . "+<br>";		
									}
								
								}
							}
							//$subrows =  $sql->query($potentialSQL, true, $strDatabase);
							//echo $potentialSQL . "<br>";
							//$strQHTMLOut.=GenericRSDisplay($strDatabase, $strPHP,"stank", $potentialSQL, 50, 300, $k); 				
							//echo "%" . $subquerySQL . "%<br>";
							
							//ActSQL($strDatabase, $strPHP, $strSQL, $bwlTruncate, $bwlSuppressLogging=false, $bwlEditableResults=false, $strPostRunScript="", $intForeignLanguageID="", $bwlSuppressOutputIfNoResults=false, $bwlSuppressStatus=false, $sortappend="")
							//echo $subquerySQL . "*****<br>";
							//$sortappend++;
						
					 		// echo $sortappend . " " . $sortappend .  "-" .  intval($intThisSortLevel++) . "\n";
							//echo "<br>---" .  $subquerySQL . "-----------<br>";
							$extrasubqueryresult=ActSQL($strDatabase, $strPHP, $subquerySQL, $bwlTruncate, true, false, $strPostRunScript, $intForeignLanguageID, true, true,  $sortappend ."^" .    intval($intThisSortLevel++) );
							//echo "-" . $extrasubqueryresult . "-<br>";
							//$strFormula=str_replace("{" . $potentialSQLRaw ."}" , "", $strFormula);
			 
						}
						
						
						if($extrasubqueryresult!="")
						{
							//echo mysql_error() . "+<br>";
							//$strQHTMLOut.="\nxxxx<tr>\n";
							$strQHTMLOut.="\n\n<tr>";
							$strQHTMLOut.="\n<td>";
							$strQHTMLOut.=PluralizeIfNecessary("subquery", $subquerytablesfound) . " of:<br>";
							
							$strQHTMLOut.=$subquerytablelist;
							$strQHTMLOut.="</td>\n";
							$strQHTMLOut.="<td colspan=\"" . intval($intFieldCount) . "\">\n";
							$strQHTMLOut.=$extrasubqueryresult;
							$strQHTMLOut.="</td>\n";
							$strQHTMLOut.="\n</tr>\n";
							$extrasubqueryresult="";
						}
			
						$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
						
					}
					if($strQHTMLOut!="")
					{
				 
					 	if(!$bwlSuppressLogging  && !$bwlSuppressStatus)
						{
							$head.= "\n<tr name=\"sortavoid\"><td colspan=\"" .  $intFieldCount . "\">\n";
							$head.="<b>Results of Query #" . intval($i+1) . "</b>";
							$head.= "</td>\n</tr>\n";
						}
						
						$strQHTMLOut=$head . $strQHTMLOut;
						$head="";
						//echo "idsorttable" . $sortappend . $i . "<br>";
						$out.=TableEncapsulate($strQHTMLOut, true, "100%", "idsorttable" .  $i. $sortappend); 
					 
					}
					if(!$bwlSuppressStatus)
					{
						$out.="<br>" . $intAffectedRows . " " . PluralizeIfNecessary("row", $intAffectedRows) . " affected. " . mysql_info() . "<br>" . mysql_stat();
					}
				}
				else
				{
 
					$errorout= "\n<tr>\n";
					$errorout.="<td valign=\"top\" class=\"" .$strLineClass  . "\" >";
					$errorout.="<span class=\"heading\">Errors:</span>";
					$errorout.= "</td></tr>\n";
					$errorout.= "\n<tr class=\"" . $strClassFirst . "\">";
					$errorout.="<td valign=\"top\"  >";
					$errorout.=$strErrors;
				
					$errorout.= "</td></tr>\n";
					$out.= "<p>" . TableEncapsulate($errorout, false) . "</p>";
				}
			}
			else
			{
	
				$errorout= "<tr>\n";
				$errorout.="<td valign=\"top\" class=\"" .$strLineClass  . "\" >";
				$errorout.="<span class=\"heading\">Errors:</span>";
				$errorout.= "</td></tr>\n";
				$errorout.= "<tr class=\"" . $strClassFirst . "\">\n";
				$errorout.="<td valign=\"top\"  >";
				$errorout.="Query contained forbidden actions for read-only mode.";
			
				$errorout.= "</td></tr>\n";
				$out.= "<p>" . TableEncapsulate($errorout, false) . "</p>";
			}
		}
	}
	if($bwlEditableResults)
	{
		$out.= HiddenInputs(array("db"=>$strDatabase,  "language_id"=>$intForeignLanguageID, "actscript"=>$strSQL, "mode"=>"entersql", "directediting"=>$bwlEditableResults));
		$out.="<div align=\"right\">";
		
		$out.=GenericInput(qpre . "editresults", "Save Data Edits");
		$out.="</div>";
	}
	if($specialMessage!="")
	{
		$out.="<div class=\"feedback\">" . $specialMessage . "</div>";
	}
	if($sortappend=="")
	{
		$out.="</form>";
	}
	//$out.= "<a href=\"javascript:domdumpwindow()\">dump</a>";
	if($bwlSuppressOutputIfNoResults  && $intRowCount==0)
	{
		return "";
	}
	else
	{
		return $out;
	}
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
			//handle language equivalents:
			//language fields being sought: $formitemname. "-lang-" . $intForeignLanguageID
			if(count($arrK)>5)
			{
				$language_id=$arrK[5];
				if(is_numeric($language_id) && $language_id!="")
				{
					$arrThisTransSpec=Array("entity_id"=>$strThisPK, "language_id"=>$language_id, "field_name"=>$strFieldName, "table_name"=>$strTable);
					//if($v!="")
					{
						$arrThisTranslation=Array("translation_value"=>$v);
						UpdateOrInsert($strDatabase, "translation",$arrThisTransSpec, $arrThisTranslation,  true,  true);
					}
				}
			}
			else if($strThisPK!=$strOldThisPK )
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
						$error=sql_error();
						if($error!="")
						{
							$out.=$error. "<br>\n";
						}
						//echo $strSQL .  "<br>";
						//echo sql_error() .  "<p>";
						//clear $strSQL
					}
					
				}
				if($v!="")
				{
					$strSQL=$strFieldName . "='" . $v . "',";
				}
				//echo "<br>";
			}
			else
			{
				//echo "$";
				if($v!="")
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
		//echo $strSQL .  "<br>";
		//echo sql_error() .  "<p>";
		$records =  $sql->query($strSQL);
		$error=sql_error();
		if($error!="")
		{
			$out.=$error. "<br>\n";
		}
		//clear $strSQL
		$strSQL="";
	}
	return $out;
}
//$thatter='Some left over pics from when I was in Japan. Eating sushi is all the rage. Especially when it\'s the size of a whale.[img:f6efbefd47]http://www.hudsonent.com/images/misc/behind14.jpg';
//echo parseTwoPartBetween($thatter, '[img:', ']', '[/img');
//die();
 

?>