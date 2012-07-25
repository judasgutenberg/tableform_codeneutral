<?php

define('IN_PHPBB', true);
$title="Medboxx : Home";
//include("header.php");
 //include("includes/bbcode.php");
  //include("includes/db.php");
include("calendar_functions.php"); 
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
 
DecryptStringToQS();
$response_message=$_REQUEST["m"];
$response_eventid=$_REQUEST["e"];
if(inList("yes no call", $response_message)  && intval($response_eventid)>0)
{
	//if we end up in here, we're at a valid response from a user

	//foreach($_REQUEST as $k=>$v)
	//{
		//echo $k . " " . $v . "<BR>";
		
	//}
	FrontendLogout();
	$day=Array();
	$phonecallday=Array();
	//$records=$sql->query($strSQL);
	$eventrecord=GenericDBLookup(our_db, "personal_calendar_event","calendar_event_id", $response_eventid, "");
	$e_datecode=$eventrecord["datecode"];
	$e_time=$eventrecord["time"];
	$e_duration=$eventrecord["duration"];
	$practitioner_id=$eventrecord["practitioner_id"];
	$e_notes=$eventrecord["notes"];
	$e_office_id=$eventrecord["office_id"];
	$e_client_id=$eventrecord["client_id"];
	$officerecord=GenericDBLookup(our_db, "office","office_id", $e_office_id, "");
	$office_name=$officerecord["office_name"];
	//OFFICE INFO!!!
	$office_phone=$officerecord["phone"];
	$day[0]   =$officerecord["first_email"];
	$day[1]  =$officerecord["second_email"];
	$day[2] =$officerecord["third_email"];
	$day[3]  =$officerecord["first_phonecall"];
	$day[4]   =$officerecord["second_phonecall"];
	$day[5] =$officerecord["third_phonecall"];
	$subdomain=gracefuldecay($officerecord["subdomain"], "www");

	$phonecall_time =gracefuldecaynotzero($officerecord["phonecall_time"], 10);
	//-----------------------------------
	$practitioner_record=GenericDBLookup(our_db, "practitioner","practitioner_id", $practitioner_id, "");
	$practitioner_name=$practitioner_record["name"];
	$office_timezone_id=$officerecord["timezone_id"];
	$office_timezone_delta=GenericDBLookup(our_db, "timezone","timezone_id", $office_timezone_id, "dif_from_GMT");
	//--------------------------------------------------------------
	$userrecord=GenericDBLookup(our_db, "client","client_id", $e_client_id, "");
	$user_fullname=$userrecord["firstname"] . ' ' . $userrecord["lastname"];
	
	$dtmAppointment =makedate($e_datecode, $e_time);
	//date("l F d, Y g:i A"
	//other: "Y-m-d H:i:s"
	$friendlydate=date("l F d, Y g:i A", $dtmAppointment);
	
	
	if($response_message=="yes")
	{
		$responsecode=2;
	}
	else if($response_message=="no")
	{
		$responsecode=3;
	}
	else if($response_message=="call")
	{
		$responsecode=4;
	}
	UpdateOrInsert(our_db, "personal_calendar_event", Array("calendar_event_id"=>$response_eventid), Array("event_status_id"=>$responsecode));
	header("location: http://" . $subdomain. "." . strtolower(sitename) . "/index.php?" . qpre . "message=" . urlencode("Thank you " . $user_fullname . " for responding to " . $office_name . " concerning your appointment scheduled for " . $friendlydate . "."));
}
else
{
	//MIGHT BE A HACKER ATTEMPT TO SCREW UP OUR SYSTEM -- TURN OFF THE IP ADDRESS OF THE MALFACTOR?

}

	foreach($_SERVER as $k=>$v)
	{
		echo $k . " " . $v . "<BR>";
		
	}
 echo "USER:" . $intOurLoginID  . " AT IP ADDRESS:" . $_SERVER["REMOTE_ADDR"] . " " .   "<BR>";
?>
 Was this a hacking attempt?
 
 
