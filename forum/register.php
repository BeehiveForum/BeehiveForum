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

/* $Id: register.php,v 1.87 2004-04-26 11:21:10 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum settings
$forum_settings = get_forum_settings();

include_once("./include/constants.inc.php");
include_once("./include/fixhtml.inc.php");
include_once("./include/form.inc.php");
include_once("./include/format.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/session.inc.php");
include_once("./include/user.inc.php");

// Where are we going after we've logged on?

if (isset($_GET['final_uri'])) {
    $final_uri = rawurldecode($_GET['final_uri']);
}

if ($user_sess = bh_session_check()) {

    html_draw_top();
    echo "<div align=\"center\">\n";
    echo "<p>{$lang['user']} ", bh_session_get_value('LOGON'), " {$lang['alreadyloggedin']}.</p>\n";

    if (isset($final_uri)) {
        form_quick_button("./index.php". $lang['continue'], "final_uri", $final_uri, "_top");
    }else {
        form_quick_button("./index.php". $lang['continue'], false, false, "_top");
    }

    echo "</div>\n";
    html_draw_bottom();
    exit;
}

// Load language file

$lang = load_language_file();

// Make sure we have a webtag

$webtag = get_webtag();

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

$available_emots = array();
$emot_names = array();

if ($dir = @opendir('emoticons')) {
    while (($file = readdir($dir)) !== false) {
        if (is_dir("emoticons/$file") && $file != '.' && $file != '..') {
            if (@file_exists("./emoticons/$file/desc.txt")) {
                if ($fp = fopen("./emoticons/$file/desc.txt", "r")) {
                    $available_emots[] = $file;
                    $emot_names[] = _htmlentities(fread($fp, filesize("emoticons/$file/desc.txt")));
                    fclose($fp);
                }else {
                    $available_emots[] = $file;
                    $emot_names[] = $file;
                }
            }
        }
    }
    closedir($dir);
}

array_multisort($emot_names, $available_emots);

$available_langs = lang_get_available(); // Get available languages
$available_langs_labels = array_merge(array($lang['browsernegotiation']), $available_langs);
array_unshift($available_langs, "");

$timezones = array("GMT -12h", "GMT -11h", "GMT -10h", "GMT -9h30m", "GMT -9h", "GMT -8h30m", "GMT -8h",
                   "GMT -7h", "GMT -6h", "GMT -5h", "GMT -4h", "GMT -3h30m", "GMT -3h", "GMT -2h", "GMT -1h",
                   "GMT", "GMT +1h", "GMT +2h", "GMT +3h",  "GMT +3h30m","GMT +4h", "GMT +4h30m", "GMT +5h",
                   "GMT +5h30m", "GMT +6h", "GMT +6h30m", "GMT +7h", "GMT +8h", "GMT +9h", "GMT +9h30m",
                   "GMT +10h", "GMT +10h30m", "GMT +11h", "GMT +11h30m", "GMT +12h", "GMT +13h", "GMT +14h");

$timezones_data = array(-12,-11,-10,-9.5,-9,-8.5,-8,-7,-6,-5,-4,-3.5,-3,-2,-1,0,1,2,3,3.5,4,4.5,5,5.5,
                        6,6.5,7,8,9,9.5,10,10.5,11,11.5,12,13,14);

if (isset($_POST['submit'])) {

    $valid = true;
    $error_html = "";

    if (isset($_POST['LOGON']) && strlen(trim($_POST['LOGON'])) > 0) {

        $new_user['LOGON'] = strtoupper(_stripslashes(trim($_POST['LOGON'])));

        if (!preg_match("/^[a-z0-9_-]+$/i", $new_user['LOGON'])) {
            $error_html.= "<h2>{$lang['usernameinvalidchars']}</h2>\n";
            $valid = false;
        }

        if (strlen($new_user['LOGON']) < 2) {
            $error_html.= "<h2>{$lang['usernametooshort']}</h2>\n";
            $valid = false;
        }

        if (strlen($new_user['LOGON']) > 15) {
            $error_html.= "<h2>{$lang['usernametoolong']}</h2>\n";
            $valid = false;
        }

    }else {

        $error_html.= "<h2>{$lang['usernamerequired']}</h2>\n";
        $valid = false;
    }

    if (isset($_POST['PW']) && strlen(trim($_POST['PW'])) > 0) {

        $new_user['PW'] = _stripslashes(trim($_POST['PW']));

        if (!preg_match("/^[a-z0-9_-]+$/i", $new_user['PW'])) {
            $error_html.= "<h2>{$lang['passwordinvalidchars']}</h2>\n";
            $valid = false;
        }

        if (strlen($new_user['PW']) < 6) {
            $error_html.= "<h2>{$lang['passwdtooshort']}</h2>\n";
            $valid = false;
        }

    }else {

        $error_html.= "<h2>{$lang['passwdrequired']}</h2>\n";
        $valid.= false;
    }

    if (isset($_POST['CPW']) && strlen(trim($_POST['CPW'])) > 0) {

        $new_user['CPW'] = _stripslashes(trim($_POST['CPW']));

        if (_htmlentities($new_user['CPW']) != $new_user['CPW']) {
            $error_html.= "<h2>{$lang['passwdmustnotcontainHTML']}</h2>\n";
            $valid = false;
        }

    }else {

        $error_html.= "<h2>{$lang['confirmationpasswdrequired']}</h2>\n";
        $valid = false;
    }

    if (isset($_POST['NICKNAME']) && strlen(trim($_POST['NICKNAME'])) > 0) {

        $new_user['NICKNAME'] = _stripslashes(trim($_POST['NICKNAME']));

    }else {

        $error_html.= "<h2>{$lang['nicknamerequired']}</h2>\n";
        $valid = false;
    }

    if (isset($_POST['EMAIL']) && strlen(trim($_POST['EMAIL'])) > 0) {

        $new_user['EMAIL'] = _stripslashes(trim($_POST['EMAIL']));

        if (!ereg("^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*$", $new_user['EMAIL'])) {

            $error = "<h2>{$lang['invalidemailaddressformat']}</h2>\n";
            $valid = false;
        }

    }else {

        $error_html.= "<h2>{$lang['emailrequired']}</h2>\n";
        $valid = false;
    }

    if (isset($_POST['dob_year']) && isset($_POST['dob_month']) && isset($_POST['dob_day']) && checkdate($_POST['dob_month'], $_POST['dob_day'], $_POST['dob_year'])) {

        $new_user['DOB_DAY']   = _stripslashes(trim($_POST['dob_day']));
        $new_user['DOB_MONTH'] = _stripslashes(trim($_POST['dob_month']));
        $new_user['DOB_YEAR']  = _stripslashes(trim($_POST['dob_year']));

        $new_user['DOB'] = "{$new_user['DOB_YEAR']}-{$new_user['DOB_MONTH']}-{$new_user['DOB_DAY']}";
        $new_user['DOB_BLANK_FIELDS'] = ($new_user['DOB_YEAR'] == 0 || $new_user['DOB_MONTH'] == 0 || $new_user['DOB_DAY'] == 0) ? true : false;

    }else {

        $error_html.= "<h2>{$lang['birthdayrequired']}</h2>";
        $valid = false;
    }

    if (isset($_POST['FIRSTNAME']) && strlen(trim($_POST['FIRSTNAME'])) > 0) {
        $new_user['FIRSTNAME'] = _stripslashes(trim($_POST['FIRSTNAME']));
    }else {
        $new_user['FIRSTNAME'] = "";
    }

    if (isset($_POST['LASTNAME']) && strlen(trim($_POST['LASTNAME'])) > 0) {
        $new_user['LASTNAME'] = _stripslashes(trim($_POST['LASTNAME']));
    }else {
        $new_user['LASTNAME'] = "";
    }

    if (isset($_POST['SIG_CONTENT']) && strlen(trim($_POST['SIG_CONTENT'])) > 0) {
        $new_user['SIG_CONTENT'] = trim($_POST['SIG_CONTENT']);
    }else {
        $new_user['SIG_CONTENT'] = "";
    }

    if (isset($_POST['SIG_HTML']) && $_POST['SIG_HTML'] == "Y") {
        $new_user['SIG_CONTENT'] = fix_html($new_user['SIG_CONTENT']);
        $new_user['SIG_HTML'] = "Y";
    }else {
        $new_user['SIG_CONTENT'] = _stripslashes($new_user['SIG_CONTENT']);
        $new_user['SIG_HTML'] = "N";
    }

    if (isset($_POST['EMAIL_NOTIFY']) && $_POST['EMAIL_NOTIFY'] == "Y") {
        $new_user['EMAIL_NOTIFY'] = "Y";
    }else {
        $new_user['EMAIL_NOTIFY'] = "N";
    }

    if (isset($_POST['PM_NOTIFY_EMAIL']) && $_POST['PM_NOTIFY_EMAIL'] == "Y") {
        $new_user['PM_NOTIFY_EMAIL'] = "Y";
    }else {
        $new_user['PM_NOTIFY_EMAIL'] = "N";
    }

    if (isset($_POST['PM_NOTIFY']) && $_POST['PM_NOTIFY'] == "Y") {
        $new_user['PM_NOTIFY'] = "Y";
    }else {
        $new_user['PM_NOTIFY'] = "N";
    }

    if (isset($_POST['MARK_AS_OF_INT']) && $_POST['MARK_AS_OF_INT'] == "Y") {
        $new_user['MARK_AS_OF_INT'] = "Y";
    }else {
        $new_user['MARK_AS_OF_INT'] = "N";
    }

    if (isset($_POST['DL_SAVING']) && $_POST['DL_SAVING'] == "Y") {
        $new_user['DL_SAVING'] = "Y";
    }else {
        $new_user['DL_SAVING'] = "N";
    }

    if (isset($_POST['TIMEZONE']) && _in_array($_POST['TIMEZONE'], $timezones_data)) {
        $new_user['TIMEZONE'] = $_POST['TIMEZONE'];
    }else {
        $new_user['TIMEZONE'] = 0;
    }

    if (isset($_POST['LANGUAGE']) && _in_array($_POST['LANGUAGE'], $available_langs_labels)) {
        $new_user['LANGUAGE'] = $_POST['LANGUAGE'];
    }else {
        $new_user['LANGUAGE'] = forum_get_setting('default_language');
    }

    if (isset($_POST['STYLE']) && _in_array($_POST['STYLE'], $available_styles)) {
        $new_user['STYLE'] = $_POST['STYLE'];
    }else {
        $new_user['STYLE'] = forum_get_setting('default_style');
    }

    if (isset($_POST['EMOTICONS']) && _in_array($_POST['EMOTICONS'], $available_emots)) {
        $new_user['EMOTICONS'] = $_POST['EMOTICONS'];
    }else {
        $new_user['EMOTICONS'] = forum_get_setting('default_emoticons');
    }

    if ($valid) {

        if ($new_user['PW'] != $new_user['CPW']) {
            $error_html.= "<h2>{$lang['passwdsdonotmatch']}</h2>\n";
            $valid = false;
        }

        if (strtolower($new_user['LOGON']) == strtolower($new_user['PW'])) {
            $error_html.= "<h2>{$lang['usernamesameaspasswd']}</h2>\n";
            $valid = false;
        }
    }

    if ($valid) {

        if (user_exists($new_user['LOGON'])) {
            $error_html.= "<h2>{$lang['usernameexists']}</h2>\n";
            $valid = false;
        }
    }

    if ($valid) {

        $new_uid = user_create($new_user['LOGON'], $new_user['PW'], $new_user['NICKNAME'], $new_user['EMAIL']);

        if ($new_uid > -1) {

            user_update_prefs($new_uid, $new_user);
            user_update_sig($new_uid, $new_user['SIG_CONTENT'], $new_user['SIG_HTML']);

            bh_session_init($new_uid);

            // Retrieve existing cookie data if any

            // Username array

            if (isset($_COOKIE['bh_remember_username']) && is_array($_COOKIE['bh_remember_username'])) {
                $username_array = $_COOKIE['bh_remember_username'];
            }else {
                $username_array = array();
            }

            // Password array

            if (isset($_COOKIE['bh_remember_password']) && is_array($_COOKIE['bh_remember_password'])) {
                $password_array = $_COOKIE['bh_remember_password'];
            }else {
                $password_array = array();
            }

            // Passhash array

            if (isset($_COOKIE['bh_remember_passhash']) && is_array($_COOKIE['bh_remember_passhash'])) {
                $passhash_array = $_COOKIE['bh_remember_passhash'];
            }else {
                $passhash_array = array();
            }

            // Prepare Form Data

            $passw = str_repeat(chr(32), strlen($new_user['PW']));
            $passh = md5(_stripslashes($new_user['PW']));

            if (($key = _array_search($new_user['LOGON'], $username_array)) !== false) {

                unset($username_array[$key]);
                unset($password_array[$key]);
                unset($passhash_array[$key]);
            }

            array_unshift($username_array, $new_user['LOGON']);

            if (isset($_POST['remember_user']) && ($_POST['remember_user'] == 'Y')) {

                array_unshift($password_array, $passw);
                array_unshift($passhash_array, $passh);

            }else {

                array_unshift($password_array, "");
                array_unshift($passhash_array, "");
            }

            // set / update the username and password cookies

            for ($i = 0; $i < sizeof($username_array); $i++) {

                bh_setcookie("bh_remember_username[$i]", $username_array[$i], time() + YEAR_IN_SECONDS);

                if (isset($password_array[$i]) && isset($passhash_array[$i])) {

                    bh_setcookie("bh_remember_password[$i]", $password_array[$i], time() + YEAR_IN_SECONDS);
                    bh_setcookie("bh_remember_passhash[$i]", $passhash_array[$i], time() + YEAR_IN_SECONDS);

                }else {

                    bh_setcookie("bh_remember_password[$i]", "", time() + YEAR_IN_SECONDS);
                    bh_setcookie("bh_remember_passhash[$i]", "", time() + YEAR_IN_SECONDS);
                }
            }

            // set / update the cookie that remembers if the user
            // has any logon form data.

            bh_setcookie("bh_logon", "1", time() + YEAR_IN_SECONDS);

            html_draw_top();

            echo "<div align=\"center\">\n";
            echo "<p>{$lang['userrecordcreated']}</p>\n";

            if (isset($final_uri)) {
                form_quick_button("./index.php", $lang['continue'], "final_uri", rawurlencode($final_uri), "_top");
            }else {
                form_quick_button("./index.php", $lang['continue'], false, false, "_top");
            }

            echo "</div>\n";
            html_draw_bottom();
            exit;

        }else {

            $error_html.= "<h2>{$lang['errorcreatinguserrecord']}</h2>\n";
            $valid = false;
        }
    }
}

html_draw_top();

echo "<h1>{$lang['userregistration']}</h1>\n";

if (isset($error_html) && strlen($error_html) > 0) {
    echo $error_html;
}else {
    echo "<br />\n";
}

echo "<div align=\"center\">\n";
echo "<form name=\"register\" action=\"register.php\" method=\"POST\">\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";
echo "  <table class=\"box\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\" width=\"500\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"posthead\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"subhead\" colspan=\"2\">{$lang['registrationinformationrequired']}</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\" width=\"250\">&nbsp;{$lang['username']}:</td>\n";
echo "            <td>", form_input_text("LOGON", (isset($new_user['LOGON']) ? $new_user['LOGON'] : ""), 35, 32), "</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">&nbsp;{$lang['passwd']}:</td>\n";
echo "            <td>", form_input_password("PW", "", 35, 32), "</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">&nbsp;{$lang['confirmpassword']}:</td>\n";
echo "            <td>", form_input_password("CPW", "", 35, 32), "</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">&nbsp;{$lang['nickname']}:</td>\n";
echo "            <td>", form_input_text("NICKNAME", (isset($new_user['NICKNAME']) ? $new_user['NICKNAME'] : ""), 35, 32), "</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">&nbsp;{$lang['email']}:</td>\n";
echo "            <td>", form_input_text("EMAIL", (isset($new_user['EMAIL']) ? $new_user['EMAIL'] : ""), 35, 80), "</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">&nbsp;{$lang['dateofbirth']}:</td>\n";
echo "            <td>", form_dob_dropdowns((isset($new_user['DOB_YEAR']) ? $new_user['DOB_YEAR'] : 0), (isset($new_user['DOB_MONTH']) ? $new_user['DOB_MONTH'] : 0), (isset($new_user['DOB_DAY']) ? $new_user['DOB_DAY'] : 0), true), "</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td>&nbsp;</td>\n";
echo "            <td>", form_checkbox("remember_user", "Y", $lang['rememberpasswd'], (isset($_POST['remember_user']) && $_POST['remember_user'] == "Y")), "</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td colspan=\"2\">&nbsp;</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td class=\"subhead\" colspan=\"2\">{$lang['profileinformationoptional']}</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">&nbsp;{$lang['firstname']}:</td>\n";
echo "            <td>", form_field("FIRSTNAME", (isset($new_user['FIRSTNAME']) ? $new_user['FIRSTNAME'] : ""), 35, 32), "</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">&nbsp;{$lang['lastname']}:</td>\n";
echo "            <td>", form_field("LASTNAME", (isset($new_user['LASTNAME']) ? $new_user['LASTNAME'] : ""), 35, 32), "</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\" valign=\"top\">&nbsp;{$lang['signature']}:</td>\n";
echo "            <td>", form_textarea("SIG_CONTENT", (isset($new_user['SIG_CONTENT']) ? $new_user['SIG_CONTENT'] : ""), 6, 32), "</td>\n";
echo "          </tr>\n";
echo "         <tr>\n";
echo "           <td>&nbsp;</td>\n";
echo "           <td>", form_checkbox("SIG_HTML", "Y", $lang['containsHTML'], (isset($new_user['SIG_HTML']) && $new_user['SIG_HTML'] == "Y")), "</td>\n";
echo "         </tr>\n";
echo "          <tr>\n";
echo "            <td colspan=\"2\">&nbsp;</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td class=\"subhead\" colspan=\"2\">{$lang['preferencesoptional']}</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">&nbsp;{$lang['alwaysnotifymeofrepliestome']}:</td>\n";
echo "            <td>", form_radio("EMAIL_NOTIFY", "Y", $lang['yes'], (isset($new_user['EMAIL_NOTIFY']) && $new_user['EMAIL_NOTIFY'] == "Y")), "&nbsp;", form_radio("EMAIL_NOTIFY", "N", $lang['no'], ((isset($new_user['EMAIL_NOTIFY']) && $new_user['EMAIL_NOTIFY'] == "N") || (!isset($new_user['EMAIL_NOTIFY'])))), "</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">&nbsp;{$lang['notifyonnewprivatemessage']}:</td>\n";
echo "            <td>", form_radio("PM_NOTIFY_EMAIL", "Y", $lang['yes'], (isset($new_user['PM_NOTIFY_EMAIL']) && $new_user['PM_NOTIFY_EMAIL'] == "Y")), "&nbsp;", form_radio("PM_NOTIFY_EMAIL", "N", $lang['no'], ((isset($new_user['PM_NOTIFY_EMAIL']) && $new_user['PM_NOTIFY_EMAIL'] == "N") || (!isset($new_user['PM_NOTIFY_EMAIL'])))), "</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">&nbsp;{$lang['popuponnewprivatemessage']}:</td>\n";
echo "            <td>", form_radio("PM_NOTIFY", "Y", $lang['yes'], (isset($new_user['PM_NOTIFY']) && $new_user['PM_NOTIFY'] == "Y")), "&nbsp;", form_radio("PM_NOTIFY", "N", $lang['no'], ((isset($new_user['PM_NOTIFY']) && $new_user['PM_NOTIFY'] == "N") || (!isset($new_user['PM_NOTIFY'])))), "</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">&nbsp;{$lang['automatichighinterestonpost']}:</td>\n";
echo "            <td>", form_radio("MARK_AS_OF_INT", "Y", $lang['yes'], (isset($new_user['MARK_AS_OF_INT']) && $new_user['MARK_AS_OF_INT'] == "Y")), "&nbsp;", form_radio("MARK_AS_OF_INT", "N", $lang['no'], ((isset($new_user['MARK_AS_OF_INT']) && $new_user['MARK_AS_OF_INT'] == "N") || (!isset($new_user['MARK_AS_OF_INT'])))), "</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">&nbsp;{$lang['daylightsaving']}:</td>\n";
echo "            <td>", form_radio("DL_SAVING", "Y", $lang['yes'], (isset($new_user['DL_SAVING']) && $new_user['DL_SAVING'] == "Y")), "&nbsp;", form_radio("DL_SAVING", "N", $lang['no'], ((isset($new_user['DL_SAVING']) && $new_user['DL_SAVING'] == "N") || (!isset($new_user['DL_SAVING'])))), "</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">&nbsp;{$lang['timezonefromGMT']}</td>\n";
echo "            <td>", form_dropdown_array("TIMEZONE", $timezones_data, $timezones, (isset($new_user['TIMEZONE']) ? $new_user['TIMEZONE'] : 0)), "</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">&nbsp;{$lang['preferredlang']}:</td>\n";
echo "            <td>", form_dropdown_array("LANGUAGE", $available_langs, $available_langs_labels, (isset($new_user['LANGUAGE']) ? $new_user['LANGUAGE'] : "en")), "</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">&nbsp;{$lang['style']}</td>\n";
echo "            <td>";

if (isset($new_user['STYLE'])) {
    $selected_style = $new_user['STYLE'];
    if (!in_array($selected_style, $available_styles)) {
        $selected_style = forum_get_setting('default_style');
    }
}else {
    $selected_style = forum_get_setting('default_style');
}

foreach ($available_styles as $key => $style) {
    if (strtolower($style) == strtolower($selected_style)) {
        break;
    }
}

reset($available_styles);

if (isset($key)) {
    echo form_dropdown_array("STYLE", $available_styles, $style_names, $available_styles[$key]);
}else {
    echo form_dropdown_array("STYLE", $available_styles, $style_names, $available_styles[0]);
}

echo "            </td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">&nbsp;{$lang['forumemoticons']}</td>\n";
echo "            <td>";

if (isset($new_user['EMOTICONS'])) {
    $selected_emoticon = $new_user['EMOTICONS'];
    if (!in_array($selected_emoticon, $available_emots)) {
        $selected_emoticon = forum_get_setting('default_emoticons');
    }
}else {
    $selected_emoticon = forum_get_setting('default_emoticons');
}

foreach ($available_emots as $key => $emoticon) {
    if (strtolower($emoticon) == strtolower($selected_emoticon)) {
        break;
    }
}

reset($available_emots);

if (isset($key)) {
    echo form_dropdown_array("EMOTICONS", $available_emots, $emot_names, $available_emots[$key]);
}else {
    echo form_dropdown_array("EMOTICONS", $available_emots, $emot_names, $available_emots[0]);
}

echo "            </td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td colspan=\"2\">&nbsp;</td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <p class=\"threadtime\">More Profile and Preference options are available once you register.</p>\n";
echo "  <p>", form_submit("submit", $lang['register']), "</p>\n";
echo "</form>\n";
echo "</div>\n";

html_draw_bottom();

?>