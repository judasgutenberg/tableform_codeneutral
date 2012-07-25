<?php


//include("header.php");
 //include("includes/bbcode.php");
  //include("includes/db.php");
  
 include("header.php");
 $title=sitename . " : Home";
 if($dest=="" && $action!="logout")
 {
 	$dest=".";
 }
 if($dest!="" && $intOurLoginID!="")
 {
 	header("location: " . $dest);
 }
 // echo "-" . $intOurLoginID . "-" ;
 
//open a connection to mysql db

 
//
// Set page ID for session management
//
//$userdata = session_pagestart($user_ip, PAGE_LOGIN);
//init_userprefs($userdata);

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
            <div id="infocontent"> 
			
	
			<div class="info">
			<?if($error!="")
			{
			?>
			<div class="error"><?=$error?></div>
			<?
			}
			if($message!="")
			{
			?>
 	 		<div class="message"><?=$message?></div>
			<?
			}
	
			?>
			
			<?= loginpiece($dest,   $intOurLoginID, $error, "large", $mode, "horizontal" );;?></div></div>
		 
            <div id="infofooter"> </div>  
			
 
	
	
	
	
	 <br/><br/>
	

 
 
<?pagebottom();  ?>
 
 
 
