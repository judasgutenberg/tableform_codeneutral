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
 

 





include_once("frontend.php");
 
include("calendar_functions.php");
include("questionnaire_functions.php");

pagetop("headersuppress", "Home"  );
//place for content!!!

///echo "-" . $intOurLoginID . "-";
 
if($intOurLoginID=="")
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
	?>
 	<div align="right" class="nav">
	<a href="view.php?<?=qpre?>table=practitioner">Practitioners</a> | 	<a href="view.php?<?=qpre?>table=user&is_office=0">Patients</a>
	</div>
	<form name="BForm">
	<input type="hidden" name="calendardata" value=""> 
 	<input type="hidden" name="thisdate" value="">
 	</form>

	
	<div style="background-image:url('images/calendartop.png');width:595px;height:28px"></div>
	<div style="background-image:url('images/596_back.png');width:595px;height:200px; background-repeat:repeat-y;">
	<center>
	<iframe frameborder="0" marginwidth="4" name="ourcalendarplace" src="calendar.php" width="584" height="200"></iframe>
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
 
 
 
