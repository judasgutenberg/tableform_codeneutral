<?php
include_once("tf_functions_sql_parsing.php");

function odbc_query($strQuery, $strSpecial="")
{
	//echo "<font color=red>" . $strQuery . "</font><BR>";
	$bwlShowErrors=false;
	
	include("odbc_config.php");
	
	$conn = odbc_connect($connStr,$odbcuser,$odbcpass, SQL_CUR_USE_IF_NEEDED ) or die("Cannot start ADO");
	$olderror= error_reporting (0);
	$recordsout=Array();
	if($strQuery=="tables")
	{
		$result=odbc_tables( $conn);
	}
	else if($strQuery=="columns")
	{
		$result=odbc_columns( $conn, $odbcdb, "%", $strSpecial);
	}
	else if($strQuery=="pks")
	{
		$result=odbc_exec($conn, "sp_pkeys ".$strSpecial);
	}
	else
	{	
		//echo $strQuery . "<p>";
		
		//incredible as this might seem, i can't set up identity_insert in a disconnected recordset
		//but to do it at this point i need to know the name of the table
		//so, hack hack hacky hack-- i have to parse out the table from the query here!!!
		//THIS IS PROBABLY THE BIGGEST HACK NEEDED TO GET DATABASE FORKING TO WORK
		if(contains(strtoupper($strQuery), "INSERT"))
		{
			$tables=FindTables($strQuery, true);
			//echo $tables[0] . "<BR>";
			odbc_exec( $conn,"SET IDENTITY_INSERT " . $tables[0]. "  ON   ");
		}
		//echo  $strQuery . "<P>";
		$result = odbc_exec( $conn, $strQuery);
	}
	
	$rowcount=0;
	
	if($result)
	{
		if(is_resource($result))
		{
			while($row = odbc_fetch_array($result))
			{
				$arrError=error_get_last;
				if($arrError["type"]>1  && $bwlShowErrors)
				{
					echo "<br>ERROR DETECTED ON " . $strQuery . " " . $strSpecial . "\n<br>";
					//debug_print_backtrace();
					echo odbc_errormsg(). "\n<br>";
				}
				//echo "^woop^" . var_dump($row) . "<p>";
			  	//echo "<li>" . odbc_result($result, "ID") . " ".  odbc_result($result,"TITLE")  . " " . odbc_result($result,"SUBJECT")  .  " " . "</li>";
				$recordsout[$rowcount]=$row;
				$rowcount++; 
			}
			
			$arrError=error_get_last;
			if($arrError["type"]>1  && $bwlShowErrors)  
			{
				echo "<br>!ERROR DETECTED ON " . $strQuery . " " . $strSpecial . "\n<br>";
				//debug_print_backtrace();
				echo odbc_errormsg(). "\n<br>";
			}
		}
		else if ($bwlShowErrors)
		{
			echo "<br>+ERROR DETECTED ON " . $strQuery . " " . $strSpecial . "\n<br>";
			//debug_print_backtrace();
			echo odbc_errormsg(). "\n<br>";
		
		}
	
	}
	else if ($bwlShowErrors)
	{
		echo "<br>=ERROR DETECTED ON " . $strQuery . " " . $strSpecial . "\n<br>";
		//debug_print_backtrace();
		echo odbc_errormsg(). "\n<br>";
	}
	error_reporting ($olderror);
	odbc_close($conn);
	return $recordsout;
}

function odbc_TableExplain($strDatabase, $strTable, $bwlFollowRelations=false)
//explains the ms sql columns -- presenting the data in a format identical to the TableExplain function for mysql
{
	$recordout=array();
	$outcount=0;
	$prerecords=odbc_query("columns",  $strTable);
	//echo GenericRSDisplayFromRS($strPHP,"old way", $prerecords, 1, 999);
	foreach($prerecords as $record)
	{

		$columnname=$record["COLUMN_NAME"];
		$typename=$record["TYPE_NAME"];
		$typesize=$record["COLUMN_SIZE"];
		$nullable=$record["NULLABLE"];
		//echo $nullable . "<BR>";
		if(!inList("text", strtolower($typename)))
		{
			$typespec=$typename . "(" .$typesize . ")";
		}
		else
		{
			$typespec=$typename;
		}
		$sqlnullable="NO";
		if($nullable)
		{
			$sqlnullable="YES";
		}
		$arrThisRecord=array("Field"=>$columnname,"Type"=>$typespec, "Null"=>$sqlnullable);
		$recordout[$outcount]=$arrThisRecord;
		$outcount++;
	}
	$prerecords=odbc_query("pks",  $strTable);
	//echo  "<BR>-";
	//foreach($prerecords as $record)
	{
		//foreach($record as $k=>$v)
		{
		//	echo $k . " " . $v . "<BR>";
		}
		//echo  "<BR>-";
		//$pk=$record["PK_NAME"];
	}
	//echo count($prerecords);
	return $recordout;
}

function odbc_TableList($strDatabase, $likeclause="")
{
	$sql=conDB();
	$records=odbc_query("tables");
	$arrOut=Array();
	$outcount=0;
	foreach($records as $record)
	{
		$tablename=$record["TABLE_NAME"];
		
		$tablecat=$record["TABLE_CAT"];
		$tabletype=$record["TABLE_TYPE"];
		if(strtolower($tabletype)=="table")
		{
			//echo $tablename . "<BR>";
			$arrRecord=Array("Tables_in_" . $strDatabase=>$tablename);
			$arrOut[$outcount]=$arrRecord;
			$outcount++;
		}
		
	}
	return $arrOut;
}

//$recs= odbc_TableList("dbo") ;
//echo   GenericRSDisplayFromRS($strPHP,"old way", $recs, 1, 999);
//odbc_TableExplain($strDatabase, $strTable, $bwlFollowRelations);

?>