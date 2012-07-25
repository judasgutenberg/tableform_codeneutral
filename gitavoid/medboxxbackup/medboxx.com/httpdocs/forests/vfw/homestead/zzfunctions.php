<?
////////////////////////////////////////
//Gus's pro website

if(!function_exists("getMax"))
{
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
}

if(!function_exists("getMin"))
{
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
}
if(!function_exists("killBetweenTags"))
{
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
 }


 
if(!function_exists("RemoveLastCharacterIfMatch"))
{
function RemoveLastCharacterIfMatch($strIn, $chrIn)
//Trim off the last character of $strIn if they happen to be  $chrIn.
//Only works with one-character $chrIn.
{

	$out=$strIn;
	if (substr($strIn,  strlen($strIn)-1, 1) ==$chrIn)
	{
		$out= substr($strIn, 0, strlen($strIn)-1);
	}
	return $out;
}
}
if(!function_exists("RemoveFirstCharacterIfMatch"))
{
function RemoveFirstCharacterIfMatch($strIn, $chrIn)
//Trim off the first character of $strIn if they happen to be  $chrIn.
//Only works with one-character $chrIn.
{
	$out=$strIn;
	//echo substr($strIn,   0, 1) . "<br>";
	if (substr($strIn,   0, 1) ==$chrIn)
	{
		$out= substr($strIn, 1);
	}
	return $out;
}
}
if(!function_exists("RemoveEndCharactersIfMatch"))
{
function RemoveEndCharactersIfMatch($strIn, $chrIn)
//Trim off the end characters of $strIn if they happen to be  $chrIn.
//Only works with one-character $chrIn.
{
	$out= RemoveFirstCharacterIfMatch($strIn, $chrIn);
 	$out= RemoveLastCharacterIfMatch($out, $chrIn);
	return $out;
}
}
if(!function_exists("truncate"))
{
function truncate($strIn, $intNumber)
//Truncates $strIn to $intNumber (more or less) at the nearest space less than $intNumber and adds ...
//I've added some code to make sure an image tag early in $strIn is shown in full, but shrunk to a thumbnail
{
	$taglist="div span DIV SPAN p br P BR strong b STRONG B i I h3 h2 h1 H1 H2 H3";
	$strIn= killBetweenTags($strIn,  $taglist, $intNumber + 10);
	//echo "+" . $strIn . "\n";
	$strLen=strlen($strIn);
	$bwlSkipElipsis=false;
	if ($strLen<$intNumber+2)
	{	
		return $strIn;
	}
	//parsehyperlink($strIn, 55);
	$intStart=$intNumber;
	for ($i=$intStart; $i>1; $i--)
	{
		if (substr($strIn, $i, 1)==" "  || substr($strIn, $i, 1)==",")
		{
			$out= substr($strIn, 0, $i);
			$lespos=strrpos($out,"<");
			$grepos=strrpos($out,">");
			if (($grepos<$lespos  || $grepos === false )  && $lespos<$intNumber   &&  !($lespos === false)  )
			{
				$grepos=strpos($strIn,">", $lespos)+1;
				$out = substr($strIn, 0, $grepos);
				$out=str_replace("<img ", "<img align=\"center\" width=\"100\" height=\"80\" ", $out);
				$bwlSkipElipsis=true;
			}
			if(!$bwlSkipElipsis)
			{
				//$out.="...";
			}
			break;
		}
		else if ($i<$intNumber-12)
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
	$out=RemoveEndCharactersIfMatch($out, ",");
	return $out;
}
}

function sheader($type, $othernav="")
{
    $width=640;
	$bgcolor="ffffee";
	$out="<html>

	<head>
	";
		$out.="<meta http-equiv=\"description\" content=\"Homesteading in rural Virginia in the late 1970s.\"><title>Homestead</title><link rel=\"stylesheet\" href=\"css.css\"></link>\n";
        //$out.="<script src=\"js.js\"  ><!--  --></script>\n";
		
		$out.="<script src=\"tableform_js.js\"><!--  --></script>
	
		\n
	</head>
<body  bgcolor=\"dddddd\" link=\"#333333\" vlink=\"666666\" alink=\"cccccc\" marginwidth=\"10\" leftmargin=\"10\" marginheight=\"10\" topmargin=\"10\" >";
// $out.="<a  href=\"javascript:editpopup('rf_data','calendar_event','calendar_event_id','1')\" target=_new>edit</a> ";
	

 


		//$out.="\n<table border='0'  cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" height=\"100%\">\n<tr><td align=\"center\" valign=\"top\" ><br>";
		$out.="\n<table border='0' cellpadding=\"0\" cellspacing=\"0\"   >" . chr(13);
		$out.= "\n<tr><td    colspan='2'>";
 
		$out.= "<span class=\"logo\">Homestead</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;by R.F. Mueller\n";
		$out= $out ."</td></tr>" . chr(13);
 

		

    	$out.= "<tr>";
		$out.= "<td valign=\"top\">";
		if($othernav!="")
		{
			$out.= $othernav;
		}
		else
		{
			$out.= nav();
		}
		$out= $out ."</td> ";
		$out= $out . "<td  class=\"textbox\" valign='top'>";

	return($out);


}

function sfooter()
{
    $width=800;
    $strfilename=thisfilename();
    
    //this is a total kludge for the unusual width og the sponsorsplash page.
    if ($strfilename=="sponsorsplash.php")
    {
        $width=816;
    }
    //end of kludge
    
	$out="";
	$out.="</td>" . chr(13);
	$out.="</td>";
	//$out= $out ."<td valign=\"top\">";
	//$out.=  "<img src=\"logo.gif\" width=\"67\" height=\"526\" alt=\"\">";
	//$out= $out ."</td>";
	$out.="</tr>" . chr(13);
	$out.="</table></td></tr></table>" . chr(13);
    $out.="</body>" . chr(13);
 	$out.="</html>" . chr(13);
	$out.="<script>
		//editpopup();
		</script>";
  return($out);
}

function random()
{
	list($usec, $sec) = explode(" ",microtime());
	$usec=substr($usec,strlen($usec)-5);
	//$usec=strrev($usec);
	$val=intval($usec)/99999;
	//echo("<br>" .$val);
	return($val);
}
if(!function_exists("inList"))
{
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
 }  
function retrieveDirs($path)
        {
            $delim = "\\"; // Change to "/" for unix
           
            if($dir=@opendir($path))
            {
                   $key = strrchr($path,$delim);
                   $key = substr($key,1,strlen($key));
                   
                   while(($file=readdir($dir))!== false) 
                   {
                     if(is_dir($path.$delim.$file) AND $file!= "." AND $file!= "..")
                     {
                           $array[$file] = retrieveDirs($path.$delim.$file);
                    }
                    elseif($file!= "." AND $file!= "..")
                    {
                        $array[] = $file;
                    }
                }
                   closedir($dir);
            }
        return $array;
        }

 
 



function logo($bgcolor)
{
//$bgcolor="ffffd0";
$height=103;
$width=261;
$swffile="logo.swf";
$canflash=true;
if (1==2)
{
	$swffile="logopure.swf";
}

$out=flash($swffile, $width, $height, $bgcolor);
return($out);
}

function thisfilename()
{
	//returns the name of the file we are on, with no path
	$arrfilename=split("/",$_SERVER['PHP_SELF']);
	$strfilename=$arrfilename[count($arrfilename)-1];
	return($strfilename);
}
if(!function_exists("cdata"))
{
function cdata($strIn,$intTypeIn, $intTypeOut, $strTranslate)
	//form of 'data' that uses an caret to divide rows from each other
	{
		$strOut=genericdata($strIn,$intTypeIn, $intTypeOut, $strTranslate, "^", "\|");
		return($strOut);
	}
}	
if(!function_exists("data"))
{
function data($strIn,$intTypeIn, $intTypeOut, $strTranslate)
	//using a double-delimited list $strTranslate of the form field1a|field2a|field3a-field1b|field2b|field3b-field1c...
	//you can retrieve the field number $intTypeOut in the record containing the first match of $strIn to the field specified by
	//$intTypeIn. if $intTypeIn is -1 then it returns a field from the record number specified by $strIn
	//this serves as very nice bare-bones database retrieval system
	{
		$strOut=genericdata($strIn,$intTypeIn, $intTypeOut, $strTranslate, "-", "|");
		return($strOut);
	}	
}
if(!function_exists("genericdata"))
{
function genericdata($strIn,$intTypeIn, $intTypeOut, $strTranslate, $rowdelimiter, $fielddelimiter)
	//form of 'data' that allows you to pass in your own delimiters
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
						if ($intTypeIn==-1) 
							{
								if ($strIn==$i+'')
								{
									$strOut=$arrThis[$intTypeOut];
									$bwlDone=1;
								}
								
							}
						else
							{
								//echo($arrThis[$intTypeIn] . "-" . $strIn . "*" . $arrThis[$intTypeOut] . "<br>");
								if ($arrThis[$intTypeIn]==$strIn)
									{
										$strOut=$arrThis[$intTypeOut];
										$bwlDone=1;
									}
							}
					}
			}
		return($strOut);
	}
}

if(!function_exists("beginswith"))
{
	function beginswith($strIn, $what)
	{
		if (substr($strIn,0, strlen($what))==$what)
		{
			return true;
		}
		return false;
	}
}

if(!function_exists("contains"))
{
	function contains($strIn, $what)
	{
		if (strpos(" " . $strIn, $what)>0)
		{
			return true;
		}
		return false;
	}
}

if(!function_exists("addlettersbyte"))
{
function addlettersbyte($in, $key, $mode="numeric")
//converts numbers into a byte stream
{
	$out="";
	$in=$in."";
	while (strlen($key)<strlen($in))
	{
		$key.=$key;
	}
	if($mode=="numeric")
	{
		for ($i=0; $i<strlen($in); $i++)
		{
			$intchrIn=ord(substr($in, $i, 1));
			$intchrKey=ord(substr($key, $i, 1));
			$out=$out.  str_pad(intval($intchrIn + $intchrKey), 3, "0", STR_PAD_LEFT);
		}
		$out=trim($out);
	}
	else
	{
		for ($i=0; $i<strlen($in); $i++)
		{
			$intchrIn=ord(substr($in, $i, 1));
			$intchrKey=ord(substr($key, $i, 1));
			$out=$out. chr($intchrIn + $intchrKey);
		}
	}
	return $out;
}
}

function nav()
{
	//provides unified site navigation based on double-delimited strConfig having the form filename1|label1-filename2|label2...
	$strfilename=thisfilename();
	$strQS= $_SERVER['QUERY_STRING'];
	if(contains(strtolower($_SERVER['HTTP_REFERER']), "asecular"))
	{
		$strQS= "src=as";
	}
	$bwlBanFrom= contains($strQS, "src=as") || contains( $_SERVER['SERVER_NAME'], "G") ;
	$strconfig="index.php|Home-sample.php|Sample work-samplecode.php|Sample code-tf_integration.php|Database visualizer-defs.php|Definitions-resume.php|Resume-feedback.php|Contact";
	$arrconfig=split("-",$strconfig);
	$count=count($arrconfig);
	$out="";
    $out.= "<table   cellspacing='0' cellpadding='4' border='0'  >";
	for ($i=0; $i<$count; $i++)
	{
		
		$arrthis=split("\|", $arrconfig[$i]);
		$strthisfile=$arrthis[0];
		//echo $strfilename . ". ." . $strthisfile . "<br>";
		if(!$bwlBanFrom  || $bwlBanFrom && $strthisfile!="feedback.php")
		{
		 	$out=$out . "<tr>";
			if ($strfilename!= $strthisfile)
			{
				$out=$out . "<td  class=\"nav\"><a  class=\"nav\"   href=\"" . $strthisfile . "?" . $strQS . "\">" . $arrthis[1] . "</a></nobr></td>" . chr(13);
			}
			else
			{
				$out=$out . "<td  class=\"navthere\"><nobr>" . $arrthis[1] . "</nobr></td> " . chr(13);
			}
			
			$out=$out . "</tr>";
		}
		
		
	}
    $out=$out . "</table>";
 	//$out=CalendarBrowser(gracefuldecay($_REQUEST[qpre . "startdate"], strtotime("April 1, 1975")), our_db, "index.php",1);
	return($out);
}


//new cool content functions
if(!function_exists("GenericDataPulldown"))
{
function GenericDataPulldown($strConfig, $intIDField, $intLabelField, $strQueryVariableName, $intThis, $strPHP, $strFormName)
{
	$intTop=-1;
	$strOut="";
	if ($strConfig!="")
	{
		if (strpos($strConfig, "-") >0)
		{
			$intTop=count(split("-",$strConfig));
		}
	}
	if (($strPHP!="") and ($strFormName!="")) 
	{
		$strOut=chr(13) . "<select name=\"" . $strQueryVariableName . "\" onChange=\"window.document.location.href='" . $strPHP . "?" . $strQueryVariableName . "=' + document." . $strFormName . "." . $strQueryVariableName . "[document." . $strFormName . "." . $strQueryVariableName . ".selectedIndex].value\">" . chr(13);
}
	else
	{
		$strOut=chr(13) . "<select name=\"" . $strQueryVariableName . "\">" . chr(13);
	}
	$strOut=$strOut . "<option value=\"\" >-none-" . chr(13);
 
	for ($t=0; $t<$intTop; $t++)
	{
		$strSel="";
		$intLocationID = data($t,-1,$intIDField,$strConfig);
		$strLabel=data($t,-1,$intLabelField,$strConfig);
 
		if ($strLabel!="")
		{
			if  ($intThis.""==$intLocationID."")
			{
				$strSel="selected";
			}
			$strOut=$strOut . "<option value=\"" . $intLocationID. "\" " . $strSel . ">" . $strLabel . chr(13);
		}
	}
	$strOut=$strOut . "</select>"  . chr(13);
 
	return($strOut);
}

}
	
function expirepulldowns($strNamePre,$dtmDefault)
{

  if (is_numeric($dtmDefault))
  {

    $intMonth=strftime("%m",$dtmDefault);
    $intYear=strftime("%Y",$dtmDefault);
  }
    else
  {

    $intMonth="";
    $intYear="";
  } 

  if (strlen($intYear)==4)
  {
    $intYear=intval(substr($intYear,strlen($intYear)-(2)));
  } 
  if (substr($intYear,0,1)=="0")
  {
    $intYear=intval(substr($intYear,strlen($intYear)-(1)));
  } 
  $strOut=$strOut."\n".numericpulldown(1,12,$intMonth,$strNamePre."_month")."\n"." / "."\n".numericpulldown(0,22,$intYear,$strNamePre."_year")."\n";
  $function_ret=$strOut;
  return $function_ret;
} 
if(!function_exists("numericpulldown"))
{
function numericpulldown($intstart,$intend,$intdefault,$strName)
{
//gives me a select with numbers running from $intstart to $intend, with $intdefault selected, and names it $strName
  $strOut="<select name=".chr(34).$strName.chr(34).">"."\n";
  $strOut=$strOut."<option value=".chr(34).chr(34).">none"."\n";
  for ($intNumber=$intstart; $intNumber<=$intend; $intNumber++)
  {
    $strSel="";
    if ($intNumber==$intdefault)
    {
      $strSel=" selected ";
    } 
    $strOut=$strOut."<option value=".$intNumber.$strSel.">".$intNumber."\n";
  } 
  $strOut=$strOut."</select>"."\n";
  $function_ret=$strOut;
  return $function_ret;
} 
}
function statepulldown($strDefault, $strName)
{

	 $strConfig="Alabama-Alaska-Arizona-Arkansas-California-Colorado-Connecticut-Delaware-District Of Columbia-Florida-Georgia-Hawaii-Idaho-Illinois-Indiana-Iowa-Kansas-Kentucky-Louisiana-Maine-Maryland-Massachusetts-Michigan-Minnesota-Mississippi-Missouri-Montana-Nebraska-Nevada-New Hampshire-New Jersey-New Mexico-New York-North Carolina-North Dakota-Ohio-Oklahoma-Oregon-Pennsylvania-Puerto Rico-Rhode Island-South Carolina-South Dakota-Tennessee-texas-Utah-Vermont-Virginia-Washington-West Virginia-Wisconsin-_______-Alberta-British Columbia-Manitoba-New Brunswick-Newfoundland-Northwest Territories-Nova Scotia-Ontario-Prince Edward Island-Quebec-Saskatchewan-Yukon";
	 $intIDField=0;
	 $intLabelField=0;
	 $strQueryVariableName="cctype";
	 $intThis=0;
	 $strPHP="";
	 $strFormName="";
	 $strOut= GenericDataPulldown($strConfig, $intIDField, $intLabelField, $strName, $strDefault, $strPHP, $strFormName);
	 return($strOut);
} 

function addressfield($arrDefaultValues, $strNamePrefix, $intSize)
{
	$intBig=$intSize*3;
	$strOut="<input type=\"text\" name=\"". $strNamePrefix. "Address\" size=\"".$intBig."\" value=\"".$arrDefaultValues[0]."\">".chr(13);
	$strOut=$strOut."<br>".chr(13);
	$strOut=$strOut."<input type=\"text\" name=\"". $strNamePrefix. "Address2\" size=\"".$intBig."\" value=\"".$arrDefaultValues[1]."\">".chr(13);
	$strOut=$strOut."<br>".chr(13);
	$strOut=$strOut."City <input type=\"text\" name=\"". $strNamePrefix. "City\" size=\"".$intSize."\" value=\"".$arrDefaultValues[2]."\"> ".chr(13);
	$strOut=$strOut." State ".chr(13);
	$strOut=$strOut.statepulldown($arrDefaultValues[3], $strNamePrefix."State");
	$strOut=$strOut."<div align=\"right\">".chr(13);
	$strOut=$strOut."ZIP code <input type=\"text\" name=\"". $strNamePrefix. "Zip\" size=\"".$intSize."\" value=\"".$arrDefaultValues[4]."\"> ".chr(13);
	$strOut=$strOut."</div>".chr(13);
	return($strOut);
} 

function escape($strIn)
{
	$strOut= str_replace("\"", "\\"."\"", $strIn);
	return($strOut);
}

function giftaddress($GiftName, $GiftAddress, $GiftAddress2 ,  $GiftCity ,  $GiftState, $GiftZip )
{
	$out=$out . "<center><b>". $GiftName . "<br>" .  $GiftAddress . "<br>";
	if ($GiftAddress2!="")
	{
		$out=$out . $GiftAddress2 . "<br>";
	}
	$out=$out  . $GiftCity . ", " . $GiftState . " " . $GiftZip . "</b></center>";
	return($out);
}

//sponsorship functions//////////////////////


function displaycell($arrIn, $count, $strSponsorURLprefix)
{
	//draws a single animal picture with caption and necessary links


	$imageurl=$arrIn[0];
	$width=$arrIn[1];
	$height=$arrIn[2];
	$caption=$arrIn[3];
	$name=$arrIn[4];
	$type=$arrIn[5];
	$bigger=$arrIn[6];
	$dtmAdopted=$arrIn[7];
					
	$out=chr(13).chr(9)."<table cellpadding=0 cellspacing=0 border=0 >". chr(13);
	$out=$out . chr(9). "<tr>" .chr(13);
	$out=$out . chr(9). "<td valign=top>" .chr(13);
	$out=$out . chr(9). "<a href=sponsor.php?i=" . $count . "><img src=\"" . $strSponsorURLprefix. $imageurl . "\"";
	if ($width !="")
	{
		$out=$out . " width=" .$width ;
	}
	if ($height !="")
	{
		$out=$out . " height=" .$height;
	}
	//if ($caption !="")
	//{
		//$out=$out . " alt\"=" .$caption . "\"" ;
	//}
 
		$out=$out . " alt\"=Hello, my name is " .  $name . ". Click on my picture to find out how to sponsor me.\"" ;
	
	$out=$out . ">" . chr(13);
	$out=$out . chr(9) . "</td>" .chr(13);
	$out=$out . chr(9). "</tr>" .chr(13);
	$out=$out . chr(9). "<tr>" .chr(13);
	$out=$out . chr(9). "<td align=center>" . chr(13);
	$out=$out . chr(9). "<b>" . $name . "</b>" . chr(13);
	$biggerpic=biggersponsorpicurl($imageurl,$bigger,$strSponsorURLprefix);
	if ($biggerpic!="")
	{
		$out=$out . chr(9). "(<a class=tiny href=\"". $biggerpic . "\" target=_new >enlarge</a>)" .chr(13);
	
	}
	$out=$out . chr(9). "<br>" . chr(13);
	$out=$out . chr(9). $caption .chr(13);

	$out=$out . chr(9). "</td>" .chr(13);
	$out=$out . chr(9). "</tr>" .chr(13);
	$out=$out . chr(9) ."</table >". chr(13);
	return ($out);
}

function configstringclean($strIn)
{
	return(str_replace(chr(13), "", $strIn));
}

function tabulardisplay($strConfig, $intDisplayWidth, $intField, $strCriteria, $strSponsorURLprefix)
	{
	//takes a double-delimited strConfig and spits out a table of pretty animal pictures
	$rowdelimeter=chr(10);
	$strFieldDelimiter="|";
    //echo $strConfig;
	$strConfig= configstringclean($strConfig);
	$out= chr(13) . "<table border=0>" . chr(13);
	$arrRows=explode($rowdelimeter, $strConfig);
	$intOut=0;
	$intProduced=count($arrRows);
    //echo $intProduced;
 
	for($t=0; $t<$intProduced; $t++)
			{
		 		if (strlen($arrRows[$t])>3)
					if (strpos($arrRows[$t],$strFieldDelimiter) >0)
					{
						{
							if (intval($intOut/$intDisplayWidth)==$intOut/ $intDisplayWidth) 
							{
								$out=$out. chr(13).  "<tr>";
							}
					 
							$arrThis=explode($strFieldDelimiter, $arrRows[$t]);
							
						
							$bwlShow=false;
							if ($strCriteria=="*") //if $strCriteria is *, all the field has to be is not empty to show
							{
								if (strlen($arrThis[$intField])>0)
								{
									$bwlShow=true;
								}
							}
							else
							{
								if ($arrThis[$intField]==$strCriteria)
								{
									$bwlShow=true;
								}
							}
							if ($bwlShow) //show if criteria matches
							{
								$out=$out. chr(13) . "<td valign=top>";
								$out=$out .displaycell($arrThis, $t, $strSponsorURLprefix);
								$out=$out. chr(13).  "</td>";
								$intOut++;

							}
							if (intval(($intOut+$intDisplayWidth)/$intDisplayWidth)==($intOut+$intDisplayWidth)/$intDisplayWidth)
								{
									$out=$out. chr(13).  "</tr>";
								}
							
						}
					}
			}
	$out=$out.  "</table>".chr(13);
	return($out);
}

function biggersponsorpicurl($strURL, $bigger, $strPrefix)
//where the $strURL is the smaller picture, $bigger is a hard-set $bigger url, and $strPrefix is the url path prefix.
{
//echo $bigger . "<br>";
	$biggerpic=str_replace( "_small", "", $strURL);
	$biggerpic=str_replace( "_150", "", $biggerpic);
	//echo($bigger . "-" . file_exists($bigger) . ":" . ($bigger + ""!="") . "*" . file_exists($biggerpic). "<br>");
   if (file_exists( $strPrefix . $bigger) and ($bigger !=""))
		{
        
		return( $strPrefix . $bigger);
		
		}
 else if (file_exists($strPrefix.$biggerpic) )
		{
			 
		//echo $biggerpic . "<br>";
		return($strPrefix.$biggerpic);
		
		}
	
	else if ($bigger=="")
		{
		return("");
		}
		
	else if (file_exists($strPrefix.$bigger)  && $bigger!="" )
		{
		return($strPrefix.$bigger);
		
		}

		return($strPrefix.$biggerpic);
		
}
 


function sitetext($key)
{
	return GenericDBLookup(our_db,  "site_text",  "name",$key, "value");
}


function DropcapFirstLetter($strIn)
{
//dropcaps the first letter of strIn;
	$out="";
	$strIn=trim($strIn);
	//skip opening tags!!!
	if(substr($strIn, 0, 1)=="<")
	{
		$goodpos=strpos($strIn, ">");
		$strIn=substr($strIn, $goodpos+1);
	}
	$chr1=substr($strIn, 0, 1);
	$strRest=substr($strIn, 1);
	$out.="<div style=\"font-size:8px\"><table align=left cellspacing=\"0\" border=\"0\" cellpadding=\"0\">\n";
	$out.="<tr><td><span style=\"font-size:70px\">" . $chr1 . "</span></td></tr>";
	$out.="</table><br></div>";
 	$out.=$strRest;
	return $out;
}

function CaptionImages($strIn, $align="left")
{
	$imageurlone=parseBetween($strIn, "src=",'"');
	$imageurltwo=parseBetween($strIn, 'src="','"');
	if(strlen($imageurltwo)>strlen($imageurlone))
	{
		$foundimage=$imageurltwo;
	}
	else
	{
		$foundimage=$imageurlone;
	}
	$caption=parseBetween($strIn, 'alt="','"');
	$foundimage=RemoveEndCharactersIfMatch($foundimage, '"');
	$imagehtml="<table align=\"" . $align . "\" width=1 cellpadding=\"9\">\n";
	$imagehtml.="<tr><td>\n";
	$imagehtml.="<img src=\"" . $foundimage . "\"   alt=\"" . $caption . "\">\n";
	$imagehtml.="</td></tr>\n";
	$imagehtml.="<tr><td align=\"center\">\n";
	$imagehtml.="<span style=\"font-size:10px\">\n";
	$imagehtml.= $caption . "\n";
	$imagehtml.="</span>\n";
	$imagehtml.="</td></tr>\n";
	$imagehtml.="</table>\n";
	$startpos=strpos($strIn, "<img");
	$endpos=strpos($strIn, ">", $startpos);
	$out=substr($strIn, 0, $startpos-1) . $imagehtml . substr($strIn, $endpos+1);
	return $out;

}
?>