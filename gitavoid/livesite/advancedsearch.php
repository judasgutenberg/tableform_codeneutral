<?php
require("scriptheader.php");
require("frontendheader.php");

$thischarin=gracefuldecay($_REQUEST["c"], "A");
$ID=gracefuldecay($_REQUEST["ID"]);

$thischar =substr($thischar, 0, 1);











 

 
echo "<tr><td  valign='top'>\n";
//echo "<div class='leaftitle'>" . $record["title"] . "</div>";
echo "<div class='taskheading'>(Advanced Search)</div>";
//echo "<div class='leafbyline'>" . "by " . $record["FIRST_NAME"] . " " .  $record["LAST_NAME"] . "</div>";

 
?>






<form name="ASForm" id="SearchForm" action="<?=$homepage?>" method="POST" onsubmit="return _CF_checkSearchForm(this)">
 
<TABLE class="Instructions">
<TR><TD class="formcaption" VALIGN="top">Sample:</TD><TD>Search for Around the World in Eighty Days</TD></TR>

<TR><TD   class="formcaption" VALIGN="top" >Exact&nbsp;Phrase:</TD><TD class="instructions"> <em>&quot;Eighty Days&quot; </em> finds the whole phrase,
<I>Eighty Days</I>, in between the quotes.</TD></TR>
<TR><TD  class="formcaption" VALIGN="top">Prioritize:</TD><TD class="instructions"> <em>+World</em>  returns articles with the term <I>World</I>, displayed more prominently in the results.</TD></TR>
<TR><TD  class="formcaption" VALIGN="top">Starts with:</TD><TD class="instructions"> <em>Eigh*</em>  finds words starting with <I>Eigh</I>, for instance: Eight, Eighty.</TD></TR>

<TR><TD  class="formcaption" VALIGN="top">Exclude:</TD><TD class="instructions"> <em>Around -World</em> finds articles which include the term <I>Around</I>, but not those that also contain the term <I>World</I>.</TD></TR>
 
 </TR>
<tr  > 
<td colspan="2">
<br>
<input name="searchterm" id="searchterm"  type="text" size="60"  /> 
<input  name="fields" id="idFIELDS"  type="radio" value="TITLE" />Headline
<input  name="fields" id="idFIELDS"  type="radio" value="TEXT" />Text
<input  name="fields" id="idFIELDS"  type="radio" value="WRITER" />Writer
<input  checked="checked" name="fields" id="idFIELDS"  type="radio" value="*" />All
 </td>

</tr>
 
 
<TR  >
<TD  align="right">In Category: 
<select id="idcategory_id"  name="c">
<option value="">All
<option value="8" >Art
<option value="10" >Books
<option value="2" >Business
<option value="16" >Celebs
<option value="13" >Essays
<option value="9" >Film & TV
<option value="5" >Food & Wine
<option value="6" >Health
<option value="18" >Humor
<option value="26" >International
<option value="11" >Life
<option value="7" >Music
<option value="1" >Politics-U.S.
<option value="15" >Relationships
<option value="17" >Science
<option value="27" >Spirituality
<option value="14" >Sports
<option value="3" >Technology
<option value="4" >Travel
</select>
</TD>
<TD align="left">Publication Date:

<select  id="idAGE"  name="age">
<option value="" >-none-
<option value="30" >Past 30 Days
<option value="183" >Past 6 Months
<option value="366" >Past Year
<option value="100000" selected="true">Full Archive
</select>

</TD>
</TR>
 
 
 
<TR align="center">
<input type="hidden" name="mode" value="advanced">
<TD colspan='2' align='right'><a href='javascript:document.ASForm.submit()'><img id='g6' src='images/submitbutton.png' border='0'></a></TD>
</TR>
</table>
</form>
	
















<?php
 

echo "</td></tr>\n";
?>













<?php
require("frontendfooter.php");
?>