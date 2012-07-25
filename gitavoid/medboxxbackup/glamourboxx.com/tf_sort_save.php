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
	
	$idfield=$_REQUEST[qpre . "idfield"];
	$strSortField=$_REQUEST[qpre . "sortfield"];
	$strTable=$_REQUEST[qpre . "table"];
	$strIDList=$_REQUEST[qpre . "idlist"];
	$strDatabase=deMoronizeDB(gracefuldecay($_REQUEST[qpre . "db"],our_db));
	$strConfigBehave=$_REQUEST[qpre . "behave"];
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
				$out.= ReshuffleSortIDs($strDatabase, $strTable,$idfield , $strSortField, $strIDList);
			}
	}
	$out =  PageHeader( "", $strConfigBehave, "", true, false, "", $strDatabase) . $out . PageFooter();
	
	return $out;
}

function ReshuffleSortIDs($strDatabase, $strTable,$idfield , $strSortField, $strIDList)
{
//update May 25 2009, Judas Gutenberg: I multiply the new sort counts by ten to allow gaps for direct manual insertions of new items by other methods
	$sql=conDB();
	$intCount=1;
	$arrIDList=explode(" ", $strIDList);
	foreach($arrIDList as $thisID)
	{
		if($thisID!="")
		{
			$strSQL="UPDATE " . $strDatabase . "." . $strTable . " SET " . $strSortField . "='" . $intCount * 10 . "' WHERE " . $idfield  . "='" . $thisID . "'";	
			//echo $strSQL . "<br>";
			$records = $sql->query($strSQL);
			$intCount++;
		}
	
	}

	return "<span class=\"feedback\">" .  pluralize($strTable). " have been reordered</span>.";

}
	
	
	
?>