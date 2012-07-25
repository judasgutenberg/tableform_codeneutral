<?php
$strPathPre="tf/";
include_once($strPathPre . "fw_functions.php");
$urlroot="http://www.featurewell.com/";
include_once($strPathPre . "tf_constants.php");
include_once($strPathPre . "tf_functions_core.php");
include_once($strPathPre . "tf_functions_editor.php");
include_once($strPathPre . "tf_functions_frontend_db.php");
include_once($strPathPre . "tf_functions_odbc.php");

set_time_limit(900);
 
echo   main();

 


function main()
{
	GLOBAL $db_type;
	if(!IsExtraSecure())
	{
		die( ExtraSecureFailure());
	}
 	$db_type= '';
	$strDatabase=our_db;
	//$olderror=error_reporting(0);
	$mode=$_REQUEST["mode"];
	if($_REQUEST["test"]!="")
	{
		//echo "@@";
		$mode="mailself";
	}
	else if($_REQUEST["weekly"]!="")
	{
		$mode="schedulemail";
	}
 
	$subject=$_REQUEST["subject"];
	$body_extra=$_REQUEST["body"];
	$strDatabase=our_db;
	$strColumn=$_REQUEST[qpre . "column"];
	$comprehensivesearch=gracefuldecaynumeric($_REQUEST[qpre . "comprehensivesearch"],0);
	error_reporting($olderror);
	$strPHP=$_SERVER['PHP_SELF'];
	$strValDefault=$_REQUEST["ID"];
	$strTable=articletable ;
	$mailing_id=$_REQUEST["mailing_id"];
	$feedback=$_REQUEST["message"];
	$out="";
	//echo $id . " " .$idfield ;
	$strConfigBehave="notopnav";
	$out=LoginDecisions($strDatabase,  $strPHP, $strUser, false, $strConfigBehave);
	$sql=conDB();
 	//$strUser="";
 
	if ($strUser!="")
	{
		//die( $db_type);
		$intAdminType= AdministerType($strDatabase, $strTable, $strUser);

		if (function_exists(toolnav) && !$bwlSimplifyLogin )
		{
				$out=toolnav(true) . $out;
		}
		if ($intAdminType>1)
		{
			//echo $mode;
			if($mode=="refresh_mailing")
			{
				//echo our_db;
				$strSQL="SELECT * FROM " . our_db . ".mailing ORDER BY mailing_id DESC";
				$records=$sql->query($strSQL);
				foreach($records as $record)
				{
					$thismailing_id=$record["mailing_id"];
					$strSQL="SELECT count(mailing_click_id) as 'clickthrough_count' from ". our_db . ".mailing_click where mailing_id=" . $thismailing_id;
					$countrecs=$sql->query($strSQL);
					$countrec=$countrecs[0];
					$clickthrough_count=$countrec["clickthrough_count"];
					$strTimeStart=$record["mailing_date"];
					$strTimeEnd=date("Y-m-d H:i:s", strtotime($strTimeStart) + 604800);//week of seconds
					$strSQL="SELECT * FROM OFFER WHERE TIMESTAMP>'" . $strTimeStart . "'  AND TIMESTAMP<'" . $strTimeEnd . "' ORDER BY ID DESC";
					$records2=$sql->query($strSQL);
					//echo $strSQL . "<BR>";
					$thisoffertally="";
					$oldtimestamp="";
					
					$thisoffertally=0;
					$olduserid="";
					$oldarticleid="";
					foreach($records2 as $record2)
					{
						$timestamp=$record2["TIMESTAMP"];
						$offer=$record2["OFFER"];
						$user_id=$record2["USER_ID"];
						$articleid=$record2["ARTICLE_ID"];
						//echo $thisoffertally . " " . $timestamp ." " .$offer ;
						if($articleid!=$oldarticleid || $oldtimestamp=="" ||   $user_id!=$olduserid || $user_id==$olduserid && abs(strtotime($oldtimestamp)-strtotime($timestamp))>500 )
						{	
							$thisoffertally+=$record2["OFFER"];
							//echo "*";
						}
						$oldtimestamp=$record2["TIMESTAMP"];
						$olduserid=$record2["USER_ID"];
						$oldarticleid=$record2["ARTICLE_ID"];
						//echo   "<BR>";
					}
					//die();
					//echo "$" . $thismailing_id . "<BR>";
					UpdateOrInsert($strDatabase, "mailing", Array("mailing_id"=>$thismailing_id), Array("sales"=>$thisoffertally, "clickthrough_count"=>$clickthrough_count), true, false, false);
				}
				//die();
				
				
				header("location: " . "?message=" . urlencode("Weekly sales retallied."));
			}
			if($mode=="restart")
			{
				
				UpdateOrInsert($strDatabase, "mailing", Array("mailing_id"=>$mailing_id), Array("aborted"=>0), true, false, false);
				header("location: " . $strPHP);
			}
			if($mode=="abort")
			{
				
				UpdateOrInsert($strDatabase, "mailing", Array("mailing_id"=>$mailing_id), Array("aborted"=>1), true, false, false);
				header("location: " . $strPHP);
			}
			else if($mode=="mailself")
			{
				 
				$user_id=GenericDBLookup($strDatabase, "USERS", "EMAIL", $strUser, "ID");
				//echo $user_id;
				$responser=SendMailingToUser($user_id, 0, $subject, $body_extra);
				$strExtraRString="The mail sending server failed to report any action, so it's likely no message was sent.";
				if($responser==1)
				{
					$strExtraRString="The mail sending server claims the message was successfully sent.";
				}
				else if($responser==1)
				{
					$strExtraRString="But there were no new articles so no email was actually sent.";
				}
				$feedback.="An attempt was made to send a mailing to " . $strUser . ".<br/> " . $strExtraRString;
			}
			else if($mode=="schedulemail")
			{
				//to odbc
			 	//$db_type= 'odbc';
				//$strDatabase="dbo";
				
				
				//we're starting up a mailing right here:
				//$emailrecords=$sql->query("fw_client_emails" );
				//echo "-" . count($records);
				//back to mysql
				
				
				$db_type= '';
				$strDatabase=our_db;
				//how it will work when we switch to MYSQL:
				//select * FROM active_user ORDER BY RECENTEST_OFFER DESC,  OFFERCOUNT   DESC,   ID DESC
				$emailrecords=$sql->query("select * FROM " . our_db . ".active_user ORDER BY RECENTEST_OFFER DESC, OFFERCOUNT DESC, ID DESC" );
				//first insert a new record into the mailing table
				$nowSQLtime=date("Y-m-d H:i:s");
				
				
				
				
				
				$strSQL="SELECT * FROM " .  $strDatabase . ".mailing  ORDER BY mailing_id DESC";
				$records=$sql->query($strSQL);
				$record=$records[0];//only worry about the latest not-completed mailing
				$last_user_id_done=$record["last_user_id_done"];
				$mailing_count= $record["mailing_count"];
				if($mailing_count=="")
				{
					$mailing_count=0;
				}
				$mailing_date=$record["mailing_date"];
				$mailing_id=$record["mailing_id"];
				$thismailingcompleted=$record["completed"];
				$aborted=$record["aborted"];
				$glitch_experienced=$record["glitch_experienced"];
				if($aborted!=1  && $thismailingcompleted!=1)
				{
					header("location: " . $strPHP . "?message=" . urlencode("You need to wait for your last mailing to complete or else you need to abort it."));
					die("Woops!");
				}
				
				
				
				
				
				
				
				
				//CLEAR OUT THE MAIL LOG FOR A FRESH NEW MAILING
				$strSQL="TRUNCATE TABLE " . our_db . ".mail_log";
				$sql->query($strSQL);
				$mailing_id=UpdateOrInsert(our_db, "mailing","", Array("mailing_date"=>$nowSQLtime, "completed"=>0, "body_extra"=>$body_extra, "subject"=>$subject),  true,  false,  false);
				 //echo function_exists("GenericRSDisplayFromRS");
				//$out.=GenericRSDisplayFromRS($strPHP,"most active users", $records, 1, 999);
				$counter=0;
				foreach($emailrecords as $record)
				{
					//echo $counter . " " ;
					$offer_count=$record["OFFERCOUNT"];
					$recentest_offer=$record["RECENTEST_OFFER"];
					$user_id=$record["ID"];
					$email_str=$record["EMAIL_STR"];
					$email=$record["EMAIL"];
					$row_number=$record["RowNum"];
					$arrVals=Array();
					$arrVals=Array(
						"email"=>$email,
						"user_id"=>$user_id,
						"email_str"=>$email_str,
						"mailing_id"=>$mailing_id,
						"offer_count"=>$offer_count,
						"recentest_offer"=>$recentest_offer,
						"row_number"=>$row_number
									);
					//that final true on the next statement ensures we don't try to put it in the tsql db
					//$strSQL="INSERT INTO " . $strDatabase . "." . "mail_log SET  email='" . singlequoteescape($email) . "',user_id=". $user_id . ",email_str='". singlequoteescape($email_str). "',mailing_id=" .$mailing_id . ",offer_count=" .$offer_count .",recentest_offer='" . $recentest_offer . "'";
					//$sql->query($strSQL );
					//echo mysql_error();
					
					
					UpdateOrInsert(our_db, "mail_log","",$arrVals,  true,  false, true);
					$counter++;
				}

				header("location: " . $strPHP . "?refresh=true&message=" . urlencode("Mailing initiated for " . date("F jS Y") . ".  Do not navigate away from this page until the mailing concludes."));
			}
	 		$out.=EmailerForm($strDatabase, $maxids);
			$out.=Mailings();
			$out.=userfeedback($feedback);
		}
		
	}
	$out.= "<br><br>ongoing tasks:<br><iframe src='http://www.featurewell.com/tasks.php?refresh=" . $_REQUEST["refresh"] . "&d=" . date("YmdHis") . "' width='600' height='250'>
</iframe>";
	//PageHeader($strTitle, $strConfigBehave,$strForBackField="", $bwlIsStandalone=true, $bwlSuppressExternalHeader=false, $intMetaRefresh="")
	$refresh="";
	if($_REQUEST["refresh"]!="")
	{
		$refresh="120";
	}
	$strConfigBehave="notopnav";
	$out =  PageHeader($strDatabase . " : weekly mailer", $strConfigBehave, "", true, false, $refresh) . $out . PageFooter();
	//echo $out;
	return $out;
}

 

	
	
function EmailerForm($strDatabase, $maxids)
{
	$out="";
	$sql=conDB();
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strOtherBgClass="bgclassother";
	$strLineClass="bgclassline";
	$sourcename="ODBC";
	$strPHP=$_SERVER["PHP_SELF"];
	$destname="MySQL";
	$nowSQLtime=date("Y-m-d H:i:s");
	$preout.=adminbreadcrumb(false,  $strDatabase, "/tf/tf.php?" . qpre . "db=" . $strDatabase,  "weekly mailer");
	$preout.="&nbsp;&nbsp;&nbsp;[<a href=\"mailer.php?mode=refresh_mailing\">retally weekly sales</a>]";
	if($_REQUEST["refresh"]=="true")
	{
		$preout.=" | [<a href=\"mailer.php\">leave auto-refresh mode</a>]";
	}
	else
	{
		$preout.=" | [<a href=\"mailer.php?refresh=true\">enter auto-refresh mode</a>]";
	}
	$preout.="<form name=\"BForm\" method=\"post\" action=\"". $strPHP . "\" onSubmit=\"  \">\n";
	
	$strSQL="SELECT * FROM " .  $strDatabase . ".mailing  ORDER BY mailing_id DESC";
	$records=$sql->query($strSQL);
	$record=$records[0];//only worry about the latest not-completed mailing
	$last_user_id_done=$record["last_user_id_done"];
	$mailing_count=$record["mailing_count"];
	$mailing_date=$record["mailing_date"];
	$mailing_id=$record["mailing_id"];
	$thismailingcompleted=$record["completed"];
	$thismailingaborted=$record["aborted"];
	//echo $mailing_date . "sss vvv" . $nowSQLtime;
	$dysincelastmailing= date_differ($mailing_date, $nowSQLtime,  "day");
	$strAdditionalWarning="";
	if($thismailingcompleted==0)
	{
		$strAdditionalWarning=" Also, your last mailing has not been completed.";
	}
	if($thismailingaborted==1)
	{
		if($strAdditionalWarning=="")
		{
			$strAdditionalWarning.=" Your last mailing was completed, though for some reason you also felt the need to abort it.";
		}
		else
		{
			$strAdditionalWarning.="  (It was aborted.)";
		}
	}
	else
	{
		if($strAdditionalWarning=="")
		{
			$strAdditionalWarning.=" Your last mailing ran until it finished.";
		}
		else
		{
			$strAdditionalWarning.="  It will probably continue sending emails until it completes or you abort it.";
		}
	}
	$out.=htmlrow($strClassFirst, "subject", GenericInput("subject", "Top Stories - " .  date("F jS"),  false,  "",   "",  "",  "text", "40",  "", 1));
	$out.=htmlrow($strClassSecond, "body prefix", GenericInput("body", "To contact Featurewell's New York sales office, please call +1 (212) 924 2283 or email sales@featurewell.com",  false,  "",   "",  "",  "text", "80",  "", 5));
 	$out.=htmlrow($strClassFirst, GenericInput("weekly", "Send Weekly Email",  false,"return(confirm(\"Are you sure you want to send this mailing?  It has been " . substr($dysincelastmailing, 0, 4) . " days since the last mailing." . $strAdditionalWarning . "\"))",  "", "", "submit"),GenericInput("test", "Send Yourself a Test Email",  false,"",  "", "", "submit"));


	//$out.=htmlrow($strClassFirst, "<a onclick=\"return(confirm('Are you sure you want to send this mailing?  It has been " . $dysincelastmailing . " days since the last mailing." . $strAdditionalWarning . "'))\" href=\"". $strPHP . "?mode=schedulemail\">Send Weekly Mailing</a>");
	//$out.=htmlrow($strClassSecond, "<a  href=\"". $strPHP . "?mode=mailself\">Send Yourself A Test Mailing</a>");
	//$out.=htmlrow($strClassFirst, "<a href=\"". $strPHP . "?mode=viewemailprogress\">View Progress of Outgoing Emails</a>");
	$out.= HiddenInputs(Array("db"=>$strDatabase));
	$out=$preout . TableEncapsulate($out, false);
	$out.="</form>";
	return $out;
}


function Mailings($start=0, $number=10)
{
	$sql=conDB();
	$strSQL="SELECT * FROM " . our_db . ".mailing ORDER BY mailing_id DESC LIMIT " . $start . "," . $number;
	$records=$sql->query($strSQL);
	$strPHP=$_SERVER['PHP_SELF'];
	//GenericRSDisplay($strDatabase, $strPHP,$strLabel, $strSQL, $truncate, $intWidth, $strLinkFieldName="", $strLinkIDName="", $strAdditionalLink="", $strSuppressFields="", $bwlSuppressHeader=false, $bwlPrettyUpFieldNames=true, $intFieldLimit=10, $idencryptionstring="", $arrPostProcessing="", $arrFieldLabels="")
	$out=GenericRSDisplayFromRS("/tf/tf.php?" . qpre . "mode=edit&" . qpre. "table=mailing&" . qpre . "idfield=mailing_id","Past and current mailings", $records, 1, 999, "mailing_id", "", "<a onclick=\"return(confirm('Are you certain you want to abort this mailing?'))\" href=\"mailer.php?mode=abort&mailing_id=<replace/>\">abort</a> | <a onclick=\"return(confirm('Are you certain you want to restart this mailing?'))\" href=\"mailer.php?mode=restart&mailing_id=<replace/>\">restart</a>", "body_extra", false, true, 14, "", "", Array("glitches_experienced"=>"glitches"));
	return $out;
}

 


    ?>
