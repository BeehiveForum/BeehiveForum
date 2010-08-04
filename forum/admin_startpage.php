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

/* $Id$ */

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

include_once(BH_INCLUDE_PATH. "admin.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "htmltools.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "post.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

// Get Webtag

$webtag = get_webtag();

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.

if (bh_session_user_banned()) {

    html_user_banned();
    exit;
}

// Check we have a webtag

if (!forum_check_webtag_available($webtag)) {
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Get the user's post page preferences.

$page_prefs = bh_session_get_post_page_prefs();

// Check to see if the user can access this page.

if (!(bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0))) {

    html_draw_top("title={$lang['error']}");
    html_error_msg($lang['accessdeniedexp']);
    html_draw_bottom();
    exit;
}

// Array to hold error messages

$error_msg_array = array();

// Check to see if we're submitting new page or retrieving the old one.

if (isset($_POST['t_content']) && strlen(trim(stripslashes_array($_POST['t_content']))) > 0) {
    $t_content = trim(stripslashes_array($_POST['t_content']));
}else {
    $t_content = forum_get_setting('start_page', false, '');
}

// Determine the toolbar type

$tool_type = POST_TOOLBAR_DISABLED;

if ($page_prefs & POST_TOOLBAR_DISPLAY) {
    $tool_type = POST_TOOLBAR_SIMPLE;
}else if ($page_prefs & POST_TINYMCE_DISPLAY) {
    $tool_type = POST_TOOLBAR_TINYMCE;
}

// Create a new instance of the Beehive editor.

$startpage_editor_message = new MessageText(POST_HTML_AUTO, $t_content, true, true);

// Submit code.

if (isset($_POST['save'])) {

    // New array of forum settings.
    $new_forum_settings = array('start_page' => $startpage_editor_message->getContent());
    
    // Save the settings.
    if (forum_save_settings($new_forum_settings)) {
    
        // Update the admin log.
        admin_add_log_entry(EDITED_START_PAGE);
        
        // Redirect back to self.
        header_redirect("admin_startpage.php?webtag=$webtag&updated=true");
        exit;
    }
        
    // Save failed. Show error message.
    $error_msg_array[] = $lang['startpageerror'];

}elseif (isset($_POST['upload'])) {

    // Check the temp file is set.
    if (isset($_FILES['cssfile']['tmp_name']) && strlen(trim($_FILES['cssfile']['tmp_name'])) > 0) {

        // Check for upload error.
        if (isset($_FILES['cssfile']['error']) && $_FILES['cssfile']['error'] != UPLOAD_ERR_OK) {

            // Upload failed. Don't bother going into detail.
            $error_msg_array[] = $lang['uploadcssfilefailed'];

        }else if (isset($_FILES['cssfile']['type']) && trim(stripslashes_array($_FILES['cssfile']['type'])) == 'text/css') {

            // Get path info for uploaded file.
            $path_parts = pathinfo($_FILES['cssfile']['name']);

            // Check the extension. This isn't fool proof, could be a renamed jpeg. Not sure
            // how to validate the content as CSS. Maybe try and parse it?
            if ((isset($path_parts['extension']) && $path_parts['extension'] == 'css')) {

                // Read the contents of the file.
                if (($start_page_css = @file_get_contents($_FILES['cssfile']['tmp_name']))) {
                    
                    // New array of forum settings.
                    $new_forum_settings = array('start_page_css' => $start_page_css);
                    
                    // Save the settings.
                    if (forum_save_settings($new_forum_settings)) {

                        // Update admin log.
                        admin_add_log_entry(EDITED_START_PAGE);
                        
                        // Redirect back to self.
                        header_redirect("admin_startpage.php?webtag=$webtag&uploaded=true");
                        exit;
                    }
                }
            }
            
            // Something went wrong above. Show Error message.
            $error_msg_array[] = $lang['uploadcssfilefailed'];
        
        } else {
        
            // File does not look like text/css
            $error_msg_array[] = $lang['invalidfiletypeerror'];
        }
    }
}

html_draw_top("title={$lang['admin']} - {$lang['editstartpage']}", "onunload=clearFocus()", "dictionary.js", "htmltools.js", 'class=window_title');

echo "<h1>{$lang['admin']} <img src=", style_image('separator.png'), " alt=\"\" border=\"0\" /> {$lang['editstartpage']}</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '700', 'center');

}elseif (isset($_GET['updated'])) {

    $start_page_link = sprintf("<a href=\"start_main.php?webtag=$webtag\" target=\"_blank\">%s</a>", $lang['viewupdatedstartpage']);
    html_display_success_msg(sprintf($lang['startpageupdated'], $start_page_link), '700', 'center');

}elseif (isset($_GET['uploaded'])) {

    $start_page_link = sprintf("<a href=\"start_main.php?webtag=$webtag\" target=\"_blank\">%s</a>", $lang['viewupdatedstartpage']);
    html_display_success_msg(sprintf($lang['cssfileuploaded'], $start_page_link), '700', 'center');
}

$startpage_editor = new TextAreaHTML("startpage");

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form accept-charset=\"utf-8\" name=\"startpage\" enctype=\"multipart/form-data\" method=\"post\" action=\"admin_startpage.php\">\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\">{$lang['startpage']}</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";

if ($tool_type <> POST_TOOLBAR_DISABLED) {

    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", $startpage_editor->toolbar(true), "</td>\n";
    echo "                      </tr>\n";

}else {

    $startpage_editor->set_tinymce(false);
}

echo "                      <tr>\n";
echo "                        <td align=\"left\">", $startpage_editor->textarea("t_content", $startpage_editor_message->getTidyContent(), 20, 80, false, false, 'admin_tools_textarea_large'), "</td>\n";
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
echo "  </table>\n";
echo "  <br />\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\">{$lang['uploadcssfile']}</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">{$lang['filename']}: ", form_input_file("cssfile", "", 45, 0), "</td>\n";
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
echo "      <td align=\"center\">", form_submit("upload", $lang['upload']), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";
echo "</div>\n";

html_draw_bottom();

?>