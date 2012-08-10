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

// Includes required by this page.
require_once BH_INCLUDE_PATH. 'attachments.inc.php';
require_once BH_INCLUDE_PATH. 'banned.inc.php';
require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'email.inc.php';
require_once BH_INCLUDE_PATH. 'fixhtml.inc.php';
require_once BH_INCLUDE_PATH. 'form.inc.php';
require_once BH_INCLUDE_PATH. 'format.inc.php';
require_once BH_INCLUDE_PATH. 'header.inc.php';
require_once BH_INCLUDE_PATH. 'html.inc.php';
require_once BH_INCLUDE_PATH. 'lang.inc.php';
require_once BH_INCLUDE_PATH. 'logon.inc.php';
require_once BH_INCLUDE_PATH. 'perm.inc.php';
require_once BH_INCLUDE_PATH. 'post.inc.php';
require_once BH_INCLUDE_PATH. 'session.inc.php';
require_once BH_INCLUDE_PATH. 'user.inc.php';
require_once BH_INCLUDE_PATH. 'word_filter.inc.php';

// Check we're logged in correctly
if (!session::logged_in()) {
    html_guest_error();
}

$admin_edit = false;

if (session::check_perm(USER_PERM_ADMIN_TOOLS, 0)) {

    if (isset($_GET['profileuid'])) {

        if (is_numeric($_GET['profileuid'])) {

            $uid = $_GET['profileuid'];
            $admin_edit = true;

        } else {

            html_draw_error(gettext("No user specified."));
        }

    } else if (isset($_POST['profileuid'])) {

        if (is_numeric($_POST['profileuid'])) {

            $uid = $_POST['profileuid'];
            $admin_edit = true;

        } else {

            html_draw_error(gettext("No user specified."));
        }

    } else {

        $uid = session::get_value('UID');
    }

} else {

    $uid = session::get_value('UID');
}

if (!(session::check_perm(USER_PERM_ADMIN_TOOLS, 0)) && ($uid != session::get_value('UID'))) {
    html_draw_error(gettext("You do not have permission to use this section."));
}

// Get User Prefs
$user_prefs = user_get_prefs($uid);

// Get user information
$user_info = user_get($uid);

// Array to hold error messages
$error_msg_array = array();

// List of allowed image types
$allowed_image_types_array = array(
    'jpg', 
    'jpeg', 
    'png', 
    'gif'
);

$allowed_image_types = "*.". implode(", *.", $allowed_image_types_array);

// Initialise the global prefs array
$user_prefs_global = array();

if (isset($_POST['save'])) {

    $valid = true;

    // Duplicate the user_info array.
    $user_info_new = $user_info;

    // Required Fields
    if ((session::check_perm(USER_PERM_ADMIN_TOOLS, 0, 0) && $admin_edit) || (($uid == session::get_value('UID')) && $admin_edit === false)) {

        if (forum_get_setting('allow_username_changes', 'Y') || (session::check_perm(USER_PERM_ADMIN_TOOLS, 0, 0) && $admin_edit)) {

            if (isset($_POST['logon']) && strlen(trim($_POST['logon'])) > 0) {

                $user_info_new['LOGON'] = trim($_POST['logon']);

                if (mb_strlen($user_info_new['LOGON']) < 2) {

                    $error_msg_array[] = gettext("Username must be a minimum of 2 characters long");
                    $valid = false;
                }

                if (mb_strlen($user_info_new['LOGON']) > 15) {

                    $error_msg_array[] = gettext("Username must be a maximum of 15 characters long");
                    $valid = false;
                }

                if (logon_is_banned($user_info_new['LOGON'])) {

                    $error_msg_array[] = gettext("Logon not permitted. Choose another!");
                    $valid = false;
                }

                if (user_exists($user_info_new['LOGON'], $uid)) {

                    $error_msg_array[] = gettext("Sorry, a user with that name already exists");
                    $valid = false;
                }

            } else {

                $error_msg_array[] = gettext("A logon name is required");
                $valid = false;
            }
        }

        if (isset($_POST['nickname']) && strlen(trim($_POST['nickname'])) > 0) {

            $user_info_new['NICKNAME'] = strip_tags(trim($_POST['nickname']));

            if (nickname_is_banned($user_info_new['NICKNAME'])) {

                $error_msg_array[] = gettext("Nickname not permitted. Choose another!");
                $valid = false;
            }

        } else {

            $error_msg_array[] = gettext("A nickname is required");
            $valid = false;
        }

        if (isset($_POST['email']) && strlen(trim($_POST['email'])) > 0) {

            $user_info_new['EMAIL'] = trim($_POST['email']);

            if (!email_address_valid($user_info_new['EMAIL'])) {

                $error_msg_array[] = gettext("Invalid email address format");
                $valid = false;

            } else {

                if (email_is_banned($user_info_new['EMAIL'])) {

                    $error_msg_array[] = gettext("Email Address not permitted. Choose another!");
                    $valid = false;
                }

                if (forum_get_setting('require_unique_email', 'Y') && !email_is_unique($user_info_new['EMAIL'], $uid)) {

                    $error_msg_array[] = gettext("Email Address already in use. Choose another!");
                    $valid = false;
                }
            }

        } else {

            $error_msg_array[] = gettext("Email address is required!");
            $valid = false;
        }

        if (isset($_POST['dob_year']) && isset($_POST['dob_month']) && isset($_POST['dob_day']) && @checkdate($_POST['dob_month'], $_POST['dob_day'], $_POST['dob_year'])) {

            $dob['DAY']   = trim($_POST['dob_day']);
            $dob['MONTH'] = trim($_POST['dob_month']);
            $dob['YEAR']  = trim($_POST['dob_year']);

            $user_prefs['DOB'] = sprintf("%04d-%02d-%02d", $dob['YEAR'], $dob['MONTH'], $dob['DAY']);

        } else {

            $error_msg_array[] = gettext("Date of birth is required or is invalid");
            $valid = false;
        }

        // Optional fields
        if (isset($_POST['firstname'])) {

            $user_prefs['FIRSTNAME'] = trim($_POST['firstname']);

            if (!user_check_pref('FIRSTNAME', $user_prefs['FIRSTNAME'])) {

                $error_msg_array[] = sprintf(gettext("%s contains invalid characters!"), gettext("First name"));
                $valid = false;
            }
        }

        if (isset($_POST['lastname'])) {

            $user_prefs['LASTNAME'] = trim($_POST['lastname']);

            if (!user_check_pref('LASTNAME', $user_prefs['LASTNAME'])) {

                $error_msg_array[] = sprintf(gettext("%s contains invalid characters!"), gettext("Last name"));
                $valid = false;
            }
        }
    }

    if (isset($_POST['homepage_url'])) {

        $user_prefs['HOMEPAGE_URL'] = trim($_POST['homepage_url']);
        $user_prefs_global['HOMEPAGE_URL'] = (isset($_POST['homepage_url_global'])) ? $_POST['homepage_url_global'] == "Y" : true;

        if (strlen(trim($user_prefs['HOMEPAGE_URL'])) > 0) {

            if (preg_match('/^http:\/\//u', $user_prefs['HOMEPAGE_URL']) < 1) {
                $error_msg_array[] = gettext("Homepage URL must include http:// schema.");
                $valid = false;

            } else if (!user_check_pref('HOMEPAGE_URL', $user_prefs['HOMEPAGE_URL'])) {

                $error_msg_array[] = sprintf(gettext("%s contains invalid characters!"), gettext("Homepage URL"));
                $valid = false;
            }
        }
    }

    if (isset($_POST['pic_url'])) {

        $user_prefs['PIC_URL'] = trim($_POST['pic_url']);
        $user_prefs_global['PIC_URL'] = (isset($_POST['pic_url_global'])) ? $_POST['pic_url_global'] == "Y" : true;

        if (strlen(trim($user_prefs['PIC_URL'])) > 0) {

            if (preg_match('/^http:\/\//u', $user_prefs['PIC_URL']) < 1) {
                $error_msg_array[] = gettext("Picture URL must include http:// schema.");
                $valid = false;

            } else if (!user_check_pref('PIC_URL', $user_prefs['PIC_URL'])) {

                $error_msg_array[] = sprintf(gettext("%s contains invalid characters!"), gettext("Picture URL"));
                $valid = false;
            }
        }
    }

    if (isset($_POST['pic_aid'])) {

        $user_prefs['PIC_AID'] = $_POST['pic_aid'];
        $user_prefs_global['PIC_AID'] = (isset($_POST['pic_url_global'])) ? $_POST['pic_url_global'] == "Y" : true;

        if (strlen(trim($user_prefs['PIC_AID'])) > 0) {

            if (!is_md5($user_prefs['PIC_AID'])) {

                $error_msg_array[] = gettext("Invalid Attachment. Check that is hasn't been deleted.");
                $valid = false;

            } else if (isset($user_prefs['PIC_URL']) && strlen(trim($user_prefs['PIC_URL'])) > 0) {

                $error_msg_array[] = gettext("To use an attachment for your profile picture the Picture URL field must be blank.");
                $valid = false;

            } else if (($attachment_dir = attachments_check_dir())) {

                if (!($attachment_details = attachments_get_by_hash($user_prefs['PIC_AID']))) {

                    $error_msg_array[] = gettext("Unsupported image attachment. You can only use jpg, gif and png image attachments for your avatar and profile picture.");
                    $valid = false;
                }

                $path_parts = pathinfo($attachment_details['filename']);

                if (!isset($path_parts['extension']) || !in_array($path_parts['extension'], $allowed_image_types_array)) {
                    
                    $error_msg_array[] = gettext("Unsupported image attachment. You can only use jpg, gif and png image attachments for your avatar and profile picture.");
                    $valid = false;
                }                    

                if (!($image_info = getimagesize("$attachment_dir/{$user_prefs['PIC_AID']}"))) {
                    
                    $error_msg_array[] = gettext("Unsupported image attachment. You can only use jpg, gif and png image attachments for your avatar and profile picture.");
                    $valid = false;
                }

                if (($image_info[0] > 95) || ($image_info[1] > 95)) {

                    $error_msg_array[] = gettext("Selected attachment is too large for profile picture. Maximum dimensions are 95x95px");
                    $valid = false;
                }

            } else {

                $error_msg_array[] = gettext("Attachments have been disabled by the forum owner.");
                $valid = false;
            }
        }
    }

    if (isset($_POST['avatar_url'])) {

        $user_prefs['AVATAR_URL'] = trim($_POST['avatar_url']);
        $user_prefs_global['AVATAR_URL'] = (isset($_POST['avatar_url_global'])) ? $_POST['avatar_url_global'] == "Y" : true;

        if (strlen(trim($user_prefs['AVATAR_URL'])) > 0) {

            if (preg_match('/^http:\/\//u', $user_prefs['AVATAR_URL']) < 1) {
                $error_msg_array[] = gettext("Avatar URL must include http:// schema.");
                $valid = false;

            } else if (!user_check_pref('AVATAR_URL', $user_prefs['AVATAR_URL'])) {

                $error_msg_array[] = sprintf(gettext("%s contains invalid characters!"), gettext("Avatar URL"));
                $valid = false;
            }
        }
    }

    if (isset($_POST['avatar_aid'])) {

        $user_prefs['AVATAR_AID'] = $_POST['avatar_aid'];
        $user_prefs_global['AVATAR_AID'] = (isset($_POST['avatar_url_global'])) ? $_POST['avatar_url_global'] == "Y" : true;

        if (strlen(trim($user_prefs['AVATAR_AID'])) > 0) {

            if (!is_md5($user_prefs['AVATAR_AID'])) {

                $error_msg_array[] = gettext("Invalid Attachment. Check that is hasn't been deleted.");
                $valid = false;

            } else if (isset($user_prefs['AVATAR_URL']) && strlen(trim($user_prefs['AVATAR_URL'])) > 0) {

                $error_msg_array[] = gettext("To use an attachment for your avatar picture the Avatar URL field must be blank.");
                $valid = false;

            } else if (($attachment_dir = attachments_check_dir())) {

                if (!($attachment_details = attachments_get_by_hash($user_prefs['AVATAR_AID']))) {
                    
                    $error_msg_array[] = gettext("Unsupported image attachment. You can only use jpg, gif and png image attachments for your avatar and profile picture.");
                    $valid = false;
                }
                    
                $path_parts = pathinfo($attachment_details['filename']);

                if (!isset($path_parts['extension']) || !in_array($path_parts['extension'], $allowed_image_types_array)) {
                    
                    $error_msg_array[] = gettext("Unsupported image attachment. You can only use jpg, gif and png image attachments for your avatar and profile picture.");
                    $valid = false;
                }

                if (!($image_info = getimagesize("$attachment_dir/{$user_prefs['AVATAR_AID']}"))) {

                    $error_msg_array[] = gettext("Unsupported image attachment. You can only use jpg, gif and png image attachments for your avatar and profile picture.");
                    $valid = false;
                }
                    
                if (($image_info[0] > 95) || ($image_info[1] > 95)) {

                    $error_msg_array[] = gettext("Selected attachment is too large for avatar picture. Maximum dimensions are 15x15px");
                    $valid = false;
                }

            } else {

                $error_msg_array[] = gettext("Attachments have been disabled by the forum owner.");
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
                if (($uid == session::get_value('UID')) && $admin_edit === false) {

                    if (forum_get_setting('require_email_confirmation', 'Y') && ($user_info_new['EMAIL'] != $user_info['EMAIL'])) {

                        if (email_send_changed_email_confirmation($uid)) {

                            perm_user_apply_email_confirmation($uid);

                            html_draw_top(sprintf('title=%s', gettext("My Controls - User Details - Email address has been changed")), 'class=window_title');
                            html_display_msg(gettext("Email address has been changed"), gettext("Your email address has been changed and a new confirmation email has been sent. Please check and read the email for further instructions."), 'index.php', 'get', array('continue' => gettext("Continue")), false, '_top');
                            html_draw_bottom();
                            exit;

                        } else {

                            html_draw_top(sprintf("title=%s", gettext("Error")));
                            html_display_msg(gettext("Email address has been changed"), gettext("You have changed your email address, but we were unable to send a confirmation request. Please contact the forum owner for assistance."), 'index.php', 'get', array('continue' => gettext("Continue")), false, '_top');
                            html_draw_bottom();
                            exit;
                        }
                    }
                }

                // Force redirect to prevent refreshing the page prompting to user to resubmit form data.
                if ($admin_edit === true) {

                    header_redirect("admin_user.php?webtag=$webtag&uid=$uid&profile_updated=true", gettext("Profile updated."));
                    exit;

                } else {

                    header_redirect("edit_prefs.php?webtag=$webtag&updated=true", gettext("Preferences were successfully updated."));
                    exit;
                }

            } else {

                $error_msg_array[] = gettext("Some or all of your user preferences could not be updated. Please try again later.");
                $valid = false;
            }

        } else {

            $error_msg_array[] = gettext("Some or all of your user account details could not be updated. Please try again later.");
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

} else {

    $dob['YEAR']  = 0;
    $dob['MONTH'] = 0;
    $dob['DAY']   = 0;
    $dob['BLANK_FIELDS'] = true;
}

if (isset($_POST['aid']) && is_md5($_POST['aid'])) {
    $aid = $_POST['aid'];
} else {
    $aid = md5(uniqid(mt_rand()));
}

// Check to see if we should show the set for all forums checkboxes
if ((session::check_perm(USER_PERM_ADMIN_TOOLS, 0, 0) && $admin_edit) || (($uid == session::get_value('UID')) && $admin_edit === false)) {
    $show_set_all = (forums_get_available_count() > 1);
} else {
    $show_set_all = false;
}

// Arrays to hold our attachments
$attachments_array = array();
$image_attachments_array = array();

// User's attachments for profile and avatar pictures
$user_attachments = attachments_get_users($uid, $attachments_array, $image_attachments_array);

// Prepare the attachments for use in a drop down.
$image_attachments_array = user_prefs_prep_attachments($image_attachments_array);

// Start Output Here
if ($admin_edit === true) {

    $user = user_get($uid);

    html_draw_top(sprintf('title=%s', sprintf(gettext("Admin - User Details - %s"), format_user_name($user['LOGON'], $user['NICKNAME']))), 'attachments.js', 'class=window_title');

    echo "<h1>", gettext("Admin"), "<img src=\"", html_style_image('separator.png'), "\" alt=\"\" border=\"0\" />", gettext("User Details"), "<img src=\"", html_style_image('separator.png'), "\" alt=\"\" border=\"0\" />", word_filter_add_ob_tags(format_user_name($user['LOGON'], $user['NICKNAME']), true), "</h1>\n";

} else {

    html_draw_top(sprintf('title=%s', gettext("My Controls - User Details")), 'class=window_title');

    echo "<h1>", gettext("User Details"), "</h1>\n";
}

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '600', ($admin_edit) ? 'center' : 'left');

} else if (isset($_GET['updated'])) {

    html_display_success_msg(gettext("Preferences were successfully updated."), '600', ($admin_edit) ? 'center' : 'left');
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
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">", gettext("User Information"), "</td>\n";
    echo "                  <td align=\"left\" class=\"subhead\" width=\"1%\">&nbsp;</td>\n";
    echo "                </tr>\n";

} else {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"4\">", gettext("User Information"), "</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\" rowspan=\"13\" width=\"1%\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" style=\"white-space: nowrap\">", gettext("Member No."), ":&nbsp;</td>\n";
echo "                  <td align=\"left\">#{$user_info['UID']}&nbsp;</td>\n";
echo "                </tr>\n";

if ((session::check_perm(USER_PERM_ADMIN_TOOLS, 0, 0) && $admin_edit) || (($uid == session::get_value('UID')) && $admin_edit === false)) {

    if (forum_get_setting('allow_username_changes', 'Y') || (session::check_perm(USER_PERM_ADMIN_TOOLS, 0, 0) && $admin_edit)) {

        echo "                <tr>\n";
        echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"150\">", gettext("Username"), ":&nbsp;</td>\n";
        echo "                  <td align=\"left\">", form_input_text("logon", (isset($user_info['LOGON']) ? htmlentities_array($user_info['LOGON']) : ""), 45, 15, "", "user_pref_field"), "</td>\n";
        echo "                </tr>\n";

    } else {

        echo "                <tr>\n";
        echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"150\">", gettext("Username"), ":&nbsp;</td>\n";
        echo "                  <td align=\"left\">", htmlentities_array($user_info['LOGON']), "&nbsp;</td>\n";
        echo "                </tr>\n";
    }

    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\">", gettext("Nickname"), ":&nbsp;</td>\n";
    echo "                  <td align=\"left\">", form_input_text("nickname", (isset($user_info['NICKNAME']) ? htmlentities_array($user_info['NICKNAME']) : ""), 45, 32, "", "user_pref_field"), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\">", gettext("Email address"), ":&nbsp;</td>\n";
    echo "                  <td align=\"left\">", form_input_text("email", (isset($user_info['EMAIL']) ? htmlentities_array($user_info['EMAIL']) : ""), 45, 80, "", "user_pref_field"), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\">&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\">", gettext("First name"), ":&nbsp;</td>\n";
    echo "                  <td align=\"left\">", form_input_text("firstname", (isset($user_prefs['FIRSTNAME']) ? htmlentities_array($user_prefs['FIRSTNAME']) : ""), 45, 32, "", "user_pref_field"), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\">", gettext("Last name"), ":&nbsp;</td>\n";
    echo "                  <td align=\"left\">", form_input_text("lastname", (isset($user_prefs['LASTNAME']) ? htmlentities_array($user_prefs['LASTNAME']) : ""), 45, 32, "", "user_pref_field"), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\">", gettext("Date of Birth"), ":&nbsp;</td>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\">", form_dob_dropdowns($dob['YEAR'], $dob['MONTH'], $dob['DAY'], $dob['BLANK_FIELDS']), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\">&nbsp;</td>\n";
    echo "                </tr>\n";

} else {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" style=\"white-space: nowrap\" width=\"150\">", gettext("Username"), ":&nbsp;</td>\n";
    echo "                  <td align=\"left\">", htmlentities_array($user_info['LOGON']), "&nbsp;</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\" valign=\"top\" style=\"white-space: nowrap\">", gettext("Homepage URL"), ":&nbsp;</td>\n";
echo "                  <td align=\"left\">", form_input_text("homepage_url", (isset($user_prefs['HOMEPAGE_URL']) ? htmlentities_array($user_prefs['HOMEPAGE_URL']) : ""), 45, 255, "", "user_pref_field"), "</td>\n";
echo "                  <td align=\"left\" valign=\"top\" style=\"white-space: nowrap\">", ($show_set_all) ? form_checkbox("homepage_url_global", "Y", '', (isset($user_prefs['HOMEPAGE_URL_GLOBAL']) ? $user_prefs['HOMEPAGE_URL_GLOBAL'] : false), sprintf('title="%s"', gettext("Set for all forums?"))) : form_input_hidden("homepage_url_global", 'Y'), "&nbsp;</td>\n";
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
        echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">", gettext("Profile Picture (Max 95x95px)"), "</td>\n";
        echo "                  <td align=\"left\" class=\"subhead\" width=\"1%\">&nbsp;</td>\n";
        echo "                </tr>\n";

    } else {

        echo "                <tr>\n";
        echo "                  <td align=\"left\" class=\"subhead\" colspan=\"4\">", gettext("Profile Picture (Max 95x95px)"), "</td>\n";
        echo "                </tr>\n";
    }

    echo "                <tr>\n";
    echo "                  <td align=\"left\" rowspan=\"3\" width=\"1%\">&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" width=\"150\" style=\"white-space: nowrap\">", gettext("Picture URL"), ":</td>\n";
    echo "                  <td align=\"left\">", form_input_text("pic_url", (isset($user_prefs['PIC_URL']) ? htmlentities_array($user_prefs['PIC_URL']) : ""), 45, 255, "", "user_pref_field"), "</td>\n";
    echo "                  <td align=\"right\" style=\"white-space: nowrap\">", ($show_set_all) ? form_checkbox("pic_url_global", "Y", '', (isset($user_prefs['PIC_URL_GLOBAL']) ? $user_prefs['PIC_URL_GLOBAL'] : false), sprintf('title="%s"', gettext("Set for all forums?"))) : form_input_hidden("pic_url_global", 'Y'), "&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" width=\"150\" style=\"white-space: nowrap\">", gettext("Select Attachment"), ":</td>\n";
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
        echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">", gettext("Avatar Picture (Max 16x16px)"), "</td>\n";
        echo "                  <td align=\"left\" class=\"subhead\" width=\"1%\">&nbsp;</td>\n";
        echo "                </tr>\n";

    } else {

        echo "                <tr>\n";
        echo "                  <td align=\"left\" class=\"subhead\" colspan=\"4\">", gettext("Avatar Picture (Max 16x16px)"), "</td>\n";
        echo "                </tr>\n";
    }

    echo "                <tr>\n";
    echo "                  <td align=\"left\" rowspan=\"6\" width=\"1%\">&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" width=\"150\" style=\"white-space: nowrap\">", gettext("Avatar URL"), ":</td>\n";
    echo "                  <td align=\"left\">", form_input_text("avatar_url", (isset($user_prefs['AVATAR_URL']) ? htmlentities_array($user_prefs['AVATAR_URL']) : ""), 45, 255, "", "user_pref_field"), "</td>\n";
    echo "                  <td align=\"right\" style=\"white-space: nowrap\">", ($show_set_all) ? form_checkbox("avatar_url_global", "Y", '', (isset($user_prefs['AVATAR_URL_GLOBAL']) ? $user_prefs['AVATAR_URL_GLOBAL'] : false), sprintf('title="%s"', gettext("Set for all forums?"))) : form_input_hidden("avatar_url_global", 'Y'), "&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" width=\"150\" style=\"white-space: nowrap\">", gettext("Select Attachment"), ":</td>\n";
    echo "                  <td align=\"left\">", form_dropdown_array("avatar_aid", $image_attachments_array, (isset($user_prefs['AVATAR_AID']) ? htmlentities_array($user_prefs['AVATAR_AID']) : ''), "", "user_pref_dropdown"), "</td>\n";
    echo "                </tr>\n";

} else {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" width=\"150\" style=\"white-space: nowrap\">", gettext("Picture URL"), ":</td>\n";
    echo "                  <td align=\"left\">", form_input_text("pic_url", (isset($user_prefs['PIC_URL']) ? htmlentities_array($user_prefs['PIC_URL']) : ""), 45, 255, "", "user_pref_field"), "</td>\n";
    echo "                  <td align=\"right\" style=\"white-space: nowrap\">", ($show_set_all) ? form_checkbox("pic_url_global", "Y", '', (isset($user_prefs['PIC_URL_GLOBAL']) ? $user_prefs['PIC_URL_GLOBAL'] : false), sprintf('title="%s"', gettext("Set for all forums?"))) : form_input_hidden("pic_url_global", 'Y'), "&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" width=\"150\" style=\"white-space: nowrap\">", gettext("Avatar URL"), ":</td>\n";
    echo "                  <td align=\"left\">", form_input_text("avatar_url", (isset($user_prefs['AVATAR_URL']) ? htmlentities_array($user_prefs['AVATAR_URL']) : ""), 45, 255, "", "user_pref_field"), "</td>\n";
    echo "                  <td align=\"right\" style=\"white-space: nowrap\">", ($show_set_all) ? form_checkbox("avatar_url_global", "Y", '', (isset($user_prefs['AVATAR_URL_GLOBAL']) ? $user_prefs['AVATAR_URL_GLOBAL'] : false), sprintf('title="%s"', gettext("Set for all forums?"))) : form_input_hidden("avatar_url_global", 'Y'), "&nbsp;</td>\n";
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
    echo "      <td align=\"center\">";
    echo "        ", form_submit("save", gettext("Save")), "&nbsp;<a href=\"attachments.php?webtag=$webtag&amp;aid=$aid\" class=\"button popup 660x500\" id=\"attachments\"><span>", gettext("Attachments"), "</span></a>\n";
    echo "    </tr>\n";

} else {

    echo "    <tr>\n";
    echo "      <td align=\"center\">", form_submit("save", gettext("Save")), "</td>\n";
    echo "    </tr>\n";
}

echo "  </table>\n";
echo "</form>\n";

if ($admin_edit === true) echo "</div>\n";

html_draw_bottom();

?>