<?


 
include("core_functions.php");
 
include("calendar_functions.php");
include("questionnaire_functions.php");
 ?>
<html>
<head>
<title><?=sitename?></title>
<link rel="stylesheet" href="styles.css" type="text/css">
</head>
<body>
<?

$strPHP=  $_SERVER['PHP_SELF'];
$sid =$_COOKIE[$cookiename . "_sid"];
$intOurLoginID=GetFrontEndLoginID();
$mode=$_REQUEST[qpre . "mode"];
$datecode=$_REQUEST["datecode"];
$strFTables="practitioner";
//echo $datecode;
$date=makedate($datecode);
$strDatabase=our_db;
$searchterm=$_REQUEST[qpre . "searchterm"];
$searchtype=$_REQUEST[qpre . "searchtype"];
$mode=$_REQUEST[qpre . "mode"];
SaveEventList($strDatabase, $intOurLoginID, $datecode, $strFTables);



$strNavConfig="dayframe.php?datecode=" . $datecode . "|Day-dayframe.php?datecode=" . $datecode . "&" . qpre . "mode=month|Month";

 

if ($mode=="save")
{
	//echo "<html><body>";
	//echo "<script>if(opener.calendardataframe){opener.calendardataframe.location.href='calendardata.php?datecode=" . $datecode . "&rnd=" . time() . "'}</script>";
	//echo "<script>window.close()</script>";
	
	
	//echo "</body>";
	//die();
}
 
//$leftnavcontent="calendar stuff"; //GetQuestionnaireList($strPHP,1, $intThisQuestionnaireID);

//echo $intOurLoginID;

$out.= "<table class=\"calendarday\" cellpadding=\"1\" cellspacing=\"1\" border=\"0\" width=\"100%\">";
$out.= "<th>";
if($searchterm!="")
{
	$out.= "Search Results";
}
else
{
	if($mode=="month")
		{
			$out.="&nbsp;";//  date(" F Y", $date) ;
		}
		else
		{
			$out.=  date("l, F jS Y", $date) ;
	
		}

}

$out.= "</th>";
$out.= "<tr>";
$out.= "<td>";
$out.= "</td>";
$out.= "</tr>";
$out.= "</table>";
echo "\n<script src=\"tableform_js.js\"><!-- --></script>\n";
echo "\n<script src=\"calendar.js\"><!-- --></script>\n";

echo $out;
 
 
if ($intOurLoginID<0 || $intOurLoginID=="" ) //we arent registered
{
	 if($mode=="month" || 1==1)
	{
		 echo BigCalendar($datecode,  $intOurLoginID, $strPHP);
	}
	else
	{
	 	echo "<div style=\"margin:10px\" class=\"text_12bl\">";
		echo "You either need to create an account or log-in to save calendar events.";
		echo "</div>";
	}

 
}
	else //we are registered
{

	if($searchterm!="")
	{
	 // MultipleEventListReadonly($strDatabase, $datecode, $intUserID, $strNoUserMessage="", $strSearchTerm="", $strSearchType="", $bwlSuppressSearch=false,  $strFTables="", $layoutwidth="100%", $bwlNoForm=true)

	 
			echo MultipleEventListReadonly($strDatabase, $datecode, $intOurLoginID, "", $searchterm, $searchtype, false, $strFTables, "100%", true);
		 
	}
	else
	{
		//$arrFields=Array("calendar_event_id"=>'',time=>"", "full name"=>"user|is_office=false", "office_name"=>"user|is_office=true", "practitioner_name"=>"practitioner");
		$arrFields=Array(time=>"", "client_login_id"=>"user|is_office=false",   "practitioner_id"=>"practitioner");
 		if($mode=="month")
		{
		
		

			echo BigCalendar($datecode,  $intOurLoginID, $strPHP);
 
			
		}
		else
		{
			echo MultipleEventList($strDatabase, $datecode, $intOurLoginID, "", $searchterm, $searchtype, $strFTables, $arrFields);
			
 
		}
	}
 
}

 
	?> 
 
</body>
	
</html>
 <?
 
 
 function BigCalendar($datecode,  $intOurLoginID, $strPHP)
 {
	$out="";
	$calendardata=CalendarData($datecode,  $intOurLoginID, $strPHP);
 
	$out.="<form name=\"BForm\">";
	$out.="<input name=\"thisdate\" type=\"hidden\">";
	$out.="<input name=\"calendardata\" type=\"hidden\" value=\"" . $calendardata . "\">";
	$out.="</form>";




	$out.="<div id=\"idcalendarplace\"></div>";

	$out.="<script>";
	$year="20" . substr($datecode,0,2);
	$month=substr($datecode,2,2)-1;
	$day=substr($datecode,4,2);
 	

	$out.="thisdate=new Date();thisdate.setFullYear('" . $year . "','" . $month . "','" . $day . "'); \n";
	$out.="\n appendCalendar(thisdate, window, 'normal'); \n";
	$out.="</script>";
	return $out;
			
}
 ?>