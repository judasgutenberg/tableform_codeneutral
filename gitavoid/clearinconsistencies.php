<?php

include_once('tf_functions_core.php');
include_once('tf_functions_backup.php');
include_once('tf_functions_sql_parsing.php');
include_once('tf_functions_frontend_db.php');
?>

<html>
<head>
<title>clear inconsistencies</title>
<link rel="stylesheet" href="tf.css" type="text/css">
</head>
<body>
 
 

 
 
 
<?php
$out=LoginDecisions($strDatabase,  $strPHP, $strUser, false, "nobottomnav");
$intAdminType= AdministerType($strDatabase,"", $strUser);
		
if ($intAdminType<2)
{
	die("insufficient permissions");

}
$breadcrumbparams=Array( false, "HFJ Comparator", "comparator.php", "Clear Inconsistencies");

 
 
$out=str_replace("databases", "",  call_user_func_array("adminbreadcrumb", $breadcrumbparams)) ;
$out.= "<h2>Clear Inonsistencies</h2>";
$out.= "<p/>";
$out.= "<span class='topnav_notselected'>[<a onclick='return(confirm(\"Are you sure you want to clear Users Inconsistencies?  To calculate them again you will  have to rerun the comparison scans.  You will also lose your notes.\"))' href=\"comparator.php?tabledest=Users&action=clearinconsistencies\">Clear Users Inconsistencies</a>]</span> ";
$out.= "<p/>";
$out.= "<span class='topnav_notselected'>[<a onclick='return(confirm(\"Are you sure you want to clear Orders Inconsistencies?  To calculate them again you will  have to rerun the comparison scans.  You will also lose your notes.\"))' href=\"comparator.php?tabledest=Orders&action=clearinconsistencies\">Clear Orders Inconsistencies</a>]</span> ";

 echo $out;
 ?>


</body>
</html>