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

require_once("./include/header.inc.php");
require_once("./include/config.inc.php");
require_once("./include/session.inc.php");
require_once("./include/lang.inc.php");

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

function _html_draw_top1($title = false)
{

    global $HTTP_GET_VARS, $forum_name, $default_style, $lang;

    if(!$title) $title = $forum_name;

    echo "<?xml version=\"1.0\" encoding=\"", $lang['_charset'], "\"?>\n";
    echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
    echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\" dir=\"", $lang['_textdir'], "\">\n";
    echo "<head>\n";
    echo "<title>$title</title>\n";
    echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=", $lang['_charset'], "\" />\n";

    if (isset($default_style)) {

        $user_style = bh_session_get_value('STYLE');
        $user_style = $user_style ? $user_style : $default_style;

        if (is_dir("./styles/$user_style")) {
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

}

function _html_draw_top2($body_class = false)
{
    echo "</head>\n\n";
    echo "<body";
    if ($body_class) {
        echo " class=\"$body_class\"";
    }
    echo ">\n";
}

function _html_draw_top_script()
{
    echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
    echo "<!--\n\n";
    echo "function openProfile(uid) {\n";
    echo "  window.open('user_profile.php?uid=' + uid, uid,'width=500, height=450, toolbars=no');\n";
    echo "}\n\n";
    echo "-->\n";
    echo "</script>\n";
    echo "<base target=\"_blank\" />\n";
}

function _html_draw_post_top2()
{
    echo "</head>\n";
    echo "<body onload=\"document.f_post.t_content.focus();\">\n";
}


function html_draw_top($title = false, $body_class = false)
{
    _html_draw_top1($title);
    _html_draw_top2($body_class);
}

function html_draw_top_script($title = false)
{
    _html_draw_top1($title);
    _html_draw_top_script();
    _html_draw_top2();
}

function html_draw_top_post_script($title = false)
{
    _html_draw_top1($title);
    _html_draw_top_script();
    _html_draw_post_top2();
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
