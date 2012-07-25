<?php
$strPathPre="tf/";

include_once($strPathPre . "tf_constants.php");
//echo tf_dir;
include_once($strPathPre . "tf_functions_core.php");
 
include_once($strPathPre . "tf_functions_editor.php");
include_once($strPathPre . "tf_functions_frontend_db.php");
include_once($strPathPre . "tf_constants.php");
include_once($strPathPre . "tf_functions_backup.php");
include_once($strPathPre . "tf_functions_odbc.php");
 
include_once($strPathPre . "fw_functions.php");
set_time_limit(120);
error_reporting($errorlevel);

$arrForm=$_POST;
 
//echo main($arrForm);
echo  makefeedthroughform($arrForm);
//displayrequest($arrForm);

function displayrequest($arrForm)
{
	$out="<table>";
	foreach($arrForm as $k=>$v)
	{
		$out.=htmlrow( "", $k , $v );
	
	
	}
 	$out.="</table>";
	echo $out;
}

function makefeedthroughform($arrForm)
{
	$strIgnorelist="Submit chkCategories CONFIRM";
	$qs="";
	$arrID=Array();
	$arrChanged=Array();
	$nowdatetime=date("Y-m-d H:i:s");
	foreach($_GET as $k=>$v)
	{
		$qs.=$k ."=". urlencode($v) . "&";
	}
	$localdest=$arrForm[qpre . "dest"];
	$distantdest=$arrForm[qpre . "dest2"];
	$dest=$localdest;
	
	if(contains($dest, "?"))
	{
		$dest.="&". $qs;
	}
	else
	{
		$dest.="?". $qs;
	}
	if($localdest=="")
	{
		$dest="Maint/" . $distantdest;
	}
	$strProbableTable=MatchArrayToTable(our_db, $arrForm,$strIgnorelist , false, true);
	logcollection(true, $arrForm, $dest, $strProbableTable);
	//echo $strProbableTable;
 
	$out="<html>\n<body>\n<form method=\"post\" action=\"" . $dest . "\" name='BForm'>\n";
	$totalfields=0;
	$bwlWeHadAnID=false;
	foreach($arrForm as $k=>$v)
	{	
		//echo "<hr>" .  $k . " " .  $v  . "<p>";;
		if(!beginswith($k, qpre))
		{
			if($k=="submit")
			{
				$k="Submit";//to keep the .submit() method from being overwritten
			}
			if(is_array($v))//got to make a cf-compatible checkbox array
			{
				//echo var_dump($v);
			 
					//echo count($v);
				foreach($v as $thiscat)
				{
				 	//echo $thiscat . "\n";
					$out.= HiddenInputs(Array($k=>$thiscat), "");
				}
				 
			}
			else
			{
				$out.= HiddenInputs(Array($k=>singlequoteescape($v)), "");
			}
		}
		if(strtoupper($k)==$k)//it's a coldfusiony field
		{
			$totalfields++;
			if($k=="TIMESTAMP" && !$bwlWeHadAnID) //don't overwrite timestamps on existing records
			{
				$arrChanged[$k]=$nowdatetime;
			}
			else if($k!="ID")
			{
				$arrChanged[$k]=$v;
				$bwlWeHadAnID=true;
			}
			else
			{
				$arrID[$k]=$v;
			}
		}
	}
 	$out.="</form>";
	
	$out.="<script>\ndocument.BForm.submit();</script>\n</body>\n</html>";
	//echo $strProbableTable . "<BR>";
	if($totalfields>3)//we have a large enough table that we can't do a simple ID from fields for deletes or whatever
	{
		// UpdateOrInsert($strDatabase, $strTable, $arrDescribedValuePairs, $arrAlteredValuePairs, $bwlEscape=true, $bwlDebug=false)
		 UpdateOrInsert(our_db,$strProbableTable, $arrID, $arrChanged);
		 if(sql_error()!="")
		 {
		 	logcollection(true, $arrForm, sql_error(), "error");
		 }
	}
	return $out;
}
 
function MatchArrayToTable($strDatabase, $arrOriginal, $strSkip, $bwlIgnoreCase=true, $bwlAutoSkipPKs=true, $bwlAutoSkipAllUpperCase=true) 
//take an array and look to see what table they match
//i wrote this for identifying tables being edited by  ColdFusion forms
//strSkip is for skipping PKs and such. it's a space-delimited field list
//2010-02-06 Judas Gutenberg
{
 
 
	$tables=ListTables($strDatabase);
	foreach($tables as $table)
	{
		//i figured out i should test from the form against the table instead of the other way around
		$arrExplain=TableExplain($strDatabase, $table);
		$arrToTest=Array();
		foreach($arrExplain as $info)
		{
			if($bwlIgnoreCase)
			{
				$arrToTest[strtolower($info["Field"])]="";
			}
			else
			{
				$arrToTest[$info["Field"]]="";
			
			}
		}
		//echo "\n<br>table : " . $table;
		$bwlFail=false;
		$bwlAtLeastOneField=false;
		foreach ($arrOriginal as $k=>$v )
		{	
			$field=$k;
			if($field=="RecordID")
			{
				return false; //this seems to be a typical ColdFusion non-table edit
			}
			//echo "\n<br>" . $field;
			if(!($bwlIgnoreCase  && array_key_exists(strtolower($field), $arrToTest) || array_key_exists($field, $arrToTest)))
			{
				if($field!=strtolower($field))
				{
					$bwlAtLeastOneField=true;//have to have at least one all-caps field for this coldfusion integration
				}
				if($bwlIgnoreCase && inList(strtolower($strSkip), strtolower($field)) || inList($strSkip, $field))
				{
					//echo "!";
				}
				else
				{
					if($bwlAutoSkipPKs  && $info["Key"]=="PRI")
					{
						//echo "?";
					}
					else
					{
						//echo "#";
						if(!beginswith($field, qpre)  && strtoupper($field)== $field)
						{
							//echo "\n<br>" . $field;
							if($bwlAutoSkipAllUpperCase  && $field!=strtoupper($field))
							{
							
							}
							else
							{
								$bwlFail=true;
							}
						}
					}
				}
			}
		}
		if(!$bwlFail )
		{
			//echo $table . "<BR>";
		}
		if(!$bwlFail  && $bwlAtLeastOneField)
		{
			return $table;
		}
	}

}

function ForceKeyCase($arr, $bwlHigher=false)
{
	$arrOut=Array();
	foreach($arr as $k=>$v )
	{	
		if($bwlHigher)
		{
			$newkeyname=strtoupper($k);
		}
		else
		{
			$newkeyname=strtolower($k);
		}
		$arrOut[$newkeyname]=$v;
	}
	return $arrOut;
}
 ?>