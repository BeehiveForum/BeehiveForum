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

/* $Id: poll_results.php,v 1.40 2008-08-20 19:02:58 decoyduck Exp $ */

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

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "poll.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "thread.inc.php");
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

// Check to see if the user has been approved.

if (!bh_session_user_approved()) {

    html_user_require_approval();
    exit;
}

// Check we have a webtag

if (!$webtag = get_webtag()) {
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = ($_GET['page'] > 0) ? $_GET['page'] : 1;
}else if (isset($_POST['page']) && is_numeric($_POST['page'])) {
    $page = ($_POST['page'] > 0) ? $_POST['page'] : 1;
}else {
    $page = 1;
}

$start = floor($page - 1) * 5;
if ($start < 0) $start = 0;

if (isset($_POST['close'])) {

    html_draw_top('pm_popup_disabled');

    echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
    echo "  window.close();\n";
    echo "</script>\n";

    html_draw_bottom();
    exit;
}

if (isset($_GET['tid']) && is_numeric($_GET['tid'])) {

    $tid = $_GET['tid'];

    if (!$t_fid = thread_get_folder($tid, 1)) {

        html_draw_top('pm_popup_disabled');
        html_error_msg($lang['threadcouldnotbefound']);
        html_draw_bottom();
        exit;
    }

}else {

    html_draw_top('pm_popup_disabled');
    html_error_msg($lang['mustspecifypolltoview'], 'poll_results.php', 'post', array('close' => $lang['close']));
    html_draw_bottom();
    exit;
}

if (!$thread_data = thread_get($tid, bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0))) {

    html_draw_top();
    html_error_msg($lang['threadcouldnotbefound']);
    html_draw_bottom();
    exit;
}

if (!$poll_data = poll_get($tid)) {

    html_draw_top();
    html_error_msg($lang['threadcouldnotbefound']);
    html_draw_bottom();
    exit;
}

if (isset($_GET['view_style']) && is_numeric($_GET['view_style'])) {

    if ($_GET['view_style'] == POLL_VIEW_TYPE_OPTION) {

        $view_style = POLL_VIEW_TYPE_OPTION;

    }elseif ($_GET['view_style'] == POLL_VIEW_TYPE_USER) {

        $view_style = POLL_VIEW_TYPE_USER;

    }else {

        $view_style = POLL_VIEW_TYPE_OPTION;
    }

}else {

    $view_style = POLL_VIEW_TYPE_OPTION;
}

$poll_user_count = 0;

$forum_name   = forum_get_setting('forum_name', false, 'A Beehive Forum');

$folder_title = _htmlentities($thread_data['FOLDER_TITLE']);

$thread_title = _htmlentities(thread_format_prefix($thread_data['PREFIX'], $thread_data['TITLE']));

html_draw_top("title=$forum_name > $thread_title > {$poll_data['QUESTION']}", "openprofile.js", "folder_options.js", 'pm_popup_disabled');

echo "<div align=\"center\">\n";
echo "<table width=\"580\" border=\"0\">\n";
echo "  <tr>\n";
echo "    <td align=\"left\">", messages_top($tid, 1, $thread_data['FID'], $folder_title, $thread_title, THREAD_NOINTEREST, FOLDER_NOINTEREST, false, false, false, false, false), "</td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo "<table cellpadding=\"0\" cellspacing=\"0\" width=\"580\">\n";
echo "  <tr>\n";
echo "    <td align=\"left\">\n";

if ($poll_data['SHOWRESULTS'] == POLL_SHOW_RESULTS || bh_session_get_value('UID') == $poll_data['FROM_UID'] || bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid) || ($poll_data['CLOSES'] > 0 && $poll_data['CLOSES'] < mktime())) {

    if ($poll_data['VOTETYPE'] == POLL_VOTE_PUBLIC && $poll_data['CHANGEVOTE'] < POLL_VOTE_MULTI && $poll_data['POLLTYPE'] <> POLL_TABLE_GRAPH) {

        echo poll_public_ballot($tid, $view_style, $start, $poll_user_count);

    }else {

        echo "      <table class=\"box\" width=\"100%\">\n";
        echo "        <tr>\n";
        echo "          <td align=\"left\" class=\"posthead\">\n";
        echo "            <table width=\"100%\">\n";

        if (strlen(trim($poll_data['QUESTION'])) > 0 && strcasecmp($thread_title, $poll_data['QUESTION']) <> 0) {

            echo "              <tr>\n";
            echo "                <td align=\"left\" class=\"subhead\">", word_filter_add_ob_tags(_htmlentities($poll_data['QUESTION'])), "</td>\n";
            echo "              </tr>\n";
        }

        echo "              <tr>\n";
        echo "                <td align=\"left\">\n";

        if ($poll_data['POLLTYPE'] == POLL_HORIZONTAL_GRAPH) {

            echo poll_horizontal_graph($tid);

        }elseif ($poll_data['POLLTYPE'] == POLL_TABLE_GRAPH) {

            echo poll_table_graph($tid);

        }else {

            echo poll_vertical_graph($tid);
        }

        echo "                </td>\n";
        echo "              </tr>\n";
        echo "            </table>\n";
        echo "          </td>\n";
        echo "        </tr>\n";
        echo "      </table>\n";
    }

}else {

    $pollresults = poll_get_votes($tid);

    for ($i = 0; $i <= sizeof($pollresults['OPTION_ID']); $i++) {

        if (!empty($pollresults['OPTION_NAME'][$i])) {

            echo "        <tr>\n";
            echo "          <td align=\"left\" class=\"postbody\">{$pollresults['OPTION_NAME'][$i]}</td>\n";
            echo "        </tr>\n";
        }
    }
}

echo "    </td>\n";
echo "  </tr>\n";
echo "</table>\n";

if ($poll_data['VOTETYPE'] == POLL_VOTE_PUBLIC && $poll_data['POLLTYPE'] <> POLL_TABLE_GRAPH) {

    if ($view_style == POLL_VIEW_TYPE_USER) {

        echo "<table cellpadding=\"0\" cellspacing=\"0\" width=\"475\">\n";
        echo "  <tr>\n";
        echo "    <td class=\"postbody\" align=\"center\">", page_links("poll_results.php?webtag=$webtag&tid=$tid&view_style=$view_style", $start, $poll_user_count, 5), "</td>\n";
        echo "  </tr>\n";
        echo "</table>\n";
        echo "<br />\n";
    }

    echo "<table cellpadding=\"0\" cellspacing=\"0\" width=\"475\">\n";
    echo "  <tr>\n";
    echo "    <td align=\"center\" class=\"postbody\">\n";
    echo "      <form accept-charset=\"utf-8\" name=\"f_mode\" method=\"get\" action=\"poll_results.php\">\n";
    echo "        ", form_input_hidden("webtag", _htmlentities($webtag)), "\n";
    echo "        ", form_input_hidden("tid", _htmlentities($tid)), "\n";
    echo "        View Style: ", form_dropdown_array("view_style", array($lang['viewbypolloption'], $lang['viewbyuser']), $view_style, "onchange=\"submit()\""), "&nbsp;", form_submit('go', $lang['goexcmark']), "\n";
    echo "      </form>\n";
    echo "    </td>\n";
    echo "  </tr>\n";
    echo "</table>\n";
}

echo "<br />\n";
echo "<form accept-charset=\"utf-8\" method=\"post\" action=\"poll_results.php\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
echo "  ". form_submit('close', $lang['close']). "\n";
echo "</form>\n";
echo "</div>\n";

html_draw_bottom();

?>