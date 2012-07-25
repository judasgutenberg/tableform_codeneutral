<?php 
class sqldb //I'm not big into PHP classes, but I use one here as part of the legacy of how this tool came to be.
{
	var $c=TRUE;
	function disconDB()
	{
		mysql_close($c);
		return($c);
	}
 
	function query($strSQL , $type="gusstyle", $strDatabase="")
	{
		
		GLOBAL $db_type;
		//if(defined("db_type")  && db_type=="odbc")
		//{
		if( $db_type=="odbc")
		{
			return odbc_query($strSQL);
		}
		//}
	
		if($strDatabase=="")
		{
			$strDatabase=our_db;
		}
		$c=FALSE;
		if(defined("remote_sql_url"))
		{
		
			$out=RemoteSQLCall(remote_sql_url, $strSQL, remote_sql_password);
		}
		else
		{
			
			if ($type=="gusstyle"  || $type==true)
			{
				//echo $_SERVER["SERVER_NAME"] . "<br>";
				$bwlNeedConnection=false;
				
				if (!$c)
				{
					if(defined("dburl"))
					{
					
					}
					else
					{
						if ($_SERVER["SERVER_NAME"]==optionalhost)
						{
							$c = mysql_connect(con_server_optional, con_user_optional,urldecode(con_pwd_optional));
						}
						else
						{
							$c = mysql_connect(con_server_web, con_user_web, urldecode(con_pwd_web));
						}
					}
					//echo $strDatabase .  "<br><b>" .  $strSQL  . "</b><p>";
					mysql_select_db($strDatabase, $c);
					$bwlNeedConnection=true;
				}
				$res= mysql_query($strSQL, $c);
				if ($bwlNeedConnection)
				{
					//mysql_close($c);
				}
	 		}
 
			else
			{
				$res= tep_db_query($strSQL);
			}
			$out=array();
			$count=0;
	
			if (gettype($res)=="resource")
			{
				for ($i=0; $i<mysql_num_rows($res); $i++)
				{
					$record=mysql_fetch_assoc($res);
				 
					$out[$count]=$record;
					$count++;
				}
	 		}
		}
		return $out;
	}	
}


//more complex db funcs

function TableExists($strDatabase, $strTable)
//Does the table exist?
{
 	GLOBAL $db_type;
	if($db_type=="odbc")
	{	
	 
		$tables=odbc_query("tables");
 
		foreach($tables as $table)
		{
			if($table["TABLE_NAME"]==$strTable  && $table["TABLE_TYPE"]=="TABLE")
			{
				return true;
			}
 
		}
		return false;
 
		//return false;
	}
	else
	{
	  	$likeclause="LIKE '" .  $strTable . "'";
		//echo $strTable . "<BR>";
		
		$tables=ListTables($strDatabase, $likeclause);
		//echo count("-" . $tables);
		if (count($tables)<1)
	    {
			return(false);
	    }
		else 
		{
			return(true);
		}
	}
}

function ListTables($strDatabase, $strLike="")
{
	$arrOut=Array();
	$tables=TableList($strDatabase, $strLike);
	$strFieldName="Tables_in_" . str_replace("`", "", $strDatabase);
	$i=0;
	foreach ($tables as  $k=>$v )
	{
		$tablename= $v[$strFieldName];
		$arrOut[$i]=$tablename;
		$i++;
		//echo $tablename . $strLike . " " . "<BR>";
	}
	//echo   "<BR>";
	return $arrOut;
}

function LookupName($strDatabase, $strTable, $strIDField, $strID, $strNameColumn="")
//Your basic lookup of a name given a table, idfield, and id
//As of Dec 18th, 2007, accepts a $strNameColumn in cases where this is known
{
	
	$sql=conDB();
	$strSQL="SELECT * FROM " . $strDatabase . "." .  $strTable . " WHERE " .  $strIDField . " = " . $strID;
	//echo "<font color=0000000>" .  $strSQL . "<br>";
	//echo $strNameColumn . " " . $strTable . "<BR>";
	if ($strTable !="")
	{
	
		$records = $sql->query($strSQL);
		$record=$records[0];
		if($strNameColumn=="")//more complex if you don't have the name column of course
		{
			$strNameField1=NthNonIDColumName($strDatabase, $strTable, 1);
			$strNameField2 = NthNonIDColumName($strDatabase, $strTable, 2);
			//echo $firstnonidcolumn  . "<br>";
		 	//echo $strNameField1 . " " . $strNameField2 . "<br>";
			//fancy code to get text from two fields when one isn't sufficient
			$strLabel1 = $record[$strNameField1];
			$strLabel2 = $record[$strNameField2];
		 	//echo $strLabel1 . " " . $strLabel2  . "<br>";
			
			if ((strlen($strLabel1)<16 && $strLabel2!="" && !(strlen($strLabel2)>14)))
			 {
			 	$strLabel=$strLabel1  . " : " . $strLabel2;
			 }
			else
			{
			 	$strLabel=$strLabel1 ;
			}
		}
		else//you have a name column, so it's easy
		{
		
			$strLabel=LabelThis("", $strNameColumn,  $wasteconnector, $record);
		 
		}
	}
	return  $strLabel;
}

function GenericDBLookup($strDB, $strTable, $strIDFieldName, $strThisID, $strResultFieldName="", $bwlDebug=false, $bwlWorkUntilFound=true, $language_id="")
{
	if($strThisID!="")
	{
		return GenericDBLookupWhere($strDB, $strTable,   $strIDFieldName . " = '" . $strThisID . "'", $strResultFieldName, $bwlDebug,  $bwlWorkUntilFound, $language_id);
	}
}

function GenericDBLookupLast($strDB, $strTable, $strIDFieldName, $strThisID, $strResultFieldName, $bwlDebug=false, $bwlWorkUntilFound=true, $language_id="")
{
	$pk=PKLookup($strDB, $strTable);
	return GenericDBLookupWhere($strDB, $strTable,   $strIDFieldName . " = '" . $strThisID . "' ORDER BY " .  $pk. " DESC", $strResultFieldName, $bwlDebug,  $bwlWorkUntilFound, $language_id);
} 

function GenericDBLookupWhere($strDB, $strTable, $strWhereClause, $strResultFieldName="", $bwlDebug=false, $bwlWorkUntilFound=true, $language_id="")
//modified 10-2-2007 to allow for the returning of a whole row
{
	$fieldtosearchfor=$strResultFieldName;
	if($strResultFieldName=="")
	{
		$fieldtosearchfor="*";
	}
	$strSQL="SELECT " . $fieldtosearchfor . " FROM " . $strDB . "." . $strTable . " WHERE " . $strWhereClause;
	if($bwlDebug)
	{
		echo $strSQL . "<br>";
	}
	if($language_id=="")
	{
		$sql=conDB();
		$records = $sql->query($strSQL);
	}
	else
	{
		$records =TranslatedQuery($strSQL, $language_id,  "");
	}

	$record = $records[0];
	//this part of the code keeps scanning through the data until a valid record is found
	if($strResultFieldName=="")
	{
		return $record;
	}
	if (count($records)>1 && $bwlWorkUntilFound  && $strResultFieldName!="")
	{
		foreach($records as $record)
		{
			if($record[$strResultFieldName]!="")
			{
				return $record[$strResultFieldName];
			}
		}
	}
	return $record[$strResultFieldName];
}

function GenericDBLookupFromArray($strDB, $strTable, $arrSpec, $strResultFieldName, $bwlDebug=false, $bwlWorkUntilFound=true)
{
 	$strWhereClause=ArrayToWhereClause($arrSpec);

	return GenericDBLookupWhere($strDB, $strTable, $strWhereClause, $strResultFieldName, $bwlDebug, $bwlWorkUntilFound);
}



function TableExplain($strDatabase, $strTable, $bwlFollowRelations=false)
//explains the columns across several tables linked by relations in the relation table or do a simple explain
{
	GLOBAL $db_type;
	if( $db_type=="odbc")
	{
		return odbc_TableExplain($strDatabase, $strTable, $bwlFollowRelations);
	}
 
	$sql=conDB();
	$arrOut=Array();

	if($bwlFollowRelations)
	{
		$strSQL="SELECT * FROM " . $strDatabase . "." . tfpre . "relation WHERE relation_type_id=0 AND table_name='" . $strTable . "'";
		$records = $sql->query($strSQL);
		foreach($records as $record)
		{
			$strThisTable=$record["f_table_name"];
			$trecords = $sql->query("EXPLAIN " . $strDatabase . "." . $strThisTable);
		 	$arrOut=array_merge($arrOut, $trecords);
		}
	}
	 
	$records = $sql->query("EXPLAIN " . $strDatabase . "." . $strTable);
 
	$arrOut=array_merge($arrOut, $records);
	return $arrOut;
}

function TableFieldsAsBlankRS($strDatabase, $strTable)
{
	$arrOut=Array();
	$arrROut=Array();
	$records = TableExplain($strDatabase, $strTable);
	foreach($records as $record)
	{
		$arrROut[$record["Field"]]="";
	}
	$arrOut[0]=$arrROut;
	return $arrOut;
}

function GetFieldTypeArray($strDatabase, $strTable)
//Give me the types of a columns for a table as an array.
//you can pass in multiple tables delimited by spaces and it will search all of them
{
	$arrOut=Array();
	$arrTables=explode(" ",$strTable);
	foreach($arrTables as $strTable)
	{
		$records=TableExplain($strDatabase, $strTable);
		foreach ($records as $k => $v )
		{
			$arrOut[$v["Field"]]= $v["Type"];
		}
	}
	return $arrOut;
}

function GetFieldArray($strDatabase, $strTable, $bwlAssociativeAndReturnType=false)
//Give me an array of field names for a table.
//you can pass in multiple tables delimited by spaces and it will search all of them
// $bwlAssociativeAndReturnType allows me to return an array of types keyed to the column names
//sorta like generateFieldTypeArray except no TypeParse
{

	$arrOut=Array();
	$arrTables=explode(" ",$strTable);
	foreach($arrTables as $strTable)
	{
		$records=TableExplain($strDatabase, $strTable);

		foreach ($records as $k => $v )
		{
			if($bwlAssociativeAndReturnType)
			{
				$arrOut[$v["Field"]]=$v["Type"];
			}
			else
			{
				$arrOut[$count]= $v["Field"];
				$count++;
			}
		}
	}
	return $arrOut;
}

function generateFieldTypeArray($strDatabase, $strTable)
//Returns an associative array keyed to the names of columns containing types.
//nov 2006
{
	$arrFieldType=array();
	$descr=TableExplain($strDatabase, $strTable);
	foreach ($descr as $nom=>$info)
	{
		$strName=$info["Field"];
		$strType=TypeParse($info["Type"], 0);
		$arrFieldType[$strName]=$strType;
		
		
	}
	return $arrFieldType;
}

function removeTics($in)
{
	$out=str_replace("`", "", $in);
	return $out;
}

function ensureEnclosure($in, $beginenclosure="`", $endencolosure="`")
{
	if(!beginswith($in, $beginenclosure))
	{
		$in=$beginenclosure. $in;
	}
	if(!endswith($in, $endencolosure)) 
	{
		$in.=$endencolosure;
	}
	return $in;
}

function MergeSQLConditionals($strConditionalOne, $strConditionalTwo, $bwlEnsureSomeSortofBegin=true)
{
//take two conditionals that are to be applied to one SQL statement, and merge them such that the syntax works.
//judas gutenberg may 25 2010
	$strConditionalOne=trim($strConditionalOne);
	$strConditionalTwo=trim($strConditionalTwo);
	$strLCOne=BlankOutQuotedAreas(strtolower($strConditionalOne), "*", "'");
	$strLCTwo=BlankOutQuotedAreas(strtolower($strConditionalTwo), "*", "'");
	$strJoinpart="";
	if(beginswith($strLCOne, "and"))
	{
		$strConditionalOne=substr($strConditionalOne, 3);
	
	}
	if(beginswith($strLCTwo, "and"))
	{
		$strConditionalTwo=substr($strConditionalTwo, 3);
	
	}
	if(beginswith($strLCOne, "where"))
	{
		$strConditionalOne=substr($strConditionalOne, 5);
	
	}
	if(beginswith($strLCTwo, "where"))
	{
		$strConditionalTwo=substr($strConditionalTwo, 5);
	
	}
	
	if(beginswith($strLCOne, "join"))
	{
		$wherestart=strpos($strLCOne, "where");
		//echo $strConditionalOne ." " . $wherestart . "=<BR>";
		$strJoinpart1=substr($strConditionalOne, 4, $wherestart-4);
		$strConditionalOne=substr($strConditionalOne, $wherestart+ 5);
	}
	if(beginswith($strLCTwo, "join"))
	{
		$wherestart=strpos($strLCTwo, "where");
		$strJoinpart2=substr($strConditionalTwo, 4, $wherestart-4);
		$strConditionalTwo=substr($strConditionalTwo, $wherestart+ 5);
	}
	//echo $strJoinpart1 . "<BR>";
	//echo $strJoinpart2 . "<BR>";
	$joinpart= JoinList("JOIN", $strJoinpart1,  $strJoinpart2);
	$out=JoinList(" AND ",  $strConditionalOne , $strConditionalTwo);
 	if($joinpart!="")
	{
		$out= "JOIN " . $joinpart. " WHERE " . $out;
	
	}
	if($out!=""  && $bwlEnsureSomeSortofBegin)
	{
		$strBegin="";
		if(beginswith(strtolower($out), "join"))
		{
			$strBegin="";
		}
		else if (beginswith(strtolower($out), "where"))
		{
			$strBegin="";
		}
		else
		{
			$strBegin="WHERE";
		}
 		$out= $strBegin . " " . $out;
	}
	return $out;
}

function UpdateOrInsert($strDatabase, $strTable, $arrDescribedValuePairs, $arrAlteredValuePairs, $bwlEscape=true, $bwlDebug=false, $bwlDontFork=false)
//Does an insert or an update depending on whether or not the described record exists.  
//Make sure to not include items in $arrAlteredValuePairs that are in  $arrDescribedValuePairs.
//If there are no $arrDescribedValuePairs, they become $arrAlteredValuePairs in an INSERT.
//this function has pretty much replaced my use of explicit SQL for updates and inserts, though Saveform still does things that way
{
	$sql=conDB();
	//echo count($arrDescribedValuePairs ) . "-" . $bwlDontFork . "<BR>";
	$strSQL="SELECT * FROM " . $strDatabase . "." .  $strTable . " WHERE ";
	//echo $strSQL . "<p>";
	$strAlterSQL="";
	$strUpdateSQL="";
	$strAlterSetSQL="";
	$bwlMustShortenByFour=false;
	$strDescrValueList="";
	$strDescrColumnList="";
	$bwlCantLookup=false;
	//added the known field lookup to allow the passing in of really messed-up arrays containing all sorts of junk value pairs
	$arrKnownFields=GetFieldArray($strDatabase, $strTable, true);
	//foreach($arrKnownFields as $k=>$r)
	{
		//echo  $strDatabase . " " .$strTable . " " . $k . " " . $r . "<BR>";
	}
	//foreach($arrAlteredValuePairs as $k=>$r)
	{
		//echo  $strDatabase . " " .$strTable . " " . $k . " " . $r . "--<BR>";
	}
	$strValueListDesc="";
	$strColumnListDesc="";
	if(is_array($arrDescribedValuePairs))
	{
		//echo "$";
		foreach($arrDescribedValuePairs as $k=>$v)
		{
			if(!$bwlDontFork)//HACKY!!!!  trying to make this work in the world of odbc
			{
				$k=ensureEnclosure($k);
			}
			//echo removeTics($k) . "()()<BR>";
			if(array_key_exists(removeTics($k), $arrKnownFields))
			{
				//echo "%";
				$bwlMustShortenByFour=true;
				$valtostore=$v;
				if($bwlEscape)
				{
		 			$valtostore= singlequoteescape($v);
				}
				//echo "isarraylatered:" . is_array($arrAlteredValuePairs) . "<BR>";
				if(is_array($arrAlteredValuePairs))
				{
					
					if(!array_key_exists(removeTics($k), $arrAlteredValuePairs)  && $k !="")
					{
						$strSQL.= " " . $k . "='" . $valtostore . "' AND";
						$strUpdateSQL.= $k . "='" . $valtostore . "',";
						$strAlterWhereSQL.=" " . $k . "='" . $valtostore . "' AND";
						//echo  $strDatabase . " " .$strTable . " " . $k . " " . $v . "--<BR>";
						$strValueListDesc.="'" . $valtostore . "',";
						$strColumnListDesc.=$k . ",";
					}
					else
					{
				
						$bwlCantLookup=true;
					}
				}
				else
				{
					$strSQL.= " " . $k . "='" . $valtostore . "' AND";
					$strUpdateSQL.= $k . "='" . $valtostore . "',";
					$strAlterWhereSQL.=" " . $k . "='" . $valtostore . "' AND";
					
				}
			 
				$strDescrValueList.="'" . $valtostore . "',";
				$strDescrColumnList.=$k . ",";
			}
		
		}
	}
	//echo $strSQL . "==<BR>";
	$strValueList.="";
	$strColumnList.="";
	if(is_array($arrAlteredValuePairs))
	{
		foreach($arrAlteredValuePairs as $k=>$v)
		{
			if(!$bwlDontFork)//HACKY!!!!  trying to make this work in the world of odbc
			{
				$k=ensureEnclosure($k);
			}
			if ($k!="")
			{
				$valtostore=$v;
				if($bwlEscape)
				{
					//echo $v . "<BR>";
		 			$valtostore= singlequoteescape($v);
				}
			
				if(array_key_exists(removeTics($k), $arrKnownFields))
				{
					
					$strAlterSetSQL.= $k . "='" . $valtostore . "',";
					//these last two are required for the fussier TSQL universe
					$strValueList.="'" . $valtostore . "',";
					$strColumnList.=$k . ",";
					//echo  $strDatabase . " " .$strTable . " " . $k . " " . $v . "--<BR>";
				}
			}
		}
	}
	$strColumnList= RemoveLastCharacterIfMatch($strColumnList, ",");
	$strValueList= RemoveLastCharacterIfMatch($strValueList, ",");
	
	$strValueListDesc=RemoveLastCharacterIfMatch($strValueListDesc, ",");
	$strColumnListDesc=RemoveLastCharacterIfMatch($strColumnListDesc, ",");
						
	//echo "strAlterSetSQL " . $strAlterSetSQL . "<p>";
	if($bwlMustShortenByFour)//gets rid of the " AND"
	{
		$strSQL= substr($strSQL, "0", strlen($strSQL)-4); 
	}
	$strAlterWhereSQL= substr($strAlterWhereSQL, "0", strlen($strAlterWhereSQL)-4); 
 
	$strUpdateSQL= RemoveLastCharacterIfMatch($strUpdateSQL, ",");
	$strAlterSetSQL= RemoveLastCharacterIfMatch($strAlterSetSQL, ",");
	$idInsert="";
	$bwlCanGetInsertID=false;
	//echo $strSQL . ":existsql<BR>";
	if(!$bwlCantLookup)
	{
		$records=$sql->query($strSQL);
	}
	//echo "count records: " . count($records) . "<br>";
	//echo "count descr val pairs: " . count($arrDescribedValuePairs) . "<br>";
	//echo "isarray descr val pairs: " . is_array($arrDescribedValuePairs) . "<br>";
	//echo "strAlterWhereSQL " . $strAlterWhereSQL . "<br>";
	//echo "strAlterSetSQL " . $strAlterSetSQL . "<p>";
	
	
	if($bwlDontFork  && ($bwlCantLookup || count($records)<1))
	{
		 
		//this is kind of hacky, but basically what we're saying is that if we're at the odbc fork of a forkind db (indicated by bwlDontFork)
		//AND there was nothing in the lookup
		//then this is basically an insert
		//but the PK is added in as just part of the DESCR
		
		$strValueList=$strDescrValueList . $strValueList;
		$strColumnList=$strDescrColumnList . $strColumnList;
		//echo $strValueList . "<BR>";
		//echo $strColumnList . "<BR>";
	}
	//echo count($records) . "_<br>";
	//die(is_array($arrDescribedValuePairs));
	if (count($records)>0 && count($arrDescribedValuePairs)>0   && is_array($arrDescribedValuePairs) && $strAlterWhereSQL!=""  && $strAlterSetSQL!="")
	{
		//need an update
		$strSQL="UPDATE " . $strDatabase . "." .  $strTable . " SET ". $strAlterSetSQL . " WHERE " . $strAlterWhereSQL;
		 
	}
	else if (count($records)<1  ||  !is_array($arrDescribedValuePairs))
	{
		//need an insert
		//OLD WAY:$strSQL="INSERT INTO " . $strDatabase . "." .  $strTable . " SET ". $strAlterSetSQL . IfAThenB($strAlterSetSQL, ", ") . $strUpdateSQL ;
		
		//NEW WAY, more compatible with TSQL:
		
		if($bwlDontFork)
		{
			
			// echo "-" . odbc_errormsg() . "-";
		}
		//echo $strColumnList . "--------" . $strColumnListDesc . "<BR>";
		//if(inList(str_replace(",", " " , $strColumnList), $strColumnListDesc))//kind of hacky, should have caught this case earlier
		//{
			//$strColumnListDesc="";
			//$strValueListDesc="";
		//}
		if(is_array($arrDescribedValuePairs))
		{
			//sometimes i need the following code and sometimes i don't for some reason.....
			//let's hope i never actually need it
			//$strColumnListDesc="";
			//$strValueListDesc="";
		}
		$strSQL="INSERT INTO " . $strDatabase . "." .  $strTable . "(" . JoinList(",", $strColumnList, $strColumnListDesc) . ") VALUES(" . JoinList(",",$strValueList ,$strValueListDesc)  . ")";
		$bwlCanGetInsertID=true;
		
	}

	if($strSQL!="")
	{
		$strSQL= RemoveLastCharacterIfMatch($strSQL, " ");
		$strSQL= RemoveLastCharacterIfMatch($strSQL, ",");
	 	if( $bwlDontFork)
		{
			//die($strSQL);
		}
		//echo $strSQL . "<br>";
		//die();
	 
		if(CanChange())
		{
	 
			$records = $sql->query($strSQL);
			//echo "-" . odbc_errormsg() . "-<BR>";
			///echo sql_error() . "<p>";
			//die();
		}
		else
		{
			return "Database is read-only.<br/>";
		}
	
		if($bwlCanGetInsertID)
		{
			 
			$idInsert=sql_insert_id();
		}
		
		if($bwlDebug=="log")
		{
	 
			logmysqlerror($strSQL, true,"", $strDatabase);
		}
		else if($bwlDebug  || $bwlDebug=="die")
		{
			echo "<b>" . $strSQL . "</b><br>";
			echo sql_error() . "<p>";
			if ($bwlDebug=="die")
			{
				die();
			}
		}
	}
	
	//echo $idInsert . "=<br>";
	$out= gracefuldecay(sql_error(),$idInsert) ;
	if(function_exists("ForkInsert")  && !$bwlDontFork)//ForkInsert is the name of a function that can be used to send the data to another db or log it somewhere
	//a good place for this would be the library for the particular application, since forking is usually application specific
	{	
		ForkInsert($strDatabase, $strTable, $arrDescribedValuePairs, $arrAlteredValuePairs,  $out, true, false);
	}
	return $out;
}


function TableList($strDatabase, $likeclause="")
{
	GLOBAL $db_type;
	if( $db_type=="odbc")
	{
		return odbc_TableList($strDatabase, $likeclause="");
	}
	$sql=conDB();
	$strSQL="SHOW TABLES FROM " . $strDatabase . " " .  $likeclause; 
	$records = $sql->query($strSQL);
	return $records;
}

function GetLimitClause($intRecord,  $intRecsPerPage)
{
	GLOBAL $db_type;
	if( $db_type=="odbc")
	{
		return;//no limit clause in odbc, so return for now until i find a workaround
	}
	return " LIMIT " . $intRecord . "," . $intRecsPerPage;
}
function sql_insert_id()
{
	GLOBAL $db_type;
	//a wrapper function in case some day we're not using mysql
	if( $db_type=="odbc")
	{
		return; //should probably figure out how to do this at some point
	}
	return mysql_insert_id();
}

function sql_error()
{
	//a wrapper function in case some day we're not using mysql
	return mysql_error();
}

function conDB()
{
 	$sql=new sqldb();
	return($sql);
}

function disconDB()
{
	mysql_close($c);
	 
	return($c);
}

////////////////
function CanChange()
{
	if(defined("mode"))
	{
		if(contains(mode, 'readonly'))
		{
			return false;
		}
	}
	return true;
}

////////////////////
function RelationLookup($strDatabase, $strTable, $strColumn="", $intType=0, $strForeignTable="", $strForeignColumn="", $tool_guidance_id ="", $mode="")
//Looks up the multi-table info given a column
{
		$sql=conDB();
		$strAdditional="";
		if($strColumn!="")
		{
			$strAdditional.=" AND column_name='" . $strColumn . "'"; 
		}
		if($strForeignTable!="")
		{
			$strAdditional.=" AND f_table_name='" . $strForeignTable . "'";
		}
		if($strForeignTable!="")
		{
			$strAdditional.=" AND f_column_name='" . $strForeignColumn . "'";
		}
		if($tool_guidance_id!="")
		{
			$strAdditional.=" AND tool_guidance_id='" . $tool_guidance_id . "'";
		}
		$strSQL="SELECT * FROM " . $strDatabase . "." . tfpre . "relation WHERE table_name='" . $strTable . "'  AND relation_type_id=" . $intType . $strAdditional;
		$records = $sql->query($strSQL);
		//echo $strSQL . "<P>";
		$count=0;
		foreach ($records as $record)
		{
			if($mode=="")
			{
				//echo  $record["display_column_name"] . "<BR>";
				return array( $record["f_table_name"],  $record["f_column_name"], $record["table_name"], $record["column_name"], $record["display_column_name"], $record["tool_guidance_id"], $record["narrowing_conditions"], $record["relation_id"]) ;
			}
			else //return associative
			{
				return  $record;
			}
		 
			$count++;//huh?  never gets executed
		}
}
	
function firstforeignkeycolumn($strDatabase, $strTable, $strMappedTableToAvoid)
//In which i make a reasonable guess of where a mapping table maps to
//returns a three-member array, with [0]the field name and [1] the mapped table and [2] the mapped column
//I pass in $strMappedTableToAvoid to avoid mapping off to the table I'm starting from
//modified for MySQL 2-7-06
{
	return  Nthforeignkeycolumn($strDatabase, $strTable, $strMappedTableToAvoid, 1);
}

function Nthforeignkeycolumn($strDatabase, $strTable, $strMappedTableToAvoid, $n)
//In which i make a reasonable guess of where a mapping table maps to
//returns a three-member array, with [0]the field name and [1] the mapped table and [2] the mapped column
//I pass in $strMappedTableToAvoid to avoid mapping off to the table I'm starting from
//modified for MySQL 2-7-06
{
	$sql=conDB();
	$records = $sql->query("SELECT * FROM " . $strDatabase . "." . tfpre . "relation WHERE table_name='" . $strTable . "'  AND relation_type_id=0");
	$count=0;
	$right=0;
	foreach ($records as $record)
	{
		if ( $record["f_table"] != $strMappedTableToAvoid  )
		{
			//echo $k . "->" . $v .  "<br>";
			$right++;
			if ($n==$right)
			{
				return array(  $record["column_name"], $record["f_table_name"],  $record["f_column_name"],  $record["display_column_name"]) ;
			}
			
		}
		$count++;
	}
}
	
function highestprimarykey($strDatabase, $strTable)
//I want the max PK id for a table.
//I didn't know that PHP has built-in support for this functionality when I wrote this.
//actually, though, this function does something somewhat different from PHP's mysql_insert_id functionality
//because it allows me to go in and find the largest PK value in a table to which nothing was added
//modified sept 2 2008 to deal with compound pks, returning null in that case
{
	$sql=conDB();
	$out="";
	$records=TableExplain($strDatabase, $strTable);
	foreach ($records as $k => $v )
	{
		if ($v["Key"]=="PRI")
		{
			if($out!="")
			{
				return; //return null if we have two PKs
			}
			$strSQL="SELECT MAX(" . $v["Field"]. ") FROM " . $strDatabase . "." .  $strTable;
			$orecords=$sql->query($strSQL);
			$orecord =$orecords[0];
			$out= $orecord["MAX(" . $v["Field"]. ")"];
		}
	}
	return $out;
}

function FieldExists($strDatabase, $strTable, $strFieldName)
//Does this field exist in this table? now can check a comma-delimited list passed in as $strFieldName
{
	$records=TableExplain($strDatabase, $strTable);
	if(contains( $strFieldName, ","))
	{
		$arrFields=explode(",", $strFieldName);
	}
	else
	{
		$arrFields=Array($strFieldName );
	}
	$bwlOut=true;
 
	foreach($arrFields as $thisfield)
	{
		$bwlThis=false;
		foreach ($records as $k => $v )
		{
			if ($v["Field"]==$thisfield)
			{
				$bwlThis=true;
				break;
			}
		}
		$bwlOut=$bwlOut  && $bwlThis;
	}
	return $bwlOut;
}

function RowExists($strDatabase, $strTable, $strFieldName, $ID)
//Does this ID exist in this table in this field?
{
	$sql=conDB();
	$strSQL="SELECT " .  $strFieldName . " FROM " . $strDatabase . "." .  $strTable . " WHERE " . $strFieldName . "='" . $ID . "'";
	$records = $sql->query($strSQL);
 	if (count($records)>0)
	{
		return true;
	}
	return false;
}

function GetFieldType($strDatabase, $strTable, $strFieldName)
//Give me the type of a column
{
	$records=TableExplain($strDatabase, $strTable);
	foreach ($records as $k => $v )
	{
		if ( $v["Field"]==$strFieldName)
		{
			return  $v["Type"];
		}
	}
}


function countforeignkeycolumns($strDatabase, $strTable, $strMappedTableToAvoid)
//For counting all the foreign keys except to the one to avoid
//Useful for seeing whether it's best to not treat a mapping table as such
{
	$sql=conDB();
	$strSQL="SELECT COUNT(*) as 'table_count' FROM " .  $strDatabase . "." . tfpre . "relation  WHERE table_name  = '" .  $strTable . "' AND relation_type_id=0";
	$records = $sql->query($strSQL);
 	$record=$records[0];
	return $record["table_count"];
}

function hasautocount($strDatabase, $strTable)
//Does the table have an autocount column?
{
	$records=TableExplain($strDatabase, $strTable);
	$count=0;
	foreach ($records as $k => $v )
	{
		if ($v["Extra"]=="auto_increment") 
		{
			return true;
		}
	}
	return false;
}

function countrecords($strDatabase , $strTable )
//Returns the number of records in a table.
{
	$sql=conDB();
	$countrecs = $sql->query("SELECT COUNT(*) FROM " . $strDatabase . "." . $strTable ); 
	$countrec=$countrecs[0];
	$count=$countrec["COUNT(*)"];
	return $count;
}

function CountSQLRecords($strSQLQuery)
{	
	if (strpos(strtolower($strSQLQuery), "count(")<1)
	{
		$strSQLQuery=str_replace("*", "count(*) as 'countage'", $strSQLQuery);
	}
	$sql=conDB();
	$countrecords = $sql->query($strSQLQuery);
	$countrecord=$countrecords[0];
	$intCount=$countrecord["countage"];
	return gracefuldecaynumeric($intCount,0);
}

function CountRecordsOnFK($strDatabase , $strTable,  $fkname, $fk)
{
	$sql=conDB();
	$strSQL="SELECT * FROM " . $strDatabase . ".". $strTable . " WHERE " .  $fkname ."='" . singlequoteescape($fk) . "'";
	return CountSQLRecords($strSQL);
}

function FieldCount($strDatabase, $strTable)
//Returns the number of columns in a table.
{
	$records = TableExplain($strDatabase, $strTable);
	return count($records);
}

/////////////////////////////////////////////////////////////////////
//basic string functions for SQL manipulations
	
function  TypeParse($strIn, $intPart)
//Parse mysql types into the basic type ($intPart=0) and whatever descriptive numerics follow ($intPart=1).
{
	$strIn=str_replace(" ","", $strIn);
	$strIn=str_replace("(","|", $strIn);
	$strIn=str_replace(")","|", $strIn);
	$arrIn=explode("|", $strIn);
	return $arrIn[$intPart];
}

function TypeSQL($strType, $strSize="", $strAfterComma="")
{
	//creates the sql phrase where a type is specified
	//makes sure to leave on $strSize for certain types
 
	//deal with no one passing in a size
	//data($strIn,$intTypeIn, $intTypeOut, $strTranslate)
	if(strtolower($strType)!="enum")//ah just learned about type enum on May 10 2010!  this allows enum stuff to be put in the size field of tablemaker
	{
 		$strSize = AppropriateSQLSizeString($strSize);
	}
	if($strAfterComma!="" && inList("decimal float double real" , strtolower($strType)))
	{
		$strSize.="," . $strAfterComma;
	}
	if (!inList("mediumtext time longtext datetime text date timestamp bit", $strType))
	{
		$out= $strType . "(" . $strSize . ") ";
	}
	else
	{
		$out= $strType . " ";
	}
	return $out;
}

function AppropriateSQLSizeString($strIn)
{
	$strIn=str_replace(",", ".", $strIn);
	$strIn=ClearNumeric($strIn,true);
	$strIn=str_replace(".", ",", $strIn);
	return $strIn;
}

function ReturnNonIDPartOfName($strIn)
//This function only works in a DB with strict adherence to the _id naming convention.
{
	if (contains($strIn, "_"))
	{
		$arrIn=explode("_", $strIn);
		for($i=0; $i<count($arrIn); $i++)
		{
			if (strtolower($arrIn[$i])!="id")
			{
				$out.=$arrIn[$i] . " ";
			
			}
		}
	}
	else
	{
		$out=$strIn;
	}
	return $out;
}

function ArrayToWhereClause($arrIn)
//Take an associative array and make it into the stuff that comes after the WHERE in a MySQL expression
{
	$out="";
	foreach($arrIn as $key=>$value)
	{
		if($value!="")
		{
			$out.= "AND  " . $key . "='" . singlequoteescape($value) . "' ";
		}
	
	}
	$out=substr($out, 3);
	return $out;
}

function ArrayToInsertSQL($strDatabase, $strTable, $arrIn, $arrSpec="")
//Take an associative array and a table name and make an insert statement out of it
//can make an update statement if $arrSpec is given
{
	//INSERT INTO tf_relation(table_name, column_name, f_table_name, f_column_name, relation_type_id) VALUES ('begin-ot_answer-end','suggested_answer_id','begin-ot_suggested_answer-end','suggested_answer_id',0);
	$strDBSpec="";
	if($strDatabase!="")
	{
		$strDBSpec=$strDatabase . ".";
	}
	if(is_array($arrSpec))
	{
		$out="UPDATE " . $strDBSpec . $strTable;
	}
	else
	{
		$out="INSERT INTO " . $strDBSpec . $strTable;
	}
	$nameclause="";
	$dataclause="";
	foreach($arrIn as $key=>$value)
	{
		if(is_array($arrSpec))
		{
			$nameclause.= ", " . $key . "='" . singlequoteescape($value) . "' ";

		}
		else
		{
			if($value!="")
			{
				$nameclause.=$key . ",";
				$dataclause.="'" . singlequoteescape($value) . "',";
			}
		}
	
	}
	if(is_array($arrSpec))
	{
		$nameclause=substr($out, 2);
		$out.=" SET " . $nameclause . " WHERE " .  ArrayToWhereClause($arrSpec) . ";";
	}
	else
	{
		$nameclause=RemoveEndCharactersIfMatch($nameclause, ",");
		$dataclause=RemoveEndCharactersIfMatch($dataclause, ",");
		$out.="(" . $nameclause . ") VALUES(" . $dataclause . ");";
	}
	
	return $out;
}

////////////////////////////////////////////////
//more complex again://////////////////////////

function MergeLimitingConditionsWithRSData($strLimitingConditions, $rsContext)
//take a limiting condition (such as a where clause or a join clause or a join followed by a where) and substitute in the 
//values from the recordset $rsContext, assuming it is an associative array of values. value replacements happen when a
//string of the form "$column_name" is found in $strLimitingConditions, and each such string is replaced by the value of columname from $rsContext
//may 25 2010 judas gutenberg
{

	//deal with $strLimitingConditions
	//$strLimitingConditions="";
	$bwlSimpleLimit=false;
	if($rsContext=="")
	{
		
		if(!contains($strLimitingConditions, "$"))
		{
			$bwlSimpleLimit=true;
		}
	}
	if($strLimitingConditions!=""  && $rsContext!=""  && !$bwlSimpleLimit)
	{
		if(beginswith(strtolower($strLimitingConditions), "join")  || beginswith(strtolower($strLimitingConditions), "left join")  || beginswith(strtolower($strLimitingConditions), "where"))
		{
			if(is_array($rsContext))
			{
				foreach($rsContext as $k=>$v)
				{
					//looks for tokens in the whereclause of the form $fieldname, and replaces them with values if they are found.
					$strLimitingConditions=str_replace("$" . $k, $v, $strLimitingConditions);
				}
			}
		}
		else
		{
			if(is_array($rsContext))
			{
				foreach($rsContext as $k=>$v)
				{
					//looks for tokens in the whereclause of the form $fieldname, and replaces them with values if they are found.
					$strLimitingConditions=str_replace("$" . $k, $v, $strLimitingConditions);
				}
			}
		}
	}
	//echo $strLimitingConditions . "^<BR>";
	if(!$bwlSimpleLimit  && !is_array($rsContext))
	{
		$strLimitingConditions="";
	}
	
	return $strLimitingConditions;
}


function TableExplanationToTableCreationSQL($strDatabase, $strTable, $bwlGuessPK=true, $bwlGuessAutoInc=true, $bwlFormat="")
//take a table explanation and turn it into create table sql
//$bwlFormat can be odbc or, if not, mysql
{
	$records=TableExplain($strDatabase, $strTable);
	if($bwlFormat=="odbc")
	{
		$strQS="[";
		$strQE="]";
	}
	else
	{
		$strQS="`";
		$strQE="`";
	}
	$thiskey="";
	$strSQL="CREATE TABLE " . $strQS .  $strTable . $strQE . " (\n";
	$columns=0;
	foreach($records as $record)
	{
		$columnname=$record["Field"];
		$bwlProbablePK=false;
		$bwlProbableAutoinc=false;
		if($columns==0  && (strtolower($columnname)=="id"  || strtolower($columnname)==strtolower($strTable) . "id"  || strtolower($columnname)==strtolower($strTable) . "_id"))
		{
			$bwlProbablePK=true;
		}
		if($bwlProbablePK)
		{
			$bwlProbableAutoinc=true;	
			 
		}
		if($bwlProbableAutoinc  && $bwlGuessAutoInc)
		{
			if($bwlFormat!="odbc")
			{
				$record["Extra"]="auto_increment";
			}
			else
			{
				$record["Extra"]="IDENTITY(1,1)";
			}
		}
		if($record["Extra"]=="auto_increment"  && $bwlFormat=="odbc")
		{
			$record["Extra"]="IDENTITY(1,1)";
		}
		$type=$record["Type"];
 		//echo $type  . " " . TypeParse($type, 0) . "*" .  inList("datetime date text",TypeParse($type, 0)) . "<BR>";
		$justtype=TypeParse($type, 0);
		if(inList("datetime date text smalldatetime",TypeParse($type, 0)))
		{
			$type=$justtype;
		}
		if(inList("smallmoney",TypeParse($type, 0)))
		{
			$type="DECIMAL(12,2)";
		}
		if(inList("smalldatetime",TypeParse($type, 0)))
		{
			$type="datetime";
		}
		$strNullString="NOT NULL";
		if(strtoupper($record["Null"])=="YES")
		{
			$strNullString="NULL";
		}
 
		if(strtoupper($record["Key"])=="PRI" ||($bwlProbablePK  && $bwlGuessPK))
		{
			$thiskey=$thiskey . "," . $columnname;
			
		}
		if($bwlFormat=="odbc"  && inList("integer int tinyint bigint", $justtype))
		{
			$type=$justtype;
		}
		if($bwlFormat=="odbc" && $justtype=="date")
		{
			$type="datetime";//evidently type date was not added until sql server 2008, which i dont have
		}
		$extra=$record["Extra"];
		$thisLine=$strQS . $columnname . $strQE . " " .  $type . " " . $strNullString . " " . $extra . ",\n";
		$strSQL.=$thisLine;
		$columns++;
	}
	$strSQL=RemoveEndCharactersIfMatch($strSQL, "\n");
	$strSQL=RemoveEndCharactersIfMatch($strSQL, ",");
	if($thiskey!="")
	{
		if($bwlFormat!="odbc")
		{
			$keystring="PRIMARY KEY(". RemoveEndCharactersIfMatch($thiskey, ",") . ")";
		}
		else
		{
			//leave this out for now
			//$keystring="CONSTRAINT pkconst_". $strTable . " UNIQUE(" . $thiskey . ")";
		}
		$strSQL.=IFAThenB($keystring, ",\n"). $keystring;
	}
	$strSQL.="\n)\n";
	return $strSQL;
}


function PKLookup($strDatabase, $strTable, $bwlGuessIfNotThere=false)
//Looks up the PK for a table.
{
	$fieldcount=0;
	$records=TableExplain($strDatabase, $strTable);
	foreach ($records as $record)
	{
		
		$fieldname=$record["Field"];
		
		if ($record["Key"]=="PRI")
		{
			$out.= " ". $fieldname;
		}
		else if($bwlGuessIfNotThere)
		{
			$lfield=strtolower($fieldname);
			$lstrTable=strtolower($strTable);
			if($lfield==$lstrTable . "id"  || $lfield==$lstrTable . "_id"  || $lfield=="id"  || contains($lfield, "code")  && $fieldcount==0)
			{
				return $fieldname;
			}
		}
		$fieldcount++;
	}
	return trim($out);
}

function WadeAcrossRelationToGetOtherTableInfo($strDatabase, $commontablename, $tablestart)
{
	//A mapping table should have to entries in tf_relation. one goes to $tablestart and the other will go to some mystery table. we want the name of that mystery table. in the returned array it will be keyed to f_table_name and its PK should be keyed to f_column_name
	$sql=conDB();
	$strSQL="SELECT * FROM " .  tfpre . "relation WHERE table_name='" .$commontablename . "' AND relation_type_id='0' AND f_table_name!='" . $tablestart . "'";
	//echo $strSQL;
	$records = $sql->query($strSQL);
	echo mysql_error();
	$record=$records[0];
 
	return $record; 
}

function WadeAcrossRelationToGetOtherColumnName($strDatabase, $commontablename, $column_name_start)
{
	//In a mapping table, the best description of an individual mapping record from the perspective of the item being mapped is not that item's column name in the relationship, but the column name of the other item in the mapped relationship.  think hater/hatee, master/slave, lawyer/client.  Though an item is referred to with a "client_id" in a hypothetical lawyership mapping table, the things listed in an associated items list for that item that were found in the mapping table are not clients, they are lawyers.
	$sql=conDB();
	$strSQL="SELECT * FROM " .  tfpre . "relation WHERE table_name='" .$commontablename . "' AND relation_type_id='0' AND column_name!='" . $column_name_start . "'";
	//echo $strSQL;
	$records = $sql->query($strSQL);
	$record=$records[0];
	$thisColumnName=gracefuldecay($record["column_name"],$column_name_start) ;
	return $thisColumnName;//if we didn't find anything in the wade we'll just make do with what we had.
}

function LimitedOptionList($strDatabase,  $strThisPKValue, $strMappingTable, $strFKMapPointingBack,  $strOurTable="", &$strFKMapPointingOut="", &$strDistantLimitedTableName="", &$strPKDistantTable="", $strType="checkboxes",  $strPrefix="")
//for cases where you just want a set of checkboxes to represent items in a table mapping this table to some distant one.
//example of use:  LimitedOptionList(our_db,58, "ARTICLE_CATEGORY", "ARTICLE_ID", "ARTICLE", "CATEGORY_ID", "CATEGORY", "ID","checkboxes", "");
//produces a checkbox list of every record in CATEGORY with the items found in the ARTICLE_CATEGORY mapping table 
//linking back to an ARTICLE_ID of 58 checked off.
//judas gutenberg cinquo de mayo 2010
{
	$out="";
	$sql=conDB();
	if($strDistantLimitedTableName==""  || $strFKMapPointingOut=="")//making it hard on me by not passing in the remote table.  fortunately this is information we can deduce
	{
		 
		$record = WadeAcrossRelationToGetOtherTableInfo($strDatabase, $strMappingTable, $strOurTable);
		$strDistantLimitedTableName=$record["f_table_name"];
		$strPKDistantTable=$record["f_column_name"];
		if($strFKMapPointingOut=="")
		{
			$strFKMapPointingOut=$record["column_name"];
		}
	}
 
	if($strPKDistantTable=="")
	{
		$strPKDistantTable=PKLookup($strDatabase, $strDistantLimitedTableName);
	}
	if( $strPrefix=="")
	{
		$name=qpre . "|extratable|" .  $strMappingTable . "|" .  $strFKMapPointingBack  . "|" . $strFKMapPointingOut . "|" . $strThisPKValue;
	}
	//ideally some day i'll centralize the finding of name fields but until then:
	$strNameField=firstnonidcolumname($strDatabase, $strDistantLimitedTableName);
	$strSQL="SELECT * FROM " .$strDatabase . "." .  $strDistantLimitedTableName . " ORDER BY " .$strNameField ;
	//echo $strSQL;
	$records = $sql->query($strSQL);
	$strDelimiter="<br/>\n";
	$encapsbeg="";
	$encapsend="";
	if(contains($strType,"horiz"))
	{
		$strDelimiter="&nbsp;&nbsp;&nbsp;\n";
		$encapsbeg="<nobr>";
		$encapsend="</nobr>";
	}
			
	foreach($records as $record)
	{
		//$return=GenericDBLookup($strDatabase, $strMappingTable, $strFKMapPointingOut, $record[$strPKDistantTable], $strFKMapPointingBack , true, true);
		//ArrayToWhereClause($arrSpec);
		$return=GenericDBLookupWhere($strDatabase, $strMappingTable,ArrayToWhereClause(Array($strFKMapPointingBack=>$strThisPKValue, $strFKMapPointingOut=>$record[$strPKDistantTable])) ,  $strFKMapPointingBack);
		//echo $return . "<BR>";
		$bwlChecked= ($return!="");
		$label=LabelForID($strDatabase,$strDistantLimitedTableName,  $strPKDistantTable, $record[$strPKDistantTable],"");
		if(contains($strType,"checkboxes"))
		{

			$out.= "\n" . $encapsbeg . CheckboxInput($name, $record[$strPKDistantTable],$bwlChecked) . $label . $strDelimiter . $encapsend;
		}
	
	}
	return $strDelimiter . $out;
}

function DelimitedStringToOrderBySubclause($in)
{
	if(contains($in, " "))
	{
		$arrIn=explode(" ", $in);
		
		$arrIn=array_reverse($arrIn);
		$out=join(",", $arrIn);
	}
 	else
	{
		$out=$in;
	}
	return $out;
}

?>