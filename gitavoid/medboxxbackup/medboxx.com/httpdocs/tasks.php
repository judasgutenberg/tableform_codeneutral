<body bgcolor="ccffff" style="font-family:courier;font-size: 9px;">
<?php
$strPathPre="";
 
include($strPathPre . "tf_constants.php");
include($strPathPre . "tf_functions_core.php");
include($strPathPre . "tf_functions_editor.php");
include($strPathPre . "tf_functions_frontend_db.php");
include($strPathPre . "tf_functions_odbc.php");
include($strPathPre . "tf_functions_backup.php");
include($strPathPre . "calendar_functions.php");
$errorlevel=error_reporting(0);
$intDoNow=$_REQUEST["donow"];
$makecall=$_REQUEST["makecall"];
$message=$_REQUEST["message"];
$voice=gracefuldecay($_REQUEST["voice"], "William");
$frequency=gracefuldecay($_REQUEST["frequency"], "8");
$strVoiceConfig="<voice name='"  . $voice . "-" . $frequency . "kHz'>";
$defaultmessage="Hello gus!  Have fun today";
set_time_limit(22);
error_reporting($errorlevel);
 
$strDatabase=our_db;
$sql=conDB();

if(!TableExists($strDatabase,"server_task"))
{
	$strSQL="CREATE TABLE `server_task` (
	`server_task_id` int(11) NOT NULL auto_increment,
	`task_type` int(11) default NULL,
	`datetime_done` datetime default NULL,
	PRIMARY KEY (`server_task_id`)
	) ";
	$records = $sql->query($strSQL, true, $strDatabase);
}


//generic for all tasks:
//---------------------
$nowhour=intval(date("G", time()));
$nowSQLtime=date("Y-m-d H:i:s");
//---------------------

//the task_type for a send email  rebuild is 2
//task 2:
$tasktype=2;
$hourpause=.01;
if(1==1 || $intDoNow==$tasktype) /// i DO THIS ONE //don't worry about the hour
{
	$strSQL="SELECT * FROM " .  $strDatabase. ".server_task WHERE task_type=" . $tasktype . " ORDER BY datetime_done DESC LIMIT 0,1";
	$records = $sql->query($strSQL);
	$record=$records[0];
	$datetime_done=$record["datetime_done"];
	$dtmDone=strtotime($datetime_done);
	$diffinhours=(time()-$dtmDone)/3600;
	echo "<HR>";
	echo "tasktype:" . $tasktype . "(send email) diff in hours:" .  $diffinhours . "* * hourpause: " . $hourpause;
	if($diffinhours>$hourpause || $intDoNow==$tasktype)
	{
		UpdateOrInsert($strDatabase, "server_task", "", Array("task_type"=>$tasktype, "datetime_done"=> date("Y-m-d H:i:s")));
		//DO ACTUAL TASK
		$strSQL="SELECT c.phone_call_id, o.office_name, c.time_to_start, c.last_attempt, c.email_content, cl.email as tomail, o.email as frommail  FROM phone_call c JOIN client cl ON c.callee_id=cl.client_id JOIN office o ON c.office_id=o.office_id  WHERE email_only =1 AND email_sent=0 AND time_to_start >'".$nowSQLtime."'";
		//logcollection(true, "", "*" .  $strSQL . "*");
		$pcrecords = $sql->query($strSQL, true,  $strDatabase);
		foreach($pcrecords as $pcrecord)
		{
			$phone_call_id=$pcrecord["phone_call_id"];
			$email_content=$pcrecord["email_content"];
			$office_name=$pcrecord["office_name"];
			$to=$pcrecord["tomail"];
			$from=$pcrecord["frommail"];
			$last_attempt=$pcrecord["last_attempt"];
			$time_to_start=$pcrecord["time_to_start"];
			$headers = "From: " . $office_name  . " <". $from . ">";
			$arrCol=Array();
			$arrCol['time_to_start']=$time_to_start;
			$arrCol['nowSQLtime']=$nowSQLtime;
			$arrCol['to']=$to;
			$arrCol['office_name']=$office_name;
			$arrCol['email_content']=$email_content;
			$arrCol['headers']=$headers;
			//logcollection(true, $arrCol,  "mailer");
			$arr_to_log=array_merge($arrCol, $pcrecord);
			$arr_to_log["time_to_start"]=$time_to_start;
			$arr_to_log["dttime_to_start"]=strtotime($time_to_start);
			$arr_to_log["dtnowsqltime"]=strtotime($nowSQLtime)+24*60*60;
			//logcollection(true, $arr_to_log, "possiblemail", "");
			if(strtotime($time_to_start)<strtotime($nowSQLtime)+24*60*60)
			{
				//logcollection(true,  $arr_to_log, "actualmail", "");
				mail($to, "Reminder from " .  $office_name,  $email_content, $headers);
				UpdateOrInsert($strDatabase, "phone_call", Array("phone_call_id"=>$phone_call_id), Array("email_sent"=>1));
			}
		}
		//END OF ACTUAL TASK
		 
	}
}

//make phone calls!!
//task 3:
$tasktype=3;
$hourpause=.01;
if(1==1 || $intDoNow==$tasktype) /// i DO THIS ONE //don't worry about the hour
{
	$strSQL="SELECT * FROM " .  $strDatabase. ".server_task WHERE task_type=" . $tasktype . " ORDER BY datetime_done DESC LIMIT 0,1";
	$records = $sql->query($strSQL);
	$record=$records[0];
	$datetime_done=$record["datetime_done"];
	$dtmDone=strtotime($datetime_done);
	$diffinhours=(time()-$dtmDone)/3600;
	echo "<HR>";
	echo "tasktype:" . $tasktype . "(make phone calls) diff in hours:" .  $diffinhours . "* * hourpause: " . $hourpause;
	
	if($diffinhours>$hourpause|| $intDoNow==$tasktype)
	{
		//a:1:{s:4:"data";s:82:"{"tag":"medboxx_box.20","disposition":"ANSWERED","vm":0,"duration":17}";}
		UpdateOrInsert($strDatabase, "server_task", "", Array("task_type"=>$tasktype, "datetime_done"=> date("Y-m-d H:i:s")));
		//DO ACTUAL TASK
		$strSQL="SELECT phonecall_status_id, phone_call_id, phone_number,call_content, time_to_start
		FROM phone_call p    
		WHERE phonecall_status_id=1
		AND attempt_count < 4
		AND email_only =0 
		AND phonecall_only =1  
		AND attempt_count<4
		AND time_to_start < '" . $nowSQLtime . "'";
		
		$records = $sql->query($strSQL);
		if(count($records)>0)
		{
			//logcollection(true, $strSQL, "phonesql");
		}
		echo mysql_error() . "<BR>";
		$strJSONdata="";
		if($makecall=="")
		{
			foreach($records as $record)
			{
				//logcollection(true, $record, "maybephone");
				$phone_number=$record['phone_number'];
				$call_content=$record['call_content'];
				$phone_call_id=$record['phone_call_id'];	
				$time_to_start=$record['time_to_start'];	
				echo $phone_number . "<br>" . $call_content . "<p>";
				$strJSONdata.='{"tag":"' . our_db . "." . $phone_call_id . '","phone":"' . str_replace("\"", "", $phone_number)  . '","tts":"' .  $strVoiceConfig. str_replace("\"", "", $call_content) . '</voice>"},';
			
				//what i would do if i assumed the call made it:
				$sql->query("UPDATE phone_call SET phonecall_status_id='2', last_attempt=now(),attempt_count=attempt_count+1 WHERE phone_call_id='" . $phone_call_id ."'");
				echo mysql_error() . "<BR>";
			}
		}
		else
		{
			$strJSONdata.='{"tag":"tester","phone":"' . str_replace("\"", "", $makecall)  . '","tts":"' . $strVoiceConfig . str_replace("\"", "", gracefuldecay($message, $defaultmessage)) . '</voice>"},';
			
		}
		$strJSONdata= RemoveEndCharactersIfMatch($strJSONdata, ",");
		echo "jsondata: " . $strJSONdata;
		//logcollection(true, json_decode($strJSONdata), "jsonphonedata");
		if($strJSONdata!="")
		{
	 		$requestdata='json={"version":1,"data":[' . $strJSONdata . ']}';
			echo "requestdata:" . $requestdata ."<BR>";
			//need to turn this on to go live
			//$handle=fopen($url, "r");
			//$contents = file_get_contents($url);
			//212 461 6016
			//http://medboxx.com/tasks.php?donow=3&makecall=18453401090&message=Hello+Gus,+this+is+the+office+of+Peterson+medical+remding+you+of+your+appointment+on+tuesday+June+22+at+10+AM
//http://medboxx.com/tasks.php?donow=3&makecall=18452465599&message=Hello,+this+is+the+office+of+Peterson+medical+remding+you+of+your+appointment+for+tuesday+June+22+at+10+AM
//http://medboxx.com/tasks.php?donow=3&makecall=19176504575&message=Hello,+this+is+the+office+of+Peterson+medical+remding+you+of+your+appointment+for+tuesday+June+22+at+10+AM
			$server= "apps.ziggoo.net";
			$path = "/automatika/index.php";
			//logcollection(true,  $requestdata , "actualphone");
			$ret =httpSocketConnection($server, "POST", $path, $requestdata);
			
			
			 
			echo "returned: " . $ret . "<BR>";
			logcollection(true,  $requestdata  . "|" . $ret, "actualphone");
		}
 
		//END OF ACTUAL TASK
		 
	}
}





//task 6: delete old server tasks in the server_task table. don't need them more than five or six days
$tasktype=6;
$hourpause=52;
$strSQL="SELECT * FROM " .  $strDatabase . ".server_task WHERE task_type=" . $tasktype . " ORDER BY datetime_done DESC LIMIT 0,1";
$records = $sql->query($strSQL);
$record=$records[0];
$datetime_done=$record["datetime_done"];
$dtmDone=strtotime($datetime_done);
$diffinhours=( time()-$dtmDone)/3600;
echo "<hr>tasktype: " . $tasktype . "(Delete Old Tasks) " . "diffinhours:" . $diffinhours. "<BR>";
if($diffinhours>$hourpause   || $intDoNow==$tasktype)//want to do this even later
{
	UpdateOrInsert( $strDatabase, "server_task", "", Array("task_type"=>$tasktype, "datetime_done"=> date("Y-m-d H:i:s")), true, false, true);
	//DO ACTUAL TASK
 	//things older than eight days in the server_task table have to go
	$strSQL="DELETE FROM " . our_db . ".server_task WHERE datetime_done<'" . date("Y-m-d H:i:s" , time() - 500000). "'";
	$records = $sql->query($strSQL);
 
	//END OF ACTUAL TASK
 
}






//reset phonecalls with no status updates after an hour!!
//task 7:
$tasktype=7;
$hourpause=.01;
if(1==1 || $intDoNow==$tasktype) /// i DO THIS ONE //don't worry about the hour
{
	$strSQL="SELECT * FROM " .  $strDatabase. ".server_task WHERE task_type=" . $tasktype . " ORDER BY datetime_done DESC LIMIT 0,1";
	$records = $sql->query($strSQL);
	$record=$records[0];
	$datetime_done=$record["datetime_done"];
	$dtmDone=strtotime($datetime_done);
	$diffinhours=(time()-$dtmDone)/3600;
	echo "<HR>";
	echo "tasktype:" . $tasktype . "(reset phonecalls with no status updates) diff in hours:" .  $diffinhours . "* * hourpause: " . $hourpause;
 
	if($diffinhours>$hourpause|| $intDoNow==$tasktype)
	{
		//a:1:{s:4:"data";s:82:"{"tag":"medboxx_box.20","disposition":"ANSWERED","vm":0,"duration":17}";}
		UpdateOrInsert($strDatabase, "server_task", "", Array("task_type"=>$tasktype, "datetime_done"=> date("Y-m-d H:i:s")));
		//DO ACTUAL TASK
		$minutesinthefuturetotry=-60;
		
		$timeearlierSQLtime=date("Y-m-d H:i:s", AddUnitToDate(time(), $minutesinthefuturetotry, "i"));
		echo "<BR>" . $nowSQLtime . " " . $timeearlierSQLtime . "<BR>";
		$strSQL="UPDATE phone_call SET phonecall_status_id = 1
		WHERE phonecall_status_id=2
		AND attempt_count<3
		AND last_attempt  < '" . $timeearlierSQLtime . "'";
		
		echo $strSQL. "<BR>";
		$records = $sql->query($strSQL);
 
	} 
}











echo "<hr>nowhour:" .  $nowhour . " " . date("Y m d H:i:s", $dtmDone) . "-------" . date("Y m d H:i:s",time());

//$strSQL="REPAIR TABLE article QUICK";
//$records = $sql->query($strSQL);



 ?>