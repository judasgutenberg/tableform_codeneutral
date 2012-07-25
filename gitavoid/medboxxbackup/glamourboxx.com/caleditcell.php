<?php

 

//include("header.php");
 //include("includes/bbcode.php");
  //include("includes/db.php");
  
include("header.php");
include("calendar_functions.php");
$title=sitename ." : Home";
 
 
$sql=conDB();
$strPHP=$_SERVER['PHP_SELF'];
$practitioner_id=$_REQUEST["practitioner_id"];
$timejs=$_REQUEST["time"];
//die($timejs);
$calendar_event_id=$_REQUEST["calendar_event_id"];
$appointment_duration=$_REQUEST["appointment_duration"];
$client_id=$_REQUEST["client_id"];
$mode=$_REQUEST["mode"];
//echo $practitioner_id . " " . $time  . "*" . $calendar_event_id;
$searchterm=$_REQUEST["searchterm"];
$search_type=gracefuldecay($_REQUEST["search_type"], "lastname");
$appointmentdefault=60;
$strDatabase=our_db;
//echo $time;
if($calendar_event_id=="")
{
	$time=parseBetween($timejs, " ", "GMT");
	
	
	//echo makedatecode($dtmNow);
	//echo date("Y-m-d H:i:s",$dtmNow);

	$dtmNow=strtotime($time);
}
else
{
	
	//we don't use this tool to change times
	$eventrecord=GenericDBLookup(our_db, "personal_calendar_event", "calendar_event_id", $calendar_event_id);
	$dtmNow=makedate($eventrecord["datecode"], $eventrecord["time"]);
	//must force timejs too to avoid fuckups
	$timejs=date("l M d Y H:i:s ", $dtmNow). "GMT" ;
	//die($eventrecord["datecode"] . " " .  $time);
}


$arrDate=getdate($dtmNow);
$notes=$_REQUEST["notes"];
$hours=$arrDate["hours"];
$minutes=$arrDate["minutes"];
?>
<html>
<head>
<title>calendar event tool</title>
<link rel="stylesheet" href="styles.css" type="text/css">

<script language="javascript" src="tableform_js.js" type="text/javascript"><!-- --></script>
<script language="javascript" src="calendar.js" type="text/javascript"><!-- --></script>
<script language="javascript" src="tf_tablesort.js" type="text/javascript"><!-- --></script>
<script>

function selectuser(id, name)
{
	document.AForm.client_id.value=id;
	document.AForm.patient_name.value=name;
	//idsearch, idsearchresults
	var searchresultsdiv=document.getElementById("idsearchresults");
	//var searchformdiv=document.getElementById("idsearch");
	searchresultsdiv.style.display='none';
} 

function JSEndLayerScript()
{
	if(document.CForm.practitioner_id)
	{
		practitioner_id=document.CForm.practitioner_id[document.CForm.practitioner_id.selectedIndex].value;
	}
	else
	{
		practitioner_id=document.BForm.practitioner_id[document.BForm.practitioner_id.selectedIndex].valu
	}
	parent.ajax.location.href='calweekdata.php?practitioner_id=' +  practitioner_id;
	weekcaltopline=parent.document.getElementById('idweekcaltopline');
	weekcaltopline.style.display='';
	window.close();
	return false;
}

</script>
</head>
<body style="background-color:#<?=themecolor?>">
<center>
 
<form name="CForm"><div  id="idinfoheader" class='datedisplay'>
<?php
if($mode=="another")
{
	echo "Additional " . customertype . ": ";
}
//foreigntablepulldown($strDatabase, $strTable, $strIDField, $intDefault, $strLabelField="", &$namereturn, $bwlHiddenReturn=false, $strPreferredNameField="", $addedselectpairs="", $strWhereClause="")
?>
<?=professionaltype?>: <?=foreigntablepulldown(our_db,  "practitioner", "practitioner_id", $practitioner_id,"practitioner_id", $namereturn,  false, "name", "", "office_id='" . $intOurOfficeID . "'");?>
<?=date("l F d, Y g:i A", $dtmNow);?> 



</div>
</form>

<?php
$out="";
$bwlDontShowSpecificPatient=false;
if($intOurOfficeID=="")
{
 
 
}
else
{
	$arrHidden=Array("mode"=>$mode, "time"=>$timejs, "practitioner_id"=>$practitioner_id, "calendar_event_id"=>$calendar_event_id, "search_type"=>$search_type);
	if($bwlOffice)
	{	
		if($mode=="unschedule" && $calendar_event_id!="")
		{
			//echo "##";
			//NEED TO ADD SECURITY CODE IN HERE!!!!
			//okay it is secure now!!
			$strSQL="DELETE FROM " . $strDatabase .".personal_calendar_event WHERE  office_id='" .$intOurOfficeID  . "' AND calendar_event_id='" . $calendar_event_id. "'";
			$records = $sql->query($strSQL);
			$strSQL="DELETE FROM " . $strDatabase .".phone_call WHERE  office_id='" .$intOurOfficeID  . "' AND calendar_event_id='" . $calendar_event_id. "'";
			$records = $sql->query($strSQL);
			$out=EndLayerScript($practitioner_id);
		}
		if($searchterm==""  && $calendar_event_id=="")
		{
			$arrHidden["practitioner_id"]="";
			$out.="<div  id=\"idsearch\"  >\n";
			$out.=GenericForm(Array("searchterm", "search_type"),  Array("Search For a Client", "Search by"), $arrHidden, Array("search_type"=>"dropdown:firstname|First&nbsp;name-lastname|Last&nbsp;name-city|City-zip|Zip Code-email|Email-phone|Home Phone-client_id|" . customertype . "&nbsp;ID"), $strPHP,  "Search", "100%",  "",  "onsubmit='document.BForm.practitioner_id.value=document.CForm.practitioner_id[document.CForm.practitioner_id.selectedIndex].value;return true'", "BForm", false, Array("*onClick=JSEndLayerScript()"=>"Cancel"));
			$out.="</div>";
		}
		//echo $intOurLoginID . "_" . $appointment_duration . "@" . $user_id. "@" . $practitioner_id . "&" . $notes . "*" .$calendar_event_id . "="  . $mode ;
		//die();
			//die("DD");
		if($appointment_duration!="" && $client_id!="" && $practitioner_id!="" &&( $mode=="save" || $mode="another"))
		{
			//echo $intOurOfficeID . "_" . $appointment_duration . "@" . $client_id. "@" . $practitioner_id . "&" . $notes . "*" .$calendar_event_id ;
			//die();
			$arrAlteredValuePairs=Array
			(
				"datecode"=>makedatecode($dtmNow),
				"time"=>$hours . ":" . $minutes,
				"duration"=>$appointment_duration,
				"client_id"=>$client_id,
				"practitioner_id"=>$practitioner_id,
				"office_id"=>$intOurOfficeID,
				"notes"=> $notes
	 
			
			);
		
			$arrID="";
			if($calendar_event_id!="")
			{
				$arrID["calendar_event_id"]=$calendar_event_id;
			}
			if(!ClientBelongsToOffice($client_id, $intOurOfficeID))
			{
				die("You attempted to alter a " . customertype . " who doesn't belong to your " . locationtype . ".");
			}
			//$ocalendar_event_id=$calendar_event_id;
			$calendar_event_id=gracefuldecaynumeric(UpdateOrInsert($strDatabase, "personal_calendar_event",$arrID, $arrAlteredValuePairs), $calendar_event_id);
	 		//die($calendar_event_id);
			if($calendar_event_id!="")
			{
				
				ScheduleAPhoneCall($calendar_event_id);
			}
			$out=EndLayerScript($practitioner_id);
		}
		else if($mode=="save")
		{
			$missing="";
			if($practitioner_id=="")
			{
				$missing="a " .  strtolower(professionaltype);
			}
			if($appointment_duration=="")
			{
				$missing.=IfAThenB($missing, " and "). "a duration";
			}
			$out.="<div class='error'>You didn't include " . $missing . ".</div>";
		}
		else if($searchterm!="")
		{
			$strSQL="SELECT *  FROM " . $strDatabase. ".client u  JOIN  " . $strDatabase. ".client_office_map p ON u.client_id=p.client_id WHERE office_id='" .$intOurOfficeID . "' AND " . $search_type . " LIKE '%" . $searchterm . "%' ORDER BY lastname ";
			//echo $strSQL;
			//GenericRSDisplay($strDatabase, $strPHP,$strLabel, $strSQL, $truncate, $intWidth, $strLinkFieldName="", $strLinkIDName="", $strAdditionalLink="", $strSuppressFields="", $bwlSuppressHeader=false, $bwlPrettyUpFieldNames=true, $intFieldLimit=10, $idencryptionstring="", $arrPostProcessing="")
			 
			$results=GenericRSDisplay($strDatabase, "",$strLabel, $strSQL, $truncate, $intWidth,  "client_id",  "client_id",  " <a target='new' href=\"view.php?client_id=<replace/>\">edit</a> |  <a href=\"javascript:selectuser('<replace/>','<firstname> <lastname>')\">select</a>",  "guardian_client_id city name_of_guardian subdomain zip office_name password address state_code",  false, true,  12, "", "");
			if($results=="")
			{
				$results="<div class='noresults'>No " . strtolower(pluralize(customertype)) . " were found.</div>";
			}
			$results=IfAThenB($results, "<div class='message'>Patient Search Results:</div>") . $results;
			$out.=IfAThenB($results, "<div  id=\"idsearchresults\"  >\n" . $results . "</div>");
		
		}
		else if($calendar_event_id!="" && $mode!="specificevent")
		{
			$strSQL="SELECT * FROM " . $strDatabase. ".personal_calendar_event WHERE calendar_event_id='" .$calendar_event_id . "'";
			$records = $sql->query($strSQL);
			$eventdefaults=$records[0];
			$datecode=$eventdefaults["datecode"];
			$time=$eventdefaults["time"];
			
			$practitioner_id=$eventdefaults["practitioner_id"];
			$strSQL="SELECT u.firstname, u.lastname, u.client_id, e.calendar_event_id FROM " . $strDatabase. ".personal_calendar_event e JOIN " . our_db . ".client u ON e.client_id=u.client_id JOIN " . $strDatabase. ".practitioner p ON e.practitioner_id=p.practitioner_id WHERE datecode='" .$datecode . "' AND time='" .$time . "' AND p.practitioner_id='" . $practitioner_id . "'";
	
			//echo $strSQL;
			$records = $sql->query($strSQL);
			
			//echo count($records);
			if(count($records)>1)
			{
				////$out.=" <br><br> <a onclick='return(confirm(\"Are you sure you want to unschedule this appointment?\"))' class='nav' href='caleditcell.php?calendar_event_id=" . $calendar_event_id . "&mode=unschedule'>Unschedule appointment</a>";
				$bwlDontShowSpecificPatient=true;
				$out.=GenericRSDisplayFromRS($strPHP,$strLabel, $records, $truncate, $intWidth,  "calendar_event_id",  "calendar_event_id",  " <a  href=\"caleditcell.php?practitioner_id=" .$practitioner_id . "&mode=specificevent&calendar_event_id=<replace/>\">edit</a> | <a onclick='return(confirm(\"Are you sure you want to unschedule this appointment?\"))'  href='caleditcell.php?calendar_event_id=<replace/>&mode=unschedule'>unschedule</a>" ,  "birthday guardian_client_id city name_of_guardian subdomain zip office_name password address state_code",  false, true,  12, "", "");
				//$out.=GenericRSDisplay($strDatabase, "",$strLabel, $strSQL, $truncate, $intWidth,  "user_id",  "user_id",  " <a target='new' href=\"view.php?user_id=<replace/>\">edit</a> |  <a href=\"javascript:selectuser('<replace/>','<firstname> <lastname>')\">select</a>",  "city name_of_guardian subdomain zip office_name password address state_code",  false, true,  12, "", "");
				
				
	
				
	
			}
			else
			{
			
				//SQL TO POPULATE A FORM FOR A SPECIFIC EVENT
				$strSQL="SELECT * FROM " . $strDatabase. ".personal_calendar_event e JOIN " . our_db . ".client u ON e.client_id=u.client_id JOIN " . $strDatabase. ".practitioner p ON e.practitioner_id=p.practitioner_id WHERE calendar_event_id='" .$calendar_event_id . "'";
				$records = $sql->query($strSQL);
				//echo $strSQL;
				//echo mysql_error();
				//$record=$records[0];
				
				
				
				//set timejs to be the time discovered here, not whatever was handed in
				$eventdefaults=$records[0];
				$timejs=date("l M d Y H:i:s ", makedate($eventdefaults["datecode"], $eventdefaults["time"])). "GMT" ;
				//echo $timejs;
				
			
			}
		
		
		}
		else if($calendar_event_id!=""  && $mode=="specificevent")//THIS WILL FIRE ONLY IF $mode contains the string "specificevent"
		{

			//from the assumption that there is only one patient scheduled per doctor per timeslot
			
		
			//echo "$$";
			$strSQL="SELECT * FROM " . $strDatabase. ".personal_calendar_event e JOIN " . our_db . ".client u ON e.client_id=u.client_id JOIN " . $strDatabase. ".practitioner p ON e.practitioner_id=p.practitioner_id WHERE calendar_event_id='" .$calendar_event_id . "'";
			$records = $sql->query($strSQL);
			//echo $strSQL;
			//echo mysql_error();
			$eventdefaults=$records[0];
			
			
		}
		else if($searchterm=="") //no existing calendar event, so we need a user browser
		{
		
			$strSQL="SELECT *  FROM client u  JOIN  " . our_db . ".client_office_map p ON u.client_id=p.client_id WHERE office_id='" .$intOurOfficeID . "' ORDER BY lastname";
			//echo $strSQL;
			//function GenericForm($arrFieldNames,  $arrLabels, $arrDefaults, $arrFieldConfigs, $strPHP, $strButtonLabel="Save", $width=630, $arrSizes="", $formextratags="")
			
		//http://medboxx.com/view.php?x_table=user&x_othertable=personal_calendar_event&user_id=69
		//http://medboxx.com/view.php?x_othertable=personal_calendar_event&x_table=user&user_id=28
		}
		//echo $eventdefaults["notes"];
		//echo"#";
		$mode=gracefuldecay($mode, "save");
		if(is_array($eventdefaults))
		{
			$arrHidden=array_merge( $eventdefaults, $arrHidden);
			$arrHidden["patient_name"]=$eventdefaults["firstname"] . " " . $eventdefaults["lastname"] ;
			
		}
		else
		{
			$arrHidden["appointment_duration"]= $appointmentdefault;
		}
		//because we want to tag this block as time start
		//echo $timejs . " -" . $eventdefaults["datecode"] . "- +" .$eventdefaults["time"]  ;
 		//$timejs=date("l M d Y H:i:s ", makedate($eventdefaults["datecode"], $eventdefaults["time"])). "GMT-0400" ;
		//echo $timejs;
		//$arrHidden["time"]=$eventdefaults["time"];
		$arrHidden["time"]=$timejs;
		$arrHidden["datecode"]=$eventdefaults["datecode"];
		//echo $timejs;
		$arrHidden["appointment_duration"]=gracefuldecaynumeric($arrHidden["duration"], $appointmentdefault);
		$arrHidden["mode"]=$mode;	$formextratags="onSubmit=\";document.AForm.practitioner_id.value=document.CForm.practitioner_id[document.CForm.practitioner_id.selectedIndex].value;parent.document.BForm.practitioner_id.selectedIndex=document.CForm.practitioner_id.selectedIndex;if(document.AForm.client_id.value==''){alert('You need to select a patient.'); return false;}return true\"";
		if(!$bwlDontShowSpecificPatient && ($searchterm!=""  || $calendar_event_id!="")) //no existing calendar event, so we need a user browser
		{
 			$out.=  GenericForm(Array("patient_name", "client_id", "appointment_duration", "notes"),  Array(  customertype ." Name", customertype . " ID", "Appointment Duration", "Notes"), $arrHidden, Array("appointment_duration"=>"dropdown:5|5&nbsp;minutes-10|10&nbsp;minutes-15|15&nbsp;minutes-20|20&nbsp;minutes-30|30&nbsp;minutes-45|45&nbsp;minutes-60|one&nbsp;hour-90|90&nbsp;minutes-120|2&nbsp;hours-180|3&nbsp;hours-240|4&nbsp;hours-300|5&nbsp;hours-360|6&nbsp;hours", "notes"=>"size:2030"), $strPHP,  "Schedule", "100%",  "", $formextratags, "AForm", false, Array("*onClick=JSEndLayerScript()"=>"Don't Save"));
		}
		$out.="<br><div class='nav'>";
		if($calendar_event_id!="")
		{
			$out.="<a class='nav' href='caleditcell.php?mode=another&time=" . urlencode($timejs) . "&practitioner_id=" .$practitioner_id . "'>Schedule Additional " . customertype . " for this Time Slot</a>";
		}
		if(!($searchterm==""  && $calendar_event_id==""))
		{
			
			$out.=" <br><br> <a class='nav' href='caleditcell.php?time=" . urlencode($timejs) . "&practitioner_id=" .$practitioner_id . "'>Search for another " . strtolower(customertype) . "</a> ";
		}
		$out.=" <br><br> <a  class='nav' href='javascript:bestclose(\"" . ($timejs)  . "\",\"" .$practitioner_id . "\")'>Back to schedule</a> ";
		if($calendar_event_id!="")
		{
		
		 	//$out.=" <br><br> <a onclick='return(confirm(\"Are you sure you want to unschedule this appointment?\"))' class='nav' href='caleditcell.php?calendar_event_id=" . $calendar_event_id . "&mode=unschedule'>Unschedule appointment</a>";
		 }
		 $out.="</div>";
		 
		//dropdown:
 	
	}
	else
	{
	
	}
}
echo $out;
 

 
 
function EndLayerScript($practitioner_id)
{
	$out="<script>\n";
	//$out.="alert('manner');\n";
	$out.="if(parent.ajax)\n";
	$out.="{\n";
	$out.="parent.ajax.location.href='calweekdata.php?practitioner_id=" .$practitioner_id. "';\n";
	$out.="weekcaltopline=parent.document.getElementById('idweekcaltopline');\n";
	$out.="weekcaltopline.style.display='';\n";
	$out.="}\n";
	$out.="else\n";
	$out.="{\n";
	$out.="parent.location.reload()\n";
	$out.="}\n";
	$out.="window.close()\n";
	$out.="</script>\n";
	return $out;
}


	
	?>
	</center>
</body>
</html>
	
	
	
	
