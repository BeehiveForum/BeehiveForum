<?php
// Main page
// Disable caching when showing logon page
require_once("./include/header.inc.php");
if(!isset($HTTP_COOKIE_VARS['bh_sess_uid'])){
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
<?
    echo "<frameset cols=\"250,*\" border=\"1\">\n";
    echo "<frame src=\"./thread_list.php\" name=\"left\" border=\"1\">\n";
    echo "<frame src=\"./messages.php";
    if($HTTP_GET_VARS['msg']){
        echo "?msg=$msg";
    }
    echo "\" name=\"right\" border=\"1\">\n";
    echo "</frameset>\n";
?>
</html>
