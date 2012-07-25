<? 
//Gus Mueller January 2006
//provides a web front end admin tool for any mysql db
//i've modified txtsql to be aware of foreign keys so this tool can dynamically build complicated tools

include('tf_functions_core.php');

echo main();

function main()
	{
	
		
		//$olderror=error_reporting(0);
		$mode=$_REQUEST[qpre . "mode"];
		$idfield=$_REQUEST[qpre . "idfield"];
		$id=$_REQUEST[$idfield];
		$strTable=$_REQUEST[qpre . "table"];
		$strTheirTable=$_REQUEST[qpre . "theirtable"];
		$strDatabase=deMoronizeDB(gracefuldecay($_REQUEST[qpre . "db"],our_db));
		$strColumn=$_REQUEST[qpre . "column"];
		$strDirection=$_REQUEST[qpre . "direction"];
		$strExtrajs=$_REQUEST[qpre . "extrajs"];
		$rec=$_REQUEST[qpre . "rec"];
		error_reporting($olderror);
		$strPHP=$_SERVER['PHP_SELF'];
		$strPHP="tf.php";
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
				 
					$out.= SerializeExpand($strDatabase, $strTable,$idfield , $id, "tf.php");
				}
		}
		$out =  PageHeader($strDatabase . " : Serialize Expandtron", $strExtrajs) . $out . PageFooter();
		
		return $out;
	}


function SerializeExpand($strDatabase, $stTable, $strIDField, $strID, $strPHP)
	{
	//inside a particular database, find all the tables that have a foreign key relationship with the given item and list them in grouped clusters, complete with various editing options
		$out="";
		$strLineClass="bgclassline";
		$strClassFirst="bgclassfirst";
		$strClassSecond="bgclasssecond";
		$strOtherBgClass="bgclassother";
		$strOtherLineClass="bgclassline";
		$intWidth=500;
		$strMode="save";
		$out.="<form enctype=\"multipart/form-data\" name=\"BForm\" method=\"post\" action=\"" . $strPHP . "\" onSubmit=\" return validate_form();\">\n";
		$out.= "<table width=\"" . $intWidth . "\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\" class=\"" .$strLineClass  . "\"  >\n";
		$sql=conDB();
		$strSQL="SELECT * FROM " . $strDatabase . "." . $stTable . " WHERE " . $strIDField . "='" .  $strID . "'";
		//echo $strSQL;
		$records = $sql->query($strSQL);
		$record=$records[0];
		 
		$intFieldCount=0;
		$row="";
		foreach ($record as $key => $value)
		{
			$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
			if(beginswith($value, "a:")   && contains($value, ":{")  &&  contains($value, ";}"))
			{
				//echo $value;
				$value=SerializeForm($value,  qpre . "serialized|" . $key , $strThisBgClass);
			}
			$out.=htmlrow($strThisBgClass, "<b>" . $key . "</b>" , $value);
		}
		
			$out.=HiddenInputs(array("needtoencryptonsave"=>$needtoencrypt,"dropdowntextvalue"=>"", "rec"=>$intRecord, "column"=>$strSort, "direction"=>$strDirection, "backfield"=>$strBackfield));
		$out.=HiddenInputs(array("table"=>$strTable,"table"=>$strTable,"db"=>$strDatabase,"mode"=>$strMode,"idfield"=>$strIDField,"extrajs"=>$strExtrajs ),qpre, $strFieldNamePrefix);
                                                                               
		$out.="<input type=\"hidden\" name=\"" . $strFieldNamePrefix . qpre. "oldid\"   value=\"".  $strValDefault . "\">\n"; 

		$out.=htmlrow($strThisBgClass, "&nbsp;", "<div align=\"right\">" . GenericInput(qpre . "submit", "Save")) . "</div>";
		$out.= "</table>\n";
		$out.= "</form>\n";
	
		return $out;
	}

	
function SerializeForm($value,  $passinname, $class)
{
	$out="";
	$thisarr=unserialize($value);
	$strLineClass="bgclassline";
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strOtherBgClass="bgclassother";
	$strOtherLineClass="bgclassline";
	$out.= "<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\" class=\"" .$class  . "\"  >\n";
	foreach ($thisarr as $key => $v)
	{
		$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
		//echo gettype($v) . "<br>";
		if(gettype($v)=="array")
		{
			//echo "$$$<br>";
			$out.=htmlrow($strThisBgClass, "<b>" . $key . "</b>" , ArrayForm($v, $key, $passinname . "|" . $key, $strThisBgClass));
		}
		else
		{
			$v=TextInput($passinname . "|" . $key, $v, 20,  "" );
			$out.=htmlrow($strThisBgClass, "<b>" . $key . "</b>" , $v);
		}
	
	}
	$out.= "</table>\n";
	return $out;
}


function ArrayForm($arrIn, $name, $passinname, $class)
{
	$out="";
	$strLineClass="bgclassline";
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strOtherBgClass="bgclassother";
	$strOtherLineClass="bgclassline";
	$out.= "<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\" class=\"" .$class  . "\"  >\n";
	foreach ($arrIn as $key => $v)
	{
		$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
		if(gettype($v)=="array")
		{
			$out.=htmlrow($strThisBgClass, "<b>" . $key . "</b>" , ArrayForm($v, $key, $passinname . "|" . $key, $strThisBgClass));
		}
		else
		{
			$v=TextInput($passinname . "|" . $key, $v, 20,  "" );
			$out.=htmlrow($strThisBgClass, "<b>" . $key . "</b>" , $v);
		}
	
	}
	$out.= "</table>\n";
	return $out;
}
?>