<?php
//Judas Gutenberg December 2010
//function(s) allowing tableform to update its schema to the latest version

function Updater($strDatabase,  $strMode="form")
{
	//updates Tableform tables to latest version.  can present a form or just do all the updates necessary
	$sql=conDB();
	$records=TableExplain($strDatabase, $strTable);
	$intFindCount=1;
	$errors="";
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$out= "";
	$preout= "";
	$strPHP="tf.php";
	$preout.= adminbreadcrumb(false, $strDatabase, $strPHP . "?" . qpre . "db=" . $strDatabase,  "Updater", "");
	$preout.="<form name=\"BForm\" action=\"" .$_SERVER['PHP_SELF'] . "\" method=\"post\">\n";
	$out.="<tr class=\"bgclassline\"><td colspan=\"2\">\n";
	$out.="Check off the updates you'd like to make to get to the latest version of Tableform.\n";
	$out.="</td></tr>\n";
	//format:tablename*field_oldname|field_newname|type|after_fieldname*field_oldname|field_newname|type|after_fieldname\n next_record....
	$strConfig="tf_dbmap_table*top|top_pos*left|left_pos*color_basis|color_basis
				tf_relation*display_column_name|disp_column_name||table_name*|sort_column_name||disp_column_name*|sort_descending|tinyint(1)|sort_column_name*|f_disp_column_name||f_table_name*|f_sort_column_name||f_disp_column_name*|f_sort_descending|tinyint(1)|f_disp_column_name*narrowing_conditions|narrowing_conditions|text|relation type*tool_guidance|tool_guidance_id|int(11)|narrowing_conditions*complete_list_data|complete_list_data|tinyint(1)|tool_guidance_id*max_dropdown|max_dropdown|int(11)|complete_list_data
tf_column_info*extra_functionality|extra_functionality|text|*forceeditable|forceeditable|tinyint*forceuneditable|forceuneditable|tinyint
";
//


	////updaterdata format:  tablename\nfieldvalue_rec1,fieldvalue_rec1,fieldvalue_rec1\nfieldvalue_rec2,fieldvalue_rec2,fieldvalue_rec2\n
	
	$updaterdata="";
	if(defined("updaterconfig"))
	{
		$strConfig.="\n" . updaterconfig;
	}
	$arrConfig=explode("\n", $strConfig);
	$strTableToAdd="";
	foreach ($arrConfig as $thisconfig )
	{
		$arrSubConfig=explode("*", $thisconfig);
		//echo count($arrSubComfig);
		$j=0;
	
		$j++;
	
		$strThisTable=trim($arrSubConfig[0]);
		for($i=1; $i<count($arrSubConfig); $i++)
		{
			$strSQL="";
			$arrFieldNames=explode("|", $arrSubConfig[$i]);
			$strOriginalName=trim($arrFieldNames[0]);
			$strNewName=trim($arrFieldNames[1]);
			$strTypeDeclaration=gracefuldecay(trim($arrFieldNames[2]), " VARCHAR(50)");
			//echo $strTypeDeclaration . "<BR>";
			$strAfterColumn=trim($arrFieldNames[3]);
			$strAfterClause="";
			if($strAfterColumn!="")
			{
				$strAfterClause=" AFTER " . ensureEnclosure($strAfterColumn) . " "; 
			}
			$bwlAlter=false;
			$bwlDoSomething=true;
			if(FieldExists($strDatabase, $strThisTable, $strOriginalName))
			{
				//echo $strDatabase . " " . $strThisTable . "*" .   $strOriginalName . "=<BR>";
				$bwlAlter=true;
			}
			else
			{
				//echo $strDatabase . " " . $strThisTable . "*" .   $strOriginalName . "<BR>";
			}
			if(FieldExists($strDatabase, $strThisTable, $strNewName))
			{
				//echo  $strNewName . "====" . $strThisTable . "<BR>";
				$bwlAlter=false;
				$bwlDoSomething=false;
				//echo $strDatabase . " " . $strThisTable . "*" .   $strOriginalName . "$<BR>";
			}
			
			if($strOriginalName=="")
			{
				$bwlAlter=false;
			}
			
			if(!TableExists($strDatabase, $strThisTable))
			{
				//$strSQL="CREATE TABLE " .$strDatabase . "." . $strThisTable . "(" . $strThisTable . "_id int(11));";
		  
				$strSQL="CREATE TABLE " .$strDatabase . "." . $strThisTable . "(";
		 
				
				$strPK="";
				$strAutoInc=" NOT NULL auto_increment";
				//echo count($arrSubConfig) . "&&<BR>";
				$bwlCanMakeTable=false;
				for($j=1; $j<count($arrSubConfig); $j++)
				{
		 			
					$arrFieldNamesCT=explode("|", $arrSubConfig[$j]);
					$strOriginalNameCT=trim($arrFieldNamesCT[0]);
					$strNewNameCT=trim($arrFieldNamesCT[1]);
					$strTypeDeclarationCT=gracefuldecay(trim($arrFieldNamesCT[2]), " VARCHAR(50)");
					$strAfterColumnCT=trim($arrFieldNamesCT[3]);
					$fieldnameCT=ensureEnclosure(gracefuldecay($strOriginalNameCT, $strNewNameCT));
					if($strPK=="")
					{
						$strPK="PRIMARY KEY (" .  $fieldnameCT . ")";
						if(contains(strtolower($strTypeDeclarationCT), "int"))
						{
							$bwlCanMakeTable=true;
						}
					}
					$strSQL.=gracefuldecay($strOriginalNameCT, $strNewNameCT) . " " . $strTypeDeclarationCT . $strAutoInc . ",\n";
					$strAutoInc="";
						
						
				}
			
	 
				$strSQL.=$strPK . ");\n";
				//echo $strSQL . "#####<BR>";
				$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
				//$out.=DisplayOrExecuteSQL($strSQL,  $mode,$strThisBgClass, $errors);
				
				if($bwlCanMakeTable)
				{
					$sql->query($strSQL);
					$error=sql_error();
					if($error!="")
					{
						$errors.=$error . "<br>";
					}
					else
					{
						//$errors.=$strThisTable . " created " . "<br>";
						
						//$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
						$out.=htmlrow($strThisBgClass,"&nbsp;",  "<b>" . $strThisTable . " created.</b> ");
						$strTableToAdd=$strThisTable;
					}
				}
			}
		 	if($strTableToAdd==""  || $strTableToAdd!= $strThisTable)
			{
				$strTableToAdd="";
				//echo $strOriginalName . "+" . $bwlDoSomething . "-" . $bwlAlter . "<BR>";
				if($bwlDoSomething)
				{
					//echo $strDatabase . " " . $strThisTable . "*" .   $strOriginalName . "%<BR>";
					if($bwlAlter)
					{
						$strSQL=  "ALTER TABLE " . $strDatabase . "." .   ($strThisTable) . " CHANGE " . ensureEnclosure($strOriginalName) . " " . ensureEnclosure($strNewName) . " " .  $strTypeDeclaration . ";\n";
					}
					else
					{
						$strSQL= "ALTER TABLE " . $strDatabase . "." .   ($strThisTable) . " ADD COLUMN " . ensureEnclosure($strNewName) . " " . $strTypeDeclaration . " " . $strAfterClause . ";\n";
					}
				}
				
				
				if($strSQL!="")
				{
				
					$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
					$out.=DisplayOrExecuteSQL($strSQL,  $strMode,$strThisBgClass, $errors);
				}
			}
		}
 	}
	if(defined("updaterdata"))
	{
		$updaterdata.="\n" . updaterdata;
	
	}
	if($updaterdata!="")
	{
		$arrConfig=explode("\n", $updaterdata);
		$strThisTable="";
		foreach ($arrConfig as $thisconfig )
		{
			if(!contains($thisconfig, ","))
			{
				$strThisTable=trim($thisconfig);
				$strThisTable=RemoveEndCharactersIfMatch($strThisTable, "'");
			}
			
			else
			{
				//echo $strThisTable;
				$records=TableExplain($strDatabase, $strThisTable);
			 	$strFields="";
			 
				$bwlThis=false;
				$arrFields=Array();
				$count=0;
				foreach ($records as $k => $v )
				{
					$thisfield=$v["Field"];
					$arrFields[$count]=$thisfield;
					//echo $thisfield . "<BR>";
				 	$strFields.=ensureEnclosure($thisfield) . ",";
					$count++;
				}
				$strFields=RemoveEndCharactersIfMatch($strFields, ",");
				 
				$exists=explode(",", $strFields);
				//kinda mushy!!
				$thisexistdata=BetterExplode(",", $thisconfig);
				
				$arrExist=Array();
				$arrFirstExist=Array();
				$count=0;
				$strAlters="";
				foreach($exists as $thisexist)
				{
					if($thisexist!="")
					{
						$val=trim($thisexistdata[$count]);
						$val=RemoveEndCharactersIfMatch($val, "'");
						$arrExist[$thisexist]=$val;
						if($count==0)
						{
							$arrFirstExist[$thisexist]=$val;
						}
						else
						{
							
							$strAlters.= $arrFields[$count] . "='" . $val . "', ";
						
						}
					}
					$count++;
				}
				$strAlters=RemoveEndCharactersIfMatch($strAlters, ", ");
				//echo $count . "<BR>";
				$strFirstExistSQL="SELECT * FROM " . $strDatabase . "." .     $strThisTable  . " WHERE " . ArrayToWhereClause($arrFirstExist);
				//echo $strExistSQL . "<BR>";
				$arrFirstExistResult=$sql->query($strFirstExistSQL);
				$strExistSQL="SELECT * FROM " . $strDatabase . "." .     $strThisTable  . " WHERE " . ArrayToWhereClause($arrExist);
				//echo $strExistSQL . "<BR>";
				$arrExistResult=$sql->query($strExistSQL);
				
				if(!$arrFirstExistResult)
				{
					$strSQL="INSERT INTO " . $strDatabase . "." .     $strThisTable . "(" . $strFields . ") VALUES (" .  $thisconfig . ")"; 
					
					
					//$sql->query($strSQL);
					if($strSQL!="")
					{
				
						$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
						$out.=DisplayOrExecuteSQL($strSQL, $strMode,$strThisBgClass, $errors);
					}
				}
				elseif(!$arrExistResult)
				{
					//var_dump($arrFirstExist);
					$strSQL="UPDATE " . $strDatabase . "." .     $strThisTable . " SET " . $strAlters . " WHERE " . ArrayToWhereClause($arrFirstExist); 
					if($strSQL!="")
					{
					//UPDATE vetboxx.tf_relation SET table_name='client', disp_column_name='', sort_column_name='', sort_descending='', column_name='client_type_id', f_table_name='client_type', f_disp_column_name='', f_sort_column_name='', f_sort_descending='', f_column_name='client_type_id', relation_type_id='0', narrowing_conditions='', tool_guidance_id='0', complete_list_data='', max_dropdown='' WHERE `relation_id`='22' 
					//UPDATE vetboxx.tf_relation SET table_name='client', disp_column_name='', sort_column_name='', sort_descending='', column_name='guardian_client_id', f_table_name='client', f_disp_column_name='firstname lastname', f_sort_column_name='', f_sort_descending='', f_column_name='client_id', relation_type_id='0', narrowing_conditions='', tool_guidance_id='0', complete_list_data='', max_dropdown='' WHERE `relation_id`='22'   
						//echo $strSQL;
						$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
						$out.=DisplayOrExecuteSQL($strSQL, $strMode,$strThisBgClass, $errors);
					}
				}
			
			}
		}

			
			
		
		 
	}
	$out.="<tr class=\"bgclassline\"><td align=\"right\" colspan=\"2\">\n";
	$out.="<a href=\"javascript:alldumpcheckboxes('sql[]', true)\">select all</a> | <a href=\"javascript:alldumpcheckboxes('sql[]', false)\">select none</a> &nbsp; ";
	$out.="<input type=\"submit\" name=\"" . qpre . "submit\" value=\"make changes " ."\">\n";
	$out.= HiddenInputs(array("db"=>$strDatabase, "table"=>$strTable ));
	$out.="</td></tr>\n";
	$out=$preout . TableEncapsulate($out, false);
	$out.="</form>\n";
	if($errors!="")
	{
		$out=$errors;
	}
	return $out;
}



function DisplayOrExecuteSQL($strSQL,  $strMode,$strThisBgClass, &$errors)
{
	$out="";


	$out.="<tr class=\"" . $strThisBgClass . "\">";
	$out.="<td width=\"10\">";
	$out.="<input type=\"checkbox\" name=\"" . qpre . "sql[]\" id=\"id" . qpre . "sql[]\" value=\"" .  str_replace("\n", " ", str_replace("\"", "\\" . "\"", $strSQL)) . "\"></td><td>" ;
	$out.= $strSQL . "</td></tr>";

	
	//$out.="<tr class=\"" . $strThisBgClass . "\"><td width=\"10\">";
	
	$out.="</td>";
	$out.="</tr>\n";
	//echo "-" . $strSQL . "-<BR>";
	//echo $strMode;
	if($strMode=="doall")
	{
		//echo "-" . $strSQL . "-<BR>";
		$strSQL=removeslashesifnecessary($strSQL);
		$sql->query($strSQL);
		$error=sql_error();
		if($error!="")
		{
			$errors.=$error . "<br>";
		}
	}

	return $out;
}
?>