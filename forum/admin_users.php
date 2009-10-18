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

/* $Id: admin_users.php,v 1.195 2009-10-18 17:51:07 decoyduck Exp $ */

// Set the default timezone
date_default_timezone_set('UTC');

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Disable PHP's register_globals
unregister_globals();

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
include_once(BH_INCLUDE_PATH. "compat.inc.php");
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

// Get Webtag

$webtag = get_webtag();

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.

if (bh_session_user_banned()) {

    html_user_banned();
    exit;
}

// Load language file

$lang = load_language_file();

// Array to hold error messages

$error_msg_array = array();

// Check we have permission to access this page.

if (!(bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0))) {

    html_draw_top("title={$lang['error']}");
    html_error_msg($lang['accessdeniedexp']);
    html_draw_bottom();
    exit;
}

// Friendly display names for column sorting

$sort_by_array = array('LOGON'      => $lang['logon'],
                       'LAST_VISIT' => $lang['lastlogon'],
                       'REGISTERED' => $lang['registered'],
                       'ACTIVE'     => $lang['active']);

// Column sorting stuff

if (isset($_GET['sort_by'])) {

    if ($_GET['sort_by'] == "LOGON") {
        $sort_by = "LOGON";
    } elseif ($_GET['sort_by'] == "LAST_LOGON") {
        $sort_by = "LAST_VISIT";
    } elseif ($_GET['sort_by'] == "REGISTERED") {
        $sort_by = "REGISTERED";
    } elseif ($_GET['sort_by'] == "ACTIVE") {
        $sort_by = "ACTIVE";
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
    } elseif ($_POST['sort_by'] == "ACTIVE") {
        $sort_by = "ACTIVE";
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

if (isset($_GET['user_search']) && strlen(trim(stripslashes_array($_GET['user_search']))) > 0) {
    $user_search = trim(stripslashes_array($_GET['user_search']));
}elseif (isset($_POST['user_search']) && strlen(trim(stripslashes_array($_POST['user_search']))) > 0) {
    $user_search = trim(stripslashes_array($_POST['user_search']));
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

html_draw_top("title={$lang['admin']} » {$lang['manageusers']}", 'openprofile.js');

echo "<h1>{$lang['admin']} &raquo; {$lang['manageusers']}</h1>\n";

if (bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0, 0)) {

    if (isset($_POST['select_action'])) {

        if (isset($_POST['action']) && is_numeric($_POST['action'])) {

            if ($_POST['action'] == ADMIN_USER_OPTION_END_SESSION) {

                $valid = true;

                if (isset($_POST['user_update']) && is_array($_POST['user_update'])) {

                    $kick_users = array_filter(array_keys($_POST['user_update']), 'is_numeric');

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

                        header_redirect(sprintf($redirect_uri, htmlentities_array($user_search)));
                        exit;
                    }
                }
            }

        }else if ($_POST['action'] == ADMIN_USER_OPTION_APPROVE) {

            if (forum_get_setting('require_user_approval', 'Y')) {

                $valid = true;

                if (isset($_POST['user_update']) && is_array($_POST['user_update'])) {

                    $approve_users = array_filter(array_keys($_POST['user_update']), 'is_numeric');

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

                        header_redirect(sprintf($redirect_uri, htmlentities_array($user_search)));
                        exit;
                    }
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

    html_display_warning_msg(sprintf($lang['manageusersexp'], htmlentities_array($sort_by_array[$sort_by])), '86%', 'center');
}

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form accept-charset=\"utf-8\" action=\"admin_users.php\" method=\"post\">\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden('user_search', htmlentities_array($user_search)), "\n";
echo "  ", form_input_hidden("sort_by", htmlentities_array($sort_by)), "\n";
echo "  ", form_input_hidden("sort_dir", htmlentities_array($sort_dir)), "\n";
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
    echo "                   <td class=\"subhead_sort_asc\" align=\"left\" nowrap=\"nowrap\"><a href=\"admin_users.php?webtag=$webtag&amp;sort_by=LOGON&amp;sort_dir=DESC&amp;user_search=", htmlentities_array($user_search), "&amp;page=$page&amp;filter=$filter\">{$lang['user']}</a></td>\n";
}elseif ($sort_by == 'LOGON' && $sort_dir == 'DESC') {
    echo "                   <td class=\"subhead_sort_desc\" align=\"left\" nowrap=\"nowrap\"><a href=\"admin_users.php?webtag=$webtag&amp;sort_by=LOGON&amp;sort_dir=ASC&amp;user_search=", htmlentities_array($user_search), "&amp;page=$page&amp;filter=$filter\">{$lang['user']}</a></td>\n";
}elseif ($sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"left\" nowrap=\"nowrap\"><a href=\"admin_users.php?webtag=$webtag&amp;sort_by=LOGON&amp;sort_dir=ASC&amp;user_search=", htmlentities_array($user_search), "&amp;page=$page&amp;filter=$filter\">{$lang['user']}</a></td>\n";
}else {
    echo "                   <td class=\"subhead\" align=\"left\" nowrap=\"nowrap\"><a href=\"admin_users.php?webtag=$webtag&amp;sort_by=LOGON&amp;sort_dir=DESC&amp;user_search=", htmlentities_array($user_search), "&amp;page=$page&amp;filter=$filter\">{$lang['user']}</a></td>\n";
}

if ($sort_by == 'LAST_VISIT' && $sort_dir == 'ASC') {
    echo "                   <td class=\"subhead_sort_asc\" align=\"left\"><a href=\"admin_users.php?webtag=$webtag&amp;sort_by=LAST_LOGON&amp;sort_dir=DESC&amp;user_search=", htmlentities_array($user_search), "&amp;page=$page&amp;filter=$filter\">{$lang['lastlogon']}</a></td>\n";
}elseif ($sort_by == 'LAST_VISIT' && $sort_dir == 'DESC') {
    echo "                   <td class=\"subhead_sort_desc\" align=\"left\"><a href=\"admin_users.php?webtag=$webtag&amp;sort_by=LAST_LOGON&amp;sort_dir=ASC&amp;user_search=", htmlentities_array($user_search), "&amp;page=$page&amp;filter=$filter\">{$lang['lastlogon']}</a></td>\n";
}elseif ($sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"left\"><a href=\"admin_users.php?webtag=$webtag&amp;sort_by=LAST_LOGON&amp;sort_dir=ASC&amp;user_search=", htmlentities_array($user_search), "&amp;page=$page&amp;filter=$filter\">{$lang['lastlogon']}</a></td>\n";
}else {
    echo "                   <td class=\"subhead\" align=\"left\"><a href=\"admin_users.php?webtag=$webtag&amp;sort_by=LAST_LOGON&amp;sort_dir=DESC&amp;user_search=", htmlentities_array($user_search), "&amp;page=$page&amp;filter=$filter\">{$lang['lastlogon']}</a></td>\n";
}

if ($sort_by == 'REGISTERED' && $sort_dir == 'ASC') {
    echo "                   <td class=\"subhead_sort_asc\" align=\"left\"><a href=\"admin_users.php?webtag=$webtag&amp;sort_by=REGISTERED&amp;sort_dir=DESC&amp;user_search=", htmlentities_array($user_search), "&amp;page=$page&amp;filter=$filter\">{$lang['registered']}</a></td>\n";
}elseif ($sort_by == 'REGISTERED' && $sort_dir == 'DESC') {
    echo "                   <td class=\"subhead_sort_desc\" align=\"left\"><a href=\"admin_users.php?webtag=$webtag&amp;sort_by=REGISTERED&amp;sort_dir=ASC&amp;user_search=", htmlentities_array($user_search), "&amp;page=$page&amp;filter=$filter\">{$lang['registered']}</a></td>\n";
}elseif ($sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"left\"><a href=\"admin_users.php?webtag=$webtag&amp;sort_by=REGISTERED&amp;sort_dir=ASC&amp;user_search=", htmlentities_array($user_search), "&amp;page=$page&amp;filter=$filter\">{$lang['registered']}</a></td>\n";
}else {
    echo "                   <td class=\"subhead\" align=\"left\"><a href=\"admin_users.php?webtag=$webtag&amp;sort_by=REGISTERED&amp;sort_dir=DESC&amp;user_search=", htmlentities_array($user_search), "&amp;page=$page&amp;filter=$filter\">{$lang['registered']}</a></td>\n";
}

if ($sort_by == 'ACTIVE' && $sort_dir == 'ASC') {
    echo "                   <td class=\"subhead_sort_asc\" align=\"left\"><a href=\"admin_users.php?webtag=$webtag&amp;sort_by=ACTIVE&amp;sort_dir=DESC&amp;user_search=", htmlentities_array($user_search), "&amp;page=$page&amp;filter=$filter\">{$lang['active']}</a></td>\n";
}elseif ($sort_by == 'ACTIVE' && $sort_dir == 'DESC') {
    echo "                   <td class=\"subhead_sort_desc\" align=\"left\"><a href=\"admin_users.php?webtag=$webtag&amp;sort_by=ACTIVE&amp;sort_dir=ASC&amp;user_search=", htmlentities_array($user_search), "&amp;page=$page&amp;filter=$filter\">{$lang['active']}</a></td>\n";
}elseif ($sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"left\"><a href=\"admin_users.php?webtag=$webtag&amp;sort_by=ACTIVE&amp;sort_dir=ASC&amp;user_search=", htmlentities_array($user_search), "&amp;page=$page&amp;filter=$filter\">{$lang['active']}</a></td>\n";
}else {
    echo "                   <td class=\"subhead\" align=\"left\"><a href=\"admin_users.php?webtag=$webtag&amp;sort_by=ACTIVE&amp;sort_dir=DESC&amp;user_search=", htmlentities_array($user_search), "&amp;page=$page&amp;filter=$filter\">{$lang['active']}</a></td>\n";
}

echo "                 </tr>\n";

if (sizeof($admin_user_array['user_array']) > 0) {

    foreach ($admin_user_array['user_array'] as $user) {

        echo "                 <tr>\n";
        echo "                   <td align=\"center\">", form_checkbox("user_update[{$user['UID']}]", "Y", ""), "</td>\n";
        echo "                   <td class=\"posthead\" align=\"left\" width=\"35%\" nowrap=\"nowrap\">&nbsp;<a href=\"admin_user.php?webtag=$webtag&amp;uid=", $user['UID'], "\">", word_filter_add_ob_tags(htmlentities_array(format_user_name($user['LOGON'], $user['NICKNAME']))), "</a></td>\n";

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
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "      <td class=\"postbody\" align=\"center\" width=\"50%\">", page_links("admin_users.php?webtag=$webtag&sort_by=$sort_by&sort_dir=$sort_dir&user_search=$user_search&filter=$filter", $start, $admin_user_array['user_count'], 10), "</td>\n";

if (forum_get_setting('require_user_approval', 'Y') && (bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0, 0))) {

    echo "      <td class=\"postbody\" align=\"right\" width=\"25%\" nowrap=\"nowrap\">{$lang['userfilter']}:&nbsp;", form_dropdown_array("filter", array(ADMIN_USER_FILTER_NONE => $lang['all'], ADMIN_USER_FILTER_ONLINE => $lang['onlineusers'], ADMIN_USER_FILTER_OFFLINE => $lang['offlineusers'], ADMIN_USER_FILTER_BANNED => $lang['bannedusers'], ADMIN_USER_FILTER_APPROVAL => $lang['usersawaitingapproval']), $filter), "&nbsp;", form_submit("change_filter", $lang['go']), "</td>\n";

}else {

    echo "      <td class=\"postbody\" align=\"right\" width=\"25%\" nowrap=\"nowrap\">{$lang['userfilter']}:&nbsp;", form_dropdown_array("filter", array(ADMIN_USER_FILTER_NONE => $lang['all'], ADMIN_USER_FILTER_ONLINE => $lang['onlineusers'], ADMIN_USER_FILTER_OFFLINE => $lang['offlineusers'], ADMIN_USER_FILTER_BANNED => $lang['bannedusers']), $filter), "&nbsp;", form_submit("change_filter", $lang['go']), "</td>\n";
}

echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "  </table>\n";

if (bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0, 0) && sizeof($admin_user_array['user_array']) > 0) {

    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"86%\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" align=\"left\">{$lang['options']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";

    if (forum_get_setting('require_user_approval', 'Y')) {

        echo "                        <td align=\"left\" valign=\"top\" nowrap=\"nowrap\">{$lang['withselected']}:&nbsp;</td>\n";
        echo "                        <td align=\"left\" valign=\"top\" nowrap=\"nowrap\" width=\"100%\">", form_dropdown_array("action", array(-1 => '&nbsp;', ADMIN_USER_OPTION_END_SESSION => $lang['endsession'], ADMIN_USER_OPTION_APPROVE => $lang['approve']), false, false, 'bhlogondropdown'), "&nbsp;", form_submit("select_action", $lang['go']), "</td>\n";

    }else {

        echo "                        <td align=\"left\" valign=\"top\" nowrap=\"nowrap\">{$lang['withselected']}:&nbsp;</td>\n";
        echo "                        <td align=\"left\" valign=\"top\" nowrap=\"nowrap\" width=\"100%\">", form_dropdown_array("action", array(-1 => '&nbsp;', ADMIN_USER_OPTION_END_SESSION => $lang['endsession']), false, false, 'bhlogondropdown'), "&nbsp;", form_submit("select_action", $lang['go']), "</td>\n";
    }

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
    echo "  <br />\n";
    echo "</form>\n";
}

echo "<form accept-charset=\"utf-8\" action=\"admin_users.php\" method=\"get\">\n";
echo "  ", form_input_hidden("webtag", htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden("sort_by", htmlentities_array($sort_by)), "\n";
echo "  ", form_input_hidden("sort_dir", htmlentities_array($sort_dir)), "\n";
echo "  ", form_input_hidden("filter", htmlentities_array($filter)), "\n";
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
echo "                        <td class=\"posthead\" align=\"left\">{$lang['username']}: ", form_input_text('user_search', htmlentities_array($user_search), 25, 64), " ", form_submit('search', $lang['search']), " ", form_submit('reset', $lang['clear']), "</td>\n";
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