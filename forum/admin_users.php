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

/* $Id: admin_users.php,v 1.77 2004-04-26 11:21:06 decoyduck Exp $ */

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
include_once("./include/format.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/perm.inc.php");
include_once("./include/session.inc.php");

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

html_draw_top();

if (!(bh_session_get_value('STATUS')&USER_PERM_SOLDIER)) {
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;
}

// Friendly display names for column sorting

$sort_by_array = array('USER.UID'        => 'UID',
                     'USER.LOGON'      => 'LOGON',
                     'USER.NICKNAME'   => 'NICKNAME',
                     'USER.STATUS'     => 'STATUS',
                     'USER.LAST_LOGON' => 'LAST_LOGON',
                     'SESSIONS.SESSID' => 'SESSID');

// Column sorting stuff

if (isset($_GET['sort_by'])) {
    if ($_GET['sort_by'] == "UID") {
        $sort_by = "USER.UID";
    } elseif ($_GET['sort_by'] == "LOGON") {
        $sort_by = "USER.LOGON";
    } elseif ($_GET['sort_by'] == "NICKNAME") {
        $sort_by = "USER.NICKNAME";
    } elseif ($_GET['sort_by'] == "STATUS") {
        $sort_by = "USER.STATUS";
    } elseif ($_GET['sort_by'] == "LAST_LOGON") {
        $sort_by = "USER.LAST_LOGON";
    } elseif ($_GET['sort_by'] == "SESSID") {
        $sort_by = "SESSIONS.SESSID";
    } else {
        $sort_by = "USER.LAST_LOGON";
    }
} else {
    $sort_by = "USER.LAST_LOGON";
}

if (isset($_GET['sort_dir'])) {
    if ($_GET['sort_dir'] == "DESC") {
        $sort_dir = "DESC";
    } else {
        $sort_dir = "ASC";
    }
} else {
    $sort_dir = "DESC";
}

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = ($_GET['page'] > 0) ? $_GET['page'] : 1;
}else {
    $page = 1;
}

if (isset($_GET['usersearch']) && strlen(trim($_GET['usersearch'])) > 0) {
    $usersearch = trim($_GET['usersearch']);
}else {
    $usersearch = "";
}

if (isset($_GET['reset'])) {
    $usersearch = "";
}

// Draw the form
echo "<h1>{$lang['admin']} : {$lang['manageusers']}</h1>\n";

if (isset($_POST['t_kick'])) {
    list($user_uid) = array_keys($_POST['t_kick']);
    if (admin_session_end($user_uid)) {
        $admin_uid = bh_session_get_value('UID');
        admin_addlog($admin_uid, 0, 0, 0, 0, $user_uid, 27);
        echo "<p><b>{$lang['sessionsuccessfullyended']}: <a href=\"javascript:void(0)\" onclick=\"openProfile($user_uid, '$webtag')\" target=\"_self\">", user_get_logon($user_uid), "</a></b></p>\n";
    }
}

echo "<p>{$lang['manageusersexp_1']} '{$sort_by_array[$sort_by]}'. {$lang['manageusersexp_2']}</p>\n";
echo "<div align=\"center\">\n";
echo "<form action=\"admin_users.php\" method=\"post\">\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"96%\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                 <tr>\n";

if ($sort_by == 'USER.UID' && $sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&amp;sort_by=UID&amp;sort_dir=DESC&amp;usersearch=$usersearch&amp;page=$page\">UID&nbsp;<img src=\"", style_image("sort_asc.png"), "\" width=\"11\" border=\"0\" alt=\"\" /></a></td>\n";
}elseif ($sort_by == 'USER.UID' && $sort_dir == 'DESC') {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&amp;sort_by=UID&amp;sort_dir=ASC&amp;usersearch=$usersearch&amp;page=$page\">UID&nbsp;<img src=\"", style_image("sort_desc.png"), "\" width=\"11\" border=\"0\" alt=\"\" /></a></td>\n";
}elseif ($sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&amp;sort_by=UID&amp;sort_dir=ASC&amp;usersearch=$usersearch&amp;page=$page\">UID</a></td>\n";
}else {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&amp;sort_by=UID&amp;sort_dir=DESC&amp;usersearch=$usersearch&amp;page=$page\">UID</a></td>\n";
}

if ($sort_by == 'USER.LOGON' && $sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&amp;sort_by=LOGON&amp;sort_dir=DESC&amp;usersearch=$usersearch&amp;page=$page\">{$lang['logon']}&nbsp;<img src=\"", style_image("sort_asc.png"), "\" width=\"11\" border=\"0\" alt=\"\" /></a></td>\n";
}elseif ($sort_by == 'USER.LOGON' && $sort_dir == 'DESC') {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&amp;sort_by=LOGON&amp;sort_dir=ASC&amp;usersearch=$usersearch&amp;page=$page\">{$lang['logon']}&nbsp;<img src=\"", style_image("sort_desc.png"), "\" width=\"11\" border=\"0\" alt=\"\" /></a></td>\n";
}elseif ($sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&amp;sort_by=LOGON&amp;sort_dir=ASC&amp;usersearch=$usersearch&amp;page=$page\">{$lang['logon']}</a></td>\n";
}else {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&amp;sort_by=LOGON&amp;sort_dir=DESC&amp;usersearch=$usersearch&amp;page=$page\">{$lang['logon']}</a></td>\n";
}

if ($sort_by == 'USER.STATUS' && $sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&amp;sort_by=STATUS&amp;sort_dir=DESC&amp;usersearch=$usersearch&amp;page=$page\">{$lang['status']}&nbsp;<img src=\"", style_image("sort_asc.png"), "\" width=\"11\" border=\"0\" alt=\"\" /></a></td>\n";
}elseif ($sort_by == 'USER.STATUS' && $sort_dir == 'DESC') {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&amp;sort_by=STATUS&amp;sort_dir=ASC&amp;usersearch=$usersearch&amp;page=$page\">{$lang['status']}&nbsp;<img src=\"", style_image("sort_desc.png"), "\" width=\"11\" border=\"0\" alt=\"\" /></a></td>\n";
}elseif ($sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&amp;sort_by=STATUS&amp;sort_dir=ASC&amp;usersearch=$usersearch&amp;page=$page\">{$lang['status']}</a></td>\n";
}else {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&amp;sort_by=STATUS&amp;sort_dir=DESC&amp;usersearch=$usersearch&amp;page=$page\">{$lang['status']}</a></td>\n";
}

if ($sort_by == 'USER.LAST_LOGON' && $sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&amp;sort_by=LAST_LOGON&amp;sort_dir=DESC&amp;usersearch=$usersearch&amp;page=$page\">{$lang['lastlogon']}&nbsp;<img src=\"", style_image("sort_asc.png"), "\" width=\"11\" border=\"0\" alt=\"\" /></a></td>\n";
}elseif ($sort_by == 'USER.LAST_LOGON' && $sort_dir == 'DESC') {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&amp;sort_by=LAST_LOGON&amp;sort_dir=ASC&amp;usersearch=$usersearch&amp;page=$page\">{$lang['lastlogon']}&nbsp;<img src=\"", style_image("sort_desc.png"), "\" width=\"11\" border=\"0\" alt=\"\" /></a></td>\n";
}elseif ($sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&amp;sort_by=LAST_LOGON&amp;sort_dir=ASC&amp;usersearch=$usersearch&amp;page=$page\">{$lang['lastlogon']}</a></td>\n";
}else {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&amp;sort_by=LAST_LOGON&amp;sort_dir=DESC&amp;usersearch=$usersearch&amp;page=$page\">{$lang['lastlogon']}</a></td>\n";
}

if ($sort_by == 'SESSIONS.SESSID' && $sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&amp;sort_by=SESSID&amp;sort_dir=DESC&amp;usersearch=$usersearch&amp;page=$page\">{$lang['active']}&nbsp;<img src=\"", style_image("sort_asc.png"), "\" width=\"11\" border=\"0\" alt=\"\" /></a></td>\n";
}elseif ($sort_by == 'SESSIONS.SESSID' && $sort_dir == 'DESC') {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&amp;sort_by=SESSID&amp;sort_dir=ASC&amp;usersearch=$usersearch&amp;page=$page\">{$lang['active']}&nbsp;<img src=\"", style_image("sort_desc.png"), "\" width=\"11\" border=\"0\" alt=\"\" /></a></td>\n";
}elseif ($sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&amp;sort_by=SESSID&amp;sort_dir=ASC&amp;usersearch=$usersearch&amp;page=$page\">{$lang['active']}</a></td>\n";
}else {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&amp;sort_by=SESSID&amp;sort_dir=DESC&amp;usersearch=$usersearch&amp;page=$page\">{$lang['active']}</a></td>\n";
}

if ($sort_by == 'SESSIONS.SESSID' && $sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&amp;sort_by=SESSID&amp;sort_dir=DESC&amp;usersearch=$usersearch&amp;page=$page\">{$lang['kick']}</a></td>\n";
}elseif ($sort_by == 'SESSIONS.SESSID' && $sort_dir == 'DESC') {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&amp;sort_by=SESSID&amp;sort_dir=ASC&amp;usersearch=$usersearch&amp;page=$page\">{$lang['kick']}</a></td>\n";
}elseif ($sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&amp;sort_by=SESSID&amp;sort_dir=ASC&amp;usersearch=$usersearch&amp;page=$page\">{$lang['kick']}</a></td>\n";
}else {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&amp;sort_by=SESSID&amp;sort_dir=DESC&amp;usersearch=$usersearch&amp;page=$page\">{$lang['kick']}</a></td>\n";
}

echo "                 </tr>\n";

$start = floor($page - 1) * 20;
if ($start < 0) $start = 0;

if (isset($usersearch) && strlen($usersearch) > 0) {
    $admin_user_array = admin_user_search($usersearch, $sort_by, $sort_dir, $start, false);
}else {
    $admin_user_array = admin_user_get_all($sort_by, $sort_dir, $start, false);
}

if (sizeof($admin_user_array['user_array']) > 0) {

    foreach ($admin_user_array['user_array'] as $user) {

        echo "                 <tr>\n";
        echo "                   <td class=\"posthead\" align=\"left\">&nbsp;", $user['UID'], "</td>\n";
        echo "                   <td class=\"posthead\" align=\"left\">&nbsp;<a href=\"admin_user.php?webtag=$webtag&amp;uid=", $user['UID'], "\">", format_user_name($user['LOGON'], $user['NICKNAME']), "</a></td>\n";
        echo "                   <td class=\"posthead\" align=\"left\">&nbsp;";

        if (isset($user['STATUS']) && $user['STATUS'] > 0) {

            if ($user['STATUS']&USER_PERM_QUEEN)   echo "{$lang['queen']} ";
            if ($user['STATUS']&USER_PERM_SOLDIER) echo "{$lang['soldier']} ";
            if ($user['STATUS']&USER_PERM_WORKER)  echo "{$lang['worker']} ";
            if ($user['STATUS']&USER_PERM_WORM)    echo "{$lang['worm']} ";
            if ($user['STATUS']&USER_PERM_WASP)    echo "{$lang['wasp']} ";
            if ($user['STATUS']&USER_PERM_SPLAT)   echo "{$lang['splat']}";

        }else {
            echo "&nbsp;";
        }

        echo "</td>\n";

        if (!isset($user['LAST_LOGON']) || is_null($user['LAST_LOGON'])) {
            echo "                   <td class=\"posthead\" align=\"left\">&nbsp;{$lang['unknown']}</td>\n";
        }else {
            echo "                   <td class=\"posthead\" align=\"left\">&nbsp;", format_time($user['LAST_LOGON'], 1), "</td>\n";
        }

        if (user_is_active($user['UID'])) {
            echo "                   <td class=\"posthead\" align=\"left\">&nbsp;<b>{$lang['yes']}</b></td>\n";
            echo "                   <td class=\"posthead\" align=\"left\">&nbsp;", form_submit("t_kick[{$user['UID']}]", $lang['kick']), "</td>\n";
        }else {
            echo "                   <td class=\"posthead\" align=\"left\">&nbsp;{$lang['no']}</td>\n";
            echo "                   <td class=\"posthead\" align=\"left\">&nbsp;</td>\n";
        }

        echo "                 </tr>\n";
    }

}else {

    if (isset($usersearch) && strlen($usersearch) > 0) {

        echo "                 <tr>\n";
        echo "                   <td class=\"posthead\" colspan=\"7\" align=\"left\">{$lang['nomatches']}</td>\n";
        echo "                 </tr>\n";

    }else {

        // Shouldn't happen ever, after all how did you get here if there are no user accounts?

        echo "                 <tr>\n";
        echo "                   <td class=\"posthead\" colspan=\"7\" align=\"left\">{$lang['nouseraccounts']}</td>\n";
        echo "                 </tr>\n";

    }

}

echo "                 <tr>\n";
echo "                   <td colspan=\"6\">&nbsp;</td>\n";
echo "                 </tr>\n";
echo "               </table>\n";
echo "             </td>\n";
echo "           </tr>\n";
echo "         </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td>&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td class=\"postbody\" align=\"center\">{$lang['pages']}: ";

$page_count = ceil($admin_user_array['user_count'] / 20);

if ($page_count > 1) {

    for ($page = 1; $page <= $page_count; $page++) {
        echo "<a href=\"admin_users.php?webtag=$webtag&amp;usersearch=$usersearch&amp;sort_by={$sort_by_array[$sort_by]}&amp;sort_dir=$sort_dir&amp;page=$page\" target=\"_self\">$page</a> ";
    }

}else {

    echo "<a href=\"admin_users.php?webtag=$webtag&amp;usersearch=$usersearch&amp;sort_by={$sort_by_array[$sort_by]}&amp;sort_dir=$sort_dir&amp;page=1\" target=\"_self\">1</a> ";
}

echo "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";

echo "<form action=\"admin_users.php\" method=\"get\">\n";
echo "  ", form_input_hidden("webtag", $webtag), "\n";
echo "  ", form_input_hidden("sort_by", $sort_by), "\n";
echo "  ", form_input_hidden("sort_dir", $sort_dir), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"96%\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" align=\"left\">{$lang['searchforusernotinlist']}:</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td class=\"posthead\" align=\"left\">\n";
echo "                    {$lang['username']}: ", form_input_text('usersearch', $usersearch, 30, 64), " ", form_submit('submit', $lang['search']), " ", form_submit('reset', $lang['clear']), "\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"6\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";
echo "</div>\n";

html_draw_bottom();

?>