<?php
//Judas Gutenberg Spring 2006
//provides a web front end admin tool for any mysql db
//i've modified txtsql to be aware of foreign keys so this tool can dynamically build complicated tools
//This code is covered under the GNU General Public License
//info here: http://www.gnu.org/copyleft/gpl.html
//the digest is as follows: you cannot modify this code without
//publishing your source code under the same license
//contact the developer at gus@asecular.com  http://asecular.com

set_time_limit(900);
include_once('tf_functions_backup.php');
include_once('tf_functions_core.php');
include_once('tf_functions_updater.php');

echo main();

function main()
{
	if(!IsExtraSecure())
	{
		die(ExtraSecureFailure());
	}
	ini_set('memory_limit','450M');
 
	$strDatabase=deMoronizeDB(gracefuldecay($_REQUEST[qpre . "db"],our_db));
	$submit=$_REQUEST[qpre . "submit"];
 
	$strPHP=$_SERVER['PHP_SELF'];
	$supressheaders=false;
 
	
	$out=LoginDecisions($strDatabase,  $strPHP, $strUser, $supressheaders);
	if ($strUser!="")
	{
		$intAdminType= AdministerType($strDatabase, $strTable, $strUser);
		
		if ($intAdminType>1)
			{
			 
					$errors=ExecuteCheckedSQL();
					if($errors!="")
					{
						$out="<div class=\"feedback\">" . $errors . "</div>";
		 			}
			 
					$out.= Updater($strDatabase);
					 
	 
					$out =  PageHeader($strDatabase . " Updater", $strConfigBehave, "", true, false, "", $strDatabase) . $out . PageFooter();
					return $out;
				 
			}
	}
}
	
function ExecuteCheckedSQL()
{
	$sql=conDB();
	if(is_array($_REQUEST[qpre . "sql"]))
	{
		foreach($_REQUEST[qpre . "sql"] as $strSQL)
		{
			//echo $strSQL . "<br>";
			$strSQL=removeslashesifnecessary($strSQL);
			$sql->query($strSQL);
			$error=sql_error();
			if($error!="")
			{
				$errors.=$error . "<br>";
			}
		}
	}
	return $errors;
}

?>