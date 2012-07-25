<?php
require("scriptheader.php");
require("frontendheader.php");

$thischarin=gracefuldecay($_REQUEST["c"], "A");
 

$thischar =substr($thischar, 0, 1);











 
$article_id=$_REQUEST["ID"];

$strSQL="SELECT *, u.ID as AUTHOR_ID  FROM " . articletable . " a LEFT JOIN USERS u ON a.AUTHOR_ID=u.ID  WHERE a.ACTIVE=1 AND a.ID=" . intval($article_id);

//echo $strSQL;
$records = $sql->query($strSQL);
$record=$records[0];
 
echo "<tr><td  valign='top'>\n";
//echo "<div class='leaftitle'>" . $record["title"] . "</div>";
echo "<div class='taskheading'>(Email Article to a Colleague)</div>";
//echo "<div class='leafbyline'>" . "by " . $record["FIRST_NAME"] . " " .  $record["LAST_NAME"] . "</div>";

if(count($_POST)>2)
{
 
	$subject=addslashes(removeslashesifnecessary($_REQUEST["subject"]));
	$email=addslashes(removeslashesifnecessary($_REQUEST["email"]));
	$additionalcomments=addslashes(removeslashesifnecessary($_REQUEST["additionalcomments"]));
	$fromemail=GenericDBLookup(our_db,"content", "name", "AdminEmail", "content");
 	$headers = "From: Featurewell Sales <" . $fromemail . ">\r\nReply-To: " . $fromemail;
	//MailPostToAdmin("Featurewell Content Submission");
	$body=$record["TITLE"] .  " by " . $record["FIRST_NAME"] . " " . $record["LAST_NAME"]   . "\r\n\r\n" . $record["SUBJECT"] . "\r\n\r\nClick this link:  http://www.featurewell.com/article.php?ID=" . intval($article_id)  . " to read full story.\r\n\r\nFeaturewell.com is an electronic marketplace that enables registered editors to read, for free, then purchase the rights to publish articles\r\nby the world's finest journalists.";
	$body.="\r\n\r\n"  . $additionalcomments;
	//echo $body;
	//$headers = "From: " .$user["EMAIL"] . "\r\nReply-To: " . $user["EMAIL"];
	if(contains($email, ","))
	{
		$arrEmail=explode(",", $email);
	}
	else if(contains($email, ";"))
	{
		$arrEmail=explode(";", $email);
	}
	else if(contains($email, chr(13)))
	{
		$email=str_replace(chr(10), "",  $email);
		$arrEmail=explode(chr(13), $email);
	}
	else
	{
		$arrEmail=array($email);
	}
	foreach($arrEmail as $email)
	{
		tf_mail($email, $subject,  $body, $headers, "-f" .  $user["EMAIL"]);
		UpdateOrInsert(our_db, "communication", "", Array("sender_id"=>$user["ID"], "article_id"=>intval($article_id), "receiver_email"=>$email, "datetime_done"=>$nowdatetime, "description"=>"email a colleague"));
	}
	$messages.="<div class='information'><strong>A message has been sent to your colleague.</strong> <p></div>";
	echo "<br><br><br><div class='messages'>" . $messages. "</div>";
	
}
else
{
?>
<h3>Emailing a colleageue the article '<?=$record["TITLE"]?>'.</h3>
<br>
<form name='BForm' action='emailcolleague.php' method='post'>
<input type='hidden'  size='60' name='ID' value='<?=$article_id?>'>
<table>
<tr>
<td class='formcaption' valign='top'>Colleague's Email Address</td>
<td>
<input type='text'  size='60' name='email'> 
</td>
</tr>

<tr>
<td class='formcaption' valign='top'>Subject</td>
<td>
<input  type='text'  size='60' name='subject' value='This might interest you: <?=$record["TITLE"]?>'> 
</td>
</tr>

<tr>
<td class='formcaption' valign='top'>Additional Comments</td>
<td>
<textarea rows='20' cols='60' name='additionalcomments'></textarea>
</td>
</tr>
 
</table>
<a  style='margin-left:450px' href="javascript: document.BForm.submit()"><img id="g4" border='0' src="images/sendbutton.png"></a>
</form>
<?php
}

echo "</td></tr>\n";
?>













<?php
require("frontendfooter.php");
?>