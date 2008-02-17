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

/* $Id: html.inc.php,v 1.275 2008-02-17 09:58:28 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

if (@file_exists(BH_INCLUDE_PATH. "config.inc.php")) {
    include_once(BH_INCLUDE_PATH. "config.inc.php");
}

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "htmltools.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "pm.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

function html_guest_error()
{
     $frame_top_target = html_get_top_frame_name();

     $lang = load_language_file();

     $final_uri = basename(get_request_uri());

     html_draw_top("robots=noindex,nofollow");
     html_error_msg($lang['guesterror'], 'logout.php', 'get', array('submit' => $lang['loginnow']), array('final_uri' => $final_uri), $frame_top_target);
     html_draw_bottom();
}

function html_error_msg($error_msg, $href = false, $method = 'get', $button_array = false, $var_array = false, $target = "_self", $align = "left")
{
     $lang = load_language_file();
     html_display_msg($lang['error'], $error_msg, $href, $method, $button_array, $var_array, $target, $align);
}

function html_display_msg($header_text, $string_msg, $href = false, $method = 'get', $button_array = false, $var_array = false, $target = "_self", $align = "left")
{
    $webtag = get_webtag($webtag_search);

    $lang = load_language_file();

    $available_methods = array('get', 'post');
    if (!in_array($method, $available_methods)) $method = 'get';

    $available_alignments = array('left', 'center', 'right');
    if (!in_array($align, $available_alignments)) $align = 'left';

    echo "<h1>$header_text</h1>\n";
    echo "<br />\n";

    if (($href !== false) && strlen(trim($href)) > 0) {

        echo "<form action=\"$href\" method=\"$method\" target=\"$target\">\n";
        echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";

        if (is_array($var_array)) {

            echo "  ", form_input_hidden_array($var_array), "\n";
        }
    }

    echo "  <div align=\"$align\">\n";
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

    if (($href !== false) && strlen(trim($href)) > 0) {

        $button_html_array = array();

        if (is_array($button_array) && sizeof($button_array) > 0) {

            foreach($button_array as $button_name => $button_label) {
                $button_html_array[] = form_submit(_htmlentities($button_name), _htmlentities($button_label));
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

    if (($href !== false) && strlen(trim($href)) > 0) {
        echo "</form>\n";
    }
}

function html_display_error_array($error_list_array, $width = '600', $align = 'center')
{
    $lang = load_language_file();

    if (!preg_match('/[0-9]+%?/', $width)) $width = '600';

    if (!is_array($error_list_array)) $error_msg_array = array($error_msg_array);

    $available_alignments = array('left', 'center', 'right');
    if (!in_array($align, $available_alignments)) $align = 'left';

    echo "<div align=\"$align\">\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"$width\" class=\"error_msg\">\n";
    echo "    <tr>\n";
    echo "      <td rowspan=\"2\" valign=\"top\" width=\"25\" class=\"error_msg_icon\"><img src=\"", style_image('error.png'), "\" width=\"15\" height=\"15\" alt=\"{$lang['error']}\" title=\"{$lang['error']}\" /></td>\n";
    echo "      <td class=\"error_msg_icon\">{$lang['thefollowingerrorswereencountered']}</td>\n";
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

function html_display_success_msg($string_msg, $width = '600', $align = 'center')
{
    $lang = load_language_file();

    if (!preg_match('/[0-9]+%?/', $width)) $width = '600';

    if (!is_string($string_msg)) return false;

    $available_alignments = array('left', 'center', 'right');
    if (!in_array($align, $available_alignments)) $align = 'left';

    echo "<div align=\"$align\">\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"$width\" class=\"success_msg\">\n";
    echo "    <tr>\n";
    echo "      <td valign=\"top\" width=\"25\" class=\"success_msg_icon\"><img src=\"", style_image('success.png'), "\" width=\"15\" height=\"15\" alt=\"{$lang['success']}\" title=\"{$lang['success']}\" /></td>\n";
    echo "      <td valign=\"top\" class=\"success_msg_icon\">$string_msg</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</div>\n";
}

function html_display_error_msg($string_msg, $width = '600', $align = 'center')
{
    $lang = load_language_file();

    if (!preg_match('/[0-9]+%?/', $width)) $width = '600';

    if (!is_string($string_msg)) return false;

    $available_alignments = array('left', 'center', 'right');
    if (!in_array($align, $available_alignments)) $align = 'left';

    echo "<div align=\"$align\">\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"$width\" class=\"error_msg\">\n";
    echo "    <tr>\n";
    echo "      <td valign=\"top\" width=\"25\" class=\"error_msg_icon\"><img src=\"", style_image('error.png'), "\" width=\"15\" height=\"15\" alt=\"{$lang['error']}\" title=\"{$lang['error']}\" /></td>\n";
    echo "      <td valign=\"top\" class=\"error_msg_icon\">$string_msg</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</div>\n";
}

function html_display_warning_msg($string_msg, $width = '600', $align = 'center')
{
    $lang = load_language_file();

    if (!preg_match('/[0-9]+%?/', $width)) $width = '600';

    if (!is_string($string_msg)) return false;

    $available_alignments = array('left', 'center', 'right');
    if (!in_array($align, $available_alignments)) $align = 'left';

    echo "<div align=\"$align\">\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"$width\" class=\"warning_msg\">\n";
    echo "    <tr>\n";
    echo "      <td valign=\"top\" width=\"25\" class=\"warning_msg_icon\"><img src=\"", style_image('warning.png'), "\" width=\"15\" height=\"15\" alt=\"{$lang['warning']}\" title=\"{$lang['warning']}\" /></td>\n";
    echo "      <td valign=\"top\" class=\"warning_msg_text\">$string_msg</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</div>\n";
}

function html_display_success_msg_js($string_msg, $width = '600', $align = 'center')
{
    ob_start();

    html_display_success_msg($string_msg, $width, $align);

    $html_display_success_msg_html = ob_get_contents();

    ob_end_clean();

    return html_js_safe_str($html_display_success_msg_html);
}

function html_user_banned()
{
    header_server_error();
}

function html_user_require_approval()
{
    $lang = load_language_file();

    html_draw_top("robots=noindex,nofollow");
    html_error_msg($lang['userapprovalrequiredbeforeaccess']);
    html_draw_bottom();
}

function html_email_confirmation_error()
{
    $lang = load_language_file();

    $webtag = get_webtag($webtag_search);

    if (($uid = bh_session_get_value('UID')) === false) return false;

    $user_array = user_get($uid);

    html_draw_top("robots=noindex,nofollow");
    html_error_msg($lang['emailconfirmationrequiredbeforepost'], 'confirm_email.php', 'get', array('resend' => $lang['resendconfirmation']), array('uid' => $user_array['UID'], 'resend' => 'Y'));
    html_draw_bottom();
}

function html_message_type_error()
{
    $lang = load_language_file();

    html_draw_top();
    html_error_msg($lang['cannotpostthisthreadtype']);
    html_draw_bottom();
}

function html_get_top_page()
{
    $webtag = get_webtag($webtag_search);

    $forum_settings = forum_get_settings();

    $forum_path = defined('BH_FORUM_PATH') ? BH_FORUM_PATH : '.';

    if (($user_style = bh_session_get_value('STYLE')) === false) {
        $user_style = forum_get_setting('default_style');
    }

    if ($user_style !== false) {

        if (@is_dir("$forum_path/styles/$user_style") && @file_exists("$forum_path/styles/$user_style/top.html")) {
            return "$forum_path/styles/$user_style/top.html";
        }

        if (@is_dir("$forum_path/forums/$webtag/styles/$user_style") && @file_exists("$forum_path/forums/$webtag/styles/$user_style/top.html")) {
            return "$forum_path/forums/$webtag/styles/$user_style/top.html";
        }
    }

    if ($webtag !== false) {

        if (@is_dir("$forum_path/forums/$webtag") && @file_exists("$forum_path/forums/$webtag/top.html")) {
            return "$forum_path/forums/$webtag/top.html";
        }
    }

    return "$forum_path/styles/top.html";
}

function html_get_style_sheet()
{
    $webtag = get_webtag($webtag_search);

    $forum_settings = forum_get_settings();

    $forum_path = defined('BH_FORUM_PATH') ? BH_FORUM_PATH : '.';

    $script_filename = basename($_SERVER['PHP_SELF'], '.php');

    if (($user_style = bh_session_get_value('STYLE')) === false) {
        $user_style = forum_get_setting('default_style');
    }

    if ($user_style !== false) {

        if (@is_dir("$forum_path/styles/$user_style") && @file_exists("$forum_path/styles/$user_style/$script_filename.css")) {

            if ($modified_time = @filemtime("$forum_path/styles/$user_style/$script_filename.css")) {
                return sprintf("$forum_path/styles/$user_style/$script_filename.css?%s", date('YmdHis', $modified_time));
            }
        }

        if (@is_dir("$forum_path/styles/$user_style") && @file_exists("$forum_path/styles/$user_style/style.css")) {

            if ($modified_time = @filemtime("$forum_path/styles/$user_style/style.css")) {
                return sprintf("$forum_path/styles/$user_style/style.css?%s", date('YmdHis', $modified_time));
            }
        }

        if (@is_dir("$forum_path/forums/$webtag/styles/$user_style") && @file_exists("$forum_path/forums/$webtag/styles/$user_style/$script_filename.css")) {

            if ($modified_time = @filemtime("$forum_path/forums/$webtag/styles/$user_style/$script_filename.css")) {
                return sprintf("$forum_path/forums/$webtag/styles/$user_style/$script_filename.css?%s", date('YmdHis', $modified_time));
            }
        }

        if (@is_dir("$forum_path/forums/$webtag/styles/$user_style") && @file_exists("$forum_path/forums/$webtag/styles/$user_style/style.css")) {

            if ($modified_time = @filemtime("$forum_path/forums/$webtag/styles/$user_style/style.css")) {
                return sprintf("$forum_path/forums/$webtag/styles/$user_style/style.css?%s", date('YmdHis', $modified_time));
            }
        }
    }

    if ($webtag !== false) {

        if (@is_dir("$forum_path/forums/$webtag") && @file_exists("$forum_path/forums/$webtag/style.css")) {

            if ($modified_time = @filemtime("$forum_path/forums/$webtag/style.css")) {
                return sprintf("$forum_path/forums/$webtag/style.css?%s", date('YmdHis', $modified_time));
            }
        }
    }

    if (@is_dir("$forum_path/styles") && @file_exists("$forum_path/styles/style.css")) {

        if ($modified_time = @filemtime("$forum_path/styles/style.css")) {
            return sprintf("$forum_path/styles/style.css?%s", date('YmdHis', $modified_time));
        }
    }

    return false;
}

function html_get_emoticon_style_sheet()
{
    $webtag = get_webtag($webtag_search);

    $forum_settings = forum_get_settings();

    $forum_path = defined('BH_FORUM_PATH') ? BH_FORUM_PATH : '.';

    if (($user_emots = bh_session_get_value('EMOTICONS')) === false) {
        $user_emots = forum_get_setting('default_emoticons');
    }

    if ($user_emots !== false) {

        if (@is_dir("$forum_path/emoticons/$user_emots") && file_exists("$forum_path/emoticons/$user_emots/style.css")) {

            if ($modified_time = @filemtime("$forum_path/emoticons/$user_emots/style.css")) {
                return sprintf("$forum_path/emoticons/$user_emots/style.css?%s", date('YmdHis', $modified_time));
            }
        }

        if (@is_dir("$forum_path/forums/$webtag/emoticons/$user_emots") && file_exists("$forum_path/forums/$webtag/emoticons/$user_emots/style.css")) {

            if ($modified_time = @filemtime("$forum_path/forums/$webtag/emoticons/$user_emots/style.css")) {
                return sprintf("$forum_path/forums/$webtag/emoticons/$user_emots/style.css?%s", date('YmdHis', $modified_time));
            }
        }
    }

    return false;
}

function html_get_forum_keywords()
{
    $webtag = get_webtag($webtag_search);

    $forum_settings = forum_get_settings();

    if ($forum_keywords = forum_get_setting('forum_keywords')) {

        return $forum_keywords;
    }

    return "";
}

function html_get_forum_description()
{
    $webtag = get_webtag($webtag_search);

    $forum_settings = forum_get_settings();

    if ($forum_desc = forum_get_setting('forum_desc')) {

        return $forum_desc;
    }

    return "";
}

function html_get_forum_email()
{
    $webtag = get_webtag($webtag_search);

    $forum_settings = forum_get_settings();

    if ($forum_email = forum_get_setting('forum_email')) {

        return $forum_email;
    }

    return "";
}

function html_get_frame_name($basename)
{
    // Forum URL

    $forum_uri = html_get_forum_uri();

    // If webtag available add that to the hash.

    if ($webtag = get_webtag($webtag_search)) {

        $frame_md5_hash = md5(sprintf('%s-%s-%s', $forum_uri, $webtag, $basename));
        return sprintf('bh_frame_%s', preg_replace('/[^a-z]+/i', '', $frame_md5_hash));
    }

    // No webtag just use forum URL and frame basename.

    $frame_md5_hash = md5(sprintf('%s-%s', $forum_uri, $basename));
    return sprintf('bh_frame_%s', preg_replace('/[^a-z]+/i', '', $frame_md5_hash));
}

function html_get_top_frame_name()
{
    if (isset($GLOBALS['frame_top_target']) && strlen(trim($GLOBALS['frame_top_target'])) > 0) {
        return $GLOBALS['frame_top_target'];
    }

    return '_top';
}

// Draws the top of the HTML page including DOCTYPE, head and body tags
//
// Usage:
//
//      html_draw_top() supports an unlimited argument count, which
//      allows you to load .js support files from Beehive's /js/
//      folder. For example:
//
//      html_draw_top("openprofile.js")
//
//      This will include openprofile.js as a
//      <script src="openprofile.js"> tag within the HTML output.
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

    $onload_array = array();
    $onunload_array = array();

    $arg_array = func_get_args();
    $meta_refresh_delay = false;
    $meta_refresh_url = false;

    $robots = "noindex,nofollow";

    $forum_settings = forum_get_settings();

    $webtag = get_webtag($webtag_search);

    $forum_path = defined('BH_FORUM_PATH') ? BH_FORUM_PATH : '.';

    $include_body_tag = true;
    $frameset_dtd = false;
    $pm_popup_disabled = false;

    foreach($arg_array as $key => $func_args) {

        if (preg_match("/^title=([^$]+)$/i", $func_args, $func_matches) > 0) {
            if (!isset($title)) $title = $func_matches[1];
            unset($arg_array[$key]);
        }

        if (preg_match("/^class=([^$]+)$/i", $func_args, $func_matches) > 0) {
            if (!isset($body_class)) $body_class = $func_matches[1];
            unset($arg_array[$key]);
        }

        if (preg_match("/^basetarget=([^$]+)$/i", $func_args, $func_matches) > 0) {
            if (!isset($base_target)) $base_target = $func_matches[1];
            unset($arg_array[$key]);
        }

        if (preg_match("/^onload=([^$]+)$/i", $func_args, $func_matches) > 0) {
            $onload_array[] = $func_matches[1];
            unset($arg_array[$key]);
        }

        if (preg_match("/^onunload=([^$]+)$/i", $func_args, $func_matches) > 0) {
            $onunload_array[] = $func_matches[1];
            unset($arg_array[$key]);
        }

        if (preg_match("/^stylesheet=([^:]+):([^$]+)$/i", $func_args, $func_matches) > 0) {

            $stylesheet_array[] = array('filename' => $func_matches[1], 'media' => $func_matches[2]);
            unset($arg_array[$key]);

        }elseif (preg_match("/^stylesheet=([^$]+)$/i", $func_args, $func_matches) > 0) {

            $stylesheet_array[] = array('filename' => $func_matches[1], 'media' => 'screen');
            unset($arg_array[$key]);
        }

        if (preg_match("/^refresh=([^:]+):([^$]+)$/i", $func_args, $func_matches) > 0) {

            if (isset($func_matches[1]) && is_numeric($func_matches[1])) {

                if (isset($func_matches[2])) {

                     $meta_refresh_delay = $func_matches[1];
                     $meta_refresh_url = basename($func_matches[2]);
                }
            }

            unset($arg_array[$key]);
        }

        if (preg_match("/^robots=([^$]+)$/i", $func_args, $func_matches) > 0) {
            $robots = $func_matches[1];
            unset($arg_array[$key]);
        }

        if (preg_match("/^body_tag=([^$]+)$/i", $func_args, $func_matches) > 0) {
            $include_body_tag = $func_matches[1];
            unset($arg_array[$key]);
        }

        if (preg_match("/^frames=([^$]+)$/i", $func_args, $func_matches) > 0) {
            $frameset_dtd = $func_matches[1];
            unset($arg_array[$key]);
        }

        if (preg_match("/^resize_width=([^$]+)$/i", $func_args, $func_matches) > 0) {
            $resize_width = $func_matches[1];
            unset($arg_array[$key]);
        }

        if (preg_match("/^pm_popup_disabled$/i", $func_args, $func_matches) > 0) {
            $pm_popup_disabled = true;
            unset($arg_array[$key]);
        }
    }

    if (!isset($title)) $title = forum_get_setting('forum_name', false, 'A Beehive Forum');
    if (!isset($body_class)) $body_class = false;
    if (!isset($base_target)) $base_target = false;
    if (!isset($resize_width)) $resize_width = 0;

    $forum_keywords = html_get_forum_keywords();
    $forum_description = html_get_forum_description();
    $forum_email = html_get_forum_email();

    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

    if ($frameset_dtd === false) {
        echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
    }else {
        echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Frameset//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd\">\n";
    }

    echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"{$lang['_isocode']}\" lang=\"{$lang['_isocode']}\" dir=\"{$lang['_textdir']}\">\n";
    echo "<head>\n";
    echo "<title>$title</title>\n";
    echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />\n";
    echo "<meta name=\"generator\" content=\"Beehive Forum ", BEEHIVE_VERSION, "\" />\n";
    echo "<meta name=\"keywords\" content=\"$forum_keywords\" />\n";
    echo "<meta name=\"description\" content=\"$forum_description\" />\n";

    if (forum_get_setting('allow_search_spidering', 'N')) {

        echo "<meta name=\"robots\" content=\"noindex,nofollow\" />\n";

    }elseif (strlen(trim($robots)) > 0) {

        echo "<meta name=\"robots\" content=\"$robots\" />\n";
    }

    if ($meta_refresh_delay && $meta_refresh_url) {
        echo "<meta http-equiv=\"refresh\" content=\"{$meta_refresh_delay}; url={$meta_refresh_url}\" />\n";
    }

    if (basename($_SERVER['PHP_SELF']) == "index.php") {
        echo "<link rel=\"alternate\" type=\"application/rss+xml\" title=\"{$title} - {$lang['rssfeed']}\" href=\"$forum_path/threads_rss.php?webtag=$webtag\" />\n";
    }

    if (file_exists("forums/$webtag/favicon.ico")) {
        echo "<link rel=\"icon\" href=\"$forum_path/forums/$webtag/favicon.ico\" type=\"image/ico\" />\n";
    }

    if ($stylesheet = html_get_style_sheet()) {
        echo "<link rel=\"stylesheet\" href=\"$stylesheet\" type=\"text/css\" media=\"screen\" />\n";
    }

    if ($emoticon_style_sheet = html_get_emoticon_style_sheet()) {
        echo "<link rel=\"stylesheet\" href=\"$emoticon_style_sheet\" type=\"text/css\" />\n";
    }

    if (isset($stylesheet_array) && is_array($stylesheet_array)) {

        foreach($stylesheet_array as $stylesheet) {

            if (isset($stylesheet['filename']) && isset($stylesheet['filename'])) {

                echo "<link rel=\"stylesheet\" href=\"{$stylesheet['filename']}\" type=\"text/css\" media=\"{$stylesheet['media']}\" />\n";
            }
        }
    }

    echo "<link rel=\"search\" type=\"application/opensearchdescription+xml\" href=\"$forum_path/search.php?webtag=$webtag&amp;opensearch\" title=\"{$title}\" />\n";

    if ($base_target) echo "<base target=\"$base_target\" />\n";

    // Dynamic Frame names.

    echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
    echo "<!--\n\n";
    echo "var bh_frame_main = '", html_get_frame_name('main'), "'\n";
    echo "var bh_frame_ftop = '", html_get_frame_name('ftop'), "'\n";
    echo "var bh_frame_fnav = '", html_get_frame_name('fnav'), "'\n";
    echo "var bh_frame_left = '", html_get_frame_name('left'), "'\n";
    echo "var bh_frame_right = '", html_get_frame_name('right'), "'\n";
    echo "var bh_frame_pm_folders = '", html_get_frame_name('pm_folders'), "'\n";
    echo "var bh_frame_pm_messages = '", html_get_frame_name('pm_messages'), "'\n\n";
    echo "//-->\n";
    echo "</script>\n";

    if ($modified_time = @filemtime("js/general.js")) {
        echo sprintf("<script language=\"Javascript\" type=\"text/javascript\" src=\"js/general.js?%s\"></script>\n", date('YmdHis', $modified_time));
    }

    if ($modified_time = @filemtime("js/xml_http.js")) {
        echo sprintf("<script language=\"Javascript\" type=\"text/javascript\" src=\"js/xml_http.js?%s\"></script>\n", date('YmdHis', $modified_time));
    }

    // Font size (not for Guests)

    if (!user_is_guest()) {

        $fontsize = bh_session_get_value('FONT_SIZE');

        if ($fontsize && $fontsize != '10') {
            echo "<style type=\"text/css\">@import \"font_size.php?webtag=$webtag\";</style>\n";
        }

        if (isset($_GET['font_resize'])) {

            echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
            echo "<!--\n\n";
            echo "top.document.body.rows='60,' + ". max($fontsize* 2, 22) ."+ ',*';\n";
            echo "top.frames['", html_get_frame_name('main'), "'].frames['", html_get_frame_name('left'), "'].location.reload();\n";
            echo "top.frames['", html_get_frame_name('fnav'), "'].location.reload();\n\n";
            echo "//-->\n";
            echo "</script>\n";
        }

        if (isset($_GET['disable_pm_popup'])) {
            $pm_popup_disabled = true;
        }
    }

    if ($include_body_tag === true) {

        // Check for any new PMs.

        if (!user_is_guest()) {

            // Check to see if the PM popup is disabled on the current page.

            if ($pm_popup_disabled === false) {

                // Pages we don't want the popup to appear on

                $pm_popup_disabled_pages = array('attachments.php', 'dictionary.php', 'display_emoticons.php',
                                                 'email.php', 'mods_list.php', 'nav.php', 'pm.php', 'pm_edit.php',
                                                 'pm_folders.php', 'pm_messages.php', 'pm_options.php',
                                                 'poll_results.php', 'search_popup.php', 'user_profile.php');

                // Check that we're not on one of the pages.

                if ((!in_array(basename($_SERVER['PHP_SELF']), $pm_popup_disabled_pages))) {

                    echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
                    echo "<!--\n\n";
                    echo "var pm_timeout;\n";
                    echo "var pm_notification = new xml_http_request();\n\n";
                    echo "function pm_notification_initialise()\n";
                    echo "{\n";
                    echo "    pm_timeout = setTimeout('pm_notification_check_messages()', 1000);\n";
                    echo "    return true;\n";
                    echo "}\n\n";
                    echo "function pm_notification_check_messages()\n";
                    echo "{\n";
                    echo "    clearTimeout(pm_timeout);\n\n";
                    echo "    pm_notification.set_handler(pm_notification_handler);\n";
                    echo "    pm_notification.get_url('pm.php?webtag=$webtag&check_messages=true');\n";
                    echo "}\n\n";
                    echo "function pm_notification_abort()\n";
                    echo "{\n";
                    echo "    pm_notification.abort();\n";
                    echo "    pm_notification.close();\n";
                    echo "    delete pm_notification;\n";
                    echo "}\n\n";
                    echo "function pm_notification_handler()\n";
                    echo "{\n";
                    echo "    var response_xml = pm_notification.get_response_xml();\n\n";
                    echo "    var pm_message_count_obj = getObjById('pm_message_count');\n\n";
                    echo "    if (typeof(pm_message_count_obj) == 'object' && pm_message_count_obj.getElementsByTagName) {\n\n";
                    echo "        var pm_unread_element = response_xml.getElementsByTagName('unread')[0];\n";
                    echo "        var pm_new_element = response_xml.getElementsByTagName('new')[0];\n\n";
                    echo "        if (typeof(pm_unread_element) == 'object' && typeof(pm_new_element) == 'object') {\n\n";
                    echo "            var pm_unread_count = pm_unread_element.childNodes[0].nodeValue;\n";
                    echo "            var pm_new_count = pm_new_element.childNodes[0].nodeValue;\n\n";
                    echo "            if (pm_new_count > 0) {\n\n";
                    echo "               pm_message_count_obj.innerHTML = '[' + pm_new_count + ' {$lang['new']}]';\n\n";
                    echo "            }else if (pm_unread_count > 0) {\n\n";
                    echo "               pm_message_count_obj.innerHTML = '[' + pm_unread_count + ' {$lang['unread']}]';\n";
                    echo "            }\n";
                    echo "        }\n";
                    echo "    }\n\n";
                    echo "    var message_array = response_xml.getElementsByTagName('notification')[0];\n\n";
                    echo "    if (typeof(message_array) == 'object') {\n\n";
                    echo "        var message_display_text = message_array.childNodes[0].nodeValue;\n\n";
                    echo "        if (message_display_text.length > 0) {\n\n";
                    echo "            if (window.confirm(message_display_text)) {\n\n";
                    echo "                top.frames['", html_get_frame_name('main'), "'].location.replace('pm.php?webtag=$webtag');\n";
                    echo "            }\n";
                    echo "        }\n";
                    echo "    }\n\n";
                    echo "    return true;\n";
                    echo "}\n\n";
                    echo "//-->\n";
                    echo "</script>\n";

                    if (!in_array("pm_notification_initialise()", $onload_array)) $onload_array[] = "pm_notification_initialise()";
                    if (!in_array("pm_notification_abort()", $onunload_array)) $onunload_array[] = "pm_notification_abort()";
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

                    $image_resized_text = html_js_safe_str($lang['imageresized']);

                    echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
                    echo "<!--\n\n";
                    echo "document.maxWidth = $resize_width;\n";
                    echo "document.resizeText = '$image_resized_text';\n\n";
                    echo "//-->\n";
                    echo "</script>\n";

                    $onload_array[] = "addOverflow()";
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

                    if ($modified_time = @filemtime("js/spoiler.js")) {

                        echo sprintf("<script language=\"Javascript\" type=\"text/javascript\" src=\"js/spoiler.js?%s\"></script>\n", date('YmdHis', $modified_time));
                        if (!in_array("spoilerInitialise", $onload_array)) $onload_array[] = "spoilerInitialise()";
                    }
                }
            }
        }

        // Stats Display pages

        $stats_display_pages = array('messages.php');

        if (in_array(basename($_SERVER['PHP_SELF']), $stats_display_pages)) {

            if ((bh_session_get_value('SHOW_STATS') == 'Y') || user_is_guest()) {

                $uid = bh_session_get_value('UID');

                $js_user_anon_disabled = USER_ANON_DISABLED;
                $js_user_friend = USER_FRIEND;

                echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
                echo "<!--\n\n";
                echo "var stats_timeout;\n";
                echo "var stats_data = new xml_http_request();\n\n";
                echo "var lang = new Object();\n";
                echo "lang['numactiveguests'] = '", html_js_safe_str($lang['numactiveguests']), "';\n";
                echo "lang['oneactiveguest'] = '", html_js_safe_str($lang['oneactiveguest']), "';\n";
                echo "lang['numactivemembers'] = '", html_js_safe_str($lang['numactivemembers']), "';\n";
                echo "lang['oneactivemember'] = '", html_js_safe_str($lang['oneactivemember']), "';\n";
                echo "lang['numactiveanonymousmembers'] = '", html_js_safe_str($lang['numactiveanonymousmembers']), "';\n";
                echo "lang['oneactiveanonymousmember'] = '", html_js_safe_str($lang['oneactiveanonymousmember']), "';\n";
                echo "lang['usersactiveinthepasttimeperiod'] = '", html_js_safe_str($lang['usersactiveinthepasttimeperiod']), "';\n";
                echo "lang['youinvisible'] = '", html_js_safe_str($lang['youinvisible']), "';\n";
                echo "lang['younormal'] = '", html_js_safe_str($lang['younormal']), "';\n";
                echo "lang['friend'] = '", html_js_safe_str($lang['friend']), "';\n";
                echo "lang['numthreadscreated'] = '", html_js_safe_str($lang['numthreadscreated']), "';\n";
                echo "lang['onethreadcreated'] = '", html_js_safe_str($lang['onethreadcreated']), "';\n";
                echo "lang['numpostscreated'] = '", html_js_safe_str($lang['numpostscreated']), "';\n";
                echo "lang['onepostcreated'] = '", html_js_safe_str($lang['onepostcreated']), "';\n";
                echo "lang['ourmembershavemadeatotalofnumthreadsandnumposts'] = '", html_js_safe_str($lang['ourmembershavemadeatotalofnumthreadsandnumposts']), "';\n";
                echo "lang['longestthreadisthreadnamewithnumposts'] = '", html_js_safe_str($lang['longestthreadisthreadnamewithnumposts']), "';\n";
                echo "lang['therehavebeenxpostsmadeinthelastsixtyminutes'] = '", html_js_safe_str($lang['therehavebeenxpostsmadeinthelastsixtyminutes']), "';\n";
                echo "lang['therehasbeenonepostmadeinthelastsxityminutes'] = '", html_js_safe_str($lang['therehasbeenonepostmadeinthelastsxityminutes']), "';\n";
                echo "lang['mostpostsevermadeinasinglesixtyminuteperiodwasnumposts'] = '", html_js_safe_str($lang['mostpostsevermadeinasinglesixtyminuteperiodwasnumposts']), "';\n";
                echo "lang['wehavenumregisteredmembersandthenewestmemberismembername'] = '", html_js_safe_str($lang['wehavenumregisteredmembersandthenewestmemberismembername']), "';\n";
                echo "lang['wehavenumregisteredmember'] = '", html_js_safe_str($lang['wehavenumregisteredmember']), "';\n";
                echo "lang['wehaveoneregisteredmember'] = '", html_js_safe_str($lang['wehaveoneregisteredmember']), "';\n";
                echo "lang['mostuserseveronlinewasnumondate'] = '", html_js_safe_str($lang['mostuserseveronlinewasnumondate']), "';\n";
                echo "lang['viewcompletelist'] = '", html_js_safe_str($lang['viewcompletelist']), "';\n\n";
                echo "function stats_display_initialise()\n";
                echo "{\n";
                echo "    var forum_stats_obj = getObjById('forum_stats');\n\n";
                echo "    if (typeof(forum_stats_obj) == 'object') {\n\n";
                echo "        stats_timeout = setTimeout('stats_display_get_data()', 1000);\n";
                echo "        return true;\n";
                echo "    }\n";
                echo "}\n\n";
                echo "function stats_display_get_data()\n";
                echo "{\n";
                echo "    clearTimeout(stats_timeout);\n\n";
                echo "    stats_data.set_handler(stats_display_handler);\n";
                echo "    stats_data.get_url('user_stats.php?webtag=$webtag&get_stats=true');\n";
                echo "}\n\n";
                echo "function stats_display_abort()\n";
                echo "{\n";
                echo "    stats_data.abort();\n";
                echo "    stats_data.close();\n";
                echo "    delete stats_data;\n";
                echo "}\n\n";
                echo "function stats_display_handler()\n";
                echo "{\n";
                echo "    var response_xml = stats_data.get_response_xml();\n\n";
                echo "    if (typeof(response_xml) == 'object') {\n\n";
                echo "        var user_stats_xml = response_xml.getElementsByTagName('users')[0];\n\n";
                echo "        var thread_stats_xml = response_xml.getElementsByTagName('threads')[0];\n\n";
                echo "        var post_stats_xml = response_xml.getElementsByTagName('posts')[0];\n\n";
                echo "        active_user_counts_obj = document.getElementById('active_user_counts');\n\n";
                echo "        if (typeof(active_user_counts_obj) == 'object') {\n\n";
                echo "            if (typeof(user_stats_xml) == 'object') {\n\n";
                echo "                var active_users_xml = user_stats_xml.getElementsByTagName('active')[0];\n\n";
                echo "                var active_guest_count = active_users_xml.getElementsByTagName('guests')[0].childNodes[0].nodeValue;\n";
                echo "                var active_nuser_count = active_users_xml.getElementsByTagName('visible')[0].childNodes[0].nodeValue;\n";
                echo "                var active_auser_count = active_users_xml.getElementsByTagName('anonymous')[0].childNodes[0].nodeValue;\n\n";
                echo "                var visitor_log_link = sprintf('[ <a href=\"start.php?webtag=$webtag&amp;show=visitors\" target=\"%s\">%s<\/a> ]', '", html_get_frame_name('main'), "', lang['viewcompletelist']);\n\n";
                echo "                var active_users_array = new Array();\n\n";
                echo "                active_users_array[0] = (active_guest_count != 1) ? sprintf(lang['numactiveguests'], active_guest_count) : lang['oneactiveguest'];\n";
                echo "                active_users_array[1] = (active_nuser_count != 1) ? sprintf(lang['numactivemembers'], active_nuser_count) : lang['oneactivemember'];\n";
                echo "                active_users_array[2] = (active_auser_count != 1) ? sprintf(lang['numactiveanonymousmembers'], active_auser_count) : lang['oneactiveanonymousmember'];\n\n";
                echo "                var active_user_text = sprintf(lang['usersactiveinthepasttimeperiod'], active_users_array.join(', '), '", format_time_display(forum_get_setting('active_sess_cutoff', false, 900), false), "', visitor_log_link);\n\n";
                echo "                active_user_counts_obj.innerHTML = active_user_text;\n";
                echo "            }\n\n";
                echo "        }\n\n";
                echo "        active_user_list_obj = document.getElementById('active_user_list');\n\n";
                echo "        if (typeof(active_user_list_obj) == 'object') {\n\n";
                echo "            if (typeof(user_stats_xml) == 'object') {\n\n";
                echo "                active_users_xml = user_stats_xml.getElementsByTagName('active')[0];\n\n";
                echo "                active_user_list_xml = active_users_xml.getElementsByTagName('list')[0];\n\n";
                echo "                if (typeof(active_user_list_xml) == 'object') {\n\n";
                echo "                    var active_user_list_array = new Array(); var count = 0;\n\n";
                echo "                    active_user_array_xml = active_user_list_xml.getElementsByTagName('user');\n\n";
                echo "                    if (typeof(active_user_array_xml) == 'object') {\n\n";
                echo "                        for (var i = 0; i < active_user_array_xml.length; i++) {\n\n";
                echo "                            active_user_uid  = active_user_array_xml[i].getElementsByTagName('uid')[0].childNodes[0].nodeValue;\n";
                echo "                            active_user_display = active_user_array_xml[i].getElementsByTagName('display')[0].childNodes[0].nodeValue;\n";
                echo "                            active_user_relationship = active_user_array_xml[i].getElementsByTagName('relationship')[0].childNodes[0].nodeValue;\n";
                echo "                            active_user_anonymous = active_user_array_xml[i].getElementsByTagName('anonymous')[0].childNodes[0].nodeValue;\n\n";
                echo "                            if (active_user_uid == $uid) {\n\n";
                echo "                                if (active_user_anonymous > $js_user_anon_disabled) {\n\n";
                echo "                                    active_user_text = sprintf('<span class=\"user_stats_curuser\" title=\"%s\">%s<\/span>', lang['youinvisible'], active_user_display);\n\n";
                echo "                                }else {\n\n";
                echo "                                    active_user_text = sprintf('<span class=\"user_stats_curuser\" title=\"%s\">%s<\/span>', lang['younormal'], active_user_display);\n";
                echo "                                }\n\n";
                echo "                            }else if (active_user_relationship & $js_user_friend) {\n\n";
                echo "                                active_user_text = sprintf('<span class=\"user_stats_friend\" title=\"%s\">%s<\/span>', lang['friend'], active_user_display);\n\n";
                echo "                            }else {\n\n";
                echo "                                active_user_text = sprintf('<span class=\"user_stats_normal\">%s<\/span>', active_user_display);\n";
                echo "                            }\n\n";
                echo "                            active_user_link = sprintf('<a href=\"user_profile.php?webtag=$webtag&uid=%s\" onclick=\"return openProfile(%s, \'$webtag\')\">%s<\/a>', active_user_uid, active_user_uid, active_user_text);\n";
                echo "                            active_user_list_array[count] = active_user_link; count++\n";
                echo "                        }\n";
                echo "                        active_user_list_obj.innerHTML = active_user_list_array.join(', ');\n";
                echo "                    }\n";
                echo "                }\n";
                echo "            }\n";
                echo "        }\n\n";
                echo "        thread_stats_obj = document.getElementById('thread_stats');\n\n";
                echo "        if (typeof(thread_stats_obj) == 'object') {\n\n";
                echo "            if (typeof(thread_stats_xml) == 'object') {\n\n";
                echo "                num_threads = thread_stats_xml.getElementsByTagName('count')[0].childNodes[0].nodeValue;\n";
                echo "                num_posts = post_stats_xml.getElementsByTagName('count')[0].childNodes[0].nodeValue;\n\n";
                echo "                num_threads_display = (num_threads != 1) ? sprintf(lang['numthreadscreated'], num_threads) : lang['onethreadcreated'];\n";
                echo "                num_posts_display = (num_posts != 1) ? sprintf(lang['numpostscreated'], num_posts) : lang['onepostcreated'];\n\n";
                echo "                thread_post_stats_text = sprintf(lang['ourmembershavemadeatotalofnumthreadsandnumposts'] + '<br />', num_threads_display, num_posts_display);\n\n";
                echo "                thread_stats_obj.innerHTML = thread_post_stats_text;\n\n";
                echo "                longest_thread_xml = thread_stats_xml.getElementsByTagName('longest')[0];\n\n";
                echo "                longest_thread_tid = longest_thread_xml.getElementsByTagName('tid')[0].childNodes[0].nodeValue;\n";
                echo "                longest_thread_title = longest_thread_xml.getElementsByTagName('title')[0].childNodes[0].nodeValue;\n";
                echo "                longest_thread_length = longest_thread_xml.getElementsByTagName('length')[0].childNodes[0].nodeValue;\n\n";
                echo "                longest_thread_link = sprintf('<a href=\"index.php?webtag=$webtag&amp;msg=%s.1\">%s<\/a>', longest_thread_tid, longest_thread_title);\n";
                echo "                longest_thread_post_count = (longest_thread_length != 1) ? sprintf(lang['numpostscreated'], longest_thread_length) : lang['onepostcreated'];\n\n";
                echo "                longest_thread_text = sprintf(lang['longestthreadisthreadnamewithnumposts'], longest_thread_link, longest_thread_post_count);\n\n";
                echo "                thread_stats_obj.innerHTML+= longest_thread_text;\n";
                echo "            }\n";
                echo "        }\n\n";
                echo "        post_stats_obj = document.getElementById('post_stats');\n\n";
                echo "        if (typeof(post_stats_obj) == 'object') {\n\n";
                echo "            if (typeof(post_stats_xml) == 'object') {\n\n";
                echo "                num_posts = post_stats_xml.getElementsByTagName('count')[0].childNodes[0].nodeValue;\n\n";
                echo "                post_stats_recent = post_stats_xml.getElementsByTagName('recent')[0];\n";
                echo "                post_stats_record = post_stats_recent.getElementsByTagName('record')[0];\n\n";
                echo "                if (typeof(post_stats_recent) == 'object') {\n\n";
                echo "                    post_stats_recent_count = post_stats_recent.getElementsByTagName('count')[0].childNodes[0].nodeValue;\n";
                echo "                    post_stats_recent_text = (post_stats_recent_count != 1) ? sprintf(lang['therehavebeenxpostsmadeinthelastsixtyminutes'] + '<br />', post_stats_recent_count) : lang['therehasbeenonepostmadeinthelastsxityminutes'];\n\n";
                echo "                    post_stats_obj.innerHTML = post_stats_recent_text;\n\n";
                echo "                    if (typeof(post_stats_record) == 'object') {\n\n";
                echo "                        post_stats_record_count = post_stats_record.getElementsByTagName('count')[0].childNodes[0].nodeValue;\n";
                echo "                        post_stats_record_date = post_stats_record.getElementsByTagName('date')[0].childNodes[0].nodeValue;\n\n";
                echo "                        post_stats_record_text = sprintf(lang['mostpostsevermadeinasinglesixtyminuteperiodwasnumposts'], post_stats_record_count, post_stats_record_date);\n\n";
                echo "                        post_stats_obj.innerHTML+= post_stats_record_text;\n";
                echo "                    }\n\n";
                echo "                }\n";
                echo "            }\n";
                echo "        }\n\n";
                echo "        user_stats_obj = document.getElementById('user_stats');\n\n";
                echo "        if (typeof(user_stats_obj) == 'object') {\n\n";
                echo "            if (typeof(user_stats_xml) == 'object') {\n\n";
                echo "                user_count = user_stats_xml.getElementsByTagName('count')[0].childNodes[0].nodeValue;\n\n";
                echo "                if (user_count != 1) {\n\n";
                echo "                    user_newest_xml = user_stats_xml.getElementsByTagName('newest')[0];\n\n";
                echo "                    if (typeof(user_newest_xml) == 'object') {\n\n";
                echo "                        user_newest_uid = user_newest_xml.getElementsByTagName('uid')[0].childNodes[0].nodeValue;\n";
                echo "                        user_newest_display = user_newest_xml.getElementsByTagName('display')[0].childNodes[0].nodeValue;\n\n";
                echo "                        user_newest_profile_link = sprintf('<a href=\"user_profile.php?webtag=$webtag&amp;uid=%s\" target=\"_blank\" onclick=\"return openProfile(%s, \'$webtag\')\">%s<\/a>', user_newest_uid, user_newest_uid, user_newest_display);\n\n";
                echo "                        user_stats_text = sprintf(lang['wehavenumregisteredmembersandthenewestmemberismembername'] + '<br />', user_count, user_newest_profile_link);\n\n";
                echo "                    }else {\n\n";
                echo "                        user_stats_text = sprintf(lang['wehavenumregisteredmember'] + '<br />', user_count);\n";
                echo "                    }\n\n";
                echo "                }else {\n\n";
                echo "                    user_stats_text = lang['wehaveoneregisteredmember'] + '<br />';\n";
                echo "                }\n\n";
                echo "                user_stats_obj.innerHTML = user_stats_text;\n\n";
                echo "                user_stats_record = user_stats_xml.getElementsByTagName('record')[0];\n";
                echo "                user_stats_record_count = user_stats_record.getElementsByTagName('count')[0].childNodes[0].nodeValue;\n";
                echo "                user_stats_record_date = user_stats_record.getElementsByTagName('date')[0].childNodes[0].nodeValue;\n\n";
                echo "                user_stats_record_text = sprintf(lang['mostuserseveronlinewasnumondate'], user_stats_record_count, user_stats_record_date);\n\n";
                echo "                user_stats_obj.innerHTML+= user_stats_record_text;\n";
                echo "            }\n";
                echo "        }\n";
                echo "    }\n";
                echo "}\n";
                echo "//-->\n";
                echo "</script>\n";

                if (!in_array("stats_display_initialise()", $onload_array)) $onload_array[] = "stats_display_initialise()";
                if (!in_array("stats_display_abort()", $onunload_array)) $onunload_array[] = "stats_display_abort()";
            }
        }

        $captcha_reload_pages = array('register.php');

        if (in_array(basename($_SERVER['PHP_SELF']), $captcha_reload_pages)) {

            if (forum_get_setting('text_captcha_enabled', 'Y')) {

                echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
                echo "<!--\n\n";
                echo "var captcha_data = new xml_http_request();\n\n";
                echo "function captcha_reload()\n";
                echo "{\n";
                echo "    captcha_data.set_handler(captcha_reload_handler);\n";
                echo "    captcha_data.get_url('register.php?webtag=$webtag&reload_captcha=true');\n";
                echo "}\n\n";
                echo "function captcha_reload_abort()\n";
                echo "{\n";
                echo "    captcha_data.abort();\n";
                echo "    captcha_data.close();\n";
                echo "    delete captcha_data;\n";
                echo "}\n\n";
                echo "function captcha_reload_handler()\n";
                echo "{\n";
                echo "    var response_xml = captcha_data.get_response_xml();\n\n";
                echo "    var captcha_img_obj = getObjById('captcha_img');\n";
                echo "    var private_key_obj = getObjsByName('private_key')[0];\n";
                echo "    var public_key_obj  = getObjsByName('public_key')[0];\n\n";
                echo "    if (typeof(captcha_img_obj) == 'object' && captcha_img_obj.getElementsByTagName) {\n\n";
                echo "        if (typeof(private_key_obj) == 'object' && private_key_obj.getElementsByTagName) {\n\n";
                echo "            if (typeof(public_key_obj) == 'object' && public_key_obj.getElementsByTagName) {\n\n";
                echo "                var new_captcha_img = response_xml.getElementsByTagName('image')[0];\n";
                echo "                var new_key_length  = response_xml.getElementsByTagName('chars')[0];\n";
                echo "                var new_public_key  = response_xml.getElementsByTagName('key')[0];\n\n";
                echo "                if (typeof(new_captcha_img) == 'object' && typeof(new_key_length) == 'object' && typeof(new_public_key) == 'object') {\n\n";
                echo "                    private_key_obj.value = '';\n";
                echo "                    private_key_obj.maxLength = new_key_length.childNodes[0].nodeValue;\n";
                echo "                    public_key_obj.value = new_public_key.childNodes[0].nodeValue;\n\n";
                echo "                    captcha_img_obj.src = new_captcha_img.childNodes[0].nodeValue;\n";
                echo "                }\n";
                echo "            }\n";
                echo "        }\n";
                echo "    }\n\n";
                echo "    return true;\n";
                echo "}\n\n";
                echo "//-->\n";
                echo "</script>\n";
            }
        }
    }

    reset($arg_array);

    foreach($arg_array as $func_args) {

        if ($func_args == "htmltools.js" && @file_exists("$forum_path/tiny_mce/tiny_mce.js")) {

            $page_prefs = bh_session_get_post_page_prefs();

            if ($page_prefs & POST_TINYMCE_DISPLAY) {

                echo TinyMCE();

            }else {

                if ($modified_time = @filemtime("js/{$func_args}")) {
                    echo sprintf("<script language=\"Javascript\" type=\"text/javascript\" src=\"$forum_path/js/{$func_args}?%s\"></script>\n", date('YmdHis', $modified_time));
                }
            }

        }else if (@is_dir("$forum_path/js/") && @file_exists("$forum_path/js/$func_args")) {

            if ($modified_time = @filemtime("js/{$func_args}")) {
                echo sprintf("<script language=\"Javascript\" type=\"text/javascript\" src=\"$forum_path/js/{$func_args}?%s\"></script>\n", date('YmdHis', $modified_time));
            }
        }
    }

    if (isset($_GET['reload_frames'])) {

        $top_html = html_get_top_page();

        echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
        echo "<!--\n\n";
        echo "if (top.document.body.rows) {\n\n";
        echo "    top.frames['", html_get_frame_name('ftop'), "'].location.replace('$top_html');\n";
        echo "    top.frames['", html_get_frame_name('fnav'), "'].location.reload();\n";
        echo "}\n\n";
        echo "-->\n";
        echo "</script>";
    }

    $onload = trim(implode(";", $onload_array));

    $onunload = trim(implode(";", $onunload_array));

    echo "</head>\n\n";

    if ($include_body_tag === true) {

        echo "<body", ($body_class) ? " class=\"$body_class\"" : "";
        echo (strlen($onload) > 0) ? " onload=\"$onload\"" : "";
        echo (strlen($onunload) > 0) ? " onunload=\"$onunload\"" : "";
        echo ">\n";
    }
}

function html_draw_bottom($include_body_tag = true)
{
    if ($include_body_tag === true) {
        echo "</body>\n";
    }

    echo "</html>\n";
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
    $webtag = get_webtag($webtag_search);

    $forum_settings = forum_get_settings();

    $forum_path = defined('BH_FORUM_PATH') ? BH_FORUM_PATH : '.';

    if (($user_style = bh_session_get_value('STYLE')) === false) {
        $user_style = forum_get_setting('default_style');
    }

    if (@is_dir("$forum_path/styles/$user_style/images") && @file_exists("$forum_path/styles/$user_style/images/$img")) {
        return "$forum_path/styles/$user_style/images/$img";
    }

    if (@is_dir("$forum_path/forums/$webtag/styles/$user_style/images") && @file_exists("$forum_path/forums/$webtag/styles/$user_style/images/$img")) {
        return "$forum_path/forums/$webtag/styles/$user_style/images/$img";
    }

    if (@is_dir("$forum_path/forums/$webtag/images") && @file_exists("$forum_path/forums/$webtag/images/$img")) {
        return "$forum_path/forums/$webtag/images/$img";
    }

    return "$forum_path/images/$img";
}

function bh_setcookie($name, $value, $expires = 0)
{
    $cookie_domain = (isset($GLOBALS['cookie_domain'])) ? $GLOBALS['cookie_domain'] : "";

    if (strlen(trim($cookie_domain)) > 0 && !defined('BEEHIVEMODE_LIGHT')) {

        $cookie_domain = preg_replace("/^[^:\s]+:\/\//", "", trim($cookie_domain));

        $cookie_path = preg_replace("/\\\/", "/", $cookie_domain);
        $cookie_path = explode('/', $cookie_domain);

        $cookie_domain = $cookie_path[0]; unset($cookie_path[0]);

        $cookie_path = implode('/', $cookie_path);

        $cookie_path = preg_replace("/[\/]+$/", "", $cookie_path);
        $cookie_path = preg_replace("/^[\/]+/", "", $cookie_path);

        $cookie_path = preg_replace("/[\/]+/", "/", "/$cookie_path/");

        if (isset($_SERVER['HTTP_HOST']) && !strstr($_SERVER['HTTP_HOST'], 'localhost')) {

            if (strstr($_SERVER['HTTP_HOST'], $cookie_domain)) {

                return setcookie($name, $value, $expires, $cookie_path, $cookie_domain, 0);
            }
        }
    }

    return setcookie($name, $value, $expires);
}

function bh_remove_all_cookies()
{
    // Retrieve existing cookie data if any

    logon_get_cookies($username_array, $password_array, $passhash_array);

    // Remove logon tracking and session cookies

    bh_setcookie("bh_logon_failed", "", time() - YEAR_IN_SECONDS);
    bh_setcookie("bh_sess_hash", "", time() - YEAR_IN_SECONDS);
    bh_setcookie("bh_logon", "", time() - YEAR_IN_SECONDS);

    // Remove the old saved logon cookies

    for ($i = 0; $i < sizeof($username_array); $i++) {

        bh_setcookie("bh_remember_username[$i]", "", time() - YEAR_IN_SECONDS);
        bh_setcookie("bh_remember_password[$i]", "", time() - YEAR_IN_SECONDS);
        bh_setcookie("bh_remember_passhash[$i]", "", time() - YEAR_IN_SECONDS);
    }

    // The newer cookie format.

    bh_setcookie("bh_remember_username", "", time() - YEAR_IN_SECONDS);
    bh_setcookie("bh_remember_password", "", time() - YEAR_IN_SECONDS);
    bh_setcookie("bh_remember_passhash", "", time() - YEAR_IN_SECONDS);

    // Remove the light mode saved logon cookies.

    bh_setcookie("bh_light_remember_username", "", time() - YEAR_IN_SECONDS);
    bh_setcookie("bh_light_remember_password", "", time() - YEAR_IN_SECONDS);
    bh_setcookie("bh_light_remember_passhash", "", time() - YEAR_IN_SECONDS);

    if ($webtag_array = forum_get_all_webtags()) {

        foreach ($webtag_array as $fid => $forum_webtag) {

            bh_setcookie("bh_{$forum_webtag}_thread_mode", "", time() - YEAR_IN_SECONDS);
            bh_setcookie("bh_{$forum_webtag}_password", "", time() - YEAR_IN_SECONDS);
        }
    }
}

// Remove named $keys from the query of a URI
// $keys can be an array or a single key to remove

function href_cleanup_query_keys($uri, $remove_keys = false, $seperator = "&amp;")
{
    $uri_array = parse_url($uri);

    if (isset($uri_array['query'])) {

        parse_str($uri_array['query'], $uri_query_array);

        $uri_query_keys = array();
        $uri_query_values = array();

        flatten_array($uri_query_array, $uri_query_keys, $uri_query_values);

        $new_uri_query_array = array();

        foreach ($uri_query_keys as $key => $key_name) {

            if (strlen($key_name) > 0) {

                if (!isset($uri_query_values[$key])) {
                    $uri_query_values[$key] = "";
                }

                if ($remove_keys === false || (is_array($remove_keys) && !in_array($key_name, $remove_keys)) || $key_name != $remove_keys) {

                    $uri_query_values[$key] = urlencode($uri_query_values[$key]);
                    $new_uri_query_array[] = "$key_name={$uri_query_values[$key]}";
                }
            }
        }

        $uri_array['query'] = implode($seperator, $new_uri_query_array);

        $uri = (isset($uri_array['scheme']))   ? "{$uri_array['scheme']}://" : '';
        $uri.= (isset($uri_array['host']))     ? "{$uri_array['host']}"      : '';
        $uri.= (isset($uri_array['port']))     ? ":{$uri_array['port']}"     : '';
        $uri.= (isset($uri_array['path']))     ? "{$uri_array['path']}"      : '';
        $uri.= (isset($uri_array['query']))    ? "?{$uri_array['query']}"    : '';
        $uri.= (isset($uri_array['fragment'])) ? "#{$uri_array['fragment']}" : '';

        $uri = preg_replace("/\?$|&$|&amp;$/", "", $uri);
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

function html_get_forum_uri($append_path = "")
{
    $uri_array = array();

    if (isset($_SERVER['REQUEST_URI']) && strlen(trim($_SERVER['REQUEST_URI'])) > 0) {
        $uri_array = @parse_url($_SERVER['REQUEST_URI']);
    }

    if (!isset($uri_array['scheme']) || strlen(trim($uri_array['scheme'])) < 1) {

        if (isset($_SERVER['HTTP_SCHEME']) && strlen(trim($_SERVER['HTTP_SCHEME'])) > 0) {

            $uri_array['scheme'] = $_SERVER['HTTP_SCHEME'];

        }elseif (isset($_SERVER['HTTPS']) && strlen(trim($_SERVER['HTTPS'])) > 0) {

            $uri_array['scheme'] = (strtolower($_SERVER['HTTPS']) != 'off') ? 'https' : 'http';

        }else {

            $uri_array['scheme'] = 'http';
        }

        if (isset($_SERVER['HTTP_HOST']) && strlen(trim($_SERVER['HTTP_HOST'])) > 0) {

            if (strpos($_SERVER['HTTP_HOST'], ':') > 0) {

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

        if (!isset($uri_array['path']) || strlen(trim($uri_array['path'])) < 1) {

            if (isset($_SERVER['PATH_INFO']) && strlen(trim($_SERVER['PATH_INFO'])) > 0) {

                $path = @parse_url($_SERVER['PATH_INFO']);

            }else {

                $path = @parse_url($_SERVER['PHP_SELF']);
            }

            $uri_array['path'] = $path['path'];
        }
    }

    if (server_os_mswin()) {

        $uri_array['path'] = dirname("{$uri_array['path']}beehive");
        $uri_array['path'] = preg_replace("/\\\/", "/", $uri_array['path']);
        $uri_array['path'] = preg_replace("/\/$/", "", $uri_array['path']);

    }else {

        $uri_array['path'] = dirname("{$uri_array['path']}beehive");
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
