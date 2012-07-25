<?php
//searches Featurewell.com using fulltext index on the mysql copy of the article table
//judas gutenberg feb 19-20 2010
$strPathPre="tf/";

include($strPathPre . "tf_constants.php");
//echo tf_dir;
include($strPathPre . "tf_functions_core.php");
  
include($strPathPre . "tf_functions_editor.php");
include($strPathPre . "tf_functions_frontend_db.php");

include($strPathPre . "tf_functions_backup.php");
include_once($strPathPre . "tf_functions_odbc.php");
include_once($strPathPre . "fw_functions.php");

$errorlevel=error_reporting(0);
//include($strPathPre . "editor_files/config.php");
//include($strPathPre . "editor_files/editor_class.php");
set_time_limit(22);
error_reporting($errorlevel);
$urlroot="http://www.featurewell.com/";

$mode=$_REQUEST["mode"];
$category_id=$_REQUEST["category_id"];
$fields=gracefuldecay($_REQUEST["FIELDS"], "*");
$age=$_REQUEST["AGE"];
$searchterm=$_REQUEST["SEARCH"];
;
$ouruserid=$_COOKIE["FW_USERID"];
$userrs=GenericDBLookup(our_db, "USERS", "ID", $ouruserid);
$ourusername=$userrs["FIRST_NAME"] . " " . $userrs["LAST_NAME"];

if($ouruserid!="")
{
	$loginpiece="  Welcome	" . $ourusername ."<BR>";
	$loginpiece.="<A href=\"" . $urlroot. "?Doc=Signout.cfm\"><U>Sign out</U></A>";
}
else
{
	$loginpiece="<A href=\"" . $urlroot. "?Doc=Signin.cfm\"><U>Sign in</U></A>";
}
$arrForm=$_POST;
if($mode=="advanced")
{
	$title="Advanced Search";
}
else
{
	$title="Search Results";
}

//-----------------------------------------------------------------------
include("header.php");

if($searchterm=="")
{
	echo AdvancedSearchForm($searchterm, $category_id, $age, $fields);
}
else
{
	echo SearchResult($searchterm, $urlroot, $category_id, $age, $fields);
}
include("footer.php");
//------------------------------------------------------------------------
function  SearchResult($searchterm , $urlroot, $category_id, $age, $fields)
{
	$out="";
	$sql=conDB();
	$intRecordsPerPage=10;
	$intStartRecord=gracefuldecaynumeric($_REQUEST["rec"],0);
	//$strSQL="SELECT * FROM article WHERE ID<43";
	//$searchterm="iraq";
	//$strSQL="SELECT  *, a.ID as ARTICLE_ID, count(a.ID) as totalcount  FROM article a JOIN USERS u ON a.AUTHOR_ID=u.ID JOIN CATEGORY c ON a.CATEGORY_ID=c.ID  WHERE MATCH(TEXT) AGAINST ('" .$searchterm . "' in boolean mode)  order by a.TIMESTAMP desc LIMIT 0,10";
	$listSQL="*, a.ID as ARTICLE_ID";
	$countSQL="COUNT(*) as totalcount  ";
	$strAgeWhere="";
	$strCatWhere="";
	if($category_id!="")
	{
		$strCatWhere=" AND a.CATEGORY_ID='" . $category_id . "' ";
	}
	if($age!="")
	{
		$strAgeWhere=" AND DATEDIFF(NOW(),a.LOADED_DATE)<='" . $age . "' ";
	}
	//$strRConfig="TITLE|Headline-TEXT|Text-WRITER|Writer-*|All";
	if($fields=="" || $fields=="*" )
	{
		$fields="TEXT, FT_WRITER, TITLE";
	}
	else if($fields=="WRITER")
	{
		$fields="FT_WRITER";
	}
	//echo "-" . $fields . "-";;
	//$strRootSQL=" FROM article a JOIN USERS u ON a.AUTHOR_ID=u.ID LEFT JOIN CATEGORY c ON a.CATEGORY_ID=c.ID  WHERE MATCH(" . $fields. ") AGAINST ('" .singlequoteescape($searchterm) . "' in boolean mode)   " . $strCatWhere  . " " . $strAgeWhere. " order by a.TIMESTAMP desc ";
	$strRootSQL=" FROM " . our_db .".article a JOIN " . our_db .".USERS u ON a.AUTHOR_ID=u.ID LEFT JOIN " . our_db .".CATEGORY c ON a.CATEGORY_ID=c.ID  WHERE MATCH(" . $fields. ") AGAINST ('" .singlequoteescape($searchterm) . "' in boolean mode)   " . $strCatWhere  . " " . $strAgeWhere. " AND u.ACTIVE=1 order by a.LOADED_DATE desc ";
	//echo "SELECT " .$countSQL .  $strRootSQL;
	$records = $sql->query("SELECT " .$countSQL .  $strRootSQL, true, our_db);
	echo mysql_error();
	$resultcount=count($records); //should be no more than $intRecordsPerPage

	$record=$records[0];
	$totalcount=$record["totalcount"];
	//no more than 100 results returned
	if($totalcount>100)
	{
		$totalcount=100;
	}
	$strSQL="SELECT " .$listSQL .  $strRootSQL  . " LIMIT " . $intStartRecord ."," .  $intRecordsPerPage;
	//echo $strSQL . "<BR>";
	$records = $sql->query($strSQL, true, our_db);
	echo mysql_error();
	$resultcount=count($records);
	$resout="";
	$header="";
	foreach($records as $record)
	{
		$title=$record["TITLE"];
		$article_id=$record["ARTICLE_ID"];
		$writer=$record["FT_WRITER"];
		$subject=$record["SUBJECT"];
		$author_id=$record["AUTHOR_ID"];
		$firstname=$record["FIRST_NAME"];
		$lastname=$record["LAST_NAME"];
		$cat_name=$record["NAME"];
		$notes=$record["NOTES"];
		//$notes="";//turned off because that's how DRWALLIS wants it
		$wordcount=$record["WORD_COUNT"];
		$resout.="<tr>\n";
    	$resout.="<td width=\"100%\">\n";
		$resout.="<table BORDER=\"0\" CELLPADDING=\"0\" CELLSPACING=\"0\" width=\"100%\">\n";
		$resout.="<tr valign=\"top\" width=\"100%\">\n";
	    $resout.="<td VALIGN=\"top\">\n";
	    $resout.="<A HREF=\"" . $urlroot. "?AID=" . $article_id . "&Search=" . $searchterm ."\" CLASS=\"ListTitle\">" .$title . "</A>\n";
	    $resout.="<br CLEAR=\"none\"/>\n";
		$resout.="<font class=\"ListByLine\">by&nbsp;\n";
		$resout.="<A HREF=\"" . $urlroot. "/WID="  . $author_id . "\" CLASS=\"ArticleWriter\">" . $firstname . " " . $lastname . "</A>,\n";
	    $resout.=$wordcount . "&nbsp;words\n";
		$resout.="<br CLEAR=\"none\"/><font CLASS=\"ListNotes\">" . $notes. "</font>\n";
		$resout.="</font>\n";
	    $resout.="<font class=\"ListSubject\">\n";
	    $resout.="<br CLEAR=\"none\"/>\n";
		$resout.="<b>" . $cat_name . ":</b> \n";
	    $resout.=$subject . "\n";
	  	$resout.="<a HREF=\"" . $urlroot. "?AID=" . $article_id . "&Search=" . $searchterm ."\"><u>Full&nbsp;story...</u></a>\n";
	    $resout.="</font>\n";
		$resout.="</td>\n";
		$resout.="</tr>\n";
		$resout.="</table>\n";
		$resout.="</td>\n";
		$resout.="</tr>\n";
      	$resout.="<TR><TD class=\"VerticalSpacer\">&nbsp;</TD></TR>\n";
	}

  	$header.="<table BORDER=\"0\" CELLPADDING=\"0\" CELLSPACING=\"0\" width=\"100%\">\n";
	$header.="<tr valign=\"top\">\n";
	$header.="<td width=\"100%\">\n";
	$maxpage= intval(ceil($totalcount/$intRecordsPerPage));
	$thisonpage=intval(ceil($intStartRecord/$intRecordsPerPage));
	if($maxpage>0 && $thisonpage==0)
	{
		$thisonpage=1;
	}
	$header.="<B>" . $totalcount . " " . PluralizeIfNecessary("article", $totalcount) . "  found. Page " . $thisonpage. " of " . $maxpage . ".</B>\n";
	$header.="<hr noshade size=\"1\" ALIGN=\"center\"/>\n";
	$header.="</td>\n";
	$header.="</tr>\n";
	
	$out=$header. $resout . "</table>\n";
	$out.=FWpaginatelinks($totalcount, $intRecordsPerPage, $intStartRecord,"sitesearch.php", "rec");;;
	//$out="result";
	return $out;
}

function AdvancedSearchForm($searchterm, $category_id, $age, $fields="*")
{
	// $category_id="";
	//$age=100000;
	$out="";
	$strTimespanConfig="30|Past 30 Days-183|Past 6 Months-366|Past Year-100000|Full Archive";
 
	$out.="<form name=\"SearchForm\" id=\"SearchForm\" action=\"sitesearch.php\" method=\"POST\" onsubmit=\"return _CF_checkSearchForm(this)\">\n";
	$out.="<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\">\n";
	$out.="<TR align=\"center\"><TH><FONT SIZE=\"+1\">Search Featurewell's archive</FONT></TH></TR>\n";
	$out.="<TR><TD>&nbsp;</TD></TR>\n";
	$out.="<TR><TD>&nbsp;</TD></TR>\n";
	$out.="<TR align=\"center\">\n";
	$out.="<TD WIDTH=\"60%\">\n";
	$out.="<TABLE class=\"Instructions\">\n";
	$out.="<TR><TD align=\"left\">Sample:</TD><TD>Search for Around the World in Eighty Days</TD></TR>\n";
	$out.="<TR><TD align=\"left\" WIDTH=\"80\">Exact&nbsp;Phrase:</TD><TD><FONT class=\"Highlight\">&quot;Eighty Days&quot;</FONT> finds the whole phrase,\n"; 
	$out.="<I>Eighty Days</I>, in between the quotes.</TD></TR>\n";
	$out.="<TR><TD align=\"left\">Prioritize:</TD><TD><FONT class=\"Highlight\">+World</FONT> returns articles with the term <I>World</I>, displayed more prominently in the results.</TD></TR>\n";
	$out.="<TR><TD align=\"left\">Startswith:</TD><TD><FONT class=\"Highlight\">Eigh*</FONT> finds words starting with <I>Eigh</I>, for instance: Eight, Eighty.</TD></TR>\n";
	$out.="<TR><TD align=\"left\" VALIGN=\"top\">Exclude:</TD><TD><FONT class=\"Highlight\">Around -World</FONT> finds articles which include the term <I>Around</I>, but not those that also contain the term <I>World</I>.</TD></TR>\n";
	$out.="</TABLE>\n";
	$out.="</TD>\n";
	$out.="<TR><TD>&nbsp;</TD></TR>\n";
	$out.="<tr align=\"center\"> \n";
	$out.="<td>\n";
	$out.="<input name=\"SEARCH\" id=\"Search\"  type=\"text\" size=\"40\"  /><br>\n";			
	$out.=" </td>\n";
	$out.="</tr>\n";
	$out.="<TR align=\"center\" CLASS=\"Instructions\">\n";
	$out.="<TD>\n";
	$strRConfig="TITLE|Headline-TEXT|Text-WRITER|Writer-*|All";
	$out.= RadioDataArray($strRConfig, 0,1,"FIELDS", $fields);
	$out.="</TD>\n";
	$out.="</TR>\n";
	$out.="<TR><TD>&nbsp;</TD></TR>\n";
	$out.="<TR align=\"center\" CLASS=\"Instructions\">\n";
	$out.="<TD>In category<BR>\n";
	// foreigntablepulldown($strDatabase, $strTable, $strIDField, $intDefault, $strLabelField="", &$namereturn, $bwlHiddenReturn=false, $strPreferredNameField="", $addedselectpairs="", $strWhereClause="")
	$catdropdown=str_replace(">none", ">All", foreigntablepulldown(our_db,  "CATEGORY", "ID", $category_id, "category_id", $namereturn, false, "NAME"));
	$out.=$catdropdown;
	$out.="</TD>\n";
	$out.="</TR>\n";
	$out.="<TR><TD>&nbsp;</TD></TR>\n";
	$out.="<TR align=\"center\" CLASS=\"Instructions\">\n";
	$out.="<TD>Publication Date<BR>\n";
	// GenericDataPulldown($strConfig, $intIDField, $intLabelField, $strQueryVariableName, $strDefault="", $strPHP="", $strFormName="", $strConnector ="?", $bwlAcceptWild=true, $strEmptyText="-none-", $rowdelimiter="-", $fielddelimiter="|", $strExtraValPairs="")
	$out.= GenericDataPulldown($strTimespanConfig, 0, 1, "AGE", gracefuldecaynumeric($age, 100000));
	$out.="</TD>\n";
	$out.="</TR>\n";
	$out.="<TR><TD>&nbsp;</TD></TR>\n";
	$out.="<TR align=\"center\" CLASS=\"Instructions\">\n";
	$out.="</TR>\n";
	$out.="<TR><TD>&nbsp;</TD></TR>\n";
	$out.="<TR align=\"center\">\n";
	$out.="<input type=\"hidden\" name=\"mode\" value=\"advanced\">\n";
	$out.="<TD><input type=\"Submit\" name=\"SUBMIT\" value=\"Search\"></TD>\n";
	$out.="</TR>\n";
	$out.="</table>\n";
	$out.="</form>\n";
	return $out;
}

function FWpaginatelinks($intRecCount, $intRecordsPerPage, $intStartRecord, $strPHP, $strThisQVar)
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
 ?>
