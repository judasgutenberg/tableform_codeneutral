CREATE TABLE `personal_calendar_event` (
  `calendar_event_id` int(4) NOT NULL auto_increment,
  `datecode` varchar(8) default NULL,
  `recurrence_id` int(4) default NULL,
  `time` varchar(10) default NULL,
  `practitioner_id` int(4) default NULL,
  `type` varchar(40) default NULL,
  `notes` text,
  `user_id` int(4) default NULL,
  `sort_id` int(4) default NULL,
  PRIMARY KEY  (`calendar_event_id`)
);