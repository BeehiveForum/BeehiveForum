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

/* $Id: user_rel.php,v 1.31 2004-03-13 20:04:35 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

//Multiple forum support
include_once("./include/forum.inc.php");

include_once("./include/constants.inc.php");
include_once("./include/form.inc.php");
include_once("./include/format.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/messages.inc.php");
include_once("./include/session.inc.php");
include_once("./include/user.inc.php");
include_once("./include/user_rel.inc.php");

if (!$user_sess = bh_session_check()) {

    $uri = "./logon.php?webtag={$webtag['WEBTAG']}&final_uri=". urlencode(get_request_uri());
    header_redirect($uri);
}

// Load the wordfilter for the current user

$user_wordfilter = load_wordfilter();

if (bh_session_get_value('UID') == 0) {
        html_guest_error();
        exit;
}

if (isset($HTTP_GET_VARS['msg']) && validate_msg($HTTP_GET_VARS['msg'])) {
    $msg = $HTTP_GET_VARS['msg'];
}elseif (isset($HTTP_POST_VARS['msg']) && validate_msg($HTTP_POST_VARS['msg'])) {
    $msg = $HTTP_POST_VARS['msg'];
}else {
    $msg = messages_get_most_recent(bh_session_get_value('UID'));
}

if (isset($HTTP_GET_VARS['edit_rel']) && is_numeric($HTTP_GET_VARS['edit_rel'])) {
    $edit_rel = true;
}elseif (isset($HTTP_POST_VARS['edit_rel']) && is_numeric($HTTP_POST_VARS['edit_rel'])) {
    $edit_rel = true;
}else {
    $edit_rel = false;
}

$my_uid = bh_session_get_value('UID');

if (isset($HTTP_POST_VARS['submit'])) {

    $rel = isset($HTTP_POST_VARS['rel']) ? $HTTP_POST_VARS['rel'] : 0;
    $rel+= isset($HTTP_POST_VARS['sig']) ? $HTTP_POST_VARS['sig'] : 0;

    $sig_global = isset($HTTP_POST_VARS['sig_global']) ? $HTTP_POST_VARS['sig_global'] : '';

    user_rel_update($my_uid, $HTTP_POST_VARS['uid'], $rel);

    user_update_global_sig($my_uid, $sig_global);

    // Update the User's Session to save them having to logout and back in
    bh_session_init(bh_session_get_value('UID'));
    header_redirect("./messages.php?webtag={$webtag['WEBTAG']}&msg=$msg");
}

if (isset($HTTP_POST_VARS['cancel'])) {
    if ($edit_rel) {
        header_redirect("./edit_relations.php?webtag={$webtag['WEBTAG']}");
    }else {
        header_redirect("./messages.php?webtag={$webtag['WEBTAG']}&msg=$msg");
    }
}

if (isset($HTTP_GET_VARS['uid']) && is_numeric($HTTP_GET_VARS['uid'])) {
    $uid = $HTTP_GET_VARS['uid'];
    if (!$user = user_get($uid)) {
        html_draw_top();
        echo "<h1>{$lang['error']}:</h1>";
        echo "<p>{$lang['invalidusername']}</p>";
        html_draw_bottom();
        exit;
    }
    $uname = "<a href=\"javascript:void(0);\" onclick=\"openProfile(". $uid .")\" target=\"_self\">". format_user_name($user['LOGON'], $user['NICKNAME']) ."</a>";
}else {
    html_draw_top();
    echo "<h1>{$lang['error']}:</h1>";
    echo "<p>{$lang['nouserspecified']}</p>";
    html_draw_bottom();
    exit;
}

html_draw_top("openprofile.js");

$rel = user_rel_get($my_uid, $uid);

echo "<h1>{$lang['userrelationship']}: $uname</h1>\n";
echo "<br />\n";
echo "<div class=\"postbody\">\n";
echo "  <form name=\"relationship\" action=\"user_rel.php?webtag={$webtag['WEBTAG']}\" method=\"post\" target=\"_self\">\n";
echo "    ", form_input_hidden("uid", $uid), "\n";
echo "    ", form_input_hidden("msg", $msg), "\n";
echo "    ", form_input_hidden("edit_rel", $edit_rel), "\n";
echo "    <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
echo "      <tr>\n";
echo "        <td>\n";
echo "          <table class=\"box\">\n";
echo "            <tr>\n";
echo "              <td class=\"posthead\">\n";
echo "                <table class=\"posthead\" width=\"500\">\n";

if (isset($uid)) {

    echo "                  <tr>\n";
    echo "                    <td class=\"subhead\" colspan=\"2\">{$lang['relationship']}</td>\n";
    echo "                  </tr>\n";
    echo "                  <tr>\n";
    echo "                    <td width=\"130\">", form_radio("rel", "1", $lang['friend'], $rel & USER_FRIEND ? true : false), "</td>\n";
    echo "                    <td width=\"370\">: {$lang['friend_exp']}</td>\n";
    echo "                  </tr>\n";
    echo "                  <tr>\n";
    echo "                    <td width=\"130\">", form_radio("rel", "0", $lang['normal'], !(($rel & USER_IGNORED) || ($rel & USER_FRIEND)) ? true : false), "</td>\n";
    echo "                    <td width=\"370\">: {$lang['normal_exp']}</td>\n";
    echo "                  </tr>\n";
    echo "                  <tr>\n";
    echo "                    <td width=\"130\">", form_radio("rel", "2", $lang['ignored'], $rel & USER_IGNORED ? true : false), "</td>\n";
    echo "                    <td width=\"370\">: {$lang['ignore_exp']}</td>\n";
    echo "                  </tr>\n";
}

echo "                  <tr>\n";
echo "                    <td class=\"subhead\" colspan=\"2\">{$lang['signature']}</td>\n";
echo "                  </tr>\n";

if (isset($uid)) {

    echo "                  <tr>\n";
    echo "                    <td width=\"130\">", form_radio("sig", "0", $lang['display'], $rel ^ USER_IGNORED_SIG ? true : false), "</td>\n";
    echo "                    <td width=\"370\">: {$lang['displaysig_exp']}</td>\n";
    echo "                  </tr>\n";
    echo "                  <tr>\n";
    echo "                    <td width=\"130\">", form_radio("sig", "4", $lang['ignore'], $rel & USER_IGNORED_SIG ? true : false), "</td>\n";
    echo "                    <td width=\"370\">: {$lang['hidesig_exp']}</td>\n";
    echo "                  </tr>\n";
}

echo "                  <tr>\n";
echo "                    <td width=\"130\">", form_checkbox("sig_global", "Y", $lang['globallyignored'], user_get_global_sig(bh_session_get_value('UID')) == "Y"), "</td>\n";
echo "                    <td width=\"370\">: {$lang['globallyignoredsig_exp']}</td>\n";
echo "                  </tr>\n";
echo "                </table>\n";
echo "              </td>\n";
echo "            </tr>\n";
echo "          </table>\n";
echo "        </td>\n";
echo "      </tr>\n";
echo "      <tr>\n";
echo "        <td align=\"center\"><p>", form_submit("submit", $lang['submit']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</p></td>\n";
echo "      </tr>\n";
echo "    </table>\n";
echo "  </form>\n";
echo "</div>\n";

html_draw_bottom();

?>