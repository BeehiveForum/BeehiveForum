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

/* $Id: admin_forums.php,v 1.72 2007-06-29 17:53:26 decoyduck Exp $ */

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

// Fetch Forum Settings

$forum_settings = forum_get_settings();

// Fetch Global Forum Settings

$forum_global_settings = forum_get_global_settings();

include_once(BH_INCLUDE_PATH. "admin.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "myforums.inc.php");
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

// Check we have a webtag

$webtag = get_webtag($webtag_search);

// Load language file

$lang = load_language_file();

if (!(bh_session_check_perm(USER_PERM_FORUM_TOOLS, 0))) {

    html_draw_top();
    html_error_msg($lang['accessdeniedexp']);
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

    unset($_POST['addforum'], $_GET['addforum'], $_POST['fid'], $_GET['fid']);
}

if (isset($_POST['delete'])) {

    if (isset($_POST['t_delete']) && is_array($_POST['t_delete'])) {

        foreach($_POST['t_delete'] as $forum_fid => $delete_forum) {
    
            if (($delete_forum == "Y") && ($forum_name = forum_get_name($forum_fid))) {

                $forum_delete_array[$forum_fid] = "{$forum_name}";
            }
        }

        html_draw_top();

        echo "<h1>{$lang['admin']} &raquo; {$lang['manageforums']}</h1>\n";
        echo "<br />\n";
        echo "<div align=\"center\">\n";
        echo "<form name=\"f_folders\" action=\"admin_forums.php\" method=\"post\">\n";
        echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
        echo "  ", form_input_hidden('page', _htmlentities($page)), "\n";

        foreach ($forum_delete_array as $forum_fid => $forum_name) {

            echo "  ", form_input_hidden("t_delete[$forum_fid]", "Y"), "\n";
        }

        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
        echo "    <tr>\n";
        echo "      <td align=\"left\">\n";
        echo "        <table class=\"box\" width=\"100%\">\n";
        echo "          <tr>\n";
        echo "            <td align=\"left\" class=\"posthead\">\n";
        echo "              <table class=\"posthead\" width=\"100%\">\n";
        echo "                <tr>\n";
        echo "                  <td align=\"left\" class=\"subhead\">{$lang['warning_caps']}</td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td align=\"center\">\n";
        echo "                    <table class=\"posthead\" width=\"90%\">\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\" colspan=\"2\">{$lang['forumdeleteconfirmation']}</td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\"><ul><li><b>", implode("</b></li><li><b>", $forum_delete_array), "</b></li></ul></td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\" colspan=\"2\">{$lang['forumdeletewarning']}</td>\n";
        echo "                      </tr>\n";
        echo "                    </table>\n";
        echo "                  </td>\n";
        echo "                </tr>\n";
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
        echo "      <td align=\"center\">", form_submit("t_confirm_delete", $lang['delete']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</td>\n";
        echo "    </tr>\n";
        echo "  </table>\n";
        echo "</form>\n";
        echo "</div>\n";

        html_draw_bottom();
        exit;
    }

}elseif (isset($_POST['t_confirm_delete'])) {

    if (isset($_POST['t_delete']) && is_array($_POST['t_delete'])) {

        foreach($_POST['t_delete'] as $forum_fid => $delete_forum) {
    
            if (($delete_forum == "Y") && ($forum_name = forum_get_name($forum_fid))) {

                if (forum_delete($forum_fid)) {

                    $del_success.= sprintf("<h2>{$lang['successfullydeletedforum']}</h2>", $forum_name);
                
                }else {

                    $error_html.= sprintf("<h2>{$lang['failedtodeleteforum']}</h2>", $forum_name);
                }
            }
        }
    }

}elseif (isset($_GET['default']) && is_numeric($_GET['default'])) {

    $fid = $_GET['default'];
    forum_update_default($fid);

}elseif (isset($_POST['addforumsubmit'])) {

    $valid = true;
    
    if (isset($_POST['t_webtag']) && strlen(trim(_stripslashes($_POST['t_webtag']))) > 0) {
        
        $t_webtag = strtoupper(trim(_stripslashes($_POST['t_webtag'])));

        if (!preg_match("/^[A-Z0-9_]+$/", $t_webtag)) {

            $error_html.= "<h2>{$lang['webtaginvalidchars']}</h2>\n";
            $valid = false;
        }

    }else {

        $error_html.= "<h2>{$lang['mustsupplyforumwebtag']}</h2>\n";
        $valid = false;
    }

    if (isset($_POST['t_name']) && strlen(trim(_stripslashes($_POST['t_name']))) > 0) {
        $t_name = trim(_stripslashes($_POST['t_name']));
    }else {
        $error_html.= "<h2>{$lang['mustsupplyforumname']}</h2>\n";
        $valid = false;
    }

    if (isset($_POST['t_database']) && strlen(trim(_stripslashes($_POST['t_database']))) > 0) {
        
        $t_database = $_POST['t_database'];

        if (!preg_match("/^[A-Z0-9_]+$/i", $t_database)) {

            $error_html.= "<h2>{$lang['databasenameinvalidchars']}</h2>\n";
            $valid = false;
        }

    }else {

        $error_html.= "<h2>{$lang['mustsupplyforumdatabasename']}</h2>\n";
        $valid = false;
    }

    if (isset($_POST['t_access']) && is_numeric($_POST['t_access'])) {
        $t_access = $_POST['t_access'];
    }else {
        $error_html.= "<h2>{$lang['mustsupplyforumaccesslevel']}</h2>\n";
        $valid = false;
    }

    if (isset($_POST['t_default']) && $_POST['t_default'] == 'Y') {
        $t_default = 1;
    }else {
        $t_default = 0;
    }

    if ($valid) {

        if ($new_fid = forum_create($t_webtag, $t_name, $t_database, $t_access, $error_str)) {

            if ($t_default == 1) forum_update_default($new_fid);
            $add_success.= sprintf("<h2>{$lang['successfullycreatedforum']}</h2>", $t_webtag);
            unset($_POST['addforum'], $_GET['addforum']);

        }else {

            $error_html.= sprintf("<h2>{$lang['failedtocreateforum']}</h2>", $t_webtag);
            $error_html.= $error_str;

            unset($_POST['addnew'], $_GET['addnew']);
        }
    }

}elseif (isset($_POST['updateforumsubmit'])) {

    $valid = true;

    if (isset($_POST['fid']) && is_numeric($_POST['fid'])) {
        $fid = $_POST['fid'];
    }else {
        $error_html.= "<h2>{$lang['invalidforumidorforumnotfound']}</h2>\n";
        $valid = false;
    }

    if ($valid && $forum_data = forum_get($fid)) {
    
        if (isset($_POST['t_name']) && strlen(trim(_stripslashes($_POST['t_name']))) > 0) {
            $t_name = trim(_stripslashes($_POST['t_name']));
        }else {
            $error_html.= "<h2>{$lang['mustsupplyforumname']}</h2>\n";
            $valid = false;
        }

        if (isset($_POST['t_access']) && is_numeric($_POST['t_access'])) {
            $t_access = $_POST['t_access'];
        }else {
            $error_html.= "<h2>{$lang['mustsupplyforumaccesslevel']}</h2>\n";
            $valid = false;
        }

        if (isset($_POST['t_default']) && $_POST['t_default'] == 'Y') {
            $t_default = 1;
        }else {
            $t_default = 0;
        }

        if ($valid) {

            if (forum_update($fid, $t_name, $t_access)) {

                if ($forum_data['DEFAULT_FORUM'] == 1 && $t_default == 0) {
                    forum_update_default(0);
                }elseif ($t_default == 1) {
                    forum_update_default($fid);
                }

                $error_html = sprintf("<h2>{$lang['successfullyupdatedforum']}</h2>", $forum_data['WEBTAG']);

            }else {

                $error_html = sprintf("<h2>{$lang['failedtoupdateforum']}</h2>", $forum_data['WEBTAG']);
            }
        }

    }else {

        $error_html.= "<h2>{$lang['invalidforumidorforumnotfound']}</h2>\n";
        $valid = false;
    }

}elseif (isset($_POST['addforum'])) {

    $redirect = "./admin_forums.php?webtag=$webtag&page=$page&addforum=true";
    header_redirect($redirect);
    exit;

}elseif (isset($_POST['changepermissions']) && is_array($_POST['changepermissions'])) {
    
    list($forum_webtag) = array_keys($_POST['changepermissions']);

    $redirect_uri = "admin_forum_access.php?webtag=$forum_webtag&";

    if (isset($_POST['fid']) && is_numeric($_POST['fid'])) {
        $redirect_uri.= "ret=". rawurlencode("admin_forums.php?webtag=$webtag&fid={$_POST['fid']}");
    }elseif (isset($_GET['fid']) && is_numeric($_GET['fid'])) {
        $redirect_uri.= "ret=". rawurlencode("admin_forums.php?webtag=$webtag&fid={$_GET['fid']}");
    }

    header_redirect($redirect_uri);
    exit;

}elseif (isset($_POST['changepassword']) && is_array($_POST['changepassword'])) {

    list($forum_webtag) = array_keys($_POST['changepassword']);

    $redirect_uri = "admin_forum_set_passwd.php?webtag=$forum_webtag&";

    if (isset($_POST['fid']) && is_numeric($_POST['fid'])) {
        $redirect_uri.= "ret=". rawurlencode("admin_forums.php?webtag=$webtag&fid={$_POST['fid']}");
    }elseif (isset($_GET['fid']) && is_numeric($_GET['fid'])) {
        $redirect_uri.= "ret=". rawurlencode("admin_forums.php?webtag=$webtag&fid={$_GET['fid']}");
    }

    header_redirect($redirect_uri);
    exit;
}

if (isset($_GET['addforum']) || isset($_POST['addforum'])) {

    html_draw_top();
    
    echo "<h1>{$lang['admin']} &raquo; {$lang['manageforums']} &raquo; {$lang['addforum']}</h1>\n";

    if (isset($error_html) && strlen(trim($error_html)) > 0) {
        echo $error_html;
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "  <form name=\"thread_options\" action=\"admin_forums.php\" method=\"post\" target=\"_self\">\n";
    echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
    echo "  ", form_input_hidden('page', _htmlentities($page)), "\n";
    echo "  ", form_input_hidden('addforum', 'true'), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\">{$lang['addforum']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"150\" class=\"posthead\">{$lang['forumwebtag']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_text("t_webtag", (isset($_POST['t_webtag']) ? _htmlentities(_stripslashes($_POST['t_webtag'])) : ""), 25, 15), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"150\" class=\"posthead\">{$lang['forumname']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_text("t_name", (isset($_POST['t_name']) ? _htmlentities(_stripslashes($_POST['t_name'])) : ""), 35, 255), "</td>\n";
    echo "                      </tr>\n";

    if ($available_databases = forums_get_available_dbs()) {

        $available_databases = array_merge(array('&nbsp;'), $available_databases);
        
        echo "                      <tr>\n";
        echo "                        <td align=\"left\" width=\"150\" class=\"posthead\">{$lang['usedatabase']}:</td>\n";
        echo "                        <td align=\"left\">", form_dropdown_array("t_database", $available_databases, (isset($_POST['t_database']) ? _stripslashes($_POST['t_database']) : (isset($forum_data['DATABASE_NAME']) ? $forum_data['DATABASE_NAME'] : ""))), form_input_hidden("t_database_old", (isset($forum_data['DATABASE_NAME']) ? _htmlentities($forum_data['DATABASE_NAME']) : "")), "</td>\n";
        echo "                      </tr>\n";
    }

    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"150\" class=\"posthead\">{$lang['accesslevel']}:</td>\n";
    echo "                        <td align=\"left\">", form_dropdown_array("t_access", array('' => '&nbsp;', FORUM_CLOSED => $lang['closed'], FORUM_UNRESTRICTED => $lang['open'], FORUM_RESTRICTED => $lang['restricted'], FORUM_PASSWD_PROTECTED => $lang['passwordprotected']), (isset($_POST['t_access']) && is_numeric($_POST['t_access'])) ? $_POST['t_access'] : ''), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"150\" class=\"posthead\">{$lang['defaultforum']}:</td>\n";
    echo "                        <td align=\"left\">", form_radio("t_default", 'Y', $lang['yes'], false), "&nbsp;", "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                        <td align=\"left\">", form_radio("t_default", 'N', $lang['no'], true), "&nbsp;", "</td>\n";
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
    echo "      <td align=\"center\">", form_submit("addforumsubmit", $lang['add']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  </form>\n";
    echo "  <br />\n";
    echo "  <table width=\"500\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"center\">\n";
    echo "        <table class=\"text_captcha_error\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" width=\"20\"><img src=\"", style_image('warning.png'), "\" width=\"16\" height=\"16\" alt=\"warning\" /></td>\n";
    echo "            <td align=\"left\">{$lang['forum_settings_help_38']}</td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  <br />\n";
    echo "  <table width=\"500\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"center\">\n";
    echo "        <table class=\"text_captcha_error\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" width=\"20\"><img src=\"", style_image('warning.png'), "\" width=\"16\" height=\"16\" alt=\"warning\" /></td>\n";
    echo "            <td align=\"left\">{$lang['forumdatabasewarning']}</td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</div>\n";

    html_draw_bottom();

}elseif (isset($_POST['fid']) || isset($_GET['fid'])) {

    if (isset($_POST['fid']) && is_numeric($_POST['fid'])) {

        $fid = $_POST['fid'];

    }elseif (isset($_GET['fid']) && is_numeric($_GET['fid'])) {

        $fid = $_GET['fid'];

    }else {

        html_draw_top();
        html_error_msg($lang['invalidforumidorforumnotfound'], 'admin_forums.php', 'get', array('back' => $lang['back']));
        html_draw_bottom();
        exit;
    }

    if (!$forum_data = forum_get($fid)) {

        html_draw_top();
        html_error_msg($lang['invalidforumidorforumnotfound'], 'admin_forums.php', 'get', array('back' => $lang['back']));
        html_draw_bottom();
        exit;
    }

    html_draw_top();
    
    echo "<h1>{$lang['admin']} &raquo; {$lang['manageforums']} &raquo; {$lang['editforum']} &raquo; {$forum_data['WEBTAG']}</h1>\n";

    if (isset($error_html) && strlen(trim($error_html)) > 0) {
        echo $error_html;
    }

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "  <form name=\"thread_options\" action=\"admin_forums.php\" method=\"post\" target=\"_self\">\n";
    echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
    echo "  ", form_input_hidden('fid', _htmlentities($fid)), "\n";
    echo "  ", form_input_hidden("t_delete[$fid]", "Y"), "\n";
    echo "  ", form_input_hidden('page', _htmlentities($page)), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\">{$lang['editforum']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"150\" class=\"posthead\">{$lang['forumname']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_text("t_name", (isset($_POST['t_name']) ? _htmlentities(_stripslashes($_POST['t_name'])) : (isset($forum_data['FORUM_SETTINGS']['forum_name']) ? _htmlentities($forum_data['FORUM_SETTINGS']['forum_name']) : "")), 35, 255), form_input_hidden("t_name_old", (isset($forum_data['FORUM_SETTINGS']['forum_name']) ? _htmlentities($forum_data['FORUM_SETTINGS']['forum_name']) : "")), "</td>\n";
    echo "                      </tr>\n";

    if ($forum_data['ACCESS_LEVEL'] == FORUM_RESTRICTED) {

        echo "                      <tr>\n";
        echo "                        <td align=\"left\" width=\"150\" class=\"posthead\">{$lang['accesslevel']}:</td>\n";
        echo "                        <td align=\"left\" nowrap=\"nowrap\">", form_dropdown_array("t_access", array(FORUM_CLOSED => $lang['closed'], FORUM_UNRESTRICTED => $lang['open'], FORUM_RESTRICTED => $lang['restricted'], FORUM_PASSWD_PROTECTED => $lang['passwordprotected']), (isset($_POST['t_access']) && is_numeric($_POST['t_access'])) ? $forum_data['ACCESS_LEVEL'] : (isset($forum_data['ACCESS_LEVEL']) && is_numeric($forum_data['ACCESS_LEVEL'])) ? $forum_data['ACCESS_LEVEL'] : 0), "&nbsp;", form_submit("changepermissions[{$forum_data['WEBTAG']}]", $lang['change']), "</td>\n";
        echo "                      </tr>\n";

    }elseif ($forum_data['ACCESS_LEVEL'] == FORUM_PASSWD_PROTECTED) {

        echo "                      <tr>\n";
        echo "                        <td align=\"left\" width=\"150\" class=\"posthead\">{$lang['accesslevel']}:</td>\n";
        echo "                        <td align=\"left\" nowrap=\"nowrap\">", form_dropdown_array("t_access", array(FORUM_CLOSED => $lang['closed'], FORUM_UNRESTRICTED => $lang['open'], FORUM_RESTRICTED => $lang['restricted'], FORUM_PASSWD_PROTECTED => $lang['passwordprotected']), (isset($_POST['t_access']) && is_numeric($_POST['t_access'])) ? $forum_data['ACCESS_LEVEL'] : (isset($forum_data['ACCESS_LEVEL']) && is_numeric($forum_data['ACCESS_LEVEL'])) ? $forum_data['ACCESS_LEVEL'] : 0), "&nbsp;", form_submit("changepassword[{$forum_data['WEBTAG']}]", $lang['change']), "</td>\n";
        echo "                      </tr>\n";

    }else {

        echo "                      <tr>\n";
        echo "                        <td align=\"left\" width=\"150\" class=\"posthead\">{$lang['accesslevel']}:</td>\n";
        echo "                        <td align=\"left\" nowrap=\"nowrap\">", form_dropdown_array("t_access", array(FORUM_CLOSED => $lang['closed'], FORUM_UNRESTRICTED => $lang['open'], FORUM_RESTRICTED => $lang['restricted'], FORUM_PASSWD_PROTECTED => $lang['passwordprotected']), (isset($_POST['t_access']) && is_numeric($_POST['t_access'])) ? $forum_data['ACCESS_LEVEL'] : (isset($forum_data['ACCESS_LEVEL']) && is_numeric($forum_data['ACCESS_LEVEL'])) ? $forum_data['ACCESS_LEVEL'] : 0), "</td>\n";
        echo "                      </tr>\n";
    }

    echo "                      <tr>\n";
    echo "                        <td align=\"left\" width=\"150\" class=\"posthead\">{$lang['defaultforum']}:</td>\n";
    echo "                        <td align=\"left\">", form_radio("t_default", 'Y', $lang['yes'], (isset($_POST['t_default']) && is_numeric($_POST['t_default']) && $_POST['t_default'] == 1) ? true : (isset($forum_data['DEFAULT_FORUM']) && is_numeric($forum_data['DEFAULT_FORUM']) && $forum_data['DEFAULT_FORUM'] == 1) ? true : false), "&nbsp;", "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                        <td align=\"left\">", form_radio("t_default", 'N', $lang['no'], (isset($_POST['t_default']) && is_numeric($_POST['t_default']) && $_POST['t_default'] == 0) ? true : (isset($forum_data['DEFAULT_FORUM']) && is_numeric($forum_data['DEFAULT_FORUM']) && $forum_data['DEFAULT_FORUM'] == 0) ? true : false), "&nbsp;", "</td>\n";
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
    echo "      <td align=\"center\">", form_submit("updateforumsubmit", $lang['save']), " &nbsp;", form_submit("delete", $lang['delete']), " &nbsp;",form_submit("cancel", $lang['back']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  <br />\n";
    echo "  <table width=\"500\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"center\">\n";
    echo "        <table class=\"text_captcha_error\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" width=\"20\"><img src=\"", style_image('warning.png'), "\" width=\"16\" height=\"16\" alt=\"warning\" /></td>\n";
    echo "            <td align=\"left\">{$lang['forum_settings_help_38']}</td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  </form>\n";
    echo "</div>\n";

    html_draw_bottom();

}else {

    html_draw_top();
    
    echo "<h1>{$lang['admin']} &raquo; {$lang['manageforums']}</h1>\n";

    if (isset($error_html) && strlen(trim($error_html)) > 0) {
        echo $error_html;
    }

    if (isset($add_success) && strlen(trim($add_success)) > 0) echo $add_success;
    if (isset($del_success) && strlen(trim($del_success)) > 0) echo $del_success;
    if (isset($edit_success) && strlen(trim($edit_success)) > 0) echo $edit_success;

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "<form name=\"forums\" action=\"admin_forums.php\" method=\"post\">\n";
    echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
    echo "  ", form_input_hidden('page', _htmlentities($page)), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" align=\"center\" width=\"20\">&nbsp;</td>\n";
    echo "                  <td class=\"subhead\" align=\"left\" nowrap=\"nowrap\" width=\"150\">{$lang['webtag']}</td>\n";
    echo "                  <td class=\"subhead\" align=\"left\" nowrap=\"nowrap\">{$lang['name']}</td>\n";
    echo "                  <td class=\"subhead\" align=\"left\" nowrap=\"nowrap\">{$lang['messages']}</td>\n";
    echo "                  <td class=\"subhead\" align=\"center\" width=\"20\">&nbsp;</td>\n";
    echo "                </tr>\n";

    $forums_array = admin_get_forum_list($start);

    if (sizeof($forums_array['forums_array']) > 0) {

        foreach ($forums_array['forums_array'] as $forum_data) {

            echo "                <tr>\n";
            echo "                  <td valign=\"top\" align=\"center\" width=\"1%\">", form_checkbox("t_delete[{$forum_data['FID']}]", "Y", false), "</td>\n";
            echo "                  <td align=\"left\"><a href=\"admin_forums.php?webtag=$webtag&amp;fid={$forum_data['FID']}&amp;page=$page\" title=\"{$lang['editforum']}\">{$forum_data['WEBTAG']}</a></td>\n";
            echo "                  <td align=\"left\"><a href=\"index.php?webtag={$forum_data['WEBTAG']}\" title=\"", sprintf($lang['visitforum'], $forum_data['FORUM_NAME']), "\" target=\"_blank\">{$forum_data['FORUM_NAME']}</a></td>\n";

            if (isset($forum_data['MESSAGES'])) {
                echo "                  <td align=\"left\">{$forum_data['MESSAGES']} {$lang['messages']}</td>\n";
            }else {
                echo "                  <td align=\"left\">{$lang['unknownmessagecount']}</td>\n";
            }

            if (isset($forum_data['DEFAULT_FORUM']) && $forum_data['DEFAULT_FORUM'] == 1) {
                echo "                        <td align=\"left\" nowrap=\"nowrap\"><a href=\"admin_forum_settings.php?webtag={$forum_data['WEBTAG']}\" target=\"_self\"><img src=\"", style_image('edit.png'), "\" border=\"0\" alt=\"{$lang['forumsettings']}\" title=\"{$lang['forumsettings']}\" /></a>&nbsp;<a href=\"admin_forums.php?webtag=$webtag&amp;page=$page&amp;default=0\"><img src=\"", style_image('default_forum.png'), "\" border=\"0\" alt=\"{$lang['unsetdefault']}\" title=\"{$lang['unsetdefault']}\" /></a></td>\n";
            }else {
                echo "                        <td align=\"left\" nowrap=\"nowrap\"><a href=\"admin_forum_settings.php?webtag={$forum_data['WEBTAG']}\" target=\"_self\"><img src=\"", style_image('edit.png'), "\" border=\"0\" alt=\"{$lang['forumsettings']}\" title=\"{$lang['forumsettings']}\" /></a>&nbsp;<a href=\"admin_forums.php?webtag=$webtag&amp;page=$page&amp;default={$forum_data['FID']}\"><img src=\"", style_image('set_default_forum.png'), "\" border=\"0\" alt=\"{$lang['makedefault']}\" title=\"{$lang['makedefault']}\" /></a></td>\n";
            }

            echo "                </tr>\n";
        }

    }else {

        echo "                <tr>\n";
        echo "                  <td valign=\"top\" align=\"center\" width=\"25\">&nbsp;</td>\n";
        echo "                  <td valign=\"top\" align=\"left\" colspan=\"3\">{$lang['noexistingforums']}</td>\n";
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
    echo "      <td class=\"postbody\" align=\"center\">", page_links(get_request_uri(true, false), $start, $forums_array['forums_count'], 10), "</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_submit("addforum", $lang['addnew']), "&nbsp;", form_submit("delete", $lang['deleteselected']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</form>\n";
    echo "</div>\n";

    html_draw_bottom();
}

?>