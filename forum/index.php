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

// Main page
// Disable caching when showing logon page
require_once("./include/header.inc.php");
require_once("./include/session.inc.php");
require_once("./include/config.inc.php");

header_no_cache();

$top_html = "./styles/".(isset($HTTP_COOKIE_VARS['bh_sess_style']) ? $HTTP_COOKIE_VARS['bh_sess_style'] : $default_style) . "/top.html";

if (!file_exists($top_html)) {
	$top_html = "./top.html";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title><?php echo $forum_name; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="styles.php?<?php echo md5(uniqid(rand())); ?>" type="text/css">
</head>
<?php

if(bh_session_check()) {

    echo "<frameset rows=\"60,20,*\" border=\"0\">\n";
    echo "<frame src=\"". $top_html. "\" name=\"ftop\" border=\"0\" scrolling=\"no\" marginwidth=\"0\" marginheight=\"0\" noresize>\n";
    echo "<frame src=\"./nav.php\" name=\"fnav\" border=\"0\" scrolling=\"no\" marginwidth=\"0\" marginheight=\"0\" noresize>\n";

    if (isset($HTTP_GET_VARS['final_uri'])) {

      echo "<frame src=\"". urldecode($HTTP_GET_VARS['final_uri']). "\" name=\"main\" border=\"1\">\n";
      
    }else if (isset($HTTP_GET_VARS['msg'])) {
    
      echo "<frame src=\"./discussion.php?msg=". $HTTP_GET_VARS['msg']. "\" name=\"main\" border=\"1\">\n";
      
    }else {

      echo "<frame src=\"./start.php\" name=\"main\" border=\"1\">\n";
      
    }

} else {

    echo "<frameset rows=\"60,*\" border=\"0\">\n";
    echo "<frame src=\"". $top_html. "\" name=\"top\" border=\"0\" scrolling=\"no\" marginwidth=\"0\" marginheight=\"0\" noresize>\n";
    
    if (isset($HTTP_GET_VARS['final_uri'])) {
    
        echo "<frame src=\"./logon.php?final_uri=". $HTTP_GET_VARS['final_uri']. "\" name=\"main\" border=\"1\">\n";
        
    }elseif(isset($HTTP_GET_VARS['msg'])) {
    
        echo "<frame src=\"./logon.php?final_uri=". urlencode("./discussion.php?msg=". $HTTP_GET_VARS['msg']). "\" name=\"main\" border=\"1\">\n";
        
    }else {
    
        echo "<frame src=\"./logon.php\" name=\"main\" border=\"1\">\n";
        
    }
    
}

?>
</frameset>
</html>
