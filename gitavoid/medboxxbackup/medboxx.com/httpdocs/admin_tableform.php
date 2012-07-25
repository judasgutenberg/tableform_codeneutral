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

///xcart admin block
require "../includes/auth.php";
include "quick_menu.php";
define('extrainclude', str_replace("|xcartfunctions.php", "", extrainclude));

if (!empty($login) && $user_account["flag"] != "FS") 
{

 
	
	#
	# Define data for the navigation within section
	#
	$dialog_tools_data = array();

	$dialog_tools_data["left"][] = array("link" => "home.php?promo#menu", "title" => func_get_langvar_by_name("lbl_quick_menu"));
	
	if (!isset($promo)) {
		$dialog_tools_data["left"][] = array("link" => "#orders", "title" => func_get_langvar_by_name("lbl_last_orders_statistics"));
		$dialog_tools_data["left"][] = array("link" => "#topsellers", "title" => func_get_langvar_by_name("lbl_top_sellers"));

		$dialog_tools_data["right"][] = array("link" => "home.php?promo", "title" => func_get_langvar_by_name("lbl_quick_start"));
		$dialog_tools_data["right"][] = array("link" => "home.php?promo&display=news", "title" => func_get_langvar_by_name("lbl_new_features_in_xcart"), "style" => "hl");
	}
	else {
		$dialog_tools_data["left"][] = array("link" => "home.php?promo#qs", "title" => func_get_langvar_by_name("lbl_quick_start_text"));
		$dialog_tools_data["left"][] = array("link" => "home.php?promo&display=news", "title" => func_get_langvar_by_name("lbl_new_features_in_xcart"), "style" => "hl");

		$dialog_tools_data["right"][] = array("link" => "home.php", "title" => func_get_langvar_by_name("lbl_top_info"));
	}

	# Assign the section navigation data
	$smarty->assign("dialog_tools_data", $dialog_tools_data);


	if (isset($promo)) {
		if ($display == "news") {
			$location[] = array(func_get_langvar_by_name("lbl_new_features_in_xcart"), "");
			$smarty->assign("display", "news");
		}
		else
			$location[] = array(func_get_langvar_by_name("lbl_quick_start"), "");
		$smarty->assign("main", "promo");
	}
	else {
		include "admin/main.php";
		$smarty->assign("main","top_info");
	}
}
else
{
	$smarty->assign("main", "home");
}



if (!empty($login))
{
	$smarty->assign("location", $location);
}
@include "admin/modules/gold_display.php";
func_display("admin/home.tpl", $smarty);
/////////////////////////////////////////


require('tf_functions_core.php');
require('tf_functions_editor.php');
require('tf_save_form.php');
require('tf_functions_serialize_form.php');

//this is in case we are doing wysiwygpro, though i don't want it to bomb if the files aren't there
$errorlevel=error_reporting(0);
	include("editor_files/config.php");
	include("editor_files/editor_class.php");
error_reporting($errorlevel);

echo main();
 
function main()
	{
		$out="";
		$strPHP=$_SERVER['PHP_SELF'];
		$olderror=error_reporting(0);
		$mode=$_REQUEST[qpre . "mode"];
		$displaytype=$_REQUEST[qpre . "displaytype"];
		$idfield=$_REQUEST[qpre . "idfield"];
		$strBackfield=$_REQUEST[qpre . "backfield"];
		//this way assumes a single PK:
		$id=$_REQUEST[$idfield];
		//new way for slurping in a PK array
		//should i really have to deescape?
		$keyserialized=deescape($_REQUEST[qpre . "ks"]);
		//echo ($keyserialized);
		if(!beginswith($keyserialized, "b:"))
		{
			$arrPK=unserialize($keyserialized);
	 	}
		$clearid=$_REQUEST[qpre . "submit_clearid"];
		$intFilterID=$_REQUEST[qpre . "filterid"];
		$strTable=$_REQUEST[qpre . "table"];
	 
		$strDatabase=deMoronizeDB(gracefuldecay($_REQUEST[qpre . "db"],our_db));
		$strColumn=$_REQUEST[qpre . "column"];
		
		$strDirection=$_REQUEST[qpre . "direction"];
		$strSearchField=$_REQUEST[qpre . "searchfield"];
		$strSearchString=$_REQUEST[qpre . "searchstring"];
		$intSearchType=$_REQUEST[qpre . "searchtype"];
		$strConfigBehave=$_REQUEST[qpre . "behave"];
		$intRecord=$_REQUEST[qpre . "rec"];
		$feedbackspanstag="<div class=\"feedback\">";
		//error_reporting($olderror);
		$bwlSimplifyLogin=false;
	  	//if the table name begins with a "!" then we go directly to any tool written specifically for it
		
	  	if (beginswith($strTable,"!"))
		{
			//echo "$$";
			$strTable=substr($strTable, 1);
			$toolpage=GenericDBLookup($strDatabase, tfpre . "browsescheme", "table_name", $strTable, "toolpage");
			
			if ($toolpage!="")
			{
				//echo "#";
 				header("Location: " . qbuild( $toolpage , $strDatabase, $strTable, "view", "id", $strOurID) . "&displaytype=7");
			}
			else //if there's no tool location, assume that what was meant was a php url of a front page kinda thing
			{
				header("Location: " . $strTable . ".php");
			
			}
		}
	  
	  
	 	if ($mode=="")
		{
			$strTable="";
		}
		if (contains($strConfigBehave,"closeclickrecycle"))
		{
			$bwlSimplifyLogin=true;
		}
		$out=LoginDecisions($strDatabase,  $strPHP, $strUser,$bwlSimplifyLogin);
		$intUserID=GenericDBLookup($strDatabase,  tfpre . "admin", "username", $strUser, "admin_id");
		$isSuperAdmin=IsSuperAdmin($strDatabase, $strUser);
		$isSuperUser=IsSuperUser($strDatabase, $strUser) || $isSuperAdmin;
		if($mode=="version")
		{
			$out.= adminbreadcrumb(false,  $strDatabase, $strPHP . "?" . qpre . "db=" . $strDatabase,  "System Version", "") ;
			//$out.= AdminNav($isSuperAdmin);
			$out.=DetermineVersion();
		}
		else
		{
		 	if ($strUser!="")
			{
			
	 
				if (default_table=="default_table")
				{
					if ($strTable=="")
					{
						
						$out.=tablebrowser($strDatabase, $strPHP, $strUser);
					}
				}
				else
				{
					if ($strTable==""  && !$isSuperAdmin)
					{
						$strTable=default_table;
						if (beginswith($strTable,"!"))
						{
							$strTable=substr($strTable, 1);
							header("Location: " . $strTable . ".php");
						}
						$mode="view";
	
						
					}
					else if ($isSuperAdmin  && $strTable=="")
					{
					
						$out.=tablebrowser($strDatabase, $strPHP, $strUser);
					}
					else
					{
		
						
					}
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
		 
				
				if ($mode=="save"  || $mode=="create")
				{
			
					if ($intAdminType==2)
					{
						 
						//i clear id if i'm doing a "save as" type operation
						if ($clearid!="")
						{
							$mode="create";
							//clear non-composite PK
							$id="";
							//clear composite PK
							if(is_array($arrPK))
							{
								foreach ($arrPK as $k=>$v)
								{
									$arrSavePK[$k]="";
								}
							}
							if(is_array($arrPK))
							{
								$arrPK=ArraySubsetFromArray($arrPK, $_REQUEST);
							}
			 
						}
						else
						{
							if(is_array($arrPK))
							{
								$arrSavePK=$arrPK;
							}
						}
						//the following test keeps odd things from happening 
						//should these things find their way into query strings
						if($_POST[qpre . "submit_clearid"]!="" || $_POST[qpre . "submit"]!="")
						{
							$out.=$feedbackspanstag .  SaveForm($strDatabase, $strTable,  $idfield, $id, $strConfigBehave, $strUser, $arrSavePK). "</div>" ;
						}
					}
					else
					{
						$out.="You don't have permissions to edit this table.";
					}
				}
				//echo $mode . "+" . $strConfigBehave;
				//echo "--" . $id . "---";
				if ( $mode=="edit" || ($mode=="create"  &&  !contains($strConfigBehave,"complete")))
				{
					if ($intAdminType==2)
					{
						$out.=TableForm($strDatabase, $strTable,  $idfield, $id, $strPHP,  $strConfigBehave, "", $strUser, $arrPK);
						
					}
					elseif ($intAdminType==1)
					{
						$out.=DisplayDataForARow($strDatabase, $strTable, $idfield, $id, $strPHP);
					}
					else
					{
						$out.="You don't have permissions to view or edit this table.";
					}
				}
				if ($mode=="delete")
				{
					if ($intAdminType==2)
					{
						$out.=$feedbackspanstag . rowdelete($strDatabase, $strTable,  $idfield, $id, $strUser, $arrPK) . "</div>"; 
					}
					else
					{
						$out.="You don't have permissions to edit this table.";
					}
					if (contains($strConfigBehave,"closeclickrecycle"))
					{
						$strConfigBehave.="complete";
					}
				}
			 
				if ( $mode=="new")
				{
					if ($intAdminType==2)
					{
						$out.=TableForm($strDatabase, $strTable,  "", "", $strPHP, $strConfigBehave,"", $strUser, $arrPK);
					}
					else
					{
						$out.="You don't have permissions to edit this table.";
					}
				}
				
				if (($mode=="view"  || ($mode=="save" ) || $mode=="delete")    &&  !contains($strConfigBehave,"complete"))
				{
					 
					if ($intAdminType>0)
					{
						$strFieldConfig="cust_order|customer_name*episode|episode_name|episode_datetime|show_id";
						$strFieldConfig="project|project_title|project_desc|project_desc|project_desc|project_desc|project_desc";
						$out.=DisplayDataTable($strDatabase, $strTable, "", $strColumn, $strPHP, $strDirection, $intRecord, $strSearchString, $strSearchField, $intSearchType, 50, $strFieldConfig, 1, 5, true, false, false, "", $displaytype, $intFilterID, $intUserID, $isSuperAdmin); 
					}
					else
					{
						$out.="You don't have permissions to view this table.";
					}
				}
			}
		}
 		if (function_exists(toolnav) && !$bwlSimplifyLogin )
		{
			if ($strUser!="")
			{
				$out=toolnav(!$isSuperAdmin,  $strUser) . $out;
			}
		}
		if ($strBackfield!=""  &&  contains($strConfigBehave,"complete"))
		{
			$strNameField=firstnonidcolumname($strDatabase, $strTable);
			$strNameField2 = NthNonIDColumName($strDatabase, $strTable, 2);
			$strForBackField=$strDatabase . "|" . $strTable . "|" . $idfield . "|" . $strBackfield . "|" . $strNameField . "|" . $strNameField2 . "|" . $id;
			//echo $strForBackField;
			//die();
		}
		 
		$out =PageHeader($strDatabase . IfAThenB($strTable, " : ") . $strTable . IfAThenB($id, " : ") . $id . IfAThenB($mode, " : ") . $mode . " : Editor", $strConfigBehave, $strForBackField) .   $out . PageFooter();
		return $out;
	}



function tablebrowser($strDatabase, $strPHP, $strUser)
//shows all the tables in $strDatabase
{
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strOtherBgClass="bgclassother";
	$strLineClass="bgclassline";
	$strThisBgClass=$strClassFirst;
	$bwlViewsPossible=  TableExists($strDatabase,  tfpre . "browsescheme");
	$sql=conDB();
	//$tables = $sql->showtables(array("db" => $strDatabase)); 
	$bwlSuperAdmin=IsSuperAdmin($strDatabase, $strUser);
	if (IsSuperuser($strDatabase,  $strUser)  || $bwlSuperAdmin)
	{
		$strSQL="SHOW TABLES FROM " .  $strDatabase ; 
		$tables=TableList($strDatabase);
	}
	else
	{
		$intAdminID=GetAdminID($strDatabase, $strUser);
		//echo "SELECT table_name AS " . "Tables_in_" . $strDatabase . " from " .  $strDatabase . ".permission  WHERE admin_id=" .  $intAdminID ;
		$strSQL="SELECT table_name AS " . "Tables_in_" . $strDatabase . " from " .  $strDatabase . "." . tfpre . "permission WHERE admin_id=" .  $intAdminID . " ORDER BY table_name ASC "; 
		$tables = $sql->query($strSQL);
	
	}
	//echo $strSQL;
	
	//echo sql_error();
	//asort($tables);
	$preout="";
	$preout.= adminbreadcrumb(false,  $strDatabase, "",  "tables", "") ;
	//$out.= AdminNav($bwlSuperAdmin);
	$preout.= "<script src=\"tf_tablesort.js\"><!-- --></script>";
 


	//$out.= "</td></tr>\n";
	
	$out=htmlrow("bgclassline", "<a href=\"javascript: SortTable('idsorttable', 0)\">table</a>", "<a href=\"javascript: SortTable('idsorttable', 1)\">records</a>",  "<a href=\"javascript: SortTable('idsorttable', 2)\">columns</a>", "other views", "&nbsp;", "&nbsp;" , "&nbsp;");

	//echo "-" . count($tables) . "-" ;
	$strFieldName="Tables_in_" . str_replace("`", "", $strDatabase);
	//echo $strFieldName;
	$bwlTableMakerExists=file_exists("tf_table_maker.php");
	foreach ( $tables as  $k=>$v )
	{
		
		$tablename=$v[$strFieldName];
		$bwlBeginsWithTF=beginswith($tablename,  tfpre );
		if (($bwlBeginsWithTF &&  $bwlSuperAdmin) || !$bwlBeginsWithTF)
		{
			//echo $k;
			$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
			$count = countrecords($strDatabase , $tablename );
			if ($bwlViewsPossible)
			{
				$otherviews=ListViews($strDatabase , $tablename, $strPHP);
			}
			if ($bwlSuperAdmin  && $bwlTableMakerExists)
			{
				$tablemakerlink= "[<a href=\"" . qbuild("tf_table_maker.php", $strDatabase, $tablename , "", "", "") . "\">edit def.</a>]";
			}
			else
			{
				$tablemakerlink= "&nbsp;";
			}
			$fieldcount=FieldCount($strDatabase, $tablename);
			$out.=htmlrow(
				$strThisBgClass,
				"<a href=\"" . qbuild($strPHP, $strDatabase, $tablename , "view", "", "") . "\">" . $tablename . "</a>",
				$count,
				$fieldcount,
				$otherviews, 
				$tablemakerlink,
				"[<a href=\"" . qbuild("tf_dump.php", $strDatabase, $tablename , "", "", "") . "\">export</a>]",
				"[<a href=\"" . qbuild("tf_import.php", $strDatabase, $tablename , "", "", "") . "\">import</a>]"
 			);
		}
	}
	$out=$preout . TableEncapsulate($out);
	return $out;
}

function ListViews($strDatabase , $strTable, $strPHP)
{
	
	$sql=conDB();
	$strSQL="SELECT * FROM " . $strDatabase . "." .  tfpre . "browsescheme b JOIN " . $strDatabase . "." .  tfpre . "browsetype t ON b.browsetype_id=t.browsetype_id WHERE b.table_name='" . $strTable . "'";
	//echo $strSQL . "<br>";
	$records = $sql->query($strSQL); 
	foreach($records as $record)
	{
		$toolpage=$record["toolpage"];
		//echo $toolpage . "<br>";
		if ($record["browsetype_id"]==7 && $toolpage!=""  && file_exists($toolpage))
		{
			//if we have a browser of type 7 then just link directly to the tool with the params we know about
			$out.= " <a href=\"" . qbuild($toolpage, $strDatabase, $strTable , "view", "", "") . "&" . qpre . "displaytype=" . $record["browsetype_id"] . "\">" .  pluralize($strTable) . "</a>\n";
		}
		else
		{
			$out.= " <a href=\"" . qbuild($strPHP, $strDatabase, $strTable , "view", "", "") . "&" . qpre . "displaytype=" . $record["browsetype_id"] . "\">" . $record["name"] . "</a>\n";
		}
	
	}
	return $out;

}

function TableForm($strDatabase, $strTable, $strIDField, $strValDefault, $strPHP,  $strConfigBehave, $strFieldNamePrefix="", $strUser="",  $arrPK="")
{

//a generic form generator that looks at the table's description in the db and then dynamically builds an editor form
	$sql=conDB();
 

	$out="";
	$strValidationJS="";
	$width=50;
	$bwlSkipHiddenIDvalue=false;
	//the following two lines apply when there is integration with wysiwygpro
	$editorcount=0;
	$editor=Array();
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strOtherBgClass="bgclassother";
	$strLineClass="bgclassline";
	$strThisBgClass=$strClassFirst;
	$noshowfields=$_REQUEST[qpre . "noshow"];


	//the following 4 lines are sort of a hack to enable the form to return to the right page in the pagination when finished
	$intRecord=$_GET[qpre . "rec"];
	$strSort=$_GET[qpre . "column"];
	$strDirection=$_GET[qpre . "direction"];
	$strBackfield=$_GET[qpre . "backfield"];
 	$arrHelpText=Array();
	$arrPrettyName=Array();
	$arrValidationType=Array();
	$arrValidationPattern=Array();
	$arrWidth=Array();
	$arrHeight=Array();
	$arrIsPassword=Array();
	$arrIsFileUpload=Array();
	$arrForce_no_wysiwg=Array();
	$arrForce_wysiwg=Array();
	$intNestTable=0;
	$strNest=""; 
	$needtoencrypt="";
	$bwlSuperAdmin=IsSuperAdmin($strDatabase, $strUser);
	$bwlFoundLabel=false;
	$preout="";
	$out="";
	if($bwlSuperAdmin)
	{
	//echo "!";
	}
	if  ($strIDField=="")
	{
		$strIDField= PKLookup($strDatabase, $strTable);
	}
	
	if(contains($strIDField, " ")   && !is_array($arrPK))
	{
			//echo "<p>&&&" . $strIDField ."&&&<br>";
		$arrPK=ArraySubsetFromList($strIDField, "");
	}
	$intDefaultWide=50;
		
	if (!contains($strConfigBehave, "noheader"))
	{
		if (!contains($strConfigBehave,"closeclickrecycle"))
			{
				//$out.=AdminNav($bwlSuperAdmin);
				$intDefaultWide=90;
				$secondarytoollable=$strDatabase;
				$closebutton=" <a href=\"javascript: changetableeditorcollapse()\">+/-</a>";
				$disablelink=false;
			}
			else
			{
				$secondarytoollable="Secondary Editor";
				$closebutton="  [<a href=\"tf_message.php\">close this tool</a>]";
				$disablelink=true;
			}

		$preout.=adminbreadcrumb($disablelink,  $secondarytoollable, $strPHP . "?" . qpre . "db=" . $strDatabase,  $strTable, qbuild($strPHP, $strDatabase, $strTable, "view", "", "")) . $closebutton;
		
	}
 
	if (!contains($strConfigBehave, "noform"))
	{
		$out.="<form enctype=\"multipart/form-data\" name=\"BForm\" method=\"post\" action=\"" . $strPHP . "\" onSubmit=\" return validate_form();\">\n";
	}
	$out.= "<input type=\"hidden\" name=\"" . $strFieldNamePrefix . "MAX_FILE_SIZE\" value=\"12000000\" />\n";
	$descr=TableExplain($strDatabase, $strTable);

  
	$record="";
	if ($strValDefault!=""  || $arrPK!="")
	{
		if($arrPK!="")
		{
			$strSQL="SELECT * FROM " . $strDatabase . "." . $strTable . " WHERE " . ArrayToWhereClause($arrPK);
		}
		else
		{
			$strSQL="SELECT * FROM " . $strDatabase . "." . $strTable . " WHERE " .  $strIDField . " = '" . $strValDefault . "'";
		}
		//echo $strSQL;
		$records = $sql->query($strSQL);
		$record=$records[0];
		$strOtherButtonText="New " . forceSingular($strTable);
		$strButtonText="Save " . forceSingular($strTable);
		
		$strMode="save";
		
	}
	else
	{
		$strButtonText="Create " . forceSingular($strTable);
		$strMode="create";
	}
 	if (contains($strConfigBehave,"closeclickrecycle"))
	{
		$strConfigBehave.="complete";
		
	}

 	$futurelabel="";
	$strFromMulti="";
	$strTableLookingOutWith="";
	foreach ($descr as $nom=>$info)
		{
			$strPickerLink="";
			$skip=false;
			$fieldlabel=$info["Field"];
			$name=$fieldlabel;
			$nameforhelp=$name;
			if(!inList($noshowfields, $name))
			{
			
				$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
				$strDefault="";
				$strType=TypeParse($info["Type"], 0);
				$intLen=intval(TypeParse($info["Type"], 1));
				$width=$intLen;
				$bwlInvisible=false;
				$strPseudo="";
				$strMSQL="select * from " . $strDatabase . "." .  tfpre . "column_info WHERE table_name='" . $strTable . "' AND column_name='" . $name . "'"; 
				$mrecords = $sql->query($strMSQL);
				if (count($mrecords)>0)
				{
					$mrecord=$mrecords[0];
					$fieldlabel=gracefuldecay($mrecord["label"], $fieldlabel);
					$helptext=$mrecord["help_text"];
					$arrValidationType[$nameforhelp]=$mrecord["validation_type_id"];
					
					$arrWidth[$nameforhelp]=$mrecord["width"];;
					$arrHeight[$nameforhelp]=$mrecord["height"];
					$arrIsPassword[$nameforhelp]=$mrecord["password"];
					$arrIsFileUpload[$nameforhelp]=$mrecord["fileupload"];
					$arrForce_wysiwg[$nameforhelp]=$mrecord["force_wysiwg"];
					$arrForce_no_wysiwg[$nameforhelp]=$mrecord["force_no_wysiwg"];
					$arrValidationPattern[$nameforhelp]=GenericDBLookup($strDatabase,  tfpre . "validation_pattern",  "validation_pattern_id",$mrecord["validation_pattern_id"], "pattern");
					$arrHelpText[$nameforhelp]=$helptext;
					$arrPrettyName[$nameforhelp]=$fieldlabel;
					if ($mrecord["invisible"]==1)
					{
						$bwlInvisible=true;
					}
					if ($mrecord["data_from_multitable_relation"]==1)
					{
						 $strDefault="[multi-placeholder]";
					}
				}
			
				if ($bwlInvisible)
				{
					$out.="<input type=\"hidden\" name=\"" .$strFieldNamePrefix . $name . "\"   value=\"".  $strDefault . "\">\n";
				}
				else
				{

					$arrPseudo=RelationLookup($strDatabase, $strTable, $name, 3);
					//a pseudo-field is a "field" that is actually a formula in a field belonging to a parent table
					//it is found at this point only so it knows to display it after this field is displayed in another way
					if (count($arrPseudo)>0)
					{
						
						$strRTable=$arrPseudo[0];
						$strRField=$arrPseudo[1];
						$strIDFieldName = PKLookup($strDatabase, $strRTable);
						//in a pseudotable, what you get is a formula
						$strFormula=GenericDBLookup($strDatabase, $strRTable, $strIDFieldName, $arrRelationTemp[$strRTable], $strRField);
						if ($strFormula!="")
						{
							
							//a sample formula:
							//wordencode($strValDefault, 6, time());
							//$idtouse=gracefuldecay($futureid,  $strValDefault);
							$idtouse=$strValDefault;
							if ($idtouse>0)
							{
								$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
								$strFormula = str_replace("\$id", $idtouse, $strFormula);
								$strPseudoContent=   eval("return " .  $strFormula);
								$strPseudoLabel=gracefuldecay($futurelabel, $strTable) . " " . $strRField;
								$strPseudo.="<tr class=\"" .  $strThisBgClass . "\">\n";
								$strPseudo.="<td valign=\"top\">\n";
								$strPseudo.=$strPseudoLabel . "\n";
								$strPseudo.="</td>\n";
								$strPseudo.="<td class=\"heading\">\n";
								$strPseudo.=$strPseudoContent; 
								$strPseudo.="</td>\n";
								$strPseudo.="</tr>\n";
								$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
							}
						}
					
					}
					if (is_array($record))
					{
						$strDefault=$record[$info["Field"]];
						
						$strDefault=substr($strDefault, 0, strlen($strDefault));
						
						//i have a real problem with single quotes!!!
						$strDefault=deendquote($strDefault);
					}
					$strDefault=gracefuldecay($_GET[$name], $strDefault);
					$bwlHypLabel=false;
					if(strlen($strDefault)>32)//maybe 34
					{
						if(contains($strDefault, "-") && !contains(trim($strDefault), " "))
						{
							if(function_exists(xcartpwdencrypt))
							{
								$strDefault=xcartpwddecrypt($strDefault);
								$needtoencrypt.= " " . $name;
							}
						
						}
					
					}
					if($strDefault!=""  && (!$bwlFoundLabel || is_numeric($strRowLabel))  && (contains($strType, "char")  || contains($strType, "text"))  ) //i allow it to overwrite a found label if it's numeric and a non-numeric comes along
					{
						$bwlFoundLabel=true;
						$strRowLabel=$strDefault;
					}
					//a good place to put various data-type editors
					if(probableserialized($strDefault))
					{
						//SerializeExpand($strDatabase, $stTable, $strIDField, $strID, $strPHP)
						//$fieldform=$strDefault . "<br/>";
						$fieldform= SerializeForm($strDefault, qpre . "serialized|" . $name, $strThisBgClass);
						$skip=true;
					}
					else if (inlist("bigint mediumint int smallint", $strType))
					{
						$width=5;
						$arrMK=RelationLookup($strDatabase, $strTable, $name, 1);
						if (count($arrMK)>0)
						{
							$bwlHypLabel=true;
							//if we are dealing with a multi-table lookup, then things get really weird at that point.  
							//suddenly the row we're looking at becomes just the husk for a field in a totally different table
							//but first we need to know what that table is and what field it is.  we don't find that table directly;
							//we have to look it up using the arrFK we just retrieved
							//right all we now is that the primary key for that field in that other table is the integer in this field
							//and that the table and field containing the name of the distant table was just retrieved.
							
							//first:  that table
							$strRTable=$arrMK[0];
							$strRField=$arrMK[1];
							
							//get the primary key of the $strRTable that applies to this specific row
							//it actually will have probably been determined earlier (to put one of the dropdowns in the right spot)

							//at this point i assume that the pk of $strRTable is what we need
							$strIDFieldName = PKLookup($strDatabase, $strRTable);
							
							$strDistantTable=GenericDBLookup($strDatabase, $strRTable, $strIDFieldName, $arrRelationTemp[$strRTable], $strRField);
							$intDistantPK = PKLookup($strDatabase, $strDistantTable);
							$intNestTable++;
							$strNest.="|" . $intNestTable;
							//just for shits im gonna get all recursive right now...
							//$out.= TableForm($strDatabase,$strDistantTable,$intDistantPK,  $strDefault, $strPHP,  "noheader noextra noform", "zzz|" . $intNestTable / . "|");
							//okay, so i chickened out!  but i could have
							$skip=true;
							$fieldlabel=gracefuldecay($strDistantTable, $fieldlabel);
							//if i have a multi-table relation, chances are i'll want to use the name of the wild table and its pk somewhere later in the tool.
							$futurelabel=$strDistantTable;
							$futureid=$strDefault;
							$fieldform=foreigntablepulldown($strDatabase,$strDistantTable, $intDistantPK, $strDefault, $strFieldNamePrefix .$name, $strFromMulti, true);
							$strFieldLabelLink=qbuild($strPHP, $strDatabase, $strDistantTable, "edit", $intDistantPK, $strDefault). "&" . qpre . "backfield=" . $nameforhelp . "&" . qpre . "behave=closeclickrecycle";
						}
						$arrFK=RelationLookup($strDatabase, $strTable, $name,0);
						if (count($arrFK)>0)
						{
						
							$bwlHypLabel=true;
							//i capture this info in case i need it later for a MultiTable lookup
					 		$arrRelationTemp[$arrFK[0]]=$strDefault;
							$skip=true;
							$count = countrecords($strDatabase,$arrFK[0]);
							//if $count <101 do a dropdown for a foreign key.  otherwise slap down a link to a searchable picker
							//because i'm all cool like that
			 
							if ($count<101)
							{
								$fieldlabel=ReturnNonIDPartOfName($fieldlabel);
								//bleh is necessary because it is by reference, but i have nothing i want to do with it
								$fieldform=foreigntablepulldown($strDatabase,$arrFK[0], $arrFK[1], $strDefault, $strFieldNamePrefix .$name, $bleh, false);
						 
							}
							else
							{
								$skip=false;
								$width =5;
								//$strPrettyLabelField=firstnonidcolumname($strDatabase, $arrFK[0]);
								$strPickerLabel=LabelForID($strDatabase, $arrFK[0], $arrFK[1], $strDefault);
								$strPickerLink= "<input style=\"font-size:9px; border:0px;\" class=\"" . $strThisBgClass . "\" type=\"text\" name=\"" . $strFieldNamePrefix .  qpre . "a|" .  $name . "\" size=\"20\" value=\"" . deescape($strPickerLabel)  . "\">\n";
								$strPickerLink.=" [<a href=\"#\" onclick=\"pickerwindow('". $strDatabase . "','" . $arrFK[0] . "','".  $strFieldNamePrefix . $name ."')\">browse</a>]\n";
								
							}
							//$fieldlabel=$info["foreign"]; //for foreign keys with dropdowns, label them with table name
							//add a link to an editor for the foreign key label because i'm all cool like that
							
							$strFieldLabelLink= qbuild($strPHP, $strDatabase, $arrFK[0], "edit", $arrFK[1], $strDefault) ."&" . qpre . "backfield=" . $nameforhelp . "&" . qpre . "behave=closeclickrecycle";
						 
						}
						if ($bwlHypLabel==true)
						{
							if (!contains($strConfigBehave,"complete"))
							{
								$fieldlabel="<a target=\"secondarytool\" href=\"". $strFieldLabelLink . "\">" . $fieldlabel . "</a>\n";
							}
							else
							{
								$fieldlabel="<a onclick=\"javascript:return(popdetachedwindow('" . $strFieldLabelLink . "','300','500'))\">" . $fieldlabel . "</a>\n";
							}
						}
					}
				elseif  (contains($strType,"text") || $intLen>100  && !(NeedsUpload($name)  || $arrIsFileUpload[$nameforhelp]==1))
				{
					$skip=true;
					$width=gracefuldecay($arrWidth[$nameforhelp],intval($intDefaultWide *.8));
					$height=gracefuldecay($arrHeight[$nameforhelp], intval(strlen($strDefault)/80)+0);
					if (!$arrForce_wysiwg[$nameforhelp] && ($arrForce_no_wysiwg[$nameforhelp] || textarea=="textarea" || !contains($strType,"text") || !class_exists("wysiwygPro")))
					{
						//old way: with textarea.  do this if no wysiwyg installed or the field type isn't actually text
						$fieldform="<textarea name=\"" . $strFieldNamePrefix . $name . "\" cols=\"" . $width . "\" rows=\"" .$height . "\">" .  $strDefault . "</textarea>\n";
					}
					else
					{
						//using wysiwygPro
				 
						$editorcount++;
						if($width<10)
						{
							$width=10;
						}
						if($height<40)
						{
							$height=40;
						}
						//echo $width;
						$editor[$editorcount]= new wysiwygPro();
						$editor[$editorcount]->set_code($strDefault);
						$editor[$editorcount]->set_name($strFieldNamePrefix . $name);
						$fieldform=$editor[$editorcount]->return_editor(gracefuldecay($arrWidth[$nameforhelp],$width *10),gracefuldecay($arrHeight[$nameforhelp],$height*5));
						 
					}
				}
				elseif  ($strType=="date")
				{
					$skip=true;
					$fieldform=datepulldowns($strFieldNamePrefix . $name, $strDefault);
				}
				elseif  ($strType=="tinyint" || $strType=="bit" )
				{
					$skip=true;
					$fieldform=boolcheck($strFieldNamePrefix . $name, $strDefault);
				}
				else 
				{
					$width=intval($width * ($intDefaultWide/90));
					
				}                                    
				
				
				if ($info["Extra"]!="auto_increment"  && !$skip)
				{
			
				
					if($name== $strIDField)
					{
						$bwlSkipHiddenIDvalue=true;	
					}
					$strFormType="text";
					
					if ($name=="password"  || $arrIsPassword[$nameforhelp]==1)
					{
						$strFormType="password";
					}
					
					if($strTableLookingOutWith !="" && (!contains($name, "display_column")  && contains($name, "column") || contains($name, "field")))
					{
						//echo  $strTableLookingOutWith$name . "<br>";
						//echo $strType . "-" . $strTableLookingOutWith . "<br>";
						//echo  $strTableLookingOutWith;
						
						$fieldform=FieldDropdown($strDatabase, $strTableLookingOutWith, $name, $strDefault);
						//$strTableLookingOutWith="";
						//TableDropdown($strDatabase, $strDefault,$strFieldNamePrefix . $name, "BForm","column_name");
					
					}
					elseif (contains($name, "table_name")) //special case for references to tables
					{
						// TableDropdown($strDatabase, $strDefaultTable, $strTableFormName, $strOurFormName='BForm', $strFieldFormName="")
						
						//time to speculate about the field names for the fields that goes with this table dropdown:
						//i have it so my primitive ajax tech can update all the selects automatically with a change of the table dropdown
						$bwlNextColumn=false;
						$associatedColumnName="";
						foreach($descr as $fnom=>$finfo)
						{
							
							$fname=$finfo["Field"];
							//echo $fname . "=<br>";
							//echo $bwlNextColumn . "%<br>";
							if ($fname==$name)
							{
								$bwlNextColumn=true;
							}
							elseif ($bwlNextColumn  && contains($fname, "_table"))
							{
								$bwlNextColumn=false;
								break;
								
							}
							if ($bwlNextColumn  && (!contains($fname, "display_column")  && contains($fname, "column") || contains($fname, "field")))
							{
								//i use plus here because i happen to know it is urlencoded space and i will later split on space on my hidden ajax page
								//and then cycle through all the select dropdowns that need to have their fields updated to reflect the new table
								$associatedColumnName.=$fname . "+" ;
								//$bwlNextColumn=false;
								
							}
							
						}
						$associatedColumnName=RemoveEndCharactersIfMatch($associatedColumnName, "+" );
						//if associatedColumnName doesn't contain anything, then none of the fancy ajax stuff is turned on for this table select
						$fieldform=TableDropdown($strDatabase, $strDefault,$strFieldNamePrefix . $name, "BForm",$associatedColumnName);
						//i use a space here to force a fielddropdown if we have a tabledropdown
						$strTableLookingOutWith=gracefuldecay($strDefault, " ");
					
					}
					else
					{
						 
						$fieldform="";
						$strAboveForm="";
				
						$strValString="value=\"". forinputform($strDefault) . "\"";
						//i determine whether or not we make this form item an upload based entirely on its field name, not its type,
						//as in, does the field name contain either the string "filename" or "banner" 
						//(alter the NeedsUpload function to change this behavior)
						//echo $name . "++ --" . NeedsUpload($name)  . "-- ==" . $arrIsFileUpload[$nameforhelp] . "<br>";
						if (NeedsUpload($name)  || $arrIsFileUpload[$nameforhelp]==1)
						{	
							$path=fieldNameToFolderPath($strFieldNamePrefix . $name, imagepath) . $strDefault;
							$ahtml="";
							$slasha="";
							$strDeleteCheckbox="";
							if (file_exists($path))
							{
								$ahtml="<a href=\"#\" onclick=\"popwindow('" . $path . "', '" . 200 . "', '" . 500 . "','picwindow'); \">";
								$slasha="</a>";
								
							}
							if($strDefault!="")
							{
								$strDeleteCheckbox=" &nbsp;&nbsp;"  . CheckboxInput($strFieldNamePrefix . qpre . "ux|" . $name,"1", false) . "delete";
							}
							$fieldform=   PictureIfThere($path, "100") . "\n";
							$width=intval($width*.5);
							$strFormType="file";
							
					 		$strAboveForm="&nbsp;&nbsp;&nbsp;" . $ahtml . $strDefault . $slasha . $strDeleteCheckbox . "<br>" . "<input type=\"hidden\" name=\"" .$strFieldNamePrefix . $name . "\"   value=\"".  $strDefault . "\">\n";
							
							$name=$strFieldNamePrefix . qpre . "u|" . $name;
							$strValString="";
						}
						$fieldform=$strAboveForm . "<input type=\"" . $strFormType . "\" name=\"" . $strFieldNamePrefix . $name . "\" size=\"" . gracefuldecay($arrWidth[$nameforhelp],$width) . "\" " . deescape($strValString) . ">\n" . $fieldform . $strPickerLink;
					}
				}
			
				elseif ($info["Extra"]=="auto_increment"  && $strValDefault=="")
				{
					$fieldform="&nbsp;&nbsp;&nbsp;<strong>autoincrement:</strong> \n";
				}
				elseif ($info["Extra"]=="auto_increment" && $strValDefault!="")
				{
					$fieldform="&nbsp;&nbsp;&nbsp;<strong>" .  $strValDefault. "</strong> \n";
				}
				
				$out.="<tr class=\"" .  $strThisBgClass . "\">\n";
				$out.="<td valign=\"top\">\n";
				$out.=$fieldlabel . "\n";
				$out.="</td>\n";
				$out.="<td>\n";
				$out.=$fieldform ; 
				
				//help link/text
				if ($bwlSuperAdmin)
				{
				
					$strHelpLink="help('" .$strDatabase . "','" . $strTable  . "','" . $nameforhelp. "')";
				}	
				else
				{
				
					$strHelpLink="return(false)";
				}
				if ($arrValidationType[$nameforhelp]!="")
				{
					//echo HexDump($arrValidationPattern[$nameforhelp]);
					if (!$bwlInvisible)
					{
						$strValidationJS.= $nameforhelp . "~" . $arrValidationType[$nameforhelp] . "~"  . $arrPrettyName[$nameforhelp]  ."~"  . html_entity_decode(decode_entities($arrValidationPattern[$nameforhelp])) . "<validata/>"; 
					}
				}
				if ($arrHelpText[$nameforhelp]!="")
				{
					$out.="<span onmouseover='return escape(\"" . htmlcodify($arrHelpText[$nameforhelp]) . "\")' href=\"" . $strHelpLink . "\">?</span>";
				}
				else if ($bwlSuperAdmin)
				{
					$out.="<span onclick=\"" . $strHelpLink . "\">?!</span>";
				}
				$out.="</td>\n";
				$out.="</tr>\n";
				$out.=$strPseudo;
				if ($strPseudo!="")
				{
					$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
				}
			}
			
	 	}
	}
	if($strValDefault!=$strRowLabel)
	{
		$strRowLabel = $strValDefault . ": " . $strRowLabel;
	}
	$out.="<tr class=\"" . $strClassFirst ."\" style=\"display:none\">\n<td colspan=2>\n";
	$out.="<a href=\"javascript: changetableeditorcollapse()\">";
	$out.=$strRowLabel;
	$out.="</a></td>";
	$out.="</tr>\n";
	$out.="<tr class=\"bgclassline\">\n<td colspan=2 align=\"right\">\n";
	if ($strValDefault!=""  || is_array($arrPK))
	{
			$out.="<input class=\"btn\"
   onmouseover=\"this.className='btn btnhov'\" onmouseout=\"this.className='btn'\" name=\"" . qpre . "submit_clearid\" type=\"submit\" value=\"" . $strOtherButtonText ."\">\n";
	
	}
	$out.="<input class=\"btn\"
   onmouseover=\"this.className='btn btnhov'\" onmouseout=\"this.className='btn'\" name=\"" . qpre . "submit\" type=\"submit\" value=\"" . $strButtonText ."\">\n";
	$out.="</td>\n</tr>\n";
	$out.=HiddenInputs(array("needtoencryptonsave"=>trim($needtoencrypt),"dropdowntextvalue"=>"", "rec"=>$intRecord, "column"=>$strSort, "direction"=>$strDirection, "backfield"=>$strBackfield));
	$out.=HiddenInputs(array("table"=>$strTable,"table"=>$strTable,"db"=>$strDatabase,"mode"=>$strMode,"idfield"=>$strIDField,"behave"=>$strConfigBehave, "ks"=>serialize($arrPK),qpre, $strFieldNamePrefix));

	
	if(!$bwlSkipHiddenIDvalue  && !is_array($arrPK))
	{
		$out.="<input type=\"hidden\" name=\"" . $strFieldNamePrefix . $strIDField . "\"   value=\"".  $strValDefault . "\">\n";
		 
	}                                                                                
	$out.="<input type=\"hidden\" name=\"" . $strFieldNamePrefix . qpre. "oldid\"   value=\"".  $strValDefault . "\">\n";
	if (strpos(" " . $strConfigBehave, "noform")<1)
	{
		$out.="</form>";
	}
	$out=$preout . TableEncapsulate($out, false);
	$strLowerLeftContent="\n<iframe frameborder=\"0\" marginwidth=\"0\" marginheight=\"0\" width=\"340\" height=\"400\" name=\"foreignstuff\" src=\"" . qbuild("tf_foreign.php", $strDatabase, $strTable, "", $strIDField, $strValDefault). "&" . qpre . "behave=noextras&" . qpre . "iddefault=" .  $strValDefault . "\"></iframe>";

	$strLowerRightContent="\n<iframe frameborder=\"0\" marginwidth=\"0\" marginheight=\"0\" width=\"490\" height=\"400\" name=\"secondarytool\" id=\"idsecondarytool\" src=\"tf_message.php\"></iframe>";
	
	//$out.= ForeignKeyReferralLists($strDatabase, $strTable,$strIDField , $strValDefault, $strPHP);
	if (!contains($strConfigBehave, "noextra"))
	{
		if ($strConfigBehave!="noextras"  && !contains($strConfigBehave,"complete"))
		{
			$out=FormEncapsulate($out, $strLowerLeftContent, $strLowerRightContent);
		}
		elseif ($strValDefault!="")
		{
			$out.="<p>\n";
			$out.="<a target=\"_new\" href=\"" . qbuild($strPHP, $strDatabase, $strTable, "edit", $strIDField, $strValDefault) . "\">Edit this " . $strTable . " and <em>its</em> Associated Items</a> starting in a new window.</a>";
			
		}
	}
	$out.="\n<script>\nvalidationconfig='" . $strValidationJS . "';  TextAreaScan();\n</script>\n";
	return $out;
}
 
function FormEncapsulate($strMainFormContent, $strLowerLeftContent, $strLowerRightContent)
//throws an editor into a three-pane editor for real down-and dirty editing possibilities
{
	$out="";
	$out.="<tr>\n<td colspan=\"2\" valign=\"top\">\n";
	$out.=$strMainFormContent;
	$out.="</td>\n";
	$out.="<tr>\n";
	$out.="<td valign=\"top\">\n";
	$out.=$strLowerLeftContent;
	$out.="</td>\n";
	$out.="<td valign=\"top\">";
	$out.=$strLowerRightContent;
	$out.="</td>\n</tr>\n";
	$out.="</tr>\n";
 	$out= TableEncapsulate($out, false);
	return $out;
}


function probableserialized($value)
{
	if(beginswith($value, "a:")   && contains($value, ":{")  &&  contains($value, ";}"))
	{
		return true;
	
	}
	return false;
}
?>