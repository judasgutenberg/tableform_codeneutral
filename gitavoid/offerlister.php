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

//error_reporting(E_ALL^E_STRICT);
//ini_set("display_errors", 1);
//include('tf_save_form.php');;
 
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
	$strTable=gracefuldecay( $_REQUEST[qpre . "table"], "OFFER");
	$strDatabase=deMoronizeDB(gracefuldecay($_REQUEST[qpre . "db"],our_db));
	$strColumn=gracefuldecay($_REQUEST[qpre . "column"], "TIMESTAMP");
	$strDirection=gracefuldecay($_REQUEST[qpre . "direction"], "DESC");
	$strSearchField=gracefuldecay($_REQUEST[qpre . "searchfield"], "TIMESTAMP");
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
	
			if ($isSuperUser)
			{	
				$intStart=0;
				$out.=TableSearcherForm($strDatabase, $strTable,   $strSearchString, $strSearchField, $intSearchType, "buyer TITLE author TEXT" );
				$out.=OfferLister($intRecord,200,  $strColumn, $strDirection,   $strSearchString, $strSearchField, $intSearchType ); 
			}
		}
	}
	$out.=userfeedback($feedback);
	$out =PageHeader($strDatabase . IfAThenB($strTable, " : ") . $strTable . IfAThenB($id, " : ") . $id . IfAThenB($mode, " : ") . $mode . " : Editor", $strConfigBehave, $strForBackField, true, $bwlSimplifyLogin, "", $strDatabase) .   $out . PageFooter(true, $bwlNoajax, $bwlSimplifyLogin);
	return $out;
}

function OfferLister($intStart, $intPerpage=200, $orderby="TIMESTAMP", $direction="DESC",  $strSearchString="", $strSearchField="", $intSearchType="")
{
	//a custom lister for the offer table for featurewell, making everything hyperlinked and what not
	$strUserURL="/tf/tf.php?x_db=featurewell&x_table=USERS&x_mode=edit&x_idfield=ID&x_displaytype=&x_filterid=&x_rec=0&x_column=ID&ID=";
	$strArticleURL="/tf/tf.php?x_db=featurewell&x_table=" . articletable . "&x_mode=edit&x_idfield=ID&x_displaytype=&x_filterid=&x_rec=0&x_column=ID&ID=";
	$strPHP="/tf/tf.php?x_db=featurewell&x_table=OFFER&x_mode=edit&x_idfield=ID&x_displaytype=&x_filterid=&x_rec=0&x_column=ID";
	$strUserURL="/tf/tf.php?x_db=featurewell&x_table=USERS&x_mode=edit&x_idfield=ID&x_displaytype=&x_filterid=&x_rec=0&x_column=ID&ID=";
	$strInvoiceURL="/tf/tf.php?x_db=featurewell&x_table=INVOICE&x_mode=edit&x_idfield=ID&x_displaytype=&x_filterid=&x_rec=0&x_column=ID&ID=";
	$strSQL="
	  select  o.ID, Concat('$', FORMAT(o.OFFER,2)) as 'USD',  o.USER_ID, o.INVOICE_ID as invoice, u.USERNAME as buyer, ARTICLE_ID, a.TITLE , a.AUTHOR_ID, CONCAT(AUTHOR_USER.LAST_NAME, ', ', AUTHOR_USER.FIRST_NAME) as 'author'  , o.TIMESTAMP,  TIMEDIFF(NOW(),o.TIMESTAMP) as 'ago', o.STATUS  from OFFER o 
left join USERS u on u.ID = o.USER_ID left join COUNTRY c on COUNTRY_CODE = c.PHONE_CODE join " . articletable . " a on a.ID = o.ARTICLE_ID 
left join USERS AUTHOR_USER ON AUTHOR_USER.ID = a.AUTHOR_ID   
 	";
	$strCountSQL="SELECT count(ID) as 'countage' from OFFER o";
	if(inList("ID STANK", $strSearchField))
	{
		$strSearchField="o." .  $strSearchField;
	}
	if(inList("author ", $strSearchField))
	{
		$strSearchField=" a.FT_WRITER";
	}
	if(inList("buyer ", $strSearchField))
	{
		$strSearchField=" u.USERNAME";
	}
 	if( $strSearchString!=""  && $strSearchField!="")
	{
		$addendum=  " WHERE  " . RemoveFirstCharacterIfMatch(SearchTypeToSQLPhrase($intSearchType, $strSearchField, $strSearchString), " WHERE ");
	}
	$strSQL.=$addendum;
	$strCountSQL.=$addendum;
	$strSQL.=" ORDER BY  " . $orderby . " " . $direction;
	$strSQL.=" LIMIT " . $intStart . "," .  $intPerpage ;
	$intRecCount=CountSQLRecords($strCountSQL);
	//echo $strSQL;
	$out= GenericRSDisplay(our_db, $strPHP,our_db ." : Offers", $strSQL,1,850 , "", "", "<a onclick='return(confirm(\"Are you sure you want to delete this offer?\"))' href='tf.php?x_db=featurewell&x_table=OFFER&x_mode=delete&x_idfield=ID&ID=<replace/>&x_direction=DESC&x_column=ID'>delete</a>", "ARTICLE_ID USER_ID AUTHOR_ID", false, true, 12, "", 
	Array( "invoice"=>"invoice^". $strInvoiceURL, "author"=>"AUTHOR_ID^" . $strUserURL, "TITLE"=>"ARTICLE_ID^" . $strArticleURL, "buyer"=>"USER_ID^" . $strUserURL ),"", true, false, "",$intRecCount>$intPerpage);
	$out.=paginatelinks($intRecCount, $intPerpage, $intStart,"offerlister.php", "r",  "", "Go to Page: ");
	return $out;
}
?>