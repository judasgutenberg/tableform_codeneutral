<?php
include('tf/tf_functions_core.php');
include('tf/tf_core_table_creation.php');

$sql=conDB();
//get the q parameter from URL
$q=$_GET["q"];
$table=$_GET["table"];
$returnid=$_GET["returnid"];
$returntextfield=$_GET["returntextfield"];
if($table=="article")
{
	$searchfield="TITLE";

}
else if($table=="USERS")
{
	$searchfield="EMAIL";
}
//lookup all links from the xml file if length of q>0
if (strlen($q)>0)
{
	$hint="";
	$records=$sql->query("SELECT * FROM " . $table ."  WHERE " . $searchfield . " LIKE '" . $q . "%'");
	foreach($records as $record)
	{
		$hint=$hint . "<a href='#' onclick='PopPopper(\"" . $returntextfield . "\",\"" . singlequoteescape($record[$searchfield]) . "\",\"" . $record["ID"].  "\",\""  . $returnid . "\");return false'  target='_blank'>" . singlequoteescape($record[$searchfield]) . "</a><br />";
	}
}

// Set output to "no suggestion" if no hint were found
// or to the correct values
if ($hint=="")
{
  $response="no suggestion";
}
else
{
  $response=$hint;
}
//output the response
echo $response;
?> 
