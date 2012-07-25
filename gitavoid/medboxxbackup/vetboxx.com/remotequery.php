<? 
//Gus Mueller September 2007
//handles a remote query, returning something similar to a recordset in flat-file form
 
 
 
include('tf_functions_core.php');
//include('tf_functions_frontend_db.php');

//$records= RemoteSQLCall("http://mymedicallife.com/stat/remotequery.php", "select * from website_hitday", remote_sql_password);
//foreach($records as $record)
//{
	//foreach($record as $k=>$v)
	//{
	//	echo $k . "----------" . $v . "<br>";
	
	
	//}



//}
 
echo remotesqlresponse();

function remotesqlresponse()
{
	$strDatabase=gracefuldecay($_REQUEST[qpre . "db"], our_db);
	$sql=conDB();
	
	
	$strSQL=$_REQUEST["sql"];
	$password=$_REQUEST["pwd"];
 	$strFieldDelimiter="|";
	$strRowDelimiter="^";
	
 
	$out="";
	if($password==remote_sql_password);
	{
		if ($strSQL!="")
		{
			$bwlNeedKeys=true;
			//mysql_select_db($strDatabase);
			$records = $sql->query($strSQL);
			foreach ($records as $key=>$value )
			{
				$intFieldCount=0;
				$row="";
				foreach ($value as $key1 => $value1 )
				{
					$strpreparedcontent=str_replace($strFieldDelimiter, "&brvbar;", $value1);
					$strpreparedcontent=str_replace($strRowDelimiter, "&#94;", $strpreparedcontent);
					if($bwlNeedKeys)
					{
						$strpreparedkey=str_replace($strFieldDelimiter, "&brvbar;", $key1);
						$strpreparedkey=str_replace($strRowDelimiter, "&#94;", $strpreparedkey);
						$keys.=   $strpreparedkey  .  $strFieldDelimiter;
					}
					{
						$row.=   $strpreparedcontent  .  $strFieldDelimiter;
					}
				}
				if($bwlNeedKeys)
				{
					$keys = RemoveEndCharactersIfMatch($keys, $strFieldDelimiter);
					$out.= $keys . $strRowDelimiter;
				}
				$row = RemoveEndCharactersIfMatch($row, $strFieldDelimiter);
				$out.=  $row  . $strRowDelimiter;
				$bwlNeedKeys=false;
			}
		}
	}
	return $out;
	
}
	

?>