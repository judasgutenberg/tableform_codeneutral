<?php
//Judas Gutenberg Spring 2006
//provides a web front end admin tool for any mysql db
//i've modified txtsql to be aware of foreign keys so this tool can dynamically build complicated tools
//This code is covered under the GNU General Public License
//info here: http://www.gnu.org/copyleft/gpl.html
//the digest is as follows: you cannot modify this code without
//publishing your source code under the same license
//contact the developer at gus@asecular.com  http://asecular.com

set_time_limit(900);
include('tf_functions_backup.php');
include('tf_functions_core.php');

echo main();

function main()
{
	if(!IsExtraSecure())
	{
		die(ExtraSecureFailure());
	}
	ini_set('memory_limit','450M');
	$strTable=$_REQUEST[qpre . "table"];
	$strDatabase=deMoronizeDB(gracefuldecay($_REQUEST[qpre . "db"],our_db));
	$submit=$_REQUEST[qpre . "submit"];
	$fielddel=$_REQUEST[qpre . "fielddel"];
	$rowdel=$_REQUEST[qpre . "rowdel"];
	$quotecontent=$_REQUEST[qpre . "quotecontent"];
	//$quotecontent=false;
	if ($quotecontent=="1")
	{
		$quotecontent=true;
	}
	else
	{
		$quotecontent=false;
	}
	$strPHP=$_SERVER['PHP_SELF'];
	$supressheaders=false;
	$arrFields=$_REQUEST[qpre . "fields"];
	if (is_array($arrFields))
	{
		foreach($arrFields as $field)
		{
			$fields.=$field  . " ";
			$supressheaders=true;
		}
	}
	
	$out=LoginDecisions($strDatabase,  $strPHP, $strUser, $supressheaders);
	if ($strUser!="")
	{
		$intAdminType= AdministerType($strDatabase, $strTable, $strUser);
		
		if ($intAdminType>1)
			{
				if ($submit!="")
				{
					//echo $fields;
					//die();
					//fielddel rowdel  quotecontent
					
					$data= CommmaDelimitedDump($strDatabase, $strTable, $fields, multichrhandle($fielddel), multichrhandle($rowdel), $quotecontent);
					
					$status=downloadData ($data, "text/plain", "Data Export for : " .  $strDatabase . " : " .  $strTable . ".txt");
			 
					if($status==0)
					{
						$out.= DumpForm($strDatabase, $strTable);
						$out.="<div class=\"feedback\">There is no data to export in the table " .  $strTable  . ".</div>";
						return PageHeader($strTable . " Exporter", $strConfigBehave, "", true, false, "", $strDatabase) . $out .  PageFooter();
					}
				}
				else
				{
					$out.= DumpForm($strDatabase, $strTable);
					$out =  PageHeader($strTable . " Exporter", $strConfigBehave, "", true, false, "", $strDatabase) . $out . PageFooter();
					return $out;
				}
			}
	}
}
	
	
	
function DumpForm($strDatabase, $strTable)
{
		$sql=conDB();
		$records=TableExplain($strDatabase, $strTable);
		$intFindCount=1;
		$strClassFirst="bgclassfirst";
		$strClassSecond="bgclasssecond";
		$out= "";
		$preout= "";
		$strPHP="tf.php";
		$preout.= adminbreadcrumb(false, $strDatabase, $strPHP . "?" . qpre . "db=" . $strDatabase,  $strTable, qbuild($strPHP, $strDatabase, $strTable, "view", "", ""), "data exporter", "");
		$preout.="<form name=\"BForm\" action=\"tf_dump.php\" method=\"post\">\n";
		$out.="<tr class=\"bgclassline\"><td colspan=\"2\">\n";
		$out.="Check off the fields that you want to export from <strong>" . $strTable . "</strong>\n";
		$out.="</td></tr>\n";
		foreach ($records as $k => $info )
		{
			$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
			$out.="<tr class=\"" . $strThisBgClass . "\"><td width=\"10\">";
			$out.="<input type=\"checkbox\" name=\"" . qpre . "fields[]\" id=\"id" . qpre . "fields[]\" value=\"" .  $info["Field"] . "\"></td><td>" .  $info["Field"];
			$out.="</td></tr>\n";
	 	}
		$out.=htmlrow("bgclassline", "<a href=\"javascript:alldumpcheckboxes('fields[]', true)\">select all</a>", "<a href=\"javascript:alldumpcheckboxes('fields[]', false)\">select none</a>");
		$out.=htmlrow($strClassFirst, 
		"pick a field delimiter: " , GenericDataPulldown("comma|44-space|32-vertical bar|124-tab|9", 1, 0, qpre . "fielddel", 44, "", "", ""));
		$out.=htmlrow($strClassSecond, 
		"pick a row delimiter: " , GenericDataPulldown("carriage return|13-linefeed|10-cr&lf|13.10", 1, 0, qpre . "rowdel", 13.10, "", "", "")
		);
	 	$out.=htmlrow($strClassFirst, 
		"quote each field: ",
		boolcheck(qpre . "quotecontent",1, false, false)
		);
		$out.="<tr class=\"bgclassline\"><td align=\"right\" colspan=\"2\">\n";
		$out.="<input type=\"submit\" name=\"" . qpre . "submit\" value=\"export " .  forcePlural($strTable) . "\">\n";
		$out.= HiddenInputs(array("db"=>$strDatabase, "table"=>$strTable ));
		$out.="</td></tr>\n";
		$out=$preout . TableEncapsulate($out, false);
		$out.="</form>\n";
		return $out;
}

?>