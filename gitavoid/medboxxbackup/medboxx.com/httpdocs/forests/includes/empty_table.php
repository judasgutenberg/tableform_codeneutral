<?php

execute('delete', array(
	'db'    => $_GET['db'],
	'table' => $_GET['table']
));

header('Location: edit.php?page=table_prop&db='.$_GET['db'].'&table='.$_GET['table']);
?>