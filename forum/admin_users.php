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

/* $Id: admin_users.php,v 1.115 2006-07-18 20:16:42 decoyduck Exp $ */

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

include_once(BH_INCLUDE_PATH. "admin.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=admin.php%3Fpage%3D$request_uri");
}

// Load language file

$lang = load_language_file();

html_draw_top("openprofile.js");

if (!(bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0))) {
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;
}

// Friendly display names for column sorting

$sort_by_array = array('USER.UID'        => 'User ID',
                       'USER.LOGON'      => 'Logon',
                       'USER.LAST_LOGON' => 'Last Logon',
                       'SESSION.REFERER' => 'Referer');

// Column sorting stuff

if (isset($_GET['sort_by'])) {
    if ($_GET['sort_by'] == "UID") {
        $sort_by = "USER.UID";
    } elseif ($_GET['sort_by'] == "LOGON") {
        $sort_by = "USER.LOGON";
    } elseif ($_GET['sort_by'] == "LAST_LOGON") {
        $sort_by = "VISITOR_LOG.LAST_LOGON";
    } elseif ($_GET['sort_by'] == "REFERER") {
        $sort_by = "SESSION.REFERER";
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

if (isset($_GET['usersearch']) && strlen(trim(_stripslashes($_GET['usersearch']))) > 0) {
    $usersearch = trim(_stripslashes($_GET['usersearch']));
}else {
    $usersearch = "";
}

if (isset($_GET['reset'])) {
    $usersearch = "";
}

// Draw the form
echo "<h1>{$lang['admin']} : ", (isset($forum_settings['forum_name']) ? $forum_settings['forum_name'] : 'A Beehive Forum'), " : {$lang['manageusers']}</h1>\n";

if (bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0, 0)) {

    if (isset($_POST['t_kick'])) {

        list($user_uid) = array_keys($_POST['t_kick']);

        if (admin_session_end($user_uid)) {

            $user_logon = user_get_logon($user_uid);

            admin_add_log_entry(END_USER_SESSION, $user_logon);
            echo "<p><b>{$lang['sessionsuccessfullyended']}: <a href=\"javascript:void(0)\" onclick=\"openProfile($user_uid, '$webtag')\" target=\"_self\">$user_logon</a></b></p>\n";
        }
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
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&amp;sort_by=UID&amp;sort_dir=DESC&amp;usersearch=$usersearch&amp;page=$page\">UID&nbsp;<img src=\"", style_image("sort_asc.png"), "\" border=\"0\" alt=\"{$lang['sortasc']}\" title=\"{$lang['sortasc']}\" /></a></td>\n";
}elseif ($sort_by == 'USER.UID' && $sort_dir == 'DESC') {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&amp;sort_by=UID&amp;sort_dir=ASC&amp;usersearch=$usersearch&amp;page=$page\">UID&nbsp;<img src=\"", style_image("sort_desc.png"), "\" border=\"0\" alt=\"{$lang['sortdesc']}\" title=\"{$lang['sortdesc']}\" /></a></td>\n";
}elseif ($sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&amp;sort_by=UID&amp;sort_dir=ASC&amp;usersearch=$usersearch&amp;page=$page\">UID</a></td>\n";
}else {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&amp;sort_by=UID&amp;sort_dir=DESC&amp;usersearch=$usersearch&amp;page=$page\">UID</a></td>\n";
}

if ($sort_by == 'USER.LOGON' && $sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&amp;sort_by=LOGON&amp;sort_dir=DESC&amp;usersearch=$usersearch&amp;page=$page\">{$lang['logon']}&nbsp;<img src=\"", style_image("sort_asc.png"), "\" border=\"0\" alt=\"{$lang['sortasc']}\" title=\"{$lang['sortasc']}\" /></a></td>\n";
}elseif ($sort_by == 'USER.LOGON' && $sort_dir == 'DESC') {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&amp;sort_by=LOGON&amp;sort_dir=ASC&amp;usersearch=$usersearch&amp;page=$page\">{$lang['logon']}&nbsp;<img src=\"", style_image("sort_desc.png"), "\" border=\"0\" alt=\"{$lang['sortdesc']}\" title=\"{$lang['sortdesc']}\" /></a></td>\n";
}elseif ($sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&amp;sort_by=LOGON&amp;sort_dir=ASC&amp;usersearch=$usersearch&amp;page=$page\">{$lang['logon']}</a></td>\n";
}else {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&amp;sort_by=LOGON&amp;sort_dir=DESC&amp;usersearch=$usersearch&amp;page=$page\">{$lang['logon']}</a></td>\n";
}

if ($sort_by == 'USER.LAST_LOGON' && $sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&amp;sort_by=LAST_LOGON&amp;sort_dir=DESC&amp;usersearch=$usersearch&amp;page=$page\">{$lang['lastlogon']}&nbsp;<img src=\"", style_image("sort_asc.png"), "\" border=\"0\" alt=\"{$lang['sortasc']}\" title=\"{$lang['sortasc']}\" /></a></td>\n";
}elseif ($sort_by == 'USER.LAST_LOGON' && $sort_dir == 'DESC') {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&amp;sort_by=LAST_LOGON&amp;sort_dir=ASC&amp;usersearch=$usersearch&amp;page=$page\">{$lang['lastlogon']}&nbsp;<img src=\"", style_image("sort_desc.png"), "\" border=\"0\" alt=\"{$lang['sortdesc']}\" title=\"{$lang['sortdesc']}\" /></a></td>\n";
}elseif ($sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&amp;sort_by=LAST_LOGON&amp;sort_dir=ASC&amp;usersearch=$usersearch&amp;page=$page\">{$lang['lastlogon']}</a></td>\n";
}else {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&amp;sort_by=LAST_LOGON&amp;sort_dir=DESC&amp;usersearch=$usersearch&amp;page=$page\">{$lang['lastlogon']}</a></td>\n";
}

if ($sort_by == 'SESSION.REFERER' && $sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&amp;sort_by=REFERER&amp;sort_dir=DESC&amp;usersearch=$usersearch&amp;page=$page\">{$lang['sessionreferer']}&nbsp;<img src=\"", style_image("sort_asc.png"), "\" border=\"0\" alt=\"{$lang['sortasc']}\" title=\"{$lang['sortasc']}\" /></a></td>\n";
}elseif ($sort_by == 'SESSION.REFERER' && $sort_dir == 'DESC') {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&amp;sort_by=REFERER&amp;sort_dir=ASC&amp;usersearch=$usersearch&amp;page=$page\">{$lang['sessionreferer']}&nbsp;<img src=\"", style_image("sort_desc.png"), "\" border=\"0\" alt=\"{$lang['sortdesc']}\" title=\"{$lang['sortdesc']}\" /></a></td>\n";
}elseif ($sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&amp;sort_by=REFERER&amp;sort_dir=ASC&amp;usersearch=$usersearch&amp;page=$page\">{$lang['sessionreferer']}</a></td>\n";
}else {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&amp;sort_by=REFERER&amp;sort_dir=DESC&amp;usersearch=$usersearch&amp;page=$page\">{$lang['sessionreferer']}</a></td>\n";
}

echo "                   <td class=\"subhead\" align=\"left\">&nbsp;{$lang['active']}</td>\n";
echo "                   <td class=\"subhead\" align=\"left\">&nbsp;{$lang['kick']}</td>\n";
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

        if (isset($user['LAST_LOGON']) && $user['LAST_LOGON'] > 0) {
            echo "                   <td class=\"posthead\" align=\"left\">&nbsp;", format_time($user['LAST_LOGON'], 1), "</td>\n";
        }else {
            echo "                   <td class=\"posthead\" align=\"left\">&nbsp;{$lang['unknown']}</td>\n";
        }

        if (isset($user['REFERER']) && strlen(trim($user['REFERER'])) > 0) {

            $user['REFERER_FULL'] = $user['REFERER'];

            if (!$user['REFERER'] = split_url($user['REFERER'])) {
                if (strlen($user['REFERER_FULL']) > 25) {
                    $user['REFERER'] = substr($user['REFERER_FULL'], 0, 25);
                    $user['REFERER'].= "&hellip;";
                }
            }

            if (referer_is_banned($user['REFERER'])) {
                echo "                   <td class=\"posthead\" align=\"left\">&nbsp;<a href=\"admin_banned.php?unban_referer=", rawurlencode($user['REFERER_FULL']), "&amp;ret=admin_users.php\" title=\"{$user['REFERER_FULL']}\">{$user['REFERER']}</a> ({$lang['banned']})</td>\n";
            }else {
                echo "                   <td class=\"posthead\" align=\"left\">&nbsp;<a href=\"admin_banned.php?ban_referer=", rawurlencode($user['REFERER_FULL']), "&amp;ret=admin_users.php\" title=\"{$user['REFERER_FULL']}\">{$user['REFERER']}</a></td>\n";
            }

        }else {

            echo "                   <td class=\"posthead\" align=\"left\">&nbsp;{$lang['unknown']}</td>\n";
        }

        if (isset($user['HASH']) && is_md5($user['HASH'])) {

            if (bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0, 0)) {

                echo "                   <td class=\"posthead\" align=\"left\">&nbsp;<b>{$lang['yes']}</b></td>\n";
                echo "                   <td class=\"posthead\" align=\"left\">&nbsp;", form_submit("t_kick[{$user['UID']}]", $lang['kick']), "</td>\n";

            }else {

                echo "                   <td class=\"posthead\" align=\"left\">&nbsp;<b>{$lang['yes']}</b></td>\n";
                echo "                   <td class=\"posthead\" align=\"left\">&nbsp;</td>\n";
            }

        }else {

            echo "                   <td class=\"posthead\" align=\"left\">&nbsp;{$lang['no']}</td>\n";
            echo "                   <td class=\"posthead\" align=\"left\">&nbsp;</td>\n";
        }

        echo "                 </tr>\n";
    }

}else {

    if (isset($usersearch) && strlen($usersearch) > 0) {

        echo "                 <tr>\n";
        echo "                   <td class=\"posthead\" colspan=\"5\" align=\"left\">{$lang['nomatches']}</td>\n";
        echo "                 </tr>\n";

    }else {

        // Shouldn't happen ever, after all how did you get here if there are no user accounts?

        echo "                 <tr>\n";
        echo "                   <td class=\"posthead\" colspan=\"5\" align=\"left\">{$lang['nouseraccounts']}</td>\n";
        echo "                 </tr>\n";
    }
}

echo "                 <tr>\n";
echo "                   <td colspan=\"5\">&nbsp;</td>\n";
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
echo "      <td class=\"postbody\" align=\"center\">", page_links(get_request_uri(false), $start, $admin_user_array['user_count'], 20), "</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td>&nbsp;</td>\n";
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