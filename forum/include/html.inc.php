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

// We shouldn't be accessing this file directly.

if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

if (@file_exists(BH_INCLUDE_PATH. "config.inc.php")) {
    include_once(BH_INCLUDE_PATH. "config.inc.php");
}

if (@file_exists(BH_INCLUDE_PATH. "config-dev.inc.php")) {
    include_once(BH_INCLUDE_PATH. "config-dev.inc.php");
}

include_once(BH_INCLUDE_PATH. "adsense.inc.php");
include_once(BH_INCLUDE_PATH. "browser.inc.php");
include_once(BH_INCLUDE_PATH. "compat.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "fixhtml.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "htmltools.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "pm.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "server.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

function html_guest_error()
{
    $frame_top_target = html_get_top_frame_name();

    $lang = load_language_file();

    $final_uri = basename(get_request_uri());

    $popup_files_preg = get_available_js_popup_files_preg();

    $available_support_pages = get_available_support_files();
    $available_support_pages_preg = implode("|^", array_map('preg_quote_callback', $available_support_pages));

    if (preg_match("/^$popup_files_preg/", $final_uri) > 0) {

        html_draw_top("title={$lang['guesterror']}", 'pm_popup_disabled', 'robots=noindex,nofollow');
        html_error_msg($lang['guesterror'], $final_uri, 'post', array('close_popup' => $lang['close']));
        html_draw_bottom();

    }else if (preg_match("/^$available_support_pages_preg/", $final_uri) > 0) {

        html_draw_top("title={$lang['guesterror']}", 'pm_popup_disabled', 'robots=noindex,nofollow');
        html_error_msg($lang['guesterror']);
        html_draw_bottom();

    }else {

        html_draw_top("title={$lang['guesterror']}", 'pm_popup_disabled', 'robots=noindex,nofollow');
        html_error_msg($lang['guesterror'], 'logout.php', 'post', array('submit' => $lang['loginnow'], 'register' => $lang['register']), array('final_uri' => $final_uri), $frame_top_target);
        html_draw_bottom();
    }
}

function html_error_msg($error_msg, $href = false, $method = 'get', $button_array = false, $var_array = false, $target = "_self", $align = "left", $id = false)
{
     $lang = load_language_file();
     html_display_msg($lang['error'], $error_msg, $href, $method, $button_array, $var_array, $target, $align, $id);
}

function html_display_msg($header_text, $string_msg, $href = false, $method = 'get', $button_array = false, $var_array = false, $target = "_self", $align = "left", $id = false)
{
    $webtag = get_webtag();

    if (!is_string($header_text)) return;
    if (!is_string($string_msg)) return;

    $available_methods = array('get', 'post');
    if (!in_array($method, $available_methods)) $method = 'get';

    $available_alignments = array('left', 'center', 'right');
    if (!in_array($align, $available_alignments)) $align = 'left';

    echo "<h1>$header_text</h1>\n";
    echo "<br />\n";

    if (is_string($href) && strlen(trim($href)) > 0) {

        echo "<form accept-charset=\"utf-8\" action=\"$href\" method=\"$method\" target=\"$target\">\n";
        echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";

        if (is_array($var_array)) {

            echo "  ", form_input_hidden_array($var_array), "\n";
        }
    }

    echo "  <div align=\"$align\"", (!is_bool($id) ? " id=\"$id\"" : ""), ">\n";
    echo "    <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\" class=\"message_box\">\n";
    echo "      <tr>\n";
    echo "        <td align=\"left\">\n";
    echo "          <table class=\"box\" width=\"100%\">\n";
    echo "            <tr>\n";
    echo "              <td align=\"left\" class=\"posthead\">\n";
    echo "                <table class=\"posthead\" width=\"100%\">\n";
    echo "                  <tr>\n";
    echo "                    <td align=\"left\" class=\"subhead\">$header_text</td>\n";
    echo "                  </tr>\n";
    echo "                  <tr>\n";
    echo "                    <td align=\"center\">\n";
    echo "                      <table class=\"posthead\" width=\"95%\">\n";
    echo "                        <tr>\n";
    echo "                          <td align=\"left\">$string_msg</td>\n";
    echo "                        </tr>\n";
    echo "                      </table>\n";
    echo "                    </td>\n";
    echo "                  </tr>\n";
    echo "                  <tr>\n";
    echo "                    <td align=\"left\">&nbsp;</td>\n";
    echo "                  </tr>\n";
    echo "                </table>\n";
    echo "              </td>\n";
    echo "            </tr>\n";
    echo "          </table>\n";
    echo "        </td>\n";
    echo "      </tr>\n";
    echo "      <tr>\n";
    echo "        <td align=\"left\">&nbsp;</td>\n";
    echo "      </tr>\n";

    if (is_string($href) && strlen(trim($href)) > 0) {

        $button_html_array = array();

        if (is_array($button_array) && sizeof($button_array) > 0) {

            foreach ($button_array as $button_name => $button_label) {
                $button_html_array[] = form_submit(htmlentities_array($button_name), htmlentities_array($button_label));
            }
        }

        if (sizeof($button_html_array) > 0) {

            echo "      <tr>\n";
            echo "        <td align=\"center\">", implode("&nbsp;", $button_html_array), "</td>\n";
            echo "      </tr>\n";
        }
    }

    echo "    </table>\n";
    echo "  </div>\n";

    if (is_string($href) && strlen(trim($href)) > 0) {
        echo "</form>\n";
    }
}

function html_display_error_array($error_list_array, $width = '600', $align = 'center', $id = false)
{
    $lang = load_language_file();

    if (!preg_match('/[0-9]+%?/u', $width)) $width = '600';

    $error_list_array = array_filter($error_list_array, 'is_string');

    if (sizeof($error_list_array) < 1) return;

    $available_alignments = array('left', 'center', 'right');
    if (!in_array($align, $available_alignments)) $align = 'left';

    echo "<div align=\"$align\"", (!is_bool($id) ? " id=\"$id\"" : ""), ">\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"$width\" class=\"error_msg\">\n";
    echo "    <tr>\n";
    echo "      <td rowspan=\"2\" valign=\"top\" width=\"25\" class=\"error_msg_icon\"><img src=\"", style_image('error.png'), "\" width=\"15\" height=\"15\" alt=\"{$lang['error']}\" title=\"{$lang['error']}\" /></td>\n";
    echo "      <td class=\"error_msg_text\">{$lang['thefollowingerrorswereencountered']}</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td>\n";
    echo "        <ul>\n";
    echo "          <li>", implode("</li>\n        <li>", $error_list_array), "</li>\n";
    echo "        </ul>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</div>\n";
}

function html_display_success_msg($string_msg, $width = '600', $align = 'center', $id = false)
{
    $lang = load_language_file();

    if (!preg_match('/[0-9]+%?/u', $width)) $width = '600';

    if (!is_string($string_msg)) return;

    $available_alignments = array('left', 'center', 'right');
    if (!in_array($align, $available_alignments)) $align = 'left';

    echo "<div align=\"$align\"", (!is_bool($id) ? " id=\"$id\"" : ""), ">\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"$width\" class=\"success_msg\">\n";
    echo "    <tr>\n";
    echo "      <td valign=\"top\" width=\"25\" class=\"success_msg_icon\"><img src=\"", style_image('success.png'), "\" width=\"15\" height=\"15\" alt=\"{$lang['success']}\" title=\"{$lang['success']}\" /></td>\n";
    echo "      <td valign=\"top\" class=\"success_msg_text\">$string_msg</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</div>\n";
}

function html_display_error_msg($string_msg, $width = '600', $align = 'center', $id = false)
{
    $lang = load_language_file();

    if (!preg_match('/[0-9]+%?/u', $width)) $width = '600';

    if (!is_string($string_msg)) return;

    $available_alignments = array('left', 'center', 'right');
    if (!in_array($align, $available_alignments)) $align = 'left';

    echo "<div align=\"$align\"", (!is_bool($id) ? " id=\"$id\"" : ""), ">\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"$width\" class=\"error_msg\">\n";
    echo "    <tr>\n";
    echo "      <td valign=\"top\" width=\"25\" class=\"error_msg_icon\"><img src=\"", style_image('error.png'), "\" width=\"15\" height=\"15\" alt=\"{$lang['error']}\" title=\"{$lang['error']}\" /></td>\n";
    echo "      <td valign=\"top\" class=\"error_msg_text\">$string_msg</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</div>\n";
}

function html_display_warning_msg($string_msg, $width = '600', $align = 'center', $id = false)
{
    $lang = load_language_file();

    if (!preg_match('/[0-9]+%?/u', $width)) $width = '600';

    if (!is_string($string_msg)) return;

    $available_alignments = array('left', 'center', 'right');
    if (!in_array($align, $available_alignments)) $align = 'left';

    echo "<div align=\"$align\"", (!is_bool($id) ? " id=\"$id\"" : ""), ">\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"$width\" class=\"warning_msg\">\n";
    echo "    <tr>\n";
    echo "      <td valign=\"top\" width=\"25\" class=\"warning_msg_icon\"><img src=\"", style_image('warning.png'), "\" width=\"15\" height=\"15\" alt=\"{$lang['warning']}\" title=\"{$lang['warning']}\" /></td>\n";
    echo "      <td valign=\"top\" class=\"warning_msg_text\">$string_msg</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</div>\n";
}

function html_user_banned()
{
    header_server_error();
}

function html_user_require_approval()
{
    $lang = load_language_file();

    html_draw_top("title={$lang['approvalrequired']}", "robots=noindex,nofollow");
    html_error_msg($lang['userapprovalrequiredbeforeaccess']);
    html_draw_bottom();
}

function html_email_confirmation_error()
{
    $lang = load_language_file();

    if (($uid = bh_session_get_value('UID')) === false) return;

    $user_array = user_get($uid);

    html_draw_top("title={$lang['emailconfirmationrequired']}", "robots=noindex,nofollow");
    html_error_msg($lang['emailconfirmationrequiredbeforepost'], 'confirm_email.php', 'get', array('resend' => $lang['resendconfirmation']), array('uid' => $user_array['UID'], 'resend' => 'Y'));
    html_draw_bottom();
}

function html_message_type_error()
{
    $lang = load_language_file();

    html_draw_top("title={$lang['error']}");
    html_error_msg($lang['cannotpostthisthreadtype']);
    html_draw_bottom();
}

function html_get_top_page()
{
    $webtag = get_webtag();

    $forum_path = defined('BH_FORUM_PATH') ? BH_FORUM_PATH : '.';
    
    if (forum_check_webtag_available($webtag)) {

        if (($user_style = bh_session_get_value('STYLE')) === false) {
            $user_style = bh_getcookie("bh_{$webtag}_style", false, forum_get_setting('default_style'));
        }   
        
        if ($user_style !== false) {

            $user_style = basename($user_style);
            
            if (@is_dir("$forum_path/forums/$webtag/styles/$user_style") && @file_exists("$forum_path/forums/$webtag/styles/$user_style/top.php")) {
                return "$forum_path/forums/$webtag/styles/$user_style/top.php";
            }

            if (@is_dir("$forum_path/styles/$user_style") && @file_exists("$forum_path/styles/$user_style/top.php")) {
                return "$forum_path/styles/$user_style/top.php";
            }
        }

        if (@is_dir("$forum_path/forums/$webtag") && @file_exists("$forum_path/forums/$webtag/top.php")) {
            return "$forum_path/forums/$webtag/top.php";
        }
    }

    return "$forum_path/styles/top.php";
}

function html_get_style_sheet()
{
    $webtag = get_webtag();

    $forum_path = defined('BH_FORUM_PATH') ? BH_FORUM_PATH : '.';

    $script_filename = basename($_SERVER['PHP_SELF'], '.php');

    if (forum_check_webtag_available($webtag)) {

        if (($user_style = bh_session_get_value('STYLE')) === false) {
            $user_style = bh_getcookie("bh_{$webtag}_style", false, forum_get_setting('default_style'));
        }

        if ($user_style !== false) {

            $user_style = basename($user_style);

            if (@is_dir("$forum_path/forums/$webtag/styles/$user_style") && @file_exists("$forum_path/forums/$webtag/styles/$user_style/$script_filename.css")) {
                return "$forum_path/forums/$webtag/styles/$user_style/$script_filename.css";
            }

            if (@is_dir("$forum_path/forums/$webtag/styles/$user_style") && @file_exists("$forum_path/forums/$webtag/styles/$user_style/style.css")) {
                return "$forum_path/forums/$webtag/styles/$user_style/style.css";
            }
            
            if (@is_dir("$forum_path/styles/$user_style") && @file_exists("$forum_path/styles/$user_style/$script_filename.css")) {
                return "$forum_path/styles/$user_style/$script_filename.css";
            }

            if (@is_dir("$forum_path/styles/$user_style") && @file_exists("$forum_path/styles/$user_style/style.css")) {
                return "$forum_path/styles/$user_style/style.css";
            }            
        }

        if (@is_dir("$forum_path/forums/$webtag/styles") && @file_exists("$forum_path/forums/$webtag/styles/$script_filename.css")) {
            return "$forum_path/forums/$webtag/styles/$script_filename.css";
        }

        if (@is_dir("$forum_path/forums/$webtag/styles") && @file_exists("$forum_path/forums/$webtag/styles/style.css")) {
            return "$forum_path/forums/$webtag/styles/style.css";
        }
    }

    if (@is_dir("$forum_path/styles") && @file_exists("$forum_path/styles/$script_filename.css")) {
        return "$forum_path/styles/$script_filename.css";
    }

    if (@is_dir("$forum_path/styles") && @file_exists("$forum_path/styles/style.css")) {
        return "$forum_path/styles/style.css";
    }

    return false;
}

function html_get_emoticon_style_sheet()
{
    $webtag = get_webtag();

    $forum_path = defined('BH_FORUM_PATH') ? BH_FORUM_PATH : '.';

    if (forum_check_webtag_available($webtag)) {

        if (($user_emots = bh_session_get_value('EMOTICONS')) === false) {
            $user_emots = forum_get_setting('default_emoticons');
        }

        if ($user_emots !== false) {

            if (@is_dir("$forum_path/forums/$webtag/emoticons/$user_emots") && file_exists("$forum_path/forums/$webtag/emoticons/$user_emots/style.css")) {
                return "$forum_path/forums/$webtag/emoticons/$user_emots/style.css";
            }
            
            if (@is_dir("$forum_path/emoticons/$user_emots") && file_exists("$forum_path/emoticons/$user_emots/style.css")) {
                return "$forum_path/emoticons/$user_emots/style.css";
            }            
        }
    }

    if (($user_emots = bh_session_get_value('EMOTICONS')) === false) {
        $user_emots = forum_get_setting('default_emoticons');
    }
    
    if (@is_dir("$forum_path/emoticons/$user_emots") && file_exists("$forum_path/emoticons/$user_emots/style.css")) {
        return "$forum_path/emoticons/$user_emots/style.css";
    }            

    return false;
}

function html_get_start_page_style_sheet()
{
    $webtag = get_webtag(true);

    $forum_path = defined('BH_FORUM_PATH') ? BH_FORUM_PATH : '.';

    if (forum_check_webtag_available($webtag)) {

        if (($user_style = bh_session_get_value('STYLE')) === false) {
            $user_style = bh_getcookie("bh_{$webtag}_style", false, forum_get_setting('default_style'));
        }

        if ($user_style !== false) {

            $user_style = basename($user_style);

            if (@is_dir("$forum_path/forums/$webtag/styles/$user_style") && @file_exists("$forum_path/forums/$webtag/styles/$user_style/start_main_additional.css")) {
                return "$forum_path/forums/$webtag/styles/$user_style/start_main_additional.css";
            }
            
            if (@is_dir("$forum_path/styles/$user_style") && @file_exists("$forum_path/styles/$user_style/start_main_additional.css")) {
                return "$forum_path/styles/$user_style/start_main_additional.css";
            }            
        }

        if (@is_dir("$forum_path/forums/$webtag/styles") && @file_exists("$forum_path/forums/$webtag/styles/start_main_additional.css")) {
            return "$forum_path/forums/$webtag/styles/start_main_additional.css";
        }
    }

    if (@is_dir("$forum_path/styles") && @file_exists("$forum_path/styles/start_main_additional.css")) {
        return "$forum_path/styles/start_main_additional.css";
    }

    return false;
}

function html_get_forum_keywords()
{
    if (($forum_keywords = forum_get_setting('forum_keywords'))) {

        return $forum_keywords;
    }

    return "";
}

function html_get_forum_description()
{
    if (($forum_desc = forum_get_setting('forum_desc'))) {

        return $forum_desc;
    }

    return "";
}

function html_get_forum_content_rating()
{
    $content_ratings_array = array(FORUM_RATING_GENERAL    => 'General',
                                   FORUM_RATING_FOURTEEN   => '14 Years',
                                   FORUM_RATING_MATURE     => 'Mature',
                                   FORUM_RATING_RESTRICTED => 'Restricted');

    if (($forum_content_rating = forum_get_setting('forum_content_rating'))) {

        if (isset($content_ratings_array[$forum_content_rating])) {

            return $content_ratings_array[$forum_content_rating];
        }
    }

    return $content_ratings_array[FORUM_RATING_GENERAL];
}

function html_get_forum_email()
{
    if (($forum_email = forum_get_setting('forum_email'))) {

        return $forum_email;
    }

    return "";
}

function html_get_frame_name($basename)
{
    // Forum URL

    $forum_uri = html_get_forum_uri();

    // Get the webtag

    $webtag = get_webtag();

    // If webtag available add that to the hash.

    if (forum_check_webtag_available($webtag)) {

        $frame_md5_hash = md5(sprintf('%s-%s-%s', $forum_uri, $webtag, $basename));
        return sprintf('bh_frame_%s', preg_replace('/[^a-z]+/iu', '', $frame_md5_hash));
    }

    // No webtag just use forum URL and frame basename.

    $frame_md5_hash = md5(sprintf('%s-%s', $forum_uri, $basename));
    return sprintf('bh_frame_%s', preg_replace('/[^a-z]+/iu', '', $frame_md5_hash));
}

function html_get_top_frame_name()
{
    if (isset($GLOBALS['frame_top_target']) && strlen(trim($GLOBALS['frame_top_target'])) > 0) {
        return $GLOBALS['frame_top_target'];
    }

    return '_top';
}

function html_include_javascript($script_filepath)
{
    $path_parts = pathinfo($script_filepath);
    
    $seperator = strstr($script_filepath, '?') ? '&amp;' : '?';

    if ((preg_match('/\.min\.js$/', $script_filepath) < 1) && ($path_parts = pathinfo($script_filepath))) {

        if (array_keys_exist($path_parts, 'filename', 'extension', 'dirname')) {

            $script_min_filepath = sprintf('%s/%s.min.%s', $path_parts['dirname'], $path_parts['filename'], $path_parts['extension']);

            if (file_exists($script_min_filepath)) {

                $script_filepath = $script_min_filepath;
            }
        }
    }

    printf("<script type=\"text/javascript\" src=\"%s%s%s\"></script>\n", $script_filepath, $seperator, @filemtime($script_filepath));
}

function html_include_css($script, $id, $media = 'screen')
{
    $forum_path = defined('BH_FORUM_PATH') ? BH_FORUM_PATH : '.';

    $path_parts = pathinfo($script);
    
    $seperator = strstr($script, '?') ? '&' : '?';

    $minified_script = sprintf('%s/%s.min.%s', $path_parts['dirname'], $path_parts['filename'], $path_parts['extension']);
    
    $id = strlen(trim($id)) > 0 ? $id : form_unique_id('stylesheet');

    if (file_exists("$forum_path/$minified_script")) $script = $minified_script;
        
    printf("<link rel=\"stylesheet\" id=\"%s\" href=\"%s%s%s\" type=\"text/css\" media=\"%s\" />\n", $id, $script, $seperator, @filemtime($script), $media);
}

// Draws the top of the HTML page including DOCTYPE, head and body tags
//
// Usage:
//
//      html_draw_top() supports an unlimited argument count, which
//      allows you to load .js support files from Beehive's /js/
//      folder. For example:
//
//      html_draw_top("user_profile.js")
//
//      This will include openprofile.js as a
//      <script src="user_profile.js"> tag within the HTML output.
//
//      To retain the old functionality as well as offer all this
//      html_draw_top also supports 6 named arguments, which
//      you can use to alter the default page title, body class,
//      base target, meta 'robots' tag, and also specify functions to be
//      called by the browser in the body tag's onload and onunload
//      events. These have to be called in a specific manner.
//      For example:
//
//      html_draw_top("title=Navigation", "class=nav", "basetarget=_top");
//
//      This will set the title of the page to "Navigation" with the
//      body class set to "nav", and base target set to "_top".
//
//      For the onload event, you do the same as the title and
//      body_class named arguments, but you can include multiple
//      arguments which will all then be loaded for you. For example:
//
//      html_draw_top("onload=pm_notification()", "onload=hicky()");
//
//      You can also mix and match all of these arguments in any order
//      for example:
//
//      html_draw_top("onload=pm_notification();", "title=pm_example");
//
//      or
//
//      html_draw_top("class=nav", "openprofile.js");
//
// ====================================================================*/
//
// Notes:
//
//      html_draw_top will only use the first of each named argument
//      it encounters for title and class. Any subsequent named
//      arguments for these two values will be ignored.
//
//      For example:
//
//      html_draw_top("title=Beehive Forum", "title=Yo Mama");
//
//      This will result in the title being set to Beehive Forum and
//      the value Yo Mama being discarded by the function.
//
//      This functionality does not apply to the onload named argument
//      as that can accept more than one value to be included in the
//      body tag.
//
// ====================================================================*/
//
//      Stuck? Any questions? Ask Matt.


function html_draw_top()
{
    $lang = load_language_file();

    $arg_array = func_get_args();
    $meta_refresh_delay = false;
    $meta_refresh_url = false;

    $title = '';
    $body_class = '';
    $base_target = '';

    $robots = 'noindex,nofollow';

    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    $forum_path = defined('BH_FORUM_PATH') ? BH_FORUM_PATH : '.';

    $forum_name = forum_get_setting('forum_name', false, 'A Beehive Forum');

    $frame_set_html = false;

    $pm_popup_disabled = false;

    $func_matches = array();

    foreach ($arg_array as $key => $func_args) {

        if (preg_match('/^title=([^$]+)?$/Diu', $func_args, $func_matches) > 0) {
            if (strlen(trim($title)) < 1 && isset($func_matches[1])) $title = $func_matches[1];
            unset($arg_array[$key]);
        }

        if (preg_match('/^class=([^$]+)?$/Diu', $func_args, $func_matches) > 0) {
            if (strlen(trim($body_class)) < 1 && isset($func_matches[1])) $body_class = $func_matches[1];
            unset($arg_array[$key]);
        }

        if (preg_match('/^basetarget=([^$]+)?$/Diu', $func_args, $func_matches) > 0) {
            if (strlen(trim($base_target)) < 1 && isset($func_matches[1])) $base_target = $func_matches[1];
            unset($arg_array[$key]);
        }

        if (preg_match('/^onload=([^$]+)?$/Diu', $func_args, $func_matches) > 0) {
            unset($arg_array[$key]);
        }

        if (preg_match('/^onunload=([^$]+)?$/Diu', $func_args, $func_matches) > 0) {
            unset($arg_array[$key]);
        }

        if (preg_match('/^stylesheet=(([^:]+):([^$]+))?$/Diu', $func_args, $func_matches) > 0) {

            if (isset($func_matches[1]) && isset($func_matches[2])) {
                $stylesheet_array[] = array('filename' => $func_matches[1], 'media' => $func_matches[2]);
            }

            unset($arg_array[$key]);

        }elseif (preg_match('/^stylesheet=([^$]+)?$/Diu', $func_args, $func_matches) > 0) {

            if (isset($func_matches[1])) {
                $stylesheet_array[] = array('filename' => $func_matches[1], 'media' => 'screen');
            }

            unset($arg_array[$key]);
        }

        if (preg_match('/^refresh=(([^:]+):([^$]+))?$/Diu', $func_args, $func_matches) > 0) {

            if (isset($func_matches[1]) && is_numeric($func_matches[1])) {

                if (isset($func_matches[2])) {

                     $meta_refresh_delay = $func_matches[1];
                     $meta_refresh_url = basename($func_matches[2]);
                }
            }

            unset($arg_array[$key]);
        }

        if (preg_match('/^robots=([^$]+)?$/Diu', $func_args, $func_matches) > 0) {
            if (isset($func_matches[1])) $robots = $func_matches[1];
            unset($arg_array[$key]);
        }

        if (preg_match('/^frame_set_html$/Diu', $func_args, $func_matches) > 0) {
            $frame_set_html = true;
            unset($arg_array[$key]);
        }

        if (preg_match('/^resize_width=([^$]+)?$/Diu', $func_args, $func_matches) > 0) {
            if (isset($func_matches[1])) $resize_width = $func_matches[1];
            unset($arg_array[$key]);
        }

        if (preg_match('/^pm_popup_disabled$/Diu', $func_args, $func_matches) > 0) {
            $pm_popup_disabled = true;
            unset($arg_array[$key]);
        }
    }

    if (strlen(trim($body_class)) < 1) $body_class = false;
    if (strlen(trim($base_target)) < 1) $base_target = false;

    if (!isset($resize_width)) $resize_width = 0;

    $forum_keywords = html_get_forum_keywords();
    $forum_description = html_get_forum_description();
    $forum_content_rating = html_get_forum_content_rating();

    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

    if ($frame_set_html === false) {
        echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
    }else {
        echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Frameset//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd\">\n";
    }

    echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"{$lang['_isocode']}\" lang=\"{$lang['_isocode']}\" dir=\"{$lang['_textdir']}\">\n";
    echo "<head>\n";

    if (strlen(trim($title)) > 0) {
        echo "<title>", htmlentities($forum_name), " &raquo; ", htmlentities_array($title), "</title>\n";
    }else {
        echo "<title>", htmlentities($forum_name), "</title>\n";
    }

    echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />\n";
    echo "<meta name=\"generator\" content=\"Beehive Forum ", BEEHIVE_VERSION, "\" />\n";
    echo "<meta name=\"keywords\" content=\"$forum_keywords\" />\n";
    echo "<meta name=\"description\" content=\"$forum_description\" />\n";
    echo "<meta name=\"rating\" content=\"$forum_content_rating\" />\n";

    if (forum_get_setting('allow_search_spidering', 'N')) {

        echo "<meta name=\"robots\" content=\"noindex,nofollow\" />\n";

    }elseif (strlen(trim($robots)) > 0) {

        echo "<meta name=\"robots\" content=\"$robots\" />\n";
    }

    if ($meta_refresh_delay && $meta_refresh_url) {
        echo "<meta http-equiv=\"refresh\" content=\"{$meta_refresh_delay}; url={$meta_refresh_url}\" />\n";
    }

    if ((basename($_SERVER['PHP_SELF']) == "index.php") && bh_session_check(false, false)) {

        printf("<link rel=\"alternate\" type=\"application/rss+xml\" title=\"%s - %s\" href=\"%s/threads_rss.php?webtag=%s\" />\n", htmlentities_array($forum_name), htmlentities_array($lang['rssfeed']), $forum_path, $webtag);

        if (($folders_array = folder_get_available_details())) {

            foreach ($folders_array as $folder) {
                printf("<link rel=\"alternate\" type=\"application/rss+xml\" title=\"%s - %s - %s\" href=\"%s/threads_rss.php?webtag=%s&amp;fid=%s\" />\n", htmlentities_array($forum_name), htmlentities_array($folder['TITLE']), htmlentities_array($lang['rssfeed']), $forum_path, $webtag, $folder['FID']);
            }
        }
    }

    if (@file_exists("forums/$webtag/favicon.ico")) {
        echo "<link rel=\"icon\" href=\"$forum_path/forums/$webtag/favicon.ico\" type=\"image/ico\" />\n";
    }

    if (($stylesheet = html_get_style_sheet())) {
        html_include_css($stylesheet, 'user_style');
    }

    if (($emoticon_style_sheet = html_get_emoticon_style_sheet())) {
        html_include_css($emoticon_style_sheet, 'emoticon_style', 'print, screen');
    }

    if (isset($stylesheet_array) && is_array($stylesheet_array)) {

        foreach ($stylesheet_array as $stylesheet) {

            if (isset($stylesheet['filename']) && isset($stylesheet['media'])) {
                html_include_css($stylesheet['filename'], false, $stylesheet['media']);
            }
        }
    }

    echo "<link rel=\"search\" type=\"application/opensearchdescription+xml\" href=\"$forum_path/search.php?webtag=$webtag&amp;opensearch\" title=\"{$title}\" />\n";

    if ($base_target) echo "<base target=\"$base_target\" />\n";

    html_include_javascript("./js/jquery-1.4.1.js");
    html_include_javascript("./js/jquery.autocomplete.js");
    html_include_javascript("./js/jquery.parsequery.js");
    html_include_javascript("./js/jquery.sprintf.js");
    html_include_javascript("./js/general.js");

    // Font size (not for Guests)

    if (!user_is_guest()) {
        echo "<style type=\"text/css\" title=\"user_font\">@import \"font_size.php?webtag=$webtag\";</style>\n";
    }
    
    echo "<!--[if IE 6]>\n";
    echo "<link rel=\"stylesheet\" href=\"$forum_path/styles/style_ie6.css\" type=\"text/css\" />\n";
    echo "<![endif]-->\n";

    if ($frame_set_html === false) {

        // Check for any new PMs.

        if (!user_is_guest()) {

            // Check to see if the PM popup is disabled on the current page.

            if ($pm_popup_disabled === false) {

                // Pages we don't want the popup to appear on

                $pm_popup_disabled_pages = array('admin.php', 'attachments.php', 'change_pw.php',
                                                 'confirm_email.php', 'dictionary.php', 'discussion.php',
                                                 'display_emoticons.php', 'edit_attachments.php', 'email.php',
                                                 'font_size.php', 'forgot_pw.php', 'get_attachment.php',
                                                 'index.php', 'mods_list.php', 'nav.php',
                                                 'pm.php', 'pm_edit.php', 'pm_folders.php',
                                                 'pm_messages.php', 'pm_options.php', 'poll_results.php',
                                                 'start.php', 'search_popup.php', 'threads_rss.php',
                                                 'user.php', 'user_font.php', 'user_profile.php',
                                                 'user_stats.php');

                // Check that we're not on one of the pages.

                if ((!in_array(basename($_SERVER['PHP_SELF']), $pm_popup_disabled_pages))) {
                    html_include_javascript('./js/pm.js');
                }
            }

            // Overflow auto-resize functionality.

            $resize_images_page = array('admin_post_approve.php', 'create_poll.php',
                                        'delete.php', 'display.php', 'edit.php',
                                        'edit_poll.php', 'edit_signature.php',
                                        'messages.php', 'post.php', 'pm_write.php',
                                        'pm_edit.php', 'pm_messages.php');

            if (in_array(basename($_SERVER['PHP_SELF']), $resize_images_page)) {

                if (bh_session_get_value('USE_OVERFLOW_RESIZE') == 'Y') {

                    html_include_javascript('./js/overflow.js');
                }
            }

            // Mouseover spoiler pages

            $message_display_pages = array('admin_post_approve.php', 'create_poll.php',
                                           'delete.php', 'display.php', 'edit.php',
                                           'edit_poll.php', 'edit_signature.php',
                                           'ldisplay.php', 'lmessages.php',
                                           'lpost.php', 'messages.php', 'post.php');

            if (in_array(basename($_SERVER['PHP_SELF']), $message_display_pages)) {

                if (bh_session_get_value('USE_MOVER_SPOILER') == "Y") {

                    html_include_javascript('./js/spoiler.js');
                }
            }
        }

        // Stats Display pages

        $stats_display_pages = array('messages.php');

        if (in_array(basename($_SERVER['PHP_SELF']), $stats_display_pages)) {

            if ((bh_session_get_value('SHOW_STATS') == 'Y') || user_is_guest()) {

                html_include_javascript('./js/stats.js');
            }
        }
    }

    reset($arg_array);

    foreach ($arg_array as $func_args) {

        if (($func_args == "htmltools.js") && @file_exists("$forum_path/tiny_mce/tiny_mce.js")) {

            $page_prefs = bh_session_get_post_page_prefs();

            if ($page_prefs & POST_TINYMCE_DISPLAY) {

                html_include_javascript("$forum_path/tiny_mce/tiny_mce.js");
                html_include_javascript('./js/tiny_mce.js');

            }else {

                html_include_javascript("./js/$func_args");
            }

        }else {

            html_include_javascript("./js/$func_args");
        }
    }

    if (($frame_set_html === true) && $google_analytics_code = html_get_google_analytics_code()) {

        echo "<script type=\"text/javascript\">\n";
        echo "var gaJsHost = ((\"https:\" == document.location.protocol) ? \"https://ssl.\" : \"http://www.\");\n";
        echo "document.write(unescape(\"%3Cscript src='\" + gaJsHost + \"google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E\"));\n";
        echo "</script>\n";
        echo "<script type=\"text/javascript\">\n";
        echo "if (typeof(_gat) == 'object' || typeof(_gat) == 'function') {\n";
        echo "var pageTracker = _gat._getTracker(\"$google_analytics_code\");\n";
        echo "pageTracker._trackPageview();\n";
        echo "}\n";
        echo "</script>\n";
    }
    
    html_include_javascript("./json.php?webtag=$webtag");

    echo "</head>\n\n";

    if ($frame_set_html === false) {

        echo "<body", ($body_class) ? " class=\"$body_class\">\n" : ">\n";

        if (html_output_adsense_settings() && adsense_check_user() && adsense_check_page()) {

            adsense_output_html();
            echo "<br />\n";
        }
    }
}

function html_draw_bottom($frame_set_html = false)
{
    if (!is_bool($frame_set_html)) $frame_set_html = false;

    if ($frame_set_html === false) {

        if (($page_footer = html_get_page_footer())) {
            echo fix_html($page_footer);
        }

        if (($google_analytics_code = html_get_google_analytics_code())) {

            echo "<script type=\"text/javascript\">\n";
            echo "var gaJsHost = ((\"https:\" == document.location.protocol) ? \"https://ssl.\" : \"http://www.\");\n";
            echo "document.write(unescape(\"%3Cscript src='\" + gaJsHost + \"google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E\"));\n";
            echo "</script>\n";
            echo "<script type=\"text/javascript\">\n";
            echo "if (typeof(_gat) == 'object' || typeof(_gat) == 'function') {\n";
            echo "var pageTracker = _gat._getTracker(\"$google_analytics_code\");\n";
            echo "pageTracker._trackPageview();\n";
            echo "}\n";
            echo "</script>\n";
        }

        if (defined('BEEHIVE_INSTALL_NOWARN') && basename($_SERVER['PHP_SELF']) != 'nav.php') {
            echo "<p align=\"center\">", number_format((memory_get_usage() / 1024) / 1024, 4), "MB /", number_format((memory_get_peak_usage() / 1024) / 1024, 4), "MB</p>\n";
        }

        echo "</body>\n";
    }

    echo "</html>\n";
}

class html_frameset
{
    private $frames_array = array();
    
    protected $id;
    protected $framespacing = 0;
    protected $frameborder = 0;
    protected $allowtransparency = '';
    
    public function html_frame($src, $name, $frameborder = 0, $scrolling = '', $noresize = '')
    {
        array_push($this->frames_array, new html_frame($src, $name, $frameborder, $scrolling, $noresize));
    }

    public function get_frames()
    {
        return $this->frames_array;
    }
}

class html_frameset_rows extends html_frameset
{
    private $rows = '';

    public function __construct($id, $rows, $framespacing = 0, $frameborder = 0)
    {
        $this->id = $id;

        if (preg_match('/^[0-9,\*%]+$/D', $rows)) {
            $this->rows = $rows;
        }

        if (is_numeric($framespacing)) $this->framespacing = $framespacing;
        if (is_numeric($frameborder)) $this->frameborder = $frameborder;

        if (browser_check(BROWSER_MSIE)) {
            $this->allowtransparency = " allowtransparency=\"true\"";
        }
    }

    public function output_html($close_frameset = true)
    {
        echo sprintf("<frameset id=\"%s\" rows=\"%s\" framespacing=\"%s\" border=\"%s\"%s>\n", $this->id, $this->rows, $this->framespacing, $this->frameborder, $this->allowtransparency);

        $frames_array = parent::get_frames();

        foreach($frames_array as $frame) {
            $frame->output_html();
        }

        if ($close_frameset) echo "</frameset>\n";
    }
}

class html_frameset_cols extends html_frameset
{
    private $cols = '';

    public function __construct($id, $cols, $framespacing = 4, $frameborder = 4)
    {
        $this->id = $id;

        if (preg_match('/^[0-9,\*%]+$/D', $cols)) {
            $this->cols = $cols;
        }

        if (is_numeric($framespacing)) $this->framespacing = $framespacing;
        if (is_numeric($frameborder)) $this->frameborder = $frameborder;

        if (browser_check(BROWSER_MSIE)) {
            $this->allowtransparency = " allowtransparency=\"true\"";
        }
    }

    public function output_html($close_frameset = true)
    {
        echo sprintf("<frameset id=\"%s\" cols=\"%s\" framespacing=\"%s\" border=\"%s\"%s>\n", $this->id, $this->cols, $this->framespacing, $this->frameborder, $this->allowtransparency);

        $frames_array = parent::get_frames();

        foreach($frames_array as $frame) {
            $frame->output_html();
        }

        if ($close_frameset) echo "</frameset>\n";
    }
}

class html_frame
{
    private $src;
    private $name;
    private $frameborder;
    private $scrolling;
    private $noresize;
    private $allowtransparency = '';

    function html_frame($src, $name, $frameborder = 0, $scrolling = '', $noresize = '')
    {
        $this->src = $src;
        $this->name = $name;

        if (in_array($scrolling, array('yes', 'no', ''))) $this->scrolling = $scrolling;
        if (in_array($noresize, array('noresize', ''))) $this->noresize = $noresize;

        if (browser_check(BROWSER_WEBKIT)) {
            $this->frameborder = 1;
        }else {
            $this->frameborder = (is_numeric($frameborder)) ? $frameborder : 0;
        }

        if (browser_check(BROWSER_MSIE)) {
            $this->allowtransparency = "allowtransparency=\"true\" ";
        }
    }

    function output_html()
    {
        echo sprintf("<frame src=\"%s\" name=\"%s\" frameborder=\"%s\" ", $this->src, $this->name, $this->frameborder);
        echo (strlen(trim($this->scrolling)) > 0) ? "scrolling=\"{$this->scrolling}\" " : "";
        echo (strlen(trim($this->noresize))  > 0) ? "noresize=\"{$this->noresize}\" "  : "";
        echo sprintf("%s/>\n", $this->allowtransparency);
    }
}

function html_get_page_footer()
{
    if (($page_footer = forum_get_setting('forum_page_footer'))) {
        return (strlen(trim($page_footer)) > 0) ? $page_footer : false;
    }

    return false;
}

function html_get_google_analytics_code()
{
    if (forum_get_global_setting('allow_forum_google_analytics', 'Y')) {

        if (forum_get_setting('enable_google_analytics', 'Y')) {

            if (($google_analytics_code = forum_get_setting('google_analytics_code'))) {
                return (strlen(trim($google_analytics_code)) > 0) ? $google_analytics_code : false;
            }
        }

    }else {

        if (forum_get_global_setting('enable_google_analytics', 'Y')) {

            if (($google_analytics_code = forum_get_global_setting('google_analytics_code'))) {
                return (strlen(trim($google_analytics_code)) > 0) ? $google_analytics_code : false;
            }
        }
    }

    return false;
}

function html_output_adsense_settings()
{
    // Check the required settings!

    if (($adsense_publisher_id = adsense_publisher_id())) {

        // No idea what format the client ID should be in
        // So we'll just assume it's right if it's a non-empty string.

        if (strlen(trim($adsense_publisher_id)) > 0) {

            // Default banner size and type

            $ad_type = 'medium'; $ad_width = 468; $ad_height = 60;

            // Get banner size and type

            adsense_get_banner_type($ad_type, $ad_width, $ad_height);

            // Get the slot id from the forum settings.

            $ad_slot_id = adsense_slot_id($ad_type);

            // Output the settings Javascript.

            echo "<script type=\"text/javascript\">\n";
            echo "<!--\n\n";
            echo "google_ad_client = \"$adsense_publisher_id\";\n";
            echo "google_ad_slot = \"$ad_slot_id\";\n";
            echo "google_ad_width = $ad_width\n";
            echo "google_ad_height = $ad_height\n\n";
            echo "//-->\n";
            echo "</script>\n";

            return true;
        }
    }

    return false;
}

function html_js_safe_str($str)
{
    $unsafe_chars_tbl = array('\\' => '\\\\',  "'"  => "\\'",   '"'  => '\\"',
                              "\r" => '\\r',   "\n" => '\\n',   '<'  => '\\074',
                              '>'  => '\\076', '&'  => '\\046', '--' => '\\055\\055');

    return strtr($str, $unsafe_chars_tbl);
}

function style_image($img)
{
    $webtag = get_webtag();

    $forum_path = defined('BH_FORUM_PATH') ? BH_FORUM_PATH : '.';

    if (forum_check_webtag_available($webtag)) {

        if (($user_style = bh_session_get_value('STYLE')) === false) {
            $user_style = bh_getcookie("bh_{$webtag}_style", false, forum_get_setting('default_style'));
        }

        if ($user_style !== false) {

            $user_style = basename($user_style);

            if (@is_dir("$forum_path/forums/$webtag/styles/$user_style/images") && @file_exists("$forum_path/forums/$webtag/styles/$user_style/images/$img")) {
                return "$forum_path/forums/$webtag/styles/$user_style/images/$img";
            }

        }else {

            if (@is_dir("$forum_path/forums/$webtag/images") && @file_exists("$forum_path/forums/$webtag/images/$img")) {
                return "$forum_path/forums/$webtag/images/$img";
            }
        }
    }

    if (($user_style = bh_session_get_value('STYLE')) === false) {
        $user_style = bh_getcookie("bh_{$webtag}_style", false, forum_get_setting('default_style'));
    }

    if ($user_style !== false) {

        $user_style = basename($user_style);

        if (@is_dir("$forum_path/styles/$user_style/images") && @file_exists("$forum_path/styles/$user_style/images/$img")) {
            return "$forum_path/styles/$user_style/images/$img";
        }
    }

    return "$forum_path/images/$img";
}

function bh_setcookie($name, $value, $expires = 0)
{
    $cookie_domain = (isset($GLOBALS['cookie_domain'])) ? $GLOBALS['cookie_domain'] : "";
    $cookie_secure = (isset($_SERVER['HTTPS']) && mb_strtolower($_SERVER['HTTPS']) == 'on');

    // Some versions of Opera don''t play well with cookie restrictions.
    // Because we don't have an exhaustive list of which don't work,
    // we disable cookie domain and path for them.

    // If we're also on Light mode we disable by default.

    if (!defined('BEEHIVEMODE_LIGHT') && !browser_check(BROWSER_OPERA)) {

        // Set the defaults.

        $cookie_domain = html_get_forum_domain();
        $cookie_path = '/';

        // Try and parse the cookie_domain config.inc.php setting.
        // Only set the path if we can also get the hostname.

        if (($cookie_domain_array = @parse_url($cookie_domain))) {

            if (isset($cookie_domain_array['host'])) {

                $cookie_domain = $cookie_domain_array['host'];

                if (isset($cookie_domain_array['path'])) {
                    $cookie_path = $cookie_domain_array['path'];
                }
            }
        }

        return setcookie($name, $value, $expires, $cookie_path, $cookie_domain, $cookie_secure);
    }

    return setcookie($name, $value, $expires, '', '', $cookie_secure);
}

function bh_getcookie($cookie_name, $callback = false, $default = false)
{
    if (isset($_COOKIE[$cookie_name])) {

        if ($callback !== false) {

            if (function_exists($callback) && is_callable($callback)) {

                return ($callback($_COOKIE[$cookie_name])) ? $_COOKIE[$cookie_name] : $default;

            }else if (is_string($callback)) {

                return mb_strtoupper($_COOKIE[$cookie_name]) == mb_strtoupper($callback);
            }
        }

        return $_COOKIE[$cookie_name];
    }

    return $default;
}

function bh_remove_all_cookies()
{
    foreach (array_keys($_COOKIE) as $name) {
        bh_setcookie($name, '', time() - YEAR_IN_SECONDS);
    }
}

// Remove named $keys from the query of a URI
// $keys can be an array or a single key to remove

function href_cleanup_query_keys($uri, $remove_keys = false, $seperator = "&amp;")
{
    $uri_array = parse_url($uri);

    if (isset($uri_array['query'])) {

        $uri_query_array = array();

        parse_str($uri_array['query'], $uri_query_array);

        unset($uri_array['query']);

        $uri_query_keys = array();
        $uri_query_values = array();

        flatten_array($uri_query_array, $uri_query_keys, $uri_query_values);

        $new_uri_query_array = array();

        foreach ($uri_query_keys as $key => $key_name) {

            if (strlen($key_name) > 0) {

                if ($remove_keys === false || (is_array($remove_keys) && !in_array($key_name, $remove_keys)) || $key_name != $remove_keys) {

                    if (isset($uri_query_values[$key]) && strlen($uri_query_values[$key]) > 0) {

                        $new_uri_query_array[] = sprintf('%s=%s', urlencode($key_name), urlencode($uri_query_values[$key]));

                    }else {

                        $new_uri_query_array[] = urlencode($key_name);
                    }
                }
            }
        }

        if (sizeof($new_uri_query_array) > 0) {
            $uri_array['query'] = implode($seperator, $new_uri_query_array);
        }

        $uri = (isset($uri_array['scheme']))   ? "{$uri_array['scheme']}://" : '';
        $uri.= (isset($uri_array['host']))     ? "{$uri_array['host']}"      : '';
        $uri.= (isset($uri_array['port']))     ? ":{$uri_array['port']}"     : '';
        $uri.= (isset($uri_array['path']))     ? "{$uri_array['path']}"      : '';
        $uri.= (isset($uri_array['query']))    ? "?{$uri_array['query']}"    : '';
        $uri.= (isset($uri_array['fragment'])) ? "#{$uri_array['fragment']}" : '';
    }

    return $uri;
}

// Draws Page links (i.e.: Pages: [1] 2 3 4 ... >>)

function page_links($uri, $offset, $total_rows, $rows_per_page, $page_var = "page")
{
    $lang = load_language_file();

    $page_count   = ceil($total_rows / $rows_per_page);
    $current_page = ceil($offset / $rows_per_page) + 1;

    if ($current_page > $page_count) $current_page = $page_count;
    if ($current_page < 1) $current_page = 1;

    $uri = href_cleanup_query_keys($uri, $page_var);

    $sep = strstr($uri, '?') ? "&amp;" : "?";

    if ($page_count > 1) {

        echo "<span class=\"pagenum_text\">{$lang['pages']}&nbsp;($page_count):&nbsp;";

    }else {

        echo "<span class=\"pagenum_text\">{$lang['pages']}:&nbsp;";
    }

    if ($page_count > 1) {

        if ($current_page == 1) {

            $end_page = (($current_page + 2) <= $page_count) ? ($current_page + 2) : $page_count;
            $start_page = $current_page;

        }elseif ($current_page == $page_count) {

            $start_page = (($current_page - 2) > 0) ? ($current_page - 2) : 1;
            $end_page = $page_count;

        }else {

            $start_page = (($current_page - 2) > 0) ? ($current_page - 2) : 1;
            $end_page   = (($current_page + 2) <= $page_count) ? ($current_page + 2) : $page_count;

            if (($end_page - $start_page) < 2) {

                if (($start_page - 2) < 1) {

                    $end_page = (($start_page + 2) <= $page_count) ? ($start_page + 2) : $page_count;

                }elseif (($end_page + 1) > $page_count) {

                    $start_page = (($end_page - 4) > 0) ? ($end_page - 4) : 1;
                }
            }
        }

        if ($start_page > 1) {

            echo "<a href=\"{$uri}{$sep}{$page_var}=1\" target=\"_self\">&laquo;&nbsp;First</a>&nbsp;&hellip;&nbsp;";
        }

        if ($current_page > 1) {

            $prev_page = (($current_page - 1) > 0) ? ($current_page - 1) : 1;
            echo "<a href=\"{$uri}{$sep}{$page_var}={$prev_page}\" target=\"_self\">&laquo;</a>&nbsp;";
        }

        for ($page = $start_page; $page <= $end_page; $page++) {

            if ($page == $current_page) {
                echo "<a href=\"{$uri}{$sep}{$page_var}={$page}\" target=\"_self\"><b>[$page]</b></a>&nbsp;";
            }else {
                echo "<a href=\"{$uri}{$sep}{$page_var}={$page}\" target=\"_self\">{$page}</a>&nbsp;";
            }
        }

        if ($current_page < $page_count) {

            $next_page = (($current_page + 1) <= $page_count) ? ($current_page + 1) : $page_count;
            echo "<a href=\"{$uri}{$sep}{$page_var}={$next_page}\" target=\"_self\">&raquo;</a>&nbsp;";
        }

        if ($end_page < $page_count) {

            echo "&nbsp;&hellip;&nbsp;<a href=\"{$uri}{$sep}{$page_var}={$page_count}\" target=\"_self\">Last&nbsp;&raquo;</a>&nbsp;";
        }

    }else {

        echo "<a href=\"{$uri}{$sep}{$page_var}=1\" target=\"_self\"><b>[1]</b></a>&nbsp;";
    }

    echo "</span>";
}

function html_get_forum_domain($allow_https = true, $return_array = false)
{
    $uri_array = array();

    if (isset($_SERVER['REQUEST_URI']) && strlen(trim($_SERVER['REQUEST_URI'])) > 0) {
        $uri_array = @parse_url($_SERVER['REQUEST_URI']);
    }

    if (!isset($uri_array['scheme']) || strlen(trim($uri_array['scheme'])) < 1) {

        if (isset($_SERVER['HTTP_SCHEME']) && strlen(trim($_SERVER['HTTP_SCHEME'])) > 0) {

            $uri_array['scheme'] = $_SERVER['HTTP_SCHEME'];

        }elseif (isset($_SERVER['HTTPS']) && strlen(trim($_SERVER['HTTPS'])) > 0) {

            $uri_array['scheme'] = ((strtolower($_SERVER['HTTPS']) != 'off') && $allow_https === true) ? 'https' : 'http';

        }else {

            $uri_array['scheme'] = 'http';
        }

        if (isset($_SERVER['HTTP_HOST']) && strlen(trim($_SERVER['HTTP_HOST'])) > 0) {

            if (mb_strpos($_SERVER['HTTP_HOST'], ':') > 0) {

                list($uri_array['host'], $uri_array['port']) = explode(':', $_SERVER['HTTP_HOST']);

            }else {

                $uri_array['host'] = $_SERVER['HTTP_HOST'];
            }

        }else if (isset($_SERVER['SERVER_NAME']) && strlen(trim($_SERVER['SERVER_NAME'])) > 0) {

            $uri_array['host'] = $_SERVER['SERVER_NAME'];
        }

        if (!isset($uri_array['port']) || strlen(trim($uri_array['port'])) < 1) {

            if (isset($_SERVER['SERVER_PORT']) && strlen(trim($_SERVER['SERVER_PORT'])) > 0) {

                if ($_SERVER['SERVER_PORT'] != '80') {

                    $uri_array['port'] = $_SERVER['SERVER_PORT'];
                }
            }
        }
    }

    if ($return_array) return $uri_array;

    $server_uri = (isset($uri_array['scheme'])) ? "{$uri_array['scheme']}://" : '';
    $server_uri.= (isset($uri_array['host']))   ? "{$uri_array['host']}"      : '';
    $server_uri.= (isset($uri_array['port']))   ? ":{$uri_array['port']}"     : '';

    return $server_uri;
}

function html_get_forum_uri($append_path = '', $allow_https = true)
{
    $uri_array = html_get_forum_domain($allow_https, true);

    if (!isset($uri_array['path']) || strlen(trim($uri_array['path'])) < 1) {

        if (isset($_SERVER['PATH_INFO']) && strlen(trim($_SERVER['PATH_INFO'])) > 0) {

            $path = @parse_url($_SERVER['PATH_INFO']);

        }else {

            $path = @parse_url($_SERVER['PHP_SELF']);
        }

        $uri_array['path'] = $path['path'];
    }

    $path_boundary = md5(uniqid(rand()));

    if (server_os_mswin()) {

        $uri_array['path'] = str_replace(DIRECTORY_SEPARATOR, '/', dirname("{$uri_array['path']}$path_boundary"));
        $uri_array['path'] = rtrim($uri_array['path'], '/');

    }else {

        $uri_array['path'] = dirname("{$uri_array['path']}$path_boundary");
    }

    $uri_array['path'] = rtrim($uri_array['path'], '/');

    if (strlen(trim($append_path)) > 0) {
        $uri_array['path'].= $append_path;
    }

    $server_uri = (isset($uri_array['scheme'])) ? "{$uri_array['scheme']}://" : '';
    $server_uri.= (isset($uri_array['host']))   ? "{$uri_array['host']}"      : '';
    $server_uri.= (isset($uri_array['port']))   ? ":{$uri_array['port']}"     : '';
    $server_uri.= (isset($uri_array['path']))   ? "{$uri_array['path']}"      : '';

    return $server_uri;
}

?>
