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

/* $Id: forum_options.php,v 1.3 2004-02-03 13:01:28 decoyduck Exp $ */

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

if (bh_session_get_value('UID') == 0) {
    html_guest_error();
    exit;
}

require_once("./include/html.inc.php");
require_once("./include/user.inc.php");
require_once("./include/post.inc.php");
require_once("./include/fixhtml.inc.php");
require_once("./include/form.inc.php");
require_once("./include/header.inc.php");
require_once("./include/lang.inc.php");

// Timezones

$timezones = array("UTC -12h", "UTC -11h", "UTC -10h", "UTC -9h30m", "UTC -9h", "UTC -8h30m", "UTC -8h",
                   "UTC -7h", "UTC -6h", "UTC -5h", "UTC -4h", "UTC -3h30m", "UTC -3h", "UTC -2h", "UTC -1h",
                   "UTC", "UTC +1h", "UTC +2h", "UTC +3h",  "UTC +3h30m","UTC +4h", "UTC +4h30m", "UTC +5h",
                   "UTC +5h30m", "UTC +6h", "UTC +6h30m", "UTC +7h", "UTC +8h", "UTC +9h", "UTC +9h30m",
                   "UTC +10h", "UTC +10h30m", "UTC +11h", "UTC +11h30m", "UTC +12h", "UTC +13h", "UTC +14h");

$timezones_data = array(-12,-11,-10,-9.5,-9,-8.5,-8,-7,-6,-5,-4,-3.5,-3,-2,-1,0,1,2,3,3.5,4,4.5,5,5.5,
                        6,6.5,7,8,9,9.5,10,10.5,11,11.5,12,13,14);
                        
// Languages

$available_langs = lang_get_available(); // get list of available languages
$available_langs_labels = array_merge(array($lang['browsernegotiation']), $available_langs);
array_unshift($available_langs, "");

// Styles

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

if (isset($HTTP_POST_VARS['submit'])) {

    // Optional fields

    if (isset($HTTP_POST_VARS['timezone'])) {
        $user_prefs['TIMEZONE'] = _stripslashes(trim($HTTP_POST_VARS['timezone']));
    }else {
        $user_prefs['TIMEZONE'] = 0;
    }    

    if (isset($HTTP_POST_VARS['dl_saving']) && $HTTP_POST_VARS['dl_saving'] == "Y") {
        $user_prefs['DL_SAVING'] = "Y";
    }else {
        $user_prefs['DL_SAVING'] = "";
    }
    
    if (isset($HTTP_POST_VARS['language'])) {
        $user_prefs['LANGUAGE'] = _stripslashes(trim($HTTP_POST_VARS['language']));
    }else {
        $user_prefs['LANGUAGE'] = "";
    }    

    if (isset($HTTP_POST_VARS['view_sigs']) && $HTTP_POST_VARS['view_sigs'] == "Y") {
        $user_prefs['VIEW_SIGS'] = "Y";
    }else {
        $user_prefs['VIEW_SIGS'] = "";
    }
    
    if (isset($HTTP_POST_VARS['pm_notify']) && $HTTP_POST_VARS['pm_notify'] == "Y") {
        $user_prefs['PM_NOTIFY'] = "Y";
    }else {
        $user_prefs['PM_NOTIFY'] = "";
    }

    if (isset($HTTP_POST_VARS['mark_as_of_int']) && $HTTP_POST_VARS['mark_as_of_int'] == "Y") {
        $user_prefs['MARK_AS_OF_INT'] = "Y";
    }else {
        $user_prefs['MARK_AS_OF_INT'] = "";
    }

    if (isset($HTTP_POST_VARS['show_stats']) && $HTTP_POST_VARS['show_stats'] == "Y") {
        $user_prefs['SHOW_STATS'] = 1;
    }else {
        $user_prefs['SHOW_STATS'] = 0;
    }

    if (isset($HTTP_POST_VARS['posts_per_page'])) {
        $user_prefs['POSTS_PER_PAGE'] = _stripslashes(trim($HTTP_POST_VARS['posts_per_page']));
    }else {
        $user_prefs['POSTS_PER_PAGE'] = 10;
    }

    if (isset($HTTP_POST_VARS['font_size'])) {
        $user_prefs['FONT_SIZE'] = _stripslashes(trim($HTTP_POST_VARS['font_size']));
    }else {
        $user_prefs['FONT_SIZE'] = 10;
    }

    if (isset($HTTP_POST_VARS['style'])) {
        $user_prefs['STYLE'] = _stripslashes(trim($HTTP_POST_VARS['style']));
    }else {
        $user_prefs['STYLE'] = $default_style;
    }

    if (isset($HTTP_POST_VARS['start_page'])) {
        $user_prefs['START_PAGE'] = _stripslashes(trim($HTTP_POST_VARS['start_page']));
    }else {
        $user_prefs['START_PAGE'] = 0;
    }

    // User's UID for updating with.

    $uid = bh_session_get_value('UID');

    // Update USER_PREFS

    user_update_prefs($uid, $user_prefs);

    // Reinitialize the User's Session to save them having to logout and back in

    bh_session_init($uid);

    // IIS bug prevents redirect at same time as setting cookies.

    if (isset($HTTP_SERVER_VARS['SERVER_SOFTWARE']) && !strstr($HTTP_SERVER_VARS['SERVER_SOFTWARE'], 'Microsoft-IIS')) {

        header_redirect("./forum_options.php?updated=true");

    }else {

        html_draw_top();

        // Try a Javascript redirect
        echo "<script language=\"javascript\" type=\"text/javascript\">\n";
        echo "<!--\n";
        echo "document.location.href = './forum_options.php?updated=true';\n";
        echo "//-->\n";
        echo "</script>";

        // If they're still here, Javascript's not working. Give up, give a link.
        echo "<div align=\"center\"><p>&nbsp;</p><p>&nbsp;</p>";
        echo "<p>{$lang['preferencesupdated']}</p>";

        form_quick_button("./forum_options.php", $lang['continue'], "", "", "_top");

        html_draw_bottom();
        exit;
    }
}

// Get User Prefs

if (!isset($user_prefs) || !is_array($user_prefs)) $user_prefs = array();
$user_prefs = array_merge(user_get(bh_session_get_value('UID')), $user_prefs);
$user_prefs = array_merge(user_get_prefs(bh_session_get_value('UID')), $user_prefs);

// Start output here

html_draw_top();

echo "<h1>{$lang['forumoptions']}</h1>\n";

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

    echo "top.frames['ftop'].location.replace('$top_html');\n";
    echo "top.frames['fnav'].location.reload();\n";
    echo "top.frames['main'].frames['left'].location.reload();\n";
    echo "-->\n";
    echo "</script>";
}

echo "<br />\n";
echo "<div class=\"postbody\">\n";
echo "  <form name=\"prefs\" action=\"forum_options.php\" method=\"post\" target=\"_self\">\n";
echo "    <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
echo "      <tr>\n";
echo "        <td>\n";
echo "          <table class=\"box\">\n";
echo "            <tr>\n";
echo "              <td class=\"posthead\">\n";
echo "                <table class=\"posthead\" width=\"500\">\n";
echo "                  <tr>\n";
echo "                    <td colspan=\"2\" class=\"subhead\">{$lang['timezone']}</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td width=\"250\">{$lang['timezonefromGMT']}:</td>\n";
echo "                    <td>", form_dropdown_array("timezone", $timezones_data, $timezones, (isset($user_prefs['TIMEZONE']) ? $user_prefs['TIMEZONE'] : 0)), "</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td colspan=\"2\">", form_checkbox("dl_saving", "Y", $lang['daylightsaving'], (isset($user_prefs['DL_SAVING']) ? $user_prefs['DL_SAVING'] : 0)), "</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td colspan=\"2\">&nbsp;</td>\n";
echo "                  </tr>\n";
echo "                </table>\n";
echo "              </td>\n";
echo "            </tr>\n";
echo "          </table>\n";
echo "        </td>\n";
echo "      </tr>\n";
echo "    </table>\n";
echo "    <br />\n";
echo "    <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
echo "      <tr>\n";
echo "        <td>\n";
echo "          <table class=\"box\">\n";
echo "            <tr>\n";
echo "              <td class=\"posthead\">\n";
echo "                <table class=\"posthead\" width=\"500\">\n";
echo "                  <tr>\n";
echo "                    <td colspan=\"2\" class=\"subhead\">{$lang['language']}</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td width=\"250\">{$lang['preferredlang']}:</td>\n";
echo "                    <td>", form_dropdown_array("language", $available_langs, $available_langs_labels, (isset($user_prefs['LANGUAGE']) ? $user_prefs['LANGUAGE'] : 0)), "</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td colspan=\"2\">&nbsp;</td>\n";
echo "                  </tr>\n";
echo "                </table>\n";
echo "              </td>\n";
echo "            </tr>\n";
echo "          </table>\n";
echo "        </td>\n";
echo "      </tr>\n";
echo "    </table>\n";
echo "    <br />\n";
echo "    <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
echo "      <tr>\n";
echo "        <td>\n";
echo "          <table class=\"box\">\n";
echo "            <tr>\n";
echo "              <td class=\"posthead\">\n";
echo "                <table class=\"posthead\" width=\"500\">\n";
echo "                  <tr>\n";
echo "                    <td colspan=\"2\" class=\"subhead\">{$lang['display']}</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td>", form_checkbox("view_sigs", "Y", $lang['globallyignoresigs'], (isset($user_prefs['VIEW_SIGS']) && $user_prefs['VIEW_SIGS'] == "Y") ? true : false), "</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td>", form_checkbox("pm_notify", "Y", $lang['notifyofnewpm'], (isset($user_prefs['PM_NOTIFY']) && $user_prefs['PM_NOTIFY'] == "Y") ? true : false), "</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td>", form_checkbox("mark_as_of_int", "Y", $lang['autohighinterest'], (isset($user_prefs['MARK_AS_OF_INT']) && $user_prefs['MARK_AS_OF_INT'] == "Y") ? true : false), "</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td>", form_checkbox("show_stats", "Y", $lang['showforumstats'], (isset($user_prefs['SHOW_STATS']) && $user_prefs['SHOW_STATS'] == 1) ? true : false), "</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td colspan=\"2\">&nbsp;</td>\n";
echo "                  </tr>\n";
echo "                </table>\n";
echo "              </td>\n";
echo "            </tr>\n";
echo "          </table>\n";
echo "        </td>\n";
echo "      </tr>\n";
echo "    </table>\n";
echo "    <br />\n";
echo "    <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
echo "      <tr>\n";
echo "        <td>\n";
echo "          <table class=\"box\">\n";
echo "            <tr>\n";
echo "              <td class=\"posthead\">\n";
echo "                <table class=\"posthead\" width=\"500\">\n";
echo "                  <tr>\n";
echo "                    <td colspan=\"2\" class=\"subhead\">{$lang['style']}</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td width=\"250\">{$lang['postsperpage']}:</td>\n";

if (isset($user_prefs['POSTS_PER_PAGE'])) {
    echo "                    <td>", form_dropdown_array("posts_per_page", array(5,10,20), array(5,10,20), $user_prefs['POSTS_PER_PAGE']), "</td>\n";
}else {
    echo "                    <td>", form_dropdown_array("posts_per_page", array(5,10,20), array(5,10,20), 10), "</td>\n";
}

echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td width=\"250\">{$lang['fontsize']}:</td>\n";

if (isset($user_prefs['FONT_SIZE'])) {
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
echo "                    <td width=\"250\">{$lang['forumstyle']}:</td>\n";

if (_in_array($user_prefs['STYLE'], $available_styles)) {
    $selected_style = $user_prefs['STYLE'];
}else {
    $selected_style = $default_style;
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
echo "                    <td width=\"250\">{$lang['startpage']}:</td>\n";

if (isset($user_prefs['START_PAGE'])) {
    echo "                    <td>", form_dropdown_array("start_page", range(0, 2), array($lang['start'], $lang['messages'], $lang['pminbox']), $user_prefs['START_PAGE']), "</td>\n";
}else {
    echo "                    <td>", form_dropdown_array("start_page", range(0, 2), array($lang['start'], $lang['messages'], $lang['pminbox']), 0), "</td>\n";
}

echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td colspan=\"2\">&nbsp;</td>\n";
echo "                  </tr>\n";
echo "                </table>\n";
echo "              </td>\n";
echo "            </tr>\n";
echo "          </table>\n";
echo "        </td>\n";
echo "      </tr>\n";
echo "      <tr>\n";
echo "        <td align=\"center\"><p>", form_submit("submit", $lang['save']), "</p></td>\n";
echo "      </tr>\n";
echo "    </table>\n";
echo "  </form>\n";
echo "</div>\n";

html_draw_bottom();

?>