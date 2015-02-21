<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
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

// Bootstrap
require_once 'boot.php';

// Required includes
require_once BH_INCLUDE_PATH . 'attachments.inc.php';
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'profile.inc.php';
require_once BH_INCLUDE_PATH . 'user.inc.php';
require_once BH_INCLUDE_PATH . 'user_profile.inc.php';
require_once BH_INCLUDE_PATH . 'user_rel.inc.php';
require_once BH_INCLUDE_PATH . 'word_filter.inc.php';
// End Required includes

$uid = null;
$logon = null;

if (isset($_GET['uid']) && is_numeric($_GET['uid'])) {

    $uid = $_GET['uid'];

    if (!($logon = user_get_logon($uid))) {
        html_draw_error(gettext("Unknown user"));
    }

} else if (isset($_GET['logon']) && strlen(trim($_GET['logon'])) > 0) {

    $logon = trim($_GET['logon']);

    if (($user_array = user_get_by_logon($logon)) !== false) {
        $uid = $user_array['UID'];
    }
}

if (!isset($uid)) {
    html_draw_error(gettext("No user specified."));
}

// Get the Profile Sections.
$profile_sections = profile_sections_get();

// Get the user's profile data.
$user_profile = user_get_profile($uid);

// User relationship.
$peer_relationship = user_get_relationship($uid, $_SESSION['UID']);

// Popup title.
$page_title = format_user_name($user_profile['LOGON'], $user_profile['NICKNAME']);

html_draw_top(
    array(
        'title' => $page_title,
        'js' => array(
            'js/user_profile.js'
        ),
        'base_target' => '_blank',
        'pm_popup_disabled' => true,
        'class' => 'window_title'
    )
);

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
echo "                        <td align=\"left\" class=\"subhead\"><h2 class=\"profile_logon\" id=\"profile_options\">", word_filter_add_ob_tags(format_user_name($user_profile['LOGON'], $user_profile['NICKNAME']), true), "&nbsp;", html_style_image('post_options', gettext("Options")), "</h2>\n";
echo "                          <div class=\"profile_options_container\" id=\"profile_options_container\">\n";
echo "                            <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
echo "                              <tr>\n";
echo "                                <td align=\"left\" colspan=\"3\">\n";
echo "                                  <table class=\"box\" width=\"100%\">\n";
echo "                                    <tr>\n";
echo "                                      <td align=\"left\" class=\"posthead\">\n";
echo "                                        <table class=\"posthead\" width=\"100%\">\n";
echo "                                          <tr>\n";
echo "                                            <td class=\"subhead\" colspan=\"2\">", gettext("Options"), "</td>\n";
echo "                                          </tr>\n";
echo "                                          <tr>\n";
echo "                                            <td align=\"center\">\n";
echo "                                              <table width=\"95%\" class=\"profile_options_menu\">\n";

if (isset($user_profile['HOMEPAGE_URL']) && filter_var($user_profile['HOMEPAGE_URL'], FILTER_VALIDATE_URL)) {

    echo "                                                <tr>\n";
    echo "                                                  <td align=\"left\"><a href=\"{$user_profile['HOMEPAGE_URL']}\" target=\"_blank\" title=\"", gettext("Visit Homepage"), "\">", html_style_image('home', gettext("Visit Homepage")), "</a></td>\n";
    echo "                                                  <td align=\"left\" style=\"white-space: nowrap\"><a href=\"{$user_profile['HOMEPAGE_URL']}\" target=\"_blank\" title=\"", gettext("Visit Homepage"), "\">", gettext("Visit Homepage"), "</a></td>\n";
    echo "                                                </tr>\n";
}

echo "                                                <tr>\n";
echo "                                                  <td align=\"left\"><a href=\"index.php?webtag=$webtag&amp;final_uri=pm_write.php%3Fwebtag%3D$webtag%26uid=$uid\" target=\"_blank\" title=\"", gettext("Send PM"), "\">", html_style_image('pm_unread', gettext("Send PM")), "</a></td>\n";
echo "                                                  <td align=\"left\" style=\"white-space: nowrap\"><a href=\"index.php?webtag=$webtag&amp;final_uri=pm_write.php%3Fwebtag%3D$webtag%26uid=$uid\" target=\"_blank\" title=\"", gettext("Send PM"), "\">", gettext("Send PM"), "</a></td>\n";
echo "                                                </tr>\n";
echo "                                                <tr>\n";
echo "                                                  <td align=\"left\"><a href=\"email.php?webtag=$webtag&amp;uid=$uid\" target=\"_blank\" title=\"", gettext("Send email"), "\">", html_style_image('email', gettext("Send email")), "</a></td>\n";
echo "                                                  <td align=\"left\" style=\"white-space: nowrap\"><a href=\"email.php?webtag=$webtag&amp;uid=$uid\" target=\"_blank\" title=\"", gettext("Send email"), "\">", gettext("Send email"), "</a></td>\n";
echo "                                                </tr>\n";

if ($uid <> $_SESSION['UID']) {

    echo "                                                <tr>\n";
    echo "                                                  <td align=\"left\"><a href=\"user_rel.php?webtag=$webtag&amp;uid=$uid&amp;ret=user_profile.php%3Fwebtag%3D$webtag%26uid%3D$uid\" target=\"_self\" title=\"", gettext("Relationship"), "\">", html_style_image('enemy', gettext("Relationship")), "</a></td>\n";
    echo "                                                  <td align=\"left\" style=\"white-space: nowrap\"><a href=\"user_rel.php?webtag=$webtag&amp;uid=$uid&amp;ret=user_profile.php%3Fwebtag%3D$webtag%26uid%3D$uid\" target=\"_self\" title=\"", gettext("Relationship"), "\">", gettext("Relationship"), "</a></td>\n";
    echo "                                                </tr>\n";
    echo "                                                <tr>\n";
    echo "                                                  <td align=\"left\"><a href=\"search.php?webtag=$webtag&amp;logon=$logon&amp;user_include=1\" target=\"_blank\" title=\"", sprintf(gettext("Find Threads started by %s"), $logon), "\" class=\"opener_top\">", html_style_image('search', sprintf(gettext("Find Threads started by %s"), $logon)), "</a></td>\n";
    echo "                                                  <td align=\"left\" style=\"white-space: nowrap\"><a href=\"search.php?webtag=$webtag&amp;logon=$logon&amp;user_include=1\" target=\"_blank\" title=\"", sprintf(gettext("Find Threads started by %s"), $logon), "\" class=\"opener_top\">", sprintf(gettext("Find Threads started by %s"), $logon), "</a></td>\n";
    echo "                                                </tr>\n";
    echo "                                                <tr>\n";
    echo "                                                  <td align=\"left\"><a href=\"search.php?webtag=$webtag&amp;logon=$logon\" target=\"_blank\" title=\"", sprintf(gettext("Find Posts made by %s"), $logon), "\" class=\"opener_top\">", html_style_image('search', sprintf(gettext("Find Posts made by %s"), $logon)), "</a></td>\n";
    echo "                                                  <td align=\"left\" style=\"white-space: nowrap\"><a href=\"search.php?webtag=$webtag&amp;logon=$logon\" target=\"_blank\" title=\"", sprintf(gettext("Find Posts made by %s"), $logon), "\" class=\"opener_top\">", sprintf(gettext("Find Posts made by %s"), $logon), "</a></td>\n";
    echo "                                                </tr>\n";

} else {

    echo "                                                <tr>\n";
    echo "                                                  <td align=\"left\"><a href=\"search.php?webtag=$webtag&amp;logon=$logon&amp;user_include=1\" target=\"_blank\" title=\"", gettext("Find Threads started by me"), "\" class=\"opener_top\">", html_style_image('search', gettext("Find Threads started by me")), "</a></td>\n";
    echo "                                                  <td align=\"left\" style=\"white-space: nowrap\"><a href=\"search.php?webtag=$webtag&amp;logon=$logon&amp;user_include=1\" target=\"_blank\" title=\"", gettext("Find Threads started by me"), "\" class=\"opener_top\">", gettext("Find Threads started by me"), "</a></td>\n";
    echo "                                                </tr>\n";
    echo "                                                <tr>\n";
    echo "                                                  <td align=\"left\"><a href=\"search.php?webtag=$webtag&amp;logon=$logon\" target=\"_blank\" title=\"", gettext("Find Posts made by me"), "\" class=\"opener_top\">", html_style_image('search', gettext("Find Posts made by me")), "</a></td>\n";
    echo "                                                  <td align=\"left\" style=\"white-space: nowrap\"><a href=\"search.php?webtag=$webtag&amp;logon=$logon\" target=\"_blank\" title=\"", gettext("Send email"), "\" class=\"opener_top\">", gettext("Find Posts made by me"), "</a></td>\n";
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

    echo "                        <td align=\"right\" class=\"subhead\">", html_style_image('friend', gettext("Friend")), "</td>\n";

} else if (isset($user_profile['RELATIONSHIP']) && ($user_profile['RELATIONSHIP'] & USER_IGNORED)) {

    echo "                        <td align=\"right\" class=\"subhead\">", html_style_image('enemy', gettext("Ignored user")), "</td>\n";

}

echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td>\n";
echo "                          <table width=\"95%\">\n";

if (isset($user_profile['GROUPS']) && sizeof($user_profile['GROUPS']) > 0) {

    $user_groups_list = (mb_strlen(trim($user_profile['GROUPS'])) > 50) ? mb_substr($user_profile['GROUPS'], 0, 47) . "&hellip;" : $user_profile['GROUPS'];

    echo "                            <tr>\n";
    echo "                              <td align=\"left\" class=\"subhead\"><div title=\"", gettext("Groups"), ": ", word_filter_add_ob_tags($user_profile['GROUPS'], true), "\"><span>", gettext("Groups"), ": ", word_filter_add_ob_tags($user_groups_list), "</span></div></td>\n";
    echo "                            </tr>\n";
}

echo "                            <tr>\n";
echo "                              <td class=\"subhead\" align=\"left\"><span>", gettext("Posts"), ": {$user_profile['POST_COUNT']}</span></td>\n";
echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td  class=\"subhead\" align=\"left\"><span>", gettext("Registered"), ": {$user_profile['REGISTERED']}</span></td>\n";
echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td class=\"subhead\" align=\"left\"><span>", gettext("Member No."), ": #{$user_profile['UID']}</span></td>\n";
echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td align=\"left\" class=\"subhead\"><span>", gettext("Last Visit"), ": {$user_profile['LAST_LOGON']}</span></td>\n";
echo "                            </tr>\n";

if (isset($user_profile['AGE'])) {

    echo "                            <tr>\n";
    echo "                              <td  class=\"subhead\" align=\"left\"><span>";

    if (isset($user_profile['DOB'])) {

        echo "      ", gettext("Birthday"), ": {$user_profile['DOB']} (", gettext("aged"), " {$user_profile['AGE']})</span></td>\n";

    } else {

        echo "      ", gettext("Age"), ": {$user_profile['AGE']}</span></td>\n";
    }

    echo "                            </tr>\n";

} else if (isset($user_profile['DOB'])) {

    echo "                            <tr>\n";
    echo "                              <td  class=\"subhead\" align=\"left\"><span>", gettext("Birthday"), ": {$user_profile['DOB']}</span></td>\n";
    echo "                            </tr>\n";
}

echo "                            <tr>\n";
echo "                              <td class=\"subhead\" align=\"left\"><span>", gettext("User's Local Time"), ": {$user_profile['LOCAL_TIME']}</span></td>\n";
echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td class=\"subhead\" align=\"left\"><span>", gettext("Status"), ": {$user_profile['STATUS']}</span></td>\n";
echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td class=\"subhead\" align=\"left\"><span>", gettext("Total Post Rating"), ": ", ($user_profile['POST_RATING'] > 0 ? '+' : ''), $user_profile['POST_RATING'], "</span></td>\n";
echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td class=\"subhead\" align=\"left\"><span>", gettext("Votes Cast"), ": ", sprintf(gettext("%d total, %d down - %d up"), $user_profile['POST_VOTE_TOTAL'], $user_profile['POST_VOTE_DOWN'], $user_profile['POST_VOTE_UP']), "</span></td>\n";
echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td>&nbsp;</td>\n";
echo "                            </tr>\n";
echo "                          </table>\n";
echo "                        </td>\n";
echo "                        <td valign=\"top\" width=\"110\">\n";
echo "                          <table width=\"100%\">\n";
echo "                            <tr>\n";
echo "                              <td align=\"right\" class=\"subhead\">\n";

if (isset($user_profile['PIC_URL']) && filter_var($user_profile['PIC_URL'], FILTER_VALIDATE_URL)) {

    echo "                                  ", html_style_image('profile_image profile_image_large', null, null, array('background-image' => sprintf("url('%s')", $user_profile['PIC_URL']))), "\n";

} else if (isset($user_profile['PIC_AID']) && ($attachment = attachments_get_by_aid($user_profile['PIC_AID']))) {

    if (($profile_picture_href = attachments_make_link($attachment, false, false, false, false)) !== false) {
        echo "                                  ", html_style_image('profile_image profile_image_large', null, null, array('background-image' => sprintf("url('%s&amp;profile_picture')", $profile_picture_href))), "\n";
    }
}

echo "                              </td>\n";
echo "                            </tr>\n";
echo "                          </table>\n";
echo "                        </td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "              </table>\n";

if (($user_profile_array = user_get_profile_entries($uid)) !== false) {

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
            echo "                              <td align=\"left\" class=\"postbody\"><b>", word_filter_add_ob_tags($profile_sections[$psid]['NAME'], true), "</b></td>\n";
            echo "                            </tr>\n";
            echo "                            <tr>\n";
            echo "                              <td align=\"center\">\n";
            echo "                                <table width=\"94%\" class=\"profile_items\">\n";

            foreach ($user_profile_item_array as $user_profile_entry) {

                if (($user_profile_entry['TYPE'] == PROFILE_ITEM_RADIO) || ($user_profile_entry['TYPE'] == PROFILE_ITEM_DROPDOWN)) {

                    $profile_item_options_array = explode("\n", $user_profile_entry['OPTIONS']);

                    if (isset($profile_item_options_array[$user_profile_entry['ENTRY']])) {

                        echo "                                  <tr>\n";
                        echo "                                    <td align=\"left\" width=\"35%\" valign=\"top\" class=\"profile_item_name\">", word_filter_add_ob_tags($user_profile_entry['NAME'], true), "</td>\n";
                        echo "                                    <td align=\"left\" class=\"profile_item_value\" valign=\"top\">", word_filter_add_ob_tags($profile_item_options_array[$user_profile_entry['ENTRY']], true), "</td>\n";
                        echo "                                  </tr>\n";

                    } else {

                        echo "                                  <tr>\n";
                        echo "                                    <td align=\"left\" width=\"35%\" valign=\"top\" class=\"profile_item_name\">", word_filter_add_ob_tags($user_profile_entry['NAME'], true), "</td>\n";
                        echo "                                    <td align=\"left\" class=\"profile_item_value\" valign=\"top\">&nbsp;</td>\n";
                        echo "                                  </tr>\n";
                    }

                } else if ($user_profile_entry['TYPE'] == PROFILE_ITEM_HYPERLINK) {

                    $profile_item_hyper_link = str_replace("[ProfileEntry]", word_filter_add_ob_tags(urlencode($user_profile_entry['ENTRY'])), $user_profile_entry['OPTIONS']);
                    $profile_item_hyper_link = sprintf("<a href=\"%s\" target=\"_blank\">%s</a>", $profile_item_hyper_link, word_filter_add_ob_tags($user_profile_entry['ENTRY'], true));

                    echo "                                  <tr>\n";
                    echo "                                    <td align=\"left\" width=\"35%\" valign=\"top\" class=\"profile_item_name\">", word_filter_add_ob_tags($user_profile_entry['NAME'], true), "</td>\n";
                    echo "                                    <td align=\"left\" class=\"profile_item_value\" valign=\"top\">$profile_item_hyper_link</td>\n";
                    echo "                                  </tr>\n";

                } else {

                    echo "                                  <tr>\n";
                    echo "                                    <td align=\"left\" width=\"35%\" valign=\"top\" class=\"profile_item_name\">", word_filter_add_ob_tags($user_profile_entry['NAME'], true), "</td>\n";
                    echo "                                    <td align=\"left\" class=\"profile_item_value\" valign=\"top\">", word_filter_add_ob_tags($user_profile_entry['ENTRY'], true), "</td>\n";
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

} else {

    echo "              <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" class=\"profile_items_section\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table width=\"96%\" cellpadding=\"0\" cellspacing=\"0\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"center\">\n";
    echo "                          <table width=\"95%\">\n";
    echo "                            <tr>\n";
    echo "                              <td align=\"left\" class=\"postbody\"><b>", gettext("Profile Not Available."), "</b></td>\n";
    echo "                            </tr>\n";
    echo "                            <tr>\n";
    echo "                              <td align=\"center\">\n";
    echo "                                <table width=\"94%\" class=\"profile_items\">\n";
    echo "                                  <tr>\n";
    echo "                                    <td align=\"left\">", gettext("This user has not filled in their profile or it is set to private."), "</td>\n";
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