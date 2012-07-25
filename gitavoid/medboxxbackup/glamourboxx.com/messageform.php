<html>
<head>
<title>message sendertron 2000</title>
</head>

<body bgcolor=ccffff>
<?
//http://medboxx.com/tasks.php?donow=3&makecall=19176504575&message=Hello,+this+is+the+office+of+Peterson+medical+remding+you+of+your+appointment+for+tuesday+June+22+at+10+AM
?>
<strong>Crank call someone with the phone caller API!</strong><p>
<form action="tasks.php" method="GET">
<table cellspacing=0 cellpadding=4 cellspacing=0>
<tr>
<td>
Message: </td><td><input name="message" size="122" value="Hello, this is the office of Peterson medical reminding you of your appointment for tuesday June 22 at 10 AM"></td></tr>
<tr>
<td>
JSON bypass: </td><td><textarea name="jsonbypass" rows="3" cols="122" >{"version":1,"data":[{"tag":"medboxx_box.150","phone":"18453401090","tts":"<voice name="William-8kHz">This is a call from Worthington Medical Facility reminding you of your appointment for 1:45 pm on Friday July 23rd. If you have any questions please call 2221212212. Thank you.</voice>"}]}</textarea></td></tr>
<tr><td>
Phone number: </td><td><input size="22" name="makecall" value="19176504575"></td></tr>
<tr><td>Voice: </td><td><select   name="voice" ><option selected>Allison</option><option>William</option></select></td></tr>
<tr><td>Frequency (KHz): </td><td><select   name="frequency" ><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option selected>8</option><option>9</option><option>10</option></select></td></tr>
<tr><td colspan="2">
 
<input type="submit" name="submit" value="Make the Call!"></td></tr>
</table>
<input type="hidden" name="donow" value="3">
</form>

</body>
</html>