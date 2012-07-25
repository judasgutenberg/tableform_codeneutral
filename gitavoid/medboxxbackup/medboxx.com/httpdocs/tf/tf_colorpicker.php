<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<?php
$infunction=$_REQUEST["infunction"];
$search=$_REQUEST["search"];
?>
<html>
<head>
<script src="tf.js"><!-- --></script>
<script src="tf_drawrelationships.js"><!-- --></script>
	<title>Color Picker</title>
</head>

<body>
<script>
document.write(colortable('<?php echo $infunction?>'));


</script>
<?php

if($search!="" && $search!="undefined")
{
	?>
	<form name='BForm' onsubmit='<?php echo $search?>;return false'>
	Pick a color and then enter a search term and then click "search."<br>
	<input type=text name='search'>
	<input type=submit value='search'  >
	</form>
	
	<?php
}

?>

</body>
</html>
