<?php 

/////////////////
///encryption///
///////////////


function ScaleEmbeddedIntegers($in, $scale=61, $bwlRejectFractions=true)
{
	//only works for whole numbers
	//goes through a string and multiplies any integers it finds by $scale and returns the string with these new numbers embedded instead
	//i use it to make ids non-consecutive in an encrypted query string
	$out="";
	$arrNumbers=Array();
	$arrBetweenNumbers=Array();
	$count=0;
	$bwlNumber=false;
	$currentbetween="";
	$currentnumber="";
	for ($i=0; $i<strlen($in); $i++)
	{		
 		$thisChr=substr($in, $i, 1);
		$thisord=ord($thisChr);
		//echo $thisord . "<br>";
		if($thisord > 47 && $thisord<58)
		{
			$bwlNumber=true;
			if($currentbetween!="")
			{
				$arrBetweenNumbers[$count]=$currentbetween;
				//echo $currentbetween . "<br>";
				$currentbetween="";
				$count++;
			}
		}
		else
		{
			$bwlNumber=false;
			if($currentnumber!="")
			{
				$arrNumbers[$count]=$currentnumber;
				//echo $currentnumber . "<br>";
				$currentnumber="";
				$count++;
			
			}
		}
		if($bwlNumber)
		{
			$currentnumber.=$thisChr;
		
		}
		else
		{
			$currentbetween.=$thisChr;
		}
		
	}
	if($currentnumber!="")
	{
		$arrNumbers[$count]=$currentnumber;
	}
	else
	{
		$arrBetweenNumbers[$count]=$currentbetween;
	}
	
	for($i=0; $i<$count+1; $i++)
	{
	
	 	if($arrBetweenNumbers[$i]!="")
		{
			$out.=$arrBetweenNumbers[$i];
		}
		else if($arrNumbers[$i]!="")
		{
			if($bwlRejectFractions)
			{
				$thisNum=$arrNumbers[$i] * $scale;
				if(intval($thisNum)==$thisNum)
				{
					$out.=$thisNum;
				}
				else
				{
					$out.="ERROR!";
				}
				
			}
			else
			{
				$out.=round(intval($arrNumbers[$i]) * $scale);
			}
		}
	
	
	}
	return $out;
}

function NumberStringToStringString($in)
{
	//produces an encoded version of a string of numbers using every pair of numbers to encode 
	//either a mixcased letter, a number, or an escaped letter or number
	//is url-compatible 
	//Judas Gutenberg September 24 2009
	$start=0;
	$out="";
	while($start<strlen($in))
	{
 		$thisPiece=intval(substr($in, $start, 2));
		
		$escape="";
		if($thisPiece>61)
		{
			$escape="-";
			$thisPiece=$thisPiece-62;
		}
		if($thisPiece<26)
		{
			$thischr=$thisPiece+ 65;
		
		}
		else if($thisPiece>25  && $thisPiece<52)
		{
			$thischr=($thisPiece-26)+ 97;
		
		}
		else if($thisPiece>51  && $thisPiece<62)
		{
			$thischr=($thisPiece-52)+ 48;
		
		}
		
		//echo $thisPiece . " " . $thischr . "<br>";
		$out.=$escape . chr($thischr);
		$start=$start+2;
	}
	return $out;
}

function LetterStringToNumberString($in)
{
	//Judas Gutenberg September 24 2009
	$out="";
	$amounttoadd=0;
	//echo $in;
	for ($i=0; $i<strlen($in); $i++)
	{

			
 		$thisChr=substr($in, $i, 1);
		if($thisChr=="-")
		{
			$amounttoadd=62;
		}
		else
		{
			$ordval=ord($thisChr);
			if($ordval>64  && $ordval<91)
			{
				$thisout=$ordval-65 + $amounttoadd;
			}
			else if($ordval>96  && $ordval<123)
			{
				$thisout=($ordval-97) +26+ $amounttoadd;
			}
			else if($ordval>47  && $ordval<58)
			{
				$thisout=($ordval-48) +52+ $amounttoadd;
			}
			else
			{
				$thisout=0;
			}
			$amounttoadd=0;
			$out.=str_pad(intval($thisout),2,"0", STR_PAD_LEFT);
		}
		
	}
	return $out;
}

function EncryptQS($qs, $humanreadable="", $intHumanReadableSize=19, $intAbsurdityRate=0, $intScale=401)
{
	$subencrypted=addletters(ScaleEmbeddedIntegers($qs, $intScale),encryptionkey, "numericnodelimiter", $intAbsurdityRate);
	$intLen=strlen($subencrypted);
	$intLenToUse=  ($intLen % 2) +$intLen;
	//echo "<br>-" .$intLen . "==" . $intLenToUse . "-0<br>";
	//echo $subencrypted . "-1<br>";
	//str_pad(intval($intchrIn + $intchrKey),3,"0", STR_PAD_LEFT);
	$subencrypted=str_pad($subencrypted,$intLenToUse,"0", STR_PAD_RIGHT);
	//echo $subencrypted . "-2<br>";
 	$encryptedstring=NumberStringToStringString(strrev($subencrypted));
	//echo $encryptedstring . "-3<br>";
	if($humanreadable!="")
	{	
		$humanreadable=str_replace(" ", "_", $humanreadable);
		$humanreadable=radicaldeescape($humanreadable, false);
		$humanreadable= FilterString($humanreadable,"48-57 a-z A-Z _ ", "");
		$out=truncate($humanreadable, $intHumanReadableSize, "end",true);
	}
	if( $out!="")
	{
		$out=qpre . "eq=" . $out . "|" . $encryptedstring;
	}
	else
	{
		$out=qpre . "eq=" . $encryptedstring;
	}
	return $out;
}

function DecryptStringToQS($qs="", $bwlJustReturnArray=false, $bwlDebug=false, $bwlRejectWild=true, $strResultArray="request", $intScale=401)
{
	if($qs=="")
	{
		$qs=$_REQUEST[qpre . "eq"];
	}
	if(!contains($qs, "|"))
	{
		$qs="|" . $qs;
	}
 	$arrQS=explode("|", $qs);
	if(is_array($arrQS))
	{
		$partWeParse=strrev(trim(LetterStringToNumberString($arrQS[count($arrQS)-1])));
		//echo $partWeParse . "=1<br>";
		//good:2231722202082201482201771611591681641510
		// bad:2231722202082201482201771611591681648310
		$partWeParse=subtractletters($partWeParse,encryptionkey, "numericnodelimiter", $bwlRejectWild);
		//echo "<br>*" . $partWeParse . "*" . $intScale  . "*2<br>";
		$partWeParse=ScaleEmbeddedIntegers($partWeParse, (1/$intScale));
		//echo "<br>*" . $partWeParse . "*3<br>";
		$arrForQS=QuerystringToAssociativeArray($partWeParse);
		if(!$bwlJustReturnArray)
		{
			foreach($arrForQS as $k=>$v)
			{
				//echo "<p style='color:#009900'>" . $k . " " . $v . "<br>";
				if($strResultArray=="get")
				{
					$_GET[$k]=$v;
				}
				else if ($strResultArray=="post")
				{
					$_POST[$k]=$v;
				}
				else if ($strResultArray=="request")
				{
					$_REQUEST[$k]=$v;
				}
				if($bwlDebug)
				{
					echo $k . " " . $v . "=<br>\n";
				}
			}
		}
	}
	return $arrForQS;
}


function addletters($in, $key, $mode="", $intAbsurdityRate=0)
//converts numbers into a letter stream
{
	$out="";
	$in=$in."";
	//while (strlen($key)<strlen($in))
	{
		//$key.=$key;
	}
	if($mode=="numeric")
	{
		for ($i=0; $i<strlen($in); $i++)
		{
			$keyi= $i % strlen($key);
			$intchrIn=ord(substr($in, $i, 1));
			$intchrKey=ord(substr($key, $keyi, 1));
			$out=$out. " " . intval($intchrIn + $intchrKey);
		}
		$out=trim($out);
	}
	else if($mode=="numericnodelimiter")
	{
		for ($i=0; $i<strlen($in); $i++)
		{
			$keyi= $i % strlen($key);
			$intchrIn=ord(substr($in, $i, 1));
			$intchrKey=ord(substr($key, $keyi, 1));
			if($intAbsurdityRate>0)
			{
				$thisrand=rand(0,$intAbsurdityRate);
				if($thisrand/$intAbsurdityRate==intval($thisrand/$intAbsurdityRate))
				{
					$out=$out.  rand(501,  999) ;
				}
			}
			$out=$out. str_pad(intval($intchrIn + $intchrKey),3,"0", STR_PAD_LEFT);
		}
		$out=trim($out);
	}
	else
	{
		for ($i=0; $i<strlen($in); $i++)
		{
			$keyi= $i % strlen($key);
			$intchrIn=ord(substr($in, $i, 1));
			$intchrKey=ord(substr($key, $keyi, 1));
			$out=$out. chr($intchrIn + $intchrKey);
		}
	}
	return $out;
}

function subtractletters($in, $key, $mode="", $bwlRejectWild=true)
//converts numbers into a letter stream
{
	$out="";
	$start=0;
	//while (strlen($key)<strlen($in))
	{
		//$key.=$key;
	}
	if($mode=="numeric")
	{
		$arrThis=explode(" ", $in);
		for ($i=0; $i<count($arrThis); $i++)
		{
			$keyi= $i % strlen($key);
			$intchrIn=$arrThis[$i];
			$intchrKey=ord(substr($key, $keyi, 1));
			$out=$out. chr($intchrIn - $intchrKey);
		}
	}
	else if($mode=="numericnodelimiter")
	{
		while($start<strlen($in))
		{
	 		$keyi= $i % strlen($key);
			$intchrIn=substr($in, $start, 3);
		 	if(intval($intchrIn)<500)
			{
				$intchrKey=ord(substr($key, $keyi,1));
				//echo $intchrIn . " " . $intchrKey . "..<br>";
				$thischarord=$intchrIn - $intchrKey;
				if(($thischarord<0)  && $bwlRejectWild)
				{
					//echo $thischarord . "=<br>";
				}
				else
				{
					$out=$out. chr($thischarord);
				}
				$i++;
			}
			else
			{
				//echo $intchrIn . "<br>";
			}
			$start=$start+3;
			
		}
		 
	}
	else
	{
		for ($i=0; $i<strlen($in); $i++)
		{
			$keyi= $i % strlen($key);
			$intchrIn=ord(substr($in, $i, 1));
			$intchrKey=ord(substr($key, $keyi, 1));
			$out=$out. chr($intchrIn - $intchrKey);
		}
	}
	return $out;
}


function wordencode($intNumber, $intDigits, $rndhelp)
//Encodes a number as a sequence of words.  
//Depends on a table called word_coding with a column of words called "word"
{
	$out="";
	$that="";
	$strNumber=str_pad($intNumber, $intDigits, "0", STR_PAD_LEFT);
	for($i=0; $i<$intDigits; $i=$i+3)
	{
		$that=substr($strNumber, $i, 3);
		{
			$thisnumber=intval($that);
			if ($thisnumber==0)
			{
				srand((double)$rndhelp); 
				$thisnumber = rand(0,40)+1000; 
			}
			$word=GenericDBLookup(our_db,  "word_coding", "word_coding_id", $thisnumber, "word");
			$out.=$word . " ";
		}
	}
	$out=RemoveEndCharactersIfMatch($out, " ");
	return $out;
}


function worddecode($strPhrase)
//Decodes a phrase created by wordencode
//Depends on a table called word_coding with a column of words called "word."
{
	$strPhrase=strtolower($strPhrase);
	$strPhrase=str_replace("-", " ", $strPhrase);
	$strPhrase=str_replace("=", " ", $strPhrase);
	$strPhrase=str_replace(".", " ", $strPhrase);
	$strPhrase=str_replace(",", " ", $strPhrase);
	$strPhrase=str_replace(":", " ", $strPhrase);
	$strPhrase=str_replace(";", " ", $strPhrase);
	$arrPhrase=explode(" ", $strPhrase);
	$out="";
	$that="";
	$strNumber=str_pad($intNumber, $intDigits, "0", STR_PAD_LEFT);
 
	for($i=0; $i<count($arrPhrase); $i++)
	{
		$that=$arrPhrase[$i];
		if ($that!="")
		{
			$thisnumber=GenericDBLookup(our_db,  "word_coding", "word", $that, "word_coding_id");
			if ($thisnumber<1000)
			{
				$intDigits=str_pad($thisnumber,3, "0", STR_PAD_LEFT);
				$intDigits=intval($intDigits);
			}
			else
			{
				$intDigits="000";
			}
			$out.=$intDigits;
		}
	}
	return $out;
}


?>