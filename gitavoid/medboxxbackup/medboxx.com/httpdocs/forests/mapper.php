<html>
<head>
<title>Botanical Surveys in the Central Appalachians</title>
<script src="http://maps.google.com/maps?file=api&v=1&key=ABQIAAAAsdk352pyuiuCBb_XbtUPvhRQd1lppSWMWgNgDfX7JXe4J_n66RTuJX_QsrlrNd0adehH6_0Y4-rv5w" type="text/javascript"></script>

<!script src="http://maps.google.com/maps?file=api&v=1&key=ABQIAAAAsdk352pyuiuCBb_XbtUPvhT2yXp_ZAY8_ufC3CFXhHIE1NvwkxQEV3kX_hAP74iL5iBH4n8YonIr8Q" type="text/javascript"></!script>
</head>
<body  onload="ShowMeTheMap();">
<p><strong>Surveys in the Central Appalachians</strong></p>
<div id="map" style="width: 800px; height: 600px"></div>

<script type="text/javascript">
function ShowMeTheMap()
{
//<![CDATA[

var map = new GMap(document.getElementById("map"));
map.addControl(new GLargeMapControl());
map.addControl(new GMapTypeControl());
//map.centerAndZoom(new GPoint(-74.10746, 41.9309), 6); //where i live, hurley ny
map.centerAndZoom( new GPoint(-79.568481, 38.377327), 10);
// Creates a marker whose info window displays the given number
function createMarker(point, number)
{
var marker = new GMarker(point);
// Show this markers index in the info window when it is clicked
var html = number;
GEvent.addListener(marker, "click", function() {marker.openInfoWindowHtml(html);});
return marker;
};

<?php
 
//textsql block
include('config.php');












 
function beginswith($strIn, $what)
{
	if (substr($strIn,0, strlen($what))==$what)
	{
		return true;
	}
	return false;
}

function contains($strIn, $what)
{
	if (strpos(" " . $strIn, $what)>0)
	{
		return true;
	}
	return false;
}

function gracefuldecay()
{
	//go through the parameters and return the first that isn't empty
		$intArgs =func_num_args();
		for($i=0; $i<$intArgs; $i++)
		{
			$option=func_get_arg($i);
			if ($option!="")
			{
				return $option;
			}
		}
}

function deMultiple($strIn, $chrIn)
//remove multiple side-by-side instances of $chrIn - works best for things like spaces and chr(13)
	{
		$strOut=$strIn;
		while(strpos($strOut, $chrIn . $chrIn))
		{
			$strOut = str_replace( $chrIn . $chrIn, $chrIn, $strOut);
		}
		return($strOut);
	}
	
function RemoveLastCharacterIfMatch($strIn, $chrIn)
	{
		$out=$strIn;
		if (substr($strIn,  strlen($strIn)-1, 1) ==$chrIn)
		{
			$out= substr($strIn, 0, strlen($strIn)-1);
		}
		return $out;
	}
	
function RemoveFirstCharacterIfMatch($strIn, $chrIn)
	{
		$out=$strIn;
		//echo substr($strIn,   0, 1) . "<br>";
		if (substr($strIn,   0, 1) ==$chrIn)
		{
			$out= substr($strIn, 1);
		}
		return $out;
	}
	
function RemoveEndCharactersIfMatch($strIn, $chrIn)
	{
		$out= RemoveFirstCharacterIfMatch($strIn, $chrIn);
	 	$out= RemoveLastCharacterIfMatch($out, $chrIn);
		return $out;
	}
	
 function SingleQuoteEscape($strIn)
	{
		$out= str_replace("'", "\'", $strIn);
 
		return $out;
	}
	
 
 function todegs($v)
 {
 
	 	
	 	if (contains($v, " "))
		{	
			$v=deMultiple($v, " ");
			$v=RemoveEndCharactersIfMatch($v, " ");
			$arrDegs=explode(" ", $v);
			$deg=$arrDegs[0];
			$mins=$arrDegs[1];
			$secs=$arrDegs[2];
			$v=intval($deg) + intval($mins)/60 + intval($secs)/3600;
		}
		$v=RemoveEndCharactersIfMatch($v, "-");
	 	if (contains($v, "-"))
		{	
			 
			
	
			$arrDegs=explode("-", $v);
			
			$deg=$arrDegs[0];
			$mins=$arrDegs[1];
			$secs=$arrDegs[2];
			$v=intval($deg) + intval($mins)/60 + intval($secs)/3600;
		}
		if ($v>60)
		{
			//force northern western hemisphere
			$v=-$v;
		}
	return $v;
		
}










 


$link = $sql->connect("root","patriot76");   //mysql_connect("[database server]", "dbmapserver", "[password]")
 
//mysql_selectdb("dbmapserver",$link) or die ("Can\'t use dbmapserver : " . mysql_error());
 
$result =  $sql->select(array("db"=> "rf","table"=> "wholocations"));


if (!$result)
{
	//echo "no results ";
}
foreach ( $result as $key  )
	{
		echo "var point = new GPoint(" . todegs($key['lon'] ). "," .todegs( $key['lat']) . ");\n";
		echo "var marker = createMarker(point, '<div id=\"infowindow\" style=\"white-space: nowrap;\"><a href=\"" .$key['url']  . "\">" . SingleQuoteEscape($key['desc']). "</a></div>');\n";
		echo "map.addOverlay(marker);\n";
		echo "\n";
	}


?>

//]]>

}
</script>

</body>
</html>