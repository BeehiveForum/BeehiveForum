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

/* $Id: html.inc.php,v 1.117 2004-06-18 16:55:30 decoyduck Exp $ */

include_once("./include/constants.inc.php");
include_once("./include/forum.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/pm.inc.php");
include_once("./include/session.inc.php");

function html_guest_error ()
{
     $lang = load_language_file();

     html_draw_top();

     $webtag = get_webtag($webtag_search);

     $final_uri = rawurlencode(get_request_uri(true));

     echo "<h1>{$lang['guesterror_1']} <a href=\"logout.php?webtag=$webtag";
     echo "&amp;final_uri=$final_uri\" target=\"_top\">{$lang['guesterror_2']}</a></h1>";
     html_draw_bottom();
}

function html_poll_edit_error ()
{
    $lang = load_language_file();

    html_draw_top();
    echo "<h1>{$lang['pollediterror']}</h1>";
    html_draw_bottom();
}

function html_message_type_error()
{
    $lang = load_language_file();

    html_draw_top();
    echo "<h1>{$lang['cannotpostthisthreadtype']}</h1>";
    html_draw_bottom();
}

function html_get_top_page()
{
    $webtag = get_webtag($webtag_search);

    $forum_settings = get_forum_settings();

    if ($user_style = bh_session_get_value('STYLE')) {

        if (@is_dir("./styles/$user_style") && @file_exists("./styles/$user_style/top.html")) {
            return "styles/$user_style/top.html";
        }

        if (@is_dir("./forums/$webtag/styles/$user_style") && @file_exists("./forums/$webtag/styles/$user_style/top.html")) {
            return "./forums/$webtag/styles/$user_style/top.html";
        }
    }

    if ($default_style = forum_get_setting('default_style')) {

        if (@is_dir("./styles/$default_style") && @file_exists("./styles/$default_style/top.html")) {
            return "styles/$default_style/top.html";
        }

        if (@is_dir("./forums/$webtag/styles/$default_style") && @file_exists("./forums/$webtag/styles/$default_style/top.html")) {
            return "forums/$webtag/styles/$default_style/top.html";
        }

        if (@is_dir("./forums/$webtag") && @file_exists("./forums/$webtag/top.html")) {
            return "forums/$webtag/top.html";
        }
    }

    return "styles/top.html";
}

function html_get_style_sheet()
{
    $webtag = get_webtag($webtag_search);

    $forum_settings = get_forum_settings();

    if ($user_style = bh_session_get_value('STYLE')) {

        if (@is_dir("styles/$user_style") && @file_exists("styles/$user_style/style.css")) {
            return "styles/$user_style/style.css";
        }

        if (@is_dir("./forums/$webtag/styles/$user_style") && @file_exists("forums/$webtag/styles/$user_style/style.css")) {
            return "forums/$webtag/styles/$user_style/style.css";
        }
    }

    if ($default_style = forum_get_setting('default_style')) {

        if (@is_dir("styles/$default_style") && @file_exists("styles/$default_style/style.css")) {
            return "styles/$default_style/style.css";
        }

        if (@is_dir("forums/$webtag/styles/$default_style") && @file_exists("forums/$webtag/styles/$default_style/style.css")) {
            return "forums/$webtag/styles/$default_style/style.css";
        }

        if (@is_dir("./forums/$webtag") && @file_exists("./forums/$webtag/style.css")) {
            return "forums/$webtag/style.css";
        }
    }

    return "styles/style.css";
}

function html_get_forum_keywords()
{
    $webtag = get_webtag($webtag_search);

    $forum_settings = get_forum_settings();

    if ($forum_keywords = forum_get_setting('forum_keywords')) {

        return $forum_keywords;
    }

    return "";
}

function html_get_forum_description()
{
    $webtag = get_webtag($webtag_search);

    $forum_settings = get_forum_settings();

    if ($forum_desc = forum_get_setting('forum_desc')) {

        return $forum_desc;
    }

    return "";
}

function html_get_forum_email()
{
    $webtag = get_webtag($webtag_search);

    $forum_settings = get_forum_settings();

    if ($forum_email = forum_get_setting('forum_email')) {

        return $forum_email;
    }

    return "";
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
//      html_draw_top also supports 5 named arguments, which
//      you can use to alter the default page title, body class,
//      base target, and also specify functions to be
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
    $meta_refresh = false;

    $forum_settings = get_forum_settings();
    $webtag = get_webtag($webtag_search);

    foreach($arg_array as $key => $func_args) {

        if (preg_match("/^title=/i", $func_args)) {
            if (!isset($title)) $title = substr($func_args, 6);
            unset($arg_array[$key]);
        }

        if (preg_match("/^class=/i", $func_args)) {
            if (!isset($body_class)) $body_class = substr($func_args, 6);
            unset($arg_array[$key]);
        }

        if (preg_match("/^basetarget=/i", $func_args)) {
            if (!isset($base_target)) $base_target = substr($func_args, 11);
            unset($arg_array[$key]);
        }

        if (preg_match("/^onload=/i", $func_args)) {
            $onload_array[] = substr($func_args, 7);
            unset($arg_array[$key]);
        }

        if (preg_match("/^onunload=/i", $func_args)) {
            $onunload_array[] = substr($func_args, 9);
            unset($arg_array[$key]);
        }

        if (preg_match("/^refresh=/i", $func_args)) {
            $meta_refresh = substr($func_args, 8);
            unset($arg_array[$key]);
        }
    }

    if (!isset($title)) $title = forum_get_setting('forum_name');
    if (!isset($body_class)) $body_class = false;
    if (!isset($base_target)) $base_target = false;

    $forum_keywords = html_get_forum_keywords();
    $forum_description = html_get_forum_description();
    $forum_email = html_get_forum_email();

    echo "<?xml version=\"1.0\" encoding=\"{$lang['_charset']}\"?>\n";
    echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
    echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"{$lang['_isocode']}\" lang=\"{$lang['_isocode']}\" dir=\"{$lang['_textdir']}\">\n";
    echo "<head>\n";
    echo "<title>$title</title>\n";
    echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset={$lang['_charset']}\" />\n";
    echo "<meta name=\"generator\" content=\"BeehiveForums ", BEEHIVE_VERSION, "\" />\n";
    echo "<meta name=\"reply-to\" content=\"$forum_email\" />\n";
    echo "<meta name=\"keywords\" content=\"$forum_keywords\" />\n";
    echo "<meta name=\"description\" content=\"$forum_description\" />\n";
    echo "<link rel=\"icon\" href=\"images/favicon.ico\" type=\"image/ico\" />\n";

    if ($meta_refresh) {
        echo "<meta http-equiv=\"refresh\" content=\"$meta_refresh; url=./nav.php?webtag=$webtag\">\n";
    }

    $stylesheet = html_get_style_sheet();
    echo "<link rel=\"stylesheet\" href=\"$stylesheet\" type=\"text/css\" />\n";

    if (forum_get_setting('default_emoticons')) {

        $user_emots = bh_session_get_value('EMOTICONS');
        $user_emots = $user_emots ? $user_emots : forum_get_setting('default_emoticons');

        if (is_dir("./emoticons/$user_emots") && file_exists("./emoticons/$user_emots/style.css")) {
            echo "<link rel=\"stylesheet\" href=\"emoticons/$user_emots/style.css\" type=\"text/css\" />\n";
        }
    }

    if ($base_target) echo "<base target=\"$base_target\" />\n";

    $fontsize = bh_session_get_value('FONT_SIZE');

    if ($fontsize && $fontsize != '10') {
        echo "<style type=\"text/css\">@import \"fontsize.php?webtag=$webtag\";</style>\n";
    }

    if (isset($_GET['fontresize'])) {

        echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
        echo "<!--\n\n";
        echo "top.document.body.rows='60,' + $fontsize * 2 + ',*';\n";
	echo "top.frames['main'].frames['left'].location.reload();\n";
	echo "top.frames['fnav'].location.reload();\n\n";
        echo "//-->\n";
        echo "</script>\n";
    }

    if (!stristr($_SERVER['PHP_SELF'], 'pm') && !stristr($_SERVER['PHP_SELF'], 'nav.php')) {
        if ((bh_session_get_value('PM_NOTIFY') == 'Y') && (pm_new_check())) {
            echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
	    echo "<!--\n\n";
            echo "function pm_notification() {\n";
            echo "    if (window.confirm('{$lang['pmnotificationpopup']}')) {\n";
            echo "        top.frames['main'].location.replace('pm.php?webtag=$webtag');\n";
            echo "    }\n";
            echo "    return true;\n";
            echo "}\n\n";
	    echo "//-->\n";
	    echo "</script>\n";
            if (!in_array("pm_notification", $onload_array)) $onload_array[] = "pm_notification()";
        }
    }

    reset($arg_array);

    echo "<script language=\"Javascript\" type=\"text/javascript\" src=\"./js/general.js\"></script>\n";

    foreach($arg_array as $func_args) {
        if (is_dir("./js/") && file_exists("./js/$func_args")) {
            echo "<script language=\"Javascript\" type=\"text/javascript\" src=\"./js/$func_args\"></script>\n";
        }
    }

    $onload = trim(implode(";", $onload_array));
    $onunload = trim(implode(";", $onunload_array));

    echo "</head>\n\n";
    echo "<body", ($body_class) ? " class=\"$body_class\"" : "", (strlen($onload) > 0) ? " onload=\"$onload\"" : "", (strlen($onunload) > 0) ? " onunload=\"$onunload\"" : "", ">\n";
}

function html_draw_bottom ()
{
    echo "</body>\n";
    echo "</html>\n";
}

function style_image($img)
{
    $forum_settings = get_forum_settings();

    $style = bh_session_get_value('STYLE');
    $file  = "./styles/". ($style ? $style : forum_get_setting('default_style')) . "/images/$img";

    if (@file_exists($file)) {
        return $file;
    } else {
        return "./images/$img";
    }
}

function bh_setcookie($name, $value, $expires = 0)
{
    global $cookie_domain;

    if (isset($cookie_domain) && strlen(trim($cookie_domain)) > 0 && !defined('BEEHIVEMODE_LIGHT')) {

        $cookie_domain = preg_replace("/^http:\/\//", "", trim($cookie_domain));

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

function page_links($uri, $offset, $total_rows, $rows_per_page, $page_var = "page")
{
    $page_count   = ceil($total_rows / $rows_per_page);
    $current_page = floor($offset / $rows_per_page) + 1;

    if ($page_count > 1) {

        if ($current_page == 1) {

            $end_page = (($current_page + 4) <= $page_count) ? ($current_page + 4) : $page_count;
            $start_page = $current_page;

        }elseif ($current_page == $page_count) {

            $start_page = (($current_page - 4) > 0) ? ($current_page - 4) : 1;
            $end_page = $page_count;

        }else {

            $start_page = (($current_page - 2) > 0) ? ($current_page - 2) : 1;
            $end_page   = (($current_page + 2) <= $page_count) ? ($current_page + 2) : $page_count;

            if (($end_page - $start_page) < 4) {

                if (($start_page - 4) < 1) {

                    $end_page = (($start_page + 4) <= $page_count) ? ($start_page + 4) : $page_count;

                }elseif (($end_page + 3) > $page_count) {

                    $start_page = (($end_page - 4) > 0) ? ($end_page - 4) : 1;
                }
            }
        }

        if ($current_page > 1) {

            $prev_page = (($current_page - 1) > 0) ? ($current_page - 1) : 1;
            echo "<a href=\"{$uri}&amp;page={$prev_page}\" target=\"_self\">&lt;&lt;</a> ";
        }

        for ($page = $start_page; $page <= $end_page; $page++) {

            if ($page == $current_page) {
                echo "<b>$page</b> ";
            }else {
                echo "<a href=\"{$uri}&amp;{$page_var}={$page}\" target=\"_self\">{$page}</a> ";
            }
        }

        if ($current_page < $page_count) {

            $next_page = (($current_page + 1) <= $page_count) ? ($current_page + 1) : $page_count;
            echo "<a href=\"{$uri}&amp;{$page_var}={$next_page}\" target=\"_self\">&gt;&gt;</a> ";
        }

    }else {

        echo "<a href=\"{$uri}&amp;page=1\" target=\"_self\">1</a> ";
    }
}

?>