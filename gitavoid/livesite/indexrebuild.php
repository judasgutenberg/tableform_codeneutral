<?php
include("tf/core_functions.php");
include("tf/tableform_functions.php");
include("tf/frontenddbfunctions.php");
include("tf/tf_constants.php");
include("tf/odbcfunctions.php");
include("tf/backup_functions.php");
include("tf/fw_functions.php");
$errorlevel=error_reporting(0);
include("editor_files/config.php");
include("editor_files/editor_class.php");
set_time_limit(22);
error_reporting($errorlevel);
$urlroot="http://www.featurewell.com/";

/*
indexes on article:
show indexes from article

recreating fulltext indexes:
alter table article drop index ft_text
create fulltext index ft_text  ON  article(TEXT)
drop  index ft_writer  on article
create fulltext index ft_writer  ON  article(FT_WRITER)
alter table article drop index ft_title
create fulltext index ft_title  ON  article(TITLE)

OR
 
REPAIR TABLE article QUICK;
*/

//the task_type for a FT index rebuild is 1
$sql=conDB();
$nowhour=intval(date("G", time()));
if($nowhour>1 && $nowhour<5)
{
	$strSQL="SELECT * FROM " . our_db . ".server_task WHERE task_type=1 ORDER BY datetime_done DESC LIMIT 0,1";
	$records = $sql->query($strSQL);
	$record=$records[0];
	$datetime_done=$record["datetime_done"];
	$dtmDone=strtotime($datetime_done);
	$diffinhours=( time()-$dtmDone)/3600;
	
	if($diffinhours>18 )
	{
		UpdateOrInsert(our_db, "server_task", "", Array("task_type"=>1, "datetime_done"=> date("Y-m-d H:i:s")));
		$strSQL="REPAIR TABLE " . our_db . ".article QUICK";
		$records = $sql->query($strSQL);
	}
}
echo "nowhour:" .  $nowhour . " " . date("Y m d H:i:s", $dtmDone) . "-------" . date("Y m d H:i:s",time());

//$strSQL="REPAIR TABLE article QUICK";
//$records = $sql->query($strSQL);

 ?>