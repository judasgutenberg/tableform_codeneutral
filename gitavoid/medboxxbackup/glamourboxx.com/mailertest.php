<body bgcolor="ccffff" style="font-family:courier;font-size: 9px;">
<?php
$strPathPre="";
$urlroot="http://www.medboxx.com/";
include($strPathPre . "tf_constants.php");
include($strPathPre . "tf_functions_core.php");
include($strPathPre . "tf_functions_editor.php");
include($strPathPre . "tf_functions_frontend_db.php");
include($strPathPre . "tf_functions_odbc.php");
include($strPathPre . "tf_functions_backup.php");



			$phone_call_id="121";
			$email_content="hey what up total homie?";
			$office_name="Kinkerton Kountry Klub";
			$to="gus@asecular.com";
			$from="bigfun@verizon.net";
			$last_attempt="2010-06-03 10:23:12";
			$time_to_start="2010-06-03 10:28:12";
			$headers = "From: " . $office_name  . " <". $from . ">";
	
		 	mail($to, "Reminder from " .  $office_name,  $email_content, $headers);



 ?>
 mail sent