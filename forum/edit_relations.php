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

/* $Id: edit_relations.php,v 1.3 2004-03-02 00:27:04 decoyduck Exp $ */

// Compress the output
require_once("./include/gzipenc.inc.php");

// Enable the error handler
require_once("./include/errorhandler.inc.php");

//Check logged in status
require_once("./include/session.inc.php");
require_once("./include/header.inc.php");

if (!bh_session_check()) {

    $uri = "./logon.php?final_uri=". urlencode(get_request_uri());
    header_redirect($uri);
}

if (bh_session_get_value('UID') == 0) {
    html_guest_error();
    exit;
}

require_once("./include/html.inc.php");
require_once("./include/user.inc.php");
require_once("./include/post.inc.php");
require_once("./include/fixhtml.inc.php");
require_once("./include/form.inc.php");
require_once("./include/header.inc.php");
require_once("./include/lang.inc.php");
require_once("./include/user_rel.inc.php");

// Start output here

html_draw_top("openprofile.js", "basetarget=_blank");

echo "<h1>{$lang['userrelationships']}</h1>\n";

$uid = bh_session_get_value('UID');

if (isset($HTTP_POST_VARS['submit'])) {
    if (isset($HTTP_POST_VARS['relationship']) && is_array($HTTP_POST_VARS['relationship'])) {
        foreach ($HTTP_POST_VARS['relationship'] as $peer_uid => $peer_rel) {
            if (isset($HTTP_POST_VARS['signature'][$peer_uid])) {
                $peer_rel = $peer_rel | $HTTP_POST_VARS['signature'][$peer_uid];
            }
            user_rel_update($uid, $peer_uid, $peer_rel);
        }
    }
}

if (isset($HTTP_POST_VARS['add'])) {
    if (isset($HTTP_POST_VARS['add_relationship']) && is_array($HTTP_POST_VARS['add_relationship'])) {
        foreach ($HTTP_POST_VARS['add_relationship'] as $peer_uid => $peer_rel) {
            if (isset($HTTP_POST_VARS['add_signature'][$peer_uid])) {
                $peer_rel = $peer_rel | $HTTP_POST_VARS['add_signature'][$peer_uid];
            }
            if ($peer_uid != $uid) {
                user_rel_update($uid, $peer_uid, $peer_rel);
            }
        }
    }
}

if (isset($HTTP_GET_VARS['page']) && is_numeric($HTTP_GET_VARS['page'])) {
    $start = $HTTP_GET_VARS['page'] * 20;
}else {
    $start = 0;
}

// Any error messages to display?

if (!empty($error_html)) {
    echo $error_html;
}else if (isset($HTTP_GET_VARS['updated'])) {
    echo "<h2>{$lang['preferencesupdated']}</h2>\n";
}

if ($user_peers = user_get_relationships($uid, $start)) {

    echo "<br />\n";
    echo "<div class=\"postbody\">\n";
    echo "  <form name=\"prefs\" action=\"edit_relations.php\" method=\"post\" target=\"_self\">\n";
    
    if (isset($HTTP_POST_VARS['usersearch']) && strlen(trim($HTTP_POST_VARS['usersearch'])) > 0) {
        echo "    ", form_input_hidden("usersearch", trim($HTTP_POST_VARS['usersearch'])), "\n";
    }
    
    echo "    <table cellpadding=\"0\" cellspacing=\"0\" width=\"80%\">\n";
    echo "      <tr>\n";
    echo "        <td>\n";
    echo "          <table class=\"box\" width=\"100%\">\n";
    echo "            <tr>\n";
    echo "              <td class=\"posthead\">\n";
    echo "                <table class=\"posthead\" width=\"100%\">\n";
    echo "                  <tr>\n";
    echo "                    <td width=\"50%\" class=\"subhead\">&nbsp;{$lang['user']}</td>\n";
    echo "                    <td class=\"subhead\">&nbsp;{$lang['relationship']}</td>\n";
    echo "                    <td class=\"subhead\">&nbsp;{$lang['signature']}</td>\n";    
    echo "                  </tr>\n";
    
    foreach ($user_peers as $user_peer) {
        echo "                  <tr>\n";    
        echo "                    <td>&nbsp;<a href=\"javascript:void(0);\" onclick=\"openProfile({$user_peer['UID']})\" target=\"_self\">", format_user_name($user_peer['LOGON'], $user_peer['NICKNAME']), "</a></td>\n";
        echo "                    <td>\n";
        echo "                      &nbsp;", form_radio("relationship[{$user_peer['UID']}]", USER_FRIEND, "", ($user_peer['RELATIONSHIP'] & USER_FRIEND)), "<img src=\"", style_image("friend.png"), "\" alt=\"\" title=\"Friend\" />\n";
        echo "                      &nbsp;", form_radio("relationship[{$user_peer['UID']}]", 0, "", !($user_peer['RELATIONSHIP'] & USER_FRIEND) && !($user_peer['RELATIONSHIP'] & USER_IGNORED)), "{$lang['normal']}\n";
        echo "                      &nbsp;", form_radio("relationship[{$user_peer['UID']}]", USER_IGNORED, "", ($user_peer['RELATIONSHIP'] & USER_IGNORED)), "<img src=\"", style_image("enemy.png"), "\" alt=\"\" title=\"Ignored\" />\n";
        echo "                    </td>\n";
        echo "                    <td>\n";
        echo "                      &nbsp;", form_radio("signature[{$user_peer['UID']}]", 0, "", !($user_peer['RELATIONSHIP'] & USER_IGNORED_SIG)), "{$lang['display']}\n";
        echo "                      &nbsp;", form_radio("signature[{$user_peer['UID']}]", USER_IGNORED_SIG, "", ($user_peer['RELATIONSHIP'] & USER_IGNORED_SIG)), "{$lang['ignore']}\n";        
        echo "                    </td>\n";        
        echo "                  </tr>\n";
    }

    echo "                  <tr>\n";
    echo "                    <td>&nbsp;</td>\n";
    echo "                  </tr>\n";
    echo "                </table>\n";
    echo "              </td>\n";
    echo "            </tr>\n";
    echo "          </table>\n";
    echo "        </td>\n";
    echo "      </tr>\n";

    if (sizeof($user_peers) == 20) {
        if ($start < 20) {
            echo "      <tr>\n";
            echo "        <td align=\"center\"><p><img src=\"", style_image('post.png'), "\" height=\"15\" alt=\"\" />&nbsp;<a href=\"edit_relations.php?page=", ($start / 20) + 1, "&amp;usersearch=$usersearch\" target=\"_self\">{$lang['more']}</a></p></td>\n";
            echo "      </tr>\n";
        }elseif ($start >= 20) {
            echo "      <tr>\n";
            echo "        <td align=\"center\">\n";
            echo "          <p><img src=\"", style_image('post.png'), "\" height=\"15\" alt=\"\" />&nbsp;<a href=\"edit_relations.php?page=", ($start / 20) - 1, "&amp;usersearch=$usersearch\" target=\"_self\">{$lang['back']}</a>&nbsp;&nbsp;";
            echo "          <img src=\"", style_image('post.png'), "\" height=\"15\" alt=\"\" />&nbsp;<a href=\"edit_relations.php?page=", ($start / 20) + 1, "&amp;usersearch=$usersearch\" target=\"_self\">{$lang['more']}</a></p>\n";
            echo "        </td>\n";
            echo "      </tr>\n";
        }
    }else {
        if ($start >= 20) {
            echo "      <tr>\n";
            echo "        <td align=\"center\">\n";
            echo "          <p><img src=\"", style_image('post.png'), "\" height=\"15\" alt=\"\" />&nbsp;<a href=\"edit_relations.php?page=", ($start / 20) - 1, "&amp;usersearch=$usersearch\" target=\"_self\">{$lang['back']}</a></p>\n";
            echo "        </td>\n";
            echo "      </td>\n";
        }
    }   
    
    echo "      <tr>\n";
    echo "        <td align=\"center\"><p>", form_submit("submit", $lang['save']), "</p></td>\n";
    echo "      </tr>\n";    
    echo "    </table>\n";
    echo "  </form>\n";    
    echo "</div>\n";
    echo "<br />\n";
}

if (isset($HTTP_POST_VARS['usersearch']) && strlen(trim($HTTP_POST_VARS['usersearch'])) > 0) {

    $usersearch = trim($HTTP_POST_VARS['usersearch']);
    
    echo "<div class=\"postbody\">\n";
    echo "  <form method=\"post\" action=\"edit_relations.php\" target=\"_self\">\n";
    echo "    ", form_input_hidden("usersearch", $usersearch), "\n";
    echo "    <table cellpadding=\"0\" cellspacing=\"0\" width=\"80%\">\n";
    echo "      <tr>\n";
    echo "        <td class=\"posthead\">\n";
    echo "          <table class=\"box\" width=\"100%\">\n";
    echo "            <tr>\n";
    echo "              <td class=\"posthead\">\n";
    echo "                <table class=\"posthead\" width=\"100%\">\n";
    echo "                  <tr>\n";
    echo "                    <td width=\"50%\" class=\"subhead\">&nbsp;{$lang['user']}</td>\n";
    echo "                    <td class=\"subhead\">&nbsp;{$lang['relationship']}</td>\n";
    echo "                    <td class=\"subhead\">&nbsp;{$lang['signature']}</td>\n";    
    echo "                  </tr>\n";
    
    if ($user_search_array = user_search($usersearch)) {
    
        foreach ($user_search_array as $user) {
        
            if ($user['UID'] != $uid) {
        
                echo "                  <tr>\n";
                echo "                    <td>&nbsp;<a href=\"javascript:void(0);\" onclick=\"openProfile({$user_peer['UID']})\" target=\"_self\">", format_user_name($user['LOGON'], $user['NICKNAME']), "</a></td>\n";
                echo "                    <td>\n";
                echo "                      &nbsp;", form_radio("add_relationship[{$user['UID']}]", USER_FRIEND, "", false), "<img src=\"", style_image("friend.png"), "\" alt=\"\" title=\"Friend\" />\n";
                echo "                      &nbsp;", form_radio("add_relationship[{$user['UID']}]", 0, "", true), "{$lang['normal']}\n";
                echo "                      &nbsp;", form_radio("add_relationship[{$user['UID']}]", USER_IGNORED, "", false), "<img src=\"", style_image("enemy.png"), "\" alt=\"\" title=\"Ignored\" />\n";
                echo "                    </td>\n";
                echo "                    <td>\n";
                echo "                      &nbsp;", form_radio("add_signature[{$user['UID']}]", 0, "", true), "{$lang['display']}\n";
                echo "                      &nbsp;", form_radio("add_signature[{$user['UID']}]", USER_IGNORED_SIG, "", false), "{$lang['ignore']}\n";        
                echo "                    </td>\n";            
                echo "                  </tr>\n";
            }
        }

    }else {
    
        echo "        <tr>\n";
        echo "          <td class=\"posthead\" colspan=\"7\" align=\"left\">{$lang['nomatches']}</td>\n";
        echo "        </tr>\n";
    }
    
    echo "                  <tr>\n";
    echo "                    <td>&nbsp;</td>\n";
    echo "                  </tr>\n";
    echo "                </table>\n";
    echo "              </td>\n";
    echo "            </tr>\n";
    echo "          </table>\n";
    echo "        </td>\n";
    echo "      </tr>\n";
    echo "      <tr>\n";
    echo "        <td align=\"center\"><p>", form_submit("add", $lang['add']), "</p></td>\n";
    echo "      </tr>\n";     
    echo "    </table>\n";
    echo "  </form>\n";
    echo "</div>\n";    
    
}

echo "<div class=\"postbody\">\n";
echo "  <form method=\"post\" action=\"edit_relations.php\" target=\"_self\">\n";
echo "    <table cellpadding=\"0\" cellspacing=\"0\" width=\"80%\">\n";
echo "      <tr>\n";
echo "        <td class=\"posthead\">\n";
echo "          <table class=\"box\" width=\"100%\">\n";
echo "            <tr>\n";
echo "              <td class=\"posthead\">\n";
echo "                <table class=\"posthead\" width=\"100%\">\n";
echo "                  <tr>\n";
echo "                    <td class=\"subhead\" align=\"left\">{$lang['search']}:</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td class=\"posthead\" align=\"left\">\n";
echo "                      {$lang['username']}: ", form_input_text("usersearch", isset($usersearch) ? $usersearch : "", 30, 64), " ", form_submit('submit', $lang['search']), "\n";
echo "                    </td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td>&nbsp;</td>\n";
echo "                  </tr>\n";
echo "                </table>\n";
echo "              </td>\n";
echo "            </tr>\n";
echo "          </table>\n";
echo "        </td>\n";
echo "      </tr>\n";
echo "    </table>\n";
echo "  </form>\n";
echo "</div>\n";

html_draw_bottom();

?>