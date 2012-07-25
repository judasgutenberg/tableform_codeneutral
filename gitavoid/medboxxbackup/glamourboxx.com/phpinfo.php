<?php 
//Gus Mueller February 2007////////////////
//place to test new functions
if(is_file('tf_functions_core.php'))
{
	require('tf_functions_core.php');
	if(!IsExtraSecure())
	{
		die(ExtraSecureFailure());
	}
}
echo phpinfo();
 
?>