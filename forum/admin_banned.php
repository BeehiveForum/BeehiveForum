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

/* $Id: admin_banned.php,v 1.30 2006-07-30 21:46:34 decoyduck Exp $ */

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
include_once(BH_INCLUDE_PATH. "attachments.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "edit.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "ip.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "poll.inc.php");
include_once(BH_INCLUDE_PATH. "post.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.

if (bh_session_check_user_ban()) {
    
    html_user_banned();
    exit;
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=admin.php%3Fpage%3D$request_uri");
}

// Load language file

$lang = load_language_file();

if (!(bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0))) {
    html_draw_top();
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;
}

// Column sorting stuff

if (isset($_GET['sort_by'])) {
    if ($_GET['sort_by'] == "BANTYPE") {
        $sort_by = "BANTYPE";
    } elseif ($_GET['sort_by'] == "BANDATA") {
        $sort_by = "BANDATA";
    } else {
        $sort_by = "ID";
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

$valid = true;
$error_html = "";

// Are we returning somewhere?

if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {
    $ret = "messages.php?webtag=$webtag&msg={$_GET['msg']}";
}elseif (isset($_POST['ret']) && strlen(trim(_stripslashes($_POST['ret']))) > 0) {
    $ret = basename(trim(_stripslashes($_POST['ret'])));
}elseif (isset($_GET['ret']) && strlen(trim(_stripslashes($_GET['ret']))) > 0) {
    $ret = basename(trim(_stripslashes($_GET['ret'])));
}

// Is there an URL query to process?

if (isset($_GET['ban_ipaddress']) && strlen(trim(_stripslashes($_GET['ban_ipaddress'])))) {

    $add_new_ban_type = BAN_TYPE_IP;
    $add_new_ban_data = trim(_stripslashes($_GET['ban_ipaddress']));

}elseif (isset($_GET['unban_ipaddress']) && strlen(trim(_stripslashes($_GET['unban_ipaddress'])))) {

    $unban_ipaddress = trim(_stripslashes($_GET['unban_ipaddress']));
    
    if (!$remove_ban_id = check_ban_data(BAN_TYPE_IP, $unban_ipaddress)) {
        unset($remove_ban_id);
    }
}

if (isset($_GET['ban_referer']) && strlen(trim(_stripslashes($_GET['ban_referer'])))) {

    $add_new_ban_type = BAN_TYPE_REF;
    $add_new_ban_data = trim(_stripslashes($_GET['ban_referer']));

}elseif (isset($_GET['unban_referer']) && strlen(trim(_stripslashes($_GET['unban_referer'])))) {

    $unban_referer = trim(_stripslashes($_GET['unban_referer']));

    if ($remove_ban_id = check_ban_data(BAN_TYPE_REF, $unban_referer)) {
        unset($remove_ban_id);
    }
}

if (isset($_POST['add'])) {

    $valid = true;

    if (isset($_POST['newbantype']) && is_numeric($_POST['newbantype'])) {

        $new_ban_type = $_POST['newbantype'];

        if ($new_ban_type < 1 || $new_ban_type > 5) {

            $error_html.= "<h2>{$lang['mustspecifybantype']}</h2>\n";
            $valid = false;
        }

    }else {

        $error_html.= "<h2>{$lang['mustspecifybantype']}</h2>\n";
        $valid = false;
    }

    if (isset($_POST['newbandata']) && strlen(trim(_stripslashes($_POST['newbandata']))) > 0) {

        $new_ban_data = trim(_stripslashes($_POST['newbandata']));

        if (preg_match("/^%+$/", $new_ban_data) > 0) {
        
            $error_html.= "<h2>{$lang['cannotusewildcardonown']}</h2>\n";
            $valid = false;
        }

    }else {

        $error_html.= "<h2>{$lang['mustspecifybandata']}</h2>\n";
        $valid = false;
    }

    if (isset($_POST['newbancomment']) && strlen(trim(_stripslashes($_POST['newbancomment']))) > 0) {
        $comment = trim(_stripslashes($_POST['newbancomment']));
    }else {
        $comment = "";
    }

    if ($valid) {

        if (!check_ban_data($new_ban_type, $new_ban_data)) {

            add_ban_data($new_ban_type, $new_ban_data, $comment);
            $error_html.= "<h2>{$lang['successfullyaddedban']}</h2>\n";
            unset($_POST['addban'], $_GET['ban_id'], $ban_id);

        }else {

            $error_html.= "<h2>{$lang['duplicatebandataentered']}</h2>\n";
            $valid = false;
        }
    }
}

if (isset($_POST['update'])) {

    // Modified ban entry

    $valid = true;

    if (isset($_POST['ban_id']) && is_numeric($_POST['ban_id'])) {

        $ban_id = $_POST['ban_id'];

        if (isset($_POST['bantype']) && is_numeric($_POST['bantype'])) {

            $ban_type = $_POST['bantype'];

            if ($ban_type < 1 || $ban_type > 5) {

                $error_html.= "<h2>{$lang['mustspecifybantype']}</h2>\n";
                $valid = false;
            }

        }else {

            $error_html.= "<h2>{$lang['mustspecifybantype']}</h2>\n";
            $valid = false;
        }

        if (isset($_POST['bandata']) && strlen(trim(_stripslashes($_POST['bandata']))) > 0) {

            $ban_data = trim(_stripslashes($_POST['bandata']));

            if (preg_match("/^%+$/", $ban_data) > 0) {

                $error_html.= "<h2>{$lang['cannotusewildcardonown']}</h2>\n";
                $valid = false;
            }

        }else {

            $error_html.= "<h2>{$lang['mustspecifybandata']}</h2>\n";
            $valid = false;
        }

        if (isset($_POST['bancomment']) && strlen(trim(_stripslashes($_POST['bancomment']))) > 0) {
            $comment = trim(_stripslashes($_POST['bancomment']));
        }else {
            $comment = "";
        }

        if ($valid) {

            if (!check_ban_data($ban_type, $ban_data)) {

                update_ban_data($ban_id, $ban_type, $ban_data, $comment);
                $error_html.= "<h2>{$lang['successfullyaddedban']}</h2>\n";
                unset($_POST['ban_id'], $_GET['ban_id'], $ban_id);

            }else {

                $error_html.= "<h2>{$lang['duplicatebandataentered']}</h2>\n";
                $valid = false;
            }
        }
    }
}

// Delete existing ban entry

if (isset($_POST['delete'])) {

    if (isset($_POST['delete_ban']) && is_array($_POST['delete_ban'])) {

        $error_html.= "<h2>{$lang['successfullyremovedselectedbans']}</h2>\n";
        
        foreach($_POST['delete_ban'] as $ban_id => $delete_ban) {

            if ($delete_ban == "Y") {
            
                if (!remove_ban_data_by_id($ban_id)) {

                    $valid = false;
                    $error_html.= "<h2>". sprintf($lang['failedtoremoveban'], $ban_id). "</h2>\n";
                }
            }
        }
    }
}

// Return to the page we came from.

if (isset($_POST['back']) && isset($ret)) {
    header_redirect($ret);
}

if (isset($_POST['cancel']) || isset($_POST['delete'])) {
    unset($_POST['addban'], $_POST['ban_id'], $_GET['ban_id'], $ban_id);
}

html_draw_top('openprofile.js');

if (isset($_POST['addban']) || (isset($add_new_ban_type) && isset($add_new_ban_data))) {

    echo "<h1>{$lang['admin']} : ", (isset($forum_settings['forum_name']) ? $forum_settings['forum_name'] : 'A Beehive Forum'), " : {$lang['bancontrols']}</h1>\n";

    if (isset($error_html) && strlen($error_html) > 0) echo $error_html;

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "<form name=\"admin_banned_form\" action=\"admin_banned.php\" method=\"post\">\n";
    echo "  ", form_input_hidden('webtag', $webtag), "\n";
    echo "  ", form_input_hidden('addban', ''), "\n";

    if (isset($ret)) {
        echo "  ", form_input_hidden("ret", $ret), "\n";
    }

    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"420\">\n";
    echo "    <tr>\n";
    echo "      <td>\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" colspan=\"2\">&nbsp;{$lang['addban']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td width=\"120\" class=\"posthead\">&nbsp;{$lang['bantype']}:</td>\n";
    echo "                  <td>", form_dropdown_array('newbantype', range(0, 5), array('', 'IP Address', 'Logon', 'Nickname', 'Email', 'HTTP Referer'), (isset($_POST['newbantype']) ? _htmlentities(_stripslashes($_POST['newbantype'])) : (isset($add_new_ban_type) ? _htmlentities($add_new_ban_type) : ''))), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td width=\"100\" class=\"posthead\">&nbsp;{$lang['bandata']}:</td>\n";
    echo "                  <td>", form_input_text('newbandata', (isset($_POST['newbandata']) ? _htmlentities(_stripslashes($_POST['newbandata'])) : (isset($add_new_ban_data) ? _htmlentities($add_new_ban_data) : '')), 40, 255), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td width=\"100\" class=\"posthead\" valign=\"top\">&nbsp;{$lang['bancomment']}:</td>\n";
    echo "                  <td>", form_textarea('newbancomment', (isset($_POST['newbancomment']) ? _htmlentities(_stripslashes($_POST['newbancomment'])) : ''), 5, 37), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td>&nbsp;</td>\n";
    echo "                  <td>&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "            </td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";

    if (isset($_POST['newbantype']) && is_numeric($_POST['newbantype'])) {
        $add_new_ban_type = $_POST['newbantype'];
    }

    if (isset($_POST['newbandata']) && strlen(trim(_stripslashes($_POST['newbandata']))) > 0) {
        $add_new_ban_data = $_POST['newbandata'];
    }

    if (isset($add_new_ban_type) && isset($add_new_ban_data)) {

        if ($affected_sessions_array = check_affected_sessions($add_new_ban_type, $add_new_ban_data)) {

            echo "        <br />\n";
            echo "        <table width=\"100%\">\n";
            echo "          <tr>\n";
            echo "            <td align=\"center\">\n";
            echo "              <table class=\"text_captcha_error\" width=\"100%\">\n";
            echo "                <tr>\n";
            echo "                  <td>{$lang['affectsessionwarnadd']}:</td>\n";
            echo "                </tr>\n";
            echo "                <tr>\n";
            echo "                  <td>\n";
            echo "                    <ul>\n";

            foreach($affected_sessions_array as $affected_session) {

                if ($affected_session['UID'] > 0) {
                    echo "                    <li><a href=\"javascript:void(0);\" onclick=\"openProfile({$affected_session['UID']}, '$webtag')\" target=\"_self\">", format_user_name($affected_session['LOGON'], $affected_session['NICKNAME']), "</a></li>\n";
                }else {
                    echo "                    <li>", format_user_name($affected_session['LOGON'], $affected_session['NICKNAME']), "</li>\n";
                }
            }

            echo "                    </ul>\n";
            echo "                  </td>\n";
            echo "                </tr>\n";
            echo "              </table>\n";
            echo "            </td>\n";
            echo "          </tr>\n";
            echo "        </table>\n";
        }
    }

    echo "      </td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td>&nbsp;</td>\n";
    echo "    </tr>\n";

    if (isset($ret)) {

        echo "    <tr>\n";
        echo "      <td colspan=\"2\" align=\"center\">", form_submit("add", $lang['add']), "&nbsp;", form_submit("back", $lang['back']), "</td>\n";
        echo "    </tr>\n";

    }else {

        echo "    <tr>\n";
        echo "      <td colspan=\"2\" align=\"center\">", form_submit("add", $lang['add']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</td>\n";
        echo "    </tr>\n";
    }

    echo "  </table>\n";

    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"420\">\n";
    echo "    <tr>\n";
    echo "      <td><p>{$lang['youcanusethepercentwildcard']}</p></td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "  </table>\n";
    echo "</form>\n";

}elseif (isset($_POST['ban_id']) || isset($_GET['ban_id']) || isset($remove_ban_id)) {

    if (isset($_POST['ban_id']) && is_numeric($_POST['ban_id'])) {

        $ban_id = $_POST['ban_id'];

    }elseif (isset($_GET['ban_id']) && is_numeric($_GET['ban_id'])) {

        $ban_id = $_GET['ban_id'];

    }elseif (isset($remove_ban_id) && is_numeric($remove_ban_id)) {

        $ban_id = $remove_ban_id;
    
    }else {

        echo "<h2>{$lang['invalidbanid']}</h2>\n";
        html_draw_bottom();
        exit;
    }

    if (!$ban_data_array = admin_get_ban($ban_id)) {

        echo "<h2>{$lang['invalidbanid']}</h2>\n";
        html_draw_bottom();
        exit;
    }

    echo "<h1>{$lang['admin']} : ", (isset($forum_settings['forum_name']) ? $forum_settings['forum_name'] : 'A Beehive Forum'), " : {$lang['bancontrols']}</h1>\n";

    if (isset($error_html) && strlen($error_html) > 0) echo $error_html;

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "<form name=\"admin_banned_form\" action=\"admin_banned.php\" method=\"post\">\n";
    echo "  ", form_input_hidden('webtag', $webtag), "\n";
    echo "  ", form_input_hidden('ban_id', $ban_id), "\n";
    echo "  ", form_input_hidden("delete_ban[$ban_id]", "Y"), "\n";

    if (isset($ret)) {
        echo "  ", form_input_hidden("ret", $ret), "\n";
    }

    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"420\">\n";
    echo "    <tr>\n";
    echo "      <td>\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" colspan=\"2\">&nbsp;{$lang['editban']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td width=\"120\" class=\"posthead\">&nbsp;{$lang['bantype']}:</td>\n";
    echo "                  <td>", form_dropdown_array('bantype', range(1, 5), array('IP Address', 'Logon', 'Nickname', 'Email', 'HTTP Referer'), (isset($_POST['newbantype']) ? _htmlentities(_stripslashes($_POST['bantype'])) : $ban_data_array['BANTYPE'])), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td width=\"100\" class=\"posthead\">&nbsp;{$lang['bandata']}:</td>\n";
    echo "                  <td>", form_input_text('bandata', (isset($_POST['newbandata']) ? _htmlentities(_stripslashes($_POST['bandata'])) : $ban_data_array['BANDATA']), 40, 255), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td width=\"100\" class=\"posthead\" valign=\"top\">&nbsp;{$lang['bancomment']}:</td>\n";
    echo "                  <td>", form_textarea('bancomment', (isset($_POST['newbancomment']) ? _htmlentities(_stripslashes($_POST['bancomment'])) : $ban_data_array['COMMENT']), 5, 37), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td>&nbsp;</td>\n";
    echo "                  <td>&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "            </td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";

    if ($affected_sessions_array = check_affected_sessions($ban_data_array['BANTYPE'], $ban_data_array['BANDATA'])) {

        echo "        <br />\n";
        echo "        <table width=\"100%\">\n";
        echo "          <tr>\n";
        echo "            <td align=\"center\">\n";
        echo "              <table class=\"text_captcha_error\" width=\"100%\">\n";
        echo "                <tr>\n";
        echo "                  <td>{$lang['affectsessionwarnremove']}:</td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td>\n";
        echo "                    <ul>\n";

        foreach($affected_sessions_array as $affected_session) {

            if ($affected_session['UID'] > 0) {
                echo "                    <li><a href=\"javascript:void(0);\" onclick=\"openProfile({$affected_session['UID']}, '$webtag')\" target=\"_self\">", format_user_name($affected_session['LOGON'], $affected_session['NICKNAME']), "</a></li>\n";
            }else {
                echo "                    <li>", format_user_name($affected_session['LOGON'], $affected_session['NICKNAME']), "</li>\n";
            }
        }

        echo "                    </ul>\n";
        echo "                  </td>\n";
        echo "                </tr>\n";
        echo "              </table>\n";
        echo "            </td>\n";
        echo "          </tr>\n";
        echo "        </table>\n";
    }

    echo "      </td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td>&nbsp;</td>\n";
    echo "    </tr>\n";

    if (isset($ret)) {

        echo "    <tr>\n";
        echo "      <td colspan=\"2\" align=\"center\">", form_submit("update", $lang['save']), "&nbsp;", form_submit("delete", $lang['delete']), "&nbsp;", form_submit("back", $lang['back']), "</td>\n";
        echo "    </tr>\n";

    }else {

        echo "    <tr>\n";
        echo "      <td colspan=\"2\" align=\"center\">", form_submit("update", $lang['save']), "&nbsp;", form_submit("delete", $lang['delete']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</td>\n";
        echo "    </tr>\n";
    }

    echo "  </table>\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"420\">\n";
    echo "    <tr>\n";
    echo "      <td><p>{$lang['youcanusethepercentwildcard']}</p></td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "  </table>\n";
    echo "</form>\n";

}else {

    echo "<h1>{$lang['admin']} : ", (isset($forum_settings['forum_name']) ? $forum_settings['forum_name'] : 'A Beehive Forum'), " : {$lang['bancontrols']}</h1>\n";

    if (!$valid && strlen($error_html) > 0) echo $error_html;

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "<form name=\"admin_banned_form\" action=\"admin_banned.php\" method=\"post\">\n";
    echo "  ", form_input_hidden('webtag', $webtag), "\n";

    if (isset($ret)) {
        echo "  ", form_input_hidden("ret", $ret), "\n";
    }

    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
    echo "    <tr>\n";
    echo "      <td>\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                 <tr>\n";


    if ($sort_by == 'BANTYPE' && $sort_dir == 'ASC') {
        echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_banned.php?webtag=$webtag&amp;sort_by=BANTYPE&amp;sort_dir=DESC&amp;page=$page\">Ban Type&nbsp;<img src=\"", style_image("sort_asc.png"), "\" border=\"0\" alt=\"{$lang['sortasc']}\" title=\"{$lang['sortasc']}\" /></a></td>\n";
    }elseif ($sort_by == 'BANTYPE' && $sort_dir == 'DESC') {
        echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_banned.php?webtag=$webtag&amp;sort_by=BANTYPE&amp;sort_dir=ASC&amp;page=$page\">Ban Type&nbsp;<img src=\"", style_image("sort_desc.png"), "\" border=\"0\" alt=\"{$lang['sortdesc']}\" title=\"{$lang['sortdesc']}\" /></a></td>\n";
    }elseif ($sort_dir == 'ASC') {
        echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_banned.php?webtag=$webtag&amp;sort_by=BANTYPE&amp;sort_dir=ASC&amp;page=$page\">Ban Type</a></td>\n";
    }else {
        echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_banned.php?webtag=$webtag&amp;sort_by=BANTYPE&amp;sort_dir=DESC&amp;page=$page\">Ban Type</a></td>\n";
    }

    if ($sort_by == 'BANDATA' && $sort_dir == 'ASC') {
        echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_banned.php?webtag=$webtag&amp;sort_by=BANDATA&amp;sort_dir=DESC&amp;page=$page\">Ban Data&nbsp;<img src=\"", style_image("sort_asc.png"), "\" border=\"0\" alt=\"{$lang['sortasc']}\" title=\"{$lang['sortasc']}\" /></a></td>\n";
    }elseif ($sort_by == 'BANDATA' && $sort_dir == 'DESC') {
        echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_banned.php?webtag=$webtag&amp;sort_by=BANDATA&amp;sort_dir=ASC&amp;page=$page\">Ban Data&nbsp;<img src=\"", style_image("sort_desc.png"), "\" border=\"0\" alt=\"{$lang['sortdesc']}\" title=\"{$lang['sortdesc']}\" /></a></td>\n";
    }elseif ($sort_dir == 'ASC') {
        echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_banned.php?webtag=$webtag&amp;sort_by=BANDATA&amp;sort_dir=ASC&amp;page=$page\">Ban Data</a></td>\n";
    }else {
        echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_banned.php?webtag=$webtag&amp;sort_by=BANDATA&amp;sort_dir=DESC&amp;page=$page\">Ban Data</a></td>\n";
    }

    echo "                   <td class=\"subhead\" align=\"left\" width=\"25\">&nbsp;&nbsp;</td>\n";
    echo "                 </tr>\n";

    $start = floor($page - 1) * 10;
    if ($start < 0) $start = 0;

    $ban_list_array = admin_get_ban_data($sort_by, $sort_dir, $start);

    $ban_types_array = array('1' => 'IP Address', '2' => 'Logon', 
                             '3' => 'Nickname',   '4' => 'Email',
                             '5' => 'HTTP Referer'); 

    if (sizeof($ban_list_array['ban_array']) > 0) {

        foreach($ban_list_array['ban_array'] as $ban_list_id => $ban_list_entry) {

            echo "                 <tr>\n";
            echo "                   <td>&nbsp;<a href=\"admin_banned.php?ban_id=$ban_list_id\">", (in_array($ban_list_entry['BANTYPE'], array_keys($ban_types_array)) ? $ban_types_array[$ban_list_entry['BANTYPE']] : $lang['unknown']), "</a></td>\n";
            echo "                   <td>&nbsp;{$ban_list_entry['BANDATA']}</td>\n";
            echo "                   <td align=\"center\">", form_checkbox("delete_ban[$ban_list_id]", "Y", false), "</td>\n";
            echo "                 </tr>\n";
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
        echo "      <td class=\"postbody\" align=\"center\">", page_links(get_request_uri(false), $start, $ban_list_array['ban_count'], 10), "</td>\n";
        echo "    </tr>\n";
        echo "    <tr>\n";
        echo "      <td>&nbsp;</td>\n";
        echo "    </tr>\n";
        echo "    <tr>\n";
        echo "      <td colspan=\"2\" align=\"center\">", form_submit("addban", $lang['addban']), "&nbsp;", form_submit("delete", $lang['deleteselectbans']), "</td>\n";
        echo "    </tr>\n";
        echo "  </table>\n";

    }else {

        echo "                 <tr>\n";
        echo "                   <td colspan=\"5\">&nbsp;{$lang['noexistingbandata']}</td>\n";
        echo "                 </tr>\n";
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

        if (isset($ret)) {

            echo "    <tr>\n";
            echo "      <td colspan=\"2\" align=\"center\">", form_submit("addban", $lang['addban']), "&nbsp;", form_submit("delete", $lang['deleteselectbans']), "&nbsp;", form_submit("back", $lang['back']), "</td>\n";
            echo "    </tr>\n";

        }else {

            echo "    <tr>\n";
            echo "      <td colspan=\"2\" align=\"center\">", form_submit("addban", $lang['addban']), "&nbsp;", form_submit("delete", $lang['deleteselectbans']), "</td>\n";
            echo "    </tr>\n";
        }

        echo "  </table>\n";
    }

    echo "  <br />\n";
    echo "</form>\n";
    echo "</div>\n";

}

html_draw_bottom();

?>