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

/* $Id: admin_forum_links.php,v 1.32 2007-01-04 18:22:22 decoyduck Exp $ */

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
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.

if (bh_session_user_banned()) {

    html_user_banned();
    exit;
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=admin.php%3Fpage%3D$request_uri");
}

// Load language file

$lang = load_language_file();

if (!(bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0))) {

    html_draw_top();
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;
}

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = ($_GET['page'] > 0) ? $_GET['page'] : 1;
}elseif (isset($_POST['page']) && is_numeric($_POST['page'])) {
    $page = ($_POST['page'] > 0) ? $_POST['page'] : 1;
}else {
    $page = 1;
}

$start = floor($page - 1) * 10;
if ($start < 0) $start = 0;

$error_html = "";
$add_success = "";
$del_success = "";
$edit_success = "";

if (isset($_POST['cancel']) || isset($_POST['delete'])) {

    unset($_POST['addlink'], $_POST['lid'], $_GET['lid']);
}

if (isset($_POST['delete'])) {

    if (isset($_POST['t_delete']) && is_array($_POST['t_delete'])) {

        foreach($_POST['t_delete'] as $lid => $delete_link) {
    
            if (($delete_link == "Y") && ($forum_link = forum_links_get_link($lid))) {

                if (forum_links_delete($lid)) {

                    admin_add_log_entry(DELETE_FORUM_LINKS, $forum_link['TITLE']);
                    $del_success = "<h2>{$lang['successfullyremovedselectedlinks']}</h2>\n";

                }else {
                    
                    $error_html.= "<h2>{$lang['failedtoremovelinks']}</h2>\n";
                }               
            }
        }
    }

}elseif (isset($_POST['addlinksubmit'])) {

    $valid = true;

    if (isset($_POST['t_title']) && strlen(trim(_stripslashes($_POST['t_title']))) > 0) {
        $t_title = trim(_stripslashes($_POST['t_title']));
    }else {
        $valid = false;
        $error_html.= "<h2>{$lang['youmustenteralinktitle']}</h2>\n";
    }

    if (isset($_POST['t_uri']) && strlen(trim(_stripslashes($_POST['t_uri']))) > 0) {

        $t_uri = trim(_stripslashes($_POST['t_uri']));

        if (preg_match("/^[a-z0-9]+:\/\//i", $t_uri) < 1) {

            $error_html.= "<h2>{$lang['alllinkurismuststartwithaschema']}</h2>\n";
            $valid = false;
        }

    }else {

        $t_uri = "";
    }

    if ($valid) {

        if (forum_links_add_link($t_title, $t_uri)) {

            admin_add_log_entry(ADD_FORUM_LINKS, array($t_title, $t_uri));
            $add_success = "<h2>{$lang['successfullyaddedlink']}</h2>\n";
            unset($t_title, $t_uri, $_POST['addlink']);
        
        }else {

            $error_html.= "<h2>{$lang['failedtoaddnewlink']}</h2>\n";
        }
    }

}elseif (isset($_POST['updatelinksubmit'])) {

    $valid = true;
    
    if (isset($_POST['lid']) && is_numeric($_POST['lid'])) {

        $lid = $_POST['lid'];
        
        if (isset($_POST['t_title']) && strlen(trim(_stripslashes($_POST['t_title']))) > 0) {
            $t_title = trim(_stripslashes($_POST['t_title']));
        }else {
            $valid = false;
            $error_html.= "<h2>{$lang['youmustenteralinktitle']}</h2>\n";
        }

        if (isset($_POST['t_uri']) && strlen(trim(_stripslashes($_POST['t_uri']))) > 0) {

            $t_uri = trim(_stripslashes($_POST['t_uri']));

            if (preg_match("/^[a-z0-9]+:\/\//i", $t_uri) < 1) {

                $error_html.= "<h2>{$lang['alllinkurismuststartwithaschema']}</h2>\n";
                $valid = false;
            }

        }else {

            $t_uri = "";
        }

        if (isset($_POST['t_old_title']) && strlen(trim(_stripslashes($_POST['t_old_title']))) > 0) {
            $t_old_title = trim(_stripslashes($_POST['t_old_title']));
        }else {
            $t_old_title = "";
        }

        if (isset($_POST['t_old_uri']) && strlen(trim(_stripslashes($_POST['t_old_uri']))) > 0) {
            $t_old_uri = trim(_stripslashes($_POST['t_old_uri']));
        }else {
            $t_old_uri = "";
        }

        if ($valid) {

            if (forum_links_update_link($lid, $t_title, $t_uri)) {

                admin_add_log_entry(EDIT_FORUM_LINKS, array($lid, $t_title, $t_uri, $t_old_title, $t_old_uri));
                $edit_success = "<h2>{$lang['successfullyeditedlink']}: $t_title</h2>\n";
                unset($lid, $t_title, $t_uri, $_POST['lid'], $_GET['lid']);
            
            }else {

                $error_html.= "<h2>{$lang['failedtoupdatelink']}</h2>\n";
            }
        }
    }

}elseif (isset($_POST['addlink'])) {

    $redirect = "./admin_forum_links.php?webtag=$webtag&page=$page&addlink=true";
    header_redirect($redirect);
    exit;
}

if (isset($_POST['move_up']) && is_array($_POST['move_up'])) {

    list($lid) = array_keys($_POST['move_up']);

    if (forum_links_move_up($lid)) {
        header_redirect("admin_forum_links.php?webtag=$webtag&page=$page");
    }
}

if (isset($_POST['move_down']) && is_array($_POST['move_down'])) {

    list($lid) = array_keys($_POST['move_down']);
    
    if (forum_links_move_down($lid)) {
        header_redirect("admin_forum_links.php?webtag=$webtag&page=$page");
    }
}

if (isset($_POST['move_up_disabled']) || isset($_POST['move_down_disabled'])) {
    header_redirect("admin_forum_links.php?webtag=$webtag&page=$page");
}

html_draw_top();

if (isset($_GET['addlink']) || isset($_POST['addlink'])) {

    echo "<h1>{$lang['admin']} &raquo; ", forum_get_setting('forum_name', false, 'A Beehive Forum'), " &raquo; {$lang['forumlinks']} &raquo; {$lang['addnewforumlink']}</h1>\n";

    if (isset($error_html) && strlen(trim($error_html)) > 0) {
        echo $error_html;
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "  <form name=\"thread_options\" action=\"admin_forum_links.php\" method=\"post\" target=\"_self\">\n";
    echo "  ", form_input_hidden('webtag', $webtag), "\n";
    echo "  ", form_input_hidden('addlink', 'true'), "\n";
    echo "  ", form_input_hidden('page', $page), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\">{$lang['addnewforumlink']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">{$lang['forumlinktitle']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_text("t_title", (isset($_POST['t_title']) ? _htmlentities(_stripslashes($_POST['t_title'])) : ""), 40, 32), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">{$lang['forumlinklocation']}:</td>\n";
    echo "                        <td align=\"left\" nowrap=\"nowrap\">", form_input_text("t_uri", (isset($_POST['t_uri']) ? _htmlentities(_stripslashes($_POST['t_uri'])) : ""), 40, 255), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                      </tr>\n";
    echo "                    </table>\n";
    echo "                  </td>\n";
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
    echo "      <td align=\"center\">", form_submit("addlinksubmit", $lang['add']), " &nbsp;", form_submit("cancel", $lang['cancel']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  </form>\n";

}elseif (isset($_POST['lid']) || isset($_GET['lid'])) {

    if (isset($_POST['lid']) && is_numeric($_POST['lid'])) {

        $lid = $_POST['lid'];

    }elseif (isset($_GET['lid']) && is_numeric($_GET['lid'])) {

        $lid = $_GET['lid'];

    }else {

        echo "<h1>{$lang['admin']} &raquo; ", forum_get_setting('forum_name', false, 'A Beehive Forum'), " &raquo; {$lang['forumlinks']} &raquo; {$lang['editlink']}</h1>\n";
        echo "<h2>{$lang['invalidlinkidorlinknotfound']}</h2>\n";
        html_draw_bottom();
        exit;
    }

    if (!$forum_link = forum_links_get_link($lid)) {

        echo "<h1>{$lang['admin']} &raquo; ", forum_get_setting('forum_name', false, 'A Beehive Forum'), " &raquo; {$lang['forumlinks']} &raquo; {$lang['editlink']}</h1>\n";
        echo "<h2>{$lang['invalidlinkidorlinknotfound']}</h2>\n";
        html_draw_bottom();
        exit;
    }
    
    echo "<h1>{$lang['admin']} &raquo; ", forum_get_setting('forum_name', false, 'A Beehive Forum'), " &raquo; {$lang['forumlinks']} &raquo; {$lang['editlink']} &raquo; {$forum_link['TITLE']}</h1>\n";

    if (isset($error_html) && strlen(trim($error_html)) > 0) {
        echo $error_html;
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "  <form name=\"thread_options\" action=\"admin_forum_links.php\" method=\"post\" target=\"_self\">\n";
    echo "  ", form_input_hidden('webtag', $webtag), "\n";
    echo "  ", form_input_hidden('lid', $lid), "\n";
    echo "  ", form_input_hidden("t_delete[$lid]", "Y"), "\n";
    echo "  ", form_input_hidden('page', $page), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\">{$lang['editlink']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">{$lang['forumlinktitle']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_text("t_title", (isset($_POST['t_title']) ? _htmlentities(_stripslashes($_POST['t_title'])) : (isset($forum_link['TITLE']) ? _htmlentities($forum_link['TITLE']) : "")), 40, 32), form_input_hidden('t_old_title', $forum_link['TITLE']), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"200\" class=\"posthead\">{$lang['forumlinklocation']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_text("t_uri", (isset($_POST['t_uri']) ? _htmlentities(_stripslashes($_POST['t_uri'])) : (isset($forum_link['URI']) ? _htmlentities($forum_link['URI']) : "")), 40, 255), form_input_hidden('t_old_uri', $forum_link['URI']), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                      </tr>\n";
    echo "                    </table>\n";
    echo "                  </td>\n";
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
    echo "      <td align=\"center\">", form_submit("updatelinksubmit", $lang['save']), " &nbsp;", form_submit("delete", $lang['delete']), " &nbsp;",form_submit("cancel", $lang['cancel']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  </form>\n";

}else {

    echo "<h1>{$lang['admin']} &raquo; ", forum_get_setting('forum_name', false, 'A Beehive Forum'), " &raquo; {$lang['editforumlinks']}</h1>\n";

    if (isset($error_html) && strlen(trim($error_html)) > 0) {
        echo $error_html;
    }

    if (isset($add_success) && strlen(trim($add_success)) > 0) echo $add_success;
    if (isset($del_success) && strlen(trim($del_success)) > 0) echo $del_success;
    if (isset($edit_success) && strlen(trim($edit_success)) > 0) echo $edit_success;

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "<form method=\"post\" action=\"admin_forum_links.php\">\n";
    echo "  ", form_input_hidden('webtag', $webtag), "\n";
    echo "  ", form_input_hidden('page', $page), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">{$lang['editforumlinks_exp']}</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  <br />\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\">&nbsp;</td>\n";
    echo "                  <td align=\"left\" class=\"subhead\">&nbsp;</td>\n";
    echo "                  <td align=\"left\" class=\"subhead\">{$lang['name']}</td>\n";
    echo "                </tr>\n";

    $forum_links_array = forum_links_get_links_by_page($start);

    if (sizeof($forum_links_array['forum_links_array']) > 0) {

        $link_index = $start;

        foreach($forum_links_array['forum_links_array'] as $key => $forum_link) {

            $link_index++;

            echo "                <tr>\n";
            echo "                  <td valign=\"top\" align=\"center\" width=\"25\">", form_checkbox("t_delete[{$forum_link['LID']}]", "Y", false), "</td>\n";

            if ($forum_links_array['forum_links_count'] == 1) {

                echo "                  <td align=\"center\" width=\"40\" nowrap=\"nowrap\">", form_submit_image('move_up.png', "move_up_disabled", "Move Up", "title=\"Move Up\" onclick=\"return false\"", "move_up_ctrl_disabled"), form_submit_image('move_down.png', "move_down_disabled", "Move Down", "title=\"Move Down\" onclick=\"return false\"", "move_down_ctrl_disabled"), "</td>\n";

            }elseif ($link_index == $forum_links_array['forum_links_count']) {

                echo "                  <td align=\"center\" width=\"40\" nowrap=\"nowrap\">", form_submit_image('move_up.png', "move_up[{$forum_link['LID']}]", "Move Up", "title=\"Move Up\"", "move_up_ctrl"), form_submit_image('move_down.png', "move_down_disabled", "Move Down", "title=\"Move Down\" onclick=\"return false\"", "move_down_ctrl_disabled"), "</td>\n";

            }elseif ($link_index > 1) {

                echo "                  <td align=\"center\" width=\"40\" nowrap=\"nowrap\">", form_submit_image('move_up.png', "move_up[{$forum_link['LID']}]", "Move Up", "title=\"Move Up\"", "move_up_ctrl"), form_submit_image('move_down.png', "move_down[{$forum_link['LID']}]", "Move Down", "title=\"Move Down\"", "move_down_ctrl"), "</td>\n";

            }else {

                echo "                  <td align=\"center\" width=\"40\" nowrap=\"nowrap\">", form_submit_image('move_up.png', "move_up_disabled", "Move Up", "title=\"Move Up\" onclick=\"return false\"", "move_up_ctrl_disabled"), form_submit_image('move_down.png', "move_down[{$forum_link['LID']}]", "Move Down", "title=\"Move Down\"", "move_down_ctrl"), "</td>\n";
            }

            echo "                  <td align=\"left\"><a href=\"admin_forum_links.php?webtag=$webtag&amp;page=$page&amp;lid={$forum_link['LID']}\">{$forum_link['TITLE']}</a></td>\n";
            echo "                </tr>\n";
        }

    }else {

        echo "                  <td align=\"left\">&nbsp;</td>\n";
        echo "                  <td align=\"left\" colspan=\"3\">{$lang['noexistingforumlinksfound']}</td>\n";
        echo "                </tr>\n";
    }

    echo "                <tr>\n";
    echo "                  <td align=\"left\">&nbsp;</td>\n";
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
    echo "      <td class=\"postbody\" align=\"center\">", page_links(get_request_uri(false), $start, $forum_links_array['forum_links_count'], 10), "</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_submit("addlink", $lang['addnew']), "&nbsp;", form_submit("delete", $lang['deleteselected']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</form>\n";
    echo "</div>\n";
}

html_draw_bottom();

?>