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

	 			 
			 
				$out.=DeleteRangeForm($strDatabase, $strTable, $strPK);
	
				if($intHigh!="")
				{
					$deleteout="";
					for($i=$intHigh; $i>=$intLow; $i--)
					{
						$deleteout.=  TotalDelete($strDatabase, $strTable, $i, $strPK);
						//echo $strDatabase . " " .  $strTable . " " .  $i . " " .  $strPK . "<br>";
					}
					$out.= $feedbackspanstag . $deleteout . "</div>"; 
				
				}
				$out =  PageHeader("Delete Range", $strConfigBehave) . $out . PageFooter();
				return $out;
			}
	}
} 


function DeleteRangeForm($strDatabase, $strTable, $strPK)
{
	//a form for entering free-form SQL.  defaults to last command run
	//gus mueller, nov 26 2006
	$strClassFirst="bgclassfirst";
	$strLineClass="bgclassline";
	$strOtherBgClass="bgclassother";
	$out= "";
	$preout= "";
	$preout.= adminbreadcrumb(false,  $strDatabase, "tf.php?" . qpre . "db=" . $strDatabase,  "db tools", $strPHP . "?" . qpre . "db=" . $strDatabase, "Delete range of IDs from this table and dependent rows in other tables", "") ;
	//$out.= AdminNav(true);
	
	$preout.= "<form method=\"post\" name=\"BForm\" action=\"tf_delete_range.php\">\n";
 	// TextInput(qpre ."table",  $strTable, "30","",  "", "")
	$out.=htmlrow("bgclassline", "table name:",
		TableDropdown($strDatabase,$strTable, qpre ."table" )
	);
	$out.=htmlrow("bgclassfirst", "start:",
	 TextInput(qpre ."low",  "", "30","",  "", "")
	 
	);
	$out.=htmlrow("bgclassfirst", "end:",
	 TextInput(qpre ."high",  "", "30","",  "", "")
	 
	);
	
	$out.="<tr>\n";
	$out.="<td align=\"right\" colspan=\"2\">\n";
	//$out.=CheckboxInput(qpre . "directediting", 1, $bwlDirectediting, "", "", "") . "allow direct editing of results  ";
	//$out.="&nbsp;&nbsp;&nbsp;&nbsp;";
 	//$out.=CheckboxInput(qpre . "truncate", 1, $trunc, "", "", "") . "truncate fields";
	$out.="<input type=\"Submit\" class=\"btn\" onmouseover=\"this.className='btn btnhov'\" onmouseout=\"this.className='btn'\" value=\"Delete Range\">";
	$out.="</td>\n";
	$out.="</tr>\n";
	$out=$preout . TableEncapsulate($out, false);
	$out.="</form>";
	return $out;
}
?>