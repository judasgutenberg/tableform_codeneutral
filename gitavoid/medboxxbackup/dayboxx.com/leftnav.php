

<?php

$strPHP=$_SERVER['PHP_SELF'];
if(contains($strPHP, "medicalprofile"   )|| contains($strPHP, "tests"   ))
{

?>
<table width="100%" class="topleft" cellpadding="0" cellspacing="0" border="0">
<tr>
<td class="text_11bl"  valign="top">
<?=  $leftnavcontent?>
<p>
 
 
</td>
</tr>
</table>

<?php

}
?>


