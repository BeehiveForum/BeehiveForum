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

/* $Id: html.inc.php,v 1.86 2004-03-16 23:15:05 decoyduck Exp $ */

include_once("./include/pm.inc.php");
include_once("./include/session.inc.php");

function html_guest_error ()
{
     global $lang, $webtag;
     
     html_draw_top();
     echo "<h1>{$lang['guesterror_1']} <a href=\"logout.php?webtag={$webtag['WEBTAG']}";
     echo "&final_uri=", rawurlencode(rawurlencode(get_request_uri())), "\" target=\"_top\">{$lang['guesterror_2']}</a></h1>";
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
    global $HTTP_GET_VARS, $HTTP_SERVER_VARS, $forum_settings, $lang, $webtag;
    
    $onload_array = array();
    $onunload_array = array();
    $arg_array = func_get_args();
    $meta_refresh = false;

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

    if (!isset($title)) $title = $forum_settings['forum_name'];
    if (!isset($body_class)) $body_class = false;
    if (!isset($base_target)) $base_target = false;

    echo "<?xml version=\"1.0\" encoding=\"{$lang['_charset']}\"?>\n";
    echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
    echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"{$lang['_isocode']}\" lang=\"{$lang['_isocode']}\" dir=\"{$lang['_textdir']}\">\n";
    echo "<head>\n";
    echo "<title>$title</title>\n";
    echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset={$lang['_charset']}\" />\n";
    echo "<link rel=\"icon\" href=\"images/favicon.ico\" type=\"image/ico\">\n";
    
    if ($meta_refresh) {
        echo "<meta http-equiv=\"refresh\" content=\"$meta_refresh; url=./nav.php?webtag={$webtag['WEBTAG']}\">\n";
    }

    if (isset($forum_settings['default_style'])) {

        $user_style = bh_session_get_value('STYLE');
        $user_style = $user_style ? $user_style : $forum_settings['default_style'];

        if (is_dir("./styles/$user_style") && file_exists("./styles/$user_style/style.css")) {
            $stylesheet = "styles/$user_style/style.css";
        }else {
            $stylesheet = "styles/style.css";
        }

    }else {
        $stylesheet = "styles/style.css";
    }

    echo "<link rel=\"stylesheet\" href=\"$stylesheet\" type=\"text/css\" />\n";

    if ($base_target) echo "<base target=\"$base_target\" />\n";

    $fontsize = bh_session_get_value('FONT_SIZE');
    
    if ($fontsize && $fontsize != '10') {
        echo "<style type=\"text/css\">@import \"fontsize.php?webtag={$webtag['WEBTAG']}\";</style>\n";
    }
    
    if (isset($HTTP_GET_VARS['fontresize'])) {
       
        echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
        echo "<!--\n\n";
        echo "top.document.body.rows='60,' + $fontsize * 2 + ',*';\n";
	echo "top.frames['main'].frames['left'].location.reload();\n";
	echo "top.frames['fnav'].location.reload();\n\n";
        echo "//-->\n";
        echo "</script>\n";	
    }

    if (!stristr($HTTP_SERVER_VARS['PHP_SELF'], 'pm') && !stristr($HTTP_SERVER_VARS['PHP_SELF'], 'nav.php')) {
        if ((bh_session_get_value('PM_NOTIFY') == 'Y') && (pm_new_check())) {
            echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
	    echo "<!--\n\n";
            echo "function pm_notification() {\n";
            echo "    if (window.confirm('{$lang['pmnotificationpopup']}')) {\n";
            echo "        top.frames['main'].location.replace('pm.php');\n";
            echo "    }\n";
            echo "    return true;\n";
            echo "}\n\n";
	    echo "//-->\n";
	    echo "</script>\n";
            if (!in_array("pm_notification", $onload_array)) $onload_array[] = "pm_notification()";
        }
    }

    reset($arg_array);

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
    global $forum_settings;

    $style = bh_session_get_value('STYLE');
    $file  = "./styles/". ($style ? $style : $forum_settings['default_style']) . "/images/$img";

    if (@file_exists($file)) {
        return $file;
    } else {
        return "./images/$img";
    }
}

function bh_setcookie($name, $value = "", $expires = 0)
{
    global $HTTP_SERVER_VARS;

    $hostname = "";

    if (isset($forum_settings['cookie_domain']) && strlen(trim($forum_settings['cookie_domain'])) > 0 && isset($HTTP_SERVER_VARS['HTTP_HOST'])) {

        if (!strstr($HTTP_SERVER_VARS['HTTP_HOST'], 'localhost')) {

            if (strstr($HTTP_SERVER_VARS['HTTP_HOST'], $forum_settings['cookie_domain'])) {
                $hostname = $forum_settings['cookie_domain'];
            }else {
                $hostname = $HTTP_SERVER_VARS['HTTP_HOST'];
            }
            
            $hostname = str_replace("www", "", $hostname);
            $hostname = str_replace("http://", "", $hostname);
            
            if (substr($hostname, 0, 1) != ".") {
                $hostname = ".{$hostname}";
            }            
	}
    }

    setcookie($name, $value, $expires, '/', $hostname, 0);
}

?>