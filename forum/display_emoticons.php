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

/* $Id: display_emoticons.php,v 1.4 2004-03-23 04:11:56 tribalonline Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum webtag and settings
$webtag = get_webtag();
$forum_settings = get_forum_settings();

include_once("./include/config.inc.php");
include_once("./include/form.inc.php");
include_once("./include/format.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/session.inc.php");
include_once("./include/user.inc.php");
include_once("./include/emoticons.inc.php");

if (!$user_sess = bh_session_check()) {

    $uri = "./logon.php?webtag={$webtag['WEBTAG']}&final_uri=". rawurlencode(get_request_uri());
    header_redirect($uri);
}

html_draw_top();

$pack = "";
if (isset($_GET['pack'])) {
	$pack = $_GET['pack'];
}

$available_emots = array();
$emot_names = array();

if ($dir = @opendir('emoticons')) {
    while (($file = readdir($dir)) !== false) {
        if (is_dir("emoticons/$file") && $file != '.' && $file != '..') {
            if (@file_exists("./emoticons/$file/style.css")) {
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

echo "<h1>{$lang['emoticons']}</h1>\n";

echo "<br />\n";
echo "<table cellpadding=\"1\" cellspacing=\"0\" width=\"100%\">\n";
echo "  <tr>\n";
echo "    <td>\n";
echo "      <table class=\"box\" width=\"100%\">\n";
echo "        <tr>\n";
echo "          <td valign=\"top\">\n";
echo "            <table class=\"posthead\" width=\"100%\">\n";
echo "              <tr>\n";

if ($pack != "user") {
	echo "              <td valign=\"top\" width=\"200\">\n";
	for ($i=0; $i<count($emot_names); $i++) {
		echo "                  <p><a href=\"display_emoticons.php?webtag={$webtag['WEBTAG']}&pack=".$available_emots[$i]."\" target=\"_self\">".$emot_names[$i]."</a></p>\n";
	}
	echo "                </td>\n";
}

if ($pack == "user") {
    $user_emots = bh_session_get_value('EMOTICONS');
    $user_emots = $user_emots ? $user_emots : forum_get_setting('default_emoticons');

	$path = "emoticons/".$user_emots;
} else if (in_array($pack, $available_emots)) {
	$path = "emoticons/".$pack;
} else {
	$path = "emoticons/".$available_emots[0];
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

html_draw_bottom();

?>