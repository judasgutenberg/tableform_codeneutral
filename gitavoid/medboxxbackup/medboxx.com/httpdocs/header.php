<?php

 
include_once("tf_functions_core.php");

include_once("tf_functions_frontend_db.php");


$officetoken=OurToken();
//$officetoken="worthington";
//echo $officetoken;
 
$strPHP=$_SERVER['PHP_SELF'];
//echo strtolower("$$" . $_SERVER['SERVER_NAME']);
//die($_SERVER['SERVER_NAME']);
if(strpos(strtolower($_SERVER['SERVER_NAME']), "glamourboxx")>0)
{
	//die($_SERVER['SERVER_NAME']);
	header("location: http://glamourboxx.com");
	die();
}
if(strpos(strtolower($_SERVER['SERVER_NAME']), "secular")>0)
{
	header("location: /asecular");
	die();
}

if(strpos(strtolower($_SERVER['SERVER_NAME']), "4.150")>0)
{
	header("location: comingsoon.php");
	die();
}
else if(strtolower($officetoken)=="www" )
{
	header("location: http://" . strtolower(sitename)) . $strPHP;
	die();
}

$requestloginid=$_REQUEST["login_id"];

$intOurLoginID=gracefuldecay(GetFrontEndLoginID(),$requestloginid);
//echo $intOurLoginID;
$dest=$_REQUEST[qpre . "dest"];
$mode=$_REQUEST[qpre . "mode"];
$message=$_REQUEST[qpre . "message"];
$action=$_REQUEST[qpre . "action"];
$strUserTable="login";
$strUserIDField="login_id";
if($officetoken!="")
{
	$ourofficerecord=GenericDBLookup(our_db, "office", "subdomain",$officetoken);
}
 
$error="";
//echo "&"; 
 
if($action=="logout")
{
	FrontendLogout();
	$message="You have been logged out.";
	$intOurLoginID="";
}
else if($_REQUEST["password"]!=""  && $_REQUEST["username"]!="" && !contains($strPHP, "view.php")  && $_REQUEST["login"]!="")
{
	//we have a login attempt
	//echo "$$$" . $intOurLoginID;
	//echo "*" .  $_REQUEST["username"] . "+" .  $ouruserrecord["is_active"] . "+";
	$ouruserrecord=GenericDBLookup(our_db,"login", "username", $_REQUEST["username"]);
	if(!is_array($ouruserrecord))
	{
		$ouruserrecord=GenericDBLookup(our_db,"login", "email", $_REQUEST["username"]);
	}
	$mode=$ouruserrecord["type"];
	
	//echo "*" ,  $mode;
	if($ouruserrecord["is_active"]==1)
	{
		
		$intOurLoginID= $ouruserrecord[$strUserIDField];
		$strLimitspec="48-57 a-z A-Z _ . -";
		$realpassword=FilterString(strtolower(trim($ouruserrecord["password"])),$strLimitspec, "") ;
		if(is_array($ouruserrecord))
		{
			if($realpassword==FilterString(strtolower(trim( $_REQUEST["password"])),$strLimitspec, "") )
			{
				//die("##" . $mode . " " . $intOurLoginID);
				SetFrontEndCookie($intOurLoginID);
			}
			else
			{
				$intOurLoginID="";
				$error.="The password you typed is wrong for this email address.\n" ;
			}
		}
		else
		{
			$intOurLoginID="";
			$error.="The username you entered does not match any of our users.\n" ;
		}
	}
	else
	{
		
		$error.="Your account is not yet enabled.\n" ;
	}
}

if(!$ouruserrecord && $intOurLoginID!="")
{
	$ouruserrecord=GenericDBLookup(our_db,"login", "login_id",$intOurLoginID);
	$mode=$ouruserrecord["type"];
	 
	 //echo $intOurLoginID;
	

	
	$bwlOffice=($mode=="office");
	$userdetails=GenericDBLookup(our_db,$mode, "login_id", $intOurLoginID);
	if(is_array($userdetails))
	{
		$ouruserrecord=array_merge($ouruserrecord,$userdetails);
	}
	// echo $intOurLoginID . "-"  .$mode;s
	
	$intOurOfficeID=$ouruserrecord["office_id"];
	$intOurClientID=$ouruserrecord["client_id"];
	if(($officetoken=="" || strtolower($officetoken)=="www")  && $intOurOfficeID!="")
	{
		$ourofficerecord=GenericDBLookup(our_db, "office", "office_id",$intOurOfficeID);
		$officetoken=$ourofficerecord["subdomain"];
	}
 }
 
 //echo $error;
// echo  "-" . GetFrontEndLoginID();
//echo $mode;

 
?>