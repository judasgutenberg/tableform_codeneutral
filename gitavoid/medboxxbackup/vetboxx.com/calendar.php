<?


 
include("header.php");
include("calendar_functions.php");
 
 
 


$strPHP=  $_SERVER['PHP_SELF'];
$sid =$_COOKIE[$cookiename . "_sid"];
$intOurLoginID=GetFrontEndLoginID();
$datecode=$_REQUEST["datecode"];
 
if (!($intOurLoginID<0 || $intOurLoginID==""))
{
	$extracontent=loginpiece( $strPHP, true);
}
$leftnavcontent=""; //GetQuestionnaireList($strPHP,1, $intThisQuestionnaireID);

 
 
echo "<table border=\"0\"  cellspacing=\"0\" width=\"100%\">";

 
echo "<tr><td valign=\"top\">";
//echo "<tr><td valign=\"top\">";

if (($intOurLoginID<0 || $intOurLoginID=="")    ) //we arent registered
{

 	echo "<div class=\"text_14b2\">Your Calendar</div><p/>";
	//echo "<div style=\"margin:10px\" class=\"text_11g\"><p>" .  DisplayContent("unregistered profile blurb") . "</div><p/>";
	$datecode=todaydatecode();
 	$daydisplayframewidth="600";
	
 
	
 
}
else //we are registered
{
 	
	$datecode=gracefuldecay($datecode,todaydatecode());
	$daydisplayframewidth=800;

}
echo "\n<script src=\"tableform_js.js\"><!-- --></script>\n";
echo "\n<script src=\"calendar.js\"><!-- --></script>\n";
echo "<form name='Bform2'><div id=\"idcalendarplace\"></div></form>";
 
echo "\n<script>var thisdate=new Date(); </script>\n";
 
echo  "<form name=\"BForm\">";
echo HiddenInputs(array("calendardata"=>"", "thisdate"=>""),"");
echo  "</form>";

echo "</td>";
 ?>
 <td valign="top">
 <div name="daybody" id="iddaybody">
 
 <?
// echo $mode;
 echo   CalendarDataFrame($datecode, $mode);
  //echo SpecificCalendarDayIframe($datecode, $daydisplayframewidth);
 
 ?>
 </div>
 </td>
 
 
	
	
	
 