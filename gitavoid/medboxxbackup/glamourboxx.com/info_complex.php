<?php

define('IN_PHPBB', true);
$title="Medboxx : Home";
//include("header.php");
 //include("includes/bbcode.php");
  //include("includes/db.php");
  
 include("header.php");
  
//open a connection to mysql db

 
//
// Set page ID for session management
//
//$userdata = session_pagestart($user_ip, PAGE_LOGIN);
//init_userprefs($userdata);
 

 
$sql=conDB();
 //echo phpinfo();
$intOurLoginID=GetFrontEndLoginID();
//echo $intOurLoginID . "_______" ;
$membername=GenericDBLookup(our_db,"bb_user", "user_id", $intOurLoginID, "username");
$cookiename=GenericDBLookup(our_db,"bb_config", "config_name", "cookie_name", "config_value");
$strPHP=$_SERVER['PHP_SELF'];
$intStartRecord=$_REQUEST["r"];
$recsperpage=14;

$config=$_REQUEST["config"];

if($config=="special")
{
	$config=whatwedoconfig;
}	



include_once("frontend.php");
 
include("calendar_functions.php");
include("questionnaire_functions.php");

pagetop("headersuppress", "Home"  );
//place for content!!!

$out="";
$arrConfig=explode(" ", $config);
$outcount=0;
$totalcount=count($arrConfig)-1;
$bgtype="";
$oldbgtype="";
for($i=0; $i<count($arrConfig); $i++  ) 
{

	$item=$arrConfig[$i];
	//echo $item . " " . $i . "<BR>";
	$itemnext="";
	$bgtypenext="";
	if($i<count($arrConfig)-1)
	{
		
		$itemnext=$arrConfig[$i+1];
		$arrItemnext=explode("|", $itemnext);
 
		$bgtypenext=trim($arrItemnext[0]);
		$contentkeynext=trim($arrItemnext[1]);
		
	}
	$arrItem=explode("|", $item);
	$contentkey=trim($arrItem[1]);
	$content=trim(DisplayContent($contentkey));
	if($content!="")
	{
	
	$oldbgtype=$bgtype;
	$bgtype=trim($arrItem[0]);
	//echo $i ." " . $bgtypenext . " " . $bgtype . "<br>";
	
	
 	

		$bgclass="onpinkinfo";
		$width="701";
	 
		if($bgtype=="p")
		{
			$thisbgpic="701pinkybg.png";
			$bgclass="onpinkinfo";
		}
		else if($bgtype=="r")
		{
			$thisbgpic="redbg.png";
			$bgclass="onredinfo";
		}
		
		else  if($bgtype=="w")
		{
			$thisbgpic="redboxbg.png";
			$bgclass="onwhiteinfo";
		}
		else  if($bgtype=="")
		{
			$thisbgpic="";
			$bgclass="onwhiteinfo";
			$closingdiv="";
		}
		if($oldbgtype=="r" && $bgtype=="w")
		{
			$divtype="rw";
		}
		if($oldbgtype=="r" && $bgtype=="p")
		{
			$divtype="rp";
		}
		if($oldbgtype=="" && $bgtype=="w")
		{
			$divtype="wt";
		}
		if($oldbgtype=="" && $bgtype=="r")
		{
			$divtype="rt";
		}
		else if($oldbgtype=="" && $bgtype=="p")
		{
			$divtype="pt";
		}
		else if ($bgtype=="w"  && $oldbgtype=="w")
		{
			$divtype="ww";
		}
		else if ($bgtype=="p"  && $oldbgtype=="p")
		{
			$divtype="pp";
		}
		else if ($bgtype=="w"  && $oldbgtype=="p")
		{
			$divtype="wp";
		}
		else if ($bgtype=="p"  && $oldbgtype=="w")
		{
			$divtype="pw";
		}
		$closingdiv="";
		if($outcount==$totalcount || $bgtypenext=="")
		{
			if($bgtype=="p")
			{
				$closingdiv="\n<div style=\"width:" . $width . "px;height:19px;background-image:url('images/redbotforpink.png')\"> </div>";;
				
			}
			else if($bgtype=="r")
			{
				$closingdiv="\n<div style=\"width:" . $width . "px;height:19px;background-image:url('images/solidredbot.png')\"> </div>";;
				
			}
			else if($bgtype=="w")
			{
				$closingdiv="\n<div style=\"width:" . $width . "px;height:19px;background-image:url('images/redbot.png')\"> </div>";;
			
			}
		
		}
		//echo $bgclass . "<br>";
		if($divtype=="rt")
		{
			$divpicname="redtopsolid.png";
			$height=16;
		}
		if($divtype=="wt")
		{
			$divpicname="redtop2.png";
			$height=16;
		}
		if($divtype=="rw")
		{
			$divpicname="redmiddle-redabovewhitebelow.png";
			$height=23;
		}
		else if  ($divtype=="pt")
		{
			$divpicname="pinktop.png";
			$height=16;
		}
		else if  ($divtype=="pw")
		{
			
			$divpicname="redmiddle-whiteabovepinkbelow.png";
			$height=23;
		}
		else if  ($divtype=="rp")
		{
			
			$divpicname="redmiddle-redabovepinkbelow.png";
			$height=23;
		}
		else if  ($divtype=="wp")
		{
			$divpicname="redmiddle-pinkabovewhitebelow.png";
			$height=23;
		}
		else if  ($divtype=="ww")
		{
			$divpicname="redmiddle-whiteabovewhitebelow.png";
			$height=23;
		}
		else if  ($divtype=="pp")
		{
			$divpicname="redmiddle-pinkabovepinkbelow.png";
			$height=23;
		}
		else if  ($divtype=="pb")
		{
			$divpicname="redmiddle-pinkabovepinkbelow.png";
			$height=19;
		}
		else if  ($divtype=="wb")
		{
			$divpicname="redbot.png";
			$height=19;
		}
		//echo $bgtype . " " . $oldbgtype . " " . $divtype . " " . $divpicname . "<br>";
		//background-image:url('images/whitehomepagebg.png');background-repeat:repeat-y
		 if($thisbgpic!=="")
		{
			$out.= "\n<div style=\"width:" . $width . "px;height:" .$height  . "px;background-image:url('images/". $divpicname . "')\" ><img src='images/spacer.png' width='" . $width . "' height='" .$height  . "'></div>";
	  
	 		$out.= "\n<div style=\"width:" . $width . "px;background-image:url('images/". $thisbgpic . "');background-repeat:repeat-y\"> <div class=\"" . $bgclass . "\">";
		}
		
		$out.= $content;
		if($thisbgpic!=="")
		{
			$out.="</div></div>";
		}
		$out.=$closingdiv;
	}
	$outcount++;
 
}

echo $out;
?>

 
 





	
	
	
	
	
	
	

 
 
<?pagebottom();  ?>
 
 
 
