<?php

define('IN_PHPBB', true);
$title="Medboxx : Home";
//include("header.php");
 //include("includes/bbcode.php");
  //include("includes/db.php");
  
 include("header.php");
 
 // echo "-" . $intOurLoginID . "-" ;
 
//open a connection to mysql db

 
//
// Set page ID for session management
//
//$userdata = session_pagestart($user_ip, PAGE_LOGIN);
//init_userprefs($userdata);

$sql=conDB();
 //echo phpinfo();
//echo $intOurLoginID . "_______" ;
$membername=GenericDBLookup(our_db,"bb_user", "user_id", $intOurLoginID, "username");
$cookiename=GenericDBLookup(our_db,"bb_config", "config_name", "cookie_name", "config_value");
$strPHP=$_SERVER['PHP_SELF'];
$datecode=$_REQUEST["datecode"];
//$intOurOfficeID=$_REQUEST["office_id"];
$practitioner_id=$_REQUEST["practitioner_id"];




include_once("frontend.php");
include("calendar_functions.php");
include("questionnaire_functions.php");

pagetop("headersuppress", "Home"  );
//place for content!!!
$tablength=120;
$tabtitle="" . date("l F jS, Y", makedate($datecode));
?>
 <script language="javascript" src="tf.js" type="text/javascript"><!-- --></script>
<script language="javascript" src="tf_tablesort.js" type="text/javascript"><!-- --></script>
			<!--<div id="idblanktablabel" style="background-image:url('images/blankredtabtop_<?=$tablength?>.png');width:595px;height:28px; font-family:helvetica, arial;color:#ffffff;font-weight:bold;font-size:16px; text-indent:0px;line-height:180%">&nbsp;&nbsp;&nbsp;<span style="font-size:23px"><?=$tabtitle?></font></div>
			-->
  			<div id="infoheader"> </div>
            <div id="infocontent"> 
			
			
		 	<?
			$strLabel="<a href='index.php'>Schedule</a> | " . "Day view for " . date("l F jS, Y", makedate($datecode)) ;
			
			$dayview=DayView($intOurOfficeID, $datecode, $practitioner_id, 650);
			echo "<div class='header'>&nbsp;&nbsp;&nbsp;&nbsp;" .$strLabel . "</div>";
			echo "<center>";
			echo $dayview;
			if($dayview=="")
			{
				echo "There are no appointments scheduled for this day.";
			}
			?>
			</center>
			<div class="info">
			<?if($error!="")
			{
			?>
			<div class="error"><?=$error?></div>
			<?	
			}
			?>
		 
			
			
			
			</div>
			
			
	
			</div>
            <div id="infofooter"> </div>  
			
 

	
	
	
	 <br/><br/>
	

 
 
<?pagebottom();  ?>
 
 
 
