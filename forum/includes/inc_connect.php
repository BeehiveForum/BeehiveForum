<?php

//Included functions for connecting to Project Beehive database.
//Written by Ben Sekulowicz-Barclay for Project beehive.

function connect() {
  $dbhost = 'localhost';
  $dbuser = '';
  $dbpass = '';
  $dbname = 'beehive';

  if (!mysql_connect($dbhost, $dbuser, $dbpass)) die (mysql_error());

  if (!mysql_select_db($dbname)) die (mysql_error());
}
?>



