<?php
//Judas Gutenberg, Jan 4 2008
//compares two tables based on two fields in each and then, if matches exist, you can update second table with info based on these concordances 
//
//This code is covered under the GNU General Public License
//info here: http://www.gnu.org/copyleft/gpl.html
//the digest is as follows: you cannot modify this code without
//publishing your source code under the same license
//contact the developer at gus@asecular.com  http://asecular.com

set_time_limit(900);
include('tf_functions_core.php');
include('tf_core_table_creation.php');
echo main();

function main()
{
	if(!IsExtraSecure())
	{
		die(ExtraSecureFailure());
	}
	$concordance_id=$_REQUEST["concordance_id"];
	$mode=$_REQUEST[qpre . "mode"];
	$nooverwrite=$_REQUEST[qpre . "nooverwrite"];
	$noexceedone=$_REQUEST[qpre . "noexceedone"];
	$noexceedonedest=$_REQUEST[qpre . "noexceedonedest"];
	//for some reason single quotes are escaped when coming in off the $_REQUEST collection
	$table1=deescape($_REQUEST["table1"]);
	$table2=deescape($_REQUEST["table2"]);
	$field11=deescape($_REQUEST[ "field11"]);
	$field12=deescape($_REQUEST["field12"]);
	$field21=deescape($_REQUEST["field21"]);
	$field22=deescape($_REQUEST["field22"]);
	$fieldtoread=deescape($_REQUEST["field1toread"]);
	$fieldtowrite=deescape($_REQUEST["field2towrite"]);
	$strDatabase=deMoronizeDB(gracefuldecay($_REQUEST[qpre . "db"],our_db));
	$strPHP=$_SERVER['PHP_SELF'];
	$out="";
 	$out=LoginDecisions($strDatabase,  $strPHP, $strUser, false);
	if (IsSuperAdmin($strDatabase, $strUser)  && $strUser!="")
	{
		$intAdminType= AdministerType($strDatabase, $strTable, $strUser);
		$feedback="";
		if ($intAdminType>1)
		{
			if ($mode!="edit" && ($table1!=""  && $table2!=""  && $field21!=""  || $concordance_id!=""))
			{
				$out.=FindConcordances($strDatabase, $table1, $table2, $field11, $field12, $field21, $field22, $fieldtoread, $fieldtowrite, $mode, $nooverwrite, $noexceedone,$noexceedonedest, $concordance_id);
			}
			else 
			{
				$out.=TableConcordanceForm($strDatabase, $strPHP,  $concordance_id);
				$out.="<div class=\"heading\">Saved Concordances</div>";
				$out.=PreviousConcordances($strDatabase);
			}
		}
	}
	else if($strUser!="")
	{
		$out.=  "You do not have permissions to see this content.";
	}
	$out =  PageHeader($strDatabase . " : table concordance", $strConfigBehave) . "<script src=\"tf_tablesort.js\"><!-- --></script>" . $out . PageFooter();
	
	return $out;
}

function TableConcordanceForm($strDatabase, $strPHP, $concordance_id)
//Scan through two tables and try to find common items
{
	$sql=conDB();
	if($concordance_id!="")
	{
		$strSQL="SELECT * FROM " .  $strDatabase . "." .  tfpre . "concordance WHERE concordance_id='" . $concordance_id ."'";
		$records = $sql->query($strSQL);
		$record =$records[0];
	}
	$table1=$record["table_name_source"];
	$table2=$record["table_name_dest"];
	$field11=$record["column_source_1"];
	$field12=$record["column_source_2"];
	$field21=$record["column_dest_1"];
	$field22=$record["column_dest_2"];
	$fieldtoread=$record["column_for_read"];
	$fieldtowrite=$record["column_for_write"];
	
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$out="";
	$preout="";
	$preout.= adminbreadcrumb(false, $strDatabase, "tf.php" . "?" . qpre . "db=" . $strDatabase,  "table concordance", "", "choose tables and fields", "");
	$preout.= "<form method=\"post\" name=\"BForm\" action=\"tf_table_concordance.php\">\n";
	//$out.= $tableheader;
		//$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
	$out.=htmlrow("bglineclass", 
		"Source Table",
		TableDropdown($strDatabase, $table1,"table1", "BForm","field11+field12+field1toread")
		);
	$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
	$out.=htmlrow($strThisBgClass, 
		"Source Field 1",
		FieldDropdown($strDatabase, $table1, "field11", $field11)
		);
	$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
	$out.=htmlrow($strThisBgClass, 
		"Source Field 2",
		FieldDropdown($strDatabase, $table1, "field12",$field12)
		);
	$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
	$out.=htmlrow($strThisBgClass, 
		"Source Field to Read",
		FieldDropdown($strDatabase, $table1, "field1toread", $fieldtoread)
		);
	//$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
	$out.=htmlrow("bglineclass", 
		"Destination Table",
		TableDropdown($strDatabase, $table2, "table2", "BForm","field21+field22+field2towrite")
		);
	$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
	$out.=htmlrow($strThisBgClass, 
		"Destination Field 1",
		FieldDropdown($strDatabase,$table2,  "field21", $field21)
		);
	$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
	$out.=htmlrow($strThisBgClass, 
		"Destination Field 2",
		FieldDropdown($strDatabase,$table2,  "field22", $field22)
		);
	$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
	$out.=htmlrow($strThisBgClass, 
		"Destination Field to Write",
		FieldDropdown($strDatabase, $table2, "field2towrite", $fieldtowrite)
		);
	$out.=htmlrow($strThisBgClass, 
		"&nbsp;",
		GenericInput(qpre . "compare", "Find Concordant Rows in These Two Tables")
		);
	$out.="<tr><td colspan=\"2\" class=\"bgclassother\">";
	$out.="The Source Table is where the data will come from.  The Destination Table is where it will go.  Rows in the Destination Table can have their \"Destination Field to Write\" fields replaced with the content of  the Source Table's \"Source Field to Read\" for rows where the data in Source Field 1=Destination Field 1 and Source Field 2=Destination Field 2.  More options are available once the matches have been scanned.";
	$out.="</td></tr>";
	$out=$preout . TableEncapsulate($out);
	$out.=HiddenInputs(Array("concordance_id"=>$concordance_id), "", "");
	$out.="</form>\n";
	return $out;
}

function PreviousConcordances($strDatabase)
{
	$out="";
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$sql=conDB();
	$out.=htmlrow("bglineclass", 
		"<a href=\"javascript: SortTable('idsorttable2', 0)\">id</a>",
		"<a href=\"javascript: SortTable('idsorttable2', 1)\">source table</a>",
		"<a href=\"javascript: SortTable('idsorttable2', 2)\">field 1</a>",
		"<a href=\"javascript: SortTable('idsorttable2', 3)\">field 2</a>",
		"<a href=\"javascript: SortTable('idsorttable2', 4)\">destination table</a>",
		"<a href=\"javascript: SortTable('idsorttable2', 5)\">field to write</a>",
		"&nbsp;", "&nbsp;"
		);
	$strSQL="SELECT * FROM " .  $strDatabase . "." .  tfpre . "concordance";
	$records = $sql->query($strSQL);
	foreach($records as $record)
	{
		$concordance_id=$record["concordance_id"];
		$table1=$record["table_name_source"];
		$table2=$record["table_name_dest"];
		$field11=$record["column_source_1"];
		$field12=$record["column_source_2"];
		$field21=$record["column_dest_1"];
		$field22=$record["column_dest_2"];
		$fieldtoread=$record["column_for_read"];
		$fieldtowrite=$record["column_for_write"];
		$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
		$out.=htmlrow($strThisBgClass, "<a href=\"tf_table_concordance.php?" .qpre ."db=" . $strDatabase . "&concordance_id=" .  $concordance_id . "\">" . $concordance_id . "</a>",
			$table1,$field11, $field12,$table2, $fieldtowrite,
			"<a href=\"tf_table_concordance.php?" .qpre ."db=" . $strDatabase . "&" .qpre ."mode=edit&concordance_id=" .  $concordance_id . "\">edit</a>",
			"<a href=\"tf_table_concordance.php?" .qpre ."db=" . $strDatabase . "&" .qpre ."mode=view&concordance_id=" .  $concordance_id . "\">view</a>"
		);
	}
	$out=TableEncapsulate($out, true, 630, "idsorttable2");
	return $out;
}

function FindConcordances($strDatabase, $table1, $table2, $field11, $field12, $field21, $field22, $fieldtoread, $fieldtowrite, $mode, $nooverwrite, $noexceedone,$noexceedonedest, $concordance_id="")
{
	MakeTableIfNotThere($strDatabase, tfpre . "concordance", "MakeConcordanceTables");
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$bwlCantdo=false;
	$out="";
	$preout="";
	$sql=conDB();
	$pklist="";
	$outcount=1;
	$arrPKDestHitCount=Array();
		
	if($concordance_id!="")
	{
		$strSQL="SELECT * FROM " .  $strDatabase . "." .  tfpre . "concordance WHERE concordance_id='" . $concordance_id . "'";
		$records = $sql->query($strSQL);
		$record=$records[0];
		$table1=$record["table_name_source"];
		$table2=$record["table_name_dest"];
		$field11=$record["column_source_1"];
		$field12=$record["column_source_2"];
		$field21=$record["column_dest_1"];
		$field22=$record["column_dest_2"];
		$fieldtoread=$record["column_for_read"];
		$fieldtowrite=$record["column_for_write"];

		
	}
	$pktable1=PKLookup($strDatabase, $table1);
	$pktable2=PKLookup($strDatabase, $table2);
	if(contains($pktable1, " ") || contains($pktable2, " "))
	{
		$bwlCantdo=true;
	}
	if($concordance_id!="" && $mode!="rescan")
	{
		$strSQL="SELECT * FROM " .  $strDatabase . "." .  tfpre . "concordance_hit WHERE concordance_id='" . $concordance_id . "'";
		$records = $sql->query($strSQL);
		//echo count($records) . "---";
		foreach($records as $record)
		{
		

			$arrConcordance[$outcount]=
			Array(
				"outcount"=>$outcount,
				"rpk1"=>$record["table_source_pk"],
				"rfield11"=>$record["field1_content"],
				"rfield12"=>$record["field2_content"],
				"readfield"=>$record["readfield_content"],
				"rpk2"=>$record["table_dest_pk"],
				"matchcount"=>$record["source_matchcount"],
				"dest_matchcount"=>$record["dest_matchcount"],
				"readfieldtowrite"=>$record["fieldtowrite_content"]
				);
			$outcount++;
 			if(!inList($pklist, $record["table_dest_pk"]))
			{
				$pklist .=$record["table_dest_pk"] . " ";
			}
		}
	}
	else if(!$bwlCantdo)
	{
		EnsureNonRemote();
		UpdateOrInsert($strDatabase, tfpre . "concordance", Array("concordance_id"=>$concordance_id), Array("table_name_source"=>$table1, "table_name_dest"=>$table2, "column_source_1"=>$field11, "column_source_2"=>$field12, "column_dest_1"=>$field21, "column_dest_2"=>$field22, "column_for_read"=>$fieldtoread, "column_for_write"=>$fieldtowrite));
		if($concordance_id=="")
		{
			$concordance_id=mysql_insert_id();
		}
		$strSQL="SELECT " . $fieldtoread . "," . $pktable1 . "," . $field11 . "," .  $field12. " FROM " .  $strDatabase . "." .  $table1;
		//echo $strSQL;
		$records = $sql->query($strSQL);
		foreach($records as $record)
		{
			$rfield11= $record[ $field11];
		 	$rfield12= $record[ $field12];
			$readfield=$record[ $fieldtoread];
			$rpk1= $record[ $pktable1];
			$strSQL="SELECT * FROM " .  $strDatabase . "." .  $table2 . " WHERE " .  $field21 . "='" . $rfield11 . "' AND " . $field22 . "='" . $rfield12 . "'";
			$records2 = $sql->query($strSQL);
			$matchcount=count($records2);
			if($matchcount>0)
			{
				$record=$records2[0];
				$rpk2= $record[ $pktable2];
				if(!inList($pklist, $rpk2))
				{
					$pklist .=$rpk2 . " ";
				}
				$rfield21= $record[ $field21];
		 		$rfield22= $record[ $field22];
				$readfieldtowrite= $record[$fieldtowrite];
				if($arrPKDestHitCount[$rpk2]=="")
				{
					$arrPKDestHitCount[$rpk2]=0;
				}
				$arrPKDestHitCount[$rpk2]++;
				$arrConcordance[$outcount]=
					Array(
						"outcount"=>$outcount,
						"rpk1"=>$rpk1,
						"rfield11"=>$rfield11,
						"rfield12"=>$rfield12,
						"readfield"=>$readfield,
						"rpk2"=>$rpk2,
						"matchcount"=>$matchcount,
						"readfieldtowrite"=>$readfieldtowrite
						);
						
				UpdateOrInsert($strDatabase, tfpre . "concordance_hit", 
					Array(
						"concordance_id"=>$concordance_id, 
						"table_source_pk"=>$rpk1, 
						"table_dest_pk"=>$rpk2
						), 
					Array(
						"field1_content"=>$rfield11, 
						"field2_content"=>$rfield12, 
						"readfield_content"=>$readfield, 
						"fieldtowrite_content"=>$readfieldtowrite, 
						"source_matchcount"=>$matchcount, 
						"dest_matchcount"=>0
						)
					);
				$outcount++;
			}
		}

		//now update dest match counts
		foreach($arrPKDestHitCount as $k=>$v)
		{
			UpdateOrInsert($strDatabase, tfpre . "concordance_hit", 
					Array(
						"concordance_id"=>$concordance_id, 
						"table_dest_pk"=>$k
						), 
					Array(
						"dest_matchcount"=>$v
						)
					);
		}
	}
	else
	{
		$preout.="<div class=\"feedback\">Concordances between tables with composite primary keys are not supported.</div>";
	}
	$preout.= adminbreadcrumb(false, $strDatabase, "tf.php" . "?" . qpre . "db=" . $strDatabase,  "table concordance", "tf_table_concordance.php?" . qpre . "db=" .$strDatabase, "scan results", "");
	$preout.= " [<a href=\"tf_table_concordance.php?" . qpre . "db=" .$strDatabase . "\">new scan</a>]";
	if($concordance_id!="")
	{
		$preout.= " [<a href=\"tf_table_concordance.php?" . qpre . "db=" .$strDatabase . "&" . qpre . "mode=rescan&concordance_id=" . $concordance_id . "\" onclick='return(confirm(\"A rescan can take several minutes.  Are you certain this is what you want?\"))'>rescan</a>]";
	}
	$preout.="<br/>Looking for matches between source table <strong><a href=\"" . qbuild("tf.php", $strDatabase, $pktable1, "view", "", "") . "\">" . $table1 . "</a></strong> and destination table <strong><a href=\"" . qbuild("tf.php", $strDatabase, $table2, "view", $pktable2, $v) . "\">" . $table2 . "</a></strong>.<br/>";
	$preout.="Looking for data narrowed by <strong>" . $field11 . "</strong> and <strong>" . $field12 . "</strong> that corresponds to data narrowed by <strong>" . $field21 . "</strong> and <strong>" . $field22 . "</strong>.";
	$preout.= "<form method=\"post\" name=\"BForm\" action=\"tf_table_concordance.php\">\n";
	$out.=htmlrow("bglineclass", 
		"<a href=\"javascript: SortTable('idsorttable', 0)\">number</a>",
		"<a href=\"javascript: SortTable('idsorttable', 1)\">" .  $pktable1 . "</a>",
		"<a href=\"javascript: SortTable('idsorttable', 2)\">" .  $field11 . "</a>",
		"<a href=\"javascript: SortTable('idsorttable', 3)\">" .  $field12 . "</a>",
		"<a href=\"javascript: SortTable('idsorttable', 4)\">" .  $fieldtoread . "</a>",
		"<a href=\"javascript: SortTable('idsorttable', 5)\">" .  $pktable2 . "</a>",
		"<a href=\"javascript: SortTable('idsorttable', 6)\">matches<br/>per<br/>source</a>",
		"<a href=\"javascript: SortTable('idsorttable', 7)\">matches<br/>per<br/>dest</a>",
		"<a href=\"javascript: SortTable('idsorttable', 8)\">" .  $fieldtowrite . "</a>",
		"written?"
		);
	if(is_array($arrConcordance))
	{
		foreach($arrConcordance as $arrConcordanceHit)
		{
			$outcount=$arrConcordanceHit["outcount"];
			$rpk1=$arrConcordanceHit["rpk1"];
			$rfield11=$arrConcordanceHit["rfield11"];
			$rfield12=$arrConcordanceHit["rfield12"];
			$readfield=$arrConcordanceHit["readfield"];
			$rpk2=$arrConcordanceHit["rpk2"];
			$matchcount=$arrConcordanceHit["matchcount"];
			$readfieldtowrite=$arrConcordanceHit["readfieldtowrite"];
			
			$thisatag1="<a target=\"newwindow\" href=\"" . qbuild("tf.php", $strDatabase, $table1, "edit", $pktable1, $rpk1)  . "\">";
			$thisatag2="<a target=\"newwindow\" href=\"" . qbuild("tf.php", $strDatabase, $table2, "edit", $pktable2, $rpk2)  . "\">";
			$thislashatag="</a>";
			
	
			$written="no";
			if($mode=="write")
			{
				EnsureNonRemote();
				if($nooverwrite==1  &&  $readfieldtowrite==""  || $nooverwrite!=1)
				{
					if( $noexceedone==1 && $matchcount==1  || $noexceedone!=1)
					{
						if($noexceedonedest==1 && $arrPKDestHitCount[$rpk2]==1 || $noexceedonedest!=1)
						{
							UpdateOrInsert($strDatabase, $table2, Array($pktable2=>$rpk2), Array($fieldtowrite=> $readfield), $bwlEscape=true, $bwlDebug=false);
							
							if(sql_error()=="")
							{
								$written="yes";
							}
						}
					}
				}
			}
			$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
			$out.=htmlrow($strThisBgClass, 
				$outcount,
				$thisatag1 . $rpk1 . $thislashatag, 
				$rfield11, 
				$rfield12, 
				$readfield, 
				$thisatag2 . $rpk2 . $thislashatag,  
				$matchcount, 
				gracefuldecaynumeric($arrConcordanceHit["dest_matchcount"], $arrPKDestHitCount[$rpk2]),
				$readfieldtowrite, 
				$written
			);
		}
	}
	$out=$preout . TableEncapsulate($out);
	$pklist= RemoveEndCharactersIfMatch($pklist, " ");
	$arrPK=explode(" ", $pklist);
	$out.=HiddenInputs(Array( 
		"concordance_id"=>$concordance_id, 
		qpre ."mode"=>"write", 
		qpre . "nooverwrite"=>$nooverwrite, 
		qpre . "noexceedone"=>$noexceedone, 
		qpre . "noexceedonedest"=>$noexceedonedest, 
		"table1"=>$table1,
		"table2"=>$table2,
		"field11"=>$field11,
		"field12"=>$field12,
		"field21"=>$field21,
		"field22"=>$field22,
		"field1toread"=>$fieldtoread,
		"field2towrite"=>$fieldtowrite
		), "", "");
		 
	$out.="Count of unique records mapped in " . $table2 . ": " . count($arrPK) . "<br/>";
	$out.=CheckboxInput(qpre . "nooverwrite", 1, true) . "Do not overwrite existing data.<br/>";
	$out.=CheckboxInput(qpre . "noexceedone", 1, true) . "Do not use matches per source that exceed one.<br/>";
	$out.=CheckboxInput(qpre . "noexceedonedest", 1, true) . "Do not use matches per destination that exceed one.<br/>";
	$out.=
			GenericInput(qpre . "write", "Write " . $fieldtowrite . " field of " . $table2 . " with found " . $fieldtoread . " fields from " .  $table2 . ".", false, "return(confirm(\"Are you sure you want to do this?  Data may be lost in " . $table2 . "!\"))" );
	$out.="</form>\n";
	return $out;
}
?>

