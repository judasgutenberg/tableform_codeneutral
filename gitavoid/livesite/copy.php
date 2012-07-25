<?php
$strPathPre="tf/";
$urlroot="http://www.featurewell.com/";
include($strPathPre . "tf_constants.php");
include($strPathPre . "tf_functions_core.php");
include($strPathPre . "tf_functions_editor.php");
include($strPathPre . "tf_functions_frontend_db.php");


 
echo main();
 


function main()
{
	GLOBAL $db_type;
	if(!IsExtraSecure())
	{
		die(ExtraSecureFailure());
	}
 	$maxrows=500;
	//$olderror=error_reporting(0);
	//$mode=$_REQUEST[qpre . "mode"];
	$strDatabase=deMoronizeDB(gracefuldecay($_REQUEST[qpre . "db"],our_db));
	$strColumn=$_REQUEST[qpre . "column"];
	$comprehensivesearch=gracefuldecaynumeric($_REQUEST[qpre . "comprehensivesearch"],0);
	error_reporting($olderror);
	$strPHP=$_SERVER['PHP_SELF'];
	$strValDefault=$_REQUEST["ID"];
	$maxids=$_REQUEST["maxids"];
	$strTable="article";
	$out="";
	//echo $id . " " .$idfield ;
	//$out=LoginDecisions($strDatabase,  $strPHP, $strUser, true);
	$db_type= 'odbc';
 	$mode=$_REQUEST["mode"];
	$strUser="root";
	if ($strUser!="")
	{
	
		//$intAdminType= AdministerType($strDatabase, $strTable, $strUser);
 
		if (1==1)
		{
			
			if($strTable==""  || $strValDefault=="")
			{
		
				//$records=odbc_query("select * from 	article where id<600" );
				//$out.=GenericRSDisplayFromRS($strPHP,"old way", $records, 1, 999);
			}
			else
			{
				
				//$out.=TableForm("dbo", $strTable, "ID", $strValDefault, $strPHP,  "","", "",  "", "", "", "odbc");
			}
			
			
			$out.=CopyForm($strDatabase, $maxids);
			//$errors=CopySchemaFromODBCToMySQL();
			
			if($_REQUEST["submit"]!="")
			{
				$sqlout=SyncDataFromODBCToMySQL($maxrows, $tables, "", $maxids);
				$len=strlen($sqlout);
				if(1==1)
				{
				header("Pragma: public");
				header("Expires: 0");
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header("Cache-Control: public"); 
				header("Content-Description: File Transfer");
				header("Content-Type: application/gzip");
				header("Content-Disposition: attachment; filename=deltasql.sql;");
				header("Content-Transfer-Encoding: binary");
				header("Content-Length: ".$len);
				 
				echo $sqlout;
				}
		
				die();
				
			}
			else if($mode=="updatemysql")
			{
				$errors=SyncDataFromODBCToMySQL($maxrows, $tables);
				$out.=DisplayTableResults($tables);
			}	
			else if($mode=="mysqlmaxid")
			{
				//echo "$";
				$listtitle="MySQL Max IDs";
				$list=SyncDataFromODBCToMySQL($maxrows, $tables, "onlymysqlids");
			
			}
			else if($mode=="odbcmaxid")
			{
				$listtitle="ODBC Max IDs";
				$list=SyncDataFromODBCToMySQL($maxrows, $tables, "onlyodbcids");
			}
			if($list!="")
			{
				
				$out.="<b>" . $listtitle . "</b><br>";
				$out.="<pre>" . $list . "</pre>";
			
			}
			
					
			//SyncDataFromODBCToMySQL(500, $tables);
			//SyncDataFromODBCToODBC(500, $tablesout);
			
			
			
			//$out.="<b>Tables hit:</b>: " . $tables;
			$out.=IfAThenB($errors, "<div class=\"feedback\">" . $errors . "</div>");
			//$records=odbc_DBExplain("dbo", "article");
			//$out.=GenericRSDisplayFromRS($strPHP,"old way", $records, 1, 999);
			//echo count($records);
			//foreach($records as $record)
			{
				//$out.=GenericRSDisplayFromRS($strPHP,"old way", $record, 1, 999);
			}
		}
		
	}
	$out =  PageHeader($strDatabase . " : mssql browser", $strConfigBehave) . $out . PageFooter();
	//echo $out;
	return $out;
}

function DisplayTableResults($tables, $strLabel="Tables Affected")
{
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strOtherBgClass="bgclassother";
	$strLineClass="bgclassline";
	$tables=trim($tables);
	$out="";
	$out.=htmlrow($strLineClass, $strLabel);
	if($tables!="")
	{
		$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
		$arrTables=explode(" ", $tables);
		foreach($arrTables as $thistable)
		{
			$out.=htmlrow($strThisBgClass,"<a href=\"tableform.php?" . qpre . "db=featurewell&" . qpre . "table="  . $thistable . "&" . qpre . "mode=view\">"  . $thistable . "</a>");
		}
	
	}
	$out=TableEncapsulate($out, false);
	return $out;
}

function CopyForm($strDatabase, $maxids)
{
	$out="";
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strOtherBgClass="bgclassother";
	$strLineClass="bgclassline";
	$sourcename="ODBC";
	$destname="MySQL";
	$preout.=adminbreadcrumb(false,  $strDatabase, "tableform.php?" . qpre . "db=" . $strDatabase,  "data copier");
	$preout.="<form name=\"BForm\" method=\"post\" action=\"copy.php\" onSubmit=\"  \">\n";
	$out.=htmlrow($strClassFirst, "<a href=\"copy.php?mode=updatemysql\">Update " . $destname . " DB from " . $sourcename . " DB</a>");
	$out.=htmlrow($strClassSecond, "<a href=\"copy.php?mode=mysqlmaxid\">Generate " . $destname . " Max ID List</a>");
	$out.=htmlrow($strClassFirst, "<a href=\"copy.php?mode=odbcmaxid\">Generate ". $sourcename ." Max ID List</a>");
	$out.=htmlrow($strClassSecond,  GenericInput("maxids",$maxids,  false,  "",   "",  "", "text", "40",  "", 30,  false));
	$out.=htmlrow($strClassSecond,  GenericInput("submit","Get Update Based on this Max ID List"));
	$out.= HiddenInputs(Array("db"=>$strDatabase));
	$out=$preout . TableEncapsulate($out, false);
	$out.="</form>";
	return $out;
}

function CopySchemaFromODBCToMySQL()
{
	GLOBAL $db_type;
	$sql=conDB();
	$db_type="odbc";
	$strDatabase="dbo";
	$tables=TableList($strDatabase);
	$errors="";
	foreach($tables as $table)
	{
		$db_type="odbc";
		$strDatabase="dbo";
		$tablename= $table["Tables_in_" . str_replace("`", "", $strDatabase)];
		//TableExplanationToTableCreationSQL($strDatabase, $strTable, $bwlGuessPK=true, $bwlGuessAutoInc=true);
		//echo $tablename . "<BR>";
		$strCreationSQL=TableExplanationToTableCreationSQL($strDatabase, $tablename, true, true);
		$db_type="";
		$strDatabase="featurewell";
		
		if(!TableExists($strDatabase, $tablename))
		{
			$records = $sql->query($strCreationSQL, true, $strDatabase);
		}
		//echo "-" . TableExists($tablename) . "-<BR>";
		//echo $tablename . " <br>"; 
		//echo "<pre>" . $strCreationSQL . "</pre>";
		//echo  "<P>";
		$error= sql_error();
		//echo  $error;
		$errors.= $error . IFAThenB($error  ,"<br>\n" );
		
	}
	return $errors;
}


function SyncDataFromODBCToMySQL($maxinago=300, &$tablesout, $mode="", $maxids="")
{
	GLOBAL $db_type;
	$sql=conDB();
	$db_type="odbc";
	$strDatabase="dbo";
	$tables=TableList($strDatabase);
	$tablesout="";
	$rowcount=0;
	$out="";
	$bwlMaxidsource=false;
	$strSQLOut="";
	if($maxids!="")
	{
		$bwlMaxidsource=true;
	}
	foreach($tables as $table)
	{
		//TO ODBC
		$db_type="odbc";
		$strDatabase="dbo";
		$sourcetablename= $table["Tables_in_" . str_replace("`", "", $strDatabase)];
		//$sourcepk="ID";
		$sourcepk=PKLookup($strDatabase, $sourcetablename, true);
		$strSQL="SELECT MAX(" . $sourcepk . ") as thismax FROM " .   $sourcetablename;
		//echo $strSQL. "<BR>";
		$records=$sql->query($strSQL);
		$record=$records[0];
		$sourcemax=$record["thismax"];
		//echo $sourcetablename . " " . $sourcemax . "<BR>";
		//TO MYSQL
		$desttablename= $sourcetablename;
		if($bwlMaxidsource)
		{
			$destpk=$sourcepk;
			$destmax=trim(genericdata($desttablename,0, 1, $maxids, "\n", " ", false));
			//echo( $desttablename . "-" . $destmax . "-<BR>");
		}
		else
		{
			$db_type="";
			$strDatabase=our_db;
			$destpk=PKLookup($strDatabase, $desttablename, true);
			$strSQL="SELECT MAX(" . $destpk . ") as thismax FROM " . $strDatabase . "." .  $desttablename;
			//echo $strSQL  ."<P>";
			$records=$sql->query($strSQL);
			//echo "Did that";
			$record=$records[0];
			$destmax=gracefuldecaynumeric($record["thismax"],0);
		}
		
		if($mode=="onlymysqlids")
		{
	 
			$line=$desttablename . " " . $destmax . "\n";
		}
		else if($mode=="onlyodbcids")
		{
			$line=$sourcetablename . " " . $sourcemax . "\n";
		
		}
		//echo  $sourcetablename . " " . $sourcemax . " " . $destmax . "<BR>";
		else if($sourcemax>$destmax)
		{
			//TO ODBC
			$db_type="odbc";
			$strDatabase="dbo";
			$strSQL="SELECT TOP " . $maxinago. " * FROM " .   $sourcetablename . " WHERE " .  $sourcepk . ">" . $destmax . " ORDER BY " . $sourcepk . " ASC";
			//echo $strSQL;
			$records=$sql->query($strSQL);
			
			//echo $maxinago . " " . count($records) . "<BR>";
			//TO MYSQL
			if(!$bwlMaxidsource)
			{
				$db_type="";
				$strDatabase=our_db;
			}
			
			foreach($records as $record)
			{
				$strSQL="\nINSERT INTO " .   $desttablename . "(";
				$colList="";
				$insertdata="";
				foreach($record as $k=>$v)
				{
				
					$field=$v;
					$colList.=$k . ",";
					
					//put together an insert from that disconnected ODBC recordset
					$insertdata.= "'" . str_replace("'", "&#39;", $field). "',";
				
				}
				$colList=RemoveEndCharactersIfMatch($colList, ",");
				$insertdata=RemoveEndCharactersIfMatch($insertdata, ",");
				$strSQL.=$colList . ") VALUES(" . $insertdata  . ");";
				if( mysql_error()!="")
				{
					die($strSQL);
				}
				//echo "<font color=red>" . mysql_error() . "</font>" . "<P>";
				if($bwlMaxidsource)
				{	
					//echo $strSQL . "<BR>";
					$strSQLOut.=$strSQL . "\n";
				}
				else
				{
					$sql->query($strSQL);
				}
				$rowcount++;
				if($maxinago<$rowcount)
				{
					if($bwlMaxidsource)
					{
						
						return $strSQLOut;
					}
					else
					{
						return $out;
					}
				}
				if(!inList($tablesout, $sourcetablename ))
				{
					$tablesout.= $sourcetablename . " ";
				}
			}	
			
			
			
		}
		 
		if($line!="")
		{
			$out.=$line;
		}
		else if ($mode=="")
		{
			//$error= sql_error();
			$out.= $error . IFAThenB($error,"<br/>\n");
		}
	}

	if($bwlMaxidsource)
	{
		
		return $strSQLOut;
	}
 
	return $out;
}


function SyncDataFromODBCToODBC($maxinago=300, &$tablesout)
{
	GLOBAL $db_type;
	GLOBAL $source;
	$sql=conDB();
	$db_type="odbc";
	$strDatabase="dbo";
	$source="original";
	$tables=TableList($strDatabase);
	$tablesout="";
	$rowcount=0;
	foreach($tables as $table)
	{
		//TO ODBC SOURCE
		$db_type="odbc";
		$strDatabase="dbo";
		$source="original";
		$sourcetablename= $table["Tables_in_" . str_replace("`", "", $strDatabase)];
		echo $sourcetablename . "<BR>";
		$sourcepk=PKLookup($strDatabase, $sourcetablename, true);
		$strSQL="SELECT MAX(" . $sourcepk . ") as thismax FROM " .   $sourcetablename;
		//echo $strSQL. "<BR>";
		$records=$sql->query($strSQL);
		$record=$records[0];
		$sourcemax=$record["thismax"];
		
		//TO ODBC DEST
		$db_type="odbc";
		$strDatabase="dbo";
		$source="";
		$desttablename= $sourcetablename;
		$destpk=PKLookup($strDatabase, $desttablename, true);
		$strSQL="SELECT MAX(" . $destpk . ") as thismax FROM " . $strDatabase . "." .  $desttablename;
		//echo $strSQL  ."<P>";
		$records=$sql->query($strSQL);
		$record=$records[0];
		$destmax=gracefuldecaynumeric($record["thismax"],0);
		
		//echo  $sourcetablename . " " . $sourcemax . " " . $destmax . "<BR>";
		if($sourcemax>$destmax)
		{
			//TO ODBC SOURCE
			$db_type="odbc";
			$strDatabase="dbo";
			$source="original";
			$strSQL="SELECT TOP " . $maxinago. " * FROM " .   $sourcetablename . " WHERE " .  $sourcepk . ">" . $destmax . " ORDER BY " . $sourcepk . " ASC";
			//echo $strSQL;
			$records=$sql->query($strSQL);
			//echo $maxinago . " " . count($records) . "<BR>";
			
			//TO ODBC DEST
			$source="";
			$db_type="odbc";
			$strDatabase="dbo";
			$db_type="";
			$strDatabase=our_db;
			
			foreach($records as $record)
			{
				$strSQL="\nINSERT INTO " .   $desttablename . "(";
				$colList="";
				$insertdata="";
				foreach($record as $k=>$v)
				{
				
					$field=$v;
					$colList.=$k . ",";
					
					//put together an insert from that disconnected ODBC recordset
					$insertdata.= "'" . str_replace("'", "&#39;", $field). "',";
				
				}
				$colList=RemoveEndCharactersIfMatch($colList, ",");
				$insertdata=RemoveEndCharactersIfMatch($insertdata, ",");
				$strSQL.=$colList . ") VALUES(" . $insertdata  . ");";
				if( mysql_error()!="")
				{
					die($strSQL);
				}
				echo "<font color=red>" . mysql_error() . "</font>" . "<P>";
				$sql->query($strSQL);
				$rowcount++;
				if($maxinago<$rowcount)
				{
					return;
				}
				if(!inList($tablesout, $sourcetablename ))
				{
					$tablesout.= $sourcetablename . " ";
				}
			}	
			
			
			
		}
		
		$error= sql_error();
		$error.= $error . IFAThenB($error,"<br/>\n");
		
	}
	return $error;
}
 ?>