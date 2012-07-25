<?php

define('IN_PHPBB', true);
$title="Medboxx : Home";
//include("header.php");
 //include("includes/bbcode.php");
  //include("includes/db.php");
  
include("header.php");
//$officetoken="kingstonmed";
if($officetoken!=""  && $intOurLoginID=="")
{
	//header("location:reg.php");
}
//open a connection to mysql db

 
//
// Set page ID for session management
//
//$userdata = session_pagestart($user_ip, PAGE_LOGIN);
//init_userprefs($userdata);
 

 
$sql=conDB();
 
 
 
$strPHP=$_SERVER['PHP_SELF'];
$tabtitle="Office Information";
$tablength=CalculateTabLength($tabtitle)  ;

 
 





include_once("frontend.php");
 
include("calendar_functions.php");
include("questionnaire_functions.php");

pagetop("headersuppress", "Home"  );
//place for content!!!
echo "\n<script src=\"tableform_js.js\"><!-- --></script>\n";
echo "\n<script src=\"calendar.js\"><!-- --></script>\n";
echo "\n<script src=\"multipleanswer_js.js\"><!-- --></script>\n";
///echo "-" . $intOurLoginID . "-";
//echo $bwlOffice . " " . $officetoken  . "<BR>";

?>

	<br/>
	<div id="idblanktablabel" style="background-image:url('images/blankredtabtop_<?=$tablength?>.png');width:595px;height:28px; font-family:helvetica, arial;color:#ffffff;font-weight:bold;font-size:16px; text-indent:0px;line-height:180%">&nbsp;&nbsp;&nbsp;<span style="font-size:23px"><?=$tabtitle?></font></div>
	<div style="background-image:url('images/596_back.png');width:595px; ; background-repeat:repeat-y;">
	<div style="padding-left:20px" class="normaltext">
	<br/>
<div class='header'>Welcome to <?=$ourofficerecord["office_name"]?>.</div>
<br/>

 
 <?=$ourofficerecord["address"]?>
 <br/>
 <?=$ourofficerecord["city"]?>, <?=$ourofficerecord["state_code"]?>  <?=$ourofficerecord["zip"]?>
 <br/>
  phone: <?=$ourofficerecord["phone"]?>
  <br/>
  <br/>
  </div>
  <div style="font-family:tahoma, arial, helvetica, sans-serif; color:#000000; border-style: solid ; border-width: 1px; border-color:#C40001; margin-left:10px;margin-right:10px; padding: 15px;   text-align:justify; font-size:12px;  background-color:#ffffff">
<?=$ourofficerecord["office_text"]?>
</div>
	<br/>
	
 
	</div>
	<div style="background-image:url('images/596_bottom.png');width:595px;height:2px; background-repeat:repeat-y;"></div>
	<br/>

 
 
	
	
	
 
 

	
	
	
	
	
	
	

 
 
<?pagebottom();  ?>
 
 
 
