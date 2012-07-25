<?php
$strPathPre="tf/";
include_once($strPathPre . "fw_functions.php");
$urlroot="http://www.featurewell.com/";
include_once($strPathPre . "tf_constants.php");
include_once($strPathPre . "tf_functions_core.php");
include_once($strPathPre . "tf_functions_editor.php");
include_once($strPathPre . "tf_functions_frontend_db.php");
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
	
		UpdateOrInsert(our_db, "mailing",Array("mailing_id"=>$mailing_id), Array("clickthrough_count"=>$clickthrough_count+1),  true,  false,  true);
		
		UpdateOrInsert(our_db, "mailing_click", "", Array("mailing_id"=>$mailing_id, "article_id"=>$article_id, "user_id"=>$user_id, "time_of_click"=>$nowSQLtime),  true,  false,  true);
	}
	header("location: /article.php?ID=" . $article_id);
}

    ?>