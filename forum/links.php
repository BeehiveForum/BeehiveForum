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

/* $Id: links.php,v 1.53 2004-04-24 18:42:17 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

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

if (!$webtag = get_webtag()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?final_uri=$request_uri");
}

if (forum_get_setting('show_links', 'N', false)) {
    html_draw_top();
    echo "<h2>{$lang['maynotaccessthissection']}</h2>\n";
    html_draw_bottom();
    exit;
}

if (isset($_GET['action'])) {
    if (perm_is_moderator() && $_GET['action'] == "folderhide") {
        links_folder_change_visibility($_GET['fid'], false);
        $fid = $_GET['new_fid'];
    } elseif (perm_is_moderator() && $_GET['action'] == "foldershow") {
        links_folder_change_visibility($_GET['fid'], true);
        $fid = $_GET['new_fid'];
    } elseif (perm_is_moderator() && $_GET['action'] == "folderdel") {
        $folders = links_folders_get(perm_is_moderator());
        if (count(links_get_subfolders($_GET['fid'], $folders)) == 0) links_folder_delete($_GET['fid']);
        $fid = $_GET['new_fid'];
    } elseif ($_GET['action'] == "go") {
        links_click($_GET['lid']);
        exit;
    }
}

$folders = links_folders_get(perm_is_moderator());

// if the LINKS_FOLDERS database is empty, add a 'Top Level' folder

if (!is_array($folders)) {
  links_add_folder(1, $lang['toplevel'], true);
  $folders = links_folders_get(perm_is_moderator());
}

if (isset($_GET['fid']) && is_numeric($_GET['fid']) && !isset($fid)) { // default to top level folder if no other valid folder specified
    if (is_array($folders) && array_key_exists($_GET['fid'], $folders)) {
        $fid = $_GET['fid'];
    } else {
        list($fid) = array_keys($folders);
    }
} elseif (!isset($fid)) {
    list($fid) = array_keys($folders);
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

html_draw_top();

echo "<h1>{$lang['links']}</h1>\n";
echo "<div align=\"right\">{$lang['viewmode']}: ";

echo ($viewmode == 0) ? "<b>" : "";
echo "<a href=\"links.php?webtag=$webtag&fid=$fid&amp;viewmode=0\">{$lang['hierarchical']}</a>";
echo ($viewmode == 0) ? "</b> | " : " | ";

echo ($viewmode == 1) ? "<b>" : "";
echo "<a href=\"links.php?webtag=$webtag&fid=$fid&amp;viewmode=1\">{$lang['list']}</a></div>\n";
echo ($viewmode == 1) ? "</b>" : "";

// work out where we are in the folder hierarchy and display links to all the higher levels

if ($viewmode == 0) {
    echo "<h2>" . links_display_folder_path($fid, $folders) . "</h2>\n";
    if ($folders[$fid]['VISIBLE'] == "N") echo "<p class=\"threadtime\">{$lang['folderhidden']}. <a href=\"links.php?webtag=$webtag&fid=$fid&amp;action=foldershow\">[{$lang['unhide']}]</a></p>";

    $subfolders = links_get_subfolders($fid, $folders);

    $new_folder_link = bh_session_get_value('UID') ? "[<a href=\"links_add.php?webtag=$webtag&mode=folder&amp;fid=$fid\">{$lang['newfolder']}</a>]" : "";

    if (count($subfolders) == 0) {
        echo "<p><span class=\"threadtime\">{$lang['nosubfolders']}. $new_folder_link</span></p>\n";
    } else {
        if (count($subfolders) == 1) {
            echo "<p><span class=\"threadtime\">{$lang['1subfolder']}: $new_folder_link</span></p>\n";
        } else {
            echo "<p><span class=\"threadtime\">" . count($subfolders) . " {$lang['subfoldersinthiscategory']}: $new_folder_link</span></p>\n";
        }
        echo "<table>\n";
        // create list of subfolders
        while (list($key, $val) = each($subfolders)) {
            echo "<tr><td class=\"postbody\"><img src=\"" . style_image("folder.png") . "\" alt=\"folder\" /></td><td class=\"postbody\"><a href=\"links.php?webtag=$webtag&fid=$val\""; if ($folders[$val]['VISIBLE'] == "N") echo "style=\"color: gray;\""; echo ">" . _stripslashes($folders[$val]['NAME']) . "</a>";
            if (perm_is_moderator() && $folders[$val]['VISIBLE'] == "Y") {
                echo "&nbsp;<a href=\"links.php?webtag=$webtag&fid=$val&amp;action=folderhide&amp;new_fid=$fid\" class=\"threadtime\">[{$lang['hide']}]</a>\n";
            } elseif (perm_is_moderator() && $folders[$val]['VISIBLE'] == "N") {
                echo "&nbsp;<a href=\"links.php?webtag=$webtag&fid=$val&amp;action=foldershow&amp;new_fid=$fid\" class=\"threadtime\">[{$lang['unhide']}]</a>\n";
            }
            if (perm_is_moderator() && count(links_get_subfolders($val, $folders)) == 0) echo "<a href=\"links.php?webtag=$webtag&fid=$val&amp;action=folderdel&amp;new_fid=$fid\" class=\"threadtime\">[{$lang['delete']}]</a>\n";
            echo "</td></tr>\n";
        }
        echo "</table>\n";
        if (perm_is_moderator()) echo "<p class=\"threadtime\">{$lang['linksdelexp']}</p>";
    }
}else {
    echo "<h2>{$lang['listview']}</h2>\n";
    echo "<p>{$lang['listviewcannotaddfolders']}</p>\n";
}

if (isset($_GET['sort_by'])) { // this seems slightly wasteful, but it's for security - just passing $_GET['sort_by'] straight to the SQL query is not a good idea (what might happen if you tried to search by "TITLE; DROP DATABASE beehive;"?)
    if ($_GET['sort_by'] == "TITLE") {
        $sort_by = "TITLE";
    } elseif ($_GET['sort_by'] == "DESCRIPTION") {
        $sort_by = "DESCRIPTION";
    } elseif ($_GET['sort_by'] == "NICKNAME") {
        $sort_by = "NICKNAME";
    } elseif ($_GET['sort_by'] == "CREATED") {
        $sort_by = "CREATED";
    } elseif ($_GET['sort_by'] == "CLICKS") {
        $sort_by = "CLICKS";
    } elseif ($_GET['sort_by'] == "RATING") {
        $sort_by = "RATING";
    }
} else {
    if ($viewmode == 0) {
        $sort_by = "TITLE";
    }else {
        $sort_by = "CREATED";
    }
}

if (isset($_GET['sort_dir'])) {
    if ($_GET['sort_dir'] == "DESC") {
        $sort_dir = "DESC";
    } else {
        $sort_dir = "ASC";
    }
} else {
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

echo "<table width=\"95%\" align=\"center\">\n";
echo "  <tr>\n";

echo "    <td class=\"posthead\">&nbsp;";
if ($sort_by == "TITLE" && $sort_dir == "ASC") {
    echo "<a href=\"links.php?webtag=$webtag&fid=$fid&amp;viewmode=$viewmode&amp;page=$start&amp;sort_by=TITLE&amp;sort_dir=DESC\">{$lang['name']}</a>";
} else {
    echo "<a href=\"links.php?webtag=$webtag&fid=$fid&amp;viewmode=$viewmode&amp;page=$start&amp;sort_by=TITLE&amp;sort_dir=ASC\">{$lang['name']}</a>";
}
echo "&nbsp;</td>\n";

echo "    <td class=\"posthead\" width=\"250\">&nbsp;";
if ($sort_by == "DESCRIPTION" && $sort_dir == "ASC") {
    echo "<a href=\"links.php?webtag=$webtag&fid=$fid&amp;viewmode=$viewmode&amp;page=$start&amp;sort_by=DESCRIPTION&amp;sort_dir=DESC\">{$lang['description']}</a>";
} else {
    echo "<a href=\"links.php?webtag=$webtag&fid=$fid&amp;viewmode=$viewmode&amp;page=$start&amp;sort_by=DESCRIPTION&amp;sort_dir=ASC\">{$lang['description']}</a>";
}
echo "&nbsp;</td>\n";

echo "    <td class=\"posthead\">&nbsp;";
if ($sort_by == "CREATED" && $sort_dir == "ASC") {
    echo "<a href=\"links.php?webtag=$webtag&fid=$fid&amp;viewmode=$viewmode&amp;page=$start&amp;sort_by=CREATED&amp;sort_dir=DESC\">{$lang['date']}</a>";
} else {
    echo "<a href=\"links.php?webtag=$webtag&fid=$fid&amp;viewmode=$viewmode&amp;page=$start&amp;sort_by=CREATED&amp;sort_dir=ASC\">{$lang['date']}</a>";
}
echo "&nbsp;</td>\n";

echo "    <td class=\"posthead\">&nbsp;";
if ($sort_by == "RATING" && $sort_dir == "DESC") {
    echo "<a href=\"links.php?webtag=$webtag&fid=$fid&amp;viewmode=$viewmode&amp;page=$start&amp;sort_by=RATING&amp;sort_dir=ASC\">{$lang['rating']}</a>";
} else {
    echo "<a href=\"links.php?webtag=$webtag&fid=$fid&amp;viewmode=$viewmode&amp;page=$start&amp;sort_by=RATING&amp;sort_dir=DESC\">{$lang['rating']}</a>";
}
echo "&nbsp;</td>\n";
echo "    <td class=\"posthead\">{$lang['commentsslashvote']}</td>\n";
echo "  </tr>\n";

if (sizeof($links['links_array']) > 0 ) {

    foreach ($links['links_array'] as $key => $link) {

        echo "  <tr" ; if ($link['VISIBLE'] == "N") echo " style=\"color: gray\""; echo ">\n";
        echo "    <td class=\"postbody\" valign=\"top\"><a href=\"links.php?webtag=$webtag&lid=$key&amp;action=go\" target=\"_blank\""; if ($link['VISIBLE'] == "N") echo " style=\"color: gray\""; echo ">". _stripslashes($link['TITLE']) . "</a></td>\n";
        echo "    <td class=\"postbody\" width=\"50%\" valign=\"top\">", _stripslashes($link['DESCRIPTION']), "</td>\n";
        echo "    <td class=\"postbody\" valign=\"top\">", format_time($link['CREATED']), "</td>\n";

	if (isset($link['RATING']) && $link['RATING'] != "") {
            echo "    <td class=\"postbody\" valign=\"top\">", round($link['RATING'], 1), "</td>\n";
	}else {
	    echo "    <td class=\"postbody\" valign=\"top\">&nbsp;</td>\n";
	}

        echo "    <td class=\"postbody\" valign=\"top\"><a href=\"links_detail.php?webtag=$webtag&lid=$key\" class=\"threadtime\">[{$lang['view']}]</a></td>\n";
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
echo "    <td class=\"postbody\" colspan=\"5\"><a href=\"links_add.php?webtag=$webtag&mode=link&amp;fid=$fid\"><b>{$lang['addlinkhere']}</b></a></td>\n";
echo "  </tr>\n";
echo "  <tr>\n";
echo "      <td class=\"postbody\" colspan=\"5\" align=\"center\">{$lang['pages']}: ";

$page_count = ceil($links['links_count'] / 20);

if ($page_count > 1) {

    for ($page = 1; $page <= $page_count; $page++) {
        echo "<a href=\"links.php?webtag=$webtag&amp;fid=$fid&amp;page=$page\" target=\"_self\">$page</a> ";
    }

}else {

    echo "<a href=\"links.php?webtag=$webtag&amp;fid=$fid&amp;page=1\" target=\"_self\">1</a> ";
}

echo "</td>\n";
echo "  </tr>\n";
echo "</table>\n";

html_draw_bottom();

?>