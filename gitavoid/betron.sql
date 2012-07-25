update mdl_course_categories set coursecount = coursecount+1 where parent =0;
insert into mdl_course_sections(course, section, summary, sequence, visible) values(<id>,'News', NULL, 12, 1);
insert into mdl_context(contextlevel, instanceid, path, depth) values(50, <id>, '/1/3/120', 0); 

insert into mdl_block_instance(blockid, pageid, pagetype, `position`, weight, visible) values(20, <id>, 'course-view', 'l', 1, 1);
insert into mdl_block_instance(blockid, pageid, pagetype, `position`, weight, visible) values(1, <id>, 'course-view', 'l', 2, 1);
insert into mdl_block_instance(blockid, pageid, pagetype, `position`, weight, visible) values(25, <id>, 'course-view', 'l', 3, 1);
insert into mdl_block_instance(blockid, pageid, pagetype, `position`, weight, visible) values(2, <id>, 'course-view', 'l', 4, 1);
insert into mdl_block_instance(blockid, pageid, pagetype, `position`, weight, visible) values(9, <id>, 'course-view', 'l', 5, 1);
insert into mdl_block_instance(blockid, pageid, pagetype, `position`, weight, visible) values(18, <id>, 'course-view', 'r', 6, 1);
insert into mdl_block_instance(blockid, pageid, pagetype, `position`, weight, visible) values(8, <id>, 'course-view', 'r', 7, 1);
insert into mdl_block_instance(blockid, pageid, pagetype, `position`, weight, visible) values(22, <id>, 'course-view', 'r', 8, 1);