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

/* $Id: user_font.php,v 1.7 2003-09-21 13:36:35 decoyduck Exp $ */

// Changes the user's fontsize. Moved from messages.php (02.05.2003)

require_once("./include/user.inc.php");
require_once("./include/session.inc.php");
require_once("./include/messages.inc.php");
require_once("./include/format.inc.php");

if (!bh_session_check()) {

    $uri = "./index.php?final_uri=". urlencode(get_request_uri());
    header_redirect($uri);

}

if (isset($HTTP_GET_VARS['msg'])) {
    $msg = $HTTP_GET_VARS['msg'];
}else {
    $msg = messages_get_most_recent(bh_session_get_value('UID'));
}

if (isset($HTTP_GET_VARS['fontsize']) && $HTTP_GET_VARS['fontsize'] > 0 && $HTTP_GET_VARS['fontsize'] < 16) {

    $userprefs = user_get_prefs(bh_session_get_value('UID'));

    user_update_prefs(bh_session_get_value('UID'), $userprefs['FIRSTNAME'], $userprefs['LASTNAME'],
                      $userprefs['DOB'], $userprefs['HOMEPAGE_URL'], $userprefs['PIC_URL'],
                      $userprefs['EMAIL_NOTIFY'], $userprefs['TIMEZONE'], $userprefs['DL_SAVING'],
                      $userprefs['MARK_AS_OF_INT'], $userprefs['POSTS_PER_PAGE'], $HTTP_GET_VARS['fontsize'],
                      $userprefs['STYLE'], $userprefs['VIEW_SIGS'], $userprefs['START_PAGE'],
                      $userprefs['LANGUAGE'], $userprefs['PM_NOTIFY'], $userprefs['PM_NOTIFY_EMAIL'],
                      $userprefs['DOB_DISPLAY'], $userprefs['ANON_LOGON'], $userprefs['SHOW_STATS']);

    bh_session_init(bh_session_get_value('UID'));
    header_redirect("./messages.php?msg=$msg");

}else {

   header_redirect("./messages.php?msg=$msg");

}

?>