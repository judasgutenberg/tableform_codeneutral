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


require('tf_functions_core.php'); 
require('tf_functions_editor.php');

//error_reporting(E_ALL^E_STRICT);
//ini_set("display_errors", 1);
//include('tf_save_form.php');;
 
require('tf_save_form.php');
require('tf_functions_serialize_form.php');
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
 
	//echo $idfield . " " . $_REQUEST[$idfield];
	//this way assumes a single PK:
	$id=$_REQUEST[$idfield];
 
 
	if(!beginswith($keyserialized, "b:"))
	{
		$arrPK=unserialize($keyserialized);
 	}
 
	$strTable=gracefuldecay("article", $_REQUEST[qpre . "table"]);
 
	$strDatabase=deMoronizeDB(gracefuldecay($_REQUEST[qpre . "db"],our_db));
	$strColumn=$_REQUEST[qpre . "column"];
	
	$strDirection=$_REQUEST[qpre . "direction"];
	$strSearchField=gracefuldecay($_REQUEST[qpre . "searchfield"], "TITLE");
	$strSearchString=$_REQUEST[qpre . "searchstring"];
	$intSearchType=gracefuldecay($_REQUEST[qpre . "searchtype"], 1);
	$strConfigBehave=$_REQUEST[qpre . "behave"];
	$intRecord=gracefuldecaynumeric($_REQUEST["r"],0);
	$feedback="";
	$bwlHadOurContent=false;
	//error_reporting($olderror);
	$bwlSimplifyLogin=false;
	//http://www.featurewell.com/tf/tf_table_searcher.php?x_arrdesc=a%3A1%3A{s%3A2%3A%22ID%22%3Bs%3A2%3A%2210%22%3B}&x_parenttable=article&=&x_db=featurewell&x_table=USERS&x_launcherfield=AUTHOR_ID
  	//if the table name begins with a "!" then we go directly to any tool written specifically for it
 
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
				$out.=TableSearcherForm($strDatabase, $strTable,   $strSearchString, $strSearchField, $intSearchType );
				$out.=ArticleLister($intRecord,100,  "TIMESTAMP", "DESC",   $strSearchString, $strSearchField, $intSearchType );
				 
			}
	 	
 
			$intAdminType= AdministerType($strDatabase, $strTable, $strUser, $id);
			
			$bwlBeginsWithTF=beginswith($strTable,  tfpre);
		 	//echo $bwlBeginsWithTF . "+" . $isSuperAdmin . "-" . $isSuperUser;
			 
			if($bwlBeginsWithTF && !$isSuperAdmin && !$isSuperUser)
			{
			 
				$intAdminType=0;
			}
			//echo $intAdminType;
			if ($intSearchType=="")
			{
				$intSearchType=0;
			}
			if ($intRecord=="")
			{
				$intRecord=0;
			}
 

			 
		}
	}
 
 
	$out.=userfeedback($feedback);
	$out =PageHeader($strDatabase . IfAThenB($strTable, " : ") . $strTable . IfAThenB($id, " : ") . $id . IfAThenB($mode, " : ") . $mode . " : Editor", $strConfigBehave, $strForBackField, true, $bwlSimplifyLogin, "", $strDatabase) .   $out . PageFooter(true, $bwlNoajax, $bwlSimplifyLogin);
	return $out;
}


function ArticleLister($intStart, $intPerpage=200, $orderby="TIMESTAMP", $direction="DESC",  $strSearchString="", $strSearchField="", $intSearchType="")
{
	$strUserURL="/tf/tf.php?x_db=featurewell&x_table=USERS&x_mode=edit&x_idfield=ID&x_displaytype=&x_filterid=&x_rec=0&x_column=ID&ID=";
	$strArticleURL="/tf/tf.php?x_db=featurewell&x_table=article&x_mode=edit&x_idfield=ID&x_displaytype=&x_filterid=&x_rec=0&x_column=ID&ID=";
	$strPHP="/tf/tf.php?x_db=featurewell&x_table=article&x_mode=edit&x_idfield=ID&x_displaytype=&x_filterid=&x_rec=0&x_column=ID";
	$strCountSQL="select count(article.ID) as 'countage'
		from article, USERS
		where AUTHOR_ID = USERS.ID";
	$strSQL="
		select article.ID,TITLE as 'title', AUTHOR_ID, concat(FIRST_NAME, ' ', LAST_NAME) as author, article.ACTIVE, LATEST, TIMEDIFF(NOW(),article.TIMESTAMP) as ago, article.TIMESTAMP 
		from article, USERS
		where AUTHOR_ID = USERS.ID";
	$addendum="";
	if( $strSearchString!=""  && $strSearchField!="")
	{
	
		$addendum=  " AND" . RemoveFirstCharacterIfMatch(SearchTypeToSQLPhrase($intSearchType, $strSearchField, $strSearchString), " WHERE");
		//$addendum= " AND article." . $strSearchField. " LIKE '%" . $strSearchString . "%'";
	
	}
	$strSQL.=$addendum;
	$strCountSQL.=$addendum;
	$strSQL.="
		order by article." . $orderby . " " . $direction;
	//echo $strSQL;
		//and DATEDIFF(now(),LOADED_DATE) < 5
	$intRecCount=CountSQLRecords($strCountSQL);
	//die($intRecCount);
	$strSQL.=" LIMIT " . $intStart . "," .  $intPerpage ;
	//echo $strSQL;
	$out= GenericRSDisplay(our_db, $strPHP,"Articles", $strSQL,0,650 , "", "", "", "AUTHOR_ID ", false, true, 10, "", 
	Array( "author"=>"AUTHOR_ID^" . $strUserURL, "title"=>"ID^" . $strArticleURL ));
	
	$out.=paginatelinks($intRecCount, $intPerpage, $intStart,"articlelister.php", "r",  "", "Go to Page: ");
	return $out;
}



function TableSearcherForm($strDatabase, $strTable,$strSearchString="", $strSearchField="", $intSearchType="" )
{


	$sql=conDB();
 	$strSearch.="<form action='articlelister.php' method='get'>";
	
	//if there is no data in the table then we have to look at the table's description
	$arrDesc=$samplerecord;
	if(count($arrDesc)<1)
	{
		$arrDesc=GetFieldTypeArray($strDatabase, $strTable);
	}

	$strDirection=ReverseDirectionSQL($strDirection);
	$strSearch.="<nobr><span class=\"tf_search\"><input name=\"" . qpre . "searchstring\" size=\"30\" type=\"text\" value=\"" . $strSearchString . "\">\n";
	$strConfig="0|at the beginning of-1|within-2|at the end of-3|as";
	//GenericDataPulldown($strConfig, $intIDField, $intLabelField, $strQueryVariableName, $strDefault, $strPHP, $strFormName, $strConnector ="?", $bwlAcceptWild=true, $strEmptyText="-none-", $rowdelimiter="-", $fielddelimiter="|", $strExtraValPairs="")
	$strSearch.=  GenericDataPulldown($strConfig,0, 1, qpre . "searchtype", $intSearchType, "", "",  "?", true, "-none-", "-", "|", "class='searchselect'");
	$strSearch.=   " the ";
	$strSearch.="<select name=\"" . qpre . "searchfield\" class=\"searchselect\">\n";
	$intFieldCount=0;
	$strLinkBasis=qbuild($strPHP, $strDatabase, $strOriginalTable, "view", $strIDFieldName, $value[$strIDFieldName]) . "&" . qpre . "displaytype=" . $displaytype   . "&" . qpre . "filterid=" . $intThisFilterID . "&" . qpre . "launcherfield=" . $launcherfield . "&" . qpre . "direction=" . $strDirection . "&" . qpre . "column=";
	foreach ($arrDesc as $name=>$info)
	{
 
		$bwlForceHide=false;
		foreach($rsColumnInfo as $irecord)
		{
			if($irecord["column_name"]==$name && $irecord["invisible"]==1)
			{
				$bwlForceHide=true;
			
			}
		}
		$strSel="";	
		if (GreaterFieldDisplayLogic($strTable, $strFieldConfig, $name, $intFieldCount, $intFieldLimitLo, $intFieldLimitHi, $display_field_list)  && !$bwlForceHide  || ($strSearchField==$name))
		{

		 
			if ($name==$strSearchField)
			{
				$strSel=" selected";
			}
			$strSearch.="<option" . $strSel . ">" . $name . "</option>\n";
			$displayname=$name;
	
			$intFieldCount++;
		}
		else
		{
			$strSearch.="<option" . $strSel . ">" . $name . "</option>\n";
		
		}
	}
	$strSearch.="</select>\n field\n: <input class=\"btn\"
   onmouseover=\"this.className='btn btnhov'\" onmouseout=\"this.className='btn'\" name=\"" . qpre . "searchbutton\" value=\"search\" type=\"submit\"></span></nobr>\n";
 	$strSearch.="</form>";
	return $strSearch;

}
?>