<?php

		
function footer()
{
	include('footer.php');
}
 
function genericheader($bodyheadallow=true)
{
	?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Strict//EN">
	<html>
	<head><title><?=sitename?></title>
	<script language="javascript" src="site/scripts/mouseover.js" type="text/javascript"></script>
	<?php
	if ($bodyheadallow)
	{
		?>
		<link rel="stylesheet" href="styles.css" type="text/css">
		</head>
		<body  marginwidth="0" leftmargin="0" marginheight="0" topmargin="0" background="images/uglybxbg.jpg">
		<?php
	}

}
 
	
 
function pagetop($type="headersuppress" )
{
	GLOBAL $extracontent;
	GLOBAL $leftnavcontent; 
	GLOBAL $intOurLoginID;
	GLOBAL $intOurOfficeID;
	GLOBAL $intOurClientID;
	GLOBAL $mode;
	GLOBAL $error;
	$rightsuppress=false;
	$bodyheadsuppress=false;
	
	if($type=="headersuppress" || $type==true)
	{
		$bodyheadsuppress=true;
	}
	if($type=="headerrightsuppress")
	{
		$rightsuppress=true;
	}
	genericheader($bodyheadsuppress);
	
	
	 //2=newcomers
	 //
 
 
 
	
	
	include("topnav.php");
	 
	 
	if(!$leftsuppress)
	{
	
	
	 
	}
	 
 	echo " <div style=\"width:100%; \">";
 	echo " <div style=\"width:870px; margin:0px auto   \"> ";
}	

 
 function pagebottom() 
 { 
 ?> 
 
 
 	</div>
	</div>
	
 <?  footer(true) ?> 
 
  
  
 </body> 
 </html> 
  
 <?php


}
?>