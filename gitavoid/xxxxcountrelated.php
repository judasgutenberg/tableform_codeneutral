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
include('tf_functions_editor.php');
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
 
	$strPHPContent=$_REQUEST[qpre . "actphp"];
	//echo $dests;
 
	
	$strDatabase=deMoronizeDB(gracefuldecay($_REQUEST[qpre . "db"],our_db));
	//$quotecontent=false;
	$strPHP=$_SERVER['PHP_SELF'];
	$strTable=$_REQUEST[qpre . "table"];
	$strPK=$_REQUEST[qpre . "pk"];
	$intHigh=$_REQUEST[qpre . "high"];
	$intLow=$_REQUEST[qpre . "low"];
	$feedbackspanstag="<div class=\"feedback\">";
	$out=LoginDecisions($strDatabase,  $strPHP, $strUser, $supressheaders);
	if ($strUser!="")
	{
		$intAdminType= AdministerType($strDatabase, $strTable, $strUser);
		
		if ($intAdminType>1)
			{
				$out.=  CountRelated($strDatabase, $strTable);
				$out =  PageHeader("Count Unrelated", "") . $out . PageFooter();
				return $out;
			}
	}
} 


 

function CountRelated($strDatabase, $strTable, $strPK, $strPKColumn="", $tfrecords="")
//November 16 2009 - counts the number of items related to this one, as known by tableform
{

	$sql=conDB();
	$out="";
	if($strPKColumn=="")
	{
		$strPKColumn=PKLookup($strDatabase, $strTable);
	}
	$out="";
	
	if($tfrecords=="")
	{		
		$strSQL="SELECT * FROM " . $strDatabase . "." . tfpre . "relation WHERE f_table_name='" . $strTable . "' AND f_column_name='" . $strPKColumn . "'";
		$tfrecords = $sql->query($strSQL);
 	}
	
	//foreach($grecord as $k=>$v)
	//{
	
	
	//}
	foreach($tfrecords as $record)
	{
		$thistable=$record["table_name"];
		$thiscolumn=$record["column_name"];
		if($strPK!="")
		{
			$cstrSQL="SELECT count(" . $thiscolumn  . ") AS thiscount FROM " . $strDatabase . "." . $thistable . " WHERE " . $thiscolumn . "='" . $strPK . "'";
			//echo $cstrSQL  ."<br>";
	 		//echo mysql_error()  ."<br>";
			$crecords = $sql->query($cstrSQL);
			foreach($crecords as $crecord)
			{
			 	$thiscount+=$crecord["thiscount"];
			}
	 
		}
	}
	
	$grecord["related"]=$thiscount;
	return $thiscount;
}



function xCountRelated($strDatabase, $strTable, $strPKColumn="")
//December 26 2007 - deletes a row and then all related rows following the contents of the relation table.
{
	$strLineClass="bgclassline";
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strOtherBgClass="bgclassother";
	$strOtherLineClass="bgclassline";
	$sql=conDB();
	$out="";
	if($strPKColumn=="")
	{
		$strPKColumn=PKLookup($strDatabase, $strTable);
	}
	$out="";
	
	$strSQL="SELECT * FROM " . $strDatabase . "." . tfpre . "relation WHERE f_table_name='" . $strTable . "' AND f_column_name='" . $strPKColumn . "'";
		//echo $strSQL  ."<br>";
	
					
	$records = $sql->query($strSQL);
		
 	$strGreaterSQL="SELECT * FROM " . $strDatabase . "." . $strTable;
 	$grecords = $sql->query($strGreaterSQL);
	foreach($grecords as $grecord)
	{
		$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
		
		$strPK=$grecord[$strPKColumn];
		
		//foreach($grecord as $k=>$v)
		//{
		
		
		//}
		foreach($records as $record)
		{
			$thistable=$record["table_name"];
			$thiscolumn=$record["column_name"];
			if($strPK!="")
			{
				$cstrSQL="SELECT count(" . $thiscolumn  . ") AS thiscount FROM " . $strDatabase . "." . $thistable . " WHERE " . $thiscolumn . "='" . $strPK . "'";
				//echo $cstrSQL  ."<br>";
		 		//echo mysql_error()  ."<br>";
				$crecords = $sql->query($cstrSQL);
				foreach($crecords as $crecord)
				{
				 	$thiscount+=$crecord["thiscount"];
				}
		 
			}
		}
		
	
		array_unshift($grecord, $strThisBgClass);
 		//array_push($grecord, "thiscount"=>$thiscount);
		$grecord["related"]=$thiscount;
	 	$thiscount=0;
		
		$out.=call_user_func_array("htmlrow",$grecord);
		
	}
	$out= TableEncapsulate($out, false);
	return $out;
}
?>