<?php
// Main page
// Disable caching when showing logon page
require_once("./include/header.inc.php");
require_once("./include/session.inc.php");

$logged_in = bh_session_check();

if(!$logged_in){
    header_no_cache();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<title>:: teh forum ::</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="stylesheet" href="./styles/style.css" type="text/css">
	</head>
	<frameset rows="60,20,*" border="0">
		<frame src="./blank.html" name="top" border="0" scrolling="no" noresize>
		<frame src="./nav.php" name="nav" border="0" scrolling="no" noresize>
<?
if($logged_in){
    echo "<frame src=\"./discussion.php";
    if($HTTP_GET_VARS['msg']){
        echo "?msg=".$HTTP_GET_VARS['msg'];
    }
    echo "\" name=\"main\" border=\"1\">";
} else {
    echo "<frame src=\"./logon.php?final_uri=";
    if($HTTP_GET_VARS['msg']){
        echo urlencode(dirname($HTTP_SERVER_VARS['PHP_SELF'])."/?msg=".$HTTP_GET_VARS['msg']);
    } else {
        echo urlencode(dirname($HTTP_SERVER_VARS['PHP_SELF'])."/");
    }
    echo "\" name=\"main\" border=\"1\">";
}
?>
	</frameset>
</html>
