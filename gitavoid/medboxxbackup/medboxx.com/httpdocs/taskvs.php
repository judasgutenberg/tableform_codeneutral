<body bgcolor="ccffff" style="font-family:courier;font-size: 9px;">
<?php
function httpSocketConnection($host, $method, $path, $data)
    {
        $method = strtoupper($method);       
       
        if ($method == "GET")
        {
            $path.= '?'.$data;
        }   
       
        $filePointer = fsockopen($host, 80, $errorNumber, $errorString);
       
        if (!$filePointer)
        {
            //logEvent('debug', 'Failed opening http socket connection: '.$errorString.' ('.$errorNumber.')<br/>\n');
           // return false;
        }

        $requestHeader = $method." ".$path."  HTTP/1.1\r\n";
        $requestHeader.= "Host: ".$host."\r\n";
        $requestHeader.= "User-Agent:      Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1) Gecko/20061010 Firefox/2.0\r\n";
        $requestHeader.= "Content-Type: application/x-www-form-urlencoded\r\n";

        if ($method == "POST")
        {
            $requestHeader.= "Content-Length: ".strlen($data)."\r\n";
        }
       
        $requestHeader.= "Connection: close\r\n\r\n";
       
        if ($method == "POST")
        {
            $requestHeader.= $data;
        }           

        fwrite($filePointer, $requestHeader);
       
        $responseHeader = '';
        $responseContent = '';

        do
        {
            $responseHeader.= fread($filePointer, 1);
        }
        while (!preg_match('/\\r\\n\\r\\n$/', $responseHeader));
       
       
        if (!strstr($responseHeader, "Transfer-Encoding: chunked"))
        {
            while (!feof($filePointer))
            {
                $responseContent.= fgets($filePointer, 128);
            }
        }
        else
        {

            while ($chunk_length = hexdec(fgets($filePointer)))
            {
                $responseContentChunk = '';
           
                //logEventToTextFile('debug', $chunk_length);
                $read_length = 0;
               
                while ($read_length < $chunk_length)
                {
                    $responseContentChunk .= fread($filePointer, $chunk_length - $read_length);
                    $read_length = strlen($responseContentChunk);
                }

                $responseContent.= $responseContentChunk;
               
                fgets($filePointer);
               
            }
           
        }

        //logEventToTextFile('debug', $responseContent);
       
       
        return chop($responseContent);
    }

?>
<?php
$strPathPre="";
$urlroot="http://www.medboxx.com/";
include($strPathPre . "tf_constants.php");
include($strPathPre . "tf_functions_core.php");
include($strPathPre . "tf_functions_editor.php");
include($strPathPre . "tf_functions_frontend_db.php");
include($strPathPre . "tf_functions_odbc.php");
include($strPathPre . "tf_functions_backup.php");
 
 

$errorlevel=error_reporting(0);
$intDoNow=$_REQUEST["donow"];
$makecall=$_REQUEST["makecall"];
$message=$_REQUEST["message"];
$defaultmessage="Hello gus!  Have fun today";
set_time_limit(22);
error_reporting($errorlevel);
$urlroot="http://www.medboxx.com/";
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
		$strSQL="SELECT c.phone_call_id, o.office_name, c.time_to_start, c.last_attempt, c.email_content, cl.email as tomail, o.email as frommail  FROM phone_call c JOIN client cl ON c.callee_id=cl.client_id JOIN office o ON c.office_id=o.office_id  WHERE email_sent=0 AND expiry_date>'".$nowSQLtime."'";
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
			$headers = "From: ". $from . "\r\nReply-To: <" . $from . "> " . $office_name;
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
				logcollection(true,  $arr_to_log, "actualmail", "");
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
		
		UpdateOrInsert($strDatabase, "server_task", "", Array("task_type"=>$tasktype, "datetime_done"=> date("Y-m-d H:i:s")));
		//DO ACTUAL TASK
		$strSQL="SELECT p.phone_call_id, p.phone_number AS number,p.call_content AS content,c.attempt_frequency AS frequency,p.time_to_start AS start_date_time,  completed, abandoned FROM phone_call p    JOIN  call_type c ON p.call_type_id=c.call_type_id WHERE date_format(p.time_to_start,'%Y:%m:%d %k:%i')<date_format(now(),'%Y:%m:%d %k:%i') AND p.completed=0 AND p.abandoned=0 AND '".$nowSQLtime ."' BETWEEN substr(c.local_call_time_span,1,5) AND substr(c.local_call_time_span,7) AND   p.time_to_start < DATE_ADD(now(),INTERVAL c.attempt_window_length day)";
		//logcollection(true, $strSQL, "phonesql");
		$records = $sql->query($strSQL);
		
		echo mysql_error() . "<BR>";
		$strJSONdata="";
		if($makecall=="")
		{
			foreach($records as $record)
			{
				//logcollection(true, $record, "maybephone");
				$number=$record['number'];
				$content=$record['content'];
				$frequency=$record['frequency'];	
				$phone_call_id=$record['phone_call_id'];	
				echo $number . "<br>" . $content . "<p>";
				$start_date_time=$record['start_date_time'];	
				$strJSONdata.='{"tag":"' . our_db . "." . $phone_call_id . '","phone":"' . str_replace("\"", "", $number)  . '","tts":"' . str_replace("\"", "", $content) . '"},';
			
				//what i would do if i assumed the call made it:
				$sql->query("UPDATE phone_call SET completed='0', last_attempt=now(),attempt_count=attempt_count+1 WHERE phone_call_id='" . $phone_call_id ."'");
				echo mysql_error() . "<BR>";
			}
		}
		else
		{
			$strJSONdata.='{"tag":"tester","phone":"' . str_replace("\"", "", $makecall)  . '","tts":"' . str_replace("\"", "", gracefuldecay($message, $defaultmessage)) . '"},';
			
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
			logcollection(true, json_decode($requestdata), "actualphone");
			$ret =httpSocketConnection($server, "POST", $path, $requestdata);
			
			
			 
			echo "returned: " . $ret . "<BR>";
		}
		if(1==2)
		{
	 		foreach($x as $y)
			{
				if(1==1)
				{
					$sql->query("update phone_call set completed='1',suid='$uid',last_attempt=now(),attempt_count=attempt_count+1 where phone_number='$number'");
				//exec("rm -f /var/lib/asterisk/sounds/dialer_mesg/$uid.wav");
				}
				else
				{
				
					$sql->query("update phone_call set suid='$uid',last_attempt=now(),attempt_count=attempt_count+1,time_to_start=DATE_ADD('$start_date_time', INTERVAL '$frequency' MINUTE) where phone_number='$number' and completed='0'");
				//exec("rm -f /var/lib/asterisk/sounds/dialer_mesg/$uid.wav");
				}
			}
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


echo "nowhour:" .  $nowhour . " " . date("Y m d H:i:s", $dtmDone) . "-------" . date("Y m d H:i:s",time());

//$strSQL="REPAIR TABLE article QUICK";
//$records = $sql->query($strSQL);



 ?>