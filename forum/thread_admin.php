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

/* $Id: thread_admin.php,v 1.28 2004-01-07 20:35:36 decoyduck Exp $ */

// Enable the error handler
require_once("./include/errorhandler.inc.php");
require_once("./include/session.inc.php");
require_once("./include/db.inc.php");
require_once("./include/forum.inc.php");
require_once("./include/header.inc.php");
require_once("./include/admin.inc.php");
require_once("./include/messages.inc.php");
require_once("./include/edit.inc.php");
require_once("./include/folder.inc.php");
require_once("./include/thread.inc.php");
require_once("./include/constants.inc.php");
require_once("./include/lang.inc.php");

if (!bh_session_check()) {

    if (isset($HTTP_GET_VARS['msg']) && validate_msg($HTTP_GET_VARS['msg'])) {
      $uri = "./index.php?msg=". $HTTP_GET_VARS['msg'];
    }else {
      $uri = "./index.php?final_uri=". urlencode(get_request_uri());
    }

    header_redirect($uri);
}

// Check to see if we are requesting a thread rename.

if (isset($HTTP_POST_VARS['rename']) && isset($HTTP_POST_VARS['t_tid']) && is_numeric($HTTP_POST_VARS['t_tid']) && thread_can_view($HTTP_POST_VARS['t_tid'], bh_session_get_value('UID'))) {

    $tid  = $HTTP_POST_VARS['t_tid'];
    $name = $HTTP_POST_VARS['t_name'];
    
    $threaddata = thread_get($tid);
    
    // Only Queens, Soldiers, Workers and thread creators can rename threads.
    
    if (perm_is_moderator() || $threaddata['FROM_UID'] == bh_session_get_value('UID')) {

        // Rename the thread
        
        thread_change_title($tid, $name);
        
        // Apply an edit stamp to the first post in the thread
        
        $post_content = message_get_content($tid, 1);
        post_update($tid, 1, $post_content);
        
        // If the user is a moderator log their action in the admin log.
        
        if (perm_is_moderator()) admin_addlog(0, 0, $tid, 0, 0, 0, 21);
    }

}else {

    // Only Queens, Soldiers and Workers can perform any other moderating duties

    if (!(bh_session_get_value('STATUS') & PERM_CHECK_WORKER)) {
        html_draw_top();
        echo "<h1>{$lang['accessdenied']}</h1>\n";
        echo "<p>{$lang['accessdeniedexp']}</p>";
        html_draw_bottom();
        exit;
    }

    if (isset($HTTP_POST_VARS['move'])) {

        if (isset($HTTP_POST_VARS['t_tid']) && isset($HTTP_POST_VARS['t_move']) && is_numeric($HTTP_POST_VARS['t_tid']) && is_numeric($HTTP_POST_VARS['t_move']) && folder_is_valid($HTTP_POST_VARS['t_move'])) {

            $tid = $HTTP_POST_VARS['t_tid'];
            $fid = $HTTP_POST_VARS['t_move'];

            thread_change_folder($tid, $fid);
            admin_addlog(0, $fid, $tid, 0, 0, 0, 18);
        }

    }else if (isset($HTTP_POST_VARS['close']) && isset($HTTP_POST_VARS['t_tid']) && is_numeric($HTTP_POST_VARS['t_tid']) && thread_can_view($HTTP_POST_VARS['t_tid'], bh_session_get_value('UID'))) {

        $tid = $HTTP_POST_VARS['t_tid'];
        thread_set_closed($tid, true);
        admin_addlog(0, 0, $tid, 0, 0, 0, 19);

    }else if (isset($HTTP_POST_VARS['reopen']) && isset($HTTP_POST_VARS['t_tid']) && is_numeric($HTTP_POST_VARS['t_tid']) && thread_can_view($HTTP_POST_VARS['t_tid'], bh_session_get_value('UID'))) {

        $tid = $HTTP_POST_VARS['t_tid'];
        thread_set_closed($tid, false);
        admin_addlog(0, 0, $tid, 0, 0, 0, 20);

    }else if (isset($HTTP_POST_VARS['sticky']) && isset($HTTP_POST_VARS['t_tid']) && is_numeric($HTTP_POST_VARS['t_tid']) && thread_can_view($HTTP_POST_VARS['t_tid'], bh_session_get_value('UID'))) {

        $day = isset($HTTP_POST_VARS['sticky_day']) && is_numeric($HTTP_POST_VARS['sticky_day']) ? $HTTP_POST_VARS['sticky_day'] : 0;
        $month = isset($HTTP_POST_VARS['sticky_month']) && is_numeric($HTTP_POST_VARS['sticky_month']) ? $HTTP_POST_VARS['sticky_month'] : 0;
        $year = isset($HTTP_POST_VARS['sticky_year']) && is_numeric($HTTP_POST_VARS['sticky_year']) ? $HTTP_POST_VARS['sticky_year'] : 0;
        $sticky_until = $day || $month || $year ? mktime(0, 0, 0, $month, $day, $year) : false;
        thread_set_sticky($HTTP_POST_VARS['t_tid'], true, $sticky_until);
        admin_addlog(0, 0, $HTTP_POST_VARS['t_tid'], 0, 0, 0, 25);

    }else if(isset($HTTP_POST_VARS['nonsticky']) && isset($HTTP_POST_VARS['t_tid']) && is_numeric($HTTP_POST_VARS['t_tid']) && thread_can_view($HTTP_POST_VARS['t_tid'], bh_session_get_value('UID'))) {

        thread_set_sticky($HTTP_POST_VARS['t_tid'], false);
        admin_addlog(0, 0, $HTTP_POST_VARS['t_tid'], 0, 0, 0, 26);
    }
}

if (isset($HTTP_GET_VARS['ret'])) {
    header_redirect($HTTP_GET_VARS['ret']);
}else {
    header_redirect("./messages.php");
}

?>