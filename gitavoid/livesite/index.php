<?php
require("scriptheader.php");
require("frontendheader.php");
set_time_limit(900);
ini_set("memory_limit","22M");

$writerinfo="";
if($mode=="bookmark")
{
	$strSQL="SELECT  WORD_COUNT,  a.ID as ARTICLE_ID,  a.CATEGORY_ID, a.TITLE, a.NOTES, a.SUBJECT, u.FIRST_NAME, u.LAST_NAME, a.AUTHOR_ID  FROM " . articletable . " a JOIN USERS u ON a.AUTHOR_ID=u.ID  JOIN BOOKMARK b ON a.ID=b.ARTICLE_ID   WHERE b.USER_ID =" .intval( $user["ID"]) . " AND a.ACTIVE=1 AND u.ACTIVE ORDER BY a.TIMESTAMP DESC ";
}
else if($writer_id!="")
{
	$strSQL="SELECT * FROM USERS  WHERE ACTIVE=1  AND ID=" . intval($writer_id);
	//echo "<script>alert('" . $strSQL . "');</script>";
	$records = $sql->query($strSQL);
	$record=$records[0];
 	$writerinfo="";
	$writerinfo.= "<div class='leaftitle'>" . $record["FIRST_NAME"] . " " . $record["LAST_NAME"]  .  "</div>";
	$writerinfo.=   "<div class='leafbody'>"  . fw_textprocess($record["BIO"]) . "</div><br>";
	$writerinfo.= "<div class='articlebottomlistheader'>Articles by " . $record["FIRST_NAME"] . " " . $record["LAST_NAME"] . "</div><br/>";
	$strSQL="SELECT a.ID as ARTICLE_ID,  a.WORD_COUNT , a.CATEGORY_ID, a.TITLE, a.NOTES, a.SUBJECT, u.FIRST_NAME, u.LAST_NAME,  a.AUTHOR_ID   FROM " . articletable . " a JOIN USERS u ON a.AUTHOR_ID=u.ID   WHERE a.AUTHOR_ID =" .intval( $writer_id) . " AND a.ACTIVE=1 ORDER BY a.TIMESTAMP DESC ";
}
else if($searchterm!="")
{
	$intStartRecord=gracefuldecaynumeric($_REQUEST["r"],0);
	$listSQL=" a.ID as ARTICLE_ID,   WORD_COUNT,  a.CATEGORY_ID, a.TITLE, a.NOTES, a.SUBJECT, u.FIRST_NAME, u.LAST_NAME, a.AUTHOR_ID  ";
	$countSQL="COUNT(*) as totalcount  ";
	$strAgeWhere="";
	$strCatWhere="";
	if($category_id!="")
	{
		$strCatWhere=" AND (c.ID='" . $category_id . "' OR a.CATEGORY_ID=" . intval($category_id) . ")";
	}
	if($searchage!="")
	{
		$strAgeWhere=" AND DATEDIFF(NOW(),a.LOADED_DATE)<='" . $searchage . "' ";
	}

	if($searchfields=="" || $searchfields=="*" )
	{
		$searchfields="TITLE, FT_WRITER, TEXT";
	}
	else if($searchfields=="WRITER")
	{
		$searchfields="FT_WRITER";
	}

	$strRootSQL=" FROM " . our_db ."." . searchtable ." a JOIN " . our_db .".USERS u ON a.AUTHOR_ID=u.ID LEFT JOIN " . our_db .".CATEGORY c ON a.CATEGORY_ID=c.ID  WHERE MATCH(" . $searchfields. ") AGAINST ('" .singlequoteescape($searchterm) . "' in boolean mode)   " . $strCatWhere  . " " . $strAgeWhere. " AND u.ACTIVE=1 AND  a.ACTIVE=1  order by a.LOADED_DATE DESC ";
	$strSQL="SELECT " .$listSQL .  $strRootSQL;

	//echo $strSQL;
}
else if(intval($category_id)<1   )
{
	$strSQL="SELECT  WORD_COUNT,  a.ID as ARTICLE_ID, a.CATEGORY_ID, a.TITLE, a.NOTES, a.SUBJECT, u.FIRST_NAME, u.LAST_NAME, a.AUTHOR_ID FROM " . articletable . " a JOIN USERS u ON a.AUTHOR_ID=u.ID  WHERE  a.ACTIVE=1 AND u.ACTIVE  ORDER BY IFNULL(a.LATEST,0) DESC, a.TIMESTAMP DESC    ";
	//echo "<script>alert('" . $strSQL . "');</script>";
}
else
{
	//$strSQL="(SELECT distinct  a.TIMESTAMP as TS, a.LATEST, a.ID as ARTICLE_ID,  a.CATEGORY_ID, a.TITLE, a.NOTES, a.SUBJECT, u.FIRST_NAME, u.LAST_NAME , a.AUTHOR_ID FROM article a JOIN USERS u ON a.AUTHOR_ID=u.ID left JOIN ARTICLE_CATEGORY c ON c.ARTICLE_ID=a.ID WHERE  c.CATEGORY_ID=" . intval($category_id) . "   AND a.ACTIVE=1 AND u.ACTIVE  ORDER BY LATEST DESC, TS DESC LIMIT 0,15) UNION DISTINCT (SELECT distinct a.TIMESTAMP as TS, a.LATEST, a.ID as ARTICLE_ID,  a.CATEGORY_ID, a.TITLE, a.NOTES, a.SUBJECT, u.FIRST_NAME, u.LAST_NAME , a.AUTHOR_ID FROM " . articletable . " a JOIN USERS u ON a.AUTHOR_ID=u.ID left JOIN ARTICLE_CATEGORY c ON c.ARTICLE_ID=a.ID WHERE  a.CATEGORY_ID=" . intval($category_id) . "   AND a.ACTIVE=1 AND u.ACTIVE  ORDER BY LATEST DESC, TS DESC LIMIT 0,15) ORDER BY LATEST DESC, TS DESC ";
	$strSQL="SELECT DISTINCT WORD_COUNT,  a.TIMESTAMP as TS, a.LATEST, a.ID as ARTICLE_ID,  a.CATEGORY_ID, a.TITLE, a.NOTES, a.SUBJECT, u.FIRST_NAME, u.LAST_NAME , a.AUTHOR_ID FROM " . articletable . " a JOIN USERS u ON a.AUTHOR_ID=u.ID left JOIN ARTICLE_CATEGORY c ON c.ARTICLE_ID=a.ID WHERE  c.CATEGORY_ID=" . intval($category_id) . "   AND a.ACTIVE=1 AND u.ACTIVE  ORDER BY IFNULL(LATEST,0) DESC, TS DESC ";
}
if($_REQUEST["sql"]=="show")
{
	echo $strSQL;
}

//make the sql leaner before performing a count query
$strExtraFields=parseBetween($strSQL, "SELECT ", "FROM") ;
$strExtraFields=RemoveFirstCharacterIfMatch($strExtraFields, "DISTINCT");
$strOrderBy=parseBetween($strSQL, "ORDER BY ", "") ;
$SQLForCount=str_replace($strExtraFields, " a.ID ", $strSQL);
$SQLForCount=str_replace("ORDER BY " . $strOrderBy, "  ", $SQLForCount);
//echo $SQLForCount;
$records = $sql->query($SQLForCount, true, our_db);
$resultcount=count($records);
//echo $resultcount;
if($searchterm!="")
{
	UpdateOrInsert(our_db, "search", "", Array("result_count"=>$resultcount, "timestamp"=> $nowdatetime, "search_string"=>$searchterm, "user_id"=>$user["ID"], "fields"=>$searchfields, "daterange"=>$searchage));
}
if($resultcount>100)
{
	$resultcount=100;
}
$strSQL.="LIMIT " . $intStartRecord ."," .  $intRecordsPerPage;
$out="";
$outcount=0;
$cols=2;
$records = $sql->query($strSQL);
$pre="";
$pre.="<tr>\n";
$pre.="<td valign='top'>\n";
$pre.=$writerinfo;
$pre.="<table   width=\"700\">\n";
$pre.="<tr><td valign='top'>\n";
$tablerowcount=0;
$firstrow=true;
if($mode=="bookmark")
{
	$out.="<form name='BMForm' method='post' action='" . $homepage . "'>\n" ;
	$out.="<input name='mode' type='hidden' value='bookmark'>\n" ;
}
$lastrow=false;
if($searchterm!="" && count($records)==0)
{
	$out.="<div class='instructions'>Your search produced no results.</div>";
}
foreach($records as $record)
{
	if($outcount>count($records)-($cols+1))
	{
		$lastrow=true;
	}
	$float="left";
	if(($outcount/$cols)==intval($outcount/$cols) && $outcount>0 )
	{
		if($firstrow)
		{
			//$out.="<x/>";
		}
		//$out.="</tr><tr>";
		$tablerowcount++;
		$firstrow=false;
	}
	$topofsubsequentcolumn=false;
	if($outcount==count($records)/2)
	{
		$out.="<x/>";
		$topofsubsequentcolumn=true;
	}
	//$out.="<td valign='top'  >\n";
	$out.="<div  class='listblock'   >\n";
	$thisnumber="";
	if($searchterm!="")
	{
		$thisnumber=intval($outcount + 1 + $intStartRecord) . ". ";
	}


	$out.=CategoryIcons($record["ARTICLE_ID"], $record["CATEGORY_ID"], true, $caticons, $outcount);
	//$out.="<img class='caticon' style='margin:10px' src='images/cat" . $record["CATEGORY_ID"] . ".png' align=\"left\">\n";
	if($record["WORD_COUNT"]>20)
	{
		 $wordcountindicatiomn=", " .  $record["WORD_COUNT"]  . " WORDS";
	}
	else
	{
		$strText=GenericDBLookup(our_db, articletable, "ID", intval($record["ARTICLE_ID"]), "TEXT");;
 		$wordcount=WordCount($strText);
		//echo "<SCRIPT>alert(" . $wordcount . ")</SCRIPT>";
		$strSQL="UPDATE " . our_db . "." . articletable . " SET WORD_COUNT=" .$wordcount  . " WHERE ID=" .$record["ARTICLE_ID"];
		$sql->query($strSQL);
	
	}
	$out.="<div class='listtitle'><a class='listtitle'  href=\"article.php?ID=" .  $record["ARTICLE_ID"] . "\">" . $thisnumber .  strtoupper($record["TITLE"]) . "</a></div>\n";
	$out.="<div class='listbyline'><a  class='listbyline'  href='" . $homepage . "?i=6&w=" . $record["AUTHOR_ID"].  "'>" . strtoupper($record["FIRST_NAME"] . " " . $record["LAST_NAME"]) . "</a>" . $wordcountindicatiomn . "</div>\n";
	$strViewedIndication="";
	if(HaveViewed($record["ARTICLE_ID"],  $user["ID"])>0)
	{
		$strViewedIndication="<span class='haveviewedlist'>(Viewed) &nbsp;</span>";
	}
	$out.="<div class='listsubject'>"  . $strViewedIndication.  $record["SUBJECT"] . "</div>\n" ;
	$out.="<div class='listnotes'>"  .$record["NOTES"] . "</div><br>\n";

	if($mode=="bookmark")
	{
		$out.="<div align='right' class='listsubject'><input type='checkbox' name='delbookmark[]' value='" .$record["ARTICLE_ID"] . "'></div>\n" ;
	}
 	//if($outcount>0 && !$topofsubsequentcolumn)
	{
		$out.="<div class='listrule'></div>\n" ;
	}
	if($lastrow)
	{
 		//$out.="<div class='listrule'></div>\n" ;
	}
	$out.="</div>";
	//$out.="</td>\n";
	$outcount++;
	
}
$vertdivider= "</td><td rowspan='" . intval($tablerowcount + 1 ) . "' style='background-image:url(images/VerticalDottedRule.jpg);width:36px;background-repeat:repeat-y; '>&nbsp;&nbsp;</td><td valign='top'>\n";
$out=str_replace("<x/>", $vertdivider, $out);
$out =$pre  .  $out .  "</td></tr>\n";
$out.="</table>\n";
if($mode=="bookmark")
{
	$out.="<div align='right' class='instructions-right'>These are your personal Featurewell bookmarks. Check off bookmarks to delete and click submit: <a href='javascript:document.BMForm.submit()'><br><img id='g3' src=\"images/submitbutton.png\"   alt='Submit' border='0'></a></div><br/></form>\n" ;
}
$out.=   FWRedesignPaginate($resultcount, $intRecordsPerPage, $intStartRecord, $homepage, "r");
$out.="</td>\n";
$out.="</tr>\n";

echo $out;
require("frontendfooter.php");

?>
