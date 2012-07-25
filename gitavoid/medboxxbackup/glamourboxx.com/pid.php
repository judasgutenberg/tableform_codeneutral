<?php

function readHTTPDigestAuthenticatedFile($host,$file,$username,$password)
{
    if (!$fp=fsockopen($host,80, $errno, $errstr, 15))
        return false;
       
    //first do the non-authenticated header so that the server
    //sends back a 401 error containing its nonce and opaque
    $out = "GET /$file HTTP/1.1\r\n";
       $out .= "Host: $host\r\n";
       $out .= "Connection: Close\r\n\r\n";

     fwrite($fp, $out);

    //read the reply and look for the WWW-Authenticate element
    while (!feof($fp))
    {
        $line=fgets($fp, 512);
       
        if (strpos($line,"WWW-Authenticate:")!==false)
            $authline=trim(substr($line,18));
    }
   
    fclose($fp);
      
    //split up the WWW-Authenticate string to find digest-realm,nonce and opaque values
    //if qop value is presented as a comma-seperated list (e.g auth,auth-int) then it won't be retrieved correctly
    //but that doesn't matter because going to use 'auth' anyway
    $authlinearr=explode(",",$authline);
    $autharr=array();
   
    foreach ($authlinearr as $el)
    {
        $elarr=explode("=",$el);
        //the substr here is used to remove the double quotes from the values
        $autharr[trim($elarr[0])]=substr($elarr[1],1,strlen($elarr[1])-2);
    }
   
    foreach ($autharr as $k=>$v)
        echo("$k ==> $v\r\n");
   
    //these are all the vals required from the server
    $nonce=$autharr['nonce'];
    $opaque=$autharr['opaque'];
    $drealm=$autharr['Digest realm'];
   
    //client nonce can be anything since this authentication session is not going to be persistent
    //likewise for the cookie - just call it MyCookie
    $cnonce="sausages";
   
    //calculate the hashes of A1 and A2 as described in RFC 2617
    $a1="$username:$drealm:$password";$a2="GET:/$file";
    $ha1=md5($a1);$ha2=md5($a2);
   
    //calculate the response hash as described in RFC 2617
    $concat = $ha1.':'.$nonce.':00000001:'.$cnonce.':auth:'.$ha2;
    $response=md5($concat);
   
    //put together the Authorization Request Header
    $out = "GET /$file HTTP/1.1\r\n";
       $out .= "Host: $host\r\n";
    $out .= "Connection: Close\r\n";
    $out .= "Cookie: cookie=MyCookie\r\n";
    $out .= "Authorization: Digest username=\"$username\", realm=\"$drealm\", qop=\"auth\", algorithm=\"MD5\", uri=\"/$file\", nonce=\"$nonce\", nc=00000001, cnonce=\"$cnonce\", opaque=\"$opaque\", response=\"$response\"\r\n\r\n";
   
    if (!$fp=fsockopen($host,80, $errno, $errstr, 15))
        return false;
   
    fwrite($fp, $out);
   
    //read in a string which is the contents of the required file
    while (!feof($fp))
    {
        $str.=fgets($fp, 512);
    }
   
    fclose($fp);
   
    return $str;
}


function URLopen($url)
{
        // Fake the browser type
        ini_set('user_agent','MSIE 4\.0b2;');

        $dh = fopen("$url",'r');
        $result = fread($dh,8192);                                                                                                                            
        return $result;
} 
$site="medboxx.com";
$file="tasks.php";
$user="tester";
$pwd="rooster12";
echo URLopen("http://" . $user . ":" . $pwd. "@" . $site . "/" . $file); 
echo "<p>--<p>";
//echo readHTTPDigestAuthenticatedFile($site,$file,$user,$pwd)
//fopen("http://medboxx.com/tasks.php", "r");
?>
 
	
	
