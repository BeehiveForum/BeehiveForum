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

/* $Id: pm_folders.php,v 1.21 2008-07-25 18:12:55 decoyduck Exp $ */

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
include_once(BH_INCLUDE_PATH. "fixhtml.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "pm.inc.php");
include_once(BH_INCLUDE_PATH. "post.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");
include_once(BH_INCLUDE_PATH. "zip_lib.inc.php");

// Intitalise a few variables

$webtag_search = false;

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
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

// Fetch the webtag

$webtag = get_webtag($webtag_search);

// Load language file

$lang = load_language_file();

// Get the user's UID

$uid = bh_session_get_value('UID');

// Guests can't access PMs

if (user_is_guest()) {

    html_guest_error();
    exit;
}

// Variables to hold our message counts

$pm_new_count = 0;
$pm_outbox_count = 0;
$pm_unread_count = 0;

// Check that PM system is enabled

pm_enabled();

// Check for new PMs

pm_get_message_count($pm_new_count, $pm_outbox_count, $pm_unread_count);

// Various Headers for the PM folders

$pm_header_array = array(PM_FOLDER_INBOX   => $lang['pminbox'],
                         PM_FOLDER_SENT    => $lang['pmsentitems'],
                         PM_FOLDER_OUTBOX  => $lang['pmoutbox'],
                         PM_FOLDER_SAVED   => $lang['pmsaveditems'],
                         PM_FOLDER_DRAFTS  => $lang['pmdrafts'],
                         PM_SEARCH_RESULTS => $lang['searchresults']);

// Default Folder

$folder = PM_FOLDER_INBOX;

if (isset($_GET['folder'])) {

    if ($_GET['folder'] == PM_FOLDER_SENT) {
        $folder = PM_FOLDER_SENT;
    }else if ($_GET['folder'] == PM_FOLDER_OUTBOX) {
        $folder = PM_FOLDER_OUTBOX;
    }else if ($_GET['folder'] == PM_FOLDER_SAVED) {
        $folder = PM_FOLDER_SAVED;
    }

}elseif (isset($_POST['folder'])) {

    if ($_POST['folder'] == PM_FOLDER_SENT) {
        $folder = PM_FOLDER_SENT;
    }else if ($_POST['folder'] == PM_FOLDER_OUTBOX) {
        $folder = PM_FOLDER_OUTBOX;
    }else if ($_POST['folder'] == PM_FOLDER_SAVED) {
        $folder = PM_FOLDER_SAVED;
    }
}

// Prune old messages for the current user

pm_user_prune_folders();

// Get the name of the pm_messages frame set.

$pm_messages_frame = html_get_frame_name('pm_messages');

// Draw the header.

html_draw_top("basetarget=$pm_messages_frame", "pm.js", 'pm_popup_disabled');

echo "<h1>{$lang['privatemessages']}</h1>\n";
echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form name=\"pm\" action=\"pm_messages.php\" method=\"post\" target=\"", html_get_frame_name('pm_messages'), "\">\n";
echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
echo "  ", form_input_hidden('folder', PM_SEARCH_RESULTS), "\n";

$pm_message_count_array = pm_get_folder_message_counts();

foreach ($pm_header_array as $folder_type => $folder_name) {

    echo "  <table width=\"90%\" border=\"0\" cellpadding=\"2\" cellspacing=\"0\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"foldername\"><img src=\"", style_image('folder.png'), "\" alt=\"{$lang['folder']}\" title=\"{$lang['folder']}\" />&nbsp;<a href=\"pm_messages.php?webtag=$webtag&amp;folder=$folder_type\" title=\"", ($pm_message_count_array[$folder_type] <> 1) ? sprintf($lang['pmtooltipxmessages'], $pm_message_count_array[$folder_type]) : $lang['pmtooltip1message'], "\">$folder_name</a> <span class=\"pm_message_count\">({$pm_message_count_array[$folder_type]})</span></td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
}

echo "  <br />\n";
echo "  <table width=\"90%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\" class=\"foldername\">{$lang['search']}:</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\" class=\"smalltext\">", form_input_text("search_string", "", 24), "&nbsp;", form_submit('search', $lang['find']), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <br />\n";
echo "  <table width=\"90%\" border=\"0\" cellpadding=\"2\" cellspacing=\"0\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"foldername\"><img src=\"", style_image('post.png'), "\" alt=\"{$lang['sendnewpm']}\" title=\"{$lang['sendnewpm']}\" />&nbsp;<a href=\"pm_write.php?webtag=$webtag\" title=\"{$lang['sendnewpm']}\" target=\"", html_get_frame_name('main'), "\">{$lang['sendnewpm']}</a></td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <table width=\"90%\" border=\"0\" cellpadding=\"2\" cellspacing=\"0\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"foldername\"><img src=\"", style_image('post.png'), "\" alt=\"{$lang['privatemessageoptions']}\" title=\"{$lang['privatemessageoptions']}\" />&nbsp;<a href=\"pm_options.php?webtag=$webtag\" title=\"{$lang['privatemessageoptions']}\">{$lang['privatemessageoptions']}</a></td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";

// Fetch the free PM space and calculate it as a percentage.

$pm_free_space = pm_get_free_space();
$pm_max_user_messages = forum_get_setting('pm_max_user_messages', false, 100);

$pm_used_percent = (100 / $pm_max_user_messages) * ($pm_max_user_messages - $pm_free_space);

echo "  <br />\n";
echo "  <table width=\"90%\" border=\"0\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\" width=\"100%\">\n";
echo "        <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" width=\"60%\">\n";
echo "              <table cellpadding=\"0\" cellspacing=\"0\" class=\"pmbar_container\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" title=\"{$pm_used_percent}% {$lang['used']}\">\n";
echo "                    <table cellpadding=\"0\" cellspacing=\"0\" class=\"pmbar\" style=\"width: {$pm_used_percent}%\">\n";
echo "                      <tr>\n";
echo "                        <td></td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"pmbar_text\" nowrap=\"nowrap\">", sprintf($lang['yourpmfoldersare'], "$pm_used_percent%"), "</td>\n";
echo "          </tr>\n";

if (pm_auto_prune_enabled()) {

    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"postbody\">&nbsp;</td>\n";
    echo "          </tr>\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"pmbar_text\"><img src=\"", style_image('warning.png'), "\" alt=\"{$lang['pmfolderpruningisenabled']}\" title=\"{$lang['pmfolderpruningisenabled']}\" /> {$lang['pmfolderpruningisenabled']}&nbsp;[<a href=\"javascript:void(0)\" target=\"_self\" onclick=\"alert('{$lang['pmpruneexplanation']}');\">?</a>]</td>\n";
    echo "          </tr>\n";
}

echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";
echo "</div>\n";

html_draw_bottom();

?>