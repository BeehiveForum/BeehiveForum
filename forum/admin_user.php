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

/* $Id: admin_user.php,v 1.47 2003-09-15 19:04:30 decoyduck Exp $ */

// Frameset for thread list and messages

// Enable the error handler
require_once("./include/errorhandler.inc.php");

// Compress the output
require_once("./include/gzipenc.inc.php");

//Check logged in status
require_once("./include/session.inc.php");
require_once("./include/header.inc.php");

if (!bh_session_check()) {
    $uri = "./logon.php?final_uri=". urlencode(get_request_uri());
    header_redirect($uri);
}

require_once("./include/perm.inc.php");
require_once("./include/html.inc.php");
require_once("./include/forum.inc.php");
require_once("./include/db.inc.php");
require_once("./include/user.inc.php");
require_once("./include/constants.inc.php");
require_once("./include/form.inc.php");
require_once("./include/poll.inc.php");
require_once("./include/config.inc.php");
require_once("./include/edit.inc.php");
require_once("./include/ip.inc.php");
require_once("./include/admin.inc.php");
require_once("./include/lang.inc.php");
require_once("./include/post.inc.php");

if (isset($HTTP_POST_VARS['cancel'])) {
    header_redirect($HTTP_POST_VARS['ret']);
}

if (isset($HTTP_GET_VARS['ret'])) {
    $ret = $HTTP_GET_VARS['ret'];
}elseif (isset($HTTP_POST_VARS['ret'])) {
    $ret = $HTTP_POST_VARS['ret'];
}else {
    $ret = "admin_users.php";
}

html_draw_top();

if (!(bh_session_get_value('STATUS') & USER_PERM_SOLDIER)) {
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    // -- html_draw_bottom is now handled by bh_gz_handler -- html_draw_bottom();
    exit;
}

if (isset($HTTP_GET_VARS['uid'])) {
    $uid = $HTTP_GET_VARS['uid'];
}else if(isset($HTTP_POST_VARS['uid'])) {
    $uid = $HTTP_POST_VARS['uid'];
}else {
    echo "<h1>{$lang['invalidop']}</h1>\n";
    echo "<p>{$lang['nouserspecified']}</p>\n";
    // -- html_draw_bottom is now handled by bh_gz_handler -- html_draw_bottom();
    exit;
}

$user = user_get($uid);

if (!isset($user['STATUS'])) {
  $user['STATUS'] = 0;
}

// Do updates

if (isset($HTTP_POST_VARS['submit'])) {

    if ($HTTP_POST_VARS['submit'] == 'Del') {

        unlink($attachment_dir. '/'. md5($HTTP_POST_VARS['aid']. _stripslashes($HTTP_POST_VARS['userfile'])));
        delete_attachment($uid, $HTTP_POST_VARS['aid'], rawurlencode(_stripslashes($HTTP_POST_VARS['userfile'])));
        admin_addlog($uid, 0, 0, 0, 0, 0, 6);

    }else if (isset($HTTP_POST_VARS['t_confirm_delete_posts'])) {

        if ($user_post_array = get_user_posts($uid)) {

            foreach ($user_post_array as $user_post) {
	        post_delete($user_post['TID'], $user_post['PID']);
            }

            admin_addlog($uid, 0, 0, 0, 0, 0, 3);

        }

    }else {

        $t_soldier = (isset($HTTP_POST_VARS['t_soldier'])) ? $HTTP_POST_VARS['t_soldier'] : 0;
        $t_worker  = (isset($HTTP_POST_VARS['t_worker']))  ? $HTTP_POST_VARS['t_worker']  : 0;
        $t_worm    = (isset($HTTP_POST_VARS['t_worm']))    ? $HTTP_POST_VARS['t_worm']    : 0;
        $t_wasp    = (isset($HTTP_POST_VARS['t_wasp']))    ? $HTTP_POST_VARS['t_wasp']    : 0;
        $t_splat   = (isset($HTTP_POST_VARS['t_splat']))   ? $HTTP_POST_VARS['t_splat']   : 0;

        $new_status = $t_worker | $t_worm | $t_wasp | $t_splat;

        if (bh_session_get_value('STATUS') & USER_PERM_QUEEN) {
            $new_status = $new_status | $t_soldier;
            $new_status = $new_status | ($user['STATUS'] & USER_PERM_QUEEN);
        }else {
            $new_status = $new_status | ($user['STATUS'] & USER_PERM_SOLDIER);
            $new_status = $new_status | ($user['STATUS'] & USER_PERM_QUEEN);
        }

        // Add lower ranks automatically
        if ($new_status & USER_PERM_QUEEN) $new_status |= USER_PERM_SOLDIER;
        if ($new_status & USER_PERM_SOLDIER) $new_status |= USER_PERM_WORKER;

        user_update_status($uid, $new_status);
        $user['STATUS'] = $new_status;

        // Add Log entry.
        admin_addlog($uid, 0, 0, 0, 0, 0, 1);

        $user['STATUS'] = $new_status;

        // Get Private folder permissions

	$uf = array();

	if (isset($HTTP_POST_VARS['t_fallow'])) {

	    for ($i = 0; $i < sizeof($HTTP_POST_VARS['t_fallow']); $i++) {
	        $uf[$i]['fid'] = $HTTP_POST_VARS['t_fallow'][$i];
	        $uf[$i]['allowed'] = 1;
	    }
	}

	// Update Private folder permissions

        user_update_folders($uid, $uf);
        admin_addlog($uid, 0, 0, 0, 0, 0, 2);

        // IP Address banning / unbanning

        if (isset($HTTP_POST_VARS['t_ban_ipaddress'])) {

            // Prevent the Queen / Soldiers from banning their own IP address

            $ipaddress = get_ip_address();

            if (($HTTP_POST_VARS['t_ip_address'] != $ipaddress) && !($user['STATUS'] & PERM_CHECK_SOLDIER)) {
                ban_ip($HTTP_POST_VARS['t_ip_address']);
                admin_addlog($uid, 0, 0, 0, 0, 0, 4);
            }

        }elseif (isset($HTTP_POST_VARS['t_ip_banned']) && !isset($HTTP_POST_VARS['t_ban_ipaddress'])) {
            unban_ip($HTTP_POST_VARS['t_ip_address']);
            admin_addlog($uid, 0, 0, 0, 0, 0, 5);
        }
    }
}

// Draw the form
echo "<h1>{$lang['manageuser']}</h1>\n";
echo "<p><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></p>\n";
echo "<div align=\"center\">\n";

if (isset($HTTP_POST_VARS['t_delete_posts'])) {

    echo "<form name=\"f_user\" action=\"", $HTTP_SERVER_VARS['PHP_SELF'], "\" method=\"post\">\n";
    echo "<table width=\"50%\">\n";
    echo "  <tr>\n";
    echo "    <td class=\"box\">\n";
    echo "      <table class=\"posthead\" width=\"100%\">\n";
    echo "        <tr>\n";
    echo "          <td class=\"subhead\">{$lang['userstatus']}: ", $user['LOGON'], "</td>\n";
    echo "        </tr>\n";
    echo "        <tr>\n";
    echo "          <td><h2>{$lang['warning_caps']}</h2></td>\n";
    echo "        </tr>\n";
    echo "        <tr>\n";
    echo "          <td>{$lang['userdeleteallpostswarning']}</td>\n";
    echo "        </tr>\n";
    echo "        <tr>\n";
    echo "          <td>", form_checkbox("t_confirm_delete_posts", 1, $lang['confirm'], false), "</td>\n";
    echo "        </tr>\n";
    echo "      </table>\n";
    echo "      ", form_input_hidden("uid", $uid), form_input_hidden("ret", "admin_user.php?uid=$uid"), "\n";
    echo "    </td>\n";
    echo "  </tr>\n";
    echo "</table>\n";
    echo "<p>", form_submit("submit", $lang['submit']), "<bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo>", form_submit("cancel", $lang['cancel']), "</p>\n";
    echo "</form>\n";

}else if (isset($HTTP_POST_VARS['t_confirm_delete_posts'])) {

    echo "<form name=\"f_user\" action=\"", $HTTP_SERVER_VARS['PHP_SELF'], "\" method=\"get\">\n";
    echo "<table width=\"50%\">\n";
    echo "  <tr>\n";
    echo "    <td class=\"box\">\n";
    echo "      <table class=\"posthead\" width=\"100%\">\n";
    echo "        <tr>\n";
    echo "          <td class=\"subhead\">{$lang['userstatus']}: ", $user['LOGON'], "</td>\n";
    echo "        </tr>\n";
    echo "        <tr>\n";
    echo "          <td>{$lang['postssuccessfullydeleted']}</td>\n";
    echo "        </tr>\n";
    echo "      </table>\n";
    echo "      ", form_input_hidden("uid", $uid), form_input_hidden("ret", $ret), "\n";
    echo "    </td>\n";
    echo "  </tr>\n";
    echo "</table>\n";
    echo "<p>", form_submit("submit", $lang['continue']), "</p>\n";
    echo "</form>\n";

}else {

    echo "<form name=\"f_user\" action=\"", $HTTP_SERVER_VARS['PHP_SELF'], "\" method=\"post\">\n";
    echo "<table width=\"50%\">\n";
    echo "  <tr>\n";
    echo "    <td class=\"box\">\n";
    echo "      <table class=\"posthead\" width=\"100%\">\n";
    echo "        <tr>\n";
    echo "          <td class=\"subhead\" align=\"left\">{$lang['userstatus']}: ", $user['LOGON'], "</td>\n";
    echo "        </tr>\n";

    if (bh_session_get_value('STATUS') & USER_PERM_QUEEN) {
        echo "        <tr>\n";
        echo "          <td align=\"left\">", form_checkbox("t_soldier", USER_PERM_SOLDIER, $lang['soldier'], isset($user['STATUS']) ? ($user['STATUS'] & USER_PERM_SOLDIER) : False), "</td>\n";
        echo "        </tr>\n";
    }

    echo "        <tr>\n";
    echo "          <td align=\"left\">", form_checkbox("t_worker", USER_PERM_WORKER, $lang['worker'], isset($user['STATUS']) ? ($user['STATUS'] & USER_PERM_WORKER) : False), "</td>\n";
    echo "        </tr>\n";
    echo "        <tr>\n";
    echo "          <td align=\"left\">", form_checkbox("t_worm", USER_PERM_WORM, $lang['worm'], isset($user['STATUS']) ? ($user['STATUS'] & USER_PERM_WORM) : False), "</td>\n";
    echo "        </tr>\n";
    echo "        <tr>\n";
    echo "          <td align=\"left\">", form_checkbox("t_wasp", USER_PERM_WASP, $lang['wasp'], isset($user['STATUS']) ? ($user['STATUS'] & USER_PERM_WASP) : False), "</td>\n";
    echo "        </tr>\n";
    echo "        <tr>\n";
    echo "          <td align=\"left\">", form_checkbox("t_splat", USER_PERM_SPLAT, $lang['splat'], isset($user['STATUS']) ? ($user['STATUS'] & USER_PERM_SPLAT) : FALSE), "</td>\n";
    echo "        </tr>\n";
    echo "        <tr>\n";
    echo "          <td><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></td>\n";
    echo "        </tr>\n";
    echo "        <tr>\n";
    echo "          <td class=\"subhead\" align=\"left\">{$lang['folderaccess']}:</td>\n";
    echo "        </tr>\n";

    if ($user_restricted_folder_array = user_get_restricted_folders($uid)) {

        foreach($user_restricted_folder_array as $user_restricted_folder) {
            echo "        <tr>\n";
            echo "          <td align=\"left\">", form_checkbox("t_fallow[]", $user_restricted_folder['FID'], $user_restricted_folder['TITLE'], (isset($user_restricted_folder['ALLOWED']) && $user_restricted_folder['ALLOWED'] > 0)), "</td>\n";
            echo "        </tr>\n";
        }

    }else {
        echo "        <tr>\n";
        echo "          <td align=\"left\">{$lang['norestrictedfolders']}</td>\n";
        echo "        </tr>\n";
    }

    echo "        <tr>\n";
    echo "          <td align=\"left\">&nbsp;</td>\n";
    echo "        </tr>\n";
    echo "        <tr>\n";
    echo "          <td class=\"subhead\" align=\"left\">{$lang['possiblealiases']}";

    if (isset($user['LOGON_FROM']) && strlen($user['LOGON_FROM']) > 0) {
        echo "(IP: ", $user['LOGON_FROM'], ") ";
    }

    echo ":</td>\n";
    echo "        </tr>\n";

    if ($user_alias_array = user_get_by_ipaddress($user['LOGON_FROM'], $user['UID'])) {

        foreach ($user_alias_array as $user_alias) {
            echo "        <tr>\n";
            echo "          <td align=\"left\"><a href=\"admin_user.php?uid=", $user_alias['UID'], "\">", $user_alias['LOGON'], "</a></td>\n";
            echo "        </tr>\n";
        }

    }else {
        echo "        <tr>\n";
        echo "          <td align=\"left\">{$lang['nomatches']}</td>\n";
        echo "        </tr>\n";
    }

    echo "        <tr>\n";
    echo "          <td align=\"left\"><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></td>\n";
    echo "        </tr>\n";

    if ($user['STATUS'] & PERM_CHECK_SOLDIER) {

        echo "        <tr>\n";
        echo "          <td class=\"smalltext\" align=\"left\">{$lang['cannotipbansoldiers']}</td>\n";
        echo "        </tr>\n";

    }elseif (isset($user['LOGON_FROM']) && strlen($user['LOGON_FROM']) > 0) {

        echo "        <tr>\n";
        echo "          <td align=\"left\">", form_checkbox("t_ban_ipaddress", 1, $lang['banthisipaddress'], ip_is_banned($user['LOGON_FROM'])), form_input_hidden("t_ip_address", $user['LOGON_FROM']);

        if (ip_is_banned($user['LOGON_FROM'])) {
            echo form_input_hidden("t_ip_banned", 1);
        }

        echo "</td>\n";
        echo "        </tr>\n";

    }else {

        echo "        <tr>\n";
        echo "          <td class=\"smalltext\" align=\"left\">{$lang['noipaddress']}</td>\n";
        echo "        </tr>\n";

    }

    echo "        <tr>\n";
    echo "          <td><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></td>\n";
    echo "        </tr>\n";
    echo "        <tr>\n";
    echo "          <td class=\"subhead\" align=\"left\">{$lang['deleteposts']}:</td>\n";
    echo "        </tr>\n";
    echo "        <tr>\n";
    echo "          <td align=\"left\">", form_checkbox("t_delete_posts", 1, $lang['deleteallusersposts'], false), "</td>\n";
    echo "        </tr>\n";
    echo "        <tr>\n";
    echo "          <td><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></td>\n";
    echo "        </tr>\n";
    echo "        <tr>\n";
    echo "          <td class=\"subhead\" align=\"left\">{$lang['attachments']}:</td>\n";
    echo "        </tr>\n";
    echo "        <tr>\n";
    echo "          <td align=\"left\">\n";
    echo "            <table class=\"posthead\" width=\"100%\">\n";

    $total_attachment_size = 0;

    if ($attachments = get_users_attachments($uid)) {

        for ($i = 0; $i < sizeof($attachments); $i++) {

            echo "              <tr>\n";
            echo "                <td valign=\"top\" width=\"300\" class=\"postbody\"><img src=\"".style_image('attach.png')."\" width=\"14\" height=\"14\" border=\"0\" /><a href=\"getattachment.php/", $attachments[$i]['hash'], "/", $attachments[$i]['filename'], "\" title=\"";

            if (strlen($attachments[$i]['filename']) > 16) {
                echo "{$lang['filename']}: ". $attachments[$i]['filename']. ", ";
            }

            if (@$imageinfo = getimagesize($attachment_dir. '/'. md5($attachments[$i]['aid']. rawurldecode($attachments[$i]['filename'])))) {
                echo "{$lang['dimensions']}: ". $imageinfo[0]. " x ". $imageinfo[1]. ", ";
            }

            echo "{$lang['size']}: ". format_file_size($attachments[$i]['filesize']). ", ";
            echo "{$lang['downloaded']}: ". $attachments[$i]['downloads'];

            if ($attachments[$i]['downloads'] == 1) {
                echo " {$lang['time']}";
            }else {
                echo " {$lang['times']}";
            }

            echo "\">";

            if (strlen($attachments[$i]['filename']) > 16) {
                echo substr($attachments[$i]['filename'], 0, 16). "...</a></td>\n";
            }else{
                echo $attachments[$i]['filename']. "</a></td>\n";
            }

            if ($messagelink = get_message_link($attachments[$i]['aid'])) {
                if (strstr($messagelink, 'messages.php')) {
                    echo "                <td valign=\"top\" width=\"100\" class=\"postbody\"><a href=\"", $messagelink, "\" target=\"_blank\">{$lang['viewmessage']}</a></td>\n";
                }else {
                    echo "                <td valign=\"top\" width=\"100\" class=\"postbody\">{$lang['messageunavailable']}</td>\n";
                }
            }else {
                echo "                <td valign=\"top\" width=\"100\" class=\"postbody\">{$lang['messageunavailable']}</td>\n";
            }

            echo "                <td align=\"right\" valign=\"top\" width=\"200\" class=\"postbody\">". format_file_size($attachments[$i]['filesize']). "</td>\n";
            echo "                <td align=\"right\" width=\"100\" class=\"postbody\" nowrap=\"nowrap\" valign=\"top\">\n";
            echo "                  ". form_input_hidden('userfile', $attachments[$i]['filename']);
            echo "                  ". form_input_hidden('aid', $attachments[$i]['aid']);
            echo "                  ". form_submit('submit', $lang['del']). "\n";
            echo "                </td>\n";
            echo "              </tr>\n";

            $total_attachment_size += $attachments[$i]['filesize'];

        }

    }else {

        echo "              <tr>\n";
        echo "                <td valign=\"top\" width=\"300\" class=\"postbody\">{$lang['noattachmentsforuser']}</td>\n";
        echo "                <td align=\"right\" valign=\"top\" width=\"200\" class=\"postbody\"><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></td>\n";
        echo "                <td align=\"right\" width=\"100\" class=\"postbody\"><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></td>\n";
        echo "              </tr>\n";
        echo "              <tr>\n";
        echo "                <td width=\"300\" class=\"postbody\"><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></td>\n";
        echo "                <td width=\"200\" class=\"postbody\"><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></td>\n";
        echo "                <td width=\"100\" class=\"postbody\"><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></td>\n";
        echo "              </tr>\n";

    }

    echo "            </table>\n";
    echo "          </td>\n";
    echo "        </tr>\n";
    echo "      </table>\n";
    echo "      ", form_input_hidden("uid", $uid), form_input_hidden("ret", $ret), "\n";
    echo "    </td>\n";
    echo "  </tr>\n";
    echo "</table>\n";
    echo "<p>", form_submit("submit", $lang['submit']), "<bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo>", form_submit("cancel", $lang['cancel']), "</p>\n";
    echo "</form>\n";

}

if (!isset($HTTP_POST_VARS['t_delete_posts']) && !isset($HTTP_POST_VARS['t_confirm_delete_posts'])) {

    echo "<p><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></p>\n";
    echo "<table width=\"50%\" border=\"0\">\n";
    echo "  <tr>\n";
    echo "    <td align=\"left\">\n";
    echo "      <p>{$lang['soldierdesc']}</p>\n";
    echo "      <p>{$lang['workerdesc']}</p>\n";
    echo "      <p>{$lang['wormdesc']}</p>\n";
    echo "      <p>{$lang['waspdesc']}</p>";
    echo "      <p>{$lang['splatdesc']}</p>";
    echo "      <p><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></p>";
    echo "      <p>{$lang['aliasdesc']}</p>\n";
    echo "    </td>\n";
    echo "  </tr>\n";
    echo "</table>\n";

}

echo "</div>\n";

// -- html_draw_bottom is now handled by bh_gz_handler -- html_draw_bottom();

?>