<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
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

// Set the default timezone
date_default_timezone_set('UTC');

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Caching functions
include_once(BH_INCLUDE_PATH. "cache.inc.php");

// Disable PHP's register_globals
unregister_globals();

// Correctly set server protocol
set_server_protocol();

// Disable caching if on AOL
cache_disable_aol();

// Disable caching if proxy server detected.
cache_disable_proxy();

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

// Initialise Locale
lang_init();

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

        html_draw_top("title=", gettext("Email confirmation"), "", 'class=window_title');
        html_display_msg(gettext("Email confirmation"), gettext("Confirmation email has been resent."));
        html_draw_bottom();
        exit;
    }

    html_draw_top(sprintf("title=%s", gettext("Error")));
    html_error_msg(gettext("Confirmation email failed to send. Please contact the forum owner to rectify this."));
    html_draw_bottom();
    exit;
}

if (!isset($uid) || !isset($key)) {

    html_draw_top(sprintf("title=%s", gettext("Error")));
    html_error_msg(gettext("Required information not found"));
    html_draw_bottom();
    exit;
}

$frame_top_target = html_get_top_frame_name();

if (($user = user_get_by_passhash($uid, $key))) {

    if (perm_user_cancel_email_confirmation($uid)) {

        html_draw_top("title=", gettext("Email confirmation"), "", 'class=window_title');
        html_display_msg(gettext("Email confirmation"), gettext("Thank you for confirming your email address. You may now login and start posting immediately."), 'index.php', 'post', array('submit' => gettext("Continue")), false, $frame_top_target, 'center');
        html_draw_bottom();

    }else {

        html_draw_top(sprintf("title=%s", gettext("Error")));
        html_display_msg(gettext("Email confirmation"), gettext("Email confirmation has failed, please try again later. If you encounter this error multiple times please contact the forum owner or a moderator for assistance."), 'index.php', 'post', array('submit' => gettext("Continue")), false, $frame_top_target, 'center');
        html_draw_bottom();
    }

    html_draw_bottom();

}else {

    html_draw_top(sprintf("title=%s", gettext("Error")));
    html_error_msg(gettext("Required information not found"));
    html_draw_bottom();
    exit;
}

?>
