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

/* $Id: admin_forum_links.php,v 1.8 2005-03-14 13:27:14 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

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

// Fetch the forum settings
$forum_settings = forum_get_settings();

include_once(BH_INCLUDE_PATH. "admin.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "forum_links.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "links.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri(true));
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=admin.php%3Fpage%3D$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

if (!(perm_has_admin_access())) {

    html_draw_top();
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;

}

if (isset($_POST['l_lid'])) {

    $first_mark = false;

    foreach($_POST['l_lid'] as $lid => $value) {

        if (isset($_POST['l_delete'][$lid])) {

            forum_links_delete($lid);

        }else if (!$first_mark) {

            $first_mark = true;

            if ($lid == 0) {

                forum_links_add(1, $_POST['l_title'][$lid], "");

            }else {

                 forum_links_update($lid, 1, $_POST['l_title'][$lid], "");
            }

        }else {

            forum_links_update($lid, $_POST['l_pos'][$lid] + 1, $_POST['l_title'][$lid], $_POST['l_uri'][$lid]);
        }
    }

    $uid = bh_session_get_value('UID');
    admin_add_log_entry(EDIT_FORUM_LINKS);
}

if (isset($_POST['l_title_new']) && $_POST['l_title_new'] != "" && isset($_POST['l_pos_new']) && isset($_POST['l_uri_new'])) {

    forum_links_add($_POST['l_pos_new'] + 1, $_POST['l_title_new'], $_POST['l_uri_new']);

    $uid = bh_session_get_value('UID');
    admin_add_log_entry(EDIT_FORUM_LINKS);
}

html_draw_top();

echo "<h1>{$lang['admin']} : {$lang['editforumlinks']}</h1>\n";
echo "<p>{$lang['editforumlinks_exp']}</p>\n";

$links = forum_links_get_links();

if (isset($status_text)) echo $status_text;

echo "<form method=\"post\" action=\"admin_forum_links.php\">\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\">{$lang['position']}</td>\n";
echo "                  <td class=\"subhead\">{$lang['name']}</td>\n";
echo "                  <td class=\"subhead\">{$lang['address']}</td>\n";
echo "                  <td class=\"subhead\">{$lang['delete']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";

$lid = isset($links[0]) ? $links[0]['LID'] : 0;

echo "                  <td>". form_input_hidden("l_lid[$lid]", $lid) . $lang['top'] ."</td>\n";
echo "                  <td>". form_field("l_title[$lid]", isset($links[0]) ? $links[0]['TITLE'] : "", 32, 64) ."</td>\n";
echo "                  <td>&nbsp;</td>\n";
echo "                  <td>&nbsp;</td>\n";
echo "                </tr>\n";

for ($i = 1; $i < count($links); $i++) {

        $lid = $links[$i]['LID'];

        echo "                <tr>\n";

        if (count($links) > 2) {

            echo "                  <td>", form_dropdown_array("l_pos[$lid]", range(1, count($links)-1), range(1, count($links)-1), $i), form_input_hidden("l_lid[$lid]", $lid), "</td>\n";

        }else {

            echo "                  <td>1", form_input_hidden("l_pos[$lid]", 1), form_input_hidden("l_lid[$lid]", $lid), "</td>\n";
        }

        echo "                  <td>". form_field("l_title[$lid]", $links[$i]['TITLE'], 32, 64) ."</td>\n";
        echo "                  <td>". form_field("l_uri[$lid]", $links[$i]['URI'], 32, 255) ."</td>\n";
        echo "                  <td>". form_submit("l_delete[$lid]", $lang['delete']) ."</td>\n";
        echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td>". form_input_hidden("l_pos_new", $i).$lang['newcaps'] ."</td>\n";
echo "                  <td>". form_field("l_title_new", "", 32, 64) ."</td>\n";
echo "                  <td>". form_field("l_uri_new", "", 32, 255) ."</td>\n";
echo "                  <td>&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>&nbsp;</td>\n";
echo "                  <td>&nbsp;</td>\n";
echo "                  <td>&nbsp;</td>\n";
echo "                  <td>&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td>&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"center\">". form_submit("submit", $lang['submit'])." ".form_reset() ."</td>\n";
echo "    </tr>\n";
echo "  </table>\n";

echo "</form>\n";

html_draw_bottom();

?>