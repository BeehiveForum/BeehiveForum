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

/* $Id: admin_make_style.php,v 1.141 2010/01/29 20:54:26 decoyduck Exp $ */

// Set the default timezone
date_default_timezone_set('UTC');

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Disable PHP's register_globals
unregister_globals();

// Disable caching if on AOL
cache_disable_aol();

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

include_once(BH_INCLUDE_PATH. "admin.inc.php");
include_once(BH_INCLUDE_PATH. "compat.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "make_style.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");

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

// Check we have a webtag

if (!forum_check_webtag_available($webtag)) {
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

if (!(bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0))) {

    html_draw_top("title={$lang['error']}");
    html_error_msg($lang['accessdeniedexp']);
    html_draw_bottom();
    exit;
}

// Array to hold error messages

$error_msg_array = array();

// Save the style

if (isset($_POST['save'])) {

    $valid = true;

    if (isset($_POST['stylename']) && strlen(trim(stripslashes_array($_POST['stylename']))) > 0) {

        $stylename = trim(stripslashes_array($_POST['stylename']));

        if (preg_match("/^[A_Z0-9_-]+$/Diu", $stylename) < 1) {

            $error_msg_array[] = $lang['stylefilenamemayonlycontain'];
            $valid = false;
        }

    }else {

        $valid = false;
        $error_msg_array[] = $lang['stylenofilename'];
    }

    if (isset($_POST['styledesc']) && strlen(trim(stripslashes_array($_POST['styledesc']))) > 0) {

        $styledesc = trim(stripslashes_array($_POST['styledesc']));

    }else if (isset($stylename) && $valid) {

        $styledesc = $stylename;

    }else {

        $valid = false;
    }

    if (isset($_POST['stylesheet']) && strlen(trim(stripslashes_array($_POST['stylesheet']))) > 0) {

        $stylesheet = trim(stripslashes_array($_POST['stylesheet']));

    }elseif (isset($_POST['elements']) && is_array($_POST['elements'])) {

        if (@file_exists("styles/make_style.css")) {

            $stylesheet = implode('', file("styles/make_style.css"));

            foreach ($_POST['elements'] as $key => $value) {

                $stylesheet = str_replace("\$elements[$key]", mb_strtoupper($value), $stylesheet);
                $stylesheet = str_replace("\$text_colour[$key]", mb_strtoupper(contrastFont($value)), $stylesheet);
            }

        }else {

            $valid = false;
            $error_msg_array[] = $lang['failedtoopenmasterstylesheet'];
        }

    }else {

        $valid = false;
        $error_msg_array[] = $lang['stylenodatasubmitted'];
    }

    if ($valid) {

        $error_code = STYLE_NO_ERROR;

        if (!forum_save_style($stylename, $styledesc, $stylesheet, $error_code)) {

            if ($error_code == STYLE_ALREADY_EXISTS) {

                $valid = false;
                $error_msg_array[] = $lang['stylealreadyexists'];

            }else {

                html_draw_top("title={$lang['admin']} » {$lang['createforumstyle']}");

                $forum_path = dirname($_SERVER['PHP_SELF']);
                $forum_path.= "/forums/$webtag/styles/$stylename";

                echo "<h1>{$lang['admin']} &raquo; {$lang['createforumstyle']}</h1>\n";
                echo "<br />\n";
                echo "<div align=\"center\">\n";
                echo "<form accept-charset=\"utf-8\" method=\"post\" action=\"admin_make_style.php\">\n";
                echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
                echo "  ", form_input_hidden('stylesheet', htmlentities_array($stylesheet)), "\n";
                echo "  ", form_input_hidden('stylename', htmlentities_array($stylename)), "\n";
                echo "  ", form_input_hidden('styledesc', htmlentities_array($styledesc)), "\n";
                echo "  ", form_input_hidden('savefailed', "yes"), "\n";
                echo "  ", form_input_hidden_array(array('elements' => stripslashes_array($_POST['elements']))), "\n";
                echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
                echo "    <tr>\n";
                echo "      <td align=\"left\">\n";
                echo "        <table class=\"box\" width=\"100%\">\n";
                echo "          <tr>\n";
                echo "            <td align=\"left\" class=\"posthead\">\n";
                echo "              <table class=\"posthead\" width=\"100%\">\n";
                echo "                <tr>\n";
                echo "                  <td align=\"left\" class=\"subhead\">{$lang['createforumstyle']}</td>\n";
                echo "                </tr>\n";
                echo "                <tr>\n";
                echo "                  <td align=\"left\">", sprintf($lang['makestyleerror'], $forum_path), "</td>\n";
                echo "                </tr>\n";
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
                echo "    <tr>\n";
                echo "      <td align=\"center\">", form_submit('download', $lang['download']), "&nbsp;", form_submit('cancel_upload', $lang['cancel']), "</td>\n";
                echo "    </tr>\n";
                echo "  </table>\n";

                html_draw_bottom();
                exit;
            }

        }else {

            header_redirect("admin_make_style.php?webtag=$webtag&saved=true");
            exit;
        }
    }

}elseif (isset($_POST['download'])) {

    if (isset($_POST['stylesheet']) && strlen(trim(stripslashes_array($_POST['stylesheet']))) > 0) {
        $stylesheet = trim(stripslashes_array($_POST['stylesheet']));
    }else {
        $stylesheet = "";
    }

    $length = mb_strlen($stylesheet);

    header("Content-Type: application/x-ms-download", true);
    header("Content-Length: $length", true);
    header("Content-disposition: attachment; filename=\"style.css\"", true);
    echo $stylesheet;
    exit;
}

// Start Here

html_draw_top("title={$lang['admin']} » {$lang['createforumstyle']}");

echo "<h1>{$lang['admin']} &raquo; {$lang['createforumstyle']}</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '85%', 'center');

}else if (isset($_GET['saved'])) {

    html_display_success_msg($lang['newstylesuccessfullycreated'], '85%', 'center');

}else {

    html_display_warning_msg($lang['stylecolourexp'], '85%', 'center');
}

// Generate some random colours

$red = mt_rand(0, 255);
$green = mt_rand(0, 255);
$blue = mt_rand(0, 255);

// Check to see if user specified a seed to use.

if (isset($_POST['go'])) {

    if (isset($_POST['seed']) && (preg_match('/[0-9A-F]{3,6}/u', trim(stripslashes_array($_POST['seed']))) > 0)) {

        $seed = trim(stripslashes_array($_POST['seed']));
        list ($red, $green, $blue) = hexToDec($seed);
    }
}

if (isset($_GET['mode']) && $_GET['mode'] == 'rand') {
    $mode = STYLE_MODE_RANDOM;
}else {
    $mode = STYLE_MODE_NONE;
}

//Maximum variance for the colours

$max_var = 15;

// An array of all the Beehive CSS elements.

$elements = array ('navpage' => '', 'threads' => '', 'button' => '', 'subhead' => '', 'h1' => '', 'body' => '', 'box' => '');

if ($mode == STYLE_MODE_RANDOM) {
    uasort($elements, 'rand_sort');
}

$colour = decToHex($red, $green, $blue);
$seed = $colour;

list ($r, $g, $b) = hexToDec($colour);

$steps = sizeof($elements);

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form accept-charset=\"utf-8\" action=\"admin_make_style.php\" method=\"post\">\n";
echo "  ", form_input_hidden("webtag", htmlentities_array($webtag)), "\n";
echo "  <table width=\"85%\" class=\"box\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\" class=\"posthead\">\n";
echo "        <table width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td colspan=\"2\" class=\"subhead\" align=\"left\">{$lang['stylecontrols']}</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td align=\"left\" colspan=\"2\" class=\"posthead\">\n";
echo "              <table width=\"100%\">\n";
echo "                <tr>\n";

if (isset($_POST['save'])) {

    $elements = (isset($_POST['elements']) && is_array($_POST['elements'])) ? $_POST['elements'] : $elements;

    foreach ($elements as $key => $value) {

        echo "                  <td width=\"50\" class=\"posthead\" style=\"background-color: #", $value, "\" align=\"center\">\n";
        echo "                    <a href=\"admin_make_style.php?webtag=$webtag&amp;seed=", $value, "&amp;mode=", $mode, "\" style=\"color: #", contrastFont($value), "\">", mb_strtoupper($value), "</a>\n";
        echo "                  </td>\n";
    }

}else {

    foreach ($elements as $key => $value) {

        echo "                  <td width=\"50\" class=\"posthead\" style=\"background-color: #", $colour, "; color: #", contrastFont($colour), "\" align=\"center\">\n";
        echo "                    <a href=\"admin_make_style.php?webtag=$webtag&amp;seed=", $colour, "&amp;mode=", $mode, "\" style=\"color: #", contrastFont($colour), "\">", mb_strtoupper($colour), "</a>\n";
        echo "                  </td>\n";

        $elements[$key] = $colour;
        list ($r, $g, $b) = hexToDec($colour);
        $colour = changeColour ($r, $g, $b, $max_var, $mode, $steps);
        $steps--;
    }

    reset($elements);
}

list ($boxr, $boxg, $boxb) = hexToDec($elements['box']);

if (($boxr < 150 && $boxg < 150 && $boxb < 150) || (($boxr + $boxg + $boxb) / 3) < 85) {
    $text_colour = "#ffffff";
} else {
    $text_colour = "#000000";
}

$r = mt_rand(0, 1000);

echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "        <table width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" valign=\"top\" class=\"posthead\" width=\"50%\">\n";
echo "              <table width=\"100%\" cellspacing=\"5\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" align=\"left\">{$lang['thiscolour']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td class=\"posthead\" align=\"left\">\n";
echo "                    <a href=\"admin_make_style.php?webtag=$webtag&amp;seed=$seed&amp;r=$r\">{$lang['standardstyle']}</a><br />\n";
echo "                    <a href=\"admin_make_style.php?webtag=$webtag&amp;seed=$seed&amp;mode=medi&amp;r=$r\">{$lang['rotelementstyle']}</a><br />\n";
echo "                    <a href=\"admin_make_style.php?webtag=$webtag&amp;seed=$seed&amp;mode=rand&amp;r=$r\">{$lang['randstyle']}</a>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"posthead\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td class=\"posthead\" align=\"left\">{$lang['enterhexcolour']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td class=\"posthead\" align=\"left\">", form_input_text('seed', htmlentities_array(mb_strtoupper($seed)), 15, 6), "&nbsp;", form_submit('go', $lang['go']), "</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "            <td align=\"left\" valign=\"top\" class=\"posthead\" width=\"50%\">\n";
echo "              <table width=\"100%\" cellspacing=\"5\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" align=\"left\">{$lang['new']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td class=\"posthead\" align=\"left\">\n";
echo "                    <a href=\"admin_make_style.php?webtag=$webtag&amp;r=$r\">{$lang['standardstyle']}</a><br />\n";
echo "                    <a href=\"admin_make_style.php?webtag=$webtag&amp;mode=med&amp;r=$r\">{$lang['rotelementstyle']}</a><br />\n";
echo "                    <a href=\"admin_make_style.php?webtag=$webtag&amp;mode=rand&amp;r=$r\">{$lang['randstyle']}</a>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"posthead\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <br />\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"85%\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table width=\"100%\" class=\"box\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" align=\"left\">{$lang['savestyle']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td valign=\"top\" class=\"posthead\" align=\"left\">\n";
echo "                    <table width=\"100%\" cellspacing=\"5\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" class=\"posthead\">{$lang['filename']}:</td>\n";
echo "                        <td align=\"left\">", form_input_text("stylename", isset($_POST['stylename']) ? htmlentities_array(stripslashes_array($_POST['stylename'])) : '', 35, 10), "</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" class=\"posthead\">{$lang['styledesc']}:</td>\n";
echo "                        <td align=\"left\">", form_input_text("styledesc", isset($_POST['styledesc']) ? htmlentities_array(stripslashes_array($_POST['styledesc'])) : '', 35, 20), "</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>&nbsp;</td>\n";
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
echo "      <td align=\"center\">", form_submit('save', $lang['save']), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  </form>\n";
echo "</div>\n";
echo "<br />\n";
echo "<h1>{$lang['stylepreview']}</h1>\n";
echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<table width=\"85%\" cellpadding=\"0\" cellspacing=\"0\" class=\"box\">\n";
echo "  <tr>\n";
echo "    <td align=\"center\">\n";
echo "      <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"background-color: #{$elements['body']}; color: #", contrastFont($elements['body']), "\">\n";
echo "        <tr>\n";
echo "          <td align=\"left\" colspan=\"3\" height=\"20\" style=\"background-color: #{$elements['navpage']}; color: #", contrastFont($elements['navpage']), "; font-size: 10px; font-weight: bold; text-decoration: none\">&nbsp;\n";
echo "            <a href=\"javascript:void(0)\" style=\"color: #", contrastFont($elements['navpage']), "\">{$lang['start']}</a>&nbsp;|&nbsp;\n";
echo "            <a href=\"javascript:void(0)\" style=\"color: #", contrastFont($elements['navpage']), "\">{$lang['messages']}</a>&nbsp;|&nbsp;\n";
echo "            <a href=\"javascript:void(0)\" style=\"color: #", contrastFont($elements['navpage']), "\">{$lang['search']}</a>&nbsp;|&nbsp;\n";
echo "            <a href=\"javascript:void(0)\" style=\"color: #", contrastFont($elements['navpage']), "\">{$lang['links']}</a>&nbsp;|&nbsp;\n";
echo "            <a href=\"javascript:void(0)\" style=\"color: #", contrastFont($elements['navpage']), "\">{$lang['pminbox']}</a>&nbsp;|&nbsp;\n";
echo "            <a href=\"javascript:void(0)\" style=\"color: #", contrastFont($elements['navpage']), "\">{$lang['mycontrols']}</a>&nbsp;|&nbsp;\n";
echo "            <a href=\"javascript:void(0)\" style=\"color: #", contrastFont($elements['navpage']), "\">{$lang['myforums']}</a>&nbsp;|&nbsp;\n";
echo "            <a href=\"javascript:void(0)\" style=\"color: #", contrastFont($elements['navpage']), "\">{$lang['admin']}</a>&nbsp;|&nbsp;\n";
echo "            <a href=\"javascript:void(0)\" style=\"color: #", contrastFont($elements['navpage']), "\">{$lang['logout']}</a>\n";
echo "          </td>\n";
echo "        </tr>\n";
echo "        <tr>\n";
echo "          <td width=\"240\" valign=\"top\" align=\"center\">\n";
echo "            <table width=\"220\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
echo "              <tr>\n";
echo "                <td class=\"postbody\" style=\"color: #", contrastFont($elements['body']), "\" colspan=\"2\" align=\"left\">\n";
echo "                  <img src=\"", style_image('post.png'), "\" alt=\"{$lang['newdiscussion']}\" title=\"{$lang['newdiscussion']}\" />&nbsp;<a href=\"javascript:void(0)\" style=\"color: #", contrastFont($elements['body']), "\">{$lang['newdiscussion']}</a><br />\n";
echo "                  <img src=\"", style_image('poll.png'), "\" alt=\"{$lang['createpoll']}\" title=\"{$lang['createpoll']}\" />&nbsp;<a href=\"javascript:void(0)\" style=\"color: #", contrastFont($elements['body']), "\">{$lang['createpoll']}</a><br />\n";
echo "                  <img src=\"", style_image('pmread.png'), "\" alt=\"{$lang['pminbox']}\" title=\"{$lang['pminbox']}\" />&nbsp;<a href=\"javascript:void(0)\" style=\"color: #", contrastFont($elements['body']), "\">{$lang['pminbox']}</a><br />\n";
echo "                </td>\n";
echo "              </tr>\n";
echo "              <tr>\n";
echo "                <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "              </tr>\n";
echo "              <tr>\n";
echo "                <td colspan=\"2\" align=\"left\">\n";
echo "                  <form accept-charset=\"utf-8\" name=\"f_mode\" method=\"get\" action=\"\">\n";
echo "                    ", form_input_hidden("webtag", htmlentities_array($webtag)), "\n";
echo "                    <select name=\"mode\" class=\"bhselect\">\n";
echo "                      <option value=\"0\" selected=\"selected\">{$lang['alldiscussions']}</option>\n";
echo "                      <option value=\"1\">{$lang['unreaddiscussions']}</option>\n";
echo "                      <option value=\"2\">{$lang['unreadtome']}</option>\n";
echo "                      <option value=\"3\">{$lang['todaysdiscussions']}</option>\n";
echo "                      <option value=\"4\">{$lang['2daysback']}</option>\n";
echo "                      <option value=\"5\">{$lang['7daysback']}</option>\n";
echo "                      <option value=\"6\">{$lang['highinterest']}</option>\n";
echo "                      <option value=\"7\">{$lang['unreadhighinterest']}</option>\n";
echo "                      <option value=\"8\">{$lang['iverecentlyseen']}</option>\n";
echo "                      <option value=\"9\">{$lang['iveignored']}</option>\n";
echo "                      <option value=\"10\">{$lang['ivesubscribedto']}</option>\n";
echo "                      <option value=\"11\">{$lang['startedbyfriend']}</option>\n";
echo "                      <option value=\"12\">{$lang['unreadstartedbyfriend']}</option>\n";
echo "                    </select>\n";
echo "                    <input type=\"submit\" name=\"go\" value=\"{$lang['goexcmark']}\" class=\"button\" style=\"background-color: #{$elements['button']}; color: #", contrastFont($elements['button']), "\" />\n";
echo "                  </form>\n";
echo "                </td>\n";
echo "              </tr>\n";
echo "              <tr>\n";
echo "                <td colspan=\"2\" align=\"left\">\n";
echo "                  <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
echo "                    <tr>\n";
echo "                      <td align=\"left\" class=\"foldername\"><img src=\"", style_image('folder.png'), "\" alt=\"{$lang['folder']}\" title=\"{$lang['folder']}\" /><a href=\"javascript:void(0)\" style=\"color: #", contrastFont($elements['body']), "\">General</a></td>\n";
echo "                      <td align=\"left\" class=\"folderpostnew\" width=\"15\"><a href=\"javascript:void(0)\"><img src=\"images/folder_hide.png\" border=\"0\" alt=\"{$lang['folderinterest']}\" title=\"{$lang['folderinterest']}\" /></a></td>\n";
echo "                    </tr>\n";
echo "                  </table>\n";
echo "                </td>\n";
echo "              </tr>\n";
echo "              <tr>\n";
echo "                <td colspan=\"2\" align=\"left\">\n";
echo "                  <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
echo "                    <tr>\n";
echo "                      <td class=\"threads\" style=\"background-color: #{$elements['threads']}; color: #", contrastFont($elements['threads']), "; border-color: #", contrastFont($elements['box']), "; border-bottom-width: 0px; border-right-width: 0px\" align=\"left\" valign=\"top\" width=\"50%\" nowrap=\"nowrap\">\n";
echo "                        <a href=\"javascript:void(0)\" class=\"folderinfo\" style=\"color: #", contrastFont($elements['threads']), "\">1 {$lang['thread']}</a>\n";
echo "                      </td>\n";
echo "                      <td class=\"threads\" style=\"background-color: #{$elements['threads']}; color: #", contrastFont($elements['threads']), "; border-color: #", contrastFont($elements['box']), "; border-bottom-width: 0px; border-left-width: 0px\" align=\"right\" valign=\"top\" width=\"50%\" nowrap=\"nowrap\">\n";
echo "                        <a href=\"javascript:void(0)\" class=\"folderpostnew\" style=\"color: #", contrastFont($elements['threads']), "\">{$lang['postnew']}</a>\n";
echo "                      </td>\n";
echo "                    </tr>\n";
echo "                  </table>\n";
echo "                </td>\n";
echo "              </tr>\n";
echo "              <tr>\n";
echo "                <td align=\"left\" class=\"threads\" style=\"background-color: #{$elements['threads']}; color: #", contrastFont($elements['threads']), "; border-color: #", contrastFont($elements['box']), "; border-top-width: 0px\" colspan=\"2\">\n";
echo "                  <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
echo "                    <tr>\n";
echo "                      <td valign=\"top\" align=\"center\" nowrap=\"nowrap\" width=\"16\">\n";
echo "                        <img src=\"", style_image('current_thread.png'), "\" alt=\"{$lang['currentthread']}\" title=\"{$lang['currentthread']}\" />&nbsp;\n";
echo "                      </td>\n";
echo "                      <td align=\"left\" valign=\"top\"><a href=\"javascript:void(0)\" class=\"threadname\" style=\"color: #", contrastFont($elements['threads']), "\">{$lang['welcome']}</a>&nbsp;<img src=\"", style_image('high_interest.png'), "\" alt=\"{$lang['highinterest']}\" title=\"{$lang['highinterest']}\" />&nbsp;<span class=\"threadxnewofy\" style=\"color: #", contrastFont($elements['threads']), "\">[2]</span></td>\n";
echo "                      <td valign=\"top\" nowrap=\"nowrap\" align=\"right\"><span class=\"threadtime\" style=\"color: #", contrastFont($elements['threads']), "\">16 Mar&nbsp;</span></td>\n";
echo "                    </tr>\n";
echo "                  </table>\n";
echo "                </td>\n";
echo "              </tr>\n";
echo "              <tr>\n";
echo "                <td align=\"left\">&nbsp;</td>\n";
echo "              </tr>\n";
echo "            </table>\n";
echo "            <table width=\"220\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
echo "              <tr>\n";
echo "                <td class=\"smalltext\" style=\"color: #", contrastFont($elements['body']), "\" colspan=\"2\" align=\"left\">{$lang['markasread']}:</td>\n";
echo "              </tr>\n";
echo "              <tr>\n";
echo "                <td align=\"left\">&nbsp;</td>\n";
echo "                <td class=\"smalltext\" style=\"color: #", contrastFont($elements['body']), "\" align=\"left\">\n";
echo "                  <form accept-charset=\"utf-8\" name=\"f_mark\" method=\"get\" action=\"\">\n";
echo "                    ", form_input_hidden("webtag", htmlentities_array($webtag)), "\n";
echo "                    <select name=\"markread\" class=\"bhselect\">\n";
echo "                      <option value=\"0\" selected=\"selected\">{$lang['alldiscussions']}</option>\n";
echo "                      <option value=\"1\">{$lang['next50discussions']}s</option>\n";
echo "                      <option value=\"2\">{$lang['visiblediscussions']}</option>\n";
echo "                    </select>\n";
echo "                    <input type=\"submit\" name=\"go\" value=\"{$lang['goexcmark']}\" class=\"button\" style=\"background-color: #{$elements['button']}; color: #", contrastFont($elements['button']), "\" />\n";
echo "                  </form>\n";
echo "                </td>\n";
echo "              </tr>\n";
echo "            </table>\n";
echo "            <table width=\"220\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
echo "              <tr>\n";
echo "                <td class=\"smalltext\" style=\"color: #", contrastFont($elements['body']), "\" colspan=\"2\" align=\"left\">{$lang['navigate']}:</td>\n";
echo "              </tr>\n";
echo "              <tr>\n";
echo "                <td align=\"left\">&nbsp;</td>\n";
echo "                <td class=\"smalltext\" style=\"color: #", contrastFont($elements['body']), "\" align=\"left\">\n";
echo "                  <form accept-charset=\"utf-8\" name=\"f_nav\" method=\"get\" action=\"\">\n";
echo "                    ", form_input_hidden("webtag", htmlentities_array($webtag)), "\n";
echo "                    <input type=\"submit\" name=\"go\" value=\"{$lang['goexcmark']}\" class=\"button\" style=\"background-color: #{$elements['button']}; color: #", contrastFont($elements['button']), "\" />\n";
echo "                  </form>\n";
echo "                </td>\n";
echo "              </tr>\n";
echo "            </table>\n";
echo "            <table width=\"220\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
echo "              <tr>\n";
echo "                <td class=\"smalltext\" style=\"color: #", contrastFont($elements['body']), "\" colspan=\"2\" align=\"left\">{$lang['search']} (<a href=\"javascript:void(0)\">{$lang['advanced']}</a>):</td>\n";
echo "              </tr>\n";
echo "              <tr>\n";
echo "                <td align=\"left\">&nbsp;</td>\n";
echo "                <td class=\"smalltext\" style=\"color: #", contrastFont($elements['body']), "\" align=\"left\">\n";
echo "                  <form accept-charset=\"utf-8\" name=\"f_search\" method=\"get\" action=\"\">\n";
echo "                    ", form_input_hidden("webtag", htmlentities_array($webtag)), "\n";
echo "                    <input type=\"text\" name=\"msg\" class=\"bhinputtext\" value=\"\" size=\"20\" />\n";
echo "                    <input type=\"submit\" name=\"go\" value=\"{$lang['find']}\" class=\"button\" style=\"background-color: #{$elements['button']}; color: #", contrastFont($elements['button']), "\" />\n";
echo "                  </form>\n";
echo "                </td>\n";
echo "              </tr>\n";
echo "            </table>\n";
echo "          </td>\n";
echo "          <td align=\"left\" bgcolor=\"#FFFFFF\" width=\"2\">&nbsp;</td>\n";
echo "          <td align=\"left\" valign=\"top\">\n";
echo "            <div align=\"center\">\n";
echo "              <table width=\"96%\" border=\"0\">\n";
echo "                <tr>\n";
echo "                  <td style=\"color: #", contrastFont($elements['body']), "\"><p style=\"color: #", contrastFont($elements['body']), "\" align=\"left\"><img src=\"", style_image('folder.png'), "\" alt=\"{$lang['folder']}\" title=\"{$lang['folder']}\" />&nbsp;General: Welcome&nbsp;<img src=\"", style_image('high_interest.png'), "\" alt=\"{$lang['highinterest']}\" title=\"{$lang['highinterest']}\" /></p></td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <br />\n";
echo "              <table width=\"96%\" class=\"box\" style=\"background-color: #{$elements['box']}; color: #", contrastFont($elements['box']), "; border-style: solid; border-width: 1px; border-color: #", contrastFont($elements['box']), "\" cellspacing=\"0\" cellpadding=\"0\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\">\n";
echo "                    <table width=\"100%\" class=\"posthead\" style=\"background-color: #{$elements['threads']}; color: #", contrastFont($elements['threads']), "\" cellspacing=\"1\" cellpadding=\"0\">\n";
echo "                      <tr>\n";
echo "                        <td width=\"1%\" align=\"right\" nowrap=\"nowrap\"><span class=\"posttofromlabel\" style=\"color: #", contrastFont($elements['threads']), "\">&nbsp;{$lang['from']}:&nbsp;</span></td>\n";
echo "                        <td nowrap=\"nowrap\" width=\"98%\" align=\"left\"><span class=\"posttofrom\"><a href=\"javascript:void(0)\" style=\"color: #", contrastFont($elements['threads']), "\">User</a></span></td>\n";
echo "                        <td width=\"1%\" align=\"right\" nowrap=\"nowrap\"><span class=\"postinfo\" style=\"color: #", contrastFont($elements['threads']), "\">14 Mar 23:56&nbsp;</span></td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td width=\"1%\" align=\"right\" nowrap=\"nowrap\"><span class=\"posttofromlabel\" style=\"color: #", contrastFont($elements['threads']), "\">&nbsp;{$lang['to']}:&nbsp;</span></td>\n";
echo "                        <td nowrap=\"nowrap\" width=\"98%\" align=\"left\"><span class=\"posttofrom\" style=\"color: #", contrastFont($elements['threads']), "\">{$lang['all_caps']}</span></td>\n";
echo "                        <td align=\"right\" nowrap=\"nowrap\"><span class=\"postinfo\" style=\"color: #", contrastFont($elements['threads']), "\">1 {$lang['of']} 2&nbsp;</span></td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\">\n";
echo "                    <table width=\"100%\">\n";
echo "                      <tr align=\"right\">\n";
echo "                        <td align=\"right\" colspan=\"3\"><span class=\"postnumber\" style=\"color: #", contrastFont($elements['box']), "\"><a href=\"javascript:void(0)\" style=\"color: #", contrastFont($elements['box']), "\">1.1</a> {$lang['inreplyto']} <a href=\"javascript:void(0)\" style=\"color: #", contrastFont($elements['box']), "\">1.2</a>&nbsp;</span></td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td class=\"postbody\" style=\"color: #", contrastFont($elements['box']), "\" align=\"left\">{$lang['messagepreview']}</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" class=\"postbody\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                    <table width=\"100%\" class=\"postresponse\" style=\"background-color: #{$elements['body']}; color: #", contrastFont($elements['body']), "\" cellspacing=\"1\" cellpadding=\"0\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\" width=\"25%\">&nbsp;</td>\n";
echo "                        <td align=\"center\" width=\"50%\">\n";
echo "                          <img src=\"", style_image('post.png'), "\" border=\"0\" alt=\"{$lang['reply']}\" title=\"{$lang['reply']}\" />&nbsp;<a href=\"javascript:void(0)\" style=\"color: #", contrastFont($elements['box']), "\">{$lang['reply']}</a>&nbsp;&nbsp;\n";
echo "                          <img src=\"", style_image('delete.png'), "\" border=\"0\" alt=\"{$lang['delete']}\" title=\"{$lang['delete']}\" />&nbsp;<a href=\"javascript:void(0)\" style=\"color: #", contrastFont($elements['box']), "\">{$lang['delete']}</a>&nbsp;&nbsp;\n";
echo "                          <img src=\"", style_image('edit.png'), "\" border=\"0\" alt=\"{$lang['edit']}\" title=\"{$lang['edit']}\" />&nbsp;<a href=\"javascript:void(0)\" style=\"color: #", contrastFont($elements['box']), "\">{$lang['edit']}</a>&nbsp;&nbsp;\n";
echo "                        </td>\n";
echo "                        <td align=\"right\" width=\"25%\">\n";
echo "                          <a href=\"javascript:void(0)\" style=\"color: #", contrastFont($elements['box']), "\"><img src=\"", style_image('pmunread.png'), "\" border=\"0\" alt=\"{$lang['reply']}\" title=\"{$lang['reply']}\" /></a>\n";
echo "                          <a href=\"javascript:void(0)\" style=\"color: #", contrastFont($elements['box']), "\"><img src=\"", style_image('print.png'), "\" border=\"0\" alt=\"{$lang['reply']}\" title=\"{$lang['reply']}\" /></a>\n";
echo "                          <a href=\"javascript:void(0)\" style=\"color: #", contrastFont($elements['box']), "\"><img src=\"", style_image('markasunread.png'), "\" border=\"0\" alt=\"{$lang['reply']}\" title=\"{$lang['reply']}\" /></a>\n";
echo "                          <a href=\"javascript:void(0)\" style=\"color: #", contrastFont($elements['box']), "\"><img src=\"", style_image('admintool.png'), "\" border=\"0\" alt=\"{$lang['reply']}\" title=\"{$lang['reply']}\" /></a>\n";
echo "                          <span class=\"adminipdisplay\"><b>{$lang['ip']}:</b> <a href=\"javascript:void(0)\">127.0.0.1</a></span>\n";
echo "                        </td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <br />\n";
echo "              <table width=\"96%\" class=\"messagefoot\" style=\"background-color: #{$elements['threads']}; color: #", contrastFont($elements['threads']), "\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <p align=\"center\" class=\"smalltext\" style=\"color: #", contrastFont($elements['threads']), "\">{$lang['showmessages']}: &nbsp;1 &nbsp;<a href=\"javascript:void(0)\" style=\"color: #", contrastFont($elements['threads']), "\">2</a></p>\n";
echo "                    <p align=\"center\"></p>\n";
echo "                    <form accept-charset=\"utf-8\" name=\"rate_interest\" target=\"_self\" action=\"\" method=\"post\">\n";
echo "                      ", form_input_hidden("webtag", htmlentities_array($webtag)), "\n";
echo "                      {$lang['ratemyinterest']}\n";
echo "                      <span class=\"bhinputradio\"><input type=\"radio\" name=\"interest\" value=\"-1\" />{$lang['ignore']} </span>\n";
echo "                      <span class=\"bhinputradio\"><input type=\"radio\" name=\"interest\" value=\"0\" checked=\"checked\" />{$lang['normal']} </span>\n";
echo "                      <span class=\"bhinputradio\"><input type=\"radio\" name=\"interest\" value=\"1\" />{$lang['interested']} </span>\n";
echo "                      <span class=\"bhinputradio\"><input type=\"radio\" name=\"interest\" value=\"2\" />{$lang['subscribe']} </span>&nbsp;\n";
echo "                      <input type=\"submit\" name=\"submit\" value=\"{$lang['apply']}\" class=\"button\" style=\"background-color: #{$elements['button']}; color: #", contrastFont($elements['button']), "\" />\n";
echo "                    </form>\n";
echo "                    <p style=\"color: #", contrastFont($elements['threads']), "\">{$lang['adjtextsize']}: <a href=\"javascript:void(0)\" style=\"color: #", contrastFont($elements['threads']), "\">{$lang['smaller']}</a> 10 <a href=\"javascript:void(0)\" style=\"color: #", contrastFont($elements['threads']), "\">{$lang['larger']}</a></p>\n";
echo "                    <p align=\"center\"></p>\n";
echo "                    <div align=\"center\">\n";
echo "                      <table width=\"96%\" class=\"posthead\" style=\"background-color: #{$elements['threads']}; color: #", contrastFont($elements['threads']), "\">\n";
echo "                        <tr>\n";
echo "                          <td width=\"60%\" class=\"smalltext\" align=\"left\">\n";
echo "                            Beehive Forum ", BEEHIVE_VERSION, "&nbsp;|&nbsp;\n";
echo "                            <a href=\"javascript:void(0)\" style=\"color: #", contrastFont($elements['threads']), "\">{$lang['faq']}</a>&nbsp;|&nbsp;\n";
echo "                            <a href=\"javascript:void(0)\" target=\"_blank\" style=\"color: #", contrastFont($elements['threads']), "\">{$lang['docs']}</a> &nbsp;|&nbsp;\n";
echo "                            <a href=\"javascript:void(0)\" target=\"_blank\" style=\"color: #", contrastFont($elements['threads']), "\">{$lang['support']}</a>\n";
echo "                          </td>\n";
echo "                          <td width=\"40%\" align=\"right\" class=\"smalltext\">&copy;2002 - ", date('Y'), " <a href=\"javascript:void(0)\" style=\"color: #", contrastFont($elements['threads']), "\">Project Beehive Forum</a></td>\n";
echo "                        </tr>\n";
echo "                      </table>\n";
echo "                    </div>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </div>\n";
echo "            <br />\n";
echo "          </td>\n";
echo "        </tr>\n";
echo "      </table>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo "</div>\n";

html_draw_bottom();

?>