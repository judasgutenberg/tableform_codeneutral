<?php 
//Judas Gutenberg January 2006-December 2007////////////////////////////////////////////////////////
//provides a web front end admin tool for any MySQL db/////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////
/////core function library///////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////
//This code is covered under the GNU General Public License////////////////////////////////////
//info here: http://www.gnu.org/copyleft/gpl.html/////////////////////////////////////////////
//the digest is as follows: you cannot modify this code without//////////////////////////////
//publishing your source code under the same license////////////////////////////////////////
//contact the developer at gus A T asecular.com  http://asecular.com///////////////////////
//////////////////////////////////////////////////////////////////////////////////////////

//This is how I like my error reporting, thank you very much.  why should i give a crap about Notice?
error_reporting(E_ERROR | E_WARNING | E_PARSE );
//testcc
ini_set("display_errors",true);
$olderrors=error_reporting(0);

 
 
function IncludeIfThere($strFilename)
{
	if(substr($strFilename, 0, 1)=="/")
	{
		$strFilename=$_SERVER["DOCUMENT_ROOT"] . $strFilename;
	}
	if (file_exists($strFilename))
	{
		require($strFilename);
	}
}
 //foreach($_SERVER as $k=>$v)
 //{
 	//echo $k . " " .$v . "<BR>";
 
// }
 
if (file_exists('tf_constants.php'))
{
	require('tf_constants.php');
}
else if (file_exists('tf/tf_constants.php'))
{
	 
	require('tf/tf_constants.php');
}
else if (file_exists('../tf_constants.php'))
{
	require('../tf_constants.php');
}
else if (file_exists('../../tf_constants.php'))
{
	require('../../tf_constants.php');
}
else if (file_exists('constants.php'))
{
	require('constants.php');
}
else if (file_exists('../constants.php'))
{
	require('../constants.php');
}
else if (file_exists('../../constants.php'))
{
	require('../../constants.php');
}

else if(strpos(" " . $_SERVER['PHP_SELF'],"buildconstants.php">0 ))
{
	//header("Location:buildconstants.php");
}

if(!defined("tf_dir"))
{
	define("tf_dir","");
}
IncludeIfThere(tf_dir . "tf_functions_basic.php");
IncludeIfThere(tf_dir . "tf_functions_misc.php");
IncludeIfThere(tf_dir . "tf_functions_encryption.php");
IncludeIfThere(tf_dir . "tf_functions_debug.php");
IncludeIfThere(tf_dir . "tf_functions_db_management.php");
IncludeIfThere(tf_dir . "tf_functions_basic_db.php");

error_reporting($olderrors);

 

//Done with functions - now it is time to include extra include files
 

if (defined("extrainclude"))
{
	if(!defined("tf_dir"))
	{
		define("tf_dir","");
	}
	$arrExtrainclude=explode("|",extrainclude);
	//hack hack hackity hack hack hack
	//$olderrorr=error_reporting(255);
 
	$strPHPSelf=  $_SERVER['PHP_SELF'];
	//echo "-" . $strPHPSelf ."-";
	$intUplevel=0;
	//echo (tf_dir);
	///extra extra extra hacky!!
	if(contains($strPHPSelf, "moodle"))
	{
		define("tf_dir","");
		$strNewTFDir="";
	}
 
	else if(tf_dir=="/")
	{
		
		$intUplevel=CountOccurence($strPHPSelf, "/")-1;
		$strNewTFDir="";
		//such a stupid hack around basedir restrictions!
		for($i=0; $i<$intUplevel; $i++)
		{
			$strNewTFDir.="../";
		}
		 
		 
	}
	else
	{
		$strNewTFDir=tf_dir;
	}
	//HACKTACULAR!!!
	$strNewTFDir=$strNewTFDir. ".";
	define("tf_dir",$strNewTFDir);
	//echo $strNewTFDir;
	
	for($i=0; $i<count($arrExtrainclude);$i++)
	{	
		//echo tf_dir . $arrExtrainclude[$i] . "<br>";
		//if($bwlPossiblyComeUpALevel  && 
		
		if(file_exists($strNewTFDir . $arrExtrainclude[$i]))
		{
			if($strNewTFDir . $arrExtrainclude[$i]!=".")
			{
				
				include_once($strNewTFDir . $arrExtrainclude[$i]); 
			}
		}
		else if(beginswith($arrExtrainclude[$i], "/"))
		{
			if(file_exists($_SERVER["DOCUMENT_ROOT"] . $arrExtrainclude[$i]))
			{
			//die($arrExtrainclude[$i]);
				include_once($_SERVER["DOCUMENT_ROOT"]  . $arrExtrainclude[$i]); 
			}
		}
		else if(file_exists($arrExtrainclude[$i]))
		{
			//die($arrExtrainclude[$i]);
			include_once($arrExtrainclude[$i]); 
		}
	}
	

	//error_reporting($olderrorr);
}


?>