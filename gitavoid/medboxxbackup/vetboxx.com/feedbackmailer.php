<?include("core_functions.php")?><?

//$to_email_address - received from the "POST" 
//$from_email_address - ditto 
//$subject 
//$message 

 
// 
 
function preprocessHeaderField($value)
{
  //Remove line feeds
  $ret = str_replace("\r", "", $value);
  $ret = str_replace("\n", "", $ret);

  // Remove injected headers
  $find = array("/bcc\:/i", 
                "/Content\-Type\:/i", 
                "/Mime\-Type\:/i", 
                "/cc\:/i", 
                "/to\:/i");
  $ret = preg_replace($find, 
                      "**bogus header removed**",
                      $ret);

  return $ret;
}

// 
//Second, test the results and send the message or display 
//an error 
// http://www.asecular.com/ran/feedback.php?subject=

$refer= substr(strtolower($_SERVER["HTTP_REFERER"]),0,24) ;
$datearray=getdate(time());
$monthname=$datearray["month"];
$prefix=$_REQUEST["prefix"]; 

$Email=preprocessHeaderField($_REQUEST["Email"]);
$Name=preprocessHeaderField($_REQUEST["Name"]);
$Body=preprocessHeaderField($_REQUEST["Body"]);
$Subject=preprocessHeaderField($_REQUEST["Subject"]);

setcookie("RealName",$Name, time()+1131536000);
setcookie("Email",$Email, time()+1131536000);

setcookie("ipaddress", $_SERVER["REMOTE_ADDR"]);

//logEmail($Email);
if ($refer=="http://www.". strtolower(sitename) ."/" || $refer=="http://". strtolower(sitename) ."/")
{
if (strlen($Body)>3 && strpos($Email, ": ")<1 && strpos($Name, ": ")<1 && strpos($Email, chr(13))<1 && strpos($Name, chr(13))<1  )
{
//if (strpos($Email, "@")>0)


{
$testbody=ltrim($Body);
$testbody=rtrim($testbody);
if (strpos($testbody, " ")>0)
{
	if (strpos($testbody, "Content-Type:")<1)
	{

 		mail("denniso@standardsourcemedia.com","site feedback: " . $Subject,$Body , "From: " . $Name . "<" . $Email . ">\r\n"
    ."Reply-To: " . $Email . "\r\n"
    ."X-Mailer: PHP/" . phpversion());
	//$f=fopen("adoptioninquiries/".str_replace( "@", "~", $Email).".txt", 'a');
	//fwrite($f, "[".$Email."]\n".$mb);
	//fclose($f);
		}
}
}
}
}
header("location: contact.php?message=thanks");




?> 


