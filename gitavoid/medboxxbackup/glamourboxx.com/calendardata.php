<?


 
include("core_functions.php");
 
include("calendar_functions.php");
include("questionnaire_functions.php");
 ?>
<html>
<head>
<title>MyMedicalLife</title>
<link rel="stylesheet" href="styles.css" type="text/css">
</head>
<body name="body">
<?

$strPHP=  $_SERVER['PHP_SELF'];
$sid =$_COOKIE[$cookiename . "_sid"];
$intOurLoginID=GetFrontEndLoginID();
$datecode=$_REQUEST["datecode"];
//echo $datecode;
$date=makedate($datecode);
$mode=$_REQUEST[qpre . "mode"];
$year="20" . substr($datecode,0,2);
$month=substr($datecode,2,2)-1;
$day=substr($datecode,4,2);
$strDatabase=our_db;

 

 
 ?>
 <script>
 //alert('dddd<?=$intOurLoginID?>');
 //alert('<?=$mode?>');
 </script>
 
 <?
 
if (($intOurLoginID<0 || $intOurLoginID=="" )&& 1==2 ) //we arent registered - but we allow you in if you're not
{
 
}
	else //we are registered
{
	if($datecode!="")
	{
		//echo RenderCalendar($datecode,  $intOurLoginID, $strPHP);
		echo "\n<script src=\"tableform_js.js\"><!-- --></script>\n";
		echo "\n<script src=\"calendar.js\"><!-- --></script>\n";
		
	 	echo "<script>\n";
		echo "\nvar thisdate=new Date();\n";
		if($mode=="office")
		{
			echo "calendardata='" . CalendarData($datecode,  $intOurLoginID, "", $strPHP, $mode)."';\n";
		}
		else
		{
			echo "calendardata='" . CalendarData($datecode,  "",$intOurLoginID, $strPHP, $mode)."';\n";
		}
		//echo "alert(top.document.BForm.calendardata.value);";
		//echo "alert(calendardata);";
		//echo "alert(top.document.BForm);";
		echo "\nif(top.document.BForm)\n{top.document.BForm.calendardata.value=calendardata;}\n";
		//echo "alert(top.document.BForm.calendardata.value);";
		//echo "alert(top.document.BForm.calendardata.value);";
		//echo "\n alert('" . $datecode . "-" .  $year . " . " . $month . " . " . $day . "');";
		echo "if(top.document.BForm.thisdate.value){var thisdate=top.document.BForm.thisdate.value;}else{var thisdate=new Date();thisdate.setFullYear('" . $year . "','" . $month . "','" . $day . "');} \n";
		//echo "\n alert(thisdate);";
		echo "\n divforcal=top.document.getElementById('idcalendarplace');";
		//echo "\n alert(top.document.BForm.calendardata.value);";
		echo "\n appendCalendar(thisdate, top.ourcalendarplace);\n";
		echo "</script>\n";
	}
	
}


	?> 
 
</body>
	
</html>
 