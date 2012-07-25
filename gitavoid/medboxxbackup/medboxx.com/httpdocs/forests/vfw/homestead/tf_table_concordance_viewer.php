<?php
//Judas Gutenberg September 2008
//copies records from one table to another based on a saved regime of column links
//This code is covered under the GNU General Public License
//info here: http://www.gnu.org/copyleft/gpl.html
//the digest is as follows: you cannot modify this code without
//publishing your source code under the same license
//contact the developer at gus@asecular.com  http://asecular.com

set_time_limit(900);
include('tf_functions_backup.php');
include('tf_functions_core.php');
include('tf_functions_frontend_db.php');
include('tf_core_table_creation.php'); 
include('tf_functions_color_math.php');
echo main();

function main()
{
	if(!IsExtraSecure())
	{
		die(ExtraSecureFailure());
	}
	ini_set('memory_limit','450M');
	$strTable1=$_REQUEST[qpre . "table1"];
	$strTable2=$_REQUEST[qpre . "table2"];
	$dests=$_REQUEST[qpre . "dests"];
	//echo $dests;
	$rec=gracefuldecaynumeric($_REQUEST[qpre . "rec"], 1);
	$tablecopymap_id=$_REQUEST["tablecopymap_id"];
	
	$strDatabase=deMoronizeDB(gracefuldecay($_REQUEST[qpre . "db"],our_db));
	//$quotecontent=false;
	$strPHP=$_SERVER['PHP_SELF'];
	$supressheaders=true;
	$out=LoginDecisions($strDatabase,  $strPHP, $strUser, $supressheaders);
	if ($strUser!="")
	{
		$intAdminType= AdministerType($strDatabase, $strTable, $strUser);
		
		if ($intAdminType>1)
			{
	 			$out.=ShowSampleConcordanceData($strDatabase, $strTable1, $strTable2, $dests, $rec);
				 
				$out =  PageHeader("table to table copy", $strConfigBehave, "", true, false, "", $strDatabase) . $out . PageFooter();
				return $out;
			}
	}
}


function ShowSampleConcordanceData($strDatabase, $strTable1, $strTable2, $dests, $rec, $len=30)
{
	$strColorFirst="ddddee";
	$strColorSecond="ccccaa";
	$strOtherLineClass="bgclassother";
	$strLineClass="bgclassline";
	$out="";
	$sql=conDB();
	$bwlFoundsomething1=false;
	$bwlFoundsomething2=false;
	$strSQL1="SELECT * FROM " . $strDatabase . "." . $strTable1 . " LIMIT  " . $rec . ",1";
	$strSQL2="SELECT * FROM " . $strDatabase . "." . $strTable2 . " LIMIT   " . $rec . ",1";
	
	$records1=$sql->query($strSQL1);
	//echo $strSQL1. "<P>";
	//echo sql_error() . "<P>";
	$records2=$sql->query($strSQL2);
	//echo $strSQL2. "<P>";
	//echo sql_error() . "<P>";
	$record1=$records1[0];
	$record2=$records2[0];
	$mrecords=TableExplain($strDatabase, $strTable1);
 
	$i=0;
	$out.=htmlrow($strLineClass,  
			$strTable1 . " field",
			$strTable1 . " data",
			$strTable2 . " field",
			$strTable2 . " data"
		);
	foreach ($mrecords as $k => $info )
	{
		$strSourceField=$info["Field"];
		$strDestField=genericdata($i,1, 0, $dests, "~", "|", false);
		$strThisColor=Alternate($strColorFirst, $strColorSecond, $strThisColor);
 		$strAltColor=colorAdd($strThisColor, "111111");
		$content1=simplelinkbody($record1[$strSourceField], $len);
		$content2= simplelinkbody($record2[$strDestField], $len);
		if ($content1!="")
		{
			$bwlFoundsomething1=true;
		}
		if ($content2!="")
		{
			$bwlFoundsomething2=true;
		}
		$out.=htmlrow("",  
			"<div style=\"background-color:" . $strThisColor  . "\">&nbsp;" . $strSourceField . "\n</div>\n",
			"<div style=\"background-color:" . $strAltColor  . "\">&nbsp;" . $content1. "\n</div>\n",
			"<div style=\"background-color:" . $strThisColor  . "\">&nbsp;" . $strDestField . "\n</div>\n",
			"<div style=\"background-color:" . $strAltColor  . "\">&nbsp;"  . $content2 . "\n</div>\n"
		);
		$i++;
	}
	
	$out= TableEncapsulate($out, false);
	$urlpre="tf_table_concordance_viewer.php?" . qpre . "table1=" . $strTable1 . "&" .  qpre . "table2=" . $strTable2 . "&" .  qpre . "table2=" . $strTable2 . "&".   qpre . "dests=" . $dests; 
	if($rec>1)
	{
		$out.="<a href=\"" . $urlpre . "&" . qpre . "rec=" .intval( intval($rec) -1) . "\">previous</a>\n";
		
	}
	if($rec>1  && $bwlFoundsomething1  && $bwlFoundsomething2)
	{
		$out.=" | \n";
	}
	if($bwlFoundsomething1  && $bwlFoundsomething2)
	{
		$out.="<a href=\"" . $urlpre . "&" . qpre . "rec=" . intval(intval($rec) +1) . "\">next</a>\n";
	}
	return $out;
}


 
?>