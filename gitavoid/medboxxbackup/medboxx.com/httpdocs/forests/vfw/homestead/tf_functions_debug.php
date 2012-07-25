<?php 

//debug functions///////////
  
function HexDump($strIn)
//A debugging function to allow me to see what hexcodes make up a vexing mystery string.
{
	$out="";
	for($i=0; $i<strlen($strIn); $i++)
	{
		$out.=ord(substr($strIn, $i, 1)) . " ";
	}
	return $out;
}

function logmysqlerror($strSQLin="", $bwlMakeTableIfNecessary=false, $error="", $strDatabase="")
{
	$strTable="mysql_errorlog";
	if($strDatabase=="")
	{
		$strDatabase=our_db;
	}
	 
	if($error=="")
	{
		$error=sql_error();
	}
	$strSQL="
		CREATE TABLE `" . $strTable ."` (
		`" . $strTable ."_id` int(11) NOT NULL auto_increment,
		`time_done` timestamp NULL default NULL,
		`ip_address` varchar(33) default NULL,
		`mysql_error` text,
		`info` text,
		`sql_query` text,
		PRIMARY KEY (`" . $strTable ."_id`)
		) ";
		//die($strSQL);
	if($bwlMakeTableIfNecessary)
	{
		if(!TableExists($strDatabase, $strTable))
		{
			$sql=conDB();
			$records = $sql->query($strSQL, true, $strDatabase);
		}
	}
	
	if(TableExists($strDatabase, $strTable))
	{
		UpdateOrInsert($strDatabase, $strTable, "", Array("ip_address"=>$_SERVER['REMOTE_ADDR'], "time_done"=> date("Y-m-d H:i:s"), "mysql_error"=>$error, "info"=>mysql_info(), "sql_query"=>$strSQLin), true, false, true);
	}
}

function logform($bwlMakeTableIfNecessary=true)
{
	logcollection($bwlMakeTableIfNecessary, $_REQUEST, "request", true, false, true);
}

function logcollection($bwlMakeTableIfNecessary=true, $collection, $label="", $comments="")
{
 
	$strTable="formlog";
	//echo $strTable . "==<BR>";
	$strDatabase=our_db;
	$strSQL="
		CREATE TABLE `" . $strTable ."` (
		`" . $strTable ."_id` int(11) NOT NULL auto_increment,
		`time_done` timestamp NULL default NULL,
		`ip_address` varchar(33) default NULL,
		`referer` varchar(211) default NULL,
		`label` text,
		`form_content` text,
		`comments` text,
		PRIMARY KEY (`" . $strTable ."_id`)
		) ";
	if($bwlMakeTableIfNecessary)
	{
		if(!TableExists($strDatabase, $strTable))
		{
			$sql=conDB();
			$records = $sql->query($strSQL);
		}
	}
//logs the serialized request object;  used for debugging or seeing what exactly an idiot user is doing that keeps fucking things up
	
 
	if(TableExists($strDatabase, $strTable))
	{
		
		$content=serialize($collection);
		$referer=$_SERVER['HTTP_REFERER'];
		UpdateOrInsert($strDatabase, $strTable, "", Array("comments"=>$comments, "label"=>singlequoteescape($label),"referer"=>$referer, "ip_address"=>$_SERVER['REMOTE_ADDR'], "time_done"=> date("Y-m-d H:i:s"), "form_content"=>$content), true, false, true);
	}
}

?>