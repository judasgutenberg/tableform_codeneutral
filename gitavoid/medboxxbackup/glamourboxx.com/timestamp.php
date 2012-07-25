<?php 
//Judas Gutenberg January 2006
//provides a web front end admin tool for any MySQL db
//depends on a table called tf_relation for foreign key info
//also needs admin table, permission table, and permission_type table

require('tf_functions_core.php');
require('tf_save_form.php');
require('tf_functions_serialize_form.php');


echo time();
echo "<p>";

echo date("Y-m-d H:i:s");
echo "<p>";
echo date(time);


?>