<?php 
//Federico Frankenstein February 2007////////////////
//questionnaire functions 



function RenderQuestions($strPHP, $strDatabase, $intQuestionnaire_id, $intUserID, $answer_group_id, $strMappingTableAvoidList="", $strQuestionAvoidList)
{
//renders a questions for a questionnaire 
	$sql=conDB();
	$out="";
	$intOut=0;
	$strClass1="firstrow";
	$strClass2="secondrow";
	$intDefaultWidth=30;
	$strSQL="SELECT * FROM " . $strDatabase . ".questionnaire WHERE questionnaire_id=" . $intQuestionnaire_id;
	$records = $sql->query($strSQL);
	$record=$records[0];
	$accept_multiple=$record["accept_multiple"];
	$intro_text=$record["intro_text"];
	if(!$accept_multiple)
	{
		$strSQL="SELECT  q.questionnaire_question_id, q.*, p.pattern, a.answer, a.user_id FROM " . $strDatabase . ".questionnaire_question q LEFT JOIN " . $strDatabase . "." . tfpre . "validation_pattern p on q.validation_pattern_id=p.validation_pattern_id LEFT JOIN " . $strDatabase . ".questionnaire_answer a ON q.questionnaire_question_id=a.questionnaire_question_id  WHERE q.questionnaire_id=" .$intQuestionnaire_id . " AND a.user_id=" . $intUserID . " ORDER BY sort_order, q.questionnaire_question_id  ASC";
 

		$records = $sql->query($strSQL);
		if (count($records)<1)
		{
			$strSQL="SELECT  *  FROM " . $strDatabase . ".questionnaire_question WHERE questionnaire_id=" .$intQuestionnaire_id . "  ORDER BY sort_order ASC";
			$records = $sql->query($strSQL);
		}
		$out.= $intro_text;
		
		$out.= "<form method=\"post\" name=\"BForm\" action=\"" .  $strPHP . "\">\n";
		$out.= "<table border=\"0\" cellspacing=\"1\" cellpadding=\"2\" class=\"" .$strLineClass  . "\" width=\"500\">\n";
		foreach($records as $record)
		{
			if(!inList($strQuestionAvoidList, $record["questionnaire_question_id"]))
			{
				//get data about this particular question
				$strDefault=$record["answer"];
				$answer_group_id=$record["answer_group_id"];
				$questionnaire_question_id=$record["questionnaire_question_id"];
				$strQVarName=qpre . "answer-" . $questionnaire_question_id;
				$question=$record["question"];
				$sort_order=$record["sort_order"];
				$questionnaire_id=$record["questionnaire_id"];
				$answer_tally=$record["answer_tally"];
				$suggested_table_name=$record["suggested_table_name"];
				$validation_type_id=$record["validation_type_id"];
				$validation_pattern_id=$record["validation_pattern_id"];
				$sql_data_type=$record["sql_data_type"];
				$pattern=$record["pattern"];
				$sql_data_type=$record["sql_data_type"];
				$width=gracefuldecay($record["answer_width"], $intDefaultWidth);
				$height=$record["answer_height"];
				//if we need a FK dropdown, let's generate that
				if( $sql_data_type=="text")
				{
					$height=gracefuldecay($height, 4);
					$width=gracefuldecay($width*12, 30);
				}
				if($suggested_table_name!="")
				{
					$strNameField=NthNonIDColumName($strDatabase, $suggested_table_name, 1);
					
					$idFieldToUse=$strNameField;
					if(contains(strtolower($sql_data_type), "int"))
					{
						//if we specify an int as the data we want to collect from a dropdown, then we should be setting the option values to PKs instead of names
						$idFieldToUse=PKLookup($strDatabase, $suggested_table_name);
					}
					$inputfield=GenericTablePulldown($strDatabase, $suggested_table_name, $strNameField, $strNameField, $strQVarName, $strDefault, "", "", "?", true);
				
				
				}
				elseif ($sql_data_type=="date")
				{
				
					$inputfield=datepulldowns("answer-" . $questionnaire_question_id . "_date_",$strDefault);
				
				}
				elseif ($height>1  || $sql_data_type=="text")
				{
					$inputfield="<textarea rows=\"" .$height . "\" cols=\"" .$width . "\" name=\"" . $strQVarName . "\" id=\"id" . $strQVarName . "\">" . $strDefault . "</textarea>\n";
				
				}
				else
				{
					$inputfield= TextInput($strQVarName, $strDefault, $width, "",  "", "");
				
				}
				$intOut++;
				$strThisClass=Alternate($strClass1, $strClass2, $strThisClass);
				$out.=htmlrow($strThisClass, $question, $inputfield);
			}
			
		}
		
		$out.=htmlrow("", "&nbsp;", GenericInput("submit", "Save"));
		$out.=HiddenInputs(Array("questionnaire_id"=>$intQuestionnaire_id, "answer_group_id"=>$answer_group_id), "");
		$out.="</table>\n";
		$out.="</form>\n";
	}
	else 
	{
		$out.= MultipleAnswerTable($strDatabase, $intQuestionnaire_id, $intUserID, $strMappingTableAvoidList);
	
	}
 
	return $out;
}

function SaveQuestionnaireAnswers($strDatabase, $intUserID, $strMappingTableAvoidList="")
{
	$sql=conDB();
	$bwlFiguredOutMeta=false;
	$intQuestionnaire_id=$_REQUEST["questionnaire_id"];
	//echo  $strMappingTableAvoidList . "***";
	//$answer_group_id=$_REQUEST[qpre . "group_id"];
	$fieldcount=$_REQUEST[qpre . "fieldcount"];
	$xlist=$_REQUEST[qpre . "xlist"];
	//echo $xlist;
	$strSQL="SELECT * FROM " . $strDatabase . ".questionnaire WHERE questionnaire_id=" . $intQuestionnaire_id;
	//echo $strSQL;
	$records = $sql->query($strSQL);
	$record=$records[0];
	
	$bwlPopulateRelated=$record["populate_related"];
	//echo   "-" . $bwlPopulateRelated . "-";
	$related_table_name=$record["related_table_name"];
	if($bwlPopulateRelated=="")
	{
		$bwlPopulateRelated=false;
	}
	//echo $xlist . "<br>";
	if($bwlPopulateRelated)
	{
 		$arrQuestionColumnMap=GetQuestionColumnMap($strDatabase, $intQuestionnaire_id, "question_id", "column_name|question");
		$arrQuestionColumnMapFlipped=array_flip($arrQuestionColumnMap);
 
		$strFragmentSQL="";
		$usermappingtable=FindMappingTable($strDatabase, $related_table_name, "bb_user", "", $strMappingTableAvoidList);
		$mappedtableinsertcolumn =nonuseridnonPKIDcolumn($strDatabase, $usermappingtable);
		//echo $usermappingtable . " " . $mappedtableinsertcolumn . "--<br>";
	}
	$arrX=explode("|", $xlist);
	$strGroupIDs="";
	if($fieldcount>0)
	{
		
		$strSQL="SELECT MAX(answer_group_id) as mgid FROM " . $strDatabase . "." . "questionnaire_answer WHERE questionnaire_id=" . $intQuestionnaire_id . " AND user_id=" .$intUserID;
		$records = $sql->query($strSQL);
		$record=$records[0];
		$intMaxGroupID=$record["mgid"] + 1;
		//echo "<br>mgid:" . $intMaxGroupID   . " returned:" . $fieldcount-1;
		
		//if we've deleted rows we need to count up through the surplus still in the db and throw them out
		if($intMaxGroupID>$fieldcount-1)
		{
			for($i=$fieldcount-1; $i<$intMaxGroupID; $i++)
			{
				$strSQL="DELETE FROM " . $strDatabase . "." . "questionnaire_answer WHERE questionnaire_id=" . $intQuestionnaire_id . " AND user_id=" .$intUserID . " AND answer_group_id='" . $i . "'";
				//echo "<br>" . $strSQL . "<br>";
				$records = $sql->query($strSQL);
				
				//also delete from the mapping table!
				//$pkID=$_POST[ $mappedtableinsertcolumn . "_id"];
				 
				$pkID=$_POST[qpre . "grid-" . $arrQuestionColumnMapFlipped["|" . $mappedtableinsertcolumn ]. "-" .  $i ];
		 		$strSQL="DELETE FROM " . $strDatabase . "." . $usermappingtable . " WHERE user_id="  .$intUserID . " AND " . $mappedtableinsertcolumn . "="  . $pkID ;
				//echo $i . " : "  . $strSQL . "<br>";
				$records = $sql->query($strSQL);

			}
		}
		$strSQL="";
		$strTestSQL="";
		//foreach($arrQuestionColumnMap as $k=>$v)
		//{
		
			//echo $k . " " . $v . "<br>";
		//}
		for($intY=1; $intY< $fieldcount+1; $intY++)
		{
			
			//echo qpre . "grid" . "-" . $intX . "-" .  $intY  . ":" . $v . "<br>";
			
			// echo $v ."<br>";

			//echo $fieldcount . "<br>";
			$strFragmentSQL="";
			$strTestSQL="";
			$pkID="";
			for($j=0; $j<count($arrX); $j++)
			{
				
				$intX=$arrX[$j];
				//echo $intX . "<br>";
				if($intX!="")
				{
					
					$v= $_REQUEST[qpre . "grid" . "-" . $intX . "-" .  $intY ];
					//if($v!="")
					{
						$arrSpec=Array("user_id"=>$intUserID,"questionnaire_question_id"=>$intX,"questionnaire_id"=>$intQuestionnaire_id, "answer_group_id"=>$intY);
						$arrVal=Array("answer"=>$v);
						//we're going to have to redo this if the insert into a related table yields a PK
						if ($v!="")
						{
							UpdateOrInsert($strDatabase, "questionnaire_answer", $arrSpec, $arrVal,false);
						}
						if($bwlPopulateRelated)
						{
					 
							//echo "F";
							$mapstring=$arrQuestionColumnMap[$intX];
							$column_name="";
							if ($mapstring!="")
							{
								$arrMap=explode("|", $mapstring);
								$column_name=$arrMap[0];
								$question=$arrMap[1];
							}
							//echo $question . "+ =" . $related_table_name . "_id<br>";
							//echo $column_name . "===" . $v . "<br>";
							if($column_name!=""  &&  $v!="" )
							{
								
								// echo $column_name . "===" . $v . "<br>";
								$strFragmentSQL.=$column_name . "='" . $v . "',";
								$strTestSQL.=$column_name . "='" . $v . "' AND ";

							}
							//echo $question . " " . $pkID . "<br>";
							if($question==$related_table_name . "_id")//hacky i know!! what if the id field has a different name?
							{
								$pkID=$v;
								$arrSpecOut=$arrSpec;
								
							}
							
						}
				

					}
			
				}
			}
			
			$strFragmentSQL=RemoveEndCharactersIfMatch($strFragmentSQL, ",");
			
			//echo $strTestSQL. "<p>";
			$strTestSQL=substr($strTestSQL,0, strlen($strTestSQL)-4);
			//test to see if this entity exists in the related table
			////$strTestSQL="SELECT * FROM " . $strDatabase . "." . $related_table_name . " WHERE " . $strTestSQL;
			////$trecords = $sql->query($strTestSQL);
			//echo $strTestSQL . "<p>";
			//echo mysql_error()  . "<p>";
			//echo "FF";
			//echo $pkID . "<br>";
			if ($pkID=="")
			{
				//echo "DD";
				//if not, populate the related table;
				//echo $strFragmentSQL . "==";
				//echo $usermappingtable;
				
				if($usermappingtable=="")
				{
					$strFragmentSQL.=", user_id='" . $intUserID . "'";
				}
				$strISQL="INSERT INTO " . $strDatabase . "." . $related_table_name . " SET " . 	$strFragmentSQL;
				//echo "****PRIMARY SQL***<BR>" . $strISQL .   "<p>";
				$trecords = $sql->query($strISQL);
				//echo mysql_error()  . "<p>";
				if(mysql_error()=="")
				{
					$pkID=mysql_insert_id();
				}
				$arrVal=Array("answer"=>$pkID);
					//foreach($arrSpecOut as $k=>$v)
					//{
					
						//echo $k . " " . $v . "<br>";
					//}
			 	//echo $pkID . " " .  count($arrSpecOut) . " " . $arrVal . "<br>";
				if ($pkID>0  && $strFragmentSQL!=""  && count($arrSpecOut)>0)
				{
					UpdateOrInsert($strDatabase, "questionnaire_answer", $arrSpecOut, $arrVal,false);
				}
				//echo mysql_error();
				//$usermappingtable
				if($usermappingtable!="")
				{
					$strISQL="INSERT INTO " . $strDatabase . "." . $usermappingtable . " SET user_id=" . 	$intUserID  ."," .$mappedtableinsertcolumn . "=" . $pkID ;	
					//echo "****MAPPING SQL***<BR>" . $strISQL .   "<p>";
					$trecords = $sql->query($strISQL);
				}
				//echo $strISQL . "<p>";
				//echo mysql_error()  . "<p>";
				
			}
			else
			{
			 	
			 	if( RowExists($strDatabase, $related_table_name, $related_table_name . "_id", $pkID))
				{
					//echo "JJ";
					$strISQL="UPDATE " . $strDatabase . "." . $related_table_name . " SET " . 	$strFragmentSQL . " WHERE " . $related_table_name . "_id='" . $pkID . "'";
					//echo "****UPDATE SQL***<BR>" . $strISQL .   "<p>";
					//echo $strISQL . "<p>";
					$trecords = $sql->query($strISQL);
					// echo  mysql_error();
					//echo mysql_affected_rows() . "<p>";
				}
				else
				if ($strFragmentSQL!="" )
				{
					
					if($usermappingtable=="")
					{
						$strFragmentSQL.=", user_id='" . $intUserID . "'";
					}
					$strISQL="INSERT INTO " . $strDatabase . "." . $related_table_name . " SET " . 	$strFragmentSQL;
					//echo "****FAILTHROUGH SQL***<BR>" . $strISQL .   "<p>";
					//echo $strISQL;
					$trecords = $sql->query($strISQL);
					 //echo  mysql_error();
					$pkID=mysql_insert_id();
					if($usermappingtable!="")
					{
						$strISQL="INSERT INTO " . $strDatabase . "." . $usermappingtable . " SET user_id=" . 	$intUserID  ."," .$mappedtableinsertcolumn . "=" . $pkID ;
						//echo "****MAPPING SQL***<BR>" . $strISQL .   "<p>";
						$trecords = $sql->query($strISQL);
					}
					
					$arrVal=Array("answer"=>$pkID);
					UpdateOrInsert($strDatabase, "questionnaire_answer", $arrSpecOut, $arrVal,false);
		 
		 
				
				}
				//echo $strISQL . "<P>";
				//echo mysql_error();
			
			}
	
		}

	}
	
	//echo "==" . $intQuestionnairID;
	foreach($_REQUEST as $k=>$v)
	{
		if(contains($k, qpre . "answer-"))
		{
			//echo $k . "....." . $v . "<br>";
			$bwlSkipSave=false;
			if(contains($k,   "_date_|"))
			{
				
				if(contains($k,   "month"))//for a three part date all we need is the month
				{
					$arrQ=explode("-", $k);
					$k=$arrQ[1];
					$arrQ=explode("_", $k);
					$intQuestionID=$arrQ[0];
					//echo qpre . "answer-" . $intQuestionID . "_date_<br>";
					$v=RequestCompoundDate(qpre . "answer-" . $intQuestionID . "_date_");
					$bwlSkipSave=false;
					//echo $v;
				}
				else
				{
					$bwlSkipSave=true;
				}

			}
			else
			{
				$arrQ=explode("-", $k);
				$intQuestionID=$arrQ[1];
			}
			if(!$bwlFiguredOutMeta)
			{
				$strSQL="SELECT * FROM " . $strDatabase . ".questionnaire WHERE questionnaire_id=" . $intQuestionnaire_id;
				//echo $strSQL . "<br>";
				$records = $sql->query($strSQL);
				$record=$records[0];
				$accept_multiple=$record["accept_multiple"];
				$bwlFiguredOutMeta=true;
			}
			//echo $k . "<br>";
			
			{
			 //echo $bwlSkipSave . "<br>";
				if(!$bwlSkipSave)
				{
					//echo $accept_multiple . "-<br>";
					if(!$accept_multiple)
					{
					
						UpdateOrInsert($strDatabase, "questionnaire_answer", Array("user_id"=>$intUserID,"questionnaire_question_id"=>$intQuestionID), Array("answer"=>$v),false);
					}
					else
					{
						if($answer_group_id=="")//need to make another group_id
						{
							//$strThisTable="questionnaire_answer_group";
							//$strGroupInsertSQL="INSERT INTO " . $strDatabase . "." . $strThisTable . "(questionnaire_id) VALUES (" . $intQuestionnaire_id . ")";
							//echo $strGroupInsertSQL;
							//$sql->query($strGroupInsertSQL);
							//$answer_group_id=highestprimarykey($strDatabase,$strThisTable);
						}
						UpdateOrInsert($strDatabase, "questionnaire_answer", Array("user_id"=>$intUserID,"questionnaire_question_id"=>$intQuestionID,"questionnaire_id"=>$intQuestionnaire_id, "answer_group_id"=>$answer_group_id), Array("answer"=>$v),false);
					
					}
				}
			}
			 

		}
	}
}

function GetQuestionnaireList($strPHP, $intQuestionnaireTypeID, $intThisQuestionnaireID, $idsToAvoid)
{
	$sql=conDB();
	$out="";
	$strSQL="SELECT * FROM " . $strDatabase . ".questionnaire   WHERE  questionnaire_type_id=" .$intQuestionnaireTypeID . " ORDER BY sort_order    ASC";
	//echo $strSQL;
	$records = $sql->query($strSQL);
	foreach($records as $record)
	{
		$strClass="leftnav";
		$htmltag="a";
		if(!inList($idsToAvoid, $record["questionnaire_id"]))
		{
			if ($intThisQuestionnaireID==$record["questionnaire_id"])
			{
			
				$strClass="leftnav_selected";
				$htmltag="span";
			}
			$out.="<p><" . $htmltag . " class=\"" . $strClass ."\" href=\"" . $strPHP . "?questionnaire_id=" . $record["questionnaire_id"] . "\">" .  $record["name"] . "</" . $htmltag . "></p>";
		}
	}
	return $out;

}
 
 

function MultipleAnswerTable($strDatabase, $intThisQuestionnaireID, $intUserID, $strMappingTableAvoidList="")
{

	$sql=conDB();
	$out="";
	$dataHTML="";
	$intFieldOut=1;
	$rowOut=0;
	$intHiddens=0;
	$arrParam=Array();
	$arrLabels=Array();
	$arrFtables=Array();
	$questionids="";
	$sql_data_types="";
	$strFormWidths="";
	$xlist="";
	$intWidth=20;
	$strClass1="firstrow";
	$strClass2="secondrow";
	$strThisClass="";
	$strSQL="SELECT * FROM  " . $strDatabase . ".questionnaire WHERE  questionnaire_id=" .$intThisQuestionnaireID;
	$records = $sql->query($strSQL);
	$record=$records[0];
	$intro_text=$record["intro_text"];
	$strQuestionnaireName=$record["name"];
	$strSingularizedName=singularize($strQuestionnaireName);
	$strSQL="SELECT * FROM  " . $strDatabase . ".questionnaire_question WHERE  questionnaire_id=" .$intThisQuestionnaireID . " ORDER BY sort_order";
	$records = $sql->query($strSQL);
	$arrLabels[0]="subtleheader";
 
	foreach($records as $record)
	{
		$sql_data_type=$record["sql_data_type"];
		$question=$record["question"];

		$strWidth=gracefuldecaynotzero($record["answer_width"],$intWidth);
		//echo $strWidth . "<br>";
		$question_id=$record["questionnaire_question_id"];
		$questionids.=" " . $question_id;
		$sql_data_types.=" " . $sql_data_type;
		$strFormWidths.=" " . $strWidth;
		$foreigntable=$record["suggested_table_name"];
		//echo 	$foreigntable . " " . $intFieldOut . "<br>";
		$arrFtables[$intFieldOut]=$foreigntable;
		//$question= GenericDBLookup($strDatabase,"questionnaire_question", "questionnaire_question_id", $question_id, "question");
		//echo $question . "==" . $intFieldOut . "<br>\n" ;
		if($sql_data_type!="hidden")
		{
			$arrLabels[$intFieldOut]="<label>" . $question . "</label>" . answerformwrap("", $question_id, 0, $sql_data_type, $foreigntable, true, $strWidth, 0, $intUserID,false, $strMappingTableAvoidList);
			
		}
		else
		{
			$arrLabels[$intFieldOut]= answerformwrap("", $question_id, 0, $sql_data_type, $foreigntable, true, $strWidth, 0, $intUserID, false, $strMappingTableAvoidList);
			$intHiddens++;
		}
		$intFieldOut++;

	
	}
	$strSQL="SELECT * FROM " . $strDatabase . ".questionnaire_answer a  WHERE a.questionnaire_id=" .$intThisQuestionnaireID . " AND user_id=" . $intUserID . " ORDER BY answer_group_id ASC";
	//echo "<b>multipleanswersql:</b> " . $strSQL . "<P>";
	$records = $sql->query($strSQL);
	$out.= "<script src=\"multipleanswer_js.js\"><!-- --></script>\n";
	$out.= "<script src=\"tableform_js.js\"><!-- --></script>\n";
	$out.= "<form method=\"post\" name=\"BForm\" action=\"" .  $strPHP . "\">\n";
	$out.= "<table border=\"0\" cellspacing=\"1\" cellpadding=\"2\" class=\"" .$strLineClass  . "\" width=\"100%\">\n";
	//$arrParam[0]="";  //because of the way htmlrow works, this is to set the class of the display of that row

	$firstaddlink="<a id=\"idaddfield-0\" href=\"javascript: addQrow('addfield-0' )\"><img  onmouseover=\"glow(this, 'on')\"  onmouseout=\"glow(this, 'off')\" border=\"0\" src=\"" . imagepath . "/insert.gif\"></a>".HiddenInputs(array("group_id[]"=>"", "swapfieldd-0" =>""),"");
	

	foreach($records as $record)
	{
		//echo $arrParam[$intFieldOut] . "**<br>";
		
		//$old_group_id=$group_id;
		$group_id=$record["answer_group_id"];
 
 		$question_id=$record["questionnaire_question_id"];
			
		
		$answer=$record["answer"];
		//$answer=$question_id . "-" . $group_id;
		
		//$addlink="<a id=\"idmoreadd-" .  $group_id .  "\" name=\"moreadd-" .  $group_id .  "\"  onclick=\"MAmore(this)\">+</a>";

		//$addlink="<a href=\"javascript:add()\">add here</a>\n";
		$questionnaire_question_id=$record["questionnaire_question_id"];
 
		$arrParam[$group_id][$question_id]=$answer;
		$arrParam[$group_id][0]=$group_id;
		//echo $arrParam[$group_id][$question_id] . "<br>";
		//echo $record["answer"] . "--" . $intFieldOut . "<br>" ;

 

 
	 	//echo $intFieldOut . "++++<br>";
 
	
	}
	//echo "count:" .  count($arrLabels) . "<br>";
 
	$arrQuestionIDs=explode(" ", $questionids);
	//echo $sql_data_types . "<br>";
	$arrDataTypes=explode(" ",$sql_data_types);
	$arrWidths=explode(" ",$strFormWidths);

	for($i=1; $i<=$group_id; $i++)
	{
		//echo "count:" .  count($arrParam[$i]) . "<br>";
		//echo count($arrParam[$group_id]) . "=isarray<br>";
	 	$arrOut=Array();
		$strThisClass=Alternate($strClass1, $strClass2, $strThisClass);
		$arrOut[0]=$strThisClass;

		for($j=1; $j<count($arrQuestionIDs) ; $j++)
		{
			
			$intQuestionID=$arrQuestionIDs[$j];
			//echo $intQuestionID . "=questionid<br>";
			$answer=$arrParam[$i][$intQuestionID];
			$foreigntable=$arrFtables[$j];
			//echo $foreigntable . " " . $j . "<br>";
			//answerformwrap($answer, $x, $y, $sql_data_type, $foreigntable, $bwlHidden=false, $width=20, $height=1, $intUserID="")
			//echo $arrDataTypes[$j] . "<br>";
			$arrOut[$j]=answerformwrap($answer, $intQuestionID, $i,$arrDataTypes[$j], $foreigntable, false, $arrWidths[$j],0, $intUserID, false, $strMappingTableAvoidList);
 
		
		}
		$addlink="<a id=\"idaddfield-" .  $i.  "\" href=\"javascript: addQrow('addfield-" .$i. "' )\"><img  onmouseover=\"glow(this, 'on')\"  onmouseout=\"glow(this, 'off')\" border=\"0\" src=\"" . imagepath . "/insert.gif\"></a>";
		
		$arrOut[count($arrOut)]=$addlink. HiddenInputs(array("group_id[]"=>$arrParam[$i][0], "swapfieldd-" . $i =>""),"");
		$dataHTML.=call_user_func_array('htmlrow', $arrOut);
	
	}
 	
	$arrParam[count($arrParam)]=$addlink. HiddenInputs(array("group_id[]"=>$group_id));
	$arrLabels[count($arrLabels)]=$firstaddlink;
	$xlist = RemoveEndCharactersIfMatch($questionids, " ");
	$xlist=str_replace(" ", "|", $xlist);
	if($i<3  ||1==1)
	{
		$out="<div class=\"text_11bl\">" . $intro_text. "</div>".$out ;
	}
	$out.=call_user_func_array('htmlrow', $arrLabels);
	//$dataHTML.=call_user_func_array('htmlrow', $arrParam);
 	$out.=$dataHTML;
	$out.=HiddenInputs(array("mode"=>"save",  "xlist"=>$xlist, "db" =>$strDatabase, "fieldcount"=>$i, "delete"=>"" ));
 
	$out.="<tr><td  align=\"left\" colspan=\"" . intval((count($arrLabels)-2)-$intHiddens) . "\">" . MASelectedTools(). "</td><td align=\"right\" >" .  GenericInput(qpre . "submit", "Save") . "</td></tr>\n";
	$out.="</table>\n\n";
	
	$out.= "</form>\n";
	
	//strictly front-end stuff:
	//i might want to turn the following line off under certain circumstances XXXXXXXX
	$out.= "\n<script>addQrowAtEnd('');</script>\n";
	$out.="<div class=\"text_11b2\">Click the <a href=\"javascript:addQrowAtEnd('')\"><img border=\"0\" src=\"" . imagepath . "/insert.gif\"></a> button to add a new <strong>" . $strSingularizedName  . "</strong>.  Click an existing <strong>" . $strSingularizedName . "</strong> to select it.  Then click the  arrows to move it up or down or the <a href=\"javascript:deleteQrowSelectedOrAtEnd('')\"><img border=\"0\" src=\"" . imagepath . "/delete.gif\"></a> button to delete it.</div><p/>";

	//echo "<a href=\"javascript:domdumpwindow()\">dump</a>";
	return $out;
}

function answerformwrap($answer, $x, $y, $sql_data_type, $foreigntable, $bwlHidden=false, $width=20, $height=1, $intUserID="", $bwlNoForm=false,  $strMappingTableAvoidList="")
{
	$out="";
	$strDatabase=our_db;
	$strClass="multianswer";
	$type="text";
	$strStyle="";
	$selectStyle="";
	//echo $width . " " . $height. "<br>";
	//echo $foreigntable . "-";
	if ( $bwlHidden)
	{
		$strStyle="display:none";
		$selectStyle="style='display:none'";
	}
	$js=" onclick='MAtrselectfromline(this, \"\")' onfocus='groovify(this, \"black\")' onmouseover='groovify(this, \"orange\")' onmouseout='degroovify(this)' onblur='degroovify(this)' " ;
	//echo $foreigntable . "-<br>";
	if($sql_data_type=="hidden")
	{
		//echo "&";
		$out.="<span/>" . GenericInput(qpre . "grid-" . $x . "-" . $y, $answer, false, "", $strStyle, $strClass, "hidden" , 1, $js, 1);
	}
	else 
	{
		if($bwlNoForm   )
		{
			$out="<span class=\"text_12bl\">" . $answer . "</span>";
		}
		else
		{
			if ($foreigntable=="")
			{
				$out.=GenericInput(qpre . "grid-" . $x . "-" . $y, $answer, false, "", $strStyle, $strClass, $type , $width, $js, $height);
				
			}
			else
			{
			//foreigntablepulldown($strDatabase, $strTable, $strIDField, $intDefault, $strLabelField="", &$namereturn, $bwlHiddenReturn=false, $strPreferredNameField="")
				$idfield=PKLookup($strDatabase, $foreigntable);
				//echo $strDatabase. " " . $foreigntable . " " . $idfield . "<br>";
				//$out.=foreigntablepulldown($strDatabase, $foreigntable, $idfield, $answer,  qpre . "grid-". $x . "-" . $y, $namereturn, "", "", $selectStyle);
				$out.=Narrowedforeigntablepulldown($strDatabase, $foreigntable, $idfield, $answer,  qpre . "grid-". $x . "-" . $y, $namereturn, "", "", $selectStyle, "user_id" , $intUserID, $strMappingTableAvoidList);
			}
		}
	}
	return $out;

}
 
function MASelectedTools()
{
	$out="";
	//$out.="move selected: ";
	$out.="<a  href=\"javascript:MATRaction('up','')\"><img  onmouseover=\"glow(this, 'on')\"  onmouseout=\"glow(this, 'off')\" border=\"0\" src=\"" . imagepath . "/uparrow.gif\"></a>";
	$out.="   ";
	$out.="<a   href=\"javascript:MATRaction('down','')\"><img onmouseover=\"glow(this, 'on')\"  onmouseout=\"glow(this, 'off')\" border=\"0\" src=\"" . imagepath . "/downarrow.gif\"></a>";
	$out.="   ";
	$out.="<a   href=\"javascript:MATRaction('delete','')\"><img onmouseover=\"glow(this, 'on')\"  onmouseout=\"glow(this, 'off')\" border=\"0\" src=\"" . imagepath . "/delete.gif\"></a>";
 	return $out;
}
	
	
function GetQuestionColumnMap($strDatabase, $intQuestionnaireID, $strKeyType="question_id", $strResultType="column_name")
{
	//return an associative array mapping questions to fields
	$sql=conDB();
	$arrOut=Array();
	$strSQL="SELECT * FROM " . $strDatabase . ".question_column_map m RIGHT JOIN " . $strDatabase . ".questionnaire_question q ON m.questionnaire_question_id=q.questionnaire_question_id WHERE q.questionnaire_id=" . $intQuestionnaireID;
	$records = $sql->query($strSQL);
	//echo mysql_error() . "<p>";
	foreach($records as $record)
	{
		$question=$record["question"];
		$column_name=$record["column_name"];
		$question_id=$record["questionnaire_question_id"];
		$result=$column_name;
		if ($strResultType=="column_name|question")
		{
			$result=$column_name . "|" . $question;
		
		}
		else if ($strResultType=="column_name|question_id")
		{
			$result=$column_name . "|" . $question_id; 
		}
		else  if ($strResultType=="question")
		{
			$result=  $question;
		}
		
		if ( $strKeyType=="question")
		{
			$arrOut[$question]=$result;
		}
		if ( $strKeyType=="question_id")
		{
			$arrOut[$question_id]=$result;
		}

		else
		{
			$arrOut[$column_name]=$result;
		}
		
	}
	return $arrOut;
}





function Narrowedforeigntablepulldown($strDatabase, $strTable, $strIDField, $intDefault, $strLabelField="", &$namereturn, $bwlAutoGo=false, $strPreferredNameField="", $styleclass="",  $strNarrowingIDName="", $intNarrowingID="", $strAvoidTableList="")
	{
		//echo  $strTable . "<br>";
		//gives me a select named $strIDField of ids with rows from $strTable, defaulted to $intDefault
		//$namereturn, passed by reference, allows me to hand back the selected string label of the pulldown, which is won at considerable
		//computative effort
		//bwlHiddenReturn allows me to pass the actual string value of the dropdown in a specially-labeled hidden field.
		//in this version i disable some of that stuff that results in nasty colon-rich option labels.
		$sql=conDB();
		$strHiddenExtra="";
		$strNameField2="";
		$strNameField="";
		$moreflag=false;
		if ($strLabelField=="")
		{
			$strLabelField= $strIDField;
		}
		$strOut="<select " . $styleclass . " id=\"id" . $strLabelField . "\"  name=\"". $strLabelField. "\"";
		if ($bwlAutoGo)
		{
		
			$strOut.=" onchange=\"location.href='" . $_SERVER['PHP_SELF'] . "?" . $strLabelField . "=' + document.BForm." .  $strLabelField . "[document.BForm." .  $strLabelField . ".selectedIndex].value\"";
		
		}
		$strOut.= ">"."\n";
		$strOut.="<option value=".chr(34).chr(34).">none"."\n";
		if ($strPreferredNameField=="")
		{
			$strNameField=firstnonidcolumname($strDatabase, $strTable);
			//$strNameField2 = NthNonIDColumName($strDatabase, $strTable, 2);
			//kind of hacky but hey, we need more info:
			//$firstIDNotPK=NthIDColumName($strDatabase, $strTable,2);
		}
		else
		{
			$strNameField = $strPreferredNameField;

		}
		$strSQL="SELECT * FROM " . $strDatabase . "." . $strTable;

		//echo $strNarrowingIDName . "<br>";
		if ($strNarrowingIDName!="")
		{
			//echo $strTable . " " . $strNarrowingIDName . "<br>";
			if (FieldExists($strDatabase, $strTable, $strNarrowingIDName))
			{
				//echo "|<br>";
				$strSQL.=" WHERE  " . $strNarrowingIDName . "='" .$intNarrowingID . "' ";
			}
			else //we need the mapping table info and we need to do a big messy join
			{
				//these two steps are awfully expensive to have to do:
				$strMappingTable=FindMappingTable($strDatabase, $strTable, "", "user_id", $strAvoidTableList);
				//echo $strMappingTable . "--------" . $strAvoidTableList . "<br>";
				$otherMappedTable=FindOtherTableMapped($strDatabase, $strTable, $strMappingTable);
				if ($otherMappedTable!="")
				{
					//echo $strMappingTable . " " . $otherMappedTable . "=<br>";
					$strSQL="SELECT  DISTINCT t.*  FROM " . $strDatabase . "." . $strTable . " t JOIN " . $strDatabase . "." . $strMappingTable . " m ON t." . $strIDField . "=m." .  $strIDField . " WHERE  " . $strNarrowingIDName . "='" .$intNarrowingID . "' ";
				}
			}
		}
 		if ($strNameField!="")
		{
			$strSQL.=" ORDER BY " . $strNameField;
		
		}
		if ($strNameField2!="")
		{
			$strSQL.=", " . $strNameField2;
		
		}
		//echo $strSQL . "<br>";
		$records = $sql->query($strSQL);
		if ($records)
		{
			$strOldLabel="";
			//some code to handle the sorting of the records, because orderby is fuct
			$arrOut=array();
			foreach($records as $k)
			{
				//some complicated code to handle the situation where name fields are not very unique
				 $strLabel1 = $k[$strNameField];
				 $strLabel2 = $k[$strNameField2];
				if ($strLabel2=="")
				 {
				 	$strLabel2=$k[$firstIDNotPK];
				 }
				 $strLabel= $strLabel1;
				 if($strOldLabel==$strLabel1 )
				 {
				 	$moreflag=true;
				 }
				// if ((strlen($strLabel1)<15 && $strLabel2!="" && !(strlen($strLabel2)>15))   && ($strNameField2!="password") || $moreflag)
				// {
				 
				 	//$strLabel=$strLabel1  . " : " . $strLabel2;
				// }
				 $strOldLabel=$strLabel1;
				 $strSel="";
				 if ($k[$strIDField]==$intDefault)
				 {
				   $strSel=" selected=\"true\" ";
				   $namereturn=$strLabel;
				   if ($bwlHiddenReturn)
				   {
				   	$strHiddenExtra="<input type=\"hidden\" name=\"" .$strFieldNamePrefix  . qpre . "multi\"   value=\"".  $strLabel . "\">\n";
				   
				   }
				 } 
				 
				 $strSel="";
				//echo $k . "<br>";
				 if ($k[$strIDField]==$intDefault)
				 {
				 	$strSel=" selected=\"true\" ";
				 } 
				$strOut=$strOut."<option value=\"". $k[$strIDField] . "\" " . $strSel .  ">". truncate($strLabel, 35) ."\n";
				
				// $arrOut[$strLabel]=$k[$strIDField];
			} 
			if ($strHiddenExtra=="" && $bwlHiddenReturn)
			{
				$strHiddenExtra="<input type=\"hidden\" name=\"" .$strFieldNamePrefix  . qpre . "multi\"   value=\"\">\n";
			}
		
			
		}
		$strOut=$strOut."</select>"."\n";
		$function_ret=$strOut . $strHiddenExtra;
		return $function_ret;
	}






?>