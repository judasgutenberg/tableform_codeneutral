<?
$USER="";
$SESSION="";

function LoginIndication($strPHP, $strUsername)
{
	$out="";
	if($strUsername=="")
	{
	
	}
	else
	{
	
		$url=replaceMultipleQueryVariables("username", "", "password",  "", qpre ."logout", "logout");
		$out.="<div style=\"margin-top:3px;\"><img src=\"images/arrow.gif\" width=\"3\" height=\"6\" alt=\"\" style=\"margin-right:2px;\"> <a href=\"" . $url . "\">Not Your Account?</a></div>";
		$out.="<div style=\"margin-top:2px;\"><img src=\"images/arrow.gif\" width=\"3\" height=\"6\" alt=\"\" style=\"margin-right:2px;\"> <a href=\"" . $url . "\"><b>Sign Out</b></a></div>";
	}

	return $out;
}



function ulogout()
{
	//echo "#";
 	//global $COOKIE_VARS;
	setcookie("xidC_remember", "x", mktime(12,0,0,1, 1, 1990), "/" );
	setcookie("MoodleSession", "x", mktime(12,0,0,1, 1, 1990), "/" );
	setcookie("xid", "x", mktime(12,0,0,1, 1, 1990), "/" );
	//setcookie("MoodleSessionTest", "x", mktime(12,0,0,1, 1, 1990), "/" );
	//setcookie("MOODLEID_", "x", mktime(12,0,0,1, 1, 1990), "/" );
	if (setcookie("mcertifiedlogin", "x", mktime(12,0,0,1, 1, 1990), "/" ))
	{
		//echo "cookie cleared!";
	}
}

function TeacherList($intCourseID)
{
	GLOBAL $strcustomurlroot;
	$sql=conDB();
	$out="";
	$strPHP=  $strcustomurlroot . "teacher.php?teacherid=";
	$strSQL="SELECT * FROM " . our_db . ".mdl_role_assignments a JOIN " . our_db . ".mdl_user u ON a.userid=u.id
	JOIN " . our_db . ".mdl_context con ON a.contextid=con.id 
	 WHERE (roleid=3  or  roleid=4) 
	 AND contextlevel=50
	 AND instanceid='". $intCourseID . "'";
	$teacherrecords = $sql->query($strSQL);
	foreach($teacherrecords as $teacherrecord)
	{
		$out.="<a href=\"" . $strPHP . "" . $teacherrecord["userid"] . "\">" .  $teacherrecord["firstname"] . " " . $teacherrecord["lastname"] . "</a><br/>";
	}
	return $out;
}

function CourseList($intTeacherID)
{
	GLOBAL $strcustomurlroot;
	$sql=conDB();
	$out="<p/><div class='mainsubtitle'>Courses</div><br>";
	$strPHP=  $strcustomurlroot . "product_detail.php?productid=";
	$strSQL="SELECT * FROM " . our_db . ".mdl_role_assignments a 
	JOIN " . our_db . ".mdl_context con ON a.contextid=con.id 
	JOIN  " . our_db . ".mdl_course c ON con.instanceid=c.id  
	JOIN " . our_db . ".xcart_products p on c.id=p.mdl_course_id 
	WHERE (roleid=3  or  roleid=4) 
	AND contextlevel=50
	AND a.userid='". $intTeacherID . "'";
	//echo $strSQL;
	$courserecords = $sql->query($strSQL);
	foreach($courserecords as $courserecord)
	{
		$out.="<b><a href=\"" . $strPHP . "" . $courserecord["productid"] . "\">" .  $courserecord["product"]   . "</a></b> : " . $courserecord["descr"] . "<br/>";
	}
	
	if($out=="")
	{
		$out.="This teacher has no courses yet.";
	}
	return $out;
}

function CourseCountForStudent($intStudentID)
{
	GLOBAL $strcustomurlroot;
	$sql=conDB();
	$count=0;
	$strSQL="SELECT * FROM " . our_db . ".mdl_role_assignments a 
	JOIN " . our_db . ".mdl_context con ON a.contextid=con.id 
	JOIN  " . our_db . ".mdl_course c ON con.instanceid=c.id  
	JOIN " . our_db . ".xcart_products p on c.id=p.mdl_course_id 
	WHERE (roleid=5 
	AND contextlevel=50
	AND a.userid='". $intStudentID . "')";
	//echo $strSQL;
	$courserecords = $sql->query($strSQL);
	foreach($courserecords as $courserecord)
	{
		$count++;
	}
	return $count;
}

function uTestAndSetLogin($strDatabase, $strUser, $Password)
{
	if (uIsLoginValid($strDatabase, $strUser, $Password))
	{
		usetLoggedIn($strUser);
		$out=$strUser;
	}
	else
	{
		$out="";
	}
	return($out);
}


function usetLoggedIn($strUser)
{

	//setcookie("these",$strUser, time()+9999, "/");
	if ( setcookie("mcertifiedlogin", addletters($strUser, encryptionkey), time()+1131536000, "/" ))
	{
		//echo "cookie set!";
	}
}

function uWhoIsLoggedIn()
{
	global $COOKIE_VARS;
	
	$strCookieVal= subtractletters( $_COOKIE["mcertifiedlogin"], encryptionkey);

	if ($strCookieVal!="")
	{
		return($strCookieVal);
	}
}

function uIsLoginValid($strDatabase, $strUser, $strPassword)
{
	$out=false;
	$sql=conDB();
	//use the function data to do a query 
 	$strSQL="SELECT user_password from " . $strDatabase . ".user WHERE username = '" . $strUser . "'";
	$records = $sql->query($strSQL);
	//echo count($records) . "=";
	$record=$records[0];
 
	if ($record["user_password"]==$strPassword and $strPassword!="")
		{
			$out=true;
		}
	return($out);
}


function uGetUserID($strDatabase, $strUsername)
{
	$sql=conDB();
	$strSQL="SELECT user_id FROM  " . $strDatabase . ".user  WHERE username = '" . $strUsername . "'";
	//echo $strSQL;
	$records = $sql->query($strSQL);
	$record=$records[0];
	$out= $record["user_id"];
	return $out;
}

function toploginindication($strPHP,  $strUsername, $loginerror="")
{ 
 
	$out="";
	if ($loginerror!='')
		$out.="<tr>";
		$out.="<td colspan=\"4\" class=\"text_11w\">" . $loginerror . "</td>";
		$out.="</tr>";
	if($strUsername=="")
	{
		$out.="<form action=\"" . $strPHP . "\" method=\"post\"><tr>";
		$out.="<td class=\"text_11w\">User ID:</td>";
		$out.="<td style=\"padding:0px 10px 0px 6px;\"><input type=\"text\" name=\"username\" style=\"width:80px;\"></td>";
		$out.="<td class=\"text_11w\">Password:</td>";
		$out.="<td style=\"padding:0px 10px 0px 6px;\"><input type=\"password\" name=\"password\" style=\"width:80px;\"></td>";
		$out.="<td><input type=\"submit\" name=\"Submit\" value=\"LOGIN\" class=\"button\"></td>";
		//foreach($_REQUEST as $k=>$v)
		//{
		// 	if(!inList("username password user_password " . qpre . "logout", $k))
			//{
			//	$out.="\n<input type=\"hidden\" name=\"" . $k . "\" value=\"" . str_replace(chr(34), "\\" . chr(34),  $v)  . "\">\n";
			//}
		//}
		
		
		$out.="</tr></form>";
		
	}
	else 
	{ 
		$out.="<tr><td colspan=\"5\" align=\"right\" width=\"609\" height=\"47\" class=\"text_11w\">Welcome <b>" . $strUsername . "</b></td></tr>";
	
	}
	return $out;
}






///////////////////////
////ad functions//////	
/////////////////////
		
function showad($ad_placement_id, $lastid="" )
{
	$sql=conDB();
	$out="";
	$strPossiblePic ="";
	$strSQL="SELECT * FROM " . our_db . ".ad a join " . our_db . ".ad_placement x on x.ad_id=a.ad_id join " . our_db . ".ad_type t on a.ad_type=t.ad_type_id WHERE ad_location_id=" . $ad_placement_id;
	//echo $strSQL;
	$records = $sql->query($strSQL);
	$count=count($records);
	if ($lastid=="")
	{
		srand(time());
		$rand=rand(0, $count-1);
	}
	else
	{
		$rand=intval($lastid)+1;
		if ($rand>$count-1)
		{
			$rand=0;
		
		}
	
	}
	//echo $rand . "==<br>";
 	$record=$records[$rand];
	//echo $rand . "++++". $count . "+++-<br>";
	$strColumnNameToUse="media_filename";
	$strNameToUse= $record[$strColumnNameToUse];
	//echo "!!!!" . fieldNameToFolderPath($strColumnNameToUse, "images") . $strNameToUse;
	$path=fieldNameToFolderPath($strColumnNameToUse, "images") . $strNameToUse;
								//echo $path . "<br>";
								
	$url="adhit.php?i=" . $record["ad_id"] . "&u=" . urlencode($record["url"]); 
	if (file_exists($path))
	{
		if (contains(strtolower($path), ".swf"))
		{
			$strPossiblePic=  PictureIfThere($path, $record["width"],  $record["height"], 0, $url) ;
		}
		else
		{
		$strPossiblePic= "<a href=\"" . 	$url . "\">" . PictureIfThere($path, $record["width"],  $record["height"], 0) . "</a>";
		}
 
	}
	 $strPossiblePic = $strPossiblePic ."<z $rand z>";
	return $strPossiblePic;
}



function LogAdHit($ad_id)
{
	
	$strReferal=$_SERVER['HTTP_REFERER'];
	$strTable=our_db . ".ad_hit";
	//$strSQL="select * from " . $strTable . " where referal_url='" . $strReferal . "' and ad_id=" . $ad_id  ; 
	//$sql=conDB();

	//$records =  $sql->query($strSQL);
	//echo $strSQL. "<br>";
	//if (count($records)>0)
 
 		$sql=conDB();
		$timestamp=time();
		$phpdate= date("Y-m-d H:i:s", $timestamp);
		$count=1;
		$strSQL="insert into " . $strTable . "(referal_url,hitcount, ad_id, time) values('" . $strReferal . "'," . $count . "," . $ad_id . ",'" . $phpdate . "')";
	 
	//echo $strSQL  . "<br>";
//die();
	$records =  $sql->query($strSQL);
	 
}

function GetTopBanner($categoryid, $defaultimage="h_collection.jpg")
{
	$sql=conDB();
	//$default="h_collection.jpg";
	$strSQL="select  * from " . our_db . ". xcart_categories where  categoryid =".$categoryid. ".";
	$records = $sql->query($strSQL);
	$record = $records[0];
	$topbanner=gracefuldecay($record["topbanner_filename"], $defaultimage);
	return $topbanner;
}

function DisplayLeftShopNav($parentid="", &$records, &$strSQL, $url="shop_department.php",$url2="shop_class.php", $root=393, $categoryid=330)
{	
	$sql=conDB();
	$out="";
	//select all categories except 'looks' categoryid = 330
	$strSQL="select  * from " . our_db . ". xcart_categories where parentid =" . $root . "  AND avail ='". "Y"."' AND categoryid != '" . $categoryid ."' order by category";
	//echo $strSQL;
	$drecords = $sql->query($strSQL);
    $out.="<div class=\"links\">";
	foreach($drecords as $drecord)
	{
		// check if it's not the deparment specified in the url
		//echo $drecord["categoryid"] . " " . $parentid . "<br>";
		if($drecord["categoryid"]!=$parentid)
		{
		 $out.="<a href=\"" . $url . "?categoryid=" .$drecord["categoryid"] . "\">" . $drecord["category"] . "</a><br>";
	  
		}
		// if it is a department, bold it.
		else 
		{  
			$out.="<b><a href=\"shop_department.php?categoryid=" .$drecord["categoryid"] . "\">" . $drecord["category"] . "</a></b><br>";
			 // if the category is  specified in the url then set it to $featuredcategory
			$featuredcategoryid = $drecord["categoryid"];
			
			
			$strSQL="select  * from " . our_db . ". xcart_categories where avail ='". "Y"."' and parentid =".$drecord["categoryid"]. " order by category";
			$records = $sql->query($strSQL);
		
			$out.="<div class=\"links2\">";
		
			foreach($records as $record)
			{
				$out.="<a href=\"" . $url2 ."?categoryid=" . $record["categoryid"] . "\">" . $record["category"] . "</a><br>";
			 
			 } 
			 $out.="</div>";
			 
		 }
	 }
	
		
	return $out;
}

function random_string ($length=15) {
    $pool  = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $pool .= 'abcdefghijklmnopqrstuvwxyz';
    $pool .= '0123456789';
    $poollen = strlen($pool);
    mt_srand ((double) microtime() * 1000000);
    $string = '';
    for ($i = 0; $i < $length; $i++) {
        $string .= substr($pool, (mt_rand()%($poollen)), 1);
    }
    return $string;
}

function sitetext($key)
{
	return GenericDBLookup(our_db,  "site_text",  "name",$key, "value");
}










//session_test
//USER
//sesskey
//






function logmein()
{
	$method=="db";
 
	global $SESSION;
	global $USER;
	//setcookie("MoodleSessionTest", random_string(10), mktime(). time()+60*60*24*30, '/');
	
	$sessionid=$_COOKIE["MoodleSessionmdl"];
	//echo "-" . $sessionid . "-";
	if($sessionid!="")
	{
	
		if($method!="file")
		{
			$content=GenericDBLookup(our_db, "mdl_sessions2", "sesskey", $sessionid, "sessdata",  false,  true);
			
			$content=urldecode($content);
			//echo "-" . $content . "-";
		}
		else
		{


			$url="moodle/moodledata/sessions/sess_" . $sessionid;
			if(is_file($url))
			{
			$handle=fopen ($url, "r");
			
				if(filesize($url)>0)
				{
					$content=fread($handle, filesize($url));
					
					//die($content);
					fclose($handle);
				}
			}
		}
	
	 	if($content!="")
		{
			//echo $content . "<p>";
			
			$strSession=trim(parseBetween($content, "SESSION|", "USER|"));
			$strUser=trim(parseBetween($content,   "USER|",""));
			
			if(1==2)
			{
				echo "<P>SESSION:<P>";
				echo DumpSerializedObject($strSession);
				echo "<P>USER:<P>";
				echo DumpSerializedObject($strUser);
			}


			$SESSION =   unserialize($strSession);   // Makes them easier to reference
		
			$USER    = unserialize($strUser);

		
		}
				
		
	}
}

function SimpleMoodleLogin($username, $password)
{
 
	$random=random_string(10);
	$sessid=random_string(26);
	$sesskeyname="moodle/moodledata/sessions/sess_" . $sessid;
	$strSessionPart='SESSION|O:6:"object":3:{s:12:"session_test";s:10:"' . $random . '";s:10:"logincount";i:0;s:12:"justloggedin";b:1;}';
	$encpassword=md5($password);
	
	$strUserPre='USER|O:8:"stdClass":67:{';
	$strUserPost=';s:7:"display";a:1:{i:447;s:1:"0";}s:10:"preference";a:0:{}s:16:"lastcourseaccess";a:1:{i:447;s:10:"1236804562";}s:19:"currentcourseaccess";a:0:{}s:11:"groupmember";a:0:{}s:7:"sesskey";s:10:"0zArg7b1wY";s:9:"sessionIP";s:32:"073f5ce37daddd2d14a4ebfe64578645";s:6:"access";a:5:{s:2:"ra";a:2:{s:8:"/1/3/677";a:1:{i:0;s:1:"5";}s:2:"/1";a:1:{i:0;s:1:"7";}}s:4:"rdef";a:3:{s:4:"/1:5";a:39:{s:13:"mod/chat:chat";s:1:"1";s:20:"mod/glossary:comment";s:1:"1";s:16:"moodle/blog:view";s:1:"1";s:16:"mod/chat:readlog";s:1:"1";s:18:"mod/glossary:write";s:1:"1";s:18:"moodle/course:view";s:1:"1";s:17:"mod/choice:choose";s:1:"1";s:18:"mod/hotpot:attempt";s:1:"1";s:30:"moodle/course:viewparticipants";s:1:"1";s:16:"mod/data:comment";s:1:"1";s:20:"mod/lams:participate";s:1:"1";s:24:"moodle/course:viewscales";s:1:"1";s:18:"mod/data:viewentry";s:1:"1";s:16:"mod/quiz:attempt";s:1:"1";s:17:"moodle/grade:view";s:1:"1";s:19:"mod/data:writeentry";s:1:"1";s:13:"mod/quiz:view";s:1:"1";s:21:"moodle/legacy:student";s:1:"1";s:26:"mod/forum:createattachment";s:1:"1";s:19:"mod/scorm:savetrack";s:1:"1";s:25:"moodle/user:readuserblogs";s:1:"1";s:23:"mod/forum:deleteownpost";s:1:"1";s:18:"mod/scorm:skipview";s:1:"1";s:25:"moodle/user:readuserposts";s:1:"1";s:30:"mod/forum:initialsubscriptions";s:1:"1";s:20:"mod/scorm:viewscores";s:1:"1";s:23:"moodle/user:viewdetails";s:1:"1";s:25:"gradereport/overview:view";s:1:"1";s:19:"mod/forum:replypost";s:1:"1";s:22:"mod/survey:participate";s:1:"1";s:21:"gradereport/user:view";s:1:"1";s:25:"mod/forum:startdiscussion";s:1:"1";s:20:"mod/wiki:participate";s:1:"1";s:21:"mod/assignment:submit";s:1:"1";s:24:"mod/forum:viewdiscussion";s:1:"1";s:24:"mod/workshop:participate";s:1:"1";s:19:"mod/assignment:view";s:1:"1";s:20:"mod/forum:viewrating";s:1:"1";s:17:"moodle/block:view";s:1:"1";}s:4:"/1:7";a:11:{s:23:"moodle/site:sendmessage";s:1:"1";s:17:"moodle/tag:create";s:1:"1";s:15:"moodle/tag:edit";s:1:"1";s:29:"moodle/user:changeownpassword";s:1:"1";s:26:"moodle/user:editownprofile";s:1:"1";s:17:"moodle/block:view";s:1:"1";s:18:"moodle/blog:create";s:1:"1";s:16:"moodle/blog:view";s:1:"1";s:32:"moodle/calendar:manageownentries";s:1:"1";s:18:"moodle/legacy:user";s:1:"1";s:22:"moodle/my:manageblocks";s:1:"1";}s:6:"/1/2:7";a:1:{s:24:"mod/forum:viewdiscussion";s:1:"1";}}s:6:"loaded";a:0:{}s:2:"dr";s:1:"7";s:4:"time";i:1238187954;}}';
	$userarray=GenericDBLookup(our_db, "mdl_user", "username", $username, "",  false,  true);
	$storedencpassword=$userarray["password"];

	if($storedencpassword=$encpassword)//cool. we have a match
	{
		$serializeduserdump=serialize($userarray);
		$locfirstcurly=strpos(	$serializeduserdump, "{");
		$trimmedsud=substr($serializeduserdump, $locfirstcurly+1);
		$trimmedsud= RemoveEndCharactersIfMatch($trimmedsud, "}");
		$content=$strSessionPart . $strUserPre . $trimmedsud . 	$strUserPost ;
		
		$handle=fopen ($sesskeyname, "w");
		//die ($content);
		fwrite($handle, $content);
		fclose($handle);  
		setcookie("MoodleSession", $sessid, mktime(). time()+60*60*24*30, '/');
		setcookie("MoodleSessionTest", $random, mktime(). time()+60*60*24*30, '/');
	  	setcookie("MOODLEID_", "%25EE%25C4%250AI%25A0i%25E2", time()+30, '/');
		//setcookie("MoodleSessionTest", random_string(10), mktime(). time()+60*60*24*30, '/');
	
	}




}
 
//http://mcertified.com/getopost.php?doxcartlogin=1&testcookies=1&tourl=/&actioner=%2Fmoodle%2Flogin%2Findex.php&username=omar&password=pool
function frontendloginarrest($USER,  $strcustomurlroot)
{
    $out="";
	//$qs=$_SERVER['QUERY_STRING'];
	$qs=replaceSpecificQueryVariable("final", "loggedin", $_GET);
	$oururl=$_SERVER['PHP_SELF'] . IfAThenB($qs, "?") .$qs;
	//die($oururl);
	if(1==2)
	{
		$out.="<div class=\"sb_top\"><img src=\"images/sb_login.png\" alt=\"Members Log In\" /></div>\n";
		$out.="<div class=\"sb_content\">\n";
		$out.=" <table width=\"210\" align=\"center\" class=\"sb_login\">\n";
		$out.="<form action=\"getopost.php\" method=\"post\" id=\"login\">\n";
		$out.="   <tr>\n";
		$out.="<td>Username:</td>\n";
		$out.="<td align=\"right\"><input type=\"text\" name=\"username\" style=\"width:130px\" /></td>\n";               
		$out.="</tr>\n";
		$out.="<tr>\n";
		$out.="<td>Password:</td>\n";
		$out.="<td align=\"right\"><input type=\"password\" name=\"password\" style=\"width:130px\" /></td> \n";              
		$out.=" </tr>\n";
		$out.="   <tr>\n";
		$out.="<td colspan=\"2\">\n";
		
		$out.=" <table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"210\" style=\"margin-top:4px;\">\n";
		$out.=" <tr>\n";
		$out.="  <td width=\"24\"><input type=\"checkbox\" name=\"remember\" value=\"Y\" class=\"radio\" /></td>\n";
		$out.="   <td style=\"font-size:10px;\">Remember Me</td>\n";
		$out.=" <td align=\"right\"><input type=\"image\" src=\"images/b_login.gif\" value=\"submit\" class=\"radio\" /></td>\n";     
		$out.=" </tr>\n";
		$out.="</table>\n";            
		
		$out.="</td>\n";
		$out.=" </tr>\n";
		$out.="<tr>\n";
		$out.="<td colspan=\"2\" align=\"center\"><a href=\"" . $strcustomurlroot . "moodle/login/forgot_password.php\">Retrieve Password</a> &nbsp;|&nbsp; <a href=\"moodle/login/signup.php\">New Members Register</a></td>\n";
		
		$out.="  </tr>\n \n";
		$out.="<input type=\"hidden\" name=\"testcookies\" value=\"1\" />\n";
		$out.="<input type=\"hidden\" name=\"tourl\" value=\"" . ($oururl) . "\">\n";
		
		$out.="<input type=\"hidden\" name=\"doxcartlogin\" value=\"1\">\n";
		$out.="<input type=\"hidden\" name=\"actioner\" value=\"" . $strcustomurlroot . "moodle/login/index.php\">\n";
		$out.="</form> \n";
		$out.="  </table>\n";
		$out.="  </div>\n";          
		$out.="<div class=\"sb_bottom\"><img src=\"images/sb_bottom.png\" /></div>\n"; 
	 
 	}
	else
	{
		
		 
		//$out.="<p/>\n";
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	if($USER->id<1)
	{
		$topimg="sb_login";
	}
	else
	{
		$topimg="sb_welcome";
	}
	
	$strNewDiv="
	<div class=\"sb_top\"><img src=\"/images/" . $topimg .".png\" alt=\"Members Log In\" /></div> 
		<div class=\"sb_content\">
		 <table width=\"210\" align=\"center\" class=\"sb_login\">\n";
		$strNewDiv.="<form action=\"/getopost.php\" method=\"post\" id=\"login\">\n";
		if($USER->id<1)
		{
		
				$strNewDiv.="   <tr>\n";
				$strNewDiv.="<td>Username:</td>\n";
				$strNewDiv.="<td align=\"right\"><input type=\"text\" name=\"username\" style=\"width:130px\" /></td>\n";               
				$strNewDiv.="</tr>\n";
				$strNewDiv.="<tr>\n";
				$strNewDiv.="<td>Password:</td>\n";
				$strNewDiv.="<td align=\"right\"><input type=\"password\" name=\"password\" style=\"width:130px\" /></td> \n";              
				$strNewDiv.=" </tr>\n";
				$strNewDiv.="   <tr>\n";
				$strNewDiv.="<td colspan=\"2\">\n";
				
				$strNewDiv.=" <table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"210\" style=\"margin-top:4px;\">\n";
				$strNewDiv.=" <tr>\n";
				$strNewDiv.="  <td width=\"24\"><input type=\"checkbox\" name=\"remember\" value=\"Y\" class=\"radio\" /></td>\n";
				$strNewDiv.="   <td style=\"font-size:10px;\">Remember Me</td>\n";
				$strNewDiv.=" <td align=\"right\"><input type=\"image\" src=\"images/b_login.gif\" value=\"submit\" class=\"radio\" /></td>\n";     
				$strNewDiv.=" </tr>\n";
				$strNewDiv.="</table>\n";            
				
				$strNewDiv.="</td>\n";
				$strNewDiv.=" </tr>\n";
				$strNewDiv.="<tr>\n";
				$strNewDiv.="<td colspan=\"2\" align=\"center\"><a href=\"" . $strcustomurlroot . "moodle/login/forgot_password.php\">Retrieve Password</a> &nbsp;|&nbsp; <a href=\"moodle/login/signup.php\">New Members Register</a></td>\n";
				
				$strNewDiv.="  </tr>\n \n";
				$strNewDiv.="<input type=\"hidden\" name=\"testcookies\" value=\"1\" />\n";
				$strNewDiv.="<input type=\"hidden\" name=\"tourl\" value=\"" . ($oururl) . "\">\n";
				
				$strNewDiv.="<input type=\"hidden\" name=\"doxcartlogin\" value=\"1\">\n";
				$strNewDiv.="<input type=\"hidden\" name=\"actioner\" value=\"" . $strcustomurlroot . "moodle/login/index.php\">\n";
		
		
		}
		else
		{
		$strNewDiv.="<tr>
		<td width=\"23\">&nbsp; </td>
		<td width=\"183\">" . $USER->username . "</td>               
		</tr>
		<tr>
		<td>&nbsp;</td><td>";
		if(HasRoleInAClass($USER->id))
		{
			$strNewDiv.="&nbsp;&nbsp;<a href=\"" . $strcustomurlroot . "moodle\">My Courses</a>\n";
			$bwlHasLine=true;
		}
		
		
		$strNewDiv.="</td>             
		 </tr>
		   <tr>
		<td colspan=\"2\">
		
		 <table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"210\" style=\"margin-top:4px;\">
		 <tr>
		  <td width=\"24\"> </td><td width=\"113\">";
		  
		if(HasAccomplishment($USER->id))
		{

			$strNewDiv.=" <a href=\"/accomplishments.php\">My Certificates</a>\n";
		}
		
		   $strNewDiv.="</td>
		 <td width=\"73\" align=\"right\"><a href=\"" . $strcustomurlroot . "moodle/login/logout.php?tourl=" . str_replace("final=loggedin", "final=", $oururl) . "\"><img src=\"/images/b_logout.gif\" border=\"0\" cl /></a></td>     
		 </tr>
		</table>            
		
		</td>
		 </tr>
		<tr>
		<td colspan=\"2\" align=\"center\" style=\"font-size:10px;\"><a href=\"/register.php?mode=update\">Change Account Info</a> &nbsp;|&nbsp; <a href=\"/faq.php\">Help Center FAQ </a></td>
		
		  </tr>";
		  }
		
		 $strNewDiv.="</form> 
		  </table>
		  </div>          
		<div class=\"sb_bottom\"><img src=\"/images/sb_bottom.png\" /></div>
	
	";
	
	
	
 
	
	
	
	
	
	
	
	
	
		//$out.="Hello, " . $USER->username . "!  (<a href=\"" . $strcustomurlroot . "moodle/login/logout.php?tourl=" . str_replace("final=loggedin", "final=", $oururl) . "\">logout</a>)\n";
		//before we bother creating a link to courses, let's make sure dude is enrolled in at least one of the mother fuckers
		//$bwlHasLine=false;
		//if(HasRoleInAClass($USER->id))
		//{
		//	$out.="&nbsp;&nbsp;<a href=\"" . $strcustomurlroot . "moodle\"> Courses</a>\n";
		//	$bwlHasLine=true;
		//}
		//if(HasAccomplishment($USER->id))
		//{
			//if($bwlHasLine)
			//{
			//	$out.=" | ";
			//}
		//	$out.=" <a href=\"accomplishments.php\">Certificates</a>\n";
		//}
		//$out.="<p/>\n";
 
	}
	
	 
 
	return $strNewDiv;
}


function HasRoleInAClass($userid)
{
	$strSQL="SELECT * FROM " . our_db . ".mdl_role_assignments WHERE userid=" . $userid . "";
	$count=CountSQLRecords($strSQL);
	//echo $strSQL;
	if($count>0)
	{
		return true;
	}
	return false;
}

function HasAccomplishment($userid)
{
	$strSQL="SELECT * FROM " . our_db . ".accomplishment WHERE user_id=" . $userid . "";
	$count=CountSQLRecords($strSQL);
	//echo $strSQL;
	if($count>0)
	{
		return true;
	}
	return false;
}







function DumpSerializedObject($strSerialized)
{
	//http://us2.php.net/manual/en/book.classobj.php
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$out="";
	$tableheader="<table class=\"bgclassline\" cellpadding=\"0\" cellspacing=\"1\" border=\"0\" width=\"500\">\n";
	$out.=$tableheader;
	$out.="<tr class=\"bgclassline\"><td colspan=\"2\">\n";
	$obj=unserialize($strSerialized);
	$arrProperties=get_object_vars($obj);
	$out.=htmlrow($strLineClass, 
				"&nbsp;",
				"Object Variables"
				);
	if(is_array($arrProperties))
	{
		foreach($arrProperties as $k=>$v)
		{
			$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
			$out.=htmlrow($strThisBgClass, 
				$k,
				$v
				);
		}
	}
	$out.=htmlrow($strLineClass, 
			"&nbsp;",
			"Class Vars"
			);
	$arrProperties=get_class_vars($obj);
	if(is_array($arrProperties))
	{
		foreach($arrProperties as $k=>$v)
		{
			$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
			$out.=htmlrow($strThisBgClass, 
				$k,
				$v
				);
		}
	}
	$out.="</table>";
	return $out;
}



//MOODLE ENCRYPTION, etc:
function rc4encrypt($data) {
    $password = 'nfgjeingjk';
    return endecrypt($password, $data, '');
}

/**
 * rc4decrypt
 *
 * @param string $data ?
 * @return string
 * @todo Finish documenting this function
 */
function rc4decrypt($data) {
    $password = 'nfgjeingjk';
    return endecrypt($password, $data, 'de');
}

/**
 * Based on a class by Mukul Sabharwal [mukulsabharwal @ yahoo.com]
 *
 * @param string $pwd ?
 * @param string $data ?
 * @param string $case ?
 * @return string
 * @todo Finish documenting this function
 */
function endecrypt ($pwd, $data, $case) {

    if ($case == 'de') {
        $data = urldecode($data);
    }

    $key[] = '';
    $box[] = '';
    $temp_swap = '';
    $pwd_length = 0;

    $pwd_length = strlen($pwd);

    for ($i = 0; $i <= 255; $i++) {
        $key[$i] = ord(substr($pwd, ($i % $pwd_length), 1));
        $box[$i] = $i;
    }

    $x = 0;

    for ($i = 0; $i <= 255; $i++) {
        $x = ($x + $box[$i] + $key[$i]) % 256;
        $temp_swap = $box[$i];
        $box[$i] = $box[$x];
        $box[$x] = $temp_swap;
    }

    $temp = '';
    $k = '';

    $cipherby = '';
    $cipher = '';

    $a = 0;
    $j = 0;

    for ($i = 0; $i < strlen($data); $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $temp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $temp;
        $k = $box[(($box[$a] + $box[$j]) % 256)];
        $cipherby = ord(substr($data, $i, 1)) ^ $k;
        $cipher .= chr($cipherby);
    }

    if ($case == 'de') {
        $cipher = urldecode(urlencode($cipher));
    } else {
        $cipher = urlencode($cipher);
    }

    return $cipher;
}




function validate_internal_user_password(&$user, $password) 
{
    global $CFG;
	//pool md5: b10a8c0bede9eb4ea771b04db3149f28
	//pool md5  b10a8c0bede9eb4ea771b04db3149f28
    if (!isset($CFG->passwordsaltmain)) {
        $CFG->passwordsaltmain = '';
    }

    $validated = false;

    // get password original encoding in case it was not updated to unicode yet
    $textlib = textlib_get_instance();
    $convpassword = $textlib->convert($password, 'utf-8', get_string('oldcharset'));

    if ($user->password == md5($password.$CFG->passwordsaltmain) or $user->password == md5($password)
        or $user->password == md5($convpassword.$CFG->passwordsaltmain) or $user->password == md5($convpassword)) {
        $validated = true;
    } else {
        for ($i=1; $i<=20; $i++) { //20 alternative salts should be enough, right?
            $alt = 'passwordsaltalt'.$i;
            if (!empty($CFG->$alt)) {
                if ($user->password == md5($password.$CFG->$alt) or $user->password == md5($convpassword.$CFG->$alt)) {
                    $validated = true;
                    break;
                }
            }
        }
    }

    if ($validated) {
        // force update of password hash using latest main password salt and encoding if needed
        update_internal_user_password($user, $password);
    }

    return $validated;
}


 class generic  
 {  
   
     var $vars;  
   
     //constructor  
     function generic() {  }  
   
     // gets a value  
     function get($var)  
     {  
         return $this->vars[$var];  
     }  
   
     // sets a key => value  
     function set($key,$value)  
     {  
         $this->vars[$key] = $value;  
     }  
   
     // loads a key => value array into the class  
     function load($array)  
     {  
         if(is_array($array))  
         {  
             foreach($array as $key=>$value)  
             {  
                 $this->vars[$key] = $value;  
             }  
         }  
     }  
   
     // empties a specified setting or all of them  
     function unload($vars = '')  
     {  
         if($vars)  
         {  
             if(is_array($vars))  
             {  
                 foreach($vars as $var)  
                 {  
                     unset($this->vars[$var]);  
                 }  
             }  
             else  
             {  
                 unset($this->vars[$vars]);  
             }  
         }  
         else  
         {  
             $this->vars = array();  
         }  
     }  
   
     /* return the object as an array */  
     function get_all()  
     {  
         return $this->vars;  
     }  
   
 } 


function ArrayToObject($arrIn)
{
	$obj=new generic();
	foreach($arrIn as $k=>$v)
	{
		$obj->set($k,$v);
	}
	return $obj;
}


function moodlelogin($username, $password) 
{
    global $CFG;

	$userarr=GenericDBLookup(our_db, "mdl_user", "username", $username, "");
    if (is_array($userarr)) 
	{
		$user= ArrayToObject($userarr);
       // $auth = empty($user->get("auth")) ? 'manual' : $user->get("auth");  // use manual if auth not set
        if ($auth=='nologin' or !is_enabled_auth($auth)) 
		{
            //add_to_log(0, 'login', 'error', 'index.php', $username);
           // error_log('[client '.$_SERVER['REMOTE_ADDR']."]  $CFG->wwwroot  Disabled Login:  $username  ".$_SERVER['HTTP_USER_AGENT']);
            return false;
        }
        if (!empty($user->deleted)) 
		{
           // add_to_log(0, 'login', 'error', 'index.php', $username);
           // error_log('[client '.$_SERVER['REMOTE_ADDR']."]  $CFG->wwwroot  Deleted Login:  $username  ".$_SERVER['HTTP_USER_AGENT']);
            return false;
        }
        $auths = array($auth);

    } 
	else 
	{
        $auths = $authsenabled;
        $user = new object();
        $user->id = 0;     // User does not exist
    }

 
	
    // failed if all the plugins have failed
    //add_to_log(0, 'login', 'error', 'index.php', $username);

    return false;
}


function ShowGraduates($courseid)
{
	
	GLOBAL $strcustomurlroot;
	
	$out="";
	$strPHP=  $strcustomurlroot . "../moodle/user/view.php?id=";
	//$out.="<a href=\"" . $strPHP . "" . $teacherrecord["userid"] . "\">" .  $teacherrecord["firstname"] . " " . $teacherrecord["lastname"] . "</a><br/>";
	$strFieldsWeWantToSee=" u.id, username, u.firstname, u.lastname, u.zip, date_achieved, course_id, shortname, fullname, employer_name ";
	$strSQL="SELECT " . $strFieldsWeWantToSee. "  FROM " . our_db . ".mdl_user u JOIN " . our_db . ".accomplishment a on u.id=a.user_id JOIN " . our_db . ".mdl_course c on a.course_id=c.id JOIN " . our_db . ".xcart_customers cust ON cust.login=binary(u.username)   LEFT JOIN " . our_db . ".employer e on cust.employer_id=e.employer_id ";
	//echo $strSQL;
	if($courseid!="")
	{
		$strSQL.=" where a.course_id=" . intval($courseid);
	}

	$strSQL.=" ORDER BY u.lastname, u.firstname";
	$strViewLink="<a href=\"user_modify.php?user=<replace/>&usertype=*\">view</a>";
	//echo $strSQL;
	//GenericRSDisplay($strDatabase, $strPHP,$strLabel, $strSQL, $truncate, $intWidth, $strLinkFieldName="", $strLinkIDName="", $strAdditionalLink="", $strSuppressFields="", $bwlSuppressHeader=false, $bwlPrettyUpFieldNames=true, $intFieldLimit=10)
	$out.=GenericRSDisplay($strDatabase, $strPHP,"",$strSQL, true, "100%", "username", "username", $strViewLink, "" , false, true, 12);
	return $out;
}

function UpdateGrades($userid)
{
	$sql=conDB();
	
	//plan of attack:
	//read mdl_lesson_grades
	//if there is a record there for this user, 
	//look to see if we made it into an accomplishment
	//if not, look up from the raw data and write a grade to accomplishment
	//if so, read the grade from accomplishment
	
	
	$strSQL="SELECT * FROM " . our_db . ".mdl_lesson_grades g JOIN mdl_lesson l on g.lessonid=l.id WHERE userid='" .$userid  . "'";
	$records = $sql->query($strSQL);
	foreach($records as $record)
	{
		$courseid=$record["courseid"];
		
		$strSQL="SELECT * FROM " . our_db . ".accomplishment WHERE user_id='" .$userid . "' AND course_id='" . $course_id  ."'";
		$arecords = $sql->query($strSQL);
		if(count($arecords)>0)
		{
			$arecord=$arecord[0];
			$grade=$arecord["grade"];
		
		}
		else
		{
			$strSQL="SELECT SUM(correct) AS totalcorrect, COUNT(correct) AS total, 100*SUM(correct)/COUNT(correct) AS grade, g.lessonid, g.*, p.*  FROM " . our_db . ".mdl_lesson_attempts g  JOIN " . our_db . ".mdl_lesson l on g.lessonid=l.id JOIN mdl_lesson_grades gr ON gr.lessonid=g.lessonid  JOIN " . our_db . ".mdl_course c on l.course=c.id JOIN " . our_db . ".xcart_products p ON p.mdl_course_id=l.course where g.userid='" . $userid . "' and retry=0 and c.id='" . $courseid . "' group by lessonid ";
			$grecords = $sql->query($strSQL);
			if(count($grecords)>0)
			{
				$grecord=$grecords[0];
				$grade=$grecord["grade"];
				$completed=date("Y-m-d H:i:s", $grecord["completed"]);
				$productid =$grecord["productid"];

				$arrDescribedValuePairs=Array("user_id"=>$USER->id, "course_id"=>$courseid );
				$arrAlteredValuePairs=Array("grade"=>$grade, "date_achieved"=>$completed);
				UpdateOrInsert(our_db, "accomplishment", $arrDescribedValuePairs, $arrAlteredValuePairs);
				

			}
			
	
		}
	}

}



function ShowGrades($userid)
{
	UpdateGrades($userid);
 	GLOBAL $strcustomurlroot;
	$failmaxpercentage="79.99999";
	$out="";
	$strCertLogic="$" . "val='<value/>';\n" . '$' . "arrCert=explode('-',  $" . "val);\n if(" . '$' . "arrCert[1]>" . $failmaxpercentage . ")\n{" . '$' . "encoded=urlencode(addletters(" . '$' . "arrCert[0],'perdle'));\n " . '$value=\"<a href=cert.php?courseid=' .   '$' . "encoded . '\">download</a>';}else{" . '$' . "value='not yet';\n}";
	
	$strFieldsWeWantToSee="a.course_id, a.date_achieved as 'attempt' ,  a.grade as 'grade percentage', p.product as 'course name' , concat(a.course_id, '-',  a.grade) as 'certificate'  ";
	$strSQL="SELECT " . $strFieldsWeWantToSee ." FROM " . our_db . ".accomplishment a  JOIN " . our_db . ".xcart_products p ON p.mdl_course_id=a.course_id WHERE a.user_id='" . $userid . "'";
	echo $strSQL;
	$out.=GenericRSDisplay($strDatabase, $strPHP,"",$strSQL, false, "100%", "username", "course", $strViewLink, "product_id" , false, true, 12,"perdle", Array("attempt"=>"  date('Y-m-d H:i:s', <value/>);", "certificate"=>$strCertLogic));
	$out=ShowAccomplishments($userid);
	return $out;

}



function OldShowGrades($userid)
{
	//function  GenericRSDisplay($strDatabase, $strPHP,$strLabel, $strSQL, $truncate, $intWidth, $strLinkFieldName="", $strLinkIDName="", $strAdditionalLink="", $strSuppressFields="", $bwlSuppressHeader=false, $bwlPrettyUpFieldNames=true, $intFieldLimit=10, $idencryptionstring="", $arrPostProcessing="")
	GLOBAL $strcustomurlroot;
	$failmaxpercentage="79.99999";
	$out="";
 //addletters($arrCert[0],'perdle') 
	$strCertLogic='$' . "arrCert=explode('-', '<value/>'); if(" . '$' . "arrCert[1]>" . $failmaxpercentage . "){" . '$' . "encoded=urlencode(addletters(" . '$' . "arrCert[0],'perdle')); " . '$' . "value='<a href=cert.php?courseid=' . " . '$' . "encoded. '>download</a>';}else{" . '$' . "value='not yet';}";
	$strPHP=  $strcustomurlroot . "../moodle/user/view.php?id=";
	//$out.="<a href=\"" . $strPHP . "" . $teacherrecord["userid"] . "\">" .  $teacherrecord["firstname"] . " " . $teacherrecord["lastname"] . "</a><br/>";
//concat(c.id, "-",  g.grade) as 'certificate' , 
	$strFieldsWeWantToSee="c.id, g.completed as 'attempt' ,  g.grade as 'grade percentage', c.fullname as 'course name' , concat(c.id, '-',  g.grade) as 'certificate'  ";
 	
	
	$strSQL="SELECT " . $strFieldsWeWantToSee ." FROM " . our_db . ".mdl_lesson_grades g JOIN mdl_lesson l on g.lessonid=l.id JOIN mdl_course c on l.course=c.id JOIN xcart_products p ON p.mdl_course_id=l.course WHERE g.userid='" . $userid . "'";
	//echo $strSQL;
	$out.=GenericRSDisplay($strDatabase, $strPHP,"",$strSQL, false, "100%", "username", "course", $strViewLink, "id" , false, true, 12,"perdle", Array("attempt"=>"  date('Y-m-d H:i:s', <value/>);", "certificate"=>$strCertLogic));
	return $out;
}

function ShowAccomplishments($userid)
{
	UpdateGrades($userid);
	GLOBAL $strcustomurlroot;
	$failmaxpercentage="79.99999";
	$out="";
	$strPHP=  $strcustomurlroot . "../moodle/user/view.php?id=";
	//$out.="<a href=\"" . $strPHP . "" . $teacherrecord["userid"] . "\">" .  $teacherrecord["firstname"] . " " . $teacherrecord["lastname"] . "</a><br/>";
	$strFieldsWeWantToSee=" accomplishment_id,    date_achieved,   shortname, fullname   ";
	$strSQL="SELECT " . $strFieldsWeWantToSee. "  FROM " . our_db . ".mdl_user u JOIN " . our_db . ".accomplishment a on u.id=a.user_id JOIN " . our_db . ".mdl_course c on a.course_id=c.id JOIN " . our_db . ".xcart_customers cust ON cust.login=binary(u.username)   LEFT JOIN " . our_db . ".employer e on cust.employer_id=e.employer_id   ";
	
	 
	$strSQL.=" where a.user_id=" . intval($userid) . " AND grade>" . $failmaxpercentage;
	 
	//echo $strSQL;
	$strSQL.=" ORDER BY u.lastname, u.firstname";
	$strViewLink="<a href=\"cert.php?accomplishment_id=" . random_string(2) . "<replace/>\">get certificate</a>";
	//echo $strSQL;
	//GenericRSDisplay($strDatabase, $strPHP,$strLabel, $strSQL, $truncate, $intWidth, $strLinkFieldName="", $strLinkIDName="", $strAdditionalLink="", $strSuppressFields="", $bwlSuppressHeader=false, $bwlPrettyUpFieldNames=true, $intFieldLimit=10)
//GenericRSDisplay($strDatabase, $strPHP,$strLabel, $strSQL, $truncate, $intWidth, $strLinkFieldName="", $strLinkIDName="", $strAdditionalLink="", $strSuppressFields="", $bwlSuppressHeader=false, $bwlPrettyUpFieldNames=true, $intFieldLimit=10, $crypt)
	$out.=GenericRSDisplay($strDatabase, $strPHP,"",$strSQL, true, "100%", "username", "accomplishment_id", $strViewLink, "accomplishment_id" , true, true, 12,"perdle");
	return $out;
}

function emailHtml($from, $subject, $message, $to) 
{
	$host = "localhost";
	$username = "";
	$password = "";
	
	$headers = array ('MIME-Version' => "1.0", 'Content-type' => "text/plain;", 'From' => $from, 'To' => $to, 'Subject' => $subject);
	
	$smtp = Mail::factory('smtp', array ('host' => $host, 'auth' => false));
	
	$mail = $smtp->send($to, $headers, $message);
	//if (PEAR::isError($mail))
	//return 0;
	//else
	//return 1;
}

 
	
logmein();


 ?>