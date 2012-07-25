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
	if(contains(strtolower($_REQUEST[qpre ."mode"]),"email invoice"))
	{
		$mode="invoice_email";
	}
	$nowdatetime=date("Y-m-d H:i:s");
	$subject=$_REQUEST["subject"];
	$body_extra=$_REQUEST["body"];
	$strDatabase=our_db;
	$strColumn=$_REQUEST[qpre . "column"];
	$comprehensivesearch=gracefuldecaynumeric($_REQUEST[qpre . "comprehensivesearch"],0);
	error_reporting($olderror);
	$strPHP=$_SERVER['PHP_SELF'];
	$offer_id=$_REQUEST["ID"];
	$strTable=articletable ;
	$mailing_id=$_REQUEST["mailing_id"];
	$feedback=$_REQUEST["message"];
	$out="";
	//echo $id . " " .$idfield ;
	$bwlSimplifyLogin=false;
	$strConfigBehave="notopnav";
	$out=LoginDecisions($strDatabase,  $strPHP, $strUser, false, $strConfigBehave);
	$sql=conDB();
 	//$strUser="";
 	$strLineClass="bgclassline";
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strOtherBgClass="bgclassother";
	$strOtherLineClass="bgclassline";
	if ($strUser!="")
	{
		//die( $db_type);
		$intAdminType= AdministerType($strDatabase, $strTable, $strUser);
 
		if ($intAdminType>1)
		{	
			$invoice_id=$_REQUEST["invoice_id"];
			if($invoice_id!="")
			{
				//$invoice_record=GenericDBLookup(our_db,"INVOICE", "ID", $invoice_id, "") ;
				$offer_id=GenericDBLookup(our_db,"OFFER", "INVOICE_ID", $invoice_id, "ID") ;
				//echo 	"-" . $offer_id;
			}
			$offerrecord=GenericDBLookup(our_db,"OFFER", "ID", $offer_id, "") ;
			$article_id=$offerrecord["ARTICLE_ID"];
			$articlerecord=GenericDBLookup(our_db, articletable , "ID", $article_id, "") ;
			$author_id=$articlerecord["AUTHOR_ID"];
			//echo $author_id;
			$authorrecord=GenericDBLookup(our_db,"USERS", "ID", $author_id, "") ;
			$authoremail=gracefuldecay($authorrecord["EMAIL"], "author email unknown");
			$client_id= gracefuldecay($offerrecord["USER_ID"], $_REQUEST["client_id"]);
			//die("clientid:"  . $client_id . " rclientid:" .  $_REQUEST["client_id"] . " offerrecird:" .$offer_id );
			$clientrecord=GenericDBLookup(our_db,"USERS", "ID", $client_id, "") ;
	
			$client_email= $clientrecord["EMAIL"];
			$client_country=GenericDBLookup(our_db,"COUNTRY", "PHONE_CODE", $clientrecord["COUNTRY_CODE"], "NAME");
			$fromemail=GenericDBLookup(our_db,"content", "name", "AdminEmail", "content");
 			$headers = "From: " . $fromemail . "\r\nReply-To: " . $fromemail;
			//echo $mode;
			if($mode=="inform")
			{
			 
				$TextDefault="Sold '" . $articlerecord["TITLE"]. "' to " .   $clientrecord["PUBLICATION"]. ", in " . gracefuldecay($clientrecord["STATE"], $client_country).", for " . "$". $offerrecord["OFFER"] . ".  You receive 60 percent on collection.  \r\nBest--David";
				//GenericForm($arrFieldNames,  $arrLabels, $arrDefaults, $arrFieldConfigs, $strPHP, $strButtonLabel="Save", $width=630, $arrSizes="", $formextratags="", $formname="BForm", $bwlAllOneRow=false, $arrExtraButtons="", $strRequiredConfig="")
				$out.=  GenericForm(Array("EMAIL", "Subject", "Text"),"",  Array("EMAIL"=>$authoremail, "Text"=>$TextDefault, "Subject"=>"Featurewell Sale", "mode"=>"inform_send"), Array("Text"=>"size:8080", "EMAIL"=>"size:80", "Subject"=>"size:80"), $strPHP,  "EMAIL", 500, "", "");
			}
			else if($mode=="inform_send")
			{
				$out.=  "<div class='heading'>Author informed via email</div><br><br>";
				$fromemail=GenericDBLookup(our_db,"content", "name", "AdminEmail", "content");
				//$fromemail="featurewell@featurewell.com";
 				$headers = "From: " . $fromemail . "\r\nReply-To: " . $fromemail;
				//echo ($_REQUEST["EMAIL"] . "<P> " .  $_REQUEST["Text"] . "<P>" . $headers);
				error_reporting(E_ALL);

				$mailresponse=tf_mail($_REQUEST["EMAIL"], $_REQUEST["Subject"],  $_REQUEST["Text"], $headers, "-f" . $fromemail);
				//error_reporting(0);
				if(!$mailresponse)
				{
					$out.="Though the server claims it didn't go through.";
				}
				else
				{
					$out.="And the server claims it went through.";
				}
			}
			else if($mode=="invoice")
			{
	
				$strSQL="SELECT o.ID, a.TITLE, o.OFFER FROM OFFER o JOIN " . articletable . " a ON o.ARTICLE_ID=a.ID WHERE  o.STATUS='N'  AND o.USER_ID='" . intval($client_id) . "' ORDER BY o.TIMESTAMP DESC LIMIT 0, 10";
			 	//die($strSQL);
				$records = $sql->query($strSQL);
				if($offer_id!="" && count($records)==0)
				{
					$invoice_id=GenericDBLookup(our_db,"OFFER", "ID", $offer_id, "INVOICE_ID") ;
					header("location: invoicer.php?mode=create_invoice&invoice_id=" . $invoice_id);
					 
				}
				else
				{
				//echo $strSQL;
					echo mysql_error();
					$thisinfo="";
					$thisinfo.="<form name='BForm' action='invoicer.php' method='post'>\n";
					$thisinfo.=htmlrow($strOtherLineClass,"Buyer: ", $clientrecord["FIRST_NAME"],  $clientrecord["LAST_NAME"]);
					foreach($records as $record)
					{
						$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
						$thisinfo.=htmlrow($strThisBgClass, "<input type='checkbox' checked='true' name='offer_id[]' value='" . $record["ID"] . "'>" , $record["TITLE"] ,  "$". $record["OFFER"]);
					
					
					
					}
					$thisinfo.=htmlrow($strOtherLineClass, "", "",GenericInput("submit", "Invoice"));
					$thisinfo.="<input type=\"hidden\" name=\"mode\"   value=\"invoice_approve\">\n";
					$thisinfo.="<input type=\"hidden\" name=\"ID\"   value=\"" . $offer_id ."\">\n";
					$out.=TableEncapsulate($thisinfo, true, 500);
					$thisinfo.="</form>\n";
				}
			}
			else if($mode=="invoice_approve")
			{
				$moneycount=0;
				$strArticleList="";
				$strOfferIDList="";
				foreach($_REQUEST["offer_id"] as $thisofferid)
				{
					$strOfferIDList.=$thisofferid. " ";
					$thisofferrecord=GenericDBLookup(our_db,"OFFER", "ID", $thisofferid, "") ;
					$thisarticlerecord=GenericDBLookup(our_db, articletable, "ID", $thisofferrecord["ARTICLE_ID"], "") ;
					$thisauthorrecord=GenericDBLookup(our_db,"USERS", "ID", $thisarticlerecord["AUTHOR_ID"], "") ;
					$moneycount+=$thisofferrecord["OFFER"];
					$strArticleList.=date("j-M-y", strtotime($thisofferrecord["TIMESTAMP"]))  ." " .  $thisarticlerecord["TITLE"] .    " by " . $thisauthorrecord["FIRST_NAME"] . " " .$thisauthorrecord["LAST_NAME"] . " US$" . $thisofferrecord["OFFER"] . "\r\n";
				
				}
				$invoice_header=GenericDBLookup(our_db,"content", "name", "invoice_header", "content");
				$strInvoiceContent=$invoice_header . "
INVOICE #<invoice_number/>

DATE:         " . date("j F Y") . "
CLIENT:       " . $clientrecord["PUBLICATION"]  . "
PAYABLE BY:   " . date("j F Y", time()+2592000) . "
Tax ID#:      134137337


". $strArticleList. "

Total:        US" . "$". $moneycount . ".00" . " 
 
Thank You
Please credit Featurewell.com.";
			
			
		 		$out.=  GenericForm(Array("INVOICE_CONTENT"),Array("Invoice"),  Array("INVOICE_CONTENT"=>$strInvoiceContent,"offer_ids"=>$strOfferIDList, "mode"=>"create_invoice",  "client_id"=>$client_id), Array("INVOICE_CONTENT"=>"size:20099"), $strPHP,  "Create", 500, "", "");
				
 			}
			else if($mode=="create_invoice")
			{
				//echo $_REQUEST["INVOICE_CONTENT"];
				//echo "\n<P>\n";
				//$invoice_id=$_REQUEST["invoice_id"];
				if($invoice_id=="")
				{
					$invoice=removeslashesifnecessary($_REQUEST["INVOICE_CONTENT"]);
	
					//echo $invoice . "\n";
					$invoice_id= UpdateOrInsert(our_db, "INVOICE", "", Array("BODY"=> str_replace("'", "", $invoice), "TIMESTAMP"=>$nowdatetime, "STATUS"=>"N", "USER_ID"=>$client_id, "EMAIL"=>$client_email));
					//echo $invoice . "\n";
					//echo $invoice_id;
					//echo mysql_error();
					$invoice=str_replace("<invoice_number/>", $invoice_id, $invoice);
					//echo $invoice . "\n";
					UpdateOrInsert(our_db, "INVOICE", Array("ID"=>$invoice_id), Array("BODY"=>$invoice));
					$out.=  "<div class='heading'>Invoice Created</div><br><br>";;
				}
				else
				{
				 
					$invoice_record=GenericDBLookup(our_db,"INVOICE", "ID", $invoice_id, "") ;
					$invoice_MD=$invoice_record["INVOICE_MAIL_DATE"];
					$invoice=$invoice_record["BODY"];
					$strIMD="";
					if($invoice_MD!="")
					{
						$strIMD=" (mailed on " . $invoice_MD . ")";
					}
					$out.=  "<div class='heading'>Edit Invoice" . $strIMD . "</div><br><br>";;
				}
				//function GenericForm($arrFieldNames,  $arrLabels, $arrDefaults, $arrFieldConfigs, $strPHP, $strButtonLabel="Save", $width=630, $arrSizes="", $formextratags="", $formname="BForm", $bwlAllOneRow=false, $arrExtraButtons="", $strRequiredConfig="")
				$out.=  GenericForm(Array("INVOICE_CONTENT"),Array("Invoice"),  Array("INVOICE_CONTENT"=>$invoice, "mode"=>"invoice_save", "invoice_id"=>$invoice_id), Array("INVOICE_CONTENT"=>"size:20099"), $strPHP,  "Save Invoice Without Mailing", 500, "", "", "BForm", false, Array("mode"=>"Email Invoice to Client (while Saving Invoice Changes)"));
				$offer_ids=$_REQUEST["offer_ids"];
				$arrOfferIDs=explode(" ", $offer_ids);
				foreach($arrOfferIDs as $thisofferID)
				{
					if($thisofferID>0)
					{
						UpdateOrInsert(our_db, "OFFER", Array("ID"=>$thisofferID), Array("INVOICE_ID"=>$invoice_id));
					}
				}
				//$out.=  " <a style='background-color:#ffccaa;border-style: solid ; border-width: 1; margin:10px; padding:10px; font-size:14px' href='invoicer.php?mode=create_invoice&invoice_id=" .$invoice_id  ."'>Edit Invoice</a> &nbsp; &nbsp;";
				//$out.=  " <a style='background-color:#ffccaa;border-style: solid ; border-width: 1;  margin:10px;padding:10px; font-size:14px' href='invoicer.php?mode=invoice_email&invoice_id=" .$invoice_id  ."'>Email Invoice to Client</a> ";
			
			}
			else if($mode=="invoice_email")
			{
				//var_dump(	$clientrecord);
				//die();
				//$invoice_id=$_REQUEST["invoice_id"];
				//var_dump($_REQUEST);
				$invoice=removeslashesifnecessary($_REQUEST["INVOICE_CONTENT"]);
				$out.=  "<div class='heading'>Invoice Emailed to " .$client_email . "</div><br><br>";
	 			//=die($mode . " " . $client_email . " <BR><BR>" . $headers . " <BR><BR>" . $invoice);
				
				$fromemail=GenericDBLookup(our_db,"content", "name", "AdminEmail", "content");
 				$headers = "From: " . $fromemail . "\r\nReply-To: " . $fromemail;
				error_reporting(E_ALL);
				//send a copy to david:
				tf_mail($fromemail, "Featurewell Invoice (Admin Copy)",  $invoice, $headers, "-f" . $fromemail);
				//send a copy to client
				$intMailedResponse = tf_mail($client_email, "Featurewell Invoice",  $invoice, $headers, "-f" . $fromemail);
				error_reporting(0);
				$strSQL="SELECT * FROM OFFER WHERE INVOICE_ID='" . intval($invoice_id) . "'";
				
				//echo $strSQL;
				$records = $sql->query($strSQL);
				if($intMailedResponse)
				{
					foreach($records as $record)
					{
						UpdateOrInsert(our_db, "OFFER", Array("ID"=>$record["ID"]), Array("STATUS"=>"A"));
					}
					UpdateOrInsert(our_db, "INVOICE",Array("ID"=>$invoice_id), Array("STATUS"=>"O", "INVOICE_MAIL_DATE"=>$nowdatetime, "BODY"=>$invoice));
				}
				else
				{
					$out.= "<br>Oops! It doesn't seem that mailing went out!  Talk to Gus and see if he knows what is up!<br>";
				}
			}
			
			else if($mode=="invoice_save")
			{
				//$invoice_id=$_REQUEST["invoice_id"];
				$invoice=removeslashesifnecessary($_REQUEST["INVOICE_CONTENT"]);
				UpdateOrInsert(our_db, "INVOICE",Array("ID"=>$invoice_id), Array("BODY"=>$invoice));
				$out.=  "<div class='heading'>Invoice Saved</div><br><br>";
				$out.=  " <a style='background-color:#ffccaa;border-style: solid ; border-width: 1; margin:10px; padding:10px; font-size:14px' href='invoicer.php?mode=create_invoice&invoice_id=" .$invoice_id  ."'>Edit Invoice</a> &nbsp; &nbsp;";
				$out.=  " <a style='background-color:#ffccaa;border-style: solid ; border-width: 1;  margin:10px;padding:10px; font-size:14px' href='invoicer.php?mode=invoice_email&invoice_id=" .$invoice_id  ."'>Email Invoice to Client</a> ";
				 
				
			}
			else if($mode=="mark_paid")
			{
				//set status to "P"
				//$invoice_id=$_REQUEST["invoice_id"];
				$out.=  "<div class='heading'>Marking Invoice Paid...</div><br><br>";

				$invoice=removeslashesifnecessary($_REQUEST["INVOICE_CONTENT"]);
				$invoice=GenericDBLookup(our_db,"INVOICE", "ID", $invoice_id, "BODY") ;
				$out.=  "<form><textarea cols='100' rows='12'>" . $invoice . "\n\n</textarea></form>";
				$out.=  "<BR/>";
				$out.=  " <a style='background-color:#ffccaa;border-style: solid ; border-width: 1;  margin:10px;padding:10px; font-size:14px' href='invoicer.php?mode=mark_paid_done&invoice_id=" .$invoice_id  ."'>Mark as Paid</a> ";
			}
			else if($mode=="mark_paid_done")
			{
				//$invoice_id=$_REQUEST["invoice_id"];
				$out.=  "<div class='heading'>Invoice Now Marked Paid...</div><br><br>";
				$invoice=GenericDBLookup(our_db,"INVOICE", "ID", $invoice_id, "BODY") ;
				$out.=  "<form><textarea cols='100' rows='12'>" . $invoice . "\n\n</textarea></form>";
				UpdateOrInsert(our_db, "INVOICE",Array("ID"=>$invoice_id), Array("STATUS"=>"P", "PAID_DATE"=>$nowdatetime));
				$out.=  " <a style='background-color:#ffccaa;border-style: solid ; border-width: 1;  margin:10px;padding:10px; font-size:14px' href='invoicer.php?mode=mark_unppaid&invoice_id=" .$invoice_id  ."'>Mark as Unpaid</a> ";
			}
			else if($mode=="mark_unppaid")
			{
				//$invoice_id=$_REQUEST["invoice_id"];
				$out.=  "<div class='heading'>Invoice Now Marked Unpaid...</div><br><br>";
				$invoice=GenericDBLookup(our_db,"INVOICE", "ID", $invoice_id, "BODY") ;
				$out.=  "<form><textarea cols='100' rows='12'>" . $invoice . "\n\n</textarea></form>";
				UpdateOrInsert(our_db, "INVOICE",Array("ID"=>$invoice_id), Array("STATUS"=>"O", "PAID_DATE"=>'1969-12-31 17:00:00'));
				$out.=  " <a style='background-color:#ffccaa;border-style: solid ; border-width: 1;  margin:10px;padding:10px; font-size:14px' href='invoicer.php?mode=mark_paid_done&invoice_id=" .$invoice_id  ."'>Mark as Paid</a> ";
			
			}
			else if($mode=="delete")
			{
 
				$out.=  "<div class='heading'>Deleting Offer...</div><br><br>";
				$out.= str_replace('"submit"', '"hidden"', FrontEndTableForm("our_db", "SELECT * FROM OFFER WHERE ID=" . intval($offer_id),  "OFFER", "ID", intval($offer_id), "/tf/tf.php",  "", "", "", ""));
				
				$out.=  " <a style='background-color:#ffccaa;border-style: solid ; border-width: 1;  margin:10px;padding:10px; font-size:14px' href='invoicer.php?mode=delete_done&ID=" .intval($offer_id)."'>Delete This Offer</a> ";
			
			}
			else if($mode=="delete_done")
			{
 
				$out.=  "<div class='heading'>Offer #" .$offer_id . " Deleted</div><br><br>";
				DeleteBySpec(our_db, "OFFER", Array("ID"=>intval($offer_id)));
			
			}
			else if($mode=="fromscratch")
			{
				//showResult(str, returntextfield, table, returnid)
				$out.= "<div id='livesearch' style='float:left;width:230px;height:200px;z-index:10;position:absolute;top:30px;left:450px'></div>";
 				$out.=  "<script src=\"invoicer.js\"><!-- --></script> ";
				$out.=  "<div class='heading'>Create Offer From Scratch...</div> ";
				$out.=  "<div class='info'>Make sure to click on an item at right after search results appear.</div> ";
				$out.=  "<div class='info'>The list will narrow as you type the article name or email address.</div> ";
				$out.= "<table>";
				$out.=  "<form name='BForm' action='invoicer.php' method='post'> \n";
				$out.=  "<tr><td>article: </td><td><input name='article_name' value='' onkeyup='showResult(this.value,\"article_name\", \"" . articletable . "\",\"article_id\")' type='text' size='30'>\n</td></tr>";
				$out.=  "<input name='article_id' value='' type='hidden'  ></td></tr>\n";
				$out.=  "<tr><td>user:</td><td> <input name='user_name' value='' onkeyup='showResult(this.value, \"user_name\",\"USERS\",\"user_id\")' type='text' size='30'></td></tr>\n";
				$out.=  "<input name='user_id' value='' type='hidden'  ></td></tr>\n";
				$out.=  "<td>offer (in dollars):</td><td> $<input name='offer' value='' type='text' size='30'></td></tr>\n";
				$out.=  "<td valign='top'>notes:</td><td> <textarea name='notes'  rows='3' cols='44'></textarea></td></tr>\n";
				$out.= "<td>status:</td><td> " . foreigntablepulldown(our_db, "status", "code", "",  "STATUS", $return, false,"status_description ") . "</td></tr>";
				$out.=  "<tr><td colspan='2'><input name='submit' value='Create' type='submit'  ></td></tr>\n";
				$out.=  "<input name='mode' value='fromscratch_done' type='hidden'  ></td></tr>\n";
				$out.=  "<input name='currency' value='USD' type='hidden'  ></td></tr>\n";
				$out.= "</table>";
				$out.=  "</form>\n";
 
			
			}
			else if($mode=="fromscratch_done")
			{
				$out.=  "<div class='heading'>Offer Created...</div> ";
				$article_id=$_REQUEST["article_id"];
				$thisuser_id=$_REQUEST["user_id"];
				$currency=$_REQUEST["currency"];
				$offer=$_REQUEST["offer"];
				$notes=$_REQUEST["notes"];
				$status=gracefuldecay($_REQUEST["STATUS"], 'N');
				$timestamp=$nowdatetime;
				$arrVals=Array("TIMESTAMP"=>$timestamp,
								"ARTICLE_ID"=>$article_id,
								"USER_ID"=>$thisuser_id,
								"INVOICE_ID"=>0,
								"OFFER"=>$offer,
								"NOTES"=>$notes,
								"PIC_OFFER"=>0,
								"STATUS"=>$status);
				UpdateOrInsert(our_db, "OFFER", "", $arrVals);
								$out.= "<table>";
				$out.=  "<form name='BForm' action='invoicer.php' method='post'> \n";
				$out.=  "<tr><td>article: </td><td>" . $article_id . ": " . $_REQUEST["article_name"] . "\n</td></tr>";
			 
				$out.=  "<tr><td>user:</td><td> " . $thisuser_id . ": " . $_REQUEST["user_name"] . "</td></tr>\n";
 
				$out.=  "<td>offer (in dollars):</td><td>" . $offer . "</td></tr>\n";
				$out.=  "<td valign='top'>notes:</td><td>  " . $notes . "</td></tr>\n";
				$out.= "<td>status:</td><td> " . $status . "</td></tr>";

				$out.= "</table>";
			
			}
			$out.=  " <br><br><br><a style='background-color:#ffccaa;border-style: solid ; border-width: 1;  margin:10px;padding:10px; font-size:14px' href='javascript:window.close()'>Close This Window</a> ";
	 
		}
	}
	$out =  PageHeader($strDatabase . " : invoicer", $strConfigBehave, "", true, false, "") . $out . "<script>window.focus()</script>" . PageFooter() ;
	//echo $out;
	return $out;
}

 


 

?>