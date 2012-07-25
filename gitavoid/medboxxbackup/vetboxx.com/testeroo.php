<?php
//Judas Gutenberg September 2008
//copies records from one table to another based on a saved regime of column links
//This code is covered under the GNU General Public License
//info here: http://www.gnu.org/copyleft/gpl.html
//the digest is as follows: you cannot modify this code without
//publishing your source code under the same license
//contact the developer at gus@asecular.com  http://asecular.com

set_time_limit(900);
 
include('tf_functions_core.php');
 
$strIn="INSERT INTO xcart_languages(code,name,value,topic) VALUES('US','language_BV','Language of Bouvet Island','Languages');
INSERT INTO xcart_languages(code,name,value,topic) VALUES('US','language_BW','Language of Botswana','Languages');
";
 $arr= ParseStringToArraySkippingQuotedRegions($strIn, "'",  ";",  "\\",  "usual"  ) ;
 foreach($arr as $a)
 {
 	echo $a . "<hr>";
 }

?>