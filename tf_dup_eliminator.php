<?php 
//Judas Gutenberg August 2008
//Searches through a database looking for changes since a set point
//of course, it doesn't bother searching through its own tables (or any other tableform tables)
//This code is covered under the GNU General Public License
//info here: http://www.gnu.org/copyleft/gpl.html
//the digest is as follows: you cannot modify this code without
//publishing your source code under the same license
//contact the developer at gus@asecular.com   

include('tf_functions_core.php');
//include('tf_core_table_creation.php'); 
include('tf_functions_backup.php');
include('tf_functions_sql_parsing.php');
include('tf_functions_frontend_db.php');


echo main();

function main()
{
	if(!IsExtraSecure())
	{
		die(ExtraSecureFailure());
	}

	
	//$olderror=error_reporting(0);
 
	$mode=$_REQUEST[qpre . "eliminate"];
 
	$strDatabase=deMoronizeDB(gracefuldecay($_REQUEST[qpre . "db"],our_db));
 	$strTable=deMoronizeDB($_REQUEST[qpre . "table"]);
	$strField=deMoronizeDB($_REQUEST[qpre . "field"]);
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
			$out.= DuplicateEliminatorForm($strDatabase, $strTable, $strField);
			if($mode!="")
			{
				$out.="<div class='feedback'>" . EliminateDuplicates($strDatabase, $strTable, $strField)  . "</div>";
			}

		}
	}
	$out =  PageHeader($strDatabase . " : duplicate row eliminator", $strConfigBehave, "", true, false, "", $strDatabase) . $out . PageFooter();
	
	return $out;
}
	 

function DuplicateEliminatorForm($strDatabase, $strDefaultTable, $strField)
{
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strPHP="tf.php";
	$preout= adminbreadcrumb(false, $strDatabase, $strPHP . "?" . qpre . "db=" . $strDatabase,"db tools","tf_dbtools.php?" . qpre . "db=" . $strDatabase,  "eliminate duplicates", "");
	$preout.="<form enctype=\"multipart/form-data\" name=\"BForm\" action=\"tf_dup_eliminator.php\" method=\"post\">\n";
 
	$out="<tr class=\"bgclassline\"><td colspan=\"2\">\n";
	$strButtonLabel= "Eliminate Duplicates";
	$out.=htmlrow($strClassFirst, "table", TableDropdown($strDatabase, $strDefaultTable, qpre  . "table", "BForm",  qpre  . "field"));
	 

	$out.=htmlrow($strClassSecond, "irrelevant field (usually an autoincrement PK)",FieldDropdown($strDatabase, $strDefaultTable, qpre . "field", $strField));
 
	$out.=htmlrow("bgclassline", 
		"&nbsp;",
		GenericInput(qpre . "eliminate",   "Eliminate Duplicates", false, 'return(confirm("Are you certain you want to eliminate the duplicates in this table?"))')
 
		);
	$out.= HiddenInputs(array("db"=>$strDatabase));
	$out.="</td></tr>\n";
	$out=  $preout . TableEncapsulate($out, false);
	$out.="</form>\n";
	return $out;
}

?>