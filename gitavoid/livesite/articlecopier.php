<?php
$strPathPre="tf/";
include_once($strPathPre . "fw_functions.php");
$urlroot="http://www.featurewell.com/";
include($strPathPre . "tf_constants.php");
include($strPathPre . "tf_functions_core.php");
include($strPathPre . "tf_functions_editor.php");
include($strPathPre . "tf_functions_frontend_db.php");
include_once($strPathPre . "tf_functions_odbc.php");
//ini_set ('odbc.defaultlrl','165536');
set_time_limit(900);
 
echo   main();

 


function main()
{
	global $db_type;
	$sql=conDB();
	$article_id=$_REQUEST["id"];
	//echo $article_id;
	$db_type= 'odbc';
	$strSQL="SELECT TEXT FROM dbo.ARTICLE WHERE ID=" . $article_id;
	$records=$sql->query($strSQL, true, 'dbo');
	$db_type="";
	$record=$records[0];
	//var_dump($record);
	$out=$record["TEXT"];
	return $out;
}

 

	

 


    ?>
