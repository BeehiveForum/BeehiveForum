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

/* $Id: edit_subscriptions.php,v 1.6 2006-11-12 23:50:24 decoyduck Exp $ */

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

include_once(BH_INCLUDE_PATH. "fixhtml.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "post.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "user_rel.inc.php");

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

// Start output here

html_draw_top();

echo "<h1>{$lang['threadsubscriptions']}</h1>\n";

$uid = bh_session_get_value('UID');

// Array to store the update texts in

$update_array = array();
$threads_array = array();

// User pressed Save button

if (isset($_POST['save'])) {

    $valid = true;

    if (isset($_POST['set_interest']) && is_array($_POST['set_interest'])) {

        foreach ($_POST['set_interest'] as $thread => $interest) {

            $threads_array[] = $thread;
            
            if (is_numeric($thread)  && is_numeric($interest)) {

                if (!thread_set_interest($thread, $interest)) {

                    $valid = false;
                    $thread_title = thread_get_title($thread);
                    $update_array[] = sprintf("{$lang['couldnotupdateinterestonthread']}", $thread_title);
                }
            }
        }

        if ($valid) {

            $update_array[] = "{$lang['threadinterestsupdatedsuccessfully']}";
        }
    }
}

// Page links.

if (isset($_GET['main_page']) && is_numeric($_GET['main_page'])) {
    $main_page = $_GET['main_page'];
    $start_main = floor($main_page - 1) * 20;
}else if (isset($_POST['main_page']) && is_numeric($_POST['main_page'])) {
    $main_page = $_POST['main_page'];
    $start_main = floor($main_page - 1) * 20;
}else {
    $main_page = 1;
    $start_main = 0;
}

// Search links.

if (isset($_GET['search_page']) && is_numeric($_GET['search_page'])) {
    $search_page = $_GET['search_page'];
    $start_search = floor($search_page - 1) * 20;
}else if (isset($_POST['search_page']) && is_numeric($_POST['search_page'])) {
    $search_page = $_POST['search_page'];
    $start_search = floor($search_page - 1) * 20;
}else {
    $search_page = 1;
    $start_search = 0;
}

// Thread search keywords.

if (isset($_GET['threadsearch']) && strlen(trim(_stripslashes($_GET['threadsearch']))) > 0) {
    $threadsearch = trim(_stripslashes($_GET['threadsearch']));
}else if (isset($_POST['threadsearch']) && strlen(trim(_stripslashes($_POST['threadsearch']))) > 0) {
    $threadsearch = trim(_stripslashes($_POST['threadsearch']));
}else {
    $threadsearch = "";
}

// View filter

if (isset($_GET['view_filter']) && is_numeric($_GET['view_filter'])) {
    $view_filter = $_GET['view_filter'];
}else if (isset($_POST['view_filter']) && is_numeric($_POST['view_filter'])) {
    $view_filter = $_POST['view_filter'];
}else {
    $view_filter = 2;
}

// Clear search?

if (isset($_POST['clear'])) {
    $threadsearch = "";
}

// Any messages to display?

if (isset($update_array) && is_array($update_array) && sizeof($update_array) > 0) {
    foreach($update_array as $update_text) {
        echo "<h2>$update_text</h2>\n";
    }
}

echo "<br />\n";

// Save button text changes depending on view selected.

$save_button_text = array('-1' => 'Unignore Selected', '1' => 'Reset Selected', '2' => 'Unsubscribe Selected');

if (isset($threadsearch) && strlen(trim($threadsearch)) > 0) {

    echo "<form method=\"post\" action=\"edit_subscriptions.php\" target=\"_self\">\n";
    echo "  ", form_input_hidden('webtag', $webtag), "\n";
    echo "  ", form_input_hidden("threadsearch", $threadsearch), "\n";
    echo "  ", form_input_hidden("main_page", $main_page), "\n";
    echo "  ", form_input_hidden("search_page", $search_page), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\" class=\"posthead\" colspan=\"3\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" width=\"600\">{$lang['threadtitle']}</td>\n";
    echo "                  <td align=\"left\" class=\"subhead\" width=\"50\">&nbsp;</td>\n";
    echo "                  <td align=\"right\" class=\"subhead\" width=\"50\">&nbsp;</td>\n";
    echo "                </tr>\n";

    $thread_search_array = threads_search_user_subscriptions($threadsearch, $threads_array, $view_filter, $start_search);

    if (sizeof($thread_search_array['thread_array']) > 0) {

        foreach ($thread_search_array['thread_array'] as $thread) {

            echo "                <tr>\n";
            echo "                  <td align=\"left\"><img src=\"", style_image('ct.png'), "\" title=\"{$lang['thread']}\" alt=\"{$lang['thread']}\" />&nbsp;<a href=\"index.php?msg={$thread['TID']}.1\" target=\"_blank\">{$thread['TITLE']}</a></td>\n";

            switch ($thread['INTEREST']) {

                case THREAD_IGNORED:

                    echo "                  <td align=\"center\"><img src=\"", style_image('ignored_thread.png'), "\" title=\"{$lang['ignored']}\" alt=\"{$lang['ignored']}\" /></td>\n";
                    break;

                case THREAD_INTERESTED:

                    echo "                  <td align=\"center\"><img src=\"", style_image('interested_thread.png'), "\" title=\"{$lang['interested']}\" alt=\"{$lang['interested']}\" /></td>\n";
                    break;

                case THREAD_SUBSCRIBED:

                    echo "                  <td align=\"center\"><img src=\"", style_image('subscribed_thread.png'), "\" title=\"{$lang['subscribed']}\" alt=\"{$lang['subscribed']}\" /></td>\n";
                    break;
            }

            echo "                  <td align=\"center\" nowrap=\"nowrap\">", form_checkbox('unsubscribe[]', $thread['TID'], ''), "</td>\n";
            echo "                </tr>\n";
        }

    }else {

        echo "                <tr>\n";
        echo "                  <td class=\"posthead\" colspan=\"7\" align=\"left\">&nbsp;{$lang['nomatches']}</td>\n";
        echo "                </tr>\n";
    }

    echo "                <tr>\n";
    echo "                  <td align=\"left\">&nbsp;</td>\n";
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
    echo "      <td align=\"left\" width=\"33%\">{$lang['view']}:&nbsp;", form_dropdown_array('view_filter', array(-1, 1, 2), array("{$lang['ignored']} ", "{$lang['interested']} ", "{$lang['subscribed']} "), $view_filter), "&nbsp;", form_submit("view_submit", $lang['goexcmark']), "</td>\n";
    echo "      <td class=\"postbody\" align=\"center\" width=\"33%\">", page_links("edit_subscriptions.php?webtag=$webtag&threadsearch=$threadsearch&main_page=$main_page&view_filter=$view_filter", $start_search, $thread_search_array['thread_count'], 20, "search_page"), "</td>\n";
    echo "      <td align=\"right\" width=\"33%\">", form_button("selectall", "Select all", "onclick=\"alert('not finished');\""), "</td>\n";    
    echo "    </tr>\n";

    if (sizeof($thread_search_array['thread_array']) > 0) {
    
        echo "    <tr>\n";
        echo "      <td align=\"left\">&nbsp;</td>\n";
        echo "    </tr>\n";
        echo "    <tr>\n";
        echo "      <td align=\"center\" colspan=\"3\">", form_submit("save", $save_button_text[$view_filter]), "</td>\n";
        echo "    </tr>\n";
    }

    echo "  </table>\n";
    echo "</form>\n";
    echo "<br />\n";

}else {

    echo "<form name=\"prefs\" action=\"edit_subscriptions.php\" method=\"post\" target=\"_self\">\n";
    echo "  ", form_input_hidden('webtag', $webtag), "\n";
    echo "  ", form_input_hidden("main_page", $main_page), "\n";
    echo "  ", form_input_hidden("search_page", $search_page), "\n";
    echo "  ", form_input_hidden("threadsearch", $threadsearch), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\" colspan=\"3\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" width=\"600\">{$lang['threadtitle']}</td>\n";
    echo "                  <td align=\"left\" class=\"subhead\" width=\"50\">&nbsp;</td>\n";
    echo "                  <td align=\"right\" class=\"subhead\" width=\"50\">&nbsp;</td>\n";
    echo "                </tr>\n";

    $thread_subscriptions = threads_get_user_subscriptions($threads_array, $view_filter, $start_main);

    if (sizeof($thread_subscriptions['thread_array']) > 0) {

        foreach ($thread_subscriptions['thread_array'] as $thread) {

            echo "                <tr>\n";
            echo "                  <td align=\"left\"><img src=\"", style_image('ct.png'), "\" title=\"{$lang['thread']}\" alt=\"{$lang['thread']}\" />&nbsp;<a href=\"index.php?msg={$thread['TID']}.1\" target=\"_blank\">{$thread['TITLE']}</a></td>\n";

            switch ($thread['INTEREST']) {

                case THREAD_IGNORED:

                    echo "                  <td align=\"center\"><img src=\"", style_image('ignored_thread.png'), "\" title=\"{$lang['ignored']}\" alt=\"{$lang['ignored']}\" /></td>\n";
                    break;

                case THREAD_INTERESTED:

                    echo "                  <td align=\"center\"><img src=\"", style_image('interested_thread.png'), "\" title=\"{$lang['interested']}\" alt=\"{$lang['interested']}\" /></td>\n";
                    break;

                case THREAD_SUBSCRIBED:

                    echo "                  <td align=\"center\"><img src=\"", style_image('subscribed_thread.png'), "\" title=\"{$lang['subscribed']}\" alt=\"{$lang['subscribed']}\" /></td>\n";
                    break;
            }

            echo "                  <td align=\"center\" nowrap=\"nowrap\">", form_checkbox('unsubscribe[]', $thread['TID'], ''), "</td>\n";
            echo "                </tr>\n";
        }

    }else {

        echo "                <tr>\n";
        echo "                  <td align=\"left\" colspan=\"2\">&nbsp;{$lang['nomatches']}</td>\n";
        echo "                </tr>\n";
    }

    echo "                <tr>\n";
    echo "                  <td align=\"left\">&nbsp;</td>\n";
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
    echo "      <td align=\"left\" width=\"33%\">{$lang['view']}:&nbsp;", form_dropdown_array('view_filter', array(-1, 1, 2), array("{$lang['ignored']} ", "{$lang['interested']} ", "{$lang['subscribed']} "), $view_filter), "&nbsp;", form_submit("view_submit", $lang['goexcmark']), "</td>\n";
    echo "      <td class=\"postbody\" align=\"center\">", page_links("edit_subscriptions.php?webtag=$webtag&threadsearch=$threadsearch&search_page=$search_page&view_filter=$view_filter", $start_main, $thread_subscriptions['thread_count'], 20, "main_page"), "</td>\n";
    echo "      <td align=\"right\" width=\"33%\">", form_button("selectall", "Select all", "onclick=\"alert('not finished');\""), "</td>\n";    
    echo "    </tr>\n";

    if (sizeof($thread_subscriptions['thread_array']) > 0) {

        echo "    <tr>\n";
        echo "      <td align=\"left\">&nbsp;</td>\n";
        echo "    </tr>\n";
        echo "    <tr>\n";
        echo "      <td align=\"center\" colspan=\"3\">", form_submit("save", $save_button_text[$view_filter]), "</td>\n";
        echo "    </tr>\n";
    }

    echo "  </table>\n";
    echo "</form>\n";
    echo "<br />\n";
}

echo "<form method=\"post\" action=\"edit_subscriptions.php\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";
echo "  ", form_input_hidden("main_page", $main_page), "\n";
echo "  ", form_input_hidden("search_page", $search_page), "\n";
echo "  ", form_input_hidden("main_page", $main_page), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\" class=\"posthead\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" align=\"left\">{$lang['search']}:</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td class=\"posthead\" align=\"left\">\n";
echo "                          {$lang['threadtitle']}: ", form_input_text("threadsearch", isset($threadsearch) ? $threadsearch : "", 30, 64), " ", form_submit('search', $lang['search']), "&nbsp;", form_submit('clear', $lang['clear']), "\n";
echo "                        </td>\n";
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
echo "  </table>\n";
echo "</form>\n";

html_draw_bottom();

?>