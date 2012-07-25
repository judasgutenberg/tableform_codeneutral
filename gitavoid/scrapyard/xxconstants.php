<?php 

 
define ('our_db',   'lola');
define ('con_server_localhost', 'localhost');
define ('con_user_localhost', 'lola');
define ('con_pwd_localhost', '');
define ('con_server_web', 'localhost');
define ('con_user_web', 'lola');
define ('con_pwd_web', 'Lola123');

define ('numrange_low', '1930');
define ('numrange_hi', '2060');
define ('qdelimiter', '_');
//qpre is the prefix for all querystring variables that are not the names of actual table columns
define ('qpre', 'x' . qdelimiter);
//tfpre is the prefix for all core tableform housekeeping tables. These aren't visible to most users.
define ('tfpre', 'tf_');
define ('encryptionkey', 'rxckinvton78');
define ('extrainclude', 'xcartfunctions.php|frontendfuncs.php|implementationfunctions.php');
//define ('default_table', 'game');
define ('pluralizationmethod', 'new0');
//location of the images directory
define ('imagepath', 'images');
define ('textarea', 'wysiwygpro');
define ('listaddside', 'left');



//define ('blowfish_key','18d45d91d59e5677fc6ee6dd007d4137');

//define("authentication_table", "xcart_customers");
//define("user_pk", "login");
//define("username", "login");
//define("password", "password");
define("cookie", "which");
//for xcart to work
//xcartfunctions.php needs to be
//in the pipe-delimited list at extrainclude
define("authtype", "tablezilla");

$conn=false;
?>