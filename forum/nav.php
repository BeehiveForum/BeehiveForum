<?php
// Navigation strip
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="stylesheet" href="./styles/style.css" type="text/css">
	</head>
    <body style="font-size: 10px; font-weight: bold; margin: 4px 1px 1px 4px; background-color: #999999">
<?
if(isset($HTTP_COOKIE_VARS['bh_sess_uid'])){
?>
        <a href="#">Start</a>&nbsp;
        <a href="discussion.php" target="main">Messages</a>&nbsp;
        <a href="prefs.php" target="main">Preferences</a>&nbsp;
        <a href="#">Logout</a>
<?
} else {
?>
        <p>Not logged in...
<?
}
?>
    </body>
</html>
