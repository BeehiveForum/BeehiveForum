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

/* $Id: forum_options.php,v 1.51 2004-08-17 23:46:32 tribalonline Exp $ */

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

include_once("./include/emoticons.inc.php");
include_once("./include/form.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/post.inc.php");
include_once("./include/session.inc.php");
include_once("./include/styles.inc.php");
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


if (isset($_POST['submit'])) {

    $user_prefs = array();
    $user_prefs_global = array();

    if (isset($_POST['timezone'])) {
        $user_prefs['TIMEZONE'] = _stripslashes(trim($_POST['timezone']));
    }else {
        $user_prefs['TIMEZONE'] = 0;
    }

    if (isset($_POST['dl_saving']) && $_POST['dl_saving'] == "Y") {
        $user_prefs['DL_SAVING'] = "Y";
    }else {
        $user_prefs['DL_SAVING'] = "N";
    }

    if (isset($_POST['language'])) {
        $user_prefs['LANGUAGE'] = _stripslashes(trim($_POST['language']));
    }else {
        $user_prefs['LANGUAGE'] = "";
    }

    if (isset($_POST['language_global'])) {
        $user_prefs_global['LANGUAGE'] = ($_POST['language_global'] == "Y") ? true : false;
    } else {
        $user_prefs_global['LANGUAGE'] = false;
    }

    if (isset($_POST['view_sigs']) && $_POST['view_sigs'] == "N") {
        $user_prefs['VIEW_SIGS'] = "N";
    }else {
        $user_prefs['VIEW_SIGS'] = "Y";
    }

    if (isset($_POST['view_sigs_global'])) {
        $user_prefs_global['VIEW_SIGS'] = ($_POST['view_sigs_global'] == "Y") ? true : false;
    } else {
        $user_prefs_global['VIEW_SIGS'] = false;
    }


    if (isset($_POST['pm_notify']) && $_POST['pm_notify'] == "Y") {
        $user_prefs['PM_NOTIFY'] = "Y";
    }else {
        $user_prefs['PM_NOTIFY'] = "N";
    }

        if (isset($_POST['pm_notify_global'])) {
        $user_prefs_global['PM_NOTIFY'] = ($_POST['pm_notify_global'] == "Y") ? true : false;
    } else {
        $user_prefs_global['PM_NOTIFY'] = false;
    }


    if (isset($_POST['mark_as_of_int']) && $_POST['mark_as_of_int'] == "Y") {
        $user_prefs['MARK_AS_OF_INT'] = "Y";
    }else {
        $user_prefs['MARK_AS_OF_INT'] = "N";
    }

    if (isset($_POST['mark_as_of_int_global'])) {
        $user_prefs_global['MARK_AS_OF_INT'] = ($_POST['mark_as_of_int_global'] == "Y") ? true : false;
    } else {
        $user_prefs_global['MARK_AS_OF_INT'] = false;
    }

    if (isset($_POST['images_to_links']) && $_POST['images_to_links'] == "Y") {
        $user_prefs['IMAGES_TO_LINKS'] = "Y";
    }else {
        $user_prefs['IMAGES_TO_LINKS'] = "N";
    }

        if (isset($_POST['images_to_links_global'])) {
        $user_prefs_global['IMAGES_TO_LINKS'] = ($_POST['images_to_links_global'] == "Y") ? true : false;
    } else {
        $user_prefs_global['IMAGES_TO_LINKS'] = false;
    }


    if (isset($_POST['use_word_filter']) && $_POST['use_word_filter'] == "Y") {
        $user_prefs['USE_WORD_FILTER'] = "Y";
    }else {
        $user_prefs['USE_WORD_FILTER'] = "N";
    }

        if (isset($_POST['use_word_filter_global'])) {
        $user_prefs_global['USE_WORD_FILTER'] = ($_POST['use_word_filter_global'] == "Y") ? true : false;
    } else {
        $user_prefs_global['USE_WORD_FILTER'] = false;
    }

    if (isset($_POST['show_stats']) && $_POST['show_stats'] == "Y") {
        $user_prefs['SHOW_STATS'] = 1;
    }else {
        $user_prefs['SHOW_STATS'] = 0;
    }

    if (isset($_POST['show_stats_global'])) {
        $user_prefs_global['SHOW_STATS'] = ($_POST['show_stats_global'] == "Y") ? true : false;
    } else {
        $user_prefs_global['SHOW_STATS'] = false;
    }


    if (isset($_POST['posts_per_page'])) {
        $user_prefs['POSTS_PER_PAGE'] = _stripslashes(trim($_POST['posts_per_page']));
    }else {
        $user_prefs['POSTS_PER_PAGE'] = 20;
    }

    if (isset($_POST['posts_per_page_global'])) {
        $user_prefs_global['POSTS_PER_PAGE'] = ($_POST['posts_per_page_global'] == "Y") ? true : false;
    } else {
        $user_prefs_global['POSTS_PER_PAGE'] = false;
    }


    if (isset($_POST['font_size'])) {
        $user_prefs['FONT_SIZE'] = _stripslashes(trim($_POST['font_size']));
    }else {
        $user_prefs['FONT_SIZE'] = 10;
    }

    if (isset($_POST['font_size_global'])) {
        $user_prefs_global['FONT_SIZE'] = ($_POST['font_size_global'] == "Y") ? true : false;
    } else {
        $user_prefs_global['FONT_SIZE'] = false;
    }

    if (isset($_POST['style'])) {
        $user_prefs['STYLE'] = _stripslashes(trim($_POST['style']));
    }else {
        $user_prefs['STYLE'] = forum_get_setting('default_style');
    }

        if (isset($_POST['style_global'])) {
        $user_prefs_global['STYLE'] = ($_POST['style_global'] == "Y") ? true : false;
    } else {
        $user_prefs_global['STYLE'] = false;
    }

        if (isset($_POST['emoticons'])) {
        $user_prefs['EMOTICONS'] = _stripslashes(trim($_POST['emoticons']));
    }else {
        $user_prefs['EMOTICONS'] = forum_get_setting('default_emoticons');
    }

    if (isset($_POST['emoticons_global'])) {
        $user_prefs_global['EMOTICONS'] = ($_POST['emoticons_global'] == "Y") ? true : false;
    } else {
        $user_prefs_global['EMOTICONS'] = false;
    }

    if (isset($_POST['start_page'])) {
        $user_prefs['START_PAGE'] = _stripslashes(trim($_POST['start_page']));
    }else {
        $user_prefs['START_PAGE'] = 0;
    }

    if (isset($_POST['start_page_global'])) {
        $user_prefs_global['START_PAGE'] = ($_POST['start_page_global'] == "Y") ? true : false;
    } else {
        $user_prefs_global['START_PAGE'] = false;
    }

        $user_prefs['POST_PAGE'] = 0;
        // toolbar_toggle emots_toggle emots_disable  post_html
        if (isset($_POST['toolbar_toggle']) && $_POST['toolbar_toggle'] == "Y") {
                $user_prefs['POST_PAGE'] |= POST_TOOLBAR_DISPLAY;
        }
        if (isset($_POST['emots_toggle']) && $_POST['emots_toggle'] == "Y") {
                $user_prefs['POST_PAGE'] |= POST_EMOTICONS_DISPLAY;
        }
        if (isset($_POST['emots_disable']) && $_POST['emots_disable'] == "Y") {
                $user_prefs['POST_PAGE'] |= POST_EMOTICONS_DISABLED;
        }
        if (isset($_POST['post_links']) && $_POST['post_links'] == "Y") {
                $user_prefs['POST_PAGE'] |= POST_AUTO_LINKS;
        }
        if (isset($_POST['post_html'])) {
                if ($_POST['post_html'] == 0) {
                        $user_prefs['POST_PAGE'] |= POST_TEXT_DEFAULT;
                } else if ($_POST['post_html'] == 1) {
                        $user_prefs['POST_PAGE'] |= POST_AUTOHTML_DEFAULT;
                } else {
                        $user_prefs['POST_PAGE'] |= POST_HTML_DEFAULT;
                }
        }

    // User's UID for updating with.

    $uid = bh_session_get_value('UID');

        // Update USER_PREFS

        user_update_prefs($uid, $user_prefs, $user_prefs_global);

    // Reinitialize the User's Session to save them having to logout and back in

    bh_session_init($uid);

    // IIS bug prevents redirect at same time as setting cookies.

        header_redirect_cookie("./forum_options.php?webtag=$webtag&updated=true");

}

if (!isset($uid)) $uid = bh_session_get_value('UID');

// Get User Prefs
$user_prefs = user_get_prefs($uid);

// Start output here

html_draw_top("emoticons.js");

echo "<h1>{$lang['forumoptions']}</h1>\n";

if (!empty($error_html)) {
    echo $error_html;
}else if (isset($_GET['updated'])) {

    echo "<h2>{$lang['preferencesupdated']}</h2>\n";

    $top_html = html_get_top_page();

    echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
    echo "<!--\n";

    if (isset($user_prefs['FONT_SIZE']) && is_numeric($user_prefs['FONT_SIZE'])) {
        echo "top.document.body.rows='60,' + {$user_prefs['FONT_SIZE']} * 2 + ',*';\n";
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
echo "<form name=\"prefs\" action=\"forum_options.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"550\">\n";
echo "                <tr>\n";
echo "                  <td colspan=\"2\" class=\"subhead\">{$lang['timezone']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>{$lang['timezonefromGMT']}:</td>\n";

if (isset($user_prefs['TIMEZONE']) && is_numeric($user_prefs['TIMEZONE'])) {
    echo "                  <td>", form_dropdown_array("timezone", $timezones_data, $timezones, $user_prefs['TIMEZONE']), "</td>\n";
}else {
    echo "                  <td>", form_dropdown_array("timezone", $timezones_data, $timezones, 0), "</td>\n";
}

echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"2\">", form_checkbox("dl_saving", "Y", $lang['daylightsaving'], (isset($user_prefs['DL_SAVING']) ? $user_prefs['DL_SAVING'] : 0)), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"2\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <br />\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"550\">\n";
echo "                <tr>\n";
echo "                  <td colspan=\"3\" class=\"subhead\">{$lang['language']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>{$lang['preferredlang']}:</td>\n";
echo "                  <td>", form_dropdown_array("language", $available_langs, $available_langs_labels, (isset($user_prefs['LANGUAGE']) ? $user_prefs['LANGUAGE'] : 0)), "</td>\n";
echo "                  <td align=\"right\" nowrap=\"nowrap\">", form_checkbox("language_global","Y",$lang['setforallforums'],$user_prefs['LANGUAGE_GLOBAL']), "&nbsp;</td>\n";
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
echo "  </table>\n";
echo "  <br />\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"550\">\n";
echo "                <tr>\n";
echo "                  <td colspan=\"3\" class=\"subhead\">{$lang['display']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>", form_checkbox("view_sigs", "N", $lang['globallyignoresigs'], (isset($user_prefs['VIEW_SIGS']) && $user_prefs['VIEW_SIGS'] == "N") ? true : false), "</td>\n";
echo "                  <td align=\"right\" nowrap=\"nowrap\">", form_checkbox("view_sigs_global","Y",$lang['setforallforums'],$user_prefs['VIEW_SIGS_GLOBAL']), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>", form_checkbox("pm_notify", "Y", $lang['notifyofnewpm'], (isset($user_prefs['PM_NOTIFY']) && $user_prefs['PM_NOTIFY'] == "Y") ? true : false), "</td>\n";
echo "                  <td align=\"right\" nowrap=\"nowrap\">", form_checkbox("pm_notify_global","Y",$lang['setforallforums'],$user_prefs['PM_NOTIFY_GLOBAL']), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>", form_checkbox("mark_as_of_int", "Y", $lang['autohighinterest'], (isset($user_prefs['MARK_AS_OF_INT']) && $user_prefs['MARK_AS_OF_INT'] == "Y") ? true : false), "</td>\n";
echo "                  <td align=\"right\" nowrap=\"nowrap\">", form_checkbox("mark_as_of_int_global","Y",$lang['setforallforums'],$user_prefs['MARK_AS_OF_INT_GLOBAL']), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>", form_checkbox("images_to_links", "Y", $lang['convertimagestolinks'], (isset($user_prefs['IMAGES_TO_LINKS']) && $user_prefs['IMAGES_TO_LINKS'] == "Y") ? true : false), "</td>\n";
echo "                  <td align=\"right\" nowrap=\"nowrap\">", form_checkbox("images_to_links_global","Y",$lang['setforallforums'],$user_prefs['IMAGES_TO_LINKS_GLOBAL']), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>", form_checkbox("show_stats", "Y", $lang['showforumstats'], (isset($user_prefs['SHOW_STATS']) && $user_prefs['SHOW_STATS'] == 1) ? true : false), "</td>\n";
echo "                  <td align=\"right\" nowrap=\"nowrap\">", form_checkbox("show_stats_global","Y",$lang['setforallforums'],$user_prefs['SHOW_STATS_GLOBAL']), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>", form_checkbox("use_word_filter", "Y", $lang['usewordfilter'], (isset($user_prefs['USE_WORD_FILTER']) && $user_prefs['USE_WORD_FILTER'] == "Y")), "&nbsp;<span class=\"smalltext\">[<a href=\"edit_wordfilter.php?webtag=$webtag\">{$lang['editwordfilter']}</a>]</span></td>\n";
echo "                  <td align=\"right\" nowrap=\"nowrap\">", form_checkbox("use_word_filter_global","Y",$lang['setforallforums'],$user_prefs['USE_WORD_FILTER_GLOBAL']), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"2\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <br />\n";

if ($user_prefs['POST_PAGE'] == 0) {
        $user_prefs['POST_PAGE'] = POST_TOOLBAR_DISPLAY | POST_EMOTICONS_DISPLAY | POST_TEXT_DEFAULT | POST_AUTO_LINKS;
}

echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"550\">\n";
echo "                <tr>\n";
echo "                  <td colspan=\"2\" class=\"subhead\">{$lang['postpage']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
$toolbar_toggle = $user_prefs['POST_PAGE'] & POST_TOOLBAR_DISPLAY;
echo "                  <td>", form_checkbox("toolbar_toggle", "Y", $lang['displayhtmltoolbar'], $toolbar_toggle), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
$emots_toggle = $user_prefs['POST_PAGE'] & POST_EMOTICONS_DISPLAY;
echo "                  <td>", form_checkbox("emots_toggle", "Y", $lang['displayemoticonspanel'], $emots_toggle), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
$emots_disabled = $user_prefs['POST_PAGE'] & POST_EMOTICONS_DISABLED;
echo "                  <td>", form_checkbox("emots_disable", "Y", $lang['disableemoticonsinpostsbydefault'], $emots_disabled), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
$post_links = $user_prefs['POST_PAGE'] & POST_AUTO_LINKS;
echo "                  <td>", form_checkbox("post_links", "Y", $lang['automaticallyparseurlsbydefault'], $post_links), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
if (($user_prefs['POST_PAGE'] & POST_AUTOHTML_DEFAULT) > 0) {
        $post_html = 1;
} else if (($user_prefs['POST_PAGE'] & POST_HTML_DEFAULT) > 0) {
        $post_html = 2;
} else {
        $post_html = 0;
}
echo "                  <td>", form_radio("post_html", "0", $lang['postinplaintextbydefault'], $post_html == 0), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>", form_radio("post_html", "1", $lang['postinhtmlwithautolinebreaksbydefault'], $post_html == 1), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>", form_radio("post_html", "2", $lang['postinhtmlbydefault'], $post_html == 2), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"2\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <br />\n";

echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"550\">\n";
echo "                <tr>\n";
echo "                  <td colspan=\"3\" class=\"subhead\">{$lang['style']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"250\">{$lang['postsperpage']}:</td>\n";

if (isset($user_prefs['POSTS_PER_PAGE']) && is_numeric($user_prefs['POSTS_PER_PAGE'])) {
    echo "                  <td>", form_dropdown_array("posts_per_page", array(10, 20, 30), array(10, 20, 30), $user_prefs['POSTS_PER_PAGE']), "</td>\n";
}else {
    echo "                  <td>", form_dropdown_array("posts_per_page", array(10, 20, 30), array(10, 20, 30), 10), "</td>\n";
}
echo "                  <td align=\"right\" nowrap=\"nowrap\">", form_checkbox("posts_per_page_global","Y",$lang['setforallforums'],$user_prefs['POSTS_PER_PAGE_GLOBAL']), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"250\">{$lang['fontsize']}:</td>\n";

if (isset($user_prefs['FONT_SIZE']) && is_numeric($user_prefs['FONT_SIZE'])) {
    echo "                  <td>", form_dropdown_array("font_size", range(5, 15), array('5pt', '6pt', '7pt', '8pt', '9pt', '10pt', '11pt', '12pt', '13pt', '14pt', '15pt'), $user_prefs['FONT_SIZE']), "</td>\n";
}else {
    echo "                  <td>", form_dropdown_array("font_size", range(5, 15), array('5pt', '6pt', '7pt', '8pt', '9pt', '10pt', '11pt', '12pt', '13pt', '14pt', '15pt'), 10), "</td>\n";
}
echo "                  <td align=\"right\" nowrap=\"nowrap\">", form_checkbox("font_size_global","Y",$lang['setforallforums'],$user_prefs['FONT_SIZE_GLOBAL']), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"250\">{$lang['forumstyle']}:</td>\n";

$styles = style_get_styles();
$styles_keys = array_keys($styles);

if (_in_array($user_prefs['STYLE'], $styles_keys)) {
    $selected_style = $user_prefs['STYLE'];
}else {
    $selected_style = forum_get_setting('default_style');
}

echo "                  <td>", form_dropdown_array("style", $styles_keys, array_values($styles), $selected_style), "</td>\n";
echo "                  <td align=\"right\" nowrap=\"nowrap\">", form_checkbox("style_global","Y",$lang['setforallforums'],$user_prefs['STYLE_GLOBAL']), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"250\">{$lang['forumemoticons']} ";
echo "[<a href=\"javascript:void(0);\" onclick=\"openEmoticons('','$webtag')\" target=\"_self\">{$lang['preview']}</a>]:</td>\n";

$emot_sets = emoticons_get_sets();
$emot_sets_keys = array_keys($emot_sets);

if (_in_array($user_prefs['EMOTICONS'], $emot_sets_keys)) {
    $emot_selected = $user_prefs['EMOTICONS'];
}else {
    $emot_selected = forum_get_setting('default_emoticons');
}

echo "                  <td>", form_dropdown_array("emoticons", $emot_sets_keys, array_values($emot_sets), $emot_selected), "</td>\n";
echo "                  <td align=\"right\" nowrap=\"nowrap\">", form_checkbox("emoticons_global","Y",$lang['setforallforums'],$user_prefs['EMOTICONS_GLOBAL']), "&nbsp;</td>\n";

echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"250\">{$lang['startpage']}:</td>\n";

if (isset($user_prefs['START_PAGE'])) {
    echo "                  <td>", form_dropdown_array("start_page", range(0, 3), array($lang['start'], $lang['messages'], $lang['pminbox'], $lang['startwiththreadlist']), $user_prefs['START_PAGE']), "</td>\n";
}else {
    echo "                  <td>", form_dropdown_array("start_page", range(0, 3), array($lang['start'], $lang['messages'], $lang['pminbox'], $lang['startwiththreadlist']), 0), "</td>\n";
}
echo "                  <td align=\"right\" nowrap=\"nowrap\">", form_checkbox("start_page_global","Y",$lang['setforallforums'],$user_prefs['START_PAGE_GLOBAL']), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"2\">&nbsp;</td>\n";
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
