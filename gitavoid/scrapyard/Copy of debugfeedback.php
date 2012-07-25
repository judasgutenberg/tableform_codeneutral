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
		$mode=$_REQUEST[qpre . "mode"];
		//for some reason single quotes are escaped when coming in off the $_REQUEST collection
		$actsql=deescape($_REQUEST[qpre . "actsql"]);
		$truncate=deescape($_REQUEST[qpre . "truncate"]);
		$strTable=$_REQUEST[qpre . "table"];
		$strDatabase=deMoronizeDB(gracefuldecay($_REQUEST[qpre . "db"],our_db));
		$strPHP=$_REQUEST['PHP'];
		$feedbackspanstag="<span class=\"feedback\">";
		$out="";
		//echo $id . " " .$idfield ;
 
 
		if ($ouruserid!=""  && $ouruserid!=0)
		{
		
 
 
	 

			$out.= DebugFeedback($strDatabase,  $strPHP,   $ouruserid);
		}
 
		else
 
		{
		
			$out.=  "You do not have permissions to see this content.";
		}
		$out =  PageHeader($strDatabase . " : Feedback Responses", $strExtrajs) . $out . PageFooter();
		
		return $out;
	}


	
	
	
	
function DebugFeedback($strDatabase,  $strPHP,  $ouruserid)
//shows all the tables in $strDatabase and allows an admin to drop and clear all data
{
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strOtherBgClass="bgclassother";
	$strLineClass="bgclassline";
	$strThisBgClass=$strClassFirst;
	//$strPHP=  $_SERVER['PHP_SELF'];
	$sql=conDB();
	//$tables = $sql->showtables(array("db" => $strDatabase)); 
	$strSQL="SELECT * FROM  " .  $strDatabase . ".debug_feedback WHERE user_id=" . $ouruserid . " AND url='" . $strPHP . "'"; 
	//echo $strSQL;
	$rs = $sql->query($strSQL);
	$out= "<table border=\"0\" cellspacing=\"1\" cellpadding=\"2\" class=\"" .$strLineClass  . "\" width=\"100%\">\n";
	$out.= "<tr class=\"" . $strOtherBgClass . "\"><td colspan=\"3\">\n";
	$out.= adminbreadcrumb(false,  $strDatabase,"tf.php",  "Feedback Responses: " . $strPHP, "") ;
 
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
 
 
		$out.= "<td>" .  $date_time . "</td>\n";
		$out.= "<td>";
 		$out.= "<textarea name=\"c" . $intOut . "\" rows=\"6\" cols=\"40\" >";
		$out.= $content;
		$out.="</textarea>";
		$out.= "</td>\n";
		$out.= "<td>";
		$out.= $response;
		$out.= "</td>\n";
 
 
		$out.= "</tr>\n";
		$intOut++;
	}
	 $out.="</table>"; 
	return $out;
}



?>

