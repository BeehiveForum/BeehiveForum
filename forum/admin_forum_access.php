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

/* $Id: admin_forum_access.php,v 1.9 2004-04-28 14:28:51 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum settings
$forum_settings = get_forum_settings();

include_once("./include/admin.inc.php");
include_once("./include/constants.inc.php");
include_once("./include/db.inc.php");
include_once("./include/folder.inc.php");
include_once("./include/form.inc.php");
include_once("./include/format.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/perm.inc.php");
include_once("./include/post.inc.php");
include_once("./include/session.inc.php");

if (!$user_sess = bh_session_check()) {

    if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {

        if (perform_logon(false)) {

	    html_draw_top();

            echo "<h1>{$lang['loggedinsuccessfully']}</h1>";
            echo "<div align=\"center\">\n";
	    echo "<p><b>{$lang['presscontinuetoresend']}</b></p>\n";

            $request_uri = get_request_uri();

            echo "<form method=\"post\" action=\"$request_uri\" target=\"_self\">\n";

            foreach($_POST as $key => $value) {
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

// Load language file

$lang = load_language_file();

// Check we have a webtag

$webtag = get_webtag($webtag_search);

html_draw_top();

if (!(bh_session_get_value('STATUS')&USER_PERM_QUEEN)) {
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;
}

// Update stuff here

if (isset($_GET['fid']) && is_numeric($_GET['fid'])) {
    $fid = $_GET['fid'];
}else if (isset($_POST['fid']) && is_numeric($_POST['fid'])) {
    $fid = $_POST['fid'];
}else {
    $fid = 1;
}

if ($forum_array = forum_get($fid)) {

    echo "<h1>{$lang['admin']} : {$lang['manageforums']} : ", _stripslashes($forum_array['FORUM_SETTINGS']['forum_name']), "</h1>\n";

    if ($forum_array['ACCESS_LEVEL'] < 1) {
        echo "<h2>{$lang['forumisnotrestricted']}</h2>\n";
        html_draw_bottom();
        exit;
    }

    if (isset($_POST['usersearch']) && strlen(trim($_POST['usersearch'])) > 0) {
        $usersearch = trim($_POST['usersearch']);
    }else {
        $usersearch = '';
    }

    // Clear the search results?

    if (isset($_POST['clear'])) {
        $usersearch = '';
    }

    if (isset($_POST['add_recent_user'])) {
        $uf[0]['fid'] = $fid;
        $uf[0]['allowed'] = 1;
        user_update_forums($_POST['t_to_uid'], $uf);
    }elseif (isset($_POST['add_searched_user'])) {
        if (isset($_POST['user_add']) && is_array($_POST['user_add'])) {
            for ($i = 0; $i < sizeof($_POST['user_add']); $i++) {
                $uf[0]['fid'] = $fid;
                $uf[0]['allowed'] = 1;
                user_update_forums($_POST['user_add'][$i], $uf);
	    }
        }
    }elseif (isset($_POST['remove_user'])) {
        if (isset($_POST['user_remove']) && is_array($_POST['user_remove'])) {
            for ($i = 0; $i < sizeof($_POST['user_remove']); $i++) {
                $uf[0]['fid'] = $fid;
                $uf[0]['allowed'] = 0;
                user_update_forums($_POST['user_remove'][$i], $uf);
                admin_addlog($_POST['user_remove'][$i], 0, 0, 0, 0, 0, 2);
	    }
        }
    }

    echo "<p>&nbsp;</p>\n";
    echo "<div align=\"center\">\n";
    echo "<form name=\"f_user\" action=\"admin_forum_access.php\" method=\"post\">\n";
    echo form_input_hidden('fid', $fid), "\n";
    echo "<table width=\"50%\">\n";
    echo "  <tr>\n";
    echo "    <td class=\"box\">\n";
    echo "      <table class=\"posthead\" width=\"100%\">\n";
    echo "        <tr>\n";
    echo "          <td class=\"subhead\" align=\"left\">{$lang['existingpermissions']}</td>\n";
    echo "        </tr>\n";

    if ($user_array = forum_get_permissions($fid)) {

        foreach ($user_array as $user_permission) {
            echo "        <tr>\n";
            echo "          <td align=\"left\">", form_checkbox("user_remove[]", $user_permission['UID'], ''), "&nbsp;", format_user_name($user_permission['LOGON'], $user_permission['NICKNAME']), "</td>\n";
            echo "        </tr>\n";
        }

        echo "        <tr>\n";
        echo "          <td align=\"left\">&nbsp;</td>\n";
        echo "        </tr>\n";
        echo "        <tr>\n";
        echo "          <td align=\"center\">", form_submit('remove_user', $lang['remove']), "</td>\n";
        echo "        </tr>\n";

    }else {

        echo "        <tr>\n";
        echo "          <td align=\"left\">{$lang['nousers']}</td>\n";
        echo "        </tr>\n";
    }

    echo "        <tr>\n";
    echo "          <td align=\"left\">&nbsp;</td>\n";
    echo "        </tr>\n";

    if (strlen($usersearch) > 0) {

        echo "        <tr>\n";
        echo "          <td class=\"subhead\" align=\"left\">{$lang['searchresults']}</td>\n";
        echo "        </tr>\n";

        $user_search_array = admin_user_search($usersearch);

	if (sizeof($user_search_array['user_array']) > 0) {

            foreach ($user_search_array['user_array'] as $user_search) {
                echo "        <tr>\n";
                echo "          <td align=\"left\">", form_checkbox("user_add[]", $user_search['UID'], ''), "&nbsp;", format_user_name($user_search['LOGON'], $user_search['NICKNAME']), "</td>\n";
                echo "        </tr>\n";
            }

            echo "        <tr>\n";
            echo "          <td align=\"left\">&nbsp;</td>\n";
            echo "        </tr>\n";
            echo "        <tr>\n";
            echo "          <td align=\"left\">", form_submit('add_searched_user', $lang['add']), "</td>\n";
            echo "        </tr>\n";

        }else {

            echo "        <tr>\n";
            echo "          <td align=\"left\">{$lang['nomatches']}</td>\n";
            echo "        </tr>\n";
        }

    }else {

        echo "        <tr>\n";
        echo "          <td class=\"subhead\" align=\"left\">{$lang['addnewuser']}</td>\n";
        echo "        </tr>\n";
        echo "        <tr>\n";
        echo "          <td>{$lang['adduser']}: ", post_draw_to_dropdown(false, false), "&nbsp;", form_submit('add_recent_user', $lang['add']), "</td>\n";
        echo "        </tr>\n";

    }

    echo "        <tr>\n";
    echo "          <td align=\"left\">&nbsp;</td>\n";
    echo "        </tr>\n";
    echo "        <tr>\n";
    echo "          <td class=\"subhead\" align=\"left\">{$lang['searchforuser']}</td>\n";
    echo "        </tr>\n";
    echo "        <tr>\n";
    echo "          <td align=\"left\">{$lang['search']}: ", form_input_text('usersearch', $usersearch), "&nbsp;", form_submit('search', $lang['search']), "&nbsp;", form_submit('clear', $lang['clear']), "</td>\n";
    echo "        </tr>\n";
    echo "        <tr>\n";
    echo "          <td align=\"left\">&nbsp;</td>\n";
    echo "        </tr>\n";
    echo "      </table>\n";
    echo "    </td>\n";
    echo "  </tr>\n";
    echo "</table>\n";
    echo "<p>", form_button("back", "Back", "onclick=\"document.location.href='admin_forums.php'\""), "</p>\n";
    echo "</form>\n";
    echo "</div>\n";
}

html_draw_bottom();

?>