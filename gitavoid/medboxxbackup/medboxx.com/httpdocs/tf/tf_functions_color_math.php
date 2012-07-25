<?php
//This code is covered under the GNU General Public License
//info here: http://www.gnu.org/copyleft/gpl.html
//the digest is as follows: you cannot modify this code without
//publishing your source code under the same license
//contact the developer at gus@asecular.com  http://asecular.com

function colorAdd($strColorInOne, $strColorInTwo, $intWrapBehavior=0)
//adds two hex color values
{
	$out="";
	for ($i=0; $i<3; $i++)
	{
		$one=hexdec(substr($strColorInOne, $i*2, 2));
		$two=hexdec(substr($strColorInTwo, $i*2, 2));
		$sum=$one+$two;
		if ($sum>255)
		{
			if ($intWrapBehavior==0) //wrap
			{
				$sum= $sum-256;
			}
			elseif ($intWrapBehavior==1)//bounce, not wrap
			{
				$sum=512 - $sum   ;
			}
			else  //brick wall without bounce
			{
				$sum=255   ;
			}
		}
		//echo $sum . " " . dechex($sum) . "@<br>";
		$out.=str_pad(dechex($sum), 2, "0", STR_PAD_LEFT);
	
	}
	//echo $out . "@<br>";
	return $out;
}

function colorSubtract($strColorInOne, $strColorInTwo, $intWrapBehavior=0)
//subtracts two hex color values, 2 from one
{
	$out="";
	for ($i=0; $i<3; $i++)
	{
		$one=hexdec(substr($strColorInOne, $i*2, 2));
		$two=hexdec(substr($strColorInTwo, $i*2, 2));
		$sum=$one-$two;
		
		if ($sum<0)  //wrap
		{
			if ($intWrapBehavior==0) //wrap
			{
				$sum= $sum+256;
			}
			elseif ($intWrapBehavior==1)//bounce, not wrap
			{
				$sum= -($sum)   ;
			}
			else //solarize
			{
				$sum=0; 
			}
		
		}
		//echo $sum . " " . dechex($sum) . "@<br>";
		$out.=str_pad(dechex($sum), 2, "0", STR_PAD_LEFT);
	}
	//echo $out . "@<br>";
	return $out;
}
?>