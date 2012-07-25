<html>
<head>
<?php
$intDoNow=$_REQUEST["donow"];

if($_REQUEST["refresh"]!="")
{
	$refreshval=intval($_REQUEST["refresh"]);
	if($refreshval<1)
	{
		$refreshval=23;
	}
?>
<meta http-equiv="refresh" content="<?=$refreshval?>">
<?php
}
?>
<head>
<body bgcolor=ffff77>
<div style="font-face:courier;font-size:10px">
<?php
$strPathPre="tf/";
$urlroot="http://www.featurewell.com/";
include_once($strPathPre . "tf_constants.php");
include_once($strPathPre . "tf_functions_core.php");
include_once($strPathPre . "tf_functions_editor.php");
include_once($strPathPre . "tf_functions_frontend_db.php");
include_once($strPathPre . "tf_functions_odbc.php");
include_once($strPathPre . "tf_functions_backup.php");
include_once($strPathPre . "fw_functions.php");
$errorlevel=error_reporting(0);
ini_set ('odbc.defaultlrl','165536');
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
//task 9:
$tasktype=11;
$hourpause=.002;
;
if($nowhour>1 && $nowhour<5 || $intDoNow==$tasktype) /// i DO want to do this one, but only in the wee hours
{
	$strSQL="SELECT * FROM " .  $strDatabase . ".server_task WHERE task_type=" . $tasktype . " ORDER BY datetime_done DESC LIMIT 0,1";
	$records = $sql->query($strSQL);
	$record=$records[0];
	$datetime_done=$record["datetime_done"];
	$dtmDone=strtotime($datetime_done);
	$diffinhours=( time()-$dtmDone)/3600;
 
	if($diffinhours>$hourpause  || $intDoNow==$tasktype )
	{
	 
		
		$strSQL="SELECT * FROM " . our_db. ".mass_mailing WHERE timestamp<'" . date("Y-m-d", time()+60*60*24). "' AND active=1 ORDER BY mass_mailing_id DESC   LIMIT 0, 1";
		//echo $strSQL;
		$records = $sql->query($strSQL);
		$mm_record=$records[0];
		if(is_array($mm_record))
		{
			//$mm_record=GenericDBLookup(our_db, "mass_mailing", "mass_mailing_id", 1, "");
			$subject=	$mm_record["subject"];
			$body=	$mm_record["body_text"];
			$timestamp=	$mm_record["timestamp"];
			$dtmTS= date("Y-m-d",strtotime($mm_record["timestamp"]));
			//die($dtmTS . " ". $body . " " . $subject);
			$mtrnd=mt_rand(0,8000);
			$strSQL="SELECT EMAIL, ID FROM " . our_db . ".USERS WHERE LAST_SPAM<'" .  $dtmTS . "'  OR LAST_SPAM IS NULL LIMIT " . $mtrnd. ",41";
			//die($strSQL);
			$records=$sql->query($strSQL);
			//echo $strSQL . " " . mysql_error();
			$intdone=0;
			$mailedrecs="";
			$unmailedrecs="";
			foreach($records as $record)
			{
				$email=$record["EMAIL"];
				$thisid=$record["ID"];
				//echo $body .  " " . $email . "<BR>";
				$from="featurewell@featurewell.com";
				$headers = "From: " . $from . "\r\nReply-To: " . $from;
				//echo "----\n\n" . $emailstr . " " . $subject."\n\n" .  $body;
				//$body=str_replace("\n", "\r\n", $body);
				if($body!="" && $email!="")//dont bother to send emails that have no essential body
				{
					//echo $email . "|" . $subject . "|" . $body . "|" . $headers . "<BR>";
					//mail("gus@asecular.com", $subject,  $body, $headers, "-f" . $from);
					$intMailedResponse=mail($email, $subject,  $body, $headers, "-f" . $from);
				 	//echo $intMailedResponse . "<BR>";
					
					if($intMailedResponse)
					{
						$mailedrecs.=$thisid . " " . $email . "<BR>";
						UpdateOrInsert(our_db, "USERS",Array("ID"=>$thisid), Array("LAST_SPAM"=>date("Y-m-d H:i:s")),  true,  false,  false);
						$intdone++;
					}
					else
					{
						$unmailedrecs.=$thisid . " " . $email . "<BR>";
					}
				}
			}
			echo "<hr>tasktype: " . $tasktype . "(Mass Mailing)<br>" . "diffinhours:" . $diffinhours. " intstart:" . $intStart . " numberdone: " . $intdone . " <br>mailedrecs:<div style='color:green'>" . $mailedrecs . "</div><BR>Unmailed recs:<div style='color:red'>" . $unmailedrecs . "</div>";
			
		}
		
		
		
		
		
	}
	
	
}



$nowhour=intval(date("G", time()));
$nowSQLtime=date("Y-m-d H:i:s");
//eventually i will remake this to be a generic task repository
//the task_type for a FT index rebuild is 1
//task 9:
$tasktype=10;
$hourpause=7;
;
if($nowhour>1 && $nowhour<5 || $intDoNow==$tasktype) /// i DO want to do this one, but only in the wee hours
{
	$strSQL="SELECT * FROM " .  $strDatabase . ".server_task WHERE task_type=" . $tasktype . " ORDER BY datetime_done DESC LIMIT 0,1";
	$records = $sql->query($strSQL);
	$record=$records[0];
	$datetime_done=$record["datetime_done"];
	$dtmDone=strtotime($datetime_done);
	$diffinhours=( time()-$dtmDone)/3600;
	$copied=0;
	if($diffinhours>$hourpause  || $intDoNow==$tasktype )
	{
		$limitpossibilities="50 10 10 10 100 5 5 5 5 5 5 5 5 5 29 100 100";
		$intStart=mt_rand(0,19000);
		$arrLimitpossibilities=explode(" " , $limitpossibilities);
		$intThisLimitPossibility=intval($arrLimitpossibilities[mt_rand(0,count($arrLimitpossibilities)-1)]);
		$strSQL="SELECT ID FROM " . our_db. "." . articletable . " ORDER BY ID DESC LIMIT " . $intStart .", ". $intThisLimitPossibility;
		
		$records = $sql->query($strSQL);
		foreach($records as $record)
		{
			$bkexists=GenericDBLookup(our_db, "article_bkup", "ARTICLE_ID",  $record["ID"], "ID");
			if($bkexists=="")
			{
				$bkuprecord=GenericDBLookup(our_db,  articletable , "ID", $record["ID"], "");
				//backup this article now
				UpdateOrInsert(our_db, "article_bkup","", $bkuprecord, true, false, true);
				$copied++;
			
			}
		}
	}
	echo "<hr>tasktype: " . $tasktype . "(Backup Articles)<br>" . "diffinhours:" . $diffinhours. " intstart:" . $intStart . " numberdone: " . $copied . " limitpossib:" . $intThisLimitPossibility . "<BR>";
	
}


$nowhour=intval(date("G", time()));
$nowSQLtime=date("Y-m-d H:i:s");
//eventually i will remake this to be a generic task repository
//the task_type for a FT index rebuild is 1
//task 9:
$tasktype=9;
$hourpause=7;
;
if($nowhour>1 && $nowhour<5 || $intDoNow==$tasktype) /// i DO want to do this one, but only in the wee hours
{
	$strSQL="SELECT * FROM " .  $strDatabase . ".server_task WHERE task_type=" . $tasktype . " ORDER BY datetime_done DESC LIMIT 0,1";
	$records = $sql->query($strSQL);
	$record=$records[0];
	$datetime_done=$record["datetime_done"];
	$dtmDone=strtotime($datetime_done);
	$diffinhours=( time()-$dtmDone)/3600;
	$copied=0;
	if($diffinhours>$hourpause  || $intDoNow==$tasktype )
	{
		$limitpossibilities="50 10 10 10";
		$arrLimitpossibilities=explode(" " , $limitpossibilities);
		$intThisLimitPossibility=intval($arrLimitpossibilities[mt_rand(0,count($arrLimitpossibilities)-1)]);
		$strSQL="SELECT ID, CATEGORY_ID FROM " . our_db. "." . articletable . " ORDER BY ID DESC LIMIT 0, ". $intThisLimitPossibility;
		
		$records = $sql->query($strSQL);
		foreach($records as $record)
		{
			$article_id=$record["ID"];
			$cat_id=$record["CATEGORY_ID"];
			$exists=GenericDBLookup($strDatabase, "ARTICLE_CATEGORY", "ARTICLE_ID", $article_id, "CATEGORY_ID");
			if($exists<1)
			{
				//echo $cat_id . " " . $article_id . "<BR>";
				$strSQL="INSERT INTO ARTICLE_CATEGORY(CATEGORY_ID, ARTICLE_ID) VALUES(" . $cat_id  . "," . $article_id . ")";
				$sql->query($strSQL);
				$copied++;
			
			}
		}
	}
	echo "<hr>tasktype: " . $tasktype . "(Copy CATEGORY_IDs from articles to mapping table)<br>" . "diffinhours:" . $diffinhours. " numberdone: " . $copied . " limitpossib:" . $intThisLimitPossibility . "<BR>";
	
}

$nowhour=intval(date("G", time()));
$nowSQLtime=date("Y-m-d H:i:s");
//eventually i will remake this to be a generic task repository
//the task_type for a FT index rebuild is 1
//task 1:
$tasktype=1;
$hourpause=18;
 
if($nowhour>1 && $nowhour<5 || $intDoNow==$tasktype) /// i DO want to do this one, but only in the wee hours
{
	$strSQL="SELECT * FROM " .  $strDatabase . ".server_task WHERE task_type=" . $tasktype . " ORDER BY datetime_done DESC LIMIT 0,1";
	$records = $sql->query($strSQL);
	$record=$records[0];
	$datetime_done=$record["datetime_done"];
	$dtmDone=strtotime($datetime_done);
	$diffinhours=( time()-$dtmDone)/3600;
	echo "<hr>tasktype: " . $tasktype . "(Update Fulltext Indices)<br>" . "diffinhours:" . $diffinhours. "<BR>";
	if($diffinhours>$hourpause  || $intDoNow==$tasktype )
	{
		UpdateOrInsert( $strDatabase, "server_task", "", Array("task_type"=>$tasktype, "datetime_done"=> date("Y-m-d H:i:s")), true, false, true);
		//DO ACTUAL TASK
		$strSQL="REPAIR TABLE " . our_db . "." . searchtable . " QUICK";
		//END OF ACTUAL TASK
		//don't do it for now because bad things were happening
		//$records = $sql->query($strSQL);
	}

	
}
 
if(1==2)//don't do this one any more
{
$tasktype=3; 
$hourpause=22;
$strSQL="SELECT * FROM " .  $strDatabase . ".server_task WHERE task_type=" . $tasktype . " ORDER BY datetime_done DESC LIMIT 0,1";
$records = $sql->query($strSQL);
$record=$records[0];
$datetime_done=$record["datetime_done"];
$dtmDone=strtotime($datetime_done);
$diffinhours=( time()-$dtmDone)/3600;
$deltaback=12;
echo "<hr>tasktype: " . $tasktype . "(Sync of MySQL DB)<br>" . "diffinhours:" . $diffinhours. "<BR>";
if($diffinhours>$hourpause   || $intDoNow==$tasktype)//want to do this even later
{
	UpdateOrInsert( $strDatabase, "server_task", "", Array("task_type"=>$tasktype, "datetime_done"=> date("Y-m-d H:i:s")), true, false, true);
	//DO ACTUAL TASK
	//SAMPLE:
	//$strSQL="REPAIR TABLE " . our_db . ".article QUICK";
	$highestarticlepk=intval(highestprimarykey(our_db, articletable ));
	echo "highest article pk: " . $highestarticlepk . "<BR>";;
	//delete recent articles
	$db_type= '';
	/*
	$strSQL="DELETE FROM " . our_db . "." . articletable . " WHERE ID>" . intval($highestarticlepk -$deltaback);
	$records = $sql->query($strSQL);
	echo $db_type . "*" . mysql_error(). "<BR>";;
	$strSQL="DELETE FROM " . our_db . ".ARTICLE_PICTURE WHERE ARTICLE_ID>" . intval($highestarticlepk -$deltaback);
	$records = $sql->query($strSQL);
	echo $db_type . "*" . mysql_error(). "<BR>";;
	$strSQL="DELETE FROM " . our_db . ".BOOKMARK WHERE ARTICLE_ID>" . intval($highestarticlepk -$deltaback);
	$records = $sql->query($strSQL);
	echo $db_type . "*" . mysql_error(). "<BR>";;
	$strSQL="DELETE FROM " . our_db . ".ARTICLE_CATEGORY WHERE ARTICLE_ID>" . intval($highestarticlepk -$deltaback);
	$records = $sql->query($strSQL);
	$highestuserspk=intval(highestprimarykey(our_db, "USERS"));
	$strSQL="DELETE FROM " . our_db . ".USERS WHERE ID>" . intval($highestuserspk -$deltaback);
	$records = $sql->query($strSQL);
	echo "highest users pk: " . $highestuserspk . "<BR>";;
	echo $db_type . "*" . mysql_error(). "<BR>";;
	SyncDataFromODBCToMySQL(220, $tablesout,  "",  "");
	*/
	
	$strTables= articletable . " OFFER USERS INVOICE HIT";
	$thosetables=explode(" ", $strTables);
	foreach($thosetables as $thistablenow)
	{
		$strHandleTable=$thistablenow;
		$highestTHISpk=intval(highestprimarykey(our_db, $strHandleTable));
		$strSQL="DELETE FROM " . our_db . "." . $strHandleTable . " WHERE ID>" . intval($highestTHISpk -$deltaback);
		$records = $sql->query($strSQL);
		echo "highest " . $strHandleTable . " pk: " .$highestTHISpk . "<BR>";;
		echo $db_type . "*" . mysql_error(). "<BR>";;
	}
	SyncDataFromODBCToMySQL(240, $tablesout,  "",  "");
	
	$fixcount=1;
	FixBrokenMetadata(270, $tablesout,$fixcount, "");
	echo "<b> fix count:</b> ";
	echo  $fixcount;
	echo " <b> tables out:</b>";
	echo $tablesout;
	echo "<P>";
	//END OF ACTUAL TASK 
	 
}
}


//the task_type for an active user table rebuild is 4
//task 4:
$tasktype=4;
$hourpause=17;
$db_type= '';
$strDatabase=our_db;
$strSQL="SELECT * FROM " .  $strDatabase . ".server_task WHERE task_type=" . $tasktype . " ORDER BY datetime_done DESC LIMIT 0,1";
$records = $sql->query($strSQL);
$record=$records[0];
$datetime_done=$record["datetime_done"];
$dtmDone=strtotime($datetime_done);
$diffinhours=( time()-$dtmDone)/3600;
echo "<hr>tasktype: " . $tasktype . "(Rebuild table of most active users)<br>" . "diffinhours:" . $diffinhours. "<BR>";
if($diffinhours>$hourpause   || $intDoNow==$tasktype)//want to do this even later
{
	UpdateOrInsert( $strDatabase, "server_task", "", Array("task_type"=>$tasktype, "datetime_done"=> date("Y-m-d H:i:s")));
	//DO ACTUAL TASK
	//$db_type= 'odbc';
	//$strDatabase="dbo";
	//$sql->query("fw_client_emails_active_user" );
	
	$db_type= '';
	$strDatabase=our_db;
	//this is the version that matters for the revamp:
	RebuildActiveUsers();
	
}




// SendMailingToUser("6797", "", 99);
//this is the task to send out a block of mailings from the latest mailing
//task 5:
$tasktype=5;
$hourpause=.004;
$mailspertime=15;
$maxperday=1200;
$strSQL="SELECT * FROM " .  $strDatabase . ".server_task WHERE task_type=" . $tasktype . " ORDER BY datetime_done DESC LIMIT 0,1";
$records = $sql->query($strSQL);
$record=$records[0];
$datetime_done=$record["datetime_done"];
$dtmDone=strtotime($datetime_done);
$diffinhours=( time()-$dtmDone)/3600;
echo "<hr>tasktype: " . $tasktype . "(block of mailings)<br>" . "diffinhours:" . $diffinhours. "<BR>";
$strSQL="SELECT * FROM " .  $strDatabase . ".mailing  ORDER BY mailing_id DESC";
$records=$sql->query($strSQL);
$record=$records[0];//only worry about the latest not-completed mailing
$last_user_id_done=$record["last_user_id_done"];
$mailing_count= $record["mailing_count"];
if($mailing_count=="")
{
	$mailing_count=0;
}
$mailing_date=$record["mailing_date"];
$mailing_id=$record["mailing_id"];
$thismailingcompleted=$record["completed"];
$aborted=$record["aborted"];
$glitch_experienced=$record["last_glitch"];
$subject=radicaldeescape($record["subject"], false);
$body_extra=radicaldeescape($record["body_extra"], false);
$emails_sent=$record["emails_sent"];
$glitches_experienced=$record["glitches_experienced"];
if($emails_sent=="")
{
	$emails_sent=0;
}
echo $mailing_date . " " . $nowSQLtime . "<BR>";
$dayssincemailingbegan=abs(date_differ($mailing_date, $nowSQLtime, "day"));
if($diffinhours>$hourpause  || $intDoNow==$tasktype )//want to do this even later
{
	UpdateOrInsert( $strDatabase, "server_task", "", Array("task_type"=>$tasktype, "datetime_done"=> date("Y-m-d H:i:s")), true, false, true);
	//DO ACTUAL TASK
	echo "days since mailing began:" . $dayssincemailingbegan . " mailing count/maxperday: " .  $mailing_count/$maxperday  . "<BR>";
	if($dayssincemailingbegan>intval($emails_sent/$maxperday))//makes sure we send no more than 1000 per day
	{
		if($thismailingcompleted<1  && $aborted<1)
		{
			//$strSQL="SELECT * FROM " .  $strDatabase . ".mail_log WHERE mailing_id=" . $mailing_id . " AND send_time is null ORDER BY mail_log_id LIMIT 0, " . $mailspertime;
			$strSQL="SELECT * FROM " .  $strDatabase . ".mail_log WHERE mailing_id=" . $mailing_id . " AND (response is null OR response=0)  ORDER BY mail_log_id LIMIT 0, " . $mailspertime;
			$records=$sql->query($strSQL);
			foreach($records as $record)
			{
				$email=$record["email"];
				$user_id=$record["user_id"];
				if($user_id!="")
				{
					$last_user_id=$user_id;
				}
				$mail_log_id=$record["mail_log_id"];
				$row_number=$record["row_number"];
				$intMailedResponse=-3;
				$intMailedResponse=SendMailingToUser($user_id, $mailing_id, $subject, $body_extra);
				if($intMailedResponse==1  || $intMailedResponse==-1)
				{
					UpdateOrInsert( $strDatabase, "mail_log", Array("mail_log_id"=>$mail_log_id), Array("send_time"=>$mailing_date, "response"=>$intMailedResponse), true, false, true);
					if($intMailedResponse==1 )
					{
						$emails_sent++;
					}
				}
				else
				{
					UpdateOrInsert( $strDatabase, "mail_log", Array("mail_log_id"=>$mail_log_id), Array("response"=>$intMailedResponse), true, false, true);
				}
				
				//UPDATE THE OLD ODBC DB
				$db_type= 'odbc';
				$strDatabase="dbo";
				if($user_id!="")
				{
					//will turn this off after migration completes
					UpdateOrInsert($strDatabase, "USERS", Array("ID"=>$user_id), Array("LAST_EMAIL"=>$mailing_date), true, false, true);
				}
				$db_type= '';
				$strDatabase=our_db;
				if($user_id!="")
				{
					//also do it on the MySQL side:
					UpdateOrInsert($strDatabase, "USERS", Array("ID"=>$user_id), Array("LAST_EMAIL"=>$mailing_date), true, false, true);
				}
			
				
			}
			$mailingcompleted=0;
			if(count($records)<$mailspertime)
			{
				$mailingcompleted=1;
			}
			$db_type= '';
			$strDatabase=our_db;
			$mailingcountforsave=intval(intval($mailing_count)+ count($records));
			if($mailingcountforsave<$mail_log_id)
			{
				$glitch_experienced=$mail_log_id;
				$glitches_experienced++;
				$mailingcountforsave=$mail_log_id;
			}
			UpdateOrInsert($strDatabase, "mailing", Array("mailing_id"=>$mailing_id), Array("mailing_count"=>$mailingcountforsave,"last_user_id_done"=> $last_user_id, "completed"=>$mailingcompleted, "last_mailing_date"=>date("Y-m-d H:i:s"), "last_glitch"=>$glitch_experienced, "emails_sent"=>$emails_sent, "glitches_experienced"=>$glitches_experienced), true, false, true);
	
		}
	}
	//END OF ACTUAL TASK
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
echo "<hr>tasktype: " . $tasktype . "(Delete Old Tasks)<br>" . "diffinhours:" . $diffinhours. "<BR>";
if($diffinhours>$hourpause   || $intDoNow==$tasktype)//want to do this even later
{
	UpdateOrInsert( $strDatabase, "server_task", "", Array("task_type"=>$tasktype, "datetime_done"=> date("Y-m-d H:i:s")), true, false, true);
	//DO ACTUAL TASK
 	//things older than eight days in the server_task table have to go
	$strSQL="DELETE FROM " . our_db . ".server_task WHERE datetime_done<'" . date("Y-m-d H:i:s" , time() - 500000). "'";
	$records = $sql->query($strSQL);
 
	//END OF ACTUAL TASK
 
}








echo "<hr><b>now hour:" .  $nowhour .  "<br>Time now:" . date("Y m d H:i:s",time()) . "</b>";

 ?>

 </div>
 </body>
 </html>
 <?
//$db_type= 'odbc';
//$strDatabase="dbo";
//UpdateOrInsert($strDatabase, "USERS", Array("ID"=>'41'), Array("LAST_EMAIL"=>'2010-07-26'), true, false, true);
//echo mysql_error(). "=mysql\n<br>";
//echo odbc_errormsg(). "=odbc\n<br>";
 ?>