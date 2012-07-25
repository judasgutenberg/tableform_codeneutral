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
	$strTable=gracefuldecay( $_REQUEST[qpre . "table"], "USERS");
	$strDatabase=deMoronizeDB(gracefuldecay($_REQUEST[qpre . "db"],our_db));
	$strColumn=gracefuldecay($_REQUEST[qpre . "column"], "ID");
	$strDirection=gracefuldecay($_REQUEST[qpre . "direction"], "DESC");
	$strSearchField=gracefuldecay($_REQUEST[qpre . "searchfield"], "EMAIL");
	$strSearchString=$_REQUEST[qpre . "searchstring"];
	$intSearchType=gracefuldecay($_REQUEST[qpre . "searchtype"], 1);
	$strConfigBehave=$_REQUEST[qpre . "behave"];
	$type=$_REQUEST["type"];
	$intRecord=gracefuldecaynumeric($_REQUEST["r"],0);
	$feedback="";
	$bwlSimplifyLogin=false;
	$out=LoginDecisions($strDatabase,  $strPHP, $strUser,$bwlSimplifyLogin, $strConfigBehave);
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
				$out.=UserLister($intRecord,200,  $strColumn, $strDirection ,   $strSearchString, $strSearchField, $intSearchType, $type);
			}
		}
	}
	$out.=userfeedback($feedback);
	$out =PageHeader($strDatabase . IfAThenB($strTable, " : ") . $strTable . IfAThenB($id, " : ") . $id . IfAThenB($mode, " : ") . $mode . " : Editor" . IfAThenB($type, " : ")  . typeToTypeName($type), $strConfigBehave, $strForBackField, true, $bwlSimplifyLogin, "", $strDatabase) .   $out . PageFooter(true, $bwlNoajax, $bwlSimplifyLogin);
	return $out;
}

function UserLister($intStart, $intPerpage=200, $orderby="TIMESTAMP", $direction="DESC",  $strSearchString="", $strSearchField="", $intSearchType="", $type="" )
{
	//a custom lister for the article table for featurewell, making everything hyperlinked and what not
	$strUserURL="/tf/tf.php?x_db=featurewell&x_table=USERS&x_mode=edit&x_idfield=ID&x_displaytype=&x_filterid=&x_rec=0&x_column=ID&ID=";
	$strArticleURL="/tf/tf.php?x_db=featurewell&x_table=article&x_mode=edit&x_idfield=ID&x_displaytype=&x_filterid=&x_rec=0&x_column=ID&ID=";
	$strPHP="/tf/tf.php?x_db=featurewell&x_table=USERS&x_mode=edit&x_idfield=ID&x_displaytype=&x_filterid=&x_rec=0&x_column=ID";
	$strCountSQL="select count(a.ID) as 'countage'
		from  USERS u ";
	$strSQL="
		select u.ID,  u.FIRST_NAME ,  u.LAST_NAME, PUBLICATION,  u.ACTIVE,u.EMAIL, u.PHONE, u.STATE, SUBSTR(c.NAME,1,16) as COUNRY
		from 
		USERS  u
		LEFT JOIN COUNTRY c ON u.COUNTRY_CODE=c.PHONE_CODE
		";
	$addendum="";
	if($type!="")
	{
		$addendum=" WHERE ROLES LIKE '%" . $type . "%'";
	}
	if( $strSearchString!=""  && $strSearchField!="")
	{
		 $addendum=MergeSQLConditionals($addendum, SearchTypeToSQLPhrase($intSearchType, $strSearchField, $strSearchString),true);
		//$addendum.=  " WHERE " . RemoveFirstCharacterIfMatch(SearchTypeToSQLPhrase($intSearchType, $strSearchField, $strSearchString), " WHERE");
	}
	$strSQL.=$addendum;
	$strCountSQL.=$addendum;
	$strSQL.=" ORDER BY " . $orderby . " " . $direction;
	$intRecCount=CountSQLRecords($strCountSQL);
	$strSQL.=" LIMIT " . $intStart . "," .  $intPerpage ;
	//echo $strSQL;
	$out= GenericRSDisplay(our_db, $strPHP,our_db ." : Users" . IfAThenB($type, " : ")  . typeToTypeName($type) , $strSQL,1,940 , "", "", "<a onclick='return(confirm(\"Are you sure you want to delete this user?\"))' href='tf.php?x_db=featurewell&x_table=USERS&x_mode=delete&x_idfield=ID&ID=<replace/>&x_direction=DESC&x_column=ID'>delete</a>", "AUTHOR_ID ", false, true, 10, "", 
	Array("EMAIL"=>"\"<a href='mailto:<value/>'><value/></a>\"", "ID^" . $strUserURL ),"", true, false, "",$intRecCount>$intPerpage);
	
	$out.=paginatelinks($intRecCount, $intPerpage, $intStart,"articlelister.php", "r",  "", "Go to Page: ");
	return $out;
}

function typeToTypeName($in)
{
	$strConfig="A|Authors-C|Customers-S|Admins";
	//data($strIn,$intTypeIn, $intTypeOut, $strTranslate)
	return data($in, 0, 1, $strConfig);

}
?>