<?php
//Judas Gutenberg December 2007
//Exports to SQL with lots of configuration options
//i've modified txtsql to be aware of foreign keys so this tool can dynamically build complicated tools
//This code is covered under the GNU General Public License
//info here: http://www.gnu.org/copyleft/gpl.html
//the digest is as follows: you cannot modify this code without
//publishing your source code under the same license
//contact the developer at gus@asecular.com  http://asecular.com

include('core_functions.php');
include('backup_functions.php');
include('sqlparsing_functions.php');
echo main();
 

function main()
{
	if(!IsExtraSecure())
	{
		die(ExtraSecureFailure());
	}
	//$olderror=error_reporting(0);
	$sqlnarrow=$_REQUEST[qpre . "sqlnarrow"];
	$mode=$_REQUEST[qpre . "mode"];
	$strTable=$_REQUEST[qpre . "table"];
	$addslashes=$_REQUEST[qpre . "addslashes"];
	$drop=$_REQUEST[qpre . "drop"];
	$schema=$_REQUEST[qpre . "schema"];
	$export=$_REQUEST[qpre . "exportron"];
	$delete=$_REQUEST[qpre . "delete"]; 
	$nocharset=$_REQUEST[qpre . "nocharset"];
	$nodbmention=$_REQUEST[qpre . "nodbmention"];
	$tableprefix=$_REQUEST[qpre . "tableprefix"];
	$recursivebackup=$_REQUEST[qpre . "recursivebackup"];
	$nullpks=$_REQUEST[qpre . "nullpks"];
	$htmlesc=$_REQUEST[qpre . "htmlesc"];
	$strDatabase=deMoronizeDB(gracefuldecay($_REQUEST[qpre . "db"],our_db));
	error_reporting($olderror);
	$strPHP=$_SERVER['PHP_SELF'];
	$out="";
	if ($rec=="")
	{
		$rec=0;
	}
	if($sqlnarrow!="")
	{
		$arrTables=FindTables($sqlnarrow ,  true);
		if($arrTables[0]!="")
		{
			$strTable=$arrTables[0];
			//echo $strTable;
		}
	}
	$out=LoginDecisions($strDatabase,  $strPHP, $strUser, false);
	if ($strUser!="")
	{
	
		$intAdminType= AdministerType($strDatabase,"", $strUser);
		
		if ($intAdminType>1)
		{
		 	if($export=="")
			{
				if($strTable!="")
				{
					$out.= SpecificTableExportForm($strDatabase, $strTable,0,600, $sqlnarrow);
				
				}
				else
				{
					$out.= ExportForm($strDatabase);
				}
			}
			else
			{
				//create the export!!!;
				$out="";
				$bwlAddSlashes=IfAThenB($addslashes, true);
				$bwlDropOld=IfAThenB($drop, true);
				$bwlNoSchema=IfAThenB($schema, true);
				$bwlDelete=IfAThenB($delete, true);
				$bwlNoCharsetCrap=IfAThenB($nocharset, true);
				$bwlNoDBMention=IfAThenB($nodbmention, true);
				$bwlHTMLEsc=IfAThenB($htmlesc, true);
				$bwlrecursivebackup=IfAThenB($recursivebackup, true); 
				$bwlnullpks=IfAThenB($nullpks, true); 
				$bwlJustSQL=true;
				//echo count($_REQUEST[qpre . "export"]) . "count";
				if($strTable=="") //no particular table - so tables presented from checkboxes
				{
					foreach($_REQUEST[qpre . "export"] as $accept)
					{
						//echo $accept . "##<br>";
						$strSQL .=backupDBtoSQL($strDatabase, $accept, $bwlAddSlashes, $bwlDelete, $bwlDropOld, $bwlNoSchema, $bwlNoCharsetCrap, $bwlJustSQL, $bwlNoDBMention, $bwlHTMLEsc, $tableprefix, "*", $bwlrecursivebackup, $bwlnullpks) . "\n";
					}
				}
				else //we are on a particular table and need a list of rows
				{
					$strAccepts="";
					foreach($_REQUEST[qpre . "exportrow"] as $accept)
					{
						//echo $accept . "##<br>";
						$strAccepts.= $accept ." "; 
					}
					$strAccepts= RemoveEndCharactersIfMatch($strAccepts, " ");
					//echo $strAccepts . "<br>";
					$strSQL .=backupDBtoSQL($strDatabase, $strTable, $bwlAddSlashes, $bwlDelete, $bwlDropOld, $bwlNoSchema, $bwlNoCharsetCrap, $bwlJustSQL, $bwlNoDBMention, $bwlHTMLEsc, $tableprefix, $strAccepts, $bwlrecursivebackup, $bwlnullpks) . "\n";
				
				}
				//echo $strSQL;
				//die();
				$len=strlen($strSQL);
				$backupFile = date("Y-m-d") . "-" . $strDatabase  . '-backup.sql';
				header("Pragma: public");
				header("Expires: 0");
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header("Cache-Control: public"); 
				header("Content-Description: File Transfer");
				header("Content-Type: application/gzip");
				header("Content-Disposition: attachment; filename=" . $backupFile . ";");
				header("Content-Transfer-Encoding: binary");
				if ($len!="")
				{
					header("Content-Length: ".$len);
				}
				echo $strSQL;
				die();
			}
		}
	}
	$out =  PageHeader($strDatabase .  IfAThenB($strTable, " : ") . $strTable . " exporter", $strConfigBehave) . $strAddedJSTag . $out . PageFooter();
	
	return $out;
}

function  SpecificTableExportForm($strDatabase, $strTable, $intStart=0, $intTotalDisplay=600, $sqlnarrow)
{
//allows an admin to check off some rows to export, which is particularly handy if using the recursive feature
	$sql=conDB();
	$intTrunc=30;
	$intFindCount=1;
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strPHP="tableform.php";
	$strCheckboxName="exportrow";
	$out="";
	$out.= adminbreadcrumb(false, $strDatabase, $strPHP . "?" . qpre . "db=" . $strDatabase,  "SQL Export", "sqlexport.php", $strTable, "");
	$tableheader="<table id=\"idsorttable\"  class=\"bgclassline\" cellpadding=\"0\" cellspacing=\"1\" border=\"0\" width=\"500\">\n";
	if($sqlnarrow!="")
	{
		$strSQL=$sqlnarrow;
	}
	else
	{
		$strSQL="SELECT * FROM " .  $strDatabase . "." .$strTable . " LIMIT " . $intStart . ", " . $intTotalDisplay; 
		$sqlnarrow=$strSQL;
	}
	//echo $strSQL;
	$records = $sql->query($strSQL);
	
	$out.=FreeSQLNarrowForm($sqlnarrow,  $strDatabase, $strTable);
	$tableheader="<table id=\"idsorttable\"  class=\"bgclassline\" cellpadding=\"0\" cellspacing=\"1\" border=\"0\" width=\"500\">\n";
	
	$out.= "<script src=\"tablesort_js.js\"><!-- --></script>";
	$out.= "<form method=\"post\" name=\"BForm\" action=\"sqlexport.php\">\n";
	$out.=$tableheader;
	$pkname=PKLookup($strDatabase, $strTable);
	$out.=SimpleTableDescriptionHeader($strDatabase, $strTable, $fieldsincluded, "bgclassline", 5, "", "", Array("include in export"));
	$outcount=0;
	$arrFields=explode(" ", $fieldsincluded);
	//echo $fieldsincluded;
	$arrRow=Array();
	
	foreach ( $records as  $record)
	{
		$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
		$pkval="";
		$fieldCursor=1;
		$arrRow[0]=$strThisBgClass;
		foreach($arrFields as $thisfield)
		{
		
			$todisplay=$record[$thisfield];
			if(contains($thisfield, "password"))
			{
				$todisplay=passworddisplay($todisplay);
			}
		 	if($pkname==$thisfield)
			{
				$pkval=$record[$thisfield];
				$todisplay="<a href=\"" . qbuild($strPHP, $strDatabase, $strTable, "edit", $pkname, $pkval) . "\">" . $pkval . "</a>";
			}
			else
			{
				$todisplay=trunchandler($todisplay, $intTrunc);
			}
			$arrRow[$fieldCursor]=singlequoteescape($todisplay);
			$fieldCursor++;
		}
		$checkcell= CheckboxInput(qpre . $strCheckboxName . "[]", $pkval,  false);
		$checkcell.="<a href=\"javascript:alldumpcheckboxes('" . $strCheckboxName ."[]', 'rev', 0, " . $outcount .")\">^</a> ";
		$checkcell.="<a href=\"javascript:alldumpcheckboxes('" . $strCheckboxName ."[]', 'rev', " . $outcount .")\">v</a>";
		$arrRow[$fieldCursor]= $checkcell;
		$out.=call_user_func_array("htmlrow", $arrRow);
		$outcount++;
	}
	$out.="</table>\n";
	$out.=str_replace("idsorttable", "idsorttable2", $tableheader);
	$out.=OptionBlock($default, $strCheckboxName, "rows");
	$out.= HiddenInputs(array("db"=>$strDatabase, "table"=>$strTable));
	$out.="</table>\n";
	$out.="</form>\n";
	$out.="<script>NumberRows('idsorttable',1);</script>";
	return $out;
}

function ExportForm($strDatabase)
{
	$sql=conDB();
	$intFindCount=1;
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strPHP="tableform.php";
	$strCheckboxName="export";
	$out="";
	$out.= adminbreadcrumb(false, $strDatabase, $strPHP . "?" . qpre . "db=" . $strDatabase,  "SQL Export", "");
	$tableheader="<table id=\"idsorttable\"  class=\"bgclassline\" cellpadding=\"0\" cellspacing=\"1\" border=\"0\" width=\"500\">\n";
	//echo $strSQL;
	$tables=TableList($strDatabase);
	$tableheader="<table id=\"idsorttable\"  class=\"bgclassline\" cellpadding=\"0\" cellspacing=\"1\" border=\"0\" width=\"500\">\n";
	$out.= "<script src=\"tablesort_js.js\"><!-- --></script>";
	$out.= "<form method=\"post\" name=\"BForm\" action=\"sqlexport.php\">\n";
	$out.=$tableheader;
	$out.=htmlrow("bgclassline", "<a href=\"javascript: SortTable('idsorttable', 0)\">table</a>", "<a href=\"javascript: SortTable('idsorttable', 1)\">records</a>",  "<a href=\"javascript: SortTable('idsorttable', 2)\">columns</a>", "include in export");
	$strFieldName="Tables_in_" . str_replace("`", "", $strDatabase);
	$outcount=0;
	foreach ( $tables as  $k=>$v )
	{
		$tablename=$v[$strFieldName];
		$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
 		$count = countrecords($strDatabase , $tablename );
		$fieldcount=FieldCount($strDatabase, $tablename);
		$checkcell=CheckboxInput(qpre . "export[]", $tablename,  false);
		$checkcell.="<a href=\"javascript:alldumpcheckboxes('" . $strCheckboxName ."[]', 'rev', 0, " . $outcount .")\">^</a> ";
		$checkcell.="<a href=\"javascript:alldumpcheckboxes('" . $strCheckboxName ."[]', 'rev', " . $outcount .")\">v</a>";
		$out.=htmlrow($strThisBgClass, 
			"<a href=\"sqlexport.php?" . qpre . "mode=tableview&" . qpre . "table=" .$tablename . "\">" .  $tablename . "</a>", 
			$count,
			$fieldcount,
			$checkcell
			);
		$outcount++;
	}
	$out.="</table>\n";
	$out.=str_replace("idsorttable", "idsorttable2", $tableheader);
	$out.=OptionBlock($default, $strCheckboxName, "tables");
	$out.= HiddenInputs(array("db"=>$strDatabase));
	$out.="</table>\n";
	$out.="</form>\n";
	$out.="<script>NumberRows('idsorttable',1);</script>";
	return $out;
}

function OptionBlock($strPrefixDefault, $strCheckboxName, $itemname)
{	
//displays the option checkboxes for an export
	$out="";
	$out.="<tr name=\"sortavoid\"><td>\n";
	$out.="<strong>When building SQL for export:</strong><p/>\n";
	$out.=CheckboxInput(qpre . "schema", 1,  false) . " do not include table definitions";
	$out.="<br>\n";
	$out.=CheckboxInput(qpre . "drop", 1,  false) . " include code to drop replaced tables and data";
	$out.="<br>\n";
	$out.=CheckboxInput(qpre . "delete", 1,  false) . " include code to delete old data";
	$out.="<br>\n";
	$out.=CheckboxInput(qpre . "addslashes", 1,  false) . " slash-escape single quotes";
	$out.="<br>\n";
	$out.=CheckboxInput(qpre . "htmlesc", 1,  true) . " HTML-escape single quotes";
	$out.="<br>\n";
	$out.=CheckboxInput(qpre . "nocharset", 1,  true) . " don't include charset info";
	$out.="<br>\n";
	$out.=CheckboxInput(qpre . "nodbmention", 1,  true) . " don't include the name of the database";
	$out.="<br>\n";
	$out.=CheckboxInput(qpre . "recursivebackup", 1,  false) . " recursively include related data";
	$out.="<br>\n";
	$out.=CheckboxInput(qpre . "nullpks", 1,  false) . " include code to generate compatible auto++ primary keys in destination";
	$out.="<br>\n";
	$out.=TextInput(qpre . "tableprefix", $strPrefixDefault, 5) . " prefixes all tablenames";
	$out.="<br>\n";

	$out.= GenericInput(qpre . "exportron", "export selected ".  $itemname);
	$out.="</td>\n";
	$out.="<td valign=\"top\" align=\"right\">\n";
	$out.="<a href=\"javascript:alldumpcheckboxes('" . $strCheckboxName . "[]', true)\">select all</a> | <a href=\"javascript:alldumpcheckboxes('" . $strCheckboxName  . "[]', false)\">select none</a>";
	$out.="</td>\n";
	$out.="</tr>\n";
	return $out;
}

function FreeSQLNarrowForm($sqlnarrow, $strDatabase, $strTable)
{
	$out="\n<div style=\"position: absolute;top: 40px;left: 520px; z-index: 100; \">\n";
	$out.="<form name=\"NForm\" action=\"sqlexport.php\" method=\"post\">\n";
	$out.="<br>Narrow your results with SQL:<br>\n";
	$out.=GenericInput(qpre. "sqlnarrow", $sqlnarrow,  false,  "",   "",  "", "text", 50, "", 5);
	$out.="<br>";
	$out.=GenericInput(qpre. "selectsubmit", "narrow");
	$out.= HiddenInputs(array("db"=>$strDatabase, "table"=>$strTable));
	$out.="</form>\n";
	$out.="</div>\n";
	return $out;
}


?>