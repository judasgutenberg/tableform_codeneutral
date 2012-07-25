<?php
//Gus Mueller January 2006
//provides a web front end admin tool for any mysql db
//i've modified txtsql to be aware of foreign keys so this tool can dynamically build complicated tools
//This code is covered under the GNU General Public License
//info here: http://www.gnu.org/copyleft/gpl.html
//the digest is as follows: you cannot modify this code without
//publishing your source code under the same license
//contact the developer at gus@asecular.com  http://asecular.com

include('header.php');

echo main($intOurOfficeID);

function main($intOurOfficeID)
{
 	GLOBAL $intOurOfficeID ;
	$strTable="practitioner";
	$strFieldFormName="data";
	$strDatabase=our_db;
	$practitioner_id=$_REQUEST["practitioner_id"];
 	
	$strSQL="SELECT * FROM " . $strDatabase . ".personal_calendar_event e JOIN " . $strDatabase  . ".client u ON e.client_id=u.client_id WHERE office_id='" . $intOurOfficeID . "'";
	if($practitioner_id!="")
	{
		$strSQL.=" AND practitioner_id='" . $practitioner_id . "'";
	}
	$strAlerter="";
	$strAlerter=$strSQL;
	$sql=conDB();

	
	$records = $sql->query($strSQL);
	$config="";
	$strAccumulatedSQL="";
	foreach($records as $record)
	{
		$client_id=$record["client_id"];
		$datecode=$record["datecode"];
		$calendar_event_id=$record["calendar_event_id"];
		$year="20" . substr($datecode, 0, 2); //hmm not very Y2100-compliant!
		//$year=substr($datecode,0,2);
		$month=substr($datecode,2,2);
		$day=substr($datecode,4,2);
		$lastname=$record["lastname"];
		$practitioner_id=$record["practitioner_id"];
		$time=$record["time"];
		$arrTime=explode(":", $time);
		$hour=$arrTime[0];
		$minute=gracefuldecaynumeric($arrTime[1],0);
		$duration=$record["duration"];
		$event_status_id =$record["event_status_id"];
		//sample data schema:2009,12,30,13,30,Caulfield,60,1232|2009,12,30,14,30,Henderson,60,1211
		$strPractPiece="";
		if( $practitioner_id!="")
		{
			$strPractPiece=" AND practitioner_id='" . $practitioner_id . "'";
		}
		$strExtraSQL="SELECT * FROM " . $strDatabase . ".personal_calendar_event e JOIN " . $strDatabase  . ".client u ON e.client_id=u.client_id WHERE office_id='" . $intOurOfficeID . "'  AND  time='" . $time. "' AND datecode='" . $datecode . "' " . $strPractPiece . " ORDER BY duration DESC";
		$strAlerter.=	$strExtraSQL . "\n";
		$strAccumulatedSQL.=	$strExtraSQL . " ";
		$erecords = $sql->query($strExtraSQL);
		logmysqlerror($strExtraSQL, false, "", our_db);
		foreach($erecords as $erecord)
		{
			$lastname.="*" . str_replace("*", "",$erecord["lastname"]);
		}
		$lastname= str_replace(",", " ", $lastname);
		$config.="|" . $year . "," . $month . "," . $day . "," .  $hour . "," . $minute . "," . str_replace(",", " ", $lastname). "," . $duration . "," . $calendar_event_id . "," . $event_status_id;
	
	}
	$config=RemoveEndCharactersIfMatch($config, "|");
	$out.="<html><body>";
	$out.="<form name=\"BForm\" method=\"post\">\n";
 
 
	//$out.="<input type=\"hidden\" name=\"fields\" value=\"" . $fields . "\">\n";
	//$out.="</form>";
	//ookay, once we've loaded the fields into that hidden field, time to build a dropdown in the launcher window
	$out.="<script src=\"tableform_js.js\"><!-- --></script>\n";
	$out.="<script src=\"calendar.js\"><!-- --></script>\n";

	$out.="<script>\n";
 	//$out.="alert('" . $practitioner_id . " " .  $intOurLoginID . "');\n";
	//$out.="alert('" . str_replace("'", "`", $strSQL) .  "         " . 	 str_replace("'", "`", $strAccumulatedSQL) . "');\n";
 
  	$out.="var config='" . $config. "';\n";
 	//$out.="alert('" . $config . " " .  $intOurLoginID . "');\n";
	//$out.="alert(\"" . $strAlerter . " " .  $intOurLoginID . "\");\n";
	$out.="parent.document.BForm['" . $strFieldFormName ."'].value=config;\n";
 	$out.="placeWeekCalendar('');\n";
	$out.="</script>\n";
	$out.="</body></html>\n";

	return $out;
}

?>