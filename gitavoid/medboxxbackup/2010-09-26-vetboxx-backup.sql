

CREATE TABLE `calendar` (
  `calendar_id` int(4) NOT NULL auto_increment,
  `calendar_name` varchar(50) default NULL,
  `description` text,
  `foreign_table_name` varchar(30) default NULL,
  `calendar_range_id` int(4) default NULL,
  `code` varchar(80) default NULL,
  PRIMARY KEY  (`calendar_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;



INSERT INTO vetboxx.calendar(`calendar_id`,`calendar_name`,`description`,`foreign_table_name`,`calendar_range_id`,`code`) VALUES('1','mascker voopp','moo','calendar','0','');
INSERT INTO vetboxx.calendar(`calendar_id`,`calendar_name`,`description`,`foreign_table_name`,`calendar_range_id`,`code`) VALUES('2','mascker voopp merkle','moo spabk','calendar','0','');


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



INSERT INTO vetboxx.call_type(`call_type_id`,`description`,`attempt_frequency`,`attempt_window_length`,`local_call_time_span`) VALUES('1','nine to five all days','1','999','15:00-23:00');
INSERT INTO vetboxx.call_type(`call_type_id`,`description`,`attempt_frequency`,`attempt_window_length`,`local_call_time_span`) VALUES('2','ten to five all days','360','1','10:00-17:00');
INSERT INTO vetboxx.call_type(`call_type_id`,`description`,`attempt_frequency`,`attempt_window_length`,`local_call_time_span`) VALUES('3','five to six all days','360','1','17:00-18:00');
INSERT INTO vetboxx.call_type(`call_type_id`,`description`,`attempt_frequency`,`attempt_window_length`,`local_call_time_span`) VALUES('4','testing','30','1','01:00-23:00');


CREATE TABLE `client` (
  `client_id` int(11) NOT NULL auto_increment,
  `login_id` int(11) default NULL,
  `guardian_client_id` int(11) default NULL,
  `name_of_guardian` varchar(111) default NULL,
  `firstname` varchar(50) default NULL,
  `lastname` varchar(50) default NULL,
  `client_type_id` int(11) default NULL,
  `description` varchar(50) default NULL,
  `weight` int(11) default NULL,
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
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;



INSERT INTO vetboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('16','20','12','','Bonnie','Treadweller','','','','0000-00-00','122 Silver Parkway','Richardville','MA','00221','foop@pool.com','','','','','','','','0','','','0','','','','','','0','asdasd','','','1','2010-05-02 14:16:34','2010-05-02 14:16:34');
INSERT INTO vetboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('15','19','0','','Fonda','Petapsco','','','','0000-00-00','122 Silver Parkway','Richardville','MA','00221','foop@pool.com','','','','','','','','0','','','0','','','','','','0','asdasd','','','1','2010-05-02 14:16:34','2010-05-02 14:16:34');
INSERT INTO vetboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('14','18','0','','Jill','Smithers','','','','0000-00-00','122 Silver Parkway','Richardville','MA','00221','foop@pool.com','','','','','','','','0','','','0','','','','','','0','asdasd','','','1','2010-05-02 14:16:34','2010-05-02 14:16:34');
INSERT INTO vetboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('13','17','0','','Henry','Moffat','','','','0000-00-00','122 Silver Parkway','Richardville','MA','00221','foop@pool.com','','','','','','','','0','','','0','','','','','','0','asdasd','','','1','2010-05-02 14:16:34','2010-05-02 14:16:34');
INSERT INTO vetboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('9','15','0','','George','McFargush','','','','1963-01-08','77 East Turncoat Lane','Hollywood','CA','97142','goop@asecular.com','4443334433','','','','','','','0','','','0','','','','','','0','sfsdfsdfdsf','','','1','2010-05-02 11:22:53','2010-05-02 11:22:53');
INSERT INTO vetboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('12','16','0','','Reginald','Treadweller','','','','0000-00-00','122 Silver Parkway','Richardville','MA','00221','foop@pool.com','','','','','','','','0','','','0','','','','','','0','asdasd','','','1','2010-05-02 14:16:34','2010-05-02 14:16:34');
INSERT INTO vetboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('17','0','0','','Valerie','Peters','','','','1966-03-04','22 Munich Heights Bypass','Flinders','WV','29112','','','','','','','','','0','','','0','','','','','','0','','','','1','0000-00-00 00:00:00','0000-00-00 00:00:00');
INSERT INTO vetboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('18','0','12','','Sybil','Treadweller','','','','1989-02-06','422 Silver Parkway','Richardville','MA','00221','','','','','','','','','0','','','0','','','','','','0','','','','1','0000-00-00 00:00:00','0000-00-00 00:00:00');
INSERT INTO vetboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('19','24','0','','anita','hayes','','','','0000-00-00','Feakle','Co. Clare','','','','','','','','','','','0','','','0','','','','','','0','','','','1','2010-05-10 12:17:58','2010-05-10 12:17:58');
INSERT INTO vetboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('20','0','0','','Tom','','','','','1999-11-30','','','','','','','','','','','','','0','','','0','','','','','','0','','','','1','1970-01-01 00:00:00','1970-01-01 00:00:00');
INSERT INTO vetboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('21','0','0','','Thomas','Hayes','','','','1953-11-26','Magherabaun','Feakle  Co. Clare, Ireland','','','tommyhaye@gmail.com','0876236292','','','','','','','0','','','0','','','','','','0','','','','1','1970-01-01 00:00:00','1970-01-01 00:00:00');
INSERT INTO vetboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('22','0','0','','tommy ','hayes','','','','0000-00-00','','','','','','','','','','','','','0','','','0','','','','','','0','','','','1','0000-00-00 00:00:00','0000-00-00 00:00:00');
INSERT INTO vetboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('23','0','0','','Randall','Walker','','','','1999-11-30','','','','','','','','','','','','','0','','','0','','','','','','0','','','','1','1970-01-01 00:00:00','1970-01-01 00:00:00');
INSERT INTO vetboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('24','0','0','','Laura','Powell','','','','0000-00-00','','','','','','','','','','','','','0','','','0','','','','','','0','','','','1','0000-00-00 00:00:00','0000-00-00 00:00:00');
INSERT INTO vetboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('25','0','0','','isaac','hayes','','','','0000-00-00','','','','','','','','','','','','','0','','','0','','','','','','0','','','','1','0000-00-00 00:00:00','0000-00-00 00:00:00');
INSERT INTO vetboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('26','0','0','','Fredrick','Ulster','','','','1933-02-03','122 Silver Parkway','Silverton','FL','22112','','','','','','','','','0','','','0','','','','','','0','','','','1','0000-00-00 00:00:00','0000-00-00 00:00:00');
INSERT INTO vetboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('27','0','0','','Manrick','Ulster','','','','1933-02-03','122 Silver Parkway','Silverton','FL','22112','','','','','','','','','0','','','0','','','','','','0','','','','1','0000-00-00 00:00:00','0000-00-00 00:00:00');
INSERT INTO vetboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('28','0','0','','Jebbediah','Ecols','','','','1933-02-03','122 Silver Parkway','Silverton','FL','22112','','','','','','','','','0','','','0','','','','','','0','','','','1','1970-01-01 00:00:00','1970-01-01 00:00:00');
INSERT INTO vetboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('29','0','0','','banrick','Ulster','','','','1933-02-03','122 Silver Parkway','Silverton','FL','22112','','','','','','','','','0','','','0','','','','','','0','','','','1','0000-00-00 00:00:00','0000-00-00 00:00:00');
INSERT INTO vetboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('30','0','0','','Vanrick','Ulster','','','','1933-02-03','122 Silver Parkway','Silverton','FL','22112','','','','','','','','','0','','','0','','','','','','0','','','','1','0000-00-00 00:00:00','0000-00-00 00:00:00');
INSERT INTO vetboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('31','0','0','','Vanrick','Ulster','','','','1933-02-03','122 Silver Parkway','Silverton','FL','22112','','','','','','','','','0','','','0','','','','','','0','','','','1','0000-00-00 00:00:00','0000-00-00 00:00:00');
INSERT INTO vetboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('32','0','0','','Joeseph','Hayes','','','','1999-11-30','','','','','','','','','','','','','0','','','0','','','','','','0','','','','1','1970-01-01 00:00:00','1970-01-01 00:00:00');
INSERT INTO vetboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('33','0','0','','Gioseppe','Hayes','','','','1999-11-30','','','','','','','','','','','','','0','','','0','','','','','','0','','','','1','1970-01-01 00:00:00','1970-01-01 00:00:00');
INSERT INTO vetboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('34','0','0','','JoJo','Hayes','','','','1999-11-30','','','','','','','','','','','','','0','','','0','','','','','','0','','','','1','1970-01-01 00:00:00','1970-01-01 00:00:00');
INSERT INTO vetboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('35','','','','Hugh','Ochoa','','','','0000-00-00','','','','','denniso2323@gmail.com','8452465599','','','','','','','','','','','','','','','','','','','','1','','');
INSERT INTO vetboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('36','','','','tom','terrific','','','','0000-00-00','','','','','denniso@standard-source.com','','917604575','','','','','','','','','','','','','','','','','','','1','','');
INSERT INTO vetboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('37','','','','Gretchen','Primack','','','','','12121 Rochester Avenue','Los Angeles','CA','92921','','','','','','','','','','','','','','','','','','','','','','1','','');
INSERT INTO vetboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('38','','37','','Sally','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','1','','');
INSERT INTO vetboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('39','','37','','Eleanor','','2','','','1999-11-30','','','','','','','','','','','','','','','','','','','','','','','','','','1','','');
INSERT INTO vetboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('40','','37','','Nigel','','3','','','','','','','','','','','','','','','','','','','','','','','','','','','','','1','','');
INSERT INTO vetboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('41','','36','','George','terrific','2','Pit Bull','122','1999-11-30','','','','','','','','','','','','','','','','','','','','','','','','','','1','','');
INSERT INTO vetboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('42','','','','Laura','Powell','','','','','','','','','denniso@standard-source.com','9176504575','','','','','','','','','','','','','','','','','','','','1','','');
INSERT INTO vetboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('43','','','','harold','beaver','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','1','','');
INSERT INTO vetboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('44','','42','','RB','Powell','2','mixed','60','0000-00-00','','','','','','','','','','','','','','','','','','','','','','','','','','1','','');
INSERT INTO vetboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('45','','42','','','Powell','','','','0000-00-00','','','','','','','','','','','','','','','','','','','','','','','','','','1','','');
INSERT INTO vetboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('46','','43','','sammy','beaver','12','','','0000-00-00','','','','','','','','','','','','','','','','','','','','','','','','','','1','','');


CREATE TABLE `client_office_map` (
  `office_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  PRIMARY KEY  (`office_id`,`client_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('0','0');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('0','34');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('0','35');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('0','37');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('1','0');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('1','7');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('1','8');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('1','9');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('1','10');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('1','11');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('1','12');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('1','13');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('1','14');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('1','15');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('1','16');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('1','17');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('1','18');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('1','19');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('1','20');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('1','21');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('1','23');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('1','24');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('1','26');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('1','27');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('1','28');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('1','30');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('1','31');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('1','38');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('1','39');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('1','40');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('1','43');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('1','44');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('1','45');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('1','56');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('1','57');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('1','58');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('5','32');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('5','33');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('5','34');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('6','31');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('7','21');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('8','35');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('8','36');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('8','41');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('8','42');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('8','44');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('8','45');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('9','37');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('9','38');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('9','39');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('9','40');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('10','43');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('10','46');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('23','20');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('23','22');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('23','25');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('26','26');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('26','27');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('26','28');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('26','29');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('52','53');
INSERT INTO vetboxx.client_office_map(`office_id`,`client_id`) VALUES('52','54');


CREATE TABLE `client_type` (
  `client_type_id` int(11) NOT NULL auto_increment,
  `client_description` varchar(122) default NULL,
  PRIMARY KEY  (`client_type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;



INSERT INTO vetboxx.client_type(`client_type_id`,`client_description`) VALUES('1',' ');
INSERT INTO vetboxx.client_type(`client_type_id`,`client_description`) VALUES('2','dog');
INSERT INTO vetboxx.client_type(`client_type_id`,`client_description`) VALUES('3','cat');
INSERT INTO vetboxx.client_type(`client_type_id`,`client_description`) VALUES('4','snake');
INSERT INTO vetboxx.client_type(`client_type_id`,`client_description`) VALUES('5','bird');
INSERT INTO vetboxx.client_type(`client_type_id`,`client_description`) VALUES('6','turtle');
INSERT INTO vetboxx.client_type(`client_type_id`,`client_description`) VALUES('7','lizard');
INSERT INTO vetboxx.client_type(`client_type_id`,`client_description`) VALUES('8','ferret');
INSERT INTO vetboxx.client_type(`client_type_id`,`client_description`) VALUES('9','horse');
INSERT INTO vetboxx.client_type(`client_type_id`,`client_description`) VALUES('10','pig');
INSERT INTO vetboxx.client_type(`client_type_id`,`client_description`) VALUES('11','other farm animal');
INSERT INTO vetboxx.client_type(`client_type_id`,`client_description`) VALUES('12','other rodent');
INSERT INTO vetboxx.client_type(`client_type_id`,`client_description`) VALUES('13','other mammal');
INSERT INTO vetboxx.client_type(`client_type_id`,`client_description`) VALUES('14','other reptile');
INSERT INTO vetboxx.client_type(`client_type_id`,`client_description`) VALUES('15','invertebrate');
INSERT INTO vetboxx.client_type(`client_type_id`,`client_description`) VALUES('16','other organism');


CREATE TABLE `content` (
  `content_id` int(11) NOT NULL auto_increment,
  `name` varchar(50) default NULL,
  `content` text,
  `icon_filename` varchar(50) default NULL,
  PRIMARY KEY  (`content_id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;



INSERT INTO vetboxx.content(`content_id`,`name`,`content`,`icon_filename`) VALUES('1','termsofuse',' VETBOXX.COM TERMS OF USE


1. ACCEPTANCE OF TERMS

VETBOXX.COM provides a collection of online and offline services &#40;referred to hereafter as "the 
Service"&#41; subject to the following Terms of Use &#40;"TOU"&#41;. By using the Service 
in any way, you are agreeing to comply with the TOU. In addition, when using 
particular VETBOXX.COM services, you agree to abide by any applicable posted 
guidelines for all VETBOXX.COM services, which may change from time to time.  
Should you object to any term or condition of the TOU, any guidelines, 
or any subsequent modifications thereto or become dissatisfied with VETBOXX.COM 
in any way, your only recourse is to immediately discontinue use of VETBOXX.COM.  
VETBOXX.COM has the right, but is not obligated, to strictly enforce the TOU 
through self-help, community moderation, active investigation, litigation and 
prosecution.


2. MODIFICATIONS TO THIS AGREEMENT

We reserve the right, at our sole discretion, to change, modify or otherwise 
alter these terms and conditions at any time.  Such modifications shall become 
effective immediately upon the posting thereof. You must review this agreement 
on a regular basis to keep yourself apprised of any changes. You can find the 
most recent version of the TOU at:

http://www.vetboxx.com/info.php?page_key=termsofuse


3. CONTENT

You understand that all postings, messages, text, files, images, photos, 
video, sounds, or other materials &#40;"Content"&#41; posted on, transmitted 
through, or linked from the Service, are the sole responsibility of the 
person from whom such Content originated. More specifically, you are 
entirely responsible for each individual item &#40;"Item"&#41; of Content that you 
post, email or otherwise make available via the Service. You understand that 
VETBOXX.COM does not control, and is not responsible for Content made available 
through the Service, and that by using the Service, you may be exposed to 
Content that is offensive, indecent, inaccurate, misleading, or otherwise 
objectionable. Furthermore, the VETBOXX.COM site and Content available through 
the Service may contain links to other websites, which are completely 
independent of VETBOXX.COM .  VETBOXX.COM makes no representation or warranty as 
to the accuracy, completeness or authenticity of the information contained 
in any such site.  Your linking to any other websites is at your own risk. 
You agree that you must evaluate, and bear all risks associated with, the 
use of any Content, that you may not rely on said Content, and that under no 
circumstances will VETBOXX.COM be liable in any way for any Content or for 
any loss or damage of any kind incurred as a result of the use of any Content 
posted, emailed or otherwise made available via the Service. You acknowledge 
that VETBOXX.COM does not pre-screen or approve Content, but that VETBOXX.COM 
shall have the right &#40;but not the obligation&#41; in its sole discretion to 
refuse, delete or move any Content that is available via the Service, for 
violating the letter or spirit of the TOU or for any other reason.


4. THIRD PARTY CONTENT, SITES, AND SERVICES

The VETBOXX.COM site and Content available through the Service may contain 
features and functionalities that may link you or provide you with access 
to third party content which is completely independent of VETBOXX.COM , 
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

You agree that VETBOXX.COM shall not be responsible or liable for any loss or 
damage of any sort incurred as the result of any such dealings. If there is 
a dispute between participants on this site, or between users and any third 
party, you understand and agree that VETBOXX.COM is under no obligation to 
become involved. In the event that you have a dispute with one or more other 
users, you hereby release VETBOXX.COM , its officers, employees, agents and 
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
otherwise violated, please notify VETBOXX.COM&#39;s agent for notice of claims of 
copyright or other intellectual property infringement &#40;"Agent"&#41;, at

abuse@VETBOXX.COM.org

or:

Copyright Agent
VETBOXX.COM 
3 VetBoxx Tower
New York, NY
10012

Please provide our Agent with the following Notice:

a&#41; Identify the material on the VETBOXX.COM  site that you claim is 
infringing, with enough detail so that we may locate it on the website;

b&#41; A statement by you that you have a good faith belief that the disputed 
use is not authorized by the copyright owner, its agent, or the law;

c&#41; A statement by you declaring under penalty of perjury that &#40;1&#41; the above 
information in your Notice is accurate, and &#40;2&#41; that you are the owner of 
the copyright interest involved or that you are authorized to act on behalf 
of that owner;

d&#41; Your address, telephone number, and email address; and

e&#41; Your physical or electronic signature.

VETBOXX.COM will remove the infringing posting&#40;s&#41;, subject to the the procedures 
outlined in the Digital Millennium Copyright Act &#40;DMCA&#41;.


6. PRIVACY AND INFORMATION DISCLOSURE

VETBOXX.COM has established a Privacy Policy to explain to users how their 
information is collected and used, which is located at the following web 
address: 

http://www.vetboxx.com/info.php?page_key=privacypolicy

Your use of the VETBOXX.COM website or the Service signifies acknowledgement of 
and agreement to our Privacy Policy. You further acknowledge and agree that 
VETBOXX.COM may, in its sole discretion, preserve or disclose your Content, 
as well as your information, such as email addresses, IP addresses, timestamps, 
and other user information, if required to do so by law or in the good faith 
belief that such preservation or disclosure is reasonably necessary to: 
comply with legal process; enforce the TOU; respond to claims that any 
Content violates the rights of third-parties; respond to claims that contact 
information &#40;e.g. phone number, street address&#41; of a third-party has been 
posted or transmitted without their consent or as a form of harassment; 
protect the rights, property, or personal safety of VETBOXX.COM, its users or 
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
VETBOXX.COM employee, or falsely states or otherwise misrepresents your 
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
posted in areas of the VETBOXX.COM sites which are not designated for such 
purposes; or emailed to VETBOXX.COM users who have not indicated in writing that 
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
permitted by VETBOXX.COM;

u&#41; post non-local or otherwise irrelevant Content, repeatedly post the 
same or similar Content or otherwise impose an unreasonable or 
disproportionately large load on our infrastructure;

v&#41; post the same item or service in more than one classified category or 
forum, or in more than one metropolitan area;

w&#41; attempt to gain unauthorized access to VETBOXX.COM&#39;s computer systems or 
engage in any activity that disrupts, diminishes the quality of, interferes 
with the performance of, or impairs the functionality of, the Service or 
the VETBOXX.COM website; or

x&#41; use any form of automated device or computer program that enables the 
submission of postings on VETBOXX.COM without each posting being manually 
entered by the author thereof &#40;an "automated posting device"&#41;, including 
without limitation, the use of any such automated posting device to submit 
postings in bulk, or for automatic submission of postings at regular intervals.

y&#41; use any form of automated device or computer program &#40;"flagging tool"&#41;
that enables the use of VETBOXX.COM&#39;s "flagging system" or other community
moderation systems without each flag being manually entered by the person
that initiates the flag &#40;an "automated flagging device"&#41;, or use the
flagging tool to remove posts of competitors, or to remove posts without a
good faith belief that the post being flagged violates these TOU;

8. POSTING AGENTS

A "Posting Agent" is a third-party agent, service, or intermediary
that offers to post Content to the Service on behalf of others. To 
moderate demands on VETBOXX.COM&#39;s resources, you may not use a Posting 
Agent to post Content to the Service without express permission or 
license from VETBOXX.COM.  Correspondingly, Posting Agents are not 
permitted to post Content on behalf of others, to cause Content to 
be so posted, or otherwise access the Service to facilitate posting 
Content on behalf of others, except with express permission or 
license from VETBOXX.COM.


9. NO SPAM POLICY

You understand and agree that sending unsolicited email advertisements to 
VETBOXX.COM email addresses or through VETBOXX.COM computer systems, which is 
expressly prohibited by these Terms, will use or cause to be used servers 
located in California.  Any unauthorized use of  VETBOXX.COM computer systems 
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

You acknowledge that VETBOXX.COM may establish limits concerning use of the 
Service, including the maximum number of days that Content will be retained 
by the Service, the maximum number and size of postings, email messages, or 
other Content that may be transmitted or stored by the Service, and the 
frequency with which you may access the Service. You agree that VETBOXX.COM 
has no responsibility or liability for the deletion or failure to store any 
Content maintained or transmitted by the Service. You acknowledge that 
VETBOXX.COM reserves the right at any time to modify or discontinue the 
Service &#40;or any part thereof&#41; with or without notice, and that VETBOXX.COM 
shall not be liable to you or to any third party for any modification, 
suspension or discontinuance of the Service.


12. ACCESS TO THE SERVICE

VETBOXX.COM grants you a limited, revocable, nonexclusive license to access 
the Service for your own personal use.  This license does not include: 
&#40;a&#41; access to the Service by Posting Agents; or &#40;b&#41; any collection, 
aggregation, copying, duplication, display or derivative use of the Service 
nor any use of data mining, robots, spiders, or similar data gathering and 
extraction tools for any purpose unless expressly permitted by VETBOXX.COM. 
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

VETBOXX.COM permits you to display on your website, or create a hyperlink 
on your website to, individual postings on the Service so long as such use 
is for noncommercial and/or news reporting purposes only &#40;e.g., for use in 
personal web blogs or personal online media&#41;.  If the total number of such 
postings displayed or linked to on your website exceeds one hundred &#40;100&#41; 
postings, your use will be presumed to be in violation of the TOU, 
absent express permission granted by VETBOXX.COM to do so.  You may also 
create a hyperlink to the home page of VETBOXX.COM sites so long as the 
link does not portray VETBOXX.COM, its employees, or its affiliates in a 
false, misleading, derogatory, or otherwise offensive matter.

VETBOXX.COM offers various parts of the Service in RSS format so that users 
can embed individual feeds into a personal website or blog, or view postings 
through third party software news aggregators.  VETBOXX.COM permits you to 
display, excerpt from, and link to the RSS feeds on your personal website 
or personal web blog, provided that &#40;a&#41; your use of the RSS feed is for 
personal, non-commercial purposes only, &#40;b&#41; each title is correctly linked 
back to the original post on the Service and redirects the user to the 
post when the user clicks on it, &#40;c&#41; you provide, adjacent to the RSS 
feed, proper attribution to &#39;VETBOXX.COM&#39; as the source, &#40;d&#41; your use or 
display does not suggest that VETBOXX.COM promotes or endorses any third 
party causes, ideas, web sites, products or services, &#40;e&#41; you do not 
redistribute the RSS feed, and &#40;f&#41; your use does not overburden 
VETBOXX.COM&#39;s systems.  VETBOXX.COM reserves all rights in the content of 
the RSS feeds and may terminate any RSS feed at any time.

Use of the Service beyond the scope of authorized access granted to you by 
VETBOXX.COM immediately terminates said permission or license.  In order to 
collect, aggregate, copy, duplicate, display or make derivative use of the 
the Service or any Content made available via the Service for other 
purposes &#40;including commercial purposes&#41; not stated herein, you must first 
obtain a license from VETBOXX.COM.


13. TERMINATION OF SERVICE

You agree that VETBOXX.COM, in its sole discretion, has the right &#40;but not 
the obligation&#41; to delete or deactivate your account, block your email or IP 
address, or otherwise terminate your access to or use of the Service &#40;or any 
part thereof&#41;, immediately and without notice, and remove and discard any 
Content within the Service, for any reason, including, without limitation, 
if VETBOXX.COM believes that you have acted inconsistently with the letter or 
spirit of the TOU. Further, you agree that VETBOXX.COM shall not be liable 
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
written consent of VETBOXX.COM. You further agree not to reproduce, 
duplicate or copy Content from the Service without the express written 
consent of VETBOXX.COM, and agree to abide by any and all copyright notices 
displayed on the Service. You may not decompile or disassemble, reverse 
engineer or otherwise attempt to discover any source code contained in the 
Service. Without limiting the foregoing, you agree not to reproduce, 
duplicate, copy, sell, resell or exploit for any commercial purposes, any 
aspect of the Service. VETBOXX.COM is a registered mark in the U.S. Patent 
and Trademark Office.

Although VETBOXX.COM does not claim ownership of content that its users post, 
by posting Content to any public area of the Service, you automatically 
grant, and you represent and warrant that you have the right to grant, to 
VETBOXX.COM an irrevocable, perpetual, non-exclusive, fully paid, worldwide 
license to use, copy, perform, display, and distribute said Content and to 
prepare derivative works of, or incorporate into other works, said Content, 
and to grant and authorize sublicenses &#40;through multiple tiers&#41; of the 
foregoing. Furthermore, by posting Content to any public area of the Service, 
you automatically grant VETBOXX.COM all rights necessary to prohibit any 
subsequent aggregation, display, copying, duplication, reproduction, or 
exploitation of the Content on the Service by any party for any purpose.


15. DISCLAIMER OF WARRANTIES

YOU AGREE THAT USE OF THE VETBOXX.COM SITE AND THE SERVICE IS ENTIRELY AT 
YOUR OWN RISK. THE VETBOXX.COM SITE AND THE SERVICE ARE PROVIDED ON AN "AS 
IS" OR "AS AVAILABLE" BASIS, WITHOUT ANY WARRANTIES OF ANY KIND.  ALL 
EXPRESS AND IMPLIED WARRANTIES, INCLUDING, WITHOUT LIMITATION, THE 
WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE, AND 
NON-INFRINGEMENT OF PROPRIETARY RIGHTS ARE EXPRESSLY DISCLAIMED TO THE 
FULLEST EXTENT PERMITTED BY LAW.  TO THE FULLEST EXTENT PERMITTED BY LAW, 
VETBOXX.COM DISCLAIMS ANY WARRANTIES FOR THE SECURITY, RELIABILITY, 
TIMELINESS, ACCURACY, AND PERFORMANCE OF THE VETBOXX.COM SITE AND THE 
SERVICE.  TO THE FULLEST EXTENT PERMITTED BY LAW, VETBOXX.COM DISCLAIMS ANY 
WARRANTIES FOR OTHER SERVICES OR GOODS RECEIVED THROUGH OR ADVERTISED ON THE 
VETBOXX.COM SITE OR THE SITES OR SERVICE, OR ACCESSED THROUGH ANY LINKS ON 
THE VETBOXX.COM SITE.  TO THE FULLEST EXTENT PERMITTED BY LAW, VETBOXX.COM 
DISCLAIMS ANY WARRANTIES FOR VIRUSES OR OTHER HARMFUL COMPONENTS IN 
CONNECTION WITH THE VETBOXX.COM SITE OR THE SERVICE.  Some jurisdictions do 
not allow the disclaimer of implied warranties.  In such jurisdictions, some 
of the foregoing disclaimers may not apply to you insofar as they relate to 
implied warranties.


16. LIMITATIONS OF LIABILITY

UNDER NO CIRCUMSTANCES SHALL VETBOXX.COM BE LIABLE FOR DIRECT, INDIRECT, 
INCIDENTAL, SPECIAL, CONSEQUENTIAL OR EXEMPLARY DAMAGES &#40;EVEN IF VETBOXX.COM 
HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES&#41;, RESULTING FROM ANY 
ASPECT OF YOUR USE OF THE VETBOXX.COM SITE OR THE SERVICE, WHETHER THE 
DAMAGES ARISE FROM USE OR MISUSE OF THE VETBOXX.COM SITE OR THE SERVICE, FROM 
INABILITY TO USE THE VETBOXX.COM SITE OR THE SERVICE, OR THE INTERRUPTION, 
SUSPENSION, MODIFICATION, ALTERATION, OR TERMINATION OF THE VETBOXX.COM SITE 
OR THE SERVICE.  SUCH LIMITATION SHALL ALSO APPLY WITH RESPECT TO DAMAGES 
INCURRED BY REASON OF OTHER SERVICES OR PRODUCTS RECEIVED THROUGH OR 
ADVERTISED IN CONNECTION WITH THE VETBOXX.COM SITE OR THE SERVICE OR ANY 
LINKS ON THE VETBOXX.COM SITE, AS WELL AS BY REASON OF ANY INFORMATION OR 
ADVICE RECEIVED THROUGH OR ADVERTISED IN CONNECTION WITH THE VETBOXX.COM SITE 
OR THE SERVICE OR ANY LINKS ON THE VETBOXX.COM SITE.  THESE LIMITATIONS SHALL 
APPLY TO THE FULLEST EXTENT PERMITTED BY LAW. In some jurisdictions, 
limitations of liability are not permitted.  In such jurisdictions, some of 
the foregoing limitation may not apply to you.


17. INDEMNITY

You agree to indemnify and hold VETBOXX.COM, its officers, subsidiaries, 
affiliates, successors, assigns, directors, officers, agents, service 
providers, suppliers and employees, harmless from any claim or demand, 
including reasonable attorney fees and court costs, made by any third party 
due to or arising out of Content you submit, post or make available through 
the Service, your use of the Service, your violation of the TOU, your 
breach of any of the representations and warranties herein, or your 
violation of any rights of another.


18. GENERAL INFORMATION

The TOU constitute the entire agreement between you and VETBOXX.COM and 
govern your use of the Service, superceding any prior agreements between you 
and VETBOXX.COM. The TOU and the relationship between you and VETBOXX.COM 
shall be governed by the laws of the State of California without regard to 
its conflict of law provisions. You and VETBOXX.COM agree to submit to the 
personal and exclusive jurisdiction of the courts located within the county 
of San Francisco, California. The failure of VETBOXX.COM to exercise or 
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

abuse@VETBOXX.COM 

Our failure to act with respect to a breach by you or others does not waive our 
right to act with respect to subsequent or similar breaches.

You understand and agree that, because damages are often difficult to quantify, 
if it becomes necessary for VETBOXX.COM to pursue legal action to enforce these 
Terms, you will be liable to pay VETBOXX.COM the following amounts as liquidated 
damages, which you accept as reasonable estimates of VETBOXX.COM&#39; damages for 
the specified breaches of these Terms:

a. If you post a message that &#40;1&#41; impersonates any person or entity; &#40;2&#41; 
falsely states or otherwise misrepresents your affiliation with a person or 
entity; or &#40;3&#41; that includes personal or identifying information about 
another person without that person&#39;s explicit consent, you agree to pay 
VETBOXX.COM one thousand dollars &#40;$1,000&#41; for each such message.  
This provision does not apply to Content that constitutes lawful non-deceptive 
parody of public figures.

b. If VETBOXX.COM establishes limits on the frequency with which you may 
access the Service, or terminates your access to or use of the Service, you 
agree to pay VETBOXX.COM one hundred dollars &#40;$100&#41; for each message posted 
in excess of such limits or for each day on which you access VETBOXX.COM in 
excess of such limits, whichever is higher.

c. If you send unsolicited email advertisements to VETBOXX.COM email 
addresses or through VETBOXX.COM computer systems, you agree to pay 
VETBOXX.COM twenty five dollars &#40;$25&#41; for each such email.

d. If you post Content in violation of the TOU, other than as described 
above, you agree to pay VETBOXX.COM one hundred dollars &#40;$100&#41; for each 
Item of Content posted.  In its sole discretion, VETBOXX.COM may elect 
to issue a warning before assessing damages.

e. If you are a Posting Agent that uses the Service in violation of the
TOU, in addition to any liquidated damages under clause &#40;d&#41;, you agree to
pay VETBOXX.COM one hundred dollars &#40;$100&#41; for each and every Item you post
in violation of the TOU.  A Posting Agent will also be deemed an agent of
the party engaging the Posting Agent to access the Service &#40;the
"Principal"&#41;, and the Principal &#40;by engaging the Posting Agent in
violation of the TOU&#41; agrees to pay VETBOXX.COM an additional one hundred
dollars &#40;$100&#41; for each Item posted by the Posting Agent on behalf of
the Principal in violation of the TOU.

f. If you aggregate, display, copy, duplicate, reproduce, or otherwise 
exploit for any purpose any Content &#40;except for your own Content&#41; in 
violation of these Terms without VETBOXX.COM&#39;s express written permission, 
you agree to pay VETBOXX.COM three thousand dollars &#40;$3,000&#41; for each day 
on which you engage in such conduct.

Otherwise, you agree to pay VETBOXX.COM&#39;s actual damages, to the extent such 
actual damages can be reasonably calculated. Notwithstanding any other 
provision of these Terms, VETBOXX.COM retains the right to seek the remedy 
of specific performance of any term contained in these Terms, or a preliminary 
or permanent injunction against the breach of any such term or in aid of the 
exercise of any power granted in these Terms, or any combination thereof.


20. FEEDBACK

We welcome your questions and comments on this document in the VETBOXX.COM 
feedback form:        

http://vetboxx.com/contact.php 

','');
INSERT INTO vetboxx.content(`content_id`,`name`,`content`,`icon_filename`) VALUES('3','privacypolicy','Your Privacy

VETBOXX.COM is committed to protecting your privacy. We only use the information we collect about you to process orders and to provide support and upgrades for our products. Please read on for more details about our privacy policy.

What information do we collect? How do we use it?

When you order, we need to know your name, e-mail address, mailing address, credit card number, and expiration date. This allows us to process and fulfill your order and to notify you of your order status. When you enter a contest or other promotional feature, we may ask for your name, address, and e-mail address so we can administer the contest and notify winners.

How does VETBOXX.COM protect customer information?

We use a Secure Server for collecting personal and credit card information. The secure server layer &#40;SSL&#41; encrypts &#40;scrambles&#41; all of the information you enter before it is transmitted over the internet and sent to us. Furthermore, all of the customer data we collect is protected against unauthorized access.

What about "cookies"?

"Cookies" are small pieces of information that are stored by your browser on your computer&#39;s hard drive. We do not use cookies to collect or store any information about visitors or customers.

Will VETBOXX.COM disclose the information it collects to outside parties?

VETBOXX.COM does not sell, trade, or rent your personal information to others. VETBOXX.COM may provide aggregate statistics about our customers, sales, traffic patterns, and related site information to reputable third-party vendors, but these statistics will not include personally identifying information.

VETBOXX.COM may release account information when we believe, in good faith, that such release is reasonably necessary to &#40;i&#41; comply with law, &#40;ii&#41; enforce or apply the terms of any of our user agreements or &#40;iii&#41; protect the rights, property or safety of VETBOXX.COM, our users, or others.

In Summary

VETBOXX.COM is committed to protecting your privacy. We use the information we collect on the site to make shopping at SimpleJoe.com as simple as possible and to enhance your overall shopping experience. We do not sell, trade, or rent your personal information to others.

Your Consent

By using our Web site, you consent to the collection and use of this information by VETBOXX.COM, Inc. If we decide to change our privacy policy, we will post those changes on this page so that you are always aware of what information we collect, how we use it, and under what circumstances we disclose it.

VETBOXX.COM also provides links to affiliated sites. The privacy policies of these linked sites are the responsibility of the linked site and VETBOXX.COM has no control or influence over their policies. Please check the policies of each site you visit for specific information. VETBOXX.COM cannot be held liable for damage or misdoings of other sites linked or otherwise.
','');
INSERT INTO vetboxx.content(`content_id`,`name`,`content`,`icon_filename`) VALUES('2','homepage blurb','<div style="font-style: italic; font-size:1.5em; text-align:right; color:#00ABDD;font-weight:bold;">Appoint. Remind.</div><br />
Welcome to <strong><span style="color:#00ABDD;">Vet</span>Boxx</strong>: your online appointment and reminder system. Eliminate guesswork while saving thousands of dollars a year in staff costs and time. Access your appointment book from any computer or smart phone, remind owners of appointments without lifting a finger.
<br /><br /><strong><span style="color:#00ABDD;">Vet</span>Boxx</strong> offers programs starting at just $49 per year per office. Take appointments and scheduling into the 21<sup><small>st</small></sup> century!','');
INSERT INTO vetboxx.content(`content_id`,`name`,`content`,`icon_filename`) VALUES('4','jobs','VetBoxx is hiring!

Currently we are looking for a phone system specialist. Must have 5+ years experience with Linux and at least a year&#39;s experience with Asterisk.','');
INSERT INTO vetboxx.content(`content_id`,`name`,`content`,`icon_filename`) VALUES('5','support','Need support?  You&#39;re outta luck! We have no support staff at this time!','');
INSERT INTO vetboxx.content(`content_id`,`name`,`content`,`icon_filename`) VALUES('6','whatwedo','VetBoxx is a system for organizing your office reminder system. Blah blah.','');
INSERT INTO vetboxx.content(`content_id`,`name`,`content`,`icon_filename`) VALUES('11','what-mb-does:patientreg','1. Patient Registration','patrientreg_icon.png');
INSERT INTO vetboxx.content(`content_id`,`name`,`content`,`icon_filename`) VALUES('15','what-mb-does:infobox','','');
INSERT INTO vetboxx.content(`content_id`,`name`,`content`,`icon_filename`) VALUES('16','what-mb-does:scheduling','<strong>1. Scheduling Appointments and Calendars</strong>
<br />Finally, you don&#39;t need to be at the office to see your appointment calendar. VetBoxx takes appointment scheduling into the 21st century by allowing online, out-of-office appointment making and review by computer or smart phone. View up-to-the-minute appointments and calendars for all doctors and staff, wherever you are. Search easily for owner appointments, current and past, without randomly flipping through calendar pages. Our scheduling calendar even accepts multiple appointments for the same time for the same doctor or staff member.','patrientrcal_icon.png');
INSERT INTO vetboxx.content(`content_id`,`name`,`content`,`icon_filename`) VALUES('17','what-mb-does:patientreminders','<strong>2. Owner Reminders</strong><br />
Take the hassle out of owner confirmations and reminders. Let VetBoxx save you precious time and effort through our easily customized automated email and phone appointment reminders. For example, patients could receive 3 email reminders: 5 months before, 1 month before, 3 days before plus a phone call reminder the day before the appointment. Each reminder will give owners one of three options: accept the appointment, request an office call to change the appointment, or cancel the appointment.','patrientrclock_icon.png');
INSERT INTO vetboxx.content(`content_id`,`name`,`content`,`icon_filename`) VALUES('20','what-mb-does:top','How VetBoxx Supports Your Front Desk And Lowers Your Costs Dramatically','spacer.png');
INSERT INTO vetboxx.content(`content_id`,`name`,`content`,`icon_filename`) VALUES('19','what-mb-does:bottombuttons','<table width=760 height=40>
<tr>
<td><a href=reg.php?x_mode=office><img src=images/signupfor.png border=0></a></td> 
<td><a href=reg.php?x_mode=office><img src=images/tryfree.png border=0></a></td>  
</tr>
</table>','');
INSERT INTO vetboxx.content(`content_id`,`name`,`content`,`icon_filename`) VALUES('21','login not yet added office','Not yet  added your office to VetBoxx.com? [Register] to streamline your office work and automate your reminders.','');
INSERT INTO vetboxx.content(`content_id`,`name`,`content`,`icon_filename`) VALUES('22','login not yet added client','Not yet    added your patient profile to VetBoxx.com? [Register] to speed your office visits and receive appointment reminders.','');


CREATE TABLE `event_status` (
  `event_status_id` int(11) NOT NULL auto_increment,
  `status_name` varchar(50) default NULL,
  PRIMARY KEY  (`event_status_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;



INSERT INTO vetboxx.event_status(`event_status_id`,`status_name`) VALUES('1','no response');
INSERT INTO vetboxx.event_status(`event_status_id`,`status_name`) VALUES('2','yes');
INSERT INTO vetboxx.event_status(`event_status_id`,`status_name`) VALUES('3','no');
INSERT INTO vetboxx.event_status(`event_status_id`,`status_name`) VALUES('4','call');


CREATE TABLE `formlog` (
  `formlog_id` int(11) NOT NULL auto_increment,
  `time_done` timestamp NULL default NULL,
  `ip_address` varchar(33) default NULL,
  `referer` varchar(211) default NULL,
  `label` varchar(222) default NULL,
  `form_content` text,
  `comments` text,
  PRIMARY KEY  (`formlog_id`)
) ENGINE=MyISAM AUTO_INCREMENT=231 DEFAULT CHARSET=latin1;



INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('1','2010-07-30 21:04:50','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:194;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-09 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:04:50";s:1:"i";i:0;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('2','2010-07-30 21:04:50','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:194;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-21 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:04:50";s:1:"i";i:1;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('3','2010-07-30 21:04:50','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:194;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-25 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:04:50";s:1:"i";i:2;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('4','2010-07-30 21:04:50','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:194;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-07-26 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:04:50";s:1:"i";i:3;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('5','2010-07-30 21:04:50','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:194;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-07-26 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:04:50";s:1:"i";i:4;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('6','2010-07-30 21:04:50','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:194;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-07-26 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:04:50";s:1:"i";i:5;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('7','2010-07-30 21:05:41','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:195;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-09 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:05:41";s:1:"i";i:0;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('8','2010-07-30 21:05:41','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:195;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-21 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:05:41";s:1:"i";i:1;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('9','2010-07-30 21:05:41','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:195;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-25 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:05:41";s:1:"i";i:2;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('10','2010-07-30 21:05:41','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:195;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-07-26 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:05:41";s:1:"i";i:3;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('11','2010-07-30 21:05:41','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:195;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-07-26 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:05:41";s:1:"i";i:4;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('12','2010-07-30 21:05:41','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:195;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-07-26 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:05:41";s:1:"i";i:5;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('13','2010-07-30 21:08:31','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:196;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-10 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:08:31";s:1:"i";i:0;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('14','2010-07-30 21:08:31','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:196;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-22 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:08:31";s:1:"i";i:1;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('15','2010-07-30 21:08:31','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:196;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-26 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:08:31";s:1:"i";i:2;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('16','2010-07-30 21:08:31','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:196;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-07-27 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:08:31";s:1:"i";i:3;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('17','2010-07-30 21:08:31','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:196;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-07-27 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:08:31";s:1:"i";i:4;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('18','2010-07-30 21:08:31','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:196;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-07-27 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:08:31";s:1:"i";i:5;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('19','2010-07-30 21:09:17','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:197;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-10 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:09:17";s:1:"i";i:0;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('20','2010-07-30 21:09:17','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:197;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-22 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:09:17";s:1:"i";i:1;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('21','2010-07-30 21:09:17','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:197;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-26 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:09:17";s:1:"i";i:2;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('22','2010-07-30 21:09:17','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:197;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-07-27 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:09:17";s:1:"i";i:3;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('23','2010-07-30 21:09:17','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:197;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-07-27 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:09:17";s:1:"i";i:4;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('24','2010-07-30 21:09:17','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:197;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-07-27 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:09:17";s:1:"i";i:5;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('25','2010-07-30 21:09:31','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:198;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-11 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:09:31";s:1:"i";i:0;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('26','2010-07-30 21:09:31','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:198;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-23 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:09:31";s:1:"i";i:1;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('27','2010-07-30 21:09:31','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:198;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-27 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:09:31";s:1:"i";i:2;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('28','2010-07-30 21:09:31','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:198;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-07-28 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:09:31";s:1:"i";i:3;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('29','2010-07-30 21:09:31','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:198;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-07-28 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:09:31";s:1:"i";i:4;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('30','2010-07-30 21:09:31','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:198;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-07-28 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:09:31";s:1:"i";i:5;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('31','2010-07-30 21:09:58','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:199;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-11 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:09:58";s:1:"i";i:0;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('32','2010-07-30 21:09:58','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:199;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-23 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:09:58";s:1:"i";i:1;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('33','2010-07-30 21:09:58','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:199;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-27 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:09:58";s:1:"i";i:2;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('34','2010-07-30 21:09:58','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:199;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-07-28 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:09:58";s:1:"i";i:3;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('35','2010-07-30 21:09:58','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:199;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-07-28 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:09:58";s:1:"i";i:4;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('36','2010-07-30 21:09:58','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:199;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-07-28 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:09:58";s:1:"i";i:5;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('37','2010-07-30 21:10:47','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:200;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-12 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:10:47";s:1:"i";i:0;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('38','2010-07-30 21:10:47','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:200;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-24 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:10:47";s:1:"i";i:1;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('39','2010-07-30 21:10:47','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:200;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-28 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:10:47";s:1:"i";i:2;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('40','2010-07-30 21:10:47','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:200;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-07-29 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:10:47";s:1:"i";i:3;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('41','2010-07-30 21:10:47','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:200;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-07-29 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:10:47";s:1:"i";i:4;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('42','2010-07-30 21:10:47','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:200;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-07-29 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:10:47";s:1:"i";i:5;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('43','2010-07-30 21:11:08','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:201;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-12 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:11:08";s:1:"i";i:0;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('44','2010-07-30 21:11:08','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:201;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-24 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:11:08";s:1:"i";i:1;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('45','2010-07-30 21:11:09','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:201;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-28 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:11:09";s:1:"i";i:2;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('46','2010-07-30 21:11:09','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:201;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-07-29 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:11:09";s:1:"i";i:3;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('47','2010-07-30 21:11:09','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:201;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-07-29 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:11:09";s:1:"i";i:4;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('48','2010-07-30 21:11:09','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:201;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-07-29 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:11:09";s:1:"i";i:5;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('49','2010-07-30 21:13:43','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:202;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-13 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:13:43";s:1:"i";i:0;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('50','2010-07-30 21:13:43','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:202;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-25 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:13:43";s:1:"i";i:1;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('51','2010-07-30 21:13:43','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:202;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-29 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:13:43";s:1:"i";i:2;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('52','2010-07-30 21:13:43','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:202;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-07-30 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:13:43";s:1:"i";i:3;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('53','2010-07-30 21:13:43','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:202;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-07-30 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:13:43";s:1:"i";i:4;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('54','2010-07-30 21:13:43','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:202;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-07-30 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:13:43";s:1:"i";i:5;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('55','2010-07-30 21:14:24','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:203;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-13 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:14:24";s:1:"i";i:0;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('56','2010-07-30 21:14:24','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:203;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-25 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:14:24";s:1:"i";i:1;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('57','2010-07-30 21:14:24','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:203;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-29 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:14:24";s:1:"i";i:2;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('58','2010-07-30 21:14:24','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:203;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-07-30 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:14:24";s:1:"i";i:3;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('59','2010-07-30 21:14:24','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:203;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-07-30 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:14:24";s:1:"i";i:4;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('60','2010-07-30 21:14:24','140.163.254.27','http://harrys.vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:203;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-07-30 00:00:00";s:10:"actualtime";s:19:"2010-07-30 21:14:24";s:1:"i";i:5;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('61','2010-07-31 14:58:12','71.246.183.178','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:204;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-12 00:00:00";s:10:"actualtime";s:19:"2010-07-31 14:58:12";s:1:"i";i:0;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('62','2010-07-31 14:58:12','71.246.183.178','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:204;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-21 00:00:00";s:10:"actualtime";s:19:"2010-07-31 14:58:12";s:1:"i";i:1;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('63','2010-07-31 14:58:12','71.246.183.178','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:204;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-21 00:00:00";s:10:"actualtime";s:19:"2010-07-31 14:58:12";s:1:"i";i:2;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('64','2010-07-31 14:58:12','71.246.183.178','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:204;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-07-29 00:00:00";s:10:"actualtime";s:19:"2010-07-31 14:58:12";s:1:"i";i:3;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('65','2010-07-31 14:58:12','71.246.183.178','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:204;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-07-29 00:00:00";s:10:"actualtime";s:19:"2010-07-31 14:58:12";s:1:"i";i:4;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('66','2010-07-31 14:58:12','71.246.183.178','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:204;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-07-29 00:00:00";s:10:"actualtime";s:19:"2010-07-31 14:58:12";s:1:"i";i:5;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('67','2010-07-31 21:27:20','70.110.110.193','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:205;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-11 00:00:00";s:10:"actualtime";s:19:"2010-07-31 21:27:20";s:1:"i";i:0;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('68','2010-07-31 21:27:20','70.110.110.193','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:205;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-20 00:00:00";s:10:"actualtime";s:19:"2010-07-31 21:27:20";s:1:"i";i:1;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('69','2010-07-31 21:27:20','70.110.110.193','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:205;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-20 00:00:00";s:10:"actualtime";s:19:"2010-07-31 21:27:20";s:1:"i";i:2;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('70','2010-07-31 21:27:20','70.110.110.193','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:205;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-07-28 00:00:00";s:10:"actualtime";s:19:"2010-07-31 21:27:20";s:1:"i";i:3;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('71','2010-07-31 21:27:20','70.110.110.193','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:205;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-07-28 00:00:00";s:10:"actualtime";s:19:"2010-07-31 21:27:20";s:1:"i";i:4;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('72','2010-07-31 21:27:20','70.110.110.193','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:205;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-07-28 00:00:00";s:10:"actualtime";s:19:"2010-07-31 21:27:20";s:1:"i";i:5;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('73','2010-08-01 22:24:57','70.110.101.221','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:206;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-19 00:00:00";s:10:"actualtime";s:19:"2010-08-01 22:24:57";s:1:"i";i:0;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('74','2010-08-01 22:24:57','70.110.101.221','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:206;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-31 00:00:00";s:10:"actualtime";s:19:"2010-08-01 22:24:57";s:1:"i";i:1;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('75','2010-08-01 22:24:57','70.110.101.221','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:206;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 00:12:00";s:10:"actualtime";s:19:"2010-08-01 22:24:57";s:1:"i";i:4;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('76','2010-08-01 22:24:57','70.110.101.221','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:206;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 00:12:00";s:10:"actualtime";s:19:"2010-08-01 22:24:57";s:1:"i";i:5;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('77','2010-08-01 22:41:12','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=109&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-19 00:00:00";s:10:"actualtime";s:19:"2010-08-01 22:41:12";s:1:"i";i:0;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('78','2010-08-01 22:41:12','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=109&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-31 00:00:00";s:10:"actualtime";s:19:"2010-08-01 22:41:12";s:1:"i";i:1;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('79','2010-08-01 22:41:12','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=109&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 00:19:00";s:10:"actualtime";s:19:"2010-08-01 22:41:12";s:1:"i";i:4;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('80','2010-08-01 22:41:12','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=109&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 00:19:00";s:10:"actualtime";s:19:"2010-08-01 22:41:12";s:1:"i";i:5;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('81','2010-08-01 22:41:56','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=109&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-19 00:00:00";s:10:"actualtime";s:19:"2010-08-01 22:41:56";s:1:"i";i:0;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('82','2010-08-01 22:41:56','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=109&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-31 00:00:00";s:10:"actualtime";s:19:"2010-08-01 22:41:56";s:1:"i";i:1;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('83','2010-08-01 22:41:56','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=109&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 00:08:00";s:10:"actualtime";s:19:"2010-08-01 22:41:56";s:1:"i";i:4;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('84','2010-08-01 22:41:56','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=109&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 00:08:00";s:10:"actualtime";s:19:"2010-08-01 22:41:56";s:1:"i";i:5;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('85','2010-08-01 22:57:38','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A30%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-19 00:00:00";s:10:"actualtime";s:19:"2010-08-01 22:57:38";s:1:"i";i:0;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('86','2010-08-01 22:57:38','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A30%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-31 00:00:00";s:10:"actualtime";s:19:"2010-08-01 22:57:38";s:1:"i";i:1;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('87','2010-08-01 22:58:34','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A30%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-19 00:00:00";s:10:"actualtime";s:19:"2010-08-01 22:58:34";s:1:"i";i:0;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('88','2010-08-01 22:58:34','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A30%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-31 00:00:00";s:10:"actualtime";s:19:"2010-08-01 22:58:34";s:1:"i";i:1;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('89','2010-08-01 22:58:48','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A30%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-19 00:00:00";s:10:"actualtime";s:19:"2010-08-01 22:58:48";s:1:"i";i:0;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('90','2010-08-01 22:58:48','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A30%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-31 00:00:00";s:10:"actualtime";s:19:"2010-08-01 22:58:48";s:1:"i";i:1;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('91','2010-08-01 22:58:48','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A30%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 00:13:00";s:10:"actualtime";s:19:"2010-08-01 22:58:48";s:1:"i";i:4;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('92','2010-08-01 22:58:48','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A30%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 00:13:00";s:10:"actualtime";s:19:"2010-08-01 22:58:48";s:1:"i";i:5;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('93','2010-08-01 22:59:47','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=109&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-19 00:00:00";s:10:"actualtime";s:19:"2010-08-01 22:59:47";s:1:"i";i:0;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('94','2010-08-01 22:59:47','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=109&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-31 00:00:00";s:10:"actualtime";s:19:"2010-08-01 22:59:47";s:1:"i";i:1;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('95','2010-08-01 22:59:47','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=109&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 00:11:00";s:10:"actualtime";s:19:"2010-08-01 22:59:47";s:1:"i";i:4;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('96','2010-08-01 22:59:47','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=109&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 00:11:00";s:10:"actualtime";s:19:"2010-08-01 22:59:47";s:1:"i";i:5;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('97','2010-08-01 23:02:23','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A30%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=109&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-19 00:00:00";s:10:"actualtime";s:19:"2010-08-01 23:02:23";s:1:"i";i:0;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('98','2010-08-01 23:02:23','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A30%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=109&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-31 00:00:00";s:10:"actualtime";s:19:"2010-08-01 23:02:23";s:1:"i";i:1;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('99','2010-08-01 23:04:35','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A30%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-19 00:00:00";s:10:"actualtime";s:19:"2010-08-01 23:04:35";s:1:"i";i:0;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('100','2010-08-01 23:04:35','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A30%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-31 00:00:00";s:10:"actualtime";s:19:"2010-08-01 23:04:35";s:1:"i";i:1;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('101','2010-08-01 23:04:35','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A30%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 00:05:00";s:10:"actualtime";s:19:"2010-08-01 23:04:35";s:1:"i";i:4;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('102','2010-08-01 23:04:35','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A30%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 00:05:00";s:10:"actualtime";s:19:"2010-08-01 23:04:35";s:1:"i";i:5;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('103','2010-08-01 23:05:36','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2012%3A00%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-19 00:00:00";s:10:"actualtime";s:19:"2010-08-01 23:05:36";s:1:"i";i:0;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('104','2010-08-01 23:05:36','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2012%3A00%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-31 00:00:00";s:10:"actualtime";s:19:"2010-08-01 23:05:36";s:1:"i";i:1;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('105','2010-08-01 23:05:36','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2012%3A00%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 00:08:00";s:10:"actualtime";s:19:"2010-08-01 23:05:36";s:1:"i";i:4;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('106','2010-08-01 23:05:36','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2012%3A00%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 00:08:00";s:10:"actualtime";s:19:"2010-08-01 23:05:36";s:1:"i";i:5;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('107','2010-08-01 23:06:02','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=109&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-19 00:00:00";s:10:"actualtime";s:19:"2010-08-01 23:06:02";s:1:"i";i:0;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('108','2010-08-01 23:06:02','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=109&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-31 00:00:00";s:10:"actualtime";s:19:"2010-08-01 23:06:02";s:1:"i";i:1;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('109','2010-08-01 23:06:25','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=109&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-19 00:00:00";s:10:"actualtime";s:19:"2010-08-01 23:06:25";s:1:"i";i:0;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('110','2010-08-01 23:06:25','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=109&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-31 00:00:00";s:10:"actualtime";s:19:"2010-08-01 23:06:25";s:1:"i";i:1;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('111','2010-08-02 00:42:09','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=109&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-19 00:00:00";s:10:"actualtime";s:19:"2010-08-02 00:42:09";s:1:"i";i:0;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('112','2010-08-02 00:42:09','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=109&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-31 00:00:00";s:10:"actualtime";s:19:"2010-08-02 00:42:09";s:1:"i";i:1;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('113','2010-08-02 00:42:09','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=109&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 00:20:00";s:10:"actualtime";s:19:"2010-08-02 00:42:09";s:1:"i";i:4;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('114','2010-08-02 00:42:09','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=109&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 00:20:00";s:10:"actualtime";s:19:"2010-08-02 00:42:09";s:1:"i";i:5;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('115','2010-08-02 00:42:37','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=109&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-19 00:00:00";s:10:"actualtime";s:19:"2010-08-02 00:42:37";s:1:"i";i:0;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('116','2010-08-02 00:42:37','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=109&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-31 00:00:00";s:10:"actualtime";s:19:"2010-08-02 00:42:37";s:1:"i";i:1;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('117','2010-08-02 00:42:38','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=109&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 00:17:00";s:10:"actualtime";s:19:"2010-08-02 00:42:38";s:1:"i";i:4;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('118','2010-08-02 00:42:38','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=109&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 00:17:00";s:10:"actualtime";s:19:"2010-08-02 00:42:38";s:1:"i";i:5;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('119','2010-08-02 00:43:18','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=109&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-19 00:00:00";s:10:"actualtime";s:19:"2010-08-02 00:43:18";s:1:"i";i:0;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('120','2010-08-02 00:43:18','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=109&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-31 00:00:00";s:10:"actualtime";s:19:"2010-08-02 00:43:18";s:1:"i";i:1;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('121','2010-08-02 00:43:19','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=109&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 00:04:00";s:10:"actualtime";s:19:"2010-08-02 00:43:19";s:1:"i";i:4;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('122','2010-08-02 00:43:19','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=109&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 00:04:00";s:10:"actualtime";s:19:"2010-08-02 00:43:19";s:1:"i";i:5;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('123','2010-08-02 00:44:58','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-19 00:00:00";s:10:"actualtime";s:19:"2010-08-02 00:44:58";s:1:"i";i:0;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('124','2010-08-02 00:44:58','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-31 00:00:00";s:10:"actualtime";s:19:"2010-08-02 00:44:58";s:1:"i";i:1;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('125','2010-08-02 00:44:58','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 00:15:00";s:10:"actualtime";s:19:"2010-08-02 00:44:58";s:1:"i";i:4;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('126','2010-08-02 00:44:58','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 00:15:00";s:10:"actualtime";s:19:"2010-08-02 00:44:58";s:1:"i";i:5;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('127','2010-08-02 00:45:26','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A30%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=109&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-19 00:00:00";s:10:"actualtime";s:19:"2010-08-02 00:45:26";s:1:"i";i:0;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('128','2010-08-02 00:45:26','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A30%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=109&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-31 00:00:00";s:10:"actualtime";s:19:"2010-08-02 00:45:26";s:1:"i";i:1;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('129','2010-08-02 00:45:26','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A30%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=109&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 00:06:00";s:10:"actualtime";s:19:"2010-08-02 00:45:26";s:1:"i";i:4;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('130','2010-08-02 00:45:26','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A30%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=109&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 00:06:00";s:10:"actualtime";s:19:"2010-08-02 00:45:26";s:1:"i";i:5;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('131','2010-08-02 00:48:09','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2012%3A00%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=109&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-19 00:00:00";s:10:"actualtime";s:19:"2010-08-02 00:48:09";s:1:"i";i:0;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('132','2010-08-02 00:48:09','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2012%3A00%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=109&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-31 00:00:00";s:10:"actualtime";s:19:"2010-08-02 00:48:09";s:1:"i";i:1;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('133','2010-08-02 00:48:09','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2012%3A00%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=109&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 00:19:00";s:10:"actualtime";s:19:"2010-08-02 00:48:09";s:1:"i";i:4;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('134','2010-08-02 00:48:09','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2012%3A00%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=109&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 00:19:00";s:10:"actualtime";s:19:"2010-08-02 00:48:09";s:1:"i";i:5;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('135','2010-08-02 00:48:12','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A30%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=109&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-19 00:00:00";s:10:"actualtime";s:19:"2010-08-02 00:48:12";s:1:"i";i:0;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('136','2010-08-02 00:48:12','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A30%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=109&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-31 00:00:00";s:10:"actualtime";s:19:"2010-08-02 00:48:12";s:1:"i";i:1;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('137','2010-08-02 00:48:12','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A30%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=109&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 00:13:00";s:10:"actualtime";s:19:"2010-08-02 00:48:12";s:1:"i";i:4;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('138','2010-08-02 00:48:12','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A30%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=109&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 00:13:00";s:10:"actualtime";s:19:"2010-08-02 00:48:12";s:1:"i";i:5;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('139','2010-08-02 00:49:33','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=109&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-19 00:00:00";s:10:"actualtime";s:19:"2010-08-02 00:49:33";s:1:"i";i:0;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('140','2010-08-02 00:49:33','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=109&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-31 00:00:00";s:10:"actualtime";s:19:"2010-08-02 00:49:33";s:1:"i";i:1;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('141','2010-08-02 00:49:33','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=109&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 00:14:00";s:10:"actualtime";s:19:"2010-08-02 00:49:33";s:1:"i";i:4;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('142','2010-08-02 00:49:33','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=109&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 00:14:00";s:10:"actualtime";s:19:"2010-08-02 00:49:33";s:1:"i";i:5;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('143','2010-08-02 00:51:54','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-19 00:00:00";s:10:"actualtime";s:19:"2010-08-02 00:51:54";s:1:"i";i:0;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('144','2010-08-02 00:51:54','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-31 00:00:00";s:10:"actualtime";s:19:"2010-08-02 00:51:54";s:1:"i";i:1;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('145','2010-08-02 00:51:54','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 00:10:00";s:10:"actualtime";s:19:"2010-08-02 00:51:54";s:1:"i";i:4;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('146','2010-08-02 00:51:54','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 00:10:00";s:10:"actualtime";s:19:"2010-08-02 00:51:54";s:1:"i";i:5;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('147','2010-08-02 00:54:48','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-19 00:00:00";s:10:"actualtime";s:19:"2010-08-02 00:54:48";s:1:"i";i:0;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('148','2010-08-02 00:54:48','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-31 00:00:00";s:10:"actualtime";s:19:"2010-08-02 00:54:48";s:1:"i";i:1;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('149','2010-08-02 00:54:48','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 00:12:00";s:10:"actualtime";s:19:"2010-08-02 00:54:48";s:1:"i";i:4;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('150','2010-08-02 00:54:48','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 00:12:00";s:10:"actualtime";s:19:"2010-08-02 00:54:48";s:1:"i";i:5;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('151','2010-08-02 00:56:00','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-19 00:00:00";s:10:"actualtime";s:19:"2010-08-02 00:56:00";s:1:"i";i:0;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('152','2010-08-02 00:56:00','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-31 00:00:00";s:10:"actualtime";s:19:"2010-08-02 00:56:00";s:1:"i";i:1;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('153','2010-08-02 00:56:00','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 00:00:00";s:10:"actualtime";s:19:"2010-08-02 00:56:00";s:1:"i";i:4;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('154','2010-08-02 00:56:00','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 00:00:00";s:10:"actualtime";s:19:"2010-08-02 00:56:00";s:1:"i";i:5;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('155','2010-08-02 00:56:44','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-19 00:00:00";s:10:"actualtime";s:19:"2010-08-02 00:56:44";s:1:"i";i:0;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('156','2010-08-02 00:56:44','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-31 00:00:00";s:10:"actualtime";s:19:"2010-08-02 00:56:44";s:1:"i";i:1;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('157','2010-08-02 00:56:44','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 00:17:00";s:10:"actualtime";s:19:"2010-08-02 00:56:44";s:1:"i";i:4;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('158','2010-08-02 00:56:44','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 00:17:00";s:10:"actualtime";s:19:"2010-08-02 00:56:44";s:1:"i";i:5;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('159','2010-08-02 00:56:55','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-19 00:00:00";s:10:"actualtime";s:19:"2010-08-02 00:56:55";s:1:"i";i:0;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('160','2010-08-02 00:56:55','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-31 00:00:00";s:10:"actualtime";s:19:"2010-08-02 00:56:55";s:1:"i";i:1;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('161','2010-08-02 00:56:55','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 00:18:00";s:10:"actualtime";s:19:"2010-08-02 00:56:55";s:1:"i";i:4;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('162','2010-08-02 00:56:55','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 00:18:00";s:10:"actualtime";s:19:"2010-08-02 00:56:55";s:1:"i";i:5;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('163','2010-08-02 00:57:30','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-19 00:00:00";s:10:"actualtime";s:19:"2010-08-02 00:57:30";s:1:"i";i:0;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('164','2010-08-02 00:57:30','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-31 00:00:00";s:10:"actualtime";s:19:"2010-08-02 00:57:30";s:1:"i";i:1;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('165','2010-08-02 00:57:30','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 00:20:00";s:10:"actualtime";s:19:"2010-08-02 00:57:30";s:1:"i";i:4;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('166','2010-08-02 00:57:30','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 00:20:00";s:10:"actualtime";s:19:"2010-08-02 00:57:30";s:1:"i";i:5;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('167','2010-08-02 00:57:58','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-19 00:00:00";s:10:"actualtime";s:19:"2010-08-02 00:57:58";s:1:"i";i:0;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('168','2010-08-02 00:57:58','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-31 00:00:00";s:10:"actualtime";s:19:"2010-08-02 00:57:58";s:1:"i";i:1;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('169','2010-08-02 00:57:58','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 00:07:00";s:10:"actualtime";s:19:"2010-08-02 00:57:58";s:1:"i";i:4;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('170','2010-08-02 00:57:58','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 00:07:00";s:10:"actualtime";s:19:"2010-08-02 00:57:58";s:1:"i";i:5;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('171','2010-08-02 00:58:57','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-19 00:00:00";s:10:"actualtime";s:19:"2010-08-02 00:58:57";s:1:"i";i:0;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('172','2010-08-02 00:58:57','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-31 00:00:00";s:10:"actualtime";s:19:"2010-08-02 00:58:57";s:1:"i";i:1;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('173','2010-08-02 00:58:57','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 00:03:00";s:10:"actualtime";s:19:"2010-08-02 00:58:57";s:1:"i";i:4;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('174','2010-08-02 00:58:57','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:"eventid";s:3:"206";s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 00:03:00";s:10:"actualtime";s:19:"2010-08-02 00:58:57";s:1:"i";i:5;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('175','2010-08-02 01:11:09','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A30%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:\"eventid\";s:3:\"206\";s:7:\"isemail\";b:1;s:9:\"calltime:\";s:19:\"2010-07-19 00:00:00\";s:10:\"actualtime\";s:19:\"2010-08-02 01:11:09\";s:1:\"i\";i:0;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('176','2010-08-02 01:11:10','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A30%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:\"eventid\";s:3:\"206\";s:7:\"isemail\";b:1;s:9:\"calltime:\";s:19:\"2010-07-31 00:00:00\";s:10:\"actualtime\";s:19:\"2010-08-02 01:11:10\";s:1:\"i\";i:1;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('177','2010-08-02 01:11:10','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A30%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:\"eventid\";s:3:\"206\";s:7:\"isemail\";b:0;s:9:\"calltime:\";s:19:\"2010-08-05 00:14:00\";s:10:\"actualtime\";s:19:\"2010-08-02 01:11:10\";s:1:\"i\";i:4;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('178','2010-08-02 01:11:10','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A30%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:\"eventid\";s:3:\"206\";s:7:\"isemail\";b:0;s:9:\"calltime:\";s:19:\"2010-08-05 00:14:00\";s:10:\"actualtime\";s:19:\"2010-08-02 01:11:10\";s:1:\"i\";i:5;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('179','2010-08-02 01:11:36','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:\"eventid\";s:3:\"206\";s:7:\"isemail\";b:1;s:9:\"calltime:\";s:19:\"2010-07-19 00:00:00\";s:10:\"actualtime\";s:19:\"2010-08-02 01:11:36\";s:1:\"i\";i:0;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('180','2010-08-02 01:11:36','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:\"eventid\";s:3:\"206\";s:7:\"isemail\";b:1;s:9:\"calltime:\";s:19:\"2010-07-31 00:00:00\";s:10:\"actualtime\";s:19:\"2010-08-02 01:11:36\";s:1:\"i\";i:1;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('181','2010-08-02 01:11:36','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:\"eventid\";s:3:\"206\";s:7:\"isemail\";b:0;s:9:\"calltime:\";s:19:\"2010-08-05 00:08:00\";s:10:\"actualtime\";s:19:\"2010-08-02 01:11:36\";s:1:\"i\";i:4;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('182','2010-08-02 01:11:36','70.110.101.221','http://vetboxx.com/caleditcell.php?time=Thu%20Aug%2005%202010%2011%3A45%3A00%20GMT-0400%20%28Eastern%20Daylight%20Time%29&practitioner_id=&calendar_event_id=206','','a:5:{s:7:\"eventid\";s:3:\"206\";s:7:\"isemail\";b:0;s:9:\"calltime:\";s:19:\"2010-08-05 00:08:00\";s:10:\"actualtime\";s:19:\"2010-08-02 01:11:36\";s:1:\"i\";i:5;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('183','2010-08-05 00:09:03','64.150.169.145','','','s:284:"json={"version":1,"data":[{"tag":"vetboxx.139","phone":"917604575","tts":"<voice name='William-8kHz'>This is a call from Harry's Dog Emporium reminding you of Georgez appointment for 11:30 am on Thursday August 5th. If you have any questions please call . Thank you.</voice>"}]}|[151]";','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('184','2010-08-05 01:13:03','64.150.169.145','','','s:284:"json={"version":1,"data":[{"tag":"vetboxx.139","phone":"917604575","tts":"<voice name='William-8kHz'>This is a call from Harry's Dog Emporium reminding you of Georgez appointment for 11:30 am on Thursday August 5th. If you have any questions please call . Thank you.</voice>"}]}|[154]";','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('185','2010-08-05 02:17:02','64.150.169.145','','','s:284:"json={"version":1,"data":[{"tag":"vetboxx.139","phone":"917604575","tts":"<voice name='William-8kHz'>This is a call from Harry's Dog Emporium reminding you of Georgez appointment for 11:30 am on Thursday August 5th. If you have any questions please call . Thank you.</voice>"}]}|[155]";','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('186','2010-08-08 20:32:56','141.152.126.231','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:207;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-23 21:00:00";s:10:"actualtime";s:19:"2010-08-08 20:32:56";s:1:"i";i:0;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('187','2010-08-08 20:32:56','141.152.126.231','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:207;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-08-01 21:00:00";s:10:"actualtime";s:19:"2010-08-08 20:32:56";s:1:"i";i:1;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('188','2010-08-08 20:32:56','141.152.126.231','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:207;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-08-01 21:00:00";s:10:"actualtime";s:19:"2010-08-08 20:32:56";s:1:"i";i:2;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('189','2010-08-08 20:32:56','141.152.126.231','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:207;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-09 21:05:00";s:10:"actualtime";s:19:"2010-08-08 20:32:56";s:1:"i";i:4;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('190','2010-08-08 20:32:56','141.152.126.231','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:207;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-09 21:05:00";s:10:"actualtime";s:19:"2010-08-08 20:32:56";s:1:"i";i:5;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('191','2010-08-09 21:05:05','64.150.169.145','','','s:274:"json={"version":1,"data":[{"tag":"vetboxx.140","phone":"","tts":"<voice name='William-8kHz'>This is a call from Flicker Tech reminding you of your appointment for 10:00 am on Tuesday August 10th. If you have any questions please call 3332221122. Thank you.</voice>"}]}|[158]";','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('192','2010-08-09 22:09:02','64.150.169.145','','','s:274:"json={"version":1,"data":[{"tag":"vetboxx.140","phone":"","tts":"<voice name='William-8kHz'>This is a call from Flicker Tech reminding you of your appointment for 10:00 am on Tuesday August 10th. If you have any questions please call 3332221122. Thank you.</voice>"}]}|[159]";','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('193','2010-08-09 23:13:02','64.150.169.145','','','s:274:"json={"version":1,"data":[{"tag":"vetboxx.140","phone":"","tts":"<voice name='William-8kHz'>This is a call from Flicker Tech reminding you of your appointment for 10:00 am on Tuesday August 10th. If you have any questions please call 3332221122. Thank you.</voice>"}]}|[160]";','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('194','2010-08-11 12:05:55','24.161.14.104','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:208;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-27 00:00:00";s:10:"actualtime";s:19:"2010-08-11 12:05:55";s:1:"i";i:0;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('195','2010-08-11 12:05:55','24.161.14.104','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:208;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-08-08 00:00:00";s:10:"actualtime";s:19:"2010-08-11 12:05:55";s:1:"i";i:1;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('196','2010-08-11 12:05:56','24.161.14.104','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:208;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-13 00:12:00";s:10:"actualtime";s:19:"2010-08-11 12:05:56";s:1:"i";i:4;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('197','2010-08-11 12:05:56','24.161.14.104','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:208;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-13 00:12:00";s:10:"actualtime";s:19:"2010-08-11 12:05:56";s:1:"i";i:5;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('198','2010-08-11 12:08:17','24.161.14.104','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:209;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-27 00:00:00";s:10:"actualtime";s:19:"2010-08-11 12:08:17";s:1:"i";i:0;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('199','2010-08-11 12:08:17','24.161.14.104','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:209;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-08-08 00:00:00";s:10:"actualtime";s:19:"2010-08-11 12:08:17";s:1:"i";i:1;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('200','2010-08-11 12:08:18','24.161.14.104','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:209;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-13 00:17:00";s:10:"actualtime";s:19:"2010-08-11 12:08:18";s:1:"i";i:4;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('201','2010-08-11 12:08:18','24.161.14.104','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:209;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-13 00:17:00";s:10:"actualtime";s:19:"2010-08-11 12:08:18";s:1:"i";i:5;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('202','2010-08-11 17:33:26','24.103.59.98','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:210;s:7:"isemail";b:1;s:9:"calltime:";s:19:"1969-12-15 00:00:00";s:10:"actualtime";s:19:"2010-08-11 17:33:26";s:1:"i";i:0;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('203','2010-08-11 17:33:26','24.103.59.98','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:210;s:7:"isemail";b:1;s:9:"calltime:";s:19:"1969-12-27 00:00:00";s:10:"actualtime";s:19:"2010-08-11 17:33:26";s:1:"i";i:1;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('204','2010-08-11 17:33:26','24.103.59.98','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:210;s:7:"isemail";b:1;s:9:"calltime:";s:19:"1969-12-31 00:00:00";s:10:"actualtime";s:19:"2010-08-11 17:33:26";s:1:"i";i:2;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('205','2010-08-11 17:33:26','24.103.59.98','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:210;s:7:"isemail";b:0;s:9:"calltime:";s:19:"1970-01-01 00:00:00";s:10:"actualtime";s:19:"2010-08-11 17:33:26";s:1:"i";i:3;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('206','2010-08-11 17:33:26','24.103.59.98','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:210;s:7:"isemail";b:0;s:9:"calltime:";s:19:"1970-01-01 00:00:00";s:10:"actualtime";s:19:"2010-08-11 17:33:26";s:1:"i";i:4;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('207','2010-08-11 17:33:26','24.103.59.98','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:210;s:7:"isemail";b:0;s:9:"calltime:";s:19:"1970-01-01 00:00:00";s:10:"actualtime";s:19:"2010-08-11 17:33:26";s:1:"i";i:5;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('208','2010-08-12 23:54:10','24.161.14.104','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:211;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-30 00:00:00";s:10:"actualtime";s:19:"2010-08-12 23:54:10";s:1:"i";i:0;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('209','2010-08-12 23:54:10','24.161.14.104','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:211;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-08-11 00:00:00";s:10:"actualtime";s:19:"2010-08-12 23:54:10";s:1:"i";i:1;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('210','2010-08-12 23:54:10','24.161.14.104','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:211;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-16 00:19:00";s:10:"actualtime";s:19:"2010-08-12 23:54:10";s:1:"i";i:4;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('211','2010-08-12 23:54:10','24.161.14.104','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:211;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-16 00:19:00";s:10:"actualtime";s:19:"2010-08-12 23:54:10";s:1:"i";i:5;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('212','2010-08-12 23:54:54','24.161.14.104','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:212;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-30 00:00:00";s:10:"actualtime";s:19:"2010-08-12 23:54:54";s:1:"i";i:0;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('213','2010-08-12 23:54:54','24.161.14.104','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:212;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-08-11 00:00:00";s:10:"actualtime";s:19:"2010-08-12 23:54:54";s:1:"i";i:1;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('214','2010-08-12 23:54:54','24.161.14.104','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:212;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-16 00:13:00";s:10:"actualtime";s:19:"2010-08-12 23:54:54";s:1:"i";i:4;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('215','2010-08-12 23:54:54','24.161.14.104','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:212;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-16 00:13:00";s:10:"actualtime";s:19:"2010-08-12 23:54:54";s:1:"i";i:5;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('216','2010-08-12 23:55:06','24.161.14.104','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:213;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-31 00:00:00";s:10:"actualtime";s:19:"2010-08-12 23:55:06";s:1:"i";i:0;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('217','2010-08-12 23:55:06','24.161.14.104','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:213;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-08-12 00:00:00";s:10:"actualtime";s:19:"2010-08-12 23:55:06";s:1:"i";i:1;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('218','2010-08-12 23:55:06','24.161.14.104','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:213;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-17 00:07:00";s:10:"actualtime";s:19:"2010-08-12 23:55:06";s:1:"i";i:4;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('219','2010-08-12 23:55:06','24.161.14.104','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:213;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-17 00:07:00";s:10:"actualtime";s:19:"2010-08-12 23:55:06";s:1:"i";i:5;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('220','2010-08-13 00:13:03','64.150.169.145','','','s:282:"json={"version":1,"data":[{"tag":"vetboxx.142","phone":"19176504575","tts":"<voice name='William-8kHz'>This is a call from Harry's Dog Emporium reminding you of your appointment for 10:45 am on Friday August 13th. If you have any questions please call . Thank you.</voice>"}]}|[170]";','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('221','2010-08-13 00:17:02','64.150.169.145','','','s:280:"json={"version":1,"data":[{"tag":"vetboxx.144","phone":"19176504575","tts":"<voice name='William-8kHz'>This is a call from Harry's Dog Emporium reminding you of RBz appointment for 3:00 pm on Friday August 13th. If you have any questions please call . Thank you.</voice>"}]}|[171]";','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('222','2010-08-16 00:13:03','64.150.169.145','','','s:280:"json={"version":1,"data":[{"tag":"vetboxx.148","phone":"19176504575","tts":"<voice name='William-8kHz'>This is a call from Harry's Dog Emporium reminding you of RBz appointment for 1:45 pm on Monday August 16th. If you have any questions please call . Thank you.</voice>"}]}|[172]";','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('223','2010-08-16 00:19:02','64.150.169.145','','','s:282:"json={"version":1,"data":[{"tag":"vetboxx.146","phone":"19176504575","tts":"<voice name='William-8kHz'>This is a call from Harry's Dog Emporium reminding you of your appointment for 10:30 am on Monday August 16th. If you have any questions please call . Thank you.</voice>"}]}|[173]";','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('224','2010-08-17 00:07:02','64.150.169.145','','','s:282:"json={"version":1,"data":[{"tag":"vetboxx.150","phone":"19176504575","tts":"<voice name='William-8kHz'>This is a call from Harry's Dog Emporium reminding you of your appointment for 9:45 am on Tuesday August 17th. If you have any questions please call . Thank you.</voice>"}]}|[174]";','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('225','2010-08-20 17:59:33','69.99.25.94','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:214;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-08-04 00:00:00";s:10:"actualtime";s:19:"2010-08-20 17:59:33";s:1:"i";i:0;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('226','2010-08-20 17:59:33','69.99.25.94','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:214;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-08-16 00:00:00";s:10:"actualtime";s:19:"2010-08-20 17:59:33";s:1:"i";i:1;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('227','2010-08-20 17:59:33','69.99.25.94','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:214;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-08-20 00:00:00";s:10:"actualtime";s:19:"2010-08-20 17:59:33";s:1:"i";i:2;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('228','2010-08-20 17:59:33','69.99.25.94','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:214;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-21 00:10:00";s:10:"actualtime";s:19:"2010-08-20 17:59:33";s:1:"i";i:4;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('229','2010-08-20 17:59:33','69.99.25.94','http://vetboxx.com/caleditcell.php','','a:5:{s:7:"eventid";i:214;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-21 00:10:00";s:10:"actualtime";s:19:"2010-08-20 17:59:33";s:1:"i";i:5;}','');
INSERT INTO vetboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`label`,`form_content`,`comments`) VALUES('230','2010-08-21 00:11:03','64.150.169.145','','','s:283:"json={"version":1,"data":[{"tag":"vetboxx.151","phone":"19176504575","tts":"<voice name='William-8kHz'>This is a call from Harry's Dog Emporium reminding you of RBz appointment for 11:45 am on Saturday August 21st. If you have any questions please call . Thank you.</voice>"}]}|[175]";','');


CREATE TABLE `insurance_type` (
  `insurance_type_id` int(11) NOT NULL auto_increment,
  `itype_name` varchar(50) default NULL,
  PRIMARY KEY  (`insurance_type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;



INSERT INTO vetboxx.insurance_type(`insurance_type_id`,`itype_name`) VALUES('1','medical');
INSERT INTO vetboxx.insurance_type(`insurance_type_id`,`itype_name`) VALUES('2','dental');
INSERT INTO vetboxx.insurance_type(`insurance_type_id`,`itype_name`) VALUES('3','eyeglasses');


CREATE TABLE `login` (
  `login_id` int(11) NOT NULL auto_increment,
  `password` varchar(50) default NULL,
  `username` varchar(150) default NULL,
  `email` varchar(144) default NULL,
  `is_active` tinyint(1) default NULL,
  `type` varchar(12) default NULL,
  PRIMARY KEY  (`login_id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;



INSERT INTO vetboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('1','pool','worthington','bigfun@verizon.net','1','office');
INSERT INTO vetboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('3','pool','','manner@asecular.com','1','client');
INSERT INTO vetboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('4','pool','','manner@asecular.com','1','client');
INSERT INTO vetboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('5','pool','','manner3@asecular.com','1','client');
INSERT INTO vetboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('6','pool','','manner4@asecular.com','1','client');
INSERT INTO vetboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('7','pool','','goop@asecular.com','1','client');
INSERT INTO vetboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('8','pool','','goop@asecular.com','1','client');
INSERT INTO vetboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('9','pool','','goop@asecular.com','1','client');
INSERT INTO vetboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('10','pool','','goop@asecular.com','1','client');
INSERT INTO vetboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('11','pool','','goop@asecular.com','1','client');
INSERT INTO vetboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('15','pool','wockerman','goop@asecular.com','1','client');
INSERT INTO vetboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('16','pool','yorpwok','foop@pool.com','1','client');
INSERT INTO vetboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('17','pool','','foop@pool.com','1','client');
INSERT INTO vetboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('18','pool','','foop@pool.com','1','client');
INSERT INTO vetboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('19','pool','','foop@pool.com','1','client');
INSERT INTO vetboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('20','pool','','foop@pool.com','1','client');
INSERT INTO vetboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('21','!test','','jstohlmann@comcast.net','1','');
INSERT INTO vetboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('22','burdett','','','0','office');
INSERT INTO vetboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('23','handson','ciunas','info@ciunascentre.com','1','office');
INSERT INTO vetboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('24','','','','1','client');
INSERT INTO vetboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('25','','','','1','');
INSERT INTO vetboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('26','pool','','bigfun2@verizon.net','1','office');
INSERT INTO vetboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('27','pool','Bertyle','bigfun33@verizon.net','1','office');
INSERT INTO vetboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('28','453453','harrys','citizenx2@zoho.com','1','office');
INSERT INTO vetboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('29','pool','cutenesscentre','bigfun99@verizon.net','1','office');
INSERT INTO vetboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('30','pool','flicker','flicker@pool.com','1','office');


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



INSERT INTO vetboxx.marital_status(`marital_status_id`,`mstatus_name`) VALUES('1','single');
INSERT INTO vetboxx.marital_status(`marital_status_id`,`mstatus_name`) VALUES('2','married');
INSERT INTO vetboxx.marital_status(`marital_status_id`,`mstatus_name`) VALUES('3','divorced');
INSERT INTO vetboxx.marital_status(`marital_status_id`,`mstatus_name`) VALUES('4','widow/widower');


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
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;



INSERT INTO vetboxx.office(`office_id`,`login_id`,`office_name`,`subdomain`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('1','1','Worthington Medical Facility','worthington','322 Milva Parkway','Dougston','DE','28121','bigfun@verizon.net','2221212212','7','Call for Phillip Morris','22','121','233','15','9*17','1*5','12*13','12/25 01/01 thanksgiving','0','1','1','2010-04-27 17:09:00','2010-04-27 17:09:00','1','Not only do we have CATscanners and FMRI, we also have stethoscopes.','18','9','0','1','0','0','10');
INSERT INTO vetboxx.office(`office_id`,`login_id`,`office_name`,`subdomain`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('3','4','','','422 Silver Parkway','Dallas','MD','22211','manner@asecular.com','','7','','','','','0','','','','','0','0','1','2010-05-02 10:11:15','2010-05-02 10:11:15','1','','0','0','0','0','0','0','0');
INSERT INTO vetboxx.office(`office_id`,`login_id`,`office_name`,`subdomain`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('4','22','Burdett Orthopedics','Burdett','2200 Burdett Ave.','Troy','NY','12180','','(518)272-0332','7','','3','10','20','20','9*17','1*5','12*13','12/25 01/01 thanksgiving','0','1','0','2010-05-06 17:38:07','2010-05-06 17:38:07','1','','14','7','1','1','0','0','18');
INSERT INTO vetboxx.office(`office_id`,`login_id`,`office_name`,`subdomain`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('5','23','ciunas','ciunas','The Old Creamery','Feakle  Co. Clare, Ireland','','0000','info@ciunascentre.com','353876236292','1','','','','','30','9*17','1*5','12*13','12/25 01/01 thanksgiving','0','1','1','2010-05-09 20:51:53','2010-05-09 20:51:53','1','We are located in a fully accessible warm and welcoming centre in Feakle, Co. Clare.  We have a fexible schedule and are there to support you for the long or short term.  ','0','0','0','0','0','0','0');
INSERT INTO vetboxx.office(`office_id`,`login_id`,`office_name`,`subdomain`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('6','26','Florence Medical Center','florence','121 Florence Drive','Florence','FL','31121','bigfun2@verizon.net','4443334433','7','121 Florence Drive Florence FL','12','33','444','15','9*17','1*5','12*13','12/25 01/01 thanksgiving','0','1','0','2010-05-17 15:54:01','2010-05-17 15:54:01','1','Florence is a full-on medical center.','18','9','0','0','0','0','10');
INSERT INTO vetboxx.office(`office_id`,`login_id`,`office_name`,`subdomain`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('7','27','Bertyle Associates','Bertyle','112 Gilver Street','Hollywood','AB','12211','bigfun33@verizon.net','4443334433','4','','','','','15','9*17','1*5','12*13','12/25 01/01 thanksgiving','0','1','0','2010-05-21 17:51:52','2010-05-21 17:51:52','1','','18','9','0','1','0','0','10');
INSERT INTO vetboxx.office(`office_id`,`login_id`,`office_name`,`subdomain`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('8','28','Harry's Dog Emporium','harrys','44 Million Ave','Bucyrus','OH','61411','citizenx2@zoho.com','','7','','','','','15','9*17','1*5','12*13','12/25 01/01 thanksgiving','0','1','1','2010-07-28 20:34:15','2010-07-28 20:34:15','1','Located in the beautiful Hudson Valley','18','6','2','1','0','0','19');
INSERT INTO vetboxx.office(`office_id`,`login_id`,`office_name`,`subdomain`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('9','29','Dug Hill Road Cuteness Centre','cutenesscentre','245 Dug Hill Road','Hurley','NY','12443','bigfun99@verizon.net','8453401090','7','Just come on up and see us some time!','12','16','55','15','9*17','1*5','12*13','12/25 01/01 thanksgiving','0','1','1','2010-07-30 13:29:47','2010-07-30 13:29:47','1','Gretchen trimmed Nigel's claws?  NOOOOOOoooooo!!!!!  Why do you mutilate your companion animal?If you\'re trying to make your cats Viggins you\'re just borrowing trouble.  A diet of dry food is notorious for causing urinary problems in male cats.  You NEED to feed that cat dead fish.  Fish that have been killitated by humans.On the other hand, there is a well known vegetarian diet for dogs, often used for service dogs.  Dogs on that diet eat better than I do.http://www.greaseman.org/sounds/jasonz/815-TunaFishSong.mp3 ','18','9','0','1','0','0','19');
INSERT INTO vetboxx.office(`office_id`,`login_id`,`office_name`,`subdomain`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('10','30','Flicker Tech','flicker','33 Flicker BLVD north ','Flicker','IN','44332','flicker@pool.com','3332221122','3','','','','','15','9*17','1*5','12*13','12/25 01/01 thanksgiving','','1','','2010-08-08 20:30:51','2010-08-08 20:30:51','1','','18','9','0','1','0','0','19');


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
) ENGINE=MyISAM AUTO_INCREMENT=215 DEFAULT CHARSET=latin1;



INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('60','100216','0','12:0','240','103','man manner','watch out for this guy he is crazy. i wouldn&#39;t trust him. he steals unattended drugs!','1','9','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('62','100217','0','9:45','60','1','','yeah and stuff','1','28','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('70','100219','0','10:45','60','3','','','1','28','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('65','100219','0','12:15','120','3','','','1','9','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('71','100218','0','16:30','240','103','','mona wong','1','8','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('72','100218','0','10:15','15','103','','','1','27','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('73','100217','0','10:0','30','2','','','1','9','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('74','100218','0','10:15','300','4','','save my baby!','1','10','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('75','100218','0','14:0','45','103','','','1','28','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('76','100220','0','10:45','240','103','','it&#39;s gonna take awhile, dude is in bad shape!','1','8','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('77','100225','0','10:45','240','103','','scary disease!','1','28','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('78','100219','0','10:0','60','103','','','1','28','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('79','100217','0','10:15','60','3','','sort of mischievious','1','30','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('80','100215','0','10:15','240','3','','fun kid!','1','30','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('81','100217','0','9:0','240','103','','fun okay kind of kid','1','30','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('82','100215','0','10:30','90','1','','','1','30','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('83','100225','0','13:45','30','1','','','1','30','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('84','100218','0','10:45','60','103','','vasectomy','1','28','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('85','100223','0','10:15','60','103','','triple vasectomy!','1','28','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('86','100219','0','10:30','60','103','','','1','28','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('87','100215','0','10:0','120','103','','','1','28','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('88','100226','0','10:0','240','103','','','1','31','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('89','100227','0','12:0','15','103','','','1','40','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('90','100224','0','10:30','240','3','','','1','40','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('91','100226','0','9:45','120','3','','','1','40','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('92','100225','0','9:45','60','3','','','1','7','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('93','100222','0','12:30','60','103','','','1','8','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('94','100305','0','10:0','60','3','','nasal','1','7','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('100','100224','0','13:15','60','103','','ww','1','28','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('101','100224','0','13:15','60','103','','dude!!!','1','44','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('102','100224','0','9:45','60','103','','wow!','1','44','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('103','100223','0','13:45','60','103','','','1','44','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('104','100226','0','15:0','60','103','','!!','1','44','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('189','100526','0','10:45','60','103','','','1','19','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('188','100603','0','11:0','60','106','','','5','34','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('187','100601','0','11:0','60','106','','','5','34','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('111','100820','0','10:45','60','103','','','1','44','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('112','101011','0','9:0','60','3','','spaghetti nerves','1','44','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('113','100906','0','10:15','60','3','','octopus eyes','1','44','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('114','100802','0','10:0','60','3','','','1','44','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('115','100930','0','9:15','60','3','','','1','28','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('116','101001','0','9:15','60','2','','','1','28','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('117','100930','0','14:30','60','2','','','1','44','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('118','100928','0','11:15','60','2','','','1','44','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('119','100927','0','13:30','60','2','','','1','44','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('120','100301','0','10:45','60','1','','','1','28','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('121','100301','0','11:30','5','103','','','1','31','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('122','100301','0','10:45','10','103','','','1','7','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('123','100303','0','10:0','30','103','','shot','1','31','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('124','100303','0','10:15','5','103','','suture removal','1','28','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('125','100225','0','13:45','60','103','','','1','28','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('126','100225','0','10:0','45','3','','check up','1','28','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('127','100304','0','10:15','30','3','','this is an edit','1','28','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('128','100304','0','10:30','5','3','','recall','1','31','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('129','100222','0','10:45','60','3','','','1','44','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('130','100303','0','10:0','60','103','','yea!!','1','28','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('131','100304','0','11:15','60','103','','','1','28','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('132','100304','0','11:15','60','103','','','1','28','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('133','100312','0','11:0','60','103','','oucher!!!','1','28','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('134','100312','0','14:15','60','103','','','1','31','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('135','100312','0','15:45','60','103','','','1','44','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('136','100301','0','11:30','5','103','','','1','28','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('138','100329','0','10:15','10','103','','','1','28','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('139','100329','0','11:15','60','103','','','1','28','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('140','100402','0','10:30','5','103','','','1','28','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('141','100408','0','10:30','60','104','','','52','53','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('142','100409','0','10:30','60','104','','','52','53','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('143','100408','0','13:0','60','104','','','52','53','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('144','100409','0','13:45','60','104','','','52','54','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('145','100408','0','15:30','60','104','','','52','54','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('146','100406','0','9:30','60','104','','','52','53','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('147','100412','0','10:15','60','104','','','52','53','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('148','100412','0','12:15','60','104','','','52','54','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('149','100413','0','12:0','60','104','','','52','54','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('150','100413','0','10:0','60','104','','','52','54','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('151','100414','0','10:15','60','104','','','52','54','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('152','100416','0','10:45','360','104','','','52','54','0','3','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('153','100417','0','10:45','300','104','','','52','53','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('154','100411','0','10:15','60','104','','','52','54','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('155','100411','0','12:15','60','104','','','52','53','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('156','100417','0','9:45','15','104','','','52','53','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('157','100415','0','14:15','300','104','','','52','53','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('158','100415','0','10:15','60','104','','','52','54','0','2','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('159','100413','0','14:30','60','104','','','52','54','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('160','100414','0','15:0','60','104','','','52','53','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('161','100417','0','11:15','60','103','','','1','28','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('162','100417','0','13:15','60','103','','','1','28','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('163','100416','0','14:15','60','103','','','1','28','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('164','100417','0','14:45','60','103','','','1','28','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('165','100419','0','10:0','15','3','','check sutures','1','56','0','4','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('166','100419','0','10:15','15','3','','crown delivery','1','57','0','4','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('167','100419','0','10:0','60','3','','crown prep','1','58','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('168','100423','0','10:30','60','103','','','1','28','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('169','100423','0','10:30','60','103','','','1','44','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('170','100423','0','10:45','5','103','','','1','9','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('171','100428','0','11:0','15','3','','exam','1','28','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('172','100421','0','10:45','30','2','','exam','1','28','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('173','691231','0','10:0','60','103','','werwer','1','12','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('174','100609','0','10:45','60','103','','dasd asd sad ','1','12','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('175','100504','0','10:0','240','103','','','1','9','0','4','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('177','100505','0','11:0','60','103','','','1','16','0','2','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('178','100421','0','10:15','60','103','','','1','16','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('179','100512','0','10:30','60','103','','','1','12','0','2','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('180','100512','0','10:30','60','103','','','1','21','0','2','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('181','100512','0','10:30','60','103','','','1','9','0','2','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('182','100420','0','11:30','60','1','','','1','12','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('183','100514','0','11:45','360','3','','they need a lot of work done.','1','16','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('184','100514','0','11:45','60','3','','party','1','12','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('185','100528','0','9:30','60','106','','','5','32','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('186','100218','0','10:15','300','4','','save my baby!','1','0','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('190','100526','0','10:0','60','106','','','5','33','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('191','100527','0','10:15','60','3','','','1','17','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('192','100525','0','10:30','60','106','','','5','34','0','0','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('193','100629','','10:45','60','103','','','1','15','','','');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('194','100726','','11:0','60','109','','','8','35','','1','0');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('195','100726','','13:15','60','110','','','8','36','','1','0');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('196','100727','','11:15','60','109','','','8','36','','1','0');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('197','100727','','13:15','60','109','','','8','35','','1','0');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('198','100728','','10:0','60','109','','','8','35','','1','0');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('199','100728','','10:30','60','109','','','8','36','','1','0');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('200','100729','','10:0','60','109','','','8','35','','1','0');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('201','100729','','10:30','60','110','','','8','36','','1','0');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('202','100730','','11:15','15','110','','','8','35','','1','0');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('203','100730','','11:15','10','110','','','8','36','','1','0');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('204','100729','','11:15','60','111','','','9','37','','1','0');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('205','100728','','11:0','60','111','','','9','38','','1','0');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('206','100805','','11:30','60','109','','','8','41','','1','0');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('207','100810','','10:0','60','112','','','10','43','','1','0');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('208','100813','','10:45','60','110','','','8','42','','1','0');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('209','100813','','15:0','60','113','','','8','44','','1','0');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('210','700101','','0:0','30','113','','exam','8','44','','1','0');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('211','100816','','10:30','60','109','','','8','42','','1','0');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('212','100816','','13:45','60','109','','scheduled as rb each afternoon','8','44','','1','0');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('213','100817','','9:45','60','109','','','8','42','','1','0');
INSERT INTO vetboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('214','100821','','11:45','15','113','','toe nail','8','44','','1','0');


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
) ENGINE=MyISAM AUTO_INCREMENT=152 DEFAULT CHARSET=latin1;



INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('1','','','0013026910104','0','Hello, this is a call from Dr. Thoreaus office reminding you that you have an appointment scheduled for 3:30pm on Tuesday, December 29th. If you cannot make this appointment, please let us know by calling us at 2232212244. Thank you!','2010-03-23 12:19:00','4','37','','1','0','2010-03-23 12:20:11','0','0','348e027832b6c3da82313e82457c6309','1999-11-30 00:00:00','0','','0','0');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('2','','','19176504575','0','This is a call from Kingston Medical Center reminding you of your appointment for 2:15 pm on Friday March 12th. If you have any questions please call 845 340 1090. Thank you.','2010-03-22 12:19:00','4','39','','1','0','2010-03-28 19:54:07','0','0','975e9c007458a58ed600333c2bb9d2e4','1999-11-30 00:00:00','0','','0','0');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('3','','','18453401090','0','This is a call from Kingston Medical Center reminding you of your appointment for 2:15 pm on Friday March 12th. If you have any questions please call 845 340 1090. Thank you.','2010-03-22 12:49:00','4','40','','1','0','2010-03-23 19:34:09','0','0','5f0fe035b37079847867ef586bd1d11b','2019-11-30 00:00:00','0','','0','0');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('5','','','19176504575','-5','This is a call from Kingston Medical Center reminding you of your appointment for 11:15 am on Monday March 29th. If you have any questions please call 845 340 1090. Thank you.','2010-03-28 15:08:00','1','9','','1','0','2010-03-28 19:54:07','1','28','975e9c007458a58ed600333c2bb9d2e4','2010-03-29 11:15:00','139','Dear Dennis Dennis,
This is a message from Kingston Medical Center reminding you of your appointment for 11:15 am on Monday March 29th with Dawn Parklington. If you have any questions please call 845 340 1090.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=|FzQS9-OK9-PKW-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=|kTp4L-J-hM-JhVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=|-OO9uS94O9-KXp-TdCbNW
Thank you.
Kingston Medical Center','0','0');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('6','','','19176504575','-5','This is a call from Kingston Medical Center reminding you of your appointment for 10:30 am on Friday April 2nd. If you have any questions please call 845 340 1090. Thank you.','2010-04-01 15:00:00','1','0','','1','0','1970-01-01 00:00:00','1','28','','2010-04-02 10:30:00','140','Dear Dennis Dennis,
This is a message from Kingston Medical Center reminding you of your appointment for 10:30 am on Friday April 2nd with Dawn Parklington. If you have any questions please call 845 340 1090.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=|FzQS9-OK9-PKW-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=|kTp4L-J-hM-JhVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=|-OO9uS94O9-KXp-TdCbNW
Thank you.
Kingston Medical Center','0','0');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('35','','','18453401090','-5','This is a call from Elmira Hospital reminding you of your appointment for 1:45 pm on Friday April 9th. If you have any questions please call 7436778433. Thank you.','2010-04-07 15:00:00','1','0','','1','0','0000-00-00 00:00:00','52','54','','2010-04-09 13:45:00','144','Dear Gus Mueller,

This is a message from Elmira Hospital reminding you of your appointment for 1:45 pm on Friday April 9th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=|BzuS9-hL9-PKW-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=|-hMz4N9GM-JhVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=|kR9uK9-EO9-KXp-TdCbNW

Thank you.
Elmira Hospital','1','1');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('34','','','18453401090','-5','This is a call from Elmira Hospital reminding you of your appointment for 1:45 pm on Friday April 9th. If you have any questions please call 7436778433. Thank you.','2010-04-08 15:00:00','1','0','','1','0','0000-00-00 00:00:00','52','54','','2010-04-09 13:45:00','144','Dear Gus Mueller,

This is a message from Elmira Hospital reminding you of your appointment for 1:45 pm on Friday April 9th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=|BzuS9-hL9-PKW-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=|-hMz4N9GM-JhVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=|kR9uK9-EO9-KXp-TdCbNW

Thank you.
Elmira Hospital','1','0');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('33','','','19176504575','-5','This is a call from Elmira Hospital reminding you of your appointment for 10:30 am on Friday April 9th. If you have any questions please call 7436778433. Thank you.','2010-04-06 15:00:00','1','0','','1','0','0000-00-00 00:00:00','52','53','','2010-04-09 10:30:00','142','Dear Dennis Opp,

This is a message from Elmira Hospital reminding you of your appointment for 10:30 am on Friday April 9th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=|AzuO9-hL9-PKW-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=|-XMzQN9GM-JhVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=|aR9GK9-EO9-KXp-TdCbNW

Thank you.
Elmira Hospital','1','2');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('32','','','19176504575','-5','This is a call from Elmira Hospital reminding you of your appointment for 10:30 am on Friday April 9th. If you have any questions please call 7436778433. Thank you.','2010-04-07 15:00:00','1','0','','1','0','0000-00-00 00:00:00','52','53','','2010-04-09 10:30:00','142','Dear Dennis Opp,

This is a message from Elmira Hospital reminding you of your appointment for 10:30 am on Friday April 9th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=|AzuO9-hL9-PKW-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=|-XMzQN9GM-JhVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=|aR9GK9-EO9-KXp-TdCbNW

Thank you.
Elmira Hospital','1','1');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('31','','','19176504575','-5','This is a call from Elmira Hospital reminding you of your appointment for 10:30 am on Friday April 9th. If you have any questions please call 7436778433. Thank you.','2010-04-08 15:00:00','1','0','','1','0','0000-00-00 00:00:00','52','53','','2010-04-09 10:30:00','142','Dear Dennis Opp,

This is a message from Elmira Hospital reminding you of your appointment for 10:30 am on Friday April 9th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=|AzuO9-hL9-PKW-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=|-XMzQN9GM-JhVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=|aR9GK9-EO9-KXp-TdCbNW

Thank you.
Elmira Hospital','1','0');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('30','','','19176504575','-5','This is a call from Elmira Hospital reminding you of your appointment for 10:30 am on Thursday April 8th. If you have any questions please call 7436778433. Thank you.','2010-04-06 15:00:00','1','0','','1','0','0000-00-00 00:00:00','52','53','','2010-04-08 10:30:00','141','Dear Dennis Opp,

This is a message from Elmira Hospital reminding you of your appointment for 10:30 am on Thursday April 8th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=|AzuO9-hL9-PKW-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=|-XMzQN9GM-JhVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=|aR9GK9-EO9-KXp-TdCbNW

Thank you.
Elmira Hospital','1','1');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('29','','','19176504575','-5','This is a call from Elmira Hospital reminding you of your appointment for 10:30 am on Thursday April 8th. If you have any questions please call 7436778433. Thank you.','2010-04-07 15:00:00','1','0','','1','0','0000-00-00 00:00:00','52','53','','2010-04-08 10:30:00','141','Dear Dennis Opp,

This is a message from Elmira Hospital reminding you of your appointment for 10:30 am on Thursday April 8th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=|AzuO9-hL9-PKW-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=|-XMzQN9GM-JhVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=|aR9GK9-EO9-KXp-TdCbNW

Thank you.
Elmira Hospital','1','0');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('36','','','18453401090','-5','This is a call from Elmira Hospital reminding you of your appointment for 3:30 pm on Thursday April 8th. If you have any questions please call 7436778433. Thank you.','2010-04-07 15:00:00','1','0','','1','0','0000-00-00 00:00:00','52','54','','2010-04-08 15:30:00','145','Dear Gus Mueller,

This is a message from Elmira Hospital reminding you of your appointment for 3:30 pm on Thursday April 8th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=|BzuS9-hL9-PKW-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=|-hMz4N9GM-JhVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=|kR9uK9-EO9-KXp-TdCbNW

Thank you.
Elmira Hospital','1','0');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('37','','','19176504575','-5','This is a call from Elmira Hospital reminding you of your appointment for 10:15 am on Monday April 12th. If you have any questions please call 7436778433. Thank you.','2010-04-11 15:00:00','1','0','','1','0','0000-00-00 00:00:00','52','53','','2010-04-12 10:15:00','147','Dear Dennis Opp,

This is a message from Elmira Hospital reminding you of your appointment for 10:15 am on Monday April 12th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=|AzuO9-hL9-PKW-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=|-XMzQN9GM-JhVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=|aR9GK9-EO9-KXp-TdCbNW

Thank you.
Elmira Hospital','1','0');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('38','','','18453401090','-5','This is a call from Elmira Hospital reminding you of your appointment for 12:15 pm on Monday April 12th. If you have any questions please call 7436778433. Thank you.','2010-04-11 15:00:00','1','0','','1','0','0000-00-00 00:00:00','52','54','','2010-04-12 12:15:00','148','Dear Gus Mueller,

This is a message from Elmira Hospital reminding you of your appointment for 12:15 pm on Monday April 12th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=|BzuS9-hL9-PKW-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=|-hMz4N9GM-JhVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=|kR9uK9-EO9-KXp-TdCbNW

Thank you.
Elmira Hospital','1','0');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('39','','','18453401090','-5','This is a call from Elmira Hospital reminding you of your appointment for 12:00 pm on Tuesday April 13th. If you have any questions please call 7436778433. Thank you.','2010-04-12 15:00:00','1','0','','1','0','0000-00-00 00:00:00','52','54','','2010-04-13 12:00:00','149','Dear Gus Mueller,

This is a message from Elmira Hospital reminding you of your appointment for 12:00 pm on Tuesday April 13th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=|BzuS9-hL9-PKW-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=|-hMz4N9GM-JhVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=|kR9uK9-EO9-KXp-TdCbNW

Thank you.
Elmira Hospital','1','0');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('40','','','18453401090','-5','This is a call from Elmira Hospital reminding you of your appointment for 12:00 pm on Tuesday April 13th. If you have any questions please call 7436778433. Thank you.','2010-04-11 15:00:00','1','0','','1','0','0000-00-00 00:00:00','52','54','','2010-04-13 12:00:00','149','Dear Gus Mueller,

This is a message from Elmira Hospital reminding you of your appointment for 12:00 pm on Tuesday April 13th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=|BzuS9-hL9-PKW-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=|-hMz4N9GM-JhVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=|kR9uK9-EO9-KXp-TdCbNW

Thank you.
Elmira Hospital','1','1');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('41','','','18453401090','-5','This is a call from Elmira Hospital reminding you of your appointment for 10:00 am on Tuesday April 13th. If you have any questions please call 7436778433. Thank you.','2010-04-12 15:00:00','1','0','','1','0','0000-00-00 00:00:00','52','54','','2010-04-13 10:00:00','150','Dear Gus Mueller,

This is a message from Elmira Hospital reminding you of your appointment for 10:00 am on Tuesday April 13th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=|BzuS9-hL9-PKW-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=|-hMz4N9GM-JhVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=|kR9uK9-EO9-KXp-TdCbNW

Thank you.
Elmira Hospital','1','0');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('42','','','18453401090','-5','This is a call from Elmira Hospital reminding you of your appointment for 10:00 am on Tuesday April 13th. If you have any questions please call 7436778433. Thank you.','2010-04-11 15:00:00','1','0','','1','0','0000-00-00 00:00:00','52','54','','2010-04-13 10:00:00','150','Dear Gus Mueller,

This is a message from Elmira Hospital reminding you of your appointment for 10:00 am on Tuesday April 13th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=|BzuS9-hL9-PKW-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=|-hMz4N9GM-JhVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=|kR9uK9-EO9-KXp-TdCbNW

Thank you.
Elmira Hospital','1','1');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('43','','','18453401090','-5','This is a call from Elmira Hospital reminding you of your appointment for 10:15 am on Wednesday April 14th. If you have any questions please call 7436778433. Thank you.','2010-04-13 15:00:00','1','0','','1','0','0000-00-00 00:00:00','52','54','','2010-04-14 10:15:00','151','Dear Gus Mueller,

This is a message from Elmira Hospital reminding you of your appointment for 10:15 am on Wednesday April 14th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=|BzuS9-hL9-PKW-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=|-hMz4N9GM-JhVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=|kR9uK9-EO9-KXp-TdCbNW

Thank you.
Elmira Hospital','1','0');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('44','','','18453401090','-5','This is a call from Elmira Hospital reminding you of your appointment for 10:15 am on Wednesday April 14th. If you have any questions please call 7436778433. Thank you.','2010-04-12 15:00:00','1','0','','1','0','0000-00-00 00:00:00','52','54','','2010-04-14 10:15:00','151','Dear Gus Mueller,

This is a message from Elmira Hospital reminding you of your appointment for 10:15 am on Wednesday April 14th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=|BzuS9-hL9-PKW-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=|-hMz4N9GM-JhVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=|kR9uK9-EO9-KXp-TdCbNW

Thank you.
Elmira Hospital','1','1');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('45','','','18453401090','-5','This is a call from Elmira Hospital reminding you of your appointment for 10:15 am on Wednesday April 14th. If you have any questions please call 7436778433. Thank you.','2010-04-11 15:00:00','1','0','','1','0','0000-00-00 00:00:00','52','54','','2010-04-14 10:15:00','151','Dear Gus Mueller,

This is a message from Elmira Hospital reminding you of your appointment for 10:15 am on Wednesday April 14th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=|BzuS9-hL9-PKW-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=|-hMz4N9GM-JhVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=|kR9uK9-EO9-KXp-TdCbNW

Thank you.
Elmira Hospital','1','2');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('52','','','18453401090','-5','This is a call from Elmira Hospital reminding you of your appointment for 10:45 am on Friday April 16th. If you have any questions please call 7436778433. Thank you.','2010-04-15 15:00:00','1','0','','1','0','0000-00-00 00:00:00','52','54','','2010-04-16 10:45:00','152','Dear Gus Mueller,

This is a message from Elmira Hospital reminding you of your appointment for 10:45 am on Friday April 16th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=JpuL-J-XP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=-NMz-YM9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=QR9-OTzHO9LXp-TdCbNW

Thank you.
Elmira Hospital','1','0');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('53','','','18453401090','-5','This is a call from Elmira Hospital reminding you of your appointment for 10:45 am on Friday April 16th. If you have any questions please call 7436778433. Thank you.','2010-04-14 15:00:00','1','0','','1','0','0000-00-00 00:00:00','52','54','','2010-04-16 10:45:00','152','Dear Gus Mueller,

This is a message from Elmira Hospital reminding you of your appointment for 10:45 am on Friday April 16th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=JpuL-J-XP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=-NMz-YM9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=QR9-OTzHO9LXp-TdCbNW

Thank you.
Elmira Hospital','1','1');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('48','','','18453401090','-5','This is a call from Elmira Hospital reminding you of your appointment for 10:45 am on Friday April 16th. If you have any questions please call 7436778433. Thank you.','2010-04-12 15:00:00','1','0','','1','0','1970-01-01 00:00:00','52','54','','2010-04-16 10:45:00','152','Dear Gus Mueller,

This is a message from Elmira Hospital reminding you of your appointment for 10:45 am on Friday April 16th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=|BzuS9-hL9-PKW-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=|-hMz4N9GM-JhVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=|kR9uK9-EO9-KXp-TdCbNW

Thank you.
Elmira Hospital','1','2');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('56','','','19176504575','-5','This is a call from Elmira Hospital reminding you of your appointment for 10:45 am on Saturday April 17th. If you have any questions please call 7436778433. Thank you.','2010-04-11 15:00:00','1','0','','1','0','1970-01-01 00:00:00','52','53','','2010-04-17 10:45:00','153','Dear Dennis Opp,

This is a message from Elmira Hospital reminding you of your appointment for 10:45 am on Saturday April 17th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=AzuP9-hP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=-XMzaN9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=aR9QK9HO9LXp-TdCbNW

Thank you.
Elmira Hospital','1','2');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('55','','','19176504575','-5','This is a call from Elmira Hospital reminding you of your appointment for 10:45 am on Saturday April 17th. If you have any questions please call 7436778433. Thank you.','2010-04-15 15:00:00','1','0','','1','0','0000-00-00 00:00:00','52','53','','2010-04-17 10:45:00','153','Dear Dennis Opp,

This is a message from Elmira Hospital reminding you of your appointment for 10:45 am on Saturday April 17th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=AzuP9-hP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=-XMzaN9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=aR9QK9HO9LXp-TdCbNW

Thank you.
Elmira Hospital','1','1');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('54','','','19176504575','-5','This is a call from Elmira Hospital reminding you of your appointment for 10:45 am on Saturday April 17th. If you have any questions please call 7436778433. Thank you.','2010-04-16 15:00:00','1','0','','1','0','0000-00-00 00:00:00','52','53','','2010-04-17 10:45:00','153','Dear Dennis Opp,

This is a message from Elmira Hospital reminding you of your appointment for 10:45 am on Saturday April 17th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=AzuP9-hP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=-XMzaN9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=aR9QK9HO9LXp-TdCbNW

Thank you.
Elmira Hospital','1','0');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('57','','','19176504575','-5','This is a call from Elmira Hospital reminding you of your appointment for 9:45 am on Saturday April 17th. If you have any questions please call 7436778433. Thank you.','2010-04-11 15:00:00','1','0','','1','0','1970-01-01 00:00:00','52','53','','2010-04-17 09:45:00','156','Dear Dennis Opp,

This is a message from Elmira Hospital reminding you of your appointment for 9:45 am on Saturday April 17th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=DzuR9GP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=QMzuO9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=4R9kL9HO9LXp-TdCbNW

Thank you.
Elmira Hospital','1','0');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('58','','','19176504575','-5','This is a call from Elmira Hospital reminding you of your appointment for 9:45 am on Saturday April 17th. If you have any questions please call 7436778433. Thank you.','2010-04-11 15:00:00','1','0','','1','0','1970-01-01 00:00:00','52','53','','2010-04-17 09:45:00','156','Dear Dennis Opp,

This is a message from Elmira Hospital reminding you of your appointment for 9:45 am on Saturday April 17th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=DzuR9GP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=QMzuO9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=4R9kL9HO9LXp-TdCbNW

Thank you.
Elmira Hospital','1','1');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('59','','','19176504575','-5','This is a call from Elmira Hospital reminding you of your appointment for 9:45 am on Saturday April 17th. If you have any questions please call 7436778433. Thank you.','2010-04-11 15:00:00','1','0','','1','0','1970-01-01 00:00:00','52','53','','2010-04-17 09:45:00','156','Dear Dennis Opp,

This is a message from Elmira Hospital reminding you of your appointment for 9:45 am on Saturday April 17th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=DzuR9GP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=QMzuO9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=4R9kL9HO9LXp-TdCbNW

Thank you.
Elmira Hospital','1','2');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('60','','','19176504575','-5','This is a call from Elmira Hospital reminding you of your appointment for 2:15 pm on Thursday April 15th. If you have any questions please call 7436778433. Thank you.','2010-04-11 15:00:00','1','0','','1','0','1970-01-01 00:00:00','52','53','','2010-04-15 14:15:00','157','Dear Dennis Opp,

This is a message from Elmira Hospital reminding you of your appointment for 2:15 pm on Thursday April 15th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=EzuL-JGP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=aMz-YO9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-ER9-OL9HO9LXp-TdCbNW

Thank you.
Elmira Hospital','1','0');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('61','','','18453401090','-5','This is a call from Elmira Hospital reminding you of your appointment for 10:15 am on Thursday April 15th. If you have any questions please call 7436778433. Thank you.','2010-04-11 15:00:00','1','0','','1','0','1970-01-01 00:00:00','52','54','','2010-04-15 10:15:00','158','Dear Gus Mueller,

This is a message from Elmira Hospital reminding you of your appointment for 10:15 am on Thursday April 15th with Fredrick Mastow. If you have any questions please call 7436778433.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=FzuP9QP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=kMzaP9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-OR9QM9HO9LXp-TdCbNW

Thank you.
Elmira Hospital','1','0');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('62','','','845 246 5599','-5','This is a call from Kingston Medical Center reminding you of your appointment for 10:00 am on Monday April 19th. If you have any questions please call 845 340 1090. Thank you.','2010-04-18 23:00:00','1','0','','1','0','0000-00-00 00:00:00','1','56','','2010-04-19 10:00:00','165','Dear Laura Powell,

This is a message from Kingston Medical Center reminding you of your appointment for 10:00 am on Monday April 19th with Dr. Nigel Matthews. If you have any questions please call 845 340 1090.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Cz4N9uP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=GNzGS9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=uS9-hP9HO9LXp-TdCbNW

Thank you.
Kingston Medical Center','1','0');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('63','','','845 246 5599','-5','This is a call from Kingston Medical Center reminding you of your appointment for 10:00 am on Monday April 19th. If you have any questions please call 845 340 1090. Thank you.','2010-04-17 23:00:00','1','0','','1','0','0000-00-00 00:00:00','1','56','','2010-04-19 10:00:00','165','Dear Laura Powell,

This is a message from Kingston Medical Center reminding you of your appointment for 10:00 am on Monday April 19th with Dr. Nigel Matthews. If you have any questions please call 845 340 1090.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Cz4N9uP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=GNzGS9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=uS9-hP9HO9LXp-TdCbNW

Thank you.
Kingston Medical Center','1','1');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('64','','','845 246 5599','-5','This is a call from Kingston Medical Center reminding you of your appointment for 10:00 am on Monday April 19th. If you have any questions please call 845 340 1090. Thank you.','2010-04-16 23:00:00','1','0','','1','0','0000-00-00 00:00:00','1','56','','2010-04-19 10:00:00','165','Dear Laura Powell,

This is a message from Kingston Medical Center reminding you of your appointment for 10:00 am on Monday April 19th with Dr. Nigel Matthews. If you have any questions please call 845 340 1090.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Cz4N9uP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=GNzGS9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=uS9-hP9HO9LXp-TdCbNW

Thank you.
Kingston Medical Center','1','2');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('65','','','917 650 4575','-5','This is a call from Kingston Medical Center reminding you of your appointment for 10:15 am on Monday April 19th. If you have any questions please call 845 340 1090. Thank you.','2010-04-18 23:00:00','1','0','','1','0','0000-00-00 00:00:00','1','57','','2010-04-19 10:15:00','166','Dear David  Spitler,

This is a message from Kingston Medical Center reminding you of your appointment for 10:15 am on Monday April 19th with Dr. Nigel Matthews. If you have any questions please call 845 340 1090.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Dz4R9uP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=QNzuS9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=4S9kP9HO9LXp-TdCbNW

Thank you.
Kingston Medical Center','1','0');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('66','','','917 650 4575','-5','This is a call from Kingston Medical Center reminding you of your appointment for 10:15 am on Monday April 19th. If you have any questions please call 845 340 1090. Thank you.','2010-04-17 23:00:00','1','0','','1','0','0000-00-00 00:00:00','1','57','','2010-04-19 10:15:00','166','Dear David  Spitler,

This is a message from Kingston Medical Center reminding you of your appointment for 10:15 am on Monday April 19th with Dr. Nigel Matthews. If you have any questions please call 845 340 1090.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Dz4R9uP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=QNzuS9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=4S9kP9HO9LXp-TdCbNW

Thank you.
Kingston Medical Center','1','1');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('67','','','917 650 4575','-5','This is a call from Kingston Medical Center reminding you of your appointment for 10:15 am on Monday April 19th. If you have any questions please call 845 340 1090. Thank you.','2010-04-16 23:00:00','1','0','','1','0','0000-00-00 00:00:00','1','57','','2010-04-19 10:15:00','166','Dear David  Spitler,

This is a message from Kingston Medical Center reminding you of your appointment for 10:15 am on Monday April 19th with Dr. Nigel Matthews. If you have any questions please call 845 340 1090.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Dz4R9uP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=QNzuS9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=4S9kP9HO9LXp-TdCbNW

Thank you.
Kingston Medical Center','1','2');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('68','','','904 264 9605','-5','This is a call from Kingston Medical Center reminding you of your appointment for 10:00 am on Monday April 19th. If you have any questions please call 845 340 1090. Thank you.','2010-04-18 23:00:00','1','0','','1','0','0000-00-00 00:00:00','1','58','','2010-04-19 10:00:00','167','Dear Lorraine Miller,

This is a message from Kingston Medical Center reminding you of your appointment for 10:00 am on Monday April 19th with Dr. Nigel Matthews. If you have any questions please call 845 340 1090.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Ez4L-JuP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=aNz-YS9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-ES9-OP9HO9LXp-TdCbNW

Thank you.
Kingston Medical Center','1','0');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('69','','','904 264 9605','-5','This is a call from Kingston Medical Center reminding you of your appointment for 10:00 am on Monday April 19th. If you have any questions please call 845 340 1090. Thank you.','2010-04-17 23:00:00','1','0','','1','0','0000-00-00 00:00:00','1','58','','2010-04-19 10:00:00','167','Dear Lorraine Miller,

This is a message from Kingston Medical Center reminding you of your appointment for 10:00 am on Monday April 19th with Dr. Nigel Matthews. If you have any questions please call 845 340 1090.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Ez4L-JuP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=aNz-YS9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-ES9-OP9HO9LXp-TdCbNW

Thank you.
Kingston Medical Center','1','1');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('70','','','904 264 9605','-5','This is a call from Kingston Medical Center reminding you of your appointment for 10:00 am on Monday April 19th. If you have any questions please call 845 340 1090. Thank you.','2010-04-16 23:00:00','1','0','','1','0','0000-00-00 00:00:00','1','58','','2010-04-19 10:00:00','167','Dear Lorraine Miller,

This is a message from Kingston Medical Center reminding you of your appointment for 10:00 am on Monday April 19th with Dr. Nigel Matthews. If you have any questions please call 845 340 1090.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Ez4L-JuP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=aNz-YS9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-ES9-OP9HO9LXp-TdCbNW

Thank you.
Kingston Medical Center','1','2');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('71','','','19176504575','-5','This is a call from Kingston Medical Center reminding you of your appointment for 10:30 am on Friday April 23rd. If you have any questions please call 845 340 1090. Thank you.','2010-04-22 23:00:00','1','0','','1','0','0000-00-00 00:00:00','1','28','','2010-04-23 10:30:00','168','Dear Dennis Dennis,

This is a message from Kingston Medical Center reminding you of your appointment for 10:30 am on Friday April 23rd with Dawn Parklington. If you have any questions please call 845 340 1090.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Fz4P94P9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=kNzaT9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-OS9QQ9HO9LXp-TdCbNW

Thank you.
Kingston Medical Center','0','0');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('72','','','19176504575','-5','This is a call from Kingston Medical Center reminding you of your appointment for 10:30 am on Friday April 23rd. If you have any questions please call 845 340 1090. Thank you.','2010-04-21 23:00:00','1','0','','1','0','0000-00-00 00:00:00','1','28','','2010-04-23 10:30:00','168','Dear Dennis Dennis,

This is a message from Kingston Medical Center reminding you of your appointment for 10:30 am on Friday April 23rd with Dawn Parklington. If you have any questions please call 845 340 1090.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Fz4P94P9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=kNzaT9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-OS9QQ9HO9LXp-TdCbNW

Thank you.
Kingston Medical Center','0','1');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('73','','','19176504575','-5','This is a call from Kingston Medical Center reminding you of your appointment for 10:30 am on Friday April 23rd. If you have any questions please call 845 340 1090. Thank you.','2010-04-20 23:00:00','1','0','','1','0','0000-00-00 00:00:00','1','28','','2010-04-23 10:30:00','168','Dear Dennis Dennis,

This is a message from Kingston Medical Center reminding you of your appointment for 10:30 am on Friday April 23rd with Dawn Parklington. If you have any questions please call 845 340 1090.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Fz4P94P9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=kNzaT9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-OS9QQ9HO9LXp-TdCbNW

Thank you.
Kingston Medical Center','1','2');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('74','','','18453401090','-5','This is a call from Kingston Medical Center reminding you of your appointment for 10:30 am on Friday April 23rd. If you have any questions please call 845 340 1090. Thank you.','2010-04-22 23:00:00','1','0','','1','0','0000-00-00 00:00:00','1','44','','2010-04-23 10:30:00','169','Dear Karlos Muelleruez,

This is a message from Kingston Medical Center reminding you of your appointment for 10:30 am on Friday April 23rd with Dawn Parklington. If you have any questions please call 845 340 1090.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Gz4T94P9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=uNz-ET9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-YS94Q9HO9LXp-TdCbNW

Thank you.
Kingston Medical Center','0','0');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('75','','','18453401090','-5','This is a call from Kingston Medical Center reminding you of your appointment for 10:30 am on Friday April 23rd. If you have any questions please call 845 340 1090. Thank you.','2010-04-21 23:00:00','1','0','','1','0','0000-00-00 00:00:00','1','44','','2010-04-23 10:30:00','169','Dear Karlos Muelleruez,

This is a message from Kingston Medical Center reminding you of your appointment for 10:30 am on Friday April 23rd with Dawn Parklington. If you have any questions please call 845 340 1090.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Gz4T94P9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=uNz-ET9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-YS94Q9HO9LXp-TdCbNW

Thank you.
Kingston Medical Center','0','1');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('76','','','18453401090','-5','This is a call from Kingston Medical Center reminding you of your appointment for 10:30 am on Friday April 23rd. If you have any questions please call 845 340 1090. Thank you.','2010-04-20 23:00:00','1','0','','1','0','0000-00-00 00:00:00','1','44','','2010-04-23 10:30:00','169','Dear Karlos Muelleruez,

This is a message from Kingston Medical Center reminding you of your appointment for 10:30 am on Friday April 23rd with Dawn Parklington. If you have any questions please call 845 340 1090.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Gz4T94P9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=uNz-ET9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-YS94Q9HO9LXp-TdCbNW

Thank you.
Kingston Medical Center','1','2');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('77','','','2221212212','-5','This is a call from Kingston Medical Center reminding you of your appointment for 10:45 am on Friday April 23rd. If you have any questions please call 845 340 1090. Thank you.','2010-04-22 23:00:00','1','0','','1','0','0000-00-00 00:00:00','1','9','','2010-04-23 10:45:00','170','Dear George Roberts,

This is a message from Kingston Medical Center reminding you of your appointment for 10:45 am on Friday April 23rd with Dawn Parklington. If you have any questions please call 845 340 1090.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Hp-EN9-EP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=3OzGK-JuM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-hT9-hR9HO9LXp-TdCbNW

Thank you.
Kingston Medical Center','0','0');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('78','','','2221212212','-5','This is a call from Kingston Medical Center reminding you of your appointment for 10:45 am on Friday April 23rd. If you have any questions please call 845 340 1090. Thank you.','2010-04-21 23:00:00','1','0','','1','0','0000-00-00 00:00:00','1','9','','2010-04-23 10:45:00','170','Dear George Roberts,

This is a message from Kingston Medical Center reminding you of your appointment for 10:45 am on Friday April 23rd with Dawn Parklington. If you have any questions please call 845 340 1090.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Hp-EN9-EP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=3OzGK-JuM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-hT9-hR9HO9LXp-TdCbNW

Thank you.
Kingston Medical Center','0','1');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('79','','','2221212212','-5','This is a call from Kingston Medical Center reminding you of your appointment for 10:45 am on Friday April 23rd. If you have any questions please call 845 340 1090. Thank you.','2010-04-20 23:00:00','1','0','','1','0','0000-00-00 00:00:00','1','9','','2010-04-23 10:45:00','170','Dear George Roberts,

This is a message from Kingston Medical Center reminding you of your appointment for 10:45 am on Friday April 23rd with Dawn Parklington. If you have any questions please call 845 340 1090.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Hp-EN9-EP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=3OzGK-JuM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-hT9-hR9HO9LXp-TdCbNW

Thank you.
Kingston Medical Center','1','2');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('80','','','19176504575','-5','This is a call from Kingston Medical Center reminding you of your appointment for 11:00 am on Wednesday April 28th. If you have any questions please call 845 340 1090. Thank you.','2010-04-27 23:00:00','1','0','','1','0','0000-00-00 00:00:00','1','28','','2010-04-28 11:00:00','171','Dear Dennis Dennis,

This is a message from Kingston Medical Center reminding you of your appointment for 11:00 am on Wednesday April 28th with Dr. Nigel Matthews. If you have any questions please call 845 340 1090.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Ip-ER9-EP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=-DOzuK-JuM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=GT9kR9HO9LXp-TdCbNW

Thank you.
Kingston Medical Center','0','0');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('81','','','19176504575','-5','This is a call from Kingston Medical Center reminding you of your appointment for 11:00 am on Wednesday April 28th. If you have any questions please call 845 340 1090. Thank you.','2010-04-26 23:00:00','1','0','','1','0','0000-00-00 00:00:00','1','28','','2010-04-28 11:00:00','171','Dear Dennis Dennis,

This is a message from Kingston Medical Center reminding you of your appointment for 11:00 am on Wednesday April 28th with Dr. Nigel Matthews. If you have any questions please call 845 340 1090.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Ip-ER9-EP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=-DOzuK-JuM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=GT9kR9HO9LXp-TdCbNW

Thank you.
Kingston Medical Center','0','1');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('82','','','19176504575','-5','This is a call from Kingston Medical Center reminding you of your appointment for 11:00 am on Wednesday April 28th. If you have any questions please call 845 340 1090. Thank you.','2010-04-25 23:00:00','1','0','','1','0','0000-00-00 00:00:00','1','28','','2010-04-28 11:00:00','171','Dear Dennis Dennis,

This is a message from Kingston Medical Center reminding you of your appointment for 11:00 am on Wednesday April 28th with Dr. Nigel Matthews. If you have any questions please call 845 340 1090.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Ip-ER9-EP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=-DOzuK-JuM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=GT9kR9HO9LXp-TdCbNW

Thank you.
Kingston Medical Center','0','2');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('118','','','','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:00 am on Tuesday May 4th. If you have any questions please call 2221212212. Thank you.','2010-05-03 15:00:00','1','0','','1','0','0000-00-00 00:00:00','1','12','','2010-05-04 10:00:00','173','Dear  ,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:00 am on Tuesday May 4th with Dawn Parklington. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Az-EP9-OP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=-XOzaL-JuM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=aT9QS9HO9LXp-TdCbNW

Thank you.
Worthington Medical Facility','0','3');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('127','','','','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:45 am on Wednesday June 9th. If you have any questions please call 2221212212. Thank you.','2010-06-08 15:00:00','1','0','','1','0','0000-00-00 00:00:00','1','12','','2010-06-09 10:45:00','174','Dear  ,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:45 am on Wednesday June 9th with Dawn Parklington. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Bz-ET9-OP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=-hOz-EL-JuM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=kT94S9HO9LXp-TdCbNW

Thank you.
Worthington Medical Facility','0','3');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('128','','','','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:00 am on Tuesday May 4th. If you have any questions please call 2221212212. Thank you.','2010-05-03 15:00:00','1','0','','1','0','0000-00-00 00:00:00','1','9','','2010-05-04 10:00:00','175','Dear  ,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:00 am on Tuesday May 4th with Dawn Parklington. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Cz-EN9-XQ9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=GOzGM94M-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=uT9-hTzRO9LXp-TdCbNW

Thank you.
Worthington Medical Facility','1','3');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('125','','','','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:45 am on Wednesday June 9th. If you have any questions please call 2221212212. Thank you.','2010-05-22 15:00:00','1','0','','1','0','0000-00-00 00:00:00','1','12','','2010-06-09 10:45:00','174','Dear  ,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:45 am on Wednesday June 9th with Dawn Parklington. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Bz-ET9-OP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=-hOz-EL-JuM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=kT94S9HO9LXp-TdCbNW

Thank you.
Worthington Medical Facility','0','0');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('126','','','','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:45 am on Wednesday June 9th. If you have any questions please call 2221212212. Thank you.','2010-05-31 15:00:00','1','0','','1','0','0000-00-00 00:00:00','1','12','','2010-06-09 10:45:00','174','Dear  ,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:45 am on Wednesday June 9th with Dawn Parklington. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Bz-ET9-OP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=-hOz-EL-JuM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=kT94S9HO9LXp-TdCbNW

Thank you.
Worthington Medical Facility','0','1');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('129','','','','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 11:00 am on Wednesday May 5th. If you have any questions please call 2221212212. Thank you.','2010-05-04 15:00:00','1','0','','1','0','0000-00-00 00:00:00','1','16','','2010-05-05 11:00:00','177','Dear  ,

This is a message from Worthington Medical Facility reminding you of your appointment for 11:00 am on Wednesday May 5th with Dawn Parklington. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Ez-EL-J-XQ9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=aOz-YM94M-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-ET9-OTzRO9LXp-TdCbNW

Thank you.
Worthington Medical Facility','0','3');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('130','','','','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:30 am on Wednesday May 12th. If you have any questions please call 2221212212. Thank you.','2010-05-11 15:00:00','1','0','','1','0','0000-00-00 00:00:00','1','12','','2010-05-12 10:30:00','179','Dear  ,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:30 am on Wednesday May 12th with Dawn Parklington. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Gz-ET9-hQ9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=uOz-EN94M-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-YT94K9RO9LXp-TdCbNW

Thank you.
Worthington Medical Facility','0','3');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('131','','','','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:30 am on Wednesday May 12th. If you have any questions please call 2221212212. Thank you.','2010-05-11 15:00:00','1','0','','1','0','0000-00-00 00:00:00','1','12','','2010-05-12 10:30:00','180','Dear  ,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:30 am on Wednesday May 12th with Dawn Parklington. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Hp-ON9GQ9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=3PzGO94M-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-hK-J-hL9RO9LXp-TdCbNW

Thank you.
Worthington Medical Facility','0','3');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('132','','','','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:30 am on Wednesday May 12th. If you have any questions please call 2221212212. Thank you.','2010-05-11 15:00:00','1','0','','1','0','0000-00-00 00:00:00','1','12','','2010-05-12 10:30:00','181','Dear  ,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:30 am on Wednesday May 12th with Dawn Parklington. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=Ip-OR9GQ9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=-DPzuO94M-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=GK-JkL9RO9LXp-TdCbNW

Thank you.
Worthington Medical Facility','0','3');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('138','0','1','917604575','-5','This is a call from Harry's Dog Emporium reminding you of Georgez appointment for 11:30 am on Thursday August 5th. If you have any questions please call . Thank you.','2010-08-04 00:04:00','1','0','1','','','','8','41','','2010-08-05 11:30:00','206','Dear tom terrific,

This is a message from Harry's Dog Emporium reminding you of George's appointment for 11:30 am on Thursday August 5th with Dr. Bite. If you have any questions please call .

If you expect to make this appointment, click this link:
http://vetboxx.com/response.php?x_eq=Dz-hS9GR9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://vetboxx.com/response.php?x_eq=QRp4O9-EM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://vetboxx.com/response.php?x_eq=4M9uL9bO9LXp-TdCbNW

Thank you.
Harry's Dog Emporium

DEBUGGING:
time to call or email:2010-08-04 00:04:00 time of appointment:2010-08-05 11:30:00
This is supposed to have come 2 days before the appointment.
The Event ID for this is: 206','1','2');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('139','1','0','917604575','-5','This is a call from Harry's Dog Emporium reminding you of Georgez appointment for 11:30 am on Thursday August 5th. If you have any questions please call . Thank you.','2010-08-05 00:08:00','1','3','2','','','2010-08-05 02:17:01','8','41','','2010-08-05 11:30:00','206','Dear tom terrific,

This is a message from Harry's Dog Emporium reminding you of George's appointment for 11:30 am on Thursday August 5th with Dr. Bite. If you have any questions please call .

If you expect to make this appointment, click this link:
http://vetboxx.com/response.php?x_eq=Dz-hS9GR9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://vetboxx.com/response.php?x_eq=QRp4O9-EM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://vetboxx.com/response.php?x_eq=4M9uL9bO9LXp-TdCbNW

Thank you.
Harry's Dog Emporium

DEBUGGING:
time to call or email:2010-08-05 00:08:00 time of appointment:2010-08-05 11:30:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 206','1','3');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('140','1','0','','-2','This is a call from Flicker Tech reminding you of your appointment for 10:00 am on Tuesday August 10th. If you have any questions please call 3332221122. Thank you.','2010-08-09 21:05:00','1','3','2','','','2010-08-09 23:13:01','10','43','','2010-08-10 10:00:00','207','Dear harold beaver,

This is a message from Flicker Tech reminding you of your appointment for 10:00 am on Tuesday August 10th with vetty. If you have any questions please call 3332221122.

If you expect to make this appointment, click this link:
http://vetboxx.com/response.php?x_eq=Ez-hM9QR9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://vetboxx.com/response.php?x_eq=aRp-hP9-EM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://vetboxx.com/response.php?x_eq=-EM9-XM9bO9LXp-TdCbNW

Thank you.
Flicker Tech','1','3');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('141','0','1','19176504575','-5','This is a call from Harry's Dog Emporium reminding you of your appointment for 10:45 am on Friday August 13th. If you have any questions please call . Thank you.','2010-08-12 00:00:00','1','0','1','','','','8','42','','2010-08-13 10:45:00','208','Dear Laura Powell,

This is a message from Harry's Dog Emporium reminding you of your appointment for 10:45 am on Friday August 13th with Richard Blinkinfeld. If you have any questions please call .

If you expect to make this appointment, click this link:
http://vetboxx.com/response.php?x_eq=Fz-hQ9QR9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://vetboxx.com/response.php?x_eq=kRpkP9-EM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://vetboxx.com/response.php?x_eq=-OM9aM9bO9LXp-TdCbNW

Thank you.
Harry's Dog Emporium','1','2');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('142','1','0','19176504575','-5','This is a call from Harry's Dog Emporium reminding you of your appointment for 10:45 am on Friday August 13th. If you have any questions please call . Thank you.','2010-08-13 00:12:00','1','1','3','','','2010-08-13 00:13:01','8','42','','2010-08-13 10:45:00','208','Dear Laura Powell,

This is a message from Harry's Dog Emporium reminding you of your appointment for 10:45 am on Friday August 13th with Richard Blinkinfeld. If you have any questions please call .

If you expect to make this appointment, click this link:
http://vetboxx.com/response.php?x_eq=Fz-hQ9QR9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://vetboxx.com/response.php?x_eq=kRpkP9-EM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://vetboxx.com/response.php?x_eq=-OM9aM9bO9LXp-TdCbNW

Thank you.
Harry's Dog Emporium','1','3');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('143','0','1','19176504575','-5','This is a call from Harry's Dog Emporium reminding you of RBz appointment for 3:00 pm on Friday August 13th. If you have any questions please call . Thank you.','2010-08-12 00:11:00','1','0','1','','','','8','44','','2010-08-13 15:00:00','209','Dear Laura Powell,

This is a message from Harry's Dog Emporium reminding you of RB's appointment for 3:00 pm on Friday August 13th with Devon. If you have any questions please call .

If you expect to make this appointment, click this link:
http://vetboxx.com/response.php?x_eq=Gz-hK-JQR9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://vetboxx.com/response.php?x_eq=uRp-OP9-EM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://vetboxx.com/response.php?x_eq=-YM9-EM9bO9LXp-TdCbNW

Thank you.
Harry's Dog Emporium','1','2');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('144','1','0','19176504575','-5','This is a call from Harry's Dog Emporium reminding you of RBz appointment for 3:00 pm on Friday August 13th. If you have any questions please call . Thank you.','2010-08-13 00:17:00','1','1','3','','','2010-08-13 00:17:01','8','44','','2010-08-13 15:00:00','209','Dear Laura Powell,

This is a message from Harry's Dog Emporium reminding you of RB's appointment for 3:00 pm on Friday August 13th with Devon. If you have any questions please call .

If you expect to make this appointment, click this link:
http://vetboxx.com/response.php?x_eq=Gz-hK-JQR9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://vetboxx.com/response.php?x_eq=uRp-OP9-EM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://vetboxx.com/response.php?x_eq=-YM9-EM9bO9LXp-TdCbNW

Thank you.
Harry's Dog Emporium','1','3');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('145','0','1','19176504575','-5','This is a call from Harry's Dog Emporium reminding you of your appointment for 10:30 am on Monday August 16th. If you have any questions please call . Thank you.','2010-08-15 00:14:00','1','0','1','','','','8','42','','2010-08-16 10:30:00','211','Dear Laura Powell,

This is a message from Harry's Dog Emporium reminding you of your appointment for 10:30 am on Monday August 16th with Dr. Bite. If you have any questions please call .

If you expect to make this appointment, click this link:
http://vetboxx.com/response.php?x_eq=IpGS9aR9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://vetboxx.com/response.php?x_eq=-DSp4Q9-EM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://vetboxx.com/response.php?x_eq=GN9uN9bO9LXp-TdCbNW

Thank you.
Harry's Dog Emporium','1','2');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('146','1','0','19176504575','-5','This is a call from Harry's Dog Emporium reminding you of your appointment for 10:30 am on Monday August 16th. If you have any questions please call . Thank you.','2010-08-16 00:19:00','1','1','3','','','2010-08-16 00:19:01','8','42','','2010-08-16 10:30:00','211','Dear Laura Powell,

This is a message from Harry's Dog Emporium reminding you of your appointment for 10:30 am on Monday August 16th with Dr. Bite. If you have any questions please call .

If you expect to make this appointment, click this link:
http://vetboxx.com/response.php?x_eq=IpGS9aR9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://vetboxx.com/response.php?x_eq=-DSp4Q9-EM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://vetboxx.com/response.php?x_eq=GN9uN9bO9LXp-TdCbNW

Thank you.
Harry's Dog Emporium','1','3');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('147','0','1','19176504575','-5','This is a call from Harry's Dog Emporium reminding you of RBz appointment for 1:45 pm on Monday August 16th. If you have any questions please call . Thank you.','2010-08-15 00:08:00','1','0','1','','','','8','44','','2010-08-16 13:45:00','212','Dear Laura Powell,

This is a message from Harry's Dog Emporium reminding you of RB's appointment for 1:45 pm on Monday August 16th with Dr. Bite. If you have any questions please call .

If you expect to make this appointment, click this link:
http://vetboxx.com/response.php?x_eq=JpGM9kR9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://vetboxx.com/response.php?x_eq=-NSp-hR9-EM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://vetboxx.com/response.php?x_eq=QN9-XO9bO9LXp-TdCbNW

Thank you.
Harry's Dog Emporium','1','2');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('148','1','0','19176504575','-5','This is a call from Harry's Dog Emporium reminding you of RBz appointment for 1:45 pm on Monday August 16th. If you have any questions please call . Thank you.','2010-08-16 00:13:00','1','1','3','','','2010-08-16 00:13:02','8','44','','2010-08-16 13:45:00','212','Dear Laura Powell,

This is a message from Harry's Dog Emporium reminding you of RB's appointment for 1:45 pm on Monday August 16th with Dr. Bite. If you have any questions please call .

If you expect to make this appointment, click this link:
http://vetboxx.com/response.php?x_eq=JpGM9kR9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://vetboxx.com/response.php?x_eq=-NSp-hR9-EM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://vetboxx.com/response.php?x_eq=QN9-XO9bO9LXp-TdCbNW

Thank you.
Harry's Dog Emporium','1','3');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('149','0','1','19176504575','-5','This is a call from Harry's Dog Emporium reminding you of your appointment for 9:45 am on Tuesday August 17th. If you have any questions please call . Thank you.','2010-08-16 00:13:00','1','0','1','','','','8','42','','2010-08-17 09:45:00','213','Dear Laura Powell,

This is a message from Harry's Dog Emporium reminding you of your appointment for 9:45 am on Tuesday August 17th with Dr. Bite. If you have any questions please call .

If you expect to make this appointment, click this link:
http://vetboxx.com/response.php?x_eq=AzGQ9kR9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://vetboxx.com/response.php?x_eq=-XSpkR9-EM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://vetboxx.com/response.php?x_eq=aN9aO9bO9LXp-TdCbNW

Thank you.
Harry's Dog Emporium','1','2');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('150','1','0','19176504575','-5','This is a call from Harry's Dog Emporium reminding you of your appointment for 9:45 am on Tuesday August 17th. If you have any questions please call . Thank you.','2010-08-17 00:07:00','1','1','3','','','2010-08-17 00:07:01','8','42','','2010-08-17 09:45:00','213','Dear Laura Powell,

This is a message from Harry's Dog Emporium reminding you of your appointment for 9:45 am on Tuesday August 17th with Dr. Bite. If you have any questions please call .

If you expect to make this appointment, click this link:
http://vetboxx.com/response.php?x_eq=AzGQ9kR9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://vetboxx.com/response.php?x_eq=-XSpkR9-EM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://vetboxx.com/response.php?x_eq=aN9aO9bO9LXp-TdCbNW

Thank you.
Harry's Dog Emporium','1','3');
INSERT INTO vetboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('151','1','0','19176504575','-5','This is a call from Harry's Dog Emporium reminding you of RBz appointment for 11:45 am on Saturday August 21st. If you have any questions please call . Thank you.','2010-08-21 00:10:00','1','1','3','','','2010-08-21 00:11:01','8','44','','2010-08-21 11:45:00','214','Dear Laura Powell,

This is a message from Harry's Dog Emporium reminding you of RB's appointment for 11:45 am on Saturday August 21st with Devon. If you have any questions please call .

If you expect to make this appointment, click this link:
http://vetboxx.com/response.php?x_eq=BzGK-JkR9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://vetboxx.com/response.php?x_eq=-hSp-OR9-EM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://vetboxx.com/response.php?x_eq=kN9-EO9bO9LXp-TdCbNW

Thank you.
Harry's Dog Emporium','1','3');


CREATE TABLE `phonecall_status` (
  `phonecall_status_id` int(11) NOT NULL auto_increment,
  `status_name` varchar(50) default NULL,
  PRIMARY KEY  (`phonecall_status_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;



INSERT INTO vetboxx.phonecall_status(`phonecall_status_id`,`status_name`) VALUES('1','scheduled');
INSERT INTO vetboxx.phonecall_status(`phonecall_status_id`,`status_name`) VALUES('2','called no status update');
INSERT INTO vetboxx.phonecall_status(`phonecall_status_id`,`status_name`) VALUES('3','answered');
INSERT INTO vetboxx.phonecall_status(`phonecall_status_id`,`status_name`) VALUES('4','busy');
INSERT INTO vetboxx.phonecall_status(`phonecall_status_id`,`status_name`) VALUES('5','no answer');
INSERT INTO vetboxx.phonecall_status(`phonecall_status_id`,`status_name`) VALUES('6','channel unavailable');
INSERT INTO vetboxx.phonecall_status(`phonecall_status_id`,`status_name`) VALUES('7','other');


CREATE TABLE `practitioner` (
  `practitioner_id` int(11) NOT NULL auto_increment,
  `name` varchar(50) default NULL,
  `practitioner_type_id` int(50) default NULL,
  `phone` varchar(50) default NULL,
  `facility` varchar(100) default NULL,
  `address` varchar(200) default NULL,
  `office_id` int(11) default NULL,
  PRIMARY KEY  (`practitioner_id`)
) ENGINE=MyISAM AUTO_INCREMENT=114 DEFAULT CHARSET=latin1;



INSERT INTO vetboxx.practitioner(`practitioner_id`,`name`,`practitioner_type_id`,`phone`,`facility`,`address`,`office_id`) VALUES('1','Dr. Peter Richards','5','1:1:111 211 2112','	Kingston Medical','1:5g jghhhhhh','1');
INSERT INTO vetboxx.practitioner(`practitioner_id`,`name`,`practitioner_type_id`,`phone`,`facility`,`address`,`office_id`) VALUES('2','Dr. Oliver Primack','5','2:2:888 443 2312','	Kingston Medical','2:6g jgh j','1');
INSERT INTO vetboxx.practitioner(`practitioner_id`,`name`,`practitioner_type_id`,`phone`,`facility`,`address`,`office_id`) VALUES('3','Dr. Nigel Matthews','4','232 121 4421','	Kingston Medical','233 Koolington Blvd','1');
INSERT INTO vetboxx.practitioner(`practitioner_id`,`name`,`practitioner_type_id`,`phone`,`facility`,`address`,`office_id`) VALUES('4','Dr. Thor Walker','2','3:232 121 4421','Kingston Medical','3:8hgj ghj rockingham','1');
INSERT INTO vetboxx.practitioner(`practitioner_id`,`name`,`practitioner_type_id`,`phone`,`facility`,`address`,`office_id`) VALUES('103','Dawn Parklington','6','','','','1');
INSERT INTO vetboxx.practitioner(`practitioner_id`,`name`,`practitioner_type_id`,`phone`,`facility`,`address`,`office_id`) VALUES('104','Fredrick Mastow','1','4443334433','','','52');
INSERT INTO vetboxx.practitioner(`practitioner_id`,`name`,`practitioner_type_id`,`phone`,`facility`,`address`,`office_id`) VALUES('105','Tonia Kusters','0','','','','5');
INSERT INTO vetboxx.practitioner(`practitioner_id`,`name`,`practitioner_type_id`,`phone`,`facility`,`address`,`office_id`) VALUES('106','Anita Hayes','0','','','','5');
INSERT INTO vetboxx.practitioner(`practitioner_id`,`name`,`practitioner_type_id`,`phone`,`facility`,`address`,`office_id`) VALUES('107','Anita Hayes','1','0872477622','','','5');
INSERT INTO vetboxx.practitioner(`practitioner_id`,`name`,`practitioner_type_id`,`phone`,`facility`,`address`,`office_id`) VALUES('108','Tonia Kusters','1','','','','5');
INSERT INTO vetboxx.practitioner(`practitioner_id`,`name`,`practitioner_type_id`,`phone`,`facility`,`address`,`office_id`) VALUES('109','Dr. Bite','','','','','8');
INSERT INTO vetboxx.practitioner(`practitioner_id`,`name`,`practitioner_type_id`,`phone`,`facility`,`address`,`office_id`) VALUES('110','Richard Blinkinfeld','5','2221212212','','','8');
INSERT INTO vetboxx.practitioner(`practitioner_id`,`name`,`practitioner_type_id`,`phone`,`facility`,`address`,`office_id`) VALUES('111','Henry Flickerdorf','1','','','','9');
INSERT INTO vetboxx.practitioner(`practitioner_id`,`name`,`practitioner_type_id`,`phone`,`facility`,`address`,`office_id`) VALUES('112','vetty','','4443434','','','10');
INSERT INTO vetboxx.practitioner(`practitioner_id`,`name`,`practitioner_type_id`,`phone`,`facility`,`address`,`office_id`) VALUES('113','Devon','','','','','8');


CREATE TABLE `practitioner_type` (
  `practitioner_type_id` int(4) NOT NULL auto_increment,
  `type_name` varchar(50) default NULL,
  PRIMARY KEY  (`practitioner_type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;



INSERT INTO vetboxx.practitioner_type(`practitioner_type_id`,`type_name`) VALUES('1','General');
INSERT INTO vetboxx.practitioner_type(`practitioner_type_id`,`type_name`) VALUES('2','Technician');
INSERT INTO vetboxx.practitioner_type(`practitioner_type_id`,`type_name`) VALUES('3','Chiropracter');
INSERT INTO vetboxx.practitioner_type(`practitioner_type_id`,`type_name`) VALUES('4','Specialist');
INSERT INTO vetboxx.practitioner_type(`practitioner_type_id`,`type_name`) VALUES('5','Surgeon');
INSERT INTO vetboxx.practitioner_type(`practitioner_type_id`,`type_name`) VALUES('6','Nurse');
INSERT INTO vetboxx.practitioner_type(`practitioner_type_id`,`type_name`) VALUES('7','Spiritual');


CREATE TABLE `promo_code` (
  `promo_code_id` int(11) NOT NULL auto_increment,
  `code` varchar(50) default NULL,
  `office_id` int(11) default NULL,
  PRIMARY KEY  (`promo_code_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;



INSERT INTO vetboxx.promo_code(`promo_code_id`,`code`,`office_id`) VALUES('1','2300','0');
INSERT INTO vetboxx.promo_code(`promo_code_id`,`code`,`office_id`) VALUES('2','flicker','10');
INSERT INTO vetboxx.promo_code(`promo_code_id`,`code`,`office_id`) VALUES('3','hurley','0');


CREATE TABLE `question_column_map` (
  `question_column_map_id` int(4) NOT NULL auto_increment,
  `questionnaire_id` int(4) default NULL,
  `table_name` varchar(50) default NULL,
  `column_name` varchar(50) default NULL,
  `questionnaire_question_id` int(4) default NULL,
  `sort_id` int(50) default NULL,
  PRIMARY KEY  (`question_column_map_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;



INSERT INTO vetboxx.question_column_map(`question_column_map_id`,`questionnaire_id`,`table_name`,`column_name`,`questionnaire_question_id`,`sort_id`) VALUES('1','8','practitioner','name','48','0');
INSERT INTO vetboxx.question_column_map(`question_column_map_id`,`questionnaire_id`,`table_name`,`column_name`,`questionnaire_question_id`,`sort_id`) VALUES('2','8','practitioner','phone','49','0');
INSERT INTO vetboxx.question_column_map(`question_column_map_id`,`questionnaire_id`,`table_name`,`column_name`,`questionnaire_question_id`,`sort_id`) VALUES('3','8','practitioner','facility','50','0');
INSERT INTO vetboxx.question_column_map(`question_column_map_id`,`questionnaire_id`,`table_name`,`column_name`,`questionnaire_question_id`,`sort_id`) VALUES('4','8','practitioner','practitioner_type_id','55','0');
INSERT INTO vetboxx.question_column_map(`question_column_map_id`,`questionnaire_id`,`table_name`,`column_name`,`questionnaire_question_id`,`sort_id`) VALUES('5','8','practitioner','address','51','0');
INSERT INTO vetboxx.question_column_map(`question_column_map_id`,`questionnaire_id`,`table_name`,`column_name`,`questionnaire_question_id`,`sort_id`) VALUES('6','11','insurance','insurance_name','57','0');
INSERT INTO vetboxx.question_column_map(`question_column_map_id`,`questionnaire_id`,`table_name`,`column_name`,`questionnaire_question_id`,`sort_id`) VALUES('9','11','insurance','mileage_reimburse_rate','60','0');
INSERT INTO vetboxx.question_column_map(`question_column_map_id`,`questionnaire_id`,`table_name`,`column_name`,`questionnaire_question_id`,`sort_id`) VALUES('10','12','subuser','name','62','0');
INSERT INTO vetboxx.question_column_map(`question_column_map_id`,`questionnaire_id`,`table_name`,`column_name`,`questionnaire_question_id`,`sort_id`) VALUES('11','12','subuser','birthday','77','0');
INSERT INTO vetboxx.question_column_map(`question_column_map_id`,`questionnaire_id`,`table_name`,`column_name`,`questionnaire_question_id`,`sort_id`) VALUES('12','11','insurance','membership_number','75','0');
INSERT INTO vetboxx.question_column_map(`question_column_map_id`,`questionnaire_id`,`table_name`,`column_name`,`questionnaire_question_id`,`sort_id`) VALUES('13','11','insurance','group_number','76','0');
INSERT INTO vetboxx.question_column_map(`question_column_map_id`,`questionnaire_id`,`table_name`,`column_name`,`questionnaire_question_id`,`sort_id`) VALUES('14','11','insurance','annual_maximum','79','0');


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



INSERT INTO vetboxx.questionnaire(`questionnaire_id`,`name`,`intro_text`,`questionnaire_type_id`,`author_id`,`created`,`answer_tally`,`link_next_questionnaire_id`,`sort_order`,`accept_multiple`,`related_table_name`,`populate_related`) VALUES('1','Identifying Information','','1','0','2007-07-30 17:56:53','0','0','1','0','','0');
INSERT INTO vetboxx.questionnaire(`questionnaire_id`,`name`,`intro_text`,`questionnaire_type_id`,`author_id`,`created`,`answer_tally`,`link_next_questionnaire_id`,`sort_order`,`accept_multiple`,`related_table_name`,`populate_related`) VALUES('2','Contact Info','','1','0','2007-07-30 17:56:53','0','0','2','0','','0');
INSERT INTO vetboxx.questionnaire(`questionnaire_id`,`name`,`intro_text`,`questionnaire_type_id`,`author_id`,`created`,`answer_tally`,`link_next_questionnaire_id`,`sort_order`,`accept_multiple`,`related_table_name`,`populate_related`) VALUES('4','Visits','','1','0','2007-07-30 17:56:53','0','0','7','1','','0');
INSERT INTO vetboxx.questionnaire(`questionnaire_id`,`name`,`intro_text`,`questionnaire_type_id`,`author_id`,`created`,`answer_tally`,`link_next_questionnaire_id`,`sort_order`,`accept_multiple`,`related_table_name`,`populate_related`) VALUES('6','calendar event','','2','0','2007-05-22 18:08:33','0','0','44','1','','0');
INSERT INTO vetboxx.questionnaire(`questionnaire_id`,`name`,`intro_text`,`questionnaire_type_id`,`author_id`,`created`,`answer_tally`,`link_next_questionnaire_id`,`sort_order`,`accept_multiple`,`related_table_name`,`populate_related`) VALUES('7','Emergency Contacts','','1','0','2007-07-30 17:56:53','0','0','4','1','','0');
INSERT INTO vetboxx.questionnaire(`questionnaire_id`,`name`,`intro_text`,`questionnaire_type_id`,`author_id`,`created`,`answer_tally`,`link_next_questionnaire_id`,`sort_order`,`accept_multiple`,`related_table_name`,`populate_related`) VALUES('8','Personal Practitioners','','1','0','2007-07-30 17:56:53','0','0','5','1','practitioner','1');
INSERT INTO vetboxx.questionnaire(`questionnaire_id`,`name`,`intro_text`,`questionnaire_type_id`,`author_id`,`created`,`answer_tally`,`link_next_questionnaire_id`,`sort_order`,`accept_multiple`,`related_table_name`,`populate_related`) VALUES('9','Provider','','0','0','2007-05-22 18:08:33','0','0','44','0','','1');
INSERT INTO vetboxx.questionnaire(`questionnaire_id`,`name`,`intro_text`,`questionnaire_type_id`,`author_id`,`created`,`answer_tally`,`link_next_questionnaire_id`,`sort_order`,`accept_multiple`,`related_table_name`,`populate_related`) VALUES('11','Insurance','<div>This is where you list your insurance providers.&nbsp;</div>','1','0','2007-07-30 17:56:53','0','0','6','1','insurance','1');
INSERT INTO vetboxx.questionnaire(`questionnaire_id`,`name`,`intro_text`,`questionnaire_type_id`,`author_id`,`created`,`answer_tally`,`link_next_questionnaire_id`,`sort_order`,`accept_multiple`,`related_table_name`,`populate_related`) VALUES('12','Family Members','<div>Enter the people whose medical records you are maintaining.&nbsp;</div>','1','0','2007-07-30 17:56:53','0','0','3','1','subuser','1');
INSERT INTO vetboxx.questionnaire(`questionnaire_id`,`name`,`intro_text`,`questionnaire_type_id`,`author_id`,`created`,`answer_tally`,`link_next_questionnaire_id`,`sort_order`,`accept_multiple`,`related_table_name`,`populate_related`) VALUES('3','medications','','3','0','2007-07-30 18:01:38','0','0','0','1','','0');
INSERT INTO vetboxx.questionnaire(`questionnaire_id`,`name`,`intro_text`,`questionnaire_type_id`,`author_id`,`created`,`answer_tally`,`link_next_questionnaire_id`,`sort_order`,`accept_multiple`,`related_table_name`,`populate_related`) VALUES('5','tests','','3','0','2007-07-30 18:02:09','0','0','0','1','','0');


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



INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('3','Gender','1','0','0','gender','0','0','0','0','');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('4','Hair color','1','0','0','hair_color','0','0','0','0','');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('5','Eye color','1','0','0','eye_color','0','0','0','0','');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('6','Ethnicity','1','0','0','ethnicity','0','0','0','0','');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('7','Language','1','0','0','language','0','0','0','0','');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('8','Marital Status','1','0','0','marital_status','0','0','0','0','');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('9','Sexual preference','1','0','0','sexual_preference','0','0','0','0','');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('10','Religion','1','0','0','religion','0','0','0','0','');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('11','Blood type','1','0','0','blood_type','0','0','0','0','');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('12','Height &#40;in inches&#41;','1','0','0','','0','0','0','0','int');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('13','Weight &#40;in pounds&#41;','1','0','0','','0','0','0','0','int');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('14','Birthdate','1','0','0','','0','0','0','0','date');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('15','Home telephone','2','0','0','','0','0','0','0','');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('16','Work telephone','2','0','0','','0','0','0','0','');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('17','Mobile telephone','2','0','0','','0','0','0','0','');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('19','Address Line 1','2','0','0','','0','0','0','0','');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('20','Address Line 2','2','0','0','','0','0','0','0','');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('21','City or Town','2','0','0','','0','0','0','0','');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('22','State or Province','2','0','0','state','0','0','0','0','');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('23','Zip or Postal Code','2','0','0','','0','0','2','4','');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('24','Country','2','0','0','country','0','0','0','0','');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('25','SSN','1','0','0','','0','0','0','0','');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('26','First Name','1','0','0','','0','0','0','0','');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('27','Middle Name','1','0','0','','0','0','0','0','');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('28','Last Name','1','0','0','','0','0','0','0','');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('29','medication','3','2','0','','0','0','0','0','');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('30','amount','3','3','0','','0','0','0','0','');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('31','start date','3','5','0','','0','0','0','0','date');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('77','birth date','12','2','0','','0','0','0','0','date');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('33','doctor','3','1','0','practitioner','0','0','0','0','int');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('68','refill #','3','4','0','','0','0','0','0','int');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('35','date','4','0','0','','0','0','0','0','date');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('36','type','4','2','0','','0','0','0','0','');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('37','medical facility','4','3','0','','0','0','0','0','');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('38','contact','4','7','0','','0','0','0','0','');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('39','reason','4','9','0','','0','0','0','0','text');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('40','test','5','0','0','','0','0','0','0','');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('41','date','5','6','0','','0','0','0','0','');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('42','notes','5','12','0','','0','0','0','0','text');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('43','type','6','0','0','','0','0','0','0','');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('44','description','6','1','0','','0','0','0','0','');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('45','contact name','7','0','0','','0','0','0','0','');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('46','phone','7','0','0','','0','0','0','0','');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('47','description','7','0','0','','0','0','0','0','');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('48','Name','8','1','0','','0','0','0','0','');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('49','Phone #','8','3','0','','0','0','0','0','');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('50','Facility','8','4','0','','0','0','0','0','');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('51','Address','8','5','0','','0','0','0','0','');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('55','Type','8','2','0','practitioner_type','0','0','0','0','');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('56','practitioner_id','8','6','0','','0','0','0','0','hidden');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('57','name','11','0','0','','0','0','0','0','');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('65','insurer','11','0','0','insurer','0','0','0','0','');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('60','reimburse rate','11','0','0','','0','0','0','0','');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('61','insurance_id','11','0','0','','0','0','0','0','hidden');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('62','name','12','1','0','','0','0','0','0','');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('64','subuser_id','12','3','0','','0','0','0','0','hidden');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('66','doctor','5','0','0','practitioner','0','0','0','0','int');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('79','annual maximum','11','0','0','','0','0','0','0','');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('75','membership number','11','0','0','','0','0','0','0','');
INSERT INTO vetboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('76','group number','11','0','0','','0','0','0','0','');


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



INSERT INTO vetboxx.questionnaire_type(`questionnaire_type_id`,`type_name`) VALUES('1','site medical profile');
INSERT INTO vetboxx.questionnaire_type(`questionnaire_type_id`,`type_name`) VALUES('2','template');
INSERT INTO vetboxx.questionnaire_type(`questionnaire_type_id`,`type_name`) VALUES('3','medications and tests');


CREATE TABLE `recurrence` (
  `recurrence_id` int(4) NOT NULL auto_increment,
  `recurrence_name` varchar(50) default NULL,
  `recurrence_interval` varchar(22) default NULL,
  `avoidance_id` int(4) default NULL,
  PRIMARY KEY  (`recurrence_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;



INSERT INTO vetboxx.recurrence(`recurrence_id`,`recurrence_name`,`recurrence_interval`,`avoidance_id`) VALUES('1','six months','6 m','2');
INSERT INTO vetboxx.recurrence(`recurrence_id`,`recurrence_name`,`recurrence_interval`,`avoidance_id`) VALUES('2','one month','1 m','2');
INSERT INTO vetboxx.recurrence(`recurrence_id`,`recurrence_name`,`recurrence_interval`,`avoidance_id`) VALUES('3','one week','1 W','2');
INSERT INTO vetboxx.recurrence(`recurrence_id`,`recurrence_name`,`recurrence_interval`,`avoidance_id`) VALUES('4','one year','1 Y','2');
INSERT INTO vetboxx.recurrence(`recurrence_id`,`recurrence_name`,`recurrence_interval`,`avoidance_id`) VALUES('5','two weeks','2 W','2');


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



INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('1','AL','ALABAMA');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('2','AK','ALASKA');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('3','AZ','ARIZONA');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('4','AR','ARKANSAS');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('5','CA','CALIFORNIA');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('6','CO','COLORADO');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('7','CT','CONNECTICUT');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('8','DE','DELAWARE');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('9','FL','FLORIDA');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('10','GA','GEORGIA');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('11','HI','HAWAII');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('12','ID','IDAHO');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('13','IL','ILLINOIS');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('14','IN','INDIANA');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('15','IA','IOWA');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('16','KS','KANSAS');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('17','KY','KENTUCKY');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('18','LA','LOUISIANA');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('19','ME','MAINE');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('20','MD','MARYLAND');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('21','MA','MASSACHUSETTS');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('22','MI','MICHIGAN');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('23','MN','MINNESOTA');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('24','MS','MISSISSIPPI');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('25','MO','MISSOURI');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('26','MT','MONTANA');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('27','NE','NEBRASKA');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('28','NV','NEVADA');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('29','NH','NEW HAMPSHIRE');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('30','NJ','NEW JERSEY');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('31','NM','NEW MEXICO');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('32','NY','NEW YORK');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('33','NC','NORTH CAROLINA');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('34','ND','NORTH DAKOTA');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('35','OH','OHIO');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('36','OK','OKLAHOMA');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('37','OR','OREGON');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('38','PA','PENNSYLVANIA');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('39','RI','RHODE ISLAND');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('40','SC','SOUTH CAROLINA');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('41','SD','SOUTH DAKOTA');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('42','TN','TENNESSEE');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('43','TX','TEXAS');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('44','UT','UTAH');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('45','VT','VERMONT');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('46','VA','VIRGINIA');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('47','WA','WASHINGTON');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('48','WV','WEST VIRGINIA');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('49','WI','WISCONSIN');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('50','WY','WYOMING');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('51','CZ','CANAL ZONE');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('52','DC','DISTRICT OF COLUMBIA');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('53','GU','GUAM');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('54','PR','PUERTO RICO');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('55','AS','U.S. PACIFIC IS.');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('56','US','UNITED STATES');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('57','VI','VIRGIN (U.S.) ISLANDS');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('58','AB','Alberta');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('59','BC','British Columbia');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('60','MB','Manitoba');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('61','NB','New Brunswick');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('62','NL','Newfoundland and Labra');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('63','NT','Northwest Territories');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('64','NS','Nova Scotia');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('65','NU','Nunavut');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('66','ON','Ontario');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('67','PE','Prince Edward Island');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('68','QC','Quebec');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('69','SK','Saskatchewan');
INSERT INTO vetboxx.state(`state_id`,`code`,`state_name`) VALUES('70','YT','Yukon');


CREATE TABLE `tf_dbmap` (
  `dbmap_id` int(11) NOT NULL auto_increment,
  `map_name` varchar(60) default NULL,
  `timecreated` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`dbmap_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;



INSERT INTO vetboxx.tf_dbmap(`dbmap_id`,`map_name`,`timecreated`) VALUES('1','phonecalls','2009-12-15 13:34:49');
INSERT INTO vetboxx.tf_dbmap(`dbmap_id`,`map_name`,`timecreated`) VALUES('2','real','2010-05-25 13:31:48');
INSERT INTO vetboxx.tf_dbmap(`dbmap_id`,`map_name`,`timecreated`) VALUES('3','New Map','2010-07-05 02:50:26');


CREATE TABLE `tf_dbmap_table` (
  `table_name` varchar(44) NOT NULL,
  `dbmap_id` int(11) NOT NULL default '0',
  `top_pos` int(11) default NULL,
  `left_pos` int(11) default NULL,
  `color_basis` varchar(50) default NULL,
  PRIMARY KEY  (`table_name`,`dbmap_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



INSERT INTO vetboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('client','3','70','30','');
INSERT INTO vetboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('office','3','70','206','');
INSERT INTO vetboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('phone_call','3','70','366','');
INSERT INTO vetboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('personal_calendar_event','3','70','518','');
INSERT INTO vetboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('questionnaire','3','196','1151','');
INSERT INTO vetboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('questionnaire_question','3','70','739','');
INSERT INTO vetboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('tf_relation','3','734','1086','');
INSERT INTO vetboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('calendar_event','3','70','939','');
INSERT INTO vetboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('questionnaire_answer','3','268','939','');
INSERT INTO vetboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('practitioner','3','543','664','');
INSERT INTO vetboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('formlog','3','484','366','');
INSERT INTO vetboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('calendar_range','3','448','939','');
INSERT INTO vetboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('question_column_map','3','736','30','');
INSERT INTO vetboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('mysql_errorlog','3','736','230','');
INSERT INTO vetboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('login','3','736','366','');
INSERT INTO vetboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('calendar','3','444','1172','');
INSERT INTO vetboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('tf_scriptlog','3','768','520','');
INSERT INTO vetboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('questionnaire_suggested_answer','3','608','1095','');
INSERT INTO vetboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('call_type','3','736','950','');
INSERT INTO vetboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('tf_dbmap_table','3','916','30','');
INSERT INTO vetboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('recurrence','3','916','164','');
INSERT INTO vetboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('content','3','916','316','');
INSERT INTO vetboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('calendar_set_map','3','916','420','');
INSERT INTO vetboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('timezone','3','660','512','');
INSERT INTO vetboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('tf_sqllog','3','610','939','');
INSERT INTO vetboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('tf_dbmap','3','916','572','');
INSERT INTO vetboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('state','3','643','388','');
INSERT INTO vetboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('server_task','3','916','740','');
INSERT INTO vetboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('mail_log','3','916','852','');
INSERT INTO vetboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('calendar_set','3','916','940','');
INSERT INTO vetboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('tf_relation_type','3','1024','30','');
INSERT INTO vetboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('questionnaire_type','3','1024','184','');
INSERT INTO vetboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('practitioner_type','3','1024','352','');
INSERT INTO vetboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('phonecall_status','3','1024','512','');
INSERT INTO vetboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('marital_status','3','1024','664','');
INSERT INTO vetboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('insurance_type','3','1024','800','');
INSERT INTO vetboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('event_status','3','1024','936','');
INSERT INTO vetboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('client_office_map','3','1096','30','');
INSERT INTO vetboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('calendar_event_type','3','1096','193','');
INSERT INTO vetboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('calendar_event_characteristic','3','1096','369','');
INSERT INTO vetboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('client_type','3','344','542','');
INSERT INTO vetboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('promo_code','3','368','754','ccff66');


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



INSERT INTO vetboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('1','tf_relation','','relation_type_id','tf_relation_type','relation_type_id','0','','0');
INSERT INTO vetboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('2','phone_call','','call_type_id','call_type','call_type_id','0','','0');
INSERT INTO vetboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('3','tf_dbmap_table','','dbmap_id','tf_dbmap','dbmap_id','0','','0');
INSERT INTO vetboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('4','personal_calendar_event','','office_user_id','user','user_id','0','','0');
INSERT INTO vetboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('5','personal_calendar_event','','patient_user_id','user','user_id','0','','0');
INSERT INTO vetboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('6','personal_calendar_event','','practitioner_id','practitioner','practitioner_id','0','office_id=$office_id','0');
INSERT INTO vetboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('7','user_office_map','','office_user_id','user','user_id','0','','0');
INSERT INTO vetboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('8','user_office_map','','patient_user_id','user','user_id','0','','0');
INSERT INTO vetboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('9','practitioner','','office_user_id','user','user_id','0','','0');
INSERT INTO vetboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('10','practitioner','','practitioner_type_id','practitioner_type','practitioner_type_id','0','','0');
INSERT INTO vetboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('13','personal_calendar_event','','event_status_id','event_status','event_status_id','0','','0');
INSERT INTO vetboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('14','personal_calendar_event','firstname lastname','client_id','client','client_id','0','join vetboxx.client_office_map m on m.client_id=a.client_id WHERE m.office_id=$office_id','0');
INSERT INTO vetboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('15','personal_calendar_event','','office_id','office','office_id','0','','0');
INSERT INTO vetboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('16','client','','insurance1_type_id','insurance_type','insurance_type_id','0','','0');
INSERT INTO vetboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('17','client','','insurance2_type_id','insurance_type','insurance_type_id','0','','0');
INSERT INTO vetboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('18','client','','marital_status','marital_status','marital_status_id','0','','0');
INSERT INTO vetboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('19','client_office_map','office_name','office_id','office','office_id','0','','0');
INSERT INTO vetboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('20','client_office_map','firstname lastname','client_id','client','client_id','0','','0');
INSERT INTO vetboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('21','office','email','login_id','login','login_id','0','','0');
INSERT INTO vetboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('22','phone_call','','phonecall_status_id','phonecall_status','phonecall_status_id','0','','');
INSERT INTO vetboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('23','practitioner','','office_id','office','office_id','0','','');
INSERT INTO vetboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('24','client','','guardian_client_id','client','client_id','0','','');
INSERT INTO vetboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('25','client','state_name','state_code','state','code','0','','0');
INSERT INTO vetboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('26','client','','client_type_id','client_type','client_type_id','0','','');
INSERT INTO vetboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('27','promo_code','','promo_code_id','office','office_id','0','','');


CREATE TABLE `tf_relation_type` (
  `relation_type_id` int(11) NOT NULL default '0',
  `name` varchar(40) default NULL,
  PRIMARY KEY  (`relation_type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



INSERT INTO vetboxx.tf_relation_type(`relation_type_id`,`name`) VALUES('0','foreign-key relation');
INSERT INTO vetboxx.tf_relation_type(`relation_type_id`,`name`) VALUES('1','multi-table relation');
INSERT INTO vetboxx.tf_relation_type(`relation_type_id`,`name`) VALUES('2','default relation');
INSERT INTO vetboxx.tf_relation_type(`relation_type_id`,`name`) VALUES('3','pseudo-field relation');


CREATE TABLE `tf_scriptlog` (
  `scriptlog_id` int(11) NOT NULL auto_increment,
  `pre_script` text,
  `post_script` text,
  `type` varchar(10) default NULL,
  `time_executed` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`scriptlog_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;



INSERT INTO vetboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('1','CREATE TABLE `phonecall_status` (
`phonecall_status` int(11) NOT NULL auto_increment,
`status_name` varchar(50) default NULL,
PRIMARY KEY (`phonecall_status`)
)','','sql','2010-07-05 02:47:00');
INSERT INTO vetboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('2','SELECT cc.* from client c JOIN client cc ON c.guardian_client_id=c.client_id WHERE cc.client_id='37' ORDER BY lastname, firstname','','sql','2010-07-31 19:41:21');
INSERT INTO vetboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('3','SELECT cc.* from client c JOIN client cc ON c.guardian_client_id=cc.client_id WHERE cc.guardian_client_id='37' ORDER BY lastname, firstname','','sql','2010-07-31 19:42:17');
INSERT INTO vetboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('4','SELECT cc.* from vetboxx.client c JOIN vetboxx.client cc ON c.guardian_client_id=cc.client_id WHERE cc.guardian_client_id='37' ORDER BY lastname, firstname','','sql','2010-07-31 19:43:11');
INSERT INTO vetboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('5','SELECT * from vetboxx.client c JOIN vetboxx.client cc ON c.guardian_client_id=cc.client_id WHERE cc.guardian_client_id='37' ORDER BY lastname, firstname','','sql','2010-07-31 19:43:32');
INSERT INTO vetboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('6','SELECT cc.* from vetboxx.client c JOIN vetboxx.client cc ON c.guardian_client_id=cc.client_id WHERE cc.guardian_client_id='37' ORDER BY lastname, firstname','','sql','2010-07-31 19:43:41');
INSERT INTO vetboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('7','SELECT cc.client_id from vetboxx.client c JOIN vetboxx.client cc ON c.guardian_client_id=cc.client_id WHERE cc.guardian_client_id='37' ORDER BY lastname, firstname','','sql','2010-07-31 19:43:53');
INSERT INTO vetboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('8','SELECT cc.client_id from vetboxx.client c JOIN vetboxx.client cc ON c.guardian_client_id=cc.client_id WHERE cc.guardian_client_id='37' ORDER BY cc.lastname, cc.firstname','','sql','2010-07-31 19:44:05');
INSERT INTO vetboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('9','select * from personal_calendar_event where calendar_event_id=46','','sql','2010-08-01 22:49:08');
INSERT INTO vetboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('10','select * from personal_calendar_event where calendar_event_id=206','','sql','2010-08-01 22:49:24');
INSERT INTO vetboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('11','SELECT * FROM vetboxx.client a JOIN client_office_map m on m.client_id=a.client_id WHERE m.office_id=8 ORDER BY lastname','','sql','2010-08-01 22:52:25');
INSERT INTO vetboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('12','UPDATE vetboxx.personal_calendar_event SET `datecode`='100805',`time`='11:30',`duration`='60',`client_id`='41',`practitioner_id`='109',`office_id`='8',`notes`='',`event_status_id`='1',`no_phone`='' WHERE `calendar_event_id`='206'','','sql','2010-08-01 23:00:25');
INSERT INTO vetboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('13','UPDATE vetboxx.personal_calendar_event SET `datecode`='100805',`time`='11:30',`duration`='61',`client_id`='41',`practitioner_id`='109',`office_id`='8',`notes`='',`event_status_id`='1',`no_phone`='' WHERE `calendar_event_id`='206'','','sql','2010-08-01 23:01:16');
INSERT INTO vetboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('14','INSERT INTO vetboxx.phone_call(`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`email_content`,`email_sent`,`phonecall_status_id`,`office_id`,`callee_id`,`expiry_date`,`calendar_event_id`,`phonecall_only`,`email_only`,`reminder_type`) VALUES('917604575','-5','This is a call from Harry's Dog Emporium reminding you of Georgez appointment for 11:30 am on Thursday August 5th. If you have any questions please call . Thank you.','2010-08-04 00:05:00','1','0','Dear tom terrific, This is a message from Harry's Dog Emporium reminding you of George's appointment for 11:30 am on Thursday August 5th with Dr. Bite. If you have any questions please call . If you expect to make this appointment, click this link: http://vetboxx.com/response.php?x_eq=Dz-hS9GR9-POC-WKW-SUWbNW If you would like us to call you, click this link: http://vetboxx.com/response.php?x_eq=QRp4O9-EM-J-JVp-TXMoc-dbNW If you would like to cancel this appointment, click this link: http://vetboxx.com/response.php?x_eq=4M9uL9bO9LXp-TdCbNW Thank you. Harry's Dog Emporium DEBUGGING: time to call or email:2010-08-04 00:05:00 time of appointment:2010-08-05 11:30:00 This is supposed to have come 2 days before the appointment. The Event ID for this is: 206','0','1','8','41','2010-08-05 11:30:00','206','0','1','2')','','sql','2010-08-01 23:02:42');
INSERT INTO vetboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('15','INSERT INTO vetboxx.phone_call(`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`email_content`,`email_sent`,`phonecall_status_id`,`office_id`,`callee_id`,`expiry_date`,`calendar_event_id`,`phonecall_only`,`email_only`,`reminder_type`) VALUES('917604575','-5','This is a call from Harry's Dog Emporium reminding you of Georgez appointment for 11:30 am on Thursday August 5th. If you have any questions please call . Thank you.','2010-08-04 00:11:00','1','0','Dear tom terrific, This is a message from Harry's Dog Emporium reminding you of George's appointment for 11:30 am on Thursday August 5th with Dr. Bite. If you have any questions please call . If you expect to make this appointment, click this link: http://vetboxx.com/response.php?x_eq=Dz-hS9GR9-POC-WKW-SUWbNW If you would like us to call you, click this link: http://vetboxx.com/response.php?x_eq=QRp4O9-EM-J-JVp-TXMoc-dbNW If you would like to cancel this appointment, click this link: http://vetboxx.com/response.php?x_eq=4M9uL9bO9LXp-TdCbNW Thank you. Harry's Dog Emporium DEBUGGING: time to call or email:2010-08-04 00:11:00 time of appointment:2010-08-05 11:30:00 This is supposed to have come 2 days before the appointment. The Event ID for this is: 206','0','1','8','41','2010-08-05 11:30:00','206','0','1','2')','','sql','2010-08-01 23:07:01');
INSERT INTO vetboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('16','INSERT INTO vetboxx.phone_call(`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`email_content`,`email_sent`,`phonecall_status_id`,`office_id`,`callee_id`,`expiry_date`,`calendar_event_id`,`phonecall_only`,`email_only`,`reminder_type`) VALUES('917604575','-5','This is a call from Harry's Dog Emporium reminding you of Georgez appointment for 11:30 am on Thursday August 5th. If you have any questions please call . Thank you.','2010-08-04 00:06:00','1','0','Dear tom terrific, This is a message from Harry's Dog Emporium reminding you of George's appointment for 11:30 am on Thursday August 5th with Dr. Bite. If you have any questions please call . If you expect to make this appointment, click this link: http://vetboxx.com/response.php?x_eq=Dz-hS9GR9-POC-WKW-SUWbNW If you would like us to call you, click this link: http://vetboxx.com/response.php?x_eq=QRp4O9-EM-J-JVp-TXMoc-dbNW If you would like to cancel this appointment, click this link: http://vetboxx.com/response.php?x_eq=4M9uL9bO9LXp-TdCbNW Thank you. Harry's Dog Emporium DEBUGGING: time to call or email:2010-08-04 00:06:00 time of appointment:2010-08-05 11:30:00 This is supposed to have come 2 days before the appointment. The Event ID for this is: 206','0','1','8','41','2010-08-05 11:30:00','206','0','1','2')','','sql','2010-08-02 00:51:12');
INSERT INTO vetboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('17','CREATE TABLE `promo_code` (
`promo_code_id` int(11) NOT NULL auto_increment,
`code` varchar(50) default NULL,
`office_id` int(11) default NULL,
PRIMARY KEY (`promo_code_id`)
)','','sql','2010-08-04 18:22:34');


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



INSERT INTO vetboxx.timezone(`timezone_id`,`timezone_name`,`dif_from_GMT`) VALUES('1','Greenwich Mean Time','0');
INSERT INTO vetboxx.timezone(`timezone_id`,`timezone_name`,`dif_from_GMT`) VALUES('2','Central African Time','-1');
INSERT INTO vetboxx.timezone(`timezone_id`,`timezone_name`,`dif_from_GMT`) VALUES('3','South Atlantic Time','-2');
INSERT INTO vetboxx.timezone(`timezone_id`,`timezone_name`,`dif_from_GMT`) VALUES('4','Brazil Eastern Time','-3');
INSERT INTO vetboxx.timezone(`timezone_id`,`timezone_name`,`dif_from_GMT`) VALUES('5','Newfoundland Time','-3.5');
INSERT INTO vetboxx.timezone(`timezone_id`,`timezone_name`,`dif_from_GMT`) VALUES('6','Atlantic Time','-4');
INSERT INTO vetboxx.timezone(`timezone_id`,`timezone_name`,`dif_from_GMT`) VALUES('7','Eastern North American Time','-5');
INSERT INTO vetboxx.timezone(`timezone_id`,`timezone_name`,`dif_from_GMT`) VALUES('8','Central North American Time','-6');
INSERT INTO vetboxx.timezone(`timezone_id`,`timezone_name`,`dif_from_GMT`) VALUES('9','Mountain North American Time','-7');
INSERT INTO vetboxx.timezone(`timezone_id`,`timezone_name`,`dif_from_GMT`) VALUES('10','Pacific North American Time','-8');
INSERT INTO vetboxx.timezone(`timezone_id`,`timezone_name`,`dif_from_GMT`) VALUES('11','Alaska Time','-9');
INSERT INTO vetboxx.timezone(`timezone_id`,`timezone_name`,`dif_from_GMT`) VALUES('12','Hawaii Time','-10');
INSERT INTO vetboxx.timezone(`timezone_id`,`timezone_name`,`dif_from_GMT`) VALUES('13','Midway Islands Time','-11');
INSERT INTO vetboxx.timezone(`timezone_id`,`timezone_name`,`dif_from_GMT`) VALUES('14','New Zealand Time','12');
INSERT INTO vetboxx.timezone(`timezone_id`,`timezone_name`,`dif_from_GMT`) VALUES('15','Solomon Time','11');
INSERT INTO vetboxx.timezone(`timezone_id`,`timezone_name`,`dif_from_GMT`) VALUES('16','Australia Eastern','10');
INSERT INTO vetboxx.timezone(`timezone_id`,`timezone_name`,`dif_from_GMT`) VALUES('17','Australia Central','9.5');

