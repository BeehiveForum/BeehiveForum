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

/* $Id: user_font.php,v 1.20 2004-03-14 18:33:42 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

//Multiple forum support
include_once("./include/forum.inc.php");

include_once("./include/format.inc.php");
include_once("./include/header.inc.php");
include_once("./include/messages.inc.php");
include_once("./include/session.inc.php");
include_once("./include/user.inc.php");

if (!$user_sess = bh_session_check()) {

    $uri = "./logon.php?webtag={$webtag['WEBTAG']}&final_uri=". rawurlencode(get_request_uri());
    header_redirect($uri);
}

// Load the wordfilter for the current user

$user_wordfilter = load_wordfilter();

$uid = bh_session_get_value('UID');

if (isset($HTTP_GET_VARS['msg']) && validate_msg($HTTP_GET_VARS['msg'])) {
    $msg = $HTTP_GET_VARS['msg'];
}else {
    $msg = messages_get_most_recent($uid);
}

if (isset($HTTP_GET_VARS['fontsize']) && is_numeric($HTTP_GET_VARS['fontsize']) && $HTTP_GET_VARS['fontsize'] > 4 && $HTTP_GET_VARS['fontsize'] < 16 && $uid > 0) {
    
    $user_prefs = user_get_prefs(bh_session_get_value('UID'));
    $user_prefs['FONT_SIZE'] = $HTTP_GET_VARS['fontsize'];

    user_update_prefs($uid, $user_prefs);

    header_redirect("./messages.php?webtag={$webtag['WEBTAG']}&msg=$msg&fontresize=1");

}else {

   header_redirect("./messages.php?webtag={$webtag['WEBTAG']}&msg=$msg");

}

?>