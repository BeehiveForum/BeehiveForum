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

/* $Id: prefs.php,v 1.71 2003-09-01 18:04:35 decoyduck Exp $ */

// Enable the error handler
require_once("./include/errorhandler.inc.php");

// Compress the output
require_once("./include/gzipenc.inc.php");

//Check logged in status
require_once("./include/session.inc.php");
require_once("./include/header.inc.php");

if(!bh_session_check()){

    $uri = "./logon.php?final_uri=". urlencode(get_request_uri());
    header_redirect($uri);

}

require_once("./include/html.inc.php");

if (bh_session_get_value('UID') == 0) {
    html_guest_error();
    exit;
}

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
        $t_nickname = $HTTP_POST_VARS['nickname'];
    }else {
        $error_html.= "<h2>{$lang['nicknamerequired']}</h2>";
        $valid = false;
    }

    if (isset($HTTP_POST_VARS['email']) && trim($HTTP_POST_VARS['email']) != "") {
        $t_email = $HTTP_POST_VARS['email'];
    }else {
        $error_html.= "<h2>{$lang['emailaddressrequired']}</h2>";
        $valid = false;
    }

    if (isset($HTTP_POST_VARS['dob_year']) && isset($HTTP_POST_VARS['dob_month']) && isset($HTTP_POST_VARS['dob_day']) && checkdate($HTTP_POST_VARS['dob_month'], $HTTP_POST_VARS['dob_day'], $HTTP_POST_VARS['dob_year'])) {
        $t_dob_day   = trim($HTTP_POST_VARS['dob_day']);
        $t_dob_month = trim($HTTP_POST_VARS['dob_month']);
        $t_dob_year  = trim($HTTP_POST_VARS['dob_year']);
        $t_user_dob  = "$t_dob_year-$t_dob_month-$t_dob_day";
        $t_dob_blank_fields = ($t_dob_year == 0 || $t_dob_month == 0 || $t_dob_day == 0) ? true : false;
    }else {
        $error_html.= "<h2>{$lang['birthdayrequired']}</h2>";
        $valid = false;
    }

    // Optional fields

    if (isset($HTTP_POST_VARS['firstname']) && trim($HTTP_POST_VARS['firstname']) != "") {
        $t_firstname = $HTTP_POST_VARS['firstname'];
    }else {
        $t_firstname = "";
    }

    if (isset($HTTP_POST_VARS['lastname']) && trim($HTTP_POST_VARS['lastname']) != "") {
        $t_lastname = $HTTP_POST_VARS['lastname'];
    }else {
        $t_lastname = "";
    }

    if (isset($HTTP_POST_VARS['homepage_url']) && trim($HTTP_POST_VARS['homepage_url']) != "") {
        $t_homepage_url = $HTTP_POST_VARS['homepage_url'];
    }else {
        $t_homepage_url = "";
    }

    if (isset($HTTP_POST_VARS['pic_url']) && trim($HTTP_POST_VARS['pic_url']) != "") {
        $t_pic_url = $HTTP_POST_VARS['pic_url'];
    }else {
        $t_pic_url = "";
    }

    if (isset($HTTP_POST_VARS['email_notify']) && $HTTP_POST_VARS['email_notify'] == "Y") {
        $t_email_notify = $HTTP_POST_VARS['email_notify'];
    }else {
        $t_email_notify = "";
    }

    if (isset($HTTP_POST_VARS['pm_notify']) && $HTTP_POST_VARS['pm_notify'] == "Y") {
        $t_pm_notify = $HTTP_POST_VARS['pm_notify'];
    }else {
        $t_pm_notify = "";
    }

    if (isset($HTTP_POST_VARS['pm_notify_email']) && $HTTP_POST_VARS['pm_notify_email'] == "Y") {
        $t_pm_notify_email = $HTTP_POST_VARS['pm_notify_email'];
    }else {
        $t_pm_notify_email = "";
    }

    if (isset($HTTP_POST_VARS['dl_saving']) && $HTTP_POST_VARS['dl_saving'] == "Y") {
        $t_dl_saving = $HTTP_POST_VARS['dl_saving'];
    }else {
        $t_dl_saving = "";
    }

    if (isset($HTTP_POST_VARS['mark_as_of_int']) && $HTTP_POST_VARS['mark_as_of_int'] == "Y") {
        $t_mark_as_of_int = $HTTP_POST_VARS['mark_as_of_int'];
    }else {
        $t_mark_as_of_int = "";
    }

    if (isset($HTTP_POST_VARS['view_sigs']) && $HTTP_POST_VARS['view_sigs'] == "Y") {
        $t_view_sigs = $HTTP_POST_VARS['view_sigs'];
    }else {
        $t_view_sigs = "";
    }

    if (isset($HTTP_POST_VARS['timezone'])) {
        $t_timezone = $HTTP_POST_VARS['timezone'];
    }else {
        $t_timezone = 0;
    }

    if (isset($HTTP_POST_VARS['posts_per_page'])) {
        $t_posts_per_page = $HTTP_POST_VARS['posts_per_page'];
    }else {
        $t_posts_per_page = 10;
    }

    if (isset($HTTP_POST_VARS['font_size'])) {
        $t_font_size = $HTTP_POST_VARS['font_size'];
    }else {
        $t_font_size = 10;
    }

    if (isset($HTTP_POST_VARS['style'])) {
        $t_style = $HTTP_POST_VARS['style'];
    }else {
        $t_style = $default_style;
    }

    if (isset($HTTP_POST_VARS['language'])) {
        $t_language = $HTTP_POST_VARS['language'];
    }else {
        $t_language = "";
    }

    if (isset($HTTP_POST_VARS['start_page'])) {
        $t_start_page = $HTTP_POST_VARS['start_page'];
    }else {
        $t_start_page = 0;
    }

    if (isset($HTTP_POST_VARS['dob_display'])) {
        $t_dob_display = $HTTP_POST_VARS['dob_display'];
    }else {
        $t_dob_display = 0;
    }

    if (isset($HTTP_POST_VARS['sig_content']) && trim($HTTP_POST_VARS['sig_content']) != "") {
        $t_sig_content = $HTTP_POST_VARS['sig_content'];
    }else {
        $t_sig_content = "";
    }

    if (isset($HTTP_POST_VARS['sig_html']) && $HTTP_POST_VARS['sig_html'] == "Y") {
        $t_sig_html = "Y";
    }else {
        $t_sig_html = "N";
    }

    if (preg_match("/<.+(src|background|codebase|background-image)(=|s?:s?).+getattachment.php.+>/ ", $t_sig_content) && $t_sig_html != "N") {
        $error_html.= "<h2>You are not allowed to embed attachments in your signature.</h2>\n";
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
                          $t_start_page, $t_language, $t_pm_notify, $t_pm_notify_email, $t_dob_display);

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
                        setcookie("bh_remember_password[$key]", $passw, time() + YEAR_IN_SECONDS);
                        setcookie("bh_remember_passhash[$key]", $passh, time() + YEAR_IN_SECONDS);
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
            echo "<div align=\"center\"><p><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></p><p><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></p>";
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
    echo "top.frames['ftop'].location.replace('$top_html'); top.frames['fnav'].location.reload();\n";
    echo "-->\n";
    echo "</script>";
}

?>
<br />
<div class="postbody">
  <form name="prefs" action="<?php echo $HTTP_SERVER_VARS['PHP_SELF']; ?>" method="post" target="_self">
    <table class="posthead" width="400">
      <tr>
        <td class="subhead" colspan="2">User Details</td>
      </tr>
      <tr>
        <td><?php echo $lang['newpasswd']; ?></td>
        <td>: <?php echo form_field("pw", "", 37, 0, "password"); ?></td>
      </tr>
      <tr>
        <td><?php echo $lang['confirmpasswd']; ?></td>
        <td>: <?php echo form_field("cpw", "", 37, 0, "password"); ?></td>
      </tr>
      <tr>
        <td><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></td>
        <td align="center"><span style="font-size: 10px">(<?php echo $lang['leaveblanktoretaincurrentpasswd']; ?>)</span></td>
      </tr>
      <tr>
        <td><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></td>
        <td><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></td>
      </tr>
      <tr>
        <td><?php echo $lang['nickname']; ?></td>
        <td>: <?php echo form_field("nickname", (isset($t_nickname) ? $t_nickname : $user['NICKNAME']), 37, 32); ?></td>
      </tr>
      <tr>
        <td><?php echo $lang['emailaddress']; ?></td>
        <td>: <?php echo form_field("email", (isset($t_email) ? $t_email : $user['EMAIL']), 37, 80); ?></td>
      </tr>
      <tr>
        <td><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></td>
        <td><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></td>
      </tr>
      <tr>
        <td><?php echo $lang['firstname']; ?></td>
        <td>: <?php echo form_field("firstname", (isset($t_firstname) ? $t_firstname : $user_prefs['FIRSTNAME']), 37, 32); ?></td>
      </tr>
      <tr>
        <td><?php echo $lang['lastname']; ?></td>
        <td>: <?php echo form_field("lastname", (isset($t_lastname) ? $t_lastname : $user_prefs['LASTNAME']), 37, 32); ?></td>
      </tr>
      <tr>
        <td><?php echo $lang['dateofbirth']; ?></td>
        <td>:
          <?php

              if (isset($t_dob_year) && isset($t_dob_month) && isset($t_dob_year) && isset($t_dob_blank_fields)) {

                  echo form_dob_dropdowns($t_dob_year, $t_dob_month, $t_dob_day, $t_dob_blank_fields);

              }else {

                  echo form_dob_dropdowns($dob_year, $dob_month, $dob_day, $dob_blank_fields);
              }

          ?>
        </td>
      </tr>
      <tr>
        <td><?php echo $lang['homepageURL']; ?></td>
        <td>: <?php echo form_field("homepage_url", (isset($t_homepage_url) ? $t_homepage_url : $user_prefs['HOMEPAGE_URL']), 37, 255); ?></td>
      </tr>
      <tr>
        <td><?php echo $lang['pictureURL']; ?></td>
        <td>: <?php echo form_field("pic_url", (isset($t_pic_url) ? $t_pic_url : $user_prefs['PIC_URL']), 37, 255); ?></td>
      </tr>
      <tr>
        <td><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></td>
        <td><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></td>
      </tr>
    </table>
    <table class="posthead" width="400">
      <tr>
        <td class="subhead"><?php echo $lang['forumoptions']; ?></td>
      </tr>
      <tr>
        <td><?php echo form_checkbox("email_notify", "Y", $lang['notifybyemail'], (isset($t_email_notify) && $t_email_notify == "Y") ? true : ($user_prefs['EMAIL_NOTIFY'] == "Y")); ?></td>
      </tr>
      <tr>
        <td><?php echo form_checkbox("pm_notify", "Y", $lang['notifyofnewpm'], (isset($t_pm_notify) && $t_pm_notify == "Y") ? true : ($user_prefs['PM_NOTIFY'] == "Y")); ?></td>
      </tr>
      <tr>
        <td><?php echo form_checkbox("pm_notify_email", "Y", $lang['notifyofnewpmemail'], (isset($t_pm_notify_email) && $t_pm_notify_email == "Y") ? true : ($user_prefs['PM_NOTIFY_EMAIL'] == "Y")); ?></td>
      </tr>
      <tr>
        <td><?php echo form_checkbox("dl_saving", "Y", $lang['daylightsaving'], (isset($t_dl_saving) && $t_dl_saving == "Y") ? true : ($user_prefs['DL_SAVING'] == "Y")); ?></td>
      </tr>
      <tr>
        <td><?php echo form_checkbox("mark_as_of_int", "Y", $lang['autohighinterest'], (isset($t_mark_as_of_int) && $t_mark_as_of_int == "Y") ? true : ($user_prefs['MARK_AS_OF_INT'] == "Y")); ?></td>
      </tr>
      <tr>
        <td><?php echo form_checkbox("view_sigs", "Y", $lang['globallyignoresigs'], (isset($t_view_sigs) && $t_view_sigs == "Y") ? true : ($user_prefs['VIEW_SIGS'] == "Y")); ?></td>
      </tr>
      <tr>
        <td><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></td>
      </tr>
    </table>
    <table class="posthead" width="400">
      <tr>
        <td><?php echo $lang['timezonefromGMT']; ?></td>
        <td><?php echo form_dropdown_array("timezone", $timezones_data, $timezones, (isset($t_timezone) ? $t_timezone : $user_prefs['TIMEZONE'])); ?></td>
      </tr>
      <tr>
        <td><?php echo $lang['postsperpage']; ?></td>
        <td>
          <?php

              if (isset($t_posts_per_page)) {

                  echo form_dropdown_array("posts_per_page", array(5,10,20), array(5,10,20), $t_posts_per_page);

              }elseif (isset($user_prefs['POSTS_PER_PAGE'])) {

                  echo form_dropdown_array("posts_per_page", array(5,10,20), array(5,10,20), $user_prefs['POSTS_PER_PAGE']);

              }else {

                  echo form_dropdown_array("posts_per_page", array(5,10,20), array(5,10,20), 10);
              }

          ?>
        </td>
      </tr>
      <tr>
        <td><?php echo $lang['fontsize']; ?></td>
        <td>
          <?php

            if (isset($t_font_size)) {

                echo form_dropdown_array("font_size", range(1,15), array('1pt', '2pt', '3pt', '4pt', '5pt', '6pt', '7pt', '8pt', '9pt', '10pt', '11pt', '12pt', '13pt', '14pt', '15pt'), $t_font_size);

            }elseif (isset($user_prefs['FONT_SIZE'])) {

                if ($user_prefs['FONT_SIZE'] == '') {

                    echo form_dropdown_array("font_size", range(1,15), array('1pt', '2pt', '3pt', '4pt', '5pt', '6pt', '7pt', '8pt', '9pt', '10pt', '11pt', '12pt', '13pt', '14pt', '15pt'), "10pt");

                }else{

                    echo form_dropdown_array("font_size", range(1,15), array('1pt', '2pt', '3pt', '4pt', '5pt', '6pt', '7pt', '8pt', '9pt', '10pt', '11pt', '12pt', '13pt', '14pt', '15pt'), $user_prefs['FONT_SIZE']);
                }

            }else {

                echo form_dropdown_array("font_size", range(1,15), array('1pt', '2pt', '3pt', '4pt', '5pt', '6pt', '7pt', '8pt', '9pt', '10pt', '11pt', '12pt', '13pt', '14pt', '15pt'), "10pt");
            }

          ?>
        </td>
      </tr>
      <tr>
        <td><?php echo $lang['forumstyle']; ?></td>
        <td>
          <?php

            if (isset($t_style)) {
                $selected_style = $t_style;
                if (!in_array($selected_style, $available_styles)) {
                    $selected_style = $default_style;
                }
            }else {
                if (bh_session_get_value('STYLE')) {
                    $selected_style = bh_session_get_value('STYLE');
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
                echo form_dropdown_array("style", $available_styles, $style_names, $available_styles[$key]);
            }else {
                echo form_dropdown_array("style", $available_styles, $style_names, $available_styles[0]);
            }

          ?>
        </td>
      </tr>
      <tr>
        <td><?php echo $lang['preferredlang']; ?></td>
        <td><?php echo form_dropdown_array("language", $available_langs, $available_langs_labels, (isset($t_language) ? $t_language : bh_session_get_value("LANGUAGE"))); ?></td>
      </tr>
      <tr>
        <td><?php echo $lang['startpage']; ?></td>
        <td>
          <?php

              if (isset($t_start_page)) {

                  echo form_dropdown_array("start_page", range(0, 2), array($lang['start'], $lang['messages'], $lang['pminbox']), $t_start_page);

              }elseif (isset($user_prefs['DOB_DISPLAY'])) {

                  echo form_dropdown_array("start_page", range(0, 2), array($lang['start'], $lang['messages'], $lang['pminbox']), $user_prefs['START_PAGE']);

              }else {

                  echo form_dropdown_array("start_page", range(0, 2), array($lang['start'], $lang['messages'], $lang['pminbox']), 0);

              }

          ?>
        </td>
      </tr>
      <tr>
        <td><?php echo $lang['ageanddob']; ?></td>
        <td>
          <?php

              if (isset($t_dob_display)) {

                  echo form_dropdown_array("dob_display", range(0, 2), array($lang['neitheragenordob'], $lang['showonlyage'], $lang['showageanddob']), $t_dob_display);

              }elseif (isset($user_prefs['DOB_DISPLAY'])) {

                  echo form_dropdown_array("dob_display", range(0, 2), array($lang['neitheragenordob'], $lang['showonlyage'], $lang['showageanddob']), $user_prefs['DOB_DISPLAY']);

              }else {

                  echo form_dropdown_array("dob_display", range(0, 2), array($lang['neitheragenordob'], $lang['showonlyage'], $lang['showageanddob']), 0);

              }

          ?>
        </td>
      </tr>
      <tr>
        <td><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></td>
        <td><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></td>
      </tr>
    </table>
    <table class="posthead" width="400">
      <tr>
        <td class="subhead" colspan="2"><?php echo $lang['signature']; ?></td>
      </tr>
      <tr>
        <td colspan="2"><?php echo form_textarea("sig_content", (isset($t_sig_content) ? _htmlentities(_stripslashes($t_sig_content)) : _htmlentities(_stripslashes($user_sig['SIG_CONTENT']))), 4, 60); ?></td>
      </tr>
      <tr>
        <td><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></td>
        <td align="right"><?php echo form_checkbox("sig_html", "Y", $lang['containsHTML'], (isset($t_sig_html) && $t_sig_html == "Y") ? true : ($user_sig['SIG_HTML'] == "Y")); ?></td>
      </tr>
    </table>
    <?php echo form_submit("submit", $lang['save']); ?>
  </form>
</div>
<?php html_draw_bottom(); ?>