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

/* $Id: admin_default_forum_settings.php,v 1.11 2005-01-30 18:56:25 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Installation checking functions
include_once("./include/install.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum settings
$forum_settings = get_forum_settings();

include_once("./include/admin.inc.php");
include_once("./include/emoticons.inc.php");
include_once("./include/form.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/post.inc.php");
include_once("./include/session.inc.php");
include_once("./include/styles.inc.php");
include_once("./include/user.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri(true));
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=admin.php%3Fpage%3D$request_uri");
}

// Load language file

$lang = load_language_file();

if (!perm_has_forumtools_access()) {
    html_draw_top();
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;
}

$error_html = "";

// Languages

$available_langs = lang_get_available(); // get list of available languages

// Default Forum Settings

$default_forum_settings = get_default_forum_settings();

if (isset($_POST['submit'])) {

    $valid = true;

    if (isset($_POST['search_min_word_length']) && is_numeric($_POST['search_min_word_length'])) {
        $new_forum_settings['search_min_word_length'] = $_POST['search_min_word_length'];
    }else {
        $new_forum_settings['search_min_word_length'] = 3;
    }

    if (isset($_POST['session_cutoff']) && is_numeric($_POST['session_cutoff'])) {
        $new_forum_settings['session_cutoff'] = $_POST['session_cutoff'];
    }else {
        $new_forum_settings['session_cutoff'] = 86400;
    }

    if (isset($_POST['active_sess_cutoff']) && is_numeric($_POST['active_sess_cutoff'])) {

        if ($_POST['active_sess_cutoff'] < $_POST['session_cutoff']) {

            $new_forum_settings['active_sess_cutoff'] = $_POST['active_sess_cutoff'];

        }else {

            $error_html = "<h2>{$lang['activesessiongreaterthansession']}</h2>\n";
            $valid = false;
        }

    }else {

        $new_forum_settings['active_sess_cutoff'] = 900;
    }

    if (isset($_POST['allow_new_registrations']) && $_POST['allow_new_registrations'] == "Y") {
        $new_forum_settings['allow_new_registrations'] = "Y";
    }else {
        $new_forum_settings['allow_new_registrations'] = "N";
    }

    if (isset($_POST['show_pms']) && $_POST['show_pms'] == "Y") {
        $new_forum_settings['show_pms'] = "Y";
    }else {
        $new_forum_settings['show_pms'] = "N";
    }

    if (isset($_POST['pm_max_user_messages']) && is_numeric($_POST['pm_max_user_messages'])) {
        $new_forum_settings['pm_max_user_messages'] = $_POST['pm_max_user_messages'];
    }else {
        $new_forum_settings['pm_max_user_messages'] = 100;
    }

    if (isset($_POST['pm_auto_prune_enabled']) && $_POST['pm_auto_prune_enabled'] == "Y") {

        if (isset($_POST['pm_auto_prune']) && is_numeric($_POST['pm_auto_prune'])) {

            $new_forum_settings['pm_auto_prune'] = $_POST['pm_auto_prune'];

        }else {

            $new_forum_settings['pm_auto_prune'] = "-60";
        }

    }else {

        if (isset($_POST['pm_auto_prune']) && is_numeric($_POST['pm_auto_prune'])) {

            $new_forum_settings['pm_auto_prune'] = $_POST['pm_auto_prune'] * -1;

        }else {

            $new_forum_settings['pm_auto_prune'] = "-60";
        }
    }

    if (isset($_POST['pm_allow_attachments']) && $_POST['pm_allow_attachments'] == "Y") {
        $new_forum_settings['pm_allow_attachments'] = "Y";
    }else {
        $new_forum_settings['pm_allow_attachments'] = "N";
    }

    if (isset($_POST['allow_search_spidering']) && $_POST['allow_search_spidering'] == "Y") {
        $new_forum_settings['allow_search_spidering'] = "Y";
    }else {
        $new_forum_settings['allow_search_spidering'] = "N";
    }

    if (isset($_POST['guest_account_enabled']) && $_POST['guest_account_enabled'] == "Y") {
        $new_forum_settings['guest_account_enabled'] = "Y";
    }else {
        $new_forum_settings['guest_account_enabled'] = "N";
    }

    if (isset($_POST['auto_logon']) && $_POST['auto_logon'] == "Y") {
        $new_forum_settings['auto_logon'] = "Y";
    }else {
        $new_forum_settings['auto_logon'] = "N";
    }

    if (isset($_POST['attachments_enabled']) && $_POST['attachments_enabled'] == "Y") {
        $new_forum_settings['attachments_enabled'] = "Y";
    }else {
        $new_forum_settings['attachments_enabled'] = "N";
    }

    if (isset($_POST['attachment_dir']) && strlen(trim(_stripslashes($_POST['attachment_dir']))) > 0) {

        $new_forum_settings['attachment_dir'] = trim(_stripslashes($_POST['attachment_dir']));

        if (!(@is_dir($new_forum_settings['attachment_dir']))) {

            @mkdir($new_forum_settings['attachment_dir'], 0755);
            @chmod($new_forum_settings['attachment_dir'], 0777);
        }

        if (@$fp = fopen("{$new_forum_settings['attachment_dir']}/bh_attach_test", "w")) {

           fclose($fp);
           unlink("{$new_forum_settings['attachment_dir']}/bh_attach_test");

        }else {

           $error_html.= "<h2>{$lang['attachmentdirnotwritable']}</h2>\n";
           $valid = false;
        }

    }elseif (strtoupper($new_forum_settings['attachments_enabled']) == "Y") {

        $error_html = "<h2>{$lang['attachmentdirblank']}</h2>\n";
        $valid = false;
    }

    if (isset($_POST['attachments_max_user_space']) && is_numeric($_POST['attachments_max_user_space'])) {
        $new_forum_settings['attachments_max_user_space'] = ($_POST['attachments_max_user_space'] * 1024) * 1024;
    }else {
        $new_forum_settings['attachments_max_user_space'] = 1048576; // 1MB in bytes
    }

    if (isset($_POST['attachments_allow_embed']) && $_POST['attachments_allow_embed'] == "Y") {
        $new_forum_settings['attachments_allow_embed'] = "Y";
    }else {
        $new_forum_settings['attachments_allow_embed'] = "N";
    }

    if (isset($_POST['attachment_use_old_method']) && $_POST['attachment_use_old_method'] == "Y") {
        $new_forum_settings['attachment_use_old_method'] = "Y";
    }else {
        $new_forum_settings['attachment_use_old_method'] = "N";
    }

    if ($valid) {

        save_default_forum_settings($new_forum_settings);

        $uid = bh_session_get_value('UID');
        admin_addlog($uid, 0, 0, 0, 0, 0, 29);

        if (isset($_SERVER['SERVER_SOFTWARE']) && !strstr($_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS')) {
            header_redirect("./admin_default_forum_settings.php?webtag=$webtag&updated=true");

        }else {

            html_draw_top();

            // Try a Javascript redirect
            echo "<script language=\"javascript\" type=\"text/javascript\">\n";
            echo "<!--\n";
            echo "document.location.href = './admin_default_forum_settings.php?webtag=$webtag&amp;updated=true';\n";
            echo "//-->\n";
            echo "</script>";

            // If they're still here, Javascript's not working. Give up, give a link.
            echo "<div align=\"center\"><p>&nbsp;</p><p>&nbsp;</p>";
            echo "<p>{$lang['forumsettingsupdated']}</p>";

            form_quick_button("./admin_default_forum_settings.php", $lang['continue'], false, false, "_top");

            html_draw_bottom();
            exit;
        }
    }
}

// Start Output Here

html_draw_top("emoticons.js");

echo "<h1>{$lang['globalforumsettings']}</h1>\n";

// Any error messages to display?

if (!empty($error_html)) {
    echo $error_html;
}else if (isset($_GET['updated'])) {
    echo "<h2>{$lang['forumsettingsupdated']}</h2>\n";
}

echo "<br />\n";
echo "<form name=\"prefs\" action=\"admin_default_forum_settings.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" colspan=\"3\">{$lang['searchoptions']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"3\">\n";
echo "                    <table class=\"posthead\" width=\"100%\">\n";
echo "                      <tr>\n";
echo "                        <td width=\"200\">{$lang['minsearchwordlength']}:</td>\n";
echo "                        <td>", form_input_text("search_min_word_length", (isset($default_forum_settings['search_min_word_length'])) ? $default_forum_settings['search_min_word_length'] : "", 20, 32), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"20\">&nbsp;</td>\n";
echo "                  <td class=\"smalltext\">\n";
echo "                    <p class=\"smalltext\">{$lang['forum_settings_help_13']}</p>\n";
echo "                  </td>\n";
echo "                  <td width=\"20\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"3\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <br />\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" colspan=\"3\">{$lang['sessions']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"3\">\n";
echo "                    <table class=\"posthead\" width=\"100%\">\n";
echo "                      <tr>\n";
echo "                        <td width=\"300\">{$lang['sessioncutoffseconds']}:</td>\n";
echo "                        <td>", form_input_text("session_cutoff", (isset($default_forum_settings['session_cutoff'])) ? $default_forum_settings['session_cutoff'] : "", 30, 32), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"3\">\n";
echo "                    <table class=\"posthead\" width=\"100%\">\n";
echo "                      <tr>\n";
echo "                        <td width=\"300\">{$lang['activesessioncutoffseconds']}:</td>\n";
echo "                        <td>", form_input_text("active_sess_cutoff", (isset($default_forum_settings['active_sess_cutoff'])) ? $default_forum_settings['active_sess_cutoff'] : "", 30, 32), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"20\">&nbsp;</td>\n";
echo "                  <td class=\"smalltext\">\n";
echo "                    <p class=\"smalltext\">{$lang['forum_settings_help_14']}</p>\n";
echo "                    <p class=\"smalltext\">{$lang['forum_settings_help_15']}</p>\n";
echo "                  </td>\n";
echo "                  <td width=\"20\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"3\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <br />\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" colspan=\"3\">{$lang['newuserregistrations']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"3\">\n";
echo "                    <table class=\"posthead\" width=\"100%\">\n";
echo "                      <tr>\n";
echo "                        <td>", form_checkbox("allow_new_registrations", "Y", $lang['allownewuserregistrations'], (isset($default_forum_settings['allow_new_registrations'])) ? ($default_forum_settings['allow_new_registrations'] == 'Y') : false), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"20\">&nbsp;</td>\n";
echo "                  <td class=\"smalltext\">\n";
echo "                    <p class=\"smalltext\">{$lang['forum_settings_help_28']}</p>\n";
echo "                  </td>\n";
echo "                  <td width=\"20\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"3\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <br />\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" colspan=\"3\">{$lang['personalmessages']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"3\">\n";
echo "                    <table class=\"posthead\" width=\"100%\">\n";
echo "                      <tr>\n";
echo "                        <td>\n";
echo "                          <fieldset>\n";
echo "                            <legend>", form_checkbox("show_pms", "Y", $lang['enablepersonalmessages'], (isset($default_forum_settings['show_pms'])) ? ($default_forum_settings['show_pms'] == 'Y') : false), "</legend>\n";
echo "                            <table class=\"posthead\" width=\"100%\">\n";
echo "                              <tr>\n";
echo "                                <td class=\"admin_settings_text\">&nbsp;{$lang['pmusermessages']}:</td>\n";
echo "                                <td>", form_input_text("pm_max_user_messages", (isset($default_forum_settings['pm_max_user_messages'])) ? $default_forum_settings['pm_max_user_messages'] : "", 10, 32), "&nbsp;</td>\n";
echo "                              </tr>\n";
echo "                              <tr>\n";
echo "                                <td>", form_checkbox("pm_auto_prune_enabled", "Y", $lang['autopruneuserspmfoldersevery'], (isset($default_forum_settings['pm_auto_prune']) && $default_forum_settings['pm_auto_prune'] > 0) ? true : false), "&nbsp;</td>\n";
echo "                                <td>", form_dropdown_array('pm_auto_prune', array(1 => 10, 2 => 15, 3 => 30, 4 => 60), array(1 => 10, 2 => 15, 3 => 30, 4 => 60), (isset($default_forum_settings['pm_auto_prune']) ? ($default_forum_settings['pm_auto_prune'] > 0 ? $default_forum_settings['pm_auto_prune'] : $default_forum_settings['pm_auto_prune'] * -1) : 4)), " <span class=\"admin_settings_text\">{$lang['days']}</span>&nbsp;</td>\n";
echo "                              </tr>\n";
echo "                              <tr>\n";
echo "                                <td colspan=\"2\">", form_checkbox("pm_allow_attachments", "Y", $lang['allowpmstohaveattachments'], (isset($default_forum_settings['pm_allow_attachments'])) ? ($default_forum_settings['pm_allow_attachments'] == 'Y') : false), "&nbsp;</td>\n";
echo "                              </tr>\n";
echo "                            </table>\n";
echo "                          </fieldset>\n";
echo "                        </td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"20\">&nbsp;</td>\n";
echo "                  <td class=\"smalltext\">\n";
echo "                    <p class=\"smalltext\">{$lang['forum_settings_help_17']}</p>\n";
echo "                    <p class=\"smalltext\">{$lang['forum_settings_help_18']}</p>\n";
echo "                    <p class=\"smalltext\">{$lang['forum_settings_help_19']}</p>\n";
echo "                  </td>\n";
echo "                  <td width=\"20\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"3\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <br />\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" colspan=\"3\">{$lang['searchenginespidering']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"3\">\n";
echo "                    <table class=\"posthead\" width=\"100%\">\n";
echo "                      <tr>\n";
echo "                        <td>", form_checkbox("allow_search_spidering", "Y", $lang['allowsearchenginespidering'], (isset($default_forum_settings['allow_search_spidering'])) ? ($default_forum_settings['allow_search_spidering'] == 'Y') : false), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"20\">&nbsp;</td>\n";
echo "                  <td class=\"smalltext\">\n";
echo "                    <p class=\"smalltext\">{$lang['forum_settings_help_27']}</p>\n";
echo "                  </td>\n";
echo "                  <td width=\"20\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"3\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <br />\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" colspan=\"3\">{$lang['guestaccount']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"3\">\n";
echo "                    <table class=\"posthead\" width=\"100%\">\n";
echo "                      <tr>\n";
echo "                        <td>", form_checkbox("guest_account_enabled", "Y", $lang['enableguestaccount'], (isset($default_forum_settings['guest_account_enabled'])) ? ($default_forum_settings['guest_account_enabled'] == 'Y') : false), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"3\">\n";
echo "                    <table class=\"posthead\" width=\"100%\">\n";
echo "                      <tr>\n";
echo "                        <td>", form_checkbox("auto_logon", "Y", $lang['autologinguests'], (isset($default_forum_settings['auto_logon'])) ? ($default_forum_settings['auto_logon'] == 'Y') : false), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"20\">&nbsp;</td>\n";
echo "                  <td class=\"smalltext\">\n";
echo "                    <p class=\"smalltext\">{$lang['forum_settings_help_20']}</p>\n";
echo "                    <p class=\"smalltext\">{$lang['forum_settings_help_21']}</p>\n";
echo "                  </td>\n";
echo "                  <td width=\"20\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"3\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <br />\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" colspan=\"3\">{$lang['attachments']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"3\">\n";
echo "                    <table class=\"posthead\" width=\"100%\">\n";
echo "                      <tr>\n";
echo "                        <td>\n";
echo "                          <fieldset>\n";
echo "                            <legend>", form_checkbox("attachments_enabled", "Y", $lang['enableattachments'], (isset($default_forum_settings['attachments_enabled'])) ? ($default_forum_settings['attachments_enabled'] == 'Y') : false), "</legend>\n";
echo "                            <table class=\"posthead\" width=\"100%\">\n";
echo "                              <tr>\n";
echo "                                <td class=\"admin_settings_text\">&nbsp;{$lang['attachmentdir']}:</td>\n";
echo "                                <td>", form_input_text("attachment_dir", (isset($default_forum_settings['attachment_dir'])) ? $default_forum_settings['attachment_dir'] : ""), "&nbsp;</td>\n";
echo "                              </tr>\n";
echo "                              <tr>\n";
echo "                                <td class=\"admin_settings_text\">&nbsp;{$lang['userattachmentspace']}:</td>\n";
echo "                                <td>", form_input_text("attachments_max_user_space", (isset($default_forum_settings['attachments_max_user_space'])) ? ($default_forum_settings['attachments_max_user_space'] / 1024) / 1024 : "", 10, 32), "&nbsp;(MB)&nbsp;</td>\n";
echo "                              </tr>\n";
echo "                              <tr>\n";
echo "                                <td colspan=\"2\">", form_checkbox("attachments_allow_embed", "Y", $lang['allowembeddingofattachments'], (isset($default_forum_settings['attachments_allow_embed'])) ? ($default_forum_settings['attachments_allow_embed'] == 'Y') : false), "&nbsp;</td>\n";
echo "                              </tr>\n";
echo "                              <tr>\n";
echo "                                <td colspan=\"2\">", form_checkbox("attachment_use_old_method", "Y", $lang['usealtattachmentmethod'], (isset($default_forum_settings['attachments_use_old_method'])) ? ($default_forum_settings['attachments_use_old_method'] == 'Y') : false), "&nbsp;</td>\n";
echo "                              </tr>\n";
echo "                            </table>\n";
echo "                          </fieldset>\n";
echo "                        </td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"20\">&nbsp;</td>\n";
echo "                  <td class=\"smalltext\">\n";
echo "                    <p class=\"smalltext\">{$lang['forum_settings_help_22']}</p>\n";
echo "                    <p class=\"smalltext\">{$lang['forum_settings_help_23']}</p>\n";
echo "                    <p class=\"smalltext\">{$lang['forum_settings_help_24']}</p>\n";
echo "                    <p class=\"smalltext\">{$lang['forum_settings_help_25']}</p>\n";
echo "                    <p class=\"smalltext\">{$lang['forum_settings_help_26']}</p>\n";
echo "                  </td>\n";
echo "                  <td width=\"20\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"3\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td>&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td><p>{$lang['settingsaffectallforumswarning']}</p></td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td>&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"center\">", form_submit("submit", $lang['save']), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";

html_draw_bottom();

?>