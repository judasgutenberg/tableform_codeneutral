<?php
//Judas Gutenberg, nov 26 2006
//tools for a tableform mysql db
//This code is covered under the GNU General Public License
//info here: http://www.gnu.org/copyleft/gpl.html
//the digest is as follows: you cannot modify this code without
//publishing your source code under the same license
//contact the developer at gus@asecular.com  http://asecular.com


function  GenerateDataSQL($strDatabase, $strTable, $bwlAddSlashes=false, $bwlNoDBMention=false, $bwlHTMLEsc=false, $tableprefix="", $rowlist="*", $bwlrecursivebackup=false, $bwlnullpks=false)
//creates a SQL-based dump of a table's data
//can handle recursive backups of related data and the moving of data (PKs and related FKs) 
//into fresh new autoinc PK ranges
//Judas Gutenberg, jan 9 2007
{

	$sql=conDB();
	$out="";
	$strSQL="SELECT * FROM " . $strDatabase . "." .  $strTable;
	$wherclause="";
	$strThisSpecialID="@rootpk";
	
	$intSpecialIDCount=0;
	$pkname=PKLookup($strDatabase, $strTable);
	$bwlThisIsAutoIncPK=hasautocount($strDatabase, $strTable);
					 
					 
	if($rowlist!="*")
	{
		$arrRowlist=explode(" ", $rowlist);
		
		
		if(!contains($pkname, " ")  && $bwlThisIsAutoIncPK) //can't handle multi-part PKs!
		{
			$wherclause=" WHERE ";
			foreach($arrRowlist as $thisID)
			{
				$wherclause.=" " . $pkname . "='" . $thisID . "' OR";
			
			}
			$wherclause=substr($wherclause, 0, strlen($wherclause)-3);
		}
		$strSQL.=$wherclause;
	}
	if($bwlnullpks   && !contains($pkname, " "))
	{
		$out.="\nSET " . $strThisSpecialID ."=(SELECT MAX( " . $pkname . " ) +1 FROM " .  IfAThenB(!$bwlNoDBMention, $strDatabase . ".") . $strTable . ");";
	}
	//echo "===" . $strSQL;
	//die();
	$records =  $sql->query($strSQL);
	$rowcount=0;
	$out.="\n";
	$pkname=PKLookup($strDatabase, $strTable);
	$bwlColListCreated=false;
	$colList="";
	foreach($records as $record)
	{
		if($bwlNoDBMention)
		{
			$out.="\nINSERT INTO " . $tableprefix . $strTable . "(";
		}
		else
		{
			$out.="\nINSERT INTO " . $strDatabase . "." . $tableprefix . $strTable . "(";
		}
 		$insertdata="";
		
		foreach($record as $k=>$field)
		{
			//$bwlnullpks
			
			$bwlFieldIsPK=false;
			if($k==$pkname)
			{
				$bwlFieldIsPK=true;
				$id=$field;
				if(!$bwlColListCreated)//i keep from doing the expensive lookup of hasautocount for every export row
				{
				}
			}
			if(!$bwlColListCreated  && (!($bwlFieldIsPK  && $bwlnullpks)  || $bwlrecursivebackup))
			{
				$colList.=$k . ",";
			}
			
	 		if($bwlrecursivebackup  && ($bwlFieldIsPK && $bwlThisIsAutoIncPK)  && $bwlnullpks )
			{
				$insertdata.=  $strThisSpecialID . " + " .  $intSpecialIDCount . ",";
				
			}
			else if(($bwlFieldIsPK && $bwlThisIsAutoIncPK)  && $bwlnullpks  && !$bwlrecursivebackup)
			{
			
			}
			else if($bwlHTMLEsc)
			{
				$insertdata.= "'" . str_replace("'", "&#39;", $field). "',";
			}
			else if($bwlAddSlashes)
			{
				$insertdata.= "'" . addslashes($field). "',";
			}
		
			else
			{
				$insertdata.= "'" . $field. "',";
			}
			$rowcount++;
		}
		if(!$bwlColListCreated)
		{
			$colList=RemoveEndCharactersIfMatch($colList, ",");
		}
				
		$bwlColListCreated=true;
		$insertdata=RemoveEndCharactersIfMatch($insertdata, ",");
		$out.=$colList . ") VALUES(" . $insertdata  . ");";
		//$out.=$insertdata . ");\n";
		if($bwlrecursivebackup)
		{
			//echo $pkname . " " . $id . "<br>";
			$strThisSpecialIDToPass=$strThisSpecialID . " + " .  $intSpecialIDCount;
			if(!$bwlnullpks)
			{
				$strThisSpecialIDToPass="";
			}

			$out.=ScriptOutRelatedData($strDatabase, $strTable, $pkname, $id, 0, $tableprefix, $bwlNoDBMention, $bwlnullpks, $strThisSpecialIDToPass);
		
		
		}
		$intSpecialIDCount++;
	}
	$out.="\n";
	return $out;
}

function ScriptOutRelatedData($strDatabase, $strTable, $pk, $strOurID, $depth, $tableprefix="", $bwlNoDBMention=false, $bwlnullpks=false, $forceID="")
//inside a particular database, find all the tables that have a foreign key relationship with the given item and //and script out all the items in those tables connected to our item recursively
//under some circumstances ($bwlnullpks), the PKs and FKs will have to be changed on insert, but there 
//is code for that too.
//Judas Gutenberg February 21, 2008
{
	//echo $strTable . " " . $forceID . "<br>";
	$outscript="";
	$numout=0;
	$thisset=0;
	if($strOurID!="")
	{
		$sql=conDB();
		//the following query makes everything easy because I have a relation table!!!
		$strSQL="SELECT * FROM " . $strDatabase . "." .  tfpre . "relation WHERE f_table_name='" . $strTable . "' AND relation_type_id=0 ORDER BY table_name ASC";
		$fkrecords = $sql->query($strSQL);
		$intUnnameditemcount=1;
		$oldTable="";
		$depth++;
		$intThisSpecialID=-2000;
		$intParallelPKCount=0;

		foreach ($fkrecords as $fkrecord)
		{
			$intSpecialIDCount=0;
			//i have to include depth in the names of the MySQL variables to avoid reuse
			$strThisSpecialID="@associatedpk" . $intParallelPKCount .  "_" . $depth ;
			
			$strTheirTable=$fkrecord["table_name"];
		    //now we have a tablename, let's look to see if there are foreign keys pointing back to our table
			$thistableinfo="";
			$strTheirIDColumnName=PKLookup($strDatabase, $strTheirTable);
			$bwlThisIsAutoIncPK=hasautocount($strDatabase, $strTable);
			if($bwlnullpks  && !contains($strTheirIDColumnName, " ")  && $bwlThisIsAutoIncPK)
			{
				//it isn't easy to generate fresh new AND compatible autoincrement IDs when inserting related
				//data. I do it by setting a MySQL variable to the next available PK during the insert and
				//rolling the numbers up from there, keeping track of them so I can be sure to have the
				//related data properly linked.
				$outscript.="\nSET " . $strThisSpecialID ."=(SELECT MAX( " . $strTheirIDColumnName . " ) +1 FROM " .  IfAThenB(!$bwlNoDBMention, $strDatabase . ".") . $strTheirTable . ");";
			}
			$strSQL="SELECT * FROM " . $strDatabase . "." .  $strTheirTable . " WHERE " . $fkrecord["column_name"] . " =  " . $strOurID;
			$records = $sql->query($strSQL);
			$bwlColListCreated=false;
			$colList="";
		 
			foreach ($records as $record )
			{
				$idToUse=$record[$fkrecord["column_name"]];
				if($bwlNoDBMention)
				{
					$outscript.="\nINSERT INTO " . $tableprefix . $strTheirTable . "(";
				}
				else
				{
					$outscript.="\nINSERT INTO " . $strDatabase . "." . $tableprefix . $strTheirTable . "(";
				}
				$insertdata="";
				$bwlFieldIsPK=false;
				foreach($record as $k=>$field)
				{
					$bwlFieldIsPK=false;
					if($k==$strTheirIDColumnName)
					{
						$bwlFieldIsPK=true;
						$id=$field;
						if(!$bwlColListCreated)//i keep from doing the expensive lookup of hasautocount for every export row
						{
						}
					}
					//if(!$bwlColListCreated  && !(($bwlFieldIsPK  && $bwlThisIsAutoIncPK) && $bwlnullpks))
					//trouble with single quotes::
					$field=str_replace( "'", "\\'", $field);
					if(!$bwlColListCreated && ((!($bwlFieldIsPK && $bwlThisIsAutoIncPK) || $forceID!="") || !$bwlnullpks))
					{
						$colList.=$k . ",";
					}
					if(($bwlFieldIsPK && $bwlThisIsAutoIncPK)  && $bwlnullpks )
					{
						//$insertdata.= "'" . $intThisSpecialID .  "',";
						$insertdata.=  $strThisSpecialID . " + " .  $intSpecialIDCount . ",";
						
					}
					else if($forceID!="" && $k==$pk  && $bwlnullpks)
					{
						$insertdata.= $forceID . ",";
					}
					else if(($bwlThisIsAutoIncPK && $bwlFieldIsPK)  && $bwlnullpks)
					{
					}
					else if($bwlHTMLEsc)
					{
						$insertdata.= "'" . str_replace("'", "&#39;", $field). "',";
					}
					else if($bwlAddSlashes)
					{
						$insertdata.= "'" . addslashes($field). "',";
					}
					else
					{
						$insertdata.= "'" . $field. "',";
					}
					$rowcount++;
				}
				if(!$bwlColListCreated)
				{
					$colList=RemoveEndCharactersIfMatch($colList, ",");
				}
				$bwlColListCreated=true;
				$insertdata=RemoveEndCharactersIfMatch($insertdata, ",");
				$outscript.=$colList . ") VALUES(" . $insertdata  . ");";
				//$outscript.=$insertdata . ");\n";
				if($depth<5)
				{
					if($id!="")
					{
						$strThisSpecialIDToPass=$strThisSpecialID .  " + " .  $intSpecialIDCount;
						if(!$bwlnullpks)
						{
							$strThisSpecialIDToPass="";
						}
						$outscript.=ScriptOutRelatedData($strDatabase, $strTheirTable, $strTheirIDColumnName, $id, $depth, $tableprefix , $bwlNoDBMention,  $bwlnullpks, $strThisSpecialIDToPass);
						$intSpecialIDCount++;
					}
				}
			}
			$intParallelPKCount++;
		}
	}
	return $outscript;
}

function  GenerateStructureSQL($strDatabase, $strTable, $tableprefix="", $tablepostfix="")
//creates a SQL-based dump of a table's structure
//Judas Gutenberg, jan 9 2007
{
	$sql=conDB();
	$out="";
	$strSQL="SHOW CREATE TABLE " . $strDatabase . "." . $strTable;
	//echo $strSQL;
	$records =  $sql->query($strSQL);
	$record=$records[0];
	$out= $record["Create Table"] . ";\n\n";
	if($tableprefix!="")
	{
		$out=str_replace("CREATE TABLE `","CREATE TABLE `" . $tableprefix, $out);
	}
	if($tablepostfix!="")
	{
		$out=str_replace("CREATE TABLE `" . $tableprefix .  $strTable ,"CREATE TABLE `" . $tableprefix .  $strTable . $tablepostfix, $out);
	}
	$out = "\n\n" . $out;
	return $out; 
}

function  BackupSQLSafe($strDatabase, $tablenamein="", $bwlAddSlashes=false, $bwlDelete=false, $bwlDropOld=false, $bwlNoSchema=false, $bwlNoCharsetCrap=false, $bwlNoDBMention=false, $bwlHTMLEsc=false, $tableprefix="", $rowlist="*", $bwlrecursivebackup=false, $bwlnullpks=false)
//creates a SQL-based dump of a db's data and structure
//this will work when mysqldump is failing
//Judas Gutenberg, jan 9 2007
{
	$out="";
	$strFieldName="Tables_in_" . str_replace("`", "", $strDatabase);
	$tables=TableList($strDatabase);
	foreach ($tables as  $k=>$v )
	{
		$tablename=$v[$strFieldName];
		
		if($tablename==$tablenamein  || $tablenamein=="")
		{
			
			
			if(!$bwlNoSchema  || $bwlDropOld)
			{
				//echo  "-" . $bwlNoSchema . "-" . $bwlDropOld;
				//die("");
				if($bwlDropOld)
				{
					if($bwlNoDBMention)
					{
						$out.="\nDROP TABLE " . $tableprefix . $tablename . ";\n";
					}
					else
					{
						$out.="\nDROP TABLE " . $strDatabase . "." . $tableprefix . $tablename . ";\n";
					}
				}
				
				$out.=GenerateStructureSQL($strDatabase, $tablename, $tableprefix);
				if($bwlNoCharsetCrap)
				{
					$pos=strrpos($out, ")");
					if($pos>0)
					{
						$out=substr($out, 0, $pos+1) . ";";
					}
				}
			}
			if($bwlDelete)
			{
				if($bwlNoDBMention)
				{
					$out.= "\nTRUNCATE TABLE " . $tableprefix . $tablename . ";\n";
				}
				else
				{
					$out.= "\nTRUNCATE TABLE " . $strDatabase . "." . $tableprefix . $tablename . ";\n";
				}
				
			}
			$out.=GenerateDataSQL($strDatabase, $tablename, $bwlAddSlashes, $bwlNoDBMention, $bwlHTMLEsc, $tableprefix, $rowlist, $bwlrecursivebackup, $bwlnullpks);
			
		}
	}
	return $out . "\n";
}

function backupDBtoSQL($strDatabase, $tablename="", $bwlAddSlashes=false,  $bwlDelete=false, $bwlDropOld=false, $bwlNoSchema=false, $bwlNoCharsetCrap=false, $bwlJustSQL=false, $bwlNoDBMention=false, $bwlHTMLEsc=false, $tableprefix="", $rowlist="*", $bwlrecursivebackup=false, $bwlnullpks=false)
//Creating a backup of MySQL DB using PHP.
//All of the hard work is done using built-in MySQL utility called mysqldump.
//Step 1 (backup): Create backup & D/L to local PC
{
	ini_set('memory_limit','950M');
	set_time_limit(9999);
	//return  BackupSQLSafe($strDatabase);
	$host = con_server_web;
	$dbuser = con_user_web;
	$dbpword = con_pwd_web;
	$dbname = $strDatabase;
	$bwlSafeMethod=false;
	$bwlSafeMethod= $bwlDelete || $bwlDropOld  || $bwlSchema;
	if (!defined("locationofmysqldump"))
	{
		$locationofmysqldump="/usr/local/bin/";
	}
	else
	{
		$locationofmysqldump="";
	}
	$len="";
	$backupFile= date("Y-m-d") . "-" . $strDatabase . IfAThenB($tablename, "-") . $tablename . '-backup.sql';

 
	//error_reporting(6143);
	# Use system functions: MySQLdump & GZIP to generate compressed backup file
	//echo $host . " " . $dbuser . " " . $dbpword . " " . $dbname;
	if(!$bwlSafeMethod)
	{
		if($tablename=="")
		{
			$command =  $locationofmysqldump . "mysqldump -q --force   -h" . $host . " -u" . $dbuser . " -p" . $dbpword . " " . $dbname . "  > " . $backupFile;
		}
		else
		{
			$command =  $locationofmysqldump . "mysqldump -q --force   -h" . $host . " -u" . $dbuser . " -p" . $dbpword . " " . $dbname . "  --tables " . $tablename . " > " . $backupFile;
		
		}
		//echo $command;
		system($command);
		# Start the download process
		$len=0;
		if (file_exists($backupFile))
		{
			$len = filesize($backupFile);
		}
	}
	else
	{
		$len=0;
	}
	if($len<1 || $bwlJustSQL  || $rowlist!="*"  || $bwlnullpks)
	{
		//error_reporting($errorlevel);
		$bwlSafeMethod=true;
		$out= BackupSQLSafe($strDatabase, $tablename, $bwlAddSlashes, $bwlDelete, $bwlDropOld, $bwlNoSchema, $bwlNoCharsetCrap, $bwlNoDBMention, $bwlHTMLEsc, $tableprefix, $rowlist, $bwlrecursivebackup, $bwlnullpks);
		if($bwlJustSQL)
		{
			
			return $out;
		}
		$len=strlen($out);
	}

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
	if ($bwlSafeMethod)
	{
		echo $out;
	}
	else
	{
		@readfile($backupFile);
		unlink($backupFile);
		# Delete the temporary backup file from server
	}
}

function downloadData($data, $mimetype, $name)
{
	$status = 0;
	if ($data != "") 
	{
		if(isset($_SERVER['HTTP_USER_AGENT']) && preg_match("/MSIE/", $_SERVER['HTTP_USER_AGENT']))
		{
		// IE Bug in download name workaround
			ini_set( 'zlib.output_compression','Off' );
		}
		header ('Content-type: ' . $mimetype);
		header ('Content-Disposition: attachment; filename="'.$name.'"');
		header ('Expires: '.gmdate("D, d M Y H:i:s", mktime(date("H")+2, date("i"), date("s"), date("m"), date("d"), date("Y"))).' GMT');
		header ('Accept-Ranges: bytes');
		// Use Cache-control: private not following:
		// header ('Cache-control: no-cache, must-revalidate');
		header('Cache-control: no-cache, must-revalidate');                 
		header ('Pragma: private');
		$size=strlen($data);
		if(isset($_SERVER['HTTP_RANGE'])) 
		{
			list($a, $range) = explode("=",$_SERVER['HTTP_RANGE']);
			//if yes, download missing part
			str_replace($range, "-", $range);
			$size2 = $size-1;
			$new_length = $size2-$range;
			header("HTTP/1.1 206 Partial Content");
			header("Content-Length: $new_length");
			header("Content-Range: bytes $range$size2/$size");
		}
		else
		{
			$size2=$size-1;
			header("Content-Range: bytes 0-$size2/$size");
			header("Content-Length: ".$size);
		}
		print $data;
	
	}
	return($status);
}


function CopyTFRelationsForCopiedTable($strDatabase, $strOldTable, $strNewTable, $bwlRelateNewPKtoOldPK=false)
{
	$sql=conDB(); 
	$out="";
	$strSQL="SELECT * FROM " . $strDatabase . "." . tfpre . "relation WHERE table_name='" .  $strOldTable . "'";
	$records=$sql->query($strSQL);
	$pk= highestprimarykey($strDatabase,  tfpre . "relation" )+1;
	foreach($records as $record)
	{
		$record["table_name"]=$strNewTable;
		$record["relation_id"]=$pk;
		UpdateOrInsert($strDatabase, tfpre . "relation","", $record,  true,  false);
		$pk++;
		
	}
	$strSQL="SELECT * FROM " . $strDatabase . "." . tfpre . "relation WHERE f_table_name='" .  $strOldTable . "'";
	$records=$sql->query($strSQL);
	$pk= highestprimarykey($strDatabase,  tfpre . "relation")+1;
	foreach($records as $record)
	{
		$record["f_table_name"]=$strNewTable;
		$record["relation_id"]=$pk;
		UpdateOrInsert($strDatabase, tfpre . "relation","", $record,  true,  false);
		$pk++;	
	}
	if($bwlRelateNewPKtoOldPK)
	{
		$pk=PKLookup($strDatabase, $strOldTable);
		$arrPK=explode(" ", $pk);
		foreach($arrPK as $thispk)
		{
			$out.=NewRelation($strDatabase, $strNewTable, $thispk,  $strOldTable , $thispk);
			$out.=NewRelation($strDatabase, $strOldTable, $thispk,  $strNewTable , $thispk);
		}
	}
	return $out;
}



function BackupRowsToBackupTable($strDatabase, $strTable, $arrID, $strPrefix="", $strPostfix="_backup", $bwlDeleteOriginals=false, $bwlCreateRelationsForNewTable=true)
{
//copies the records specified by the associative array $arrID to a backup table, creating one on the fly if necessary
//also copies tf relations for the new table
//April 21 2009 Judas Gutenberg
	$sql=conDB();
	$strNewTableName= $strPrefix. $strTable. $strPostfix;
	if(!TableExists($strDatabase, $strNewTableName))
	{
	
		$strSQL=GenerateStructureSQL($strDatabase, $strTable, $strPrefix, $strPostfix);
		$sql->query($strSQL);
		if($bwlCreateRelationsForNewTable)
		{
			CopyTFRelationsForCopiedTable($strDatabase, $strTable, $strNewTableName);
		}
	}
	//the following line would work if $arrID specified only a single row:
 	//$recordtobebackedup=GenericDBLookupFromArray($strDatabase, $strTable, $arrID, "", false, true);
	//but this function, which originally was called BackupRowToBackupTable, can handle multiple rows
	$strSQL="SELECT * FROM " . $strDatabase . "." . $strTable . " WHERE " . ArrayToWhereClause($arrID);
	
	$recordtobebackedups=$sql->query($strSQL);
	foreach($recordtobebackedups as $recordtobebackedup)
	{
	//echo var_dump($recordtobebackedup);
		$pk=UpdateOrInsert($strDatabase, $strNewTableName,"", $recordtobebackedup,  true,  false);
	}
	if($bwlDeleteOriginals)
	{
		$strSQL="DELETE FROM " . $strDatabase . "." . $strTable . " WHERE " . ArrayToWhereClause($arrID);
		//echo $strSQL;
		//die();
		$sql->query($strSQL);
	}
	 
	return $pk;
}
?>
