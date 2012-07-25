<?php
GLOBAL $source;
if($source=="")
{
	$odbcserver = "featureweller.db.5463974.hostedresource.com";
	$odbcuser = "featureweller";
	$odbcpass = "Dinosaur12";
	$odbcdb = "featureweller";
	$mydsn="mssql_featureweller.dsn";
	$connStr="Driver={SQL Server};server=".$odbcserver.";uid=".$odbcuser.";pwd=".$odbcpass.";database=".$odbcdb; 
}
else if($source=="original")
{
	//echo "$$";
	$odbcserver = "sql6.media3.net";
	$odbcuser = "featurewell";
	$odbcpass = "nycsynd";
	$odbcdb = "featurewell";
	$connStr="Driver={SQL Server};server=".$odbcserver.";uid=".$odbcuser.";pwd=".$odbcpass.";database=".$odbcdb; 

}
?>