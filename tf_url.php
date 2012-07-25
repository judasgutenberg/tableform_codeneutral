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

include_once('tf_functions_core.php');
include_once('tf_core_table_creation.php');
echo main();

function main()
{
	MakeURLTable();
	$strDatabase=deMoronizeDB(gracefuldecay($_REQUEST[qpre . "db"],our_db));
	$urlnumber=$_SERVER["QUERY_STRING"];
	$urlrecord= GenericDBLookup($strDatabase,tfpre . "url", "url_id", $urlnumber, "") ;
	if(is_array($urlrecord ))
	{
		UpdateOrInsert($strDatabase, tfpre . "url",  Array("url_id"=>$urlrecord["url_id"]), Array("hit"=>$urlrecord["content"]+1));
		header("location: " . $urlrecord["content"]);
	}
		
	
}


function IntToCondensedString($in)
{
	

}
?>