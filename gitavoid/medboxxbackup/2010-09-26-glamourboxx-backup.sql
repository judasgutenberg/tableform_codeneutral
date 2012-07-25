

CREATE TABLE `calendar` (
  `calendar_id` int(4) NOT NULL auto_increment,
  `calendar_name` varchar(50) default NULL,
  `description` text,
  `foreign_table_name` varchar(30) default NULL,
  `calendar_range_id` int(4) default NULL,
  `code` varchar(80) default NULL,
  PRIMARY KEY  (`calendar_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;



INSERT INTO glamourboxx.calendar(`calendar_id`,`calendar_name`,`description`,`foreign_table_name`,`calendar_range_id`,`code`) VALUES('1','mascker voopp','moo','calendar','0','');
INSERT INTO glamourboxx.calendar(`calendar_id`,`calendar_name`,`description`,`foreign_table_name`,`calendar_range_id`,`code`) VALUES('2','mascker voopp merkle','moo spabk','calendar','0','');


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



INSERT INTO glamourboxx.call_type(`call_type_id`,`description`,`attempt_frequency`,`attempt_window_length`,`local_call_time_span`) VALUES('1','nine to five all days','1','999','15:00-23:00');
INSERT INTO glamourboxx.call_type(`call_type_id`,`description`,`attempt_frequency`,`attempt_window_length`,`local_call_time_span`) VALUES('2','ten to five all days','360','1','10:00-17:00');
INSERT INTO glamourboxx.call_type(`call_type_id`,`description`,`attempt_frequency`,`attempt_window_length`,`local_call_time_span`) VALUES('3','five to six all days','360','1','17:00-18:00');
INSERT INTO glamourboxx.call_type(`call_type_id`,`description`,`attempt_frequency`,`attempt_window_length`,`local_call_time_span`) VALUES('4','testing','30','1','01:00-23:00');


CREATE TABLE `client` (
  `client_id` int(11) NOT NULL auto_increment,
  `login_id` int(11) default NULL,
  `guardian_client_id` int(11) default NULL,
  `name_of_guardian` varchar(111) default NULL,
  `firstname` varchar(50) default NULL,
  `lastname` varchar(50) default NULL,
  `client_type_id` int(11) default NULL,
  `description` varchar(50) default NULL,
  `weight` int(50) default NULL,
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
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;



INSERT INTO glamourboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('16','20','12','','Bonnie','Treadweller','0','','0','0000-00-00','122 Silver Parkway','Richardville','MA','00221','foop@pool.com','','','','','','','','0','','','0','','','','','','0','asdasd','','','1','2010-05-02 14:16:34','2010-05-02 14:16:34');
INSERT INTO glamourboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('15','19','0','','Fonda','Petapsco','0','','0','0000-00-00','122 Silver Parkway','Richardville','MA','00221','foop@pool.com','','','','','','','','0','','','0','','','','','','0','asdasd','','','1','2010-05-02 14:16:34','2010-05-02 14:16:34');
INSERT INTO glamourboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('14','18','0','','Jill','Smithers','0','','0','0000-00-00','122 Silver Parkway','Richardville','MA','00221','foop@pool.com','','','','','','','','0','','','0','','','','','','0','asdasd','','','1','2010-05-02 14:16:34','2010-05-02 14:16:34');
INSERT INTO glamourboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('13','17','0','','Henry','Moffat','0','','0','1999-11-30','122 Silver Parkway','Richardville','MA','00221','gus@asecular.com','18453401090','','','','','','','0','','','0','','','','','','0','asdasd','','','1','2010-05-02 14:16:34','2010-05-02 14:16:34');
INSERT INTO glamourboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('9','15','0','','George','McFargush','0','','0','1963-01-08','77 East Turncoat Lane','Hollywood','CA','97142','goop@asecular.com','4443334433','','','','','','','0','','','0','','','','','','0','sfsdfsdfdsf','','','1','2010-05-02 11:22:53','2010-05-02 11:22:53');
INSERT INTO glamourboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('12','16','0','','Reginald','Treadweller','0','','0','0000-00-00','122 Silver Parkway','Richardville','MA','00221','foop@pool.com','','','','','','','','0','','','0','','','','','','0','asdasd','','','1','2010-05-02 14:16:34','2010-05-02 14:16:34');
INSERT INTO glamourboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('17','0','0','','Valerie','Peters','0','','0','1966-03-04','22 Munich Heights Bypass','Flinders','WV','29112','','','','','','','','','0','','','0','','','','','','0','','','','1','0000-00-00 00:00:00','0000-00-00 00:00:00');
INSERT INTO glamourboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('18','0','12','','Sybil','Treadweller','0','','0','1989-02-06','422 Silver Parkway','Richardville','MA','00221','','','','','','','','','0','','','0','','','','','','0','','','','1','0000-00-00 00:00:00','0000-00-00 00:00:00');
INSERT INTO glamourboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('19','24','0','','anita','hayes','0','','0','0000-00-00','Feakle','Co. Clare','','','','','','','','','','','0','','','0','','','','','','0','','','','1','2010-05-10 12:17:58','2010-05-10 12:17:58');
INSERT INTO glamourboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('20','0','0','','Tom','','0','','0','1999-11-30','','','','','','','','','','','','','0','','','0','','','','','','0','','','','1','1970-01-01 00:00:00','1970-01-01 00:00:00');
INSERT INTO glamourboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('21','0','0','','Thomas','Hayes','0','','0','1953-11-26','Magherabaun','Feakle  Co. Clare, Ireland','','','tommyhaye@gmail.com','0876236292','','','','','','','0','','','0','','','','','','0','','','','1','1970-01-01 00:00:00','1970-01-01 00:00:00');
INSERT INTO glamourboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('22','0','0','','tommy ','hayes','0','','0','0000-00-00','','','','','','','','','','','','','0','','','0','','','','','','0','','','','1','0000-00-00 00:00:00','0000-00-00 00:00:00');
INSERT INTO glamourboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('23','0','0','','Randall','Walker','0','','0','1999-11-30','','','','','','','','','','','','','0','','','0','','','','','','0','','','','1','1970-01-01 00:00:00','1970-01-01 00:00:00');
INSERT INTO glamourboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('24','0','0','','Laura','Powell','0','','0','0000-00-00','','','','','','','','','','','','','0','','','0','','','','','','0','','','','1','0000-00-00 00:00:00','0000-00-00 00:00:00');
INSERT INTO glamourboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('25','0','0','','isaac','hayes','0','','0','0000-00-00','','','','','','','','','','','','','0','','','0','','','','','','0','','','','1','0000-00-00 00:00:00','0000-00-00 00:00:00');
INSERT INTO glamourboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('26','0','0','','Fredrick','Ulster','0','','0','1933-02-03','122 Silver Parkway','Silverton','FL','22112','','','','','','','','','0','','','0','','','','','','0','','','','1','0000-00-00 00:00:00','0000-00-00 00:00:00');
INSERT INTO glamourboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('27','0','0','','Manrick','Ulster','0','','0','1933-02-03','122 Silver Parkway','Silverton','FL','22112','','','','','','','','','0','','','0','','','','','','0','','','','1','0000-00-00 00:00:00','0000-00-00 00:00:00');
INSERT INTO glamourboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('28','0','0','','Jebbediah','Ecols','0','','0','1933-02-03','122 Silver Parkway','Silverton','FL','22112','','','','','','','','','0','','','0','','','','','','0','','','','1','1970-01-01 00:00:00','1970-01-01 00:00:00');
INSERT INTO glamourboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('29','0','0','','banrick','Ulster','0','','0','1933-02-03','122 Silver Parkway','Silverton','FL','22112','','','','','','','','','0','','','0','','','','','','0','','','','1','0000-00-00 00:00:00','0000-00-00 00:00:00');
INSERT INTO glamourboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('30','0','0','','Vanrick','Ulster','0','','0','1933-02-03','122 Silver Parkway','Silverton','FL','22112','','','','','','','','','0','','','0','','','','','','0','','','','1','0000-00-00 00:00:00','0000-00-00 00:00:00');
INSERT INTO glamourboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('31','0','0','','Vanrick','Ulster','0','','0','1933-02-03','122 Silver Parkway','Silverton','FL','22112','','','','','','','','','0','','','0','','','','','','0','','','','1','0000-00-00 00:00:00','0000-00-00 00:00:00');
INSERT INTO glamourboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('32','0','0','','Joeseph','Hayes','0','','0','1999-11-30','','','','','','','','','','','','','0','','','0','','','','','','0','','','','1','1970-01-01 00:00:00','1970-01-01 00:00:00');
INSERT INTO glamourboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('33','0','0','','Gioseppe','Hayes','0','','0','1999-11-30','','','','','','','','','','','','','0','','','0','','','','','','0','','','','1','1970-01-01 00:00:00','1970-01-01 00:00:00');
INSERT INTO glamourboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('34','0','0','','JoJo','Hayes','0','','0','1999-11-30','','','','','','','','','','','','','0','','','0','','','','','','0','','','','1','1970-01-01 00:00:00','1970-01-01 00:00:00');
INSERT INTO glamourboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('35','0','0','','Dennis','O','0','','0','1999-11-30','','','','','denniso2323@gmail.com','','9176504575','','','','','','0','','','0','','','','','','0','','','','1','0000-00-00 00:00:00','0000-00-00 00:00:00');
INSERT INTO glamourboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('36','0','0','','David','Spitler','0','','0','0000-00-00','','','','','denniso@standard-source.com','845 246 5599','','','','','','','0','','','0','','','','','','0','','','','1','0000-00-00 00:00:00','0000-00-00 00:00:00');
INSERT INTO glamourboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('37','0','0','','Florida','Slinker','0','','0','1915-01-04','22 Runcington Way','Goopler','IA','','','','','','','','','','0','','','0','','','','','','0','','','','1','0000-00-00 00:00:00','0000-00-00 00:00:00');
INSERT INTO glamourboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('38','0','0','','Fred ','Funk','0','','0','0000-00-00','','','','','denniso2323@gmail.com','','917 6504575','','','','','','0','','','0','','','','','','0','','','','1','0000-00-00 00:00:00','0000-00-00 00:00:00');
INSERT INTO glamourboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('39','0','0','','John','Claridge','0','','0','0000-00-00','','','','','denniso@standardsourcemedia.com','8452465599','','','','','','','0','','','0','','','','','','0','','','','1','0000-00-00 00:00:00','0000-00-00 00:00:00');
INSERT INTO glamourboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('40','49','0','','Rothington','Slitchel','0','','0','0000-00-00','4499 Widdle Lane','','','','mommer@slick.com','','','','','','','','0','','','0','','','','','','0','','','','1','2010-08-04 18:08:20','2010-08-04 18:08:20');
INSERT INTO glamourboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('41','','','','william','mocker','','','','0000-00-00','','','','','','','','','','','','','','','','','','','','','','','','','','1','','');
INSERT INTO glamourboxx.client(`client_id`,`login_id`,`guardian_client_id`,`name_of_guardian`,`firstname`,`lastname`,`client_type_id`,`description`,`weight`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`is_active`,`date_created`,`date_lastvisited`) VALUES('42','','','','gina','test','','','','0000-00-00','','','','','','','','','','','','','','','','','','','','','','','','','','1','','');


CREATE TABLE `client_office_map` (
  `office_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  PRIMARY KEY  (`office_id`,`client_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('0','0');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('0','34');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('0','35');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('0','37');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('1','0');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('1','7');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('1','8');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('1','9');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('1','10');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('1','11');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('1','12');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('1','13');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('1','14');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('1','15');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('1','16');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('1','17');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('1','18');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('1','19');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('1','20');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('1','21');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('1','23');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('1','24');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('1','26');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('1','27');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('1','28');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('1','30');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('1','31');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('1','35');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('1','36');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('1','38');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('1','39');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('1','40');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('1','43');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('1','44');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('1','45');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('1','56');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('1','57');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('1','58');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('5','32');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('5','33');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('5','34');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('6','31');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('7','21');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('12','37');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('13','38');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('13','39');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('18','41');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('18','42');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('23','20');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('23','22');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('23','25');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('26','26');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('26','27');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('26','28');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('26','29');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('52','53');
INSERT INTO glamourboxx.client_office_map(`office_id`,`client_id`) VALUES('52','54');


CREATE TABLE `client_type` (
  `client_type_id` int(11) NOT NULL auto_increment,
  `client_description` varchar(122) default NULL,
  PRIMARY KEY  (`client_type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;



INSERT INTO glamourboxx.client_type(`client_type_id`,`client_description`) VALUES('1','human patient');
INSERT INTO glamourboxx.client_type(`client_type_id`,`client_description`) VALUES('2','dog');
INSERT INTO glamourboxx.client_type(`client_type_id`,`client_description`) VALUES('3','cat');
INSERT INTO glamourboxx.client_type(`client_type_id`,`client_description`) VALUES('4','snake');
INSERT INTO glamourboxx.client_type(`client_type_id`,`client_description`) VALUES('5','bird');
INSERT INTO glamourboxx.client_type(`client_type_id`,`client_description`) VALUES('6','turtle');
INSERT INTO glamourboxx.client_type(`client_type_id`,`client_description`) VALUES('7','lizard');
INSERT INTO glamourboxx.client_type(`client_type_id`,`client_description`) VALUES('8','ferret');
INSERT INTO glamourboxx.client_type(`client_type_id`,`client_description`) VALUES('9','horse');
INSERT INTO glamourboxx.client_type(`client_type_id`,`client_description`) VALUES('10','pig');
INSERT INTO glamourboxx.client_type(`client_type_id`,`client_description`) VALUES('11','other farm animal');
INSERT INTO glamourboxx.client_type(`client_type_id`,`client_description`) VALUES('12','other rodent');
INSERT INTO glamourboxx.client_type(`client_type_id`,`client_description`) VALUES('13','other mammal');
INSERT INTO glamourboxx.client_type(`client_type_id`,`client_description`) VALUES('14','other reptile');
INSERT INTO glamourboxx.client_type(`client_type_id`,`client_description`) VALUES('15','invertebrate');
INSERT INTO glamourboxx.client_type(`client_type_id`,`client_description`) VALUES('16','other organism');


CREATE TABLE `content` (
  `content_id` int(11) NOT NULL auto_increment,
  `name` varchar(50) default NULL,
  `content` text,
  `icon_filename` varchar(50) default NULL,
  PRIMARY KEY  (`content_id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;



INSERT INTO glamourboxx.content(`content_id`,`name`,`content`,`icon_filename`) VALUES('1','termsofuse',' MEDBOXX.COM TERMS OF USE


1. ACCEPTANCE OF TERMS

MEDBOXX.COM provides a collection of online and offline services &#40;referred to hereafter as "the 
Service"&#41; subject to the following Terms of Use &#40;"TOU"&#41;. By using the Service 
in any way, you are agreeing to comply with the TOU. In addition, when using 
particular MEDBOXX.COM services, you agree to abide by any applicable posted 
guidelines for all MEDBOXX.COM services, which may change from time to time.  
Should you object to any term or condition of the TOU, any guidelines, 
or any subsequent modifications thereto or become dissatisfied with MEDBOXX.COM 
in any way, your only recourse is to immediately discontinue use of MEDBOXX.COM.  
MEDBOXX.COM has the right, but is not obligated, to strictly enforce the TOU 
through self-help, community moderation, active investigation, litigation and 
prosecution.


2. MODIFICATIONS TO THIS AGREEMENT

We reserve the right, at our sole discretion, to change, modify or otherwise 
alter these terms and conditions at any time.  Such modifications shall become 
effective immediately upon the posting thereof. You must review this agreement 
on a regular basis to keep yourself apprised of any changes. You can find the 
most recent version of the TOU at:

http://www.medboxx.com/info.php?page_key=termsofuse


3. CONTENT

You understand that all postings, messages, text, files, images, photos, 
video, sounds, or other materials &#40;"Content"&#41; posted on, transmitted 
through, or linked from the Service, are the sole responsibility of the 
person from whom such Content originated. More specifically, you are 
entirely responsible for each individual item &#40;"Item"&#41; of Content that you 
post, email or otherwise make available via the Service. You understand that 
MEDBOXX.COM does not control, and is not responsible for Content made available 
through the Service, and that by using the Service, you may be exposed to 
Content that is offensive, indecent, inaccurate, misleading, or otherwise 
objectionable. Furthermore, the MEDBOXX.COM site and Content available through 
the Service may contain links to other websites, which are completely 
independent of MEDBOXX.COM .  MEDBOXX.COM makes no representation or warranty as 
to the accuracy, completeness or authenticity of the information contained 
in any such site.  Your linking to any other webites is at your own risk. 
You agree that you must evaluate, and bear all risks associated with, the 
use of any Content, that you may not rely on said Content, and that under no 
circumstances will MEDBOXX.COM be liable in any way for any Content or for 
any loss or damage of any kind incurred as a result of the use of any Content 
posted, emailed or otherwise made available via the Service. You acknowledge 
that MEDBOXX.COM does not pre-screen or approve Content, but that MEDBOXX.COM 
shall have the right &#40;but not the obligation&#41; in its sole discretion to 
refuse, delete or move any Content that is available via the Service, for 
violating the letter or spirit of the TOU or for any other reason.


4. THIRD PARTY CONTENT, SITES, AND SERVICES

The MEDBOXX.COM site and Content available through the Service may contain 
features and functionalities that may link you or provide you with access 
to third party content which is completely independent of MEDBOXX.COM , 
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

You agree that MEDBOXX.COM shall not be responsible or liable for any loss or 
damage of any sort incurred as the result of any such dealings. If there is 
a dispute between participants on this site, or between users and any third 
party, you understand and agree that MEDBOXX.COM is under no obligation to 
become involved. In the event that you have a dispute with one or more other 
users, you hereby release MEDBOXX.COM , its officers, employees, agents and 
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
otherwise violated, please notify MEDBOXX.COM&#39;s agent for notice of claims of 
copyright or other intellectual property infringement &#40;"Agent"&#41;, at

abuse@MEDBOXX.COM.org

or:

Copyright Agent
MEDBOXX.COM 
3 Medboxx Tower
New York, NY
10012

Please provide our Agent with the following Notice:

a&#41; Identify the material on the MEDBOXX.COM  site that you claim is 
infringing, with enough detail so that we may locate it on the website;

b&#41; A statement by you that you have a good faith belief that the disputed 
use is not authorized by the copyright owner, its agent, or the law;

c&#41; A statement by you declaring under penalty of perjury that &#40;1&#41; the above 
information in your Notice is accurate, and &#40;2&#41; that you are the owner of 
the copyright interest involved or that you are authorized to act on behalf 
of that owner;

d&#41; Your address, telephone number, and email address; and

e&#41; Your physical or electronic signature.

MEDBOXX.COM will remove the infringing posting&#40;s&#41;, subject to the the procedures 
outlined in the Digital Millenium Copyright Act &#40;DMCA&#41;.


6. PRIVACY AND INFORMATION DISCLOSURE

MEDBOXX.COM has established a Privacy Policy to explain to users how their 
information is collected and used, which is located at the following web 
address: 

http://www.medboxx.com/info.php?page_key=privacypolicy

Your use of the MEDBOXX.COM website or the Service signifies acknowledgement of 
and agreement to our Privacy Policy. You further acknowledge and agree that 
MEDBOXX.COM may, in its sole discretion, preserve or disclose your Content, 
as well as your information, such as email addresses, IP addresses, timestamps, 
and other user information, if required to do so by law or in the good faith 
belief that such preservation or disclosure is reasonably necessary to: 
comply with legal process; enforce the TOU; respond to claims that any 
Content violates the rights of third-parties; respond to claims that contact 
information &#40;e.g. phone number, street address&#41; of a third-party has been 
posted or transmitted without their consent or as a form of harassment; 
protect the rights, property, or personal safety of MEDBOXX.COM, its users or 
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
MEDBOXX.COM employee, or falsely states or otherwise misrepresents your 
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
posted in areas of the MEDBOXX.COM sites which are not designated for such 
purposes; or emailed to MEDBOXX.COM users who have not indicated in writing that 
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
permitted by MEDBOXX.COM;

u&#41; post non-local or otherwise irrelevant Content, repeatedly post the 
same or similar Content or otherwise impose an unreasonable or 
disproportionately large load on our infrastructure;

v&#41; post the same item or service in more than one classified category or 
forum, or in more than one metropolitan area;

w&#41; attempt to gain unauthorized access to MEDBOXX.COM&#39;s computer systems or 
engage in any activity that disrupts, diminishes the quality of, interferes 
with the performance of, or impairs the functionality of, the Service or 
the MEDBOXX.COM website; or

x&#41; use any form of automated device or computer program that enables the 
submission of postings on MEDBOXX.COM without each posting being manually 
entered by the author thereof &#40;an "automated posting device"&#41;, including 
without limitation, the use of any such automated posting device to submit 
postings in bulk, or for automatic submission of postings at regular intervals.

y&#41; use any form of automated device or computer program &#40;"flagging tool"&#41;
that enables the use of MEDBOXX.COM&#39;s "flagging system" or other community
moderation systems without each flag being manually entered by the person
that initiates the flag &#40;an "automated flagging device"&#41;, or use the
flagging tool to remove posts of competitors, or to remove posts without a
good faith belief that the post being flagged violates these TOU;

8. POSTING AGENTS

A "Posting Agent" is a third-party agent, service, or intermediary
that offers to post Content to the Service on behalf of others. To 
moderate demands on MEDBOXX.COM&#39;s resources, you may not use a Posting 
Agent to post Content to the Service without express permission or 
license from MEDBOXX.COM.  Correspondingly, Posting Agents are not 
permitted to post Content on behalf of others, to cause Content to 
be so posted, or otherwise access the Service to facilitate posting 
Content on behalf of others, except with express permission or 
license from MEDBOXX.COM.


9. NO SPAM POLICY

You understand and agree that sending unsolicited email advertisements to 
MEDBOXX.COMemail addresses or through MEDBOXX.COM computer systems, which is 
expressly prohibited by these Terms, will use or cause to be used servers 
located in California.  Any unauthorized use of  MEDBOXX.COM computer systems 
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

You acknowledge that MEDBOXX.COM may establish limits concerning use of the 
Service, including the maximum number of days that Content will be retained 
by the Service, the maximum number and size of postings, email messages, or 
other Content that may be transmitted or stored by the Service, and the 
frequency with which you may access the Service. You agree that MEDBOXX.COM 
has no responsibility or liability for the deletion or failure to store any 
Content maintained or transmitted by the Service. You acknowledge that 
MEDBOXX.COM reserves the right at any time to modify or discontinue the 
Service &#40;or any part thereof&#41; with or without notice, and that MEDBOXX.COM 
shall not be liable to you or to any third party for any modification, 
suspension or discontinuance of the Service.


12. ACCESS TO THE SERVICE

MEDBOXX.COM grants you a limited, revocable, nonexclusive license to access 
the Service for your own personal use.  This license does not include: 
&#40;a&#41; access to the Service by Posting Agents; or &#40;b&#41; any collection, 
aggregation, copying, duplication, display or derivative use of the Service 
nor any use of data mining, robots, spiders, or similar data gathering and 
extraction tools for any purpose unless expressly permitted by MEDBOXX.COM. 
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

MEDBOXX.COM permits you to display on your website, or create a hyperlink 
on your website to, individual postings on the Service so long as such use 
is for noncommercial and/or news reporting purposes only &#40;e.g., for use in 
personal web blogs or personal online media&#41;.  If the total number of such 
postings displayed or linked to on your website exceeds one hundred &#40;100&#41; 
postings, your use will be presumed to be in violation of the TOU, 
absent express permission granted by MEDBOXX.COM to do so.  You may also 
create a hyperlink to the home page of MEDBOXX.COM sites so long as the 
link does not portray MEDBOXX.COM, its employees, or its affiliates in a 
false, misleading, derogatory, or otherwise offensive matter.

MEDBOXX.COM offers various parts of the Service in RSS format so that users 
can embed individual feeds into a personal website or blog, or view postings 
through third party software news aggregators.  MEDBOXX.COM permits you to 
display, excerpt from, and link to the RSS feeds on your personal website 
or personal web blog, provided that &#40;a&#41; your use of the RSS feed is for 
personal, non-commercial purposes only, &#40;b&#41; each title is correctly linked 
back to the original post on the Service and redirects the user to the 
post when the user clicks on it, &#40;c&#41; you provide, adjacent to the RSS 
feed, proper attribution to &#39;MEDBOXX.COM&#39; as the source, &#40;d&#41; your use or 
display does not suggest that MEDBOXX.COM promotes or endorses any third 
party causes, ideas, web sites, products or services, &#40;e&#41; you do not 
redistribute the RSS feed, and &#40;f&#41; your use does not overburden 
MEDBOXX.COM&#39;s systems.  MEDBOXX.COM reserves all rights in the content of 
the RSS feeds and may terminate any RSS feed at any time.

Use of the Service beyond the scope of authorized access granted to you by 
MEDBOXX.COM immediately terminates said permission or license.  In order to 
collect, aggregate, copy, duplicate, display or make derivative use of the 
the Service or any Content made available via the Service for other 
purposes &#40;including commercial purposes&#41; not stated herein, you must first 
obtain a license from MEDBOXX.COM.


13. TERMINATION OF SERVICE

You agree that MEDBOXX.COM, in its sole discretion, has the right &#40;but not 
the obligation&#41; to delete or deactivate your account, block your email or IP 
address, or otherwise terminate your access to or use of the Service &#40;or any 
part thereof&#41;, immediately and without notice, and remove and discard any 
Content within the Service, for any reason, including, without limitation, 
if MEDBOXX.COM believes that you have acted inconsistently with the letter or 
spirit of the TOU. Further, you agree that MEDBOXX.COM shall not be liable 
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
written consent of MEDBOXX.COM. You further agree not to reproduce, 
duplicate or copy Content from the Service without the express written 
consent of MEDBOXX.COM, and agree to abide by any and all copyright notices 
displayed on the Service. You may not decompile or disassemble, reverse 
engineer or otherwise attempt to discover any source code contained in the 
Service. Without limiting the foregoing, you agree not to reproduce, 
duplicate, copy, sell, resell or exploit for any commercial purposes, any 
aspect of the Service. MEDBOXX.COM is a registered mark in the U.S. Patent 
and Trademark Office.

Although MEDBOXX.COM does not claim ownership of content that its users post, 
by posting Content to any public area of the Service, you automatically 
grant, and you represent and warrant that you have the right to grant, to 
MEDBOXX.COM an irrevocable, perpetual, non-exclusive, fully paid, worldwide 
license to use, copy, perform, display, and distribute said Content and to 
prepare derivative works of, or incorporate into other works, said Content, 
and to grant and authorize sublicenses &#40;through multiple tiers&#41; of the 
foregoing. Furthermore, by posting Content to any public area of the Service, 
you automatically grant MEDBOXX.COM all rights necessary to prohibit any 
subsequent aggregation, display, copying, duplication, reproduction, or 
exploitation of the Content on the Service by any party for any purpose.


15. DISCLAIMER OF WARRANTIES

YOU AGREE THAT USE OF THE MEDBOXX.COM SITE AND THE SERVICE IS ENTIRELY AT 
YOUR OWN RISK. THE MEDBOXX.COM SITE AND THE SERVICE ARE PROVIDED ON AN "AS 
IS" OR "AS AVAILABLE" BASIS, WITHOUT ANY WARRANTIES OF ANY KIND.  ALL 
EXPRESS AND IMPLIED WARRANTIES, INCLUDING, WITHOUT LIMITATION, THE 
WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE, AND 
NON-INFRINGEMENT OF PROPRIETARY RIGHTS ARE EXPRESSLY DISCLAIMED TO THE 
FULLEST EXTENT PERMITTED BY LAW.  TO THE FULLEST EXTENT PERMITTED BY LAW, 
MEDBOXX.COM DISCLAIMS ANY WARRANTIES FOR THE SECURITY, RELIABILITY, 
TIMELINESS, ACCURACY, AND PERFORMANCE OF THE MEDBOXX.COM SITE AND THE 
SERVICE.  TO THE FULLEST EXTENT PERMITTED BY LAW, MEDBOXX.COM DISCLAIMS ANY 
WARRANTIES FOR OTHER SERVICES OR GOODS RECEIVED THROUGH OR ADVERTISED ON THE 
MEDBOXX.COM SITE OR THE SITES OR SERVICE, OR ACCESSED THROUGH ANY LINKS ON 
THE MEDBOXX.COM SITE.  TO THE FULLEST EXTENT PERMITTED BY LAW, MEDBOXX.COM 
DISCLAIMS ANY WARRANTIES FOR VIRUSES OR OTHER HARMFUL COMPONENTS IN 
CONNECTION WITH THE MEDBOXX.COM SITE OR THE SERVICE.  Some jurisdictions do 
not allow the disclaimer of implied warranties.  In such jurisdictions, some 
of the foregoing disclaimers may not apply to you insofar as they relate to 
implied warranties.


16. LIMITATIONS OF LIABILITY

UNDER NO CIRCUMSTANCES SHALL MEDBOXX.COM BE LIABLE FOR DIRECT, INDIRECT, 
INCIDENTAL, SPECIAL, CONSEQUENTIAL OR EXEMPLARY DAMAGES &#40;EVEN IF MEDBOXX.COM 
HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES&#41;, RESULTING FROM ANY 
ASPECT OF YOUR USE OF THE MEDBOXX.COM SITE OR THE SERVICE, WHETHER THE 
DAMAGES ARISE FROM USE OR MISUSE OF THE MEDBOXX.COM SITE OR THE SERVICE, FROM 
INABILITY TO USE THE MEDBOXX.COM SITE OR THE SERVICE, OR THE INTERRUPTION, 
SUSPENSION, MODIFICATION, ALTERATION, OR TERMINATION OF THE MEDBOXX.COM SITE 
OR THE SERVICE.  SUCH LIMITATION SHALL ALSO APPLY WITH RESPECT TO DAMAGES 
INCURRED BY REASON OF OTHER SERVICES OR PRODUCTS RECEIVED THROUGH OR 
ADVERTISED IN CONNECTION WITH THE MEDBOXX.COM SITE OR THE SERVICE OR ANY 
LINKS ON THE MEDBOXX.COM SITE, AS WELL AS BY REASON OF ANY INFORMATION OR 
ADVICE RECEIVED THROUGH OR ADVERTISED IN CONNECTION WITH THE MEDBOXX.COM SITE 
OR THE SERVICE OR ANY LINKS ON THE MEDBOXX.COM SITE.  THESE LIMITATIONS SHALL 
APPLY TO THE FULLEST EXTENT PERMITTED BY LAW. In some jurisdictions, 
limitations of liability are not permitted.  In such jurisdictions, some of 
the foregoing limitation may not apply to you.


17. INDEMNITY

You agree to indemnify and hold MEDBOXX.COM, its officers, subsidiaries, 
affiliates, successors, assigns, directors, officers, agents, service 
providers, suppliers and employees, harmless from any claim or demand, 
including reasonable attorney fees and court costs, made by any third party 
due to or arising out of Content you submit, post or make available through 
the Service, your use of the Service, your violation of the TOU, your 
breach of any of the representations and warranties herein, or your 
violation of any rights of another.


18. GENERAL INFORMATION

The TOU constitute the entire agreement between you and MEDBOXX.COM and 
govern your use of the Service, superceding any prior agreements between you 
and MEDBOXX.COM. The TOU and the relationship between you and MEDBOXX.COM 
shall be governed by the laws of the State of California without regard to 
its conflict of law provisions. You and MEDBOXX.COM agree to submit to the 
personal and exclusive jurisdiction of the courts located within the county 
of San Francisco, California. The failure of MEDBOXX.COM to exercise or 
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

abuse@MEDBOXX.COM 

Our failure to act with respect to a breach by you or others does not waive our 
right to act with respect to subsequent or similar breaches.

You understand and agree that, because damages are often difficult to quantify, 
if it becomes necessary for MEDBOXX.COM to pursue legal action to enforce these 
Terms, you will be liable to pay MEDBOXX.COM the following amounts as liquidated 
damages, which you accept as reasonable estimates of MEDBOXX.COM&#39; damages for 
the specified breaches of these Terms:

a. If you post a message that &#40;1&#41; impersonates any person or entity; &#40;2&#41; 
falsely states or otherwise misrepresents your affiliation with a person or 
entity; or &#40;3&#41; that includes personal or identifying information about 
another person without that person&#39;s explicit consent, you agree to pay 
MEDBOXX.COM one thousand dollars &#40;$1,000&#41; for each such message.  
This provision does not apply to Content that constitutes lawful non-deceptive 
parody of public figures.

b. If MEDBOXX.COM establishes limits on the frequency with which you may 
access the Service, or terminates your access to or use of the Service, you 
agree to pay MEDBOXX.COM one hundred dollars &#40;$100&#41; for each message posted 
in excess of such limits or for each day on which you access MEDBOXX.COM in 
excess of such limits, whichever is higher.

c. If you send unsolicited email advertisements to MEDBOXX.COM email 
addresses or through MEDBOXX.COM computer systems, you agree to pay 
MEDBOXX.COM twenty five dollars &#40;$25&#41; for each such email.

d. If you post Content in violation of the TOU, other than as described 
above, you agree to pay MEDBOXX.COM one hundred dollars &#40;$100&#41; for each 
Item of Content posted.  In its sole discretion, MEDBOXX.COM may elect 
to issue a warning before assessing damages.

e. If you are a Posting Agent that uses the Service in violation of the
TOU, in addition to any liquidated damages under clause &#40;d&#41;, you agree to
pay MEDBOXX.COM one hundred dollars &#40;$100&#41; for each and every Item you post
in violation of the TOU.  A Posting Agent will also be deemed an agent of
the party engaging the Posting Agent to access the Service &#40;the
"Principal"&#41;, and the Principal &#40;by engaging the Posting Agent in
violation of the TOU&#41; agrees to pay MEDBOXX.COM an additional one hundred
dollars &#40;$100&#41; for each Item posted by the Posting Agent on behalf of
the Principal in violation of the TOU.

f. If you aggregate, display, copy, duplicate, reproduce, or otherwise 
exploit for any purpose any Content &#40;except for your own Content&#41; in 
violation of these Terms without MEDBOXX.COM&#39;s express written permission, 
you agree to pay MEDBOXX.COM three thousand dollars &#40;$3,000&#41; for each day 
on which you engage in such conduct.

Otherwise, you agree to pay MEDBOXX.COM&#39;s actual damages, to the extent such 
actual damages can be reasonably calculated. Notwithstanding any other 
provision of these Terms, MEDBOXX.COM retains the right to seek the remedy 
of specific performance of any term contained in these Terms, or a preliminary 
or permanent injunction against the breach of any such term or in aid of the 
exercise of any power granted in these Terms, or any combination thereof.


20. FEEDBACK

We welcome your questions and comments on this document in the MEDBOXX.COM 
feedback form:        

http://medboxx.com/contact.php 

','');
INSERT INTO glamourboxx.content(`content_id`,`name`,`content`,`icon_filename`) VALUES('3','privacypolicy','Your Privacy

MEDBOXX.COM is committed to protecting your privacy. We only use the information we collect about you to process orders and to provide support and upgrades for our products. Please read on for more details about our privacy policy.

What information do we collect? How do we use it?

When you order, we need to know your name, e-mail address, mailing address, credit card number, and expiration date. This allows us to process and fulfill your order and to notify you of your order status. When you enter a contest or other promotional feature, we may ask for your name, address, and e-mail address so we can administer the contest and notify winners.

How does MEDBOXX.COM protect customer information?

We use a Secure Server for collecting personal and credit card information. The secure server layer &#40;SSL&#41; encrypts &#40;scrambles&#41; all of the information you enter before it is transmitted over the interenet and sent to us. Furthermore, all of the customer data we collect is protected against unauthorized access.

What about "cookies"?

"Cookies" are small pieces of information that are stored by your browser on your computer&#39;s hard drive. We do not use cookies to collect or store any information about visitors or customers.

Will MEDBOXX.COM disclose the information it collects to outside parties?

MEDBOXX.COM does not sell, trade, or rent your personal information to others. MEDBOXX.COM may provide aggregate statistics about our customers, sales, traffic patterns, and related site information to reputable third-party vendors, but these statistics will not include personally identifying information.

MEDBOXX.COM may release account information when we believe, in good faith, that such release is reasonably necessary to &#40;i&#41; comply with law, &#40;ii&#41; enforce or apply the terms of any of our user agreements or &#40;iii&#41; protect the rights, property or safety of MEDBOXX.COM, our users, or others.

In Summary

MEDBOXX.COM is committed to protecting your privacy. We use the information we collect on the site to make shopping at SimpleJoe.com as simple as possible and to enhance your overall shopping experience. We do not sell, trade, or rent your personal information to others.

Your Consent

By using our Web site, you consent to the collection and use of this information by MEDBOXX.COM, Inc. If we decide to change our privacy policy, we will post those changes on this page so that you are always aware of what information we collect, how we use it, and under what circumstances we disclose it.

MEDBOXX.COM also provides links to affiliated sites. The privacy policies of these linked sites are the responsibliity of the linked site and MEDBOXX.COM has no control or influence over their policies. Please check the policies of each site you visit for specific information. MEDBOXX.COM cannot be held liable for damage or misdoings of other sites linked or otherwise.
','');
INSERT INTO glamourboxx.content(`content_id`,`name`,`content`,`icon_filename`) VALUES('2','homepage blurb','<div style="font-style: italic; font-size:1.5em; text-align:right; color:#9a5e99;font-weight:bold;">Appoint. Remind.</div><br />
Welcome to <strong><span style="color:#9a5e99;">Glamour</span>Boxx</strong>: your online appointment and reminder system. Eliminate guesswork while saving thousands of dollars a year in staff costs and time. Access your appointment book from any computer or smart phone, remind clients and customers of appointments without lifting a finger.
<br /><br /><strong><span style="color:#9a5e99;">Glamour</span>Boxx</strong> offers programs starting at just $49 per year per office. Take appointments and scheduling in the 21<small><sup>st</sup></small> century!','');
INSERT INTO glamourboxx.content(`content_id`,`name`,`content`,`icon_filename`) VALUES('4','jobs','Medboxx.com is hiring!

Currently we are looking for a phone system specialist. Must have 5+ years experience with Linux and at least a year&#39;s experience with Asterisk.','');
INSERT INTO glamourboxx.content(`content_id`,`name`,`content`,`icon_filename`) VALUES('5','support','Need support?  You&#39;re outta luck! We have no support staff at this time!','');
INSERT INTO glamourboxx.content(`content_id`,`name`,`content`,`icon_filename`) VALUES('6','whatwedo','Medboxx is a system for organizing your office reminder system. Blah blah.','');
INSERT INTO glamourboxx.content(`content_id`,`name`,`content`,`icon_filename`) VALUES('11','what-mb-does:patientreg','<strong>1. Patient Registration</strong>','patrientreg_icon.png');
INSERT INTO glamourboxx.content(`content_id`,`name`,`content`,`icon_filename`) VALUES('15','what-mb-does:infobox','','');
INSERT INTO glamourboxx.content(`content_id`,`name`,`content`,`icon_filename`) VALUES('16','what-mb-does:scheduling','1. <strong>Scheduling Appointments and Calendars</strong><br />
Finally you don't need to be at the office or shop to see your appointment calendar. GlamourBoxx takes appointment scheduling into the 21st century by allowing online, out-of-office appointment making and review by computer or smart phone. View up-to-the-minute appointments and calendars for the entire staff, wherever you are. Search easily for client or customer appointments, current and past, without randomly flipping through calendar pages. Our scheduling calendar even accepts multiple appointments for the same time for the same staff member or desk.','patrientrcal_icon.png');
INSERT INTO glamourboxx.content(`content_id`,`name`,`content`,`icon_filename`) VALUES('17','what-mb-does:patientreminders','2. <strong>Client and Customer Reminders</strong><br />
Take the hassle out of client and customer reminders. Let GlamourBoxx save you precious time and effort through our easily customized automated email and phone appointment reminders. For example, patients could receive 3 email reminders: 5 months before, 1 month before, 3 days before plus a phone call reminder the day before the appointment. Each reminder will give clients and customers one of three options: accept the appointment, request an office call to change the appointment, or cancel the appointment.','patrientrclock_icon.png');
INSERT INTO glamourboxx.content(`content_id`,`name`,`content`,`icon_filename`) VALUES('20','what-mb-does:top','How MedBoxx Supports Your Front Desk And Lowers Your Costs Dramatically','spacer.png');
INSERT INTO glamourboxx.content(`content_id`,`name`,`content`,`icon_filename`) VALUES('19','what-mb-does:bottombuttons','<table width=760 height=40>
<tr>
<td><a href=reg.php?x_mode=office><img src=images/signupfor.png border=0></a></td> 
<td><a href=reg.php?x_mode=office><img src=images/tryfree.png border=0></a></td>  
</tr>
</table>','');
INSERT INTO glamourboxx.content(`content_id`,`name`,`content`,`icon_filename`) VALUES('21','login not yet added office','Not yet  added your office to GlamourBoxx.com? [Register] to streamline your office work and automate your appointment reminders.','');
INSERT INTO glamourboxx.content(`content_id`,`name`,`content`,`icon_filename`) VALUES('22','login not yet added client','Not yet    added your client profile to Glamourboxx.com? [Register] to speed your office visits and receive appointment reminders.','');


CREATE TABLE `event_status` (
  `event_status_id` int(11) NOT NULL auto_increment,
  `status_name` varchar(50) default NULL,
  PRIMARY KEY  (`event_status_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;



INSERT INTO glamourboxx.event_status(`event_status_id`,`status_name`) VALUES('1','no response');
INSERT INTO glamourboxx.event_status(`event_status_id`,`status_name`) VALUES('2','yes');
INSERT INTO glamourboxx.event_status(`event_status_id`,`status_name`) VALUES('3','no');
INSERT INTO glamourboxx.event_status(`event_status_id`,`status_name`) VALUES('4','call');


CREATE TABLE `formlog` (
  `formlog_id` int(11) NOT NULL auto_increment,
  `time_done` timestamp NULL default NULL,
  `ip_address` varchar(33) default NULL,
  `referer` varchar(211) default NULL,
  `record_label` text,
  `form_content` text,
  `comments` text,
  PRIMARY KEY  (`formlog_id`)
) ENGINE=MyISAM AUTO_INCREMENT=170 DEFAULT CHARSET=latin1;



INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('1','2010-07-22 19:45:42','70.18.130.157','http://medboxx.com/messageform.php','actualphone','s:224:"json={"version":1,"data":[{"tag":"tester","phone":"19176504575","tts":"<voice name=&#39;Allison-8kHz&#39;>Hello, this is the office of Peterson medical reminding you of your appointment for tuesday June 22 at 10 AM</voice>"}]}|[115]";','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('2','2010-07-22 19:46:26','66.246.246.6','','postback','a:1:{s:4:"data";s:47:"{\"tag\":\"tester\",\"disposition\":\"CANCEL\"}";}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('3','2010-07-22 19:49:27','70.18.130.157','http://medboxx.com/messageform.php','actualphone','s:224:"json={"version":1,"data":[{"tag":"tester","phone":"18453401090","tts":"<voice name=&#39;Allison-8kHz&#39;>Hello, this is the office of Peterson medical reminding you of your appointment for tuesday June 22 at 10 AM</voice>"}]}|[116]";','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('4','2010-07-22 19:49:54','66.246.246.6','','postback','a:1:{s:4:"data";s:73:"{\"tag\":\"tester\",\"disposition\":\"ANSWERED\",\"vm\":0,\"duration\":9}";}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('5','2010-07-22 20:08:00','70.18.130.157','','actualphone','s:574:"json={"version":1,"data":[{"tag":"medboxx_box.146","phone":"19176504575","tts":"<voice name=&#39;William-8kHz&#39;>This is a call from Worthington Medical Facility reminding you of your appointment for 10:45 am on Friday July 23rd. If you have any questions please call 2221212212. Thank you.</voice>"},{"tag":"medboxx_box.150","phone":"18452465599","tts":"<voice name=&#39;William-8kHz&#39;>This is a call from Worthington Medical Facility reminding you of your appointment for 1:45 pm on Friday July 23rd. If you have any questions please call 2221212212. Thank you.</voice>"}]}|[117,118]";','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('6','2010-07-22 20:08:40','66.246.246.6','','postback','a:1:{s:4:"data";s:83:"{\"tag\":\"medboxx_box.150\",\"disposition\":\"ANSWERED\",\"vm\":0,\"duration\":16}";}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('7','2010-07-22 20:08:55','66.246.246.6','','postback','a:1:{s:4:"data";s:83:"{\"tag\":\"medboxx_box.146\",\"disposition\":\"ANSWERED\",\"vm\":1,\"duration\":33}";}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('8','2010-07-22 20:21:16','70.18.130.157','http://medboxx.com/caleditcell.php','daywaszero','a:5:{s:7:"eventid";i:256;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-07-28 15:15:00";s:10:"actualtime";s:19:"2010-07-22 20:21:16";s:1:"i";i:4;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('9','2010-07-22 20:21:16','70.18.130.157','http://medboxx.com/caleditcell.php','daywaszero','a:5:{s:7:"eventid";i:256;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-07-28 15:15:00";s:10:"actualtime";s:19:"2010-07-22 20:21:16";s:1:"i";i:5;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('10','2010-07-22 20:21:38','70.18.130.157','http://medboxx.com/caleditcell.php','daywaszero','a:5:{s:7:"eventid";i:257;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-07-28 15:12:00";s:10:"actualtime";s:19:"2010-07-22 20:21:38";s:1:"i";i:4;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('11','2010-07-22 20:21:38','70.18.130.157','http://medboxx.com/caleditcell.php','daywaszero','a:5:{s:7:"eventid";i:257;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-07-28 15:12:00";s:10:"actualtime";s:19:"2010-07-22 20:21:38";s:1:"i";i:5;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('12','2010-07-23 18:42:51','75.194.84.121','http://medboxx.com/caleditcell.php','daywaszero','a:5:{s:7:"eventid";i:258;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-01 15:05:00";s:10:"actualtime";s:19:"2010-07-23 18:42:51";s:1:"i";i:4;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('13','2010-07-23 18:42:51','75.194.84.121','http://medboxx.com/caleditcell.php','daywaszero','a:5:{s:7:"eventid";i:258;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-01 15:05:00";s:10:"actualtime";s:19:"2010-07-23 18:42:51";s:1:"i";i:5;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('14','2010-07-25 15:03:03','64.150.169.145','','actualphone','s:302:"json={"version":1,"data":[{"tag":"medboxx_box.162","phone":"19176504575","tts":"<voice name=&#39;William-8kHz&#39;>This is a call from Worthington Medical Facility reminding you of your appointment for 11:00 am on Monday July 26th. If you have any questions please call 2221212212. Thank you.</voice>"}]}|[119]";','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('15','2010-07-25 15:04:11','66.246.246.6','','postback','a:1:{s:4:"data";s:83:"{\"tag\":\"medboxx_box.162\",\"disposition\":\"ANSWERED\",\"vm\":1,\"duration\":33}";}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('16','2010-07-25 15:13:02','64.150.169.145','','actualphone','s:301:"json={"version":1,"data":[{"tag":"medboxx_box.158","phone":"18452465599","tts":"<voice name=&#39;William-8kHz&#39;>This is a call from Worthington Medical Facility reminding you of your appointment for 9:45 am on Monday July 26th. If you have any questions please call 2221212212. Thank you.</voice>"}]}|[120]";','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('17','2010-07-25 15:13:37','66.246.246.6','','postback','a:1:{s:4:"data";s:83:"{\"tag\":\"medboxx_box.158\",\"disposition\":\"ANSWERED\",\"vm\":0,\"duration\":16}";}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('18','2010-07-26 15:11:06','64.150.169.145','','actualphone','s:302:"json={"version":1,"data":[{"tag":"medboxx_box.170","phone":"18452465599","tts":"<voice name=&#39;William-8kHz&#39;>This is a call from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Tuesday July 27th. If you have any questions please call 2221212212. Thank you.</voice>"}]}|[121]";','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('19','2010-07-26 15:12:06','66.246.246.6','','postback','a:1:{s:4:"data";s:83:"{\"tag\":\"medboxx_box.170\",\"disposition\":\"ANSWERED\",\"vm\":1,\"duration\":23}";}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('20','2010-07-26 15:17:02','64.150.169.145','','actualphone','s:302:"json={"version":1,"data":[{"tag":"medboxx_box.174","phone":"19176504575","tts":"<voice name=&#39;William-8kHz&#39;>This is a call from Worthington Medical Facility reminding you of your appointment for 2:45 pm on Tuesday July 27th. If you have any questions please call 2221212212. Thank you.</voice>"}]}|[122]";','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('21','2010-07-26 15:17:55','66.246.246.6','','postback','a:1:{s:4:"data";s:83:"{\"tag\":\"medboxx_box.174\",\"disposition\":\"ANSWERED\",\"vm\":1,\"duration\":33}";}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('22','2010-07-27 15:05:03','64.150.169.145','','actualphone','s:304:"json={"version":1,"data":[{"tag":"medboxx_box.182","phone":"19176504575","tts":"<voice name=&#39;William-8kHz&#39;>This is a call from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Wednesday July 28th. If you have any questions please call 2221212212. Thank you.</voice>"}]}|[123]";','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('23','2010-07-27 15:05:55','66.246.246.6','','postback','a:1:{s:4:"data";s:83:"{\"tag\":\"medboxx_box.182\",\"disposition\":\"ANSWERED\",\"vm\":1,\"duration\":33}";}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('24','2010-07-27 15:07:03','64.150.169.145','','actualphone','s:304:"json={"version":1,"data":[{"tag":"medboxx_box.186","phone":"19176504575","tts":"<voice name=&#39;William-8kHz&#39;>This is a call from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Wednesday July 28th. If you have any questions please call 2221212212. Thank you.</voice>"}]}|[124]";','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('25','2010-07-27 15:08:02','66.246.246.6','','postback','a:1:{s:4:"data";s:83:"{\"tag\":\"medboxx_box.186\",\"disposition\":\"ANSWERED\",\"vm\":1,\"duration\":34}";}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('26','2010-07-27 15:17:02','64.150.169.145','','actualphone','s:304:"json={"version":1,"data":[{"tag":"medboxx_box.178","phone":"18452465599","tts":"<voice name=&#39;William-8kHz&#39;>This is a call from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Wednesday July 28th. If you have any questions please call 2221212212. Thank you.</voice>"}]}|[125]";','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('27','2010-07-27 15:18:10','66.246.246.6','','postback','a:1:{s:4:"data";s:83:"{\"tag\":\"medboxx_box.178\",\"disposition\":\"ANSWERED\",\"vm\":1,\"duration\":27}";}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('28','2010-07-28 15:01:03','64.150.169.145','','actualphone','s:293:"json={"version":1,"data":[{"tag":"medboxx_box.194","phone":"","tts":"<voice name=&#39;William-8kHz&#39;>This is a call from Worthington Medical Facility reminding you of your appointment for 11:15 am on Thursday July 29th. If you have any questions please call 2221212212. Thank you.</voice>"}]}|[126]";','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('29','2010-07-28 15:05:02','64.150.169.145','','actualphone','s:304:"json={"version":1,"data":[{"tag":"medboxx_box.190","phone":"19176504575","tts":"<voice name=&#39;William-8kHz&#39;>This is a call from Worthington Medical Facility reminding you of your appointment for 11:15 am on Thursday July 29th. If you have any questions please call 2221212212. Thank you.</voice>"}]}|[127]";','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('30','2010-07-28 15:05:48','66.246.246.6','','postback','a:1:{s:4:"data";s:83:"{\"tag\":\"medboxx_box.190\",\"disposition\":\"ANSWERED\",\"vm\":1,\"duration\":20}";}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('31','2010-07-28 15:07:02','64.150.169.145','','actualphone','s:293:"json={"version":1,"data":[{"tag":"medboxx_box.198","phone":"","tts":"<voice name=&#39;William-8kHz&#39;>This is a call from Worthington Medical Facility reminding you of your appointment for 11:45 am on Thursday July 29th. If you have any questions please call 2221212212. Thank you.</voice>"}]}|[128]";','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('32','2010-07-28 15:13:03','64.150.169.145','','actualphone','s:304:"json={"version":1,"data":[{"tag":"medboxx_box.214","phone":"18452465599","tts":"<voice name=&#39;William-8kHz&#39;>This is a call from Worthington Medical Facility reminding you of your appointment for 12:00 pm on Thursday July 29th. If you have any questions please call 2221212212. Thank you.</voice>"}]}|[129]";','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('33','2010-07-28 15:14:04','66.246.246.6','','postback','a:1:{s:4:"data";s:83:"{\"tag\":\"medboxx_box.214\",\"disposition\":\"ANSWERED\",\"vm\":1,\"duration\":22}";}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('34','2010-07-28 15:15:02','64.150.169.145','','actualphone','s:293:"json={"version":1,"data":[{"tag":"medboxx_box.210","phone":"","tts":"<voice name=&#39;William-8kHz&#39;>This is a call from Worthington Medical Facility reminding you of your appointment for 12:15 pm on Thursday July 29th. If you have any questions please call 2221212212. Thank you.</voice>"}]}|[130]";','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('35','2010-07-28 16:05:02','64.150.169.145','','actualphone','s:293:"json={"version":1,"data":[{"tag":"medboxx_box.194","phone":"","tts":"<voice name=&#39;William-8kHz&#39;>This is a call from Worthington Medical Facility reminding you of your appointment for 11:15 am on Thursday July 29th. If you have any questions please call 2221212212. Thank you.</voice>"}]}|[131]";','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('36','2010-07-28 16:11:02','64.150.169.145','','actualphone','s:293:"json={"version":1,"data":[{"tag":"medboxx_box.198","phone":"","tts":"<voice name=&#39;William-8kHz&#39;>This is a call from Worthington Medical Facility reminding you of your appointment for 11:45 am on Thursday July 29th. If you have any questions please call 2221212212. Thank you.</voice>"}]}|[132]";','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('37','2010-07-28 16:19:02','64.150.169.145','','actualphone','s:293:"json={"version":1,"data":[{"tag":"medboxx_box.210","phone":"","tts":"<voice name=&#39;William-8kHz&#39;>This is a call from Worthington Medical Facility reminding you of your appointment for 12:15 pm on Thursday July 29th. If you have any questions please call 2221212212. Thank you.</voice>"}]}|[133]";','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('38','2010-07-28 17:07:03','64.150.169.145','','actualphone','s:293:"json={"version":1,"data":[{"tag":"medboxx_box.194","phone":"","tts":"<voice name=&#39;William-8kHz&#39;>This is a call from Worthington Medical Facility reminding you of your appointment for 11:15 am on Thursday July 29th. If you have any questions please call 2221212212. Thank you.</voice>"}]}|[134]";','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('39','2010-07-28 17:15:02','64.150.169.145','','actualphone','s:293:"json={"version":1,"data":[{"tag":"medboxx_box.198","phone":"","tts":"<voice name=&#39;William-8kHz&#39;>This is a call from Worthington Medical Facility reminding you of your appointment for 11:45 am on Thursday July 29th. If you have any questions please call 2221212212. Thank you.</voice>"}]}|[135]";','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('40','2010-07-28 17:23:03','64.150.169.145','','actualphone','s:293:"json={"version":1,"data":[{"tag":"medboxx_box.210","phone":"","tts":"<voice name=&#39;William-8kHz&#39;>This is a call from Worthington Medical Facility reminding you of your appointment for 12:15 pm on Thursday July 29th. If you have any questions please call 2221212212. Thank you.</voice>"}]}|[136]";','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('41','2010-07-28 20:24:04','140.163.254.27','http://medboxx.com/caleditcell.php','loggedfails','a:5:{s:7:"eventid";i:259;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-01 00:00:00";s:10:"actualtime";s:19:"2010-07-28 20:24:04";s:1:"i";i:0;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('42','2010-07-28 20:24:04','140.163.254.27','http://medboxx.com/caleditcell.php','loggedfails','a:5:{s:7:"eventid";i:259;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-22 00:00:00";s:10:"actualtime";s:19:"2010-07-28 20:24:04";s:1:"i";i:1;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('43','2010-07-28 20:24:04','140.163.254.27','http://medboxx.com/caleditcell.php','loggedfails','a:5:{s:7:"eventid";i:259;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-28 00:00:00";s:10:"actualtime";s:19:"2010-07-28 20:24:04";s:1:"i";i:2;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('44','2010-07-28 20:24:04','140.163.254.27','http://medboxx.com/caleditcell.php','daywaszero','a:5:{s:7:"eventid";i:259;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-07-30 00:00:00";s:10:"actualtime";s:19:"2010-07-28 20:24:04";s:1:"i";i:4;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('45','2010-07-28 20:24:04','140.163.254.27','http://medboxx.com/caleditcell.php','daywaszero','a:5:{s:7:"eventid";i:259;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-07-30 00:00:00";s:10:"actualtime";s:19:"2010-07-28 20:24:04";s:1:"i";i:5;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('46','2010-07-28 20:24:25','140.163.254.27','http://medboxx.com/caleditcell.php','loggedfails','a:5:{s:7:"eventid";i:260;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-01 00:00:00";s:10:"actualtime";s:19:"2010-07-28 20:24:25";s:1:"i";i:0;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('47','2010-07-28 20:24:25','140.163.254.27','http://medboxx.com/caleditcell.php','loggedfails','a:5:{s:7:"eventid";i:260;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-22 00:00:00";s:10:"actualtime";s:19:"2010-07-28 20:24:25";s:1:"i";i:1;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('48','2010-07-28 20:24:25','140.163.254.27','http://medboxx.com/caleditcell.php','loggedfails','a:5:{s:7:"eventid";i:260;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-28 00:00:00";s:10:"actualtime";s:19:"2010-07-28 20:24:25";s:1:"i";i:2;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('49','2010-07-28 20:24:25','140.163.254.27','http://medboxx.com/caleditcell.php','daywaszero','a:5:{s:7:"eventid";i:260;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-07-30 00:01:00";s:10:"actualtime";s:19:"2010-07-28 20:24:25";s:1:"i";i:4;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('50','2010-07-28 20:24:25','140.163.254.27','http://medboxx.com/caleditcell.php','daywaszero','a:5:{s:7:"eventid";i:260;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-07-30 00:01:00";s:10:"actualtime";s:19:"2010-07-28 20:24:25";s:1:"i";i:5;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('51','2010-07-28 20:27:27','140.163.254.27','http://medboxx.com/caleditcell.php','loggedfails','a:5:{s:7:"eventid";i:261;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-04 00:00:00";s:10:"actualtime";s:19:"2010-07-28 20:27:27";s:1:"i";i:0;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('52','2010-07-28 20:27:27','140.163.254.27','http://medboxx.com/caleditcell.php','loggedfails','a:5:{s:7:"eventid";i:261;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-25 00:00:00";s:10:"actualtime";s:19:"2010-07-28 20:27:27";s:1:"i";i:1;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('53','2010-07-28 20:27:27','140.163.254.27','http://medboxx.com/caleditcell.php','daywaszero','a:5:{s:7:"eventid";i:261;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-02 00:19:00";s:10:"actualtime";s:19:"2010-07-28 20:27:27";s:1:"i";i:4;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('54','2010-07-28 20:27:27','140.163.254.27','http://medboxx.com/caleditcell.php','daywaszero','a:5:{s:7:"eventid";i:261;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-02 00:19:00";s:10:"actualtime";s:19:"2010-07-28 20:27:27";s:1:"i";i:5;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('55','2010-07-28 20:29:13','140.163.254.27','http://medboxx.com/caleditcell.php','loggedfails','a:5:{s:7:"eventid";i:262;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-01 00:00:00";s:10:"actualtime";s:19:"2010-07-28 20:29:13";s:1:"i";i:0;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('56','2010-07-28 20:29:13','140.163.254.27','http://medboxx.com/caleditcell.php','loggedfails','a:5:{s:7:"eventid";i:262;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-22 00:00:00";s:10:"actualtime";s:19:"2010-07-28 20:29:13";s:1:"i";i:1;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('57','2010-07-28 20:29:13','140.163.254.27','http://medboxx.com/caleditcell.php','loggedfails','a:5:{s:7:"eventid";i:262;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-28 00:00:00";s:10:"actualtime";s:19:"2010-07-28 20:29:13";s:1:"i";i:2;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('58','2010-07-28 20:29:13','140.163.254.27','http://medboxx.com/caleditcell.php','daywaszero','a:5:{s:7:"eventid";i:262;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-07-30 00:04:00";s:10:"actualtime";s:19:"2010-07-28 20:29:13";s:1:"i";i:4;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('59','2010-07-28 20:29:13','140.163.254.27','http://medboxx.com/caleditcell.php','daywaszero','a:5:{s:7:"eventid";i:262;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-07-30 00:04:00";s:10:"actualtime";s:19:"2010-07-28 20:29:13";s:1:"i";i:5;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('60','2010-07-28 20:29:55','140.163.254.27','http://medboxx.com/caleditcell.php','loggedfails','a:5:{s:7:"eventid";i:263;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-04 00:00:00";s:10:"actualtime";s:19:"2010-07-28 20:29:55";s:1:"i";i:0;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('61','2010-07-28 20:29:55','140.163.254.27','http://medboxx.com/caleditcell.php','loggedfails','a:5:{s:7:"eventid";i:263;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-25 00:00:00";s:10:"actualtime";s:19:"2010-07-28 20:29:55";s:1:"i";i:1;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('62','2010-07-28 20:29:55','140.163.254.27','http://medboxx.com/caleditcell.php','daywaszero','a:5:{s:7:"eventid";i:263;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-02 00:19:00";s:10:"actualtime";s:19:"2010-07-28 20:29:55";s:1:"i";i:4;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('63','2010-07-28 20:29:55','140.163.254.27','http://medboxx.com/caleditcell.php','daywaszero','a:5:{s:7:"eventid";i:263;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-02 00:19:00";s:10:"actualtime";s:19:"2010-07-28 20:29:55";s:1:"i";i:5;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('64','2010-07-28 20:57:43','70.110.97.242','http://medboxx.com/caleditcell.php','loggedfails','a:5:{s:7:"eventid";i:264;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-01 00:00:00";s:10:"actualtime";s:19:"2010-07-28 20:57:43";s:1:"i";i:0;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('65','2010-07-28 20:57:43','70.110.97.242','http://medboxx.com/caleditcell.php','loggedfails','a:5:{s:7:"eventid";i:264;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-22 00:00:00";s:10:"actualtime";s:19:"2010-07-28 20:57:43";s:1:"i";i:1;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('66','2010-07-28 20:57:43','70.110.97.242','http://medboxx.com/caleditcell.php','loggedfails','a:5:{s:7:"eventid";i:264;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-28 00:00:00";s:10:"actualtime";s:19:"2010-07-28 20:57:43";s:1:"i";i:2;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('67','2010-07-28 20:57:43','70.110.97.242','http://medboxx.com/caleditcell.php','daywaszero','a:5:{s:7:"eventid";i:264;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-07-30 00:01:00";s:10:"actualtime";s:19:"2010-07-28 20:57:43";s:1:"i";i:4;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('68','2010-07-28 20:57:43','70.110.97.242','http://medboxx.com/caleditcell.php','daywaszero','a:5:{s:7:"eventid";i:264;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-07-30 00:01:00";s:10:"actualtime";s:19:"2010-07-28 20:57:43";s:1:"i";i:5;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('69','2010-07-28 20:58:04','70.110.97.242','http://medboxx.com/caleditcell.php','loggedfails','a:5:{s:7:"eventid";i:265;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-04 00:00:00";s:10:"actualtime";s:19:"2010-07-28 20:58:04";s:1:"i";i:0;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('70','2010-07-28 20:58:04','70.110.97.242','http://medboxx.com/caleditcell.php','loggedfails','a:5:{s:7:"eventid";i:265;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-07-25 00:00:00";s:10:"actualtime";s:19:"2010-07-28 20:58:04";s:1:"i";i:1;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('71','2010-07-28 20:58:04','70.110.97.242','http://medboxx.com/caleditcell.php','daywaszero','a:5:{s:7:"eventid";i:265;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-02 00:06:00";s:10:"actualtime";s:19:"2010-07-28 20:58:04";s:1:"i";i:4;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('72','2010-07-28 20:58:04','70.110.97.242','http://medboxx.com/caleditcell.php','daywaszero','a:5:{s:7:"eventid";i:265;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-02 00:06:00";s:10:"actualtime";s:19:"2010-07-28 20:58:04";s:1:"i";i:5;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('73','2010-07-29 15:13:03','64.150.169.145','','actualphone','s:302:"json={"version":1,"data":[{"tag":"medboxx_box.202","phone":"19176504575","tts":"<voice name=&#39;William-8kHz&#39;>This is a call from Worthington Medical Facility reminding you of your appointment for 10:30 am on Friday July 30th. If you have any questions please call 2221212212. Thank you.</voice>"}]}|[137]";','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('74','2010-07-29 15:14:00','66.246.246.6','','postback','a:1:{s:4:"data";s:83:"{\"tag\":\"medboxx_box.202\",\"disposition\":\"ANSWERED\",\"vm\":1,\"duration\":32}";}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('75','2010-07-29 15:19:03','64.150.169.145','','actualphone','s:302:"json={"version":1,"data":[{"tag":"medboxx_box.206","phone":"18452465599","tts":"<voice name=&#39;William-8kHz&#39;>This is a call from Worthington Medical Facility reminding you of your appointment for 10:45 am on Friday July 30th. If you have any questions please call 2221212212. Thank you.</voice>"}]}|[138]";','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('76','2010-07-29 15:20:04','66.246.246.6','','postback','a:1:{s:4:"data";s:83:"{\"tag\":\"medboxx_box.206\",\"disposition\":\"ANSWERED\",\"vm\":1,\"duration\":22}";}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('77','2010-07-30 00:01:07','64.150.169.145','','actualphone','s:793:"json={"version":1,"data":[{"tag":"medboxx_box.219","phone":"19176504575","tts":"<voice name=&#39;William-8kHz&#39;>This is a call from OppyDental reminding you of your appointment for 10:30 am on Friday July 30th. If you have any questions please call 9176504575. Thank you.</voice>"},{"tag":"medboxx_box.220","phone":"18452465599","tts":"<voice name=&#39;William-8kHz&#39;>This is a call from OppyDental reminding you of your appointment for 1:30 pm on Friday July 30th. If you have any questions please call 9176504575. Thank you.</voice>"},{"tag":"medboxx_box.226","phone":"18452465599","tts":"<voice name=&#39;William-8kHz&#39;>This is a call from OppyDental reminding you of your appointment for 12:30 pm on Friday July 30th. If you have any questions please call 9176504575. Thank you.</voice>"}]}|[139,140,141]";','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('78','2010-07-30 00:01:20','66.246.246.6','','postback','a:1:{s:4:"data";s:54:"{\"tag\":\"medboxx_box.226\",\"disposition\":\"BUSY\"}";}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('79','2010-07-30 00:01:57','66.246.246.6','','postback','a:1:{s:4:"data";s:83:"{\"tag\":\"medboxx_box.219\",\"disposition\":\"ANSWERED\",\"vm\":1,\"duration\":33}";}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('80','2010-07-30 00:02:12','66.246.246.6','','postback','a:1:{s:4:"data";s:83:"{\"tag\":\"medboxx_box.220\",\"disposition\":\"ANSWERED\",\"vm\":1,\"duration\":28}";}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('81','2010-07-30 00:05:02','64.150.169.145','','actualphone','s:283:"json={"version":1,"data":[{"tag":"medboxx_box.223","phone":"18452465599","tts":"<voice name=&#39;William-8kHz&#39;>This is a call from OppyDental reminding you of your appointment for 1:30 pm on Friday July 30th. If you have any questions please call 9176504575. Thank you.</voice>"}]}|[142]";','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('82','2010-07-30 00:06:02','66.246.246.6','','postback','a:1:{s:4:"data";s:83:"{\"tag\":\"medboxx_box.223\",\"disposition\":\"ANSWERED\",\"vm\":1,\"duration\":22}";}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('83','2010-07-30 00:29:02','64.150.169.145','','actualphone','s:284:"json={"version":1,"data":[{"tag":"medboxx_box.226","phone":"18452465599","tts":"<voice name=&#39;William-8kHz&#39;>This is a call from OppyDental reminding you of your appointment for 12:30 pm on Friday July 30th. If you have any questions please call 9176504575. Thank you.</voice>"}]}|[143]";','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('84','2010-07-30 00:30:02','66.246.246.6','','postback','a:1:{s:4:"data";s:83:"{\"tag\":\"medboxx_box.226\",\"disposition\":\"ANSWERED\",\"vm\":1,\"duration\":22}";}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('85','2010-08-01 15:05:04','64.150.169.145','','actualphone','s:303:"json={"version":1,"data":[{"tag":"medboxx_box.218","phone":"19176504575","tts":"<voice name=&#39;William-8kHz&#39;>This is a call from Worthington Medical Facility reminding you of your appointment for 10:15 am on Monday August 2nd. If you have any questions please call 2221212212. Thank you.</voice>"}]}|[144]";','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('86','2010-08-01 15:05:57','66.246.246.6','','postback','a:1:{s:4:"data";s:83:"{\"tag\":\"medboxx_box.218\",\"disposition\":\"ANSWERED\",\"vm\":1,\"duration\":32}";}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('87','2010-08-02 00:07:03','64.150.169.145','','actualphone','s:285:"json={"version":1,"data":[{"tag":"medboxx_box.228","phone":"18452465599","tts":"<voice name=&#39;William-8kHz&#39;>This is a call from OppyDental reminding you of your appointment for 12:00 pm on Monday August 2nd. If you have any questions please call 9176504575. Thank you.</voice>"}]}|[145]";','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('88','2010-08-02 00:08:08','66.246.246.6','','postback','a:1:{s:4:"data";s:83:"{\"tag\":\"medboxx_box.228\",\"disposition\":\"ANSWERED\",\"vm\":1,\"duration\":27}";}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('89','2010-08-02 00:19:03','64.150.169.145','','actualphone','s:540:"json={"version":1,"data":[{"tag":"medboxx_box.222","phone":"18452465599","tts":"<voice name=&#39;William-8kHz&#39;>This is a call from OppyDental reminding you of your appointment for 9:45 am on Monday August 2nd. If you have any questions please call 9176504575. Thank you.</voice>"},{"tag":"medboxx_box.225","phone":"19176504575","tts":"<voice name=&#39;William-8kHz&#39;>This is a call from OppyDental reminding you of your appointment for 10:15 am on Monday August 2nd. If you have any questions please call 9176504575. Thank you.</voice>"}]}|[146,147]";','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('90','2010-08-02 00:19:59','66.246.246.6','','postback','a:1:{s:4:"data";s:83:"{\"tag\":\"medboxx_box.222\",\"disposition\":\"ANSWERED\",\"vm\":1,\"duration\":22}";}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('91','2010-08-02 00:20:13','66.246.246.6','','postback','a:1:{s:4:"data";s:83:"{\"tag\":\"medboxx_box.225\",\"disposition\":\"ANSWERED\",\"vm\":1,\"duration\":33}";}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('92','2010-08-03 00:02:05','66.246.246.6','','postback','a:1:{s:4:"data";s:79:"{\"tag\":\"dayboxx.138\",\"disposition\":\"ANSWERED\",\"vm\":1,\"duration\":22}";}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('93','2010-08-03 00:13:59','66.246.246.6','','postback','a:1:{s:4:"data";s:79:"{\"tag\":\"dayboxx.134\",\"disposition\":\"ANSWERED\",\"vm\":1,\"duration\":33}";}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('94','2010-08-04 00:15:54','66.246.246.6','','postback','a:1:{s:4:"data";s:79:"{\"tag\":\"dayboxx.136\",\"disposition\":\"ANSWERED\",\"vm\":1,\"duration\":33}";}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('95','2010-08-04 14:08:47','70.18.136.66','','postback','a:0:{}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('96','2010-08-05 00:18:02','66.246.246.6','','postback','a:1:{s:4:"data";s:79:"{\"tag\":\"dayboxx.140\",\"disposition\":\"ANSWERED\",\"vm\":1,\"duration\":22}";}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('97','2010-08-05 00:18:08','66.246.246.6','','postback','a:1:{s:4:"data";s:79:"{\"tag\":\"dayboxx.142\",\"disposition\":\"ANSWERED\",\"vm\":1,\"duration\":32}";}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('98','2010-08-05 16:11:03','71.169.57.244','http://medboxx.com/caleditcell.php','loggedfails','a:5:{s:7:"eventid";i:266;s:7:"isemail";b:1;s:9:"calltime:";s:19:"1969-12-29 15:00:00";s:10:"actualtime";s:19:"2010-08-05 16:11:03";s:1:"i";i:0;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('99','2010-08-05 16:11:04','71.169.57.244','http://medboxx.com/caleditcell.php','loggedfails','a:5:{s:7:"eventid";i:266;s:7:"isemail";b:1;s:9:"calltime:";s:19:"1969-12-30 15:00:00";s:10:"actualtime";s:19:"2010-08-05 16:11:04";s:1:"i";i:1;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('100','2010-08-05 16:11:04','71.169.57.244','http://medboxx.com/caleditcell.php','loggedfails','a:5:{s:7:"eventid";i:266;s:7:"isemail";b:1;s:9:"calltime:";s:19:"1969-12-31 15:00:00";s:10:"actualtime";s:19:"2010-08-05 16:11:04";s:1:"i";i:2;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('101','2010-08-05 16:11:04','71.169.57.244','http://medboxx.com/caleditcell.php','loggedfails','a:5:{s:7:"eventid";i:266;s:7:"isemail";b:0;s:9:"calltime:";s:19:"1969-12-31 15:00:00";s:10:"actualtime";s:19:"2010-08-05 16:11:04";s:1:"i";i:3;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('102','2010-08-05 16:11:04','71.169.57.244','http://medboxx.com/caleditcell.php','daywaszero','a:5:{s:7:"eventid";i:266;s:7:"isemail";b:0;s:9:"calltime:";s:19:"1969-12-31 15:00:00";s:10:"actualtime";s:19:"2010-08-05 16:11:04";s:1:"i";i:4;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('103','2010-08-05 16:11:04','71.169.57.244','http://medboxx.com/caleditcell.php','daywaszero','a:5:{s:7:"eventid";i:266;s:7:"isemail";b:0;s:9:"calltime:";s:19:"1969-12-31 15:00:00";s:10:"actualtime";s:19:"2010-08-05 16:11:04";s:1:"i";i:5;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('104','2010-08-06 00:16:12','66.246.246.6','','postback','a:1:{s:4:"data";s:79:"{\"tag\":\"dayboxx.146\",\"disposition\":\"ANSWERED\",\"vm\":1,\"duration\":26}";}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('105','2010-08-06 00:19:58','66.246.246.6','','postback','a:1:{s:4:"data";s:79:"{\"tag\":\"dayboxx.144\",\"disposition\":\"ANSWERED\",\"vm\":1,\"duration\":33}";}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('106','2010-08-06 16:43:52','24.161.14.104','http://medboxx.com/caleditcell.php','loggedfails','a:5:{s:7:"eventid";i:267;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-08-03 15:00:00";s:10:"actualtime";s:19:"2010-08-06 16:43:52";s:1:"i";i:0;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('107','2010-08-06 16:43:52','24.161.14.104','http://medboxx.com/caleditcell.php','loggedfails','a:5:{s:7:"eventid";i:267;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-08-04 15:00:00";s:10:"actualtime";s:19:"2010-08-06 16:43:52";s:1:"i";i:1;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('108','2010-08-06 16:43:52','24.161.14.104','http://medboxx.com/caleditcell.php','loggedfails','a:5:{s:7:"eventid";i:267;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-08-05 15:00:00";s:10:"actualtime";s:19:"2010-08-06 16:43:52";s:1:"i";i:2;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('109','2010-08-06 16:43:52','24.161.14.104','http://medboxx.com/caleditcell.php','loggedfails','a:5:{s:7:"eventid";i:267;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 15:00:00";s:10:"actualtime";s:19:"2010-08-06 16:43:52";s:1:"i";i:3;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('110','2010-08-06 16:43:52','24.161.14.104','http://medboxx.com/caleditcell.php','daywaszero','a:5:{s:7:"eventid";i:267;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 15:00:00";s:10:"actualtime";s:19:"2010-08-06 16:43:52";s:1:"i";i:4;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('111','2010-08-06 16:43:52','24.161.14.104','http://medboxx.com/caleditcell.php','daywaszero','a:5:{s:7:"eventid";i:267;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-05 15:00:00";s:10:"actualtime";s:19:"2010-08-06 16:43:52";s:1:"i";i:5;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('112','2010-08-06 17:14:21','68.236.158.222','http://medboxx.com/caleditcell.php','loggedfails','a:5:{s:7:"eventid";i:268;s:7:"isemail";b:1;s:9:"calltime:";s:19:"1969-12-29 15:00:00";s:10:"actualtime";s:19:"2010-08-06 17:14:21";s:1:"i";i:0;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('113','2010-08-06 17:14:21','68.236.158.222','http://medboxx.com/caleditcell.php','loggedfails','a:5:{s:7:"eventid";i:268;s:7:"isemail";b:1;s:9:"calltime:";s:19:"1969-12-30 15:00:00";s:10:"actualtime";s:19:"2010-08-06 17:14:21";s:1:"i";i:1;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('114','2010-08-06 17:14:21','68.236.158.222','http://medboxx.com/caleditcell.php','loggedfails','a:5:{s:7:"eventid";i:268;s:7:"isemail";b:1;s:9:"calltime:";s:19:"1969-12-31 15:00:00";s:10:"actualtime";s:19:"2010-08-06 17:14:21";s:1:"i";i:2;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('115','2010-08-06 17:14:21','68.236.158.222','http://medboxx.com/caleditcell.php','loggedfails','a:5:{s:7:"eventid";i:268;s:7:"isemail";b:0;s:9:"calltime:";s:19:"1969-12-31 15:00:00";s:10:"actualtime";s:19:"2010-08-06 17:14:21";s:1:"i";i:3;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('116','2010-08-06 17:14:21','68.236.158.222','http://medboxx.com/caleditcell.php','daywaszero','a:5:{s:7:"eventid";i:268;s:7:"isemail";b:0;s:9:"calltime:";s:19:"1969-12-31 15:00:00";s:10:"actualtime";s:19:"2010-08-06 17:14:21";s:1:"i";i:4;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('117','2010-08-06 17:14:21','68.236.158.222','http://medboxx.com/caleditcell.php','daywaszero','a:5:{s:7:"eventid";i:268;s:7:"isemail";b:0;s:9:"calltime:";s:19:"1969-12-31 15:00:00";s:10:"actualtime";s:19:"2010-08-06 17:14:21";s:1:"i";i:5;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('118','2010-08-06 17:17:10','68.236.158.222','http://medboxx.com/caleditcell.php','daywaszero','a:5:{s:7:"eventid";i:269;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-11 15:15:00";s:10:"actualtime";s:19:"2010-08-06 17:17:10";s:1:"i";i:4;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('119','2010-08-06 17:17:10','68.236.158.222','http://medboxx.com/caleditcell.php','daywaszero','a:5:{s:7:"eventid";i:269;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-11 15:15:00";s:10:"actualtime";s:19:"2010-08-06 17:17:10";s:1:"i";i:5;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('120','2010-08-06 17:17:10','68.236.158.222','http://medboxx.com/caleditcell.php','daywaszero','a:5:{s:7:"eventid";i:270;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-11 15:02:00";s:10:"actualtime";s:19:"2010-08-06 17:17:10";s:1:"i";i:4;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('121','2010-08-06 17:17:10','68.236.158.222','http://medboxx.com/caleditcell.php','daywaszero','a:5:{s:7:"eventid";i:270;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-11 15:02:00";s:10:"actualtime";s:19:"2010-08-06 17:17:10";s:1:"i";i:5;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('122','2010-08-06 17:17:33','68.236.158.222','http://medboxx.com/caleditcell.php','daywaszero','a:5:{s:7:"eventid";i:271;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-11 15:04:00";s:10:"actualtime";s:19:"2010-08-06 17:17:33";s:1:"i";i:4;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('123','2010-08-06 17:17:33','68.236.158.222','http://medboxx.com/caleditcell.php','daywaszero','a:5:{s:7:"eventid";i:271;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-11 15:04:00";s:10:"actualtime";s:19:"2010-08-06 17:17:33";s:1:"i";i:5;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('124','2010-08-06 17:17:33','68.236.158.222','http://medboxx.com/caleditcell.php','daywaszero','a:5:{s:7:"eventid";i:272;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-11 15:15:00";s:10:"actualtime";s:19:"2010-08-06 17:17:33";s:1:"i";i:4;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('125','2010-08-06 17:17:33','68.236.158.222','http://medboxx.com/caleditcell.php','daywaszero','a:5:{s:7:"eventid";i:272;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-11 15:15:00";s:10:"actualtime";s:19:"2010-08-06 17:17:33";s:1:"i";i:5;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('126','2010-08-06 17:32:01','68.236.158.222','http://medboxx.com/caleditcell.php','daywaszero','a:5:{s:7:"eventid";i:273;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-11 15:04:00";s:10:"actualtime";s:19:"2010-08-06 17:32:01";s:1:"i";i:4;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('127','2010-08-06 17:32:01','68.236.158.222','http://medboxx.com/caleditcell.php','daywaszero','a:5:{s:7:"eventid";i:273;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-08-11 15:04:00";s:10:"actualtime";s:19:"2010-08-06 17:32:01";s:1:"i";i:5;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('128','2010-08-11 15:03:02','64.150.169.145','','actualphone','s:306:"json={"version":1,"data":[{"tag":"medboxx_box.236","phone":"19176504575","tts":"<voice name=&#39;William-8kHz&#39;>This is a call from Worthington Medical Facility reminding you of your appointment for 10:30 am on Thursday August 12th. If you have any questions please call 2221212212. Thank you.</voice>"}]}|[161]";','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('129','2010-08-11 15:03:52','66.246.246.6','','postback','a:1:{s:4:"data";s:83:"{\"tag\":\"medboxx_box.236\",\"disposition\":\"ANSWERED\",\"vm\":1,\"duration\":32}";}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('130','2010-08-11 15:05:04','64.150.169.145','','actualphone','s:571:"json={"version":1,"data":[{"tag":"medboxx_box.240","phone":"","tts":"<voice name=&#39;William-8kHz&#39;>This is a call from Worthington Medical Facility reminding you of your appointment for 12:00 pm on Thursday August 12th. If you have any questions please call 2221212212. Thank you.</voice>"},{"tag":"medboxx_box.248","phone":"19176504575","tts":"<voice name=&#39;William-8kHz&#39;>This is a call from Worthington Medical Facility reminding you of your appointment for 9:45 am on Thursday August 12th. If you have any questions please call 2221212212. Thank you.</voice>"}]}|[162,163]";','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('131','2010-08-11 15:05:58','66.246.246.6','','postback','a:1:{s:4:"data";s:83:"{\"tag\":\"medboxx_box.248\",\"disposition\":\"ANSWERED\",\"vm\":1,\"duration\":33}";}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('132','2010-08-11 15:15:04','64.150.169.145','','actualphone','s:572:"json={"version":1,"data":[{"tag":"medboxx_box.234","phone":"19176504575","tts":"<voice name=&#39;William-8kHz&#39;>This is a call from Worthington Medical Facility reminding you of your appointment for 10:30 am on Thursday August 12th. If you have any questions please call 2221212212. Thank you.</voice>"},{"tag":"medboxx_box.244","phone":"","tts":"<voice name=&#39;William-8kHz&#39;>This is a call from Worthington Medical Facility reminding you of your appointment for 12:00 pm on Thursday August 12th. If you have any questions please call 2221212212. Thank you.</voice>"}]}|[164,165]";','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('133','2010-08-11 15:15:56','66.246.246.6','','postback','a:1:{s:4:"data";s:83:"{\"tag\":\"medboxx_box.234\",\"disposition\":\"ANSWERED\",\"vm\":1,\"duration\":33}";}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('134','2010-08-11 16:09:02','64.150.169.145','','actualphone','s:295:"json={"version":1,"data":[{"tag":"medboxx_box.240","phone":"","tts":"<voice name=&#39;William-8kHz&#39;>This is a call from Worthington Medical Facility reminding you of your appointment for 12:00 pm on Thursday August 12th. If you have any questions please call 2221212212. Thank you.</voice>"}]}|[166]";','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('135','2010-08-11 16:19:02','64.150.169.145','','actualphone','s:295:"json={"version":1,"data":[{"tag":"medboxx_box.244","phone":"","tts":"<voice name=&#39;William-8kHz&#39;>This is a call from Worthington Medical Facility reminding you of your appointment for 12:00 pm on Thursday August 12th. If you have any questions please call 2221212212. Thank you.</voice>"}]}|[167]";','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('136','2010-08-11 17:13:02','64.150.169.145','','actualphone','s:295:"json={"version":1,"data":[{"tag":"medboxx_box.240","phone":"","tts":"<voice name=&#39;William-8kHz&#39;>This is a call from Worthington Medical Facility reminding you of your appointment for 12:00 pm on Thursday August 12th. If you have any questions please call 2221212212. Thank you.</voice>"}]}|[168]";','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('137','2010-08-11 17:23:02','64.150.169.145','','actualphone','s:295:"json={"version":1,"data":[{"tag":"medboxx_box.244","phone":"","tts":"<voice name=&#39;William-8kHz&#39;>This is a call from Worthington Medical Facility reminding you of your appointment for 12:00 pm on Thursday August 12th. If you have any questions please call 2221212212. Thank you.</voice>"}]}|[169]";','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('138','2010-08-13 00:14:05','66.246.246.6','','postback','a:1:{s:4:"data";s:79:"{\"tag\":\"vetboxx.142\",\"disposition\":\"ANSWERED\",\"vm\":1,\"duration\":30}";}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('139','2010-08-13 00:18:05','66.246.246.6','','postback','a:1:{s:4:"data";s:79:"{\"tag\":\"vetboxx.144\",\"disposition\":\"ANSWERED\",\"vm\":1,\"duration\":29}";}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('140','2010-08-16 00:14:06','66.246.246.6','','postback','a:1:{s:4:"data";s:79:"{\"tag\":\"vetboxx.148\",\"disposition\":\"ANSWERED\",\"vm\":1,\"duration\":30}";}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('141','2010-08-16 00:20:03','66.246.246.6','','postback','a:1:{s:4:"data";s:79:"{\"tag\":\"vetboxx.146\",\"disposition\":\"ANSWERED\",\"vm\":1,\"duration\":30}";}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('142','2010-09-09 02:07:08','68.237.188.127','http://glamourboxx.com/caleditcell.php','loggedfails','a:5:{s:7:"eventid";i:274;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-08-22 00:00:00";s:10:"actualtime";s:19:"2010-09-09 02:07:08";s:1:"i";i:0;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('143','2010-09-09 02:07:08','68.237.188.127','http://glamourboxx.com/caleditcell.php','loggedfails','a:5:{s:7:"eventid";i:274;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-08-31 00:00:00";s:10:"actualtime";s:19:"2010-09-09 02:07:08";s:1:"i";i:1;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('144','2010-09-09 02:07:08','68.237.188.127','http://glamourboxx.com/caleditcell.php','daywaszero','a:5:{s:7:"eventid";i:274;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-08-31 00:00:00";s:10:"actualtime";s:19:"2010-09-09 02:07:08";s:1:"i";i:2;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('145','2010-09-09 02:07:08','68.237.188.127','http://glamourboxx.com/caleditcell.php','loggedfails','a:5:{s:7:"eventid";i:274;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-09-08 00:00:00";s:10:"actualtime";s:19:"2010-09-09 02:07:08";s:1:"i";i:3;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('146','2010-09-09 02:07:08','68.237.188.127','http://glamourboxx.com/caleditcell.php','daywaszero','a:5:{s:7:"eventid";i:274;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-09-08 00:00:00";s:10:"actualtime";s:19:"2010-09-09 02:07:08";s:1:"i";i:4;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('147','2010-09-09 02:07:08','68.237.188.127','http://glamourboxx.com/caleditcell.php','daywaszero','a:5:{s:7:"eventid";i:274;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-09-08 00:00:00";s:10:"actualtime";s:19:"2010-09-09 02:07:08";s:1:"i";i:5;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('148','2010-09-09 11:51:42','24.161.14.104','http://glamourboxx.com/caleditcell.php','loggedfails','a:5:{s:7:"eventid";i:275;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-08-24 00:00:00";s:10:"actualtime";s:19:"2010-09-09 11:51:42";s:1:"i";i:0;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('149','2010-09-09 11:51:42','24.161.14.104','http://glamourboxx.com/caleditcell.php','loggedfails','a:5:{s:7:"eventid";i:275;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-09-02 00:00:00";s:10:"actualtime";s:19:"2010-09-09 11:51:42";s:1:"i";i:1;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('150','2010-09-09 11:51:42','24.161.14.104','http://glamourboxx.com/caleditcell.php','daywaszero','a:5:{s:7:"eventid";i:275;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-09-02 00:00:00";s:10:"actualtime";s:19:"2010-09-09 11:51:42";s:1:"i";i:2;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('151','2010-09-09 11:51:42','24.161.14.104','http://glamourboxx.com/caleditcell.php','daywaszero','a:5:{s:7:"eventid";i:275;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-09-10 00:09:00";s:10:"actualtime";s:19:"2010-09-09 11:51:42";s:1:"i";i:4;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('152','2010-09-09 11:51:42','24.161.14.104','http://glamourboxx.com/caleditcell.php','daywaszero','a:5:{s:7:"eventid";i:275;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-09-10 00:09:00";s:10:"actualtime";s:19:"2010-09-09 11:51:42";s:1:"i";i:5;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('153','2010-09-10 00:09:03','64.150.169.145','','actualphone','s:277:"json={"version":1,"data":[{"tag":"glamourboxx.249","phone":"","tts":"<voice name='William-8kHz'>This is a call from MiddleMan reminding you of your appointment for 10:00 am on Friday September 10th. If you have any questions please call 2266212212. Thank you.</voice>"}]}|[182]";','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('154','2010-09-10 01:13:02','64.150.169.145','','actualphone','s:277:"json={"version":1,"data":[{"tag":"glamourboxx.249","phone":"","tts":"<voice name='William-8kHz'>This is a call from MiddleMan reminding you of your appointment for 10:00 am on Friday September 10th. If you have any questions please call 2266212212. Thank you.</voice>"}]}|[184]";','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('155','2010-09-10 02:17:02','64.150.169.145','','actualphone','s:277:"json={"version":1,"data":[{"tag":"glamourboxx.249","phone":"","tts":"<voice name='William-8kHz'>This is a call from MiddleMan reminding you of your appointment for 10:00 am on Friday September 10th. If you have any questions please call 2266212212. Thank you.</voice>"}]}|[186]";','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('156','2010-09-10 02:56:25','24.161.42.157','http://glamourboxx.com/caleditcell.php','loggedfails','a:5:{s:7:"eventid";i:276;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-08-21 00:00:00";s:10:"actualtime";s:19:"2010-09-10 02:56:25";s:1:"i";i:0;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('157','2010-09-10 02:56:25','24.161.42.157','http://glamourboxx.com/caleditcell.php','loggedfails','a:5:{s:7:"eventid";i:276;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-08-30 00:00:00";s:10:"actualtime";s:19:"2010-09-10 02:56:25";s:1:"i";i:1;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('158','2010-09-10 02:56:25','24.161.42.157','http://glamourboxx.com/caleditcell.php','daywaszero','a:5:{s:7:"eventid";i:276;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-08-30 00:00:00";s:10:"actualtime";s:19:"2010-09-10 02:56:25";s:1:"i";i:2;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('159','2010-09-10 02:56:25','24.161.42.157','http://glamourboxx.com/caleditcell.php','loggedfails','a:5:{s:7:"eventid";i:276;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-09-07 00:00:00";s:10:"actualtime";s:19:"2010-09-10 02:56:25";s:1:"i";i:3;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('160','2010-09-10 02:56:25','24.161.42.157','http://glamourboxx.com/caleditcell.php','daywaszero','a:5:{s:7:"eventid";i:276;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-09-07 00:00:00";s:10:"actualtime";s:19:"2010-09-10 02:56:25";s:1:"i";i:4;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('161','2010-09-10 02:56:25','24.161.42.157','http://glamourboxx.com/caleditcell.php','daywaszero','a:5:{s:7:"eventid";i:276;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-09-07 00:00:00";s:10:"actualtime";s:19:"2010-09-10 02:56:25";s:1:"i";i:5;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('162','2010-09-12 00:19:13','24.161.42.157','http://glamourboxx.com/caleditcell.php','loggedfails','a:5:{s:7:"eventid";i:277;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-08-30 00:00:00";s:10:"actualtime";s:19:"2010-09-12 00:19:13";s:1:"i";i:0;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('163','2010-09-12 00:19:13','24.161.42.157','http://glamourboxx.com/caleditcell.php','loggedfails','a:5:{s:7:"eventid";i:277;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-09-08 00:00:00";s:10:"actualtime";s:19:"2010-09-12 00:19:13";s:1:"i";i:1;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('164','2010-09-12 00:19:13','24.161.42.157','http://glamourboxx.com/caleditcell.php','daywaszero','a:5:{s:7:"eventid";i:277;s:7:"isemail";b:1;s:9:"calltime:";s:19:"2010-09-08 00:00:00";s:10:"actualtime";s:19:"2010-09-12 00:19:13";s:1:"i";i:2;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('165','2010-09-12 00:19:13','24.161.42.157','http://glamourboxx.com/caleditcell.php','daywaszero','a:5:{s:7:"eventid";i:277;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-09-16 00:16:00";s:10:"actualtime";s:19:"2010-09-12 00:19:13";s:1:"i";i:4;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('166','2010-09-12 00:19:13','24.161.42.157','http://glamourboxx.com/caleditcell.php','daywaszero','a:5:{s:7:"eventid";i:277;s:7:"isemail";b:0;s:9:"calltime:";s:19:"2010-09-16 00:16:00";s:10:"actualtime";s:19:"2010-09-12 00:19:13";s:1:"i";i:5;}','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('167','2010-09-21 23:13:04','64.150.169.145','','actualphone','s:279:"json={"version":1,"data":[{"tag":"glamourboxx.250","phone":"","tts":"<voice name='William-8kHz'>This is a call from MiddleMan reminding you of your appointment for 11:15 am on Thursday September 16th. If you have any questions please call 2266212212. Thank you.</voice>"}]}|[194]";','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('168','2010-09-22 00:17:02','64.150.169.145','','actualphone','s:279:"json={"version":1,"data":[{"tag":"glamourboxx.250","phone":"","tts":"<voice name='William-8kHz'>This is a call from MiddleMan reminding you of your appointment for 11:15 am on Thursday September 16th. If you have any questions please call 2266212212. Thank you.</voice>"}]}|[195]";','');
INSERT INTO glamourboxx.formlog(`formlog_id`,`time_done`,`ip_address`,`referer`,`record_label`,`form_content`,`comments`) VALUES('169','2010-09-22 01:21:02','64.150.169.145','','actualphone','s:279:"json={"version":1,"data":[{"tag":"glamourboxx.250","phone":"","tts":"<voice name='William-8kHz'>This is a call from MiddleMan reminding you of your appointment for 11:15 am on Thursday September 16th. If you have any questions please call 2266212212. Thank you.</voice>"}]}|[197]";','');


CREATE TABLE `insurance_type` (
  `insurance_type_id` int(11) NOT NULL auto_increment,
  `itype_name` varchar(50) default NULL,
  PRIMARY KEY  (`insurance_type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;



INSERT INTO glamourboxx.insurance_type(`insurance_type_id`,`itype_name`) VALUES('1','medical');
INSERT INTO glamourboxx.insurance_type(`insurance_type_id`,`itype_name`) VALUES('2','dental');
INSERT INTO glamourboxx.insurance_type(`insurance_type_id`,`itype_name`) VALUES('3','eyeglasses');


CREATE TABLE `login` (
  `login_id` int(11) NOT NULL auto_increment,
  `password` varchar(50) default NULL,
  `username` varchar(150) default NULL,
  `email` varchar(144) default NULL,
  `is_active` tinyint(1) default NULL,
  `type` varchar(12) default NULL,
  PRIMARY KEY  (`login_id`)
) ENGINE=MyISAM AUTO_INCREMENT=56 DEFAULT CHARSET=latin1;



INSERT INTO glamourboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('1','pool','worthington','bigfun@verizon.net','1','office');
INSERT INTO glamourboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('3','pool','','manner@asecular.com','1','client');
INSERT INTO glamourboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('4','pool','','manner@asecular.com','1','client');
INSERT INTO glamourboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('5','pool','','manner3@asecular.com','1','client');
INSERT INTO glamourboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('6','pool','','manner4@asecular.com','1','client');
INSERT INTO glamourboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('7','pool','','goop@asecular.com','1','client');
INSERT INTO glamourboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('8','pool','','goop@asecular.com','1','client');
INSERT INTO glamourboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('9','pool','','goop@asecular.com','1','client');
INSERT INTO glamourboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('10','pool','','goop@asecular.com','1','client');
INSERT INTO glamourboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('11','pool','','goop@asecular.com','1','client');
INSERT INTO glamourboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('15','pool','wockerman','goop@asecular.com','1','client');
INSERT INTO glamourboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('16','pool','yorpwok','foop@pool.com','1','client');
INSERT INTO glamourboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('17','pool','','foop@pool.com','1','client');
INSERT INTO glamourboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('18','pool','','foop@pool.com','1','client');
INSERT INTO glamourboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('19','pool','','foop@pool.com','1','client');
INSERT INTO glamourboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('20','pool','','foop@pool.com','1','client');
INSERT INTO glamourboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('21','!test','','jstohlmann@comcast.net','1','');
INSERT INTO glamourboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('22','burdett','','','0','office');
INSERT INTO glamourboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('23','handson','ciunas','info@ciunascentre.com','1','office');
INSERT INTO glamourboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('24','','','','1','client');
INSERT INTO glamourboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('25','','','','1','');
INSERT INTO glamourboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('26','pool','','bigfun2@verizon.net','1','office');
INSERT INTO glamourboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('27','pool','Bertyle','bigfun33@verizon.net','1','office');
INSERT INTO glamourboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('47','pool','geraldford','gusm@standardsourcemedia.com','1','office');
INSERT INTO glamourboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('48','453453','oppydental','citizenx2@zoho.com','1','office');
INSERT INTO glamourboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('49','pool','','mommer@slick.com','1','client');
INSERT INTO glamourboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('50','pool','gurgle','goop@lop.com','1','office');
INSERT INTO glamourboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('51','pool','snackle','3@p.com','1','office');
INSERT INTO glamourboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('52','pool','snackles','3@p.com','0','office');
INSERT INTO glamourboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('53','pool','sylvia','erewr','1','office');
INSERT INTO glamourboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('54','453453','gina','g@g.g','1','office');
INSERT INTO glamourboxx.login(`login_id`,`password`,`username`,`email`,`is_active`,`type`) VALUES('55','pool','middleman','xxgfun@verizon.net','1','office');


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



INSERT INTO glamourboxx.marital_status(`marital_status_id`,`mstatus_name`) VALUES('1','single');
INSERT INTO glamourboxx.marital_status(`marital_status_id`,`mstatus_name`) VALUES('2','married');
INSERT INTO glamourboxx.marital_status(`marital_status_id`,`mstatus_name`) VALUES('3','divorced');
INSERT INTO glamourboxx.marital_status(`marital_status_id`,`mstatus_name`) VALUES('4','widow/widower');


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
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;



INSERT INTO glamourboxx.office(`office_id`,`login_id`,`office_name`,`subdomain`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('1','1','Worthington Medical Facility','worthington','322 Milva Parkway','Dougston','DE','28121','bigfun@verizon.net','2221212212','7','Call for Phillip Morris','22','121','233','15','9*18','1*5','12*13','12/25 01/01 thanksgiving','0','1','1','2010-04-27 17:09:00','2010-04-27 17:09:00','1','Not only do we have CATscanners and FMRI, we also have stethoscopes.  ','3','2','1','1','0','0','10');
INSERT INTO glamourboxx.office(`office_id`,`login_id`,`office_name`,`subdomain`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('3','4','','','422 Silver Parkway','Dallas','MD','22211','manner@asecular.com','','7','','','','','0','','','','','0','0','1','2010-05-02 10:11:15','2010-05-02 10:11:15','1','','0','0','0','0','0','0','0');
INSERT INTO glamourboxx.office(`office_id`,`login_id`,`office_name`,`subdomain`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('4','22','Burdett Orthopedics','Burdett','2200 Burdett Ave.','Troy','NY','12180','','(518)272-0332','7','','3','10','20','20','9*17','1*5','12*13','12/25 01/01 thanksgiving','0','1','0','2010-05-06 17:38:07','2010-05-06 17:38:07','1','','14','7','1','1','0','0','18');
INSERT INTO glamourboxx.office(`office_id`,`login_id`,`office_name`,`subdomain`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('5','23','ciunas','ciunas','The Old Creamery','Feakle  Co. Clare, Ireland','','0000','info@ciunascentre.com','353876236292','1','','','','','30','9*17','1*5','12*13','12/25 01/01 thanksgiving','0','1','1','2010-05-09 20:51:53','2010-05-09 20:51:53','1','We are located in a fully accessible warm and welcoming centre in Feakle, Co. Clare.  We have a fexible schedule and are there to support you for the long or short term.  ','0','0','0','0','0','0','0');
INSERT INTO glamourboxx.office(`office_id`,`login_id`,`office_name`,`subdomain`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('6','26','Florence Medical Center','florence','121 Florence Drive','Florence','FL','31121','bigfun2@verizon.net','4443334433','7','121 Florence Drive Florence FL','12','33','444','15','9*17','1*5','12*13','12/25 01/01 thanksgiving','0','1','0','2010-05-17 15:54:01','2010-05-17 15:54:01','1','Florence is a full-on medical center.','18','9','0','0','0','0','10');
INSERT INTO glamourboxx.office(`office_id`,`login_id`,`office_name`,`subdomain`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('7','27','Bertyle Associates','Bertyle','112 Gilver Street','Hollywood','AB','12211','bigfun33@verizon.net','4443334433','4','','','','','15','9*17','1*5','12*13','12/25 01/01 thanksgiving','0','1','0','2010-05-21 17:51:52','2010-05-21 17:51:52','1','','18','9','0','1','0','0','10');
INSERT INTO glamourboxx.office(`office_id`,`login_id`,`office_name`,`subdomain`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('12','47','Gerald Ford&#39;s Lab','geraldford','12 Rum Drinker Road','Runcey','IN','44332','gusm@standardsourcemedia.com','4443334433','7','Please please call me and don&#39;t forget to writ','12','14','222','15','9*17','1*5','12*13','12/25 01/01 thanksgiving','0','1','0','2010-07-18 23:36:15','2010-07-18 23:36:15','1','this is my office text','18','9','0','1','0','0','19');
INSERT INTO glamourboxx.office(`office_id`,`login_id`,`office_name`,`subdomain`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('13','48','OppyDental','oppydental','48 Front St','Kingston','NY','12477','citizenx2@zoho.com','9176504575','7','fred','1','1','18','15','8*21','1*5','12*13','12/25 01/01 thanksgiving','0','1','1','2010-07-25 17:55:02','2010-07-25 17:55:02','1','located in the beautiful Hocking Hills','30','9','3','1','0','0','19');
INSERT INTO glamourboxx.office(`office_id`,`login_id`,`office_name`,`subdomain`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('14','50','Gurgle','gurgle','4499 Widdle Lane','Little Rock','BC','22334','goop@lop.com','6773334993','8','','','','','15','9*17','1*5','12*13','12/25 01/01 thanksgiving','0','1','0','2010-08-04 18:15:09','2010-08-04 18:15:09','1','','18','9','0','1','0','0','19');
INSERT INTO glamourboxx.office(`office_id`,`login_id`,`office_name`,`subdomain`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('15','51','Snackle','snackle','4499 Widdle Lane','Little Rock','AB','33221','3@p.com','6773334993','2','','','','','15','9*17','1*5','12*13','12/25 01/01 thanksgiving','0','1','0','2010-08-04 18:16:36','2010-08-04 18:16:36','1','','18','9','0','1','0','0','19');
INSERT INTO glamourboxx.office(`office_id`,`login_id`,`office_name`,`subdomain`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('16','52','Snackles','snackles','4499 Widdle Lane','Little Rock','AB','33221','3@p.com','6773334993','2','','','','','15','9*17','1*5','12*13','12/25 01/01 thanksgiving','0','1','0','2010-08-04 18:16:36','2010-08-04 18:16:36','1','','18','9','0','1','0','0','19');
INSERT INTO glamourboxx.office(`office_id`,`login_id`,`office_name`,`subdomain`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('17','53','sam','sylvia','wewer','werewr','AK','were','erewr','werwer','2','','','','','15','9*17','1*5','12*13','12/25 01/01 thanksgiving','0','1','0','2010-08-08 20:24:31','2010-08-08 20:24:31','1','','18','9','0','1','0','0','19');
INSERT INTO glamourboxx.office(`office_id`,`login_id`,`office_name`,`subdomain`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('18','55','MiddleMan','middleman','44 East Gladstone Turnpike','Morris','AK','33221','xxgfun@verizon.net','2266212212','7','','','','','15','9*17','1*5','12*13','12/25 01/01 thanksgiving','','1','','2010-09-07 15:11:46','2010-09-07 15:11:46','1','','18','9','0','1','0','0','19');


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
) ENGINE=MyISAM AUTO_INCREMENT=278 DEFAULT CHARSET=latin1;



INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('1','100705','0','11:0','60','103','','','1','13','0','0','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('2','100706','0','11:30','60','103','','','1','13','0','0','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('3','100707','0','12:15','60','103','','','1','13','0','0','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('4','100708','0','13:15','60','103','','','1','13','0','0','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('8','100709','0','15:0','60','103','','','1','13','0','0','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('12','100706','0','10:0','60','2','','','1','35','0','0','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('13','100706','0','15:0','60','2','','','1','36','0','0','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('14','100707','0','11:0','60','2','','','1','35','0','0','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('15','100707','0','14:15','60','2','','','1','36','0','0','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('16','100708','0','9:15','60','2','','','1','35','0','0','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('17','100708','0','13:30','60','2','','','1','36','0','4','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('18','100709','0','10:15','60','2','','','1','35','0','0','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('19','100709','0','13:0','60','2','','','1','36','0','2','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('20','100712','0','13:0','60','2','','','1','35','0','0','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('21','100712','0','9:15','60','2','','','1','36','0','0','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('22','100713','0','13:15','60','2','','','1','35','0','0','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('23','100713','0','9:30','60','2','','','1','36','0','0','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('24','100714','0','10:30','60','2','','','1','35','0','0','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('25','100714','0','13:30','60','2','','','1','36','0','0','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('26','100715','0','14:30','60','2','','','1','35','0','0','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('27','100715','0','10:0','60','2','','','1','36','0','1','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('28','100716','0','10:15','60','2','','','1','35','0','1','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('29','100716','0','13:15','60','2','','','1','36','0','0','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('30','100719','0','13:0','60','4','','','1','35','0','0','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('31','100720','0','13:30','60','4','','','1','35','0','1','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('32','100719','0','10:0','60','4','','','1','36','0','2','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('33','100720','0','11:0','60','4','','','1','36','0','4','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('34','100721','0','10:15','60','4','','','1','36','0','3','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('35','100721','0','14:30','60','4','','','1','35','0','1','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('36','100722','0','14:0','60','4','','','1','35','0','1','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('37','100722','0','11:15','60','4','','','1','36','0','1','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('38','100723','0','10:45','60','4','','','1','35','0','1','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('39','100723','0','13:45','60','4','','','1','36','0','4','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('241','','0','','0','0','','','0','0','0','4','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('224','','0','','0','0','','','0','0','0','2','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('242','100720','0','10:0','60','109','','','12','37','0','1','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('243','100726','0','9:45','60','4','','','1','36','0','1','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('244','100726','0','11:0','60','4','','','1','35','0','1','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('246','100727','0','13:15','60','4','','','1','36','0','1','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('247','100727','0','14:45','60','4','','','1','35','0','1','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('248','100728','0','13:15','60','4','','','1','36','0','1','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('249','100728','0','13:15','60','4','','','1','35','0','1','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('250','100728','0','13:15','60','4','','','1','35','0','1','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('251','100729','0','11:15','60','4','','','1','35','0','1','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('252','100729','0','11:15','60','4','','','1','19','0','1','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('253','100729','0','11:45','60','4','','','1','17','0','1','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('254','100730','0','10:30','60','4','','','1','35','0','1','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('255','100730','0','10:45','60','4','','','1','36','0','1','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('256','100729','0','12:15','60','4','','','1','26','0','1','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('257','100729','0','12:0','60','4','','','1','36','0','1','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('258','100802','0','10:15','60','4','','exam','1','35','0','1','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('259','100730','0','10:30','60','110','','','13','38','0','1','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('260','100730','0','13:30','60','110','','','13','39','0','1','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('261','100802','0','9:45','60','110','','','13','39','0','2','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('262','100730','0','13:30','60','110','','','13','39','0','1','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('263','100802','0','10:15','60','110','','','13','38','0','1','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('264','100730','0','12:30','60','110','','','13','39','0','1','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('265','100802','0','12:0','60','110','','','13','39','0','1','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('266','700101','0','0:0','60','3','','exam','1','35','0','1','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('267','100806','0','11:45','60','2','','','1','24','0','1','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('268','700101','0','0:0','60','4','','','1','35','0','1','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('269','100812','0','10:30','60','3','','','1','35','0','1','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('270','100812','0','10:30','60','3','','','1','35','0','1','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('271','100812','0','12:0','60','3','','','1','24','0','1','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('272','100812','0','12:0','60','3','','','1','24','0','1','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('273','100812','0','9:45','15','2','','','1','35','0','1','0');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('274','100908','','9:30','60','112','','','18','41','','','');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('275','100910','','10:0','30','112','','','18','41','','','');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('276','100907','','11:0','10','112','','','18','42','','','');
INSERT INTO glamourboxx.personal_calendar_event(`calendar_event_id`,`datecode`,`recurrence_id`,`time`,`duration`,`practitioner_id`,`type`,`notes`,`office_id`,`client_id`,`sort_id`,`event_status_id`,`no_phone`) VALUES('277','100916','','11:15','60','112','','','18','42','','','');


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
) ENGINE=MyISAM AUTO_INCREMENT=251 DEFAULT CHARSET=latin1;



INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('1','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 11:30 am on Tuesday July 6th. If you have any questions please call 2221212212. Thank you.','2009-12-12 12:12:12','1','0','7','1','0','0000-00-00 00:00:00','1','13','','2010-07-06 11:30:00','2','Dear Henry Moffat,

This is a message from Worthington Medical Facility reminding you of your appointment for 11:30 am on Tuesday July 6th with Dawn Parklington. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=E9-XR9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=QM9-EM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=GTzbO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call:2010-07-05 15:00:00 time of appointment:2010-07-06 11:30:00','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('2','1','0','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 11:30 am on Tuesday July 6th. If you have any questions please call 2221212212. Thank you.','2010-07-05 15:00:00','1','1','3','1','0','2010-07-05 01:01:02','1','13','','2010-07-06 11:30:00','2','Dear Henry Moffat,

This is a message from Worthington Medical Facility reminding you of your appointment for 11:30 am on Tuesday July 6th with Dawn Parklington. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=E9-XR9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=QM9-EM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=GTzbO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call:2010-07-05 15:00:00 time of appointment:2010-07-06 11:30:00','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('3','0','1','18453401090','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 12:15 pm on Wednesday July 7th. If you have any questions please call 2221212212. Thank you.','2010-07-05 15:00:00','1','0','0','1','0','1970-01-01 00:00:00','1','13','','2010-07-07 12:15:00','3','Dear Henry Moffat,

This is a message from Worthington Medical Facility reminding you of your appointment for 12:15 pm on Wednesday July 7th with Dawn Parklington. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=aM9GK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=Az-hO9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=F9-XL94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call:2010-07-05 15:00:00 time of appointment:2010-07-07 12:15:00','1','1');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('4','0','1','18453401090','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 12:15 pm on Wednesday July 7th. If you have any questions please call 2221212212. Thank you.','2010-07-06 15:00:00','1','0','0','1','0','1970-01-01 00:00:00','1','13','','2010-07-07 12:15:00','3','Dear Henry Moffat,

This is a message from Worthington Medical Facility reminding you of your appointment for 12:15 pm on Wednesday July 7th with Dawn Parklington. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=aM9GK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=Az-hO9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=F9-XL94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call:2010-07-06 15:00:00 time of appointment:2010-07-07 12:15:00','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('5','1','0','18453401090','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 12:15 pm on Wednesday July 7th. If you have any questions please call 2221212212. Thank you.','2010-07-06 15:00:00','1','1','3','0','0','2010-07-06 01:01:01','1','13','','2010-07-07 12:15:00','3','Dear Henry Moffat,

This is a message from Worthington Medical Facility reminding you of your appointment for 12:15 pm on Wednesday July 7th with Dawn Parklington. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=aM9GK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=Az-hO9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=F9-XL94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call:2010-07-06 15:00:00 time of appointment:2010-07-07 12:15:00','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('6','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Thursday July 8th. If you have any questions please call 2221212212. Thank you.','2010-07-05 15:00:00','1','0','0','1','0','0000-00-00 00:00:00','1','13','','2010-07-08 13:15:00','4','Dear Henry Moffat,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Thursday July 8th with Dawn Parklington. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=kM9uK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=Bz-hS9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=G9-XP94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call:2010-07-05 15:00:00 time of appointment:2010-07-08 13:15:00','1','0');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('7','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Thursday July 8th. If you have any questions please call 2221212212. Thank you.','2010-07-06 15:00:00','1','0','0','1','0','0000-00-00 00:00:00','1','13','','2010-07-08 13:15:00','4','Dear Henry Moffat,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Thursday July 8th with Dawn Parklington. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=kM9uK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=Bz-hS9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=G9-XP94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call:2010-07-06 15:00:00 time of appointment:2010-07-08 13:15:00','1','1');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('8','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Thursday July 8th. If you have any questions please call 2221212212. Thank you.','2010-07-07 15:00:00','1','0','0','1','0','0000-00-00 00:00:00','1','13','','2010-07-08 13:15:00','4','Dear Henry Moffat,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Thursday July 8th with Dawn Parklington. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=kM9uK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=Bz-hS9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=G9-XP94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call:2010-07-07 15:00:00 time of appointment:2010-07-08 13:15:00','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('9','1','0','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Thursday July 8th. If you have any questions please call 2221212212. Thank you.','2010-07-07 15:00:00','1','1','3','0','0','2010-07-07 15:01:02','1','13','','2010-07-08 13:15:00','4','Dear Henry Moffat,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Thursday July 8th with Dawn Parklington. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=kM9uK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=Bz-hS9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=G9-XP94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call:2010-07-07 15:00:00 time of appointment:2010-07-08 13:15:00','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('38','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 11:00 am on Wednesday July 7th. If you have any questions please call 2221212212. Thank you.','2010-07-05 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-07 11:00:00','14','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 11:00 am on Wednesday July 7th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=kN9uO9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=BzGS9kM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=G9-hP9-iO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-05 15:00:00 time of appointment:2010-07-07 11:00:00','1','1');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('37','1','0','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 3:00 pm on Tuesday July 6th. If you have any questions please call 2221212212. Thank you.','2010-07-06 15:00:00','1','11','3','0','0','2010-07-05 15:31:01','1','36','','2010-07-06 15:00:00','13','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 3:00 pm on Tuesday July 6th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=aN9GO9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=AzGO9kM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=F9-hL9-iO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-05 15:00:00 time of appointment:2010-07-06 15:00:00','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('36','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 3:00 pm on Tuesday July 6th. If you have any questions please call 2221212212. Thank you.','2010-07-05 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-06 15:00:00','13','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 3:00 pm on Tuesday July 6th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=aN9GO9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=AzGO9kM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=F9-hL9-iO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-05 15:00:00 time of appointment:2010-07-06 15:00:00','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('35','1','0','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:00 am on Tuesday July 6th. If you have any questions please call 2221212212. Thank you.','2010-07-05 15:00:00','1','10','3','0','0','2010-07-05 15:29:01','1','35','','2010-07-06 10:00:00','12','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:00 am on Tuesday July 6th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=QN9-EN9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=JpGK-JaM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=E9-hR9-YO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-05 15:00:00 time of appointment:2010-07-06 10:00:00','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('34','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:00 am on Tuesday July 6th. If you have any questions please call 2221212212. Thank you.','2010-07-05 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-06 10:00:00','12','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:00 am on Tuesday July 6th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=QN9-EN9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=JpGK-JaM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=E9-hR9-YO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-05 15:00:00 time of appointment:2010-07-06 10:00:00','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('45','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 9:15 am on Thursday July 8th. If you have any questions please call 2221212212. Thank you.','2010-07-06 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-08 09:15:00','16','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 9:15 am on Thursday July 8th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=4N9aP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=DzGQ9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=I9-hN9HO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-06 15:00:00 time of appointment:2010-07-08 09:15:00','1','1');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('44','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 9:15 am on Thursday July 8th. If you have any questions please call 2221212212. Thank you.','2010-07-05 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-08 09:15:00','16','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 9:15 am on Thursday July 8th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=4N9aP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=DzGQ9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=I9-hN9HO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-05 15:00:00 time of appointment:2010-07-08 09:15:00','1','0');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('39','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 11:00 am on Wednesday July 7th. If you have any questions please call 2221212212. Thank you.','2010-07-06 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-07 11:00:00','14','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 11:00 am on Wednesday July 7th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=kN9uO9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=BzGS9kM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=G9-hP9-iO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-06 15:00:00 time of appointment:2010-07-07 11:00:00','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('40','1','0','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 11:00 am on Wednesday July 7th. If you have any questions please call 2221212212. Thank you.','2010-07-06 15:00:00','1','1','3','0','0','2010-07-06 01:01:01','1','35','','2010-07-07 11:00:00','14','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 11:00 am on Wednesday July 7th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=kN9uO9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=BzGS9kM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=G9-hP9-iO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-06 15:00:00 time of appointment:2010-07-07 11:00:00','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('41','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 2:15 pm on Wednesday July 7th. If you have any questions please call 2221212212. Thank you.','2010-07-05 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-07 14:15:00','15','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 2:15 pm on Wednesday July 7th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=uN9-XP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=CzGM9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=H9-hTzHO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-05 15:00:00 time of appointment:2010-07-07 14:15:00','1','1');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('42','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 2:15 pm on Wednesday July 7th. If you have any questions please call 2221212212. Thank you.','2010-07-05 15:00:00','1','1','1','0','0','2010-07-05 15:25:49','1','36','','2010-07-07 14:15:00','15','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 2:15 pm on Wednesday July 7th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=uN9-XP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=CzGM9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=H9-hTzHO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-06 15:00:00 time of appointment:2010-07-07 14:15:00','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('43','1','0','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 2:15 pm on Wednesday July 7th. If you have any questions please call 2221212212. Thank you.','2010-07-06 15:00:00','1','3','2','0','0','2010-07-22 03:25:01','1','36','','2010-07-07 14:15:00','15','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 2:15 pm on Wednesday July 7th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=uN9-XP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=CzGM9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=H9-hTzHO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-06 15:00:00 time of appointment:2010-07-07 14:15:00','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('46','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 9:15 am on Thursday July 8th. If you have any questions please call 2221212212. Thank you.','2010-07-07 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-08 09:15:00','16','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 9:15 am on Thursday July 8th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=4N9aP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=DzGQ9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=I9-hN9HO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-07 15:00:00 time of appointment:2010-07-08 09:15:00','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('47','1','0','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 9:15 am on Thursday July 8th. If you have any questions please call 2221212212. Thank you.','2010-07-07 15:00:00','1','3','2','0','0','2010-07-22 03:25:01','1','35','','2010-07-08 09:15:00','16','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 9:15 am on Thursday July 8th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=4N9aP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=DzGQ9uM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=I9-hN9HO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-07 15:00:00 time of appointment:2010-07-08 09:15:00','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('48','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:30 pm on Thursday July 8th. If you have any questions please call 2221212212. Thank you.','2010-07-05 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-08 13:30:00','17','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:30 pm on Thursday July 8th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=-EN9-EP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=EzGK-JuM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=J9-hR9HO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-05 15:00:00 time of appointment:2010-07-08 13:30:00','1','0');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('49','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:30 pm on Thursday July 8th. If you have any questions please call 2221212212. Thank you.','2010-07-06 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-08 13:30:00','17','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:30 pm on Thursday July 8th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=-EN9-EP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=EzGK-JuM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=J9-hR9HO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-06 15:00:00 time of appointment:2010-07-08 13:30:00','1','1');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('50','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:30 pm on Thursday July 8th. If you have any questions please call 2221212212. Thank you.','2010-07-07 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-08 13:30:00','17','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:30 pm on Thursday July 8th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=-EN9-EP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=EzGK-JuM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=J9-hR9HO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-07 15:00:00 time of appointment:2010-07-08 13:30:00','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('51','1','0','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:30 pm on Thursday July 8th. If you have any questions please call 2221212212. Thank you.','2010-07-07 15:00:00','1','1','3','0','0','2010-07-07 15:01:02','1','36','','2010-07-08 13:30:00','17','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:30 pm on Thursday July 8th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=-EN9-EP9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=EzGK-JuM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=J9-hR9HO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-07 15:00:00 time of appointment:2010-07-08 13:30:00','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('52','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:15 am on Friday July 9th. If you have any questions please call 2221212212. Thank you.','2010-07-06 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-09 10:15:00','18','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:15 am on Friday July 9th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=-ON9GQ9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=FzGO94M-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=A-J-hL9RO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-06 15:00:00 time of appointment:2010-07-09 10:15:00','1','0');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('56','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:00 pm on Friday July 9th. If you have any questions please call 2221212212. Thank you.','2010-07-06 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-09 13:00:00','19','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:00 pm on Friday July 9th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=-YN9uQ9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=GzGS94M-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=B-J-hP9RO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-06 15:00:00 time of appointment:2010-07-09 13:00:00','1','0');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('57','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:00 pm on Friday July 9th. If you have any questions please call 2221212212. Thank you.','2010-07-07 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-09 13:00:00','19','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:00 pm on Friday July 9th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=-YN9uQ9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=GzGS94M-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=B-J-hP9RO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-07 15:00:00 time of appointment:2010-07-09 13:00:00','1','1');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('58','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:00 pm on Friday July 9th. If you have any questions please call 2221212212. Thank you.','2010-07-08 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-09 13:00:00','19','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:00 pm on Friday July 9th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=-YN9uQ9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=GzGS94M-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=B-J-hP9RO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-08 15:00:00 time of appointment:2010-07-09 13:00:00','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('59','1','0','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:00 pm on Friday July 9th. If you have any questions please call 2221212212. Thank you.','2010-07-08 15:00:00','1','1','3','0','0','2010-07-08 15:01:06','1','36','','2010-07-09 13:00:00','19','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:00 pm on Friday July 9th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=-YN9uQ9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=GzGS94M-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=B-J-hP9RO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-08 15:00:00 time of appointment:2010-07-09 13:00:00','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('60','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:00 pm on Monday July 12th. If you have any questions please call 2221212212. Thank you.','2010-07-09 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-12 13:00:00','20','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:00 pm on Monday July 12th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=-hO9-XR9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=HpQM9-EM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=C9GTzbO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-09 15:00:00 time of appointment:2010-07-12 13:00:00','1','0');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('61','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:00 pm on Monday July 12th. If you have any questions please call 2221212212. Thank you.','2010-07-10 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-12 13:00:00','20','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:00 pm on Monday July 12th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=-hO9-XR9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=HpQM9-EM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=C9GTzbO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-10 15:00:00 time of appointment:2010-07-12 13:00:00','1','1');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('62','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:00 pm on Monday July 12th. If you have any questions please call 2221212212. Thank you.','2010-07-11 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-12 13:00:00','20','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:00 pm on Monday July 12th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=-hO9-XR9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=HpQM9-EM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=C9GTzbO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-11 15:00:00 time of appointment:2010-07-12 13:00:00','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('63','1','0','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:00 pm on Monday July 12th. If you have any questions please call 2221212212. Thank you.','2010-07-11 15:00:00','1','1','3','0','0','2010-07-11 15:01:01','1','35','','2010-07-12 13:00:00','20','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:00 pm on Monday July 12th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=-hO9-XR9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=HpQM9-EM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=C9GTzbO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-11 15:00:00 time of appointment:2010-07-12 13:00:00','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('64','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 9:15 am on Monday July 12th. If you have any questions please call 2221212212. Thank you.','2010-07-09 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-12 09:15:00','21','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 9:15 am on Monday July 12th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=GO9aR9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=IpQQ9-EM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=D9GN9bO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-09 15:00:00 time of appointment:2010-07-12 09:15:00','1','0');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('65','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 9:15 am on Monday July 12th. If you have any questions please call 2221212212. Thank you.','2010-07-10 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-12 09:15:00','21','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 9:15 am on Monday July 12th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=GO9aR9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=IpQQ9-EM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=D9GN9bO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-10 15:00:00 time of appointment:2010-07-12 09:15:00','1','1');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('66','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 9:15 am on Monday July 12th. If you have any questions please call 2221212212. Thank you.','2010-07-11 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-12 09:15:00','21','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 9:15 am on Monday July 12th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=GO9aR9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=IpQQ9-EM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=D9GN9bO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-11 15:00:00 time of appointment:2010-07-12 09:15:00','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('67','1','0','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 9:15 am on Monday July 12th. If you have any questions please call 2221212212. Thank you.','2010-07-11 15:00:00','1','3','2','0','0','2010-07-22 03:25:01','1','36','','2010-07-12 09:15:00','21','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 9:15 am on Monday July 12th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=GO9aR9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=IpQQ9-EM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=D9GN9bO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-11 15:00:00 time of appointment:2010-07-12 09:15:00','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('68','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Tuesday July 13th. If you have any questions please call 2221212212. Thank you.','2010-07-10 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-13 13:15:00','22','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Tuesday July 13th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=QO9-ER9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=JpQK-J-EM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=E9GR9bO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-10 15:00:00 time of appointment:2010-07-13 13:15:00','1','0');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('69','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Tuesday July 13th. If you have any questions please call 2221212212. Thank you.','2010-07-11 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-13 13:15:00','22','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Tuesday July 13th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=QO9-ER9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=JpQK-J-EM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=E9GR9bO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-11 15:00:00 time of appointment:2010-07-13 13:15:00','1','1');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('70','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Tuesday July 13th. If you have any questions please call 2221212212. Thank you.','2010-07-12 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-13 13:15:00','22','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Tuesday July 13th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=QO9-ER9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=JpQK-J-EM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=E9GR9bO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-12 15:00:00 time of appointment:2010-07-13 13:15:00','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('71','1','0','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Tuesday July 13th. If you have any questions please call 2221212212. Thank you.','2010-07-12 15:00:00','1','1','3','0','0','2010-07-12 15:01:04','1','35','','2010-07-13 13:15:00','22','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Tuesday July 13th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=QO9-ER9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=JpQK-J-EM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=E9GR9bO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-12 15:00:00 time of appointment:2010-07-13 13:15:00','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('72','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 9:30 am on Tuesday July 13th. If you have any questions please call 2221212212. Thank you.','2010-07-10 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-13 09:30:00','23','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 9:30 am on Tuesday July 13th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=aO9GS9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=AzQO9-OM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=F9GL9lO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-10 15:00:00 time of appointment:2010-07-13 09:30:00','1','0');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('73','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 9:30 am on Tuesday July 13th. If you have any questions please call 2221212212. Thank you.','2010-07-11 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-13 09:30:00','23','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 9:30 am on Tuesday July 13th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=aO9GS9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=AzQO9-OM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=F9GL9lO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-11 15:00:00 time of appointment:2010-07-13 09:30:00','1','1');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('74','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 9:30 am on Tuesday July 13th. If you have any questions please call 2221212212. Thank you.','2010-07-12 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-13 09:30:00','23','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 9:30 am on Tuesday July 13th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=aO9GS9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=AzQO9-OM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=F9GL9lO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-12 15:00:00 time of appointment:2010-07-13 09:30:00','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('75','1','0','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 9:30 am on Tuesday July 13th. If you have any questions please call 2221212212. Thank you.','2010-07-12 15:00:00','1','1','3','0','0','2010-07-12 15:01:04','1','36','','2010-07-13 09:30:00','23','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 9:30 am on Tuesday July 13th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=aO9GS9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=AzQO9-OM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=F9GL9lO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-12 15:00:00 time of appointment:2010-07-13 09:30:00','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('76','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:30 am on Wednesday July 14th. If you have any questions please call 2221212212. Thank you.','2010-07-11 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-14 10:30:00','24','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:30 am on Wednesday July 14th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=kO9uS9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=BzQS9-OM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=G9GP9lO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-11 15:00:00 time of appointment:2010-07-14 10:30:00','1','0');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('77','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:30 am on Wednesday July 14th. If you have any questions please call 2221212212. Thank you.','2010-07-12 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-14 10:30:00','24','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:30 am on Wednesday July 14th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=kO9uS9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=BzQS9-OM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=G9GP9lO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-12 15:00:00 time of appointment:2010-07-14 10:30:00','1','1');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('78','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:30 am on Wednesday July 14th. If you have any questions please call 2221212212. Thank you.','2010-07-13 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-14 10:30:00','24','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:30 am on Wednesday July 14th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=kO9uS9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=BzQS9-OM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=G9GP9lO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-13 15:00:00 time of appointment:2010-07-14 10:30:00','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('79','1','0','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:30 am on Wednesday July 14th. If you have any questions please call 2221212212. Thank you.','2010-07-13 15:00:00','1','1','3','0','0','2010-07-13 15:01:02','1','35','','2010-07-14 10:30:00','24','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:30 am on Wednesday July 14th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=kO9uS9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=BzQS9-OM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=G9GP9lO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-13 15:00:00 time of appointment:2010-07-14 10:30:00','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('80','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:30 pm on Wednesday July 14th. If you have any questions please call 2221212212. Thank you.','2010-07-11 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-14 13:30:00','25','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:30 pm on Wednesday July 14th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=CzQM9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=GTp-hM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=uO9-XTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-11 15:00:00 time of appointment:2010-07-14 13:30:00','1','0');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('81','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:30 pm on Wednesday July 14th. If you have any questions please call 2221212212. Thank you.','2010-07-12 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-14 13:30:00','25','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:30 pm on Wednesday July 14th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=CzQM9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=GTp-hM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=uO9-XTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-12 15:00:00 time of appointment:2010-07-14 13:30:00','1','1');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('82','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:30 pm on Wednesday July 14th. If you have any questions please call 2221212212. Thank you.','2010-07-13 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-14 13:30:00','25','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:30 pm on Wednesday July 14th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=CzQM9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=GTp-hM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=uO9-XTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-13 15:00:00 time of appointment:2010-07-14 13:30:00','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('83','1','0','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:30 pm on Wednesday July 14th. If you have any questions please call 2221212212. Thank you.','2010-07-13 15:00:00','1','1','3','0','0','2010-07-13 15:01:02','1','36','','2010-07-14 13:30:00','25','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:30 pm on Wednesday July 14th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=CzQM9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=GTp-hM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=uO9-XTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-13 15:00:00 time of appointment:2010-07-14 13:30:00','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('84','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 2:30 pm on Thursday July 15th. If you have any questions please call 2221212212. Thank you.','2010-07-12 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-15 14:30:00','26','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 2:30 pm on Thursday July 15th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=DzQQ9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=QTpkM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=4O9aTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-12 15:00:00 time of appointment:2010-07-15 14:30:00','1','0');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('85','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 2:30 pm on Thursday July 15th. If you have any questions please call 2221212212. Thank you.','2010-07-13 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-15 14:30:00','26','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 2:30 pm on Thursday July 15th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=DzQQ9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=QTpkM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=4O9aTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-13 15:00:00 time of appointment:2010-07-15 14:30:00','1','1');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('108','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 2:30 pm on Thursday July 15th. If you have any questions please call 2221212212. Thank you.','2010-07-14 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-15 14:30:00','26','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 2:30 pm on Thursday July 15th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=DzQQ9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=QTpkM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=4O9aTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-14 15:00:00 time of appointment:2010-07-15 14:30:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 26','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('109','1','0','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 2:30 pm on Thursday July 15th. If you have any questions please call 2221212212. Thank you.','2010-07-14 15:15:00','1','1','3','0','0','2010-07-14 15:15:01','1','35','','2010-07-15 14:30:00','26','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 2:30 pm on Thursday July 15th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=DzQQ9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=QTpkM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=4O9aTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-14 15:15:00 time of appointment:2010-07-15 14:30:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 26','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('88','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:00 am on Thursday July 15th. If you have any questions please call 2221212212. Thank you.','2010-07-12 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-15 10:00:00','27','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:00 am on Thursday July 15th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=EzQK-J-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=aTp-OM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-EO9-ETz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-12 15:00:00 time of appointment:2010-07-15 10:00:00','1','0');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('89','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:00 am on Thursday July 15th. If you have any questions please call 2221212212. Thank you.','2010-07-13 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-15 10:00:00','27','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:00 am on Thursday July 15th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=EzQK-J-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=aTp-OM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-EO9-ETz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-13 15:00:00 time of appointment:2010-07-15 10:00:00','1','1');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('106','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:00 am on Thursday July 15th. If you have any questions please call 2221212212. Thank you.','2010-07-14 15:08:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-15 10:00:00','27','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:00 am on Thursday July 15th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=EzQK-J-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=aTp-OM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-EO9-ETz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-14 15:08:00 time of appointment:2010-07-15 10:00:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 27','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('107','1','0','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:00 am on Thursday July 15th. If you have any questions please call 2221212212. Thank you.','2010-07-14 15:14:00','1','1','3','0','0','2010-07-14 15:15:01','1','36','','2010-07-15 10:00:00','27','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:00 am on Thursday July 15th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=EzQK-J-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=aTp-OM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-EO9-ETz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-14 15:14:00 time of appointment:2010-07-15 10:00:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 27','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('92','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:15 am on Friday July 16th. If you have any questions please call 2221212212. Thank you.','2010-07-13 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-16 10:15:00','28','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:15 am on Friday July 16th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=FzQO9-hK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=kTpQN9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-OO9GK94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-13 15:00:00 time of appointment:2010-07-16 10:15:00','1','0');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('93','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:15 am on Friday July 16th. If you have any questions please call 2221212212. Thank you.','2010-07-14 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-16 10:15:00','28','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:15 am on Friday July 16th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=FzQO9-hK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=kTpQN9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-OO9GK94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-14 15:00:00 time of appointment:2010-07-16 10:15:00','1','1');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('114','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:15 am on Friday July 16th. If you have any questions please call 2221212212. Thank you.','2010-07-15 15:09:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-16 10:15:00','28','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:15 am on Friday July 16th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=FzQO9-hK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=kTpQN9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-OO9GK94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-15 15:09:00 time of appointment:2010-07-16 10:15:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 28','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('115','1','0','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:15 am on Friday July 16th. If you have any questions please call 2221212212. Thank you.','2010-07-15 15:05:00','1','1','3','0','0','2010-07-15 15:05:01','1','35','','2010-07-16 10:15:00','28','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:15 am on Friday July 16th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=FzQO9-hK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=kTpQN9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-OO9GK94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-15 15:05:00 time of appointment:2010-07-16 10:15:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 28','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('96','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Friday July 16th. If you have any questions please call 2221212212. Thank you.','2010-07-13 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-16 13:15:00','29','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Friday July 16th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=GzQS9-hK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=uTp4N9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-YO9uK94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-13 15:00:00 time of appointment:2010-07-16 13:15:00','1','0');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('97','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Friday July 16th. If you have any questions please call 2221212212. Thank you.','2010-07-14 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-16 13:15:00','29','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Friday July 16th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=GzQS9-hK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=uTp4N9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-YO9uK94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-14 15:00:00 time of appointment:2010-07-16 13:15:00','1','1');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('98','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Friday July 16th. If you have any questions please call 2221212212. Thank you.','2010-07-15 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-16 13:15:00','29','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Friday July 16th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=GzQS9-hK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=uTp4N9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-YO9uK94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-15 15:00:00 time of appointment:2010-07-16 13:15:00','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('99','1','0','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Friday July 16th. If you have any questions please call 2221212212. Thank you.','2010-07-15 15:00:00','1','1','3','0','0','2010-07-15 15:01:01','1','36','','2010-07-16 13:15:00','29','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Friday July 16th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=GzQS9-hK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=uTp4N9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-YO9uK94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-15 15:00:00 time of appointment:2010-07-16 13:15:00','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('103','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:15 am on Friday July 9th. If you have any questions please call 2221212212. Thank you.','2010-07-07 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-09 10:15:00','18','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:15 am on Friday July 9th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=-ON9GQ9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=FzGO94M-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=A-J-hL9RO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-07 15:00:00 time of appointment:2010-07-09 10:15:00
This is supposed to have come 2 days before the appointment.
The Event ID for this is: 18','1','1');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('104','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:15 am on Friday July 9th. If you have any questions please call 2221212212. Thank you.','2010-07-08 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-09 10:15:00','18','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:15 am on Friday July 9th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=-ON9GQ9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=FzGO94M-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=A-J-hL9RO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-08 15:00:00 time of appointment:2010-07-09 10:15:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 18','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('105','1','0','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:15 am on Friday July 9th. If you have any questions please call 2221212212. Thank you.','2010-07-08 15:00:00','1','1','3','0','0','2010-07-08 15:01:06','1','35','','2010-07-09 10:15:00','18','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:15 am on Friday July 9th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=-ON9GQ9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=FzGO94M-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=A-J-hL9RO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-08 15:00:00 time of appointment:2010-07-09 10:15:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 18','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('110','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:00 pm on Monday July 19th. If you have any questions please call 2221212212. Thank you.','2010-07-16 15:20:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-19 13:00:00','30','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:00 pm on Monday July 19th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=HpaM9GK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=3Kz-hO9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-hP9-XL94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-16 15:20:00 time of appointment:2010-07-19 13:00:00
This is supposed to have come 3 days before the appointment.
The Event ID for this is: 30','1','0');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('111','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:00 pm on Monday July 19th. If you have any questions please call 2221212212. Thank you.','2010-07-17 15:19:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-19 13:00:00','30','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:00 pm on Monday July 19th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=HpaM9GK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=3Kz-hO9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-hP9-XL94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-17 15:19:00 time of appointment:2010-07-19 13:00:00
This is supposed to have come 2 days before the appointment.
The Event ID for this is: 30','1','1');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('112','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:00 pm on Monday July 19th. If you have any questions please call 2221212212. Thank you.','2010-07-18 15:18:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-19 13:00:00','30','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:00 pm on Monday July 19th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=HpaM9GK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=3Kz-hO9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-hP9-XL94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-18 15:18:00 time of appointment:2010-07-19 13:00:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 30','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('113','1','0','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:00 pm on Monday July 19th. If you have any questions please call 2221212212. Thank you.','2010-07-18 15:06:00','1','1','3','0','0','2010-07-18 15:07:01','1','35','','2010-07-19 13:00:00','30','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:00 pm on Monday July 19th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=HpaM9GK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=3Kz-hO9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-hP9-XL94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-18 15:06:00 time of appointment:2010-07-19 13:00:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 30','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('116','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:30 pm on Tuesday July 20th. If you have any questions please call 2221212212. Thank you.','2010-07-17 15:09:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-20 13:30:00','31','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:30 pm on Tuesday July 20th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=IpaQ9GK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=-DKzkO9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=GP9aL94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-17 15:09:00 time of appointment:2010-07-20 13:30:00
This is supposed to have come 3 days before the appointment.
The Event ID for this is: 31','1','0');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('117','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:30 pm on Tuesday July 20th. If you have any questions please call 2221212212. Thank you.','2010-07-18 15:08:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-20 13:30:00','31','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:30 pm on Tuesday July 20th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=IpaQ9GK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=-DKzkO9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=GP9aL94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-18 15:08:00 time of appointment:2010-07-20 13:30:00
This is supposed to have come 2 days before the appointment.
The Event ID for this is: 31','1','1');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('118','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:30 pm on Tuesday July 20th. If you have any questions please call 2221212212. Thank you.','2010-07-19 15:10:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-20 13:30:00','31','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:30 pm on Tuesday July 20th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=IpaQ9GK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=-DKzkO9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=GP9aL94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-19 15:10:00 time of appointment:2010-07-20 13:30:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 31','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('119','1','0','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:30 pm on Tuesday July 20th. If you have any questions please call 2221212212. Thank you.','2010-07-19 15:14:00','1','1','3','0','0','2010-07-19 15:15:01','1','35','','2010-07-20 13:30:00','31','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:30 pm on Tuesday July 20th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=IpaQ9GK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=-DKzkO9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=GP9aL94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-19 15:14:00 time of appointment:2010-07-20 13:30:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 31','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('120','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:00 am on Monday July 19th. If you have any questions please call 2221212212. Thank you.','2010-07-17 15:11:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-19 10:00:00','32','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:00 am on Monday July 19th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=JpaK-JGK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=-NKz-OO9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=QP9-EL94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-17 15:11:00 time of appointment:2010-07-19 10:00:00
This is supposed to have come 2 days before the appointment.
The Event ID for this is: 32','1','1');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('153','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:00 am on Monday July 19th. If you have any questions please call 2221212212. Thank you.','2010-07-18 15:10:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-19 10:00:00','32','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:00 am on Monday July 19th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=JpaK-JGK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=-NKz-OO9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=QP9-EL94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-18 15:10:00 time of appointment:2010-07-19 10:00:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 32','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('154','1','0','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:00 am on Monday July 19th. If you have any questions please call 2221212212. Thank you.','2010-07-18 15:12:00','1','1','3','0','0','2010-07-18 15:13:02','1','36','','2010-07-19 10:00:00','32','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:00 am on Monday July 19th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=JpaK-JGK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=-NKz-OO9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=QP9-EL94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-18 15:12:00 time of appointment:2010-07-19 10:00:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 32','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('123','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 11:00 am on Tuesday July 20th. If you have any questions please call 2221212212. Thank you.','2010-07-17 15:07:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-20 11:00:00','33','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 11:00 am on Tuesday July 20th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=AzaO9QK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=-XKzQP9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=aP9GM94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-17 15:07:00 time of appointment:2010-07-20 11:00:00
This is supposed to have come 3 days before the appointment.
The Event ID for this is: 33','1','0');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('124','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 11:00 am on Tuesday July 20th. If you have any questions please call 2221212212. Thank you.','2010-07-18 15:13:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-20 11:00:00','33','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 11:00 am on Tuesday July 20th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=AzaO9QK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=-XKzQP9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=aP9GM94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-18 15:13:00 time of appointment:2010-07-20 11:00:00
This is supposed to have come 2 days before the appointment.
The Event ID for this is: 33','1','1');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('125','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 11:00 am on Tuesday July 20th. If you have any questions please call 2221212212. Thank you.','2010-07-19 15:18:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-20 11:00:00','33','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 11:00 am on Tuesday July 20th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=AzaO9QK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=-XKzQP9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=aP9GM94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-19 15:18:00 time of appointment:2010-07-20 11:00:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 33','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('126','1','0','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 11:00 am on Tuesday July 20th. If you have any questions please call 2221212212. Thank you.','2010-07-19 15:08:00','1','1','3','0','0','2010-07-19 15:09:01','1','36','','2010-07-20 11:00:00','33','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 11:00 am on Tuesday July 20th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=AzaO9QK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=-XKzQP9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=aP9GM94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-19 15:08:00 time of appointment:2010-07-20 11:00:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 33','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('127','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:15 am on Wednesday July 21st. If you have any questions please call 2221212212. Thank you.','2010-07-18 15:01:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-21 10:15:00','34','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:15 am on Wednesday July 21st with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=BzaS9QK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=-hKz4P9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=kP9uM94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-18 15:01:00 time of appointment:2010-07-21 10:15:00
This is supposed to have come 3 days before the appointment.
The Event ID for this is: 34','1','0');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('128','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:15 am on Wednesday July 21st. If you have any questions please call 2221212212. Thank you.','2010-07-19 15:11:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-21 10:15:00','34','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:15 am on Wednesday July 21st with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=BzaS9QK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=-hKz4P9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=kP9uM94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-19 15:11:00 time of appointment:2010-07-21 10:15:00
This is supposed to have come 2 days before the appointment.
The Event ID for this is: 34','1','1');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('129','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:15 am on Wednesday July 21st. If you have any questions please call 2221212212. Thank you.','2010-07-20 15:06:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-21 10:15:00','34','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:15 am on Wednesday July 21st with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=BzaS9QK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=-hKz4P9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=kP9uM94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-20 15:06:00 time of appointment:2010-07-21 10:15:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 34','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('130','1','0','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:15 am on Wednesday July 21st. If you have any questions please call 2221212212. Thank you.','2010-07-20 15:14:00','1','1','3','0','0','2010-07-20 15:15:01','1','36','','2010-07-21 10:15:00','34','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:15 am on Wednesday July 21st with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=BzaS9QK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=-hKz4P9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=kP9uM94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-20 15:14:00 time of appointment:2010-07-21 10:15:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 34','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('131','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 2:30 pm on Wednesday July 21st. If you have any questions please call 2221212212. Thank you.','2010-07-18 15:03:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-21 14:30:00','35','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 2:30 pm on Wednesday July 21st with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=CzaM9aK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=GKz-hQ9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=uP9-XN94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-18 15:03:00 time of appointment:2010-07-21 14:30:00
This is supposed to have come 3 days before the appointment.
The Event ID for this is: 35','1','0');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('132','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 2:30 pm on Wednesday July 21st. If you have any questions please call 2221212212. Thank you.','2010-07-19 15:11:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-21 14:30:00','35','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 2:30 pm on Wednesday July 21st with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=CzaM9aK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=GKz-hQ9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=uP9-XN94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-19 15:11:00 time of appointment:2010-07-21 14:30:00
This is supposed to have come 2 days before the appointment.
The Event ID for this is: 35','1','1');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('133','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 2:30 pm on Wednesday July 21st. If you have any questions please call 2221212212. Thank you.','2010-07-20 15:20:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-21 14:30:00','35','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 2:30 pm on Wednesday July 21st with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=CzaM9aK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=GKz-hQ9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=uP9-XN94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-20 15:20:00 time of appointment:2010-07-21 14:30:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 35','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('134','1','0','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 2:30 pm on Wednesday July 21st. If you have any questions please call 2221212212. Thank you.','2010-07-20 15:08:00','1','1','3','0','0','2010-07-20 15:09:01','1','35','','2010-07-21 14:30:00','35','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 2:30 pm on Wednesday July 21st with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=CzaM9aK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=GKz-hQ9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=uP9-XN94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-20 15:08:00 time of appointment:2010-07-21 14:30:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 35','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('135','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 2:00 pm on Thursday July 22nd. If you have any questions please call 2221212212. Thank you.','2010-07-19 15:04:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-22 14:00:00','36','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 2:00 pm on Thursday July 22nd with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=DzaQ9aK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=QKzkQ9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=4P9aN94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-19 15:04:00 time of appointment:2010-07-22 14:00:00
This is supposed to have come 3 days before the appointment.
The Event ID for this is: 36','1','0');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('136','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 2:00 pm on Thursday July 22nd. If you have any questions please call 2221212212. Thank you.','2010-07-20 15:05:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-22 14:00:00','36','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 2:00 pm on Thursday July 22nd with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=DzaQ9aK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=QKzkQ9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=4P9aN94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-20 15:05:00 time of appointment:2010-07-22 14:00:00
This is supposed to have come 2 days before the appointment.
The Event ID for this is: 36','1','1');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('137','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 2:00 pm on Thursday July 22nd. If you have any questions please call 2221212212. Thank you.','2010-07-21 15:10:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-22 14:00:00','36','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 2:00 pm on Thursday July 22nd with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=DzaQ9aK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=QKzkQ9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=4P9aN94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-21 15:10:00 time of appointment:2010-07-22 14:00:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 36','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('138','1','0','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 2:00 pm on Thursday July 22nd. If you have any questions please call 2221212212. Thank you.','2010-07-21 15:19:00','1','1','3','0','0','2010-07-21 15:19:01','1','35','','2010-07-22 14:00:00','36','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 2:00 pm on Thursday July 22nd with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=DzaQ9aK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=QKzkQ9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=4P9aN94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-21 15:19:00 time of appointment:2010-07-22 14:00:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 36','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('139','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 11:15 am on Thursday July 22nd. If you have any questions please call 2221212212. Thank you.','2010-07-19 15:03:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-22 11:15:00','37','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 11:15 am on Thursday July 22nd with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=EzaK-JaK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=aKz-OQ9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-EP9-EN94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-19 15:03:00 time of appointment:2010-07-22 11:15:00
This is supposed to have come 3 days before the appointment.
The Event ID for this is: 37','1','0');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('140','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 11:15 am on Thursday July 22nd. If you have any questions please call 2221212212. Thank you.','2010-07-20 15:07:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-22 11:15:00','37','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 11:15 am on Thursday July 22nd with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=EzaK-JaK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=aKz-OQ9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-EP9-EN94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-20 15:07:00 time of appointment:2010-07-22 11:15:00
This is supposed to have come 2 days before the appointment.
The Event ID for this is: 37','1','1');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('141','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 11:15 am on Thursday July 22nd. If you have any questions please call 2221212212. Thank you.','2010-07-21 15:04:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-22 11:15:00','37','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 11:15 am on Thursday July 22nd with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=EzaK-JaK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=aKz-OQ9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-EP9-EN94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-21 15:04:00 time of appointment:2010-07-22 11:15:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 37','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('142','1','0','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 11:15 am on Thursday July 22nd. If you have any questions please call 2221212212. Thank you.','2010-07-21 15:00:00','1','3','2','0','0','2010-07-22 03:25:01','1','36','','2010-07-22 11:15:00','37','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 11:15 am on Thursday July 22nd with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=EzaK-JaK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=aKz-OQ9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-EP9-EN94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-21 15:00:00 time of appointment:2010-07-22 11:15:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 37','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('143','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:45 am on Friday July 23rd. If you have any questions please call 2221212212. Thank you.','2010-07-20 15:06:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-23 10:45:00','38','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:45 am on Friday July 23rd with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=FzaO9kK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=kKzQR9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-OP9GO94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-20 15:06:00 time of appointment:2010-07-23 10:45:00
This is supposed to have come 3 days before the appointment.
The Event ID for this is: 38','1','0');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('144','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:45 am on Friday July 23rd. If you have any questions please call 2221212212. Thank you.','2010-07-21 15:01:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-23 10:45:00','38','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:45 am on Friday July 23rd with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=FzaO9kK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=kKzQR9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-OP9GO94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-21 15:01:00 time of appointment:2010-07-23 10:45:00
This is supposed to have come 2 days before the appointment.
The Event ID for this is: 38','1','1');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('145','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:45 am on Friday July 23rd. If you have any questions please call 2221212212. Thank you.','2010-07-22 15:11:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-23 10:45:00','38','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:45 am on Friday July 23rd with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=FzaO9kK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=kKzQR9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-OP9GO94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-22 15:11:00 time of appointment:2010-07-23 10:45:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 38','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('146','1','0','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:45 am on Friday July 23rd. If you have any questions please call 2221212212. Thank you.','2010-07-22 15:00:00','1','2','3','0','0','2010-07-22 20:07:58','1','35','','2010-07-23 10:45:00','38','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:45 am on Friday July 23rd with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=FzaO9kK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=kKzQR9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-OP9GO94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-22 15:00:00 time of appointment:2010-07-23 10:45:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 38','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('147','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:45 pm on Friday July 23rd. If you have any questions please call 2221212212. Thank you.','2010-07-20 15:07:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-23 13:45:00','39','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:45 pm on Friday July 23rd with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=GzaS9kK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=uKz4R9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-YP9uO94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-20 15:07:00 time of appointment:2010-07-23 13:45:00
This is supposed to have come 3 days before the appointment.
The Event ID for this is: 39','1','0');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('148','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:45 pm on Friday July 23rd. If you have any questions please call 2221212212. Thank you.','2010-07-21 15:16:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-23 13:45:00','39','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:45 pm on Friday July 23rd with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=GzaS9kK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=uKz4R9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-YP9uO94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-21 15:16:00 time of appointment:2010-07-23 13:45:00
This is supposed to have come 2 days before the appointment.
The Event ID for this is: 39','1','1');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('149','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:45 pm on Friday July 23rd. If you have any questions please call 2221212212. Thank you.','2010-07-22 15:09:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-23 13:45:00','39','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:45 pm on Friday July 23rd with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=GzaS9kK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=uKz4R9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-YP9uO94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-22 15:09:00 time of appointment:2010-07-23 13:45:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 39','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('150','1','0','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:45 pm on Friday July 23rd. If you have any questions please call 2221212212. Thank you.','2010-07-22 15:07:00','1','2','3','0','0','2010-07-22 20:07:58','1','36','','2010-07-23 13:45:00','39','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:45 pm on Friday July 23rd with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=GzaS9kK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=uKz4R9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-YP9uO94O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-22 15:07:00 time of appointment:2010-07-23 13:45:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 39','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('155','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 9:45 am on Monday July 26th. If you have any questions please call 2221212212. Thank you.','2010-07-23 15:15:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-26 09:45:00','243','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 9:45 am on Monday July 26th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=AzkQ94S9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=-XLzkT9-OM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=aQ9aQ9lO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-23 15:15:00 time of appointment:2010-07-26 09:45:00
This is supposed to have come 3 days before the appointment.
The Event ID for this is: 243','1','0');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('156','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 9:45 am on Monday July 26th. If you have any questions please call 2221212212. Thank you.','2010-07-24 15:01:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-26 09:45:00','243','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 9:45 am on Monday July 26th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=AzkQ94S9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=-XLzkT9-OM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=aQ9aQ9lO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-24 15:01:00 time of appointment:2010-07-26 09:45:00
This is supposed to have come 2 days before the appointment.
The Event ID for this is: 243','1','1');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('157','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 9:45 am on Monday July 26th. If you have any questions please call 2221212212. Thank you.','2010-07-25 15:20:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-26 09:45:00','243','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 9:45 am on Monday July 26th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=AzkQ94S9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=-XLzkT9-OM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=aQ9aQ9lO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-25 15:20:00 time of appointment:2010-07-26 09:45:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 243','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('158','1','0','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 9:45 am on Monday July 26th. If you have any questions please call 2221212212. Thank you.','2010-07-25 15:12:00','1','1','3','0','0','2010-07-25 15:13:01','1','36','','2010-07-26 09:45:00','243','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 9:45 am on Monday July 26th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=AzkQ94S9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=-XLzkT9-OM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=aQ9aQ9lO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-25 15:12:00 time of appointment:2010-07-26 09:45:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 243','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('159','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 11:00 am on Monday July 26th. If you have any questions please call 2221212212. Thank you.','2010-07-23 15:04:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-26 11:00:00','244','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 11:00 am on Monday July 26th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=BzkK-J4S9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=-hLz-OT9-OM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=kQ9-EQ9lO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-23 15:04:00 time of appointment:2010-07-26 11:00:00
This is supposed to have come 3 days before the appointment.
The Event ID for this is: 244','1','0');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('160','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 11:00 am on Monday July 26th. If you have any questions please call 2221212212. Thank you.','2010-07-24 15:14:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-26 11:00:00','244','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 11:00 am on Monday July 26th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=BzkK-J4S9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=-hLz-OT9-OM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=kQ9-EQ9lO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-24 15:14:00 time of appointment:2010-07-26 11:00:00
This is supposed to have come 2 days before the appointment.
The Event ID for this is: 244','1','1');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('161','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 11:00 am on Monday July 26th. If you have any questions please call 2221212212. Thank you.','2010-07-25 15:15:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-26 11:00:00','244','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 11:00 am on Monday July 26th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=BzkK-J4S9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=-hLz-OT9-OM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=kQ9-EQ9lO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-25 15:15:00 time of appointment:2010-07-26 11:00:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 244','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('162','1','0','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 11:00 am on Monday July 26th. If you have any questions please call 2221212212. Thank you.','2010-07-25 15:02:00','1','1','3','0','0','2010-07-25 15:03:01','1','35','','2010-07-26 11:00:00','244','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 11:00 am on Monday July 26th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=BzkK-J4S9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=-hLz-OT9-OM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=kQ9-EQ9lO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-25 15:02:00 time of appointment:2010-07-26 11:00:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 244','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('170','1','0','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Tuesday July 27th. If you have any questions please call 2221212212. Thank you.','2010-07-26 15:11:00','1','1','3','0','0','2010-07-26 15:11:04','1','36','','2010-07-27 13:15:00','246','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Tuesday July 27th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=DzkS9-ES9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=QLz4K-J-OM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=4Q9uR9lO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-26 15:11:00 time of appointment:2010-07-27 13:15:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 246','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('169','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Tuesday July 27th. If you have any questions please call 2221212212. Thank you.','2010-07-26 15:20:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-27 13:15:00','246','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Tuesday July 27th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=DzkS9-ES9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=QLz4K-J-OM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=4Q9uR9lO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-26 15:20:00 time of appointment:2010-07-27 13:15:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 246','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('168','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Tuesday July 27th. If you have any questions please call 2221212212. Thank you.','2010-07-25 15:03:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-27 13:15:00','246','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Tuesday July 27th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=DzkS9-ES9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=QLz4K-J-OM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=4Q9uR9lO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-25 15:03:00 time of appointment:2010-07-27 13:15:00
This is supposed to have come 2 days before the appointment.
The Event ID for this is: 246','1','1');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('167','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Tuesday July 27th. If you have any questions please call 2221212212. Thank you.','2010-07-24 15:08:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-27 13:15:00','246','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Tuesday July 27th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=DzkS9-ES9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=QLz4K-J-OM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=4Q9uR9lO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-24 15:08:00 time of appointment:2010-07-27 13:15:00
This is supposed to have come 3 days before the appointment.
The Event ID for this is: 246','1','0');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('171','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 2:45 pm on Tuesday July 27th. If you have any questions please call 2221212212. Thank you.','2010-07-24 15:09:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-27 14:45:00','247','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 2:45 pm on Tuesday July 27th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=EzkM9-OS9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=aLz-hL-J-OM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-EQ9-XS9lO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-24 15:09:00 time of appointment:2010-07-27 14:45:00
This is supposed to have come 3 days before the appointment.
The Event ID for this is: 247','1','0');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('172','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 2:45 pm on Tuesday July 27th. If you have any questions please call 2221212212. Thank you.','2010-07-25 15:15:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-27 14:45:00','247','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 2:45 pm on Tuesday July 27th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=EzkM9-OS9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=aLz-hL-J-OM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-EQ9-XS9lO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-25 15:15:00 time of appointment:2010-07-27 14:45:00
This is supposed to have come 2 days before the appointment.
The Event ID for this is: 247','1','1');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('173','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 2:45 pm on Tuesday July 27th. If you have any questions please call 2221212212. Thank you.','2010-07-26 15:16:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-27 14:45:00','247','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 2:45 pm on Tuesday July 27th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=EzkM9-OS9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=aLz-hL-J-OM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-EQ9-XS9lO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-26 15:16:00 time of appointment:2010-07-27 14:45:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 247','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('174','1','0','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 2:45 pm on Tuesday July 27th. If you have any questions please call 2221212212. Thank you.','2010-07-26 15:16:00','1','1','3','0','0','2010-07-26 15:17:01','1','35','','2010-07-27 14:45:00','247','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 2:45 pm on Tuesday July 27th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=EzkM9-OS9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=aLz-hL-J-OM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-EQ9-XS9lO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-26 15:16:00 time of appointment:2010-07-27 14:45:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 247','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('175','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Wednesday July 28th. If you have any questions please call 2221212212. Thank you.','2010-07-25 15:03:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-28 13:15:00','248','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Wednesday July 28th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=FzkQ9-OS9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=kLzkL-J-OM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-OQ9aS9lO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-25 15:03:00 time of appointment:2010-07-28 13:15:00
This is supposed to have come 3 days before the appointment.
The Event ID for this is: 248','1','0');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('176','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Wednesday July 28th. If you have any questions please call 2221212212. Thank you.','2010-07-26 15:12:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-28 13:15:00','248','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Wednesday July 28th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=FzkQ9-OS9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=kLzkL-J-OM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-OQ9aS9lO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-26 15:12:00 time of appointment:2010-07-28 13:15:00
This is supposed to have come 2 days before the appointment.
The Event ID for this is: 248','1','1');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('177','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Wednesday July 28th. If you have any questions please call 2221212212. Thank you.','2010-07-27 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-28 13:15:00','248','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Wednesday July 28th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=FzkQ9-OS9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=kLzkL-J-OM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-OQ9aS9lO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-27 15:00:00 time of appointment:2010-07-28 13:15:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 248','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('178','1','0','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Wednesday July 28th. If you have any questions please call 2221212212. Thank you.','2010-07-27 15:16:00','1','1','3','0','0','2010-07-27 15:17:01','1','36','','2010-07-28 13:15:00','248','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Wednesday July 28th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=FzkQ9-OS9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=kLzkL-J-OM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-OQ9aS9lO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-27 15:16:00 time of appointment:2010-07-28 13:15:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 248','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('179','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Wednesday July 28th. If you have any questions please call 2221212212. Thank you.','2010-07-25 15:05:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-28 13:15:00','249','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Wednesday July 28th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=GzkK-J-OS9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=uLz-OL-J-OM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-YQ9-ES9lO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-25 15:05:00 time of appointment:2010-07-28 13:15:00
This is supposed to have come 3 days before the appointment.
The Event ID for this is: 249','1','0');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('180','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Wednesday July 28th. If you have any questions please call 2221212212. Thank you.','2010-07-26 15:18:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-28 13:15:00','249','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Wednesday July 28th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=GzkK-J-OS9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=uLz-OL-J-OM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-YQ9-ES9lO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-26 15:18:00 time of appointment:2010-07-28 13:15:00
This is supposed to have come 2 days before the appointment.
The Event ID for this is: 249','1','1');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('181','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Wednesday July 28th. If you have any questions please call 2221212212. Thank you.','2010-07-27 15:07:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-28 13:15:00','249','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Wednesday July 28th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=GzkK-J-OS9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=uLz-OL-J-OM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-YQ9-ES9lO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-27 15:07:00 time of appointment:2010-07-28 13:15:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 249','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('182','1','0','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Wednesday July 28th. If you have any questions please call 2221212212. Thank you.','2010-07-27 15:05:00','1','1','3','0','0','2010-07-27 15:05:01','1','35','','2010-07-28 13:15:00','249','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Wednesday July 28th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=GzkK-J-OS9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=uLz-OL-J-OM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=-YQ9-ES9lO9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-27 15:05:00 time of appointment:2010-07-28 13:15:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 249','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('183','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Wednesday July 28th. If you have any questions please call 2221212212. Thank you.','2010-07-25 15:13:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-28 13:15:00','250','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Wednesday July 28th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=3MzQM9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=DzGTp-hM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=HpuO9-XTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-25 15:13:00 time of appointment:2010-07-28 13:15:00
This is supposed to have come 3 days before the appointment.
The Event ID for this is: 250','1','0');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('184','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Wednesday July 28th. If you have any questions please call 2221212212. Thank you.','2010-07-26 15:05:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-28 13:15:00','250','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Wednesday July 28th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=3MzQM9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=DzGTp-hM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=HpuO9-XTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-26 15:05:00 time of appointment:2010-07-28 13:15:00
This is supposed to have come 2 days before the appointment.
The Event ID for this is: 250','1','1');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('185','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Wednesday July 28th. If you have any questions please call 2221212212. Thank you.','2010-07-27 15:11:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-28 13:15:00','250','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Wednesday July 28th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=3MzQM9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=DzGTp-hM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=HpuO9-XTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-27 15:11:00 time of appointment:2010-07-28 13:15:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 250','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('186','1','0','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Wednesday July 28th. If you have any questions please call 2221212212. Thank you.','2010-07-27 15:07:00','1','1','3','0','0','2010-07-27 15:07:02','1','35','','2010-07-28 13:15:00','250','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 1:15 pm on Wednesday July 28th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=3MzQM9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=DzGTp-hM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=HpuO9-XTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-27 15:07:00 time of appointment:2010-07-28 13:15:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 250','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('187','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 11:15 am on Thursday July 29th. If you have any questions please call 2221212212. Thank you.','2010-07-26 15:18:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-29 11:15:00','251','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 11:15 am on Thursday July 29th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=-DMz4M9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=EzGNz-hM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=IpuS9-XTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-26 15:18:00 time of appointment:2010-07-29 11:15:00
This is supposed to have come 3 days before the appointment.
The Event ID for this is: 251','1','0');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('188','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 11:15 am on Thursday July 29th. If you have any questions please call 2221212212. Thank you.','2010-07-27 15:03:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-29 11:15:00','251','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 11:15 am on Thursday July 29th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=-DMz4M9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=EzGNz-hM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=IpuS9-XTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-27 15:03:00 time of appointment:2010-07-29 11:15:00
This is supposed to have come 2 days before the appointment.
The Event ID for this is: 251','1','1');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('189','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 11:15 am on Thursday July 29th. If you have any questions please call 2221212212. Thank you.','2010-07-28 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-29 11:15:00','251','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 11:15 am on Thursday July 29th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=-DMz4M9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=EzGNz-hM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=IpuS9-XTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-28 15:00:00 time of appointment:2010-07-29 11:15:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 251','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('190','1','0','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 11:15 am on Thursday July 29th. If you have any questions please call 2221212212. Thank you.','2010-07-28 15:04:00','1','1','3','0','0','2010-07-28 15:05:01','1','35','','2010-07-29 11:15:00','251','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 11:15 am on Thursday July 29th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=-DMz4M9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=EzGNz-hM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=IpuS9-XTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-28 15:04:00 time of appointment:2010-07-29 11:15:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 251','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('191','0','1','','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 11:15 am on Thursday July 29th. If you have any questions please call 2221212212. Thank you.','2010-07-26 15:05:00','1','0','1','0','0','0000-00-00 00:00:00','1','19','','2010-07-29 11:15:00','252','Dear anita hayes,

This is a message from Worthington Medical Facility reminding you of your appointment for 11:15 am on Thursday July 29th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=-NMz-hN9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=FzGRpGM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=JpuM9-hTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-26 15:05:00 time of appointment:2010-07-29 11:15:00
This is supposed to have come 3 days before the appointment.
The Event ID for this is: 252','1','0');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('192','0','1','','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 11:15 am on Thursday July 29th. If you have any questions please call 2221212212. Thank you.','2010-07-27 15:10:00','1','0','1','0','0','0000-00-00 00:00:00','1','19','','2010-07-29 11:15:00','252','Dear anita hayes,

This is a message from Worthington Medical Facility reminding you of your appointment for 11:15 am on Thursday July 29th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=-NMz-hN9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=FzGRpGM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=JpuM9-hTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-27 15:10:00 time of appointment:2010-07-29 11:15:00
This is supposed to have come 2 days before the appointment.
The Event ID for this is: 252','1','1');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('193','0','1','','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 11:15 am on Thursday July 29th. If you have any questions please call 2221212212. Thank you.','2010-07-28 15:07:00','1','0','1','0','0','0000-00-00 00:00:00','1','19','','2010-07-29 11:15:00','252','Dear anita hayes,

This is a message from Worthington Medical Facility reminding you of your appointment for 11:15 am on Thursday July 29th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=-NMz-hN9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=FzGRpGM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=JpuM9-hTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-28 15:07:00 time of appointment:2010-07-29 11:15:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 252','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('194','1','0','','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 11:15 am on Thursday July 29th. If you have any questions please call 2221212212. Thank you.','2010-07-28 15:01:00','1','3','2','0','0','2010-07-28 17:07:02','1','19','','2010-07-29 11:15:00','252','Dear anita hayes,

This is a message from Worthington Medical Facility reminding you of your appointment for 11:15 am on Thursday July 29th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=-NMz-hN9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=FzGRpGM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=JpuM9-hTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-28 15:01:00 time of appointment:2010-07-29 11:15:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 252','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('195','0','1','','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 11:45 am on Thursday July 29th. If you have any questions please call 2221212212. Thank you.','2010-07-26 15:09:00','1','0','1','0','0','0000-00-00 00:00:00','1','17','','2010-07-29 11:45:00','253','Dear Valerie Peters,

This is a message from Worthington Medical Facility reminding you of your appointment for 11:45 am on Thursday July 29th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=-XMzkN9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=GzGLzGM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=AzuQ9-hTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-26 15:09:00 time of appointment:2010-07-29 11:45:00
This is supposed to have come 3 days before the appointment.
The Event ID for this is: 253','1','0');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('196','0','1','','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 11:45 am on Thursday July 29th. If you have any questions please call 2221212212. Thank you.','2010-07-27 15:01:00','1','0','1','0','0','0000-00-00 00:00:00','1','17','','2010-07-29 11:45:00','253','Dear Valerie Peters,

This is a message from Worthington Medical Facility reminding you of your appointment for 11:45 am on Thursday July 29th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=-XMzkN9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=GzGLzGM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=AzuQ9-hTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-27 15:01:00 time of appointment:2010-07-29 11:45:00
This is supposed to have come 2 days before the appointment.
The Event ID for this is: 253','1','1');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('197','0','1','','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 11:45 am on Thursday July 29th. If you have any questions please call 2221212212. Thank you.','2010-07-28 15:13:00','1','0','1','0','0','0000-00-00 00:00:00','1','17','','2010-07-29 11:45:00','253','Dear Valerie Peters,

This is a message from Worthington Medical Facility reminding you of your appointment for 11:45 am on Thursday July 29th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=-XMzkN9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=GzGLzGM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=AzuQ9-hTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-28 15:13:00 time of appointment:2010-07-29 11:45:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 253','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('198','1','0','','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 11:45 am on Thursday July 29th. If you have any questions please call 2221212212. Thank you.','2010-07-28 15:06:00','1','3','2','0','0','2010-07-28 17:15:01','1','17','','2010-07-29 11:45:00','253','Dear Valerie Peters,

This is a message from Worthington Medical Facility reminding you of your appointment for 11:45 am on Thursday July 29th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=-XMzkN9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=GzGLzGM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=AzuQ9-hTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-28 15:06:00 time of appointment:2010-07-29 11:45:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 253','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('199','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:30 am on Friday July 30th. If you have any questions please call 2221212212. Thank you.','2010-07-27 15:19:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-30 10:30:00','254','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:30 am on Friday July 30th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=-hMz-ON9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=HzGPzGM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=BzuK-J-hTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-27 15:19:00 time of appointment:2010-07-30 10:30:00
This is supposed to have come 3 days before the appointment.
The Event ID for this is: 254','1','0');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('200','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:30 am on Friday July 30th. If you have any questions please call 2221212212. Thank you.','2010-07-28 15:07:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-30 10:30:00','254','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:30 am on Friday July 30th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=-hMz-ON9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=HzGPzGM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=BzuK-J-hTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-28 15:07:00 time of appointment:2010-07-30 10:30:00
This is supposed to have come 2 days before the appointment.
The Event ID for this is: 254','1','1');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('201','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:30 am on Friday July 30th. If you have any questions please call 2221212212. Thank you.','2010-07-29 15:11:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-07-30 10:30:00','254','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:30 am on Friday July 30th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=-hMz-ON9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=HzGPzGM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=BzuK-J-hTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-29 15:11:00 time of appointment:2010-07-30 10:30:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 254','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('202','1','0','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:30 am on Friday July 30th. If you have any questions please call 2221212212. Thank you.','2010-07-29 15:13:00','1','1','3','0','0','2010-07-29 15:13:02','1','35','','2010-07-30 10:30:00','254','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:30 am on Friday July 30th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=-hMz-ON9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=HzGPzGM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=BzuK-J-hTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-29 15:13:00 time of appointment:2010-07-30 10:30:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 254','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('203','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:45 am on Friday July 30th. If you have any questions please call 2221212212. Thank you.','2010-07-27 15:20:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-30 10:45:00','255','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:45 am on Friday July 30th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=GMzQO9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=IzGTpQM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=CzuO9GTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-27 15:20:00 time of appointment:2010-07-30 10:45:00
This is supposed to have come 3 days before the appointment.
The Event ID for this is: 255','1','0');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('204','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:45 am on Friday July 30th. If you have any questions please call 2221212212. Thank you.','2010-07-28 15:13:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-30 10:45:00','255','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:45 am on Friday July 30th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=GMzQO9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=IzGTpQM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=CzuO9GTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-28 15:13:00 time of appointment:2010-07-30 10:45:00
This is supposed to have come 2 days before the appointment.
The Event ID for this is: 255','1','1');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('205','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:45 am on Friday July 30th. If you have any questions please call 2221212212. Thank you.','2010-07-29 15:14:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-30 10:45:00','255','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:45 am on Friday July 30th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=GMzQO9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=IzGTpQM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=CzuO9GTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-29 15:14:00 time of appointment:2010-07-30 10:45:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 255','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('206','1','0','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:45 am on Friday July 30th. If you have any questions please call 2221212212. Thank you.','2010-07-29 15:19:00','1','1','3','0','0','2010-07-29 15:19:02','1','36','','2010-07-30 10:45:00','255','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:45 am on Friday July 30th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=GMzQO9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=IzGTpQM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=CzuO9GTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-29 15:19:00 time of appointment:2010-07-30 10:45:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 255','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('207','0','1','','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 12:15 pm on Thursday July 29th. If you have any questions please call 2221212212. Thank you.','2010-07-26 15:13:00','1','0','1','0','0','0000-00-00 00:00:00','1','26','','2010-07-29 12:15:00','256','Dear Fredrick Ulster,

This is a message from Worthington Medical Facility reminding you of your appointment for 12:15 pm on Thursday July 29th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=QMz4O9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=JzGNzQM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=DzuS9GTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-26 15:13:00 time of appointment:2010-07-29 12:15:00
This is supposed to have come 3 days before the appointment.
The Event ID for this is: 256','1','0');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('208','0','1','','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 12:15 pm on Thursday July 29th. If you have any questions please call 2221212212. Thank you.','2010-07-27 15:13:00','1','0','1','0','0','0000-00-00 00:00:00','1','26','','2010-07-29 12:15:00','256','Dear Fredrick Ulster,

This is a message from Worthington Medical Facility reminding you of your appointment for 12:15 pm on Thursday July 29th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=QMz4O9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=JzGNzQM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=DzuS9GTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-27 15:13:00 time of appointment:2010-07-29 12:15:00
This is supposed to have come 2 days before the appointment.
The Event ID for this is: 256','1','1');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('209','0','1','','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 12:15 pm on Thursday July 29th. If you have any questions please call 2221212212. Thank you.','2010-07-28 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','26','','2010-07-29 12:15:00','256','Dear Fredrick Ulster,

This is a message from Worthington Medical Facility reminding you of your appointment for 12:15 pm on Thursday July 29th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=QMz4O9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=JzGNzQM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=DzuS9GTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-28 15:00:00 time of appointment:2010-07-29 12:15:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 256','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('210','1','0','','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 12:15 pm on Thursday July 29th. If you have any questions please call 2221212212. Thank you.','2010-07-28 15:15:00','1','3','2','0','0','2010-07-28 17:23:01','1','26','','2010-07-29 12:15:00','256','Dear Fredrick Ulster,

This is a message from Worthington Medical Facility reminding you of your appointment for 12:15 pm on Thursday July 29th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=QMz4O9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=JzGNzQM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=DzuS9GTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-28 15:15:00 time of appointment:2010-07-29 12:15:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 256','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('211','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 12:00 pm on Thursday July 29th. If you have any questions please call 2221212212. Thank you.','2010-07-26 15:09:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-29 12:00:00','257','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 12:00 pm on Thursday July 29th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=aMz-hP9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=A9GRpaM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=EzuM9QTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-26 15:09:00 time of appointment:2010-07-29 12:00:00
This is supposed to have come 3 days before the appointment.
The Event ID for this is: 257','1','0');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('212','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 12:00 pm on Thursday July 29th. If you have any questions please call 2221212212. Thank you.','2010-07-27 15:08:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-29 12:00:00','257','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 12:00 pm on Thursday July 29th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=aMz-hP9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=A9GRpaM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=EzuM9QTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-27 15:08:00 time of appointment:2010-07-29 12:00:00
This is supposed to have come 2 days before the appointment.
The Event ID for this is: 257','1','1');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('213','0','1','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 12:00 pm on Thursday July 29th. If you have any questions please call 2221212212. Thank you.','2010-07-28 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','36','','2010-07-29 12:00:00','257','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 12:00 pm on Thursday July 29th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=aMz-hP9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=A9GRpaM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=EzuM9QTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-28 15:00:00 time of appointment:2010-07-29 12:00:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 257','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('214','1','0','18452465599','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 12:00 pm on Thursday July 29th. If you have any questions please call 2221212212. Thank you.','2010-07-28 15:12:00','1','1','3','0','0','2010-07-28 15:13:01','1','36','','2010-07-29 12:00:00','257','Dear David Spitler,

This is a message from Worthington Medical Facility reminding you of your appointment for 12:00 pm on Thursday July 29th with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=aMz-hP9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=A9GRpaM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=EzuM9QTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-28 15:12:00 time of appointment:2010-07-29 12:00:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 257','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('215','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:15 am on Monday August 2nd. If you have any questions please call 2221212212. Thank you.','2010-07-30 15:03:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-08-02 10:15:00','258','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:15 am on Monday August 2nd with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=kMzkP9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=B9GLzaM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=FzuQ9QTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-30 15:03:00 time of appointment:2010-08-02 10:15:00
This is supposed to have come 3 days before the appointment.
The Event ID for this is: 258','1','0');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('216','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:15 am on Monday August 2nd. If you have any questions please call 2221212212. Thank you.','2010-07-31 15:05:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-08-02 10:15:00','258','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:15 am on Monday August 2nd with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=kMzkP9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=B9GLzaM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=FzuQ9QTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-07-31 15:05:00 time of appointment:2010-08-02 10:15:00
This is supposed to have come 2 days before the appointment.
The Event ID for this is: 258','1','1');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('217','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:15 am on Monday August 2nd. If you have any questions please call 2221212212. Thank you.','2010-08-01 15:16:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-08-02 10:15:00','258','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:15 am on Monday August 2nd with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=kMzkP9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=B9GLzaM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=FzuQ9QTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-08-01 15:16:00 time of appointment:2010-08-02 10:15:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 258','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('218','1','0','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:15 am on Monday August 2nd. If you have any questions please call 2221212212. Thank you.','2010-08-01 15:05:00','1','1','3','0','0','2010-08-01 15:05:02','1','35','','2010-08-02 10:15:00','258','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:15 am on Monday August 2nd with Dr. Thor Walker. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=kMzkP9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=B9GLzaM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=FzuQ9QTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility

DEBUGGING:
time to call or email:2010-08-01 15:05:00 time of appointment:2010-08-02 10:15:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 258','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('219','1','0','19176504575','-5','This is a call from OppyDental reminding you of your appointment for 10:30 am on Friday July 30th. If you have any questions please call 9176504575. Thank you.','2010-07-30 00:00:00','1','1','3','0','0','2010-07-30 00:01:01','13','38','','2010-07-30 10:30:00','259','Dear Fred  Funk,

This is a message from OppyDental reminding you of your appointment for 10:30 am on Friday July 30th with Dr. Flubberbein. If you have any questions please call 9176504575.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=uMz-OP9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=C9GPzaM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=GzuK-JQTz4O9LXp-TdCbNW

Thank you.
OppyDental

DEBUGGING:
time to call or email:2010-07-30 00:00:00 time of appointment:2010-07-30 10:30:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 259','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('220','1','0','18452465599','-5','This is a call from OppyDental reminding you of your appointment for 1:30 pm on Friday July 30th. If you have any questions please call 9176504575. Thank you.','2010-07-30 00:01:00','1','1','3','0','0','2010-07-30 00:01:03','13','39','','2010-07-30 13:30:00','260','Dear John Claridge,

This is a message from OppyDental reminding you of your appointment for 1:30 pm on Friday July 30th with Dr. Flubberbein. If you have any questions please call 9176504575.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=3NzQQ9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=DzQTpkM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=Hp4O9aTz4O9LXp-TdCbNW

Thank you.
OppyDental

DEBUGGING:
time to call or email:2010-07-30 00:01:00 time of appointment:2010-07-30 13:30:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 260','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('221','0','1','18452465599','-5','This is a call from OppyDental reminding you of your appointment for 9:45 am on Monday August 2nd. If you have any questions please call 9176504575. Thank you.','2010-07-31 00:13:00','1','0','1','0','0','0000-00-00 00:00:00','13','39','','2010-08-02 09:45:00','261','Dear John Claridge,

This is a message from OppyDental reminding you of your appointment for 9:45 am on Monday August 2nd with Dr. Flubberbein. If you have any questions please call 9176504575.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=-DNz4Q9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=EzQNzkM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=Ip4S9aTz4O9LXp-TdCbNW

Thank you.
OppyDental

DEBUGGING:
time to call or email:2010-07-31 00:13:00 time of appointment:2010-08-02 09:45:00
This is supposed to have come 3 days before the appointment.
The Event ID for this is: 261','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('222','1','0','18452465599','-5','This is a call from OppyDental reminding you of your appointment for 9:45 am on Monday August 2nd. If you have any questions please call 9176504575. Thank you.','2010-08-02 00:19:00','1','1','3','0','0','2010-08-02 00:19:01','13','39','','2010-08-02 09:45:00','261','Dear John Claridge,

This is a message from OppyDental reminding you of your appointment for 9:45 am on Monday August 2nd with Dr. Flubberbein. If you have any questions please call 9176504575.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=-DNz4Q9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=EzQNzkM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=Ip4S9aTz4O9LXp-TdCbNW

Thank you.
OppyDental

DEBUGGING:
time to call or email:2010-08-02 00:19:00 time of appointment:2010-08-02 09:45:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 261','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('223','1','0','18452465599','-5','This is a call from OppyDental reminding you of your appointment for 1:30 pm on Friday July 30th. If you have any questions please call 9176504575. Thank you.','2010-07-30 00:04:00','1','1','3','0','0','2010-07-30 00:05:01','13','39','','2010-07-30 13:30:00','262','Dear John Claridge,

This is a message from OppyDental reminding you of your appointment for 1:30 pm on Friday July 30th with Dr. Flubberbein. If you have any questions please call 9176504575.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=-NNz-hR9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=FzQRpuM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=Jp4M9kTz4O9LXp-TdCbNW

Thank you.
OppyDental

DEBUGGING:
time to call or email:2010-07-30 00:04:00 time of appointment:2010-07-30 13:30:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 262','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('224','0','1','19176504575','-5','This is a call from OppyDental reminding you of your appointment for 10:15 am on Monday August 2nd. If you have any questions please call 9176504575. Thank you.','2010-07-31 00:04:00','1','0','1','0','0','0000-00-00 00:00:00','13','38','','2010-08-02 10:15:00','263','Dear Fred  Funk,

This is a message from OppyDental reminding you of your appointment for 10:15 am on Monday August 2nd with Dr. Flubberbein. If you have any questions please call 9176504575.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=-XNzkR9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=GzQLzuM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=Az4Q9kTz4O9LXp-TdCbNW

Thank you.
OppyDental

DEBUGGING:
time to call or email:2010-07-31 00:04:00 time of appointment:2010-08-02 10:15:00
This is supposed to have come 3 days before the appointment.
The Event ID for this is: 263','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('225','1','0','19176504575','-5','This is a call from OppyDental reminding you of your appointment for 10:15 am on Monday August 2nd. If you have any questions please call 9176504575. Thank you.','2010-08-02 00:19:00','1','1','3','0','0','2010-08-02 00:19:01','13','38','','2010-08-02 10:15:00','263','Dear Fred  Funk,

This is a message from OppyDental reminding you of your appointment for 10:15 am on Monday August 2nd with Dr. Flubberbein. If you have any questions please call 9176504575.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=-XNzkR9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=GzQLzuM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=Az4Q9kTz4O9LXp-TdCbNW

Thank you.
OppyDental

DEBUGGING:
time to call or email:2010-08-02 00:19:00 time of appointment:2010-08-02 10:15:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 263','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('226','1','0','18452465599','-5','This is a call from OppyDental reminding you of your appointment for 12:30 pm on Friday July 30th. If you have any questions please call 9176504575. Thank you.','2010-07-30 00:28:20','1','2','3','0','0','2010-07-30 00:29:01','13','39','','2010-07-30 12:30:00','264','Dear John Claridge,

This is a message from OppyDental reminding you of your appointment for 12:30 pm on Friday July 30th with Dr. Flubberbein. If you have any questions please call 9176504575.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=-hNz-OR9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=HzQPzuM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=Bz4K-JkTz4O9LXp-TdCbNW

Thank you.
OppyDental

DEBUGGING:
time to call or email:2010-07-30 00:01:00 time of appointment:2010-07-30 12:30:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 264','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('227','0','1','18452465599','-5','This is a call from OppyDental reminding you of your appointment for 12:00 pm on Monday August 2nd. If you have any questions please call 9176504575. Thank you.','2010-07-31 00:06:00','1','0','1','0','0','0000-00-00 00:00:00','13','39','','2010-08-02 12:00:00','265','Dear John Claridge,

This is a message from OppyDental reminding you of your appointment for 12:00 pm on Monday August 2nd with Dr. Flubberbein. If you have any questions please call 9176504575.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=GNzQS9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=IzQTp4M9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=Cz4O9uTz4O9LXp-TdCbNW

Thank you.
OppyDental

DEBUGGING:
time to call or email:2010-07-31 00:06:00 time of appointment:2010-08-02 12:00:00
This is supposed to have come 3 days before the appointment.
The Event ID for this is: 265','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('228','1','0','18452465599','-5','This is a call from OppyDental reminding you of your appointment for 12:00 pm on Monday August 2nd. If you have any questions please call 9176504575. Thank you.','2010-08-02 00:06:00','1','1','3','0','0','2010-08-02 00:07:01','13','39','','2010-08-02 12:00:00','265','Dear John Claridge,

This is a message from OppyDental reminding you of your appointment for 12:00 pm on Monday August 2nd with Dr. Flubberbein. If you have any questions please call 9176504575.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=GNzQS9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=IzQTp4M9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=Cz4O9uTz4O9LXp-TdCbNW

Thank you.
OppyDental

DEBUGGING:
time to call or email:2010-08-02 00:06:00 time of appointment:2010-08-02 12:00:00
This is supposed to have come 1 days before the appointment.
The Event ID for this is: 265','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('229','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:30 am on Thursday August 12th. If you have any questions please call 2221212212. Thank you.','2010-08-09 15:05:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-08-12 10:30:00','269','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:30 am on Thursday August 12th with Dr. Nigel Matthews. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=uNz-OT9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=C9QPz-EM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=Gz4K-J4Tz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility','1','0');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('230','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:30 am on Thursday August 12th. If you have any questions please call 2221212212. Thank you.','2010-08-09 15:07:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-08-12 10:30:00','270','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:30 am on Thursday August 12th with Dr. Nigel Matthews. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=3OzQK-J-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=DzaTp-OM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=Hp-EO9-ETz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility','1','0');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('231','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:30 am on Thursday August 12th. If you have any questions please call 2221212212. Thank you.','2010-08-10 15:10:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-08-12 10:30:00','269','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:30 am on Thursday August 12th with Dr. Nigel Matthews. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=uNz-OT9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=C9QPz-EM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=Gz4K-J4Tz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility','1','1');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('232','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:30 am on Thursday August 12th. If you have any questions please call 2221212212. Thank you.','2010-08-10 15:05:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-08-12 10:30:00','270','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:30 am on Thursday August 12th with Dr. Nigel Matthews. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=3OzQK-J-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=DzaTp-OM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=Hp-EO9-ETz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility','1','1');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('233','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:30 am on Thursday August 12th. If you have any questions please call 2221212212. Thank you.','2010-08-11 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-08-12 10:30:00','269','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:30 am on Thursday August 12th with Dr. Nigel Matthews. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=uNz-OT9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=C9QPz-EM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=Gz4K-J4Tz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('234','1','0','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:30 am on Thursday August 12th. If you have any questions please call 2221212212. Thank you.','2010-08-11 15:15:00','1','1','3','0','0','2010-08-11 15:15:02','1','35','','2010-08-12 10:30:00','269','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:30 am on Thursday August 12th with Dr. Nigel Matthews. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=uNz-OT9-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=C9QPz-EM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=Gz4K-J4Tz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('235','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:30 am on Thursday August 12th. If you have any questions please call 2221212212. Thank you.','2010-08-11 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-08-12 10:30:00','270','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:30 am on Thursday August 12th with Dr. Nigel Matthews. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=3OzQK-J-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=DzaTp-OM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=Hp-EO9-ETz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('236','1','0','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 10:30 am on Thursday August 12th. If you have any questions please call 2221212212. Thank you.','2010-08-11 15:02:00','1','1','3','0','0','2010-08-11 15:03:01','1','35','','2010-08-12 10:30:00','270','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 10:30 am on Thursday August 12th with Dr. Nigel Matthews. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=3OzQK-J-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=DzaTp-OM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=Hp-EO9-ETz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('237','0','1','','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 12:00 pm on Thursday August 12th. If you have any questions please call 2221212212. Thank you.','2010-08-09 15:01:00','1','0','1','0','0','0000-00-00 00:00:00','1','24','','2010-08-12 12:00:00','271','Dear Laura Powell,

This is a message from Worthington Medical Facility reminding you of your appointment for 12:00 pm on Thursday August 12th with Dr. Nigel Matthews. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=-DOz4K-J-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=EzaNz-OM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=Ip-ES9-ETz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility','1','0');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('238','0','1','','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 12:00 pm on Thursday August 12th. If you have any questions please call 2221212212. Thank you.','2010-08-10 15:05:00','1','0','1','0','0','0000-00-00 00:00:00','1','24','','2010-08-12 12:00:00','271','Dear Laura Powell,

This is a message from Worthington Medical Facility reminding you of your appointment for 12:00 pm on Thursday August 12th with Dr. Nigel Matthews. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=-DOz4K-J-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=EzaNz-OM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=Ip-ES9-ETz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility','1','1');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('239','0','1','','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 12:00 pm on Thursday August 12th. If you have any questions please call 2221212212. Thank you.','2010-08-11 15:12:00','1','0','1','0','0','0000-00-00 00:00:00','1','24','','2010-08-12 12:00:00','271','Dear Laura Powell,

This is a message from Worthington Medical Facility reminding you of your appointment for 12:00 pm on Thursday August 12th with Dr. Nigel Matthews. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=-DOz4K-J-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=EzaNz-OM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=Ip-ES9-ETz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('240','1','0','','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 12:00 pm on Thursday August 12th. If you have any questions please call 2221212212. Thank you.','2010-08-11 15:04:00','1','3','2','0','0','2010-08-11 17:13:01','1','24','','2010-08-12 12:00:00','271','Dear Laura Powell,

This is a message from Worthington Medical Facility reminding you of your appointment for 12:00 pm on Thursday August 12th with Dr. Nigel Matthews. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=-DOz4K-J-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=EzaNz-OM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=Ip-ES9-ETz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('241','0','1','','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 12:00 pm on Thursday August 12th. If you have any questions please call 2221212212. Thank you.','2010-08-09 15:01:00','1','0','1','0','0','0000-00-00 00:00:00','1','24','','2010-08-12 12:00:00','272','Dear Laura Powell,

This is a message from Worthington Medical Facility reminding you of your appointment for 12:00 pm on Thursday August 12th with Dr. Nigel Matthews. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=-NOz-hL-J-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=FzaRp-YM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=Jp-EM9-OTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility','1','0');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('242','0','1','','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 12:00 pm on Thursday August 12th. If you have any questions please call 2221212212. Thank you.','2010-08-10 15:00:00','1','0','1','0','0','0000-00-00 00:00:00','1','24','','2010-08-12 12:00:00','272','Dear Laura Powell,

This is a message from Worthington Medical Facility reminding you of your appointment for 12:00 pm on Thursday August 12th with Dr. Nigel Matthews. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=-NOz-hL-J-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=FzaRp-YM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=Jp-EM9-OTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility','1','1');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('243','0','1','','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 12:00 pm on Thursday August 12th. If you have any questions please call 2221212212. Thank you.','2010-08-11 15:12:00','1','0','1','0','0','0000-00-00 00:00:00','1','24','','2010-08-12 12:00:00','272','Dear Laura Powell,

This is a message from Worthington Medical Facility reminding you of your appointment for 12:00 pm on Thursday August 12th with Dr. Nigel Matthews. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=-NOz-hL-J-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=FzaRp-YM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=Jp-EM9-OTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('244','1','0','','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 12:00 pm on Thursday August 12th. If you have any questions please call 2221212212. Thank you.','2010-08-11 15:15:00','1','3','2','0','0','2010-08-11 17:23:01','1','24','','2010-08-12 12:00:00','272','Dear Laura Powell,

This is a message from Worthington Medical Facility reminding you of your appointment for 12:00 pm on Thursday August 12th with Dr. Nigel Matthews. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=-NOz-hL-J-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=FzaRp-YM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=Jp-EM9-OTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('245','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 9:45 am on Thursday August 12th. If you have any questions please call 2221212212. Thank you.','2010-08-09 15:07:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-08-12 09:45:00','273','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 9:45 am on Thursday August 12th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=-XOzkL-J-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=GzaLz-YM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=Az-EQ9-OTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility','1','0');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('246','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 9:45 am on Thursday August 12th. If you have any questions please call 2221212212. Thank you.','2010-08-10 15:16:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-08-12 09:45:00','273','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 9:45 am on Thursday August 12th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=-XOzkL-J-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=GzaLz-YM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=Az-EQ9-OTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility','1','1');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('247','0','1','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 9:45 am on Thursday August 12th. If you have any questions please call 2221212212. Thank you.','2010-08-11 15:15:00','1','0','1','0','0','0000-00-00 00:00:00','1','35','','2010-08-12 09:45:00','273','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 9:45 am on Thursday August 12th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=-XOzkL-J-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=GzaLz-YM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=Az-EQ9-OTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility','1','2');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('248','1','0','19176504575','-5','This is a call from Worthington Medical Facility reminding you of your appointment for 9:45 am on Thursday August 12th. If you have any questions please call 2221212212. Thank you.','2010-08-11 15:04:00','1','1','3','0','0','2010-08-11 15:05:02','1','35','','2010-08-12 09:45:00','273','Dear Dennis O,

This is a message from Worthington Medical Facility reminding you of your appointment for 9:45 am on Thursday August 12th with Dr. Oliver Primack. If you have any questions please call 2221212212.

If you expect to make this appointment, click this link:
http://medboxx.com/response.php?x_eq=-XOzkL-J-XK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://medboxx.com/response.php?x_eq=GzaLz-YM9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://medboxx.com/response.php?x_eq=Az-EQ9-OTz4O9LXp-TdCbNW

Thank you.
Worthington Medical Facility','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('249','1','0','','-5','This is a call from MiddleMan reminding you of your appointment for 10:00 am on Friday September 10th. If you have any questions please call 2266212212. Thank you.','2010-09-10 00:09:00','1','3','2','','','2010-09-10 02:17:01','18','41','','2010-09-10 10:00:00','275','Dear william mocker,

This is a message from MiddleMan reminding you of your appointment for 10:00 am on Friday September 10th with manter. If you have any questions please call 2266212212.

If you expect to make this appointment, click this link:
http://glamourboxx.com/response.php?x_eq=GOzQM9-hK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://glamourboxx.com/response.php?x_eq=IzaTp-hN9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://glamourboxx.com/response.php?x_eq=Cz-EO9-XK94O9LXp-TdCbNW

Thank you.
MiddleMan','1','3');
INSERT INTO glamourboxx.phone_call(`phone_call_id`,`phonecall_only`,`email_only`,`phone_number`,`timezone`,`call_content`,`time_to_start`,`call_type_id`,`attempt_count`,`phonecall_status_id`,`completed`,`abandoned`,`last_attempt`,`office_id`,`callee_id`,`suid`,`expiry_date`,`calendar_event_id`,`email_content`,`email_sent`,`reminder_type`) VALUES('250','1','0','','-5','This is a call from MiddleMan reminding you of your appointment for 11:15 am on Thursday September 16th. If you have any questions please call 2266212212. Thank you.','2010-09-16 00:16:00','1','3','2','','','2010-09-22 01:21:01','18','42','','2010-09-16 11:15:00','277','Dear gina test,

This is a message from MiddleMan reminding you of your appointment for 11:15 am on Thursday September 16th with manter. If you have any questions please call 2266212212.

If you expect to make this appointment, click this link:
http://glamourboxx.com/response.php?x_eq=aOz-hN9-hK9-POC-WKW-SUWbNW

If you would like us to call you, click this link:
http://glamourboxx.com/response.php?x_eq=A9aRpGN9-hM-J-JVp-TXMoc-dbNW

If you would like to cancel this appointment, click this link:
http://glamourboxx.com/response.php?x_eq=Ez-EM9-hK94O9LXp-TdCbNW

Thank you.
MiddleMan','1','3');


CREATE TABLE `phonecall_status` (
  `phonecall_status_id` int(11) NOT NULL auto_increment,
  `status_name` varchar(50) default NULL,
  PRIMARY KEY  (`phonecall_status_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;



INSERT INTO glamourboxx.phonecall_status(`phonecall_status_id`,`status_name`) VALUES('1','scheduled');
INSERT INTO glamourboxx.phonecall_status(`phonecall_status_id`,`status_name`) VALUES('2','called no status update');
INSERT INTO glamourboxx.phonecall_status(`phonecall_status_id`,`status_name`) VALUES('3','answered');
INSERT INTO glamourboxx.phonecall_status(`phonecall_status_id`,`status_name`) VALUES('4','busy');
INSERT INTO glamourboxx.phonecall_status(`phonecall_status_id`,`status_name`) VALUES('5','no answer');
INSERT INTO glamourboxx.phonecall_status(`phonecall_status_id`,`status_name`) VALUES('6','channel unavailable');
INSERT INTO glamourboxx.phonecall_status(`phonecall_status_id`,`status_name`) VALUES('7','other');


CREATE TABLE `practitioner` (
  `practitioner_id` int(11) NOT NULL auto_increment,
  `name` varchar(50) default NULL,
  `practitioner_type_id` int(50) default NULL,
  `phone` varchar(50) default NULL,
  `facility` varchar(100) default NULL,
  `address` varchar(200) default NULL,
  `office_id` int(11) default NULL,
  PRIMARY KEY  (`practitioner_id`)
) ENGINE=MyISAM AUTO_INCREMENT=113 DEFAULT CHARSET=latin1;



INSERT INTO glamourboxx.practitioner(`practitioner_id`,`name`,`practitioner_type_id`,`phone`,`facility`,`address`,`office_id`) VALUES('1','Dr. Peter Richards','5','1:1:111 211 2112','	Kingston Medical','1:5g jghhhhhh','1');
INSERT INTO glamourboxx.practitioner(`practitioner_id`,`name`,`practitioner_type_id`,`phone`,`facility`,`address`,`office_id`) VALUES('2','Dr. Oliver Primack','5','2:2:888 443 2312','	Kingston Medical','2:6g jgh j','1');
INSERT INTO glamourboxx.practitioner(`practitioner_id`,`name`,`practitioner_type_id`,`phone`,`facility`,`address`,`office_id`) VALUES('3','Dr. Nigel Matthews','4','232 121 4421','	Kingston Medical','233 Koolington Blvd','1');
INSERT INTO glamourboxx.practitioner(`practitioner_id`,`name`,`practitioner_type_id`,`phone`,`facility`,`address`,`office_id`) VALUES('4','Dr. Thor Walker','2','3:232 121 4421','Kingston Medical','3:8hgj ghj rockingham','1');
INSERT INTO glamourboxx.practitioner(`practitioner_id`,`name`,`practitioner_type_id`,`phone`,`facility`,`address`,`office_id`) VALUES('103','Dawn Parklington','6','','','','1');
INSERT INTO glamourboxx.practitioner(`practitioner_id`,`name`,`practitioner_type_id`,`phone`,`facility`,`address`,`office_id`) VALUES('104','Fredrick Mastow','1','4443334433','','','52');
INSERT INTO glamourboxx.practitioner(`practitioner_id`,`name`,`practitioner_type_id`,`phone`,`facility`,`address`,`office_id`) VALUES('105','Tonia Kusters','0','','','','5');
INSERT INTO glamourboxx.practitioner(`practitioner_id`,`name`,`practitioner_type_id`,`phone`,`facility`,`address`,`office_id`) VALUES('106','Anita Hayes','0','','','','5');
INSERT INTO glamourboxx.practitioner(`practitioner_id`,`name`,`practitioner_type_id`,`phone`,`facility`,`address`,`office_id`) VALUES('107','Anita Hayes','1','0872477622','','','5');
INSERT INTO glamourboxx.practitioner(`practitioner_id`,`name`,`practitioner_type_id`,`phone`,`facility`,`address`,`office_id`) VALUES('108','Tonia Kusters','1','','','','5');
INSERT INTO glamourboxx.practitioner(`practitioner_id`,`name`,`practitioner_type_id`,`phone`,`facility`,`address`,`office_id`) VALUES('109','Dr. Bron Wonson','1','2441292712','','','12');
INSERT INTO glamourboxx.practitioner(`practitioner_id`,`name`,`practitioner_type_id`,`phone`,`facility`,`address`,`office_id`) VALUES('110','Dr. Flubberbein','0','','','','13');
INSERT INTO glamourboxx.practitioner(`practitioner_id`,`name`,`practitioner_type_id`,`phone`,`facility`,`address`,`office_id`) VALUES('111','Susie Caldwell','','','','','');
INSERT INTO glamourboxx.practitioner(`practitioner_id`,`name`,`practitioner_type_id`,`phone`,`facility`,`address`,`office_id`) VALUES('112','manter','','','','','18');


CREATE TABLE `practitioner_type` (
  `practitioner_type_id` int(4) NOT NULL auto_increment,
  `type_name` varchar(50) default NULL,
  PRIMARY KEY  (`practitioner_type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;



INSERT INTO glamourboxx.practitioner_type(`practitioner_type_id`,`type_name`) VALUES('1','General');
INSERT INTO glamourboxx.practitioner_type(`practitioner_type_id`,`type_name`) VALUES('2','Technician');
INSERT INTO glamourboxx.practitioner_type(`practitioner_type_id`,`type_name`) VALUES('3','Chiropracter');
INSERT INTO glamourboxx.practitioner_type(`practitioner_type_id`,`type_name`) VALUES('4','Specialist');
INSERT INTO glamourboxx.practitioner_type(`practitioner_type_id`,`type_name`) VALUES('5','Surgeon');
INSERT INTO glamourboxx.practitioner_type(`practitioner_type_id`,`type_name`) VALUES('6','Nurse');
INSERT INTO glamourboxx.practitioner_type(`practitioner_type_id`,`type_name`) VALUES('7','Spiritual');


CREATE TABLE `practitioner_user_map` (
  `practicioner_user_map_id` int(4) NOT NULL auto_increment,
  `user_id` int(4) default NULL,
  `practitioner_id` int(4) default NULL,
  PRIMARY KEY  (`practicioner_user_map_id`)
) ENGINE=MyISAM AUTO_INCREMENT=91 DEFAULT CHARSET=latin1;



INSERT INTO glamourboxx.practitioner_user_map(`practicioner_user_map_id`,`user_id`,`practitioner_id`) VALUES('88','1','83');
INSERT INTO glamourboxx.practitioner_user_map(`practicioner_user_map_id`,`user_id`,`practitioner_id`) VALUES('19','30','14');
INSERT INTO glamourboxx.practitioner_user_map(`practicioner_user_map_id`,`user_id`,`practitioner_id`) VALUES('20','30','15');
INSERT INTO glamourboxx.practitioner_user_map(`practicioner_user_map_id`,`user_id`,`practitioner_id`) VALUES('21','30','16');
INSERT INTO glamourboxx.practitioner_user_map(`practicioner_user_map_id`,`user_id`,`practitioner_id`) VALUES('22','33','17');
INSERT INTO glamourboxx.practitioner_user_map(`practicioner_user_map_id`,`user_id`,`practitioner_id`) VALUES('23','33','18');
INSERT INTO glamourboxx.practitioner_user_map(`practicioner_user_map_id`,`user_id`,`practitioner_id`) VALUES('85','1','80');
INSERT INTO glamourboxx.practitioner_user_map(`practicioner_user_map_id`,`user_id`,`practitioner_id`) VALUES('90','1','85');
INSERT INTO glamourboxx.practitioner_user_map(`practicioner_user_map_id`,`user_id`,`practitioner_id`) VALUES('81','1','76');


CREATE TABLE `promo_code` (
  `promo_code_id` int(11) NOT NULL auto_increment,
  `code` varchar(50) default NULL,
  `office_id` int(11) default NULL,
  PRIMARY KEY  (`promo_code_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;



INSERT INTO glamourboxx.promo_code(`promo_code_id`,`code`,`office_id`) VALUES('1','slacker','1');
INSERT INTO glamourboxx.promo_code(`promo_code_id`,`code`,`office_id`) VALUES('2','henry','14');
INSERT INTO glamourboxx.promo_code(`promo_code_id`,`code`,`office_id`) VALUES('3','101','0');
INSERT INTO glamourboxx.promo_code(`promo_code_id`,`code`,`office_id`) VALUES('4','brian','0');
INSERT INTO glamourboxx.promo_code(`promo_code_id`,`code`,`office_id`) VALUES('5','la','18');
INSERT INTO glamourboxx.promo_code(`promo_code_id`,`code`,`office_id`) VALUES('6','sam','17');
INSERT INTO glamourboxx.promo_code(`promo_code_id`,`code`,`office_id`) VALUES('7','gina1','0');
INSERT INTO glamourboxx.promo_code(`promo_code_id`,`code`,`office_id`) VALUES('8','gina2','0');
INSERT INTO glamourboxx.promo_code(`promo_code_id`,`code`,`office_id`) VALUES('9','gina3','0');


CREATE TABLE `question_column_map` (
  `question_column_map_id` int(4) NOT NULL auto_increment,
  `questionnaire_id` int(4) default NULL,
  `table_name` varchar(50) default NULL,
  `column_name` varchar(50) default NULL,
  `questionnaire_question_id` int(4) default NULL,
  `sort_id` int(50) default NULL,
  PRIMARY KEY  (`question_column_map_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;



INSERT INTO glamourboxx.question_column_map(`question_column_map_id`,`questionnaire_id`,`table_name`,`column_name`,`questionnaire_question_id`,`sort_id`) VALUES('1','8','practitioner','name','48','0');
INSERT INTO glamourboxx.question_column_map(`question_column_map_id`,`questionnaire_id`,`table_name`,`column_name`,`questionnaire_question_id`,`sort_id`) VALUES('2','8','practitioner','phone','49','0');
INSERT INTO glamourboxx.question_column_map(`question_column_map_id`,`questionnaire_id`,`table_name`,`column_name`,`questionnaire_question_id`,`sort_id`) VALUES('3','8','practitioner','facility','50','0');
INSERT INTO glamourboxx.question_column_map(`question_column_map_id`,`questionnaire_id`,`table_name`,`column_name`,`questionnaire_question_id`,`sort_id`) VALUES('4','8','practitioner','practitioner_type_id','55','0');
INSERT INTO glamourboxx.question_column_map(`question_column_map_id`,`questionnaire_id`,`table_name`,`column_name`,`questionnaire_question_id`,`sort_id`) VALUES('5','8','practitioner','address','51','0');
INSERT INTO glamourboxx.question_column_map(`question_column_map_id`,`questionnaire_id`,`table_name`,`column_name`,`questionnaire_question_id`,`sort_id`) VALUES('6','11','insurance','insurance_name','57','0');
INSERT INTO glamourboxx.question_column_map(`question_column_map_id`,`questionnaire_id`,`table_name`,`column_name`,`questionnaire_question_id`,`sort_id`) VALUES('9','11','insurance','mileage_reimburse_rate','60','0');
INSERT INTO glamourboxx.question_column_map(`question_column_map_id`,`questionnaire_id`,`table_name`,`column_name`,`questionnaire_question_id`,`sort_id`) VALUES('10','12','subuser','name','62','0');
INSERT INTO glamourboxx.question_column_map(`question_column_map_id`,`questionnaire_id`,`table_name`,`column_name`,`questionnaire_question_id`,`sort_id`) VALUES('11','12','subuser','birthday','77','0');
INSERT INTO glamourboxx.question_column_map(`question_column_map_id`,`questionnaire_id`,`table_name`,`column_name`,`questionnaire_question_id`,`sort_id`) VALUES('12','11','insurance','membership_number','75','0');
INSERT INTO glamourboxx.question_column_map(`question_column_map_id`,`questionnaire_id`,`table_name`,`column_name`,`questionnaire_question_id`,`sort_id`) VALUES('13','11','insurance','group_number','76','0');
INSERT INTO glamourboxx.question_column_map(`question_column_map_id`,`questionnaire_id`,`table_name`,`column_name`,`questionnaire_question_id`,`sort_id`) VALUES('14','11','insurance','annual_maximum','79','0');


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



INSERT INTO glamourboxx.questionnaire(`questionnaire_id`,`name`,`intro_text`,`questionnaire_type_id`,`author_id`,`created`,`answer_tally`,`link_next_questionnaire_id`,`sort_order`,`accept_multiple`,`related_table_name`,`populate_related`) VALUES('1','Identifying Information','','1','0','2007-07-30 17:56:53','0','0','1','0','','0');
INSERT INTO glamourboxx.questionnaire(`questionnaire_id`,`name`,`intro_text`,`questionnaire_type_id`,`author_id`,`created`,`answer_tally`,`link_next_questionnaire_id`,`sort_order`,`accept_multiple`,`related_table_name`,`populate_related`) VALUES('2','Contact Info','','1','0','2007-07-30 17:56:53','0','0','2','0','','0');
INSERT INTO glamourboxx.questionnaire(`questionnaire_id`,`name`,`intro_text`,`questionnaire_type_id`,`author_id`,`created`,`answer_tally`,`link_next_questionnaire_id`,`sort_order`,`accept_multiple`,`related_table_name`,`populate_related`) VALUES('4','Visits','','1','0','2007-07-30 17:56:53','0','0','7','1','','0');
INSERT INTO glamourboxx.questionnaire(`questionnaire_id`,`name`,`intro_text`,`questionnaire_type_id`,`author_id`,`created`,`answer_tally`,`link_next_questionnaire_id`,`sort_order`,`accept_multiple`,`related_table_name`,`populate_related`) VALUES('6','calendar event','','2','0','2007-05-22 18:08:33','0','0','44','1','','0');
INSERT INTO glamourboxx.questionnaire(`questionnaire_id`,`name`,`intro_text`,`questionnaire_type_id`,`author_id`,`created`,`answer_tally`,`link_next_questionnaire_id`,`sort_order`,`accept_multiple`,`related_table_name`,`populate_related`) VALUES('7','Emergency Contacts','','1','0','2007-07-30 17:56:53','0','0','4','1','','0');
INSERT INTO glamourboxx.questionnaire(`questionnaire_id`,`name`,`intro_text`,`questionnaire_type_id`,`author_id`,`created`,`answer_tally`,`link_next_questionnaire_id`,`sort_order`,`accept_multiple`,`related_table_name`,`populate_related`) VALUES('8','Personal Practitioners','','1','0','2007-07-30 17:56:53','0','0','5','1','practitioner','1');
INSERT INTO glamourboxx.questionnaire(`questionnaire_id`,`name`,`intro_text`,`questionnaire_type_id`,`author_id`,`created`,`answer_tally`,`link_next_questionnaire_id`,`sort_order`,`accept_multiple`,`related_table_name`,`populate_related`) VALUES('9','Provider','','0','0','2007-05-22 18:08:33','0','0','44','0','','1');
INSERT INTO glamourboxx.questionnaire(`questionnaire_id`,`name`,`intro_text`,`questionnaire_type_id`,`author_id`,`created`,`answer_tally`,`link_next_questionnaire_id`,`sort_order`,`accept_multiple`,`related_table_name`,`populate_related`) VALUES('11','Insurance','<div>This is where you list your insurance providers.&nbsp;</div>','1','0','2007-07-30 17:56:53','0','0','6','1','insurance','1');
INSERT INTO glamourboxx.questionnaire(`questionnaire_id`,`name`,`intro_text`,`questionnaire_type_id`,`author_id`,`created`,`answer_tally`,`link_next_questionnaire_id`,`sort_order`,`accept_multiple`,`related_table_name`,`populate_related`) VALUES('12','Family Members','<div>Enter the people whose medical records you are maintaining.&nbsp;</div>','1','0','2007-07-30 17:56:53','0','0','3','1','subuser','1');
INSERT INTO glamourboxx.questionnaire(`questionnaire_id`,`name`,`intro_text`,`questionnaire_type_id`,`author_id`,`created`,`answer_tally`,`link_next_questionnaire_id`,`sort_order`,`accept_multiple`,`related_table_name`,`populate_related`) VALUES('3','medications','','3','0','2007-07-30 18:01:38','0','0','0','1','','0');
INSERT INTO glamourboxx.questionnaire(`questionnaire_id`,`name`,`intro_text`,`questionnaire_type_id`,`author_id`,`created`,`answer_tally`,`link_next_questionnaire_id`,`sort_order`,`accept_multiple`,`related_table_name`,`populate_related`) VALUES('5','tests','','3','0','2007-07-30 18:02:09','0','0','0','1','','0');


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



INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('3','Gender','1','0','0','gender','0','0','0','0','');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('4','Hair color','1','0','0','hair_color','0','0','0','0','');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('5','Eye color','1','0','0','eye_color','0','0','0','0','');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('6','Ethnicity','1','0','0','ethnicity','0','0','0','0','');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('7','Language','1','0','0','language','0','0','0','0','');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('8','Marital Status','1','0','0','marital_status','0','0','0','0','');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('9','Sexual preference','1','0','0','sexual_preference','0','0','0','0','');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('10','Religion','1','0','0','religion','0','0','0','0','');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('11','Blood type','1','0','0','blood_type','0','0','0','0','');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('12','Height &#40;in inches&#41;','1','0','0','','0','0','0','0','int');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('13','Weight &#40;in pounds&#41;','1','0','0','','0','0','0','0','int');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('14','Birthdate','1','0','0','','0','0','0','0','date');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('15','Home telephone','2','0','0','','0','0','0','0','');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('16','Work telephone','2','0','0','','0','0','0','0','');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('17','Mobile telephone','2','0','0','','0','0','0','0','');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('19','Address Line 1','2','0','0','','0','0','0','0','');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('20','Address Line 2','2','0','0','','0','0','0','0','');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('21','City or Town','2','0','0','','0','0','0','0','');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('22','State or Province','2','0','0','state','0','0','0','0','');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('23','Zip or Postal Code','2','0','0','','0','0','2','4','');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('24','Country','2','0','0','country','0','0','0','0','');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('25','SSN','1','0','0','','0','0','0','0','');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('26','First Name','1','0','0','','0','0','0','0','');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('27','Middle Name','1','0','0','','0','0','0','0','');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('28','Last Name','1','0','0','','0','0','0','0','');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('29','medication','3','2','0','','0','0','0','0','');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('30','amount','3','3','0','','0','0','0','0','');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('31','start date','3','5','0','','0','0','0','0','date');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('77','birth date','12','2','0','','0','0','0','0','date');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('33','doctor','3','1','0','practitioner','0','0','0','0','int');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('68','refill #','3','4','0','','0','0','0','0','int');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('35','date','4','0','0','','0','0','0','0','date');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('36','type','4','2','0','','0','0','0','0','');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('37','medical facility','4','3','0','','0','0','0','0','');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('38','contact','4','7','0','','0','0','0','0','');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('39','reason','4','9','0','','0','0','0','0','text');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('40','test','5','0','0','','0','0','0','0','');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('41','date','5','6','0','','0','0','0','0','');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('42','notes','5','12','0','','0','0','0','0','text');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('43','type','6','0','0','','0','0','0','0','');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('44','description','6','1','0','','0','0','0','0','');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('45','contact name','7','0','0','','0','0','0','0','');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('46','phone','7','0','0','','0','0','0','0','');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('47','description','7','0','0','','0','0','0','0','');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('48','Name','8','1','0','','0','0','0','0','');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('49','Phone #','8','3','0','','0','0','0','0','');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('50','Facility','8','4','0','','0','0','0','0','');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('51','Address','8','5','0','','0','0','0','0','');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('55','Type','8','2','0','practitioner_type','0','0','0','0','');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('56','practitioner_id','8','6','0','','0','0','0','0','hidden');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('57','name','11','0','0','','0','0','0','0','');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('65','insurer','11','0','0','insurer','0','0','0','0','');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('60','reimburse rate','11','0','0','','0','0','0','0','');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('61','insurance_id','11','0','0','','0','0','0','0','hidden');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('62','name','12','1','0','','0','0','0','0','');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('64','subuser_id','12','3','0','','0','0','0','0','hidden');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('66','doctor','5','0','0','practitioner','0','0','0','0','int');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('79','annual maximum','11','0','0','','0','0','0','0','');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('75','membership number','11','0','0','','0','0','0','0','');
INSERT INTO glamourboxx.questionnaire_question(`questionnaire_question_id`,`question`,`questionnaire_id`,`sort_order`,`answer_tally`,`suggested_table_name`,`answer_width`,`answer_height`,`validation_type_id`,`validation_pattern_id`,`sql_data_type`) VALUES('76','group number','11','0','0','','0','0','0','0','');


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



INSERT INTO glamourboxx.questionnaire_type(`questionnaire_type_id`,`type_name`) VALUES('1','site medical profile');
INSERT INTO glamourboxx.questionnaire_type(`questionnaire_type_id`,`type_name`) VALUES('2','template');
INSERT INTO glamourboxx.questionnaire_type(`questionnaire_type_id`,`type_name`) VALUES('3','medications and tests');


CREATE TABLE `recurrence` (
  `recurrence_id` int(4) NOT NULL auto_increment,
  `recurrence_name` varchar(50) default NULL,
  `recurrence_interval` varchar(22) default NULL,
  `avoidance_id` int(4) default NULL,
  PRIMARY KEY  (`recurrence_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;



INSERT INTO glamourboxx.recurrence(`recurrence_id`,`recurrence_name`,`recurrence_interval`,`avoidance_id`) VALUES('1','six months','6 m','2');
INSERT INTO glamourboxx.recurrence(`recurrence_id`,`recurrence_name`,`recurrence_interval`,`avoidance_id`) VALUES('2','one month','1 m','2');
INSERT INTO glamourboxx.recurrence(`recurrence_id`,`recurrence_name`,`recurrence_interval`,`avoidance_id`) VALUES('3','one week','1 W','2');
INSERT INTO glamourboxx.recurrence(`recurrence_id`,`recurrence_name`,`recurrence_interval`,`avoidance_id`) VALUES('4','one year','1 Y','2');
INSERT INTO glamourboxx.recurrence(`recurrence_id`,`recurrence_name`,`recurrence_interval`,`avoidance_id`) VALUES('5','two weeks','2 W','2');


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



INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('1','AL','ALABAMA');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('2','AK','ALASKA');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('3','AZ','ARIZONA');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('4','AR','ARKANSAS');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('5','CA','CALIFORNIA');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('6','CO','COLORADO');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('7','CT','CONNECTICUT');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('8','DE','DELAWARE');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('9','FL','FLORIDA');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('10','GA','GEORGIA');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('11','HI','HAWAII');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('12','ID','IDAHO');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('13','IL','ILLINOIS');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('14','IN','INDIANA');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('15','IA','IOWA');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('16','KS','KANSAS');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('17','KY','KENTUCKY');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('18','LA','LOUISIANA');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('19','ME','MAINE');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('20','MD','MARYLAND');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('21','MA','MASSACHUSETTS');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('22','MI','MICHIGAN');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('23','MN','MINNESOTA');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('24','MS','MISSISSIPPI');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('25','MO','MISSOURI');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('26','MT','MONTANA');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('27','NE','NEBRASKA');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('28','NV','NEVADA');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('29','NH','NEW HAMPSHIRE');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('30','NJ','NEW JERSEY');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('31','NM','NEW MEXICO');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('32','NY','NEW YORK');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('33','NC','NORTH CAROLINA');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('34','ND','NORTH DAKOTA');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('35','OH','OHIO');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('36','OK','OKLAHOMA');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('37','OR','OREGON');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('38','PA','PENNSYLVANIA');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('39','RI','RHODE ISLAND');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('40','SC','SOUTH CAROLINA');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('41','SD','SOUTH DAKOTA');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('42','TN','TENNESSEE');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('43','TX','TEXAS');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('44','UT','UTAH');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('45','VT','VERMONT');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('46','VA','VIRGINIA');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('47','WA','WASHINGTON');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('48','WV','WEST VIRGINIA');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('49','WI','WISCONSIN');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('50','WY','WYOMING');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('51','CZ','CANAL ZONE');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('52','DC','DISTRICT OF COLUMBIA');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('53','GU','GUAM');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('54','PR','PUERTO RICO');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('55','AS','U.S. PACIFIC IS.');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('56','US','UNITED STATES');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('57','VI','VIRGIN (U.S.) ISLANDS');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('58','AB','Alberta');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('59','BC','British Columbia');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('60','MB','Manitoba');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('61','NB','New Brunswick');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('62','NL','Newfoundland and Labra');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('63','NT','Northwest Territories');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('64','NS','Nova Scotia');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('65','NU','Nunavut');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('66','ON','Ontario');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('67','PE','Prince Edward Island');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('68','QC','Quebec');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('69','SK','Saskatchewan');
INSERT INTO glamourboxx.state(`state_id`,`code`,`state_name`) VALUES('70','YT','Yukon');


CREATE TABLE `tf_column_info` (
  `column_info_id` int(11) NOT NULL auto_increment,
  `table_name` varchar(50) default NULL,
  `column_name` varchar(80) default NULL,
  `width` int(11) default NULL,
  `height` int(11) default NULL,
  `invisible` tinyint(3) default NULL,
  `data_from_multitable_relation` tinyint(3) default NULL,
  `label` text,
  `help_text` text,
  `validation_type_id` int(11) default NULL,
  `validation_pattern_id` int(11) default NULL,
  `fileupload` tinyint(4) default NULL,
  `datecreated` tinyint(4) default NULL,
  `datemodified` tinyint(4) default NULL,
  `password` tinyint(4) default NULL,
  `force_no_wysiwg` tinyint(4) default NULL,
  `force_wysiwg` tinyint(4) default NULL,
  `force_text_input` tinyint(4) default NULL,
  `force_binary` tinyint(4) default NULL,
  `browsetype_id` int(11) default NULL,
  PRIMARY KEY  (`column_info_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;



INSERT INTO glamourboxx.tf_column_info(`column_info_id`,`table_name`,`column_name`,`width`,`height`,`invisible`,`data_from_multitable_relation`,`label`,`help_text`,`validation_type_id`,`validation_pattern_id`,`fileupload`,`datecreated`,`datemodified`,`password`,`force_no_wysiwg`,`force_wysiwg`,`force_text_input`,`force_binary`,`browsetype_id`) VALUES('1','formlog','form_content','120','3','0','0','','','0','0','0','0','0','0','0','0','0','0','0');


CREATE TABLE `tf_dbmap` (
  `dbmap_id` int(11) NOT NULL auto_increment,
  `map_name` varchar(60) default NULL,
  `timecreated` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`dbmap_id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;



INSERT INTO glamourboxx.tf_dbmap(`dbmap_id`,`map_name`,`timecreated`) VALUES('1','phonecalls','2009-12-15 13:34:49');
INSERT INTO glamourboxx.tf_dbmap(`dbmap_id`,`map_name`,`timecreated`) VALUES('2','real','2010-05-25 13:31:48');
INSERT INTO glamourboxx.tf_dbmap(`dbmap_id`,`map_name`,`timecreated`) VALUES('29','New Map','2010-06-09 01:05:04');


CREATE TABLE `tf_dbmap_table` (
  `table_name` varchar(44) NOT NULL,
  `dbmap_id` int(11) NOT NULL default '0',
  `top_pos` int(11) default NULL,
  `left_pos` int(11) default NULL,
  `color_basis` varchar(50) default NULL,
  PRIMARY KEY  (`table_name`,`dbmap_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('','0','70','30','');
INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('user','2','70','36','');
INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('client','2','70','184','');
INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('office','2','70','338','');
INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('phone_call','2','70','478','');
INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('personal_calendar_event','2','96','894','');
INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('tf_relation','2','736','184','');
INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('practitioner','2','718','338','');
INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('login','2','934','184','');
INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('call_type','2','322','597','');
INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('tf_dbmap_table','2','880','338','');
INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('tf_dbmap','2','988','338','');
INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('tf_relation_type','2','430','478','');
INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('practitioner_type','2','448','597','');
INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('marital_status','2','502','478','');
INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('insurance_type','2','574','478','');
INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('event_status','2','646','478','');
INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('client_office_map','2','718','478','');
INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('client','29','70','30','');
INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('office','29','112','332','');
INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('phone_call','29','390','1218','cccc66');
INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('questionnaire','29','786','1181','cc99ff');
INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('personal_calendar_event','29','25','736','');
INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('questionnaire_question','29','322','502','');
INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('calendar_event','29','70','931','');
INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('questionnaire_answer','29','268','931','');
INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('practitioner','29','322','710','');
INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('formlog','29','35','1240','');
INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('calendar_range','29','484','710','');
INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('question_column_map','29','448','931','');
INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('mysql_errorlog','29','736','30','');
INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('login','29','196','168','');
INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('calendar','29','736','238','');
INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('questionnaire_suggested_answer','29','736','382','');
INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('call_type','29','556','502','');
INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('recurrence','29','592','931','');
INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('content','29','736','646','');
INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('calendar_set_map','29','736','750','');
INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('state','29','198','1269','');
INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('server_task','29','736','902','');
INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('practitioner_user_map','29','916','30','');
INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('mail_log','29','916','222','');
INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('calendar_set','29','916','310','');
INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('questionnaire_type','29','916','438','');
INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('practitioner_type','29','916','606','');
INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('marital_status','29','916','766','');
INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('insurance_type','29','916','902','');
INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('event_status','29','1006','30','');
INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('client_office_map','29','1006','150','');
INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('calendar_event_type','29','1006','313','');
INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('calendar_event_characteristic','29','1006','489','');
INSERT INTO glamourboxx.tf_dbmap_table(`table_name`,`dbmap_id`,`top_pos`,`left_pos`,`color_basis`) VALUES('phonecall_status','29','725','1038','');


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
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;



INSERT INTO glamourboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('1','tf_relation','','relation_type_id','tf_relation_type','relation_type_id','0','','0');
INSERT INTO glamourboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('2','phone_call','','call_type_id','call_type','call_type_id','0','','0');
INSERT INTO glamourboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('3','tf_dbmap_table','','dbmap_id','tf_dbmap','dbmap_id','0','','0');
INSERT INTO glamourboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('4','personal_calendar_event','','office_user_id','user','user_id','0','','0');
INSERT INTO glamourboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('5','personal_calendar_event','','patient_user_id','user','user_id','0','','0');
INSERT INTO glamourboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('6','personal_calendar_event','','practitioner_id','practitioner','practitioner_id','0','office_id=$office_id','0');
INSERT INTO glamourboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('7','user_office_map','','office_user_id','user','user_id','0','','0');
INSERT INTO glamourboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('8','user_office_map','','patient_user_id','user','user_id','0','','0');
INSERT INTO glamourboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('9','practitioner','','office_user_id','user','user_id','0','','0');
INSERT INTO glamourboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('10','practitioner','','practitioner_type_id','practitioner_type','practitioner_type_id','0','','0');
INSERT INTO glamourboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('13','personal_calendar_event','','event_status_id','event_status','event_status_id','0','','0');
INSERT INTO glamourboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('14','personal_calendar_event','firstname lastname','client_id','client','client_id','0','join client_office_map m on m.client_id=a.client_id WHERE m.office_id=$office_id','0');
INSERT INTO glamourboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('15','personal_calendar_event','','office_id','office','office_id','0','','0');
INSERT INTO glamourboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('16','client','','insurance1_type_id','insurance_type','insurance_type_id','0','','0');
INSERT INTO glamourboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('17','client','','insurance2_type_id','insurance_type','insurance_type_id','0','','0');
INSERT INTO glamourboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('18','client','','marital_status','marital_status','marital_status_id','0','','0');
INSERT INTO glamourboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('19','client_office_map','office_name','office_id','office','office_id','0','','0');
INSERT INTO glamourboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('20','client_office_map','firstname lastname','client_id','client','client_id','0','','0');
INSERT INTO glamourboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('21','office','email','login_id','login','login_id','0','','0');
INSERT INTO glamourboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('22','client','','guardian_client_id','client','client_id','0','','0');
INSERT INTO glamourboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('23','client','','login_id','login','login_id','0','','0');
INSERT INTO glamourboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('24','phone_call','','office_id','office','office_id','0','','0');
INSERT INTO glamourboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('25','phone_call','firstname lastname','callee_id','client','client_id','0','','0');
INSERT INTO glamourboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('26','phone_call','','calendar_event_id','personal_calendar_event','calendar_event_id','0','','0');
INSERT INTO glamourboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('27','phone_call','','phonecall_status_id','phonecall_status','phonecall_status_id','0','','0');
INSERT INTO glamourboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('28','tf_column_info','','validation_type_id','tf_validation_type','validation_type_id','0','','0');
INSERT INTO glamourboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('29','tf_column_info','','validation_pattern_id','tf_validation_pattern','validation_pattern_id','0','','0');
INSERT INTO glamourboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('30','client','','state_code','state','code','0','','0');
INSERT INTO glamourboxx.tf_relation(`relation_id`,`table_name`,`display_column_name`,`column_name`,`f_table_name`,`f_column_name`,`relation_type_id`,`narrowing_conditions`,`tool_guidance_id`) VALUES('31','promo_code','','office_id','office','office_id','0','','0');


CREATE TABLE `tf_relation_type` (
  `relation_type_id` int(11) NOT NULL default '0',
  `name` varchar(40) default NULL,
  PRIMARY KEY  (`relation_type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



INSERT INTO glamourboxx.tf_relation_type(`relation_type_id`,`name`) VALUES('0','foreign-key relation');
INSERT INTO glamourboxx.tf_relation_type(`relation_type_id`,`name`) VALUES('1','multi-table relation');
INSERT INTO glamourboxx.tf_relation_type(`relation_type_id`,`name`) VALUES('2','default relation');
INSERT INTO glamourboxx.tf_relation_type(`relation_type_id`,`name`) VALUES('3','pseudo-field relation');


CREATE TABLE `tf_scriptlog` (
  `scriptlog_id` int(11) NOT NULL auto_increment,
  `pre_script` text,
  `post_script` text,
  `type` varchar(10) default NULL,
  `time_executed` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`scriptlog_id`)
) ENGINE=MyISAM AUTO_INCREMENT=97 DEFAULT CHARSET=latin1;



INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('1','create database vetboxx','','sql','2010-05-29 18:47:32');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('2','select * from form_data where form_data_id=451','','sql','2010-06-26 21:12:48');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('3','select * from formlog where formlog_id=451','','sql','2010-06-26 21:13:13');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('4','SELECT c.phone_call_id, o.office_name, c.time_to_start, c.last_attempt, c.email_content, u.email as tomail, o.email as frommail FROM phone_call c JOIN user u ON c.callee_id=u.user_id JOIN user o ON c.office_id=o.user_id','','sql','2010-06-27 17:44:24');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('5','SELECT c.phone_call_id, o.office_name, c.time_to_start, c.last_attempt, c.email_content, u.email as tomail, o.email as frommail FROM phone_call c JOIN user u ON c.callee_id=u.user_id JOIN user o ON c.office_id=o.user_id WHERE email_sent=0 AND expiry_date>&#39;2010-06-27 18:05:42&#39;','','sql','2010-06-27 18:06:16');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('6','SELECT c.phone_call_id, o.office_name, c.time_to_start, c.last_attempt, c.email_content, u.email as tomail, o.email as frommail FROM phone_call c JOIN user u ON c.callee_id=u.user_id JOIN user o ON c.office_id=o.user_id WHERE expiry_date>&#39;2010-06-27 18:05:42&#39;','','sql','2010-06-27 18:06:36');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('7','SELECT c.phone_call_id, o.office_name, c.time_to_start, c.last_attempt, c.email_content, u.email as tomail, o.email as frommail FROM phone_call c JOIN user u ON c.callee_id=u.user_id JOIN user o ON c.office_id=o.user_id WHERE email_sent=0 AND expiry_date>&#39;2010-06-27 18:05:42&#39;','','sql','2010-06-27 18:06:55');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('8','SELECT c.phone_call_id, o.office_name, c.time_to_start, c.last_attempt, c.email_content, u.email as tomail, o.email as frommail FROM phone_call c JOIN user u ON c.callee_id=u.user_id JOIN user o ON c.office_id=o.user_id WHERE email_sent=0 AND expiry_date>&#39;2010-06-26 18:05:42&#39;','','sql','2010-06-27 18:07:05');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('9','SELECT c.phone_call_id, o.office_name, c.time_to_start, c.last_attempt, c.email_content, u.email as tomail, o.email as frommail FROM phone_call c JOIN user u ON c.callee_id=u.user_id JOIN user o ON c.office_id=o.user_id WHERE email_sent=0 AND expiry_date>&#39;2010-06-24 18:05:42&#39;','','sql','2010-06-27 18:07:11');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('10','SELECT c.phone_call_id, o.office_name, c.time_to_start, c.last_attempt, c.email_content, u.email as tomail, o.email as frommail FROM phone_call c JOIN user u ON c.callee_id=u.user_id JOIN user o ON c.office_id=o.user_id WHERE email_sent=0 AND expiry_date>&#39;2010-06-23 18:05:42&#39;','','sql','2010-06-27 18:07:15');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('11','SELECT c.phone_call_id, o.office_name, c.time_to_start, c.last_attempt, c.email_content, u.email as tomail, o.email as frommail FROM phone_call c JOIN user u ON c.callee_id=u.user_id JOIN user o ON c.office_id=o.user_id WHERE email_sent=0 AND expiry_date>&#39;2010-06-21 18:05:42&#39;','','sql','2010-06-27 18:07:21');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('12','SELECT c.phone_call_id, o.office_name, c.time_to_start, c.last_attempt, c.email_content, u.email as tomail, o.email as frommail FROM phone_call c JOIN user u ON c.callee_id=u.user_id JOIN user o ON c.office_id=o.user_id WHERE email_sent=0 AND expiry_date>&#39;2000-06-21 18:05:42&#39;','','sql','2010-06-27 18:07:26');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('13','SELECT c.expiry_date, c.phone_call_id, o.office_name, c.time_to_start, c.last_attempt, c.email_content, u.email as tomail, o.email as frommail FROM phone_call c JOIN user u ON c.callee_id=u.user_id JOIN user o ON c.office_id=o.user_id WHERE email_sent=0 AND expiry_date>&#39;2000-06-21 18:05:42&#39;','','sql','2010-06-27 18:08:23');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('14','SELECT c.phone_call_id, o.office_name, c.time_to_start, c.last_attempt, c.email_content, u.email as tomail, o.email as frommail FROM phone_call c JOIN user u ON c.callee_id=u.user_id JOIN user o ON c.office_id=o.user_id WHERE email_sent=0 AND expiry_date>&#39;2010-06-27 18:35:01&#39;','','sql','2010-06-27 18:35:25');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('15','SELECT c.phone_call_id, o.office_name, c.time_to_start, c.last_attempt, c.email_content, u.email as tomail, o.email as frommail FROM phone_call c JOIN user u ON c.callee_id=u.user_id JOIN user o ON c.office_id=o.user_id WHERE email_sent=0 AND expiry_date>&#39;2010-01-27 18:35:01&#39;','','sql','2010-06-27 18:35:34');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('16','SELECT c.phone_call_id, o.office_name, c.time_to_start, c.last_attempt, c.email_content, u.email as tomail, o.email as frommail FROM phone_call c JOIN user u ON c.callee_id=u.user_id JOIN user o ON c.office_id=o.user_id','','sql','2010-06-27 18:35:54');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('17','SELECT c.phone_call_id, o.office_name, c.time_to_start, c.last_attempt, c.email_content, u.email as tomail, o.email as frommail FROM phone_call c JOIN client c ON c.callee_id=c.client_id JOIN office o ON c.office_id=o.office_id WHERE email_sent=0 AND expiry_date>&#39;2010-06-27 18:37:57&#39;','','sql','2010-06-27 18:38:22');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('18','SELECT c.phone_call_id, o.office_name, c.time_to_start, c.last_attempt, c.email_content, cl.email as tomail, o.email as frommail FROM phone_call c JOIN client cl ON cl.callee_id=cl.client_id JOIN office o ON c.office_id=o.office_id WHERE email_sent=0 AND expiry_date>&#39;2010-06-27 18:39:50&#39;','','sql','2010-06-27 18:40:04');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('19','date(\"Y-m-d H:i:s\", 1277737200)','','php','2010-06-27 19:12:10');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('20','date(&#39;Y-m-d H:i:s&#39;, 1277737200)','','php','2010-06-27 19:12:19');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('21','date(&#39;Y-m-d H:i:s&#39;, 1277694709)','','php','2010-06-27 19:12:29');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('22','date(&#39;Y-m-d H:i:s&#39;, 1277737200)','','php','2010-06-27 19:12:56');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('23','date(&#39;Y-m-d H:i:s&#39;, 1277694709)','','php','2010-06-27 19:13:09');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('24','update phone_call set email_sent=0','','sql','2010-06-27 19:19:30');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('25','SELECT p.phone_call_id, p.phone_number AS number,p.call_content AS content,c.attempt_frequency AS frequency,p.time_to_start AS start_date_time FROM phone_call p,call_type c WHERE date_format(p.time_to_start,&#39;%Y:%m:%d %k:%i&#39;)<date_format(now(),&#39;%Y:%m:%d %k:%i&#39;) AND p.completed=0 AND p.abandoned=0 AND &#39;&#39; BETWEEN substr(c.local_call_time_span,1,5) AND substr(c.local_call_time_span,7) AND p.call_type_id=c.call_type_id and p.time_to_start < DATE_ADD(now(),INTERVAL c.attempt_window_length day)','','sql','2010-06-29 00:46:25');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('26','SELECT p.phone_call_id, p.phone_number AS number,p.call_content AS content,c.attempt_frequency AS frequency,p.time_to_start AS start_date_time FROM phone_call p JOIN call_type c ON p.call_type_id=c.call_type_id WHERE date_format(p.time_to_start,&#39;%Y:%m:%d %k:%i&#39;)<date_format(now(),&#39;%Y:%m:%d %k:%i&#39;) AND p.completed=0 AND p.abandoned=0 AND &#39;&#39; BETWEEN substr(c.local_call_time_span,1,5) AND substr(c.local_call_time_span,7) AND p.call_type_id=c.call_type_id and p.time_to_start < DATE_ADD(now(),INTERVAL c.attempt_window_length day)','','sql','2010-06-29 00:48:47');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('27','SELECT p.phone_call_id, p.phone_number AS number,p.call_content AS content,c.attempt_frequency AS frequency,p.time_to_start AS start_date_time FROM phone_call p WHERE date_format(p.time_to_start,&#39;%Y:%m:%d %k:%i&#39;)<date_format(now(),&#39;%Y:%m:%d %k:%i&#39;) AND p.completed=0 AND p.abandoned=0 AND &#39;&#39; BETWEEN substr(c.local_call_time_span,1,5) AND substr(c.local_call_time_span,7) AND p.call_type_id=c.call_type_id and p.time_to_start < DATE_ADD(now(),INTERVAL c.attempt_window_length day)','','sql','2010-06-29 00:48:53');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('28','SELECT p.phone_call_id, p.phone_number AS number,p.call_content AS content AS frequency,p.time_to_start AS start_date_time FROM phone_call p WHERE date_format(p.time_to_start,&#39;%Y:%m:%d %k:%i&#39;)<date_format(now(),&#39;%Y:%m:%d %k:%i&#39;) AND p.completed=0 AND p.abandoned=0 AND &#39;&#39; BETWEEN substr(c.local_call_time_span,1,5) AND substr(c.local_call_time_span,7) AND p.call_type_id=c.call_type_id and p.time_to_start < DATE_ADD(now(),INTERVAL c.attempt_window_length day)','','sql','2010-06-29 00:49:05');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('29','SELECT p.phone_call_id, p.phone_number AS number,p.call_content AS content ,p.time_to_start AS start_date_time FROM phone_call p WHERE date_format(p.time_to_start,&#39;%Y:%m:%d %k:%i&#39;)<date_format(now(),&#39;%Y:%m:%d %k:%i&#39;) AND p.completed=0 AND p.abandoned=0 AND &#39;&#39; BETWEEN substr(c.local_call_time_span,1,5) AND substr(c.local_call_time_span,7) AND p.call_type_id=c.call_type_id and p.time_to_start < DATE_ADD(now(),INTERVAL c.attempt_window_length day)','','sql','2010-06-29 00:49:20');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('30','SELECT p.phone_call_id, p.phone_number AS number,p.call_content AS content,c.attempt_frequency AS frequency,p.time_to_start AS start_date_time FROM phone_call p JOIN call_type c ON p.call_type_id=c.call_type_id WHERE date_format(p.time_to_start,&#39;%Y:%m:%d %k:%i&#39;)<date_format(now(),&#39;%Y:%m:%d %k:%i&#39;) AND p.completed=0 AND p.abandoned=0 AND &#39;&#39; BETWEEN substr(c.local_call_time_span,1,5) AND substr(c.local_call_time_span,7) AND p.call_type_id=c.call_type_id and p.time_to_start < DATE_ADD(now(),INTERVAL c.attempt_window_length day)','','sql','2010-06-29 00:49:42');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('31','SELECT p.phone_call_id, p.phone_number AS number,p.call_content AS content,c.attempt_frequency AS frequency,p.time_to_start AS start_date_time FROM phone_call p left JOIN call_type c ON p.call_type_id=c.call_type_id WHERE date_format(p.time_to_start,&#39;%Y:%m:%d %k:%i&#39;)<date_format(now(),&#39;%Y:%m:%d %k:%i&#39;) AND p.completed=0 AND p.abandoned=0 AND &#39;&#39; BETWEEN substr(c.local_call_time_span,1,5) AND substr(c.local_call_time_span,7) AND p.call_type_id=c.call_type_id and p.time_to_start < DATE_ADD(now(),INTERVAL c.attempt_window_length day)','','sql','2010-06-29 00:49:49');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('32','SELECT p.phone_call_id, p.phone_number AS number,p.call_content AS content,c.attempt_frequency AS frequency,p.time_to_start AS start_date_time FROM phone_call p left JOIN call_type c ON p.call_type_id=c.call_type_id WHERE date_format(p.time_to_start,&#39;%Y:%m:%d %k:%i&#39;)<date_format(now(),&#39;%Y:%m:%d %k:%i&#39;) AND p.completed=0 AND p.abandoned=0 AND p.call_type_id=c.call_type_id and p.time_to_start < DATE_ADD(now(),INTERVAL c.attempt_window_length day)','','sql','2010-06-29 00:50:07');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('33','SELECT p.phone_call_id, p.phone_number AS number,p.call_content AS content,c.attempt_frequency AS frequency,p.time_to_start AS start_date_time FROM phone_call p left JOIN call_type c ON p.call_type_id=c.call_type_id WHERE date_format(p.time_to_start,&#39;%Y:%m:%d %k:%i&#39;)<date_format(now(),&#39;%Y:%m:%d %k:%i&#39;) AND p.completed=0 AND p.abandoned=0 and p.time_to_start < DATE_ADD(now(),INTERVAL c.attempt_window_length day)','','sql','2010-06-29 00:50:30');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('34','SELECT p.phone_call_id, p.phone_number AS number,p.call_content AS content,c.attempt_frequency AS frequency,p.time_to_start AS start_date_time FROM phone_call p left JOIN call_type c ON p.call_type_id=c.call_type_id WHERE date_format(p.time_to_start,&#39;%Y:%m:%d %k:%i&#39;)<date_format(now(),&#39;%Y:%m:%d %k:%i&#39;) AND p.completed=0 AND p.abandoned=0','','sql','2010-06-29 00:50:46');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('35','SELECT p.phone_call_id, p.phone_number AS number,p.call_content AS content,c.attempt_frequency AS frequency,p.time_to_start AS start_date_time FROM phone_call p left JOIN call_type c ON p.call_type_id=c.call_type_id WHERE date_format(p.time_to_start,&#39;%Y:%m:%d %k:%i&#39;)<date_format(now(),&#39;%Y:%m:%d %k:%i&#39;)','','sql','2010-06-29 00:50:54');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('36','SELECT p.phone_call_id, p.phone_number AS number,p.call_content AS content,c.attempt_frequency AS frequency,p.time_to_start AS start_date_time FROM phone_call p JOIN call_type c ON p.call_type_id=c.call_type_id WHERE date_format(p.time_to_start,&#39;%Y:%m:%d %k:%i&#39;)<date_format(now(),&#39;%Y:%m:%d %k:%i&#39;) AND p.completed=0 AND p.abandoned=0 AND &#39;&#39; BETWEEN substr(c.local_call_time_span,1,5) AND substr(c.local_call_time_span,7) AND p.time_to_start < DATE_ADD(now(),INTERVAL c.attempt_window_length day)','','sql','2010-06-29 00:51:45');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('37','SELECT p.phone_call_id, p.phone_number AS number,p.call_content AS content,c.attempt_frequency AS frequency,p.time_to_start AS start_date_time FROM phone_call p JOIN call_type c ON p.call_type_id=c.call_type_id WHERE date_format(p.time_to_start,&#39;%Y:%m:%d %k:%i&#39;)<date_format(now(),&#39;%Y:%m:%d %k:%i&#39;) AND p.completed=0 AND p.abandoned=0 AND &#39;2010-06-29 00:52:41&#39; BETWEEN substr(c.local_call_time_span,1,5) AND substr(c.local_call_time_span,7) AND p.time_to_start < DATE_ADD(now(),INTERVAL c.attempt_window_length day)','','sql','2010-06-29 00:52:56');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('38','SELECT p.phone_call_id, p.phone_number AS number,p.call_content AS content,c.attempt_frequency AS frequency,p.time_to_start AS start_date_time FROM phone_call p JOIN call_type c ON p.call_type_id=c.call_type_id WHERE date_format(p.time_to_start,&#39;%Y:%m:%d %k:%i&#39;)<date_format(now(),&#39;%Y:%m:%d %k:%i&#39;) AND &#39;2010-06-29 00:52:41&#39; BETWEEN substr(c.local_call_time_span,1,5) AND substr(c.local_call_time_span,7) AND p.time_to_start < DATE_ADD(now(),INTERVAL c.attempt_window_length day)','','sql','2010-06-29 00:53:10');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('39','SELECT p.phone_call_id, p.phone_number AS number,p.call_content AS content,c.attempt_frequency AS frequency,p.time_to_start AS start_date_time FROM phone_call p JOIN call_type c ON p.call_type_id=c.call_type_id, completed, abandoned WHERE date_format(p.time_to_start,&#39;%Y:%m:%d %k:%i&#39;)<date_format(now(),&#39;%Y:%m:%d %k:%i&#39;) AND p.completed=0 AND p.abandoned=0 AND &#39;2010-06-29 00:54:18&#39; BETWEEN substr(c.local_call_time_span,1,5) AND substr(c.local_call_time_span,7) AND p.time_to_start < DATE_ADD(now(),INTERVAL c.attempt_window_length day)','','sql','2010-06-29 00:54:34');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('40','SELECT p.phone_call_id, p.phone_number AS number,p.call_content AS content,c.attempt_frequency AS frequency,p.time_to_start AS start_date_time, completed, abandoned FROM phone_call p JOIN call_type c ON p.call_type_id=c.call_type_id WHERE date_format(p.time_to_start,&#39;%Y:%m:%d %k:%i&#39;)<date_format(now(),&#39;%Y:%m:%d %k:%i&#39;) AND p.completed=0 AND p.abandoned=0 AND &#39;2010-06-29 00:55:03&#39; BETWEEN substr(c.local_call_time_span,1,5) AND substr(c.local_call_time_span,7) AND p.time_to_start < DATE_ADD(now(),INTERVAL c.attempt_window_length day)','','sql','2010-06-29 00:55:19');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('41','SELECT p.phone_call_id, p.phone_number AS number,p.call_content AS content,c.attempt_frequency AS frequency,p.time_to_start AS start_date_time, completed, abandoned FROM phone_call p JOIN call_type c ON p.call_type_id=c.call_type_id WHERE date_format(p.time_to_start,&#39;%Y:%m:%d %k:%i&#39;)<date_format(now(),&#39;%Y:%m:%d %k:%i&#39;) AND AND &#39;2010-06-29 00:55:03&#39; BETWEEN substr(c.local_call_time_span,1,5) AND substr(c.local_call_time_span,7) AND p.time_to_start < DATE_ADD(now(),INTERVAL c.attempt_window_length day)','','sql','2010-06-29 00:55:33');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('42','SELECT p.phone_call_id, p.phone_number AS number,p.call_content AS content,c.attempt_frequency AS frequency,p.time_to_start AS start_date_time, completed, abandoned FROM phone_call p JOIN call_type c ON p.call_type_id=c.call_type_id WHERE date_format(p.time_to_start,&#39;%Y:%m:%d %k:%i&#39;)<date_format(now(),&#39;%Y:%m:%d %k:%i&#39;) AND &#39;2010-06-29 00:55:03&#39; BETWEEN substr(c.local_call_time_span,1,5) AND substr(c.local_call_time_span,7) AND p.time_to_start < DATE_ADD(now(),INTERVAL c.attempt_window_length day)','','sql','2010-06-29 00:55:50');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('43','update phone_call set completed=0','','sql','2010-06-29 00:57:34');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('44','select * from phone_call','','sql','2010-06-29 00:58:42');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('45','SELECT p.phone_call_id, p.phone_number AS number,p.call_content AS content,c.attempt_frequency AS frequency,p.time_to_start AS start_date_time FROM phone_call p JOIN call_type c ON p.call_type_id=c.call_type_id, completed, abandoned WHERE date_format(p.time_to_start,&#39;%Y:%m:%d %k:%i&#39;)<date_format(now(),&#39;%Y:%m:%d %k:%i&#39;) AND p.completed is null AND p.abandoned=0 AND &#39;2010-06-29 00:54:18&#39; BETWEEN substr(c.local_call_time_span,1,5) AND substr(c.local_call_time_span,7) AND p.time_to_start < DATE_ADD(now(),INTERVAL c.attempt_window_length day)','','sql','2010-06-29 01:15:39');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('46','SELECT completed, abandoned, p.phone_call_id, p.phone_number AS number,p.call_content AS content,c.attempt_frequency AS frequency,p.time_to_start AS start_date_time FROM phone_call p JOIN call_type c ON p.call_type_id=c.call_type_id WHERE date_format(p.time_to_start,&#39;%Y:%m:%d %k:%i&#39;)<date_format(now(),&#39;%Y:%m:%d %k:%i&#39;) AND p.completed is null AND p.abandoned=0 AND &#39;2010-06-29 00:54:18&#39; BETWEEN substr(c.local_call_time_span,1,5) AND substr(c.local_call_time_span,7) AND p.time_to_start < DATE_ADD(now(),INTERVAL c.attempt_window_length day)','','sql','2010-06-29 01:16:08');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('47','select * from phone_call','','sql','2010-06-29 01:27:41');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('48','update phone_call set completed=null where phone_call_id=12','','sql','2010-06-29 01:32:20');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('49','select * from phone_call','','sql','2010-07-04 20:12:22');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('50','truncate table phone_call; truncate table personal_calendar_event','','sql','2010-07-04 20:15:40');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('51','show create table medboxx_box.phonecall_status','','sql','2010-07-05 02:46:50');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('52','UPDATE phone_call SET phonecall_status_id=&#39;2&#39;, last_attempt=now(),attempt_count=attempt_count+1 WHERE phone_call_id=&#39;42&#39;','','sql','2010-07-05 15:25:49');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('53','SELECT p.phone_call_id, p.phone_number AS number,p.call_content AS content,c.attempt_frequency AS frequency,p.time_to_start AS start_date_time, completed, abandoned FROM phone_call p JOIN call_type c ON p.call_type_id=c.call_type_id WHERE date_format(p.time_to_start,&#39;%Y:%m:%d %k:%i&#39;)<date_format(now(),&#39;%Y:%m:%d %k:%i&#39;) AND (phonecall_status_id=1 OR phonecall_status_id>3) AND email_only =0 AND phonecall_only =1 AND &#39;".$nowSQLtime ."&#39; BETWEEN substr(c.local_call_time_span,1,5) AND substr(c.local_call_time_span,7) AND p.time_to_start < DATE_ADD(now(),INTERVAL c.attempt_window_length day)','','sql','2010-07-05 15:26:56');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('54','SELECT p.phone_call_id, p.phone_number AS number,p.call_content AS content,c.attempt_frequency AS frequency,p.time_to_start AS start_date_time, completed, abandoned FROM phone_call p JOIN call_type c ON p.call_type_id=c.call_type_id WHERE (phonecall_status_id=1 OR phonecall_status_id>3) AND email_only =0 AND phonecall_only =1 AND now() BETWEEN substr(c.local_call_time_span,1,5) AND substr(c.local_call_time_span,7) AND p.time_to_start < DATE_ADD(now(),INTERVAL c.attempt_window_length day)','','sql','2010-07-05 15:27:32');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('55','update phone_call set phone_number=&#39;18453401090&#39;','','sql','2010-07-05 15:30:24');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('56','update phone_call set phone_number=&#39;19176504575&#39; where phone_call_id<34','','sql','2010-07-05 15:37:02');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('57','SELECT phonecall_status_id, phone_call_id, phone_number,call_content, completed, abandoned FROM phone_call p 
		WHERE phonecall_status_id=1
		AND attempt_count < 4
		AND email_only =0 
		AND phonecall_only =1 
		AND time_to_start < now()','','sql','2010-07-06 13:07:14');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('58','SELECT phonecall_status_id, phone_call_id, phone_number,call_content, completed, abandoned FROM phone_call p 
		WHERE phonecall_status_id=1
		AND attempt_count < 4
		AND email_only =0 
		AND phonecall_only =1 
		AND time_to_start < &#39;2010-7-08&#39;','','sql','2010-07-06 13:07:53');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('59','SELECT phonecall_status_id, phone_call_id, phone_number,call_content 
		FROM phone_call p 
		WHERE phonecall_status_id=1
		AND attempt_count < 4
		AND email_only =0 
		AND phonecall_only =1 
		AND time_to_start < now()";','','sql','2010-07-06 13:10:52');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('60','SELECT phonecall_status_id, phone_call_id, phone_number,call_content 
		FROM phone_call p 
		WHERE phonecall_status_id=1
		AND attempt_count < 4
		AND email_only =0 
		AND phonecall_only =1 
		AND time_to_start < now()','','sql','2010-07-06 13:11:01');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('61','SELECT phonecall_status_id, phone_call_id, phone_number,call_content 
		FROM phone_call p 
		WHERE phonecall_status_id=1
		AND attempt_count < 4
		AND email_only =0 
		AND phonecall_only =1 
		AND time_to_start < &#39;2010-7-6&#39;','','sql','2010-07-06 13:11:18');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('62','SELECT phonecall_status_id, phone_call_id, phone_number,call_content 
		FROM phone_call p 
		WHERE phonecall_status_id=1
		AND attempt_count < 4
		AND email_only =0 
		AND phonecall_only =1 
		AND time_to_start < &#39;2010-7-7&#39;','','sql','2010-07-06 13:11:22');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('63','SELECT phonecall_status_id, phone_call_id, phone_number,call_content 
		FROM phone_call p 
		WHERE phonecall_status_id=1
		AND attempt_count < 4
		AND email_only =0 
		AND phonecall_only =1 
		AND time_to_start < &#39;2010-7-8&#39;','','sql','2010-07-06 13:11:27');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('64','SELECT phonecall_status_id, phone_call_id, phone_number,call_content 
		FROM phone_call p 
		WHERE phonecall_status_id=1
		AND attempt_count < 4
		AND email_only =0 
		AND phonecall_only =1 
		AND time_to_start < &#39;2010-7-7 15:00&#39;','','sql','2010-07-06 13:11:44');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('65','SELECT phonecall_status_id, phone_call_id, phone_number,call_content 
		FROM phone_call p 
		WHERE phonecall_status_id=1
		AND attempt_count < 4
		AND email_only =0 
		AND phonecall_only =1 
		AND time_to_start < &#39;2010-7-7 15:00:00&#39;','','sql','2010-07-06 13:11:51');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('66','SELECT phonecall_status_id, phone_call_id, phone_number,call_content 
		FROM phone_call p 
		WHERE phonecall_status_id=1
		AND attempt_count < 4
		AND email_only =0 
		AND phonecall_only =1 
		AND time_to_start < &#39;2010-7-8 15:00:00&#39;','','sql','2010-07-06 13:11:56');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('67','SELECT phonecall_status_id, phone_call_id, phone_number,call_content, time_to_start
		FROM phone_call p 
		WHERE phonecall_status_id=1
		AND attempt_count < 4
		AND email_only =0 
		AND phonecall_only =1 
		AND time_to_start < &#39;2010-7-8 15:30&#39;','','sql','2010-07-06 13:12:55');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('68','SELECT phonecall_status_id, phone_call_id, phone_number,call_content, time_to_start
		FROM phone_call p 
		WHERE phonecall_status_id=1
		AND attempt_count < 4
		AND email_only =0 
		AND phonecall_only =1 
		AND time_to_start < &#39;2010-7-7 15:30&#39;','','sql','2010-07-06 13:13:21');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('69','SELECT phonecall_status_id, phone_call_id, phone_number,call_content, time_to_start
		FROM phone_call p 
		WHERE phonecall_status_id=1
		AND attempt_count < 4
		AND email_only =0 
		AND phonecall_only =1 
		AND time_to_start < &#39;2010-07-06 13:16:14&#39;','','sql','2010-07-06 13:16:29');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('70','SELECT phonecall_status_id, phone_call_id, phone_number,call_content, time_to_start
		FROM phone_call p 
		WHERE phonecall_status_id=1
		AND attempt_count < 4
		AND email_only =0 
		AND phonecall_only =1 
		AND time_to_start < &#39;2010-07-07 13:16:14&#39;','','sql','2010-07-06 13:16:36');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('71','SELECT phonecall_status_id, phone_call_id, phone_number,call_content, time_to_start
		FROM phone_call p 
		WHERE phonecall_status_id=1
		AND attempt_count < 4
		AND email_only =0 
		AND phonecall_only =1 
		AND time_to_start < &#39;2010-07-08 13:16:14&#39;','','sql','2010-07-06 13:16:49');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('72','SELECT phonecall_status_id, phone_call_id, phone_number,call_content, time_to_start
		FROM phone_call p 
		WHERE phonecall_status_id=1
		AND attempt_count < 4
		AND email_only =0 
		AND phonecall_only =1 
		AND time_to_start < &#39;2010-07-07 13:16:14&#39;','','sql','2010-07-06 13:16:58');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('73','SELECT phonecall_status_id, phone_call_id, phone_number,call_content, time_to_start
		FROM phone_call p 
		WHERE phonecall_status_id=1
		AND attempt_count < 4
		AND email_only =0 
		AND phonecall_only =1 
		AND time_to_start < &#39;2010-07-07 15:16:14&#39;','','sql','2010-07-06 13:17:04');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('74','select * from medboxx_box.tf_column_info WHERE table_name=&#39;formlog&#39; AND column_name=&#39;form_content&#39;','','sql','2010-07-08 21:13:51');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('75','update phone_call set phone_number=&#39;18452465599&#39; where client=36','','sql','2010-07-11 19:22:11');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('76','update phone_call set phone_number=&#39;18452465599&#39; where client_id=36','','sql','2010-07-11 19:22:18');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('77','update phone_call set phone_number=&#39;18452465599&#39; where callee_id=36','','sql','2010-07-11 19:22:31');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('78','update phone_call set phone_number=&#39;19176504575&#39; where callee_id=35','','sql','2010-07-11 19:23:12');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('79','date(\"Y-m-d H:i:s\", AddUnitToDate(time(), 15, \"i\"));','','php','2010-07-14 01:09:19');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('80','date(&#39;Y-m-d H:i:s&#39;, AddUnitToDate(time(), 15, &#39;i&#39;));','','php','2010-07-14 01:09:29');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('81','UPDATE phone_call SET time_to_start=&#39;2009-12-12 12:12:12&#39;, phonecall_status_id=&#39;7&#39; WHERE phone_call_id=&#39;1&#39;','','sql','2010-07-14 01:14:01');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('82','medboxx_box.login(`password`,`email`,`type`,`username`) VALUES(&#39;pool&#39;,&#39;gusm@standardsourcemedia.com&#39;,&#39;office&#39;,&#39;geraldford&#39;)','','sql','2010-07-18 23:46:42');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('83','INSERT INTO medboxx_box.login(`password`,`email`,`type`,`username`) VALUES(&#39;pool&#39;,&#39;gusm@standardsourcemedia.com&#39;,&#39;office&#39;,&#39;geraldford&#39;)','','sql','2010-07-18 23:47:09');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('84','INSERT INTO medboxx_box.office(`office_name`,`subdomain`,`address`,`city`,`state_code`,`zip`,`phone`,`timezone_id`,`email`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`office_text`,`second_phonecall`,`third_phonecall`,`phonecall_time`,`days_open`,`midday_closed`,`holidays`,`is_office`,`date_created`,`date_lastvisited`,`visitcount`,`login_id`) VALUES(&#39;Gerald Ford&#39;s Lab&#39;,&#39;geraldford&#39;,&#39;12 Rum Drinker Road&#39;,&#39;Runcey&#39;,&#39;IN&#39;,&#39;44332&#39;,&#39;4443334433&#39;,&#39;7&#39;,&#39;gusm@standardsourcemedia.com&#39;,&#39;Please please call me and don&#39;t forget to write.&#39;,&#39;12&#39;,&#39;14&#39;,&#39;222&#39;,&#39;15&#39;,&#39;9*17&#39;,&#39;18&#39;,&#39;9&#39;,&#39;&#39;,&#39;1&#39;,&#39;this is my office text&#39;,&#39;&#39;,&#39;&#39;,&#39;19&#39;,&#39;1*5&#39;,&#39;12*13&#39;,&#39;12/25 01/01 thanksgiving&#39;,&#39;1&#39;,&#39;2010-07-18 23:36:15&#39;,&#39;2010-07-18 23:36:15&#39;,&#39;1&#39;','','sql','2010-07-18 23:49:22');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('85','INSERT INTO medboxx_box.office(`office_name`,`subdomain`,`address`,`city`,`state_code`,`zip`,`phone`,`timezone_id`,`email`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`office_text`,`second_phonecall`,`third_phonecall`,`phonecall_time`,`days_open`,`midday_closed`,`holidays`,`is_office`,`date_created`,`date_lastvisited`,`visitcount`,`login_id`) VALUES(&#39;Gerald Ford&#39;s Lab&#39;,&#39;geraldford&#39;,&#39;12 Rum Drinker Road&#39;,&#39;Runcey&#39;,&#39;IN&#39;,&#39;44332&#39;,&#39;4443334433&#39;,&#39;7&#39;,&#39;gusm@standardsourcemedia.com&#39;,&#39;Please please call me and don&#39;t forget to write.&#39;,&#39;12&#39;,&#39;14&#39;,&#39;222&#39;,&#39;15&#39;,&#39;9*17&#39;,&#39;18&#39;,&#39;9&#39;,&#39;&#39;,&#39;1&#39;,&#39;this is my office text&#39;,&#39;&#39;,&#39;&#39;,&#39;19&#39;,&#39;1*5&#39;,&#39;12*13&#39;,&#39;12/25 01/01 thanksgiving&#39;,&#39;1&#39;,&#39;2010-07-18 23:36:15&#39;,&#39;2010-07-18 23:36:15&#39;,&#39;1&#39;','','sql','2010-07-18 23:56:45');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('86','INSERT INTO medboxx_box.office(`office_name`,`subdomain`,`address`,`city`,`state_code`,`zip`,`phone`,`timezone_id`,`email`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`office_text`,`second_phonecall`,`third_phonecall`,`phonecall_time`,`days_open`,`midday_closed`,`holidays`,`is_office`,`date_created`,`date_lastvisited`,`visitcount`,`login_id`) VALUES(&#39;Gerald Ford&#39;s Lab&#39;,&#39;geraldford&#39;,&#39;12 Rum Drinker Road&#39;,&#39;Runcey&#39;,&#39;IN&#39;,&#39;44332&#39;,&#39;4443334433&#39;,&#39;7&#39;,&#39;gusm@standardsourcemedia.com&#39;,&#39;Please please call me and don&#39;t forget to write.&#39;,&#39;12&#39;,&#39;14&#39;,&#39;222&#39;,&#39;15&#39;,&#39;9*17&#39;,&#39;18&#39;,&#39;9&#39;,&#39;&#39;,&#39;1&#39;,&#39;this is my office text&#39;,&#39;&#39;,&#39;&#39;,&#39;19&#39;,&#39;1*5&#39;,&#39;12*13&#39;,&#39;12/25 01/01 thanksgiving&#39;,&#39;1&#39;,&#39;2010-07-18 23:36:15&#39;,&#39;2010-07-18 23:36:15&#39;,&#39;1&#39;','','sql','2010-07-18 23:56:47');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('87','delete from server_task where task_type=7','','sql','2010-07-22 03:13:58');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('89','UPDATE phone_call WHERE phonecall_status_id=2 AND last_attempt < &#39;2010-07-22 04:15:55&#39; SET phonecall_status_id = 1','','sql','2010-07-22 03:18:47');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('90','UPDATE phone_call WHERE phonecall_status_id=2 AND last_attempt < &#39;2010-07-22 04:20:54&#39; SET phonecall_status_id = 1','','sql','2010-07-22 03:21:13');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('91','UPDATE phone_call SET phonecall_status_id = 1 WHERE phonecall_status_id=2 AND last_attempt < &#39;2010-07-22 04:21:58&#39;','','sql','2010-07-22 03:22:22');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('92','UPDATE phone_call SET phonecall_status_id = 1 WHERE phonecall_status_id=2 AND attempt_count<3 AND last_attempt < &#39;2010-07-22 04:28:16&#39;','','sql','2010-07-22 03:28:30');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('93','SELECT 1 FROM medboxx_box.office WHERE office_id = &#39;48&#39;','','sql','2010-07-28 17:10:08');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('94','SELECT * FROM medboxx_box.office WHERE office_id = &#39;48&#39;','','sql','2010-07-28 17:10:50');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('95','show create table medboxx_box.promo_code','','sql','2010-08-04 18:21:55');
INSERT INTO glamourboxx.tf_scriptlog(`scriptlog_id`,`pre_script`,`post_script`,`type`,`time_executed`) VALUES('96','create database glamourboxx','','sql','2010-08-16 17:40:12');


CREATE TABLE `tf_sqllog` (
  `sqllog_id` int(11) NOT NULL auto_increment,
  `sql_string` text,
  `time_executed` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`sqllog_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;





CREATE TABLE `tf_validation_pattern` (
  `validation_pattern_id` int(11) NOT NULL auto_increment,
  `name` varchar(20) default NULL,
  `pattern` varchar(255) default NULL,
  PRIMARY KEY  (`validation_pattern_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;



INSERT INTO glamourboxx.tf_validation_pattern(`validation_pattern_id`,`name`,`pattern`) VALUES('1','email','^.+@[^\\.].*\\.[a-z]{2,}$');
INSERT INTO glamourboxx.tf_validation_pattern(`validation_pattern_id`,`name`,`pattern`) VALUES('2','American phone','^(?:\\([2-9]\\d{2}\\)\\ ?|[2-9]\\d{2}(?:\\-?|\\ ?))[2-9]\\d{2}[- ]?\\d{4}$');
INSERT INTO glamourboxx.tf_validation_pattern(`validation_pattern_id`,`name`,`pattern`) VALUES('3','American postal code','^\\d{5}-\\d{4}|\\d{5}|[A-Z]\\d[A-Z] \\d[A-Z]\\d$');
INSERT INTO glamourboxx.tf_validation_pattern(`validation_pattern_id`,`name`,`pattern`) VALUES('4','five digit zipcode','^\\d{5}$');
INSERT INTO glamourboxx.tf_validation_pattern(`validation_pattern_id`,`name`,`pattern`) VALUES('5','zip+4 zipcode','^\\d{5}-\\d{4}$');
INSERT INTO glamourboxx.tf_validation_pattern(`validation_pattern_id`,`name`,`pattern`) VALUES('6','URL','^&#40;ht|f&#41;tp&#40;&#40;?<=http&#41;s&#41;?://&#40;&#40;?<=http://&#41;www|&#40;?<=https://&#41;www|&#40;?<=ftp://&#41;ftp&#41;\\.&#40;&#40;[a-z][0-9]&#41;|&#40;[0-9][a-z]&#41;|&#40;[a-z0-9][a-z0-9\\-]{1,2}[a-z0-9]&#41;|&#40;[a-z0-9][a-z0-9\\-]&#40;&#4');


CREATE TABLE `tf_validation_type` (
  `validation_type_id` int(11) NOT NULL auto_increment,
  `type_name` varchar(45) default NULL,
  PRIMARY KEY  (`validation_type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;



INSERT INTO glamourboxx.tf_validation_type(`validation_type_id`,`type_name`) VALUES('1','no validation');
INSERT INTO glamourboxx.tf_validation_type(`validation_type_id`,`type_name`) VALUES('2','must fit pattern if field not empty');
INSERT INTO glamourboxx.tf_validation_type(`validation_type_id`,`type_name`) VALUES('3','must always fit pattern');
INSERT INTO glamourboxx.tf_validation_type(`validation_type_id`,`type_name`) VALUES('4','must never fit pattern');
INSERT INTO glamourboxx.tf_validation_type(`validation_type_id`,`type_name`) VALUES('5','must never fit pattern if field not empty');


CREATE TABLE `timezone` (
  `timezone_id` int(11) NOT NULL auto_increment,
  `timezone_name` varchar(50) default NULL,
  `dif_from_GMT` varchar(50) default NULL,
  PRIMARY KEY  (`timezone_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;



INSERT INTO glamourboxx.timezone(`timezone_id`,`timezone_name`,`dif_from_GMT`) VALUES('1','Greenwich Mean Time','0');
INSERT INTO glamourboxx.timezone(`timezone_id`,`timezone_name`,`dif_from_GMT`) VALUES('2','Central African Time','-1');
INSERT INTO glamourboxx.timezone(`timezone_id`,`timezone_name`,`dif_from_GMT`) VALUES('3','South Atlantic Time','-2');
INSERT INTO glamourboxx.timezone(`timezone_id`,`timezone_name`,`dif_from_GMT`) VALUES('4','Brazil Eastern Time','-3');
INSERT INTO glamourboxx.timezone(`timezone_id`,`timezone_name`,`dif_from_GMT`) VALUES('5','Newfoundland Time','-3.5');
INSERT INTO glamourboxx.timezone(`timezone_id`,`timezone_name`,`dif_from_GMT`) VALUES('6','Atlantic Time','-4');
INSERT INTO glamourboxx.timezone(`timezone_id`,`timezone_name`,`dif_from_GMT`) VALUES('7','Eastern North American Time','-5');
INSERT INTO glamourboxx.timezone(`timezone_id`,`timezone_name`,`dif_from_GMT`) VALUES('8','Central North American Time','-6');
INSERT INTO glamourboxx.timezone(`timezone_id`,`timezone_name`,`dif_from_GMT`) VALUES('9','Mountain North American Time','-7');
INSERT INTO glamourboxx.timezone(`timezone_id`,`timezone_name`,`dif_from_GMT`) VALUES('10','Pacific North American Time','-8');
INSERT INTO glamourboxx.timezone(`timezone_id`,`timezone_name`,`dif_from_GMT`) VALUES('11','Alaska Time','-9');
INSERT INTO glamourboxx.timezone(`timezone_id`,`timezone_name`,`dif_from_GMT`) VALUES('12','Hawaii Time','-10');
INSERT INTO glamourboxx.timezone(`timezone_id`,`timezone_name`,`dif_from_GMT`) VALUES('13','Midway Islands Time','-11');
INSERT INTO glamourboxx.timezone(`timezone_id`,`timezone_name`,`dif_from_GMT`) VALUES('14','New Zealand Time','12');
INSERT INTO glamourboxx.timezone(`timezone_id`,`timezone_name`,`dif_from_GMT`) VALUES('15','Solomon Time','11');
INSERT INTO glamourboxx.timezone(`timezone_id`,`timezone_name`,`dif_from_GMT`) VALUES('16','Australia Eastern','10');
INSERT INTO glamourboxx.timezone(`timezone_id`,`timezone_name`,`dif_from_GMT`) VALUES('17','Australia Central','9.5');


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



INSERT INTO glamourboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('1','Kingston Medical Center','kingstonmed','','','','pool','1999-11-30','16 Mercury Road','Kingston','NY','12443','bigfun@verizon.net','845 340 1090','7','','','','','','','0','','','0','','','','','','0','','','','Gus Mueller','2','12','22','15','9*17','1*5','12*13','12/25 01/01 thanksgiving','1','1','1','1969-12-31 19:00:00','1969-12-31 19:00:00','0','Situated in the gorgeous Hudson Valley of New York, Kingston Medical has the latest equipment and the highest-rated staff to help you with all your medical needs.','1','2','3','0','0','0','18');
INSERT INTO glamourboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('5','','','','Harold','Kumar','pool','1965-06-12','333 Richard Lane','Richardville','','12434','bigfune@verizon.net','2221212212','0','','','','','','','0','','','0','','','','','','0','','','','','','','','0','','','','','0','0','1','2010-01-23 11:00:30','2010-01-23 11:00:30','1','','0','0','0','0','0','0','0');
INSERT INTO glamourboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('3','Georgia Medical Center','gmc','','','','','0000-00-00','123 Atlanta Blvd.','Atlanta','','33221','master@gmc.edu','2221212212','0','','','','','','','0','','','0','','','','','','0','','','','Gus Mueller','21','332','122','0','','','','','0','1','1','2010-01-23 08:17:55','2010-01-23 08:17:55','0','','0','0','0','0','0','0','0');
INSERT INTO glamourboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('4','Houston Medical Center','houston','','','','pool','0000-00-00','232 Hospital Road','Houston','','TX','houston@houston.com','845 340 1090','0','','','','','','','0','','','0','','','','','','0','','','','Gerald Houston','1','2','33','0','','','','','0','1','1','2010-01-23 08:19:05','2010-01-23 08:19:05','0','','0','0','0','0','0','0','0');
INSERT INTO glamourboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('6','','','','Gerald','Friendmer','pool','0000-00-00','333 Richard Lane','Billings','','12434','bigfune@verizon.net','2221212212','0','','','','','','','0','','','0','','','','','','0','','','','','','','','0','','','','','0','1','1','2010-01-23 11:00:30','2010-01-23 11:00:30','1','','0','0','0','0','0','0','0');
INSERT INTO glamourboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('7','','','','Ginger','Smith','33','1929-08-04','333 Richard Lane','Verona','','77887','bigfune@verizon.net','2221212212','0','','','','','','','0','','','0','','','','','','0','','','','','','','','0','','','','','0','0','1','2010-01-23 11:00:30','2010-01-23 11:00:30','1','','0','0','0','0','0','0','0');
INSERT INTO glamourboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('8','','','','Ozzie','Jones','','1979-04-19','333 Richard Lane','Stafford','','55443','bigfune@verizon.net','2221212212','0','','','','','','','0','','','0','','','','','','0','','','','','','','','0','','','','','0','0','1','2010-01-23 11:00:30','2010-01-23 11:00:30','1','','0','0','0','0','0','0','0');
INSERT INTO glamourboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('9','','','','George','Roberts','5','1989-07-14','333 Richard Lane','Klingerville','','22334','bigfune@verizon.net','2221212212','0','','','','','','','0','','','0','','','','','','0','','','','','','','','0','','','','','0','0','1','2010-01-23 11:00:30','2010-01-23 11:00:30','1','','0','0','0','0','0','0','0');
INSERT INTO glamourboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('10','','','','Steve','Franklin','6','1949-08-25','333 Richard Lane','Sepialand','','90977','bigfunwe@verizon.net','2221212212','0','','','','','','','0','','','0','','','','','','0','','','','','','','','0','','','','','0','0','1','2010-01-23 11:00:30','2010-01-23 11:00:30','1','','0','0','0','0','0','0','0');
INSERT INTO glamourboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('11','','','','Brian','Barnes','huskers','1959-05-17','8436 Wirt St.','Omaha','','68134','brian@voicendata.net','4025719049','0','','','','','','','0','','','0','','','','','','0','','','','','','','','0','','','','','0','0','1','2010-02-02 20:12:18','2010-02-02 20:12:18','1','','0','0','0','0','0','0','0');
INSERT INTO glamourboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('31','','','','Laura','Laura','','1958-08-03','22 4th st','kingston','NY','12477','','1917 650 4575','0','','','','','','','0','','','0','','','','','','0','','','','','','','','0','','','','','0','0','1','2010-02-19 19:11:15','2010-02-19 19:11:15','1','','0','0','0','0','0','0','0');
INSERT INTO glamourboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('30','','','Homer Simpson','Bart','Simpson','pool','1989-01-07','742 Evergreen Terrace','Springfield','XA','11111','bart@verizon.net','2221212212','0','2221212222','','','','','','0','','','0','','','','','','0','','','','','','','','0','','','','','0','0','1','1970-01-01 00:00:00','1970-01-01 00:00:00','0','','0','0','0','0','0','0','0');
INSERT INTO glamourboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('26','','','Harold Flingerman','David','Flingerman','pool','1999-12-07','1 Manster Lane','Jillersburg','ME','02211','goop@voop.com','2221112222','0','','2221119988','Ritter Lane Northeast','MA','02221','226091977','2','Eugle Dental Insurance','33112334','3','Foop Optical','332423423232','Man on the Moon','I dont feel very gwood!','Launch.com','0','','','','','','','','0','','','','','0','0','1','2010-02-13 22:06:04','2010-02-13 22:06:04','1','','0','0','0','0','0','0','0');
INSERT INTO glamourboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('27','','','Maud Richter','Peter','Flingerman','pool','1999-02-07','2 Manster Lane','Jillersburg','ME','02211','goop2@voop.com','2221112222','0','','2221119988','Ritter Lane Northeast','MA','02221','226091977','2','Eugle Dental Insurance','33112334','3','Foop Optical','332423423232','Man on the Moon','I dont feel very gwood!','Launch.com','0','','','','','','','','0','','','','','0','0','1','2010-02-13 22:06:04','2010-02-13 22:06:04','1','','0','0','0','0','0','0','0');
INSERT INTO glamourboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('28','','','','Dennis','Dennis','453453','2000-10-14','576 5th Ave','Saugerties','NY','12477','denniso@standardsourcemedia.com','19176504575','0','','','same','','','234564309','1','Blue Cross','456754','0','','','Dr. Roll','pain','self','0','','','','','','','','0','','','','','0','0','1','2010-02-14 21:17:42','2010-02-14 21:17:42','1','','0','0','0','0','0','0','0');
INSERT INTO glamourboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('40','','','','David','Managerson','','1972-01-19','25 Dug Hill Road','Dallas','TX','55443','bun@verizon.net','2156654433','0','','','','','','','0','','','0','','','','','','0','','','','','','','','0','','','','','2','0','1','0000-00-00 00:00:00','0000-00-00 00:00:00','0','','0','0','0','0','0','0','0');
INSERT INTO glamourboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('41','','','','','','pool','0000-00-00','','','','','','','0','','','','','','','0','','','0','','bigfun@verizon.net','','','','0','','','','','','','','0','','','','','0','0','1','2010-02-21 21:12:13','2010-02-21 21:12:13','1','','0','0','0','0','0','0','0');
INSERT INTO glamourboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('42','','','','','','pool','0000-00-00','','','','','','','0','','','','','','','0','','','0','','bigfun@verizon.net','','','','0','','','','','','','','0','','','','','0','0','1','2010-02-21 21:12:22','2010-02-21 21:12:22','1','','0','0','0','0','0','0','0');
INSERT INTO glamourboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('43','','','','Fred','Vroomer','pool','1982-11-14','','','','','','','7','','','','','','','0','','','0','','','','','','0','','','','','','','','0','','','','','0','0','1','2010-02-21 21:15:41','2010-02-21 21:15:41','1','','0','0','0','0','0','0','0');
INSERT INTO glamourboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('44','','','','Karlos','Muelleruez','pool','1913-01-02','25 Dug Hill Road','Juneau','AK','12434','man@verizon.net','18453401090','7','','','','','','226091977','0','','','0','','','','ouch!','Launch.com','0','Gretchen Primack','','','','','','','0','','','','','0','0','1','2010-02-25 04:25:50','2010-02-25 04:25:50','1','','0','0','0','0','0','0','0');
INSERT INTO glamourboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('45','','','','Vicky','Signalwave','pool','1974-01-03','55 Uppledown Lane','Boise','ID','91221','vicky@signalwave.com','2224212212','10','','3322233333','66 Mackerel Lane ','ID','91221','226061977','1','Obamacare Insurance','','0','','man@verizon.net','Man on the Moon','','Rickle&#39;s Tuneups','0','Harold Signalwave','','','','','','','0','','','','','0','0','1','2010-04-02 20:00:25','2010-04-02 20:00:25','1','','0','0','0','0','0','0','0');
INSERT INTO glamourboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('46','Holy Cross Hospital','holycross','','','','pool','0000-00-00','122 Silver Parkway','Silver Spring','MD','22112','largefun@pool.com','4443334433','7','','','','','','','0','','','0','','','','','','0','','','','tell me about it','33','121','88','15','10*16','1*5','12*13','12/25 01/01 thanksgiving','4','1','1','2010-04-03 02:51:42','2010-04-03 02:51:42','1','','0','0','0','0','0','0','0');
INSERT INTO glamourboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('47','Capitol Hospital','capitol','','','','pool','0000-00-00','122 Silver Parkway','Silver Spring','MD','22112','biglargefun@pool.com','4443334433','7','','','','','','','0','','','0','','','','','','0','','','','','33','121','88','15','10*16','1*5','12*13','12/25 01/01 thanksgiving','4','1','1','2010-04-03 02:57:33','2010-04-03 02:57:33','1','','0','0','0','0','0','0','0');
INSERT INTO glamourboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('48','Capitol Hospital','capitoler','','','','pool','0000-00-00','122 Silver Parkway','Silver Spring','MD','22112','bsiglargefun@pool.com','4443334433','7','','','','','','','0','','','0','','','','','','0','','','','','33','121','88','15','10*16','1*5','12*13','12/25 01/01 thanksgiving','4','1','1','2010-04-03 02:57:33','2010-04-03 02:57:33','1','','0','0','0','0','0','0','0');
INSERT INTO glamourboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('49','Capitol Hospital','capitoler2','','','','pool','0000-00-00','122 Silver Parkway','Silver Spring','MD','22112','bswiglargefun@pool.com','4443334433','7','','','','','','','0','','','0','','','','','','0','','','','','33','121','88','15','10*16','1*5','12*13','12/25 01/01 thanksgiving','4','1','1','2010-04-03 02:57:33','2010-04-03 02:57:33','1','','0','0','0','0','0','0','0');
INSERT INTO glamourboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('50','Capitol Hospital','capitoler3','','','','3333','0000-00-00','122 Silver Parkway','Silver Spring','MD','22112','bsw3iglargefun@pool.com','4443334433','7','','','','','','','0','','','0','','','','','','0','','','','','33','121','88','15','10*16','1*5','12*13','12/25 01/01 thanksgiving','4','1','1','2010-04-03 02:57:33','2010-04-03 02:57:33','1','','0','0','0','0','0','0','0');
INSERT INTO glamourboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('51','Capitol Hospital','capitoler43','','','','5555','0000-00-00','122 Silver Parkway','Silver Spring','MD','22112','bs4w3iglargefun@pool.com','4443334433','7','','','','','','','0','','','0','','','','','','0','','','','','33','121','88','15','10*16','1*5','12*13','12/25 01/01 thanksgiving','4','1','1','2010-04-03 02:57:33','2010-04-03 02:57:33','1','','0','0','0','0','0','0','0');
INSERT INTO glamourboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('52','Elmira Hospital','elmira','','','','pool','0000-00-00','76 Hummingbird Turnpike','Elmira','GA','33221','b22igfun@verizon.net','7436778433','7','','','','','','','0','','','0','','','','','','0','','','','333-222-1121','23','121','999','15','9*17','1*5','12*13','12/25 01/01 thanksgiving','0','1','1','2010-04-05 21:25:44','2010-04-05 21:25:44','1','Elmira features some of the best and most elite equipment manufactured by Chinese exporters.','1','2','3','0','0','0','10');
INSERT INTO glamourboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('53','','','','Dennis','Opp','pool','1986-06-04','222 Milver Highway','Saugerties','NY','12232','thompsonsquare@gmail.com','19176504575','0','','','','','','','0','','','0','','','','','','0','','','','','','','','0','','','','','0','0','1','0000-00-00 00:00:00','0000-00-00 00:00:00','0','','0','0','0','0','0','0','0');
INSERT INTO glamourboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('54','','','','Gus','Mueller','pool','1986-06-04','782 Rocker Freedomtron Highway','Saugerties','NY','12232','gus@asecular.com','18453401090','7','','','','','','','0','','','0','','','','','','0','','','','','','','','0','','','','','0','0','1','1970-01-01 00:00:00','1970-01-01 00:00:00','0','','0','0','0','0','0','0','0');
INSERT INTO glamourboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('55','Woodstock Dental','woodstockdental','','','','453453','1999-11-30','12 Tinker St','Woodstock','NY','12409','denniso2323@gmail.com','8452465599','7','','','','','','','0','','','0','','','','','','0','','','','Joanna','1','1','28','15','9*17','1*5','12*13','12/25 01/01 thanksgiving','0','1','0','2010-04-06 22:49:55','2010-04-06 22:49:55','1','','18','9','1','1','0','0','10');
INSERT INTO glamourboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('56','','','','Laura','Powell','727727','0000-00-00','','','','12477','lclar210@yahoo.com','845 246 5599','7','','','','','','','0','','','0','','','','','','0','David Spitler','','','','','','','0','','','','','0','0','1','2010-04-15 21:17:58','2010-04-15 21:17:58','1','','0','0','0','0','0','0','0');
INSERT INTO glamourboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('57','','','','David ','Spitler','453453','0000-00-00','','','','12477','denniso2323@gmail.com','917 650 4575','7','','','','','','','0','','','0','','','','','','0','Laura Powell','','','','','','','0','','','','','0','0','1','2010-04-15 21:14:52','2010-04-15 21:14:52','1','','0','0','0','0','0','0','0');
INSERT INTO glamourboxx.user(`user_id`,`office_name`,`subdomain`,`name_of_guardian`,`firstname`,`lastname`,`password`,`birthday`,`address`,`city`,`state_code`,`zip`,`email`,`phone`,`timezone_id`,`cellphone`,`business_phone`,`business_address`,`business_state_code`,`business_zip`,`social_security_number`,`insurance1_type_id`,`insurance1`,`insurance1_number`,`insurance2_type_id`,`insurance2`,`insurance2_number`,`referred_by`,`why_visiting`,`employed_by`,`marital_status`,`emergency_contact_name`,`emergency_phone`,`emergency_cellphone`,`contact_info`,`doctor_number`,`staff_number`,`patients_per_day`,`scheduling_unit_size`,`hours_open`,`days_open`,`midday_closed`,`holidays`,`call_type_id`,`is_office`,`is_active`,`date_created`,`date_lastvisited`,`visitcount`,`office_text`,`first_email`,`second_email`,`third_email`,`first_phonecall`,`second_phonecall`,`third_phonecall`,`phonecall_time`) VALUES('58','','','','Lorraine','Miller','453453','0000-00-00','','','','90211','lomille@comcast.net ','904 264 9605','7','','','','','','','0','','','0','','','','','','0','john miller','','','','','','','0','','','','','0','0','1','2010-04-15 21:31:40','2010-04-15 21:31:40','1','','0','0','0','0','0','0','0');

