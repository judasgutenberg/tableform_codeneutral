<?php

function killBetweenAlways($oldString, $begin="[", $end="]") 
{
	$newString = "";
	$inTag = false;
   	for($i = 0; $i < strlen($oldString); $i++) 
	{
        if(substr($oldString,$i,strlen($begin)) == $begin  || ($end==""  && $inTag ==true) ) 
		{
			$inTag = true;
		}
        if( substr($oldString,$i,strlen($end)) == $end  && $inTag ==true  && !($end==""  && $inTag ==true)) 
		{
			$inTag = false;
			$i++;
		}
	
        if(!$inTag)
		{ 
			$newString.= substr($oldString,$i,1);
		}
	}
 return $newString;
}

function parsemessage($message)
{
	//global $db, $template, $board_config, $theme, $lang, $phpEx, $phpbb_root_path, $nav_links, $gen_simple_header, $images;
	//global $starttime;
	//include($phpbb_root_path . 'language/lang_english/lang_main.'.$phpEx);
	//$template->set_filenames(array('message_body' => 'message_body.tpl'));
	//$template->pparse($handle);	
	//$message =  (1) ? bbencode_second_pass($message, $bbcode_uid) : preg_replace("/\:$bbcode_uid/si", '', $message);
	//$message = ereg_replace ("/([([^>]+)])/ig","", $message ); 
	$message = killBetweenAlways($message);
	$message = killBetweenAlways($message, "http", " ");
	$message = killBetweenAlways($message, "http", chr(10));
	$message = killBetweenAlways($message, "http", chr(13));
	$message=nl2br($message);
	return $message;
}

function GetFrontEndLoginID()
{
	$cookiename="ourcookie";
	$strCookie=subtractletters($_COOKIE[$cookiename], encryptionkey);
	if(contains($strCookie, " "))
	{
		$arrCookie=explode(" ", $strCookie); 
		$strCookie=$arrCookie[0];
	}
 	//echo  $strCookie;
	$id=GenericDBLookup(our_db, "login","email", $strCookie, "login_id");
	return $id;
}

function FrontendLogout()
{
	$cookiename="ourcookie";
	setcookie($cookiename,"");
}

function SetFrontEndCookie($login_id)
{
	//echo $login_id;
	$cookiename="ourcookie";
	$whatisstored=GenericDBLookup(our_db, "login","login_id", $login_id, "email");
	//die( $whatisstored);
	$strCookie=addletters($whatisstored, encryptionkey);
	setcookie($cookiename,$strCookie);
}

function ipintegercompress()
{
	
	$ip_address=$_SERVER["REMOTE_ADDR"];
	$ip_address=str_replace(".", "",	$ip_address);
	$ip_address=str_replace("1", "",	$ip_address);
	$ip_address=str_replace("2", "",	$ip_address);
	$ip_address= intval($ip_address);
	if ($ip_address>10000000)
	{
	$ip_address=intval($ip_address/10);
	}
	return $ip_address;
}
	
/////MEDBOX FUNCTIONS

function AssociateClientWithOffice($client_id, $officetoken, $office_id="", $office_login_id="")
{
	if($office_id=="")
	{
		if($office_login_id!="")
		{
			$officerecord=GenericDBLookup(our_db,"office", "login_id", $office_login_id, "");
			//$office_login_id=$officerecord["login_id"];
			$office_id=LoginIdToClientOrOfficeID($office_login_id, "office");
		}
		else
		{
			$officerecord=GenericDBLookup(our_db,"office", "subdomain", $officetoken, "");
			$office_login_id=$officerecord["login_id"];
			$office_id=LoginIdToClientOrOfficeID($office_login_id, "office");
		}
	}
	if(!ClientBelongsToOffice($client_id, $office_id))
	{
		//echo "FF";
		$strSQL="INSERT INTO client_office_map SET office_id='" . $office_id . "', client_id='" . $client_id . "'";
		//echo $strSQL;
		$sql=conDB();
		$records = $sql->query($strSQL);
	}
}

function GetOfficesForClient($client_id, $fields="office_id")
{
	$strSQL="SELECT o." . $fields . " FROM  client_office_map m JOIN office o on m.office_id=o.office_id WHERE m.client_id='" . $client_id . "'";
	$sql=conDB();
	$records = $sql->query($strSQL, true, our_db);
	return $records;
}

function IsClientInOffice($client_id, $office_id)
{
	$records= GetOfficesForClient($client_id, "office_id");
	foreach($records as $record)
	{
		if( $record["office_id"]==$office_id)
		{
			return true;
		}
	}
	return false;
}

function ClientBelongsToOffice($client_id, $office_id)
{
	$strSQL="SELECT * FROM " . our_db . ".client_office_map WHERE office_id='" . intval($office_id) . "' AND client_id='" . intval($client_id) . "'";
	$sql=conDB();
	$records=$sql->query($strSQL);
	if(count($records)<1)
	{
		return false;
	}
	return true;
}

//loginpiece("",   $intOurLoginID, $error, "large", $mode, "horizontal" )
function loginpiece($dest="",  $login_id="", $error="", $type="large",  $mode="client", $displaymode="horizontal", $intOfficeID="")
{
	if($dest=="")
	{
		$dest=  $_SERVER['PHP_SELF'];
	}
	$strTable="login";
	$strPK="login_id";
	$regtitle="Already Have a " . sitename . " " . strtolower(customertype) . " profile?";
	$entityname=strtolower(customertype);
	$strLoginDesc="E-mail";
	if( $mode=="office")
	{
		$regtitle="Is your " . locationtype . " already in " . sitename . "?";
		$entityname=locationtype;
		$strLoginDesc="Subdomain or E-mail";
	}
	$action=$_REQUEST[qpre . "action"];
 
	if($login_id!="" && $error==""  && $action!="logout")
	{
		$intOurLoginID=$login_id;
	}
	else if($action=="logout" )
	{
		$intOurLoginID="";
	}
	else
	{
		$intOurLoginID=GetFrontEndLoginID();
	}
	//echo $intOurLoginID . "_______" ;
	$record=GenericDBLookup(our_db,$mode, $strPK, $intOurLoginID);
	$membername=$record["username"];
 	//echo $mode. " " . $membername;
	$out="";
  //echo $intOurLoginID;
	
	if($type!="large")
	{
		$alwayslogin="";
		if( contains(strtolower(sitename), "medboxx"))
		{
			$alwayslogin="<div style=\"background-image:url('images/tab.png'); background-repeat:norepeat; color: white; text-align:center; height: 25px; width: 80px; float: right\"><a class=\"nav\" href=\"login.php?" . qpre . "action=&" . qpre . "mode=client" ."\">" .customertype. " Login</a></div>  ";
		}
		$alwayslogin.="<div style=\"background-image:url('images/tab.png'); background-repeat:norepeat; color: white; text-align:center; height: 25px; width: 80px; float: right\"><a class=\"nav\" href=\"login.php?" . qpre . "action=&" . qpre . "mode=office\">" .locationtype. " Login</a></div> ";
		//$alwayspatientlogin="<a class=\"nav\" href=\"login.php?" . qpre . "action=logout&" . qpre . "mode=patient\">" . strtolower(customertype) . "  login</a>  ";
		//echo $intOurLoginID;
		if($intOurLoginID=="")
		{
			$login=$alwayslogin; 
			//$patientlogin=$alwayspatientlogin;
		}
		else
		{ 
			if($mode=="office")
			{
				$displayname=$record["office_name"];
			}
			else
			{
				$displayname=$record["firstname"] . " " . $record["lastname"] ;
			}
				
			$login="<div style=\"background-image:url('images/tab.png'); background-repeat:norepeat; color: white; text-align:center; height: 25px; width: 80px; float: right\"><a class='nav'  href='reg.php?" . qpre . "profilemode=profile'>Edit " . locationtype . "</a></div>"; 
			//$patientlogin=$alwayspatientlogin;
		}

		//$out.=$patientlogin . "| ";
		if($intOurLoginID!="")
		{
			$out.="<div style=\"background-image:url('images/tab.png'); background-repeat:norepeat; color: white; text-align:center; height: 25px; width: 80px; float: right\"><a class=\"nav\" href=\"" .  $_SERVER['PHP_SELF']  . "?" . qpre . "action=logout\">Logout</a></div>  ";
		}
		$out.= $login;
		if($intOurLoginID!="")
		{
		$out.="<span class=\"nav\" style=\"color:white; position:relative; top:-22px; left:720px\">Welcome, ".$displayname."</span>&nbsp;&nbsp;&nbsp;";
		}
		//$out.="<div style=\"background-image:url('images/tab.png'); background-repeat:norepeat; color: white; text-align:center; height: 25px; width: 80px; float: right\"><a class=\"nav\" href=\"contact.php?" . qpre . "mode=contactus\">Contact Us</a></div>";
		if($mode=="office" && $intOurLoginID!="")
		{
		$out.=  sitenav($intOfficeID);
		}
	}
	else
	{
		if($intOurLoginID<1)
		{
		$out.= "	<form action=\"login.php?sid=" . $sid . "\" method=post>\n";
 		if($displaymode=="horizontal")
		{
			$out.= "	<center><table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"700\"><tr><td>\n";
		}
		$out.= "	<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"555\">\n";
		$out.= "	<tr>\n";
		//$out.= "		<td><a href=\"reg.php\"><img src=\"images/signup.gif\" width=\"215\" height=\"35\" border=\"0\" alt=\"\"></a></td>";
		$out.= "	</tr>\n";
		$out.= "	<tr>\n";
		$out.= "	<td class=\"bg_rightcol\">\n";
		$out.= "	<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"199\" align=\"center\">\n";
		$out.= "	<tr>";
		$out.= "		<td colspan=\"2\" class=\"text_11g\">&nbsp;				</td>\n";
		$out.= "	</tr>";
		$out.= "	<tr>";
		$out.= "		<td colspan=\"2\" class=\"bg_hdot\"><img src=\"images/spacer.gif\" width=\"1\" height=\"1\" alt=\"\"></td>\n";
		$out.= "	</tr>";
		$out.= "	<tr>";
		$out.= "		<td colspan=\"2\" class=\"text_11g\" style=\"padding-top:6px;\">\n";
		$out.= "		<b class=\"text_12bl\">" . $regtitle . "</b><br>";
		$out.= "		Enter your " . $entityname . " login information here and click the link below.				</td>\n";
		$out.= "	</tr>";
		$out.= "	<tr>";
		$out.= "<td class=\"text_10g\" style=\"padding:10px 10px 0px 10px;\">" . $strLoginDesc . ":</td>\n";
		$out.= "		<td style=\"padding:10px 0px 0px 0px;\"><input type=\"text\" name=\"username\" style=\"width:110px; font-size:9px;\"></td>\n		";		
		$out.= "	</tr>\n";
		$out.= "	<tr>\n";
		$out.= "		<td class=\"text_10g\" style=\"padding:4px 10px 10px 10px;\">Password:</td>\n";
		$out.= "		<td style=\"padding:4px 0px 10px 0px;\"><input type=\"password\" name=\"password\" style=\"width:110px; font-size:9px;\"></td>\n	";			
		$out.= "	</tr>\n";
		$out.= "	<tr>\n";
		$out.= "	<td colspan=\"2\" class=\"text_11g\">\n";
		$out.= "	<a href=\"profile.php?" . qpre . "mode=sendpassword\">Forget your " . $entityname . " password?</a>			</td>\n";
		$out.= "	<tr>";
		$out.= "	<td colspan=\"2\" align=\"left\" class=\"text_10g\" style=\"padding:4px 10px 10px 10px;\">\n ";
		$out.= "	  <input name=\"" . qpre . "dest\" value=\"" . $dest . "\" type=\"hidden\">\n";
		$out.= "	  <input name=\"login\" value=\"Log in\" type=\"Submit\"></td>\n			";	
		$out.= "	</tr>	";
		if($displaymode=="horizontal")
		{
			$out.= "	</table></td><td>&nbsp;</td><td valign=\"top\"><br/><br/><table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"215\">\n";
		}
		$out.= "<tr>";
		$out.= "	<td colspan=\"2\" class=\"text_11g\">";
		$regblurb=DisplayContent("login not yet added " . $mode);
		$regblurb=str_replace("[", "<a href=\"reg.php?" . qpre . "mode=" . $mode . "\">", $regblurb);\
		$regblurb=str_replace("]", "</a>", $regblurb);
		//echo $regblurb;
		$out.= $regblurb;
		$out.= "	</td>\n";
		$out.= "	</tr>	";
		$out.= "	<tr>";
		$out.= "		<td colspan=\"2\" class=\"bg_hdot\"><img src=\"images/spacer.gif\" width=\"1\" height=\"1\" alt=\"\"></td>\n";
		$out.= "	</tr>		";			
		$out.= "</table>			</td>\n";
		$out.= "</tr>";
		$out.= "<tr>";
		$out.= "	<td colspan=\"2\" class=\"text_11g\">\n";
		$out.= "	</td>\n";
		//$out.= "	<td align=\"center\" class=\"signup\"><img src=\"images/spacer.gif\" width=\"1\" height=\"1\" alt=\"\"></td>\n";
		$out.= "</tr>";
		$out.= "</table>	";
		$out.= "</form>";
	 		if($displaymode=="horizontal")
			{
				$out.= "	</td></tr></table></center>\n";
			}
		}
		else
		{
		$out.= "<div  align=\"right\" class=\"text_10g\">&nbsp;You are logged in as 	<a href=\"profile.php?mode=viewprofile&u=" . $intOurLoginID . "\">" . $displayname . "</a> ";
		$out.= "[<a href=\"login.php?redirect=" . $dest. "&" . qpre . "action=logout&sid=" . urlencode($sid) ."\">Logout</a>]</div>";
		}
		if (!$bwlsuppressads)
		{
 			//$out .= googleads($intOurLoginID);
		}
	}
 	return $out;
}

function googleads($intOurLoginID)
{
	$adwidth="120";
	$adheight="240";
	$strPHP=  $_SERVER['PHP_SELF'];
	if($intOurLoginID<1  &&  !contains($strPHP, "calendar"))
	{
		$adwidth="250";
		$adheight="250";
	}
	else 
	{ 
	} 
		
	$out.= "
	<script type=\"text/javascript\"><!--
	google_ad_client = \"pub-7943019996715830\";
	google_ad_width = " . $adwidth . ";
	google_ad_height = " . $adheight . ";
	google_color_border=\"6578DE\";
	google_color_bg=\"" . textcolorontheme . "\";
	google_ad_format = \"" . $adwidth . "x" . $adheight ."_as\";
	google_ad_channel = \"medical\";
	//-->
	</script>
	<script type=\"text/javascript\"
	  src=\"http://pagead2.googlesyndication.com/pagead/show_ads.js\">
	</script>
	";
	return $out;
}


function showlinks($page_id)
{
	$strSQL="SELECT * FROM " . our_db . ".link_placement p JOIN " . our_db . ".link l on p.link_id=l.link_id WHERE p.page_id=" . $page_id . "  ORDER BY sort_order ASC";
	$sql=conDB();
	$records = $sql->query($strSQL);
	$out="";
	foreach($records as $record)
	{
		$url=$record["url"];
		$description =$record["description"];
		$link_name=$record["link_name"];
		$out.="<p><a href=\"" . 	$url . "\"><b>" . $link_name . "</b></a> - " . $description . "</p>";
	}
	return $out;
}

function DisplayContent($name)
{
	$strSQL="SELECT * FROM " . our_db . ".content  WHERE name='" . $name ."'";
	$sql=conDB();
	$records = $sql->query($strSQL);
	$record=$records[0];
	$content= $record["content"];
	$imagefieldname="icon_filename";
	$icon_filename=$record[$imagefieldname];
	$out="";
	if($icon_filename!="")
	{
		$strPath=fieldNameToFolderPath($imagefieldname, imagepath) .$icon_filename;
		//echo $strPath . "+" . file_exists($strPath) . "<br>";
		$out.="<div class=\"contenticon\">" .  PictureIfThere($strPath, "","", " ", "") . "</div>";
	}
	if($content==strip_tags($content))
	{
		$out.=str_replace(chr(10), "<br>", $content);
	}
	else
	{
		$out.=$content;
	}
	return $out;
}


function ShowCalendarIcon()
{
	$out="";
	$date=time();
	$strMonth=strftime("%b",$date);
	$intYear=strftime("%Y",$date);
	$intDay=strftime("%d",$date);
	$out.="<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\">";
	$out.="<tr>";
	$out.="<td align=\"center\" width=\"66\" height=\"68\" class=\"calendariconday\" background=\"". imagepath . "/calendaricon.gif\">";
	$out.="<span class=\"calendariconmonth\">" . $strMonth . "</span><br>";
	$out.="<a href=\"calendar.php\">" . $intDay . "</a>";
	$out.="</td>";
	$out.="</tr>";
	$out.="</table>";
	return $out;

}

function ShowPostIcon()
{
	$out="";
	$out.="<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\">";
	$out.="<tr>";
	$out.="<td align=\"center\" width=\"66\" height=\"68\" class=\"calendariconday\" background=\"". imagepath . "/messageboardicon.gif\">";
 	$out.="<a href=\"bb_basis.php\"><img border=\"0\" width=\"66\" height=\"68\" src=\"". imagepath . "/spacer.gif\"></a>";
	$out.="</td>";
	$out.="</tr>";
	$out.="</table>";
	return $out;
}

function ShowBillIcon()
{
	$out="";
	$out.="<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\">";
	$out.="<tr>";
	$out.="<td align=\"center\" width=\"66\" height=\"68\" class=\"calendariconday\" background=\"". imagepath . "/billicon.gif\">";
 	$out.="<a href=\"bills.php\"><img  border=\"0\" width=\"66\" height=\"68\" src=\"". imagepath . "/spacer.gif\"></a>";
	$out.="</td>";
	$out.="</tr>";
	$out.="</table>";
	return $out;
}

function DebugFeedbackForm($intUserId)
{	
	$sql=conDB();
	$strDatabase=our_db;
	$strPHP=  $_SERVER['PHP_SELF'];
	$intUserId=gracefuldecay($intUserId,"0");
	$content=$_REQUEST[qpre . "debug_content"];
	if(IsSuperUser($strDatabase, $intOurLoginID))
	{
		$strSQL1="SELECT COUNT(debug_feedback_id) as 'c'    FROM " . $strDatabase . ".debug_feedback WHERE  url='" . $strPHP . "'";
		$strSQL2="SELECT COUNT(debug_feedback_id) as 'c'    FROM " . $strDatabase . ".debug_feedback WHERE response!='' AND    url='" . $strPHP . "'";
	}
	else
	{
		$strSQL1="SELECT COUNT(debug_feedback_id) as 'c'    FROM " . $strDatabase . ".debug_feedback WHERE user_id=" . $intUserId. " AND  url='" . $strPHP . "'";
		$strSQL2="SELECT COUNT(debug_feedback_id) as 'c'    FROM " . $strDatabase . ".debug_feedback WHERE response!='' AND user_id=" . $intUserId. " AND  url='" . $strPHP . "'";
	}
	
	$records=$sql->query($strSQL1);
	$record=$records[0];
	$count=$record["c"];
	$records=$sql->query($strSQL2);
	$record=$records[0];
	$responsecount=$record["c"];
	if ($content!="")
	{
		$strSQL="INSERT INTO " . our_db . ".debug_feedback(user_id, url, content) VALUES(" . $intUserId . ",'" . $strPHP . "','" . $content . "')";
		$records=$sql->query($strSQL);
 		$out="Thanks for your feedback!";
	}
	else
	{
		$pre="Leave any suggestions you have about the way this page is implemented.";
		$out="<form method=\"POST\" name=\"FForm\" action=\"" . $strPHP . "\">";
		$out.="<div style=\"border: groove; border-color:000000; padding:2px ;margin:2px; background-color:" . textcolorontheme . ";  font-size:12pt\">";
 		$strStyle="";
		$out.=GenericInput(qpre . "debug_content",$pre,  false,  "onclick=document.FForm." . qpre . "debug_content.value=\"\";document.FForm." . qpre . "debug_content.cols=150;",  $strStyle ,  "","text", "150",   "", 6);
		$out.="<div align=\"right\">";
		$out.=GenericInput(qpre . "save","send");
		$out.="</div>";
		$out.="<div class=\"text_10g\">";
		$out.="<a  href=\"debugfeedback.php?" . qpre . "PHP=" . $strPHP . "\">[<span style=\"color:red\">" . $count . "/"  . $responsecount ."</span>]</a>";
		$out.="</div>";
		$out.="</div>";
		$out.="</form>";
	}
	return $out;
}

function sitenav($intOffficeID)
{
	$out="";
	$out.="";
	$out.="";
	$out.="<div style=\"background-image:url('images/tab2.png');  background-repeat:norepeat; color: white; text-align:center; height: 25px; width: 129px; float: right\"><a class=\"nav\" style=\"font-size:10px;\" href=\"index.php?" . qpre . "displaymode=forceclient\">View Your Homepage</a></div> 	\n";
  //$out.="  <div style=\"background-image:url('images/tab.png');  background-repeat:norepeat; color: white; text-align:center; height: 25px; width: 80px; float: right\"><a class=\"nav\" href=\"reg.php?" . qpre . "profilemode=profile\">Edit " . locationtype . "</a></div>  	\n";
  $out.="<div style=\"background-image:url('images/tab.png');  background-repeat:norepeat; color: white; text-align:center; height: 25px; width: 80px; float: right\"><a class=\"nav\"  style=\"font-size:9px;\" href=\"view.php?office_id=" . $intOffficeID . "&x_action=new&x_table=client\">Add " .  customertype . " </a></div>\n";
  $out.="<div style=\"background-image:url('images/tab.png');  background-repeat:norepeat; color: white; text-align:center; height: 25px; width: 80px; float: right\"><a class=\"nav\" href=\"view.php?" . qpre . "table=client&type=client\">" . pluralize(customertype) . " </a></div>  \n";
  $out.="<div style=\"background-image:url('images/tab2.png');  background-repeat:norepeat; color: white; text-align:center; height: 25px; width: 129px; float: right\"><a class=\"nav\"  href=\"view.php?office_id=" . $intOffficeID . "&x_action=new&x_table=practitioner\">Add " .  professionaltype . " </a></div> \n ";
  $out.="<div style=\"background-image:url('images/tab.png');  background-repeat:norepeat; color: white; text-align:center; height: 25px; width: 80px; float: right\"><a class=\"nav\" href=\"view.php?" . qpre . "table=practitioner\">" . pluralize(professionaltype) . "</a></div>  	\n";
	$out.="  <div style=\"background-image:url('images/tab.png'); background-repeat:norepeat; color: white; text-align:center; height: 25px; width: 80px; float: right\"><a class=\"nav\" href=\"index.php?" . qpre . "\">Schedule</a></div>  	\n";
	$out.="";
	return $out;
}

function OurToken()
{
	$servername=$_SERVER["SERVER_NAME"];
	$arrS=explode(".", $servername);
	if(count($arrS)>2)
	{
		return $arrS[0];
	}
}

function CalculateTabLength($strIn, $sizes="10 18 30")
{
	$len=strLen($strIn);
	if($size=="small")
	{
		$sizes="12 18 30";
	}
	else
	{
		$sizes="9 13 17";
	}
	$arrSizes=explode(" ", $sizes);
	if($len<intval($arrSizes[0]))
	{
		$out=40;
	}
	else if($len<intval($arrSizes[1]))
	{
		$out=60;
	}
	else if($len<intval($arrSizes[2]))
	{
		$out=80;
	}
	else
	{
		$out=120;
	}
	return $out;
}

function ScheduleAPhoneCall($event_id, $bwlDoNotPhone=false)
{
	//also schedules email
	//server time is GMT!!!!
	//$sql=conDB();
	$day=Array();
	$phonecallday=Array();
	$bwlAllowPhonecalls=true;
	//$records=$sql->query($strSQL);
	$eventrecord=GenericDBLookup(our_db, "personal_calendar_event","calendar_event_id", $event_id, "");
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
	$phonecall_time =gracefuldecaynotzero($officerecord["phonecall_time"], 10);
	//-----------------------------------
	$practitioner_record=GenericDBLookup(our_db, "practitioner","practitioner_id", $practitioner_id, "");
	$practitioner_name=$practitioner_record["name"];
	$office_timezone_id=$officerecord["timezone_id"];
	$office_timezone_delta=GenericDBLookup(our_db, "timezone","timezone_id", $office_timezone_id, "dif_from_GMT");
	$dtmAppointment=makedate($e_datecode, $e_time);
	for($i=0;$i<6; $i++)
	{
		$bwlEmail=false; 
		if($i<3)
		{
			$bwlEmail=true;
		}
		$thisday=$day[$i];
		//echo $i . " " . $thisday . "<BR>";
		if($thisday!=0)
		{
			$dtmCall=timetocall($dtmAppointment, $office_timezone_delta,  $phonecall_time,$thisday);
			if($dtmCall>time()) //don't bother scheduling phonecalls and emails in the past
			{
				$dtmCall =AddUnitToDate($dtmCall, mt_rand(0,20), "i");//adding a random number of minutes between 0 and 20 to mix up the timing a bit 
				//and not jam up the calling system
				$timetoCallForSQL=date("Y-m-d H:i:s", $dtmCall);
				$patientrecord=GenericDBLookup(our_db, "client","client_id", $e_client_id, "");
				if($patientrecord["guardian_client_id"]!=""  && $patientrecord["guardian_client_id"]>0)
				{
					$dependentfirstname=$patientrecord["firstname"];
					//die($dependentfirstname);
					$guardianrecord=GenericDBLookup(our_db, "client","client_id", $patientrecord["guardian_client_id"], "");
					$guardianphone=gracefuldecay($guardianrecord["cellphone"], $guardianrecord["phone"]);
					$patient_phone=MakeNumberCallable($guardianphone);
					$messagetext="This is a call from " . $office_name . " reminding you of " . $dependentfirstname . "z appointment for " . appointmentDTMtoMessageText($dtmAppointment). ". If you have any questions please call " . $office_phone. ". Thank you.";
					$emailtext="Dear " .$guardianrecord["firstname"] . " " . $guardianrecord["lastname"] . ",\n\nThis is a message from " . $office_name . " reminding you of ";
					$emailtext.=$dependentfirstname . "'s ";
				}
				else
				{
					$patient_phone=gracefuldecay($patientrecord["cellphone"], $patientrecord["phone"]);
					$patient_phone=MakeNumberCallable($patient_phone);
					$messagetext="This is a call from " . $office_name . " reminding you of your appointment for " . appointmentDTMtoMessageText($dtmAppointment). ". If you have any questions please call " . $office_phone. ". Thank you.";
					$emailtext="Dear " .$patientrecord["firstname"] . " " . $patientrecord["lastname"] . ",\n\nThis is a message from " . $office_name . " reminding you of ";
					$emailtext.="your ";
				}
				$emailtext.="appointment for " . appointmentDTMtoMessageText($dtmAppointment). " with " . $practitioner_name . ". If you have any questions please call " . $office_phone . ".";
				$emailtext.="\n\nIf you expect to make this appointment, click this link:\n";
				$emailtext.="http://" . strtolower(sitename) .  "/response.php?" . EncryptQS("m=yes&e=" . $event_id);
				$emailtext.="\n\nIf you would like us to call you, click this link:\n";
				$emailtext.="http://" . strtolower(sitename) .  "/response.php?" . EncryptQS("m=call&e=" . $event_id);
				$emailtext.="\n\nIf you would like to cancel this appointment, click this link:\n";
				$emailtext.="http://" . strtolower(sitename) .  "/response.php?" . EncryptQS("m=no&e=" . $event_id);
				$emailtext.= "\n\nThank you.\n" . $office_name;
				//$strDebugging="\n\nDEBUGGING:\ntime to call or email:" . $timetoCallForSQL . " time of appointment:" . date("Y-m-d H:i:s", $dtmAppointment) . "\nThis is supposed to have come " . $thisday . " days before the appointment.\nThe Event ID for this is: " . $event_id;
				$emailtext.=$strDebugging;
			 	$arrAlteredValuePairs=Array
				(
					"phone_number"=>$patient_phone,
					"timezone"=>$office_timezone_delta,
					"call_content"=>$messagetext,
					"time_to_start"=>$timetoCallForSQL,
					"call_type_id"=>1,
					"attempt_count"=>0,
					"email_content"=>$emailtext,
					"email_sent"=>0,
					"phonecall_status_id"=>1,
					"office_id"=>$e_office_id,
					"callee_id"=>$e_client_id,
					"expiry_date"=>date("Y-m-d H:i:s", $dtmAppointment),
					"calendar_event_id"=>$event_id
				);
				if($bwlEmail)
				{
					$arrAlteredValuePairs["phonecall_only"]=0;
					$arrAlteredValuePairs["email_only"]=1;
				}
				else
				{
					if(!$bwlDoNotPhone)
					{
						$arrAlteredValuePairs["phonecall_only"]=1;
						$arrAlteredValuePairs["email_only"]=0;
					}
				}
				if($bwlEmail || !$bwlAllowPhonecalls)
				{
				}
				else
				{
					$arrAlteredValuePairs["email_sent"]=1;
				}
				$arrAlteredValuePairs["reminder_type"]=$i;
				$strSQL="DELETE FROM " . our_db . ".phone_call WHERE reminder_type='" . $i . "' AND calendar_event_id='" . intval($event_id) . "'";
				//echo $strSQL . "=delsql<BR>";
				$sql=conDB();
				$records=$sql->query($strSQL);
				//so now i'm using phonecall to handle both emails and phonecalls, and a separate the kind by reminder_type.
				//reminder_type is as follows:
				//0 = "first_email";
				//1 = "second_email";
				//2 = "third_email";
				//3 = "first_phonecall";
				//4 = "second_phonecall";
				//5 = "third_phonecall";
				UpdateOrInsert(our_db, "phone_call", "", $arrAlteredValuePairs);
				//die();
			}
			else
			{
				logcollection(true, Array("eventid"=>$event_id, "isemail"=>$bwlEmail, "calltime:"=>date("Y-m-d H:i:s",$dtmCall),  "actualtime"=>date("Y-m-d H:i:s",time()), "i"=>$i), "loggedfails");
			}
		}
		else
		{
			logcollection(true, Array("eventid"=>$event_id, "isemail"=>$bwlEmail, "calltime:"=>date("Y-m-d H:i:s",$dtmCall),  "actualtime"=>date("Y-m-d H:i:s",time()), "i"=>$i), "daywaszero");
		}
	}

}

function timetocall($dtmAppointment, $office_timezone_delta, $preferredhour=10, $dayleadtime=1)
{
	//die($dtmAppointment . " " . $office_timezone_delta);
	//return the time to call in GMT, assuming the time of the appointment is local time for the office
	//for now place the call close to 10am on the preceding day
	//$dtm10amdaybefore=date_modify(date_create($dtmAppointment),"-1 day");
	$arrDate=getdate($dtmAppointment);
	$dtm10amdaybefore=mktime($preferredhour-$office_timezone_delta, "00", "00", $arrDate["mon"], $arrDate["mday"]-$dayleadtime, $arrDate["year"]);
 	return $dtm10amdaybefore;
}

function appointmentDTMtoMessageText($dtmIn)
{
	$out=date("g:i a ~ l F jS", $dtmIn);
	$out=str_replace("~", "on", $out);
	return $out;
}
//echo date("Y-m-d H:i:s") . " " . date("Y-m-d H:i:s",timetocall(time(), 5));
//echo appointmentDTMtoMessageText(time());

function PayPal($cost, $productname, $transaction_id=1, $business="payments@standardsourcemedia.com")
{
//echo $count . " " .  intval($MonthsSponsored."") ;
	$pageout.=   "<html><body><form name='BForm' action=\"https://www.paypal.com/cgi-bin/webscr\" method=\"post\">\n";
	$pageout.=   "<input type=\"hidden\" name=\"cmd\" value=\"_xclick\">\n";
	$pageout.=   "<input type=\"hidden\" name=\"business\" value=\"" . $business . "\">\n";
	$pageout.=    "<input type=\"hidden\" name=\"item_name\" value=\"" .  $productname . "\">\n";
	$pageout.=   "<input type=\"hidden\" name=\"item_number\" value=\"" . $transaction_id . "\">\n";
	$pageout.=    "<input type=\"hidden\" name=\"amount\" value=\"" . $cost . "\">\n";
	$pageout.=    "<input type=\"hidden\" name=\"no_note\" value=\"1\">\n";
	$pageout.=   "<input type=\"hidden\" name=\"currency_code\" value=\"USD\">\n";
	$pageout.=    "<input type=\"hidden\" name=\"tax\" value=\"0\">\n";
	$pageout.=    "<input type=\"hidden\" name=\"lc\" value=\"US\">\n";
	$pageout.=    "<input type=\"hidden\"  border=\"0\" name=\"ssubmit\" value=\"Pay With PayPal\">\n";
	$pageout.=    "<input type=\"hidden\"  border=\"0\" name=\"notify_url\" value=\"http://" . $_SERVER['SERVER_NAME'] . "/paymentcomplete.php\">\n";
	$pageout.=    "</form>\n";
	$pageout.=    "<script>document.BForm.submit()</script></body></html>\n";
	return $pageout;
}
 
function ChangeActiveState($login_id, $is_active)
{
	$strDatabase=our_db;
	$strTable="login";
	$arrDescribedValuePairs=Array("login_id"=>$login_id);
	$arrAlteredValuePairs=Array("is_active"=>$is_active);
	if($login_id!="")
	{
	UpdateOrInsert($strDatabase, $strTable, $arrDescribedValuePairs, $arrAlteredValuePairs);
	}
}

function LoginIdToClientOrOfficeID($IDin, $type="")
{
	if($type=="")
	{
		$idOut=GenericDBLookup(our_db, "office","login_id", $IDin, "office_id");
		if($idOut=="")
		{
			$idOut=GenericDBLookup(our_db, "client","login_id", $IDin, "client_id");
		}
	}
	else if ($type=="office")
	{
		$idOut=GenericDBLookup(our_db, "office","login_id", $IDin, "office_id");
	}
	else
	{
		$idOut=GenericDBLookup(our_db, "client","login_id", $IDin, "client_id");
	}
	return $idOut;
}
 
 
function DayView($office_id, $datecode, $practitioner_id, $size=600)
{
	$strPSQL="";
	if($practitioner_id!="")
	{
		$strPSQL=" AND practitioner_id='" . $practitioner_id . "'";
	}
	$strSQL="SELECT calendar_event_id, e.client_id , CONCAT_WS(' ', firstname, lastname) as 'patient name', status_name, time, duration,p.practitioner_id,  name as 'practitioner name', c.phone, notes FROM " . our_db . ".personal_calendar_event e left JOIN event_status s ON e.event_status_id=s.event_status_id JOIN client c ON c.client_id=e.client_id JOIN practitioner p ON e.practitioner_id=p.practitioner_id WHERE e.office_id=" . $office_id . " AND datecode='" . $datecode . "' " . $strPSQL . " ORDER BY  time ASC";
	$sql=conDB();
	$records=$sql->query($strSQL);
	//echo mysql_error();
	
	if(is_array($records))
	{  
	//GenericRSDisplayFromRS($strPHP,$strLabel, $rows, $truncate, $intWidth, $strLinkFieldName="", $strLinkIDName="", $strAdditionalLink="", $strSuppressFields="", $bwlSuppressHeader=false, $bwlPrettyUpFieldNames=true, $intFieldLimit=10, $idencryptionstring="", $arrPostProcessing="", $arrFieldLabels="", $bwlSuppressLinksWhereNoData=true)
		$out=GenericRSDisplayFromRS($strPHP,"", $records, $truncate, $size ,  "calendar_event_id",  "calendar_event_id", "","datecode recurrence_id practitioner_id guardian_client_id type office_id name_of_guardian login_id event_status_id sort_id address", false,  true,  40,  "",  Array("client_id"=>"'<a href=view.php?" . qpre . "table=client&client_id=<value/>>edit</a>'", "calendar_event_id"=>"'<a href=view.php?" . qpre . "editevent=<value/>>edit</a>'"), Array("status_name"=>"status", "calendar_event_id"=>"appmt", "client_id"=>"client"),  true);
	}
	return $out;
}
 
function MaxSimultaneousAppointments($intPractitionerID)
{
	$strSQL="SELECT count(client_id) as thiscount FROM " . our_db . ".personal_calendar_event WHERE  practitioner_id=" . intval($intPractitionerID) . " GROUP BY datecode, time ORDER BY thiscount DESC";
	//die($strSQL);
	$sql=conDB();
	$records = $sql->query($strSQL);
	$record =$records[0];
	return $record["thiscount"];
}

function PractitionerCount($intOfficeID)
{
	$strSQL="SELECT count(practitioner_id) as thiscount FROM " . our_db . ".practitioner WHERE  office_id='" . intval($intOfficeID) . "'";
	//die($strSQL);
	$sql=conDB();
	$records = $sql->query($strSQL);
	$record =$records[0];
	return $record["thiscount"];
}

function MakeNumberCallable($number)
{
	$out=$number;
	$out= trim(str_replace( " ","", $out));
	if(strlen($out)==7)
	{
		return $out;
	}
	else if (strlen($out)==10)
	{
		return "1" . $out;
	}
	return $out;
}

function FrontendOfficePicture($subdomain)
{
	if(defined('userimagepath'))
	{
		$imageroot=userimagepath;
	}
	else if (defined('imagepath'))
	{
		$imageroot=imagepath;
	}
	$out="";
	//used to be alcoholicdoctor.png
	//$thisImagePath="images/alcoholicdoctor.png";
	$thisImagePath="images/real_professional.png";
	$strExtension="";
	$strExtensionsToTry="jpg gif swf";
	$arrExtensions=explode(" ", $strExtensionsToTry);
	foreach($arrExtensions as $strThisExtension)
	{
		//echo $imageroot . "/" . $subdomain . $strThisExtension . "<BR>";
		if(file_exists($imageroot . "/" . $subdomain .  "." . $strThisExtension))
		{
			$thisImagePath=$imageroot . "/" . $subdomain . "." . $strThisExtension;
			$strExtension=$strThisExtension;
		}
	
	}
	if($thisImagePath!="")
	{
		if($strExtension=="swf")
		{
			$out=flash(themecolor,200, 300, $thisImagePath);
		}
		else
		{
			$out="<img width=\"200\" border='0' src=\"" . $thisImagePath . "\">";
		}
	}
 
	return $out;
}
?>