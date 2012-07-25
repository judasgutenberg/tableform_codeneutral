<?php 

define('optionalhost', 'gus_demo');
define ('our_db',   'gus_demo');
define ('con_server_optional', 'localhost');
define ('con_user_optional', 'gus_demo');
define ('con_pwd_optional', 'Rooster19');
define ('con_server_web', 'p41mysql87.secureserver.net');
define ('con_user_web', 'gus_demo');
define ('con_pwd_web', 'Rooster19');

define ('numrange_low', '1930');
define ('numrange_hi', '2060');
define ('qdelimiter', '_');
//qpre is the prefix for all querystring variables that are not the names of actual table columns
define ('qpre', 'x' . qdelimiter);
//tfpre is the prefix for all core tableform housekeeping tables. These aren't visible to most users.
define ('tfpre', 'tf_');
define ('encryptionkey', 'rockington');
define ('extrainclude', 'frontendfuncs.php|../functions.php|xcartfunctions.php');
//define ('default_table', 'game');
define ('pluralizationmethod', 'new');
//location of the images directory
define ('imagepath', 'images');
define ('textarea', 'wysiwygpro');
define ('listaddside', 'left');
define ('tf_dir', '');
define ('headerfunction', 'sheader'); //if empty or undefined, use tf's native header
define ('footerfunction', 'sfooter'); //if empty or undefined, use tf's native footer
define ('mode', '');
$conn=false;


define ('blowfish_key','18d45d91d59e5677fc6ee6dd007d4137');


//define("authentication_table", "xcart_customers");
define("user_pk", "login");
define("username", "login");
define("password", "password");
define("cookie", "xid");
define("offline_id", 445);
//for xcart to work
//xcartfunctions.php needs to be
//in the pipe-delimited list at extrainclude
//define("authtype", "xcart");
?>