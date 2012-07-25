<?php
include("header.php");
$title=sitename . " : Home";
//$officetoken="kingstonmed";
if($officetoken!=""  && $intOurLoginID=="")
{
	//header("location:reg.php");
}
$sql=conDB();
$strPHP=$_SERVER['PHP_SELF'];
$tabtitle="Appointment Scheduler";
$tablength=CalculateTabLength($tabtitle, "small")  ;
$calxpos=65;
$calypos=120;
$calwidth=800;
$displaymode=$_REQUEST[qpre . 'displaymode'];

include_once("frontend.php");
include("calendar_functions.php");
include("questionnaire_functions.php");

pagetop("headersuppress", "Home"  );

echo "\n<script src=\"tf.js\"><!-- --></script>\n";
echo "\n<script src=\"calendar.js\"><!-- --></script>\n";
echo "\n<script src=\"tf_multipleanswer.js\"><!-- --></script>\n";

$datecode=gracefuldecay($_REQUEST["datecode"], todaydatecode());
$date=date("l M d Y H:i:s", makedate(laterday($datecode, 1), $timeforquery)). " GMT" ;
$practitioner_id=$_REQUEST["practitioner_id"];
if($displaymode=="forceclient" || ($officetoken!=""  || strtolower($officetoken)=="www") && $mode!= "office")
{
 
 
	if($ourofficerecord)
	{
	
	?>
	<table cellpadding=12>
	<tr>
	<td valign="top">
	<a href="officeinfo.php"><div class="patientbutton"><div style="float:left; margin-top:12px;margin-left:-2px;margin-right:5px"><img border="0" src="images/door.png"></div> <br>Welcome to our <?=locationtype?>.</p>  </div></a>
	<br>
	<a href="reg.php?<?=qpre?>mode=client"><div class="patientbutton"><div style="float:left; margin-top:12px;margin-left:-2px;margin-right:5px"><img  border="0" src="images/patrientreg_icon.png"></div> <br>Initial <?=customertype?> Registration.</p>  </div></a>
	<br>
	<a href="appointments.php?<?=qpre?>mode=client"><div class="patientbutton"><div style="float:left; margin-top:12px;margin-left:-2px;margin-right:12px"><img  border="0" src="images/patrientrcal_icon.png"></div> <br>My Appointments.</p>  </div></a>
	 
	</td>
	<td valign="top">
		<div id="idblanktablabel" style="background-image:url('images/whitebox_roundtop.png');width:375px;height:22px; font-family:helvetica, arial;color:#<?=textcolorontheme?>;font-weight:bold;font-size:16px; text-indent:0px;line-height:180%"></div>
		<div style="background-image:url('images/whitebox_middle.png');width:375px;height:200px;   background-repeat:repeat-y;padding-left:12px;font-weight:bold;font-family:helvetica, sans-serif; font-size:12px; color:#666666;">
	
	<div style="float:right; margin-left:10px; margin-right:20px">
	<?php
	
		echo FrontendOfficePicture($officetoken);
	
	
	
	?></div>
	Welcome to <?=$ourofficerecord["office_name"]?>.
	<br/><br/>
	
	 
		<?=$ourofficerecord["address"]?>
		<br/>
		<?=$ourofficerecord["city"]?>, <?=$ourofficerecord["state_code"]?>  <?=$ourofficerecord["zip"]?>
		<br/>
		phone: <?=$ourofficerecord["phone"]?>
		</div>
		<div style="background-image:url('images/whitebox_roundbottom.png');width:375px;height:22px; background-repeat:repeat-y; "></div>
		<br/> 
	</td>
	</tr>
		<tr>
		<td colspan="2"> 
				<? 
			 
				if($message!="")
				{
				?>
		 	 		<div class="message"><?=$message?></div>
					<br>
					<?php
				}
				?>
		
		</td>
		</tr>
	</table>
	
	<?
	}
	else
	{
	?>
	<div class="header">The office you are looking for does not exist.</div>
	<?php 
			 
			 
	
	}
}
else if($intOurLoginID=="")
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
			<p>			<a class="footercontent" href="info_complex.php?config=special" ><img src="images/whatdoes.png" width="303" height="51" alt="" border="0"></a>
</p>
			
			<p><a class="footercontent" href="reg.php?<?=qpre?>mode=office" ><img src="images/startorg.png" width="303" height="51" alt="" border="0"></a></p>
		  <p><a class="footercontent" href="reg.php?<?=qpre?>mode=office" ><img src="images/tryfree.png" width="303" height="51" alt="" border="0"></a></p>

			
		</td>
		<td>
			<div id="homepageboxheader"> </div>
			<div id="homepagebox"><div class="homepageboxinfo"><?=  DisplayContent("homepage blurb");?></div></div>
			<div id="homepageboxfooter"> </div>  
		</td>
	</tr>
</table>
<?php
}
else
{
?>
 
<?php
	if($bwlOffice)
	{
	 
		//echo"-" . gracefuldecay($ouruserrecord["scheduling_unit_size"], 15) . "-";
		$unitsize=gracefuldecay($ouruserrecord["scheduling_unit_size"], 15);
		if($unitsize<1)
		{
			$unitsize=15;
		}
		if($error!="")
		{
			?>
			<div class="error"><?=$error?></div>
			<br>
			<?
		}

		?>
	<form name="BForm">
	<input type="hidden" name="hoursopen" value="<?=gracefuldecay($ouruserrecord["hours_open"], "0*24")?>">
	<input type="hidden" name="middayclosed" value="<?=gracefuldecay($ouruserrecord["midday_closed"], "12*12.25")?>">
	<input type="hidden" name="daysopen" value="<?=gracefuldecay($ouruserrecord["days_open"],"0*7")?>">
	<input type="hidden" name="holidays" value="<?=$ouruserrecord["holidays"]?>">
	<!--nput type="hidden" name="data" value="2009,12,30,13,30,Caulfield,60,1232|2009,12,30,14,30,Henderson,60,1211"-->
	<input type="hidden" name="data" value="">
	<input type="hidden" name="granulesize" value="<?=$unitsize?>">
	<input type="hidden" name="hourstart" value="9">
	<input type="hidden" name="hourend" value="17">
	<input type="hidden" name="calwidth" value="<?=$calwidth?>">
	<input type="hidden" name="timestorage" value="">
	<br/>
	<div class="smallfreetab" style="position:absolute;top:<?=$calypos?>px;left:<?=$calxpos?>px;width:<?=$calwidth?>px;background-image:url(images/justtab_<?=$tablength?>.png);background-repeat:no-repeat;">&nbsp;<a style="color:#<?=textcolorontheme?>;text-decoration:none" href=index.php?datecode=<?=$datecode?>&practitioner_id=<?=$practitioner_id?>><?=$tabtitle?></a></div> 
	<center class="normaltext">
	<div style="position:absolute;top:<?=$calypos+22?>px;left:<?=$calxpos?>px;width:<?=$calwidth?>px;" class="weekcalendarsurroundtop">
	<?
			if($message!="")
			{
				?>
	 	 		<div " class="message"  style="padding:0px"><?=$message?><br><br></div>
				<br>
				<?
			}
?>
	<div id="idweekcaltopline">
	<?=professionaltype?>: 
<?php
// placeWeekCalendar(thisdate,  granulesizeinminutes, hourstart, hourend, width, extraparam)


//foreigntablepulldown($strDatabase, $strTable, $strIDField, $intDefault, $strLabelField="", &$namereturn, $bwlHiddenReturn=false, $strPreferredNameField="", $addedselectpairs="", $strWhereClause="")
echo str_replace(">none\n", ">all\n", foreigntablepulldown(our_db,  "practitioner", "practitioner_id", $_REQUEST["practitioner_id"],"practitioner_id", $namereturn,  false, "name", "onChange=\"frames['ajax'].location.href='calweekdata.php?practitioner_id=' + document.BForm.practitioner_id[document.BForm.practitioner_id.selectedIndex].value;\"", "office_id='" . $intOurOfficeID . "'"));

?>
 Pick a Date:<input name='godate' type='text' value='<?php echo date("m/d/Y", time());?>'> 
<input class="generictinybutton" name='submit' type='submit' value='Go' onclick="placeWeekCalendar(document.BForm.godate.value);return false"> 
 </div>&nbsp;<br>&nbsp;
 </div>
</form>

<div style="position:absolute;top:<?=$calypos+43?>px;left:<?=$calxpos?>px;width:<?=$calwidth?>px;" class="weekcalendarsurround" id='idweekcalendar'></div><br>
</center>

<br/>

<script>
	placeWeekCalendar('<?=$date?>');
</script>

<?

		echo "\n<iframe frameborder=\"0\" marginwidth=\"0\" marginheight=\"0\" width=\"1\" height=\"1\" name=\"ajax\" src=\"calweekdata.php?practitioner_id=" . $_REQUEST["practitioner_id"] . "\"></iframe>";


	}
		

		
			
	
}

pagebottom();  
?>
 
 
 
