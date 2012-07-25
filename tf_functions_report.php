<?php


function PlotStats($strDatabase, $strTable, $strIDFieldName, $UserID, $strGivenLabelField, $strPHPForRows, $strGivenQuantityField_x, $strGivenFilterField,  $intThisFilterID, $intStartRecord=0, $intRecordCount=50, $strOrderbyField="", $strOrderbyDirection="", $graphwidth=400, $filterString="")
//plot a bargraph of recent data from a table, specifying a quantity field, a filter field (not necessary!), and other things
{
	$strGraphClassFirst="graph1";
	$strGraphClassSecond="graph2";
	$strPHP=$_SERVER['PHP_SELF'];
	$sql=conDB();
 	$strAdminIDRangeAddendum=UserIDToSelectAddendum($strDatabase, $strTable, $strIDFieldName, $UserID);
	$strSQLThis="SELECT MAX(" . $strGivenQuantityField_x . ") as MAX FROM " . $strDatabase. "." . $strTable  ;

	$strSQL="SELECT * FROM " . $strDatabase. "." . $strTable;
 	if($strOrderbyField=="")
	{
		$strOrderbyField=$strIDFieldName;
	}
	if($strOrderbyDirection=="")
	{
		$strOrderbyDirection="DESC";
	}
	$strWhere="";
 	if ($strGivenFilterField!="" &&  $intThisFilterID!="")
	{
		$strWhere=" WHERE " . $strGivenFilterField . " = " . $intThisFilterID . " ";
		//$strSQL.=$strWhere;
		$strSQLThis.=$strWhere;
	}
	if ($filterString!="")
	{
		//echo "-" . $filterString . "-";
		if ($strWhere=="")
		{
			$strWhere=" WHERE ";
		}
		else
		{
			$strWhere.=" AND ";
		}
		$strWhere.= "   " . $strGivenLabelField . " NOT LIKE '%" . $filterString . "%'";
	
	}
	$strSQL.=$strWhere . " ORDER BY " .  $strOrderbyField. " " .  $strOrderbyDirection . " LIMIT " . $intStartRecord . "," . $intRecordCount  ;
	
	//$strSQLThis=ProperlyAppendSQLWherePhrase($strSQLThis, $strAdminIDRangeAddendum);
	$records = $sql->query( $strSQLThis);
	$record=$records[0];
	$intMaxVal=$record["MAX"];
 	
 
	$out= "\n<table border=\"0\" cellspacing=\"1\" cellpadding=\"2\" class=\"" .$strLineClass  . "\" width=\"900\">\n";

	$records = $sql->query($strSQL);
	//echo $strSQL . "<p>";
	//echo mysql_error();
	foreach($records as $record)
	{
		//echo $strGivenLabelField . "<br>";
		$strLabel=$record[$strGivenLabelField];
		$strLabel=trunchandler($strLabel, 56, true);
		$value=$record[ $strGivenQuantityField_x];
		//$graphwidth=400;
		$strThisGraphClass=Alternate($strGraphClassFirst, $strGraphClassSecond, $strThisGraphClass);
		$strThisClass=Alternate("bgclassfirst", "bgclasssecond", $strThisClass);
		$strDataToDisplay=GraphValue($value, $intMaxVal, $graphwidth, 13, $strThisGraphClass, false);
		$strWidthSpecial=" width=\"" .  intval($graphwidth + 59). "\"";
		$strWidthSpecialOther=" width=\"50\"";
		if($strGivenFilterField!="" &&  $intThisFilterID!="")
		{
			$out.=htmlrow($strThisClass, $strLabel, $strDataToDisplay);
		}
		else
		{
			$strURL=GenericDBLookup(our_db, "page", "page_id", $record["page_id"], "querystring");
			$strURLDisplay = "<b><a href=\""  . $strPHP . "?q=" . $strURL . "\">" . $strURL  . "</a></b>";
			$out.=htmlrow($strThisClass, $strLabel, $strURLDisplay, $strDataToDisplay);
		}
	}
	$out.= "\n</table>";
	return $out;
}

?>