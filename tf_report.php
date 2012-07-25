<?php
//Judas Gutenberg Nov 28 2007
//produces reports based on the data in the database
//This code is covered under the GNU General Public License
//info here: http://www.gnu.org/copyleft/gpl.html
//the digest is as follows: you cannot modify this code without
//publishing your source code under the same license
//contact the developer at gus@asecular.com  http://asecular.com
//jesus died for my ass
 
set_time_limit(900);
include_once('tf_functions_backup.php');
include_once('tf_functions_core.php');
include_once('tf_functions_frontend_db.php');
include_once('tf_functions_report.php');
include_once('tf_core_table_creation.php');
include_once('tf_functions_sql_parsing.php');

echo main();

function main()
{
	if(!IsExtraSecure())
	{
		die(ExtraSecureFailure());
	}
	ini_set('memory_limit','450M');
	$strTable=tfpre . "report";//gracefuldecay($_REQUEST[qpre . "newtable"], $_REQUEST[qpre . "table"]);
	$strDatabase=deMoronizeDB(gracefuldecay($_REQUEST[qpre . "db"],our_db));
	$mode=$_REQUEST["mode"];
	$scriptlog_id=$_REQUEST["scriptlog_id"];
	$script=$_REQUEST["script"];
	$name=$_REQUEST["name"];
	$strPHP=$_SERVER['PHP_SELF'];
	$sql=conDB();
		
	if(!FieldExists($strDatabase, tfpre . "scriptlog", "name"))
	{
		$strSQL="ALTER TABLE " . $strDatabase . "." . tfpre . "scriptlog ADD COLUMN name VARCHAR(50)";
		$sql->query($strSQL);
	}
	 
	$out=LoginDecisions($strDatabase,  $strPHP, $strUser, $supressheaders);
	//echo $strDatabase;
	if ($strUser!="")
	{
		if($scriptlog_id>0)
		{
			if($mode=="generate")
			{
				$out.= adminbreadcrumb(false,  $strDatabase, "tf.php?" . qpre . "db=" . $strDatabase,  "reports", $strPHP . "?" . qpre . "db=" . $strDatabase,  "generate report") ;
			}
			else
			{
				$out.= adminbreadcrumb(false,  $strDatabase, "tf.php?" . qpre . "db=" . $strDatabase,  "reports", $strPHP . "?" . qpre . "db=" . $strDatabase,  "edit report") ;
			}
			
		}
		else
		{
			$out.= adminbreadcrumb(false,  $strDatabase, "tf.php?" . qpre . "db=" . $strDatabase,  "reports", $strPHP . "?" . qpre . "db=" . $strDatabase ) ;	
		}
		$intAdminType= AdministerType($strDatabase, $strTable, $strUser);
		
		if ($intAdminType>1)
		{
			
			if($mode=="save")
			{
	 
				$report_id=UpdateOrInsert($strDatabase,tfpre . "scriptlog", Array( "scriptlog_id"=>$scriptlog_id), Array("pre_script"=>removeslashesifnecessary($script), "type"=>"report","name"=>removeslashesifnecessary($name), "time_executed"=>date("Y-m-d H:i:s")));
			}
			
			if(contains($mode,"generate"))
			{
				$out.= GenerateReport($strDatabase, $strPHP,  $scriptlog_id);
			}
			else if (contains($mode,"report")  || contains($submit,"arting") )
			{
				
	

			}
			else if((contains($mode,"new")  || $scriptlog_id!=""   )  && $mode!="save")
			{
				$out.= ReportForm($strDatabase, $strPHP,  $strReportScript,$scriptlog_id);
			}
		 
			else
			{
				 $out.= ReportList($strDatabase);
			}
	 
			
			
				
		}
	}
	$strAddedJSTag="<script src=\"tf_import.js\"><!-- --></script>";
	$out =  PageHeader($strDatabase . " Reporter", $strConfigBehave, "", true, false, "", $strDatabase) . $strAddedJSTag . $out . PageFooter();
	return $out;
				
}
	

function ReportList($strDatabase)
{
	$strPHP=tfpre . "report.php?" . qpre . "db=" . $strDatabase .  "";
	$strSQL="SELECT scriptlog_id, name FROM ".  $strDatabase . "." . tfpre . "scriptlog WHERE type='report' ORDER BY name";
	//echo $strSQL;
	$out= GenericRSDisplay($strDatabase, $strPHP,": list", $strSQL,33, 500 , "", "", 
		"<a href=" . $strPHP ."&mode=edit&scriptlog_id=<replace/>>edit report</a> | " .
		"<a href=" . $strPHP ."&mode=generate&scriptlog_id=<replace/>>generate report</a>"  
		, 
		" ", false, true, 10, "", 
	Array());
	$out.= "<a href=\"" . $strPHP . "&" . qpre . "db=" . $strDatabase .  "&mode=new\">create new report</a>";
	//coulda been  "username"=>"ID^" . $strUserURL  in that array
	//$out=str_replace("idsorttable", "idsorttable4", $out);
	return $out;
}

function ReportForm($strDatabase, $strPHP, $strReportScript, $report_id)
{
	//a form for entering free-form report in my reporting pseudoscript.  defaults to last command run
	//gus mueller, nov 26 2006
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strLineClass="bgclassline";
	$strOtherBgClass="bgclassother";
	//echo $language_id . "-";
	
	$record=GenericDBLookup($strDatabase,  tfpre."scriptlog", "scriptlog_id", $report_id , "");
 	$strReportScript=$record["pre_script"];
	$name=$record["name"];
	$preout="";

	//$out.= AdminNav(true);
	
	$preout.= "<form method=\"post\" name=\"BForm\" action=\"" .  $strPHP . "\">\n";

	//$out.= "</td></tr>\n";
	$out.= HiddenInputs(array("db"=>$strDatabase));
	$out.= HiddenInputs(array("scriptlog_id"=>$report_id),"");
	$out.= HiddenInputs(array("mode"=>"save"),"");
	$out.=htmlrow
		(
			$strThisBgClass, 
			"report name",
			TextInput("name", $name, 40)
		);
	
	$out.="<tr>\n";
	
	$out.="<td colspan='2' style='font-size:10px'  valign=\"top\" class=\"" . $strClassFirst . "\">\n";

	$out.="<textarea name=\"script\" style='width:100%' rows=\"20\"  >" .  $strReportScript . "</textarea>\n";
	$out.="<br/>Reporting script.  Use the   names of fields prepended with '$' to refer to the data of those fields to be processed by subqueries enclosed in {}, which can nest inside other subqueries.";
	$out.="</td>\n";
	$out.="</tr>\n";
	$out.="<tr>\n";
	$out.="<tr>\n";
	$out.="<td align=\"right\" colspan=\"2\">\n";
	$out.="<a href=\"" .  AllRequestToURL() . "\">URL of this page's state</a> ";
	$out.="<input type=\"Submit\" class=\"btn\" onmouseover=\"this.className='btn btnhov'\" onmouseout=\"this.className='btn'\" value=\"Save\">";
	$out.="</td>\n";
	$out.="</tr>\n";
 
	$out.="</form>";
	$out=$preout . TableEncapsulate($out ,false, "100%");
	return $out;
}



function GenerateReport($strDatabase, $strPHP,  $scriptlog_id)
{
//ActSQL($strDatabase, $strPHP, $strSQL, $bwlTruncate, $bwlSuppressLogging=false, $bwlEditableResults=false, $strPostRunScript="", $intForeignLanguageID="", $bwlSuppressOutputIfNoResults=false, $bwlSuppressStatus=false, $sortappend="")
 	
	$sql=conDB();
	
	$reportrecord=GenericDBLookup($strDatabase, tfpre . "scriptlog", "scriptlog_id", $scriptlog_id);
	$strRawScript=$reportrecord["pre_script"];
	$name=$reportrecord["name"];
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
	$potentialSQL=GetBracketedContent($strRawScript, "{", "}", "' \"", true);
	
	//echo($potentialSQL . "<BR><BR>" . $strRawScript);
	$rows =  $sql->query($potentialSQL);
	$commandname=parseBetween("!||!". $strRawScript, "!||!", "(");
	$params=parseBetween(   $strRawScript, "(", ")");
	$arrPreParams=explode(",", $params);
	foreach($arrPreParams as $thisparam)
	{
		$arrThisParamPair=explode("=", $thisparam);
		$arrParam[trim($arrThisParamPair[0])]=trim($arrThisParamPair[1]);
	}
	//var_dump($arrParam);
	//die("-" . $commandname. "-");
	if($commandname=="graph"  || $commandname=="bargraph")
	{
		$top =60;
		//die(count($rows));
		$orientation="";
		foreach($rows as $thisrow)
		{
			
	 		if(array_key_exists($arrParam["color"],$thisrow))
			{
				$color=$thisrow[$arrParam["color"]];
			}
			else
			{
				$color=gracefuldecay($arrParam["color"], "666666");
			}
		 
			if(is_numeric($arrParam["y"]))
			{
				$y=$arrParam["y"];
				$orientation="horizontal";
			}
			else
			{
				$y=20*$thisrow[$arrParam["y"]];
			}
			if(is_numeric($arrParam["x"]))
			{
				$x=$arrParam["x"];
				$orientation="vertical";
			}
			else
			{
				$x=20*$thisrow[$arrParam["x"]];
			}
			$stylebase="float:left;z-index:2;position:absolute;background-color:#" . $color. ";";
		 
			$out.="<div style='" . $stylebase . "width:" . $x . "px;height:" .  $y . "px;left:" . $left . "px;top:" . $top . "px'>" . $thisrow[$arrParam["label"]] . "</div>\n\n";
			if($orientation=="horizontal")
			{
				$top=$top+$y ;
				$left=10;
			}
			else
			{
				$left=$left+$x ;
				$top=30;
			}
		
		}
	
	
	}
	
	if(1==2)
	{
	
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
	for($i=0; $i<count($arrSQL); $i++) 
	{
 		$strThisBgClass=$strLineClass;
		$strSQL=$arrSQL[$i];
		$strQHTMLOut="";
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
		
							$thisatag="";
							if(in_array($intFieldCount, $arrPKPositions)  || inList($strPKList, $k))//if this position is the name of PK
							{
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
							}
				 
					 
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
								$strFormula=FixFormulaForEval($strPostRunScript, true);
								$arrVars=FindDollarVariables($strFormula);
								if(is_array($arrVars))
								{
									foreach($arrVars as $thisinputvar)
									{
										if($thisinputvar!="")
										{
											$strFormula=str_replace("$" . $thisinputvar, "\"" . $record[$thisinputvar] . "\"", $strFormula);
										}
									}
								}
								if(trim($strFormula)!="")
								{
									$strFormula='$returnval=' . $strFormula . ";";
									eval($strFormula );
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
							$strFormula="";
							$strQHTMLOut.="</td>";
							$intFieldCount++;
						}
						$strQHTMLOut.="<td><a onclick=\"javascript:return(confirm('Are you sure you want to delete " . $thislinktable . " number " . $record[$thislinkpk] . "?'))\" href='" . qbuild("tf.php", $strDatabase,$thislinktable, "delete", $thislinkpk, $record[$thislinkpk]) .$keyserialized  . "&" . "'>Delete</a></td>";

						$intRowCount++;
						$strQHTMLOut.="\n</tr>\n";
						
			 
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
									if($thisinputvar!="")
									{
										$subquerySQL=str_replace("$" . $thisinputvar, "'" . $record[$thisinputvar] . "'", $subquerySQL);;		
									}
								
								}
							}
					 
							$extrasubqueryresult=ActSQL($strDatabase, $strPHP, $subquerySQL, $bwlTruncate, true, false, $strPostRunScript, $intForeignLanguageID, true, true,  $sortappend ."^" .    intval($intThisSortLevel++) );
						}
						
						
						if($extrasubqueryresult!="")
						{
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
						$out.=TableEncapsulate($strQHTMLOut, true, "100%", "idsorttable" .  $i. $sortappend); 
					 
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

	if($bwlSuppressOutputIfNoResults  && $intRowCount==0)
	{
		return "";
	}
	else
	{
		return $out;
	}
	}
	return $out;
}
?> 