<?php
$olderror=error_reporting(0);
$to=$_REQUEST["to"];
$subject=$_REQUEST["subject"];
$body=$_REQUEST["body"];
$from="sales@featurewell.com";
$headers = "From: " . $from . "\r\nReply-To: " . $from;
$extra="-fsales@featurewell.com";
if($body=="")
{
	$body="To contact Featurewell's New York sales office, please call +1 (212) 924 2283 or email sales@featurewell.com Your Featurewell.com username is 'BIGFUN'. For a password reminder, click here http://www.featurewell.com/signin.php?mode=forgotpassword&clue=bigfun. International: WIKILEAKS: THE TMZ OF GLOBAL POLITICS by SUSAN J. DOUGLAS 656 words. The tenets of celebrity gossip -- who's thin-skinned, who's shallow, who parties, who likes chickens -- are now contaminating the reporting of international news. Second U.S. and all other rights available. Full story at http://www.featurewell.com/i.php?18713.6797.0 Politics-U.S.: CATASTROPHIC BLIZZARDS, HEAT WAVES AND FLOODS: GLOBAL WARMING OR JUST CRAZY WEATHER? by STAN COX 2723 words. It is very likely that public discussion of the climate will tend to focus on events like heat waves, floods and storms more than on the invisible, and ultimately more important, transformation of the planet-wide climate. Second electronic and all other rights available. Full story at http://www.featurewell.com/i.php?18704.6797.0 Politics-U.S.: FOOD FIGHT by CATHY YOUNG 999 words. Parents have the right to decide what their children eat -- but let's not pretend that many of them don't make woefully bad decisions. Second electronic and all other rights available. Full story at http://www.featurewell.com/i.php?18724.6797.0 Politics-U.S.: WATCHING WHAT YOU EAT by GREG BEATO 1302 words. Why has the USDA been plumping up the food stamps program like a factory chicken? Second U.S. and all other rights available. Full story at http://www.featurewell.com/i.php?18715.6797.0 Politics-U.S.: NOTES FROM THE MORAL UNDERGROUND by ANDREW OXFORD 1369 words. Sociologist Lisa Dodson, author of \"The Moral Underground: How Ordinary Americans Subvert an Unfair Economy,\" has spent years studying the struggles of the growing ranks of impoverished Americans. Second U.S. and all other rights available. Full story at http://www.featurewell.com/i.php?18709.6797.0 Politics-U.S.: WIKILEAKS REVEALS DISGUSTING US ALLIES IN CENTRAL ASIA by TED RALL 818 words. Cables reveal background of pro-dictator U.S. policy. Not available in Aspen CO, Boise ID, Bradford PA, Columbia SC, Springfield IL. and Japan. All other rights available. Full story at http://www.featurewell.com/i.php?18707.6797.0 Politics-U.S.: THE WAR ON CAMERAS by RADLEY BALKO 6214 words. It has never been easier--or more dangerous--to record the police. Second U.S. and all other rights available. Full story at http://www.featurewell.com/i.php?18706.6797.0 Celebs: HE SHALL OVERCOME by RACHEL KAADZI GHANSAH 4884 words. Jay-Z is 450 Million beyond the projects. Where does he go from here? Not available in New York City. All other rights available. Full story at http://www.featurewell.com/i.php?18714.6797.0 Celebs: TWITTER: TV'S NEW BATTLEGROUND by DAMIAN HOLBROOK 767 words. It used to be that celebrity beefs were settled privately by their handlers and fan gripes were reserved for chat rooms. No longer. Second U.S. and all other rights available. Electronic rights not available. Full story at http://www.featurewell.com/i.php?18723.6797.0 Celebs: JULIAN SCHNABEL ON FILM, POWER, CHARITY AND ART by ALEXANDRA PEERS 1200 words. The artist and director talks about his new likely-to-be-controversial movie \"Miral,\" and a two-year partnership with German luxury car manufacturer Maybach. Not available in New York City. All other rights available. Full story at http://www.featurewell.com/i.php?18716.6797.0 Technology: THE GREAT MURDOCH IPAD DEBATE by NICK SUMMERS 1532 words. News Corp's iPad-only newspaper, the Daily will soon debut. Why do many media critics root for its demise, while many others greet its arrival like the second coming? Not available in New York City. All other rights available. Full story at http://www.featurewell.com/i.php?18698.6797.0 Technology: PEER-TO-PEER RENTING by CLIVE THOMPSON 606 words. We're seeing a new relationship to property -- where access trumps ownership. We're using bits to help us share atoms. Second U.S. and all other rights available. Full story at http://www.featurewell.com/i.php?18679.6797.0 Food & Wine: MOJO RISING by TAYLOR EASON 646 words. Producers in Rioja and Ribera del Duero have decided to change up their dusty, Tempranillo-based grape juice and make wine the new-fashioned way. Not available in Memphis. All other rights available. Full story at http://www.featurewell.com/i.php?18719.6797.0 Food & Wine: CHEESE BALL by YVONA FAST 1159 words. No matter how you slice it, it's just not a holiday party without cheese. Second rights available in New York City. All other rights available. Full story at http://www.featurewell.com/i.php?18711.6797.0 Food & Wine: CHAMPAGNE TASTE, BEER BUDGET by TAYLOR EASON 882 words. The price of bubbly often hinges on the second fermentation: Methode Champenoise or not? Not available in Memphis. All other rights available. Full story at http://www.featurewell.com/i.php?18703.6797.0 Health: STAYING HEALTHY DURING THE HOLIDAYS by ALEXANDRA GROSS 821 words. To cleanse the body of harmful viruses, you don't need a pricey New Age retreat. Second U.S. and all other rights available. Not available in New York City. Full story at http://www.featurewell.com/i.php?17348.6797.0 Health: 7 WAYS TO HALT HEAD PAIN by JEANNETTE MONINGER 1543 words. The vast majority of women will feel the dull ache of a tension headache at some point in their lives. Whether your head hurts only occasionally or all too frequently, these expert tips can help. Second U.S. and all other rights available. Full story at http://www.featurewell.com/i.php?18717.6797.0 Film & TV: IS THIS THE END OF THE LAW & ORDER ERA? by ILEANE RUDOLPH 596 words. It is possible that for the first time in 21 years there could be no Law & Order show on television. Second U.S. and all other rights available. Electronic rights not available. Full story at http://www.featurewell.com/i.php?18722.6797.0 Life: SCROOGENOMICS by JASON ZASKY 1249 words. University of Minnesota economist Joel Waldfogel makes the case against holiday gift-giving. Second electronic and all other rights available. Full story at http://www.featurewell.com/i.php?18720.6797.0 Life: YOUR GUIDE TO HEALTHY HOLIDAY PARTYING by SANDRA GORDON 1165 words. Put together a party strategy that keeps your portions -- and your appetite-under control. Second U.S. and all other rights available. Full story at http://www.featurewell.com/i.php?18623.6797.0 Life: 'TIS THE SEASON FOR A BARGAIN by SUSAN PALMQUIST 757 words. How to spread Christmas cheer on a tight budget. Second electronic and all other rights available. Full story at http://www.featurewell.com/i.php?17350.6797.0 Life: MIND YOUR EMAIL MANNERS by BETH LEVINE 1548 words. Expert etiquette tips on using BCC, mass messages, forwards and more. Second U.S. and all other rights available. Full story at http://www.featurewell.com/i.php?18712.6797.0 Life: WANT HAPPY HOLIDAYS? AVOID THE HOLIDAY SPENDING HANGOVER by KIMBERLEY ALLERS SEALS 502 words. Minimize all gifting and expenditures to your immediate family (You and your Kids, and husband/significant other) Second electronic and all other rights available. Full story at http://www.featurewell.com/i.php?18710.6797.0 Life: RUDE AWAKENING by JIM MOTAVALLI 541 words. Rampant misinformation about EV price and range. Not available in Pennsylvania, Massachusetts, and Connecticut. All other rights available. Full story at http://www.featurewell.com/i.php?18708.6797.0 Humor: HOLIDAY COMMANDMENTS by BETH LEVINE 392 words. When I regift unto you, and it turns out to be something you gave unto me, lo, these many years ago, just put it away to give unto me again next year. Have faith in this most venerable truth: I will never remember. Second U.S. and all other rights available. Not available in Ottawa and Hartford. Full story at http://www.featurewell.com/i.php?6901.6797.0 Humor: 'TIS THE SEASON, UNFORTUNATELY by BOB MORRIS 385 words. DSM candidates include Gingervitis: A hypyer-manic, Martha Stewart-like state of perfectionism manifested when building elaborate gingerbread homes. Not available in New York City. All other rights available. Full story at http://www.featurewell.com/i.php?18721.6797.0 If you do not wish to receive further emails from us, please reply to this email with 'remove' in the subject. http://www.featurewell.com Reproduction of material from any of Featurewell.com's pages, without written permission is prohibited. (c) 2000-2010 Featurewell.com all rights reserved.";
}
if($to!="")
{
	echo "to:" . $to . "<BR>";
	echo "subject:" . $subject . "<BR>";
	echo "body:" . $body . "<BR>";
	echo "headers:" . $headers . "<BR>";
	echo "extra:" . $extra . "<BR>";
	$response=mail($to, $subject,  $body, $headers , $extra);
	echo "<font color=red>Mail sent<br>";
	if($response!=1)
	{
		echo "But the server says it wasn't delivered.";
	}
	else
	{
		echo "And the server says it was delivered.";
	}
	echo "</font><p>";
}
	
	
	
	
	if($to=="" )
	{
		$to="gus@asecular.com";
	}
	if($subject=="" )
	{
		$subject=="test subject";
	}
	if($body=="" )
	{
		$body="test body with lots of fun text to try";
	}
	 
	?>
	<h2>send   a test email using the SMTP server that Featurewell.com uses</h2>
	
	<form method="post" action="testmail.php">
	to: <input name="to" type="text" value="<?=$to?>"><br>
	subject: <input name="subject" type="text" value="<?=$subject?>"><br>
	body: <br><textarea cols=80 rows=25 name="body" type="text" ><?=$body?></textarea><br>
	<input name="mailemailer" type="submit" value="mail!"><br>
	</form>
	
