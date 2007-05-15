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

/* $Id: links.php,v 1.96 2007-05-15 22:13:16 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

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

// Fetch the forum settings
$forum_settings = forum_get_settings();

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "links.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");

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

if (!forum_get_setting('show_links', 'Y')) {

    html_draw_top();
    html_error_msg($lang['maynotaccessthissection']);
    html_draw_bottom();
    exit;
}

$folders = links_folders_get(bh_session_check_perm(USER_PERM_LINKS_MODERATE, 0));

if (isset($_GET['fid']) && is_numeric($_GET['fid'])) {

    $fid = $_GET['fid'];

}elseif (is_array($folders)) {

    list($fid) = array_keys($folders);

}else {

    links_create_top_folder($lang['toplevel']);
    header_redirect("./links.php?fid=1");
}

if (isset($_GET['action'])) {

    if (bh_session_check_perm(USER_PERM_LINKS_MODERATE, 0) && $_GET['action'] == "folderhide") {

        links_folder_change_visibility($fid, false);

        if (isset($_GET['new_fid']) && is_numeric($_GET['new_fid'])) {
            $fid = $_GET['new_fid'];
        }else {
            $fid = 1;
        }

        header_redirect("./links.php?fid=$fid");

    }elseif (bh_session_check_perm(USER_PERM_LINKS_MODERATE, 0) && $_GET['action'] == "foldershow") {

        links_folder_change_visibility($fid, true);

        if (isset($_GET['new_fid']) && is_numeric($_GET['new_fid'])) {
            $fid = $_GET['new_fid'];
        }else {
            $fid = 1;
        }

        header_redirect("./links.php?fid=$fid");

    }elseif (bh_session_check_perm(USER_PERM_LINKS_MODERATE, 0) && $_GET['action'] == "folderdel") {

        $folders = links_folders_get(bh_session_check_perm(USER_PERM_LINKS_MODERATE, 0));
        if (count(links_get_subfolders($fid, $folders)) == 0) links_folder_delete($fid);

        if (isset($_GET['new_fid']) && is_numeric($_GET['new_fid'])) {
            $fid = $_GET['new_fid'];
        }else {
            $fid = 1;
        }

        header_redirect("./links.php?fid=$fid");

    }elseif ($_GET['action'] == "go") {

        links_click($_GET['lid']);
        exit;
    }
}

$viewmode = LINKS_VIEW_HIERARCHICAL;

if (isset($_GET['viewmode']) && is_numeric($_GET['viewmode'])) {

    if ($_GET['viewmode'] == LINKS_VIEW_LIST) {

        $viewmode = LINKS_VIEW_LIST;

    }else {

        $viewmode = LINKS_VIEW_HIERARCHICAL;
    }
}

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = ($_GET['page'] > 0) ? $_GET['page'] : 1;
}else {
    $page = 1;
}

$start = floor($page - 1) * 20;

if ($start < 0) $start = 0;

html_draw_top("robots=noindex,nofollow");

echo "<h1>{$lang['links']}</h1>\n";

if ($viewmode == LINKS_VIEW_HIERARCHICAL) {

    echo "<div align=\"right\">{$lang['viewmode']}: ";
    echo "<a href=\"links.php?webtag=$webtag&amp;fid=$fid&amp;viewmode=0\"><b>{$lang['hierarchical']}</b></a> | ";
    echo "<a href=\"links.php?webtag=$webtag&amp;fid=$fid&amp;viewmode=1\">{$lang['list']}</a></div>\n";

}else {

    echo "<div align=\"right\">{$lang['viewmode']}: ";
    echo "<a href=\"links.php?webtag=$webtag&amp;fid=$fid&amp;viewmode=0\">{$lang['hierarchical']}</a> | ";
    echo "<a href=\"links.php?webtag=$webtag&amp;fid=$fid&amp;viewmode=1\"><b>{$lang['list']}</b></a></div>\n";
}

// work out where we are in the folder hierarchy and display links to all the higher levels

if ($viewmode == LINKS_VIEW_HIERARCHICAL) {

    echo "<div align=\"center\">\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"65%\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <h2>" . links_display_folder_path($fid, $folders) . "</h2>\n";

    if ($folders[$fid]['VISIBLE'] == "N") echo "<p class=\"threadtime\">{$lang['folderhidden']}. <a href=\"links.php?webtag=$webtag&amp;fid=$fid&amp;action=foldershow\">[{$lang['unhide']}]</a></p>";

    $subfolders = links_get_subfolders($fid, $folders);

    $new_folder_link = bh_session_get_value('UID') ? "[<a href=\"links_add.php?webtag=$webtag&amp;mode=folder&amp;fid=$fid\">{$lang['newfolder']}</a>]" : "";

    if (count($subfolders) == 0) {

        echo "        <p><span class=\"threadtime\">{$lang['nosubfolders']}. $new_folder_link</span></p>\n";

    }else {

        if (count($subfolders) == 1) {
            echo "        <p><span class=\"threadtime\">{$lang['1subfolder']}: $new_folder_link</span></p>\n";
        }else {
            echo "        <p><span class=\"threadtime\">" . count($subfolders) . " {$lang['subfoldersinthiscategory']}: $new_folder_link</span></p>\n";
        }

        echo "          <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
        echo "            <tr>\n";
        echo "              <td align=\"left\">\n";
        echo "                <table class=\"box\" width=\"100%\">\n";
        echo "                  <tr>\n";
        echo "                    <td align=\"left\" class=\"posthead\">\n";
        echo "                      <table width=\"100%\">\n";
        echo "                        <tr>\n";
        echo "                          <td align=\"left\" class=\"subhead\">{$lang['folders']}</td>";
        echo "                        </tr>\n";
        echo "                      </table>\n";
        echo "                      <div class=\"links_folder_list\">\n";
        echo "                        <table>\n";

        while (list($key, $val) = each($subfolders)) {

            echo "                          <tr>\n";
            echo "                            <td class=\"postbody\">\n";
            echo "                              <img src=\"" . style_image("folder.png") . "\" alt=\"{$lang['folder']}\" title=\"{$lang['folder']}\" /></td><td align=\"left\" class=\"postbody\"><a href=\"links.php?webtag=$webtag&amp;fid=$val\""; if ($folders[$val]['VISIBLE'] == "N") echo "class=\"link_hidden\""; echo ">{$folders[$val]['NAME']}</a>";

            if (bh_session_check_perm(USER_PERM_LINKS_MODERATE, 0) && $folders[$val]['VISIBLE'] == "Y") {

                echo "&nbsp;<a href=\"links.php?webtag=$webtag&amp;fid=$val&amp;action=folderhide&amp;new_fid=$fid\" class=\"threadtime\">[{$lang['hide']}]</a>\n";

            }elseif (bh_session_check_perm(USER_PERM_LINKS_MODERATE, 0) && $folders[$val]['VISIBLE'] == "N") {

                echo "&nbsp;<a href=\"links.php?webtag=$webtag&amp;fid=$val&amp;action=foldershow&amp;new_fid=$fid\" class=\"threadtime\">[{$lang['unhide']}]</a>\n";
            }

            if (bh_session_check_perm(USER_PERM_LINKS_MODERATE, 0) && count(links_get_subfolders($val, $folders)) == 0) echo "<a href=\"links.php?webtag=$webtag&amp;fid=$val&amp;action=folderdel&amp;new_fid=$fid\" class=\"threadtime\">[{$lang['delete']}]</a>\n";

            echo "                            </td>\n";
            echo "                          </tr>\n";
        }

        echo "                        </table>\n";
        echo "                      </div>\n";
        echo "                    </td>\n";
        echo "                  </tr>\n";
        echo "                </table>\n";
        echo "              </td>\n";
        echo "            </tr>\n";

        if (bh_session_check_perm(USER_PERM_LINKS_MODERATE, 0)) {

            echo "            <tr>\n";
            echo "              <td>{$lang['linksdelexp']}</td>\n";
            echo "            </tr>\n";

        }else {

            echo "            <tr>\n";
            echo "              <td>&nbsp;</td>\n";
            echo "            </tr>\n";
        }

        echo "          </table>\n";
    }

    echo "      </td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</div>\n";

}else {

    echo "<h2>{$lang['listview']}</h2>\n";
    echo "<p><span class=\"threadtime\">{$lang['listviewcannotaddfolders']}</span></p>\n";
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

    if ($viewmode == LINKS_VIEW_HIERARCHICAL) {
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

    if ($viewmode == LINKS_VIEW_HIERARCHICAL) {
        $sort_dir = "ASC";
    }else {
        $sort_dir = "DESC";
    }
}

if ($viewmode == LINKS_VIEW_HIERARCHICAL) {
    $links = links_get_in_folder($fid, bh_session_check_perm(USER_PERM_LINKS_MODERATE, 0), $sort_by, $sort_dir, $start);
}else {
    $links = links_get_all(bh_session_check_perm(USER_PERM_LINKS_MODERATE, 0), $sort_by, $sort_dir, $start);
}

echo "<div align=\"center\">\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"65%\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table width=\"100%\">\n";
echo "                <tr>\n";

if ($sort_by == "TITLE" && $sort_dir == "ASC") {
    echo "                  <td align=\"left\" class=\"subhead\"><a href=\"links.php?webtag=$webtag&amp;fid=$fid&amp;viewmode=$viewmode&amp;page=$page&amp;sort_by=TITLE&amp;sort_dir=DESC\">{$lang['name']}</a>&nbsp;</td>\n";
}else {
    echo "                  <td align=\"left\" class=\"subhead\"><a href=\"links.php?webtag=$webtag&amp;fid=$fid&amp;viewmode=$viewmode&amp;page=$page&amp;sort_by=TITLE&amp;sort_dir=ASC\">{$lang['name']}</a>&nbsp;</td>\n";
}

if ($sort_by == "CREATED" && $sort_dir == "ASC") {
    echo "                  <td align=\"left\" class=\"subhead\"><a href=\"links.php?webtag=$webtag&amp;fid=$fid&amp;viewmode=$viewmode&amp;page=$page&amp;sort_by=CREATED&amp;sort_dir=DESC\">{$lang['date']}</a>&nbsp;</td>\n";
}else {
    echo "                  <td align=\"left\" class=\"subhead\"><a href=\"links.php?webtag=$webtag&amp;fid=$fid&amp;viewmode=$viewmode&amp;page=$page&amp;sort_by=CREATED&amp;sort_dir=ASC\">{$lang['date']}</a>&nbsp;</td>\n";
}

if ($sort_by == "RATING" && $sort_dir == "DESC") {
    echo "                  <td align=\"center\" class=\"subhead\"><a href=\"links.php?webtag=$webtag&amp;fid=$fid&amp;viewmode=$viewmode&amp;page=$page&amp;sort_by=RATING&amp;sort_dir=ASC\">{$lang['rating']}</a>&nbsp;</td>";
}else {
    echo "                  <td align=\"center\" class=\"subhead\"><a href=\"links.php?webtag=$webtag&amp;fid=$fid&amp;viewmode=$viewmode&amp;page=$page&amp;sort_by=RATING&amp;sort_dir=DESC\">{$lang['rating']}</a>&nbsp;</td>";
}

echo "                </tr>\n";

if (sizeof($links['links_array']) > 0 ) {

    foreach ($links['links_array'] as $key => $link) {

        if ($link['VISIBLE'] == "N") {

            echo "                <tr class=\"link_hidden\">\n";
            echo "                  <td align=\"left\" class=\"postbody\" valign=\"top\">&nbsp;<a href=\"links_detail.php?webtag=$webtag&amp;lid=$key&amp;fid=$fid&amp;page=$page\" class=\"link_hidden\">{$link['TITLE']}</a></td>\n";

        }else {

            echo "                <tr>\n";
            echo "                  <td align=\"left\" class=\"postbody\" valign=\"top\">&nbsp;<a href=\"links_detail.php?webtag=$webtag&amp;lid=$key&amp;fid=$fid&amp;page=$page\">{$link['TITLE']}</a></td>\n";
        }

        echo "                  <td align=\"left\" class=\"postbody\" valign=\"top\">", format_time($link['CREATED']), "</td>\n";

        if (isset($link['RATING']) && strlen($link['RATING']) > 0) {
            echo "                  <td align=\"center\" class=\"postbody\" valign=\"top\">", number_format($link['RATING'], 1, ".", ","), "</td>\n";
        }else {
            echo "                  <td align=\"center\" class=\"postbody\" valign=\"top\">&nbsp;</td>\n";
        }

        echo "                </tr>\n";
    }

}else {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" colspan=\"5\" class=\"postbody\">{$lang['nolinksinfolder']}</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"postbody\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" width=\"25%\"><img src=\"", style_image("ct.png"), "\" alt=\"\" /> <a href=\"links_add.php?webtag=$webtag&amp;mode=link&amp;fid=$fid\">{$lang['addlinkhere']}</a></td>\n";
echo "            <td width=\"50%\" align=\"center\">", page_links(get_request_uri(false), $start, $links['links_count'], 20), "</td>\n";
echo "            <td align=\"left\" width=\"25%\">&nbsp;</td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</div>\n";

html_draw_bottom();

?>