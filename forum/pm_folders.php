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

// Set the default timezone
date_default_timezone_set('UTC');

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Caching functions
include_once(BH_INCLUDE_PATH. "cache.inc.php");

// Disable PHP's register_globals
unregister_globals();

// Correctly set server protocol
set_server_protocol();

// Disable caching if on AOL
cache_disable_aol();

// Disable caching if proxy server detected.
cache_disable_proxy();

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

// Get Webtag
$webtag = get_webtag();

// Check we're logged in correctly
if (!$user_sess = session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.
if (session_user_banned()) {

    html_user_banned();
    exit;
}

// Check to see if the user has been approved.
if (!session_user_approved()) {

    html_user_require_approval();
    exit;
}

// Initialise Locale
lang_init();

// Get the user's UID
$uid = session_get_value('UID');

// Guests can't access PMs
if (user_is_guest()) {

    html_guest_error();
    exit;
}

// Check that PM system is enabled
pm_enabled();

// Variables to hold message counts
$pm_new_count = 0;
$pm_outbox_count = 0;
$pm_unread_count = 0;

// Check for new PMs
pm_get_message_count($pm_new_count, $pm_outbox_count, $pm_unread_count);

// Get custom folder names array.
if (!$pm_folder_names_array = pm_get_folder_names()) {

    $pm_folder_names_array = array(PM_FOLDER_INBOX   => gettext("Inbox"),
                                   PM_FOLDER_SENT    => gettext("Sent Items"),
                                   PM_FOLDER_OUTBOX  => gettext("Outbox"),
                                   PM_FOLDER_SAVED   => gettext("Saved Items"),
                                   PM_FOLDER_DRAFTS  => gettext("Drafts"),
                                   PM_SEARCH_RESULTS => gettext("Search Results"));
}

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

if (isset($_GET['manage_folder'])) {

    if (is_numeric($_GET['manage_folder'])) {

        $manage_folder = $_GET['manage_folder'];

    }else {

        html_draw_top(sprintf("title=%s", gettext("Error")));
        html_display_error_msg(gettext("Invalid Folder ID. Check that a folder with this ID exists!"));
        html_draw_bottom();
        exit;
    }

}elseif (isset($_POST['manage_folder'])) {

    if (is_numeric($_POST['manage_folder'])) {

        $manage_folder = $_POST['manage_folder'];

    }else {

        html_draw_top(sprintf("title=%s", gettext("Error")));
        html_display_error_msg(gettext("Invalid Folder ID. Check that a folder with this ID exists!"));
        html_draw_bottom();
        exit;
    }
}

if (isset($_POST['save'])) {

    if (isset($_POST['folder_name']) && strlen(trim(stripslashes_array($_POST['folder_name']))) > 0) {

        $folder_name = trim(stripslashes_array($_POST['folder_name']));

        if (pm_update_folder_name($manage_folder, $folder_name)) {

            header_redirect("pm_folders.php?webtag=$webtag&manage_folder=$manage_folder&folder_renamed=true");
            exit;

        }else {

            $error_msg_array[] = gettext("Failed to update folder");
            $valid = false;
        }
    }

}elseif (isset($_POST['reset'])) {

    if (pm_reset_folder_name($manage_folder)) {

        header_redirect("pm_folders.php?webtag=$webtag&manage_folder=$manage_folder&folder_renamed=true");
        exit;

    }else {

        $error_msg_array[] = gettext("Failed to update folder");
        $valid = false;
    }
}

// Prune old messages for the current user
pm_user_prune_folders();

// Get the name of the pm_messages frame set.
$pm_messages_frame = html_get_frame_name('pm_messages');

// Draw the header.
html_draw_top("title=", gettext("Private Messages"), "", "basetarget=$pm_messages_frame", "pm.js", 'pm_popup_disabled');

if (isset($manage_folder) && is_numeric($manage_folder)) {

    echo "<h1>", gettext("Private Messages"), "<img src=\"", html_style_image('separator.png'), "\" alt=\"\" border=\"0\" />", gettext("Manage Folder"), "<img src=\"", html_style_image('separator.png'), "\" alt=\"\" border=\"0\" />{$pm_folder_names_array[$manage_folder]}</h1>\n";

    if (isset($_GET['folder_renamed'])) {

        html_display_success_msg(gettext("Successfully Renamed Folder"), '500', 'center', 'pm_rename_success');

    }elseif (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

        html_display_error_array($error_msg_array, '500', 'center');
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "  <form accept-charset=\"utf-8\" name=\"pm_folder_options\" action=\"pm_folders.php\" method=\"post\" target=\"_self\">\n";
    echo "  ", form_input_hidden("webtag", htmlentities_array($webtag)), "\n";
    echo "  ", form_input_hidden("manage_folder", htmlentities_array($manage_folder)), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">", gettext("Folder name"), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">", gettext("Folder name"), ":</td>\n";
    echo "                        <td align=\"left\">", form_input_text("folder_name", htmlentities_array($pm_folder_names_array[$manage_folder]), 40, 32), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
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
    echo "      <td align=\"center\">", form_submit("save", gettext("Save")), "&nbsp;", form_submit("reset", gettext("Reset")), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</form>\n";

    html_draw_bottom();
    exit;
}

echo "<h1>", gettext("Private Messages"), "</h1>\n";
echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form accept-charset=\"utf-8\" name=\"pm\" action=\"pm_messages.php\" method=\"post\" target=\"", html_get_frame_name('pm_messages'), "\">\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden('folder', PM_SEARCH_RESULTS), "\n";

$pm_message_count_array = pm_get_folder_message_counts();

foreach ($pm_folder_names_array as $folder_type => $folder_name) {

    if (isset($pm_message_count_array[$folder_type]) && is_numeric($pm_message_count_array[$folder_type])) {

        echo "  <table width=\"90%\" border=\"0\" cellpadding=\"2\" cellspacing=\"0\">\n";
        echo "    <tr>\n";
        echo "      <td align=\"left\">\n";
        echo "        <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
        echo "          <tr>\n";
        echo "            <td align=\"left\" class=\"foldername\"><a href=\"pm_folders.php?webtag=$webtag&amp;manage_folder=$folder_type\" target=\"", html_get_frame_name('pm_messages'), "\"><img src=\"", html_style_image('folder.png'), "\" alt=\"", gettext("Folder"), "\" title=\"", gettext("Manage Folder"), "\" border=\"0\" /></a>&nbsp;<a href=\"pm_messages.php?webtag=$webtag&amp;folder=$folder_type\" title=\"", ($pm_message_count_array[$folder_type] <> 1) ? sprintf(gettext("%s messages"), $pm_message_count_array[$folder_type]) : gettext("1 message"), "\">$folder_name</a> <span class=\"pm_message_count\">({$pm_message_count_array[$folder_type]})</span></td>\n";
        echo "          </tr>\n";
        echo "        </table>\n";
        echo "      </td>\n";
        echo "    </tr>\n";
        echo "  </table>\n";
    }
}

echo "  <br />\n";
echo "  <table width=\"90%\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\" class=\"foldername\">", gettext("Search"), ":</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\" class=\"smalltext\">", form_input_text("search_string", "", 24), "&nbsp;", form_submit('search', gettext("Find")), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <br />\n";
echo "  <table width=\"90%\" border=\"0\" cellpadding=\"2\" cellspacing=\"0\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"foldername\"><img src=\"", html_style_image('post.png'), "\" alt=\"", gettext("Send New PM"), "\" title=\"", gettext("Send New PM"), "\" />&nbsp;<a href=\"pm_write.php?webtag=$webtag\" title=\"", gettext("Send New PM"), "\" target=\"", html_get_frame_name('main'), "\">", gettext("Send New PM"), "</a></td>\n";
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
echo "            <td align=\"left\" class=\"foldername\"><img src=\"", html_style_image('options.png'), "\" alt=\"", gettext("Private Message Options"), "\" title=\"", gettext("Private Message Options"), "\" />&nbsp;<a href=\"pm_options.php?webtag=$webtag\" title=\"", gettext("Private Message Options"), "\">", gettext("Private Message Options"), "</a></td>\n";
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
echo "            <td align=\"left\" class=\"foldername\"><img src=\"", html_style_image('export.png'), "\" alt=\"", gettext("Export Private Messages"), "\" title=\"", gettext("Export Private Messages"), "\" />&nbsp;<a href=\"pm_export.php?webtag=$webtag\" title=\"", gettext("Export Private Messages"), "\">", gettext("Export Private Messages"), "</a></td>\n";
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
echo "      <td align=\"left\">\n";
echo "        <table cellpadding=\"0\" cellspacing=\"0\" width=\"75%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\">\n";
echo "              <table cellpadding=\"0\" cellspacing=\"0\" class=\"pmbar_container\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" title=\"{$pm_used_percent}% ", gettext("Used"), "\">\n";
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
echo "            <td align=\"left\" class=\"pmbar_text\" style=\"white-space: nowrap\">", sprintf(gettext("Your PM folders are %s full"), "$pm_used_percent%"), "</td>\n";
echo "          </tr>\n";

if (pm_auto_prune_enabled()) {

    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"postbody\">&nbsp;</td>\n";
    echo "          </tr>\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"pmbar_text\"><img src=\"", html_style_image('warning.png'), "\" alt=\"", gettext("PM Folder pruning is enabled!"), "\" title=\"", gettext("PM Folder pruning is enabled!"), "\" /> ", gettext("PM Folder pruning is enabled!"), "&nbsp;[<a class=\"help_popup\" title=\"", gettext("This forum uses PM folder pruning. The messages you have stored in your Inbox and Sent Items
folders are subject to automatic deletion. Any messages you wish to keep should be moved to
your 'Saved Items' folder so that they are not deleted."), "\">?</a>]</td>\n";
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
