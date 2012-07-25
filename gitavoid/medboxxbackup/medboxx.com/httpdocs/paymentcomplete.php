<?php

define('IN_PHPBB', true);
$title="Medboxx : Home";
//include("header.php");
 //include("includes/bbcode.php");
  //include("includes/db.php");
  
include("header.php");
include("calendar_functions.php");

logcollection(true, $_REQUEST );
ChangeActiveState($intOurLoginID, 1);//set inactive until paid up!
SetFrontEndCookie($intOurLoginID);
header("location: index.php");
?>
	
	
	
