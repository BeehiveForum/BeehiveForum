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

// Changes the user's fontsize. Moved from messages.php (02.05.2003)

require_once("./include/user.inc.php");
require_once("./include/session.inc.php");
require_once("./include/messages.inc.php");

if (!bh_session_check()) {

    $uri = "./index.php?final_uri=". urlencode(get_request_uri());
    header_redirect($uri);

}

if (isset($HTTP_GET_VARS['msg'])) {
    $msg = $HTTP_GET_VARS['msg'];
}else {
    $msg = messages_get_most_recent($HTTP_COOKIE_VARS['bh_sess_uid']);
}

if (isset($HTTP_GET_VARS['fontsize']) && $HTTP_GET_VARS['fontsize'] > 0 && $HTTP_GET_VARS['fontsize'] < 16) {

    $userprefs = user_get_prefs($HTTP_COOKIE_VARS['bh_sess_uid']);

    user_update_prefs($HTTP_COOKIE_VARS['bh_sess_uid'], $userprefs['FIRSTNAME'], $userprefs['LASTNAME'],
                      $userprefs['DOB'], $userprefs['HOMEPAGE_URL'], $userprefs['PIC_URL'],
                      $userprefs['EMAIL_NOTIFY'], $userprefs['TIMEZONE'], $userprefs['DL_SAVING'],
                      $userprefs['MARK_AS_OF_INT'], $userprefs['POSTS_PER_PAGE'], $HTTP_GET_VARS['fontsize'],
                      $userprefs['STYLE'], $userprefs['VIEW_SIGS'], $userprefs['START_PAGE']);

    bh_session_init($HTTP_COOKIE_VARS['bh_sess_uid']);
    header_redirect("messages.php?msg=$msg");

}else {

   header_redirect("messages.php?msg=$msg");

}

?>