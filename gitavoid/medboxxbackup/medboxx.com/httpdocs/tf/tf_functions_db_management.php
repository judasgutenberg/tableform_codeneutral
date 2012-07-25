<?php 

function ReschemeTableForData($strDatabase, $strTable, $intPercentageExpansionRoom=30, $intMinRecordsToEstablishPattern=10)
{
//looks at the data in a table and changes the types of the columns to better conform to the range of data it finds in them
	$sql=conDB();
	$arrInfo=TableDataRange($strDatabase, $strTable);
	$intRecordCount=countrecords($strDatabase,$strTable);
	foreach($arrInfo as $arrThis)
	{
		$column=$arrThis["column"];
		$min=$arrThis["minval"];
		$max=$arrThis["maxval"];
		$minsize=$arrThis["minsize"];
		$intNonnullsCount=$arrThis["nonnulls"];
		$type=$arrThis["type"];
		$defacto_type=$arrThis["defacto_type"];
		
		$defactotypename=TypeParse($defacto_type, 0);
		//echo $defacto_type . " " . $defactotypename . "<BR>";
		$defactosize=TypeParse($defacto_type, 1);
		$defactodecimal="";
		if(contains($defactosize, ","))
		{
			$arrDefactosize=explode(",", $defactosize);
			$defactodecimal=$arrDefactosize[1];
			$defactosize=$arrDefactosize[0];
		}
 
 		if($minsize==$defactosize && $intRecordCount>=$intMinRecordsToEstablishPattern)
		{
			$maxlengthtouse=intval($defactosize);//don't create rom for expansion in very uniform columns
		}
		else
		{
			$maxlengthtouse=intval($defactosize) + intval($defactosize*($intPercentageExpansionRoom/100)); 
		}
		if($defactotypename=="bit")
		{
			$defactotypename="tinyint";
		}
		if($defactotypename=="int")
		{
			$maxlengthtouse=11;
		}
		//if($defactotypename=="float")
		{
			//$maxlengthtouse="10";
		}
		if($defactotypename=="varchar" && $maxlengthtouse>250)
		{
			$defactotypename="text";
			$maxlengthtouse="";
		}
		$typeSQL=TypeSQL($defactotypename, $maxlengthtouse, $defactodecimal);
		
		if($defactosize>0  && $defacto_type!="" && trim($typeSQL)!=trim($type))
		{
			$strAlterSQL="ALTER TABLE " . $strDatabase . "." .    $strTable . " CHANGE COLUMN " . $column . " " . $column . " " .  $typeSQL . " default NULL";
			//echo $strAlterSQL . "<BR>";
			$records=$sql->query($strAlterSQL);
			$error=sql_error();
			///echo $error . "<BR>";
			$out=$out . $error . IfAThenB($error, "<br>\n");
		}
	}
	return $out;
}
	
function TableDataRange($strDatabase, $strTable)
{
//returns a pseudo-recordset containing information about the data in a table

	$sql=conDB();
	$arrOut="";
	$strSQL="SELECT * FROM " . $strDatabase . "." .  $strTable;
	$records=$sql->query($strSQL);
	$arrMax=Array();
	$arrMin=Array();
	$arrSum=Array();
	$arrMaxSize=Array();
	$arrMinSize=Array();
	$arrAfterDecimal=Array();
	$arrHasbeenNumeric=Array();
	$arrHasbeenInteger=Array();
	$arrHasbeenDatetime=Array();
	$arrHasbeenDate=Array();
	$arrHasbeenBool=Array();
	$arrKeys=Array();
	$arrNonNullValues=Array();
	$arrVals=Array();
	$keycount=0;
	$rowcount=0;
	if(count($records)==0)
	{
		$records=TableFieldsAsBlankRS($strDatabase, $strTable);
	}
	foreach($records as $record)
	{	
		$rowcount++;
		foreach($record as $k=>$v)
		{
			//echo $k . " " . $v . "<BR>";
			
			if($v!="")
			{
				if(array_key_exists($k, $arrNonNullValues))
				{
					$arrNonNullValues[$k]++;
				}
				else
				{
					$arrNonNullValues[$k]=1;
				}
			}
			if(!in_array( $k,$arrKeys))
			{
				$arrKeys[$keycount]=$k;
				$keycount++;
			}
			if(is_numeric($v))
			{
				if(!is_array($arrVals[$k]))
				{
					$arrVals[$k]=Array();
				}
				$arrVals[$k][$rowcount]=$v;
				//echo $arrVals[$k][$rowcount] . "<BR>";
				
				//echo "!";
				if(!array_key_exists($k,$arrSum))
				{
					$arrSum[$k]=$v;
				}
				else
				{
					$arrSum[$k]+=$v;
				}
				$strV=strval($v);
				$arrNumeric=explode(".", $strV);
				if(count($arrNumeric)>1)
				{
					$decimalpart=$arrNumeric[1];
					$intLenDecimalPart=strlen($decimalpart);
					if(array_key_exists($k, $arrAfterDecimal))
					{
						if($intLenDecimalPart>$arrAfterDecimal[$k])
						{
							$arrAfterDecimal[$k]=$intLenDecimalPart;
						}
					}
					else
					{
						$arrAfterDecimal[$k]=$intLenDecimalPart;
					}
				}
	
				if(array_key_exists($k, $arrHasbeenNumeric))
				{
					if(array_key_exists($k, $arrMax))
					{
						if($arrMax[$k]<$v)
						{
							$arrMax[$k]=$v;
						}
					}
					else
					{
						$arrMax[$k]=$v;
					}
					if(array_key_exists($k, $arrMin))
					{
						if($arrMin[$k]>$v)
						{
							$arrMin[$k]=$v;
						}
					}
					else
					{
						$arrMin[$k]=$v;
					}
				}
				else
				{
					$arrHasbeenNumeric[$k]=true;
					$arrMax[$k]=$v;
					$arrMin[$k]=$v;
				}
				if(intval($v)==$v  && !contains(strval($v), ".") && !beginswith(strval($v), "0"))//this test seems kind of dumb, but int_val fails for some reason
				{
					//echo $k . " ";
					if(!array_key_exists($k, $arrHasbeenInteger))
					{
						$arrHasbeenInteger[$k]=true;
					}
				}
				else
				{
					$arrHasbeenInteger[$k]=false;
				}
			}
			else
			{
				if($v!="")
				{
					$arrHasbeenNumeric[$k]=false;
					$arrHasbeenInteger[$k]=false;
				}
			}
			if(IsMySQLDate($v))
			{
					if(!array_key_exists($k, $arrHasbeenDate))
					{
						$arrHasbeenDate[$k]=true;
					}
			}
			else
			{
				$arrHasbeenDate[$k]=false;
			}
			if(IsMySQLDateTime($v))
			{
					if(!array_key_exists($k, $arrHasbeenDatetime))
					{
						$arrHasbeenDatetime[$k]=true;
					}
			}
			else
			{
				$arrHasbeenDatetime[$k]=false;
			}
			$len=strlen($v);
			if(array_key_exists($k, $arrMaxSize))
			{
				if($len>$arrMaxSize[$k])
				{
					$arrMaxSize[$k]=$len;
				}
			}
			else
			{
				$arrMaxSize[$k]=$len;
			}
			
			if(array_key_exists($k, $arrMinSize))
			{
				if($len<$arrMinSize[$k]  && $len>0)
				{
					$arrMinSize[$k]=$len;
				}
			}
			else if($len>0)
			{
				$arrMinSize[$k]=$len;
			}
		}
	}
	$arrThis=Array();
	$outcount=0;
	$pk=PKLookup($strDatabase, $strTable, true);
	foreach($arrKeys as $thiskey)
	{
		//echo var_dump($arrVals[$thiskey]) . "<P>";
		sort($arrVals[$thiskey]);
		$rawtype=GetFieldType($strDatabase,$strTable, $thiskey);
	
		$arrThis["column"]=$thiskey;
		
		$arrThis["foreign_refs"]="";
		$arrThis["primary_refs"]="";
		$strSQL="SELECT * FROM " . $strDatabase . "." . tfpre . "relation WHERE f_table_name='" . $strTable . "' AND f_column_name='" . $thiskey . "'";
		$foreignrecords = $sql->query($strSQL);
		foreach($foreignrecords as $thisrecord)
		{
			$arrThis["primary_refs"].=$thisrecord["table_name"].  "." . $thisrecord["column_name"] . ":" .  $thisrecord["relation_id"];
		}
		$strSQL="SELECT * FROM " . $strDatabase . "." . tfpre . "relation WHERE table_name='" . $strTable . "' AND column_name='" . $thiskey . "'";
		$primaryrecords = $sql->query($strSQL);
		
		foreach($primaryrecords as $thisrecord)
		{
			$arrThis["foreign_refs"].=$thisrecord["f_table_name"].  "." . $thisrecord["f_column_name"]. ":" .  $thisrecord["relation_id"];
		}
		
		//$arrThis["decimalpoints"]=$arrAfterDecimal[$thiskey];
		$arrThis["minval"]=$arrMin[$thiskey];
		$arrThis["maxval"]=$arrMax[$thiskey];
		
		$arrThis["median"]="";
		$arrThis["mean"]="";
		$arrThis["stand_dev"]="";
		if($rowcount>0 && $arrThis["maxval"]>0)
		{
			$arrThis["mean"]=number_format ($arrSum[$thiskey]/$rowcount,3);
			if($rowcount/2==intval($rowcount/2))
			{
				$arrThis["median"]=($arrVals[$thiskey][1+intval($rowcount/2)] + $arrThis["median"]=$arrVals[$thiskey][1+intval($rowcount/2)])/2;
			}
			else
			{
				$arrThis["median"]=$arrVals[$thiskey][intval($rowcount/2)+1];
			}
			$arrThis["stand_dev"]=number_format(StandardDeviation($arrVals[$thiskey], $arrSum[$thiskey]/$rowcount),3);
		}
		
		$arrThis["nonnulls"]=gracefuldecaynumeric($arrNonNullValues[$thiskey],0);
		$arrThis["no_nulls"]=false;
		 if($rowcount==$arrThis["nonnulls"])
		{
			$arrThis["no_nulls"]=true;
		}
		//$arrThis["maxlength"]=parseBetween($rawtype, "(", ")");
		//$arrThis["maxlength"] =TypeParse($rawtype, 1);
		
		//$arrThis["type"]=parseBetween($rawtype, "", "(");
		$arrThis["minsize"] =$arrMinSize[$thiskey]; 
		$arrThis["maxsize"] =$arrMaxSize[$thiskey]; 
		$arrThis["type"] =$rawtype;
		$strTypeName=TypeParse($rawtype,0);
		if($arrHasbeenDatetime[$thiskey]  && $arrThis["nonnulls"]>0)
		{
			$defacto_typename="datetime";
		}
		else if($arrHasbeenDate[$thiskey]  && $arrThis["nonnulls"]>0)
		{
			$defacto_typename="date";
		}
		else if($pk!=$thiskey && ($arrHasbeenInteger[$thiskey] && abs($arrThis["minval"])<2  && abs($arrThis["maxval"])<2)  &&  $arrHasbeenInteger[$thiskey])
		{
			$defacto_typename="bit";
		}
		else if($arrHasbeenInteger[$thiskey])
		{
			$defacto_typename="int";
		}
		else if($arrHasbeenNumeric[$thiskey])
		{
			if(inList("varchar char text", $strTypeName))//whatever it was before but decimal if some form of varchar
			{
				$defacto_typename="decimal";
			}
			else
			{
				$defacto_typename=$strTypeName; 
			}
		}
		else if($arrThis["maxsize"]<250)
		{
			$defacto_typename="varchar";
		}
		else 
		{
			$defacto_typename="text";
		}
		if($arrMaxSize[$thiskey]==0)
		{
			$defacto_typename=$strTypeName; //allow that unpopulated columns are what the original definition called for
			$arrMaxSize[$thiskey]=1;
		}
		$arrThis["defacto_type"]=TypeSQL($defacto_typename,  $arrMaxSize[$thiskey] , $arrAfterDecimal[$thiskey]);
		$arrOut[$outcount]=$arrThis;
		$outcount++;
	}
	return $arrOut;
}


function IsMySQLDateTime($strIn)
{
	if($strIn=="")
	{
		return true;
	}
	$intLen=strlen($strIn);
	if($intLen==19)
	{
		//echo date("Y", strtotime($strIn)) . " ";
		$thisdate= strtotime($strIn);
		if(intval(date("Y", $thisdate))>1970 || intval(date("n", $thisdate))>1 || intval(date("j", $thisdate))>1)
		{
			return true;
		}
	}
	return false;
}

function IsMySQLDate($strIn)
{
	if($strIn=="")
	{
		return true;
	}
	$intLen=strlen($strIn);
	if($intLen==10)
	{
		//echo date("Y", strtotime($strIn)) . " ";
		$thisdate= strtotime($strIn);
		if(intval(date("Y", $thisdate))>1970 || intval(date("n", $thisdate))>1 || intval(date("j", $thisdate))>1)
		{
			return true;
		}
	}
	return false;
}


function EliminateDuplicates($strDatabase, $strTable, $strIrrelevantField)
{
//eliminates dupes in a table where an autoincPK ($strIrrelevantField) is all that distinguishes between otherwise identical rows
//favors rows with lower autoincPKs
//Judas Gutenberg September 6 2009
	$errors="";
	$sql=conDB(); 
	$delcount=0;
	$strSQL="SELECT * FROM " . $strDatabase . "." . $strTable . " ORDER BY " . $strIrrelevantField . " ASC";
	//echo $strSQL . "<BR>";
	$records = $sql->query($strSQL);
	

	$pkvaluelist="";
	foreach($records as $record)
	{
		$subset=Array();
		foreach($record as $k=>$v)
		{
			if($k!= $strIrrelevantField)
			{
				$subset[$k]=$v;
			}
		}
		$strWhereClause= " AND " . ArrayToWhereClause($subset);
	
	 	$pkvalue=$record[$strIrrelevantField];
		//echo $pkvaluelist . "==<br>";
		if(!inList($pkvaluelist, $pkvalue))
		{
			
			$strSQL="SELECT  *," . $strIrrelevantField . " FROM " . $strDatabase . "." . $strTable . "  WHERE " . $strIrrelevantField . "!='" . $pkvalue . "'" . $strWhereClause;
			//echo $strSQL . "<BR>";
			$rrecords = $sql->query($strSQL);
			//echo mysql_error();
			foreach($rrecords as $rrecord)
			{
				//echo "-|";
				//echo $rrecord["table_name"] . "<br>";
				$delpk=$rrecord[$strIrrelevantField];
				$strSQL="DELETE FROM " . $strDatabase . "." . $strTable . "  WHERE " . $strIrrelevantField . "='" .  $delpk . "'";
				
				$pkvaluelist.=" " . $delpk;
				$delcount++;
				$sql->query($strSQL);
				//echo $strSQL . "<BR>";
				$thiserror= sql_error();
				$errors.=IfAThenB($thiserror,"<br/>")  . $thiserror;
			}
		}
		$thiserror= sql_error();
		$errors.=IfAThenB($thiserror,"<br/>")  . $thiserror;
	}
	$errors .="<br/>" . $delcount . " " . PluralizeIfNecessary("item", $delcount) . " deleted.";
	return $errors;
}

function TotalDelete($strDatabase, $strTable, $strPK, $strPKColumn="")
//December 26 2007 - deletes a row and then all related rows following the contents of the relation table.
{
	$sql=conDB();
	if($strPKColumn=="")
	{
		$strPKColumn=PKLookup($strDatabase, $strTable);
	}
	$out="";
	$strSQL="DELETE FROM " . $strDatabase . "." . $strTable . " WHERE " . $strPKColumn . "='" . $strPK . "'";
	$records = $sql->query($strSQL);
	if(sql_error()=="")
	{
		$out.="A row was deleted from the " . $strTable . " table in the " . $strDatabase . ".<br/>";
	}
	$strSQL="SELECT * FROM " . $strDatabase . "." . tfpre . "relation WHERE f_table_name='" . $strTable . "' AND f_column_name='" . $strPKColumn . "'";
	//echo $strSQL  ."<br>";
	if(CanChange())
	{
		$records = $sql->query($strSQL);
	}
	else
	{
		$out.=  "Database is read-only.<br/>";
	} 
				
	$records = $sql->query($strSQL);
	foreach($records as $record)
	{
		$thistable=$record["table_name"];
		$thiscolumn=$record["column_name"];
		if($strPK!=0)
		{
			$strSQL="DELETE FROM " . $strDatabase . "." . $thistable . " WHERE " . $thiscolumn . "='" . $strPK . "'";
			//echo $strSQL  ."<br>";
			if(CanChange())
			{
				$records = $sql->query($strSQL);
				if(sql_error()=="")
				{
					$out.="Rows were deleted from the " . $thistable . " table in the " . $strDatabase . ".<br/>";
				}
			}
			else
			{
				$out.=  "Database is read-only.<br/>";
			} 
			
		}
	}
	return $out;
}

function StandardDeviation($arrIn, $mean)
{
	$sqrsum=0;
	$count=count($arrIn);
	foreach($arrIn as $thisval)
	{
		$sqrsum+=pow(($thisval-$mean),2);
	
	}
	$dev=sqrt($sqrsum/($count-0));
	return $dev;
}

function NewRelation($strDatabase, $linkertable, $linkerfield, $linkeetable, $linkeefield, $type=0)
{
//creates a new relation if one matching the spec doesn't exist
	$sql=conDB();
	$out="";
	$strExistSQL="SELECT table_name FROM " . $strDatabase . "." .  tfpre . "relation WHERE table_name='" . $linkertable . "' AND column_name='" . $linkerfield . "' AND f_table_name='" . $linkeetable . "' AND f_column_name='" . $linkeefield . "' AND relation_type_id='" . $type . "'";
	//echo  "<br>" .$strExistSQL . "<br>";
	$tables = $sql->query($strExistSQL);
	$out.= sql_error();
	//echo count($tables) . "<br>";
	if(count($tables)<1)
	{
		$strSQL="INSERT INTO " . $strDatabase . "." .  tfpre . "relation(table_name, column_name, f_table_name, f_column_name, relation_type_id) VALUES ('" .  $linkertable . "','" . $linkerfield  ."','" .  $linkeetable . "','" . $linkeefield  ."'," . $type .");";
		$tables = $sql->query($strSQL);
		$out.= sql_error();	
	}
	else
	{
		$out.= "Needed relation already exists:" . $linkertable . "." .$linkerfield . "->" . $linkeetable . "." . $linkeefield . ":" . $type;
	}
	//echo $out;
	return $out;
}

function PercentageOfNotNullsInTable($strDatabase, $strTable)
{
//September 14, 2008
//this function is, of necessity, super expensive!
//returns an associative array of percentages of not nulls for each field
//so you can tell the relative utility of the fields in actual practice
	$sql=conDB();
	$records = TableExplain($strDatabase, $strTable);
	$arrOut=Array();
	$total=countrecords($strDatabase, $strTable);
	foreach ($records as $k => $info)
	{
		$strField= $info["Field"];
		$strSQL="SELECT count(" . $strField .") AS result FROM " . $strDatabase . "." .  $strTable . " WHERE " . $strField . "!=\"\"";
		//echo $strSQL . "<br>";
		$records = $sql->query($strSQL);
		$record=$records[0];
		$val=$record["result"];
		//$total=$record["total"];
		if($total>0)//don't divide by zero
		{
			$percent=intval($val/$total * 100);
		}
		else
		{	
			$percent=0;
		}
		
		if (!is_numeric($percent)  || $percent=="")
		{
			$percent="0";
		}
		$arrOut[$strField]=$percent;
	}
	return $arrOut;
}
?>