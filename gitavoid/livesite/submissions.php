<?php
require("scriptheader.php");
require("frontendheader.php");

$thischarin=gracefuldecay($_REQUEST["c"], "A");
$ID=gracefuldecay($_REQUEST["ID"]);

$thischar =substr($thischar, 0, 1);











 

 
echo "<tr><td  valign='top'>\n";
//echo "<div class='leaftitle'>" . $record["title"] . "</div>";
echo "<div class='taskheading'>(Submissions)</div>";
//echo "<div class='leafbyline'>" . "by " . $record["FIRST_NAME"] . " " .  $record["LAST_NAME"] . "</div>";

if(count($_POST)>2)
{
	MailPostToAdmin("Featurewell Content Submission");
	$messages.="<div class='information'><strong>Your submission has been received.</strong> <p>
	
Featurewell.com, which markets previously published articles to newspapers, magazines, and web sites throughout the world, will consider brief queries from experienced journalists. E-mail your pitch to featurewell@featurewell.com. Due to the number of submissions, we will only respond if we are interested in marketing your article.</div>";
	echo "<br><br><br><div class='messages'>" . $messages. "</div>";
}
else
{
?>
<form name='BForm' action='submissions.php' method='post'>

<table>
<tr>
<td class='formcaption' valign='top'>Title</td>
<td>
<textarea rows='5' cols='60' name='title'></textarea>
</td>
</tr>
<tr>
<td class='formcaption' valign='top'>Deck</td>
<td>
<textarea rows='5' cols='60' name='deck'></textarea>
</td>
</tr>
<tr>
<td class='formcaption' valign='top'>Word Count</td>
<td>
<input type='text'  size='60' name='wordcount'> 
</td>
</tr>
<tr>
<td class='formcaption' valign='top'>Category</td>
<td>
<?= foreigntablepulldown(our_db, "CATEGORY", "ID", "", "CATEGORY_ID", $namereturn);?>
</td>
</tr>
<tr>
<td class='formcaption' valign='top'>Text</td>
<td>
<textarea rows='20' cols='60' name='text'></textarea>
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