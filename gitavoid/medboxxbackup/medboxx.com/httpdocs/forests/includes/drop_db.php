<?php

execute('drop database', array('db' => $_GET['db']));
header('Location: edit.php?page=view_databases');

?>