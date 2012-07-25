<?php
//Judas Gutenberg Dec 21 2007
//
//displays a linked map of table relationships in the database
//
//This code is covered under the GNU General Public License
//info here: http://www.gnu.org/copyleft/gpl.html
//the digest is as follows: you cannot modify this code without
//publishing your source code under the same license
//contact the developer at gus@asecular.com  http://asecular.com

include('core_functions.php');
//echo "<a href=\"javascript:domdumpwindow()\">dump</a>";
echo main();
 

function main()
{
	//$olderror=error_reporting(0);
	$mode=$_REQUEST[qpre . "mode"];
	$strDatabase=deMoronizeDB(gracefuldecay($_REQUEST[qpre . "db"],our_db));
	$strPHP=$_SERVER['PHP_SELF'];
	$out="";


	$out.=LoginDecisions($strDatabase,  $strPHP, $strUser, false);
	if ($strUser!="")
	{
	
		$intAdminType= AdministerType($strDatabase, $strTable, $strUser);
		
		if ($intAdminType>1)
			{
			
				$out.=DBMap($strDatabase, $strPHP);
				
			}
	}
	$out=  PageHeader($strDatabase . " : relationship map", $strConfigBehave) . $out . PageFooter();
	
	return $out;
}

function DBMap($strDatabase, $strPHP)
{
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strOtherBgClass="bgclassother";
	$strLineClass="bgclassline";
	$strThisBgClass=$strClassFirst;
	$sql=conDB(); 
	$arrSort=Array();
	$tablecount=0;
	$x=0; 
	$y=40;
	$z=50;
	$intPixPerLine=18;
	$intPixPerChr=7;
	$intColMax=0;
	$strSQL="SHOW TABLES FROM " .  $strDatabase ; 
	$tables = $sql->query($strSQL);
	$out="";
	$out.= "<script type=\"text/javascript\" src=\"dom-drag.js\"></script>\n";
	//$out.= "<script type=\"text/javascript\" src=\"wz_jsgraphics.js\"></script>\n";
	$out.="\n<div id='idmap' style='position:absolute'>\n";
	$out.="</div>";
	$out.= adminbreadcrumb(false,  $strDatabase, "",  "Tables", "") ;
	
	$strTableFieldName="Tables_in_" . str_replace("`", "", $strDatabase);
	$bwlTableMakerExists=file_exists("tablemaker.php");
	//echo count($tables);
	foreach($tables as  $k=>$v )
	{
		//if($tablecount>10){break;};
		$strTable=$v[$strTableFieldName];
		//echo $strDatabase  . " " . $strTable . "<br>";
		$count = countrecords($strDatabase , $strTable );
		$fieldcount=FieldCount($strDatabase, $strTable);
		$arrSort[$tablecount]=str_pad($fieldcount, 3, "0", STR_PAD_LEFT) . " " . $strTable . " ". MaxColNameLength($strDatabase, $strTable);
		if($fieldcount>$intOverallColMax)
		{
			$intOverallColMax=$fieldcount;
		}
		$tablecount++;
	}
	$intColMax=0;
	arsort($arrSort);
	$strDifString="";
	foreach($arrSort as  $item)
	{
		//echo $item . "<br>";
		$arrTemp=explode(" ", $item);
		$intCols=intval($arrTemp[0]);
		
		
		
		$intPreviousCols=$intCols;
		

		$intColLength=$arrTemp[2];
		if($intCols>$intColMax)
		{
			$intColMax=$intCols;
		}
		$intDif=  $intColMax-$intCols-3;
		//$intDif=  $intOverallColMax-$intCols-2;
		$strTable=$arrTemp[1];
		$records=DBExplain($strDatabase, $strTable);
		$thistableHTML="";
		$thistableHTML.= "\n<table id='idtable" .  $strTable . "' border=\"0\" cellspacing=\"1\" cellpadding=\"2\" class=\"" .$strLineClass  . "\" >\n";
		$thistableHTML.=htmlrow($strLineClass,"<b>" . $strTable . "</b>");
		$strThisBgClass=$strClassFirst;
		foreach ($records as $k1 => $v1 )
		{
			$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
			$strFieldName=$v1["Field"] ;
			//$strSQL="SELECT * FROM " . $strDatabase . "." . tfpre . "relation  WHERE table_name='". $strTable . "' AND column_name='" . $strFieldName . "'";
			//$record2s = $sql->query($strSQL);
			//$record2=$record2s[0];
			//$strFKTable=$record2["f_table_name"];
			//$strFKField=$record2["f_column_name"];
			
			
			
			$thistableHTML.="<tr class=\"" . $strThisBgClass  . "\"><td id=\"idfield-" .$strTable . "-" .$strFieldName  . "\">" . $strFieldName . "</td></tr>\n";
		}
		$thistableHTML.="</table>"; 

		//put in empty spaces if available
		//search dif string to see if this one will fit
		if(contains($strDifString, "|"))
		{
			$arrDif=explode("|", $strDifString);
			
			$bwlLocated=false;
			for($i=0; $i<count($arrDif); $i++)
			{ 
				if(contains($arrDif[$i], " "))
				{
					$arrDifInfo=explode(" ", $arrDif[$i]);
	
					$testDif=$arrDifInfo[3];
					//echo $testDif . " " . $intCols . "<br>";
					$thisx=$arrDifInfo[0];
					$thiscollen=$arrDifInfo[5];
					if($testDif>$intCols +2  && !$bwlLocated  && $thiscollen>=$intColLength)
					{
						//echo "#<br>";
		 
						$thisy=$arrDifInfo[1] + ($arrDifInfo[4] + 2) * $intPixPerLine ;
						//$thisz=$arrDifInfo[2];
						$out.="\n<div id=\"iddiv-" .  $strTable . "\" style=\"position: absolute;top:" .$thisy . "px;left: " . $thisx . "px;\">" . $thistableHTML . "</div>";
						$z++;
						$bwlLocated=true;
						//update the dif entry
						//echo "***" .  $thisx . '/' . $thisy . '_' . $z . '-' .  intval($arrDifInfo[3] -$intCols) . '+' .  $intCols . "<br>";
						$arrDif[$i]=$thisx . " " . $thisy . " " . $z . " " .intval(-1+   $arrDifInfo[3]  -($intCols)) .  " " . $intCols . " " . $thiscollen;
						//echo $arrDif[$i] . "===<br>";
				 
					}
				}
			
			}
		}
		if($bwlLocated)
		{
	 		$strDifString=implode("|", $arrDif);
		}
		//okay then make a new space
		else  
		{
			//only add to the dif string if taking new ground
			$out.="\n<div id=\"iddiv-" .  $strTable . "\" style=\"position: absolute;top:" . $y . "px;left: " . $x . "px; \">" . $thistableHTML . "</div>";
			if($intDif>0)
			{
				//echo $intDif . " " . count($arrDif) . "=============<br>";
				$strDifString.=$x . " " . $y . " " . $z . " " . $intDif .  " " . $intCols . " " . $intColLength .  "|";
				//echo $x . " " . $y . " " . $z . " " . $intDif .  " " . $intCols . "|<br>";
			}
			$x+=($intPixPerChr*$intColLength);
			if($x>1000)
			{
				$y+=($intColMax + 2)*$intPixPerLine ;
				$x=0;
				$intColMax=0;
				$intPreviousCols=0;
			}
			$z+=1;
		 
		}
		
		$out.="<script type=\"text/javascript\">";
		$out.="Drag.init(document.getElementById('iddiv-" .  $strTable . "'));\n";
		$out.="</script>";
		
	}
	$out.=RelationDump($strDatabase);
	return $out;


}


function RelationDump($strDatabase)
{
	$sql=conDB();
	$out="";
	$strSQL="SELECT * FROM " . $strDatabase . "." . tfpre . "relation  WHERE relation_type_id='0'";
	$records = $sql->query($strSQL);
	foreach($records as $record)
	{
		$strTable=$record["table_name"];
		$strColumn=$record["f_column_name"];
		$strFKTable=$record["f_table_name"];
		$strFKColumn=$record["f_column_name"];
		$out.=$strTable . " " . $strColumn . " " . $strFKTable . " " . $strFKColumn . "|";
	}
	$out="\n<script type=\"text/javascript\">relationshipdata='" . $out . "'</script>\n";
	$out.= "<script type=\"text/javascript\" src=\"drawrelationships.js\"></script>\n";
	return $out;
}


	
?>