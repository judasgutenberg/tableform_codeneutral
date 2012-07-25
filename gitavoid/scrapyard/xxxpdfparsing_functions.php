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


include('tf_functions_core.php');


	$filename="sample.pdf";
	$handle=fopen ($filename, "r");
	$content=fread($handle, filesize($filename));
	fclose($handle);
	
	$content=str_replace(izb("John"), izb("Bill"), $content);
	$content=str_replace( ("John"),  ("Bill"), $content);
	//$content=str_replace( ("J o h n"),  ("B i l l"), $content);
	
	$sample=parseBetween($content, "J", "l");
	//echo $sample;
	
	//echo "<p>";
	//echo hexdump($sample);
	echo contextdump($content, "J", 1, "o", 20, true );
	echo "<p>";
	echo "<p>";
	$handle=fopen ("x" . $filename, "w");
	fwrite($handle, $content);
	fclose($handle);

	echo "xx<br>";
	
	
function contextdump($in, $contextofwhat, $byteskip=1, $contextofwhat2="", $contextsize=20, $hexdump=false)
{
	$lookat=$in;
	$out="";
	$intThis=strpos($lookat, $contextofwhat);
	while($intThis>0)
	{
		//echo $intThis . "==<P>";
		$thisrun="";
		$bwlGood=false;
		for($i=0; $i<$contextsize; $i++)
		{
			$chr=substr($lookat, $i, 1);
			if($i==$byteskip+1)
			{
			
				if($chr==$contextofwhat2 )
				{
					$bwlGood=true;
				}
			 
			}
			$thisrun.=$chr;
			
			if(  $contextofwhat2=="")
			{
			 	$bwlGood=true;
			}
		
		}
		if($bwlGood)
		{
			if($hexdump)
			{
				$out.= $thisrun . "---------" . hexdump($thisrun) . "<p>\n";
			}
			else
			{
				$out.=$thisrun . "<p>\n";
			}
		}
		$lookat=substr($lookat, $contextsize);
		$intThis=strpos($lookat, $contextofwhat);
		$lookat=substr($lookat, $intThis);
 
	}

	return $out;

}

function izb($strIn)
{	
	$contextsize=strlen($strIn);
	$out="";
	for($i=0; $i<$contextsize; $i++)
	{
		$chr=substr($strIn, $i, 1);
		$out.=$chr . chr(0);
	}
	echo $out . "<P>";
	return $out;
}
?>

