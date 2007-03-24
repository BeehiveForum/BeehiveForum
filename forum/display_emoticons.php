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

/* $Id: display_emoticons.php,v 1.47 2007-03-24 17:32:23 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

// Compress the output
include_once(BH_INCLUDE_PATH. "gzipenc.inc.php");

// Enable the error handler
include_once(BH_INCLUDE_PATH. "errorhandler.inc.php");

// Installation checking functions
include_once(BH_INCLUDE_PATH. "install.inc.php");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once(BH_INCLUDE_PATH. "forum.inc.php");

// Fetch the forum settings
$forum_settings = forum_get_settings();

include_once(BH_INCLUDE_PATH. "emoticons.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.

if (bh_session_user_banned()) {

    html_user_banned();
    exit;
}

// Check to see if the user has been approved.

if (!bh_session_user_approved()) {

    html_user_require_approval();
    exit;
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

$pack = "";
$mode = "";

if (isset($_GET['pack']) && strlen(trim(_stripslashes($_GET['pack']))) > 0) {
    $pack = $_GET['pack'];
}

if (isset($_GET['mode']) && strlen(trim(_stripslashes($_GET['mode']))) > 0) {
    $mode = $_GET['mode'];
}

if ($mode == "mini") {
    echo emoticons_preview($pack);
    exit;
}

html_draw_top("emoticons.js");

echo "<h1>{$lang['emoticons']}</h1>\n";

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<table cellpadding=\"0\" cellspacing=\"0\" width=\"450\">\n";
echo "  <tr>\n";
echo "    <td align=\"left\">\n";
echo "      <table class=\"box\" width=\"100%\">\n";
echo "        <tr>\n";
echo "          <td align=\"left\" valign=\"top\">\n";
echo "            <table class=\"posthead\" width=\"100%\">\n";
echo "              <tr>\n";
echo "                <td align=\"left\" class=\"subhead\">{$lang['emoticons']}</td>\n";
echo "              </tr>\n";
echo "              <tr>\n";
echo "                <td align=\"center\">\n";
echo "                  <table class=\"posthead\" width=\"95%\">\n";
echo "                    <tr>\n";

$emot_forum = forum_get_setting('default_emoticons', false, 'default');

$emot_sets = emoticons_get_available(false);
$emot_sets_keys = array_keys($emot_sets);

if ($pack != "user" && !in_array($pack, $emot_sets_keys)) {
    $pack = $emot_forum;
}

if ($pack != "user") {

    echo "                      <td align=\"left\" valign=\"top\" width=\"200\">\n";

    foreach ($emot_sets as $pack_name => $display_name) {

        if ($pack == $pack_name) {

            echo "                        <h2>{$display_name}</h2>\n";

        }else {

            echo "                        <p><a href=\"display_emoticons.php?webtag=$webtag&amp;pack=$pack_name\" target=\"_self\">{$display_name}</a></p>\n";
        }
    }

    echo "                      </td>\n";
}

if ($pack == "user") {
    if (!$pack = bh_session_get_value('EMOTICONS')) $pack = $emot_forum;
}

if (in_array($pack, $emot_sets_keys)) {
    $path = "emoticons/$pack";
}else if (in_array($emot_forum, $emot_sets_keys)) {
    $path = "emoticons/{$emot_forum}";
}else if (isset($emot_sets_keys[0])) {
    $path = "emoticons/{$emot_sets_keys[0]}";
}

if (@file_exists("$path/definitions.php")) {
    include ("$path/definitions.php");
}

if (isset($emoticon) && count($emoticon) > 0) {

    krsort($emoticon);
    reset($emoticon);

    $emoticon_text = array();

    foreach ($emoticon as $k => $v) {
        $emoticon_text[$v][] = $k;
    }
}

echo "                      <td align=\"left\">\n";
echo "                        <table class=\"posthead\" width=\"300\">\n";

if (@$fp = fopen("$path/style.css", "r")) {

    $style = fread($fp, filesize("$path/style.css"));

    preg_match_all("/\.e_([\w_]+) \{.*\n[^\}]*background-image\s*:\s*url\s*\([\"\']([^\"\']*)[\"\']\)[^\}]*\}/i", $style, $matches);

    for ($i = 0; $i < count($matches[1]); $i++) {

        if (isset($emoticon_text[$matches[1][$i]])) {

            $string_matches = array();

            for ($j = 0; $j < count($emoticon_text[$matches[1][$i]]); $j++) {

                $string_matches[] = $emoticon_text[$matches[1][$i]][$j];
            }

            $emots_array[] = array('matches' => $string_matches,
                                   'text'    => $matches[1][$i],
                                   'img'     => $matches[2][$i]);
        }
    }

    foreach($emots_array as $emot) {

            echo "                          <tr onclick=\"insertEmoticon(' ", rawurlencode(str_replace("'", "\\'", $emot['matches'][0])), " ');\">\n";
            echo "                            <td align=\"left\" width=\"100\"><img src=\"$path/{$emot['img']}\" alt=\"{$emot['text']}\" title=\"{$emot['text']}\" /></td>\n";
            echo "                            <td align=\"left\">";

            foreach ($emot['matches'] as $emot_match) {

                echo _htmlentities($emot_match), " &nbsp; ";
            }

            echo "      </td>\n";
            echo "                          </tr>\n";
    }
}

echo "                          <tr>\n";
echo "                            <td align=\"left\">&nbsp;</td>\n";
echo "                          </tr>\n";
echo "                        </table>\n";
echo "                      </td>\n";
echo "                    </tr>\n";
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
echo "    <td align=\"left\">&nbsp;</td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td align=\"center\">", form_submit('close', $lang['close'], "onclick='window.close()'"), "</td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo "</div>\n";

html_draw_bottom();

?>