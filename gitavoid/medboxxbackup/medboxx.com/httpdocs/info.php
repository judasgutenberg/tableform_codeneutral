<?php

 include("header.php");
$title=sitename . " : Home";


 
$sql=conDB();
 //echo phpinfo();

//echo $intOurLoginID . "_______" ;
$membername=GenericDBLookup(our_db,"bb_user", "user_id", $intOurLoginID, "username");
$cookiename=GenericDBLookup(our_db,"bb_config", "config_name", "cookie_name", "config_value");
$strPHP=$_SERVER['PHP_SELF'];
$intStartRecord=$_REQUEST["r"];
$recsperpage=14;

$page_key=$_REQUEST["page_key"];





include_once("frontend.php");
 
include("calendar_functions.php");
include("questionnaire_functions.php");

pagetop("headersuppress", "Home"  );
//place for content!!!
?>
 
    <div id="infoheader"> </div>
     
            <div id="infocontent"> <div class="info"><?=DisplayContent($page_key);?></div></div>
		 
            <div id="infofooter"> </div>
<br/>
 
 
 



<?php

	
if ($intOurLoginID<0 || $intOurLoginID=="" ) //we arent registered
{
	?>
 
	
	<? 
	echo "<div style=\"margin:10px\" class=\"text_12bl\">";
	echo DisplayContent("unregistered homepage intro");
	echo "</div>";
}
else //we are registered
{
	echo "<div style=\"margin:10px\" class=\"text_12bl\">";
	echo DisplayContent("registered homepage intro");
	echo "</div>";
}
 
 
 

//echo  loginpiece();

 
 
 
	
	
	
	
	
	?>

	
	
	
	
	
	
	

 
 
<?pagebottom();  ?>
 
 
 
