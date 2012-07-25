<?php

function PseudoTagExpand($strIn, $strTagName, $val)
{
	$out=str_replace("<" . $strTagName . "/>", $val, $strIn);
	$out=str_replace("<" . $strTagName . ">", $val, $out);
	$out=str_replace("&lt;" . $strTagName . "&gt;", $val, $out);
	$out=str_replace("&lt;" . $strTagName . "/&gt;", $val, $out);
	return $out;
}

function htmlemaildownload($id, $strTemplateFilename)
{
	$data=ProcessTemplateWithDBRow(our_db, "email_promo", "email_promo_id", $id, $strTemplateFilename);
	downloadData($data, "text/html", "Email-" . $id . ".html");
}

function textemaildownload($id, $strTemplateFilename)
{
	$data=ProcessTemplateWithDBRow(our_db, "email_promo", "email_promo_id", $id, $strTemplateFilename);
	downloadData($data, "text/plain", "Email-" . $id . ".txt");
}
function ProcessTemplateWithDBRow($strDatabase, $strTable, $strIDFieldName, $id, $strTemplateFilename)
{
	//gets a row from the database and an HTML-based template file from the file system
	//and then cranks through the fields in the row, substituting their values for 
	//pseudotags in the HTML template having the form "<NAME_OF_FIELD/>
	//content inserted in this way can itself contain pseudotags
	if (filesize($strTemplateFilename)>0)
	{
		$fp = fopen ($strTemplateFilename, "r");
		$strTemplateText = fread($fp, filesize ($strTemplateFilename));
	}
	$strSQL="SELECT * FROM " . $strDatabase . "." . $strTable . " where " . $strIDFieldName . "=" . $id;
	$out=ProcessTemplateWithSQL($strSQL, $strTemplateText);
	return $out;
}

function ProcessTemplateWithSQL($sqlorarray, $strTemplateText)
{
	//gets a row from the database and an HTML-based template 
	//and then cranks through the fields in each row, substituting their values for 
	//pseudotags in the HTML template having the form "<NAME_OF_FIELD/>
	//content inserted in this way can itself contain pseudotags
	//if multiple rows are selected, it only deals with the first
	//March 22 2009: $sqlorarray can now just be an associative array, bypassing the db call
	
	$oldcontent="";
	$out="";
	$loopcount=0;
	//echo $strSQL . "<br>";
	//die($strSQL);
 
	if(is_array($sqlorarray))
	{
		$record=$sqlorarray;
	}
	else
	{
		$sql=conDB();
		$records = $sql->query($sqlorarray);
		$record=$records[0];
	}
		
	$content=$strTemplateText;
	//i use a while loop to permit the embedding of pseudotags within content
	while ($oldcontent!=$content && $content!=""  && $loopcount<20000)
	{
		foreach ($record as $field => $value )
		{
			$content=PseudoTagExpand($content, $field, $value);
			$oldcontent=$content;
		}
		$loopcount++;
	}
	$out=$content;
	//}
	return $out;
} 


function GetTemplatePath($id, $type)
{
	$sql=conDB();
	$strDatabase=our_db;
	$strSQL="SELECT * from " . our_db . ".email_promo e join  " . our_db . ".email_promo_type t on e.email_promo_type_id=t.email_promo_type_id WHERE e.email_promo_id=" . $id;
	$records = $sql->query($strSQL);
	$record=$records[0];
	if ($type=="text")
	{
		return "images/texttemplates/" . $record["texttemplate_filename"];
	}
	else
	{
		return "images/templates/" . $record["template_filename"];
	}

}



function SpamableList()
{

	$data=CommmaDelimitedDump(our_db, "bb_user","user_email", "", $strRowDelimiter=chr(13) . chr(10), false, "", "select user_email from " . our_db . ".bb_user where user_notify=1");
	downloadData($data, "text/plain", "EmailList.txt");
}

?>