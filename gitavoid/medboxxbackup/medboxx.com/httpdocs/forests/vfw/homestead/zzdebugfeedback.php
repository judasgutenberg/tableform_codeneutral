<? 
//gus mueller, nov 26 2006
//tools for a tableform mysql db

 
 
define('IN_PHPBB', true);
$title="MyMedicalLife : Debugfeedback";
 
 include("header.php");



//FRONT-END CODE
$page_id=$_REQUEST["page_id"];
$sql=conDB();
 //echo phpinfo();
$ouruserid=GetFrontEndUserID();
//echo $ouruserid . "_______" ;
$membername=GenericDBLookup(our_db,"bb_user", "user_id", $ouruserid, "username");
$cookiename=GenericDBLookup(our_db,"bb_config", "config_name", "cookie_name", "config_value");
$strPHP=$_SERVER['PHP_SELF'];
$intStartRecord=$_REQUEST["r"];
$recsperpage=14;








echo main($ouruserid);

function main($ouruserid)
{
	if(!IsExtraSecure())
	{
		die(ExtraSecureFailure());
	}
	$mode=$_REQUEST[qpre . "mode"];
	//for some reason single quotes are escaped when coming in off the $_REQUEST collection
	$actsql=deescape($_REQUEST[qpre . "actsql"]);
	$truncate=deescape($_REQUEST[qpre . "truncate"]);
	$strTable=$_REQUEST[qpre . "table"];
	$strDatabase=deMoronizeDB(gracefuldecay($_REQUEST[qpre . "db"],our_db));
	$strPHP=$_REQUEST[qpre . 'PHP'];
	$feedbackspanstag="<span class=\"feedback\">";
	$out="";
	//echo $id . " " .$idfield ;


	if ($ouruserid!=""  && $ouruserid!=0)
	{
	


 

		$out.= DebugFeedbackResults($strDatabase,  $strPHP,   $ouruserid);
	}

	else

	{
	
		$out.=  "You do not have permissions to see this content.";
	}
	$out =  PageHeader($strDatabase . " : Feedback Responses", $strConfigBehave) . $out . PageFooter();
	
	return $out;
}


	
	
	
	
function DebugFeedbackResults($strDatabase,  $strPHP,  $ouruserid)
//shows all the tables in $strDatabase and allows an admin to drop and clear all data
{
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strOtherBgClass="bgclassother";
	$strLineClass="bgclassline";
	$strThisBgClass=$strClassFirst;
	$intTop=$_REQUEST[qpre . "top"];
	$sql=conDB();
	//save changes made to form
	//echo $intTop;
	for($i=0; $i<$intTop+1; $i++)
	{
		$c=$_REQUEST["c" . $i];
		//echo $c . "<br>";
		$r=$_REQUEST["r" . $i];
		$v=$_REQUEST["v" . $i];
		if ($r!="" || $c!="")
		{
			$strSQL="UPDATE   " .  $strDatabase . ".debug_feedback SET content='" . $c . "', response='" . $r . "' WHERE  debug_feedback_id=" . $v ; 
			$rs = $sql->query($strSQL);
			echo sql_error();
		
		}
	
	
	}
	//$strPHP=  $_SERVER['PHP_SELF'];
	
	//$tables = $sql->showtables(array("db" => $strDatabase)); 
	if(IsSuperUser($strDatabase, $ouruserid))
	{
		$strSQL="SELECT * FROM  " .  $strDatabase . ".debug_feedback WHERE  url='" . $strPHP . "' ORDER BY date_time ASC"; 
	}
	else
	{
		$strSQL="SELECT * FROM  " .  $strDatabase . ".debug_feedback WHERE user_id=" . $ouruserid . " AND url='" . $strPHP . "' ORDER BY date_time ASC"; 
	}
	//echo $strSQL;
	$rs = $sql->query($strSQL);
	$out= "<table border=\"0\" cellspacing=\"1\" cellpadding=\"2\" class=\"" .$strLineClass  . "\" width=\"100%\">\n";
	$out.= "<form method=\"post\" name=\"BForm\" action=\"debugfeedback.php\">\n";
	$out.= "<tr class=\"" . $strOtherBgClass . "\"><td colspan=\"3\">\n";
	$out.= adminbreadcrumb(false,  $strDatabase,"tableform.php",  "Feedback Responses: " . $strPHP, "") ;
 
	$out.= "</td></tr>\n";
	$out.= "<tr class=\"" . $strOtherBgClass . "\"><td colspan=\"3\">\n";

	$out.= "<a href=\"" . $strPHP . "\">back to original page</a>";
	$out.= "</td></tr>\n";
	$out.=htmlrow("bgclassline", "date", "issue", "response");
	$intOut=0;
	foreach ( $rs as  $r )
	{
		$content=$r["content"];
		$response=$r["response"];
		$date_time=$r["date_time"];
		$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
		$out.= "<tr  class=\"" . $strThisBgClass . "\">\n";
 
 
		$out.= "<td valign=\"top\">" .  FormatMySQLTimestamp( $date_time). "</td>\n";
		$out.= "<td>";
 		$out.= "<textarea name=\"c" . $intOut . "\" rows=\"6\" cols=\"40\" >";
		$out.= $content;
		$out.="</textarea>";
		$out.= "</td>\n";
		$out.= "<td>";
		$out.= "<textarea name=\"r" . $intOut . "\" rows=\"6\" cols=\"40\" >";
		$out.= $response;
		$out.="</textarea>";
		$out.= "</td>\n";
 
 		$out.=GenericInput("v" . $intOut, $r["debug_feedback_id"], false, "",  "", "", "hidden");
		$out.= "</tr>\n";
		
		$intOut++;
	}
	$out.=HiddenInputs(Array("top"=>$intOut, "PHP"=>$strPHP));
	$out.="<tr><td  align=\"left\" colspan=\"3\">" . GenericInput(qpre . "submit", "Save Changes") . "</td></tr>\n";
	$out.= "</form>";
	$out.="</table>";
	 
	return $out;
}

function FormatMySQLTimestamp($dated) // for straight timestamp 14
{
	$hour = substr($dated,8,2);
	$minute = substr($dated,10,2);
	$second = substr($dated,12,2);
	$month = substr($dated,4,2);
	$day = substr($dated,6,2);
	$year = substr($dated,0,4);
	$mktime = mktime($hour, $minute, $second, $month, $day, $year);
	$formatted = date("F j, Y g:i a",$mktime);
	return $formatted;
}
 
?>

