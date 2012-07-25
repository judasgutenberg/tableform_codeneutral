<?php
//Judas Gutenberg January 2006
//provides a web front end admin tool for any mysql db
//this page appears in an iframe to show links to rows in  tables to which the parent table is foreign
//i've modified txtsql to be aware of foreign keys so this tool can dynamically build complicated tools
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
	
		if(!IsExtraSecure())
		{
			die(ExtraSecureFailure());
		}
		//$olderror=error_reporting(0);
		$mode=$_REQUEST[qpre . "mode"];
		$displaymode=strtolower($_REQUEST[qpre . "displaymode"]);
		$idfield=$_REQUEST[qpre . "idfield"];
		$id=$_REQUEST[qpre . "iddefault"];
		$strTable=$_REQUEST[qpre . "table"];
 
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
				}
				
				
				
				
				
		}
		if($displaymode=="ajax")
		{
			$displaycontent= str_replace(chr(13), "\\n" ,  str_replace(chr(10), " " , $displaycontent));
			$out.="<html><head><script>\n";
			$out.="setTimeout(thingstodo,200);\n";
			$out.="function thingstodo()\n";
			$out.="{\n";
			//at some point i'll want to be able to dynamically say which div is getting modified by this script
			$out.="thisdiv=copypaster.document.getElementById('ajaxback');\n";
			$out.=$displaycontent;
			$out.="thisdiv.innerHTML= \"";
			$out.="\";//+ thisdiv.innerHTML;\n\nalert(\"" . $displaycontent. "\");\n";
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
		//($strTitle, $strConfigBehave,$strForBackField="", $bwlIsStandalone=true, $bwlSuppressExternalHeader=false)
		//$out =  PageHeader($strDatabase . " : Foreign Referrals", $strConfigBehave, "", true, true, "", $strDatabase) . $out . PageFooter(true, false, true);
		
		return $out;
	}
 
?>