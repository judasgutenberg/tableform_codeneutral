<?php 
//Judas Gutenberg January 2006-January 2007/////////////
//provides a web front end admin tool for any MySQL db/
//////////////////////////////////////////////////////
/////build some constants if we need them////////////
////////////////////////////////////////////////////
//This code is covered under the GNU General Public License
//info here: http://www.gnu.org/copyleft/gpl.html
//the digest is as follows: you cannot modify this code without
//publishing your source code under the same license
//contact the developer at gus@asecular.com  http://asecular.com


require('tf_functions_core.php');
if(!IsExtraSecure())
{
	die(ExtraSecureFailure());
}
$constantfile="constants.php";
$goalhome="tf.php";
if (!file_exists($constantfile))
{

	if($_REQUEST["x_save"]!="")
	{
		$filecontent= ProcessConstantForm();
		//echo $constantfile . "-";
		$handle=fopen ($constantfile, "w");
		$content=fwrite($handle, $filecontent);
		fclose($handle);
		header("Location:" . $goalhome);
	}
	else
	{
		$out.= ConstantsForm();
	}
 
	$out =  PageHeader("Configure DB Tools", "", "", true, false, "", $strDatabase) . $out . PageFooter(); 
	echo $out;
}
else
{
	header("Location:" . $goalhome);
}

function ConstantsForm()
{
	$strPHP=$_SERVER['PHP_SELF'];
	$strFieldNames="our_db|con_server_localhost|con_user_localhost|con_pwd_localhost|numrange_low|numrange_hi|qdelimiter|qpre|tfpre|encryptionkey|extrainclude|default_table|imagepath|pluralizationmethod";
	$strLabels="Database Name|Database Server Name|Database Username|Database User Password|Minium year for date dropdowns|Maximum year for date dropdows|Delimiter for the housekeeping form items' names (usually '_')|Full prefix for the names of housekeeping form items (usually 'x_')|Prefix for housekeeping table names (usually 'tf_')|Encryption key for storing encrypted cookies|Name of any extra PHP files to include|Default table (often left empty)|The folder where images and uploads are placed|Pluralization method (use 'new')";
	$strHiddenMask="0|0|0|0|0|0|1|1|0|0|1|0|0|1";
	$strDefaults="||||1940|2020|_|x_|tf_||||images|new";
	$arrFieldNames=explode("|", $strFieldNames);
	$arrDefaults=explode("|", $strDefaults);
	$arrLabels=explode("|", $strLabels);
	$arrHiddenMask=explode("|", $strHiddenMask);
	$out="<span class=\"heading\">Configure your new Tableform system</span>";
	$out.=GenericForm($arrFieldNames,  $arrLabels, $arrDefaults, $arrSizes, $arrHiddenMask, $strPHP);
	return $out;
}


function ProcessConstantForm()
{
	$out="";
	foreach($_POST as $k=>$v)
	{
		if(!beginswith( $k, "x_"))
		{
			$out.="define ('" . $k . "', '" . $v . "');\n";
			if (beginswith( $k, "con_server"))
			{
				$out.="define ('con_server_web', '" . $v . "');\n";
			}
			else if (beginswith( $k, "con_user"))
			{
				$out.="define ('con_user_web', '" . $v . "');\n";
			}
			else if (beginswith( $k, "con_pwd"))
			{
				$out.="define ('con_pwd_localhost', '" . $v . "');\n";
			}
		}
	}
	return $out;
}

?>