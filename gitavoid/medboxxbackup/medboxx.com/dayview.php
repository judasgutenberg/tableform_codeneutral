<?php

$title="Medboxx : Home";
//include("header.php");
 //include("includes/bbcode.php");
  //include("includes/db.php");
  
 include("header.php");
 include("calendar_functions.php");

//open a connection to mysql db

 
//
// Set page ID for session management
//
//$userdata = session_pagestart($user_ip, PAGE_LOGIN);
//init_userprefs($userdata);
 
///////////THIS FILE IS A MESS BUT IT WORKS SORT OF

$sql=conDB();
 //echo phpinfo();
//echo $intOurLoginID . "_______" ;
$membername=GenericDBLookup(our_db,"bb_user", "user_id", $intOurLoginID, "username");
$cookiename=GenericDBLookup(our_db,"bb_config", "config_name", "cookie_name", "config_value");
$strPHP=$_SERVER['PHP_SELF'];
$datecode=gracefuldecay($_REQUEST["datecode"], todaydatecode());
//$intOurOfficeID=$_REQUEST["office_id"];
$practitioner_id=$_REQUEST["practitioner_id"];

$strPHP=$_SERVER['PHP_SELF'];

  
$tablength=CalculateTabLength($tabtitle);
$sql=conDB();
$strPHP=$_SERVER['PHP_SELF'];
include_once("frontend.php");
 
include("questionnaire_functions.php");

pagetop("headersuppress", "Home"  );
//place for content!!!

?>
<script language="javascript" src="tf_tablesort.js" type="text/javascript"><!-- --></script>
<?
echo "\n<script src=\"tableform_js.js\"><!-- --></script>\n";
echo "\n<script src=\"calendar.js\"><!-- --></script>\n";
echo "\n<script src=\"multipleanswer_js.js\"><!-- --></script>\n";


	 
function DivedDayView($intOurOfficeID, $datecode, $practitioner_id, $intWidth, $intStart=0, $intNumber=10)
{
	$officerec=GenericDBLookup(our_db, "office", "office_id", $intOurOfficeID);
	$strPHP=$_SERVER['PHP_SELF'];
	$occupiedcolor="993333";
	$unusedcolor="cc9966";
	$scheduling_unit_size=gracefuldecay($officerec["scheduling_unit_size"], 15);
	$days_open=$officerec["days_open"];
	$hours_open=$officerec["hours_open"];
	$midday_closed=$officerec["midday_closed"];
	$holidays=$officerec["holidays"];
	$arrHours=explode("*", $hours_open);
	$intHourStart=$arrHours[0];
	$intHourEnd=$arrHours[1];
	$sql=conDB();
	$arrDuration=Array();
	$appointmentcountforcolumn=Array();
	$cellcountForAppointment=Array();
	$occupied=Array();
	$ceidtouse=Array();
	$Appointmentdata=Array();
	$unitsOpen=intval(intval($intHourEnd*60)-intval($intHourStart*60));
	if($practitioner_id==0)
	{
		$practitioner_id="";
	}
	$padding="&nbsp;&nbsp;";
	if($practitioner_id=="")
	{
		$strSQL="SELECT * FROM " . our_db . ".practitioner WHERE  office_id=" . $intOurOfficeID . " ORDER BY name LIMIT " . $intStart . "," . $intNumber . " ";
		
		$drecords = $sql->query($strSQL);
	
	}
	else
	{
			$drec=GenericDBLookup(our_db, "practitioner", "practitioner_id",  intval($practitioner_id));
			$doctorname=$drec["name"];
 			$padding=$doctorname;
	
		$maxsimultaneous= MaxSimultaneousAppointments($practitioner_id);
		//die($maxsimultaneous);
	}
	$intTruncSize=50-count($drecords )*5;
	//echo $intHourStart . " " . $intHourEnd . " " . $scheduling_unit_size . " " . $unitsOpen;
	$out.="<table  border='0' cellspacing='0' cellpadding='0' width='" .  $intWidth . "'>\n";
	 
	$out.="<tr class='weekcalendarnavheader'>\n";
	$out.="<td  align='left' colspan='4'>\n";
	$out.="<a class='weekcalendarnav'href=\"" . $strPHP . "?practitioner_id=" .   intval($practitioner_id) . "&datecode="  .  earlierday($datecode,7) . "\">&lt;&lt;earlier week</a>\n";
	$out.="&nbsp;&nbsp;";
	$out.="<a class='weekcalendarnav'href=\"" . $strPHP . "?practitioner_id=" .   intval($practitioner_id) . "&datecode="  .  earlierday($datecode) . "\">&lt;earlier day</a>\n";
	
 
	$out.="</td>\n";
	$out.="<td class=\"onredinfo\" >\n";
	$out.=$padding;
	$out.="</td>\n";
	$out.="<td  align='right' colspan='4'>\n";
	$out.="<a class='weekcalendarnav' href=\"" . $strPHP . "?practitioner_id=" .  intval($practitioner_id). "&datecode="  .  laterday($datecode) . "\">later day&gt;</a>\n";
	
	$out.="&nbsp;&nbsp;";
	$out.="<a class='weekcalendarnav'  href=\"" . $strPHP . "?practitioner_id=" .  intval($practitioner_id) . "&datecode="  .  laterday($datecode,7) . "\">later week&gt;&gt;</a>\n";
	$out.="</td>\n";
	$out.="</tr>\n";
	$out.="</table>";
	$out.="<table  border='0' cellspacing='0' cellpadding='0' width='" .  $intWidth . "'>\n";
	$out.="<tr>\n";
	$out.="<td>\n";
	$out.="</td>\n";
	if(is_array($drecords))
	{
		foreach($drecords as $thisdrecord)
		{
			$out.="<td >\n";
			$out.="<a href=\"" . $strPHP . "?datecode=" . $datecode . "&practitioner_id=" . $thisdrecord["practitioner_id"] . "\">"; 
			$out.=trunchandler($thisdrecord["name"], $intTruncSize);
			$out.="</a>";
			$out.="</td>\n";
			
		}
	}
	else
	{
		//$maxsimultaneous
		for($thiscount=0; $thiscount<$maxsimultaneous; $thiscount++)
		{
			$out.="<td >\n";
			$out.="";
			$out.="</td>\n";
			
		}
	}
	$out.="</tr>\n";
	$cellcount=0;
	$appointmentnumber=0;
	for($i=$intHourStart*60; $i<=$intHourStart*60+ $unitsOpen; $i=$scheduling_unit_size+$i)
	{
		$intCalcColspan=0;
		$strRowClass="";
		$thishour=intval($i/60);
		$displayhour=$thishour % 12;
		if($displayhour==0)
		{
			$displayhour=12;
		}
		$thisminute=$i-($thishour*60);
		$thisminuteforquery=$thisminute;
		$thisminute=str_pad($thisminute, 2,  "0");
		$strRowClass=' class="weekrow"';
		$strMinuteClass='minutelabel';
		
		if($i/60==intval($i/60))
		{
			$strRowClass=' class="weektablehour"';
			$strMinuteClass='hourlabel';
		}
		$out.="<tr " . $strRowClass . ">\n";
		$out.="<td style=\"width:5%\" class='" . $strMinuteClass . "'>\n";
		$timeforquery=$thishour . ":" .  $thisminuteforquery ;
		$timefordisplay=$displayhour . ":" .  $thisminute ;
		$jsdtmInstant=date("l M d Y H:i:s", makedate($datecode, $timeforquery)). " GMT" ;
		$out.=$timefordisplay . "\n";
		$intCalcColspan++;
		$out.="</td>\n";
		if(is_array($drecords))
		{
			
			foreach($drecords as $thisdrecord)
			{
				$practitioner_id =$thisdrecord["practitioner_id"];
				$glowbehavior="";
				
				$thiscellcolortouse=$unusedcolor;
				//the join will toss out records from invalid clients in the db
				$strSQL="SELECT * FROM " . our_db . ".personal_calendar_event e JOIN client c ON e.client_id=c.client_id WHERE practitioner_id='" .  intval($practitioner_id) . "' AND datecode='" .intval($datecode) . "' AND time='" . $timeforquery. "' AND office_id='" . $intOurOfficeID . "'";
				//echo $strSQL . "<p>";
				$records = $sql->query($strSQL);
				$reczero=$records[0];
				if(count($records)>0)
				{
					$appointmentnumber++;
					$appointmentcountforcolumn[$intCalcColspan]++;
					if( $appointmentcountforcolumn[$intCalcColspan]=="")
					{
						 $appointmentcountforcolumn[$intCalcColspan]=0;
					}
					if($cellcountForAppointment[$appointmentcountforcolumn[$intCalcColspan]]=="")
					{
						$cellcountForAppointment[$appointmentcountforcolumn[$intCalcColspan]]=0;
					}
					
			 		if($occupied[$intCalcColspan]=="")
					{
						$occupied[$intCalcColspan]=0;
					}
					$occupied[$intCalcColspan]++;
					
					
				
					
					$thiscellidroot="idoccupied-" . $intCalcColspan . "-"   .$appointmentcountforcolumn[$intCalcColspan];
					$thiscellid=$thiscellidroot . "-" . $cellcountForAppointment[$appointmentcountforcolumn[$intCalcColspan]];
					$ceidtouse[$intCalcColspan . "-" . $appointmentcountforcolumn[$intCalcColspan]]= $reczero["calendar_event_id"];
					$cellcountForAppointment[$appointmentcountforcolumn[$intCalcColspan]]++;
					
				}
				else if($arrDuration[$intCalcColspan]>0)
				{
				
					$cellcountForAppointment[$appointmentcountforcolumn[$intCalcColspan]]++;
					//$cellcountForAppointment[$appointmentcountforcolumn[$intCalcColspan]]++;
					$thiscellidroot="idoccupied-" . $intCalcColspan .    "-" .$appointmentcountforcolumn[$intCalcColspan];
					$thiscellid=$thiscellidroot . "-" . $cellcountForAppointment[$appointmentcountforcolumn[$intCalcColspan]];
				}
				else if($arrDuration[$intCalcColspan]<1)
				{
					$thiscellid="id" . $cellcount;
					$ceidtouse[$intCalcColspan . "-" . $appointmentcountforcolumn[$intCalcColspan]]="";
				}
			 	
				
				$thiscelldata="";
				foreach($records as $record)
				{
					$firstname=$record["firstname"];
					$lastname=$record["lastname"];
					
					$thisduration=$record["duration"];
					if($arrDuration[$intCalcColspan]<$thisduration)
					{
 
						$arrDuration[$intCalcColspan]=$thisduration;
					}
					
					$thiscelldata=JoinList("<br>", $thiscelldata, $firstname . " " . $lastname);
					
				}
				if($arrDuration[$intCalcColspan]>0)
				{
					
					$thiscellcolortouse=$occupiedcolor;
					$glowbehavior="onmouseover=\"occupiedglow('" .$thiscellidroot . "', 'on')\" onmouseout=\"occupiedglow('" .$thiscellidroot ."', 'off')\"";
				}
				else
				{
					$glowbehavior="onmouseover=\"glow('" . $thiscellid . "', 'on')\" onmouseout=\"glow('" . $thiscellid . "', 'off')\"";
				}
				
				$out.="<td id='" . $thiscellid . "' " . $glowbehavior . " style=\"font-size:10px;color:#ffffff\" onclick=\"ecell('" . $jsdtmInstant . "','". intval($practitioner_id)  . "','" . $ceidtouse[$intCalcColspan . "-" . $appointmentcountforcolumn[$intCalcColspan]]. "')\" " . $strRowClass . " bgcolor='#" . $thiscellcolortouse . "'>\n"; 
				$cellcount++;
				//$out.="<td class='" . $strMinuteClass . "'>\n";
				
				$out.= $thiscelldata;
				//$out.=   "<BR>" .$ceidtouse[$intCalcColspan . "-" . $appointmentcountforcolumn[$intCalcColspan]];
				//$out.=   "<BR>" . $thiscellid;
				//$out.=   "<BR>" .$intCalcColspan;
				//$out.=   "<BR>" . $appointmentcountforcolumn[$intCalcColspan];
				//$out.= . " " . $arrDuration[$intCalcColspan];
				$out.="</td>\n";
				$arrDuration[$intCalcColspan]=$arrDuration[$intCalcColspan]-$scheduling_unit_size;
				$intCalcColspan++;
				
			}
		}
		else
		{
			$strSQL="SELECT * FROM " . our_db . ".personal_calendar_event e JOIN client c ON e.client_id=c.client_id WHERE practitioner_id='" .  intval($practitioner_id) . "' AND datecode='" .intval($datecode) . "' AND time='" . $timeforquery. "' AND office_id='" . $intOurOfficeID . "'";
				//echo $strSQL . "<BR>";
			$records = $sql->query($strSQL);
	 
			//$maxsimultaneous
			if(count($records)>0)
			{
			
				for($thiscount=0;   $thiscount<$maxsimultaneous; $thiscount++)
				{
					$appointmentnumber++;
					$thiscellcolortouse=$unusedcolor;
					$record=$records[$thiscount];
					$firstname=$record["firstname"];
					$lastname=$record["lastname"];
					
					$arrDuration[$intCalcColspan]=$record["duration"];
				
	
					
					
					$thiscelldata=  $firstname . " " . $lastname;
					
					$appointmentcountforcolumn[$intCalcColspan]++;
					if( $appointmentcountforcolumn[$intCalcColspan]=="")
					{
						 $appointmentcountforcolumn[$intCalcColspan]=0;
					}
					if($cellcountForAppointment[$appointmentcountforcolumn[$intCalcColspan]]=="")
					{
						$cellcountForAppointment[$appointmentcountforcolumn[$intCalcColspan]]=0;
					}
					
			 		if($occupied[$intCalcColspan]=="")
					{
						$occupied[$intCalcColspan]=0;
					}
					if($record["calendar_event_id"]!="")
					{
						$cellcountForAppointment[$appointmentcountforcolumn[$intCalcColspan]]=0
						$thiscellcolortouse=$occupiedcolor;
						$occupied[$intCalcColspan]++;
						$thiscellidroot="idoccupied-" . $intCalcColspan . "-"   .$appointmentcountforcolumn[$intCalcColspan];
						$thiscellid=$thiscellidroot . "-" . $cellcountForAppointment[$appointmentcountforcolumn[$intCalcColspan]];
						$ceidtouse[$intCalcColspan . "-" . $appointmentcountforcolumn[$intCalcColspan]]= $record["calendar_event_id"];
						$cellcountForAppointment[$appointmentcountforcolumn[$intCalcColspan]]++;	
						$glowbehavior="onmouseover=\"occupiedglow('" .$thiscellidroot . "', 'on')\" onmouseout=\"occupiedglow('" .$thiscellidroot ."', 'off')\"";
						$Appointmentdata[$thiscellidroot . "-" . 1]="&nbsp;&nbsp;" . $record["city"];
						$Appointmentdata[$thiscellidroot . "-" . 2]="&nbsp;&nbsp;" . $record["email"];
						$Appointmentdata[$thiscellidroot . "-" . 3]="&nbsp;&nbsp;" .$record["phone"];
						$Appointmentdata[$thiscellidroot . "-" . 0]="&nbsp;&nbsp;" .$record["phone"];
						//echo $thiscellidroot . "-" . $arrDuration[$intCalcColspan] . "*<BR>";
					}
					else
					{
						$thiscellid="id" . $cellcount;
						$ceidtouse[$intCalcColspan . "-" . $appointmentcountforcolumn[$intCalcColspan]]="";
						$thiscellcolortouse=$unusedcolor;
						$glowbehavior="onmouseover=\"glow('" . $thiscellid . "', 'on')\" onmouseout=\"glow('" . $thiscellid . "', 'off')\"";
						$thiscelldata="";
					}
						
					$out.="<td id='" . $thiscellid . "' " . $glowbehavior . " style=\"font-size:10px;color:#ffffff\" onclick=\"ecell('" . $jsdtmInstant . "','". intval($practitioner_id)  . "','" . $ceidtouse[$intCalcColspan . "-" . $appointmentcountforcolumn[$intCalcColspan]]. "')\" " . $strRowClass . " bgcolor='#" . $thiscellcolortouse . "'>\n"; 
					$out.=$thiscelldata;
					//$out.= " " . $thiscellid ;
					//$out.= " " . $ceidtouse[$intCalcColspan . "-" . $appointmentcountforcolumn[$intCalcColspan]];
					$out.="</td>\n";
					$arrDuration[$intCalcColspan]=$arrDuration[$intCalcColspan]-$scheduling_unit_size;
					$intCalcColspan++;
					$cellcount++;
					$appointmentnumber++;
				}
			}
			else
			{
			
				for($thiscount=0;   $thiscount<$maxsimultaneous; $thiscount++)
				{
					if($arrDuration[$intCalcColspan]>0)
					{
						
						//$cellcountForAppointment[$appointmentcountforcolumn[$intCalcColspan]]++;
						$thiscellidroot="idoccupied-" . $intCalcColspan .    "-" .$appointmentcountforcolumn[$intCalcColspan];
						$thiscellid=$thiscellidroot . "-" . $cellcountForAppointment[$appointmentcountforcolumn[$intCalcColspan]];
						$thiscellcolortouse=$occupiedcolor;
						$glowbehavior="onmouseover=\"occupiedglow('" .$thiscellidroot . "', 'on')\" onmouseout=\"occupiedglow('" .$thiscellidroot ."', 'off')\"";
						$thiscelldata=$Appointmentdata[$thiscellidroot . "-" . $cellcountForAppointment[$appointmentcountforcolumn[$intCalcColspan]]];
						echo $thiscellidroot . "-" . $cellcountForAppointment[$appointmentcountforcolumn[$intCalcColspan]] . "=<BR>";
						$cellcountForAppointment[$appointmentcountforcolumn[$intCalcColspan]]++;
					}
					else
					{
						$thiscelldata="";
						$thiscellcolortouse=$unusedcolor;
						$thiscellid="id" . $cellcount;
						$ceidtouse[$intCalcColspan . "-" . $appointmentcountforcolumn[$intCalcColspan]]="";
						$glowbehavior="onmouseover=\"glow('" . $thiscellid . "', 'on')\" onmouseout=\"glow('" . $thiscellid . "', 'off')\"";
					}
					$out.="<td id='" . $thiscellid . "' " . $glowbehavior . " style=\"font-size:10px;color:#ffffff\" onclick=\"ecell('" . $jsdtmInstant . "','". intval($practitioner_id)  . "','" . $ceidtouse[$intCalcColspan . "-" . $appointmentcountforcolumn[$intCalcColspan]]. "')\" " . $strRowClass . " bgcolor='#" . $thiscellcolortouse . "'>\n"; 
					$out.=$thiscelldata;
					//$out.= " " . $thiscellid ;
					//$out.= " " . $thiscellid ;
					//$out.= " " . $arrDuration[$intCalcColspan];
					//$out.= " " . $ceidtouse[$intCalcColspan . "-" . $appointmentcountforcolumn[$intCalcColspan]];
					$out.="</td>\n";
					$arrDuration[$intCalcColspan]=$arrDuration[$intCalcColspan]-$scheduling_unit_size;
					$intCalcColspan++;
					$cellcount++;
					
				}
				
			}
			
			
		}
		$out.="</tr>\n";
	}
	$out.="<tr>\n";
	$out.="<td class=\"bottomline\" colspan=\"" . $intCalcColspan . "\">\n";
	$out.="</td>\n";
	$out.="</tr>\n";
	$out.="</table>\n";
	return $out;
}
 




if($intOurLoginID=="")
{
?>
 

  
<?php
 
}
else
{

	if($bwlOffice)
	{
	
		$tabtitle="" . date("l F jS, Y", makedate($datecode));
		$tablength=CalculateTabLength($tabtitle . "SSSSSSSSSSSSSSSSSfffffffffffS");
		$calxpos=65;
		$calypos=120;
		$calwidth=900;
	?>
 

	<form name="BForm">
	<input type="hidden" name="calendardata" value=""> 
 	<input type="hidden" name="thisdate" value="">
 	</form>

	
		<div class="smallfreetab" style="position:absolute;top:<?=$calypos?>px;left:<?=$calxpos?>px;width:<?=$calwidth?>px;background-image:url(images/justtab_<?=$tablength?>.png);background-repeat:no-repeat;">&nbsp;<a style="color:#ffffff;text-decoration:none" href=dayview.php?datecode=<?=$datecode?>&practitioner_id=<?=$practitioner_id?>><?=$tabtitle?></a></div> 
	<center class="normaltext">
	<div style="position:absolute;top:<?=$calypos+22?>px;left:<?=$calxpos?>px;width:<?=$calwidth?>px;" class="weekcalendarsurroundtop">
	<div id="idweekcalendarbody">
	<div id="idweekcaltopline">
	
	
 	<!--
	<br/>
	<div id="idblanktablabel" style="background-image:url('images/blankredtabtop_<?=$tablength?>.png');width:595px;height:28px; font-family:helvetica, arial;color:#ffffff;font-weight:bold;font-size:16px; text-indent:0px;line-height:180%">&nbsp;&nbsp;&nbsp;<span style="font-size:23px"><?=$tabtitle?></font></div>
	<div style="background-image:url('images/596_back.png');width:595px; ; background-repeat:repeat-y;">
	<center class='header'>
	-->
<?
// GenericRSDisplay($strDatabase, $strPHP,$strLabel, $strSQL, $truncate, $intWidth, $strLinkFieldName="", $strLinkIDName="", $strAdditionalLink="", $strSuppressFields="", $bwlSuppressHeader=false, $bwlPrettyUpFieldNames=true, $intFieldLimit=10, $idencryptionstring="", $arrPostProcessing="")
 
 
 	//$strLabel="<a href='index.php'>Schedule</a> | " . "Day view for " . date("l F jS, Y", makedate($datecode)) ;
			
	$dayview=DivedDayView($intOurOfficeID, $datecode, $practitioner_id, $calwidth);
	//echo "<div class='header'>&nbsp;&nbsp;&nbsp;&nbsp;" .$strLabel . "</div>";
	echo "<center>";
	echo $dayview;
	if($dayview=="")
	{
		echo "There are no appointments scheduled for this day.";
	}
	?>
	</center>
 
 
			 
 
	<!--
	</center>
	</div>
	<div style="background-image:url('images/596_bottom.png');width:595px;height:2px; background-repeat:repeat-y;"></div>
	<br/>
	-->
	 </div> 
 </div>
 </div>
	</center>
	
	<?
	 

	 
		
		 
			
			
	 
	 
	 
	 
	}
	else
	{
	?>
	<form action="appointments.php"><input class="profilebutton" type="submit" name="submit" value="View your appointment schedule"></form>
	<br/>
	<form action="reg.php"><input type="hidden" name="<?=qpre?>profilemode" value="profile"><input class="profilebutton" type="submit" name="submit" value="Edit your profile"></form>

	<?
}
}
 
pagebottom();


function PractitionerEditLink($practitioner_id)
{
	$record=GenericDBLookup(our_db, "practitioner", "practitioner_id", $practitioner_id);
	$out="<div class='header'>Appointments for <a href=\"view.php?practitioner_id=" . $practitioner_id. "\">" . $record["name"] . "</a></div>";
	return $out;
}


function PatientEditLink($client_id)
{
	$record=GenericDBLookup(our_db, "client", "client_id", $client_id);
	$out="<div class='header'>Appointments for <a href=\"view.php?client_id=" . $client_id. "\">" . $record["firstname"] . " " . $record["lastname"] . "</a></div>";
	return $out;
}
	
	
?>

 
 
 
