<?php

function odbc_query($strQuery, $strSpecial="")
{
	include("odbc_config.php");
	$conn = odbc_connect($connStr,$odbcuser,$odbcpass, SQL_CUR_USE_IF_NEEDED ) or die("Cannot start ADO");
	$recordsout=Array();
	if($strQuery=="tables")
	{
		$result=odbc_tables( $conn);
	}
	else if($strQuery=="columns")
	{
		$result=odbc_columns( $conn, $odbcdb, "%", $strSpecial);
	}
	else
	{	
		//echo $strQuery . "<p>";
		$result = odbc_exec( $conn, $strQuery);
	}
	$rowcount=0;
	while($row = odbc_fetch_array($result))
	{
		//echo "^woop^" . var_dump($row) . "<p>";
	  	//echo "<li>" . odbc_result($result, "ID") . " ".  odbc_result($result,"TITLE")  . " " . odbc_result($result,"SUBJECT")  .  " " . "</li>";
		$recordsout[$rowcount]=$row;
		$rowcount++;
	}
	
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
		foreach($record as $k=>$v)
		{
			echo $k . " " . $v . "<BR>";
		
		
		}
		echo  "<BR>";
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
		$sqlnullable="No";
		if($nullable)
		{
			$sqlnullable="Yes";
		}
		$arrThisRecord=array("Field"=>$columnname,"Type"=>$typespec, "Null"=>$sqlnullable);
		$recordout[$outcount]=$arrThisRecord;
		$outcount++;
	}

	//echo count($prerecords);
	return $recordout;
}


?>