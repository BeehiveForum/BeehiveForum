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

/* $Id: forum_options.php,v 1.1 2004-01-24 16:42:55 decoyduck Exp $ */

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

// Get User Prefs

$user = user_get(bh_session_get_value('UID'));
$user_prefs = user_get_prefs(bh_session_get_value('UID'));

// Start output here

html_draw_top();

echo "<h1>{$lang['forumoptions']}</h1>\n";
echo "<br />\n";
echo "<div class=\"postbody\">\n";
echo "  <form name=\"prefs\" action=\"./prefs.php\" method=\"post\" target=\"_self\">\n";
echo "    <table cellpadding=\"0\" cellspacing=\"0\" width=\"400\">\n";
echo "      <tr>\n";
echo "        <td>\n";
echo "          <table class=\"box\">\n";
echo "            <tr>\n";
echo "              <td class=\"posthead\">\n";
echo "                <table class=\"posthead\" width=\"400\">\n";
echo "                  <tr>\n";
echo "                    <td colspan=\"2\" class=\"subhead\">Time Zone</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td>{$lang['timezonefromGMT']}:</td>\n";
echo "                    <td>", form_dropdown_array("timezone", $timezones_data, $timezones, (isset($t_timezone) ? $t_timezone : $user_prefs['TIMEZONE'])), "</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td>", form_checkbox("dl_saving", "Y", $lang['daylightsaving'], (isset($t_dl_saving) && $t_dl_saving == "Y") ? true : (isset($user_prefs['DL_SAVING']) && $user_prefs['DL_SAVING'] == "Y")), "</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td>&nbsp;</td>\n";
echo "                  </tr>\n";
echo "                </table>\n";
echo "              </td>\n";
echo "            </tr>\n";
echo "          </table>\n";
echo "        </td>\n";
echo "      </tr>\n";
echo "    </table>\n";
echo "    <br />\n";
echo "    <table cellpadding=\"0\" cellspacing=\"0\" width=\"400\">\n";
echo "      <tr>\n";
echo "        <td>\n";
echo "          <table class=\"box\">\n";
echo "            <tr>\n";
echo "              <td class=\"posthead\">\n";
echo "                <table class=\"posthead\" width=\"400\">\n";
echo "                  <tr>\n";
echo "                    <td colspan=\"2\" class=\"subhead\">Language</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td>{$lang['preferredlang']}</td>\n";
echo "                    <td>", form_dropdown_array("language", $available_langs, $available_langs_labels, (isset($t_language) ? $t_language : bh_session_get_value("LANGUAGE"))), "</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td>&nbsp;</td>\n";
echo "                  </tr>\n";
echo "                </table>\n";
echo "              </td>\n";
echo "            </tr>\n";
echo "          </table>\n";
echo "        </td>\n";
echo "      </tr>\n";
echo "    </table>\n";
echo "    <br />\n";
echo "    <table cellpadding=\"0\" cellspacing=\"0\" width=\"400\">\n";
echo "      <tr>\n";
echo "        <td>\n";
echo "          <table class=\"box\">\n";
echo "            <tr>\n";
echo "              <td class=\"posthead\">\n";
echo "                <table class=\"posthead\" width=\"400\">\n";
echo "                  <tr>\n";
echo "                    <td colspan=\"2\" class=\"subhead\">{$lang['display']}</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td>", form_checkbox("view_sigs", "Y", $lang['globallyignoresigs'], (isset($t_view_sigs) && $t_view_sigs == "Y") ? true : (isset($user_prefs['VIEW_SIGS']) && $user_prefs['VIEW_SIGS'] == "Y")), "</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td>", form_checkbox("pm_notify", "Y", $lang['notifyofnewpm'], (isset($t_pm_notify) && $t_pm_notify == "Y") ? true : (isset($user_prefs['PM_NOTIFY']) && $user_prefs['PM_NOTIFY'] == "Y")), "</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td>", form_checkbox("mark_as_of_int", "Y", $lang['autohighinterest'], (isset($t_mark_as_of_int) && $t_mark_as_of_int == "Y") ? true : (isset($user_prefs['MARK_AS_OF_INT']) && $user_prefs['MARK_AS_OF_INT'] == "Y")), "</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td>", form_checkbox("show_stats", "Y", $lang['showforumstats'], (isset($t_show_stats) && $t_show_stats == 1) ? true : (isset($user_prefs['SHOW_STATS']) && $user_prefs['SHOW_STATS'] == 1)), "</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td>&nbsp;</td>\n";
echo "                  </tr>\n";
echo "                </table>\n";
echo "              </td>\n";
echo "            </tr>\n";
echo "          </table>\n";
echo "        </td>\n";
echo "      </tr>\n";
echo "    </table>\n";
echo "    <br />\n";
echo "    <table cellpadding=\"0\" cellspacing=\"0\" width=\"400\">\n";
echo "      <tr>\n";
echo "        <td>\n";
echo "          <table class=\"box\">\n";
echo "            <tr>\n";
echo "              <td class=\"posthead\">\n";
echo "                <table class=\"posthead\" width=\"400\">\n";
echo "                  <tr>\n";
echo "                    <td colspan=\"2\" class=\"subhead\">{$lang['style']}</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td>{$lang['postsperpage']}</td>\n";

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
echo "                    <td>{$lang['startpage']}</td>\n";

if (isset($t_start_page)) {
    echo "                    <td>", form_dropdown_array("start_page", range(0, 2), array($lang['start'], $lang['messages'], $lang['pminbox']), $t_start_page), "</td>\n";
}elseif (isset($user_prefs['DOB_DISPLAY'])) {
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