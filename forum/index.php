<?php
// Main page
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
if(isset($HTTP_COOKIE_VARS['bh_sess_uid'])){
    echo "<frameset cols=\"250,*\" border=\"1\">";
    echo "<frame src=\"./thread_list.php\" name=\"left\" border=\"1\">";
    echo "<frame src=\"./messages.php";
    if($HTTP_GET_VARS['msg']){
        echo "?msg=$msg";
    }
    echo "\" name=\"right\" border=\"1\">";
    echo "</frameset>";
} else {
    echo "<frame src=\"./logon.php?final_uri=";
    echo urlencode($HTTP_SERVER_VARS['REQUEST_URI']);
    echo "\" name=\"login\" border=\"1\">";
}
?>
	</frameset>
</html>
