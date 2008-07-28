<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

Beehive Forum is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
USA
======================================================================*/

/* $Id: confirm_email.php,v 1.25 2008-07-28 21:05:48 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Compress the output
include_once(BH_INCLUDE_PATH. "gzipenc.inc.php");

// Enable the error handler
include_once(BH_INCLUDE_PATH. "errorhandler.inc.php");

// Installation checking functions
include_once(BH_INCLUDE_PATH. "install.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once(BH_INCLUDE_PATH. "forum.inc.php");

// Fetch Forum Settings

$forum_settings = forum_get_settings();

// Fetch Global Forum Settings

$forum_global_settings = forum_get_global_settings();

// Load language file

$lang = load_language_file();

// Check we have a webtag

$webtag = get_webtag();

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "email.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

if (isset($_GET['uid']) && is_numeric($_GET['uid'])) {
    $uid = $_GET['uid'];
}else if (isset($_GET['u']) && is_numeric($_GET['u'])) {
    $uid = $_GET['u'];
}

if (isset($_GET['h']) && is_md5($_GET['h'])) {
    $key = $_GET['h'];
}

if (isset($_GET['resend']) && isset($uid)) {

    if (email_send_user_confirmation($uid)) {

        html_draw_top();
        html_display_msg($lang['emailconfirmation'], $lang['emailconfirmationsent']);
        html_draw_bottom();
        exit;
    }

    html_draw_top();
    html_error_msg($lang['emailconfirmationfailedtosend']);
    html_draw_bottom();
    exit;
}

if (!isset($uid) || !isset($key)) {

    html_draw_top();
    html_error_msg($lang['requiredinformationnotfound']);
    html_draw_bottom();
    exit;
}

$frame_top_target = html_get_top_frame_name();

if (($user = user_get_by_password($uid, $key))) {

    if (perm_user_cancel_email_confirmation($uid)) {

        html_draw_top();
        html_display_msg($lang['emailconfirmation'], $lang['emailconfirmationcomplete'], 'index.php', 'post', array('submit' => $lang['continue']), false, $frame_top_target, 'center');
        html_draw_bottom();

    }else {

        html_draw_top();
        html_display_msg($lang['emailconfirmation'], $lang['emailconfirmationfailed'], 'index.php', 'post', array('submit' => $lang['continue']), false, $frame_top_target, 'center');
        html_draw_bottom();
    }

    html_draw_bottom();

}else {

    html_draw_top();
    html_error_msg($lang['requiredinformationnotfound']);
    html_draw_bottom();
    exit;
}

?>