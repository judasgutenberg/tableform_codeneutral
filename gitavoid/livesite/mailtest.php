<?php
$to = "gus@asecular.com";
$subject = "Test mail";
$message = "Hello! This is a simple email message.";
$from = "gus@asecular.com";
//$headers = "From: $from";
mail($to,$subject,$message,$headers);
echo "Mail Sent.";
?> 

tested!@