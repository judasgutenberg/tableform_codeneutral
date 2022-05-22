Tableform Ultraquick Start Guide

Tableform is generic system for viewing and editing MySQL databases.
Unlike other systems (such as PHPMyAdmin), it is relationship-aware,
meaning that editors show sub-editors for related tables and that
Foreign key references can be displayed in human readable form (for example:
as a dropdown instead of as a meaningless number).


To install, copy all these files to a directory and edit tf_constants.php
to reflect your MySQL database.  The values that matter the most on remote servers:

con_server_web -- name of your database server
con_user_web -- name of your database user
con_pwd_web -- database user password

these are their equivalents for use on localhost: 

con_server_optional
con_user_optional
con_pwd_optional

our_db is the name of the default database.

Once you have configured Tableform, you can browse your databases and tables.

To add relationships, the best way is to drag relations inside a database map.
To do this, first click the db tools link in the upper right.
Select Show/create relationship maps....
Check off tables to appear in the map
Click the button "map selected tables"
Now you will have a map -- you can drag tables around and drag foreign keys to primary keys to create relations.
Click save map when done.

This is all written in framework-free procedural-style code, most of which predates the influence of AJAX, though it does a few AJAX-like things, and the interactive database designer is like a modern web app.
