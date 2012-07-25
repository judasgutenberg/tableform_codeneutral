<?
///////////////////////////////////////////////
//PHP functions for RFMdomly Ever After
//begun in the Summer of 2001 --
//greatly expanded in the Fall and Winter of 2003
//Many of these have origins in old ASP functions
//for Vodkatea and Bathtubgirl
//though some are original or I developed them in
//the PHP world in places like CaSanctuary.org
//or Jonbowermaster.com
////////////////////////////////////////////////




function hexdump($strIn)
{
	$out="";
	for ($i=0; $i<strlen($strIn); $i++)
	{
		$out=$out . " " . ord(substr($strIn, $i, 1));
		
	
	
	}
	echo $out;

}


function title($strPath, $strFilename)
{
	$content="";
	$title=""; $desc=""; $date="";$body="";
	if(file_exists($strPath . "/" . $strFilename))
	{
		$fhandle=fopen ($strPath . "/" . $strFilename, "r");
		$content=fread($fhandle, filesize($strPath . "/" . $strFilename));
		$arrContent=explode("|", $content);
		$title=$arrContent[0];
		$desc=$arrContent[1];
		$date=$arrContent[2];
		$body=$arrContent[3];
		fclose($fhandle);
	}
	$title =fixfuckedcharacters($title);
	return $title;
}


function displayitem($strPath, $strFilename)
{
	$content="";
	$title=""; $desc=""; $date="";$body=""; $annotation="";
	if(file_exists($strPath . "/" . $strFilename))
	{
		$fhandle=fopen ($strPath . "/" . $strFilename, "r");
		$content=fread($fhandle, filesize($strPath . "/" . $strFilename));
		$arrContent=explode("|", $content);
		$title=$arrContent[0];
		$desc=$arrContent[1];
		$date=$arrContent[2];
		$body=$arrContent[3];
		if (count($arrContent)>4)
		{
			$annotation=$arrContent[4];
		
		}
		fclose($fhandle);
	}
	$body=crtobr($body);
	$title =fixfuckedcharacters($title);
	$desc =fixfuckedcharacters($desc);
	$body =fixfuckedcharacters($body);
	$out="<div class='title'>" . $title . "</div>";
	if ($desc!="")
	{
		$out.="<div class='subtitle'>" . $desc . "</div>";
	
	}
	$out.="<div class='author'>R.F. Mueller</div>";
	$out.="<p></p>";
	$out.="<p></p>";
	$out.="<div class='body'>" . $body . "</div>";
	
	if ($annotation!="")
	{
		$out.="<p/>&nbsp;";
		$out.="<div class='annotationtitle'>annotation</div>";
		$out.="<p/><div class='annotation'>" . fixfuckedcharacters($annotation) . "</div>";
	
	}
	return $out;
}

function crtobr($strIn)
{
	$out=str_replace(chr(10), chr(10) . "<br>", $strIn);
	return $out;
}

function fixfuckedcharacters($in)
{
	//we hate smart quotes and all that shit
	$in=str_replace( "“", chr(34), $in);
	$in=str_replace(  "”", chr(34), $in);
	$in=str_replace(  "‘", "'", $in);
	$in=str_replace( "’", "'", $in);
	$in=str_replace( chr(8212), "--", $in);
		
	$in=str_replace( chr(92) . "'", "'", $in);
	$in=str_replace( chr(92) . "\"", "\"", $in);
	$in=str_replace( chr(92) . chr(92), "", $in);
	$in=str_replace( chr(151), "&mdash;", $in);
	return $in;


}

function filelist($strPath)
{
	$url="";
	$out="<dl>";
	$strPHP=$_SERVER['PHP_SELF'];
	$strFilename="";
	if ($handle = opendir($strPath)) 
	{
   		//echo "Directory handle: $handle\n";
  		//echo "Files:\n";
		if (array_key_exists("f",$_REQUEST))
		{
			$strFilename=$_REQUEST["f"];
		}

   		/* This is the correct way to loop over the directory. */
		if ($strFilename=="")
		{	
			$out.="<a   class='navthere' href='" . $strPHP . "'>INTRO</a>";
		}
		else
		{
			$out.="<a class='nav' href='" . $strPHP . "'>INTRO</a>";
		}
   		while (false !== ($url = readdir($handle))) 
		{
		 
       		$fhandle=fopen ($strPath . "/" . $url, "r");
			$content=fread($fhandle, filesize($strPath . "/" . $url));
			//echo $content;
			if ($content!="")
			{
				$arrContent=explode("|", $content);
				$title=$arrContent[0];
				
				$desc=$arrContent[1];
				$date=$arrContent[2];
				
				$calcurl=$strPHP . "?f=" . $url;
				$out.="<dt>";
				//echo $strFilename . "----------" . $url . "<br>";
				if ($strFilename!=$url)
				{
					$out.="<a class='nav' href='" . $calcurl . "'>" . $title . "</a>";
				}
				else
				{
					$out.= "<div class='navthere'>" . $title . "</div>";
				}
				$out.="</dt>";
				if ($desc!="")
				{
					//$out.="<dd>" . $desc . "</dd><br>";
				
				}
				//echo $content;
				//echo "<br><hr><br>";
			}
			fclose($fhandle);
			
   		}
		$out.="</dl>";
   }

    closedir($handle);
	return $out;

}













function thisfilename()
//returns the name of the file we are on, with no path
	{
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
			//echo("lowermusings");
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
		else //RFMdomly every after, either php or htm ending
		{
			$out = $upper . "/" . $datecode . "." ;
		}
	
		if (strpos($out, "#")<1)
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
		//echo "pooP". $out;
		return($out);
	
	}




function monthofRFMArticleList($datecode)
//give me an unformatted list of linked numbers - not a true calendar
	{
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
					$title=parseRFMTitle($content);
					if (substr($title, 0, 1)!="*") //do not show asterisk-preceded titles
					{
						$out=$out . imageIcon($content) . $day . ": <a href=i.php?" . $datecode . " target=_top><b>" . $title . "</b></a>" . chr(13);
						$description=parseRFMDescription($content);
						
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





function RFMArticleList($intNumber, $intNumberOfDescriptions)
//return a display of $intNumber recent REA articles, the first $intNumberOfDescriptions presented with descriptions as well
	{
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
				$title=parseRFMTitle($content);
				if (substr($title, 0, 1)!="*") //do not show asterisk-preceded titles
				{
					$out=$out . "<a href=i.php?" . $todaydatecode . " target=_top><b>" . $title . "</b></a>";
					if ($intNumberOfDescriptions>0)
					{
						$description=parseRFMDescription($content);
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
	//give me the actual body of an REA content page, whether it is PHP or HTML
	{
		if (strpos($strIn, "$" . "articletitle=" . chr(34))>0)
		{
				$content=parseBetween($strIn,  "<" . "?include(\"../header.php\")" . "?" . ">", "<" . "?include(\"../footer.php\")?" . ">"). "<p><p>";
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

function parseRFMLatitude($strIn)
//this parses the latitude info from an REA entry page - it will always be a PHP variable
	{
		$rd=parseBetween($strIn,  "$" . "latitude=" . chr(34),  chr(34) .";");
		return($rd);
	}

function parseRFMLongitude($strIn)
//this parses the longitude info from an REA entry page - it will always be a PHP variable
	{
		$rd=parseBetween($strIn,  "$" . "longitude=" . chr(34),  chr(34) .";");
		return($rd);
	}

function parseRFMDescription($strIn)
//parses meta description from rea or musings pages
	{
		if (strpos($strIn, "$" . "articletitle=" . chr(34))>0)
			{
				//this is the method for parsing all-PHP entries - the data is stored in a PHP variable and must be parsed that way
				$rd=parseBetween($strIn,  "$" . "articledescription=" . chr(34),  chr(34) .";");
			}
		else
			{
				//all-HTML enties can be parsed as if they are cluttered, messy XML
				$rd=parseBetween($strIn, "<meta name=\"description\" content=\"","\">");
			}
		return($rd);
	}

function parseRFMTitle($strIn)
//effectively parses either a REA title or a musings title from html content $strIn. Parses title of most web pages actually.
	{

		//all-HTML enties can be parsed as if they are cluttered, messy XML
		$title=parseSimpleNode($strIn, "title");
			
		return($title);
	}

function parseSimpleNode($strIn, $strNode)
//return the content of a simple non-parameterized, non-nested node
	{
		return(parseBetween($strIn, "<" . $strNode . ">", "</" . $strNode . ">"));
	}


function parseBetween($strIn, $strStart, $strEnd)
//a great function for returning the string between two known strings ($strStart, $strEnd) within $strIn
	{
		$pos1 = strpos($strIn, $strStart) + strlen($strStart);
		//echo ($strEnd . "-----". $pos1. "-----". $strIn . "****<P>");
		//if (strlen($strIn)<$pos1)
		//{
		//	$pos1=0;
		//}
		$pos2 = strpos($strIn, $strEnd, $pos1+1);
		//echo "<p>=" . $pos1 . " " . $pos2 . "=<p>";
		
		$found=substr($strIn, $pos1, ($pos2-$pos1));
        //echo "<P>" . $found ."<P>";
       // $found= $pos1 . " " .$pos2 . "<p>".  $found . "<br>";
		return($found);
        
	}


  
 
 

function filterwordsize($strIn, $intMin, $inMax)
//filters words in $strIn not between $intMin and $intMax in size
	{
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

  
function defeed($strIn)
//no linefeeds in $strIn!
	{
		$strOut=$strIn;
		$strOut=str_replace(chr(10), "", $strOut);
		$strOut=str_replace(chr(13), "", $strOut);
		return($strOut);
	}

//i needed this because the Spies.com PHP parser is kinda oldschool
if (!function_exists("ob_get_clean")) 
	{
	   function ob_get_clean() {
	       $ob_contents = ob_get_contents();
	       ob_end_clean();
	       return $ob_contents;
	   }
	}
	
function tagHREFprefixer($strIn, $strTagList, $strParameterList, $strPrefix)
//scans through HTML in $strIn and appends $strPrefix to URL parameters in space-delimited $strParameterList list in tags named in space-delimited $strTagList
//this is great for cases where you are dealing with the display of the same cluttered HTML file viewed from several different depths in a website directory
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
									$strOut=str_replace($strFullTag, $strThis, $strOut);
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
											if (strtolower(substr($arrItem[1], 0, 7))=="http://" or  substr($arrItem[1], 0, 1)=="#")
												{
												}
											else
												{
												//this is kind of ponderous i know
													$strThisParameter=removebalancedendquotes($arrItem[1]);
													if (substr($strThisParameter, 0 , strlen($strPrefix))!=$strPrefix and substr($strThisParameter, 0 , 1)!="#")
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
		//retrieves pre-built site fragments from /RFM/cache to limit work on the backend
		//the content expires in $intDayLife days
		//used to cache pages generated from large amounts of server-side work
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
    
	
function getIPaddress()
{

  	$ipaddress=getenv("REMOTE_ADDR");
 	return ($ipaddress);
}
	
function logIPaddress($siteid)
{
   // $url="iplog.txt";
   // $ipaddress=getenv("REMOTE_ADDR");
    //$handle=fopen ($url, "a");
   // $content=fwrite($handle, $siteid . "    " . $ipaddress . chr(10));
   // fclose($handle);
}

function logEmail($strEmail)
//write $strIn to the filesystem cache under the key $strKey
	{
		$url="emails_for_gus_x.txt";
		$handle=fopen ($url, "a");
		$content=fwrite($handle, $strEmail);
		fclose($handle);
	}
	
function logAnything($name, $strLine)
//write $strIn to the filesystem cache under the key $strKey
	{
		$url=$name .".txt";
		$handle=fopen ($url, "a");
		$content=fwrite($handle, $strLine);
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
		while(strpos($strOut, $chrIn . $chrIn))
		{
			$strOut = str_replace( $chrIn . $chrIn, $chrIn, $strOut);
		}
		return($strOut);
	}

function filterHTML($strIn)
//remove all HTML tags in $strIn. Works best if the tags are complete.
	{
	  return(strip_tags($strIn));
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
		$strIn=str_replace(chr(10), " ", $strIn);
		$strIn=str_replace(chr(13), " ", $strIn);
		$strIn=str_replace("<p>", " ", $strIn);
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

function textinfo($strInOriginal, $infotype, $intParameterOne, $intParameterOne)
//give a text of $strInOriginal, return various forms of info based on $infotype (see below for the various infotypes)
//for  $infotype, you can pass in a RFMge with $intParameterOne the floor and  $intParameterOne the ceiling
//saying what sized words you want considered in the data returned.
	{
		$intSum=0;
		$count=0;
		$strOut="";
		$strUniqueWordList="";
		$arrWords=array();
		$strIn=filterHTML($strInOriginal);
		$strIn=deMultiple($strIn, " ");
		$strIn=strtolower($strIn);
		for ($i=0; strlen($strIn)>$i; $i++)
			{
				$chrThis=substr($strIn, $i, 1);
				$intASC=ord($chrThis);
				if ($intASC>64 and $intASC<91 or $intASC>96 and $intASC<123 or $intASC==32 or $intASC>47 and $intASC<58 ) 
				{
					
				}
				else
				{
					$chrThis=" ";
				}
				$strOut=$strOut . $chrThis;
			}
	
		//echo($strOut);
		$arrThis=explode(" ", $strOut);
		foreach($arrThis as $strThis)
			{
				$intThisLen=strlen($strThis);
				if ($intThisLen>0)
				{
					if (!inList($strUniqueWordList, $strThis))
					{
						$strUniqueWordList=$strUniqueWordList . " " . $strThis;
						$arrWords[$strThis]=1;
					}
					else
					{
						$arrWords[$strThis]++;
					}
					$intSum=$intSum + $intThisLen;
					$count++;
				}
			}
		$intAverage=$intSum/$count;
		arsort($arrWords);
		if ($infotype==0)
		{
			return($intAverage);
		}
		else if ($infotype==1) //number of words
		{
			return($count);
		}
		else if ($infotype==2) //list of unique words as they happened
		{
			return($strUniqueWordList);
		}
		else if ($infotype==3)
		{
			return(count($arrWords));//number of unique words
		}
		else if ($infotype==4) //list all unique words in order of number of times they were used, smallest to greatest
		{
			$strOut="";
			foreach($arrWords as $key => $value)
			{
				$strOut=$strOut. " " .   $key;
			}
			return($strOut);
		}
		else if ($infotype==5) //list all unique words with the number of times they occurred
		{
			$strOut="";
			foreach($arrWords as $key => $value)
			{
				if ($value>$intParameterOne and  $value<$intParametertwo)
				{
					$strOut=$strOut. " " .   $key . " " . $value;
				}
			}
			return($strOut);
		}
	}
	
function day($datein)
{
	$datearray=getdate($datein);
	//$dayoftheweek=$datearray["weekday"];
	//$year=$datearray["year"];
	//$month=$datearray["month"];
	$day=$datearray["mday"];
	return $day;
}
	
function month($datein)
{
	$datearray=getdate($datein);
	//$dayoftheweek=$datearray["weekday"];
	//$year=$datearray["year"];
	$month=$datearray["mon"];
	//$day=$datearray["mday"];
	return $month;
}

function year($datein)
{
	$datearray=getdate($datein);
	//$dayoftheweek=$datearray["weekday"];
	$year=$datearray["year"];
	//$month=$datearray["month"];
	//$day=$datearray["mday"];
	return $year;
}

function weekday($datein)
{
	$datearray=getdate($datein);
	$dayoftheweek=$datearray["wday"];
	//$year=$datearray["year"];
	//$month=$datearray["month"];
	//$day=$datearray["mday"];
	return $dayoftheweek;
}

function monthname($datein)
{
	$datearray=getdate($datein);
	//$dayoftheweek=$datearray["weekday"];
	//$year=$datearray["year"];
	$month=$datearray["month"];
	//$day=$datearray["mday"];
	return $month;
}
	
function Calendar($dtmStart, $intArticleIDIn, $intSectionID, $colBG, $colSelected, $strPHP)
{ 

	$arrThis=array("","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","","");
	if ($dtmStart=="")
	{
		//$intArticleID=GetLatestBTGJournalEntryID(dtmLast, intSectionID);
		$dtmLast=$dtmLast;
	}
	else
	{
		$dtmLast= $dtmStart;
	}
	if ($dtmLast=="" or year($dtmLast)<1990) 
	{
		$dtmLast=time();
	}
	$intThisMonth=month($dtmLast);
	$dtmCursor= firstofmonthtimestamp($dtmLast);
	$dtmLastDayLastMonth=adddaystodate($dtmCursor, -1);
	$dtmFirstDayNextMonth=adddaystodate($dtmCursor, 1);
	$intWeekDayFirst=weekday($dtmCursor);
	//echo $dtmLast . "-" . $dtmCursor;
 
	//set $rst=MBrst("exec usp_a125Article_GetCalendar " & intSectionID & ",'" &  dtmLastDayLastMonth & "','" & dtmFirstDayNextMonth & "'");
	//i=1;
	//while (!$rst.eof)
	//{
		//$arrThis[day($rst("sdRelease"))]=$rst("iArticleID");
		//$i=$i+1;
		//$rst.movenext;
	//}
	$out="<table bgcolor=" . $colBG . " cellpadding=0 cellspacing=0 border=2>" . chr(13);
	$intWeekDay=1;
	$out=$out . "<tr>" . chr(13);
	$out=$out . "<td colspan=7>" . chr(13);
	$out=$out . monthname($dtmCursor) . " " . substr(year($dtmLast), 2,2);
	$out=$out . "</td>" . chr(13);
	$out=$out . "</tr>" . chr(13);
	$out=$out . "<tr>" . chr(13);
	$i=0;
	while (!($intWeekDay==$intWeekDayFirst or $i>33))
	{
		$out=$out . "<td>&nbsp;</td>" . chr(13);
		$intWeekDay++;
		$i++;
	}
	$intDay=1;
	$i=0;
	$intMonth=$intThisMonth;
	while (!($intMonth!=$intThisMonth or $i>32))
	{
		if (weekday($dtmCursor)==1)
		{
			$out=$out . "<tr>" . chr(13);
		}
		if  ($dtmCursor=time())
		{
			$strDisplayDate="<b>" . $intDay . "</b>";
		}
		else
		{
			$strDisplayDate=$intDay;
		}
		if ($arrThis[$intDay]!="")
		{
			if ($intArticleIDIn=$arrThis[$intDay]) 
			{
				$colThis=$colSelected;
			}
			else
			{
				$colThis=$colBg;
			}
			$out=$out . "<td bgcolor=" . $colThis . "><a href=" . $strPHP . "?thismonth=" . $dtmStart . "&articleid=" . $arrThis[$intDay] . ">" . $strDisplayDate . "</a></td>" . chr(13);
		}
		else
		{
			$out=$out . "<td>" . $strDisplayDate . "</td>" . chr(13);
		}
		if (weekday($dtmCursor)==7)
		{
			$out=$out . "</tr>" . chr(13);
		}
		$dtmCursor=adddaystodate($dtmCursor, 1);
		$intMonth=month($dtmCursor);
		$intDay=day($dtmCursor);
		$i++;
	}
	$i=0;
	while (!(weekday($dtmCursor)==1 or $i>8))
	{
		$out=$out . "<td>&nbsp;</td>" . chr(13);
		$dtmCursor=adddaystodate($dtmCursor, 1);
		$i++;
	}
	$out =$out . "</tr></table>" . chr(13);
	return($out);
}
?>