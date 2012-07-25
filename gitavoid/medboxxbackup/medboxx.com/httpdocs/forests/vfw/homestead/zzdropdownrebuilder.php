<?php
//Judas Gutenberg January 2006
//provides a web front end admin tool for any mysql db
//i've modified txtsql to be aware of foreign keys so this tool can dynamically build complicated tools
//This code is covered under the GNU General Public License
//info here: http://www.gnu.org/copyleft/gpl.html
//the digest is as follows: you cannot modify this code without
//publishing your source code under the same license
//contact the developer at gus@asecular.com  http://asecular.com

include('core_functions.php');

echo main();

function main()
{
	$fieldDelimiter="=";
	$rowDelimiter="~";
	$strDelimiters=$fieldDelimiter . " " . $rowDelimiter;
	$bwlUpdateLabel=false;
	if(!IsExtraSecure())
	{
		die(ExtraSecureFailure());
	}
	$sql=conDB();
	$strBackfielddata=$_REQUEST[qpre . "backfielddata"];
	//echo  $strBackfielddata;
	//$strDatabase . "|" . $strTable . "|" . $idfield . "|" . $strBackfield . "|" . $strNameField . "|" . $strNameField2;
	$arrBFD=explode("|", $strBackfielddata);
	$strDatabase=deMoronizeDB(gracefuldecay($arrBFD[0],our_db));
	$strTable=$arrBFD[1];
	$idfield=$arrBFD[2];
	$strBackfield=$arrBFD[3];
	$strNameField=trim($arrBFD[4]);
	$strNameField2=trim($arrBFD[5]);
	$strOldIDField=$idfield;
	
	//var str=db +"|" + table + "|" + pkofremote  + "|" + selecttorepopulate + "|" + namefield+"|" + namefield2 + "|" + thisselectvalue; 
	//var str+="|" + rtable +"|" + rtablepkname;
	if(count($arrBFD)>7)
	{
		$thisID=$arrBFD[6];
		$strRTable=$arrBFD[7];
		$strRTablepkname=$arrBFD[8];
		$strRField=$arrBFD[9];
		
		//ok we're doing a multitable relation dropdown rebuild so we have to look up the relevant bits in the distant table based on the stuff in the remote table. remember, localtable->remotetable->distanttable
		//$arrMK=RelationLookup($strDatabase, $strTable, $name, 1);
		$strDistantTable=GenericDBLookup($strDatabase, $strRTable, $strRTablepkname, $thisID, $strRField);
	 	$strTable=$strDistantTable;
		$strNameField=firstnonidcolumname($strDatabase, $strDistantTable);
		$idfield=PKLookup($strDatabase, $strTable);
		$bwlUpdateLabel=true;
		//$strNameField2 = NthNonIDColumName($strDatabase, $strDistantTable, 2);
	}

	$out="<html><body>";
	$out.="<form name=\"BForm\" method=\"post\">\n";
	
	$strSQL="SELECT  * FROM " . $strDatabase . "." . $strTable . " ORDER BY "  . $strNameField ;
	if($strNameField2!="")
	{
		$strSQL.="," . $strNameField2;
	}
	$strSQL.=" LIMIT 0,50";
	 //echo $strSQL;
	$records = $sql->query($strSQL);
	foreach ($records as $record )
	{
		
		//$fields.=  $record[$idfield].  $fieldDelimiter .  KillDelimiters($record[$strNameField], $strDelimiters) . $fieldDelimiter . KillDelimiters($record[$strNameField2], $strDelimiters)  . $rowDelimiter;
		$fields.=  $record[$idfield].  $fieldDelimiter .  simplelinkbody(KillDelimiters($record[$strNameField], $strDelimiters))   . $rowDelimiter;
		
 	}
	
	$fields=RemoveEndCharactersIfMatch($fields,$rowDelimiter);

	//$out.="<input type=\"hidden\" name=\"fields\" value=\"" . $fields . "\">\n";
	//$out.="</form>";
	//ookay, once we've loaded the fields into that hidden field, time to build a dropdown in the launcher window
	$out.= "<script src=\"" . tf_dir . "tableform_js.js\"><!-- --></script>";
	$out.="<script>\n";
	$out.="foralert='';\n";
	//$out.="alert(\"" . $strRField . "-" . $idfield . "-" .  $strNameField . "\\n" . $strSQL . "\");";
	//$out.="alert('" .count($arrBFD) . "');";
	//$out.="alert('" . $strSQL . "');";
	//$out.="alert('" . $fields . "');";
	$out.="ourfields='" . $fields . "'\n";
	$out.="arrFields=ourfields.split('" . $rowDelimiter . "');\n";
	//$out.="alert(parent.document.BForm." . $strFieldFormName . ".type)\n";
	$out.="ourreturnfield='" . $strBackfield . "'\n";
	$out.="ourreturnid='" . $thisID . "'\n";
	//$out.="alert(ourreturnfield);";
	$out.="	if(parent.document.BForm[ourreturnfield])\n";
	$out.="	{\n";
	if($bwlUpdateLabel)
	{
		$out.="var thislabel=parent.document.getElementById('idmultitablelabel');\n";
		$out.=" thislabel.innerHTML='" . $strTable . "'\n";
		//ReplaceQueryStringVariable(strQuery, strName, newValue, newName, bwlEliminatePair)
		$out.="var thisurl= thislabel.href;\n";
		$out.="thisurl= thislabel.href;\n";
		$out.="var thisqs= GetQueryString(thisurl);\n";
		$out.="var oldqs=thisqs;\n";
 		$out.="thisqs=ReplaceQueryStringVariable(thisqs, '" . qpre . "table','" .$strTable . "');\n";
		$out.="thisqs=ReplaceQueryStringVariable(thisqs, '" . qpre . "idfield','" .$idfield . "');\n";
		$out.="var existingidfieldname=GetQueryStringVariable(thisurl, '" . qpre . "idfield');\n";
		//$out.="alert(existingidfieldname);\n";
		$out.="	if(existingidfieldname!='" . $idfield ."')\n";
		$out.="	{\n";
		$out.="		thisqs=ReplaceQueryStringVariable(thisqs, existingidfieldname,'ourreturnid','" .$idfield . "');\n";
		$out.="	}\n";

		$out.="thislabel.href=ReplaceQueryString(thislabel.href, thisqs);\n";
		$out.="thislabel.onclick=function()\n";
		$out.="{\n";
		$out.="var thisurl= thislabel.href;\n";
 
		$out.="var thisqs= GetQueryString(thisurl);\n";
		$out.="var thisidname=GetQueryStringVariable(thisurl, '" . qpre . "idfield');\n";
		$out.="var thisselect=parent.document.getElementById('id" . $strBackfield . "');\n";
		$out.="var newid= thisselect[thisselect.selectedIndex].value;\n";
		//$out.="alert('" . $strBackfield . "' + '\\n\\n:' + newid);\n"; 
		$out.="thisqs=ReplaceQueryStringVariable(thisqs,thisidname ,newid);\n";
		$out.="thislabel.href=ReplaceQueryString(thislabel.href, thisqs);\n";
		//$out.="alert(thisidname + '\\n\\n' + thisqs);\n";
		$out.="}\n";
		//$out.="alert('" . qpre . "table' + '\\n\\n' + '"  . $strTable . "' + '\\n\\n'  + oldqs +'\\n\\n' + thisqs);";
		//$out.=" thislabel.onclick='function(){return false}'\n";
		//$out.=" thislabel.target=null\n";
	}
	$out.="		parent.document.BForm[ourreturnfield].length=0\n";
	$out.="		if(parent.document.BForm[ourreturnfield].type=='text')\n";
	$out.="		{\n";
	$out.="			parent.document.BForm[ourreturnfield].type='select';\n";
	$out.="		}\n";
	$out.="		for(j=0; j<arrFields.length; j++)\n";
	$out.="		{\n";
	$out.="			thisreturnrow=arrFields[j]\n";
	$out.="			arrThisData=thisreturnrow.split('" . $fieldDelimiter . "');\n";
	$out.="			thisid=arrThisData[0]\n";
	$out.="			thisname=arrThisData[1]\n";
	$out.="			thisname2=arrThisData[2]\n";
	$out.="			if(!parent.document.BForm[ourreturnfield][j])\n";
	$out.="			{\n";
	$out.="				parent.document.BForm[ourreturnfield].length++;\n";
	$out.="			}\n";
	$out.="			if(thisname2)\n";
	$out.="			{\n";
	$out.="				parent.document.BForm[ourreturnfield][j].text=thisname + ' : ' + thisname2;\n";
	$out.="			}\n";
	$out.="			else\n";
	$out.="			{\n";
	$out.="				parent.document.BForm[ourreturnfield][j].text=thisname;\n";
	$out.="			}\n";
	$out.="			parent.document.BForm[ourreturnfield][j].value=thisid;\n";
	//$out.="	  	foralert = foralert + thisid + ' ' + thisname + '\\n';";
	$out.="			if(ourreturnid==thisid)\n";
	$out.="			{\n";
	$out.="				parent.document.BForm[ourreturnfield][j].selected=true;\n";
	//$out.="				parent.document.BForm[ourreturnfield][j].text+='#';\n";
	$out.="			}\n";
	$out.="			else \n";
	$out.="			{\n";
	$out.="				parent.document.BForm[ourreturnfield][j].selected='';\n";
	$out.="			}\n";
	$out.="		}\n";
	$out.="}\n";
	//$out.="alert(foralert);";
	$out.="</script>\n";
	$out.="</body></html>\n";
	return $out;
}

	
function KillDelimiters($strIn, $strDelimiters)
{
	$out=$strIn;
	$arrDelimiters=explode(" ", $strDelimiters);
	foreach($arrDelimiters as $a)
	{
		$out=str_replace($a, "", $out);
	}
	$out=str_replace("\n", " ", $out);
	$out=str_replace("\r", " ", $out);
	$out=str_replace(chr(34), "", $out);
	//$out=truncate($out,30);
	return $out;
}
?>