<?php
//Judas Gutenberg Nov 30 2007
//scans all columns of a database for a search term
//This code is covered under the GNU General Public License
//info here: http://www.gnu.org/copyleft/gpl.html
//the digest is as follows: you cannot modify this code without
//publishing your source code under the same license
//contact the developer at gus@asecular.com  http://asecular.com
 
set_time_limit(900);
include('backup_functions.php');
include('core_functions.php');

echo main();

function main()
{
	if(!IsExtraSecure())
	{
		die(ExtraSecureFailure());
	}
	ini_set('memory_limit','450M');
	$strDatabase=deMoronizeDB(gracefuldecay($_REQUEST[qpre . "db"],our_db));
	$strSearch=$_REQUEST[qpre . "search"];
	$submit=strtolower($_REQUEST[qpre . "submit"]);
	$bwlFilterMeta=$_REQUEST[qpre . "filtermeta"];
	$bwlFilterScript=$_REQUEST[qpre . "filterscript"];
	 
	// echo "-" .$rowdel . "-";
	//$quotecontent=false;
	$strPHP=$_SERVER['PHP_SELF'];
	$supressheaders=false;

	 
	$out=LoginDecisions($strDatabase,  $strPHP, $strUser, $supressheaders);
	if ($strUser!="")
	{
		$intAdminType= AdministerType($strDatabase, "", $strUser);
		
		if ($intAdminType>1)
			{
				$out.=ColumnScannerForm($strDatabase, $strSearch, $bwlFilterMeta, $bwlFilterScript);
				if ($strSearch!="")
				{
					if(contains($submit, "loose"))
					{
						$out.=ColumnScanner($strDatabase, $strSearch, false, $bwlFilterMeta, $bwlFilterScript);
					}
					else
					{
						$out.=ColumnScanner($strDatabase, $strSearch, true, $bwlFilterMeta, $bwlFilterScript);
					}
				}
				
				
			}
	}
	$out =  PageHeader($strDatabase . " searcher", $strConfigBehave) . $out . PageFooter();
	return $out;
}
	 
	
function ColumnScannerForm($strDatabase, $strSearch, $bwlFilterMeta, $bwlFilterScript)
{
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strPHP=$_SERVER['PHP_SELF'];
	$out.= adminbreadcrumb(false, $strDatabase,"tableform.php" . "?" . qpre . "db=" . $strDatabase,   "full database searcher", "");
	$out.="<form name=\"BForm\" action=\"" . $strPHP . "\" method=\"post\">\n";
	$strButtonLabel="loose search " . $strDatabase;
	$strButtonLabel2="precise search " . $strDatabase;
	$out.= "<table border=\"0\" cellspacing=\"1\" cellpadding=\"2\" class=\"bgclassline\">\n";
	$out.=htmlrow("bgclassline", 
	 TextInput(qpre ."search", $strSearch, "30","",  "", ""),
	 GenericInput(qpre . "submit",   $strButtonLabel) . " " . GenericInput(qpre . "submit",   $strButtonLabel2)
	 
	);
	$out.=htmlrow("bgclassfirst", "Filter out META tags", CheckboxInput(qpre . "filtermeta", "1", $bwlFilterMeta));
	$out.=htmlrow("bgclasssecond", "Filter out SCRIPT tags", CheckboxInput(qpre . "filterscript", "1", $bwlFilterScript));
	$out.= HiddenInputs(array("db"=>$strDatabase));
	$out.="</table>\n";
	$out.="</form>\n";
	return $out;

}



function ColumnScanner($strDatabase, $strSearch, $bwlStrict, $bwlFilterMeta=false, $bwlFilterScript=false)
{



 
	//creates a SQL-based dump of a db's data and structure
	//this will work when mysqldump is failing
	//federico frankenstein, jan 9 2007
	$sql=conDB();
	$out="";
	$strTypeDescription="loose";
	if($bwlStrict)
	{
		$strTypeDescription="strict";
	}
	$strPHP=$_SERVER['PHP_SELF'];
	$strFieldName="Tables_in_" . str_replace("`", "", $strDatabase);
	$tables=TableList($strDatabase);
	foreach ( $tables as  $k=>$v )
	{
		$strTable=$v[$strFieldName];
		$fieldrecords=DBExplain($strDatabase, $strTable); 
		foreach ($fieldrecords as $k => $info )
		{
 
			$field=$info["Field"];
			if($bwlStrict)
			{
				//for strings i'm going to need to put in code to make sure the searched field is a string or else i get a hit when it's zero for some reason
				$strSQL="SELECT * FROM " . $strDatabase . "." . $strTable . " WHERE `" . $field . "` LIKE '" .$strSearch . "';";
			}
			else
			{
				$strSQL="SELECT * FROM " . $strDatabase . "." . $strTable . " WHERE `" . $field . "` LIKE '%" .$strSearch . "%';";
			}
			//echo $strSQL . "<br>";
			$results="";
			$results=SpecialQueryDisplay($strDatabase,  $strTable, $field  , $strPHP, $strSQL, 1, true, $bwlFilterMeta, $bwlFilterScript);
			if($results!="")
			{
				
				$out.="<p/>Matches found in <b><a href=\"" . qbuild("tableform.php", $strDatabase, $strTable, "view", "", "") . "\">" . $strTable . "</a></b> in the column <b> " . $field . ":</b><br>";
				$out.=$results;
			}
		 	
		}
		 
	}

	if($out=="")
	{
		 $out="<p/>No matches were found in the " . $strTypeDescription . " search for  <b>" .$strSearch . "</b>." ;
	}
	return $out . "\n";
}




function  SpecialQueryDisplay($strDatabase, $strTable, $field, $strPHP, $strSQL, $truncate, $bwlSuppressLogging=false, $bwlFilterMeta, $bwlFilterScript)
{
	//runs $strSQL and displays results in a labeled HTML table
	//also shows errors if there is a problem
	//judas gutenberg: nov 26 2006, nov 30 2007
	$sql=conDB();
	mysql_select_db($strDatabase);
	$strLineClass="bgclassline";
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strOtherBgClass="bgclassother";
	$strOtherLineClass="bgclassline";
	$strThisBgClass=$strLineClass;
	//echo $strSQL;
	$arrSQL =ParseStringToArraySkippingQuotedRegions($strSQL);
	$out= "";
	$strPKName=PKLookup($strDatabase, $strTable);
	for($i=0; $i<count($arrSQL); $i++) 
	{
		$strSQL=$arrSQL[$i];
		if(!TableExists($strDatabase, tfpre . "sqllog"))
		{
		
			echo MakeSQLLogTable($strDatabase);
		}
		if(! $bwlSuppressLogging)
		{
			$strLogSQL="INSERT INTO " . $strDatabase . "." . tfpre . "sqllog(sql_string) VALUES('" . str_replace("'", "\\'", $strSQL) . "')";
			$recs =  $sql->query($strLogSQL);
		}
		if (trim($strSQL)!="")
		{
			//echo $strSQL . "<p>";
			$rows =  $sql->query($strSQL);
			$rowcount=0;
			$strErrors=sql_error();
			if ($strErrors=="")
			{
				$head= "\n<table id=\"idsorttable" . $strTable .  "-" .  $field .  "\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\" class=\"" .$strLineClass  . "\"  >\n";
			 	if(!$bwlSuppressLogging)
				{
					$head.= "<tr><td>\n";
					$head.="<b>Results of Query #" . intval($i+1) . "</b>";
					$head.= "</td></tr>\n";
				}
				
				foreach ($rows as $record )
				{
					$out.= "<tr class=\"" . $strThisBgClass . "\">\n";
					if($rowcount==0)
					{
						$intHeadfieldCount=0;
						foreach($record as $k=>$v)
						{
							$out.="<td valign=\"top\">";
							$fieldval=$k;
							
							 
							$out.="<a href=\"javascript: SortTable('idsorttable" . $strTable .  "-" .  $field ."', " . $intHeadfieldCount . ")\">";
							if($field==$k)
							{
								$fieldval="<b>" . $fieldval  . "<b>";
							}
							$out.=$fieldval ;
							$out.="</a>";
							$out.="</td>";
							$intHeadfieldCount++;
							
						}
						$out.="</tr>\n";
						$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
						$out.= "<tr class=\"" . $strThisBgClass . "\">\n";
					}
					
					foreach($record as $k=>$v)
					{
						$fieldval=$v;
						$keyserialized="";
						$strBg="";
						if($field==$k)
						{
							$strBg=" class='bgclassfresh'";
						}
						$out.="<td " . $strBg . "valign=\"top\">";
						if ($truncate==1)
						{
							
	
							
							if($field!=$k)
							{
								$fieldval=simplelinkbody($fieldval);
							}
							
							if(inList($strPKName,$k))
							{
								if(contains($strPKName, " "))
								{
									$keyserialized=$qpre . "&" . qpre . "ks=" . urlencode(serialize(ArraySubsetFromList($strPKName, $record)));
								}
							//qbuild($strPHP, $strDatabase, $strTable, $mode, $idfieldname, $id)
								$fieldval="<a href=" . qbuild("tableform.php", $strDatabase, $strTable, "edit", urlencode($strPKName), $fieldval)  . $keyserialized . ">" . $fieldval  . "</a>";

									

							}
							if($bwlFilterMeta)
							{
								//remove meta tags from output
								$fieldval=str_ireplace("<meta", "<xxxx", $fieldval);
							}
							if($bwlFilterScript)
							{
								//remove meta tags from output
								$fieldval=str_ireplace("<script", "<xxxx", $fieldval);
							}
							$out.= $fieldval;
						}
						else
						{
							$out.=str_replace(chr(10), chr(10) . "<br/>" , $v);
						}
						$out.="</td>";
						$rowcount++;
					}
					$out.="</tr>\n";
					$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
					
				}
				if($out!="")
				{
					$out=$head . $out . "</table>";
					$out.="<script>NumberRows('idsorttable" . $strTable .  "-" .  $field . "', " . intval(intval($intHeadfieldCount)-1) . ");</script>";
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
				$out.=$strErrors;
				//$out.= "<br>SQL: " . $strSQL;
				$out.= "</td></tr>\n";
				$out.="</table></p>";
			}
		}
	}
	if($out!="")
	{
		$out="<script src=\"tablesort_js.js\"><!-- --></script>" . $out;
	}
	return $out;
}




 
?>