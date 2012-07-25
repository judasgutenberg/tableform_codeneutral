<?php 
//Judas Gutenberg January 2006-December 2007////////////////////////////////////////////////////////
//provides a web front end admin tool for any MySQL db/////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////
/////core function library///////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////
//This code is covered under the GNU General Public License////////////////////////////////////
//info here: http://www.gnu.org/copyleft/gpl.html/////////////////////////////////////////////
//the digest is as follows: you cannot modify this code without//////////////////////////////
//publishing your source code under the same license////////////////////////////////////////
//contact the developer at gus A T asecular.com  http://asecular.com///////////////////////
//////////////////////////////////////////////////////////////////////////////////////////

//This is how I like my error reporting, thank you very much.  why should i give a crap about Notice?
error_reporting(E_ERROR | E_WARNING | E_PARSE );
ini_set("display_errors",true);
$olderrors=error_reporting(0);
if (file_exists('tf_constants.php'))
{
	require('tf_constants.php');
}
else if (file_exists('../tf_constants.php'))
{
	require('../tf_constants.php');
}
else if (file_exists('../../tf_constants.php'))
{
	require('../../tf_constants.php');
}
else if (file_exists('constants.php'))
{
	require('constants.php');
}
else if (file_exists('../constants.php'))
{
	require('../constants.php');
}
else if (file_exists('../../constants.php'))
{
	require('../../constants.php');
}
else if(!contains($_SERVER['PHP_SELF'],"buildconstants.php" ))
{
	//header("Location:buildconstants.php");
}
if(!defined("tf_dir"))
{
	define("tf_dir","");
}
error_reporting($olderrors);

class sqldb //I'm not big into PHP classes, but I use one here as part of the legacy of how this tool came to be.
{
	var $c=TRUE;
	function disconDB()
	{
		mysql_close($c);
		return($c);
	}
 
	function query($strSQL , $bwlGusStyleConnect=true)
	{
		$c=FALSE;
		if(defined("remote_sql_url"))
		{
		
			$out=RemoteSQLCall(remote_sql_url, $strSQL, remote_sql_password);
		}
		else
		{
			if ($bwlGusStyleConnect)
			{
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
				if ($bwlNeedConnection)
				{
					//mysql_close($c);
				}
	 		}
			else
			{
				$res= tep_db_query($strSQL);
			}
			$out=array();
			$count=0;
	
			if (gettype($res)=="resource")
			{
				for ($i=0; $i<mysql_num_rows($res); $i++)
				{
					$record=mysql_fetch_assoc($res);
				 
					$out[$count]=$record;
					$count++;
				}
	 		}
		}
		return $out;
	}	
}

function SQLtoArray($strSQL)
{
	$sql=conDB();
	$records = $sql->query($strSQL);
	return $records;
}

function parseBetween($strIn, $strStart, $strEnd, $intStartingAt=0)
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
	if ($pos1+1<strlen($strIn))
	{
		if($strEnd=="")
		{
			$pos2=strlen($strIn);
		}
		else
		{
			$pos2 = strpos($strIn, $strEnd, $pos1);
		}
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
 
function prevnextlinks($strDB, $strThisTable, $sortcolumn, $id_column, $strLabel,   $type, $strAdditionalField="", $strAdditionalValue="", $thiscolumn)
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
	$nrecords = $sql->query($strSQL);
	$nrecord = $nrecords[0];
	$id=$nrecord[$id_column];
	//show the links only if an ID for the next one is found

	if ($id!="")
	{
		$url=$strPHP . "?" . replaceSpecificQueryVariable($id_column, $id);
		$link=$pre . " <a href=\"" . $url .   "\"   class=\"text_news10\">" . $verbiage  . " " . $strLabel . "</a>" . $post;
	}
	return $link;
}

function PageHeader($strTitle, $strConfigBehave,$strForBackField="", $bwlIsStandalone=true, $bwlSuppressExternalHeader=false)
//page header for all the pages
{
	$out="";
	$externalheader="";
	if(defined("headerfunction")  && !$bwlSuppressExternalHeader)
	{
		if(headerfunction!="")
		{
			$externalheader=call_user_func(headerfunction);
		}
	}
	if($externalheader!="")
	{
		$out.=$externalheader;
	}
	else if($bwlIsStandalone)
	{
		$out.= "<html>
		<head>
		<meta http-equiv=\"cache-control\" content=\"no-cache\"/>
		<title>" . $strTitle . "</title>\n";
	}
 
	$out.= "<link rel=\"stylesheet\" href=\"" . tf_dir . "tableform_css.css\" type=\"text/css\">\n";
	$out.= "<script src=\"" . tf_dir . "tableform_js.js\"><!-- --></script>";
	 
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
	$out="<div id=\"idothertools\" class=\"overlay\">";
	$out.="<span class=\"heading\">Other Tools</span><br/>\n";
	if(file_exists("tabletotablecopy.php"))
	{
		$out.="<a href=\"tabletotablecopy.php\">Table to table copy.</a><br/>\n";
	}

	$out.="<a href=\"" . $strPHP . "?" . qpre . "mode=entersql\">Manually enter SQL.</a><br/>\n";
	$out.="<a href=\"" . $strPHP . "?" . qpre . "mode=auxpick\">Install table packages.</a><br/>\n";
	$out.="<a href=\"" . $strPHP . "?" . qpre . "mode=stats\">Display database stats.</a><br/>\n";

	if(file_exists("dbdiff.php"))
	{
		$out.="<a href=\"dbdiff.php\">Analyze database changes.</a><br/>\n";
	}
	if(file_exists("sqlimport.php"))
	{
		$out.="<a href=\"sqlimport.php\">Import a database from SQL.</a><br/>\n";
	}
	$out.="<a href=\"" . $strPHP . "?" . qpre . "mode=backup\">Backup database to a SQL file.</a><br/>\n";

	if(file_exists("sqlexport.php"))
	{
		$out.="<a href=\"sqlexport.php\">Comprehensive SQL export tools.</a><br/>\n";
	}
	if(file_exists("columnscanner.php"))
	{
		$out.="<a href=\"columnscanner.php\">Search the entire <strong>" . $strDatabase . "</strong> database.</a><br/>\n";
	}

	if(file_exists("dbmap.php"))
	{
		$out.="<a href=\"dbmap.php\">Show/create relationship maps of the <strong>" . $strDatabase . "</strong> database.</a><br/>\n";
	}
	$out.="<a href=\"" . $strPHP . "?" . qpre . "mode=fkscan\"> Scan database for possible relations based on field names.</a><br/>\n";
	if(file_exists("tableconcordance.php"))
	{
		$out.="<a href=\"tableconcordance.php\">Copy information between similar tables using concordances</a>.<br/>\n";
	}
	if(file_exists("fieldfinder.php"))
	{
		$out.="<a href=\"fieldfinder.php\">Search the entire <strong>" . $strDatabase . "</strong> database for tables having a given field name.</a><br/>\n";
	}
	if(file_exists("deleterange.php"))
	{
		$out.="<a href=\"deleterange.php\">Delete a range of IDs from a table, and also delete  all dependent columns in other tables.</a><br/>\n";
	}
	$out.="<div align=\"right\">[<a href=\"javascript: closeothertools()\">close</a>]</div>\n";
	$out.="</div>";
	return $out;
}

function AdminNav($bwlSuperAdmin, $bwlSimple=false)
{
	$intTop=20;
	if($bwlSimple)
	{
		$intTop=0;
	}
	$out="<div style=\"position: absolute;top:" . $intTop . "px;right: 0px; z-index: 100;\">";
	$strPHP=$_SERVER['PHP_SELF'];
	$strThisQS=$_SERVER['QUERY_STRING'];
	
	$strDatabase=$_REQUEST[qpre . "db="];
	$strConfig="tableform|browse tables||1-tablemaker|create new table||-dbtools|db tools||-dbtools|manually enter SQL|entersql|-tableform|version|version|1";
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
		$strQS=qpre . "db=" . $strDatabase;
 
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
	 	if(!contains($strPHP, "dbtools") || contains($strThisQS, "mode"))
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
			$out.=LinkIfFile($arrThis[0] . ".php", $strQS, $arrThis[1], " <span class='topnav_notselected'>", "</span> ", $bwlLink, "class='topnav_selected'", $jsextra) ;
		
		}
 
	}
	if($bwlShowMoreTools  && $bwlSuperAdmin)
	{
		$out.="<p>" . OtherTools(our_db, $strPHP);
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
			$out.=call_user_func(footerfunction);
		}
	}
	
	if($bwlIsStandalone)
	{
		$out.="</body>\n";
		$out.="</html>\n";
	}
	return $out;
}

function conDB()
{
 	$sql=new sqldb();
	return($sql);
}

function disconDB()
{
	mysql_close($c);
	 
	return($c);
}

function DateTimeForMySQL($strIn)
//Parses a datetime and makes it acceptable for mysql.
{
	$timestamp=strtotime($strIn);
	return date("Y-m-d H:i:s", $timestamp);
}

function kdateformat($intDate)
{
	if (is_numeric($intDate))
	{
		$out=date("m.d.y", intval($intDate));
	}
	else
	{
		$out=date("m.d.y", strtotime($intDate));
	}
	//echo "<p>" . time() . " " . $intDate . " " . $out . "<p>";
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

function adminbreadcrumb($disablelink)
//Breadcrumb nav for the admin tools
{
	$intArgs =func_num_args();
	$out="";
	$strDelimiter=" : ";
	
	for($i=1; $i<$intArgs; $i=$i+2)
	{
		$out.="<span class=\"heading\">";
		$label=func_get_arg($i);
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
	$records = DBExplain($strDatabase, $strTable);
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
	
function TableList($strDatabase, $likeclause="")
{
	$sql=conDB();
	$strSQL="SHOW TABLES FROM " . $strDatabase . " " .  $likeclause; 
	$records = $sql->query($strSQL);
	return $records;
}

function sql_error()
{
	//a wrapper function in case some day we're not using mysql
	return mysql_error();
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

function endswith($strIn, $what)
//Does $strIn end with $what?
{
	if (substr($strIn, strlen($strIn)- strlen($what) , strlen($what))==$what)
	{
		return true;
	}
	return false;
}

function beginswith($strIn, $what)
//Does $strIn begin with $what?
{
	if (substr($strIn,0, strlen($what))==$what)
	{
		return true;
	}
	return false;
}

function contains($strIn, $what)
//Does $strIn contain $what?
{
	if ($strIn!="" && $what !="")
	{
		if (strpos($strIn, $what)===false)
		{
			return false;
		}
	}
	else
	{
		return false;
	}
	return true;
}

function gracefuldecay()
//Go through the parameters and return the first that isn't empty. Incredibly useful!
{
	$intArgs =func_num_args();
	for($i=0; $i<$intArgs; $i++)
	{
		$option=func_get_arg($i);
		if ($option!="")
		{
			return $option;
		}
	}
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

function GenericInput($name, $default, $bwlChecked=false, $onClick="",  $strStyle="", $strClass="", $type="submit", $size="", $strStrayJS="", $height=1)
//Displays just about any kind of HTML input.
{
	if ($onClick!="")
	{
		$onClick=" onclick='javascript:" . $onClick . "'";
	}
	$strSize ="";
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
	$idstring="";
	if(strlen($name)<35)//suppress ids in cases with extremely long names
	{
		$idstring= " id=\"id" . $name . "\"";
	}
	if ($height>1)
	{
		$out="<textarea rows=\"" .$height . "\" cols=\"" . $size . "\" " . $strStrayJS .  $onClick . $checkedindication .  $strClass .  $strStyle . $idstring . " name=\"" . $name . "\" >" .  $default . "</textarea>";
	}
	else
	{
		if ($size!="")
		{
			$strSize=" size='" .  $size . "'";
		}
		$out="<input value=\"" . $default . "\" " . $strStrayJS . $onClick . $checkedindication . $strClass . " " . $strSize .  $strStyle .  $idstring . " name=\"" . $name . "\" type=\"" . $type . "\" >\n";
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

function Alternate($strOptionOne, $strOptionTwo, $strOptionNow)
//Swap between two strings.  Great for both front end and back end.
{
	if ($strOptionOne== $strOptionNow)
	{
		return $strOptionTwo;
	}
	return $strOptionOne;

} 
function deMultiple($strIn, $chrIn)
//Remove multiple side-by-side instances of $chrIn - works best for things like spaces and chr(13).
{
	$strOut=$strIn;
	while(strpos($strOut, $chrIn . $chrIn))
	{
		$strOut = str_replace( $chrIn . $chrIn, $chrIn, $strOut);
	}
	return($strOut);
}
	
function RemoveLastCharacterIfMatch($strIn, $chrIn)
//Trim off the last character of $strIn if they happen to be  $chrIn.
//Only works with one-character $chrIn.
{

	$out=$strIn;
	if (substr($strIn,  strlen($strIn)-1, 1) ==$chrIn)
	{
		$out= substr($strIn, 0, strlen($strIn)-1);
	}
	return $out;
}
	
function RemoveFirstCharacterIfMatch($strIn, $chrIn)
//Trim off the first character of $strIn if they happen to be  $chrIn.
//Only works with one-character $chrIn.
{
	$out=$strIn;
	//echo substr($strIn,   0, 1) . "<br>";
	if (substr($strIn,   0, 1) ==$chrIn)
	{
		$out= substr($strIn, 1);
	}
	return $out;
}
	
function RemoveEndCharactersIfMatch($strIn, $chrIn)
//Trim off the end characters of $strIn if they happen to be  $chrIn.
//Only works with one-character $chrIn.
{
	$out= RemoveFirstCharacterIfMatch($strIn, $chrIn);
 	$out= RemoveLastCharacterIfMatch($out, $chrIn);
	return $out;
}

function GenericForm($arrFieldNames,  $arrLabels, $arrDefaults, $arrSizes, $arrHiddenMask, $strPHP)
//Simplest-possible conversion of field names, labels, and defaults into an actual form.
{
	$strLineClass="bgclassline";
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strOtherBgClass="bgclassother";
	$strOtherLineClass="bgclassline";
	$intDefaultSize=20;
	$out= "<table border=\"0\" cellspacing=\"1\" cellpadding=\"2\" class=\"" .$strLineClass  . "\" width=\"450\">\n";
	$out.= "<form method=\"post\" name=\"BForm\" action=\"" .  $strPHP . "\">\n";
	for($i=0; $i<count($arrFieldNames); $i++)
	{
		$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
		if ($arrHiddenMask[$i]=="1")
		{
			$out.=HiddenInputs(Array($arrFieldNames[$i]=>$arrDefaults[$i]), $pre="","", "") . "\n";
		}
		else
		{
			$out.=htmlrow($strThisBgClass, gracefuldecay($arrLabels[$i], $arrFieldNames[$i]), TextInput($arrFieldNames[$i], $arrDefaults[$i], gracefuldecay($arrSizes[$i], $intDefaultSize), "",  "", ""));
		}
	}
	$out.=htmlrow($strOtherLineClass, "&nbsp;", GenericInput(qpre . "save", "Configure"));
	$out.= "</form>\n";
	$out.= "</table>\n";
	return $out;
}
	
function genericdata($strIn,$intTypeIn, $intTypeOut, $strTranslate, $rowdelimiter, $fielddelimiter, $bwlRow=false)
//Form of 'data' that allows you to pass in your own delimiters
//If $bwlRow=true than return the whole row as an array
{
	$arrTranslate=explode($rowdelimiter, $strTranslate);
	$strOut="";
	$bwlDone=1;
	$strIn=$strIn;
	$bwlDone=0;
	for ($i=0;  $i < count($arrTranslate) and $bwlDone==0; $i++)
	{
		$arrThis=explode($fielddelimiter,$arrTranslate[$i]);
		if ($intTypeIn<count($arrThis) and $intTypeOut<count($arrThis))
		{
			if ($intTypeIn==-1) //type==-1 allows you to grab fields by the number of the row
			{
				if ($strIn==$i+'')
				{
					if ($bwlRow)
					{
						$strOut=$arrThis;
					}
					else
					{
						$strOut=$arrThis[$intTypeOut];
					}
					$bwlDone=1;
				}
				
			}
			else
			{
				if ($arrThis[$intTypeIn]==$strIn)
				{
					if ($bwlRow)
					{
						$strOut=$arrThis;
					}
					else
					{
						$strOut=$arrThis[$intTypeOut];
					}
					$bwlDone=1;
				}
			}
		}
	}
	return($strOut);
}

function DDStringToDelimitedList($strConfig, $intFieldNumber, $strSourceRowDelimiter, $strSourceColumnDelimiter, $strDestinationDelimiter)
{
//makes a delimited list of single fields for a column in a double-delimited string
//Judas Gutenberg, January 28 2009
	$out="";
	$rowcount=0;
	$bwlFresh=true;
	while($thisresult!="" ||  $bwlFresh)
	{
		$thisresult=genericdata($rowcount,-1,  $intFieldNumber, $strConfig, $strSourceRowDelimiter, $strSourceColumnDelimiter, false);
		$bwlFresh=false;
		$rowcount++;
		$out.=$thisresult . $strDestinationDelimiter;
	}
	return $out;
}

function ArraySubsetFromList($strList, $arrArray)
//Take an associative array and return an array whose keys are mentioned in the space-delimited list $strList
{
	$arrList=explode(" ", $strList);
	$arrOut=Array();
	foreach($arrList as $key)
	{
		if($arrArray=="" || !array_key_exists($key,$arrArray))
		{
			$arrOut[$key]="";
		}
		else
		{
			$arrOut[$key]=$arrArray[$key];
		}
	}
	return $arrOut;
} 

function ArraySubsetFromArray($arrVictim, $arrSource)
//Take an associative array and return an array whose keys are mentioned in the associative array $arrVictim
{
	$arrOut=Array();
	foreach($arrVictim as $key=>$value)
	{
		if($arrSource=="" || !array_key_exists($key,$arrSource))
		{
			$arrOut[$key]="";
		}
		else
		{
			$arrOut[$key]=$arrSource[$key];
		}
	}
	return $arrOut;
} 

function ArrayToWhereClause($arrIn)
//Take an associative array and make it into the stuff that comes after the WHERE in a MySQL expression
{
	$out="";
	foreach($arrIn as $key=>$value)
	{
		if($value!="")
		{
			$out.= "AND  " . $key . "='" . singlequoteescape($value) . "' ";
		}
	
	}
	$out=substr($out, 3);
	return $out;
}

function AppropriateSQLName($in)
//Take a user-chosen string and return something that could be used as a MySQL table name or field name
{
	$strLimitspec="48-57 a-z A-Z _ ";
	$in=FilterString($in, $strLimitspec, "_");
	if(inList("outer inner on key table where in real repeat write read label upgrade out leave then while with when right unique union left select create database update insert between blob call change column character case grant", strtolower( $in)))
	{
		$in="attempted_reserved_word";
	}
	return $in;
}

function FilterString($strIn, $strLimitspec, $replacement)
//$strLimitspec is a dual-delimited string of ascii codes or characters. each range is separated by spaces
//the extremes of each limit are separated by -
{
	$arrLimit=explode(" ",$strLimitspec);
	$out="";
 	for($i=0; $i<strlen($strIn); $i++)
	{
		$chr=substr($strIn, $i, 1);
 
		$bwlHandled=false;
		foreach($arrLimit as $limitpair)
		{
			$chrOneLimit="";
			if(contains($limitpair, "-"))
			{
				$arrLimitSet=explode("-", $limitpair);
			}
			else
			{
				$chrOneLimit=$limitpair;
			}
			if (!$bwlHandled && ($chr==$chrOneLimit  || $chr>=ReturnCharacter($arrLimitSet[0])  && $chr<=ReturnCharacter($arrLimitSet[1])))
			{
				$out.=$chr;
				$bwlHandled=true;
			}
		}
		if(!$bwlHandled)
		{
			$out.=$replacement;
		}
	}
	return $out;
}

function ReturnCharacter($possibleASCIICode)
//If $possibleASCIICode is an ASCII code, turn it into a chr, otherwise return chr.
{
	if(strlen($possibleASCIICode)>1)
	{
		$out=chr($possibleASCIICode);
	}
	else
	{
		$out=$possibleASCIICode;
	}
	return $out;
}

function HandleNumericCasesInSpaceDelimitedChrString($quotechar)
//In a string of chrs, sometimes the chr is so weird it's passed in as an ASCII value.  Here we turn them all into chrs.
{
	$arrQuotes=explode(" ", $quotechar);
	$quotechar="";
	foreach($arrQuotes as $thisquote)
	{
		if(is_numeric($thisquote))
		{
			$quotechar.=chr($thisquote) . " ";
		}
		else
		{
			$quotechar.=$thisquote. " ";
		}
	}
	$quotechar=RemoveEndCharactersIfMatch($quotechar, " ");
	return $quotechar;
}

function multichrhandle($strIn)
//If a string contains ".", this expodes the string, interprets the parts as ASCII values, and returns it as a set of special chracters
{
	$out="";
	$arrIn=explode(".", $strIn);
	foreach($arrIn as $chr)
	{
		$out.=chr($chr);
	}
	return $out;
}

function ParseStringToArraySkippingQuotedRegions($strIn, $quote="'", $delimiter=";", $escapecharacter="\\", $arrQuoteCorrectingSequences="usual") 
//Judas Gutenberg Jan 4 2007
//Go through, say, SQL and find the commands and put them in an array
//carefully overlooking semicolons inside quotes
//Dec 1, 2008: added some code to allow the parser to fix misplaced single quotes in the text
{
	$newString = "";
	$inQuotes = false;
	$arrOut=Array();
	$intLastDelimiterPos=0;
	$outCount=0;
	$chrSub=chr(4);
	$strLen=strlen($strIn);
	if($arrQuoteCorrectingSequences=="usual"  )
	{
 
		$arrQuoteCorrectingSequences=Array(" ", ",", ")",";");
	}
   	for($i = 0; $i < strlen($strIn)+1; $i++) 
	{
        if(substr($strIn,$i,strlen($quote)) == $quote  &&  substr($strIn,$i-1,strlen($escapecharacter)) != $escapecharacter) 
		{
			$bwlQuoteFail=false;
	 		 
			if($inQuotes &&  is_array($arrQuoteCorrectingSequences))
			{
				$bwlFoundACorrectingSequence=false;
				foreach($arrQuoteCorrectingSequences as $strQuoteCorrectingSequence)
				{
					//echo "[" . $strQuoteCorrectingSequence . "]<br>";
					$bwlNextMatchCorrectingSequence=true;
					for($j=0; $j<strlen($strQuoteCorrectingSequence); $j++)
					{
						//echo "<font color=red>" . $j . " ="  . substr($strIn,$j+$i+strlen($quote),1) .   "= -" . substr($strQuoteCorrectingSequence,$j,1) . "-</font><br>";
						if(substr($strIn,$j+$i+strlen($quote),1)!=substr($strQuoteCorrectingSequence,$j,1)  &&  $j+$i+strlen($quote)<=strlen($strIn)-1)
						{
							//echo "<font color=orange>*</font><br>";
							$bwlNextMatchCorrectingSequence=false;
						}
						else
						{
							//echo "<font color=green>*</font><br>";
						}
					
					}
		
					if($bwlNextMatchCorrectingSequence)
					{
						$bwlFoundACorrectingSequence=true;
						//echo "&&";
					}
			 
				}
				if(!$bwlFoundACorrectingSequence)
				{
					//echo "<br>!<br>";
					$strIn=substr($strIn, 0, $i) . str_pad("", strlen($quote),  $chrSub) . substr($strIn,   $i + strlen($quote));
					$bwlQuoteFail=true;
				}
			}
			if(!$bwlQuoteFail)
			{
				$inQuotes =!$inQuotes;
			}
		}
		if(!$inQuotes)
		{ 
			if(substr($strIn,$i,strlen($delimiter)) == $delimiter  || $i==$strLen)
			{
				$strThisCommand=RemoveEndCharactersIfMatch(substr($strIn, $intLastDelimiterPos, ($i-$intLastDelimiterPos)), $delimiter);
				//echo "<br><font color=blue>" . $strThisCommand . "</font><br>";
				$strThisCommand=str_replace(str_pad("", strlen($quote), $chrSub),  "\\" . $quote, $strThisCommand);
				//echo "<br><font color=green>" . $strThisCommand . "</font><br>";
				$intLastDelimiterPos=$i;
				$arrOut[$outCount]=$strThisCommand;
				$outCount++;
			}
		}
	}
 	return $arrOut;
}

function BetterExplode($delimiter, $data,  $quotechar="\" '", $bwlLeaveQuotesInPlace=false, $strEscapeStyle="csv", $bwlDelmiterCaseInsensitive=true, $delimiterprefixnixlist="", $chrQuoteOverwrite="", $chrPHPCommentOverwrite="", $chrNonQuoteOverwrite="", $chrEndQuoteToStripFromData="")
//Judas Gutenberg November 28 2007
//moves through data character by character breaking on delimiters so quoted characters are not mistaken as delimiters
//$quotechar can be a space-delimited series of acceptable quotes, though they cannot be mixed when 
//quoting a particular string
//think of it as a more complicated version of explode
//as of December 12 2007 this function handles multi-char delimiters (MCDs) too
{
	$bwlCommentOn=false;
	$intDelimiterChrCount=0;
	//handle quotes being passed in as ascii values:
	$quotechar=HandleNumericCasesInSpaceDelimitedChrString($quotechar);
	$bwlPossibleMCD=false;
	if (contains($delimiter, "."))
	{
		$delimiter=multichrhandle($delimiter);
	}
	else if (is_numeric($delimiter))
	{
		$delimiter=chr($delimiter);
	}
	$arrOut=Array();
	if($quotechar=="")
	{
		$bwlQuoteOn=true;
	}
	else
	{
		$bwlQuoteOn=false;
	}
	$testdelimiter=$delimiter;
	if($bwlDelmiterCaseInsensitive)
	{
		$testdelimiter=strtolower($delimiter);
	}
	$intArrCursor=0;
	$chrKnownQuote="";
	$chrQuoteToBeEscaping="";
	$strTempPossibleDelimeter="";
	$thisvar="";
	for($i=0; $i<strlen($data); $i++)
	{
		$chr=substr($data, $i, 1);
		$tchr=$chr;
		if($bwlDelmiterCaseInsensitive)
		{
			$tchr=strtolower($chr);
		}
		$dchr=substr($testdelimiter, $intDelimiterChrCount, 1);
		if($i+1<strlen($data))
		{
			$chrNext=substr($data, $i+1, 1);
		}
		else
		{
			$chrNext="";
		}
		if($i-1>-1)
		{
			$chrPrev=substr($data, $i-1, 1);
		}
		else
		{
			$chrPrev="";
		}
		//php comment handling
		if($strEscapeStyle=="php")
		{
			if( $chr=="/"  && $chrNext=="/" && !$bwlQuoteOn  && !$bwlCommentOn)
			{
				$bwlCommentOn=true;
				if($chrPHPCommentOverwrite!="")
				{
					$thisvar.=$chrPHPCommentOverwrite;
				}
				else
				{
					$thisvar.=$chr;
				}
				
			}
	
			else if( $chr==chr(13)  && !$bwlQuoteOn  && $bwlCommentOn)
			{
				$bwlCommentOn=false;
				$thisvar.=$chr;
			}
			else if($bwlCommentOn)
			{
				if($chrPHPCommentOverwrite!="")
				{
					$thisvar.=$chrPHPCommentOverwrite;
				}
				else
				{
					$thisvar.=$chr;
				}
			}
		}
		if(!$bwlCommentOn)
		{
			if(!$bwlPossibleMCD)
			{
				if($tchr==$dchr    &&  (!$bwlQuoteOn  || $quotechar=="")  && !inList($delimiterprefixnixlist, $chrPrev))
				{
					$bwlPossibleMCD=true;
					$strTempPossibleDelimeter.=$chr;
					$intDelimiterChrCount++;
				}
			}
			else
			{
				if($tchr==$dchr    &&  (!$bwlQuoteOn  || $quotechar==""))
				{
					$intDelimiterChrCount++;
					$strTempPossibleDelimeter.=$chr;
				}
				else
				{
					//echo "<p>$<p>";
					$bwlPossibleMCD=false;
					//we've not been adding to the content of this delimited item
					//because it began with the first several characters of a 
					//multichar delimiter (MCD).  so we have to take those first
					//few chrs and add them to $thisvar.
					$thisvar.=$strTempPossibleDelimeter;
					$strTempPossibleDelimeter="";
					$intDelimiterChrCount=0;
				}
			}
			if($bwlPossibleMCD )//MCD means multi-chr delimiter
			{	
				if($intDelimiterChrCount==strlen($delimiter))
				{
					//echo $thisvar . "\n";
					if($chrEndQuoteToStripFromData!="")
					{
						$thisvar=RemoveEndCharactersIfMatch($thisvar, $chrKnownQuote);
					}
					$arrOut[$intArrCursor]=$thisvar;
					$intArrCursor++;
					$thisvar="";
					$intDelimiterChrCount=0;
					$strTempPossibleDelimeter="";
					$bwlPossibleMCD =false;
				}
			}
			else if (!$bwlQuoteOn  && ($chrKnownQuote=="" && inList($quotechar, $chr) || $chrKnownQuote==$chr))
			{
				$bwlQuoteOn=true;
				$chrKnownQuote=$chr;
				if($bwlLeaveQuotesInPlace)
				{
					$thisvar.=$chr;
				}
			}
			else if ($bwlQuoteOn)
			{	
				//$chrPrev catches the situation in which the backslash is itself escaped
				if($chr=="\\"  && $strEscapeStyle=="php"  && $chrPrev!="\\")
				{
					if($chrNext==$chrKnownQuote)
					{
						$chrQuoteToBeEscaping=$chrNext;
					}
				}
				else if($chrKnownQuote=="" && inList($quotechar, $chr) || $chrKnownQuote==$chr) //only for csv escapes
				{
					//handle internally-escaped quotes, that is, a known quote escaping one immediately following in data
					if($chrQuoteToBeEscaping==$chr)
					{
						$chrQuoteToBeEscaping="";
						$thisvar.=$chr;
					}
					else if($chrNext==$chrKnownQuote  && $strEscapeStyle=="csv")
					{
						//was: $chrQuoteToBeEscaping=$chr;
						$chrQuoteToBeEscaping=$chrNext;
						if($bwlLeaveQuotesInPlace)
						{
							$thisvar.=$chr;
						}
					}
					else
					{
						$bwlQuoteOn=false;
						$chrKnownQuote="";
						if($bwlLeaveQuotesInPlace)
						{
							$thisvar.=$chr;
						}
					}
		 		}
		 		else //we're not a quote but we are a chr in a quoted section of text
				{
					if($chrQuoteOverwrite!="")
					{
						$thisvar.=$chrQuoteOverwrite;
					}
					else
					{
						$thisvar.=$chr;
					}
				}
			}
			else if($bwlLeaveQuotesInPlace)
			{
				if($chrNonQuoteOverwrite=="")
				{
					$thisvar.=$chr;
				}
				else
				{
					$thisvar.=$chrNonQuoteOverwrite;
				}
			}
		}
	}
	if($chrEndQuoteToStripFromData!="")
	{
		$thisvar=RemoveEndCharactersIfMatch($thisvar, $chrEndQuoteToStripFromData);
	}
	$arrOut[$intArrCursor]=$thisvar;
	return $arrOut;
}

function BlankOutQuotedAreas($data, $chrBlank, $quotechar="' \"", $chrPHPCommentBlank="")
//Whoever passes in $quotechar will want to have done
//$quotechar=HandleNumericCasesInSpaceDelimitedChrString($quotechar); 
//to it. i don't do that here since this function is done inside loops and 
//$quotechar=HandleNumericCasesInSpaceDelimitedChrString($quotechar) is somewhat expensive
//I take advantage of BetterExplode's parser to blank out the quoted areas
{
	$arrThis=BetterExplode(" ", $data,  $quotechar="\" '", true,  "csv", true, "", $chrBlank, $chrPHPCommentBlank);
	$out=implode(" ", $arrThis);
	return $out;
}

function PosInList($strList, $strProspect, $strDelimiter=" ", $bwlIgnoreCase=true, $quotechar="' \"")
//Search for each item of $strList in $strProspect and returns first found strpos or -1 if nothing
{
	$arrList=explode(" ", $strList);
	if($quotechar!="")
	{
		$bwlIgnoreQuotedAreas=true;
	}
	else
	{
		$bwlIgnoreQuotedAreas=false;
		$quotechar=HandleNumericCasesInSpaceDelimitedChrString($quotechar);
	}
	if($bwlIgnoreCase)
	{
		$strList=strtolower($strList);
		$strProspect=strtolower($strProspect);
	}
	foreach($arrList as $strToTest)
	{
		if(! $bwlIgnoreQuotedAreas)//fast algorithm for cases where quoted areas don't need to be ignored
		{
			if(contains($strProspect, $strToTest))
			{
				//i added 1 here to get something to work right but i'm not sure it's the right thing to do
				return(strpos($strProspect, $strToTest) + 1);
			}
		}
		else//got to do the slow-ass algorithm
		{
			//echo "<br>preblankedout: " . $strProspect . "<br>";
			$strProspect=BlankOutQuotedAreas($strProspect, "*", $quotechar);
			//echo "<br>blankedout: " . $strProspect . "<br>";
			//echo $strToTest . "==totest<br>";
			//echo $strProspect . "------------" . $strToTest . "==prospect/totest<br>";
			if(contains($strProspect, $strToTest))
			{
				//i added 1 here to get something to work right but i'm not sure it's the right thing to do
				return(strpos($strProspect, $strToTest) + 1);
			}
		}
	}
	return -1;
}

function inList($strList, $item, $MatchOnlyType="") 
//look to see if item is in the space-delimited strList (similar to my ASP version)
{
	$arrThis=explode(' ', $strList);
	for ($t=0; $t<count($arrThis); $t++)
	{
		$thislen=strlen($arrThis[$t]);
		if($MatchOnlyType=="last")
		{
			if ($arrThis[$t]==substr($item, strlen($item)-$thislen))
			{
				return true;
			}	
		}
		else if ($MatchOnlyType=="first")
		{
			if ($arrThis[$t]==substr($item, 0,$thislen))
			{
				return true;
			}	
		}
		else
		{
			if ($arrThis[$t]==$item)
			{
				return true;
			}
		}
	}
	return false;
}

function pluralize($strIn)
//pluralize an english word, getting it right most of the time
//i had a bug in the original version that i fix here with the global pluralizationmethod
{
	$intLen=strlen($strIn);
	$endletter=substr(strtolower($strIn), $intLen-1, 1);
	$endtwoletter=substr(strtolower($strIn), $intLen-2, 2);
	$strESletters="s z c x";
	if (contains(pluralizationmethod,"new"))
	{
		$strESletters="s z x";
		if (inList("ay ey iy oy uy",$endtwoletter))
		{
			$out=$strIn. "s";
		}
		else if ($endletter=="y" )
		{
			$out=substr($strIn, 0, strlen($strIn)-1). "ies";
		}
	}
	if ($endletter=="y" )
	{
		$out=substr($strIn, 0, strlen($strIn)-1). "ies";
	}
	elseif (inList("sh ch",$endtwoletter))
	{
		$out=$strIn. "es";
	}
	elseif (inList($strESletters, $endletter))
	{
		$out=$strIn. "es";
	}
	else
	{
		$out=$strIn. "s";
	}
	if (endswith($strIn,"child"))
	{
		$out="children";
	}
	else if (endswith($strIn,"woman"))                                                                                                     
	{
		$out="women";
	}
	else if (endswith($strIn,"man"))
	{
		$out="men";
	}
	else if (endswith($strIn,"ox"))
	{
		$out="oxen";
	}
	else if (endswith($strIn,"mouse"))
	{
		$out="mice";
	}
	if (inList("news deer moose sheep keyart", $strIn, "last"))
	{
		$out=$strIn;
	}
	if (contains(pluralizationmethod,"new0"))
	{
		if (inList("media", $strIn, "last"))
		{
			$out=$strIn;
		}
		if ($strIn=="datum")
		{
			$out="data";
		}
	}
	return $out;
}

function PluralizeIfNecessary($subject, $number)
//If $number is 1, no need to plurazlize $subject.  Otherwise there is a need to.
{
	if ($number!=1)
	{
		return pluralize($subject);
	}
	return $subject;
} 

function IsAlreadyPlural($subject)
//Kinda stupid but it mostly works
{
	$subject=strtolower($subject);
	$out=false;
	$strPrePluralized="news deer moose sheep keyart oxen children men women mice";
	if (contains(pluralizationmethod,"new0"))
	{
		$strPrePluralized.=" media data";
	}
	$endletter=substr($subject, $intLen-1, 1);
	
	if($endletter=="s" || inList($strPrePluralized, $subject, "last"))
	{
		$out=true;	
	}
	return $out;
}

function forcePlural($subject)
//If it's plural, leave it alone.  If it's not, pluralize.
{
	$out=$subject;
	if(!IsAlreadyPlural($out))
	{
		$out=pluralize(	$out);
	}
	return $out;
}

function forceSingular($subject)
//If it's singular, leave it alone.  If it's not, singularize.
{
	$out=$subject;
	if(IsAlreadyPlural($out))
	{
		$out=singularize($out);
	}
	return $out;
}

function singularize($subject)
//Turns a plural word singular.
{
	$intLen=strlen($subject);
	$endletter=substr(strtolower($subject), $intLen-1, 1);
	$endtwoletter=substr(strtolower($subject), $intLen-2, 2);
	$endthreeletter=substr(strtolower($subject), $intLen-3, 3);
	$out=$subject;
	$lowered=strtolower($subject);
	if($endthreeletter=="ies")
	{
		$out=substr($subject, 0, strlen($subject)-3). "y";
	}
	else if (endswith($lowered,"news"))
	{
		$out=$subject;
	}
	else if (endswith($lowered,"men"))
	{
		$out=replaceend($subject, "man");
	}
	else if (endswith($lowered,"women"))
	{
		$out=replaceend($subject, "women");
	}
	else if (endswith($lowered,"data"))
	{
		$out=replaceend($subject, "datu"). "m";                                         
	}
	else if (endswith($lowered,"media")  && contains(pluralizationmethod,"new0"))
	{
		$out=replaceend($subject, "mediu") . "m";
	}
	else if ($endthreeletter=="ren")
	{
		$out=substr($subject, 0, strlen($subject)-3);
	}
	else if ($endtwoletter=="en")
	{
		$out=substr($subject, 0, strlen($subject)-2);
	}
	else if($endletter=="s")
	{
		$out=substr($subject, 0, strlen($subject)-1);	
	}                                                                                     
	return $out;
}

function replaceend($strIn, $strReplacement)
//Look at how many characters are in $strReplacement and then replace that number at the end of $strIn with $strReplacement.
{
	$out=substr($strIn, 0, strlen($strIn) - strlen($strReplacement)) . $strReplacement;
	return $out;
}

function probablepassword($in)
//If $in looks like an xcart password, the return true.
{
	$out=false;
	$in=trim($in);
	if(contains($in, "-"))
	{
		$arrThis=explode("-", $in);
		if( $arrThis[0]=="B"  && !contains($arrThis[1], " ")  && strlen($arrThis[1])>12)
		{                               
			$out=true;
		}
	}                    
	return $out;
}

function AllWhiteSpaceToSpace($strIn)
//Anything considered whitespace ends up as a space.
{
	$strWhiteSpaceChrs="13 9 10 0 11 8";
	$arrChrs=explode(" ", $strWhiteSpaceChrs);
	foreach($arrChrs as $intChr)
	{
		$strIn=str_replace(chr($intChr), " ",$strIn);
	}
	return $strIn;
}

function singlequoteescape($strIn)
//Escapes '
{
	if (strlen($strIn)>0)
	{
		return str_replace("'", "\'", $strIn);
	}
}

function doublequoteescape($strIn)
//Escapes "
{
	if (strlen($strIn)>0)
	{
		return str_replace('"', '&#34;', $strIn);
	}
}

function escapeslash($strIn)
//Escapes \
{
	if (strlen($strIn)>0)
	{
		return str_replace("\\", "\\" . "\\", $strIn);
	}
}

function htmlcodify($strIn)
//Changes ' to &#34;
//and parentheses to &...
{
	$out="";
	if (strlen($strIn)>0)
	{
		$out= str_replace("'",  "&#39;", $strIn);
		$out=  str_replace("(",  "&#40;", $out);
		$out= str_replace(")",  "&#41;", $out);
		return $out;
	}
}

function forinputform($strIn)
//Changes ' to &#34;
{
	if (strlen($strIn)>0)
	{
		return str_replace(chr(34),  "&#34;", $strIn);
	}
}

function deescape($strIn)
//Deescapes \'
{
	if (strlen($strIn)>0)
	{
		$strIn=str_replace("\'", "'", $strIn);
		$strIn=str_replace("\'", "'", $strIn);
		$strIn=str_replace("\\&#39;", "&#39;", $strIn);
		$strIn=str_replace("\\" . chr(34), chr(34), $strIn);
		$strIn=str_replace("\\'", "&#39;", $strIn);
		return $strIn;
	}
}


function radicaldeescapenourl($strIn)
//Deescapes \'
{
	if (strlen($strIn)>0)
	{
		$strIn=deescape($strIn);
  		$strIn=str_replace("&#40;", "(", $strIn);
  		$strIn=str_replace("&#41;", ")", $strIn);
		$strIn=str_replace("&#39;", "'", $strIn);
		$strIn=str_replace("&#34;", "\"", $strIn);
		return $strIn;
	}
}

function radicaldeescape($strIn)
//Deescapes \'
{
	if (strlen($strIn)>0)
	{
		$strIn=deescape($strIn);
  		$strIn=str_replace("&#40;", "(", $strIn);
  		$strIn=str_replace("&#41;", ")", $strIn);
		$strIn=str_replace("&#39;", "'", $strIn);
		$strIn=str_replace("&#34;", "\"", $strIn);
		$strIn=str_replace("'", "%27", $strIn);
		return $strIn;
	}
}

function deendquote($strIn)
//Removes end quotes
{
	if (substr($strIn, 0, 1)=="'")
	{
		$strIn=substr($strIn, 1, strlen($strIn));
	}
	if (substr($strIn, strlen($strIn)-1, 1)=="'")
	{
		$strIn=substr($strIn, 0, strlen($strIn)-1);
	
	}
	return $strIn;
}

function parsehyperlink($strIn, $intTruncNumber)
//Hyperlink anything in $strIn that looks like a URL.  Also cut the anchor text to $intTruncNumber length.
{
	$strHref="";
	$olderrorr=error_reporting(0);
	$intBegin=strpos(strtolower($strIn), "http://");
	$intEnd1=strpos(strtolower($strIn), " ", $intBegin+7);
	$intEnd2=strpos(strtolower($strIn), chr(34), $intBegin+7);
	$intEnd=getMin($intEnd1, $intEnd2);
	if ($intBegin==0 && $intEnd=="")
	{
		$intEnd=strlen($strIn);
	}
	if ( strlen($intBegin)>0)//total hack for the maddening php "beginning of string strpos enigma"
	{
		$strHref=substr($strIn, $intBegin, $intEnd-$intBegin);
		if ($strHref!="")
		{
			$out="<a href=\"". $strHref . "\" target=\"new\">" .  truncate($strIn, $intTruncNumber) . "</a>";
		}
		else
		{
			$out=  truncate($strIn, $intTruncNumber) ; 
		}
	}
	else
	{
		$out=  truncate($strIn, $intTruncNumber) ; 
	}
	error_reporting($olderrorr);
	return $out;
}

function striplfcr($strIn)
{
	$strIn=str_replace(chr(13), "", $strIn);
	$strIn=str_replace(chr(10), "", $strIn);
	return $strIn;
}

function simplelinkbody($strIn, $len=25)
{
	$strIn=str_replace("'", "", $strIn);
	$strIn=str_replace("\"", "", $strIn);
	$strIn=str_replace("&#39;", "", $strIn);
	$strIn=str_replace("&#34;", "", $strIn);
	$strIn=htmlcodify(truncate(strip_tags(striplfcr($strIn)), $len));
	return $strIn;
}

function killBetweenTags($oldString,  $taglist, $maxLength=9500, $begin="<", $end=">") 
//Judas Gutenberg Jan 2 2007
//gets rid of XML tags from $oldString if they are present in the space-delimited list $taglist.  also gets rid of the </XX> closer.
//this function doesn't consider whether or not content inside a node should be removed.  it just removes matching tags
//i made this function mostly to target DIVs and SPANs i didn't want in my truncated synopses.
{
	$newString = "";
	$inUnapprovedTag = false;
	$inApprovedTag=false;
   	for($i = 0; $i < strlen($oldString); $i++) 
	{
        if(substr($oldString,$i,strlen($begin)) == $begin  || ($end==""  && $inUnapprovedTag ==true) ) 
		{
			$strProspectiveTag=substr($oldString, $i + 1,getMin(strpos($oldString, " ",$i+1), strpos($oldString, ">",$i+1))-($i+1));
			//echo $strProspectiveTag . "<br>\n";
			//echo hexdump($strProspectiveTag)  . "<br>\n";
			if(inList($taglist, $strProspectiveTag) || inList($taglist, RemoveFirstCharacterIfMatch($strProspectiveTag, "/")))
			{
				$inUnapprovedTag = true;
			}
			else
			{
				$inApprovedTag=true;
			}
		}
		if(!$inUnapprovedTag)
		{ 
			$newString.= substr($oldString,$i,1);
		}
        if( substr($oldString,$i,strlen($end)) == $end  && $inUnapprovedTag ==true  && !($end==""  && $inUnapprovedTag ==true)) 
		{
			$inUnapprovedTag = false;
			//$i++;
		}
		if( substr($oldString,$i,strlen($end)) == $end  && $inApprovedTag ==true  && !($end==""  && $inApprovedTag ==true)) 
		{
			$inApprovedTag = false;
			//$i++;
		}
		//i want to bail at $maxLength, but not if we're still in a good tag
		if (strlen($newString)>$maxLength  && !$inApprovedTag)
		{
			break 1;
		}
	}
 	return $newString;
  }


function truncate($strIn, $intNumber)
//Truncates $strIn to $intNumber (more or less) at the nearest space less than $intNumber and adds ...
//I've added some code to make sure an image tag early in $strIn is shown in full, but shrunk to a thumbnail
{
	$taglist="div span DIV SPAN p br P BR strong b STRONG B i I h3 h2 h1 H1 H2 H3";
	$strIn= killBetweenTags($strIn,  $taglist, $intNumber + 10);
	//echo "+" . $strIn . "\n";
	$strLen=strlen($strIn);
	$bwlSkipElipsis=false;
	if ($strLen<$intNumber+2)
	{	
		return $strIn;
	}
	//parsehyperlink($strIn, 55);
	$intStart=$intNumber;
	for ($i=$intStart; $i>1; $i--)
	{
		if (substr($strIn, $i, 1)==" ")
		{
			$out= substr($strIn, 0, $i);
			$lespos=strrpos($out,"<");
			$grepos=strrpos($out,">");
			if (($grepos<$lespos  || $grepos === false )  && $lespos<$intNumber   &&  !($lespos === false)  )
			{
				$grepos=strpos($strIn,">", $lespos)+1;
				$out = substr($strIn, 0, $grepos);
				$out=str_replace("<img ", "<img align=\"center\" width=\"100\" height=\"80\" ", $out);
				$bwlSkipElipsis=true;
			}
			if(!$bwlSkipElipsis)
			{
				$out.="...";
			}
			break;
		}
		else if ($i<$intNumber-12)
		{
			$out = substr($strIn, 0, $intNumber-5);
			$lespos=strrpos($out,"<");
			$grepos=strrpos($out,">");
			if (($grepos<$lespos  || $grepos=="")  && $lespos<$intNumber  &&  !($lespos === false))
			{
				$grepos=strpos($strIn,">", $lespos)+1;
				$out = substr($strIn, 0, $grepos);
				$out=str_replace("<img ", "<img align=\"center\" width=\"100\" height=\"80\" ", $out);
			}
			else
			{
				$out = forinputform($out);
			}
			break;
		}
	}
	return $out;
}

function trunchandler($strIn, $intNumber, $bwlForceOutSpaces=false)
{
	if($bwlForceOutSpaces)
	{
		$strIn=ltrim(rtrim($strIn));
		$strIn=str_replace(" ", "+", $strIn);
	}
	if (strpos(ltrim(rtrim($strIn)), " ")>0)
	{
	 
		return truncate($strIn, $intNumber);
	}
	else
	{
		return parsehyperlink($strIn, $intNumber);
	}
}

	
function htmlrow($strClass)
//Produces a row for the display of data, configured now to do so in an HTML table.
//If one precedes a class name with a * then the row gets a MAtrselectfromline onclick event, which is very useful for all sorts of things
{
	$out="\n<tr";
	$bwlDontSize= false;
	$bwlHideAllButLast=false;
	$intArgs =func_num_args();
	$strPreFed="";
	//a hack allowing the dynamic pre-hiding of a row
	$bwlHideAllButLast="";
	if (beginswith($strClass, "*"))
	{
		$extraTDpairs= "onclick=\"MAtrselectfromline(this, '')\"";
		$strClass=substr($strClass,1);
	}
	elseif (beginswith($strClass, "!"))
	{
		$bwlDontSize= true;
		$strClass=substr($strClass,1);
	}
	if (contains($strClass, "hideallbutlast"))
	{
		//$out.=" \"" . $strClass . "\"";
		$bwlHideAllButLast=true;
		$strPreFed="<td " . $extraTDpairs . " id=\"killmeonexpand\" colspan=\"" . intval($intArgs-2) . "\"></td>";
	}
	elseif ($strClass!="")
	{
		$out.=" class=\"" . $strClass . "\"";
	}
	$out.=">\n";
	
	$out.=$strPreFed;
		
	for($i=1; $i<$intArgs; $i++)
	{
		$strWidth="";
		$content=func_get_arg($i);
		if (contains($content, "insert.gif"))
		{
			$strWidth="width=\"33\"";
		}
		elseif(!contains($content, "<"))
		{
			$strWidth="width=\"22%\"";
		}
		$bwlNoTD=false;
		if (contains($content, "type=\"hidden\"")  && !contains($content, "<img ")  && !(contains($content, "javascript: addfield(")))
		{
			$bwlNoTD=true;
		}
		if($bwlDontSize)
		{
			$strWidth="";
		}
		if(!$bwlNoTD)
		{
			if ($bwlHideAllButLast  && $i<$intArgs-1)
			{
				$out.="<td " . $strWidth . " " . $extraTDpairs . " valign=\"top\" style=\"display:none\">\n";
			}
			else
			{
				$out.="<td " . $strWidth . " " . $extraTDpairs . " valign=\"top\">\n";
			}
 		}
		else
		{
			$out.="<td " . $strWidth . " " . $extraTDpairs . " style=\"display:none\">";
		}
		if ($content!="")
		{
			$out.=$content;
		}
		else
		{
			$out.="&nbsp;";
		}
		$out.="</td>\n";
	}
	$out.="</tr>\n";
	return $out;
}
 
 
function replaceMultipleQueryVariables()
{
	//probably won't use this as much as linkme, since it just generates the link, not the HTML
	$strPHP=$_SERVER['PHP_SELF'];
	$intArgs =func_num_args();
	$out="";
	$arrOut=$_REQUEST;
	for($i=0; $i<$intArgs; $i=$i+2)
	{
		$var=func_get_arg($i);
		$val=func_get_arg($i+1);
		$strOut=replaceSpecificQueryVariable($var, $val, $arrOut);
		$arrOut=QuerystringToAssociativeArray($strOut);
	}
	$out=$strPHP . "?" . $strOut; 
	return $out;
}
	
function QuerystringToAssociativeArray($strIn)
//convert a querystring directly into an associative array without ever having it be an actual querystring
{
	$arrOut=array();
	$arr=explode("&", $strIn);
	foreach($arr as $a)
	{
		$arrSub=explode("=", $a);
		$arrOut[$arrSub[0]]=urldecode($arrSub[1]);
	}
	return $arrOut;
}

function linkme($strIn, $target)
//creates a hyperlink labeled with $strIn, replacing any query variables passed in additionally
{
	$strPHP=$_SERVER['PHP_SELF'];
	$intArgs =func_num_args();
	$out="";
	$arr=array();
	for($i=2; $i<$intArgs; $i=$i+2)
	{
		$var=func_get_arg($i);
		$val=func_get_arg($i+1);
		$str= replaceSpecificQueryVariable($var, $val, $arr);
		$arr =QuerystringToAssociativeArray($str);
	}
	$out=$strPHP . "?" . $str; 
	$targethtml="";
	if ($target!="")
	{
		$targethtml=" target=\"" . $target . "\"";
	}
	$out="<a" . $targethtml . " href=\"" . $out . "\">" .  $strIn . "</a>";
	return $out;
}

function replaceSpecificQueryVariable($strVariable, $strValue, $arr="")
//replaces specific associative element in an array, usually the Query String, though it can be a passed-in array of the Post array.
{
	$out="";
	$intOut=0;
	$strCharacterGlue="";
	$bwlFoundOurVariable=false;
	if (is_array($arr) && count($arr)>0)
	{
		$arrToScan=$arr;
	}
	else
	{
		if (count($_GET)==0 && count($_POST)>0)
		{
			$arrToScan=$_POST;
		}
		else
		{
			$arrToScan=$_GET;
		}
	}
	foreach ($arrToScan as $k=>$v)
	{
		if (strlen($v)<100)//keep the query string to a reasonable size in some cases
		{
			if ($intOut!=0)
			{
				$strCharacterGlue="&";
			}
			if ($k==$strVariable)
				{
					$out.= $strCharacterGlue . $k. "=" . urlencode($strValue);
					$bwlFoundOurVariable=true;
				}
			else
				{
					if(is_string($v))
					{
						$out.=$strCharacterGlue . $k. "=" . urlencode($v);
					}
				}
		}
		$intOut++;
	}
	if ($out=="")
	{
		$out=$strVariable. "=" . urlencode($strValue);
	
	}
	elseif (!$bwlFoundOurVariable)
	{
		$out.="&" . $strVariable. "=" . urlencode($strValue);
	}
	//echo "--" . $out;
	return $out;
}

function EliminateEmptyArrayPairs($arrIn)
{
	$arrOut=Array();
	foreach($arrIn as $k=>$v)
	{
		if($v!="")
		{
			$arrOut[$k]=$v;
		}
	}
	return $arrOut;
}		
	
function ZeroIfEmpty($in)
{			
	if ($in=="")
	{
		return 0;
	}
	return $in;
}

function IfAThenB($a,$b)
{			
	if ($a!="")
	{
		return $b;
	}
}

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

function CountSQLRecords($strSQLQuery)
{	
	if (strpos(strtolower($strSQLQuery), "count(")<1)
	{
		$strSQLQuery=str_replace("*", "count(*) as 'countage'", $strSQLQuery);
	}
	$sql=conDB();
	$countrecords = $sql->query($strSQLQuery);
	$countrecord=$countrecords[0];
	$intCount=$countrecord["countage"];
	return $intCount;
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

function UpdateOrInsert($strDatabase, $strTable, $arrDescribedValuePairs, $arrAlteredValuePairs, $bwlEscape=true, $bwlDebug=false)
//Does an insert or an update depending on whether or not the described record exists.  
//Make sure to not include items in $arrAlteredValuePairs that are in  $arrDescribedValuePairs.
//If there are no $arrDescribedValuePairs, they become $arrAlteredValuePairs in an INSERT.
{
	$sql=conDB();
	$strSQL="SELECT * FROM " . $strDatabase . "." .  $strTable . " WHERE ";
	//echo $strSQL . "<p>";
	$strAlterSQL="";
	$strUpdateSQL="";
	$strAlterSetSQL="";
	$bwlMustShortenByFour=false;
	if(is_array($arrDescribedValuePairs))
	{
		foreach($arrDescribedValuePairs as $k=>$v)
		{
			$bwlMustShortenByFour=true;
			$valtostore=$v;
			if($bwlEscape)
			{
	 			$valtostore= singlequoteescape($v);
			}
			if(is_array($arrAlteredValuePairs))
			{
				if(!array_key_exists($k, $arrAlteredValuePairs))
				{
					$strSQL.= " " . $k . "='" . $valtostore . "' AND";
					$strUpdateSQL.= $k . "='" . $valtostore . "',";
					$strAlterWhereSQL.=" " . $k . "='" . $valtostore . "' AND";
				}
			}
			else
			{
				$strSQL.= " " . $k . "='" . $valtostore . "' AND";
				$strUpdateSQL.= $k . "='" . $valtostore . "',";
				$strAlterWhereSQL.=" " . $k . "='" . $valtostore . "' AND";
			}
		
		}
	}
	if(is_array($arrAlteredValuePairs))
	{
		foreach($arrAlteredValuePairs as $k=>$v)
		{
			//echo $k . " " . $v . "==<br>";
			if ($k!="")
			{
				$valtostore=$v;
				if($bwlEscape)
				{
		 			$valtostore= singlequoteescape($v);
				}
				$strAlterSetSQL.= $k . "='" . $valtostore . "',";
			}
		}
	}
	//echo "strAlterSetSQL " . $strAlterSetSQL . "<p>";
	if($bwlMustShortenByFour)//gets rid of the " AND"
	{
		$strSQL= substr($strSQL, "0", strlen($strSQL)-4); 
	}
	$strAlterWhereSQL= substr($strAlterWhereSQL, "0", strlen($strAlterWhereSQL)-4); 
	$strUpdateSQL= RemoveLastCharacterIfMatch($strUpdateSQL, ",");
	$strAlterSetSQL= RemoveLastCharacterIfMatch($strAlterSetSQL, ",");
	$idInsert="";
	$bwlCanGetInsertID=false;
	$records=$sql->query($strSQL);
	//echo "count records: " . count($records) . "<br>";
	//echo "count descr val pairs: " . count($arrDescribedValuePairs) . "<br>";
	//echo "isarray descr val pairs: " . is_array($arrDescribedValuePairs) . "<br>";
	//echo "strAlterWhereSQL " . $strAlterWhereSQL . "<br>";
	//echo "strAlterSetSQL " . $strAlterSetSQL . "<p>";
	if (count($records)>0 && count($arrDescribedValuePairs)>0   && is_array($arrDescribedValuePairs) && $strAlterWhereSQL!=""  && $strAlterSetSQL!="")
	{
		//need an update
		$strSQL="UPDATE " . $strDatabase . "." .  $strTable . " SET ". $strAlterSetSQL . " WHERE " . $strAlterWhereSQL;
		 
	}
	else if (count($records)<1  ||  !is_array($arrDescribedValuePairs))
	{
		//need an insert
		$strSQL="INSERT INTO " . $strDatabase . "." .  $strTable . " SET ". $strAlterSetSQL . IfAThenB($strAlterSetSQL, ", ") . $strUpdateSQL ;
		$bwlCanGetInsertID=true;
		
	}
 
	if($strSQL!="")
	{
		$strSQL= RemoveLastCharacterIfMatch($strSQL, " ");
		$strSQL= RemoveLastCharacterIfMatch($strSQL, ",");
		//echo $strSQL . "<br>";
		if(CanChange())
		{
			$records = $sql->query($strSQL);
		}
		else
		{
			return "Database is read-only.<br/>";
		}
	
		if($bwlCanGetInsertID)
		{
			 
			$idInsert=mysql_insert_id();
		}
		if($bwlDebug=="log")
		{
			
			logmysqlerror($strSQL, true);
		}
		else if($bwlDebug  || $bwlDebug=="die")
		{
			echo "<b>" . $strSQL . "</b><br>";
			echo sql_error() . "<p>";
			if ($bwlDebug=="die")
			{
				die();
			}
		}
	}
	
	//echo $idInsert . "=<br>";
	$out= gracefuldecay(sql_error(),$idInsert) ;
	return $out;
}

function paginatelinks($intRecCount, $intRecordsPerPage, $intStartRecord, $strPHP, $strThisQVar)
//Paginates a record set
//$intRecCount is the total number of records in unpaginated record set
{
	$out="";
 	if ($intStartRecord=="")
	{
		$intStartRecord=0;
	}
	$intPages=intval(($intRecCount-1)/$intRecordsPerPage);
	if ($intPages>0)
	{
		for ($i=0; $i<=$intPages; $i++)
		{
			$url=$strPHP . "?" . replaceSpecificQueryVariable($strThisQVar, $i * $intRecordsPerPage);
			if (intval($intStartRecord)!= intval($i * $intRecordsPerPage) )
			{
				$out.="<a href=\"" . $url . "\">" .intval($i +1) . "</a>";
			}
			else
			{
				$out.=    "<b>" . intval($i +1) . "</b>";
			}
			if (($i+1)* $intRecordsPerPage<$intRecCount)
			{
				$out.= " | ";
			}
		}	
		return "Go to Page: " . $out;
	}
}

function NumToMon($intNum)
//Take a number from 1 to 12 and return a month name.
{
	$strMons="|January|February|March|April|May|June|July|August|September|October|November|December";
	$arrMons=explode("|", $strMons);
	return $arrMons[$intNum];
}

function getMax($intOne, $intTwo)
//Returns the larger of two numbers.
{
	if ($intOne>$intTwo)
	{
		$intBigger=$intOne;
	}
	else
	{
		$intBigger=$intTwo;
	}
	return $intBigger;
}
	
function getMin($intOne, $intTwo)
//Returns the smaller of two numbers.
{
	if ($intOne<$intTwo)
	{
		$intSmaller=$intOne;
	}
	else
	{
		$intSmaller=$intTwo;
	}
	return $intSmaller;
}
	
////specifically DB-related functions

function deMoronizeDB($strDB)
//Fixes idiotic dbs that contain dashes in their names. Thanks a lot, certain DB host providers!
{
	if (contains($strDB, "-")  && !contains($strDB, "`"))
	{
		$strDB="`" . $strDB . "`";
	}
	return $strDB;
}

function DuplicatesInThisField($arrIn, $strFieldName, $strValue)
{
	//scans through a mysql recordset looking to see if there are duplicates of  $strValue in a field named $strFieldName
	$found=0;
	foreach($arrIn as $row)
	{
		if ($row[$strFieldName]==$strValue)
		{
			$found++;
			if ($found>1)
			{
				return true;
			}
		}
	}
	return false;
}

function numericpulldown($intstart,$intend,$intdefault,$strName,  $bwlDontShowNone=false, $strFunction="")
//Gives me a select with numbers running from $intstart to $intend, with $intdefault selected, and names it $strName
//MARCH 17 2009:  added code to pass in a function, allowing display to be a function of the numeric to be passed in the select
{
	if($strFunction!="")
	{
		$strFunction=FixFormulaForEval($strFunction, true) . ";";
	}
	$strOut="<select  id=\"id" . $strName . "\" name=\"". $strName . "\">\n";
	if(!$bwlDontShowNone)
	{
		$strOut.="<option value=\"\">none\n";
	}
  	for ($intNumber=$intstart; $intNumber<=$intend; $intNumber++)
	{
		$strThisFunction=$strFunction;
		$strSel="";
		if (intval($intNumber)==intval($intdefault))
		{
			$strSel=" selected=\"true\" ";
		} 
		if($strFunction!="")
		{
			
			$strThisFunction=str_replace("<value/>", $intNumber, $strThisFunction);
			$strThisFunction=str_replace("<value>", $intNumber, $strThisFunction);
			$strDisplay=eval("return " . $strThisFunction. ";");
			//$strDisplay=$intNumber;
		}
		else
		{
			$strDisplay=$intNumber;
		}
		$strOut.="<option value=\"". $intNumber. "\" " . $strSel .  ">". $strDisplay ."\n";
	} 
	$strOut.="</select>"."\n";
	$function_ret=$strOut;
	return $function_ret;
} 

function datepulldowns($strNamePre,$dtmDefault, $bwlDontShowNone=false, $strFormatString="", $yearlow="", $yearhi="")
//provides a set of pulldowns to select a date
//MARCH 17 2009: $strFormatString allows changing the format of the date display
//for example "d F Y" uses PHP date function to populate the dropdowns with the correct translations of the date components
{
	$yearlow=gracefuldecaynumeric($yearlow,numrange_low,0);
	$yearhi=gracefuldecaynumeric($yearhi, numrange_hi,99);
	$datetyperelations="nFmMtn-month-1-12 jdDlNSj-day-1-31 Yoy-year-" . $yearlow . "-" . $yearhi;
	$divider="/";
	$arrDTR=explode(" ", $datetyperelations);
	$daydropdown="";
	$monthdropdown="";
	$yeardropdown="";
	$strOut="";
	$arrDatePartsIn=Array();
	if (!is_numeric($dtmDefault)  && $dtmDefault!="")
	{	
		$dtmDefault=strtotime($dtmDefault);
	}
	$strSuperPre=qpre;
	$strOut="";
	if (strlen($yearlow)==4)
 	{
		$intYear=intval($intYear);
  	}
	else
 	{
		$intYear=intval(substr($intYear,strlen($intYear)-(2)));
  	}
	if (substr($intYear,0,1)=="0")
	{
		$intYear=intval(substr($intYear,strlen($intYear)-(1)));
	} 
	//echo strlen($strFormatString);
	if(strlen($strFormatString)>1)
	{
		$endcount=strlen($strFormatString);
		$bwlStringParseMode=true;
	}
	else
	{
		$endcount=3;
		$bwlStringParseMode=false;
	}
 	for($i=0; $i<$endcount; $i++)
	{
		$thisdropdown="";
		if(!$bwlStringParseMode)
		{
			$thisDTR=$arrDTR[$i];
			$arrDPI=explode("-", $thisDTR);
			$thisFormatBundle=$arrDPI[0];
			$typeIn=substr($thisFormatBundle, 0, 1);
			$bwlFoundAMatch=true;
			$chrFormat=$strFormatString;
		}
		else
		{
			$chrFormat=substr($strFormatString, $i, 1);
			$thisDTR=$arrDTR[$i];
			$arrDPI=explode("-", $thisDTR);
			$bwlFoundAMatch=false;
			foreach($arrDTR as $oneDTR)
			{
				
				$arrOneDTR=explode("-", $oneDTR);
				if(contains($arrOneDTR[0], $chrFormat))
				{
					//echo "!<br>";
					$thisDTR=$arrOneDTR;
					$arrDPI=$arrOneDTR;
					$bwlFoundAMatch=true;
					break;
				}
			}
			$thisFormatBundle=$arrDPI[0];
			$typeIn=substr($thisFormatBundle, 0, 1);
			
		}
		if(is_numeric($dtmDefault)  && $dtmDefault!="")
		{
			$thisdatepart= date( $typeIn, $dtmDefault);
		}
		else
		{
			$thisdatepart= "";
		}
		//echo $typeIn .  " " . $thisdatepart.   " " . $dtmDefault. "\n<br>";
		if($bwlFoundAMatch)
		{
			$strFunction="";
			if(contains($thisFormatBundle,$chrFormat))
			{
				//DatePartConversion(7, "m", "m");
				// numericpulldown($intstart,$intend,$intdefault,$strName,  $bwlDontShowNone=false, $strFunction="")
				$strFunction="DatePartConversion('<value/>', '" . $typeIn . "', '" . $chrFormat . "')";
				//echo $strFunction . "<br>"; 
			}
			$thisdropdown = numericpulldown($arrDPI[2],$arrDPI[3],$thisdatepart,$strSuperPre  . $strNamePre."|" . $arrDPI[1],  $bwlDontShowNone, $strFunction);
		
			$strOut.="\n" . $thisdropdown;
		}
		if(!$bwlFoundAMatch)
		{
			$strOut.="\n" . $chrFormat;
		}
		else if(!$bwlStringParseMode)
		{
			if($i<$endcount-1)
			{
				$strOut.="\n" . $divider;
			}
		}
	}
	return $strOut;
} 

function gracefuldecaynumeric()
{
	//go through the parameters and return the first that isn't empty
	$intArgs =func_num_args();
	for($i=0; $i<$intArgs; $i++)
	{
		$option=func_get_arg($i);
		if (is_numeric($option))
		{
			return $option;
		}
	}
}

function gracefuldecaynotzero()
{
	//go through the parameters and return the first that isn't empty
	$intArgs =func_num_args();
	for($i=0; $i<$intArgs; $i++)
	{
		$option=func_get_arg($i);
		if ($option!=0)
		{
			return $option;
		}
	}
}

function boolcheck($strName,$strDefault, $bwlFriendly=false, $bwlNoForm=false,$strStyle="")
//shows a set of radio buttons for setting a boolean db value
{
	$strTrue="true";
	$strFalse="false";
	if ($bwlFriendly)
	{
		$strTrue="yes";
		$strFalse="no";
	}
	if ($bwlNoForm)
	{
		if (intval($strDefault)==1  || $strDefault==chr(1))
		{
			return $strTrue;
		}
		return $strFalse;
	}
	else
	{
		if (intval($strDefault)==1 || $strDefault==chr(1))
		{
			$out= "<input type=\"radio\" checked name=\"" . $strName . "\" value=\"1\"> "  . $strTrue ;
			$out.= "<input type=\"radio\"  name=\"" . $strName . "\" value=\"0\"> "  . $strFalse ;
		}
		else if (!($strDefault==="")  && !is_null($strDefault))
		{
			$out= "<input type=\"radio\"  name=\"" . $strName . "\" value=\"1\"> "  . $strTrue ;
			$out.= "<input type=\"radio\"  checked name=\"" . $strName . "\" value=\"0\"> "  . $strFalse ;
		}
		else
		{
			$out= "<input type=\"radio\" name=\"" . $strName . "\" value=\"1\"> "  . $strTrue ;
			$out.= "<input type=\"radio\"  name=\"" . $strName . "\" value=\"0\"> "  . $strFalse ;
		}
	}
	if ($strStyle!="")
	{
		$out= "<span style=\"" . $strStyle. "\">" . $out . "</span>";
	}
	return $out;
}

function LabelForID($strDatabase, $strTable, $strIDField, $intID)
{
	$strNameField=firstnonidcolumname($strDatabase, $strTable);
	if ( $intID!="")
	{
		$sql=conDB();
		$strSQL="SELECT " . $strNameField . " FROM " . $strDatabase . "." . $strTable . " WHERE " .  $strIDField . " = " . $intID;
		$records = $sql->query($strSQL);
		if ($records)
		{
			//echo"@";
			$record=$records[0];
			return $record[$strNameField];
		}
	}
}
	
function foreigntablepulldown($strDatabase, $strTable, $strIDField, $intDefault, $strLabelField="", &$namereturn, $bwlHiddenReturn=false, $strPreferredNameField="", $styleclass="")
//Gives me a select named $strIDField of ids with rows from $strTable, defaulted to $intDefault
//$namereturn, passed by reference, allows me to hand back the selected string label of the pulldown, which is won at considerable
//computative effort
//bwlHiddenReturn allows me to pass the actual string value of the dropdown in a specially-labeled hidden field.
{
	$sql=conDB();
	$strHiddenExtra="";
	$strNameField2="";
	$strNameField="";
	$moreflag=false;
	if ($strLabelField=="")
	{
		$strLabelField= $strIDField;
	}
	$strOut="<select id=\"id" . $strLabelField  . "\" " . $styleclass . " name=\"" . $strLabelField . "\"";
	if ($bwlHiddenReturn)
	{
	
		$strOut.=" onchange=\"document.BForm." . qpre . "multi.value=document.BForm." .  $strLabelField . "[document.BForm." .  $strLabelField . ".selectedIndex].text\"";
	}
	$strOut.= ">"."\n";
	$strOut.="<option value=".chr(34).chr(34).">none"."\n";
	if ($strPreferredNameField=="")
	{
		$strNameField=firstnonidcolumname($strDatabase, $strTable);
		$strNameField2 = NthNonIDColumName($strDatabase, $strTable, 2);
		//kind of hacky but hey, we need more info:
		$firstIDNotPK=NthIDColumName($strDatabase, $strTable,2);
	}
	else
	{
		$strNameField = $strPreferredNameField;
	}
	$strSQL="SELECT * FROM " . $strDatabase . "." . $strTable;
	if ($strNameField!="")
	{
		$strSQL.=" ORDER BY " . $strNameField;
	}
	if ($strNameField2!="")
	{
		$strSQL.=", " . $strNameField2;
	}
	//echo $strSQL;
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
			 $strLabel2 = $k[$strNameField2];
			if ($strLabel2=="")
			 {
			 	$strLabel2=$k[$firstIDNotPK];
			 }
			 $strLabel= $strLabel1;
			 if($strOldLabel==$strLabel1 )
			 {
			 	$moreflag=true;
			 }
			 if ((strlen($strLabel1)<15 && $strLabel2!="" && !(strlen($strLabel2)>15))   && ($strNameField2!="password") || $moreflag)
			 {
			 	$strLabel=$strLabel1  . " : " . $strLabel2;
			 }
			 $strOldLabel=$strLabel1;
			 $strSel="";
			 if ($k[$strIDField]==$intDefault)
			 {
			   $strSel=" selected=\"true\" ";
			   $namereturn=$strLabel;
			   if ($bwlHiddenReturn)
			   {
			   	$strHiddenExtra="<input type=\"hidden\" name=\"" .$strFieldNamePrefix  . qpre . "multi\"   value=\"".  $strLabel . "\">\n";
			   
			   }
			 } 
			$strOut=$strOut."<option value=\"". $k[$strIDField] . "\" " . $strSel .  ">". truncate($strLabel, 35) ."\n";
			
			// $arrOut[$strLabel]=$k[$strIDField];
		} 
		if ($strHiddenExtra=="" && $bwlHiddenReturn)
		{
			$strHiddenExtra="<input type=\"hidden\" name=\"" .$strFieldNamePrefix  . qpre . "multi\"   value=\"\">\n";
		}
	}
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

function FieldCount($strDatabase, $strTable)
//Returns the number of columns in a table.
{
	$records = DBExplain($strDatabase, $strTable);
	return count($records);
}

function MaxColNameLength($strDatabase, $strTable)
//Returns the length in characters of a table's column names.  Will return table's name if it's longest
{
	$records = DBExplain($strDatabase, $strTable);
	$maxlen=strlen($strTable);
	foreach ($records as $k => $info )
	{
		 $len=strlen($info["Field"]);
		 if($len>$maxlen)
		 {
		 	$maxlen=$len;
		 } 
	}
	return $maxlen;
}

function countrecords($strDatabase , $strTable )
//Returns the number of records in a table.
{
	$sql=conDB();
	$countrecs = $sql->query("SELECT COUNT(*) FROM " . $strDatabase . "." . $strTable ); 
	$countrec=$countrecs[0];
	$count=$countrec["COUNT(*)"];
	return $count;
}

function PercentageOfNotNullsInTable($strDatabase, $strTable)
{
//September 14, 2008
//this function is, of necessity, super expensive!
//returns an associative array of percentages of not nulls for each field
//so you can tell the relative utility of the fields in actual practice
	$sql=conDB();
	$records = DBExplain($strDatabase, $strTable);
	$arrOut=Array();
	$total=countrecords($strDatabase, $strTable);
	foreach ($records as $k => $info)
	{
		$strField= $info["Field"];
		$strSQL="SELECT count(" . $strField .") AS result FROM " . $strDatabase . "." .  $strTable . " WHERE " . $strField . "!=\"\"";
		//echo $strSQL . "<br>";
		$records = $sql->query($strSQL);
		$record=$records[0];
		$val=$record["result"];
		//$total=$record["total"];
		if($total>0)//don't divide by zero
		{
			$percent=intval($val/$total * 100);
		}
		else
		{	
			$percent=0;
		}
		
		if (!is_numeric($percent)  || $percent=="")
		{
			$percent="0";
		}
		$arrOut[$strField]=$percent;
	}
	return $arrOut;
}

function FleshedOutFKSelect($strDatabase, $strTable, $additionalClauses, &$arrDesc, $strUnnecessaryJoinTables="", $bwlKeepPKs=false, $bwlIncludeAllRelatedFields=false)
//Delivers the SQL to do a select from a table with the necessary joins so that instead of foreign key ids we get
//fields populated with readable strings
//ALSO: returns an array by reference containing types, because this is essential info for a lot of what this SQL is used to do
//Judas Gutenberg 2007-2-1
{
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
			$nameColumn=firstnonidcolumname($strDatabase, $record["f_table_name"]);
			$strNameAdditional="";
			//in some cases the foreign table's field name isn't specific enough in the join to be a proper label
			//so in those cases i append the table name to the front of the fieldname to make it into a proper label
			if($nameColumn=="name")
			{
				$strNameAdditional=" as `" . $record["f_table_name"] . "_" . $nameColumn . "`";
			}
			$arrDesc[$nameColumn]= GetFieldType($strDatabase, $record["f_table_name"], $nameColumn);
			if($bwlIncludeAllRelatedFields)
			{
				$leafrecords = DBExplain($strDatabase,$record["f_table_name"]);
				foreach($leafrecords as $kl=>$vl)
				{
					$strPreJoinSQL.=" x".$count . "." . $vl["Field"]  . ","   ;
					
				}
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
	$records=DBExplain($strDatabase, $strTable);
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
	$out="SELECT DISTINCT " . $goodFieldList .  IFAthenB(($strPreJoinSQL  && $goodFieldList),", ") . $strPreJoinSQL  ." FROM " .  $strTable . " t " . $strJoinSQL . " " .   " " . $additionalClauses . " GROUP BY " . $strPK ;
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
	$records=DBExplain($strDatabase, $strTable);
	$intFindCount=1;
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
	$records=DBExplain($strDatabase, $strTable);
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
	$records=DBExplain($strDatabase, $strTable);
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

function PKLookup($strDatabase, $strTable)
//Looks up the PK for a table.
{
	$records=DBExplain($strDatabase, $strTable);
	foreach ($records as $k => $v )
	{
		if ($v["Key"]=="PRI")
		{
			$out.= " ". $v["Field"];
		}
	}
	return trim($out);
}


function RelationLookup($strDatabase, $strTable, $strColumn, $intType=0)
//Looks up the multi-table info given a column
{
		$sql=conDB();
		$records = $sql->query("SELECT column_name, f_table_name, f_column_name FROM " . $strDatabase . "." . tfpre . "relation WHERE table_name='" . $strTable . "' AND column_name='" . $strColumn . "'  AND relation_type_id=" . $intType);
		$count=0;
		foreach ($records as $record)
		{
			return array( $record["f_table_name"],  $record["f_column_name"]) ;
			$count++;
		}
}

function NewRelation($strDatabase, $linkertable, $linkerfield, $linkeetable, $linkeefield, $type=0)
{
//creates a new relation if one matching the spec doesn't exist
	$sql=conDB();
	$out="";
	$strExistSQL="SELECT table_name FROM " . $strDatabase . "." .  tfpre . "relation WHERE table_name='" . $linkertable . "' AND column_name='" . $linkerfield . "' AND f_table_name='" . $linkeetable . "' AND f_column_name='" . $linkeefield . "' AND relation_type_id='" . $type . "'";
	//echo  "<br>" .$strExistSQL . "<br>";
	$tables = $sql->query($strExistSQL);
	$out.= sql_error();
	//echo count($tables) . "<br>";
	if(count($tables)<1)
	{
		$strSQL="INSERT INTO " . $strDatabase . "." .  tfpre . "relation(table_name, column_name, f_table_name, f_column_name, relation_type_id) VALUES ('" .  $linkertable . "','" . $linkerfield  ."','" .  $linkeetable . "','" . $linkeefield  ."'," . $type .");";
		$tables = $sql->query($strSQL);
		$out.= sql_error();	
	}
	else
	{
		$out.= "<br/>Needed relation already exists:" . $linkertable . "." .$linkerfield . "->" . $linkeetable . "." . $linkeefield . ":" . $type;
	}
	//echo $out;
	return $out;
}
	
function firstforeignkeycolumn($strDatabase, $strTable, $strMappedTableToAvoid)
//In which i make a reasonable guess of where a mapping table maps to
//returns a three-member array, with [0]the field name and [1] the mapped table and [2] the mapped column
//I pass in $strMappedTableToAvoid to avoid mapping off to the table I'm starting from
//modified for MySQL 2-7-06
{
	return  Nthforeignkeycolumn($strDatabase, $strTable, $strMappedTableToAvoid, 1);
}

function Nthforeignkeycolumn($strDatabase, $strTable, $strMappedTableToAvoid, $n)
//In which i make a reasonable guess of where a mapping table maps to
//returns a three-member array, with [0]the field name and [1] the mapped table and [2] the mapped column
//I pass in $strMappedTableToAvoid to avoid mapping off to the table I'm starting from
//modified for MySQL 2-7-06
{
	$sql=conDB();
	$records = $sql->query("SELECT * FROM " . $strDatabase . "." . tfpre . "relation WHERE table_name='" . $strTable . "'  AND relation_type_id=0");
	$count=0;
	$right=0;
	foreach ($records as $record)
	{
		if ( $record["f_table"] != $strMappedTableToAvoid  )
		{
			//echo $k . "->" . $v .  "<br>";
			$right++;
			if ($n==$right)
			{
				return array(  $record["column_name"], $record["f_table_name"],  $record["f_column_name"],  $record["display_column_name"]) ;
			}
			
		}
		$count++;
	}
}
	
function highestprimarykey($strDatabase, $strTable)
//I want the max PK id for a table.
//I didn't know that PHP has built-in support for this functionality when I wrote this.
//actually, though, this function does something somewhat different from PHP's mysql_insert_id functionality
//because it allows me to go in and find the largest PK value in a table to which nothing was added
//modified sept 2 2008 to deal with compound pks, returning null in that case
{
	$sql=conDB();
	$out="";
	$records=DBExplain($strDatabase, $strTable);
	foreach ($records as $k => $v )
	{
		if ($v["Key"]=="PRI")
		{
			if($out!="")
			{
				return; //return null if we have two PKs
			}
			$strSQL="SELECT MAX(" . $v["Field"]. ") FROM " . $strDatabase . "." .  $strTable;
			$orecords=$sql->query($strSQL);
			$orecord =$orecords[0];
			$out= $orecord["MAX(" . $v["Field"]. ")"];
		}
	}
	return $out;
}

function FieldExists($strDatabase, $strTable, $strFieldName)
//Does this field exist in this table?
{
	$records=DBExplain($strDatabase, $strTable);
	foreach ($records as $k => $v )
	{
		if ($v["Field"]==$strFieldName)
		{
			return  true;
		}
	}
	return false;
}

function RowExists($strDatabase, $strTable, $strFieldName, $ID)
//Does this ID exist in this table in this field?
{
	$sql=conDB();
	$strSQL="SELECT " .  $strFieldName . " FROM " . $strDatabase . "." .  $strTable . " WHERE " . $strFieldName . "='" . $ID . "'";
	$records = $sql->query($strSQL);
 	if (count($records)>0)
	{
		return true;
	}
	return false;
}

function GetFieldType($strDatabase, $strTable, $strFieldName)
//Give me the type of a column
{
	$records=DBExplain($strDatabase, $strTable);
	foreach ($records as $k => $v )
	{
		if ( $v["Field"]==$strFieldName)
		{
			return  $v["Type"];
		}
	}
}

function DBExplain($strDatabase, $strTable, $bwlFollowRelations=false)
//explains the columns across several tables linked by relations in the relation table or do a simple explain
{
	$sql=conDB();
	$arrOut=Array();
	if($bwlFollowRelations)
	{
		$strSQL="SELECT * FROM " . $strDatabase . "." . tfpre . "relation WHERE relation_type_id=0 AND table_name='" . $strTable . "'";
		$records = $sql->query($strSQL);
		foreach($records as $record)
		{
			$strThisTable=$record["f_table_name"];
			$trecords = $sql->query("EXPLAIN " . $strDatabase . "." . $strThisTable);
		 	$arrOut=array_merge($arrOut, $trecords);
		}
	}
	$records = $sql->query("EXPLAIN " . $strDatabase . "." . $strTable);
	$arrOut=array_merge($arrOut, $records);
	return $arrOut;
}

function GetFieldTypeArray($strDatabase, $strTable)
//Give me the types of a columns for a table as an array.
{
	$arrOut=Array();
	$records=DBExplain($strDatabase, $strTable);
	foreach ($records as $k => $v )
	{
		$arrOut[$v["Field"]]= $v["Type"];
	}
	return $arrOut;
}

function generateFieldTypeArray($strDatabase, $strTable)
//Returns an associative array keyed to the names of columns containing types.
//nov 2006
{
	$arrFieldType=array();
	$descr=DBExplain($strDatabase, $strTable);
	foreach ($descr as $nom=>$info)
	{
		$strName=$info["Field"];
		$strType=TypeParse($info["Type"], 0);
		$arrFieldType[$strName]=$strType;
		
	}
	return $arrFieldType;
}

function countforeignkeycolumns($strDatabase, $strTable, $strMappedTableToAvoid)
//For counting all the foreign keys except to the one to avoid
//Useful for seeing whether it's best to not treat a mapping table as such
{
	$sql=conDB();
	$strSQL="SELECT COUNT(*) as 'table_count' FROM " .  $strDatabase . "." . tfpre . "relation  WHERE table_name  = '" .  $strTable . "' AND relation_type_id=0";
	$records = $sql->query($strSQL);
 	$record=$records[0];
	return $record["table_count"];
}
	
	
function nonuseridnonPKIDcolumn($strDatabase, $strTable)
//Return the first int column that isn't userid or PK.
{
	$records=DBExplain($strDatabase, $strTable);
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
	$strFieldName="Tables_in_" . str_replace("`", "", $strDatabase);
	$strSQL="INSERT INTO " . $strDatabase  . "." . tfpre . "dbdiff(diff_performed) VALUES('" . DateTimeForMySQL(date("F j Y g:i a")) . "')";
	$rs = $sql->query($strSQL);
	$id=mysql_insert_id();
	foreach ($tables as  $k=>$v )
	{
		$tablename=$v[$strFieldName];
		$count = countrecords($strDatabase , $tablename );
		$checksum=tablechecksum($strDatabase , $tablename );
		$highestpk=highestprimarykey($strDatabase, $tablename);
		$strSQL="INSERT INTO " . $strDatabase  . "." . tfpre . "dbdiff_table(dbdiff_id, table_name, table_rowcount, table_checksum, max_id) VALUES('" . $id . "','" . $tablename . "','" . $count . "','" . $checksum  . "','" . $highestpk . "')";
		$rs = $sql->query($strSQL);
		//echo $strSQL . " " . sql_error() . "<p>";
	}
 
	return "Database state saved.";
}
	
function hasautocount($strDatabase, $strTable)
//Does the table have an autocount column?
{
	$records=DBExplain($strDatabase, $strTable);
	$count=0;
	foreach ($records as $k => $v )
	{
		if ($v["Extra"]=="auto_increment") 
		{
			return true;
		}
	}
	return false;
}
	
function  TypeParse($strIn, $intPart)
//Parse mysql types into the basic type ($intPart=0) and whatever descriptive numerics follow ($intPart=1).
{
	$strIn=str_replace(" ","", $strIn);
	$strIn=str_replace("(","|", $strIn);
	$strIn=str_replace(")","|", $strIn);
	$arrIn=explode("|", $strIn);
	return $arrIn[$intPart];
}

function ReturnNonIDPartOfName($strIn)
//This function only works in a DB with strict adherence to the _id naming convention.
{
	if (contains($strIn, "_"))
	{
		$arrIn=explode("_", $strIn);
		for($i=0; $i<count($arrIn); $i++)
		{
			if (strtolower($arrIn[$i])!="id")
			{
				$out.=$arrIn[$i] . " ";
			
			}
		}
	}
	else
	{
		$out=$strIn;
	}
	return $out;
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

function data($strIn,$intTypeIn, $intTypeOut, $strTranslate)
//Using a double-delimited list $strTranslate of the form field1a|field2a|field3a-field1b|field2b|field3b-field1c...
//you can retrieve the field number $intTypeOut in the record containing the first match of $strIn to the field specified by
//$intTypeIn. if $intTypeIn is -1 then it returns a field from the record number specified by $strIn
//this serves as very nice bare-bones database retrieval system
{
	$strOut=genericdata($strIn,$intTypeIn, $intTypeOut, $strTranslate, "-", "|");
	return($strOut);
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

function GenericDataPulldown($strConfig, $intIDField, $intLabelField, $strQueryVariableName, $strDefault, $strPHP, $strFormName, $strConnector ="?", $bwlAcceptWild=true, $strEmptyText="-none-", $rowdelimiter="-", $fielddelimiter="|", $strExtraValPairs="")
//From a double-delimited -| string, generate a dropdown
//$bwlAcceptWild allows it to add items at the bottom found in the wild but not in the config string
{
	$intTop=-1;
	$strOut="";
	if ($strConfig!="")
	{
		if (strpos($strConfig, $fielddelimiter) >0)
		{
			$intTop=count(explode($fielddelimiter, $strConfig));
		}
	}
	if (($strPHP!="") and ($strFormName!="")) 
	{
		$strOut= "\n<select " . $strExtraValPairs ." id=\"id" . $strQueryVariableName . "\" name=\"" . $strQueryVariableName . "\" onChange=\"window.document.location.href='" . $strPHP . $strConnector . $strQueryVariableName . "=' + document." . $strFormName . "." . $strQueryVariableName . "[document." . $strFormName . "." . $strQueryVariableName . ".selectedIndex].value\">\n";
}
	else
	{
		$strOut="\n<select " . $strExtraValPairs ." id=\"id" . $strQueryVariableName . "\"  name=\"" . $strQueryVariableName . "\">\n";
	}
	$strOut.= "<option value=\"\" >" . $strEmptyText ."\n" ;
 	$bwlFoundOne=false;
	for ($t=0; $t<$intTop; $t++)
	{
		$strSel="";
		$strThisIdentifier = genericdata($t,-1,$intIDField,$strConfig,$rowdelimiter,$fielddelimiter);
		$strLabel=genericdata($t,-1,$intLabelField,$strConfig,$rowdelimiter,$fielddelimiter);
 		
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

function DatePartConversion($in, $strTypeIn, $strTypeOut)
//March 17, 2009:
//converts one type of a date component into another 3 can become "March" for example.
//(see PHP date function for documentation of the characters or typein/out.
{
	$tempdate=ReplaceUnitInDate(time(), $in, $strTypeIn);
	$out=date($strTypeOut, $tempdate);
	return $out;
}


function ReplaceUnitInDate($date, $value, $type)
//March 17, 2009: replaces just the $type in $date with $value
{	
	$strConfig="H|i|s|n|j|Y";
	if ($type=="W")
	{
		$unit=$unit*7;
		$type="d";
	}
	$arrConfig=explode("|", $strConfig);
	$strAction="mktime(";
	for ($i=0; $i<count($arrConfig); $i++)
	{
		
		if ($type==$arrConfig[$i])
		{
			$strAction.=$value;
		}

		else
		{
			$strAction.="date(\"" . $arrConfig[$i] . "\", " . $date . ")";
			 
		}
		if($i<count($arrConfig)-1)
		{
			$strAction.=",";
		}
	}
	$strAction.=");";
	//echo $strAction . "<br>\n";
	$out=eval("return " . $strAction);
	return($out);
}

function ReasonableStringDate($m, $d, $y)
{
	$y=intval($y);
	if (strlen($y+ " ")<4)
	{
		if ($y<50)
		{
			$y=2000+$y;
		}
		else
		{
			$y=1900+$y;
		}
	}
	return     $y . "/" . $m . "/" . $d;

}

function flipyear($strDate)
{
//for taking m/d/y and making it y/m/d
	$datearray=getdate(strtotime($strDate));
	$month=$datearray["mon"];
	$year=$datearray["year"];
	$day=$datearray["mday"];
	return $year . "/" . $month . "/" . $day;
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

function TableExists($strDatabase, $strTable)
//Does the table exist?
{
    $likeclause="LIKE '" .  $strTable . "'";
	$rs=TableList($strDatabase, $likeclause);
	if (count($rs)<1)
    {
		return(false);
    }
	else 
	{
		return(true);
	}
}

function FieldDropdown($strDatabase, $strTable, $strFieldFormName, $strDefault)
//Creates a dropdown of column names for a table.
{
	$records=DBExplain($strDatabase, $strTable);
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
		$out.="onChange=\" field=document." . $strOurFormName . "." .  $strTableFormName . "[document." . $strOurFormName . "." .   $strTableFormName. ".selectedIndex].text; frames['ajax'].location.href='fielddump.php?" . qpre . "db=" . $strDatabase . "&" . qpre . "formname=" . $strOurFormName . "&" . qpre . "table=' + field + '&" . qpre . "fieldformname=" .   $strFieldFormName ."'\";"; 
	}
	$out.=">\n";
	$out.="<option value=''>none</option>\n";
	$tables=TableList($strDatabase);
	$strFieldName="Tables_in_" . str_replace("`", "", $strDatabase);
	foreach ( $tables as  $k=>$v )
	{
		$tablename= $v["Tables_in_" . str_replace("`", "", $strDatabase)];
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

function LookupName($strDatabase, $strTable, $strIDField, $strID, $strNameColumn="")
//Your basic lookup of a name given a table, idfield, and id
//As of Dec 18th, 2007, accepts a $strNameColumn in cases where this is known
{
	$sql=conDB();
	$strSQL="SELECT * FROM " . $strDatabase . "." .  $strTable . " WHERE " .  $strIDField . " = " . $strID;
	//echo "<font color=0000000>" .  $strSQL . "<br>";
	if ($strTable !="")
	{
		$records = $sql->query($strSQL);
		$record=$records[0];
		if($strNameColumn=="")//more complex if you don't have the name column of course
		{
			$strNameField1=NthNonIDColumName($strDatabase, $strTable, 1);
			$strNameField2 = NthNonIDColumName($strDatabase, $strTable, 2);
			//echo $firstnonidcolumn  . "<br>";
		 	//echo $strNameField1 . " " . $strNameField2 . "<br>";
			//fancy code to get text from two fields when one isn't sufficient
			$strLabel1 = $record[$strNameField1];
			$strLabel2 = $record[$strNameField2];
		 	//echo $strLabel1 . " " . $strLabel2  . "<br>";
			
			if ((strlen($strLabel1)<16 && $strLabel2!="" && !(strlen($strLabel2)>14)))
			 {
			 	$strLabel=$strLabel1  . " : " . $strLabel2;
			 }
			else
			{
			 	$strLabel=$strLabel1 ;
			}
		}
		else//you have a name column, so it's easy
		{
			$strLabel=$record[$strNameColumn];
		}
	}
	return $strLabel;
}

function GenericDBLookup($strDB, $strTable, $strIDFieldName, $strThisID, $strResultFieldName, $bwlDebug=false, $bwlWorkUntilFound=true)
{
	if($strThisID!="")
	{
		return GenericDBLookupWhere($strDB, $strTable,   $strIDFieldName . " = '" . $strThisID . "'", $strResultFieldName, $bwlDebug);
	}
}

function GenericDBLookupLast($strDB, $strTable, $strIDFieldName, $strThisID, $strResultFieldName, $bwlDebug=false, $bwlWorkUntilFound=true)
{
	$pk=PKLookup($strDB, $strTable);
	return GenericDBLookupWhere($strDB, $strTable,   $strIDFieldName . " = '" . $strThisID . "' ORDER BY " .  $pk. " DESC", $strResultFieldName, false);
} 

function GenericDBLookupWhere($strDB, $strTable, $strWhereClause, $strResultFieldName="", $bwlDebug=false, $bwlWorkUntilFound=true)
//modified 10-2-2007 to allow for the returning of a whole row
{
	$sql=conDB();
	$fieldtosearchfor=$strResultFieldName;
	if($strResultFieldName=="")
	{
		$fieldtosearchfor="*";
	}
	$strSQL="SELECT " . $fieldtosearchfor . " FROM " . $strDB . "." . $strTable . " WHERE " . $strWhereClause;
	if($bwlDebug)
	{
		echo $strSQL;
	}
	$records = $sql->query($strSQL);

	$record = $records[0];
	//this part of the code keeps scanning through the data until a valid record is found
	if (count($records)>1 && $bwlWorkUntilFound  && $strResultFieldName!="")
	{
		foreach($records as $record)
		{
			if($record[$strResultFieldName]!="")
			{
				return $record[$strResultFieldName];
			}
		}
	}
	if($strResultFieldName=="")
	{
		return $record;
	}
	return $record[$strResultFieldName];
}

function GenericDBLookupFromArray($strDB, $strTable, $arrSpec, $strResultFieldName, $bwlDebug=false, $bwlWorkUntilFound=true)
{
 	$strWhereClause=ArrayToWhereClause($arrSpec);

	return GenericDBLookupWhere($strDB, $strTable, $strWhereClause, $strResultFieldName, $bwlDebug, $bwlWorkUntilFound);
}

 
///////////////////////////////////////
/////////User functions///////////////
/////////////////////////////////////

function WhoIsLoggedIn()
{
	global $COOKIE_VARS;
	$x="";
	$a=GetLoginTableArray();
	$strCookieVal= subtractletters( $_COOKIE[$a["cookie"]], encryptionkey);
	//echo          $a["cookie"] . " " . $strCookieVal;
	
	if(authtype!="xcart"  || !defined("authtype"))
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
	//overwrite defaults as needed
	$arrOut["table"]= IfDefinedThenSet("authentication_table", $arrOut["table"]);
        $arrOut["user_pk"]= IfDefinedThenSet("user_pk", $arrOut["user_pk"]);
	$arrOut["username"]= IfDefinedThenSet("username", $arrOut["username"]);
	$arrOut["password"]= IfDefinedThenSet("password", $arrOut["password"]);
	$arrOut["cookie"]= IfDefinedThenSet("cookie", $arrOut["cookie"]);
	$arrOut["authtype"]= IfDefinedThenSet("authtype", $arrOut["authtype"]);
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
		if ($record[$a["password"]]==$strPassword and $strPassword!="")
		{
			$out=true;
		}
	}
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
	if(authtype!="xcart"  || !defined("authtype"))
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
	$out="";
	$out.="<table class=\"loginTable\">\n";
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
	$out.="</table >\n";
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
		logform();
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
	if (TableExists($strDatabase, tfpre . "permission") && TableExists($strDatabase, $a["table"])  || superuserexplicit) //if no admin tables, everyone is an admin!
	{
		$sql=conDB();
		$strSQL="SELECT  * from  " . $strDatabase . "." . $a["table"] . " WHERE " . $a["username"] . " = '" . $strAdmin . "'";
		$records = $sql->query($strSQL);
		if (count($records)>0)
		{
			$record=$records[0];
		 
		 	$out=false;
			if ($record["is_superuser"]==1)
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
	return $out;
}

function IsSuperAdmin($strDatabase, $strAdmin)
//Is this TF user a super admin?  This is the highest level of power in the system.
{
	$a=GetLoginTableArray();
	$sql=conDB();
	if(TableExists($strDatabase, $a["table"]))
	{
		$strSQL="SELECT  * from  " . $strDatabase . "." . $a["table"] . " WHERE is_superadmin = 1";
		$records = $sql->query($strSQL);
		if (count($records)>0  && (authtype!="xcart"  || !defined("authtype")))  //if there are no superadmins then everyone is a superadmin!
		{
			
			$strSQL="SELECT  is_superadmin from  " . $strDatabase . "." . $a["table"] . " WHERE " . $a["username"]. " = '" . $strAdmin . "'";
			//echo $strSQL;
			$records = $sql->query($strSQL);
			$record=$records[0];
		 
		 	$out=false;
			if ($record["is_superadmin"]==1)
			{
				$out=true;
			}
		}
		else if(authtype=="xcart")
		{
			$strSQL="SELECT   usertype from  " . $strDatabase . "." . $a["table"] . " WHERE usertype='P' AND " . $a["username"]. " = '" . $strAdmin . "'";
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
	MakeTableIfNotThere($strDatabase, tfpre . $strTable, "MakeScriptLogTable");
	$strExistScript="SELECT pre_script, post_script FROM " . $strDatabase . "." . tfpre . $strTable . " WHERE type='" . $type . "' ORDER BY " . $strTable ."_id DESC LIMIT 0,1";
	$exist =  $sql->query($strExistScript);
	$exist=$exist[0];
	//echo $exist["sql_string"] . "=<p>" . $strSQL. "=<p>" ;
	if($exist["pre_script"]!=$strThisScript || $exist["post_script"]!=$strPostRunScript)
	{
		// str_replace("'", "\\'", $strSQL)  //maybe need this sometimes
		$strLogScript="INSERT INTO " . $strDatabase . "." . tfpre .  $strTable . "(pre_script, post_script, type, time_executed) VALUES('" . addslashes($strThisScript) . "','" . addslashes($strPostRunScript) . "','" . $type . "','" . date("Y-m-d H:i:s") . "')";	
		//echo $strLogSQL. "<P>";
		$recs =  $sql->query($strLogScript);	
		if (sql_error())
		{
			dropTable($strDatabase, tfpre .  $strTable);
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
		$strSQL="SELECT id_range_lowend, id_range_highend FROM " . $strDatabase . "." . tfpre . "permission WHERE admin_id = " . $UserID . " AND  table_name='" . $strTable . "'";
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
	$strSQL="SELECT permission_type_id as 'p', id_range_lowend, id_range_highend FROM  " . $strDatabase . "." . tfpre . "permission p LEFT JOIN " . $strDatabase . "." . tfpre . "admin a ON p.admin_id=a.admin_id WHERE a.username = '" . $strAdmin . "' AND p.table_name='" . $strTable . "'";
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
	$strSQL="SELECT " .$a["user_pk"] . " FROM  " . $strDatabase . "." . $a["table"] . "  WHERE " . $a["username"]. " = '" . $strAdmin . "'";
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
	if (strpos($strTestPath, ".jpg")>1  || strpos($strTestPath, ".gif")>1 || strpos($strTestPath, ".swf")>1)
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
	$out.= "<script src=\"tablesort_js.js\"><!-- --></script>";
	$tableheader="<table id=\"idsorttable99\" class=\"bgclassline\" cellpadding=\"0\" cellspacing=\"1\" border=\"0\" width=\"800\">\n";
	$out.=$tableheader;
	if (is_dir($strPath))
	{
		$dh  = opendir($strPath);
		while (false !== ($filename = readdir($dh))) 
		{
		  		$files[] = $filename;
		}
		rsort($files);
		$out.=htmlrow("bgclassline", "<a href=\"javascript: SortTable('idsorttable99', 0)\">SQL File</a>", "<a href=\"javascript: SortTable('idsorttable99', 1)\">last edited</a>", "<a href=\"javascript: SortTable('idsorttable99', 2)\">size</a>" );
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
	
	$out.="</table>";
	$out.="<script>NumberRows('idsorttable99', 1);</script>";
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
 
function PictureIfThere($strPath, $intWidth, $intHeight="", $border=" ", $url="")
//If there is a picture at $strPath this will generate the HTML to display it.
{
	//GLOBAL $vertoffsetvalue; //i want to KILL Bill Gates!!!!!!!
	//if($vertoffsetvalue=="")
	//{
	//	$vertoffsetvalue=0;
	//}
	$strTestPath=strtolower($strPath);
	if (file_exists($strPath))
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
		if (!file_exists($strPathOut))
		{
			if ($strPathOut!="")
			{
				if (strpos("---" . $arrPath[$i], ".")>0)
				{
				//don't add a file or folder if this item contains a "."
				}
				else
				{
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

/////////////////
///encryption///
///////////////

function addletters($in, $key, $mode="")
//converts numbers into a letter stream
{
	$out="";
	$in=$in."";
	while (strlen($key)<strlen($in))
	{
		$key.=$key;
	}
	if($mode=="numeric")
	{
		for ($i=0; $i<strlen($in); $i++)
		{
			$intchrIn=ord(substr($in, $i, 1));
			$intchrKey=ord(substr($key, $i, 1));
			$out=$out. " " . intval($intchrIn + $intchrKey);
		}
		$out=trim($out);
	}
	else
	{
		for ($i=0; $i<strlen($in); $i++)
		{
			$intchrIn=ord(substr($in, $i, 1));
			$intchrKey=ord(substr($key, $i, 1));
			$out=$out. chr($intchrIn + $intchrKey);
		}
	}
	return $out;
}

function subtractletters($in, $key, $mode="")
//converts numbers into a letter stream
{
	$out="";

	while (strlen($key)<strlen($in))
	{
		$key.=$key;
	}
	if($mode=="numeric")
	{
		$arrThis=explode(" ", $in);
		for ($i=0; $i<count($arrThis); $i++)
		{
			$intchrIn=$arrThis[$i];
			$intchrKey=ord(substr($key, $i, 1));
			$out=$out. chr($intchrIn - $intchrKey);
		}
	}
	else
	{
		for ($i=0; $i<strlen($in); $i++)
		{
			$intchrIn=ord(substr($in, $i, 1));
			$intchrKey=ord(substr($key, $i, 1));
			$out=$out. chr($intchrIn - $intchrKey);
		}
	}
	return $out;
}


function wordencode($intNumber, $intDigits, $rndhelp)
//Encodes a number as a sequence of words.  
//Depends on a table called word_coding with a column of words called "word"
{
	$out="";
	$that="";
	$strNumber=str_pad($intNumber, $intDigits, "0", STR_PAD_LEFT);
	for($i=0; $i<$intDigits; $i=$i+3)
	{
		$that=substr($strNumber, $i, 3);
		{
			$thisnumber=intval($that);
			if ($thisnumber==0)
			{
				srand((double)$rndhelp); 
				$thisnumber = rand(0,40)+1000; 
			}
			$word=GenericDBLookup(our_db,  "word_coding", "word_coding_id", $thisnumber, "word");
			$out.=$word . " ";
		}
	}
	$out=RemoveEndCharactersIfMatch($out, " ");
	return $out;
}


function worddecode($strPhrase)
//Decodes a phrase created by wordencode
//Depends on a table called word_coding with a column of words called "word."
{
	$strPhrase=strtolower($strPhrase);
	$strPhrase=str_replace("-", " ", $strPhrase);
	$strPhrase=str_replace("=", " ", $strPhrase);
	$strPhrase=str_replace(".", " ", $strPhrase);
	$strPhrase=str_replace(",", " ", $strPhrase);
	$strPhrase=str_replace(":", " ", $strPhrase);
	$strPhrase=str_replace(";", " ", $strPhrase);
	$arrPhrase=explode(" ", $strPhrase);
	$out="";
	$that="";
	$strNumber=str_pad($intNumber, $intDigits, "0", STR_PAD_LEFT);
 
	for($i=0; $i<count($arrPhrase); $i++)
	{
		$that=$arrPhrase[$i];
		if ($that!="")
		{
			$thisnumber=GenericDBLookup(our_db,  "word_coding", "word", $that, "word_coding_id");
			if ($thisnumber<1000)
			{
				$intDigits=str_pad($thisnumber,3, "0", STR_PAD_LEFT);
				$intDigits=intval($intDigits);
			}
			else
			{
				$intDigits="000";
			}
			$out.=$intDigits;
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
 
function TotalDelete($strDatabase, $strTable, $strPK, $strPKColumn="")
//December 26 2007 - deletes a row and then all related rows following the contents of the relation table.
{
	$sql=conDB();
	if($strPKColumn=="")
	{
		$strPKColumn=PKLookup($strDatabase, $strTable);
	}
	$out="";
	$strSQL="DELETE FROM " . $strDatabase . "." . $strTable . " WHERE " . $strPKColumn . "='" . $strPK . "'";
	$records = $sql->query($strSQL);
	if(sql_error()=="")
	{
		$out.="A row was deleted from the " . $strTable . " table in the " . $strDatabase . ".<br/>";
	}
	$strSQL="SELECT * FROM " . $strDatabase . "." . tfpre . "relation WHERE f_table_name='" . $strTable . "' AND f_column_name='" . $strPKColumn . "'";
	//echo $strSQL  ."<br>";
	if(CanChange())
	{
		$records = $sql->query($strSQL);
	}
	else
	{
		$out.=  "Database is read-only.<br/>";
	} 
				
	$records = $sql->query($strSQL);
	foreach($records as $record)
	{
		$thistable=$record["table_name"];
		$thiscolumn=$record["column_name"];
		if($strPK!=0)
		{
			$strSQL="DELETE FROM " . $strDatabase . "." . $thistable . " WHERE " . $thiscolumn . "='" . $strPK . "'";
			//echo $strSQL  ."<br>";
			if(CanChange())
			{
				$records = $sql->query($strSQL);
				if(sql_error()=="")
				{
					$out.="Rows were deleted from the " . $thistable . " table in the " . $strDatabase . ".<br/>";
				}
			}
			else
			{
				$out.=  "Database is read-only.<br/>";
			} 
			
		}
	}
	return $out;
}

function CanChange()
{
	if(defined("mode"))
	{
		if(contains(mode, 'readonly'))
		{
			return false;
		}
	}
	return true;
}

function rowdelete($strDatabase, $strTable,  $idfield, $id, $strUser, $arrPK="")
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
	return $out . "<br/>";
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

function logmysqlerror($strSQLin="", $bwlMakeTableIfNecessary=false, $error="")
{
	$strTable="mysql_errorlog";
	$strDatabase=our_db;
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
			$records = $sql->query($strSQL);
		}
	}
	
	if(TableExists($strDatabase, $strTable))
	{
		UpdateOrInsert($strDatabase, $strTable, "", Array("ip_address"=>$_SERVER['REMOTE_ADDR'], "time_done"=> date("Y-m-d H:i:s"), "mysql_error"=>$error, "info"=>mysql_info(), "sql_query"=>$strSQLin));
	}
}

function logform($bwlMakeTableIfNecessary=true)
{
	logcollection($bwlMakeTableIfNecessary, $_REQUEST, "request");
}

function logcollection($bwlMakeTableIfNecessary=true, $collection, $label="", $comments="")
{
	$strTable="formlog";
	$strDatabase=our_db;
	$strSQL="
		CREATE TABLE `" . $strTable ."` (
		`" . $strTable ."_id` int(11) NOT NULL auto_increment,
		`time_done` timestamp NULL default NULL,
		`ip_address` varchar(33) default NULL,
		`referer` varchar(211) default NULL,
		`label` varchar(222) default NULL,
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
		UpdateOrInsert($strDatabase, $strTable, "", Array("comments"=>$comments, "label"=>$label,"referer"=>$referer, "ip_address"=>$_SERVER['REMOTE_ADDR'], "time_done"=> date("Y-m-d H:i:s"), "form_content"=>$content));
	}
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
   
function CountOccurence($strIn, $strSought)
{
//counts instances of $strSought in $strIn
	$intOut=0;
   	for($i = 0; $i < strlen($strIn)+1; $i++) 
	{
		$thisChar=substr($strIn,$i,strlen($strSought));
 		if($thisChar==$strSought)
		{
			$intOut++;
			$i=$i+strlen($strSought)-1;
		}
	}
	return $intOut;
}

function FixFormulaForEval($strFormula, $bwlLeaveDollars=false)
{
	$strFormula=str_replace("&#40;",  "(", $strFormula);
	$strFormula=str_replace("&#41;",  ")", $strFormula);
	$strFormula=str_replace("&#63;",  "?", $strFormula);
	$strFormula=str_replace("&#39;",  "'", $strFormula);
	$strFormula=str_replace("&#lt;",  "<", $strFormula);
	$strFormula=str_replace("&#gt;",  ">", $strFormula);
	$strFormula=str_replace("&lt;",  "<", $strFormula);
	$strFormula=str_replace("&gt;",  ">", $strFormula);
	if(!$bwlLeaveDollars)
	{
		$strFormula=str_replace("$",  "", $strFormula);
	}
	$strFormula=str_replace("\'",  "'", $strFormula);
	return $strFormula;
}

//Done with functions - now it is time to include extra include files
 

if (defined("extrainclude"))
{
	if(!defined("tf_dir"))
	{
		define("tf_dir","");
	}
	$arrExtrainclude=explode("|",extrainclude);
	//hack hack hackity hack hack hack
	//$olderrorr=error_reporting(255);
 
	$strPHPSelf=  $_SERVER['PHP_SELF'];
	//echo "-" . $strPHPSelf ."-";
	$intUplevel=0;
	//echo (tf_dir);
	///extra extra extra hacky!!
	if(contains($strPHPSelf, "moodle"))
	{
		define("tf_dir","");
		$strNewTFDir="";
	}
 
	else if(tf_dir=="/")
	{
		
		$intUplevel=CountOccurence($strPHPSelf, "/")-1;
		$strNewTFDir="";
		//such a stupid hack around basedir restrictions!
		for($i=0; $i<$intUplevel; $i++)
		{
			$strNewTFDir.="../";
		}
		 
		 
	}
	else
	{
		$strNewTFDir=tf_dir;
	}
	//HACKTACULAR!!!
	$strNewTFDir=$strNewTFDir. ".";
	define("tf_dir",$strNewTFDir);
	//echo $strNewTFDir;
	for($i=0; $i<count($arrExtrainclude);$i++)
	{	
		//echo tf_dir . $arrExtrainclude[$i] . "<br>";
		//if($bwlPossiblyComeUpALevel  && 
		if(file_exists($strNewTFDir . $arrExtrainclude[$i]))
		{
	
			include($strNewTFDir . $arrExtrainclude[$i]); 
		}
		else if(file_exists($arrExtrainclude[$i]))
		{
			include $arrExtrainclude[$i]; 
		}
	}
	//error_reporting($olderrorr);
}

?>