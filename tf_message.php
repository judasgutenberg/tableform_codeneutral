<html>
<head>
<title></title>
<?php
if(array_key_exists("mode", $_REQUEST))
{
	if($_REQUEST["mode"]=="" )
	{
	?>
	
	<script>
	window.close();
	
	</script>
	
	<?php
	}
}
 
 ?>
	
	<script>

	if(top==window)
	{
		window.opener.location.reload();
		window.close();
		
	}
	</script>
	
 
</head>
<body>
<script>
//alert(window.name);
//copypaste.location.href='http://yahoo.com';
</script>
<?php

?>
</body>
</html>