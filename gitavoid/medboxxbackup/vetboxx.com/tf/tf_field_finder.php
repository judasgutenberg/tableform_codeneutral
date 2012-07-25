<?php
//Judas Gutenberg August 2008
//Searches through a database looking for tables with a given field name
//This code is covered under the GNU General Public License
//info here: http://www.gnu.org/copyleft/gpl.html
//the digest is as follows: you cannot modify this code without
//publishing your source code under the same license
//contact the developer at gus@asecular.com  http://asecular.com

include('tf_functions_core.php');
include('tf_functions_editor.php');

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
	$strColumn2=$_REQUEST[qpre . "column2"];
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
			$out.= FieldFinderForm($strDatabase, $strColumn, $strColumn2, $comprehensivesearch);
			if($strColumn=="")
			{
			
			}
			else
			{
				$out.=  DisplayTablesWithColumn($strDatabase, $strColumn, $strColumn2, $strPHP, $comprehensivesearch);
			}
		}
	}
	$out =  PageHeader($strDatabase . " : field finder", $strConfigBehave) . $out . PageFooter();
	
	return $out;
}

	
function DisplayTablesWithColumn($strDatabase,  $strColumn, $strColumn2, $strPHP, $comprehensivesearch)
{
	
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strOtherBgClass="bgclassother";
	$strLineClass="bgclassline";
	$strThisBgClass=$strClassFirst;
	$sql=conDB(); 
	$strFieldName="Tables_in_" . str_replace("`", "", $strDatabase);
	//echo $comprehensivesearch;
	if($comprehensivesearch==0)
	{
		//$strSQL="SHOW TABLES FROM " .  $strDatabase ; 
		$tables=TableList($strDatabase);
		$strRelationTerm="named";
		$strConjunction="or";
		$strNoun="a field";
	}
	else
	{
		$strRelationTerm="containing";
		$strConjunction="and";
		$strNoun="a field";
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
		if( $strColumn2!="")
		{
			//$strSQL="DELETE * FROM " . $strDatabase  . ".temp_searchresult WHERE createtable NOT LIKE '%" . $strColumn2 . "%'";
			//$tables= $sql->query($strSQL);
		}
		$strSQL="SELECT * FROM " . $strDatabase  . ".temp_searchresult WHERE createtable LIKE '%" . $strColumn . "%'";
		$tables= $sql->query($strSQL);
		//echo $strSQL;
		//end of mystery code
		$strFieldName="tablename";
		//$tables=TableList($strDatabase, "LIKE '%" . $strColumn . "%'");
	}
	//echo $strSQL . " " . sql_error() . "<p>";
	$out="";
	$preout="";
	$descadditional="";
	if($strColumn2!="")
	{
		if($comprehensivesearch)
		{
			$strRelationTerm.=" both";
		}
		$descadditional=" " . $strConjunction . " '" . $strColumn2 . "'";
		$strNoun="fields";
	}
 
	$preout.= adminbreadcrumb(false,  $strDatabase, "tf.php" . "?" . qpre . "db=" . $strDatabase,  "db tools", "tf_dbtools.php". qpre . "db=" . $strDatabase, "tables containing  " . $strNoun . " " .  $strRelationTerm . " '" .  $strColumn . "'" . $descadditional, "") ;
	$preout.= "<script src=\"tf_tablesort.js\"><!-- --></script>";
 
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
	
	$bwlTableMakerExists=file_exists("tf_table_maker.php");
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
				$tablemakerlink= "<nobr>[<a href=\"" . qbuild("tf_table_maker.php", $strDatabase, $tablename , "", "", "") . "\">edit def.</a>]</nobr>";
			}
			else
			{
				$tablemakerlink= "&nbsp;";
			} 
			$out.=htmlrow
			(
				$strThisBgClass, 
				"<a href=\"" . qbuild("tf.php", $strDatabase, $tablename , "view", "", "") . "\">" . $tablename . "</a>", 
				$count,
				$fieldcount,
					$tablemakerlink,
				"[<a onclick=\"return(tableconfirm('drop', '" .  $tablename . "'))\" href=\"" . qbuild("tf_dbtools.php", $strDatabase, $tablename , "drop", "", "") . "\">drop</a>]",
				"[<a onclick=\"return(tableconfirm('empty', '" .  $tablename . "'))\" href=\"" . qbuild("tf_dbtools.php", $strDatabase, $tablename , "empty", "", "") . "\">empty</a>]",
				"[<a target=\"_new\" href=\"" . qbuild("tablexml.php", $strDatabase, $tablename , "view", "", "") . "\">XML</a>]",
				"[<a href=\"" . qbuild("tf_dbtools.php", $strDatabase, $tablename , "backup", "", "") . "\">SQL</a>]",
				"[<a href=\"" . qbuild("tf_dump.php", $strDatabase, $tablename , "", "", "") . "\">export</a>]",
				"[<a href=\"" . qbuild("tf_import.php", $strDatabase, $tablename , "", "", "") . "\">import</a>]"
			);
		}
		 
	}
	 
	$out=$preout . TableEncapsulate($out, true);
	return $out;

}


function FieldFinderForm($strDatabase, $strColumn, $strColumn2, $comprehensivesearch)
{
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strPHP="tf.php";
	$out="";
	$preout="";
	$preout.= adminbreadcrumb(false, $strDatabase, $strPHP . "?" . qpre . "db=" . $strDatabase, "search database for a field name", "");
	$preout.="<form name=\"BForm\" action=\"tf_field_finder.php\" method=\"post\">\n";
 

	 
	$out.="<tr class=\"bgclassline\"><td colspan=\"2\">\n";
	$strButtonLabel= "Search";
	$out.="</strong>\n</td></tr>\n";
	$out.=htmlrow($strClassFirst, 
		"column name or term  to search for: ",
		GenericInput(qpre . "column", $strColumn, false, "",  "", "", "text", "44")
	);
	
	$out.=htmlrow($strClassSecond, 
		"other column name or term to search for: ",
		GenericInput(qpre . "column2", $strColumn2, false, "",  "", "", "text", "44")
	);
	$out.=htmlrow($strClassFirst, 
	"comprehensive search? ",
	boolcheck(qpre . "comprehensivesearch",$comprehensivesearch, true, $bwlNoForm=false) . " <br/>Comprehensive search looks through the field and table names for the occurrence of the search term, and returns a hit even if it is part of another word."
	);
	
	
	
	
	$out.=htmlrow("bgclassline", 
		"&nbsp;",
		GenericInput(qpre . "submit",   $strButtonLabel)
		);
	$out.= HiddenInputs(array("db"=>$strDatabase));
	$out.="</td></tr>\n";
	$out=$preout . TableEncapsulate($out, false);
	$out.="</form>\n";
	return $out;
}
?>