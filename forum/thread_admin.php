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

/* $Id: thread_admin.php,v 1.52 2004-04-26 11:21:10 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum settings
$forum_settings = get_forum_settings();

include_once("./include/admin.inc.php");
include_once("./include/constants.inc.php");
include_once("./include/db.inc.php");
include_once("./include/edit.inc.php");
include_once("./include/folder.inc.php");
include_once("./include/header.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/messages.inc.php");
include_once("./include/perm.inc.php");
include_once("./include/session.inc.php");
include_once("./include/thread.inc.php");

if (!$user_sess = bh_session_check()) {

    if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {

        if (perform_logon(false)) {

	    html_draw_top();

            echo "<h1>{$lang['loggedinsuccessfully']}</h1>";
            echo "<div align=\"center\">\n";
	    echo "<p><b>{$lang['presscontinuetoresend']}</b></p>\n";

            $request_uri = get_request_uri();

            echo "<form method=\"post\" action=\"$request_uri\" target=\"_self\">\n";

            foreach($_POST as $key => $value) {
	        form_input_hidden($key, _htmlentities(_stripslashes($value)));
            }

	    echo form_submit(md5(uniqid(rand())), $lang['continue']), "&nbsp;";
            echo form_button(md5(uniqid(rand())), $lang['cancel'], "onclick=\"self.location.href='$request_uri'\""), "\n";
	    echo "</form>\n";

	    html_draw_bottom();
	    exit;
	}

    }else {
        html_draw_top();
        draw_logon_form(false);
	html_draw_bottom();
	exit;
    }
}

// Load language file

$lang = load_language_file();

// Check we have a webtag

if (!$webtag = get_webtag()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?final_uri=$request_uri");
}

// Check to see if we are requesting a thread rename or move first.

if (isset($_POST['rename']) && isset($_POST['t_tid']) && is_numeric($_POST['t_tid']) && thread_can_view($_POST['t_tid'], bh_session_get_value('UID'))) {

    $tid  = $_POST['t_tid'];
    $name = $_POST['t_name'];

    $threaddata = thread_get($tid);

    // Only Queens, Soldiers, Workers and thread creators can rename threads.

    if (perm_is_moderator()) {

        thread_change_title($tid, $name);
        post_add_edit_text($tid, 1);
        admin_addlog(0, 0, $tid, 0, 0, 0, 21);

    }elseif ($threaddata['FROM_UID'] == bh_session_get_value('UID') && $threaddata['ADMIN_LOCK'] == 0) {

        if (((forum_get_setting('allow_post_editing', 'Y', false)) && intval(forum_get_setting('post_edit_time')) == 0) || ((time() - $threaddata['CREATED']) < (intval(forum_get_setting('post_edit_time')) * HOUR_IN_SECONDS))) {

            thread_change_title($tid, $name);
            post_add_edit_text($tid, 1);
            admin_addlog(0, 0, $tid, 0, 0, 0, 21);
        }
    }

}elseif (isset($_POST['move']) && isset($_POST['t_tid']) && isset($_POST['t_move']) && is_numeric($_POST['t_tid']) && is_numeric($_POST['t_move']) && folder_is_valid($_POST['t_move'])) {

    $tid = $_POST['t_tid'];
    $fid = $_POST['t_move'];

    $threaddata = thread_get($tid);

    if (perm_is_moderator()) {

        thread_change_folder($tid, $fid);
        admin_addlog(0, $fid, $tid, 0, 0, 0, 18);

    }elseif ($threaddata['FROM_UID'] == bh_session_get_value('UID') && $threaddata['ADMIN_LOCK'] == 0) {

        if (((forum_get_setting('allow_post_editing', 'Y', false)) && intval(forum_get_setting('post_edit_time')) == 0) || ((time() - $threaddata['CREATED']) < (intval(forum_get_setting('post_edit_time')) * HOUR_IN_SECONDS))) {

            thread_change_folder($tid, $fid);
            admin_addlog(0, $fid, $tid, 0, 0, 0, 18);
        }
    }

 }else {

    // Only Queens, Soldiers and Workers can perform any other moderating duties

    if (!(bh_session_get_value('STATUS')&PERM_CHECK_WORKER)) {
        html_draw_top();
        echo "<h1>{$lang['accessdenied']}</h1>\n";
        echo "<p>{$lang['accessdeniedexp']}</p>";
        html_draw_bottom();
        exit;
    }

    if (isset($_POST['close']) && isset($_POST['t_tid']) && is_numeric($_POST['t_tid']) && thread_can_view($_POST['t_tid'], bh_session_get_value('UID'))) {

        $tid = $_POST['t_tid'];
        thread_set_closed($tid, true);
        admin_addlog(0, 0, $tid, 0, 0, 0, 19);

    }else if (isset($_POST['reopen']) && isset($_POST['t_tid']) && is_numeric($_POST['t_tid']) && thread_can_view($_POST['t_tid'], bh_session_get_value('UID'))) {

        $tid = $_POST['t_tid'];
        thread_set_closed($tid, false);
        admin_addlog(0, 0, $tid, 0, 0, 0, 20);

    }else if (isset($_POST['lock']) && isset($_POST['t_tid']) && is_numeric($_POST['t_tid']) && thread_can_view($_POST['t_tid'], bh_session_get_value('UID'))) {

        $tid = $_POST['t_tid'];
        thread_admin_lock($tid, true);
        admin_addlog(0, 0, $tid, 0, 0, 0, 20);

    }else if (isset($_POST['unlock']) && isset($_POST['t_tid']) && is_numeric($_POST['t_tid']) && thread_can_view($_POST['t_tid'], bh_session_get_value('UID'))) {

        $tid = $_POST['t_tid'];
        thread_admin_lock($tid, false);
        admin_addlog(0, 0, $tid, 0, 0, 0, 20);

    }else if (isset($_POST['sticky']) && isset($_POST['t_tid']) && is_numeric($_POST['t_tid']) && thread_can_view($_POST['t_tid'], bh_session_get_value('UID'))) {

        $day = isset($_POST['sticky_day']) && is_numeric($_POST['sticky_day']) ? $_POST['sticky_day'] : 0;
        $month = isset($_POST['sticky_month']) && is_numeric($_POST['sticky_month']) ? $_POST['sticky_month'] : 0;
        $year = isset($_POST['sticky_year']) && is_numeric($_POST['sticky_year']) ? $_POST['sticky_year'] : 0;
        $sticky_until = $day || $month || $year ? mktime(0, 0, 0, $month, $day, $year) : false;
        thread_set_sticky($_POST['t_tid'], true, $sticky_until);
        admin_addlog(0, 0, $_POST['t_tid'], 0, 0, 0, 25);

    }else if (isset($_POST['nonsticky']) && isset($_POST['t_tid']) && is_numeric($_POST['t_tid']) && thread_can_view($_POST['t_tid'], bh_session_get_value('UID'))) {

        thread_set_sticky($_POST['t_tid'], false);
        admin_addlog(0, 0, $_POST['t_tid'], 0, 0, 0, 26);
    }
}

$uri = "./messages.php?webtag=$webtag";

if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {
    $uri.= "&msg=". $_GET['msg'];
}

header_redirect($uri);

?>