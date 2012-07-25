<?php

define('IN_PHPBB', true);
$title=sitename ." : Home";
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
 
if($_REQUEST[qpre . "mode"]=="client"  && $intOurOfficeID!="")
{
	header("location: view.php?office_id=" . $intOurOfficeID . "&x_action=new&x_table=client");
}
 
$sql=conDB();
 
 
 
$strPHP=$_SERVER['PHP_SELF'];
$tabtitle="My Appointments";
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
	<div id="idblanktablabel" style="background-image:url('images/blankredtabtop_<?=$tablength?>.png');width:595px;height:28px; font-family:helvetica, arial;color:#<?=textcolorontheme?>;font-weight:bold;font-size:16px; text-indent:0px;line-height:180%">&nbsp;&nbsp;&nbsp;<span style="font-size:23px"><?=$tabtitle?></font></div>
	<div style="padding:5px;background-image:url('images/596_back.png');width:595px; font-family:helvetica, arial; background-repeat:repeat-y;font-weight:bold;font-size:16px;  ">

	<?
if($intOurLoginID!="")
{
 
		$strPKName="calendar_event_id";
		$strTable="personal_calendar_event";
		$strSQL="SELECT *, o.phone as   office_phone   FROM " . our_db . "." . $strTable . " t JOIN " . our_db . ".client_office_map m ON t.client_id=m.client_id JOIN " . our_db . ".practitioner p ON  t.practitioner_id=p.practitioner_id JOIN " . our_db . ".office o ON m.office_id=o.office_id LEFT JOIN " . our_db . ".event_status e ON e.event_status_id=t.event_status_id WHERE t.client_id='" . intval($intOurClientID) . "' ORDER BY datecode DESC";
	//echo $strSQL;
		$strSuppressFields="event_status_id client_id office_id login_id practitioner_id office_login_id type notes recurrence_id calendar_event_id client_login_id practitioner_type_id sort_id address facility phone subdomain user_id";
		
		
		//displaydatecode
		// GenericRSDisplay($strDatabase, $strPHP,$strLabel, $strSQL, $truncate, $intWidth, $strLinkFieldName="", $strLinkIDName="", $strAdditionalLink="", $strSuppressFields="", $bwlSuppressHeader=false, $bwlPrettyUpFieldNames=true, $intFieldLimit=10, $idencryptionstring="", $arrPostProcessing="")
		//echo $strSQL;
		echo GenericRSDisplay(our_db, $strPHP,"", $strSQL, true, 550,  $strPKName,$strPKName, $strAdditionalLink, $strSuppressFields ,  false,  true, 19,  "",  Array("datecode"=>"displaydatecode(<value/>)", "time"=>"cleanuptime('<value/>')"), Array("datecode"=>"date", "name"=>professionaltype));
		//echo mysql_error();
 
}
else
{
?>
	&nbsp;&nbsp;To see your appointments you need to <a href="login.php">login</a>.<br/> &nbsp;&nbsp;If you do not have an account, you will need to <a href="reg.php">register</a>.
<?
}
?>
</div>
 
 
	<div style="background-image:url('images/596_bottom.png');width:595px;height:2px; background-repeat:repeat-y;"></div>
	<br/>

	
 

 

 
 
 
	
	
	
 

	
	
	
	
	
	
	

 
 
<?pagebottom();  ?>
 
 
 
