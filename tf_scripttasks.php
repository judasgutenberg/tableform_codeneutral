<?php
//Judas Gutenberg July-November 2010
//sends back data headlessly for various tool needs, mostly for tf_db_map.php
//This code is covered under the GNU General Public License
//info here: http://www.gnu.org/copyleft/gpl.html
//the digest is as follows: you cannot modify this code without
//publishing your source code under the same license
//contact the developer at gus@asecular.com  http://asecular.com

include('tf_functions_core.php');
include('tf_functions_backup.php');
echo main();

function main()
	{
		$strClassFirst="bgclassfirst";
		$strClassSecond="bgclasssecond";
		$strOtherBgClass="bgclassother";
		$strLineClass="bgclassline";
		
		if(!IsExtraSecure())
		{
			die(ExtraSecureFailure());
		}
		$windowback=gracefuldecay($_REQUEST[qpre . "windowback"],"copypaster");
		$ajaxback=gracefuldecay($_REQUEST[qpre . "ajaxback"],"ajaxback");
		//$olderror=error_reporting(0);
		$mode=$_REQUEST[qpre . "mode"];
		$displaymode=strtolower($_REQUEST[qpre . "displaymode"]);
		$idfield=$_REQUEST[qpre . "idfield"];
		$id=$_REQUEST[qpre . "iddefault"];
		$strTable=$_REQUEST[qpre . "table"];
 		$x=$_REQUEST[qpre . "x"];
		$y=$_REQUEST[qpre . "y"];
		$z=$_REQUEST[qpre . "z"];
		$strDatabase=deMoronizeDB(gracefuldecay($_REQUEST[qpre . "db"],our_db));
  		$sql=conDB();
		error_reporting($olderror);
		$strPHP=$_SERVER['PHP_SELF'];
		$out="";
		if ($rec=="")
		{
			$rec=0;
		}
		//echo $id . " " .$idfield ;
		LoginDecisions($strDatabase,  $strPHP, $strUser, false);
		if ($strUser!="")
		{
	
			$intAdminType= AdministerType($strDatabase, $strTable, $strUser);
			
			if ($intAdminType>1)
				{
				 	if($mode=="sqldata")
					{
						
						$displaycontent=  GenerateDataSQL($strDatabase, $strTable, false, true);
						$strTitle =$strDatabase . " : " . $strTable . " : SQL data dump";
					}
					else if($mode=="sqlcreate")
					{
						$strSQL="SHOW CREATE TABLE " . 	$strDatabase. "." .$strTable ;
						$records = $sql->query($strSQL);
						$record=$records[0];
						//$displaycontent= $record["Table"];
						$displaycontent=  $record["Create Table"] . ";";
						$strTitle =$strDatabase . " : " . $strTable . " : SQL for create";
						
					}
					
					else if($mode=="tableinfo")
					{
					
						$records=TableExplain($strDatabase, $strTable,  false);


						$displaycontent=htmlrow("",   "<a class=\"mapdragbar\" id=\"iddrag-" . $strTable . "\">" . $strTable . "</a>");
						foreach($records as $record)
						{
							$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
							//$displaycontent.=htmlrow($strThisBgClass,  $record["Field"]) . "\n";	
							$strFieldName=$record["Field"] ;
							$thisfieldDivName="idfield-" .$strTable . "-" .$strFieldName;
							
							$displaycontent.="\n<tr class=\"" . $strThisBgClass  . "\"><td id=\"" .$thisfieldDivName  . "\"><a onmousedown=mrstart(\"" .$thisfieldDivName . "\") onmouseup=mrdone(\"" .$thisfieldDivName . "\") onmouseover=mrdrag(\"" .$thisfieldDivName . "\")  onmouseout=mrdragno(\"" .$thisfieldDivName . "\") class=mapfield>" . $strFieldName . "</a></td></tr>\n";
						}
						

						//$displaycontent= $record["Table"];
			 			$displaycontent=TableEncapsulate($displaycontent, false,"","idtable" .  $strTable);
					$displaycontent="<div id=\"iddiv-" .  $strTable . "\" style=\"position: absolute;top:" . $y . "px;z-index:" . $z . ";left:" . $x . "px;\">" . $displaycontent . "</div>";
						$strTitle =$strDatabase . " : " . $strTable . " : SQL for create";
						
					}
				}
				
				
				
				
				
		}
		if($displaymode=="ajax")
		{
			$displaycontent= str_replace(chr(13), "\\n" ,  str_replace(chr(10), " " , $displaycontent));
			$out.="<html><head><script>\n";
			$out.="setTimeout(thingstodo,220);\n";
			$out.="function thingstodo()\n";
			$out.="{\n";
			//at some point i'll want to be able to dynamically say which div is getting modified by this script
			$out.="thisdiv=" . $windowback .".document.getElementById('" . $ajaxback . "');\n";
			//$out.=str_replace("\n", "", $displaycontent);
			$out.="thisdiv.innerHTML='" . $displaycontent . "' + thisdiv.innerHTML \n";
			//$out.=";//+ thisdiv.innerHTML;\n\nalert('" . $displaycontent. "');\n";
			$out.="}\n";
			$out.="</script></head></html>\n";
		}
		else if($displaymode=="text")
		{
			$out.="<html><head>\n";
			$out.="<title>" . $strTitle . "</title>\n";
			$out.="</head>\n";
			$out.="<body><plaintext>\n";
			$out.=$displaycontent;
			//$out.="</body>\n";
			//$out.="</html>\n";
		
		}
		else if($displaymode=="html")
		{
			$out.="<html><head>\n";
			$out.="<title>" . $strTitle . "</title>\n";
			$out.="</head>\n";
			$out.="<body>\n";
			$out.=$displaycontent;
			//$out.="</body>\n";
			//$out.="</html>\n";
		
		}
		//($strTitle, $strConfigBehave,$strForBackField="", $bwlIsStandalone=true, $bwlSuppressExternalHeader=false)
		//$out =  PageHeader($strDatabase . " : Foreign Referrals", $strConfigBehave, "", true, true, "", $strDatabase) . $out . PageFooter(true, false, true);
		
		return $out;
	}
 
?>