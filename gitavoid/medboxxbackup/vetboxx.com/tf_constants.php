<?php 

if(strpos(" " .  $_SERVER['SERVER_NAME'], "vetboxx.com")>0)
{
	define('optionalhost', '');
	define ('our_db',   'vetboxx');
	define ('con_server_optional', 'localhost');
	define ('con_user_optional', 'admin');
	define ('con_pwd_optional', '#rooster19');
	define ('con_server_web', 'localhost');
	define ('con_user_web', 'admin');
	define ('con_pwd_web', '#rooster19');
}
else
{
	define('optionalhost', '');
	define ('our_db',   'vetboxx');
	define ('con_server_optional', 'localhost');
	define ('con_user_optional', 'zroot');
	define ('con_pwd_optional', '');
	define ('con_server_web', 'localhost');
	define ('con_user_web', 'zzroot');
	define ('con_pwd_web', '');
}
define('tftemp',  '/usr/local/apache2/tftemp');
define ('numrange_low', '1910');
define ('numrange_hi', '2020');
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
define ('userimagepath', 'clientimages');
define ('textarea', 'wysiwygpro');
define ('listaddside', 'left');
define ('databasepickerlink', 'true');
$conn=false;
define('themecolor', '009AD6');
define('textcolorontheme', 'FFFFFF');
define('customertype', 'Owner');
define('dependenttype', 'Critter');
define('eliteprofessionaltype', 'Veterinarian');
define('professionaltype', 'Staffer');
define('locationtype', 'Office');
define('guardiantype', 'Owner');
define('sitename', 'VetBoxx.com');
//define("authentication_table", "user");
define ('blowfish_key','18d45d91d59e5677fc6ee6dd007d4137');

define('whatwedoconfig', 'p|what-mb-does:infobox p|what-mb-does:scheduling p|what-mb-does:patientreminders |what-mb-does:bottombuttons');
?>