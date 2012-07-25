<?
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



?><HTML>
<head>
<META NAME="Description" CONTENT="The Central Appalachian forests of Virginia, West Virginia, Maryland and Pennsylvania are some of the most biologically diverse and most threatened ecosystems anywhere.">
<TITLE>Forests of the Central Appalachians Project</TITLE>
<script src="http://maps.google.com/maps?file=api&v=1&key=ABQIAAAAsdk352pyuiuCBb_XbtUPvhRQd1lppSWMWgNgDfX7JXe4J_n66RTuJX_QsrlrNd0adehH6_0Y4-rv5w" type="text/javascript"></script>


 


 


</head>
<BODY bgcolor="ffffff" text="000000" link=990000 vlink=000099  onload="ShowMeTheMap();">
<font face=arial>

 

<a href="vfw/">Back to the Virginians For Wilderness Homepage</a>



<div align="right">
<script language="JavaScript">
document.write("<img src=\"http://www.mymedicallife.com/stat/log.php?q="+escape(top.location.href)+"&r="+escape(top.document.referrer)+"\" width=1 height=1 alt=\"\">");
document.write("<a href=\"http://www.mymedicallife.com/stat/viewstats.php?q="+escape(top.location.href)+"\"  alt=\"\">stats</a>");
</script> 
</div>
<P>


<div style="border-style: solid ; border-width: 1px; border-color:#C40001; padding:10px; background:#cc6633; font-size:18px">
<h3>URGENT NOTICE (May 6th, 2010)</h3>
Please  urge authorities to use agricultural  products  (dry  hay, straw, corn stalks etc. as well  as brush to hold in  place)   at edges of sensitive areas such as the Mississippi  Delta.  Deposition could be  from the air or otherwise. This material is abundant, cheap and readily available. This  would rapidly take up and nueutralize the toxic components, might be left in place or removed at convenience.
<p>
Dr. Robert F. Mueller

</div>









<center>
<h1>Forests of the Central Appalachians Project</h1>





 








 
<P>
<h2>Inventories to Protect</h2>
photos and text by Robert F. 
Mueller
<br></center>
<P>
<B>Introduction</B>
<P>
 The Central Appalachian forests of Virginia, West Virginia, Maryland
and Pennsylvania are some of the most biologically diverse and
most threatened ecosystems anywhere.  Home to many thousands of
species of plants and animals, they represent a vast but dwindling
source of medicinal compounds, recreational amenities and precious
solitude.  They make up irreplaceable wildlands that were and
are the ultimate origin of our clean air and water, and even diminished
as they are today, play a greater than ever role in our civilization's
survival.  Yet all this is jeopardized by single-minded exploitation
in the form of mining, destructive timbering, road building and
innumerable and varied development schemes.  And this is happening
with only limited knowledge of what is being lost.  Many centers
of diversity and rarity and the last remnants of old growth are
being destroyed while the interconnected mosaic of habitats is
being sundered as never before.  Consequently an important and
even critical element of any protection strategy must be a more
thorough knowledge of the forest and its physical and biological
structure.  To this end Virginians for Wilderness have designed
the Forests of the Central Appalachians Project by which we seek
the most comprehensive picture ever of these forests.<p>


<p>
A more in-depth introduction can be <a href=forestchapter.htm>viewed here</a>.
<p>
<table width=200 align=right><td>
<a href="trillium.jpg"><img src="trilliums.jpg" width=200 
height=294></a><br>
<tr><td><font size=-1 color=888888><center>
Fig. 1- Mesic Slope with Cow Parsnip and Trillium, Peaks of Otter.
</center></font></table>
<B><h2>The Link Between Biological Inventories and Forest 
Protection</h2></B>
<P>
 Given that public agencies such as the U.S. Forest Service conduct
biological inventories, how can additional ones be justified?
<P>
 We believe detailed knowledge of the forest is an imperative
for its protection.  However, given that the public agencies such
as the US Forest Service conduct biological inventories, how can
additional ones be justified?  Unfortunately, to put it bluntly,
inventories done by some public agencies, and particularly by
the US Forest Service, cannot be trusted because they are frequently
biased in such a way as to favor decisions already made.  Also,
to cut costs they are often conducted by unqualified personnel.
 It works as follows:
<P>
 The US Forest Service employs its own scientists and many others
from academic institutions and the private sector to do inventories
of plants and animals, ostensibly to prevent negative impacts
on them by timber sales and other activities in the national forests.
 However detailed information collected by VFW under the Freedom
of Information Act indicates that many of the inventories are
woefully incomplete, incompetent or fraudulent.  Associated experiments
are conducted in such a way as to support destructive policies
such as clearcutting.  In some cases independent scientists under
contract have been forced to recant opinions arrived at by valid
research because they conflict with Forest Service policies. 
In the case of the Elk Mtn. timber sale in the Monongahela national
Forest, no copies of field notes could be obtained even under
the Freedom of Information Act and the Regional Forester stated
that he didn&iacute;t know if they existed!
<P>
 Some public agencies, such as State Natural Heritage Programs,
do produce trustworthy information.  However when such information
relates to national forests, or in some cases state lands, it
may be suppressed by the US Forest Service or the state agency
concerned.  In some cases Natural Heritage employees have been
threatened with withdrawal of support by the US Forest Service.
 Both Forest Service and Natural Heritage scientists have lost
their positions when they refused to produce fraudulent inventories.
<P>
 Although many of the data we rely upon are obtained from our
own field inventories, we also incorporate many from other sources.
 Unsuppressed natural Heritage Program inventories are highly
reliable because they are conducted by academic and other experts
who are beyond the reach of biased agencies.  We make use of as
many of these data as possible.  However Natural Heritage Programs
tend to concentrate on rare species and communities while we also
require information on more widespread forest communities.  Thus
we have another reason for conducting our own inventories.
<P>
 We have already monitored or inventoried hundreds of sites throughout
the Central Appalachians and the number of detailed inventories
entered into our computerized data base is approaching fifty.
 Among studied areas are several centers of diversity such as
Blowing Springs which is as yet part of unprotected general forest
in the George Washington National Forest but for which we seek
protection as a research natural area as well as an integral part
of our Wildland Reserve System.  A large timber sale was originally
scheduled.  We are assembling all available data to produce the
most comprehensive picture of Central Appalachian forests and
to incorporate these data into a protection strategy and a Wildlands
Reserve System.  

 <p><h2>The Project</h2> 
<P>
 The Project is in part inspired by E. Lucy Braun' classic
<I>Deciduous Forests of Eastern North America</I>.  However it
is confined to the Central Appalachians and is somewhat different
in emphasis.  Although it treats a smaller area than Braun does,
it takes a broader approach within this area.  Instead of emphasis
on forest trees it attempts to include as many species as possible,
give equal weight to the diverse herbaceous flora and weave in
faunal elements as the occasion presents itself.  Although Braun
was well aware of the role of geology in forest ecology and cited
many examples, more extensive and site-specific correlations are
attempted in this Project.  In particular many examples of microhabitats
are drawn upon.
<P>
 The major thrust of the Project is in its "forest walks"
which are distributed over diverse terrain.  Typically these walks
are traverses, usually from low to high elevations during which
an attempt is made to identify and record along the way as many
taxa as possible as well as environmental data such as elevation,
aspect, rock and soil types, disturbance regimes, etc.  More transient
elements such as weather conditions and wildlife sightings are
also recorded.  As frequently as practicable the traverses are
punctuated by "spot inventories" in which a representative
or unusual community or tract of forest, perhaps half an acre
(0.2 hectare) in extent, is inventoried in more detail.  When
centers of great diversity or complexity are encountered, a number,
or even numerous return visits may be made, particularly during
the growing season.  In some instances soil, rock or vegetation
samples may be taken for laboratory work, or sample plots may
be established.
<P>
 The site and time-specific observations that characterize the
forest walks, and which are retained in the final product, are
a unique feature of the Project.  They provide a variety of baseline
data for many areas within the Central Appalachians.  Inclusion
of biologically diverse and general forest areas as well as many
that are well known and accessible provides a resource for teachers
of forest ecology as well as the general public who, by consulting
the Project documentation, may plan field trips and science projects
with greater economy.  The specific nature of the observations
 and accessibility of many of the sites visited also provide a
desirable vulnerability of the data to confirmation, rejection
or revision.
<p>
<table width=170 align=right><td>
<img src="undulatum.jpg" width=170 height=202><br>
<tr><td><font size=-1 color=888888><center>
Fig. 2- Painted Trillium at Potts Pond
</center></font></table>
<B><h2>Data Interpretation</h2></B>
<P>
 The Project makes use of a new approach in the interpretation
of the inventoried biologic communities.  This approach is grounded
in an analogy with the mineral systems that form the substrates
of those communities.  Like minerals forest species are regarded
as having <I>stability fields</I> in systems with many variables
such as those of chemical composition, soil moisture content and
temperature.  For example, the stability field of Chinquapin Oak
(<I>Quercus muhlenbergii</I>) appears to be confined to alkaline,
lime rich soils with low moisture-content at moderate temperatures.
 By contrast that of Chestnut Oak (<I>Quercus prinus</I>) appears
to lie well within the acid range in low soil moisture environments,
usually in association with silica-rich rocks.  In this way the
stability fields of many forest species can be mapped and graphed
in at least semi-quantitative or general terms.
<P>
 Stability field analysis in forest ecology provides a practical
framework for data collection.  In particular it mandates the
recognition of microhabitats since, as in the case of mineral
systems, forests are subject to communication/mobility constraints
on their chemical, physical and biological components.  This limits
the sizes of units in which stability relations can be expressed.
 The concept also has a bearing on the recognition of sizes of
representative stands of trees and the relative importance of
the presence or absence of given species versus the number of
individuals of these species in the stands.  Finally it demands
a correlation of species with the mineral substrate as well as
other environmental parameters.  Consideration of these factors
are of course additional to those of classical ecology, many of
which also bear on stability relations.
<P>
 Stability field analysis is an outgrowth of the natural tendency
in nature toward dynamic equilibrium, with the caveat that perfect
equilibrium is only a reference state.  While the well-known criteria
for general equilibrium apply, forest equilibrium does not have
the thermodynamic basis of the simpler mineral version, although
the latter exerts its influence in the substrate.  Its most familiar
expression of stability is in the attainment of forest climax
in which natural disturbances are perturbations.
<P>
 These theoretical musings do have implications in forest protection
because they reveal a depth and systematization beyond those of
current ecological theory.  For example, it is likely that the
patchiness of the microhabitat mosaic is as important as that
of macrohabitats.  They also serve as an aid to prioritizing data
collection in the rapid biologic assessments which are assuming
greater importance in this age of ecodestruction.<p>

<P><center><a href="graphic.jpg"><img src="graphics.jpg" border=3 width=400 height=449></a><p>




<blockquote> 


<font size=-1 color=555555>
A: Chinquapin Oak-White Ash<br>
B: Black Maple-Sugar Maple-White Ash<br>
C: Chestnut Oak-White Ash-Sugar Maple-Red Maple-Beech<br>
 </font>
</blockquote>
<p>



Fig. 3-Tentative overlapping tree stability fields with resulting 
associations (A, B, C) as a function of field position.  Concept by RF 
Mueller, graphic by <a href="http://atlas.comet.net/~gus/art/gus/">the 
Gus</a>.<p>

</center>

 Figure 3 is an illustration of the stability fields of a number
of tree species in terms of acidity and soil moisture.  It is
based on a variety of field data including some resulting from
this Project.  Community and forest type ranges may also be derived
from such figures or direct field experience (Mueller, <I>Wild
Earth 6</I>(1), 1996).<BR>


<table width=200 align=right><td>
<a href="sedge.jpg"><img src="sedges.jpg" width=200 height=238></a>
<tr><td><font size=-1 color=888888><center>
Fig. 4- High elevation bog.  Dolly Sods, West Virginia's
Allegheny Mountains.
</center></font></table>


<p>

<dl>
 
 





<dt><strong><a href="biorange.htm">Biodiversity: Central Appalachian Plant Distributions and Forest Types</a></strong> <dd> Occurrences of plant species and forest types in the Central Appalachians are related to elevation, soil acidity and moisture content. Simple observations and survey methods are featured. Time rate of change (kinetic) and equilibrium criteria for forest succession are discussed. (From <i>Wild
Earth</i>, <i>Volume 6</i>, #1, pp 37-43, 1996)<p>

<dt><strong><a href="resdes.htm">Geology in Reserve Design - An Example from the Folded Appalachians</a></strong> <dd> Management of the George Washington National Forest is in a state of flux, as it is in the National Forest System as a whole. In the evolving mental climate of the administrators, the true function of big wilderness-as the imperative for biodiversity and the evolutionary process-is still only faintly grasped. (From  <i>Wild
Earth, Vol. 7, #2, pp 62-66</i>, 1997)<p>

<dt> <strong><a href="gwnf.htm">Wilderness Proposals - The George Washington National Forest - Central Appalachian Wilderness in Perspective</a></strong> <dd> Management of the George Washington National Forest is in a state of flux, as it is in the National Forest System as a whole. In the evolving mental climate of the administrators, the true function of big wilderness-as the imperative for biodiversity and the evolutionary process-is still only faintly grasped. (from <i>Wild Earth Vol. 1</i> (3),  pp 62-67)<p>

<dt><strong><a href="vfw/freerangescience.htm">Free Range Science on the World Wide Web</a></strong> <dd> an editorial.<p>




<dt><b>"<a href=bigrunbog.htm>Big Run Bog</a>" 
</b>- 
<dd>A botanical survey of Big Run Bog Candidate Research Natural Area, located in Tucker County, West Virginia. (By R. Hunsucker)<p>




<dt>

<b>"<a href=activistguide.htm>CENTRAL APPALACHIAN FORESTS - A Guide for Activists</a>" 
</b>- 
<dd>An on-the-ground and literature survey of the Central Appalachian forests is presented from the perspective of an activist.<p>



<dt><b>"<a href=space.htm>Exploring Nature's Multidimensional Space, The Forest Example</a>" 
</b>- 
<dd>The application of our inventories and methodologies to forest ecology 
and old growth flora.<p>



<dt><b>"<a href=megafauna.htm>Floral Legacies of the Megafauna</a>" 
</b>- 
<dd>Modern plants still show evidence of selection by extinct megafaunal herbivores from the iceage.<p>
<p>

<dt><b>"<a href=folly.htm>Folly Mills Calcareous Wetland</a>" 
</b>- 
<dd>An in-depth study of a rare wetland in the Shenandoah Valley of Virginia.<p>




<p>
<dt>
<font color=red size=1> Dec. 2005</font>
<a href="kids.htm"><strong>Forest Ecology in Brief</strong></a> 
<dd>A digest of forest ecology basics for novices or children.<p>





<p>
<dt>
<a href="penn.htm"><strong>The Forests of Pennsylvania - Transition to the Northern Appalachians</strong></a> 
<dd> Attempting to fill out our picture of the Central Appalachian forests by a survey of their northern reaches, a part of which includes the new element of glaciated terrain.<p>


<dt><b>"<a href=stability.htm>Stability Relations in
Forests</a>" 
</b>- 
<dd>The relationship between rock, soil and associated ecosystems.<p>
<p>
<dt>"<a href="phleaves.htm"><strong>pH of Leaves</strong></a>"
<dd>Six forest types were represented, and although most samples were from calcareous substrates, some were from substrates developed on highly acidic chert within the calcareous terrain (see our section on <i>Hydrastis canadensis</i> L). The period of collection was exceptionally dry, with only a few light rains. Thus, there is an increased probability that chemical leaching of the leaves was minimal.<p>



<dt>"<a href="soiltemperatures/"><strong>Soil Temperature and Forest Type</strong></a>"
<dd>Soil temperatures related to several forest types and different environmental conditions in the Central Appalachian Mountains.
<br>
See also the versions from <a href=soiltemperatures/soil_2001.htm>2001</a> and <a href=soiltemperatures/soil_2002.htm>2002</a>.
</dl>
<P>





<B><h2>Forest Walks- Details</h2></B>
(Look below the map for text descriptions of these walks as well additional ones not yet plotted.)

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












<P>





 The following are our Forest Walk inventories:
 <p><blockquote>

 <a href="altona.htm"><strong>Altona Marsh</strong></a> - In Jefferson County, West Virginia, about one mile
west of the city of Charles Town.<p>


<a href="anthonycr.htm"><strong>Anthony Creek Old Growth</strong></a> - The tract of old growth or ancient forest near Neola, West Virginia occupies an east-facing slope just west of the North Fork of Anthony Creek.<p>


<font color=red size=1>revised</font>
<a href="bearmountain.htm"><strong>Bear Mountain/Laurel Fork</strong></a> - This area, which lies in the highest part of the Central Applachians, features moderately fertile soils.<p>


<a href="beartown.htm"><strong>Beartown Wilderness/Chestnut Ridge</strong></a> - Long, straight and winding sandstone ridges that close back on themselves to form features such as Burke's Garden, a 3100 foot  (945 m)  high agricultural valley composed largely of Ordovician limestones.<p>


<a href="bluebend.htm"><strong>Blue Bend/Round Mountain</strong></a> - A sharp bend of Anthony Creek, a major stream in this part of the Valley and Ridge physiographic province.<p>


<a href="hardscrabble.htm"><strong>Ascent of Big Bald and Hardscrabble Knobs From the North River</strong></a> - The area of the ascent is within a proposed Ramsey's Draft Wilderness addition as proposed by local conservationists.<p>
 
 <a href="biglevels.htm"><strong>Big Levels</strong></a> - A large quartzite plateau in the central Blue Ridge of Virginia.<p>

 
<a href="bigschloss.htm"><strong>Big Schloss/ Wolf Gap</strong></a> - Big Schloss rises 700 ft. above Wolf Gap and 1500 ft. above the Little Stony Creek Valley to the southeast. Wolf Gap is a "wind gap" or a gap without a stream.<p>


<a href="blackmtn.htm"><strong>Black Mountain</strong></a> - The highest point in Kentucky and in the Cumberland Mountains.<p>

<a href="blows.htm"><strong>Blowing Springs</strong></a> - in Western Virginia<p>


<a href="blisterer.htm"><strong>Blister Run</strong></a> - a branch of the Shavers Fork of the Cheat River,is closely paralleled by US Route 250 in Randolph County, West Virginia and lies entirely within the Monongahela National Forest.<p>
<a href="bolar.htm"><strong>Bolar Mountain</strong></a> - a low ridge in the western folded Appalachians of Virginia, lies southwest of and along the regional strike from the Blowing Springs Area.<p>

<a href="bowed.htm"><strong>Land of Bowed Mountains</strong></a> - In the vicinity of the New River crossing the uniform northeast/southwest trend and parallel orientation of the Virginia fold mountains. <p>

 <a href="brattonsrun.htm"><strong>Brattons Run</strong></a> - Survey from the Rt. 39 bridge upstream to an unknown location between approximately 10:30 AM and 4:30 PM on 7-14-07. <p>


<a href="buffalomountain.htm"><strong>Buffalo Mountain</strong></a> - A monadnock that rises a thousand feet  (305 m)  above the plateau a few miles west of the Blue Ridge escarpment.<p>


 <a href="canaan.htm"><strong>Canaan Mountain</strong></a> and  <a 
href="canaanv.htm"><strong>Canaan Valley</strong></a>- in the high 
Alleghenies of West Virginia<p>



  <a href="cartercaves.htm"><strong>Carter and Cascade Caves Area</strong></a>  -Canada Yew and Associated Floras.<p>
 <a href="cathedral.htm"><strong>Cathedral State Park</strong></a>  - A 133 acre (54 ha) remnant of ancient primary forest in West Virginia's Allegheny Mountain sub-province.<p>

 <a href="chieflogan.htm"><strong>Ecology of Chief Logan State Park</strong></a>  - Logan State Park lies in the heart of Coal Country and thus is emblematic of the ecosystems at risk and presently being destroyed by Mountain Top Removal/Valley Fill Mining. MTR/VF Mining is one the most far-reaching types of environmental abuses.  Survey by R.  Hunsucker.<p>

 <font color=red size=1>New!</font>
 <a href="chieflogan2.htm"><strong>Ecology of Chief Logan State Park 2</strong></a>  - a further study.<p>


<a href="craig.htm"><strong>Craig Creek Watershed</strong></a> - Logan State Park lies in the heart of Coal Country and thus is emblematic of the ecosystems at risk and presently being destroyed by Mountain Top Removal/Valley Fill Mining. MTR/VF Mining is one the most far-reaching types of environmental abuses.  Survey by R.  Hunsucker.<p>
<p>
<a href="cranberry.htm"><strong>Cranberry Glades</strong></a> - These form a wetland complex in a deep valley beneath some of the loftiest parts of the dissected Allegheny Plateau. <p>
<p>


<p>

<a href="crawford.htm"><strong>Ascent of Crawford Mountain / Chimney Hollow</strong></a> - An offshoot of the Shenandoah Range northwest of Staunton, Virginia. <p>
<p>




<a href="dismalcreekdoo.htm"><strong>Dismal Creek Watershed</strong></a> - The Dismal Creek Watershed occupies a basin formed by the slopes of Flat Top, Sugar Run and Brushy Mountains.<p>


<a href="dollysods.htm"><strong>Dolly Sods</strong></a> - Part of a dissected Allegheny Mountain Tableland.<p>


<a href="elkmountain.htm"><strong>Elk Mountain to Gay Knob</strong></a> - The Elk Mountain/Gay Knob Area forms the southeast edge of the Allegheny Plateau and overlooks the Greenbrier Valley northwest of Marlinton, West Virginia.<p>


<a href=fallsofhills.htm><strong>Falls of Hills Creek Scenic Area</strong></a>- The site of three scenic waterfalls and the gorge on
Hills Creek. <p>


<p>
<font color=red size=1>revised 6/03, 9/03</font>
<a href=fannier.htm><strong>Fanny Bennett Hemlock Grove</strong></a>- a standout in its beauty and diversity as one of the few remnants of mesic primary forest in the Central Appalachians. <p>
<p>


<p>

<a href=follymills.htm><strong>Folly Mills Watershed</strong></a>- Two  facing slopes in a relatively rugged region in the middle of the Shenandoah Valley. <p>
<p>



<a href="15.html"><strong>Green Ridge/Fifteen Mile Creek</strong></a> - from 
Maryland's Valley and Ridge. <p>

<a href="glade.htm"><strong>Glade Creek / New River Gorge</strong></a> - a minor tributary that enters the deep New River Gorge near Beckley West Virginia and within the New River Gorge National River. <p>
<p>

<a href="gardenmountain.htm"><strong>Garden Mountain and Vicinity</strong></a> - Adjacent to Burkes Garden in Southwest Virginia.<p>

<a href="gaud.htm"><strong>Gaudineer Scenic Area and Vicinity</strong></a> - The Scenic Area is notable as one of the few remnants of old growth Red Spruce in the Central Appalachians.<p>


 

<a href="eastforkgreen.htm"><strong>East Fork Greenbrier Watershed</strong></a> - Surveys conducted in the vicinity of the Island campground of the Monongahela National Forest northeast of Thornwood, West Virginia.<p>

<a href="hall.htm"><strong>Hall Spring/ Rader Mountain/ Laurel Run Spruce Forest</strong></a> - NE of Reddish Knob the Shenandoah Mountain crest swings east a few miles and in that angle forms a small sloping plateau. Rader Mountain is an extension of this plateau to the south, while Laurel Run issues from springs on its slopes. The highest of these springs is Hall Spring.<p>

<a href="hiddenvalley.htm"><strong>Hidden Valley</strong></a> - Valley is a local segment of the Valley of the Jackson River, a bold Virginia stream that for most of its course follows the strike of the folded Appalachians, then curves east across the ranges to become the James at Clifton Forge.<p>


<a href="hollyriver.htm"><strong>Holly River</strong></a> - In Webster County, West Virginia.<p>

<a href="horseshoe.htm"><strong>Horseshoe Run/Dorman Ridge</strong></a> - Horseshoe Run is a tributary of the Cheat River and lies within the Allegheny Mountain subprovince in Tucker and Preston Counties,West Virginia.<p>

<font color=red size=1>updated, Dec. 2004</font>
<a href="hydrastis.htm"><strong>Hydrastis canadensis L.</strong></a> - This herb, sought ever more intensively for its medicinal and herbal properties, is under grave threat of extirpation wherever it occurs.<p>

<a href="kencreek.htm"><strong>Ascent of Kennedy Creek</strong></a> - Kennedy Creek seems more like the precinct of a native god or demon of green light and shadow.<p>


<a href="kumbrabow_sf.htm"><strong>Kumbrabow State Forest</strong></a> - The high precipitation and average elevation result in a rich forest characterized by many northern and montane species, and, according to the State,  "forms a showcase for Black Cherry and Red Spruce."<p>



<font color=red size=1>revised and expanded 10/03</font> 
<a href="laurelsouth.htm"><strong>Laurel Fork Wilderness Areas and Vicinity</strong></a> - These twin federally-designated wilderness areas are in a region of considerable ecological interest and illustrate the close relations between floras and their geologic and climatic environments.<p>
 
<a href="lilleycornell.htm"><strong>Lilley Cornett Woods</strong></a> - A Report of a 5 hour walk by Dr. Robert Hunsucker from lower coves to the Mountain Crest on 7-7-06.<p>

<a href="giles.htm"><strong>Little Stony Creek Valley, Giles County, Virginia</strong></a> - a minor tributary of the New River, heads at Mountain Lake and in the highlands within and below the Mountain Lake Wilderness. <p>

<a href="littlewolf.htm"><strong>Little Wolf and Laurel Creeks</strong></a> - In Southwest Virginia.<p>

<a href="locustsprings.htm"><strong>Locust Springs/ Laurel Fork</strong></a> - Part of the George Washington and Jefferson National Forests and lies just east of the West Virginia line in Highland County, Virginia. <p>


<a href="lowgap.htm"><strong>Low Gap</strong></a> - Start of the inventory is at Low Gap along Route 33 at an elevation of about 2900 ft. <p>


<font color=red size=1>updated, Feb. 2003 & Feb. 2004</font>
<a href="mapleflats.htm"><strong>Maple Flats</strong></a> - A complex, multifaceted ecosystem that incorporates elements of Appalachian, coastal and northern floras and faunas. <p>



<a href="meadow.htm"><strong>Meadow Creek Watershed</strong></a> - Meadow Creek, a branch of Anthony Creek, extends from
Neola to above the Lake Sherwood impoundment. <p>


<a href="millhill.htm"><strong>Mill Hill</strong></a> - Of particular interest are calcareous sandstones, in which silica grains are cemented by calcium carbonate, and which may give rise to substrates for plants much like those derived from limestone.<p>

 
<a href="morrisshill.htm"><strong>Morris Hill</strong></a> - The hill is bordered on the southeast by the Jackson River flood plain and on the northwest in part by the Lake Moomaw impoundment. Bedrock is the Upper Silurian / Lower Devonian complex of shales, sandstones and limestones that occur widely throughout the region (see our section on Blowing Springs) (Rader and Evans, 1993).<p>

<a href="pleasantpompey.htm"><strong>Mounts Pleasant and Pompey Trails</strong></a> - Along the backbone of the Blue Ridge in Central Virginia.<p>


<a href="nimrod.htm"><strong>Nimrod Hall Ridge and Vicinity</strong></a> - The area is characterized by a wide variety of macro and microhabitats, which follow from the great variety of rock types, structures, topography and soils.<p>


<a href="nrivervalley.htm"><strong>North River Valley Augusta County, Virginia</strong></a> - A branch of the South Fork of the Shenandoah River.<p>

<a href="ottercreek.htm"><strong>Otter Creek</strong></a> - Lies within the North Potomac Syncline.<p>

<p>
<a href="otter.htm"><strong>The Peaks of Otter</strong></a>-a well known 
Blue Ridge location in western Virginia.  <p>


<p>
<a href="pearis.htm"><strong>Ascent of
 Pearis Mountain</strong></a> - Our ascent of Pearis Mountain was along the Appalachian Trail, starting at the edge of the City of Pearisburg.<p>



<a href="pedlarwatershed.htm"><strong>Pedlar River Watershed</strong></a> - The Pedlar River, a tributary of the lower James, lies between the westernmost ridge and a complex of some of the highest peaks of the northern Blue Ridge.<p>


<a href="pasalient.htm"><strong>The Pennsylvania Allegheny Salient</strong></a> - The salient is defined by a unique concentration of northern plants-and to a lesser degree mammals and birds - centered in Somerset and Cambria Counties.<p>


<a href="petite.htm"><strong>Petite's Gap</strong></a> - Petite's Gap, at 2461 feet (750 meters) asl and 37<sup>o</sup>34' N latitude, lies between two federally-designated wilderness areas, the James River Face and Thunder Ridge to the northeast and southwest respectively. The terrain is moderately rugged and the country rock is Pre-Cambrian layered pyroxene granulite.<p>


 
<a href="pinemountain.htm"><strong>Pine Mountain Settlement School Property</strong></a> - 
Pine Mountain is the northeast to southwest-trending surface expression of a major thrust faultwith a steep, northwest facing scarp slope and amoregentle southeast facing dip slope. It is near 100 miles (161 km) in length in Kentucky and extends south into Tennessee with only few significant gaps.<p>


<font color=red size=1>completely revised</font>
<a href="potts.htm"><strong>Potts Mtn.</strong></a>-from Virginia's Valley 
and Ridge.<p>


<font color=red size=1>revised 8/03</font>
<a href="ramsey.htm"><strong>Ramsey's Draft</strong></a> -   a branch of the Calfpasture River and thus a part of the James System.<p>


<a href="reddish.htm"><strong>Reddish and Bother Knobs and Vicinity</strong></a> -  Coupled with variations of soils, aspect and air drainage, this elevation difference of about 3000 ft.   has resulted in considerable disjunct habitat and endemism, the full extent of which are still being revealed. <p>

 
<a href="smokehole.htm"><strong>Smoke Hole Country</strong></a> -  In a limestone karst area near the South Branch of the Potomac River in WV. <p>

<a href="sounding.htm"><strong>Ascent of Sounding Knob</strong></a> <p>

<a href="spruceandfir.htm"><strong>High Elevation Spruce and Fir Forests of Sugar Creek, Yew and Black Mountains</strong></a> - Between Tea Creek and the Cranberry glades in the Allegheny Plateau.<p>


<a href="sky.htm"><strong>Sky Island Borderlands, Transition to the Southern Appalachians</strong></a> - Island habitats formed at high elevations in the south-central Appalachians.<p>
<font color=red size=1>updated, August 2004</font>
<a href="sprucek.htm"><strong>Spruce Knob</strong></a> - the highest point in West Virginia.<p>

<a href="stonycreek.htm"><strong>Stony Creek Watershed</strong></a><p>


<a href="tomlinsonrun.htm"><strong>Tomlinson Run  State Park (West Virginia)</strong></a><p>
<a href="upperbrattonsrun.htm"><strong>Upper Brattons Run</strong></a> - A section of the stream above Little California in the George Washington National Forest in Rockbridge County.<p>



<a href="warspur.htm"><strong>War Spur, Mountain Lake Wilderness</strong></a> - A northeast-trending
spur of Salt Pond Mountain within the Mountain Lake Wilderness of the Jefferson National Forest.<p>


<a href="warmspring.htm"><strong>Warm Springs Mountain</strong></a> - The range extends southwest 28 miles from Burnsville to Covington, Virginia and averages about three miles  in width.  It attains elevations of 4000 ft in several places, with a maximum of 4225 ft on Bald Knob.<p>


 <font color=red size=1>completely revised</font>
<a href="teacreek.htm"><strong>Tea Creek/Williams River</strong></a> - Many peaks in the surrounding plateau rise above 4000 ft (1220 meters) asl with Red Spruce Knob at 4700 ft. (1430 meters). Elevation along the Williams River at Tea Creek is about 3000 ft (910 meters) while on the southwest side of the river the steep slope of Sugar Creek Mountain rises to 4000 ft. in 2/3 mile (1 km).<p>


<a href="3forks.htm"><strong>Three Forks of the Williams River</strong></a> - a survey from the Cranberry Wilderness in the West Virginia Alleghenies.<p>

<a href="wetlands.htm"><strong>Introduction to wetlands of the Allegheny 
Mountains</strong></a> in West Virginia with the Cranesville Swamp as an 
illustration.<p>


<hr noshade size=1 width=50%>
 
<a href="1firstinventory.htm"><strong>1: First Inventories</strong></a> - A presentation of transcribed notes from the early field trips that evolved into The Forests of the Central Appalachians Project. These notes are presented with all their warts and omissions (especially punctuation!). Where clarification is needed, this is bracketed.<p>


<a href="2firstinventory.htm"><strong>2: First Inventories</strong></a> - This is the second group of our early inventories.<p>

<a href="3firstinventory.htm"><strong>3: First Inventories</strong></a> - This is the third group of our early inventories.<p>
 
<a href="4firstinventory.htm"><strong>4: First Inventories</strong></a> - This is the fourth group of our early inventories.<p>
 <p>
   
<a href="5firstinventory.htm"><strong>5: First Inventories</strong></a> - This is the fifth group of our early inventories.<p>
 <p>

<a href="6firstinventory.htm"><strong>6: First Inventories</strong></a> - This is the sixth group of our early inventories.<p> 
 <p>

<a href="7firstinventory.htm"><strong>7: First Inventories</strong></a> - This is the seventh group of our early inventories.<p> 
 <p>
</blockquote>

<center>

<br clear=all>
<table cellpadding=20>
<td valign=top>
<font face=arial>
send feedback to: </td>
<td valign=top>
<font face=arial>
RF Mueller<br>
727 Stingy Hollow Road<br>
Staunton, Virginia 24401 <br>
(540) 885-6983<br></td>
<td valign=top>
<font face=arial>
or use our 
<a href="feedback.php">feedback form</a><br><td>
</table></center>
<a href="vfw/">Back to the Virginians For Wilderness Homepage</a>
</BODY>
</HTML>

