<?

include("tf_functions_core.php");


function SimpleMoodleLogin($username, $password)
{
	$random=random_string(10);
	
	$sesskeyname="moodle/moodledata/sessions/sess_" . random_string(26);
	$strSessionPart='SESSION|O:6:"object":3:{s:12:"session_test";s:10:"yru291kVLt";s:10:"logincount";i:0;s:12:"justloggedin";b:1;}';
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
		$content=$strSessionPart . $strUserPre . $trimmedsud  ;
		$handle=fopen ($sesskeyname, "w");
		fwrite($handle, $content);
		fclose($handle);  
		echo $trimmedsud;

		
		//setcookie("MoodleSessionTest", random_string(10), mktime(). time()+60*60*24*30, '/');
	
	}




}

 











//SESSION|O:6:"object
$stank='SESSION|O:6:"object":3:{s:12:"session_test";s:10:"yru291kVLt";s:10:"logincount";i:0;s:12:"justloggedin";b:1;}USER|O:8:"stdClass":67:{s:2:"id";s:3:"137";s:4:"auth";s:6:"manual";s:9:"confirmed";s:1:"1";s:12:"policyagreed";s:1:"1";s:7:"deleted";s:1:"0";s:10:"mnethostid";s:1:"1";s:8:"username";s:4:"omar";s:8:"password";s:32:"b10a8c0bede9eb4ea771b04db3149f28";s:8:"idnumber";s:0:"";s:9:"firstname";s:4:"Omar";s:8:"lastname";s:6:"Little";s:5:"email";s:18:"bigfun@verizon.net";s:9:"emailstop";s:1:"0";s:3:"icq";s:0:"";s:5:"skype";s:0:"";s:5:"yahoo";s:0:"";s:3:"aim";s:0:"";s:3:"msn";s:0:"";s:6:"phone1";s:0:"";s:6:"phone2";s:0:"";s:11:"institution";s:0:"";s:10:"department";s:0:"";s:7:"address";s:32:"23 Martin Luther King Blvd North";s:4:"city";s:9:"Baltimore";s:7:"country";s:0:"";s:4:"lang";s:2:"en";s:5:"theme";s:0:"";s:8:"timezone";s:2:"99";s:11:"firstaccess";s:1:"0";s:10:"lastaccess";s:10:"1238187354";s:9:"lastlogin";s:10:"1238187354";s:12:"currentlogin";i:1238187954;s:6:"lastip";s:14:"129.44.114.163";s:6:"secret";s:0:"";s:7:"picture";s:1:"0";s:3:"url";s:0:"";s:11:"description";N;s:10:"mailformat";s:1:"1";s:10:"maildigest";s:1:"0";s:11:"maildisplay";s:1:"2";s:10:"htmleditor";s:1:"1";s:4:"ajax";s:1:"1";s:13:"autosubscribe";s:1:"1";s:11:"trackforums";s:1:"0";s:12:"timemodified";s:1:"0";s:12:"trustbitmask";s:1:"0";s:8:"imagealt";N;s:12:"screenreader";s:1:"0";s:10:"state_name";s:8:"Maryland";s:3:"zip";s:5:"21121";s:5:"birth";s:19:"1972-03-06 00:00:00";s:8:"address1";N;s:8:"address2";s:0:"";s:5:"phone";s:0:"";s:9:"cellphone";N;s:6:"gender";s:1:"1";s:9:"reg_phase";s:1:"1";s:11:"employer_id";N;s:13:"employer_name";s:23:"Stick \'Em Up Industries";s:7:"display";a:1:{i:447;s:1:"0";}s:10:"preference";a:0:{}s:16:"lastcourseaccess";a:1:{i:447;s:10:"1236804562";}s:19:"currentcourseaccess";a:0:{}s:11:"groupmember";a:0:{}s:7:"sesskey";s:10:"0zArg7b1wY";s:9:"sessionIP";s:32:"073f5ce37daddd2d14a4ebfe64578645";s:6:"access";a:5:{s:2:"ra";a:2:{s:8:"/1/3/677";a:1:{i:0;s:1:"5";}s:2:"/1";a:1:{i:0;s:1:"7";}}s:4:"rdef";a:3:{s:4:"/1:5";a:39:{s:13:"mod/chat:chat";s:1:"1";s:20:"mod/glossary:comment";s:1:"1";s:16:"moodle/blog:view";s:1:"1";s:16:"mod/chat:readlog";s:1:"1";s:18:"mod/glossary:write";s:1:"1";s:18:"moodle/course:view";s:1:"1";s:17:"mod/choice:choose";s:1:"1";s:18:"mod/hotpot:attempt";s:1:"1";s:30:"moodle/course:viewparticipants";s:1:"1";s:16:"mod/data:comment";s:1:"1";s:20:"mod/lams:participate";s:1:"1";s:24:"moodle/course:viewscales";s:1:"1";s:18:"mod/data:viewentry";s:1:"1";s:16:"mod/quiz:attempt";s:1:"1";s:17:"moodle/grade:view";s:1:"1";s:19:"mod/data:writeentry";s:1:"1";s:13:"mod/quiz:view";s:1:"1";s:21:"moodle/legacy:student";s:1:"1";s:26:"mod/forum:createattachment";s:1:"1";s:19:"mod/scorm:savetrack";s:1:"1";s:25:"moodle/user:readuserblogs";s:1:"1";s:23:"mod/forum:deleteownpost";s:1:"1";s:18:"mod/scorm:skipview";s:1:"1";s:25:"moodle/user:readuserposts";s:1:"1";s:30:"mod/forum:initialsubscriptions";s:1:"1";s:20:"mod/scorm:viewscores";s:1:"1";s:23:"moodle/user:viewdetails";s:1:"1";s:25:"gradereport/overview:view";s:1:"1";s:19:"mod/forum:replypost";s:1:"1";s:22:"mod/survey:participate";s:1:"1";s:21:"gradereport/user:view";s:1:"1";s:25:"mod/forum:startdiscussion";s:1:"1";s:20:"mod/wiki:participate";s:1:"1";s:21:"mod/assignment:submit";s:1:"1";s:24:"mod/forum:viewdiscussion";s:1:"1";s:24:"mod/workshop:participate";s:1:"1";s:19:"mod/assignment:view";s:1:"1";s:20:"mod/forum:viewrating";s:1:"1";s:17:"moodle/block:view";s:1:"1";}s:4:"/1:7";a:11:{s:23:"moodle/site:sendmessage";s:1:"1";s:17:"moodle/tag:create";s:1:"1";s:15:"moodle/tag:edit";s:1:"1";s:29:"moodle/user:changeownpassword";s:1:"1";s:26:"moodle/user:editownprofile";s:1:"1";s:17:"moodle/block:view";s:1:"1";s:18:"moodle/blog:create";s:1:"1";s:16:"moodle/blog:view";s:1:"1";s:32:"moodle/calendar:manageownentries";s:1:"1";s:18:"moodle/legacy:user";s:1:"1";s:22:"moodle/my:manageblocks";s:1:"1";}s:6:"/1/2:7";a:1:{s:24:"mod/forum:viewdiscussion";s:1:"1";}}s:6:"loaded";a:0:{}s:2:"dr";s:1:"7";s:4:"time";i:1238187954;}}';











$stank='SESSION|O:6:"object":3:{s:12:"session_test";s:10:"yru291kVLt";s:10:"logincount";i:0;s:12:"justloggedin";b:1;}USER|O:8:"stdClass":67:{s:2:"id";s:3:"137";s:4:"auth";s:6:"manual";s:9:"confirmed";s:1:"1";s:12:"policyagreed";s:1:"1";s:7:"deleted";s:1:"0";s:10:"mnethostid";s:1:"1";s:8:"username";s:4:"omar";s:8:"password";s:32:"b10a8c0bede9eb4ea771b04db3149f28";s:8:"idnumber";s:0:"";s:9:"firstname";s:4:"Omar";s:8:"lastname";s:6:"Little";s:5:"email";s:18:"bigfun@verizon.net";s:9:"emailstop";s:1:"0";s:3:"icq";s:0:"";s:5:"skype";s:0:"";s:5:"yahoo";s:0:"";s:3:"aim";s:0:"";s:3:"msn";s:0:"";s:6:"phone1";s:0:"";s:6:"phone2";s:0:"";s:11:"institution";s:0:"";s:10:"department";s:0:"";s:7:"address";s:32:"23 Martin Luther King Blvd North";s:4:"city";s:9:"Baltimore";s:7:"country";s:0:"";s:4:"lang";s:2:"en";s:5:"theme";s:0:"";s:8:"timezone";s:2:"99";s:11:"firstaccess";s:1:"0";s:10:"lastaccess";s:10:"1238197652";s:9:"lastlogin";s:10:"1238196987";s:12:"currentlogin";s:10:"1238197652";s:6:"lastip";s:14:"129.44.114.163";s:6:"secret";s:0:"";s:7:"picture";s:1:"0";s:3:"url";s:0:"";s:11:"description";N;s:10:"mailformat";s:1:"1";s:10:"maildigest";s:1:"0";s:11:"maildisplay";s:1:"2";s:10:"htmleditor";s:1:"1";s:4:"ajax";s:1:"1";s:13:"autosubscribe";s:1:"1";s:11:"trackforums";s:1:"0";s:12:"timemodified";s:1:"0";s:12:"trustbitmask";s:1:"0";s:8:"imagealt";N;s:12:"screenreader";s:1:"0";s:10:"state_name";s:8:"Maryland";s:3:"zip";s:5:"21121";s:5:"birth";s:19:"1972-03-06 00:00:00";s:8:"address1";N;s:8:"address2";s:0:"";s:5:"phone";s:0:"";s:9:"cellphone";N;s:6:"gender";s:1:"1";s:9:"reg_phase";s:1:"1";s:11:"employer_id";N;s:13:"employer_name";s:23:"Stick \'Em Up Industries";;s:7:"display";a:1:{i:447;s:1:"0";}s:10:"preference";a:0:{}s:16:"lastcourseaccess";a:1:{i:447;s:10:"1236804562";}s:19:"currentcourseaccess";a:0:{}s:11:"groupmember";a:0:{}s:7:"sesskey";s:10:"0zArg7b1wY";s:9:"sessionIP";s:32:"073f5ce37daddd2d14a4ebfe64578645";s:6:"access";a:5:{s:2:"ra";a:2:{s:8:"/1/3/677";a:1:{i:0;s:1:"5";}s:2:"/1";a:1:{i:0;s:1:"7";}}s:4:"rdef";a:3:{s:4:"/1:5";a:39:{s:13:"mod/chat:chat";s:1:"1";s:20:"mod/glossary:comment";s:1:"1";s:16:"moodle/blog:view";s:1:"1";s:16:"mod/chat:readlog";s:1:"1";s:18:"mod/glossary:write";s:1:"1";s:18:"moodle/course:view";s:1:"1";s:17:"mod/choice:choose";s:1:"1";s:18:"mod/hotpot:attempt";s:1:"1";s:30:"moodle/course:viewparticipants";s:1:"1";s:16:"mod/data:comment";s:1:"1";s:20:"mod/lams:participate";s:1:"1";s:24:"moodle/course:viewscales";s:1:"1";s:18:"mod/data:viewentry";s:1:"1";s:16:"mod/quiz:attempt";s:1:"1";s:17:"moodle/grade:view";s:1:"1";s:19:"mod/data:writeentry";s:1:"1";s:13:"mod/quiz:view";s:1:"1";s:21:"moodle/legacy:student";s:1:"1";s:26:"mod/forum:createattachment";s:1:"1";s:19:"mod/scorm:savetrack";s:1:"1";s:25:"moodle/user:readuserblogs";s:1:"1";s:23:"mod/forum:deleteownpost";s:1:"1";s:18:"mod/scorm:skipview";s:1:"1";s:25:"moodle/user:readuserposts";s:1:"1";s:30:"mod/forum:initialsubscriptions";s:1:"1";s:20:"mod/scorm:viewscores";s:1:"1";s:23:"moodle/user:viewdetails";s:1:"1";s:25:"gradereport/overview:view";s:1:"1";s:19:"mod/forum:replypost";s:1:"1";s:22:"mod/survey:participate";s:1:"1";s:21:"gradereport/user:view";s:1:"1";s:25:"mod/forum:startdiscussion";s:1:"1";s:20:"mod/wiki:participate";s:1:"1";s:21:"mod/assignment:submit";s:1:"1";s:24:"mod/forum:viewdiscussion";s:1:"1";s:24:"mod/workshop:participate";s:1:"1";s:19:"mod/assignment:view";s:1:"1";s:20:"mod/forum:viewrating";s:1:"1";s:17:"moodle/block:view";s:1:"1";}s:4:"/1:7";a:11:{s:23:"moodle/site:sendmessage";s:1:"1";s:17:"moodle/tag:create";s:1:"1";s:15:"moodle/tag:edit";s:1:"1";s:29:"moodle/user:changeownpassword";s:1:"1";s:26:"moodle/user:editownprofile";s:1:"1";s:17:"moodle/block:view";s:1:"1";s:18:"moodle/blog:create";s:1:"1";s:16:"moodle/blog:view";s:1:"1";s:32:"moodle/calendar:manageownentries";s:1:"1";s:18:"moodle/legacy:user";s:1:"1";s:22:"moodle/my:manageblocks";s:1:"1";}s:6:"/1/2:7";a:1:{s:24:"mod/forum:viewdiscussion";s:1:"1";}}s:6:"loaded";a:0:{}s:2:"dr";s:1:"7";s:4:"time";i:1238187954;}}';


$blarnk=unserialize($stank);
foreach($blarnk as $k=>$v)
{
	//echo $k . " " . $v . "<br>";
	
}
?>