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

/* $Id: search_popup.php,v 1.11 2007-04-18 23:20:27 decoyduck Exp $ */

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

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "htmltools.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "thread.inc.php");
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

if (bh_session_get_value('UID') == 0) {
    html_guest_error();
    exit;
}

if (isset($_POST['close'])) {

    echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
    echo "  window.close();\n";
    echo "</script>\n";

    html_draw_bottom();
    exit;
}

if (isset($_GET['type']) && is_numeric($_GET['type'])) {

    if ($_GET['type'] == SEARCH_POPUP_TYPE_USER) {
        
        $type = SEARCH_POPUP_TYPE_USER;
    
    }elseif ($_GET['type'] == SEARCH_POPUP_TYPE_THREAD) {

        $type = SEARCH_POPUP_TYPE_THREAD;
    
    }else {

        html_draw_top();
        html_error_msg($lang['unkownsearchtypespecified'], 'search_popup.php', $lang['close']);
        html_draw_bottom();
        exit;
    }

}elseif (isset($_POST['type']) && is_numeric($_POST['type'])) {

    if ($_POST['type'] == SEARCH_POPUP_TYPE_USER) {

        $type = SEARCH_POPUP_TYPE_USER;

    }elseif ($_POST['type'] == SEARCH_POPUP_TYPE_THREAD) {

        $type = SEARCH_POPUP_TYPE_THREAD;
    
    }else {

        html_draw_top();
        html_error_msg($lang['unkownsearchtypespecified'], 'search_popup.php', $lang['close']);
        html_draw_bottom();
        exit;
    }

}else {

    html_draw_top();
    html_error_msg($lang['mustspecifytypeofsearch'], 'search_popup.php', $lang['close']);
    html_draw_bottom();
    exit;
}

// Form Object ID

if (isset($_POST['obj_name']) && strlen(trim(_stripslashes($_POST['obj_name']))) > 0) {

    $obj_name = trim(_stripslashes($_POST['obj_name']));

}elseif (isset($_GET['obj_name']) && strlen(trim(_stripslashes($_GET['obj_name']))) > 0) {

    $obj_name = trim(_stripslashes($_GET['obj_name']));

}else {

    html_draw_top();
    html_error_msg($lang['noformobj'], 'search_popup.php', $lang['close']);
    html_draw_bottom();
    exit;
}

if (isset($_POST['allow_multi'])) {
    $allow_multi = true;
}elseif (isset($_GET['allow_multi'])) {
    $allow_multi = true;
}else {
    $allow_multi = false;
}


if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = ($_GET['page'] > 0) ? $_GET['page'] : 1;
}else {
    $page = 1;
}

$start = floor($page - 1) * 10;
if ($start < 0) $start = 0;

if (isset($_POST['select_result'])) {

    if (isset($_POST['search_result'])) {

        $search_result = $_POST['search_result'];

        html_draw_top();

        echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
        echo "  if (window.opener.returnSearchResult) {\n";

        if (is_array($search_result)) {

            foreach($search_result as $search_result_part) {

                $search_result_part = trim(_stripslashes($search_result_part));
                echo "    window.opener.returnSearchResult('$obj_name', '$search_result_part');\n";
            }

        }else {

            $search_result = trim(_stripslashes($search_result));
            echo "    window.opener.returnSearchResult('$obj_name', '$search_result');\n";
        }

        echo "  }\n";
        echo "  window.close();\n";
        echo "</script>\n";

        html_draw_bottom();
        exit;
    }
}

if (isset($_GET['search_query']) && strlen(trim(_stripslashes($_GET['search_query']))) > 0) {
    $search_query = trim(_stripslashes($_GET['search_query']));
}elseif (isset($_POST['search_query']) && strlen(trim(_stripslashes($_POST['search_query']))) > 0) {
    $search_query = trim(_stripslashes($_POST['search_query']));
}else {
    $search_query = "";
}

html_draw_top('openprofile.js');

echo "<h1>{$lang['search']}</h1>\n";
echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form action=\"search_popup.php\" method=\"post\">\n";
echo "  ", form_input_hidden("webtag", _htmlentities($webtag)), "\n";
echo "  ", form_input_hidden("type", _htmlentities($type)), "\n";
echo "  ", form_input_hidden("obj_name", _htmlentities($obj_name)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"475\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";

if ($type == SEARCH_POPUP_TYPE_USER) {

    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" align=\"left\">{$lang['searchforuser']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"100\">{$lang['username']}:</td>\n";

}elseif ($type == SEARCH_POPUP_TYPE_THREAD) {

    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" align=\"left\">{$lang['searchforthread']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"100\">{$lang['threadtitle']}:</td>\n";
}

echo "                        <td class=\"posthead\" align=\"left\">", form_input_text('search_query', _htmlentities($search_query), 45, 64), "</td>\n";
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

if (strlen(trim($search_query)) > 0) {

    if ($type == SEARCH_POPUP_TYPE_USER) {

        $search_results_array = user_search($search_query, $start);
    
    }elseif ($type == SEARCH_POPUP_TYPE_THREAD) {

        $search_results_array = thread_search($search_query, $start);
    }

    if (sizeof($search_results_array['results_array']) > 0) {

        echo "  <br />\n";
        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"475\">\n";
        echo "    <tr>\n";
        echo "      <td align=\"left\">\n";
        echo "        <table class=\"box\" width=\"100%\">\n";
        echo "          <tr>\n";
        echo "            <td align=\"left\" class=\"posthead\">\n";
        echo "              <table class=\"posthead\" width=\"100%\">\n";
        echo "                <tr>\n";
        echo "                  <td class=\"subhead\" align=\"left\">{$lang['results']}</td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td align=\"center\">\n";
        echo "                    <div class=\"search_popup_results\">\n";
        echo "                      <table width=\"95%\">\n";

        foreach ($search_results_array['results_array'] as $search_result) {

            if ($type == SEARCH_POPUP_TYPE_USER) {

                if (($search_results_array['results_count'] > 1) && $allow_multi === false) {

                    echo "                      <tr>\n";
                    echo "                        <td align=\"left\">", form_radio("search_result[]", $search_result['LOGON'], ''), "&nbsp;<a href=\"user_profile.php?webtag=$webtag&amp;uid={$search_result['UID']}\" target=\"_blank\" onclick=\"return openProfile({$search_result['UID']}, '$webtag')\">", word_filter_add_ob_tags(format_user_name($search_result['LOGON'], $search_result['NICKNAME'])), "</a></td>\n";
                    echo "                      </tr>\n";

                }else {

                    echo "                      <tr>\n";
                    echo "                        <td align=\"left\">", form_checkbox("search_result[]", $search_result['LOGON'], ''), "&nbsp;<a href=\"user_profile.php?webtag=$webtag&amp;uid={$search_result['UID']}\" target=\"_blank\" onclick=\"return openProfile({$search_result['UID']}, '$webtag')\">", word_filter_add_ob_tags(format_user_name($search_result['LOGON'], $search_result['NICKNAME'])), "</a></td>\n";
                    echo "                      </tr>\n";
                }
            
            }else {

                if (($search_results_array['results_count'] > 1) && $allow_multi === false) {

                    echo "                      <tr>\n";
                    echo "                        <td align=\"left\">", form_radio("search_result[]", $search_result['TID'], ''), "&nbsp;<a href=\"messages.php?webtag=$webtag&amp;msg={$search_result['TID']}.1\" target=\"_blank\">", word_filter_add_ob_tags(thread_format_prefix($search_result['PREFIX'], $search_result['TITLE'])), "</a></td>\n";
                    echo "                      </tr>\n";

                }else {

                    echo "                      <tr>\n";
                    echo "                        <td align=\"left\">", form_checkbox("search_result[]", $search_result['TID'], ''), "&nbsp;<a href=\"messages.php?webtag=$webtag&amp;msg={$search_result['TID']}.1\" target=\"_blank\">", word_filter_add_ob_tags(thread_format_prefix($search_result['PREFIX'], $search_result['TITLE'])), "</a></td>\n";
                    echo "                      </tr>\n";
                }
            }
        }

        echo "                        <tr>\n";
        echo "                          <td class=\"postbody\">&nbsp;</td>\n";
        echo "                        </tr>\n";
        echo "                      </table>\n";
        echo "                    </div>\n";
        echo "                  </td>\n";
        echo "                </tr>\n";
        echo "              </table>\n";
        echo "            </td>\n";
        echo "          </tr>\n";
        echo "        </table>\n";
        echo "      </td>\n";
        echo "    </tr>\n";
        echo "    <tr>\n";
        echo "      <td class=\"postbody\">&nbsp;</td>\n";
        echo "    </tr>\n";
        echo "    <tr>\n";
        echo "      <td class=\"postbody\" align=\"center\">", page_links("search_popup.php?webtag=$webtag&search_query=$search_query&type=$type", $start, $search_results_array['results_count'], 10), "</td>\n";
        echo "    </tr>\n";
        echo "    <tr>\n";
        echo "      <td class=\"postbody\">&nbsp;</td>\n";
        echo "    </tr>\n";
        echo "    <tr>\n";
        echo "      <td align=\"center\">", form_submit('select_result', $lang['select']), "&nbsp;", form_submit('submit', $lang['searchagain']), "&nbsp;", form_submit('close', $lang['close']), "</td>\n";
        echo "    </tr>\n";
        echo "  </table>\n";
    
    }else {

        echo "  <br />\n";
        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"475\">\n";
        echo "    <tr>\n";
        echo "      <td align=\"left\">\n";
        echo "        <table class=\"box\" width=\"100%\">\n";
        echo "          <tr>\n";
        echo "            <td align=\"left\" class=\"posthead\">\n";
        echo "              <table class=\"posthead\" width=\"100%\">\n";
        echo "                <tr>\n";
        echo "                  <td class=\"subhead\" align=\"left\">{$lang['results']}</td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td align=\"center\">\n";
        echo "                    <table width=\"95%\">\n";
        echo "                      <tr>\n";
        echo "                        <td class=\"postbody\">{$lang['nomatches']}</td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td class=\"postbody\">&nbsp;</td>\n";
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
        echo "      <td class=\"postbody\">&nbsp;</td>\n";
        echo "    </tr>\n";
        echo "    <tr>\n";
        echo "      <td align=\"center\">", form_submit('submit', $lang['search']), "&nbsp;", form_submit('close', $lang['close']), "</td>\n";
        echo "    </tr>\n";
        echo "  </table>\n";
    }

}else {

    echo "  <br />\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"475\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_submit('submit', $lang['search']), "&nbsp;", form_submit('close', $lang['close']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
}

echo "</form>\n";
echo "</div>\n";

html_draw_bottom();

?>