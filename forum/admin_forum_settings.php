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

/* $Id: admin_forum_settings.php,v 1.4 2004-03-17 22:21:20 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum webtag and settings
$webtag = get_webtag();
$forum_settings = get_forum_settings();

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

// Languages

$available_langs = lang_get_available(); // get list of available languages

// Styles

$available_styles = array();
$style_names = array();

if ($dir = @opendir('styles')) {
    while (($file = readdir($dir)) !== false) {
        if (is_dir("styles/$file") && $file != '.' && $file != '..') {
            if (@file_exists("./styles/$file/desc.txt")) {
                if ($fp = fopen("./styles/$file/desc.txt", "r")) {
                    $available_styles[] = $file;
                    $style_names[] = _htmlentities(fread($fp, filesize("styles/$file/desc.txt")));
                    fclose($fp);
                }else {
                    $available_styles[] = $file;
                    $style_names[] = $file;
                }
            }
        }
    }
    closedir($dir);
}

array_multisort($style_names, $available_styles);

if (isset($HTTP_POST_VARS['submit'])) {

    html_draw_top();
    echo "This doesn't do owt yet.";
    html_draw_bottom();
    exit;
}

// Start Output Here

html_draw_top();

echo "<h1>Forum Settings</h1>\n";

echo "<pre>\n";
print_r($forum_settings);
echo "</pre>\n";

// Any error messages to display?

if (!empty($error_html)) {
    echo $error_html;
}else if (isset($HTTP_GET_VARS['updated'])) {
    echo "<h2>{$lang['preferencesupdated']}</h2>\n";
}

echo "<br />\n";
echo "<form name=\"prefs\" action=\"admin_forum_settings.php?webtag={$webtag['WEBTAG']}\" method=\"post\" target=\"_self\">\n";
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
echo "                  <td>", form_input_text("forum_name", (isset($forum_settings['forum_name']) ? $forum_settings['forum_name'] : ""), 45, 32), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"200\">Forum Email:</td>\n";
echo "                  <td>", form_input_text("forum_email", (isset($forum_settings['forum_email']) ? $forum_settings['forum_email'] : ""), 45, 80), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"2\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"200\">Default Style:</td>\n";
      
foreach ($available_styles as $key => $style) {
    if (strtolower($style) == strtolower($forum_settings['default_style'])) {
        break;
    }
}
      
echo "                  <td>", form_dropdown_array("default_style", $available_styles, $style_names, $available_styles[$key]), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"200\">Default Language:</td>\n";
echo "                  <td>", form_dropdown_array("default_language", $available_langs, $available_langs, (isset($forum_settings['default_language']) ? $forum_settings['default_language'] : "en")), "</td>\n";
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
echo "                  <td>", form_checkbox("show_friendly_errors", "Y", "Show Friendly Error Messages", (isset($forum_settings['show_friendly_errors']) && $forum_settings['show_friendly_errors'] == "Y") ? true : false), "&nbsp;</td>\n";
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
echo "                      <legend>", form_checkbox("gzip_compress_output", "Y", "Compress pages using GZIP", (isset($forum_settings['gzip_compress_output']) && $forum_settings['gzip_compress_output'] == "Y") ? true : false), "</legend>\n";
echo "                        &nbsp;GZIP Compression Level: ", form_dropdown_array("gzip_compress_level", range(1, 9), range(1, 9), (isset($forum_settings['gzip_compress_output']) ? $forum_settings['gzip_compress_output'] : 1)), "\n";
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
echo "                  <td>", form_input_text("cookie_domain", (isset($forum_settings['cookie_domain']) ? $forum_settings['cookie_domain'] : $HTTP_SERVER_VARS['HTTP_HOST']), 45, 32), "&nbsp;</td>\n";
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
echo "                      <legend>", form_checkbox("allow_post_editing", "Y", "Allow Post Editing", (isset($forum_settings['allow_post_editing']) && $forum_settings['allow_post_editing'] == "Y") ? true : false), "</legend>\n";
echo "                        &nbsp;Post Edit Timeout: ", form_input_text("post_edit_time", (isset($forum_settings['post_edit_time']) ? $forum_settings['post_edit_time'] : "0"), 20, 32), "\n";
echo "                    </fieldset>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"2\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"200\">Maximum Post Length:</td>\n";
echo "                  <td>", form_input_text("maximum_post_length", (isset($forum_settings['maximum_post_length']) ? $forum_settings['maximum_post_length'] : "6226"), 20, 32), "&nbsp;</td>\n";
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
echo "                  <td colspan=\"2\">", form_checkbox("allow_polls", "Y", "Allow creation of polls", (isset($forum_settings['allow_polls']) && $forum_settings['allow_polls'] == "Y") ? true : false), "&nbsp;</td>\n";
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
echo "                  <td>", form_input_text("search_min_word_length", (isset($forum_settings['search_min_word_length']) ? $forum_settings['search_min_word_length'] : "3"), 20, 32), "&nbsp;</td>\n";
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
echo "                  <td>", form_input_text("session_cutoff", (isset($forum_settings['session_cutoff']) ? $forum_settings['session_cutoff'] : "86400"), 30, 32), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"300\">Active session cut off (seconds):</td>\n";
echo "                  <td>", form_input_text("active_sess_cutoff", (isset($forum_settings['active_sess_cutoff']) ? $forum_settings['active_sess_cutoff'] : "900"), 30, 32), "&nbsp;</td>\n";
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
echo "                  <td>", form_checkbox("show_stats", "Y", "Enable Stats Display at bottom of message pane", (isset($forum_settings['show_stats']) && $forum_settings['show_stats'] == "Y") ? true : false), "&nbsp;</td>\n";
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
echo "                  <td>", form_checkbox("show_pms", "Y", "Enable Personal Messages", (isset($forum_settings['show_pms']) && $forum_settings['show_pms'] == "Y") ? true : false), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>", form_checkbox("pm_allow_attachments", "Y", "Allow Personal Messages to have attachments", (isset($forum_settings['pm_allow_attachments']) && $forum_settings['pm_allow_attachments'] == "Y") ? true : false), "&nbsp;</td>\n";
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
echo "                  <td>", form_checkbox("guest_account_enabled", "Y", "Enable Guest Account", (isset($forum_settings['auto_logon']) && $forum_settings['guest_account_enabled'] == "Y") ? true : false), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>", form_checkbox("auto_logon", "Y", "Automatically Login Guests", (isset($forum_settings['auto_logon']) && $forum_settings['auto_logon'] == "Y") ? true : false), "&nbsp;</td>\n";
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
echo "                      <legend>", form_checkbox("attachments_enabled", "Y", "Enable Attachments", (isset($forum_settings['attachments_enabled']) && $forum_settings['attachments_enabled'] == "Y") ? true : false), "</legend>\n";
echo "                      <table class=\"posthead\" width=\"100%\">\n";
echo "                        <tr>\n";
echo "                          <td>&nbsp;Attachment Dir:</td>\n";
echo "                          <td>", form_input_text("attachment_dir", (isset($forum_settings['attachment_dir']) ? $forum_settings['attachment_dir'] : "attachments"), 45, 32), "&nbsp;</td>\n";
echo "                        </tr>\n";
echo "                        <tr>\n";
echo "                          <td colspan=\"2\">", form_checkbox("attachments_show_deleted", "Y", "Show Deleted Attachments in messages", (isset($forum_settings['attachments_show_deleted']) && $forum_settings['attachments_show_deleted'] == "Y") ? true : false), "&nbsp;</td>\n";
echo "                        </tr>\n";
echo "                        <tr>\n";
echo "                          <td colspan=\"2\">", form_checkbox("attachments_allow_embed", "Y", "Allow embedding of attachments in messages / signatures", (isset($forum_settings['attachments_show_deleted']) && $forum_settings['attachments_show_deleted'] == "Y") ? true : false), "&nbsp;</td>\n";
echo "                        </tr>\n";
echo "                        <tr>\n";
echo "                          <td colspan=\"2\">", form_checkbox("attachment_use_old_method", "Y", "Use Alternative attachment method", (isset($forum_settings['attachment_use_old_method']) && $forum_settings['attachment_use_old_method'] == "Y") ? true : false), "&nbsp;</td>\n";
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