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

/* $Id: admin_forums.php,v 1.11 2004-04-17 20:21:47 decoyduck Exp $ */

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
include_once("./include/myforums.inc.php");
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

html_draw_top();

if (!(bh_session_get_value('STATUS') & USER_PERM_QUEEN)) {
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;
}

// Do updates

if (isset($_POST['submit'])) {

    $valid = true;
    $message_html = "";

    if (isset($_POST['t_access']) && is_array($_POST['t_access'])) {

        foreach($_POST['t_access'] as $fid => $new_access) {
            forum_update_access($fid, $new_access);
        }
    }

    if (isset($_POST['t_webtag_new']) && strlen(trim($_POST['t_webtag_new'])) > 0) {
	       
        $new_webtag = strtoupper(trim(_stripslashes($_POST['t_webtag_new'])));
        
        if (!preg_match("/^[A-Z0-9_-]+$/", $new_webtag)) {
            $message_html.= "<h2>{$lang['webtaginvalidchars']}</h2>\n";
            $valid = false;
        }

	if (isset($_POST['t_name_new']) && strlen(trim($_POST['t_name_new'])) > 0) {
	    $new_name = trim(_stripslashes($_POST['t_name_new']));
	}else {
	    $new_name = "";
	}
        
	if (isset($_POST['t_access_new']) && is_numeric($_POST['t_access_new'])) {
	    $new_access = $_POST['t_access_new'];
	}else {
	    $new_access = 0;
	}

	if ($valid) {
            if ($new_fid = forum_create($new_webtag, $new_name, $new_access)) {
	        $message_html = "<h2>{$lang['successfullycreatedforum']} '$new_webtag'</h2>\n";
	    }else {
	        $message_html = "<h2>{$lang['failedtocreateforum_1']} '$new_webtag'. {$lang['failedtocreateforum_2']}</h2>\n";
	    }
	}
    }

}elseif (isset($_POST['t_delete']) && is_array($_POST['t_delete'])) {

    list($fid) = array_keys($_POST['t_delete']);
    
    echo "<h1>{$lang['admin']} : {$lang['manageforums']}</h1>\n";
    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "<form name=\"f_folders\" action=\"admin_forums.php\" method=\"post\">\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
    echo "    <tr>\n";
    echo "      <td>\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td class=\"posthead\">\n";
    echo "              <table width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\"><h2>{$lang['warning_caps']}</h2></td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td>&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td>{$lang['forumdeletewarning']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
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
    echo "      <td align=\"center\">", form_submit("t_confirm_delete[$fid]", $lang['delete']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</td>\n";
    echo "    </tr>\n";     
    echo "  </table>\n";
    echo "</form>\n";
    echo "</div>\n";

    html_draw_bottom();
    exit;

}elseif (isset($_POST['t_confirm_delete'])) {
    
    list($fid) = array_keys($_POST['t_confirm_delete']);
    forum_delete($fid);

}elseif (isset($_POST['t_default']) && is_array($_POST['t_default'])) {

    list($fid) = array_keys($_POST['t_default']);
    forum_update_default($fid);
}

echo "<h1>{$lang['admin']} : {$lang['manageforums']}</h1>\n";
echo "<br />\n";

if (isset($message_html) && strlen($message_html) > 0) {
    echo $message_html;
    echo "<br />\n";
}

echo "<div align=\"center\">\n";

$forums_array = admin_get_forum_list();

if (sizeof($forums_array) > 0) {

    echo "  <form name=\"f_folders\" action=\"admin_forums.php\" method=\"post\">\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"96%\">\n";
    echo "    <tr>\n";
    echo "      <td>\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td class=\"posthead\">\n";
    echo "              <table width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" align=\"left\" nowrap=\"nowrap\">&nbsp;</td>\n";
    echo "                  <td class=\"subhead\" align=\"left\" nowrap=\"nowrap\" width=\"150\">&nbsp;{$lang['webtag']}</td>\n";
    echo "                  <td class=\"subhead\" align=\"left\" nowrap=\"nowrap\">&nbsp;{$lang['name']}</td>\n";
    echo "                  <td class=\"subhead\" align=\"left\" nowrap=\"nowrap\">&nbsp;{$lang['messages']}</td>\n";
    echo "                  <td class=\"subhead\" align=\"left\" nowrap=\"nowrap\">&nbsp;{$lang['allow']}</td>\n";
    echo "                  <td class=\"subhead\" align=\"left\" nowrap=\"nowrap\">&nbsp;{$lang['permissions']}</td>\n";
    echo "                  <td class=\"subhead\" align=\"left\" nowrap=\"nowrap\">&nbsp;{$lang['delete']}</td>\n";
    echo "                  <td class=\"subhead\" align=\"left\" nowrap=\"nowrap\">&nbsp;{$lang['defaultforum']}</td>\n";
    echo "                </tr>\n";

    foreach ($forums_array as $forum) {

        echo "                <tr>\n";
        echo "                  <td align=\"left\">&nbsp;</td>\n";
        echo "                  <td align=\"left\"><a href=\"index.php?webtag={$forum['WEBTAG']}\" target=\"_blank\">{$forum['WEBTAG']}</a></td>\n";
        echo "                  <td align=\"left\">{$forum['FORUM_NAME']}</td>\n";
        echo "                  <td align=\"left\">{$forum['MESSAGES']} Messages</td>\n";
        echo "                  <td align=\"left\">", form_dropdown_array("t_access[{$forum['FID']}]", array(-1, 0, 1, 2), array($lang['closed'], $lang['open'], $lang['restricted'], $lang['passwd']), $forum['ACCESS_LEVEL']), "</td>\n";

        if ($forum['ACCESS_LEVEL'] > 0) {
            echo "                  <td align=\"left\">", form_button("permissions", $lang['change'], "onclick=\"document.location.href='admin_forum_access.php?fid={$forum['FID']}'\""), "</td>\n";
        }else {
            echo "                  <td align=\"center\">&nbsp;</td>\n";
        }

        echo "                  <td align=\"left\">", form_submit("t_delete[{$forum['FID']}]", $lang['deleteforum']), "</td>\n";

	if ($forum['DEFAULT_FORUM'] == 1) {
  	    echo "                  <td align=\"left\">", form_submit("t_default[0]", $lang['unsetdefault']), "</td>\n";
	}else {
  	    echo "                  <td align=\"left\">", form_submit("t_default[{$forum['FID']}]", $lang['makedefault']), "</td>\n";
	}

        echo "                </tr>\n";
    }

    echo "                <tr>\n";
    echo "                  <td colspan=\"5\">&nbsp;</td>\n";
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
    echo "      <td align=\"center\">", form_submit("submit", $lang['savechanges']), "</td>\n";
    echo "    </tr>\n";  
    echo "  </table>\n";
    echo "  </form>\n";
    echo "  <br />\n";
}

echo "  <form name=\"f_folders\" action=\"admin_forums.php\" method=\"post\">\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"96%\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\">&nbsp;</td>\n";
echo "                  <td class=\"subhead\">&nbsp;{$lang['webtag']}</td>\n";
echo "                  <td class=\"subhead\">&nbsp;{$lang['name']}</td>\n";
echo "                  <td class=\"subhead\">&nbsp;{$lang['allow']}</td>\n";
echo "                  <td class=\"subhead\" width=\"50%\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>{$lang['newcaps']}</td>\n";
echo "                  <td>", form_input_text("t_webtag_new", "", 20, 32), "</td>\n";
echo "                  <td>", form_input_text("t_name_new", "", 45, 255), "</td>\n";
echo "                  <td>", form_dropdown_array("t_access_new", array(-1, 0, 1), array($lang['closed'], $lang['open'], $lang['restricted']), 0), "</td>\n";
echo "                  <td>&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"5\">&nbsp;</td>\n";
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
echo "      <td align=\"center\">", form_submit("submit", $lang['add']), "</td>\n";
echo "    </tr>\n";  
echo "  </table>\n";
echo "  </form>\n";;
echo "</div>\n";

html_draw_bottom();

?>