<?php
clearstatcache();
$url="http://www.asecular.com";

//$handle= fopen($url, "r");

//$arr=fstat($handle);
//foreach($arr as $k=>$v)
{
	//echo $k . " ". $v . "<BR>";
}
//$content=fread( $handle, filesize($url));
$content= file_get_contents($url);
echo $content;

?>
