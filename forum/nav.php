<?php

/*======================================================================
Copyright Project BeehiveForum 2002

This file is part of BeehiveForum.

BeehiveForum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

BeehiveForum is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  
USA
======================================================================*/

// Navigation strip

require_once("./include/constants.inc.php");
require_once("./include/header.inc.php");

header_no_cache();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="stylesheet" href="./styles/style.css" type="text/css">
	</head>
    <body style="font-size: 10px; font-weight: bold; margin: 4px 1px 1px 4px; background-color: #D7D7D7">
        <a href="start.php" target="main">Start</a>&nbsp;
        <a href="discussion.php" target="main">Messages</a>&nbsp;
        <a href="prefs.php" target="main">Preferences</a>&nbsp;
        <a href="edit_profile.php" target="main">Profile</a>&nbsp;
<?
if($HTTP_COOKIE_VARS['bh_sess_ustatus'] & USER_PERM_SOLDIER){
?>
        <a href="admin.php" target="main">Admin</a>&nbsp;
<?
}
?>
        <a href="#">Logout</a>
    </body>
</html>
