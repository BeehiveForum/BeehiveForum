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

/* $Id: user_rel.php,v 1.57 2004-09-13 14:43:22 tribalonline Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Installation checking functions
include_once("./include/install.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum settings
$forum_settings = get_forum_settings();

include_once("./include/constants.inc.php");
include_once("./include/form.inc.php");
include_once("./include/format.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/messages.inc.php");
include_once("./include/session.inc.php");
include_once("./include/user.inc.php");
include_once("./include/user_rel.inc.php");

if (!$user_sess = bh_session_check()) {

    html_draw_top();

    if (isset($_POST['user_logon']) && isset($_POST['user_password']) && isset($_POST['user_passhash'])) {

        if (perform_logon(false)) {

            $lang = load_language_file();
            $webtag = get_webtag($webtag_search);

            echo "<h1>{$lang['loggedinsuccessfully']}</h1>";
            echo "<div align=\"center\">\n";
            echo "<p><b>{$lang['presscontinuetoresend']}</b></p>\n";

            $request_uri = get_request_uri();

            echo "<form method=\"post\" action=\"$request_uri\" target=\"_self\">\n";
            echo form_input_hidden('webtag', $webtag);

            foreach($_POST as $key => $value) {
                echo form_input_hidden($key, _htmlentities(_stripslashes($value)));
            }

            echo form_submit(md5(uniqid(rand())), $lang['continue']), "&nbsp;";
            echo form_button(md5(uniqid(rand())), $lang['cancel'], "onclick=\"self.location.href='$request_uri'\""), "\n";
            echo "</form>\n";

            html_draw_bottom();
            exit;
        }
    }

    draw_logon_form(false);
    html_draw_bottom();
    exit;
}

// Load language file

$lang = load_language_file();

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

if (bh_session_get_value('UID') == 0) {
    html_guest_error();
    exit;
}

if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {
    $msg = $_GET['msg'];
}elseif (isset($_POST['msg']) && validate_msg($_POST['msg'])) {
    $msg = $_POST['msg'];
}else {
    $msg = messages_get_most_recent(bh_session_get_value('UID'));
}

if (isset($_GET['edit_rel']) && is_numeric($_GET['edit_rel'])) {
    $edit_rel = true;
}elseif (isset($_POST['edit_rel']) && is_numeric($_POST['edit_rel'])) {
    $edit_rel = true;
}else {
    $edit_rel = false;
}

$my_uid = bh_session_get_value('UID');

if (isset($_POST['submit'])) {

    $rel = isset($_POST['rel']) ? $_POST['rel'] : 0;
    $rel+= isset($_POST['sig']) ? $_POST['sig'] : 0;

    $view_sigs = isset($_POST['view_sigs']) ? $_POST['view_sigs'] : '';
	$view_sigs_global = false;
	if (isset($_POST['view_sigs_global'])) {
		$view_sigs_global = ($_POST['view_sigs_global'] == "Y") ? true : false;
	}

    user_rel_update($my_uid, $_POST['uid'], $rel);

    user_update_global_sig($my_uid, $view_sigs, $view_sigs_global);

    // Update the User's Session to save them having to logout and back in
    bh_session_init(bh_session_get_value('UID'));
    header_redirect("./messages.php?webtag=$webtag&msg=$msg");
}

if (isset($_POST['cancel'])) {
    if ($edit_rel) {
        header_redirect("./edit_relations.php?webtag=$webtag");
    }else {
        header_redirect("./messages.php?webtag=$webtag&msg=$msg");
    }
}

if (isset($_GET['uid']) && is_numeric($_GET['uid'])) {
    $uid = $_GET['uid'];
    if (!$user = user_get($uid)) {
        html_draw_top();
        echo "<h1>{$lang['invalidop']}:</h1>";
        echo "<h2>{$lang['invalidusername']}</h2>";
        html_draw_bottom();
        exit;
    }
    $uname = "<a href=\"javascript:void(0);\" onclick=\"openProfile($uid, '$webtag')\" target=\"_self\">". format_user_name($user['LOGON'], $user['NICKNAME']) ."</a>";
}else {
    html_draw_top();
    echo "<h1>{$lang['invalidop']}:</h1>";
    echo "<h2>{$lang['nouserspecified']}</h2>";
    html_draw_bottom();
    exit;
}

html_draw_top("openprofile.js");

$rel = user_rel_get($my_uid, $uid);

$user_prefs = user_get_prefs($my_uid);

echo "<h1>{$lang['userrelationship']}: $uname</h1>\n";
echo "<br />\n";
echo "<form name=\"relationship\" action=\"user_rel.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";
echo "  ", form_input_hidden("uid", $uid), "\n";
echo "  ", form_input_hidden("msg", $msg), "\n";
echo "  ", form_input_hidden("edit_rel", $edit_rel), "\n";

if (isset($uid)) {

    echo "  <table cellpadding=\"0\" cellspacing=\"0\">\n";
    echo "    <tr>\n";
    echo "      <td>\n";
    echo "        <table class=\"box\">\n";
    echo "          <tr>\n";
    echo "            <td class=\"posthead\">\n";
    echo "              <table class=\"posthead\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" colspan=\"2\">{$lang['relationship']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td width=\"200\">", form_radio("rel", "1", $lang['friend'], $rel&USER_FRIEND ? true : false), "</td>\n";
    echo "                  <td width=\"400\">: {$lang['friend_exp']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td width=\"200\">", form_radio("rel", "0", $lang['normal'], !(($rel&USER_IGNORED) || ($rel&USER_FRIEND)) ? true : false), "</td>\n";
    echo "                  <td width=\"400\">: {$lang['normal_exp']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td width=\"200\">", form_radio("rel", "2", $lang['ignored'], $rel&USER_IGNORED ? true : false), "</td>\n";
    echo "                  <td width=\"400\">: {$lang['ignore_exp']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td width=\"200\">", form_radio("rel", "8", $lang['ignoredcompletely'], $rel&USER_IGNORED_COMPLETELY ? true : false), "</td>\n";
    echo "                  <td width=\"400\">: {$lang['ignore_completely_exp']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td colspan=\"2\">&nbsp;</td>\n";
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
echo "      <td>\n";
echo "        <table class=\"box\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" colspan=\"2\">{$lang['signature']}</td>\n";
echo "                </tr>\n";

if (isset($uid)) {

    echo "                <tr>\n";
    echo "                  <td width=\"200\">", form_radio("sig", "0", $lang['display'], $rel ^ USER_IGNORED_SIG ? true : false), "</td>\n";
    echo "                  <td width=\"400\">: {$lang['displaysig_exp']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td width=\"200\">", form_radio("sig", "4", $lang['ignore'], $rel&USER_IGNORED_SIG ? true : false), "</td>\n";
    echo "                  <td width=\"400\">: {$lang['hidesig_exp']}</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td width=\"200\" valign=\"top\">", form_checkbox("view_sigs", "N", $lang['globallyignored'], $user_prefs['VIEW_SIGS'] == 'N'), "</td>\n";
echo "                  <td width=\"400\">: {$lang['globallyignoredsig_exp']}<br />&nbsp;(", form_checkbox("view_sigs_global","Y",$lang['setforallforums'],$user_prefs['VIEW_SIGS_GLOBAL']) ,")</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"2\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td>&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"center\"><p>", form_submit("submit", $lang['submit']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</p></td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";

html_draw_bottom();

?>