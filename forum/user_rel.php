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

/* $Id: user_rel.php,v 1.82 2007-01-11 20:05:32 decoyduck Exp $ */

/**
* Displays and handles the User Relationship page
*
* Generates the forms relating to the user relationship settings, and handles their sumbission.
*/

/**
*/
// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

// Compress the output
include_once(BH_INCLUDE_PATH. "gzipenc.inc.php");

// Enable the error handler
include_once(BH_INCLUDE_PATH. "errorhandler.inc.php");

// Installation checking functions
include_once(BH_INCLUDE_PATH. "install.inc.php");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once(BH_INCLUDE_PATH. "forum.inc.php");

// Fetch the forum settings
$forum_settings = forum_get_settings();

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "user_rel.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.

if (bh_session_user_banned()) {

    html_user_banned();
    exit;
}

// Check to see if the user has been approved.

if (!bh_session_user_approved()) {

    html_user_require_approval();
    exit;
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// User's UID

$uid = bh_session_get_value('UID');

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

if ($uid == 0) {
    html_guest_error();
    exit;
}

if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {
    $msg = $_GET['msg'];
}elseif (isset($_POST['msg']) && validate_msg($_POST['msg'])) {
    $msg = $_POST['msg'];
}else {
    $msg = messages_get_most_recent($uid);
}

if (isset($_GET['edit_rel']) && is_numeric($_GET['edit_rel'])) {
    $edit_rel = true;
}elseif (isset($_POST['edit_rel']) && is_numeric($_POST['edit_rel'])) {
    $edit_rel = true;
}else {
    $edit_rel = false;
}

if (isset($_POST['submit'])) {

    $valid = true;

    if (isset($_POST['uid']) && is_numeric($_POST['uid'])) {
        $peer_uid = $_POST['uid'];
    }else {
        $valid = false;
    }

    if (isset($_POST['rel']) && is_numeric($_POST['rel'])) {
        $t_rel = $_POST['rel'];
    }else {
        $t_rel = 0;
    }

    if (isset($_POST['sig']) && is_numeric($_POST['sig'])) {
        $t_rel+= $_POST['sig'];
    }else {
        $t_rel+= 0;
    }

    if (isset($_POST['view_sigs']) && $_POST['view_sigs'] == "N") {
        $view_sigs = "N";
    }else {
        $view_sigs = "";
    }

    if (isset($_POST['view_sigs_global'])) {
        $view_sigs_global = ($_POST['view_sigs_global'] == "Y") ? true : false;
    }else {
        $view_sigs_global = false;
    }

    if (isset($_POST['nickname']) && strlen(_stripslashes($_POST['nickname'])) > 0) {
        $peer_nickname = strip_tags(_stripslashes($_POST['nickname']));
    }else {
        $peer_nickname = user_get_nickname($peer_uid);
    }

    if ($valid) {

        user_rel_update($uid, $peer_uid, $t_rel, $peer_nickname);

        user_update_global_sig($uid, $view_sigs, $view_sigs_global);

        // Update the User's Session to save them having to logout and back in

        bh_session_init($uid, false);

        header_redirect("./messages.php?webtag=$webtag&msg=$msg", $lang['preferencesupdated']);
    }
}

if (isset($_POST['reset_nickname'])) {

    $valid = true;

    if (isset($_POST['uid']) && is_numeric($_POST['uid'])) {
        $peer_uid = $_POST['uid'];
    }else {
        $valid = false;
    }

    if ($valid) {

        $peer_nickname = user_get_nickname($peer_uid);
        $peer_rel = user_get_peer_relationship($uid, $peer_uid);

        user_rel_update($uid, $peer_uid, $peer_rel, $peer_nickname);
    }
}

if (isset($_POST['cancel'])) {

    if ($edit_rel) {
        header_redirect("./edit_relations.php?webtag=$webtag");
    }else {
        header_redirect("./messages.php?webtag=$webtag&msg=$msg");
    }
}

if (isset($_GET['uid']) && is_numeric($_GET['uid'])) {

    $peer_uid = $_GET['uid'];

}elseif (!isset($peer_uid)) {

    html_draw_top();
    echo "<h1>{$lang['error']}</h1>";
    echo "<h2>{$lang['nouserspecified']}</h2>";
    html_draw_bottom();
    exit;
}

if (!$user = user_get($peer_uid)) {

    html_draw_top();
    echo "<h1>{$lang['error']}</h1>";
    echo "<h2>{$lang['invalidusername']}</h2>";
    html_draw_bottom();
    exit;
}

html_draw_top("openprofile.js");

$rel = user_rel_get($uid, $peer_uid);

$user_peer = user_get($peer_uid);

$user_prefs = user_get_prefs($uid);

$user_perms = perm_get_user_permissions($uid);
$user_peer_perms = perm_get_user_permissions($peer_uid);

echo "<h1>{$lang['userrelationship']} &raquo; <a href=\"user_profile.php?webtag=$webtag&amp;uid=$peer_uid\" target=\"_blank\" onclick=\"return openProfile($peer_uid, '$webtag')\">", add_wordfilter_tags(format_user_name($user['LOGON'], $user['NICKNAME'])), "</a></h1>\n";
echo "<br />\n";
echo "<form name=\"relationship\" action=\"user_rel.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";
echo "  ", form_input_hidden("uid", $peer_uid), "\n";
echo "  ", form_input_hidden("msg", $msg), "\n";
echo "  ", form_input_hidden("edit_rel", $edit_rel), "\n";

if (isset($peer_uid)) {

    echo "  <table cellpadding=\"0\" cellspacing=\"0\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">{$lang['relationship']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" width=\"200\">", form_radio("rel", "1", $lang['friend'], $rel & USER_FRIEND ? true : false), "</td>\n";
    echo "                  <td align=\"left\" width=\"400\">: {$lang['friend_exp']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" width=\"200\">", form_radio("rel", "0", $lang['normal'], !(($rel & USER_IGNORED) || ($rel & USER_FRIEND) || ($rel & USER_IGNORED_COMPLETELY)) ? true : false), "</td>\n";
    echo "                  <td align=\"left\" width=\"400\">: {$lang['normal_exp']}</td>\n";
    echo "                </tr>\n";

    if ((($user_peer_perms & USER_PERM_FOLDER_MODERATE) && ($user_perms & USER_PERM_CAN_IGNORE_ADMIN)) || !($user_peer_perms & USER_PERM_FOLDER_MODERATE)) {

        echo "                <tr>\n";
        echo "                  <td align=\"left\" width=\"200\">", form_radio("rel", "2", $lang['ignored'], $rel & USER_IGNORED ? true : false), "</td>\n";
        echo "                  <td align=\"left\" width=\"400\">: {$lang['ignore_exp']}</td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td align=\"left\" width=\"200\">", form_radio("rel", "8", $lang['ignoredcompletely'], $rel & USER_IGNORED_COMPLETELY ? true : false), "</td>\n";
        echo "                  <td align=\"left\" width=\"400\">: {$lang['ignore_completely_exp']}</td>\n";
        echo "                </tr>\n";

    }else {

        echo "                <tr>\n";
        echo "                  <td align=\"left\" width=\"200\">&nbsp;</td>\n";
        echo "                  <td align=\"left\" width=\"400\">{$lang['cannotignoremod']}</td>\n";
        echo "                </tr>\n";
    }

    echo "                <tr>\n";
    echo "                  <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "            </td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  <br />\n";
}

echo "  <table cellpadding=\"0\" cellspacing=\"0\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">{$lang['signature']}</td>\n";
echo "                </tr>\n";

if (isset($peer_uid)) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" width=\"200\">", form_radio("sig", "0", $lang['display'], $rel ^ USER_IGNORED_SIG ? true : false), "</td>\n";
    echo "                  <td align=\"left\" width=\"400\">: {$lang['displaysig_exp']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" width=\"200\">", form_radio("sig", "4", $lang['ignore'], $rel & USER_IGNORED_SIG ? true : false), "</td>\n";
    echo "                  <td align=\"left\" width=\"400\">: {$lang['hidesig_exp']}</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\" width=\"200\" valign=\"top\">", form_checkbox("view_sigs", "N", $lang['globallyignored'], isset($user_prefs['VIEW_SIGS']) && $user_prefs['VIEW_SIGS'] == 'N'), "</td>\n";
echo "                  <td align=\"left\" width=\"400\">: {$lang['globallyignoredsig_exp']}<br />&nbsp;(", form_checkbox("view_sigs_global", "Y", $lang['setforallforums'], (isset($user_prefs['VIEW_SIGS_GLOBAL']) ? $user_prefs['VIEW_SIGS_GLOBAL'] : false)) ,")</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";

if (isset($peer_uid)) {

    if (isset($_POST['reset_nickname'])) {

        $nickname = user_get_nickname($peer_uid);

    }else if (isset($user_peer['PEER_NICKNAME']) && 
             !is_null($user_peer['PEER_NICKNAME']) && 
             strlen($user_peer['PEER_NICKNAME']) > 0) {
    
        $nickname = $user_peer['PEER_NICKNAME'];

    }else {

        $nickname = $user_peer['NICKNAME'];
    }

    echo "  </table>\n";
    echo "  <br />\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">{$lang['nickname']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" width=\"200\" valign=\"top\">{$lang['nickname']}</td>\n";
    echo "                  <td align=\"left\" width=\"400\">", form_input_text("nickname", $nickname, 32), "&nbsp;", form_submit_image('reload.png', "reset_nickname", "Y", "title=\"{$lang['restorenickname']}\""), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "            </td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
}

echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"center\"><p>", form_submit("submit", $lang['submit']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</p></td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";

html_draw_bottom();

?>