<?php
//goes here: /var/www/html
//on 173.201.27.171
$to = $_REQUEST["to"];
$subject = $_REQUEST["subject"];
$body =  $_REQUEST["body"];
$from = $_REQUEST["from"];
$headers =  $_REQUEST["headers"];
$more =  $_REQUEST["more"];
$auth =  $_REQUEST["auth"];
 
//$body =str_replace(" ", "\n\n\n", $body);









/* * * * * * * * * * * * * * SEND EMAIL FUNCTIONS * * * * * * * * * * * * * */

//Authenticate Send - 21st March 2005
//This will send an email using auth smtp and output a log array
//logArray - connection,

function authSendEmail($to, $subject, $message )
{
//SMTP + SERVER DETAILS
/* * * * CONFIGURATION START * * * */
$smtpServer = "k2smtpout.secureserver.net";
$port = "25";
$timeout = "30";
$username = "";
$password = "";
$localhost = "localhost";
$newLine = "\r\n";
$from="sales@featurewell.com";
$namefrom="Featurwell Sales";
$nameto=$to;
/* * * * CONFIGURATION END * * * * */

//Connect to the host on the specified port
$smtpConnect = fsockopen($smtpServer, $port, $errno, $errstr, $timeout);
$smtpResponse = fgets($smtpConnect, 515);
if(empty($smtpConnect))
{
$output = "Failed to connect: $smtpResponse";
return $output;
}
else
{
$logArray['connection'] = "Connected: $smtpResponse";
}

//Request Auth Login
fputs($smtpConnect,"AUTH LOGIN" . $newLine);
$smtpResponse = fgets($smtpConnect, 515);
$logArray['authrequest'] = "$smtpResponse";

//Send username
fputs($smtpConnect, base64_encode($username) . $newLine);
$smtpResponse = fgets($smtpConnect, 515);
$logArray['authusername'] = "$smtpResponse";

//Send password
fputs($smtpConnect, base64_encode($password) . $newLine);
$smtpResponse = fgets($smtpConnect, 515);
$logArray['authpassword'] = "$smtpResponse";

//Say Hello to SMTP
fputs($smtpConnect, "HELO $localhost" . $newLine);
$smtpResponse = fgets($smtpConnect, 515);
$logArray['heloresponse'] = "$smtpResponse";

//Email From
fputs($smtpConnect, "MAIL FROM: $from" . $newLine);
$smtpResponse = fgets($smtpConnect, 515);
$logArray['mailfromresponse'] = "$smtpResponse";

//Email To
fputs($smtpConnect, "RCPT TO: $to" . $newLine);
$smtpResponse = fgets($smtpConnect, 515);
$logArray['mailtoresponse'] = "$smtpResponse";

//The Email
fputs($smtpConnect, "DATA" . $newLine);
$smtpResponse = fgets($smtpConnect, 515);
$logArray['data1response'] = "$smtpResponse";

//Construct Headers
$headers = "MIME-Version: 1.0" . $newLine;
$headers .= "Content-type: text/html; charset=iso-8859-1" . $newLine;
$headers .= "To: $nameto <$to>" . $newLine;
$headers .= "From: $namefrom <$from>" . $newLine;

fputs($smtpConnect, "To: $to\nFrom: $from\nSubject: $subject\n$headers\n\n$message\n.\n");
$smtpResponse = fgets($smtpConnect, 515);
$logArray['data2response'] = "$smtpResponse";

// Say Bye to SMTP
fputs($smtpConnect,"QUIT" . $newLine);
$smtpResponse = fgets($smtpConnect, 515);
$logArray['quitresponse'] = "$smtpResponse";
$arrResp=explode(" ", $smtpResponse);
if($arrResp[0]=="221")
{
	return 1;
}
else
{
	return $smtpResponse;
}
}





if($auth=="spaghetti")
{
	$out=authSendEmail($to,$subject,$body);
}
echo $out;




?> 

 