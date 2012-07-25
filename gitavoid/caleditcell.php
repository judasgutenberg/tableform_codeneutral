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
$phonecall_behavior_id=$_REQUEST["phonecall_behavior_id"];
$email_behavior_id=$_REQUEST["email_behavior_id"];
$reminder_content_id=intval($_REQUEST["reminder_content_id"]);
$event_type_id=1;
//echo $calendar_event_id;
if($reminder_content_id>0)
{
	$rsrc=GenericDBLookup(our_db, "reminder_content","reminder_content_id",$reminder_content_id, "");
	//$reminder_type_id=$rsrc["reminder_type_id"];
	$event_type_id=$rsrt["event_type_id"];
 
}
$event_status_id=gracefuldecay($_REQUEST["event_status_id"], 1);
$mode=$_REQUEST["mode"];
//echo $practitioner_id . " " . $time  . "*" . $calendar_event_id;
$searchterm=$_REQUEST["searchterm"];
$search_type=gracefuldecay($_REQUEST["search_type"], "lastname");
$appointmentdefault=60;
$strDatabase=our_db;
$intWidth=800;
if($_REQUEST[qpre . "unschedule"]!="")
{
	$mode="unschedule";
}
 
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
	if( $practitioner_id=="")
	{
		$practitioner_id=$eventrecord["practitioner_id"];
	}
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
<link rel="stylesheet" href="<?=strtolower(sitename)?>.styles.css" type="text/css">

<script language="javascript" src="tf.js" type="text/javascript"><!-- --></script>
<script language="javascript" src="calendar.js" type="text/javascript"><!-- --></script>
<script language="javascript" src="tf_tablesort.js" type="text/javascript"><!-- --></script>
<script>
function rootpractbiz()
{
	if(parent.document.BForm.practitioner_id)
	{
		parent.document.BForm.practitioner_id.selectedIndex=document.CForm.practitioner_id.selectedIndex;
	}
}

function NotNeedPractitioner()
{
	if(document.CForm.practitioner_id[document.CForm.practitioner_id.selectedIndex].value=="")
	{
		
		if(document.AForm.reminder_content_id[document.AForm.reminder_content_id.selectedIndex].value=="")
		{
			alert("You must select a staff member.");
			return false
		
		}
	}
		else
	{
		document.AForm.submit();
		return true;
	}

}

function selectuser(id, name, phonecall_behavior_id, email_behavior_id, reminder_content_id)
{
	var thisform=document.AForm;
	thisform.client_id.value=id;
	thisform.patient_name.value=name;
	
	thisform.phonecall_behavior_id.value=phonecall_behavior_id;
	thisform.email_behavior_id.value=email_behavior_id;
	thisform.reminder_content_id.value=reminder_content_id;
	//idsearch, idsearchresults
	var searchresultsdiv=document.getElementById("idsearchresults");
	//var searchformdiv=document.getElementById("idsearch");
	searchresultsdiv.style.display='none';
	
	var clientformdiv=document.getElementById("idclientformcontainer");
	if(clientformdiv)
	{
		clientformdiv.style.display='';
	}
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
if(strtolower(sitename)=="vetboxx.com")
{
	$strCustomerNoun=customertype . " or " . dependenttype;
	$strCustomerNounPlural=strtolower(pluralize(customertype) . " or " . pluralize(dependenttype));
}
else
{
	$strCustomerNoun=customertype;
	$strCustomerNounPlural=pluralize(customertype);
}

if($mode=="another")
{
	echo "Additional " . $strCustomerNounPlural . ": ";
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

$strSQL="SELECT * FROM reminder_content WHERE office_id='" . intval($intOurOfficeID ) . "'";

$rsReminderContents=$sql->query($strSQL);
echo $mode;

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
			//die( "##" . $calendar_event_id);
			//NEED TO ADD SECURITY CODE IN HERE!!!!
			//okay it is secure now!!
			$strSQL="DELETE FROM " . $strDatabase .".personal_calendar_event WHERE  office_id='" .$intOurOfficeID  . "' AND calendar_event_id='" . $calendar_event_id. "'";
			//echo $strSQL . "<BR>";
			$records = $sql->query($strSQL);
			$strSQL="DELETE FROM " . $strDatabase .".scheduled_contact WHERE  office_id='" .$intOurOfficeID  . "' AND calendar_event_id='" . $calendar_event_id. "'";
			$records = $sql->query($strSQL);
			//echo $strSQL . "<BR>";
			//die();
			$out=EndLayerScript($practitioner_id);
		}
		if($searchterm==""  && $calendar_event_id=="")
		{
			$arrHidden["practitioner_id"]="";
			$out.="<div  id=\"idsearch\"  >\n";
			
			$out.=GenericForm(Array("searchterm", "search_type"),  Array("Search For " . $strCustomerNoun, "Search by"), $arrHidden, Array("search_type"=>"dropdown:firstname|First&nbsp;name-lastname|Last&nbsp;name-city|City-zip|Zip Code-email|Email-phone|Home Phone-client_id|" . $strCustomerNoun . "&nbsp;ID"), $strPHP,  "Search", "100%",  "",  "onsubmit='document.BForm.practitioner_id.value=document.CForm.practitioner_id[document.CForm.practitioner_id.selectedIndex].value;return true'", "BForm", false, Array("*onClick=JSEndLayerScript()"=>"Cancel"));
			$out.="</div>";
		}
 
		//die();
			//die("DD");
		//echo $intOurOfficeID . "_" . $appointment_duration . "@" . $client_id. "@" . $practitioner_id . "&" . $notes . "*" .$calendar_event_id . "&" . $mode;
		if($appointment_duration!="" && $client_id!="" && ($practitioner_id!="" || $reminder_content_id!="") &&( $mode=="save" || $mode=="another"))
		{
	
			
			//die();
			//die($calendar_event_id . "&" . date("Y-m-d H:i:s",$dtmNow). " " .  makedatecode($dtmNow));
			$arrAlteredValuePairs=Array
			(
				
				"datecode"=>makedatecode($dtmNow),
				"time"=>$hours . ":" . $minutes,
				"duration"=>$appointment_duration,
				"client_id"=>$client_id,
				"practitioner_id"=>$practitioner_id,
				"office_id"=>$intOurOfficeID,
				"notes"=> $notes,
				"event_status_id"=>$event_status_id,
				"phonecall_behavior_id"=>$phonecall_behavior_id,
	 			"email_behavior_id"=>$email_behavior_id,
				"reminder_content_id"=>$reminder_content_id,
				"event_type_id"=>$event_type_id
			
			);
		
			$arrID="";
			if($calendar_event_id!="")
			{
				$arrID["calendar_event_id"]=$calendar_event_id;
			}
			if(!ClientBelongsToOffice($client_id, $intOurOfficeID))
			{
				die("You attempted to alter " . $strCustomerNoun . " who doesn't belong to your " . locationtype . ".");
			}
			$calendar_event_id=gracefuldecaynumeric(UpdateOrInsert($strDatabase, "personal_calendar_event",$arrID, $arrAlteredValuePairs), $calendar_event_id);

			//echo ("caleventid=" . $calendar_event_id);
			if($calendar_event_id!="")
			{
				
				ScheduleContacts($calendar_event_id, $phonecall_behavior_id==1);
			}
			$out=EndLayerScript($practitioner_id);
		}
		else if($mode=="save")
		{
			$missing="";
			if($practitioner_id==""  )
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
			$strHidden=" birthday description guardian_client_id city name_of_guardian subdomain zip office_name password address state_code client_type_id login_id client_id";
			$labels["client_id"]="";
			if(strtolower(sitename)=="vetboxx.com")
			{
				//$labels["firstname"]="name";
				$labels["client_type_id"]="type";
				$labels["description"]="breed";
				$labels["client_description"]="type";
				$labels["weight"]="weight (pounds)";
				$strHidden.=" birthday";
				$strSQL="SELECT  firstname, lastname,  client_description, description, u.client_id FROM " . $strDatabase. ".client u  JOIN  " . $strDatabase. ".client_office_map p ON u.client_id=p.client_id LEFT JOIN  " . $strDatabase. ".client_type t ON u.client_type_id=t.client_type_id  WHERE office_id='" .$intOurOfficeID . "' AND " . $search_type . " LIKE '%" . $searchterm . "%' ORDER BY lastname ";
			}
			else
			{
				$strHidden.=" weight";
				$strSQL="SELECT *  FROM " . $strDatabase. ".client u  JOIN  " . $strDatabase. ".client_office_map p ON u.client_id=p.client_id WHERE office_id='" .$intOurOfficeID . "' AND " . $search_type . " LIKE '%" . $searchterm . "%' ORDER BY lastname ";
			}
			//echo $strSQL;
			//GenericRSDisplay($strDatabase, $strPHP,$strLabel, $strSQL, $truncate, $intWidth, $strLinkFieldName="", $strLinkIDName="", $strAdditionalLink="", $strSuppressFields="", $bwlSuppressHeader=false, $bwlPrettyUpFieldNames=true, $intFieldLimit=10, $idencryptionstring="", $arrPostProcessing="")
			 
			$results=GenericRSDisplay($strDatabase, "",$strLabel, $strSQL, $truncate, $intWidth,  "client_id",  "client_id",  " <a target='new' href=\"view.php?client_id=<replace/>\">edit</a> |  <a href=\"javascript:selectuser('<replace/>','<firstname> <lastname>', '<phonecall_behavior_id>','<email_behavior_id>','<reminder_content_id>')\">select</a>",  $strHidden,  false, true,  16, "", "", $labels);
			if($results=="")
			{
				$results="<div class='noresults'>No " .$strCustomerNounPlural . " were found.</div>";
			}
			$results=IfAThenB($results, "<div class='message'>" . $strCustomerNoun . " Search Results:</div>") . $results;
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
			$strSQL="SELECT u.firstname, u.lastname, u.client_id, e.calendar_event_id, e.event_status_id FROM " . $strDatabase. ".personal_calendar_event e JOIN " . our_db . ".client u ON e.client_id=u.client_id JOIN " . $strDatabase. ".practitioner p ON e.practitioner_id=p.practitioner_id WHERE datecode='" .$datecode . "' AND time='" .$time . "' AND p.practitioner_id='" . $practitioner_id . "'";
	
			//echo $strSQL;
			$records = $sql->query($strSQL);
			
			//echo count($records);
			if(count($records)>1)
			{
				////$out.=" <br><br> <a onclick='return(confirm(\"Are you sure you want to unschedule this appointment?\"))' class='nav' href='caleditcell.php?calendar_event_id=" . $calendar_event_id . "&mode=unschedule'>Unschedule appointment</a>";
				$bwlDontShowSpecificPatient=true;
				$out.=GenericRSDisplayFromRS($strPHP,$strLabel, $records, $truncate, $intWidth,  "calendar_event_id",  "calendar_event_id",  " <a  href=\"caleditcell.php?practitioner_id=" .$practitioner_id . "&mode=specificevent&calendar_event_id=<replace/>\">edit</a> | <a onclick='return(confirm(\"Are you sure you want to unschedule this appointment?\"))'  href='caleditcell.php?calendar_event_id=<replace/>&mode=unschedule'>unschedule</a>" ,  "weight birthday guardian_client_id city name_of_guardian subdomain zip office_name password address state_code",  false, true,  22, "", "");
		 
				
				
	
				
	
			}
			else
			{
			
				//SQL TO POPULATE A FORM FOR A SPECIFIC EVENT
				$strSQL="SELECT e.*, u.*, p.* FROM " . $strDatabase. ".personal_calendar_event e JOIN " . our_db . ".client u ON e.client_id=u.client_id LEFT JOIN " . $strDatabase. ".practitioner p ON e.practitioner_id=p.practitioner_id WHERE calendar_event_id='" .$calendar_event_id . "'";
 
				//echo $strSQL . "<P>";
				//echo mysql_error();
				//$record=$records[0];
				$records = $sql->query($strSQL);
				
				
				//set timejs to be the time discovered here, not whatever was handed in
				$eventdefaults=$records[0];
				//var_dump($eventdefaults);
				$timejs=date("l M d Y H:i:s ", makedate($eventdefaults["datecode"], $eventdefaults["time"])). "GMT" ;
				//echo  "*" . $eventdefaults["datecode"] . "*" . $eventdefaults["time"] .  "*" . $timejs;
				
			
			}
		
		
		}
		else if($calendar_event_id!=""  && $mode=="specificevent")//THIS WILL FIRE ONLY IF $mode contains the string "specificevent"
		{

			//from the assumption that there is only one patient scheduled per doctor per timeslot
			
		
			//echo "$$";
			$strSQL="SELECT * FROM " . $strDatabase. ".personal_calendar_event e JOIN " . our_db . ".client u ON e.client_id=u.client_id JOIN " . $strDatabase. ".practitioner p ON e.practitioner_id=p.practitioner_id WHERE calendar_event_id='" .$calendar_event_id . "'";
			$records = $sql->query($strSQL);
			 
			//echo mysql_error();
			$eventdefaults=$records[0];
			
			
		}
		else if($searchterm=="") //no existing calendar event, so we need a user browser
		{
		
			$strSQL="SELECT *  FROM client u  JOIN  " . our_db . ".client_office_map p ON u.client_id=p.client_id WHERE office_id='" .$intOurOfficeID . "' ORDER BY lastname";
			//echo $strSQL;
			//function GenericForm($arrFieldNames,  $arrLabels, $arrDefaults, $arrFieldConfigs, $strPHP, $strButtonLabel="Save", $width=630, $arrSizes="", $formextratags="")
			 
		}
		//echo $eventdefaults["notes"];
		//echo"#";
		$mode=gracefuldecay($mode, "save");
		if(is_array($eventdefaults))
		{
			$arrHidden=array_merge( $eventdefaults, $arrHidden);
			$arrHidden["patient_name"]=$eventdefaults["firstname"] . " " . $eventdefaults["lastname"] ;
			var_dump($eventdefaults);
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
		$arrHidden["event_status_id"]=$eventdefaults["event_status_id"];
		$arrHidden["mode"]=$mode;	$formextratags="onSubmit=\";document.AForm.practitioner_id.value=document.CForm.practitioner_id[document.CForm.practitioner_id.selectedIndex].value;rootpractbiz();if(document.AForm.client_id.value==''){alert('You need to select a patient.'); return false;}return true\"";
		if(!$bwlDontShowSpecificPatient && ($searchterm!=""  || $calendar_event_id!="")) //no existing calendar event, so we need a user browser
		{
		
 


			$arrButtons=Array("*onClick=JSEndLayerScript()"=>"Don't Save","*onClick=return NotNeedPractitioner()\n"=>"Schedule" );
			if($calendar_event_id!="")
			{
				$arrButtons["unschedule"]="Unschedule";
			}
			$arrHidden["client_id"]=gracefuldecay($arrHidden["client_id"], $client_id);
			
			$additionalinfo="";
			if($arrHidden["client_id"]>0)
			{
				$rsClient=GenericDBLookup(our_db, "client", "client_id", $arrHidden["client_id"]);
				$rsType=GenericDBLookup(our_db, "client_type", "client_type_id", $rsClient["client_type_id"]);
				if($arrHidden["guardian_client_id"]>0)
				{
					$rsGuardian=GenericDBLookup(our_db, "client", "client_id", $arrHidden["guardian_client_id"]);
	
					$additionalinfo=guardiantype . ": " . "<a target=\"_new\" href=\"view.php?client_id=" . $arrHidden["guardian_client_id"] . "\">" . $rsGuardian["firstname"] . " " . $rsGuardian["lastname"] . "</a>";
					if($rsType["client_description"]!="")
					{
						$additionalinfo.= " Type: " . 	$rsType["client_description"];
					}
					$additionalinfo.= "<br>";
				}
				if(is_array($rsGuardian))
				{
					$additionalinfo.= "Phone: " . gracefuldecay($rsGuardian["cellphone"], $rsGuardian["phone"]);
					$additionalinfo.= " Email: <a href=mailto:" .  $rsGuardian["email"] . ">" .  $rsGuardian["email"] . "</a>" ;
				}
				else
				{
					$additionalinfo.= "Phone: " . gracefuldecay($rsClient["cellphone"], $rsClient["phone"]);
					$additionalinfo.= " Email: <a href=mailto:" .  $rsClient["email"] . ">" .  $rsClient["email"] . "</a>" ;
				}
				$additionalinfo.="<br>(<a target=_new href=view.php?x_table=client&client_id=" . $arrHidden["client_id"] . ">edit</a>)";
			}
			$arrFieldNames=Array("patient_name", "appointment_duration", "extra", "notes",
 "phonecall_behavior|phonecall_behavior_id|name|phonecall_behavior_id|","email_behavior|email_behavior_id|behavior_name|email_behavior_id|" , "event_status|event_status_id|status_name|event_status_id|");

		
 			$arrLabel=Array($strCustomerNoun ." Name",   "Appointment Duration", "Info", "Notes", "Phone or Text Reminder", "Email Functionality",  "Appointment Status");
			if(count($rsReminderContents)>0)
			{	
				$arrFieldNames[]="reminder_content|reminder_content_id|description|reminder_content_id|office_id=" . $intOurOfficeID . "|Appointment";
				$arrLabel[]="Event Type";
			}
			
			//get client record to set these defaults
			if(intval($thisid)<1)
			{
				$arrHidden["phonecall_behavior_id"]=$ourofficerecord["phonecall_behavior_id"];
				$arrHidden["email_behavior_id"]=$ourofficerecord["email_behavior_id"];
				$arrHidden["event_type_id"]=$ourofficerecord["event_type_id"];
				$arrHidden["reminder_content_id"]=$ourofficerecord["reminder_content_id"];
			
			}
			$arrHidden["mode"]="save";
 			$out.=  "<div id='idclientformcontainer' style='display:none'>" . GenericForm($arrFieldNames, $arrLabel, $arrHidden, Array("patient_name"=>"classinput:formdeny ", "extra"=>"noformitem info:'" . singlequoteescape($additionalinfo) . "'", "appointment_duration"=>"dropdown:5|5&nbsp;minutes-10|10&nbsp;minutes-15|15&nbsp;minutes-20|20&nbsp;minutes-30|30&nbsp;minutes-45|45&nbsp;minutes-60|one&nbsp;hour-90|90&nbsp;minutes-120|2&nbsp;hours-180|3&nbsp;hours-240|4&nbsp;hours-300|5&nbsp;hours-360|6&nbsp;hours", "notes"=>"size:2090"), $strPHP,  "", "100%",  "", $formextratags, "AForm", false, $arrButtons) . "</div>";
		}
		$out.="<br><div class='nav'>";
		if($calendar_event_id!="")
		{
			$out.="<a class='nav' href='caleditcell.php?mode=another&time=" . urlencode($timejs) . "&practitioner_id=" .$practitioner_id . "'>Schedule Additional " . $strCustomerNoun . " for this Time Slot</a>";
		}
		if(!($searchterm==""  && $calendar_event_id==""))
		{
			
			$out.=" <br><br> <a class='nav' href='caleditcell.php?time=" . urlencode($timejs) . "&practitioner_id=" .$practitioner_id . "'>Search for another " . $strCustomerNoun . "</a> ";
		}
		//echo $timejs
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
<script>
var divsearchresults=document.getElementById("idsearchresults");
if(!divsearchresults)
{
	var clientformdiv=document.getElementById("idclientformcontainer");
	if(clientformdiv)
	{
		clientformdiv.style.display='';
	}
}

</script>
</html>
	
	
	
	
