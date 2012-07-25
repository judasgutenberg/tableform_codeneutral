<?php 




function GetTranslation($strTable, $strField, $pk,  $language_id, $default="", $bwlDontDefault=false)
{	
	$pkname=PKLookup(our_db, $strTable);
	if(!$bwlDontDefault)
	{
		if($default=="")
		{
			$default=GenericDBLookup(our_db,  $strTable, $pkname, $pk ,  $strField);
		}
	}
	$translation=trim(GenericDBLookupWhere(our_db, "translation", "table_name='" . $strTable .  "' AND field_name='" .  $strField ."' AND entity_id='" . singlequoteescape($pk) . "' AND language_id='" .  singlequoteescape($language_id) . "'","translation_value"));
	if(!$bwlDontDefault)
	{
		$out=gracefuldecay($translation, $default);
	}
	else
	{
		$out=$translation;
	}
	return $out;
}


function TranslatedQuery($strSQL, $language_id, $strLimitTranslationToFields="")
//takes advantage of Tableform's new built-in language translation support
//to look up translations of fields and substitute those if they are available
//Judas Gutenberg May 22 2009
{
	$outrecords=Array();
	$records=Array();
	 
	//echo $_SERVER["SERVER_NAME"] . "<br>";
	$bwlNeedConnection=false;
	
	if (!$c)
	{
		if ($_SERVER["SERVER_NAME"]==optionalhost)
		{
			$c = mysql_connect(con_server_optional, con_user_optional,con_pwd_optional);
		}
		else
		{
			$c = mysql_connect(con_server_web, con_user_web, con_pwd_web);
			
		}
		mysql_select_db(our_db);
		$bwlNeedConnection=true;
	}
	$res= mysql_query($strSQL);

	$out=array();
	$count=0;
	if (gettype($res)=="resource")
	{
		for ($i=0; $i<mysql_num_rows($res); $i++)
		{
			$record=mysql_fetch_assoc($res);
		 
			$records[$count]=$record;
			$count++;
		}
	}
	//$records=SQLtoArray($strSQL);

	foreach($records as $record)
	{
		
		$fieldcount=0;
		foreach($record as $k=>$v)
		{
			$strTable=mysql_field_table($res, $fieldcount);
			
			$pkname=PKLookup(our_db, $strTable);
			$pk=$record[$pkname];
			//echo $strTable . " " . $k . " " . $v . " " . $pkname .  "<br>";
			if( $strLimitTranslationToFields==""  || inList($strLimitTranslationToFields,$k))
			{
				$v=GetTranslation($strTable, $k, $pk,  $language_id, $v);
			}
			$record[$k]=$v;
			$fieldcount++;
		
		}
		$outrecords[count($outrecords)]=$record;
	}
	//echo var_dump($outrecords);
	return $outrecords;
}




function SQLtoArray($strSQL)
{
	$sql=conDB();
	$records = $sql->query($strSQL);
	return $records;
}

function parseBetween($strIn, $strStart, $strEnd, $intStartingAt=0, $bwlTillEndIfEndNotFound=false)
//A great function for returning the string between two known strings ($strStart, $strEnd) within $strIn
//modified 10-2-2007 to take "" as $strEnd to look for cases where there is no $strEnd and we want to get everything to the end
//Also takes "" for $strStart to return stuff from beginning of $strIn
{
	$found="";
	if($strStart=="")
	{
		$pos1=0;
	}
	else
	{
		$pos1 = strpos($strIn, $strStart, $intStartingAt) + strlen($strStart);
	}
	//echo $strIn. " " . intval($pos1+1) . " " . strlen($strIn) . "<BR>";
	if ($pos1<strlen($strIn))//used to be $pos+1<strlen.... but that wasn't working
	{
		if($strEnd=="")
		{
			
			$pos2=strlen($strIn);
		}
		else if($bwlTillEndIfEndNotFound && !strpos($strIn,$strEnd, $pos1) )
		{
			$pos2=strlen($strIn);
		}
		else
		{
			 
			$pos2 = strpos($strIn, $strEnd, $pos1);
		}
	 
		 
	}
	else
	{
	//echo "-" . $strEnd . "-";
	}
	if ($pos1<$pos2)
	{
		$found=substr($strIn, $pos1, ($pos2-$pos1));
	}
	return($found);   
}

function parseTwoPartBetween($strIn, $strStart, $strStartEnd, $strEnd)
//A complex parser that looks for $strStart followed at some point by $strStartEnd, at which point it returns everything from the end of $strStartEnd to the beginning of $strEnd
//this is useful for certain HTML and XML parsing operations, where you know how a tag begins and ends, but not what is in the middle, and you also know precisely what you are 
//looking for at the end of what you seek.
//i've tried to write this function several times and this is the first time i've managed to pull it off
//December 18, 2008 Judas Gutenberg
{	
	$bwlInData=false;
	$bwlInStart=false;
	$intStrStart=0;
	$intStrStartEnd=0;
	$intEnd=0;
	$found="";
	$bwlPossiblyInstrStart=false;
	$bwlPossiblyInstrStartEnd=false;
	$bwlPossiblyInEnd=false;
	$foundprovisional.="";
	for($i = 0; $i < strlen($strIn)+1; $i++) 
	{
		$chr=substr($strIn,$i,1);
		
		
		$chrEnd=substr($strEnd,$intEnd,1);
		if($bwlInData)
		{
			if(!$bwlPossiblyInEnd)
			{
				if($chrEnd==$chr)
				
				{
					$bwlPossiblyInEnd=true;
					$intEnd++;
					$foundprovisional.=$chr;
				}
				else
				{
					$found.=$chr;
					$intEnd=0;
				}
			}
			else
			{
				if($chrEnd==$chr)
				
				{
					$bwlPossiblyInEnd=true;
					$foundprovisional.=$chr;
					$intEnd++;
				}
				else
				{
					$bwlPossiblyInEnd=false;
					$found.=$foundprovisional;
					$found.=$chr;
					$foundprovisional="";
				}
			}
			if($bwlPossiblyInEnd && $intEnd>=strlen($strEnd))
			{
				return $found;
			}
		}
		else
		{
			if(!$bwlInStart  && !$bwlInData   && !$bwlPossiblyInstrStart)
			{
				$intStrStart=0;
			}
			$chrStrStart=substr($strStart,$intStrStart,1);
			$chrStrStartEnd=substr($strStartEnd,$intStrStartEnd,1);
			if(!$bwlPossiblyInstrStart  && !$bwlInStart && !$bwlInData)
			{
				if($chr==$chrStrStart)
				{
					$bwlPossiblyInstrStart=true;
					$intStrStart++;
				}
			}
			elseif($bwlPossiblyInstrStart)
			{
				$intStrStart++;
			}
			else if($chr!=$chrStrStart && !$bwlInStart)
			{
				$bwlPossiblyInstrStart=false;
				$intStrStart=0;
			}
			if($intStrStart>=strlen($strStart))
			{
				$bwlInStart=true;
				$bwlInData=false;
				$bwlPossiblyInstrStart=false;
				$intStrStart=0;
			}
			if($bwlInStart  && !$bwlPossiblyInstrStartEnd)
			{
				$intStrStartEnd=0;
				if($chrStrStartEnd==$chr)
				{
					$bwlPossiblyInstrStartEnd=true;
					$intStrStartEnd++;
				}
			
			}
			else if($bwlPossiblyInstrStartEnd)
			{
				if($chrStrStartEnd==$chr)
				{
					$bwlPossiblyInstrStartEnd=true;
					$bwlInStart=false;
					$intStrStartEnd++;
				}
				else
				{
					$bwlPossiblyInstrStartEnd=false;
					$intStrStartEnd=0;
				}
			}
			if($intStrStartEnd>=strlen($strStartEnd))
			{
				$bwlInData=true;
				$bwlPossiblyInstrStartEnd=false;
				$bwlInStart=false;
				$intStrStartEnd=0;
			}
		}
		//echo $chr . "= " . $chrStrStart . " " . $chrStrStartEnd . " " .  $chrEnd . " start:" . $intStrStart . " startend:" . $intStrStartEnd . " end:" . $intEnd  . " instart:" . $bwlInStart . " indata:" .  $bwlInData." bwlPossiblyInstrStart:" . $bwlPossiblyInstrStart . " bwlPossiblyInstrStartEnd:"  .$bwlPossiblyInstrStartEnd  ." bwlPossiblyInEnd:" . $bwlPossiblyInEnd .  "<br>found:<font color=red>|" . $found . "|</font>Foundprovisional:<font color=blue>|" . $foundprovisional . "|</font><br>";
	}
	return($found);  
}

function JoinQuery($strTableList, $strJoinFieldList, $strCondition="", $strReturnFields="*", $mode="all", $type="")
//this only works for tables where the on clause is to fields having the same name
//$strTableList is space-delimited list of tables and $strJoinFieldList is a space-delimited list of conditions
// $strCondition is  the WHERE clause and everything that might follow it

//example: JoinQuery("airlinesmiles_converted user", "user_id", "", "*", "all"); - returns all recordsets
//from airlinesmiles_converted joined with user on user_id
//example: JoinQuery("airlinesmiles_converted user", "user_id", "WHERE airlinesmiles_converted_id=1", "username", "1"); - returns username from airlinesmiles_converted joined with user on user_id where airlinesmiles_converted_id=1
{
	$strSQL="SELECT " .$strReturnFields . " FROM ";
	$arrTables=explode(" ", $strTableList);
 	$arrFieldList=explode(" ",$strJoinFieldList);
	$intFieldCursor=0;
	$strPrecedingTable="";
	$strDatabase=our_db;
	if (count($arrTables)<=count($arrFieldList)  || count($arrTables)<count($arrFieldList)-1)
	{
		die("Error in JoinQuery:  space-delimited table list must be one more than space-delimited joinfield list!");
	}
	foreach($arrTables as $strTable)
	{
		if($strPrecedingTable!="")
		{
			$strJoinSQL.=" " . $type . " JOIN ";
	 
			$strJoinSQL.=  $strDatabase . "." .  $strTable . " ON ";
			
			$strJoinSQL.= $strDatabase . "." . $strPrecedingTable . "." . $arrFieldList[$intFieldCursor] . "=" .  $strDatabase . "." .  $strTable . "." .  $arrFieldList[$intFieldCursor];

			$intFieldCursor++;
		}
		else
		{
			$strJoinSQL.= $strDatabase . "." . $strTable ;
		}
		$strPrecedingTable=$strTable;
	}
	$strSQL=$strSQL. $strJoinSQL . " " .  $strCondition;
	if(inList("all 1 one *", $mode))
	{
		$sql=conDB();
		if(inList("all *", $mode))
		{
			$out=$sql->query($strSQL);
		}
		else
		{
			$out=$sql->query($strSQL);
			$out=$out[0];
		}
	}
	else
	{
		$out=$strSQL;
	}
	return $out;
}

function PageNumber($in)
//Finds the proper page number in a page-tagged text
{
	$strTag="[pagebreak]";
	$arrThis=explode($strTag, $in);
	$out=count($arrThis);
	return $out;
}


function SpecificPageOfPagedText($in, $intPage)
//Finds the proper page in a page-tagged text
{
	$strTag="[pagebreak]";
	if($intPage=="")
	{
		$intPage=0;
	}		
	$arrThis=explode($strTag, $in);
	$out=$arrThis[$intPage];
	return $out;
}
 
function prevnextlinks($strDB, $strThisTable, $sortcolumn, $id_column, $strLabel,   $type, $strAdditionalField="", $strAdditionalValue="", $thiscolumn, $bwlJustQS=false, $strIncludeFields="")
{
	//$thiscolumn contains the value of the sortable column we're presently on
	$sql=conDB();
	//echo $this . "<br>";
	$strPHP=$_SERVER['PHP_SELF'];
	$strAdditionalSQL="";
	if ($strAdditionalField!="")
	{
		$strAdditionalSQL=" AND " . $strAdditionalField  . "='" . $strAdditionalValue . "'";
	}
	$strBaseSQL="select  * from " . $strDB . "." . $strThisTable . " where " . $sortcolumn;
	if ($type=="newer")
	{
		$strSQL=$strBaseSQL . ">'" . $thiscolumn . "' " . $strAdditionalSQL . " ORDER BY " . $sortcolumn . " asc limit 0,1";
		$verbiage="Next";
		$pre="";
		$post="&gt;&gt;";
	}
	else
	{
		$strSQL=$strBaseSQL . "<'" . $thiscolumn . "' " . $strAdditionalSQL . " ORDER BY " . $sortcolumn . " desc limit 0,1";
		$verbiage="Last";
		$pre="&#60;&#60;";
		$post="";
	}
	//echo "<p  style='color:#ff5555'>" . $strSQL . "<p>";
	$nrecords = $sql->query($strSQL);
	$nrecord = $nrecords[0];
	$id=$nrecord[$id_column];
	//show the links only if an ID for the next one is found

	if ($id!="")
	{
		$strNewQS=replaceSpecificQueryVariable($id_column, $id, $_REQUEST, $strIncludeFields);
		if($bwlJustQS)
		{
			//echo "<P style='color:#ccccff'>" . $strNewQS . "<P>";
			return $strNewQS;
		}
		else
		{
			$url=$strPHP . "?" . $strNewQS;
			$link=$pre . " <a href=\"" . $url .   "\"   class=\"text_news10\">" . $verbiage  . " " . $strLabel . "</a>" . $post;
		}
		
	}
	return $link;
}

function PageHeader($strTitle, $strConfigBehave,$strForBackField="", $bwlIsStandalone=true, $bwlSuppressExternalHeader=false, $intMetaRefresh="",  $strDatabase="")
//page header for all the pages
{
	if($strDatabase=="")
	{
		 $strDatabase=our_db;
	}
	$out="";
	$externalheader="";
	if(defined("headerfunction")  && !$bwlSuppressExternalHeader)
	{
		if(headerfunction!="")
		{
			if(function_exists(headerfunction))
			{
				$externalheader=call_user_func(headerfunction);
			}
		}
	}
	if($externalheader!="")
	{
		$out.=$externalheader;
	}
	else if($bwlIsStandalone)
	{
		//$out.= "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
		
		header("Content-type: text/html; charset=iso-8859-1");
		$out.= "<html>\n";
		$out.= "<head>\n";
		$out.= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"/>\n";
		if( $intMetaRefresh!="")
		{
			$out.= "<meta http-equiv=\"refresh\" content=\"" . $intMetaRefresh . "\">\n";
		}
		
		$out.= "<meta http-equiv=\"cache-control\" content=\"no-cache\"/>
		<title>" . $strTitle . "</title>\n";
	}
 
	$out.= "<link rel=\"stylesheet\" href=\"" . tf_dir . "tf.css\" type=\"text/css\">\n";
	//set some globals for use in the javascript world:
	$out.= "<script>\nvar database='" . $strDatabase . "';\nvar qpre='" . qpre . "';\nvar tfpre='" . tfpre . "';\n</script>";
	$out.= "<script src=\"" . tf_dir . "tf.js\"><!-- --></script>";
	 
	if($bwlIsStandalone && $externalheader=="")
	{	  
		$out.= "</head>";
	}
	if (contains($strConfigBehave,"complete" )  && !contains($strConfigBehave,"updateopener"))//just a compressed version of what i really mean
	{
		$strExtratag="onLoad='recrank(\"" . $strForBackField . "\")'";
	}
	else if(contains($strConfigBehave,"updateopener")  && contains($strConfigBehave,"complete"))
	{
		$strExtratag="onLoad='UpdateOpener()'";
	}
	if($bwlIsStandalone  && $externalheader=="")
	{
		$out.= "<body " . $strExtratag . "  marginwidth=\"0\" leftmargin=\"0\" marginheight=\"0\" topmargin=\"0\" >";
	}
	return $out;
}
	
function OtherTools($strDatabase, $strPHP)
{
	//i've migrated this to a js popup as of june 2010
	$strDBPart=   "?" . qpre . "db=" . $strDatabase;
	$out="<div id=\"idothertools\" class=\"overlay\">";
	$out.="<span class=\"heading\">Other Tools</span><br/>\n";
	if(file_exists("tf_table_to_table_copy.php"))
	{
		$out.="<a href=\"tf_table_to_table_copy.php" . $strDBPart . "\">Table to table copy.</a><br/>\n";
	}
	
	$out.="<a href=\"" . $strPHP .  $strDBPart . "&" . qpre . "mode=entersql\">Manually enter SQL.</a><br/>\n";
	$out.="<a href=\"" . $strPHP .  $strDBPart . "&" . qpre . "mode=auxpick\">Install table packages.</a><br/>\n";
	$out.="<a href=\"" . $strPHP .  $strDBPart . "&" . qpre . "mode=stats\">Display database stats.</a><br/>\n";

	if(file_exists("tf_db_difference.php"))
	{
		$out.="<a href=\"tf_db_difference.php" . $strDBPart . "\">Analyze database changes.</a><br/>\n";
	}
	if(file_exists("tf_sql_import.php"))
	{
		$out.="<a href=\"tf_sql_import.php" . $strDBPart . "\">Import a database from SQL.</a><br/>\n";
	}
	$out.="<a href=\"" . $strPHP .  $strDBPart . "&" . qpre . "mode=backup\">Backup database to a SQL file.</a><br/>\n";

	if(file_exists("tf_sql_export.php"))
	{
		$out.="<a href=\"tf_sql_export.php" . $strDBPart . "\">Comprehensive SQL export tools.</a><br/>\n";
	}
	if(file_exists("tf_column_scanner.php"))
	{
		$out.="<a href=\"tf_column_scanner.php" . $strDBPart . "\">Search the entire <strong>" . $strDatabase . "</strong> database.</a><br/>\n";
	}

	if(file_exists("tf_db_map.php"))
	{
		$out.="<a href=\"tf_db_map.php" . $strDBPart . "\">Show/create relationship maps of the <strong>" . $strDatabase . "</strong> database.</a><br/>\n";
	}
	$out.="<a href=\"" . $strPHP .  $strDBPart . "&" . qpre . "mode=fkscan\"> Scan database for possible relations based on field names.</a><br/>\n";
	if(file_exists("tf_table_concordance.php"))
	{
		$out.="<a href=\"tf_table_concordance.php" . $strDBPart . "\">Copy information between similar tables using concordances</a>.<br/>\n";
	}
	if(file_exists("tf_field_finder.php"))
	{
		$out.="<a href=\"tf_field_finder.php" . $strDBPart . "\">Search the entire <strong>" . $strDatabase . "</strong> database for tables having a given field name.</a><br/>\n";
	}
	if(file_exists("tf_delete_range.php"))
	{
		$out.="<a href=\"tf_delete_range.php" . $strDBPart . "\">Delete a range of IDs from a table, and also delete  all dependent columns in other tables.</a><br/>\n";
	}
	$out.="<div align=\"right\">[<a href=\"javascript: closeothertools()\">close</a>]</div>\n";
	$out.="</div>";
	return $out;
}

function AdminNav($bwlSuperAdmin, $bwlSimple=false)
{
	$intTop=20;
	$strDatabase=$_REQUEST[qpre . "db"];
	if($bwlSimple)
	{
		$intTop=0;
	}
	
	$out="<div style=\"position: absolute;top:" . $intTop . "px;right: 0px; z-index: 100;\">";
	$strPHP=$_SERVER['PHP_SELF'];
	$strThisQS=$_SERVER['QUERY_STRING'];
	//$strConfig="tableform|browse tables||1-tf_table_maker|create new table||-tf_dbtools|db tools||-tf_dbtools|manually enter SQL|entersql|-tableform|version|version|1";
	$strConfig="tableform|browse tables||1-tf_table_maker|create new table||-ExtraToolsMenu()|db tools||-tf_dbtools|manually enter SQL|entersql|-tableform|version|version|1";
	$arrConfig=explode("-", $strConfig);
	if(contains($strPHP, "/"))
	{
		$arrPHP=explode("/", $strPHP);
		$strPHP=$arrPHP[count($arrPHP)-1];
	
	}
	$thisFullURL=$strPHP . IfAThenB($strThisQS, "?"). $strThisQS;
	foreach($arrConfig as $thisConfig)
	{
		$arrThis=explode("|", $thisConfig);
		$strQS=qpre . "db=" . $_REQUEST[qpre . "db"];
 
		$strMode=$arrThis[2];
		$okayForNonAdmin=$arrThis[3];
		$bwlLink=true;
		$bwlShowMoreTools=true;
		$jsextra="";
		if($arrThis[1]=="db tools")
		{
			//$jsextra=" id='idtipper' onmouseover=\"Tip('<b>Date:</b> October 15, 2008<br /><b>Time:</b> 4:00PM<br /><b>Location:</b> Campus X<br /><b>Approved:</b> Yes<br /><b>By:</b> L. Jenkins');\" onmouseout=\"UnTip();\"";
			//$jsextra="onmouseover='return escape(\"" . str_replace("\"", "\\\"", OtherTools($strDatabase, $strPHP)) ."\")' href=\"" . $strHelpLink . "\"";
		
		}
	 	if(!contains($strPHP, "dbtools") || $_REQUEST[qpre . "mode"]!="")
		{
			$bwlShowMoreTools=false;
		}
		if($strMode!="")
		{
			$strQS.="&" . qpre . "mode=" . $strMode;
		}
 
		if($thisFullURL==$arrThis[0]. ".php?" . $strQS)
		{
			$bwlLink=false;
		}
		//|| $bwlSuperAdmin
		

		if($okayForNonAdmin!="" || $bwlSuperAdmin )
		{
			//LinkIfFile($strFile, $strQueryString, $strAnchorText, $strUnlinkedPre="", $strUnlinkedPost="", $bwlActuallyLink=true, $bwlUnlinkParam="", $strExtraPairs)
			if(contains($arrThis[0], "("))
			{
				$out.="<a id='idextratools' class='topnav_notselected' href=\"javascript:" . $arrThis[0] . "\">" . $arrThis[1] . "</a>";
			}
			else
			{
				$out.=LinkIfFile($arrThis[0] . ".php", $strQS, $arrThis[1], " <span class='topnav_notselected'>", "</span> ", $bwlLink, "class='topnav_selected'", $jsextra) ;
			}
		
		}
 
	}
	if($bwlShowMoreTools  && $bwlSuperAdmin)
	{
		//$out.="<p>" . OtherTools($strDatabase, $strPHP);
	}
	$out.="</div>";
	return $out;
}
	
function NanHandler($in, $default)
{
	if($in=="NAN")
	{
		return "0.5";
	}
	else
	{
		return $in;
	}

}


function PageFooter($bwlIsStandalone=true, $bwlNoajax=false, $bwlSuppressFooter=false)
{
	$out="";
	//a good place to drop an ajax frame!
	if(!$bwlNoajax)
	{
		$out.="\n<iframe frameborder=\"0\" marginwidth=\"0\" marginheight=\"0\" width=\"1\" height=\"1\" name=\"ajax\" src=\"\"></iframe>";
	}
	$out.="<script src=\"" . tf_dir . "wz_tooltip.js\"><!-- --></script>\n";
	$out.="<script>setupclearfeedback()</script>\n";
	
	if(defined("footerfunction")  && !$bwlSuppressFooter)
	{
		if(footerfunction!="")
		{
			if(function_exists(footerfunction))
			{
				$out.=call_user_func(footerfunction);
			}
		}
	}
	
	if($bwlIsStandalone)
	{
		$out.="</body>\n";
		$out.="</html>\n";
	}
	return $out;
}


function mustDisplayField($strTable, $strFieldConfig, $strFieldName)
{
	//returns yes if $strFieldName is in $strFieldConfig for table, returns no if $strFieldName is not in the found info for table
	//returns nothing if there is no info on this table
	$arrFieldsToRequire=genericdata($strTable,0, 1, $strFieldConfig, "*", "|", true);
	$strFieldRequired="nothing";
	if (is_array($arrFieldsToRequire))
	{
		if (array_search($strFieldName, $arrFieldsToRequire)>0)
		{
			$strFieldRequired="yes";
		}
		else
		{
			$strFieldRequired="no";
		}
	}
	return $strFieldRequired;
}
	
function GreaterFieldDisplayLogic($strTable, $strFieldConfig, $strFieldName, $intFieldCount, $intFieldLimitLo, $intFieldLimitHi, $display_field_list="")
{
	$strFieldRequired=mustDisplayField($strTable, $strFieldConfig, $strFieldName);
	$out=false;
	//echo $intFieldLimitLo . "<br>";
	if($display_field_list!="")
	{
		$display_field_list=trim(deMultiple($display_field_list, " "));
		if(inList($display_field_list, $strFieldName))
		{
			$out=true;
		}
		
	}
	else
	{
		if ((($strFieldRequired=="yes" ||   $intFieldCount<=$intFieldLimitLo) && $intFieldCount<=$intFieldLimitHi) || ($strFieldRequired=="nothing"  && $intFieldCount<=$intFieldLimitHi))
		{	
			if(!contains(strtolower($strFieldName), "password"))  //no sense in showing a blanked-out password in a list of records
			{
				$out=true;
			}
		}
	}
	if($strFieldRequired=="no")
	{
		$out=false;
	}
	return $out;
}
	
function qbuild($strPHP, $strDatabase, $strTable, $mode, $idfieldname, $id)
//Builds a url from the given info, specific to tableform-style implementation
{
	$out=$strPHP ."?" . qpre . "db=" . $strDatabase  ;
	if ($strTable!="")
	{
		$out.="&" . qpre . "table=". $strTable;
	}
	if ($mode!="")
	{
		$out.="&" . qpre . "mode=" . $mode;
	}
	if ($idfieldname!="")
	{
		$out.="&" . qpre . "idfield=" . $idfieldname;
		if ($id!="" && !contains($idfieldname, "+") && !contains($idfieldname, " ") && !contains($idfieldname, "%20"))
		{
			$out.="&" . $idfieldname . "=" . $id;
		}
	}
	return $out;
}

function shorteststring()
//return the shortest string in a list of args
{
	$intArgs =func_num_args();
 	$shortest=99999;
	
	for($i=0; $i<$intArgs; $i++)
	{
		$thisstr=func_get_arg($i);
		
		$thislen=strlen($thisstr);
		if($thislen!=0 && $thislen<$shortest)
		{
			$shortest=$thislen;
			$shorteststring=$thisstr;
		}
	}
	if($shortest<99999)
	{
		return $shorteststring;
	}
}

function adminbreadcrumb($disablelink)
//Breadcrumb nav for the admin tools
{
	$intArgs =func_num_args();
	$out="";
	$strDelimiter=" : ";
	$classname="heading";
	if(defined("databasepickerlink") )
	{
		if(databasepickerlink=="true")
		{
			$out.="<span class=\"" . $classname . "\">";
			$strLinkName="databases";
			if($intArgs >1)
			{
				if(!$disablelink)
				{
					$out.="<a href=\"tf_databases.php\">" . $strLinkName . "</a>";
				}
			}
			else
			{
				$out.=  $strLinkName;
			}
			$out.="</span>";
			if($intArgs >1)
			{
				$out.=$strDelimiter;
			}
		}
	}
 
	for($i=1; $i<$intArgs; $i=$i+2)
	{
		$label=func_get_arg($i);
		if(strtolower($label)== "associated items")
		{
			$out="";
			$disablelink=true;
		}
		$out.="<span class=\"" . $classname . "\">";
		$link="";
		if($i+1<$intArgs)
		{
			$link=func_get_arg($i+1);
		}
		//echo $label . " " . $link.  "<br>";
		if ($link=="" || $disablelink)
		{
			$out.= $label;
		}
		else
		{
			$out.="<a href=\"" .  $link .     "\">" . $label . "</a>";
		}
		$out.="</span>";
		if ($i<$intArgs-2)
		{
		
			$out.=$strDelimiter;
		}
		//echo $out . "<br>";
	}
 
	return $out;
}

	
function SimpleTableDescriptionHeader($strDatabase, $strTable, &$fieldsincluded, $strClass="bgclassline", $intRowsToInclude=5, $fieldsToExclude="", $typesToExclude="", $arrExtraColumns="", $strTableID="idsorttable")
//Judas Gutenberg 2-21-2008
//creates a header for a non-paginated dump of a table's full contents
//$fieldsincluded is returned as a space-delimited list by reference so you know what to show in the table to which this is a header
{
	$records = TableExplain($strDatabase, $strTable);
	$intFindCount=1;
	$goodFieldList="";
	$intCount=1;
	$arrOut[0]=$strClass;
	foreach ($records as $k => $info )
	{
		if(!inList($fieldsToExclude, $info["Field"])  && $intCount< 1+$intRowsToInclude  && !inList($typesToExclude, $info["Type"]))
		{
			$arrOut[$intCount]="<a href=\"javascript: SortTable('" . $strTableID . "', " . intval($intCount-1) . ")\">" . $info["Field"] . "</a>";
			
			$fieldsincluded.=" " . $info["Field"];
			$intCount++;
		}
	}
	if(is_array($arrExtraColumns))
	{
		foreach($arrExtraColumns as $extra)
		{
			$arrOut[$intCount]=$extra;
			$intCount++;
		}
	
	}
	for($i=0; $i< $intEmptyCols; $i++)
	{
		$arrOut[$intCount]="&nbsp;";
		$intCount++;
	}
	$fieldsincluded= RemoveEndCharactersIfMatch($fieldsincluded, " ");
	$out=call_user_func_array("htmlrow", $arrOut);
	return $out;
}
	

function CommmaDelimitedDump($strDatabase, $strTable, $strFields="", $strFieldDelimiter=",", $strRowDelimiter="\n", $quotecontent=true, $UserID="", $strSQL="")
//An export feature from table to file
//If $strFields is not empty, then the fields are filtered based on their mention in $strFields
{
	$sql=conDB();
	$strAdminIDRangeAddendum=UserIDToSelectAddendum($strDatabase, $strTable, $strIDFieldName, $UserID);
	if ($strSQL=="")
	{
		$strSQL="SELECT * FROM  " .  $strDatabase . "." . $strTable;
	
		$strSQL=ProperlyAppendSQLWherePhrase($strSQL, $strAdminIDRangeAddendum);
	}
	$out="";
	$records = $sql->query($strSQL);
	foreach ($records as $key=>$value )
	{
		$intFieldCount=0;
		$row="";
		foreach ($value as $key1 => $value1 )
		{
		
			$strpreparedcontent=doublequoteescape($value1);
			if ($quotecontent)
			{
				$strpreparedcontent='"' . $strpreparedcontent . '"';
			}
			if ($strFields!="")
			{
				if (inList($strFields,  $key1))
				{
				
					$row.=     $strpreparedcontent .  $strFieldDelimiter;
				}
			}
			else
			{
				$row.=   $strpreparedcontent  .  $strFieldDelimiter;
			}
		}
		$out.= RemoveEndCharactersIfMatch($row, $strFieldDelimiter);
		$out.=  $strRowDelimiter;
	}
	return $out;
}


////////////////////////////////////////
//UTILITIES////////////////////////////
//////////////////////////////////////

function LinkIfFile($strFile, $strQueryString, $strAnchorText, $strUnlinkedPre="", $strUnlinkedPost="", $bwlActuallyLink=true, $bwlUnlinkParam="", $strExtraPairs="")
//Creates a link if the linked-to file exists
{
	$out="";
	$strURL=$strFile;
	
	if (file_exists($strFile))
	{
		if ($strQueryString!="")
		{
		
			$strURL.="?" .  $strQueryString;
		}
		if($bwlActuallyLink)
		{
			$out="<a href=\"" . $strURL . "\" " . $strExtraPairs .">" . $strAnchorText . "</a>";
		}
		else
		{
			$out= "<span " . $bwlUnlinkParam . " " . $strExtraPairs  . " >" . $strAnchorText . "</span>";
		}
	
	}
	if ($out!="")
	{
		$out=$strUnlinkedPre . $out .  $strUnlinkedPost;
	}
	return $out;
}

function simplelinenav($strconfig)
//provides unified site navigation based on double-delimited strConfig having the form filename1|label1-filename2|label2...
{
	$strPHP=$_SERVER['PHP_SELF'] . IfAThenB($_SERVER['QUERY_STRING'], "?") . $_SERVER['QUERY_STRING'];
	$arrconfig=split("-",$strconfig);
	$count=count($arrconfig);
	$out="";
 
	for ($i=0; $i<$count; $i++)
	{
		$arrthis=split("\|", $arrconfig[$i]);
		$strthisfile="/" . $arrthis[0];
	 	//echo $strthisfile . " " . $strPHP . "<br>";
		if ($strthisfile!= $strPHP)
		{
			$out.= "<a  \"  class=\"nav\" href=\"" . $strthisfile . "\">" . $arrthis[1] . "</a>" . chr(13);
		}
		else
		{
			$out.= $arrthis[1]  . chr(13);
		}
		if ($i<$count-1)
		{
			$out.=" | ";
		}
	}
	return($out);
}


function CalculateProbableTextAreaDimensions($v, &$width, &$height, $widthguide=10, $probablescreentextwidth=80)
{
	$len=strlen($v);
	$arrRows=explode("\n", $v);
	$thisrows=count($arrRows);
	$lcasev=strtolower($v);
	if($widthguide>$probablescreentextwidth)
	{
		$widthguide=$probablescreentextwidth;
	}
	if(contains($lcasev, "<p"))
	{
		$thisrows++;
	}
	if(contains($lcasev, "<br"))
	{
		$thisrows++;
	}
	$height=$thisrows; 
	if($len<4)
	{
		$width=4;
	}
	if($len<5)
	{
		$width=8;
	}
	else if($len<8)
	{
		$width=15;
	}
	else if ($len<15)
	{
		$width=20;
	}
	else
	{
		$width= $probablescreenwidth;
		//$width=50;
	}
	if($width<$widthguide)
	{
		$width=$widthguide;
	}
}

function RadioInput($name, $default, $bwlChecked=false, $onClick="",  $strStyle="",  $strClass="")
{
	return GenericInput($name, $default, $bwlChecked, $onClick,  $strStyle, $strClass, "radio");
}

function CheckboxInput($name, $default, $bwlChecked=false, $onClick="", $strStyle="", $strClass="")
{
	return GenericInput($name, $default, $bwlChecked, $onClick, $strStyle, $strClass, "checkbox");
}

function TextInput($name, $default, $size, $onClick="",  $strClass="", $strStyle="")
{
	return GenericInput($name, $default, false, $onClick,  $strStyle, $strClass, "text", $size);
}

function GenericInput($name, $default, $bwlChecked=false, $onClick="",  $strStyle="", $strClass="", $type="submit", $size="", $strStrayJS="", $height=1, $bwlAutocomplete=false)
//Displays just about any kind of HTML input.
{

	if ($onClick!="")
	{
		if(substr($onClick, 0, 1)=="*")
		{
			$onClick=substr($onClick, 1);
			$onClick=" onclick='return(" . $onClick . ")'";
		}
		else
		{
			$onClick=" onclick='" . $onClick . "'";
		}
	}
	$strSize="";
	$checkedindication="";
	if ($bwlChecked)
	{
		$checkedindication=" checked";
	}
	if ($strClass!="")
	{
		$strClass=" class='" .  $strClass . "'";
	}
	if ($strStyle!="")
	{
		$strStyle=" style='" .  $strStyle . "'";
	}
	if(!$bwlAutocomplete)
	{
		$strAutocomplete=" autocomplete=\"off\"";
		//added this part jan 31 2010 because autocomplete usually drives me crazy
	}
	$idstring="";
	if(strlen($name)<35)//suppress ids in cases with extremely long names
	{
		$idstring= " id=\"id" . $name . "\"";
	}
	if ($height>1)
	{
		$out="<textarea" . $strAutocomplete . " rows=\"" .$height . "\" cols=\"" . $size . "\" " . $strStrayJS .  $onClick . $checkedindication .  $strClass .  $strStyle . $idstring . " name=\"" . $name . "\" >" .  $default . "</textarea>";
	}
	else
	{
		if ($size!="")
		{
			$strSize=" size='" .  $size . "'";
		} 
		$out="<input value=\"" . doublequoteescape($default) . "\" " . $strStrayJS . $onClick . $checkedindication . $strClass . " " . $strSize .  $strStyle .  $idstring . " name=\"" . $name . "\" type=\"" . $type . "\" >\n";
	}
	return $out;
}

function HiddenInputs($arrIn, $pre=qpre, $strListToAvoid="", $additionalprefix="")
//Takes an associative array and makes it into a series of hidden  input tags
{
	$out="";
	foreach($arrIn as $k=>$v)
	{
		if (!inList($strListToAvoid, $k))
		{ 
			$quote='"';
			if(contains($v, "\""))
			{
				$quote="'";
			}
		
			$out.="<input id=\"id" . $additionalprefix . $pre .$k . "\"  name=\"" . $additionalprefix . $pre .$k . "\" value=" . $quote . $v . $quote . " type=\"hidden\">\n";
		}
	}
	return $out;
}
	
function addBwls()
//Adds all the bwls and returns the number that were true
{
	$count = func_num_args();
	$out=0;
	for ($i=0; $i<$count; $i++)
	{
		$thisarg[$i]=func_get_arg($i);
		if ($thisarg[$i])
		{
			$out++;
		}
	}
	return $out;
}

function IntToSQLBoul($int)
//Turn a number into the words "true" or "false".
{
	if (intval($int)==1)
	{
		$out="true";
	}
	else
	{
		$out="false";
	}
	return $out;
}

function ProperlyAppendSQLWherePhrase($strSQL, $strPhrase)
//Smart enough to know whether the phrase needs a WHERE
{
	$strProspect=BlankOutQuotedAreas($strSQL, "*", "'");
	if (contains(strtolower($strProspect), " where "))
	{
		$strSQL.= IfAThenB($strPhrase, " AND ") . $strPhrase;
	}
	else
	{
		$strSQL.= IfAThenB($strPhrase, " WHERE ") . $strPhrase;
	}
	return $strSQL;
}
					
function ReverseDirectionSQL($strDirection)
//This function allows me to reverse the sort order by clicking on the heading a second time.
	{
		$strDirection=Alternate("ASC", "DESC", $strDirection);
		return $strDirection;
	}

	
//echo "-" .  parsebetween("man of cheese and honey", "man ", "!", 0, true) . "~";
function GenericForm($arrFieldNames,  $arrLabels, $arrDefaults, $arrFieldConfigs, $strPHP, $strButtonLabel="Save", $width=630, $arrSizes="", $formextratags="", $formname="BForm", $bwlAllOneRow=false, $arrExtraButtons="", $strRequiredConfig="")
//Simplest-possible conversion of field names, labels, and defaults into an actual form.\
//although this thing is pretty complicated now!
{
	//echo var_dump($arrDefaults);
	$strLineClass="bgclassline";
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strOtherBgClass="bgclassother";
	$strOtherLineClass="bgclassline";
	$intDefaultSize=20;
	$strMode="";
	$strFieldsAdded="";
	$fullout="";
	//echo "-" .  $arrDefaults  . "-";
	if(is_array($arrDefaults))
	{
	 	if(array_keys($arrDefaults)>0)//arrays are being passed in as associative
		{
			$strMode="defaultassociative";
		}
	}
	$out.= "<form method=\"post\" name=\"" . $formname . "\" action=\"" .  $strPHP . "\" " . $formextratags . ">\n";
 
	for($i=0; $i<count($arrFieldNames); $i++)
	{
		$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
		$intRequired=0;
		$thisconfig="";
		$size="";
		$foundlabel="";
		$height=1;
		$class="";
		$alpha="";
		$action="";
		$info="";
		$thisfieldname=$arrFieldNames[$i];
		$bwlNumberDropdown=false;
		//echo $thisfieldname. "<BR>";
		$fieldnamefortests =$thisfieldname;
		if(contains($thisfieldname, "|"))
		{
			$arrFN=explode("|", $thisfieldname);
			if(is_numeric($arrFN[1]))
			{
			
				$fieldnamefortests=$arrFN[0]; //numeric dropdown case
			}
			else
			{
				$fieldnamefortests=$arrFN[3];
			}
		}
		if(is_array($arrFieldConfigs))
		{
			//echo $fieldnamefortests . "+<BR>";
			//echo $thisfieldname . "<BR>";
			if(array_key_exists($fieldnamefortests, $arrFieldConfigs))
			{
				//echo $thisfieldname . "-";
				$thisconfig= ($arrFieldConfigs[$fieldnamefortests]);
				//echo $thisconfig . "<BR>";
			}
			//echo $thisfieldname . "<BR>";
		}
		//echo 	$thisfieldname . " "  ;
		if($strMode=="defaultassociative")
		{
			if(contains($arrFieldNames[$i], "|"))
			{
				$arrTemp=explode("|", $arrFieldNames[$i]);
				 
				$strThisDefault=$arrDefaults[ $arrTemp[3]];
				if(is_numeric($arrTemp[1]))
				{
					$bwlNumberDropdown=true;
					$strThisDefault=$arrDefaults[ $arrTemp[0]];
				}
				//echo  $arrFieldNames[$i] . " " .  $strThisDefault . "=<BR>";
				
			}
			else
			{
				$strThisDefault=$arrDefaults[ $arrFieldNames[$i]];
			}
			//echo  $arrFieldNames[$i] . " " .  $strThisDefault . "=<BR>";
		}
		else
		{
			//I WILL NEVER USE THIS MODE AGAIN:
			$strThisDefault=$arrDefaults[$i];
			//echo $strThisDefault . "-<BR>";
		}
		$type="text";
		if(contains($arrFieldNames[$i], "password"))
		{
			$type="password";
		}
		if(contains($oldfieldname, "password")  && contains($thisfieldname, qpre . "password") )
		{
			//handles the setting of default passwords in an edit form where you have to type in the pwd twice
			//only works if a field named qpre. password immediately follows a field containing the name password
			$strThisDefault=$oldvalue;
		}
		$dropdownconfig="";
		//echo $thisconfig . "<BR>";
		if(contains($thisconfig,"dropdown:"))
		{
			$dropdownconfig=parseBetween($thisconfig, "dropdown:", "%", 0, true);
		}
		if (contains($thisconfig,"size:"))
		{
			$size=parseBetween($thisconfig, "size:", " ", 0, true);
			//echo $thisconfig . "*" . $size . "<BR>";
		}
		if (contains($thisconfig,"info:"))
		{
			$info=parseBetween($thisconfig, "info:'", "'", 0, true);
			//echo $thisconfig . "*" . $info . "<BR>";
		}
		
		if (contains($thisconfig,"label:"))//you can pass in a label this way, but you have to use underscores instead of spaces these get converted to spaces
		{
			$foundlabel=parseBetween($thisconfig, "label:", " ", 0, true);
			$foundlabel=str_replace("_", " ", $foundlabel);
			//echo $thisconfig . "*" . $size . "<BR>";
		}
 
		if (contains($thisconfig,"type:"))
		{
			$type=parseBetween($thisconfig, "type:", " ", 0, true);
			//echo $thisconfig . "*" . $size . "<BR>";
		}
		if (contains($thisconfig,"action:"))
		{
			$action=parseBetween($thisconfig, "action:", " ", 0, true);
			//echo $thisconfig . "*" . $size . "<BR>";
		}
		if (contains($thisconfig,"alpha:"))
		{	
		
			$alpha=parseBetween($thisconfig, "alpha:", " ", 0, true);
			//echo "<BR>" . $thisconfig . "*" . $alpha . "==<BR>";
		}
		if (contains($thisconfig,"class:"))
		{	
		
			$class=parseBetween($thisconfig, "class:", " ", 0, true);
			//echo $thisconfig . "*" . $class . "<BR>";
		}
		if (contains($thisconfig,"hid"))
		{
			
			$out.=HiddenInputs(Array($thisfieldname=>$strThisDefault),"") . "\n";
		}
		else
		{
			if($size=="")
			{
				$size=$arrSizes[$i];
			}
			if($size>1000)  //i pass in height as multiples of 1000 with the remainder as width
			{
				//echo "*";
				$height=intval($size/ 1000);
				$size=  $size % 1000  ;
	 
			}
			//echo $size .  "+" . $height . "-<br>";
			$size=gracefuldecay($size, $intDefaultSize);
			if (contains($thisconfig,"readonly"))
			{
				$inputtag=$strThisDefault;
			}
			else
			{
				if(contains($thisfieldname, "|"))
				{	
					//echo $strThisDefault .  " "  . $thisfieldname . "<BR>";
					//i hack this function to allow me to embed dropdowns
					//if the fieldname contains vertical bars then the format is:
					//table_name|table_pk|table_labelfield|localfieldname|whereclause
					if($bwlNumberDropdown)
					{
						$arrThisFieldName=explode("|", $thisfieldname);
						$strName=$arrThisFieldName[0];
						$intstart=$arrThisFieldName[1];
						$intend=$arrThisFieldName[2];
						$strFunction=$arrThisFieldName[3];
						$strAppend=$arrThisFieldName[4];
							//echo $strThisDefault . "<BR>";
						$inputtag=numericpulldown($intstart,$intend,$strThisDefault,$strName,   false, $strFunction , $strAppend);
					}
					else
					{
						$arrThisFieldName=explode("|", $thisfieldname);
						$thistablename=$arrThisFieldName[0];
						$thistablepk=$arrThisFieldName[1];
						$thistablelabelfield=$arrThisFieldName[2];
						$thislocalfieldname=$arrThisFieldName[3];
						$thisfieldname=$thislocalfieldname;//needed to do this to keep dropdown form items from also appearing in hidden list
						$whereclause=$arrThisFieldName[4];
						//echo "+" . $strThisDefault . "+<br>";
						//echo $thistablename;
						$inputtag=foreigntablepulldown(our_db,  $thistablename, $thistablepk, $strThisDefault, $thislocalfieldname, $namereturn,  false, $thistablelabelfield, "", $whereclause);
					}
					//$inputtag=Narrowedforeigntablepulldown(our_db, $thistablename, $thistablepk,$strThisDefault, $thislocalfieldname, $namereturn, false,  $thistablelabelfield,"",  "","", "", "", $whereclause);
				}
				else
				{	
					$strRequiredIndication="";
			 		if($strRequiredConfig!="")
					{
						if(genericdata($thisfieldname,0, 0, $strRequiredConfig, "~", "|")==$thisfieldname)
						{
							$strRequiredIndication="<span class='requiredindication'>*</span>";
							$intRequired++;
						}
					}
					if($dropdownconfig!="")
					{
						//echo $dropdownconfig;
						//GenericDataPulldown($strConfig, $intIDField, $intLabelField, $strQueryVariableName, $strDefault="", $strPHP="", $strFormName="", $strConnector ="?", $bwlAcceptWild=true, $strEmptyText="-none-", $rowdelimiter="-", $fielddelimiter="|", $strExtraValPairs="")
						//echo $strThisDefault;
						$inputtag=GenericDataPulldown($dropdownconfig, 0, 1, $thisfieldname, $strThisDefault );
					}
					else if($type=="checkbox")
					{
						$inputtag=CheckboxInput($thisfieldname, 1, $strThisDefault==1);
					}
					else if($type=="date")
					{
						$inputtag=datepulldowns($thisfieldname, $strThisDefault);
					}
					else
					{
						$inputtag= GenericInput($thisfieldname, $strThisDefault,  false,  "",   "",  "", $type,$size, "", $height) ;
					}
				}
			}
			//echo $class . "<BR>";
	 
			if($action=="startover")
			{
				$fullout.=TableEncapsulate($out, false, $width) . "<BR/>";
				$out="";
			}
			$classToUse=gracefuldecay($class, $strThisBgClass);
			if($alpha!="")
			{
				$classToUse=gracefuldecay($class, $strThisBgClass) . "|" . $alpha;
			}
			$infostring="";
			//echo "-" . $info;
			if($info!="")
			{
				$infostring="<div class='infostring'>" . $info . "</div>";
			}
		
		
			if($bwlAllOneRow)
			{
				$out.=  gracefuldecay($foundlabel,$arrLabels[$i], $thisfieldname) .$strRequiredIndication . "&nbsp;" .  $inputtag . $infostring;
			}
			else
			{

				$out.=htmlrow($classToUse, gracefuldecay($foundlabel, $arrLabels[$i], $thisfieldname) . $strRequiredIndication , $inputtag . $infostring);
			}
		}
		$strFieldsAdded.=" " . $fieldnamefortests;
		$oldfieldname=$thisfieldname;
		$oldvalue=$strThisDefault;
	}
	//add any leftover defaults as hidden form items
	if($strMode=="defaultassociative")
	{
		foreach($arrDefaults as $k=>$v)
		{
			if(!inList($strFieldsAdded, $k))
			{
				// GenericInput($name, $default, $bwlChecked, $onClick,  $strStyle, $strClass, "radio");
				$out.=HiddenInputs(Array($k=>$v), "") . "\n";
			}
		}
	}
	$strExtraButtons="";
	if(is_array($arrExtraButtons))
	{
		foreach($arrExtraButtons as $k=>$v)
		{
			if(contains( strtolower($k), "onclick"))
			{
				//GenericInput($name, $default, $bwlChecked=false, $onClick="",  $strStyle="", $strClass="", $type="submit", $size="", $strStrayJS="", $height=1, $bwlAutocomplete=false)
				$strOnclick=parseBetween($k, "=", "");
				//echo "-" . $k . "-" . $strOnclick;
				$strExtraButtons.=GenericInput(qpre, $v, "",  $strOnclick ,"",  "genericbutton") . "\n";
			}
			else
			{
				$strExtraButtons.=GenericInput(qpre . $k, $v, "","","",  "genericbutton") . "\n";
			}
		}
	}
	$strRequiredIndicationExplanation="";
	if($intRequired>0)
	{
		$strRequiredIndicationExplanation="<span class='requiredindication'>*</span> Indicates required fields.  ";
	}
	$mainbutton="";
	if($strButtonLabel!="")
	{
		$mainbutton= GenericInput(qpre . "save", $strButtonLabel, "","","",  "genericbutton");
	}
	if($bwlAllOneRow)
	{
		$out.="&nbsp;" .  $strRequiredIndicationExplanation  . $strExtraButtons .$mainbutton;
	}
	else
	{
		$out.=htmlrow("^2" . $strOtherBgClass,  "<div align='right'>" . $strRequiredIndicationExplanation  . $strExtraButtons .  $mainbutton. "</div>");
	}
	
	$out.= "</form>\n";
 	if($bwlAllOneRow)
	{
		$fullout.= "<div style=\"width:" .$width . "px\" class=\"" . $strOtherBgClass . "\">" . $out . "</div>";
	}
	else
	{
		$fullout.= TableEncapsulate($out, false, $width);
		
	}
	
	return $fullout;
}

////////////////////////////////////////////////////////
//more complex db functions
////////////////////////////////////////////////////////

function tablechecksum($strDatabase, $tablename) 
//Judas Gutenberg, September 2 2008
//returns a table's checksum from mysql
{
	$sql=conDB(); 
	//for some reason i have to do this. it's a bug in mysql
	$strSQL="ALTER TABLE " . $strDatabase . "." . $tablename . " CHECKSUM=1";
	$rs = $sql->query($strSQL);
	//echo sql_error(). "<br>";
	$strSQL="CHECKSUM TABLE " . $strDatabase . "." . $tablename;
	$rs = $sql->query($strSQL);
	$r=$rs[0];
	$out=$r["Checksum"];
	//echo $tablename . " " . $out . "<br>";
	return $out;
}


function CountRelated($strDatabase, $strTable, $strPK, $strPKColumn="", &$tfrecords)
//November 16 2009 - counts the number of items related to this one, as known by tableform
//i pass back tfrecords to make it usable to subsequent calls
{

	$sql=conDB();
	$out="";
	if($strPKColumn=="")
	{
		$strPKColumn=PKLookup($strDatabase, $strTable);
	}
	$out="";
	
	if($tfrecords=="")
	{		
		$strSQL="SELECT * FROM " . $strDatabase . "." . tfpre . "relation WHERE f_table_name='" . $strTable . "' AND f_column_name='" . $strPKColumn . "'";
		$tfrecords = $sql->query($strSQL);
 	}
	
	//foreach($grecord as $k=>$v)
	//{
	
	
	//}
	foreach($tfrecords as $record)
	{
		$thistable=$record["table_name"];
		$thiscolumn=$record["column_name"];
		if($strPK!="")
		{
			$cstrSQL="SELECT count(" . $thiscolumn  . ") AS thiscount FROM " . $strDatabase . "." . $thistable . " WHERE " . $thiscolumn . "='" . $strPK . "'";
			//echo $cstrSQL  ."<br>";
	 		//echo mysql_error()  ."<br>";
			$crecords = $sql->query($cstrSQL);
			foreach($crecords as $crecord)
			{
			 	$thiscount+=$crecord["thiscount"];
			}
	 
		}
	}
	
	$grecord["related"]=$thiscount;
	return $thiscount;
}

function RequestCompoundDate($pre)
{
	$day=$_REQUEST[$pre . "|day"   ];
	$month=$_REQUEST[$pre . "|month" ];
	$year=$_REQUEST[$pre. "|year" ];
	$v="";
	if($day!=""  && $month!=""  && $year!="")
	{
		$strTime=ReasonableStringDate($month, $day, $year);
		$v=$strTime; //just turning the value into a PHP timestamp
		$k=$strPossibleDateName;  //just turning the key back to a conventional key for the next section
	}
	return $v;
}

function GVFF($spacedelimitednamelist, $arrAdditional="",  $type="post" )
//returns an array of requests with values
{
	$arrIn=explode(" ", $spacedelimitednamelist);
	$arrOut=Array();
	foreach($arrIn as $k)
	{
		if ($type=="request")
		{
			$v=$_REQUEST[$k];
		}
		else if ($type=="post")
		{
			$v=$_POST[$k];
		}
		else if ($type=="get")
		{
			$v=$_GET[$k];
		}
		$arrOut[$k]=$v;
	}
	if (is_array($arrAdditional))
	{
		foreach($arrAdditional as $k=>$v)
		{
			$arrOut[$k]=$v;
		}
	}
	return $arrOut;
}

////////////////////////////
//took out more complex string funcs
///////////////////////////

function LabelForID($strDatabase, $strTable, $strIDField, $intID, $strKnownFields="")
{

 	$arrNameFields =LabelThis(firstnonidcolumname($strDatabase, $strTable), $strKnownFields, $connector,  "",    "");
	if ( $intID!="")
	{
		$sql=conDB();
		$strSQL="SELECT " . join(",", $arrNameFields) . " FROM " . $strDatabase . "." . $strTable . " WHERE " .  $strIDField . " = " . $intID;
		$records = $sql->query($strSQL);
		if ($records)
		{
			//echo"@";
			$record=$records[0];
			$out="";
			foreach($arrNameFields as $thisfield)
			{
				//echo  $strTable . " " . $thisfield . "<BR>";;
				$out.=$record[$thisfield]. $connector; 
			}
			$out=substr($out, 0, strlen($out)-strlen($connector));
			return $out;
		}
	}
}
	
function foreigntablepulldown($strDatabase, $strTable, $strIDField, $intDefault, $strLabelField="", &$namereturn, $bwlHiddenReturn=false, $strPreferredNameField="", $addedselectpairs="", $strWhereClause="", $recordforusewithwhereclause="", $truncsize=35)
//Gives me a select named $strIDField of ids with rows from $strTable, defaulted to $intDefault
//$namereturn, passed by reference, allows me to hand back the selected string label of the pulldown, which is won at considerable
//computative effort
//bwlHiddenReturn allows me to pass the actual string value of the dropdown in a specially-labeled hidden field.
//THIS FUNCTION IS BEGGING TO BE REFACTORED!!!
{
 	//echo $strWhereClause;
	//echo  $strTable  . " " . $strIDField ." " . $intDefault .  "<BR>";
	$sql=conDB();
	$strHiddenExtra="";
	$strNameField2="";
	$strNameField="";
	$moreflag=false;
	$connector =" : ";
	$arrOut=Array();
	$strIDs="";
	$bwlForceBothFields=false;
	if ($strLabelField=="")
	{
		$strLabelField= $strIDField;
	}
	$strOut="<select id=\"id" . $strLabelField  . "\" " . $addedselectpairs . " name=\"" . $strLabelField . "\"";
	if ($bwlHiddenReturn)
	{
	
		$strOut.=" onchange=\"document.BForm." . qpre . "multi.value=document.BForm." .  $strLabelField . "[document.BForm." .  $strLabelField . ".selectedIndex].text\"";
	}
	$strOut.= ">"."\n";
	$strOut.="<option value=".chr(34).chr(34).">none"."\n";
	if ($strPreferredNameField=="")
	{
		$arrFieldNames=GetFieldArray($strDatabase, $strTable);
		$strNameField=firstnonidcolumname($strDatabase, $strTable);
		//echo 	$strNameField;
		//$strNameField2 = NthNonIDColumName($strDatabase, $strTable, 2);
		//kind of hacky but hey, we need more info:
		//$firstIDNotPK=NthIDColumName($strDatabase, $strTable,"last");
	}
	else
	{
		//would love to include the logic from LabelThis here
		//so here i go!
		$arrLabelFields=LabelThis($strPreferredNameField, $strPreferredNameField,  $connector, "", "", $truncsize);
		$strNameField=$arrLabelFields[0];
		$strNameField2=$arrLabelFields[1];
		$bwlForceBothFields=count($arrLabelFields)>1;
		$orderby=$strNameField;
		if($connector==" "  && $bwlForceBothFields)
		{
			$orderby=$strNameField2;
		}
	}
	$strSQL="SELECT * FROM " . $strDatabase . "." . $strTable . " a ";
	//echo "+" . MergeLimitingConditionsWithRSData($strWhereClause, $recordforusewithwhereclause) . "+";
	$strSQL.=" " .  MergeSQLConditionals(MergeLimitingConditionsWithRSData($strWhereClause, $recordforusewithwhereclause) , "");
	
	if ($strNameField!="")
	{
		$strSQL.=" ORDER BY " . str_replace(" ", ",", gracefuldecay($orderby, $strNameField));
	}
	//echo $strSQL . "<BR>";
	//if ($strNameField2!="")
	//{
		//$strSQL.=", " . $strNameField2;
	//}
	//echo $strSQL . "<BR>";
	$records = $sql->query($strSQL);
	if ($records)
	{
		$strOldLabel="";
		//some code to handle the sorting of the records, because orderby is fuct
		$arrOut=array();
		foreach($records as $k)
		{
			//some complicated code to handle the situation where name fields are not very unique
			$strLabel1 = $k[$strNameField];
			$strLabel2="";
			//$strLabel2 = $k[$strNameField2];
			if($strNameField2=="")
			{
				for($j=0; $j<2; $j++)
				{
					//echo $strNameField2 . ".<BR>";
					for($i=1; $i<count($arrFieldNames); $i++)
					{
						//echo $arrFieldNames[$i] . "<br>";
						
						$possiblelabel2field=  $arrFieldNames[$i];
						$possiblelabel2=$k[$possiblelabel2field];
						if($strLabel2==""  && $possiblelabel2field!=$strNameField  && $possiblelabel2field!=$strIDField  && $possiblelabel2!=""  && $possiblelabel2!=0  && !(is_numeric($possiblelabel2) && $j==0) )
						{
							$strLabel2=$k[$arrFieldNames[$i]];
							//echo $arrFieldNames[$i] . " " . $strLabel2 . "<br>";
							break;
						}
					}
				}
			}
			else
			{
				$strLabel2=$k[$strNameField2];
				
			}
			//if ($strLabel2=="")
			//{
				//echo $firstIDNotPK . "<br>";
			 	//$strLabel2=$k[$firstIDNotPK];
			//}
			$strLabel= $strLabel1;
			if($strOldLabel==$strLabel1 )
			{
				$moreflag=true;
			}
			if ((strlen($strLabel1)<15 && $strLabel2!="" && !(strlen($strLabel2)>15))   && ($strNameField2!="password") || $moreflag  || $bwlForceBothFields)
			{
			 	//echo truncate($strOldLabel, $truncsize) . " ---- " . trim(truncate($strLabel1, $truncsize))  . " --- " . (trim(truncate($strOldLabel, 35))==trim(truncate($strLabel1, 35))) .  "\n";
			 	if($bwlForceBothFields )
				{
					$strLabel = $strLabel1 . $connector . $strLabel2;
				}
				else if(trim(truncate($strOldLabel, $truncsize))==trim(truncate($strLabel1, $truncsize)) )
				{
					$pod=PointOfDissimilarity(trim($strOldLabel), trim($strLabel1));
					//echo $pod . "<br>";
					$pretruncated= substr($strLabel1, $pod);
					if($pretruncated!="")
					{
						$strLabel= truncate("..." . $pretruncated, $truncsize);
					}
					else
					{
						$strLabel = $strLabel1 . $connector  . $strLabel2;
						$bwlAlterPreceding=true;
					}
				}
				else
				{
					$strLabel=$strLabel1 ;
				}
			}

			$strOldLabel=$strLabel1;
			$strSel="";
			//if(!inList($strIDs, $k[$strIDField]))//don't actually need this test
			{
		 		//echo $strIDs . "<br>";
				$strIDs.=" " . $k[$strIDField];
				if ($k[$strIDField]==$intDefault)
				{
				   $strSel=" selected=\"true\" ";
				   $namereturn=$strLabel;
				 
				   if ($bwlHiddenReturn)
				   {
				   	$strHiddenExtra="<input type=\"hidden\" name=\"" .$strFieldNamePrefix  . qpre . "multi\"   value=\"".  $strLabel . "\">\n";
				   
				   }
				 } 
				$arrOut[$outcount] = "<option value=\"". $k[$strIDField] . "\" " . $strSel .  ">". truncate($strLabel, $truncsize) ."\n";
				
				// $arrOut[$strLabel]=$k[$strIDField];
				
				if($bwlAlterPreceding)
				{
					//echo $strLabel . " " . $strPrecedingAltLabel . "<br>";
					$arrOut[$outcount-1]="<option value=\"". $strPrecedingK  . "\" " . $strPrecedingSel .  ">". $strPrecedingAltLabel ."\n";
				}
				$outcount++;
				$strPrecedingAltLabel = $strLabel1 . "  " . $strLabel2;
				$strLabel2 ="";
				$strPrecedingK=$k[$strIDField];
				$strPrecedingSel=$strSel;
				$bwlAlterPreceding=false;
			}
		} 
		if ($strHiddenExtra=="" && $bwlHiddenReturn)
		{
			$strHiddenExtra="<input type=\"hidden\" name=\"" .$strFieldNamePrefix  . qpre . "multi\"   value=\"\">\n";
		}
	}
	$strOut.=join("\n", $arrOut);
	$strOut.= "</select>\n";
	$strOut.= $strHiddenExtra;
	
	return $strOut;
}

function FindOtherTableMapped($strDatabase, $strGivenTable, $strMappingTable)
//Given a mapping table and a table at one end of the map, return the other.
{
	$sql=conDB();
	$strSQL="SELECT * FROM " . $strDatabase . "." . tfpre . "relation WHERE table_name='" . $strMappingTable . "' AND relation_type_id=0"; 
	$records = $sql->query($strSQL);
	foreach($records as $record)
	{
		if( $record["f_table_name"]!=$strGivenTable)
		{
			return $record["f_table_name"];
		}
	}
}

function FindOtherColumnMapped($strDatabase, $strGivenColumn, $strMappingTable)
//Given a mapping table and a column at one end of the map, return the other.
{
	$sql=conDB();
	$strSQL="SELECT * FROM " . $strDatabase . "." . tfpre . "relation WHERE table_name='" . $strMappingTable . "' AND relation_type_id=0"; 
	$records = $sql->query($strSQL);
	foreach($records as $record)
	{
		if( $record["column_name"]!=$strGivenColumn)
		{
			return $record["column_name"];
		}
	}
}

function LookupAPotentialLimitingJoin($strDatabase, $strOurTable, $strMysteryColumn, $strTableToAvoid)
{
	$sql=conDB();
	$strSQL="SELECT * FROM " . $strDatabase . "." . tfpre . "relation WHERE f_table_name='" . $strOurTable . "' AND column_name='" . $strMysteryColumn . "' AND table_name<>'"  . $strTableToAvoid . "'";
	//echo $strSQL . "<P>";
	$records = $sql->query($strSQL);
	$record=$records[0];
	$maptablename= $record["table_name"];
	$maptablePK=$record["f_column_name"];
	$columnonothersideofmap=FindOtherColumnMapped($strDatabase, $strMysteryColumn, $maptablename);
	$strSQLOUT="SELECT * FROM " . $strDatabase . "." . $strOurTable . " INNER JOIN   " .$strDatabase . "." .$maptablename . "  ON   " . $strDatabase . "." . $strOurTable . "." . $maptablePK  . "=" .   $strDatabase . "." . $maptablename  . "." .  $columnonothersideofmap;
	return $strSQLOUT;
}

function FindMappingTable($strDatabase, $strTable, $strMappedTable, $strMappedPKName="", $strAvoidTableList="")
//Return the name of table that maps one table to another
{
	$sql=conDB();
	$strTableList="";
	$strMTableList="";
	if($strMappedTable!="")
	{
		$strSQL="SELECT * FROM " . $strDatabase . "." . tfpre . "relation WHERE  (f_table_name='" . $strTable . "' OR f_table_name='" . $strMappedTable . "') AND  relation_type_id=0 " ;
	}
	else
	{
		$strSQL="SELECT * FROM " . $strDatabase . "." . tfpre . "relation WHERE  (f_table_name='" . $strTable . "' OR f_column_name='" . $strMappedPKName . "') AND  relation_type_id=0 " ;
	}
	//echo $strSQL;
	$records = $sql->query($strSQL);
	foreach($records as $record)
	{
		if( $record["f_table_name"]==$strTable)
		{
			$strTableList.=$record["table_name"]. " ";
 
			if (inList($strMTableList, $record["table_name"])  && !inList($strAvoidTableList, $record["table_name"]))
			{
				return $record["table_name"];
			}
		}
		if( $record["f_table_name"]==$strMappedTable )
		{
			$strMTableList.=$record["table_name"] . " ";
 
			if (inList($strTableList, $record["table_name"]) && !inList($strAvoidTableList, $record["table_name"]))
			{
				return $record["table_name"];
			}
		}
		if( $record["f_column_name"]==$strMappedPKName )
		{
			$strMTableList.=$record["table_name"] . " ";
	 
			if (inList($strTableList, $record["table_name"])&& !inList($strAvoidTableList, $record["table_name"]))
			{
				return $record["table_name"];
			}
		}
	}
	return false;
}



function MaxColNameLength($strDatabase, $strTable, &$bwlWasTableName)
//Returns the length in characters of a table's column names.  Will return table's name if it's longest
{
	$records = TableExplain($strDatabase, $strTable);
	$maxlen=strlen($strTable);
	$bwlWasTableName=true;
	foreach ($records as $k => $info )
	{
		 $len=strlen($info["Field"]);
		 if($len>$maxlen)
		 {
		 	$maxlen=$len;
			$bwlWasTableName=false;
		 } 
	}
	return $maxlen;
}



function FleshedOutFKSelect($strDatabase, $strTable, $additionalClauses, &$arrDesc, $strUnnecessaryJoinTables="", $bwlKeepPKs=false, $bwlIncludeAllRelatedFields=false, $arrFKNameMap="", $strConcatString=", ")
//Delivers the SQL to do a select from a table with the necessary joins so that instead of foreign key ids we get
//fields populated with readable strings
//ALSO: returns an array by reference containing types, because this is essential info for a lot of what this SQL is used to do
//Judas Gutenberg 2007-2-1
//ADDED 2010-1-30:  $arrFKNameMap is an associative array map in the form FK->namecolumn to offer suggestions for best name columns in complex
//cross-relation selects
{
	GLOBAL $db_type;
	$strDISTINCT="DISTINCT ";
	if( $db_type=="odbc")
	{
		$strDISTINCT="";
	}
	
	
	$sql=conDB();
	//first get all the text fields for all the foreign keys
	$strPK=PKLookup($strDatabase, $strTable);
	$strSQL="SELECT * FROM " . $strDatabase . "." . tfpre . "relation WHERE relation_type_id=0 AND table_name='" . $strTable . "'";
	//echo $strSQL;
	$records = $sql->query($strSQL);
	$strJoinSQL="";
	$strPreJoinSQL="";
	$strSkipFieldList="";
	$arrDesc=Array();
	$bwlDie=false;
	$count=0;
	foreach($records as $record)
	{
		//echo $record["f_table_name"] . " " .  $strTable . "<br>";
		if ($record["f_table_name"]== $strTable)
		{
			$bwlDie=true;
		}
		if (!inList($strUnnecessaryJoinTables, $record["f_table_name"]))
		{
			$strJoinSQL.=" LEFT JOIN " . $strDatabase . "." . $record["f_table_name"] . " x" . $count. " ON t." . $record["column_name"] . "=x" . $count. "." . $record["f_column_name"] . " " ;
			$suggestedcolumn="";
			$arrSuggestion="";
			if($arrFKNameMap=="")
			{
				$nameColumn=firstnonidcolumname($strDatabase, $record["f_table_name"]);
			}
			else if(array_key_exists($record["column_name"], $arrFKNameMap))
			{
				$suggestedcolumn=$arrFKNameMap[$record["column_name"]];
				$arrSuggestion="";
				if(contains($suggestedcolumn, " "))
				{
					//TOO HAIRY FOR NOW!!//nevermind i pulled it off!
					$arrSuggestion=explode(" ", $suggestedcolumn);
				}
				else
				{
					$nameColumn=$suggestedcolumn;
				}
			
			}
			else
			{
				$nameColumn=firstnonidcolumname($strDatabase, $record["f_table_name"]);
			}
			$strNameAdditional="";
			//in some cases the foreign table's field name isn't specific enough in the join to be a proper label
			//so in those cases i append the table name to the front of the fieldname to make it into a proper label
			$strNameAdditional="";
			if($nameColumn=="name"  && $arrSuggestion=="")
			{
				$strNameAdditional=" as `" . $record["f_table_name"] . "_" . $nameColumn . "`";
			}
			else if (is_array($arrSuggestion))
			{
				$strNameAdditional=" as `full name`";
			}
			$arrDesc[$nameColumn]= GetFieldType($strDatabase, $record["f_table_name"], $nameColumn);
			if($bwlIncludeAllRelatedFields)
			{
				$leafrecords = TableExplain($strDatabase,$record["f_table_name"]);
				foreach($leafrecords as $kl=>$vl)
				{
					$strPreJoinSQL.=" x".$count . "." . $vl["Field"]  . ","   ;
					
				}
			}
			else if(is_array($arrSuggestion))
			{
				$concatstring="";
				$concatconclude=",'" . $strConcatString . "',";
				foreach($arrSuggestion as $thissuggestion)
				{
					$concatstring.=" x".$count . "." . $thissuggestion . $concatconclude;
				}
				$concatstring=substr($concatstring, 0, strlen($concatstring)-strlen($concatconclude));
				$strPreJoinSQL.=" CONCAT(" .     $concatstring . ")"  .$strNameAdditional . ","   ;
			}
			else 
			{
				$strPreJoinSQL.=" x".$count . "." . $nameColumn .$strNameAdditional. ","   ;
			}
			if(!$bwlKeepPKs)
			{
				$strSkipFieldList.=" " .  $record["column_name"];
			}
	
			$count++;
		}
	}
	//now throw away the FK fields themselves, since they just gum up the works
	$records=TableExplain($strDatabase, $strTable);
	$intFindCount=1;
	$goodFieldList="";
	foreach ($records as $k => $info )
	{
		if(!inList($strSkipFieldList, $info["Field"]))
		{
			$goodFieldList.="t." . $info["Field"] . ",";
			$arrDesc[$info["Field"]]= GetFieldType($strDatabase, $strTable, $info["Field"]);
		}
	}

	$goodFieldList=RemoveEndCharactersIfMatch($goodFieldList, ",");
	$strPreJoinSQL=RemoveEndCharactersIfMatch($strPreJoinSQL, ",");
	$out="SELECT " . $strDISTINCT .   $goodFieldList .  IFAthenB(($strPreJoinSQL  && $goodFieldList),", ") . $strPreJoinSQL  ." FROM " . $strDatabase . "." .  $strTable . " t " . $strJoinSQL . " " .   " " . $additionalClauses;
	if($strPK!="")
	{
		if(!contains($additionalClauses, "ORDER BY") )//was having trouble with group by when an order by was passed in
		{
			$out.=" GROUP BY " . $strPK ;
		}
		else
		{
			$out=str_replace("ORDER BY", "GROUP BY " . $strPK . " ORDER BY", $out);
		}
	}
	if (count($arrDesc)<1)
	{
		$arrDesc=GetFieldTypeArray($strDatabase, $strTable);
	}
	if($bwlDie)
	{
		$out="";
	}
	//echo $out;
	return $out;
}

function firstnonidcolumname($strDatabase, $strTable)
//In which i make a reasonable guess of how to best provide a user-friendly label for a row of data
//I basically look through the fields until I find the first one that isn't  type int or named password
{
	return NthNonIDColumName($strDatabase, $strTable, 1);
}

	
function NthIDColumName($strDatabase, $strTable, $n)
//I basically look through the fields until I find the $nth one that is type int 
{
	$records=TableExplain($strDatabase, $strTable);
	$intFindCount=1;
	if($n=="last")
	{
		$n=count($records)-1;
	}
	foreach ($records as $k => $info )
	{
		$olderror=error_reporting(0);
		//echo TypeParse($info["Type"],0) . "==<br>";
		//if (!contains(TypeParse($info["Type"],0),"int")  && (!contains($info["Field"], "password")    & !contains($info["Field"], "image") & !contains($info["Field"], "filename") & !contains($info["Field"], "date") & !contains($info["Field"], "price")))
		if (contains(TypeParse($info["Type"],0),"int"))
		{
			//echo $info["Field"]. "=<br>";
			if ($intFindCount==$n)
			{
				//echo $info["Field"] . "**<br>";
				return $info["Field"];
			}
			$intFindCount++;
		}
		error_reporting($olderror);
	}
}
	
function NthNonIDColumName($strDatabase, $strTable, $n)
//In which i make a reasonable guess of how to best provide a user-friendly label for a row of data
//I basically look through the fields until i find the $nth one that isn't type int or named password
{
	$records=TableExplain($strDatabase, $strTable);
	$intFindCount=1;
	foreach ($records as $k => $info )
	{
		$olderror=error_reporting(0);
		//echo TypeParse($info["Type"],0) . "==<br>";
		//if (!contains(TypeParse($info["Type"],0),"int")  && (!contains($info["Field"], "password")    & !contains($info["Field"], "image") & !contains($info["Field"], "filename") & !contains($info["Field"], "date") & !contains($info["Field"], "price")))
		if (!contains(TypeParse($info["Type"],0),"int")  && (!contains($info["Field"], "password") ))
		{
			if ($intFindCount==$n)
			{
				return $info["Field"];
			}
			$intFindCount++;
		}
		error_reporting($olderror);
	}
}
	
function SortColumn($strDatabase, $strTable)
//Looks for a possible sort column
//February 25 2007
{
	$records=TableExplain($strDatabase, $strTable);
	foreach ($records as $k => $info )
	{
		$olderror=error_reporting(0);
		//echo TypeParse($info["Type"],0) . "==<br>";
		//if (!contains(TypeParse($info["Type"],0),"int")  && (!contains($info["Field"], "password")    & !contains($info["Field"], "image") & !contains($info["Field"], "filename") & !contains($info["Field"], "date") & !contains($info["Field"], "price")))
		//echo $info["Field"] . "**<br>";
		if (contains(TypeParse($info["Type"],0),"int"))
		{
			//echo $k . "<br>";
			$name=$info["Field"];
			if(contains($name, "sort"))
			{
				return $name;
			}
		}
		error_reporting($olderror);
	}
}
	
function foreignKeyLookup($strDatabase, $strTable, $strColumn)
//Looks up the foreign key table and column given a column.
{
	$sql=conDB();
	$records = $sql->query("SELECT column_name, f_table_name, f_column_name FROM " . $strDatabase . "." . tfpre . "relation WHERE table_name='" . $strTable . "' AND column_name='" . $strColumn . "'  AND relation_type_id=0");
	$count=0;
	foreach ($records as $record)
	{
		return array(  $record["f_table_name"],  $record["f_column_name"]) ;
		$count++;
	}
}


function GetExtraColumnInfo($strDatabase, $strTable, $strColumnName="")
{
	$sql=conDB();
	$strSQL="SELECT * FROM " . $strDatabase . "." .  tfpre . "column_info WHERE table_name='" . $strTable . "'";
	if($strColumnName!="")
	{
		$strSQL=" AND column_name='" . $strColumnName . "'"; 
	
	}
	$records = $sql->query($strSQL);
	if($strColumnName=="")
	{
		return $records;
	}
	if(is_array($records))
	{
		return $records[0];
	}
	else
	{
		return array();
	}
}

//basic db functions moved to appropriate include
	
function nonuseridnonPKIDcolumn($strDatabase, $strTable)
//Return the first int column that isn't userid or PK.
{
	$records=TableExplain($strDatabase, $strTable);
	foreach ($records as $k => $v )
	{
		if ($v["Key"]!="PRI"  && !contains($v["Field"],"user_id") && (beginswith($v["Type"], "int")))
		{
			return $v["Field"];
		}
	}
	return false;
}
	
function SetChanged($strDatabase)
{
	$sql=conDB(); 
	$tables=TableList($strDatabase);
	$strSQL="INSERT INTO " . $strDatabase  . "." . tfpre . "dbdiff(diff_performed) VALUES('" . DateTimeForMySQL(date("F j Y g:i a")) . "')";
	$rs = $sql->query($strSQL);
	$id=sql_insert_id();
	$tables=ListTables($strDatabase);
	foreach ($tables as $tablename)
	{
		$count = countrecords($strDatabase , $tablename );
		$checksum=tablechecksum($strDatabase , $tablename );
		$highestpk=highestprimarykey($strDatabase, $tablename);
		$strSQL="INSERT INTO " . $strDatabase  . "." . tfpre . "dbdiff_table(dbdiff_id, table_name, table_rowcount, table_checksum, max_id) VALUES('" . $id . "','" . $tablename . "','" . $count . "','" . $checksum  . "','" . $highestpk . "')";
		$rs = $sql->query($strSQL);
		//echo $strSQL . " " . sql_error() . "<p>";
	}
 
	return "Database state saved.";
}
	

function ClearNumeric($strIn, $bwlAcceptDecimal=true, $bwlAcceptNegative=true)
//Only return the numeric part of a string, including possibly a decimal and a negative sign.
{
	$bwlIsNegative=false;
	if($bwlAcceptNegative)
	{
		if(substr($strIn, 0, 1)=="-")
		{
			$bwlIsNegative=true;
		}
	}
	if($bwlAcceptDecimal)
	{
		$arrThis=explode(".", $strIn);
		$strIn=$arrThis[0];
		$strFrac="";
		if(count($arrThis)>1)
		{
			$strFrac=$arrThis[1];
			$strFrac=ClearRange($strFrac,48, 57);
		}
	}
	$strIn=ClearRange($strIn,48, 57);
	if($strFrac!="")
	{
		$strIn.="." . $strFrac;
	}
	if($bwlIsNegative)
	{
		$strIn="-" . $strIn;
	}
	return $strIn;
}

function ClearRange($strIn, $intLow, $intHigh)
//Only return characters between ASCII $intLow and $intHigh inclusive.
{
	$intLen=strlen($strIn);
	$strOut="";
	for ($i=0; $i<$intLen; $i++)
	{
		$chr=substr($strIn, $i, 1);
		$ord=ord($chr);
		if ($ord>$intLow-1 && $ord<$intHigh+1)
		{
			$strOut.=$chr;
		}
	}
	return $strOut;
}
	
function GenericTablePulldown($strDatabase, $strTable, $strIDField, $strNameField, $strQueryVariableName, $strDefault, $strPHP, $strFormName, $strConnector="", $bwlAcceptWild=true, $strFirstLabel="-none-", $strExtraSelectContent="", $strSQL="")
//From a table, generate a dropdown.
//$bwlAcceptWild allows it to add items at the bottom found in the wild but not in the config string
{
	$intTop=-1;
	$strOut="";
 	$sql=conDB();
	if($strConnector=="")
	{
		$strConnector="?";
 
		if(contains($strPHP, "?") || $_SERVER['QUERY_STRING']!="")
		{
			$strConnector="&";
		}
	}
	if($strSQL=="")
	{
		$strSQL="SELECT * FROM " . $strDatabase . "." . $strTable . " ORDER BY " . $strNameField . " ASC";
	}
	$records = $sql->query($strSQL);
	if (($strPHP!="") and ($strFormName!="")) 
	{
		$strOut="\n<select id=\"id" . $strQueryVariableName . "\" name=\"" . $strQueryVariableName . "\" onChange=\"window.document.location.href='" . $strPHP . $strConnector . $strQueryVariableName . "=' + document." . $strFormName . "." . $strQueryVariableName . "[document." . $strFormName . "." . $strQueryVariableName . ".selectedIndex].value\">\n";
}
	else
	{
		$strOut="\n<select id=\"id" . $strQueryVariableName . "\"  name=\"" . $strQueryVariableName . "\" " . $strExtraSelectContent . ">\n";
	}
	$strOut.= "<option value=\"\" >" . $strFirstLabel . "\n" ;
 	$bwlFoundOne=false;
	foreach ($records as $record)
	{
		$strSel="";
		$strThisIdentifier = $record[$strIDField];
		$strLabel=$record[$strNameField];;
 		
		if ($strLabel!="")
		{
		 
			if  ($strDefault.""==$strThisIdentifier."")
			{
				$strSel="selected=\"true\"";
				$bwlFoundOne=true;
			}
			$strOut.=  "<option value=\"" . $strThisIdentifier. "\" " . $strSel . ">" . $strLabel . "\n";
		}
	}
	if (!$bwlFoundOne  && $bwlAcceptWild  )
	{
		$strOut.=  "<option selected=\"true\" value=\"" . $strDefault. "\">" . $strDefault . "\n";
	}
	$strOut.= "</select>\n";
 
	return($strOut);
}

function passworddisplay($strIn)
//Obfuscates a password with "*" replacements.
{
	$count=strlen($strIn);
	if ($count>0)
	{
		$strOut= str_pad("*", $count, "*");
	}
	return $strOut;
}

function FieldDropdown($strDatabase, $strTable, $strFieldFormName, $strDefault)
//Creates a dropdown of column names for a table.
{
	$records=TableExplain($strDatabase, $strTable);
	$fields=  "<option value=\"\">none</option>";
	foreach ($records as $k => $info )
	{
		if ($info["Field"]== $strDefault)
		{
			$fields.=  "<option selected>";
		}
		else
		{
			$fields.=  "<option>";
		}
		$fields.=$info["Field"] . "</option>\n";
 	}
	$out="<select name=\"" .  $strFieldFormName . "\">\n" .$fields . "</select>" ;
	return $out;
}

function TableDropdown($strDatabase, $strDefaultTable, $strTableFormName, $strOurFormName='BForm', $strFieldFormName="")
//Produces a dropdown of tables in the DB.
//Contains the code to allow the selection of a table to immediately populate a dropdown list of fields
{
	$out="<select name=\"".   $strTableFormName . "\" ";
	if ($strFieldFormName!="")
	{
		$out.="onChange=\" field=document." . $strOurFormName . "." .  $strTableFormName . "[document." . $strOurFormName . "." .   $strTableFormName. ".selectedIndex].text; frames['ajax'].location.href='tf_field_dump.php?" . qpre . "db=" . $strDatabase . "&" . qpre . "formname=" . $strOurFormName . "&" . qpre . "table=' + field + '&" . qpre . "fieldformname=" .   $strFieldFormName ."'\";"; 
	}
	$out.=">\n";
	$out.="<option value=''>none</option>\n";
	$tables=ListTables($strDatabase);
	foreach ( $tables as $tablename )
	{
		$strSel="";
		if ($tablename==$strDefaultTable)
		{
			$strSel="selected";
		}
		$out.="<option " . $strSel . ">" . $tablename . "</option>\n";
	}
	$out.="</select>\n";
	return $out;
}


 
///////////////////////////////////////
/////////User functions///////////////
/////////////////////////////////////

function WhoIsLoggedIn()
{
	global $COOKIE_VARS;
	$x="";
	$a=GetLoginTableArray();
	//echo encryptionkey;
	$strCookieVal= subtractletters( $_COOKIE[$a["cookie"]], encryptionkey);
	//echo          $a["cookie"] . " " . $strCookieVal;
  
	if(beginswith(authtype, "code:"))
	{
		$code=substr(authtype, 5);
		$arrCode=explode("*",$code);
		$readcode=$arrCode[1];
		$strCookieVal="";
		//echo $readcode;
		eval('$strCookieVal=' . $readcode . ";");
		if(is_array($strCookieVal))
		{
			//echo $strCookieVall[0] . " " . $strCookieVal[1];
			$md5password=$strCookieVal[1];
			$strCookieVal=$strCookieVal[0];
			
			
			if(md5(GenericDBLookup(our_db, $a["table"], $a["username"], $strCookieVal,$a["password"],  false,  true))!=$md5password)
			{
				$strCookieVal="";
			}
		}
 		return($strCookieVal);
	}
	else if(authtype!="xcart"  || !defined("authtype"))
	{
		if ($strCookieVal!="")
		{
			return($strCookieVal);
		}
		
	}

	else
	{	
		
		//$sessid=$_COOKIE[cookie];
		$sessid=ExtricateXcartCookie();
		//echo "--" . $sessid;
		if(!TableExists(our_db, "xcart_sessions_data"))
		{
			echo "<div class='feedback'>You need to have an xcart_session_data table.</div>\n";
		}
		else
		{
			$strSQL="SELECT data FROM " . our_db .  ".xcart_sessions_data WHERE sessid='" .$sessid . "'";
			$sql=conDB();                   
			//echo    "55".   $sessid;                                    
			$rs=$sql->query($strSQL);
			$r=$rs[0];                        
			$data=$r["data"];  
			if ($data=="")
			{
				//because of how fucked up php cookies are, i do a second check here
				$sessid=$_COOKIE[$a["cookie"]];
				$strSQL="SELECT data FROM " . our_db .  ".xcart_sessions_data WHERE sessid='" .$sessid . "'";
	                    
			                            
				$rs=$sql->query($strSQL);
				$r=$rs[0];                        
				$data=$r["data"];
				//echo "no data:" . $data;
				if ($data=="")
				{
					//logout();
				}
				
			}
			$arr=unserialize($data);
		
			$outcount=0;
			
			$strUser= $arr["login"];
			if($strUser=="")
			{
				//echo "no user";
				logout();
			}
		}
		return $strUser;   
		                               
	}
}
                                                                                    

function GetLoginTableArray()
{
	$arrOut=array();
	//defaults
	$arrOut["table"]=tfpre . "admin";
	$arrOut["user_pk"]="admin_id";
	$arrOut["username"]="username";
	$arrOut["password"]="password";
	$arrOut["cookie"]="which";
	$arrOut["authtype"]="tablezilla";
	$arrOut["superuserindicationfield"]="is_superuser";
	$arrOut["superuserindicationvalue"]=1;
	$arrOut["superadminindicationfield"]="is_superadmin";
	$arrOut["superadminindicationvalue"]=1;
	//overwrite defaults as needed
	$arrOut["table"]= IfDefinedThenSet("authentication_table", $arrOut["table"]);
    $arrOut["user_pk"]= IfDefinedThenSet("user_pk", $arrOut["user_pk"]);
	$arrOut["username"]= IfDefinedThenSet("username", $arrOut["username"]);
	$arrOut["password"]= IfDefinedThenSet("password", $arrOut["password"]);
	$arrOut["cookie"]= IfDefinedThenSet("cookie", $arrOut["cookie"]);
	$arrOut["authtype"]= IfDefinedThenSet("authtype", $arrOut["authtype"]);
	$arrOut["superuserindicationfield"]=IfDefinedThenSet("superuserindicationfield", $arrOut["superuserindicationfield"]);
	$arrOut["superuserindicationvalue"]=IfDefinedThenSet("superuserindicationvalue", $arrOut["superuserindicationvalue"]);
	$arrOut["superadminindicationfield"]=IfDefinedThenSet("superuserindicationfield", $arrOut["superuserindicationfield"]);
	$arrOut["superadminindicationvalue"]=IfDefinedThenSet("superadminindicationvalue", $arrOut["superadminindicationvalue"]);
	return $arrOut;
}

function IfDefinedThenSet($name, $value)
{	
	$out=$value;
	if(defined($name))
	{
		$out=constant($name);  
	}
	return $out;
}

function IsLoginValid($strDatabase, $strUser, $strPassword)
{
	$a=GetLoginTableArray();
	$out=false;
	$sql=conDB();
	//use the function data to do a query 
 	$strSQL="SELECT " . $a["password"] . " from " . $strDatabase . "." . $a["table"] . " WHERE " . $a["username"] . " = '" . $strUser . "'";
	//echo $strSQL;
	$records = $sql->query($strSQL);
	//echo mysql_error();
	//echo "<P>---" .$record[$a["password"]];
	$record=$records[0];
	if($a["authtype"]=="xcart")         
	{
		if (xcartpwddecrypt($record[$a["password"]])==$strPassword and $strPassword!="")
		{
			$out=true;
		}	
	}
	else
	{
		if ($record[$a["password"]]==$strPassword && $strPassword!="")
		{
			$out=true;
		}
	}
	//$out=true;
	return($out);
}

function TestAndSetLogin($strDatabase, $strUser, $Password)
//If login is valid, set the cookie and dude is logged in.
{                                                   
	if (IsLoginValid($strDatabase, $strUser, $Password))
	{
		setLoggedIn($strUser);
		$out=$strUser;
	}
	else
	{
		$out="";
	}
	return($out);
}


function CreateTableFromSQLFile($strDatabase, $strTableName)
{
//installs a table package from a .sql file
	$url=$strTableName . ".sql";
	if(file_exists($url))
	{
		$handle=fopen ($url, "r"); 
		$content=fread($handle,filesize($url));
		$sql=conDB();
		//die("<script>alert(\'" . $content . "\')</script>");
		$sql->query($content, true, $strDatabase);
		$thiserror= sql_error();
		fclose($handle); 
	}
	if($thiserror)
	{
		die($thiserror);
	}
	return $thiserror;
}


function writecache($key, $content)
//Logs something in a file in the file system.
{
	$strRoot="cache";
	BuildPathPiecesAsNecessary( $strRoot);
 
	$url=$strRoot ."/" .  $key . ".txt";
	$handle=fopen ($url, "w"); 
	$content=fwrite($handle, $content);
	fclose($handle);   
}

function readcache($key)
//Logs something in a file in the file system.
{
	$content="";
	$strRoot="cache";
	BuildPathPiecesAsNecessary( $strRoot);
 
	$url=$strRoot . "/". $key . ".txt";
	if(file_exists($url))
	{
		$handle=fopen ($url, "r"); 
		$content=fread($handle,filesize($url) );
		fclose($handle); 
	}
	return $content;  
}

function logSomething($line, $log)
//Logs something in a file in the file system.
{
	$strRoot="log";
	if (!is_dir($strRoot))
	{
		mkdir($strRoot);
	}
	$url="log/" . $log . ".txt";
	$handle=fopen ($url, "a"); 
	$content=fwrite($handle, $line . chr(10));
	fclose($handle);   
}

function EnsureNonRemote()
{
	if(IsRefererTheSameAsHost())
	{
		return true;
	}
	else
	{
		die("Action from a remote site requested.  This is not permitted.");
	}
}

function IsRefererTheSameAsHost()
{
	$host=strtolower($_SERVER["HTTP_HOST"]);
	$referer=strtolower($_SERVER["HTTP_REFERER"]);
	if(beginswith($referer, "http://"))
	{
		$referer=substr($referer,7);
	}
	if(contains($referer, "/"))
	{	
		$arrReferer=explode("/", $referer);
		$referer=$arrReferer[0];
	}
	if($host == $referer)
	{
		return true;
	}
	return false;
}

function ExtricateXcartCookie()
//Just give me an Xcart cookie!
{
	$a=GetLoginTableArray();
	return $_COOKIE[$a["cookie"]];
	///////bleh!!!!!!!!!!!!
	$cookie=$_SERVER["HTTP_COOKIE"] ;//fucked up PHP bug!  see http://bugs.php.net/bug.php?id=32802
	$arr=explode(";", $cookie);
	for($i=0; $i<count($arr); $i++)
	{ 
		$ourpair=$arr[$i];
		$arrReturn=explode("=", $ourpair);
		$out=  trim($arrReturn[1]);
		if(trim($arrReturn[0])==cookie)
		{
			//echo $out . "<br>";
			return $out;
		}
		$i++;
	}
} 
 
function setLoggedIn($strUser)
//Sets user as logged in.  Also handles xcart-style logins.
{                            
 
	$a=GetLoginTableArray();
	if(beginswith(authtype, "code:"))
	{
		$password=GenericDBLookup(our_db, $a["table"], $a["username"], $strUser, $a["password"],  false,  true);
		$code=substr(authtype, 5);
		$arrCode=explode("*",$code);
		$writecode=$arrCode[0];
 		//echo $password . "<br>";
		//echo $writecode . "<br>";
		eval('$cookievalue=' . $writecode . ";");
		setcookie($a["cookie"], $cookievalue, time()+1131536000, "/" );
		//echo $cookievalue;
	}     
	else if(authtype!="xcart"  || !defined("authtype"))
	{
		if ( setcookie($a["cookie"], addletters($strUser, encryptionkey), time()+1131536000, "/" ))
		{
			//echo "cookie set!";
		}
	}
		
	else
	{
		$usertype= GenericDBLookup(our_db, $a["table"], $a["username"], $strUser,"usertype",  false,  true);
		$serializeduserinfo=strlen($strUser) . ':"' . $strUser ;
		
		if($usertype=="P")
		{
			$identifiers='a:3:{s:1:"P";a:2:{s:5:"login";s:';
			$identifiers.=$serializeduserinfo . '";s:10:"login_type";s:1:"' . $usertype . '";}s:1:"A";a:2:{s:5:"login";s:';
			$identifiers.=$serializeduserinfo . '";s:10:"login_type";s:1:"' . $usertype;
			$identifiers.='";}s:1:"C";a:2:{s:5:"login";s:';
			$identifiers.=$serializeduserinfo . '";s:10:"login_type";s:1:"' . $usertype;
			$identifiers.='";}}';
		}
		else
		{
			$identifiers='a:1:{s:1:"C";a:2:{s:5:"login";s:';
			$identifiers.=$serializeduserinfo . '";s:10:"login_type";s:1:"' . $usertype;
			$identifiers.='";}}';
		}
		$serialized='a:28:{s:11:"editor_mode";s:0:"";s:8:"is_robot";s:1:"N";s:5:"robot";s:0:"";s:11:"is_location";s:0:"";s:9:';
		$serialized.='"adaptives";a:11:{s:4:"isJS";s:1:"Y";s:5:"isDOM";s:1:"Y";s:8:"isStrict";s:1:"Y";s:6:"isJava";s:1:"Y";s:7:';
		$serialized.='"browser";s:7:"Firefox";s:7:"version";s:3:"2.0";s:8:"platform";s:5:"Win32";s:8:"isCookie";s:1:"Y";s:8:';
		$serialized.='"screen_x";s:4:"1600";s:8:"screen_y";s:4:"1200";s:14:"is_first_start";s:0:"";}s:22:"antibot_validation_val";';
		$serialized.='a:4:{s:13:"on_contact_us";a:2:{s:4:"code";s:5:"29968";s:4:"used";s:1:"N";}s:8:"on_login";a:2:{s:4:"code";s:5:';
		$serialized.='"11172";s:4:"used";s:1:"N";}s:10:"on_reviews";a:2:{s:4:"code";s:5:"71432";s:4:"used";s:1:"N";}s:20:';
		$serialized.='"on_news_subscription";a:2:{s:4:"code";s:5:"76652";s:4:"used";s:1:"N";}}s:5:"login";s:' . $serializeduserinfo;
		$serialized.='";s:10:"login_type";s:1:"A";s:6:"logged";s:0:"";s:13:"export_ranges";s:0:"";s:11:"top_message";s:0:"";s:7:';
		$serialized.='"old_lng";s:0:"";s:16:"current_language";s:2:"US";s:11:"identifiers";' . $identifiers . 's:17:"merchant_password";s:0:"";s:16:"file_upload_data";s:0:"";s:14:"remember_login";b:0;s:13:';
		$serialized.='"remember_data";s:0:"";s:8:"username";s:'  . $serializeduserinfo;
		$serialized.='";s:16:"login_antibot_on";b:0;s:11:"logout_user";b:0;s:19:"previous_login_date";s:10:"1194586303"';
		$serialized.=';s:13:"login_attempt";s:0:"";s:4:"cart";s:0:"";s:19:"intershipper_recalc";s:1:"Y";s:11:"antibot_err"';
		$serialized.=';b:0;s:7:"bf_mode";s:0:"";s:21:"hide_security_warning";s:0:"";}';	
		
		

		$sessid=$_COOKIE[$a["cookie"]];
		if($sessid!="")//we have a current acceptable session happening
		{
			//giving a session length of a little under two weeks
			UpdateOrInsert(our_db, "xcart_sessions_data", "", Array("sessid"=> $sessid, "data"=>$serialized, "start"=>time(), "expiry"=>time()+ 300000), true,false);
		
		}
		else
		{
			$sessid = md5(uniqid(rand()));
			UpdateOrInsert(our_db, "xcart_sessions_data", "", Array("sessid"=> $sessid, "data"=>$serialized ), true,false);
			if(!setcookie($a["cookie"], $sessid, time()+90000))
			{
				echo "Cookie set failure!";
			}
		}
	}
}

function logout()
//Logs out TF user
{
	global $COOKIE_VARS;
	$a=GetLoginTableArray();
	//echo "#";
 	//global $COOKIE_VARS;
	if(authtype!="xcart"  || !defined("authtype"))
	{
		if (setcookie($a["cookie"], "x", mktime(12,0,0,1, 1, 1990), "/" ))
		{
			//echo "cookie cleared!";
		}
	}
	else
	{       
		$sessid=ExtricateXcartCookie();//fucked up PHP bug!  see http://bugs.php.net/bug.php?id=32802                        
		$strSQL="DELETE FROM " . our_db .  ".xcart_sessions_data WHERE sessid='" .$sessid . "'";
		$sql=conDB();
		
		if(CanChange())
		{
			$records = $sql->query($strSQL);
		}
		else
		{
			$errors.=  "Database is read-only.<br/>";
		}
	}
}

function loginarrest($strPHP)
//Throws up a login form if the user is not logged in.
{
	$a=GetLoginTableArray();
	$strUserNameFormItem= qpre . $a["username"];
	$strPasswordFormItem=qpre .  $a["password"];
	 
	$out.="<form target=\"_top\" action=\"" . $strPHP . "\" method=\"POST\">\n";
	$out.="\n";
	$out.="<tr><td colspan=\"2\" class=\"loginLogo\" ></td></tr>";
	$out.="<tr><td colspan=\"2\"><h2>Log in Here:</h2></tr>\n";
	$out.="<tr><td>\n";
	$out.="Username:</td><td><input type=\"text\" name=\"" . $strUserNameFormItem . "\" value=\"\"></td></tr>\n";
	$out.="<tr><td>\n";
	$out.="Password:</td><td><input type=\"password\" name=\"" . $strPasswordFormItem . "\" value=\"\"></td></tr>\n";
	$out.="<tr><td colspan=\"2\" align=\"right\"><input type=\"Submit\" value=\"Login\"></td></tr>\n";
	$strAvoidList=$strUserNameFormItem . " " . $strPasswordFormItem;
	if ($_REQUEST[qpre . "mode"]=="logout")
	{
		$strAvoidList.= " " .  qpre .   "mode";
		$out.=HiddenInputs(Array( qpre .   "mode"=>""), "", "");
	}
	//echo  $strAvoidList;
	$out.=HiddenInputs($_REQUEST, "", $strAvoidList);
	$out.="</form>\n";
	$out=  TableEncapsulate($out, false, "", "idloginTable", 1, 2, 0, "loginTable");
	return $out;
}

function LoginDecisions($strDatabase,  $strPHP,  &$strUser, $bwlSimpleOutput=false, $strConfigBehave="")
//Saves me many lines of code at the top of a page.
//Returns $strUser as a "by reference" variable
{
	$a=GetLoginTableArray();
	$strUser=$_REQUEST[qpre . $a["username"]];
	$Password=$_REQUEST[qpre . $a["password"]];
	$skiplogintest=false;
	$out="";
	if ($_REQUEST[ qpre . "mode"]=="logout")
	{
		logout();
		$out="<div class=\"loginstring\">You have been logged out.</div>";
		$skiplogintest=true;
	}
	$bwlSavedSimpleOutput=$bwlSimpleOutput;
	if (countrecords($strDatabase ,$a["table"])<1)
	{
		$strUser="-no security-";
		$skiplogintest=true;
		$bwlSimpleOutput=true;
	}
	elseif ($strUser!="" && $Password!="")
	{
		//logform();
		//echo $Password;
		$strUser=TestAndSetLogin($strDatabase, $strUser, $Password);
		if ($strUser=="")
		{
			$out="<div class=\"feedback\">The Username/Password combination you typed has failed.</div>";
		}
		else 
		{
			$skiplogintest=true;
		}
	}
 	if (!$skiplogintest)
	{
		$strUser=WhoIsLoggedIn();
	}	
	$bwlSuperAdmin=IsSuperAdmin($strDatabase, $strUser);
	if (!$bwlSimpleOutput )
	{
		if ($strUser!="")
		{
			
			$strPHP = replaceMultipleQueryVariables(qpre .$a["username"], "", qpre .$a["password"],  "", qpre ."mode", "logout");
			$out="<div class=\"loginstring\">You are currently logged in as <b>" . $strUser . "</b>.  (<a href=\"" . $strPHP  . "\">Logout</a>)</div>\n";
			
		}
		if ($strUser=="" )
		{
			$out.=loginarrest($strPHP);
		}
	}
	elseif ($strUser=="")
	{
 
			$out="You do not have permissions to see this content.";
	}
	if(!$bwlSavedSimpleOutput)
	{
		if(!contains($strConfigBehave, "notopnav"))
		{
 			$out.= AdminNav($bwlSuperAdmin, $bwlSimpleOutput);
		}
	}
	return $out;
}

function IsSuperuser($strDatabase, $strAdmin)
//Is this TF user a super user?  This is powerful and allows all activities, but certain admin tasks are kept hidden.
{
	$a=GetLoginTableArray();
	//echo "-" . $a["table"];
	if (TableExists($strDatabase, tfpre . "permission") || TableExists($strDatabase, $a["table"])  || superuserexplicit) //if no admin tables, everyone is an admin!
	{
		

		$sql=conDB();
		
		$strSQL="SELECT  * from  " . $strDatabase . "." . $a["table"] . " WHERE " . $a["username"] . " = '" .   singlequoteescape($strAdmin) . "'";
	 	//echo $strSQL;
		$records = $sql->query($strSQL);
		
		if (count($records)>0)
		{
			$record=$records[0];
		 
		 	$out=false;
			
			if ($record[$a["superuserindicationfield"]]==$a["superuserindicationvalue"])
			{
				$out=true;
			}
		}
		else
		{
			$out=true;
		}
		
	}
	else if(authtype!="xcart")
	{
 	
		$out=true;	
 
	}
	
	$out=$out || IsSuperAdmin($strDatabase, $strAdmin);
	//echo "-" . $out . "-";
	return $out;
}

function IsSuperAdmin($strDatabase, $strAdmin)
//Is this TF user a super admin?  This is the highest level of power in the system.
{
	$a=GetLoginTableArray();
	$sql=conDB();
	if(TableExists($strDatabase, $a["table"]))
	{
		$strSQL="SELECT  * from  " . $strDatabase . "." . $a["table"] . " WHERE " . $a["superadminindicationfield"] . " = '" . $a["superadminindicationvalue"] . "'";
		$records = $sql->query($strSQL);
		if (count($records)>0  && (authtype!="xcart"  || !defined("authtype")))  //if there are no superadmins then everyone is a superadmin!
		{
			
			$strSQL="SELECT  " . $a["superadminindicationfield"] . " from  " . $strDatabase . "." . $a["table"] . " WHERE " . $a["username"]. " = '" . singlequoteescape($strAdmin) . "'";
			//echo $strSQL;
			$records = $sql->query($strSQL);
			$record=$records[0];
		 
		 	$out=false;
			
			
			if ($record[$a["superadminindicationfield"]]==$a["superadminindicationvalue"])
			{
				$out=true;
			}
		}
		else if(authtype=="xcart")
		{
			$strSQL="SELECT   usertype from  " . $strDatabase . "." . $a["table"] . " WHERE usertype='P' AND " . $a["username"]. " = '" . singlequoteescape($strAdmin) . "'";
			$records = $sql->query($strSQL);
			if(count($records)>0)
			{
				$out=true;
			}
			else
			{
				$out=false;
			}
		}
		else
		{
			$out=true;
		}
	}
	else
	{
		$out=true;
	}
 
	return $out;
}

function AdminIDRangePermCalc($rangelow, $rangehigh, $thisid)
//If ranges of IDs are set up in the tf_permission table, then this calculates whether a user can access a certain row.
{
	$bwlOut=false;
	
	if ($thisid!="")
	{
		if (($rangelow<= $thisid  || $rangelow=="") && ($rangehigh>=$thisid || $rangehigh==""))
		{
			$bwlOut=true;
		}
	}
	{
		$bwlOut=true;
	}
	return $bwlOut;
}

function LogAdminScriptIfNovel($strDatabase, $strThisScript, $strPostRunScript, $type)
{
	$sql=conDB();
	$strTable="scriptlog";
	$strThisScript=trim(deMultiple($strThisScript, " "));
	$strPostRunScript=trim(deMultiple($strPostRunScript, " "));
	MakeTableIfNotThere($strDatabase, tfpre . $strTable, "MakeScriptLogTable");
	$strExistScript="SELECT pre_script, post_script FROM " . $strDatabase . "." . tfpre . $strTable . " WHERE type='" . $type . "' ORDER BY " . $strTable ."_id DESC LIMIT 0,1";
	$exist =  $sql->query($strExistScript);
	$exist=$exist[0];
	//echo $exist["pre_script"] . "=\<p>" . $strThisScript. "=/<p>" ;
	//echo $exist["post_script"] . "=<p>" . $strPostRunScript. "=<p>" ;
	if($strThisScript!="")
	{
		if(  $exist["pre_script"]!=$strThisScript || $exist["post_script"]!=$strPostRunScript)
		{
			// str_replace("'", "\\'", $strSQL)  //maybe need this sometimes
			$strLogScript="INSERT INTO " . $strDatabase . "." . tfpre .  $strTable . "(pre_script, post_script, type, time_executed) VALUES('" . addslashes($strThisScript) . "','" . addslashes($strPostRunScript) . "','" . $type . "','" . date("Y-m-d H:i:s") . "')";	
			//echo $strLogScript. "<P>";
			$recs =  $sql->query($strLogScript);	
			if (sql_error())
			{
				dropTable($strDatabase, tfpre .  $strTable);
			}
		}
	}

}
		
function UserIDToSelectAddendum($strDatabase, $strTable, $pk, $UserID)
//Creates the SQL phrase added to the select in cases where 
{
	if ($UserID!="")
	{
		if ($pk=="")
		{
			 $pk=PKLookup($strDatabase, $strTable);
		}
		$sql=conDB();
		$strSQL="SELECT id_range_lowend, id_range_highend FROM " . $strDatabase . "." . tfpre . "permission WHERE admin_id = " . singlequoteescape($UserID) . " AND  table_name='" . $strTable . "'";
		//echo $strSQL;
		$rs = $sql->query($strSQL);
		$r=$rs[0];
		$lowpart="";
		$highpart="";
		if ($r["id_range_lowend"]!=""  )
		{
			$lowpart=$pk . ">=" . $r["id_range_lowend"];
		}
		if ($r["id_range_highend"]!="")
		{
		 	$highpart= $pk . "<=" . $r["id_range_highend"];
		}
		$out=$lowpart . IfAThenB($highpart," AND ") . $highpart;
	}
	return $out;
}


function AdministerType($strDatabase, $strTable, $strAdmin, $id="")
//Returns an integer determining what a TF user is allowed to do.
//2 is lots of power, 0 is none.  1 means read but no write.
{
	$a=GetLoginTableArray();
	$sql=conDB();
	$strSQL="SELECT permission_type_id as 'p', id_range_lowend, id_range_highend FROM  " . $strDatabase . "." . tfpre . "permission p LEFT JOIN " . $strDatabase . "." . tfpre . "admin a ON p.admin_id=a.admin_id WHERE a.username = '" . singlequoteescape($strAdmin) . "' AND p.table_name='" . $strTable . "'";
	$bwlSuperAdmin=IsSuperAdmin($strDatabase, $strAdmin);
	$bwlSuperUser=IsSuperuser($strDatabase, $strAdmin) || $bwlSuperAdmin;
	
	if (TableExists($strDatabase, tfpre . "permission") && TableExists($strDatabase, $a["table"]) )
	{
		$rs = $sql->query($strSQL);
		//echo count($rs);
		$r=$rs[0];
		if ( AdminIDRangePermCalc($r["id_range_lowend"], $r["id_range_highend"], $id))
		{
			$out= $r["p"];
		}
		if ($bwlSuperUser)
		{
			$out=2;
		}
	}
	else
	{
		if(authtype!="xcart"  || !defined("authtype"))
		{
			$out=2; 
		}
		else
		{
			if($bwlSuperUser)
			{
				$out=2; 
			}
			else
			{
				$out=0; 
			}
		}
	}
	if(inList(superadmintables, $strTable)  )
	{
		if($bwlSuperAdmin)
		{
			$out=2;
		}
		else
		{
			$out=0;
		}
	}
	if(inList(superusertables, $strTable) )
	{
	
		if($bwlSuperUser)
		{
			$out=2;
		}
		else
		{
			$out=0;
		}
	}
	return $out;
}

function GetAdminID($strDatabase, $strAdmin)
//Given the name of an TF user, return the user_id.  Could look in different tables depending on how
//authentication is configured in constants.php.
{
	$a=GetLoginTableArray();
	$sql=conDB();
	$strSQL="SELECT " .$a["user_pk"] . " FROM  " . $strDatabase . "." . $a["table"] . "  WHERE " . $a["username"]. " = '" . singlequoteescape($strAdmin) . "'";
	$records = $sql->query($strSQL);
	$record=$records[0];
	$out= $record[$a["user_pk"]];
	return $out;
}

//////////////////////////////////////////
//IMAGE AND FILE FUNCTIONS///////////////
////////////////////////////////////////

function isImageFileName($strName)
//Looking at the file name, is this an image file?
{
	$strTestPath=strtolower($strName);
	if (strpos($strTestPath, ".png")>1  || strpos($strTestPath, ".jpg")>1  || strpos($strTestPath, ".gif")>1 || strpos($strTestPath, ".swf")>1)
	{
		return true;
	}
	else
	{
		return false;
	}
}

function fieldNameToFolderPath($strIn, $strRoot)
//This is totally a hack function that does a good job in this particular application
//of determining the proper upload path based only on the field name
//path names from here always end with "/";
{
	$arrName=explode("_", $strIn);
	$strPossibleFolder=$arrName[0];
	//echo $strPossibleFolder . "&<br>";
	//echo $strPossibleFolder . "<br>";
	//if ($strPossibleFolder!="flash")
	//{
	$path= $strRoot . "/" . forcePlural($strPossibleFolder) . "/";
	//}
	//else
	//{
		////in this site, swfs are just loose in the top level
		//$path= "";
	//}
	return $path;
}

function FileBrowser($strPath, $strExtensionMatch, $strPHP, $strVar=  "file")
//Judas Gutenberg Dec 1 2008
{
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$preout.= "<script src=\"tf_tablesort.js\"><!-- --></script>";
	
	if (is_dir($strPath))
	{
		$dh  = opendir($strPath);
		while (false !== ($filename = readdir($dh))) 
		{
		  		$files[] = $filename;
		}
		rsort($files);
		$out=htmlrow("bgclassline", "<a href=\"javascript: SortTable('idsorttable99', 0)\">SQL File</a>", "<a href=\"javascript: SortTable('idsorttable99', 1)\">last edited</a>", "<a href=\"javascript: SortTable('idsorttable99', 2)\">size</a>" );
		if(contains($strPHP, "?"))
		{
			$strThisPHP = $strPHP . "&";
		}
		else
		{
			$strThisPHP = $strPHP . "?";
		}
		foreach ($files as $file)
		{
			list($name, $extension )= split("\.", $file);
			if(inList($strExtensionMatch, $extension))
			{
				$timestamp=date("Y-m-d H:i:s",filemtime($strPath . "/" . $file));
				$filesize=filesize($strPath . "/" . $file);
				$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
				$out.=htmlrow($strThisBgClass,  "<a href=\"" . $strThisPHP . $strVar . "=" . $file . "\">" . $file . "</a>", $timestamp,   $filesize);
				
			}
		}
	}
	$out=$preout . TableEncapsulate($out,  true, "", "idsorttable99");
	return $out;
}

function URLexists($url)
{
	$url = str_replace("http://", "", $url);
	if (strstr($url, "/")) 
	{
		$url = explode("/", $url, 2);
		$url[1] = "/".$url[1];
	} 
	else 
	{
		$url = array($url, "/");
	}

	$fh = fsockopen($url[0], 80);
	if ($fh) 
	{
		fputs($fh,"GET ".$url[1]." HTTP/1.1\nHost:".$url[0]."\n\n");
		if (fread($fh, 22) == "HTTP/1.1 404 Not Found") 
		{ 
			return FALSE; 
		}
		else 
		{ 
			return TRUE;    
		}

	} 
	else 
	{ 
		return FALSE;
	}
 }
 
function tf_file_exists($strPath)
{
	if (file_exists($strPath)  || file_exists($_SERVER["DOCUMENT_ROOT"]. $path))
	{
		return true;
	}
	return false;
}
 
function PictureIfThere($strPath, $intWidth, $intHeight="", $border=" ", $url="")
//If there is a picture at $strPath this will generate the HTML to display it.
{
	//GLOBAL $vertoffsetvalue; //i want to KILL Bill Gates!!!!!!!
	//if($vertoffsetvalue=="")
	//{
	//	$vertoffsetvalue=0;
	//}
	//hacky, do deal with tf_dirs that begin with /
	
	if(beginswith($strPath, "/")  && $testroot!='')
	{
		$testroot=deMultiple(  "/". tf_dir, "/");
		//echo $strPath, "*" . $testroot . "<br>";
		if(beginswith($strPath, $testroot) )
		{
			$pod=PointOfDissimilarity($testroot, $strPath);
			{
				$strPath=substr($strPath, $pod);
			}
				 
		}
		else
		{
			
			$strPath=substr(deMultiple($strPath, "/"), 1);
		}
	}
	$strTestPath=strtolower($strPath);
	//echo tf_file_exists($path) . " " .  $strTestPath. " " . $path . "<p>";
	if (tf_file_exists($path))
	{
		if (isImageFileName($strPath))
		{

			if ($border!=" ")
			{
				$border=" border=\"" . $border . "\"";
			}
			if (strpos($strTestPath, ".swf")>1)
			{
				if ($intHeight==""  && $intWidth!="") 
				{
					$intHeight= $intWidth * .5;
				}
				$out.= flash("cccc99",$intWidth, $intHeight, $strPath, $url) ;
			}
			else
			{
				if ($intHeight!="")
				{
					$intHeight=" height=\"" . $intHeight . "\"";
				}
				$stupidiestylehack="";
				//if(isset($_SERVER['HTTP_USER_AGENT']) && preg_match("/MSIE/", $_SERVER['HTTP_USER_AGENT']))
				//{
				//	$stupidiestylehack="style=\"position:relative;top:" . -($height + $vertoffsetvalue) . "px\"";
					//$vertoffsetvalue+=$intHeight;
				//}
				$out.=  "<img " . $stupidiestylehack ." src=\"" . $strPath  ."\" " . IFAThenB($intWidth, "width=\"" . $intWidth . "\"") ." " .   $intHeight . " border=\"0\">";
			}
		}
	}
	//echo $out . "<P>";
	return $out;
}

function flash($bgcolor,$width, $height, $swffile, $url="")
//Display a Flash object embed for both IE and Mozilla
{
	//GLOBAL $vertoffsetvalue; //i want to KILL Bill Gates!!!!!!!
	//if($vertoffsetvalue=="")
	//{
		//$vertoffsetvalue=0;
	//}
	//echo $width . "-------&&&&&&&------" . $height;
	$canflash=true;
	$out="";
	$stylefornext="style=\"z-index:0;\"";
	if ($canflash==true)
	{
		//if(isset($_SERVER['HTTP_USER_AGENT']) && preg_match("/MSIE/", $_SERVER['HTTP_USER_AGENT']))
		//{
			 
			//if($url!="")
			//{
			


				//$out= "<div style=\"width:" . $width ."px;" . ($height + $vertoffsetvalue) .":0px;z-index:0;position:relative;top:" . -$height . "px;left:0px\" id=\"adlayer\"><a href=\"" . $url . "\">" . SpacerGif($width, $height) . "</a></div>";
				//$stylefornext="style=\"float:left;width:0px;height:0px;z-index:4;position:relative;top:" . -($height + $vertoffsetvalue) . "px;left:0px\"";
			//}
			//$vertoffsetvalue+=$height;
		//}
		//if($url!="")
		//{
			//$out.="<span " . $stylefornext . " onclick=\"window.location.href='" . $url . "'\" >";
		//}
		$out.="<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\"\n";
		$out.="codebase=\"http://active.macromedia.com/flash2/cabs/swflash.cab#version=4,0,0,0\"\n";
		$out.= "ID=\"logo\"  width=\"".$width."\" height=\"".$height."\">\n";
		$out.="<param  name=\"movie\" VALUE=\"" . $swffile ."\"><param  name=\"wmode\" VALUE=\"transparent\"> <param name=\"quality\" value=\"high\">\n";
		$out.="<param name=\"bgcolor\" VALUE=\"".$bgcolor."\">";
		$out.="<embed wmode=\"transparent\" src=\"". $swffile . "\" quality=\"high\"\n";
		$out.= "bgcolor=\"".$bgcolor."\"  WIDTH=\"".$width."\" HEIGHT=\"".$height."\" TYPE=\"application/x-shockwave-flash\"\n";
		$out.= " PLUGINSPAGE=\"http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_\"" .chr(13);
		$out.= "Version=\"ShockwaveFlash\"></embed>";
		$out.= "</object>";
		if ($url!="")
		{
			$out.="</span>\n";
		}
	}
	else
	{
		$out="Can't load flash." . chr(13);
	}
	return($out);
}

function SpacerGif($width, $height)
//Returns a spacer gif of any size, assuming a blank transparent spacer.gif exists in the image directory
{
	$out="<img src=\"".tf_dir . imagepath . "/spacer.gif\" width=\"" . $width . "\" height=\"" . $height . "\" border=\"0\">";
	return $out;
}

function NeedsUpload($strFieldName)
//Looks at a field and determines whether or not it should get an upload file form item based only on its name.
//This is a little primitive but it's legacy at this point.
{
	$strTextIndications="filename banner";
 	$arrIndic=explode(" ", $strTextIndications);
	for ($i=0; $i<count($arrIndic); $i++)
	{
		if (contains($strFieldName, $arrIndic[$i]))
		{
			return true;
		}
	}
	return false;
}

function ScanToInclude($testfunction, $includefilename)
{
//pass in a test function and the name of an include.  if the function can't be found, will climb directory as high as four levels looking for that include
//Judas Gutenberg, March 10th 2009
	$bwlDone=false;
	$count=0;
	$strThisPath=$includefilename;
	if(!function_exists($testfunction))
	{
		while(!$bwlDone  && $count<4)
		{
		 	$strThisPath="../" . $strThisPath;
		 	if(file_exists($strThisPath))
			{
		 		include($strThisPath);
				$bwlDone=true;
			}
			$count++;
		}
	}
}

function BuildPathPiecesAsNecessary($strPath)
//This function has ancient origins in ASP when I needed to be able to save stuff
//at arbitrary depth in a file system without worrying about whether the directory 
//structure actually existed.
//This builds all the directories down to a location in a directory tree as needed
//should they happen not to exist.
{
	if(beginswith($strPath, "/"))
	{
		//hacky hacky hack hack, thanks a lot php!
		$strPath=$_SERVER["DOCUMENT_ROOT"]. $strPath;
	}
	//echo $strPath . "==<br>";
	$strPath = str_replace( "\\", "/", $strPath);
	$strPath= deMultiple($strPath, "/");
	$arrPath=explode("/", $strPath);
	$strPathOut="";
	$out=true;
	for ($i=0; $i<count($arrPath); $i++)
	{
		if ($i==0)
		{
			//dont use a beginning slash unless our string begins with one
			$strPathOut.=$arrPath[$i];
		}
		else
		{
			$strPathOut.="/" . $arrPath[$i];
		}
		//echo $strPathOut .  "--" . file_exists($strPathOut) . "==<br>";
		if (!file_exists($strPathOut))
		{
			if ($strPathOut!="")
			{
				if (!contains($arrPath[$i], "."))
				{
				//don't add a file or folder if this item contains a "."
					
					if (!mkdir($strPathOut, 0777))
						{
							$out=false;
						}
				}
			}
		}
	}
	return $out;
}


//////////////////////////////////////////////
/////xml functions //////////////////////////
////////////////////////////////////////////

function parseXMLNodeContent($strIn, $nodename, $bwlStripOutCDATA=true)
//Returns the content of an XML node.
{
	$out=parseBetween($strIn, "<" . $nodename . ">",  "</" . $nodename . ">" );
	if($bwlStripOutCDATA)
	{
		$strRemoveStart="<![CDATA[";
		$strRemoveEnd="]]>";
		if(contains($out, $strRemoveStart))
		{
			$out=parseBetween($out,$strRemoveStart, $strRemoveEnd );
		
		}
	}
	return $out;
}

function XMLselect($strDatabase, $strTable, $strWhereClause, $bwlWrapTopLevel=true)
//Does a select call to the db and returns XML-wrapped data, naming entities using their names from the DB
//Cannot handle joins!
{
	$sql=conDB();
	$arrParameter=array();
	$out="";
	$arrFieldType=generateFieldTypeArray($strDatabase, $strTable);
	$strSQL="SELECT * FROM " . $strDatabase . "." . $strTable  ;
	if ( $strWhereClause!="")
	{
		$strSQL.=" WHERE " . $strWhereClause;
	}
	$rs = $sql->query($strSQL);

 	//echo count($rs);
	for($i=0; $i<count($rs); $i++)
	{
		$arrRS=$rs[$i];
		$out.=XMLDBitem($strTable, $arrRS, $arrFieldType);
	}
	if ($bwlWrapTopLevel)
	{
		$out=makeXMLNode(forcePlural($strTable), "", $out) . "\n";
	}
	return $out;
}

function XMLDBitem($strTable, $arrRS, $arrFieldType, $strAdditionalSubContent="")
//Returns a single XML-wrapped row of data, wrapping columns of type TEXT in their own sub-tags
//$arrRS is an associative array of the data from a single row 
//$arrFieldType is an associative array with the columns' names as keys and their types as values
{
	$strSubContent="";
	foreach ($arrRS as $key => $value )
	{
		
		$strpreparedcontent=doublequoteescape($value);
		if ($quotecontent)
		{
			$strpreparedcontent='"' . $strpreparedcontent . '"';
		}
		if ($arrFieldType[$key]=="text")
		{
			 //$strSubContent.=makeXMLNode($key, "", "<![CDATA[" . $value . "]]>") . "\n";
			 $strSubContent.=makeXMLNode($key, "",  $value) . "\n";
		}
		else
		{
			$arrParameter[$key]=$strpreparedcontent;
		}
	}
	$strSubContent = $strSubContent . "\n" . $strAdditionalSubContent;
	$out=makeXMLNode($strTable, $arrParameter, $strSubContent) . "\n";
	return $out;
}

function makeXMLNode($name, $arrParameters, $content, $bwlSuppresCR=false)
//Give an XML nide name, an associative array of parameters, and some content, make an XML node
{
	$out="<" . $name;
	if (is_array($arrParameters))
	{
		foreach($arrParameters as $k=>$v)
		{
			if ($v!="")
			{
				$out.=" " . $k . "=\"" . deescape(htmlcodify(fixAmp($v))) . "\"";
			}
		}
	}
	if ($content=="")
	{
		$out.="/>";
	}
	else
	{
		$out.=">";
		if (!$bwlSuppresCR)
		{
			$out.="\n";
		}
		if (!$bwlSuppresCR)
		{
			$out.="\t";
		}
		$out.= fixUnbalancedTags(deescape(fixAmp($content)));
		if (!$bwlSuppresCR)
		{
			$out.="\n";
		}
		$out.="</" . $name . ">";
		if (!$bwlSuppresCR)
		{
			$out.="\n";
		}
	}
	return $out;
}

function RemoveBalancedEndCharacters($strIn, $strBal)
{
	$strOut=$strIn;
	if(substr($strIn, 0, strlen($strBal))== $strBal)
	{
		if(substr($strIn, strlen($strIn)-strlen($strBal), strlen($strBal))== $strBal)
		{
			$strOut=substr($strIn, strlen($strBal));
			$strOut=substr($strOut,0,strlen($strOut)-strlen($strBal));
		}
	
	}
	return $strOut;

}


function fixUnbalancedTags($strIn)
//Fixes only the worst offenders
//obviously this doesn't do anything systematic
//some day perhaps...
{
	$strIn=str_replace("<br>", "<br/>", $strIn);
	$strIn=str_replace("<BR>", "<br/>", $strIn);
	return $strIn;
}	

function fixAmp($strIn)
//Handles & in XML - probably needs improvement
{
	$strIn=str_replace("& ", "&amp; ", $strIn);
 	//fix at
	$strIn=str_replace("@", "&#64;", $strIn);
	return $strIn;
}	

function decode_entities($text) 
//I got this from somewhere -- PHP.net probably
//a more robust version of the PHP function to convert all HTML entities to their applicable characters
{
   $text= html_entity_decode($text,ENT_QUOTES,"ISO-8859-1"); #NOTE: UTF-8 does not work!
   $text= preg_replace('/&#(\d+);/me',"chr(\\1)",$text); #decimal notation
   $text= preg_replace('/&#x([a-f0-9]+);/mei',"chr(0x\\1)",$text);  #hex notation
   return $text;
}

////////////////////////////////////////////////////////
////more db functions -- mostly admin ones/////////////
//////////////////////////////////////////////////////

function emptyTable($strDatabase, $strTable)
{
//clears all data from a table
	$sql=conDB();
	$out="";
	//echo $strTable . " " . contains($strTable, "g") ;
	if(CanChange())
	{
		if (contains($strTable, " "))//handle multiple empty - dangerous!
		{
			$arrTable=explode(" ", $strTable);
			foreach ($arrTable as $strTable)
			{
				$strSQL= "TRUNCATE TABLE " . $strDatabase . "." . $strTable;
				$tables = $sql->query($strSQL);
				$out.=  "All data in " . $strTable . " has been removed.<br/>";
			
			}
		}
		else
		{
			$strSQL= "TRUNCATE TABLE " . $strDatabase . "." . $strTable;
			$tables = $sql->query($strSQL);
			$out =  "All data in " . $strTable . " has been removed.";
		}
	}
	else
	{
		$out =  "Database is read-only<br/>.";
	}
	return $out;
}

function dropTable($strDatabase, $strTable)
//Removes a table completely from the db.
{
	$sql=conDB();
	if(CanChange())
	{
		$strSQL= "DROP TABLE " . $strDatabase . "." . $strTable;
		$tables = $sql->query($strSQL);
		$out =  $strTable . " has been dropped.";
	}
	else
	{
		$out =  "Database is read-only<br/>.";
	}
	return $out;
}

function rowdelete($strDatabase, $strTable,  $idfield, $id, $strUser="always allow deletes", $arrPK="")
//Deletes a row of data from $strTable in $strDatabase matching $idfield=$id
{
 	$out="";
	$bwlSuperUser=IsSuperUser($strDatabase, $strUser)  || $strUser=="always allow deletes"; //total jihack!
	$bwlBeginsWithTF=beginswith($strTable,  tfpre );
	if (($bwlBeginsWithTF &&  $bwlSuperUser) || !$bwlBeginsWithTF)
	{
		$sql=conDB();
		if(is_array( $arrPK))
		{
			$strSQL="DELETE FROM " . $strDatabase . "." . $strTable . " WHERE " . ArrayToWhereClause($arrPK);
			//echo $strSQL;

			if(CanChange())
			{
				$records = $sql->query($strSQL);
				$out= "A row was deleted from the " . $strTable . " table in the " . $strDatabase . " database whose " .  $idfield . " was equal to " . $id;
			}
			else
			{
				$out.=  "Database is read-only.<br/>";
			} 
		}
		else
		{
			$strSQL="DELETE FROM " . $strDatabase . "." . $strTable . " WHERE " .  $idfield . " = '" . singlequoteescape($id) . "'";
			//echo $strSQL;
			if(CanChange())
			{
				$records = $sql->query($strSQL);
				$out= "A row was deleted from the " . $strTable . " table in the " . $strDatabase . " database whose " .  $idfield . " was equal to " . $id;
			}
			else
			{
				$out.=  "Database is read-only.<br/>";
			}
		}
		//echo sql_error();
		
	}
	else
	{
		$out= "You do not have permission to delete from this table.";
	}
	return $out;
}

function IsExtraSecure()
//a function that tests whether a user _SERVER info for a particular item (such as IP address) is present in an table used to provide extra security.
{
	if(defined("extra_security"))
	{
		if(contains(extra_security, "|"))
		{
			$sql=conDB();
			$arrES=explode("|", extra_security);
			$strSecurityTable=$arrES[0];
			$strSecurityField=$arrES[1];
			$strSecurityTest=$_SERVER[$arrES[2]];
			//echo our_db . "!" . $strSecurityTable . "@" . $strSecurityField .  "$" . $strSecurityTest . "%" . $strSecurityField . "<br>";
			$strSQL="SELECT " . $strSecurityField . " FROM " . our_db . "." . 	$strSecurityTable;
			$records = $sql->query($strSQL);
			foreach($records as $record)
			{
				if(beginswith($strSecurityTest, $record[$strSecurityField]))
				{
					//echo $strSecurityTest . " " .  $record[$strSecurityField] . "<br>";
					return true;
				}
			}
			return false;
			
		}
	}
	return true;
}

function ExtraSecureFailure()
{
	return "You lack credentials to access this page.";
}



//experimental functions//////////

function RemoteSQLCall($url, $strSQL, $pwd)
//makes a call to a remote database via HTTP
//the server-side of this connection must have have the file remotequery.php on its side to do the queries and provide
//the info in ^| double-delimited fashion
//the pwd is to keep these connections somewhat secure so as to limit the queries made by people
//aware of this system
{
	$content= file_get_contents($url . "?pwd=" . urlencode($pwd)   . "&sql=" . urlencode($strSQL) );
	//echo $content;
 	$strFieldDelimiter="|";
	$strRowDelimiter="^";
	$arrOut=Array();
	$arrThis=Array();
	$arrContent=explode($strRowDelimiter, $content);
	$arrFieldNames=explode($strFieldDelimiter, $arrContent[0]);
	for($i=1; $i<count($arrContent)-1; $i++)
	{
		$arrThisContent=explode($strFieldDelimiter, $arrContent[$i]);
		$j=0;
		foreach($arrFieldNames as $field)
		{
			$arrThis[$field] = $arrThisContent[$j];
			$j++;
		}
		$arrOut[$i-1]=$arrThis;
	}
	return $arrOut;
}

?>