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

/* $Id: discussion.php,v 1.25 2003-08-05 03:11:20 decoyduck Exp $ */

// Enable the error handler
require_once("./include/errorhandler.inc.php");

// Compress the output
require_once("./include/gzipenc.inc.php");

// Frameset for thread list and messages

//Check logged in status
require_once("./include/session.inc.php");
require_once("./include/header.inc.php");
require_once("./include/messages.inc.php");

if(!bh_session_check()){

    $uri = "./logon.php?final_uri=". urlencode(get_request_uri());
    header_redirect($uri);

}

// Disable caching when showing logon page
require_once("./include/header.inc.php");

if(!bh_session_get_value('UID')){
    header_no_cache();
}

require_once("./include/config.inc.php");

if (isset($HTTP_GET_VARS['folder']) && folder_is_valid($HTTP_GET_VARS['folder'])) {
    $folder = $HTTP_GET_VARS['folder'];
    $msg = messages_get_most_recent(bh_session_get_value('UID'), $folder);
}else {
    if (isset($HTTP_GET_VARS['msg'])) {
        $msg = $HTTP_GET_VARS['msg'];
    }else {
        $msg = messages_get_most_recent(bh_session_get_value('UID'));
    }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="<?php echo $lang['_textdir']; ?>">
<head>
<title><?php echo $forum_name ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $lang['_charset']; ?>">
<link rel="stylesheet" href="./styles/style.css" type="text/css" />
</head>
<frameset cols="250,*" border="1">
  <frame src="./thread_list.php<?php if (isset($folder)) { echo "?mode=0&amp;folder=$folder"; }else if (isset($msg)) { echo "?msg=$msg"; } ?>" name="left" frameborder="0" framespacing="0" />
  <frame src="./messages.php<?php if (isset($msg)) echo "?msg=$msg"; ?>" name="right" frameborder="0" framespacing="0" />
</frameset>
</html>
