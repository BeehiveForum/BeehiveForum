<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
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

/* $Id: user_profile.php,v 1.157 2009-06-26 17:14:20 decoyduck Exp $ */

// Set the default timezone
date_default_timezone_set('UTC');

/**
* Displays user profiles
*/

/**
*/

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Disable PHP's register_globals
unregister_globals();

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

include_once(BH_INCLUDE_PATH. "attachments.inc.php");
include_once(BH_INCLUDE_PATH. "compat.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "fixhtml.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "profile.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "user_profile.inc.php");
include_once(BH_INCLUDE_PATH. "user_rel.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

// Get webtag

$webtag = get_webtag();

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.

if (bh_session_user_banned()) {

    html_user_banned();
    exit;
}

// Check to see if the user has been approved.

if (!bh_session_user_approved()) {

    html_user_require_approval();
    exit;
}

// Check we have a webtag

if (!forum_check_webtag_available($webtag)) {
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

// Load language file

$lang = lang::get_instance()->load(__FILE__);

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

if (isset($_GET['close_window'])) {

    html_draw_top('pm_popup_disabled');

    echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
    echo "  window.close();\n";
    echo "</script>\n";

    html_draw_bottom();
    exit;

}elseif (isset($_GET['uid']) && is_numeric($_GET['uid'])) {

    $uid = $_GET['uid'];

    if (!$logon = user_get_logon($uid)) {

        html_draw_top('pm_popup_disabled');
        html_error_msg($lang['unknownuser']);
        html_draw_bottom();
        exit;
    }

}elseif (isset($_GET['logon']) && strlen(trim(stripslashes_array($_GET['logon']))) > 0) {

    $logon = trim(stripslashes_array($_GET['logon']));

    if (($user_array = user_get_by_logon($logon))) {
        $uid = $user_array['UID'];
    }
}

if (!isset($uid)) {

    html_draw_top('pm_popup_disabled');
    html_error_msg($lang['nouserspecified']);
    html_draw_bottom();
    exit;
}

// Get the Profile Sections.

$profile_sections = profile_sections_get();

// Get the user's profile data.

$user_profile = user_get_profile($uid);

// User relationship.

$peer_relationship = user_get_relationship($uid, bh_session_get_value('UID'));

// Popup title.

$title = word_filter_add_ob_tags(htmlentities_array(format_user_name($user_profile['LOGON'], $user_profile['NICKNAME'])));

html_draw_top("title=$title", "openprofile.js", "basetarget=_blank", 'pm_popup_disabled');

echo "<div align=\"center\">\n";
echo "  <table width=\"600\" cellpadding=\"0\" cellspacing=\"0\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"center\" class=\"posthead\">\n";
echo "              <table class=\"profile_header\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\" width=\"95%\">\n";
echo "                    <table width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" class=\"subhead\"><h2 class=\"profile_logon\"><a href=\"javascript:void(0)\" onclick=\"openProfileOptions()\" target=\"_self\" id=\"profile_options\">", word_filter_add_ob_tags(htmlentities_array(format_user_name($user_profile['LOGON'], $user_profile['NICKNAME']))), "&nbsp;<img src=\"", style_image('post_options.png'), "\" width=\"17\" height=\"16\" class=\"post_options\" alt=\"{$lang['options']}\" title=\"{$lang['options']}\" border=\"0\" /></a></h2>\n";
echo "                          <div class=\"profile_options_container_closed\" id=\"profile_options_container\">\n";
echo "                            <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
echo "                              <tr>\n";
echo "                                <td align=\"left\" colspan=\"3\">\n";
echo "                                  <table class=\"box\" width=\"100%\">\n";
echo "                                    <tr>\n";
echo "                                      <td align=\"left\" class=\"posthead\">\n";
echo "                                        <table class=\"posthead\" width=\"100%\">\n";
echo "                                          <tr>\n";
echo "                                            <td class=\"subhead\" colspan=\"2\">{$lang['options']}</td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"center\">\n";
echo "                                              <table width=\"95%\" class=\"profile_options_menu\">\n";

if (isset($user_profile['HOMEPAGE_URL'])) {

    echo "                                                <tr>\n";
    echo "                                                  <td align=\"left\"><a href=\"{$user_profile['HOMEPAGE_URL']}\" target=\"_blank\" title=\"{$lang['visithomepage']}\"><img src=\"", style_image('home.png'), "\" border=\"0\" alt=\"{$lang['visithomepage']}\" title=\"{$lang['visithomepage']}\" /></a></td>\n";
    echo "                                                  <td align=\"left\" nowrap=\"nowrap\"><a href=\"{$user_profile['HOMEPAGE_URL']}\" target=\"_blank\" title=\"{$lang['visithomepage']}\">{$lang['visithomepage']}</a></td>\n";
    echo "                                                </tr>\n";
}

echo "                                                <tr>\n";
echo "                                                  <td align=\"left\"><a href=\"index.php?webtag=$webtag&amp;final_uri=pm_write.php%3Fwebtag%3D$webtag%26uid=$uid\" target=\"_blank\" title=\"{$lang['sendpm']}\"><img src=\"", style_image('pmunread.png'), "\" border=\"0\" alt=\"{$lang['sendpm']}\" title=\"{$lang['sendpm']}\" /></a></td>\n";
echo "                                                  <td align=\"left\" nowrap=\"nowrap\"><a href=\"index.php?webtag=$webtag&amp;final_uri=pm_write.php%3Fwebtag%3D$webtag%26uid=$uid\" target=\"_blank\" title=\"{$lang['sendpm']}\">{$lang['sendpm']}</a></td>\n";
echo "                                                </tr>\n";
echo "                                                <tr>\n";
echo "                                                  <td align=\"left\"><a href=\"email.php?webtag=$webtag&amp;uid=$uid\" target=\"_blank\" title=\"{$lang['sendemail']}\"><img src=\"", style_image('email.png'), "\" border=\"0\" alt=\"{$lang['sendemail']}\" title=\"{$lang['sendemail']}\" /></a></td>\n";
echo "                                                  <td align=\"left\" nowrap=\"nowrap\"><a href=\"email.php?webtag=$webtag&amp;uid=$uid\" target=\"_blank\" title=\"{$lang['sendemail']}\">{$lang['sendemail']}</a></td>\n";
echo "                                                </tr>\n";

if ($uid <> bh_session_get_value('UID')) {

    echo "                                                <tr>\n";
    echo "                                                  <td align=\"left\"><a href=\"user_rel.php?webtag=$webtag&amp;uid=$uid&amp;ret=user_profile.php%3Fwebtag%3D$webtag%26uid%3D$uid\" target=\"_self\" title=\"{$lang['relationship']}\"><img src=\"", style_image('enemy.png'), "\" border=\"0\" alt=\"{$lang['relationship']}\" title=\"{$lang['relationship']}\" /></a></td>\n";
    echo "                                                  <td align=\"left\" nowrap=\"nowrap\"><a href=\"user_rel.php?webtag=$webtag&amp;uid=$uid&amp;ret=user_profile.php%3Fwebtag%3D$webtag%26uid%3D$uid\" target=\"_self\" title=\"{$lang['relationship']}\">{$lang['relationship']}</a></td>\n";
    echo "                                                </tr>\n";
    echo "                                                <tr>\n";
    echo "                                                  <td align=\"left\"><a href=\"search.php?webtag=$webtag&amp;logon=$logon&amp;user_include=1\" target=\"_blank\" title=\"", sprintf($lang['findthreadsstartedbyuser'], $logon), "\" onclick=\"return findUserThreads('$logon', '$webtag');\"><img src=\"", style_image('search.png'), "\" border=\"0\" alt=\"", sprintf($lang['findthreadsstartedbyuser'], $logon), "\" title=\"", sprintf($lang['findpostsmadebyuser'], $logon), "\" /></a></td>\n";
    echo "                                                  <td align=\"left\" nowrap=\"nowrap\"><a href=\"search.php?webtag=$webtag&amp;logon=$logon&amp;user_include=1\" target=\"_blank\" title=\"", sprintf($lang['findthreadsstartedbyuser'], $logon), "\" onclick=\"return findUserThreads('$logon', '$webtag');\">", sprintf($lang['findthreadsstartedbyuser'], $logon), "</a></td>\n";
    echo "                                                </tr>\n";
    echo "                                                <tr>\n";
    echo "                                                  <td align=\"left\"><a href=\"search.php?webtag=$webtag&amp;logon=$logon\" target=\"_blank\" title=\"", sprintf($lang['findpostsmadebyuser'], $logon), "\" onclick=\"return findUserPosts('$logon', '$webtag');\"><img src=\"", style_image('search.png'), "\" border=\"0\" alt=\"", sprintf($lang['findpostsmadebyuser'], $logon), "\" title=\"", sprintf($lang['findpostsmadebyuser'], $logon), "\" /></a></td>\n";
    echo "                                                  <td align=\"left\" nowrap=\"nowrap\"><a href=\"search.php?webtag=$webtag&amp;logon=$logon\" target=\"_blank\" title=\"", sprintf($lang['findpostsmadebyuser'], $logon), "\" onclick=\"return findUserPosts('$logon', '$webtag');\">", sprintf($lang['findpostsmadebyuser'], $logon), "</a></td>\n";
    echo "                                                </tr>\n";

}else {

    echo "                                                <tr>\n";
    echo "                                                  <td align=\"left\"><a href=\"search.php?webtag=$webtag&amp;logon=$logon&amp;user_include=1\" target=\"_blank\" title=\"{$lang['findthreadsstartedbyme']}\" onclick=\"return findUserThreads('$logon', '$webtag');\"><img src=\"", style_image('search.png'), "\" border=\"0\" alt=\"{$lang['findthreadsstartedbyme']}\" title=\"{$lang['findthreadsstartedbyme']}\" /></a></td>\n";
    echo "                                                  <td align=\"left\" nowrap=\"nowrap\"><a href=\"search.php?webtag=$webtag&amp;logon=$logon&amp;user_include=1\" target=\"_blank\" title=\"{$lang['findthreadsstartedbyme']}\" onclick=\"return findUserThreads('$logon', '$webtag');\">{$lang['findthreadsstartedbyme']}</a></td>\n";
    echo "                                                </tr>\n";
    echo "                                                <tr>\n";
    echo "                                                  <td align=\"left\"><a href=\"search.php?webtag=$webtag&amp;logon=$logon\" target=\"_blank\" title=\"{$lang['findpostsmadebyme']}\" onclick=\"return findUserPosts('$logon', '$webtag');\"><img src=\"", style_image('search.png'), "\" border=\"0\" alt=\"{$lang['findpostsmadebyme']}\" title=\"{$lang['findpostsmadebyme']}\" /></a></td>\n";
    echo "                                                  <td align=\"left\" nowrap=\"nowrap\"><a href=\"search.php?webtag=$webtag&amp;logon=$logon\" target=\"_blank\" title=\"{$lang['sendemail']}\" onclick=\"return findUserPosts('$logon', '$webtag');\">{$lang['findpostsmadebyme']}</a></td>\n";
    echo "                                                </tr>\n";
}

echo "                                              </table>\n";
echo "                                            </td>\n";
echo "                                          </tr>\n";
echo "                                        </table>\n";
echo "                                      </td>\n";
echo "                                    </tr>\n";
echo "                                  </table>\n";
echo "                                </td>\n";
echo "                              </tr>\n";
echo "                            </table>\n";
echo "                          </div>\n";
echo "                        </td>\n";

if (isset($user_profile['RELATIONSHIP']) && ($user_profile['RELATIONSHIP'] & USER_FRIEND)) {

    echo "                        <td align=\"right\" class=\"subhead\"><img src=\"", style_image('friend.png'), "\" alt=\"{$lang['friend']}\" title=\"{$lang['friend']}\" /></td>\n";

}else if (isset($user_profile['RELATIONSHIP']) && ($user_profile['RELATIONSHIP'] & USER_IGNORED)) {

    echo "                        <td align=\"right\" class=\"subhead\"><img src=\"", style_image('enemy.png'), "\" alt=\"{$lang['ignoreduser']}\" title=\"{$lang['ignoreduser']}\" /></td>\n";

}

echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td>\n";
echo "                          <table width=\"95%\">\n";

if (isset($user_profile['USER_GROUPS']) && sizeof($user_profile['USER_GROUPS']) > 0) {

    $user_groups_list = (mb_strlen(trim($user_profile['USER_GROUPS'])) > 50) ? mb_substr($user_profile['USER_GROUPS'], 0, 47). "&hellip;" : $user_profile['USER_GROUPS'];

    echo "                            <tr>\n";
    echo "                              <td align=\"left\" class=\"subhead\"><div title=\"{$lang['groups']}: ", word_filter_add_ob_tags($user_profile['USER_GROUPS']), "\"><span class=\"smalltext\">{$lang['groups']}: ", word_filter_add_ob_tags($user_groups_list), "</span></div></td>\n";
    echo "                            </tr>\n";
}

echo "                            <tr>\n";
echo "                              <td class=\"subhead\" align=\"left\"><span class=\"smalltext\">{$lang['posts']}: {$user_profile['POST_COUNT']}</span></td>\n";
echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td  class=\"subhead\" align=\"left\"><span class=\"smalltext\">{$lang['registered']}: {$user_profile['REGISTERED']}</span></td>\n";
echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td class=\"subhead\" align=\"left\"><span class=\"smalltext\">{$lang['memberno']}: #{$user_profile['UID']}</span></td>\n";
echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td align=\"left\" class=\"subhead\"><span class=\"smalltext\">{$lang['lastvisit']}: {$user_profile['LAST_LOGON']}</span></td>\n";
echo "                            </tr>\n";

if (isset($user_profile['AGE'])) {

    echo "                            <tr>\n";
    echo "                              <td  class=\"subhead\" align=\"left\"><span class=\"smalltext\">";

    if (isset($user_profile['DOB'])) {

        echo "      {$lang['birthday']}: {$user_profile['DOB']} ({$lang['aged']} {$user_profile['AGE']})</span></td>\n";

    }else {

        echo "      {$lang['age']}: {$user_profile['AGE']}</span></td>\n";
    }

    echo "                            </tr>\n";

}else if (isset($user_profile['DOB'])) {

    echo "                            <tr>\n";
    echo "                              <td  class=\"subhead\" align=\"left\"><span class=\"smalltext\">{$lang['birthday']}: {$user_profile['DOB']}</span></td>\n";
    echo "                            </tr>\n";
}

echo "                            <tr>\n";
echo "                              <td class=\"subhead\" align=\"left\"><span class=\"smalltext\">{$lang['userslocaltime']}: {$user_profile['LOCAL_TIME']}</span></td>\n";
echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td class=\"subhead\" align=\"left\"><span class=\"smalltext\">{$lang['userstatus']}: {$user_profile['STATUS']}</span></td>\n";
echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td>&nbsp;</td>\n";
echo "                            </tr>\n";
echo "                          </table>\n";
echo "                        </td>\n";
echo "                        <td valign=\"top\">\n";
echo "                          <table width=\"95%\">\n";

if (isset($user_profile['PIC_URL'])) {

    echo "                            <tr>\n";
    echo "                              <td align=\"right\" class=\"subhead\">\n";
    echo "                                <div class=\"profile_image\">\n";
    echo "                                  <img src=\"{$user_profile['PIC_URL']}\" width=\"95\" height=\"95\" alt=\"\" />\n";
    echo "                                </div>\n";
    echo "                              </td>\n";
    echo "                            </tr>\n";

}elseif (isset($user_profile['PIC_AID']) && ($attachment = get_attachment_by_hash($user_profile['PIC_AID']))) {

    if (($profile_picture_href = attachment_make_link($attachment, false, false, false, false))) {

        echo "                            <tr>\n";
        echo "                              <td align=\"right\" class=\"subhead\">\n";
        echo "                                <div class=\"profile_image\">\n";
        echo "                                  <img src=\"$profile_picture_href\" width=\"95\" height=\"95\" alt=\"\" />\n";
        echo "                                </div>\n";
        echo "                              </td>\n";
        echo "                            </tr>\n";

    }else {

        echo "                            <tr>\n";
        echo "                              <td align=\"right\" class=\"subhead\">\n";
        echo "                                <div class=\"profile_image_none\"></div>\n";
        echo "                              </td>\n";
        echo "                            </tr>\n";
    }

}else {

    echo "                            <tr>\n";
    echo "                              <td align=\"right\" class=\"subhead\">\n";
    echo "                                <div class=\"profile_image_none\"></div>\n";
    echo "                              </td>\n";
    echo "                            </tr>\n";
}

echo "                          </table>\n";
echo "                        </td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "              </table>\n";

if (($user_profile_array = user_get_profile_entries($uid))) {

    foreach ($user_profile_array as $psid => $user_profile_item_array) {

        if (isset($profile_sections[$psid]) && is_array($profile_sections[$psid])) {

            echo "              <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" class=\"profile_items_section\">\n";
            echo "                <tr>\n";
            echo "                  <td align=\"center\">\n";
            echo "                    <table width=\"96%\" cellpadding=\"0\" cellspacing=\"0\">\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"center\">\n";
            echo "                          <table width=\"95%\">\n";
            echo "                            <tr>\n";
            echo "                              <td align=\"left\" class=\"postbody\"><b>", word_filter_add_ob_tags(htmlentities_array($profile_sections[$psid]['NAME'])), "</b></td>\n";
            echo "                            </tr>\n";
            echo "                            <tr>\n";
            echo "                              <td align=\"center\">\n";
            echo "                                <table width=\"94%\" class=\"profile_items\">\n";

            foreach ($user_profile_item_array as $user_profile_entry) {

                if (($user_profile_entry['TYPE'] == PROFILE_ITEM_RADIO) || ($user_profile_entry['TYPE'] == PROFILE_ITEM_DROPDOWN)) {

                    $profile_item_options_array = explode("\n", $user_profile_entry['OPTIONS']);

                    if (isset($profile_item_options_array[$user_profile_entry['ENTRY']])) {

                        echo "                                  <tr>\n";
                        echo "                                    <td align=\"left\" width=\"35%\" valign=\"top\" class=\"profile_item_name\">", word_filter_add_ob_tags(htmlentities_array($user_profile_entry['NAME'])), "</td>\n";
                        echo "                                    <td align=\"left\" class=\"profile_item_value\" valign=\"top\">", word_filter_add_ob_tags(htmlentities_array($profile_item_options_array[$user_profile_entry['ENTRY']])), "</td>\n";
                        echo "                                  </tr>\n";

                    }else {

                        echo "                                  <tr>\n";
                        echo "                                    <td align=\"left\" width=\"35%\" valign=\"top\" class=\"profile_item_name\">", word_filter_add_ob_tags(htmlentities_array($user_profile_entry['NAME'])), "</td>\n";
                        echo "                                    <td align=\"left\" class=\"profile_item_value\" valign=\"top\">&nbsp;</td>\n";
                        echo "                                  </tr>\n";
                    }

                }else if ($user_profile_entry['TYPE'] == PROFILE_ITEM_HYPERLINK) {

                    $profile_item_hyper_link = str_replace("[ProfileEntry]", word_filter_add_ob_tags(urlencode($user_profile_entry['ENTRY'])), $user_profile_entry['OPTIONS']);
                    $profile_item_hyper_link = sprintf("<a href=\"%s\" target=\"_blank\">%s</a>", $profile_item_hyper_link, word_filter_add_ob_tags(htmlentities_array($user_profile_entry['ENTRY'])));

                    echo "                                  <tr>\n";
                    echo "                                    <td align=\"left\" width=\"35%\" valign=\"top\" class=\"profile_item_name\">", word_filter_add_ob_tags(htmlentities_array($user_profile_entry['NAME'])), "</td>\n";
                    echo "                                    <td align=\"left\" class=\"profile_item_value\" valign=\"top\">$profile_item_hyper_link</td>\n";
                    echo "                                  </tr>\n";

                }else {

                    echo "                                  <tr>\n";
                    echo "                                    <td align=\"left\" width=\"35%\" valign=\"top\" class=\"profile_item_name\">", word_filter_add_ob_tags(htmlentities_array($user_profile_entry['NAME'])), "</td>\n";
                    echo "                                    <td align=\"left\" class=\"profile_item_value\" valign=\"top\">", word_filter_add_ob_tags(htmlentities_array($user_profile_entry['ENTRY'])), "</td>\n";
                    echo "                                  </tr>\n";
                }
            }

            echo "                                </table>\n";
            echo "                              </td>\n";
            echo "                            </tr>\n";
            echo "                          </table>\n";
            echo "                          <br />\n";
            echo "                        </td>\n";
            echo "                      </tr>\n";
            echo "                    </table>\n";
            echo "                  </td>\n";
            echo "                </tr>\n";
            echo "              </table>\n";
        }
    }

}else {

    echo "              <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" class=\"profile_items_section\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table width=\"96%\" cellpadding=\"0\" cellspacing=\"0\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"center\">\n";
    echo "                          <table width=\"95%\">\n";
    echo "                            <tr>\n";
    echo "                              <td align=\"left\" class=\"postbody\"><b>{$lang['profilenotavailable']}</b></td>\n";
    echo "                            </tr>\n";
    echo "                            <tr>\n";
    echo "                              <td align=\"center\">\n";
    echo "                                <table width=\"94%\" class=\"profile_items\">\n";
    echo "                                  <tr>\n";
    echo "                                    <td align=\"left\">{$lang['userprofileempty']}</td>\n";
    echo "                                  </tr>\n";
    echo "                                </table>\n";
    echo "                              </td>\n";
    echo "                            </tr>\n";
    echo "                          </table>\n";
    echo "                          <br />\n";
    echo "                        </td>\n";
    echo "                      </tr>\n";
    echo "                    </table>\n";
    echo "                  </td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
}

echo "              <table class=\"profile_footer\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" align=\"right\" colspan=\"2\">{$lang['longesttimeinforum']}: {$user_profile['USER_TIME_BEST']}&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" colspan=\"2\" align=\"right\">{$lang['totaltimeinforum']}: {$user_profile['USER_TIME_TOTAL']}&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">&nbsp;</td>\n";
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
echo "  </table>\n";
echo "</div>\n";

html_draw_bottom();

?>