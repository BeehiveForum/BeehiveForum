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

/* $Id: user_stats.php,v 1.12 2004-03-15 21:33:31 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

//Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum webtag and settings
$webtag = get_webtag();
$forum_settings = get_forum_settings();

// Enable the error handler
include_once("./include/errorhandler.inc.php");

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

if (isset($HTTP_GET_VARS['show_stats']) && $uid > 0) {

    $user_prefs = user_get_prefs(bh_session_get_value('UID'));
    $user_prefs['SHOW_STATS'] = $HTTP_GET_VARS['show_stats'];

    user_update_prefs($uid, $user_prefs);

    bh_session_init(bh_session_get_value('UID'));
    header_redirect("./messages.php?webtag={$webtag['WEBTAG']}&msg=$msg");

}else {

   header_redirect("./messages.php?webtag={$webtag['WEBTAG']}&msg=$msg");

}

?>