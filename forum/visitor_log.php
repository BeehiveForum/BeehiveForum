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

/* $Id: visitor_log.php,v 1.87 2007-04-18 23:20:27 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

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

// Fetch the forum settings
$forum_settings = forum_get_settings();

include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

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

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Get a list of available user_prefs and profile items for the user to browse.

profile_items_get_list($profile_header_array, $profile_dropdown_array);

$profile_items_selected_array = array();

if (isset($_POST['profile_selection'])) {

    if (strlen(trim(_stripslashes($_POST['profile_selection']))) > 0) {

        $profile_selection = explode(",", $_POST['profile_selection']);

        foreach($profile_selection as $profile_item_key) {

            if (isset($profile_header_array[$profile_item_key])) {

                $profile_items_selected_array[$profile_item_key] = $profile_header_array[$profile_item_key];
            }
        }
    }

}else if (isset($_GET['profile_selection'])) {

    if (strlen(trim(_stripslashes($_GET['profile_selection']))) > 0) {

        $profile_selection = explode(",", $_GET['profile_selection']);

        foreach($profile_selection as $profile_item_key) {

            if (isset($profile_header_array[$profile_item_key])) {

                $profile_items_selected_array[$profile_item_key] = $profile_header_array[$profile_item_key];
            }
        }
    }

}else {

    $profile_items_selected_array = array('LAST_VISIT' => $profile_header_array['LAST_VISIT']);
}

if (isset($_POST['add'])) {

    if (isset($_POST['add_column']) && in_array($_POST['add_column'], array_keys($profile_header_array))) {
    
        $add_column = $_POST['add_column'];
        
        if (!in_array($add_column, array_keys($profile_items_selected_array))) {

            if (sizeof($profile_items_selected_array) < 3) {

                $profile_items_selected_array[$add_column] = $profile_header_array[$add_column];
            }
        }
    }

}elseif (isset($_POST['remove_column']) && is_array($_POST['remove_column'])) {
    
    list($remove_column) = array_keys($_POST['remove_column']);

    if (in_array($remove_column, array_keys($profile_items_selected_array))) {
        unset($profile_items_selected_array[$remove_column]);
    }
}

if (sizeof($profile_items_selected_array) > 0) {

    $profile_items_selected_string = implode(',', array_keys($profile_items_selected_array));
    $profile_items_selected_encoded_string = urlencode($profile_items_selected_string);

}else {

    $profile_items_selected_string = "";
    $profile_items_selected_encoded_string = "";
}

// Permitted columns to sort the results by

$sort_by_array = array_keys($profile_header_array);
array_unshift($sort_by_array, 'LOGON');

// Permitted sort directions.

$sort_dir_array = array('ASC', 'DESC'); 

// Sort column

if (isset($_GET['sort_by']) && in_array($_GET['sort_by'], $sort_by_array)) {

    $sort_by = $_GET['sort_by'];

}elseif (isset($_POST['sort_by']) && in_array($_POST['sort_by'], $sort_by_array)) {

    $sort_by = $_POST['sort_by'];

}elseif (sizeof($profile_items_selected_array) > 0) {
    
    list($sort_by) = array_keys($profile_items_selected_array);

}else {

    $sort_by = 'LAST_VISIT';
}

if (isset($_POST['hide_empty']) && $_POST['hide_empty'] == 'Y') {
    $hide_empty = 'Y';
}elseif (isset($_GET['hide_empty']) && $_GET['hide_empty'] == 'Y') {
    $hide_empty = 'Y';
}else {
    $hide_empty = 'N';
}

// Sort direction

if (isset($_GET['sort_dir']) && in_array($_GET['sort_dir'], $sort_dir_array)) {
    $sort_dir = $_GET['sort_dir'];
}elseif (isset($_POST['sort_dir']) && in_array($_POST['sort_dir'], $sort_dir_array)) {
    $sort_dir = $_POST['sort_dir'];
}else {
    $sort_dir = 'DESC';
}

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = ($_GET['page'] > 0) ? $_GET['page'] : 1;
}else if (isset($_POST['page']) && is_numeric($_POST['page'])) {
    $page = ($_POST['page'] > 0) ? $_POST['page'] : 1;
}else {
    $page = 1;
}

$start = floor($page - 1) * 10;
if ($start < 0) $start = 0;

if (isset($_POST['usersearch']) && strlen(trim(_stripslashes($_POST['usersearch']))) > 0) {
    $usersearch = $_POST['usersearch'];
}elseif (isset($_GET['usersearch']) && strlen(trim(_stripslashes($_GET['usersearch']))) > 0) {
    $usersearch = $_GET['usersearch'];
}else {
    $usersearch = "";
}

if (isset($_GET['reset'])) {
    $usersearch = "";
}

html_draw_top("robots=noindex,nofollow", "openprofile.js");

echo "<h1>{$lang['userprofile']}</h1><br />\n";

$user_profile_array = profile_browse_items($usersearch, $profile_items_selected_array, $start, $sort_by, $sort_dir, $hide_empty == 'Y');

echo "<div align=\"center\">\n";
echo "<form name=\"f_profile\" action=\"visitor_log.php\" method=\"post\">\n";
echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
echo "  ", form_input_hidden('page', _htmlentities($page)), "\n";
echo "  ", form_input_hidden('sort_by', _htmlentities($sort_by)), "\n";
echo "  ", form_input_hidden('sort_dir', _htmlentities($sort_dir)), "\n";
echo "  ", form_input_hidden('usersearch', _htmlentities($usersearch)), "\n";
echo "  ", form_input_hidden('profile_selection', _htmlentities($profile_items_selected_string)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"85%\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "               <table width=\"100%\">\n";

if (sizeof($user_profile_array['user_array']) > 0) {

    echo "                 <tr>\n";

    if ($sort_by == 'LOGON' && $sort_dir == 'ASC') {
        echo "                   <td class=\"subhead_sort_asc\" align=\"left\"><a href=\"visitor_log.php?webtag=$webtag&amp;sort_by=LOGON&amp;sort_dir=DESC&amp;page=$page&amp;profile_selection=$profile_items_selected_encoded_string&amp;usersearch=$usersearch&amp;hide_empty=$hide_empty\">{$lang['member']}</a></td>\n";
    }elseif ($sort_by == 'LOGON' && $sort_dir == 'DESC') {
        echo "                   <td class=\"subhead_sort_desc\" align=\"left\"><a href=\"visitor_log.php?webtag=$webtag&amp;sort_by=LOGON&amp;sort_dir=ASC&amp;page=$page&amp;profile_selection=$profile_items_selected_encoded_string&amp;usersearch=$usersearch&amp;hide_empty=$hide_empty\">{$lang['member']}</a></td>\n";
    }elseif ($sort_dir == 'ASC') {
        echo "                   <td class=\"subhead\" align=\"left\"><a href=\"visitor_log.php?webtag=$webtag&amp;sort_by=LOGON&amp;sort_dir=ASC&amp;page=$page&amp;profile_selection=$profile_items_selected_encoded_string&amp;usersearch=$usersearch&amp;hide_empty=$hide_empty\">{$lang['member']}</a></td>\n";
    }else {
        echo "                   <td class=\"subhead\" align=\"left\"><a href=\"visitor_log.php?webtag=$webtag&amp;sort_by=LOGON&amp;sort_dir=DESC&amp;page=$page&amp;profile_selection=$profile_items_selected_encoded_string&amp;usersearch=$usersearch&amp;hide_empty=$hide_empty\">{$lang['member']}</a></td>\n";
    }

    foreach ($profile_items_selected_array as $key => $profile_item_selected) {

        if ($sort_by == $key && $sort_dir == 'ASC') {
            echo "                   <td class=\"subhead_sort_asc\" align=\"left\">", form_submit_image('close.png', "remove_column[$key]", $lang['close'], "title=\"{$lang['close']}\"", "profile_browse_close"), "&nbsp;<a href=\"visitor_log.php?webtag=$webtag&amp;sort_by=$key&amp;sort_dir=DESC&amp;page=$page&amp;profile_selection=$profile_items_selected_encoded_string&amp;usersearch=$usersearch&amp;hide_empty=$hide_empty\">{$profile_item_selected}</a></td>\n";
        }elseif ($sort_by == $key && $sort_dir == 'DESC') {
            echo "                   <td class=\"subhead_sort_desc\" align=\"left\">", form_submit_image('close.png', "remove_column[$key]", $lang['close'], "title=\"{$lang['close']}\"", "profile_browse_close"), "&nbsp;<a href=\"visitor_log.php?webtag=$webtag&amp;sort_by=$key&amp;sort_dir=ASC&amp;page=$page&amp;profile_selection=$profile_items_selected_encoded_string&amp;usersearch=$usersearch&amp;hide_empty=$hide_empty\">{$profile_item_selected}</a></td>\n";
        }elseif ($sort_dir == 'ASC') {
            echo "                   <td class=\"subhead\" align=\"left\">", form_submit_image('close.png', "remove_column[$key]", $lang['close'], "title=\"{$lang['close']}\"", "profile_browse_close"), "&nbsp;<a href=\"visitor_log.php?webtag=$webtag&amp;sort_by=$key&amp;sort_dir=ASC&amp;page=$page&amp;profile_selection=$profile_items_selected_encoded_string&amp;usersearch=$usersearch&amp;hide_empty=$hide_empty\">{$profile_item_selected}</a></td>\n";
        }else {
            echo "                   <td class=\"subhead\" align=\"left\">", form_submit_image('close.png', "remove_column[$key]", $lang['close'], "title=\"{$lang['close']}\"", "profile_browse_close"), "&nbsp;<a href=\"visitor_log.php?webtag=$webtag&amp;sort_by=$key&amp;sort_dir=DESC&amp;page=$page&amp;profile_selection=$profile_items_selected_encoded_string&amp;usersearch=$usersearch&amp;hide_empty=$hide_empty\">{$profile_item_selected}</a></td>\n";
        }
    }

    echo "                 </tr>\n";

    foreach ($user_profile_array['user_array'] as $user_array) {
        
        echo "                 <tr>\n";

        if (isset($user_array['SID']) && !is_null($user_array['SID'])) {

            echo "                   <td class=\"postbody\" align=\"left\"><a href=\"{$user_array['URL']}\" target=\"_blank\">{$user_array['NAME']}</a></td>\n";

        }elseif ($user_array['UID'] > 0) {

            echo "                   <td class=\"postbody\" align=\"left\"><a href=\"user_profile.php?webtag=$webtag&amp;uid={$user_array['UID']}\" target=\"_blank\" onclick=\"return openProfile({$user_array['UID']}, '$webtag')\">", word_filter_add_ob_tags(format_user_name($user_array['LOGON'], $user_array['NICKNAME'])), "</a></td>\n";

        }else {

            echo "                   <td class=\"postbody\" align=\"left\">", word_filter_add_ob_tags(format_user_name($user_array['LOGON'], $user_array['NICKNAME'])), "</td>\n";
        }

        foreach ($profile_items_selected_array as $key => $profile_item_selected) {
            
            if (is_numeric($key)) {
            
                if (isset($user_array["ENTRY_$key"])) {

                    echo "                   <td class=\"postbody\" align=\"right\" width=\"200\">", $user_array["ENTRY_$key"], "&nbsp;</td>\n";
                
                }else {

                    echo "                   <td class=\"postbody\" align=\"right\" width=\"200\">{$lang['unknown']}&nbsp;</td>\n";
                }
        
            }elseif (isset($profile_header_array[$key]) && isset($user_array[$key])) {

                echo "                   <td class=\"postbody\" align=\"right\" width=\"200\">{$user_array[$key]}&nbsp;</td>\n";
            
            }else {

                echo "                   <td class=\"postbody\" align=\"right\" width=\"200\">{$lang['unknown']}&nbsp;</td>\n";
            }
        }

        echo "                 </tr>\n";
    }

    echo "                 <tr>\n";
    echo "                   <td align=\"left\" class=\"postbody\">&nbsp;</td>\n";
    echo "                 </tr>\n";

}else {

    echo "                 <tr>\n";
    echo "                   <td class=\"subhead\" align=\"left\">{$lang['search']}</td>\n";
    echo "                 </tr>\n";

    if (isset($usersearch) && strlen($usersearch) > 0) {

        echo "                 <tr>\n";
        echo "                   <td class=\"postbody\" align=\"left\">{$lang['yoursearchdidnotreturnanymatches']}</td>\n";
        echo "                 </tr>\n";

    }else {

        echo "                 <tr>\n";
        echo "                   <td class=\"postbody\" align=\"left\">{$lang['nouseraccounts']}</td>\n";
        echo "                 </tr>\n";
    }

    echo "                 <tr>\n";
    echo "                   <td align=\"left\" class=\"postbody\">&nbsp;</td>\n";
    echo "                 </tr>\n";
}

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
echo "      <td align=\"left\">\n";
echo "        <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" width=\"40%\">&nbsp;</td>\n";
echo "            <td align=\"center\" nowrap=\"nowrap\" width=\"20%\">", page_links("visitor_log.php?webtag=$webtag&page=$page&profile_selection=$profile_items_selected_encoded_string&usersearch=$usersearch&sort_by=$sort_by&sort_dir=$sort_dir&hide_empty=$hide_empty", $start, $user_profile_array['user_count'], 10), "</td>\n";
echo "            <td align=\"right\" nowrap=\"nowrap\" width=\"40%\">", form_dropdown_array('add_column', $profile_dropdown_array), "&nbsp;", form_submit('add', $lang['add']), "</td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"85%\">\n";
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
echo "                        <td align=\"left\" colspan=\"2\">", form_checkbox("hide_empty", "Y", "Hide rows with empty or null values in selected columns", $hide_empty == 'Y'), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"center\">", form_submit("save", $lang['save']), "</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"85%\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" align=\"left\">{$lang['searchforusernotinlist']}:</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td class=\"posthead\" align=\"left\">{$lang['username']}: ", form_input_text('usersearch', _htmlentities($usersearch), 30, 64), " ", form_submit('submit', $lang['search']), " ", form_submit('reset', $lang['clear']), "</td>\n";
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