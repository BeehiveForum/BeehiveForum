<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
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

// Bootstrap
require_once 'boot.php';

// Required includes
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'folder.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'header.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'links.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
require_once BH_INCLUDE_PATH . 'word_filter.inc.php';
// End Required includes

// Check links section is enabled
if (!forum_get_setting('show_links', 'Y')) {
    html_draw_error(gettext("You may not access this section."));
}

$folders = links_folders_get(!session::check_perm(USER_PERM_LINKS_MODERATE, 0));

if (isset($_GET['fid']) && isset($folders[$_GET['fid']])) {

    $fid = $_GET['fid'];

} else if (is_array($folders)) {

    list($fid) = array_keys($folders);

} else {

    links_create_top_folder(gettext("Top Level"));
    header_redirect("links.php?webtag=$webtag&fid=1");
}

if (isset($_GET['action'])) {

    if (session::check_perm(USER_PERM_LINKS_MODERATE, 0) && $_GET['action'] == "folderhide") {

        links_folder_change_visibility($fid, false);

        if (isset($_GET['new_fid']) && is_numeric($_GET['new_fid'])) {
            $fid = intval($_GET['new_fid']);
        } else {
            $fid = 1;
        }

        header_redirect("links.php?webtag=$webtag&fid=$fid");

    } else if (session::check_perm(USER_PERM_LINKS_MODERATE, 0) && $_GET['action'] == "foldershow") {

        links_folder_change_visibility($fid, true);

        if (isset($_GET['new_fid']) && is_numeric($_GET['new_fid'])) {
            $fid = intval($_GET['new_fid']);
        } else {
            $fid = 1;
        }

        header_redirect("links.php?webtag=$webtag&fid=$fid");

    } else if (session::check_perm(USER_PERM_LINKS_MODERATE, 0) && $_GET['action'] == "folderdel") {

        $folders = links_folders_get(!session::check_perm(USER_PERM_LINKS_MODERATE, 0));
        if (count(links_get_subfolders($fid, $folders)) == 0) links_folder_delete($fid);

        if (isset($_GET['new_fid']) && is_numeric($_GET['new_fid'])) {
            $fid = intval($_GET['new_fid']);
        } else {
            $fid = 1;
        }

        header_redirect("links.php?webtag=$webtag&fid=$fid");

    } else if ($_GET['action'] == "go" && isset($_GET['lid'])) {

        links_click($_GET['lid']);
        exit;
    }
}

$viewmode = LINKS_VIEW_HIERARCHICAL;

if (isset($_GET['viewmode']) && is_numeric($_GET['viewmode'])) {

    if ($_GET['viewmode'] == LINKS_VIEW_LIST) {

        $viewmode = LINKS_VIEW_LIST;

    } else {

        $viewmode = LINKS_VIEW_HIERARCHICAL;
    }
}

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = ($_GET['page'] > 0) ? intval($_GET['page']) : 1;
} else {
    $page = 1;
}

$page_title = links_get_folder_page_title($fid, $folders);

html_draw_top(
    array(
        'title' => $page_title,
        'class' => 'window_title'
    )
);

echo "<h1>", links_get_folder_path_links($fid, $folders), "</h1>\n";

if (isset($_GET['link_added']) && strlen(trim($_GET['link_added'])) > 0) {

    $link_added = $_GET['link_added'];
    html_display_success_msg(sprintf(gettext("Successfully added link '%s'"), htmlentities_array($link_added)), '85%', 'center');

} else if (isset($_GET['folder_added']) && strlen(trim($_GET['folder_added'])) > 0) {

    $folder_added = $_GET['folder_added'];
    html_display_success_msg(sprintf(gettext("Successfully added link '%s'"), htmlentities_array($folder_added)), '85%', 'center');
}

// work out where we are in the folder hierarchy and display links to all the higher levels
if ($viewmode == LINKS_VIEW_HIERARCHICAL) {

    echo "<div align=\"right\">", gettext("View Mode"), ": ";
    echo "  <a href=\"links.php?webtag=$webtag&amp;fid=$fid&amp;viewmode=0\"><b>", gettext("Hierarchical"), "</b></a> | ";
    echo "  <a href=\"links.php?webtag=$webtag&amp;fid=$fid&amp;viewmode=1\">", gettext("List"), "</a>\n";
    echo "</div>\n";
    echo "<br />";
    echo "<div align=\"center\">\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"85%\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";

    if ($folders[$fid]['VISIBLE'] == "N") echo "<p class=\"threadtime\">", gettext("This folder is hidden"), ". <a href=\"links.php?webtag=$webtag&amp;fid=$fid&amp;action=foldershow\">[", gettext("unhide"), "]</a></p>";

    $subfolders = links_get_subfolders($fid, $folders);

    $links_add_folder = LINKS_ADD_FOLDER;

    if (sizeof($subfolders) > 0) {

        echo "          <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
        echo "            <tr>\n";
        echo "              <td align=\"left\">\n";
        echo "                <table class=\"box\" width=\"100%\">\n";
        echo "                  <tr>\n";
        echo "                    <td align=\"left\" class=\"posthead\">\n";
        echo "                      <table width=\"100%\">\n";
        echo "                        <tr>\n";
        echo "                          <td align=\"left\" class=\"subhead\">", gettext("Folders"), "</td>";
        echo "                        </tr>\n";
        echo "                      </table>\n";
        echo "                      <div class=\"links_folder_list\">\n";
        echo "                        <table>\n";

        foreach ($subfolders as $key => $folder) {

            echo "                          <tr>\n";
            echo "                            <td class=\"postbody\">", html_style_image('folder', gettext("Folder")), "</td>\n";
            echo "                            <td align=\"left\" class=\"postbody\"><a href=\"links.php?webtag=$webtag&amp;fid=$folder\" class=\"", ($folders[$folder]['VISIBLE'] == "N") ? "link_hidden" : "", "\">", word_filter_add_ob_tags($folders[$folder]['NAME'], true), "</a>";

            if (session::check_perm(USER_PERM_LINKS_MODERATE, 0) && $folders[$folder]['VISIBLE'] == "Y") {

                echo "&nbsp;<a href=\"links.php?webtag=$webtag&amp;fid=$folder&amp;action=folderhide&amp;new_fid=$fid\" class=\"threadtime\">[", gettext("hide"), "]</a>\n";

            } else if (session::check_perm(USER_PERM_LINKS_MODERATE, 0) && $folders[$folder]['VISIBLE'] == "N") {

                echo "&nbsp;<a href=\"links.php?webtag=$webtag&amp;fid=$folder&amp;action=foldershow&amp;new_fid=$fid\" class=\"threadtime\">[", gettext("unhide"), "]</a>\n";
            }

            if (session::check_perm(USER_PERM_LINKS_MODERATE, 0)) {

                echo "<a href=\"links_folder_edit.php?webtag=$webtag&amp;fid=$folder\" class=\"threadtime\">[", gettext("Edit"), "]</a>\n";

                if (count(links_get_subfolders($folder, $folders)) == 0) {

                    echo "<a href=\"links.php?webtag=$webtag&amp;fid=$folder&amp;action=folderdel&amp;new_fid=$fid\" class=\"threadtime\">[", gettext("Delete"), "]</a>\n";
                }
            }

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

        if (session::check_perm(USER_PERM_LINKS_MODERATE, 0)) {

            echo "            <tr>\n";
            echo "              <td>&nbsp;</td>\n";
            echo "            </tr>\n";
            echo "            <tr>\n";
            echo "              <td>\n";

            html_display_warning_msg(gettext("Entries in a deleted folder will be moved to the parent folder. Only folders which do not contain subfolders may be deleted."), '100%', 'left');

            echo "              </td>\n";
            echo "            </tr>\n";
            echo "            <tr>\n";
            echo "              <td>&nbsp;</td>\n";
            echo "            </tr>\n";

        } else {

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

} else {

    echo "<div align=\"right\">", gettext("View Mode"), ": ";
    echo "  <a href=\"links.php?webtag=$webtag&amp;fid=$fid&amp;viewmode=0\">", gettext("Hierarchical"), "</a> | ";
    echo "  <a href=\"links.php?webtag=$webtag&amp;fid=$fid&amp;viewmode=1\"><b>", gettext("List"), "</b></a>\n";
    echo "</div>\n";
    echo "<br />";
    echo "<div align=\"center\">\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"85%\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <h2>", gettext("List View"), "</h2>\n";
    echo "        <p><span class=\"threadtime\">", gettext("Cannot add folders in this view. Showing 20 entries at a time."), "</span></p>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</div>\n";
}

if (isset($_GET['sort_by'])) {

    if ($_GET['sort_by'] == "TITLE") {
        $sort_by = "TITLE";
    } else if ($_GET['sort_by'] == "DESCRIPTION") {
        $sort_by = "DESCRIPTION";
    } else if ($_GET['sort_by'] == "NICKNAME") {
        $sort_by = "NICKNAME";
    } else if ($_GET['sort_by'] == "CREATED") {
        $sort_by = "CREATED";
    } else if ($_GET['sort_by'] == "CLICKS") {
        $sort_by = "CLICKS";
    } else if ($_GET['sort_by'] == "RATING") {
        $sort_by = "RATING";
    } else {
        $sort_by = "TITLE";
    }

} else {

    if ($viewmode == LINKS_VIEW_HIERARCHICAL) {
        $sort_by = "TITLE";
    } else {
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

    if ($viewmode == LINKS_VIEW_HIERARCHICAL) {
        $sort_dir = "ASC";
    } else {
        $sort_dir = "DESC";
    }
}

if ($viewmode == LINKS_VIEW_HIERARCHICAL) {
    $links = links_get_in_folder($fid, session::check_perm(USER_PERM_LINKS_MODERATE, 0), $sort_by, $sort_dir, $page);
} else {
    $links = links_get_all(session::check_perm(USER_PERM_LINKS_MODERATE, 0), $sort_by, $sort_dir, $page);
}

if (sizeof($links['links_array']) < 1) {
    html_display_warning_msg(gettext("No links in this folder."), '85%', 'center');
}

echo "<div align=\"center\">\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"85%\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table width=\"100%\">\n";
echo "                <tr>\n";

if ($sort_by == "TITLE" && $sort_dir == "ASC") {
    echo "                  <td align=\"left\" class=\"subhead\"><a href=\"links.php?webtag=$webtag&amp;fid=$fid&amp;viewmode=$viewmode&amp;page=$page&amp;sort_by=TITLE&amp;sort_dir=DESC\">", gettext("Name"), "</a>&nbsp;</td>\n";
} else {
    echo "                  <td align=\"left\" class=\"subhead\"><a href=\"links.php?webtag=$webtag&amp;fid=$fid&amp;viewmode=$viewmode&amp;page=$page&amp;sort_by=TITLE&amp;sort_dir=ASC\">", gettext("Name"), "</a>&nbsp;</td>\n";
}

if ($sort_by == "CREATED" && $sort_dir == "ASC") {
    echo "                  <td align=\"center\" class=\"subhead\" width=\"150\"><a href=\"links.php?webtag=$webtag&amp;fid=$fid&amp;viewmode=$viewmode&amp;page=$page&amp;sort_by=CREATED&amp;sort_dir=DESC\">", gettext("Date"), "</a>&nbsp;</td>\n";
} else {
    echo "                  <td align=\"center\" class=\"subhead\" width=\"150\"><a href=\"links.php?webtag=$webtag&amp;fid=$fid&amp;viewmode=$viewmode&amp;page=$page&amp;sort_by=CREATED&amp;sort_dir=ASC\">", gettext("Date"), "</a>&nbsp;</td>\n";
}

if ($sort_by == "RATING" && $sort_dir == "DESC") {
    echo "                  <td align=\"center\" class=\"subhead\" width=\"100\"><a href=\"links.php?webtag=$webtag&amp;fid=$fid&amp;viewmode=$viewmode&amp;page=$page&amp;sort_by=RATING&amp;sort_dir=ASC\">", gettext("Rating"), "</a>&nbsp;</td>";
} else {
    echo "                  <td align=\"center\" class=\"subhead\" width=\"100\"><a href=\"links.php?webtag=$webtag&amp;fid=$fid&amp;viewmode=$viewmode&amp;page=$page&amp;sort_by=RATING&amp;sort_dir=DESC\">", gettext("Rating"), "</a>&nbsp;</td>";
}

echo "                </tr>\n";

if (sizeof($links['links_array']) > 0) {

    foreach ($links['links_array'] as $key => $link) {

        if ($link['VISIBLE'] == "N") {

            echo "                <tr class=\"link_hidden\">\n";
            echo "                  <td align=\"left\" class=\"postbody\" valign=\"top\">&nbsp;<a href=\"links_detail.php?webtag=$webtag&amp;lid=$key&amp;fid=$fid\" class=\"link_hidden\">", word_filter_add_ob_tags($link['TITLE'], true), "</a></td>\n";

        } else {

            echo "                <tr>\n";
            echo "                  <td align=\"left\" class=\"postbody\" valign=\"top\">&nbsp;<a href=\"links_detail.php?webtag=$webtag&amp;lid=$key&amp;fid=$fid\">", word_filter_add_ob_tags($link['TITLE'], true), "</a></td>\n";
        }

        echo "                  <td align=\"center\" class=\"postbody\" valign=\"top\">", format_date_time($link['CREATED']), "</td>\n";

        if (isset($link['RATING']) && strlen($link['RATING']) > 0) {
            echo "                  <td align=\"center\" class=\"postbody\" valign=\"top\">", format_number($link['RATING'], 1), "</td>\n";
        } else {
            echo "                  <td align=\"center\" class=\"postbody\" valign=\"top\">&nbsp;</td>\n";
        }

        echo "                </tr>\n";
    }
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
echo "            <td align=\"left\" width=\"33%\">\n";
echo "              ", html_style_image('link_add'), " <a href=\"links_add.php?webtag=$webtag&amp;mode=", LINKS_ADD_LINK, "&amp;fid=$fid\">", gettext("Add link here"), "</a><br />\n";

if ($viewmode == LINKS_VIEW_HIERARCHICAL) {
    echo "              ", html_style_image('folder_add'), " <a href=\"links_add.php?webtag=$webtag&amp;mode=", LINKS_ADD_FOLDER, "&amp;fid=$fid\">", gettext("New Folder"), "</a>\n";
}

echo "            </td>\n";
echo "            <td align=\"center\" valign=\"top\" width=\"33%\">";

html_page_links("links.php?webtag=$webtag&fid=$fid&viewmode=$viewmode&sort_by=$sort_by&sort_dir=$sort_dir", $page, $links['links_count'], 20);

echo "            </td>\n";
echo "            <td align=\"right\" valign=\"top\" width=\"33%\">&nbsp;</td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</div>\n";

html_draw_bottom();