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

/* $Id: links.php,v 1.69 2005-02-06 14:28:04 decoyduck Exp $ */

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

include_once("./include/form.inc.php");
include_once("./include/format.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/links.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/perm.inc.php");
include_once("./include/session.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri(true));
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {

    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

if (forum_get_setting('show_links', 'N', false)) {

    html_draw_top();
    echo "<h2>{$lang['maynotaccessthissection']}</h2>\n";
    html_draw_bottom();
    exit;
}

$folders = links_folders_get(perm_is_moderator());

if (isset($_GET['fid']) && is_numeric($_GET['fid'])) {

    $fid = $_GET['fid'];

}elseif (is_array($folders)) {

    list($fid) = array_keys($folders);

}else {

    links_add_folder(1, $lang['toplevel'], true);
    $folders = links_folders_get(perm_is_moderator());
    $fid = 1;
}

if (isset($_GET['action'])) {

    if (perm_is_moderator() && $_GET['action'] == "folderhide") {

        links_folder_change_visibility($fid, false);

        if (isset($_GET['new_fid']) && is_numeric($_GET['new_fid'])) {
            $fid = $_GET['new_fid'];
        }else {
            $fid = 1;
        }

    }elseif (perm_is_moderator() && $_GET['action'] == "foldershow") {

        links_folder_change_visibility($fid, true);

        if (isset($_GET['new_fid']) && is_numeric($_GET['new_fid'])) {
            $fid = $_GET['new_fid'];
        }else {
            $fid = 1;
        }

    }elseif (perm_is_moderator() && $_GET['action'] == "folderdel") {

        $folders = links_folders_get(perm_is_moderator());
        if (count(links_get_subfolders($fid, $folders)) == 0) links_folder_delete($fid);

        if (isset($_GET['new_fid']) && is_numeric($_GET['new_fid'])) {
            $fid = $_GET['new_fid'];
        }else {
            $fid = 1;
        }

    }elseif ($_GET['action'] == "go") {

        links_click($_GET['lid']);
        exit;
    }
}

if (isset($_GET['viewmode']) && is_numeric($_GET['viewmode']) && $_GET['viewmode'] == 1) {
    $viewmode = $_GET['viewmode'];
}else {
    $viewmode = 0;
}

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $start = floor($_GET['page'] - 1) * 20;
}else {
    $start = 0;
}

html_draw_top("robots=noindex,nofollow");

echo "<h1>{$lang['links']}</h1>\n";
echo "<div align=\"right\">{$lang['viewmode']}: ";

echo ($viewmode == 0) ? "<b>" : "";
echo "<a href=\"links.php?webtag=$webtag&amp;fid=$fid&amp;viewmode=0\">{$lang['hierarchical']}</a>";
echo ($viewmode == 0) ? "</b> | " : " | ";

echo ($viewmode == 1) ? "<b>" : "";
echo "<a href=\"links.php?webtag=$webtag&amp;fid=$fid&amp;viewmode=1\">{$lang['list']}</a></div>\n";
echo ($viewmode == 1) ? "</b>" : "";

// work out where we are in the folder hierarchy and display links to all the higher levels

if ($viewmode == 0) {

    echo "<h2>" . links_display_folder_path($fid, $folders) . "</h2>\n";

    if ($folders[$fid]['VISIBLE'] == "N") echo "<p class=\"threadtime\">{$lang['folderhidden']}. <a href=\"links.php?webtag=$webtag&amp;fid=$fid&amp;action=foldershow\">[{$lang['unhide']}]</a></p>";

    $subfolders = links_get_subfolders($fid, $folders);

    $new_folder_link = bh_session_get_value('UID') ? "[<a href=\"links_add.php?webtag=$webtag&amp;mode=folder&amp;fid=$fid\">{$lang['newfolder']}</a>]" : "";

    if (count($subfolders) == 0) {

        echo "<p><span class=\"threadtime\">{$lang['nosubfolders']}. $new_folder_link</span></p>\n";

    }else {

        if (count($subfolders) == 1) {
            echo "<p><span class=\"threadtime\">{$lang['1subfolder']}: $new_folder_link</span></p>\n";
        }else {
            echo "<p><span class=\"threadtime\">" . count($subfolders) . " {$lang['subfoldersinthiscategory']}: $new_folder_link</span></p>\n";
        }

        echo "<table>\n";

        // create list of subfolders

        while (list($key, $val) = each($subfolders)) {

            echo "  <tr>\n";
            echo "    <td class=\"postbody\"><img src=\"" . style_image("folder.png") . "\" alt=\"{$lang['folder']}\" title=\"{$lang['folder']}\" /></td><td class=\"postbody\"><a href=\"links.php?webtag=$webtag&amp;fid=$val\""; if ($folders[$val]['VISIBLE'] == "N") echo "class=\"link_hidden\""; echo ">" . _stripslashes($folders[$val]['NAME']) . "</a>";

            if (perm_is_moderator() && $folders[$val]['VISIBLE'] == "Y") {

                echo "&nbsp;<a href=\"links.php?webtag=$webtag&amp;fid=$val&amp;action=folderhide&amp;new_fid=$fid\" class=\"threadtime\">[{$lang['hide']}]</a>\n";

            }elseif (perm_is_moderator() && $folders[$val]['VISIBLE'] == "N") {

                echo "&nbsp;<a href=\"links.php?webtag=$webtag&amp;fid=$val&amp;action=foldershow&amp;new_fid=$fid\" class=\"threadtime\">[{$lang['unhide']}]</a>\n";
            }

            if (perm_is_moderator() && count(links_get_subfolders($val, $folders)) == 0) echo "<a href=\"links.php?webtag=$webtag&amp;fid=$val&amp;action=folderdel&amp;new_fid=$fid\" class=\"threadtime\">[{$lang['delete']}]</a>\n";

            echo "</td>\n";
            echo "  </tr>\n";
        }

        echo "</table>\n";

        if (perm_is_moderator()) echo "<p class=\"threadtime\">{$lang['linksdelexp']}</p>";
    }

}else {

    echo "<h2>{$lang['listview']}</h2>\n";
    echo "<p>{$lang['listviewcannotaddfolders']}</p>\n";
}

if (isset($_GET['sort_by'])) {

    if ($_GET['sort_by'] == "TITLE") {
        $sort_by = "TITLE";
    }elseif ($_GET['sort_by'] == "DESCRIPTION") {
        $sort_by = "DESCRIPTION";
    }elseif ($_GET['sort_by'] == "NICKNAME") {
        $sort_by = "NICKNAME";
    }elseif ($_GET['sort_by'] == "CREATED") {
        $sort_by = "CREATED";
    }elseif ($_GET['sort_by'] == "CLICKS") {
        $sort_by = "CLICKS";
    }elseif ($_GET['sort_by'] == "RATING") {
        $sort_by = "RATING";
    }

}else {

    if ($viewmode == 0) {
        $sort_by = "TITLE";
    }else {
        $sort_by = "CREATED";
    }
}

if (isset($_GET['sort_dir'])) {

    if ($_GET['sort_dir'] == "DESC") {
        $sort_dir = "DESC";
    }else {
        $sort_dir = "ASC";
    }

}else {

    if ($viewmode == 0) {
        $sort_dir = "ASC";
    }else {
        $sort_dir = "DESC";
    }
}

if ($viewmode == 0) {
    $links = links_get_in_folder($fid, perm_is_moderator(), $sort_by, $sort_dir, $start);
}else {
    $links = links_get_all(perm_is_moderator(), $sort_by, $sort_dir, $start);
}

echo "<div align=\"center\">\n";
echo "<table width=\"95%\">\n";
echo "  <tr>\n";

if ($sort_by == "TITLE" && $sort_dir == "ASC") {
    echo "    <td class=\"posthead\">&nbsp;<a href=\"links.php?webtag=$webtag&amp;fid=$fid&amp;viewmode=$viewmode&amp;page=$start&amp;sort_by=TITLE&amp;sort_dir=DESC\">{$lang['name']}</a>&nbsp;</td>\n";
}else {
    echo "    <td class=\"posthead\">&nbsp;<a href=\"links.php?webtag=$webtag&amp;fid=$fid&amp;viewmode=$viewmode&amp;page=$start&amp;sort_by=TITLE&amp;sort_dir=ASC\">{$lang['name']}</a>&nbsp;</td>\n";
}

if ($sort_by == "DESCRIPTION" && $sort_dir == "ASC") {
    echo "    <td class=\"posthead\" width=\"250\">&nbsp;<a href=\"links.php?webtag=$webtag&amp;fid=$fid&amp;viewmode=$viewmode&amp;page=$start&amp;sort_by=DESCRIPTION&amp;sort_dir=DESC\">{$lang['description']}</a>&nbsp;</td>\n";
}else {
    echo "    <td class=\"posthead\" width=\"250\">&nbsp;<a href=\"links.php?webtag=$webtag&amp;fid=$fid&amp;viewmode=$viewmode&amp;page=$start&amp;sort_by=DESCRIPTION&amp;sort_dir=ASC\">{$lang['description']}</a>&nbsp;</td>\n";
}

if ($sort_by == "CREATED" && $sort_dir == "ASC") {
    echo "    <td class=\"posthead\">&nbsp;<a href=\"links.php?webtag=$webtag&amp;fid=$fid&amp;viewmode=$viewmode&amp;page=$start&amp;sort_by=CREATED&amp;sort_dir=DESC\">{$lang['date']}</a>&nbsp;</td>\n";
}else {
    echo "    <td class=\"posthead\">&nbsp;<a href=\"links.php?webtag=$webtag&amp;fid=$fid&amp;viewmode=$viewmode&amp;page=$start&amp;sort_by=CREATED&amp;sort_dir=ASC\">{$lang['date']}</a>&nbsp;</td>\n";
}

if ($sort_by == "RATING" && $sort_dir == "DESC") {
    echo "    <td class=\"posthead\">&nbsp;<a href=\"links.php?webtag=$webtag&amp;fid=$fid&amp;viewmode=$viewmode&amp;page=$start&amp;sort_by=RATING&amp;sort_dir=ASC\">{$lang['rating']}</a>&nbsp;</td>";
}else {
    echo "    <td class=\"posthead\">&nbsp;<a href=\"links.php?webtag=$webtag&amp;fid=$fid&amp;viewmode=$viewmode&amp;page=$start&amp;sort_by=RATING&amp;sort_dir=DESC\">{$lang['rating']}</a>&nbsp;</td>";
}

echo "    <td class=\"posthead\">{$lang['commentsslashvote']}</td>\n";
echo "  </tr>\n";

if (sizeof($links['links_array']) > 0 ) {

    foreach ($links['links_array'] as $key => $link) {

        if ($link['VISIBLE'] == "N") {

            echo "  <tr class=\"link_hidden\">\n";
            echo "    <td class=\"postbody\" valign=\"top\"><a href=\"links.php?webtag=$webtag&amp;lid=$key&amp;action=go\" target=\"_blank\" class=\"link_hidden\">", _stripslashes($link['TITLE']), "</a></td>\n";

        }else {

            echo "  <tr>\n";
            echo "    <td class=\"postbody\" valign=\"top\"><a href=\"links.php?webtag=$webtag&amp;lid=$key&amp;action=go\" target=\"_blank\">", _stripslashes($link['TITLE']), "</a></td>\n";
        }

        echo "    <td class=\"postbody\" width=\"50%\" valign=\"top\">", _stripslashes($link['DESCRIPTION']), "</td>\n";
        echo "    <td class=\"postbody\" valign=\"top\">", format_time($link['CREATED']), "</td>\n";

        if (isset($link['RATING']) && $link['RATING'] != "") {
            echo "    <td class=\"postbody\" valign=\"top\">", round($link['RATING'], 1), "</td>\n";
        }else {
            echo "    <td class=\"postbody\" valign=\"top\">&nbsp;</td>\n";
        }

        echo "    <td class=\"postbody\" valign=\"top\"><a href=\"links_detail.php?webtag=$webtag&amp;lid=$key&fid=$fid\" class=\"threadtime\">[{$lang['view']}]</a></td>\n";
        echo "  </tr>\n";
    }

}else {

    echo "  <tr>\n";
    echo "    <td colspan=\"5\" class=\"postbody\">{$lang['nolinksinfolder']}</td>\n";
    echo "  </tr>\n";
}

echo "  <tr>\n";
echo "    <td class=\"postbody\">&nbsp;</td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td class=\"postbody\" colspan=\"5\"><a href=\"links_add.php?webtag=$webtag&amp;mode=link&amp;fid=$fid\"><b>{$lang['addlinkhere']}</b></a></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "    <td class=\"postbody\" colspan=\"5\" align=\"center\">", page_links(get_request_uri(), $start, $links['links_count'], 20), "</td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo "</div>\n";

html_draw_bottom();

?>