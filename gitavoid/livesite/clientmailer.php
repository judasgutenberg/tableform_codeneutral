<?php
$strPathPre="tf/";
include_once($strPathPre . "fw_functions.php");
$urlroot="http://www.featurewell.com/";
include_once($strPathPre . "tf_constants.php");
include_once($strPathPre . "tf_functions_core.php");
include_once($strPathPre . "tf_functions_editor.php");
include_once($strPathPre . "tf_functions_frontend_db.php");
include_once($strPathPre . "tf_functions_odbc.php");

set_time_limit(1900);
 
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
 
 
	$subject=$_REQUEST["subject"];
	$body=$_REQUEST["body"];
	$strDatabase=our_db;
	$strColumn=$_REQUEST[qpre . "column"];
	$comprehensivesearch=gracefuldecaynumeric($_REQUEST[qpre . "comprehensivesearch"],0);
	error_reporting($olderror);
	$strPHP=$_SERVER['PHP_SELF'];
	$strValDefault=$_REQUEST["ID"];
	$strTable="article";
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
	
	 		$out.=EmailerForm($strDatabase, $maxids);
			$out.=userfeedback($feedback);
		}
		//die($mode);
		if($mode=="sendmail"  )
		{
			
			UpdateOrInsert(our_db, "mass_mailing","", Array("active"=>1, "sent_count"=>0,"timestamp"=>date("Y-m-d H:i:s"), "body_text"=>$body, "subject"=>$subject),  true,  false,  false);
			$out.="mailing scheduled";
			if(1==2)
			{
				$mtrnd=mt_rand(0,8000);
				$strSQL="SELECT EMAIL, ID FROM " . our_db . ".USERS WHERE LAST_SPAM<'" .  date("Y-m-d") . "'  OR LAST_SPAM IS NULL LIMIT " . $mtrnd. ",150";
				$records=$sql->query($strSQL);
				//echo $strSQL . " " . mysql_error();
				foreach($records as $record)
				{
					$email=$record["EMAIL"];
					$thisid=$record["ID"];
					//echo $body .  " " . $email . "<BR>";
					$from="sales@featurewell.com";
					$headers = "From: " . $from . "\r\nReply-To: " . $from;
					//echo "----\n\n" . $emailstr . " " . $subject."\n\n" .  $body;
					if($body!="" && $email!="")//dont bother to send emails that have no essential body
					{
						//echo $email . "|" . $subject . "|" . $body . "|" . $headers . "<BR>";
						$intMailedResponse=tf_mail($email, $subject,  $body, $headers, "-fsales@featurewell.com");
					 
						$out.=$thisid . " " . $email . "<BR>";
						if($intMailedResponse)
						{
							UpdateOrInsert(our_db, "USERS",Array("ID"=>$thisid), Array("LAST_SPAM"=>date("Y-m-d H:i:s")),  true,  false,  false);
						}
					}
				}
			}
		}
		
	}
 
	//PageHeader($strTitle, $strConfigBehave,$strForBackField="", $bwlIsStandalone=true, $bwlSuppressExternalHeader=false, $intMetaRefresh="")
 
	$out =  PageHeader($strDatabase . " : mass mailer", $strConfigBehave, "", true, false, $refresh) . $out . PageFooter();
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
	$preout.=adminbreadcrumb(false,  $strDatabase, "/tf/tf.php?" . qpre . "db=" . $strDatabase,  "mass mailer");
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
	 
	$out.=htmlrow($strClassFirst, "subject", GenericInput("subject",  "",  false,  "",   "",  "",  "text", "40",  "", 1));
	$out.=htmlrow($strClassSecond, "body", GenericInput("body", "",  false,  "",   "",  "",  "text", "80",  "", 5));
 	$out.=htmlrow($strClassFirst, GenericInput("weekly", "Send Mass Email",  false,"return(confirm(\"It will go to everyone." . $strAdditionalWarning . "\"))",  "", "", "submit"),"");
	//GenericInput("test", "Send Yourself a Test Email",  false,"",  "", "", "submit")

	//$out.=htmlrow($strClassFirst, "<a onclick=\"return(confirm('Are you sure you want to send this mailing?  It has been " . $dysincelastmailing . " days since the last mailing." . $strAdditionalWarning . "'))\" href=\"". $strPHP . "?mode=schedulemail\">Send Weekly Mailing</a>");
	//$out.=htmlrow($strClassSecond, "<a  href=\"". $strPHP . "?mode=mailself\">Send Yourself A Test Mailing</a>");
	//$out.=htmlrow($strClassFirst, "<a href=\"". $strPHP . "?mode=viewemailprogress\">View Progress of Outgoing Emails</a>");
	$out.= HiddenInputs(Array("db"=>$strDatabase ));
	$out.= HiddenInputs(Array("mode"=>"sendmail" ), "");
	$out=$preout . TableEncapsulate($out, false);
	$out.="</form>";
	return $out;
}

 


    ?>
