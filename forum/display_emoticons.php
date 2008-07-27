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

/* $Id: display_emoticons.php,v 1.59 2008-07-27 10:53:28 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Compress the output
include_once(BH_INCLUDE_PATH. "gzipenc.inc.php");

// Enable the error handler
include_once(BH_INCLUDE_PATH. "errorhandler.inc.php");

// Installation checking functions
include_once(BH_INCLUDE_PATH. "install.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once(BH_INCLUDE_PATH. "forum.inc.php");

// Fetch Forum Settings

$forum_settings = forum_get_settings();

// Fetch Global Forum Settings

$forum_global_settings = forum_get_global_settings();

include_once(BH_INCLUDE_PATH. "emoticons.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

// Intitalise a few variables

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag();
    header_redirect("logon.php?webtag=$webtag&final_uri=$request_uri");
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

if (!$webtag = get_webtag()) {
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

if (isset($_GET['pack']) && strlen(trim(_stripslashes($_GET['pack']))) > 0) {
    $user_emoticon_pack = $_GET['pack'];
}else {
    $user_emoticon_pack = '';
}

if (isset($_GET['mode']) && strlen(trim(_stripslashes($_GET['mode']))) > 0) {
    $view_mode = $_GET['mode'];
}else {
    $view_mode = '';
}

if ($view_mode == "mini") {
    echo emoticons_preview($user_emoticon_pack);
    exit;
}

html_draw_top("emoticons.js", 'pm_popup_disabled');

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

$emoticon_sets_array = emoticons_get_available(false);

if ($user_emoticon_pack != "user" && !(in_array($user_emoticon_pack, array_keys($emoticon_sets_array)))) {
    $user_emoticon_pack = forum_get_setting('default_emoticons', false, 'default');
}

if ($user_emoticon_pack != "user") {

    echo "                      <td align=\"left\" valign=\"top\" width=\"200\">\n";

    foreach ($emoticon_sets_array as $user_emoticon_pack_name => $display_name) {

        if ($user_emoticon_pack == $user_emoticon_pack_name) {

            echo "                        <h2>{$display_name}</h2>\n";

        }else {

            echo "                        <p><a href=\"display_emoticons.php?webtag=$webtag&amp;pack=$user_emoticon_pack_name\" target=\"_self\">{$display_name}</a></p>\n";
        }
    }

    echo "                      </td>\n";
}

if ($user_emoticon_pack == "user") {

    if (($user_emoticon_pack = bh_session_get_value('EMOTICONS')) === false) {

        $user_emoticon_pack = forum_get_setting('default_emoticons', false, 'default');
    }
}

$emoticon = array();

if (in_array($user_emoticon_pack, array_keys($emoticon_sets_array))) {

    $emoticon_path = basename($user_emoticon_pack);

    if (file_exists("emoticons/$emoticon_path/definitions.php")) {
        include ("emoticons/$emoticon_path/definitions.php");
    }

}else if (sizeof($emoticon_sets_array) > 0) {

    $emoticon_path = basename(array_shift($emoticon_sets_array));

    if (file_exists("emoticons/$emoticon_path/definitions.php")) {
        include ("emoticons/$emoticon_path/definitions.php");
    }
}

if (sizeof($emoticon) > 0) {

    krsort($emoticon);
    reset($emoticon);

    $emoticon_text = array();

    foreach ($emoticon as $k => $v) {
        $emoticon_text[$v][] = $k;
    }
}

echo "                      <td align=\"left\">\n";
echo "                        <table class=\"posthead\" width=\"300\">\n";

if (($style_content = @file_get_contents("emoticons/$emoticon_path/style.css"))) {

    $style_matches = array();

    preg_match_all('/\.e_([\w_]+) \{.*\n[^\}]*background-image\s*:\s*url\s*\(["\']([^"\']*)["\']\)[^\}]*\}/i', $style_content, $style_matches);

    for ($i = 0; $i < count($style_matches[1]); $i++) {

        if (isset($emoticon_text[$style_matches[1][$i]])) {

            $string_matches = array();

            for ($j = 0; $j < count($emoticon_text[$style_matches[1][$i]]); $j++) {

                $string_matches[] = $emoticon_text[$style_matches[1][$i]][$j];
            }

            $emots_array[] = array('matches' => $string_matches,
                                   'text'    => $style_matches[1][$i],
                                   'img'     => $style_matches[2][$i]);
        }
    }

    foreach($emots_array as $emot) {

        echo "                          <tr onclick=\"insertEmoticon(' ", html_js_safe_str($emot['matches'][0]), " ');\">\n";
        echo "                            <td align=\"left\" width=\"100\"><img src=\"emoticons/$emoticon_path/{$emot['img']}\" alt=\"{$emot['text']}\" title=\"{$emot['text']}\" /></td>\n";
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