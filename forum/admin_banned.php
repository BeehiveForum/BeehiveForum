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

/* $Id: admin_banned.php,v 1.25 2006-07-18 20:30:34 decoyduck Exp $ */

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

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=admin.php%3Fpage%3D$request_uri");
}

// Load language file

$lang = load_language_file();

html_draw_top();

if (!(bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0))) {
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
    
    if ($remove_ban_id = check_ban_data(BAN_TYPE_IP, $unban_ipaddress)) {
        
        $remove_ban_type = BAN_TYPE_IP;
        $remove_ban_data = $unban_ipaddress;
    }    
}

if (isset($_GET['ban_referer']) && strlen(trim(_stripslashes($_GET['ban_referer'])))) {

    $add_new_ban_type = BAN_TYPE_REF;
    $add_new_ban_data = trim(_stripslashes($_GET['ban_referer']));

}elseif (isset($_GET['unban_referer']) && strlen(trim(_stripslashes($_GET['unban_referer'])))) {

    $unban_referer = trim(_stripslashes($_GET['unban_referer']));

    if ($remove_ban_id = check_ban_data(BAN_TYPE_REF, $unban_referer)) {

        $remove_ban_type = BAN_TYPE_REF;
        $remove_ban_data = $unban_referer;
    }
}

if (isset($add_new_ban_type) && isset($add_new_ban_data)
   || isset($remove_ban_type) && isset($remove_ban_data) && isset($remove_ban_id)) {

    html_draw_top("openprofile.js");

    echo "<h1>{$lang['admin']} : ", (isset($forum_settings['forum_name']) ? $forum_settings['forum_name'] : 'A Beehive Forum'), " : {$lang['bancontrols']}</h1>\n";

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "<form name=\"admin_banned_form\" action=\"admin_banned.php\" method=\"post\">\n";
    echo "  ", form_input_hidden('webtag', $webtag), "\n";

    if (isset($ret)) {
        echo "  ", form_input_hidden("ret", $ret), "\n";
        echo "  ", form_input_hidden("back", "back"), "\n";
    }

    if (isset($add_new_ban_type) && isset($add_new_ban_data)) {

        echo "  ", form_input_hidden("newbantype", $add_new_ban_type), "\n";
        echo "  ", form_input_hidden("newbandata", $add_new_ban_data), "\n";

    }elseif (isset($remove_ban_type) && isset($remove_ban_data)) {

        echo "  ", form_input_hidden("delete_ban[$remove_ban_id]", "Y"), "\n";
    }

    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
    echo "    <tr>\n";
    echo "      <td>\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";

    if (isset($add_new_ban_type) && isset($add_new_ban_data)) {

        echo "                 <tr>\n";
        echo "                   <td class=\"subhead\">Add Ban Data</td>\n";
        echo "                 </tr>\n";

    }else {

        echo "                 <tr>\n";
        echo "                   <td class=\"subhead\">Remove Ban Data</td>\n";
        echo "                 </tr>\n";
    }

    echo "              </table>\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                 <tr>\n";
    echo "                   <td align=\"center\">\n";

    if (isset($add_new_ban_type) && isset($add_new_ban_data)) {

        echo "                     <table class=\"posthead\" width=\"95%\">\n";
        echo "                       <tr>\n";
        echo "                         <td>Please confirm that you want to add the following ban data to the database:</td>\n";
        echo "                       </tr>\n";
        echo "                       <tr>\n";
        echo "                         <td>&nbsp;</td>\n";
        echo "                       </tr>\n";

        if ($add_new_ban_type == BAN_TYPE_IP) {

            echo "                       <tr>\n";
            echo "                         <td><b>IP Address: $add_new_ban_data</b></td>\n";
            echo "                       </tr>\n";

        }elseif ($add_new_ban_type == BAN_TYPE_REF) {

            echo "                       <tr>\n";
            echo "                         <td><b>HTTP Referer: $add_new_ban_data</b></td>\n";
            echo "                       </tr>\n";
        }

        if ($affected_sessions_array = check_affected_sessions($add_new_ban_type, $add_new_ban_data)) {

            echo "                       <tr>\n";
            echo "                         <td>&nbsp;</td>\n";
            echo "                       </tr>\n";
            echo "                       <tr>\n";
            echo "                         <td>This ban may affect the following active user sessions:</td>\n";
            echo "                       </tr>\n";
            echo "                       <tr>\n";
            echo "                         <td>\n";
            echo "                           <ul>\n";

            foreach($affected_sessions_array as $affected_session) {

                if ($affected_session['UID'] > 0) {
                    echo "      <li><a href=\"javascript:void(0);\" onclick=\"openProfile({$affected_session['UID']}, '$webtag')\" target=\"_self\">", format_user_name($affected_session['LOGON'], $affected_session['NICKNAME']), "</a></li>\n";
                }else {
                    echo "      <li>", format_user_name($affected_session['LOGON'], $affected_session['NICKNAME']), "</li>\n";
                }
            }

            echo "                           </ul>\n";
            echo "                         </td>\n";
            echo "                       </tr>\n";
        }

    }else {

        echo "                     <table class=\"posthead\" width=\"95%\">\n";
        echo "                       <tr>\n";
        echo "                         <td>Please confirm that you want to remove the following ban data from the database:</td>\n";
        echo "                       </tr>\n";
        echo "                       <tr>\n";
        echo "                         <td>&nbsp;</td>\n";
        echo "                       </tr>\n";

        if ($remove_ban_type == BAN_TYPE_IP) {

            echo "                       <tr>\n";
            echo "                         <td><b>IP Address: $remove_ban_data</b></td>\n";
            echo "                       </tr>\n";

        }elseif ($remove_ban_type == BAN_TYPE_REF) {

            echo "                       <tr>\n";
            echo "                         <td><b>HTTP Referer: $remove_ban_data</b></td>\n";
            echo "                       </tr>\n";
        }

        if ($affected_sessions_array = check_affected_sessions($remove_ban_type, $remove_ban_data)) {

            echo "                       <tr>\n";
            echo "                         <td>&nbsp;</td>\n";
            echo "                       </tr>\n";
            echo "                       <tr>\n";
            echo "                         <td>This ban affects the following active user sessions:</td>\n";
            echo "                       </tr>\n";
            echo "                       <tr>\n";
            echo "                         <td>\n";
            echo "                           <ul>\n";

            foreach($affected_sessions_array as $affected_session) {

                if ($affected_session['UID'] > 0) {
                    echo "      <li><a href=\"javascript:void(0);\" onclick=\"openProfile({$affected_session['UID']}, '$webtag')\" target=\"_self\">", format_user_name($affected_session['LOGON'], $affected_session['NICKNAME']), "</a></li>\n";
                }else {
                    echo "      <li>", format_user_name($affected_session['LOGON'], $affected_session['NICKNAME']), "</li>\n";
                }
            }

            echo "                           </ul>\n";
            echo "                         </td>\n";
            echo "                       </tr>\n";
        }
    }

    echo "                       <tr>\n";
    echo "                         <td>&nbsp;</td>\n";
    echo "                       </tr>\n";
    echo "                     </table>\n";
    echo "                   </td>\n";
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

        if (isset($add_new_ban_type) && isset($add_new_ban_data)) {

            echo "    <tr>\n";
            echo "      <td colspan=\"2\" align=\"center\">", form_submit("add", $lang['add']), "&nbsp;", form_submit("back", $lang['cancel']), "</td>\n";
            echo "    </tr>\n";

        }else {

            echo "    <tr>\n";
            echo "      <td colspan=\"2\" align=\"center\">", form_submit("update", $lang['remove']), "&nbsp;", form_submit("back", $lang['cancel']), "</td>\n";
            echo "    </tr>\n";
        }

    }else {

        if (isset($add_new_ban_type) && isset($add_new_ban_data)) {

            echo "    <tr>\n";
            echo "      <td colspan=\"2\" align=\"center\">", form_submit("add", $lang['add']), "</td>\n";
            echo "    </tr>\n";

        }else {

            echo "    <tr>\n";
            echo "      <td colspan=\"2\" align=\"center\">", form_submit("update", $lang['remove']), "</td>\n";
            echo "    </tr>\n";
        }
    }

    echo "  </table>\n";
    echo "</form>\n";
    echo "</div>\n";

    html_draw_bottom();
    exit;
}

if (isset($_POST['add'])) {

    // New Ban entry

    if (isset($_POST['newbantype']) && is_numeric($_POST['newbantype'])) {
        $new_ban_type = $_POST['newbantype'];
    }

    if (isset($_POST['newbandata']) && strlen(trim(_stripslashes($_POST['newbandata']))) > 0) {
        $new_ban_data = trim(_stripslashes($_POST['newbandata']));
    }

    if (isset($_POST['newbancomment']) && strlen(trim(_stripslashes($_POST['newbancomment']))) > 0) {
        $comment = trim(_stripslashes($_POST['newbancomment']));
    }else {
        $comment = "";
    }

    if (isset($new_ban_data) && isset($new_ban_type)) {

        if ($new_ban_type > 0) {

            if (preg_match("/^%+$/", $new_ban_data) < 1) {

                if (!check_ban_data($new_ban_type, $new_ban_data)) {
        
                    add_ban_data($new_ban_type, $new_ban_data, $comment);

                }else {

                    $error_html.= "<h2>{$lang['ipaddressisalreadybanned']}</h2>\n";
                }

            }else {

                $error_html.= "<h2>{$lang['cannotusewildcardonown']}</h2>\n";
                $valid = false;
            }

        }else {

            $error_html.= "<h2>You must specify a ban type</h2>\n";
            $valid = false;
        }

    }else if (!isset($new_ban_type) && isset($new_ban_data)) {

        $error_html.= "<h2>You must specify a ban type</h2>\n";
        $valid = false;

    }else if (!isset($new_ban_data) && isset($new_ban_type) && $new_ban_type > 0) {

        $error_html.= "<h2>You must specify some ban data</h2>\n";
        $valid = false;
    }
}

if (isset($_POST['update'])) {

    // Delete existing ban entry

    if (isset($_POST['delete_ban']) && is_array($_POST['delete_ban'])) {

        foreach($_POST['delete_ban'] as $ban_id => $delete_ban) {

            if ($delete_ban == "Y") {
            
                if (!remove_ban_data_by_id($ban_id)) {

                    $valid = false;
                    $error_html.= "<h2>Failed to remove ban data with ID: $ban_id</h2>\n";
                }
            }
        }
    }

    // Modified ban entry

    if (isset($_POST['bantype']) && is_array($_POST['bantype'])) {

        foreach($_POST['bantype'] as $ban_id => $ban_type) {

            if (is_numeric($ban_type) && $ban_type > 0) {

                if (isset($_POST['bancomment'][$ban_id]) && strlen(trim(_stripslashes($_POST['bancomment'][$ban_id]))) > 0) {
                    $comment = trim(_stripslashes($_POST['bancomment'][$ban_id]));
                }else {
                    $comment = "";
                }
                
                if (isset($_POST['bandata'][$ban_id]) && strlen(trim(_stripslashes($_POST['bandata'][$ban_id]))) > 0) {

                    $ban_data = trim(_stripslashes($_POST['bandata'][$ban_id]));

                    if (preg_match("/^%+$/", $ban_data) < 1) {
                        
                        if (!check_ban_data($ban_type, $ban_data, $ban_id)) {

                            update_ban_data($ban_id, $ban_type, $ban_data, $comment);

                        }else {

                            $valid = false;
                            $error_html.= "<h2>{$lang['ipaddressisalreadybanned']}</h2>\n";
                        }

                    }else {

                        $error_html.= "<h2>{$lang['cannotusewildcardonown']}</h2>\n";
                        $valid = false;
                    }
                
                }else {

                    $error_html.= "<h2>You must specify some ban data</h2>\n";
                    $valid = false;
                }

            }else {

                $error_html.= "<h2>You must specify a ban type</h2>\n";
                $valid = false;
            }
        }
    }
}

// Return to the page we came from.

if (isset($_POST['back']) && isset($ret)) {
    header_redirect($ret);
}

echo "<h1>{$lang['admin']} : ", (isset($forum_settings['forum_name']) ? $forum_settings['forum_name'] : 'A Beehive Forum'), " : {$lang['bancontrols']}</h1>\n";

if (!$valid && strlen($error_html) > 0) echo $error_html;

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form name=\"admin_banned_form\" action=\"admin_banned.php\" method=\"post\">\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";

if (isset($ret)) {
    echo "  ", form_input_hidden("ret", $ret), "\n";
}

echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"75%\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                 <tr>\n";
echo "                   <td class=\"subhead\" align=\"left\" width=\"50\">&nbsp;</td>\n";


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

if ($sort_by == 'COMMENT' && $sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"left\" width=\"40%\">&nbsp;<a href=\"admin_banned.php?webtag=$webtag&amp;sort_by=COMMENT&amp;sort_dir=DESC&amp;page=$page\">Comment&nbsp;<img src=\"", style_image("sort_asc.png"), "\" border=\"0\" alt=\"{$lang['sortasc']}\" title=\"{$lang['sortasc']}\" /></a></td>\n";
}elseif ($sort_by == 'COMMENT' && $sort_dir == 'DESC') {
    echo "                   <td class=\"subhead\" align=\"left\" width=\"40%\">&nbsp;<a href=\"admin_banned.php?webtag=$webtag&amp;sort_by=COMMENT&amp;sort_dir=ASC&amp;page=$page\">Comment&nbsp;<img src=\"", style_image("sort_desc.png"), "\" border=\"0\" alt=\"{$lang['sortdesc']}\" title=\"{$lang['sortdesc']}\" /></a></td>\n";
}elseif ($sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"left\" width=\"40%\">&nbsp;<a href=\"admin_banned.php?webtag=$webtag&amp;sort_by=COMMENT&amp;sort_dir=ASC&amp;page=$page\">Comment</a></td>\n";
}else {
    echo "                   <td class=\"subhead\" align=\"left\" width=\"40%\">&nbsp;<a href=\"admin_banned.php?webtag=$webtag&amp;sort_by=COMMENT&amp;sort_dir=DESC&amp;page=$page\">Comment</a></td>\n";
}

echo "                   <td class=\"subhead\" align=\"left\" width=\"25\">&nbsp;{$lang['delete']}&nbsp;</td>\n";
echo "                 </tr>\n";

$start = floor($page - 1) * 10;
if ($start < 0) $start = 0;

$ban_list_array = admin_get_ban_data($sort_by, $sort_dir, $start);

if (sizeof($ban_list_array['ban_array']) > 0) {

    foreach($ban_list_array['ban_array'] as $ban_list_id => $ban_list_entry) {

        echo "                 <tr>\n";
        echo "                   <td>&nbsp;</td>\n";
        echo "                   <td>", form_dropdown_array("bantype[$ban_list_id]", range(1, 5), array('IP Address', 'Logon', 'Nickname', 'Email', 'HTTP Referer'), $ban_list_entry['BANTYPE']), "</td>\n";
        echo "                   <td>", form_input_text("bandata[$ban_list_id]", $ban_list_entry['BANDATA'], 30, 255), "</td>\n";
        echo "                   <td>", form_input_text("bancomment[$ban_list_id]", $ban_list_entry['COMMENT'], 50, 255), "</td>\n";
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
    echo "      <td colspan=\"2\" align=\"center\">", form_submit("update", $lang['update']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";

}else {

    echo "                 <tr>\n";
    echo "                   <td>&nbsp;</td>\n";
    echo "                   <td colspan=\"4\">No ban data exists</td>\n";
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
    echo "  </table>\n";
}

echo "  <br />\n";
echo "</form>\n";
echo "<form name=\"admin_banned_form\" action=\"admin_banned.php\" method=\"post\">\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"75%\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                 <tr>\n";
echo "                   <td class=\"subhead\" align=\"left\" width=\"50\">&nbsp;</td>\n";
echo "                   <td class=\"subhead\" align=\"left\" width=\"50\">Ban Type</td>\n";
echo "                   <td class=\"subhead\" align=\"left\" width=\"50\">Ban Data</td>\n";
echo "                   <td class=\"subhead\" align=\"left\" width=\"50\">Comment</td>\n";
echo "                   <td class=\"subhead\" align=\"left\" width=\"25\">&nbsp;</td>\n";
echo "                 </tr>\n";
echo "                 <tr>\n";
echo "                   <td>{$lang['newcaps']}</td>\n";
echo "                   <td>", form_dropdown_array('newbantype', range(0, 5), array('', 'IP Address', 'Logon', 'Nickname', 'Email', 'HTTP Referer')), "</td>\n";
echo "                   <td>", form_input_text('newbandata', '', 30, 255), "</td>\n";
echo "                   <td>", form_input_text('newbancomment', '', 50, 255), "</td>\n";
echo "                   <td>&nbsp;</td>\n";
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
    echo "      <td colspan=\"2\" align=\"center\">", form_submit("add", $lang['add']), "&nbsp;", form_submit("back", $lang['back']), "</td>\n";
    echo "    </tr>\n";

}else {

    echo "    <tr>\n";
    echo "      <td colspan=\"2\" align=\"center\">", form_submit("add", $lang['add']), "</td>\n";
    echo "    </tr>\n";
}

echo "  </table>\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"75%\">\n";
echo "    <tr>\n";
echo "      <td><p>{$lang['youcanusethepercentwildcard']}</p></td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "  </table>\n";
echo "</form>\n";
echo "</div>\n";

html_draw_bottom();

?>