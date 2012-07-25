<?php 

define('optionalhost', '');
define ('our_db',   'BOOSTUP');
define ('con_server_optional', 'localhost');
define ('con_user_optional', 'eat');
define ('con_pwd_optional', 'dg4f00d%21');
define ('con_server_web', 'localhost');
define ('con_user_web', 'eat');
define ('con_pwd_web', 'dg4f00d%21');

define ('numrange_low', '1930');
define ('numrange_hi', '2060');
define ('qdelimiter', '_');
//qpre is the prefix for all querystring variables that are not the names of actual table columns
define ('qpre', 'x' . qdelimiter);
//tfpre is the prefix for all core tableform housekeeping tables. These aren't visible to most users.
define ('tfpre', 'tf_');
define ('encryptionkey', 'rockington');
define ('extrainclude', 'frontendfuncs.php|implementationfunctions.php|xcartfunctions.php');
//define ('default_table', 'game');
define ('pluralizationmethod', 'new');
//location of the images directory
define ('imagepath', 'images');
define ('textarea', 'wysiwygpro');
define ('listaddside', 'left');
define ('databasepickerlink', 'true');
$conn=false;

//define("authentication_table", "user");
define ('blowfish_key','18d45d91d59e5677fc6ee6dd007d4137');
?>