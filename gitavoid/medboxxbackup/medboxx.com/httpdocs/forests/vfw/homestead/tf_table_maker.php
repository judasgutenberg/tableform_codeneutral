<?php
//Judas Gutenberg May-December 2006
//provides a web front end to edit mysql database table definitions
//This code is covered under the GNU General Public License
//info here: http://www.gnu.org/copyleft/gpl.html
//the digest is as follows: you cannot modify this code without
//publishing your source code under the same license
//contact the developer at gus@asecular.com  http://asecular.com



include('tf_functions_core.php');
 
include('tf_core_table_creation.php');
//set_time_limit(90);
echo main();

function main()
	{
		if(!IsExtraSecure())
		{
			die(ExtraSecureFailure());
		}
		//$bwlAdvanced, when false, hides nullability and defaults, though the settings on these items are saved through the edits
		$bwlAdvanced=true;
		//needlessly-complex version:	//$strTypeConfig="Bit|1-TinyInt|1-SmallInt|2-MediumInt|3-Int|4-BigInt|8-Float|4-Double|8-Decimal|18,2-Date|3-DateTime|8-TimeStamp|4-Time|3-Year|2-Char|10-VarChar|50-Binary-VarBinary|100-TinyText|10-Text|8000-MediumText|4000-LongText|20000-TinyBlob|250-MediumBlob|1000-Blob|2000-LongBlob|8000-Enum-Set-Geometry-Point-LineString-Polygon-MultiPoint-MultiLineString-MultiPolygon-GeometryCollection";

		$strTypeConfig="Bit|Bit|1-TinyInt|TinyInt|1-MediumInt|MediumInt|8-Int|Int|11-BigInt|BigInt|8-Double|Double|8-Decimal|Decimal|18,2-Float|Float|12,4-Date|Date|3-Datetime|DateTime|8-Timestamp|TimeStamp|4-Time|Time|3-Char|Char|10-VarChar|VarChar|50-Text|Text|8000";
		//if this tool finds a type not in this configuration in the wild, it will automatically append that to the bottom of the dropdown list
		//that is generated from this list

		//$olderror=error_reporting(0);
		$mode=$_REQUEST[qpre . "mode"];
		$deletefields=$_REQUEST[qpre . "delete"];
		$repositions=$_REQUEST[qpre . "repositions"];
		$strOldTableName=$_REQUEST[qpre . "oldtablename"];
		$strTable=$_REQUEST[qpre . "table"];
		$strDatabase=deMoronizeDB(gracefuldecay($_REQUEST[qpre . "db"],our_db));
		$strConfigBehave=$_REQUEST[qpre . "behave"];
		$strPHP=$_SERVER['PHP_SELF'];
		$feedback="";
		$out="";
		//echo $repositions . "==<br>";
		if ($rec=="")
		{
			$rec=0;
		}
		//echo $id . " " .$idfield ;
		$out=LoginDecisions($strDatabase,  $strPHP, $strUser, false);
		if ($strUser!="")
		{
		
			$intAdminType= AdministerType($strDatabase, $strTable, $strUser);
			if ($deletefields!="")
			{
				//echo "##". $deletefields;
				EnsureNonRemote();
				deletefields($strDatabase, $strTable, $deletefields);
			}
			if ($intAdminType>1)
				{
				 	if ($mode=="save")
					{
						EnsureNonRemote();
						$possibleerrors =  AlterTable($strDatabase, $strTable,  $strOldTableName, $strTypeConfig);
					}
	 
					
					$out.= TableMaker($strDatabase, $strTable, $strTypeConfig, $bwlAdvanced);
					$out.=RelatedTables($strDatabase, $strTable);
					$feedback =JoinList("<br/>\n",$feedback ,$possibleerrors);
					
				}
		}
		$out.=userfeedback($feedback);
		$out =  PageHeader($strDatabase . IfAThenB($strTable, " : ") . $strTable . " : Table Maker", $strConfigBehave, "", true, false, "", $strDatabase) .
			"<script src=\"tf_tablemaker.js\"><!-- --></script>" . 
		$out . PageFooter();
		
		return $out;
	}

	
	
function TableMaker($strDatabase, $strTable, $strTypeConfig, $bwlAdvanced=false)
{

	$sql=conDB();
	$out="";
	$preout="";
	$length=50;
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strOtherBgClass="bgclassother";
	$strLineClass="bgclassline";
	$strThisBgClass=$strClassFirst;
	$strPHP=$_SERVER['PHP_SELF'];
	$strStyle ="none";

	if ( $strTable=="")
	{
		$strStyle="block";
	}
	
	
	if($strTable=="")
	{
		$preout.= adminbreadcrumb(false,  $strDatabase, "tf.php?" . qpre . "db=" . $strDatabase,  "New Table");
	}
	else
	{
		$preout.= adminbreadcrumb(false,  $strDatabase, "tf.php?" . qpre . "db=" . $strDatabase,  "altering table definition for " . $strTable, "");
	}
	//$out.= AdminNav(true);
	$preout.="<form name=\"BForm\" method=\"post\" action=\"" . $strPHP . "\" onSubmit=\"  \">\n";

	if($strTable=="")
	{
		$strTableNameLabel="New Table Name";
	}
	else
	{
		$strTableNameLabel="Table Name";
	}
	$out.="<tr class=\"bgclassother\"><td colspan=\"11\"    align=\"left\">" .  $strTableNameLabel . ": <input type=\"text\" size=\"22\" value=\"" .  $strTable . "\" name=\"" . qpre . "table\" />\n";
	if ($strTable!="")
	{
		$count = countrecords($strDatabase , $strTable );
		$out.="[<a href=\"" .  qbuild("tf.php", $strDatabase, $strTable, "view", "", "")  . "\">view " . $count ." " . PluralizeIfNecessary("record", $count) . " of existing table data</a>]";
		$out.=" [<a href=\"" .  qbuild("tf_dbtools.php", $strDatabase, $strTable, "entersql", "", "") ."&" . qpre .  "actscript=show+create+table+"  . $strDatabase . "." . $strTable  . "\">view SQL table definition</a>]";
		$out.= " [<a href=\"tf_table_maker.php\">new table</a>]";
	}
	else
	{
		$out.= " [<a href=\"" . qbuild("tf_import.php", $strDatabase, $strTable, "", "", "") . "\">create table from imported data</a>]";
	
	}
	$out.="\n</td>\n</tr>\n";
	if($bwlAdvanced)
	{
		$out.=htmlrow("bgclassline", "select", "column", "type", "size","default", "nullable","&nbsp;PK", "&nbsp;auto++", "&nbsp;more","&nbsp;relate","&nbsp;+field" );
	}
	else
	{
		$out.=htmlrow("bgclassline", "select", "column", "type", "size","", "","&nbsp;PK", "&nbsp;auto++", "&nbsp;more" ,"&nbsp;relate","&nbsp;+field" );
	}
	
	$outcount=0;
	$strUpDownArrows=UpDownArrows($outcount);
	$strStyleAdvanced="display:none";
	if ($bwlAdvanced)
	{
		$strStyleAdvanced="";
	}

	$out.=FieldEditLine($strDatabase, $strTable,  $outcount,"","","", "", true,false,  false, "", "",  "", "", "", "", "", "", "", "", "", "","", "", "", $strTypeConfig,$strUpDownArrows,"hideallbutlast", $strStyleAdvanced,   $autoinccheckboxstyle, $strStyleAdvanced, "", false);
	
	if ($strTable!="")
	{
		$descr=TableExplain($strDatabase, $strTable); 
		$outcount=1;
		foreach ($descr as  $info)
		{

 			$bwlIsPK=false;
			$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
			$strPickerLink="";
			$skip=false;
			$fieldlabel=$info["Field"];
			$name=$fieldlabel;
			
			//get stuff from   tfpre column_info
			$whereclause=" table_name='" . $strTable . "' AND column_name='" . $fieldlabel . "'";
			$strSQL="SELECT * FROM " . $strDatabase . "." .  tfpre . "column_info WHERE " . $whereclause;
			//echo $strSQL;
			$rs = $sql->query($strSQL);
			$height="";
			$width="";
			$password="";
			$fileupload="";
			$datecreated="";
			$datemodified="";
			$invisible="";
			$force_wysiwg="";
			$force_no_wysiwg="";
			$force_text_input="";
			$force_binary="";
			$friendly="";
			$validation_pattern_id="";
			$validation_type_id="";
			$helptext="";
			if(count($rs)>0)
			{
				//echo $r["datecreated"];
				$r=$rs[0];
				$helptext=$r["help_text"];
				$validation_type_id=$r["validation_type_id"];
				$validation_pattern_id=$r["validation_pattern_id"];
				$friendly=$r["label"];
				$invisible=$r["invisible"];
				$force_wysiwg=$r["force_wysiwg"];
				$force_no_wysiwg=$r["force_no_wysiwg"];
				$force_text_input=$r["force_text_input"];
				$force_binary=$r["force_binary"];
				$fileupload=$r["fileupload"];
				$datecreated=$r["datecreated"];
				$datemodified=$r["datemodified"];
				$password=$r["password"];
				$width=$r["width"];
				$height=$r["height"];
			}
				//echo sql_error();
			$arrRelation=RelationLookup($strDatabase, $strTable, $name);
			$rid=$arrRelation[7];
			$bwlOutgoingRelationExists=is_array($arrRelation);
			$strType=TypeParse($info["Type"], 0);
			$intLen=(TypeParse($info["Type"], 1));
			$extra=$info["Extra"];
			$default=$info["Default"];
			$key=$info["Key"];
			$bwlPK=false;
			$bwlAI=false;
			$bwlNull=false;
			$autoinccheckboxstyle="display:none";
			if ($key=="PRI")
			{
				$bwlPK=true;
				if(contains($strType, "int"))
				{
					$autoinccheckboxstyle="";
					$bwlIsPK=true;
				}
			}
			
			if ($extra=="auto_increment")
			{
				$bwlAI=true;
			
			}
			//echo $info["Null"] . "<br>";
			if ($info["Null"]=="YES")
			{
				$bwlNull=true;
			
			}

				
			$strUpDownArrows=UpDownArrows($outcount);
			$out.=FieldEditLine($strDatabase, $strTable,  $outcount,$name,$strType,$intLen, $default, $bwlNull,$bwlPK,  $bwlAI,  $friendly, $helptext, $validation_type_id,$validation_pattern_id, $invisible, $force_wysiwg, $force_no_wysiwg, $force_binary, $force_text_input, $fileupload, $datecreated, $datemodified, $password, $width, $height, $strTypeConfig, $strUpDownArrows, $strThisBgClass, $strStyleAdvanced,   $autoinccheckboxstyle, $strStyleAdvanced, $rid, $bwlIsPK);
				
			$outcount++;
			
		}
	
	}
	else
	{

	
	
	}
	$out.="<tr class=\"bgclassline\" ><td colspan=\"5\">" .  SelectedTools() . "</td><td colspan=\"5\"  align=\"right\"><input type=\"submit\" value=\"Save Table\" name=\"" . qpre . "submit\" /></td></tr>\n";
	$out.=HiddenInputs(array("mode"=>"save",  "db" =>$strDatabase, "fieldcount"=>$outcount, "delete"=>"",  "repositions"=>"", "oldtablename"=>$strTable));
	$out=$preout . TableEncapsulate($out, false);
	$out.="</form>\n";
	return $out;
}

function FieldEditLine($strDatabase, $strTable, $outcount,$name,$strType,$intLen, $default, $bwlNull,$bwlPK,  $bwlAI, $friendly, $helptext,$validation_type_id,$validation_pattern_id, $invisible ,  $force_wysiwg , $force_no_wysiwg ,   $force_binary , $force_text_input , $fileupload ,  $datecreated , $datemodified , $password , $width , $height, $strTypeConfig, $strUpDownArrows, $strThisBgClass, $strStyleAdvanced,   $autoinccheckboxstyle, $strStyleAdvanced, $intRelationID="", $bwlIsPK=false)
{
	$relationEditURL="tf.php?" . qpre . "db=" . $strDatabase . "&" . qpre . "table=" . tfpre . "relation&" . qpre . "mode=edit&" . qpre . "idfield=relation_id&column_name=" . $name . "&table_name=" . $strTable . "&relation_type_id=0";
	if($intRelationID!="")
	{
		$strOutgoingRelationshipString="<b>=&gt;</b>";
		$relationEditURL="tf.php?" . qpre . "db=" . $strDatabase . "&" . qpre . "table=" . tfpre . "relation&" . qpre . "mode=edit&" . qpre . "idfield=relation_id&relation_id=" . $intRelationID;
	}
	else if ($bwlIsPK)
	{
		$relationEditURL="tf.php?" . qpre . "db=" . $strDatabase . "&" . qpre . "table=" . tfpre . "relation&" . qpre . "mode=edit&" . qpre . "idfield=relation_id&f_column_name=" . $name . "&f_table_name=" . $strTable . "&relation_type_id=0";
		$strOutgoingRelationshipString="<b>&lt;=</b>";
	}
	else
	{
		
		$strOutgoingRelationshipString="-&gt;";
	}
	//echo $helptext . " -- " . $friendly;
	//still need to deal with $validation_type_id, $invisible
	
	$out=htmlrow($strThisBgClass, 
		$strUpDownArrows, 
		TextInput(qpre . "field-" . $outcount , $name, 22), 
		TypePulldown($strType,  qpre .  "type-" . $outcount, $strTypeConfig), 
		TextInput(qpre . "length-" . $outcount , $intLen, 6), 
		TextInput(qpre . "default-" . $outcount , $default, 6,"","", $strStyleAdvanced), 
		CheckboxInput(qpre . "nullable-" . $outcount , "1", $bwlNull, "",  $strStyleAdvanced), 
		CheckboxInput(qpre . "prikey-" . $outcount , "1", $bwlPK,  "pksingle(this)"), 
		CheckboxInput(qpre . "autoinc-" . $outcount , "1", $bwlAI, "autoincsingle(this)", $autoinccheckboxstyle),
		"<a id=\"idmoreadd-" .  $outcount .  "\" name=\"moreadd-" .  $outcount .  "\"  onclick=\"more(this)\">+</a>",
		"<a id=\"idrellink-" .  $outcount .   "\" href=\"" . $relationEditURL . "\">"  . $strOutgoingRelationshipString . "</a>",
		"<a id=\"idaddfield-" .  $outcount .  "\" href=\"javascript: addfield('addfield-" .intval($outcount ). "' )\">here</a>". HiddenInputs(array("old-" . $outcount =>$name))
		
			);
	$out.="\n<tr id=\"idmorerow-" .  $outcount . "\"  name=\"morerow-" .  $outcount . "\" class=\"" . $strThisBgClass . "\" style=\"display:none\">";
	$out.="<td>&nbsp;</td>";

	$out.="<td valign=\"top\" colspan=\"1\">display name<br>" . TextInput(qpre . "friendly-" . $outcount ,  $friendly, 22) . "</td>";
 
	$out.="<td colspan=\"8\">help text<br><textarea id=\"id" . qpre . "helptext-" .  $outcount . "\" name=\"" . qpre . "helptext-" .  $outcount . "\" rows=\"3\" cols=\"42\">" .  $helptext . "</textarea>";
	$out.="<br/>";
	$out.="Validation Type: " .  foreigntablepulldown($strDatabase, tfpre . "validation_type","validation_type_id",$validation_type_id, qpre . "validationtypeid-" .  $outcount, $namereturn, false, "type_name");
	$out.="<br/>";
	$out.="Validation Pattern: " .  foreigntablepulldown($strDatabase,  tfpre . "validation_pattern", "validation_pattern_id" , $validation_pattern_id, qpre . "validationpatternid-" . $outcount, $namereturn, false, "name");
	$out.="<br/>";
	$strStyle="position:absolute;  left: 330px;";
	$out.="Is Invisible " .   boolcheck(qpre . "invisible-" . $outcount , $invisible, false, false, $strStyle);
	$out.="<br/>";
	// $force_wysiwg, $force_no_wysiwg, 
	$out.="Force WYSWG Editor " .   boolcheck(qpre . "force_wysiwg-" . $outcount , $force_wysiwg, false, false, $strStyle);
	$out.="<br/>";
	$out.="Force Simple Editor  " .   boolcheck(qpre . "force_no_wysiwg-" . $outcount , $force_no_wysiwg, false, false, $strStyle);
	$out.="<br/>";
	$out.="Force Binary " .   boolcheck(qpre . "force_binary-" . $outcount , $force_binary, false, false, $strStyle);
	$out.="<br/>";
	$out.="Force Integer  " .   boolcheck(qpre . "force_text_input-" . $outcount , $force_text_input, false, false, $strStyle);
	$out.="<br/>";
	$out.="Is a File Upload " .   boolcheck(qpre . "fileupload-" . $outcount , $fileupload, false, false, $strStyle);
	$out.="<br/>";
	
	$out.="Is a Created Date" .   boolcheck(qpre . "datecreated-" . $outcount , $datecreated, false, false, $strStyle);
	$out.="<br/>";
	
	$out.="Is a Modified Date " .   boolcheck(qpre . "datemodified-" . $outcount , $datemodified, false, false, $strStyle);
	$out.="<br/>";
	
	$out.="Is a Password " .   boolcheck(qpre . "password-" . $outcount , $password, false, false, $strStyle);
	
	$out.="<br/><br/>";
	$out.="width: " . TextInput(qpre . "width-" . $outcount , $width, 3,"","", "");
	$out.="height: " . TextInput(qpre . "height-" . $outcount , $height, 3,"","","");
	$out.="</td>";
	$out.="</tr>\n";
	return $out;
}
	
function SelectedTools()
{
	$out="move selected: ";
	$out.="<a href=\"javascript:TRaction('up')\">up</a>";
	$out.=" | ";
	$out.="<a href=\"javascript:TRaction('down')\">down</a>";
	$out.=" | ";
	$out.="<a href=\"javascript:TRaction('delete')\">delete selected</a>";
 	return $out;
}
	
	
function UpDownArrows($outcount)
{
	$strUpDownArrows="<input id=\"idswapfieldd-" . $outcount . "\" type=\"radio\" name=\"swapfieldd-" . $outcount . "\" onClick=\"trselect(this.id)\">\n";
	return ($strUpDownArrows);
}



function TypePulldown($strDefault, $strQSname, $strConfig)
{
	$out=GenericDataPulldown(strtolower($strConfig), 0, 1,  $strQSname, $strDefault, "", "", "");
	return $out;
}


function AlterTable($strDatabase, $strTable,  $strOldTableName,  $strTypeConfig)
{
	$sql=conDB();
	$out="";
	$errors="";
 	$bwlSkipPrimaryAdd=false;
	$bwltf_column_info_exists=false;
	//$strOutrageousDefaultFieldName is the default name for the only field in cases where there are no known fields yet.  usually dropped.
	$strOutrageousDefaultFieldName="xxxzzzxxx";
	$strPrevious="";
	$strOldPK=PKLookup($strDatabase, $strTable);
	$count=intval($_REQUEST[qpre . "fieldcount"]);
	//echo $strOldTableName . " " .$strTable ;
	$newtable=false;
	if ($strTable!="" && $strOldTableName=="") // a new table
	{
		$strSQL="CREATE TABLE " .  $strDatabase  . "." . $strTable . " (" . $strOutrageousDefaultFieldName . " varchar(12))";
		if(CanChange())
		{
			$r = $sql->query($strSQL);
		}
		else
		{
			$errors.=  "Database is read-only.<br/>";
		}
		$errors.=IfAThenB(sql_error(), "<b>failed to create placeholder table:</b>" .  sql_error() . "<br>". $strSQL . "<br><br>");
		$newtable=true;
	}
	elseif ($strOldTableName!=$strTable  && $strTable!="")//altering a table name
	{
	
		$strSQL="ALTER TABLE " . $strDatabase . "." .$strOldTableName . " RENAME TO " . $strDatabase . "." .$strTable;
		//echo $strSQL;
		$bwlSkipPrimaryAdd=true;
		$r = $sql->query($strSQL);
		$errors.=IfAThenB(sql_error(), "<b>failed to rename placeholder table:</b>" .  sql_error() . "<br>". $strSQL . "<br><br>");
	}

	for($i=0; $i<=$count; $i++)
	{
		$thisField=$_REQUEST[qpre . "field-" . $i];
		
		//handle stuff that needs to go into tf_column_info\
		$helptext=$_REQUEST[qpre . "helptext-" . $i];
		$validation_type_id=$_REQUEST[qpre . "validationtypeid-" . $i];
		$validation_pattern_id=$_REQUEST[qpre . "validationpatternid-" . $i];
		$friendly=$_REQUEST[qpre . "friendly-" . $i];
		$invisible=$_REQUEST[qpre . "invisible-" . $i];
		$force_no_wysiwg=$_REQUEST[qpre . "force_no_wysiwg-" . $i];
		$force_wysiwg=$_REQUEST[qpre . "force_wysiwg-" . $i];
		$force_text_input=$_REQUEST[qpre . "force_text_input-" . $i];
		$force_binary=$_REQUEST[qpre . "force_binary-" . $i];
		$fileupload=$_REQUEST[qpre . "fileupload-" . $i];
		$datecreated=$_REQUEST[qpre . "datecreated-" . $i];
		$datemodified=$_REQUEST[qpre . "datemodified-" . $i];
		$password=$_REQUEST[qpre . "password-" . $i];
		$width=$_REQUEST[qpre . "width-" . $i];
		$height=$_REQUEST[qpre . "height-" . $i];
		if ($width==0)
		{
			$width="";
		}
		if ($height==0)
		{
			$height="";
		}
		//echo "<br>__" . $invisible . "----<br>";
		$whereclause=" table_name='" . AppropriateSQLName($strTable) . "' AND column_name='" . AppropriateSQLName($thisField) . "'";
		//this code may need to be changed!!!!
		if($helptext!=""  || $friendly!="" || $validation_type_id!=""  || $invisible!="" || $force_no_wysiwg!="" || $force_wysiwg!=""  || $force_no_bianry!="" || $force_binary!="" || $fileupload!="" || $datecreated!="" || $datemodified!="" || $password!="" || $validation_pattern_id!="" || $width!=""  || $height!="")
		{
			
			
		 	if (!$bwltf_column_info_exists)
			{
				MakeTableIfNotThere($strDatabase, tfpre . "column_info", "MakeColumnInfoTables");
			
			}
			
			$strSQL="SELECT column_info_id FROM " . $strDatabase . "." .  tfpre . "column_info WHERE " . $whereclause;
			$r = $sql->query($strSQL);
			$errors.=IfAThenB(sql_error(), "<b>failed to obtain column info:</b>" .  sql_error() . "<br>". $strSQL . "<br><br>");
			$strPostExtraSQL= $strDatabase . "." .  tfpre . "column_info SET ";
  			$strPostExtraSQLValues=IfAThenB($help_text,",help_text='" . $help_text . "'") . 
			IfAThenB($label,",label='" . $label . "'") . 
			IfAThenB($validation_type_id,",validation_type_id='" . $validation_type_id . "'") . 
			IfAThenB($validation_pattern_id,",validation_pattern_id='" . $validation_pattern_id . "'") . 
			IfAThenB($password,",password='" . $password . "'") . 
			IfAThenB($fileupload,",fileupload='" . $fileupload . "'") . 
			IfAThenB($datecreated,",datecreated='" . $datecreated . "'") .
			IfAThenB($datemodified,",datemodified='" . $datemodified . "'") .
			IfAThenB($invisible,",invisible='" . $invisible . "'") . 
			IfAThenB($force_no_wysiwg,",force_no_wysiwg='" . $force_no_wysiwg . "'") . 
			IfAThenB($force_wysiwg,",force_wysiwg='" . $force_wysiwg . "'") . 
			IfAThenB($force_no_wysiwg,",force_text_input='" . $force_text_input . "'") . 
			IfAThenB($force_binary,",force_binary='" . $force_binary . "'") . 
			IfAThenB($width,",width='" . $width . "'") . 
			IfAThenB($height,",height='" . $height . "'");
			$strPostExtraSQLValues=RemoveFirstCharacterIfMatch($strPostExtraSQLValues, ",");
			$strPostExtraSQL.=$strPostExtraSQLValues;
			//echo $strPostExtraSQL;
			if (count($r)>0)
			{
				//update tf_column_info, not insert
				$strSQL="UPDATE " . $strPostExtraSQL .  " WHERE " . $whereclause;
 
			}
			else
			{	
				$strSQL="INSERT " . $strPostExtraSQL .  ", " . str_replace("' AND ", "',", $whereclause);
			
			}
			//echo $strSQL . "<br>";
			if(CanChange())
			{
				$r = $sql->query($strSQL);
			}
			else
			{
				$errors.=  "Database is read-only.<br/>";
			}
 
			$errors.=IfAThenB(sql_error(), "<b>failed to alter column_info table:</b>" .  sql_error() . "<br>". $strSQL . "<br/><br/>");
			//echo sql_error() . "<br>";
		
		}
		$oldField=$_REQUEST[qpre . "old-" . $i];
		$strSQLPK="";
		$strSQLDesc="";
		$thisType=gracefuldecay($_REQUEST[qpre . "type-" . $i], "varchar");
		//echo $thisType .   "----------" . $i  . "<br>";
		if ($_REQUEST[qpre . "prikey-" . $i]=="1"  && $thisField!="")
		{
			//echo "PRIKEY!!!<br>";
			$strSQLPK=" PRIMARY KEY";
			$strPrimaryKeyList.=$thisField . ",";
			//echo $strPrimaryKeyList. "<br>";
			//most of this code here only does noticeable stuff if the primary key is changed, which shouldn't happen very often
			//i'd originally guessed that the old primary key was of type int(8) because i couldn't be bothered to perform the lookup
			//but now i'm actually looking it up because there are plenty of cases outside the tf world where the PK is not even numeric
			//also: i have to turn off auto_increment to change the primary key
			$oldPKtype=GetFieldType($strDatabase, $strTable, $strOldPK);
			if($strOldPK!="")
			{
				if(!contains($strOldPK, " "))
				{
					$strSQL="ALTER TABLE " . $strDatabase . "." . $strTable . " CHANGE " . $strOldPK . " " . $strOldPK . " " . $oldPKtype . "  ";
					//echo $strSQL . "<br>\n";
					if(CanChange())
					{
						$r = $sql->query($strSQL);
					}
					else
					{
						$errors.=  "Database is read-only.<br/>";
					}
					$errors.=IfAThenB(sql_error(), "<b>failed to change primary key name:</b>" .  sql_error() . "<br>" . $strSQL . "<br><br>");
				}
				
			}
			//then i have to drop the old primary key
			//echo $bwlNoPrimaryKeyDropped . "-<br>";

			
		}
		//echo "Autoinc" . $_REQUEST[qpre . "autoinc-" . $i] . " --- " . $i . " --- " . $thisField . "<br>";
		if ($_REQUEST[qpre . "autoinc-" . $i]=="1" && $thisField!="")
		{
			//echo "AUTOINC!!!<br>";
 
			$strSQLDesc="";
			//$strSQLDesc=" PRIMARY KEY NOT NULL AUTO_INCREMENT ";
			$strPKSupplemental=" MODIFY " . $thisField . " " . $thisType ." NOT NULL AUTO_INCREMENT, ";

		}
		elseif ($_REQUEST[qpre . "nullable-" . $i]=="1" && $thisField!="")
		{
			$strSQLDesc=" NULL ";
		
		}
		else
		{
			$strSQLDesc=" NOT NULL ";
		
		}
		$thisdefault=$_REQUEST[qpre . "default-" . $i];
		if ($thisdefault!="" && $thisField!=""  && !contains($strSQLDesc, "PRIMARY"))
		{
			$strSQLDesc.=" DEFAULT '" . 	$thisdefault . "'";
		}
		
		$strDefaultLength=data($thisType,0, 2, strtolower($strTypeConfig));
		//echo $strTypeConfig . "<br>";
		//echo $strDefaultLength . "<br>";
		$thisLength=gracefuldecay($_REQUEST[qpre . "length-" . $i], $strDefaultLength);
		
		$strSQL="";

		if ($thisField!="")
		{
			//echo "thisfieldindication<br>";
			if ($oldField!="")
			{
				//echo "oldfieldindication<br>";
				if ($thisField!="")
				{
					//so wrong!! need to figure this shit out!
					//first need to digest repositions!!
					//echo  $i . "**" . $thisField . "---" . $_REQUEST[qpre . "repositions"] . "===" . $oldField . "<br>";
					$possiblelocation=gracefuldecay(FindFinalPosition($_REQUEST[qpre . "repositions"], $oldField),FindFinalPosition($_REQUEST[qpre . "repositions"], $thisField)) ;
					//echo $possiblelocation . "---";
					if ($possiblelocation=="*")
					{
						if ($oldField !=$thisField)
						{
							$strSQL="ALTER TABLE " . $strDatabase . "." .$strTable . "   CHANGE " . $oldField . " " . AppropriateSQLName($thisField) . " " . TypeSQL($thisType, $thisLength) . $strSQLDesc;
							 movecolumn($strDatabase, $strTable,$thisField, $thisType , $thisLength ,"");
						}
						else
						{
							//$strSQL="ALTER TABLE " . $strDatabase . "." .$strTable . "   CHANGE " . $thisField . " " . $thisType . "(" . $thisLength . ")";
							 movecolumn($strDatabase, $strTable,$thisField, $thisType ,$thisLength , "");
						}
					}
					elseif ($possiblelocation!="")
					{
						if ($oldField !=$thisField)
						{
							$strSQL="ALTER TABLE " . $strDatabase . "." .$strTable . "   CHANGE " . $oldField . " " . AppropriateSQLName($thisField) . " " . TypeSQL($thisType, $thisLength) . $strSQLDesc ;
							 movecolumn($strDatabase, $strTable,$thisField, $thisType ,$thisLength ,  $possiblelocation);
						}
						else
						{
							
							//$strSQL="ALTER TABLE " . $strDatabase . "." .$strTable . "   CHANGE " . $thisField . " " . $thisType . "(" . $thisLength . ")";
							 movecolumn($strDatabase, $strTable,$thisField,  $thisType , $thisLength , $possiblelocation);
						}			
					}
					else
					{
					
						$strSQL="ALTER TABLE " . $strDatabase  . "." . $strTable . "  CHANGE " . $oldField . " " . AppropriateSQLName($thisField) . " " . TypeSQL($thisType, $thisLength) . $strSQLDesc;
					}
				}
			}
			else
			{
				if ($strPrevious!="") 
				{
					$strSQL="ALTER TABLE " . $strDatabase  . "." . $strTable . "  ADD  " . AppropriateSQLName($thisField) .  " "   . TypeSQL($thisType, $thisLength)  . $strSQLDesc  ." AFTER " . $strPrevious ;
				}
				else
				{
					$strSQL="ALTER TABLE " . $strDatabase  . "." . $strTable . "  ADD "  . AppropriateSQLName($thisField) . " " . TypeSQL($thisType, $thisLength) . $strSQLDesc;
				}
			
			}
		}
		$strPrevious=$thisField;
		if ($strSQL!="")
		{
			//echo $strSQL . "<br>";
			if(CanChange())
			{
				$r = $sql->query($strSQL);
			}
			else
			{
				$errors.=  "Database is read-only.<br/>";
			}
			$errors.=IfAThenB(sql_error(), "<b>failed to alter table:</b>" .  sql_error() . "<br>". $strSQL . "<br><br>");
			//echo sql_error() . "<br>";

		}
		
	}
	if ($newtable)
	{
		$strSQL="ALTER TABLE  " . $strDatabase  . "." . $strTable . "  DROP COLUMN " . $strOutrageousDefaultFieldName;
		//echo $strSQL . "<br>";
		if(CanChange())
		{
			$r = $sql->query($strSQL);
		}
		else
		{
			$errors.=  "Database is read-only.<br/>";
		}
		$failedtoaltererror="";
		$failedtoaltererror=IfAThenB(sql_error(), "<b>failed to alter table:</b>" .  sql_error() . "<br>". $strSQL . "<br><br>");
		//echo "-" . $failedtoaltererror . "-" ;
		$errors.=$failedtoaltererror;
		//echo "++";
		if ($failedtoaltererror!="")
		{
			//echo "$$vv";
			//if we didn't give the new table any fields yet then default the name of the only column to TABLENAME_id
			$strSQL="ALTER TABLE " . $strDatabase  . "." . $strTable . "  CHANGE " . $strOutrageousDefaultFieldName . " " . $strTable . "_id int   NOT NULL AUTO_INCREMENT PRIMARY KEY;";
			if(CanChange())
			{
				$r = $sql->query($strSQL);
			}
			else
			{
				$errors.=  "Database is read-only.<br/>";
			}
			$errors.=IfAThenB(sql_error(), "<b>failed to assign a default primary key:</b>" .  sql_error() . "<br>". $strSQL . "<br><br>");
		}
	}
	
	if($strOldPK!="")
	{
		$strSQL="ALTER TABLE " . $strDatabase . "." .$strTable . " DROP PRIMARY KEY ";
		//echo $strSQL . "<br>\n";
		if(CanChange())
		{
			$r = $sql->query($strSQL);
		}
		else
		{
			$errors.=  "Database is read-only.<br/>";
		};
		$errors.=IfAThenB(sql_error(), "<b>failed to drop primary key:</b>" .  sql_error() . "<br>". $strSQL . "<br><br>");

	}
	//echo  "+" . $strPrimaryKeyList . "-" . $bwlSkipPrimaryAdd . "+";
	if($strPrimaryKeyList!=""  && !$bwlSkipPrimaryAdd)
	{
		//echo "$$";
		$strPrimaryKeyList=RemoveEndCharactersIfMatch($strPrimaryKeyList, ",");
		//if($strPKSupplemental!="")
		//{
			$strSQL="ALTER TABLE " . $strDatabase  . "." . $strTable . $strPKSupplemental . " ADD PRIMARY KEY (" . $strPrimaryKeyList . ") ";
		//}
		//$strSQL="ALTER TABLE " . $strDatabase  . "." . $strTable . " ADD PRIMARY KEY (" . $strPrimaryKeyList . ") ";
		if(CanChange())
		{
			$r = $sql->query($strSQL);
		}
		else
		{
			$errors.=  "Database is read-only.<br/>";
		}
		$errors.=IfAThenB(sql_error(), "<b>failed to add primary key:</b>" .  sql_error() . "<br>". $strSQL . "<br><br>");
	}
	else if($bwlSkipPrimaryAdd  && $strPKSupplemental !="")
	{
		//echo "=" . $strPKSupplemental;
		$strSQL=RemoveEndCharactersIfMatch("ALTER TABLE  " . $strDatabase  . "." . $strTable .  $strPKSupplemental, " ");
		$strSQL=RemoveEndCharactersIfMatch( $strSQL, ",");
		if(CanChange())
		{
			$r = $sql->query($strSQL);
		}
		else
		{
			$errors.=  "Database is read-only.<br/>";
		}
		$errors.=IfAThenB(sql_error(), "<b>failed to make PK autoincrement on renamed table:</b>" .  sql_error() . "<br>". $strSQL . "<br><br>");
	}
	

	return $errors;

}

function deletefields($strDatabase, $strTable, $deletefields)
{
	$sql=conDB();
	$arrThis=explode("|", $deletefields);
	for ($i=0; $i<count($arrThis); $i++)
	{
		$strThisField=$arrThis[$i];
		if ($strThisField!="")
		{
		
			$strSQL="ALTER TABLE  " . $strDatabase  . "." . $strTable . "  DROP COLUMN " . AppropriateSQLName($strThisField);
		
		}
		if ($strSQL!="")
		{
			//echo $strSQL . "<br>";
			if(CanChange())
			{
				$r = $sql->query($strSQL);
			}
			else
			{
				$errors.=  "Database is read-only.<br/>";
			};
		}
	}
	return true;
}


function movecolumn($strDatabase, $strTable,$this, $strType, $strSize, $after)
//moves a column in the database
{
	$sql=conDB();

 	if($after!="")
	{
		$strSQL="ALTER TABLE " . $strDatabase . "." .$strTable . "   MODIFY COLUMN " . AppropriateSQLName($this) . "  " . TypeSQL($strType, $strSize) . " AFTER " . $after;
	}
	else
 	{
		$strSQL="ALTER TABLE " . $strDatabase . "." .$strTable . "   MODIFY COLUMN " . AppropriateSQLName($this) . " " .  TypeSQL($strType, $strSize) ." FIRST";
	}
	//echo $strSQL . "<br>";
	if(CanChange())
	{
		$r = $sql->query($strSQL);
	}
	else
	{
		$errors.=  "Database is read-only.<br/>";
	}
	return $errors;
}


function GivenOneReturnTheOther($strConfig, $strThis)
//from a double-delimited array (in this case, space-pipe), return the other in the pipe-delimited pair if one matches
{
	$arrConfig =explode(" ", $strConfig);
	for ($i=0; $i<count($arrConfig); $i++)
	{
		$arrThis=explode(" ", $arrConfig[$i]);
		if ($arrThis[0]==$strThis)
		{
		
			return $arrThis[1];
		}
		if ($arrThis[1]==$strThis)
		{
		
			return $arrThis[0];
		}
	
	}
}

function FindFinalPosition($strConfig, $strThis)
//scan through the config string starting at the end and return the right side of the pipe given the value left on the left of the pipe matches strThis.
{
	$arrConfig =explode(" ", $strConfig);
	for ($i=count($arrConfig)-1; $i>-1; $i--)
	{
		$arrThis=explode("|", $arrConfig[$i]);
		//echo $arrThis[0] . " " . $strThis . "<br>";
		if ($arrThis[0]==$strThis)
		{
			//echo "!";
			//echo $arrThis[1] . "----<br>";
			return $arrThis[1];
		}
	}
}

function RelatedTables($strDatabase, $strTable)
{
	$sql=conDB();
	$out="";
	$out_f="";
	$out_p="";
	$cols=0;
	$strSQL="SELECT * FROM " . $strDatabase . "." . tfpre . "relation WHERE table_name='" . $strTable . "'";
	$records = $sql->query($strSQL);
	//echo sql_error();
	foreach($records as $record)
	{
		$f_table_name=$record["f_table_name"];
		$out_f.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"tf_table_maker.php?" . qpre . "db=" . $strDatabase . "&" . qpre . "table=" . $f_table_name . "\">" . $f_table_name . "</a><br/>";
	}
	$strSQL="SELECT * FROM " . $strDatabase . "." . tfpre . "relation WHERE f_table_name='" . $strTable . "'";
	
	$records = $sql->query($strSQL);
	//echo sql_error();
	foreach($records as $record)
	{
		$table_name=$record["table_name"];
		$out_p.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"tf_table_maker.php?" . qpre . "db=" . $strDatabase . "&" . qpre . "table=" . $table_name . "\">" . $table_name . "</a><br/>";
	}
	if ($out_f!="")
	{
		$out.="<td valign=\"top\">\n";
		$out.=" &nbsp;&nbsp;<div class=\"subtleheading\">Foreign Tables</div> \n";
		$out.=$out_f;
		$out.="</td>\n";
		$cols++;
	}
	if ($out_p!="")
	{
		$out.="<td valign=\"top\">\n";
		$out.=" &nbsp;&nbsp;<div  class=\"subtleheading\">Tables to which This Table is Foreign</div> \n";
		$out.=$out_p;
		$out.="</td>\n";
		$cols++;
	}
	if ($out!="")
	{
		$out="<tr>" . $out . "</tr>";
		$out=TableEncapsulate($out, false);
	
	}
	return $out;
}



//echo "<a href=\"javascript:domdumpwindow()\">dump</a>";
?>

