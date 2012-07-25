<?php
//This code is covered under the GNU General Public License
//info here: http://www.gnu.org/copyleft/gpl.html
//the digest is as follows: you cannot modify this code without
//publishing your source code under the same license
//contact the developer at gus@asecular.com  http://asecular.com

function SerializeExpand($strDatabase, $stTable, $strIDField, $strID, $strPHP)
	{
	//display a specific record and throw a form around the serialized data too
	//Judas Gutenberg 11-16-2007
		$out="";
		$strLineClass="bgclassline";
		$strClassFirst="bgclassfirst";
		$strClassSecond="bgclasssecond";
		$strOtherBgClass="bgclassother";
		$strOtherLineClass="bgclassline";
		$intWidth=500;
		$strMode="save";
		$preout="<form enctype=\"multipart/form-data\" name=\"BForm\" method=\"post\" action=\"" . $strPHP . "\" onSubmit=\" return validate_form();\">\n";
 
		$sql=conDB();
		$strSQL="SELECT * FROM " . $strDatabase . "." . $stTable . " WHERE " . $strIDField . "='" .  $strID . "'";
		//echo $strSQL;
		$records = $sql->query($strSQL);
		$record=$records[0];
		 
		$intFieldCount=0;
		$row="";
		foreach ($record as $key => $value)
		{
			$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
			if(beginswith($value, "a:")   && contains($value, ":{")  &&  contains($value, ";}"))
			{
				//echo $value;
				$value=SerializeForm($value,  qpre . "serialized|" . $key , $strThisBgClass);
			}
			$out.=htmlrow($strThisBgClass, "<b>" . $key . "</b>" , $value);
		}
		
			$out.=HiddenInputs(array("needtoencryptonsave"=>$needtoencrypt,"dropdowntextvalue"=>"", "rec"=>$intRecord, "column"=>$strSort, "direction"=>$strDirection, "backfield"=>$strBackfield));
		$out.=HiddenInputs(array("table"=>$strTable,"table"=>$strTable,"db"=>$strDatabase,"mode"=>$strMode,"idfield"=>$strIDField,"behave"=>$strConfigBehave ),qpre, $strFieldNamePrefix);
                                                                               
		$out.="<input type=\"hidden\" name=\"" . $strFieldNamePrefix . qpre. "oldid\"   value=\"".  $strValDefault . "\">\n"; 

		$out.=htmlrow($strThisBgClass, "&nbsp;", "<div align=\"right\">" . GenericInput(qpre . "submit", "Save")) . "</div>";
		$out= TableEncapsulate($out, false);
		$out.= "</form>\n";
	
		return $out;
	}

	
function SerializeForm($value,  $passinname, $class)
{
//display a form for editing serialized data ($value)
	$out="";
	$thisarr=unserialize($value);
	$strLineClass="bgclassline";
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strOtherBgClass="bgclassother";
	$strOtherLineClass="bgclassline";
	foreach ($thisarr as $key => $v)
	{
		$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
		//echo gettype($v) . "<br>";
		if(gettype($v)=="array")
		{
			if(count($v)<1)
			{
				 
				$v=GenericInput($passinname  . "|" . $key,"",  false,  "",   "",  "",  "text", 20,  "", 1);
				$out.=htmlrow($strThisBgClass, "<b>" . $key . "</b>" , $v);
			}
			else
			{
			//echo "$$$<br>";
				$out.=htmlrow($strThisBgClass, "<b>" . $key . "</b>" , ArrayForm($v, $key, $passinname . "|" . $key, $strThisBgClass));
			}
		}
		elseif(gettype($v)=="object")
		{
			 
			//$out.=htmlrow($strThisBgClass, "<b>" . $key . "</b>" , ArrayForm($v, $key, $passinname . "|" . $key, $strThisBgClass));
			 
		
		}
		else
		{
			CalculateProbableTextAreaDimensions($v, $width, $height, 5);
			$v=GenericInput($passinname  . "|" . $key, $v,  false,  "",   "",  "",  "text", $width,  "", $height);
			//$v=TextInput($passinname . "|" . $key, $v, 20,  "" );
			$out.=htmlrow($strThisBgClass, "<b>" . $key . "</b>" , $v);
		}
	
	}
	$out= TableEncapsulate($out, false);
	//at this point I need a way to manually add data structures
	//using freeform serialized data
	//ideally I'd have a way to do this graphically using DHTML
	$out.="freeform serialized data<br/>" . GenericInput(qpre. "serialextra", "",  false, "",   "",  "", "text", "40", "", 12);
	return $out;
}


function ArrayForm($arrIn, $name, $passinname, $class)
{
//display a sub-form around an Array inside the serialized data.
//if an array item is in turn another array, go recursive!
	$out="";
	$strLineClass="bgclassline";
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strOtherBgClass="bgclassother";
	$strOtherLineClass="bgclassline";
 
	foreach ($arrIn as $key => $v)
	{
		$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
		if(gettype($v)=="array")
		{
			if(count($v)<1)
			{
				$v=TextInput($passinname . "|" . $key, $v, 30,  "" );
				$out.=htmlrow($strThisBgClass, "<b>" . $key . "</b>" , $v);
			}
			else
			{
				$out.=htmlrow($strThisBgClass, "<b>" . $key . "</b>" , ArrayForm($v, $key, $passinname . "|" . $key, $strThisBgClass));
			}	
		}
		else
		{
			$v=TextInput($passinname . "|" . $key, $v, 20,  "" );
			$out.=htmlrow($strThisBgClass, "<b>" . $key . "</b>" , $v);
		}
	
	}
	//GenericInput($name, $default, $bwlChecked=false, $onClick="",  $strStyle="", $strClass="", $type="submit", $size="", $strStrayJS="", $height=1)
	$out= TableEncapsulate($out, false);
	return $out;
}


function ReadSerializedForm(&$key, &$serializeddone, $defaultvalue)
{
//if, when reading form items to save from tableform, we encounter
//a form variable beginning with x_serialized|, we search the $_POST array
//for all the serialized data available and then build and return a string.
//in the process we create a space-delimited list of serialized variables to ignore,
//$serializeddone, returned by reference, and a $key (also by reference).  the $key
//is the DB column name of the serialized data 
//$defaultvalue contains the output if serialization should fail
//Judas Gutenberg 11-16-2007
	$arrPath=explode("|", $key);
	//echo $k . "-----" . $serializeddone . " " .$arrPath[1]  .  "<br>";
	if(!inList($serializeddone,$arrPath[1]))
	{	
		$k=$arrPath[1];
		$serializeddone.=" " . $k;
		foreach($_POST as $ks=>$vs)
		{
			//echo $ks . "-----<br>";
			if(beginswith($ks, qpre . "serialized|"))
			{
				$arrPath=explode("|", $ks);
				$strToExec="";
				for($pathcount=2; $pathcount<count($arrPath); $pathcount++)//must start at 2 because 0 is the indication that it is serialized data to begin with, and 1 is the name of the field
				{
				
					$thisArrName=$arrPath[$pathcount];
					$strToExec.="['" . singlequoteescape($thisArrName) . "']";
					
					if( $pathcount==count($arrPath)-1)
					{
						$strToExec.="='" . $vs . "'";
						//echo "END: " . $thisArrName .  " " . $vs . "-<br>";
					}
				}
				$strToExec='$arrThis' . $strToExec . ";";
				//error_reporting(6143);
				//the easiest way to handle this is to make a PHP string and eval it
				eval($strToExec);
			}
		
		}
		$serialextra=trim($_POST[qpre . "serialextra"]);
		//echo $serialextra;
		
		//a sample snatch of serialized data in all its brutal ugliness:	//s:11:"identifiers";a:2:{s:1:"P";a:2:{s:5:"login";s:4:"root";s:10:"login_type";s:1:"P";}s:1:"A";a:2:{s:5:"login";s:4:"root";s:10:"login_type";s:1:"P";}}
		if (!beginswith($serialextra,"a:"))//in case our extra serialized is not sent as an array
		{
			//echo "<br>##";
			$serialextra="a:1:{" . $serialextra . "};";
		
		}
		$arrExtra=unserialize($serialextra);
		if(count($arrExtra)>0)
		{
			//this should only reset the top-level dimensions of the $arrExtra array
			foreach($arrExtra as $ke=>$ve)
			{
				//echo $k  . " " . $v . "<br>";
				$arrThis[$ke]=$ve;
			}
		}
		$key=$k;
		$v=serialize($arrThis) . "<p>";
	}
	else
	{
		$v=$defaultvalue;
	}
	
	return $v;
}
?>