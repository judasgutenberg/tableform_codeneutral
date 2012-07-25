<?php
//Judas Gutenberg 2007
//the save function for tableform
//This code is covered under the GNU General Public License
//info here: http://www.gnu.org/copyleft/gpl.html
//the digest is as follows: you cannot modify this code without
//publishing your source code under the same license
//contact the developer at gus@asecular.com  http://asecular.com

function SaveForm($strDatabase, $strTable, $strPKField, &$strValDefault, $strConfigBehave, $strUser="", $arrPK="")
//saves a form in the database and table, assuming all the form items have the names of the fields.
//skips fields beginning with qpre so I can pass data through without attempting to stuff it in the db.
//however, if it begins with  qpre  and ends with |day, |month, or |year, then we need to do special things because it is a date
//also handles file uploads having names of the form " . qpre . "u|FILENAME for which FILENAME is the corresponding field
//in the database.  
{
	//echo $strPKField . "<p>";
	//logform();
 	$sql=conDB();
	$serializeddone="";
	$dataadded=0;
	$oldkey="";
	$strSuperPre=qpre;
	$arrUpdate=array();
	$strSQL="";
	$strPKSQL="";
	$builtjs="";
	$bwlSuperAdmin=IsSuperAdmin($strDatabase, $strUser);
	$bwlSuperUser=IsSuperUser($strDatabase, $strUser);
	$strExistsSQL="";
	$arrTransSpec=Array();
	$arrTranslation=Array();
	$needtoencryptonsave=$_POST[$strSuperPre . "needtoencryptonsave"];
	//echo "-" . $needtoencryptonsave . "-";
	$hasauto=hasautocount($strDatabase, $strTable);
	$nowdatetime=date("Y-m-d H:i:s");
 	$inforecords=GetExtraColumnInfo($strDatabase, $strTable);
	//echo "-" . $hasauto . "-";
	//echo is_array($arrPK) . "==isarray";
	//echo $strValDefault;
	//die(is_array($arrPK) . "--");
 	if(is_array($arrPK))//sorta hacky!!!
	{
 
		//$strPKField="";//a little too hacky if you ask me
		$strValDefault="";
	}
	foreach ($_POST as $k=>$v)
	{
		if(contains($k, "!"))
		{
			$arrLanguageInfo=explode("!", $k);
			$languageid=$arrLanguageInfo[1];
			$thistransfield=$arrLanguageInfo[0];
			$arrTransSpec[count($arrTransSpec)]=Array("language_id"=>$languageid, "field_name"=>$thistransfield, "table_name"=>$strTable);
			$arrTranslation[count($arrTranslation)]=Array("translation_value"=>$v);
		}
		else
		{
			if (contains($strConfigBehave, "updateopener"))
			{
				$builtjs.="\nif(opener.document.BForm['ret_" . $k . "'])
				\n{\nopener.document.BForm['ret_" . $k . "'].value='" . $v . "';\n}\n";
				
	
			}
			$isDate=false;
			//echo $k . " " . $v . "<br>\n";
			//looking to see if this item is perhaps a date
			if (beginswith($k, qpre))
			{
				
				//$arrPossibleDateName=explode( "|", $k);
				if (strpos($k, "|")>1) //then it might be a date input
				{
					//" . qpre . "a is for handback prettyname form inputs
					//" . qpre . "u is for $_FILES
					//we want to eliminate both of those
					$strPossibleDateName=parseBetween($k, qdelimiter, "|");
					if  (!inList("a u ux serialized", $strPossibleDateName))
					{
						$day=$_POST[$strSuperPre . $strPossibleDateName . "|day"   ];
						$month=$_POST[$strSuperPre . $strPossibleDateName . "|month" ];
						$year=$_POST[$strSuperPre . $strPossibleDateName . "|year" ];
						//echo "<br>#" . $strSuperPre  . $arrPossibleDateName[1] . "|year"; 
						//echo "<br>*".  $month . "-" . $day . "-" . $year . "*<br>";
			
			 			$strTime=ReasonableStringDate($month, $day, $year);
						//echo $strTime . "<br>";
						$v=$strTime; //just turning the value into a PHP timestamp
						$k=$strPossibleDateName;  //just turning the key back to a conventional key for the next section
						$isDate=true;  //i use this to make sure there are quotes around a date, which are necessary for some reason
					}
					else if (beginswith($k, qpre . "serialized|")   )//might be our fancy new serialized data form system!
					{
						$v= ReadSerializedForm($k, $serializeddone, $v);
						
					
					}
					
				}
				
			}
	
			if (!beginswith($k, qpre)  && strpos($k, "X_FILE_SIZE")<1 ) //here we're eliminating hidden variables i need to pass for bookkeeping
			{
			
				
	
				//echo var_dump($inforecord);
				//echo $k . "<br>";
				//handle any file uploads:
				//where i read in the files and copy them to their proper places if there are file uploads
				if ($_REQUEST[qpre . "ux|" . $k]!="")
				{
					$v="";
					//$destpath=fieldNameToFolderPath( $k, imagepath)  . $_REQUEST[qpre . "u|" . $k];
					//if(file_exists($destpath))
					//{
						//dont worry about the uploaded file
						//unlink($destpath);
					//}
				
				}
				else if ($_FILES[qpre . "u|" . $k]["name"]!="")
				{
				//NASTY hack that assumes tf code is always in the root directory.  this is a mess!:
					if(tf_dir!="")
					{
						$strTFDirtouse=tf_dir;
						if (beginswith(tf_dir, "/"))
						{	//echo $_SERVER['PHP_SELF'];
							$arrRootPath=explode("/", $_SERVER['PHP_SELF']);
							$strTFDirtouse="";
							for($i=3; $i<count($arrRootPath); $i++)
							{
								$strTFDirtouse.="../";
							}
						}
					}
					$destpath=fieldNameToFolderPath( $k, $strTFDirtouse . imagepath)  . $_FILES[qpre . "u|" . $k]['name'];
					//echo "------" . $destpath;
					if (!BuildPathPiecesAsNecessary($destpath))
					{
						$out.="The path " .$destpath . " could not be built.<br>";
					}
					//ini_set("safe_mode_gid",0);
					//ini_set("safe_mode",0);
					//echo $destpath . " - " . $_FILES[ qpre . "u|" . $k]['tmp_name'] . "-<br>";
				 	//error_reporting(E_ALL);
					//echo $destpath;
					if(beginswith($destpath, "/"))
					{
						//hacky hacky hack hack, thanks a lot php!
						$destpath=$_SERVER["DOCUMENT_ROOT"]. $destpath;
					}
					if (move_uploaded_file($_FILES[ qpre . "u|" . $k]['tmp_name'], $destpath))
					{
					
						chmod($destpath, 0777);
						$out.="The file " . $destpath . " was uploaded successfully.<br/>";
						//if we have a successful upload that put the new name in the db
						$v=$_FILES[qpre . "u|" . $k]['name'];
					}
					else
					{
						$out.="The file " . $destpath . " failed to upload.<br/>";
					}
			 	}		
				//if ($v!="")  //this was causing "none"-selected dropdown things not to save
				                                                                                               
		
			 	if ($v=="[multi-placeholder]")
				{                                                                 
					 $v = $_POST[qpre . "multi"];
				
				}

	 
				
				//echo $oldkey . " " . $k . "=" .  $v . "**" . intval($v)  . "^^" . $v .  "===<br>\n";
				if($k!=$oldkey) //keeps dup fields out of sql when dates are saved                                                                      
				{
					//echo  '$k!=$oldkey:' . $k .  " " . $v . "<br>";
					//the following reencrypts an xcart password if necessary
					if(inList($needtoencryptonsave, $k))
					{           
						$v=xcartpwdencrypt($v);	
	
					}
	
					$strType=TypeParse(GetFieldType($strDatabase, $strTable, $k),0);
					 
					if (strtolower($strType)=="decimal")
					{
						 $v=ClearNumeric($v);
					}
					elseif (strtolower($strType)=="date")
					{
					}
					elseif  (strtolower($strType)=="datetime")
					{
						$v = DateTimeForMySQL($v);
					}
	
					if (!inList($strPKField, $k) || is_array($arrPK)  || !is_numeric($v) || !$hasauto)//just added the hasauto clause 9/15/2008
					{
						//echo $k . " " . $v . " ". "##<br>";
						$strRSQL=  $k . "='" . htmlcodify($v) . "'";
					}
				
					if (!inList($strPKField,$k)  ||  !is_numeric($v) || !$hasauto) //in this system with no compound PKs, the primary key is useless in establishing the existance of an identical row.  the is_string part is to disregard this logic in the few cases where the PK is a string.  such tables are not proper tf style tables but they exist and we want to be able to edit them with tf //just added hasuauto clause 10/17/2008
					{
						//echo $strExistsSQL . "##<br>";
						$strExistsSQL.=$strRSQL . " AND " ;
					}
					
					//the hasauto clause is important for cases where there is a numeric PK with no autoincrement
					if(!inList($strPKField,$k) || is_array($arrPK ) ||  !is_numeric($v) || !$hasauto)  //just added the hasauto clause 9/15/2008
					{
						//echo $strPKField . "==pkfield..." .  $strRSQL  . "==RSQL--**" . $k . "==key<br>";
						if($strRSQL!="")
						{
							$strSQL.=$strRSQL . ",";
						}
					}
					else //this is an experiment....
					{
					 
						//echo $strPKField . "==pkfield, " . $k . "==k<br>";
						if($strRSQL!=""  && contains($strRSQL, $k . "=") )
						{
							//echo $strRSQL . "<br>";
							$strPKSQL.=$strRSQL . ",";
						 
						}
					}
				
					$dataadded++;
				}
				$oldkey=$k;  //i do this to keep dates from trying to put the same field into the db three times
				//echo $k . " " . $v. "<br>";
				
				
			}
		}
		
	}
	foreach($inforecords as $inforecord)
	{
		//echo $inforecord["datecreated"]. "-" . $inforecord["datemodified"] . "-" . $inforecord["column_name"] ;
 		if($inforecord["datecreated"]==1  && $_POST[qpre . "oldid"]==""  && !is_array($arrPK) || $inforecord["datemodified"]==1) 
		{
			$strSQL.=$inforecord["column_name"] . "='" . $nowdatetime . "',";
		}
	}
				
	//echo $strSQL .  "<br>==" .  $strPKSQL .  "++<P>";
	//remove last comma and " and "
	$strSQL=RemoveLastCharacterIfMatch($strSQL, ",");
	$strPKSQL=RemoveLastCharacterIfMatch($strPKSQL, ",");
	$strExistsSQL=substr($strExistsSQL, 0, strlen($strExistsSQL)-5);
	//echo count($arrPK);
	//foreach($arrPK as $k=>$v)
	//{
		//echo $k . " " . $v . "==pkstuff<br>";
	//}
	
	if(is_array($arrPK))
	{
		$strExistsSQL="SELECT * FROM " . $strDatabase . "." .  $strTable . " WHERE " . ArrayToWhereClause($arrPK);
	}
	else
	{
		$strExistsSQL="SELECT * FROM " . $strDatabase . "." .  $strTable . " WHERE " . 	$strExistsSQL;
	}
	//echo "<br>" . $strExistsSQL . "<br>";
	if($_POST[qpre . "oldid"]==""  || is_array( $arrPK))//this might have to be examined -- the decision to skip this test of arrPk is set
	{
		$rs=$sql->query($strExistsSQL);
	}
	if (count($rs)<1)
	{
		$strSQL.=IFAThenB($strPKSQL, ", ") . $strPKSQL;
	}
	//echo  count($rs) . "==countrs<br>";
	if (!is_array($rs) || count($rs)<1  || is_array($arrPK))
	{
	
		$bwlBeginsWithTF=beginswith($strTable,  tfpre) && inList(superusertables, $strTable) ;
		if (($bwlBeginsWithTF &&  $bwlSuperAdmin) || !$bwlBeginsWithTF  || ($bwlBeginsWithTF &&  $bwlSuperUser && superuserexplicit))
		{
			//gotta figure out what to do in cases like this where the PK is text-editable
			if  ((($strValDefault=="" || $_POST[qpre . "oldid"]=="")   && !is_array($arrPK)) ||  is_array($arrPK) && count($rs)<1 ) //insert  //really need to figure out how to handle $arrPK
			{
				//echo "valdef:" .  $strValDefault  . " oldid:" . $_POST[qpre . "oldid"] . " countrs:" . count($rs);
		 		//echo "INSERT INTO " . $strDatabase . "." .  $strTable . " SET " . $strSQL;
				$strSQL="INSERT INTO " . $strDatabase . "." .  $strTable . " SET " . $strSQL;
				//echo $strSQL . "--<p>";
				
				$strDescrOfAction="added to";
				
				if(!hasautocount($strDatabase, $strTable))
				{
					//sort of a hacky way to deal with a PK being a string
					//MUST GET RID OF!!!
					//$existlookup=GenericDBLookup($strDatabase, $strTable, $strPKField, $_POST[$strPKField], $strPKField, false, false);
					if (intval($_POST[$strPKField])!=$_POST[$strPKField]  && $existlookup==""  || $_POST[$strPKField]=="")
					{
						//$strSQL =$strSQL . "," . $strPKField . "='" . $_POST[$strPKField] . "'";
					}
					else
					{
						//$strISQL="SELECT MAX(" . $strPKField . ") as 'MAX' from " . $strDatabase . "." .  $strTable;
						//$rs=$sql->query($strISQL);
						//$r=$rs[0];
						//$max=intval($r["MAX"])+1;
						//$strSQL =$strSQL . "," . $strPKField . "=" . $max;
					}  
				}
				//$strValDefault = highestprimarykey($strDatabase, $strTable);
				
			}
			else	//update
			{
		
				//echo "UPDATE " . $strDatabase . "." .  $strTable . " SET " . $strSQL . " WHERE " . $strPKField . " = " . $strValDefault;
				//echo "***" . ArrayToWhereClause($arrPK)  . "***";
				if(is_array($arrPK))
				{
					if($strSQL=="")
					{
						$strSQL=ArrayToWhereClause($arrPK);
					}
					$strSQL="UPDATE " . $strDatabase . "." .  $strTable . " SET " . $strSQL . " WHERE " . ArrayToWhereClause($arrPK);
				}
				else
				{
					$strSQL="UPDATE " . $strDatabase . "." .  $strTable . " SET " . $strSQL . " WHERE " . $strPKField . " = '" . $_POST[qpre . "oldid"] . "'";
				}
				
				$strDescrOfAction="altered in";
			}

			//echo $strSQL;
			//die($strSQL);
		 	if(CanChange())
			{
				$records = $sql->query($strSQL);
				if($strValDefault=="")
				{
					$strValDefault= sql_insert_id();
				}
			}
			else
			{
				$out.=  "Database is read-only.<br/>";
			}
			 
			//echo sql_error();
			$out.= sql_error(); //now we get to see actual errors when they happen
			if( sql_error()=="")
			{
				$out.=  "A row of data was " . $strDescrOfAction. " the " . $strTable . " table in the " . $strDatabase . " database.";
			}
			else
			{
				$out.= ". The attempted " . substr($strDescrOfAction, 0, strlen($strDescrOfAction)-5) . " failed.";
			}
		}
		else
		{
			$out.="You do not have permissions to alter this table.<br/>";
		
		}
		//i passed this in by reference so now i get to set it for the outside world to know and love
		
		
		if (contains($strConfigBehave, "updateopener"))
		{
			$builtjs.="\nopener.document.BForm['" . qpre . "idfrominsert'].value='" . $strValDefault . "';\n";
		}
			
		if ($builtjs!="")
		{
			$builtjs="\n<script>" . $builtjs . ";\n";
			
			$builtjs.="</script>\n";
		}
	//if ($strConfigBehave=="closeclickrecyclecomplete")
	}
	else
	
	{
		  $out.="Identical records cannot be inserted.";
	}
	for($i=0; $i<count($arrTransSpec); $i++)
	{
		$arrThisTransSpec=$arrTransSpec[$i];
		$arrThisTransSpec["entity_id"]=$strValDefault;
		$arrThisTranslation=$arrTranslation[$i];
		UpdateOrInsert($strDatabase, "translation",$arrThisTransSpec, $arrThisTranslation,  true,  false);
	}
	return $builtjs .  $out;
	
}
?>