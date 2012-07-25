<?php

define('IN_PHPBB', true);
$title=sitename ." : Home";
//include("header.php");
 //include("includes/bbcode.php");
  //include("includes/db.php");
  
 include("header.php");
if($officetoken!="")
{
	header("location:reg.php");
}
//open a connection to mysql db

 
//
// Set page ID for session management
//
//$userdata = session_pagestart($user_ip, PAGE_LOGIN);
//init_userprefs($userdata);
 

 
$sql=conDB();
 
 
$strPHP=$_SERVER['PHP_SELF'];
$tabtitle="Week Scheduler";
$tablength=80;

 





include_once("frontend.php");
 
include("calendar_functions.php");
 
include("extra_calendar_functions.php");
include("questionnaire_functions.php");

pagetop("headersuppress", "Calendar"  );


//hidden form input "data" is occupied by AJAXy methods
?>

<form name="BForm">
<input type="hidden" name="hoursopen" value="9-17">
<input type="hidden" name="middayclosed" value="12-13">
<input type="hidden" name="daysopen" value="1-5">
<input type="hidden" name="holidays" value="12/25 01/01 thanksgiving">
<input type="hidden" name="data" value="2009,12,30,13,30,Caulfield,60,1232|2009,12,30,14,30,Henderson,60,1211">
<input type="hidden" name="granulesize" value="15">
<input type="hidden" name="hourstart" value="9">
<input type="hidden" name="hourend" value="17">
<input type="hidden" name="calwidth" value="570">
<input type="hidden" name="timestorage" value="">

	<br/>
	<div id="idblanktablabel" style="background-image:url('images/blankredtabtop_<?=$tablength?>.png');width:595px;height:28px; font-family:helvetica, arial;color:#ffffff;font-weight:bold;font-size:16px; text-indent:0px;line-height:180%">&nbsp;&nbsp;&nbsp;<span style="font-size:23px"><?=$tabtitle?></font></div>
	<div style="background-image:url('images/596_back.png');width:595px; ; background-repeat:repeat-y;">
	<center class="normaltext">
	
Practitioner: 
<?php
// placeWeekCalendar(thisdate,  granulesizeinminutes, hourstart, hourend, width, extraparam)


//foreigntablepulldown($strDatabase, $strTable, $strIDField, $intDefault, $strLabelField="", &$namereturn, $bwlHiddenReturn=false, $strPreferredNameField="", $addedselectpairs="", $strWhereClause="")
echo foreigntablepulldown(our_db,  "practitioner", "practitioner_id", "","practitioner_id", $namereturn,  false, "name", "onChange=\"frames['ajax'].location.href='calweekdata.php?practitioner_id=' + document.BForm.practitioner_id[document.BForm.practitioner_id.selectedIndex].value;\"", "office_login_id='" . $intOurLoginID . "'");

?>
Go <input name='godate' type='text' value='<?php=date("m/d/Y", $time)?>'> 
<input class="genericbutton" name='submit' type='submit' value='Go'> 
</form>
<?
echo "\n<script src=\"tableform_js.js\"><!-- --></script>\n";
echo "\n<script src=\"calendar.js\"><!-- --></script>\n";
echo "\n<script src=\"multipleanswer_js.js\"><!-- --></script>\n";
//place for content!!!

///echo "-" . $intOurLoginID . "-";
 
 
//echo CalendarBrowser(time(),our_db, $strPHP,0);
?><div id='idweekcalendar'></div><br>
	</center>
	</div>
	<div style="background-image:url('images/596_bottom.png');width:595px;height:2px; background-repeat:repeat-y;"></div>
	<br/>

<script>


placeWeekCalendar("Dec 29, 2009",  15,8, 18, 600,1);
</script>

<?

echo "\n<iframe frameborder=\"0\" marginwidth=\"0\" marginheight=\"0\" width=\"1\" height=\"1\" name=\"ajax\" src=\"\"></iframe>";


if($intOurLoginID=="")
{
 
 
}
else
{

	if($bwlOffice)
	{
	
 	
	}
	else
	{
	
	}
}

 

 
 
 
	
	
	
	
	
	?>

	
	
	
	
	
	
	

 
 
<?pagebottom();  ?>
 
 
 
