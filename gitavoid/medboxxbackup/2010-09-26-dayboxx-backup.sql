

CREATE TABLE `calendar` (
  `calendar_id` int(4) NOT NULL auto_increment,
  `calendar_name` varchar(50) default NULL,
  `description` text,
  `foreign_table_name` varchar(30) default NULL,
  `calendar_range_id` int(4) default NULL,
  `code` varchar(80) default NULL,
  PRIMARY KEY  (`calendar_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;



INSERT INTO dayboxx.calendar(`calendar_id`,`calendar_name`,`description`,`foreign_table_name`,`calendar_range_id`,`code`) VALUES('1','mascker voopp','moo','calendar','0','');
INSERT INTO dayboxx.calendar(`calendar_id`,`calendar_name`,`description`,`foreign_table_name`,`calendar_range_id`,`code`) VALUES('2','mascker voopp merkle','moo spabk','calendar','0','');
INSERT INTO dayboxx.calendar(`calendar_id`,`calendar_name`,`description`,`foreign_table_name`,`calendar_range_id`,`code`) VALUES('3','ssds','sdasdasd','','0','');
INSERT INTO dayboxx.calendar(`calendar_id`,`calendar_name`,`description`,`foreign_table_name`,`calendar_range_id`,`code`) VALUES('4','erterter','','','0','');
INSERT INTO dayboxx.calendar(`calendar_id`,`calendar_name`,`description`,`foreign_table_name`,`calendar_range_id`,`code`) VALUES('5','456546 4','','','0','');
INSERT INTO dayboxx.calendar(`calendar_id`,`calendar_name`,`description`,`foreign_table_name`,`calendar_range_id`,`code`) VALUES('6','werwer we','','','0','');
INSERT INTO dayboxx.calendar(`calendar_id`,`calendar_name`,`description`,`foreign_table_name`,`calendar_range_id`,`code`) VALUES('7','r werwerwe','','','0','');
INSERT INTO dayboxx.calendar(`calendar_id`,`calendar_name`,`description`,`foreign_table_name`,`calendar_range_id`,`code`) VALUES('8','r werwerwe','','','0','');


CREATE TABLE `calendar_event` (
  `calendar_event_id` int(4) NOT NULL auto_increment,
  `calendar_id` int(4) default NULL,
  `notes` text,
  `start` datetime default NULL,
  `end` datetime default NULL,
  `foreign_id` int(4) default NULL,
  `calendar_event_type_id` int(4) default NULL,
  `calendar_event_characteristic_id` int(4) default NULL,
  `event_name` varchar(60) default NULL,
  PRIMARY KEY  (`calendar_event_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;





CREATE TABLE `calendar_event_characteristic` (
  `calendar_event_characteristic_id` int(4) NOT NULL auto_increment,
  `name` varchar(40) default NULL,
  PRIMARY KEY  (`calendar_event_characteristic_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;





CREATE TABLE `calendar_event_type` (
  `calendar_event_type_id` int(4) NOT NULL auto_increment,
  `event_type_name` int(4) default NULL,
  PRIMARY KEY  (`calendar_event_type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;





CREATE TABLE `calendar_range` (
  `calendar_range_id` int(4) NOT NULL auto_increment,
  `name` varchar(50) default NULL,
  `description` text,
  `size_in_seconds` int(4) default NULL,
  `size_php_code` char(1) default NULL,
  `granules` int(4) default NULL,
  `granule_php_code` char(1) default NULL,
  PRIMARY KEY  (`calendar_range_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;





CREATE TABLE `calendar_set` (
  `calendar_set_id` int(4) NOT NULL auto_increment,
  `name` varchar(50) default NULL,
  `range_in_seconds` int(4) default NULL,
  PRIMARY KEY  (`calendar_set_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;





CREATE TABLE `calendar_set_map` (
  `calendar_set_map_id` int(4) NOT NULL auto_increment,
  `calendar_set_id` int(4) default NULL,
  `calendar_id` int(4) default NULL,
  `map_order` int(4) default NULL,
  PRIMARY KEY  (`calendar_set_map_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;





CREATE TABLE `call_type` (
  `call_type_id` int(11) NOT NULL auto_increment,
  `description` varchar(80) default NULL,
  `attempt_frequency` int(11) default NULL,
  `attempt_window_length` int(11) default NULL,
  `local_call_time_span` varchar(50) default NULL,
  PRIMARY KEY  (`call_type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;



INSERT INTO dayboxx.call_type(`call_type_id`,`description`,`attempt_frequency`,`attempt_window_length`,`local_call_time_span`) VALUES('1','nine to five all days','1','999','15:00-23:00');
INSERT INTO dayboxx.call_type(`call_type_id`,`description`,`attempt_frequency`,`attempt_window_length`,`local_call_time_span`) VALUES('2','ten to five all days','360','1','10:00-17:00');
INSERT INTO dayboxx.call_type(`call_type_id`,`description`,`attempt_frequency`,`attempt_window_length`,`local_call_time_span`) VALUES('3','five to six all days','360','1','17:00-18:00');
INSERT INTO dayboxx.call_type(`call_type_id`,`description`,`attempt_frequency`,`attempt_window_length`,`local_call_time_span`) VALUES('4','testing','30','1','01:00-23:00');


CREATE TABLE `client` (
  `client_id` int(11) NOT NULL auto_increment,
  `login_id` int(11) default NULL,
  `guardian_client_id` int(11) default NULL,
  `name_of_guardian` varchar(111) default NULL,
  `firstname` varchar(50) default NULL,
  `lastname` varchar(50) default NULL,
  `client_type_id` int(11) default NULL,
  `birthday` date default NULL,
  `address` varchar(50) default NULL,
  `city` varchar(50) default NULL,
  `state_code` varchar(3) default NULL,
  `zip` varchar(20) default NULL,
  `email` varchar(50) default NULL,
  `phone` varchar(50) default NULL,
  `cellphone` varchar(50) default NULL,
  `business_phone` varchar(50) default NULL,
  `business_address` varchar(50) default NULL,
  `business_state_code` varchar(50) default NULL,
  `business_zip` varchar(10) default NULL,
  `social_security_number` varchar(50) default NULL,
  `insurance1_type_id` int(11) default NULL,
  `insurance1` varchar(50) default NULL,
  `insurance1_number` varchar(50) default NULL,
  `insurance2_type_id` int(11) default NULL,
  `insurance2` varchar(50) default NULL,
  `insurance2_number` varchar(50) default NULL,
  `referred_by` varchar(50) default NULL,
  `why_visiting` text,
  `employed_by` varchar(50) default NULL,
  `marital_status` int(11) default NULL,
  `emergency_contact_name` varchar(60) default NULL,
  `emergency_phone` varchar(50) default NULL,
  `emergency_cellphone` varchar(50) default NULL,
  `is_active` tinyint(1) default NULL,
  `date_created` datetime default NULL,
  `date_lastvisited` datetime default NULL,
  PRIMARY KEY  (`client_id`)
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;



INSERT INTO dayboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('16','20','12','','Bonnie','Treadweller','','0000-00-00','122 Silver Parkway','Richardville','MA','00221','foop@pool.com','','','','','','','','0','','','0','','','','','','0','asdasd','','','1','2010-05-02 14:16:34','2010-05-02 14:16:34');
INSERT INTO dayboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('15','19','0','','Fonda','Petapsco','','0000-00-00','122 Silver Parkway','Richardville','MA','00221','foop@pool.com','','','','','','','','0','','','0','','','','','','0','asdasd','','','1','2010-05-02 14:16:34','2010-05-02 14:16:34');
INSERT INTO dayboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('14','18','0','','Jill','Smithers','','0000-00-00','122 Silver Parkway','Richardville','MA','00221','foop@pool.com','','','','','','','','0','','','0','','','','','','0','asdasd','','','1','2010-05-02 14:16:34','2010-05-02 14:16:34');
INSERT INTO dayboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('13','17','0','','Henry','Moffat','','0000-00-00','122 Silver Parkway','Richardville','MA','00221','foop@pool.com','','','','','','','','0','','','0','','','','','','0','asdasd','','','1','2010-05-02 14:16:34','2010-05-02 14:16:34');
INSERT INTO dayboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('9','15','0','','George','McFargush','','1963-01-08','77 East Turncoat Lane','Hollywood','CA','97142','goop@asecular.com','4443334433','','','','','','','0','','','0','','','','','','0','sfsdfsdfdsf','','','1','2010-05-02 11:22:53','2010-05-02 11:22:53');
INSERT INTO dayboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('12','16','0','','Reginald','Treadweller','','0000-00-00','122 Silver Parkway','Richardville','MA','00221','foop@pool.com','','','','','','','','0','','','0','','','','','','0','asdasd','','','1','2010-05-02 14:16:34','2010-05-02 14:16:34');
INSERT INTO dayboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('17','0','0','','Valerie','Peters','','1966-03-04','22 Munich Heights Bypass','Flinders','WV','29112','','','','','','','','','0','','','0','','','','','','0','','','','1','0000-00-00 00:00:00','0000-00-00 00:00:00');
INSERT INTO dayboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('18','0','12','','Sybil','Treadweller','','1989-02-06','422 Silver Parkway','Richardville','MA','00221','','','','','','','','','0','','','0','','','','','','0','','','','1','0000-00-00 00:00:00','0000-00-00 00:00:00');
INSERT INTO dayboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('19','24','0','','anita','hayes','','0000-00-00','Feakle','Co. Clare','','','','','','','','','','','0','','','0','','','','','','0','','','','1','2010-05-10 12:17:58','2010-05-10 12:17:58');
INSERT INTO dayboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('20','0','0','','Tom','','','1999-11-30','','','','','','','','','','','','','0','','','0','','','','','','0','','','','1','1970-01-01 00:00:00','1970-01-01 00:00:00');
INSERT INTO dayboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('21','0','0','','Thomas','Hayes','','1953-11-26','Magherabaun','Feakle  Co. Clare, Ireland','','','tommyhaye@gmail.com','0876236292','','','','','','','0','','','0','','','','','','0','','','','1','1970-01-01 00:00:00','1970-01-01 00:00:00');
INSERT INTO dayboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('22','0','0','','tommy ','hayes','','0000-00-00','','','','','','','','','','','','','0','','','0','','','','','','0','','','','1','0000-00-00 00:00:00','0000-00-00 00:00:00');
INSERT INTO dayboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('23','0','0','','Randall','Walker','','1999-11-30','','','','','','','','','','','','','0','','','0','','','','','','0','','','','1','1970-01-01 00:00:00','1970-01-01 00:00:00');
INSERT INTO dayboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('24','0','0','','Laura','Powell','','0000-00-00','','','','','','','','','','','','','0','','','0','','','','','','0','','','','1','0000-00-00 00:00:00','0000-00-00 00:00:00');
INSERT INTO dayboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('25','0','0','','isaac','hayes','','0000-00-00','','','','','','','','','','','','','0','','','0','','','','','','0','','','','1','0000-00-00 00:00:00','0000-00-00 00:00:00');
INSERT INTO dayboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('26','0','0','','Fredrick','Ulster','','1933-02-03','122 Silver Parkway','Silverton','FL','22112','','','','','','','','','0','','','0','','','','','','0','','','','1','0000-00-00 00:00:00','0000-00-00 00:00:00');
INSERT INTO dayboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('27','0','0','','Manrick','Ulster','','1933-02-03','122 Silver Parkway','Silverton','FL','22112','','','','','','','','','0','','','0','','','','','','0','','','','1','0000-00-00 00:00:00','0000-00-00 00:00:00');
INSERT INTO dayboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('28','0','0','','Jebbediah','Ecols','','1933-02-03','122 Silver Parkway','Silverton','FL','22112','','','','','','','','','0','','','0','','','','','','0','','','','1','1970-01-01 00:00:00','1970-01-01 00:00:00');
INSERT INTO dayboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('29','0','0','','banrick','Ulster','','1933-02-03','122 Silver Parkway','Silverton','FL','22112','','','','','','','','','0','','','0','','','','','','0','','','','1','0000-00-00 00:00:00','0000-00-00 00:00:00');
INSERT INTO dayboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('30','0','0','','Vanrick','Ulster','','1933-02-03','122 Silver Parkway','Silverton','FL','22112','','','','','','','','','0','','','0','','','','','','0','','','','1','0000-00-00 00:00:00','0000-00-00 00:00:00');
INSERT INTO dayboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('31','0','0','','Vanrick','Ulster','','1933-02-03','122 Silver Parkway','Silverton','FL','22112','','','','','','','','','0','','','0','','','','','','0','','','','1','0000-00-00 00:00:00','0000-00-00 00:00:00');
INSERT INTO dayboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('32','0','0','','Joeseph','Hayes','','1999-11-30','','','','','','','','','','','','','0','','','0','','','','','','0','','','','1','1970-01-01 00:00:00','1970-01-01 00:00:00');
INSERT INTO dayboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('33','0','0','','Gioseppe','Hayes','','1999-11-30','','','','','','','','','','','','','0','','','0','','','','','','0','','','','1','1970-01-01 00:00:00','1970-01-01 00:00:00');
INSERT INTO dayboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('34','0','0','','JoJo','Hayes','','1999-11-30','','','','','','','','','','','','','0','','','0','','','','','','0','','','','1','1970-01-01 00:00:00','1970-01-01 00:00:00');
INSERT INTO dayboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('35','','','','Don ','Dom','','0000-00-00','','','','','','','917 650 4575','','','','','','','','','','','','','','','','','','','1','','');
INSERT INTO dayboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('36','','','','Jammyboy','Quinkler','','1971-02-04','','','','','denniso2323@gmail.com','9176504575','','','','','','','','','','','','','','','','','','','','1','','');
INSERT INTO dayboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('37','','','','Laura','Powell','','0000-00-00','','','','','lclar210@yahoo.com','8452465599','','','','','','','','','','','','','','','','','','','','1','','');
INSERT INTO dayboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('38','45','','qevgsjpqe','qevgsjpqe','qevgsjpqe','','','UKzHLFmmVqO','','WV','44826','jknslzsvmoik.com','93055103132','','YvrAkoaYCYthb','MmnyGOOtGGZxGkFYd','KY','oyJIhApueo','http://aexlnmpvqdxr.com/','2','http://aexlnmpvqdxr.com/','http://aexlnmpvqdxr.com/','2','jknslz@svmoik.com','jknslz@svmoik.com','BecFwgJqcAjCiEtV','Nk7F5z  <a href="http://rggvpqbgzefq.com/">rggvpqbgzefq</a>, [url=http://regljoidbagu.com/]regljoidbagu[/url], [link=http://ynmbbdcrjvsy.com/]ynmbbdcrjvsy[/link], http://lynalngvcqzo.com/','jknslz@svmoik.com','','jknslz@svmoik.com','','','1','2010-09-10 02:23:55','2010-09-10 02:23:55');
INSERT INTO dayboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('39','46','','kemofu','kemofu','kemofu','','','lsIKRYJIKqlLF','','OH','11780','izjfuluogyov.com','58155403855','','LDBcxuoiFDKN','NndPRTYbnSocXriFLw','AR','UhcaaToDHq','http://tzmtlrepmbuv.com/','2','http://tzmtlrepmbuv.com/','http://tzmtlrepmbuv.com/','2','izjful@uogyov.com','izjful@uogyov.com','dBqXMunVHCsrWF','1VmXs0  <a href="http://vganbogmxtot.com/">vganbogmxtot</a>, [url=http://orakfiysvzgq.com/]orakfiysvzgq[/url], [link=http://hgcxnpaphymw.com/]hgcxnpaphymw[/link], http://tfsizrzliqfx.com/','izjful@uogyov.com','','izjful@uogyov.com','','','1','2010-09-12 04:48:22','2010-09-12 04:48:22');
INSERT INTO dayboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('40','47','','ojipizl','ojipizl','ojipizl','','','RsxQhltvagpXGntYcy','','RI','15634','ssztphfgblzb.com','41491288376','','tCwoJZkFQeDVU','nzyKzEXzAlmNqX','CA','PmbScSqaYA','http://wxdjdoawzjra.com/','2','http://wxdjdoawzjra.com/','http://wxdjdoawzjra.com/','3','ssztph@fgblzb.com','ssztph@fgblzb.com','okRylUkmwh','aGvunD  <a href="http://qqoxbbgfdynh.com/">qqoxbbgfdynh</a>, [url=http://iaekzhwgkvtu.com/]iaekzhwgkvtu[/url], [link=http://kcighzpxqfcw.com/]kcighzpxqfcw[/link], http://qihfopcjmmgn.com/','ssztph@fgblzb.com','','ssztph@fgblzb.com','','','1','2010-09-12 18:49:28','2010-09-12 18:49:28');
INSERT INTO dayboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('41','48','','jlicyssrmf','jlicyssrmf','jlicyssrmf','','','oBYMICvQuj','','WY','46027','eobxslwoebzx.com','82206859798','','AjkTGwbsDuUGDMig','qNwdChrIGCwkClZq','AR','zuMqokzUau','http://snvensjuipzn.com/','3','http://snvensjuipzn.com/','http://snvensjuipzn.com/','3','eobxsl@woebzx.com','eobxsl@woebzx.com','TAPDiyfTMUtFelIKa','Lw4NRr  <a href="http://oxcoomjdlmlr.com/">oxcoomjdlmlr</a>, [url=http://yphzdshvyyre.com/]yphzdshvyyre[/url], [link=http://epzatzgjkrfl.com/]epzatzgjkrfl[/link], http://lyxgjmiycvew.com/','eobxsl@woebzx.com','','eobxsl@woebzx.com','','','1','2010-09-12 18:49:28','2010-09-12 18:49:28');
INSERT INTO dayboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('42','49','','kzidfwjh','kzidfwjh','kzidfwjh','','','zlYjLpnrFMPn','','IN','79403','knvciufwznvx.com','40646250494','','VgVepeKvSOqsuSahKw','gdOQAPHDbeL','HI','eLOtjOZuyr','http://sdwlwshihomd.com/','3','http://sdwlwshihomd.com/','http://sdwlwshihomd.com/','2','knvciu@fwznvx.com','knvciu@fwznvx.com','bDsNmHKWZcshHj','Ivs0Yl  <a href="http://nuygeafosmwu.com/">nuygeafosmwu</a>, [url=http://xaqaarfzzxrq.com/]xaqaarfzzxrq[/url], [link=http://totqbvillyvl.com/]totqbvillyvl[/link], http://glppuaiuqmsm.com/','knvciu@fwznvx.com','','knvciu@fwznvx.com','','','1','2010-09-14 01:20:16','2010-09-14 01:20:16');
INSERT INTO dayboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('43','50','','qsdkyjroec','qsdkyjroec','qsdkyjroec','','','JmJuORYdHRcIIhllZ','','PR','98891','zbyfdzyqrszi.com','73522916207','','JjqfPMLlWry','LUXWYoDxQO','PE','cjkPFoOrMq','http://vauagpxtifdi.com/','2','http://vauagpxtifdi.com/','http://vauagpxtifdi.com/','2','zbyfdz@yqrszi.com','zbyfdz@yqrszi.com','djHatBIJjT','RNEBC6  <a href="http://pbyofculcfnl.com/">pbyofculcfnl</a>, [url=http://rdpgrizesiiw.com/]rdpgrizesiiw[/url], [link=http://ygxvcgbvnumr.com/]ygxvcgbvnumr[/link], http://ubeokyuwuwnj.com/','zbyfdz@yqrszi.com','','zbyfdz@yqrszi.com','','','1','2010-09-14 06:06:43','2010-09-14 06:06:43');
INSERT INTO dayboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('44','51','','biuzosafskj','biuzosafskj','biuzosafskj','','','nVGofswBUFvbZDKIT','','RI','62930','rdklapaahnzv.com','87222826626','','vZNFgrHWten','qLVnWnTYdZzWholvM','MA','bWMuFUjVna','http://uizcxdxntpit.com/','2','http://uizcxdxntpit.com/','http://uizcxdxntpit.com/','3','rdklap@aahnzv.com','rdklap@aahnzv.com','mIXKCNRiIl','kpU1A4  <a href="http://sncfjqsnqamv.com/">sncfjqsnqamv</a>, [url=http://forknrnnsjkg.com/]forknrnnsjkg[/url], [link=http://xrqatwsvaeer.com/]xrqatwsvaeer[/link], http://vbeelclfooov.com/','rdklap@aahnzv.com','','rdklap@aahnzv.com','','','1','2010-09-14 06:06:42','2010-09-14 06:06:42');
INSERT INTO dayboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('45','52','','peiewomluy','peiewomluy','peiewomluy','','','yfgqfxyYpreEc','','MN','45333','eoiapusctkwk.com','36116872499','','SiNegFlhvXSjg','wRbTMyDSnCKR','SC','PTSMhWNEcv','http://yadatgvzcwtu.com/','2','http://yadatgvzcwtu.com/','http://yadatgvzcwtu.com/','2','eoiapu@sctkwk.com','eoiapu@sctkwk.com','uSlgklsPuZRUytRnV','O2OB5T  <a href="http://pbsctptfjhra.com/">pbsctptfjhra</a>, [url=http://xstoswntkjse.com/]xstoswntkjse[/url], [link=http://mllkphmlikzn.com/]mllkphmlikzn[/link], http://gbcfpwxgztib.com/','eoiapu@sctkwk.com','','eoiapu@sctkwk.com','','','1','2010-09-15 20:35:45','2010-09-15 20:35:45');
INSERT INTO dayboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('46','53','','nncqlqsrize','nncqlqsrize','nncqlqsrize','','','rxSnXiBqiOvwhQLPzio','','KY','62009','hiouxqucxlxa.com','24560024080','','ErmKIGUqdgrP','cjRCWEsoLclERybHrK','MT','mbhXwxBAzO','http://jooorstavgih.com/','3','http://jooorstavgih.com/','http://jooorstavgih.com/','2','hiouxq@ucxlxa.com','hiouxq@ucxlxa.com','YudPoljKFONWMGuWHoL','QFZVrw  <a href="http://pjulirkizqpr.com/">pjulirkizqpr</a>, [url=http://tohlawdjrpri.com/]tohlawdjrpri[/url], [link=http://umhklbvurske.com/]umhklbvurske[/link], http://zkdohgefixdr.com/','hiouxq@ucxlxa.com','','hiouxq@ucxlxa.com','','','1','2010-09-22 09:23:51','2010-09-22 09:23:51');
INSERT INTO dayboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('47','54','','nncqlqsrize','nncqlqsrize','nncqlqsrize','','','rxSnXiBqiOvwhQLPzio','','KY','62009','hiouxqucxlxa.com','24560024080','','ErmKIGUqdgrP','cjRCWEsoLclERybHrK','MT','mbhXwxBAzO','http://jooorstavgih.com/','3','http://jooorstavgih.com/','http://jooorstavgih.com/','2','hiouxq@ucxlxa.com','hiouxq@ucxlxa.com','YudPoljKFONWMGuWHoL','QFZVrw  <a href="http://pjulirkizqpr.com/">pjulirkizqpr</a>, [url=http://tohlawdjrpri.com/]tohlawdjrpri[/url], [link=http://umhklbvurske.com/]umhklbvurske[/link], http://zkdohgefixdr.com/','hiouxq@ucxlxa.com','','hiouxq@ucxlxa.com','','','1','2010-09-22 09:23:51','2010-09-22 09:23:51');


CREATE TABLE `client_office_map` (
  `office_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  PRIMARY KEY  (`office_id`,`client_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('0','0');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('0','34');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('0','35');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('0','37');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('1','0');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('1','7');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('1','8');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('1','9');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('1','10');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('1','11');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('1','12');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('1','13');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('1','14');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('1','15');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('1','16');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('1','17');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('1','18');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('1','19');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('1','20');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('1','21');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('1','23');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('1','24');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('1','26');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('1','27');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('1','28');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('1','30');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('1','31');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('1','38');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('1','39');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('1','40');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('1','43');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('1','44');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('1','45');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('1','56');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('1','57');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('1','58');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('5','32');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('5','33');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('5','34');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('6','31');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('7','21');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('9','35');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('23','20');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('23','22');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('23','25');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('24','36');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('24','37');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('26','26');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('26','27');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('26','28');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('26','29');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('52','53');
INSERT INTO dayboxx.client_office_map(`office_id`,`client_id`) VALUES('52','54');


CREATE TABLE `client_type` (
  `client_type_id` int(11) NOT NULL auto_increment,
  `client_description` varchar(122) default NULL,
  PRIMARY KEY  (`client_type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;



INSERT INTO dayboxx.client_type(`client_type_id`,`client_description`) VALUES('1',' ');
INSERT INTO dayboxx.client_type(`client_type_id`,`client_description`) VALUES('2','dog');
INSERT INTO dayboxx.client_type(`client_type_id`,`client_description`) VALUES('3','cat');
INSERT INTO dayboxx.client_type(`client_type_id`,`client_description`) VALUES('4','snake');
INSERT INTO dayboxx.client_type(`client_type_id`,`client_description`) VALUES('5','bird');
INSERT INTO dayboxx.client_type(`client_type_id`,`client_description`) VALUES('6','turtle');
INSERT INTO dayboxx.client_type(`client_type_id`,`client_description`) VALUES('7','lizard');
INSERT INTO dayboxx.client_type(`client_type_id`,`client_description`) VALUES('8','ferret');
INSERT INTO dayboxx.client_type(`client_type_id`,`client_description`) VALUES('9','horse');
INSERT INTO dayboxx.client_type(`client_type_id`,`client_description`) VALUES('10','pig');
INSERT INTO dayboxx.client_type(`client_type_id`,`client_description`) VALUES('11','other farm animal');
INSERT INTO dayboxx.client_type(`client_type_id`,`client_description`) VALUES('12','other rodent');
INSERT INTO dayboxx.client_type(`client_type_id`,`client_description`) VALUES('13','other mammal');
INSERT INTO dayboxx.client_type(`client_type_id`,`client_description`) VALUES('14','other reptile');
INSERT INTO dayboxx.client_type(`client_type_id`,`client_description`) VALUES('15','invertebrate');
INSERT INTO dayboxx.client_type(`client_type_id`,`client_description`) VALUES('16','other organism');


CREATE TABLE `content` (
  `content_id` int(11) NOT NULL auto_increment,
  `name` varchar(50) default NULL,
  `content` text,
  `icon_filename` varchar(50) default NULL,
  PRIMARY KEY  (`content_id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;



INSERT INTO dayboxx.content(`content_id`,`name`,`content`,`icon_filename`) VALUES('1','termsofuse',' DAYBOXX.COM TERMS OF USE


1. ACCEPTANCE OF TERMS

DAYBOXX.COM provides a collection of online and offline services &#40;referred to hereafter as "the 
Service"&#41; subject to the following Terms of Use &#40;"TOU"&#41;. By using the Service 
in any way, you are agreeing to comply with the TOU. In addition, when using 
particular DAYBOXX.COM services, you agree to abide by any applicable posted 
guidelines for all DAYBOXX.COM services, which may change from time to time.  
Should you object to any term or condition of the TOU, any guidelines, 
or any subsequent modifications thereto or become dissatisfied with DAYBOXX.COM 
in any way, your only recourse is to immediately discontinue use of DAYBOXX.COM.  
DAYBOXX.COM has the right, but is not obligated, to strictly enforce the TOU 
through self-help, community moderation, active investigation, litigation and 
prosecution.


2. MODIFICATIONS TO THIS AGREEMENT

We reserve the right, at our sole discretion, to change, modify or otherwise 
alter these terms and conditions at any time.  Such modifications shall become 
effective immediately upon the posting thereof. You must review this agreement 
on a regular basis to keep yourself apprised of any changes. You can find the 
most recent version of the TOU at:

http://www.dayboxx.com/info.php?page_key=termsofuse


3. CONTENT

You understand that all postings, messages, text, files, images, photos, 
video, sounds, or other materials &#40;"Content"&#41; posted on, transmitted 
through, or linked from the Service, are the sole responsibility of the 
person from whom such Content originated. More specifically, you are 
entirely responsible for each individual item &#40;"Item"&#41; of Content that you 
post, email or otherwise make available via the Service. You understand that 
DAYBOXX.COM does not control, and is not responsible for Content made available 
through the Service, and that by using the Service, you may be exposed to 
Content that is offensive, indecent, inaccurate, misleading, or otherwise 
objectionable. Furthermore, the DAYBOXX.COM site and Content available through 
the Service may contain links to other websites, which are completely 
independent of DAYBOXX.COM .  DAYBOXX.COM makes no representation or warranty as 
to the accuracy, completeness or authenticity of the information contained 
in any such site.  Your linking to any other websites is at your own risk. 
You agree that you must evaluate, and bear all risks associated with, the 
use of any Content, that you may not rely on said Content, and that under no 
circumstances will DAYBOXX.COM be liable in any way for any Content or for 
any loss or damage of any kind incurred as a result of the use of any Content 
posted, emailed or otherwise made available via the Service. You acknowledge 
that DAYBOXX.COM does not pre-screen or approve Content, but that DAYBOXX.COM 
shall have the right &#40;but not the obligation&#41; in its sole discretion to 
refuse, delete or move any Content that is available via the Service, for 
violating the letter or spirit of the TOU or for any other reason.


4. THIRD PARTY CONTENT, SITES, AND SERVICES

The DAYBOXX.COM site and Content available through the Service may contain 
features and functionalities that may link you or provide you with access 
to third party content which is completely independent of DAYBOXX.COM , 
including web sites, directories, servers, networks, systems, information 
and databases, applications, software, programs, products or services, 
and the Internet as a whole.  

Your interactions with organizations and/or individuals found on or through 
the Service, including payment and delivery of goods or services, and any 
other terms, conditions, warranties or representations associated with such 
dealings, are solely between you and such organizations and/or individuals.  
You should make whatever investigation you feel necessary or appropriate 
before proceeding with any online or offline transaction with any of these 
third parties.  

You agree that DAYBOXX.COM shall not be responsible or liable for any loss or 
damage of any sort incurred as the result of any such dealings. If there is 
a dispute between participants on this site, or between users and any third 
party, you understand and agree that DAYBOXX.COM is under no obligation to 
become involved. In the event that you have a dispute with one or more other 
users, you hereby release DAYBOXX.COM , its officers, employees, agents and 
successors in rights from claims, demands and damages &#40;actual and 
consequential&#41; of every kind or nature, known or unknown, suspected and 
unsuspected, disclosed and undisclosed, arising out of or in any way related 
to such disputes and / or our service. If you are a California resident, you 
waive California Civil Code Section 1542, which says: "A general release does 
not extend to claims which the creditor does not know or suspect to exist in 
his favor at the time of executing the release, which, if known by him must 
have materially affected his settlement with the debtor."  


5.  NOTIFICATION OF CLAIMS OF INFRINGEMENT

If you believe that your work has been copied in a way that constitutes 
copyright infringement, or your intellectual property rights have been 
otherwise violated, please notify DAYBOXX.COM&#39;s agent for notice of claims of 
copyright or other intellectual property infringement &#40;"Agent"&#41;, at

abuse@DAYBOXX.COM.org

or:

Copyright Agent
DAYBOXX.COM 
3 DayBoxx Tower
New York, NY
10012

Please provide our Agent with the following Notice:

a&#41; Identify the material on the DAYBOXX.COM  site that you claim is 
infringing, with enough detail so that we may locate it on the website;

b&#41; A statement by you that you have a good faith belief that the disputed 
use is not authorized by the copyright owner, its agent, or the law;

c&#41; A statement by you declaring under penalty of perjury that &#40;1&#41; the above 
information in your Notice is accurate, and &#40;2&#41; that you are the owner of 
the copyright interest involved or that you are authorized to act on behalf 
of that owner;

d&#41; Your address, telephone number, and email address; and

e&#41; Your physical or electronic signature.

DAYBOXX.COM will remove the infringing posting&#40;s&#41;, subject to the the procedures 
outlined in the Digital Millennium Copyright Act &#40;DMCA&#41;.


6. PRIVACY AND INFORMATION DISCLOSURE

DAYBOXX.COM has established a Privacy Policy to explain to users how their 
information is collected and used, which is located at the following web 
address: 

http://www.dayboxx.com/info.php?page_key=privacypolicy

Your use of the DAYBOXX.COM website or the Service signifies acknowledgement of 
and agreement to our Privacy Policy. You further acknowledge and agree that 
DAYBOXX.COM may, in its sole discretion, preserve or disclose your Content, 
as well as your information, such as email addresses, IP addresses, timestamps, 
and other user information, if required to do so by law or in the good faith 
belief that such preservation or disclosure is reasonably necessary to: 
comply with legal process; enforce the TOU; respond to claims that any 
Content violates the rights of third-parties; respond to claims that contact 
information &#40;e.g. phone number, street address&#41; of a third-party has been 
posted or transmitted without their consent or as a form of harassment; 
protect the rights, property, or personal safety of DAYBOXX.COM, its users or 
the general public. 


7. CONDUCT

You agree not to post, email, or otherwise make available Content:

a&#41; that is unlawful, harmful, threatening, abusive, harassing, defamatory, 
libelous, invasive of another&#39;s privacy, or is harmful to minors in any way;

b&#41; that is pornographic or depicts a human being engaged in actual sexual conduct 
including but not limited to &#40;i&#41; sexual intercourse, including genital-genital, 
oral-genital, anal-genital, or oral-anal, whether between persons of the same or 
opposite sex, or &#40;ii&#41; bestiality, or &#40;iii&#41; masturbation, or &#40;iv&#41; sadistic or 
masochistic abuse, or &#40;v&#41; lascivious exhibition of the genitals or pubic area 
of any person;

c&#41; that harasses, degrades, intimidates or is hateful toward an individual or 
group of individuals on the basis of religion, gender, sexual orientation, 
race, ethnicity, age, or disability;

d&#41; that violates the Fair Housing Act by stating, in any notice or ad for
the sale or rental of any dwelling, a discriminatory preference based on
race, color, national origin, religion, sex, familial status or handicap
&#40;or violates any state or local law prohibiting discrimination on the
basis of these or other characteristics&#41;;

e&#41; that violates federal, state, or local equal employment opportunity
laws, including but not limited to, stating in any advertisement for
employment a preference or requirement based on race, color, religion,
sex, national origin, age, or disability.

f&#41; with respect to employers that employ four or more employees, that
violates the anti-discrimination provision of the Immigration and
Nationality Act, including requiring U.S. citizenship or lawful
permanent residency &#40;green card status&#41; as a condition for employment,
unless otherwise required in order to comply with law, regulation,
executive order, or federal, state, or local government contract.

g&#41; that impersonates any person or entity, including, but not limited to, a 
DAYBOXX.COM employee, or falsely states or otherwise misrepresents your 
affiliation with a person or entity &#40;this provision does not apply to Content 
that constitutes lawful non-deceptive parody of public figures.&#41;;

h&#41; that includes personal or identifying information about another person 
without that person&#39;s explicit consent;

i&#41; that is false, deceptive, misleading, deceitful, misinformative, or 
constitutes "bait and switch";

j&#41; that infringes any patent, trademark, trade secret, copyright or other 
proprietary rights of any party, or Content that you do not have a right to 
make available under any law or under contractual or fiduciary relationships;

k&#41; that constitutes or contains  "affiliate marketing," "link referral code," 
"junk mail," "spam," "chain letters," "pyramid schemes," or unsolicited 
commercial advertisement;

l&#41; that constitutes or contains any form of advertising or solicitation if: 
posted in areas of the DAYBOXX.COM sites which are not designated for such 
purposes; or emailed to DAYBOXX.COM users who have not indicated in writing that 
it is ok to contact them about other services, products or commercial interests.

m&#41; that includes links to commercial services or web sites, except as allowed 
in "services";

n&#41; that contains software viruses or any other computer code, files or 
programs designed to interrupt, destroy or limit the functionality of any 
computer software or hardware or telecommunications equipment; 

o&#41; that disrupts the normal flow of dialogue with an excessive amount of 
Content &#40;flooding attack&#41; to the Service, or that otherwise negatively 
affects other users&#39; ability to use the Service; or

p&#41; that employs misleading email addresses, or forged headers or otherwise 
manipulated identifiers in order to disguise the origin of Content 
transmitted through the Service.

Additionally, you agree not to:

q&#41; contact anyone who has asked not to be contacted, or make unsolicited 
contact with anyone for any commercial purpose;

r&#41; "stalk" or otherwise harass anyone;

s&#41; collect personal data about other users for commercial or unlawful 
purposes;

t&#41; use automated means, including spiders, robots, crawlers, data mining 
tools, or the like to download data from the Service - unless expressly 
permitted by DAYBOXX.COM;

u&#41; post non-local or otherwise irrelevant Content, repeatedly post the 
same or similar Content or otherwise impose an unreasonable or 
disproportionately large load on our infrastructure;

v&#41; post the same item or service in more than one classified category or 
forum, or in more than one metropolitan area;

w&#41; attempt to gain unauthorized access to DAYBOXX.COM&#39;s computer systems or 
engage in any activity that disrupts, diminishes the quality of, interferes 
with the performance of, or impairs the functionality of, the Service or 
the DAYBOXX.COM website; or

x&#41; use any form of automated device or computer program that enables the 
submission of postings on DAYBOXX.COM without each posting being manually 
entered by the author thereof &#40;an "automated posting device"&#41;, including 
without limitation, the use of any such automated posting device to submit 
postings in bulk, or for automatic submission of postings at regular intervals.

y&#41; use any form of automated device or computer program &#40;"flagging tool"&#41;
that enables the use of DAYBOXX.COM&#39;s "flagging system" or other community
moderation systems without each flag being manually entered by the person
that initiates the flag &#40;an "automated flagging device"&#41;, or use the
flagging tool to remove posts of competitors, or to remove posts without a
good faith belief that the post being flagged violates these TOU;

8. POSTING AGENTS

A "Posting Agent" is a third-party agent, service, or intermediary
that offers to post Content to the Service on behalf of others. To 
moderate demands on DAYBOXX.COM&#39;s resources, you may not use a Posting 
Agent to post Content to the Service without express permission or 
license from DAYBOXX.COM.  Correspondingly, Posting Agents are not 
permitted to post Content on behalf of others, to cause Content to 
be so posted, or otherwise access the Service to facilitate posting 
Content on behalf of others, except with express permission or 
license from DAYBOXX.COM.


9. NO SPAM POLICY

You understand and agree that sending unsolicited email advertisements to 
DAYBOXX.COM email addresses or through DAYBOXX.COM computer systems, which is 
expressly prohibited by these Terms, will use or cause to be used servers 
located in California.  Any unauthorized use of  DAYBOXX.COM computer systems 
is a violation of these Terms and certain federal and state laws, including 
without limitation the Computer Fraud and Abuse Act &#40;18 U.S.C. Ã‚Â§ 1030 et 
seq.&#41;, Section 502 of the California Penal Code and Section 17538.45 of the 
California Business and Professions Code.  Such violations may subject the 
sender and his or her agents to civil and criminal penalties.


10. PAID POSTINGS

We may charge a fee to post Content in some areas of the Service. The fee
is an access fee permitting Content to be posted in a designated area.
Each party posting Content to the Service is responsible for said Content
and compliance with the TOU. All fees paid will be non-refundable in the
event that Content is removed from the Service for violating the TOU.


11. LIMITATIONS ON SERVICE

You acknowledge that DAYBOXX.COM may establish limits concerning use of the 
Service, including the maximum number of days that Content will be retained 
by the Service, the maximum number and size of postings, email messages, or 
other Content that may be transmitted or stored by the Service, and the 
frequency with which you may access the Service. You agree that DAYBOXX.COM 
has no responsibility or liability for the deletion or failure to store any 
Content maintained or transmitted by the Service. You acknowledge that 
DAYBOXX.COM reserves the right at any time to modify or discontinue the 
Service &#40;or any part thereof&#41; with or without notice, and that DAYBOXX.COM 
shall not be liable to you or to any third party for any modification, 
suspension or discontinuance of the Service.


12. ACCESS TO THE SERVICE

DAYBOXX.COM grants you a limited, revocable, nonexclusive license to access 
the Service for your own personal use.  This license does not include: 
&#40;a&#41; access to the Service by Posting Agents; or &#40;b&#41; any collection, 
aggregation, copying, duplication, display or derivative use of the Service 
nor any use of data mining, robots, spiders, or similar data gathering and 
extraction tools for any purpose unless expressly permitted by DAYBOXX.COM. 
A limited exception to &#40;b&#41; is provided to general purpose internet search 
engines and non-commercial public archives that use such tools to gather 
information for the sole purpose of displaying hyperlinks to the Service, 
provided they each do so from a stable IP address or range of IP addresses 
using an easily identifiable agent and comply with our robots.txt file. 
"General purpose internet search engine" does not include a website or 
search engine or other service that specializes in classified listings 
or in any subset of classifieds listings such as jobs, housing, for sale, 
services, or personals, or which is in the business of providing classified 
ad listing services.

DAYBOXX.COM permits you to display on your website, or create a hyperlink 
on your website to, individual postings on the Service so long as such use 
is for noncommercial and/or news reporting purposes only &#40;e.g., for use in 
personal web blogs or personal online media&#41;.  If the total number of such 
postings displayed or linked to on your website exceeds one hundred &#40;100&#41; 
postings, your use will be presumed to be in violation of the TOU, 
absent express permission granted by DAYBOXX.COM to do so.  You may also 
create a hyperlink to the home page of DAYBOXX.COM sites so long as the 
link does not portray DAYBOXX.COM, its employees, or its affiliates in a 
false, misleading, derogatory, or otherwise offensive matter.

DAYBOXX.COM offers various parts of the Service in RSS format so that users 
can embed individual feeds into a personal website or blog, or view postings 
through third party software news aggregators.  DAYBOXX.COM permits you to 
display, excerpt from, and link to the RSS feeds on your personal website 
or personal web blog, provided that &#40;a&#41; your use of the RSS feed is for 
personal, non-commercial purposes only, &#40;b&#41; each title is correctly linked 
back to the original post on the Service and redirects the user to the 
post when the user clicks on it, &#40;c&#41; you provide, adjacent to the RSS 
feed, proper attribution to &#39;DAYBOXX.COM&#39; as the source, &#40;d&#41; your use or 
display does not suggest that DAYBOXX.COM promotes or endorses any third 
party causes, ideas, web sites, products or services, &#40;e&#41; you do not 
redistribute the RSS feed, and &#40;f&#41; your use does not overburden 
DAYBOXX.COM&#39;s systems.  DAYBOXX.COM reserves all rights in the content of 
the RSS feeds and may terminate any RSS feed at any time.

Use of the Service beyond the scope of authorized access granted to you by 
DAYBOXX.COM immediately terminates said permission or license.  In order to 
collect, aggregate, copy, duplicate, display or make derivative use of the 
the Service or any Content made available via the Service for other 
purposes &#40;including commercial purposes&#41; not stated herein, you must first 
obtain a license from DAYBOXX.COM.


13. TERMINATION OF SERVICE

You agree that DAYBOXX.COM, in its sole discretion, has the right &#40;but not 
the obligation&#41; to delete or deactivate your account, block your email or IP 
address, or otherwise terminate your access to or use of the Service &#40;or any 
part thereof&#41;, immediately and without notice, and remove and discard any 
Content within the Service, for any reason, including, without limitation, 
if DAYBOXX.COM believes that you have acted inconsistently with the letter or 
spirit of the TOU. Further, you agree that DAYBOXX.COM shall not be liable 
to you or any third-party for any termination of your access to the Service.  
Further, you agree not to attempt to use the Service after said termination.  
Sections 2, 4, 6 and 10-16 shall survive termination of the TOU.


14. PROPRIETARY RIGHTS

The Service is protected to the maximum extent permitted by copyright laws 
and international treaties. Content displayed on or through the Service is 
protected by copyright as a collective work and/or compilation, pursuant to 
copyrights laws, and international conventions. Any reproduction, 
modification, creation of derivative works from or redistribution of the 
site or the collective work, and/or copying or reproducing the sites 
or any portion thereof to any other server or location for further 
reproduction or redistribution is prohibited without the express 
written consent of DAYBOXX.COM. You further agree not to reproduce, 
duplicate or copy Content from the Service without the express written 
consent of DAYBOXX.COM, and agree to abide by any and all copyright notices 
displayed on the Service. You may not decompile or disassemble, reverse 
engineer or otherwise attempt to discover any source code contained in the 
Service. Without limiting the foregoing, you agree not to reproduce, 
duplicate, copy, sell, resell or exploit for any commercial purposes, any 
aspect of the Service. DAYBOXX.COM is a registered mark in the U.S. Patent 
and Trademark Office.

Although DAYBOXX.COM does not claim ownership of content that its users post, 
by posting Content to any public area of the Service, you automatically 
grant, and you represent and warrant that you have the right to grant, to 
DAYBOXX.COM an irrevocable, perpetual, non-exclusive, fully paid, worldwide 
license to use, copy, perform, display, and distribute said Content and to 
prepare derivative works of, or incorporate into other works, said Content, 
and to grant and authorize sublicenses &#40;through multiple tiers&#41; of the 
foregoing. Furthermore, by posting Content to any public area of the Service, 
you automatically grant DAYBOXX.COM all rights necessary to prohibit any 
subsequent aggregation, display, copying, duplication, reproduction, or 
exploitation of the Content on the Service by any party for any purpose.


15. DISCLAIMER OF WARRANTIES

YOU AGREE THAT USE OF THE DAYBOXX.COM SITE AND THE SERVICE IS ENTIRELY AT 
YOUR OWN RISK. THE DAYBOXX.COM SITE AND THE SERVICE ARE PROVIDED ON AN "AS 
IS" OR "AS AVAILABLE" BASIS, WITHOUT ANY WARRANTIES OF ANY KIND.  ALL 
EXPRESS AND IMPLIED WARRANTIES, INCLUDING, WITHOUT LIMITATION, THE 
WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE, AND 
NON-INFRINGEMENT OF PROPRIETARY RIGHTS ARE EXPRESSLY DISCLAIMED TO THE 
FULLEST EXTENT PERMITTED BY LAW.  TO THE FULLEST EXTENT PERMITTED BY LAW, 
DAYBOXX.COM DISCLAIMS ANY WARRANTIES FOR THE SECURITY, RELIABILITY, 
TIMELINESS, ACCURACY, AND PERFORMANCE OF THE DAYBOXX.COM SITE AND THE 
SERVICE.  TO THE FULLEST EXTENT PERMITTED BY LAW, DAYBOXX.COM DISCLAIMS ANY 
WARRANTIES FOR OTHER SERVICES OR GOODS RECEIVED THROUGH OR ADVERTISED ON THE 
DAYBOXX.COM SITE OR THE SITES OR SERVICE, OR ACCESSED THROUGH ANY LINKS ON 
THE DAYBOXX.COM SITE.  TO THE FULLEST EXTENT PERMITTED BY LAW, DAYBOXX.COM 
DISCLAIMS ANY WARRANTIES FOR VIRUSES OR OTHER HARMFUL COMPONENTS IN 
CONNECTION WITH THE DAYBOXX.COM SITE OR THE SERVICE.  Some jurisdictions do 
not allow the disclaimer of implied warranties.  In such jurisdictions, some 
of the foregoing disclaimers may not apply to you insofar as they relate to 
implied warranties.


16. LIMITATIONS OF LIABILITY

UNDER NO CIRCUMSTANCES SHALL DAYBOXX.COM BE LIABLE FOR DIRECT, INDIRECT, 
INCIDENTAL, SPECIAL, CONSEQUENTIAL OR EXEMPLARY DAMAGES &#40;EVEN IF DAYBOXX.COM 
HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES&#41;, RESULTING FROM ANY 
ASPECT OF YOUR USE OF THE DAYBOXX.COM SITE OR THE SERVICE, WHETHER THE 
DAMAGES ARISE FROM USE OR MISUSE OF THE DAYBOXX.COM SITE OR THE SERVICE, FROM 
INABILITY TO USE THE DAYBOXX.COM SITE OR THE SERVICE, OR THE INTERRUPTION, 
SUSPENSION, MODIFICATION, ALTERATION, OR TERMINATION OF THE DAYBOXX.COM SITE 
OR THE SERVICE.  SUCH LIMITATION SHALL ALSO APPLY WITH RESPECT TO DAMAGES 
INCURRED BY REASON OF OTHER SERVICES OR PRODUCTS RECEIVED THROUGH OR 
ADVERTISED IN CONNECTION WITH THE DAYBOXX.COM SITE OR THE SERVICE OR ANY 
LINKS ON THE DAYBOXX.COM SITE, AS WELL AS BY REASON OF ANY INFORMATION OR 
ADVICE RECEIVED THROUGH OR ADVERTISED IN CONNECTION WITH THE DAYBOXX.COM SITE 
OR THE SERVICE OR ANY LINKS ON THE DAYBOXX.COM SITE.  THESE LIMITATIONS SHALL 
APPLY TO THE FULLEST EXTENT PERMITTED BY LAW. In some jurisdictions, 
limitations of liability are not permitted.  In such jurisdictions, some of 
the foregoing limitation may not apply to you.


17. INDEMNITY

You agree to indemnify and hold DAYBOXX.COM, its officers, subsidiaries, 
affiliates, successors, assigns, directors, officers, agents, service 
providers, suppliers and employees, harmless from any claim or demand, 
including reasonable attorney fees and court costs, made by any third party 
due to or arising out of Content you submit, post or make available through 
the Service, your use of the Service, your violation of the TOU, your 
breach of any of the representations and warranties herein, or your 
violation of any rights of another.


18. GENERAL INFORMATION

The TOU constitute the entire agreement between you and DAYBOXX.COM and 
govern your use of the Service, superceding any prior agreements between you 
and DAYBOXX.COM. The TOU and the relationship between you and DAYBOXX.COM 
shall be governed by the laws of the State of California without regard to 
its conflict of law provisions. You and DAYBOXX.COM agree to submit to the 
personal and exclusive jurisdiction of the courts located within the county 
of San Francisco, California. The failure of DAYBOXX.COM to exercise or 
enforce any right or provision of the TOU shall not constitute a waiver of 
such right or provision. If any provision of the TOU is found by a court 
of competent jurisdiction to be invalid, the parties nevertheless agree that 
the court should endeavor to give effect to the parties&#39; intentions as 
reflected in the provision, and the other provisions of the TOU remain in 
full force and effect. You agree that regardless of any statute or law to 
the contrary, any claim or cause of action arising out of or related to use 
of the Service or the TOU must be filed within one &#40;1&#41; year after such 
claim or cause of action arose or be forever barred.


19. VIOLATION OF TERMS AND LIQUIDATED DAMAGES

Please report any violations of the TOU, by flagging the posting&#40;s&#41; for 
review, or by emailing to:

abuse@DAYBOXX.COM 

Our failure to act with respect to a breach by you or others does not waive our 
right to act with respect to subsequent or similar breaches.

You understand and agree that, because damages are often difficult to quantify, 
if it becomes necessary for DAYBOXX.COM to pursue legal action to enforce these 
Terms, you will be liable to pay DAYBOXX.COM the following amounts as liquidated 
damages, which you accept as reasonable estimates of DAYBOXX.COM&#39; damages for 
the specified breaches of these Terms:

a. If you post a message that &#40;1&#41; impersonates any person or entity; &#40;2&#41; 
falsely states or otherwise misrepresents your affiliation with a person or 
entity; or &#40;3&#41; that includes personal or identifying information about 
another person without that person&#39;s explicit consent, you agree to pay 
DAYBOXX.COM one thousand dollars &#40;$1,000&#41; for each such message.  
This provision does not apply to Content that constitutes lawful non-deceptive 
parody of public figures.

b. If DAYBOXX.COM establishes limits on the frequency with which you may 
access the Service, or terminates your access to or use of the Service, you 
agree to pay DAYBOXX.COM one hundred dollars &#40;$100&#41; for each message posted 
in excess of such limits or for each day on which you access DAYBOXX.COM in 
excess of such limits, whichever is higher.

c. If you send unsolicited email advertisements to DAYBOXX.COM email 
addresses or through DAYBOXX.COM computer systems, you agree to pay 
DAYBOXX.COM twenty five dollars &#40;$25&#41; for each such email.

d. If you post Content in violation of the TOU, other than as described 
above, you agree to pay DAYBOXX.COM one hundred dollars &#40;$100&#41; for each 
Item of Content posted.  In its sole discretion, DAYBOXX.COM may elect 
to issue a warning before assessing damages.

e. If you are a Posting Agent that uses the Service in violation of the
TOU, in addition to any liquidated damages under clause &#40;d&#41;, you agree to
pay DAYBOXX.COM one hundred dollars &#40;$100&#41; for each and every Item you post
in violation of the TOU.  A Posting Agent will also be deemed an agent of
the party engaging the Posting Agent to access the Service &#40;the
"Principal"&#41;, and the Principal &#40;by engaging the Posting Agent in
violation of the TOU&#41; agrees to pay DAYBOXX.COM an additional one hundred
dollars &#40;$100&#41; for each Item posted by the Posting Agent on behalf of
the Principal in violation of the TOU.

f. If you aggregate, display, copy, duplicate, reproduce, or otherwise 
exploit for any purpose any Content &#40;except for your own Content&#41; in 
violation of these Terms without DAYBOXX.COM&#39;s express written permission, 
you agree to pay DAYBOXX.COM three thousand dollars &#40;$3,000&#41; for each day 
on which you engage in such conduct.

Otherwise, you agree to pay DAYBOXX.COM&#39;s actual damages, to the extent such 
actual damages can be reasonably calculated. Notwithstanding any other 
provision of these Terms, DAYBOXX.COM retains the right to seek the remedy 
of specific performance of any term contained in these Terms, or a preliminary 
or permanent injunction against the breach of any such term or in aid of the 
exercise of any power granted in these Terms, or any combination thereof.


20. FEEDBACK

We welcome your questions and comments on this document in the DAYBOXX.COM 
feedback form:        

http://dayboxx.com/contact.php 

','');
INSERT INTO dayboxx.content(`content_id`,`name`,`content`,`icon_filename`) VALUES('3','privacypolicy','Your Privacy

DAYBOXX.COM is committed to protecting your privacy. We only use the information we collect about you to process orders and to provide support and upgrades for our products. Please read on for more details about our privacy policy.

What information do we collect? How do we use it?

When you order, we need to know your name, e-mail address, mailing address, credit card number, and expiration date. This allows us to process and fulfill your order and to notify you of your order status. When you enter a contest or other promotional feature, we may ask for your name, address, and e-mail address so we can administer the contest and notify winners.

How does DAYBOXX.COM protect customer information?

We use a Secure Server for collecting personal and credit card information. The secure server layer &#40;SSL&#41; encrypts &#40;scrambles&#41; all of the information you enter before it is transmitted over the internet and sent to us. Furthermore, all of the customer data we collect is protected against unauthorized access.

What about "cookies"?

"Cookies" are small pieces of information that are stored by your browser on your computer&#39;s hard drive. We do not use cookies to collect or store any information about visitors or customers.

Will DAYBOXX.COM disclose the information it collects to outside parties?

DAYBOXX.COM does not sell, trade, or rent your personal information to others. DAYBOXX.COM may provide aggregate statistics about our customers, sales, traffic patterns, and related site information to reputable third-party vendors, but these statistics will not include personally identifying information.

DAYBOXX.COM may release account information when we believe, in good faith, that such release is reasonably necessary to &#40;i&#41; comply with law, &#40;ii&#41; enforce or apply the terms of any of our user agreements or &#40;iii&#41; protect the rights, property or safety of DAYBOXX.COM, our users, or others.

In Summary

DAYBOXX.COM is committed to protecting your privacy. We use the information we collect on the site to make shopping at SimpleJoe.com as simple as possible and to enhance your overall shopping experience. We do not sell, trade, or rent your personal information to others.

Your Consent

By using our Web site, you consent to the collection and use of this information by DAYBOXX.COM, Inc. If we decide to change our privacy policy, we will post those changes on this page so that you are always aware of what information we collect, how we use it, and under what circumstances we disclose it.

DAYBOXX.COM also provides links to affiliated sites. The privacy policies of these linked sites are the responsibility of the linked site and DAYBOXX.COM has no control or influence over their policies. Please check the policies of each site you visit for specific information. DAYBOXX.COM cannot be held liable for damage or misdoings of other sites linked or otherwise.
','');
INSERT INTO dayboxx.content(`content_id`,`name`,`content`,`icon_filename`) VALUES('2','homepage blurb','<div style="font-style: italic; font-size:1.5em; text-align:right; color:#23630c;font-weight:bold;">Appoint. Remind.</div><br />
Welcome to <strong><span style="color:#23630c;">Day</span>Boxx</strong>: your online appointment and reminder system. Eliminate guesswork while saving thousands of dollars a year in staff costs and time. Access your appointment book from any computer or smart phone, remind clients and customers of appointments without lifting a finger.
<br /><br /><strong><span style="color:#23630c;">Day</span>Boxx</strong> offers programs starting at just $49 per year per office. Take appointments and scheduling in the 21<small><sup>st</sup></small> century!','');
INSERT INTO dayboxx.content(`content_id`,`name`,`content`,`icon_filename`) VALUES('4','jobs','DayBoxx is hiring!

Currently we are looking for a phone system specialist. Must have 5+ years experience with Linux and at least a year&#39;s experience with Asterisk.','');
INSERT INTO dayboxx.content(`content_id`,`name`,`content`,`icon_filename`) VALUES('5','support','Need support?  You&#39;re outta luck! We have no support staff at this time!','');
INSERT INTO dayboxx.content(`content_id`,`name`,`content`,`icon_filename`) VALUES('6','whatwedo','Finally you don&#39;t need to be at the office or shop to see your appointment
calendar.  DayBoxx takes appointment scheduling into the 21st century by
allowing online, of-of-office appointment making and review by computer or
smart phone.  View up-to-the-minute appointments and calendars for the
entire staff, wherever you are.  Search easily for client or customer
appointments, current and past, without randomly flipping through calendar
pages.  Our scheduling calendar even accepts multiple appointments for the
same time for the same staff member or desk.
','');
INSERT INTO dayboxx.content(`content_id`,`name`,`content`,`icon_filename`) VALUES('11','what-mb-does:patientreg','1. Patient Registration','patrientreg_icon.png');
INSERT INTO dayboxx.content(`content_id`,`name`,`content`,`icon_filename`) VALUES('15','what-mb-does:infobox','','');
INSERT INTO dayboxx.content(`content_id`,`name`,`content`,`icon_filename`) VALUES('16','what-mb-does:scheduling','1. <strong>Scheduling Appointments and Calendars</strong><br />
Finally you don&#39;t need to be at the office or shop to see your appointment calendar. DayBoxx takes appointment scheduling into the 21st century by allowing online, out-of-office appointment making and review by computer or smart phone. View up-to-the-minute appointments and calendars for the entire staff, wherever you are. Search easily for client or customer appointments, current and past, without randomly flipping through calendar pages. Our scheduling calendar even accepts multiple appointments for the same time for the same staff member or desk.','patrientrcal_icon.png');
INSERT INTO dayboxx.content(`content_id`,`name`,`content`,`icon_filename`) VALUES('17','what-mb-does:patientreminders','2. <strong>Client and Customer Reminders</strong><br />
Take the hassle out of client and customer reminders. Let DayBoxx save you precious time and effort through our easily customized automated email and phone appointment reminders. For example, patients could receive 3 email reminders: 5 months before, 1 month before, 3 days before plus a phone call reminder the day before the appointment. Each reminder will give clients and customers one of three options: accept the appointment, request an office call to change the appointment, or cancel the appointment.','patrientrclock_icon.png');
INSERT INTO dayboxx.content(`content_id`,`name`,`content`,`icon_filename`) VALUES('20','what-mb-does:top','How DayBoxx Supports Your Front Desk And Lowers Your Costs Dramatically','spacer.png');
INSERT INTO dayboxx.content(`content_id`,`name`,`content`,`icon_filename`) VALUES('19','what-mb-does:bottombuttons','<table width=760 height=40>
<tr>
<td><a href=reg.php?x_mode=office><img src=images/signupfor.png border=0></a></td> 
<td><a href=reg.php?x_mode=office><img src=images/tryfree.png border=0></a></td>  
</tr>
</table>','');
INSERT INTO dayboxx.content(`content_id`,`name`,`content`,`icon_filename`) VALUES('21','login not yet added office','Not yet  added your office to DayBoxx.com? [Register] to streamline your office work and automate your reminders.','');
INSERT INTO dayboxx.content(`content_id`,`name`,`content`,`icon_filename`) VALUES('22','login not yet added client','Not yet    added your patient profile to DayBoxx.com? [Register] to speed your office visits and receive appointment reminders.','');


CREATE TABLE `event_status` (
  `event_status_id` int(11) NOT NULL auto_increment,
  `status_name` varchar(50) default NULL,
  PRIMARY KEY  (`event_status_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;



INSERT INTO dayboxx.event_status(`event_status_id`,`status_name`) VALUES('1','none');
INSERT INTO dayboxx.event_status(`event_status_id`,`status_name`) VALUES('2','yes');
INSERT INTO dayboxx.event_status(`event_status_id`,`status_name`) VALUES('3','no');
INSERT INTO dayboxx.event_status(`event_status_id`,`status_name`) VALUES('4','call');


CREATE TABLE `formlog` (
  `formlog_id` int(11) NOT NULL auto_increment,
  `time_done` timestamp NULL default NULL,
  `ip_address` varchar(33) default NULL,
  `referer` varchar(211) default NULL,
  `label` varchar(222) default NULL,
  `form_content` text,
  `comments` text,
  PRIMARY KEY  (`formlog_id`)
) ENGINE=MyISAM AUTO_INCREMENT=60 DEFAULT CHARSET=latin1;



INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('1','2010-07-30 21:42:22','71.246.176.17','http://dayboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:194;s:7:"isemail";b:1;s:9:"calltime:";s:19:"1970-01-01 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:42:22";s:1:"i";i:0;}','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('2','2010-07-30 21:42:22','71.246.176.17','http://dayboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:194;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-22 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:42:22";s:1:"i";i:1;}','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('3','2010-07-30 21:42:22','71.246.176.17','http://dayboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:194;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-27 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:42:22";s:1:"i";i:2;}','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('4','2010-07-30 21:42:22','71.246.176.17','http://dayboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:194;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-07-28 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:42:22";s:1:"i";i:3;}','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('5','2010-07-30 21:42:22','71.246.176.17','http://dayboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:194;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-07-28 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:42:22";s:1:"i";i:4;}','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('6','2010-07-30 21:42:22','71.246.176.17','http://dayboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:194;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-07-28 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:42:22";s:1:"i";i:5;}','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('7','2010-08-01 18:06:33','24.161.14.104','http://dayboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:195;s:7:"isemail";b:1;s:9:"calltime:";s:19:"1970-01-01 00:00:00";s:10:"actualtime";s:19:"2010-08-01 18:06:33";s:1:"i";i:0;}','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('8','2010-08-01 18:06:33','24.161.14.104','http://dayboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:195;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-28 00:00:00";s:10:"actualtime";s:19:"2010-08-01 18:06:33";s:1:"i";i:1;}','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('9','2010-08-01 18:06:33','24.161.14.104','http://dayboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:195;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-03 00:12:00";s:10:"actualtime";s:19:"2010-08-01 18:06:33";s:1:"i";i:4;}','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('10','2010-08-01 18:06:33','24.161.14.104','http://dayboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:195;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-03 00:12:00";s:10:"actualtime";s:19:"2010-08-01 18:06:33";s:1:"i";i:5;}','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('11','2010-08-01 18:06:57','24.161.14.104','http://dayboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:196;s:7:"isemail";b:1;s:9:"calltime:";s:19:"1970-01-01 00:00:00";s:10:"actualtime";s:19:"2010-08-01 18:06:57";s:1:"i";i:0;}','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('12','2010-08-01 18:06:57','24.161.14.104','http://dayboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:196;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-29 00:00:00";s:10:"actualtime";s:19:"2010-08-01 18:06:57";s:1:"i";i:1;}','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('13','2010-08-01 18:06:57','24.161.14.104','http://dayboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:196;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-04 00:14:00";s:10:"actualtime";s:19:"2010-08-01 18:06:57";s:1:"i";i:4;}','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('14','2010-08-01 18:06:57','24.161.14.104','http://dayboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:196;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-04 00:14:00";s:10:"actualtime";s:19:"2010-08-01 18:06:57";s:1:"i";i:5;}','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('15','2010-08-01 18:08:14','24.161.14.104','http://dayboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:197;s:7:"isemail";b:1;s:9:"calltime:";s:19:"1970-01-01 00:00:00";s:10:"actualtime";s:19:"2010-08-01 18:08:14";s:1:"i";i:0;}','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('16','2010-08-01 18:08:14','24.161.14.104','http://dayboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:197;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-28 00:00:00";s:10:"actualtime";s:19:"2010-08-01 18:08:14";s:1:"i";i:1;}','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('17','2010-08-01 18:08:14','24.161.14.104','http://dayboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:197;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-03 00:01:00";s:10:"actualtime";s:19:"2010-08-01 18:08:14";s:1:"i";i:4;}','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('18','2010-08-01 18:08:14','24.161.14.104','http://dayboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:197;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-03 00:01:00";s:10:"actualtime";s:19:"2010-08-01 18:08:14";s:1:"i";i:5;}','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('19','2010-08-01 18:08:32','24.161.14.104','http://dayboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:198;s:7:"isemail";b:1;s:9:"calltime:";s:19:"1970-01-01 00:00:00";s:10:"actualtime";s:19:"2010-08-01 18:08:32";s:1:"i";i:0;}','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('20','2010-08-01 18:08:32','24.161.14.104','http://dayboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:198;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-30 00:00:00";s:10:"actualtime";s:19:"2010-08-01 18:08:32";s:1:"i";i:1;}','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('21','2010-08-01 18:08:32','24.161.14.104','http://dayboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:198;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 00:17:00";s:10:"actualtime";s:19:"2010-08-01 18:08:32";s:1:"i";i:4;}','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('22','2010-08-01 18:08:32','24.161.14.104','http://dayboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:198;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 00:17:00";s:10:"actualtime";s:19:"2010-08-01 18:08:32";s:1:"i";i:5;}','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('23','2010-08-01 18:15:23','24.161.14.104','http://dayboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:199;s:7:"isemail";b:1;s:9:"calltime:";s:19:"1970-01-01 00:00:00";s:10:"actualtime";s:19:"2010-08-01 18:15:23";s:1:"i";i:0;}','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('24','2010-08-01 18:15:23','24.161.14.104','http://dayboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:199;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-30 00:00:00";s:10:"actualtime";s:19:"2010-08-01 18:15:23";s:1:"i";i:1;}','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('25','2010-08-01 18:15:23','24.161.14.104','http://dayboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:199;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 00:16:00";s:10:"actualtime";s:19:"2010-08-01 18:15:23";s:1:"i";i:4;}','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('26','2010-08-01 18:15:23','24.161.14.104','http://dayboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:199;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 00:16:00";s:10:"actualtime";s:19:"2010-08-01 18:15:23";s:1:"i";i:5;}','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('27','2010-08-01 18:15:40','24.161.14.104','http://dayboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:200;s:7:"isemail";b:1;s:9:"calltime:";s:19:"1970-01-01 00:00:00";s:10:"actualtime";s:19:"2010-08-01 18:15:40";s:1:"i";i:0;}','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('28','2010-08-01 18:15:40','24.161.14.104','http://dayboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:200;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-31 00:00:00";s:10:"actualtime";s:19:"2010-08-01 18:15:40";s:1:"i";i:1;}','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('29','2010-08-01 18:15:40','24.161.14.104','http://dayboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:200;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-06 00:18:00";s:10:"actualtime";s:19:"2010-08-01 18:15:40";s:1:"i";i:4;}','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('30','2010-08-01 18:15:40','24.161.14.104','http://dayboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:200;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-06 00:18:00";s:10:"actualtime";s:19:"2010-08-01 18:15:40";s:1:"i";i:5;}','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('31','2010-08-01 18:16:00','24.161.14.104','http://dayboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:201;s:7:"isemail";b:1;s:9:"calltime:";s:19:"1970-01-01 00:00:00";s:10:"actualtime";s:19:"2010-08-01 18:16:00";s:1:"i";i:0;}','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('32','2010-08-01 18:16:00','24.161.14.104','http://dayboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:201;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-31 00:00:00";s:10:"actualtime";s:19:"2010-08-01 18:16:00";s:1:"i";i:1;}','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('33','2010-08-01 18:16:00','24.161.14.104','http://dayboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:201;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-06 00:15:00";s:10:"actualtime";s:19:"2010-08-01 18:16:00";s:1:"i";i:4;}','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('34','2010-08-01 18:16:00','24.161.14.104','http://dayboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:201;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-06 00:15:00";s:10:"actualtime";s:19:"2010-08-01 18:16:00";s:1:"i";i:5;}','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('35','2010-08-03 00:01:06','64.150.169.145','','','s:281:"json={"version":1,"data":[{"tag":"dayboxx.138","phone":"18452465599","tts":"<voice name='William-8kHz'>This is a call from Beauty Bar reminding you of your appointment for 1:15 pm on Tuesday August 3rd. If you have any questions please call 9176504575. Thank you.</voice>"}]}|[148]";','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('36','2010-08-03 00:13:02','64.150.169.145','','','s:282:"json={"version":1,"data":[{"tag":"dayboxx.134","phone":"19176504575","tts":"<voice name='William-8kHz'>This is a call from Beauty Bar reminding you of your appointment for 10:30 am on Tuesday August 3rd. If you have any questions please call 9176504575. Thank you.</voice>"}]}|[149]";','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('37','2010-08-04 00:15:02','64.150.169.145','','','s:283:"json={"version":1,"data":[{"tag":"dayboxx.136","phone":"19176504575","tts":"<voice name='William-8kHz'>This is a call from Beauty Bar reminding you of your appointment for 1:45 pm on Wednesday August 4th. If you have any questions please call 9176504575. Thank you.</voice>"}]}|[150]";','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('38','2010-08-05 00:17:03','64.150.169.145','','','s:537:"json={"version":1,"data":[{"tag":"dayboxx.140","phone":"18452465599","tts":"<voice name='William-8kHz'>This is a call from Beauty Bar reminding you of your appointment for 10:30 am on Thursday August 5th. If you have any questions please call 9176504575. Thank you.</voice>"},{"tag":"dayboxx.142","phone":"19176504575","tts":"<voice name='William-8kHz'>This is a call from Beauty Bar reminding you of your appointment for 10:30 am on Thursday August 5th. If you have any questions please call 9176504575. Thank you.</voice>"}]}|[152,153]";','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('39','2010-08-06 00:15:03','64.150.169.145','','','s:280:"json={"version":1,"data":[{"tag":"dayboxx.146","phone":"18452465599","tts":"<voice name='William-8kHz'>This is a call from Beauty Bar reminding you of your appointment for 1:30 pm on Friday August 6th. If you have any questions please call 9176504575. Thank you.</voice>"}]}|[156]";','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('40','2010-08-06 00:19:02','64.150.169.145','','','s:281:"json={"version":1,"data":[{"tag":"dayboxx.144","phone":"19176504575","tts":"<voice name='William-8kHz'>This is a call from Beauty Bar reminding you of your appointment for 11:15 am on Friday August 6th. If you have any questions please call 9176504575. Thank you.</voice>"}]}|[157]";','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('41','2010-09-09 01:16:05','24.161.14.104','http://dayboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:202;s:7:"isemail";b:1;s:9:"calltime:";s:19:"1970-01-01 00:00:00";s:10:"actualtime";s:19:"2010-09-09 01:16:05";s:1:"i";i:0;}','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('42','2010-09-09 01:16:05','24.161.14.104','http://dayboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:202;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-09-04 00:00:00";s:10:"actualtime";s:19:"2010-09-09 01:16:05";s:1:"i";i:1;}','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('43','2010-09-09 01:16:05','24.161.14.104','http://dayboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:202;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-09-09 00:00:00";s:10:"actualtime";s:19:"2010-09-09 01:16:05";s:1:"i";i:2;}','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('44','2010-09-09 01:16:05','24.161.14.104','http://dayboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:202;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-09-10 00:17:00";s:10:"actualtime";s:19:"2010-09-09 01:16:05";s:1:"i";i:4;}','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('45','2010-09-09 01:16:05','24.161.14.104','http://dayboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:202;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-09-10 00:17:00";s:10:"actualtime";s:19:"2010-09-09 01:16:05";s:1:"i";i:5;}','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('46','2010-09-10 00:17:02','64.150.169.145','','','s:282:"json={"version":1,"data":[{"tag":"dayboxx.147","phone":"","tts":"<voice name='William-8kHz'>This is a call from Curley's Nail Salon reminding you of your appointment for 11:00 am on Friday September 10th. If you have any questions please call 917604575. Thank you.</voice>"}]}|[183]";','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('47','2010-09-10 01:21:03','64.150.169.145','','','s:282:"json={"version":1,"data":[{"tag":"dayboxx.147","phone":"","tts":"<voice name='William-8kHz'>This is a call from Curley's Nail Salon reminding you of your appointment for 11:00 am on Friday September 10th. If you have any questions please call 917604575. Thank you.</voice>"}]}|[185]";','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('48','2010-09-10 02:25:02','64.150.169.145','','','s:282:"json={"version":1,"data":[{"tag":"dayboxx.147","phone":"","tts":"<voice name='William-8kHz'>This is a call from Curley's Nail Salon reminding you of your appointment for 11:00 am on Friday September 10th. If you have any questions please call 917604575. Thank you.</voice>"}]}|[187]";','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('49','2010-09-10 02:54:41','24.161.42.157','http://dayboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:203;s:7:"isemail";b:1;s:9:"calltime:";s:19:"1970-01-01 00:00:00";s:10:"actualtime";s:19:"2010-09-10 02:54:41";s:1:"i";i:0;}','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('50','2010-09-10 02:54:41','24.161.42.157','http://dayboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:203;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-09-01 00:00:00";s:10:"actualtime";s:19:"2010-09-10 02:54:41";s:1:"i";i:1;}','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('51','2010-09-10 02:54:41','24.161.42.157','http://dayboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:203;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-09-06 00:00:00";s:10:"actualtime";s:19:"2010-09-10 02:54:41";s:1:"i";i:2;}','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('52','2010-09-10 02:54:41','24.161.42.157','http://dayboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:203;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-09-07 00:00:00";s:10:"actualtime";s:19:"2010-09-10 02:54:41";s:1:"i";i:3;}','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('53','2010-09-10 02:54:41','24.161.42.157','http://dayboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:203;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-09-07 00:00:00";s:10:"actualtime";s:19:"2010-09-10 02:54:41";s:1:"i";i:4;}','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('54','2010-09-10 02:54:41','24.161.42.157','http://dayboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:203;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-09-07 00:00:00";s:10:"actualtime";s:19:"2010-09-10 02:54:41";s:1:"i";i:5;}','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('55','2010-09-21 23:21:39','75.213.104.95','http://dayboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:204;s:7:"isemail";b:1;s:9:"calltime:";s:19:"1970-01-01 00:00:00";s:10:"actualtime";s:19:"2010-09-21 23:21:39";s:1:"i";i:0;}','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('56','2010-09-21 23:21:41','75.213.104.95','http://dayboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:204;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-09-16 00:00:00";s:10:"actualtime";s:19:"2010-09-21 23:21:41";s:1:"i";i:1;}','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('57','2010-09-21 23:21:41','75.213.104.95','http://dayboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:204;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-09-21 00:00:00";s:10:"actualtime";s:19:"2010-09-21 23:21:41";s:1:"i";i:2;}','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('58','2010-09-21 23:21:41','75.213.104.95','http://dayboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:204;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-09-22 00:03:00";s:10:"actualtime";s:19:"2010-09-21 23:21:41";s:1:"i";i:4;}','');
INSERT INTO dayboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('59','2010-09-21 23:21:41','75.213.104.95','http://dayboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:204;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-09-22 00:03:00";s:10:"actualtime";s:19:"2010-09-21 23:21:41";s:1:"i";i:5;}','');


CREATE TABLE `insurance_type` (
  `insurance_type_id` int(11) NOT NULL auto_increment,
  `itype_name` varchar(50) default NULL,
  PRIMARY KEY  (`insurance_type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;



INSERT INTO dayboxx.insurance_type(`insurance_type_id`,`itype_name`) VALUES('1','medical');
INSERT INTO dayboxx.insurance_type(`insurance_type_id`,`itype_name`) VALUES('2','dental');
INSERT INTO dayboxx.insurance_type(`insurance_type_id`,`itype_name`) VALUES('3','eyeglasses');


CREATE TABLE `login` (
  `login_id` int(11) NOT NULL auto_increment,
  `password` varchar(50) default NULL,
  `username` varchar(150) default NULL,
  `email` varchar(144) default NULL,
  `is_active` tinyint(1) default NULL,
  `type` varchar(12) default NULL,
  PRIMARY KEY  (`login_id`)
) ENGINE=MyISAM AUTO_INCREMENT=55 DEFAULT CHARSET=latin1;



INSERT INTO dayboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('1','pool','worthington','bigfun@verizon.net','1','office');
INSERT INTO dayboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('3','pool','','manner@asecular.com','1','client');
INSERT INTO dayboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('4','pool','','manner@asecular.com','1','client');
INSERT INTO dayboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('5','pool','','manner3@asecular.com','1','client');
INSERT INTO dayboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('6','pool','','manner4@asecular.com','1','client');
INSERT INTO dayboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('7','pool','','goop@asecular.com','1','client');
INSERT INTO dayboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('8','pool','','goop@asecular.com','1','client');
INSERT INTO dayboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('9','pool','','goop@asecular.com','1','client');
INSERT INTO dayboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('10','pool','','goop@asecular.com','1','client');
INSERT INTO dayboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('11','pool','','goop@asecular.com','1','client');
INSERT INTO dayboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('15','pool','wockerman','goop@asecular.com','1','client');
INSERT INTO dayboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('16','pool','yorpwok','foop@pool.com','1','client');
INSERT INTO dayboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('17','pool','','foop@pool.com','1','client');
INSERT INTO dayboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('18','pool','','foop@pool.com','1','client');
INSERT INTO dayboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('19','pool','','foop@pool.com','1','client');
INSERT INTO dayboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('20','pool','','foop@pool.com','1','client');
INSERT INTO dayboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('21','!test','','jstohlmann@comcast.net','1','');
INSERT INTO dayboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('22','burdett','','','0','office');
INSERT INTO dayboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('23','handson','ciunas','info@ciunascentre.com','1','office');
INSERT INTO dayboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('24','','','','1','client');
INSERT INTO dayboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('25','','','','1','');
INSERT INTO dayboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('26','pool','','bigfun2@verizon.net','1','office');
INSERT INTO dayboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('27','pool','Bertyle','bigfun33@verizon.net','1','office');
INSERT INTO dayboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('46','VW7NZsNN','','izjfuluogyov.com','1','client');
INSERT INTO dayboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('30','','','','1','');
INSERT INTO dayboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('31','pool','sammycomputer','bigfun111@verizon.net','1','office');
INSERT INTO dayboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('32','','','','1','');
INSERT INTO dayboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('33','','','','1','');
INSERT INTO dayboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('34','pool','fiddlewoo-','bigfun222@verizon.net','1','office');
INSERT INTO dayboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('45','55Gu5O94','','jknslzsvmoik.com','1','client');
INSERT INTO dayboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('44','453453','beauty','denniso2323@gmail.com','1','office');
INSERT INTO dayboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('43','453453','curlys','citizenx2@zoho.com','1','office');
INSERT INTO dayboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('41','','','','1','');
INSERT INTO dayboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('42','pool','rickies','runcey@rickies.com','1','office');
INSERT INTO dayboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('47','kbvXcgEO','','ssztphfgblzb.com','1','client');
INSERT INTO dayboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('48','HTLgt5Gx','','eobxslwoebzx.com','1','client');
INSERT INTO dayboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('49','eYh09rCq','','knvciufwznvx.com','1','client');
INSERT INTO dayboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('50','vrnALa5n','','zbyfdzyqrszi.com','1','client');
INSERT INTO dayboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('51','YHheDmJd','','rdklapaahnzv.com','1','client');
INSERT INTO dayboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('52','aJgs3CcU','','eoiapusctkwk.com','1','client');
INSERT INTO dayboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('53','uRPp5o3v','','hiouxqucxlxa.com','1','client');
INSERT INTO dayboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('54','uRPp5o3v','','hiouxqucxlxa.com','1','client');


CREATE TABLE `mail_log` (
  `mail_log_id` int(11) NOT NULL auto_increment,
  `send_time` timestamp NULL default NULL,
  `address` varchar(99) default NULL,
  PRIMARY KEY  (`mail_log_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;





CREATE TABLE `marital_status` (
  `marital_status_id` int(11) NOT NULL auto_increment,
  `mstatus_name` varchar(50) default NULL,
  PRIMARY KEY  (`marital_status_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;



INSERT INTO dayboxx.marital_status(`marital_status_id`,`mstatus_name`) VALUES('1','single');
INSERT INTO dayboxx.marital_status(`marital_status_id`,`mstatus_name`) VALUES('2','married');
INSERT INTO dayboxx.marital_status(`marital_status_id`,`mstatus_name`) VALUES('3','divorced');
INSERT INTO dayboxx.marital_status(`marital_status_id`,`mstatus_name`) VALUES('4','widow/widower');


CREATE TABLE `mysql_errorlog` (
  `mysql_errorlog_id` int(11) NOT NULL auto_increment,
  `time_done` timestamp NULL default NULL,
  `ip_address` varchar(33) default NULL,
  `mysql_error` text,
  `info` text,
  `sql_query` text,
  PRIMARY KEY  (`mysql_errorlog_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;





CREATE TABLE `office` (
  `office_id` int(11) NOT NULL auto_increment,
  `login_id` int(11) default NULL,
  `office_name` varchar(50) default NULL,
  `subdomain` varchar(50) default NULL,
  `address` varchar(50) default NULL,
  `city` varchar(50) default NULL,
  `state_code` varchar(3) default NULL,
  `zip` varchar(20) default NULL,
  `email` varchar(50) default NULL,
  `phone` varchar(50) default NULL,
  `timezone_id` int(11) default NULL,
  `contact_info` varchar(50) default NULL,
  `doctor_number` varchar(50) default NULL,
  `staff_number` varchar(50) default NULL,
  `patients_per_day` varchar(50) default NULL,
  `scheduling_unit_size` int(11) default NULL,
  `hours_open` varchar(50) default NULL,
  `days_open` varchar(50) default NULL,
  `midday_closed` varchar(50) default NULL,
  `holidays` varchar(50) default NULL,
  `call_type_id` int(11) default NULL,
  `is_office` varchar(1) default NULL,
  `is_active` tinyint(1) default NULL,
  `date_created` datetime default NULL,
  `date_lastvisited` datetime default NULL,
  `visitcount` int(11) default NULL,
  `office_text` text,
  `first_email` int(11) default NULL,
  `second_email` int(11) default NULL,
  `third_email` int(11) default NULL,
  `first_phonecall` int(11) default NULL,
  `second_phonecall` int(11) default NULL,
  `third_phonecall` int(11) default NULL,
  `phonecall_time` int(11) default NULL,
  PRIMARY KEY  (`office_id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;



INSERT INTO dayboxx.office(`office_id`,`login_id`,`office_name`,`subdomain`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('1','1','Worthington Medical Facility','worthington','322 Milva Parkway','Dougston','DE','28121','bigfun@verizon.net','2221212212','7','Call for Phillip Morris','22','121','233','15','9*17','1*5','12*13','12/25 01/01 thanksgiving','0','1','1','2010-04-27 17:09:00','2010-04-27 17:09:00','1','Not only do we have CATscanners and FMRI, we also have stethoscopes.','18','9','0','1','0','0','10');
INSERT INTO dayboxx.office(`office_id`,`login_id`,`office_name`,`subdomain`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('3','4','','','422 Silver Parkway','Dallas','MD','22211','manner@asecular.com','','7','','','','','0','','','','','0','0','1','2010-05-02 10:11:15','2010-05-02 10:11:15','1','','0','0','0','0','0','0','0');
INSERT INTO dayboxx.office(`office_id`,`login_id`,`office_name`,`subdomain`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('4','22','Burdett Orthopedics','Burdett','2200 Burdett Ave.','Troy','NY','12180','','(518)272-0332','7','','3','10','20','20','9*17','1*5','12*13','12/25 01/01 thanksgiving','0','1','0','2010-05-06 17:38:07','2010-05-06 17:38:07','1','','14','7','1','1','0','0','18');
INSERT INTO dayboxx.office(`office_id`,`login_id`,`office_name`,`subdomain`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('5','23','ciunas','ciunas','The Old Creamery','Feakle  Co. Clare, Ireland','','0000','info@ciunascentre.com','353876236292','1','','','','','30','9*17','1*5','12*13','12/25 01/01 thanksgiving','0','1','1','2010-05-09 20:51:53','2010-05-09 20:51:53','1','We are located in a fully accessible warm and welcoming centre in Feakle, Co. Clare.  We have a fexible schedule and are there to support you for the long or short term.  ','0','0','0','0','0','0','0');
INSERT INTO dayboxx.office(`office_id`,`login_id`,`office_name`,`subdomain`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('6','26','Florence Medical Center','florence','121 Florence Drive','Florence','FL','31121','bigfun2@verizon.net','4443334433','7','121 Florence Drive Florence FL','12','33','444','15','9*17','1*5','12*13','12/25 01/01 thanksgiving','0','1','0','2010-05-17 15:54:01','2010-05-17 15:54:01','1','Florence is a full-on medical center.','18','9','0','0','0','0','10');
INSERT INTO dayboxx.office(`office_id`,`login_id`,`office_name`,`subdomain`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('7','27','Bertyle Associates','Bertyle','112 Gilver Street','Hollywood','AB','12211','bigfun33@verizon.net','4443334433','4','','','','','15','9*17','1*5','12*13','12/25 01/01 thanksgiving','0','1','0','2010-05-21 17:51:52','2010-05-21 17:51:52','1','','18','9','0','1','0','0','10');
INSERT INTO dayboxx.office(`office_id`,`login_id`,`office_name`,`subdomain`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('22','42','ricky's','rickies','419 Widdle Lane','Runcey','AZ','88772','runcey@rickies.com','2221212212','9','','','','','15','9*17','1*5','12*13','12/25 01/01 thanksgiving','','1','','2010-07-30 14:55:38','2010-07-30 14:55:38','1','','18','9','0','1','0','0','19');
INSERT INTO dayboxx.office(`office_id`,`login_id`,`office_name`,`subdomain`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('11','31','Sammy's Computer Repair','sammycomputer','122 Hot Latina At the Fair Way','Macy','AZ','89221','bigfun111@verizon.net','6443334993','9','','','','','15','9*17','1*5','12*13','12/25 01/01 thanksgiving','','1','','2010-07-29 21:20:13','2010-07-29 21:20:13','1','','18','9','0','1','0','0','19');
INSERT INTO dayboxx.office(`office_id`,`login_id`,`office_name`,`subdomain`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('23','43','Curley's Nail Salon','curleys','22 Front St','Kingston','ID','44343','citizenx2@zoho.com','917604575','7','fred firth','2','4','13','15','9*21','1*5','12*13','12/25 01/01 thanksgiving','0','1','1','2010-07-30 19:48:06','2010-07-30 19:48:06','1','IN THE HOCKING HILLS','0','7','2','1','0','0','19');
INSERT INTO dayboxx.office(`office_id`,`login_id`,`office_name`,`subdomain`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('24','44','Beauty Bar','beauty','21 Wall St','Kingston','CT','45333','denniso2323@gmail.com','9176504575','7','Nancy Firth','4','2','15','15','9*21','1*5','12*13','12/25 01/01 thanksgiving','','1','','2010-07-30 20:28:47','2010-07-30 20:28:47','1','xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx','0','7','2','1','0','0','19');
INSERT INTO dayboxx.office(`office_id`,`login_id`,`office_name`,`subdomain`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('14','34','fiddlewoo nails','fiddlewoo-','155 Rickler Street','Little Rock','AR','22111','bigfun222@verizon.net','','8','','','','','15','9*17','1*5','12*13','12/25 01/01 thanksgiving','','1','','2010-07-29 22:19:19','2010-07-29 22:19:19','1','','18','9','0','1','0','0','19');
INSERT INTO dayboxx.office(`office_id`,`login_id`,`office_name`,`subdomain`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('25','27','54654645654','','','','','','','','0','','','','','0','','','','','0','','','1970-01-01 00:00:00','1970-01-01 00:00:00','0','','0','0','0','0','0','0','0');
INSERT INTO dayboxx.office(`office_id`,`login_id`,`office_name`,`subdomain`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('26','0','rrr','rr','rr','','','','','','0','','','','','0','','','','','0','','','1970-01-01 00:00:00','1970-01-01 00:00:00','0','','0','0','0','0','0','0','0');
INSERT INTO dayboxx.office(`office_id`,`login_id`,`office_name`,`subdomain`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('27','0','ee','eee','','','','','','','0','','','','','0','','','','','0','','','1970-01-01 00:00:00','1970-01-01 00:00:00','0','','0','0','0','0','0','0','0');


CREATE TABLE `personal_calendar_event` (
  `calendar_event_id` int(11) NOT NULL auto_increment,
  `datecode` varchar(8) default NULL,
  `recurrence_id` int(11) default NULL,
  `time` varchar(10) default NULL,
  `duration` int(11) default NULL,
  `practitioner_id` int(11) default NULL,
  `type` varchar(40) default NULL,
  `notes` text,
  `office_id` int(11) default NULL,
  `client_id` int(11) default NULL,
  `sort_id` int(11) default NULL,
  `event_status_id` int(11) default NULL,
  `no_phone` tinyint(1) default NULL,
  PRIMARY KEY  (`calendar_event_id`)
) ENGINE=MyISAM AUTO_INCREMENT=205 DEFAULT CHARSET=latin1;



INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('60','100216','0','12:0','240','103','man manner','watch out for this guy he is crazy. i wouldn&#39;t trust him. he steals unattended drugs!','1','9','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('62','100217','0','9:45','60','1','','yeah and stuff','1','28','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('70','100219','0','10:45','60','3','','','1','28','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('65','100219','0','12:15','120','3','','','1','9','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('71','100218','0','16:30','240','103','','mona wong','1','8','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('72','100218','0','10:15','15','103','','','1','27','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('73','100217','0','10:0','30','2','','','1','9','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('74','100218','0','10:15','300','4','','save my baby!','1','10','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('75','100218','0','14:0','45','103','','','1','28','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('76','100220','0','10:45','240','103','','it&#39;s gonna take awhile, dude is in bad shape!','1','8','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('77','100225','0','10:45','240','103','','scary disease!','1','28','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('78','100219','0','10:0','60','103','','','1','28','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('79','100217','0','10:15','60','3','','sort of mischievious','1','30','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('80','100215','0','10:15','240','3','','fun kid!','1','30','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('81','100217','0','9:0','240','103','','fun okay kind of kid','1','30','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('82','100215','0','10:30','90','1','','','1','30','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('83','100225','0','13:45','30','1','','','1','30','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('84','100218','0','10:45','60','103','','vasectomy','1','28','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('85','100223','0','10:15','60','103','','triple vasectomy!','1','28','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('86','100219','0','10:30','60','103','','','1','28','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('87','100215','0','10:0','120','103','','','1','28','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('88','100226','0','10:0','240','103','','','1','31','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('89','100227','0','12:0','15','103','','','1','40','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('90','100224','0','10:30','240','3','','','1','40','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('91','100226','0','9:45','120','3','','','1','40','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('92','100225','0','9:45','60','3','','','1','7','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('93','100222','0','12:30','60','103','','','1','8','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('94','100305','0','10:0','60','3','','nasal','1','7','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('100','100224','0','13:15','60','103','','ww','1','28','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('101','100224','0','13:15','60','103','','dude!!!','1','44','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('102','100224','0','9:45','60','103','','wow!','1','44','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('103','100223','0','13:45','60','103','','','1','44','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('104','100226','0','15:0','60','103','','!!','1','44','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('189','100526','0','10:45','60','103','','','1','19','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('188','100603','0','11:0','60','106','','','5','34','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('187','100601','0','11:0','60','106','','','5','34','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('111','100820','0','10:45','60','103','','','1','44','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('112','101011','0','9:0','60','3','','spaghetti nerves','1','44','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('113','100906','0','10:15','60','3','','octopus eyes','1','44','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('114','100802','0','10:0','60','3','','','1','44','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('115','100930','0','9:15','60','3','','','1','28','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('116','101001','0','9:15','60','2','','','1','28','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('117','100930','0','14:30','60','2','','','1','44','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('118','100928','0','11:15','60','2','','','1','44','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('119','100927','0','13:30','60','2','','','1','44','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('120','100301','0','10:45','60','1','','','1','28','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('121','100301','0','11:30','5','103','','','1','31','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('122','100301','0','10:45','10','103','','','1','7','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('123','100303','0','10:0','30','103','','shot','1','31','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('124','100303','0','10:15','5','103','','suture removal','1','28','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('125','100225','0','13:45','60','103','','','1','28','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('126','100225','0','10:0','45','3','','check up','1','28','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('127','100304','0','10:15','30','3','','this is an edit','1','28','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('128','100304','0','10:30','5','3','','recall','1','31','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('129','100222','0','10:45','60','3','','','1','44','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('130','100303','0','10:0','60','103','','yea!!','1','28','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('131','100304','0','11:15','60','103','','','1','28','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('132','100304','0','11:15','60','103','','','1','28','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('133','100312','0','11:0','60','103','','oucher!!!','1','28','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('134','100312','0','14:15','60','103','','','1','31','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('135','100312','0','15:45','60','103','','','1','44','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('136','100301','0','11:30','5','103','','','1','28','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('138','100329','0','10:15','10','103','','','1','28','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('139','100329','0','11:15','60','103','','','1','28','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('140','100402','0','10:30','5','103','','','1','28','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('141','100408','0','10:30','60','104','','','52','53','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('142','100409','0','10:30','60','104','','','52','53','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('143','100408','0','13:0','60','104','','','52','53','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('144','100409','0','13:45','60','104','','','52','54','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('145','100408','0','15:30','60','104','','','52','54','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('146','100406','0','9:30','60','104','','','52','53','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('147','100412','0','10:15','60','104','','','52','53','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('148','100412','0','12:15','60','104','','','52','54','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('149','100413','0','12:0','60','104','','','52','54','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('150','100413','0','10:0','60','104','','','52','54','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('151','100414','0','10:15','60','104','','','52','54','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('152','100416','0','10:45','360','104','','','52','54','0','3','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('153','100417','0','10:45','300','104','','','52','53','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('154','100411','0','10:15','60','104','','','52','54','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('155','100411','0','12:15','60','104','','','52','53','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('156','100417','0','9:45','15','104','','','52','53','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('157','100415','0','14:15','300','104','','','52','53','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('158','100415','0','10:15','60','104','','','52','54','0','2','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('159','100413','0','14:30','60','104','','','52','54','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('160','100414','0','15:0','60','104','','','52','53','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('161','100417','0','11:15','60','103','','','1','28','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('162','100417','0','13:15','60','103','','','1','28','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('163','100416','0','14:15','60','103','','','1','28','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('164','100417','0','14:45','60','103','','','1','28','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('165','100419','0','10:0','15','3','','check sutures','1','56','0','4','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('166','100419','0','10:15','15','3','','crown delivery','1','57','0','4','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('167','100419','0','10:0','60','3','','crown prep','1','58','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('168','100423','0','10:30','60','103','','','1','28','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('169','100423','0','10:30','60','103','','','1','44','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('170','100423','0','10:45','5','103','','','1','9','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('171','100428','0','11:0','15','3','','exam','1','28','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('172','100421','0','10:45','30','2','','exam','1','28','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('173','691231','0','10:0','60','103','','werwer','1','12','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('174','100609','0','10:45','60','103','','dasd asd sad ','1','12','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('175','100504','0','10:0','240','103','','','1','9','0','4','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('177','100505','0','11:0','60','103','','','1','16','0','2','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('178','100421','0','10:15','60','103','','','1','16','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('179','100512','0','10:30','60','103','','','1','12','0','2','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('180','100512','0','10:30','60','103','','','1','21','0','2','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('181','100512','0','10:30','60','103','','','1','9','0','2','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('182','100420','0','11:30','60','1','','','1','12','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('183','100514','0','11:45','360','3','','they need a lot of work done.','1','16','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('184','100514','0','11:45','60','3','','party','1','12','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('185','100528','0','9:30','60','106','','','5','32','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('186','100218','0','10:15','300','4','','save my baby!','1','0','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('190','100526','0','10:0','60','106','','','5','33','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('191','100527','0','10:15','60','3','','','1','17','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('192','100525','0','10:30','60','106','','','5','34','0','0','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('193','100602','','10:30','60','103','','','1','17','','','');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('194','100728','','11:30','60','112','','','24','36','','1','0');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('195','100803','','10:30','60','111','','','24','36','','1','0');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('196','100804','','13:45','60','111','','','24','36','','1','0');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('197','100803','','13:15','60','111','','','24','37','','1','0');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('198','100805','','10:30','60','111','','','24','37','','1','0');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('199','100805','','10:30','60','114','','','24','36','','1','0');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('200','100806','','11:15','60','114','','','24','36','','1','0');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('201','100806','','13:30','60','115','','','24','37','','1','0');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('202','100910','','11:0','15','110','','','23','22','','1','0');
INSERT INTO dayboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('203','100907','','10:0','300','110','','','23','22','','2','1');


CREATE TABLE `phone_call` (
  `phone_call_id` int(11) NOT NULL auto_increment,
  `phonecall_only` tinyint(1) default NULL,
  `email_only` tinyint(1) default NULL,
  `phone_number` varchar(40) default NULL,
  `timezone` int(11) default NULL,
  `call_content` text,
  `time_to_start` datetime default NULL,
  `call_type_id` int(11) default NULL,
  `attempt_count` int(11) default NULL,
  `phonecall_status_id` int(11) default NULL,
  `completed` tinyint(1) default NULL,
  `abandoned` tinyint(1) default NULL,
  `last_attempt` datetime default NULL,
  `office_id` int(11) default NULL,
  `callee_id` int(11) default NULL,
  `suid` varchar(50) NOT NULL,
  `expiry_date` datetime NOT NULL,
  `calendar_event_id` int(11) default NULL,
  `email_content` text,
  `email_sent` tinyint(1) default NULL,
  `reminder_type` int(11) default NULL,
  PRIMARY KEY  (`phone_call_id`)
) ENGINE=MyISAM AUTO_INCREMENT=149 DEFAULT CHARSET=latin1;



INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('1','','','0013026910104','0','Hello, this is a call from Dr. Thoreaus office reminding you that you have an appointment scheduled for 3:30pm on Tuesday, December 29th. If you cannot make this appointment, please let us know by calling us at 2232212244. Thank you!','2010-03-23 12:19:00','4','37','','1','0','2010-03-23 12:20:11','0','0','348e027832b6c3da82313e82457c6309','1999-11-30 00:00:00','0','','0','0');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('2','','','19176504575','0','This is a call from Kingston Medical Center reminding you of your appointment for 2:15 pm on Friday March 12th. If you have any questions please call 845 340 1090. Thank you.','2010-03-22 12:19:00','4','39','','1','0','2010-03-28 19:54:07','0','0','975e9c007458a58ed600333c2bb9d2e4','1999-11-30 00:00:00','0','','0','0');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('3','','','18453401090','0','This is a call from Kingston Medical Center reminding you of your appointment for 2:15 pm on Friday March 12th. If you have any questions please call 845 340 1090. Thank you.','2010-03-22 12:49:00','4','40','','1','0','2010-03-23 19:34:09','0','0','5f0fe035b37079847867ef586bd1d11b','2019-11-30 00:00:00','0','','0','0');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('5','','','19176504575','-5','This is a call from Kingston Medical Center reminding you of your appointment for 11:15 am on Monday March 29th. If you have any questions please call 845 340 1090. Thank you.','2010-03-28 15:08:00','1','9','','1','0','2010-03-28 19:54:07','1','28','975e9c007458a58ed600333c2bb9d2e4','2010-03-29 11:15:00','139','Dear Dennis Dennis,
This is a message from Kingston Medical Center reminding you of your appointment for 11:15 am on Monday March 29th with Dawn Parklington. If you have any questions please call 845 340 1090.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=|FzQS9-OK9-PKW-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=|kTp4L-J-hM-JhVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=|-OO9uS94O9-KXp-TdCbNW
Thank you.
Kingston Medical Center','0','0');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('6','','','19176504575','-5','This is a call from Kingston Medical Center reminding you of your appointment for 10:30 am on Friday April 2nd. If you have any questions please call 845 340 1090. Thank you.','2010-04-01 15:00:00','1','0','','1','0','1970-01-01 00:00:00','1','28','','2010-04-02 10:30:00','140','Dear Dennis Dennis,
This is a message from Kingston Medical Center reminding you of your appointment for 10:30 am on Friday April 2nd with Dawn Parklington. If you have any questions please call 845 340 1090.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=|FzQS9-OK9-PKW-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=|kTp4L-J-hM-JhVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=|-OO9uS94O9-KXp-TdCbNW
Thank you.
Kingston Medical Center','0','0');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('35','','','18453401090','-5','This is a call from Elmira Hospital reminding you of your appointment for 1:45 pm on Friday April 9th. If you have any questions please call 7436778433. Thank you.','2010-04-07 15:00:00','1','0','','1','0','0000-00-00 00:00:00','52','54','','2010-04-09 13:45:00','144','Dear Gus Mueller,

This is a message from Elmira Hospital reminding you of your appointment for 1:45 pm on Friday April 9th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=|BzuS9-hL9-PKW-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=|-hMz4N9GM-JhVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=|kR9uK9-EO9-KXp-TdCbNW

Thank you.
Elmira Hospital','1','1');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('34','','','18453401090','-5','This is a call from Elmira Hospital reminding you of your appointment for 1:45 pm on Friday April 9th. If you have any questions please call 7436778433. Thank you.','2010-04-08 15:00:00','1','0','','1','0','0000-00-00 00:00:00','52','54','','2010-04-09 13:45:00','144','Dear Gus Mueller,

This is a message from Elmira Hospital reminding you of your appointment for 1:45 pm on Friday April 9th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=|BzuS9-hL9-PKW-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=|-hMz4N9GM-JhVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=|kR9uK9-EO9-KXp-TdCbNW

Thank you.
Elmira Hospital','1','0');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('33','','','19176504575','-5','This is a call from Elmira Hospital reminding you of your appointment for 10:30 am on Friday April 9th. If you have any questions please call 7436778433. Thank you.','2010-04-06 15:00:00','1','0','','1','0','0000-00-00 00:00:00','52','53','','2010-04-09 10:30:00','142','Dear Dennis Opp,

This is a message from Elmira Hospital reminding you of your appointment for 10:30 am on Friday April 9th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=|AzuO9-hL9-PKW-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=|-XMzQN9GM-JhVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=|aR9GK9-EO9-KXp-TdCbNW

Thank you.
Elmira Hospital','1','2');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('32','','','19176504575','-5','This is a call from Elmira Hospital reminding you of your appointment for 10:30 am on Friday April 9th. If you have any questions please call 7436778433. Thank you.','2010-04-07 15:00:00','1','0','','1','0','0000-00-00 00:00:00','52','53','','2010-04-09 10:30:00','142','Dear Dennis Opp,

This is a message from Elmira Hospital reminding you of your appointment for 10:30 am on Friday April 9th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=|AzuO9-hL9-PKW-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=|-XMzQN9GM-JhVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=|aR9GK9-EO9-KXp-TdCbNW

Thank you.
Elmira Hospital','1','1');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('31','','','19176504575','-5','This is a call from Elmira Hospital reminding you of your appointment for 10:30 am on Friday April 9th. If you have any questions please call 7436778433. Thank you.','2010-04-08 15:00:00','1','0','','1','0','0000-00-00 00:00:00','52','53','','2010-04-09 10:30:00','142','Dear Dennis Opp,

This is a message from Elmira Hospital reminding you of your appointment for 10:30 am on Friday April 9th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=|AzuO9-hL9-PKW-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=|-XMzQN9GM-JhVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=|aR9GK9-EO9-KXp-TdCbNW

Thank you.
Elmira Hospital','1','0');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('30','','','19176504575','-5','This is a call from Elmira Hospital reminding you of your appointment for 10:30 am on Thursday April 8th. If you have any questions please call 7436778433. Thank you.','2010-04-06 15:00:00','1','0','','1','0','0000-00-00 00:00:00','52','53','','2010-04-08 10:30:00','141','Dear Dennis Opp,

This is a message from Elmira Hospital reminding you of your appointment for 10:30 am on Thursday April 8th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=|AzuO9-hL9-PKW-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=|-XMzQN9GM-JhVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=|aR9GK9-EO9-KXp-TdCbNW

Thank you.
Elmira Hospital','1','1');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('29','','','19176504575','-5','This is a call from Elmira Hospital reminding you of your appointment for 10:30 am on Thursday April 8th. If you have any questions please call 7436778433. Thank you.','2010-04-07 15:00:00','1','0','','1','0','0000-00-00 00:00:00','52','53','','2010-04-08 10:30:00','141','Dear Dennis Opp,

This is a message from Elmira Hospital reminding you of your appointment for 10:30 am on Thursday April 8th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=|AzuO9-hL9-PKW-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=|-XMzQN9GM-JhVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=|aR9GK9-EO9-KXp-TdCbNW

Thank you.
Elmira Hospital','1','0');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('36','','','18453401090','-5','This is a call from Elmira Hospital reminding you of your appointment for 3:30 pm on Thursday April 8th. If you have any questions please call 7436778433. Thank you.','2010-04-07 15:00:00','1','0','','1','0','0000-00-00 00:00:00','52','54','','2010-04-08 15:30:00','145','Dear Gus Mueller,

This is a message from Elmira Hospital reminding you of your appointment for 3:30 pm on Thursday April 8th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=|BzuS9-hL9-PKW-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=|-hMz4N9GM-JhVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=|kR9uK9-EO9-KXp-TdCbNW

Thank you.
Elmira Hospital','1','0');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('37','','','19176504575','-5','This is a call from Elmira Hospital reminding you of your appointment for 10:15 am on Monday April 12th. If you have any questions please call 7436778433. Thank you.','2010-04-11 15:00:00','1','0','','1','0','0000-00-00 00:00:00','52','53','','2010-04-12 10:15:00','147','Dear Dennis Opp,

This is a message from Elmira Hospital reminding you of your appointment for 10:15 am on Monday April 12th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=|AzuO9-hL9-PKW-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=|-XMzQN9GM-JhVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=|aR9GK9-EO9-KXp-TdCbNW

Thank you.
Elmira Hospital','1','0');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('38','','','18453401090','-5','This is a call from Elmira Hospital reminding you of your appointment for 12:15 pm on Monday April 12th. If you have any questions please call 7436778433. Thank you.','2010-04-11 15:00:00','1','0','','1','0','0000-00-00 00:00:00','52','54','','2010-04-12 12:15:00','148','Dear Gus Mueller,

This is a message from Elmira Hospital reminding you of your appointment for 12:15 pm on Monday April 12th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=|BzuS9-hL9-PKW-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=|-hMz4N9GM-JhVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=|kR9uK9-EO9-KXp-TdCbNW

Thank you.
Elmira Hospital','1','0');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('39','','','18453401090','-5','This is a call from Elmira Hospital reminding you of your appointment for 12:00 pm on Tuesday April 13th. If you have any questions please call 7436778433. Thank you.','2010-04-12 15:00:00','1','0','','1','0','0000-00-00 00:00:00','52','54','','2010-04-13 12:00:00','149','Dear Gus Mueller,

This is a message from Elmira Hospital reminding you of your appointment for 12:00 pm on Tuesday April 13th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=|BzuS9-hL9-PKW-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=|-hMz4N9GM-JhVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=|kR9uK9-EO9-KXp-TdCbNW

Thank you.
Elmira Hospital','1','0');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('40','','','18453401090','-5','This is a call from Elmira Hospital reminding you of your appointment for 12:00 pm on Tuesday April 13th. If you have any questions please call 7436778433. Thank you.','2010-04-11 15:00:00','1','0','','1','0','0000-00-00 00:00:00','52','54','','2010-04-13 12:00:00','149','Dear Gus Mueller,

This is a message from Elmira Hospital reminding you of your appointment for 12:00 pm on Tuesday April 13th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=|BzuS9-hL9-PKW-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=|-hMz4N9GM-JhVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=|kR9uK9-EO9-KXp-TdCbNW

Thank you.
Elmira Hospital','1','1');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('41','','','18453401090','-5','This is a call from Elmira Hospital reminding you of your appointment for 10:00 am on Tuesday April 13th. If you have any questions please call 7436778433. Thank you.','2010-04-12 15:00:00','1','0','','1','0','0000-00-00 00:00:00','52','54','','2010-04-13 10:00:00','150','Dear Gus Mueller,

This is a message from Elmira Hospital reminding you of your appointment for 10:00 am on Tuesday April 13th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=|BzuS9-hL9-PKW-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=|-hMz4N9GM-JhVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=|kR9uK9-EO9-KXp-TdCbNW

Thank you.
Elmira Hospital','1','0');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('42','','','18453401090','-5','This is a call from Elmira Hospital reminding you of your appointment for 10:00 am on Tuesday April 13th. If you have any questions please call 7436778433. Thank you.','2010-04-11 15:00:00','1','0','','1','0','0000-00-00 00:00:00','52','54','','2010-04-13 10:00:00','150','Dear Gus Mueller,

This is a message from Elmira Hospital reminding you of your appointment for 10:00 am on Tuesday April 13th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=|BzuS9-hL9-PKW-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=|-hMz4N9GM-JhVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=|kR9uK9-EO9-KXp-TdCbNW

Thank you.
Elmira Hospital','1','1');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('43','','','18453401090','-5','This is a call from Elmira Hospital reminding you of your appointment for 10:15 am on Wednesday April 14th. If you have any questions please call 7436778433. Thank you.','2010-04-13 15:00:00','1','0','','1','0','0000-00-00 00:00:00','52','54','','2010-04-14 10:15:00','151','Dear Gus Mueller,

This is a message from Elmira Hospital reminding you of your appointment for 10:15 am on Wednesday April 14th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=|BzuS9-hL9-PKW-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=|-hMz4N9GM-JhVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=|kR9uK9-EO9-KXp-TdCbNW

Thank you.
Elmira Hospital','1','0');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('44','','','18453401090','-5','This is a call from Elmira Hospital reminding you of your appointment for 10:15 am on Wednesday April 14th. If you have any questions please call 7436778433. Thank you.','2010-04-12 15:00:00','1','0','','1','0','0000-00-00 00:00:00','52','54','','2010-04-14 10:15:00','151','Dear Gus Mueller,

This is a message from Elmira Hospital reminding you of your appointment for 10:15 am on Wednesday April 14th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=|BzuS9-hL9-PKW-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=|-hMz4N9GM-JhVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=|kR9uK9-EO9-KXp-TdCbNW

Thank you.
Elmira Hospital','1','1');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('45','','','18453401090','-5','This is a call from Elmira Hospital reminding you of your appointment for 10:15 am on Wednesday April 14th. If you have any questions please call 7436778433. Thank you.','2010-04-11 15:00:00','1','0','','1','0','0000-00-00 00:00:00','52','54','','2010-04-14 10:15:00','151','Dear Gus Mueller,

This is a message from Elmira Hospital reminding you of your appointment for 10:15 am on Wednesday April 14th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=|BzuS9-hL9-PKW-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=|-hMz4N9GM-JhVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=|kR9uK9-EO9-KXp-TdCbNW

Thank you.
Elmira Hospital','1','2');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('52','','','18453401090','-5','This is a call from Elmira Hospital reminding you of your appointment for 10:45 am on Friday April 16th. If you have any questions please call 7436778433. Thank you.','2010-04-15 15:00:00','1','0','','1','0','0000-00-00 00:00:00','52','54','','2010-04-16 10:45:00','152','Dear Gus Mueller,

This is a message from Elmira Hospital reminding you of your appointment for 10:45 am on Friday April 16th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=JpuL-J-XP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=-NMz-YM9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=QR9-OTzHO9LXp-TdCbNW

Thank you.
Elmira Hospital','1','0');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('53','','','18453401090','-5','This is a call from Elmira Hospital reminding you of your appointment for 10:45 am on Friday April 16th. If you have any questions please call 7436778433. Thank you.','2010-04-14 15:00:00','1','0','','1','0','0000-00-00 00:00:00','52','54','','2010-04-16 10:45:00','152','Dear Gus Mueller,

This is a message from Elmira Hospital reminding you of your appointment for 10:45 am on Friday April 16th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=JpuL-J-XP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=-NMz-YM9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=QR9-OTzHO9LXp-TdCbNW

Thank you.
Elmira Hospital','1','1');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('48','','','18453401090','-5','This is a call from Elmira Hospital reminding you of your appointment for 10:45 am on Friday April 16th. If you have any questions please call 7436778433. Thank you.','2010-04-12 15:00:00','1','0','','1','0','1970-01-01 00:00:00','52','54','','2010-04-16 10:45:00','152','Dear Gus Mueller,

This is a message from Elmira Hospital reminding you of your appointment for 10:45 am on Friday April 16th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=|BzuS9-hL9-PKW-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=|-hMz4N9GM-JhVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=|kR9uK9-EO9-KXp-TdCbNW

Thank you.
Elmira Hospital','1','2');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('56','','','19176504575','-5','This is a call from Elmira Hospital reminding you of your appointment for 10:45 am on Saturday April 17th. If you have any questions please call 7436778433. Thank you.','2010-04-11 15:00:00','1','0','','1','0','1970-01-01 00:00:00','52','53','','2010-04-17 10:45:00','153','Dear Dennis Opp,

This is a message from Elmira Hospital reminding you of your appointment for 10:45 am on Saturday April 17th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=AzuP9-hP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=-XMzaN9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=aR9QK9HO9LXp-TdCbNW

Thank you.
Elmira Hospital','1','2');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('55','','','19176504575','-5','This is a call from Elmira Hospital reminding you of your appointment for 10:45 am on Saturday April 17th. If you have any questions please call 7436778433. Thank you.','2010-04-15 15:00:00','1','0','','1','0','0000-00-00 00:00:00','52','53','','2010-04-17 10:45:00','153','Dear Dennis Opp,

This is a message from Elmira Hospital reminding you of your appointment for 10:45 am on Saturday April 17th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=AzuP9-hP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=-XMzaN9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=aR9QK9HO9LXp-TdCbNW

Thank you.
Elmira Hospital','1','1');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('54','','','19176504575','-5','This is a call from Elmira Hospital reminding you of your appointment for 10:45 am on Saturday April 17th. If you have any questions please call 7436778433. Thank you.','2010-04-16 15:00:00','1','0','','1','0','0000-00-00 00:00:00','52','53','','2010-04-17 10:45:00','153','Dear Dennis Opp,

This is a message from Elmira Hospital reminding you of your appointment for 10:45 am on Saturday April 17th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=AzuP9-hP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=-XMzaN9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=aR9QK9HO9LXp-TdCbNW

Thank you.
Elmira Hospital','1','0');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('57','','','19176504575','-5','This is a call from Elmira Hospital reminding you of your appointment for 9:45 am on Saturday April 17th. If you have any questions please call 7436778433. Thank you.','2010-04-11 15:00:00','1','0','','1','0','1970-01-01 00:00:00','52','53','','2010-04-17 09:45:00','156','Dear Dennis Opp,

This is a message from Elmira Hospital reminding you of your appointment for 9:45 am on Saturday April 17th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=DzuR9GP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=QMzuO9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=4R9kL9HO9LXp-TdCbNW

Thank you.
Elmira Hospital','1','0');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('58','','','19176504575','-5','This is a call from Elmira Hospital reminding you of your appointment for 9:45 am on Saturday April 17th. If you have any questions please call 7436778433. Thank you.','2010-04-11 15:00:00','1','0','','1','0','1970-01-01 00:00:00','52','53','','2010-04-17 09:45:00','156','Dear Dennis Opp,

This is a message from Elmira Hospital reminding you of your appointment for 9:45 am on Saturday April 17th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=DzuR9GP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=QMzuO9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=4R9kL9HO9LXp-TdCbNW

Thank you.
Elmira Hospital','1','1');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('59','','','19176504575','-5','This is a call from Elmira Hospital reminding you of your appointment for 9:45 am on Saturday April 17th. If you have any questions please call 7436778433. Thank you.','2010-04-11 15:00:00','1','0','','1','0','1970-01-01 00:00:00','52','53','','2010-04-17 09:45:00','156','Dear Dennis Opp,

This is a message from Elmira Hospital reminding you of your appointment for 9:45 am on Saturday April 17th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=DzuR9GP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=QMzuO9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=4R9kL9HO9LXp-TdCbNW

Thank you.
Elmira Hospital','1','2');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('60','','','19176504575','-5','This is a call from Elmira Hospital reminding you of your appointment for 2:15 pm on Thursday April 15th. If you have any questions please call 7436778433. Thank you.','2010-04-11 15:00:00','1','0','','1','0','1970-01-01 00:00:00','52','53','','2010-04-15 14:15:00','157','Dear Dennis Opp,

This is a message from Elmira Hospital reminding you of your appointment for 2:15 pm on Thursday April 15th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=EzuL-JGP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=aMz-YO9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-ER9-OL9HO9LXp-TdCbNW

Thank you.
Elmira Hospital','1','0');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('61','','','18453401090','-5','This is a call from Elmira Hospital reminding you of your appointment for 10:15 am on Thursday April 15th. If you have any questions please call 7436778433. Thank you.','2010-04-11 15:00:00','1','0','','1','0','1970-01-01 00:00:00','52','54','','2010-04-15 10:15:00','158','Dear Gus Mueller,

This is a message from Elmira Hospital reminding you of your appointment for 10:15 am on Thursday April 15th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=FzuP9QP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=kMzaP9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-OR9QM9HO9LXp-TdCbNW

Thank you.
Elmira Hospital','1','0');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('62','','','845 246 5599','-5','This is a call from Kingston Medical Center reminding you of your appointment for 10:00 am on Monday April 19th. If you have any questions please call 845 340 1090. Thank you.','2010-04-18 23:00:00','1','0','','1','0','0000-00-00 00:00:00','1','56','','2010-04-19 10:00:00','165','Dear Laura Powell,

This is a message from Kingston Medical Center reminding you of your appointment for 10:00 am on Monday April 19th with Dr. Nigel Matthews. If you have any questions please call 845 340 1090.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Cz4N9uP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=GNzGS9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=uS9-hP9HO9LXp-TdCbNW

Thank you.
Kingston Medical Center','1','0');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('63','','','845 246 5599','-5','This is a call from Kingston Medical Center reminding you of your appointment for 10:00 am on Monday April 19th. If you have any questions please call 845 340 1090. Thank you.','2010-04-17 23:00:00','1','0','','1','0','0000-00-00 00:00:00','1','56','','2010-04-19 10:00:00','165','Dear Laura Powell,

This is a message from Kingston Medical Center reminding you of your appointment for 10:00 am on Monday April 19th with Dr. Nigel Matthews. If you have any questions please call 845 340 1090.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Cz4N9uP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=GNzGS9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=uS9-hP9HO9LXp-TdCbNW

Thank you.
Kingston Medical Center','1','1');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('64','','','845 246 5599','-5','This is a call from Kingston Medical Center reminding you of your appointment for 10:00 am on Monday April 19th. If you have any questions please call 845 340 1090. Thank you.','2010-04-16 23:00:00','1','0','','1','0','0000-00-00 00:00:00','1','56','','2010-04-19 10:00:00','165','Dear Laura Powell,

This is a message from Kingston Medical Center reminding you of your appointment for 10:00 am on Monday April 19th with Dr. Nigel Matthews. If you have any questions please call 845 340 1090.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Cz4N9uP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=GNzGS9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=uS9-hP9HO9LXp-TdCbNW

Thank you.
Kingston Medical Center','1','2');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('65','','','917 650 4575','-5','This is a call from Kingston Medical Center reminding you of your appointment for 10:15 am on Monday April 19th. If you have any questions please call 845 340 1090. Thank you.','2010-04-18 23:00:00','1','0','','1','0','0000-00-00 00:00:00','1','57','','2010-04-19 10:15:00','166','Dear David  Spitler,

This is a message from Kingston Medical Center reminding you of your appointment for 10:15 am on Monday April 19th with Dr. Nigel Matthews. If you have any questions please call 845 340 1090.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Dz4R9uP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=QNzuS9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=4S9kP9HO9LXp-TdCbNW

Thank you.
Kingston Medical Center','1','0');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('66','','','917 650 4575','-5','This is a call from Kingston Medical Center reminding you of your appointment for 10:15 am on Monday April 19th. If you have any questions please call 845 340 1090. Thank you.','2010-04-17 23:00:00','1','0','','1','0','0000-00-00 00:00:00','1','57','','2010-04-19 10:15:00','166','Dear David  Spitler,

This is a message from Kingston Medical Center reminding you of your appointment for 10:15 am on Monday April 19th with Dr. Nigel Matthews. If you have any questions please call 845 340 1090.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Dz4R9uP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=QNzuS9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=4S9kP9HO9LXp-TdCbNW

Thank you.
Kingston Medical Center','1','1');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('67','','','917 650 4575','-5','This is a call from Kingston Medical Center reminding you of your appointment for 10:15 am on Monday April 19th. If you have any questions please call 845 340 1090. Thank you.','2010-04-16 23:00:00','1','0','','1','0','0000-00-00 00:00:00','1','57','','2010-04-19 10:15:00','166','Dear David  Spitler,

This is a message from Kingston Medical Center reminding you of your appointment for 10:15 am on Monday April 19th with Dr. Nigel Matthews. If you have any questions please call 845 340 1090.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Dz4R9uP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=QNzuS9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=4S9kP9HO9LXp-TdCbNW

Thank you.
Kingston Medical Center','1','2');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('68','','','904 264 9605','-5','This is a call from Kingston Medical Center reminding you of your appointment for 10:00 am on Monday April 19th. If you have any questions please call 845 340 1090. Thank you.','2010-04-18 23:00:00','1','0','','1','0','0000-00-00 00:00:00','1','58','','2010-04-19 10:00:00','167','Dear Lorraine Miller,

This is a message from Kingston Medical Center reminding you of your appointment for 10:00 am on Monday April 19th with Dr. Nigel Matthews. If you have any questions please call 845 340 1090.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Ez4L-JuP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=aNz-YS9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-ES9-OP9HO9LXp-TdCbNW

Thank you.
Kingston Medical Center','1','0');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('69','','','904 264 9605','-5','This is a call from Kingston Medical Center reminding you of your appointment for 10:00 am on Monday April 19th. If you have any questions please call 845 340 1090. Thank you.','2010-04-17 23:00:00','1','0','','1','0','0000-00-00 00:00:00','1','58','','2010-04-19 10:00:00','167','Dear Lorraine Miller,

This is a message from Kingston Medical Center reminding you of your appointment for 10:00 am on Monday April 19th with Dr. Nigel Matthews. If you have any questions please call 845 340 1090.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Ez4L-JuP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=aNz-YS9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-ES9-OP9HO9LXp-TdCbNW

Thank you.
Kingston Medical Center','1','1');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('70','','','904 264 9605','-5','This is a call from Kingston Medical Center reminding you of your appointment for 10:00 am on Monday April 19th. If you have any questions please call 845 340 1090. Thank you.','2010-04-16 23:00:00','1','0','','1','0','0000-00-00 00:00:00','1','58','','2010-04-19 10:00:00','167','Dear Lorraine Miller,

This is a message from Kingston Medical Center reminding you of your appointment for 10:00 am on Monday April 19th with Dr. Nigel Matthews. If you have any questions please call 845 340 1090.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Ez4L-JuP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=aNz-YS9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-ES9-OP9HO9LXp-TdCbNW

Thank you.
Kingston Medical Center','1','2');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('71','','','19176504575','-5','This is a call from Kingston Medical Center reminding you of your appointment for 10:30 am on Friday April 23rd. If you have any questions please call 845 340 1090. Thank you.','2010-04-22 23:00:00','1','0','','1','0','0000-00-00 00:00:00','1','28','','2010-04-23 10:30:00','168','Dear Dennis Dennis,

This is a message from Kingston Medical Center reminding you of your appointment for 10:30 am on Friday April 23rd with Dawn Parklington. If you have any questions please call 845 340 1090.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Fz4P94P9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=kNzaT9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-OS9QQ9HO9LXp-TdCbNW

Thank you.
Kingston Medical Center','0','0');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('72','','','19176504575','-5','This is a call from Kingston Medical Center reminding you of your appointment for 10:30 am on Friday April 23rd. If you have any questions please call 845 340 1090. Thank you.','2010-04-21 23:00:00','1','0','','1','0','0000-00-00 00:00:00','1','28','','2010-04-23 10:30:00','168','Dear Dennis Dennis,

This is a message from Kingston Medical Center reminding you of your appointment for 10:30 am on Friday April 23rd with Dawn Parklington. If you have any questions please call 845 340 1090.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Fz4P94P9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=kNzaT9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-OS9QQ9HO9LXp-TdCbNW

Thank you.
Kingston Medical Center','0','1');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('73','','','19176504575','-5','This is a call from Kingston Medical Center reminding you of your appointment for 10:30 am on Friday April 23rd. If you have any questions please call 845 340 1090. Thank you.','2010-04-20 23:00:00','1','0','','1','0','0000-00-00 00:00:00','1','28','','2010-04-23 10:30:00','168','Dear Dennis Dennis,

This is a message from Kingston Medical Center reminding you of your appointment for 10:30 am on Friday April 23rd with Dawn Parklington. If you have any questions please call 845 340 1090.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Fz4P94P9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=kNzaT9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-OS9QQ9HO9LXp-TdCbNW

Thank you.
Kingston Medical Center','1','2');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('74','','','18453401090','-5','This is a call from Kingston Medical Center reminding you of your appointment for 10:30 am on Friday April 23rd. If you have any questions please call 845 340 1090. Thank you.','2010-04-22 23:00:00','1','0','','1','0','0000-00-00 00:00:00','1','44','','2010-04-23 10:30:00','169','Dear Karlos Muelleruez,

This is a message from Kingston Medical Center reminding you of your appointment for 10:30 am on Friday April 23rd with Dawn Parklington. If you have any questions please call 845 340 1090.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Gz4T94P9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=uNz-ET9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-YS94Q9HO9LXp-TdCbNW

Thank you.
Kingston Medical Center','0','0');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('75','','','18453401090','-5','This is a call from Kingston Medical Center reminding you of your appointment for 10:30 am on Friday April 23rd. If you have any questions please call 845 340 1090. Thank you.','2010-04-21 23:00:00','1','0','','1','0','0000-00-00 00:00:00','1','44','','2010-04-23 10:30:00','169','Dear Karlos Muelleruez,

This is a message from Kingston Medical Center reminding you of your appointment for 10:30 am on Friday April 23rd with Dawn Parklington. If you have any questions please call 845 340 1090.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Gz4T94P9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=uNz-ET9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-YS94Q9HO9LXp-TdCbNW

Thank you.
Kingston Medical Center','0','1');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('76','','','18453401090','-5','This is a call from Kingston Medical Center reminding you of your appointment for 10:30 am on Friday April 23rd. If you have any questions please call 845 340 1090. Thank you.','2010-04-20 23:00:00','1','0','','1','0','0000-00-00 00:00:00','1','44','','2010-04-23 10:30:00','169','Dear Karlos Muelleruez,

This is a message from Kingston Medical Center reminding you of your appointment for 10:30 am on Friday April 23rd with Dawn Parklington. If you have any questions please call 845 340 1090.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Gz4T94P9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=uNz-ET9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-YS94Q9HO9LXp-TdCbNW

Thank you.
Kingston Medical Center','1','2');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('77','','','2221212212','-5','This is a call from Kingston Medical Center reminding you of your appointment for 10:45 am on Friday April 23rd. If you have any questions please call 845 340 1090. Thank you.','2010-04-22 23:00:00','1','0','','1','0','0000-00-00 00:00:00','1','9','','2010-04-23 10:45:00','170','Dear George Roberts,

This is a message from Kingston Medical Center reminding you of your appointment for 10:45 am on Friday April 23rd with Dawn Parklington. If you have any questions please call 845 340 1090.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Hp-EN9-EP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=3OzGK-JuM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-hT9-hR9HO9LXp-TdCbNW

Thank you.
Kingston Medical Center','0','0');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('78','','','2221212212','-5','This is a call from Kingston Medical Center reminding you of your appointment for 10:45 am on Friday April 23rd. If you have any questions please call 845 340 1090. Thank you.','2010-04-21 23:00:00','1','0','','1','0','0000-00-00 00:00:00','1','9','','2010-04-23 10:45:00','170','Dear George Roberts,

This is a message from Kingston Medical Center reminding you of your appointment for 10:45 am on Friday April 23rd with Dawn Parklington. If you have any questions please call 845 340 1090.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Hp-EN9-EP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=3OzGK-JuM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-hT9-hR9HO9LXp-TdCbNW

Thank you.
Kingston Medical Center','0','1');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('79','','','2221212212','-5','This is a call from Kingston Medical Center reminding you of your appointment for 10:45 am on Friday April 23rd. If you have any questions please call 845 340 1090. Thank you.','2010-04-20 23:00:00','1','0','','1','0','0000-00-00 00:00:00','1','9','','2010-04-23 10:45:00','170','Dear George Roberts,

This is a message from Kingston Medical Center reminding you of your appointment for 10:45 am on Friday April 23rd with Dawn Parklington. If you have any questions please call 845 340 1090.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Hp-EN9-EP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=3OzGK-JuM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-hT9-hR9HO9LXp-TdCbNW

Thank you.
Kingston Medical Center','1','2');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('80','','','19176504575','-5','This is a call from Kingston Medical Center reminding you of your appointment for 11:00 am on Wednesday April 28th. If you have any questions please call 845 340 1090. Thank you.','2010-04-27 23:00:00','1','0','','1','0','0000-00-00 00:00:00','1','28','','2010-04-28 11:00:00','171','Dear Dennis Dennis,

This is a message from Kingston Medical Center reminding you of your appointment for 11:00 am on Wednesday April 28th with Dr. Nigel Matthews. If you have any questions please call 845 340 1090.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Ip-ER9-EP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=-DOzuK-JuM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=GT9kR9HO9LXp-TdCbNW

Thank you.
Kingston Medical Center','0','0');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('81','','','19176504575','-5','This is a call from Kingston Medical Center reminding you of your appointment for 11:00 am on Wednesday April 28th. If you have any questions please call 845 340 1090. Thank you.','2010-04-26 23:00:00','1','0','','1','0','0000-00-00 00:00:00','1','28','','2010-04-28 11:00:00','171','Dear Dennis Dennis,

This is a message from Kingston Medical Center reminding you of your appointment for 11:00 am on Wednesday April 28th with Dr. Nigel Matthews. If you have any questions please call 845 340 1090.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Ip-ER9-EP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=-DOzuK-JuM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=GT9kR9HO9LXp-TdCbNW

Thank you.
Kingston Medical Center','0','1');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('82','','','19176504575','-5','This is a call from Kingston Medical Center reminding you of your appointment for 11:00 am on Wednesday April 28th. If you have any questions please call 845 340 1090. Thank you.','2010-04-25 23:00:00','1','0','','1','0','0000-00-00 00:00:00','1','28','','2010-04-28 11:00:00','171','Dear Dennis Dennis,

This is a message from Kingston Medical Center reminding you of your appointment for 11:00 am on Wednesday April 28th with Dr. Nigel Matthews. If you have any questions please call 845 340 1090.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Ip-ER9-EP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=-DOzuK-JuM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=GT9kR9HO9LXp-TdCbNW

Thank you.
Kingston Medical Center','0','2');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('118','','','','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:00 am on Tuesday May 4th. If you have any questions please call 2221212212. Thank you.','2010-05-03 15:00:00','1','0','','1','0','0000-00-00 00:00:00','1','12','','2010-05-04 10:00:00','173','Dear  ,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:00 am on Tuesday May 4th with Dawn Parklington. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Az-EP9-OP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=-XOzaL-JuM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=aT9QS9HO9LXp-TdCbNW

Thank you.
Worthington Medical Facility','0','3');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('127','','','','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:45 am on Wednesday June 9th. If you have any questions please call 2221212212. Thank you.','2010-06-08 15:00:00','1','0','','1','0','0000-00-00 00:00:00','1','12','','2010-06-09 10:45:00','174','Dear  ,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:45 am on Wednesday June 9th with Dawn Parklington. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Bz-ET9-OP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=-hOz-EL-JuM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=kT94S9HO9LXp-TdCbNW

Thank you.
Worthington Medical Facility','0','3');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('128','','','','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:00 am on Tuesday May 4th. If you have any questions please call 2221212212. Thank you.','2010-05-03 15:00:00','1','0','','1','0','0000-00-00 00:00:00','1','9','','2010-05-04 10:00:00','175','Dear  ,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:00 am on Tuesday May 4th with Dawn Parklington. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Cz-EN9-XQ9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=GOzGM94M-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=uT9-hTzRO9LXp-TdCbNW

Thank you.
Worthington Medical Facility','1','3');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('125','','','','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:45 am on Wednesday June 9th. If you have any questions please call 2221212212. Thank you.','2010-05-22 15:00:00','1','0','','1','0','0000-00-00 00:00:00','1','12','','2010-06-09 10:45:00','174','Dear  ,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:45 am on Wednesday June 9th with Dawn Parklington. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Bz-ET9-OP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=-hOz-EL-JuM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=kT94S9HO9LXp-TdCbNW

Thank you.
Worthington Medical Facility','0','0');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('126','','','','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:45 am on Wednesday June 9th. If you have any questions please call 2221212212. Thank you.','2010-05-31 15:00:00','1','0','','1','0','0000-00-00 00:00:00','1','12','','2010-06-09 10:45:00','174','Dear  ,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:45 am on Wednesday June 9th with Dawn Parklington. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Bz-ET9-OP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=-hOz-EL-JuM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=kT94S9HO9LXp-TdCbNW

Thank you.
Worthington Medical Facility','0','1');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('129','','','','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 11:00 am on Wednesday May 5th. If you have any questions please call 2221212212. Thank you.','2010-05-04 15:00:00','1','0','','1','0','0000-00-00 00:00:00','1','16','','2010-05-05 11:00:00','177','Dear  ,

This is a message from Worthington Medical Facility reminding you of your appointment for 11:00 am on Wednesday May 5th with Dawn Parklington. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Ez-EL-J-XQ9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=aOz-YM94M-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-ET9-OTzRO9LXp-TdCbNW

Thank you.
Worthington Medical Facility','0','3');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('130','','','','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:30 am on Wednesday May 12th. If you have any questions please call 2221212212. Thank you.','2010-05-11 15:00:00','1','0','','1','0','0000-00-00 00:00:00','1','12','','2010-05-12 10:30:00','179','Dear  ,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:30 am on Wednesday May 12th with Dawn Parklington. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Gz-ET9-hQ9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=uOz-EN94M-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-YT94K9RO9LXp-TdCbNW

Thank you.
Worthington Medical Facility','0','3');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('131','','','','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:30 am on Wednesday May 12th. If you have any questions please call 2221212212. Thank you.','2010-05-11 15:00:00','1','0','','1','0','0000-00-00 00:00:00','1','12','','2010-05-12 10:30:00','180','Dear  ,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:30 am on Wednesday May 12th with Dawn Parklington. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Hp-ON9GQ9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=3PzGO94M-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-hK-J-hL9RO9LXp-TdCbNW

Thank you.
Worthington Medical Facility','0','3');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('132','','','','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:30 am on Wednesday May 12th. If you have any questions please call 2221212212. Thank you.','2010-05-11 15:00:00','1','0','','1','0','0000-00-00 00:00:00','1','12','','2010-05-12 10:30:00','181','Dear  ,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:30 am on Wednesday May 12th with Dawn Parklington. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Ip-OR9GQ9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=-DPzuO94M-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=GK-JkL9RO9LXp-TdCbNW

Thank you.
Worthington Medical Facility','0','3');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('133','0','1','19176504575','-5','This is a call from Beauty Bar reminding you of your appointment for 10:30 am on Tuesday August 3rd. If you have any questions please call 9176504575. Thank you.','2010-08-02 00:14:00','1','0','1','','','','24','36','','2010-08-03 10:30:00','195','Dear Jammyboy Quinkler,

This is a message from Beauty Bar reminding you of your appointment for 10:30 am on Tuesday August 3rd with Susie Caldwell. If you have any questions please call 9176504575.

If you expect to make this appointment, click this link:
http://dayboxx.com/response.php?x_eq=Cz-YN9-EQ9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://dayboxx.com/response.php?x_eq=GQzGK-J4M-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://dayboxx.com/response.php?x_eq=uL-J-hR9RO9LXp-TdCbNW

Thank you.
Beauty Bar

DEBUGGING:
time to call or email:2010-08-02 00:14:00 time of appointment:2010-08-03 10:30:00
This is supposed to have come 2 days before the appointment.
The Event ID for this is: 195','1','2');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('134','1','0','19176504575','-5','This is a call from Beauty Bar reminding you of your appointment for 10:30 am on Tuesday August 3rd. If you have any questions please call 9176504575. Thank you.','2010-08-03 00:12:00','1','1','3','','','2010-08-03 00:13:01','24','36','','2010-08-03 10:30:00','195','Dear Jammyboy Quinkler,

This is a message from Beauty Bar reminding you of your appointment for 10:30 am on Tuesday August 3rd with Susie Caldwell. If you have any questions please call 9176504575.

If you expect to make this appointment, click this link:
http://dayboxx.com/response.php?x_eq=Cz-YN9-EQ9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://dayboxx.com/response.php?x_eq=GQzGK-J4M-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://dayboxx.com/response.php?x_eq=uL-J-hR9RO9LXp-TdCbNW

Thank you.
Beauty Bar

DEBUGGING:
time to call or email:2010-08-03 00:12:00 time of appointment:2010-08-03 10:30:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 195','1','3');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('135','0','1','19176504575','-5','This is a call from Beauty Bar reminding you of your appointment for 1:45 pm on Wednesday August 4th. If you have any questions please call 9176504575. Thank you.','2010-08-03 00:01:00','1','0','1','','','','24','36','','2010-08-04 13:45:00','196','Dear Jammyboy Quinkler,

This is a message from Beauty Bar reminding you of your appointment for 1:45 pm on Wednesday August 4th with Susie Caldwell. If you have any questions please call 9176504575.

If you expect to make this appointment, click this link:
http://dayboxx.com/response.php?x_eq=Dz-YR9-EQ9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://dayboxx.com/response.php?x_eq=QQzuK-J4M-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://dayboxx.com/response.php?x_eq=4L-JkR9RO9LXp-TdCbNW

Thank you.
Beauty Bar

DEBUGGING:
time to call or email:2010-08-03 00:01:00 time of appointment:2010-08-04 13:45:00
This is supposed to have come 2 days before the appointment.
The Event ID for this is: 196','1','2');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('136','1','0','19176504575','-5','This is a call from Beauty Bar reminding you of your appointment for 1:45 pm on Wednesday August 4th. If you have any questions please call 9176504575. Thank you.','2010-08-04 00:14:00','1','1','3','','','2010-08-04 00:15:01','24','36','','2010-08-04 13:45:00','196','Dear Jammyboy Quinkler,

This is a message from Beauty Bar reminding you of your appointment for 1:45 pm on Wednesday August 4th with Susie Caldwell. If you have any questions please call 9176504575.

If you expect to make this appointment, click this link:
http://dayboxx.com/response.php?x_eq=Dz-YR9-EQ9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://dayboxx.com/response.php?x_eq=QQzuK-J4M-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://dayboxx.com/response.php?x_eq=4L-JkR9RO9LXp-TdCbNW

Thank you.
Beauty Bar

DEBUGGING:
time to call or email:2010-08-04 00:14:00 time of appointment:2010-08-04 13:45:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 196','1','3');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('137','0','1','18452465599','-5','This is a call from Beauty Bar reminding you of your appointment for 1:15 pm on Tuesday August 3rd. If you have any questions please call 9176504575. Thank you.','2010-08-02 00:11:00','1','0','1','','','','24','37','','2010-08-03 13:15:00','197','Dear Laura Powell,

This is a message from Beauty Bar reminding you of your appointment for 1:15 pm on Tuesday August 3rd with Susie Caldwell. If you have any questions please call 9176504575.

If you expect to make this appointment, click this link:
http://dayboxx.com/response.php?x_eq=Ez-YL-J-EQ9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://dayboxx.com/response.php?x_eq=aQz-YK-J4M-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://dayboxx.com/response.php?x_eq=-EL-J-OR9RO9LXp-TdCbNW

Thank you.
Beauty Bar

DEBUGGING:
time to call or email:2010-08-02 00:11:00 time of appointment:2010-08-03 13:15:00
This is supposed to have come 2 days before the appointment.
The Event ID for this is: 197','1','2');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('138','1','0','18452465599','-5','This is a call from Beauty Bar reminding you of your appointment for 1:15 pm on Tuesday August 3rd. If you have any questions please call 9176504575. Thank you.','2010-08-03 00:01:00','1','1','3','','','2010-08-03 00:01:01','24','37','','2010-08-03 13:15:00','197','Dear Laura Powell,

This is a message from Beauty Bar reminding you of your appointment for 1:15 pm on Tuesday August 3rd with Susie Caldwell. If you have any questions please call 9176504575.

If you expect to make this appointment, click this link:
http://dayboxx.com/response.php?x_eq=Ez-YL-J-EQ9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://dayboxx.com/response.php?x_eq=aQz-YK-J4M-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://dayboxx.com/response.php?x_eq=-EL-J-OR9RO9LXp-TdCbNW

Thank you.
Beauty Bar

DEBUGGING:
time to call or email:2010-08-03 00:01:00 time of appointment:2010-08-03 13:15:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 197','1','3');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('139','0','1','18452465599','-5','This is a call from Beauty Bar reminding you of your appointment for 10:30 am on Thursday August 5th. If you have any questions please call 9176504575. Thank you.','2010-08-04 00:19:00','1','0','1','','','','24','37','','2010-08-05 10:30:00','198','Dear Laura Powell,

This is a message from Beauty Bar reminding you of your appointment for 10:30 am on Thursday August 5th with Susie Caldwell. If you have any questions please call 9176504575.

If you expect to make this appointment, click this link:
http://dayboxx.com/response.php?x_eq=Fz-YP9-OQ9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://dayboxx.com/response.php?x_eq=kQzaL-J4M-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://dayboxx.com/response.php?x_eq=-OL-JQS9RO9LXp-TdCbNW

Thank you.
Beauty Bar

DEBUGGING:
time to call or email:2010-08-04 00:19:00 time of appointment:2010-08-05 10:30:00
This is supposed to have come 2 days before the appointment.
The Event ID for this is: 198','1','2');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('140','1','0','18452465599','-5','This is a call from Beauty Bar reminding you of your appointment for 10:30 am on Thursday August 5th. If you have any questions please call 9176504575. Thank you.','2010-08-05 00:17:00','1','1','3','','','2010-08-05 00:17:01','24','37','','2010-08-05 10:30:00','198','Dear Laura Powell,

This is a message from Beauty Bar reminding you of your appointment for 10:30 am on Thursday August 5th with Susie Caldwell. If you have any questions please call 9176504575.

If you expect to make this appointment, click this link:
http://dayboxx.com/response.php?x_eq=Fz-YP9-OQ9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://dayboxx.com/response.php?x_eq=kQzaL-J4M-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://dayboxx.com/response.php?x_eq=-OL-JQS9RO9LXp-TdCbNW

Thank you.
Beauty Bar

DEBUGGING:
time to call or email:2010-08-05 00:17:00 time of appointment:2010-08-05 10:30:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 198','1','3');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('141','0','1','19176504575','-5','This is a call from Beauty Bar reminding you of your appointment for 10:30 am on Thursday August 5th. If you have any questions please call 9176504575. Thank you.','2010-08-04 00:19:00','1','0','1','','','','24','36','','2010-08-05 10:30:00','199','Dear Jammyboy Quinkler,

This is a message from Beauty Bar reminding you of your appointment for 10:30 am on Thursday August 5th with john does. If you have any questions please call 9176504575.

If you expect to make this appointment, click this link:
http://dayboxx.com/response.php?x_eq=Gz-YT9-OQ9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://dayboxx.com/response.php?x_eq=uQz-EL-J4M-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://dayboxx.com/response.php?x_eq=-YL-J4S9RO9LXp-TdCbNW

Thank you.
Beauty Bar

DEBUGGING:
time to call or email:2010-08-04 00:19:00 time of appointment:2010-08-05 10:30:00
This is supposed to have come 2 days before the appointment.
The Event ID for this is: 199','1','2');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('142','1','0','19176504575','-5','This is a call from Beauty Bar reminding you of your appointment for 10:30 am on Thursday August 5th. If you have any questions please call 9176504575. Thank you.','2010-08-05 00:16:00','1','1','3','','','2010-08-05 00:17:01','24','36','','2010-08-05 10:30:00','199','Dear Jammyboy Quinkler,

This is a message from Beauty Bar reminding you of your appointment for 10:30 am on Thursday August 5th with john does. If you have any questions please call 9176504575.

If you expect to make this appointment, click this link:
http://dayboxx.com/response.php?x_eq=Gz-YT9-OQ9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://dayboxx.com/response.php?x_eq=uQz-EL-J4M-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://dayboxx.com/response.php?x_eq=-YL-J4S9RO9LXp-TdCbNW

Thank you.
Beauty Bar

DEBUGGING:
time to call or email:2010-08-05 00:16:00 time of appointment:2010-08-05 10:30:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 199','1','3');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('143','0','1','19176504575','-5','This is a call from Beauty Bar reminding you of your appointment for 11:15 am on Friday August 6th. If you have any questions please call 9176504575. Thank you.','2010-08-05 00:13:00','1','0','1','','','','24','36','','2010-08-06 11:15:00','200','Dear Jammyboy Quinkler,

This is a message from Beauty Bar reminding you of your appointment for 11:15 am on Friday August 6th with john does. If you have any questions please call 9176504575.

If you expect to make this appointment, click this link:
http://dayboxx.com/response.php?x_eq=Hp-hO9-XR9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://dayboxx.com/response.php?x_eq=3RpQM9-EM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://dayboxx.com/response.php?x_eq=-hM9GTzbO9LXp-TdCbNW

Thank you.
Beauty Bar

DEBUGGING:
time to call or email:2010-08-05 00:13:00 time of appointment:2010-08-06 11:15:00
This is supposed to have come 2 days before the appointment.
The Event ID for this is: 200','1','2');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('144','1','0','19176504575','-5','This is a call from Beauty Bar reminding you of your appointment for 11:15 am on Friday August 6th. If you have any questions please call 9176504575. Thank you.','2010-08-06 00:18:00','1','1','3','','','2010-08-06 00:19:01','24','36','','2010-08-06 11:15:00','200','Dear Jammyboy Quinkler,

This is a message from Beauty Bar reminding you of your appointment for 11:15 am on Friday August 6th with john does. If you have any questions please call 9176504575.

If you expect to make this appointment, click this link:
http://dayboxx.com/response.php?x_eq=Hp-hO9-XR9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://dayboxx.com/response.php?x_eq=3RpQM9-EM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://dayboxx.com/response.php?x_eq=-hM9GTzbO9LXp-TdCbNW

Thank you.
Beauty Bar

DEBUGGING:
time to call or email:2010-08-06 00:18:00 time of appointment:2010-08-06 11:15:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 200','1','3');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('145','0','1','18452465599','-5','This is a call from Beauty Bar reminding you of your appointment for 1:30 pm on Friday August 6th. If you have any questions please call 9176504575. Thank you.','2010-08-05 00:05:00','1','0','1','','','','24','37','','2010-08-06 13:30:00','201','Dear Laura Powell,

This is a message from Beauty Bar reminding you of your appointment for 1:30 pm on Friday August 6th with john does. If you have any questions please call 9176504575.

If you expect to make this appointment, click this link:
http://dayboxx.com/response.php?x_eq=Ip-hS9-XR9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://dayboxx.com/response.php?x_eq=-DRp4M9-EM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://dayboxx.com/response.php?x_eq=GM9uTzbO9LXp-TdCbNW

Thank you.
Beauty Bar

DEBUGGING:
time to call or email:2010-08-05 00:05:00 time of appointment:2010-08-06 13:30:00
This is supposed to have come 2 days before the appointment.
The Event ID for this is: 201','1','2');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('146','1','0','18452465599','-5','This is a call from Beauty Bar reminding you of your appointment for 1:30 pm on Friday August 6th. If you have any questions please call 9176504575. Thank you.','2010-08-06 00:15:00','1','1','3','','','2010-08-06 00:15:01','24','37','','2010-08-06 13:30:00','201','Dear Laura Powell,

This is a message from Beauty Bar reminding you of your appointment for 1:30 pm on Friday August 6th with john does. If you have any questions please call 9176504575.

If you expect to make this appointment, click this link:
http://dayboxx.com/response.php?x_eq=Ip-hS9-XR9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://dayboxx.com/response.php?x_eq=-DRp4M9-EM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://dayboxx.com/response.php?x_eq=GM9uTzbO9LXp-TdCbNW

Thank you.
Beauty Bar

DEBUGGING:
time to call or email:2010-08-06 00:15:00 time of appointment:2010-08-06 13:30:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 201','1','3');
INSERT INTO dayboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('147','1','0','','-5','This is a call from Curley's Nail Salon reminding you of your appointment for 11:00 am on Friday September 10th. If you have any questions please call 917604575. Thank you.','2010-09-10 00:17:00','1','3','2','','','2010-09-10 02:25:01','23','22','','2010-09-10 11:00:00','202','Dear tommy  hayes,

This is a message from Curley's Nail Salon reminding you of your appointment for 11:00 am on Friday September 10th with Susie Caldwell. If you have any questions please call 917604575.

If you expect to make this appointment, click this link:
http://dayboxx.com/response.php?x_eq=Jp-hM9-hR9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://dayboxx.com/response.php?x_eq=-NRp-hN9-EM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://dayboxx.com/response.php?x_eq=QM9-XK9bO9LXp-TdCbNW

Thank you.
Curley's Nail Salon','1','3');


CREATE TABLE `phonecall_status` (
  `phonecall_status_id` int(11) NOT NULL auto_increment,
  `status_name` varchar(50) default NULL,
  PRIMARY KEY  (`phonecall_status_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;



INSERT INTO dayboxx.phonecall_status(`phonecall_status_id`,`status_name`) VALUES('1','scheduled');
INSERT INTO dayboxx.phonecall_status(`phonecall_status_id`,`status_name`) VALUES('2','called no status update');
INSERT INTO dayboxx.phonecall_status(`phonecall_status_id`,`status_name`) VALUES('3','answered');
INSERT INTO dayboxx.phonecall_status(`phonecall_status_id`,`status_name`) VALUES('4','busy');
INSERT INTO dayboxx.phonecall_status(`phonecall_status_id`,`status_name`) VALUES('5','no answer');
INSERT INTO dayboxx.phonecall_status(`phonecall_status_id`,`status_name`) VALUES('6','channel unavailable');
INSERT INTO dayboxx.phonecall_status(`phonecall_status_id`,`status_name`) VALUES('7','other');


CREATE TABLE `practitioner` (
  `practitioner_id` int(11) NOT NULL auto_increment,
  `name` varchar(50) default NULL,
  `practitioner_type_id` int(50) default NULL,
  `phone` varchar(50) default NULL,
  `facility` varchar(100) default NULL,
  `address` varchar(200) default NULL,
  `office_id` int(11) default NULL,
  PRIMARY KEY  (`practitioner_id`)
) ENGINE=MyISAM AUTO_INCREMENT=118 DEFAULT CHARSET=latin1;



INSERT INTO dayboxx.practitioner(`practitioner_id`,`name`,`practitioner_type_id`,`phone`,`facility`,`address`,`office_id`) VALUES('1','Dr. Peter Richards','5','1:1:111 211 2112','Kingston Medical','1:5g jghhhhhh','1');
INSERT INTO dayboxx.practitioner(`practitioner_id`,`name`,`practitioner_type_id`,`phone`,`facility`,`address`,`office_id`) VALUES('2','Dr. Oliver Primack','5','2:2:888 443 2312','	Kingston Medical','2:6g jgh j','1');
INSERT INTO dayboxx.practitioner(`practitioner_id`,`name`,`practitioner_type_id`,`phone`,`facility`,`address`,`office_id`) VALUES('3','Dr. Nigel Matthews','4','232 121 4421','	Kingston Medical','233 Koolington Blvd','1');
INSERT INTO dayboxx.practitioner(`practitioner_id`,`name`,`practitioner_type_id`,`phone`,`facility`,`address`,`office_id`) VALUES('4','Dr. Thor Walker','2','3:232 121 4421','Kingston Medical','3:8hgj ghj rockingham','1');
INSERT INTO dayboxx.practitioner(`practitioner_id`,`name`,`practitioner_type_id`,`phone`,`facility`,`address`,`office_id`) VALUES('103','Dawn Parklington','6','','','','1');
INSERT INTO dayboxx.practitioner(`practitioner_id`,`name`,`practitioner_type_id`,`phone`,`facility`,`address`,`office_id`) VALUES('104','Fredrick Mastow','1','4443334433','','','52');
INSERT INTO dayboxx.practitioner(`practitioner_id`,`name`,`practitioner_type_id`,`phone`,`facility`,`address`,`office_id`) VALUES('105','Tonia Kusters','0','','','','5');
INSERT INTO dayboxx.practitioner(`practitioner_id`,`name`,`practitioner_type_id`,`phone`,`facility`,`address`,`office_id`) VALUES('106','Anita Hayes','0','','','','5');
INSERT INTO dayboxx.practitioner(`practitioner_id`,`name`,`practitioner_type_id`,`phone`,`facility`,`address`,`office_id`) VALUES('107','Anita Hayes','1','0872477622','','','5');
INSERT INTO dayboxx.practitioner(`practitioner_id`,`name`,`practitioner_type_id`,`phone`,`facility`,`address`,`office_id`) VALUES('108','Tonia Kusters','1','','','','5');
INSERT INTO dayboxx.practitioner(`practitioner_id`,`name`,`practitioner_type_id`,`phone`,`facility`,`address`,`office_id`) VALUES('109','Cindy Lou','','','','','9');
INSERT INTO dayboxx.practitioner(`practitioner_id`,`name`,`practitioner_type_id`,`phone`,`facility`,`address`,`office_id`) VALUES('110','Susie Caldwell','','9176504575','','','23');
INSERT INTO dayboxx.practitioner(`practitioner_id`,`name`,`practitioner_type_id`,`phone`,`facility`,`address`,`office_id`) VALUES('111','Susie Caldwell','','','','','24');
INSERT INTO dayboxx.practitioner(`practitioner_id`,`name`,`practitioner_type_id`,`phone`,`facility`,`address`,`office_id`) VALUES('112','Diffler Ron','1','4443334433','','','24');
INSERT INTO dayboxx.practitioner(`practitioner_id`,`name`,`practitioner_type_id`,`phone`,`facility`,`address`,`office_id`) VALUES('113','Plis's Wa','1','','','','24');
INSERT INTO dayboxx.practitioner(`practitioner_id`,`name`,`practitioner_type_id`,`phone`,`facility`,`address`,`office_id`) VALUES('114','john does','','','','','24');
INSERT INTO dayboxx.practitioner(`practitioner_id`,`name`,`practitioner_type_id`,`phone`,`facility`,`address`,`office_id`) VALUES('115','john does','1','','','','24');
INSERT INTO dayboxx.practitioner(`practitioner_id`,`name`,`practitioner_type_id`,`phone`,`facility`,`address`,`office_id`) VALUES('116','piddle paddle','','','','','24');
INSERT INTO dayboxx.practitioner(`practitioner_id`,`name`,`practitioner_type_id`,`phone`,`facility`,`address`,`office_id`) VALUES('117','christine','','','','','23');


CREATE TABLE `practitioner_type` (
  `practitioner_type_id` int(4) NOT NULL auto_increment,
  `type_name` varchar(50) default NULL,
  PRIMARY KEY  (`practitioner_type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;



INSERT INTO dayboxx.practitioner_type(`practitioner_type_id`,`type_name`) VALUES('1','General');
INSERT INTO dayboxx.practitioner_type(`practitioner_type_id`,`type_name`) VALUES('2','Technician');
INSERT INTO dayboxx.practitioner_type(`practitioner_type_id`,`type_name`) VALUES('3','Chiropracter');
INSERT INTO dayboxx.practitioner_type(`practitioner_type_id`,`type_name`) VALUES('4','Specialist');
INSERT INTO dayboxx.practitioner_type(`practitioner_type_id`,`type_name`) VALUES('5','Surgeon');
INSERT INTO dayboxx.practitioner_type(`practitioner_type_id`,`type_name`) VALUES('6','Nurse');
INSERT INTO dayboxx.practitioner_type(`practitioner_type_id`,`type_name`) VALUES('7','Spiritual');


CREATE TABLE `practitioner_user_map` (
  `practicioner_user_map_id` int(4) NOT NULL auto_increment,
  `user_id` int(4) default NULL,
  `practitioner_id` int(4) default NULL,
  PRIMARY KEY  (`practicioner_user_map_id`)
) ENGINE=MyISAM AUTO_INCREMENT=91 DEFAULT CHARSET=latin1;



INSERT INTO dayboxx.practitioner_user_map(`practicioner_user_map_id`,`user_id`,`practitioner_id`) VALUES('88','1','83');
INSERT INTO dayboxx.practitioner_user_map(`practicioner_user_map_id`,`user_id`,`practitioner_id`) VALUES('19','30','14');
INSERT INTO dayboxx.practitioner_user_map(`practicioner_user_map_id`,`user_id`,`practitioner_id`) VALUES('20','30','15');
INSERT INTO dayboxx.practitioner_user_map(`practicioner_user_map_id`,`user_id`,`practitioner_id`) VALUES('21','30','16');
INSERT INTO dayboxx.practitioner_user_map(`practicioner_user_map_id`,`user_id`,`practitioner_id`) VALUES('22','33','17');
INSERT INTO dayboxx.practitioner_user_map(`practicioner_user_map_id`,`user_id`,`practitioner_id`) VALUES('23','33','18');
INSERT INTO dayboxx.practitioner_user_map(`practicioner_user_map_id`,`user_id`,`practitioner_id`) VALUES('85','1','80');
INSERT INTO dayboxx.practitioner_user_map(`practicioner_user_map_id`,`user_id`,`practitioner_id`) VALUES('90','1','85');
INSERT INTO dayboxx.practitioner_user_map(`practicioner_user_map_id`,`user_id`,`practitioner_id`) VALUES('81','1','76');


CREATE TABLE `promo_code` (
  `promo_code_id` int(11) NOT NULL auto_increment,
  `code` varchar(50) default NULL,
  `office_id` int(11) default NULL,
  PRIMARY KEY  (`promo_code_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;





CREATE TABLE `question_column_map` (
  `question_column_map_id` int(4) NOT NULL auto_increment,
  `questionnaire_id` int(4) default NULL,
  `table_name` varchar(50) default NULL,
  `column_name` varchar(50) default NULL,
  `questionnaire_question_id` int(4) default NULL,
  `sort_id` int(50) default NULL,
  PRIMARY KEY  (`question_column_map_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;



INSERT INTO dayboxx.question_column_map(`question_column_map_id`,`questionnaire_id`,`table_name`,`column_name`,`questionnaire_question_id`,`sort_id`) VALUES('1','8','practitioner','name','48','0');
INSERT INTO dayboxx.question_column_map(`question_column_map_id`,`questionnaire_id`,`table_name`,`column_name`,`questionnaire_question_id`,`sort_id`) VALUES('2','8','practitioner','phone','49','0');
INSERT INTO dayboxx.question_column_map(`question_column_map_id`,`questionnaire_id`,`table_name`,`column_name`,`questionnaire_question_id`,`sort_id`) VALUES('3','8','practitioner','facility','50','0');
INSERT INTO dayboxx.question_column_map(`question_column_map_id`,`questionnaire_id`,`table_name`,`column_name`,`questionnaire_question_id`,`sort_id`) VALUES('4','8','practitioner','practitioner_type_id','55','0');
INSERT INTO dayboxx.question_column_map(`question_column_map_id`,`questionnaire_id`,`table_name`,`column_name`,`questionnaire_question_id`,`sort_id`) VALUES('5','8','practitioner','address','51','0');
INSERT INTO dayboxx.question_column_map(`question_column_map_id`,`questionnaire_id`,`table_name`,`column_name`,`questionnaire_question_id`,`sort_id`) VALUES('6','11','insurance','insurance_name','57','0');
INSERT INTO dayboxx.question_column_map(`question_column_map_id`,`questionnaire_id`,`table_name`,`column_name`,`questionnaire_question_id`,`sort_id`) VALUES('9','11','insurance','mileage_reimburse_rate','60','0');
INSERT INTO dayboxx.question_column_map(`question_column_map_id`,`questionnaire_id`,`table_name`,`column_name`,`questionnaire_question_id`,`sort_id`) VALUES('10','12','subuser','name','62','0');
INSERT INTO dayboxx.question_column_map(`question_column_map_id`,`questionnaire_id`,`table_name`,`column_name`,`questionnaire_question_id`,`sort_id`) VALUES('11','12','subuser','birthday','77','0');
INSERT INTO dayboxx.question_column_map(`question_column_map_id`,`questionnaire_id`,`table_name`,`column_name`,`questionnaire_question_id`,`sort_id`) VALUES('12','11','insurance','membership_number','75','0');
INSERT INTO dayboxx.question_column_map(`question_column_map_id`,`questionnaire_id`,`table_name`,`column_name`,`questionnaire_question_id`,`sort_id`) VALUES('13','11','insurance','group_number','76','0');
INSERT INTO dayboxx.question_column_map(`question_column_map_id`,`questionnaire_id`,`table_name`,`column_name`,`questionnaire_question_id`,`sort_id`) VALUES('14','11','insurance','annual_maximum','79','0');


CREATE TABLE `questionnaire` (
  `questionnaire_id` int(4) NOT NULL default '0',
  `name` varchar(100) default NULL,
  `intro_text` text,
  `questionnaire_type_id` int(4) default NULL,
  `author_id` int(4) default NULL,
  `created` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `answer_tally` int(4) default NULL,
  `link_next_questionnaire_id` int(4) default NULL,
  `sort_order` int(4) default NULL,
  `accept_multiple` tinyint(1) default NULL,
  `related_table_name` varchar(50) default NULL,
  `populate_related` tinyint(1) default NULL,
  PRIMARY KEY  (`questionnaire_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



INSERT INTO dayboxx.questionnaire(`questionnaire_id`,`name`,`intro_text`,`questionnaire_type_id`,`author_id`,`created`,`answer_tally`,`link_next_questionnaire_id`,`sort_order`,`accept_multiple`,`related_table_name`,`populate_related`) VALUES('1','Identifying Information','','1','0','2007-07-30 17:56:53','0','0','1','0','','0');
INSERT INTO dayboxx.questionnaire(`questionnaire_id`,`name`,`intro_text`,`questionnaire_type_id`,`author_id`,`created`,`answer_tally`,`link_next_questionnaire_id`,`sort_order`,`accept_multiple`,`related_table_name`,`populate_related`) VALUES('2','Contact Info','','1','0','2007-07-30 17:56:53','0','0','2','0','','0');
INSERT INTO dayboxx.questionnaire(`questionnaire_id`,`name`,`intro_text`,`questionnaire_type_id`,`author_id`,`created`,`answer_tally`,`link_next_questionnaire_id`,`sort_order`,`accept_multiple`,`related_table_name`,`populate_related`) VALUES('4','Visits','','1','0','2007-07-30 17:56:53','0','0','7','1','','0');
INSERT INTO dayboxx.questionnaire(`questionnaire_id`,`name`,`intro_text`,`questionnaire_type_id`,`author_id`,`created`,`answer_tally`,`link_next_questionnaire_id`,`sort_order`,`accept_multiple`,`related_table_name`,`populate_related`) VALUES('6','calendar event','','2','0','2007-05-22 18:08:33','0','0','44','1','','0');
INSERT INTO dayboxx.questionnaire(`questionnaire_id`,`name`,`intro_text`,`questionnaire_type_id`,`author_id`,`created`,`answer_tally`,`link_next_questionnaire_id`,`sort_order`,`accept_multiple`,`related_table_name`,`populate_related`) VALUES('7','Emergency Contacts','','1','0','2007-07-30 17:56:53','0','0','4','1','','0');
INSERT INTO dayboxx.questionnaire(`questionnaire_id`,`name`,`intro_text`,`questionnaire_type_id`,`author_id`,`created`,`answer_tally`,`link_next_questionnaire_id`,`sort_order`,`accept_multiple`,`related_table_name`,`populate_related`) VALUES('8','Personal Practitioners','','1','0','2007-07-30 17:56:53','0','0','5','1','practitioner','1');
INSERT INTO dayboxx.questionnaire(`questionnaire_id`,`name`,`intro_text`,`questionnaire_type_id`,`author_id`,`created`,`answer_tally`,`link_next_questionnaire_id`,`sort_order`,`accept_multiple`,`related_table_name`,`populate_related`) VALUES('9','Provider','','0','0','2007-05-22 18:08:33','0','0','44','0','','1');
INSERT INTO dayboxx.questionnaire(`questionnaire_id`,`name`,`intro_text`,`questionnaire_type_id`,`author_id`,`created`,`answer_tally`,`link_next_questionnaire_id`,`sort_order`,`accept_multiple`,`related_table_name`,`populate_related`) VALUES('11','Insurance','<div>This is where you list your insurance providers.&nbsp;</div>','1','0','2007-07-30 17:56:53','0','0','6','1','insurance','1');
INSERT INTO dayboxx.questionnaire(`questionnaire_id`,`name`,`intro_text`,`questionnaire_type_id`,`author_id`,`created`,`answer_tally`,`link_next_questionnaire_id`,`sort_order`,`accept_multiple`,`related_table_name`,`populate_related`) VALUES('12','Family Members','<div>Enter the people whose medical records you are maintaining.&nbsp;</div>','1','0','2007-07-30 17:56:53','0','0','3','1','subuser','1');
INSERT INTO dayboxx.questionnaire(`questionnaire_id`,`name`,`intro_text`,`questionnaire_type_id`,`author_id`,`created`,`answer_tally`,`link_next_questionnaire_id`,`sort_order`,`accept_multiple`,`related_table_name`,`populate_related`) VALUES('3','medications','','3','0','2007-07-30 18:01:38','0','0','0','1','','0');
INSERT INTO dayboxx.questionnaire(`questionnaire_id`,`name`,`intro_text`,`questionnaire_type_id`,`author_id`,`created`,`answer_tally`,`link_next_questionnaire_id`,`sort_order`,`accept_multiple`,`related_table_name`,`populate_related`) VALUES('5','tests','','3','0','2007-07-30 18:02:09','0','0','0','1','','0');


CREATE TABLE `questionnaire_answer` (
  `questionnaire_answer_id` int(4) NOT NULL auto_increment,
  `answer` text,
  `questionnaire_question_id` int(4) default NULL,
  `questionnaire_answer_field_id` int(4) default NULL,
  `suggested_answer_id` int(4) default NULL,
  `user_id` int(4) default NULL,
  `questionnaire_id` int(4) default NULL,
  `answer_group_id` int(4) default NULL,
  PRIMARY KEY  (`questionnaire_answer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;





CREATE TABLE `questionnaire_question` (
  `questionnaire_question_id` int(4) NOT NULL auto_increment,
  `question` varchar(222) default NULL,
  `questionnaire_id` int(4) default NULL,
  `sort_order` int(4) default NULL,
  `answer_tally` int(4) default NULL,
  `suggested_table_name` varchar(44) default NULL,
  `answer_width` int(4) default NULL,
  `answer_height` int(4) default NULL,
  `validation_type_id` int(4) default NULL,
  `validation_pattern_id` int(4) default NULL,
  `sql_data_type` varchar(50) default NULL,
  PRIMARY KEY  (`questionnaire_question_id`)
) ENGINE=MyISAM AUTO_INCREMENT=80 DEFAULT CHARSET=latin1;



INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('3','Gender','1','0','0','gender','0','0','0','0','');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('4','Hair color','1','0','0','hair_color','0','0','0','0','');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('5','Eye color','1','0','0','eye_color','0','0','0','0','');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('6','Ethnicity','1','0','0','ethnicity','0','0','0','0','');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('7','Language','1','0','0','language','0','0','0','0','');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('8','Marital Status','1','0','0','marital_status','0','0','0','0','');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('9','Sexual preference','1','0','0','sexual_preference','0','0','0','0','');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('10','Religion','1','0','0','religion','0','0','0','0','');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('11','Blood type','1','0','0','blood_type','0','0','0','0','');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('12','Height &#40;in inches&#41;','1','0','0','','0','0','0','0','int');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('13','Weight &#40;in pounds&#41;','1','0','0','','0','0','0','0','int');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('14','Birthdate','1','0','0','','0','0','0','0','date');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('15','Home telephone','2','0','0','','0','0','0','0','');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('16','Work telephone','2','0','0','','0','0','0','0','');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('17','Mobile telephone','2','0','0','','0','0','0','0','');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('19','Address Line 1','2','0','0','','0','0','0','0','');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('20','Address Line 2','2','0','0','','0','0','0','0','');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('21','City or Town','2','0','0','','0','0','0','0','');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('22','State or Province','2','0','0','state','0','0','0','0','');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('23','Zip or Postal Code','2','0','0','','0','0','2','4','');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('24','Country','2','0','0','country','0','0','0','0','');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('25','SSN','1','0','0','','0','0','0','0','');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('26','First Name','1','0','0','','0','0','0','0','');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('27','Middle Name','1','0','0','','0','0','0','0','');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('28','Last Name','1','0','0','','0','0','0','0','');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('29','medication','3','2','0','','0','0','0','0','');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('30','amount','3','3','0','','0','0','0','0','');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('31','start date','3','5','0','','0','0','0','0','date');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('77','birth date','12','2','0','','0','0','0','0','date');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('33','doctor','3','1','0','practitioner','0','0','0','0','int');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('68','refill #','3','4','0','','0','0','0','0','int');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('35','date','4','0','0','','0','0','0','0','date');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('36','type','4','2','0','','0','0','0','0','');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('37','medical facility','4','3','0','','0','0','0','0','');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('38','contact','4','7','0','','0','0','0','0','');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('39','reason','4','9','0','','0','0','0','0','text');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('40','test','5','0','0','','0','0','0','0','');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('41','date','5','6','0','','0','0','0','0','');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('42','notes','5','12','0','','0','0','0','0','text');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('43','type','6','0','0','','0','0','0','0','');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('44','description','6','1','0','','0','0','0','0','');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('45','contact name','7','0','0','','0','0','0','0','');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('46','phone','7','0','0','','0','0','0','0','');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('47','description','7','0','0','','0','0','0','0','');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('48','Name','8','1','0','','0','0','0','0','');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('49','Phone #','8','3','0','','0','0','0','0','');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('50','Facility','8','4','0','','0','0','0','0','');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('51','Address','8','5','0','','0','0','0','0','');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('55','Type','8','2','0','practitioner_type','0','0','0','0','');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('56','practitioner_id','8','6','0','','0','0','0','0','hidden');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('57','name','11','0','0','','0','0','0','0','');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('65','insurer','11','0','0','insurer','0','0','0','0','');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('60','reimburse rate','11','0','0','','0','0','0','0','');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('61','insurance_id','11','0','0','','0','0','0','0','hidden');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('62','name','12','1','0','','0','0','0','0','');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('64','subuser_id','12','3','0','','0','0','0','0','hidden');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('66','doctor','5','0','0','practitioner','0','0','0','0','int');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('79','annual maximum','11','0','0','','0','0','0','0','');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('75','membership number','11','0','0','','0','0','0','0','');
INSERT INTO dayboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('76','group number','11','0','0','','0','0','0','0','');


CREATE TABLE `questionnaire_suggested_answer` (
  `questionnaire_suggested_answer_id` int(4) NOT NULL auto_increment,
  `suggested_answer` text,
  `questionnaire_question_id` int(4) default NULL,
  `sort_order` int(4) default NULL,
  `answer_tally` int(4) default NULL,
  PRIMARY KEY  (`questionnaire_suggested_answer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;





CREATE TABLE `questionnaire_type` (
  `questionnaire_type_id` int(4) NOT NULL auto_increment,
  `type_name` varchar(50) default NULL,
  PRIMARY KEY  (`questionnaire_type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;



INSERT INTO dayboxx.questionnaire_type(`questionnaire_type_id`,`type_name`) VALUES('1','site medical profile');
INSERT INTO dayboxx.questionnaire_type(`questionnaire_type_id`,`type_name`) VALUES('2','template');
INSERT INTO dayboxx.questionnaire_type(`questionnaire_type_id`,`type_name`) VALUES('3','medications and tests');


CREATE TABLE `recurrence` (
  `recurrence_id` int(4) NOT NULL auto_increment,
  `recurrence_name` varchar(50) default NULL,
  `recurrence_interval` varchar(22) default NULL,
  `avoidance_id` int(4) default NULL,
  PRIMARY KEY  (`recurrence_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;



INSERT INTO dayboxx.recurrence(`recurrence_id`,`recurrence_name`,`recurrence_interval`,`avoidance_id`) VALUES('1','six months','6 m','2');
INSERT INTO dayboxx.recurrence(`recurrence_id`,`recurrence_name`,`recurrence_interval`,`avoidance_id`) VALUES('2','one month','1 m','2');
INSERT INTO dayboxx.recurrence(`recurrence_id`,`recurrence_name`,`recurrence_interval`,`avoidance_id`) VALUES('3','one week','1 W','2');
INSERT INTO dayboxx.recurrence(`recurrence_id`,`recurrence_name`,`recurrence_interval`,`avoidance_id`) VALUES('4','one year','1 Y','2');
INSERT INTO dayboxx.recurrence(`recurrence_id`,`recurrence_name`,`recurrence_interval`,`avoidance_id`) VALUES('5','two weeks','2 W','2');


CREATE TABLE `server_task` (
  `server_task_id` int(11) NOT NULL auto_increment,
  `task_type` int(11) default NULL,
  `datetime_done` datetime default NULL,
  PRIMARY KEY  (`server_task_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;





CREATE TABLE `state` (
  `state_id` int(11) NOT NULL auto_increment,
  `code` char(3) default NULL,
  `state_name` varchar(22) default NULL,
  PRIMARY KEY  (`state_id`)
) ENGINE=MyISAM AUTO_INCREMENT=71 DEFAULT CHARSET=latin1;



INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('1','AL','ALABAMA');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('2','AK','ALASKA');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('3','AZ','ARIZONA');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('4','AR','ARKANSAS');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('5','CA','CALIFORNIA');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('6','CO','COLORADO');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('7','CT','CONNECTICUT');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('8','DE','DELAWARE');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('9','FL','FLORIDA');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('10','GA','GEORGIA');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('11','HI','HAWAII');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('12','ID','IDAHO');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('13','IL','ILLINOIS');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('14','IN','INDIANA');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('15','IA','IOWA');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('16','KS','KANSAS');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('17','KY','KENTUCKY');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('18','LA','LOUISIANA');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('19','ME','MAINE');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('20','MD','MARYLAND');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('21','MA','MASSACHUSETTS');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('22','MI','MICHIGAN');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('23','MN','MINNESOTA');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('24','MS','MISSISSIPPI');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('25','MO','MISSOURI');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('26','MT','MONTANA');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('27','NE','NEBRASKA');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('28','NV','NEVADA');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('29','NH','NEW HAMPSHIRE');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('30','NJ','NEW JERSEY');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('31','NM','NEW MEXICO');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('32','NY','NEW YORK');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('33','NC','NORTH CAROLINA');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('34','ND','NORTH DAKOTA');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('35','OH','OHIO');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('36','OK','OKLAHOMA');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('37','OR','OREGON');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('38','PA','PENNSYLVANIA');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('39','RI','RHODE ISLAND');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('40','SC','SOUTH CAROLINA');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('41','SD','SOUTH DAKOTA');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('42','TN','TENNESSEE');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('43','TX','TEXAS');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('44','UT','UTAH');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('45','VT','VERMONT');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('46','VA','VIRGINIA');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('47','WA','WASHINGTON');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('48','WV','WEST VIRGINIA');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('49','WI','WISCONSIN');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('50','WY','WYOMING');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('51','CZ','CANAL ZONE');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('52','DC','DISTRICT OF COLUMBIA');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('53','GU','GUAM');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('54','PR','PUERTO RICO');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('55','AS','U.S. PACIFIC IS.');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('56','US','UNITED STATES');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('57','VI','VIRGIN (U.S.) ISLANDS');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('58','AB','Alberta');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('59','BC','British Columbia');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('60','MB','Manitoba');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('61','NB','New Brunswick');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('62','NL','Newfoundland and Labra');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('63','NT','Northwest Territories');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('64','NS','Nova Scotia');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('65','NU','Nunavut');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('66','ON','Ontario');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('67','PE','Prince Edward Island');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('68','QC','Quebec');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('69','SK','Saskatchewan');
INSERT INTO dayboxx.state(`state_id`,`code`,`state_name`) VALUES('70','YT','Yukon');


CREATE TABLE `tf_dbmap` (
  `dbmap_id` int(11) NOT NULL auto_increment,
  `map_name` varchar(60) default NULL,
  `timecreated` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`dbmap_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;



INSERT INTO dayboxx.tf_dbmap(`dbmap_id`,`map_name`,`timecreated`) VALUES('1','phonecalls','2009-12-15 13:34:49');
INSERT INTO dayboxx.tf_dbmap(`dbmap_id`,`map_name`,`timecreated`) VALUES('2','real','2010-05-25 13:31:48');
INSERT INTO dayboxx.tf_dbmap(`dbmap_id`,`map_name`,`timecreated`) VALUES('3','New Map','2010-07-05 02:51:06');


CREATE TABLE `tf_dbmap_table` (
  `table_name` varchar(44) NOT NULL,
  `dbmap_id` int(11) NOT NULL default '0',
  `top_pos` int(11) default NULL,
  `left_pos` int(11) default NULL,
  `color_basis` varchar(50) default NULL,
  PRIMARY KEY  (`table_name`,`dbmap_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



INSERT INTO dayboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('client','3','61','51','');
INSERT INTO dayboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('office','3','61','549','');
INSERT INTO dayboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('phone_call','3','681','514','');
INSERT INTO dayboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('personal_calendar_event','3','487','258','');
INSERT INTO dayboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('tf_relation','3','677','1175','');
INSERT INTO dayboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('practitioner','3','154','281','');
INSERT INTO dayboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('formlog','3','285','751','');
INSERT INTO dayboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('mysql_errorlog','3','290','1044','');
INSERT INTO dayboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('login','3','61','390','');
INSERT INTO dayboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('tf_scriptlog','3','779','885','');
INSERT INTO dayboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('call_type','3','764','676','');
INSERT INTO dayboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('tf_dbmap_table','3','448','915','');
INSERT INTO dayboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('content','3','128','957','');
INSERT INTO dayboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('timezone','3','684','834','');
INSERT INTO dayboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('tf_sqllog','3','816','1026','');
INSERT INTO dayboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('tf_dbmap','3','587','912','');
INSERT INTO dayboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('state','3','457','1168','');
INSERT INTO dayboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('server_task','3','696','1017','');
INSERT INTO dayboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('tf_relation_type','3','580','1243','');
INSERT INTO dayboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('practitioner_type','3','421','263','');
INSERT INTO dayboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('phonecall_status','3','656','683','');
INSERT INTO dayboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('marital_status','3','865','23','');
INSERT INTO dayboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('insurance_type','3','731','75','');
INSERT INTO dayboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('event_status','3','756','343','');
INSERT INTO dayboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('client_office_map','3','334','293','');
INSERT INTO dayboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('promo_code','3','116','769','ffff33');
INSERT INTO dayboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('client_type','3','94','229','');


CREATE TABLE `tf_relation` (
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
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;



INSERT INTO dayboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('1','tf_relation','','relation_type_id','tf_relation_type','relation_type_id','0','','0');
INSERT INTO dayboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('2','phone_call','','call_type_id','call_type','call_type_id','0','','0');
INSERT INTO dayboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('3','tf_dbmap_table','','dbmap_id','tf_dbmap','dbmap_id','0','','0');
INSERT INTO dayboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('4','personal_calendar_event','','office_user_id','user','user_id','0','','0');
INSERT INTO dayboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('5','personal_calendar_event','','patient_user_id','user','user_id','0','','0');
INSERT INTO dayboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('6','personal_calendar_event','','practitioner_id','practitioner','practitioner_id','0','office_id=$office_id','0');
INSERT INTO dayboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('7','user_office_map','','office_user_id','user','user_id','0','','0');
INSERT INTO dayboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('8','user_office_map','','patient_user_id','user','user_id','0','','0');
INSERT INTO dayboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('9','practitioner','','office_user_id','user','user_id','0','','0');
INSERT INTO dayboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('10','practitioner','','practitioner_type_id','practitioner_type','practitioner_type_id','0','','0');
INSERT INTO dayboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('13','personal_calendar_event','','event_status_id','event_status','event_status_id','0','','0');
INSERT INTO dayboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('14','personal_calendar_event','firstname lastname','client_id','client','client_id','0','join client_office_map m on m.client_id=a.client_id WHERE m.office_id=$office_id','0');
INSERT INTO dayboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('15','personal_calendar_event','','office_id','office','office_id','0','','0');
INSERT INTO dayboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('16','client','','insurance1_type_id','insurance_type','insurance_type_id','0','','0');
INSERT INTO dayboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('17','client','','insurance2_type_id','insurance_type','insurance_type_id','0','','0');
INSERT INTO dayboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('18','client','','marital_status','marital_status','marital_status_id','0','','0');
INSERT INTO dayboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('19','client_office_map','office_name','office_id','office','office_id','0','','0');
INSERT INTO dayboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('20','client_office_map','firstname lastname','client_id','client','client_id','0','','0');
INSERT INTO dayboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('21','office','email','login_id','login','login_id','0','','0');
INSERT INTO dayboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('22','phone_call','','phonecall_status_id','phonecall_status','phonecall_status_id','0','','');
INSERT INTO dayboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('23','promo_code','','office_id','office','office_id','0','','');
INSERT INTO dayboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('24','client','','login_id','login','login_id','0','','');
INSERT INTO dayboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('25','client','','client_type_id','client_type','client_type_id','0','','');
INSERT INTO dayboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('26','phone_call','','office_id','office','office_id','0','','');
INSERT INTO dayboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('27','phone_call','','callee_id','client','client_id','0','','');


CREATE TABLE `tf_relation_type` (
  `relation_type_id` int(11) NOT NULL default '0',
  `name` varchar(40) default NULL,
  PRIMARY KEY  (`relation_type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



INSERT INTO dayboxx.tf_relation_type(`relation_type_id`,`name`) VALUES('0','foreign-key relation');
INSERT INTO dayboxx.tf_relation_type(`relation_type_id`,`name`) VALUES('1','multi-table relation');
INSERT INTO dayboxx.tf_relation_type(`relation_type_id`,`name`) VALUES('2','default relation');
INSERT INTO dayboxx.tf_relation_type(`relation_type_id`,`name`) VALUES('3','pseudo-field relation');


CREATE TABLE `tf_scriptlog` (
  `scriptlog_id` int(11) NOT NULL auto_increment,
  `pre_script` text,
  `post_script` text,
  `type` varchar(10) default NULL,
  `time_executed` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`scriptlog_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;



INSERT INTO dayboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('1','CREATE TABLE `phonecall_status` (
`phonecall_status` int(11) NOT NULL auto_increment,
`status_name` varchar(50) default NULL,
PRIMARY KEY (`phonecall_status`)
)','','sql','2010-07-05 02:47:08');
INSERT INTO dayboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('2','CREATE TABLE `promo_code` (
`promo_code_id` int(11) NOT NULL auto_increment,
`code` varchar(50) default NULL,
`office_id` int(11) default NULL,
PRIMARY KEY (`promo_code_id`)
)','','sql','2010-08-04 18:22:48');


CREATE TABLE `tf_sqllog` (
  `sqllog_id` int(11) NOT NULL auto_increment,
  `sql_string` text,
  `time_executed` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`sqllog_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;





CREATE TABLE `timezone` (
  `timezone_id` int(11) NOT NULL auto_increment,
  `timezone_name` varchar(50) default NULL,
  `dif_from_GMT` varchar(50) default NULL,
  PRIMARY KEY  (`timezone_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;



INSERT INTO dayboxx.timezone(`timezone_id`,`timezone_name`,`dif_from_GMT`) VALUES('1','Greenwich Mean Time','0');
INSERT INTO dayboxx.timezone(`timezone_id`,`timezone_name`,`dif_from_GMT`) VALUES('2','Central African Time','-1');
INSERT INTO dayboxx.timezone(`timezone_id`,`timezone_name`,`dif_from_GMT`) VALUES('3','South Atlantic Time','-2');
INSERT INTO dayboxx.timezone(`timezone_id`,`timezone_name`,`dif_from_GMT`) VALUES('4','Brazil Eastern Time','-3');
INSERT INTO dayboxx.timezone(`timezone_id`,`timezone_name`,`dif_from_GMT`) VALUES('5','Newfoundland Time','-3.5');
INSERT INTO dayboxx.timezone(`timezone_id`,`timezone_name`,`dif_from_GMT`) VALUES('6','Atlantic Time','-4');
INSERT INTO dayboxx.timezone(`timezone_id`,`timezone_name`,`dif_from_GMT`) VALUES('7','Eastern North American Time','-5');
INSERT INTO dayboxx.timezone(`timezone_id`,`timezone_name`,`dif_from_GMT`) VALUES('8','Central North American Time','-6');
INSERT INTO dayboxx.timezone(`timezone_id`,`timezone_name`,`dif_from_GMT`) VALUES('9','Mountain North American Time','-7');
INSERT INTO dayboxx.timezone(`timezone_id`,`timezone_name`,`dif_from_GMT`) VALUES('10','Pacific North American Time','-8');
INSERT INTO dayboxx.timezone(`timezone_id`,`timezone_name`,`dif_from_GMT`) VALUES('11','Alaska Time','-9');
INSERT INTO dayboxx.timezone(`timezone_id`,`timezone_name`,`dif_from_GMT`) VALUES('12','Hawaii Time','-10');
INSERT INTO dayboxx.timezone(`timezone_id`,`timezone_name`,`dif_from_GMT`) VALUES('13','Midway Islands Time','-11');
INSERT INTO dayboxx.timezone(`timezone_id`,`timezone_name`,`dif_from_GMT`) VALUES('14','New Zealand Time','12');
INSERT INTO dayboxx.timezone(`timezone_id`,`timezone_name`,`dif_from_GMT`) VALUES('15','Solomon Time','11');
INSERT INTO dayboxx.timezone(`timezone_id`,`timezone_name`,`dif_from_GMT`) VALUES('16','Australia Eastern','10');
INSERT INTO dayboxx.timezone(`timezone_id`,`timezone_name`,`dif_from_GMT`) VALUES('17','Australia Central','9.5');


CREATE TABLE `user` (
  `user_id` int(11) NOT NULL auto_increment,
  `office_name` varchar(50) default NULL,
  `subdomain` varchar(50) default NULL,
  `name_of_guardian` varchar(111) default NULL,
  `firstname` varchar(50) default NULL,
  `lastname` varchar(50) default NULL,
  `password` varchar(50) default NULL,
  `birthday` date default NULL,
  `address` varchar(50) default NULL,
  `city` varchar(50) default NULL,
  `state_code` varchar(3) default NULL,
  `zip` varchar(20) default NULL,
  `email` varchar(50) default NULL,
  `phone` varchar(50) default NULL,
  `timezone_id` int(11) default NULL,
  `cellphone` varchar(50) default NULL,
  `business_phone` varchar(50) default NULL,
  `business_address` varchar(50) default NULL,
  `business_state_code` varchar(50) default NULL,
  `business_zip` varchar(10) default NULL,
  `social_security_number` varchar(50) default NULL,
  `insurance1_type_id` int(11) default NULL,
  `insurance1` varchar(50) default NULL,
  `insurance1_number` varchar(50) default NULL,
  `insurance2_type_id` int(11) default NULL,
  `insurance2` varchar(50) default NULL,
  `insurance2_number` varchar(50) default NULL,
  `referred_by` varchar(50) default NULL,
  `why_visiting` text,
  `employed_by` varchar(50) default NULL,
  `marital_status` int(11) default NULL,
  `emergency_contact_name` varchar(60) default NULL,
  `emergency_phone` varchar(50) default NULL,
  `emergency_cellphone` varchar(50) default NULL,
  `contact_info` varchar(50) default NULL,
  `doctor_number` varchar(50) default NULL,
  `staff_number` varchar(50) default NULL,
  `patients_per_day` varchar(50) default NULL,
  `scheduling_unit_size` int(11) default NULL,
  `hours_open` varchar(50) default NULL,
  `days_open` varchar(50) default NULL,
  `midday_closed` varchar(50) default NULL,
  `holidays` varchar(50) default NULL,
  `call_type_id` int(11) default NULL,
  `is_office` varchar(1) default NULL,
  `is_active` tinyint(1) default NULL,
  `date_created` datetime default NULL,
  `date_lastvisited` datetime default NULL,
  `visitcount` int(11) default NULL,
  `office_text` text,
  `first_email` int(11) default NULL,
  `second_email` int(11) default NULL,
  `third_email` int(11) default NULL,
  `first_phonecall` int(11) default NULL,
  `second_phonecall` int(11) default NULL,
  `third_phonecall` int(11) default NULL,
  `phonecall_time` int(11) default NULL,
  PRIMARY KEY  (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=latin1;



INSERT INTO dayboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('1','Kingston Medical Center','kingstonmed','','','','pool','1999-11-30','16 Mercury Road','Kingston','NY','12443','bigfun@verizon.net','845 340 1090','7','','','','','','','0','','','0','','','','','','0','','','','Gus Mueller','2','12','22','15','9*17','1*5','12*13','12/25 01/01 thanksgiving','1','1','1','1969-12-31 19:00:00','1969-12-31 19:00:00','0','Situated in the gorgeous Hudson Valley of New York, Kingston Medical has the latest equipment and the highest-rated staff to help you with all your medical needs.','1','2','3','0','0','0','18');
INSERT INTO dayboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('5','','','','Harold','Kumar','pool','1965-06-12','333 Richard Lane','Richardville','','12434','bigfune@verizon.net','2221212212','0','','','','','','','0','','','0','','','','','','0','','','','','','','','0','','','','','0','0','1','2010-01-23 11:00:30','2010-01-23 11:00:30','1','','0','0','0','0','0','0','0');
INSERT INTO dayboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('3','Georgia Medical Center','gmc','','','','','0000-00-00','123 Atlanta Blvd.','Atlanta','','33221','master@gmc.edu','2221212212','0','','','','','','','0','','','0','','','','','','0','','','','Gus Mueller','21','332','122','0','','','','','0','1','1','2010-01-23 08:17:55','2010-01-23 08:17:55','0','','0','0','0','0','0','0','0');
INSERT INTO dayboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('4','Houston Medical Center','houston','','','','pool','0000-00-00','232 Hospital Road','Houston','','TX','houston@houston.com','845 340 1090','0','','','','','','','0','','','0','','','','','','0','','','','Gerald Houston','1','2','33','0','','','','','0','1','1','2010-01-23 08:19:05','2010-01-23 08:19:05','0','','0','0','0','0','0','0','0');
INSERT INTO dayboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('6','','','','Gerald','Friendmer','pool','0000-00-00','333 Richard Lane','Billings','','12434','bigfune@verizon.net','2221212212','0','','','','','','','0','','','0','','','','','','0','','','','','','','','0','','','','','0','1','1','2010-01-23 11:00:30','2010-01-23 11:00:30','1','','0','0','0','0','0','0','0');
INSERT INTO dayboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('7','','','','Ginger','Smith','33','1929-08-04','333 Richard Lane','Verona','','77887','bigfune@verizon.net','2221212212','0','','','','','','','0','','','0','','','','','','0','','','','','','','','0','','','','','0','0','1','2010-01-23 11:00:30','2010-01-23 11:00:30','1','','0','0','0','0','0','0','0');
INSERT INTO dayboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('8','','','','Ozzie','Jones','','1979-04-19','333 Richard Lane','Stafford','','55443','bigfune@verizon.net','2221212212','0','','','','','','','0','','','0','','','','','','0','','','','','','','','0','','','','','0','0','1','2010-01-23 11:00:30','2010-01-23 11:00:30','1','','0','0','0','0','0','0','0');
INSERT INTO dayboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('9','','','','George','Roberts','5','1989-07-14','333 Richard Lane','Klingerville','','22334','bigfune@verizon.net','2221212212','0','','','','','','','0','','','0','','','','','','0','','','','','','','','0','','','','','0','0','1','2010-01-23 11:00:30','2010-01-23 11:00:30','1','','0','0','0','0','0','0','0');
INSERT INTO dayboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('10','','','','Steve','Franklin','6','1949-08-25','333 Richard Lane','Sepialand','','90977','bigfunwe@verizon.net','2221212212','0','','','','','','','0','','','0','','','','','','0','','','','','','','','0','','','','','0','0','1','2010-01-23 11:00:30','2010-01-23 11:00:30','1','','0','0','0','0','0','0','0');
INSERT INTO dayboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('11','','','','Brian','Barnes','huskers','1959-05-17','8436 Wirt St.','Omaha','','68134','brian@voicendata.net','4025719049','0','','','','','','','0','','','0','','','','','','0','','','','','','','','0','','','','','0','0','1','2010-02-02 20:12:18','2010-02-02 20:12:18','1','','0','0','0','0','0','0','0');
INSERT INTO dayboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('31','','','','Laura','Laura','','1958-08-03','22 4th st','kingston','NY','12477','','1917 650 4575','0','','','','','','','0','','','0','','','','','','0','','','','','','','','0','','','','','0','0','1','2010-02-19 19:11:15','2010-02-19 19:11:15','1','','0','0','0','0','0','0','0');
INSERT INTO dayboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('30','','','Homer Simpson','Bart','Simpson','pool','1989-01-07','742 Evergreen Terrace','Springfield','XA','11111','bart@verizon.net','2221212212','0','2221212222','','','','','','0','','','0','','','','','','0','','','','','','','','0','','','','','0','0','1','1970-01-01 00:00:00','1970-01-01 00:00:00','0','','0','0','0','0','0','0','0');
INSERT INTO dayboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('26','','','Harold Flingerman','David','Flingerman','pool','1999-12-07','1 Manster Lane','Jillersburg','ME','02211','goop@voop.com','2221112222','0','','2221119988','Ritter Lane Northeast','MA','02221','226091977','2','Eugle Dental Insurance','33112334','3','Foop Optical','332423423232','Man on the Moon','I dont feel very gwood!','Launch.com','0','','','','','','','','0','','','','','0','0','1','2010-02-13 22:06:04','2010-02-13 22:06:04','1','','0','0','0','0','0','0','0');
INSERT INTO dayboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('27','','','Maud Richter','Peter','Flingerman','pool','1999-02-07','2 Manster Lane','Jillersburg','ME','02211','goop2@voop.com','2221112222','0','','2221119988','Ritter Lane Northeast','MA','02221','226091977','2','Eugle Dental Insurance','33112334','3','Foop Optical','332423423232','Man on the Moon','I dont feel very gwood!','Launch.com','0','','','','','','','','0','','','','','0','0','1','2010-02-13 22:06:04','2010-02-13 22:06:04','1','','0','0','0','0','0','0','0');
INSERT INTO dayboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('28','','','','Dennis','Dennis','453453','2000-10-14','576 5th Ave','Saugerties','NY','12477','denniso@standardsourcemedia.com','19176504575','0','','','same','','','234564309','1','Blue Cross','456754','0','','','Dr. Roll','pain','self','0','','','','','','','','0','','','','','0','0','1','2010-02-14 21:17:42','2010-02-14 21:17:42','1','','0','0','0','0','0','0','0');
INSERT INTO dayboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('40','','','','David','Managerson','','1972-01-19','25 Dug Hill Road','Dallas','TX','55443','bun@verizon.net','2156654433','0','','','','','','','0','','','0','','','','','','0','','','','','','','','0','','','','','2','0','1','0000-00-00 00:00:00','0000-00-00 00:00:00','0','','0','0','0','0','0','0','0');
INSERT INTO dayboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('41','','','','','','pool','0000-00-00','','','','','','','0','','','','','','','0','','','0','','bigfun@verizon.net','','','','0','','','','','','','','0','','','','','0','0','1','2010-02-21 21:12:13','2010-02-21 21:12:13','1','','0','0','0','0','0','0','0');
INSERT INTO dayboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('42','','','','','','pool','0000-00-00','','','','','','','0','','','','','','','0','','','0','','bigfun@verizon.net','','','','0','','','','','','','','0','','','','','0','0','1','2010-02-21 21:12:22','2010-02-21 21:12:22','1','','0','0','0','0','0','0','0');
INSERT INTO dayboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('43','','','','Fred','Vroomer','pool','1982-11-14','','','','','','','7','','','','','','','0','','','0','','','','','','0','','','','','','','','0','','','','','0','0','1','2010-02-21 21:15:41','2010-02-21 21:15:41','1','','0','0','0','0','0','0','0');
INSERT INTO dayboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('44','','','','Karlos','Muelleruez','pool','1913-01-02','25 Dug Hill Road','Juneau','AK','12434','man@verizon.net','18453401090','7','','','','','','226091977','0','','','0','','','','ouch!','Launch.com','0','Gretchen Primack','','','','','','','0','','','','','0','0','1','2010-02-25 04:25:50','2010-02-25 04:25:50','1','','0','0','0','0','0','0','0');
INSERT INTO dayboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('45','','','','Vicky','Signalwave','pool','1974-01-03','55 Uppledown Lane','Boise','ID','91221','vicky@signalwave.com','2224212212','10','','3322233333','66 Mackerel Lane ','ID','91221','226061977','1','Obamacare Insurance','','0','','man@verizon.net','Man on the Moon','','Rickle&#39;s Tuneups','0','Harold Signalwave','','','','','','','0','','','','','0','0','1','2010-04-02 20:00:25','2010-04-02 20:00:25','1','','0','0','0','0','0','0','0');
INSERT INTO dayboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('46','Holy Cross Hospital','holycross','','','','pool','0000-00-00','122 Silver Parkway','Silver Spring','MD','22112','largefun@pool.com','4443334433','7','','','','','','','0','','','0','','','','','','0','','','','tell me about it','33','121','88','15','10*16','1*5','12*13','12/25 01/01 thanksgiving','4','1','1','2010-04-03 02:51:42','2010-04-03 02:51:42','1','','0','0','0','0','0','0','0');
INSERT INTO dayboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('47','Capitol Hospital','capitol','','','','pool','0000-00-00','122 Silver Parkway','Silver Spring','MD','22112','biglargefun@pool.com','4443334433','7','','','','','','','0','','','0','','','','','','0','','','','','33','121','88','15','10*16','1*5','12*13','12/25 01/01 thanksgiving','4','1','1','2010-04-03 02:57:33','2010-04-03 02:57:33','1','','0','0','0','0','0','0','0');
INSERT INTO dayboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('48','Capitol Hospital','capitoler','','','','pool','0000-00-00','122 Silver Parkway','Silver Spring','MD','22112','bsiglargefun@pool.com','4443334433','7','','','','','','','0','','','0','','','','','','0','','','','','33','121','88','15','10*16','1*5','12*13','12/25 01/01 thanksgiving','4','1','1','2010-04-03 02:57:33','2010-04-03 02:57:33','1','','0','0','0','0','0','0','0');
INSERT INTO dayboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('49','Capitol Hospital','capitoler2','','','','pool','0000-00-00','122 Silver Parkway','Silver Spring','MD','22112','bswiglargefun@pool.com','4443334433','7','','','','','','','0','','','0','','','','','','0','','','','','33','121','88','15','10*16','1*5','12*13','12/25 01/01 thanksgiving','4','1','1','2010-04-03 02:57:33','2010-04-03 02:57:33','1','','0','0','0','0','0','0','0');
INSERT INTO dayboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('50','Capitol Hospital','capitoler3','','','','3333','0000-00-00','122 Silver Parkway','Silver Spring','MD','22112','bsw3iglargefun@pool.com','4443334433','7','','','','','','','0','','','0','','','','','','0','','','','','33','121','88','15','10*16','1*5','12*13','12/25 01/01 thanksgiving','4','1','1','2010-04-03 02:57:33','2010-04-03 02:57:33','1','','0','0','0','0','0','0','0');
INSERT INTO dayboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('51','Capitol Hospital','capitoler43','','','','5555','0000-00-00','122 Silver Parkway','Silver Spring','MD','22112','bs4w3iglargefun@pool.com','4443334433','7','','','','','','','0','','','0','','','','','','0','','','','','33','121','88','15','10*16','1*5','12*13','12/25 01/01 thanksgiving','4','1','1','2010-04-03 02:57:33','2010-04-03 02:57:33','1','','0','0','0','0','0','0','0');
INSERT INTO dayboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('52','Elmira Hospital','elmira','','','','pool','0000-00-00','76 Hummingbird Turnpike','Elmira','GA','33221','b22igfun@verizon.net','7436778433','7','','','','','','','0','','','0','','','','','','0','','','','333-222-1121','23','121','999','15','9*17','1*5','12*13','12/25 01/01 thanksgiving','0','1','1','2010-04-05 21:25:44','2010-04-05 21:25:44','1','Elmira features some of the best and most elite equipment manufactured by Chinese exporters.','1','2','3','0','0','0','10');
INSERT INTO dayboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('53','','','','Dennis','Opp','pool','1986-06-04','222 Milver Highway','Saugerties','NY','12232','thompsonsquare@gmail.com','19176504575','0','','','','','','','0','','','0','','','','','','0','','','','','','','','0','','','','','0','0','1','0000-00-00 00:00:00','0000-00-00 00:00:00','0','','0','0','0','0','0','0','0');
INSERT INTO dayboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('54','','','','Gus','Mueller','pool','1986-06-04','782 Rocker Freedomtron Highway','Saugerties','NY','12232','gus@asecular.com','18453401090','7','','','','','','','0','','','0','','','','','','0','','','','','','','','0','','','','','0','0','1','1970-01-01 00:00:00','1970-01-01 00:00:00','0','','0','0','0','0','0','0','0');
INSERT INTO dayboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('55','Woodstock Dental','woodstockdental','','','','453453','1999-11-30','12 Tinker St','Woodstock','NY','12409','denniso2323@gmail.com','8452465599','7','','','','','','','0','','','0','','','','','','0','','','','Joanna','1','1','28','15','9*17','1*5','12*13','12/25 01/01 thanksgiving','0','1','0','2010-04-06 22:49:55','2010-04-06 22:49:55','1','','18','9','1','1','0','0','10');
INSERT INTO dayboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('56','','','','Laura','Powell','727727','0000-00-00','','','','12477','lclar210@yahoo.com','845 246 5599','7','','','','','','','0','','','0','','','','','','0','David Spitler','','','','','','','0','','','','','0','0','1','2010-04-15 21:17:58','2010-04-15 21:17:58','1','','0','0','0','0','0','0','0');
INSERT INTO dayboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('57','','','','David ','Spitler','453453','0000-00-00','','','','12477','denniso2323@gmail.com','917 650 4575','7','','','','','','','0','','','0','','','','','','0','Laura Powell','','','','','','','0','','','','','0','0','1','2010-04-15 21:14:52','2010-04-15 21:14:52','1','','0','0','0','0','0','0','0');
INSERT INTO dayboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('58','','','','Lorraine','Miller','453453','0000-00-00','','','','90211','lomille@comcast.net ','904 264 9605','7','','','','','','','0','','','0','','','','','','0','john miller','','','','','','','0','','','','','0','0','1','2010-04-15 21:31:40','2010-04-15 21:31:40','1','','0','0','0','0','0','0','0');

