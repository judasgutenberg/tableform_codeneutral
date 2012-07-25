<?php 
//Gus Mueller February 2007////////////////
//place to test new functions
if(is_file('core_functions.php'))
{
	require('core_functions.php');
	if(!IsExtraSecure())
	{
		die(ExtraSecureFailure());
	}
}
echo phpinfo();
 
?>