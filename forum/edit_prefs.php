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

/* $Id: edit_prefs.php,v 1.34 2004-08-14 15:11:44 hodcroftcj Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Installation checking functions
include_once("./include/install.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum settings
$forum_settings = get_forum_settings();

include_once("./include/fixhtml.inc.php");
include_once("./include/form.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/post.inc.php");
include_once("./include/session.inc.php");
include_once("./include/user.inc.php");

if (!$user_sess = bh_session_check()) {

    html_draw_top();

    if (isset($_POST['user_logon']) && isset($_POST['user_password']) && isset($_POST['user_passhash'])) {

        if (perform_logon(false)) {

            $lang = load_language_file();
            $webtag = get_webtag($webtag_search);

            echo "<h1>{$lang['loggedinsuccessfully']}</h1>";
            echo "<div align=\"center\">\n";
            echo "<p><b>{$lang['presscontinuetoresend']}</b></p>\n";

            $request_uri = get_request_uri();

            echo "<form method=\"post\" action=\"$request_uri\" target=\"_self\">\n";
            echo form_input_hidden('webtag', $webtag);

            foreach($_POST as $key => $value) {
                echo form_input_hidden($key, _htmlentities(_stripslashes($value)));
            }

            echo form_submit(md5(uniqid(rand())), $lang['continue']), "&nbsp;";
            echo form_button(md5(uniqid(rand())), $lang['cancel'], "onclick=\"self.location.href='$request_uri'\""), "\n";
            echo "</form>\n";

            html_draw_bottom();
            exit;
        }
    }

    draw_logon_form(false);
    html_draw_bottom();
    exit;
}

// Load language file

$lang = load_language_file();

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

if (bh_session_get_value('UID') == 0) {
    html_guest_error();
    exit;
}

$error_html = "";

if (isset($_POST['submit'])) {

    $valid = true;

    // Required Fields

    if (isset($_POST['nickname']) && trim($_POST['nickname']) != "") {
        $user_info['NICKNAME'] = _stripslashes(trim($_POST['nickname']));
    }else {
        $error_html .= "<h2>{$lang['nicknamerequired']}</h2>";
        $valid = false;
    }

    if (isset($_POST['email']) && trim($_POST['email']) != "") {
        $user_info['EMAIL'] = _stripslashes(trim($_POST['email']));
    }else {
        $error_html .= "<h2>{$lang['emailaddressrequired']}</h2>";
        $valid = false;
    }

    if (isset($_POST['dob_year']) && isset($_POST['dob_month']) && isset($_POST['dob_day']) && checkdate($_POST['dob_month'], $_POST['dob_day'], $_POST['dob_year'])) {

        $dob['DAY']   = _stripslashes(trim($_POST['dob_day']));
        $dob['MONTH'] = _stripslashes(trim($_POST['dob_month']));
        $dob['YEAR']  = _stripslashes(trim($_POST['dob_year']));

        $user_prefs['DOB'] = sprintf("%04d-%02d-%02d", $dob['YEAR'], $dob['MONTH'], $dob['DAY']);
    }else {
        $error_html .= "<h2>{$lang['birthdayrequired']}</h2>";
        $valid = false;
    }

    // Optional fields

    if (isset($_POST['firstname'])) {
        if (user_check_pref('FIRSTNAME', _stripslashes(trim($_POST['firstname'])))) {
		   	$user_prefs['FIRSTNAME'] = _stripslashes(trim($_POST['firstname']));
		} else {
		    $error_html .= "<h2>{$lang['firstname']} {$lang['containsinvalidchars']}</h2>";
			$valid = false;
		}
    }

    if (isset($_POST['lastname'])) {
        if (user_check_pref('LASTNAME', _stripslashes(trim($_POST['lastname'])))) {
		   	$user_prefs['LASTNAME'] = _stripslashes(trim($_POST['lastname']));
		} else {
		    $error_html .= "<h2>{$lang['lastname']} {$lang['containsinvalidchars']}</h2>";
		    $valid = false;
		}
    }

    if (isset($_POST['homepage_url'])) {
        if (user_check_pref('HOMEPAGE_URL', _stripslashes(trim($_POST['homepage_url'])))) {
		   	$user_prefs['HOMEPAGE_URL'] = _stripslashes(trim($_POST['homepage_url']));
        	$user_prefs_global['HOMEPAGE_URL'] = (isset($_POST['homepage_url_global']) && $_POST['homepage_url_global'] == "Y") ? true : false;
        } else {
		    $error_html .= "<h2>{$lang['homepageURL']} {$lang['containsinvalidchars']}</h2>";
		    $valid = false;
		}
    }

    if (isset($_POST['pic_url'])) {
	    if (user_check_pref('PIC_URL', _stripslashes(trim($_POST['pic_url'])))) {
			$user_prefs['PIC_URL'] = _stripslashes(trim($_POST['pic_url']));
	        $user_prefs_global['PIC_URL'] = (isset($_POST['pic_url_global']) && $_POST['pic_url_global'] == "Y") ? true : false;
		} else {
		    $error_html .= "<h2>{$lang['pictureURL']} {$lang['containsinvalidchars']}</h2>";
		    $valid = false;
		}
	}

	if ($valid) {

        // User's UID for updating with.

        $uid = bh_session_get_value('UID');

        // Update basic settings in USER table

        user_update($uid, $user_info['NICKNAME'], $user_info['EMAIL']);

        // Update USER_PREFS

        user_update_prefs($uid, $user_prefs, $user_prefs_global);

        // Reinitialize the User's Session to save them having to logout and back in

        bh_session_init($uid);

        // IIS bug prevents redirect at same time as setting cookies.
        header_redirect_cookie("./edit_prefs.php?webtag=$webtag&updated=true");

    }
}

if (!isset($uid)) $uid = bh_session_get_value('UID');

// Get User Prefs
if (isset($user_prefs)) {
   	$user_prefs = array_merge(user_get_prefs($uid), $user_prefs);
} else {
	$user_prefs = user_get_prefs($uid);
}

// Get user information
if (isset($user_info)) {
   	$user_info = array_merge(user_get($uid), $user_info);
} else {
	$user_info = user_get($uid);
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

// Start Output Here

html_draw_top();

echo "<h1>{$lang['userdetails']}</h1>\n";

// Any error messages to display?

echo $error_html;
if (isset($_GET['updated'])) {
    echo "<h2>{$lang['preferencesupdated']}</h2>\n";
}

echo "<br />\n";
echo "<form name=\"prefs\" action=\"edit_prefs.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" colspan=\"3\">{$lang['userinformation']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"200\">{$lang['nickname']}:</td>\n";
echo "                  <td>", form_field("nickname", (isset($user_info['NICKNAME']) ? $user_info['NICKNAME'] : ""), 45, 32), "&nbsp;</td>\n";
echo "					<td>&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"200\">{$lang['emailaddress']}:</td>\n";
echo "                  <td>", form_field("email", (isset($user_info['EMAIL']) ? $user_info['EMAIL'] : ""), 45, 80), "&nbsp;</td>\n";
echo "					<td>&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"3\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"200\">{$lang['firstname']}:</td>\n";
echo "                  <td>", form_field("firstname", (isset($user_prefs['FIRSTNAME']) ? $user_prefs['FIRSTNAME'] : ""), 45, 32), "&nbsp;</td>\n";
echo "					<td>&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"200\">{$lang['lastname']}:</td>\n";
echo "                  <td>", form_field("lastname", (isset($user_prefs['LASTNAME']) ? $user_prefs['LASTNAME'] : ""), 45, 32), "&nbsp;</td>\n";
echo "					<td>&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>{$lang['dateofbirth']}:</td>\n";
echo "                  <td>", form_dob_dropdowns($dob['YEAR'], $dob['MONTH'], $dob['DAY'], $dob['BLANK_FIELDS']), "&nbsp;</td>\n";
echo "					<td>&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"200\">{$lang['homepageURL']}:</td>\n";
echo "                  <td>", form_field("homepage_url", (isset($user_prefs['HOMEPAGE_URL']) ? $user_prefs['HOMEPAGE_URL'] : ""), 45, 255), "&nbsp;</td>\n";
echo "					<td>".form_checkbox("homepage_url_global","Y",$lang['setforallforums'],$user_prefs['HOMEPAGE_URL_GLOBAL'])."</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"200\">{$lang['pictureURL']}:</td>\n";
echo "                  <td>", form_field("pic_url", (isset($user_prefs['PIC_URL']) ? $user_prefs['PIC_URL'] : ""), 45, 255), "&nbsp;</td>\n";
echo "					<td>".form_checkbox("pic_url_global","Y",$lang['setforallforums'],$user_prefs['PIC_URL_GLOBAL'])."</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"3\">&nbsp;</td>\n";
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
echo "      <td align=\"center\">", form_submit("submit", $lang['save']), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";

html_draw_bottom();

?>
