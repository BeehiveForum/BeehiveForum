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

/* $Id: html.inc.php,v 1.54 2003-08-24 19:45:54 tribalonline Exp $ */

require_once("./include/header.inc.php");
require_once("./include/config.inc.php");
require_once("./include/session.inc.php");
require_once("./include/lang.inc.php");
require_once("./include/pm.inc.php");

function html_guest_error ()
{
     global $lang;
     html_draw_top();
     echo "<h1>{$lang['guesterror']}</h1>";
     html_draw_bottom();
}

function html_poll_edit_error ()
{
    global $lang;
    html_draw_top();
    echo "<h1>{$lang['pollediterror']}</h1>";
    html_draw_bottom();
}

function html_message_type_error()
{
    global $lang;
    html_draw_top();
    echo "<h1>{$lang['cannotpostthisthreadtype']}</h1>";
    html_draw_bottom();
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
//      html_draw_top also supports 3 named arguments, which
//      you can use to alter the default page title, body class
//      and also specify functions to be called by the browser in
//      the body tag's onload event. These have to be called in a
//      specific manner. For example:
//
//      html_draw_top("title=Navigation", "class=nav");
//
//      This will set the title of the page to "Navigation" with the body
//      class set to "nav"
//
//      For the onload event, you do the same as the title and
//      body_class named arguments, but you can include multiple
//      arguments which will all then be loaded for you. For example:
//
//      html_draw_top("onload=pm_notification", "onload=openprofile(1)");
//
//      You can also mix and match all of these arguments in any order
//      for example:
//
//      html_draw_top("onload=pm_notification();", "title=pm_example");
//
//      or
//
//      html_draw_top("class=nav", "openprofile.js", "title=Navigation");
//
//      Easy, eh?
//
//      Any questions ask Matt.

function html_draw_top()
{
    global $HTTP_GET_VARS, $HTTP_SERVER_VARS, $forum_name, $default_style, $lang;

    $onload_array = array();
    $arg_array = func_get_args();

    foreach($arg_array as $key => $func_args) {

        if (preg_match("/^title=/", $func_args)) {
            $title = substr($func_args, 6);
            unset($arg_array[$key]);
        }

        if (preg_match("/^class=/", $func_args)) {
            $body_class = substr($func_args, 6);
            unset($arg_array[$key]);
        }

        if (preg_match("/^onload=/", $func_args)) {
            $onload_array[] = substr($func_args, 7);
            unset($arg_array[$key]);
        }
    }

    if (!isset($title)) $title = $forum_name;
    if (!isset($body_class)) $body_class = false;

    echo "<?xml version=\"1.0\" encoding=\"", $lang['_charset'], "\"?>\n";
    echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
    echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\" dir=\"", $lang['_textdir'], "\">\n";
    echo "<head>\n";
    echo "<title>$title</title>\n";
    echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=", $lang['_charset'], "\" />\n";

    if (isset($default_style)) {

        $user_style = bh_session_get_value('STYLE');
        $user_style = $user_style ? $user_style : $default_style;

        if (is_dir("./styles/$user_style") && file_exists("./styles/$user_style/style.css")) {
            $stylesheet = "styles/$user_style/style.css";
        }else {
            $stylesheet = "styles/style.css";
        }

    }else {
        $stylesheet = "styles/style.css";
    }

    echo "<link rel=\"stylesheet\" href=\"", $stylesheet, "\" type=\"text/css\" />\n";

    if (bh_session_get_value('FONT_SIZE') && bh_session_get_value('FONT_SIZE') != '10') {
        echo "<style type=\"text/css\">@import \"fontsize.php\";</style>\n";
    }

    if (basename($HTTP_SERVER_VARS['PHP_SELF']) != 'pm.php') {
        if ((bh_session_get_value('PM_NOTIFY') == 'Y') && (pm_new_check())) {
            echo "<script language=\"Javascript\" type=\"text/javascript\" src=\"./js/pm_notification.js\" />\n";
            if (!in_array("pm_notification", $onload_array)) $onload_array[] = "pm_notification()";
        }
    }

    reset($arg_array);

    foreach($arg_array as $func_args) {
        if (is_dir("./js/") && file_exists("./js/$func_args")) {
            echo "<script language=\"Javascript\" type=\"text/javascript\" src=\"./js/$func_args\"></script>\n";
        }
    }

    echo "</head>\n\n";
    echo "<body", ($body_class) ? " class=\"$body_class\"" : "", " onload=\"", implode(";", $onload_array), "\">\n";
}

function html_draw_bottom ()
{
    echo "</body>\n";
    echo "</html>\n";
}

function style_image($img)
{
    global $default_style;

    $style = bh_session_get_value('STYLE');
    $file  = "./styles/". ($style ? $style : $default_style) . "/images/$img";

    if (@file_exists($file)) {
        return $file;
    } else {
        return "./images/$img";
    }
}

?>
