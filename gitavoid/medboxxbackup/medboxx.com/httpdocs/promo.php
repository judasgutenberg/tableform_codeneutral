<?php

define('IN_PHPBB', true);
$title="Medboxx : Home";
//include("header.php");
 //include("includes/bbcode.php");
  //include("includes/db.php");
  
 include("header.php");
  
//open a connection to mysql db

 
//
// Set page ID for session management
//
//$userdata = session_pagestart($user_ip, PAGE_LOGIN);
//init_userprefs($userdata);
 

 
$sql=conDB();
 //echo phpinfo();
$intOurLoginID=GetFrontEndLoginID();
//echo $intOurLoginID . "_______" ;
$membername=GenericDBLookup(our_db,"bb_user", "user_id", $intOurLoginID, "username");
$cookiename=GenericDBLookup(our_db,"bb_config", "config_name", "cookie_name", "config_value");
$strPHP=$_SERVER['PHP_SELF'];
$intStartRecord=$_REQUEST["r"];
$recsperpage=14;

$config=$_REQUEST["config"];

if($config=="special")
{
	$config=whatwedoconfig;
}	



include_once("frontend.php");
include("calendar_functions.php");
include("questionnaire_functions.php");
pagetop("headersuppress", "Home"  );
//place for content!!!

$out="";

?>
<div class="header">Enter a Promo Code</div>
<form method="post" action="reg.php">
<input type="hidden" name="<?=qpre?>mode" value="office">

<input type="text" name="<?=qpre?>pc" value="" size="33">

<input type="submit" name="subtron" value="Use Promo Code" size="33">
</form>


<?

echo $out;
?>

 
 





	
	
	
	
	
	
	

 
 
<?pagebottom();  ?>
 
 
 
