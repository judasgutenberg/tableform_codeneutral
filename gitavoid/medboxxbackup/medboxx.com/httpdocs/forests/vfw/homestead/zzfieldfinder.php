<? 
//Judas Gutenberg August 2008
//Searches through a database looking for tables with a given field name
//This code is covered under the GNU General Public License
//info here: http://www.gnu.org/copyleft/gpl.html
//the digest is as follows: you cannot modify this code without
//publishing your source code under the same license
//contact the developer at gus@asecular.com  http://asecular.com

include('core_functions.php');
include('tableform_functions.php');

echo main();

function main()
{
	if(!IsExtraSecure())
	{
		die(ExtraSecureFailure());
	}

	//$olderror=error_reporting(0);
	//$mode=$_REQUEST[qpre . "mode"];
	$strDatabase=deMoronizeDB(gracefuldecay($_REQUEST[qpre . "db"],our_db));
	$strColumn=$_REQUEST[qpre . "column"];
	$comprehensivesearch=gracefuldecaynumeric($_REQUEST[qpre . "comprehensivesearch"],0);
	error_reporting($olderror);
	$strPHP=$_SERVER['PHP_SELF'];
	$out="";
	//echo $id . " " .$idfield ;
	$out=LoginDecisions($strDatabase,  $strPHP, $strUser, true);
	
	if ($strUser!="")
	{
	
		$intAdminType= AdministerType($strDatabase, $strTable, $strUser);
 
		if ($intAdminType>1)
		{
				 
			if ($intSearchType=="")
			{
				$intSearchType=0;
			}
			if ($intRecord=="")
			{
				$intRecord=0;
			}
			$out.= FieldFinderForm($strDatabase, $strColumn, $comprehensivesearch);
			if($strColumn=="")
			{
			
			}
			else
			{
				$out.=  DisplayTablesWithColumn($strDatabase, $strColumn, $strPHP, $comprehensivesearch);
			}
		}
	}
	$out =  PageHeader($strDatabase . " : field finder", $strConfigBehave) . $out . PageFooter();
	
	return $out;
}

	
function DisplayTablesWithColumn($strDatabase,  $strColumn, $strPHP, $comprehensivesearch)
{
	
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strOtherBgClass="bgclassother";
	$strLineClass="bgclassline";
	$strThisBgClass=$strClassFirst;
	$sql=conDB(); 
	$strFieldName="Tables_in_" . str_replace("`", "", $strDatabase);
	if($comprehensivesearch==0)
	{
		//$strSQL="SHOW TABLES FROM " .  $strDatabase ; 
		$tables=TableList($strDatabase);
		$strRelationTerm="named";
	}
	else
	{
		$strRelationTerm="containing";
		$strSQL="CREATE TEMPORARY TABLE  " . $strDatabase  . ".temp_searchresult (
	  	temp_id int(11) NOT NULL auto_increment,
	  	tablename varchar(45) default NULL,
		createtable text default NULL,
	  	PRIMARY KEY  (temp_id))";
		$tables = $sql->query($strSQL);
		//echo $strSQL . " " . sql_error() . "<p>";
		$strSQL="SHOW TABLES FROM " .  $strDatabase  ; 
		$strFieldName="Tables_in_" . str_replace("`", "", $strDatabase);
		$tables = $sql->query($strSQL);
		//echo $strSQL . " " . sql_error() . "<p>";
		foreach ($tables as  $k=>$v )
		{
			$tablename=$v[$strFieldName];
			$strSQL="show create table " . $strDatabase . "." . $tablename;
			$rs = $sql->query($strSQL);
			$r=$rs[0];
			$createtable=$r["Create Table"];
			$strSQL="INSERT INTO " . $strDatabase  . ".temp_searchresult(tablename, createtable) VALUES('" . $tablename . "','" . singlequoteescape($createtable) . "')";
			$tables = $sql->query($strSQL);
			//echo $strSQL . " " . sql_error() . "<p>";
		}
		//for some reason this code had been absent and it had been almost working:
		$strSQL="SELECT * FROM " . $strDatabase  . ".temp_searchresult WHERE createtable LIKE '%" . $strColumn . "%'";
		$tables= $sql->query($strSQL);
		//end of mystery code
		$strFieldName="tablename";
		//$tables=TableList($strDatabase, "LIKE '%" . $strColumn . "%'");
	}
	//echo $strSQL . " " . sql_error() . "<p>";
	$out="";

	$out.= adminbreadcrumb(false,  $strDatabase, "tableform.php",  "db tools", "dbtools.php", "tables containing a field " . $strRelationTerm . " '" .  $strColumn . "'", "") ;
	$out.= "<script src=\"tablesort_js.js\"><!-- --></script>";
	$out.= "<table  id=\"idsorttable\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\" class=\"" .$strLineClass  . "\" width=\"630\">\n";
	$out.=htmlrow("bgclassline", 
	"<a href=\"javascript: SortTable('idsorttable', 0)\">table</a>",
	 "<a href=\"javascript: SortTable('idsorttable', 1)\">records</a>",
	  "<a href=\"javascript: SortTable('idsorttable', 2)\">columns</a>",
	  "&nbsp;",
	   "&nbsp;",
	    "&nbsp;",
		 "&nbsp;",
		  "&nbsp;",
		   "&nbsp;");
	
	$bwlTableMakerExists=file_exists("tablemaker.php");
	foreach ($tables as  $k=>$v )
	{
		
		$tablename=$v[$strFieldName];
		//echo "*" . $strFieldName . " " .  var_dump($v)  . " " . $v["createtable"] . "<br>";
		if($comprehensivesearch!=0 || FieldExists($strDatabase, $tablename, $strColumn))
		{
			
			$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
			$count = countrecords($strDatabase , $tablename );
			$fieldcount=FieldCount($strDatabase, $tablename);
			if ($bwlTableMakerExists)
			{
				$tablemakerlink= "<nobr>[<a href=\"" . qbuild("tablemaker.php", $strDatabase, $tablename , "", "", "") . "\">edit def.</a>]</nobr>";
			}
			else
			{
				$tablemakerlink= "&nbsp;";
			} 
			$out.=htmlrow
			(
				$strThisBgClass, 
				"<a href=\"" . qbuild("tableform.php", $strDatabase, $tablename , "view", "", "") . "\">" . $tablename . "</a>", 
				$count,
				$fieldcount,
					$tablemakerlink,
				"[<a onclick=\"return(tableconfirm('drop', '" .  $tablename . "'))\" href=\"" . qbuild("dbtools.php", $strDatabase, $tablename , "drop", "", "") . "\">drop</a>]",
				"[<a onclick=\"return(tableconfirm('empty', '" .  $tablename . "'))\" href=\"" . qbuild("dbtools.php", $strDatabase, $tablename , "empty", "", "") . "\">empty</a>]",
				"[<a target=\"_new\" href=\"" . qbuild("tablexml.php", $strDatabase, $tablename , "view", "", "") . "\">XML</a>]",
				"[<a href=\"" . qbuild("dbtools.php", $strDatabase, $tablename , "backup", "", "") . "\">SQL</a>]",
				"[<a href=\"" . qbuild("dump.php", $strDatabase, $tablename , "", "", "") . "\">export</a>]",
				"[<a href=\"" . qbuild("import.php", $strDatabase, $tablename , "", "", "") . "\">import</a>]"
			);
		}
		 
	}
	$out.="</table>"; 
	$out.="<script>NumberRows('idsorttable', 4);</script>";
	return $out;

}


function FieldFinderForm($strDatabase, $strColumn, $comprehensivesearch)
{
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strPHP="tableform.php";
	$out.= adminbreadcrumb(false, $strDatabase, $strPHP . "?" . qpre . "db=" . $strDatabase, "search database for a field name", "");
	$out.="<form enctype=\"multipart/form-data\" name=\"BForm\" action=\"fieldfinder.php\" method=\"post\">\n";
	$out.="<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"12000000\" />";

	$tableheader="<table class=\"bgclassline\" cellpadding=\"0\" cellspacing=\"1\" border=\"0\" width=\"500\">\n";
	$out.=$tableheader;
	$out.="<tr class=\"bgclassline\"><td colspan=\"2\">\n";
	$strButtonLabel= "Search";
	$out.="</strong>\n</td></tr>\n";
	$out.=htmlrow($strClassFirst, 
	"field to search for: ",
	GenericInput(qpre . "column", $strColumn, false, "",  "", "", "text", "44")
	);
	$out.=htmlrow($strClassSecond, 
	"comprehensive search? ",
	boolcheck(qpre . "comprehensivesearch",$comprehensivesearch, true, $bwlNoForm=false) . " <br/>Comprehensive search looks through the field and table names for the occurrence of the search term, and returns a hit even if it is part of another word."
	);
	
	
	
	
	$out.=htmlrow("bgclassline", 
		"&nbsp;",
		GenericInput(qpre . "submit",   $strButtonLabel)
		);
	$out.= HiddenInputs(array("db"=>$strDatabase));
	$out.="</td></tr>\n";
	$out.="</table>\n";
	$out.="</form>\n";
	return $out;
}
?>