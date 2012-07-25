<?php
//HTML to PDF
	/**
	 * Genereate PDF from HTML
	 * @author Harish Chauhan
	 * @version 1.0.0
	 * @name HTML_TO_PDF
	 */
	
	define ("HKC_USE_ABC",1);
	define ("HKC_USE_EASYW",2);

	class HTML_TO_PDF
	{
		var $html 	= "";
		var $htmlurl= "";
		var $error 	= "";
		var $host	= "";
		var $port	= 80;
		var $url	= "";
		var $_useurl  = "";
		
		var $saveFile = "";
		var $downloadFile = "";	
		var $_cookie = "";
		
		function HTML_TO_PDF($html="",$useurl = HKC_USE_ABC)
		{
			$this->html = $html;
			$this->_useurl=$useurl;
		}
		
		function useURL($useurl)
		{
			$this->_useurl = $useurl;
		}
		
		function saveFile($file="")
		{
			if(empty($file))
				$this->saveFile = time().".pdf";
			else 
				$this->saveFile =$file;
		}
		
		function downloadFile($file="")
		{
			if(empty($file))
				$this->downloadFile = time().".pdf";
			else 
				$this->downloadFile =$file;
		}
		
		function error()
		{
			return  $this->error;
		}
		
		function convertHTML($html="")
		{
			if(!empty($html))
				$this->html=$html;
			$htmlfile = time().".html";
			$url = "http://".$_SERVER['SERVER_NAME'].dirname($_SERVER['PHP_SELF'])."/".$htmlfile;
			
			$this->write_file($htmlfile,$this->html);

			$return = $this->convertURL($url);
			//if(is_file($htmlfile))
				//@unlink($htmlfile);
			return $return;
		}
		
		function convertURL($url)
		{
			$this->htmlurl = $url;
			if($this->_useurl == HKC_USE_ABC)
				return $this->_convertABC();
			elseif ($this->_useurl == HKC_USE_EASYW)
				return $this->_convertEASYW();
		}
		
		function _convertABC()
		{
			$this->host = "64.39.14.230";

			$this->url = "/pdf-net/cleardoc.aspx";
			$this->_sendRequest($s_POST_DATA);
			$s_POST_DATA = "url=".urlencode($this->htmlurl);
			$s_POST_DATA.= "&PagedOutput=on";
			$s_POST_DATA.= "&AddLinks=on";
			$s_POST_DATA.= "&x=30";
			$s_POST_DATA.= "&y=30";
			$s_POST_DATA.= "&w=550";
			$s_POST_DATA.= "&h=704";
			$s_POST_DATA.= "&UserName=";
			$s_POST_DATA.= "&Password=";
			$s_POST_DATA.= "&Timeout=15550";
			$s_POST_DATA.= "&Submit=Add URL";

			$this->url = "/pdf-net/addurl.aspx";
			$this->_sendRequest($s_POST_DATA);
			$this->url = "/pdf-net/showdoc.aspx";
			$s_POST_DATA = "";
			
			$pdfdata = $this->_sendRequest($s_POST_DATA);
			if($pdfdata===false) return false;

			if(!empty($this->saveFile))		
				$this->write_file($this->saveFile,$pdfdata);
			if(!empty($this->downloadFile))
				$this->download_file($pdfdata);
			return $pdfdata;
		}
		
		function _convertEASYW()
		{
			//http://www.easysw.com/htmldoc/pdf-o-matic.php
			$this->url= "/htmldoc/pdf-o-matic.php";
			$this->host="www.easysw.com";
			$s_POST_DATA = "URL=".urlencode($this->htmlurl);
			$s_POST_DATA .= "&FORMAT=.pdf";
			$pdfdata = @file_get_contents("http://".$this->host.$this->url."?".$s_POST_DATA);
			if(!empty($pdfdata))
			{
				if(!empty($this->saveFile))		
					$this->write_file($this->saveFile,$pdfdata);
				if(!empty($this->downloadFile))
					$this->download_file($pdfdata);
				return true;
			}
			
			$pdfdata = $this->_sendRequest($s_POST_DATA);
			if($pdfdata===false) return false;
			
			if(!empty($this->saveFile))		
				$this->write_file($this->saveFile,$pdfdata);
			if(!empty($this->downloadFile))
				$this->download_file($pdfdata);

			return $pdfdata;			
		}
		
		function _sendRequest($s_POST_DATA)
		{
			if(function_exists("curl_init"))
				return $this->_sendCRequest($s_POST_DATA);
			else
				return $this->_sendSRequest($s_POST_DATA);
		}

		function _sendSRequest($s_POST_DATA)
		{
			$s_Request = "POST ".$this->url." HTTP/1.0\n";
			$s_Request .="Host: ".$this->host.":".$this->port."\n";
			$s_Request .="Content-Type: application/x-www-form-urlencoded\n";
			$s_Request .="Content-Length: ".strlen($s_POST_DATA)."\n";
			if($this->_useurl == HKC_USE_ABC && !empty($this->_cookie))
				$s_Request .="Cookie: ".$this->_cookie."\n";
			$s_Request .="\n".$s_POST_DATA."\n\n";
			
			$fp = fsockopen ($this->host, $this->port, $errno, $errstr, 30);
			if(!$fp)
			{
				$this->error = "ERROR: $errno - $errstr<br />\n";
				return false;
			}
			fputs ($fp, $s_Request);
			while (!feof($fp)) {
				$this->GatewayResponse .= fgets ($fp, 128);
			}
			fclose ($fp);

			if(empty($this->_cookie))
			{
				@preg_match("/ASP.NET_SessionId[^;]*/s", $this->GatewayResponse, $match);
				$this->_cookie = $match[0];
			}

			@preg_match("/^(.*?)\r?\n\r?\n(.*)/s", $this->GatewayResponse, $match);
			if($this->_useurl == HKC_USE_ABC)
				@preg_match("/^(.*?)\r?\n\r?\n(.*)/s", $match[2], $match);
			$this->GatewayResponse =$match[2];

			return $this->GatewayResponse;
		}
		
		function _sendCRequest($s_POST_DATA)
		{
			$ch = curl_init();
			//"http://".$this->host.":".$this->port.$this->url;
			curl_setopt( $ch, CURLOPT_URL, "http://".$this->host.":".$this->port.$this->url );
			curl_setopt( $ch, CURLOPT_POST, 1 );
			curl_setopt( $ch, CURLOPT_POSTFIELDS,$s_POST_DATA);
			if($this->_useurl == HKC_USE_ABC && !empty($this->_cookie))
				curl_setopt( $ch, CURLOPT_COOKIE,$this->_cookie);
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt( $ch, CURLOPT_TIMEOUT,30 );
			curl_setopt($ch, CURLOPT_HEADER, 1);
			$this->GatewayResponse=curl_exec( $ch );
			if(curl_error($ch)!="")
			{
				$this->error = "ERROR: ".curl_error($ch)."<br />\n";
				return false;
			}
			curl_close($ch);
			
			if(empty($this->_cookie))
			{
				@preg_match("/ASP.NET_SessionId[^;]*/s", $this->GatewayResponse, $match);
				$this->_cookie = $match[0];
			}

			@preg_match("/^(.*?)\r?\n\r?\n(.*)/s", $this->GatewayResponse, $match);
			if($this->_useurl == HKC_USE_ABC)
				@preg_match("/^(.*?)\r?\n\r?\n(.*)/s", $match[2], $match);
			$this->GatewayResponse =$match[2];

			return $this->GatewayResponse;
		}

		function write_file($file,$content,$mode="w")
		{
			$fp=@fopen($file,$mode);
			if(!is_resource($fp))
				return false;
			fwrite($fp,$content);
			fclose($fp);
			return true;
		}

		function download_file($pdfdata)
		{
			@header("Cache-Control: ");// leave blank to avoid IE errors
			@header("Pragma: ");// leave blank to avoid IE errors
			@header("Content-type: application/octet-stream");
			@header("Content-Disposition: attachment; filename=".$this->downloadFile);
			echo $pdfdata;
		}

	}


//HTML to DOC
	
	/**
	 * Convert HTML to MS Word file
	 * @author Harish Chauhan
	 * @version 1.0.0
	 * @name HTML_TO_DOC
	 */
	
	class HTML_TO_DOC
	{
		var $docFile="";
		var $title="";
		var $htmlHead="";
		var $htmlBody="";
		
		
		/**
		 * Constructor
		 *
		 * @return void
		 */
		function HTML_TO_DOC()
		{
			$this->title="Untitled Document";
			$this->htmlHead="";
			$this->htmlBody="";
		}
		
		/**
		 * Set the document file name
		 *
		 * @param String $docfile 
		 */
		
		function setDocFileName($docfile)
		{
			$this->docFile=$docfile;
			if(!preg_match("/\.doc$/i",$this->docFile))
				$this->docFile.=".doc";
			return;		
		}
		
		function setTitle($title)
		{
			$this->title=$title;
		}
		
		/**
		 * Return header of MS Doc
		 *
		 * @return String
		 */
		function getHeader()
		{
			$return  = <<<EOH
			 <html xmlns:v="urn:schemas-microsoft-com:vml"
			xmlns:o="urn:schemas-microsoft-com:office:office"
			xmlns:w="urn:schemas-microsoft-com:office:word"
			xmlns="http://www.w3.org/TR/REC-html40">
			
			<head>
			<meta http-equiv=Content-Type content="text/html; charset=utf-8">
			<meta name=ProgId content=Word.Document>
			<meta name=Generator content="Microsoft Word 9">
			<meta name=Originator content="Microsoft Word 9">
			<!--[if !mso]>
			<style>
			v\:* {behavior:url(#default#VML);}
			o\:* {behavior:url(#default#VML);}
			w\:* {behavior:url(#default#VML);}
			.shape {behavior:url(#default#VML);}
			</style>
			<![endif]-->
			<title>$this->title</title>
			<!--[if gte mso 9]><xml>
			 <w:WordDocument>
			  <w:View>Print</w:View>
			  <w:DoNotHyphenateCaps/>
			  <w:PunctuationKerning/>
			  <w:DrawingGridHorizontalSpacing>9.35 pt</w:DrawingGridHorizontalSpacing>
			  <w:DrawingGridVerticalSpacing>9.35 pt</w:DrawingGridVerticalSpacing>
			 </w:WordDocument>
			</xml><![endif]-->
			<style>
			<!--
			 /* Font Definitions */
			@font-face
				{font-family:Verdana;
				panose-1:2 11 6 4 3 5 4 4 2 4;
				mso-font-charset:0;
				mso-generic-font-family:swiss;
				mso-font-pitch:variable;
				mso-font-signature:536871559 0 0 0 415 0;}
			 /* Style Definitions */
			p.MsoNormal, li.MsoNormal, div.MsoNormal
				{mso-style-parent:"";
				margin:0in;
				margin-bottom:.0001pt;
				mso-pagination:widow-orphan;
				font-size:7.5pt;
			        mso-bidi-font-size:8.0pt;
				font-family:"Verdana";
				mso-fareast-font-family:"Verdana";}
			p.small
				{mso-style-parent:"";
				margin:0in;
				margin-bottom:.0001pt;
				mso-pagination:widow-orphan;
				font-size:1.0pt;
			        mso-bidi-font-size:1.0pt;
				font-family:"Verdana";
				mso-fareast-font-family:"Verdana";}
			@page Section1
				{size:8.5in 11.0in;
				margin:1.0in 1.25in 1.0in 1.25in;
				mso-header-margin:.5in;
				mso-footer-margin:.5in;
				mso-paper-source:0;}
			div.Section1
				{page:Section1;}
			-->
			</style>
			<!--[if gte mso 9]><xml>
			 <o:shapedefaults v:ext="edit" spidmax="1032">
			  <o:colormenu v:ext="edit" strokecolor="none"/>
			 </o:shapedefaults></xml><![endif]--><!--[if gte mso 9]><xml>
			 <o:shapelayout v:ext="edit">
			  <o:idmap v:ext="edit" data="1"/>
			 </o:shapelayout></xml><![endif]-->
			 $this->htmlHead
			</head>
			<body>
EOH;
		return $return;
		}
		
		/**
		 * Return Document footer
		 *
		 * @return String
		 */
		function getFotter()
		{
			return "</body></html>";
		}
		
		/**
		 * Create The MS Word Document from given HTML
		 *
		 * @param String $html :: URL Name like http://www.example.com
		 * @param String $file :: Document File Name
		 * @param Boolean $download :: Wheather to download the file or save the file
		 * @return boolean 
		 */
		
		function createDocFromURL($url,$file,$download=false)
		{
			if(!preg_match("/^http:/",$url))
				$url="http://".$url;
			$html=@file_get_contents($url);
			return $this->createDoc($html,$file,$download);	
		}

		/**
		 * Create The MS Word Document from given HTML
		 *
		 * @param String $html :: HTML Content or HTML File Name like path/to/html/file.html
		 * @param String $file :: Document File Name
		 * @param Boolean $download :: Wheather to download the file or save the file
		 * @return boolean 
		 */
		
		function createDoc($html,$file,$download=false)
		{
			//if(is_file($html))
				//$html=@file_get_contents($html);
			
			$this->_parseHtml($html);
			$this->setDocFileName($file);
			$doc=$this->getHeader();
			$doc.=$this->htmlBody;
			$doc.=$this->getFotter();
							
			if($download)
			{
				@header("Cache-Control: ");// leave blank to avoid IE errors
				@header("Pragma: ");// leave blank to avoid IE errors
				@header("Content-type: application/octet-stream");
				@header("Content-Disposition: attachment; filename=\"$this->docFile\"");
				echo $doc;
				return true;
			}
			else 
			{
				return $this->write_file($this->docFile,$doc);
			}
		}
		
		/**
		 * Parse the html and remove <head></head> part if present into html
		 *
		 * @param String $html
		 * @return void
		 * @access Private
		 */
		
		function _parseHtml($html)
		{
			$html=preg_replace("/<!DOCTYPE((.|\n)*?)>/ims","",$html);
			$html=preg_replace("/<script((.|\n)*?)>((.|\n)*?)<\/script>/ims","",$html);
			preg_match("/<head>((.|\n)*?)<\/head>/ims",$html,$matches);
			$head=$matches[1];
			preg_match("/<title>((.|\n)*?)<\/title>/ims",$head,$matches);
			$this->title = $matches[1];
			$html=preg_replace("/<head>((.|\n)*?)<\/head>/ims","",$html);
			$head=preg_replace("/<title>((.|\n)*?)<\/title>/ims","",$head);
			$head=preg_replace("/<\/?head>/ims","",$head);
			$html=preg_replace("/<\/?body((.|\n)*?)>/ims","",$html);
			$this->htmlHead=$head;
			$this->htmlBody=$html;
			return;
		}
		
		/**
		 * Write the content int file
		 *
		 * @param String $file :: File name to be save
		 * @param String $content :: Content to be write
		 * @param [Optional] String $mode :: Write Mode
		 * @return void
		 * @access boolean True on success else false
		 */
		
		function write_file($file,$content,$mode="w")
		{
			$fp=@fopen($file,$mode);
			if(!is_resource($fp))
				return false;
			fwrite($fp,$content);
			fclose($fp);
			return true;
		}

	}

?>