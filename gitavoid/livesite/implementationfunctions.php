<?php
include_once("tf/tf_functions_frontend_db.php");
//default fixes for some tables where tableform doesn't populate correctly:
$arrFix=Array();
$nowSQLtime=date("Y-m-d H:i:s");
if($_REQUEST["ID"]!="")
{
	$ID=$_REQUEST["ID"];
	if($_REQUEST[qpre . "table"]!="")
	{
		$strTable=$_REQUEST[qpre . "table"];
		$exists=GenericDBLookup(our_db,$strTable, "ID", $ID, "");
		//if($strTable=="USERS")
		{	
			if($strTable== articletable   && $exists["FT_WRITER"]=="" )
			{
				$arecord= GenericDBLookup(our_db,"USERS", "ID",$exists["AUTHOR_ID"], "");
				$ftauthor=$arecord["FIRST_NAME"] . " " . $arecord["LAST_NAME"];
				$arrFix["FT_WRITER"]=$ftauthor;
				
			}
			if($strTable==articletable)
			{
				$artrecord= GenericDBLookup(our_db,articletable, "ID", $ID, "");
				//clean up ms text whenever possible
				$text=$artrecord["TEXT"];
				$cleantoken="";
				//$cleantoken="<!#--cleaned-->";
				//if(!contains($text, $cleantoken))
				{
					$arrFix["TEXT"]=cleanHTML($text) . $cleantoken;
				}
				//die(cleanHTML($text) . "-"  . $cleantoken);
			}
			
			if($exists["ACTIVE"]=="")
			{
				$arrFix["ACTIVE"]=1;
			}
			if($exists["TIMESTAMP"]==""  || $exists["TIMESTAMP"]<"1970-01-01 12:22:00")  
			{
			//echo $nowSQLtime;
				$arrFix["TIMESTAMP"]=$nowSQLtime;
			}
			if(is_array($exists))
			{
				UpdateOrInsert(our_db, $strTable, Array("ID"=>$ID ), $arrFix);
			}
			
		}
	
	}


}
if($_REQUEST["x_TEXT_forceclean"]==1)
{

	$_POST["TEXT"]=fw_textprocess($_POST["TEXT"]);
	$_REQUEST["TEXT"]=fw_textprocess($_REQUEST["TEXT"]);
}

function CleanMicrosoftShit($strIn, $bwlClearBold=true)
{
//does anyone appreciate the abomination known as Microsoft HTML export?
	$bwlFresh=true;
	$strFound="";
 
	$strTags=" b font div span meta style";
	$strTags=$strTags . " " . strtoupper($strTags);
	$tags=explode(" ", $strTags);
	if(1==1)
	{
	foreach($tags as $tag)
	{
		//echo "<b>" . $tag . "</b><br>";
		$bwlFresh=true;
		$intStartingAt=0;
		while($strFound!=""  || $bwlFresh) //removes all parameters from tags 
		{
			$bwlFresh=false;
			$strStart="<" . $tag . " ";
			$strEnd=">";
			//echo $strStart . "~~~~~~~~~<br>";
			$strFound=parseBetween($strIn, $strStart, $strEnd, $intStartingAt);
			if($strFound!="")
			{
				$intStartingAt=strpos($strIn, $strFound,$intStartingAt+1);
				//echo $tag . " " . $strFound . "=<br>";
				//$pos1 = strpos($strIn, $strFound);
				//$out.=  substr($strIn,0,$pos1 );
				//$strIn=substr($strIn,$pos1);
				$strIn=str_replaceone($strFound, "", $strIn);
			}
			//echo $tag . " " . $strFound . "=<br>";
		}
	 
		
	}
	}
	if($bwlClearBold)
	{
		$strIn=TrashTag($strIn, "b");
	}
	
	$strIn=TrashTag($strIn, "meta");  
	$strIn=TrashTag($strIn, "o:p");  
 	$strIn=TrashTag($strIn, "span");  
	//$strIn=TrashTag($strIn, "div"); 
  	//$strIn=TrashTag($strIn, "h2");
	//$strIn=TrashTag($strIn, "h3");
	//$strIn=TrashTag($strIn, "h4");
	if(1==1)
	{
	$strIn=ReplaceTag($strIn, "h5", "p");
	$strIn=ReplaceTag($strIn, "h4", "p");
	$strIn=ReplaceTag($strIn, "h3", "p");
	$strIn=ReplaceTag($strIn, "h2", "p");
	$strIn=ReplaceTag($strIn, "h1", "p");
	}
	$strIn=str_ireplace(" ", " ", $strIn);
	$strIn=str_ireplace(",", ", ", $strIn);
	$strIn=str_ireplace(".", ". ", $strIn);
	$strIn= charspacingimprove("(", " ",   $strIn);
	$strIn= charspacingimprove("[", " ",   $strIn);
	$strIn= charspacingimprove("{", " ",   $strIn);
	$strIn= charspacingimprove(" ", ")",   $strIn);
	$strIn= charspacingimprove(" ", "]",   $strIn);
	$strIn= charspacingimprove(" ", "}",   $strIn);
	$strIn= charspacingimprove(" ", ".",   $strIn);
	$strIn= charspacingimprove(" ", ",",   $strIn);
	$strIn=str_ireplace(chr(10), " ", $strIn);
	$strIn=str_ireplace(chr(13), " ", $strIn);
	$strIn=str_ireplace("<p", chr(13) . "<p", $strIn);
	$strIn=deMultiple( $strIn, " ");
 	$strIn=str_replace("<di><>>>" , "", $strIn);
	$strIn=substr($strIn,strpos( $strIn, "<body "));
 
	return $strIn;
}	
	


	
function charspacingimprove($charprecedewrong, $charfollowwrong,   $strIn)
{
	$countfound=1;
	while($countfound>0)
	{
	 
		$strIn=str_replace($charprecedewrong . $charfollowwrong, $charfollowwrong . $charprecedewrong, $strIn, $countfound);
		 
	 
	}
	return $strIn;
}


function str_replaceone($search,  $replace, $subject, $intStartingAt=0)
{
	$pos1 = strpos($subject, $search, $intStartingAt);// + strlen($search);
	return substr($subject, 0, $pos1) . $replace . substr($subject, $pos1+strlen($search));

}

function WeirdCharacterFix($in)
{
	$in=str_replace(  chr(147), "'", $in);
	$in=str_replace(  chr(148), "'", $in);
	$in=str_replace(  chr(145), chr(39), $in);
	$in=str_replace(  chr(146),chr(39), $in);
	$in=str_replace(  chr(151), "--", $in);
	$in=str_replace(  chr(246), "o", $in);
	return $in;
}


function fw_textprocess($in)
{
	 
  	$in =WeirdCharacterFix($in);
	$in =FilterString($in, "32-126 13-13", " ");
	$in=deMultiple($in, " ");
	$in=cleanHTML($in);
	$in = str_replace("&nbsp;"," ",$in);
	//$in = str_ireplace("<p> <p>","<p>",$in);
 	//echo $in;
	$in=RemoveFirstCharacterIfMatch($in,"<div>&nbsp;</div>");
 	$bwlDontExpandCRs=false;
	$bwlOnlyExpandDoubleCRs=false;
	$lowerin=strtolower($in);
 	if(contains($lowerin, "<br>")  || contains($lowerin, "<p>")  )
	{
		$bwlDontExpandCRs=true;
	}
	else if (contains($lowerin, chr(13) .  ' ' . chr(13)))
	{
		//echo "$";
		$bwlOnlyExpandDoubleCRsWithSpace=true;
	}
	else if (contains($lowerin, chr(13) .   chr(13)))
	{
		//echo "$";
		$bwlOnlyExpandDoubleCRs =true;
	}
	if(contains($lowerin, "<o:"))
	{
		//$in =cleanHTML($in);
	}
	//fucking smart quotes:
	//$in=WeirdCharacterFix($in);
	//$in=str_replace(  chr(97), "&ouml;", $in);
	//$in=str_replace(  chr(59), "&ouml;", $in);
	$in=str_ireplace(  "[BR]", "<BR>", $in);
	$in=str_ireplace(  "[/BR]", "</BR>", $in);
	$in=str_ireplace(  "[P]", "<P>", $in);
	$in=str_ireplace(  "[/P]", "</P>", $in);
	$in=str_ireplace(  "[B]", "<B>", $in);
	$in=str_ireplace(  "[/B]", "</B>", $in);
	$in=str_ireplace(  "[I]", "<I>", $in);
	$in=str_ireplace(  "[/I]", "</I>", $in);
	$in=str_replace(  " ,", ", ", $in);
	$in=str_replace(  " .", ". ", $in);
	$in=str_replace(  " ,", ", ", $in);
	$in=str_replace(  " .", ". ", $in);

	//$in=deMultiple($in, " ");
 
	$in=str_replace(  "#--cleaned:", "", $in);
	if($bwlDontExpandCRs)
	{

		
 
	
	}
	else if($bwlOnlyExpandDoubleCRsWithSpace)
	{
		$in=str_replace( chr(13) .    ' '. chr(13),  "<br>", $in);
	}
	else if($bwlOnlyExpandDoubleCRs)
	{
		$in=str_replace( chr(13) .    chr(13),  "<br>", $in);
	}
	else
	{
 
		$in=str_replace( chr(13),  "<br>", $in);
 		$in=deMultiple( $in , " ");
		
	}
	$in=str_ireplace( "</p>", "<br>", $in);
	$in=str_ireplace( chr(13),  " ", $in);
	$in=deMultiple( $in , " ");
 	//echo "_" . $in . "_";
	$in=str_ireplace( "<em> </em>", "", $in);
	$in=str_ireplace( "<strong> </strong>", "", $in);
	$in=str_ireplace( "<b> </b>", "", $in);
	$in=str_ireplace( "<i> </i>", "", $in);
	$in=str_ireplace( "<p >",  "<p>", $in);
	//if($bwlDontExpandCRs)
	{
		$in=str_ireplace( "<p>", "<br><br>", $in);
		while(stripos(" " . $in, "<br> <br>")>0)
		{
			//echo "!\n";
			$in=str_ireplace( "<br> <br>", "<br><br>", $in);
		}
		while(stripos(" " . $in, "<br><br>")>0)
		{
			//echo "!\n";
			$in=str_ireplace( "<br><br>", "<br>", $in);
		}
		$in=str_ireplace( "<br>", "<br><br>", $in);
 
	}
 	//echo codeJustBeforeFound($in, "<BR><BR> <BR><BR>");
	return $in;
}






function TrashTag($strIn, $tagname)
{
//get rid of retarded html tags if simple
	$strIn=str_ireplace("<" . $tagname .">", "", $strIn);
	//$strIn=str_ireplace("<" . $tagname ." >", "", $strIn);
	//$strIn=str_ireplace("<" . $tagname , "<x", $strIn);
	$strIn=str_ireplace("</" . $tagname .">", "", $strIn);
	return $strIn;
}	

function ReplaceTag($strIn, $taglookfor, $tagreplace)
{
//get rid of retarded html tags if simple
	$strIn=str_ireplace("<" . $taglookfor .">", "<" . $tagreplace .">", $strIn);
	$strIn=str_ireplace("<" . $taglookfor ." >", "<" . $tagreplace .">", $strIn);
	$strIn=str_ireplace("</" . $taglookfor .">", "</" . $tagreplace .">", $strIn);
	return $strIn;
}	
function cleanHTML($html) 
{
 
	$html = ereg_replace("<(/)?(font|span|del|ins)[^>]*>","",$html);
	$html = ereg_replace("<(/)?(div)[^>]*>","<p>",$html);
	$html = ereg_replace("<([^>]*)(class|lang|style|size|face)=(\"[^\"]*\"|'[^']*'|[^>]+)([^>]*)>","<\\1>",$html);
	$html = ereg_replace("<([^>]*)(class|lang|style|size|face)=(\"[^\"]*\"|'[^']*'|[^>]+)([^>]*)>","<\\1>",$html);
	$html=str_replace( "-->", "", $html);
	$html=str_replace( "<!--", "", $html);
	$html=str_replace( "StartFragment", "", $html);
 
	$html=ReplaceTag($html, "div", "br");
	$html=ReplaceTag($html, "h1", "br");
	$html=ReplaceTag($html, "h2", "br");
	$html=ReplaceTag($html, "h3", "br");
	$html=ReplaceTag($html, "h4", "br");
	$html=ReplaceTag($html, "h5", "br");
	$html=ReplaceTag($html, "h6", "br");
	return $html;
}


function associated_list_OFFER($colname, $val, $startingtable="")
{
 	//die($colname . " " .  $val);
	$strUserURL="/tf/tf.php?x_behave=closeclickrecyclex_db=featurewell&x_table=USERS&x_mode=edit&x_idfield=ID&x_displaytype=&x_filterid=&x_rec=0&x_column=ID&ID=";
	$strArticleURL="/tf/tf.php?x_behave=closeclickrecyclex_db=featurewell&x_table=" . articletable  . "&x_mode=edit&x_idfield=ID&x_displaytype=&x_filterid=&x_rec=0&x_column=ID&ID=";
	$strPHP="/tf/tf.php?x_behave=closeclickrecyclex_db=featurewell&x_table=OFFER&x_mode=edit&x_idfield=ID&x_displaytype=&x_filterid=&x_rec=0&x_column=ID";
	if( $startingtable=="")
	{
	$strSQL="
	  select o.ID, Concat('$', FORMAT(o.OFFER,2)) as 'USD', o.TIMESTAMP, o.STATUS, USER_ID, u.USERNAME as 'username', ARTICLE_ID, a.TITLE as 'title', a.AUTHOR_ID, concat(AUTHOR_USER.FIRST_NAME, ' ', AUTHOR_USER.LAST_NAME) as author , TIMEDIFF(NOW(),o.TIMESTAMP) as ago from OFFER o left join USERS u on u.ID = o.USER_ID left join COUNTRY c on COUNTRY_CODE = c.PHONE_CODE join " . articletable . " a on a.ID = o.ARTICLE_ID left join USERS AUTHOR_USER ON AUTHOR_USER.ID = a.AUTHOR_ID   WHERE " . $colname. "='" . $val . "' order by o.TIMESTAMP DESC
 	";
	}
	else if( $startingtable==articletable)
	{
	  $strSQL="select o.ID, Concat('$', FORMAT(o.OFFER,2)) as 'USD', o.TIMESTAMP,o.STATUS,  USER_ID, u.USERNAME as 'username',  TIMEDIFF(NOW(),o.TIMESTAMP) as ago from OFFER o left join USERS u on u.ID = o.USER_ID left join COUNTRY c on COUNTRY_CODE = c.PHONE_CODE join " . articletable . " a on a.ID = o.ARTICLE_ID left join USERS AUTHOR_USER ON AUTHOR_USER.ID = a.AUTHOR_ID   WHERE " . $colname. "='" . $val . "' order by o.TIMESTAMP DESC
 	";
	}
	if( $startingtable=="USERS")
	{
	$strSQL="
	  select o.ID, Concat('$', FORMAT(o.OFFER,2)) as 'USD', o.TIMESTAMP, o.STATUS,   ARTICLE_ID, a.TITLE as 'title', a.AUTHOR_ID, concat(AUTHOR_USER.FIRST_NAME, ' ', AUTHOR_USER.LAST_NAME) as author , TIMEDIFF(NOW(),o.TIMESTAMP) as ago from OFFER o left join USERS u on u.ID = o.USER_ID left join COUNTRY c on COUNTRY_CODE = c.PHONE_CODE join " . articletable . " a on a.ID = o.ARTICLE_ID left join USERS AUTHOR_USER ON AUTHOR_USER.ID = a.AUTHOR_ID   WHERE " . $colname. "='" . $val . "' order by o.TIMESTAMP DESC
 	";
	}
		//echo $strSQL;
 	$out=    GenericRSDisplay(our_db, $strPHP,"Offers", $strSQL,1, 300 , "", "", "", "AUTHOR_ID ARTICLE_ID USER_ID", false, true, 10, "", 
	Array("TIMESTAMP"=>"date('D H:i',strtotime('<value/>'))", "author"=>"AUTHOR_ID^" . $strUserURL, "title"=>"ARTICLE_ID^" . $strArticleURL, "username"=>"USER_ID^" .$strUserURL ),"", true, false, "secondarytool");
// GenericRSDisplayFromRS($strPHP,$strLabel, $rows, $truncate, $intWidth, $strLinkFieldName="", $strLinkIDName="", $strAdditionalLink="", $strSuppressFields="", $bwlSuppressHeader=false, $bwlPrettyUpFieldNames=true, $intFieldLimit=10, $idencryptionstring="", $arrPostProcessing="", $arrFieldLabels="", $bwlSuppressLinksWhereNoData=true, $bwlNoTableEncapsulate=false, $hrefTarget="")
	$out=str_replace("idsorttable", "idsorttable1", $out);
	return $out;
 
}




function toolnav($isSuperAdmin=false,  $strUser="", $showNav=true) 
{

	//echo  $strUser;
	//die($strUser . " " . AdministerType(our_db,"", $strUser,  "",  ""));
	if( AdministerType(our_db,"", $strUser,  "",  "")<2 )
	{
		//header('location: /');
	}
	//generates a set of tabbed navigation links depending on the table being edited
	//$strPHP="tableform.php";
	$strTable=$_REQUEST[qpre . "table"];
	if ($strTable=="")
	{
		$strTable=default_table;
	}
	//$strPHP=$_SERVER['PHP_SELF'];
	$strPHP="/tf/tf.php";
	$mode=$_REQUEST[qpre . 'mode'];
	//this string contains all the internal language/table information this function needs
	//	$strConfig="Game Titles|game|Add Game Title*game|Add Wallpaper*wallpaper|Add Ringtone*ringtone|Add Review*review|Add Screenshot*screenshot-Carriers|carrier|Add Carrier*carrier-Handsets|handset|Add Handset*handset-News|news|Add News*news-Admins|admin|Add Admin*admin";
//Articles|article|Add Article*article-

//Offers|/tf/tf.php?x_db=featurewell&x_table=OFFER&x_mode=view&x_displaytype=&x_filterid=&x_launcherfield=&x_direction=DESC&x_column=ID|Create Offer From Scratch*onclick=\"remote=window.open('/invoicer.php?mode=fromscratch&ID=', 'invoicer','" . $windowconfig . "');remote.focus()\"-

	$windowconfig="menubar=yes,height=400,width=900,scrollbars=yes";
	$strConfig="
	Site Copy|content-
	Searches|search-
	Articles|/tf/articlelister.php|Add Article*" . articletable . "-
	Bookmarks|BOOKMARK|Add Bookmark*BOOKMARK-
	Users|/tf/userlister.php|Add User*USERS|Authors*/tf/userlister.php?type=A*|Admins*/tf/userlister.php?type=S*|Customers*/tf/userlister.php?type=C*-

	Offers|/tf/offerlister.php|Create Offer From Scratch*onclick=\"remote=window.open('/invoicer.php?mode=fromscratch&ID=', 'invoicer','" . $windowconfig . "');remote.focus()\"-
	Invoices|/tf/tf.php?x_db=featurewell&x_table=INVOICE&x_mode=view&x_displaytype=&x_filterid=&x_launcherfield=&x_direction=DESC&x_column=ID-Mailer|/mailer.php-
	Blotter|/blotter.php";
	$notselectedcolor ="topnav_notselected";
	$selectedcolor="topnav_selected";
	$width="100%";
	//banner and link particular to this implementation:
	$out="<a href=\"/index.php\" target=\"_blank\"><img src=\"/images/fwadmin.png\" alt=\"Featurewell\"     border=\"0\" align=\"absmiddle\"></a><span class=\"toolheader\">&nbsp;Content Management System</span><br/>";
	//$out.="<div align=\"right\"><a onclick=\"return(confirm('Are you certain you want do deploy all data in this staging database live?'))\" href=\"". $strPHP . "?" . qpre . "mode=copyup\">Deploy Data Live</a></div>\n";
	if ($showNav)
	{
 	$arrConf=explode("-", $strConfig);
	$out.= "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"" .$notselectedcolor  . "\" width=\"" . $width . "\">\n";
	$out.= "<tr>\n";
	$out.= "<td align=\"center\" valign=\"bottom\">\n";
	$out.= "<img src=\"" . imagepath . "/spacer.gif\" height=\"1\" width=\"1\"><br>\n";
	$out.= "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"" .$notselectedcolor  . "\" width=\"" . $width . "\">\n";
	$out.= "<tr>\n";
	$out.= "<td width=\"2\" class=\"" .$cellcolor  . "\">";
	//line between lower links
	$out.="<img src=\"" . imagepath . "/spacer.gif\" height=\"1\" width=\"2\">";
	$out.= "</td>\n";
	//this is where i scan through $strConfig data and spit out the upper row of links for table editors
	$killLowerMenu=false;
	for ($i=0; $i<count($arrConf); $i++)
	{
		$arrThis=explode("|", $arrConf[$i]);
		$cellcolor=$bgcolor;
		//if we're at a table being edited (or one of the game's tables) then this "selects" the tab
		//echo $arrThis[1] . " = " . $strTable . "<br>";
		$strOutTable=$arrThis[1];
		//echo $strOutTable . "* -" .  $strTable . "<br>";
		//echo  $_SERVER['PHP_SELF']. "*" . $strOutTable . "-- " .  $mode . "<BR>";
		$arrOutTable=explode("?", $strOutTable);
		//echo singularize(strtolower($_REQUEST[qpre . "table"])) . " " . singularize(strtolower($arrThis[0])) . "<BR>";
		//echo  $arrThis[0] . "<BR>";
		$strTestOutTable=$strOutTable;
		$possibletable=singularize(strtolower($_REQUEST[qpre . "table"]));
		$tablelizedlabel=singularize(strtolower($arrThis[0]));
		//echo $possibletable . "-" . $tablelizedlabel . "*" . $strTestOutTable .  "+" .$_SERVER['PHP_SELF'] . "<BR>";
		if (RemoveEndCharactersIfMatch($strOutTable, "!") ==RemoveEndCharactersIfMatch($strTable, "!") || $mode==$strOutTable      || ($_SERVER['PHP_SELF']==$strTestOutTable  && $possibletable ==""   || $tablelizedlabel==$possibletable))
		{
			
			if (!($mode=="help"  && $strOutTable!="help"))
			{
				$cellcolor=$selectedcolor;
				
			}
			else
			{
				$killLowerMenu=true;
			}
			//use this item for the lower row of links
			$arrTodealwith=$arrThis;
		
		}
		
		$out.= "<td class=\"". $cellcolor ."\" align=\"center\">\n";
 		//append some rev sorting:
		 
		$sortcolumn="ID";
		if($strOutTable=="search")
		{
			$sortcolumn="timestamp";
		}
		else if($strOutTable=="content")
		{
			$sortcolumn="content_id";
		}
		else if($strOutTable=="BOOKMARK")
		{
			$sortcolumn="TIMESTAMP";
		}
		$sortinghelp="&x_direction=DESC&x_column=" . $sortcolumn;
		if(contains($strOutTable, ".php"))
		{
			$out.="<a class=\"topnav\" href=\"". $strOutTable  . "\">";
		}
		else if ( $strOutTable =="help")
		{
			$out.="<a class=\"topnav\" href=\"". $strPHP . "?" . qpre . "mode=help&" . qpre . "table=" . $strTable . "\">";
		}
		else
		{
			$out.="<a class=\"topnav\" href=\"". $strPHP . "?" . qpre . "mode=view&" . qpre . "table=" . $strOutTable . $sortinghelp ."\">";
			
		}
		$out.= $arrThis[0];
		$out.= "</a>\n";
		$out.= "</td>\n";
		//vertical lines between upper links
		$dividercolor=$selectedcolor;
	
		if ($i==count($arrConf)-1)
		{
			//make the last divider not white
			$dividerclass =$notselectedcolor;
		
		}
		$out.= "<td width=\"1\" class=\"" .$dividerclass  . "\">";
		$out.="<img src=\"" . imagepath . "/spacer.gif\" height=\"1\" width=\"1\">";
		$out.= "</td>\n";
	}
	$out.= "</tr>\n";
	$out.= "</table>\n";
	
	$align.= "center";
	$bullet="";
	//echo $mode;
	$strStyle="";
	if ( $mode=="help")
		{	
			$align= "left";
			$mode="help";
			$bullet="<li>";
			$strStyle="style=\"text-indent:10px\"";
			$notselectedcolor="topnav_notselected";
			$class=$notselectedcolor;

			$selectedcolor="topnav_selected";
		}
	else
		{
			$mode="new";
		}
	if (!$killLowerMenu)
	{
		$out.= "<table " . $strStyle . " align=\"" . $align . "\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"" .$selectedcolor . "\" width=\"" . $width . "\">\n";
		$out.= "<td  align=\"" . $align . "\" width=\"2\" class=\"" .$notselectedcolor  . "\">";
		//line between lower links
		$out.="<img src=\"" . imagepath . "/spacer.gif\" height=\"1\" width=\"2\">";
		$out.= "</td>\n";
		//this is where i spit out the lower row of links for editors related to a table
		for ($i=2; $i<count($arrTodealwith); $i++)
		{
			$arrThis=explode("*", $arrTodealwith[$i]);
			if ( $mode=="help")
			{	
				$out.= "<tr>\n";
			}
			//echo $arrThis[1]  . "<br>";
			$out.= "<td  align=\"" . $align . "\" class=\"". $selectedcolor."\"  >\n";
			if(count($arrThis)>3)
			{
				$out.=$bullet . " <a class=\"topnav\" href=\"". $strPHP . "?" . qpre . "mode=view&" . qpre . "table=" . $arrThis[1] . "&" . qpre . "searchstring=" . $arrThis[2] . "&". qpre . "searchtype=" . $arrThis[3] .  "&". qpre . "searchfield=" .  $arrThis[4] . "\">";
			}
			else if(count($arrThis)>2)
			{
				$out.=$bullet . " <a class=\"topnav\" href=\"". $arrThis[1] . "\">";
			}
			else if(contains($arrThis[1], "onclick"))
			{
			 
				$out.=$bullet . " <a " . $arrThis[1] . " class=\"topnav\" href=#>";
			}
			else
			{
				$out.=$bullet . " <a class=\"topnav\" href=\"". $strPHP . "?" . qpre . "mode=" . $mode . "&" . qpre . "table=" . $arrThis[1] . "\">";
			}
			$out.= $arrThis[0];
			$out.= "</a>\n";
			$out.= "</td>\n";
			
			if ($i==count($arrTodealwith)-1)
			{
				//make the last divider not white
				$class =$selectedcolor;
			
			}
			$out.= "<td width=\"2\" class=\"" .$class  . "\">";
			//vertical lines between lower links
			$out.="<img src=\"" . imagepath . "/spacer.gif\" height=\"1\" width=\"2\">";
			$out.= "</td>\n";
			if ( $mode=="help")
			{	
				$out.= "</tr>\n";
			}
		}
		$out.= "</table>\n";
	}
	else
	{
		$out.= "<table border=\"0\" cellspacing=\"1\" cellpadding=\"0\" width=\"100%\" class=\"topnav_notselected\"><tr><td align=\"center\" class=\"topnav_selected\"><a class=\"topnav\" href=\"" . $strPHP . "?" . qpre . "mode=help\">See Complete Help Menu</a></td></tr></table>\n";
	
	}
	$out.= "</td>\n";
	$out.= "</tr>\n";
	$out.= "</table>\n";
	}
	return $out;
}


?>