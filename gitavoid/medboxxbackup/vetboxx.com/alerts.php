<?php
define('IN_PHPBB', true);
$title="Medboxx : Home";
//include("header.php");
 //include("includes/bbcode.php");
  //include("includes/db.php");
  
 include("header.php");
 
define('IN_PHPBB', true);
$title="Medboxx : Home";
//include("header.php");
 //include("includes/bbcode.php");
  //include("includes/db.php");
  
  
//open a connection to mysql db

 
//
// Set page ID for session management
//
//$userdata = session_pagestart($user_ip, PAGE_LOGIN);
//init_userprefs($userdata);
 

 
$sql=conDB();
 
 
$strPHP=$_SERVER['PHP_SELF'];
 
?>
<html>
<head>		
<link rel="stylesheet" href="styles.css" type="text/css">
</head>
<body style="background-color:#E8CACA">

<?
 




 
include("calendar_functions.php");
include("questionnaire_functions.php");

 
//place for content!!!


 
if($intOurLoginID=="")
{
 
}
else
{

	if($bwlOffice)
	{
	 //maybe show an alert
	 ?>
	 <img src="images/newreg.png" width="43" height="50" alt=""> <span class="alert">New Registrations!</span>
	 <a href=view.php?<?=qpre?>table=client&is_office=0  target=_top><img src="images/view_red.png" width="53" height="23" alt="" border="0"></a>
	 <?
	}
	else
	{
 
	}
}

 

 
 
 
	
	
	
	
	
	?>

	
	
	

</body>
</html>
<?
	
	
	

 
 
 
 
