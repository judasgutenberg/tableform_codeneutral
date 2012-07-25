<?
function SearchDBtoArray($strSearchTerm, $strSearchType, $strDatabase, $arrTableLinkMatch, &$totalrecords, $intStartRecord=0, $intRecordsToReturn=20, $forbiddendescriptionfieldnames="keywords", $namesizelimit=40, $descrsizelimit=80, $intLinkTextTruncNumber=50, $typesToInclude="varchar text")
{
//returns an associative array keyed to link url of all the search results.  the data of the associated array is chr(13) delimited data containing first linktext then description
//$arrTableLinkMatch passes in an associative array of tables to search keyed to the pages where the results for that table should link
//thus "user"=>"profile.php?userid=" could be one pairing in that array indicating searches of the user table.
//$forbiddendescriptionfieldnames is a space-delimited list
//this function takes most of the thinking out of designing a site search for a site based on a mysql database
//since it automatically decides what columns are worth searching based on their size and type, easily changed at $typesToInclude
//this function is definitely a server-buster, but in a low-traffic site it will work just fine
//ponderous but flexible!  Judas Gutenberg dec 9 2008

	//$intLinkTextTruncNumber=20;
	$sql=conDB();
	if($strSearchType=="general"  || $strSearchType=="")
	{
		$strSearchTerm="%" . $strSearchTerm . "%";
	}
	if($strSearchType=="start")
	{
		$strSearchTerm= $strSearchTerm . "%";
	}
	if($strSearchType=="end")
	{
		$strSearchTerm="%" . $strSearchTerm ;
	}
	if($strSearchType=="precise")
	{
		$strSearchTerm= $strSearchTerm ;
	}
 
	$errors="";
	$strSQL="CREATE TEMPORARY TABLE " . $strDatabase . ".tmp_searchresult(\n";
	$strSQL.="`id` int(11) NOT NULL auto_increment,\n";
	$strSQL.="`linkurl` varchar(180) NULL,\n";
	$strSQL.="`linktable` varchar(50) NULL,\n";
	$strSQL.="`linktext` varchar(150) NULL,\n";
	$strSQL.="`description` text NULL,\n";
	$strSQL.="PRIMARY KEY (`id`)\n";
	$strSQL.=");\n";
	$tables = $sql->query($strSQL);
	$errors.= sql_error();
	//echo $errors;
	foreach($arrTableLinkMatch as $strTable=>$url)
	{
		//$strField;
		$bwlMultitable=false;
		if(contains($strTable, " "))
		{	
			$bwlMultitable=true;
			$arrTable=explode(" ", $strTable);
			$strTable=$arrTable[0];
		}
		$strPK=PKLookup($strDatabase, $strTable);
		$strFoundNameField="";
		$strDescriptionField="";
		$bwlFoundDescriptionField=false;
		if(!contains($strPK, " "))//don't attempt a compound PK
		{
			$guessedvariable=GuessQueryVariable($url);
			$fullurl=$url; //$url . "?" . $strPK . "=";
			$records=TableExplain($strDatabase, $strTable, $bwlMultitable);
			//$records =array_reverse($records );//most tables are organized so description fields follow name fields, and I want to find description fields first
			$intFieldCount=0;
			$strFoundNameField="";
			foreach ($records as $record => $info )
			{
				$typename=strtolower(TypeParse($info["Type"], 0));
				//echo $bwlMultitable . " " . $info["Field"] . " " . $typename . " " . "<br>"; 
				$typesize=intval(TypeParse($info["Type"], 1));
				$bwlCouldBeDescr=$typesize>$namesizelimit  || $typesize>$descrsizelimit || inList($typesToInclude , $typename)  || $typename=="text";
				
				if( $bwlCouldBeDescr  &&  !inList($forbiddendescriptionfieldnames, $info["Field"]) )
				{
					//echo $typesize . " " . $typename .  " " . $info["Field"] . "<br>";
					if($strFoundNameField!="")
					{
						//echo  $info["Field"] . "<br>";
						if(!$bwlFoundDescriptionField && $typesize>$descrsizelimit)
						{
							//echo  $info["Field"] . " " .$typesize . " ".  "<br>";
							$strDescriptionField=$info["Field"];
							$bwlFoundDescriptionField=true;
						}
					}
					else if($typesize>$namesizelimit)
					{
						$strFoundNameField=$info["Field"];
					}
				}
			 
				//echo $substr . "<br>";
				//echo "<font color=red>" . $typesToInclude. " " .  $typename .  "</font><br>";
				if(inList($typesToInclude, $typename))
				{
					//echo $info["Field"] . "<br>";
					$arrFields[$intFieldCount]=$info["Field"] . " " . $typesize;
					$intFieldCount++;
				
				}
			
			}
			$pklist="";
			//$strDescription="";
			foreach($arrFields as $field)
			{
				//echo $strDescriptionField . "<br>";
	
				$arrField=explode(" ", $field);
				$additionalClause="  WHERE  LOWER(" . $arrField[0] . " ) LIKE '" . strtolower($strSearchTerm) . "'";
				if($bwlMultitable)
				{
					//FleshedOutFKSelect($strDatabase, $strTable, $additionalClause, &$arrDesc, $strUnnecessaryJoinTables="", $bwlKeepPKs=false, $bwlIncludeAllRelatedFields=false)
					$strSQL=FleshedOutFKSelect($strDatabase, $strTable, $additionalClause, $arrDescOut,  "", true, true);
					//echo $strSQL . "<br>";
				}
				else
				{
					$strSQL="SELECT * FROM " . $strDatabase . "." . $strTable . $additionalClause;
				}
				//echo $strSQL . "<br>";
				
				$resultrecords = $sql->query($strSQL);
				//echo sql_error();
				//echo count($resultrecords) . "<br>";
				//echo $strPK;
				
				//echo $finalurl . "<br>";
				
				foreach($resultrecords as $resultrecord)
				{
					
					$strDescription=$resultrecord[$strDescriptionField];
					if($strDescription==""  && $arrField[0]!=$strFoundNameField)
					{
						$strDescription=$resultrecord[$arrField[0]];
					}
				
					//echo $strDescriptionField . "<br>";
					if(!inList($pklist, $resultrecord[$strPK]))
					{
						$bwlFoundID=false;
						if($guessedvariable!="")
						{
							if ($resultrecord[$guessedvariable]!="")
							{
								$finalurl=$fullurl . $resultrecord[$guessedvariable];
								$bwlFoundID=true;
							}
						}
						if(!$bwlFoundID)
						{
							$finalurl=$fullurl . $resultrecord[$strPK];
						}
						//if($strDescriptionField!=$info["Field"]])
						{
							$strLinkText=$resultrecord[$strFoundNameField];
						}
						//echo $info["Field"] . "=" .  $strLinkText . "<br>";
						$strLinkText=truncate($strLinkText, $intLinkTextTruncNumber);
						
						
						$strSQL="INSERT INTO " . $strDatabase . ".tmp_searchresult(linkurl,linktable,linktext, description) VALUES('" . $finalurl . "','" . $strTable .  "','" . $strLinkText . "','" .  str_replace(chr(13), " ", $strDescription) . "');";
	
						$sql->query($strSQL);
					}
					$pklist.=" " . $resultrecord[$strPK];
					//echo $strSQL . "<br>";
					//echo sql_error();
				}
					
			}
			
		}
		
	}
	$strSQL="SELECT * FROM " . $strDatabase . ".tmp_searchresult LIMIT " . $intStartRecord . "," . $intRecordsToReturn;
	//echo $strSQL;
	$outputresults=$sql->query($strSQL);
	$totalrecords=count($outputresults);
	foreach($outputresults as $record)
	{
		$arrOut[$record["linkurl"]] = $record["linktext"] . chr(13) . $record["description"];
	}
	return $arrOut;
}

function GuessQueryVariable($strIn)
{
	if (contains($strIn, "?"))
	{
		$arrThis=explode("?", $strIn);
		
		$arrQS=$arrThis[1];
		if (contains($arrQS, "="))
		{
			$arrQSV=explode("=", $arrQS);
			return $arrQSV[0];
		}
		
	}
}
?>