<?php
include("tf_functions_core.php");
include("tf_functions_editor.php");
include("tf_functions_frontend_db.php");
include("tf_odbc_functions.php");
include("tf_functions_backup.php");
include("fw_functions.php");
$errorlevel=error_reporting(E_STRICT);
	include("editor_files/config.php");
	include("editor_files/editor_class.php");
error_reporting($errorlevel);

set_time_limit(900);
 
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
	//error_reporting($olderror);
	$strPHP=$_SERVER['PHP_SELF'];
	$strValDefault=$_REQUEST["ID"];
	$maxids=$_REQUEST["maxids"];
	$strTable="article";
	$out="";
	//echo $id . " " .$idfield ;
	$out=LoginDecisions($strDatabase,  $strPHP, $strUser, true);
	//$db_type= 'odbc';
 	$mode=$_REQUEST["mode"];
	if ($strUser!="")
	{
	
		$intAdminType= AdministerType($strDatabase, $strTable, $strUser);
 
		if ($intAdminType>1)
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
			
			//$errors.= SyncDataFromODBCToODBC(500,  $tables);
			//$out.=DisplayTableResults($tables);
			$out.=CopyForm($strDatabase, $maxids);
			//$errors=CopySchemaFromODBCToMySQL();
			
			if($_REQUEST["submit"]!="")
			{
				$sqlout=SyncDataFromODBCToMySQL($maxrows, $tables, "", $maxids);
				echo DownloadPage($sqlout, "deltasql.sql", false);
				
			}
			else if($mode=="fixmeta")
			{
				$out.=FixBrokenMetadata($maxrows, $tablesout, $fixcount,  "");
				$errors.=$tablesout . " Tables were affected and " . $fixcount . " pieces of metadata were restored.";
			}
			else if($mode=="updatemysql")
			{
				$errors.=SyncFWODBCtoMySQL($maxrows, $tables, "");//can also be sqlonly
				//$errors.=SyncDataFromODBCToMySQL($maxrows, $tables);
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
			//$records=odbc_TableExplain("dbo", "article");
			//$out.=GenericRSDisplayFromRS($strPHP,"old way", $records, 1, 999);
			//echo count($records);
			//foreach($records as $record)
			{
				//$out.=GenericRSDisplayFromRS($strPHP,"old way", $record, 1, 999);
			}
		}
		
	}
	$out =  PageHeader($strDatabase . " : mssql browser", $strConfigBehave, "", true, false, "", $strDatabase) . $out . PageFooter();
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
			$out.=htmlrow($strThisBgClass,"<a href=\"tf.php?" . qpre . "db=featurewell&" . qpre . "table="  . $thistable . "&" . qpre . "mode=view\">"  . $thistable . "</a>");
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
	$strPHP=$_SERVER['PHP_SELF'];
	$sourcename="ODBC";
	$destname="MySQL";
	$preout.=adminbreadcrumb(false,  $strDatabase, "tf.php?" . qpre . "db=" . $strDatabase,  "data copier");
	$preout.="<form name=\"BForm\" method=\"post\" action=\"" . $strPHP . "\" onSubmit=\"  \">\n";
	$out.=htmlrow($strClassFirst, "<a href=\"" . $strPHP . "?mode=updatemysql\">Update " . $destname . " DB from " . $sourcename . " DB</a>");
	$out.=htmlrow($strClassSecond, "<a href=\"" . $strPHP . "?mode=mysqlmaxid\">Generate " . $destname . " Max ID List</a>");
	$out.=htmlrow($strClassFirst, "<a href=\"" . $strPHP . "?mode=odbcmaxid\">Generate ". $sourcename ." Max ID List</a>");
	$out.=htmlrow($strClassSecond, "<a href=\"" . $strPHP . "?mode=fixmeta\">Fix Meta Data for " . $destname . "</a>");
	$out.=htmlrow($strClassFirst,  GenericInput("maxids",$maxids,  false,  "",   "",  "", "text", "40",  "", 30,  false));
	$out.=htmlrow($strClassSecond,  GenericInput("submit","Get Update Based on this Max ID List"));
	$out.= HiddenInputs(Array("db"=>$strDatabase));
	$out=$preout . TableEncapsulate($out, false);
	$out.="</form>";
	return $out;
}
 
 
 
function LargeSQLScanner($url="featurewell.sql")
{
 
	$intStart=0;
	$intOut=0;

	if(file_exists($url))
	{
		echo "$";
		$handle=fopen ($url, "r"); 
		$content=fread($handle,filesize($url));
		$strLF=chr(10) . chr(13);
		$strGoSeek= $strLF . "GO" . $strLF;
		$intEnd=strpos($content, $strGoSeek, $intStart)-strlen($strGoSeek);
		$strThisBlockOfSQL=substr($content, $intStart, $intEnd-$intStart);
		echo "<br>-" . $strThisBlockOfSQL . "-<br>";
		
		
		if($intOut>5)
		{
			die();
		}
		$intOut++;
	}


}

 echo "*" . LargeSQLScanner("featurewell.sql");
 ?>