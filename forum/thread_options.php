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

/* $Id: thread_options.php,v 1.14 2004-04-26 11:21:11 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Multiple forum support
include_once("./include/forum.inc.php");

$forum_settings = get_forum_settings();

include_once("./include/admin.inc.php");
include_once("./include/beehive.inc.php");
include_once("./include/constants.inc.php");
include_once("./include/edit.inc.php");
include_once("./include/folder.inc.php");
include_once("./include/form.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/messages.inc.php");
include_once("./include/perm.inc.php");
include_once("./include/poll.inc.php");
include_once("./include/post.inc.php");
include_once("./include/session.inc.php");
include_once("./include/thread.inc.php");
include_once("./include/user.inc.php");

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

// Guests can't use this

if (bh_session_get_value('UID') == 0) {
    html_guest_error();
    exit;
}

// Check that required variables are set

if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {
    list($tid, $pid) = explode(".", $_GET['msg']);
}elseif (isset($_GET['tid']) && is_numeric($_GET['tid'])) {
    $tid = $_GET['tid'];
    $pid = 1;
}else {
    html_draw_top();
    echo "<h1>{$lang['invalidop']}</h1>\n";
    html_draw_bottom();
}

$uid = bh_session_get_value('UID');

if (!thread_can_view($tid, $uid)) {

    html_draw_top();
    echo "<h1>{$lang['error']}</h1>\n";
    echo "<h2>{$lang['threadcouldnotbefound']}</h2>";
    html_draw_bottom();
    exit;
}

if (!$threaddata = thread_get($tid)) {

    html_draw_top();
    echo "<h2>{$lang['postdoesnotexist']}</h2>\n";
    html_draw_bottom();
    exit;
}

$update = false;

if (isset($_POST['back'])) {

    $uri = "./messages.php?webtag=$webtag&msg=$tid.$pid";
    header_redirect($uri);
    exit;
}

// User Options

if (isset($_POST['markasread']) && is_numeric($_POST['markasread']) && $_POST['markasread'] != $threaddata['LAST_READ']) {

    $threaddata['LAST_READ'] = $_POST['markasread'];
    messages_set_read($tid, $threaddata['LAST_READ'], $uid);
    $update = true;

}else if (isset($_GET['markasread']) && is_numeric($_GET['markasread'])) {

    $markasread = $_GET['markasread'];
    messages_set_read($tid, $markasread, $uid);

    $uri = "./messages.php?webtag=$webtag&msg=$tid.$pid&markasread=1";
    header_redirect($uri);
    exit;
}

if (isset($_POST['interest']) && is_numeric($_POST['interest']) && $_POST['interest'] != $threaddata['INTEREST']) {
    $threaddata['INTEREST'] = $_POST['interest'];
    thread_set_interest($tid, $threaddata['INTEREST']);
    $update = true;
}

// Admin Options

if (perm_is_moderator() || ((($threaddata['FROM_UID'] == $uid) && $threaddata['ADMIN_LOCK'] == 0) && ((forum_get_setting('allow_post_editing', 'Y', false)) && intval(forum_get_setting('post_edit_time')) == 0) || ((time() - $threaddata['CREATED']) < (intval(forum_get_setting('post_edit_time')) * HOUR_IN_SECONDS)))) {

    if (isset($_POST['rename'])) {

        if ($_POST['rename'] != $threaddata['TITLE'] && trim($_POST['rename']) != "") {

            $threaddata['TITLE'] = $_POST['rename'];
            thread_change_title($tid, $threaddata['TITLE']);
            post_add_edit_text($tid, 1);
			if (perm_is_moderator() && $threaddata['FROM_UID'] != $uid) {
	            admin_addlog(0, 0, $tid, 0, 0, 0, 21);
			}
            $update = true;
        }
    }

    if (isset($_POST['move']) && is_numeric($_POST['move'])) {

        if (folder_is_valid($_POST['move']) && $_POST['move'] != $threaddata['FID']) {

            $threaddata['FID'] = $_POST['move'];
            thread_change_folder($tid, $threaddata['FID']);
			if (perm_is_moderator() && $threaddata['FROM_UID'] != $uid) {
	            admin_addlog(0, $threaddata['FID'], $tid, 0, 0, 0, 18);
			}
            $update = true;
        }
    }
}

if (perm_is_moderator()) {

    if (isset($_POST['closed'])) {

        if (($_POST['closed'] == "Y") != $threaddata['CLOSED']) {

            $threaddata['CLOSED'] = ($_POST['closed'] == "Y");
            thread_set_closed($tid, $threaddata['CLOSED']);
            admin_addlog(0, 0, $tid, 0, 0, 0, ($threaddata['CLOSED']) ? 19 : 20);
            $update = true;
        }
    }

    if (isset($_POST['lock'])) {

        if (($_POST['lock'] == "Y") != $threaddata['ADMIN_LOCK']) {

            $threaddata['ADMIN_LOCK'] = ($_POST['lock'] == "Y");
            thread_admin_lock($tid, $threaddata['ADMIN_LOCK']);
            admin_addlog(0, 0, $tid, 0, 0, 0, ($threaddata['ADMIN_LOCK']) ? 30 : 31);
            $update = true;
        }
    }

    if (isset($_POST['sticky'])) {

        if ($_POST['sticky'] == "Y") {

            $day = isset($_POST['sticky_day']) && is_numeric($_POST['sticky_day']) ? $_POST['sticky_day'] : 0;
            $month = isset($_POST['sticky_month']) && is_numeric($_POST['sticky_month']) ? $_POST['sticky_month'] : 0;
            $year = isset($_POST['sticky_year']) && is_numeric($_POST['sticky_year']) ? $_POST['sticky_year'] : 0;
            $tmp_sticky_until = $day || $month || $year ? mktime(0, 0, 0, $month, $day, $year) : false;

            if (($_POST['sticky'] == $threaddata['STICKY'] && $tmp_sticky_until != $threaddata['STICKY_UNTIL']) || $_POST['sticky'] != $threaddata['STICKY']) {

                $threaddata['STICKY'] = $_POST['sticky'];
                $threaddata['STICKY_UNTIL'] = $tmp_sticky_until;
                thread_set_sticky($tid, true, $threaddata['STICKY_UNTIL']);
                admin_addlog(0, 0, $tid, 0, 0, 0, 25);
                $update = true;
            }

        }elseif ($_POST['sticky'] != $threaddata['STICKY']) {
            $threaddata['STICKY'] = $_POST['sticky'];
            thread_set_sticky($tid, false);
            admin_addlog(0, 0, $tid, 0, 0, 0, 26);
            $update = true;
        }
    }

    if (isset($_POST['t_to_uid_in_thread']) && is_numeric($_POST['t_to_uid_in_thread']) && isset($_POST['deluser_con']) && $_POST['deluser_con'] == "Y") {

        if ($del_uid = $_POST['t_to_uid_in_thread']) {

            thread_delete_by_user($tid, $del_uid['UID']);
            admin_addlog($del_uid['UID'], 0, $tid, 0, 0, 0, 32);
            $update = true;
        }
    }

    if (isset($_POST['delthread']) && $_POST['delthread'] == "Y") {

        if (isset($_POST['delthread_con']) && $_POST['delthread_con'] == "Y") {

            thread_delete($tid);
            admin_addlog(0, 0, $tid, 0, 0, 0, 33);
            $update = true;
        }
    }
}

html_draw_top("basetarget=_blank");

echo "<h1>{$lang['threadoptions']}: <a href=\"messages.php?webtag=$webtag&amp;msg={$tid}.1\" target=\"_self\">#{$tid} {$threaddata['TITLE']}</a></h1>\n";
echo "<br />\n";

if ($update) {
    echo "<h2>{$lang['updatesmade']}</h2>\n";
    echo "<br />\n";
}

echo "<div align=\"center\">\n";
echo "  <form name=\"thread_options\" action=\"" . get_request_uri() . "\" method=\"post\" target=\"_self\">\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\"> \n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" colspan=\"2\">{$lang['useroptions']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"250\" class=\"posthead\">{$lang['markedasread']}:</td>\n";
echo "                  <td>", form_input_text("markasread", $threaddata['LAST_READ'], 5), " {$lang['postsoutof']} {$threaddata['LENGTH']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td valign=\"top\" class=\"posthead\">{$lang['interest']}:</td>\n";
echo "                  <td>", form_radio("interest", -1, $lang['ignore'], $threaddata['INTEREST'] == -1), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>&nbsp;</td>\n";
echo "                  <td>", form_radio("interest", 0, $lang['normal'], $threaddata['INTEREST'] == 0), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>&nbsp;</td>\n";
echo "                  <td>", form_radio("interest", 1, $lang['interested'], $threaddata['INTEREST'] == 1), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>&nbsp;</td>\n";
echo "                  <td>", form_radio("interest", 2, $lang['subscribe'], $threaddata['INTEREST'] == 2), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>&nbsp;</td>\n";
echo "                  <td>&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";

if (perm_is_moderator() || ((($threaddata['FROM_UID'] == $uid) && $threaddata['ADMIN_LOCK'] == 0) && ((forum_get_setting('allow_post_editing', 'Y', false)) && intval(forum_get_setting('post_edit_time')) == 0) || ((time() - $threaddata['CREATED']) < (intval(forum_get_setting('post_edit_time')) * HOUR_IN_SECONDS)))) {

    echo "        <br />\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" colspan=\"2\">{$lang['rename']} / {$lang['move']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td width=\"250\" class=\"posthead\">{$lang['renamethread']}:</td>\n";

    if (thread_is_poll($tid)) {
        echo "                  <td><a href=\"edit_poll.php?webtag=$webtag&amp;msg=$tid.1\" target=\"_parent\">{$lang['editthepoll']}</a> {$lang['torenamethisthread']}.</td>\n";
    }else {
        echo "                  <td>".form_input_text("rename", _stripslashes($threaddata['TITLE']), 30, 64)."</td>\n";
    }

    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td class=\"posthead\">{$lang['movethread']}:</td>\n";
    echo "                  <td>", folder_draw_dropdown($threaddata['FID'], "move"), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td>&nbsp;</td>\n";
    echo "                  <td>&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "            </td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";

    if (perm_is_moderator()) {

        echo "        <br />\n";
	echo "        <table class=\"box\" width=\"100%\">\n";
	echo "          <tr>\n";
	echo "            <td class=\"posthead\">\n";
        echo "              <table class=\"posthead\" width=\"100%\">\n";
	echo "                <tr>\n";
	echo "                  <td class=\"subhead\" colspan=\"2\">{$lang['makethreadsticky']}</td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td width=\"50%\" class=\"posthead\">{$lang['sticky']}:</td>\n";

        if ($threaddata['STICKY_UNTIL'] && $threaddata['STICKY'] == "Y") {
            $year = date("Y", $threaddata['STICKY_UNTIL']);
            $month = date("n", $threaddata['STICKY_UNTIL']);
            $day = date("j", $threaddata['STICKY_UNTIL']);
        } else {
            $year = 0;
            $month = 0;
            $day = 0;
        }

        echo "                  <td nowrap=\"nowrap\">", form_radio("sticky", "Y", $lang['until'], $threaddata['STICKY'] == "Y"), "&nbsp;", form_date_dropdowns($year, $month, $day, "sticky_"), "&nbsp;&nbsp;</td>\n";
        echo "                </tr>\n";
	echo "                <tr>\n";
	echo "                  <td>&nbsp;</td>\n";
	echo "                  <td>", form_radio("sticky", "N", $lang['no'], $threaddata['STICKY'] == "N"), "</td>\n";
	echo "                </tr>\n";
	echo "                <tr>\n";
	echo "                  <td>&nbsp;</td>\n";
	echo "                  <td>&nbsp;</td>\n";
        echo "                </tr>\n";
        echo "              </table>\n";
	echo "            </td>\n";
	echo "          </tr>\n";
	echo "        </table>\n";
	echo "        <br />\n";
	echo "        <table class=\"box\" width=\"100%\">\n";
	echo "          <tr>\n";
	echo "            <td class=\"posthead\">\n";
        echo "              <table class=\"posthead\" width=\"100%\">\n";
	echo "                <tr>\n";
	echo "                  <td class=\"subhead\" colspan=\"2\">{$lang['locked']} / {$lang['closed']}</td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td class=\"posthead\">{$lang['closedforposting']}:</td>\n";
        echo "                  <td>\n";
        echo "                    ", form_radio("closed", "Y", $lang['yes'], $threaddata['CLOSED']), " \n";
        echo "                    ", form_radio("closed", "N", $lang['no'], !$threaddata['CLOSED']), "\n";
        echo "                  </td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td class=\"posthead\">{$lang['locktitleandfolder']}:</td>\n";
        echo "                  <td>\n";
        echo "                    ", form_radio("lock", "Y", $lang['yes'], $threaddata['ADMIN_LOCK']), " \n";
        echo "                    ", form_radio("lock", "N", $lang['no'], !$threaddata['ADMIN_LOCK']), "\n";
        echo "                  </td>\n";
        echo "                </tr>\n";
	echo "                <tr>\n";
	echo "                  <td>&nbsp;</td>\n";
	echo "                  <td>&nbsp;</td>\n";
        echo "                </tr>\n";
        echo "              </table>\n";
	echo "            </td>\n";
	echo "          </tr>\n";
	echo "        </table>\n";
	echo "        <br />\n";
	echo "        <table class=\"box\" width=\"100%\">\n";
	echo "          <tr>\n";
	echo "            <td class=\"posthead\">\n";
        echo "              <table class=\"posthead\" width=\"100%\">\n";
        echo "                <tr>\n";
	echo "                  <td class=\"subhead\" colspan=\"2\">{$lang['deletethread']} / {$lang['posts']}</td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td class=\"posthead\">{$lang['deletepostsinthreadbyuser']}:</td>\n";
        echo "                  <td class=\"posthead\">", post_draw_to_dropdown_in_thread($tid, 0, false, true), "</td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
	echo "                  <td>&nbsp;</td>\n";
        echo "                  <td class=\"posthead\">", form_checkbox("deluser_con", "Y", $lang['confirm']), "</td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td class=\"posthead\">{$lang['deletethread']}:</td>\n";
        echo "                  <td class=\"posthead\">\n";
        echo "                    ", form_checkbox("delthread", "Y", $lang['yes']), "\n";
        echo "                    ", form_checkbox("delthread_con", "Y", $lang['confirm']), "\n";
        echo "                  </td>\n";
        echo "                </tr>\n";
	echo "                <tr>\n";
	echo "                  <td>&nbsp;</td>\n";
	echo "                  <td>&nbsp;</td>\n";
        echo "                </tr>\n";
    }

    echo "              </table>\n";
    echo "            </td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
}

echo "    <tr>\n";
echo "      <td>&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"center\">", form_submit("submit", $lang['submit']), " &nbsp;", form_submit("back", $lang['back']), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  </form>\n";
echo "</div>\n";

html_draw_bottom();

?>