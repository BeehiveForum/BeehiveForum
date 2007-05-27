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

/* $Id: edit_prefs.php,v 1.70 2007-05-27 21:09:39 decoyduck Exp $ */

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

// Fetch the forum settings
$forum_settings = forum_get_settings();

include_once(BH_INCLUDE_PATH. "banned.inc.php");
include_once(BH_INCLUDE_PATH. "fixhtml.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "post.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

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

// Check to see if the user has been approved.

if (!bh_session_user_approved()) {

    html_user_require_approval();
    exit;
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

if (bh_session_get_value('UID') == 0) {
    html_guest_error();
    exit;
}

// User's UID
$uid = bh_session_get_value('UID');

// Get User Prefs
$user_prefs = user_get_prefs($uid);

// Get user information
$user_info = user_get($uid);

// Clear the error string
$error_html = "";

// Initialise the global prefs array

$user_prefs_global = array();

if (isset($_POST['submit'])) {

    $valid = true;

    // Required Fields

    if (isset($_POST['logon']) && strlen(trim(_stripslashes($_POST['logon']))) > 0) {

        $user_info['LOGON'] = trim(_stripslashes($_POST['logon']));

        if (!preg_match("/^[a-z0-9_-]+$/i", $user_info['LOGON'])) {
            $error_html.= "<h2>{$lang['usernameinvalidchars']}</h2>\n";
            $valid = false;
        }

        if (strlen($user_info['LOGON']) < 2) {
            $error_html.= "<h2>{$lang['usernametooshort']}</h2>\n";
            $valid = false;
        }

        if (strlen($user_info['LOGON']) > 15) {
            $error_html.= "<h2>{$lang['usernametoolong']}</h2>\n";
            $valid = false;
        }

        if (logon_is_banned($user_info['LOGON'])) {

            $error_html.= "<h2>{$lang['logonnotpermitted']}</h2>\n";
            $valid = false;
        }

        if (user_exists($user_info['LOGON'], $uid)) {

            $error_html.= "<h2>{$lang['usernameexists']}</h2>\n";
            $valid = false;
        }

    }else if (forum_get_setting('allow_username_changes', 'Y')) {

        $error_html.= "<h2>{$lang['usernamerequired']}</h2>";
        $valid = false;
    }

    if (isset($_POST['nickname']) && strlen(trim(_stripslashes($_POST['nickname']))) > 0) {

        $user_info['NICKNAME'] = trim(_stripslashes($_POST['nickname']));

        if (nickname_is_banned($user_info['NICKNAME'])) {

            $error_html.= "<h2>{$lang['nicknamenotpermitted']}</h2>\n";
            $valid = false;
        }

    }else {

        $error_html.= "<h2>{$lang['nicknamerequired']}</h2>";
        $valid = false;
    }

    if (isset($_POST['email']) && strlen(trim(_stripslashes($_POST['email']))) > 0) {

        $user_info['EMAIL'] = trim(_stripslashes($_POST['email']));

        if (!ereg("^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*$", $user_info['EMAIL'])) {

            $error_html.= "<h2>{$lang['invalidemailaddressformat']}</h2>\n";
            $valid = false;

        }else {

            if (email_is_banned($user_info['EMAIL'])) {

                $error_html.= "<h2>{$lang['emailaddressnotpermitted']}</h2>\n";
                $valid = false;
            }

            if (forum_get_setting('require_unique_email', 'Y') && !email_is_unique($user_info['EMAIL'])) {

                $error_html.= "<h2>{$lang['emailaddressalreadyinuse']}</h2>\n";
                $valid = false;
            }
        }

    }else {

        $error_html.= "<h2>{$lang['emailaddressrequired']}</h2>";
        $valid = false;
    }

    if (isset($_POST['dob_year']) && isset($_POST['dob_month']) && isset($_POST['dob_day']) && @checkdate($_POST['dob_month'], $_POST['dob_day'], $_POST['dob_year'])) {

        $dob['DAY']   = trim(_stripslashes($_POST['dob_day']));
        $dob['MONTH'] = trim(_stripslashes($_POST['dob_month']));
        $dob['YEAR']  = trim(_stripslashes($_POST['dob_year']));

        $user_prefs['DOB'] = sprintf("%04d-%02d-%02d", $dob['YEAR'], $dob['MONTH'], $dob['DAY']);

    }else {

        $error_html.= "<h2>{$lang['birthdayrequired']}</h2>";
        $valid = false;
    }

    // Optional fields

    if (isset($_POST['firstname'])) {

        $user_prefs['FIRSTNAME'] = trim(_stripslashes($_POST['firstname']));

        if (!user_check_pref('FIRSTNAME', $user_prefs['FIRSTNAME'])) {

            $error_html.= "<h2>{$lang['firstname']} {$lang['containsinvalidchars']}</h2>";
            $valid = false;
        }
    }

    if (isset($_POST['lastname'])) {

        $user_prefs['LASTNAME'] = trim(_stripslashes($_POST['lastname']));

        if (!user_check_pref('LASTNAME', $user_prefs['LASTNAME'])) {

            $error_html.= "<h2>{$lang['lastname']} {$lang['containsinvalidchars']}</h2>";
            $valid = false;
        }
    }

    if (isset($_POST['homepage_url'])) {

        $user_prefs['HOMEPAGE_URL'] = trim(_stripslashes($_POST['homepage_url']));
        $user_prefs_global['HOMEPAGE_URL'] = (isset($_POST['homepage_url_global'])) ? $_POST['homepage_url_global'] == "Y" : true;

        if (!user_check_pref('HOMEPAGE_URL', $user_prefs['HOMEPAGE_URL'])) {

            $error_html.= "<h2>{$lang['homepageURL']} {$lang['containsinvalidchars']}</h2>";
            $valid = false;
        }
    }

    if (isset($_POST['pic_url'])) {

        $user_prefs['PIC_URL'] = trim(_stripslashes($_POST['pic_url']));
        $user_prefs_global['PIC_URL'] = (isset($_POST['pic_url_global'])) ? $_POST['pic_url_global'] == "Y" : true;

        if (!user_check_pref('PIC_URL', $user_prefs['PIC_URL'])) {

            $error_html.= "<h2>{$lang['pictureURL']} {$lang['containsinvalidchars']}</h2>";
            $valid = false;
        }
    }

    if (isset($_POST['pic_aid'])) {

        $user_prefs['PIC_AID'] = $_POST['pic_aid'];
        $user_prefs_global['PIC_AID'] = (isset($_POST['pic_url_global'])) ? $_POST['pic_url_global'] == "Y" : true;

        if (strlen(trim($user_prefs['PIC_AID'])) > 0) {

            if (!is_md5($user_prefs['PIC_AID'])) {

                $error_html.= "<h2>{$lang['invalidattachmentid']}</h2>\n";
                $valid = false;

            }elseif (isset($user_prefs['PIC_URL']) && strlen(trim($user_prefs['PIC_URL'])) > 0) {

                $error_html.= "<h2>{$lang['profilepictureconflict']}</h2>\n";
                $valid = false;

            }elseif ($attachment_dir = attachments_check_dir()) {

                if ($image_info = getimagesize("$attachment_dir/{$user_prefs['PIC_AID']}")) {

                    if (($image_info[0] > 150) || ($image_info[1] > 150)) {

                        $error_html.= "<h2>{$lang['attachmenttoolargeforprofilepicture']}</h2>\n";
                        $valid = false;
                    }

                }else {

                    $error_html.= "<h2>{$lang['unsupportedimagetype']}</h2>\n";
                    $valid = false;
                }

            }else {

                $error_html.= "<h2>{$lang['attachmentshavebeendisabled']}</h2>\n";
                $valid = false;
            }
        }
    }

    if (isset($_POST['avatar_url'])) {

        $user_prefs['AVATAR_URL'] = trim(_stripslashes($_POST['avatar_url']));
        $user_prefs_global['AVATAR_URL'] = (isset($_POST['avatar_url_global'])) ? $_POST['avatar_url_global'] == "Y" : true;

        if (!user_check_pref('AVATAR_URL', $user_prefs['AVATAR_URL'])) {

            $error_html.= "<h2>{$lang['pictureURL']} {$lang['containsinvalidchars']}</h2>";
            $valid = false;
        }
    }

    if (isset($_POST['avatar_aid'])) {

        $user_prefs['AVATAR_AID'] = $_POST['avatar_aid'];
        $user_prefs_global['AVATAR_AID'] = (isset($_POST['avatar_url_global'])) ? $_POST['avatar_url_global'] == "Y" : true;

        if (strlen(trim($user_prefs['AVATAR_AID'])) > 0) {

            if (!is_md5($user_prefs['AVATAR_AID'])) {

                $error_html.= "<h2>{$lang['invalidattachmentid']}</h2>\n";
                $valid = false;

            }elseif (isset($user_prefs['AVATAR_URL']) && strlen(trim($user_prefs['AVATAR_URL'])) > 0) {

                $error_html.= "<h2>{$lang['avatarpictureconflict']}</h2>\n";
                $valid = false;

            }elseif ($attachment_dir = attachments_check_dir()) {

                if ($image_info = getimagesize("$attachment_dir/{$user_prefs['AVATAR_AID']}")) {

                    if (($image_info[0] > 150) || ($image_info[1] > 150)) {

                        $error_html.= "<h2>{$lang['attachmenttoolargeforavatarpicture']}</h2>\n";
                        $valid = false;
                    }

                }else {

                    $error_html.= "<h2>{$lang['unsupportedimagetype']}</h2>\n";
                    $valid = false;
                }

            }else {

                $error_html.= "<h2>{$lang['attachmentshavebeendisabled']}</h2>\n";
                $valid = false;
            }
        }
    }

    if ($valid) {

        // Update USER_PREFS
        
        user_update_prefs($uid, $user_prefs, $user_prefs_global);

        // Update basic settings in USER table

        user_update($uid, $user_info['LOGON'], $user_info['NICKNAME'], $user_info['EMAIL']);

        // If the user's logon was changed, update their cookie.

        if (forum_get_setting('allow_username_changes', 'Y')) {

            // Fetch current logon.

            $logon = bh_session_get_value('LOGON');

            // Update the logon that matches the current logged on user

            logon_update_logon_cookie($logon, $user_info['LOGON']);
        }

        // Reinitialize the User's Session to save them having to logout and back in

        bh_session_init($uid, false);

        // Force redirect to prevent refreshing the page 
        // prompting to user to resubmit form data.

        header_redirect("./edit_prefs.php?webtag=$webtag&updated=true", $lang['preferencesupdated']);
    }
}

// Split the DOB into usable variables.

if (isset($user_prefs['DOB']) && preg_match("/\d{4,}-\d{2,}-\d{2,}/", $user_prefs['DOB'])) {

    if (!isset($dob['YEAR']) || !isset($dob['MONTH']) || !isset($dob['DAY'])) {

        list($dob['YEAR'], $dob['MONTH'], $dob['DAY']) = explode('-', $user_prefs['DOB']);
    }

    $dob['BLANK_FIELDS'] = ($dob['YEAR'] == 0 || $dob['MONTH'] == 0 || $dob['DAY'] == 0) ? true : false;

}else {

    $dob['YEAR']  = 0;
    $dob['MONTH'] = 0;
    $dob['DAY']   = 0;
    $dob['BLANK_FIELDS'] = true;
}

if (isset($_POST['aid']) && is_md5($_POST['aid'])) {
    $aid = $_POST['aid'];
}else {
    $aid = md5(uniqid(rand()));
}

// Check to see if we should show the set for all forums checkboxes

$show_set_all = (forums_get_available_count() > 1) ? true : false;

// User's attachments for profile and avatar pictures

$user_attachments = get_users_attachments($uid, $attachments_array, $image_attachments_array);

// Prepare the attachments for use in a drop down.

$image_attachments_array = user_prefs_prep_attachments($image_attachments_array);

// Start Output Here

html_draw_top('attachments.js');

echo "<h1>{$lang['userdetails']}</h1>\n";

// Any error messages to display?

echo $error_html;

if (isset($_GET['updated'])) {
    echo "<h2>{$lang['preferencesupdated']}</h2>\n";
}

echo "<br />\n";
echo "<form name=\"prefs\" action=\"edit_prefs.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
echo "  ", form_input_hidden('aid', _htmlentities($aid)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">{$lang['userinformation']}</td>\n";
echo "                  <td align=\"left\" class=\"subhead\" width=\"1%\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" rowspan=\"13\" width=\"1%\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\">{$lang['memberno']}:&nbsp;</td>\n";
echo "                  <td align=\"left\">#{$user_info['UID']}&nbsp;</td>\n";
echo "                </tr>\n";

if (forum_get_setting('allow_username_changes', 'Y')) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"150\">{$lang['username']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">", form_input_text("logon", (isset($user_info['LOGON']) ? $user_info['LOGON'] : ""), 45, 15, "", "user_pref_field"), "</td>\n";
    echo "                </tr>\n";

}else {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"150\">{$lang['username']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">{$user_info['LOGON']}&nbsp;</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\">{$lang['nickname']}:&nbsp;</td>\n";
echo "                  <td align=\"left\">", form_input_text("nickname", (isset($user_info['NICKNAME']) ? $user_info['NICKNAME'] : ""), 45, 32, "", "user_pref_field"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\">{$lang['emailaddress']}:&nbsp;</td>\n";
echo "                  <td align=\"left\">", form_input_text("email", (isset($user_info['EMAIL']) ? $user_info['EMAIL'] : ""), 45, 80, "", "user_pref_field"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\">{$lang['firstname']}:&nbsp;</td>\n";
echo "                  <td align=\"left\">", form_input_text("firstname", (isset($user_prefs['FIRSTNAME']) ? $user_prefs['FIRSTNAME'] : ""), 45, 32, "", "user_pref_field"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\">{$lang['lastname']}:&nbsp;</td>\n";
echo "                  <td align=\"left\">", form_input_text("lastname", (isset($user_prefs['LASTNAME']) ? $user_prefs['LASTNAME'] : ""), 45, 32, "", "user_pref_field"), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\">{$lang['dateofbirth']}:&nbsp;</td>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\">", form_dob_dropdowns($dob['YEAR'], $dob['MONTH'], $dob['DAY'], $dob['BLANK_FIELDS']), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" valign=\"top\" nowrap=\"nowrap\">{$lang['homepageURL']}:&nbsp;</td>\n";
echo "                  <td align=\"left\">", form_input_text("homepage_url", (isset($user_prefs['HOMEPAGE_URL']) ? $user_prefs['HOMEPAGE_URL'] : ""), 45, 255, "", "user_pref_field"), "</td>\n";
echo "                  <td align=\"left\" valign=\"top\" nowrap=\"nowrap\">", ($show_set_all) ? form_checkbox("homepage_url_global", "Y", '', (isset($user_prefs['HOMEPAGE_URL_GLOBAL']) ? $user_prefs['HOMEPAGE_URL_GLOBAL'] : false), "title=\"{$lang['setforallforums']}\"") : '', "&nbsp;</td>\n";
echo "                </tr>\n";

if (forum_get_setting('attachments_enabled', 'Y')) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\">&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "            </td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "        <br />\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">{$lang['profilepicturedimensions']}</td>\n";
    echo "                  <td align=\"left\" class=\"subhead\" width=\"1%\">&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" rowspan=\"4\" width=\"1%\">&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" width=\"150\" nowrap=\"nowrap\">{$lang['pictureURL']}:</td>\n";
    echo "                  <td align=\"left\">", form_input_text("pic_url", (isset($user_prefs['PIC_URL']) ? $user_prefs['PIC_URL'] : ""), 45, 255, "", "user_pref_field"), "</td>\n";
    echo "                  <td align=\"right\" nowrap=\"nowrap\">", ($show_set_all) ? form_checkbox("pic_url_global", "Y", '', (isset($user_prefs['PIC_URL_GLOBAL']) ? $user_prefs['PIC_URL_GLOBAL'] : false), "title=\"{$lang['setforallforums']}\"") : '', "&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" width=\"150\" nowrap=\"nowrap\">{$lang['selectattachment']}:</td>\n";
    echo "                  <td align=\"left\">", form_dropdown_array("pic_aid", $image_attachments_array, (isset($user_prefs['PIC_AID']) ? $user_prefs['PIC_AID'] : ''), "", "user_pref_dropdown"), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\">&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "            </td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "        <br />\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">{$lang['avatarpicturedimensions']}</td>\n";
    echo "                  <td align=\"left\" class=\"subhead\" width=\"1%\">&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" rowspan=\"6\" width=\"1%\">&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" width=\"150\" nowrap=\"nowrap\">{$lang['avatarURL']}:</td>\n";
    echo "                  <td align=\"left\">", form_input_text("avatar_url", (isset($user_prefs['AVATAR_URL']) ? $user_prefs['AVATAR_URL'] : ""), 45, 255, "", "user_pref_field"), "</td>\n";
    echo "                  <td align=\"right\" nowrap=\"nowrap\">", ($show_set_all) ? form_checkbox("avatar_url_global", "Y", '', (isset($user_prefs['AVATAR_URL_GLOBAL']) ? $user_prefs['AVATAR_URL_GLOBAL'] : false), "title=\"{$lang['setforallforums']}\"") : '', "&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" width=\"150\" nowrap=\"nowrap\">{$lang['selectattachment']}:</td>\n";
    echo "                  <td align=\"left\">", form_dropdown_array("avatar_aid", $image_attachments_array, (isset($user_prefs['AVATAR_AID']) ? $user_prefs['AVATAR_AID'] : ''), "", "user_pref_dropdown"), "</td>\n";
    echo "                </tr>\n";

}else {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" width=\"150\" nowrap=\"nowrap\">{$lang['pictureURL']}:</td>\n";
    echo "                  <td align=\"left\">", form_input_text("pic_url", (isset($user_prefs['PIC_URL']) ? $user_prefs['PIC_URL'] : ""), 45, 255, "", "user_pref_field"), "</td>\n";
    echo "                  <td align=\"right\" nowrap=\"nowrap\">", ($show_set_all) ? form_checkbox("pic_url_global", "Y", '', (isset($user_prefs['PIC_URL_GLOBAL']) ? $user_prefs['PIC_URL_GLOBAL'] : false), "title=\"{$lang['setforallforums']}\"") : '', "&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" width=\"150\" nowrap=\"nowrap\">{$lang['avatarURL']}:</td>\n";
    echo "                  <td align=\"left\">", form_input_text("avatar_url", (isset($user_prefs['AVATAR_URL']) ? $user_prefs['AVATAR_URL'] : ""), 45, 255, "", "user_pref_field"), "</td>\n";
    echo "                  <td align=\"right\" nowrap=\"nowrap\">", ($show_set_all) ? form_checkbox("avatar_url_global", "Y", '', (isset($user_prefs['AVATAR_URL_GLOBAL']) ? $user_prefs['AVATAR_URL_GLOBAL'] : false), "title=\"{$lang['setforallforums']}\"") : '', "&nbsp;</td>\n";
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

if (forum_get_setting('attachments_enabled', 'Y')) {

    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_submit("submit", $lang['save']), "&nbsp;", form_button("attachments", $lang['uploadnewattachment'], "onclick=\"launchAttachWin('{$aid}', '$webtag')\""), "</td>\n";
    echo "    </tr>\n";

}else {

    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_submit("submit", $lang['save']), "</td>\n";
    echo "    </tr>\n";
}

echo "  </table>\n";
echo "</form>\n";

html_draw_bottom();

?>