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

/* $Id: admin_forum_links.php,v 1.2 2004-09-13 12:34:11 tribalonline Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Installation checking functions
include_once("./include/install.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum settings
$forum_settings = get_forum_settings();

include_once("./include/admin.inc.php");
include_once("./include/constants.inc.php");
include_once("./include/db.inc.php");
include_once("./include/form.inc.php");
include_once("./include/forum_links.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/perm.inc.php");
include_once("./include/session.inc.php");
include_once("./include/user.inc.php");

if (!$user_sess = bh_session_check()) {

    html_draw_top();

    if (isset($_POST['user_logon']) && isset($_POST['user_password']) && isset($_POST['user_passhash'])) {

        if (perform_logon(false)) {

            $lang = load_language_file();
            $webtag = get_webtag($webtag_search);

            echo "<h1>{$lang['loggedinsuccessfully']}</h1>";
            echo "<div align=\"center\">\n";
            echo "<p><b>{$lang['presscontinuetoresend']}</b></p>\n";

            $request_uri = get_request_uri();

            echo "<form method=\"post\" action=\"$request_uri\" target=\"_self\">\n";
            echo form_input_hidden('webtag', $webtag);

            foreach($_POST as $key => $value) {
                echo form_input_hidden($key, _htmlentities(_stripslashes($value)));
            }

            echo form_submit(md5(uniqid(rand())), $lang['continue']), "&nbsp;";
            echo form_button(md5(uniqid(rand())), $lang['cancel'], "onclick=\"self.location.href='$request_uri'\""), "\n";
            echo "</form>\n";

            html_draw_bottom();
            exit;
        }
    }

    draw_logon_form(false);
    html_draw_bottom();
    exit;
}

// Load language file

$lang = load_language_file();

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

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
			// Delete
			forum_links_delete($lid);

		} else if (!$first_mark) {
			$first_mark = true;
			if ($lid == 0) {
				forum_links_add(1, $_POST['l_title'][$lid], "");
			} else {
				forum_links_update($lid, 1, $_POST['l_title'][$lid], "");
			}

		} else {
			// Update
			forum_links_update($lid, $_POST['l_pos'][$lid] + 1, $_POST['l_title'][$lid], $_POST['l_uri'][$lid]);
		}
	}

    $uid = bh_session_get_value('UID');
    admin_addlog($uid, 0, 0, 0, 0, 0, 35);
}
if (isset($_POST['l_title_new']) && $_POST['l_title_new'] != "" && isset($_POST['l_pos_new']) && isset($_POST['l_uri_new'])) {
	forum_links_add($_POST['l_pos_new'] + 1, $_POST['l_title_new'], $_POST['l_uri_new']);

    $uid = bh_session_get_value('UID');
    admin_addlog($uid, 0, 0, 0, 0, 0, 35);
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

for ($i=1; $i<count($links); $i++) {
	$lid = $links[$i]['LID'];
	echo "                <tr>\n";

	if (count($links) > 2) {
		echo "                  <td>", form_dropdown_array("l_pos[$lid]", range(1, count($links)-1), range(1, count($links)-1), $i), form_input_hidden("l_lid[$lid]", $lid), "</td>\n";
	} else {
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