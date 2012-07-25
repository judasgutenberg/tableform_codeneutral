<?php
//This code is covered under the GNU General Public License
//info here: http://www.gnu.org/copyleft/gpl.html
//the digest is as follows: you cannot modify this code without
//publishing your source code under the same license
//contact the developer at gus@asecular.com  http://asecular.com

function  GenericRSDisplay($strDatabase, $strPHP,$strLabel, $strSQL, $truncate, $intWidth, $strLinkFieldName="", $strLinkIDName="", $strAdditionalLink="", $strSuppressFields="", $bwlSuppressHeader=false, $bwlPrettyUpFieldNames=true, $intFieldLimit=10, $idencryptionstring="", $arrPostProcessing="", $arrFieldLabels="", $bwlSuppressLinksWhereNoData=true, $bwlNoTableEncapsulate=false, $hrefTarget="", $bwlPaginated=false)
{
	//looks for <replace/> and replaces it with the PK!
	//also shows errors if there is a problem
	//judas gutenberg, July 8 2007
	//if $strAdditionalLink contains a ^ then the left half of that is the label for stringadditional
 	//now substitutes in a running <rowcount/> if needed as well as <replace/> for id
	//also now can post-process data in PHP using an associated array of fieldname=>"php_expression(<value/>)" passed in as $arrPostProcessing
	$sql=conDB();
	mysql_select_db($strDatabase);
	$strLineClass="bgclassline";
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strOtherBgClass="bgclassother";
	$strOtherLineClass="bgclassline";
	$strThisBgClass=$strLineClass;
	$arrFN=Array();
	$strAdditionalLinkLabel= "&nbsp;";
	$strTargetPair="";
	if($bwlPaginated)
	{
		if($_GET[qpre . "direction"]==""  || $_GET[qpre . "direction"]=="ASC")
		{
			$_GET[qpre . "direction"]="DESC";
		}
		else
		{
			$_GET[qpre . "direction"]="ASC";
		}
	}
	if( $hrefTarget!="")
	{
		$strTargetPair=" target='" . $hrefTarget . "' ";
	}
	//echo $strSQL;
	if (contains($strAdditionalLink, "^"))
	{
		$arrAdditionalLink=explode("^", $strAdditionalLink);
		$strAdditionalLink=$arrAdditionalLink[1];
		$strAdditionalLinkLabel=$arrAdditionalLink[0];
	}
	$out="";
	$strQSGlue="?";
	if (contains($strPHP, $strQSGlue))
	{
		$strQSGlue="&";
	}
	if ($strSQL!="")
	{
		//echo $strSQL;
		$rows =  $sql->query($strSQL);
		$rowcount=0;
		$strErrors=mysql_error();
		//echo $strErrors;
		if( count($rows)>0)
		{
			if ($strErrors=="" )
			{
				$preout= "<script src=\"" . tf_dir . "tf_tablesort.js\"><!-- --></script>";
				$preout.="<span class=\"heading\">" . $strLabel . "</span>";
				//$out.= "</td></tr>\n";
				foreach ($rows as $record )
				{
					if(!$bwlSuppressHeader)
					{
						$out.= "<tr class=\"" . $strThisBgClass . "\">\n";
					}
					if($rowcount==0)
						{	
							$fieldcount=0;
						 
							$fielddisplaycount=0;
							foreach($record as $k=>$v)
							{
								if($fieldcount<$intFieldLimit)
								{
									if(!inList($strSuppressFields, $k) && !$bwlSuppressHeader)
									{
										$out.="<td valign=\"top\">";
										$kdisplay="";
										
										
										if(is_array($arrFieldLabels))
										{
											//echo $k . "-" .$arrFieldLabels[$k] . "-" .  array_key_exists($k, $arrFieldLabels) . "<BR>"; 
										 	if(array_key_exists($k, $arrFieldLabels))
											{
												$kdisplay= gracefuldecay($arrFieldLabels[$k], " ");//hack to force something so it'll make it through the next test
											}
										}
										
										
										
										
								
									 	if($kdisplay=="")
										{
											if($bwlPrettyUpFieldNames)
											{
												$kdisplay=str_replace("_", " ", $k) ;
											}
											else
											{
												$kdisplay=$k;
											}
										}
										if($bwlPaginated)
										{
				
											$out.="<a class=\"" .$strOtherLineClass . "\" href=\"" . $_SERVER["PHP_SELF"] . "?" . replaceSpecificQueryVariable(qpre . "column" , $k, $_GET) . "\">" . $kdisplay . "</a>";
										}
										else
										{
											$out.="<a class=\"" .$strOtherLineClass . "\" href=\"javascript: SortTable('idsorttable', " . $fielddisplaycount . ")\">" . $kdisplay . "</a>";
										}
										$out.="</td>";
										$fielddisplaycount++;
									}
								}
								$arrFN[$fieldcount]=$k;
								if($strLinkIDName=="")
								{
									$strLinkIDName=$k;
								}
								$fieldcount++;
								
	
							}
							 
							if ($strAdditionalLink!="")
							{
								$out.="<td valign=\"top\">";
				 
								$out.=$strAdditionalLinkLabel;
								$out.="</td>";
							}
							if(!$bwlSuppressHeader)
							{
								$out.="</tr>\n";
							}
							
							$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
							$out.= "<tr class=\"" . $strThisBgClass . "\">\n";
						}
					$fieldcount=0;
					foreach($record as $k=>$v)
					{
						$bwlSkipTrunc=false;
						if($idencryptionstring!="")
						{
							$idtouse=urlencode(addletters($record[$strLinkIDName], $idencryptionstring));
						
						}
						else
						{
							$idtouse=$record[$strLinkIDName];
						}
						//echo $k . " " . $v . "<br>";
						if($fieldcount<$intFieldLimit)
						{
							if(!inList($strSuppressFields, $k))
							{
								$out.="<td valign=\"top\">";
								$body=$v;
								
								if($arrPostProcessing!="")
								{
									$postprocessingstring="";
									if(is_array($arrPostProcessing))
									{
										$postprocessingstring=$arrPostProcessing[$k];
										//echo "<br>---" . $postprocessingstring . "---- " . $body . "<P>";
										if($postprocessingstring!="")
										{
											//this part of postprocessing handles cases where postprocessing contains a ^
											//(do not use that for anything else!!)
											//if such a postprocessing string is found, then it is split on that and the first
											//item is taken to be a root url and the second item is taken to be column name
											//whose value will be looked up to append to the root url
											//the whole thing becomes an anchor tag for our item, which ends up hyperlinkes
										 	if(contains($postprocessingstring, "^"))
											{
												
												$arrSpecialLink=explode("^",$postprocessingstring);
												if ($truncate==1)
												{
													$bwlSkipTrunc=true;
													$body=simplelinkbody($body);
												}

												$body="<a ".$strTargetPair ."href='" .$arrSpecialLink[1] . $record[$arrSpecialLink[0]] . "'>" .   $body . "</a>";
												//echo $body . "<BR>";
											}
											else
											{
												if($body!=""  && $bwlSuppressLinksWhereNoData && $body!="0" )
												{
													$postprocessingstring=FixFormulaForEval($postprocessingstring, true);
													$postprocessingstring=str_replace("<value/>", $body, $postprocessingstring);
													$postprocessingstring=str_replace("<value>", $body, $postprocessingstring);
													
													//echo "-" . contains($postprocessingstring, "$value") . "-";
													//$postprocessingstring='<a href="view.php?table=login&login_id=15">dd</a>';
													if(!contains($postprocessingstring, "$value"))
													{
														//echo( "<P>==" . $postprocessingstring . "==<P>");
														//echo hexdump($postprocessingstring);
														 
														$value=	eval("return "  . $postprocessingstring . ";");
														//var_dump(error_get_last());
														//echo "$" . "value='" . $postprocessingstring . "';<BR>";
													}
													else
													{
													
														$value=	eval($postprocessingstring . ";");
													}
													//die($value);
													$bwlSkipTrunc=true;
													//echo $value . "<BR>";
													$body=$value;
												}
												else if($body=="0")
												{
													$body="";
												}
											}
										}
										
									
									}
								
								}								
								if ($truncate==1 && !$bwlSkipTrunc)
								{
									$body=simplelinkbody($body);
								}
								else
								{
									$body=str_replace(chr(10), chr(10) . "<br/>" , $body);
								}

								if (($fieldcount==0  && $strLinkFieldName==""  || $strLinkFieldName==$arrFN[$fieldcount])  && $strPHP!="")
								{
								  
									$body="<a ".$strTargetPair ."href=\"" .$strPHP . $strQSGlue . $strLinkIDName . "=" . $idtouse . "\">" . $body . "</a>";
								 
									
								}
								
								$out.=$body;
								$out.="</td>";
							}
						}
						
						$fieldcount++;
					}
					
					if ($strAdditionalLink!="")
					{
						//echo $rowcount . "<br>";
						$out.="<td valign=\"top\">";
 					
						$strThisAdditionalLink=str_replace("<replace/>", $idtouse, $strAdditionalLink);
						$strThisAdditionalLink=str_replace("<replace>", $idtouse, $strThisAdditionalLink); 
						$strThisAdditionalLink=str_replace("<rowcount/>", intval($rowcount), $strThisAdditionalLink); //added 9-13-2008
						$strThisAdditionalLink=str_replace("<rowcount>", intval($rowcount), $strThisAdditionalLink); //added 9-13-2008
						$timethrough=0;
						while(contains($strThisAdditionalLink, "<")  && $timethrough<4)//added 2-17-2010
						{	//eh kind of expensive!!
							foreach($record as $k=>$v)
							{
								$strThisAdditionalLink=str_replace("<" .$k .">", $v, $strThisAdditionalLink);
								$strThisAdditionalLink=str_replace("<" .$k ."/>", $v, $strThisAdditionalLink);
							}
							$timethrough++;
						}
						//echo $timethrough;
						//echo $strThisAdditionalLink. "<br>";
						$out.=$strThisAdditionalLink;
						$out.="</td>";
					}
					$rowcount++;
					
					$out.="</tr>\n";
					$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
				}
				if(!$bwlNoTableEncapsulate)
				{
					$out=$preout . TableEncapsulate($out, true, $intWidth);
				}
		 
			}
			else
			{
	 
				$errorout= "<tr>\n";
				$errorout.="<td valign=\"top\" class=\"" .$strLineClass  . "\" >";
				$errorout.="<span class=\"heading\">Errors:</span>";
				$errorout.= "</td></tr>\n";
				$errorout.= "<tr class=\"" . $strClassFirst . "\">\n";
				$errorout.="<td valign=\"top\"  >";
				$errorout.=$strErrors;
				$errorout.= "</td></tr>\n";
				if(!$bwlNoTableEncapsulate)
				{
					$out.= "<p>" . TableEncapsulate($errorout, false) . "</p>";
				}
			}
		}
	}
	return $out;
}

//function  GenericRSDisplay($strDatabase, $strPHP,$strLabel, $strSQL, $truncate, $intWidth, $strLinkFieldName="", $strLinkIDName="", $strAdditionalLink="", $strSuppressFields="", $bwlSuppressHeader=false, $bwlPrettyUpFieldNames=true, $intFieldLimit=10, $idencryptionstring="", $arrPostProcessing="", $arrFieldLabels="", $bwlSuppressLinksWhereNoData=true, $bwlNoTableEncapsulate=false, $hrefTarget="")


function  GenericRSDisplayFromRS($strPHP,$strLabel, $rows, $truncate, $intWidth, $strLinkFieldName="", $strLinkIDName="", $strAdditionalLink="", $strSuppressFields="", $bwlSuppressHeader=false, $bwlPrettyUpFieldNames=true, $intFieldLimit=10, $idencryptionstring="", $arrPostProcessing="", $arrFieldLabels="", $bwlSuppressLinksWhereNoData=true, $bwlNoTableEncapsulate=false, $hrefTarget="")
{
	//looks for <replace/> and replaces it with the PK!
	//also shows errors if there is a problem
	//judas gutenberg, July 8 2007
	//if $strAdditionalLink contains a ^ then the left half of that is the label for stringadditional
 	//now substitutes in a running <rowcount/> if needed as well as <replace/> for id
	//also now can post-process data in PHP using an associated array of fieldname=>"php_expression(<value/>)" passed in as $arrPostProcessing
 
	$strLineClass="bgclassline";
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strOtherBgClass="bgclassother";
	$strOtherLineClass="bgclassline";
	$strThisBgClass=$strLineClass;
	$arrFN=Array();
	
	$strAdditionalLinkLabel= "&nbsp;";
	$strTargetPair="";
	if($hrefTarget!="")
	{
		$strTargetPair=" target='" . $hrefTarget . "' ";
	}
	//echo $strSQL;
	if (contains($strAdditionalLink, "^"))
	{
		$arrAdditionalLink=explode("^", $strAdditionalLink);
		$strAdditionalLink=$arrAdditionalLink[1];
		$strAdditionalLinkLabel=$arrAdditionalLink[0];
	}
	$out="";
	$strQSGlue="?";
	if (contains($strPHP, $strQSGlue))
	{
		$strQSGlue="&";
	}
	//echo count(array_keys($rows));
	if(is_array(array_keys($rows)))
	{
		//$rows=Array($rows);
	}
	if (is_array($rows))
	{
	 
 
		$rowcount=0;
		//$strErrors=mysql_error();//find a tech agnostic way for this
		//echo $strErrors;
		if( count($rows)>0)
		{
			if ($strErrors=="" )
			{
				$preout= "<script src=\"" . tf_dir . "tf_tablesort.js\"><!-- --></script>";
				$preout.="<span class=\"heading\">" . $strLabel . "</span>";
				$out.= "</td></tr>\n";
				foreach ($rows as $record )
				{
					if(!$bwlSuppressHeader)
					{
						$out.= "<tr class=\"" . $strThisBgClass . "\">\n";
					}
					if($rowcount==0)
						{	
							$fieldcount=0;
						 	$fielddisplaycount=0;
					 
							foreach($record as $k=>$v)
							{
								if($fieldcount<$intFieldLimit)
								{
									if(!inList($strSuppressFields, $k) && !$bwlSuppressHeader)
									{
										$out.="<td valign=\"top\">";
										$kdisplay="";
										if(is_array($arrFieldLabels))
										{
											$kdisplay=$arrFieldLabels[$k];
										}
										
									 	if($kdisplay=="")
										{
											if($bwlPrettyUpFieldNames)
											{
												$kdisplay=str_replace("_", " ", $k) ;
											}
											else
											{
												$kdisplay=$k;
											}
										}
										$out.="<a href=\"javascript: SortTable('idsorttable', " . $fielddisplaycount . ")\">" . $kdisplay . "</a>";
										$out.="</td>";
										$fielddisplaycount++;
									}
								}
								$arrFN[$fieldcount]=$k;
								if($strLinkIDName=="")
								{
									$strLinkIDName=$k;
								}
								$fieldcount++;
								
	
							}
							 
							if ($strAdditionalLink!="")
							{
								$out.="<td valign=\"top\">";
								$out.=$strAdditionalLinkLabel;
								$out.="</td>";
							}
							if(!$bwlSuppressHeader)
							{
								$out.="</tr>\n";
							}
							
							$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
							$out.= "<tr class=\"" . $strThisBgClass . "\">\n";
						}
					$fieldcount=0;
					foreach($record as $k=>$v)
					{
					
						if($idencryptionstring!="")
						{
							$idtouse=urlencode(addletters($record[$strLinkIDName], $idencryptionstring));
						
						}
						else
						{
							$idtouse=$record[$strLinkIDName];
						}
						//echo $k . " " . $v . "<br>";
						if($fieldcount<$intFieldLimit)
						{
							if(!inList($strSuppressFields, $k))
							{
								$out.="<td valign=\"top\">";
								$body=$v;
								
								if($arrPostProcessing!=""  && $body!="")
								{
									$postprocessingstring="";
									if(is_array($arrPostProcessing))
									{
										$postprocessingstring=$arrPostProcessing[$k];
										//echo "<br>---." . $postprocessingstring . ".--'" . $k . "'-- " . $body . "<P>";
										if($postprocessingstring!="")
										{
											//this part of postprocessing handles cases where postprocessing contains a ^
											//(do not use that for anything else!!)
											//if such a postprocessing string is found, then it is split on that and the first
											//item is taken to be a root url and the second item is taken to be column name
											//whose value will be looked up to append to the root url
											//the whole thing becomes an anchor tag for our item, which ends up hyperlinkes
										 	if(contains($postprocessingstring, "^"))
											{
												
												$arrSpecialLink=explode("^",$postprocessingstring);
												if ($truncate==1)
												{
													$bwlSkipTrunc=true;
													$body=simplelinkbody($body);
												}
												$body="<a ".$strTargetPair ."href='" .$arrSpecialLink[1] . $record[$arrSpecialLink[0]] . "'>" .   $body . "</a>";
												//echo $body . "<BR>";
											}
											else
											{
												if($body!=""  && $bwlSuppressLinksWhereNoData)
												{
													$postprocessingstring=FixFormulaForEval($postprocessingstring, true);
													$postprocessingstring=str_replace("<value/>", $body, $postprocessingstring);
													$postprocessingstring=str_replace("<value>", $body, $postprocessingstring);
													
													//echo "-" . contains($postprocessingstring, "$value") . "-";
													//$postprocessingstring='<a href="view.php?table=login&login_id=15">dd</a>';
													if(!contains($postprocessingstring, "$value"))
													{
														//echo( "<P>==" . $postprocessingstring . "==<P>");
														//echo hexdump($postprocessingstring);
														eval("$" .   "value=" . $postprocessingstring . ";");
														// echo "$" . "value='" . $postprocessingstring . "';";
													}
													else
													{
													
														eval($postprocessingstring . ";");
													}
													//die($value);
													$bwlSkipTrunc=true;
													$body=$value;
												}
											}
							 
										}
										
									
									}
								
								}								
								if ($truncate==1)
								{
									$body=simplelinkbody($body);
								}
								else
								{
									$body=str_replace(chr(10), chr(10) . "<br/>" , $body);
								}

								if (($fieldcount==0  && $strLinkFieldName==""  || $strLinkFieldName==$arrFN[$fieldcount])  && $strPHP!="")
								 
								 {
									$body="<a ".$strTargetPair ."href=\"" .$strPHP . $strQSGlue . $strLinkIDName . "=" . $idtouse . "\">" . $body . "</a>";
									
								}
								
								$out.=$body;
								$out.="</td>";
							}
						}
						
						$fieldcount++;
					}
					
					if ($strAdditionalLink!="")
					{
						//echo $rowcount . "<br>";
						$out.="<td valign=\"top\">";
 
						$strThisAdditionalLink=str_replace("<replace/>", $idtouse, $strAdditionalLink);
						$strThisAdditionalLink=str_replace("<replace>", $idtouse, $strThisAdditionalLink); 
						$strThisAdditionalLink=str_replace("<rowcount/>", intval($rowcount), $strThisAdditionalLink); //added 9-13-2008
						$strThisAdditionalLink=str_replace("<rowcount>", intval($rowcount), $strThisAdditionalLink); //added 9-13-2008
						//echo $strThisAdditionalLink. "<br>";
						$out.=$strThisAdditionalLink;
						$out.="</td>";
					}
					$rowcount++;
					
					$out.="</tr>\n";
					$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
				}
				if(!$bwlNoTableEncapsulate)
				{
					$out=$preout . TableEncapsulate($out, true, $intWidth);
				}
		 
			}
			else
			{
	 
				$errorout= "<tr>\n";
				$errorout.="<td valign=\"top\" class=\"" .$strLineClass  . "\" >";
				$errorout.="<span class=\"heading\">Errors:</span>";
				$errorout.= "</td></tr>\n";
				$errorout.= "<tr class=\"" . $strClassFirst . "\">\n";
				$errorout.="<td valign=\"top\"  >";
				$errorout.=$strErrors;
				$errorout.= "</td></tr>\n";
				if(!$bwlNoTableEncapsulate)
				{
					$out.= "<p>" . TableEncapsulate($errorout, false, $intWidth) . "</p>";
				}
			}
		}
	}
	return $out;
}



function FrontEndTableForm($strDatabase, $strSQL, $strTable, $strIDField, $strPKValue, $strPHP,  $strHiddenList, $strDisplayOnlyList, $arrPassedInDefaults, $strConfigBehave, $strUser="", $bwlSuppressNewButton=false, $breadcrumb="", $bwlPlaintextPWD=false, $bwlSuppressSubmitButtons=false, $intWidth=630, $bwlSuppressTableNameOnButton=true, $bwlFriendlyLabels=false, $arrLabels="")
{
// echo $strPKValue . "=<br>";
//a generic form generator that looks at the table's description in the db and then dynamically builds an editor form
	$sql=conDB();
	$out="";
 
	$strValidationJS="";
	$width=50;
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
	$bwlDefaults=true;
 	$arrHelpText=Array();
	$arrPrettyName=Array();
	$arrValidationType=Array();
	$arrValidationPattern=Array();
	$arrWidth=Array();
	$arrHeight=Array();
	$arrIsPassword=Array();
	$arrIsFileUpload=Array();
	$intNestTable=0;
	$strNest=""; 
 	$strFieldsDone="";
	if($bwlSuperAdmin)
	{
	//echo "!";
	}
	if  ($strIDField=="")
	{
		$strIDField= idcolumname($strDatabase, $strTable);
	}

	if(substr($strSQL,strlen($strSQL)-1,1)=="=")
	{
		//echo "!";
		//total hacktacular!
		$strSQL="SELECT * FROM " . $strTable . "   LIMIT 0,1";
		$bwlDefaults=false;
	}
		
	//echo $strSQL;
	mysql_select_db($strDatabase);
	//echo $strSQL;
	$descr = $sql->query($strSQL);
	//echo count($descr) . "<BR>";
 	if (count($descr)<1)
	{
		//total hacktacular!
	 
		$strSQL="SELECT * FROM " . $strTable . "   LIMIT 0,1";
		$descr = $sql->query($strSQL);
		$bwlDefaults=false;
		 
	}
	//echo $strSQL;
	if (count($descr)<1)
	{
	
		$descr=RegularizeExplainedTable($strDatabase, $strTable);
	}
	//echo "count desc:" . count($descr) . "<BR>";
	if (count($descr)>0)
	{
		$descr=$descr[0];
		 
		if (!contains($strConfigBehave, "noform"))
		{
			$out.="<form enctype=\"multipart/form-data\" name=\"BForm\" method=\"post\" action=\"" . $strPHP . "\" onSubmit=\" return validate_form();\">\n";
		}
		$out.= "<input type=\"hidden\" name=\"" ."MAX_FILE_SIZE\" value=\"12000000\" />\n";
		$intDefaultWide=50;
	 	if($breadcrumb!="")
		{
			$out.= "<tr class=\"" . $strOtherBgClass . "\">\n";
			$out.= "<td colspan=\"" . intval(count($descr))  . "\">";
			
			
			if (!contains($strConfigBehave, "noheader"))
			{
				if (!contains($strConfigBehave,"closeclickrecycle"))
					{
						
						$intDefaultWide=90;
						$secondarytoollable=$strDatabase;
						$closebutton="";
						$disablelink=false;
					}
					else
					{
						$secondarytoollable="Secondary Editor";
						$closebutton="  [<a href=\"tf_message.php\">close this tool</a>]";
						$disablelink=true;
					}
		
				$out.=$breadcrumb. $closebutton;
			}
			
			$out.= "</td>\n";
			$out.= "</tr>\n";
	  	}
		$record="";
		$buttonEntityName=" " . $strTable;
		if($bwlSuppressTableNameOnButton)
		{
			$buttonEntityName="";
		}
		if ($strPKValue!=""  || $bwlSuppressNewButton)
		{
		
			//$strSQL="SELECT * FROM " . $strDatabase . "." . $strTable . " WHERE " .  $strIDField . " = '" . $strPKValue . "'";
			//echo $strSQL;
			$records = $sql->query($strSQL);
			$record=$records[0];
		
			$strOtherButtonText="New" . $buttonEntityName;
			$strButtonText="Save" . $buttonEntityName;
			
			$strMode="save";
			
		}
		else
		{
			$strButtonText="Create" . $buttonEntityName;
			$strMode="create";
		}
	 	if (contains($strConfigBehave,"closeclickrecycle"))
		{
			$strConfigBehave.="complete";
			
		}
	 	$futurelabel="";
		$strFromMulti="";
		$strTableLookingOutWith="";
		foreach ($descr as $fieldlabel=>$info)
			{
				
				//echo  $fieldlabel . " " . $info . "<BR>";
				$strPickerLink="";
				$skip=false;
 
				$name=$fieldlabel;
				$strFieldsDone.=" " . $name;
				$nameforhelp=$name;
				if(!inList($noshowfields, $name))
				{
					
					$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
					$strDefault="";
					
					$strTypeFull=GetFieldType($strDatabase, $strTable, $fieldlabel);
					if($strTypeFull=="")
					{
						$strTypeFull="varchar(50)";
					}
					$strType=TypeParse($strTypeFull, 0);
					
					$intLen=gracefuldecaynotzero(intval(TypeParse($strTypeFull, 1)), 25);
					//echo $name .  $strTypeFull . " " . $intLen . "<BR>";
					$width=$intLen+4;
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
					//echo $strHiddenList . " " . $fieldname . "<br>";
					//echo $name . " " . $strDefault . "<br>";
					if($bwlDefaults)
					{
						$strDefault=gracefuldecay($_GET[$fieldlabel], $record[$fieldlabel]);
						
					}
			 
					//echo "<b>" . $name . "</b> " . $strDefault . "<br>";
					$strDefault=gracefuldecay($_REQUEST[$fieldlabel], $arrPassedInDefaults[$fieldlabel],$strDefault) ;
					if ($bwlInvisible  || inList($strHiddenList, $fieldlabel))
					{
	 
						//echo $name . " " . $strDefault . "<br>";
						$out.="<input type=\"hidden\" name=\"" . $name . "\"   value=\"".  $strDefault . "\">\n";
						$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
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
								//wordencode($strPKValue, 6, time());
								//$idtouse=gracefuldecay($futureid,  $strPKValue);
								$idtouse=$strPKValue;
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
							
							//echo $fieldlabel . "-" .$arrPassedInDefaults[$fieldlabel] . "-" .  $strDefault . "<br>";
							$strDefault=substr($strDefault, 0, strlen($strDefault));
							
							//i have a real problem with single quotes!!!
							$strDefault=deendquote($strDefault);
						}
						
						//echo $_GET[$name] . " " .  $name  . "<br>";
						$strDefault=gracefuldecay($_GET[$name], $strDefault);
						$bwlHypLabel=false;
					 	
						
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
								$fieldform=foreigntablepulldown($strDatabase,$strDistantTable, $intDistantPK, $strDefault, $name, $strFromMulti, true);
								$strFieldLabelLink=qbuild($strPHP, $strDatabase, $strDistantTable, "edit", $intDistantPK, $strDefault). "&" . qpre . "backfield=" . $nameforhelp . "&" . qpre . "behave=closeclickrecycle";
							}
							$arrFK=RelationLookup($strDatabase, $strTable, $name,0);
							if (count($arrFK)>0)
							{
								//echo $strTable . " " . $name . "<BR>";
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
										//foreigntablepulldown(our_db,  $thistablename, $thistablepk, $strThisDefault, $thislocalfieldname, $namereturn,  false, $thistablelabelfield, "", $whereclause);
										//echo $arrFK[5] . "-<BR>";
										$fieldform=foreigntablepulldown($strDatabase,$arrFK[0], $arrFK[1], $strDefault, $name, $bleh, false,$arrFK[4], "", $arrFK[6],$record);
								 
									}
									else
									{
										$skip=false;
										$width =5;
										//$strPrettyLabelField=firstnonidcolumname($strDatabase, $arrFK[0]);
										$strPickerLabel=LabelForID($strDatabase, $arrFK[0], $arrFK[1], $strDefault);
										$strPickerLink= "<input style=\"font-size:9px; border:0px;\" class=\"" . $strThisBgClass . "\" type=\"text\" name=\"" .  qpre . "a|" .  $name . "\" size=\"20\" value=\"" . deescape($strPickerLabel)  . "\">\n";
										$strPickerLink.=" [<a href=\"#\" onclick=\"pickerwindow('". $strDatabase . "','" . $arrFK[0] . "','".   $name ."')\">browse</a>]\n";
										
									}
									//$fieldlabel=$info["foreign"]; //for foreign keys with dropdowns, label them with table name
									//add a link to an editor for the foreign key label because i'm all cool like that
									
									$strFieldLabelLink= qbuild($strPHP, $strDatabase, $arrFK[0], "edit", $arrFK[1], $strDefault) ."&" . qpre . "backfield=" . $nameforhelp . "&" . qpre . "behave=closeclickrecycle";
							 
							}
						 
							if ($bwlHypLabel)
							{
								if (contains($strConfigBehave,"nolinkstoothertools"))
								{
							 
								}
								else if (!contains($strConfigBehave,"complete"))
								{
									$fieldlabel="<a target=\"secondarytool\" href=\"". $strFieldLabelLink . "\">" . $fieldlabel . "</a>\n";
								}
							
								else
								{
									$fieldlabel="<a onclick=\"javascript:return(popdetachedwindow('" . $strFieldLabelLink . "','300','500'))\">" . $fieldlabel . "</a>\n";
								}
							}
					if (inlist("bigint mediumint int smallint", $strType))
					{
						 
						$width=5;
					}
					if  ($strType=="text" || $intLen>100)
					{
						$skip=true;
						$width=gracefuldecay($arrWidth[$nameforhelp],intval($intDefaultWide *.8));
						$height=gracefuldecay($arrHeight[$nameforhelp], intval(strlen($strDefault)/80)+2);
						
						if (textarea=="textarea" || $strType!="text"  || !class_exists("wysiwygPro"))
						{
							//old way: with textarea.  do this if no wysiwyg installed or the field type isn't actually text
							$fieldform="<textarea name=\"" .  $name . "\" cols=\"" . intval($width * $intWidth/630) . "\" rows=\"" .$height . "\">" .  $strDefault . "</textarea>\n";
						}
						else
						{
							//using wysiwygPro
					 		$height=gracefuldecay($arrHeight[$nameforhelp], intval(strlen($strDefault)/80)+12);
							$editorcount++;
							if($width<10)
							{
								$width=10;
							}
							if($height<70)
							{
								$height=70;
							}
							$editor[$editorcount]= new wysiwygPro();
							$editor[$editorcount]->set_code($strDefault);
							$editor[$editorcount]->set_name($name);
							$fieldform=$editor[$editorcount]->return_editor(gracefuldecay($arrWidth[$nameforhelp],$width *10),gracefuldecay($arrHeight[$nameforhelp],$height*5));
							 
						}
					}
					elseif  ($strType=="date"  || (contains($name, "datecode")  && function_exists("makedate")))//datecodes are ints of the form YYMMDD
					{
						if(contains($name, "datecode"))
						{
							$strDefault=makedate($strDefault);
						}
						$skip=true;
						$fieldform=datepulldowns( $name, $strDefault);
					}
					elseif  ($strType=="tinyint" || $strType=="bit" )
					{
						$skip=true;
						$fieldform=boolcheck( $name, $strDefault);
					}
					else 
					{
						$width=intval($width * ($intDefaultWide/90));
						
					}
					if ($info["Extra"]!="auto_increment"  && !$skip)
					{
					
						$strFormType="text";
						
						if (($name=="password"  || $arrIsPassword[$nameforhelp]==1) && !$bwlPlaintextPWD)
						{
							$strFormType="password";
						}
						if($strTableLookingOutWith !="" && (contains($name, "column") || contains($name, "field")))
						{
							//echo $strType . "-" . $strTableLookingOutWith . "<br>";
							//echo  $strTableLookingOutWith;
							
							$fieldform=FieldDropdown($strDatabase, $strTableLookingOutWith, $name, $strDefault);
							//$strTableLookingOutWith="";
							//TableDropdown($strDatabase, $strDefault,$name, "BForm","column_name");
						
						}
						elseif (contains($name, "table_name")) //special case for references to tables
						{
							// TableDropdown($strDatabase, $strDefaultTable, $strTableFormName, $strOurFormName='BForm', $strFieldFormName="")
							
							//time to speculate about the field names for the fields that goes with this table dropdown:
							//i have it so my primitive ajax tech can update all the selects automatically with a change of the table dropdown
							$blwNextColumn=false;
							$associatedColumnName="";
							foreach($descr as $fnom=>$finfo)
							{
								
								$fname=$finfo["Field"];
								//echo $fname . "=<br>";
								//echo $blwNextColumn . "%<br>";
								if ($fname==$name)
								{
									$blwNextColumn=true;
								}
								elseif ($blwNextColumn  && contains($fname, "_table"))
								{
									$blwNextColumn=false;
									break;
									
								}
								if ($blwNextColumn  && (contains($fname, "column") || contains($fname, "field")))
								{
									//i use plus here because i happen to know it is urlencoded space and i will later split on space on my hidden ajax page
									//and then cycle through all the select dropdowns that need to have their fields updated to reflect the new table
									$associatedColumnName.=$fname . "+" ;
									//$blwNextColumn=false;
									
								}
								
							}
							$associatedColumnName=RemoveEndCharactersIfMatch($associatedColumnName, "+" );
							//if associatedColumnName doesn't contain anything, then none of the fancy ajax stuff is turned on for this table select
							$fieldform=TableDropdown($strDatabase, $strDefault, $name, "BForm",$associatedColumnName);
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
							
							if (NeedsUpload($name)  || $arrIsFileUpload[$nameforhelp]==1)
							{	
								$path=fieldNameToFolderPath( $name, imagepath) . $strDefault;
								$ahtml="";
								$slasha="";
								if (file_exists($path))
								{
									$ahtml="<a href=\"#\" onclick=\"popwindow('" . $path . "', '" . 200 . "', '" . 500 . "','picwindow'); \">";
									$slasha="</a>";
								}
								$fieldform=   PictureIfThere($path, "100") . "\n";
								$width=intval($width*.5);
								$strFormType="file";
						 		$strAboveForm="&nbsp;&nbsp;&nbsp;" . $ahtml . $strDefault . $slasha . "<br>" . "<input type=\"hidden\" name=\"" .$name . "\"   value=\"".  $strDefault . "\">\n";
								
								$name=qpre . "u|" . $name;
								$strValString="";
							}
							if (inList($strDisplayOnlyList, $fieldlabel))
							{
								$fieldform=  "&nbsp;" . $strDefault . "\n";
								$fieldform.="<input type=\"hidden\" name=\"" .$name . "\" size=\"" . gracefuldecay($arrWidth[$nameforhelp],$width)  . "\" " . deescape($strValString) . ">\n";
							}
							else
							{
								$fieldform=$strAboveForm . "<input type=\"" . $strFormType . "\" name=\"" .$name . "\" size=\"" . gracefuldecay($arrWidth[$nameforhelp],$width) . "\" " . deescape($strValString) . ">\n" . $fieldform . $strPickerLink;
							}
						}
					}
					
					elseif ($info["Extra"]=="auto_increment"  && $strPKValue=="")
					{
						$fieldform="&nbsp;&nbsp;&nbsp;<strong>autoincrement:</strong> \n";
					}
					elseif ($info["Extra"]=="auto_increment" && $strPKValue!="")
					{
						$fieldform="&nbsp;&nbsp;&nbsp;<strong>" .  $strPKValue. "</strong> \n";
					}
					
					$out.="<tr class=\"" .  $strThisBgClass . "\">\n";
					$out.="<td valign=\"top\">\n";
					if(is_array($arrLabels))
					{
						if(array_key_exists($nameforhelp, $arrLabels))
						{
							$fieldlabel=$arrLabels[$nameforhelp];
						}
					}
					if(function_exists("DisplayColumnName"))
					{
						$out.=DisplayColumnName($fieldlabel) . "\n";
					}
					else
					{
						if($bwlFriendlyLabels)
						{
							$out.=str_replace("_", " ", $fieldlabel) . "\n";
				
						}
						else
						{
							$out.=$fieldlabel . "\n";
						}
					}
					$out.="</td>\n";
					$out.="<td>\n";
					$out.=$fieldform ; 
					
					//help link/text
			 
					
					$strHelpLink="return(false)";
				 
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
	
		$out.="<tr class=\"" . $strOtherBgClass . "\">\n<td colspan=2 align=\"right\">\n";
		if ($strPKValue!=""  && !$bwlSuppressNewButton )
		{

				$out.="<input class=\"genericbutton\"
	 name=\"" . qpre . "submit_clearid\" type=\"submit\" value=\"" . $strOtherButtonText ."\">\n";
		
		}
		if(1==1)
		{
				$strThisInputStyle="";
				if($bwlSuppressSubmitButtons)
				{
					$strThisInputStyle="display:none";
				
				}
			$out.="<input  style=\"" . $strThisInputStyle . "\" class=\"genericbutton\"
	     name=\"" . qpre . "submit\" type=\"submit\" value=\"" . $strButtonText ."\">\n";
		}
		$out.="</td>\n</tr>\n";
		$out.=HiddenInputs(array("dropdowntextvalue"=>"", "rec"=>$intRecord, "column"=>$strSort, "direction"=>$strDirection, "backfield"=>$strBackfield));//, "suppressnew"=>$bwlSuppressNewButton
		$out.=HiddenInputs(array("table"=>$strTable,"table"=>$strTable,"db"=>$strDatabase,"mode"=>$strMode,"idfield"=>$strIDField,"behave"=>$strConfigBehave),qpre, "");
		//$out.="<input type=\"hidden\" name=\"" .  $strIDField . "\"   value=\"".  $strPKValue . "\">\n";
		//if we pass in extra params beginning with qpre, then we can add them to the form to pass through
		foreach($arrPassedInDefaults as $k=>$v)
		{
			if(beginswith($k, qpre)  || !inList($strFieldsDone, $k))
			{
				//echo $k . " " .  $v . "<BR>";
				 $out.=HiddenInputs(Array($k=>$v), "") . "\n";
			}
		}
		if (strpos(" " . $strConfigBehave, "noform")<1)
		{
			$out.="</form>";
		}
		//$content, $bwlJSNumberForSort=true, $width="630"
		$out= TableEncapsulate($out, false, $intWidth);
		
		$out.="<p>";

	}
	
	$out.="\n<script>\nvalidationconfig='" . $strValidationJS . "'\n</script>\n";
	return $out;
}











function FrontEndSaveForm($strDatabase, $strTable, $strIDField, &$strValDefault, $strConfigBehave, $strUser="", $arrAdditionalVariables="", $strPKTypeFieldNames="")

//saves a form in the database and table, assuming all the form items have the names of the fields.
//skips fields beginning with qpre so I can pass data through without attempting to stuff it in the db.
//however, if it begins with  qpre  and ends with |day, |month, or |year, then we need to do special things because it is a date
//also handles file uploads having names of the form " . qpre . "u|FILENAME for which FILENAME is the corresponding field
//in the database.  
{
 	//die("DD");
 	$sql=conDB();
	$dataadded=0;
	$oldkey="";
	$strSuperPre=qpre;
	$arrUpdate=array();
	$strSQL="";
	$builtjs="";
	$bwlSuperAdmin=IsSuperAdmin($strDatabase, $strUser);
	$strExistsSQL="";
	foreach ($_POST as $k=>$v)
	{
		$v=removeslashesifnecessary($v);//deal with fucking get_magic_quotes_gpc nightmare!!
		if (contains($strConfigBehave, "updateopener"))
		{
			$builtjs.="\nif(opener.document.BForm['ret_" . $k . "'])
			\n{\nopener.document.BForm['ret_" . $k . "'].value='" . $v . "';\n}\n";
			

		}
		$isDate=false;
		//echo $k . " " . $v . "<br>\n";
		//looking to see if this item is perhaps a date
		if (strpos(" " . $k, qpre)==1)
		{
			//$arrPossibleDateName=explode( "|", $k);
			if (strpos($k, "|")>1) //then it might be a date input
			{
				//" . qpre . "a is for handback prettyname form inputs
				//" . qpre . "u is for $_FILES
				//we want to eliminate both of those
				$strPossibleDateName=parseBetween($k, qdelimiter, "|");
				if  (!inList("a u", $strPossibleDateName))
				{
			 ;
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
			}
			
		}
		if (strpos(" " . $k, qpre)<1  && strpos($k, "X_FILE_SIZE")<1 ) //here we're eliminating hidden variables i need to pass for bookkeeping
		{
		
			//handle any file uploads:
			//where i read in the files and copy them to their proper places if there are file uploads
				
			if ($_FILES[qpre . "u|" . $k]["name"]!="")
				{
					$destpath=fieldNameToFolderPath( $k, imagepath)  . $_FILES[qpre . "u|" . $k]['name'];
					//echo $destpath;
					//die();
					if (!BuildPathPiecesAsNecessary($destpath))
					{
						$out.="The path " .$destpath . " could not be built.<br>";
					}
					//ini_set("safe_mode_gid",0);
					//ini_set("safe_mode",0);
					//echo $destpath . " - " . $_FILES[ qpre . "u|" . $k]['tmp_name'] . "-<br>";
				 	//error_reporting(E_ALL);
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
			{

			 	if ($v=="[multi-placeholder]")
				{
					 $v = $_POST[qpre . "multi"];
				
				}
			 	if ($k=="create_date")//total hack!
				{
					$v=date("Y-m-d H:i:s");
				
				}
				if ($k!=$strIDField && $k!=$oldkey)
				{
					//echo $k . "=" .  $v . "-<br>\n";
					$strType=TypeParse(GetFieldType($strDatabase, $strTable, $k),0);
					if ($strType!="")
					{
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
						if (is_numeric($v)  && !$isDate)
						{
							$strRSQL= $k . "=" . $v;
							
						}
						else
						{
							//$arrUpdate[$k]=  "'".  htmlcodify($v) . "'" ;
							$strRSQL=  $k . "='" . htmlcodify($v) . "'";
							 //echo $arrUpdate[$k]. "<p>";
						}
						//allows odd pk type strings to define things a little better!!!
						if ($strIDField!=$k  && !is_string($v)  ||  inList($strPKTypeFieldNames, $k)) //in this system with no compound PKs, the primary key is useless in establishing the existance of an identical row.  the is_string part is to disregard this logic in the few cases where the PK is a string.  such tables are not proper tf style tables but they exist and we want to be able to edit them with tf
						{
							//echo $strRSQL . " " . $strPKTypeFieldNames . "--<br>";
							$strExistsSQL.=$strRSQL . " AND " ;
 
						}
	 
						$strSQL.=$strRSQL . ",";
						$dataadded++;
						$oldkey=$k;  //i do this to keep dates from trying to put the same field into the db three times
						//echo $k . " " . $v. "<br>";
					}
				}
			}
		}
		
	}
	
	//might need to add more to this
 
	if(is_array($arrAdditionalVariables))
	{
		foreach($arrAdditionalVariables as $k=>$v)
		{
			$strSQL.=  $k . "='" . htmlcodify($v) . "',";
			$dataadded++;
			 
		}
	
	
	}
	//remove last comma and " and "
	$strSQL=RemoveLastCharacterIfMatch($strSQL, ",");
	$strExistsSQL=substr($strExistsSQL, 0, strlen($strExistsSQL)-5);
	 
	$strExistsSQL="SELECT * FROM " . $strDatabase . "." .  $strTable . " WHERE " . 	$strExistsSQL;
	//echo $strExistsSQL. "-<br>";
	//echo $strValDefault . "-<br>";
	$rs=$sql->query($strExistsSQL);
	if (count($rs)<1  || $strValDefault!="")
	{
		
		$bwlBeginsWithTF=beginswith($strTable,  tfpre);
		if (($bwlBeginsWithTF &&  $bwlSuperAdmin) || !$bwlBeginsWithTF)
		{
			//echo $strValDefault . "-";
			if  ($strValDefault=="") //insert
			{
		 		//echo "INSERT INTO " . $strDatabase . "." .  $strTable . " SET " . $strSQL;
				$strSQL="INSERT INTO " . $strDatabase . "." .  $strTable . " SET " . $strSQL;
				$strDescrOfAction="added to";
				
				if(!hasautocount($strDatabase, $strTable))
				{
					$strISQL="SELECT MAX(" . $strIDField . ") as 'MAX' from " . $strDatabase . "." .  $strTable;
					$rs=$sql->query($strISQL);
					$r=$rs[0];
					$max=intval($r["MAX"])+1;
					$strSQL =$strSQL . "," . $strIDField . "=" . $max;
				}
				
			}
			else	//update
			{
		
				//echo "UPDATE " . $strDatabase . "." .  $strTable . " SET " . $strSQL . " WHERE " . $strIDField . " = " . $strValDefault;
				$strSQL="UPDATE " . $strDatabase . "." .  $strTable . " SET " . $strSQL . " WHERE " . $strIDField . " = '" . $strValDefault . "'";
				$strDescrOfAction="altered in";
			}
			//echo $strSQL;
			$sql->query($strSQL);
			//echo sql_error();
			$out.=  "A row of data was " . $strDescrOfAction. " the " . $strTable . " table in the " . $strDatabase . " database.";
		}
		else
		{
			$out.="You do not have permissions to alter this table.<br/>";
		
		}
		//i passed this in by reference so now i get to set it for the outside world to know and love
		$strValDefault = highestprimarykey($strDatabase, $strTable);
		
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
	
	return $builtjs .  $out;
	
}

function DefaultRequest($name, $default)
{
	if ($_REQUEST[$name]=="")
	{
		$_REQUEST[$name]=$default;
		$_POST[$name]=$default;
		$_GET[$name]=$default;
	}
}



function RegularizeExplainedTable($strDatabase, $strTable)
{
	//returns a set of records containing one record, identical to a record of null fields from $strTable -- useful as a template
	//for occasions when you need to build a form for a table having no stored data.
	//judas gutenberg
	//if $strTable contains a space, then assume we're making a form for two tables
	$arrOut=Array();
	$ro=Array();
	//$strTable="login client";
 	$arrTable=explode(" ", $strTable);
	$fieldsdone="";
	foreach($arrTable as $thisTable)
	{
		$rs=TableExplain($strDatabase, $strTable);
		foreach($rs as $r)
		{
			//echo $strTable . " " .  $fieldname . "-<br>";
			
			$fieldname=$r["Field"];
			if(!inList($fieldsdone, $fieldname))
			{
				$ro[$fieldname]="";
				$fieldsdone.=$fieldsdone . " ";
			}
		}
		
	}
	$arrOut[0]=$ro;
	return $arrOut;
}



function GatherRecordFromFormBasedOnTableSchema($strDatabase, $strTable)
{
	//given a table, gather info from a form and return it as an associative array
	$arrOut=Array();
	$records = TableExplain($strDatabase, $strTable);
	foreach ($records as $k => $info )
	{
		 $field= $info["Field"];
		 $arrOut[$field]=$_POST[$field];
 		 $type= $info["Type"];
		 if($type=="datetime")
		 {
		 	 $arrOut[$field]= RequestCompoundDate(qpre . $field);
		 }
	}
	return $arrOut;
}


function FormToSavedSchema(&$tablename, &$strPrimaryKey, $bwlJustSQL=false, $bwlForceLowerCase=true)
{
	$tablename=AppropriateSQLName(gracefuldecay($tablename, $_REQUEST[qpre. "table"], "table" . mt_rand(0, 9) . mt_rand(0, 9) . mt_rand(0, 9)));
	if( $bwlForceLowerCase)
	{
		$tablename=strtolower($tablename);
	}
	if(!TableExists(our_db, $tablename))
	{
		$possiblePK=$tablename . "_id";
		$strSQL="CREATE TABLE `" . $tablename . "` ( \n";
		$strSQL.="`" . $possiblePK . "` int(11) NOT NULL auto_increment,\n";
		
		foreach($_POST as $k=>$v)
		{
			$thisschemaline="";
			if(!beginswith($k, qpre) && $k!=$possiblePK)
			{
				$fieldname=AppropriateSQLName($k);
				if( $bwlForceLowerCase)
				{
					$fieldname=strtolower($fieldname);
				}
				if($v=="")
				{
					$thisschemaline="`" . $fieldname . "` varchar(50) NULL,\n";
				}
				else if (is_int($v))
				{
				
					$thisschemaline="`" . $fieldname . "` int(11) NULL,\n";
				}
				else
				{
					$thisschemaline="`" . $fieldname . "` varchar(50) NULL,\n";
				
				}
			
			}
			$strSQL.=$thisschemaline;
		}
 

		$thisschemaline=RemoveEndCharactersIfMatch($thisschemaline,"\n");
		$thisschemaline=RemoveEndCharactersIfMatch($thisschemaline,",");
		$strSQL.="PRIMARY KEY (`" . $possiblePK . "`)\n";
		$strSQL.=")\n";
		//echo $strSQL;
		if($bwlJustSQL)
		{
			return $strSQL;
		}
		else
		{
			$sql=conDB();
			$records = $sql->query($strSQL);
			//echo mysql_error();
		}
	}
}

function GenericFormSaver($strDatabase, $strTable, $strPrimaryKey, $strPKVal, $strFieldIgnoreList, $bwlDebug=false, $bwlWorkFromSchema=false, $bwlDontOverwriteWithNulls=true, $bwlCreateSchema=false, $strImageUploadKeyFieldName="", $strFieldForceRead="")
//simpler in that it doesn't try to do any file uploads
//if $bwlWorkFromSchema then only request form items that have corresponding field names in $strTable
//just added some code that treates $strTable as a space-delimited string of tables
//and puts fields present in one table in that table and fields present in the other table(s) and that/those
//this is somewhat complicated by the fact that in an insert, the returned autoincrement id of one table will have to be used in the second table
//with this in mind, i am making it so the first table in the list must be the first table inserted into, and any ids it returns in an insert may be used as an 
//fk in the second table -- update April 25 2010
//judas gutenberg
{
	//die($strFieldIgnoreList . "-");
	//foreach($_REQUEST as $k=>$v)
	{
		//echo $k . " *" . $v . "*<br>";
	}
	//echo $strTable;
	//die();
	//echo $strTable;
	$fieldsadded="";
	$arrIncidental=Array();
	$arrID=Array();
	if($strPKVal!=""  && $strPrimaryKey!="")
	{
		$arrID[$strPrimaryKey]=$strPKVal;
	}

	if($bwlCreateSchema  && !contains($strTable, " "))
	{
		FormToSavedSchema($strTable,$strPrimaryKey,false);
 
	}
 
	if($bwlWorkFromSchema)
	{
		$placetogetdata= GatherRecordFromFormBasedOnTableSchema($strDatabase, $strTable);
 
	}
	else
	{
		$placetogetdata=$_POST;
	}
	 
	//let's treat  $strTable as a space-delimited string of tables so we can update multiple tables if that's how things are going
	
	$arrTables=explode(" ", $strTable);
	//echo count($arrTables);
	$arrIncidental[$strThisTable]=Array();
	
	$arrForce=explode(" ",$strFieldForceRead);
	foreach($arrForce as $k)
	{
		if($placetogetdata[$k]=="")
		{
			$placetogetdata[$k]=0;
		}
	}
	foreach($placetogetdata as $k=>$v)
	{
		if($placetogetdata==$_REQUEST  || $placetogetdata==$_POST  || $placetogetdata==$_GET || $placetogetdata==$_COOKIE)
		{
			$v=removeslashesifnecessary($v);//deal with fucking get_magic_quotes_gpc nightmare!!
		}
		//echo $k . " " . $v . "<br>";
		if($k!="MAX_FILE_SIZE")
		{
			
			//echo $k . "<BR>";
			if(beginswith($k, qpre . "upload_keytorecord_")) //handle file uploads where we don't actually store the name of the uploaded file
			{
				//echo $k . " " . $v . "<br>";
				if(defined('userimagepath'))
				{
					$imageroot=userimagepath;
				}
				else if (defined('imagepath'))
				{
					$imageroot=imagepath;
				}
				$strNameOfNakedField=parseBetween($k,qpre . "upload_keytorecord_", "");
				//echo $strNameOfNakedField . "=<BR>";
				//echo  $strNameOfNakedField . "==" . $_FILES[$strNameOfNakedField]['name'] . "**" . $_FILES[$strNameOfNakedField]. " " . $_FILES[$strNameOfNakedField]['tmp_name'] . "<BR>";
				$arrExtension=explode(".",strtolower( $_FILES[$strNameOfNakedField]['name']));
				//echo $arrExtension . " " . count($arrExtension).  "=arrext<BR>";
			//	for($i=0; $i<count($arrExtension); $i++)
				//{
					//echo "k:" .  $arrExtension[$i] . "<BR>";
				//}
				$thisextension=gracefuldecay($arrExtension[count($arrExtension)-1], ".jpg");
		 		//echo $thisextension  . "=extension<BR>";
				//echo $placetogetdata[$strImageUploadKeyFieldName];
				
				$uploadpath= $imageroot . "/" . $placetogetdata[gracefuldecay($strImageUploadKeyFieldName, $strPrimaryKey)] . "." . strtolower($thisextension);
				//echo $uploadpath;
				if (!BuildPathPiecesAsNecessary($uploadpath))
				{
					echo  "The path to " .$uploadpath . " could not be built.";
					die();
				}
				//echo "nameofnaked=" . $strNameOfNakedField . " tmpname=" . $_FILES[$strNameOfNakedField]['tmp_name'] .  " " . $uploadpath . "=uploadfilename<BR>";
				if($_FILES[$strNameOfNakedField]['tmp_name']!="")
				{
					if (move_uploaded_file($_FILES[$strNameOfNakedField]['tmp_name'], $uploadpath))
					{
						chmod($uploadpath, 0777);
						
					}
					else
					{	
						
						echo  "The file " .$uploadpath . " could not be uploaded.";
						die();
					}
				}
				//die();
			
			}
			else if (!beginswith($k, qpre))
			{
				//echo $k . " " . $v . "<br>";
				if (!inList($strFieldIgnoreList, $k))
				{
					foreach($arrTables as $strThisTable)
					{
						
						if($bwlWorkFromSchema && GetFieldType($strDatabase, $strThisTable, $k)== "date")
						{
							//echo $k . " " . $v . "<br>";
							if (GetFieldType($strDatabase, $strThisTable, $k)== "date")
							{
								$v=RequestCompoundDate(qpre .  $k);
								if(!inList($fieldsadded, $k))
								{
									$arrIncidental[$strThisTable][$k]=singlequoteescape($v);
									$fieldsadded.=" " . $k;
								}
							}
						
						}
						else if(contains($k, "password")  && $v=="")
						{
							//dont save empty passwords
						}
						else
						{
									
									
							if( $k!=$strPrimaryKey)
							{
							 	//echo $strThisTable . " " . $k . "-beforefieldtest<br>";
								if(FieldExists($strDatabase, $strThisTable, $k))
								{
									
										//special moodle case hack:
								//	echo $strTable . " ----------- " . $k . "<br>";
									if($strTable=="mdl_user"   && $k=="password")
									{
										$v=md5($v);
									}
									//echo $k . " " . $v . "-somatic<br>";
									if($bwlDontOverwriteWithNulls && $v!="" || !$bwlDontOverwriteWithNulls)
									{
										if(!inList($fieldsadded, $k))
										{
											$arrIncidental[$strThisTable][$k]=singlequoteescape($v);
											$fieldsadded.=" " . $k;
										}
								
										//$arrIncidental[$strThisTable][$k]=($v);
										//echo $strThisTable . " " . $k . " " . $v . "<BR>";
									}
								}
								
							}
							else if($v!=""  && $strPKVal=="")
							{
								
								if(!inList($fieldsadded, $strPrimaryKey))
								{
										$arrID[ $strPrimaryKey]=($v);
										$fieldsadded.=" " . $strPrimaryKey;
								}
								//echo $k . " " . $v . "-id<br>";
							}
						}
					}
				}
			}
			
			else  //handle dates
			{
				//echo $k . " " . $v . "<br>";
				foreach($arrTables as $strThisTable)
				{
					 
					if (strpos($k, "|")>1) //then it might be a date input
					{
						//" . qpre . "a is for handback prettyname form inputs
						//" . qpre . "u is for $_FILES
						//we want to eliminate both of those
						$strPossibleDateName=parseBetween($k, qdelimiter, "|");
						
						if  (!inList("a u", $strPossibleDateName))
						{
							if(contains($k, "|day"))
							{
								$day=$_POST[qpre . $strPossibleDateName . "|day"   ];
								$month=$_POST[qpre . $strPossibleDateName . "|month" ];
								$year=$_POST[qpre . $strPossibleDateName . "|year" ];
								//echo "<br>#" . $strSuperPre  . $arrPossibleDateName[1] . "|year"; 
								//echo "<br>*".  $month . "-" . $day . "-" . $year . "*<br>";
					
					 			$strTime=ReasonableStringDate($month, $day, $year);
								//echo $strTime . "<br>";
								$v=$strTime; //just turning the value into a PHP timestamp
								$k=$strPossibleDateName;  //just turning the key back to a conventional key for the next section
								if(FieldExists($strDatabase, $strThisTable, $k))
								{
									//echo $k . " " .  makedatecode(strtotime($v)) . " " . $v . " ". function_exists("makedatecode") . "<BR>";
									
									if(contains($k, "datecode")  && function_exists("makedatecode")) //if it's a datecode it needs to be stored in as an int of the form YYMMDD
									{
										$v=makedatecode(strtotime($v));
									}
									$arrIncidental[$strThisTable][$k]=singlequoteescape($v);
									//echo "--" . $strThisTable . " " . $k . " " . $v . "<BR>";
								}
								//$isDate=true;  //i use this to make sure there are quotes around a date, which are necessary for some reason
							}
						}
					}
				}
			}
		}
	}
	//die();
	//echo "--" . count($arrIncidental) . "--" ;
	$lastTable="";
	//echo "<P>" . var_dump($arrIncidental) . "<P>";
	foreach($arrTables as $strThisTable)
	{

		if($thisPK!="")
		{
			$strLastPrimaryKeyname= PKLookup($strDatabase, $lastTable) ;
			//should do a lookup for weird cases, but this is fine for now
 
			//RelationLookup($strDatabase, $strTable, $strColumn="", $intType=0, $strForeignTable="", $strForeignColumn="")
			$arrRelation=RelationLookup($strDatabase, $strThisTable, "", 0, $lastTable, $strLastPrimaryKeyname);
			$additionalkeytouse= gracefuldecay($arrRelation["column_name"], $strLastPrimaryKeyname);
			$arrIncidental[$strThisTable][$additionalkeytouse]=$thisPK;
			//echo "<P>arrdump after create:" .   $strThisTable . "=" . var_dump($arrIncidental[$strThisTable]) . "=<P>";
		}
		//echo $strThisTable . "<br>";
		//$bwlDebug="die";
		//echo  $strThisTable . " " .  $strDatabase;
		//var_dump( $arrID);
		//echo "<BR>";
		//var_dump( $arrIncidental[$strThisTable]);
		//UpdateOrInsert($strDatabase, $strTable, $arrDescribedValuePairs, $arrAlteredValuePairs, $bwlEscape=true, $bwlDebug=false, $bwlDontFork=false)
		$thisPK=UpdateOrInsert($strDatabase, $strThisTable, $arrID, $arrIncidental[$strThisTable],true,  $bwlDebug);
		//echo mysql_error();
	

		
		//at this point we assume relation information is stored in tf_relation
		//but if not, we can wing it
		

		//$arrRelation["f_table_name"],  $arrRelation["f_column_name"]
		//RelationLookup($strDatabase, $strTable, $strColumn, $intType=0, $strForeignTable="")
		
		$lastTable=$strThisTable;
		
	}
	//echo "-" . $thisPK;
	//note, in multi-table situations, this will be coming from the last table where records were aded.
	$thisPK=gracefuldecay($thisPK, $strPKVal);
	return $thisPK;
}

?>