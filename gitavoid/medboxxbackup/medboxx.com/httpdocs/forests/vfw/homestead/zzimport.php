<?php
//Judas Gutenberg Nov 28 2007
//imports csv data to a db table
//This code is covered under the GNU General Public License
//info here: http://www.gnu.org/copyleft/gpl.html
//the digest is as follows: you cannot modify this code without
//publishing your source code under the same license
//contact the developer at gus@asecular.com  http://asecular.com
//jesus died for my ass
 
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
	$strTable=gracefuldecay($_REQUEST[qpre . "newtable"], $_REQUEST[qpre . "table"]);
	$strDatabase=deMoronizeDB(gracefuldecay($_REQUEST[qpre . "db"],our_db));
	$submit=$_REQUEST[qpre . "submit"];
	$fielddel=$_REQUEST[qpre . "fielddel"];
	$rowdel=$_REQUEST[qpre . "rowdel"];
	$quotecontent=$_REQUEST[qpre . "quotecontent"];
	$filename=$_REQUEST[qpre . "filename"];
	$quotechar=$_REQUEST[qpre . "quotechar"];
	$fieldcount=$_REQUEST[qpre . "fieldcount"];
	$pk=$_REQUEST[qpre . "pk"];
	$filename=$_REQUEST[qpre . "filename"];
	// echo "-" .$rowdel . "-";
	$skip=gracefuldecay($_REQUEST[qpre . "skip"], 1);
	//$quotecontent=false;
	$strPHP=$_SERVER['PHP_SELF'];
	$supressheaders=false;
	$bwlNewTable=false;
	if($_REQUEST[qpre . "newtable"]!="" || $strTable=="")
	{
		$bwlNewTable=true;
	
	}
	 
	$out=LoginDecisions($strDatabase,  $strPHP, $strUser, $supressheaders);
	if ($strUser!="")
	{
		$intAdminType= AdministerType($strDatabase, $strTable, $strUser);
		
		if ($intAdminType>1)
			{
			
				if (contains($submit,"pload")  || contains($submit,"arting") )
				{
				 	if(!contains($submit,"arting") ) //only do this if we're doing the initial upload
					{
					//first upload file
						$errors="<div class=\"feedback\">" . UploadImportFile($strFirstrow, $filename, $rowdel, $quotechar, $skip) . "</div>";
					}
					else
					{
						//don't re-upload, just read the file on the server;									
						$handle=fopen ($filename, "r");
						$content=fread($handle, filesize($filename));
						fclose($handle);
						$arrRows=BetterExplode($rowdel, $content,  $quotechar, true);
						//$arrRows=explode(chr($rowdel), $content);
						$strFirstrow=$arrRows[intval($skip)-1];

					}
					
					//then draw a form to specify mapping
					//echo  ($arrRows[4]) . "==len==" . $rowdel . "<br>";
					$out.= $errors . ImportForm($strDatabase, $strTable, $strFirstrow,  $filename, $fielddel, $rowdel, $quotechar, $skip, $bwlNewTable);
					 
				}
				else if (contains($submit,"mport"))
				{
					//need to read file from past efforts
					$errors="";
					if (file_exists($filename))
					{
									
						$handle=fopen ($filename, "r");
						$content=fread($handle, filesize($filename));
						fclose($handle);
						//echo intval($skip). "==";
						
						//then we need to assemble a fieldmap
						$arrFieldMap=BuildFieldMap($strDatabase, $strTable, $bwlNewTable);
					
						//then import
						if($content!="")
						{
							$errors.=  CommmaDelimitedSlurp($strDatabase, $strTable, $content, "",  $fielddel=",", $rowdel, $quotechar, $arrFieldMap, $bwlNewTable, $pk, $skip);
							;
						}
						else
						{
							$errors.= "The uploaded file was empty or had incorrect format.";
						
						}
				 		
					}
					else
					{
							$errors.= "The uploaded file was misplaced.";
						
					}
				 		
					$errors= "<div class=\"feedback\">" . $errors. "</div>";
					$out.= $errors . ReadFileForm($strDatabase, $strTable);
		 
		
				}
				else
				{
					$out.=ReadFileForm($strDatabase, $strTable);
					
					
					
				}
				
			}
	}
	$strAddedJSTag="<script src=\"import_js.js\"><!-- --></script>";
	$out =  PageHeader($strTable . " Exporter", $strConfigBehave) . $strAddedJSTag . $out . PageFooter();
	return $out;
				
}
	
function UploadImportFile(&$strFirstrow, &$destpath, $rowdel="\n", $quotechar="\" '", $skip)
{
	//read the import file and return its first row and destpath by reference
	$name=qpre . "importfile";
	if ($_FILES[$name]["name"]!="")
	{
		if($destpath=="")
		{
			$destpath=imagepath . "/"  . "tmp_import_" . $_FILES[$name]['name'];
		}
		//echo $destpath;
		if (!BuildPathPiecesAsNecessary($destpath))
		{
			$out.="The path " .$destpath . " could not be built.<br>";
		}
		if (move_uploaded_file($_FILES[$name]['tmp_name'], $destpath))
		{
			chmod($destpath, 0777);
			$out.="The file " . $destpath . " was uploaded successfully.<br/>";
			//if we have a successful upload that put the new name in the db
		}
	}
	if (file_exists($destpath))
	{
					
		$handle=fopen ($destpath, "r");
		$content=fread($handle, filesize($destpath));
		fclose($handle);
		$arrRows=BetterExplode($rowdel, $content,  $quotechar, true);
		//echo intval($skip). "==";
 		
		if($content!="")
		{
			$strFirstrow=$arrRows[ intval($skip)-1];
		}
	}
	return $out;

}
	
	
function ReadFileForm($strDatabase, $strTable)
{
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strPHP="tableform.php";
	$out.= adminbreadcrumb(false, $strDatabase, $strPHP . "?" . qpre . "db=" . $strDatabase,  gracefuldecay($strTable, "New Table"), IFAThenB($strTable, qbuild($strPHP, $strDatabase, $strTable, "view", "", "")), "data importer", "");
	$out.="<form enctype=\"multipart/form-data\" name=\"BForm\" action=\"import.php\" method=\"post\">\n";
	$out.="<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"12000000\" />";
	$tableheader="<table class=\"bgclassline\" cellpadding=\"0\" cellspacing=\"1\" border=\"0\" width=\"500\">\n";
	$out.=$tableheader;
	$out.="<tr class=\"bgclassline\"><td colspan=\"2\">\n";
	$out.="Select a file of delimited data to import";
	$strButtonLabel= "upload";
	if($strTable!="")
	{
		 $out.=" into <strong>" . $strTable;
		 $strButtonLabel.= " data for " . $strTable ;
	}
	else
	{
		$out.=".";
	}
	
	$out.="</strong>\n</td></tr>\n";
	$out.=htmlrow($strClassFirst, 
	"file to import: ",
	GenericInput(qpre . "importfile", "", false, "",  "", "", "file", "44")
	);
	
	
	$out.=htmlrow("bgclassline", "&nbsp;", "<span class=\"heading\">Upload File Format Information</span>");
	

	
	
	
	$out.=htmlrow($strClassFirst, 
	"field delimiter: " , GenericDataPulldown("comma|44-space|32-vertical bar|124-tab|9", 1, 0, qpre . "fielddel", 44, "", "", ""));
	$out.=htmlrow($strClassSecond, 
	"row delimiter: " , GenericDataPulldown("carriage return|13-linefeed|10-cr&lf|13.10", 1, 0, qpre . "rowdel", "13.10", "", "", ""));

	$out.=htmlrow($strClassFirst, 
	"acceptable quotes: " , GenericDataPulldown("double quotes|34-single quotes|39-double or single quotes|34 39", 1, 0, qpre . "quotechar", "34 39", "", "", "")
	);
 
	$out.=htmlrow($strClassSecond, 
	"begin at row: ",
	numericpulldown(1,20,1,qpre . "skip")
	);
	
	
	$out.=htmlrow("bgclassline", 
	"&nbsp;",
	GenericInput(qpre . "submit",   $strButtonLabel)
	);
	

	$out.= HiddenInputs(array("db"=>$strDatabase, "table"=>$strTable ));
	$out.="</td></tr>\n";
	$out.="</table>\n";
	$out.="</form>\n";
	return $out;

}
	
	
function ImportForm($strDatabase, $strTable, $strFirstrow,  $filename, $fielddel, $rowdel, $quotechar, $skip=1, $bwlNewTable=false)
{
	$sql=conDB();
	$arrFirst= BetterExplode($fielddel, $strFirstrow,  $quotechar);
 
	$intFindCount=1;
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strPHP="tableform.php";
	$out.= adminbreadcrumb(false, $strDatabase, $strPHP . "?" . qpre . "db=" . $strDatabase,  gracefuldecay($strTable, "New Table"), IFAThenB($strTable, qbuild($strPHP, $strDatabase, $strTable, "view", "", "")), "data importer", "");
	$out.="<form name=\"BForm\" action=\"import.php\" method=\"post\">\n";
	$tableheader="<table class=\"bgclassline\" cellpadding=\"0\" cellspacing=\"1\" border=\"0\" width=\"500\">\n";
	$out.=$tableheader;
	
	if($bwlNewTable)
	{
		$out.=htmlrow("bgclassline", "&nbsp;", "<span class=\"heading\">New Table Information</span>");
		$out.=htmlrow("bgclassother",   "new table name", TextInput( qpre ."newtable", $strTable, "30","",  "", ""));
		$out.=htmlrow("bgclassother",   "autoincrement PK (if needed)", TextInput( qpre ."pk",$_REQUEST[qpre . "pk"], "30","",  "", ""));
	}
	else
	{
		//$out.=htmlrow("bgclassline", "&nbsp;", "<span class=\"heading\">Table Information</span>");
	}
	$out.="<tr class=\"bgclassline\"><td colspan=\"2\">\n";
	$out.="Pick appropriate field mappings";
	$strButtonLabel= "import";

		
	if($strTable!="")
	{
		 $out.=" for <strong>" . $strTable;
		 $strButtonLabel.= " to " . $strTable;
	}
	else
	{
		$out.=".";
	}
	$out.="</strong>\n</td></tr>\n";
	$fieldcount=0;
	

	
	if(!$bwlNewTable)
	{

		$out.=htmlrow("bgclassother",   "database field", "import field number and sample data");
		$records=DBExplain($strDatabase, $strTable);
		foreach ($records as $k => $info )
		{
			
			$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
			$out.="<tr class=\"" . $strThisBgClass . "\">";
			//$out.="<input type=\"checkbox\" name=\"" . qpre . "fields[]\" id=\"id" . qpre . "fields[]\" value=\"" .  $info["Field"] . "\"></td>"
			$out.="<td>" .  $info["Field"];
			$out.="</td><td>";
			$out.= ArrayToEnumeratedPulldown($arrFirst, qpre ."pulldown-" .$fieldcount,  $fieldcount);
			$out.="</td></tr>\n";
			$fieldcount++;
	 	}
	}
	else
	{
			
		$out.=htmlrow("bgclassother",   "new database field", "import field number and sample data");
		
		foreach ($arrFirst as $k )
		{
			
			$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
			$out.="<tr class=\"" . $strThisBgClass . "\">";
			//$out.="<input type=\"checkbox\" name=\"" . qpre . "fields[]\" id=\"id" . qpre . "fields[]\" value=\"" .  $info["Field"] . "\"></td>"
			$out.="<td>" .  TextInput( qpre ."newfield-" .$fieldcount, $_REQUEST[qpre ."newfield-" .$fieldcount], "30","",  "", "");
			$out.="</td><td>";
			$out.= ArrayToEnumeratedPulldown($arrFirst, qpre ."pulldown-" .$fieldcount,  $fieldcount);
			$out.="</td></tr>\n";
			$fieldcount++;
	 	}
		$strTable="";
	
	}
	$out.=htmlrow("bgclassother", "<a href=\"javascript: importfieldnameslc()\">Force these lower case.</a>","<div align=\"right\"><a href=\"javascript: importfieldnames()\">Use these fields to name the database fields.</a></div>");
	$out.="</table>\n";
	
	$out.=$tableheader;
	$out.="<tr><td>";
	$out.="<br/>Note:  by selecting \"none\" under 	\"import field number and sample data\" you can keep the corresponding database field from receiving data during the import.  This is particularly useful when you need an autoincrement field to actually increment as the rows are added.
<br/><br/>";
	$out.="</td></tr>";
	$out.="</table>\n";
	$out.=$tableheader;
	$out.=htmlrow("bgclassline", "&nbsp;", "<span class=\"heading\">Upload File Format Information</span>");
	$out.=htmlrow($strClassFirst, 
	"field delimiter: " , GenericDataPulldown("comma|44-space|32-vertical bar|124-tab|9", 1, 0, qpre . "fielddel", $fielddel, "", "", ""));
	$out.=htmlrow($strClassSecond, 
	"row delimiter: " , GenericDataPulldown("carriage return|13-linefeed|10-cr&lf|13.10", 1, 0, qpre . "rowdel", $rowdel, "", "", "")
	);
	$out.=htmlrow($strClassFirst, 
	"acceptable quotes: " , GenericDataPulldown("double quotes|34-single quotes|39-double or single quotes|34 39", 1, 0, qpre . "quotechar", $quotechar, "", "", "")
	);
	
	$out.=htmlrow($strClassSecond, 
	"begin at row: ",
	numericpulldown(1,20,$skip,qpre . "skip").
	"<input type=\"submit\" name=\"" . qpre . "submit\" value=\"view a different starting row in import data\">"
	);
	
	
	$out.="<tr class=\"bgclassline\"><td align=\"right\" colspan=\"2\">\n";
	
	$out.="<input onclick=\"return(checkimportform())\" type=\"submit\" name=\"" . qpre . "submit\" value=\"" .  $strButtonLabel . "\">\n";
	$out.= HiddenInputs(array("db"=>$strDatabase, "table"=>$strTable,  "fieldcount"=>$fieldcount , "filename"=>$filename));
	$out.="</td></tr>\n";
	$out.="</table>\n";
	$out.="</form>\n";

	return $out;
}
	
	
function BuildFieldMap($strDatabase, $strTable, $bwlNewTable)
{
	$i=0;
	$arrOut=Array();
	if( !$bwlNewTable)
	{
		$records=DBExplain($strDatabase, $strTable);
		foreach ($records as $k => $info )
		{
			$field=$info["Field"];
			$arrOut[$field]=$_REQUEST[qpre . "pulldown-" . $i];
			$i++;
		}
	}
	else
	{

		$topfield=$_REQUEST[qpre . "fieldcount"];
		for($i=0; $i<$topfield; $i++ )
		{
			$field=$_REQUEST[qpre ."newfield-" . $i ];
			$arrOut[$field]=$_REQUEST[qpre . "pulldown-" . $i];
		}
	}
	return $arrOut;
}


function ArrayToEnumeratedPulldown($arrIn,  $strName, $intDefault)
{

	//gives me a select with numbers running from $intstart to $intend, with $intdefault selected, and names it $strName
	$intEnd=count($arrIn)-1;
	$intstart=0;
	$strOut="<select  id=\"id" . $strName . "\" name=".chr(34).$strName.chr(34).">"."\n";
	$strOut.="<option value=".chr(34).chr(34).">none"."\n";
	for ($intNumber=$intstart; $intNumber<=$intEnd; $intNumber++)
	{
				//echo $arrIn[$intNumber] . "<br>";
				$strSel="";
				if ($intNumber==$intDefault)
					{
						$strSel=" selected=\"true\" ";
					} 
				$strOut.="<option value=\"". $intNumber. "\" " . $strSel .  ">". intval($intNumber +1). ": " .truncate($arrIn[$intNumber],30)."\n";
			
	} 
	$strOut.="</select>"."\n";
	return $strOut;
}

function CommmaDelimitedSlurp($strDatabase, $strTable, $content, $fields,  $fielddel=",", $rowdel="\n", $quotechar="\" '", $arrFieldMap, $bwlNewTable, $pk="", $skip=1)
{
	$sql=conDB();
	$arrRows=BetterExplode($rowdel, $content,  $quotechar,  true);
	$errors="";
	if($bwlNewTable)
	{
		//first we have to make the table
		$strSQL="CREATE TABLE " . $strDatabase . "." .   AppropriateSQLName($strTable) . " (";
		if ($pk!="")
		{
			 $strSQL.= AppropriateSQLName($pk) . " int(11) NOT NULL auto_increment,";
		}
		foreach($arrFieldMap as $k=>$v)
		{
			if($k!="")
			{
		  		$strSQL.= AppropriateSQLName($k) . " varchar(255) default NULL,";
			}
		 
		}
		$strSQL=RemoveEndCharactersIfMatch($strSQL, ",");
		if ($pk!="")
		{
			$strSQL.= ",\nPRIMARY KEY  (" . AppropriateSQLName($pk) . ")";
		}
		$strSQL.= ");";
		$sql->query($strSQL);
		$errors.=IfAThenB(sql_error(), "<b>failed to create table:</b>" .  sql_error() . "<br>". $strSQL . "<br><br>");
	
	}
	for($i=$skip-1; $i< count($arrRows); $i++)
	{
		$strSQL="";
		$strRow=$arrRows[$i];
		$arrFields=BetterExplode($fielddel, $strRow,  $quotechar);
		foreach($arrFieldMap as $k=>$v)
		{
			if($v!=""  && $k!="")
			{
				$strSQL.="," . AppropriateSQLName($k) . "='" . singlequoteescape($arrFields[intval($v)]) . "'"; 
			}
		
		}
		$strSQL=RemoveEndCharactersIfMatch($strSQL, ",");
		$strSQL="INSERT INTO " . $strDatabase . "." .  AppropriateSQLName($strTable) . " SET " .  $strSQL;
		if(CanChange())
		{
			$records = $sql->query($strSQL);
		}
		else
		{
			$errors=  "Database is read-only";
		}
	
		$errors.=IfAThenB(sql_error(), "<b>failed to insert data:</b>" .  sql_error() . "<br>". $strSQL . "<br><br>");
	}
 
	if ($errors=="")
	{
		$errors="The data import into <a href=\"tableform.php?" . qpre . "mode=view&" . qpre  . "table=" .  AppropriateSQLName($strTable) . "\">" . AppropriateSQLName($strTable)  . "</a> was successful.";
	}
	return $errors;
}

?>