<?php

define('IN_PHPBB', true);
$title="Medboxx : Home";
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
include("questionnaire_functions.php");

pagetop("headersuppress", "Home"  );
//place for content!!!
echo "\n<script src=\"tableform_js.js\"><!-- --></script>\n";
echo "\n<script src=\"calendar.js\"><!-- --></script>\n";
echo "\n<script src=\"multipleanswer_js.js\"><!-- --></script>\n";
///echo "-" . $ouruserid . "-";
 
if($ouruserid=="")
{
?>
<table cellpadding=12>
	<tr>
		<td>
					<?if($error!="")
			{
			?>
			<div class="error"><?=$error?></div>
			<br>
			<?
			}
			if($message!="")
			{
			?>
 	 		<div class="message"><?=$message?></div>
			<br>
			<?
			}
			?>
	
			<a class="footercontent" href="reg.php?<?=qpre?>mode=office" ><img src="images/tryfree.png" width="308" height="51" alt="" border="0"></a>
			<p>
			<a class="footercontent" href="reg.php?<?=qpre?>mode=office" ><img src="images/startorg.png" width="308" height="51" alt="" border="0"></a>
			<p>
			<a class="footercontent" href="info_complex.php?config=r|what-mb-does:top+p|what-mb-does:patientreg+w|what-mb-does:infobox+p|what-mb-does:scheduling+p|what-mb-does:patientreminders+|what-mb-does:bottombuttons" ><img src="images/whatdoes.png" width="305" height="74" alt="" border="0"></a>
		</td>
		<td>
			<div id="homepageboxheader"> </div>
			<div id="homepagebox"> <div class="homepageboxinfo"><?=  DisplayContent("homepage blurb");?></div></div>
			<div id="homepageboxfooter"> </div>  
		</td>
	</tr>
</table>

  
<?php
 
}
else
{

	if($bwlOffice)
	{
		echo sitenav();
		echo $ouruserrecord["scheduling_unit_size"];
	?>


	<form name="BForm">
<input type="hidden" name="hoursopen" value="<?=gracefuldecay($ouruserrecord["hours_open"], "0*24")?>">
<input type="hidden" name="middayclosed" value="<?=gracefuldecay($ouruserrecord["midday_closed"], "12*12.25")?>">
<input type="hidden" name="daysopen" value="<?=gracefuldecay($ouruserrecord["days_open"],"0*7")?>">
<input type="hidden" name="holidays" value="<?=$ouruserrecord["holidays"]?>">
<!--nput type="hidden" name="data" value="2009,12,30,13,30,Caulfield,60,1232|2009,12,30,14,30,Henderson,60,1211"-->
<input type="hidden" name="data" value="">
<input type="hidden" name="granulesize" value="<?=gracefuldecay($ouruserrecord["scheduling_unit_size"], 15)?>">
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
echo foreigntablepulldown(our_db,  "practitioner", "practitioner_id", "","practitioner_id", $namereturn,  false, "name", "onChange=\"frames['ajax'].location.href='calweekdata.php?practitioner_id=' + document.BForm.practitioner_id[document.BForm.practitioner_id.selectedIndex].value;\"", "office_user_id='" . $ouruserid . "'");

?>

</form>
<?

//place for content!!!

///echo "-" . $ouruserid . "-";
 
 
//echo CalendarBrowser(time(),our_db, $strPHP,0);
?><div id='idweekcalendar'></div><br>
	</center>
	</div>
	<div style="background-image:url('images/596_bottom.png');width:595px;height:2px; background-repeat:repeat-y;"></div>
	<br/>

<script>


placeWeekCalendar('');
</script>

<?

echo "\n<iframe frameborder=\"0\" marginwidth=\"0\" marginheight=\"0\" width=\"1\" height=\"1\" name=\"ajax\" src=\"\"></iframe>";

	?>
	
	
	
	
	<?
		//echo  CalendarDataFrame($datecode);
	}
	else
	{
		
	?>
	
	
	
	
	
		<form name="BForm">
	<input type="hidden" name="calendardata" value=""> 
 	<input type="hidden" name="thisdate" value="">
 	</form>

	
	<div style="background-image:url('images/calendartop.png');width:595px;height:28px"></div>
	<div style="background-image:url('images/596_back.png');width:595px;height:200px; background-repeat:repeat-y;">
	<center>
	<iframe frameborder="0" marginwidth="4" name="ourcalendarplace" src="calendar.php?<?=qpre?>mode=<?=$mode?>" width="584" height="200"></iframe>
	</center>
	</div>
	<div style="background-image:url('images/596_bottom.png');width:595px;height:2px; background-repeat:repeat-y;"></div>
	
	
	<br/>
	<div id="idblanktablabel" style="background-image:url('images/blankredtabtop.png');width:595px;height:28px; font-family:helvetica, arial;color:#ffffff;font-weight:bold;font-size:16px; text-indent:10px;line-height:180%">&nbsp;&nbsp;&nbsp;<span style="font-size:23px">Alerts</font></div>
	<div style="background-image:url('images/596_back.png');width:595px;height:200px; background-repeat:repeat-y;">
	<center>
	<iframe name="dayframe" frameborder="0" marginwidth="4" src="alerts.php" width="584" height="200"></iframe>
	</center>
	</div>
	<div style="background-image:url('images/596_bottom.png');width:595px;height:2px; background-repeat:repeat-y;"></div>
	
	
	
	
	
	
	
	
	
	
	
	
	
	<!--<form action="appointments.php"><input class="profilebutton" type="submit" name="submit" value="View your appointment schedule"></form>
	<br/>
	<form action="reg.php"><input type="hidden" name="<?=qpre?>profilemode" value="profile"><input class="profilebutton" type="submit" name="submit" value="Edit your profile"></form>-->
	
	<?
}
}

 

 
 
 
	
	
	
	
	
	?>

	
	
	
	
	
	
	

 
 
<?pagebottom();  ?>
 
 
 
