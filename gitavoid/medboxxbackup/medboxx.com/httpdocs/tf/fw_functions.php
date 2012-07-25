<?php
 







 

 




function CopySchemaFromODBCToMySQL()
{
	GLOBAL $db_type;
	$sql=conDB();
	$db_type="odbc";
	$strDatabase="dbo";
	$tables=TableList($strDatabase);
	$errors="";
	foreach($tables as $table)
	{
		$db_type="odbc";
		$strDatabase="dbo";
		$tablename= $table["Tables_in_" . str_replace("`", "", $strDatabase)];
		//TableExplanationToTableCreationSQL($strDatabase, $strTable, $bwlGuessPK=true, $bwlGuessAutoInc=true);
		//echo $tablename . "<BR>";
		$strCreationSQL=TableExplanationToTableCreationSQL($strDatabase, $tablename, true, true);
		$db_type="";
		$strDatabase="featurewell";
		
		if(!TableExists($strDatabase, $tablename))
		{
			$records = $sql->query($strCreationSQL, true, $strDatabase);
		}
		//echo "-" . TableExists($tablename) . "-<BR>";
		//echo $tablename . " <br>"; 
		//echo "<pre>" . $strCreationSQL . "</pre>";
		//echo  "<P>";
		$error= sql_error();
		//echo  $error;
		$errors.= $error . IFAThenB($error  ,"<br>\n" );
		
	}
	return $errors;
}


function SyncDataFromODBCToMySQL($maxinago=300, &$tablesout, $mode="", $maxids="" )
{
	GLOBAL $db_type;
	$sql=conDB();
	$db_type="odbc";
	$strDatabase="dbo";
	$tables=TableList($strDatabase);
	$tablesout="";
	$rowcount=0;
	$out="";
	$bwlMaxidsource=false;
	$strSQLOut="";
	if($maxids!="")
	{
		$bwlMaxidsource=true;
	}
	foreach($tables as $table)
	{
		
		//TO ODBC
		$db_type="odbc";
		$strDatabase="dbo";
		$sourcetablename= $table["Tables_in_" . str_replace("`", "", $strDatabase)];
		$sourcepk=PKLookup($strDatabase, $sourcetablename, true);
		echo $sourcepk . "<BR>";
		$strSQL="SELECT MAX(" . $sourcepk . ") as thismax FROM " .   $sourcetablename;
		//echo $strSQL. "<BR>";
		$records=$sql->query($strSQL);
		$record=$records[0];
		$sourcemax=$record["thismax"];
		
		//TO MYSQL
		$db_type="";
		$strDatabase=our_db;
		$desttablename= $sourcetablename;
		if(strtolower( $sourcetablename)=="article")
		{
		
			$desttablename=strtolower( $sourcetablename);
		}
		$destpk=PKLookup($strDatabase, $desttablename, true);
		if($bwlMaxidsource)
		{
			$destmax=trim(genericdata($desttablename,0, 1, $maxids, "\n", " ", false));
			//echo( $desttablename . "-" . $destmax . "-<BR>");
		}
		else
		{
			$strSQL="SELECT MAX(" . $destpk . ") as thismax FROM " . $strDatabase . "." .  $desttablename;
			//echo $strSQL  ."<P>";
			$records=$sql->query($strSQL);
			$record=$records[0];
			$destmax=gracefuldecaynumeric($record["thismax"],0);
		}
		
		if($mode=="onlymysqlids")
		{
	 
			$line=$desttablename . " " . $destmax . "\n";
		}
		else if($mode=="onlyodbcids")
		{
			$line=$sourcetablename . " " . $sourcemax . "\n";
		
		}
		//echo  $sourcetablename . " " . $sourcemax . " " . $destmax . "<BR>";
		else if($sourcemax>$destmax)
		{
			//TO ODBC
			$db_type="odbc";
			$strDatabase="dbo";
			$strSQL="SELECT TOP " . $maxinago. " * FROM " .   $sourcetablename . " WHERE " .  $sourcepk . ">" . $destmax . " ORDER BY " . $sourcepk . " ASC";
			//echo $strSQL;
			$records=$sql->query($strSQL);
			//echo $maxinago . " " . count($records) . "<BR>";
			//TO MYSQL
			$db_type="";
			$strDatabase=our_db;
			
			foreach($records as $record)
			{
	
				$strSQL=AssociativeArrayToInsertStatement($record, $desttablename);
			
				//echo "<font color=red>" . mysql_error() . "</font>" . "<P>";
				if($bwlMaxidsource)
				{	
					//echo $strSQL . "<BR>";
					$strSQLOut.=$strSQL . "\n";
				}
				else
				{
					$sql->query($strSQL);
					if( mysql_error()!="")
					{
						die( mysql_error() . "<BR>" . $strSQL);
					}
				}
				$rowcount++;
				if($maxinago<$rowcount)
				{
					if($bwlMaxidsource)
					{
						
						return $strSQLOut;
					}
					else
					{
						return $out;
					}
				}
				if(!inList($tablesout, $sourcetablename ))
				{
					$tablesout.= $sourcetablename . " ";
				}
			}	
			
			
			
		}
		 
		if($line!="")
		{
			$out.=$line;
		}
		else if ($mode=="")
		{
			$error= sql_error();
			$out.= $error . IFAThenB($error,"<br/>\n");
		}
	}

	if($bwlMaxidsource)
	{
		
		return $strSQLOut;
	}
 
	return $out;
}


function SyncDataFromODBCToODBC($maxinago=300, &$tablesout)
{
	GLOBAL $db_type;
	GLOBAL $source;
	$sql=conDB();
	$db_type="odbc";
	$strDatabase="dbo";
	$source="original";
	$tables=TableList($strDatabase);
	$tablesout="";
	$rowcount=0;
	foreach($tables as $table)
	{
		//TO ODBC SOURCE
		$db_type="odbc";
		$strDatabase="dbo";
		$source="original";
		$sourcetablename= $table["Tables_in_" . str_replace("`", "", $strDatabase)];
		echo $sourcetablename . "<BR>";
		$sourcepk=PKLookup($strDatabase, $sourcetablename, true);
		$strSQL="SELECT MAX(" . $sourcepk . ") as thismax FROM " .   $sourcetablename;
		//echo $strSQL. "<BR>";
		$records=$sql->query($strSQL);
		$record=$records[0];
		$sourcemax=$record["thismax"];
		//TO ODBC DEST
		$db_type="odbc";
		$strDatabase="dbo";
		$source="";
		$desttablename= $sourcetablename;
		$destpk=PKLookup($strDatabase, $desttablename, true);
		$strSQL="SELECT MAX(" . $destpk . ") as thismax FROM " . $strDatabase . "." .  $desttablename;
		//echo $strSQL  ."<P>";
		$records=$sql->query($strSQL);
		$record=$records[0];
		$destmax=gracefuldecaynumeric($record["thismax"],0);
		
		//echo  $sourcetablename . " " . $sourcemax . " " . $destmax . "<BR>";
		if($sourcemax>$destmax)
		{
			//TO ODBC SOURCE
			$db_type="odbc";
			$strDatabase="dbo";
			$source="original";
			$strSQL="SELECT TOP " . $maxinago. " * FROM " .   $sourcetablename . " WHERE " .  $sourcepk . ">" . $destmax . " ORDER BY " . $sourcepk . " ASC";
			//echo $strSQL;
			$records=$sql->query($strSQL);
			//echo $maxinago . " " . count($records) . "<BR>";
			
			//TO ODBC DEST
			$source="";
			$db_type="odbc";
			$strDatabase="dbo";
			$db_type="";
			$strDatabase=our_db;
			
			foreach($records as $record)
			{
				$strSQL=AssociativeArrayToInsertStatement($record, $desttablename);
		 
				if( mysql_error()!="")
				{
					die($strSQL);
				}
				echo "<font color=red>" . mysql_error() . "</font>" . "<P>";
				$sql->query($strSQL);
				$rowcount++;
				if($maxinago<$rowcount)
				{
					return;
				}
				if(!inList($tablesout, $sourcetablename ))
				{
					$tablesout.= $sourcetablename . " ";
				}
			}	
		}
		$error= sql_error();
		$error.= $error . IFAThenB($error,"<br/>\n");
		
	}
	return $error;
}

function SyncFWODBCtoMySQL($maxinago=300, &$tablesout, $mode="")//$mode could also be "sqlonly"
{
	GLOBAL $db_type;
	GLOBAL $connStr;
	$strConfig="article|ID|ARTICLE_CATEGORY|ARTICLE_ID-article|ID|ARTICLE_PICTURE|ARTICLE_ID-USERS|ID|BOOKMARK|USER_ID-USERS|ID|HIT|USER_ID-USERS|ID|USER_CATEGORY|USER_ID";
	$sql=conDB();
	$db_type="odbc";
	$strDatabase="dbo";
	//die($connStr);
	$tables=TableList($strDatabase);
	$tablesout="";
	$rowcount=0;
	$out="";
	$strSQLOut="";

	foreach($tables as $table)
	{
		//echo $table . "<BR>";
		//TO ODBC
		$db_type="odbc";
		$strDatabase="dbo";
		$sourcetablename= $table["Tables_in_" . str_replace("`", "", $strDatabase)];
		//$sourcepk="ID";
		$sourcepk=PKLookup($strDatabase, $sourcetablename, true);
		if($sourcepk!=""  || $mode=="mapscriptout")
		{
			if($mode!="mapscriptout")
			{
				$strSQL="SELECT MAX(" . $sourcepk . ") as thismax FROM " .   $sourcetablename;
				//echo $strSQL. "<BR>";
				$records=$sql->query($strSQL);
				$record=$records[0];
				$sourcemax=$record["thismax"];
				//echo $sourcetablename . " " . $sourcemax . "<BR>";
				//TO MYSQL

		
				$desttablename= $sourcetablename;
				 
				 
				$db_type="";
				$strDatabase=our_db;
				$destpk=PKLookup($strDatabase, $desttablename, true);
				$strSQL="SELECT MAX(" . $destpk . ") as thismax FROM " . $strDatabase . "." .  $desttablename;
				//echo $strSQL  ."<P>";
				$records=$sql->query($strSQL);
				//echo "Did that";
				$record=$records[0];
				$destmax=gracefuldecaynumeric($record["thismax"],0);
				 
			}
			else
			{
				$desttablename= $sourcetablename;
			}
	 
			//echo  $sourcetablename . " " . $sourcemax . " " . $destmax . "<BR>";
			if($sourcemax>$destmax && $destpk!=""  )
			{
				//TO ODBC
				$db_type="odbc";
				$strDatabase="dbo";
				$strSQL="";
			 
				if($sourcepk=="")
				{
					$strSQL="SELECT   * FROM " .   $sourcetablename  ;
				}
			 
				else
				{
					$strSQL="SELECT TOP " . $maxinago. " * FROM " .   $sourcetablename . " WHERE " .  $sourcepk . ">" . $destmax . " ORDER BY " . $sourcepk . " ASC";
				}
				//echo $strSQL;
				if($strSQL!="")
				{
					$records=$sql->query($strSQL);
					foreach($records as $record)
					{
					
						$strSQL=AssociativeArrayToInsertStatement($record, $desttablename);
						if( mysql_error()!="")
						{
							die($strSQL);
						}
						//echo "<font color=red>" . mysql_error() . "</font>" . "<P>";
				
						//echo $strSQL . "<BR>";
						$strSQLOut.=$strSQL . "\n";
						if($mode!="sqlonly")
						{
							//TO MYSQL
							//echo $strSQL . "<BR>";
							$db_type="";
							$strDatabase=our_db;
							$sql->query($strSQL);
							//echo sql_error() . "<BR>";
						}
						$rowcount++;
						if($maxinago<$rowcount)
						{
							if($mode=="sqlonly")
							{
								return $strSQLOut;
							}
							else
							{
								return $out;
							}
						}
						if(!inList($tablesout, $sourcetablename ))
						{
							$tablesout.= $sourcetablename . " ";
						}
						//do stuff with $strConfig
						$rowdelimiter="-";
						$fielddelimiter="|";
						$intTop=count(explode($rowdelimiter, $strConfig));
						
						for ($t=0; $t<$intTop; $t++)
						{
						
						
							$arrData=genericdata($t,-1,0,$strConfig,$rowdelimiter,$fielddelimiter, true);
							
							if($arrData[0]==$desttablename)
							{
								$ftable=$arrData[2];
								$fk=$arrData[3];
								$morepk=$arrData[1];
								$strMoreSQL="SELECT * FROM " . $ftable . " WHERE " . $fk ."='" . $record[$morepk] . "'";
								//echo $strMoreSQL ."<BR>=<BR><BR>";
								//TO ODBC
								$db_type="odbc";
								$strDatabase="dbo";
								$morerecords=$sql->query($strMoreSQL);
								foreach($morerecords as $thismorerecord)
								{
									$strMoreResultSQL=AssociativeArrayToInsertStatement($thismorerecord, $ftable);
									$strSQLOut . $strMoreResultSQL . "\n";
									//$rowcount++;
									if($mode!="sqlonly")
									{
										//TO MYSQL
										$db_type="";
										$strDatabase=our_db;
										$sql->query($strMoreResultSQL);
									}
								}
						
						 	}
						
						}
					
					}	
					
				}
				
			}
		}
 
		if ($mode=="" )
		{
			//$error= sql_error();
			$out.= $error . IFAThenB($error,"<br/>\n");
		}
	}
	if($bwlMaxidsource || $mode=="mapscriptout")
	{
		return $strSQLOut;
	}
	return $out;
}

function FixBrokenMetadata($maxinago=300, &$tablesout, &$fixcount, $mode="")//$mode could also be "sqlonly"
{
	GLOBAL $db_type;
	GLOBAL $connStr;
	$fixcount=0;
	$strConfig="article|ID|ARTICLE_CATEGORY|ARTICLE_ID-article|ID|ARTICLE_PICTURE|ARTICLE_ID-USERS|ID|BOOKMARK|USER_ID-USERS|ID|HIT|USER_ID-USERS|ID|USER_CATEGORY|USER_ID";
	$sql=conDB();
	//to ODBC
	$db_type="odbc";
	$strDatabase="dbo";
	//die($connStr);
	$tables=TableList($strDatabase);
	$tablesout="";
	$rowcount=0;
	$out="";
	$strSQLOut="";
	foreach($tables as $table)
	{
		//TO ODBC
		$db_type="odbc";
		$strDatabase="dbo";
		$sourcetablename= $table["Tables_in_" . str_replace("`", "", $strDatabase)];
		//$sourcepk="ID";
		//echo $sourcetablename . "<BR>";
		$sourcepk=PKLookup($strDatabase, $sourcetablename, true);
		$desttablename=$sourcetablename;
		$rowdelimiter="-";
		$fielddelimiter="|";
		$arrData=genericdata($t,-1,0,$strConfig,$rowdelimiter,$fielddelimiter, true);			
		if($arrData[0]==$desttablename)
		{
			$ftable=$arrData[2];
			$fk=$arrData[3];
			$morepk=$arrData[1];
			//TO MYSQL
			$db_type="";
			$strDatabase=our_db;
			$strMoreSQL="SELECT " . $morepk . " FROM " . $desttablename . " a LEFT JOIN " . $ftable . " b ON a." . $morepk . "=b." . $fk ." WHERE b." . $fk . " IS NULL LIMIT 0, 10"; //only do ten at a time
			$morerecords=$sql->query($strMoreSQL);
			//$strMoreSQL="SELECT * FROM " . $ftable . " WHERE " . $fk ."='" . $record[$morepk] . "'";
			//echo $strMoreSQL ."<BR>=<BR><BR>";
			foreach($morerecords as $thismorerecord)
			{
				//TO ODBC
				$db_type="odbc";
				$strDatabase="dbo";
				$thisorphanPK=$thismorerecord[$morepk];
				$strOrphanSQL="SELECT * FROM " . $ftable . " WHERE " . $fk . "='" . $thisorphanPK . "' ORDER BY " . $fk  ." DESC";
				//echo "<font color=blue>" . $strOrphanSQL ."</font><BR>=<BR><BR>";
				$orphanrecords=$sql->query($strOrphanSQL);
				foreach($orphanrecords as $orphanrecord)
				{
					$fixSQL=AssociativeArrayToInsertStatement($orphanrecord, $ftable);
					//echo $fixSQL . "<BR>";
					$strSQLOut . $strMoreResultSQL . "\n";
					$rowcount++;
					if($mode!="sqlonly")
					{
						//TO MYSQL
						$db_type="";
						$strDatabase=our_db;
						$sql->query($fixSQL);
					}
				}
			}
	
	 	}
		
	}
	return $strMoreResultSQL;
}


function ForkInsert($strDatabase, $strTable, $arrDescribedValuePairs, $arrAlteredValuePairs,  $insertID, $bwlEscape=true, $bwlDebug=false)
//this inserts data into the MS SQL database to keep it synch'd with the MySQL DB
{
 
	GLOBAL $db_type;
	$sql=conDB();
	//first though, let's make sure that page we are on is NOT called form.php -- a page that we are on if data was inserted from the MSSQL end
	//because in that case, synching is going the other way
	if(!contains($_SERVER["PHP_SELF"], "form.php"))
	{
		//basically, we can set the whole thing up and send it back through UpdateOrInsert with nofork turned on
	
		
		//just for fun, let's make it so we can also create tables ODBC tables on the fly as needed
	 
		$strSQL=TableExplanationToTableCreationSQL($strDatabase, $strTable,  true,  true, "odbc");
	 
		$db_type="odbc";
		$strDatabase="dbo";
		//die("-" . TableExists($strDatabase, "USERSw"));
		if(!TableExists($strDatabase, $strTable))
		{
			//create the table on the ODBC side
			$sql->query($strSQL);
		}
		if($strTable=="article")
		{
			$strTable=="ARTICLE";
		}
 		if($insertID!="")
		{
			//but first figure out what to do with  $insertID
 
			$pk=PKLookup($strDatabase, $strTable, true);
			//echo "-" . $pk ."-<BR>";
			$arrDescribedValuePairs[$pk]=$insertID;
		}
		UpdateOrInsert($strDatabase, $strTable, $arrDescribedValuePairs, $arrAlteredValuePairs,  true,  false, true);
		
 
	 
	
 
		//BACK TO MYSQL FOR WHEN WE LEAVE THE FUNCTION
		$db_type="";
		$strDatabase=our_db;
	
	}

}


function SendMailingToUser($user_id, $mailing_id=0,  $subject="Featurewell's Top Stories", $bodyextra="")
{
 
	GLOBAL $db_type;
	$intMailedResponse=2;
	$db_type= 'odbc';
	$strDatabase="dbo";
	$record=GenericDBLookup($strDatabase, "USERS", "ID", $user_id, "");
	$username=$record["USERNAME"];
	$lastemail=$record["LAST_EMAIL"];
	$password=$record["PASSWORD"];
	$email=$record["EMAIL"] ;
	//for testing:
	//$email="gus@asecular.com";
	//$email="featurewell@featurewell.com";
	//$subject="Featurewell's Top Stories - " . date("F jS");
	$body= BuildMailerBody($user_id, $lastemail, $mailing_id, $username, $password,  $mailing_id, $bodyextra);
	$db_type="";
	$emailstr=$record["FIRST_NAME"] . " " . $record["LAST_NAME"] . " <" . $email . ">";
	$from="Featurewell Sales<sales@featurewell.com>";
	$headers = "From: " . $from . "\r\nReply-To: " . $from;
	//echo "----\n\n" . $emailstr . " " . $subject."\n\n" .  $body;
	if($body!="")//dont bother to send emails that have no essential body
	{
		$intMailedResponse=mail($emailstr, $subject,  $body, $headers);
		if($intMailedResponse)
		{	
			$intMailedResponse=1;
		}
		//mail("gus@asecular.com", $subject,  $body, $headers);
	}
	else
	{
		$intMailedResponse=-1;
	}
	return $intMailedResponse;
	//mail($email, $subject,  "working it");
}

function BuildMailerBody($user_id, $lastemail, $mailing_id=0, $username, $password,  $mailing_id, $bodyextra="")
{
	GLOBAL $db_type;
	$db_type= 'odbc';
	$strDatabase="dbo";
	$body="";
	$nowSQLtime=date("Y-m-d H:i:s");
	$intStoryLimit=30;
	if( $lastemail=="")
	{
		$lastemail=date("Y-m-d H:i:s", mktime(0, 0, 0, date("m")  , date("d")-7, date("Y")));
	}
	$strSQL="
	  select A.ID, LTRIM(RTRIM(A.TITLE)) AS TITLE, A.SUBJECT, A.WORD_COUNT, A.NOTES, A.LOADED_DATE, A.USA_CANADA,
                 C.NAME AS CAT_NAME, W.FIRST_NAME + ' ' + W.LAST_NAME AS AUTH
            from ARTICLE A, USER_CATEGORY, CATEGORY C, USERS W
            where USER_CATEGORY.USER_ID = " . $user_id . "
              and C.ID = A.CATEGORY_ID
              and W.ID = A.AUTHOR_ID
              and A.CATEGORY_ID = USER_CATEGORY.CATEGORY_ID
              and A.ACTIVE = 1
              and (A.LOADED_DATE > '" . $lastemail . "' or A.LATEST > 0)
            order by C.ORDERBY, A.LATEST DESC, A.LOADED_DATE DESC
	";
	$sql=conDB();
	//echo $strSQL;
	$records=$sql->query($strSQL, true, $strDatabase);
	//echo odbc_error();
	//echo mysql_error();
	$count=0;
	foreach($records as $record)
	{
		if($count<$intStoryLimit)
		{
			$ID=$record["ID"];
			$COUNTRY_CODE=$record["COUNTRY_CODE"];
			$CAT_NAME=$record["CAT_NAME"];
			$TITLE=$record["TITLE"];
			$AUTH=$record["AUTH"];
			$WORD_COUNT=$record["WORD_COUNT"];
			$SUBJECT=$record["SUBJECT"];
			$NOTES=$record["NOTES"];
			//echo $ID. "<BR>";
			$url="http://www.featurewell.com/i.php?" . $ID . "." . $user_id . "." .  $mailing_id;
			if ($USA_CANADA ==0 ||  $COUNTRY_CODE == 1 ||  $COUNTRY_CODE==107)
			{
				$body.= "\r\n" . $CAT_NAME .": " .  strtoupper($TITLE) . " by " . strtoupper($AUTH). " ".  $WORD_COUNT . " words.\r\n";
		        $body.= $SUBJECT. "\r\n";
		        if($NOTES!="")
				{
					   $body.= $NOTES . "\r\n";
				}
		        $body.= "Full story at " . $url . "\r\n";
		    }
		}
		$count++;
	}
	$db_type="";
	
	$pwdreminderstring="For a password reminder, click here http://www.featurewell.com/?Doc=Forgot.cfm&clue=" . $username . "";
	$out=$bodyextra . "\r\n\r\n";//"To contact Featurewell's New York sales office, please call +1 (212) 924 2283 or email sales@featurewell.com\r\n\r\n";
	
	$out.="Your Featurewell.com username is '" . strtoupper($username) . "'. " . $pwdreminderstring . ".\r\n\r\n" . $body . "\r\nIf you do not wish to receive further emails from us, please reply to this email with 'remove' in the subject.\r\nhttp://www.featurewell.com\r\n\r\nReproduction of material from any of Featurewell.com's pages, without written permission is prohibited. (c) 2000-" . date("Y") . " Featurewell.com all rights reserved.";
	if($count<1)
	{
		$out="";//don't make a body for zero counts
	}
	return $out;  
	//
}

function date_differ($start, $end="NOW", $unitsdif="day") 
{
        $sdate = strtotime($start);
        $edate = strtotime($end);

        $timeshift = $edate - $sdate;
       
		$out=$timeshift;
		if(beginswith($unitsdif,"day"))
		{
			$out=$timeshift/86400;
		}
		if(beginswith($unitsdif,"hour"))
		{
			$out=$timeshift/3600;
		}
        return $out;
}

?>