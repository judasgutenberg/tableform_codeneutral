<?php
//Judas Gutenberg September 2008
//copies records from one table to another based on a saved regime of column links
//This code is covered under the GNU General Public License
//info here: http://www.gnu.org/copyleft/gpl.html
//the digest is as follows: you cannot modify this code without
//publishing your source code under the same license
//contact the developer at gus@asecular.com  http://asecular.com

set_time_limit(900);
require_once('tf_functions_backup.php');
require_once('tf_functions_core.php');
require_once('tf_functions_frontend_db.php');
require_once('tf_core_table_creation.php'); 
require_once('tf_functions_color_math.php');
if (file_exists('tf_odbc_functions.php'))
{
	require('tf_odbc_functions.php');
}

echo main();

function main()
{
	if(!IsExtraSecure())
	{
		die(ExtraSecureFailure());
	}
	ini_set('memory_limit','450M');
 
	$strPHPContent=$_REQUEST[qpre . "actscript"];
	//echo $dests;
 
	
	$strDatabase=deMoronizeDB(gracefuldecay($_REQUEST[qpre . "db"],our_db));
	//$quotecontent=false;
	$strPHP=$_SERVER['PHP_SELF'];
	$supressheaders=true;
	$bwlTableDisplay=$_REQUEST[qpre . "tabledisplay"];
	$out=LoginDecisions($strDatabase,  $strPHP, $strUser, $supressheaders);
	if ($strUser!="")
	{
		$intAdminType= AdministerType($strDatabase, $strTable, $strUser);
		
		if ($intAdminType>1)
			{

	 			$out.=EnterPHP($strDatabase, $strPHPContent, $bwlTableDisplay);
				if($strPHPContent!="")
				{
					$out.=ActPHP($strPHPContent, $bwlTableDisplay);
				
				}
				$out =  PageHeader("Quick PHP", $strConfigBehave, "", true, false, "", $strDatabase) . $out . PageFooter();
				return $out;
			}
	}
}
//http://threethirty.com/~mcertified/admin/product_modify.php?productid=255
//http://threethirty.com/~mcertified/admin/product_modify.php?productid=241
function ActPHP($strFormula, $bwlTableDisplay=false)
{
	LogAdminScriptIfNovel($strDatabase, $strFormula, "", "php");
	//$strFormula=str_replace("&#40;",  "(", $strFormula);
	//$strFormula=str_replace("&#41;",  ")", $strFormula);
	//$strFormula=str_replace("&#63;",  "?", $strFormula);
	//$strFormula=str_replace("&#39;",  "'", $strFormula);
	//$strFormula=str_replace("&#lt;",  "<", $strFormula);
	//$strFormula=str_replace("&#gt;",  ">", $strFormula);
	//$strFormula=str_replace("&lt;",  "<", $strFormula);
	//$strFormula=str_replace("&gt;",  ">", $strFormula);
	//$strFormula=str_replace("$",  "", $strFormula);
	//$strFormula="$" . "out=" . str_replace("\'",  "'", $strFormula). ";";
	$strFormula= FixFormulaForEval($strFormula) . ";";
 
	$strFormula="$" . "out=" . str_replace("\'",  "'", $strFormula). ";";
	eval($strFormula);
	if( $bwlTableDisplay  || is_array($out))
	{
		$out=GenericRSDisplayFromRS($strPHP,"results", $out, 1, "100%");
	}
	//echo $strFormula;
	return $out;

}
 
function EnterPHP($strDatabase, $strPHPContent, $bwlTableDisplay=false)
{
	//a form for entering free-form SQL.  defaults to last command run
	//gus mueller, nov 26 2006
	$strClassFirst="bgclassfirst";
	$strLineClass="bgclassline";
	$strOtherBgClass="bgclassother";
	$strPHP="tf.php";
	$out="";
	$preout="";
	$preout.= adminbreadcrumb(false,  $strDatabase,  $strPHP . "?" . qpre . "db=" . $strDatabase,  "db tools", $strPHP. "?".  qpre . "db=" . $strDatabase, "Enter Raw PHP", "") ;
	//$out.= AdminNav(true);
	
	$preout.= "<form method=\"post\" name=\"BForm\" action=\"tf_quick_php.php\">\n";
 
	
	//$out.= "</td></tr>\n";
	$out.= HiddenInputs(array("mode"=>"quickphp"));
	$out.="<tr>\n";
	$out.="<td valign=\"top\" class=\"" . $strClassFirst . "\">\n";
	$out.="<textarea name=\"" . qpre . "actscript\" cols=\"60\" rows=\"20\"  >" .  deescape($strPHPContent) . "</textarea>\n";
	$out.="</td>\n";
	$out.="<td  valign=\"top\" class=\"" . $strClassFirst . "\">\n";
	$out.="\n<iframe frameborder=\"0\" marginwidth=\"0\" marginheight=\"0\" width=\"300\" height=\"400\" name=\"recentsql\" src=\"tf_recent_script.php?" . qpre . "type=php" . "&" . qpre . "db=" . $strDatabase . "\"></iframe>\n";
	$out.="</td>\n";
	$out.="</tr>\n";
	$out.="<tr>\n";
	$out.="<td align=\"right\" colspan=\"2\">\n";
	//$out.=CheckboxInput(qpre . "directediting", 1, $bwlDirectediting, "", "", "") . "allow direct editing of results  ";
	//$out.="&nbsp;&nbsp;&nbsp;&nbsp;";
 	//$out.=CheckboxInput(qpre . "truncate", 1, $trunc, "", "", "") . "truncate fields";
	//$out.=CheckboxInput(qpre . "tabledisplay", 1,  false) . " table display";
	$out.="<input type=\"Submit\" class=\"btn\" onmouseover=\"this.className='btn btnhov'\" onmouseout=\"this.className='btn'\" value=\"Execute\">";
	$out.="</td>\n";
	$out.="</tr>\n";
	$out=$preout . TableEncapsulate($out, false);
	$out.="</form>";
	return $out;
}




?>