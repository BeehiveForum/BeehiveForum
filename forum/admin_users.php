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

/* $Id: admin_users.php,v 1.67 2004-04-10 16:35:00 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Multiple forum support
include_once("./include/forum.inc.php");

// Check we have a webtag

if (!$webtag = get_webtag()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?final_uri=$request_uri");
}

// We got this far we should now read the forum settings

$forum_settings = get_forum_settings();

include_once("./include/admin.inc.php");
include_once("./include/constants.inc.php");
include_once("./include/db.inc.php");
include_once("./include/format.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/perm.inc.php");
include_once("./include/session.inc.php");

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

// Load the wordfilter for the current user

$user_wordfilter = load_wordfilter();

html_draw_top();

if (!(bh_session_get_value('STATUS') & USER_PERM_SOLDIER)) {
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;
}

// Friendly display names for column sorting

$sort_by_array = array('USER.UID'        => 'UID',
                     'USER.LOGON'      => 'LOGON',
                     'USER.NICKNAME'   => 'NICKNAME',
                     'USER.STATUS'     => 'STATUS',
                     'USER.LAST_LOGON' => 'LAST_LOGON',
                     'SESSIONS.SESSID' => 'SESSID');
               
// Column sorting stuff               

if (isset($HTTP_GET_VARS['sort_by'])) {
    if ($HTTP_GET_VARS['sort_by'] == "UID") {
        $sort_by = "USER.UID";
    } elseif ($HTTP_GET_VARS['sort_by'] == "LOGON") {
        $sort_by = "USER.LOGON";
    } elseif ($HTTP_GET_VARS['sort_by'] == "NICKNAME") {
        $sort_by = "USER.NICKNAME";
    } elseif ($HTTP_GET_VARS['sort_by'] == "STATUS") {
        $sort_by = "USER.STATUS";
    } elseif ($HTTP_GET_VARS['sort_by'] == "LAST_LOGON") {
        $sort_by = "USER.LAST_LOGON";
    } elseif ($HTTP_GET_VARS['sort_by'] == "SESSID") {
        $sort_by = "SESSIONS.SESSID";        
    } else {
        $sort_by = "USER.LAST_LOGON";
    }
} else {
    $sort_by = "USER.LAST_LOGON";
}

if (isset($HTTP_GET_VARS['sort_dir'])) {
    if ($HTTP_GET_VARS['sort_dir'] == "DESC") {
        $sort_dir = "DESC";
    } else {
        $sort_dir = "ASC";
    }
} else {
    $sort_dir = "DESC";
}

if (isset($HTTP_GET_VARS['page']) && is_numeric($HTTP_GET_VARS['page'])) {
    $start = $HTTP_GET_VARS['page'] * 20;
}else {
    $start = 0;
}

if (isset($HTTP_GET_VARS['usersearch']) && strlen(trim($HTTP_GET_VARS['usersearch'])) > 0) {
    $usersearch = trim($HTTP_GET_VARS['usersearch']);
}else {
    $usersearch = "";
}

if (isset($HTTP_GET_VARS['reset'])) {
    $usersearch = "";
}

// Draw the form
echo "<h1>{$lang['admin']} : {$lang['manageusers']}</h1>\n";

if (isset($HTTP_POST_VARS['t_kick'])) {
    list($user_uid) = array_keys($HTTP_POST_VARS['t_kick']);
    if (admin_session_end($user_uid)) {
        $admin_uid = bh_session_get_value('UID');
        admin_addlog($admin_uid, 0, 0, 0, 0, $user_uid, 27);
        echo "<p><b>{$lang['sessionsuccessfullyended']}: <a href=\"javascript:void(0)\" onclick=\"openProfile($user_uid, '$webtag')\" target=\"_self\">", user_get_logon($user_uid), "</a></b></p>\n";
    }
}

echo "<p>{$lang['manageusersexp_1']} '{$sort_by_array[$sort_by]}'. {$lang['manageusersexp_2']}</p>\n";
echo "<div align=\"center\">\n";
echo "<form action=\"admin_users.php?webtag=$webtag\" method=\"post\">\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"96%\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "               <table width=\"100%\">\n";
echo "                 <tr>\n";

if ($sort_by == 'USER.UID' && $sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&sort_by=UID&amp;sort_dir=DESC&amp;usersearch=$usersearch&amp;page=", ($start / 20), "\">UID&nbsp;<img src=\"", style_image("sort_asc.png"), "\" width=\"11\" border=\"0\" alt=\"\" /></a></td>\n";
}elseif ($sort_by == 'USER.UID' && $sort_dir == 'DESC') {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&sort_by=UID&amp;sort_dir=ASC&amp;usersearch=$usersearch&amp;page=", ($start / 20), "\">UID&nbsp;<img src=\"", style_image("sort_desc.png"), "\" width=\"11\" border=\"0\" alt=\"\" /></a></td>\n";
}elseif ($sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&sort_by=UID&amp;sort_dir=ASC&amp;usersearch=$usersearch&amp;page=", ($start / 20), "\">UID</a></td>\n";
}else {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&sort_by=UID&amp;sort_dir=DESC&amp;usersearch=$usersearch&amp;page=", ($start / 20), "\">UID</a></td>\n";
}

if ($sort_by == 'USER.LOGON' && $sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&sort_by=LOGON&amp;sort_dir=DESC&amp;usersearch=$usersearch&amp;page=", ($start / 20), "\">{$lang['logon']}&nbsp;<img src=\"", style_image("sort_asc.png"), "\" width=\"11\" border=\"0\" alt=\"\" /></a></td>\n";
}elseif ($sort_by == 'USER.LOGON' && $sort_dir == 'DESC') {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&sort_by=LOGON&amp;sort_dir=ASC&amp;usersearch=$usersearch&amp;page=", ($start / 20), "\">{$lang['logon']}&nbsp;<img src=\"", style_image("sort_desc.png"), "\" width=\"11\" border=\"0\" alt=\"\" /></a></td>\n";
}elseif ($sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&sort_by=LOGON&amp;sort_dir=ASC&amp;usersearch=$usersearch&amp;page=", ($start / 20), "\">{$lang['logon']}</a></td>\n";
}else {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&sort_by=LOGON&amp;sort_dir=DESC&amp;usersearch=$usersearch&amp;page=", ($start / 20), "\">{$lang['logon']}</a></td>\n";
}

if ($sort_by == 'USER.STATUS' && $sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&sort_by=STATUS&amp;sort_dir=DESC&amp;usersearch=$usersearch&amp;page=", ($start / 20), "\">{$lang['status']}&nbsp;<img src=\"", style_image("sort_asc.png"), "\" width=\"11\" border=\"0\" alt=\"\" /></a></td>\n";
}elseif ($sort_by == 'USER.STATUS' && $sort_dir == 'DESC') {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&sort_by=STATUS&amp;sort_dir=ASC&amp;usersearch=$usersearch&amp;page=", ($start / 20), "\">{$lang['status']}&nbsp;<img src=\"", style_image("sort_desc.png"), "\" width=\"11\" border=\"0\" alt=\"\" /></a></td>\n";
}elseif ($sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&sort_by=STATUS&amp;sort_dir=ASC&amp;usersearch=$usersearch&amp;page=", ($start / 20), "\">{$lang['status']}</a></td>\n";
}else {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&sort_by=STATUS&amp;sort_dir=DESC&amp;usersearch=$usersearch&amp;page=", ($start / 20), "\">{$lang['status']}</a></td>\n";
}

if ($sort_by == 'USER.LAST_LOGON' && $sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&sort_by=LAST_LOGON&amp;sort_dir=DESC&amp;usersearch=$usersearch&amp;page=", ($start / 20), "\">{$lang['lastlogon']}&nbsp;<img src=\"", style_image("sort_asc.png"), "\" width=\"11\" border=\"0\" alt=\"\" /></a></td>\n";
}elseif ($sort_by == 'USER.LAST_LOGON' && $sort_dir == 'DESC') {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&sort_by=LAST_LOGON&amp;sort_dir=ASC&amp;usersearch=$usersearch&amp;page=", ($start / 20), "\">{$lang['lastlogon']}&nbsp;<img src=\"", style_image("sort_desc.png"), "\" width=\"11\" border=\"0\" alt=\"\" /></a></td>\n";
}elseif ($sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&sort_by=LAST_LOGON&amp;sort_dir=ASC&amp;usersearch=$usersearch&amp;page=", ($start / 20), "\">{$lang['lastlogon']}</a></td>\n";
}else {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&sort_by=LAST_LOGON&amp;sort_dir=DESC&amp;usersearch=$usersearch&amp;page=", ($start / 20), "\">{$lang['lastlogon']}</a></td>\n";
}

if ($sort_by == 'SESSIONS.SESSID' && $sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&sort_by=SESSID&amp;sort_dir=DESC&amp;usersearch=$usersearch&amp;page=", ($start / 20), "\">{$lang['active']}&nbsp;<img src=\"", style_image("sort_asc.png"), "\" width=\"11\" border=\"0\" alt=\"\" /></a></td>\n";
}elseif ($sort_by == 'SESSIONS.SESSID' && $sort_dir == 'DESC') {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&sort_by=SESSID&amp;sort_dir=ASC&amp;usersearch=$usersearch&amp;page=", ($start / 20), "\">{$lang['active']}&nbsp;<img src=\"", style_image("sort_desc.png"), "\" width=\"11\" border=\"0\" alt=\"\" /></a></td>\n";
}elseif ($sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&sort_by=SESSID&amp;sort_dir=ASC&amp;usersearch=$usersearch&amp;page=", ($start / 20), "\">{$lang['active']}</a></td>\n";
}else {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&sort_by=SESSID&amp;sort_dir=DESC&amp;usersearch=$usersearch&amp;page=", ($start / 20), "\">{$lang['active']}</a></td>\n";
}

if ($sort_by == 'SESSIONS.SESSID' && $sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&sort_by=SESSID&amp;sort_dir=DESC&amp;usersearch=$usersearch&amp;page=", ($start / 20), "\">{$lang['kick']}</a></td>\n";
}elseif ($sort_by == 'SESSIONS.SESSID' && $sort_dir == 'DESC') {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&sort_by=SESSID&amp;sort_dir=ASC&amp;usersearch=$usersearch&amp;page=", ($start / 20), "\">{$lang['kick']}</a></td>\n";
}elseif ($sort_dir == 'ASC') {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&sort_by=SESSID&amp;sort_dir=ASC&amp;usersearch=$usersearch&amp;page=", ($start / 20), "\">{$lang['kick']}</a></td>\n";
}else {
    echo "                   <td class=\"subhead\" align=\"left\">&nbsp;<a href=\"admin_users.php?webtag=$webtag&sort_by=SESSID&amp;sort_dir=DESC&amp;usersearch=$usersearch&amp;page=", ($start / 20), "\">{$lang['kick']}</a></td>\n";
}

echo "                 </tr>\n";

if (isset($usersearch) && strlen($usersearch) > 0) {
    $user_array = admin_user_search($usersearch, $sort_by, $sort_dir, $start, false);
}else {
    $user_array = admin_user_get_all($sort_by, $sort_dir, $start, false);
}

if (sizeof($user_array) > 0) {

    foreach ($user_array as $user) {

        echo "                 <tr>\n";
        echo "                   <td class=\"posthead\" align=\"left\">&nbsp;", $user['UID'], "</td>\n";
        echo "                   <td class=\"posthead\" align=\"left\">&nbsp;<a href=\"admin_user.php?webtag=$webtag&uid=", $user['UID'], "\">", format_user_name($user['LOGON'], $user['NICKNAME']), "</a></td>\n";
        echo "                   <td class=\"posthead\" align=\"left\">&nbsp;";

        if (isset($user['STATUS']) && $user['STATUS'] > 0) {

            if ($user['STATUS'] & USER_PERM_QUEEN)   echo "{$lang['queen']} ";
            if ($user['STATUS'] & USER_PERM_SOLDIER) echo "{$lang['soldier']} ";
            if ($user['STATUS'] & USER_PERM_WORKER)  echo "{$lang['worker']} ";
            if ($user['STATUS'] & USER_PERM_WORM)    echo "{$lang['worm']} ";
            if ($user['STATUS'] & USER_PERM_WASP)    echo "{$lang['wasp']} ";
            if ($user['STATUS'] & USER_PERM_SPLAT)   echo "{$lang['splat']}";

        }else {
            echo "&nbsp;";
        }
        
        echo "</td>\n";
        
        if (!isset($user['LAST_LOGON']) || is_null($user['LAST_LOGON'])) {
            echo "                   <td class=\"posthead\" align=\"left\">&nbsp;{$lang['unknown']}</td>\n";
        }else {
            echo "                   <td class=\"posthead\" align=\"left\">&nbsp;", format_time($user['LAST_LOGON'], 1), "</td>\n";
        }
        
        if (user_is_active($user['UID'])) {
            echo "                   <td class=\"posthead\" align=\"left\">&nbsp;<b>{$lang['yes']}</b></td>\n";
            echo "                   <td class=\"posthead\" align=\"left\">&nbsp;", form_submit("t_kick[{$user['UID']}]", $lang['kick']), "</td>\n";
        }else {
            echo "                   <td class=\"posthead\" align=\"left\">&nbsp;{$lang['no']}</td>\n";
            echo "                   <td class=\"posthead\" align=\"left\">&nbsp;</td>\n";
        }
        
        echo "                 </tr>\n";
    }

}else {

    if (isset($usersearch) && strlen($usersearch) > 0) {

        echo "                 <tr>\n";
        echo "                   <td class=\"posthead\" colspan=\"7\" align=\"left\">{$lang['nomatches']}</td>\n";
        echo "                 </tr>\n";

    }else {

        // Shouldn't happen ever, after all how did you get here if there are no user accounts?

        echo "                 <tr>\n";
        echo "                   <td class=\"posthead\" colspan=\"7\" align=\"left\">{$lang['nouseraccounts']}</td>\n";
        echo "                 </tr>\n";

    }

}

echo "                 <tr>\n";
echo "                   <td colspan=\"6\">&nbsp;</td>\n";
echo "                 </tr>\n";
echo "               </table>\n";
echo "             </td>\n";
echo "           </tr>\n";
echo "         </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";

if (sizeof($user_array) == 20) {
    if ($start < 20) {
        echo "<p><img src=\"", style_image('post.png'), "\" height=\"15\" alt=\"\" />&nbsp;<a href=\"admin_users.php?webtag=$webtag&page=", ($start / 20) + 1, "&amp;usersearch=$usersearch&amp;sort_by={$sort_by_array[$sort_by]}&amp;sort_dir=$sort_dir\" target=\"_self\">{$lang['more']}</a></p>\n";
    }elseif ($start >= 20) {
        echo "<p><img src=\"", style_image('post.png'), "\" height=\"15\" alt=\"\" />&nbsp;<a href=\"admin_users.php?webtag=$webtag\" target=\"_self\">{$lang['recentvisitors']}</a>&nbsp;&nbsp;";
        echo "<img src=\"", style_image('post.png'), "\" height=\"15\" alt=\"\" />&nbsp;<a href=\"admin_users.php?webtag=$webtag&page=", ($start / 20) - 1, "&amp;usersearch=$usersearch&amp;sort_by={$sort_by_array[$sort_by]}&amp;sort_dir=$sort_dir\" target=\"_self\">{$lang['back']}</a>&nbsp;&nbsp;";
        echo "<img src=\"", style_image('post.png'), "\" height=\"15\" alt=\"\" />&nbsp;<a href=\"admin_users.php?webtag=$webtag&page=", ($start / 20) + 1, "&amp;usersearch=$usersearch&amp;sort_by={$sort_by_array[$sort_by]}&amp;sort_dir=$sort_dir\" target=\"_self\">{$lang['more']}</a></p>\n";
    }
}else {
    if ($start >= 20) {
        echo "<p><img src=\"", style_image('post.png'), "\" height=\"15\" alt=\"\" />&nbsp;<a href=\"admin_users.php?webtag=$webtag\" target=\"_self\">{$lang['recentvisitors']}</a>&nbsp;&nbsp;";
        echo "<img src=\"", style_image('post.png'), "\" height=\"15\" alt=\"\" />&nbsp;<a href=\"admin_users.php?webtag=$webtag&page=", ($start / 20) - 1, "&amp;usersearch=$usersearch&amp;sort_by={$sort_by_array[$sort_by]}&amp;sort_dir=$sort_dir\" target=\"_self\">{$lang['back']}</a>&nbsp;&nbsp;";
    }else {
        echo "<p>&nbsp;</p>\n";
    }
}

echo "<form action=\"admin_users.php\" method=\"get\">\n";
echo "  ", form_input_hidden("webtag", $webtag), "\n";
echo "  ", form_input_hidden("sort_by", $sort_by), "\n";
echo "  ", form_input_hidden("sort_dir", $sort_dir), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"96%\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" align=\"left\">{$lang['searchforusernotinlist']}:</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td class=\"posthead\" align=\"left\">\n";
echo "                    {$lang['username']}: ", form_input_text('usersearch', $usersearch, 30, 64), " ", form_submit('submit', $lang['search']), " ", form_submit('reset', $lang['clear']), "\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"6\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";
echo "</div>\n";

html_draw_bottom();

?>