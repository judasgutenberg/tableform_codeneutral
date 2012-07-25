<?php
//This code is covered under the GNU General Public License
//info here: http://www.gnu.org/copyleft/gpl.html
//the digest is as follows: you cannot modify this code without
//publishing your source code under the same license
//contact the developer at gus@asecular.com  http://asecular.com

function MakeTableCopyMapTables($strDatabase)
{

	$sql=conDB();
	$out="";
	$out.=MakeTableIfNotThere($strDatabase, tfpre . "relation", "MakeRelationTables");
	$strSQL="
		CREATE TABLE " . $strDatabase . "." .  tfpre . "tablecopymap (
		`tablecopymap_id` int(11) NOT NULL auto_increment,
		`name` varchar(80) collate utf8_bin default NULL,
		`create_date` datetime default NULL,
		`source_tablename` varchar(50) default NULL,
		`dest_tablename` varchar(50) default NULL,
		fk_column_name  varchar(50) default NULL,
		postcopy_script  text default NULL,
		merge_dest_pk  varchar(50) default NULL,
		merge_source_fk  varchar(50) default NULL,
		PRIMARY KEY (`tablecopymap_id`)
		)";
	$tables = $sql->query($strSQL);
	$out.= sql_error();
	$out.=MakeTableIfNotThere($strDatabase, tfpre . "relation", "MakeRelationTables");
	$strSQL="
		CREATE TABLE " . $strDatabase . "." .  tfpre . "tablecopymap_fieldlink (
		`tablecopymap_fieldlink_id` int(11) NOT NULL auto_increment,
		`tablecopymap_id` int(11) default NULL,
		`source_column_name` varchar(50)  default NULL,
		`dest_column_name` varchar(50)  default NULL,
		conversion_formula varchar(200) default NULL,
		PRIMARY KEY (`tablecopymap_fieldlink_id`)
		)";
	$tables = $sql->query($strSQL);
	$out.= sql_error();
	$out.= NewRelation($strDatabase, tfpre . 'tablecopymap_fieldlink', 'tablecopymap_id', tfpre . 'tablecopymap', 'tablecopymap_id');
	return $out;
}

function MakeSQLLogTable($strDatabase)
{
	$sql=conDB();
	$out="";
	$strSQL="

		CREATE TABLE " . $strDatabase . "." .  tfpre . "sqllog (
		`sqllog_id` int(11) NOT NULL auto_increment,
		`sql_string` text,
		`time_executed` timestamp NOT NULL,
		PRIMARY KEY (`sqllog_id`)
	)  ";
	$tables = $sql->query($strSQL);
	$out.= mysql_error();
	return $out;
}

function MakeDBDiffTables($strDatabase)
{
	$sql=conDB();
	$out="";
	$out.=MakeTableIfNotThere($strDatabase, tfpre . "relation", "MakeRelationTables");
	$strSQL="
	CREATE TABLE " . $strDatabase . "." .  tfpre . "dbdiff_table (
		`dbdiff_table_id` int(11) NOT NULL auto_increment,
		`dbdiff_id` int(11) default NULL,
		`table_name` varchar(50) collate utf8_bin default NULL,
		`table_rowcount` int(11) default NULL,
		`max_id` int(11) default NULL,
		`table_checksum` bigint(11) default NULL,
		PRIMARY KEY (`dbdiff_table_id`)
		) 
	";
	$tables = $sql->query($strSQL);
	$out.= sql_error();
	$strSQL="
	CREATE TABLE " . $strDatabase . "." .  tfpre . "dbdiff (
		`dbdiff_id` int(11) NOT NULL auto_increment,
		`diff_performed` datetime default NULL,
		PRIMARY KEY (`dbdiff_id`)
	) 
	";
	$tables = $sql->query($strSQL);
	$out.= sql_error();
	$out.= NewRelation($strDatabase, tfpre . 'dbdiff_table', 'dbdiff_id', tfpre . 'dbdiff', 'dbdiff_id');
	return $out;
}


function MakeColumnInfoTables($strDatabase)
{
	$out="";
	$out.=MakeTableIfNotThere($strDatabase, tfpre . "relation", "MakeRelationTables");
	$sql=conDB();
	$strSQL="
	CREATE TABLE " . $strDatabase . "." .  tfpre . "column_info (
	`column_info_id` int(11) NOT NULL auto_increment,
	`table_name` varchar(50) default NULL,
	`column_name` varchar(80) default NULL,
	`width` int(11) default NULL,
	`height` int(11) default NULL,
	`invisible` tinyint(3) default NULL,
	`data_from_multitable_relation` tinyint(3) default NULL,
	`label` text,
	`help_text` text,
  	validation_type_id int(11) default NULL,
  	validation_pattern_id int(11) default NULL,
	fileupload tinyint default NULL,
	datecreated tinyint default NULL,
	datemodified tinyint default NULL,
	password tinyint default NULL,
	force_no_wysiwg tinyint default NULL,
	force_wysiwg tinyint default NULL,
	force_text_input tinyint default NULL,
	force_binary tinyint default NULL,
  	browsetype_id int(11) default NULL,
	PRIMARY KEY  (`column_info_id`)
	);
	";
	$tables = $sql->query($strSQL);
	$out.= sql_error();
	
	$strSQL="
	CREATE TABLE " . $strDatabase . "." .  tfpre . "validation_pattern (
	  validation_pattern_id int(11) NOT NULL auto_increment,
	  name varchar(20) default NULL,
	  pattern varchar(255) default NULL,
	  PRIMARY KEY  (validation_pattern_id)
	);";
	$tables = $sql->query($strSQL);
	$out.= sql_error();
	//a set of useful validation regular expressions
	//for some reason i need eight backslashes to end up with just one in the final javascript expression
	$strSQL="
	INSERT INTO " . $strDatabase . "." .  tfpre . "validation_pattern VALUES (1,'email','^.+@[^\\\\\\\\.].*\\\\\\\\.[a-z]{2,}$');
		";
	$tables = $sql->query($strSQL);
	$out= sql_error();
	
	$strSQL="
	INSERT INTO " . $strDatabase . "." .  tfpre . "validation_pattern VALUES (2,'American phone','^(?:\\\\\\\\([2-9]\\\\\\\\d{2}\\\\\\\\)\\\\\\\\ ?|[2-9]\\\\\\\\d{2}(?:\\\\\\\\-?|\\\\\\\\ ?))[2-9]\\\\\\\\d{2}[- ]?\\\\\\\\d{4}$');
		";
	$tables = $sql->query($strSQL);
	$out= sql_error();
	
	$strSQL="
	INSERT INTO " . $strDatabase . "." .  tfpre . "validation_pattern VALUES (3,'American postal code','^\\\\\\\\d{5}-\\\\\\\\d{4}|\\\\\\\\d{5}|[A-Z]\\\\\\\\d[A-Z] \\\\\\\\d[A-Z]\\\\\\\\d$');
		";
	$tables = $sql->query($strSQL);
	$out= sql_error();
	
	$strSQL="
	INSERT INTO " . $strDatabase . "." .  tfpre . "validation_pattern VALUES (4,'five digit zipcode','^\\\\\\\\d{5}$');
		";
	$tables = $sql->query($strSQL);
	$out= sql_error();
	
	$strSQL="
	INSERT INTO " . $strDatabase . "." .  tfpre . "validation_pattern VALUES (5,'zip+4 zipcode','^\\\\\\\\d{5}-\\\\\\\\d{4}$');
		";
	$tables = $sql->query($strSQL);
	$out= sql_error();
	
	$strSQL="
	INSERT INTO " . $strDatabase . "." .  tfpre . "validation_pattern VALUES (6,'URL','^&#40;ht|f&#41;tp&#40;&#40;?<=http&#41;s&#41;?://&#40;&#40;?<=http://&#41;www|&#40;?<=https://&#41;www|&#40;?<=ftp://&#41;ftp&#41;\\\\\\\\.&#40;&#40;[a-z][0-9]&#41;|&#40;[0-9][a-z]&#41;|&#40;[a-z0-9][a-z0-9\\\\\\\\-]{1,2}[a-z0-9]&#41;|&#40;[a-z0-9][a-z0-9\\\\\\\\-]&#40;&#4');
		";
	$tables = $sql->query($strSQL);
	$out= sql_error();
	 
	
	
	$strSQL="
	CREATE TABLE " . $strDatabase . "." .  tfpre . "validation_type (
	  validation_type_id int(11) NOT NULL auto_increment,
	  type_name varchar(45) default NULL,
	  PRIMARY KEY  (validation_type_id)
	);";
	$tables = $sql->query($strSQL);
	$out.= sql_error();
	$strSQL="
	INSERT INTO " . $strDatabase . "." .  tfpre . "validation_type VALUES (1,'no validation');";
	$tables = $sql->query($strSQL);
	$out.= sql_error();
	$strSQL="
	INSERT INTO " . $strDatabase . "." .  tfpre . "validation_type VALUES (2,'must fit pattern if field not empty');";
	$tables = $sql->query($strSQL);
	$out.= sql_error();
	$strSQL="
	INSERT INTO " . $strDatabase . "." .  tfpre . "validation_type VALUES (3,'must always fit pattern');";
	$tables = $sql->query($strSQL);
	$out.= sql_error();
	$strSQL="
	INSERT INTO " . $strDatabase . "." .  tfpre . "validation_type VALUES (4,'must never fit pattern');";
	$tables = $sql->query($strSQL);
	$out.= sql_error();
	$strSQL="
	INSERT INTO " . $strDatabase . "." .  tfpre . "validation_type VALUES (5,'must never fit pattern if field not empty');";
	$tables = $sql->query($strSQL);
	$out.= sql_error();
	$out.= NewRelation($strDatabase, tfpre . 'column_info', 'validation_type_id', tfpre . 'validation_type', 'validation_type_id');
	$out.= NewRelation($strDatabase, tfpre . 'column_info', 'validation_pattern_id', tfpre . 'validation_pattern', 'validation_pattern_id');
	
	return $out;
}
		
function MakeCalendarTables($strDatabase)
{
	$out="";
	$out.=MakeTableIfNotThere($strDatabase, tfpre . "relation", "MakeRelationTables");
	$sql=conDB();
	$strSQL="
		CREATE TABLE " . $strDatabase . ".`calendar` (
		`calendar_id` int(11) NOT NULL auto_increment,
		`calendar_name` varchar(50) default NULL,
		`description` text,
		`foreign_table_name` varchar(30) default NULL,
		`calendar_range_id` int(11) default NULL,
		`code` varchar(80) default NULL,
		PRIMARY KEY  (`calendar_id`)
		) ;
		";
		$tables = $sql->query($strSQL);
		$out.= sql_error();
		$strSQL="
		CREATE TABLE " . $strDatabase . ".`calendar_event` (
		`calendar_event_id` int(11) NOT NULL auto_increment,
		`calendar_id` int(11) default NULL,
		`notes` text,
		`start` datetime default NULL,
		`end` datetime default NULL,
		`foreign_id` int(11) default NULL,
		`calendar_event_type_id` int(11) default NULL,
		`calendar_event_characteristic_id` int(11) default NULL,
		`event_name` varchar(60) default NULL,
		PRIMARY KEY  (`calendar_event_id`)
		);
		";
		$tables = $sql->query($strSQL);
		$out.= sql_error();
		$strSQL="
		CREATE TABLE " . $strDatabase . ".`calendar_event_characteristic` (
		`calendar_event_characteristic_id` int(11) NOT NULL auto_increment,
		`name` varchar(40) default NULL,
		PRIMARY KEY  (`calendar_event_characteristic_id`)
		);
		";
		$tables = $sql->query($strSQL);
		$out.= sql_error();
		$strSQL="
		CREATE TABLE " . $strDatabase . ".`calendar_event_type` (
		`calendar_event_type_id` int(11) NOT NULL auto_increment,
		`event_type_name` int(11) default NULL,
		PRIMARY KEY  (`calendar_event_type_id`)
		);
		";
		$tables = $sql->query($strSQL);
		$out.= sql_error();
		$strSQL="
		CREATE TABLE " . $strDatabase . ".`calendar_range` (
		`calendar_range_id` int(11) NOT NULL auto_increment,
		`name` varchar(50) default NULL,
		`description` text,
		`size_in_seconds` int(11) default NULL,
		`size_php_code` varchar(1) default NULL,
		`granules` int(11) default NULL,
		`granule_php_code` varchar(1) default NULL,
		PRIMARY KEY  (`calendar_range_id`)
		);
		";
		$tables = $sql->query($strSQL);
		$out.= sql_error();
		$strSQL="
		CREATE TABLE " . $strDatabase . ".`calendar_set` (
		`calendar_set_id` int(11) NOT NULL auto_increment,
		`name` varchar(50) default NULL,
		`range_in_seconds` int(11) default NULL,
		PRIMARY KEY  (`calendar_set_id`)
		);
		";
		$tables = $sql->query($strSQL);
		$out.= sql_error();
		$strSQL="
		CREATE TABLE " . $strDatabase . ".`calendar_set_map` (
		`calendar_set_map_id` int(11) NOT NULL auto_increment,
		`calendar_set_id` int(11) default NULL,
		`calendar_id` int(11) default NULL,
		`map_order` int(11) default NULL,
		PRIMARY KEY  (`calendar_set_map_id`)
		);
		";
		$tables = $sql->query($strSQL);
		$out.= sql_error();
		
		$out.= NewRelation($strDatabase, 'calendar', 'calendar_range_id', 'calendar_range', 'calendar_range_id');
		$out.= NewRelation($strDatabase, 'calendar_event','calendar_id','calendar','calendar_id');
		$out.= NewRelation($strDatabase, 'calendar_event','calendar_event_type_id','calendar_event_type','calendar_event_type_id');
		$out.= NewRelation($strDatabase, 'calendar_event','calendar_event_characteristic_id','calendar_event_characteristic','calendar_event_characteristic_id');
		$out.= NewRelation($strDatabase, 'calendar_event','foreign_id','calendar','foreign_table_name');
	 	$out.= NewRelation($strDatabase, 'calendar_set_map','calendar_set_id','calendar_set','calendar_set_id');
		$out.= NewRelation($strDatabase, 'calendar_set_map','calendar_id','calendar','calendar_id');
	return $out;
}
	
	
	
function MakeStatsTables($strDatabase)
{
	$out="";
	$out.=MakeTableIfNotThere($strDatabase, tfpre . "relation", "MakeRelationTables");
	$sql=conDB();
	$strSQL="
		CREATE TABLE " . $strDatabase . ".`website_hitday` (
		`website_hitday_id` int(11) NOT NULL auto_increment,
		`date` date default NULL,
		`count` int(11) default NULL,
		`page_id` int(11) default NULL,
		PRIMARY KEY  (`website_hitday_id`)
		);
		";
		$tables = $sql->query($strSQL);
		$out.= sql_error();
		$strSQL="
		CREATE TABLE " . $strDatabase . ".`website_hithour` (
		`website_hithour_id` int(11) NOT NULL auto_increment,
		`datetime` datetime default NULL,
		`count` int(11) default NULL,
		`page_id` int(11) default NULL,
		PRIMARY KEY  (`website_hithour_id`)
		);
		";
		$tables = $sql->query($strSQL);
		$out.= sql_error();
		$strSQL="
		CREATE TABLE " . $strDatabase . ".`website_referral` (
		`website_referral_id` int(11) NOT NULL auto_increment,
		`referral_url` varchar(222) default NULL,
		`count` int(11) default NULL,
		`page_id` int(11) default NULL,
		`datetime_created` datetime default NULL,
		`datetime_latest` datetime default NULL, 
		PRIMARY KEY  (`website_referal_id`)
		);
		";
		$tables = $sql->query($strSQL);
		$out.= sql_error();
		$out.= NewRelation($strDatabase,'website_referal','page_id','page','page_id');
		$out.= NewRelation($strDatabase,'website_hitday','page_id','page','page_id');
		$out.= NewRelation($strDatabase,'website_hithour','page_id','page','page_id');
	return $out;
}
		
function MakeAdTables($strDatabase)
{
	$out="";
	$out.=MakeTableIfNotThere($strDatabase, tfpre . "relation", "MakeRelationTables");
	$sql=conDB();
	$strSQL="
		CREATE TABLE " . $strDatabase . ".`ad` (
		`ad_id` int(11) NOT NULL auto_increment,
		`media_filename` varchar(88) default NULL,
		`ad_type_id` int(10) default NULL,
		`url` varchar(144) default NULL,
		`release_date` date default NULL,
		`expire_date` date default NULL,
		`hitcount` int(11) default NULL,
		PRIMARY KEY  (`ad_id`)
		);
		";
		$tables = $sql->query($strSQL);
		$out.= sql_error();
		$strSQL="
		CREATE TABLE " . $strDatabase . ".`ad_hit` (
		`ad_hit_id` int(11) NOT NULL auto_increment,
		`ad_id` int(11) default NULL,
		`referal_url` varchar(88) default NULL,
		`time` datetime default NULL,
		`hitcount` int(11) default NULL,
		PRIMARY KEY  (`ad_hit_id`)
		);
		";
		$tables = $sql->query($strSQL);
		$out.= sql_error();
		$strSQL="
		CREATE TABLE " . $strDatabase . ".`ad_location` (
		`ad_location_id` int(11) NOT NULL auto_increment,
		`name` varchar(33) default NULL,
		PRIMARY KEY  (`ad_location_id`)
		);
		";
		$tables = $sql->query($strSQL);
		$out.= sql_error();
		$strSQL="
		CREATE TABLE `ad_placement` (
		`ad_placement_id` int(11) NOT NULL auto_increment,
		`ad_id` int(11) default NULL,
		`ad_location_id` int(11) default NULL,
		PRIMARY KEY  (`ad_placement_id`)
		);
		";
		$tables = $sql->query($strSQL);
		$out.= sql_error();
		$strSQL="
		CREATE TABLE " . $strDatabase . ".`ad_type` (
		`ad_type_id` int(11) NOT NULL auto_increment,
		`type_name` varchar(88) default NULL,
		`width` int(11) default NULL,
		`height` int(11) default NULL,
		PRIMARY KEY  (`ad_type_id`)
		);
		";
		$tables = $sql->query($strSQL);
		$out.= sql_error();
		
		$out.= NewRelation($strDatabase,'ad_hit','ad_id','ad','ad_id');
		$out.= NewRelation($strDatabase,'ad_placement','ad_id','ad','ad_id');
		$out.= NewRelation($strDatabase,'ad_placement','ad_location_id','ad_location','ad_location_id');
		$out.= NewRelation($strDatabase,'ad','ad_type_id','ad_type','ad_type_id');
	return $out;
}
	
function MakePageTable($strDatabase)
{
	$sql=conDB();
	$strSQL="
		CREATE TABLE " . $strDatabase . ".`page` (
		`page_id` int(11) NOT NULL auto_increment,
		`page_name` varchar(50) default NULL,
		`text` text,
		`querystring` varchar(200) default NULL,
		`datetime_created` datetime default NULL, 
		PRIMARY KEY  (`page_id`)
		);
		";
		$tables = $sql->query($strSQL);
		$out= sql_error();
	return $out;
}

function MakeAdminTable($strDatabase)
{
	$sql=conDB();
	$strSQL="
		CREATE TABLE " . $strDatabase . "." .  tfpre . "admin (
		`admin_id` int(11) NOT NULL auto_increment,
		`username` varchar(44) default NULL,
		`password` varchar(44) default NULL,
		`is_superuser` tinyint(1) default NULL,
		`is_superadmin` tinyint(1) default NULL,
		`phone` varchar(44) default NULL,
		`email` varchar(30) default NULL,
		PRIMARY KEY  (`admin_id`)
		) 
		";
		$tables = $sql->query($strSQL);
		$out= sql_error();
	return $out;
}


function MakePermissionTables($strDatabase)
{
	$out="";
	$out=MakeTableIfNotThere($strDatabase, tfpre . "relation", "MakeRelationTables");
	$sql=conDB();
	$strSQL="
		CREATE TABLE " . $strDatabase . "." .  tfpre . "permission (
		`permission_id` int(11) NOT NULL auto_increment,
		`table_name` varchar(40) default NULL,
		`admin_id` int(11) default NULL,
		`permission_type_id` int(11) default NULL,
		`id_range_lowend` int(11) default NULL,
		`id_range_highend` int(11) default NULL,
		PRIMARY KEY  (`permission_id`)
		);
		";
		$tables = $sql->query($strSQL);
		$out.= sql_error();
		$strSQL="
		CREATE TABLE " . $strDatabase . "." .  tfpre . "permission_type (
		`permission_type_id` int(11) NOT NULL auto_increment,
		`name` varchar(40) default NULL,
		PRIMARY KEY  (`permission_type_id`)
		);
		";
		$tables = $sql->query($strSQL);
		$out.= sql_error();
		$out.= NewRelation($strDatabase,  tfpre . 'permission','admin_id', tfpre . 'admin','admin_id');
		$out.= NewRelation($strDatabase,  tfpre . 'permission','permission_type_id', tfpre . 'permission_type','permission_type_id');
		$out.= NewRelation($strDatabase,  tfpre . 'permission','admin_id', tfpre . 'admin','admin_id');
		$out.= NewRelation($strDatabase,  tfpre . 'permission','admin_id',  tfpre . 'admin','admin_id');
		$strSQL="INSERT INTO " . $strDatabase . "." .  tfpre . "permission_type (`permission_type_id`,`name`) VALUES (1,'read');";
		$tables = $sql->query($strSQL);
		$out.= sql_error();
		$strSQL="INSERT INTO " . $strDatabase . "." .  tfpre . "permission_type (`permission_type_id`,`name`) VALUES (2,'read/write');";
		$tables = $sql->query($strSQL);
		$out.= sql_error();
	return $out;
}

function MakeRelationTables($strDatabase)
{
	$sql=conDB();
	$strSQL="
		CREATE TABLE " . $strDatabase . "." .  tfpre . "relation (
		`relation_id` int(11) NOT NULL auto_increment,
		`table_name` varchar(44) default NULL,
		`display_column_name` varchar(44) default NULL,
		`column_name` varchar(44) default NULL,
		`f_table_name` varchar(44) default NULL,
		`f_column_name` varchar(44) default NULL,
		`relation_type_id` int(11) default NULL,
		`narrowing_conditions` varchar(250) default NULL,
		`tool_guidance_id` int(11) default NULL,
		PRIMARY KEY  (`relation_id`)
		);
		";
		$tables = $sql->query($strSQL);
		$out= sql_error();
		$strSQL="
		CREATE TABLE " . $strDatabase . "." .  tfpre . "relation_type (
		  `relation_type_id` int(11) NOT NULL default '0',
		  `name` varchar(40) default NULL,
		  PRIMARY KEY  (`relation_type_id`)
		);
		";
		$tables = $sql->query($strSQL);
		$out.= sql_error();
		$strSQL="
		CREATE TABLE " . $strDatabase . "." .  tfpre . "tool_guidance (
		`tool_guidance_id` int(11) NOT NULL auto_increment,
		`guidance_name` varchar(50) default NULL,
		PRIMARY KEY (`tool_guidance_id`)
		);
		";
		$tables = $sql->query($strSQL);
		$out= sql_error();

		$out.= NewRelation($strDatabase, tfpre . 'relation','relation_type_id',tfpre .'relation_type','relation_type_id');
		$out.= NewRelation($strDatabase, tfpre . 'relation','tool_guidance_id',tfpre .'tool_guidance','tool_guidance_id');
		$strSQL="INSERT INTO " . $strDatabase . "." .  tfpre . "relation_type (`relation_type_id`,`name`) VALUES (0,'foreign-key relation');";
		$tables = $sql->query($strSQL);
		$out.= sql_error();
		$strSQL="INSERT INTO " . $strDatabase . "." .  tfpre . "relation_type (`relation_type_id`,`name`) VALUES (1,'multi-table relation');";
		$tables = $sql->query($strSQL);
		$out.= sql_error();
		$strSQL="INSERT INTO   " . $strDatabase . "." .  tfpre . "relation_type (`relation_type_id`,`name`) VALUES (2,'default relation');";
		$tables = $sql->query($strSQL);
		$out.= sql_error();
		$strSQL="INSERT INTO " . $strDatabase . "." .  tfpre . "relation_type (`relation_type_id`,`name`) VALUES (3,'pseudo-field relation');";
		$tables = $sql->query($strSQL);
		$out.= sql_error();
		$strSQL="INSERT INTO " . $strDatabase . "." .  tfpre . "tool_guidance (`tool_guidance_id`,`guidance_name`) VALUES (1,'remote table checkboxes on f_table\'s editor');";
		$tables = $sql->query($strSQL);
		$out.= sql_error();
	return $out;
}

function MakeBrowseSchemeTable($strDatabase)
{
	$out="";
	$out.=MakeTableIfNotThere($strDatabase, tfpre . "column_info", "MakeColumnInfoTables");
	$out.=MakeTableIfNotThere($strDatabase, tfpre . "relation", "MakeRelationTables");
	$sql=conDB();
	$strSQL="
		CREATE TABLE " . $strDatabase . "." .  tfpre . "browsescheme (
		`browsescheme_id` int(11) NOT NULL auto_increment,
		`table_name` varchar(50) default NULL,
		`browsetype_id` int(11) default NULL,
		`label_field` varchar(50) default NULL,
		`quantity_field_x` varchar(50) default NULL,
		`quantity_field_y` varchar(50) default NULL,
		`quantity_field_z` varchar(50) default NULL,
		`filter_field` varchar(50) default NULL,
		`graphic_field` varchar(50) default NULL,
		`toolpage` varchar(20) default NULL,
		`integration_label` varchar(30) default NULL,
		`display_field_list` text default NULL,
		PRIMARY KEY  (`browsescheme_id`)
		);
		";
		$tables = $sql->query($strSQL);
		$out.= sql_error();
		$strSQL="
		CREATE TABLE " . $strDatabase . "." .  tfpre . "browsetype (
		`browsetype_id` int(11) NOT NULL auto_increment,
		`name` varchar(77) default NULL,
		PRIMARY KEY  (`browsetype_id`)
		);
		";
		$tables = $sql->query($strSQL);
		$out.= sql_error();
		$out.= NewRelation($strDatabase, tfpre . 'column_info','browsetype_id',tfpre .'browsetype','browsetype_id');
	return $out;
}


function MakeScriptLogTable($strDatabase)
{
	$sql=conDB();
	$out="";
	$strSQL="

		CREATE TABLE " . $strDatabase . "." .  tfpre . "scriptlog (
		`scriptlog_id` int(11) NOT NULL auto_increment,
		`pre_script` text,
		`post_script` text,
		`type` varchar(10),
		`time_executed` timestamp NOT NULL,
		PRIMARY KEY (`scriptlog_id`)
	)  ";
	$tables = $sql->query($strSQL);
	$out.= sql_error();
	return $out;
}

function MakePHPFunctionTables($strDatabase)
{
	$sql=conDB();
	$out="";
	$out.=MakeTableIfNotThere($strDatabase, tfpre . "relation", "MakeRelationTables");
	$strSQL="

		CREATE TABLE " . $strDatabase . "." .  tfpre . "php_function (
		`function_id` int(11) NOT NULL auto_increment,
		`function_name` varchar(60),
		`page_path` varchar(120),
		`linecount` int(11),
		`function_body` text,
		PRIMARY KEY (`function_id`)
	)  ";
	$tables = $sql->query($strSQL);
	$out.= sql_error();
	$strSQL="
		CREATE TABLE " . $strDatabase . "." .  tfpre . "php_function_param (
		`param_id` int(11) NOT NULL auto_increment,
		`function_id` int(11),
		`param_name` varchar(60),
		`param_default` varchar(120),
		PRIMARY KEY (`param_id`)
	)  ";
	$tables = $sql->query($strSQL);
	$out.= sql_error();
	$strSQL="
		CREATE TABLE " . $strDatabase . "." .  tfpre . "php_function_reference (
		`caller_function_id` int(11),
		`called_function_id` int(11),
		`callcount` int(11),
		PRIMARY KEY (caller_function_id, called_function_id)
	)  ";
	$tables = $sql->query($strSQL);
	$out.= sql_error();
	$out.= NewRelation($strDatabase, tfpre . 'php_function_param','function_id',tfpre .'php_function','function_id');
	$out.= NewRelation($strDatabase, tfpre . 'php_function_reference','caller_function_id',tfpre .'php_function','function_id');
	$out.= NewRelation($strDatabase, tfpre . 'php_function_reference','called_function_id',tfpre .'php_function','function_id');
	return $out;
}

function MakeDBMapTables($strDatabase)
{
	$sql=conDB();
	$out="";
	$out.=MakeTableIfNotThere($strDatabase, tfpre . "relation", "MakeRelationTables");
	$strSQL="
		CREATE TABLE " . $strDatabase . "." .  tfpre . "dbmap (
		`dbmap_id` int(11) NOT NULL auto_increment,
		`map_name` varchar(60),
		timecreated timestamp NOT NULL,
		PRIMARY KEY (`dbmap_id`)
	)  ";
	$tables = $sql->query($strSQL);
	$out.= sql_error();
	$strSQL="
		CREATE TABLE " . $strDatabase . "." .  tfpre . "dbmap_table (
		`table_name` varchar(44),
		`dbmap_id` int(11),
		`top` int(11),
		`left` int(11),
		PRIMARY KEY (table_name, dbmap_id)
	)  ";
	$tables = $sql->query($strSQL);
	$out.= sql_error();
	$out.= NewRelation($strDatabase, tfpre . 'dbmap_table','dbmap_id',tfpre .'dbmap','dbmap_id');
	return $out;
}

function MakeConcordanceTables($strDatabase)
{
	$sql=conDB();
	$out="";
	$out.=MakeTableIfNotThere($strDatabase, tfpre . "relation", "MakeRelationTables");
	$strSQL="
		CREATE TABLE " . $strDatabase . "." .  tfpre . "concordance (
		`concordance_id` int(11) NOT NULL auto_increment,
		`table_name_source` varchar(44),
		`column_source_1` varchar(44),
		`column_source_2` varchar(44),
		`column_for_read` varchar(44),
		`table_name_dest` varchar(44),
		`column_dest_1` varchar(44),
		`column_dest_2` varchar(44),
		`column_for_write` varchar(44),
		timecreated timestamp NOT NULL,
		PRIMARY KEY (`concordance_id`)
	)  ";
	$tables = $sql->query($strSQL);
	$out.= sql_error();
	$strSQL="
	CREATE TABLE " . $strDatabase . "." .  tfpre . "concordance_hit (
		`concordance_hit_id` int(11) NOT NULL auto_increment,
		`concordance_id` int(11),
		`table_source_pk` varchar(44),
		`table_dest_pk` varchar(44),
		`field1_content` varchar(44),
		`field2_content` varchar(44),
		`readfield_content` varchar(44),
		`source_matchcount` int(11),
		`dest_matchcount` int(11),
		`fieldtowrite_content` varchar(44),
		PRIMARY KEY (`concordance_hit_id`)
	)  ";
	$tables = $sql->query($strSQL);
	$out.= sql_error();
	$out.= NewRelation($strDatabase, tfpre . 'concordance_hit','concordance_id',tfpre .'concordance','concordance_id');
	return $out;
}
	
function MakeTableIfNotThere($strDatabase, $strTable, $strMakeFunction)
//calls $strMakeFunction if $strTable does not exist in $strDatabase
{
	if(!TableExists($strDatabase, $strTable))
	{
		$out=call_user_func($strMakeFunction, $strDatabase);
	}
	return $out;
}


?>