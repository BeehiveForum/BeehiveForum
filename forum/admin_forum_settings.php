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

/* $Id: admin_forum_settings.php,v 1.1 2004-03-17 16:12:02 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

//Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum webtag and settings
$webtag = get_webtag();
$forum_settings = get_forum_settings();

// Enable the error handler
include_once("./include/errorhandler.inc.php");

include_once("./include/fixhtml.inc.php");
include_once("./include/form.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/post.inc.php");
include_once("./include/session.inc.php");
include_once("./include/user.inc.php");

if (!$user_sess = bh_session_check()) {

    $uri = "./logon.php?webtag={$webtag['WEBTAG']}&final_uri=". rawurlencode(get_request_uri());
    header_redirect($uri);
}

// Load the wordfilter for the current user

$user_wordfilter = load_wordfilter();

if (!(bh_session_get_value('STATUS') & USER_PERM_QUEEN)) {
    html_draw_top();
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;
}

$error_html = "";

if (isset($HTTP_POST_VARS['submit'])) {

    $valid = true;
    
    // Required Fields

    if (isset($HTTP_POST_VARS['nickname']) && trim($HTTP_POST_VARS['nickname']) != "") {
        $forum_prefs['NICKNAME'] = _stripslashes(trim($HTTP_POST_VARS['nickname']));       
    }else {
        $error_html.= "<h2>{$lang['nicknamerequired']}</h2>";
        $valid = false;
    }

    if (isset($HTTP_POST_VARS['email']) && trim($HTTP_POST_VARS['email']) != "") {
        $forum_prefs['EMAIL'] = _stripslashes(trim($HTTP_POST_VARS['email']));      
    }else {
        $error_html.= "<h2>{$lang['emailaddressrequired']}</h2>";
        $valid = false;
    }

    if (isset($HTTP_POST_VARS['dob_year']) && isset($HTTP_POST_VARS['dob_month']) && isset($HTTP_POST_VARS['dob_day']) && checkdate($HTTP_POST_VARS['dob_month'], $HTTP_POST_VARS['dob_day'], $HTTP_POST_VARS['dob_year'])) {

        $forum_prefs['DOB_DAY']   = _stripslashes(trim($HTTP_POST_VARS['dob_day']));
        $forum_prefs['DOB_MONTH'] = _stripslashes(trim($HTTP_POST_VARS['dob_month']));
        $forum_prefs['DOB_YEAR']  = _stripslashes(trim($HTTP_POST_VARS['dob_year']));
        
        $forum_prefs['DOB'] = "{$forum_prefs['DOB_YEAR']}-{$forum_prefs['DOB_MONTH']}-{$forum_prefs['DOB_DAY']}";
        $forum_prefs['DOB_BLANK_FIELDS'] = ($forum_prefs['DOB_YEAR'] == 0 || $forum_prefs['DOB_MONTH'] == 0 || $forum_prefs['DOB_DAY'] == 0) ? true : false;
        
    }else {
        $error_html.= "<h2>{$lang['birthdayrequired']}</h2>";
        $valid = false;
    }

    // Optional fields

    if (isset($HTTP_POST_VARS['firstname']) && trim($HTTP_POST_VARS['firstname']) != "") {
        $forum_prefs['FIRSTNAME'] = _stripslashes(trim($HTTP_POST_VARS['firstname']));       
    }else {
        $forum_prefs['FIRSTNAME'] = "";
    }

    if (isset($HTTP_POST_VARS['lastname']) && trim($HTTP_POST_VARS['lastname']) != "") {
        $forum_prefs['LASTNAME'] = _stripslashes(trim($HTTP_POST_VARS['lastname']));
    }else {
        $forum_prefs['LASTNAME'] = "";
    }

    if (isset($HTTP_POST_VARS['homepage_url']) && trim($HTTP_POST_VARS['homepage_url']) != "") {
        $forum_prefs['HOMEPAGE_URL'] = _stripslashes(trim($HTTP_POST_VARS['homepage_url']));
    }else {
        $forum_prefs['HOMEPAGE_URL'] = "";
    }

    if (isset($HTTP_POST_VARS['pic_url']) && trim($HTTP_POST_VARS['pic_url']) != "") {
        $forum_prefs['PIC_URL'] = _stripslashes(trim($HTTP_POST_VARS['pic_url']));
    }else {
        $forum_prefs['PIC_URL'] = "";
    }

    if ($valid) {

        // User's UID for updating with.

        $uid = bh_session_get_value('UID');

        // Update basic settings in USER table

        user_update($uid, $forum_prefs['NICKNAME'], $forum_prefs['EMAIL']);

        // Update USER_PREFS

        user_update_prefs($uid, $forum_prefs);

        // Reinitialize the User's Session to save them having to logout and back in

        bh_session_init($uid);

        // IIS bug prevents redirect at same time as setting cookies.

        if (isset($HTTP_SERVER_VARS['SERVER_SOFTWARE']) && !strstr($HTTP_SERVER_VARS['SERVER_SOFTWARE'], 'Microsoft-IIS')) {

            header_redirect("./edit_prefs.php?webtag={$webtag['WEBTAG']}&updated=true");

        }else {

            html_draw_top();

            // Try a Javascript redirect
            echo "<script language=\"javascript\" type=\"text/javascript\">\n";
            echo "<!--\n";
            echo "document.location.href = './edit_prefs.php?webtag={$webtag['WEBTAG']}&updated=true';\n";
            echo "//-->\n";
            echo "</script>";

            // If they're still here, Javascript's not working. Give up, give a link.
            echo "<div align=\"center\"><p>&nbsp;</p><p>&nbsp;</p>";
            echo "<p>{$lang['preferencesupdated']}</p>";

            form_quick_button("./edit_prefs.php?webtag={$webtag['WEBTAG']}", $lang['continue'], "", "", "_top");

            html_draw_bottom();
            exit;
        }
    }
}

// Get User Prefs

if (!isset($forum_prefs) || !is_array($forum_prefs)) $forum_prefs = array();
$forum_prefs = array_merge(user_get(bh_session_get_value('UID')), $forum_prefs);
$forum_prefs = array_merge(user_get_prefs(bh_session_get_value('UID')), $forum_prefs);

// Split the DOB into usable variables.

if (isset($forum_prefs['DOB']) && preg_match("/\d{4,}-\d{2,}-\d{2,}/", $forum_prefs['DOB'])) {
    list($forum_prefs['DOB_YEAR'], $forum_prefs['DOB_MONTH'], $forum_prefs['DOB_DAY']) = explode('-', $forum_prefs['DOB']);
    $forum_prefs['DOB_BLANK_FIELDS'] = ($forum_prefs['DOB_YEAR'] == 0 || $forum_prefs['DOB_MONTH'] == 0 || $forum_prefs['DOB_DAY'] == 0) ? true : false;
}else {
    $forum_prefs['DOB_YEAR']  = 0;
    $forum_prefs['DOB_MONTH'] = 0;
    $forum_prefs['DOB_DAY']   = 0;
    $forum_prefs['DOB_BLANK_FIELDS'] = true;
}

// Start Output Here

html_draw_top();

echo "<h1>Forum Settings</h1>\n";

// Any error messages to display?

if (!empty($error_html)) {
    echo $error_html;
}else if (isset($HTTP_GET_VARS['updated'])) {
    echo "<h2>{$lang['preferencesupdated']}</h2>\n";
}

echo "<br />\n";
echo "<form name=\"prefs\" action=\"edit_prefs.php?webtag={$webtag['WEBTAG']}\" method=\"post\" target=\"_self\">\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" colspan=\"2\">Main Settings</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"200\">Forum Name:</td>\n";
echo "                  <td>", form_input_text("forum_name", (isset($forum_prefs['forum_name']) ? $forum_prefs['forum_name'] : ""), 45, 32), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"200\">Forum Email:</td>\n";
echo "                  <td>", form_input_text("forum_email", (isset($forum_prefs['forum_email']) ? $forum_prefs['forum_email'] : ""), 45, 80), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"2\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"200\">Default Style:</td>\n";
echo "                  <td>", form_input_text("default_style", (isset($forum_prefs['default_style']) ? $forum_prefs['default_style'] : ""), 45, 32), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"200\">Default Language:</td>\n";
echo "                  <td>", form_input_text("default_language", (isset($forum_prefs['default_language']) ? $forum_prefs['default_language'] : ""), 45, 32), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"2\">&nbsp;</td>\n";
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
echo "            <td class=\"posthead\" width=\"100%\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" colspan=\"2\">Error Handler</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>", form_checkbox("show_friendly_errors", "Y", "Show Friendly Error Messages", (isset($forum_prefs['forum_name']) && $forum_prefs['forum_name'] == "Y") ? true : false), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>&nbsp;</td>\n";
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
echo "                  <td class=\"subhead\" colspan=\"2\">GZIP Compression</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>\n";
echo "                    <fieldset>\n";
echo "                      <legend>", form_checkbox("gzip_compress_output", "Y", "Compress pages using GZIP", (isset($forum_prefs['gzip_compress_output']) && $forum_prefs['gzip_compress_output'] == "Y") ? true : false), "</legend>\n";
echo "                        &nbsp;GZIP Compression Level: ", form_dropdown_array("gzip_compress_level", range(1, 9), range(1, 9), (isset($forum_prefs['gzip_compress_output']) ? $forum_prefs['gzip_compress_output'] : 1)), "\n";
echo "                    </fieldset>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>&nbsp;</td>\n";
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
echo "                  <td class=\"subhead\" colspan=\"2\">Cookie Options</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"200\">Cookie Domain:</td>\n";
echo "                  <td>", form_input_text("cookie_domain", (isset($forum_prefs['cookie_domain']) ? $forum_prefs['cookie_domain'] : $HTTP_SERVER_VARS['HTTP_HOST']), 45, 32), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"2\">&nbsp;</td>\n";
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
echo "                  <td class=\"subhead\" colspan=\"2\">Post Options</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"2\">\n";
echo "                    <fieldset>\n";
echo "                      <legend>", form_checkbox("allow_post_editing", "Y", "Allow Post Editing", (isset($forum_prefs['allow_post_editing']) && $forum_prefs['allow_post_editing'] == "Y") ? true : false), "</legend>\n";
echo "                        &nbsp;Post Edit Timeout: ", form_input_text("post_edit_time", (isset($forum_prefs['post_edit_time']) ? $forum_prefs['post_edit_time'] : "0"), 20, 32), "\n";
echo "                    </fieldset>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"2\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"200\">Maximum Post Length:</td>\n";
echo "                  <td>", form_input_text("maximum_post_length", (isset($forum_prefs['maximum_post_length']) ? $forum_prefs['maximum_post_length'] : "6226"), 20, 32), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"2\">&nbsp;</td>\n";
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
echo "                  <td class=\"subhead\" colspan=\"2\">Polls</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"2\">", form_checkbox("allow_polls", "Y", "Allow creation of polls", (isset($forum_prefs['allow_polls']) && $forum_prefs['allow_polls'] == "Y") ? true : false), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>&nbsp;</td>\n";
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
echo "                  <td class=\"subhead\" colspan=\"2\">Search Options</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"200\">Min search word length:</td>\n";
echo "                  <td>", form_input_text("search_min_word_length", (isset($forum_prefs['search_min_word_length']) ? $forum_prefs['search_min_word_length'] : "3"), 20, 32), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>&nbsp;</td>\n";
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
echo "                  <td class=\"subhead\" colspan=\"2\">Sessions</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"300\">Session cut off (seconds):</td>\n";
echo "                  <td>", form_input_text("session_cutoff", (isset($forum_prefs['session_cutoff']) ? $forum_prefs['session_cutoff'] : "86400"), 30, 32), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"300\">Active session cut off (seconds):</td>\n";
echo "                  <td>", form_input_text("active_sess_cutoff", (isset($forum_prefs['active_sess_cutoff']) ? $forum_prefs['active_sess_cutoff'] : "900"), 30, 32), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>&nbsp;</td>\n";
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
echo "                  <td class=\"subhead\" colspan=\"2\">Stats</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>", form_checkbox("show_stats", "Y", "Enable Stats Display at bottom of message pane", (isset($forum_prefs['show_stats']) && $forum_prefs['show_stats'] == "Y") ? true : false), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>&nbsp;</td>\n";
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
echo "                  <td class=\"subhead\" colspan=\"2\">Personal Messages</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>", form_checkbox("show_pms", "Y", "Enable Personal Messages", (isset($forum_prefs['show_pms']) && $forum_prefs['show_pms'] == "Y") ? true : false), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>", form_checkbox("pm_allow_attachments", "Y", "Allow Personal Messages to have attachments", (isset($forum_prefs['pm_allow_attachments']) && $forum_prefs['pm_allow_attachments'] == "Y") ? true : false), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>&nbsp;</td>\n";
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
echo "                  <td class=\"subhead\" colspan=\"2\">Guest Account</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>", form_checkbox("guest_account_enabled", "Y", "Enable Guest Account", (isset($forum_prefs['auto_logon']) && $forum_prefs['guest_account_enabled'] == "Y") ? true : false), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>", form_checkbox("auto_logon", "Y", "Automatically Login Guests", (isset($forum_prefs['auto_logon']) && $forum_prefs['auto_logon'] == "Y") ? true : false), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>&nbsp;</td>\n";
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
echo "                  <td class=\"subhead\" colspan=\"2\">Attachments</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"2\">\n";
echo "                    <fieldset>\n";
echo "                      <legend>", form_checkbox("attachments_enabled", "Y", "Enable Attachments", (isset($forum_prefs['attachments_enabled']) && $forum_prefs['attachments_enabled'] == "Y") ? true : false), "</legend>\n";
echo "                      <table class=\"posthead\" width=\"100%\">\n";
echo "                        <tr>\n";
echo "                          <td>&nbsp;Attachment Dir:</td>\n";
echo "                          <td>", form_input_text("attachment_dir", (isset($forum_prefs['attachment_dir']) ? $forum_prefs['attachment_dir'] : "attachments"), 45, 32), "&nbsp;</td>\n";
echo "                        </tr>\n";
echo "                        <tr>\n";
echo "                          <td colspan=\"2\">", form_checkbox("attachments_show_deleted", "Y", "Show Deleted Attachments in messages", (isset($forum_prefs['attachments_show_deleted']) && $forum_prefs['attachments_show_deleted'] == "Y") ? true : false), "&nbsp;</td>\n";
echo "                        </tr>\n";
echo "                        <tr>\n";
echo "                          <td colspan=\"2\">", form_checkbox("attachments_allow_embed", "Y", "Allow embedding of attachments in messages / signatures", (isset($forum_prefs['attachments_show_deleted']) && $forum_prefs['attachments_show_deleted'] == "Y") ? true : false), "&nbsp;</td>\n";
echo "                        </tr>\n";
echo "                        <tr>\n";
echo "                          <td colspan=\"2\">", form_checkbox("attachment_use_old_method", "Y", "Use Alternative attachment method", (isset($forum_prefs['attachment_use_old_method']) && $forum_prefs['attachment_use_old_method'] == "Y") ? true : false), "&nbsp;</td>\n";
echo "                        </tr>\n";
echo "                      </table>\n";
echo "                    </fieldset>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>&nbsp;</td>\n";
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
echo "      <td align=\"center\">", form_submit("submit", $lang['save']), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";

html_draw_bottom();

?>