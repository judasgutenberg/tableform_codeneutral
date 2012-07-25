<? 

include('tf_functions_core.php');
include('tf_functions_color_math.php');
include("functions.php");
$intCalendarSetID=1;
$startdate=gracefuldecay($_REQUEST[qpre . "startdate"],strtotime("april 18 1975")); 
$mode=$_REQUEST[qpre . "mode"];
$sql=conDB();
$strSQL="SELECT * FROM " . our_db. ".calendar_event WHERE start='" .  date("Y-m-d H:i:s",$startdate) ."'";
$records = $sql->query($strSQL);
$othernav="";
$othernav.="<a class='datenav' href=index.php?" . qpre . "startdate=&" . qpre . "mode=>home</a> <br>" ;
$othernav.="<a class='datenav' href=index.php?" . qpre . "startdate=167122800&" . qpre . "mode=>first entry</a> <br>" ;
$othernav.="<a class='datenav' href=index.php?" . qpre . "startdate=" . $startdate . "&" . qpre . "mode=print>all entries</a> <br> " ;

$othernav.="<br> " ;
if($mode!="print")
{
	$othernav.= CalendarBrowser($startdate, our_db, "index.php",$intCalendarSet);
}
$othernav.="<br><b>see also:</b><br> " ;
$othernav.="<a class='datenav' href=../energy>Energy in a Real World</a> <br> "; 
$othernav.="<a class='datenav' href=..>Virginians for Wilderness</a> <br> " ;
$othernav.="<a class='datenav' href=../..>Forests of the Appalachians</a> <br> " ;
//$othernav.="<a href=index.php?" . qpre . "startdate=" . $startdate . "&" . qpre . "mode=>daily</a> <br>" ;
echo sheader("home", $othernav);


$intCalendarSetID=1;
$startdate=gracefuldecay($_REQUEST[qpre . "startdate"],strtotime("april 4 1975")); 

$sql=conDB();
$contentvalue="";
$bwlshowedsomething=false;
if($_REQUEST[qpre . "startdate"]=="")
{


}
else 
{
	if($mode!="print")
	{
		$strSQL="SELECT * FROM " . our_db. ".calendar_event WHERE start='" .  date("Y-m-d H:i:s",$startdate) ."'";
	}
	else
	{
		$strSQL="SELECT * FROM " . our_db. ".calendar_event ORDER BY calendar_event_id";
	}
	$records = $sql->query($strSQL);
	
	
	$olddisplaystartdate="";
	foreach($records as $record)
	{
		$displaystartdate= date("l, F j, Y",strtotime($record["start"])) ;
		if($olddisplaystartdate!=$displaystartdate)
		{
			
			 
			
			$displayenddate= date("l, F j, Y",strtotime($record["end"]));
			
			$contentvalue.=  "<p><b>" . $displaystartdate . "</b>";
			if($record["end"]!=""    &&  $displaystartdate!=$displayenddate)
			{
				
				$bwlShownEnd=true;
				$contentvalue.= "<b> - " .	$displayenddate  . "</b>";
			}
		}
		$olddisplaystartdate=$displaystartdate;
		$contentvalue.= "<p>" . $record["notes"];
		if($mode!="print")
		{

			$contentvalue.= "<p class=\"edit\">" . "(<a  href=\"javascript:editpopup('rf_data','calendar_event','calendar_event_id','" .  $record["calendar_event_id"] ."',Array(),Array(), 'noajaxnotopnavfullloginnonewbutton', 'calendar_event_id+notes')\">edit</a>)</p>";

		}
		if($record["notes"]!="")
		{
			$bwlshowedsomething=true;
		}	
		//echo "<p>";
	
	}
}
if ($bwlshowedsomething)
{
	echo $contentvalue;
}
else
{
?>
<script src="http://maps.google.com/maps?file=api&v=1&key=ABQIAAAAsdk352pyuiuCBb_XbtUPvhRQd1lppSWMWgNgDfX7JXe4J_n66RTuJX_QsrlrNd0adehH6_0Y4-rv5w" type="text/javascript"></script>


<div align="right">
<script language="JavaScript">
document.write("<img src=\"http://www.mymedicallife.com/stat/log.php?q="+escape(top.location.href)+"&r="+escape(top.document.referrer)+"\" width=1 height=1 alt=\"\">");
document.write("<a href=\"http://www.mymedicallife.com/stat/viewstats.php?q="+escape(top.location.href)+"\"  alt=\"\">stats</a>");
</script> 
</div>
 
 


<table align=right width=450 cellpadding="9">
<tr><td>
 <img src="picstack.jpg" width="450" height="1028" alt="">
</td></tr>
<tr><td align=center>
<span style="font-size:10px">
Top: the house.  Middle: "Pileated Peak" (formerly known as "Shipe's Mountain"). Bottom: barn viewed from Pileated Peak.
</font>
</td></tr>
</table>
<?
	$firstblock= sitetext("homefirst");
	$firstblock=CaptionImages($firstblock);
	$firstblock=DropcapFirstLetter($firstblock, "left");
 
	 
	$firstblock.= "<p class=\"edit\">" . "(<a  href=\"javascript:editpopup('rf_data','site_text','site_text_id','1',Array(),Array(), 'noajaxnotopnavfullloginnonewbutton', 'site_text_id+value', 900, 750)\">edit</a>)</p>";
	echo $firstblock;
?>



<p>
<b>The location of Homestead:</b><p>









<div id="map" style="width: 650px; height: 600px"></div>


<script type="text/javascript">
function ShowMeTheMap()
{
//<![CDATA[

var map = new GMap(document.getElementById("map"));
map.addControl(new GLargeMapControl());
map.addControl(new GMapTypeControl());
map.setMapType(G_SATELLITE_MAP);
 
//map.centerAndZoom(new GPoint(-74.10746, 41.9309), 6); //where i live, hurley ny
map.centerAndZoom( new GPoint(-79.130251, 38.100194), 0);
// Creates a marker whose info window displays the given number
function createMarker(point, number)
{
var marker = new GMarker(point);
// Show this markers index in the info window when it is clicked
var html = number;
GEvent.addListener(marker, "click", function() {marker.openInfoWindowHtml(html);});
return marker;
};

var point = new GPoint(-79.130251,38.100194);
var marker = createMarker(point, '<div id="infowindow" style="white-space: nowrap;">Homestead</div>');
map.addOverlay(marker);

//http://maps.google.com/maps?f=q&source=s_q&hl=en&geocode=&q=731+stingy+hollow+road+staunton+va&sll=37.0625,-95.677068&sspn=51.974572,74.882813&ie=UTF8&ll=38.100194,-79.130251&spn=0.006366,0.009141&t=h&z=17



//]]>
}
</script>
<script language="JavaScript">
document.write("<img src=\"http://www.mymedicallife.com/stat/log.php?q="+escape(top.location.href)+"&r="+escape(top.document.referrer)+"\" width=1 height=1 alt=\"\">");
ShowMeTheMap();
</script>










<?
}
 
//echo prevnextdate($startdate, our_db, "index.php", "d", 1 ,$intCalendarSetID);
//echo $startdate;
//echo "<br><br><br><br><br>";
//echo CalendarBrowser($startdate, our_db, "index.php",$intCalendarSet);
//echo "<br><br><br><br><br>";
//echo monthcalendar($startdate,   3, "index.php", 0,$intCalendarSetID);
?> 
	

 

 <p>

 
 
 

 

 
<? echo sfooter()?>
