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

/* $Id: pm_options.php 4599 2010-11-16 20:00:49Z DecoyDuck $ */

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
include_once(BH_INCLUDE_PATH. "emoticons.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "pm.inc.php");
include_once(BH_INCLUDE_PATH. "post.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "styles.inc.php");
include_once(BH_INCLUDE_PATH. "timezone.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "zip_lib.inc.php");

// Get Webtag
$webtag = get_webtag();

// See if we can try and logon automatically
logon_perform_auto();

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

// Load language file
$lang = load_language_file();

// Guests can't access this page.
if (user_is_guest()) {

    html_guest_error();
    exit;
}

// Array to store error messages.
$error_msg_array = array();

// Check that PM system is enabled
pm_enabled();

// Variables to hold message counts
$pm_new_count = 0;
$pm_outbox_count = 0;
$pm_unread_count = 0;

// Check for new PMs
pm_get_message_count($pm_new_count, $pm_outbox_count, $pm_unread_count);

// Get custom folder names array.
if (!$pm_folder_names_array = pm_get_folder_names(false)) {

    $pm_folder_names_array = array(PM_FOLDER_INBOX   => $lang['pminbox'],
                                   PM_FOLDER_SENT    => $lang['pmsentitems'],
                                   PM_FOLDER_OUTBOX  => $lang['pmoutbox'],
                                   PM_FOLDER_SAVED   => $lang['pmsaveditems'],
                                   PM_FOLDER_DRAFTS  => $lang['pmdrafts']);
}

// Submit code starts here.
if (isset($_POST['export'])) {

    $options_array = array();

    $pm_folders_array = array();

    if (isset($_POST['pm_folders_array']) && is_array($_POST['pm_folders_array'])) {

        foreach ($_POST['pm_folders_array'] as $folder => $export) {

            if (isset($pm_folder_names_array[$folder]) && ($export == 'Y')) {

                $pm_folders_array[] = $folder;
            }
        }
    }

    if (isset($_POST['pm_export_file']) && in_array($_POST['pm_export_file'], range(0, 2))) {
        $options_array['PM_EXPORT_FILE'] = $_POST['pm_export_file'];
    }else {
        $options_array['PM_EXPORT_FILE'] = 0;
    }

    if (isset($_POST['pm_export_type']) && in_array($_POST['pm_export_file'], range(0, 1))) {
        $options_array['PM_EXPORT_TYPE'] = $_POST['pm_export_type'];
    }else {
        $options_array['PM_EXPORT_TYPE'] = 0;
    }

    if (isset($_POST['pm_export_attachments']) && $_POST['pm_export_attachments'] == "Y") {
        $options_array['PM_EXPORT_ATTACHMENTS'] = "Y";
    }else {
        $options_array['PM_EXPORT_ATTACHMENTS'] = "N";
    }

    if (isset($_POST['pm_export_style']) && $_POST['pm_export_style'] == "Y") {
        $options_array['PM_EXPORT_STYLE'] = "Y";
    }else {
        $options_array['PM_EXPORT_STYLE'] = "N";
    }

    if (isset($_POST['pm_export_wordfilter']) && $_POST['pm_export_wordfilter'] == "Y") {
        $options_array['PM_EXPORT_WORDFILTER'] = "Y";
    }else {
        $options_array['PM_EXPORT_WORDFILTER'] = "N";
    }

    if (sizeof($pm_folders_array) > 0) {

        pm_export_folders($pm_folders_array, $options_array);

    } else {

        $error_msg_array[] = $lang['youmustselectsomefolderstoexport'];
    }
}

$uid = session_get_value('UID');

// Get User Prefs
$user_prefs = user_get_prefs($uid);

// Start output here
html_draw_top("title={$lang['exportprivatemessages']}", "emoticons.js", 'class=window_title');

echo "<h1>{$lang['exportprivatemessages']}</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '600', 'left');

}else if (isset($_GET['updated'])) {

    html_display_success_msg($lang['preferencesupdated'], '600', 'left');
}

echo "<br />\n";
echo "<form accept-charset=\"utf-8\" name=\"prefs\" action=\"pm_export.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\">{$lang['selectprivatemessagefolderstoexport']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\">\n";

$pm_message_count_array = pm_get_folder_message_counts();

foreach ($pm_folder_names_array as $folder_type => $folder_name) {

    if (isset($pm_message_count_array[$folder_type]) && is_numeric($pm_message_count_array[$folder_type])) {

        echo "  <table width=\"90%\" border=\"0\" cellpadding=\"2\" cellspacing=\"0\">\n";
        echo "    <tr>\n";
        echo "      <td align=\"left\">\n";
        echo "        <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
        echo "          <tr>\n";
        echo "            <td align=\"left\" class=\"foldername\">", form_checkbox("pm_folders_array[$folder_type]", "Y", $folder_name), "&nbsp;<span class=\"pm_message_count\">({$pm_message_count_array[$folder_type]})</span></td>\n";
        echo "          </tr>\n";
        echo "        </table>\n";
        echo "      </td>\n";
        echo "    </tr>\n";
        echo "  </table>\n";
    }
}

echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "        <br />\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"3\" class=\"subhead\">{$lang['privatemessageexportoptions']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" rowspan=\"7\" width=\"1%\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" width=\"250\" nowrap=\"nowrap\">{$lang['pmexportastype']}:</td>\n";
echo "                  <td align=\"left\">", form_dropdown_array("pm_export_type", array($lang['pmexporthtml'], $lang['pmexportxml'], $lang['pmexportcsv']), (isset($user_prefs['PM_EXPORT_TYPE']) && is_numeric($user_prefs['PM_EXPORT_TYPE'])) ? $user_prefs['PM_EXPORT_TYPE'] : 0), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" width=\"250\" nowrap=\"nowrap\">{$lang['pmexportmessagesas']}:</td>\n";
echo "                  <td align=\"left\">", form_dropdown_array("pm_export_file", array($lang['pmexportonefileforallmessages'], $lang['pmexportonefilepermessage']), (isset($user_prefs['PM_EXPORT_FILE']) && is_numeric($user_prefs['PM_EXPORT_FILE'])) ? $user_prefs['PM_EXPORT_FILE'] : 0), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\" nowrap=\"nowrap\">", form_checkbox("pm_export_attachments", "Y", $lang['pmexportattachments'], (isset($user_prefs['PM_EXPORT_ATTACHMENTS']) && $user_prefs['PM_EXPORT_ATTACHMENTS'] == "Y") ? true : false), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\" nowrap=\"nowrap\">", form_checkbox("pm_export_style", "Y", $lang['pmexportincludestyle'], (isset($user_prefs['PM_EXPORT_STYLE']) && $user_prefs['PM_EXPORT_STYLE'] == "Y") ? true : false), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\" nowrap=\"nowrap\">", form_checkbox("pm_export_wordfilter", "Y", $lang['pmexportwordfilter'], (isset($user_prefs['PM_EXPORT_WORDFILTER']) && $user_prefs['PM_EXPORT_WORDFILTER'] == "Y") ? true : false), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
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
echo "      <td align=\"center\">", form_submit("export", $lang['export']), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";

html_draw_bottom();

?>