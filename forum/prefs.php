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

/* $Id: prefs.php,v 1.85 2004-01-04 15:28:37 decoyduck Exp $ */

// Compress the output
require_once("./include/gzipenc.inc.php");

// Enable the error handler
require_once("./include/errorhandler.inc.php");

//Check logged in status
require_once("./include/session.inc.php");
require_once("./include/header.inc.php");

if(!bh_session_check()){

    $uri = "./logon.php?final_uri=". urlencode(get_request_uri());
    header_redirect($uri);

}

require_once("./include/html.inc.php");
require_once("./include/user.inc.php");
require_once("./include/post.inc.php");
require_once("./include/fixhtml.inc.php");
require_once("./include/form.inc.php");
require_once("./include/header.inc.php");
require_once("./include/lang.inc.php");

$error_html = "";

$available_styles = array();
$style_names = array();

if ($dir = @opendir('styles')) {
    while (($file = readdir($dir)) !== false) {
        if (is_dir("styles/$file") && $file != '.' && $file != '..') {
            if (@file_exists("./styles/$file/desc.txt")) {
                if ($fp = fopen("./styles/$file/desc.txt", "r")) {
                    $available_styles[] = $file;
                    $style_names[] = _htmlentities(fread($fp, filesize("styles/$file/desc.txt")));
                    fclose($fp);
                }else {
                    $available_styles[] = $file;
                    $style_names[] = $file;
                }
            }
        }
    }
    closedir($dir);
}

array_multisort($style_names, $available_styles);

$available_langs = lang_get_available(); // get list of available languages
$available_langs_labels = array_merge(array($lang['browsernegotiation']), $available_langs);
array_unshift($available_langs, "");

$timezones = array("UTC -12h", "UTC -11h", "UTC -10h", "UTC -9h30m", "UTC -9h", "UTC -8h30m", "UTC -8h",
                   "UTC -7h", "UTC -6h", "UTC -5h", "UTC -4h", "UTC -3h30m", "UTC -3h", "UTC -2h", "UTC -1h",
                   "UTC", "UTC +1h", "UTC +2h", "UTC +3h",  "UTC +3h30m","UTC +4h", "UTC +4h30m", "UTC +5h",
                   "UTC +5h30m", "UTC +6h", "UTC +6h30m", "UTC +7h", "UTC +8h", "UTC +9h", "UTC +9h30m",
                   "UTC +10h", "UTC +10h30m", "UTC +11h", "UTC +11h30m", "UTC +12h", "UTC +13h", "UTC +14h");

$timezones_data = array(-12,-11,-10,-9.5,-9,-8.5,-8,-7,-6,-5,-4,-3.5,-3,-2,-1,0,1,2,3,3.5,4,4.5,5,5.5,
                        6,6.5,7,8,9,9.5,10,10.5,11,11.5,12,13,14);

if (isset($HTTP_POST_VARS['submit'])) {

    if (bh_session_get_value('UID') == 0) {

        html_guest_error();
	exit;
    }

    $valid = true;
    $update_password = false;

    // Required fields

    if (isset($HTTP_POST_VARS['pw']) && trim($HTTP_POST_VARS['pw']) != "") {
        if (isset($HTTP_POST_VARS['cpw']) && trim($HTTP_POST_VARS['cpw']) != "") {
            if ($HTTP_POST_VARS['pw'] == $HTTP_POST_VARS['cpw']) {
                if (_htmlentities(trim($HTTP_POST_VARS['pw'])) != trim($HTTP_POST_VARS['pw'])) {
                    $error_html.= "<h2>{$lang['passwdmustnotcontainHTML']}</h2>\n";
                    $valid = false;
                }
                if (strlen(trim($HTTP_POST_VARS['pw'])) < 6) {
                    $error_html.= "<h2>{$lang['passwdtooshort']}</h2>\n";
                    $valid = false;
                }
                if ($valid) {
                    $update_password = true;
                    $t_password = $HTTP_POST_VARS['pw'];
                }
            }else {
                $error_html.= "<h2>{$lang['passwdsdonotmatch']}</h2>";
                $valid = false;
            }
        }else {
            $error_html.= "<h2>{$lang['passwdsdonotmatch']}</h2>";
            $valid = false;
        }
    }

    if (isset($HTTP_POST_VARS['nickname']) && trim($HTTP_POST_VARS['nickname']) != "") {
        $t_nickname = _stripslashes(trim($HTTP_POST_VARS['nickname']));       
    }else {
        $error_html.= "<h2>{$lang['nicknamerequired']}</h2>";
        $valid = false;
    }

    if (isset($HTTP_POST_VARS['email']) && trim($HTTP_POST_VARS['email']) != "") {
        $t_email = _stripslashes(trim($HTTP_POST_VARS['email']));      
    }else {
        $error_html.= "<h2>{$lang['emailaddressrequired']}</h2>";
        $valid = false;
    }

    if (isset($HTTP_POST_VARS['dob_year']) && isset($HTTP_POST_VARS['dob_month']) && isset($HTTP_POST_VARS['dob_day']) && checkdate($HTTP_POST_VARS['dob_month'], $HTTP_POST_VARS['dob_day'], $HTTP_POST_VARS['dob_year'])) {
        $t_dob_day   = _stripslashes(trim($HTTP_POST_VARS['dob_day']));
        $t_dob_month = _stripslashes(trim($HTTP_POST_VARS['dob_month']));
        $t_dob_year  = _stripslashes(trim($HTTP_POST_VARS['dob_year']));
        $t_user_dob  = "$t_dob_year-$t_dob_month-$t_dob_day";
        $t_dob_blank_fields = ($t_dob_year == 0 || $t_dob_month == 0 || $t_dob_day == 0) ? true : false;
    }else {
        $error_html.= "<h2>{$lang['birthdayrequired']}</h2>";
        $valid = false;
    }

    // Optional fields

    if (isset($HTTP_POST_VARS['firstname']) && trim($HTTP_POST_VARS['firstname']) != "") {
        $t_firstname = _stripslashes(trim($HTTP_POST_VARS['firstname']));       
    }else {
        $t_firstname = "";
    }

    if (isset($HTTP_POST_VARS['lastname']) && trim($HTTP_POST_VARS['lastname']) != "") {
        $t_lastname = _stripslashes(trim($HTTP_POST_VARS['lastname']));
    }else {
        $t_lastname = "";
    }

    if (isset($HTTP_POST_VARS['homepage_url']) && trim($HTTP_POST_VARS['homepage_url']) != "") {
        $t_homepage_url = _stripslashes(trim($HTTP_POST_VARS['homepage_url']));
    }else {
        $t_homepage_url = "";
    }

    if (isset($HTTP_POST_VARS['pic_url']) && trim($HTTP_POST_VARS['pic_url']) != "") {
        $t_pic_url = _stripslashes(trim($HTTP_POST_VARS['pic_url']));
    }else {
        $t_pic_url = "";
    }

    if (isset($HTTP_POST_VARS['email_notify']) && $HTTP_POST_VARS['email_notify'] == "Y") {
        $t_email_notify = _stripslashes(trim($HTTP_POST_VARS['email_notify']));
    }else {
        $t_email_notify = "";
    }

    if (isset($HTTP_POST_VARS['pm_notify']) && $HTTP_POST_VARS['pm_notify'] == "Y") {
        $t_pm_notify = _stripslashes(trim($HTTP_POST_VARS['pm_notify']));
    }else {
        $t_pm_notify = "";
    }

    if (isset($HTTP_POST_VARS['pm_notify_email']) && $HTTP_POST_VARS['pm_notify_email'] == "Y") {
        $t_pm_notify_email = _stripslashes(trim($HTTP_POST_VARS['pm_notify_email']));
    }else {
        $t_pm_notify_email = "";
    }

    if (isset($HTTP_POST_VARS['dl_saving']) && $HTTP_POST_VARS['dl_saving'] == "Y") {
        $t_dl_saving = _stripslashes(trim($HTTP_POST_VARS['dl_saving']));
    }else {
        $t_dl_saving = "";
    }

    if (isset($HTTP_POST_VARS['mark_as_of_int']) && $HTTP_POST_VARS['mark_as_of_int'] == "Y") {
        $t_mark_as_of_int = _stripslashes(trim($HTTP_POST_VARS['mark_as_of_int']));
    }else {
        $t_mark_as_of_int = "";
    }

    if (isset($HTTP_POST_VARS['view_sigs']) && $HTTP_POST_VARS['view_sigs'] == "Y") {
        $t_view_sigs = _stripslashes(trim($HTTP_POST_VARS['view_sigs']));
    }else {
        $t_view_sigs = "";
    }

    if (isset($HTTP_POST_VARS['anon_logon']) && $HTTP_POST_VARS['anon_logon'] == "Y") {
        $t_anon_logon = 1;
    }else {
        $t_anon_logon = 0;
    }

    if (isset($HTTP_POST_VARS['show_stats']) && $HTTP_POST_VARS['show_stats'] == "Y") {
        $t_show_stats = 1;
    }else {
        $t_show_stats = 0;
    }

    if (isset($HTTP_POST_VARS['timezone'])) {
        $t_timezone = _stripslashes(trim($HTTP_POST_VARS['timezone']));
    }else {
        $t_timezone = 0;
    }

    if (isset($HTTP_POST_VARS['posts_per_page'])) {
        $t_posts_per_page = _stripslashes(trim($HTTP_POST_VARS['posts_per_page']));
    }else {
        $t_posts_per_page = 10;
    }

    if (isset($HTTP_POST_VARS['font_size'])) {
        $t_font_size = _stripslashes(trim($HTTP_POST_VARS['font_size']));
    }else {
        $t_font_size = 10;
    }

    if (isset($HTTP_POST_VARS['style'])) {
        $t_style = _stripslashes(trim($HTTP_POST_VARS['style']));
    }else {
        $t_style = $default_style;
    }

    if (isset($HTTP_POST_VARS['language'])) {
        $t_language = _stripslashes(trim($HTTP_POST_VARS['language']));
    }else {
        $t_language = "";
    }

    if (isset($HTTP_POST_VARS['start_page'])) {
        $t_start_page = _stripslashes(trim($HTTP_POST_VARS['start_page']));
    }else {
        $t_start_page = 0;
    }

    if (isset($HTTP_POST_VARS['dob_display'])) {
        $t_dob_display = _stripslashes(trim($HTTP_POST_VARS['dob_display']));
    }else {
        $t_dob_display = 0;
    }

    if (isset($HTTP_POST_VARS['sig_content']) && trim($HTTP_POST_VARS['sig_content']) != "") {
        $t_sig_content = _stripslashes(trim($HTTP_POST_VARS['sig_content']));
    }else {
        $t_sig_content = "";
    }

    if (isset($HTTP_POST_VARS['sig_html']) && $HTTP_POST_VARS['sig_html'] == "Y") {
        $t_sig_html = "Y";
    }else {
        $t_sig_html = "N";
    }

    $t_sig_content_check = preg_replace('/\&\#([0-9]+)\;/me', "chr('\\1')", rawurldecode($t_sig_content));

    if (preg_match("/<.+(src|background|codebase|background-image)(=|s?:s?).+getattachment.php.+>/ ", $t_sig_content_check) && $t_sig_html != "N") {
        $error_html.= "<h2>{$lang['notallowedembedattachmentsignature']}</h2>\n";
        $valid = false;
    }

    if ($valid) {

        // User's UID for updating with.

        $uid = bh_session_get_value('UID');

        // Check the signature code to see if it needs running through fix_html

        if ($t_sig_html == "Y") {
            $t_sig_content = fix_html($t_sig_content);
        }else {
            $t_sig_content = _stripslashes($t_sig_content);
        }

        // Update basic settings in USER table

        user_update($uid, $t_nickname, $t_email);

        // Update USER_PREFS

        user_update_prefs($uid, $t_firstname, $t_lastname, $t_user_dob,
                          $t_homepage_url, $t_pic_url, $t_email_notify, $t_timezone, $t_dl_saving,
                          $t_mark_as_of_int, $t_posts_per_page, $t_font_size, $t_style, $t_view_sigs,
                          $t_start_page, $t_language, $t_pm_notify, $t_pm_notify_email, $t_dob_display,
                          $t_anon_logon, $t_show_stats);

        // Update USER_SIG

        user_update_sig($uid, $t_sig_content, $t_sig_html);

        // Update the password (and cookie)

        if ($update_password) {

            user_change_pw($uid, $t_password);

            // Username array

            if (isset($HTTP_COOKIE_VARS['bh_remember_username']) && is_array($HTTP_COOKIE_VARS['bh_remember_username'])) {
                $username_array = $HTTP_COOKIE_VARS['bh_remember_username'];
            }else {
                $username_array = array();
            }

            // Password array

            if (isset($HTTP_COOKIE_VARS['bh_remember_password']) && is_array($HTTP_COOKIE_VARS['bh_remember_password'])) {
                $password_array = $HTTP_COOKIE_VARS['bh_remember_password'];
            }else {
                $password_array = array();
            }

            // Passhash array

            if (isset($HTTP_COOKIE_VARS['bh_remember_passhash']) && is_array($HTTP_COOKIE_VARS['bh_remember_passhash'])) {
                $passhash_array = $HTTP_COOKIE_VARS['bh_remember_passhash'];
            }else {
                $passhash_array = array();
            }

            // Update the password that matches the current logged on user

            foreach ($username_array as $key => $logon) {
                if (stristr($logon, bh_session_get_value('LOGON'))) {
                    $passw = str_repeat(chr(32), strlen(_stripslashes($t_password)));
                    $passh = md5(_stripslashes($t_password));
                    if (isset($password_array[$key]) && isset($passhash_array[$key])) {
                        bh_setcookie("bh_remember_password[$key]", $passw, time() + YEAR_IN_SECONDS);
                        bh_setcookie("bh_remember_passhash[$key]", $passh, time() + YEAR_IN_SECONDS);
                    }
                }
            }
        }

        // Reinitialize the User's Session to save them having to logout and back in

        bh_session_init($uid);

        // IIS bug prevents redirect at same time as setting cookies.

        if (isset($HTTP_SERVER_VARS['SERVER_SOFTWARE']) && !strstr($HTTP_SERVER_VARS['SERVER_SOFTWARE'], 'Microsoft-IIS')) {

            header_redirect("./prefs.php?updated=true");

        }else {

            html_draw_top();

            // Try a Javascript redirect
            echo "<script language=\"javascript\" type=\"text/javascript\">\n";
            echo "<!--\n";
            echo "document.location.href = './prefs.php?updated=true';\n";
            echo "//-->\n";
            echo "</script>";

            // If they're still here, Javascript's not working. Give up, give a link.
            echo "<div align=\"center\"><p>&nbsp;</p><p>&nbsp;</p>";
            echo "<p>{$lang['userpreferences']}</p>";

            form_quick_button("./prefs.php", $lang['continue'], "", "", "_top");

            html_draw_bottom();
            exit;
        }
    }
}

$user = user_get(bh_session_get_value('UID'));
$user_prefs = user_get_prefs(bh_session_get_value('UID'));

user_get_sig(bh_session_get_value('UID'), $user_sig['SIG_CONTENT'], $user_sig['SIG_HTML']);

// Split the DOB into usable variables.

if (isset($user_prefs['DOB']) && preg_match("/\d{4,}-\d{2,}-\d{2,}/", $user_prefs['DOB'])) {
    list($dob_year, $dob_month, $dob_day) = explode('-', $user_prefs['DOB']);
    $dob_blank_fields = ($dob_year == 0 || $dob_month == 0 || $dob_day == 0) ? true : false;
}else {
    $dob_year = 0;
    $dob_month = 0;
    $dob_day = 0;
    $dob_blank_fields = true;
}

// Start output here

html_draw_top();

echo "<h1>{$lang['userpreferences']}</h1>\n";

if (!empty($error_html)) {
    echo $error_html;
}else if (isset($HTTP_GET_VARS['updated'])) {

    echo "<h2>{$lang['preferencesupdated']}</h2>\n";

    $top_html = "./styles/".(bh_session_get_value('STYLE') ? bh_session_get_value('STYLE') : $default_style) . "/top.html";

    if (!file_exists($top_html)) {
        $top_html = "./top.html";
    }

    echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
    echo "<!--\n";
    
    if (isset($t_font_size)) {
        echo "top.document.body.rows='60,' + $t_font_size * 2 + ',*';\n";
    }elseif (isset($user_prefs['FONT_SIZE'])) {
        if ($user_prefs['FONT_SIZE'] == '') {
            echo "top.document.body.rows='60,20,*';\n";
        }else{
            echo "top.document.body.rows='60,' + {$user_prefs['FONT_SIZE']} * 2 + ',*';\n";
        }
    }else {
        echo "top.document.body.rows='60,20,*';\n";
    }    

    echo "top.frames['ftop'].location.replace('$top_html'); top.frames['fnav'].location.reload();\n";
    echo "-->\n";
    echo "</script>";
}

echo "<br />\n";
echo "<div class=\"postbody\">\n";
echo "  <form name=\"prefs\" action=\"{$HTTP_SERVER_VARS['PHP_SELF']}\" method=\"post\" target=\"_self\">\n";
echo "    <table cellpadding=\"0\" cellspacing=\"0\">\n";
echo "      <tr>\n";
echo "        <td>\n";
echo "          <table class=\"box\">\n";
echo "            <tr>\n";
echo "              <td class=\"posthead\">\n";
echo "                <table class=\"posthead\" width=\"100%\">\n";
echo "                  <tr>\n";
echo "                    <td class=\"subhead\" colspan=\"3\">User Details</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td>{$lang['newpasswd']}</td>\n";
echo "                    <td>:</td>\n";
echo "                    <td>", form_field("pw", "", 37, 0, "password"), "&nbsp;</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td>{$lang['confirmpasswd']}</td>\n";
echo "                    <td>:</td>\n";
echo "                    <td>", form_field("cpw", "", 37, 0, "password"), "&nbsp;</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td colspan=\"3\" align=\"right\"><span style=\"font-size: 10px\">({$lang['leaveblanktoretaincurrentpasswd']})</span></td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td colspan=\"3\">&nbsp;</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td>{$lang['nickname']}</td>\n";
echo "                    <td>:</td>\n";
echo "                    <td>", form_field("nickname", (isset($t_nickname) ? $t_nickname : $user['NICKNAME']), 37, 32), "&nbsp;</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td>{$lang['emailaddress']}</td>\n";
echo "                    <td>:</td>\n";
echo "                    <td>", form_field("email", (isset($t_email) ? $t_email : $user['EMAIL']), 37, 80), "&nbsp;</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td colspan=\"3\">&nbsp;</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td>{$lang['firstname']}</td>\n";
echo "                    <td>:</td>\n";
echo "                    <td>", form_field("firstname", (isset($t_firstname) ? $t_firstname : $user_prefs['FIRSTNAME']), 37, 32), "&nbsp;</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td>{$lang['lastname']}</td>\n";
echo "                    <td>:</td>\n";
echo "                    <td>", form_field("lastname", (isset($t_lastname) ? $t_lastname : $user_prefs['LASTNAME']), 37, 32), "&nbsp;</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td>{$lang['dateofbirth']}</td>\n";
echo "                    <td>:</td>\n";

if (isset($t_dob_year) && isset($t_dob_month) && isset($t_dob_year) && isset($t_dob_blank_fields)) {
    echo "                    <td>", form_dob_dropdowns($t_dob_year, $t_dob_month, $t_dob_day, $t_dob_blank_fields), "&nbsp;</td>\n";
}else {
    echo "                    <td>", form_dob_dropdowns($dob_year, $dob_month, $dob_day, $dob_blank_fields), "&nbsp;</td>\n";
}

echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td>{$lang['homepageURL']}</td>\n";
echo "                    <td>:</td>\n";
echo "                    <td>", form_field("homepage_url", (isset($t_homepage_url) ? $t_homepage_url : $user_prefs['HOMEPAGE_URL']), 37, 255), "&nbsp;</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td>{$lang['pictureURL']}</td>\n";
echo "                    <td>:</td>\n";
echo "                    <td>", form_field("pic_url", (isset($t_pic_url) ? $t_pic_url : $user_prefs['PIC_URL']), 37, 255), "&nbsp;</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td colspan=\"3\">&nbsp;</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td colspan=\"3\">\n";
echo "                      <table class=\"posthead\" cellspacing=\"0\" cellpadding=\"0\" width=\"100%\">\n";
echo "                        <tr>\n";
echo "                          <td class=\"subhead\" colspan=\"2\">{$lang['forumoptions']}</td>\n";
echo "                        </tr>\n";
echo "                        <tr>\n";
echo "                          <td>", form_checkbox("email_notify", "Y", $lang['notifybyemail'], (isset($t_email_notify) && $t_email_notify == "Y") ? true : (isset($user_prefs['EMAIL_NOTIFY']) && $user_prefs['EMAIL_NOTIFY'] == "Y")), "</td>\n";
echo "                        </tr>\n";
echo "                        <tr>\n";
echo "                          <td>", form_checkbox("pm_notify", "Y", $lang['notifyofnewpm'], (isset($t_pm_notify) && $t_pm_notify == "Y") ? true : (isset($user_prefs['PM_NOTIFY']) && $user_prefs['PM_NOTIFY'] == "Y")), "</td>\n";
echo "                        </tr>\n";
echo "                        <tr>\n";
echo "                          <td>", form_checkbox("pm_notify_email", "Y", $lang['notifyofnewpmemail'], (isset($t_pm_notify_email) && $t_pm_notify_email == "Y") ? true : (isset($user_prefs['PM_NOTIFY_EMAIL']) && $user_prefs['PM_NOTIFY_EMAIL'] == "Y")), "</td>\n";
echo "                        </tr>\n";
echo "                        <tr>\n";
echo "                          <td>", form_checkbox("dl_saving", "Y", $lang['daylightsaving'], (isset($t_dl_saving) && $t_dl_saving == "Y") ? true : (isset($user_prefs['DL_SAVING']) && $user_prefs['DL_SAVING'] == "Y")), "</td>\n";
echo "                        </tr>\n";
echo "                        <tr>\n";
echo "                          <td>", form_checkbox("mark_as_of_int", "Y", $lang['autohighinterest'], (isset($t_mark_as_of_int) && $t_mark_as_of_int == "Y") ? true : (isset($user_prefs['MARK_AS_OF_INT']) && $user_prefs['MARK_AS_OF_INT'] == "Y")), "</td>\n";
echo "                        </tr>\n";
echo "                        <tr>\n";
echo "                          <td>", form_checkbox("view_sigs", "Y", $lang['globallyignoresigs'], (isset($t_view_sigs) && $t_view_sigs == "Y") ? true : (isset($user_prefs['VIEW_SIGS']) && $user_prefs['VIEW_SIGS'] == "Y")), "</td>\n";
echo "                        </tr>\n";
echo "                        <tr>\n";
echo "                          <td>", form_checkbox("anon_logon", "Y", $lang['browseanonymously'], (isset($t_anon_logon) && $t_anon_logon == 1) ? true : (isset($user_prefs['ANON_LOGON']) && $user_prefs['ANON_LOGON'] == 1)), "</td>\n";
echo "                        </tr>\n";
echo "                        <tr>\n";
echo "                          <td>", form_checkbox("show_stats", "Y", $lang['showforumstats'], (isset($t_show_stats) && $t_show_stats == 1) ? true : (isset($user_prefs['SHOW_STATS']) && $user_prefs['SHOW_STATS'] == 1)), "</td>\n";
echo "                        </tr>\n";
echo "                        <tr>\n";
echo "                          <td>&nbsp;</td>\n";
echo "                        </tr>\n";
echo "                      </table>\n";
echo "                    </td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td>{$lang['timezonefromGMT']}</td>\n";
echo "                    <td>:</td>\n";
echo "                    <td>", form_dropdown_array("timezone", $timezones_data, $timezones, (isset($t_timezone) ? $t_timezone : $user_prefs['TIMEZONE'])), "</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td>{$lang['postsperpage']}</td>\n";
echo "                    <td>:</td>\n";

if (isset($t_posts_per_page)) {
    echo "                    <td>", form_dropdown_array("posts_per_page", array(5,10,20), array(5,10,20), $t_posts_per_page), "</td>\n";
}elseif (isset($user_prefs['POSTS_PER_PAGE'])) {
    echo "                    <td>", form_dropdown_array("posts_per_page", array(5,10,20), array(5,10,20), $user_prefs['POSTS_PER_PAGE']), "</td>\n";
}else {
    echo "                    <td>", form_dropdown_array("posts_per_page", array(5,10,20), array(5,10,20), 10), "</td>\n";
}

echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td>{$lang['fontsize']}</td>\n";
echo "                    <td>:</td>\n";

if (isset($t_font_size)) {
    echo "                    <td>", form_dropdown_array("font_size", range(5, 15), array('5pt', '6pt', '7pt', '8pt', '9pt', '10pt', '11pt', '12pt', '13pt', '14pt', '15pt'), $t_font_size), "</td>\n";
}elseif (isset($user_prefs['FONT_SIZE'])) {
    if ($user_prefs['FONT_SIZE'] == '') {
        echo "                    <td>", form_dropdown_array("font_size", range(5, 15), array('5pt', '6pt', '7pt', '8pt', '9pt', '10pt', '11pt', '12pt', '13pt', '14pt', '15pt'), '10pt'), "</td>\n";
    }else{
        echo "                    <td>", form_dropdown_array("font_size", range(5, 15), array('5pt', '6pt', '7pt', '8pt', '9pt', '10pt', '11pt', '12pt', '13pt', '14pt', '15pt'), $user_prefs['FONT_SIZE']), "</td>\n";
    }
}else {
    echo "                    <td>", form_dropdown_array("font_size", range(5, 15), array('5pt', '6pt', '7pt', '8pt', '9pt', '10pt', '11pt', '12pt', '13pt', '14pt', '15pt'), '10pt'), "</td>\n";
}

echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td>{$lang['forumstyle']}</td>\n";
echo "                    <td>:</td>\n";

if (isset($t_style)) {
    $selected_style = $t_style;
    if (!in_array($selected_style, $available_styles)) {
        $selected_style = $default_style;
    }
}else {
    if ($selected_style = bh_session_get_value('STYLE')) {
        if (!in_array($selected_style, $available_styles)) {
            $selected_style = $default_style;
        }
    }else {
        $selected_style = $default_style;
    }
}
      
foreach ($available_styles as $key => $style) {
    if (strtolower($style) == strtolower($selected_style)) {
        break;
    }
}
      
reset($available_styles);
      
if (isset($key)) {
    echo "                    <td>", form_dropdown_array("style", $available_styles, $style_names, $available_styles[$key]), "</td>\n";
}else {
    echo "                    <td>", form_dropdown_array("style", $available_styles, $style_names, $available_styles[0]), "</td>\n";
}

echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td>{$lang['preferredlang']}</td>\n";
echo "                    <td>:</td>\n";
echo "                    <td>", form_dropdown_array("language", $available_langs, $available_langs_labels, (isset($t_language) ? $t_language : bh_session_get_value("LANGUAGE"))), "</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td>{$lang['startpage']}</td>\n";
echo "                    <td>:</td>\n";

if (isset($t_start_page)) {
    echo "                    <td>", form_dropdown_array("start_page", range(0, 2), array($lang['start'], $lang['messages'], $lang['pminbox']), $t_start_page), "</td>\n";
}elseif (isset($user_prefs['DOB_DISPLAY'])) {
    echo "                    <td>", form_dropdown_array("start_page", range(0, 2), array($lang['start'], $lang['messages'], $lang['pminbox']), $user_prefs['START_PAGE']), "</td>\n";
}else {
    echo "                    <td>", form_dropdown_array("start_page", range(0, 2), array($lang['start'], $lang['messages'], $lang['pminbox']), 0), "</td>\n";
}

echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td>{$lang['ageanddob']}</td>\n";
echo "                    <td>:</td>\n";

if (isset($t_dob_display)) {
    echo "                    <td>", form_dropdown_array("dob_display", range(0, 2), array($lang['neitheragenordob'], $lang['showonlyage'], $lang['showageanddob']), $t_dob_display), "</td>\n";
}elseif (isset($user_prefs['DOB_DISPLAY'])) {
    echo "                    <td>", form_dropdown_array("dob_display", range(0, 2), array($lang['neitheragenordob'], $lang['showonlyage'], $lang['showageanddob']), $user_prefs['DOB_DISPLAY']), "</td>\n";
}else {
    echo "                    <td>", form_dropdown_array("dob_display", range(0, 2), array($lang['neitheragenordob'], $lang['showonlyage'], $lang['showageanddob']), 0), "</td>\n";
}

echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td colspan=\"3\">&nbsp;</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td class=\"subhead\" colspan=\"3\">{$lang['signature']}</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td colspan=\"3\">", form_textarea("sig_content", (isset($t_sig_content) ? _htmlentities(_stripslashes($t_sig_content)) : _htmlentities(_stripslashes($user_sig['SIG_CONTENT']))), 4, 60), "</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td colspan=\"3\" align=\"right\">", form_checkbox("sig_html", "Y", $lang['containsHTML'], (isset($t_sig_html) && $t_sig_html == "Y") ? true : ($user_sig['SIG_HTML'] == "Y")), "</td>\n";
echo "                  </tr>\n";
echo "	              </table>\n";
echo "              </td>\n";
echo "            </tr>\n";
echo "          </table>\n";
echo "	      </td>\n";
echo "      </tr>\n";
echo "      <tr>\n";
echo "        <td align=\"center\"><p>", form_submit("submit", $lang['save']), "</p></td>\n";
echo "      </tr>\n";
echo "    </table>\n";
echo "  </form>\n";
echo "</div>\n";

html_draw_bottom();

?>