<?php
$strPathPre="../";
$urlroot="http://www.medboxx.com/";
include($strPathPre . "tf_functions_basic.php");
include($strPathPre . "tf_constants.php");
//include($strPathPre . "tf_functions_core.php");
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
 	//return 1;
	$to=$_REQUEST["to"];
	$subject=$_REQUEST["subject"];
	$body=$_REQUEST["body"];
	$headers=$_REQUEST["headers"];
	$from=$_REQUEST["from"];
	$key=$_REQUEST["key"];
	//echo $to . "<BR>" . $subject . "<BR>" . $body . "<BR>";
	if($key==$ourkey)
	{
		return mail($to, $subject,  $body, $headers);
	}
	else
	{
		return -2;
	}
 
}

echo handleremotemail("waddaywoo");
?>