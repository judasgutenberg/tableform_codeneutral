<?php 

if(!function_exists("IncludeIfThere"))
{
	function IncludeIfThere($strFilename)
	{
		if(substr($strFilename, 0, 1)=="/")
		{
			$strFilename=$_SERVER["DOCUMENT_ROOT"] . $strFilename;
		}
		if (file_exists($strFilename))
		{
			require($strFilename);
		}
	}
}

function endswith($strIn, $what)
//Does $strIn end with $what?
{
	if (substr($strIn, strlen($strIn)- strlen($what) , strlen($what))==$what)
	{
		return true;
	}
	return false;
}

function beginswith($strIn, $what)
//Does $strIn begin with $what?
{
	if (substr($strIn,0, strlen($what))==$what)
	{
		return true;
	}
	return false;
}

function contains($strIn, $what)
//Does $strIn contain $what?
{
	if(is_array($strIn))
	{
		return false;
	}
	if ($strIn!="" && $what !="")
	{
		if (strpos($strIn, $what)===false)
		{
			return false;
		}
	}
	else
	{
		return false;
	}
	return true;
}

function userfeedback($content)
{
	$striptags=strip_tags($content);
	$strLimitspec="48-57 a-z A-Z _ ";
	$striptags=FilterString($striptags, $strLimitspec, "");
	$out="";
	if($striptags!="") 
	{
		$out="<div class=\"feedback\">" . $content . "</div>";
	}
	return $out;
}

function gracefuldecay()
//Go through the parameters and return the first that isn't empty. Incredibly useful!
{
	$intArgs =func_num_args();
	for($i=0; $i<$intArgs; $i++)
	{
		$option=func_get_arg($i);
		if ($option!="")
		{
			return $option;
		}
	}
}

function LabelThis($strComputedPrettyFieldName, $strSetPrettyFieldNames, &$connector, $record="", $strLabelOverride="", $intTruncSize=40)
//provides a pretty name of a recordset
//if no db $record is passed in, just return the computed array of pretty field names
//connector is returned by reference
{
	if($strLabelOverride!="")
	{
		$out=$strLabelOverride;
	}
	else
	{
		//echo "*" . $strSetPrettyFieldNames . "*<BR>";
		$strSetPrettyFieldNames=trim($strSetPrettyFieldNames);
		if(contains($strSetPrettyFieldNames, ","))
		{
			$arrNameFields=explode(",",  $strSetPrettyFieldNames);
			$connector=", ";
			
			//$arrNameFields=array_reverse($arrNameFields);
		}
		else if(contains($strSetPrettyFieldNames, " "))
		{
			$arrNameFields=explode(" ",  $strSetPrettyFieldNames);
			$connector=" ";
		}

		else if($strSetPrettyFieldNames=="")
		{
			$arrNameFields=Array($strComputedPrettyFieldName);
			$connector="";
		}
		else
		{
			$arrNameFields=Array($strSetPrettyFieldNames);
			$connector="";
		}
		$out="";
		if($record=="")
		{
			return $arrNameFields;
		}
		foreach($arrNameFields as $thisnamefield)
		{
			$out.=$record[$thisnamefield] . $connector;
		}
		$out=substr($out, 0, strlen($out)-strlen($connector));
	}
	$out = trunchandler($out, $intTruncSize);
	//echo $strLabelOverride  . "=<BR>";
	return $out;

}
 
function AppropriateSQLName($in)
//Take a user-chosen string and return something that could be used as a MySQL table name or field name
{
	$strLimitspec="48-57 a-z A-Z _ ";
	$in=FilterString($in, $strLimitspec, "_");
	if(inList("outer inner on key table where in real repeat write read label upgrade out leave then while with when right unique union left select create database update insert between blob call change column character case grant", strtolower( $in)))
	{
		$in="attempted_reserved_word";
	}
	return $in; 
}

function FilterString($strIn, $strLimitspec, $replacement)
//$strLimitspec is a dual-delimited string of ascii codes or characters. each range is separated by spaces
//the extremes of each limit are separated by -
{
	$arrLimit=explode(" ",$strLimitspec);
	$out="";
 	for($i=0; $i<strlen($strIn); $i++)
	{
		$chr=substr($strIn, $i, 1);
 
		$bwlHandled=false;
		foreach($arrLimit as $limitpair)
		{
			$chrOneLimit="";
			if(contains($limitpair, "-"))
			{
				$arrLimitSet=explode("-", $limitpair);
			}
			else
			{
				$chrOneLimit=$limitpair;
			}
			if (!$bwlHandled && ($chr==$chrOneLimit  || $chr>=ReturnCharacter($arrLimitSet[0])  && $chr<=ReturnCharacter($arrLimitSet[1])))
			{
				$out.=$chr;
				$bwlHandled=true;
			}
		}
		if(!$bwlHandled)
		{
			$out.=$replacement;
		}
	}
	return $out;
}

function ReturnCharacter($possibleASCIICode)
//If $possibleASCIICode is an ASCII code, turn it into a chr, otherwise return chr.
{
	if(strlen($possibleASCIICode)>1)
	{
		$out=chr($possibleASCIICode);
	}
	else
	{
		$out=$possibleASCIICode;
	}
	return $out;
}

function HandleNumericCasesInSpaceDelimitedChrString($quotechar)
//In a string of chrs, sometimes the chr is so weird it's passed in as an ASCII value.  Here we turn them all into chrs.
{
	$arrQuotes=explode(" ", $quotechar);
	$quotechar="";
	foreach($arrQuotes as $thisquote)
	{
		if(is_numeric($thisquote))
		{
			$quotechar.=chr($thisquote) . " ";
		}
		else
		{
			$quotechar.=$thisquote. " ";
		}
	}
	$quotechar=RemoveEndCharactersIfMatch($quotechar, " ");
	return $quotechar;
}

function multichrhandle($strIn)
//If a string contains ".", this expodes the string, interprets the parts as ASCII values, and returns it as a set of special chracters
{
	$out="";
	$arrIn=explode(".", $strIn);
	foreach($arrIn as $chr)
	{
		$out.=chr($chr);
	}
	return $out;
}

function GetBracketedContent(&$strIn, $chrStartBracket, $strEndBracket, $strQuote="' \"", $bwlRefHandback=false)
//returns the content within the brackets, starting from both ends and moving inward
{
	$out="";
	$bwlTheEasyWay=false;
	$bwlFrontQuote=false;
	$bwlBackQuote=false;
	$end=-1;
	$start=-1;
	if(contains($strIn,  $chrStartBracket) && contains($strIn,  $strEndBracket))
	{
		if($bwlTheEasyWay)//might step on quoted content
		{
			$start=strpos($strIn,  $chrStartBracket)+1;
			$end=strrpos($strIn,  $strEndBracket);
			
		}
		else //we parse the content from both ends, eliminating brackets in quoted regions
		{
			//for($i = 0; $i < intval((strlen($thisitem)+1)/2) ; $i++) \
			for($i = 0; $i <  strlen($strIn)+1 ; $i++) 
		 	{
				$chrFront=substr($strIn, $i, 1);
				$chrBack=substr($strIn, strlen($thisitem)-$i, 1);
				if(inList($strQuote, $chrFront) && !$bwlFrontQuote)
				{
					$bwlFrontQuote=true;
					$strFrontQuote=$chrFront;
				}
				
				else if($bwlFrontQuote)
				{
					if($chrFront==$strFrontQuote)
					{
						$bwlFrontQuote=false;
					
					}
				
				}
				else
				{
					if($chrFront==$chrStartBracket)
					{
						if($start==-1)
						{
							$start=$i+1;
						}
					}
				}
				
				
				if(inList($strQuote, $chrBack) && !$bwlBackQuote)
				{
					$bwlBackQuote=true;
					$strBackQuote=$chrBack;
				}
				else if($bwlBackQuote)
				{
					if($chrBack==$strBackQuote)
					{
						$bwlBackQuote=false;
					
					}
				
				}
				else
				{
					if($chrBack==$strEndBracket)
					{
						if($end==-1)
						{
							$end= strlen($strIn)-$i;
						}
					}
				}
			
			}
			//echo "$";
			$out=substr($strIn, $start, intval($end-$start));
			if($bwlRefHandback)
			{
				$strIn=substr($strIn,0,$start-1) . substr($strIn,1+$end);
			}
		}
		
	}
	return $out;
}

function FindDollarVariables($strIn)
//returns all variables of the form $variable in an array, mostly skipping quoted areas
{
	//echo $strIn . "<br>";
	
	$arrTemp=ParseStringToArraySkippingQuotedRegions($strIn,  "'\"",  "$") ;
	//$arrTemp=BetterExplode("$", $data,   "\" '",  false,  "csv");
	$count=0;
	//echo count( $arrTemp);
	//echo $arrTemp[1] . "*<br>";
	$tempcursor=0;
	foreach($arrTemp as $thisitem)
	{
		//echo $thisitem . "--<br>";
		$thisOut="";
		for($i = 0; $i < strlen($thisitem)+1; $i++) 
		{
			$chrThis=substr($thisitem, $i, 1);
			//echo $chrThis . "<br>";
			$intAscii=ord(strtoupper($chrThis));
			//echo $intAscii . "<br>";
			if($intAscii>64  && $intAscii<91  || $intAscii>47  && $intAscii<58  || $intAscii==95)
			{
				//echo $chrThis . "-<br>";
				$thisOut.=$chrThis;
				//echo $thisOut . "=<br>";
			}
			else
			{
				break;
			}
		}
 		if($tempcursor>0)
		{
			if($thisOut!="")
			{
				$arrOut[$count]=trim($thisOut);
				//echo $thisOut . "<BR>";
				$count++;
			}
		}
		
		$tempcursor++;
	}
	return $arrOut;
}

function ParseStringToArraySkippingQuotedRegions($strIn, $quote="'", $delimiter=";", $escapecharacter="\\", $arrQuoteCorrectingSequences="usual") 
//Judas Gutenberg Jan 4 2007
//Go through, say, SQL and find the commands and put them in an array
//carefully overlooking semicolons inside quotes
//Dec 1, 2008: added some code to allow the parser to fix misplaced single quotes in the text
{
	$strIn.= $delimiter;
	$newString = "";
	$inQuotes = false;
	$arrOut=Array();
	$intLastDelimiterPos=0;
	$outCount=0;
	$chrSub=chr(4);
	$strLen=strlen($strIn);
	if($arrQuoteCorrectingSequences=="usual"  )
	{
 
		$arrQuoteCorrectingSequences=Array(" ", ",", ")",";");
	}
   	for($i = 0; $i < strlen($strIn)+1; $i++) 
	{
        if(substr($strIn,$i,strlen($quote)) == $quote  &&  substr($strIn,$i-1,strlen($escapecharacter)) != $escapecharacter) 
		{
			$bwlQuoteFail=false;
	 		 
			if($inQuotes &&  is_array($arrQuoteCorrectingSequences))
			{
				$bwlFoundACorrectingSequence=false;
				foreach($arrQuoteCorrectingSequences as $strQuoteCorrectingSequence)
				{
					//echo "[" . $strQuoteCorrectingSequence . "]<br>";
					$bwlNextMatchCorrectingSequence=true;
					for($j=0; $j<strlen($strQuoteCorrectingSequence); $j++)
					{
						//echo "<font color=red>" . $j . " ="  . substr($strIn,$j+$i+strlen($quote),1) .   "= -" . substr($strQuoteCorrectingSequence,$j,1) . "-</font><br>";
						if(substr($strIn,$j+$i+strlen($quote),1)!=substr($strQuoteCorrectingSequence,$j,1)  &&  $j+$i+strlen($quote)<=strlen($strIn)-1)
						{
							//echo "<font color=orange>*</font><br>";
							$bwlNextMatchCorrectingSequence=false;
						}
						else
						{
							//echo "<font color=green>*</font><br>";
						}
					
					}
		
					if($bwlNextMatchCorrectingSequence)
					{
						$bwlFoundACorrectingSequence=true;
						//echo "&&";
					}
			 
				}
				if(!$bwlFoundACorrectingSequence)
				{
					//echo "<br>!<br>";
					$strIn=substr($strIn, 0, $i) . str_pad("", strlen($quote),  $chrSub) . substr($strIn,   $i + strlen($quote));
					$bwlQuoteFail=true;
				}
			}
			if(!$bwlQuoteFail)
			{
				$inQuotes =!$inQuotes;
			}
		}
		if(!$inQuotes)
		{ 
			if(substr($strIn,$i,strlen($delimiter)) == $delimiter  || $i==$strLen)
			{
				$strThisCommand=RemoveEndCharactersIfMatch(substr($strIn, $intLastDelimiterPos, ($i-$intLastDelimiterPos)), $delimiter);
				//echo "<br><font color=blue>" . $strThisCommand . "</font><br>";
				$strThisCommand=str_replace(str_pad("", strlen($quote), $chrSub),  "\\" . $quote, $strThisCommand);
				//echo "<br><font color=green>" . $strThisCommand . "</font><br>";
				$intLastDelimiterPos=$i;
				$arrOut[$outCount]=$strThisCommand;
				$outCount++;
			}
		}
	}
 	return $arrOut;
}

//$arr= BetterExplode(",|", "man,|chicken,|'dog',horse'dog',|friend,|ape,|peter'pan',|peter'pan',|'pan'peter,|'dog'",  $quotechar="\" '");
//$arr= BetterExplode(',', 'Dr. Eugene H. and Esther C. Herman,,125.00,1/4 page,1/31/2010,Primack Tribute,"Congratulations. You are special people, and we know you will continue your tireless efforts for the Jews of the world. Our dream is to take a trip with you and observe your fine work first hand. ~ Eugene and Esther Herman",1/31/2010,511 New York Ave,Takoma Park,MD,20912,United States,"Herman, Gene & Esther",(301) 585-5832,esther511@aol.com,,General', "\"");
//foreach($arr as $a)
{
	//echo "=" . $a . "=<BR>";
}

function BetterExplode($delimiter, $data,  $quotechar="\" '", $bwlLeaveQuotesInPlace=false, $strEscapeStyle="csv", $bwlDelmiterCaseInsensitive=true, $delimiterprefixnixlist="", $chrQuoteOverwrite="", $chrPHPCommentOverwrite="", $chrNonQuoteOverwrite="", $chrEndQuoteToStripFromData="")
//Judas Gutenberg November 28 2007
//moves through data character by character breaking on delimiters so quoted characters are not mistaken as delimiters
//$quotechar can be a space-delimited series of acceptable quotes, though they cannot be mixed when 
//quoting a particular string
//think of it as a more complicated version of explode
//as of December 12 2007 this function handles multi-char delimiters (MCDs) too
//March 3 2010:  now mops-up unquoted strings between delimiters and returns them  as well in situations where quoted strings are being sought
//this uses the variable $strMop
{
	$bwlCommentOn=false;
	$intDelimiterChrCount=0;
	//handle quotes being passed in as ascii values:
	$quotechar=HandleNumericCasesInSpaceDelimitedChrString($quotechar);

	$bwlPossibleMCD=false;
	$bwlGoWithBigMop=false;
	if (contains($delimiter, "."))
	{
		$delimiter=multichrhandle($delimiter);
	}
	else if (is_numeric($delimiter))
	{
		$delimiter=chr($delimiter);
	}
	$arrOut=Array();
	if($quotechar=="")
	{
		$bwlQuoteOn=true;
	}
	else
	{
		$bwlQuoteOn=false;
	}
	$testdelimiter=$delimiter;
	if($bwlDelmiterCaseInsensitive)
	{
		$testdelimiter=strtolower($delimiter);
	}
	$intArrCursor=0;
	$chrKnownQuote="";
	$chrQuoteToBeEscaping="";
	$strTempPossibleDelimeter="";
	$thisvar="";
	$strMop="";
	$strBigMop="";
	for($i=0; $i<strlen($data); $i++)
	{

		$chr=substr($data, $i, 1);
		$tchr=$chr;
		if($bwlDelmiterCaseInsensitive)
		{
			$tchr=strtolower($chr);
		}
		$dchr=substr($testdelimiter, $intDelimiterChrCount, 1);
		if($i+1<strlen($data))
		{
			$chrNext=substr($data, $i+1, 1);
		}
		else
		{
			$chrNext="";
		}
		if($i-1>-1)
		{
			$chrPrev=substr($data, $i-1, 1);
		}
		else
		{
			$chrPrev="";
		}
		//php comment handling
		if($strEscapeStyle=="php")
		{
			if( $chr=="/"  && $chrNext=="/" && !$bwlQuoteOn  && !$bwlCommentOn)
			{
				$bwlCommentOn=true;
				if($chrPHPCommentOverwrite!="")
				{
					$thisvar.=$chrPHPCommentOverwrite;
				}
				else
				{
					$thisvar.=$chr;
					$strBigMop.=$chr;
				}
				
			}
	
			else if( $chr==chr(13)  && !$bwlQuoteOn  && $bwlCommentOn)
			{
				$bwlCommentOn=false;
				$thisvar.=$chr;
				$strBigMop.=$chr;
			}
			else if($bwlCommentOn)
			{
				if($chrPHPCommentOverwrite!="")
				{
					$thisvar.=$chrPHPCommentOverwrite;
				}
				else
				{
					$thisvar.=$chr;
					$strBigMop.=$chr;
				}
			}
			
		}
		if(!$bwlCommentOn)
		{
			if(!$bwlPossibleMCD)
			{
				if($tchr==$dchr    &&  (!$bwlQuoteOn  || $quotechar=="")  && !inList($delimiterprefixnixlist, $chrPrev))
				{
					$bwlPossibleMCD=true;
					$strTempPossibleDelimeter.=$chr;
					$intDelimiterChrCount++;
				}
			}
			else
			{
				if($tchr==$dchr    &&  (!$bwlQuoteOn  || $quotechar==""))
				{
					$intDelimiterChrCount++;
					$strTempPossibleDelimeter.=$chr;
				}
				else
				{
					//echo "<p>$<p>";
					$bwlPossibleMCD=false;
					//we've not been adding to the content of this delimited item
					//because it began with the first several characters of a 
					//multichar delimiter (MCD).  so we have to take those first
					//few chrs and add them to $thisvar.
					$thisvar.=$strTempPossibleDelimeter;
					$strBigMop.=$strTempPossibleDelimeter;
					$strTempPossibleDelimeter="";
					$intDelimiterChrCount=0;
				}
				
				
			}
			
			if($bwlPossibleMCD )//MCD means multi-chr delimiter
			{	
				
				if($intDelimiterChrCount==strlen($delimiter))
				{
					//echo $thisvar . "\n";
					if($chrEndQuoteToStripFromData!="")
					{
						$thisvar=RemoveEndCharactersIfMatch($thisvar, $chrKnownQuote);
						$strBigMop=RemoveEndCharactersIfMatch($strBigMop, $chrKnownQuote);
					}
					if($bwlGoWithBigMop )
					{
						$arrOut[$intArrCursor]=$strBigMop;
						
					}
					else
					{
						if($thisvar=="")
						{
							$arrOut[$intArrCursor]=$strBigMop;
						}
						else
						{
						
							$arrOut[$intArrCursor]=$thisvar;
							
						}
					}
					$strBigMop="";
					$strMop="";
					$intArrCursor++;
					$thisvar="";
					$intDelimiterChrCount=0;
					$strTempPossibleDelimeter="";
					$bwlPossibleMCD =false;
					$bwlGoWithBigMop=false;
					//echo "-" . $strMop . "-<P>";
		
					
				}
			 	else //extra characters that proved not to be part of the multichr delimiter
				{
					//these are actually handled elsewhere so we can't do the next two lines
					//$thisvar.=$chr;
					//$strBigMop.=$chr;
				}
				
			 

			}
			else if (!$bwlQuoteOn  && ($chrKnownQuote=="" && inList($quotechar, $chr) || $chrKnownQuote==$chr))
			{
				//echo "<BR>|" . $chr . "|" . substr($data, $i-11, 10) .  "<font color=red>" . substr($data, $i, 1) . "</FONT>" . substr($data, $i+1, 10) . "";
				if(strlen($strBigMop)>0)
				{
					$bwlGoWithBigMop=true;
					//echo "<FONT COLOR=green>" . $strBigMop . "</font>";
				}
				$strBigMop.=$chr;
				$bwlQuoteOn=true;
				$chrKnownQuote=$chr;
				if($bwlLeaveQuotesInPlace)
				{
					$thisvar.=$chr;
					//echo "<font color=blue>*</font>";
					//$strBigMop.=$chr;
				}
				//echo "<BR>";
				
			}
			else if ($bwlQuoteOn)
			{	
			
				//$chrPrev catches the situation in which the backslash is itself escaped
				if($chr=="\\"  && $strEscapeStyle=="php"  && $chrPrev!="\\")
				{
					if($chrNext==$chrKnownQuote)
					{
						$chrQuoteToBeEscaping=$chrNext;
					}
				}
				else if($chrKnownQuote=="" && inList($quotechar, $chr) || $chrKnownQuote==$chr) //only for csv escapes
				{
					//$strBigMop.=$chr; //too many times!!
					//handle internally-escaped quotes, that is, a known quote escaping one immediately following in data
					if($chrQuoteToBeEscaping==$chr)
					{
						$chrQuoteToBeEscaping="";
						$thisvar.=$chr;
						$strBigMop.=$chr;
					}
					else if($chrNext==$chrKnownQuote  && $strEscapeStyle=="csv")
					{
						//was: $chrQuoteToBeEscaping=$chr;
						$chrQuoteToBeEscaping=$chrNext;
						if($bwlLeaveQuotesInPlace)
						{
							$thisvar.=$chr;
							$strBigMop.=$chr;
						}
					}
					else
					{
						$bwlQuoteOn=false;
						$chrKnownQuote="";
						if($bwlLeaveQuotesInPlace)
						{
							$thisvar.=$chr;
							$strBigMop.=$chr;
						}
					}
		 		}
		 		else //we're not a quote but we are a chr in a quoted section of text
				{
					if($chrQuoteOverwrite!="")
					{
						$thisvar.=$chrQuoteOverwrite;
					}
					else
					{
						$thisvar.=$chr;
						$strBigMop.=$chr;
					}
					
				}
	
			}
			else if($bwlLeaveQuotesInPlace)
			{
				$strMop.=$chr;
			//	$strBigMop.=$chr;//too many times!
				if($chrNonQuoteOverwrite=="")
				{
					$thisvar.=$chr;
					$strBigMop.=$chr;
				}
				else
				{
					$thisvar.=$chrNonQuoteOverwrite;
				}
			}
			else 
			{
				$strMop.=$chr;
				$strBigMop.=$chr;
				
			}
		}
		//echo $strMop . "-<BR>";
	}
	if($chrEndQuoteToStripFromData!="")
	{
		$thisvar=RemoveEndCharactersIfMatch($thisvar, $chrEndQuoteToStripFromData);
	}
	if($bwlGoWithBigMop )
	{
		$arrOut[$intArrCursor]=$strBigMop;
		
	}
	else
	{
		if($thisvar=="")
		{
			$arrOut[$intArrCursor]=$strMop;
			$strMop="";
		}
		else
		{
			$arrOut[$intArrCursor]=$thisvar;
		}
	}
	//echo "<div style='background-color:ff6600'>";
	//var_dump( $arrOut);
	//echo "</div>";
	return $arrOut;
}

function BlankOutQuotedAreas($data, $chrBlank, $quotechar="' \"", $chrPHPCommentBlank="")
//Whoever passes in $quotechar will want to have done
//$quotechar=HandleNumericCasesInSpaceDelimitedChrString($quotechar); 
//to it. i don't do that here since this function is done inside loops and 
//$quotechar=HandleNumericCasesInSpaceDelimitedChrString($quotechar) is somewhat expensive
//I take advantage of BetterExplode's parser to blank out the quoted areas
{
	$arrThis=BetterExplode(" ", $data,  $quotechar="\" '", true,  "csv", true, "", $chrBlank, $chrPHPCommentBlank);
	$out=implode(" ", $arrThis);
	return $out;
}

function PosInList($strList, $strProspect, $strDelimiter=" ", $bwlIgnoreCase=true, $quotechar="' \"", $bwlMakeSureNoFalsePositiveInsideMatches=true)
//Search for each item of $strList in $strProspect and returns first found strpos or -1 if nothing
{
	$arrList=explode(" ", $strList);
	$maybeout=-1;
	if($quotechar!="")
	{
		$bwlIgnoreQuotedAreas=true;
	}
	else
	{
		$bwlIgnoreQuotedAreas=false;
		$quotechar=HandleNumericCasesInSpaceDelimitedChrString($quotechar);
	}
	if($bwlIgnoreCase)
	{
		$strList=strtolower($strList);
		$strProspect=strtolower($strProspect);
	}
	foreach($arrList as $strToTest)
	{
		if(! $bwlIgnoreQuotedAreas)//fast algorithm for cases where quoted areas don't need to be ignored
		{
			if(contains($strProspect, $strToTest))
			{
				//i added 1 here to get something to work right but i'm not sure it's the right thing to do
				if($bwlMakeSureNoFalsePositiveInsideMatches)
				{
					//this code makes sure that the sql keyword being sought is not just the beginning or ending of some larger word
					if(!IsItemWithinWord($strToTest,$strProspect))
					{
						return strpos($strProspect, $strToTest) + 1;
					}
				} 
				else
				{
					return strpos($strProspect, $strToTest) + 1;
				}
			
			}
		}
		else//got to do the slow-ass algorithm
		{
			//echo "<br>preblankedout: " . $strProspect . "<br>";
			$strProspect=BlankOutQuotedAreas($strProspect, "*", $quotechar);
			//echo "<br>blankedout: " . $strProspect . "<br>";
			//echo $strToTest . "==totest<br>";
			//echo $strProspect . "------------" . $strToTest . "==prospect/totest<br>";
			if(contains($strProspect, $strToTest))
			{
				//i added 1 here to get something to work right but i'm not sure it's the right thing to do

				if($bwlMakeSureNoFalsePositiveInsideMatches)
				{
					//this code makes sure that the sql keyword being sought is not just the beginning or ending of some larger word
					if(!IsItemWithinWord($strToTest,$strProspect))
					{
						return strpos($strProspect, $strToTest) + 1;
					}
				} 
				else
				{
					return strpos($strProspect, $strToTest) + 1;
				}
			}
		}
	}

	return -1;
}

function IsItemWithinWord($item,$context)
{
	$out=false;
	$intNextCharPos=strpos($context, $item)+strlen($item);
	$chrNextPos=substr($context,$intNextCharPos,1);
	$intPreviousCharPos=strpos($context, $item)-1;
	$chrPrevPos=substr($context,$intPreviousCharPos,1);
	//echo "<br>" . $context . "+" .  $item . "-" . $chrNextPos  . "#" . $chrPrevPos . "-" ;
	//if($chrNextPos===false && $chrPrevPos===false)//this line of code is probably logically wrong
	//{
		//$out= false;
	//}
	if(CouldNotBeADelimiter($chrNextPos) || CouldNotBeADelimiter($chrPrevPos) )
	{
		$out= true;
	}
	//echo $item . "###" . $context . "@@@" . $out . "<br>";
	return $out;
}

function CouldNotBeADelimiter($chrIn)
{
//is $chrIn a letter or a number or a _?
	$intIn=ord(strtoupper($chrIn));
	if(($intIn>47  && $intIn<58) || ($intIn>64  && $intIn<91)  || $intIn==95)
	{
		return true;
	}
	return false;
}

   
function CountOccurence($strIn, $strSought)
{
//counts instances of $strSought in $strIn
	$intOut=0;
   	for($i = 0; $i < strlen($strIn)+1; $i++) 
	{
		$thisChar=substr($strIn,$i,strlen($strSought));
 		if($thisChar==$strSought)
		{
			$intOut++;
			$i=$i+strlen($strSought)-1;
		}
	}
	return $intOut;
}

function appendwordifnotthere($strConfig, $word,$wordtoeliminate="", $strDelimiter="", $mode="postpend")
{
//looks at $strConfig, which may or may not be delimited by  $strDelimiter, and see if it contains $word.  if not, it appends it, possibly separated by $strDelimiter
//also, get rid of $wordtoeliminate if present
	//echo $strConfig . "<br>";
	if($strConfig=="")
	{
		//don't bother with a delimiter if strConfig is already empty
		$strDelimiter="";
	}
	if($mode=="postpend")
	{
		if(!contains($strConfig, $strDelimiter . $word))
		{
			$strConfig=$strConfig . $strDelimiter . $word;
		}
		$strConfig=str_replace($strDelimiter . $wordtoeliminate, "" , $strConfig);
	}
	else
	{
		if(!contains($strConfig,  $word . $strDelimiter))
		{
			$strConfig=  $word .$strDelimiter . $strConfig ;
		}
		$strConfig=str_replace( $wordtoeliminate . $strDelimiter, "" , $strConfig);
	}
	//echo $strConfig . "=<br>";
	return $strConfig;
}

function FixFormulaForEval($strFormula, $bwlLeaveDollars=false)
{
	$strFormula=str_replace("&#40;",  "(", $strFormula);
	$strFormula=str_replace("&#41;",  ")", $strFormula);
	$strFormula=str_replace("&#63;",  "?", $strFormula);
	$strFormula=str_replace("&#39;",  "'", $strFormula);
	$strFormula=str_replace("&#lt;",  "<", $strFormula);
	$strFormula=str_replace("&#gt;",  ">", $strFormula);
	$strFormula=str_replace("&lt;",  "<", $strFormula);
	$strFormula=str_replace("&gt;",  ">", $strFormula);
	if(!$bwlLeaveDollars)
	{
		$strFormula=str_replace("$",  "", $strFormula);
	}
	$strFormula=str_replace("\'",  "'", $strFormula);
	return $strFormula;
}


function DownloadPage($out, $strFilename="test.txt", $bwlDisable=false)
{
	$len=strlen($out);
	if(!$bwlDisable)
	{
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: public"); 
		header("Content-Description: File Transfer");
		header("Content-Type: application/gzip");
		header("Content-Disposition: attachment; filename=" . $strFilename  .";");
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: ".$len);
		echo $out;
	}
	die();
}

function httpSocketConnection($host, $method, $path, $data)
//make a socket connection
{
	$method = strtoupper($method);       
	$path=trim($path);
	$data=trim($data);
	if ($method == "GET")
	{
		$path.= '?'.$data;
	} 
	else if($method == "NONE")
	{
		
	}  
	$filePointer = fsockopen($host, 80, $errorNumber, $errorString);
	if (!$filePointer)
	{
		//logEvent('debug', 'Failed opening http socket connection: '.$errorString.' ('.$errorNumber.')<br/>\n');
		echo "failure with " . $host  . $path . "<BR>";
		return false;
	}
	$requestHeader = $method." ".$path."  HTTP/1.1\r\n";
	$requestHeader.= "Host: ".$host."\r\n";
	//$requestHeader.= "Method: ".$method."\r\n";
	$requestHeader.= "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1) Gecko/20061010 Firefox/2.0\r\n";
	$requestHeader.= "Content-Type: application/x-www-form-urlencoded\r\n";
	
	if ($method == "POST")
	{
		$requestHeader.= "Content-Length: ".strlen($data)."\r\n";
	}
	$requestHeader.= "Connection: close\r\n\r\n";
	if ($method == "POST")
	{
		$requestHeader.= $data;
	}  
	
	fwrite($filePointer, $requestHeader);
	$responseHeader = '';
	$responseContent = '';
	do
	{
		$responseHeader.= fread($filePointer, 1);
	}
	while (!preg_match('/\\r\\n\\r\\n$/', $responseHeader));
	
	
	if (!strstr($responseHeader, "Transfer-Encoding: chunked"))
	{
		while (!feof($filePointer))
		{
			$responseContent.= fgets($filePointer, 128);
		}
	}
	else
	{
		while($chunk_length = hexdec(fgets($filePointer)))
		{
			$responseContentChunk = '';
			$read_length = 0;
			while ($read_length < $chunk_length)
			{
				$responseContentChunk .= fread($filePointer, $chunk_length - $read_length);
				$read_length = strlen($responseContentChunk);
			}
			$responseContent.= $responseContentChunk;
			fgets($filePointer);
		}
	
	}
	return chop($responseContent);
}

function inList($strList, $item, $MatchOnlyType="", $strDelimiter=" ") 
//look to see if item is in the space-delimited (or other-delimited) strList (similar to my ASP version)
{
	$arrThis=explode($strDelimiter, $strList);
	for ($t=0; $t<count($arrThis); $t++)
	{
		$thislen=strlen($arrThis[$t]);
		if($MatchOnlyType=="last")
		{
			if ($arrThis[$t]==substr($item, strlen($item)-$thislen))
			{
				return true;
			}	
		}
		else if ($MatchOnlyType=="first")
		{
			if ($arrThis[$t]==substr($item, 0,$thislen))
			{
				return true;
			}	
		}
		else
		{
			if ($arrThis[$t]==$item)
			{
				return true;
			}
		}
	}
	return false;
}

function eliminatedAlphanumericWords($in)
//filter out any words containing alphanumerics
{
 	$arrWords=explode(" ", trim($in));
	$strLimitspec="a-z A-Z _ ";
	$newSentence="";
	foreach($arrWords as $thisword)
	{
		$oldthisword=$thisword;
		$thisword=FilterString($thisword, $strLimitspec, " ");
		if($oldthisword==$thisword)
		{
			$newSentence.=" " . $thisword;
		}
	}
	$out =trim($newSentence);
	return $out;
}

function firstlettercapitalize($strIn, $bwlForceLowerCaseFirst=true)
{
	if($bwlForceLowerCaseFirst)
	{
		$strIn=strtolower($strIn);
	}
	return strtoupper(substr($strIn, 0, 1)) . substr($strIn, 1);

}

function pluralize($strIn)
//pluralize an english word, getting it right most of the time
//i had a bug in the original version that i fix here with the global pluralizationmethod
{
	$intLen=strlen($strIn);
	$endletter=substr(strtolower($strIn), $intLen-1, 1);
	$endtwoletter=substr(strtolower($strIn), $intLen-2, 2);
	$strESletters="s z c x";
	if (contains(pluralizationmethod,"new"))
	{
		$strESletters="s z x";
		if (inList("ay ey iy oy uy",$endtwoletter))
		{
			$out=$strIn. "s";
		}
		else if ($endletter=="y" )
		{
			$out=substr($strIn, 0, strlen($strIn)-1). "ies";
		}
	}
	if ($endletter=="y" )
	{
		$out=substr($strIn, 0, strlen($strIn)-1). "ies";
	}
	elseif (inList("sh ch",$endtwoletter))
	{
		$out=$strIn. "es";
	}
	elseif (inList($strESletters, $endletter))
	{
		$out=$strIn. "es";
	}
	else
	{
		$out=$strIn. "s";
	}
	if (endswith($strIn,"child"))
	{
		$out="children";
	}
	else if (endswith($strIn,"woman"))                                                                                                     
	{
		$out="women";
	}
	else if (endswith($strIn,"man"))
	{
		$out="men";
	}
	else if (endswith($strIn,"ox"))
	{
		$out="oxen";
	}
	else if (endswith($strIn,"mouse"))
	{
		$out="mice";
	}
	else if (endswith($strIn,"day"))
	{
		$out="days";
	}
	if (inList("news deer moose sheep keyart", $strIn, "last"))
	{
		$out=$strIn;
	}
	if (contains(pluralizationmethod,"new0"))
	{
		if (inList("media", $strIn, "last"))
		{
			$out=$strIn;
		}
		if ($strIn=="datum")
		{
			$out="data";
		}
	}
	return $out;
}

function PluralizeIfNecessary($subject, $number)
//If $number is 1, no need to plurazlize $subject.  Otherwise there is a need to.
{
	if ($number!=1)
	{
		return pluralize($subject);
	}
	return $subject;
} 

function IsAlreadyPlural($subject)
//Kinda stupid but it mostly works
{
	$subject=strtolower($subject);
	$out=false;
	$strPrePluralized="news deer moose sheep keyart oxen children men women mice";
	if (contains(pluralizationmethod,"new0"))
	{
		$strPrePluralized.=" media data";
	}
	$endletter=substr($subject, $intLen-1, 1);
	
	if($endletter=="s" || inList($strPrePluralized, $subject, "last"))
	{
		$out=true;	
	}
	return $out;
}

function forcePlural($subject)
//If it's plural, leave it alone.  If it's not, pluralize.
{
	$out=$subject;
	if(!IsAlreadyPlural($out))
	{
		$out=pluralize(	$out);
	}
	return $out;
}

function forceSingular($subject)
//If it's singular, leave it alone.  If it's not, singularize.
{
	$out=$subject;
	if(IsAlreadyPlural($out))
	{
		$out=singularize($out);
	}
	return $out;
}

function singularize($subject)
//Turns a plural word singular.
{
	$intLen=strlen($subject);
	$endletter=substr(strtolower($subject), $intLen-1, 1);
	$endtwoletter=substr(strtolower($subject), $intLen-2, 2);
	$endthreeletter=substr(strtolower($subject), $intLen-3, 3);
	$out=$subject;
	$lowered=strtolower($subject);
	if($endthreeletter=="ies")
	{
		$out=substr($subject, 0, strlen($subject)-3). "y";
	}
	else if (endswith($lowered,"news"))
	{
		$out=$subject;
	}
	else if (endswith($lowered,"men"))
	{
		$out=replaceend($subject, "man");
	}
	else if (endswith($lowered,"women"))
	{
		$out=replaceend($subject, "women");
	}
	else if (endswith($lowered,"data"))
	{
		$out=replaceend($subject, "datu"). "m";                                         
	}
	else if (endswith($lowered,"media")  && contains(pluralizationmethod,"new0"))
	{
		$out=replaceend($subject, "mediu") . "m";
	}
	else if ($endthreeletter=="ren")
	{
		$out=substr($subject, 0, strlen($subject)-3);
	}
	else if ($endtwoletter=="en")
	{
		$out=substr($subject, 0, strlen($subject)-2);
	}
	else if($endletter=="s")
	{
		$out=substr($subject, 0, strlen($subject)-1);	
	}                                                                                     
	return $out;
}

function replaceend($strIn, $strReplacement)
//Look at how many characters are in $strReplacement and then replace that number at the end of $strIn with $strReplacement.
{
	$out=substr($strIn, 0, strlen($strIn) - strlen($strReplacement)) . $strReplacement;
	return $out;
}

function probablepassword($in)
//If $in looks like an xcart password, the return true.
{
	$out=false;
	$in=trim($in);
	if(contains($in, "-"))
	{
		$arrThis=explode("-", $in);
		if( $arrThis[0]=="B"  && !contains($arrThis[1], " ")  && strlen($arrThis[1])>12)
		{                               
			$out=true;
		}
	}                    
	return $out;
}

function AllWhiteSpaceToSpace($strIn)
//Anything considered whitespace ends up as a space.
{
	$strWhiteSpaceChrs="13 9 10 0 11 8";
	$arrChrs=explode(" ", $strWhiteSpaceChrs);
	foreach($arrChrs as $intChr)
	{
		$strIn=str_replace(chr($intChr), " ",$strIn);
	}
	return $strIn;
}

function singlequoteescape($strIn)
//Escapes '
{
	
	$out=$strIn;
	//echo $out . "(== ==)";
	if (strlen($strIn)>0  )
	{
		//return str_replace("'", "\'", $strIn);
		//$oldErrorHandler=set_error_handler("TFErrorHandler");
			$oldErrorReporting=error_reporting(0);
			//$out= mysql_real_escape_string($strIn);
			//$arrError= error_get_last();
			if(is_array($arrError)  || 1==1)
			{
				 $out=str_replace("'", "&#39;", $strIn);
			}
			//foreach($arrError as $k=>$v)
			//{
				//echo $k . " " . $v . "<br>";
			//}
			error_reporting($oldErrorReporting);
		//set_error_handler($oldErrorHandler);
	}
	//echo $out . " <br>";
	return $out;
}

function doublequoteescape($strIn)
//Escapes "
{
	if (strlen($strIn)>0)
	{
		return str_replace('"', '&#34;', $strIn);
	}
}

function SuitableEnclosureQuote($strIn)
{
	//analyze a string to see what kind of quote it needs surrounding it
	//i will probably want to make this smarter at some point
	if(contains($strIn, "\""))
	{
		return "'";
	}
	return '"';
}


function escapeslash($strIn)
//Escapes \
{
	if (strlen($strIn)>0)
	{
		return str_replace("\\", "\\" . "\\", $strIn);
	}
}

function htmlcodify($strIn)
//Changes ' to &#34;
//and parentheses to &...
{
	$out="";
	if (strlen($strIn)>0)
	{
		$out= str_replace("'",  "&#39;", $strIn);
		$out=  str_replace("(",  "&#40;", $out);
		$out= str_replace(")",  "&#41;", $out);
		return $out;
	}
}

function forinputform($strIn)
//Changes ' to &#34;
{
	if (strlen($strIn)>0)
	{
		return str_replace(chr(34),  "&#34;", $strIn);
	}
}

function deescape($strIn)
//Deescapes \'
{
	if (strlen($strIn)>0)
	{
		$strIn=str_replace("\'", "'", $strIn);
		$strIn=str_replace("\'", "'", $strIn);
		$strIn=str_replace("\\&#39;", "&#39;", $strIn);
		$strIn=str_replace("\\" . chr(34), chr(34), $strIn);
		$strIn=str_replace("\\'", "&#39;", $strIn);
		return $strIn;
	}
}


function radicaldeescapenourl($strIn)
//Deescapes \'
{
	if (strlen($strIn)>0)
	{
		$strIn=deescape($strIn);
  		$strIn=str_replace("&#40;", "(", $strIn);
  		$strIn=str_replace("&#41;", ")", $strIn);
		$strIn=str_replace("&#39;", "'", $strIn);
		$strIn=str_replace("&#34;", "\"", $strIn);
		return $strIn;
	}
}

function radicaldeescape($strIn, $bwlEscapeSingleQuote=true)
//Deescapes \'
{
	if (strlen($strIn)>0)
	{
		$strIn=deescape($strIn);
  		$strIn=str_replace("&#40;", "(", $strIn);
  		$strIn=str_replace("&#41;", ")", $strIn);
		$strIn=str_replace("&#39;", "'", $strIn);
		$strIn=str_replace("&#34;", "\"", $strIn);
		if($bwlEscapeSingleQuote)
		{
			$strIn=str_replace("'", "%27", $strIn);
		}
		return $strIn;
	}
}

function deendquote($strIn, $bwlAlsoRemoveDoubleQuotes=false)
//Removes end quotes
{
	if (substr($strIn, 0, 1)=="'")
	{
		$strIn=substr($strIn, 1, strlen($strIn));
	}
	if (substr($strIn, strlen($strIn)-1, 1)=="'")
	{
		$strIn=substr($strIn, 0, strlen($strIn)-1);
	
	}
	if($bwlAlsoRemoveDoubleQuotes)
	{
		if (substr($strIn, 0, 1)=='"')
		{
			$strIn=substr($strIn, 1, strlen($strIn));
		}
		if (substr($strIn, strlen($strIn)-1, 1)=='"')
		{
			$strIn=substr($strIn, 0, strlen($strIn)-1);
		
		}
	}
	return $strIn;
}

function parseBetween($strIn, $strStart, $strEnd, $intStartingAt=0, $bwlTillEndIfEndNotFound=false, $bwlCaseInsensitive=false)
//A great function for returning the string between two known strings ($strStart, $strEnd) within $strIn
//modified 10-2-2007 to take "" as $strEnd to look for cases where there is no $strEnd and we want to get everything to the end
//Also takes "" for $strStart to return stuff from beginning of $strIn
{
	$pos1=0;
	$pos2=0;
	$bwlstrStartNotFound=false;
	$found="";
	if($strStart=="")
	{
		$pos1=0;
	}
	else
	{
		if($bwlCaseInsensitive)
		{
			$strBasisPos1=stripos($strIn, $strStart, $intStartingAt);
		}
		else
		{
			$strBasisPos1=strpos($strIn, $strStart, $intStartingAt);
		}
		if($strBasisPos1===false)
		{
			$bwlstrStartNotFound=true;
		}
		else
		{
			$pos1 = $strBasisPos1 + strlen($strStart);
		}
	}
	//echo $strIn. " " . $strStart . " " . $strBasisPos1 . " " .  intval($pos1+1) . " " . strlen($strIn) . "<BR>";
	if ($pos1<strlen($strIn)  && 	!$bwlstrStartNotFound)//used to be $pos+1<strlen.... but that wasn't working
	{
		if($strEnd=="")
		{
			
			$pos2=strlen($strIn);
		}
		else if($bwlTillEndIfEndNotFound &&   !strpos($strIn,$strEnd, $pos1) &&  !$bwlCaseInsensitive)
		{
			$pos2=strlen($strIn);
		}
		else if($bwlTillEndIfEndNotFound &&   !stripos($strIn,$strEnd, $pos1) &&  $bwlCaseInsensitive)
		{
			$pos2=strlen($strIn);
		}
		else
		{
			if($bwlCaseInsensitive)
			{
				$pos2 = stripos($strIn, $strEnd, $pos1);
			}
			else
			{
				$pos2 = strpos($strIn, $strEnd, $pos1);;
			}
		
	 
		}
	 
		 
	}
	else
	{
	//echo "-" . $strEnd . "-";
	}
	if ($pos1<$pos2)
	{
		$found=substr($strIn, $pos1, ($pos2-$pos1));
	}
	return($found);   
}
function parseTwoPartBetween($strIn, $strStart, $strStartEnd, $strEnd)
{
	//A complex parser that looks for $strStart followed at some point by $strStartEnd, at which point it returns everything from the end of $strStartEnd to the beginning of $strEnd
//this is useful for certain HTML and XML parsing operations, where you know how a tag begins and ends, but not what is in the middle, and you also know precisely what you are 
//looking for at the end of what you seek.
//i've tried to write this function several times and this is the first time i've managed to pull it off
//December 18, 2008 Judas Gutenberg
//totally rewritten from scratch October 25, 2011 to fix a serious bug
	$bwlInData=false;
	$intStartCursor=0;
	$intStartEndCursor=0;
	$intEndCursor=0;
	$bwlPossiblyInEnd=false;
	$bwlPossiblyInStart=false;
	$bwlPossiblyInStartEnd=false;
	$bwlBetweenStartAndStartEnd=false;
	$out="";
	$provisional="";
	for($i = 0; $i < strlen($strIn)+1; $i++) 
	{
		//echo $chr . " " .  $bwlInData . ":" . $intStartEndCursor. "-" . $bwlBetweenStartAndStartEnd . "\n";
		$chr=substr($strIn,$i,1);
		if($bwlInData)
		{
			$chrEnd=substr($strEnd,$intEndCursor,1);
			if($chr==$chrEnd  && ($intEndCursor==0 || $bwlPossiblyInEnd))
			{
				$intEndCursor++;
				$bwlPossiblyInEnd=true;
				 
				if($intEndCursor==strlen($strEnd))
				{
					return $out ;
				}
			 	$provisional.=$chr;
		 
			}
			else
			{
				$bwlPossiblyInEnd=false;
				$intEndCursor=0;
				if($provisional!="")
				{
					$out.= $provisional;
					$provisional="";
				}
				$out.=  $chr;
			}	
		}
		else //not in bwldata
		{
			if($chr==substr($strStart,$intStartCursor,1))
			{
				$bwlPossiblyInStart=true;
				$intStartCursor++;
				
			}
			else if($bwlPossiblyInStart && $chr!=substr($strStart,$intStartCursor,1)) //started okay but character bad
			{
				$bwlPossiblyInStart=false;
				$intStartCursor=0;
				
			}
			if($intStartCursor==strlen($strStart) && $bwlPossiblyInStart)
			{
				$bwlBetweenStartAndStartEnd=true;
				$bwlPossiblyInStart=false;
			}
			
	 		if($bwlBetweenStartAndStartEnd)
	 		{
	 			
	 			if($chr==substr($strStartEnd,$intStartEndCursor,1))
				{
					$bwlPossiblyInStartEnd=true;
					$intStartEndCursor++;
				}
				else if($bwlPossiblyInStartEnd && $chr!=substr($strStartEnd,$intStartEndCursor,1)) //started okay but character bad
				{
					$bwlPossiblyInStartEnd=false;
					
					$intStartEndCursor=0;
					//$out.=$chr;
				}
	 			if($intStartEndCursor==strlen($strStartEnd)  && $bwlPossiblyInStartEnd)
				{
					$bwlInData=true;
					$bwlPossiblyInStartEnd=false;
				}
	 		}
		}
	}
	return $out;
}



function BADVERSIONparseTwoPartBetween($strIn, $strStart, $strStartEnd, $strEnd)
//HAS A BUG! ignores the second and third chars of strstart, etc.
//A complex parser that looks for $strStart followed at some point by $strStartEnd, at which point it returns everything from the end of $strStartEnd to the beginning of $strEnd
//this is useful for certain HTML and XML parsing operations, where you know how a tag begins and ends, but not what is in the middle, and you also know precisely what you are 
//looking for at the end of what you seek.
//i've tried to write this function several times and this is the first time i've managed to pull it off
//December 18, 2008 Judas Gutenberg
{	
	$bwlInData=false;
	$bwlInStart=false;
	$intStrStart=0;
	$intStrStartEnd=0;
	$intEnd=0;
	$found="";
	$bwlPossiblyInstrStart=false;
	$bwlPossiblyInstrStartEnd=false;
	$bwlPossiblyInEnd=false;
	$foundprovisional.="";
	//$strIn= $strIn;
	for($i = 0; $i < strlen($strIn)+1; $i++) 
	{
		//echo $intStrStart . "\n";
		$chr=substr($strIn,$i,1);
		
		
		$chrEnd=substr($strEnd,$intEnd,1);
		if($bwlInData)
		{
			//echo $chr . "\n";
			if(!$bwlPossiblyInEnd)
			{
				if($chrEnd==$chr)
				
				{
					$bwlPossiblyInEnd=true;
					$intEnd++;
					$foundprovisional.=$chr;
				}
				else
				{
					$found.=$chr;
					$intEnd=0;
				}
			}
			else
			{
				if($chrEnd==$chr)
				
				{
					$bwlPossiblyInEnd=true;
					$foundprovisional.=$chr;
					$intEnd++;
				}
				else
				{
					$bwlPossiblyInEnd=false;
					$found.=$foundprovisional;
					$found.=$chr;
					$foundprovisional="";
				}
			}
			if($bwlPossiblyInEnd && $intEnd>=strlen($strEnd))
			{
				return $found;
			}
			
		}
		else //not in data
		{
			
			if(!$bwlInStart  && !$bwlInData   && !$bwlPossiblyInstrStart)
			{
				$intStrStart=0;
			}
			$chrStrStart=substr($strStart,$intStrStart,1);
			$chrStrStartEnd=substr($strStartEnd,$intStrStartEnd,1);
			if(!$bwlPossiblyInstrStart  && !$bwlInStart && !$bwlInData)
			{
				if($chr==$chrStrStart)
				{
					$bwlPossiblyInstrStart=true;
					$intStrStart++;
				}
		
			
			}
			elseif($bwlPossiblyInstrStart)
			{
				$intStrStart++;
			}
			else if($chr!=$chrStrStart && !$bwlInStart)
			{
				$bwlPossiblyInstrStart=false;
				$intStrStart=0;
			}
	
			if($intStrStart>=strlen($strStart))
			{
				$bwlInStart=true;
				$bwlInData=false;
				$bwlPossiblyInstrStart=false;
				$intStrStart=0;
			}
			if($bwlInStart  && !$bwlPossiblyInstrStartEnd)
			{
				$intStrStartEnd=0;
				if($chrStrStartEnd==$chr)
				{
					$bwlPossiblyInstrStartEnd=true;
					$intStrStartEnd++;
				}
				
			}
			else if($bwlPossiblyInstrStartEnd)
			{
				if($chrStrStartEnd==$chr)
				{
					$bwlPossiblyInstrStartEnd=true;
					$bwlInStart=false;
					$intStrStartEnd++;
				}
				else
				{
					$bwlPossiblyInstrStartEnd=false;
					$intStrStartEnd=0;
				}
			}
			//echo strlen($strStartEnd) . "\n";
			if($intStrStartEnd>=strlen($strStartEnd)  )
			{
				$bwlInData=true;
				$bwlPossiblyInstrStartEnd=false;
				$bwlInStart=false;
				$intStrStartEnd=0;
			}
		 
		}
		//echo $chr . "= " . $chrStrStart . " " . $chrStrStartEnd . " " .  $chrEnd . " start:" . $intStrStart . " startend:" . $intStrStartEnd . " end:" . $intEnd  . " instart:" . $bwlInStart . " indata:" .  $bwlInData." bwlPossiblyInstrStart:" . $bwlPossiblyInstrStart . " bwlPossiblyInstrStartEnd:"  .$bwlPossiblyInstrStartEnd  ." bwlPossiblyInEnd:" . $bwlPossiblyInEnd .  "<br>found:<font color=red>|" . $found . "|</font>Foundprovisional:<font color=blue>|" . $foundprovisional . "|</font><br>";
	}
	return($found);  
}

//$str='<tggo    opd><tgg>   dd ddd <th pool="msak dfsdfs sdf sda">omega fats</th></tr></th><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/> 
//<meta http-equiv="cache-control" content="no-cache"/>';
//echo  "-" . parseTwoPartBetween($str, '<th', '>', "</th>") . "-\n\n";

function parsehyperlink($strIn, $intTruncNumber)
//Hyperlink anything in $strIn that looks like a URL.  Also cut the anchor text to $intTruncNumber length.
{
	$strHref="";
	$olderrorr=error_reporting(0);
	$intBegin=strpos(strtolower($strIn), "http://");
	$intEnd1=strpos(strtolower($strIn), " ", $intBegin+7);
	$intEnd2=strpos(strtolower($strIn), chr(34), $intBegin+7);
	$intEnd=getMin($intEnd1, $intEnd2);
	if ($intBegin==0 && $intEnd=="")
	{
		$intEnd=strlen($strIn);
	}
	if ( strlen($intBegin)>0)//total hack for the maddening php "beginning of string strpos enigma"
	{
		$strHref=substr($strIn, $intBegin, $intEnd-$intBegin);
		if ($strHref!="")
		{
			$out="<a href=\"". $strHref . "\" target=\"new\">" .  truncate($strIn, $intTruncNumber) . "</a>";
		}
		else
		{
			$out=  truncate($strIn, $intTruncNumber) ; 
		}
	}
	else
	{
		$out=  truncate($strIn, $intTruncNumber) ; 
	}
	error_reporting($olderrorr);
	return $out;
}

function striplfcr($strIn)
{
	$strIn=str_replace(chr(13), "", $strIn);
	$strIn=str_replace(chr(10), "", $strIn);
	return $strIn;
}

function simplelinkbody($strIn, $len=25)
{
	$strIn=str_replace("'", "", $strIn);
	$strIn=str_replace("\"", "", $strIn);
	$strIn=str_replace("&#39;", "", $strIn);
	$strIn=str_replace("&#34;", "", $strIn);
	$strIn=htmlcodify(truncate(strip_tags(striplfcr($strIn)), $len));
	return $strIn;
}

function killBetweenTags($oldString,  $taglist, $maxLength=9500, $begin="<", $end=">") 
//Judas Gutenberg Jan 2 2007
//gets rid of XML tags from $oldString if they are present in the space-delimited list $taglist.  also gets rid of the </XX> closer.
//this function doesn't consider whether or not content inside a node should be removed.  it just removes matching tags
//i made this function mostly to target DIVs and SPANs i didn't want in my truncated synopses.
{
	$newString = "";
	$inUnapprovedTag = false;
	$inApprovedTag=false;
   	for($i = 0; $i < strlen($oldString); $i++) 
	{
        if(substr($oldString,$i,strlen($begin)) == $begin  || ($end==""  && $inUnapprovedTag ==true) ) 
		{
			$strProspectiveTag=substr($oldString, $i + 1,getMin(strpos($oldString, " ",$i+1), strpos($oldString, ">",$i+1))-($i+1));
			//echo $strProspectiveTag . "<br>\n";
			//echo hexdump($strProspectiveTag)  . "<br>\n";
			if(inList($taglist, $strProspectiveTag) || inList($taglist, RemoveFirstCharacterIfMatch($strProspectiveTag, "/")))
			{
				$inUnapprovedTag = true;
			}
			else
			{
				$inApprovedTag=true;
			}
		}
		if(!$inUnapprovedTag)
		{ 
			$newString.= substr($oldString,$i,1);
		}
        if( substr($oldString,$i,strlen($end)) == $end  && $inUnapprovedTag ==true  && !($end==""  && $inUnapprovedTag ==true)) 
		{
			$inUnapprovedTag = false;
			//$i++;
		}
		if( substr($oldString,$i,strlen($end)) == $end  && $inApprovedTag ==true  && !($end==""  && $inApprovedTag ==true)) 
		{
			$inApprovedTag = false;
			//$i++;
		}
		//i want to bail at $maxLength, but not if we're still in a good tag
		if (strlen($newString)>$maxLength  && !$inApprovedTag)
		{
			break 1;
		}
	}
 	return $newString;
  }


function truncate($strIn, $intNumber, $mode="end", $bwlSkipElipsis=false)
//Truncates $strIn to $intNumber (more or less) at the nearest space less than $intNumber and adds ...
//I've added some code to make sure an image tag early in $strIn is shown in full, but shrunk to a thumbnail
{
	$taglist="table TABLE TR TD tr td div span DIV SPAN p br P BR strong b STRONG B i I h3 h2 h1 H1 H2 H3";
	$strIn= killBetweenTags($strIn,  $taglist, $intNumber + 10);
	//echo "+" . $strIn . "\n";
	$strLen=strlen($strIn);
	//$bwlSkipElipsis=false;
	if ($strLen<$intNumber+2)
	{	
		return $strIn;
	}
	//parsehyperlink($strIn, 55);
	$intStart=$intNumber;
	for ($i=$intStart; $i>1; $i--) //going backwards through the string
	{
		if (substr($strIn, $i, 1)==" ") //trying to find a space
		{
			if($mode=="end")
			{
				$out= substr($strIn, 0, $i);
			}
			$lespos=strrpos($out,"<");
			$grepos=strrpos($out,">");
			if (($grepos<$lespos  || $grepos === false )  && $lespos<$intNumber   &&  !($lespos === false)  )//we're inside a tag!
			{
				$grepos=strpos($strIn,">", $lespos)+1;
				$out = substr($strIn, 0, $grepos);
				//a little hack to ensure an image will be small!
				$out=str_replace("<img ", "<img align=\"center\" width=\"100\" height=\"80\" ", $out);
				$bwlSkipElipsis=true;
			}
			if(!$bwlSkipElipsis)
			{
				$out.="...";
			}
			break;
		}
		else if ($i<$intNumber-12)//oh no, we're back 12 and havent found a space!
		{
			$out = substr($strIn, 0, $intNumber-5);
			$lespos=strrpos($out,"<");
			$grepos=strrpos($out,">");
			if (($grepos<$lespos  || $grepos=="")  && $lespos<$intNumber  &&  !($lespos === false))
			{
				$grepos=strpos($strIn,">", $lespos)+1;
				$out = substr($strIn, 0, $grepos);
				$out=str_replace("<img ", "<img align=\"center\" width=\"100\" height=\"80\" ", $out);
			}
			else
			{
				$out = forinputform($out);
			}
			break;
		}
	}
	return $out;
}

function trunchandler($strIn, $intNumber, $bwlForceOutSpaces=false)
{
	if($bwlForceOutSpaces)
	{
		$strIn=ltrim(rtrim($strIn));
		$strIn=str_replace(" ", "+", $strIn);
	}
	if (strpos(ltrim(rtrim($strIn)), " ")>0)
	{
	 
		return truncate($strIn, $intNumber);
	}
	else
	{
		return parsehyperlink($strIn, $intNumber);
	}
}

	
function htmlrow($strClass)
//Produces a row for the display of data, configured now to do so in an HTML table.
//If one precedes a class name with a * then the row gets a MAtrselectfromline onclick event, which is very useful for all sorts of things
{
	$out="\n<tr";
	$bwlDontSize= false;
	$bwlHideAllButLast=false;
	$intArgs =func_num_args();
	$strPreFed="";
	$extraTDpairs="";
	//a hack allowing the dynamic pre-hiding of a row
	$bwlHideAllButLast="";
	//echo $strClass . "<BR>";
	if (beginswith($strClass, "*"))
	{
		$extraTDpairs= "onclick=\"MAtrselectfromline(this, '')\"";
		$strClass=substr($strClass,1);
	}
	if (beginswith($strClass, "+"))//force not to sort!
	{
		$out.= " name=\"pleasesortavoid\"";
		$strClass=substr($strClass,1);
	}
	if (beginswith($strClass, "!"))
	{
		$bwlDontSize= true;
		$strClass=substr($strClass,1);
	}
	if (beginswith($strClass, "^"))
	{
		$bwlDontSize= true;
		$strClass=substr($strClass,1);
		$intColspan=substr($strClass,0,1);
		$strClass=substr($strClass,1);
		$extraTDpairs.= " colspan=\"" . $intColspan . "\"";
	}
	if (contains($strClass, "|"))//if we have a class with a vertical line in it, then the first part is the class and the second part is the alpha
	{
		//$out.=" \"" . $strClass . "\"";
		$arrThis=explode("|", $strClass);
		$strClass=$arrThis[0];
		$extraTDpairs.="style='opacity: ." . $arrThis[1] . ";;filter:alpha(opacity=" . $arrThis[1] . ")' ";
	//	echo $strClass . "<BR>";
		//$out.=" bgcolor='" . $arrThis[1] . "'";
		 
	}
	if (contains($strClass, "hideallbutlast"))
	{
		//$out.=" \"" . $strClass . "\"";
		$bwlHideAllButLast=true;
		$strPreFed="<td " .  $extraTDpairs . " id=\"killmeonexpand\" colspan=\"" . intval($intArgs-2) . "\"></td>";
	}
	elseif ($strClass!="")
	{
		$out.=" class=\"" . $strClass . "\"";
	}
	$out.=">\n";
	
	$out.=$strPreFed;
		
	for($i=1; $i<$intArgs; $i++)
	{
		$strWidth="";
		$content=func_get_arg($i);
		if (contains($content, "insert.gif"))//HACKY!!!!!!!!!!!
		{
			$strWidth="width=\"33\"";
		}
		elseif(!contains($content, "<"))
		{
			$strWidth="width=\"22%\"";
		}
		$bwlNoTD=false;
		if (contains($content, "type=\"hidden\"")  && !contains($content, "<img ")  && !contains($content, "type=\"file\"") && !(contains($content, "javascript: addfield(")))
		{
			$bwlNoTD=true;
		 
		}
		if($bwlDontSize)
		{
			$strWidth="";
		}
		if(!$bwlNoTD)
		{
			if ($bwlHideAllButLast  && $i<$intArgs-1)
			{
				$out.="<td " . $strWidth . " " . $extraTDpairs . " valign=\"top\" style=\"display:none\">\n";
			}
			else
			{
				$out.="<td " . $strWidth . " " . $extraTDpairs . " valign=\"top\">\n";
			}
 		}
		else
		{
			//echo $content . "==<BR><hr>";
			$out.="<td " . $strWidth . " " . $extraTDpairs . " style=\"display:none\">";
		}
		if ($content!="")
		{
			$out.=$content;
		}
		else
		{
			$out.="&nbsp;";
		}
		$out.="</td>\n";
	}
	$out.="</tr>\n";
	return $out;
}
 

function AllRequestToURL()
{
	//Judas Gutenberg, May 26 2009.  Returns the url of the page with any form items or other requests set as query variables
	$strPHP=$_SERVER['PHP_SELF'];
	$out="";
	foreach($_REQUEST as $k=>$v)
	{
		$v=stripslashes($v);
		$v=removeslashesifnecessary($v);
		
		if($v!="")
		{
			$out.="&" . $k . "=" . urlencode($v);
		}
	}
	if($out!="")
	{
		$out= RemoveFirstCharacterIfMatch($out, "&");
		$out="?" . $out;
	}
	return $strPHP . $out;

}
 
function replaceMultipleQueryVariables()
{
	//probably won't use this as much as linkme, since it just generates the link, not the HTML
	$strPHP=$_SERVER['PHP_SELF'];
	$intArgs =func_num_args();
	$out="";
	$arrOut=$_REQUEST;
	for($i=0; $i<$intArgs; $i=$i+2)
	{
		$var=func_get_arg($i);
		$val=func_get_arg($i+1);
		$strOut=replaceSpecificQueryVariable($var, $val, $arrOut);
		$arrOut=QuerystringToAssociativeArray($strOut);
	}
	$out=$strPHP . "?" . $strOut; 
	return $out;
}
	
function QuerystringToAssociativeArray($strIn)
//convert a querystring directly into an associative array without ever having it be an actual querystring
{
	$arrOut=array();
	$arr=explode("&", $strIn);
	foreach($arr as $a)
	{
		$arrSub=explode("=", $a);
		$arrOut[$arrSub[0]]=urldecode($arrSub[1]);
	}
	return $arrOut;
}

function linkme($strIn, $target)
//creates a hyperlink labeled with $strIn, replacing any query variables passed in additionally
{
	$strPHP=$_SERVER['PHP_SELF'];
	$intArgs =func_num_args();
	$out="";
	$arr=array();
	for($i=2; $i<$intArgs; $i=$i+2)
	{
		$var=func_get_arg($i);
		$val=func_get_arg($i+1);
		$str= replaceSpecificQueryVariable($var, $val, $arr);
		$arr =QuerystringToAssociativeArray($str);
	}
	$out=$strPHP . "?" . $str; 
	$targethtml="";
	if ($target!="")
	{
		$targethtml=" target=\"" . $target . "\"";
	}
	$out="<a" . $targethtml . " href=\"" . $out . "\">" .  $strIn . "</a>";
	return $out;
}

function replaceSpecificQueryVariable($strVariable, $strValue, $arr="", $strIncludeFields="")
//replaces specific associative element in an array, usually the Query String, though it can be a passed-in array of the Post array.
{
	$out="";
	$intOut=0;
	$strCharacterGlue="";
	$bwlFoundOurVariable=false;
	if (is_array($arr) && count($arr)>0)
	{
		$arrToScan=$arr;
	}
	else
	{
		if (count($_GET)==0 && count($_POST)>0)
		{
			$arrToScan=$_POST;
		}
		else
		{
			//die("##");
			$arrToScan=$_GET;
		}
	}
	
	if(array_key_exists(qpre . "eq", $arrToScan))//might have to worry about this but probably not
	{
		//$arrToScan=DecryptStringToQS($arrToScan, true);
	}
	foreach ($arrToScan as $k=>$v)
	{
		if($strIncludeFields==""  || ($strIncludeFields!="" && inList($strIncludeFields, $k)))
		{
			//echo "<div style='color:#ffff00'>" . $k . " " . $v . "</div>";
			if(is_array($v))
			{
				$v=$v[0];
			}
			if (strlen($v)<100)//keep the query string to a reasonable size in some cases
			{
				if ($intOut!=0)
				{
					$strCharacterGlue="&";
				}
				if ($k==$strVariable)
					{
						$out.= $strCharacterGlue . $k. "=" . urlencode($strValue);
						$bwlFoundOurVariable=true;
					}
				else
					{
						if(is_string($v))
						{
							$out.=$strCharacterGlue . $k. "=" . urlencode($v);
						}
					}
			}
			 
			$intOut++;
		}
	}
	if ($out=="")
	{
		$out=$strVariable. "=" . urlencode($strValue);
	
	}
	elseif (!$bwlFoundOurVariable)
	{
		$out.="&" . $strVariable. "=" . urlencode($strValue);
	}
	//echo "--" . $out;
	return $out;
}

function EliminateEmptyArrayPairs($arrIn)
{
	$arrOut=Array();
	foreach($arrIn as $k=>$v)
	{
		if($v!="")
		{
			$arrOut[$k]=$v;
		}
	}
	return $arrOut;
}		
	
function ZeroIfEmpty($in)
{			
	if ($in=="")
	{
		return 0;
	}
	return $in;
}

function IfAThenB($a,$b)
{			
	if ($a!="")
	{
		return $b;
	}
}

function JoinList($character)
{
	//the first argument is a join character, and the second argument, etc., are items to be joined around that character
	//but, unlike say join() (which works on arrays instead of argument lists), the join character (which can be multicharacter) is only used
	//between non-empty items. empty items are skipped.
	//this function is often a handier and more-flexible substitute for cases that might otherwise call for IfAThenB($a,$b)
	//may 4 2010 judas gutenberg.
	$intArgs =func_num_args();
	$out="";
	for($i=1; $i<$intArgs; $i++)
	{
		$item=func_get_arg($i);
 		if($item!="")
		{
			if($item!="")
			{
				if($out!="")
				{
					$out.=$character;
				}
				$out.=$item;
			}
			 
		}
	} 
	$out=RemoveLastCharacterIfMatch($out, $character);
	return $out;
}

function IfAThenNextB($strConfig, $fltThis, $mode="larger", $strDelimiter=" ")
{
//given a delimited-string of numbers (they do not have to be integers)
//scan through and return either the next number larger or smaller than $fltThis
//judas gutenberg, march 4 2010
	$arrThis=explode($strDelimiter , $strConfig);
	$intOut=0;
	if($mode=="larger")
	{
		rsort($arrThis, SORT_NUMERIC);
	}
	else
	{
		sort($arrThis, SORT_NUMERIC);
	}
	foreach($arrThis as $testcase)
	{
		//echo "-" . $testcase . "- ." . $fltThis . ".<BR>";
		if($mode=="larger")
		{
			if(floatval($testcase)<floatval($fltThis))
			{
				return $intOut;
			}
		}
		else
		{
			if(floatval($testcase)>floatval($fltThis))
			{
				return $intOut;
			}
		}
		$intOut=$testcase;
	} 
	return floatval($testcase);
}


////////////////////////////
// more complex string functions
////////////////////////////

function paginatelinks($intRecCount, $intRecordsPerPage, $intStartRecord, $strPHP, $strThisQVar, $strAdditionalTagPairs="", $strIntroText="Go to Page: ")
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
				$out.="<a " . $strAdditionalTagPairs ." href=\"" . $url . "\">" .intval($i +1) . "</a>";
			}
			else
			{
				$out.=    "<b " . $strAdditionalTagPairs .">" . intval($i +1) . "</b>";
			}
			if (($i+1)* $intRecordsPerPage<$intRecCount)
			{
				$out.= " | ";
			}
		}	
		return $strIntroText . $out;
	}
}

function NumToMon($intNum)
//Take a number from 1 to 12 and return a month name.
{
	$strMons="|January|February|March|April|May|June|July|August|September|October|November|December";
	$arrMons=explode("|", $strMons);
	return $arrMons[$intNum];
}

function getMax($intOne, $intTwo)
//Returns the larger of two numbers.
{
	if ($intOne>$intTwo)
	{
		$intBigger=$intOne;
	}
	else
	{
		$intBigger=$intTwo;
	}
	return $intBigger;
}
	
function getMin($intOne, $intTwo)
//Returns the smaller of two numbers.
{
	if ($intOne<$intTwo)
	{
		$intSmaller=$intOne;
	}
	else
	{
		$intSmaller=$intTwo;
	}
	return $intSmaller;
}
	
////specifically DB-related functions

function deMoronizeDB($strDB)
//Fixes idiotic dbs that contain dashes in their names. Thanks a lot, certain DB host providers!
{
	if (contains($strDB, "-")  && !contains($strDB, "`"))
	{
		$strDB="`" . $strDB . "`";
	}
	return $strDB;
}

function DuplicatesInThisField($arrIn, $strFieldName, $strValue)
{
	//scans through a mysql recordset looking to see if there are duplicates of  $strValue in a field named $strFieldName
	$found=0;
	foreach($arrIn as $row)
	{
		if ($row[$strFieldName]==$strValue)
		{
			$found++;
			if ($found>1)
			{
				return true;
			}
		}
	}
	return false;
}

function numericpulldown($intstart,$intend,$intdefault,$strName,  $bwlDontShowNone=false, $strFunction="", $strLabelAppend="")
//Gives me a select with numbers running from $intstart to $intend, with $intdefault selected, and names it $strName
//MARCH 17 2009:  added code to pass in a function, allowing display to be a function of the numeric to be passed in the select
{
	if($strFunction!="")
	{
		$strFunction=FixFormulaForEval($strFunction, true) . ";";
	}
	$strOut="<select  id=\"id" . $strName . "\" name=\"". $strName . "\">\n";
	if(!$bwlDontShowNone)
	{
		$strOut.="<option value=\"\">none\n";
	}
  	for ($intNumber=$intstart; $intNumber<=$intend; $intNumber++)
	{
		$strThisFunction=$strFunction;
		$strSel="";
		if (intval($intNumber)==intval($intdefault))
		{
			$strSel=" selected=\"true\" ";
		} 
		if($strFunction!="")
		{
			
			$strThisFunction=str_replace("<value/>", $intNumber, $strThisFunction);
			$strThisFunction=str_replace("<value>", $intNumber, $strThisFunction);
			if(contains($strThisFunction, "return"))
			{
				$strDisplay=eval($strThisFunction.";");
			}
			else
			{
				$strDisplay=eval("return " . $strThisFunction. ";");
			}
			//$strDisplay=$intNumber;
		}
		else
		{
			$strDisplay=$intNumber;
		}
		$strOut.="<option value=\"". $intNumber. "\" " . $strSel .  ">". $strDisplay . $strLabelAppend ."\n";
	} 
	$strOut.="</select>"."\n";
	$function_ret=$strOut;
	return $function_ret;
} 

function datepulldowns($strNamePre,$dtmDefault, $bwlDontShowNone=false, $strFormatString="", $yearlow="", $yearhi="", $bwlCCDate=false, $bwlYearOnly=false)
//provides a set of pulldowns to select a date
//MARCH 17 2009: $strFormatString allows changing the format of the date display
//for example "d F Y" uses PHP date function to populate the dropdowns with the correct translations of the date components
{
	$yearlow=gracefuldecaynumeric($yearlow,numrange_low,0);
	$yearhi=gracefuldecaynumeric($yearhi, numrange_hi,99);
	$datetyperelations="nFmMtn-month-1-12 jdDlNSj-day-1-31 Yoy-year-" . $yearlow . "-" . $yearhi;
	$divider="/";
	$arrDTR=explode(" ", $datetyperelations);
	$daydropdown="";
	$monthdropdown="";
	$yeardropdown="";
	$strOut="";
	$arrDatePartsIn=Array();
	if (!is_numeric($dtmDefault)  && $dtmDefault!="")
	{	
		$dtmDefault=strtotime($dtmDefault);
	}
	$strSuperPre=qpre;
	$strOut="";
	if (strlen($yearlow)==4)
 	{
		$intYear=intval($intYear);
  	}
	else
 	{
		$intYear=intval(substr($intYear,strlen($intYear)-(2)));
  	}
	if (substr($intYear,0,1)=="0")
	{
		$intYear=intval(substr($intYear,strlen($intYear)-(1)));
	} 
	//echo strlen($strFormatString);
	if(strlen($strFormatString)>1)
	{
		$endcount=strlen($strFormatString);
		$bwlStringParseMode=true;
	}
	else
	{
		$endcount=3;
		$bwlStringParseMode=false;
	}
 
 	for($i=0; $i<$endcount; $i++)
	{
		$thisdropdown="";
		if( $bwlCCDate && $i!=1 || !$bwlCCDate && !$bwlYearOnly  || $bwlYearOnly  && $i==2 )
		{
		if(!$bwlStringParseMode)
		{
			$thisDTR=$arrDTR[$i];
			$arrDPI=explode("-", $thisDTR);
			$thisFormatBundle=$arrDPI[0];
			$typeIn=substr($thisFormatBundle, 0, 1);
			$bwlFoundAMatch=true;
			$chrFormat=$strFormatString;
		}
		else
		{
			$chrFormat=substr($strFormatString, $i, 1);
			$thisDTR=$arrDTR[$i];
			$arrDPI=explode("-", $thisDTR);
			$bwlFoundAMatch=false;
			foreach($arrDTR as $oneDTR)
			{
				
				$arrOneDTR=explode("-", $oneDTR);
				if(contains($arrOneDTR[0], $chrFormat))
				{
					//echo "!<br>";
					$thisDTR=$arrOneDTR;
					$arrDPI=$arrOneDTR;
					$bwlFoundAMatch=true;
					break;
				}
			}
			$thisFormatBundle=$arrDPI[0];
			$typeIn=substr($thisFormatBundle, 0, 1);
			
		}
		//echo $arrDPI[1] . " " .  $typeIn . "<BR>";
		//echo $thisdatepart . " " . $strNamePre. "|" . $arrDPI[1] . "<BR>";
		
		if(is_numeric($dtmDefault)  && $dtmDefault!=""  )
		{
			//a way to hackily set the dates in a dropdown to particular defaults
			$thisdatepart= date( $typeIn, $dtmDefault);
			//echo $thisdatepart . "<BR>";
			//echo $_REQUEST["x_datecode_start|year"] . " " . qpre . $strNamePre. "|" . $arrDPI[1] . " " . $_REQUEST[qpre . $strNamePre. "|" . $arrDPI[1]]  . "<BR>";
		}
		else if( $_REQUEST[qpre . $strNamePre. "|" . $arrDPI[1]]!="")
		{
			$thisdatepart=$_REQUEST[qpre . $strNamePre. "|" . $arrDPI[1]];
		}
		else
		{
			$thisdatepart= "";
		}
		//echo $typeIn .  " " . $thisdatepart.   " " . $dtmDefault. "\n<br>";
		if($bwlFoundAMatch)
		{
			$strFunction="";
			if(contains($thisFormatBundle,$chrFormat))
			{
				//DatePartConversion(7, "m", "m");
				// numericpulldown($intstart,$intend,$intdefault,$strName,  $bwlDontShowNone=false, $strFunction="")
				$strFunction="DatePartConversion('<value/>', '" . $typeIn . "', '" . $chrFormat . "')";
				//echo $strFunction . "<br>"; 
			}
			$thisdropdown = numericpulldown($arrDPI[2],$arrDPI[3],$thisdatepart,$strSuperPre  . $strNamePre."|" . $arrDPI[1],  $bwlDontShowNone, $strFunction);
		
			$strOut.="\n" . $thisdropdown;
		}
		if(!$bwlFoundAMatch)
		{
			$strOut.="\n" . $chrFormat;
		}
		else if(!$bwlStringParseMode)
		{
			if($i<$endcount-1)
			{
				$strOut.="\n" . $divider;
			}
		}
		}

	}
	if($bwlCCDate)
	{
		//$strOut.=HiddenInputs(Array($strNamePre."|day"=>1), "");
		$strOut.="<input value=\"1\" type='hidden' name=\"" .qpre.  $strNamePre."|day" . "\">";
	}
	return $strOut;
} 

function gracefuldecaynumeric()
{
	//go through the parameters and return the first that isn't empty
	$intArgs =func_num_args();
	for($i=0; $i<$intArgs; $i++)
	{
		$option=func_get_arg($i);
		if (is_numeric($option))
		{
			return $option;
		}
	}
}

function gracefuldecaynotzero()
{
	//go through the parameters and return the first that isn't empty
	$intArgs =func_num_args();
	for($i=0; $i<$intArgs; $i++)
	{
		$option=func_get_arg($i);
		if ($option!=0)
		{
			return $option;
		}
	}
}

function boolcheck($strName,$strDefault, $bwlFriendly=false, $bwlNoForm=false,$strStyle="", $strTrue="true", $strFalse="false")
//shows a set of radio buttons for setting a boolean db value
{
	//$strTrue="true";
	//$strFalse="false";
	if ($bwlFriendly)
	{
		$strTrue="yes";
		$strFalse="no";
	}
	if ($bwlNoForm)
	{
		if (intval($strDefault)==1  || $strDefault==chr(1))
		{
			return $strTrue;
		}
		return $strFalse;
	}
	else
	{
		if (intval($strDefault)==1 || $strDefault==chr(1))
		{
			$out= "<input type=\"radio\" checked name=\"" . $strName . "\" value=\"1\"> "  . $strTrue ;
			$out.= "<input type=\"radio\"  name=\"" . $strName . "\" value=\"0\"> "  . $strFalse ;
		}
		else if (!($strDefault==="")  && !is_null($strDefault))
		{
			$out= "<input type=\"radio\"  name=\"" . $strName . "\" value=\"1\"> "  . $strTrue ;
			$out.= "<input type=\"radio\"  checked name=\"" . $strName . "\" value=\"0\"> "  . $strFalse ;
		}
		else
		{
			$out= "<input type=\"radio\" name=\"" . $strName . "\" value=\"1\"> "  . $strTrue ;
			$out.= "<input type=\"radio\"  name=\"" . $strName . "\" value=\"0\"> "  . $strFalse ;
		}
	}
	if ($strStyle!="")
	{
		$out= "<span style=\"" . $strStyle. "\">" . $out . "</span>";
	}
	return $out;
}

//////////////////
//another place in the code
//////////////////


function PointOfDissimilarity($strOne, $strTwo)
//finds the first point where two strings diverge in content
{
	for($i=0; $i<strlen($strOne); $i++)
	{
		$chrOne=substr($strOne, $i, 1);
		
		$chrTwo=substr($strTwo, $i, 1);
		if($chrOne!=$chrTwo)
		{
			return $i;
		}
		
	}
	return $i;
}
	
////
//data and generic data
//

function data($strIn,$intTypeIn, $intTypeOut, $strTranslate)
//Using a double-delimited list $strTranslate of the form field1a|field2a|field3a-field1b|field2b|field3b-field1c...
//you can retrieve the field number $intTypeOut in the record containing the first match of $strIn to the field specified by
//$intTypeIn. if $intTypeIn is -1 then it returns a field from the record number specified by $strIn
//this serves as very nice bare-bones database retrieval system
{
	$strOut=genericdata($strIn,$intTypeIn, $intTypeOut, $strTranslate, "-", "|");
	return($strOut);
}	

function genericdata($strIn,$intTypeIn, $intTypeOut, $strTranslate, $rowdelimiter, $fielddelimiter, $bwlRow=false)
//Form of 'data' that allows you to pass in your own delimiters
//If $bwlRow=true then return the whole row as an array
{
	$arrTranslate=explode($rowdelimiter, $strTranslate);
	$strOut="";
	$bwlDone=1;
	$strIn=$strIn;
	$bwlDone=0;
	for ($i=0;  $i < count($arrTranslate) and $bwlDone==0; $i++)
	{
		$arrThis=explode($fielddelimiter,$arrTranslate[$i]);
		if ($intTypeIn<count($arrThis) and $intTypeOut<count($arrThis))
		{
			if ($intTypeIn==-1) //type==-1 allows you to grab fields by the number of the row
			{
				if ($strIn==$i+'')
				{
					if ($bwlRow)
					{
						$strOut=$arrThis;
					}
					else
					{
						$strOut=$arrThis[$intTypeOut];
					}
					$bwlDone=1;
				}
				
			}
			else
			{
				if ($arrThis[$intTypeIn]==$strIn)
				{
					if ($bwlRow)
					{
						$strOut=$arrThis;
					}
					else
					{
						$strOut=$arrThis[$intTypeOut];
					}
					$bwlDone=1;
				}
			}
		}
	}
	return($strOut);
}

function DDStringToDelimitedList($strConfig, $intFieldNumber, $strSourceRowDelimiter, $strSourceColumnDelimiter, $strDestinationDelimiter)
{
//makes a delimited list of single fields for a column in a double-delimited string
//Judas Gutenberg, January 28 2009
	$out="";
	$rowcount=0;
	$bwlFresh=true;
	while($thisresult!="" ||  $bwlFresh)
	{
		$thisresult=genericdata($rowcount,-1,  $intFieldNumber, $strConfig, $strSourceRowDelimiter, $strSourceColumnDelimiter, false);
		$bwlFresh=false;
		$rowcount++;
		$out.=$thisresult . $strDestinationDelimiter;
	}
	return $out;
}

function ArraySubsetFromList($strList, $arrArray)
//Take an associative array and return an array whose keys are mentioned in the space-delimited list $strList
{
	$arrList=explode(" ", $strList);
	$arrOut=Array();
	foreach($arrList as $key)
	{
		if($arrArray=="" || !array_key_exists($key,$arrArray))
		{
			$arrOut[$key]="";
		}
		else
		{
			$arrOut[$key]=$arrArray[$key];
		}
	}
	return $arrOut;
} 

function ArraySubsetFromArray($arrVictim, $arrSource)
//Take an associative array and return an array whose keys are mentioned in the associative array $arrVictim
{
	$arrOut=Array();
	foreach($arrVictim as $key=>$value)
	{
		if($arrSource=="" || !array_key_exists($key,$arrSource))
		{
			$arrOut[$key]="";
		}
		else
		{
			$arrOut[$key]=$arrSource[$key];
		}
	}
	return $arrOut;
} 


function RadioDataArray($strConfig,$intIDField, $intLabelField, $strQueryVariableName, $strDefault="")
{
	$out="";
	$arrConfig=explode("-", $strConfig);
	foreach($arrConfig as $thisConfig)
	{
		$arrThis=explode("|",  $thisConfig);
		$strChecked="";
		if($arrThis[$intIDField]==$strDefault)
		{
			$strChecked=" checked=\"checked\"";
		}
		$out.=    "<input " . $strChecked. " name=\"" . $strQueryVariableName . "\" id=\"id" .$strQueryVariableName . "\"  type=\"radio\" value=\"" .$arrThis[$intIDField] . "\" />" .   $arrThis[$intLabelField] . "\n";
	}
	return $out;

}

function GenericDataPulldown($strConfig, $intIDField, $intLabelField, $strQueryVariableName, $strDefault="", $strPHP="", $strFormName="", $strConnector ="?", $bwlAcceptWild=true, $strEmptyText="-none-", $rowdelimiter="-", $fielddelimiter="|", $strExtraValPairs="")
//From a double-delimited -| string, generate a dropdown
//$bwlAcceptWild allows it to add items at the bottom found in the wild but not in the config string
{
	$intTop=-1;
	$strOut="";
	if ($strConfig!="")
	{
		//if (strpos($strConfig, $fielddelimiter) >0)
		//{
			//$intTop=count(explode($fielddelimiter, $strConfig));
		//}
		//else
		//{
			$intTop=count(explode($rowdelimiter, $strConfig));
		//}
		//echo "<P>" . $strConfig . " " . $intTop;
	}
	if (($strPHP!="") and ($strFormName!="")) 
	{
		$strOut= "\n<select " . $strExtraValPairs ." id=\"id" . $strQueryVariableName . "\" name=\"" . $strQueryVariableName . "\" onChange=\"window.document.location.href='" . $strPHP . $strConnector . $strQueryVariableName . "=' + document." . $strFormName . "." . $strQueryVariableName . "[document." . $strFormName . "." . $strQueryVariableName . ".selectedIndex].value\">\n";
}
	else
	{
		$strOut="\n<select " . $strExtraValPairs ." id=\"id" . $strQueryVariableName . "\"  name=\"" . $strQueryVariableName . "\">\n";
	}
	$strOut.= "<option value=\"\" >" . $strEmptyText ."\n" ;
 	$bwlFoundOne=false;
	for ($t=0; $t<$intTop; $t++)
	{
		$strSel="";
		$strThisIdentifier = genericdata($t,-1,$intIDField,$strConfig,$rowdelimiter,$fielddelimiter);
		$strLabel=genericdata($t,-1,$intLabelField,$strConfig,$rowdelimiter,$fielddelimiter);
 		//echo "-" . $strLabel . "-<BR>";
		if ($strLabel!="")
		{
		 
			if  ($strDefault.""==$strThisIdentifier."")
			{
				$strSel="selected=\"true\"";
				$bwlFoundOne=true;
			}
			$strOptionStyle="";
			if(strlen($strThisIdentifier)==7)
			{
				if(beginswith( $strThisIdentifier, "#"))
				{
					if(strtoupper($strThisIdentifier)==$strThisIdentifier)
					{
						//it's a color!  just show that!
						$strOptionStyle=" style='background-color:" . $strThisIdentifier. "' ";
						//$strLabel="";
					}
				}
				
			}
			$strOut.=  "<option " . $strOptionStyle . " value=\"" . $strThisIdentifier. "\" " . $strSel . ">" . $strLabel . "</option>\n";
		}
	}
	if (!$bwlFoundOne  && $bwlAcceptWild && $strDefault!="" )
	{
		$strOut.=  "<option selected=\"true\" value=\"" . $strDefault. "\">" . $strDefault . "</option>\n";
	
	}
	$strOut.= "</select>\n";
 
	return($strOut);
}

//date functions

function DatePartConversion($in, $strTypeIn, $strTypeOut)
//March 17, 2009:
//converts one type of a date component into another 3 can become "March" for example.
//(see PHP date function for documentation of the characters or typein/out.
{
	$tempdate=ReplaceUnitInDate(time(), $in, $strTypeIn);
	$out=date($strTypeOut, $tempdate);
	return $out;
}


function DescribeTimeSpan($past, $present, $strEnd="ago")
{
	$present=$present-$past;
 
	if($present>31536000)
	{
		$intervalcount=intval($present/31536000);
		$entity="year";
	}
	else if($present>86400)
	{
		$intervalcount=intval($present/86400);
		$entity="day";
	}
	else if($present>3600)
	{
		$intervalcount=intval($present/3600);
		$entity="hour";
	}
	else if($present>60) 
	{
		$intervalcount=intval($present/60) ;
		$entity="minute";
	}
	else if($present>0)
	{
		$intervalcount=intval($present);
		$entity="second";
	}
	return $intervalcount . " " . PluralizeIfNecessary($entity,$intervalcount) . " " . $strEnd;
}

function ReplaceUnitInDate($date, $value, $type)
//March 17, 2009: replaces just the $type in $date with $value
{	
	$strConfig="H|i|s|n|j|Y";
	if ($type=="W")
	{
		$unit=$unit*7;
		$type="d";
	}
	$arrConfig=explode("|", $strConfig);
	$strAction="mktime(";
	for ($i=0; $i<count($arrConfig); $i++)
	{
		
		if ($type==$arrConfig[$i])
		{
			$strAction.=$value;
		}

		else
		{
			$strAction.="date(\"" . $arrConfig[$i] . "\", " . $date . ")";
			 
		}
		if($i<count($arrConfig)-1)
		{
			$strAction.=",";
		}
	}
	$strAction.=");";
	//echo $strAction . "<br>\n";
	$out=eval("return " . $strAction);
	return($out);
}

function ReasonableStringDate($m, $d, $y)
{
	$y=intval($y);
	if (strlen($y+ " ")<4)
	{
		if ($y<50)
		{
			$y=2000+$y;
		}
		else
		{
			$y=1900+$y;
		}
	}
	return     $y . "/" . $m . "/" . $d;

}

function flipyear($strDate)
{
//for taking m/d/y and making it y/m/d
	$datearray=getdate(strtotime($strDate));
	$month=$datearray["mon"];
	$year=$datearray["year"];
	$day=$datearray["mday"];
	return $year . "/" . $month . "/" . $day;
}


function DateTimeForMySQL($strIn)
//Parses a datetime and makes it acceptable for mysql.
{
	$timestamp=strtotime($strIn);
	return date("Y-m-d H:i:s", $timestamp);
}

function kdateformat($intDate)
{
	if (is_numeric($intDate))
	{
		$out=date("m.d.y", intval($intDate));
	}
	else
	{
		$out=date("m.d.y", strtotime($intDate));
	}
	//echo "<p>" . time() . " " . $intDate . " " . $out . "<p>";
	return $out;
}

//another clip

function Alternate($strOptionOne, $strOptionTwo, $strOptionNow)
//Swap between two strings.  Great for both front end and back end.
{
	if ($strOptionOne== $strOptionNow)
	{
		return $strOptionTwo;
	}
	return $strOptionOne;

} 
function deMultiple($strIn, $chrIn)
//Remove multiple side-by-side instances of $chrIn - works best for things like spaces and chr(13).
{
	$strOut=$strIn;
	while(!(strpos($strOut, $chrIn . $chrIn)===false))
	{
		$strOut = str_replace( $chrIn . $chrIn, $chrIn, $strOut);
	}
	return($strOut);
}
	
function RemoveLastCharacterIfMatch($strIn, $strMatch)
//Trim off the last characters of $strIn if they happen to be  $strMatch.
//Used to only work with one-character $strMatch, but now should work with any strMatch
{

	$out=$strIn;
	$intMatchLength=strlen($strMatch);
	if (substr($strIn,  strlen($strIn)-$intMatchLength, $intMatchLength) ==$strMatch)
	{
		$out= substr($strIn, 0, strlen($strIn)-$intMatchLength);
	}
	return $out;
}
	
function RemoveFirstCharacterIfMatch($strIn, $strMatch)
//Trim off the first character of $strIn if they happen to be  $strMatch.
//Used to only work with one-character $strMatch, but now should work with any strMatch
{
	$out=$strIn;
	$intMatchLength=strlen($strMatch);
	//echo substr($strIn,   0, 1) . "<br>";
	if (substr($strIn,   0, $intMatchLength) ==$strMatch)
	{
		$out= substr($strIn, $intMatchLength);
	}
	return $out;
}
	
function RemoveEndCharactersIfMatch($strIn, $strMatch)
//Trim off the end characters of $strIn if they happen to be  $chrIn.
//Used to only work with one-character $strMatch, but now should work with any strMatch
{
	$out= RemoveFirstCharacterIfMatch($strIn, $strMatch);
 	$out= RemoveLastCharacterIfMatch($out, $strMatch);
	return $out;
}

function TableBegin($width="630", $id="idsorttable",$cellspacing="1", $cellpadding="2", $border="0", $class="bgclassline")
{
	if($width!="")
	{
		$strWidth="width=\"" . $width ."\" ";
	}
	if($id!="")
	{
		$strID="id=\"" . $id ."\" ";
	}
	if($class!="")
	{
		$strClass="class=\"" . $class ."\" ";
	}
	$out= "\n<table " . $strClass . $strID . $strWidth . "border=\"" .  $border . "\" cellspacing=\"" . $cellspacing ."\" cellpadding=\"" . $cellpadding . "\">\n";
	return $out;
}

function TableEnd()
{
	$out= "\n</table>\n";
	return $out;
}

function TableEncapsulate($content, $bwlJSNumberForSort=true, $width="630", $id="idsorttable",$cellspacing="1", $cellpadding="2", $border="0", $class="bgclassline")
{
	if(!$bwlJSNumberForSort  && $id=="idsorttable")
	{
		$id=="idnonsortedtable";//added this code to allow unsortable tables to coexist with sortable ones
	}
	if(!$bwlJSNumberForSort  && $id=="idsorttable")
	{
		$id="x" . $id;
	}
	$out=TableBegin($width, $id,$cellspacing, $cellpadding, $border, $class);
	$out.=$content;
	$out.= TableEnd();
	if($bwlJSNumberForSort)
	{
		$out.="<script>NumberRows('" . $id . "', 1);</script>";
	}
	return $out;
}

function  codeJustBeforeFound($haystack, $needle)
{
//handy for debugging vexing chrs in content
	if(strpos($haystack, $needle)>1)
	{
		return ord(substr($haystack, strpos($haystack, $needle)-1, 1));
	}
	return 0;
}

function DeleteOldFiles($path, $oldestageinseconds)
{
	$delim = "/"; // Change to "/" for unix
	
	if($dir=@opendir($path))
	{
	$key = strrchr($path,$delim);
	$key = substr($key,1,strlen($key));
	
		while(($file=readdir($dir))!== false) 
		{
			if(is_dir($path.$delim.$file) AND $file!= "." AND $file!= "..")
			{
				//this would make things recursive:
				//$array[$file] = DeleteOldFiles($path.$delim.$file, oldestageinseconds);
			}
			elseif($file!= "." AND $file!= "..")
			{
				if(time()-filemtime($path.$delim.$file)>$oldestageinseconds)
				{
					unlink($path.$delim.$file);
					$array[] = $file;
				}
			}
		}
		closedir($dir);
	}
	return $array;
}

function simplePHPTemplate($templatePath="buynowformtemplate.html", $thisData)
{	
	ob_start();
	$template=file_get_contents($templatePath);
	eval($template);
	$out = ob_get_contents();
	ob_end_clean();
	return $out;
}
?>