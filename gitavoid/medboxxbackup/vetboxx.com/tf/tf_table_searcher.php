<? 
//Judas Gutenberg Spring 2006
//This code is covered under the GNU General Public License
//info here: http://www.gnu.org/copyleft/gpl.html
//the digest is as follows: you cannot modify this code without
//publishing your source code under the same license
//contact the developer at gus@asecular.com  http://asecular.com

include('tf_functions_core.php');
include('tf_functions_editor.php');

echo main();

function main()
{
	if(!IsExtraSecure())
	{
		die(ExtraSecureFailure());
	}

	
	//$olderror=error_reporting(0);
	$mode=$_REQUEST[qpre . "mode"];
	$idfield=$_REQUEST[qpre . "idfield"];
	$launcherfield=$_REQUEST[qpre . "launcherfield"];
	$id=$_REQUEST[qpre . "iddefault"];
	$strTable=$_REQUEST[qpre . "table"];
	$strDatabase=deMoronizeDB(gracefuldecay($_REQUEST[qpre . "db"],our_db));
	$strColumn=$_REQUEST[qpre . "column"];
	$strDirection=$_REQUEST[qpre . "direction"];
	$strConfigBehave=$_REQUEST[qpre . "behave"];
	$strSearchField=$_REQUEST[qpre . "searchfield"];
	$strSearchString=$_REQUEST[qpre . "searchstring"];
	$intRecord=$_REQUEST[qpre . "rec"];
	$intSearchType=$_REQUEST[qpre . "searchtype"];
	error_reporting($olderror);
	$strPHP=$_SERVER['PHP_SELF'];
	$out="";
	//echo $id . " " .$idfield ;
	$out=LoginDecisions($strDatabase,  $strPHP, $strUser, true);
	
	if ($strUser!="")
	{
	
		$intAdminType= AdministerType($strDatabase, $strTable, $strUser);
 
		if ($intAdminType>1)
			{
				 
			if ($intSearchType=="")
			{
				$intSearchType=0;
			}
			if ($intRecord=="")
			{
				$intRecord=0;
			}
			
			$out.= "
			<script>
					function handback(tablename, fieldname, thisvalue, prettyname, returnfield, returnid)
					{
						targetfield='" .$launcherfield . "';
						if (opener.document.BForm)
						{
							opener.document.BForm." . $launcherfield . ".value=thisvalue;
							opener.document.BForm[\"" . qpre . "a|" . $launcherfield . "\"].value=prettyname;
						}
						else
						{
							
							opener.top.secondarytool.location.href='tf.php?' +  returnfield + '=' +  returnid + '&" . qpre . "table=" . $strTable . "&" . qpre . "mode=edit&" . qpre . "id=' + thisvalue + '&" . qpre . "idfield=' + fieldname + '&' + fieldname + '=' + thisvalue + '&" . qpre . "behave=closeclickrecycle';
						}
						window.close();
					}
			
			</script>
					";
			
			$out.=  DisplayDataTable($strDatabase, $strTable, $idfield, $strColumn, $strPHP, $strDirection, $intRecord, $strSearchString, $strSearchField, $intSearchType, 50, "", 0,6, false, true, true, $launcherfield);
			}
	}
	$out =  PageHeader($strTable . " Searcher", $strConfigBehave) . $out . PageFooter();
	
	return $out;
}

?>