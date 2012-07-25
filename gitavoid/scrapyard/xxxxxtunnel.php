<? 
//Gus Mueller January 2007
//a tunnel for the PHP server

include('tf_functions_core.php');

echo main();

function main()
	{
		$sql=conDB();
		$strDatabase=deMoronizeDB(gracefuldecay($_REQUEST[qpre . "db"],our_db));
		$strSQL=$_REQUEST["query"];
		$out= TunnelQuery($strDatabase,  $strSQL);
		return $out;
	}

	

function  TunnelQuery($strDatabase,  $strSQL)
{
	//runs $strSQL and displays results in a labeled HTML table
	//also shows errors if there is a problem
	//gus mueller, nov 26 2006
	$sql=conDB();
	$out="";
	mysql_select_db($strDatabase);
	$rows =  $sql->query($strSQL);
	$rowcount=0;
	$strErrors=mysql_error();
	echo $strErrors;
	if ($strErrors=="")
	{
		$out.= "<table>\n";
		foreach ($rows as $record )
		{
			$out.= "<tr  >\n";
			if($rowcount==0)
				{
					foreach($record as $k=>$v)
					{
						$out.="<td>";
						$out.=$k ;
						$out.="</td>";
					}
					$out.="</tr>\n";
					$out.= "<tr>\n";
				}
			foreach($record as $k=>$v)
			{
				$out.="<td>";
				$out.=$v;
				$out.="</td>";
				$rowcount++;
			}
			$out.="</tr>\n";
		}
		$out.="</table>";
		
	}
	return $out;
}
	
?>



