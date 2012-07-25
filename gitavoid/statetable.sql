

CREATE TABLE `state` (
  `state_id` int(11) NOT NULL auto_increment,
  `code` char(3) default NULL,
  `state_name` varchar(22) default NULL,
  `co2_emission` decimal(12,3) default NULL,
  PRIMARY KEY  (`state_id`)
);

INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('1','AL','ALABAMA','1298.652');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('2','AK','ALASKA','1106.484');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('3','AZ','ARIZONA','1218.864');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('4','AR','ARKANSAS','1280.254');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('5','CA','CALIFORNIA','700.400');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('6','CO','COLORADO','1986.085');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('7','CT','CONNECTICUT','754.186');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('8','DE','DELAWARE','1803.732');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('9','FL','FLORIDA','1348.031');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('10','GA','GEORGIA','1388.331');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('11','HI','HAWAII','1654.736');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('12','ID','IDAHO','0.000');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('13','IL','ILLINOIS','1154.754');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('14','IN','INDIANA','2098.028');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('15','IA','IOWA','0.000');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('16','KS','KANSAS','1870.580');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('17','KY','KENTUCKY','2051.055');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('18','LA','LOUISIANA','1201.206');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('19','ME','MAINE','771.833');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('20','MD','MARYLAND','1293.045');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('21','MA','MASSACHUSETTS','1226.147');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('22','MI','MICHIGAN','1412.673');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('23','MN','MINNESOTA','1587.518');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('24','MS','MISSISSIPPI','1408.978');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('25','MO','MISSOURI','1881.391');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('26','MT','MONTANA','1572.928');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('27','NE','NEBRASKA','1503.084');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('28','NV','NEVADA','1572.724');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('29','NH','NEW HAMPSHIRE','779.267');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('30','NJ','NEW JERSEY','712.790');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('31','NM','NEW MEXICO','1991.983');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('32','NY','NEW YORK','907.159');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('33','NC','NORTH CAROLINA','1217.818');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('34','ND','NORTH DAKOTA','0.000');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('35','OH','OHIO','1778.971');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('36','OK','OKLAHOMA','1726.042');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('37','OR','OREGON','455.790');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('38','PA','PENNSYLVANIA','1216.211');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('39','RI','RHODE ISLAND','1070.996');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('40','SC','SOUTH CAROLINA','914.816');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('41','SD','SOUTH DAKOTA','1215.369');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('42','TN','TENNESSEE','1266.009');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('43','TX','TEXAS','1471.637');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('44','UT','UTAH','2120.814');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('45','VT','VERMONT','6.939');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('46','VA','VIRGINIA','1210.537');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('47','WA','WASHINGTON','359.933');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('48','WV','WEST VIRGINIA','1988.026');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('49','WI','WISCONSIN','1712.915');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('50','WY','WYOMING','2277.504');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('51','CZ','CANAL ZONE','0.000');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('52','DC','DISTRICT OF COLUMBIA','0.000');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('53','GU','GUAM','0.000');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('54','PR','PUERTO RICO','0.000');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('55','AS','U.S. PACIFIC IS.','0.000');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('56','US','UNITED STATES','0.000');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('57','VI','VIRGIN (U.S.) ISLANDS','0.000');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('58','AB','Alberta','0.000');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('59','BC','British Columbia','0.000');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('60','MB','Manitoba','0.000');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('61','NB','New Brunswick','0.000');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('62','NL','Newfoundland and Labra','0.000');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('63','NT','Northwest Territories','0.000');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('64','NS','Nova Scotia','0.000');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('65','NU','Nunavut','0.000');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('66','ON','Ontario','0.000');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('67','PE','Prince Edward Island','0.000');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('68','QC','Quebec','0.000');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('69','SK','Saskatchewan','0.000');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('70','YT','Yukon','0.000');
INSERT INTO state(state_id,code,state_name,co2_emission) VALUES('71','DC','DC','3614.251');


