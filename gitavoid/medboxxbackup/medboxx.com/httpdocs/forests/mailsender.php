<?php 

//$to_email_address - received from the "POST" 
//$from_email_address - ditto 
//$subject 
//$message 

// 
//First, validate the addresses using Jons' function 
// 
 

// 
//Second, test the results and send the message or display 
//an error 
// 






 	mail($to,$Subject,$Body . chr(13) . $Email . " (" . $Name . ")", "From: R. F. Mueller <tetraphis@yahoo.com>" .  "\r\n"
    ."Reply-To: " . $Email . "\r\n"
    ."X-Mailer: PHP/" . phpversion());
	//$f=fopen("adoptioninquiries/".str_replace( "@", "~", $Email).".txt", 'a');
	//fwrite($f, "[".$Email."]\n".$mb);
	//fclose($f);
	header("location: mailx.php?thanks=thanks");




?> 

