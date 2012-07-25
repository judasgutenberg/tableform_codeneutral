<?php
$strPathPre="tf/";
$urlroot="http://www.featurewell.com/";
include($strPathPre . "tf_constants.php");
include($strPathPre . "tf_functions_core.php");
include($strPathPre . "tf_functions_editor.php");
include($strPathPre . "tf_functions_frontend_db.php");
include_once($strPathPre . "tf_functions_odbc.php");
include($strPathPre . "tf_functions_backup.php");
include_once($strPathPre . "fw_functions.php");
$errorlevel=error_reporting(0);

set_time_limit(900);
error_reporting($errorlevel);

$strDatabase=our_db;
$sql=conDB();
/*
indexes on article:
show indexes from article

recreating fulltext indexes:
alter table article drop index ft_text
create fulltext index ft_text  ON  article(TEXT)
drop  index ft_writer  on article
create fulltext index ft_writer  ON  article(FT_WRITER)
alter table article drop index ft_title
create fulltext index ft_title  ON  article(TITLE)

OR
 
REPAIR TABLE article QUICK;
*/




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







$nowhour=intval(date("G", time()));
$nowSQLtime=date("Y-m-d H:i:s");
//eventually i will remake this to be a generic task repository
//the task_type for a FT index rebuild is 1
//task 1:
$tasktype=1;
$hourpause=18;
if($nowhour>1 && $nowhour<5 ) /// i DO want to do this one
{
	$strSQL="SELECT * FROM " .  $strDatabase . ".server_task WHERE task_type=" . $tasktype . " ORDER BY datetime_done DESC LIMIT 0,1";
	$records = $sql->query($strSQL);
	$record=$records[0];
	$datetime_done=$record["datetime_done"];
	$dtmDone=strtotime($datetime_done);
	$diffinhours=( time()-$dtmDone)/3600;
	
	if($diffinhours>$hourpause )
	{
		UpdateOrInsert( $strDatabase, "server_task", "", Array("task_type"=>$tasktype, "datetime_done"=> date("Y-m-d H:i:s")), true, false, true);
		//DO ACTUAL TASK
		$strSQL="REPAIR TABLE " . our_db . ".article QUICK";
		//END OF ACTUAL TASK
		$records = $sql->query($strSQL);
	}

	
}
 
 
$tasktype=3;
$hourpause=22;
$strSQL="SELECT * FROM " .  $strDatabase . ".server_task WHERE task_type=" . $tasktype . " ORDER BY datetime_done DESC LIMIT 0,1";
$records = $sql->query($strSQL);
$record=$records[0];
$datetime_done=$record["datetime_done"];
$dtmDone=strtotime($datetime_done);
$diffinhours=( time()-$dtmDone)/3600;
echo "tasktype: " . $tasktype . " " . "diffinhours:" . $diffinhours. "<BR>";
if($diffinhours>$hourpause  )//want to do this even later
{
	UpdateOrInsert( $strDatabase, "server_task", "", Array("task_type"=>$tasktype, "datetime_done"=> date("Y-m-d H:i:s")), true, false, true);
	//DO ACTUAL TASK
	//SAMPLE:
	//$strSQL="REPAIR TABLE " . our_db . ".article QUICK";
	$highestarticlepk=intval(highestprimarykey(our_db, "article"));
	echo $highestarticlepk;
	//delete recent articles
	$deltaback=6;
	$strSQL="DELETE FROM " . our_db . ".article WHERE ID>" . intval($highestarticlepk -$deltaback);
	$records = $sql->query($strSQL);
	echo mysql_error(). "<BR>";;
	$strSQL="DELETE FROM " . our_db . ".ARTICLE_PICTURE WHERE ARTICLE_ID>" . intval($highestarticlepk -$deltaback);
	$records = $sql->query($strSQL);
	echo mysql_error(). "<BR>";;
	$strSQL="DELETE FROM " . our_db . ".BOOKMARK WHERE ARTICLE_ID>" . intval($highestarticlepk -$deltaback);
	$records = $sql->query($strSQL);
	echo mysql_error(). "<BR>";;
	$strSQL="DELETE FROM " . our_db . ".ARTICLE_CATEGORY WHERE ARTICLE_ID>" . intval($highestarticlepk -$deltaback);
	$records = $sql->query($strSQL);
	echo mysql_error(). "<BR>";;
	SyncDataFromODBCToMySQL(300, $tablesout,  "",  "");
	echo $tablesout;
	FixBrokenMetadata(200, $tablesout, 20, "");
	echo "<HR>";
	echo  $fixcount;
	echo "<HR>";
	echo $tablesout;
	//END OF ACTUAL TASK
	$records = $sql->query($strSQL);
}
	
//the task_type for an active user table rebuild is 4
//task 4:
$tasktype=4;
$hourpause=17;
$strSQL="SELECT * FROM " .  $strDatabase . ".server_task WHERE task_type=" . $tasktype . " ORDER BY datetime_done DESC LIMIT 0,1";
$records = $sql->query($strSQL);
$record=$records[0];
$datetime_done=$record["datetime_done"];
$dtmDone=strtotime($datetime_done);
$diffinhours=( time()-$dtmDone)/3600;
echo "tasktype: " . $tasktype . " " . "diffinhours:" . $diffinhours. "<BR>";
if($diffinhours>$hourpause  )//want to do this even later
{
	UpdateOrInsert( $strDatabase, "server_task", "", Array("task_type"=>$tasktype, "datetime_done"=> date("Y-m-d H:i:s")));
	//DO ACTUAL TASK
	$db_type= 'odbc';
	$strDatabase="dbo";
	$sql->query("fw_client_emails_active_user" );
	$db_type= '';
	$strDatabase=our_db;
	
}

// SendMailingToUser("6797", "", 99);
//this is the task to send out a block of mailings from the latest mailing
//task 5:
$tasktype=5;
$hourpause=.1;
$mailspertime=20;
$maxperday=1000;
$strSQL="SELECT * FROM " .  $strDatabase . ".server_task WHERE task_type=" . $tasktype . " ORDER BY datetime_done DESC LIMIT 0,1";
$records = $sql->query($strSQL);
$record=$records[0];
$datetime_done=$record["datetime_done"];
$dtmDone=strtotime($datetime_done);
$diffinhours=( time()-$dtmDone)/3600;
echo "tasktype: " . $tasktype . "(block of mailings) " . "diffinhours:" . $diffinhours. "<BR>";
$strSQL="SELECT * FROM " .  $strDatabase . ".mailing  ORDER BY mailing_id DESC";
$records=$sql->query($strSQL);
$record=$records[0];//only worry about the latest not-completed mailing
$last_user_id_done=$record["last_user_id_done"];
$mailing_count=$record["mailing_count"];
$mailing_date=$record["mailing_date"];
$mailing_id=$record["mailing_id"];
$thismailingcompleted=$record["completed"];
$dayssincemailingbegan=abs(date_diff($mailing_date, $nowSQLtime, "day"));
if($diffinhours>$hourpause  )//want to do this even later
{
	UpdateOrInsert( $strDatabase, "server_task", "", Array("task_type"=>$tasktype, "datetime_done"=> date("Y-m-d H:i:s")), true, false, true);
	//DO ACTUAL TASK
	if($dayssincemailingbegan>intval($mailing_count/$maxperday))//makes sure we send no more than 1000 per day
	{
		if($thismailingcompleted<1)
		{
			$strSQL="SELECT * FROM " .  $strDatabase . ".mail_log WHERE mailing_id=" . $mailing_id . " AND send_time is null ORDER BY mail_log_id LIMIT 0, " . $mailspertime;
			$records=$sql->query($strSQL);
			foreach($records as $record)
			{
				$email=$record["email"];
				$user_id=$record["user_id"];
				$mail_log_id=$record["mail_log_id"];
				SendMailingToUser($user_id, $mailing_id=0);
				UpdateOrInsert( $strDatabase, "mail_log", Array("mail_log_id"=>$mail_log_id), Array("send_time"=>$mailing_date), true, false, true);
			}
			$mailingcompleted=0;
			if(count($records)<$mailspertime)
			{
				$mailingcompleted=1;
			}
			UpdateOrInsert($strDatabase, "mailing", Array("mailing_id"=>$mailing_id), Array("mailing_count"=>$mailing_count+$mailspertime,"last_user_id_done"=> $user_id, "completed"=>$mailingcompleted), true, false, true);
		}
	}
	//END OF ACTUAL TASK
	
}


//the task_type for a send email  rebuild is 2
//task 2:
$tasktype=2;
$hourpause=1;
if( 1==2) /// i DON't want to do THIS ONE //don't worry about the hour
{
	$strSQL="SELECT * FROM " .  $strDatabase. ".server_task WHERE task_type=" . $tasktype . " ORDER BY datetime_done DESC LIMIT 0,1";
	$records = $sql->query($strSQL);
	$record=$records[0];
	$datetime_done=$record["datetime_done"];
	$dtmDone=strtotime($datetime_done);
	$diffinhours=(time()-$dtmDone)/3600;
	//echo $diffinhours . "* *" . $hourpause;
	if($diffinhours>$hourpause)
	{
		UpdateOrInsert($strDatabase, "server_task", "", Array("task_type"=>$tasktype, "datetime_done"=> date("Y-m-d H:i:s")), true, false, true);
		//DO ACTUAL TASK
		$strSQL="SELECT c.phone_call_id, o.office_name, c.time_to_start, c.last_attempt, c.email_content, u.email as tomail, o.email as frommail  FROM phone_call c JOIN user u ON c.callee_id=u.user_id JOIN user o ON c.office_id=o.user_id  WHERE email_sent=0 AND expiry_date>'".$nowSQLtime."'";
		$pcrecords = $sql->query($strSQL, true,  $strDatabase);
		foreach($pcrecords as $pcrecord)
		{
			$phone_call_id=$pcrecord["phone_call_id"];
			$email_content=$pcrecord["email_content"];
			$to=$pcrecord["tomail"];
			$from=$pcrecord["frommail"];
			$last_attempt=$pcrecord["last_attempt"];
			$time_to_start=$pcrecord["time_to_start"];
			$headers = "From: ". $from . "\r\nReply-To: " . $from;
			
			if($time_to_start<$nowSQLtime)
			{
				mail($to, "Reminder from " .  $office_name,  $email_content, $headers);
				UpdateOrInsert($strDatabase, "phone_call", Array("phone_call_id"=>$phone_call_id), Array("email_sent"=>1));
			}
		}
		//END OF ACTUAL TASK
		 
	}
}



echo "nowhour:" .  $nowhour . " " . date("Y m d H:i:s", $dtmDone) . "-------" . date("Y m d H:i:s",time());

//$strSQL="REPAIR TABLE article QUICK";
//$records = $sql->query($strSQL);

 ?>