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

/* $Id: admin_folder_access.php,v 1.17 2004-03-03 23:15:17 decoyduck Exp $ */

// Compress the output
require_once("./include/gzipenc.inc.php");

// Enable the error handler
require_once("./include/errorhandler.inc.php");

//Check logged in status
require_once("./include/session.inc.php");
require_once("./include/header.inc.php");

if(!bh_session_check()){

    $uri = "./logon.php?final_uri=". urlencode(get_request_uri());
    header_redirect($uri);

}

require_once("./include/perm.inc.php");
require_once("./include/html.inc.php");
require_once("./include/forum.inc.php");
require_once("./include/db.inc.php");
require_once("./include/folder.inc.php");
require_once("./include/constants.inc.php");
require_once("./include/form.inc.php");
require_once("./include/admin.inc.php");
require_once("./include/lang.inc.php");
require_once("./include/format.inc.php");
require_once("./include/post.inc.php");
require_once("./include/admin.inc.php");

html_draw_top();

if(!(bh_session_get_value('STATUS') & USER_PERM_SOLDIER)) {
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;
}

// Update stuff here

if (isset($HTTP_GET_VARS['fid']) && is_numeric($HTTP_GET_VARS['fid'])) {
    $fid = $HTTP_GET_VARS['fid'];
}else if (isset($HTTP_POST_VARS['fid']) && is_numeric($HTTP_POST_VARS['fid'])) {
    $fid = $HTTP_POST_VARS['fid'];
}else {
    $fid = 1;
}

$folder_array = folder_get($fid);

echo "<h1>{$lang['admin']} : {$lang['managefolder']} : ", _stripslashes($folder_array['TITLE']), "</h1>\n";

if ($folder_array['ACCESS_LEVEL'] < 1) {
    echo "<h2>{$lang['folderisnotrestricted']}</h2>\n";
    html_draw_bottom();
    exit;
}

if (isset($HTTP_POST_VARS['usersearch']) && strlen(trim($HTTP_POST_VARS['usersearch'])) > 0) {
    $usersearch = trim($HTTP_POST_VARS['usersearch']);
}else {
    $usersearch = '';
}

// Clear the search results?

if (isset($HTTP_POST_VARS['clear'])) {
    $usersearch = '';
}

if (isset($HTTP_POST_VARS['add_recent_user'])) {
    $uf[0]['fid'] = $fid;
    $uf[0]['allowed'] = 1;
    user_update_folders($HTTP_POST_VARS['t_to_uid'], $uf);
    admin_addlog($HTTP_POST_VARS['add_recent_user'], 0, 0, 0, 0, 0, 2);
}elseif (isset($HTTP_POST_VARS['add_searched_user'])) {
    for ($i = 0; $i < sizeof($HTTP_POST_VARS['user_add']); $i++) {
        $uf[0]['fid'] = $fid;
        $uf[0]['allowed'] = 1;
        user_update_folders($HTTP_POST_VARS['user_add'][$i], $uf);
        admin_addlog($HTTP_POST_VARS['user_add'][$i], 0, 0, 0, 0, 0, 2);
    }
}elseif (isset($HTTP_POST_VARS['remove_user']) && isset($HTTP_POST_VARS['user_remove']) && is_array($HTTP_POST_VARS['user_remove'])) {
    for ($i = 0; $i < sizeof($HTTP_POST_VARS['user_remove']); $i++) {
        $uf[0]['fid'] = $fid;
        $uf[0]['allowed'] = 0;
        user_update_folders($HTTP_POST_VARS['user_remove'][$i], $uf);
        admin_addlog($HTTP_POST_VARS['user_remove'][$i], 0, 0, 0, 0, 0, 2);
    }
}

echo "<p>&nbsp;</p>\n";
echo "<div align=\"center\">\n";
echo "<form name=\"f_user\" action=\"admin_folder_access.php\" method=\"post\">\n";
echo form_input_hidden('fid', $fid), "\n";
echo "<table width=\"50%\">\n";
echo "  <tr>\n";
echo "    <td class=\"box\">\n";
echo "      <table class=\"posthead\" width=\"100%\">\n";
echo "        <tr>\n";
echo "          <td class=\"subhead\" align=\"left\">{$lang['existingpermissions']}</td>\n";
echo "        </tr>\n";

if ($user_array = folder_get_permissions($fid)) {
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

    if ($user_search_array = admin_user_search($usersearch)) {

        foreach ($user_search_array as $user_search) {
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
echo "<p>", form_button("back", "Back", "onclick=\"document.location.href='admin_folders.php'\""), "</p>\n";
echo "</form>\n";
echo "</div>\n";

html_draw_bottom();

?>