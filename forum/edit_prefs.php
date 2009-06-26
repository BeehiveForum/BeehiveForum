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

/* $Id: edit_prefs.php,v 1.116 2009-06-26 17:14:20 decoyduck Exp $ */

// Set the default timezone
date_default_timezone_set('UTC');

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
include_once(BH_INCLUDE_PATH. "banned.inc.php");
include_once(BH_INCLUDE_PATH. "compat.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "email.inc.php");
include_once(BH_INCLUDE_PATH. "fixhtml.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "post.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

// Get Webtag

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

if (user_is_guest()) {

    html_guest_error();
    exit;
}

$admin_edit = false;

if (bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0)) {

    if (isset($_GET['profileuid'])) {

        if (is_numeric($_GET['profileuid'])) {

            $uid = $_GET['profileuid'];
            $admin_edit = true;

        }else {

            html_draw_top();
            html_error_msg($lang['nouserspecified']);
            html_draw_bottom();
            exit;
        }

    }elseif (isset($_POST['profileuid'])) {

        if (is_numeric($_POST['profileuid'])) {

            $uid = $_POST['profileuid'];
            $admin_edit = true;

        }else {

            html_draw_top();
            html_error_msg($lang['nouserspecified']);
            html_draw_bottom();
            exit;
        }

    }else {

        $uid = bh_session_get_value('UID');
    }

    if (isset($_POST['cancel'])) {

        header_redirect("admin_user.php?webtag=$webtag&uid=$uid");
        exit;
    }

}else {

    $uid = bh_session_get_value('UID');
}

if (!(bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0)) && ($uid != bh_session_get_value('UID'))) {

    html_draw_top();
    html_error_msg($lang['accessdeniedexp']);
    html_draw_bottom();
    exit;
}

// Get User Prefs
$user_prefs = user_get_prefs($uid);

// Get user information
$user_info = user_get($uid);

// Array to hold error messages
$error_msg_array = array();

// List of allowed image types

$allowed_image_types_array = array('jpg', 'jpeg', 'png', 'gif');
$allowed_image_types = "*.". implode(", *.", $allowed_image_types_array);

// Initialise the global prefs array

$user_prefs_global = array();

if (isset($_POST['save'])) {

    $valid = true;

    // Duplicate the user_info array.

    $user_info_new = $user_info;

    // Required Fields

    if ((bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0, 0) && $admin_edit) || (($uid == bh_session_get_value('UID')) && $admin_edit === false)) {

        if (forum_get_setting('allow_username_changes', 'Y') || (bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0, 0) && $admin_edit)) {

            if (isset($_POST['logon']) && strlen(trim(stripslashes_array($_POST['logon']))) > 0) {

                $user_info_new['LOGON'] = trim(stripslashes_array($_POST['logon']));

                if (mb_strlen($user_info_new['LOGON']) < 2) {

                    $error_msg_array[] = $lang['usernametooshort'];
                    $valid = false;
                }

                if (mb_strlen($user_info_new['LOGON']) > 15) {

                    $error_msg_array[] = $lang['usernametoolong'];
                    $valid = false;
                }

                if (logon_is_banned($user_info_new['LOGON'])) {


                    $error_msg_array[] = $lang['logonnotpermitted'];
                    $valid = false;
                }

                if (user_exists($user_info_new['LOGON'], $uid)) {

                    $error_msg_array[] = $lang['usernameexists'];
                    $valid = false;
                }

            }else {

                $error_msg_array[] = $lang['usernamerequired'];
                $valid = false;
            }
        }

        if (isset($_POST['nickname']) && strlen(trim(stripslashes_array($_POST['nickname']))) > 0) {

            $user_info_new['NICKNAME'] = strip_tags(trim(stripslashes_array($_POST['nickname'])));

            if (nickname_is_banned($user_info_new['NICKNAME'])) {

                $error_msg_array[] = $lang['nicknamenotpermitted'];
                $valid = false;
            }

        }else {

            $error_msg_array[] = $lang['nicknamerequired'];
            $valid = false;
        }

        if (isset($_POST['email']) && strlen(trim(stripslashes_array($_POST['email']))) > 0) {

            $user_info_new['EMAIL'] = trim(stripslashes_array($_POST['email']));

            if (!email_address_valid($user_info_new['EMAIL'])) {

                $error_msg_array[] = $lang['invalidemailaddressformat'];
                $valid = false;

            }else {

                if (email_is_banned($user_info_new['EMAIL'])) {

                    $error_msg_array[] = $lang['emailaddressnotpermitted'];
                    $valid = false;
                }

                if (forum_get_setting('require_unique_email', 'Y') && !email_is_unique($user_info_new['EMAIL'], $uid)) {

                    $error_msg_array[] = $lang['emailaddressalreadyinuse'];
                    $valid = false;
                }
            }

        }else {

            $error_msg_array[] = $lang['emailaddressrequired'];
            $valid = false;
        }

        if (isset($_POST['dob_year']) && isset($_POST['dob_month']) && isset($_POST['dob_day']) && @checkdate($_POST['dob_month'], $_POST['dob_day'], $_POST['dob_year'])) {

            $dob['DAY']   = trim(stripslashes_array($_POST['dob_day']));
            $dob['MONTH'] = trim(stripslashes_array($_POST['dob_month']));
            $dob['YEAR']  = trim(stripslashes_array($_POST['dob_year']));

            $user_prefs['DOB'] = sprintf("%04d-%02d-%02d", $dob['YEAR'], $dob['MONTH'], $dob['DAY']);

        }else {

            $error_msg_array[] = $lang['birthdayrequired'];
            $valid = false;
        }

        // Optional fields

        if (isset($_POST['firstname'])) {

            $user_prefs['FIRSTNAME'] = trim(stripslashes_array($_POST['firstname']));

            if (!user_check_pref('FIRSTNAME', $user_prefs['FIRSTNAME'])) {

                $error_msg_array[] = sprintf($lang['containsinvalidchars'], $lang['firstname']);
                $valid = false;
            }
        }

        if (isset($_POST['lastname'])) {

            $user_prefs['LASTNAME'] = trim(stripslashes_array($_POST['lastname']));

            if (!user_check_pref('LASTNAME', $user_prefs['LASTNAME'])) {

                $error_msg_array[] = sprintf($lang['containsinvalidchars'], $lang['lastname']);
                $valid = false;
            }
        }
    }

    if (isset($_POST['homepage_url'])) {

        $user_prefs['HOMEPAGE_URL'] = trim(stripslashes_array($_POST['homepage_url']));
        $user_prefs_global['HOMEPAGE_URL'] = (isset($_POST['homepage_url_global'])) ? $_POST['homepage_url_global'] == "Y" : true;

        if (strlen(trim($user_prefs['HOMEPAGE_URL'])) > 0) {

            if (preg_match('/^http:\/\//u', $user_prefs['HOMEPAGE_URL']) < 1) {

                $error_msg_array[] = $lang['homepageurlmustincludeschema'];
                $valid = false;

            }else if (!user_check_pref('HOMEPAGE_URL', $user_prefs['HOMEPAGE_URL'])) {

                $error_msg_array[] = sprintf($lang['containsinvalidchars'], $lang['homepageURL']);
                $valid = false;
            }
        }
    }

    if (isset($_POST['pic_url'])) {

        $user_prefs['PIC_URL'] = trim(stripslashes_array($_POST['pic_url']));
        $user_prefs_global['PIC_URL'] = (isset($_POST['pic_url_global'])) ? $_POST['pic_url_global'] == "Y" : true;

        if (strlen(trim($user_prefs['PIC_URL'])) > 0) {

            if (preg_match('/^http:\/\//u', $user_prefs['PIC_URL']) < 1) {

                $error_msg_array[] = $lang['pictureurlmustincludeschema'];
                $valid = false;

            }else if (!user_check_pref('PIC_URL', $user_prefs['PIC_URL'])) {

                $error_msg_array[] = sprintf($lang['containsinvalidchars'], $lang['pictureURL']);
                $valid = false;
            }
        }
    }

    if (isset($_POST['pic_aid'])) {

        $user_prefs['PIC_AID'] = $_POST['pic_aid'];
        $user_prefs_global['PIC_AID'] = (isset($_POST['pic_url_global'])) ? $_POST['pic_url_global'] == "Y" : true;

        if (strlen(trim($user_prefs['PIC_AID'])) > 0) {

            if (!is_md5($user_prefs['PIC_AID'])) {

                $error_msg_array[] = $lang['invalidattachmentid'];
                $valid = false;

            }elseif (isset($user_prefs['PIC_URL']) && strlen(trim($user_prefs['PIC_URL'])) > 0) {

                $error_msg_array[] = $lang['profilepictureconflict'];
                $valid = false;

            }elseif (($attachment_dir = attachments_check_dir())) {

                if (($attachment_details = get_attachment_by_hash($user_prefs['PIC_AID']))) {

                    $path_parts = pathinfo($attachment_details['filename']);

                    if (isset($path_parts['extension']) && in_array($path_parts['extension'], $allowed_image_types_array)) {

                        if (($image_info = getimagesize("$attachment_dir/{$user_prefs['PIC_AID']}"))) {

                            if (($image_info[0] > 95) || ($image_info[1] > 95)) {

                                $error_msg_array[] = sprintf($lang['attachmenttoolargeforprofilepicture'], '95x95px');
                                $valid = false;
                            }

                        }else {

                            $error_msg_array[] = sprintf("{$lang['unsupportedimagetype']}", $allowed_image_types);
                            $valid = false;
                        }

                    }else {

                        $error_msg_array[] = sprintf("{$lang['unsupportedimagetype']}", $allowed_image_types);
                        $valid = false;
                    }

                }else {

                    $error_msg_array[] = sprintf("{$lang['unsupportedimagetype']}", $allowed_image_types);
                    $valid = false;
                }

            }else {

                $error_msg_array[] = $lang['attachmentshavebeendisabled'];
                $valid = false;
            }
        }
    }

    if (isset($_POST['avatar_url'])) {

        $user_prefs['AVATAR_URL'] = trim(stripslashes_array($_POST['avatar_url']));
        $user_prefs_global['AVATAR_URL'] = (isset($_POST['avatar_url_global'])) ? $_POST['avatar_url_global'] == "Y" : true;

        if (strlen(trim($user_prefs['AVATAR_URL'])) > 0) {

            if (preg_match('/^http:\/\//u', $user_prefs['AVATAR_URL']) < 1) {

                $error_msg_array[] = $lang['avatarurlmustincludeschema'];
                $valid = false;

            }else if (!user_check_pref('AVATAR_URL', $user_prefs['AVATAR_URL'])) {

                $error_msg_array[] = sprintf($lang['containsinvalidchars'], $lang['avatarURL']);
                $valid = false;
            }
        }
    }

    if (isset($_POST['avatar_aid'])) {

        $user_prefs['AVATAR_AID'] = $_POST['avatar_aid'];
        $user_prefs_global['AVATAR_AID'] = (isset($_POST['avatar_url_global'])) ? $_POST['avatar_url_global'] == "Y" : true;

        if (strlen(trim($user_prefs['AVATAR_AID'])) > 0) {

            if (!is_md5($user_prefs['AVATAR_AID'])) {

                $error_msg_array[] = $lang['invalidattachmentid'];
                $valid = false;

            }elseif (isset($user_prefs['AVATAR_URL']) && strlen(trim($user_prefs['AVATAR_URL'])) > 0) {

                $error_msg_array[] = $lang['avatarpictureconflict'];
                $valid = false;

            }elseif (($attachment_dir = attachments_check_dir())) {

                if (($attachment_details = get_attachment_by_hash($user_prefs['AVATAR_AID']))) {

                    $path_parts = pathinfo($attachment_details['filename']);

                    if (isset($path_parts['extension']) && in_array($path_parts['extension'], $allowed_image_types_array)) {

                        if (($image_info = getimagesize("$attachment_dir/{$user_prefs['AVATAR_AID']}"))) {

                            if (($image_info[0] > 95) || ($image_info[1] > 95)) {

                                $error_msg_array[] = sprintf($lang['attachmenttoolargeforavatarpicture'], '15x15px');
                                $valid = false;
                            }

                        }else {

                            $error_msg_array[] = sprintf("{$lang['unsupportedimagetype']}", $allowed_image_types);
                            $valid = false;
                        }

                    }else {

                        $error_msg_array[] = sprintf("{$lang['unsupportedimagetype']}", $allowed_image_types);
                        $valid = false;
                    }

                }else {

                    $error_msg_array[] = sprintf("{$lang['unsupportedimagetype']}", $allowed_image_types);
                    $valid = false;
                }

            }else {

                $error_msg_array[] = $lang['attachmentshavebeendisabled'];
                $valid = false;
            }
        }
    }

    if ($valid) {

        // Update User Preferences

        if (user_update_prefs($uid, $user_prefs, $user_prefs_global)) {

            // Update basic settings in USER table

            if (user_update($uid, $user_info_new['LOGON'], $user_info_new['NICKNAME'], $user_info_new['EMAIL'])) {

                // If email confirmation is requied and the user has changed
                // their email address we need to get them to confirm the
                // change by sending them another email.

                if (($uid == bh_session_get_value('UID')) && $admin_edit === false) {

                    if (forum_get_setting('require_email_confirmation', 'Y') && ($user_info_new['EMAIL'] != $user_info['EMAIL'])) {

                        if (email_send_changed_email_confirmation($uid)) {

                            perm_user_apply_email_confirmation($uid);

                            html_draw_top();
                            html_display_msg($lang['emailaddresschanged'], $lang['newconfirmationemailsuccess'], 'index.php', 'get', array('continue' => $lang['continue']), false, '_top');
                            html_draw_bottom();
                            exit;

                        }else {

                            html_draw_top();
                            html_display_msg($lang['emailaddresschanged'], $lang['newconfirmationemailfailure'], 'index.php', 'get', array('continue' => $lang['continue']), false, '_top');
                            html_draw_bottom();
                            exit;
                        }
                    }

                    // If Forum permits username changes we need to change the user's cookie.

                    if (forum_get_setting('allow_username_changes', 'Y')) {

                        // Fetch current logon.

                        $logon = bh_session_get_value('LOGON');

                        // Update the logon that matches the current logged on user

                        logon_update_logon_cookie($logon, $user_info['LOGON']);
                    }
                }

                // Force redirect to prevent refreshing the page prompting to user to resubmit form data.

                if ($admin_edit === true) {

                    header_redirect("admin_user.php?webtag=$webtag&uid=$uid&profile_updated=true", $lang['profileupdated']);
                    exit;

                }else {

                    header_redirect("edit_prefs.php?webtag=$webtag&updated=true", $lang['preferencesupdated']);
                    exit;
                }

            }else {

                $error_msg_array[] = $lang['failedtoupdateuserpreferences'];
                $valid = false;
            }

        }else {

            $error_msg_array[] = $lang['failedtoupdateuserdetails'];
            $valid = false;
        }
    }
}

// Split the DOB into usable variables.

if (isset($user_prefs['DOB']) && preg_match('/\d{4,}-\d{2,}-\d{2,}/u', $user_prefs['DOB'])) {

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
    $aid = md5(uniqid(mt_rand()));
}

// Check to see if we should show the set for all forums checkboxes

if ((bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0, 0) && $admin_edit) || (($uid == bh_session_get_value('UID')) && $admin_edit === false)) {
    $show_set_all = (forums_get_available_count() > 1);
}else {
    $show_set_all = false;
}

// Arrays to hold our attachments

$attachments_array = array();
$image_attachments_array = array();

// User's attachments for profile and avatar pictures

$user_attachments = get_users_attachments($uid, $attachments_array, $image_attachments_array);

// Prepare the attachments for use in a drop down.

$image_attachments_array = user_prefs_prep_attachments($image_attachments_array);

// Start Output Here

html_draw_top('attachments.js');

if ($admin_edit === true) {

    $user = user_get($uid);
    echo "<h1>{$lang['admin']} &raquo; ", forum_get_setting('forum_name', false, 'A Beehive Forum'), " &raquo; {$lang['userdetails']} &raquo; ", word_filter_add_ob_tags(htmlentities_array(format_user_name($user['LOGON'], $user['NICKNAME']))), "</h1>\n";

}else {

    echo "<h1>{$lang['userdetails']}</h1>\n";
}

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '600', ($admin_edit) ? 'center' : 'left');

}else if (isset($_GET['updated'])) {

    html_display_success_msg($lang['preferencesupdated'], '600', ($admin_edit) ? 'center' : 'left');
}

if ($admin_edit === true) echo "<div align=\"center\">\n";

echo "<br />\n";
echo "<form accept-charset=\"utf-8\" name=\"prefs\" action=\"edit_prefs.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden('aid', htmlentities_array($aid)), "\n";

if ($admin_edit === true) echo "  ", form_input_hidden('profileuid', htmlentities_array($uid)), "\n";

echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";

if ($show_set_all) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">{$lang['userinformation']}</td>\n";
    echo "                  <td align=\"left\" class=\"subhead\" width=\"1%\">&nbsp;</td>\n";
    echo "                </tr>\n";

}else {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"4\">{$lang['userinformation']}</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\" rowspan=\"13\" width=\"1%\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\">{$lang['memberno']}:&nbsp;</td>\n";
echo "                  <td align=\"left\">#{$user_info['UID']}&nbsp;</td>\n";
echo "                </tr>\n";

if ((bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0, 0) && $admin_edit) || (($uid == bh_session_get_value('UID')) && $admin_edit === false)) {

    if (forum_get_setting('allow_username_changes', 'Y') || (bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0, 0) && $admin_edit)) {

        echo "                <tr>\n";
        echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"150\">{$lang['username']}:&nbsp;</td>\n";
        echo "                  <td align=\"left\">", form_input_text("logon", (isset($user_info['LOGON']) ? htmlentities_array($user_info['LOGON']) : ""), 45, 15, "", "user_pref_field"), "</td>\n";
        echo "                </tr>\n";

    }else {

        echo "                <tr>\n";
        echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"150\">{$lang['username']}:&nbsp;</td>\n";
        echo "                  <td align=\"left\">", htmlentities_array($user_info['LOGON']), "&nbsp;</td>\n";
        echo "                </tr>\n";
    }

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\">{$lang['nickname']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">", form_input_text("nickname", (isset($user_info['NICKNAME']) ? htmlentities_array($user_info['NICKNAME']) : ""), 45, 32, "", "user_pref_field"), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\">{$lang['emailaddress']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">", form_input_text("email", (isset($user_info['EMAIL']) ? htmlentities_array($user_info['EMAIL']) : ""), 45, 80, "", "user_pref_field"), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\">&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\">{$lang['firstname']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">", form_input_text("firstname", (isset($user_prefs['FIRSTNAME']) ? htmlentities_array($user_prefs['FIRSTNAME']) : ""), 45, 32, "", "user_pref_field"), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\">{$lang['lastname']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">", form_input_text("lastname", (isset($user_prefs['LASTNAME']) ? htmlentities_array($user_prefs['LASTNAME']) : ""), 45, 32, "", "user_pref_field"), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\">{$lang['dateofbirth']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\">", form_dob_dropdowns($dob['YEAR'], $dob['MONTH'], $dob['DAY'], $dob['BLANK_FIELDS']), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\">&nbsp;</td>\n";
    echo "                </tr>\n";

}else {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" nowrap=\"nowrap\" width=\"150\">{$lang['username']}:&nbsp;</td>\n";
    echo "                  <td align=\"left\">", htmlentities_array($user_info['LOGON']), "&nbsp;</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\" valign=\"top\" nowrap=\"nowrap\">{$lang['homepageURL']}:&nbsp;</td>\n";
echo "                  <td align=\"left\">", form_input_text("homepage_url", (isset($user_prefs['HOMEPAGE_URL']) ? htmlentities_array($user_prefs['HOMEPAGE_URL']) : ""), 45, 255, "", "user_pref_field"), "</td>\n";
echo "                  <td align=\"left\" valign=\"top\" nowrap=\"nowrap\">", ($show_set_all) ? form_checkbox("homepage_url_global", "Y", '', (isset($user_prefs['HOMEPAGE_URL_GLOBAL']) ? $user_prefs['HOMEPAGE_URL_GLOBAL'] : false), "title=\"{$lang['setforallforums']}\"") : form_input_hidden("homepage_url_global", 'Y'), "&nbsp;</td>\n";
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

    if ($show_set_all) {

        echo "                <tr>\n";
        echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">{$lang['profilepicturedimensions']}</td>\n";
        echo "                  <td align=\"left\" class=\"subhead\" width=\"1%\">&nbsp;</td>\n";
        echo "                </tr>\n";

    }else {

        echo "                <tr>\n";
        echo "                  <td align=\"left\" class=\"subhead\" colspan=\"4\">{$lang['profilepicturedimensions']}</td>\n";
        echo "                </tr>\n";
    }

    echo "                <tr>\n";
    echo "                  <td align=\"left\" rowspan=\"4\" width=\"1%\">&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" width=\"150\" nowrap=\"nowrap\">{$lang['pictureURL']}:</td>\n";
    echo "                  <td align=\"left\">", form_input_text("pic_url", (isset($user_prefs['PIC_URL']) ? htmlentities_array($user_prefs['PIC_URL']) : ""), 45, 255, "", "user_pref_field"), "</td>\n";
    echo "                  <td align=\"right\" nowrap=\"nowrap\">", ($show_set_all) ? form_checkbox("pic_url_global", "Y", '', (isset($user_prefs['PIC_URL_GLOBAL']) ? $user_prefs['PIC_URL_GLOBAL'] : false), "title=\"{$lang['setforallforums']}\"") : form_input_hidden("pic_url_global", 'Y'), "&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" width=\"150\" nowrap=\"nowrap\">{$lang['selectattachment']}:</td>\n";
    echo "                  <td align=\"left\">", form_dropdown_array("pic_aid", $image_attachments_array, (isset($user_prefs['PIC_AID']) ? htmlentities_array($user_prefs['PIC_AID']) : ''), "", "user_pref_dropdown"), "</td>\n";
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

    if ($show_set_all) {

        echo "                <tr>\n";
        echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">{$lang['avatarpicturedimensions']}</td>\n";
        echo "                  <td align=\"left\" class=\"subhead\" width=\"1%\">&nbsp;</td>\n";
        echo "                </tr>\n";

    }else {

        echo "                <tr>\n";
        echo "                  <td align=\"left\" class=\"subhead\" colspan=\"4\">{$lang['avatarpicturedimensions']}</td>\n";
        echo "                </tr>\n";
    }

    echo "                <tr>\n";
    echo "                  <td align=\"left\" rowspan=\"6\" width=\"1%\">&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" width=\"150\" nowrap=\"nowrap\">{$lang['avatarURL']}:</td>\n";
    echo "                  <td align=\"left\">", form_input_text("avatar_url", (isset($user_prefs['AVATAR_URL']) ? htmlentities_array($user_prefs['AVATAR_URL']) : ""), 45, 255, "", "user_pref_field"), "</td>\n";
    echo "                  <td align=\"right\" nowrap=\"nowrap\">", ($show_set_all) ? form_checkbox("avatar_url_global", "Y", '', (isset($user_prefs['AVATAR_URL_GLOBAL']) ? $user_prefs['AVATAR_URL_GLOBAL'] : false), "title=\"{$lang['setforallforums']}\"") : form_input_hidden("avatar_url_global", 'Y'), "&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" width=\"150\" nowrap=\"nowrap\">{$lang['selectattachment']}:</td>\n";
    echo "                  <td align=\"left\">", form_dropdown_array("avatar_aid", $image_attachments_array, (isset($user_prefs['AVATAR_AID']) ? htmlentities_array($user_prefs['AVATAR_AID']) : ''), "", "user_pref_dropdown"), "</td>\n";
    echo "                </tr>\n";

}else {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" width=\"150\" nowrap=\"nowrap\">{$lang['pictureURL']}:</td>\n";
    echo "                  <td align=\"left\">", form_input_text("pic_url", (isset($user_prefs['PIC_URL']) ? htmlentities_array($user_prefs['PIC_URL']) : ""), 45, 255, "", "user_pref_field"), "</td>\n";
    echo "                  <td align=\"right\" nowrap=\"nowrap\">", ($show_set_all) ? form_checkbox("pic_url_global", "Y", '', (isset($user_prefs['PIC_URL_GLOBAL']) ? $user_prefs['PIC_URL_GLOBAL'] : false), "title=\"{$lang['setforallforums']}\"") : form_input_hidden("pic_url_global", 'Y'), "&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" width=\"150\" nowrap=\"nowrap\">{$lang['avatarURL']}:</td>\n";
    echo "                  <td align=\"left\">", form_input_text("avatar_url", (isset($user_prefs['AVATAR_URL']) ? htmlentities_array($user_prefs['AVATAR_URL']) : ""), 45, 255, "", "user_pref_field"), "</td>\n";
    echo "                  <td align=\"right\" nowrap=\"nowrap\">", ($show_set_all) ? form_checkbox("avatar_url_global", "Y", '', (isset($user_prefs['AVATAR_URL_GLOBAL']) ? $user_prefs['AVATAR_URL_GLOBAL'] : false), "title=\"{$lang['setforallforums']}\"") : form_input_hidden("avatar_url_global", 'Y'), "&nbsp;</td>\n";
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

if (forum_get_setting('attachments_enabled', 'Y') && $admin_edit === false) {

    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_submit("save", $lang['save']), "&nbsp;", form_button("attachments", $lang['uploadnewattachment'], "onclick=\"launchAttachWin('{$aid}', '$webtag')\""), "</td>\n";
    echo "    </tr>\n";

}else {

    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_submit("save", $lang['save']), "</td>\n";
    echo "    </tr>\n";
}

echo "  </table>\n";
echo "</form>\n";

if ($admin_edit === true) echo "</div>\n";

html_draw_bottom();

?>