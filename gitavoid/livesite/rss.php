<?php
require("scriptheader.php");
header("Content-Type: application/xml; charset=ISO-8859-1"); 

$article_id=$_REQUEST["ID"];
if($category_id<1)
{
	$catname="Home";
	$strSQL="SELECT a.ID as ARTICLE_ID, a.CATEGORY_ID, a.TITLE, a.NOTES, a.SUBJECT, u.FIRST_NAME, u.LAST_NAME  FROM " . articletable . " a JOIN USERS u ON a.AUTHOR_ID=u.ID  WHERE a.LATEST=1 AND a.ACTIVE=1 ORDER BY a.TIMESTAMP DESC  LIMIT 0,20";
	//echo "<script>alert('" . $strSQL . "');</script>";
}
else
{
	$catname= $v=str_replace("&", "&amp;",GenericDBLookup(our_db,"CATEGORY", "ID", $category_id, "NAME"));
	$strSQL="SELECT a.ID as ARTICLE_ID,  a.CATEGORY_ID, a.TITLE, a.NOTES, a.SUBJECT, u.FIRST_NAME, u.LAST_NAME  FROM " . articletable . " a JOIN USERS u ON a.AUTHOR_ID=u.ID JOIN ARTICLE_CATEGORY c ON c.ARTICLE_ID=a.ID WHERE c.CATEGORY_ID=" . intval($category_id) . " AND a.ACTIVE=1 ORDER BY a.TIMESTAMP DESC LIMIT 0,20";
}

$out="";
//echo $strSQL;
$records = $sql->query($strSQL);
?><rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/"><channel><title>Featurewell <?=$catname?></title><link>http://www.featurewell.com/CID=8</link><description>Featurewell.com Syndication Worldwide</description><copyright>Copyright &#169; 2000-<?=date("Y")?> Featurewell.com all rights reserved.</copyright><language>en-us</language><managingEditor>editor@featurewell.com</managingEditor><webMaster>webmaster@featurewell.com</webMaster><ttl>240</ttl><skipDays><day>Saturday</day><day>Sunday</day></skipDays><image><title>Featurewell.com Syndication</title><url>http://www.featurewell.com/gfx/featurewell.gif</url><link>http://www.featurewell.com/</link></image><?php

foreach($records as $record)
{
	foreach($record as $k=>$v)
	{
		$v=str_replace("&", "&amp;", $v);
		$v=str_replace(  chr(147),"&#39;", $v);
		$v=str_replace(  chr(148),"&#39;", $v);
		$v=str_replace(  chr(145), "&#39;", $v);
		$v=str_replace(  chr(146),"&#39;", $v);
		$v=str_replace("'",  "&#39;", $v);

		$record[$k]=$v;
		
	}
	$catname= str_replace("&", "&amp;",GenericDBLookup(our_db,"CATEGORY", "ID", $record["CATEGORY_ID"], "NAME"));
	$catname=str_replace("&", "&amp;", $catname);
	$catname=str_replace(  chr(147),"&#39;", $catname);
	$catname=str_replace(  chr(148),"&#39;", $catname);
	$catname=str_replace("'",  "&#39;", $catname);
?><item><title><?=$record["TITLE"]?></title><link>http://www.featurewell.com/article.php?ID=<?=$record["ARTICLE_ID"]?>&amp;rss=1</link><description><?=$record["SUBJECT"]?></description><author><?=$record["FIRST_NAME"]?><?=$record["LAST_NAME"]?></author><dc:identifier><?=$record["ARTICLE_ID"]?></dc:identifier><dc:creator><?=$record["FIRST_NAME"]?><?=$record["LAST_NAME"]?></dc:creator><dc:date><?=$record["LOADED_DATE"]?></dc:date><dc:subject><?=$catname?></dc:subject><dc:publisher>Featurewell.com Inc</dc:publisher><dc:rights>Copyright &#169; 2000-2010 Featurewell.com - Second rights available.</dc:rights><dc:coverage>World</dc:coverage><dc:type>Text</dc:type></item><?php

}
?></channel></rss>