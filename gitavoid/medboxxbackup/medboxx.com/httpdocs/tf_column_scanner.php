<?php
//Judas Gutenberg Nov 30 2007
//scans all columns of a database for a search term
//This code is covered under the GNU General Public License
//info here: http://www.gnu.org/copyleft/gpl.html
//the digest is as follows: you cannot modify this code without
//publishing your source code under the same license
//contact the developer at gus@asecular.com  http://asecular.com
 
set_time_limit(900);
include('tf_functions_backup.php');
include('tf_functions_core.php');
include('tf_core_table_creation.php');

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
	$bwlTruncate=gracefuldecaynumeric($_REQUEST[qpre . "truncate"], 1);
	$bwlTotalTruncate=gracefuldecaynumeric($_REQUEST[qpre . "totaltruncate"],0);
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
				$out.=ColumnScannerForm($strDatabase, $strSearch, $bwlFilterMeta, $bwlFilterScript, $bwlTruncate, $bwlTotalTruncate);
				if ($strSearch!="")
				{
					if(contains($submit, "loose"))
					{
						$out.=ColumnScanner($strDatabase, $strSearch, false, $bwlFilterMeta, $bwlFilterScript, $bwlTruncate, $bwlTotalTruncate);
					}
					else
					{
						$out.=ColumnScanner($strDatabase, $strSearch, true, $bwlFilterMeta, $bwlFilterScript, $bwlTruncate, $bwlTotalTruncate);
					}
				}
				
				
			}
	}
	$out =  PageHeader($strDatabase . " searcher", $strConfigBehave) . $out . PageFooter();
	return $out;
}
	 
	
function ColumnScannerForm($strDatabase, $strSearch, $bwlFilterMeta, $bwlFilterScript, $bwlTruncate, $bwlTotalTruncate)
{
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strPHP=$_SERVER['PHP_SELF'];
	$preout.= adminbreadcrumb(false, $strDatabase,"tf.php" . "?" . qpre . "db=" . $strDatabase,   "full database searcher", "");
	$out="<form name=\"BForm\" action=\"" . $strPHP . "\" method=\"post\">\n";
	$strButtonLabel="loose search " . $strDatabase;
	$strButtonLabel2="precise search " . $strDatabase;
 
	$out.=htmlrow("bgclassline", 
	 TextInput(qpre ."search", $strSearch, "30","",  "", ""),
	 GenericInput(qpre . "submit",   $strButtonLabel) . " " . GenericInput(qpre . "submit",   $strButtonLabel2)
	 
	);
	$out.=htmlrow("bgclassfirst", "filter out META tags", CheckboxInput(qpre . "filtermeta", "1", $bwlFilterMeta));
	$out.=htmlrow("bgclasssecond", "filter out SCRIPT tags", CheckboxInput(qpre . "filterscript", "1", $bwlFilterScript));

	$out.=htmlrow("bgclassfirst", "truncate unrelated fields", CheckboxInput(qpre . "truncate", "1", $bwlTruncate));
	$out.=htmlrow("bgclasssecond", "truncate all fields", CheckboxInput(qpre . "totaltruncate", "1", $bwlTotalTruncate));
	$out.= HiddenInputs(array("db"=>$strDatabase));
 
	$out.="</form>\n";
	$out=$preout . TableEncapsulate($out);
	return $out;

}



function ColumnScanner($strDatabase, $strSearch, $bwlStrict, $bwlFilterMeta=false, $bwlFilterScript=false, $bwlTruncate=false,  $bwlTotalTruncate=false)
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
		$fieldrecords=TableExplain($strDatabase, $strTable); 
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
			$results=SpecialQueryDisplay($strDatabase,  $strTable, $field  , $strPHP, $strSQL, $bwlTruncate, $bwlTotalTruncate, true, $bwlFilterMeta, $bwlFilterScript);
			if($results!="")
			{
				
				$out.="<p/>Matches found in <b><a href=\"" . qbuild("tf.php", $strDatabase, $strTable, "view", "", "") . "\">" . $strTable . "</a></b> in the column <b> " . $field . ":</b><br>";
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




function  SpecialQueryDisplay($strDatabase, $strTable, $field, $strPHP, $strSQL, $bwlPartialTruncate, $bwlTotalTruncate, $bwlSuppressLogging=false, $bwlFilterMeta, $bwlFilterScript)
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
						$out.="<td>&nbsp;</td>";//room for delete link
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
					 
							
	
							
						if(($field!=$k && $bwlPartialTruncate) || $bwlTotalTruncate)
						{
							$fieldval=simplelinkbody($fieldval);
						}
						else
						{
							$fieldval=str_replace(chr(10), chr(10) . "<br/>" , $fieldval);
						}
						
					 
						if(inList($strPKName,$k))
						{
							if(contains($strPKName, " "))
							{
								$keyserialized=$qpre . "&" . qpre . "ks=" . urlencode(serialize(ArraySubsetFromList($strPKName, $record)));
							}
							else
							{
								if($pkval=="")
								{
									$pkval=$fieldval;
								}
							}
						//qbuild($strPHP, $strDatabase, $strTable, $mode, $idfieldname, $id)
							$fieldval="<a href=" . qbuild("tf.php", $strDatabase, $strTable, "edit", urlencode($strPKName), $fieldval)  . $keyserialized . ">" . $fieldval  . "</a>";

								

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
						 
					 
						$out.="</td>";
						$rowcount++;
					}
					$out.="<td><a onclick=\"javascript:return(confirm('Are you sure you want to delete " . $strTable . " number " . $pkval . "?'))\" href='" . qbuild("tf.php", $strDatabase,$strTable, "delete", $strPKName, $pkval) . $keyserialized . "&" . "'>Delete</a></td>";
					$out.="</tr>\n";
					$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
					
				}
				if($out!="")
				{
					$out=  TableEncapsulate($head.$out, true, "","idsorttable" . $strTable .  "-" .  $field );
				}
			}
			else
			{

				$out.= "<tr>\n";
				$out.="<td valign=\"top\" class=\"" .$strLineClass  . "\" >";
				$out.="<span class=\"heading\">Errors:</span>";
				$out.= "</td></tr>\n";
				$out.= "<tr class=\"" . $strClassFirst . "\">\n";
				$out.="<td valign=\"top\"  >";
				$out.=$strErrors;
				//$out.= "<br>SQL: " . $strSQL;
				$out.= "</td></tr>\n";
				//$out.="</table></p>";
				$out=  TableEncapsulate( $out, true, "","idsorttable" . $strTable .  "-" .  $field );
			}
		}
	}
	if($out!="")
	{
		$out="<script src=\"tf_tablesort.js\"><!-- --></script>" . $out;
	}
	return $out;
}




 
?>