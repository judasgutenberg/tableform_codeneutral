<?php 

$windowconfig="menubar=yes,height=400,width=900,scrollbars=yes";
$strContent="";
$strContent.="[<a style='margin:10px' href=# onclick=\"remote=window.open('/invoicer.php?mode=invoice&ID=" . $_REQUEST["ID"]. "', 'invoicer','" . $windowconfig . "');remote.focus()\"    class='heading' >Invoice Client</a>]\n ";
$strContent.="[<a style='margin:10px'  href=#  onclick=\"remote=window.open('/invoicer.php?mode=inform&ID=" . $_REQUEST["ID"]. "', 'invoicer','" . $windowconfig . "');remote.focus()\" class='heading' >Inform Writer</a>]\n ";
$strContent.="[<a style='margin:10px'   href=#  onclick=\"remote=window.open('/invoicer.php?mode=delete&ID=" . $_REQUEST["ID"]. "', 'invoicer','" . $windowconfig . "');remote.focus()\" class='heading' >Delete This Offer</a>]\n";

$strContent.="[<a style='margin:10px'   href=#  onclick=\"remote=window.open('/invoicer.php?mode=fromscratch&ID=" . $_REQUEST["ID"]. "', 'invoicer','" . $windowconfig . "');remote.focus()\" class='heading' >Create An Offer From Scratch</a>]\n<br>";

$out.=htmlrow('bgclassline', " ",  $strContent);
?>