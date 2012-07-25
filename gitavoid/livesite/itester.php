<?php
$strPathPre="tf/";
include_once($strPathPre . "fw_functions.php");
$urlroot="http://www.featurewell.com/";
include($strPathPre . "tf_constants.php");
include($strPathPre . "tf_functions_core.php");
include($strPathPre . "tf_functions_editor.php");
include($strPathPre . "tf_functions_frontend_db.php");
include_once($strPathPre . "tf_functions_odbc.php");

 
 
echo   main();

 


function main()
{
	$raw= $_SERVER['QUERY_STRING'];
 
	$arrRaw=explode(".", $raw);
	$article_id=$arrRaw[0];
	$user_id=$arrRaw[1];
	$mailing_id=$arrRaw[2];
	$nowSQLtime=date("Y-m-d H:i:s");
	//increment clickthrough count
	$record=GenericDBLookup(our_db,"mailing", "mailing_id", $mailing_id, "");
	$last_user_id_done=$record["last_user_id_done"];
	$mailing_count=$record["mailing_count"];
	$mailing_date=$record["mailing_date"];
	$mailing_id_out=$record["mailing_id"];
	$thismailingcompleted=$record["completed"];
	$clickthrough_count=$record["clickthrough_count"];
	$subject=$record["subject"];
	$body_extra=$record["body_extra"];
	if($mailing_id_out!="" )
	{
	 
		 echo "mailing_id_out: " .  $mailing_id_out . "<BR>";
		 
		  echo "user_id: " .  $user_id . "<BR>";
		   echo "article_id: " .  $article_id . "<BR>";
		    echo "mailing_id: " .  $mailing_id . "<BR>";
	}
	 
}

    ?>