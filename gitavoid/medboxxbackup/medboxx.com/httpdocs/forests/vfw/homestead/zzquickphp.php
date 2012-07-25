<?php
//Judas Gutenberg September 2008
//copies records from one table to another based on a saved regime of column links
//This code is covered under the GNU General Public License
//info here: http://www.gnu.org/copyleft/gpl.html
//the digest is as follows: you cannot modify this code without
//publishing your source code under the same license
//contact the developer at gus@asecular.com  http://asecular.com

set_time_limit(900);
include('backup_functions.php');
include('core_functions.php');
include('frontenddbfunctions.php');
include('coretablecreation.php'); 
include('colormath.php');
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
	$out=LoginDecisions($strDatabase,  $strPHP, $strUser, $supressheaders);
	if ($strUser!="")
	{
		$intAdminType= AdministerType($strDatabase, $strTable, $strUser);
		
		if ($intAdminType>1)
			{

	 			$out.=EnterPHP($strDatabase, $strPHPContent);
				if($strPHPContent!="")
				{
					$out.=ActPHP($strPHPContent);
				
				}
				$out =  PageHeader("Quick PHP", $strConfigBehave) . $out . PageFooter();
				return $out;
			}
	}
}
//http://threethirty.com/~mcertified/admin/product_modify.php?productid=255
//http://threethirty.com/~mcertified/admin/product_modify.php?productid=241
function ActPHP($strFormula)
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
	//echo $strFormula;
	return $out;

}
 
function EnterPHP($strDatabase, $strPHPContent)
{
	//a form for entering free-form SQL.  defaults to last command run
	//gus mueller, nov 26 2006
	$strClassFirst="bgclassfirst";
	$strLineClass="bgclassline";
	$strOtherBgClass="bgclassother";
	$out="";
	$out.= adminbreadcrumb(false,  $strDatabase, "tableform.php",  "db tools", $strPHP, "Enter Raw PHP", "") ;
	//$out.= AdminNav(true);
	
	$out.= "<form method=\"post\" name=\"BForm\" action=\"quickphp.php\">\n";
	$out.= "<table border=\"0\" cellspacing=\"1\" cellpadding=\"2\" class=\"" .$strLineClass  . "\"  >\n";
	//$out.= "<tr class=\"" . $strOtherBgClass . "\"><td colspan=\"2\">\n";
	
	//$out.= "</td></tr>\n";
	$out.= HiddenInputs(array("mode"=>"quickphp"));
	$out.="<tr>\n";
	$out.="<td valign=\"top\" class=\"" . $strClassFirst . "\">\n";
	$out.="<textarea name=\"" . qpre . "actscript\" cols=\"60\" rows=\"20\"  >" .  deescape($strPHPContent) . "</textarea>\n";
	$out.="</td>\n";
	$out.="<td  valign=\"top\" class=\"" . $strClassFirst . "\">\n";
	$out.="\n<iframe frameborder=\"0\" marginwidth=\"0\" marginheight=\"0\" width=\"300\" height=\"400\" name=\"recentsql\" src=\"recentscript.php?" . qpre . "type=php" . "&" . qpre . "db=" . $strDatabase . "\"></iframe>\n";
	$out.="</td>\n";
	$out.="</tr>\n";
	$out.="<tr>\n";
	$out.="<td align=\"right\" colspan=\"2\">\n";
	//$out.=CheckboxInput(qpre . "directediting", 1, $bwlDirectediting, "", "", "") . "allow direct editing of results  ";
	//$out.="&nbsp;&nbsp;&nbsp;&nbsp;";
 	//$out.=CheckboxInput(qpre . "truncate", 1, $trunc, "", "", "") . "truncate fields";
	$out.="<input type=\"Submit\" class=\"btn\" onmouseover=\"this.className='btn btnhov'\" onmouseout=\"this.className='btn'\" value=\"Execute\">";
	$out.="</td>\n";
	$out.="</tr>\n";
	$out.="</table>";
	$out.="</form>";
	return $out;
}




?>