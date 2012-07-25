<?php 
//Judas Gutenberg January 2006
//provides a web front end admin tool for any MySQL db
//depends on a table called tf_relation for foreign key info
//also needs admin table, permission table, and permission_type table
//This code is covered under the GNU General Public License
//info here: http://www.gnu.org/copyleft/gpl.html
//the digest is as follows: you cannot modify this code without
//publishing your source code under the same license
//contact the developer at gus@asecular.com  http://asecular.com

require_once('tf_functions_core.php'); 
require_once('tf_functions_editor.php');
require_once('tf_save_form.php');
require_once('tf_functions_serialize_form.php');
IncludeIfThere("tf_functions_frontend_db.php");

if(file_exists("tf_odbc_functions.php"))
{
	include("tf_odbc_functions.php");
}
 
//this is in case we are doing wysiwygpro, though i don't want it to bomb if the files aren't there
$errorlevel=error_reporting(0);
	include("editor_files/config.php");
	include("editor_files/editor_class.php");
error_reporting($errorlevel);

echo main();

function main()
{
	if(!IsExtraSecure())
	{
		die(ExtraSecureFailure());
	}
	$out="";
	$strFieldConfig="";
	$strPHP=$_SERVER['PHP_SELF'];
	$olderror=error_reporting(0);
	$mode=gracefuldecay("view",$_REQUEST[qpre . "mode"]);
	//this way assumes a single PK:
	$id=$_REQUEST[$idfield];
 
	if(!beginswith($keyserialized, "b:"))
	{
		$arrPK=unserialize($keyserialized);
 	}
	$strTable=gracefuldecay( $_REQUEST[qpre . "table"],articletable);
	$strDatabase=deMoronizeDB(gracefuldecay($_REQUEST[qpre . "db"],our_db));
	$strColumn=gracefuldecay($_REQUEST[qpre . "column"], "ID");
	$strDirection=gracefuldecay($_REQUEST[qpre . "direction"], "DESC");
	$strSearchField=gracefuldecay($_REQUEST[qpre . "searchfield"], "TITLE");
	$strSearchString=$_REQUEST[qpre . "searchstring"];
	$intSearchType=gracefuldecay($_REQUEST[qpre . "searchtype"], 1);
	$strConfigBehave=$_REQUEST[qpre . "behave"];
	$intRecord=gracefuldecaynumeric($_REQUEST["r"],0);
	$feedback="";
	$bwlSimplifyLogin=false;
	$out=LoginDecisions($strDatabase,  $strPHP, $strUser,$bwlSimplifyLogin, $strConfigBehave);
	$intUserID=GenericDBLookup($strDatabase,  tfpre . "admin", "username", $strUser, "admin_id");
	$isSuperAdmin=IsSuperAdmin($strDatabase, $strUser);
	//echo $strDatabase . " " .  $strUser. "<br>";
	$isSuperUser=IsSuperUser($strDatabase, $strUser) || $isSuperAdmin;
	{
	 	if ($strUser!="")
		{
			if (function_exists(toolnav) )
			{
					$out=toolnav(true) . $out;
			}
			if ($isSuperUser  )
			{	
				$intStart=0;
				$out.=TableSearcherForm($strDatabase, $strTable,   $strSearchString, $strSearchField, $intSearchType);
				$out.=ArticleLister($intRecord,200,  $strColumn, $strDirection ,   $strSearchString, $strSearchField, $intSearchType);
			}
		}
	}
	$out.=userfeedback($feedback);
	$out =PageHeader($strDatabase . IfAThenB($strTable, " : ") . $strTable . IfAThenB($id, " : ") . $id . IfAThenB($mode, " : ") . $mode . " : Editor", $strConfigBehave, $strForBackField, true, $bwlSimplifyLogin, "", $strDatabase) .   $out . PageFooter(true, $bwlNoajax, $bwlSimplifyLogin);
	return $out;
}

function ArticleLister($intStart, $intPerpage=200, $orderby="TIMESTAMP", $direction="DESC",  $strSearchString="", $strSearchField="", $intSearchType="" )
{
	//a custom lister for the article table for featurewell, making everything hyperlinked and what not
	$strUserURL="/tf/tf.php?x_db=featurewell&x_table=USERS&x_mode=edit&x_idfield=ID&x_displaytype=&x_filterid=&x_rec=0&x_column=ID&ID=";
	$strArticleURL="/tf/tf.php?x_db=featurewell&x_table=" . articletable . "&x_mode=edit&x_idfield=ID&x_displaytype=&x_filterid=&x_rec=0&x_column=ID&ID=";
	$strPHP="/tf/tf.php?x_db=featurewell&x_table=" . articletable . "&x_mode=edit&x_idfield=ID&x_displaytype=&x_filterid=&x_rec=0&x_column=ID";
	$strCountSQL="select count(a.ID) as 'countage'
		from " . articletable . " a JOIN USERS u
		ON a.AUTHOR_ID = u.ID";
	$strSQL="
		select a.ID,a.TITLE as 'title',a.AUTHOR_ID, CONCAT(LAST_NAME, ', ', FIRST_NAME) as 'author' , a.ACTIVE, a.LATEST, a.TIMESTAMP, TIMEDIFF(NOW(),a.TIMESTAMP) as 'ago',  c.NAME as 'category'
		from 
		" . articletable . " a 
		LEFT JOIN USERS u ON a.AUTHOR_ID=u.ID
		LEFT JOIN CATEGORY c ON a.CATEGORY_ID=c.ID
		";
	$addendum="";
	if( $strSearchString!=""  && $strSearchField!="")
	{
		$addendum=  " WHERE " . RemoveFirstCharacterIfMatch(SearchTypeToSQLPhrase($intSearchType, $strSearchField, $strSearchString), " WHERE");
	}
	$strSQL.=$addendum;
	$strCountSQL.=$addendum;
	$strSQL.=" ORDER BY " . $orderby . " " . $direction;
	$intRecCount=CountSQLRecords($strCountSQL);
	$strSQL.=" LIMIT " . $intStart . "," .  $intPerpage ;
	$out= GenericRSDisplay(our_db, $strPHP,our_db ." : Articles", $strSQL,1,850 , "", "", "<a onclick='return(confirm(\"Are you sure you want to delete this article?\"))' href='tf.php?x_db=featurewell&x_table=" . articletable . "&x_mode=delete&x_idfield=ID&ID=<replace/>&x_direction=DESC&x_column=ID'>delete</a>", "AUTHOR_ID ", false, true, 10, "", 
	Array( "author"=>"AUTHOR_ID^" . $strUserURL, "title"=>"ID^" . $strArticleURL ),"", true, false, "",$intRecCount>$intPerpage);
	
	$out.=paginatelinks($intRecCount, $intPerpage, $intStart,"articlelister.php", "r",  "", "Go to Page: ");
	return $out;
}
?>