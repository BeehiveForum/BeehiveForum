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

function html_guest_error () 
{ 
     html_draw_top(); 
     echo "<h1>Sorry, you need to be logged in to use this feature.</h1>"; 
     html_draw_bottom(); 
}

function html_poll_edit_error ()
{
    html_draw_top();
    echo "<h1>You cannot edit polls</h1>";
    html_draw_bottom();
}

function _html_draw_top1($title = false)
{

    global $HTTP_COOKIE_VARS, $forum_name;

    if(!$title){
        $title = $forum_name;
    }
    
    $fontsize = isset($HTTP_COOKIE_VARS['bh_sess_fontsize']) ? $HTTP_COOKIE_VARS['bh_sess_fontsize'] : 9;

    header_no_cache(); // Hopefully this will stop Opera from caching the PHP pages, but I doubt it.

	echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
	echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"DTD/xhtml1-transitional.dtd\">\n";
	echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">\n";
	echo "\t<head>\n";
	echo "\t\t<title>$title</title>\n";
	echo "\t\t<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\"/>\n";
	echo "\t\t<link rel=\"stylesheet\" href=\"styles.php?fontsize=$fontsize&". md5(uniqid(rand())). "\" type=\"text/css\"/>\n";
}

function _html_draw_top2($body_class = false)
{
	echo "\t</head>\n";
	echo "<body";
	if ($body_class) {
		echo " class=\"$body_class\"";
	}
	echo ">\n";
}

function _html_draw_top_script()
{
    echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
    echo "<!--\n";
    echo "function openProfile(uid)\n";
    echo "{\n";
    echo "window.open('user_profile.php?uid=' + uid, uid,'width=400, height=400, toolbars=no');\n";
    echo "}\n";
    echo "-->\n";
    echo "</script>\n";
	echo "<base target=\"_blank\" />\n";
}

function _html_draw_post_top2()
{
	echo "\t</head>\n";
	echo "<body onLoad=\"self.focus();document.f_post.t_content.focus();\">\n";
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
    global $HTTP_COOKIE_VARS, $default_style;

	$file = "./styles/".(isset($HTTP_COOKIE_VARS['bh_sess_style']) ? $HTTP_COOKIE_VARS['bh_sess_style'] : $default_style) . "/images/$img";

	if (file_exists($file)) {
	    return $file;
	} else {
		return "./images/$img";
	}
}

?>
