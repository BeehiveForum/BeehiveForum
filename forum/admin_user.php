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

/* $Id: admin_user.php,v 1.71 2004-03-22 12:58:47 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum webtag and settings
$webtag = get_webtag();
$forum_settings = get_forum_settings();

include_once("./include/admin.inc.php");
include_once("./include/attachments.inc.php");
include_once("./include/constants.inc.php");
include_once("./include/db.inc.php");
include_once("./include/edit.inc.php");
include_once("./include/folder.inc.php");
include_once("./include/form.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/ip.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/messages.inc.php");
include_once("./include/perm.inc.php");
include_once("./include/poll.inc.php");
include_once("./include/post.inc.php");
include_once("./include/session.inc.php");
include_once("./include/user.inc.php");

if (!$user_sess = bh_session_check()) {

    $uri = "./logon.php?webtag={$webtag['WEBTAG']}&final_uri=". rawurlencode(get_request_uri());
    header_redirect($uri);
}

// Load the wordfilter for the current user

$user_wordfilter = load_wordfilter();

if (isset($HTTP_GET_VARS['msg']) && validate_msg($HTTP_GET_VARS['msg'])) {
    $ret = "./messages.php?msg={$HTTP_GET_VARS['msg']}";
}elseif (isset($HTTP_POST_VARS['ret'])) {
    $ret = $HTTP_POST_VARS['ret'];
}else {
    $ret = "admin_users.php?webtag={$webtag['WEBTAG']}";
}

if (isset($HTTP_POST_VARS['cancel'])) {
    header_redirect($ret);
}

html_draw_top();

if (!(bh_session_get_value('STATUS') & USER_PERM_SOLDIER)) {
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;
}

if (isset($HTTP_GET_VARS['uid']) && is_numeric($HTTP_GET_VARS['uid'])) {
    $uid = $HTTP_GET_VARS['uid'];
}else if (isset($HTTP_POST_VARS['uid']) && is_numeric($HTTP_POST_VARS['uid'])) {
    $uid = $HTTP_POST_VARS['uid'];
}else {
    echo "<h1>{$lang['invalidop']}</h1>\n";
    echo "<p>{$lang['nouserspecified']}</p>\n";
    html_draw_bottom();
    exit;
}

$user = user_get($uid);

if (!isset($user['STATUS'])) {
  $user['STATUS'] = 0;
}

// Draw the form
echo "<h1>{$lang['admin']} : {$lang['manageuser']} : {$user['LOGON']}</h1>\n";

// Do updates

if (isset($HTTP_POST_VARS['del'])) {

    if (isset($HTTP_POST_VARS['hash']) && is_md5($HTTP_POST_VARS['hash'])) {

        delete_attachment(bh_session_get_value('UID'), $HTTP_POST_VARS['hash']);
    }

}elseif (isset($HTTP_POST_VARS['submit'])) {

    if (isset($HTTP_POST_VARS['t_confirm_delete_posts'])) {

        if ($user_post_array = get_user_posts($uid)) {

            foreach ($user_post_array as $user_post) {
                post_delete($user_post['TID'], $user_post['PID']);
            }

            admin_addlog($uid, 0, 0, 0, 0, 0, 3);
        }

        echo "<p><b>{$lang['usersettingsupdated']}</b></p>\n";        
    
    }elseif (!isset($HTTP_POST_VARS['t_delete_posts']) || (isset($HTTP_POST_VARS['t_delete_posts']) && $HTTP_POST_VARS['t_delete_posts'] = "")) {

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

        // IP Addresses to be banned

        if (isset($HTTP_POST_VARS['t_ban_ipaddress']) && is_array($HTTP_POST_VARS['t_ban_ipaddress'])) {
            $t_ban_ipaddress = $HTTP_POST_VARS['t_ban_ipaddress'];
        }else {
            $t_ban_ipaddress = array();
        }
        
        // Already banned IPs for the selected user.
        
        if (isset($HTTP_POST_VARS['t_ip_banned']) && is_array($HTTP_POST_VARS['t_ip_banned'])) {
            $t_ip_banned = $HTTP_POST_VARS['t_ip_banned'];
        }else {
            $t_ip_banned = array();
        }
        
        // Get the current user's IP. So we don't ban ourselves.
            
        if ($ipaddress = get_ip_address()) {
            
            // Unban the unselected IP adddresses first.
            
            foreach($t_ip_banned as $banned_ip_address) {
                if (!in_array($banned_ip_address, $t_ban_ipaddress)) {
                    unban_ip($banned_ip_address);
                    admin_addlog($uid, 0, 0, 0, 0, 0, 5);
                }
            }
            
            // Ban the selected IP Addresses
            
            foreach($t_ban_ipaddress as $ban_ip_address) {
                if (!ip_is_banned($ban_ip_address)) {
                    if (($t_ban_ipaddress != $ipaddress) && !($user['STATUS'] & PERM_CHECK_SOLDIER)) {
                        ban_ip($ban_ip_address);
                        admin_addlog($uid, 0, 0, 0, 0, 0, 4);
                    }
                }
            }
        }
            
        echo "<p><b>{$lang['usersettingsupdated']}</b></p>\n";
    }
}

echo "<p>&nbsp;</p>\n";
echo "<div align=\"center\">\n";
echo "<form name=\"f_user\" action=\"admin_user.php?webtag={$webtag['WEBTAG']}\" method=\"post\">\n";
echo "  ", form_input_hidden("uid", $uid), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\">{$lang['userstatus']}</td>\n";
echo "                </tr>\n";

if (isset($HTTP_POST_VARS['t_delete_posts'])) {

    echo "                <tr>\n";
    echo "                  <td><h2>{$lang['warning_caps']}</h2></td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td>{$lang['userdeleteallpostswarning']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td>", form_checkbox("t_confirm_delete_posts", 1, $lang['confirm'], false), "</td>\n";
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
    echo "      <td align=\"center\">", form_submit("submit", $lang['submit']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</td>\n";
    echo "    </tr>\n";     
    echo "  </table>\n";
    echo "  ", form_input_hidden("ret", "admin_user.php?webtag={$webtag['WEBTAG']}&uid=$uid"), "\n";

}else if (isset($HTTP_POST_VARS['t_confirm_delete_posts'])) {

    echo "                <tr>\n";
    echo "                  <td>{$lang['postssuccessfullydeleted']}</td>\n";
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
    echo "      <td align=\"center\">", form_submit("submit", $lang['submit']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</td>\n";
    echo "    </tr>\n";     
    echo "  </table>\n";
    echo "  ", form_input_hidden("ret", "admin_user.php?webtag={$webtag['WEBTAG']}&uid=$uid"), "\n";

}else {

    if (bh_session_get_value('STATUS') & USER_PERM_QUEEN) {
        echo "                <tr>\n";
        echo "                  <td align=\"left\">", form_checkbox("t_soldier", USER_PERM_SOLDIER, $lang['soldier'], isset($user['STATUS']) ? ($user['STATUS'] & USER_PERM_SOLDIER) : False), "</td>\n";
        echo "                </tr>\n";
    }

    echo "                <tr>\n";
    echo "                  <td align=\"left\">", form_checkbox("t_worker", USER_PERM_WORKER, $lang['worker'], isset($user['STATUS']) ? ($user['STATUS'] & USER_PERM_WORKER) : False), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\">", form_checkbox("t_worm", USER_PERM_WORM, $lang['worm'], isset($user['STATUS']) ? ($user['STATUS'] & USER_PERM_WORM) : False), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\">", form_checkbox("t_wasp", USER_PERM_WASP, $lang['wasp'], isset($user['STATUS']) ? ($user['STATUS'] & USER_PERM_WASP) : False), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\">", form_checkbox("t_splat", USER_PERM_SPLAT, $lang['splat'], isset($user['STATUS']) ? ($user['STATUS'] & USER_PERM_SPLAT) : FALSE), "</td>\n";
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
    echo "  </table>\n";    
    echo "  <br />\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
    echo "    <tr>\n";
    echo "      <td>\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td class=\"posthead\">\n";    
    echo "              <table class=\"posthead\" width=\"100%\">\n";    
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" align=\"left\">{$lang['folderaccess']}:</td>\n";
    echo "                </tr>\n";

    if ($user_restricted_folder_array = user_get_restricted_folders($uid)) {

        foreach($user_restricted_folder_array as $user_restricted_folder) {
            echo "                <tr>\n";
            echo "                  <td align=\"left\">", form_checkbox("t_fallow[]", $user_restricted_folder['FID'], $user_restricted_folder['TITLE'], (isset($user_restricted_folder['ALLOWED']) && $user_restricted_folder['ALLOWED'] > 0)), "</td>\n";
            echo "                </tr>\n";
        }

    }else {
        echo "                <tr>\n";
        echo "                  <td align=\"left\">{$lang['norestrictedfolders']}</td>\n";
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
    echo "  </table>\n";    
    echo "  <br />\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
    echo "    <tr>\n";
    echo "      <td>\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td class=\"posthead\">\n"; 
    echo "              <table class=\"posthead\" width=\"100%\">\n";        
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" align=\"left\">{$lang['possiblealiases']}:</td>\n";
    echo "                </tr>\n";

    if ($user_alias_array = user_get_aliases($user['UID'])) {
    
        if (sizeof($user_alias_array) > 0) {
        
            echo "                <tr>\n";
	    echo "                  <td>&nbsp;</td>\n";
	    echo "                </tr>\n";    
	    echo "                <tr>\n";
            echo "                  <td>\n";
            echo "                    <table class=\"box\" align=\"center\" width=\"80%\">\n";
	    echo "                      <tr>\n";
            echo "                        <td>\n";
            echo "                          <table class=\"posthead\" width=\"100%\">\n";
            echo "                            <tr>\n";
            echo "                              <td class=\"subhead\">&nbsp;</td>\n";
            echo "                              <td class=\"subhead\" width=\"150\">&nbsp;LOGON</td>\n";
            echo "                              <td class=\"subhead\">&nbsp;IP Address</td>\n";
            echo "                            </tr>\n";        

            foreach ($user_alias_array as $user_alias) {
                echo "                            <tr>\n";
                echo "                              <td align=\"left\">", form_checkbox("t_ban_ipaddress[]", $user_alias['IPADDRESS'], "", ip_is_banned($user_alias['IPADDRESS'])), "</td>\n";
                echo "                              <td align=\"left\">&nbsp;<a href=\"admin_user.php?webtag={$webtag['WEBTAG']}&uid={$user_alias['UID']}\">{$user_alias['LOGON']}</a></td>\n";
                echo "                              <td align=\"left\">&nbsp;{$user_alias['IPADDRESS']}";
            
                if (ip_is_banned($user_alias['IPADDRESS'])) echo form_input_hidden("t_ip_banned[]", $user_alias['IPADDRESS']);

                echo "</td>\n";            
                echo "                            </tr>\n";
            }

	    echo "                            </tr>\n";
	    echo "                          </table>\n";    
	    echo "                        </td>\n";    
	    echo "                      </tr>\n";
            echo "                    </table>\n";
            echo "                  </td>\n";
            echo "                </tr>\n";
            echo "                <tr>\n";
            echo "                  <td align=\"left\">&nbsp;</td>\n";
            echo "                </tr>\n";
            echo "                <tr>\n";
            echo "                  <td class=\"smalltext\" align=\"left\">{$lang['tobananIPaddress']}</td>\n";
            echo "                </tr>\n";                    
        }

    }else {
        
        echo "                <tr>\n";
        echo "                  <td>{$lang['nomatches']}</td>\n";
        echo "                </tr>\n";
    }
    
    echo "                <tr>\n";
    echo "                  <td>&nbsp;</td>\n";
    echo "                </tr>\n";    
    echo "              </table>\n";
    echo "            </td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";    
    echo "  <br />\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
    echo "    <tr>\n";
    echo "      <td>\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td class=\"posthead\">\n";     
    echo "              <table width=\"100%\" align=\"center\">\n";    
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" align=\"left\">{$lang['deleteposts']}:</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\">", form_checkbox("t_delete_posts", 1, $lang['deleteallusersposts'], false), "</td>\n";
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
    echo "  </table>\n";    
    echo "  <br />\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
    echo "    <tr>\n";
    echo "      <td>\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td class=\"posthead\">\n";     
    echo "              <table width=\"100%\" align=\"center\">\n";    
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" align=\"left\">{$lang['attachments']}:</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\">\n";
    echo "                    <table class=\"posthead\" width=\"100%\">\n";

    $total_attachment_size = 0;

    if ($attachments = get_users_attachments($uid)) {

        for ($i = 0; $i < sizeof($attachments); $i++) {

            echo "                      <tr>\n";
            echo "                        <td valign=\"top\" width=\"300\" class=\"postbody\"><img src=\"".style_image('attach.png')."\" width=\"14\" height=\"14\" border=\"0\" />";
            
            if ($attachment_use_old_method) {
                echo "<a href=\"getattachment.php?webtag={$webtag['WEBTAG']}&hash=", $attachments[$i]['hash'], "\" title=\"";
            }else {
                echo "<a href=\"getattachment.php/", $attachments[$i]['hash'], "/", rawurlencode($attachments[$i]['filename']), "?webtag={$webtag['WEBTAG']}\" title=\"";
            }           

            if (strlen($attachments[$i]['filename']) > 16) {
                echo "{$lang['filename']}: ". $attachments[$i]['filename']. ", ";
            }

            if (@$imageinfo = getimagesize(forum_get_setting('attachment_dir'). '/'. md5($attachments[$i]['aid']. rawurldecode($attachments[$i]['filename'])))) {
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
                    echo "                        <td valign=\"top\" width=\"100\" class=\"postbody\"><a href=\"", $messagelink, "\" target=\"_blank\">{$lang['viewmessage']}</a></td>\n";
                }else {
                    echo "                        <td valign=\"top\" width=\"100\" class=\"postbody\">&nbsp;</td>\n";
                }
            }else {
                echo "                        <td valign=\"top\" width=\"100\" class=\"postbody\">&nbsp;</td>\n";
            }

            echo "                        <td align=\"right\" valign=\"top\" width=\"200\" class=\"postbody\">". format_file_size($attachments[$i]['filesize']). "</td>\n";
            echo "                        <td align=\"right\" width=\"100\" class=\"postbody\" nowrap=\"nowrap\" valign=\"top\">\n";
            echo "                          ", form_input_hidden('hash', $attachments[$i]['hash']), "\n";
            echo "                          ", form_submit('del', $lang['del']), "\n";
            echo "                        </td>\n";
            echo "                      </tr>\n";

            $total_attachment_size += $attachments[$i]['filesize'];

        }

    }else {

        echo "                      <tr>\n";
        echo "                        <td valign=\"top\" width=\"300\" class=\"postbody\">{$lang['noattachmentsforuser']}</td>\n";
        echo "                        <td align=\"right\" valign=\"top\" width=\"200\" class=\"postbody\">&nbsp;</td>\n";
        echo "                        <td align=\"right\" width=\"100\" class=\"postbody\">&nbsp;</td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td width=\"300\" class=\"postbody\">&nbsp;</td>\n";
        echo "                        <td width=\"200\" class=\"postbody\">&nbsp;</td>\n";
        echo "                        <td width=\"100\" class=\"postbody\">&nbsp;</td>\n";
        echo "                      </tr>\n";

    }

    echo "                    </table>\n";
    echo "                  </td>\n";
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
    echo "      <td align=\"center\">", form_submit("submit", $lang['submit']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</td>\n";
    echo "    </tr>\n";    
    echo "  </table>\n";
    echo "  ", form_input_hidden("ret", $ret), "\n";
}

if (!isset($HTTP_POST_VARS['t_delete_posts']) && !isset($HTTP_POST_VARS['t_confirm_delete_posts'])) {

    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
    echo "    <tr>\n";
    echo "      <td>\n";
    echo "        <table width=\"100%\" border=\"0\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\">\n";
    echo "              <p>{$lang['soldierdesc']}</p>\n";
    echo "              <p>{$lang['workerdesc']}</p>\n";
    echo "              <p>{$lang['wormdesc']}</p>\n";
    echo "              <p>{$lang['waspdesc']}</p>";
    echo "              <p>{$lang['splatdesc']}</p>";
    echo "              <p>&nbsp;</p>";
    echo "              <p>{$lang['aliasdesc']}</p>\n";
    echo "            </td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";

}

echo "</form>\n";
echo "</div>\n";

html_draw_bottom();

?>