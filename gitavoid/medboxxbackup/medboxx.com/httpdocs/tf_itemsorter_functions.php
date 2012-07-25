<?php
//Gus Mueller August 2006
//php functions for a generic DHTML-based manual item sorter

function ItemSorter($strDatabase, $strTable,  $strIDField, $intID, $strSortField, $strFilterField, $intFilterID,  $strNameField, $strToJoinField="", $strToForeignTable="", $strFromJoinField="", $strFromForeignTable="")
//if we have a strToForeignTable then the strNameField is the Foreign Key to it, otherwise it is the Item we use to label Items in our list.  got it?
{
 
	$sql=conDB();
	$out="";
	$preout="";
	$length=50;
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
	$strOtherBgClass="bgclassother";
	$strThisBgClass=$strClassFirst;
	$strPHP=$_SERVER['PHP_SELF'];
	$strStyle ="none";
	$preout.= "<script src=\"tf_itemsorter.js\"><!-- --></script>";
	if ( $strTable=="")
	{
		$strStyle="block";
	}
	$preout.="<form name=\"BForm\" method=\"post\" action=\"" . $strPHP . "\" onSubmit=\" return validate_form();\">\n";
 
	$out.= "<tr class=\"" . $strOtherBgClass . "\"><td colspan=\"6\">\n";
	if($strTable=="")
	{
		//$out.= adminbreadcrumb(false,  $strDatabase, "tf.php?" . qpre . "db=" . $strDatabase,  "New Table");
	}
	else
	{
	// echo  $strFromForeignTable . " " . $strFilterField .  " " . $intFilterID;
		$filterdescriptor=LookupName($strDatabase, $strFromForeignTable,$strFilterField, $intFilterID);
		
		if ($strToForeignTable!="")
		{
			$arrangeditem=pluralize($strToForeignTable);
		 	
		
		}
		else
		{
			$arrangeditem=pluralize($strTable);
		}
		$out.= adminbreadcrumb(false,  $strDatabase, "tf.php?" . qpre . "db=" . $strDatabase, "arranger home", $strPHP,   "arranging " . $arrangeditem . " in the   " . $strTable . " table for " . $filterdescriptor , "");
	}
	$out.= "</td></tr>\n";
	$out.=htmlrow("bgclassline", "Select",   "ID", "Name", "Insert Item" );
	$outcount=0;
	$strUpDownArrows=UpDownArrows($outcount);
	 
	if ($strTable!="")
	{
		if ($strToForeignTable=="")
		{
			$strSQL="SELECT * FROM " . $strDatabase . "." .  $strTable . " WHERE " .  $strFilterField . "=" . $intFilterID . " ORDER BY " .  $strSortField . " ASC ";
			$strIDFieldToUse=$strIDField;
			$strTableForEdit=$strTable;
		 
		}
		else
		{
			$strSQL="SELECT * FROM " . $strDatabase . "." .  $strTable . " l JOIN " . $strDatabase . "." .  $strToForeignTable . " f ON l." . $strToJoinField . "=f." . $strToJoinField . "  WHERE " .  $strFilterField . "=" . $intFilterID . " ORDER BY " .  $strSortField . " ASC ";
			$strIDFieldToUse=$strToJoinField;
			$strTableForEdit=$strToForeignTable;
		 
		}

		$out.=htmlrow("hideallbutlast"
					, $strUpDownArrows
					,$r[$strIDFieldToUse]
					,"<a href=\"javascript: editItemG('" . $r[$strIDFieldToUse] . "','" .  $strIDFieldToUse .  "','" . $strTableForEdit . "')\">" .$r[$strNameField] . "</a>" 
					,"<a id=\"idaddItem" .  $outcount .  "\" href=\"javascript: createItemG('addItem" .intval($outcount ). "','','','" . $strFilterField. "','" . $intFilterID . "','" . $strSortField .  "','" . $strFilterField . "','" . $intFilterID .  "')\">here</a>" . HiddenInputs(array("pkid" . $outcount =>"")) 

				); 
 


		//echo $strSQL;
		$rs = $sql->query($strSQL);
		$outcount=1;
		//echo $strNameField . "<br>";
		//echo $strIDFieldToUse . "<br>";
		foreach ($rs as $r)
			{
	 
 				$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
				$strPickerLink="";
				$skip=false;
				$strUpDownArrows=UpDownArrows($outcount);
				$out.=htmlrow($strThisBgClass
				,$strUpDownArrows
				,$r[$strIDFieldToUse]
				,"<a href=\"javascript: editItemG('" . $r[$strIDFieldToUse] . "','" .  $strIDFieldToUse .  "','" . $strTableForEdit . "')\">" .$r[$strNameField] . "</a>" 
				,"<a id=\"idaddItem" .  $outcount .  "\" href=\"javascript: createItemG('addItem" .intval($outcount ). "','','','" . $strFromJoinField . "','" . $r[$strFromJoinField] . "','" . $strSortField . "','" . $strFilterField . "','" . $intFilterID .  "')\">here</a>" . HiddenInputs(array("pkid" . $outcount => $r[$strIDField])) 
				);
				
				$outcount++;
			}
	
	}
	else
	{

	
	
	}
	$out.="<tr class=\"bgclassline\" ><td colspan=\"2\">" .  SelectedTools() . "</td><td colspan=\"3\"  align=\"right\"><input type=\"submit\" value=\"Save Arrangement\" name=\"" . qpre . "submit\" /></td></tr>\n";
	$out=$preout . TableEncapsulate($out, false);
	$out.=HiddenInputs(array("mode"=>"save",  "db" =>$strDatabase,"table"=>$strTable, "idfield"=>  $strIDField, "Itemcount"=>$outcount, "delete"=>"",  "repositions"=>"", "filterfield"=>$strFilterField, "sortfield"=>$strSortField, "toforeigntable"=>$strToForeignTable, "fromforeigntable"=>$strFromForeignTable, "fromJoinField"=>$strFromJoinField,  "toJoinField"=>$strToJoinField,  "namefield"=> $strNameField));
	$out.=HiddenInputs(array($strFilterField=>$intFilterID), "");
	//empty hidden ret_inputs for inserts:
	$out.=HiddenInputs(array( $strFilterField =>"", $strToJoinField=>"",  $strNameField=>"", $strFromJoinField=>"",$strSortField=>""), "ret_");
	//list of
	$out.=HiddenInputs(array("frontendlist"=>  $strFilterField . "|" . $strToJoinField . "|" .$strNameField . "|".  $strFromJoinField . "|" . $strSortField));
	//bookkeeping of new item's id
	$out.=HiddenInputs(array("newitemid"=> ""));
	//what id did we get back from that insert?
	$out.=HiddenInputs(array("idfrominsert"=> "") );
	$out.=HiddenInputs(array("ret_" . qpre . "dropdowntextvalue"=> ""), "" );
	$out.="</form>\n";
	return $out;

}
	
function SelectedTools()
{
	$out="move selected: ";
	$out.="<a href=\"javascript:TRactionG('up')\">up</a>";
	$out.=" | ";
	$out.="<a href=\"javascript:TRactionG('down')\">down</a>";
	$out.=" | ";
	$out.="<a href=\"javascript:TRactionG('delete')\">delete selected</a>";
 	return $out;
}
	
function UpDownArrows($outcount)
{
	$strUpDownArrows="<input id=\"idswapItemd" . $outcount . "\" type=\"radio\" name=\"swapItemd" . $outcount . "\" onClick=\"trselectG(this.id)\">\n";
	return ($strUpDownArrows);
}
	

function AlterItems($strDatabase, $strTable,   $strIDField, $strSortField)
{

	$sql=conDB();
	$out="";
	$strPrevious="";
	$count=intval($_REQUEST[qpre . "Itemcount"]);
 	//echo $count;
	$newtable=false;
 
	for($i=0; $i<=$count; $i++)
	{
		//echo $_REQUEST[qpre . "Item-" . $i] . " " .  $_REQUEST[qpre . "type-" . $i] . " " .  $_REQUEST[qpre . "old-" . $i] . " " .   $_REQUEST[qpre . "length-" . $i] . "<br>";
		
		$thisItem=$_REQUEST[qpre . "pkid" . $i];
	 	//echo $thisItem . "-<br>";
		$strSQL="";

		if ($thisItem!="")
		{
			$strSQL="UPDATE " . $strDatabase . "." . $strTable . " SET " . $strSortField . "=" . $i . " WHERE " . $strIDField . "=" . $thisItem; 
		}
		if ($strSQL!="")
		{
			//echo $strSQL . "<br>";
			$r = $sql->query($strSQL);
		}
	}

	return $out;

}

function DeleteItems($strDatabase, $strTable, $strIDField, $DeleteItems)
{
	$sql=conDB();
	$arrThis=explode("|", $DeleteItems);
	for ($i=0; $i<count($arrThis); $i++)
	{
		$strThisItem=$arrThis[$i];
		if ($strThisItem!="")
		{
		
			$strSQL="DELETE FROM  " . $strDatabase  . "." . $strTable . "  WHERE " . $strIDField . "=" .  $strThisItem;
		
		}
		if ($strSQL!="")
		{
			//echo $strSQL . "<br>";
			$r = $sql->query($strSQL);
		}
	}
	return true;
}



?>