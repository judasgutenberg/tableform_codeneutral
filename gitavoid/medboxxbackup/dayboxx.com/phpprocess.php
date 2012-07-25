<? 
//Federico Frankenstein March 2007
//redorders the sort ids in a list of primary key ids from a table  
 

include('tf_functions_core.php');

echo main();

function main()
{

	if(!IsExtraSecure())
	{
		die(ExtraSecureFailure());
	}
	
	$method=$_REQUEST['method'];
	$value=$_REQUEST['value'];
	$outputformitem=$_REQUEST['outputformitem'];
	$strDatabase=deMoronizeDB(gracefuldecay($_REQUEST[qpre . "db"],our_db));

	$strPHP=$_SERVER['PHP_SELF'];
	$out="";
	if ($rec=="")
	{
		$rec=0;
	}
	//echo $id . " " .$idfield ;
	$out=LoginDecisions($strDatabase,  $strPHP, $strUser, true);
	if ($strUser!="")
	{
	
		$intAdminType= AdministerType($strDatabase, $strTable, $strUser);
		
		if ($intAdminType>1)
			{
			 	EnsureNonRemote();
				$out.= ProcessPHP($method,$value, $outputformitem);
			}
	}
	$out =  PageHeader( "", $strConfigBehave) . $out . PageFooter();
	
	return $out;
}

function ProcessPHP($method,$value, $outputformitem)
{
	$out="<script>\n";
	//for debug:
	//$out.="alert('" . $method . "+" . $outputformitem . "');\n";
	$method=FixFormulaForEval($method, true);
	//$out.="alert('" . $value . "');\n";
	$method="$" . "processed=" . str_replace("$" . "value", "\'" . $value . "\'", $method) . ";";
	//$out.="alert('" . $method . "');\n";
	eval($method);
	//$out.="alert('" . $processed . "');\n";
	$out.="eval(\"parent." . $outputformitem . ".value='" . $processed . "'\");";
	$out.="</script>\n";
	return $out;
}
	
?>