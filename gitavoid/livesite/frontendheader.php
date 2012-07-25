<?php
//die( $_SERVER["HTTP_USER_AGENT"]);


 
 
 
 
 
//fuck how i hate CHROME!!!
 
$droppants=-4 ;
if(contains($_SERVER['HTTP_USER_AGENT'], "Chrome"))
{
 	
	$droppants=-5;
}

$buypixeldelta=80;
$vertlen=25;
$pagetitle="Featurewell.com - Syndication Worldwide";

$baseheightforbuynow=264
?>


<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
	<LINK REL="SHORTCUT ICON" href="http://www.featurewell.com/favicon.ico" />
	<LINK REL="alternate" type="application/rss+xml" title="RSS" href="http://www.featurewell.com/rss.php" />
	<META name="Description" CONTENT="Featurewell.com syndicates top journalists to newspapers, magazines and web sites around the world."/>
	<META name="Keywords" CONTENT="Featurewell, NYC, NY, New York, Syndicate, Syndication, Article, journalism, reprint, copyright, second rights, feature, media, press, news, reporter, stringer, correspondent, reportage, literary agency, writer, newspaper, magazine, editor, editorial, content, story, narrative, non-fiction, publish, publication, commentary, information, dispatch, byline, broadsheet, journal, deadline, Herald, Times, resell,Mochila, Mochilla, New York Times and Tribune Media Services, Creators, United Media, Low cost, discount"/>
	<META name="VERSION" CONTENT="<?=date('F Y')?>"/>
	<META http-equiv="Pragma" CONTENT="no-cache"/>
	<META http-equiv="Expires" CONTENT="Now"/>



<title><?=$pagetitle?></title>
<link rel="stylesheet" href="styles.css">

</head>
<body>
<?php
if(1==2)
{
if(contains(strtolower($_SERVER['HTTP_USER_AGENT']), "safari"))
{
 	?>
<div id='whitefixer' style='background-color:#ffffff;position:absolute;top:125px;left: 169px;width:7px;height:12px;  z-index:2211;'></div>
<?
}

//glitch management: how i hate my life!
else if(!contains($_SERVER['HTTP_USER_AGENT'], "Chrome")  && !contains($_SERVER['HTTP_USER_AGENT'], "MSIE"))
{
 	?>
<div id='whitefixer' style='background-color:#ffffff;position:absolute;top:126.5px;left: 169px;width:5px;height:10px;  z-index:1;'></div>
<?
}
}
?>
<div id='buynow' style='background-image:url(images/buynow.png);position:absolute;top:<?=intval($baseheightforbuynow + $buypixeldelta) ?>px;left: 642px;width:267px;height:42px;  z-index:3;display:none'>
</div>

<!--
<div id='buynowhoriz' style="height:2px; line-height:0;font-size:0px;padding:0;margin:0;background-color:#ffffff;position:absolute;top:<?=intval($baseheightforbuynow+39 +$vertlen + $buypixeldelta )?>px;left:782px;width:1px;z-index:35;display:none "></div>
<div id='buynowvert' style='background-color:#ffffff ;position:absolute;top:<?=intval($baseheightforbuynow+42 + $buypixeldelta) ?>px;left: 782px;width:2px;height:<?=intval($vertlen )?>;  z-index:3;display:none'></div>
-->

<div style="margin-bottom:0px; height:136px; "><a href="<?=$homepage?>"><img src="images/HeaderSmaller.png"  alt="Featurewell.com Syndication" border="0"  ></a>

<?php
//sign in indication:

if($strUser=="")
{
	
	echo "<a href='signin.php?mode=login&login_dest="  . urlencode($strLocation) . "''><img style='margin-left:-6px;margin-top:-12px' id='g1' src='images/SignInButton.png' border='0' alt='signin'></a>";
}
else
{
	
	echo "<a href='signin.php?mode=logout&login_dest="  . urlencode($strLocation) . "'><img  style='margin-left:-6px;margin-top:-12px''  id='g1'  src='images/SignOutButton.png' border='0' alt='signout'></a>";
	echo "<div class='welcomeuser' style='	position: absolute;top: 20px;left: 660px; z-index: 100; background-color:#F78320; width:320px; height:24px;   '>Welcome " . $user["FIRST_NAME"] . " " . $user["LAST_NAME"] . " </div>";
}


?>
</div>
<?
function NavBar($placement)
{
	GLOBAL $user;
	$strStyleAdditional=" ";
	if(contains(strtolower($_SERVER['HTTP_USER_AGENT']), "msie"))
	{
		$strStyleAdditional=" margin-top:-4px;";
	}
	if($placement==2)
	{	//hackety hack!!!!
		$strStyleAdditional=" margin-top:10px; margin-left:-182px; position: absolute; top:2000px; left:0px";
		
	}
	$bgimage="MenuBarTop.png";
	$strConfig="register.0|aboutus.0|faq.1|press.1|partners.1|writers.1|submissions.1|contact.-1|my_account";
	if($user["ID"]>0)
	{
		$bgimage="MenuBarTop_li.png";
		$strConfig="bookmarks.0|aboutus.0|faq.1|press.1|partners.1|writers.1|submissions.1|contact.-1|my_account";
	}
	$out="<div id='nav" . $placement . "' style=\"background-image:url(images/" . $bgimage . ");background-repeat:no-repeat;width:972px;height:36px; " . $strStyleAdditional . "\">\n";
	
	$arrConfig=explode("|", $strConfig);
	$outcount=1;
	foreach($arrConfig as $thisconfig)
	{
		$arrThisconfig=explode(".", $thisconfig);
		$thisconfig=$arrThisconfig[0];
		$marginleft=$arrThisconfig[1];
		$out.="<a id=\"a" . $outcount . "-" . $placement . "\"><img id=\"m" . $outcount . "-" . $placement . "\" src=\"images/o_" . $thisconfig  . ".png\"  alt=\"" . $thisconfig . "\" border=\"0\" style='margin-left:" . $marginleft . "px'></a>";
		$outcount++;
	}
	if($placement==2)
	{
		$out.="<div class=\"copyright\">";
		$out.="COPYRIGHT &copy;2000-" . date(Y) . " FEATUREWELL.COM ALL RIGHTS RESERVED." ;
		
		$out.=" </div>";
	}
	$out.="</div>";
	

	
	return $out;
}

echo NavBar(1);
//echo $_SERVER['HTTP_USER_AGENT'];
?><div style="float:left; width:182px;height:910px;background-image:url(images/SideMenu.png);background-repeat:no-repeat;; z-index:91">

<style>
.lefticon 
{
	margin-left:0px;
	margin-right:140px;
<?php
//fuck how i hate IE!!!
//$browser = get_browser();
$paddingheight=23.5;
$lowerpaddingheight=28;
if(contains($_SERVER['HTTP_USER_AGENT'], "MSIE"))
{
	$paddingheight=28;
	$lowerpaddingheight=26;
?>

	margin-top:-2.05px;
<?php
}
else
{
?>

	margin-top:2.05px;
<?php

}
?>
 
}
 
</style>
<div   style="height:<?=$paddingheight?>px;  width:12px"></div>

<?php
$catlist=" 8 10 2 16 13 9 5 6 18 26 11 7 1 15 17 27 14 3 4";
$arrCatlist=explode(" ", $catlist);
if(1==1)//if penny ever gets this part to work:
{
	for($i=0; $i<20; $i++)
	{
		$thiscatname=GenericDBLookup(our_db,"CATEGORY", "ID", $arrCatlist[$i], "NAME");
		if($thiscatname=="")
		{
			$thiscatname="home";
		}
	?>
	<img id="cat<?=$i+1?>" src="images/s<?=$i+1?>.png"  alt="<?=$thiscatname?>" class="lefticon">
	<?php
	}
}
?>
<img id="cat21" src="images/XMLwithArrow.png"  alt="XML RSS Feed"  style='margin-top:<?=$lowerpaddingheight?>px'>
</div>
 


<script>

 

function flipon(evt)
{
	//alert(evt);
	//alert(evt[moz_var]);
	var callerid;
	var ie_var = "srcElement";
	var moz_var = "target";
	//alert(evt[moz_var].id);
	evt[moz_var] ? callerid = evt[moz_var].id : callerid = evt[ie_var].id;
	var thisimg=document.getElementById(callerid);
	thisimg.style.opacity='1';
	thisimg.style.filter="alpha(opacity=100)"; 
 
}

function flipoff(evt)
{
	//alert(evt);
	//alert(evt[moz_var]);
	var callerid;
	var ie_var = "srcElement";
	var moz_var = "target";
	//alert(evt[moz_var].id);
	evt[moz_var] ? callerid = evt[moz_var].id : callerid = evt[ie_var].id;
	//alert(callerid);
	var thisimg=document.getElementById(callerid);
	if(callerid.indexOf("-")>0)
	{
		arrcallerid=callerid.split("-");
		var testcallerid=arrcallerid[0];
	}
	
	if(stayorangeid!=callerid  && topstayorangeid!=testcallerid)
	{
		thisimg.style.opacity='.0';
		thisimg.style.filter="alpha(opacity=.0)"; 
	}
}

var strCatList="<?=$catlist?>";
var arrCat=strCatList.split(" ");
var i;
 
for(i=0; i<arrCat.length; i++)
{
	if("<?=$category_id?>"==arrCat[i])
	{
		var catindex=i;
	}
 

}
	
function flipclick(evt)
{
	var callerid;

	var ie_var = "srcElement";
	var moz_var = "target";
	evt[moz_var] ? callerid = evt[moz_var].id : callerid = evt[ie_var].id;
	var thisimg=document.getElementById(callerid);
	thisimg.style.opacity='.5';
	thisimg.style.filter="alpha(opacity=50)"; 
	document.innerHTML='';
	document.bgColor='#f0f0f0';
	url='newhome.php';
	//alert(callerid);
	if(callerid.indexOf("-")>0)
	{
		arrcallerid=callerid.split("-");
		callerid=arrcallerid[0];
	}
	if(  callerid.substr(0,3)=="cat")
	{
		url='<?=$homepage?>?c=' + arrCat[parseInt(callerid.substr(3))-1];
	}
	if(callerid=='m1')
	{
		<?php 
		if($user["ID"]>0)
		{
		?>
		
		url='<?=$homepage?>?mode=bookmark&i=1';
		<?php
		}
		else
		{
		?>
		
		url='register.php?mode=new&login_dest=<?=urlencode($strLocation)?>&i=1';
		<?php
		}
		?>
	}
 	if(callerid=='m2')
	{
		url='content.php?n=aboutus&i=2';
	}
	if(callerid=='m3')
	{
		url='content.php?n=faq&i=3';
	}
	if(callerid=='m4')
	{
		url='content.php?n=press&i=4';
	}
	if(callerid=='m5')
	{
		url='content.php?n=partners&i=5';
	}
	if(callerid=='m6')
	{
		url='writers.php?i=6';
	}
	if(callerid=='m7')
	{
		url='submissions.php?i=7';
	}
	if(callerid=='m8')
	{
		url='content.php?n=contact&i=8';
	}
	if(callerid=='m9')
	{
		url='register.php?mode=profile&i=9';
	}
	if(callerid=='buynow')
	{
		url='buynow.php?ID=<?=$_REQUEST["ID"]?>';
	}
	if(callerid=='cat21')
	{
		url='rss_index.php';
	}
	window.location.href=url;
}



for(i=1; i<22; i++)
{
 	var thisimg=document.getElementById("cat" + i);
	thisimg.style.opacity=0;
	thisimg.style.filter="alpha(opacity='0')"; 
	if(thisimg.addEventListener)
	{
		thisimg.addEventListener('mouseover', flipon,false);
		thisimg.addEventListener('mouseout', flipoff,false);
		thisimg.addEventListener('click', flipclick,false);
	}
	else
	{
		thisimg.attachEvent('onmouseover',flipon);
		thisimg.attachEvent('onmouseout', flipoff);
		thisimg.attachEvent('onclick', flipclick);
	}
}
var stayorangeid="";
if(catindex!="")
{
	stayorangeid="cat" + parseInt(parseInt(catindex) +1);
}
var topstayorangeid="m" + "<?=$_REQUEST["i"]?>";
<?php

if($strLocation=="/". $homepage . "?"  || $strLocation=="/". $homepage . "?c=")
{
?>
	stayorangeid='cat1';
<?
}

?>

if(stayorangeid!="cat")
{
	//alert("cat" + arrCat[catindex]);
	var thisimg=document.getElementById(stayorangeid);
	if(thisimg)
	{
	thisimg.style.opacity='1';
	thisimg.style.filter="alpha(opacity=100)";
	} 
}

</script>
<?php
//echo $strLocation . " " . $homepage;
//die();
$pre="";
 
$pre.="<div id='contentdiv' style='	position: absolute;top: 182px;left: 182px; z-index: 1; background-color:#ffffff;  '>";
$pre.="<table border='0'  height=\"900\"   width=\"800\">\n";
$pre.="<tr>\n";
$pre.="<td height='10' rowspan=\"4\" style='background-image:url(images/VerticalDottedRule.jpg);width:36px;background-repeat:repeat-y; '>\n";
$pre.="&nbsp;&nbsp;\n";
$pre.="</td>\n";
$pre.="<td valign='top' height='30'>";
 
$pre.=Searchbox($searchterm, "", $category_id);
$pre.="</td>\n";
$pre.="<td  height='10'  rowspan=\"4\" style='background-image:url(images/VerticalDottedRule.jpg);width:36px;background-repeat:repeat-y; '>\n";
$pre.="&nbsp;&nbsp;\n";
$pre.="</td>\n";
$pre.="</tr>\n";
$pre.="<tr>\n";
$pre.="<td  height='10'  style='background-image:url(images/HorizDottedRule2Col.jpg);width:36px;background-repeat:no-repeat; '>\n";
$pre.="&nbsp;&nbsp;\n";
$pre.="</td>\n";
$pre.="</tr>\n";
$pre.="<tr>\n";
$pre.="<td valign='top' height='1'>\n";
if($article_id==""  && $category_id!="")
{
	$thiscatname=GenericDBLookup(our_db,"CATEGORY", "ID", $category_id, "NAME");
	if($thiscatname !="")
	{
		$listname="<div class='taskheading'>(" . $thiscatname . ")</div>";
	}
	 
	$pre.=$listname;
}
if($messages!="")
{
	$pre.="<div class='messages'>" . $messages . "</div>";
}
if($errors!="")
{
	$pre.="<div class='errors'>" . $errors . "</div>";
}
$pre.="</td>\n";
$pre.="</tr>\n";
echo $pre;
?>