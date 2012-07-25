<?
//i worked hard to make this code as generic as possible 
//january 28 2009
//judas gutenberg
//to use this include, populate $strRequiredConfig with a string in this format:
//requiredfield|errormessage|isdate(1 or 0)|additionaltest(such as indexOf('@')>0)~next record....
//the delimiters are pipe and squiggle
//also put a onSubmit="return(regcheckform())" in the applicable form, which, unless $FormName is changed, must be named
//BForm 

$FormName="BForm";
?>
<script>
qpre="x_";

function IsNumeric(strString)
  //  check for valid numeric strings	
  {
  var strValidChars = "0123456789.-";
  var strChar;
  var blnResult = true;

  if (strString.length == 0) return false;

  //  test strString consists of valid characters listed above
  for (i = 0; i < strString.length && blnResult == true; i++)
     {
     strChar = strString.charAt(i);
     if (strValidChars.indexOf(strChar) == -1)
        {
        blnResult = false;
        }
     }
  return blnResult;
  }
  
function GetFormItemValue(formname, itemname, isdatecomplex)
//works with selects, textareas, text inputs, checkboxes, or radio button arrays
{	
	if(document[formname])
	{
		if(document[formname][itemname])
		{
			itemobj=document[formname][itemname];
			//alert(itemobj);
			
			if(isdatecomplex==true)
			{
			
				strpre=qpre + itemname ;
				itemobj=document[formname];
				 
				if(itemobj[strpre + "|month"]  && itemobj[strpre + "|year"]  && itemobj[strpre + "|day"])
				{
				 
				 	//alert(strpre + " ---- " + itemobj[strpre + "|month"].selectedIndex  + " " + itemobj[strpre + "|year"].selectedIndex  + " " + itemobj[strpre + "|day"].selectedIndex);
					if(itemobj[strpre + "|month"].selectedIndex>-1  && itemobj[strpre + "|year"].selectedIndex >-1 && itemobj[strpre + "|day"].selectedIndex>-1)
					{
						var monthsel=itemobj[strpre + "|month"].selectedIndex;
						var daysel=itemobj[strpre + "|day"].selectedIndex;
						var yearsel=itemobj[strpre + "|year"].selectedIndex;
						 //alert(itemobj[strpre + "|month"][monthsel].value + "-"  + itemobj[strpre + "|day"][daysel].value + "-" + itemobj[strpre + "|year"][yearsel].value);
						return itemobj[strpre + "|month"][monthsel].value  + "-"  + itemobj[strpre + "|day"][daysel].value + "-" + itemobj[strpre + "|year"][yearsel].value;
					}
				}
			
			}
			else
			
			{
				if(itemobj)
				{
					if (document[formname][itemname])
					{
						if(itemobj.selectedIndex)
						{
							return itemobj[itemobj.selectedIndex].value;
						}
						else
						{
							return itemobj.value;
						}
					}
				}
			}
		}
	}
	return "";
}

function regcheckform()
{
 	//alert("$");
	var f=document.<?=$FormName?>;
	var thiserror="";
	<?
	
if($_REQUEST["requiredconfig"]!="")
{
	//strictly for testing!!!
	$strRequiredConfig =$_REQUEST["requiredconfig"];
}
//format for $strRequiredConfig:
//requiredfield|errormessage|isdate(1 or 0)|additionaltest(such as indexOf('@')>0)~next record....
$arrRequiredconfig=explode("~", $strRequiredConfig);
$passwordmatchcode="";
foreach($arrRequiredconfig as $thisrequiredconfig)
{	
	$additonalTests="";
	if($thisrequiredconfig!="")
	{
	$arrThisRequiredConfig=explode("|", $thisrequiredconfig);
	$requiredfield=$arrThisRequiredConfig[0];
	$errormessage=$arrThisRequiredConfig[1];
	$isdate=$arrThisRequiredConfig[2];
	$strAdditionalTest=$arrThisRequiredConfig[3];
	
	//echo $arrThisRequiredConfig[3] . "-" . $strAdditionalTest . "\n";
	
	if(contains($requiredfield, "password"))
	{
		//the one place where this code seems a little non-code-neutral
		$passwordmatchcode="if(GetFormItemValue('" . $FormName . "', 'password')!=GetFormItemValue('" . $FormName . "', qpre + 'password')){thiserror+='You must type the same password twice.';}";
	}
	if(contains($requiredfield, "PASSWORD"))
	{
		//the one place where this code seems a little non-code-neutral
		$passwordmatchcode="if(GetFormItemValue('" . $FormName . "', 'PASSWORD')!=GetFormItemValue('" . $FormName . "', 'CONFIRM')){thiserror+='You must type the same password twice.';}";
	}
	if($errormessage=="")
	{
		$errormessage="You must supply a valid " . $requiredfield . ".";
	}
	if(contains($strAdditionalTest, "`"))
	{
		$arrAdditionalTest=explode("`", $strAdditionalTest);
		foreach($arrAdditionalTest as $thisAdditionalTest)
		{
			$additonalTests.=  " || thisval." . $thisAdditionalTest . " ";
		}
	}
	else if($strAdditionalTest!="")
	{
		$additonalTests.=  " || thisval." . $strAdditionalTest . " ";
	}
	$additonalTests =substr($additonalTests, 3);
	if($isdate!="")
	{
	?>

	thisval=GetFormItemValue("<?=$FormName?>", "<?=$requiredfield?>", <?=$isdate?>);
	//alert(thisval);
	<?
	}
	else
	{
	?>

	thisval=GetFormItemValue("<?=$FormName?>", "<?=$requiredfield?>");
		
	<?
	}
	?>
	additionaltests="<?=$additonalTests?>";
	if(thisval=="")
	{
		bwlFail=true;
	}
	else
	{
		bwlFail=false;
	}
	if(additionaltests!="")
	{
		bwlFail=eval( "!("  + additionaltests + ")");
	}
	if (bwlFail )
	{
		thiserror+='<?=$errormessage?>\n';
	}
	<?
	
	}

}
if($strLastMinuteTests!="")
{
	echo $strLastMinuteTests;
}

 
	?>
	<?=$passwordmatchcode?>
	
		if (thiserror!="")
		{
			alert(thiserror);
			return false;
		}
		return true;

 
}
</script>