<?php
$strPathPre="tf/";
$urlroot="http://www.medboxx.com/";
include($strPathPre . "tf_constants.php");
include($strPathPre . "tf_functions_core.php");
include($strPathPre . "tf_functions_editor.php");
include($strPathPre . "tf_functions_frontend_db.php");
include($strPathPre . "tf_functions_odbc.php");
include($strPathPre . "tf_functions_backup.php");


function remotemail($to, $subject,  $body, $headers, $from)
{
	//sends a mail() call to a separate web server via POST so it can be mailed from there
	//this is handy when SMTP is broken on a server and you have access to one that actually works
	//key makes sure that no yahoos use the system for spamming
	$server= "medboxx.com";
	$path = "/fw/remotemail.php";
	$key="waddaywoo";
	$data="";
	$data.="to=" . urlencode($to);
	$data.="&subject=" . urlencode($subject);
	$data.="&body=" . urlencode($body);
	$data.="&headers=" . urlencode($headers);
	$data.="&from=" . urlencode($from);
	$data.="&key=" . urlencode($key);
	$responseContent=httpSocketConnection($host,"POST", $path, $data);
	return $responseContent;
	//actually need to write the remote mailer now -- 
}

function handleremotemail($ourkey="waddaywoo")
{
	//receives a mail() call from a separate web server via POST so it can be mailed from here
	//this is handy when SMTP is broken on a server and you have access to one that actually works
	//key makes sure that no yahoos use the system for spamming
 
	$to=$_REQUEST["to"];
	$subject=$_REQUEST["subject"];
	$body=$_REQUEST["body"];
	$headers=$_REQUEST["headers"];
	$from=$_REQUEST["from"];
	$key=$_REQUEST["key"];
	if($key==$ourkey)
	{
		return mail($to, $subject,  $body, $headers, $from);
	}
 
}





$to=$_REQUEST["to"];
$subject=$_REQUEST["subject"];
$body=$_REQUEST["body"];
$from="sales@featurewell.com";
$headers = "From: " . $from . "\r\nReply-To: " . $from;

if($to!="")
{

	//$response=mail($to, $subject,  $body, $headers , "-fsales@featurewell.com");
	$response=remotemail($to, $subject,  $body, $headers , "-fsales@featurewell.com");
	echo "<font color=red>Mail sent<br>";
	if($response!=1)
	{
		echo "But the server says it wasn't delivered.";
	}
	else
	{
		echo "And the server says it was delivered.";
	}
	echo "</font><p>";
}
	
	
	
	
	if($to=="" )
	{
		$to="gus@asecular.com";
	}
	if($subject=="" )
	{
		$subject=="test subject";
	}
	if($body=="" )
	{
		$body="test body with lots of fun text to try";
	}
	 
	?>
	<h2>send   a test email using the special SNEAKY MEDBOXX server</h2>
	
	<form method="post" action="rtestmail.php">
	to: <input name="to" type="text" value="<?=$to?>"><br>
	subject: <input name="subject" type="text" value="<?=$subject?>"><br>
	body: <br><textarea cols=80 rows=5 name="body" type="text" ><?=$body?></textarea><br>
	<input name="mailemailer" type="submit" value="mail!"><br>
	</form>
	
