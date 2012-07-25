<?php
//Judas Gutenberg February 24 2008
//imports sql data to a db
//This code is covered under the GNU General Public License
//info here: http://www.gnu.org/copyleft/gpl.html
//the digest is as follows: you cannot modify this code without
//publishing your source code under the same license
//contact the developer at gus@asecular.com  http://asecular.com

set_time_limit(900);
include('tf_functions_backup.php');
include('tf_functions_core.php');
include('tf_functions_sql_parsing.php');
include('tf_core_table_creation.php');

	//echo phpinfo();
	//die();
echo main();

function main()
{
	if(!IsExtraSecure())
	{
		die(ExtraSecureFailure());
	}
	//$rootpath=imagepath; //bad old way
	if (!defined("tftemp"))
	{
		$rootpath="/"; //don't let this happen
	}
	else
	{
		$rootpath=tftemp;
	}
	BuildPathPiecesAsNecessary($rootpath);
	ini_set('memory_limit','3050M');
	$strDatabase=deMoronizeDB(gracefuldecay($_REQUEST[qpre . "db"],our_db));

	$submit=$_REQUEST[qpre . "submit"];
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
 
	$out=LoginDecisions($strDatabase,  $strPHP, $strUser, $supressheaders);
	if ($strUser!="")
	{
		$intAdminType= AdministerType($strDatabase,"", $strUser);
		
		if ($intAdminType>1)
		{
			
			if (contains($submit,"pload") )
			{
				EnsureNonRemote();
				if($filename!="") //we picked a file from the already-uploaded list
				{
					$filename=$rootpath ."/" . $filename;
				}
				else //we're uploading a file
				{
					
					$errors.="<div class=\"feedback\">" . UploadImportFile($filename, $rootpath) . "</div>";
					
					//don't re-upload, just read the file on the server;									
					
					//$arrRows=explode(chr($rowdel), $content);
	
					//then draw a form to specify mapping
					//echo  ($arrRows[4]) . "==len==" . $rowdel . "<br>";
				}
				$handle=fopen ($filename, "r");
				$content=fread($handle, filesize($filename));
				fclose($handle);
				if($content!="")
				{
					$analysis= SQLAnalysis($content);
				}
				$out.= $errors . ImportForm($strDatabase, $strTable, $analysis,  $filename );
					 
			}
			else if (contains($submit,"mport"))
			{
				//need to read file from past efforts
				
				$errors="";
				if (file_exists($filename))
				{
					EnsureNonRemote();
					$handle=fopen ($filename, "r");
					$content=fread($handle, filesize($filename));
					fclose($handle);
					//echo intval($skip). "==";
					$results= ActSQL($strDatabase, $strPHP, $content, true,true);
					//then we need to assemble a fieldmap
					 
				
					//then import
					if($content!="")
					{
				 
					 
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
				$out.= $errors . ReadFileForm($strDatabase,  $rootpath) . $results;
	 
	
			}
			else
			{
				$out.=ReadFileForm($strDatabase,  $rootpath);
				
				
				
			}
			
		}
	}
	$strAddedJSTag="<script src=\"tf_import.js\"><!-- --></script>";
	$out =  PageHeader($strDatabase .  IfAThenB($strTable, " : ") . $strTable . " importer", $strConfigBehave) . $strAddedJSTag . $out . PageFooter();
	return $out;
					
}
	
function UploadImportFile(&$destpath, $rootpath)
{
	//read the import file and return its first row and destpath by reference
	$name=qpre . "importfile";
	if ($_FILES[$name]["name"]!="")
	{
		if($destpath=="")
		{
			$destpath=$rootpath . "/"  . "tmp_sqlimport_" . $_FILES[$name]['name'];
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
	
	}
	return $out;

}
	
	
function ReadFileForm($strDatabase, $rootpath)
{
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strPHP="tf.php";
	$preout= adminbreadcrumb(false, $strDatabase, $strPHP . "?" . qpre . "db=" . $strDatabase,  "import SQL","tf_sql_import.php". qpre . "db=" . $strDatabase, "choose upload", "");
	$out="<form enctype=\"multipart/form-data\" name=\"BForm\" action=\"tf_sql_import.php\" method=\"post\">\n";
	$out.="<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"12000000\" />";
	$out.="<tr class=\"bgclassline\"><td colspan=\"2\">\n";
	$out.="Select a SQL file containing data and/or schema to import into " . $strDatabase;
	$strButtonLabel= "upload SQL";
	$out.="</strong>\n</td></tr>\n";
	$out.=htmlrow($strClassFirst, 
	"file to import: ",
	GenericInput(qpre . "importfile", "", false, "",  "", "", "file", "44")
	);
	//$out.=htmlrow("bgclassline", "&nbsp;", "<span class=\"heading\">Upload Configuration</span>");
	$out.=htmlrow("bgclassline", 
		"&nbsp;",
		GenericInput(qpre . "submit",   $strButtonLabel)
		);
	$out.= HiddenInputs(array("db"=>$strDatabase));
	$out.="</td></tr>\n";
	$out.="</form>\n";
	$out=$preout . TableEncapsulate($out, false);
	$out.= "<br>";
	$out.="or pick an existing SQL file that has already been uploaded...\n";
	$out.= "<br>";
	$out.= FileBrowser($rootpath, "sql txt", "tf_sql_import.php?" . qpre . "submit=Upload", qpre . "filename");
	return $out;
}
	
	
function ImportForm($strDatabase, $strTable, $analysis,  $filename )
{
	$sql=conDB();
	$intFindCount=1;
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strPHP="tf.php";
	$preout.= adminbreadcrumb(false, $strDatabase, $strPHP . "?" . qpre . "db=" . $strDatabase,  "import SQL","tf_sql_import.php". qpre . "db=" . $strDatabase, "SQL analysis : " . $filename, "");
	$out.="<form name=\"BForm\" action=\"tf_sql_import.php\" method=\"post\">\n";
	$out.="<tr class=\"bgclassline\"><td colspan=\"2\">\n";
	$strButtonLabel= "import SQL";
	$out.="</strong>\n</td></tr>\n";
	$strTable="";
	$out.="</table>\n";
	$out.=$analysis;
	$out.=$tableheader;
	$out.="<tr class=\"bgclassline\"><td align=\"right\" colspan=\"2\">\n";
	
	$out.="<input onclick=\"return(checkimportform())\" type=\"submit\" name=\"" . qpre . "submit\" value=\"" .  $strButtonLabel . "\">\n";
	$out.= HiddenInputs(array("db"=>$strDatabase, "table"=>$strTable,  "fieldcount"=>$fieldcount , "filename"=>$filename));
	$out.="</td></tr>\n";
	$out.="</form>\n";
	$out=$preout . TableEncapsulate($out);
	return $out;
}
	


function SQLAnalysis($strSQL)
{

	$arrIn =ParseStringToArraySkippingQuotedRegions($strSQL);
	$intTotalLinesofSQL=count($arrSQL);
	$arrTables=Array();
	$out="";
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$bwlAutoIncsRelocatable=false;
	$bwlIncludeDatabaseName=false;
	$bwlCreates=false;
	$bwlDropTables=false;
	$bwlTruncateTables=false;
	$bwlRecursive=false;
	foreach($arrIn as $thisline)
	{
 
		$thisline=AllWhiteSpaceToSpace($thisline);
		$thisline=deMultiple($thisline, " ");
		$thisline=RemoveEndCharactersIfMatch($thisline, " ");
		$lowerThisLine=strtolower($thisline);
		
		 
		if(contains($lowerThisLine, "@associatedpk"))
		{
			$bwlRecursive=true;
		}
		if(contains($lowerThisLine, "create table"))
		{
			$bwlCreates=true;
		}
		if(contains($lowerThisLine, "drop table"))
		{
			$bwlDropTables=true;
		}
		if(contains($lowerThisLine, "truncate table"))
		{
			$bwlTruncateTables=true;
		}
		if(!beginswith($lowerThisLine, "set "))
		{
			$arrFoundTables=FindTables($thisline,  false);
			if(is_array($arrFoundTables))
			{
				foreach($arrFoundTables as $thisfoundtable)
				{
					if(!array_key_exists($thisfoundtable, $arrTables))
					{
						if(contains($thisfoundtable, "."))
						{
							$bwlIncludeDatabaseName=true;
						}
						$arrTables[$thisfoundtable]=1;
						$tablecount++;
					}
					else
					{
						$arrTables[$thisfoundtable]++;
					}
				
				}
			}
		}
		else
		{
			$bwlAutoIncsRelocatable=true;
		}
	
	
	}
	asort($arrTables);
	$out.= "<script src=\"tf_tablesort.js\"><!-- --></script>";
	$tableheader=TableBegin(630, "idsorttable2");
	$out.=$tableheader;
	$out.=htmlrow("bgclassline", "<a href=\"javascript: SortTable('idsorttable2', 0)\">table</a>", "<a href=\"javascript: SortTable('idsorttable2', 1)\">mentions in SQL</a>" );
	foreach($arrTables as $k=>$v)
	{
		if($k!="")
		{
			$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);

			$out.=htmlrow($strThisBgClass, $k, $v );
		}
	
	}
	$out.=TableEnd();
	$out.=str_replace("idsorttable2", "idsorttable3", $tableheader);
	$out.=htmlrow("bgclassline", "<a href=\"javascript: SortTable('idsorttable3', 0)\">feature</a>", "<a href=\"javascript: SortTable('idsorttable3', 1)\">implemented?</a>" );
	$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
	$out.=htmlrow($strThisBgClass, "autoincrements relocatable",  IntToSQLBoul($bwlAutoIncsRelocatable) );
	$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
	$out.=htmlrow($strThisBgClass, "includes database name",  IntToSQLBoul($bwlIncludeDatabaseName) );
	$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
	$out.=htmlrow($strThisBgClass, "includes table creations",  IntToSQLBoul($bwlCreates) );
	$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
	$out.=htmlrow($strThisBgClass, "deletes tables first",  IntToSQLBoul($bwlDropTables) );
	$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
	$out.=htmlrow($strThisBgClass, "deletes data first",  IntToSQLBoul($bwlTruncateTables) );
	$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
	$out.=htmlrow($strThisBgClass, "contains recursively-associated data",  IntToSQLBoul($bwlRecursive) );
	$out.=TableEnd();
	//$out.="<script>NumberRows('idsorttable2', 1);</script>";
	//$out.="<script>NumberRows('idsorttable3', 1);</script>";
	return $out;
		
}

?> 
 