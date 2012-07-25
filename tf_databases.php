<?php
//Judas Gutenberg September 2008
//copies records from one table to another based on a saved regime of column links
//This code is covered under the GNU General Public License
//info here: http://www.gnu.org/copyleft/gpl.html
//the digest is as follows: you cannot modify this code without
//publishing your source code under the same license
//contact the developer at gus@asecular.com  http://asecular.com

 
include('tf_functions_backup.php');
include('tf_functions_core.php');
include('tf_functions_frontend_db.php');
include('tf_core_table_creation.php'); 

echo main();



function main()
{
	if(!IsExtraSecure())
	{
		die(ExtraSecureFailure());
	}
 
 
 
	//a merge is a regime where fields from the source table are copied into blank fields in the rows of the destination table
	//based on a match of a foreign key in the source table to a primary key in the destination table
	$strDatabase=deMoronizeDB(gracefuldecay($_REQUEST[qpre . "db"],our_db));
	//$quotecontent=false;
	$strPHP=$_SERVER['PHP_SELF'];
        $strDatabase=$_REQUEST[qpre . 'db'];
        $mode=$_REQUEST[qpre . 'mode'];
	$supressheaders=false;
	$strTitle="databases";
	$message="";
	//if we're doing cross-db database admin, this thing should authenticate off the default db to make sure we're okay
	//that means our_db instead of $strDatabase
	$out=LoginDecisions(our_db,  $strPHP, $strUser, $supressheaders);
	$newdb=$_REQUEST[qpre . "newdb"];
	$sql=conDB();
	if ($strUser!="")
	{
		$intAdminType= AdministerType(our_db, "", $strUser);
		//echo $strUser . " " . $intAdminType . " " . $strTable;
		if ($intAdminType>1)
		{
                        if($mode=="toMyISAM")
                        {
                             $engine="MYISAM";
                             $message=changeEngineInDB($strDatabase, $engine);
                             $message.="All tables in " . AppropriateSQLName($strDatabase) . " were changed to " . $engine . ".";
                        }
                        else if($mode=="toInnoDB")
                        {
                            $engine="INNODB";
                            $message=changeEngineInDB($strDatabase, $engine);
                            $message.="All tables in " . AppropriateSQLName($strDatabase) . " were changed to " . $engine . ".";
                                    
                        }
			if($newdb!="")
			{
                                echo $newdb;
				$strSQL="CREATE DATABASE ".AppropriateSQLName($newdb);
				$records = $sql->query($strSQL);
				$message="Database '" . AppropriateSQLName($newdb) . "' was created.";
			}
			$out.= adminbreadcrumb(false );
		
		 
			$out.= PickDatabases();

		}
		else
		{	
			$message="You do not have permission to browse the databases.";
			
		}
		if($message!="")
		{
			$out.=  "<div class='message'>" . $message . "</div>";
		}

	}
	$out =  PageHeader($strTitle,  "", "", true, false, "", $strDatabase) .   $out .  PageFooter();
	return $out;
}

function PickDatabases()
{
	//TableDropdown($strDatabase, $strDefaultTable, $strTableFormName, $strOurFormName='BForm', $strFieldFormName="")
	$strClassFirst="bgclassfirst";
	$strClassSecond="bgclasssecond";
 
	$sql=conDB();
 	$strSQL="SHOW DATABASES";
	$records = $sql->query($strSQL);
	//$strTabledropdown2=TableDropdown($strDatabase, $strTable2, qpre . "table2",  '', "");
	$preout="<form name=\"BForm\" action=\"" . tfpre . "databases.php\" method=\"post\">\n";
	$preout.= "<script src=\"tf_tablesort.js\"><!-- --></script>";
	 
	$out.=htmlrow("+" . "bgclassline", "<a href=\"javascript: SortTable('idsorttable', 0)\">database</a>" , "<a href=\"javascript: SortTable('idsorttable', 1)\">number of tables</a>");

	foreach($records as $record)
	{
		$strThisBgClass=Alternate($strClassFirst, $strClassSecond, $strThisBgClass);
		$strDatabase=$record["Database"];
		$out.=htmlrow($strThisBgClass, "<a href=\"tf.php?" . qpre . "db=" . $strDatabase . "\">" . $record["Database"] . "</a>",  
               
                        
                        DatabaseTableInfo($strDatabase,  "count"),
                        "<a onclick='return(confirm(\"Are you certain you want to convert all tables in  " . $strDatabase . " to InnoDB?\"))' href='" . tfpre . "databases.php?" . qpre . "db=" . $strDatabase . "&" . qpre . "mode=toInnoDB'>&gt;InnoDB</a>",
                        "<a onclick='return(confirm(\"Are you certain you want to convert all tables in " . $strDatabase . " to MyISAM?\"))' href='" . tfpre . "databases.php?" . qpre . "db=" . $strDatabase . "&" . qpre . "mode=toMyISAM'>&gt;MyISAM</a>"

                  );
	}
 	$newdbFormItem=TextInput(qpre . "newdb","", 20) . " " . GenericInput(qpre . "createnewdb", "create new database");
 	
 	$out= TableEncapsulate($out);
 	$out.= TableEncapsulate(htmlrow("sortavoid", "new database:",  $newdbFormItem));
	$out.="</form>\n";
	$out=$preout .  $out;
 
	return $out;
}



function DatabaseTableInfo($strDatabase, $strType="count")
{
	$sql=conDB();
	if($strType=="count");
	{
		$strSQL="SELECT count(TABLE_SCHEMA) as 'thisinfo' FROM information_schema.TABLES WHERE TABLE_SCHEMA='" . $strDatabase . "'";
	}
	$records = $sql->query($strSQL);
	//echo $strSQL . "<br>";
	//echo mysql_error();
	$record =$records[0];
	return $record["thisinfo"];
}

function changeEngineInDB($strDatabase, $strEngine)
{
    $sql=conDB();
    $strSQL = "SHOW tables IN " . $strDatabase ."   ";
   // echo $strSQL;
    $records = $sql->query($strSQL);
 
    foreach($records as $record)
    {
        
        $strTable = $record["Tables_in_" . $strDatabase];
        $strSQL = "ALTER TABLE " . $strDatabase. "." .  $strTable  . " ENGINE=" .  $strEngine;
       // echo $strSQL;
        $error=mysql_error();
        $out.=IFAThenB($error, "<br>" . $strSQL . "<br>" )  . $error;
        $sql->query($strSQL);
    }
   return $out;
}


?>