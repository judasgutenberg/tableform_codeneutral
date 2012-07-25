<?php 
//Federico Frankenstein February 2007////////////////
//calendar functions 
//This code is covered under the GNU General Public License
//info here: http://www.gnu.org/copyleft/gpl.html
//the digest is as follows: you cannot modify this code without
//publishing your source code under the same license
//contact the developer at gus@asecular.com  http://asecular.com

function SpecificCalendarDayIframe($datecode, $width=800)
{
	$out.="\n<iframe frameborder=\"0\" marginwidth=\"0\" marginheight=\"0\" width=\"" .$width . "\" height=\"600\" name=\"dayframe\" src=\"dayframe.php?datecode=" . $datecode . "\"></iframe>";
	return $out;
}


function SpecificCalendarMonthIframe($datecode)
{
	$out.="\n<iframe frameborder=\"0\" marginwidth=\"0\" marginheight=\"0\" width=\"270\" height=\"320\" name=\"calendarframe\" src=\"calendarframe.php?datecode=" . $datecode . "\"></iframe>";
	return $out;
} 

function CalendarDataFrame($datecode, $mode)
{
	$out.="\n<iframe frameborder=\"0\" marginwidth=\"0\" marginheight=\"0\" width=\"1\" height=\"1\" name=\"calendardataframe\" src=\"calendardata.php?" . qpre . "&" . qpre . "mode=" . $mode. "&datecode=" . $datecode . "\"></iframe>";
	return $out;
} 


function CalendarData($datecode,  $intOfficeUserID, $intPatientUserID,$strPHP, $mode="" )
{
	$sql=conDB();
	$out="";
	//$strTable="personal_calendar_event";
	//$strTable2="practitioner";
	
	$strSQL="CREATE TEMPORARY TABLE results(datecode varchar(50), counter int, name varchar(50), result_type int, recurrence varchar(30) );";
	$records = $sql->query($strSQL);
		//echo sql_error()."\n\n\n\n";
	//logmysqlerror($mode, true);
	if($mode=="office")
	{
		$strSQL="INSERT INTO " . our_db . ".results(datecode, counter, name, result_type, recurrence) select c.datecode, count(*) as counter, p.name ,1, 0  FROM  " . our_db . ".personal_calendar_event c LEFT JOIN  " . our_db . ".practitioner p ON c.practitioner_id=p.practitioner_id    WHERE  c.office_login_id='" . $intOfficeUserID . "' GROUP BY datecode;";
	}
	else
	{
		$strSQL="INSERT INTO " . our_db . ".results(datecode, counter, name, result_type, recurrence) select c.datecode, count(*) as counter, p.name ,1, 0 FROM  " . our_db . ".personal_calendar_event c LEFT JOIN  " . our_db . ".practitioner p ON c.practitioner_id=p.practitioner_id   WHERE  c.client_login_id='" . $intPatientUserID . "' GROUP BY datecode;";
	}
	 "');</script>";
 
	if(CanChange())
	{
		$records = $sql->query($strSQL);
	}
	else
	{
		echo "Database is read-only.";
	}
	//logmysqlerror($strSQL, true);
		//echo sql_error()."\n\n\n\n";
	if($mode=="office")
	{
	//$strSQL="INSERT INTO  results(datecode, counter, name, result_type) SELECT CONCAT( SUBSTRING(year(NOW()),3,2),lpad(month(NOW()),2,'0') , lpad(dayofmonth(NOW()),2,'0')), 1 ,p.office_name, 2 from " . our_db . ".user p WHERE  user_id=" . $intOfficeUserID . " ; ";
	}
	else
	{
	//$strSQL="INSERT INTO  results(datecode, counter, name, result_type) SELECT CONCAT( SUBSTRING(year(NOW()),3,2),lpad(month(NOW()),2,'0') , lpad(dayofmonth(NOW()),2,'0')), 1 ,p.lastname, 2 from " . our_db . ".user p WHERE user_id=" . $intPatientUserID . " ; ";
	}
	
	if(CanChange())
	{
		//$records = $sql->query($strSQL);
	}
	else
	{
		//echo "Database is read-only.";
	}
	//logmysqlerror($strSQL, true);
		//echo sql_error()."\n\n\n\n";
	$strSQL="SELECT  datecode, name, sum(counter) as counter, sum(result_type) as type, recurrence  from  results GROUP BY datecode order by datecode";
	//logmysqlerror($strSQL, true);
	$records = $sql->query($strSQL);
	//echo "\n\n\n\n\n" . $strSQL ."\n\n\n\n";
	//echo sql_error()."\n\n\n\n";
	 
	foreach($records as $record)
	{
		//echo $record["counter"] . "=<br>";
		$out.=$record["datecode"] . "|" . $record["counter"] . "|". $record["name"] ."|". $record["type"] . "^";
		if ($record["recurrence"]!="")
		{
			//echo "--" . $record["recurrence"];
			$arrRecurrence=explode(" ", deMultiple($record["recurrence"], " "));
			//$newdatecode=adddaystodate(makedate($record["datecode"]), 1);
			$newdatecode=NextPossibleDateCode(IncrementDatecodeByUnit($record["datecode"],  $arrRecurrence[0], $arrRecurrence[1]));
			//echo $datecode . " " . $newdatecode . " " . $arrRecurrence[0] . " " . $arrRecurrence[1] . "\n";
			if($arrRecurrence[0]>0)
			{
				//echo makedatecode(addmonthstodate(makedate($record["datecode"]), 12)) . "=newdatecode\n";
				while($newdatecode< makedatecode(addmonthstodate(makedate($record["datecode"]), 36))) //three years into the future
				{
					$out.=$newdatecode . "|1|". $record["name"] ."|4|" .  $record["datecode"] . "^";
				
					$newdatecode=NextPossibleDateCode(IncrementDatecodeByUnit($newdatecode,  $arrRecurrence[0], $arrRecurrence[1]));
				}
			}
		}
	}
	$strSQL="DROP TEMPORARY TABLE results";
	$records = $sql->query($strSQL);
	return $out;
}

function IncrementDatecodeByUnit($datecode,  $unit, $type)
{
	$date=makedate($datecode);
	$out  =  makedatecode(AddUnitToDate($date, $unit, $type));
	return $out;
	
}



function AddUnitToDate($date, $unit, $type)
	//give me a date that is $amount of $units of $type (defined in PHP date function) in the future (can take negative for the past)
	{	
		$strConfig="H|i|s|m|d|Y";
		if ($type=="W")
		{
			$unit=$unit*7;
			$type="d";
		}
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
		//echo $strAction . "\n";
		$out=eval("return " . $strAction);
		return($out);
	}
	





function RenderCalendar($datecode,  $intUserID, $strPHP, $day_name_length = 3, $month_href = NULL, $first_day = 0)
{
	$sql=conDB();
 	$style="littlenav";
	$calendarcell="calendarcell";
	$date=makedate($datecode);
	$datearray=getdate($date);
	$month=$datearray["mon"];
	$year=$datearray["year"];
	$basecolor=themecolor;
	$colorfraction="001111";
	$arrPopulatedDatecodes=Array();
	$strTable="personal_calendar_event";
	//echo $month . " " . $year;
	$first_of_month = gmmktime(0,0,0,$month,1,$year);
	$day_names = array(); #generate all the day names according to the current locale
	
	
	$strSQL="SELECT   datecode, count(*) as counter  FROM  " . $strDatabase . "." .  $strTable . " WHERE  datecode>='" .substr($datecode,0,4) . "01" . "' AND datecode<'" . addmonthstodate(substr($datecode,0,4), 1) . "01" . "' AND user_id=" .  $intUserID . " GROUP BY datecode";
	//echo $strSQL;
	$records = $sql->query($strSQL);
		
	 
	foreach($records as $record)
	{
		//echo $record["counter"] . "=<br>";
		$arrPopulatedDatecodes[$record["datecode"]]=$record["counter"];
	}
 
	
	for($n=0,$t=(3+$first_day)*86400; $n<7; $n++,$t+=86400) #January 4, 1970 was a Sunday
	{
		$day_names[$n] = ucfirst(gmstrftime('%A',$t)); #%A means full textual day name
	}
	list($month, $year, $month_name, $weekday) = explode(',',gmstrftime('%m,%Y,%B,%w',$first_of_month));
	$weekday = ($weekday + 7 - $first_day) % 7; #adjust for $first_day
	$title   = htmlentities(ucfirst($month_name)).'&nbsp;'.$year;  #note that some locales don't capitalize month and day names
	$out = '<table class="calendar" cellpadding="1" cellspacing="1" border="0" width="100%">';
	$out .= '<caption class="calendar-month"><a href="' . $strPHP . '?datecode=' .  makedatecode(addmonthstodate($date, -1)) . '">&lt;</a> ' . ($month_href ? '<a href="'.htmlspecialchars($month_href).'">'.$title.'</a>' : $title). '</a> <a href="' . $strPHP . '?datecode=' .  makedatecode(addmonthstodate($date, 1)) . '">&gt;</a></caption>';
	$out .= "<tr>";
	$row=0;
	if($day_name_length)
	{ #if the day names should be shown ($day_name_length > 0)
		#if day_name_length is >3, the full name of the day will be printed
		foreach($day_names as $d)
		{
			$out .= '<th abbr="'.htmlentities($d).'">'.htmlentities($day_name_length < 4 ? substr($d,0,$day_name_length) : $d).'</th>';
		}
		$out .= "</tr>\n<tr>";
	}
	if ($weekday > 0) $out .= '<td colspan="'.$weekday.'">&nbsp;</td>'; #initial empty days
	for($day=1,$days_in_month=gmdate('t',$first_of_month); $day<=$days_in_month; $day++,$weekday++)
	{
		if($weekday == 7)
		{
			$weekday   = 0; #start a new week
			$out .= "</tr>\n<tr>";
			$row++;
		}
 
		 
		
 
 		//$link=$strPHP . "?" . $datecode;
		$thisdatecode= substr($datecode,0,4) . str_pad($day , 2, '0', STR_PAD_LEFT);
		$content  = "<a target=\"dayframe\" href=\"dayframe.php?datecode=" .  $thisdatecode . "\">" . $day . "</a>";
		
		//$out .= "<td class=\"" .$calendarcell ."\">" . $content . "</td>\n";
		$thiscolorfraction="000000";
		//echo $thisdatecode  . " " . $arrPopulatedDatecodes[$thisdatecode] . "<br>"; 
		//echo $arrPopulatedDatecodes[$thisdatecode] . "<br>";
		for($i=0; $i<$arrPopulatedDatecodes[$thisdatecode]; $i++)
		{
			$thiscolorfraction=colorADD($thiscolorfraction, $colorfraction);
			if($i>5)
			{
				 break;
			}
		}
		//echo $thiscolor . "<br>";
		$thiscolor=colorSubtract($basecolor,$thiscolorfraction);
	 	$out .= "<td bgcolor=\"" .$thiscolor ."\">" . $content . "</td>\n";
	 
	}
	if ($weekday != 7) 
	{
		$out .= '<td colspan="'.(7-$weekday).'">&nbsp;</td>'; #remaining "empty" days
	}
	$out.="</tr>\n";
	//echo $row;
	if ($row<5)
	{
		$out.="<tr><td colspan=\"7\">&nbsp;</td></tr>\n"; #keep all calendars the same height to help with rapid nav
	}
	$out.="</table>\n";
	$out.="<br>";
	return $out;
}
	
	
function datecodetoyear($datecode)
{
	$datearray=getdate(makedate($datecode));
	$year=$datearray["year"];
	return ($year);
}

function datecodetomonthname($datecode)
{
	$datearray=getdate(makedate($datecode));
	$month=$datearray["month"];
	return ($month);
}

function makedate($datecode, $datelesstime="")
	{
		$year=substr($datecode,0,2);
		$month=substr($datecode,2,2);
		$day=substr($datecode,4,2);
		$newdate=strtotime($month . '/' . $day . '/' . $year . " " .$datelesstime);
		return($newdate);
	}

function displaydatecode($datecode)
{
	$year=substr($datecode,0,2);
	$month=substr($datecode,2,2);
	$day=substr($datecode,4,2);
	return $month . '/' . $day . '/' . $year;
}

function cleanuptime($time)
{
	$arrTime=explode(":", $time);
	$i=0;
	$arrOut=Array();
	foreach($arrTime as $component)
	{
		if($i==0)
		{
			$strExtension="AM";
			if(intval($component)>12)
			{
				$component=intval($component)-12;
				$strExtension="PM";
			}
		}
		$arrOut[$i]=str_pad(intval($component),2,"0", STR_PAD_LEFT);
		$i++;
	}
	return join(":",  $arrOut) . $strExtension;
}

function makedatecode($date)
	//function written in the Summer of 2001, back when I was just learning PHP
	//given a date, i want the datecode in the form YYMMDD
	{
		$datecode=str_pad(substr(date("Y", ($date)),2,2), 2, '0', STR_PAD_LEFT) . str_pad(date("m", ($date)), 2, '0', STR_PAD_LEFT)   . str_pad(date("d", ($date)), 2, '0', STR_PAD_LEFT) ;
		return($datecode);
	}
  
  
function todaydatecode()
	//return the datecode of today in the form YYMMDD
	{
		$datearray=getdate();
		$year=substr($datearray["year"],2,2);
		$month=str_pad($datearray["mon"], 2, '0', STR_PAD_LEFT);
		$day=str_pad($datearray["mday"], 2, '0', STR_PAD_LEFT);
		$out=$year . $month . $day;
		return($out);
	}
	
	

function addmonthstodate($date, $amount)
	//add months to this $date
	{
		$weird=$date;
		$newdate  = mktime (0,0,0,date("m", $weird)+$amount, date("d", $weird), date("Y", $weird));
		return($newdate);
	}
	
function adddaystodate($date, $amount)
	//give me a date that is $amount days in the future (can take negative for the past)
	{
		$weird=$date;
		$newdate  = mktime (0,0,0,date("m", $weird), date("d", $weird)+$amount , date("Y", $weird));
		return($newdate);
	}
	
function earlierday($datecode, $amount=1)
	//give me the YYMMDD datecode preceding this one
	{
		$out=makedatecode(adddaystodate(makedate($datecode), -$amount));
		return($out);
	}

function laterday($datecode, $amount=1)
	//give me the YYMMDD datecode for the one following this one
	{
		$out=makedatecode(adddaystodate(makedate($datecode), $amount));
		return($out);
	}
	
function firstofnextmonth($datecode)
	//i want to know what the datecode of the first of next month looks like
	{
		$out=makedatecode(addmonthstodate(makedate($datecode), 1));
		$out=substr($out, 0, 4). "01";
		return($out);
	}
	
	

function MultipleEventList($strDatabase, $datecode, $intOfficeUserID, $intPatientUserID,  $strSearchTerm="", $strSearchType="", $strFTables, $arrFieldNamesIn="")
{
	//echo  "db:" . $strDatabase . " datecode:" . $datecode . " intuserID:" .  $intUserID ;
	$sql=conDB();
 	$strTable="personal_calendar_event";
	if($strDatabase=="")
	{
		$strDatabase=our_db;
	}
	$out="";
	$dataHTML="";
	$intFieldOut=1;
	$rowOut=0;
	$arrParam=Array();
	$arrLabels=Array();
	$arrFTables=Array();
	$questionids="";
	$sql_data_types="";
	$strFormWidths="";
	$strFormHeights="";
	$xlist="";
	$intWidth=15;
	
	$intTextHeight=2;
	$strClass1="firstrow";
	$strClass2="secondrow";
	$strThisClass="";
 
 
	$arrLabels[0]="subtleheader";
	
	
 	$listaddside="right";
	if (listaddside=="left" )
	{
		$listaddside="left";
	}
	//echo $listaddside;
	if(!TableExists($strDatabase, $strTable))
	{
		$errors=CreateTableFromSQLFile($strDatabase, $strTable);
	}
	if($arrFieldNamesIn=="")
	{
	$arrFieldNames=Array();
	$records=TableExplain($strDatabase, $strTable);
	foreach ($records as $k => $v )
	{
		//echo $k . " " . $v["Field"]  . "<br>";
		//$strTFSQL="SELECT * FROM " . tfpre . "relation WHERE table_name='". $strTable . "' AND column_name='" . $v["Field"]. "'";
		//$TFrecords = $sql->query($strTFSQL);
		//echo sql_error();
		//if (count($TFrecords)>0)
		//{
			//$TFrecord=$TFrecords[0];
			//$TFTable=$TFrecord["f_table_name"];
			//$TFColumn=$TFrecord["f_column_name"];
			//$namecolumn=NthNonIDColumName($strDatabase, $TFTable, 1);
			//$v["Field"]=$namecolumn;
			//$v["Type"]="varchar";//total hack - but usually true!
		//}
		//kinda hacky but...
		$field=$v["Field"];
 
 
	 	if ((contains($v["Type"], "varchar") || $v["Type"]=="text")  && $v["Field"]!="datecode" )
		{
			$question=$v["Field"];
			$question_id=$intFieldOut;
			$questionids.=" " . $question_id;
			$intHeight=1;
			
			if($v["Type"]=="text"  )
			{
				$intHeight=$intTextHeight;
				$strWidth=27;
			}
			else
			{
				$strWidth=(TypeParse($v["Type"], 1)); //$intWidth;
				if ($strWidth>$intWidth)
				{
					$strWidth=$intWidth;
				}
			}
			$foreigntable="";
	 
			$strFormWidths.=" " . $strWidth;
			$strFormHeights.=" " . $intHeight;
			//$arrFtables[$j];
			//answerformwrap($answer, $x, $y, $sql_data_type, $foreigntable, $bwlHidden=false, $width=20, $height=1, $intUserID)
			
			
	
			//$arrOut[$j]=answerformwrap($answer, $intQuestionID, $i,$arrDataTypes[$j], $arrFTables[$j ], false, $arrWidths[$j], $arrHeights[$j], $intOfficeUserID,  false, $strTable, $arrLimiting, $strPreferredNameField);
			
			$arrLabels[$intFieldOut]="<label>" . DisplayLabel($question) . "</label>" . answerformwrap("", $question_id, 0, $sql_data_type, $foreigntable, true, $strWidth, $intHeight, $intOfficeUserID, false, $arrLimiting, $strPreferredNameField);
			$arrFieldNames[$intFieldOut]=$field;
			$arrFTables[$intFieldOut]=$foreigntable;
			$intFieldOut++;
			
		}
	}
	
	}
	else
	{
		$intFieldOut=1;//can't begin with 1 because that's the class for the row!!
		$question_id=44;
		
		$foreigntable="";
		$strWidth="12";
		$intHeight=1;
		foreach($arrFieldNamesIn as $question=>$v)
		{
			//echo $question . "<BR>";
			$foreigntable="";
			$strExtraconditional="";
			$sql_data_type="varchar";
			if(contains($v, "|"))
			{
				$arrV=explode("|", $v);
				//echo "$";
				$foreigntable=$arrV[0];
				$strExtraconditional=$arrV[1];
				$sql_data_type="int";
			}
			else
			{
				$foreigntable=$v;
				$sql_data_type="int";
			}
			//echo $foreigntable . "@<BR>";
			$strFormWidths.=" " . $strWidth;
			$strFormHeights.=" " . $intHeight;
			//echo "=" . $question . "*".  $foreigntable . "=<P>";
			//answerformwrap($answer, $x, $y, $sql_data_type, $foreigntable, $bwlHidden=false, $width=20, $height=1, $intUserID="", $bwlNoForm=false,  $strMappingTableAvoidList="")
			//$arrOut[$j]=answerformwrap($answer, $intQuestionID, $i,$arrDataTypes[$j], $arrFTables[$j ], false, $arrWidths[$j], $arrHeights[$j], $intOfficeUserID,  false, $strTable, $arrLimiting, $strPreferredNameField);
	
			//HARDCODING CENTRAL!!
			if($foreigntable=="practitioner")
			{
				$arrLimiting=Array("office_login_id"=>$intOfficeUserID);
			 	$strPreferredNameField="";
			}
			else if($foreigntable=="user")
			{
				$arrLimiting=Array("is_office"=>0, "office_login_id"=>$intOfficeUserID);
				$strPreferredNameField="firstname lastname";
			}
	
			$arrLabels[$intFieldOut]="<label>" . DisplayLabel($question) . "</label>" . answerformwrap("", $intFieldOut-1, 0, $sql_data_type, $foreigntable, true, $strWidth, $intHeight, $intOfficeUserID,false, $strTable, $arrLimiting, $strPreferredNameField);
			$questionids.=" " . intval($intFieldOut-1);
			$arrFieldNames[$intFieldOut-1]=$question;
			$arrFTables[$intFieldOut]=$foreigntable;
			//echo $intFieldOut . "^" .  $arrFTables[$intFieldOut ] . "&" . $foreigntable . "=<BR>";
	 		$intFieldOut++;
		
			
 
		}
	}
 
	//$strSQL="SELECT * FROM " . $strDatabase . ".questionnaire_answer a  WHERE a.questionnaire_id=" .$intThisQuestionnaireID . " AND user_id=" . $intUserID . " ORDER BY answer_group_id ASC";
	//$strSQL="SELECT * FROM " . $strDatabase . "." . $strTable . "  WHERE datecode=" .$datecode . " AND user_id=" . $intUserID . " ORDER BY sort_id ASC";
	//$additionalClauses=" WHERE datecode=" .$datecode . " AND t.office_login_id=" . $intOfficeUserID . " ORDER BY sort_id ASC";
	//normally would be ORDER BY sort!
	$additionalClauses=" WHERE datecode=" .$datecode . " AND office_login_id=" . $intOfficeUserID . " ORDER BY time ASC";
	//FleshedOutFKSelect($strDatabase, $strTable, $additionalClauses, &$arrDesc, $strUnnecessaryJoinTables="", $bwlKeepPKs=false, $bwlIncludeAllRelatedFields=false, $arrFKNameMap="")
	//$strSQL=FleshedOutFKSelect($strDatabase, $strTable, $additionalClauses,  $arrDesc, "", true, false, Array("office_login_id"=>"office_name", "client_login_id"=>"lastname firstname"));
	$strSQL="SELECT * FROM " . our_db . "." . $strTable . "   " . $additionalClauses;
	//echo "<b>eventsql:</b> " . $strSQL . "<P>";
	$records = $sql->query($strSQL);
	//echo sql_error();
	$out.= "<script src=\"tf_multipleanswer.js\"><!-- --></script>\n";
	$out.= "<script src=\"tf.js\"><!-- --></script>\n";
	$out.= "\n<script>	colorbg('" .themecolor . "')</script>\n";
	$out.= "<form method=\"post\" name=\"BForm\" action=\"" .  $strPHP . "\">\n";
	$out.= "<table class='bgclassline' border=\"0\" cellspacing=\"1\" cellpadding=\"3\" class=\"" .$strLineClass  . "\" width=\"100%\">\n";
	//$arrParam[0]="";  //because of the way htmlrow works, this is to set the class of the display of that row

	$firstaddlink="<a id=\"idaddfield-0\" href=\"javascript: addQrow('addfield-0' )\"><img  onmouseover=\"glow(this, 'on')\"  onmouseout=\"glow(this, 'off')\" border=\"0\" src=\"" . imagepath . "/insert_" .$listaddside . ".gif\"></a>".HiddenInputs(array("group_id[]"=>"", "swapfieldd-0" =>""),"");
	foreach($records as $record)
	{
		$sort_id=$record["sort_id"];
		$arrParam[$sort_id][0]=$record[$sort_id];
		//echo count($arrFieldNames) . "<br>";
		for($i=0; $i<=count($arrFieldNames); $i++)
		{
			//echo $sort_id . "-" . $arrFieldNames[$i] . "+" . $i . "=" . $record[$arrFieldNames[$i]] . "<br>";
			$arrParam[$sort_id][$i]=$record[$arrFieldNames[$i]];
			//$foreigntable="";
			//echo $arrFieldNames[$i] . " " . $record[$arrFieldNames[$i]]  . "<br>";

			//$arrFtables[$intFieldOut]=$foreigntable;
			
		}
		//echo $sort_id . "<br>";
	}


	$arrQuestionIDs=explode(" ", $questionids);
	$arrDataTypes=explode(" ",$sql_data_types);
	$arrWidths=explode(" ",$strFormWidths);
	$arrHeights=explode(" ",$strFormHeights);
	for($i=1; $i<=count($records); $i++)
	{
		//echo "count:" .  count($arrParam[$i]) . "<br>";
		//echo count($arrParam[$sort_id]) . "=isarray<br>";
	 	$arrOut=Array();
		$strThisClass=Alternate($strClass1, $strClass2, $strThisClass);
		$arrOut[0]="*" . $strThisClass;

		for($j=1; $j<count($arrQuestionIDs) ; $j++)
		{
			
			$intQuestionID=$arrQuestionIDs[$j];
			//echo $arrParam[$i][$intQuestionID]  . "*" . $intQuestionID .  "+".   $j . "^" . $arrFieldNames[$j] . "#" . $arrFieldNames[$intQuestionID] . "<br>";
			//echo $intQuestionID . " " . $j  . "<br>";
			$answer=$arrParam[$i][$intQuestionID];
			//echo $intQuestionID . " " . $answer . "<br>";
			//answerformwrap($answer, $x, $y, $sql_data_type, $foreigntable, $bwlHidden=false, $width=20, $height=1)
	
			//echo $arrFieldNames[$j] . "=<br>";
		
 			
			//echo $foreigntable . "<br>";
			//echo $answer . "<br>";
			//echo $j . " " .  $arrFTables[$j ];
			//answerformwrap($answer, $x, $y, $sql_data_type, $foreigntable, $bwlHidden=false, $width=20, $height=1, $intUserID="", $bwlNoForm=false,  $strMappingTableAvoidList="", $arrLimiting=Array("user_id"=>$intUserID))

			//HARDCODING CENTRAL!!
			if($arrFTables[$j ]=="practitioner")
			{
				$arrLimiting=Array("office_login_id"=>$intOfficeUserID);
			 	$strPreferredNameField="";
			}
			else if($arrFTables[$j ]=="user")
			{
				$arrLimiting=Array("is_office"=>0, "office_login_id"=>$intOfficeUserID);
				$strPreferredNameField="firstname lastname";
			}
			
			$arrOut[$j]=answerformwrap($answer, $intQuestionID, $i,$arrDataTypes[$j], $arrFTables[$j ], false, $arrWidths[$j], $arrHeights[$j], $intOfficeUserID,  false, $strTable, $arrLimiting, $strPreferredNameField);
		

 			// answerformwrap($answer, $x, $y, $sql_data_type, $foreigntable, $bwlHidden=false, $width=20, $height=1, $intUserID="", $bwlNoForm=false,  $strMappingTableAvoidList="", $arrLimiting="")
		
		}
		$addlink="<a id=\"idaddfield-" .  $i.  "\" href=\"javascript: addQrow('addfield-" .$i. "' )\"><img  onmouseover=\"glow(this, 'on')\"  onmouseout=\"glow(this, 'off')\" border=\"0\" src=\"" . imagepath . "/insert_" .$listaddside . ".gif\"></a>";
		
		//$arrOut[count($arrOut)]=$addlink. HiddenInputs(array("group_id[]"=>$arrParam[$i][0], "swapfieldd-" . $i =>""),"");
		
		
		
		
		$strAddFullLink=$addlink. HiddenInputs(array("group_id[]"=>$arrParam[$i][0], "swapfieldd-" . $i =>""),"");
	 	if($listaddside=="left")
		{
			$arrOut= InsertAtArrayPosOne($arrOut,$strAddFullLink);
		}
		else
		{
		
			$arrOut[count($arrOut)]=$strAddFullLink;
		}
		
		
		
		$dataHTML.=call_user_func_array('htmlrow', $arrOut);
	
	}
 	//echo $listaddside;
	$arrParam[count($arrParam)]=$addlink. HiddenInputs(array("group_id[]"=>$sort_id));
	//$arrLabels[count($arrLabels)]=$firstaddlink;
	
	
 
	if($listaddside=="left")
	{
		$arrLabels= InsertAtArrayPosOne($arrLabels,$firstaddlink);
		 
	}
	else
	{
			
		$arrLabels[count($arrLabels)]=$firstaddlink;
	}
	
	
	
	$xlist = RemoveEndCharactersIfMatch($questionids, " ");
	$xlist=str_replace(" ", "|", $xlist);

	$out.=call_user_func_array('htmlrow', $arrLabels);
	//$dataHTML.=call_user_func_array('htmlrow', $arrParam);
 	$out.=$dataHTML;
	$out.=HiddenInputs(array("mode"=>"save",  "xlist"=>$xlist, "db" =>$strDatabase, "fieldcount"=>$i, "delete"=>"", "arrfieldnames"=>serialize($arrFieldNamesIn) ));
	//echo count($arrLabels);
	//GenericInput($name, $default, $bwlChecked=false, $onClick="",  $strStyle="", $strClass="", $type="submit", $size="", $strStrayJS="", $height=1, $bwlAutocomplete=false)
	$out.="<tr class='bgclassother'><td  align=\"left\" colspan=\"" . intval(count($arrLabels)-0). "\"> " . MASelectedTools(true, true, "png", "style='margin-top: 0px;'"). " " . GenericInput(qpre . "submit", "SAVE", false, "", "", "genericbutton", "submit")  . " </td></tr> \n";
	$out.="</table>\n\n";
 
	$out.= "</form>\n";
	
 	$out.= CalSearchForm($strDatabase, $strPHP, $strSearchTerm, $strSearchType);
	$out.= "\n<script>	setTimeout(\"colorbg('ffffff')\", 100);addQrowAtEnd(''); </script>\n";
	
	//echo "<a href=\"javascript:domdumpwindow()\">dump</a>";
	
	return $out;
}


function MultipleEventListReadonly($strDatabase, $datecode, $intUserID, $strNoUserMessage="", $strSearchTerm="", $strSearchType="", $bwlSuppressSearch=false,  $strFTables="", $layoutwidth="100%", $bwlNoForm=true)
{
 
	if($intUserID!="")
	{
		$sql=conDB();
		$strTable="personal_calendar_event";
		$out="";
		$dataHTML="";
		$intFieldOut=1;
		$rowOut=0;
		$arrParam=Array();
		$arrLabels=Array();
		$arrFtables=Array();
		$questionids="";
		$sql_data_types="";
		$strFormWidths="";
		$strFormHeights="";
		$xlist="";
		$intWidth=15;
		
		$intTextHeight=2;
		$strClass1="firstrow";
		$strClass2="secondrow";
		$strThisClass="";
		
	 
		$arrLabels[0]="subtleheader";
		if (listaddside=="left" )
		{
			$listaddside="left";
		}
		$arrFieldNames=Array();
	 
		$arrFTables=explode(" ", $strFTables);
		$records=TableExplain($strDatabase, $strTable);
		foreach ($records as $k => $v )
		{
			//echo $strFTable . "-";
			foreach($arrFTables as $strFTable)
			{
				if ($v["Field"]==$strFTable . "_id"  )
				{
					$v["Type"]="varchar"; //yeah, right!
					$v["Field"]=$strFTable;
				}
				else if( $v["Field"]=="recurrence_id")
				{
					//echo "#";
					$v["Type"]="varchar"; //yeah, right!
					$v["Field"]="recurrence";
				}
			
			}
			
		 	if ((contains($v["Type"], "varchar") || $v["Type"]=="text")   )
			{
				$question=$v["Field"];
				$question_id=$intFieldOut;
				$questionids.=" " . $question_id;
				$intHeight=1;
	
	

	
	
	
				if($v["Type"]=="text"  )
				{
					$intHeight=$intTextHeight;
					$strWidth=27;
				}
				else
				{
					$strWidth=(TypeParse($v["Type"], 1)); //$intWidth;
					if ($strWidth>$intWidth)
					{
						$strWidth=$intWidth;
					}
				}
				$strFormWidths.=" " . $strWidth;
				$strFormHeights.=" " . $intHeight;
				$arrFieldNames[$intFieldOut]=$question;
				if ($v["Field"]=="datecode")
				{
					
					$question="date";
				}
				
				foreach($arrFTables as $strFTable)
				{
					if ($v["Field"]==$strFTable)
					{
						$foreigntable=$strFTable;
					}
					else if ($v["Field"]=="recurrence")
					{
						
						$foreigntable="recurrence";
					}
				}
				$strAddFullLink="<label>" . DisplayLabel($question) . "</label>" . answerformwrap("", $question_id, 0, $sql_data_type, $foreigntable, true, $strWidth, $intHeight, $intUserID, $bwlNoForm,  $strTable);

				$arrLabels[$intFieldOut]=$strAddFullLink;
				
				
				$intFieldOut++;
			}
		}
		
 
	 
		//$strSQL="SELECT * FROM " . $strDatabase . ".questionnaire_answer a  WHERE a.questionnaire_id=" .$intThisQuestionnaireID . " AND user_id=" . $intUserID . " ORDER BY answer_group_id ASC";
		if($strSearchTerm!="")
		{
			$searchstring ="";
			if ($strSearchType=="")
			{
				$searchstring=" (time LIKE  '%" .  $strSearchTerm . "' OR name LIKE  '%" .  $strSearchTerm . "%' OR type LIKE  '%" .  $strSearchTerm . "%' OR notes LIKE  '%" .  $strSearchTerm . "%') ";
			
			}
			else
			{
				$searchstring=" " . $strSearchType . " LIKE '%" .  $strSearchTerm . "%'  ";
			
			}
	
			$strWhere=" WHERE " .$searchstring . " AND user_id=" . $intUserID . " ORDER BY sort_id ASC";
		}
		else
		{
			$strWhere=" WHERE  datecode=" .$datecode . " AND user_id=" . $intUserID . " ORDER BY sort_id ASC";
		}
		//$strSQL=FleshedOutFKSelect($strDatabase, $strTable, $strWhere,  $arrDesc, "user", false);
		$strSQL=FleshedOutFKSelect($strDatabase, $strTable, $additionalClauses,  $arrDesc, "", true, false, Array("office_login_id"=>"office_name", "client_login_id"=>"lastname firstname"));
		//echo "<b>eventsql:</b> " . $strSQL . "<P>";
		$records = $sql->query($strSQL);
		//echo count($records);
	 
		$out.= "<form method=\"post\" name=\"BForm\" action=\"" .  $strPHP . "\">\n";
		$out.= "<table  width='100%' border=\"0\" cellspacing=\"1\" cellpadding=\"2\" class=\"" .$strLineClass  . "\" width=\"" . $layoutwidth . "\">\n";
		//$arrParam[0]="";  //because of the way htmlrow works, this is to set the class of the display of that row
	
		$firstaddlink="<a id=\"idaddfield-0\" href=\"javascript: addQrow('addfield-0' )\"><img  onmouseover=\"glow(this, 'on')\"  onmouseout=\"glow(this, 'off')\" border=\"0\" src=\"" . imagepath . "/insert_" .$listaddside . ".gif\"></a>".HiddenInputs(array("group_id[]"=>"", "swapfieldd-0" =>""),"");
		$bwlNoRecords=false;
		if (count($records)<1)
		{
			$bwlNoRecords=true;
		}
		foreach($records as $record)
		{
			$sort_id=$record["sort_id"];
			$arrParam[$sort_id][0]=$record[$sort_id];
			//echo count($arrFieldNames) . "<br>";
			for($i=1; $i<=count($arrFieldNames); $i++)
			{
				//echo $arrFieldNames[$i] . "<br>";
				if($arrFieldNames[$i]=="practitioner")
				{
					$arrFieldNames[$i]=  $arrFieldNames[$i] . "_name";
				
				}
				//echo $arrFieldNames[$i] . "<br>";
				$arrParam[$sort_id][$i]=$record[$arrFieldNames[$i]];
			}
			
			$foreigntable="";
			//echo $arrFieldNames[$i] . "<br>";

			$arrFtables[$intFieldOut]=$foreigntable;
			
			//echo $sort_id . "<br>";
		}
	
 
		$arrQuestionIDs=explode(" ", $questionids);
		$arrDataTypes=explode(" ",$sql_data_types);
		$arrWidths=explode(" ",$strFormWidths);
		$arrHeights=explode(" ",$strFormHeights);
 
		for($i=1; $i<=$sort_id; $i++)
		{
			
			//echo "count:" .  count($arrParam[$i]) . "<br>";
			//echo count($arrParam[$sort_id]) . "=isarray<br>";
		 	$arrOut=Array();
			$strThisClass=Alternate($strClass1, $strClass2, $strThisClass);
			$arrOut[0]="*" . $strThisClass;
			
			for($j=1; $j<count($arrQuestionIDs) ; $j++)
			{
				
				$intQuestionID=$arrQuestionIDs[$j];
				//echo $intQuestionID . "=questionid<br>";
				$answer=$arrParam[$i][$intQuestionID];
				
				$foreigntable="";
				foreach($arrFTables as $strFTable)
				{
					if ($arrFieldNames[$j]==$strFTable)
					{
						$foreigntable=$strFTable;
					}
				}
			
				if ($arrFieldNames[$j]=="datecode")
				{
					//echo $answer . "=<br>";
					$datecode=$answer;
					$answer=date("m-d-y", makedate($answer));
					$answer="<a class=\"text_11b2\" target=\"_top\" href=\"calendar.php?datecode=" . $datecode . "\">" . $answer . "</a>";
					$arrOut[$j]=$answer;
					
				}
				else
				{
					$arrOut[$j]=answerformwrap($answer, $intQuestionID, $i,$arrDataTypes[$j], "", false, $arrWidths[$j], $arrHeights[$j], $intUserID, $bwlNoForm,   $strTable);
	 			}
			
			}
			//$addlink="";//"<a id=\"idaddfield-" .  $i.  "\" href=\"javascript: addQrow('addfield-" .$i. "' )\"><img  onmouseover=\"glow(this, 'on')\"  onmouseout=\"glow(this, 'off')\" border=\"0\" src=\"" . imagepath . "/insert_" .$listaddside . ".gif\"></a>";
			
			//$arrOut[count($arrOut)]=$addlink. HiddenInputs(array("group_id[]"=>$arrParam[$i][0], "swapfieldd-" . $i =>""),"");
			if($datecode!="")
			{
				$dataHTML.=call_user_func_array('htmlrow', $arrOut);
			}
		
		}
		$strAddFullLink=$addlink. HiddenInputs(array("group_id[]"=>$sort_id));
	 	if($listaddside=="left")
		{
			$arrOut= InsertAtArrayPosOne($arrOut,$strAddFullLink);
		}
		else
		{
		
			$arrOut[count($arrOut)]=$strAddFullLink;
		}
		//$arrLabels[count($arrLabels)]=$firstaddlink;
		$xlist = RemoveEndCharactersIfMatch($questionids, " ");
		$xlist=str_replace(" ", "|", $xlist);
	
		$out.=call_user_func_array('htmlrow', $arrLabels);
		//$dataHTML.=call_user_func_array('htmlrow', $arrParam);
	 	$out.=$dataHTML;
		$out.=HiddenInputs(array("mode"=>"save",  "xlist"=>$xlist, "db" =>$strDatabase, "fieldcount"=>$i, "delete"=>"" ));
		//echo count($arrLabels);
		//$out.="<tr><td  align=\"left\" colspan=\"" . intval(count($arrLabels)-2) . "\">" . MASelectedTools(). "</td><td align=\"right\" >" .  GenericInput(qpre . "submit", "Save") . "</td></tr>\n";
		$out.="</table>\n\n";
		
		$out.= "</form>\n";
		
		if ($bwlNoRecords)
		{
			if($strSearchTerm=="")
			{
				$out="<span class=\"postbody\">There is nothing in My Calendar for today.</span>";
			}
			else
			{
				$out="<span class=\"postbody\">No match was found for your search.</span>";
			}
		
		}
		if(!$bwlSuppressSearch)
		{
			$out.= CalSearchForm($strDatabase, $strPHP, $strSearchTerm, $strSearchType);
		}
	 	$out= "<script src=\"tf_multipleanswer.js\"><!-- --></script>\n" . $out;
		$out= "<script src=\"tf.js\"><!-- --></script>\n" . $out;
	}
	else
	{
		$out=$strNoUserMessage;
	}
	//$out.= "\n<script>	setTimeout(\"colorbg('ffffff')\", 100)</script>\n";
	//echo "<a href=\"javascript:domdumpwindow()\">dump</a>";
	return $out;
}


function SaveEventList($strDatabase, $intOfficeUserID, $datecode, $strFTables)
{
	$sql=conDB();
	$bwlFiguredOutMeta=false;
 	$strTable="personal_calendar_event";
	//$answer_group_id=$_REQUEST[qpre . "group_id"];
	$fieldcount=$_REQUEST[qpre . "fieldcount"];
	$xlist=$_REQUEST[qpre . "xlist"];
	//echo $_REQUEST[qpre . "arrfieldnames"];
	$preunserialized=$_REQUEST[qpre . "arrfieldnames"];
	if(contains($preunserialized, "\\\""))//some default server settings mangle my serialized array
	{
		$preunserialized=str_replace("\\\"", chr(34), $preunserialized);
	}
	$arrFieldNamesIn=unserialize($preunserialized);
	//echo $xlist . "<br>";
 	//$arrFTables=explode(" ", $strFTables);
 	$arrX=explode("|", $xlist);
	$strGroupIDs="";
	$arrFieldNames=Array();
	$arrSlurpedData=Array();
	//echo $fieldcount . ": fieldcount<br>";
	//echo $fieldcount;
	if($fieldcount>0)
	{
		$strSQL="SELECT MAX(sort_id) as mgid FROM " . $strDatabase . "." . $strTable . " WHERE datecode='" . $datecode . "' AND office_login_id=" .$intOfficeUserID;
		$records = $sql->query($strSQL);
		$record=$records[0];
		$intMaxGroupID=$record["mgid"] + 1;
		//echo "<br>mgid:" . $intMaxGroupID   . " returned:" . $fieldcount;
		
		//if we've deleted rows we need to count up through the surplus still in the db and throw them out
		
		//echo $intMaxGroupID . " " . $fieldcount . "<br>";
		if($intMaxGroupID>$fieldcount-1)
		{
			for($i=$fieldcount-1; $i<$intMaxGroupID; $i++)
			{
				$strSQL="DELETE FROM " . $strDatabase . "." . $strTable . " WHERE datecode='" . $datecode . "' AND office_login_id=" .$intOfficeUserID . " AND sort_id='" . $i . "'";
				//echo "<br>" . $strSQL . "<br>";
				if(CanChange())
				{
					$records = $sql->query($strSQL);
				}
				else
				{
					$errors.=  "Database is read-only.<br/>";
				}
			
				$records = $sql->query($strSQL);
			}
		}
		//echo "-" . !is_array($arrFieldNamesIn) . "-";
		if(!is_array($arrFieldNamesIn))
		{
			//echo "**";
			$records=TableExplain($strDatabase, $strTable);
			$intFieldNames=1;
			foreach ($records as $k => $v )
			{
				//echo ReturnNonIDPartOfName( $v["Field"]) . "<br>"; //" ". $strFTables .  " " . inList($strFTables,ReturnNonIDPartOfName( $v["Field"])) . "<br>";
			 	if ((contains($v["Type"], "varchar") || $v["Type"]=="text"  || $v["Field"]=="recurrence_id"  || inList($strFTables,RemoveEndCharactersIfMatch(ReturnNonIDPartOfName( $v["Field"]), " ")))  && $v["Field"]!="datecode" )
				{
					//echo $v["Field"] . "<br>";
					$question=$v["Field"];
					$arrFieldNames[$intFieldNames]=$question;
					$arrSlurpedData[$question]="";
					$intFieldNames++;
				}
			}
		}
		else
		{
		
			//echo "%%%%%%%%%%";
			$intFieldOut=1;//can't begin with 1 because that's the class for the row!!
	
			foreach($arrFieldNamesIn as $question=>$v)
			{
				//echo  $question . "..<br>";
				$questionids.=" " . intval($intFieldOut-1);
				$arrFieldNames[$intFieldOut-1]=$question;
		 		$intFieldOut++;	
			}
		}
		//foreach($_REQUEST as $k=>$v)
		{
			//echo $k . " " . $v . ":<BR>";
		}
		for($intY=1; $intY< $fieldcount+1; $intY++)
		{
			//echo count($arrX) . "==<br>";
			//echo qpre . "grid" . "-" . $intX . "-" .  $intY  . ":" . $v . "<br>";
			
			// echo $v ."<br>";

			//echo $fieldcount . "<br>";
			$allempty=true;
			for($j=0; $j<count($arrX); $j++)
			{
			
				$intX=$arrX[$j];
				
				if($intX!="")
				{
					$v= $_REQUEST[qpre . "grid" . "-" . $intX . "-" .  $intY ];
					//echo qpre . "grid" . "-" . $intX . "-" .  $intY  . "<BR>";
					//echo $arrFieldNames[intval($j)+1] . "++" . $v . "<br>";
				
					
					
					
					$arrSlurpedData[$arrFieldNames[intval($j)]]=$v;
					if($v!="")
					{
						$allempty=false;
					}
		 
				  
					//$v=str_replace("\\", "", $v);
					//echo $v . "<br>";
				}
			}
			//echo $type . " " . $event_name  . " " . $note . "<br>";
			//echo !addBwls($type=="", $event_name=="",$notes=="" ) . "<br>";
			//echo $intY . " " .  $j . " update/insert<br>";
			
			if( !$allempty)
			{
	 			//echo "update/insert<br>";
				//echo $intY . " " . $intOfficeUserID .  "<BR>";
				//echo  $intY ."-" . var_dump($arrSlurpedData) . "<BR>";
				UpdateOrInsert($strDatabase, $strTable, Array("office_login_id"=>$intOfficeUserID,"datecode"=>$datecode, "sort_id"=>$intY), $arrSlurpedData, false);
				$event_name="";
				$type="";
				$notes="";
			}
	
		}

	}
	echo "<script>if(top.calendardataframe){top.calendardataframe.location.href='calendardata.php?datecode=" . $datecode . "&rnd=" . time() . "'}</script>";
}


function DisplayLabel($strIn)
{
	//echo "." . $strIn . ".<br>";
	$out=$strIn;
	if(str_replace("_user_id", "", $out)!="")
	{
		$out=str_replace("_user_id", "", $out);
	}
	if(str_replace("_id", "", $out)!="")
	{
		//echo "*";
		$out=str_replace("_id", "", $out);
	}
	else
	{
		$out=str_replace("_", " ", $out);
	}
	// echo "." . $out . ".<br>";
	return $out;

}


function CalSearchForm($strDatabase, $strPHP, $strSearchTerm, $strTypeDefault)
{
	$out="";
	$out.= "<form method=\"post\" name=\"SForm\" action=\"" .  $strPHP . "\" target=\"dayframe\">\n";
	$out.= "<table border=\"0\" cellspacing=\"1\" cellpadding=\"2\" class=\"" .$strLineClass  . "\" width=\"100%\">\n";
	$out.= "<tr>\n";
	$out.= "<td>\n";
	$out.=GenericInput(qpre . "searchterm", $strSearchTerm, false, "", "", "", "text" , 22, "", 1);
	$out.= "</td>\n";
	$out.= "<td>\n";
	$strConfig="time|time-practitioner|cc" . strtolower(professionaltype) . "-type|type-notes|notes";
	$out.=str_replace("-none-", "any",GenericDataPulldown($strConfig, 0, 1, qpre . "searchtype", $strTypeDefault, $strPHP, "", "", false));
	$out.= "</td>\n";
	$out.= "<td>\n";
	$out.=GenericInput(qpre . "searchbutton", "Search Calendar", false, "", "", "", "submit" , "", "", "");
	$out.= "</td>\n";

	$out.= "</tr>\n";
	$out.= "</table>\n";
	$out.= "</form>";
	return $out;
}



/* US Holiday Calculations in PHP
 * Version 1.02
 * by Dan Kaplan <design@abledesign.com>
 * Last Modified: April 15, 2001
 * ------------------------------------------------------------------------
 * The holiday calculations on this page were assembled for
 * use in MyCalendar:  http://abledesign.com/programs/MyCalendar/
 * 
 * USE THIS LIBRARY AT YOUR OWN RISK; no warranties are expressed or
 * implied. You may modify the file however you see fit, so long as
 * you retain this header information and any credits to other sources
 * throughout the file.  If you make any modifications or improvements,
 * please send them via email to Dan Kaplan <design@abledesign.com>.
 * ------------------------------------------------------------------------
*/



function format_date($year, $month, $day) 
{
    // pad single digit months/days with a leading zero for consistency (aesthetics)
    // and format the date as desired: YYYY-MM-DD by default

    if (strlen($month) == 1) 
	{
        $month = "0". $month;
    }
    if (strlen($day) == 1) 
	{
        $day = "0". $day;
    }
    $date = $year ."-". $month ."-". $day;
    return $date;
}

// the following function get_holiday() is based on the work done by
// Marcos J. Montes: http://www.smart.net/~mmontes/ushols.html
//
// if $week is not passed in, then we are checking for the last week of the month
function get_holiday($year, $month, $day_of_week, $week="") 
{
    if ( (($week != "") && (($week > 5) || ($week < 1))) || ($day_of_week > 6) || ($day_of_week < 0) ) 
	{
        // $day_of_week must be between 0 and 6 (Sun=0, ... Sat=6); $week must be between 1 and 5
        return FALSE;
    } 
	else 
	{
        if (!$week || ($week == "")) 
		{
            $lastday = date("t", mktime(0,0,0,$month,1,$year));
            $temp = (date("w",mktime(0,0,0,$month,$lastday,$year)) - $day_of_week) % 7;
        } 
		else 
		{
            $temp = ($day_of_week - date("w",mktime(0,0,0,$month,1,$year))) % 7;
        }
        
        if ($temp < 0) {
            $temp += 7;
        }

        if (!$week || ($week == "")) 
		{
            $day = $lastday - $temp;
        } 
		else 
		{
            $day = (7 * $week) - 6 + $temp;
        }

        return format_date($year, $month, $day);
    }
}

function observed_day($year, $month, $day) 
{
    // sat -> fri & sun -> mon, any exceptions?
    //
    // should check $lastday for bumping forward and $firstday for bumping back,
    // although New Year's & Easter look to be the only holidays that potentially
    // move to a different month, and both are accounted for.

    $dow = date("w", mktime(0, 0, 0, $month, $day, $year));
    
    if ($dow == 0) 
	{
        $dow = $day + 1;
    }
	elseif ($dow == 6) 
	{
        if (($month == 1) && ($day == 1)) 
		{    // New Year's on a Saturday
            $year--;
            $month = 12;
            $dow = 31;
        } 
		else 
		{
            $dow = $day - 1;
        }
    } 
	else 
	{
        $dow = $day;
    }

    return format_date($year, $month, $dow);
}

function calculate_easter($y) 
{
    // In the text below, 'intval($var1/$var2)' represents an integer division neglecting
    // the remainder, while % is division keeping only the remainder. So 30/7=4, and 30%7=2
    //
    // This algorithm is from Practical Astronomy With Your Calculator, 2nd Edition by Peter
    // Duffett-Smith. It was originally from Butcher's Ecclesiastical Calendar, published in
    // 1876. This algorithm has also been published in the 1922 book General Astronomy by
    // Spencer Jones; in The Journal of the British Astronomical Association (Vol.88, page
    // 91, December 1977); and in Astronomical Algorithms (1991) by Jean Meeus. 
    $a = $y%19;
    $b = intval($y/100);
    $c = $y%100;
    $d = intval($b/4);
    $e = $b%4;
    $f = intval(($b+8)/25);
    $g = intval(($b-$f+1)/3);
    $h = (19*$a+$b-$d-$g+15)%30;
    $i = intval($c/4);
    $k = $c%4;
    $l = (32+2*$e+2*$i-$h-$k)%7;
    $m = intval(($a+11*$h+22*$l)/451);
    $p = ($h+$l-7*$m+114)%31;
    $EasterMonth = intval(($h+$l-7*$m+114)/31);    // [3 = March, 4 = April]
    $EasterDay = $p+1;    // (day in Easter Month)
    
    return format_date($y, $EasterMonth, $EasterDay);
}

/////////////////////////////////////////////////////////////////////////////
// end of calculation functions; place the dates you wish to calculate below
/////////////////////////////////////////////////////////////////////////////

function NextPossibleDateCode($dtmIn, $typeofskip="")
{

	return  makedatecode(NextPossibleDay(makedate($dtmIn), $typeofskip));
}

function NextPossibleDay($dtmIn, $typeofskip="")
//returns the next possible day for an appointment, avoiding either weekends, holidays, or both
{
	$scale=WhatHoliday($dtmIn, "scale");
	$count=0;
	while($scale!=7  && $scale!=4 && $scale!=3 && $count<20)
	{
		//echo makedatecode($dtmIn) . " " . $scale .  "\n";
		$dtmIn=adddaystodate($dtmIn,1);
		$scale=WhatHoliday($dtmIn, "scale");
		$count++;
	}
	return $dtmIn;

}

function WhatHoliday($dtmIn, $mode)
{
	//takes a date and tells whether or not it's a holiday and how big of a holiday it is
	$datearray=getdate($dtmIn);
	$month_in=$datearray["mon"];
	$year_in=$datearray["year"];
	$day_in=$datearray["mday"];
	$weekday=$datearray["wday"];
	$thisformatteddate=format_date($year_in, $month_in, $day_in);
	
	$thanksgiving=strtotime(get_holiday($year_in, 11, 4, 4));
	$dayafterthanksgiving=adddaystodate($thanksgiving,1);
	$tdadatearray=getdate($dayafterthanksgiving);
	$tdaformatted=format_date($tdadatearray["year"],$tdadatearray["mon"],$tdadatearray["mday"]);
	// Gregorian Calendar = 1583 or later
	if ($year_in || ($year_in < 1583) || ($year_in > 4099)) 
	{
		$year_in = date("Y",time());    // use the current year if nothing is specified
	}
	
	 
	if ($thisformatteddate==format_date($year_in, 1, 1))
	{
		$out="New Year's Day|1";
	}
 	else if ($thisformatteddate==get_holiday($year_in, 1, 1, 3))
	{
		$out="Martin Luther King Day|3";
	}
  	else if ($thisformatteddate==format_date($year_in, 2, 14))
	{
		$out="Valentine's Day|4";
	}
   	else if ($thisformatteddate==get_holiday($year_in, 2, 1, 3))
	{
		$out="President's Day|3";
	}
    else if ($thisformatteddate==format_date($year_in, 3, 17))
	{
		$out="St. Patrick's Day|4";
	}
    else if ($thisformatteddate==calculate_easter($year_in))
	{
		$out="Easter|1";
	}
    else if ($thisformatteddate==format_date($year_in, 5, 5))
	{
		$out="Cinco De Mayo|4";
	}
    else if ($thisformatteddate==get_holiday($year_in, 5, 1))
	{
		$out="Memorial Day|3";
	}
    else if ($thisformatteddate==format_date($year_in, 7, 4))
	{
		$out="Independence Day|1";
	}
    else if ($thisformatteddate==get_holiday($year_in, 9, 1, 1))
	{
		$out="Labor Day|3";
	}
    else if ($thisformatteddate==get_holiday($year_in, 10, 1, 2))
	{
		$out="Columbus Day|3";
	}
    else if ($thisformatteddate==format_date($year_in, 10, 31))
	{
		$out="Halloween|4";
	}
    else if ($thisformatteddate==get_holiday($year_in, 11, 4, 4))
	{
		$out="Thanksgiving|1";
	}
    else if ($thisformatteddate==$tdaformatted)
	{
		$out="Day After Thanksgiving|2";
	}
    else if ($thisformatteddate==format_date($year_in, 12, 25))
	{
		$out="Christmas|1";
	}
 	else if ($weekday==0)
	{
		$out="Sunday|5";
	}
 	else if ($weekday==6)
	{
		$out="Saturday|6";
	}
	else
	{
		$out="|7";
	}
	$arrOut=explode("|", $out);
	if($mode==""  || $mode=="scale")
	{
		return $arrOut[1];
	}
	else if ($mode=="name")
	{
		return $arrOut[0];
	}
	else
	{
		return $arrOut;
	}
	
}

 






function WeekDisplay($dtmStart, $intOfficeUserID, $intPhysicialID)
{

	




}








include "tf_functions_color_math.php";
?>