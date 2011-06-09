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
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "emoticons.inc.php");
include_once(BH_INCLUDE_PATH. "fixhtml.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "htmltools.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "pm.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "server.inc.php");
include_once(BH_INCLUDE_PATH. "swift.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

function html_guest_error()
{
    $frame_top_target = html_get_top_frame_name();

    $lang = load_language_file();

    $final_uri = basename(get_request_uri(true, false));

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

    if (!preg_match('/^[0-9]+%?$/u', $width)) $width = '600';

    $error_list_array = array_filter($error_list_array, 'is_string');

    if (sizeof($error_list_array) == 0) return;

    if (sizeof($error_list_array) == 1) {
        return html_display_error_msg(array_shift($error_list_array), $width, $align, $id);
    }

    $available_alignments = array('left', 'center', 'right');
    if (!in_array($align, $available_alignments)) $align = 'left';

    echo "<div align=\"$align\"", (!is_bool($id) ? " id=\"$id\"" : ""), ">\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"$width\" class=\"error_msg\">\n";
    echo "    <tr>\n";
    echo "      <td rowspan=\"2\" valign=\"top\" width=\"25\" class=\"error_msg_icon\"><img src=\"", html_style_image('error.png'), "\" alt=\"{$lang['error']}\" title=\"{$lang['error']}\" /></td>\n";
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

    if (!preg_match('/^[0-9]+%?$/u', $width)) $width = '600';

    if (!is_string($string_msg)) return;

    $available_alignments = array('left', 'center', 'right');
    if (!in_array($align, $available_alignments)) $align = 'left';

    echo "<div align=\"$align\"", (!is_bool($id) ? " id=\"$id\"" : ""), ">\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"$width\" class=\"success_msg\">\n";
    echo "    <tr>\n";
    echo "      <td valign=\"top\" width=\"25\" class=\"success_msg_icon\"><img src=\"", html_style_image('success.png'), "\" alt=\"{$lang['success']}\" title=\"{$lang['success']}\" /></td>\n";
    echo "      <td valign=\"top\" class=\"success_msg_text\">$string_msg</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</div>\n";
}

function html_display_error_msg($string_msg, $width = '600', $align = 'center', $id = false)
{
    $lang = load_language_file();

    if (!preg_match('/^[0-9]+%?$/u', $width)) $width = '600';

    if (!is_string($string_msg)) return;

    $available_alignments = array('left', 'center', 'right');
    if (!in_array($align, $available_alignments)) $align = 'left';

    echo "<div align=\"$align\"", (!is_bool($id) ? " id=\"$id\"" : ""), ">\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"$width\" class=\"error_msg\">\n";
    echo "    <tr>\n";
    echo "      <td valign=\"top\" width=\"25\" class=\"error_msg_icon\"><img src=\"", html_style_image('error.png'), "\" alt=\"{$lang['error']}\" title=\"{$lang['error']}\" /></td>\n";
    echo "      <td valign=\"top\" class=\"error_msg_text\">$string_msg</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</div>\n";
}

function html_display_warning_msg($string_msg, $width = '600', $align = 'center', $id = false)
{
    $lang = load_language_file();

    if (!preg_match('/^[0-9]+%?$/u', $width)) $width = '600';

    if (!is_string($string_msg)) return;

    $available_alignments = array('left', 'center', 'right');
    if (!in_array($align, $available_alignments)) $align = 'left';

    echo "<div align=\"$align\"", (!is_bool($id) ? " id=\"$id\"" : ""), ">\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"$width\" class=\"warning_msg\">\n";
    echo "    <tr>\n";
    echo "      <td valign=\"top\" width=\"25\" class=\"warning_msg_icon\"><img src=\"", html_style_image('warning.png'), "\" alt=\"{$lang['warning']}\" title=\"{$lang['warning']}\" /></td>\n";
    echo "      <td valign=\"top\" class=\"warning_msg_text\">$string_msg</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</div>\n";
}

function html_user_banned()
{
    header_status(500, 'Internal Server Error');
    exit;
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

    if (($uid = session_get_value('UID')) === false) return;

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

function html_get_user_style_path()
{
    if (($user_style = session_get_value('STYLE')) === false) {
        $user_style = html_get_cookie("forum_style", false, forum_get_setting('default_style', false, 'default'));
    }

    return $user_style;
}

function html_get_style_sheet()
{
    if (!($user_style = html_get_user_style_path())) {
        return html_get_forum_file_path('styles/style.css');
    }

    return html_get_forum_file_path(sprintf('styles/%s/style.css', basename($user_style)));
}

function html_get_mobile_style_sheet()
{
    if (!($user_style = html_get_user_style_path())) {
        return html_get_forum_file_path('styles/mobile.css');
    }

    return html_get_forum_file_path(sprintf('styles/%s/mobile.css', basename($user_style)));
}

function html_get_script_style_sheet()
{
    if (!($user_style = html_get_user_style_path())) return false;

    $script_style_sheet = sprintf('styles/%s/%s.css', basename($user_style), basename($_SERVER['PHP_SELF'], '.php'));

    if (($user_style === false) || !file_exists($script_style_sheet)) return false;

    return html_get_forum_file_path($script_style_sheet);
}

function html_get_top_page()
{
    if (!($user_style = html_get_user_style_path())) {
        return html_get_forum_file_path('styles/top.php');
    }

    return html_get_forum_file_path(sprintf('styles/%s/top.php', basename($user_style)));
}

function html_get_emoticon_style_sheet($emoticon_set = false)
{
    if (($emoticon_set) && emoticons_set_exists($emoticon_set)) {

        $user_emoticons = basename($emoticon_set);

    } else if (($user_emoticons = session_get_value('EMOTICONS')) === false) {

        $user_emoticons = forum_get_setting('default_emoticons');
    }

    if (emoticons_set_exists($user_emoticons)) {
        return html_get_forum_file_path(sprintf('emoticons/%s/style.css', basename($user_emoticons)));
    }

    return false;
}

function html_get_forum_keywords()
{
    if (!($forum_keywords = forum_get_setting('forum_keywords'))) return '';

    return $forum_keywords;
}

function html_get_forum_description()
{
    if (!($forum_desc = forum_get_setting('forum_desc'))) return '';

    return $forum_desc;
}

function html_get_forum_content_rating()
{
    $content_ratings_array = array(FORUM_RATING_GENERAL    => 'General',
                                   FORUM_RATING_FOURTEEN   => '14 Years',
                                   FORUM_RATING_MATURE     => 'Mature',
                                   FORUM_RATING_RESTRICTED => 'Restricted');

    if (!($forum_content_rating = forum_get_setting('forum_content_rating'))) {
        return $content_ratings_array[FORUM_RATING_GENERAL];
    }

    if (!isset($content_ratings_array[$forum_content_rating])) {
        return $content_ratings_array[FORUM_RATING_GENERAL];
    }

    return $content_ratings_array[$forum_content_rating];
}

function html_get_forum_email()
{
    if (!($forum_email = forum_get_setting('forum_email'))) return '';

    return $forum_email;
}

function html_get_frame_name($basename)
{
    // Forum URL
    $forum_uri = html_get_forum_uri(null, true, true);

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
    if (!isset($GLOBALS['frame_top_target']) || strlen(trim($GLOBALS['frame_top_target'])) == 0) {
        return '_top';
    }

    return $GLOBALS['frame_top_target'];
}

function html_include_javascript($script_filepath)
{
    $path_parts = path_info_query($script_filepath);

    if (!array_keys_exist($path_parts, 'basename', 'filename', 'extension', 'dirname')) return;

    if (forum_get_setting('use_minified_scripts', false, false)) {
        $path_parts['basename'] = sprintf('%s.min.%s', $path_parts['filename'], $path_parts['extension']);
    }

    $script_filepath = "{$path_parts['dirname']}/{$path_parts['basename']}";

    $script_filepath.= isset($path_parts['query']) ? "?{$path_parts['query']}" : '';

    printf("<script type=\"text/javascript\" src=\"%s\"></script>\n", $script_filepath);
}

function html_include_css($script_filepath, $media = 'screen', $id = false)
{
    $path_parts = path_info_query($script_filepath);

    if (!array_keys_exist($path_parts, 'basename', 'filename', 'extension', 'dirname')) return;

    $id = ($id !== false) ? $id : sprintf('style_%s', preg_replace('/[^a-zA-Z]+/', '', $script_filepath));

    if (forum_get_setting('use_minified_scripts', false, false)) {
        $path_parts['basename'] = sprintf('%s.min.%s', $path_parts['filename'], $path_parts['extension']);
    }

    $script_filepath = "{$path_parts['dirname']}/{$path_parts['basename']}";

    $script_filepath.= isset($path_parts['query']) ? "?{$path_parts['query']}" : '';

    printf("<link rel=\"stylesheet\" id=\"%s\" href=\"%s\" type=\"text/css\" media=\"%s\" />\n", $id, $script_filepath, $media);
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

    $forum_name = forum_get_setting('forum_name', false, 'A Beehive Forum');

    $frame_set_html = false;

    $pm_popup_disabled = false;

    $func_matches = array();

    $emoticons = false;

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

        if (preg_match('/^inline_css=([^$]+)?$/Diu', $func_args, $func_matches) > 0) {
            if (isset($func_matches[1])) $inline_css = $func_matches[1];
            unset($arg_array[$key]);
        }

        if (preg_match('/^emoticons=([^$]+)?$/Diu', $func_args, $func_matches) > 0) {
            if (isset($func_matches[1])) $emoticons = $func_matches[1];
            unset($arg_array[$key]);
        }
    }

    if (strlen(trim($body_class)) < 1) $body_class = false;
    if (strlen(trim($base_target)) < 1) $base_target = false;

    if (!isset($resize_width)) $resize_width = 0;

    // Default Meta keywords and description.
    $meta_keywords = html_get_forum_keywords();
    $meta_description = html_get_forum_description();

    // Get the page meta keywords and description
    if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {
        message_get_meta_content($_GET['msg'], $meta_keywords, $meta_description);
    }

    $forum_content_rating = html_get_forum_content_rating();

    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

    if ($frame_set_html === false) {
        echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
    }else {
        echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Frameset//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd\">\n";
    }

    echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"{$lang['_isocode']}\" lang=\"{$lang['_isocode']}\" dir=\"{$lang['_textdir']}\">\n";
    echo "<head>\n";

    echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />\n";

    if (strlen(trim($title)) > 0) {
        echo "<title>", htmlentities_array($title), " - ", htmlentities_array($forum_name), "</title>\n";
    }else if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {
        echo "<title>", htmlentities_array($meta_description), " - ", htmlentities_array($forum_name), "</title>\n";
    }else {
        echo "<title>", htmlentities_array($forum_name), "</title>\n";
    }

    echo "<meta name=\"generator\" content=\"Beehive Forum ", BEEHIVE_VERSION, "\" />\n";
    echo "<meta name=\"keywords\" content=\"$meta_keywords\" />\n";
    echo "<meta name=\"description\" content=\"$meta_description\" />\n";
    echo "<meta name=\"rating\" content=\"$forum_content_rating\" />\n";

    if (forum_get_setting('allow_search_spidering', 'N')) {

        echo "<meta name=\"robots\" content=\"noindex,nofollow\" />\n";

    }elseif (strlen(trim($robots)) > 0) {

        echo "<meta name=\"robots\" content=\"$robots\" />\n";
    }

    if ($meta_refresh_delay && $meta_refresh_url) {
        echo "<meta http-equiv=\"refresh\" content=\"{$meta_refresh_delay}; url={$meta_refresh_url}\" />\n";
    }

    printf("<meta name=\"application-name\" content=\"%s\" />\n", htmlentities_array($forum_name));
    printf("<meta name=\"msapplication-tooltip\" content=\"%s\" />\n", htmlentities_array($meta_description));

    if (forum_check_webtag_available($webtag)) {

        printf("<meta name=\"msapplication-task\" content=\"name=%s;action-uri=%s;icon-uri=%s\" />\n", $lang['messages'], htmlentities_array(html_get_forum_uri("/index.php?webtag=$webtag&final_uri=discussion.php%3Fwebtag%3D$webtag")), html_get_forum_uri(sprintf('/%s', html_style_image('msie/unread_thread.ico'))));

        if (forum_get_setting('show_links', 'Y')) {
            printf("<meta name=\"msapplication-task\" content=\"name=%s;action-uri=%s;icon-uri=%s\" />\n", $lang['links'], htmlentities_array(html_get_forum_uri("/index.php?webtag=$webtag&final_uri=links.php%3Fwebtag%3D$webtag")), html_get_forum_uri(sprintf('/%s', html_style_image('msie/link.ico'))));
        }
    }

    if (forum_get_setting('show_pms', 'Y')) {
        printf("<meta name=\"msapplication-task\" content=\"name=%s;action-uri=%s;icon-uri=%s\" />\n", $lang['pminbox'], htmlentities_array(html_get_forum_uri("/index.php?webtag=$webtag&final_uri=pm.php%3Fwebtag%3D$webtag")), html_get_forum_uri(sprintf('/%s', html_style_image('msie/pmunread.ico'))));
    }

    if (forum_check_webtag_available($webtag)) {
        printf("<meta name=\"msapplication-task\" content=\"name=%s;action-uri=%s;icon-uri=%s\" />\n", $lang['mycontrols'], htmlentities_array(html_get_forum_uri("/index.php?webtag=$webtag&final_uri=user.php%3Fwebtag%3D$webtag")), html_get_forum_uri(sprintf('/%s', html_style_image('msie/user_controls.ico'))));
    }

    if (session_check(false, false) && (session_check_perm(USER_PERM_FORUM_TOOLS, 0) || session_check_perm(USER_PERM_ADMIN_TOOLS, 0) || session_get_folders_by_perm(USER_PERM_FOLDER_MODERATE))) {
        printf("<meta name=\"msapplication-task\" content=\"name=%s;action-uri=%s;icon-uri=%s\" />\n", $lang['admin'], htmlentities_array(html_get_forum_uri("/index.php?webtag=$webtag&final_uri=admin.php%3Fwebtag%3D$webtag")), html_get_forum_uri(sprintf('/%s', html_style_image('msie/admintool.ico'))));
    }

    printf("<meta name=\"msapplication-starturl\" content=\"%s\" />\n", html_get_forum_uri("/index.php?webtag=$webtag"));

    if ((basename($_SERVER['PHP_SELF']) == "index.php") && session_check(false, false)) {

        $rss_feed_path = html_get_forum_file_path("threads_rss.php?webtag=$webtag");
        printf("<link rel=\"alternate\" type=\"application/rss+xml\" title=\"%s - %s\" href=\"%s\" />\n", htmlentities_array($forum_name), htmlentities_array($lang['rssfeed']), $rss_feed_path);

        if (($folders_array = folder_get_available_details())) {

            foreach ($folders_array as $folder) {

                $rss_feed_path = html_get_forum_file_path("threads_rss.php?webtag=$webtag&amp;fid={$folder['FID']}");
                printf("<link rel=\"alternate\" type=\"application/rss+xml\" title=\"%s - %s - %s\" href=\"%s\" />\n", htmlentities_array($forum_name), htmlentities_array($folder['TITLE']), htmlentities_array($lang['rssfeed']), $rss_feed_path);
            }
        }
    }

    if (($user_style_path = html_get_user_style_path())) {

        printf("<link rel=\"apple-touch-icon\" href=\"%s\" />\n", html_get_forum_file_path(sprintf('styles/%s/images/apple-touch-icon-57x57.png', $user_style_path), true, true));
        printf("<link rel=\"apple-touch-icon\" sizes=\"72x72\" href=\"%s\" />\n", html_get_forum_file_path(sprintf('styles/%s/images/apple-touch-icon-72x72.png', $user_style_path), true, true));
        printf("<link rel=\"apple-touch-icon\" sizes=\"114x114\" href=\"%s\" />\n", html_get_forum_file_path(sprintf('styles/%s/images/apple-touch-icon-114x114.png', $user_style_path), true, true));

        printf("<link rel=\"shortcut icon\" type=\"image/ico\"href=\"%s\" />\n", html_get_forum_file_path(sprintf('styles/%s/images/favicon.ico', $user_style_path)));
    }

    $opensearch_path = html_get_forum_file_path(sprintf('search.php?webtag=%s&amp;opensearch', $webtag));

    printf("<link rel=\"search\" type=\"application/opensearchdescription+xml\" title=\"%s\" href=\"%s\" />\n", $forum_name, $opensearch_path);

    if (($style_sheet = html_get_style_sheet())) {
        html_include_css($style_sheet);
    }

    if (($script_style_sheet = html_get_script_style_sheet())) {
        html_include_css($script_style_sheet);
    }

    if (($emoticon_style_sheet = html_get_emoticon_style_sheet($emoticons))) {
        html_include_css($emoticon_style_sheet, 'print, screen');
    }

    if (isset($stylesheet_array) && is_array($stylesheet_array)) {

        foreach ($stylesheet_array as $stylesheet) {

            if (isset($stylesheet['filename']) && isset($stylesheet['media'])) {
                html_include_css($stylesheet['filename'], $stylesheet['media']);
            }
        }
    }

    $style_path_ie6 = html_get_forum_file_path('styles/style_ie6.css');

    echo "<!--[if IE 6]>\n";
    echo "<link rel=\"stylesheet\" href=\"$style_path_ie6\" type=\"text/css\" />\n";
    echo "<![endif]-->\n";

    if (isset($inline_css) && strlen(trim($inline_css)) > 0) {

        echo "<style type=\"text/css\">\n";
        echo "<!--\n\n";
        echo trim($inline_css), "\n\n";
        echo "//-->\n";
        echo "</style>\n";
    }

    // Font size (not for Guests)
    if (!user_is_guest()) {
        html_include_css(html_get_forum_file_path(sprintf('font_size.php?webtag=%s', $webtag)), 'screen', 'user_font');
    }

    if ($base_target) echo "<base target=\"$base_target\" />\n";

    html_include_javascript(html_get_forum_file_path('js/jquery-1.4.1.js'));
    html_include_javascript(html_get_forum_file_path('js/jquery.autocomplete.js'));
    html_include_javascript(html_get_forum_file_path('js/jquery.parsequery.js'));
    html_include_javascript(html_get_forum_file_path('js/jquery.sprintf.js'));
    html_include_javascript(html_get_forum_file_path('js/json2.js'));
    html_include_javascript(html_get_forum_file_path('js/general.js'));

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
                    html_include_javascript(html_get_forum_file_path('js/pm.js'));
                }
            }

            // Overflow auto-resize functionality.
            $resize_images_page = array('admin_post_approve.php', 'create_poll.php',
                                        'delete.php', 'display.php', 'edit.php',
                                        'edit_poll.php', 'edit_signature.php',
                                        'messages.php', 'post.php', 'pm_write.php',
                                        'pm_edit.php', 'pm_messages.php');

            if (in_array(basename($_SERVER['PHP_SELF']), $resize_images_page)) {

                if (session_get_value('USE_OVERFLOW_RESIZE') == 'Y') {

                    html_include_javascript(html_get_forum_file_path('js/overflow.js'));
                }
            }

            // Mouseover spoiler pages
            $message_display_pages = array('admin_post_approve.php', 'create_poll.php',
                                           'delete.php', 'display.php', 'edit.php',
                                           'edit_poll.php', 'edit_signature.php',
                                           'ldisplay.php', 'lmessages.php',
                                           'lpost.php', 'messages.php', 'post.php');

            if (in_array(basename($_SERVER['PHP_SELF']), $message_display_pages)) {

                html_include_javascript(html_get_forum_file_path('js/spoiler.js'));
            }
        }

        // Stats Display pages
        $stats_display_pages = array('messages.php');

        if (in_array(basename($_SERVER['PHP_SELF']), $stats_display_pages)) {
            html_include_javascript(html_get_forum_file_path('js/stats.js'));
        }
    }

    reset($arg_array);

    foreach ($arg_array as $func_args) {

        if (($func_args == "htmltools.js") && @file_exists(html_get_forum_file_path('tiny_mce/tiny_mce.js'))) {

            $page_prefs = session_get_post_page_prefs();

            if ($page_prefs & POST_TINYMCE_DISPLAY) {

                html_include_javascript(html_get_forum_file_path('tiny_mce/tiny_mce.js'));
                html_include_javascript(html_get_forum_file_path('js/tiny_mce.js'));

            }else {

                html_include_javascript(html_get_forum_file_path("js/$func_args"));
            }

        }else {

            html_include_javascript(html_get_forum_file_path("js/$func_args"));
        }
    }

    html_include_javascript(html_get_forum_file_path("json.php?webtag=$webtag"));

    if (($frame_set_html === true) && $google_analytics_code = html_get_google_analytics_code()) {

        echo "<script type=\"text/javascript\">\n\n";
        echo "  var _gaq = _gaq || [];\n";
        echo "  _gaq.push(['_setAccount', '$google_analytics_code']);\n";
        echo "  _gaq.push(['_trackPageview']);\n\n";
        echo "  (function() {\n";
        echo "    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;\n";
        echo "    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';\n";
        echo "    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);\n";
        echo "  })();\n\n";
        echo "</script>\n";
    }

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

            echo "<script type=\"text/javascript\">\n\n";
            echo "  var _gaq = _gaq || [];\n";
            echo "  _gaq.push(['_setAccount', '$google_analytics_code']);\n";
            echo "  _gaq.push(['_trackPageview']);\n\n";
            echo "  (function() {\n";
            echo "    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;\n";
            echo "    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';\n";
            echo "    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);\n";
            echo "  })();\n\n";
            echo "</script>\n";
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

function html_style_image($img)
{
    if (($user_style = session_get_value('STYLE')) === false) {
        $user_style = html_get_cookie("forum_style", false, forum_get_setting('default_style', false, 'default'));
    }

    if ($user_style !== false) {
        return html_get_forum_file_path(sprintf('styles/%s/images/%s', basename($user_style), $img));
    }

    return html_get_forum_file_path(sprintf('images/%s', $img));
}

function html_set_cookie($name, $value, $expires = 0)
{
    // Set the secure state of the cookie
    $cookie_secure = (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on');

    // Some versions of Opera don''t play well with cookie restrictions.
    // Because we don't have an exhaustive list of which don't work,
    // we disable cookie domain and path for them.
    // If we're also on Light mode we disable by default.
    if (!defined('BEEHIVEMODE_LIGHT') && !browser_check(BROWSER_OPERA)) {

        // Get the cookie domain from config.inc.php or html_get_forum_uri
        if (isset($GLOBALS['cookie_domain']) && strlen(trim($GLOBALS['cookie_domain'])) > 0) {
            $cookie_domain = trim($GLOBALS['cookie_domain']);
        } else {
            $cookie_domain = html_get_forum_uri(null, false);
        }

        // Try and parse the cookie_domain config.inc.php setting.
        if (($cookie_domain_array = @parse_url($cookie_domain))) {

            // Check we have a hostname and path.
            if (isset($cookie_domain_array['host']) && isset($cookie_domain_array['path'])) {

                // Set the cookie with hostname and path.
                return setcookie($name, $value, $expires, $cookie_domain_array['path'], ".{$cookie_domain_array['host']}", $cookie_secure);
            }
        }
    }

    return setcookie($name, $value, $expires, '', '', $cookie_secure);
}

function html_get_cookie($cookie_name, $callback = false, $default = false)
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

function html_remove_all_cookies()
{
    foreach (array_keys($_COOKIE) as $name) {
        html_set_cookie($name, '', time() - YEAR_IN_SECONDS);
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

            if (($start_page - 1) > 1) {
                echo "<a href=\"{$uri}{$sep}{$page_var}=1\" target=\"_self\">1</a>&nbsp;&hellip;&nbsp;";
            } else {
                echo "<a href=\"{$uri}{$sep}{$page_var}=1\" target=\"_self\">1</a>&nbsp;";
            }
        }

        for ($page = $start_page; $page <= $end_page; $page++) {

            if ($page == $current_page) {
                echo "<a href=\"{$uri}{$sep}{$page_var}={$page}\" target=\"_self\"><span class=\"pagenum_current\">$page</span></a>&nbsp;";
            }else {
                echo "<a href=\"{$uri}{$sep}{$page_var}={$page}\" target=\"_self\">{$page}</a>&nbsp;";
            }
        }

        if ($end_page < $page_count) {

            if (($end_page + 1) < $page_count) {
                echo "&hellip;&nbsp;<a href=\"{$uri}{$sep}{$page_var}={$page_count}\" target=\"_self\">{$page_count}</a>";
            } else {
                echo "<a href=\"{$uri}{$sep}{$page_var}={$page_count}\" target=\"_self\">{$page_count}</a>";
            }
        }

    }else {

        echo "<a href=\"{$uri}{$sep}{$page_var}=1\" target=\"_self\"><b>[1]</b></a>&nbsp;";
    }

    echo "</span>";
}

function html_get_forum_uri($append_path = null, $use_forum_uri = true)
{
    if (($use_forum_uri === true) && ($forum_uri = rtrim(forum_get_global_setting('forum_uri', 'strlen', false), '/'))) {

        $uri_array = @parse_url($forum_uri);

    } else {

        $uri_array = @parse_url($_SERVER['PHP_SELF']);

        $uri_array['path'] = dirname($uri_array['path']);
    }

    if (!isset($uri_array['scheme'])) {

        if (isset($_SERVER['HTTP_SCHEME']) && strlen(trim($_SERVER['HTTP_SCHEME'])) > 0) {

            $uri_array['scheme'] = $_SERVER['HTTP_SCHEME'];

        }elseif (isset($_SERVER['HTTPS']) && strlen(trim($_SERVER['HTTPS'])) > 0) {

            $uri_array['scheme'] = (mb_strtolower($_SERVER['HTTPS']) != 'off') ? 'https' : 'http';

        }else {

            $uri_array['scheme'] = 'http';
        }
    }

    if (!isset($uri_array['host'])) {

        if (isset($_SERVER['HTTP_HOST']) && strlen(trim($_SERVER['HTTP_HOST'])) > 0) {

            if (mb_strpos($_SERVER['HTTP_HOST'], ':') > 0) {

                list($uri_array['host'], $uri_array['port']) = explode(':', $_SERVER['HTTP_HOST']);

            }else {

                $uri_array['host'] = $_SERVER['HTTP_HOST'];
            }

        }else if (isset($_SERVER['SERVER_NAME']) && strlen(trim($_SERVER['SERVER_NAME'])) > 0) {

            $uri_array['host'] = $_SERVER['SERVER_NAME'];
        }
    }

    if (!isset($uri_array['port'])) {

        if (isset($_SERVER['SERVER_PORT']) && strlen(trim($_SERVER['SERVER_PORT'])) > 0) {

            if ($_SERVER['SERVER_PORT'] != '80') {

                $uri_array['port'] = $_SERVER['SERVER_PORT'];
            }
        }
    }

    if (!isset($uri_array['path'])) {

        if (isset($_SERVER['PATH_INFO']) && strlen(trim($_SERVER['PATH_INFO'])) > 0) {

            $path = @parse_url($_SERVER['PATH_INFO']);

        }else {

            $path = @parse_url($_SERVER['PHP_SELF']);
        }

        if (isset($path['path'])) {

            $uri_array['path'] = $path['path'];
        }
    }

    $uri_array['path'] = str_replace(DIRECTORY_SEPARATOR, '/', dirname(rtrim($uri_array['path'], '/'). '/a'));

    if (strlen(trim($append_path)) > 0) {
        $uri_array['path'].= $append_path;
    }

    $server_uri = (isset($uri_array['scheme'])) ? "{$uri_array['scheme']}://" : '';
    $server_uri.= (isset($uri_array['host']))   ? "{$uri_array['host']}"      : '';
    $server_uri.= (isset($uri_array['port']))   ? ":{$uri_array['port']}"     : '';
    $server_uri.= (isset($uri_array['path']))   ? "{$uri_array['path']}"      : '';

    return $server_uri;
}

function html_get_forum_file_path($file_path, $allow_cdn = true, $use_full_path = false)
{
    // Cache of requested file paths.
    static $file_path_cache_array = array();

    // Check if the path is in the cache.
    if (!isset($file_path_cache_array[$file_path])) {

        // Get the BH_FORUM_PATH prefix.
        $forum_path = defined('BH_FORUM_PATH') ? rtrim(BH_FORUM_PATH, '/') : '.';

        // HTTP schema
        $http_scheme = (isset($_SERVER['HTTPS']) && mb_strtolower($_SERVER['HTTPS']) == 'on') ? 'https' : 'http';

        // Disable CDN for everything but images, CSS and icons.
        if (($url_file_path = @parse_url($file_path, PHP_URL_PATH))) {
            $allow_cdn = (preg_match('/\.png$|\.css$|\.ico$/Diu', $url_file_path) > 0) ? $allow_cdn : false;
        }

        // If CDN is allowed, get the CDN path including the domain.
        if (($allow_cdn === true) && ($cdn_domain = forum_get_content_delivery_path($file_path))) {
            $final_file_path = sprintf('%s://%s/%s', $http_scheme, trim($cdn_domain, '/'), ltrim($file_path, '/'));
        } else if (($use_full_path === true) && ($forum_uri = html_get_forum_uri())) {
            $final_file_path = sprintf('%s/%s', $forum_uri, ltrim($file_path, '/'));
        } else {
            $final_file_path = preg_replace('/^.\//', '', sprintf('%s/%s', $forum_path, ltrim($file_path, '/')));
        }

        // Add final file path to the cache.
        $file_path_cache_array[$file_path] = $final_file_path;
    }

    // Return the cached entry.
    return $file_path_cache_array[$file_path];
}

?>
