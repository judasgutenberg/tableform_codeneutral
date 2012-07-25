<?php
$strPathPre="tf/";
$homepage="index.php";
include_once($strPathPre . "tf_constants.php");
//echo tf_dir;
include_once($strPathPre . "tf_functions_core.php");
include_once($strPathPre . "tf_functions_editor.php");
include_once($strPathPre . "tf_functions_frontend_db.php");
include_once($strPathPre . "tf_constants.php");
include_once($strPathPre . "tf_functions_backup.php");
include_once($strPathPre . "tf_functions_odbc.php");
include_once($strPathPre . "fw_functions.php");


$intRecordsPerPage=20;
$intStartRecord=gracefuldecaynumeric($_REQUEST["r"], 0);
$sql=conDB();
$category_id=$_REQUEST["c"]; 
$searchterm=$_REQUEST["searchterm"];
$searchfields=$_REQUEST["fields"];
$searchage=$_REQUEST["age"];
$writer_id=$_REQUEST["w"];
$nowdatetime=date("Y-m-d H:i:s");
$article_id=$_REQUEST["ID"];


$logindecisions=LoginDecisions($strDatabase,  $strPHP, $strUser, false);

$email_forgottenuser=str_replace("'", "", $_REQUEST["email_forgottenuser"]);
$login_username=addslashes(removeslashesifnecessary($_REQUEST["login_username"]));
$login_password=addslashes(removeslashesifnecessary($_REQUEST["login_password"]));
$login_dest=addslashes(removeslashesifnecessary($_REQUEST["login_dest"]));
$errors=$_REQUEST["errors"];
$messages=$_REQUEST["messages"];

//READ THE OLD FW COOKIES AND COPY THEM IF USER IS NOT AN ADMIN!!!!
$mode=str_replace("'", "", $_REQUEST["mode"]);
if(contains($login_dest, "Forgot.cfm")) //catching a failure to change a url in the email
{
	$mode="forgotpassword";
	$messages="";
	$errors="";
	$login_dest="";
	header('location: ' . $homepage . '?mode=forgotpassword');
	die();
}
else if(contains($article_id, "Forgot.cfm"))
{
	header('location: signin.php?mode=forgotpassword');
	die();
}
if($strUser==""  && $mode!="logout"  && $_COOKIE["FW_USERID"]!="1")
{
	$oldFWCookie=$_COOKIE["FW_USERID"];
	if($oldFWCookie!="")
	{
		setcookie("fw_transition", "1", time()+50000000);
		$fw_user=GenericDBLookup(our_db,"USERS", "ID", $oldFWCookie, "") ;
		$fw_roles=$fw_user["ROLES"];
		$fw_email=$fw_user["EMAIL"];
		if(!contains($fw_roles, "S"))
		{
			setLoggedIn($fw_email);
			$strUser=$fw_email;
			$user_id=$oldFWCookie;
		}
	}
}


if(contains($_SERVER['PHP_SELF'] , "signin"))
{
	//$strLocation= $login_dest;
}
else
{
	$strLocation= $_SERVER['PHP_SELF'] . "?" .$_SERVER['QUERY_STRING'];
}

$action="";
 

if($login_username!="" && $login_password!="")
{
	$rfp=GenericDBLookup(our_db,"USERS", "USERNAME", $login_username) ;
	$foundpassword=$rfp["PASSWORD"];
	if(strtolower($foundpassword)==strtolower($login_password))
	{
		$action="setloggedin";
		$strUser=$rfp["EMAIL"];
	}
	$foundpassword=GenericDBLookup(our_db,"USERS", "EMAIL", $login_username, "PASSWORD") ;
	if($foundpassword==$login_password)
	{
		$action="setloggedin";
		$strUser=$login_username;
	}
	//echo  $foundpassword;
	if($action==""  && $foundpassword!="")
	{
		$errors.="The password you entered was wrong.<br>";
	}
	else if($action==""  && $foundpassword=="")
	{
		$errors.="The username or email you entered could not be found.<br>";
	}
 
}

if($mode=="logout")
{
	$action="setloggedout";
}
if($action=="setloggedout")
{
	//setcookie("FW_USERID", "", $time-1000000);
	logout();
	
	setcookie("FW_USERID", "",time()-20000, "/" );
	setcookie("CFTOKEN", "x", time()-20000, "/" );
	 
	
	$messages="You are now logged out.<br>";
	$strUser="";

}
else if($action=="setloggedin")
{
	
	setLoggedIn($strUser);
	$messages="You are now logged in.<br>";
	//die($login_dest);
	if($login_dest!="")
	{
		header("location: " . $login_dest . "&messages=" . urlencode($messages));
	}
}

if($email_forgottenuser!="")
{
	$rfp=GenericDBLookup(our_db,"USERS", "EMAIL", $email_forgottenuser) ;
	if(count($rfp)<1)
	{
		$rfp=GenericDBLookup(our_db,"USERS", "USERNAME", $email_forgottenuser) ;
	}
	if(is_array($rfp))
	{
		//setLoggedIn($strUser);
		$messages="An email was sent to " . $email_forgottenuser . " with a password and username reminder.<br>";
		
		$body="\r\n\r\nYour username and password for http://www.featurewell.com are\r\n\r\nUsername: " . $rfp["USERNAME"] . "\r\n\r\nPassword: " . $rfp["PASSWORD"] . "\r\n\r\nClick this link to sign in: http://www.featurewell.com/signin.php";
	 	$fromemail=GenericDBLookup(our_db,"content", "name", "AdminEmail", "content");
	 	$headers = "From: " . $fromemail . "\r\nReply-To: " . $fromemail;
	 
		mail($email_forgottenuser, "Your Featurewell password",  $body, $headers, "-f" . $fromemail);
		UpdateOrInsert(our_db, "communication", "", Array("sender_id"=>$user["ID"], "article_id"=>intval($article_id), "receiver_email"=>$email, "datetime_done"=>$nowdatetime, "description"=>"password reminder"));
	 }
	 else
	 {
	 	$errors="The email " . $email_forgottenuser . " does not exist in our system.  Perhaps you registered under a different one.<br>";
		$mode="forgotpassword";
	 }
	//header("location: " . $homepage . "?c=&messages=" . urlencode($messages));
	 
}

$user=GenericDBLookup(our_db,"USERS", "EMAIL", $strUser, "");
if($user["ROLES"]=="" && $user["ID"]>0)
{
	$arrFix=Array();
	$arrFix["ROLES"]="C";
	UpdateOrInsert(our_db, "USERS", Array("ID"=>$user["ID"] ), $arrFix);
}
if($mode=="bookmark")
{
	$delcount=0;
	if(is_array($_REQUEST["delbookmark"]))
	{
		foreach($_REQUEST["delbookmark"] as $thisarticle_id)
		{
			DeleteBySpec(our_db, "BOOKMARK", Array("ARTICLE_ID"=>$thisarticle_id, "USER_ID"=>$user["ID"]));
			$delcount++;
		}
	}
	if($delcount>0)
	{
		$messages.=$delcount .  " " . PluralizeIfNecessary("bookmark", $delcount)  . " deleted.<br>";
	}
	if(is_array($user)  && $article_id!="")
	{
		//GenericDBLookupWhere($strDB, $strTable, $strWhereClause, $strResultFieldName="", $bwlDebug=false, $bwlWorkUntilFound=true, $language_id="")
		$foundarticleid=GenericDBLookupWhere(our_db, "BOOKMARK", "ARTICLE_ID=".intval($article_id) . " AND USER_ID=" .$user["ID"]  ,"ARTICLE_ID");
		if($foundarticleid=="")
		{
			UpdateOrInsert(our_db, "BOOKMARK", "", Array("USER_ID"=>$user["ID"], "ARTICLE_ID"=>intval($article_id), "TIMESTAMP"=>$nowdatetime ));
		}
		$messages.="A bookmark has been added.<br>";
		//header("location: " . $login_destination . "&messages=" . urlencode($messages));
	}
}
if($mode!="forgotpassword")
{
	if(is_array($user) && $user["ACTIVE"]==0 && (contains($strLocation, "article") || contains($strLocation, "printer") ))
	{
		header("location: signin.php?login_dest=" . urlencode($strLocation ) . "&errors=" . urlencode("You must be logged in with an active account to access this part of the site."));
	}
 	
	
	if(!is_array($user) && (contains($strLocation, "/article.php?") || contains($strLocation, "/emailcolleague.php")|| contains($strLocation, "/buynow.php")))
	{
	
		header("location: signin.php?login_dest=" . urlencode($strLocation ) . "&errors=" . urlencode("You must be logged in to access this part of the site."));
	
	}
	else if($user["ID"]>0 && $article_id>0)
	{
		UpdateOrInsert(our_db, "HIT", "", Array("URL"=>$_SERVER["HTTP_REFERER"], "USER_ID"=>$user["ID"], "ARTICLE_ID"=>intval($article_id), "TIMESTAMP"=>$nowdatetime ));
		$strSQL="UPDATE " . our_db . "." . articletable . " SET HITS=HITS+1 WHERE ID=" . intval($article_id);
		$sql->query($strSQL);
	
	
	}
}
else
{
	$article_id="";
}
 
//echo "<script>alert('" . $strLocation . " " . $strUser . "')</script>";
//now i also have the username as $strUser










function FWPrice($userid, $article_id, $mode="")
{
	$sql=conDB();
	$strSQL="
		SELECT CLIENT.PRICE_PER_WORD,
	         CLIENT.PIC_PRICE,
	         CLIENT.MIN_PRICE            AS MIN_PRICE,
	         CLIENT.MAX_PRICE           AS MAX_PRICE,
	         CIRC.PRICE_PER_WORD  AS CIRC_PRICE_PER_WORD, 
	         CIRC.PHOTO_PRICE          AS CIRC_PHOTO_PRICE,
	         CIRC.MIN_PRICE                AS CIRC_MIN_PRICE,
	         CIRC.MAX_PRICE               AS CIRC_MAX_PRICE
	 	from USERS CLIENT
	         JOIN PARAMETER CIRC ON CIRC.ID = CLIENT.CIRCULATION_ID
	 	WHERE CLIENT.ID = " . $userid;
	$records = $sql->query($strSQL);
	//echo mysql_error();
	$clientrecord=$records[0];
	
	$ppw=$clientrecord["PRICE_PER_WORD"];
	$cppw=$clientrecord["CIRC_PRICE_PER_WORD"];
	$minprice=$clientrecord["MIN_PRICE"];
	$maxprice=$clientrecord["MAX_PRICE"];
	$cmaxprice=$clientrecord["CIRC_MAX_PRICE"];
	$cminprice=$clientrecord["CIRC_MIN_PRICE"];
	$picprice=$clientrecord["PIC_PRICE"];
	$cpicprice=$clientrecord["CIRC_PHOTO_PRICE"];
	//var_dump($clientrecord);
	//echo "<P>";
	$strSQL="
	select WORD_COUNT, BIO,
	         wr.WEIGHT                   AS WRITER_WEIGHT, 
	         ar.WEIGHT                   AS ARTICLE_WEIGHT,
	         IfNULL(wr.MIN_PRICE,0)  AS WRT_RATING_MIN,
	         wr.MAX_PRICE              AS WRT_RATING_MAX,
	         IfNULL(ar.MIN_PRICE,0)  AS ART_RATING_MIN,
	         ar.MAX_PRICE              AS ART_RATING_MAX
	 	FROM USERS w 
			JOIN  " . articletable . " a ON w.ID = a.AUTHOR_ID 
	        LEFT JOIN  PARAMETER  wr ON wr.ID  = w.RATING_ID 
	       LEFT  JOIN PARAMETER  ar ON ar.ID = a.RATING_ID
		WHERE a.ID = " . $article_id;
	$records = $sql->query($strSQL);
	//echo $strSQL;
	//echo mysql_error();
	
	
	$articlerecord=$records[0];
	$bio=str_replace("  ", " ", trim($articlerecord["BIO"]));
	//echo $articlerecord["BIO"];
	$biowordcount=0;
	{
		$arrBiowc=explode(" ", $bio);
		$biowordcount=count($arrBiowc) +1;
	}
	$wordcount=$articlerecord["WORD_COUNT"];
	$art_rating_min=$articlerecord["ART_RATING_MIN"];
	$art_rating_max=$articlerecord["ART_RATING_MAX"];
	$art_weight=gracefuldecay($articlerecord["ARTICLE_WEIGHT"], 1);
	$writer_weight=gracefuldecay($articlerecord["WRITER_WEIGHT"], 1);
	$wr_rating_min=$articlerecord["WRT_RATING_MIN"];
	$wr_rating_max=$articlerecord["WRT_RATING_MAX"];
	//var_dump($articlerecord);
	
	if($ppw==0)
	{
		$ppw=$cppw;
	}
	if($maxprice==0)
	{
		$maxprice=$cmaxprice;
	}
	
	if($picprice==0)
	{
		$picprice=$cpicprice;
	}
	if(1==2)
	{
	echo "<P>";
	echo $minprice . "<P>";
	echo $maxprice . "<P>";
	echo $wordcount . ":wc<P>";
	echo $biowordcount . ":biowc<P>";
	echo intval($wordcount+$biowordcount) . "<P>";
	echo $ppw . "<P>";
	echo $art_weight . ":aw<P>";
	echo $writer_weight . ":ww<P>";
	echo $ppw * ($wordcount+$biowordcount)* $art_weight * $writer_weight;
	}
	$minprice=max($minprice, $art_rating_min);
	$minprice=max($minprice, $wr_rating_min);
	
	$maxprice=max($maxprice, $art_rating_max);
	$maxprice=max($maxprice, $wr_rating_max);
	
	if($ppw=="")
	{
		$price="NA";
	}
	else
	{
		$price=$ppw * ($wordcount+$biowordcount) * $art_weight * $writer_weight;
		$price=5*ceil($price/5);
		$price=max(min($price,$maxprice),$minprice);
	}
	if( $mode=="")
	{
		return $price;
	}
	else if( $mode=="")
	{
		return $price;
	}
	
}
  
function CategoryIcons($article_id, $additionalID, $bwlAlignLeft=true, &$catcount, $pagearticlecount=0)
{
	GLOBAL $homepage;
	$sql=conDB();
	if($additionalID!="")
	{
		$strAdditionalClause=" c.CATEGORY_ID='" . $additionalID ."' OR ";
	}
	$strSQL="SELECT CATEGORY_ID, NAME FROM   ARTICLE_CATEGORY c JOIN CATEGORY cc ON c.CATEGORY_ID=cc.ID  WHERE ". $strAdditionalClause. " ARTICLE_ID=" . intval($article_id) . "";
	$records = $sql->query($strSQL);
	//echo $strSQL . "<BR>";
	//echo mysql_error();
	$strAlign="";
	$catcount=0;
	if( $bwlAlignLeft)
	{
		$strAlign=" align='left' ";
	}
	$out="<table   style='  margin-bottom:0px; padding-bottom:0px' cellpadding=\"0\" border=\"0\" cellspacing=\"0\" " . $strAlign . "  ><tr><td>";
	//if( $additionalID!="")
	//{
		//$records[count($records)]= $additionalID;
	//}
	$catids="";
	foreach($records as $record)
	{
		if(!inList($catids, $record["CATEGORY_ID"]))
		{
			$catids.=" " .  $record["CATEGORY_ID"];
			$out.="<a href='" . $homepage . "?c=" .$record["CATEGORY_ID"] . "'><img id='g" . intval(10 + intval(intval($pagearticlecount) *5 + intval($catcount))) . "' border='0' alt='" . $record["NAME"] . "' style='margin-right:4px' src='images/cat" . $record["CATEGORY_ID"] . ".png'></a>";
			$catcount++;
		}
	}
	//$out.="<script>alert(" . $catids . ");</script>";
	$out.="</td></tr></table>";
	return $out;
}

function MailPostToAdmin($subject)
{
	GLOBAL $strUser;
	GLOBAL $user;
	$toemail=GenericDBLookup(our_db,"content", "name", "AdminEmail", "content");
	foreach($_POST as $k=>$v)
	{	
		$strLookupAdditional="";
		if($k=="TEXT")
		{
			$v=WeirdCharacterFix($v);
		}
		else if($k=="CATEGORY_ID")
		{
			$strLookupAdditional=" (" . GenericDBLookup(our_db,"CATEGORY", "ID", $v, "NAME") . ")";
		}
		$body.=$k . ": " . $v . $strLookupAdditional . "\r\n\r\n----------------------------------\r\n\r\n";
	}
	$body.="USER: " . $user["FIRST_NAME"] . " " . $user["LAST_NAME"] . "; ID=" . $user["ID"] . "; EMAIL=" . $user["EMAIL"] . "\r\n";
	$headers = "From: " .$user["EMAIL"] . "\r\nReply-To: " . $user["EMAIL"];
	mail($toemail,"Featurewell: User submission",  "From: " . $user["EMAIL"] . "\r\n" . $body);
}






function Searchbox($searchterm, $bwlAdvanced, $category_id)
{
	GLOBAL $homepage;
 
	$strPHP=$_SERVER['PHP_SELF'];
	$out="";
	$out.="<form action='" . $homepage  ."' action='GET' name='SForm'>\n";
	$out.="<table  cellspacing='0'   style='padding:0px;border:0px;margin:0px;height:12px;width:740px'   >\n";
	$out.="<tr>\n";
	$catlabelimage="BlankTop.png";
 
	 
	$catname="";
	$marginleft="150";
	$strDateformat="F d, Y";
	$width="200";
 	if(contains($_REQUEST["mode"], "bookmark"))
	{
 		//"l, F d Y"
		$strDateformat="";//, F d
		$marginleft="10";
		$width=340;
		$listname="Your Bookmarks";
	}
	else if(!contains($strPHP, $homepage))
	{
 		//"l, F d Y"
		$strDateformat="F d, Y";//, F d
		$marginleft="10";
		$width=340;
	}
	else if($searchterm!="")
	{
		$listname="SEARCHING FOR: '" . $searchterm . "'";
		$marginleft="10";
		$width=340;
 		$strDateformat="";//, F d
	}
	else if($category_id!="")
	{
		//$out.="<img src='images/cat" .$category_id . ".png'>";
		//$listname=GenericDBLookup(our_db,"CATEGORY", "ID", $category_id, "NAME") . " : ";
		//$out.=$catname;
		$marginleft="10";
		$width=340;
 		$strDateformat="F d, Y";//, F d
		//$out.="<img src='images/cat" .$category_id . ".png'>";
	}
	else
	{
		$catlabelimage="TopStoriesBar.jpg";
	}
 
	$out.="<td style=\"height:30px;background-image:url(images/" .$catlabelimage . ");\"  >\n";
	 
	$out.="<div style=\"margin-left:" . $marginleft . "px;padding-top:13px;padding-bottom:0px;width:" . $width . "px; height:30px;\" class='topdatedisplay'>" . $listname   . date($strDateformat) . "</div>";
	$out.="</td>\n";
	
	$out.="<td width='100%' style=\"padding-left:10px;padding-top:5px;padding-bottom:0px\">";
	$out.=" <div style='border: 1px solid grey;padding-top:2px;padding-left:2px'>";
	$out.=" <input style=\"vertical-align:top;padding-bottom:2px;\" name='searchterm' type='text' size='25' > \n";
	$out.=" <input name='c' type='hidden' size='25' value='" .  $category_id . "'> \n";
	$out.="<a href='javascript:document.SForm.submit()'><img id='g7' border='0'  name='search'  src='images/search.png' ></a>\n";
	$out.="<a href='advancedsearch.php'><img  id='g8'   name='advancedsearch' type='image' border='0' src='images/advancedsearch.png' ></a>";
	$out.="</div>";
	$out.="</td>\n";
	
	$out.="</tr>\n";
	$out.="</table>\n";
	$out.="</form>\n";
	return $out;
}
 
 
 function FWRedesignPaginate($intRecCount, $intRecordsPerPage, $intStartRecord, $strPHP, $strThisQVar)
//Paginates a record set
//$intRecCount is the total number of records in unpaginated record set
{
	$out="";
 	if ($intStartRecord=="")
	{
		$intStartRecord=0;
	}
	$intPages=intval(($intRecCount-1)/$intRecordsPerPage);
	if ($intPages>0)
	{
		for ($i=0; $i<=$intPages; $i++)
		{
			$url=$strPHP . "?" . replaceSpecificQueryVariable($strThisQVar, $i * $intRecordsPerPage);
			if (intval($intStartRecord)!= intval($i * $intRecordsPerPage) )
			{
				$out.="<a class='paginationlink' href=\"" . $url . "\">" .intval($i +1) . "</a>";
			}
			else
			{
				$out.=    "<b>" . intval($i +1) . "</b>";
			}
			if (($i+1)* $intRecordsPerPage<$intRecCount)
			{
				$out.= " ";
			}
		}	
		$carrethyperlink="";
		$endcarrethyper="";
		if($intStartRecord<$intRecCount)
		{
			$url=$strPHP . "?" . replaceSpecificQueryVariable($strThisQVar, $intStartRecord + $intRecordsPerPage);
			$carrethyperlink="<a class='paginationlink' href=\"" . $url . "\">";
			$endcarrethyper="</a>";
		}
		return "<div class='paginationationnav'>Go to Page: " . $out . " " . $carrethyperlink . "&gt;" . $endcarrethyper."</div>";
	}
}
 
 

function WordCount($strFWC)
{
	$strFWC=trim(strip_tags($strFWC));
	$strFWC=str_replace(chr(10), " ", 	$strFWC);
	$strFWC=str_replace(chr(13), " ", 	$strFWC);
	$strFWC=str_replace("'", " ", 	$strFWC);
	$strFWC=str_replace(chr(39), " ", 	$strFWC);
	$strFWC=str_replace(chr(34), " ", 	$strFWC);
	$strFWC=deMultiple( $strFWC, " "  );
	//echo $strFWC;
	$arrCountWords=explode(" " , $strFWC);
	$wordcount=count($arrCountWords) + 1;
	return $wordcount;
}

function HaveViewed($article_id,  $user_id)
{
	$sql=conDB();
	$strSQL="SELECT * FROM HIT WHERE ARTICLE_ID=". intval($article_id) . " AND USER_ID=" .  $user_id;
	//echo $strSQL;
	$records = $sql->query($strSQL);
	return count($records);
}


?>
