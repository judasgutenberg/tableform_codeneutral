<?php

$strPathPre="";
$urlroot="http://www.medboxx.com/";
include($strPathPre . "tf_constants.php");
include($strPathPre . "tf_functions_core.php");
include($strPathPre . "tf_functions_editor.php");
include($strPathPre . "tf_functions_frontend_db.php");
include($strPathPre . "tf_functions_odbc.php");
include($strPathPre . "tf_functions_backup.php");
include($strPathPre . "calendar_functions.php");
 
$errorlevel=error_reporting(0);
error_reporting($errorlevel);
$strDatabase=our_db;
$sql=conDB();
//how shit arrives: a:1:{s:4:"data";s:82:'{"tag":"medboxx_box.20","disposition":"ANSWERED","vm":0,"duration":17}';}
//logcollection($bwlMakeTableIfNecessary=true, $collection, $label="", $comments="")
logcollection(true, $_REQUEST, "postback", "");
//sample data: data =>"{"tag":"tester","disposition":"ANSWERED","vm":0,"duration":11}"
//echo urlencode('a:1:{s:4:"data";s:82:"{"tag":"medboxx_box.20","disposition":"ANSWERED","vm":0,"duration":17}";}') . "<BR>";
$data= str_replace("\\", "", $_REQUEST["data"]);
//$data= str_replace('"', "'", $data);
//echo $data . "<BR>";
$arrData=json_decode( $data );
//var_dump($arrData);
$tag=$arrData->tag;
$disposition=$arrData->disposition;
$duration=$arrData->duration;
$vm=$arrData->vm;
$arrTag=explode(".", $tag);
$databasetouse=$arrTag[0];
$phone_call_id=$arrTag[1];
$phonecall_status_id=7;
$bwlRedial=false;
$nowSQLtime=date("Y-m-d H:i:s");
$minutesinthefuturetotry=30;
//echo $nowSQLtime . "<BR>";
//echo $timefutureSQLtime. "<BR>";

if($disposition=="ANSWERED")
{
 
	$phonecall_status_id="3";
}
else if($disposition=="BUSY")
{
 
	//$phonecall_status_id="4";
	$phonecall_status_id="1";
	$bwlRedial=true;
	$minutesinthefuturetotry=20;
}
else if($disposition=="NO ANSWER")
{
 
	//$phonecall_status_id="5";
	$phonecall_status_id="1";
	$bwlRedial=true;
	$minutesinthefuturetotry=15;
}
else if($disposition=="CHANUNAVAIL")
{
 
	//$phonecall_status_id="6";
	$phonecall_status_id="1";
	$bwlRedial=true;
	$minutesinthefuturetotry=60;
}
else
{
	//$phonecall_status_id="7";
	$phonecall_status_id="1";
	$bwlRedial=true;
 	$minutesinthefuturetotry=60;
}

$minutesinthefuturetotry=$minutesinthefuturetotry + mt_rand(0,20);//mix up the callback time a little with some randomness

$timefutureSQLtime=date("Y-m-d H:i:s", AddUnitToDate(time(), $minutesinthefuturetotry, "i"));
////a:1:{s:4:"data";s:82:"{"tag":"medboxx_box.20","disposition":"ANSWERED","vm":0,"duration":17}";}
//echo $databasetouse;
if( inList(our_db . " dayboxx vetboxx",  $databasetouse))
{
	//echo "UPDATE " . $databasetouse . ".phone_call SET completed='" . $completed . "' WHERE phone_call_id='" . $phone_call_id ."'";
	if($bwlRedial)
	{
		//if it's a redial, we will try again in fifteen minutes
		$sql->query("UPDATE phone_call SET time_to_start='" . $timefutureSQLtime . "', phonecall_status_id='" . $phonecall_status_id . "'   WHERE phone_call_id='" . $phone_call_id ."'", "gusstyle", $databasetouse);
	}
	else
	{
		$sql->query("UPDATE phone_call SET phonecall_status_id='" . $phonecall_status_id . "'   WHERE phone_call_id='" . $phone_call_id ."'", "gusstyle", $databasetouse);
	}
}
 ?>
 ok