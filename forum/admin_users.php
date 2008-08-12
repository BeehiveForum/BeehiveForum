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

/* $Id: admin_users.php,v 1.174 2008-08-12 17:13:46 decoyduck Exp $ */

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

include_once(BH_INCLUDE_PATH. "admin.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "email.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag();
    header_redirect("logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.

if (bh_session_user_banned()) {

    html_user_banned();
    exit;
}

// Check we have a webtag

$webtag = get_webtag();

// Load language file

$lang = load_language_file();

// Array to hold error messages

$error_msg_array = array();

// Check we have permission to access this page.

if (!(bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0))) {

    html_draw_top();
    html_error_msg($lang['accessdeniedexp']);
    html_draw_bottom();
    exit;
}

// Friendly display names for column sorting

$sort_by_array = array('LOGON'      => $lang['logon'],
                       'LAST_VISIT' => $lang['lastlogon'],
                       'REGISTERED' => $lang['registered'],
                       'REFERER'    => $lang['referer']);

// Column sorting stuff

if (isset($_GET['sort_by'])) {

    if ($_GET['sort_by'] == "LOGON") {
        $sort_by = "LOGON";
    } elseif ($_GET['sort_by'] == "LAST_LOGON") {
        $sort_by = "LAST_VISIT";
    } elseif ($_GET['sort_by'] == "REGISTERED") {
        $sort_by = "REGISTERED";
    } elseif ($_GET['sort_by'] == "REFERER") {
        $sort_by = "REFERER";
    } else {
        $sort_by = "LAST_VISIT";
    }

}else if (isset($_POST['sort_by'])) {

    if ($_POST['sort_by'] == "LOGON") {
        $sort_by = "LOGON";
    } elseif ($_POST['sort_by'] == "LAST_LOGON") {
        $sort_by = "LAST_VISIT";
    } elseif ($_POST['sort_by'] == "REGISTERED") {
        $sort_by = "REGISTERED";
    } elseif ($_POST['sort_by'] == "REFERER") {
        $sort_by = "REFERER";
    } else {
        $sort_by = "LAST_VISIT";
    }

}else {

    $sort_by = "LAST_VISIT";
}

if (isset($_GET['sort_dir'])) {

    if ($_GET['sort_dir'] == "DESC") {
        $sort_dir = "DESC";
    } else {
        $sort_dir = "ASC";
    }

}else if (isset($_POST['sort_dir'])) {

    if ($_POST['sort_dir'] == "DESC") {
        $sort_dir = "DESC";
    } else {
        $sort_dir = "ASC";
    }

}else {

    $sort_dir = "DESC";
}

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = ($_GET['page'] > 0) ? $_GET['page'] : 1;
}else {
    $page = 1;
}

$start = floor($page - 1) * 10;
if ($start < 0) $start = 0;

if (isset($_GET['user_search']) && strlen(trim(_stripslashes($_GET['user_search']))) > 0) {
    $user_search = trim(_stripslashes($_GET['user_search']));
}elseif (isset($_POST['user_search']) && strlen(trim(_stripslashes($_POST['user_search']))) > 0) {
    $user_search = trim(_stripslashes($_POST['user_search']));
}else {
    $user_search = "";
}

if (isset($_GET['reset'])) {
    $user_search = "";
}

if (isset($_GET['filter']) && is_numeric($_GET['filter'])) {
    $filter = $_GET['filter'];
}elseif (isset($_POST['filter']) && is_numeric($_POST['filter'])) {
    $filter = $_POST['filter'];
}else {
    $filter = ADMIN_USER_FILTER_NONE;
}

html_draw_top("openprofile.js");

if (($table_data = get_table_prefix())) {
    echo "<h1>{$lang['admin']} &raquo; ", forum_get_setting('forum_name', false, 'A Beehive Forum'), " &raquo; {$lang['manageusers']}</h1>\n";
}else {
    echo "<h1>{$lang['admin']} &raquo; {$lang['manageusers']}</h1>\n";
}

if (bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0)) {

    if (isset($_POST['kick_submit'])) {

        $valid = true;

        if (isset($_POST['user_update']) && is_array($_POST['user_update'])) {

            $kick_users = preg_grep("/^[0-9]+$/u", array_keys($_POST['user_update']));

            $kick_user_success_array = array();

            foreach ($kick_users as $user_uid) {

                if (($valid && $user_logon = user_get_logon($user_uid))) {

                    if (!admin_session_end($user_uid)) {

                        $error_msg_array[] = sprintf($lang['failedtoendsessionforuser'], $user_logon);
                        $valid = false;
                    }
                }
            }

            if ($valid) {

                $redirect_uri = "admin_users.php?webtag=$webtag&page=$page";
                $redirect_uri.= "&sort_by=$sort_by&sort_dir=$sort_dir&filter=$filter";
                $redirect_uri.= "&user_search=%s&kicked=true";

                header_redirect(sprintf($redirect_uri, _htmlentities($user_search)));
                exit;
            }
        }

    }elseif (isset($_POST['approve_submit'])) {

        if (forum_get_setting('require_user_approval', 'Y')) {

            $valid = true;

            if (isset($_POST['user_update']) && is_array($_POST['user_update'])) {

                $approve_users = preg_grep("/^[0-9]+$/u", array_keys($_POST['user_update']));

                $approved_user_success_array = array();

                foreach ($approve_users as $user_uid) {

                    if (($valid && $user_logon = user_get_logon($user_uid))) {

                        if (admin_approve_user($user_uid)) {

                            email_send_user_approved_notification($user_uid);

                        }else {

                            $error_msg_array[] = sprintf($lang['failedtoapproveuser'], $user_logon);
                            $valid = false;
                        }
                    }
                }

                if ($valid) {

                    $redirect_uri = "admin_users.php?webtag=$webtag&page=$page";
                    $redirect_uri.= "&sort_by=$sort_by&sort_dir=$sort_dir&filter=$filter";
                    $redirect_uri.= "&user_search=%s&approved=true";

                    header_redirect(sprintf($redirect_uri, _htmlentities($user_search)));
                    exit;
                }
            }
        }
    }
}

if (isset($user_search) && strlen($user_search) > 0) {
    $admin_user_array = admin_user_search($user_search, $sort_by, $sort_dir, $filter, $start);
}else {
    $admin_user_array = admin_user_get_all($sort_by, $sort_dir, $filter, $start);
}

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '86%', 'center');

}else if (isset($_GET['kicked'])) {

    html_display_success_msg($lang['successfullyendedusersessionsforselectedusers'], '86%', 'center');

}elseif (isset($_GET['approved'])) {

    html_display_success_msg($lang['successfullyapprovedselectedusers'], '86%', 'center');

}elseif (sizeof($admin_user_array['user_array']) < 1) {

    if (isset($user_search) && strlen($user_search) > 0) {

        html_display_error_msg($lang['yoursearchdidnotreturnanymatches'], '86%', 'center');

    }else {

        html_display_error_msg($lang['nouseraccountsmatchingfilter'], '86%', 'center');
    }

}else {

    html_display_warning_msg(sprintf($lang['manageusersexp'], _htmlentities($sort_by_array[$sort_by])), '86%', 'center');
}

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form action=\"admin_users.php\" method=\"post\">\n";
echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
echo "  ", form_input_hidden('user_search', _htmlentities($user_search)), "\n";
echo "  ", form_input_hidden("sort_by", _htmlentities($sort_by)), "\n";
echo "  ", form_input_hidden("sort_dir", _htmlentities($sort_dir)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"86%\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\" colspan=\"3\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                 <tr>\n";
echo "                   <td class=\"subhead\" width=\"20\">&nbsp;</td>\n";

if ($sort_by == 'LOGON' && $sort_dir == 'ASC') {
    echo "                   <td class=\"subhead_sort_asc\" align=\"left\"><a href=\"admin_users.php?webtag=$webtag&amp;sort_by=LOGON&amp;sort_dir=DESC&amp;user_search=", _htmlentities($user_search), "&amp;page=$page&amp;filter=$filter\">{$lang['user']}</a></td>\n";
}elseif ($sort_by == 'LOGON' && $sort_dir == 'DESC') {
    echo "                   <td class=\"subhead_sort_desc\" align=\"left\"><a href=\"admin_users.php?webtag=$webtag&amp;sort_by=LOGON&amp;sort_dir=ASC&amp;user_search=", _htmlentities($user_search), "&amp;page=$page&amp;filter=$filter\">{$lang['user']}</a></td>\n";
}elseif ($sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"left\"><a href=\"admin_users.php?webtag=$webtag&amp;sort_by=LOGON&amp;sort_dir=ASC&amp;user_search=", _htmlentities($user_search), "&amp;page=$page&amp;filter=$filter\">{$lang['user']}</a></td>\n";
}else {
    echo "                   <td class=\"subhead\" align=\"left\"><a href=\"admin_users.php?webtag=$webtag&amp;sort_by=LOGON&amp;sort_dir=DESC&amp;user_search=", _htmlentities($user_search), "&amp;page=$page&amp;filter=$filter\">{$lang['user']}</a></td>\n";
}

if ($sort_by == 'LAST_VISIT' && $sort_dir == 'ASC') {
    echo "                   <td class=\"subhead_sort_asc\" align=\"left\"><a href=\"admin_users.php?webtag=$webtag&amp;sort_by=LAST_LOGON&amp;sort_dir=DESC&amp;user_search=", _htmlentities($user_search), "&amp;page=$page&amp;filter=$filter\">{$lang['lastlogon']}</a></td>\n";
}elseif ($sort_by == 'LAST_VISIT' && $sort_dir == 'DESC') {
    echo "                   <td class=\"subhead_sort_desc\" align=\"left\"><a href=\"admin_users.php?webtag=$webtag&amp;sort_by=LAST_LOGON&amp;sort_dir=ASC&amp;user_search=", _htmlentities($user_search), "&amp;page=$page&amp;filter=$filter\">{$lang['lastlogon']}</a></td>\n";
}elseif ($sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"left\"><a href=\"admin_users.php?webtag=$webtag&amp;sort_by=LAST_LOGON&amp;sort_dir=ASC&amp;user_search=", _htmlentities($user_search), "&amp;page=$page&amp;filter=$filter\">{$lang['lastlogon']}</a></td>\n";
}else {
    echo "                   <td class=\"subhead\" align=\"left\"><a href=\"admin_users.php?webtag=$webtag&amp;sort_by=LAST_LOGON&amp;sort_dir=DESC&amp;user_search=", _htmlentities($user_search), "&amp;page=$page&amp;filter=$filter\">{$lang['lastlogon']}</a></td>\n";
}

if ($sort_by == 'REGISTERED' && $sort_dir == 'ASC') {
    echo "                   <td class=\"subhead_sort_asc\" align=\"left\"><a href=\"admin_users.php?webtag=$webtag&amp;sort_by=REGISTERED&amp;sort_dir=DESC&amp;user_search=", _htmlentities($user_search), "&amp;page=$page&amp;filter=$filter\">{$lang['registered']}</a></td>\n";
}elseif ($sort_by == 'REGISTERED' && $sort_dir == 'DESC') {
    echo "                   <td class=\"subhead_sort_desc\" align=\"left\"><a href=\"admin_users.php?webtag=$webtag&amp;sort_by=REGISTERED&amp;sort_dir=ASC&amp;user_search=", _htmlentities($user_search), "&amp;page=$page&amp;filter=$filter\">{$lang['registered']}</a></td>\n";
}elseif ($sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"left\"><a href=\"admin_users.php?webtag=$webtag&amp;sort_by=REGISTERED&amp;sort_dir=ASC&amp;user_search=", _htmlentities($user_search), "&amp;page=$page&amp;filter=$filter\">{$lang['registered']}</a></td>\n";
}else {
    echo "                   <td class=\"subhead\" align=\"left\"><a href=\"admin_users.php?webtag=$webtag&amp;sort_by=REGISTERED&amp;sort_dir=DESC&amp;user_search=", _htmlentities($user_search), "&amp;page=$page&amp;filter=$filter\">{$lang['registered']}</a></td>\n";
}

if ($sort_by == 'REFERER' && $sort_dir == 'ASC') {
    echo "                   <td class=\"subhead_sort_asc\" align=\"left\"><a href=\"admin_users.php?webtag=$webtag&amp;sort_by=REFERER&amp;sort_dir=DESC&amp;user_search=", _htmlentities($user_search), "&amp;page=$page&amp;filter=$filter\">{$lang['sessionreferer']}</a></td>\n";
}elseif ($sort_by == 'REFERER' && $sort_dir == 'DESC') {
    echo "                   <td class=\"subhead_sort_desc\" align=\"left\"><a href=\"admin_users.php?webtag=$webtag&amp;sort_by=REFERER&amp;sort_dir=ASC&amp;user_search=", _htmlentities($user_search), "&amp;page=$page&amp;filter=$filter\">{$lang['sessionreferer']}</a></td>\n";
}elseif ($sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"left\"><a href=\"admin_users.php?webtag=$webtag&amp;sort_by=REFERER&amp;sort_dir=ASC&amp;user_search=", _htmlentities($user_search), "&amp;page=$page&amp;filter=$filter\">{$lang['sessionreferer']}</a></td>\n";
}else {
    echo "                   <td class=\"subhead\" align=\"left\"><a href=\"admin_users.php?webtag=$webtag&amp;sort_by=REFERER&amp;sort_dir=DESC&amp;user_search=", _htmlentities($user_search), "&amp;page=$page&amp;filter=$filter\">{$lang['sessionreferer']}</a></td>\n";
}

echo "                   <td class=\"subhead\" align=\"left\">{$lang['active']}</td>\n";
echo "                 </tr>\n";

if (sizeof($admin_user_array['user_array']) > 0) {

    foreach ($admin_user_array['user_array'] as $user) {

        echo "                 <tr>\n";
        echo "                   <td align=\"center\">", form_checkbox("user_update[{$user['UID']}]", "Y", ""), "</td>\n";
        echo "                   <td class=\"posthead\" align=\"left\" width=\"35%\">&nbsp;<a href=\"admin_user.php?webtag=$webtag&amp;uid=", $user['UID'], "\">", word_filter_add_ob_tags(_htmlentities(format_user_name($user['LOGON'], $user['NICKNAME']))), "</a></td>\n";

        if (isset($user['LAST_VISIT']) && $user['LAST_VISIT'] > 0) {
            echo "                   <td class=\"posthead\" align=\"left\">&nbsp;", format_time($user['LAST_VISIT'], 1), "</td>\n";
        }else {
            echo "                   <td class=\"posthead\" align=\"left\">&nbsp;{$lang['unknown']}</td>\n";
        }

        if (isset($user['REGISTERED']) && $user['REGISTERED'] > 0) {
            echo "                   <td class=\"posthead\" align=\"left\">&nbsp;", format_time($user['REGISTERED'], 1), "</td>\n";
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
                echo "                   <td class=\"posthead\" align=\"left\">&nbsp;<a href=\"admin_banned.php?webtag=$webtag&amp;unban_referer=", rawurlencode($user['REFERER_FULL']), "&amp;ret=", rawurlencode(get_request_uri(true, false)), "\" title=\"{$user['REFERER_FULL']}\">{$user['REFERER']}</a>&nbsp;<a href=\"{$user['REFERER_FULL']}\"><img src=\"", style_image('link.png'), "\" border=\"0\" align=\"top\" alt=\"{$lang['externallink']}\" title=\"{$lang['externallink']}\" /></a> ({$lang['banned']})</td>\n";
            }else {
                echo "                   <td class=\"posthead\" align=\"left\">&nbsp;<a href=\"admin_banned.php?webtag=$webtag&amp;ban_referer=", rawurlencode($user['REFERER_FULL']), "&amp;ret=", rawurlencode(get_request_uri(true, false)), "\" title=\"{$user['REFERER_FULL']}\">{$user['REFERER']}</a>&nbsp;<a href=\"{$user['REFERER_FULL']}\"><img src=\"", style_image('link.png'), "\" border=\"0\" align=\"top\" alt=\"{$lang['externallink']}\" title=\"{$lang['externallink']}\" /></a></td>\n";
            }

        }else {

            echo "                   <td class=\"posthead\" align=\"left\">&nbsp;{$lang['unknown']}</td>\n";
        }

        if (isset($user['HASH']) && is_md5($user['HASH'])) {
            echo "                   <td class=\"posthead\" align=\"left\">&nbsp;<b>{$lang['yes']}</b></td>\n";
        }else {
            echo "                   <td class=\"posthead\" align=\"left\">&nbsp;{$lang['no']}</td>\n";
        }

        echo "                 </tr>\n";
    }
}

echo "                 <tr>\n";
echo "                   <td align=\"left\" colspan=\"5\">&nbsp;</td>\n";
echo "                 </tr>\n";
echo "               </table>\n";
echo "             </td>\n";
echo "           </tr>\n";
echo "         </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";

if (sizeof($admin_user_array['user_array']) > 0) {

    echo "      <td align=\"left\" width=\"40%\">", bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0) ? form_submit("kick_submit", $lang['kickselected']). "&nbsp;" : "", forum_get_setting('require_user_approval', 'Y') && bh_session_check_perm(USER_PERM_FORUM_TOOLS, 0) ? form_submit("approve_submit", $lang['approveselected']) : "", "</td>\n";

}else {

    echo "      <td align=\"left\" width=\"40%\">&nbsp;</td>\n";
}

echo "      <td class=\"postbody\" align=\"center\">", page_links("admin_users.php?webtag=$webtag&sort_by=$sort_by&sort_dir=$sort_dir&user_search=$user_search&filter=$filter", $start, $admin_user_array['user_count'], 10), "</td>\n";

if (forum_get_setting('require_user_approval', 'Y') && (bh_session_check_perm(USER_PERM_FORUM_TOOLS, 0))) {

    echo "      <td align=\"right\" width=\"40%\" class=\"postbody\">{$lang['userfilter']}: ", form_dropdown_array("filter", array($lang['all'], $lang['onlineusers'], $lang['offlineusers'], $lang['bannedusers'], $lang['usersawaitingapproval']), $filter), "&nbsp;", form_submit("go", $lang['go']), "</td>\n";

}else {

    echo "      <td align=\"right\" width=\"40%\" class=\"postbody\">{$lang['userfilter']}: ", form_dropdown_array("filter", array($lang['all'], $lang['onlineusers'], $lang['offlineusers'], $lang['bannedusers']), $filter), "&nbsp;", form_submit("go", $lang['go']), "</td>\n";
}

echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";

echo "<form action=\"admin_users.php\" method=\"get\">\n";
echo "  ", form_input_hidden("webtag", _htmlentities($webtag)), "\n";
echo "  ", form_input_hidden("sort_by", _htmlentities($sort_by)), "\n";
echo "  ", form_input_hidden("sort_dir", _htmlentities($sort_dir)), "\n";
echo "  ", form_input_hidden("filter", _htmlentities($filter)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"86%\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" align=\"left\">{$lang['searchforusernotinlist']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td class=\"posthead\" align=\"left\">{$lang['username']}: ", form_input_text('user_search', _htmlentities($user_search), 30, 64), " ", form_submit('search', $lang['search']), " ", form_submit('reset', $lang['clear']), "</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"6\">&nbsp;</td>\n";
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