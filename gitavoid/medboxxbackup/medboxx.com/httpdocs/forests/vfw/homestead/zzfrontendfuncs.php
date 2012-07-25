<?

function GetAndClean($strFilename="small.htm", $knownyear=1975)
{

	$url=$strFilename;
	$handle=fopen ($url, "r");
	$content=fread($handle, filesize($url));
	fclose($handle);  
	$content= CleanMicrosoftShit($content);
	//echo "<pre>" . $content . "</pre>";
	$content=str_replace("</p>", "|", $content);
	$arrContent= explode("|", $content );
	//;
	$knownmonth=0;
	foreach($arrContent as $item)
	{
		//echo $item . "<p>";
		$cutpoint=0;
		$potentialopeningdate= ParseOutOpeningDate($item, $cutpoint);
		$oldknownmonth=$knownmonth;
		if($timestamp!="")
		{
			$oldtimestamp=$timestamp;
		}
		$timestamp=GuessActualStartingDate($potentialopeningdate, $knownyear, $knownmonth, $enddate, $oldknownmonth);
		$possibleyear=date("Y", $timestamp);
		//if($possibleyear>1970)
		{
			//echo date("Y-m-d H:i:s", $timestamp) .    "<br>";
			if($enddate!="")
			{
				//echo "<font color=red>" . date("Y-m-d H:i:s", $enddate) . "</font><br>";
			}
			//echo $cutpoint . "|" . $item . "<p>";
			$entrycontent=trim(substr($item, $cutpoint));
			
			$strDatabase=our_db;
			$strTable="calendar_event";
			$arrDescribedValuePairs="";
			//echo $timestamp . "-" . $oldtimestamp . "<br>";
			if($timestamp=="")
			{
				$timestamp=$oldtimestamp;
			}
			if($enddate=="")
			{
				$enddate= $timestamp;
			}
			if($timestamp!=""  && strlen($entrycontent)>2)
			{
				$arrAlteredValuePairs=Array("start"=>date("Y-m-d H:i:s", $timestamp),"end"=>date("Y-m-d H:i:s", $enddate), "notes"=>$entrycontent, "calendar_id"=>1);
				//echo $entrycontent  . "<br>" .  date("Y-m-d H:i:s", $timestamp) . "|" . $timestamp . "|" . $oldtimestamp . "<p>";
				echo UpdateOrInsert($strDatabase, $strTable, $arrDescribedValuePairs, $arrAlteredValuePairs, $bwlEscape=true, $bwlDebug=false);
				//echo "<br>" . mysql_error();
			}
			//if($knownmonth<$oldknownmonth  && $knownmonth==1)
			//{
				//$knownyear++; //i do this in the date guesser function now
			//}
		}
		//echo "<b>" . ParseOutOpeningDate($item) . "</b><p>\n";
		//echo  ($item) . "<hr><p>\n";
		
	}
	
	
}






function CleanMicrosoftShit($strIn, $bwlClearBold=true)
{
//does anyone appreciate the abomination known as Microsoft HTML export?
	$bwlFresh=true;
	$strFound="";
 
	$strTags="p b font div span";
	$strTags=$strTags . " " . strtoupper($strTags);
	$tags=explode(" ", $strTags);
	foreach($tags as $tag)
	{
		//echo "<b>" . $tag . "</b><br>";
		$bwlFresh=true;
		$intStartingAt=0;
		while($strFound!=""  || $bwlFresh) //removes all parameters from tags 
		{
			$bwlFresh=false;
			$strStart="<" . $tag . " ";
			$strEnd=">";
			//echo $strStart . "~~~~~~~~~<br>";
			$strFound=parseBetween($strIn, $strStart, $strEnd, $intStartingAt);
			if($strFound!="")
			{
				$intStartingAt=strpos($strIn, $strFound,$intStartingAt+1);
				//echo $tag . " " . $strFound . "=<br>";
				//$pos1 = strpos($strIn, $strFound);
				//$out.=  substr($strIn,0,$pos1 );
				//$strIn=substr($strIn,$pos1);
				$strIn=str_replaceone($strFound, "", $strIn);
			}
			//echo $tag . " " . $strFound . "=<br>";
		}
	 
		
	}
	if($bwlClearBold)
	{
		$strIn=TrashTag($strIn, "b");
	}
	$strIn=TrashTag($strIn, "o:p");  
 	$strIn=TrashTag($strIn, "span");  
	$strIn=TrashTag($strIn, "div"); 
  	//$strIn=TrashTag($strIn, "h2");
	//$strIn=TrashTag($strIn, "h3");
	//$strIn=TrashTag($strIn, "h4");
	$strIn=ReplaceTag($strIn, "h5", "p");
	$strIn=ReplaceTag($strIn, "h4", "p");
	$strIn=ReplaceTag($strIn, "h3", "p");
	$strIn=ReplaceTag($strIn, "h2", "p");
	$strIn=ReplaceTag($strIn, "h1", "p");
	$strIn=str_ireplace(" ", " ", $strIn);
	$strIn=str_ireplace(",", ", ", $strIn);
	$strIn=str_ireplace(".", ". ", $strIn);
	$strIn= charspacingimprove("(", " ",   $strIn);
	$strIn= charspacingimprove("[", " ",   $strIn);
	$strIn= charspacingimprove("{", " ",   $strIn);
	$strIn= charspacingimprove(" ", ")",   $strIn);
	$strIn= charspacingimprove(" ", "]",   $strIn);
	$strIn= charspacingimprove(" ", "}",   $strIn);
	$strIn= charspacingimprove(" ", ".",   $strIn);
	$strIn= charspacingimprove(" ", ",",   $strIn);
	$strIn=str_ireplace(chr(10), " ", $strIn);
	$strIn=str_ireplace(chr(13), " ", $strIn);
	$strIn=str_ireplace("<p", chr(13) . "<p", $strIn);
	$strIn=deMultiple( $strIn, " ");
 
	$strIn=substr($strIn,strpos( $strIn, "<body "));
	
	return $strIn;
}	
	
function TrashTag($strIn, $tagname)
{
//get rid of retarded html tags if simple
	$strIn=str_ireplace("<" . $tagname .">", "", $strIn);
	$strIn=str_ireplace("<" . $tagname ." >", "", $strIn);
	$strIn=str_ireplace("<" . $tagname , "<x", $strIn);
	$strIn=str_ireplace("</" . $tagname .">", "", $strIn);
	return $strIn;
}	

function ReplaceTag($strIn, $taglookfor, $tagreplace)
{
//get rid of retarded html tags if simple
	$strIn=str_ireplace("<" . $taglookfor .">", "<" . $tagreplace .">", $strIn);
	$strIn=str_ireplace("<" . $taglookfor ." >", "<" . $tagreplace .">", $strIn);
	$strIn=str_ireplace("</" . $taglookfor .">", "</" . $tagreplace .">", $strIn);
	return $strIn;
}	
	
function charspacingimprove($charprecedewrong, $charfollowwrong,   $strIn)
{
	$countfound=1;
	while($countfound>0)
	{
	 
		$strIn=str_replace($charprecedewrong . $charfollowwrong, $charfollowwrong . $charprecedewrong, $strIn, $countfound);
		 
	 
	}
	return $strIn;
}

function str_replaceone($search,  $replace, $subject, $intStartingAt=0)
{
	$pos1 = strpos($subject, $search, $intStartingAt);// + strlen($search);
	return substr($subject, 0, $pos1) . $replace . substr($subject, $pos1+strlen($search));

}

function ParseOutOpeningDate($strIn, &$cutpoint)
{
	$originallen=strlen($strIn);
	$strIn=strip_tags($strIn);
	$len=strlen($strIn);
	$deltalen=$originallen-$len ;
	if($deltalen>4)
	{
		$deltalen=4;//hacktacular
	}
	//echo $deltalen . "<br>" .$strIn . "<p>";
	$bwlBegin=true;
	$bwlNumberPart=false;
	$potential="";
	$cutpoint="";
	$bwlFail=false;
	$datecharactercounter=0;
	for($i=0; $i<$len; $i++)
	{
		$char=substr($strIn, $i, 1);
		if($datecharactercounter<3  && $char=="(")
		{
			$bwlFail=true;
			$deltalen++;
		}
		else if($bwlBegin  &&  $datecharactercounter>10)
		{
			$bwlFail=true;
		}
		else if((strtoupper($char)<="Z"  && strtoupper($char)>="A"  )  && $bwlBegin )
		{
			$potential.=$char;
		}
		else if($char==" " && $bwlBegin)
		{
			$potential.=$char;
		}
		else if( strtoupper($char)=="." )
		{
			//$deltalen++;
		}
		else if((strtoupper($char)<="9"  && strtoupper($char)>="0" )  && ($bwlBegin ||  $bwlNumberPart))
		{
			$potential.=$char;
			$bwlNumberPart=true;
			$bwlBegin=false;
		}
		else if( strtoupper($char)== "-"  && ($bwlBegin ||  $bwlNumberPart) )
		{
			$potential.=$char;
			$bwlNumberPart=true;
			$bwlBegin=true;
			$datecharactercounter=0; //could be another date;  want to be ready for it
		}
		else
		{
			
			if( $bwlNumberPart==true)
			{
				$cutpoint=$i + $deltalen   ;
			}
			$bwlNumberPart=false;
			//exit;
		}
		$datecharactercounter++;
	}
	if($bwlFail)
	{
		$potential="";
		$cutpoint=0;
	}
	$potential=deMultiple(trim($potential), " ");
	
	return $potential;
}


function GuessActualStartingDate($strIn, &$knownyear, &$knownmonth, &$enddate, $oldknownmonth)
{
	$bwlReturnEndDate=false;
	$enddate="";
	if(!contains(strtolower($strIn), "year"))//weird parser thing in php's strtotime can calculate a date from the mere mention of phrases like "last year"
	{
		if(!is_numeric($strIn))
		{
			if(contains($strIn, "-"))
			{
				$arrActual=explode("-", $strIn);
				$possibledatestring=$arrActual[0] . " " .  $knownyear;
				$bwlReturnEndDate=true;
			}
			else
			{
				$possibledatestring=$strIn . " " .  $knownyear;
			}
		
		
		}
		else
		{
			$possibledatestring=$strIn .  " " .$knownmonth . " " .  $knownyear;
		
		}
	}
	if( strlen(trim($possibledatestring))>4)
	{
		$timestamp=strtotime($possibledatestring);
	}
	$knownmonth=date("m", $timestamp);
	//1977-06-01
	if($knownyear==1977  && ($knownmonth ==6  || $knownmonth ==6 ))
	{
		//echo $possibledatestring . " " . "----" . date("Y-m-d H:i:s", strtotime($possibledatestring)) . "---" . $oldknownmonth . " " . $knownmonth . "<br>";
	}
	if($oldknownmonth>$knownmonth  && $knownmonth==1  && $timestamp!="")
	{
		//if($knownyear==1977)
		{
			//echo $possibledatestring . " " . "----" . date("Y-m-d H:i:s", strtotime($possibledatestring)) . "---" . $oldknownmonth . " " . $knownmonth . "<br>";
		}
		$knownyear++;
		$possibledatestring=$strIn .  " " .$knownmonth . " " .  $knownyear;
		
		$timestamp=strtotime($possibledatestring);
	}
	if($bwlReturnEndDate)
	{
		$possibleenddate=trim($arrActual[1]);
		if(is_numeric($possibleenddate))
		{
			$enddate=strtotime($arrActual[1] . "-" . $knownmonth . "-"  . $knownyear);
		}
		else
		{
			$enddate=strtotime($arrActual[1] . " "   . $knownyear);
		}
		//echo  $arrActual[1] . " " . $knownmonth . " "  . $knownyear . "!" . $enddate . "<br>";
	}
	//echo $possibledatestring  ." ------ " .$timestamp .  " ------- " . date("Y-m-d H:i:s", $timestamp) . "----------" . $enddate .  "<br>";
 
	return  $timestamp;


}


function monthcalendar($dtmNow, $day_name_length = 3, $month_href = NULL, $first_day = 0, $intCalendarSetID)
{
 	$style="littlenav";
	$cellbgcolor="999999";

	$datearray=getdate($dtmNow);
	$month=$datearray["mon"];
	$year=$datearray["year"];
	$hour=$datearray["hours"];
	$minute=$datearray["minutes"];
	$second=$datearray["seconds"];
	$todaydatecode=$datecode;
	//echo $month . " " . $year;
	$first_of_month = gmmktime(0,0,0,$month,1,$year);
	$day_names = array(); #generate all the day names according to the current locale
	for($n=0,$t=(3+$first_day)*86400; $n<7; $n++,$t+=86400) #January 4, 1970 was a Sunday
	{
		$day_names[$n] = ucfirst(gmstrftime('%A',$t)); #%A means full textual day name
	}
	list($month, $year, $month_name, $weekday) = explode(',',gmstrftime('%m,%Y,%B,%w',$first_of_month));
	
	$weekday = ($weekday + 7 - $first_day) % 7; #adjust for $first_day
	//echo $weekday;
	//$weekday=abs($weekday);
	
	$title   = htmlentities(ucfirst($month_name)).'&nbsp;'.$year;  #note that some locales don't capitalize month and day names
	$out = '<table class="calendar" cellpadding="1" cellspacing="1" border="0" >';
	$out .= '<caption class="calendar-month">' . ($month_href ? '<a href="'.htmlspecialchars($month_href).'">'.$title.'</a>' : $title). "</caption>\n";
	$out .= "<tr>";
	$row=0;
	if($day_name_length){ #if the day names should be shown ($day_name_length > 0)
		#if day_name_length is >3, the full name of the day will be printed
		foreach($day_names as $d)
		{
			$out .= '<td class="calendar-weekname" abbr="'.htmlentities($d).'">'.htmlentities($day_name_length < 4 ? substr($d,0,$day_name_length) : $d).'</td>';
		}
		$out .= "</tr>\n<tr>";
	}
	//echo $weekday . "<br>";

	if ($weekday > 0) 
	{
		$out .= '<td colspan="'.$weekday.'">&nbsp;</td>'; #initial 'empty' days
	}
	for($day=1,$days_in_month=gmdate('t',$first_of_month); $day<=$days_in_month; $day++,$weekday++)
	{
		if($weekday == 7)
		{
			$weekday   = 0; #start a new week
			$out .= "</tr>\n<tr>";
			$row++;
		}
		$dtmThis=mktime($hour,$minute,$second,$month, $day,$year); 
		$url="";////////////////
		//echo (file_exists($url) and strpos($url, "#")<1 . "<br>");
		//echo $dtmThis . " " . $dtmNow . "<br>" ;
		$link=qbuild($strPHP, $strDatabase, "calendar_set", "view", qpre . "startdate" , $dtmThis) . "&calendar_set_id=" . $intCalendarSetID;  
		$content  = $day;
		$result="";

 		//echo $dtmThis . "<br>";
		$result=GenericDBLookup(our_db, "calendar_event", "start", date("Y-m-d H:i:s", $dtmThis), "calendar_event_id");
		$thiscellbgcolor=$cellbgcolor;
		if($result!="")
		{
			$thiscellbgcolor=colorAdd($cellbgcolor, "333333");
			
		}
		else
		{
			$link="";
		}
		if($dtmThis==$dtmNow)
		{
 			$thiscellbgcolor=colorAdd($thiscellbgcolor, "333300");
			$link="";
		}
		$out .= '<td bgcolor="' . $thiscellbgcolor. '"'.($style ? ' class="'.htmlspecialchars($style).'">' : '>');
				
			
		$out .= ($link ? '<a href="'. $link .'">'.$content.'</a>' : $content).'</td>';
	 		
	}
	if ($weekday != 7) $out .= '<td colspan="'.(7-$weekday).'">&nbsp;</td>'; #remaining "empty" days
	$out.="</tr>\n";
	//echo $row;
	if ($row<5)
	{
		$out.="<tr><td colspan=\"7\">&nbsp;</td></tr>\n"; #keep all calendars the same height to help with rapid nav
	}
	$out.="</table>\n";
	$out.="<br>";

	//$out.=asecularmonthnav($datecode);
	//$out.= asecularyearnav($datecode);
	return $out;
}

function findprevornextdatewithcontent($strDatabase, $strTable, $strDateField, $dtmNow, $intUnits, $strPHPcodeunit,  $direction="+")
{
	$strConfig="H-0|i-0|s-0|m-1|d-1|Y-2000";
	$arrConfig=explode("|", $strConfig);
	$attempt=0;
	$intUnitsToUse=$intUnits;
	while($this_id==""  && $attempt<120  && $strPHPcodeunit=="d"  ||  $strPHPcodeunit!="d" && $attempt<1)
	{
		
		$strCode="mktime(";
		for ($i=0; $i<count($arrConfig); $i++)
		{
			$arrThis=explode("-", $arrConfig[$i]);
			
			if ($strPHPcodeunit== $arrThis[0])
			{
				$strCode.="date(\"" . $arrThis[0] . "\", " . $dtmNow . ") " . $direction ." " . $intUnitsToUse;
				//$strEarlierCode.="date(\"" . $arrThis[0] . "\", " . $dtmNow . ") - " . $intUnits;
				
				//$strLaterCode.=date("'" . $arrThis[0] . "'",$dtmNow )+ $intUnits  ;
				//$strEarlierCode.=date("'" . $arrThis[0] . "'",$dtmNow )- $intUnits  ;
			}
			else
			{
				$strCode.="date(\"" . $arrThis[0] . "\", " . $dtmNow . ")";
				//$strEarlierCode.="date(\"" . $arrThis[0] . "\", " . $dtmNow . ")";
			}
			if($i<count($arrConfig)-1)
			{
				$strCode.=",";
				//$strEarlierCode.=",";
			}
			else
			{
				$strCode.=");";
				//$strEarlierCode.=");";
			}
		}
		
		$out=eval("return " . $strCode);
		
		$this_id=GenericDBLookup($strDatabase, $strTable, $strDateField,  date("Y-m-d H:i:s",$out), "calendar_event_id", false);
		//if($this_id!="")
		{
			//echo  $strCode . " possibledate:" . date("Y-m-d H:i:s",$out) . " thisid:" . $this_id . " attempt:" . $attempt .  " " . "<p>";
		}
		$intUnitsToUse+=$intUnits;
		$attempt++;
	}
	return $out;
}
function prevnextdate($dtmNow, $strDB, $strPHP, $strPHPcodeunit, $intUnits, $intCalendarSetID, $strLabel="", $divider=" | ")
{

	$strEarlierSymbol="&lt; earlier " . $strLabel;
	$strLaterSymbol="later " . $strLabel . " &gt;";
	$strConfig="H-0|i-0|s-0|m-1|d-1|Y-2000";
	$arrConfig=explode("|", $strConfig);

 
	$strTable="calendar_event";
 
	$strDateField="start";
	$intLaterDateCode= findprevornextdatewithcontent($strDB,  $strTable, $strDateField, $dtmNow, $intUnits,  $strPHPcodeunit, "+");
	$intEarlierDateCode= findprevornextdatewithcontent($strDB, $strTable, $strDateField, $dtmNow, $intUnits,  $strPHPcodeunit, "-");
	//echo $out. "<br>";
	$urlbasis=qbuild($strPHP, $strDB, "calendar_set", "", "calendar_set_id", $intCalendarSetID);
	//echo date("Y-m-d H:i:s",$intEarlierDateCode) . " === " . date("Y-m-d H:i:s",$intLaterDateCode);
	$earlierhref="<a class=\"datenav\" href=\"" . $urlbasis . "&" . qpre . "startdate=" . $intEarlierDateCode . "\">" . $strEarlierSymbol . "</a>";
	$laterhref="<a class=\"datenav\"  href=\"" . $urlbasis . "&" . qpre . "startdate=" . $intLaterDateCode  . "\">". $strLaterSymbol . "</a>";
	$out=$earlierhref . $divider . $laterhref;
	return($out);

}
	
	

function datenavcomplex($dtmIn,$strDatabase, $strPHP,$calendar_set_id)
{
	$out="";
	$divider= "</td><td>&nbsp;</td><td>";
	$out.= "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\"   >\n";
	$out.= "<tr>\n"; 
	$out.= "<td rowspan=\"1\" colspan=\"3\">\n";
	$out.=monthcalendar($dtmIn, 3 ,"" ,   0,$calendar_set_id);
	$out.= "</td>\n";
	$out.= "<td rowspan=\"1\"  colspan=\"3\">\n"; 
	$out.= "&nbsp;\n";
	$out.= "</td>\n";
	$out.="<td colspan=\"3\">";
	$out.="&nbsp;";
	$out.= "</td>\n";
	$out.= "</tr>\n";
	$out.= "<tr>\n";
	$out.= "<td>\n";
	$out.=prevnextdate($dtmIn,$strDatabase, $strPHP, "d", 1,$calendar_set_id, "day", $divider);
	$out.="</td>";
	$out.= "</tr>\n"; 
	$out.= "<tr>\n"; 
	$out.="<td>";
	$out.=prevnextdate($dtmIn,$strDatabase, $strPHP, "d", 7,$calendar_set_id, "week", $divider);
	$out.="</td>";
	$out.= "</tr>\n"; 
	$out.= "<tr>\n"; 
	$out.="<td>";
	$out.=prevnextdate($dtmIn,$strDatabase, $strPHP, "m", 1,$calendar_set_id, "month" , $divider);
	$out.="</td>";
	$out.= "</tr>\n"; 
	$out.= "<tr>\n"; 
	$out.="<td>";
	$out.=prevnextdate($dtmIn,$strDatabase, $strPHP, "Y", 1,$calendar_set_id, "year" , $divider);
	$out.= "</td>\n";
	$out.= "</tr>\n";
	$out.= "<tr>\n"; 
	$out.="<td colspan=\"3\">";
	$out.="&nbsp;";
	$out.= "</td>\n";
	$out.= "</tr>\n";
	$out.= "</table>\n";
	return $out;
}
	
	
	
	
function CalendarBrowser($dtmStart, $strDatabase, $strPHP,$intCalendarSet)
{
	$sql=conDB();
	$intDateWidthPercentage=8;
	$arrCalendarIDs=Array();
	//first get info about the range of this calendar
	$strSQL="SELECT calendar_id, name, range_in_seconds FROM " . $strDatabase . ".calendar_set s JOIN " . $strDatabase . ".calendar_set_map m ON s.calendar_set_id=m.calendar_set_id WHERE s.calendar_set_id=" . $intCalendarSet . " ORDER BY map_order ASC";
	//echo $strSQL;
	$records = $sql->query($strSQL);
	foreach($records as $record)
	{	
		$strSetName=$record["name"];
		$intSetRange=$record["range_in_seconds"];
		//echo $intSetRange;
		$arrCalendarIDs[count($arrCalendarIDs)]=$record["calendar_id"];
	
	}

	$strSQL="SELECT * FROM " . $strDatabase . ".calendar_range r JOIN " . $strDatabase . ".calendar c ON r.calendar_range_id=c.calendar_range_id WHERE c.calendar_id=" . $arrCalendarIDs[0];
	//echo $strSQL;
	$records = $sql->query($strSQL);
	//$record = $records[0];
	foreach($records as $record)
	{
		$intThisCalendarID=$record["calendar_id"];
		
		$size[$intThisCalendarID]=gracefuldecay($record["size_in_seconds"], 604800);
		$granules[$intThisCalendarID]=gracefuldecay($record["granules"], 168);
 
		$size_php_code[$intThisCalendarID]=gracefuldecay($record["size_php_code"], "l");
		$granules_php_code[$intThisCalendarID]=gracefuldecay($record["granules_php_code"], "H");
		
		if ($granules[$intThisCalendarID]>0)
			{
				$intIncrement[$intThisCalendarID]=intval($size[$intThisCalendarID]/$granules[$intThisCalendarID]);
			}
	}
	//echo "!" . $granules;

	$strColors="0a1925|060025|122712|120223|201020";
	$thiscolor=explode("|",$strColors);
	$strBgClassFirst="bgclassfirst";
	$strBgClassSecond="bgclasssecond";
	$strBgClassOther="bgclassother";
	$strLineClass="bgclassline";
	$strColorOne="babb9c";
	$strColorTwo="b0b990";
	$strDayBarColor="ffffff";
	$strThisColor=$strColorTwo;
	$out="";
	$out.= "<table border=\"0\" cellspacing=\"1\" cellpadding=\"2\" class=\"" .$strLineClass  . "\" width=\"100%\">\n";
	$out.= "<tr class=\"" . $strBgClassOther. "\"><td>\n";
	//$out.=adminbreadcrumb(false,  $strDatabase,  qbuild("tableform.php", $strDatabase, "", "", "", "" ),   "calendar sets", qbuild($strPHP, $strDatabase, "calendar_set", "view", "", ""),  $strSetName, "");
	$out.= datenavcomplex($dtmStart,$strDatabase, $strPHP,$intCalendarSet);
	$out.= "</td>\n";
	$out.= "</tr>\n";
	$out.= "</table>\n";
	$out.= "<table border=\"0\" cellspacing=\"1\" cellpadding=\"2\" class=\"" .$strLineClass  . "\" width=\"100%\">\n";
	$olddayoftheweek="";
	$arrStarts=Array();
	$arrEnds=Array();
	$arrForeignTablename=Array();
	//$out.= "<tr class=\"" . $strLineClass. "\"><td>time</td>\n";
	//return;
	$intFirstCalendarID="";
	
	foreach($arrCalendarIDs as $intCalendarID)
	{
		//echo $record["foreign_table_name"] . "<br>";
		if ($intFirstCalendarID=="")
		{
			$intFirstCalendarID=$intCalendarID;
		}
		//sets up the pacing for all the parallel calendars
		$size[$intCalendarID]=gracefuldecay($size[$intCalendarID], 31557600, $size[$intFirstCalendarID], 604800);
		$granules[$intCalendarID]=gracefuldecay($granules[$intCalendarID], 8760, $granules[$intFirstCalendarID], 168);
		//echo $granules[$intCalendarID] . " " . $intThisCalendarID . "<br>";
		$size_php_code[$intCalendarID]=gracefuldecay($size_php_code[$intCalendarID], "Y", $size_php_code[$intFirstCalendarID] );
		$granules_php_code[$intCalendarID]=gracefuldecay($granules_php_code[$intCalendarID], $granules_php_code[$intFirstCalendarID],"H");
		
		$colorcount[$intCalendarID]=0;
		$strSQL="SELECT * FROM " . $strDatabase . ".calendar_event WHERE calendar_id=" . $intCalendarID;
		//echo  	$strSQL . "<br>";
		$records = $sql->query($strSQL);
		
		$out.= "<td>\n";
		//echo "!";
		
		$strThisSQL="select calendar_name, foreign_table_name from " . $strDatabase . ".calendar where calendar_id = " . $intCalendarID;
		//echo $strThisSQL;
		$erecords = $sql->query($strThisSQL);
		$erecord=$erecords[0];
		$strCalendarName=$erecord["calendar_name"];
		$foreign_table_name=$erecord["foreign_table_name"];
		//echo $intCalendarID . " " .  $foreign_table_name . "<br>";
		
		//$strCalendarName = GenericDBLookup($strDatabase, 'calendar', "calendar_id", $intCalendarID, "calendar_name");
		//$arrForeignTablename[$intCalendarID]=GenericDBLookup($strDatabase, "calendar", "calendar_id", $intCalendarID,"foreign_table_name");  
		$FTable[$intCalendarID]=$foreign_table_name;
		$FTIDFieldName[$intCalendarID] = PKLookup($strDatabase, $foreign_table_name);
		//echo $FTIDFieldName[$intCalendarID] . "<br>";
		$FTNameField[$intCalendarID]=firstnonidcolumname($strDatabase, $foreign_table_name);
		//echo $NameField[$intCalendarID] . "<br>";
		
		$out.="<span class=\"heading\"><a onclick=\"javascript:return(editpopup('" . $strDatabase . "','calendar','calendar_id','" . $intCalendarID . "','',''))\">". $strCalendarName. "</a></span>";
		foreach($records as $record)
		{
			
			$id=$record["calendar_event_id"];
			$eventname=$record["event_name"];
			//echo $id . "-<br>"; 
			$ce_id=$record["calendar_event_characteristic_id"];
			if ($ce_id=="" || $ce_id==0)
			{
				$ce_id=0; //this means the event continues until it is supplanted, though i'm just assuming this is the case anyway  
			}
			$dtmThisStart=$record["start"];
			$dtmThisEnd=$record["end"];
			//echo $dtmThisStart . "=<br>";
			//echo $size[$intCalendarID] . "_" . $granules[$intCalendarID] . "*" . $intCalendarID . "<br>";
			$keyStart=TimeFormatToKey(strtotime($dtmThisStart), $size[$intCalendarID], $granules[$intCalendarID], "");
			$keyEnd=TimeFormatToKey(strtotime($dtmThisEnd), $size[$intCalendarID], $granules[$intCalendarID], "");
			$arrStarts[$keyStart][$intCalendarID]=$id;
			$arrEnds[$keyEnd][$intCalendarID]=$id;
		 	$arrEventNames[$keyStart][$intCalendarID]=$eventname;
			//echo $keyStart . " " . $intCalendarID . "-<br>";
	
			
		}
		$out.= "</td>\n";
		
	}
	
	$out.= "</tr>\n";
	//$record = $records[0];//eventually need to make a real call here
	$lineout=0;
	 
	//echo $size_php_code[$intFirstCalendarID]  . "<br>";
	//$dtmStart=RegularizeNowDate($size_php_code[$intFirstCalendarID], $dtmStart);
	
	//total zero-out hack:
	$dtmStart= ZeroBelowDateUnit($dtmStart, "H", "inclusive");
 
	$range=gracefuldecay($intSetRange, $size[$intFirstCalendarID]);
	//echo $range;
	if (count($arrCalendarIDs)>0)
	{
		$width="%" . intval(-$intDateWidthPercentage+(100 / (count($arrCalendarIDs))));
		for  ($i=0; $i<$range; $i=$i+$intIncrement[$intFirstCalendarID])
		{
			$lineout++;
			//echo date("Y-m-d H:i:s", $dtmStart)  . "- -" . $intIncrement[$intThisCalendarID] .  "- -" . intval($dtmStart + $i) . "- -" . date("Y-m-d H:i:s", $dtmStart +$i).  "- -" . $i . "<br>";
			//$dtmThis=AddUnitToDate($dtmStart, intval($i/3600), "H");
			$dtmThis=intval($dtmStart +  $i);
			$strSLQdate=date("Y-m-d H:i:s", $dtmThis);
			
			$dayoftheweek=date("l",$dtmThis);
			$dayoftheweekno=date("N",$dtmThis);
			$hour=date("H",$dtmThis);
			$minute=date("i",$dtmThis);
			$dateDisplay=$hour . ":" . $minute;
	
			//$eventname=$record["name"];
			$strSepara="";
			if ($lineout/2==intval($lineout/2))
			{
	 			$strThisColor = colorSubtract($strThisColor, "060606");
			}
			else
			{
	 			$strThisColor = colorAdd($strThisColor, "060606");
			}
			if ($olddayoftheweek!=$dayoftheweek)
			{
				$strSepara="<tr bgcolor=\"" . $strDayBarColor . "\"><td colspan=\"" . intval(count($arrCalendarIDs) + 1) . "\">";
				$strSepara.=SpacerGif(1, 1);
				$olddayoftheweek=$dayoftheweek;
				$strThisColor=Alternate($strColorOne, $strColorTwo, $strThisColor);
				
				$dateDisplay="<b>" . $dayoftheweek . "</b><br>" . $dateDisplay;
			}
		 	
			//echo $strThisEventColor . "*<br>";
			$out.=$strSepara;
			$out.= "<tr style=\"background-color:" . $strThisColor . "\">\n";
			$out.= "<td valign=\"top\" width=\"" . $intDateWidthPercentage . "%\">".  $dateDisplay   ."</td>\n";
			foreach($arrCalendarIDs as $intCalendarID)
			{
				$id="";
				$eventname="";
				//echo TimeFormatToKey($dtmThis, $size[$intCalendarID], $granules[$intCalendarID] , ""). "<br>";
		 		$id=  $arrStarts[TimeFormatToKey(RegularizeNowDate($size_php_code[$intCalendarID], $dtmThis), $size[$intCalendarID], $granules[$intCalendarID], "")][$intCalendarID];
				$eventname = $arrEventNames[TimeFormatToKey(RegularizeNowDate($size_php_code[$intCalendarID], $dtmThis), $size[$intCalendarID], $granules[$intCalendarID], "")][$intCalendarID];
	
				//echo $id . "<br>";
				if ($id!="")
				{
					//$eventname = GenericDBLookup($strDatabase, "calendar_event", "calendar_event_id", $id, "name");
					
					//$intForeignId = GenericDBLookup($strDatabase, "calendar_event", "calendar_event_id", $id, "foreign_id");
					//$strThisSQL="select foreign_id, notes, event_name from " . $strDatabase . ".calendar_event where calendar_event_id = " . $id;
					//$erecords = $sql->query($strThisSQL);
					//$erecord=$erecords[0];
					//$notes=$erecord["notes"];
					//$intForeignId =$erecord["foreign_id"];
					//$eventname= $erecord["event_name"];
					$strForeignTableName=$arrForeignTablename[$intCalendarID];
					//echo $strForeignTableName . "<br>";
					
					$strNameField=$NameField[$intCalendarID];
					//echo $strNameField . "<br>";
					//the bad old way to do it:
					//$eventname= GenericDBLookup($strDatabase, $FTable[$intCalendarID], $FTIDFieldName[$intCalendarID] , $intForeignId, $FTNameField[$intCalendarID]);
					$eventname =simplelinkbody(gracefuldecay($eventname, $notes, "unnamed"));
					//echo $strDatabase . " 1:" . $strForeignTableName . " 2:" . $strFTIDFieldName . " 3:" . $intForeignId  . " 4:" . $strNameField . "<br>";
					//
			 
					$strEventColor[$intCalendarID]=$thiscolor[$colorcount[$intCalendarID]];
					
					$colorcount[$intCalendarID]++;
					if ($colorcount[$intCalendarID]>=count($thiscolor))
					{
						$colorcount[$intCalendarID]=0;
					}
					
					//echo $strEventColor . "<br>";
				}
		 
				$arrThisEventColor[$intCalendarID]=colorAdd($strThisColor, $strEventColor[$intCalendarID]);
				
				//$strThisBgClass=Alternate($strBgClassFirst, $strBgClassSecond, $strThisBgClass);
			
				$eventhtml="";
				if ($eventname=="")
				{
					$eventname="[add]";
				
				}
				else
				{
					$eventhtml.="[<a onclick=\"javascript:if(confirm('Are you sure you want to delete this calendar item?')){ return(editpopup('" . $strDatabase . "','calendar_event','calendar_event_id','" . $id . "',Array('start','calendar_id','" . qpre . "mode'), Array('" .  $strSLQdate . "','" .  $intCalendarID . "','delete')))}\">X</a>] ";
				}
				$eventhtml.="<a onclick=\"javascript:return(editpopup('" . $strDatabase . "','calendar_event','calendar_event_id','" . $id . "',Array('start','calendar_id'), Array('" .  $strSLQdate . "','" .  $intCalendarID . "')))\">". $eventname. "</a>";
				
		
			 	$out.= "<td valign=\"top\" width=\"" . $width. "\" style=\"background-color:" . $arrThisEventColor[$intCalendarID] . "\">".  $eventhtml   ."</td>\n";
			 	
			}
			$out.= "</tr>\n";
		}
	}
	$out.= "</table>\n";

	return $out;
}


 
function calendardateformat($intDate)
{
	if (is_numeric($intDate))
	{
		$out=date("H:i", intval($intDate));
	}
	else
	{
		$out=date("H:i", strtotime($intDate));
	}
	//echo "<p>" . time() . " " . $intDate . " " . $out . "<p>";
	return $out;
}

function RegularizeNowDate($strSpanPHPCode, $dtmIn="")
{
//makes a date reasonably contemporary given the spansize (obviously, you don't want to contemporize years if the span size is ten years in size
	$strTimeConfig="604800-l-d-7-Sunday-H|31557600-Y----m";
	if ($dtmIn=="")
	{
		$dtmIn=time();  //use the server clock for now if no dtmIn
	}
	$out=$dtmIn;

	$arrConfig=explode("|", $strTimeConfig);
	for ($i=0; $i<count($arrConfig); $i++)
	{
		$arrThis=explode("-", $arrConfig[$i]);
		// echo $arrThis[0] . "-<br>";
		// echo "!";
		if ( $strSpanPHPCode==$arrThis[1])
		{
			//here i need to trash date info smaller than our intSpanSize
			//echo $dtmIn . " " .  $arrThis[5] . " " . " " . "<br>";
			$dtmBasis = ZeroBelowDateUnit($dtmIn, $arrThis[5], "inclusive");
			//echo date("Y-m-d H:i:s",$dtmBasis). "<br>";
			//echo $dtmBasis . " " .  $arrThis[5] . " " . " " . "<br>";
			//$dtmBasis=strtotime(date("m.d.y",$dtmIn));
			//return $dtmBasis;
			//pick a week near the current one and go!
			
			if (2==1)
			{
			for ($i=0; $i<$arrThis[3]; $i++)
			{
				//echo $arrThis[2] . "<br>";
				$newdate=AddUnitToDate($dtmBasis, $i, $arrThis[2]);
				//echo date("Y-m-d H:i:s",$newdate). "<br>";
				//echo date("N", $newdate) . "<br>";
				if (date($arrThis[1], $newdate)==$arrThis[4])
				{
					$out=$newdate;
				}
			}
			}
		}
	}
	//echo date("Y-m-d H:i:s",$out). "<br>";
	return $out;
}

function AddDaysToDate($date, $amount)
	//give me a date that is $amount days in the future (can take negative for the past)
	{
		$newdate  = mktime (0,0,0,date("m", $date), date("d", $date)+$amount , date("Y", $date));
		return($newdate);
	}

function AddUnitToDate($date, $unit, $type)
//give me a date that is $amount of $units of $type (defined in PHP date function) in the future (can take negative for the past)
{	
	$strConfig="H|i|s|m|d|Y";
	$arrConfig=explode("|", $strConfig);
	$strAction="mktime(";
	for ($i=0; $i<count($arrConfig); $i++)
	{
		$strAction.="date(\"" . $arrConfig[$i] . "\", " . $date . ")";
		if ($type==$arrConfig[$i])
		{
			$strAction.="+" . $unit;
		}
		if($i<count($arrConfig)-1)
		{
			$strAction.=",";
		}
		else
		{
			$strAction.=");";
		}
	}
	$out=eval("return " . $strAction);
	//echo $out . "----------<br>";
	return($out);
}

function xAddUnitToDate($date, $unit, $type)
//give me a date that is $amount of $units of $type (defined in PHP date function) in the future (can take negative for the past)
{	
	$strConfig="H|i|s|m|d|Y";
	$arrConfig=explode("|", $strConfig);
	$strAction="mktime(";
	for ($i=0; $i<count($arrConfig); $i++)
	{
		$strAction.="date(\"" . $arrConfig[$i] . "\", " . $date . ")";
		if ($type==$arrConfig[$i])
		{
			$strAction.="+" . $unit;
		}
		if($i<count($arrConfig)-1)
		{
			$strAction.=",";
		}
		else
		{
			$strAction.=");";
		}
	}
	$out=eval("return " . $strAction);
	return($out);
}
	
function ZeroDateUnit($date, $type)
	//give me a date with the timepart of $type (defined in PHP date function) zeroed
	//in some cases this means set to numbers other than zero
	{	
		$strConfig="H-0|i-0|s-0|m-1|d-1|Y-2000";
		$arrConfig=explode("|", $strConfig);
		$strAction="mktime(";
		for ($i=0; $i<count($arrConfig); $i++)
		{
			$arrThis=explode("-", $arrConfig[$i]);
			
			if ($type==$arrThis[0])
			{
				$strAction.=$arrThis[1];
			}
			else
			{
				$strAction.="date(\"" . $arrThis[0] . "\", " . $date . ")";
			}
			if($i<count($arrConfig)-1)
			{
				$strAction.=",";
			}
			else
			{
				$strAction.=");";
			}
		}
		//echo $strAction . "<br>";
		$out=eval("return " . $strAction);
		return($out);
	}
	
 
	
function ZeroBelowDateUnit($date, $type, $mode="inclusive")
	//give me a date with the timepart of $type (defined in PHP date function) zeroed
	//in some cases this means set to numbers other than zero
	{	
		$strConfigOrder="Y m d H i s";
		if ($mode=="inclusive")
		{
			$strConfigOrder=substr($strConfigOrder, strpos($strConfigOrder, $type));
		}
		else
		{
			$intPlace= strpos($strConfigOrder, $type)+2;
			if ($intPlace<=strlen($strConfigOrder))
			{
				$strConfigOrder=substr($strConfigOrder,$intPlace);
			}
		}
		//echo "<br>" . $strConfigOrder;
		$strConfig="H-0|i-0|s-0|m-1|d-1|Y-2000";
		$arrConfig=explode("|", $strConfig);
		$strAction="mktime(";
		for ($i=0; $i<count($arrConfig); $i++)
		{
			$arrThis=explode("-", $arrConfig[$i]);
			
			if (inList($strConfigOrder, $arrThis[0]))
			{
				$strAction.=$arrThis[1];
			}
			else
			{
				$strAction.="date(\"" . $arrThis[0] . "\", " . $date . ")";
			}
			if($i<count($arrConfig)-1)
			{
				$strAction.=",";
			}
			else
			{
				$strAction.=");";
			}
		}
		//echo "<br>" .  $strAction . "<br>";
		$out=eval("return " . $strAction);
		return($out);
	}
 
function TimeFormatToKey($dtmThis, $intSpanSize, $intGranularity, $strOutputType="")
//convert a standard PHP datetime into an appropriate key given the size of the calendar
{
	$tolerance=0.7;
	$intGranularityType="";
	$intSpanType="";
	$strTimeConfig="1-s|15-s|60-i|900-i|1800-i|3600-H|43200-H|86400-d|604800-N|2678400-m|8035200-m|31557600-Y";
	$arrTimeConfig=explode("|", $strTimeConfig);
	//scan through the different granule types and come back with the general size of the one passed in, both for total span size and granularity
	for($i=0; $i<count($arrTimeConfig); $i++)
	{
		$arrThis=explode("-" , $arrTimeConfig[$i]);
		$intThisGranule=intval($arrThis[0]); 
		//echo  $intThisGranule . " " .  $intThisGranule* $tolerance . " " . $intThisGranule/ $tolerance  . ($intGranularity>($intThisGranule* $tolerance)  && $intGranularity<($intThisGranule/$tolerance)) . "<br>";
		if ($intGranularity>($intThisGranule* $tolerance)  && $intGranularity<($intThisGranule/$tolerance)  || $intGranularity<($intThisGranule/$tolerance) && $intGranularityType=="") //we're at the right granule size for intgranularity
		{
			//echo $intThisGranule* $tolerance . "<br>";
			$intGranularityType=$i;
		}
		if ($intSpanSize>($intThisGranule* $tolerance)  && $intSpanSize<($intThisGranule/$tolerance) || $intSpanSize<($intThisGranule/$tolerance)  && $intSpanType=="") //we're at the right granule size for intgranularity
		{
			$intSpanType=$i;
		}
	}
	$out="";
	$code="";
	$strOldDateCode="";
	$skipD=false;
	$skipN=false;
	//code to make it not look at day of the month if it's clearly a week calendar
	//otherwise, we don't care about days of the week
	if ($intSpanSize==604800)
	{
		$skipD=true;
	}
	else
	{
		$skipN=true;
	}
	//echo $intGranularityType . "^<br>";
	for($i=$intSpanType; $i>$intGranularityType-2; $i--)
	{
		$arrThis=explode("-" , $arrTimeConfig[$i]);
		$strDateCode=$arrThis[1];
		
		if ($strDateCode!=""  && $strDateCode!=$strOldDateCode  && !($skipD && $strDateCode=="d") && !($skipN && $strDateCode=="N"))
		{
			//echo $strDateCode . " " . date($strDateCode,$dtmThis) . "<br>";
			$out.="-" . date($strDateCode,$dtmThis);
			$code.="-" . $strDateCode;
			$strOldDateCode=$strDateCode;
		}
	
	}
	$code=RemoveEndCharactersIfMatch($code, "-");
	$out=RemoveEndCharactersIfMatch($out, "-");
	if ($strOutputType=="code")
	{
		return $code;
	}
	//return $code;
	return  $out;
}
 ?>