<?php
require("scriptheader.php");
require("frontendheader.php");

//was user here in the past?
$strYouHaveBeenHere="";

if(HaveViewed($article_id,  $user["ID"])>1)
{
	$strYouHaveBeenHere="<div class='haveviewed'>You have viewed this article.</div>";
}


$strSQL="SELECT *, u.ID as AUTHOR_ID   FROM " . articletable . " a LEFT JOIN USERS u ON a.AUTHOR_ID=u.ID  WHERE a.ACTIVE=1 AND u.ACTIVE  AND a.ID=" . intval($article_id);
$out="";
//echo $strSQL;
$records = $sql->query($strSQL);
echo mysql_error();
$record=$records[0];

//echo codeJustBeforeFound(fw_textprocess($record["TEXT"]) , "hold me");
$authorname=$record["FIRST_NAME"] . " " .  $record["LAST_NAME"];
$catname=GenericDBLookup(our_db,"CATEGORY", "ID", $record["CATEGORY_ID"], "NAME");
echo "<tr><td valign='top'>\n";
if($record)
{
	if(intval($record["WORD_COUNT"])>20)
	{
		 $wordcountindicatiomn=", " .  $record["WORD_COUNT"]  . " WORDS";
	}
	else
	{
		//set word_count if it's empty
		$strFWC=$record["TEXT"];
 		$wordcount=WordCount($record["TEXT"]);
		$strSQL="UPDATE " . our_db . "." . articletable . " SET WORD_COUNT=" .$wordcount  . " WHERE ID=" . intval($article_id);
		$sql->query($strSQL);
	}
	//just fix the cat id of an article when it is viewed:
	//copy the category id of this article to ARTICLE_CATEGORY if it isn't there already. this speeds cat list displays
	$cat_id=$record["CATEGORY_ID"];
	$exists=GenericDBLookup($strDatabase, "ARTICLE_CATEGORY", "ARTICLE_ID", $article_id, "CATEGORY_ID");
	if($exists<1)
	{
		$strSQLFix="INSERT INTO ARTICLE_CATEGORY(CATEGORY_ID, ARTICLE_ID) VALUES(" . $cat_id  . "," . $article_id . ")";
		$sql->query($strSQLFix);
		$copied++;
	}
	$bkexists=GenericDBLookup(our_db, "article_bkup", "ARTICLE_ID", $article_id, "ID");
	if($bkexists=="")
	{
		$bkuprecord=GenericDBLookup(our_db, articletable, "ID", $article_id, "");
		//backup this article now
		UpdateOrInsert(our_db, "article_bkup","", $bkuprecord);
	
	}
	
	
	//echo "<div style='position:absolute;top:463px;left:200px;'>";
	echo "<div class='articlefunctions' >&gt; <a class='articlefunctions' href='emailcolleague.php?ID=" .$article_id . "'>EMAIL A COLLEAGUE</a> &gt; <a class='articlefunctions' href='printerfriendly.php?ID=" .$article_id . "'>PRINTER FRIENDLY</a> &gt; <a class='articlefunctions' href='" . $homepage . "?mode=bookmark&ID=" .$article_id ."'>BOOKMARK</a></div>";
	echo "<div class='isprotected' >This story is protected by copyright and may be used only after purchase from Featurewell.com.</div>";
	if($catname!="")
	{
		echo "<div class='taskheading'>(" . $catname. ")</div>";
	}
	//echo die("<script>alert(" . $record['CATEGORY_ID'] . " )</script>");
	echo  CategoryIcons($article_id, $record["CATEGORY_ID"], true, $catcount);
	
	echo "<div id='articletitle' class='leaftitle' >" . strtoupper($record["TITLE"] ). "</div>";
	
	echo "<div class='leafbyline'>by <a class='listbyline' href='" . $homepage . "?i=6&w=" . $record["AUTHOR_ID"] . "'>" .  strtoupper( $authorname). "</a>" . $wordcountindicatiomn . "</div>";
	echo "<br clear='all'/>";
	echo "<div class='leafnotes'>" .$record["NOTES"]. "</div>";
	echo $strYouHaveBeenHere;
	echo "<br/>";

	if(AdministerType(our_db, articletable,$strUser, "")>1)
	{
		echo "<div align='right'>[<a href='tf/tf.php?" .qpre . "db=" . our_db . "&x_table=article&" .qpre . "mode=edit&" .qpre . "idfield=ID&" .qpre . "column=ID&" .qpre . "direction=DESC&ID=" .$article_id . "'>edit</a>]</div>";
	
	}
	
	//echo "</div>";
	
	echo  "<div class='leafbody'>"  . fw_textprocess($record["TEXT"]) . "</div>";
	echo  "<div class='bottomarticledivider'>***</div>";
	
	$strSQL="SELECT   a.ID as ARTICLE_ID,  a.CATEGORY_ID, a.TITLE, a.NOTES, a.SUBJECT, u.FIRST_NAME, u.LAST_NAME   FROM " . articletable . " a JOIN USERS u ON a.AUTHOR_ID=u.ID  WHERE a.AUTHOR_ID =" .intval($record["AUTHOR_ID"]) . " AND a.ACTIVE=1 ORDER BY a.TIMESTAMP DESC LIMIT 0,4";
	//echo $strSQL;
	$arecords = $sql->query($strSQL);
	if(count($arecords )>1)
	{

		echo  "<div class='articlebottomlistheader'>Also by "  . $authorname . ":</div>";
		foreach($arecords as $arecord)
		{
			if($article_id!=$arecord["ARTICLE_ID"])
			{
				echo "<div class='bottomlist' ><a class='bottomlistlink' href='article.php?ID=" . $arecord["ARTICLE_ID"] . "'>" . strtoupper($arecord["TITLE"] ). "</a> " . $arecord["SUBJECT"] . "</div>\n\n";
			}
		}
	}
	echo "<BR>";
	echo "</td></tr>\n";
}
else
{
	echo "<div class='leafbyline'>This article no longer exists.</a>";
}

$price= FWPrice($user["ID"], $article_id);


?>

<script>

	buynowdiv=document.getElementById('buynow');
	articletitlediv=document.getElementById('articletitle');
	//articletitlediv.style.zindex=9000;
	//alert(articletitlediv.style.left);
	var chrstodealwith=articletitlediv.innerHTML.length;
	if(buynowdiv.addEventListener)
	{
	 
		var vertdelta=10;
	}
	else
	{
		var vertdelta=-5;
	}
	<?php
	if($messages!=""  || $errors!="")
	{
		echo "   vertdelta+=21;";
	}
	?>
	buynowdiv.style.display='';
	buynowdiv.innerHTML='[$<?=number_format($price,2)?>]';
	articlehoriz=document.getElementById('buynowhoriz');
	articlevert=document.getElementById('buynowvert');
	articlehoriz.style.display='';
	articlevert.style.display='';
	//alert(articlevert.style.height);

	pixelwidther=(36-chrstodealwith )*16 - <?=$catcount?>*40 ;
	if(pixelwidther<0)
	{
		pixelwidther=0;
	}
	if(pixelwidther==0)
	{
		vertdelta=vertdelta-10;
	
	}
	
	articlevert.style.height= parseInt(articlevert.style.height) + vertdelta  ;
	articlehoriz.style.top= parseInt(articlehoriz.style.top) +  vertdelta;
	//pixelwidther=450;
	articlehoriz.style.width =pixelwidther;
	articlehoriz.style.left=parseInt(articlehoriz.style.left) -pixelwidther;
	//alert(articletitlediv.style.zIndex);
</script>
<?php
require("frontendfooter.php");
?>