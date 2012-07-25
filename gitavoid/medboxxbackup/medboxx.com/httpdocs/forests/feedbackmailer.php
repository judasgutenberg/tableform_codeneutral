<?php 

//$to_email_address - received from the "POST" 
//$from_email_address - ditto 
//$subject 
//$message 

// 
//First, validate the addresses using Jons' function 
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
 
$Email=preprocessHeaderField($_REQUEST["Email"]);
$Name=preprocessHeaderField($_REQUEST["Name"]);
$Body=$_REQUEST["Body"];
$Subject=preprocessHeaderField($_REQUEST["Subject"]);


$refer= substr(strtolower($_SERVER["HTTP_REFERER"]),0,24) ;
//echo $refer;
// 
//Second, test the results and send the message or display 
//an error 
// 



if ($refer=="http://www.asecular.com/" || $refer=="http://asecular.com/fore")
{
if (strlen($Body)>3)
{


 	mail("tetraphis@yahoo.com","site feedback: " . $Subject,$Body . chr(13) . $Email . " (" . $Name . ")", "From: " . $Email . "\r\n"

    ."Reply-To: " . $Email . "\r\n"
    ."X-Mailer: PHP/" . phpversion());
	
	 	mail("gus@asecular.com","RF site feedback: " . $Subject,$Body . chr(13) . $Email . " (" . $Name . ")", "From: " . $Email . "\r\n"

    ."Reply-To: " . $Email . "\r\n"
    ."X-Mailer: PHP/" . phpversion());
	
	//$f=fopen("adoptioninquiries/".str_replace( "@", "~", $Email).".txt", 'a');
	//fwrite($f, "[".$Email."]\n".$mb);
	//fclose($f);
	
}

}
	header("location: feedback.php?thanks=thanks");




?> 

