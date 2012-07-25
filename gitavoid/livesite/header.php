<!doctype html public "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD><script type="text/javascript" src="/CFIDE/scripts/cfform.js"></script>
<script type="text/javascript" src="/CFIDE/scripts/masks.js"></script>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
    <LINK REL="SHORTCUT ICON" href="http://www.featurewell.com/favicon.ico" />
    <LINK REL="STYLESHEET" type="text/css" href="http://www.featurewell.com/featurewell.css" />
    <LINK REL="alternate" type="application/rss+xml" title="RSS" href="http://www.featurewell.com/rss.cfm" />
	<META name="Description" CONTENT="Featurewell.com syndicates top journalists to newspapers, magazines and web sites around the world."/>
  <META name="Keywords" CONTENT="Featurewell, NYC, NY, New York, Syndicate, Syndication, Article, journalism, reprint, copyright, second rights, feature, media, press, news, reporter, stringer, correspondent, reportage, literary agency, writer, newspaper, magazine, editor, editorial, content, story, narrative, non-fiction, publish, publication, commentary, information, dispatch, byline, broadsheet, journal, deadline, Herald, Times, resell,Mochila, Mochilla, New York Times and Tribune Media Services, Creators, United Media, Low cost, discount"
 />
  <META name="VERSION" CONTENT="April 2002"/>
  <META name="robots" CONTENT="nofollow"/>
  <META http-equiv="Pragma" CONTENT="no-cache"/>

  <META http-equiv="Expires" CONTENT="Now"/>
	<SCRIPT LANGUAGE="JAVASCRIPT" TYPE="text/javascript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; 
	if(d.images){ 
		if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; 
		for(i=0; i<a.length; i++)
    	if (a[i].indexOf("#")!=0){ 
				d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; 
	for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) 
		x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.0
  var p,i,x;  
	if(!d) 
		d=document; 
	if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) 
		x=d.all[n]; 
	for (i=0;!x&&i<d.forms.length;i++) 
		x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) 
		x=MM_findObj(n,d.layers[i].document);
  if(!x && document.getElementById) 
		x=document.getElementById(n); 
	return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; 
	document.MM_sr=new Array; 
	for(i=0;i<(a.length-2);i+=3)
   	if ((x=MM_findObj(a[i]))!=null){
	 		document.MM_sr[j++]=x; 
	if(!x.oSrc) 
		x.oSrc=x.src; x.src=a[i+2];}
}

function winopen (url,params) {
	open(url,"NewWindow",params)
}

<!-- This script and many more are available free online at -->
<!-- The JavaScript Source!! http://javascript.internet.com -->
<!-- V1.1.3: Sandeep V. Tamhankar (stamhankar@hotmail.com) -->
<!-- Original:  Sandeep V. Tamhankar (stamhankar@hotmail.com) -->
function emailCheck (p1,p2,emailStr) {

var checkTLD=1;
var knownDomsPat=/^(com|net|org|edu|int|mil|gov|arpa|biz|aero|name|coop|info|pro|museum)$/;
var emailPat=/^(.+)@(.+)$/;
var specialChars="\\(\\)><@,;:\\\\\\\"\\.\\[\\]";
var validChars="\[^\\s" + specialChars + "\]";
var quotedUser="(\"[^\"]*\")";
var ipDomainPat=/^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/;
var atom=validChars + '+';
var word="(" + atom + "|" + quotedUser + ")";
var userPat=new RegExp("^" + word + "(\\." + word + ")*$");
var domainPat=new RegExp("^" + atom + "(\\." + atom +")*$");
var matchArray=emailStr.match(emailPat);

if (matchArray==null) {
alert("Email address seems incorrect (check @ and .'s)");
return false;
}
var user=matchArray[1];
var domain=matchArray[2];

for (i=0; i<user.length; i++) {
if (user.charCodeAt(i)>127) {
alert("Ths username contains invalid characters.");
return false;
   }
}
for (i=0; i<domain.length; i++) {
if (domain.charCodeAt(i)>127) {
alert("Ths domain name contains invalid characters.");
return false;
   }
}

if (user.match(userPat)==null) {

alert("The username doesn't seem to be valid.");
return false;
}

var IPArray=domain.match(ipDomainPat);
if (IPArray!=null) {

for (var i=1;i<=4;i++) {
if (IPArray[i]>255) {
alert("Destination IP address is invalid!");
return false;
   }
}
return true;
}

var atomPat=new RegExp("^" + atom + "$");
var domArr=domain.split(".");
var len=domArr.length;
for (i=0;i<len;i++) {
if (domArr[i].search(atomPat)==-1) {
alert("The domain name does not seem to be valid.");
return false;
   }
}

if (checkTLD && domArr[domArr.length-1].length!=2 && 
domArr[domArr.length-1].search(knownDomsPat)==-1) {
alert("The address must end in a well-known domain or two letter " + "country.");
return false;
}

if (len<2) {
alert("This address is missing a hostname!");
return false;
}

return true;
}

//configure the two variables below to match yoursite's own info

function addbookmark(){
	var bookmarkurl="http://www.featurewell.com"
	var bookmarktitle="Featurewell.com - Syndication Worldwide"
	if (document.all)
		window.external.AddFavorite(bookmarkurl,bookmarktitle)
}

//-->
</SCRIPT>
<script type="text/javascript">
<!--
    _CF_checkSearchForm = function(_CF_this)
    {
        //reset on submit
        _CF_error_exists = false;
        _CF_error_messages = new Array();
        _CF_error_fields = new Object();
        _CF_FirstErrorField = null;


        //display error messages and return success
        if( _CF_error_exists )
        {
            if( _CF_error_messages.length > 0 )
            {
                // show alert() message
                _CF_onErrorAlert(_CF_error_messages);
                // set focus to first form error, if the field supports js focus().
                if( _CF_this[_CF_FirstErrorField].type == "text" )
                { _CF_this[_CF_FirstErrorField].focus(); }

            }
            return false;
        }else {
            return true;
        }
    }
//-->
</script>
<TITLE>Featurewell.com - Syndication Worldwide</TITLE></HEAD>
<BODY bgcolor="#FFFFFF" link="#CCCCCC" vlink="#CCCCCC" alink="#CCCCCC" 
			onLoad="MM_preloadImages('gfx/arrwl_ovr.gif','gfx/arrwr_ovr.gif')">
			


<TABLE CELLSPACING="0" CELLPADDING="0" BORDER="0" ALIGN="CENTER" WIDTH="100%">
	<tr><td COLSPAN="3"><table width="720" border="0" cellspacing="0" cellpadding="0" align="center">

  <tr> 
    <td><img src="gfx/spacer.gif" width="5" height="5"/></td>
  </tr>
  <tr> 
    <td align="left" valign="top">
      <a href="http://www.featurewell.com/" TITLE="Featurewell home"><img src="gfx/featurewell.gif" border="0"/></a>
    </td>
		<td align="left" valign="top">&nbsp;</td>
    <td align="right" valign="top">
  



<TABLE cellpadding=0 cellspacing=0 BORDER=0>
	<TR>
		<TD class="Username" align="right">
			

        
				<?=$loginpiece?> 
 
        
		  
		</TD>
	</TR>	
</TABLE>
</td>

  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" valign="middle" class="TopMenu"> 
      <table width="720" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="243" valign="top" CLASS="TopMenu">
            <a href="http://www.featurewell.com/" TITLE="Featurewell home"><img src="gfx/syndicationww.gif" border="0"/></a>
					</td>
          <td width="477" align="right" CLASS="TopMenu">

						
              
					  	<a href="http://www.featurewell.com/?Doc=Register.cfm&AID=<?=$article_id?>" TITLE="Register to read the articles"><FONT CLASS="Register">Register</FONT></a> <FONT CLASS="TopMenu"> | </FONT> 
           		<a href="http://www.featurewell.com/?Doc=Account.cfm" TITLE="Edit your account details"><FONT CLASS="TopMenu">My Account</FONT></a><FONT CLASS="TopMenu"> | </FONT>
							<a href="http://www.featurewell.com/?Msg=ABOUTUS" TITLE="About the people at Featurewell.com"><FONT CLASS="TopMenu">About Us</FONT></a><FONT CLASS="TopMenu"> | </FONT>
							<a href="http://www.featurewell.com/?Msg=PRESS" TITLE="What the press has said about Featurewell.com"><FONT CLASS="TopMenu">Press</FONT></a><FONT CLASS="TopMenu"> | </FONT>

	            <a href="http://www.featurewell.com/?Doc=Writers.cfm" TITLE="Our Writers"><FONT CLASS="TopMenu">Writers</FONT></a><FONT CLASS="TopMenu"> | </FONT>  
           		<a href="http://www.featurewell.com/?Doc=Submit.cfm" TITLE="How to submit an article"><FONT CLASS="TopMenu">Submissions</FONT></a><FONT CLASS="TopMenu"> | </FONT>
           		<a href="http://www.featurewell.com/?Msg=CONTACTUS" TITLE="How to get in touch with us"><FONT CLASS="TopMenu">Contact</FONT></a><FONT CLASS="TopMenu"> | </FONT>
           		<a href="http://www.featurewell.com/?Msg=FAQ2" TITLE="Frequently Asked Questions"><FONT CLASS="TopMenu">FAQ</FONT></a>

							 
					</td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td><img height="5" src="gfx/spacer.gif" width="5"/></td>
  </tr>
</table>

<table width="720" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr> 
    <td width="472" valign="top" class="DateStamp"><?=date("F j, Y");?></td>
    <td width="228" rowspan="2"><img height="60" width="468" src="gfx/fw_banner.gif" BORDER="0"/></td>
  </tr>
  <tr> 
    <td width="472" valign="bottom"><FONT class="Title">
	
<?=$title?>
	
</FONT>
</td>
  </tr>

  <tr> 
    <td><img height="2" src="gfx/spacer.gif" width="5"/></td>
  </tr>
</table></td></tr>  
	<tr VALIGN="top"> 
		<td>
      <table WIDTH="720" height="500" BORDER="0" CELLSPACING="0" CELLPADDING="0" ALIGN="CENTER">
				<tr VALIGN="TOP">	
					<td></td>
          <td>
    				<hr NOSHADE SIZE="1"/>

	