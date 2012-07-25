<?php
//Judas Gutenberg, nov 26 2006
//builds and destroys entire entities in the database
//This code is covered under the GNU General Public License
//info here: http://www.gnu.org/copyleft/gpl.html
//the digest is as follows: you cannot modify this code without
//publishing your source code under the same license
//contact the developer at gus@asecular.com  http://asecular.com


//need to work on the unique_data  processing -- right now i pass in an associative array to RunTokenRichSQLScript 
//looking for dollar tokens in the sql
//but i really want to just be able to overwrite the hardcoded crap coming from creation_script.
 
include('tf_functions_core.php');
include('tf_functions_frontend_db.php');
include('tf_functions_backup.php');
include('tf_functions_sql_parsing.php');
include('tf_functions_editor.php');
include('tf_core_table_creation.php');
include('tf_save_form.php');
include('tf_functions_color_math.php');
if (file_exists('tf_odbc_functions.php'))
{
	require('tf_odbc_functions.php');
}

echo main();

function main()
{
	if(!IsExtraSecure())
	{
		die(ExtraSecureFailure());
	}
	$mode=$_REQUEST[qpre . "mode"];

	$strTable=$_REQUEST[qpre . "table"];
	$strDatabase=deMoronizeDB(gracefuldecay($_REQUEST[qpre . "db"],our_db));
	$strPHP=$_SERVER['PHP_SELF'];
	$entity_instance_id=$_REQUEST["entity_instance_id"];
	$entity_id=$_REQUEST["entity_id"];
	$bwlAddSlashes=false;
	if($_REQUEST[qpre . "addslashes"]!="")
	{
		$bwlAddSlashes=true;
	}
	$feedbackspanstag="<div class=\"feedback\">";
	$out="";
	//echo $id . " " .$idfield ;
 
	$out=LoginDecisions($strDatabase,  $strPHP, $strUser, false);
 
	if (IsSuperAdmin($strDatabase, $strUser)  && $strUser!="")
	{
		//echo $mode;
		$intAdminType= AdministerType($strDatabase, $strTable, $strUser);
		$feedback="";
		if ($intAdminType>1)
			{
				$sql=conDB();
				
				$feedback.= CreateNecessarySchemaIfNecessary($strDatabase);
				if($mode=="createinstance" || $mode=="reviveinstance" || $mode=="newentitycreate")
				{
					//echo "##";
					$feedback.= CreateEntityInstance($strDatabase, $entity_id, $entity_instance_id);
				}
				else if($mode=="kill" && $entity_instance_id!="")
				{
					$feedback.=KillInstance($strDatabase, $entity_instance_id, $entity_id);
				}
				//echo $_POST[qpre . "submit_clearid"] . "-";
				if( $_POST[qpre . "submit"]!="" || $_POST[qpre . "submit_clearid"]!="")
				{
					if($_POST[qpre . "submit_clearid"]!="")
					{
						$_POST[qpre . "oldid"]="";
						$entity_id="";
					}
					$feedback.=SaveForm($strDatabase, tfpre."db_entity",  "entity_id", $entity_id, "", $strUser, "");
				}
				if($feedback!="")
				{
					$out.=$feedbackspanstag . $feedback . "</div>";
				}
	 			if($mode=="" && $instance_id=="" || $mode=="newcreate")
				{
					$out.=EntityBrowser($strDatabase, $strPHP);
				}
				else if($mode=="viewinstances" && $entity_id!="" ||  $mode=="reviveinstance"  || $mode=="kill" ||  $mode=="createinstance" ||  $mode=="newentitycreate")
				{
					$out.=InstanceBrowser($strDatabase, $strPHP, $entity_id);
				}
				else if ($mode=="addinstance"  || $mode=="revive"  || $mode=="createinstance" || $mode=="editinstance")
				{
					$out.= InstanceForm($strDatabase, $entity_id, $entity_instance_id);
				}
				else if ($mode=="edit"  || $mode=="newentity" || $mode=="save" )
				{
					$strDBLink="tf.php?" . qpre . "db=" . $strDatabase;
					$breadcrumboverride=adminbreadcrumb(false,  $strDatabase, $strDBLink,  "entities", qbuild($strPHP, $strDatabase, $strTable, "", "", ""), "edit entity","") . $closebutton;
					$out.= TableForm($strDatabase, tfpre."db_entity", "entity_id", $entity_id, $strPHP,   "",  "", $strUser ,   "",  "",  "", $breadcrumboverride);
				}
		 		
			}
	}
	else if($strUser!="")
	{
		$out.=  "You do not have permissions to see this content.";
	}
	$out =  PageHeader($strDatabase . IfAThenB($strTable, " : ") . $strTable . IfAThenB($mode, " : ") . $mode . " : entity builder", $strConfigBehave) . $out;
	
	
	$out.= "<script>validationconfig='';\n TextAreaScan();\n</script>";
	$out.= PageFooter();

	return $out;
}

function InstanceBrowser($strDatabase, $strPHP, $entity_id)
{
//allows an admin to browse instances of entities
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strOtherBgClass="bgclassother";
	$strLineClass="bgclassline";
	$strTable=tfpre . "db_entity_instance";
	$strThisBgClass=$strClassFirst;
	$sql=conDB();
	$preout= "";

	$preout.= "<script src=\"tf_tablesort.js\"><!-- --></script>";
	$preout.= adminbreadcrumb(false,  $strDatabase,"tf.php?" . qpre . "db=" . $strDatabase,  "entities", $strPHP . "?" . qpre . "db=" . $strDatabase, "entity browser",  $strPHP . "?" . qpre . "db=" . $strDatabase . "&entity_id=" . $entity_id . "&" . qpre . "mode=", "entity ". $entity_id, "tf_entity_builder.php?" . qpre . "db=" . $strDatabase. "&" . qpre . "table=" . tfpre . "db_entity&" . qpre . "idfield=entity_id&entity_id=" . $entity_id  . "&" . qpre . "mode=edit", "instances", "" ) ;
	
	$out= "<form method=\"post\" name=\"BForm\" action=\"" .  $strPHP . "\">\n";
 	$out.= "\n" . HiddenInputs(array( "db"=>$strDatabase));
 
	$out.=htmlrow($strLineClass, "<a href=\"javascript: SortTable('idsorttable', 0)\">
		instance name</a>", "<a href=\"javascript: SortTable('idsorttable', 1)\">
		date created</a>", "<a href=\"javascript: SortTable('idsorttable', 2)\">
		date last revived</a>", "<a href=\"javascript: SortTable('idsorttable', 3)\">
		churn count</a>" ,   "<a href=\"javascript: SortTable('idsorttable', 4)\">
		root PK</a>", 
		"<a href=\"javascript: SortTable('idsorttable', 5)\">
		instance items</a>",
		"<a href=\"javascript: SortTable('idsorttable', 6)\">
		action</a>"
		);
	$strSQL="SELECT * FROM " . $strDatabase . "." . $strTable . " WHERE entity_id='" .  singlequoteescape($entity_id). "' ORDER BY entity_instance_id DESC";
	//echo $strSQL;
	$records = $sql->query($strSQL);
	foreach($records as $record)
	{
		$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
		$strRootURL=$strPHP.  "?" . qpre . "db=" . $strDatabase . "&" . qpre . "table=" . tfpre . "db_entity_instance&" . qpre . "idfield=entity_instance_id&entity_instance_id=" . $record["entity_instance_id"];
		$churn=CountRecordsOnFK($strDatabase , $strTable . "_entity", "entity_instance_id", $record["entity_id"]);
		$modeswitchlabel="revive";
		if($record["is_alive"])
		{
			$modeswitchlabel="kill";
		}
		$out.=htmlrow($strThisBgClass,
		"<a href=\"" . $strRootURL . "&" . qpre . "mode=editinstance\">" . $record["instance_name"] . "</a>", 
		$record["instance_creation"], 
		$record["last_created"], 
		$record["churn_count"], 
		$record["pk_value"], 
		ShowEntityInstanceItemLinks($strDatabase, $record["entity_instance_id"]),
		"<a href=\"" . $strRootURL . "&" . qpre . "mode=" . $modeswitchlabel . "\">" . $modeswitchlabel . "</a>" );
	} 

	
	$out.="<tr name=\"sortavoid\"><td colspan='4'><a href=\"" . $strPHP.  "?" . qpre . "db=" . $strDatabase . "&entity_id=" . $entity_id . "&" . qpre . "table=" . tfpre . "db_entity&" . qpre . "mode=addinstance\">Create new instance</a></td>";
	$out.="</form>";
	$out=$preout . TableEncapsulate($out);
	//$out.= "<a href=\"javascript:domdumpwindow()\">dump</a>";
	return $out;
}


function EntityBrowser($strDatabase, $strPHP)
//allows an admin to browse entities
{
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strOtherBgClass="bgclassother";
	$strLineClass="bgclassline";
	$strTable=tfpre . "db_entity";
	$strThisBgClass=$strClassFirst;
	$sql=conDB();
	$preout= "";

	$preout.= "<script src=\"tf_tablesort.js\"><!-- --></script>";
	$preout.= adminbreadcrumb(false,  $strDatabase,"tf.php?" . qpre . "db=" . $strDatabase,  "entities", $strPHP . "?" . qpre . "db=" . $strDatabase, "entity browser", "") ;
	
	$out= "<form method=\"post\" name=\"BForm\" action=\"" .  $strPHP . "\">\n";
 	$out.= "\n" . HiddenInputs(array( "db"=>$strDatabase));
 
	$out.=htmlrow($strLineClass, "<a href=\"javascript: SortTable('idsorttable', 0)\">
		entity name</a>", "<a href=\"javascript: SortTable('idsorttable', 1)\">
		date created</a>", "<a href=\"javascript: SortTable('idsorttable', 2)\">
		instance number</a>", "<a href=\"javascript: SortTable('idsorttable', 3)\">
		affected tables</a>", "
		&nbsp;", "&nbsp;", "&nbsp;");
	$strSQL="SELECT * FROM " . $strDatabase . "." . $strTable . " ORDER BY entity_id DESC";
	//echo $strSQL;
	$records = $sql->query($strSQL);
	foreach($records as $record)
	{
		$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
		$strRootURL=$strPHP.  "?" . qpre . "db=" . $strDatabase . "&" . qpre . "table=" . tfpre . "db_entity&" . qpre . "idfield=entity_id&entity_id=" . $record["entity_id"];
		$instance_number=CountRecordsOnFK($strDatabase , $strTable . "_instance", "entity_id", $record["entity_id"]);
		$out.=htmlrow($strThisBgClass,
		"<a href=\"" .  $strRootURL . "&" . qpre . "mode=edit\">" . $record["entity_name"] . "</a>",
		$record["date_created"], 
		$instance_number, 
		ShowEntityItemLinks($strDatabase,  $record["entity_id"]),
		"<a href=\"" . $strRootURL . "&" . qpre . "mode=addinstance\">add instance</a>", 
		"<a href=\"" . $strRootURL . "&" . qpre . "mode=viewinstances\">view instances</a>" ,
		"<a href=\"" .  $strRootURL . "&" . qpre . "mode=edit\">edit</a>"
		);
	} 

	
	$out.="<tr name='sortavoid'><td colspan='4'><a href=\"" . $strPHP.  "?" . qpre . "db=" . $strDatabase . "&" . qpre . "table=" . tfpre . "db_entity&" . qpre . "mode=newentity\">Create new entity</a></td>";
	$out.="</form>";
	$out=$preout . TableEncapsulate($out);
	//$out.= "<a href=\"javascript:domdumpwindow()\">dump</a>";
	return $out;
}

function CreateNecessarySchemaIfNecessary($strDatabase)
{
	$out="";
	$sql=conDB();
	if(!TableExists($strDatabase, tfpre . "db_entity"))
	{
		;
		$out.=MakeTableIfNotThere($strDatabase, tfpre . "relation", "MakeRelationTables");

		$strSQL="CREATE TABLE " . $strDatabase . "." .  tfpre . "db_entity (
		`entity_id` int(11) NOT NULL AUTO_INCREMENT,
		`entity_name` varchar(50) DEFAULT NULL,
		`root_table_name` varchar(50) DEFAULT NULL,
		`pk_column_name` varchar(50) DEFAULT NULL,
		`creation_script` text,
		`destruction_script` text,
		`view_script` text,
		`list_script` text,
		`date_created` datetime DEFAULT NULL,
		`date_used` datetime DEFAULT NULL,
		PRIMARY KEY (`entity_id`)
		) ";
		$tables = $sql->query($strSQL);
		$out.= sql_error();
	}
	if(!TableExists($strDatabase,  tfpre . "db_entity_instance"))
	{
		$strSQL="CREATE TABLE " . $strDatabase . "." .  tfpre . "db_entity_instance (
		`entity_instance_id` int(11) NOT NULL AUTO_INCREMENT,
		`entity_id` int(11) DEFAULT NULL,
		`instance_name` varchar(50) DEFAULT NULL,
		`pk_value` varchar(50) DEFAULT NULL,
		`unique_data` text,
		`instance_creation` datetime DEFAULT NULL,
		`creation_log` text,
		`churn_count` int(11) DEFAULT NULL,
		`is_alive` tinyint(1) DEFAULT NULL,
		`last_uncreated` datetime DEFAULT NULL,
		`last_created` datetime DEFAULT NULL, 
		PRIMARY KEY (`entity_instance_id`)
		}";
		$tables = $sql->query($strSQL);
		$out.= sql_error();
		
	}
	NewRelation($strDatabase,tfpre . "db_entity_instance","entity_id", tfpre . "db_entity","entity_id");
	return $out;
}


function InstanceForm($strDatabase, $entity_id, $entity_instance_id)
{
	$sql=conDB();
	$out="";
	$arrFieldNames=Array("instance_name", "unique_data", "pk_value", "instance_creation");
	$arrConfig=Array("instance_name"=>"size:12 ", "unique_data"=>"size:6040 ", "pk_value"=>"readonly label:'primary key'","instance_creation"=>"readonly label:'created'");
	$edittype="Create";
	if($entity_instance_id!="")
	{
		$strSQL="SELECT * FROM " . $strDatabase . "." . tfpre . "db_entity_instance WHERE entity_instance_id='" . $entity_instance_id . "'";
		$records = $sql->query($strSQL);
		$arrDefaults=$records[0];
		$edittype="revive";
		$arrDefaults[qpre. "mode"]="reviveinstance";
		$entity_id=gracefuldecay($entity_id, $arrDefaults["entity_id"]);
	}
	else
	{
		$arrDefaults[qpre. "mode"]="createinstance";
	}
	$arrDefaults[qpre. "db"]=$strDatabase;
	if($entity_id!="")
	{
		$arrDefaults["entity_id"]=$entity_id;
		$out.=adminbreadcrumb(false,  $strDatabase,"tf.php?" . qpre . "db=" . $strDatabase,  "entities", $strPHP . "?" . qpre . "db=" . $strDatabase, "entity " . $entity_id, "tf_entity_builder.php?" . qpre . "db=" . $strDatabase . "&entity_id=" . $entity_id, "instance " . $entity_instance_id, "",  $edittype . " instance" );
	}
	else
	{
		$out.=adminbreadcrumb(false,  $strDatabase,"tf.php?" . qpre . "db=" . $strDatabase,  "entities", $strPHP . "?" . qpre . "db=" . $strDatabase, "entity " . $entity_id, "tf_entity_builder.php?" . qpre . "db=" . $strDatabase . "&entity_id=" . $entity_id, $edittype . " instance" , "");
	}
	
	
	
	$out.=GenericForm($arrFieldNames,  $arrLabels, $arrDefaults,  $arrConfig, $strPHP, $edittype . " Instance", 630 );
	return $out;
}

function KillInstance($strDatabase, $entity_instance_id, &$entity_id)
{
	$today=date("Y-m-d H:i:s");
	$sql=conDB();
	$errors="";
	$pkname="entity_instance_id";
	$strTable=tfpre . "db_entity_instance";
	//basically run the creation log backwards, though it is more cryptic and more easily-parsed than real SQL
	$defaultrecord=GenericDBLookup($strDatabase,  $strTable, $pkname, $entity_instance_id ,  "");
	$entity_id=$defaultrecord["entity_id"];
	$creation_log=$defaultrecord["creation_log"];
	$arrLog=explode("\n-+||+-\n", $creation_log); // i make
	for($i=count($arrLog)-1; $i>-1; $i--)
	{
		$thislogline=$arrLog[$i] ;
		
		if($thislogline!="")
		{
			
			if(beginswith($thislogline, "a{"))
			{
				$thisInsertArray=unserialize($thislogline);
				$strThisTable=$thisInsertArray[qpre . "table"];
				unset($thisInsertArray[qpre . "table"]);
				$strWhereClause=ArrayToWhereClause($thisInsertArray);
				$strSQL="DELETE FROM " . $strDatabase . "." . $strThisTable . " WHERE " . $strWhereClause;
			}
			else
			{
				
				$arrLine=explode(" ", $thislogline);
				$strThisTable=$arrLine[0];
				$strThisKey=$arrLine[1];
				$strThisVal=$arrLine[2];
				$strSQL="DELETE FROM " . $strDatabase . "." . $strThisTable . " WHERE " . $strThisKey . "='". $strThisVal ."'";

			}
			//echo $strSQL . "<BR>";
			$records = $sql->query($strSQL);
			$thiserror=sql_error();
			if($thiserror!="")
			{
				$errors.="\n<br/>" . $thiserror;
			}
			else
			{
				//UPDATE data in the database about this instance
			 	//echo "#";
				$arrDescribedValuePairs=Array($pkname=>$entity_instance_id);
				unset($defaultrecord[$pkname]);
				$defaultrecord["is_alive"]=0;
				$defaultrecord["last_uncreated"]=$today;
				//$defaultrecord["churn_count"]=$defaultrecord["churn_count"]+1; //don't churn on delete, just recreate
				//echo var_dump($defaultrecord);
				//echo count( $arrDescribedValuePairs) . " " . count($defaultrecord) . "<br>";
				UpdateOrInsert($strDatabase,$strTable, $arrDescribedValuePairs, $defaultrecord);
				
			}
		}
	
	
	}
	return $errors;
}


function CreateEntityInstance($strDatabase, $entity_id, $entity_instance_id)
{
	
	$creationlog="";
 	$today=date("Y-m-d H:i:s");
	$instance_name=$_REQUEST["instance_name"];
	$unique_data=$_REQUEST["unique_data"];
 	$pkname="entity_instance_id";
	$strTable=tfpre . "db_entity_instance";
	//$strSQL="SELECT * FROM " . $strDatabase . "." . $strTable . " WHERE entity_id='" . $entity_id . "'";
	$entityinfo=GenericDBLookup($strDatabase,  tfpre . "db_entity", "entity_id", $entity_id ,  "");
	//$records = $sql->query($strSQL);
	//$entityinfo=$records[0];
	//echo $entityinfo["creation_script"];
	//most important is to run the creation script, which is a semicolon-delimited list of sql containing dollarsign tokens
	$unique_data=FixFormulaForEval($unique_data, true);
	eval('$arrUniqueData=Array(' . $unique_data . ');');
	$entityinfo=array_merge($entityinfo,$arrUniqueData);
	$errors=RunTokenRichSQLScript($entityinfo["creation_script"], $strDatabase, $entityinfo, $creationlog, $pk, $unique_data);
	//echo "<br>" . $pk . "<br>";
	$arrAlteredValuePairs=Array("unique_data"=>$unique_data, "creation_log"=>$creationlog, "instance_creation"=>$today, "entity_id"=>$entity_id, "instance_name"=>$instance_name, "pk_value"=>$pk);
	if($entity_instance_id!="")
	{
		$defaultrecord=GenericDBLookup($strDatabase,  $strTable, $pkname, $entity_instance_id ,  "");
		$arrDescribedValuePairs=Array($pkname=>$entity_instance_id);
		$arrAlteredValuePairs["churn_count"]=$defaultrecord["churn_count"]+1;
		$unique_data=gracefuldecay($unique_data, $defaultrecord["unique_data"]);
		$arrAlteredValuePairs["unique_data"]=$unique_data;
	}
	else
	{
		$arrAlteredValuePairs["churn_count"]=0;
	}
	 
	$arrAlteredValuePairs["is_alive"]=1;
	$arrAlteredValuePairs["last_created"]=$today;
	UpdateOrInsert($strDatabase, tfpre . "db_entity_instance", $arrDescribedValuePairs, $arrAlteredValuePairs, true,  false);
	return $errors;
}

function RunTokenRichSQLScript($strSQL, $strDatabase, $entityinfo, &$creationlog, &$pk)
{
	//runs a semicolon-delimited set of sql scripts, returning errors and replacing $variables
	//with values found in the $_REQUEST, $entityinfo, and the recordset generated by the preceding sql
	//also returns a creationlog and the first generated pk by reference
	//echo $strDatabase;
	//ParseStringToArraySkippingQuotedRegions($strIn, $quote="'", $delimiter=";", $escapecharacter="\\", $arrQuoteCorrectingSequences="usual") 
	$sql=conDB();
	$strSQL=FixFormulaForEval($strSQL, true);
	$arrSQL =ParseStringToArraySkippingQuotedRegions($strSQL);
	$errors="";
	$creationlog="";
	$entity_id=$entityinfo["entity_id"];
	$arrInsertIDsKeyedToPKs=Array();
	$arrInsertIDsKeyedToTables=Array();
	if(is_array($arrSQL))
	{
		foreach($arrSQL as $strSQL)
		{
			if(strlen($strSQL)>4)
			{
				//detokenize script:
				$arrTableGuess=FindTables($strSQL,  true);
				$guessedTable=$arrTableGuess[0];
				$guessedPK=PKLookup($strDatabase, $guessedTable);
				$arrVars=FindDollarVariables($strSQL);
				if(is_array($arrVars))
				{
					foreach($arrVars as $thisVar)
					{
						if(array_key_exists($thisVar, $_REQUEST))
						{
							$strSQL=str_replace('$' . $thisVar, $_REQUEST[$thisVar] , $strSQL); //replace anything keyed to columns in _REQUEST
						}
						
						if(array_key_exists($thisVar, $entityinfo))
						{
							$strSQL=str_replace('$' . $thisVar, $entityinfo[$thisVar] , $strSQL); //replace anything keyed to columns in db_entity
						}
						
						if(is_array($outrecord))
						{
							if(array_key_exists($thisVar, $outrecord))
							{
							//replace anything keyed to columns in the last record returned, though usually this will not amount to much
								$strSQL=str_replace('$' . $thisVar, $outrecord[$thisVar] , $strSQL); 
							}
						}
						if(array_key_exists($thisVar, $arrInsertIDsKeyedToPKs))
						{
							$strSQL=str_replace('$' . $thisVar, $arrInsertIDsKeyedToPKs[$thisVar] , $strSQL); //replace anything keyed to columns in db_entity
						}
						if(array_key_exists($thisVar, $arrInsertIDsKeyedToTables))
						{
							$strSQL=str_replace('$' . $thisVar, $arrInsertIDsKeyedToTables[$thisVar] , $strSQL); //replace anything keyed to columns in db_entity
						}
						
						//replace anything keyed to the $newid with the value of the last insert
						$strSQL=str_replace(  '$newid',   $insert_id   , $strSQL);
					}
				}
			 
				//echo "<font color=blue>::" . $strSQL . "</font><p>";
				$records = $sql->query($strSQL, true, $strDatabase);
				$outrecord=$records[0];
				$thiserror=sql_error();
				$insert_id=sql_insert_id();
				$arrInsertIDsKeyedToPKs[$guessedPK]=$insert_id;
				$arrInsertIDsKeyedToTables[$guessedTable]=$insert_id;
				//echo "<p><br><font color=red>" . $insert_id . "</font><p>";
				if($pk=="")
				{
					$pk=$insert_id;
				}
				if($thiserror!="")
				{
					$errors.="<br/>" . $thiserror;
				}
				else
				{
					if($insert_id>0 && !contains($guessedPK, " "))
					{
						$creationlog.=$guessedTable . " " . $guessedPK . " " . $insert_id . "\n-+||+-\n";
					}
					else
					{
						$arrInsertInfo=ParseInsertIntoStatement($strSQL);
						
					 
						$creationlog.=serialize($arrInsertInfo) . "\n-+||+-\n";
					}
				}
			}
		}
	}
	return $errors;
}

function ShowEntityItemLinks($strDatabase,  $entity_id)
{
	$out="";
	if($entity_id!="")
	{
		$creation_script=FixFormulaForEval(GenericDBLookup($strDatabase,  tfpre . "db_entity", "entity_id", $entity_id ,  "creation_script"));
		//echo $creation_script . "<P>";
	 	$arrSQL =ParseStringToArraySkippingQuotedRegions($creation_script);
		foreach($arrSQL as $strSQL)
		{	
			if($strSQL!="")
			{
				$info=ParseInsertIntoStatement($strSQL);
				$strThisTable=$info[qpre . "table"];
				$out.="<a href=\"tf.php?" . qpre . "db=" . $strDatabase . "&" . qpre . "table=" .  $strThisTable ."&x_mode=view\">" . $strThisTable. "</a> ";
			}
		}
	
	}
	return $out;
}

function ShowEntityInstanceItemLinks($strDatabase,  $entity_instance_id)
{
	$out="";
	$pkname="entity_instance_id";
	$strTable=tfpre . "db_entity_instance";
	$defaultrecord=GenericDBLookup($strDatabase,  $strTable, $pkname, $entity_instance_id ,  "");
	$entity_id=$defaultrecord["entity_id"];
	$creation_log=$defaultrecord["creation_log"];
	$arrLog=explode("\n-+||+-\n", $creation_log); // i make
	for($i=count($arrLog)-1; $i>-1; $i--)
	{
		$thislogline=$arrLog[$i] ;
		if($thislogline!="")
		{
			if(beginswith($thislogline, "a{"))
			{
				$thisInsertArray=unserialize($thislogline);
				$strThisTable=$thisInsertArray[qpre . "table"];
				unset($thisInsertArray[qpre . "table"]);
				$pk=PKLookup($strDatabase, $strThisTable);
				$arrPK=explode(" ", $pk);
				$thisInsertArray=array_intersect_key($arrPK, $thisInsertArray);
			}
			else
			{
				$arrLine=explode(" ", $thislogline);
				$strThisTable=$arrLine[0];
				$strThisKey=$arrLine[1];
				$strThisVal=$arrLine[2];
			}
			//echo $strThisTable . " " . $entity_instance_id . "<BR>";
 			//ArrayToWhereClause($arrPK)
	 		$out.="<a href=\"tf.php?" . qpre . "db=" . $strDatabase . "&" . qpre . "table=" .  $strThisTable ."&x_mode=edit&" . qpre . "idfield=". $strThisKey . "&". $strThisKey ."=". $strThisVal ."&" . qpre . "ks=" . urlencode(serialize($thisInsertArray)) . "\">" . $strThisTable. "</a> ";
 
		}
	}
	 
	return $out;
}
?>

