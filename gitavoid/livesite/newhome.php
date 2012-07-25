<?php
require("scriptheader.php");
require("frontendheader.php");
set_time_limit(900);
ini_set("memory_limit","22M");

$writerinfo="";
if($mode=="bookmark")
{
	$strSQL="SELECT a.ID as ARTICLE_ID,  a.CATEGORY_ID, a.TITLE, a.NOTES, a.SUBJECT, u.FIRST_NAME, u.LAST_NAME  FROM article a JOIN USERS u ON a.AUTHOR_ID=u.ID  JOIN BOOKMARK b ON a.ID=b.ARTICLE_ID   WHERE b.USER_ID =" .intval( $user["ID"]) . " AND a.ACTIVE=1 ORDER BY a.TIMESTAMP DESC ";
}
else if($writer_id!="")
{
	$strSQL="SELECT * FROM USERS  WHERE ACTIVE=1 AND ID=" . intval($writer_id);
	//echo "<script>alert('" . $strSQL . "');</script>";
	$records = $sql->query($strSQL);
	$record=$records[0];
 	$writerinfo="";
	$writerinfo.= "<div class='leaftitle'>" . $record["FIRST_NAME"] . " " . $record["LAST_NAME"]  .  "</div>";
	$writerinfo.=   "<div class='leafbody'>"  . fw_textprocess($record["BIO"]) . "</div>";
	$writerinfo.= "<div class='articlebottomlistheader'>Articles by " . $record["FIRST_NAME"] . " " . $record["LAST_NAME"] . "</div>";
	$strSQL="SELECT a.ID as ARTICLE_ID,  a.CATEGORY_ID, a.TITLE, a.NOTES, a.SUBJECT, u.FIRST_NAME, u.LAST_NAME  FROM article a JOIN USERS u ON a.AUTHOR_ID=u.ID   WHERE a.AUTHOR_ID =" .intval( $writer_id) . " AND a.ACTIVE=1 ORDER BY a.TIMESTAMP DESC ";
}
else if($searchterm!="")
{
	$intStartRecord=gracefuldecaynumeric($_REQUEST["r"],0);
	$listSQL=" a.ID as ARTICLE_ID,  a.CATEGORY_ID, a.TITLE, a.NOTES, a.SUBJECT, u.FIRST_NAME, u.LAST_NAME ";
	$countSQL="COUNT(*) as totalcount  ";
	$strAgeWhere="";
	$strCatWhere="";
	if($category_id!="")
	{
		$strCatWhere=" AND c.ID='" . $category_id . "' ";
	}
	if($searchage!="")
	{
		$strAgeWhere=" AND DATEDIFF(NOW(),a.LOADED_DATE)<='" . $searchage . "' ";
	}

	if($searchfields=="" || $searchfields=="*" )
	{
		$searchfields="TEXT, FT_WRITER, TITLE";
	}
	else if($searchfields=="WRITER")
	{
		$searchfields="FT_WRITER";
	}

	$strRootSQL=" FROM " . our_db .".article a JOIN " . our_db .".USERS u ON a.AUTHOR_ID=u.ID LEFT JOIN " . our_db .".CATEGORY c ON a.CATEGORY_ID=c.ID  WHERE MATCH(" . $searchfields. ") AGAINST ('" .singlequoteescape($searchterm) . "' in boolean mode)   " . $strCatWhere  . " " . $strAgeWhere. " AND u.ACTIVE=1 order by a.LOADED_DATE desc ";
	$strSQL="SELECT " .$listSQL .  $strRootSQL;


}
else if(intval($category_id)<1   )
{
	$strSQL="SELECT a.ID as ARTICLE_ID, a.CATEGORY_ID, a.TITLE, a.NOTES, a.SUBJECT, u.FIRST_NAME, u.LAST_NAME  FROM article a JOIN USERS u ON a.AUTHOR_ID=u.ID  WHERE a.LATEST=1 AND a.ACTIVE=1 ORDER BY a.TIMESTAMP DESC ";
	//echo "<script>alert('" . $strSQL . "');</script>";
}
else
{
	$strSQL="SELECT a.ID as ARTICLE_ID,  a.CATEGORY_ID, a.TITLE, a.NOTES, a.SUBJECT, u.FIRST_NAME, u.LAST_NAME  FROM article a JOIN USERS u ON a.AUTHOR_ID=u.ID JOIN ARTICLE_CATEGORY c ON c.ARTICLE_ID=a.ID WHERE c.CATEGORY_ID=" . intval($category_id) . " AND a.ACTIVE=1 ORDER BY a.TIMESTAMP DESC ";
}
//echo $strSQL;
$records = $sql->query($strSQL, true, our_db);
$resultcount=count($records);
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

	$out.="<div class='listtitle'><a class='listtitle'  href=\"article.php?ID=" .  $record["ARTICLE_ID"] . "\">" . $thisnumber .  strtoupper($record["TITLE"]) . "</a></div>\n";
	$out.="<div class='listbyline'>" . strtoupper($record["FIRST_NAME"] . " " . $record["LAST_NAME"]) . "</div>\n";
	$out.="<div class='listnotes'>"  . $record["NOTES"] . "</div>\n";
	$out.="<div class='listsubject'>"  .  $record["SUBJECT"] . "</div><br/>\n" ;
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