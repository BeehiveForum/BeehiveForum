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

/* $Id: display_emoticons.php,v 1.11 2004-04-10 16:35:00 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Multiple forum support
include_once("./include/forum.inc.php");

include_once("./include/config.inc.php");
include_once("./include/form.inc.php");
include_once("./include/format.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/session.inc.php");
include_once("./include/user.inc.php");
include_once("./include/emoticons.inc.php");

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

// Check we have a webtag

if (!$webtag = get_webtag()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?final_uri=$request_uri");
}

// We got this far we should now read the forum settings

$forum_settings = get_forum_settings();

$pack = "";
$mode = "";

if (isset($HTTP_GET_VARS['pack'])) {
	$pack = $HTTP_GET_VARS['pack'];
}

if (isset($HTTP_GET_VARS['mode'])) {
	$mode = $HTTP_GET_VARS['mode'];
}

if ($mode == "mini") {
	echo emoticons_preview($pack);
	exit;
}

html_draw_top();

echo "<h1>{$lang['emoticons']}</h1>\n";

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<table cellpadding=\"1\" cellspacing=\"0\" width=\"450\">\n";
echo "  <tr>\n";
echo "    <td>\n";
echo "      <table class=\"box\" width=\"100%\">\n";
echo "        <tr>\n";
echo "          <td valign=\"top\">\n";
echo "            <table class=\"posthead\" width=\"100%\">\n";
echo "              <tr>\n";


$emot_sets = emoticons_get_sets();
unset($emot_sets['none']);
$emot_sets_keys = array_keys($emot_sets);

if ($pack != "user") {
	echo "              <td valign=\"top\" width=\"200\">\n";

	foreach ($emot_sets as $k => $v) {
		if ($pack != $k) {
			echo "                  <p><a href=\"display_emoticons.php?webtag=$webtag&pack=".$k."\" target=\"_self\">".$v."</a></p>\n";
		} else {
			echo "                  <p><h2>".$v."</h2></p>\n";
		}
	}

	echo "                </td>\n";
}

$emot_forum = forum_get_setting('default_emoticons');

if ($pack == "user") {
    $pack = bh_session_get_value('EMOTICONS');
    $pack = $pack ? $pack : $emot_forum;
}

if (in_array($pack, $emot_sets_keys)) {
	$path = "emoticons/".$pack;
} else if (in_array($emot_forum, $emot_sets_keys)) {
	$path = "emoticons/".$emot_forum;
} else {
	$path = "emoticons/".$emot_sets_keys[0];
}

$fp = fopen("$path/style.css", "r");
$style = fread($fp, filesize("$path/style.css"));

preg_match_all("/\.e_([\w_]+) \{[^\}]*background-image\s*:\s*url\s*\([\"\']([^\"\']*)[\"\']\)[^\}]*\}/i", $style, $matches);

for ($i=0; $i<count($matches[1]); $i++) {
	if (isset($emoticon_text[$matches[1][$i]])) {
		$tmp = "";
		for ($j=0; $j<count($emoticon_text[$matches[1][$i]]); $j++) {
			$tmp.= $emoticon_text[$matches[1][$i]][$j]." &nbsp; ";
		}
		$emot_match[] = $tmp;
		$emot_text[] = $matches[1][$i];
		$emot_image[] = $matches[2][$i];
	}
}

array_multisort($emot_match, $emot_text, $emot_image);

echo "                <td>\n";
echo "                  <table class=\"posthead\" width=\"300\">\n";

for ($i=0; $i<count($emot_match); $i++) {
	echo "                    <tr>\n";
	echo "                      <td width=\"100\"><img src=\"$path/".$emot_image[$i]."\" title=\"".$emot_text[$i]."\"></td>\n";
	echo "                      <td>".$emot_match[$i]."</td>\n";
	echo "                    </tr>\n";
}

echo "                  </table>\n";
echo "                </td>\n";
echo "              </tr>\n";
echo "            </table>\n";
echo "          </td>\n";
echo "        </tr>\n";
echo "      </table>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td>&nbsp;</td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td align=\"center\">".form_submit('close', $lang['close'], "onclick='window.close()'")."</td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo "</div>\n";

html_draw_bottom();

?>