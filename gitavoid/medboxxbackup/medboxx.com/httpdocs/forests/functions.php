<?
///////////////////////////////////////////////
//PHP functions for Randomly Ever After
//begun in the Summer of 2001 --
//greatly expanded in the Fall and Winter of 2003
//Many of these have origins in old ASP functions
//for Vodkatea and Bathtubgirl
//though some are original or I developed them in
//the PHP world in places like CaSanctuary.org
//or Jonbowermaster.com
////////////////////////////////////////////////

function thisfilename()
{
	//returns the name of the file we are on, with no path
	$arrfilename=split("/",$GLOBALS["PHP_SELF"]);
	$strfilename=$arrfilename[count($arrfilename)-1];
	return($strfilename);
}


function datecodetourl($datecode)
{
	//given a six character code of the form YYMMDD, it returns the relative URL of its location in the file system
 	$out="";
	$bwlBypass=false;
	$upper=substr($datecode, 0, 4);
	$extension="php";
	$daycode=substr($datecode, 4, 2);
	$monthcode=intval(substr($datecode, 2, 2));
	$yearcode=substr($datecode, 0, 2);
	$arrMusingsMonths=array("", "jan", "feb", "mar", "apr", "may", "jun", "jul", "aug", "sep", "oct", "nov", "dec");
	//echo $datecode . "<br>" ;

	if ($datecode>"961130" and $datecode<"980923") //conventional musings entry
	{
		//echo("!!");
		
		$extension="htm";
		$monthstring=$arrMusingsMonths[$monthcode];
		$out="../musings/" . $monthstring . $yearcode . "/" . $daycode . ".htm";
	
	}
	elseif ($datecode<"961201" and $datecode<"980923" and $datecode >todaydatecode()) //all-in-one musings entries
	{
		if ($datecode>"960831" and $datecode<"961001") //fucked up september case
		{
			$out="../musings/sept96.htm#" . $daycode . ".";
			$extension="";
		}
		else if($datecode>"960730")
		{
			$monthstring=$arrMusingsMonths[$monthcode];
			$extension="";
			$out="../musings/" . $monthstring . "96.htm#" . $daycode;
		}
	}
	else //randomly every after, either php or htm ending
	{
		$out = $upper . "/" . $datecode . "." ;
	}
	if (true)
	{
		if (file_exists($out . "htm")) //i'll use whichever ending is available, or none.
		{
			$out=$out . "htm";
		}
		else if  (file_exists($out . "php"))
		{
			$out=$out. "php";
		}
		
		else if  (file_exists($out ))
		{
			$out=$out;
		}
		else //return nothing if the file doesn't exist.  we do not create entry files in this system; those are uploaded
		{
			$out="";
		}
	}
	return($out);

}




function monthofRanArticleList($datecode)
{
	//give me an unformatted list of linked numbers - not a true calendar
	$monthpart=substr($datecode,0,4);
	$out= filereadcache("m" . $monthpart, calculateexpiration($datecode));
	//$out="";
	if ($out=="")
		{
		$count=0;
		$poo=0;
		//first day of next month later followed by one day earlier
		//$datecode=firstofnextmonth($datecode);
		//$datecode=earlierday($datecode);
		
		$datecode=$monthpart."01";
		$datearray=getdate(makedate($datecode));
		$month=$datearray["month"];
		$year=$datearray["year"];
		$out=$out . "<b>" . $month . " <a href=dyears.php?" . $datecode . ">" . $year . "</a></b><p>";
		while (substr($datecode,0,4)==$monthpart and $poo<70)
		{
			
			$url=datecodetourl($datecode);
			$day=substr($datecode, 4,2);
			//echo($url . "<br>");
			if (file_exists($url) and strpos($url, "#")<1)
			{
				
				$handle=fopen ($url, "r");
				$content=fread($handle, filesize($url));
				fclose($handle);
				$title=parseRanTitle($content);
				if (substr($title, 0, 1)!="*") //do not show asterisk-preceded titles
				{
					$out=$out . $day . ": <a href=i.php?" . $datecode . " target=_top><b>" . $title . "</b></a>" . chr(13);
					$description=parseRanDescription($content);
					
					$out=$out . " - " . $description . "<br>" . chr(13);
				}
				
				$count++;
			}
			$datecode=laterday($datecode);
			$poo++;	
		}
		
		filewritecache("m".$monthpart, $out);
	}
	return($out);

}





function recentRanArticleList($intNumber, $intNumberOfDescriptions)
{
	//$intNumber recent ran articles, the first $intNumberOfDescriptions having descriptions too
	$todaydatecode=todaydatecode();
	$count=0;
	$poo=0;
	$out="";
	while ($count<$intNumber && $poo<70)
	{
		$url=datecodetourl($todaydatecode);
		if (file_exists($url))
		{
			$handle=fopen ($url, "r");
			$content=fread($handle, filesize($url));
			fclose($handle);
			$title=parseRanTitle($content);
			if (substr($title, 0, 1)!="*") //do not show asterisk-preceded titles
			{
				$out=$out . "<a href=i.php?" . $todaydatecode . " target=_top><b>" . $title . "</b></a>";
				if ($intNumberOfDescriptions>0)
				{
					$description=parseRanDescription($content);
					$out=$out . " - " . $description . "<br>";
				
					$intNumberOfDescriptions--;
				}
				else
				{
					$out=$out . "<br>";
				}
			}
			$count++;
			
			
		}
		$todaydatecode=earlierday($todaydatecode);
		$poo++;
	}
	return($out);

}

function parseContent($strIn)
{
	if (strpos($strIn, "$" . "articletitle=" . chr(34))>0)
	{
			$content=parseBetween($strIn,  "<" . "?include(\"../header.php\")" . "?" . ">", "<" . "?include(\"../footer.php\")?" . ">");
	}
	else
	{
			$content=parseBetween($strIn,  "&nbsp;&nbsp;&nbsp;<p>
<blockquote>", "<p>
</blockquote>
</font><p>
<center>");
	}
	return($content);
}

function parseRanLatitude($strIn)
{
	$rd=parseBetween($strIn,  "$" . "latitude=" . chr(34),  chr(34) .";");
	return($rd);
}

function parseRanLongitude($strIn)
{
	$rd=parseBetween($strIn,  "$" . "longitude=" . chr(34),  chr(34) .";");
	return($rd);
}

function parseRanDescription($strIn)
{
	//parses meta description from rea or musings pages
	if (strpos($strIn, "$" . "articletitle=" . chr(34))>0)
		{
			$rd=parseBetween($strIn,  "$" . "articledescription=" . chr(34),  chr(34) .";");
		}
	else
		{
			$rd=parseBetween($strIn, "<meta name=\"description\" content=\"","\">");
		}
	return($rd);
}

function parseRanTitle($strIn)
//effectively parses either a randomly ever after title or a musings title from html content $strIn. Parses title of most web pages actually.
{
	if (strpos($strIn, "$" . "articletitle=" . chr(34))>0)
		{
			$title=parseBetween($strIn, "$" . "articletitle=" . chr(34), chr(34) .";");
		}
	else
		{
			$title=parseSimpleNode($strIn, "title");
		}
	return($title);
}

function parseSimpleNode($strIn, $strNode)
//return the content of a simple non-parameterized, non-nested node
{
	return(parseBetween($strIn, "<" . $strNode . ">", "</" . $strNode . ">"));
}


function parseBetween($strIn, $strStart, $strEnd)
{
	//a great function for returning the string between two known strings ($strStart, $strEnd) within $strIn
	
	$pos1 = strpos($strIn, $strStart) + strlen($strStart);
	//echo ($strEnd . "-----". $pos1. "-----". $strIn . "****<P>");
	//if (strlen($strIn)<$pos1)
	//{
	//	$pos1=0;
	//}
	$pos2 = strpos($strIn, $strEnd, $pos1);
	//echo "<p>=" . $pos1 . " " . $pos2 . "=<p>";
	
	$found=substr($strIn, $pos1, ($pos2-$pos1));
	return($found);
}

function yearlinks($datecode)
{
	//the months in a year, old method (still used in thin month sliver)
	$datearray=getdate(makedate($datecode));
	$year=$datearray["year"];
	$earlieryear=$year-1;
	$lateryear=$year+1;
	$extension=decideextension($earlieryear);
	$target="";
	$base="days.php?";
	$thisbase="years.php";
		
	if ($extension=="htm")
		{
		 $earlierurl=$earlieryear . "." . $extension;
		}
	else
		{
		 $earlierurl= $thisbase . "?" . substr($earlieryear,2,2) . "0101";   
		}
	$laterurl=$thisbase . "?" . substr($lateryear,2,2) . "0101";   
	$startdate= substr($year,2,2) . "0101";
 
	$out="<h2>" . $year . "</h2>";
	$t=2;
	while  ($t<14)
	{
		$datearray=getdate(makedate($startdate));
		$month=str_pad($datearray["mon"], 2, '0', STR_PAD_LEFT);
		$monthname=$datearray["month"];
		$extension=decideextension($startdate);
		$monthpart=substr($year,2,2) . $month;
		//echo(todaydatecode() . " " . $monthpart . "01" . "<br>");
		if ($monthpart . "01"<=todaydatecode() or $monthpart . "01">"960730" )
		{
			if ($extension=="htm" )
			{
				
				$out=$out . "<a href=" .   $monthpart   . "/days.htm" . $target . ">" . $monthname . "</a><br>";
			
			}
			else
			{
				$out=$out . "<a href=" . $base . $monthpart   ."01" . $target . ">" . $monthname. "</a><br>";
			}
		}
		else
		{
			$out=$out .  $monthname. "<br>";
		}
 
		$startdate= substr($year,2,2) . str_pad($t, 2, '0', STR_PAD_LEFT) . "01";
		$t++;
	}
	$out=$out . "</font><p> ";
	$out=$out . "<font size=-2 color=666666 face=arial>";
	if (substr($earlieryear, 2, 2) . "0101">"950801" or  substr($earlieryear, 2, 2) . "0101" < todaydatecode())
		{
			$out=$out . "<a href=" .  $earlierurl . ">" . $earlieryear. "</a>  | ";
		}
	else
		{
			$out=$out . $earlieryear. " | ";
		}
	if (todaydatecode() > substr($lateryear, 2, 2) . "0101" or substr($lateryear, 2, 2) . "0101">"950801")
	{
		$out=$out . "<a href=" . $laterurl . ">" . $lateryear . "</a>";
	}
	else
	{
		$out=$out  . $lateryear ;
	}
	$out=$out . "</font>";
	return($out);
}

function dyearlinks($datecode)
{
//a better function for showing a full year of month links, with proper noun abstracts. 
	$expiration=calculateexpiration($datecode);
	$datearray=getdate(makedate($datecode));
	$year=$datearray["year"];
	$out=filereadcache("y" . $year, $expiration);
	if ($out=="")
	{
		
		$earlieryear=$year-1;
		$lateryear=$year+1;
		$extension="php";
		$target="";
		$base="months.php?";
		$thisbase="dyears.php";
		$content="";
		$earlierurl= $thisbase . "?" . substr($earlieryear,2,2) . "0101";   
		$laterurl=$thisbase . "?" . substr($lateryear,2,2) . "0101";   
		$startdate= substr($year,2,2) . "0101";
		$out="<p align=right><b>" . $year . "</b></p>";
		$t=2;
		while  ($t<14)
		{
			$datearray=getdate(makedate($startdate));
			$month=str_pad($datearray["mon"], 2, '0', STR_PAD_LEFT);
			$monthname=$datearray["month"];
			$extension=decideextension($startdate);
			$monthpart=substr($year,2,2) . $month;
			
			if ($monthpart . "01"<=todaydatecode() or $monthpart . "01">"960730" )
			{
				$url="cache/m" . $monthpart . ".htm";
				if (file_exists($url))
				{
					$handle=fopen ($url, "r");
					$content=fread($handle, filesize($url));
					fclose($handle);
					$content =ProperNounList($content);
				}
				else
				{
					$content ="";
				}
				if (inList("9607 9608 9609 9610 9611", $monthpart))
				{
					$target=" target=_top";
					$link=datecodetourl($monthpart   ."01");
				}
				else
				{
					$link=$base . $monthpart   ."01";
				}
				
				$out=$out . "<a href=" . $link . $target . "><b>" . $monthname. "</b></a> - " . $content . "<p>";
				
			}
			else
			{
				$out=$out . "<b>". $monthname. "</b><p>";
			}
	 
			$startdate= substr($year,2,2) . str_pad($t, 2, '0', STR_PAD_LEFT) . "01";
			$t++;
		}
		$out=$out . "</font><p align=center> ";
		$out=$out . "<font size=-2 color=666666 face=arial>";
		if (substr($earlieryear, 2, 2) . "0101">"950801" or  substr($earlieryear, 2, 2) . "0101" < todaydatecode())
			{
				$out=$out . "<a href=" .  $earlierurl . ">" . $earlieryear. "</a>  | ";
			}
		else
			{
				$out=$out . $earlieryear. " | ";
			}
		if (todaydatecode() > substr($lateryear, 2, 2) . "0101" or substr($lateryear, 2, 2) . "0101">"950801")
		{
			$out=$out . "<a href=" . $laterurl . ">" . $lateryear . "</a>";
		}
		else
		{
			$out=$out  . $lateryear ;
		}
		$out=$out . "<br><a href=allyears.php>index of years</a>";
		$out=$out . "</font>";
		filewritecache("y" . $year, $out);
	}
	return($out);
}

function allyears()
{
	//give me a list of all years my journal has existed, with a sampling of important proper nouns
	$out=filereadcache("allyears", 600);
	if ($out=="")
	{
		$out="<p align=right><b>complete archive</b><p>";
		$datearray=getdate(time());
		$thisyear=$datearray["year"];
	 	for($year=1996; $year<=$thisyear; $year++)
		{
			$yearpart=substr($year, 2, 2);
			$link="dyears.php?" . $yearpart . "0101";
			$url="cache/y" . $year . ".htm";
			if (file_exists($url))
				{
					$handle=fopen ($url, "r");
					$content=fread($handle, filesize($url));
					fclose($handle);
				}
				$content =ProperNounList($content);
				if (strlen($content)>350)
				{
					$content =filterwordsize($content , 8, 18);
				}
			$out=$out . "<a href=" . $link .  "><b>" . $year. "</b></a> - " . $content . "<p>";
		
		}
		filewritecache("allyears", $out);
	}
	return($out);
}

function filterwordsize($strIn, $intMin, $inMax)
{
	//filters words in $strIn not between $intMin and $intMax in size
	$strOut="";
	$arrThis=explode(" ",$strIn);
	foreach($arrThis as $this)
	{
		//echo $this . "-";
		if (strlen($this)<$inMax and strlen($this)>$intMin)
		{
			$strOut=$strOut . " " . $this;
		}
	}
	return($strOut);
}


function latestdateurl()
//give me the latest entry 
{
	$datecode=todaydatecode();
	$out="";
	while ($out=="")
	{
		$monthcode=monthcode($datecode);
		$dir="" . $monthcode;
		
		if (is_dir($dir))
		{
	
			$dh  = opendir($dir);
			while (false !== ($filename = readdir($dh))) 
			{
			  		$files[] = $filename;
			}
			rsort($files);
				foreach ($files as $file)
				{
					list($name, $extension )= split("\.", $file);
			
					if (strlen($name)==6)
					{
					if (ereg("^[0-9]+$",$name))
						{
							if (makedate($name))
							{
								if ($name>$out)
								{
									$out=$name;
								}
							}
						}
					
					}
				}
		}
		$datecode=earliermonthcode($datecode) . "01";
	}
	return($monthcode . "/" . $out . ".php");
}	



function monthdescription($datecode )
{
	//what a month heading looks like, with links
	$datearray=getdate(makedate($datecode));
	$month=$datearray["month"];
	$year=$datearray["year"];
	$extension=decideextension($datecode);
	//$extension="php";
	if ($extension=="htm")
	{
		$out=$month . " <a href=" . $year . "." . $extension . " >" . $year . "</a>";
	}
	else
	{
		$out=$month . " <a href=years.php?" . $year=substr($year,2,2) . "0101" . " >" . $year . "</a>";
	}
	return($out);
}	

function monthnav($datecode )
{
	//nav for simple undescriptive month link frames
	$earliermonth=datecodetomonthdescription(earliermonthcode($datecode) . "01", 2);
	$latermonth=datecodetomonthdescription(latermonthcode($datecode) . "01", 2);
	$latermonthcode=latermonthcode($datecode);
	$out="<a href=". earliermonthurl($datecode).">" . $earliermonth . "</a><br>\n";
	if ($latermonthcode."01" < todaydatecode())
	{
		$out=$out . "<a href=" . latermonthurl($datecode) .">" . $latermonth . "</a>";
	}
	return($out);
}	

function descriptivemonthnav($datecode )
{
	//a nav for the more interesting month link pages
	$datearray=getdate(makedate($datecode));
	$year=$datearray["year"];
	$earliermonth=datecodetomonthdescription(earliermonthcode($datecode) . "01", 2);
	$latermonth=datecodetomonthdescription(latermonthcode($datecode) . "01", 2);
	$latermonthcode=latermonthcode($datecode);
	$out="<a href=". dearliermonthurl($datecode).">" . $earliermonth . "</a> | \n";
	if ($latermonthcode."01" < todaydatecode() or $latermonthcode."01">"960730")
	{
		$out=$out . "<a href=" . dlatermonthurl($datecode) .">" . $latermonth . "</a>";
	}
	else
	{
		$out=$out . $latermonth ;
	}
	$out=$out . "<br><a href=dyears.php?" . $datecode . ">" . $year . "</a>";
	return($out);
}	


function datecodetomonthdescription($datecode, $yearlen)
{
	$datearray=getdate(makedate($datecode));
	$month=$datearray["month"];
	$year=$datearray["year"];
	if ($yearlen!=4)
	{
		$year=substr($year,2,2);
	}
	return($month . " " . $year);
}	


function earliermonthurl($datecode)
{
	$earliermonthcode=earliermonthcode($datecode);
	$extension=decideextension($earliermonthcode . "01");
	if ($extension!="htm")
	{
		$out="days.php?" . $earliermonthcode . "01";
	}
	else
	{
		$out=$earliermonthcode . "/days.htm";
	}
	return ($out);
}

function dearliermonthurl($datecode)
{
	$earliermonthcode=earliermonthcode($datecode);
	$extension=decideextension($earliermonthcode . "01");
	$out="months.php?" . $earliermonthcode . "01";
	return ($out);
}

function dlatermonthurl($datecode)
{
	$latermonthcode=latermonthcode($datecode);
	$extension=decideextension($latermonthcode . "01");
	$out="months.php?" . $latermonthcode . "01";
	return ($out);
}

function latermonthurl($datecode)
{
	$latermonthcode=latermonthcode($datecode);
	$extension=decideextension($latermonthcode . "01");
	if ($extension="htm")
	{
		$out="days.php?" . $latermonthcode . "01";
		
	}
	else
	{
		$out=$latermonthcode . "/days.htm";
	}
	return ($out);
}

function earliermonthcode($datecode)
{
	//returns a monthcode from the month preceding datecode
	$firstofmonth=firstofmonth($datecode);
	$firstofmonthdate=makedate($firstofmonth);
	$mildlyearlierdatecode=makedatecode(adddaystodate($firstofmonthdate, -5));
	$out=monthcode($mildlyearlierdatecode);
	return ($out);
}

function latermonthcode($datecode)
{
	//returns a monthcode from the month preceding datecode
	$firstofmonth=firstofmonth($datecode);
	$firstofmonthdate=makedate($firstofmonth);
	$mildlylaterdatecode=makedatecode(adddaystodate($firstofmonthdate, 35));
	$out=monthcode($mildlylaterdatecode);
	return ($out);
}

function monthcode($datecode)
{
	$out=substr($datecode,0,4);
	return ($out);
}


function monthlinks($datecode)
{
	//returns a list of links for the month up to $datecode
	$firstofmonth=firstofmonth($datecode);
	$newdatecode=$firstofmonth;
	$out="";
	$p=1;
	$datecodetest=laterday($datecode);
	$todayceiling=laterday(todaydatecode());
	while ($datecodetest>$newdatecode and $p<40 and $newdatecode<$todayceiling)
	{
		$monthcode=monthcode($datecode);
		$day=substr($newdatecode,4,2);
		$extension=decideextension($datecode);
		$path=$monthcode . "/" . $newdatecode . "." . $extension;
		if (is_file($path)  )
		{
			if ($datecode>"030700")
			{
				$strHref="d.php?datecode=" . $newdatecode ;
			}
			else
			{
				$strHref=$monthcode . "/" . $newdatecode . "." . $extension;
			}
			$out=$out . "<a href=" . $strHref . " target=entries>" . $day . "</a> " ;
		}
		else
		{
			$out=$out . " " .  $day . " "  ;
		}
		$newdatecode=laterday($newdatecode);
		$p=$p+1;
	}
	return ($out);
}

function firstofmonth($datecode)
{
		$year=substr($datecode,0,2);
		$month=substr($datecode,2,2);
		$out=$year . $month . "01";
		return($out);
}

function todaydatecode()
{
	$datearray=getdate();
	$year=substr($datearray["year"],2,2);
	$month=str_pad($datearray["mon"], 2, '0', STR_PAD_LEFT);
	$day=str_pad($datearray["mday"], 2, '0', STR_PAD_LEFT);
	$out=$year . $month . $day;
	return($out);
}

function displayrandate($datecode)
	{
	$datearray=getdate(makedate($datecode));
	$dayoftheweek=$datearray["weekday"];
	$year=$datearray["year"];
	$month=$datearray["month"];
	$day=$datearray["mday"];
	$monthpart=substr($datecode,0,4);
	$out=$dayoftheweek . ", " . "<a href=months.php?" .$datecode . ">" . $month . "</a> " . $day  . " <a href=dyears.php?" . substr($year,2,2) . "0101 >" . $year . "</a>";
	return ($out);
	}


function makedate($datecode)
//from a randomly ever after $datecode to a UNIX timestamp
	{
		$year=substr($datecode,0,2);
		$month=substr($datecode,2,2);
		$day=substr($datecode,4,2);
		$newdate=strtotime($month . '/' . $day . '/' . $year);
		return($newdate);
	}


function decideextension($datecode)
//i have begun abandoning this hardcoding in much of the code
{
	$extension="php";
	if ($datecode<"030701" or $datecode>"980901")
	{
		$extension="htm";
	}
	return($extension);
}
	
	
function makeearlierdateurl($datecode)
	{
	$earlierdatecode=earlierday($datecode);
	$earliermonthpart=substr($earlierdatecode,0,4);
	$nowmonthpart=substr($datecode,0,4);
	$extension=decideextension($earlierdatecode);
	$allinoneurl="d.php";
	$bwlIsD=(strpos($_SERVER['SCRIPT_FILENAME'], $allinoneurl)>0);
	if ($earliermonthpart>"0307" and !$bwlIsD)
		{
			$out="../" . $allinoneurl . "?datecode=" . $earlierdatecode;
		}
	else if ($bwlIsD)
	{	
		if ($earliermonthpart<"0307")
			{
				$out= $earliermonthpart . "/" . $earlierdatecode . "." . $extension;
			}
		else
			{
				$out=$allinoneurl . "?datecode=" . $earlierdatecode;
			}
	}
	else if ($nowmonthpart!=$earliermonthpart)
		{
			$out="../" . $earliermonthpart . "/" . $earlierdatecode . "." . $extension;
		}
	else
		{
			$out=$earlierdatecode . "." . $extension;
		}
	return($out);
	}
	
	
function makelaterdatelink($datecode)
	{
	$laterdateurl=makelaterdateurl($datecode);
	$out=" | next ";
	if ($laterdateurl!="")
		{
			$out=" | <a href=" . $laterdateurl . ">next</a>";
		}
	return($out);
	}
	
function makelaterdateurl($datecode)
	{
	$laterdatecode=laterday($datecode);
	$latermonthpart=substr($laterdatecode,0,4);
	$nowmonthpart=substr($datecode,0,4);
	$allinoneurl="d.php";
	$bwlIsD=(strpos($_SERVER['SCRIPT_FILENAME'], $allinoneurl)>0);
	if ($latermonthpart>"0307" and !$bwlIsD)
	{
		$out="../" . $allinoneurl . "?datecode=" . $laterdatecode;
	}
	else if ($bwlIsD)
	{
		$out=$allinoneurl . "?datecode=" . $laterdatecode;
		
		if (datecodetourl($laterdatecode)=="")
			{
				$out="";
			}
	}
	else
	{
		if ($nowmonthpart!=$latermonthpart)
			{
				$out="../" . $latermonthpart . "/" . $laterdatecode . ".php";
			}
		else
			{
				$out=$laterdatecode . ".php";
			}
	
		if (!is_file($out))
		{
			$out="";
		}
	}
	return($out);
	}
	
function makedatecode($date)
	//function written in the Summer of 2001, back when I was just learning PHP
	//given a date, i want the datecode
	{
		$datecode=str_pad(substr(date("Y", ($date)),2,2), 2, '0', STR_PAD_LEFT) . str_pad(date("m", ($date)), 2, '0', STR_PAD_LEFT)   . str_pad(date("d", ($date)), 2, '0', STR_PAD_LEFT) ;
		return($datecode);
	}
  
function adddaystodate($date, $amount)
	//give me a date that is $amount days in the future (can take negative for the past)
	{
		$weird=$date;
		$newdate  = mktime (0,0,0,date("m", $weird), date("d", $weird)+$amount , date("Y", $weird));
		return($newdate);
	}
	
function addmonthstodate($date, $amount)
	//add months to this $date
	{
		$weird=$date;
		$newdate  = mktime (0,0,0,date("m", $weird)+$amount, date("d", $weird), date("Y", $weird));
		return($newdate);
	}

function earlierday($datecode)
	//give me the datecode preceding this one
	{
		$out=makedatecode(adddaystodate(makedate($datecode), -1));
		return($out);
	}

function laterday($datecode)
	//give me the datecode for the one following this one
	{
		$out=makedatecode(adddaystodate(makedate($datecode), 1));
		return($out);
	}
	
function firstofnextmonth($datecode)
	//i want to know what the datecode of the first of next month looks like
	{
		$out=makedatecode(addmonthstodate(makedate($datecode), 1));
		$out=substr($out, 0, 4). "01";
		return($out);
	}

function possiblefolderappend($thisdatecode, $navdatecode)
	//do i need a folder path with this item? if so, hit me yo!!
	{
		$thismonthcode=substr($thisdatecode, 0, 4);
		$navmonthcode=substr($navdatecode, 0, 4);
		if ($thismonthcode != $navmonthcode)
			{
				$out="../".$navmonthcode."/".$navdatecode;
			}
		else
			{
				$out=$navdatecode;
			}
		return($out);
	}
	

function flash($bgcolor,$width, $height, $swffile)
//display a Flash object embed for both IE and Mozilla
{
$canflash=true;
$out="";
 
if ($canflash==true)
{
	$out=$out . "<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\"".  chr(13); 
	$out=$out . "codebase=\"http://active.macromedia.com/flash2/cabs/swflash.cab#version=4,0,0,0\"" .chr(13); 
	$out=$out . "ID=logo\" WIDTH=\"".$width."\" HEIGHT=\"".$height."\">" .chr(13);
	$out=$out . "<param NAME=movie VALUE=\"" . $swffile ."\"> <param NAME=quality VALUE=high>" .chr(13);
	$out=$out . "<param NAME=bgcolor VALUE=\"".$bgcolor."\"> <embed src=\"". $swffile . "\" quality=high" .chr(13);
	$out=$out . "bgcolor=\"".$bgcolor."\"  WIDTH=\"".$width."\" HEIGHT=\"".$height."\" TYPE=\"application/x-shockwave-flash\"" .chr(13);
	$out=$out . "PLUGINSPAGE=\"http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_\"" .chr(13);
	$out=$out . "Version=\"ShockwaveFlash\"></embed>" .chr(13);
	$out=$out . "</object>" .chr(13);
}
else
{
	$out="<img src=\"gifs/cas-logo.gif\"  WIDTH=\"".$width."\" HEIGHT=\"".$height."\" alt=\"Catskill Animal Sanctuary\" border=\"0\">" . chr(13);
}
return($out);
}


function parseEntry($strIn)
//a placeholder of course
{
	$strOut=$strIn;
	return($strOut);
}

function defeed($strIn)
//no linefeeds in $strIn!
{
	$strOut=$strIn;
	$strOut=str_replace(chr(10), "", $strOut);
	$strOut=str_replace(chr(13), "", $strOut);
	return($strOut);
}

//i needed this because the Spies.com PHP parser is kinda oldschool
if (!function_exists("ob_get_clean")) {
   function ob_get_clean() {
       $ob_contents = ob_get_contents();
       ob_end_clean();
       return $ob_contents;
   }
}

function stringprefix($strIn, $strPrefix)
	//adds a prefix to quoted strings that look like URLs found within $strIn
	{
	$strEndingList="swf htm php jpg gif";
	$intCursor=0;
	$intEndCursor=1;
	$bwlNotDone=true;
	$strOut=$strIn;
	$intCount=0;
	while($intEndCursor>0 and $intCount<12000 and $bwlNotDone)
		{
		$intCursor=strpos($strIn, chr(34), $intCursor);
		$intEndCursor=strpos($strIn, chr(34), $intCursor+1);
		$strThisQuotedString=substr($strIn, $intCursor +1, $intEndCursor-$intCursor-1);
		if ($intCursor)
			{
				if (substr($strThisQuotedString, strlen($strThisQuotedString)-4,1)==".")
					{
						if (inList($strEndingList, substr($strThisQuotedString, strlen($strThisQuotedString)-3, strlen($strThisQuotedString))))
							{
							if (substr($strThisQuotedString, 0 , strlen($strPrefix))!=$strPrefix)
							{
								$strOut=str_replace($strThisQuotedString, $strPrefix.$strThisQuotedString,$strOut);
							}
							
							}
					}
			}
		else
			{
				$bwlNotDone=false;
			}
		$intCursor=$intEndCursor+1;
		$intCount++;
		}
		return($strOut);
	}



function tagHREFprefixer($strIn, $strTagList, $strParameterList, $strPrefix)
//scans through HTML in $strIn and appends $strPrefix to URL parameters in space-delimited $strParameterList list in tags named in space-delimited $strTagList
{
	$intCursor=0;
	$intEndCursor=1;
	$intCount=0;
	$bwlNotDone=true;
	$strBadBegins="/ ! $";
	$strOut=$strIn;
	//$strOut=str_replace("<!--", "~!--", $strOut);
	//$strOut=str_replace("-->", "--~", $strOut);
	while($intEndCursor>0 and $intCount<12000 and $bwlNotDone)
	{
		$intCursor=strpos($strIn, "<", $intCursor);
		$intEndCursor=strpos($strIn, ">", $intCursor);
			if ($intCursor)
				{
				$strThisTag=substr($strIn, $intCursor +1, $intEndCursor-$intCursor-1);
				$strFullTag=substr($strIn, $intCursor , 1+$intEndCursor-$intCursor);
				//$excerpt=substr($strIn, $intCursor +1, strlen($strIn));
				if (substr($strThisTag, 0, 1)=="?")
					{
						$strThisTagMod=substr($strThisTag, 1, strlen($strThisTag)-2);
						if (substr($strThisTagMod, 0 , 7)!="include")
							{
								
								$strThisTagMod=stringprefix($strThisTagMod, $strPrefix);
								ob_start();
								eval($strThisTagMod . ";");
								$strThis = ob_get_clean();
								$strOut=str_replace($strFullTag, $strThis, $strOut, 1);
							}
					
					}
				else if (!inList($strBadBegins, substr($strThisTag, 0, 1)))//not interested in end tags or comments
					{
						$arrThis=parameterarray($strThisTag);
						if (count($arrThis)>1)
						{
							if (inList($strTagList, $arrThis[0]))
							{
							for($t=1; $t<count($arrThis); $t++)
								{
									$arrItem=explode("=", $arrThis[$t], 2);
									
								
									if (inList($strParameterList,$arrItem[0]))
									{
										if (strtolower(substr($arrItem[1], 0, 7))=="http://")
											{
											}
										else
											{
											//this is kind of ponderous i know
												$strThisParameter=removebalancedendquotes($arrItem[1]);
												if (substr($strThisParameter, 0 , strlen($strPrefix))!=$strPrefix)
												{
													$strOut=str_replace($strThisParameter, $strPrefix . $strThisParameter, $strOut);
												}
											}
										
									}
								}
							}
						}
					}
		
			 	}
			else
				{
					$bwlNotDone=false;
				}
		if (intval($intCursor)<intval($intEndCursor))
		{
			$intCursor=$intEndCursor;
		}
		else
		{
			$bwlNotDone=false;
		}
		$intCount++;
	
	}
	return($strOut);
}

function tagName($strThisTag)
{
//returns the name of an XML tag, assuming no < or >
	$intSpaceLocation=strpos($strThisTag, " ");
	if (!$intSpaceLocation)
	{
		$intSpaceLocation=strlen($strThisTag);
	}
	$strThisTagName=substr($strThisTag, 0, $intSpaceLocation);
	return($strThisTagName);
}

function parameterarray($strThisTag)
//returns an array of a parameter pairs from a tag
//warning- doesn't handle spaces in parameter yet!!
{
	$arrOut=array();
	$intSpaceLocation=1;
	$intCursor=0;
	$intCount=0;
	$bwlNotDone=true;
	while($intSpaceLocation>0 and $intCount<500 and $bwlNotDone)
	{
		$intSpaceLocation=strpos($strThisTag, " ", $intCursor);
		if (!$intSpaceLocation)
		{
			$intSpaceLocation=strlen($strThisTag);
			$bwlNotDone=false;
		}
		$strThisParameterPair=substr($strThisTag, $intCursor, $intSpaceLocation-$intCursor);
		if ($strThisParameterPair!="")
		{
			$arrOut[]=$strThisParameterPair;
		}
		$intCursor= $intSpaceLocation+1;
		$intCount++;
	}
	return($arrOut);
}

function inList($strList, $item) 
//look to see if item is in the space-delimited strList (similar to my ASP version)
	{
		$arrThis=explode(' ', $strList);
		for ($t=0; $t<count($arrThis); $t++)
		{
			if ($arrThis[$t]==$item)
			{
				return true;
				break;
			}
		}
		return false;
	}
	
function removebalancedendquotes($strIn)
{
	//kills off ' or " on either side of a string - but only if they're both there.
	$strQuotes=chr(34) . " " .chr(39);
	$chrBegin=substr($strIn, 0, 1);
	$chrEnd=substr($strIn, strlen($strIn)-1, 1);
	if (inList($strQuotes, $chrBegin) and inList($strQuotes, $chrEnd) and $chrBegin==$chrEnd)
	{
		//echo "!hoo!";
		$strOut=substr($strIn, 1, strlen($strIn)-2);
	
	}
	else
	{
		$strOut=$strIn;
	}
	return($strOut);
}


function filereadcache($strKey, $intDayLife)
{
	//retrieves pre-built site fragments from /ran/cache to limit work on the backend
	//the content expires in $intDayLife days
	$url="cache/" . $strKey . ".htm";
	$content="";
	if (file_exists($url))
	{
		$tsFileModTime=filemtime($url);
		$tsExpiration=adddaystodate($tsFileModTime, $intDayLife);
		if ($tsExpiration>time()) //if not expired
		{
			$handle=fopen ($url, "r");
			$content=fread($handle, filesize($url));
			fclose($handle);
		}
	}
	return($content);
}


function filewritecache($strKey, $strIn)
//write $strIn to the filesystem cache under the key $strKey
{
	$url="cache/" . $strKey . ".htm";
	$handle=fopen ($url, "w");
	$content=fwrite($handle, $strIn);
	fclose($handle);
}

function calculateexpiration($datecode)
//intelligently give me a cache expiration in days based on the $datecode of the content - in this case i use a period a third of the content's age.
{
	$date = makedate($datecode);
	$diff = time()-$date;
	$daysDiff = floor($diff/60/60/24);
	$intOut=floor($daysDiff/3);
	return($intOut);
}

function deMultiple($strIn, $chrIn)
//remove multiple side-by-side instances of $chrIn - works best for things like spaces and chr(13)
{
	$strOut=$strIn;
	while(!strpos($strOut, $chrIn . $chrIn))
	{
		$strOut = str_replace( $chrIn . $chrIn, $chrIn, $strOut);
	}
	return($strOut);
}

function filterHTML($strIn)
//remove all HTML tags in $strIn. Works best if the tags are complete.
{
  $strTemp = $strIn;
  $i=0;
  while (!(strpos($strTemp,"<")===false) and !(strpos($strTemp, ">")===false) and $i<10000)
	{
    	$strTemp = substr($strTemp, 0, strpos($strTemp, "<",0)) . " " . substr($strTemp, 1+strpos($strTemp, ">",0),strlen($strTemp)-strpos($strTemp, ">",0));
		$i++;
	}
  	return ($strTemp);
}


function TruncateString($strIn, $intVal)
//make $strIn only $intVal long
{
	if (strlen($strIn)>$intVal)
		{
			$strOut=substr($strIn, 0, $intVal . "...");
		}
		else
		{
			$strOut= $strIn;
		}
		return($strOut);
}

function ProperNounList($strIn)
	{
	//December 11, revised Dec 28 2003
	//extracts proper nouns that are not at the beginning of sentences.
	//based on a version I wrote in ASP that worked poorly.
	//$strFilter contains a space-delimited list of words to /not/ include in generated lists.
	
	$strFilter="I Gretchen My Mine Our Today Email Feedback Monday Tuesday Wednesday Thursday Friday Saturday Sunday January February March April May June July August September October November December";
	if (strLen($strIn)>250)
	{
		$strIn=FilterHTML($strIn);
		$strIn=deMultiple($strIn, " ");
		$strThisFilter="";
		$strWord="";
		$bwlBeginSentenceMode=true;
		$bwlGoodWordMode=false;
		$strOut="";
		//$strIn=TruncateString($strIn,2000);

		if ($strIn!="")
		{
			
			for ($i=0; strlen($strIn)>$i; $i++)
			{
				$chrThis=substr($strIn, $i, 1);
				$intASC=ord($chrThis);
				if ($intASC>64 and $intASC<91 or $intASC>96 and $intASC<123 or $intASC==32 or $intASC>47 and $intASC<58 or inList(". ! ? - (", $chrThis))//useful character
				{
				
				}
				else
				{
					$chrThis=" ";
				}
				if (inList(". ! ? - (", $chrThis)) 
				{
					
					$bwlBeginSentenceMode=true;
					$bwlGoodWordMode=false;
					
				}
			
				if (!$bwlBeginSentenceMode)
				{
					if ($intASC>64 and $intASC<91)
					{
						$bwlGoodWordMode=true;
					}
					if ($bwlGoodWordMode)
					{
						
						if  (!(inList(". ! ? , - (", $chrThis) or $chrThis==" "))
						{
							$strWord=$strWord . $chrThis;
						}
						else
						{
							$bwlGoodWordMode=false;
							if (!inList($strFilter, $strWord) and !inList($strThisFilter, $strWord))
								{
									$strOut=$strOut . " " . $strWord;
									$strThisFilter=$strThisFilter . " " . $strWord;
								}
								$strWord="";
						}
					}
				}
				else if (($intASC>64 and $intASC<91 ) and $intASC!=32)
				{
					$bwlBeginSentenceMode=false;
					if (!inList($strFilter, $strWord) and !inList($strThisFilter, $strWord))
						{
							$strOut=$strOut . " " . $strWord;
							$strThisFilter=$strThisFilter . " " . $strWord;
						}
						$strWord="";
					
				}
				
			
			}
		}
	}
	else
	{
		$strOut=$strIn;
	}

	return($strOut);
}


?>