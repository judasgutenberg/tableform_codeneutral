
 
Gus

Following is the architecture I am thinking of (just to make sure we are on the 
same page)



Following is a the PHP code i was toying with.

Basically it's really easy (told you Dennis) I am using the internal MacOS 
say(1) command (man say)
It's a form that receive the parameters via HTTP GET command
(parameters = voice (alex/agnes or any of the mac voices)
text=The text to say
and path = unique identifier for message.)

File parameter should be changed to full path of temp directory (/path/to/temp_dir)
I saved it to my home directory.

<?

$path = $GET[_path]; // This will get unique name
$text = $GET[_text]; // the text to speach to say
$voice =$GET[_voice]; // the voice to use. (you liked agnes and alex but you can use more and even buy voices)

$file = "/users/scipio/apache_tmp/".$path.".aiff"; //this is the path to the file you want to send to the user

exec("/usr/bin/say -v ".$voice." -o ".$file." ".$text."");

//if we have a file, we start the show
if(file_exists($file))
{
	//These header settings make the browser know whats coming, and how to act, they are self explainatory
	header ('Content-type: Application/Octet-stream');
	header ("Content-Transfer-Encoding: binary");
	header ("Content-Length: " . filesize($file) ."; ");
	header ('Content-Disposition: attachment; filename="'.$path.'.aiff"');
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Pragma: no-cache");
	header("Expires: Mon, 26 Jul 1997 06:00:00 GMT"); // Gus - this is to make sure it is not cached!!!
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0, 
	post-check=0, pre-ch eck=0");
	foreach (file($file) as $line)
	{
		print $line; // here we send the binary stream
	}

}

?>

Integration

Instead of line 63 in dialer.php
(exec("/var/lib/asterisk/agi-bin/command.sh $uid '$content'",$op);)

which generate the file locally
exec wget(1) on the linux to the mac URL or IP with the right parameters.
parameters translation

$uid = $path (unique identifier)
$content = $text
voice is new parameter that should be alex or agnes.

Note that the system is distributed now - you use mac for the voice and the 
linux for everything else. (Alternatively use mac solo)

Nezer

Dennis - I am working on the voice (beep) recognition now.



On Apr 19, 2010, at 3:25 PM, gus wrote:

> On 4/19/2010 6:09 AM, Nezer Zaidenberg wrote:
>>
>>
>>
> i have a mac mini running 10.6.3 that i use for iphone development
?>
