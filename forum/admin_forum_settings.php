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

/* $Id: admin_forum_settings.php,v 1.14 2004-03-27 21:56:17 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum webtag and settings
$webtag = get_webtag();
$forum_settings = get_forum_settings();

include_once("./include/admin.inc.php");
include_once("./include/config.inc.php");
include_once("./include/fixhtml.inc.php");
include_once("./include/form.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/post.inc.php");
include_once("./include/session.inc.php");
include_once("./include/user.inc.php");

if (!$user_sess = bh_session_check()) {

    if (isset($HTTP_SERVER_VARS["REQUEST_METHOD"]) && $HTTP_SERVER_VARS["REQUEST_METHOD"] == "POST") {
        
        if (perform_logon(false)) {
	    
	    html_draw_top();

            echo "<h1>{$lang['loggedinsuccessfully']}</h1>";
            echo "<div align=\"center\">\n";
	    echo "<p><b>{$lang['presscontinuetoresend']}</b></p>\n";

            $request_uri = get_request_uri();

            echo "<form method=\"post\" action=\"$request_uri\" target=\"_self\">\n";

            foreach($HTTP_POST_VARS as $key => $value) {
	        form_input_hidden($key, _htmlentities(_stripslashes($value)));
            }

	    echo form_submit(md5(uniqid(rand())), $lang['continue']), "&nbsp;";
            echo form_button(md5(uniqid(rand())), $lang['cancel'], "onclick=\"self.location.href='$request_uri'\""), "\n";
	    echo "</form>\n";
	    
	    html_draw_bottom();
	    exit;
	}

    }else {
        html_draw_top();
        draw_logon_form(false);
	html_draw_bottom();
	exit;
    }
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


$available_emots = array();
$emot_names = array();

if ($dir = @opendir('emoticons')) {
    while (($file = readdir($dir)) !== false) {
        if (is_dir("emoticons/$file") && $file != '.' && $file != '..' && $file != 'none') {
            if (@file_exists("./emoticons/$file/desc.txt")) {
                if ($fp = fopen("./emoticons/$file/desc.txt", "r")) {
                    $available_emots[] = $file;
                    $emot_names[] = _htmlentities(fread($fp, filesize("emoticons/$file/desc.txt")));
                    fclose($fp);
                }else {
                    $available_emots[] = $file;
                    $emot_names[] = $file;
                }
            }
        }
    }
    closedir($dir);
}

array_multisort($emot_names, $available_emots);

array_unshift($emot_names, "None");
array_unshift($available_emots, "none");


if (isset($HTTP_POST_VARS['submit'])) {

    $valid = true;

    if (isset($HTTP_POST_VARS['forum_name']) && strlen(trim($HTTP_POST_VARS['forum_name'])) > 0) {
        $new_forum_settings['forum_name'] = _htmlentities(trim($HTTP_POST_VARS['forum_name']));
    }else {
        $error_html = "<h2>{$lang['mustsupplyforumname']}</h2>\n";
        $valid = false;
    }
    
    if (isset($HTTP_POST_VARS['forum_email']) && strlen(trim($HTTP_POST_VARS['forum_email'])) > 0) {
        $new_forum_settings['forum_email'] = trim($HTTP_POST_VARS['forum_email']);
    }else {
        $error_html = "<h2>{$lang['mustsupplyforumemail']}</h2>\n";
        $valid = false;
    }

    if (isset($HTTP_POST_VARS['default_style']) && strlen(trim($HTTP_POST_VARS['default_style'])) > 0) {

        $new_forum_settings['default_style'] = trim($HTTP_POST_VARS['default_style']);
        
        if (!_in_array($new_forum_settings['default_style'], $available_styles)) {
        
            $error_html = "<h2>{$lang['unknownstylename']}</h2>\n";
            $valid = false;
        }
        
    }else {
        $error_html = "<h2>{$lang['mustchoosedefaultstyle']}</h2>\n";
        $valid = false;
    }

    if (isset($HTTP_POST_VARS['default_emoticons']) && strlen(trim($HTTP_POST_VARS['default_emoticons'])) > 0) {

        $new_forum_settings['default_emoticons'] = trim($HTTP_POST_VARS['default_emoticons']);
        
        if (!_in_array($new_forum_settings['default_emoticons'], $available_emots)) {
        
            $error_html = "<h2>{$lang['unknownemoticonsname']}</h2>\n";
            $valid = false;
        }
        
    }else {
        $error_html = "<h2>{$lang['mustchoosedefaultemoticons']}</h2>\n";
        $valid = false;
    }
    
    if (isset($HTTP_POST_VARS['default_language']) && strlen(trim($HTTP_POST_VARS['default_language'])) > 0) {
        $new_forum_settings['default_language'] = trim($HTTP_POST_VARS['default_language']);

        if (!_in_array($new_forum_settings['default_language'], $available_langs)) {
        
            $error_html = "<h2>{$lang['unknownlanguage']}</h2>\n";
            $valid = false;
        }        
        
    }else {
        $error_html = "<h2>{$lang['mustchoosedefaultlang']}</h2>\n";
        $valid = false;
    }
    
    if (isset($HTTP_POST_VARS['show_friendly_errors']) && $HTTP_POST_VARS['show_friendly_errors'] == "Y") {
        $new_forum_settings['show_friendly_errors'] = "Y";
    }else {
        $new_forum_settings['show_friendly_errors'] = "N";
    }
    
    if (isset($HTTP_POST_VARS['gzip_compress_output']) && $HTTP_POST_VARS['gzip_compress_output'] == "Y") {
        $new_forum_settings['gzip_compress_output'] = "Y";
    }else {
        $new_forum_settings['gzip_compress_output'] = "N";
    }
    
    if (isset($HTTP_POST_VARS['gzip_compress_level']) && is_numeric($HTTP_POST_VARS['gzip_compress_level'])) {
        if ($HTTP_POST_VARS['gzip_compress_level'] > 0 && $HTTP_POST_VARS['gzip_compress_level'] < 10) {
            $new_forum_settings['gzip_compress_level'] = $HTTP_POST_VARS['gzip_compress_level'];
        }else {
            $HTTP_POST_VARS['gzip_compress_level'] = 1;
        }
    }else {
        $new_forum_settings['gzip_compress_level'] = 1;
    }
    
    if (isset($HTTP_POST_VARS['cookie_domain']) && strlen(trim($HTTP_POST_VARS['cookie_domain'])) > 0) {
        $new_forum_settings['cookie_domain'] = trim($HTTP_POST_VARS['cookie_domain']);
    }else {
        $new_forum_settings['cookie_domain'] = "";
    }
    
    if (isset($HTTP_POST_VARS['allow_post_editing']) && $HTTP_POST_VARS['allow_post_editing'] == "Y") {
        $new_forum_settings['allow_post_editing'] = "Y";
    }else {
        $new_forum_settings['allow_post_editing'] = "N";
    }
    
    if (isset($HTTP_POST_VARS['post_edit_time']) && is_numeric($HTTP_POST_VARS['post_edit_time'])) {
        $new_forum_settings['post_edit_time'] = $HTTP_POST_VARS['post_edit_time'];
    }else {
        $new_forum_settings['post_edit_time'] = 0;
    }
    
    if (isset($HTTP_POST_VARS['maximum_post_length']) && is_numeric($HTTP_POST_VARS['maximum_post_length'])) {
        $new_forum_settings['maximum_post_length'] = $HTTP_POST_VARS['maximum_post_length'];
    }else {
        $new_forum_settings['maximum_post_length'] = 6226;
    }
    
    if (isset($HTTP_POST_VARS['allow_polls']) && $HTTP_POST_VARS['allow_polls'] == "Y") {
        $new_forum_settings['allow_polls'] = "Y";
    }else {
        $new_forum_settings['allow_polls'] = "N";
    }
    
    if (isset($HTTP_POST_VARS['search_min_word_length']) && is_numeric($HTTP_POST_VARS['search_min_word_length'])) {
        $new_forum_settings['search_min_word_length'] = $HTTP_POST_VARS['search_min_word_length'];
    }else {
        $new_forum_settings['search_min_word_length'] = 3;
    }
    
    if (isset($HTTP_POST_VARS['session_cutoff']) && is_numeric($HTTP_POST_VARS['session_cutoff'])) {
        $new_forum_settings['session_cutoff'] = $HTTP_POST_VARS['session_cutoff'];
    }else {
        $new_forum_settings['session_cutoff'] = 86400;
    }
    
    if (isset($HTTP_POST_VARS['active_sess_cutoff']) && is_numeric($HTTP_POST_VARS['active_sess_cutoff'])) {
        if ($HTTP_POST_VARS['active_sess_cutoff'] < $HTTP_POST_VARS['session_cutoff']) {
            $new_forum_settings['active_sess_cutoff'] = $HTTP_POST_VARS['active_sess_cutoff'];
        }else {
            $error_html = "<h2>{$lang['activesessiongreaterthansession']}</h2>\n";
            $valid = false;
        }
    }else {
        $new_forum_settings['active_sess_cutoff'] = 900;
    }
    
    if (isset($HTTP_POST_VARS['show_stats']) && $HTTP_POST_VARS['show_stats'] == "Y") {
        $new_forum_settings['show_stats'] = "Y";
    }else {
        $new_forum_settings['show_stats'] = "N";
    }
    
    if (isset($HTTP_POST_VARS['show_pms']) && $HTTP_POST_VARS['show_pms'] == "Y") {
        $new_forum_settings['show_pms'] = "Y";
    }else {
        $new_forum_settings['show_pms'] = "N";
    }
    
    if (isset($HTTP_POST_VARS['pm_allow_attachments']) && $HTTP_POST_VARS['pm_allow_attachments'] == "Y") {
        $new_forum_settings['pm_allow_attachments'] = "Y";
    }else {
        $new_forum_settings['pm_allow_attachments'] = "N";
    }
    
    if (isset($HTTP_POST_VARS['guest_account_enabled']) && $HTTP_POST_VARS['guest_account_enabled'] == "Y") {
        $new_forum_settings['guest_account_enabled'] = "Y";
    }else {
        $new_forum_settings['guest_account_enabled'] = "N";
    }
    
    if (isset($HTTP_POST_VARS['auto_logon']) && $HTTP_POST_VARS['auto_logon'] == "Y") {
        $new_forum_settings['auto_logon'] = "Y";
    }else {
        $new_forum_settings['auto_logon'] = "N";
    }
    
    if (isset($HTTP_POST_VARS['attachments_enabled']) && $HTTP_POST_VARS['attachments_enabled'] == "Y") {
        $new_forum_settings['attachments_enabled'] = "Y";
    }else {
        $new_forum_settings['attachments_enabled'] = "N";
    }
    
    if (isset($HTTP_POST_VARS['attachment_dir']) && strlen(trim($HTTP_POST_VARS['attachment_dir'])) > 0) {

        $new_forum_settings['attachment_dir'] = trim($HTTP_POST_VARS['attachment_dir']);
        
        if (!(@is_dir($new_forum_settings['attachment_dir']))) {
            @mkdir($new_forum_settings['attachment_dir'], 0755);
            @chmod($new_forum_settings['attachment_dir'], 0777);
        }
            
        if ($fp = @fopen("{$new_forum_settings['attachment_dir']}/bh_attach_test", "w")) {
               
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
    
    if (isset($HTTP_POST_VARS['attachments_max_user_space']) && is_numeric($HTTP_POST_VARS['attachments_max_user_space'])) {
        $new_forum_settings['attachments_max_user_space'] = ($HTTP_POST_VARS['attachments_max_user_space'] * 1024) * 1024;
    }else {
        $new_forum_settings['attachments_max_user_space'] = 1048576; // 1MB in bytes
    }

    if (isset($HTTP_POST_VARS['attachments_show_deleted']) && $HTTP_POST_VARS['attachments_show_deleted'] == "Y") {
        $new_forum_settings['attachments_show_deleted'] = "Y";
    }else {
        $new_forum_settings['attachments_show_deleted'] = "N";
    }
    
    if (isset($HTTP_POST_VARS['attachments_allow_embed']) && $HTTP_POST_VARS['attachments_allow_embed'] == "Y") {
        $new_forum_settings['attachments_allow_embed'] = "Y";
    }else {
        $new_forum_settings['attachments_allow_embed'] = "N";
    }
    
    if (isset($HTTP_POST_VARS['attachment_use_old_method']) && $HTTP_POST_VARS['attachment_use_old_method'] == "Y") {
        $new_forum_settings['attachment_use_old_method'] = "Y";
    }else {
        $new_forum_settings['attachment_use_old_method'] = "N";
    }
    
    if ($valid) {
    
        save_forum_settings($new_forum_settings);
        
        $uid = bh_session_get_value('UID');        
        admin_addlog($uid, 0, 0, 0, 0, 0, 29);
        
        if (isset($HTTP_SERVER_VARS['SERVER_SOFTWARE']) && !strstr($HTTP_SERVER_VARS['SERVER_SOFTWARE'], 'Microsoft-IIS')) {

            header_redirect("./admin_forum_settings.php?webtag={$webtag['WEBTAG']}&updated=true");

        }else {

            html_draw_top();

            // Try a Javascript redirect
            echo "<script language=\"javascript\" type=\"text/javascript\">\n";
            echo "<!--\n";
            echo "document.location.href = './admin_forum_settings.php?webtag={$webtag['WEBTAG']}&updated=true';\n";
            echo "//-->\n";
            echo "</script>";

            // If they're still here, Javascript's not working. Give up, give a link.
            echo "<div align=\"center\"><p>&nbsp;</p><p>&nbsp;</p>";
            echo "<p>{$lang['forumsettingsupdated']}</p>";

            form_quick_button("./admin_forum_settings.php", $lang['continue'], false, false, "_top");

            html_draw_bottom();
            exit;
        }
    }            
}

// Start Output Here

html_draw_top("emoticons.js");

echo "<h1>Forum Settings</h1>\n";

// Any error messages to display?

if (!empty($error_html)) {
    echo $error_html;
}else if (isset($HTTP_GET_VARS['updated'])) {
    echo "<h2>{$lang['forumsettingsupdated']}</h2>\n";
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
echo "                  <td class=\"subhead\" colspan=\"2\">{$lang['mainsettings']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"200\">{$lang['forumname']}:</td>\n";
echo "                  <td>", form_input_text("forum_name", forum_get_setting('forum_name', false, 'A Beehive Forum'), 45, 32), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"200\">{$lang['forumemail']}:</td>\n";
echo "                  <td>", form_input_text("forum_email", forum_get_setting('forum_email', false, 'admin@abeehiveforum.net'), 45, 80), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"2\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"200\">{$lang['defaultstyle']}:</td>\n";
      
foreach ($available_styles as $key => $style) {
    if (strtolower($style) == strtolower(forum_get_setting('default_style'))) {
        break;
    }
}
      
echo "                  <td>", form_dropdown_array("default_style", $available_styles, $style_names, $available_styles[$key]), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"200\">{$lang['defaultemoticons']} ";
echo "[<a href=\"javascript:void(0);\" onclick=\"openEmoticons('','{$webtag['WEBTAG']}')\" target=\"_self\">{$lang['preview']}</a>]:</td>\n";
      
foreach ($available_emots as $key => $emots) {
    if (strtolower($emots) == strtolower(forum_get_setting('default_emoticons'))) {
        break;
    }
}
      
echo "                  <td>", form_dropdown_array("default_emoticons", $available_emots, $emot_names, $available_emots[$key]), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"200\">{$lang['defaultlanguage']}:</td>\n";
echo "                  <td>", form_dropdown_array("default_language", $available_langs, $available_langs, forum_get_setting('default_language', false, 'en')), "</td>\n";
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
echo "                  <td class=\"subhead\" colspan=\"3\">{$lang['errorhandler']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"3\">", form_checkbox("show_friendly_errors", "Y", $lang['showfriendlyerrors'], forum_get_setting('show_friendly_errors', 'Y', false)), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"20\">&nbsp;</td>\n";
echo "                  <td class=\"smalltext\"><p class=\"smalltext\">{$lang['forum_settings_help_1']}</p></td>\n";
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
echo "                  <td class=\"subhead\" colspan=\"3\">{$lang['gzipcompression']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"3\">\n";
echo "                    <table class=\"posthead\" width=\"100%\">\n";
echo "                      <tr>\n";
echo "                        <td>\n";
echo "                          <fieldset>\n";
echo "                            <legend>", form_checkbox("gzip_compress_output", "Y", $lang['compresspagesusinggzip'], forum_get_setting('gzip_compress_output', 'Y', false)), "</legend>\n";
echo "                            &nbsp;{$lang['gzipcompressionlevel']}: ", form_dropdown_array("gzip_compress_level", range(1, 9), range(1, 9), forum_get_setting('gzip_compress_level', false, 1)), "\n";
echo "                          </fieldset>\n";
echo "                        </td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"20\">&nbsp;</td>\n";
echo "                  <td class=\"smalltext\">\n";
echo "                    <p class=\"smalltext\">{$lang['forum_settings_help_2']}</p>\n";
echo "                    <p class=\"smalltext\">{$lang['forum_settings_help_3']}</p>\n";
echo "                    <p class=\"smalltext\">{$lang['forum_settings_help_4']}</p>\n";
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
echo "                  <td class=\"subhead\" colspan=\"3\">{$lang['cookieoptions']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"3\">\n";
echo "                    <table class=\"posthead\" width=\"100%\">\n";
echo "                      <tr>\n";
echo "                        <td>{$lang['cookiedomain']}:</td>\n";
echo "                        <td colspan=\"2\">", form_input_text("cookie_domain", forum_get_setting('cookie_domain', false, $HTTP_SERVER_VARS['HTTP_HOST']), 45, 32), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"20\">&nbsp;</td>\n";
echo "                  <td class=\"smalltext\">\n";
echo "                    <p class=\"smalltext\">{$lang['forum_settings_help_5']}</p>\n";
echo "                    <p class=\"smalltext\">{$lang['forum_settings_help_6']}</p>\n";
echo "                    <p class=\"smalltext\">{$lang['forum_settings_help_7']}</p>\n";
echo "                    <p class=\"smalltext\">{$lang['forum_settings_help_8']}</p>\n";
echo "                    <p class=\"smalltext\">{$lang['forum_settings_help_9']}</p>\n";
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
echo "                  <td class=\"subhead\" colspan=\"3\">{$lang['postoptions']}</td>\n";
echo "                </tr>\n";
echo "                  <td colspan=\"3\">\n";
echo "                    <table class=\"posthead\" width=\"100%\">\n";
echo "                      <tr>\n";
echo "                        <td>\n";
echo "                          <fieldset>\n";
echo "                            <legend>", form_checkbox("allow_post_editing", "Y", $lang['allowpostoptions'], forum_get_setting('allow_post_editing', 'Y', false)), "</legend>\n";
echo "                            &nbsp;{$lang['postedittimeout']}: ", form_input_text("post_edit_time", forum_get_setting('post_edit_time', false, '0'), 20, 32), "\n";
echo "                          </fieldset>\n";
echo "                        </td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"3\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"20\">&nbsp;</td>\n";
echo "                  <td>\n";
echo "                    <table class=\"posthead\" width=\"100%\">\n";
echo "                      <tr>\n";
echo "                        <td>{$lang['maximumpostlength']}:</td>\n";
echo "                        <td>", form_input_text("maximum_post_length", forum_get_setting('maximum_post_length', false, '6226'), 45, 32), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                  <td width=\"20\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"20\">&nbsp;</td>\n";
echo "                  <td class=\"smalltext\">\n";
echo "                    <p class=\"smalltext\">{$lang['forum_settings_help_10']}</p>\n";
echo "                    <p class=\"smalltext\">{$lang['forum_settings_help_11']}</p>\n";
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
echo "                  <td class=\"subhead\" colspan=\"3\">{$lang['polls']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"3\">", form_checkbox("allow_polls", "Y", $lang['allowcreationofpolls'], forum_get_setting('allow_polls', 'Y', false)), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"20\">&nbsp;</td>\n";
echo "                  <td class=\"smalltext\">\n";
echo "                    <p class=\"smalltext\">{$lang['forum_settings_help_12']}</p>\n";
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
echo "                  <td class=\"subhead\" colspan=\"3\">{$lang['searchoptions']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"3\">\n";
echo "                    <table class=\"posthead\" width=\"100%\">\n";
echo "                      <tr>\n";
echo "                        <td width=\"200\">{$lang['minsearchwordlength']}:</td>\n";
echo "                        <td>", form_input_text("search_min_word_length", forum_get_setting('search_min_word_length', false, '3'), 20, 32), "&nbsp;</td>\n";
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
echo "                        <td>", form_input_text("session_cutoff", forum_get_setting('session_cutoff', false, '86400'), 30, 32), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"3\">\n";
echo "                    <table class=\"posthead\" width=\"100%\">\n";
echo "                      <tr>\n";
echo "                        <td width=\"300\">{$lang['activesessioncutoffseconds']}:</td>\n";
echo "                        <td>", form_input_text("active_sess_cutoff", forum_get_setting('active_sess_cutoff', false, '900'), 30, 32), "&nbsp;</td>\n";
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
echo "                  <td class=\"subhead\" colspan=\"3\">{$lang['stats']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"3\">\n";
echo "                    <table class=\"posthead\" width=\"100%\">\n";
echo "                      <tr>\n";
echo "                        <td>", form_checkbox("show_stats", "Y", $lang['enablestatsdisplay'], forum_get_setting('show_stats', 'Y', false)), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"20\">&nbsp;</td>\n";
echo "                  <td class=\"smalltext\">\n";
echo "                    <p class=\"smalltext\">{$lang['forum_settings_help_16']}</p>\n";
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
echo "                        <td>", form_checkbox("show_pms", "Y", $lang['enablepersonalmessages'], forum_get_setting('show_pms', 'Y', false)), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"3\">\n";
echo "                    <table class=\"posthead\" width=\"100%\">\n";
echo "                      <tr>\n";
echo "                        <td>", form_checkbox("pm_allow_attachments", "Y", $lang['allowpmstohaveattachments'], forum_get_setting('pm_allow_attachments', 'Y', false)), "&nbsp;</td>\n";
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
echo "                  <td class=\"subhead\" colspan=\"3\">{$lang['guestaccount']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"3\">\n";
echo "                    <table class=\"posthead\" width=\"100%\">\n";
echo "                      <tr>\n";
echo "                        <td>", form_checkbox("guest_account_enabled", "Y", $lang['enableguestaccount'], forum_get_setting('guest_account_enabled', 'Y', false)), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"3\">\n";
echo "                    <table class=\"posthead\" width=\"100%\">\n";
echo "                      <tr>\n";
echo "                        <td>", form_checkbox("auto_logon", "Y", $lang['autologinguests'], forum_get_setting('auto_logon', 'Y', false)), "&nbsp;</td>\n";
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
echo "                            <legend>", form_checkbox("attachments_enabled", "Y", $lang['enableattachments'], forum_get_setting('attachments_enabled', 'Y', false)), "</legend>\n";
echo "                            <table class=\"posthead\" width=\"100%\">\n";
echo "                              <tr>\n";
echo "                                <td>&nbsp;{$lang['attachmentdir']}:</td>\n";
echo "                                <td>", form_input_text("attachment_dir", forum_get_setting('attachment_dir', false, 'attachments'), 45, 32), "&nbsp;</td>\n";
echo "                              </tr>\n";
echo "                              <tr>\n";
echo "                                <td>&nbsp;{$lang['userattachmentspace']}:</td>\n";
echo "                                <td>", form_input_text("attachments_max_user_space", (forum_get_setting('attachments_max_user_space', false, 1048576) / 1024) / 1024, 10, 32), "&nbsp;(MB)&nbsp;</td>\n";
echo "                              </tr>\n";
echo "                              <tr>\n";
echo "                                <td colspan=\"2\">", form_checkbox("attachments_show_deleted", "Y", $lang['showdeletedattachments'], forum_get_setting('attachments_show_deleted', 'Y', false)), "&nbsp;</td>\n";
echo "                              </tr>\n";
echo "                              <tr>\n";
echo "                                <td colspan=\"2\">", form_checkbox("attachments_allow_embed", "Y", $lang['allowembeddingofattachments'], forum_get_setting('attachments_allow_embed', 'Y', false)), "&nbsp;</td>\n";
echo "                              </tr>\n";
echo "                              <tr>\n";
echo "                                <td colspan=\"2\">", form_checkbox("attachment_use_old_method", "Y", $lang['usealtattachmentmethod'], forum_get_setting('attachment_use_old_method', 'Y', false)), "&nbsp;</td>\n";
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