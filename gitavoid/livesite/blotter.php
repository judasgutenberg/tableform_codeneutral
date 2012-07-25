<?php
$strPathPre="tf/";
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
	$strTable= articletable;
	$mailing_id=$_REQUEST["mailing_id"];
	$feedback=$_REQUEST["message"];
	$out="";
	//echo $id . " " .$idfield ;
	$bwlSimplifyLogin=false;
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
				
			}
			$roles="C";
			$out.="<table>\n";
			$out.="<tr>\n";
			$out.="<td valign='top'>\n";
			$out.= HitsDisplay($roles);
			$out.="</td>\n";
			$out.="<td valign='top'>\n";
			
			$out.= OffersDisplay();
			$out.= NewArticles();
			$out.= RecentSearches();
			$out.=MailingClick();
			$out.="</td>\n";
			$out.="<td valign='top'>\n";
			$out.= NewUsers($roles);
			$out.= InvoicesDue();
			$out.="</td>\n";
			$out.="</tr>\n";
			$out.="</table>\n";
		}
	}
	$out =  PageHeader($strDatabase . " : blotter", $strConfigBehave, "", true, false, $refresh) . $out . PageFooter();
	//echo $out;
	return $out;
}

function HitsDisplay($roles)
{
	$strHitURL="/tf/tf.php?x_db=featurewell&x_table=HIT&x_mode=edit&x_idfield=TIMESTAMP&x_displaytype=&x_filterid=&x_rec=0&x_column=TIMESTAMP&TIMESTAMP=";
	$strUserURL="/tf/tf.php?x_db=featurewell&x_table=USERS&x_mode=edit&x_idfield=ID&x_displaytype=&x_filterid=&x_rec=0&x_column=ID&ID=";
	$strArticleURL="/tf/tf.php?x_db=featurewell&x_table=" . articletable . "&x_mode=edit&x_idfield=ID&x_displaytype=&x_filterid=&x_rec=0&x_column=ID&ID=";
	$strSQL="
		select  HIT.TIMESTAMP, HIT.USER_ID, HIT.ARTICLE_ID, USERS.USERNAME as 'username',  TITLE as 'title', TIMEDIFF( NOW(),HIT.TIMESTAMP ) AS 'ago' from HIT JOIN USERS ON HIT.USER_ID = USERS.ID JOIN " . articletable . " ON HIT.ARTICLE_ID=article.ID where HIT.TIMESTAMP > DATE_ADD( NOW(),INTERVAL -1 DAY) and ROLES like '%" . $roles . "%' order by HIT.TIMESTAMP DESC
	";
 	$out= GenericRSDisplay(our_db,"blotter.php","Hits", $strSQL, 1, 350, "", "", "", "AUTHOR_ID ARTICLE_ID USER_ID TIMESTAMP", false, true, 10, "", 
	Array("ago"=>"TIMESTAMP^" . $strHitURL, 
	"title"=>"ARTICLE_ID^" . $strArticleURL, 
	"username"=>"USER_ID^" .$strUserURL  )); //date('D H:i',strtotime('<value/>
	// GenericRSDisplay($strDatabase, $strPHP,$strLabel, $strSQL, $truncate, $intWidth, $strLinkFieldName="", $strLinkIDName="", $strAdditionalLink="", $strSuppressFields="", $bwlSuppressHeader=false, $bwlPrettyUpFieldNames=true, $intFieldLimit=10, $idencryptionstring="", $arrPostProcessing="", $arrFieldLabels="", $bwlSuppressLinksWhereNoData=true)
	$out=str_replace("idsorttable", "idsorttable0", $out);
	return $out;
}
  
function OffersDisplay()
{
 
	$strUserURL="/tf/tf.php?x_db=featurewell&x_table=USERS&x_mode=edit&x_idfield=ID&x_displaytype=&x_filterid=&x_rec=0&x_column=ID&ID=";
	$strArticleURL="/tf/tf.php?x_db=featurewell&x_table=" . articletable . "&x_mode=edit&x_idfield=ID&x_displaytype=&x_filterid=&x_rec=0&x_column=ID&ID=";
	$strPHP="/tf/tf.php?x_db=featurewell&x_table=OFFER&x_mode=edit&x_idfield=ID&x_displaytype=&x_filterid=&x_rec=0&x_column=ID";
	$strSQL="
	  select o.ID, Concat('$', FORMAT(o.OFFER,2)) as 'USD', o.TIMESTAMP,  USER_ID, u.USERNAME as 'username', ARTICLE_ID, a.TITLE as 'title', a.AUTHOR_ID, concat(AUTHOR_USER.FIRST_NAME, ' ', AUTHOR_USER.LAST_NAME) as author , TIMEDIFF(NOW(),o.TIMESTAMP) as ago from OFFER o left join USERS u on u.ID = o.USER_ID left join COUNTRY c on COUNTRY_CODE = c.PHONE_CODE join " . articletable . " a on a.ID = o.ARTICLE_ID left join USERS AUTHOR_USER ON AUTHOR_USER.ID = a.AUTHOR_ID where o.TIMESTAMP > Date_Add(NOW(),INTERVAL -7 DAY) order by o.TIMESTAMP DESC
 	";
 	$out= GenericRSDisplay(our_db, $strPHP,"Sales", $strSQL,1, 500 , "", "", "", "AUTHOR_ID ARTICLE_ID USER_ID", false, true, 10, "", 
	Array("TIMESTAMP"=>"date('D H:i',strtotime('<value/>'))", "author"=>"AUTHOR_ID^" . $strUserURL, "title"=>"ARTICLE_ID^" . $strArticleURL, "username"=>"USER_ID^" .$strUserURL ));
// GenericRSDisplay($strDatabase, $strPHP,$strLabel, $strSQL, $truncate, $intWidth, $strLinkFieldName="", $strLinkIDName="", $strAdditionalLink="", $strSuppressFields="", $bwlSuppressHeader=false, $bwlPrettyUpFieldNames=true, $intFieldLimit=10, $idencryptionstring="", $arrPostProcessing="", $arrFieldLabels="", $bwlSuppressLinksWhereNoData=true)
	$out=str_replace("idsorttable", "idsorttable1", $out);
	return $out;
}

function NewArticles()
{
	$strUserURL="/tf/tf.php?x_db=featurewell&x_table=USERS&x_mode=edit&x_idfield=ID&x_displaytype=&x_filterid=&x_rec=0&x_column=ID&ID=";
	$strArticleURL="/tf/tf.php?x_db=featurewell&x_table=" . articletable . "&x_mode=edit&x_idfield=ID&x_displaytype=&x_filterid=&x_rec=0&x_column=ID&ID=";
	$strPHP="/tf/tf.php?x_db=featurewell&x_table=" . articletable . "&x_mode=edit&x_idfield=ID&x_displaytype=&x_filterid=&x_rec=0&x_column=ID";
	$strSQL="
		select " . articletable . ".ID,TITLE as 'title', AUTHOR_ID, concat(FIRST_NAME, ' ', LAST_NAME) as author, " . articletable . ".ACTIVE, LATEST, TIMEDIFF(NOW()," . articletable . ".TIMESTAMP) as ago
		from " . articletable . ", USERS
		where USERS.ACTIVE=1
		and AUTHOR_ID = USERS.ID
		
		order by LOADED_DATE DESC LIMIT 0,40";
		//and DATEDIFF(now(),LOADED_DATE) < 5
	$out= GenericRSDisplay(our_db, $strPHP,"New Articles", $strSQL,1,500 , "", "", "", "AUTHOR_ID ", false, true, 10, "", 
	Array( "author"=>"AUTHOR_ID^" . $strUserURL, "title"=>"ID^" . $strArticleURL ));
	$out=str_replace("idsorttable", "idsorttable2", $out);
	return $out;
}

function NewUsers($roles)
{
	$strUserURL="/tf/tf.php?x_db=featurewell&x_table=USERS&x_mode=edit&x_idfield=ID&x_displaytype=&x_filterid=&x_rec=0&x_column=ID&ID=";
	$strPHP="/tf/tf.php?x_db=featurewell&x_table=USERS&x_mode=edit&x_idfield=ID&x_displaytype=&x_filterid=&x_rec=0&x_column=ID";
	$strSQL="
		select ID,USERNAME as 'username',FIRST_NAME,LAST_NAME, TIMEDIFF(NOW(), TIMESTAMP) AS ago from USERS   where ACTIVE=1  and TIMESTAMP > DATE_ADD(now(), interval  -1 DAY)  and ROLES like '" . $roles . "' order by TIMESTAMP DESC";
	$out= GenericRSDisplay(our_db, $strPHP,"New Clients", $strSQL,33, 300 , "", "", "", "", false, true, 10, "", 
	Array( "username"=>"ID^" . $strUserURL ));
	$out=str_replace("idsorttable", "idsorttable3", $out);
	return $out;
}

function RecentSearches()
{
	$strUserURL="/tf/tf.php?x_db=featurewell&x_table=USERS&x_mode=edit&x_idfield=ID&x_displaytype=&x_filterid=&x_rec=0&x_column=ID&ID=";
	$strSearchURL="/tf/articlelister.php?x_searchtype=1&x_searchfield=TEXT&x_searchbutton=search+" . articletable . "s&x_searchstring=";
	$strPHP="/tf/tf.php?x_db=featurewell&x_table=USERS&x_mode=edit&x_idfield=ID&x_displaytype=&x_filterid=&x_rec=0&x_column=ID";
	$strSQL="select ID,USERNAME as 'username',  search_string, fields, daterange, result_count as 'results',  TIMEDIFF(NOW(), s.timestamp) AS ago from USERS u JOIN search s ON u.ID=s.user_id   order by s.timestamp DESC LIMIT 0,30";
	//echo $strSQL;
	$out= GenericRSDisplay(our_db, $strPHP,"Recent Searches", $strSQL,33, 500 , "", "", "", "ID", false, true, 10, "", 
	Array( "username"=>"ID^" . $strUserURL, "search_string"=>"search_string^" .  $strSearchURL));
	$out=str_replace("idsorttable", "idsorttable4", $out);
	return $out;
}

function InvoicesDue()
{
	// GenericRSDisplay($strDatabase, $strPHP,$strLabel, $strSQL, $truncate, $intWidth, $strLinkFieldName="", $strLinkIDName="", $strAdditionalLink="", $strSuppressFields="", $bwlSuppressHeader=false, $bwlPrettyUpFieldNames=true, $intFieldLimit=10, $idencryptionstring="", $arrPostProcessing="", $arrFieldLabels="", $bwlSuppressLinksWhereNoData=true)
	$windowconfig="menubar=yes,height=400,width=900,scrollbars=yes";
	$strUserURL="/tf/tf.php?x_db=featurewell&x_table=USERS&x_mode=edit&x_idfield=ID&x_displaytype=&x_filterid=&x_rec=0&x_column=ID&ID=";
	$strPHP="/tf/tf.php?x_db=featurewell&x_table=INVOICE&x_mode=edit&x_idfield=ID&x_displaytype=&x_filterid=&x_rec=0&x_column=ID";
	$strSQL="
		select INVOICE.ID, INVOICE.TIMESTAMP, INVOICE.STATUS, DATE_ADD(INVOICE.TIMESTAMP, INTERVAL 30 DAY) AS DUE,  USER_ID, USERNAME as username  from INVOICE, USERS AS CLIENT  where CLIENT.ID = USER_ID  and INVOICE.STATUS = 'O'  and DATE_ADD(INVOICE.TIMESTAMP, INTERVAL 30 DAY) < NOW()  order by INVOICE.TIMESTAMP desc";
	$out= GenericRSDisplay(our_db, $strPHP,"Invoices Due", $strSQL,33, 300 , "", "", "<a href=\"javascript:remote=window.open('invoicer.php?mode=mark_paid&invoice_id=<ID/>', 'invoicer','" . $windowconfig . "');remote.focus()\">paid</a>", "STATUS USER_ID", false, true, 10, "", 
	Array( "username"=> "USER_ID^" . $strUserURL, "TIMESTAMP"=>"date('Y-m-d',strtotime('<value/>'))", "DUE"=>"date('Y-m-d',strtotime('<value/>'))"));
	$out=str_replace("idsorttable", "idsorttable5", $out);
	return $out;
}

function MailingClick()
{
	$strUserURL="/tf/tf.php?x_db=featurewell&x_table=USERS&x_mode=edit&x_idfield=ID&x_displaytype=&x_filterid=&x_rec=0&x_column=ID&ID=";
	$strArticleURL="/tf/tf.php?x_db=featurewell&x_table=" . articletable . "&x_mode=edit&x_idfield=ID&x_displaytype=&x_filterid=&x_rec=0&x_column=ID&ID=";
	$strMailingURL="/tf/tf.php?x_db=featurewell&x_table=mailing&x_mode=edit&x_idfield=mailing_id&x_displaytype=&x_filterid=&x_rec=0&x_column=ID&mailing_id=";
	$strSQL="
		select mailing_date  as mailing, u.USERNAME as 'username', TITLE as 'title',  cc.article_id, cc.user_id, cc.mailing_id ,  TIMEDIFF( NOW(),time_of_click ) AS 'ago' from mailing_click cc JOIN " . articletable . " a ON a.ID=cc.article_id JOIN USERS u ON cc.user_id=u.ID JOIN mailing mm ON cc.mailing_id=mm.mailing_id ORDER BY time_of_click  DESC LIMIT 0,50 
	";
 	$out= GenericRSDisplay(our_db,"blotter.php","Mailing Clickthroughs", $strSQL, 1, 500, "", "", "", "article_id user_id", false, true, 10, "", 
	Array("username"=>"user_id^" . $strUserURL, "title"=>"article_id^" . $strArticleURL , "mailing"=>"mailing_id^" . $strMailingURL));

	$out=str_replace("idsorttable", "idsorttable6", $out);
	return $out;
}




?>