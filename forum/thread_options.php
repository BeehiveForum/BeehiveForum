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

/* $Id: thread_options.php,v 1.2 2004-04-12 14:31:20 tribalonline Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Multiple forum support
include_once("./include/forum.inc.php");
$forum_settings = get_forum_settings();

include_once("./include/admin.inc.php");
include_once("./include/beehive.inc.php");
include_once("./include/config.inc.php");
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
include_once("./include/session.inc.php");
include_once("./include/thread.inc.php");
include_once("./include/user.inc.php");

if (!$user_sess = bh_session_check()) {

    if (isset($HTTP_SERVER_VARS["REQUEST_METHOD"]) && $HTTP_SERVER_VARS["REQUEST_METHOD"] == "POST") {
        
        if (perform_logon(false)) {
	    
	    html_draw_top();

            echo "<h1>{$lang['loggedinsuccessfully']}</h1>";
            echo "<div align=\"center\">\n";
	    echo "<p><b>{$lang['presscontinuetoresend']}</b></p>\n";

            $request_uri = get_request_uri();

            echo "<form method=\"post\" action=\"$request_uri\" target=\"_self\">\n";

            foreach($HTTP_POST_VARS as $key => $value) {
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


// Check we have a webtag

if (!$webtag = get_webtag()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?final_uri=$request_uri");
}


// Check that required variables are set
if (isset($HTTP_GET_VARS['tid'])) {
    $tid = $HTTP_GET_VARS['tid'];
}

$uid = bh_session_get_value('UID');

if (!thread_can_view($tid, $uid)) {
	html_draw_top();
	echo "<h1>{$lang['error']}</h1>\n";
	echo "<h2>{$lang['threadcouldnotbefound']}</h2>";
	html_draw_bottom();
	exit;
}

html_draw_top("basetarget=_blank");

if (!$threaddata = thread_get($tid)) {
	echo "<h2>{$lang['postdoesnotexist']}</h2>\n";
	html_draw_bottom();
	exit;
}

$title = $threaddata['TITLE'];
$length = $threaddata['LENGTH'];
$fid = $threaddata['FID'];
$interest = $threaddata['INTEREST'];
$sticky = $threaddata['STICKY'];
$sticky_until = $threaddata['STICKY_UNTIL'];
$closed = $threaddata['CLOSED'];
$locked = $threaddata['ADMIN_LOCK'];
$last_read = $threaddata['LAST_READ'];

$ismod = perm_is_moderator();
$canedit = $ismod;
if (!$ismod) {
	$canedit = (($threaddata['FROM_UID'] == $uid) && $locked == 0);
	if ($canedit) {
		$canedit = ((forum_get_setting('allow_post_editing', 'Y', false)) && intval(forum_get_setting('post_edit_time')) == 0) || ((time() - $threaddata['CREATED']) < (intval(forum_get_setting('post_edit_time')) * HOUR_IN_SECONDS));
	}
}

$update = false;

// User Options
if (isset($HTTP_POST_VARS['markasread']) && is_numeric($HTTP_POST_VARS['markasread']) && $HTTP_POST_VARS['markasread'] != $last_read) {
	$last_read = $HTTP_POST_VARS['markasread'];
	messages_set_read($tid, $last_read, $uid);
	$update = true;
} else if (isset($HTTP_GET_VARS['mar']) && is_numeric($HTTP_GET_VARS['mar']) && $HTTP_GET_VARS['mar'] != $last_read) {
	$last_read = $HTTP_GET_VARS['mar'];
	messages_set_read($tid, $last_read, $uid);
	$update = true;
}
if (isset($HTTP_POST_VARS['interest']) && is_numeric($HTTP_POST_VARS['interest']) && $HTTP_POST_VARS['interest'] != $interest) {
    $interest = $HTTP_POST_VARS['interest'];
    thread_set_interest($tid, $interest);
	$update = true;
}

// Admin Options
if ($canedit) {
	if (isset($HTTP_POST_VARS['rename'])) {
		if ($HTTP_POST_VARS['rename'] != $title) {
			$title = $HTTP_POST_VARS['rename'];
			thread_change_title($tid, $title);
			post_add_edit_text($tid, 1);
			admin_addlog(0, 0, $tid, 0, 0, 0, 21);
			$update = true;
		}
	}
	if (isset($HTTP_POST_VARS['move']) && is_numeric($HTTP_POST_VARS['move'])) {
		if (folder_is_valid($HTTP_POST_VARS['move']) && $HTTP_POST_VARS['move'] != $fid) {
			$fid = $HTTP_POST_VARS['move'];
			thread_change_folder($tid, $fid);
			admin_addlog(0, $fid, $tid, 0, 0, 0, 18);
			$update = true;
		}
	}
}
if ($ismod) {
	if (isset($HTTP_POST_VARS['closed'])) {
		if (($HTTP_POST_VARS['closed'] == "Y") != $closed) {
			$closed = ($HTTP_POST_VARS['closed'] == "Y");
			thread_set_closed($tid, $closed);
			admin_addlog(0, 0, $tid, 0, 0, 0, ($closed) ? 19 : 20);
			$update = true;
		}
	}
	if (isset($HTTP_POST_VARS['lock'])) {
		if (($HTTP_POST_VARS['lock'] == "Y") != $locked) {
			$locked = ($HTTP_POST_VARS['lock'] == "Y");
	        thread_admin_lock($tid, $locked);
		    admin_addlog(0, 0, $tid, 0, 0, 0, ($locked) ? 30 : 31);
			$update = true;
		}
	}
	if (isset($HTTP_POST_VARS['sticky'])) {
		if ($HTTP_POST_VARS['sticky'] == "Y") {
			$day = isset($HTTP_POST_VARS['sticky_day']) && is_numeric($HTTP_POST_VARS['sticky_day']) ? $HTTP_POST_VARS['sticky_day'] : 0;
			$month = isset($HTTP_POST_VARS['sticky_month']) && is_numeric($HTTP_POST_VARS['sticky_month']) ? $HTTP_POST_VARS['sticky_month'] : 0;
			$year = isset($HTTP_POST_VARS['sticky_year']) && is_numeric($HTTP_POST_VARS['sticky_year']) ? $HTTP_POST_VARS['sticky_year'] : 0;
			$tmp_sticky_until = $day || $month || $year ? mktime(0, 0, 0, $month, $day, $year) : false;

			if (($HTTP_POST_VARS['sticky'] == $sticky && $tmp_sticky_until != $sticky_until) || $HTTP_POST_VARS['sticky'] != $sticky) {
				$sticky = $HTTP_POST_VARS['sticky'];
				$sticky_until = $tmp_sticky_until;
				thread_set_sticky($tid, true, $sticky_until);
				admin_addlog(0, 0, $tid, 0, 0, 0, 25);
				$update = true;
			}

		} else if ($HTTP_POST_VARS['sticky'] != $sticky) {
			$sticky = $HTTP_POST_VARS['sticky'];
			thread_set_sticky($tid, false);
			admin_addlog(0, 0, $tid, 0, 0, 0, 26);
			$update = true;
		}
	}
	if (isset($HTTP_POST_VARS['deluser']) && isset($HTTP_POST_VARS['deluser_con']) && $HTTP_POST_VARS['deluser_con'] == "Y") {
		if ($del_uid = user_get_uid($HTTP_POST_VARS['deluser'])) {
			thread_delete_by_user($tid, $del_uid['UID']);
			admin_addlog($del_uid['UID'], 0, $tid, 0, 0, 0, 32);
			$update = true;
		}
	}
	if (isset($HTTP_POST_VARS['delthread']) && $HTTP_POST_VARS['delthread'] == "Y") {
		if (isset($HTTP_POST_VARS['delthread_con']) && $HTTP_POST_VARS['delthread_con'] == "Y") {
			thread_delete_by_user($tid, 0);
			admin_addlog(0, 0, $tid, 0, 0, 0, 33);
			$update = true;
		}
	}
}

echo "<h1>{$lang['threadoptions']}: <a href=\"messages.php?msg={$tid}.1\" target=\"_self\">#{$tid} {$title}</a></h1>\n";

if ($update) {
	echo "<h2>{$lang['updatesmade']}</h2>\n";
}

echo "<div align=\"center\">\n";
echo "  <form name=\"thread_options\" action=\"" . get_request_uri() . "\" method=\"post\" target=\"_self\">\n";
echo "    <table class=\"box\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\" width=\"500\">\n";
echo "      <tr>\n";
echo "        <td>\n";
echo "          <table class=\"posthead\" width=\"100%\"> \n";
echo "            <tr>\n";
echo "              <td class=\"subhead\" colspan=\"2\">{$lang['useroptions']}</td>\n";
echo "            </tr>\n";
echo "            <tr>\n";
echo "              <td width=\"250\" class=\"posthead\">{$lang['markedasread']}:</td>\n";

echo "              <td>".form_input_text("markasread", $last_read, 5);
echo " {$lang['postsoutof']} {$length}</td>\n";

echo "            </tr>\n";
echo "            <tr>\n";
echo "              <td valign=\"top\" class=\"posthead\">{$lang['interest']}</td>\n";
echo "              <td>\n";

echo "                ".form_radio("interest", -1, $lang['ignore'], $interest == -1)."<br />\n";
echo "                ".form_radio("interest", 0, $lang['normal'], $interest == 0)."<br />\n";
echo "                ".form_radio("interest", 1, $lang['interested'], $interest == 1)."<br />\n";
echo "                ".form_radio("interest", 2, $lang['subscribe'], $interest == 2)."<br />\n";

echo "              </td>\n";
echo "            </tr>\n";
echo "          </table>\n";
echo "        </td>\n";
echo "      </tr>\n";
echo "    </table>\n";

if ($ismod || $canedit) {
	echo "    <br />\n";
	echo "    <table class=\"box\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\" width=\"500\">\n";
	echo "      <tr>\n";
	echo "        <td>\n";
	echo "          <table class=\"posthead\" width=\"100%\">\n";
	echo "            <tr>\n";
	echo "              <td class=\"subhead\" colspan=\"2\">{$lang['adminoptions']}</td>\n";
	echo "            </tr>\n";
	echo "            <tr>\n";
	echo "              <td width=\"250\" class=\"posthead\">{$lang['renamethread']}</td>\n";

	if (thread_is_poll($tid)) {
		echo "              <td><a href=\"edit_poll.php?webtag=$webtag&msg=$tid.1\" target=\"_parent\">{$lang['editthepoll']}</a> {$lang['torenamethisthread']}.</td>\n";
	} else {
		echo "              <td>".form_input_text("rename", _stripslashes($title), 30, 64)."</td>\n";
    }

	echo "            </tr>\n";
	echo "            <tr>\n";
	echo "              <td class=\"posthead\">{$lang['movethread']}</td>\n";
	echo "              <td>".folder_draw_dropdown($fid, "move")."</td>\n";
	echo "            </tr>\n";

	if ($ismod) {
		echo "            <tr>\n";
		echo "              <td valign=\"top\" class=\"posthead\">{$lang['sticky']}:</td>\n";
		echo "              <td>\n";


		if ($sticky_until && $sticky == "Y") {
			$year = date("Y", $sticky_until);
			$month = date("n", $sticky_until);
			$day = date("j", $sticky_until);
		} else {
			$year = 0;
			$month = 0;
			$day = 0;
		}
		echo "                ".form_radio("sticky", "Y", $lang['until'], $sticky == "Y")."<br />\n";
		echo "                ".form_date_dropdowns($year, $month, $day, "sticky_");

		echo "                <br />\n";
		echo "                ".form_radio("sticky", "N", $lang['no'], $sticky == "N")."\n";
		echo "              </td>\n";
		echo "            </tr>\n";
		echo "            <tr>\n";
		echo "              <td class=\"posthead\">{$lang['closedforposting']}:</td>\n";
		echo "              <td>\n";

		echo "                ".form_radio("closed", "Y", $lang['yes'], $closed)." \n";
		echo "                ".form_radio("closed", "N", $lang['no'], !$closed)."\n";

		echo "              </td>\n";
		echo "            </tr>\n";
		echo "            <tr>\n";
		echo "              <td class=\"posthead\">{$lang['locktitleandfolder']}:</td>\n";
		echo "              <td>\n";

		echo "                ".form_radio("lock", "Y", $lang['yes'], $locked)." \n";
		echo "                ".form_radio("lock", "N", $lang['no'], !$locked)."\n";

		echo "              </td>\n";
		echo "            </tr>\n";
		echo "            <tr>\n";
		echo "              <td class=\"posthead\">{$lang['deletepostsinthreadbyuser']}:</td>\n";
		echo "              <td class=\"posthead\">\n";

		echo "                ".form_input_text("deluser", "", 20)."\n";
		echo "                ".form_checkbox("deluser_con", "Y", $lang['confirm'])."\n";

		echo "              </td>\n";
		echo "            </tr>\n";
		echo "            <tr>\n";
		echo "              <td class=\"posthead\">{$lang['deletethread']}:</td>\n";
		echo "              <td class=\"posthead\">\n";

		echo "                ".form_checkbox("delthread", "Y", $lang['yes'])."\n";
		echo "                ".form_checkbox("delthread_con", "Y", $lang['confirm'])."\n";

		echo "              </td>\n";
		echo "            </tr>\n";
	}

	echo "          </table>\n";
	echo "        </td>\n";
	echo "      </tr>\n";
	echo "    </table>\n";
}

echo "    <p><input type=\"submit\" name=\"Submit\" value=\"{$lang['submit']}\" /></p>\n";
echo "  </form>\n";
echo "</div>\n";

html_draw_bottom();

?>