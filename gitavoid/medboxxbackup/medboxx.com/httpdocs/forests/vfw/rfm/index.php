<?
require("functions.php");
$title="";
$strFilename="";
$out="";
if (array_key_exists("f",$_REQUEST))
{
	$strFilename=$_REQUEST["f"];
}
else

{
	//$strFilename="intro.txt";

}
$root="content";

$filelist=  filelist($root);
 
 if ( $strFilename!="")
 {
	$body=  displayitem($root, $strFilename);
 	$title= title($root, $strFilename);
}
else
{
	$body=  "<p>&nbsp; <p class='intro'>What follows is a life, in part as lived, in part as imagined, I hope, with fidelity. Many of these poems have Wisconsin as their setting, while others have theirs in Virginia. Many are based to a varying degree on the writer's direct experiences or thoughs that sprang from them. A number represent experiences and inclinations unfamiliar in  our urbanized world, others the impact of historical events on an individual. In many wild nature is an active participant. Most were written in the early 1980s, usually with a tree trunk as a backrest.</p>
<img src=\"poemsfront.jpg\" width=\"600\" height=\"462\" alt=\"\">

";

}

if ($title=="")
{

	$title="Poems of R.F.Mueller";

}



//require("header.php");



 


//require("footer.php");
?>
<html>
<head>
<title><?=$title?></title>
<link rel="stylesheet" href="poems.css" type="text/css">
</head>
<body>


 <table>
 <tr>
 
 <td valign=top>
 <?=$filelist?>
 
 
 </td>
 
 
 <td valign=top width="600">
 <div class="overallheading">
&copy;Poems of R.F.Mueller- Other Times, Other Thoughts</div>
 
 <p/>
  <?=$body?>
 
 
 </td>
 </tr>
 </table>
 </body>
 </html>