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
include('tf_functions_backup.php');
include('tf_functions_core.php');

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
	$firstfornames=$_REQUEST[qpre . "firstfornames"];
	$lowercasefields=$_REQUEST[qpre . "lowercasefields"];
 
	

	$skip=gracefuldecay($_REQUEST[qpre . "skip"], 1);
	//echo $skip;
	//$quotecontent=false;
	$strPHP=$_SERVER['PHP_SELF'];
	$supressheaders=false;
	$bwlNewTable=false;
	//this actually takes place elsewhere
	//if (!defined("tftemp"))
	//{
	//	$rootpath="/"; //don't let this happen
	//}
	//else
	//{
		//$rootpath=tftemp;
	//}
	//$fullfilename=$rootpath . "/" . $filename;
	//die($filename);
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
						EnsureNonRemote();
						$errors="<div class=\"feedback\">" . UploadImportFile($strFirstrow, $filename, $rowdel, $quotechar, $skip) . "</div>";
					}
					else
					{
						EnsureNonRemote();
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
				
					$out.= $errors . ImportForm($strDatabase, $strTable, $strFirstrow,  $filename, $fielddel, $rowdel, $quotechar, $skip, $bwlNewTable, $firstfornames, $lowercasefields);
 
				}
				else if (contains($submit,"mport"))
				{
					EnsureNonRemote();
					//need to read file from past efforts
					$errors="";
					if (file_exists($filename))
					{
									
						$handle=fopen ($filename, "r");
						$content=fread($handle, filesize($filename));
						fclose($handle);
						//echo intval($skip). "==";
						
						//then we need to assemble a fieldmap
						$arrFieldMap=BuildFieldMap($strDatabase, $strTable, $bwlNewTable, $firstfornames, $lowercasefields);
					
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
	$strAddedJSTag="<script src=\"tf_import.js\"><!-- --></script>";
	$out =  PageHeader($strTable . " Exporter", $strConfigBehave) . $strAddedJSTag . $out . PageFooter();
	return $out;
				
}
	
function UploadImportFile(&$strFirstrow, &$destpath, $rowdel="\n", $quotechar="\" '", $skip)
{
	//read the import file and return its first row and destpath by reference
	$name=qpre . "importfile";
	if ($_FILES[$name]["name"]!="")
	{
		if (!defined("tftemp"))
		{
			$rootpath="/"; //don't let this happen
		}
		else
		{
			$rootpath=tftemp;
		}
		//echo $destpath . "::1<br>";
		if($destpath=="")
		{
			$destpath=$rootpath .  "/tmp_import_" . $_FILES[$name]['name'];
		}
		//echo $destpath . "::2<br>";
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
	$strPHP="tf.php";
	$preout="";
	$out="";
	$preout.= adminbreadcrumb(false, $strDatabase, $strPHP . "?" . qpre . "db=" . $strDatabase,  gracefuldecay($strTable, "New Table"), IFAThenB($strTable, qbuild($strPHP, $strDatabase, $strTable, "view", "", "")), "data importer", "");
	$preout.="<form enctype=\"multipart/form-data\" name=\"BForm\" action=\"tf_import.php\" method=\"post\">\n";
	$preout.="<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"12000000\" />";
	 
	//$out.=$tableheader;
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
	
	$out.=ImportOptions($strClassFirst, $strClassSecond, 44, "13.10",  "34 39", true, true, false);
	$out.=htmlrow("bgclassline", "&nbsp;",GenericInput(qpre . "submit",   $strButtonLabel));
	$out.= HiddenInputs(array("db"=>$strDatabase, "table"=>$strTable ));
	$out.="</td></tr>\n";
	$out=   $preout . TableEncapsulate($out, false);
	$out.="</form>\n";
	return $out;

}


function ImportOptions($strClassFirst, $strClassSecond, $defaultfielddelimeter, $defaultrowdelimiter, 	 $defaultquotes, $firstfornames, $lowercasefields, $bwlSecondtimeUse)
{
	$out="";
	$out.=htmlrow("bgclassline", "&nbsp;", "<span class=\"heading\">Upload File Format Information</span>");

	
	$out.=htmlrow($strClassFirst, 
	"field delimiter: " , GenericDataPulldown("comma|44-space|32-vertical bar|124-tab|9", 1, 0, qpre . "fielddel", $defaultfielddelimeter , "", "", ""));
	$out.=htmlrow($strClassSecond, 
	"row delimiter: " , GenericDataPulldown("carriage return|13-linefeed|10-cr&lf|13.10-comma|44", 1, 0, qpre . "rowdel", $defaultrowdelimiter, "", "", ""));

	$out.=htmlrow($strClassFirst, 
	"acceptable quotes: " , GenericDataPulldown("double quotes|34-single quotes|39-double or single quotes|34 39", 1, 0, qpre . "quotechar",$defaultquotes, "", "", "")
	);
 

	if(!$bwlSecondtimeUse)
	{
		$out.=htmlrow($strClassFirst, "use first row as fieldnames " ,   CheckboxInput(qpre . "firstfornames", 1, $firstfornames));
		$out.=htmlrow($strClassSecond, "force fieldnames lowercase" ,   CheckboxInput(qpre . "lowercasefields", 1, $lowercasefields));
	}
	else
	{
		$out.=htmlrow($strClassFirst, 
		"begin at row: ",
		numericpulldown(1,20,$skip,qpre . "skip").
		"<input type=\"submit\" name=\"" . qpre . "submit\" value=\"view a different starting row in import data\">"
		);
	}

	return $out;

}
	
function ImportForm($strDatabase, $strTable, $strFirstrow,  $filename, $fielddel, $rowdel, $quotechar, $skip=1, $bwlNewTable=false, $firstfornames=true, $lowercasefields=true)
{
	
	$sql=conDB();
	if(!function_exists("str_getcsv")  || 1==1)
	{
		$arrFirst= BetterExplode($fielddel, $strFirstrow,  $quotechar);
		
	}
	else
	{
		$arrFirst=str_getcsv( $strFirstrow, $fielddel);
		//echo "<BR><BR>" . $strFirstrow ."<BR><BR>" . count($arrFields);
			
	}
	$intFindCount=1;
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$preout="";
	$out="";
	$strPHP="tf.php";
	$preout.= adminbreadcrumb(false, $strDatabase, $strPHP . "?" . qpre . "db=" . $strDatabase,  gracefuldecay($strTable, "New Table"), IFAThenB($strTable, qbuild($strPHP, $strDatabase, $strTable, "view", "", "")), "data importer", "");
	$preout.="<form name=\"BForm\" action=\"tf_import.php\" method=\"post\">\n";
 
	
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
		$records=TableExplain($strDatabase, $strTable);
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
			$fieldnamedefault= $_REQUEST[qpre ."newfield-" .$fieldcount];
			
			if($firstfornames)
			{
				$fieldnamedefault =AppropriateSQLName(gracefuldecay($fieldnamedefault, $arrFirst[$fieldcount]));
				
				
			}
			if($lowercasefields)
			{
				$fieldnamedefault=strtolower($fieldnamedefault);
			}
			$out.="<td>" .  TextInput( qpre ."newfield-" .$fieldcount,$fieldnamedefault, "30","",  "", "");
			$out.="</td><td>";
			$out.= ArrayToEnumeratedPulldown($arrFirst, qpre ."pulldown-" .$fieldcount,  $fieldcount);
			$out.="</td></tr>\n";
			$fieldcount++;
	 	}
		$strTable="";
	
	}
	
	$out.=htmlrow("bgclassother", "<a href=\"javascript: importfieldnameslc()\">Force these lower case.</a>","<div align=\"right\"><a href=\"javascript: importfieldnames()\">Use these fields to name the database fields.</a></div>");
	$overallout=   $preout . TableEncapsulate($out, false);
	$out="";
	//$out.="</table>\n";
	
	//$out.=$tableheader;
	$out.="<tr><td>";
	$out.="<br/>Note:  by selecting \"none\" under 	\"import field number and sample data\" you can keep the corresponding database field from receiving data during the import.  This is particularly useful when you need an autoincrement field to actually increment as the rows are added.
<br/><br/>";
	//$out.="</td></tr>";
	//$out.="</table>\n";
	$overallout.=   TableEncapsulate($out, false);
	$out="";
	//$out.=$tableheader;
	//echo "-" .  $firstfornames . "-";
 
	$out.=ImportOptions($strClassFirst, $strClassSecond, $fielddel,  $rowdel, $quotechar, $firstfornames,$lowercasefields, true);

	
	
	$out.="<tr class=\"bgclassline\"><td align=\"right\" colspan=\"2\">\n";
	
	$out.="<input onclick=\"return(checkimportform())\" type=\"submit\" name=\"" . qpre . "submit\" value=\"" .  $strButtonLabel . "\">\n";
	$out.= HiddenInputs(array("db"=>$strDatabase, "table"=>$strTable,  "fieldcount"=>$fieldcount , "filename"=>$filename));
	$out.="</td></tr>\n";
 	$overallout.= TableEncapsulate($out, false);
	$overallout.="</form>\n";
	
	return $overallout;
}
	
	
function BuildFieldMap($strDatabase, $strTable, $bwlNewTable, $firstfornames=true, $lowercasefields=true)
{
	$i=0;
	$arrOut=Array();
	if( !$bwlNewTable)
	{
		$records=TableExplain($strDatabase, $strTable);
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

function CommmaDelimitedSlurp($strDatabase, $strTable, $content, $fields,  $fielddel=",", $rowdel="\n", $quotechar="\" '", $arrFieldMap, $bwlNewTable, $pk="", $skip=1,  $firstfornames=true, $lowercasefields=true)
{
	$sql=conDB();
	$arrRows=BetterExplode($rowdel, $content,  $quotechar,  true);
	$errors="";
	$strTable=AppropriateSQLName($strTable);
	if($bwlNewTable)
	{
		//first we have to make the table
		$strSQL="CREATE TABLE " . $strDatabase . "." .    $strTable . " (";
		if ($pk!="")
		{
			 $strSQL.= AppropriateSQLName($pk) . " INT(11) NOT NULL auto_increment,";
		}
		foreach($arrFieldMap as $k=>$v)
		{
			if($k!="")
			{
				//initial schema is very liberal, but after filled with data, it will be tightened
		  		$strSQL.= AppropriateSQLName($k) . " TEXT DEFAULT NULL,";
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
	$arrFieldTypes=GetFieldTypeArray($strDatabase, $strTable);
	for($i=$skip-1; $i< count($arrRows); $i++)
	{
		$strSQL="";
		$strRow=$arrRows[$i];
		//discovered that microsoft sometimes quotes values and sometimes does not feb 25 2010
		//echo  $strRow . "<p>";
		$arrFields=BetterExplode($fielddel, $strRow,  $quotechar);

		
		foreach($arrFieldMap as $k=>$v)
		{
			//added this code to deal with vexing microsoft csv exports
			$value=$arrFields[intval($v)];
			$value=trim($value);
			
	  		//OLD SCHEME FOR tightening schema -- but it was needlessly slow. now we do it once the data is all in the db
			//$vallen=strlen($value);
			//$k=AppropriateSQLName($k);
			//$sizechange=intval(IfAThenNextB("4 12 20 60 250 1000",$vallen, "larger",  " "));
			//if($sizechange>255)
			//{
				//$strAlterSQL="ALTER TABLE " . $strDatabase . "." .    $strTable . " CHANGE COLUMN " . $k . " " . $k . " TEXT DEFAULT NULL";
			//}
			//else
			//{
				//$strAlterSQL="ALTER TABLE " . $strDatabase . "." .    $strTable . " CHANGE COLUMN " . $k . " " . $k . " VARCHAR(" . $sizechange. ") default NULL";
			//}
		
			//if($strAlterSQL!="")
			//{
				//$existingtype=GetFieldType($strDatabase, $strTable, $k);//expensive!!
				//$existingtype=$arrFieldTypes[$k];
				//$existingsize=TypeParse($existingtype, 1);//intval(parseBetween($existingtype ,"(", ")"));
				//echo $existingsize . " " . $sizechange . "<BR>";
				//echo  $existingsize . " " . $sizechange  . " " . $strAlterSQL . "<BR>";
				//if(intval($sizechange)>intval($existingsize)  && $existingsize!=0 && $sizechange>0  )
				//{
	
					//echo $existingsize . " " . $sizechange . "<BR>";
					
					//$sql->query($strAlterSQL);
					//i have to update arrFieldTypes, since i'm not hitting the db to get the latest copy
					//$arrFieldTypes[$k]="VARCHAR(" .$sizechange . ")";
					//echo mysql_error() . "<BR>";;
				//}
				//$strAlterSQL="";
			//}
			if($v!=""  && $k!="")
			{
				$strSQL.="," . $k . "='" . singlequoteescape($value) . "'"; 
			}
		
		}
		$strSQL=RemoveEndCharactersIfMatch($strSQL, ",");
		$strSQL="INSERT INTO " . $strDatabase . "." .  $strTable . " SET " .  $strSQL;
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
		$errors="The data import into <a href=\"tf.php?" . qpre . "mode=view&" . qpre  . "table=" .  AppropriateSQLName($strTable) . "\">" . AppropriateSQLName($strTable)  . "</a> was successful.";
	}
	//take the rough 
	$errors.=ReschemeTableForData($strDatabase, $strTable, 30);
	return $errors;
}





//echo "-" . IfAThenNextB("4 12 20 60 250 1000", 0, "larger",  " ") ."-";
?>