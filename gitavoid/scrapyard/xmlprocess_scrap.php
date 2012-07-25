<?php
//Judas Gutenberg Nov 30 2007
//scans all columns of a database for a search term
//This code is covered under the GNU General Public License
//info here: http://www.gnu.org/copyleft/gpl.html
//the digest is as follows: you cannot modify this code without
//publishing your source code under the same license
//contact the developer at gus@asecular.com  http://asecular.com
 
set_time_limit(900);
include('tf_functions_backup.php');
include('tf_functions_core.php');

echo main();

function main()
	{
		ini_set('memory_limit','450M');
		$strDatabase=deMoronizeDB(gracefuldecay($_REQUEST[qpre . "db"],our_db));
		$submit=strtolower($_REQUEST[qpre . "submit"]);
		$filename=gracefuldecay($_REQUEST["filename"], "pop.xml");
		// echo "-" .$rowdel . "-";
		//$quotecontent=false;
		$strPHP=$_SERVER['PHP_SELF'];
		$supressheaders=false;
 	
		 
		$out=LoginDecisions($strDatabase,  $strPHP, $strUser, $supressheaders);
		if ($strUser!="")
		{
			$intAdminType= AdministerType($strDatabase, "", $strUser);
			
			if ($intAdminType>1)
				{
					$out.=xmlprocess($filename);
	 
					
					
				}
		}
		$out =  PageHeader($strDatabase . " xmlprocess", $strExtrajs) . $out . PageFooter();
		return $out;
	}
	 


function xmlprocess($filename)
{

	if (!($fp=@fopen($filename, "r")))
	{
	        die ("Couldn't open XML.");
	}
	$usercount=0;
	$userdata=array();
	$product='';
	if (!($xml_parser = xml_parser_create()))
	{
	        die("Couldn't create parser.");
	}
	
	
	//Finally, tell the parser which functions to use, read the data from the opened file and parse the contents.

	xml_set_element_handler($xml_parser,"startElementHandler","endElementHandler");
	xml_set_character_data_handler( $xml_parser, "characterDataHandler");
	
	while( $data = fread($fp, 4096))
	{
		if(!xml_parse($xml_parser, $data, feof($fp))) 
		{
			break;
		}
	}
	xml_parser_free($xml_parser);
	
	//The data from the XML file is now held in $userdata and can be accessed using a standard PHP loop:
	
	for ($i=0;$i<$usercount; $i++) 
	{
		echo "Name: ".$userdata[$i]["title"]." ". ucfirst($userdata[$i]["first"])." ". ucfirst($userdata[$i]["last"]);
	}
	
}
 
 
 
 
 
 
function startElementHandler ($parser,$name,$attrib)
{
	global $usercount;
	global $userdata;
	global $product;
	
	switch ($name) {
	        case $name=="Product" : {
	                $userdata[$usercount]["first"] = $attrib["ProductName"];
	                $userdata[$usercount]["last"] = $attrib["UnBrandedContent"];
	                $userdata[$usercount]["nick"] = $attrib["NICK"];
	                $userdata[$usercount]["title"] = $attrib["TITLE"];
	                break;
	                }
	        }
}

function endElementHandler ($parser,$name)
{
	global $usercount;
	global $userdata;
	global $product;
	$product='';
	if($name=="CONTACT") 
	{
		$usercount++;
	}
}

 

function characterDataHandler ($parser, $data) 
{
	global $usercount;
	global $userdata;
	global $product;
	if (!$product) {return;}
	if ($product=="COMPANY") { $userdata[$usercount]["bcompany"] = $data;}
	if ($product=="GENDER") { $userdata[$usercount]["gender"] = $data;}
}






function XMLtoArray($xmlin, &$strNodeName, &$arrAttrib, &$arrSubnodes)
//returns an array of attributes and subnodes
{
//$delimiter, $data,  $quotechar="\" '", $bwlLeaveQuotesInPlace=false, $strEscapeStyle="csv", $bwlDelmiterCaseInsensitive=true, $delimiterprefixnixlist="", $chrQuoteOverwrite="", $chrPHPCommentOverwrite="", $chrNonQuoteOverwrite="", $chrEndQuoteToStripFromData=""
	$bwlInTag=false;
	$bwlInNode=false;
	$bwlInRootNode=false;
	$bwlInRootTag=false;
	$bwlInNodeName=false;
	$bwlInAttribName=false;
	$bwlInAttribValue=false;
	$bwlInClosingTag=false;
	$bwlInContent=false;
	$bwlReadyForSubNode=false;
	$bwlInSubnode=false;
	$strThisNodeName="";
	$strThisAttribName="";
	$strThisAttribValue="";
	$bwlReadyForAttribName=false;
	$bwlReadyForAttribValue=false;
	$arrSubnodes=Array();
	$nodecount=0;
	for($i=0; $i<strlen($xmlin); $i++)
	{
		if($bwlReadyForSubNode)
		{
			$bwlReadyForSubNode=false;
			$bwlInSubnode=true;
		}
		$chr=substr($xmlin, $i, 1);
	 	if($chr=="<")
		{
			$bwlInTag=true;
			$bwlInNodeName=true;
			if(!$bwlInRootNode)
			{
				$bwlInRootNode=true;
			}
			if($strNodeName=="")
			{
				$bwlInRootTag=true;
			}
		}
		if($bwlInTag)
		{
			if($chr==">")
			{
				$bwlInNodeName=false;
				$bwlInTag=false;
				if($bwlInSubnode)
				{
					if($strThisNodeName==$strNodeNameForClosing)
					{
						$arrSubnodes[$nodecount]=$strThisContent;
						$nodecount++;
						$strThisContent="";
						$bwlReadyForSubNode=true;
					}
					if($bwlInRootTag)
					{
						$bwlInRootTag=false;
						$bwlReadyForSubNode=true;
					}
				}
			
			}
		}
		if($bwlInNodeName)
		{
			if($chr=="/")
			{
				$bwlInClosingTag=true;
			
			}
			if($chr!=" ")
			{
				if($chr!="<")
				{
					$strThisNodeName.=$chr;
				
				}
			}
			else
			{
				$strNodeName=$strThisNodeName;
				$bwlInNodeName=false;
				$bwlReadyForAttribName=true;
				if(!$bwlInClosingTag)
				{
					$strNodeNameForClosing=$strThisNodeName;
				}
				else
				{
		
				
				}
			}
		
		}
		if(!$bwlReadyForSubNode  && $bwlInSubnode)
		{
			if($bwlInTag  && !$bwlInNodeName && !$bwlInAttribValue  && ($bwlReadyForAttribName  || $bwlInAttribName))
			{
				if($chr!=" " &&  $chr!="=")
				{
					if (!inList("' \"", $chr))
					{
						$strThisAttribName.=$chr;
						$bwlReadyForAttribName=false;
						$bwlInAttribName=true;
						
					}
					else
					{
						$chrQuote=$chr;
					}
				}
				else if($bwlInAttribName)
				{	
					$bwlInAttribName=false;
					$bwlReadyForAttribValue=true;
				
				}
				 
			}
			if($bwlReadyForAttribValue)
			{
				if (inList("' \"", $chr))
				{
					$bwlInAttribValue=true;
					$bwlReadyForAttribValue=false;
					$chrQuote=$chr;
				}
			 
			
			}
			else if($bwlInAttribValue)
			{
				if($chrQuote!= $chr)
				{
					$strThisAttribValue.=$chr;
				}
				else
				{
					$bwlInAttribValue=false;
					$arrAttrib[$strThisAttribName]=$strThisAttribValue;
					$strThisAttribValue="";
					$strThisAttribName="";
				}
				
			
			}
		}
		if($bwlInSubnode)
		{
			$strThisContent.=$chr;
		}
		
	}
}
?>