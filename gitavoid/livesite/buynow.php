<?php
require("scriptheader.php");
require("frontendheader.php");

$article_id=$_REQUEST["ID"];
$strSQL="SELECT *, u.ID as AUTHOR_ID  FROM " . articletable . " a LEFT JOIN USERS u ON a.AUTHOR_ID=u.ID  WHERE a.ACTIVE=1 AND a.ID=" . intval($article_id);
$out="";
//echo $strSQL;
$records = $sql->query($strSQL);
$record=$records[0];
$authorname=$record["FIRST_NAME"] . " " .  $record["LAST_NAME"];
$price= FWPrice($user["ID"], $article_id);
if( $price!="NA")
{
	$price="$" . number_format($price,2);
}
$catname=GenericDBLookup(our_db,"CATEGORY", "ID", $record["CATEGORY_ID"], "NAME");
 
$comments=addslashes(removeslashesifnecessary($_REQUEST["comments"]));
$submittedprice=addslashes(removeslashesifnecessary($_REQUEST["price"]));
$submittedprice =RemoveEndCharactersIfMatch($submittedprice, "$");
echo "<tr><td valign='top'>\n";


if(count($_POST)>2)
{
 //die($submittedprice);
	//	INSERT INTO OFFER (TIMESTAMP,USER_ID,ARTICLE_ID,OFFER,PIC_OFFER,NOTES,CURRENCY)
	//VALUES (GetDate(), #FW_UserID#, #AID#, #OFFER#, #PIC_OFFER#, '#txtNOTES#', '#txtCURRENCY#')
	UpdateOrInsert(our_db, "OFFER", "", Array("USER_ID"=>$user["ID"], "ARTICLE_ID"=>intval($article_id), "STATUS"=>"N", "OFFER"=>$submittedprice, "CURRENCY"=>"USD", "TIMESTAMP"=>$nowdatetime, "NOTES"=>$comments));

	$body=$user["FIRST_NAME"] . " " .$user["LAST_NAME"] . " (" . $user["EMAIL"] . ") " . $user["PHONE"]  . " " . $submittedprice . " buys " . $record["TITLE"] . "(" . $record["ID"] . ")"; 
	$body.="\r\nCalculated price had been: " . $price;
	$body.="\r\n\r\n" . $comments;
 	$fromemail=GenericDBLookup(our_db,"content", "name", "AdminEmail", "content");
	$headers = "From: " . $fromemail . "\r\nReply-To: " . $fromemail;
	tf_mail($fromemail, "Featurewell Order:" . $user["FIRST_NAME"] . " " .$user["LAST_NAME"],  $body, $headers, "-f" . $fromemail);
	?>
	<br>
	<h2>Thank you for licensing an article from Featurewell.com.</h2>
	<br>
	<div class="instructions">You now have permission to publish this article.</div>
	<div class="instructions">Featurewell.com will invoice you shortly.</div>
	<?php
}
else
{
	echo "<div class='taskheading'>(Buy Now)</div>";
	//echo  CategoryIcons($article_id, $record["CATEGORY_ID"], true, $catcount);
	$blurbaboveform=GenericDBLookup(our_db,"content", "name", "blurb above buy now form", "content");
	echo "<div class='instructions'>" . $blurbaboveform . "</div>";
	echo "<br><div id='articletitle' class='leaftitle' >" . strtoupper($record["TITLE"] ). "</div>";
	echo "<div class='leafbyline'>" .strtoupper( "by " .  $authorname). ", " .$record["WORD_COUNT"] . " words</div>";
	echo "<br clear='all'/>";
	echo "<div class='leafnotes'>" .$record["SUBJECT"]. "</div>";
	echo "<br/>";
	?>
	<form name='BForm' action='buynow.php' method='post'>
	<input type='hidden'  size='60' name='ID' value='<?=$article_id?>'>
	<table>
	<tr>
	<td class='formcaption' valign='top'>Comments</td>
	<td>
	<textarea rows='5' cols='60' name='comments'></textarea>
	</td>
	</tr>
	<tr>
	<td class='formcaption' valign='top'>Total</td>
	<td>
	<input  type='text'  size='40' name='price' value='<?=$price?>'> 
	</td>
	</tr>
	</table>
	<a  style='margin-left:450px' href="javascript: document.BForm.submit()"><img id="g4" border='0' src="images/buy.png"></a>
	</form>
	<?php
}
 
echo "</td></tr>\n";



 
require("frontendfooter.php");
?>