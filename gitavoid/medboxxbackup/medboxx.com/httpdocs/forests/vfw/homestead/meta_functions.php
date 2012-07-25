<?php


//$data="freedom costs more than democracy or 'keeping' watch over reeds and pee and poop' and \'heeding' the chases";
//$quotechar="' \"";
//$delimiter="eed";
//$strEscapeStyle="php";
//$thiser=BetterBetterExplode($delimiter, $data,  $quotechar="\" '", true, $strEscapeStyle="php");

 
function ScanPHPLibrary($strDatabase, $strFilename, $strPHP)
{
	$out="";
	$strLineClass="bgclassline";
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strOtherBgClass="bgclassother";
	$strOtherLineClass="bgclassline";
	$delimiterprefixnixlist="$";
	
	$out.="<span class=\"feedback\">" . MakeTableIfNotThere($strDatabase, tfpre . "php_function", "MakePHPFunctionTables") . "</span>";
	$out.= "<script src=\"tablesort_js.js\"><!-- --></script>";
	$out.= "\n<form method=\"post\" name=\"BForm\" action=\"" .  $strPHP . "\">\n";
	$out.= "<table id=\"idsorttable\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\" class=\"" .$strLineClass  . "\" width=\"550\">\n";

	if($strFilename=="")
	{
		$strFiles="core_functions.php|backup_functions.php|dbtools.php|sqlparsing_functions.php|tableform_functions.php|tableform.php|tablemaker.php";
		$arrFiles=explode("|", $strFiles);

		
		foreach($arrFiles as $file)
		{
 
	 
			$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
			$out.=htmlrow($strThisBgClass, "<a href=\"" . $strPHP . "?" .qpre."filename=" . $file . "\">" . $file . "</a>");
				 
		 }
	}
	else
	{
		$strThisBgClass=$strClassFirst;
		$handle=fopen ($strFilename, "r");
		$content=fread($handle, filesize($strFilename));
		fclose($handle);
		$arrFunctions=BetterExplode("function ", $content, "\" '", true, "php", true, "");
		//$content=BlankOutQuotedAreas($content, "", "' \"", "*");
		//$out= $content;
		//$arrFunctions=explode("FunctiOn ", $content);
		
	
		$functioncount=0;
		$out.=htmlrow("bgclassline", "<a href=\"javascript: SortTable('idsorttable', 0)\">function</a>" , "<a href=\"javascript: SortTable('idsorttable', 1 )\">lines</a>" );
		foreach($arrFunctions as $thisfunction)
		{	
			$thisfunction=trim($thisfunction);
			$strPos=strpos($thisfunction, ")");
			if($functioncount>0)
			{
				$fullspec=trim(substr($thisfunction, 0, $strPos+1));
				 
				$strPosEndName=strpos($fullspec, "(");
				$name=trim(substr($fullspec, 0, $strPosEndName));
				$strPos=strpos($thisfunction, ")");
				$body=trim(substr($thisfunction,$strPos+1));
				if($fullspec!="")
				{
					$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
					$arrLines=explode(chr(13), $thisfunction);
					$lines= count($arrLines)-2;
					$out.=htmlrow($strThisBgClass, $fullspec ,$lines);
					
					UpdateOrInsert($strDatabase, tfpre . "php_function", 
						Array
						(
							"function_name"=>$name
						), 
						Array
						(
		
							"linecount"=>$lines,
							"page_path"=>$strFilename,
							"function_body"=>$body
						),true, false);
					$function_id=GenericDBLookup($strDatabase,tfpre . "php_function", "function_name", $name, "function_id");
					//echo $function_id . "==fid<br>";
					//store info about the parameters
					if($function_id!="")
					{
						$paramstring=AllWhiteSpaceToSpace(parseBetween($fullspec, "(", ")"));
						$paramstring=deMultiple($paramstring, " ");
						//BetterExplode($delimiter, $data,  $quotechar="\" '", $bwlLeaveQuotesInPlace=false, $strEscapeStyle="csv", $bwlDelmiterCaseInsensitive=true, $delimiterprefixnixlist="", $chrQuoteOverwrite="")
						$arrParams=BetterExplode(" ", $paramstring, "\" '", true, "php", false, "", "");
						//echo count($arrParams ) . "==count<br>";
						foreach($arrParams as $param)
						{
							$thispair=BetterExplode("=", $param, "\" '", true, "php", false, "", "");
							$paramName=$thispair[0];
							$paramDefault=$thispair[1];
							//echo count($thispair ) . "==equalcount<br>";
							$paramName=trim(DeMultiple($paramName, " "));
							$paramDefault=trim(DeMultiple($paramDefault, " "));
							$paramName=trim(RemoveEndCharactersIfMatch($paramName, ","));
							$paramDefault=trim(RemoveEndCharactersIfMatch($paramDefault, ","));
							if($paramName!="")
							{
								UpdateOrInsert($strDatabase, tfpre . "php_function_param", 
								Array
								(
									"param_name"=>$paramName
								), 
								Array
								(
									"param_default"=>$paramDefault,
									"function_id"=>$function_id
								),true, false);
							}
							
						}
					}
					
				}
			}
			$functioncount++;
		}
	}
	$out.= "</table>\n";
	$out.= "</form>\n";
	$out.= "<script>NumberRows('idsorttable', 1);</script>";
	
	return $out;
}


function PopulatePHPFunctionReferenceTable($strDatabase)
{
	$sql=conDB();
	
	$strSQL="SELECT * FROM   " . $strDatabase . "." . tfpre . "php_function";
	$records =  $sql->query($strSQL);
	//echo "$$";
	$out="";
	foreach($records as $record)
	{
		$function_name=$record["function_name"];
		$function_body=$record["function_body"];
		$function_id=$record["function_id"];
		$function_body=AllWhiteSpaceToSpace($function_body);
		$strLimitspec="48-57 a-z A-Z _ $ ";
		$function_body=BlankOutQuotedAreas($function_body, " ", $quotechar="' \"", " ");
		$function_body=FilterString($function_body, $strLimitspec, " ");
		$function_body=deMultiple($function_body, " ");
		$arrFunctionBody=explode(" ", $function_body);
		foreach($arrFunctionBody as $thisterm)
		{
			if($thisterm!=""  && substr($thisterm, 0,1)!="$")
			{
				//echo $thisterm . "<br/>\n";
				$function_called_id=GenericDBLookup($strDatabase,tfpre . "php_function", "function_name", $thisterm, "function_id");
				if($function_called_id!="")
				{
					UpdateOrInsert($strDatabase, tfpre . "php_function_reference", 
						Array
						(
							"caller_function_id"=>$function_id,
							"called_function_id"=>$function_called_id
						), 
						"",true, false);
						$thiserror= sql_error();
						if($thiserror!="")
						{
							$out.=$thiserror . "<br/>\n";
						}
				
				}
			
			}
		
		}
	}
	return $out;

}

?>