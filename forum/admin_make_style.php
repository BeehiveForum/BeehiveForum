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

/* $Id: admin_make_style.php,v 1.69 2005-01-19 21:49:25 decoyduck Exp $ */

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

include_once("./include/admin.inc.php");
include_once("./include/constants.inc.php");
include_once("./include/db.inc.php");
include_once("./include/form.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/make_style.inc.php");
include_once("./include/session.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri(true));
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=admin.php%3Fpage%3D$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

if (!perm_has_admin_access()) {
    html_draw_top();
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;
}

// Save the style

$success = false;

if (isset($_POST['submit'])) {

    if (isset($_POST['stylename']) && strlen(trim(_stripslashes($_POST['stylename']))) > 0) {

        // Get the style filename

        $stylename = trim(_stripslashes($_POST['stylename']));
        $stylename = strtolower(str_replace(" ", "_", $stylename));
        $stylename = preg_replace("/[^a-z|0-9|'_']/", "", $stylename);

        // Get the style desc - if no description use the filename.

        if (isset($_POST['styledesc']) && strlen(trim(_stripslashes($_POST['styledesc']))) > 0) {
            $styledesc = trim(_stripslashes($_POST['styledesc']));
        }else {
            $styledesc = $stylename;
        }

        clearstatcache();

        // Read in the master style sheet.

        $stylesheet = implode("", file("./styles/make_style.css"));

        // Modify it with the colours specified by the post data.

        foreach ($_POST['elements'] as $key => $value) {
            $stylesheet = str_replace("\$elements[$key]", strtoupper($value), $stylesheet);
            $stylesheet = str_replace("\$text_colour[$key]", strtoupper(contrastFont($value)), $stylesheet);
        }

        // Save the style sheet

        if (!@file_exists("./forums/$webtag/styles/$stylename/style.css")) {

            // Create the directory structure we need
            // Beehive defaults to setting permissions to 0777
            // so that the folders are writable via FTP / SSH
            // if the user later requires them to be.

            if (!is_dir("forums")) {

                @mkdir("forums", 0755);
                @chmod("forums", 0777);
            }

            if (!is_dir("forums/$webtag")) {

                @mkdir("forums/$webtag", 0755);
                @chmod("forums/$webtag", 0777);
            }

            if (!is_dir("forums/$webtag/styles")) {

                @mkdir("forums/$webtag/styles", 0755);
                @chmod("forums/$webtag/styles", 0777);
            }

            if (!is_dir("forums/$webtag/styles/$stylename")) {

                @mkdir("forums/$webtag/styles/$stylename", 0755);
                @chmod("forums/$webtag/styles/$stylename", 0777);
            }

            // Save the style desc.txt file

            if (@$fp = fopen("./forums/$webtag/styles/$stylename/desc.txt", "w")) {

                fwrite($fp, $styledesc);
                fclose($fp);

                // Save the style.css file

                if (@$fp = fopen("./forums/$webtag/styles/$stylename/style.css", "w")) {

                    fwrite($fp, $stylesheet);
                    fclose($fp);

                    $success = true;

                    admin_addlog(0, 0, 0, 0, 0, 0, 17);
                    echo "<h2>{$lang['newstyle']} \"$stylename\" {$lang['successfullycreated']}</h2>\n";
                }
            }

            // We failed to save the style locally, so send it to the user
            // so they can then upload it to the server via FTP.

            if (!$success) {

                admin_addlog(0, 0, 0, 0, 0, 0, 17);

                $style_download = "/*======================================================================\n";
                $style_download.= "Copyright Project BeehiveForum 2002\n\n";
                $style_download.= "This file is part of BeehiveForum.\n\n";
                $style_download.= "BeehiveForum is free software; you can redistribute it and/or modify\n";
                $style_download.= "it under the terms of the GNU General Public License as published by\n";
                $style_download.= "the Free Software Foundation; either version 2 of the License, or\n";
                $style_download.= "(at your option) any later version.\n\n";
                $style_download.= "BeehiveForum is distributed in the hope that it will be useful,\n";
                $style_download.= "but WITHOUT ANY WARRANTY; without even the implied warranty of\n";
                $style_download.= "MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the\n";
                $style_download.= "GNU General Public License for more details.\n\n";
                $style_download.= "You should have received a copy of the GNU General Public License\n";
                $style_download.= "along with Beehive; if not, write to the Free Software\n";
                $style_download.= "Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307\n";
                $style_download.= "USA\n";
                $style_download.= "======================================================================\n\n";
                $style_download.= "*** Auto generated by BeehiveForum on ". date('d/m/Y', mktime()). "\n\n";
                $style_download.= "*** Beehive was unable to save this style locally to your\n";
                $style_download.= "*** server. Please upload this file to your forum styles\n";
                $style_download.= "*** folder, creating where neccesary the folder to hold\n";
                $style_download.= "*** this style.css file.\n\n";
                $style_download.= "======================================================================*/\n\n";
                $style_download.= $stylesheet;

                $length = strlen($style_download);

                header("Content-Type: application/x-ms-download", true);
                header("Content-Length: $length", true);
                header("Content-disposition: attachment; filename=\"style.css\"", true);
                echo $style_download;
                exit;
            }

        }else {

            echo "<h2>{$lang['stylealreadyexists']}</h2>\n";
        }

    }else {

        echo "<h2>{$lang['stylenofilename']}</h2>\n";
    }
}

// Start Here

html_draw_top();

echo "<h1>{$lang['admin']} : {$lang['createforumstyle']}</h1>\n";

// Check to see if any of the required variables were passed via the URL Query or POST_VARS
// Otherwise create some random numbers to work with.

if (isset($_GET['seed'])) {
    $seed = substr(preg_replace("/[^0-9|A-F]/i", "", $_GET['seed']), 0, 6);
    list ($red, $green, $blue) = hexToDec($seed);
}else {
    $red = rand(0, 255);
    $green = rand(0, 255);
    $blue = rand(0, 255);
}

if (isset($_GET['mode']) && $_GET['mode'] == 'rand') {
    $mode = 'rand';
}else {
    $mode = '';
}

//Maximum variance for the colours

$max_var = 15;

// An array of all the Beehive CSS elements.

$elements = array ('navpage' => '', 'threads' => '', 'button' => '', 'subhead' => '', 'h1' => '', 'body' => '', 'box' => '');

if ($mode != "") {
    uasort($elements, rand_sort());
}

$colour = decToHex($red, $green, $blue);
$seed = $colour;

list ($r, $g, $b) = hexToDec($colour);

$steps = sizeof($elements);


echo "<p>{$lang['styleexp']}</p>\n";
echo "<div align=\"center\">\n";
echo "  <table width=\"70%\" class=\"box\">\n";
echo "    <tr>\n";
echo "      <td class=\"posthead\">\n";
echo "        <table width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td colspan=\"2\" class=\"subhead\" align=\"left\">{$lang['stylecontrols']}</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td colspan=\"2\" class=\"posthead\">\n";
echo "              <table width=\"100%\">\n";
echo "                <tr>\n";

if (isset($_POST['submit'])) {

    $elements = $_POST['elements'];

    foreach ($_POST['elements'] as $key => $value) {

        echo "                  <td width=\"50\" class=\"posthead\" style=\"background-color: #", $value, "\" align=\"center\">\n";
        echo "                    <a href=\"admin_make_style.php?webtag=$webtag&amp;seed=", $value, "&amp;mode=", $mode, "\" style=\"color: #", contrastFont($value), "\">", strtoupper($value), "</a>\n";
        echo "                  </td>\n";

    }


}else {

    foreach ($elements as $key => $value) {

        echo "                  <td width=\"50\" class=\"posthead\" style=\"background-color: #", $colour, "; color: #", contrastFont($colour), "\" align=\"center\">\n";
        echo "                    <a href=\"admin_make_style.php?webtag=$webtag&amp;seed=", $colour, "&amp;mode=", $mode, "\" style=\"color: #", contrastFont($colour), "\">", strtoupper($colour), "</a>\n";
        echo "                  </td>\n";

        $elements[$key] = $colour;
        list ($r, $g, $b) = hexToDec($colour);
        $colour = changeColour ($r, $g, $b, $max_var, $mode, $steps);
        $steps--;

    }

    reset($elements);

}

echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"", sizeof($elements), "\" class=\"posthead\" align=\"left\">\n";
echo "                    {$lang['stylecolourexp']}\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "        <table width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\" width=\"250\">\n";
echo "              <table width=\"100%\" cellspacing=\"5\">\n";
echo "                <tr>\n";

list ($boxr, $boxg, $boxb) = hexToDec($elements['box']);

if (($boxr < 150 and $boxg < 150 and $boxb < 150) or (($boxr + $boxg + $boxb) / 3) < 85) {
    $text_colour = "#ffffff";
} else {
    $text_colour = "#000000";
}

$r = rand(0, 1000);

echo "                  <td class=\"subhead\" align=\"left\">New</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td class=\"posthead\" align=\"left\">\n";
echo "                    <a href=\"admin_make_style.php?webtag=$webtag&amp;r=$r\">{$lang['standardstyle']}</a><br />\n";
echo "                    <a href=\"admin_make_style.php?webtag=$webtag&amp;mode=med&amp;r=$r\">{$lang['rotelementstyle']}</a><br />\n";
echo "                    <a href=\"admin_make_style.php?webtag=$webtag&amp;mode=rand&amp;r=$r\">{$lang['randstyle']}</a>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td class=\"posthead\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" align=\"left\">This Colour</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td class=\"posthead\" align=\"left\">\n";
echo "                    <a href=\"admin_make_style.php?webtag=$webtag&amp;seed=$seed&amp;r=$r\">{$lang['standardstyle']}</a><br />\n";
echo "                    <a href=\"admin_make_style.php?webtag=$webtag&amp;seed=$seed&amp;mode=medi&amp;r=$r\">{$lang['rotelementstyle']}</a><br />\n";
echo "                    <a href=\"admin_make_style.php?webtag=$webtag&amp;seed=$seed&amp;mode=rand&amp;r=$r\">{$lang['randstyle']}</a>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td class=\"posthead\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td class=\"posthead\" align=\"left\">{$lang['enterhexcolour']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td class=\"posthead\" align=\"left\">\n";
echo "                    <form action=\"admin_make_style.php\" method=\"get\">\n";
echo "                      ", form_input_hidden("webtag", $webtag), "\n";
echo "                      ", form_input_text("seed", strtoupper($seed), 15, 6), "&nbsp;", form_submit('submit', $lang['go']), "\n";
echo "                    </form>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "            <td valign=\"top\" class=\"posthead\" align=\"left\">\n";
echo "              <table width=\"100%\" cellspacing=\"5\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\">{$lang['savestyle']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td class=\"posthead\">\n";
echo "                    <form action=\"admin_make_style.php\" method=\"post\">\n";
echo "                      ", form_input_hidden('webtag', $webtag), "\n";

foreach ($elements as $key => $value) {
    echo "                      ", form_input_hidden("elements[$key]", $value), "\n";
}

reset($elements);

echo "                      <table width=\"100%\" cellspacing=\"5\">\n";
echo "                        <tr>\n";
echo "                          <td class=\"posthead\">{$lang['filename']}:</td>\n";
echo "                          <td>", form_input_text("stylename", isset($_POST['stylename']) ? $_POST['stylename'] : '', 35, 10), "</td>\n";
echo "                        </tr>\n";
echo "                        <tr>\n";
echo "                          <td class=\"posthead\">{$lang['styledesc']}:</td>\n";
echo "                          <td>", form_input_text("styledesc", isset($_POST['styledesc']) ? $_POST['styledesc'] : '', 35, 20), "&nbsp;", form_submit('submit', 'Save'), "</td>\n";
echo "                        </tr>\n";
echo "                      </table>\n";
echo "                    </form>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td class=\"posthead\">{$lang['fileallowedchars']}</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</div>\n";
echo "<br />\n";
echo "<h1>{$lang['stylepreview']}:</h1>\n";
echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<table width=\"96%\" cellpadding=\"0\" cellspacing=\"0\" class=\"box\">\n";
echo "  <tr>\n";
echo "    <td align=\"center\">\n";
echo "      <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"background-color: #{$elements['body']}; color: #", contrastFont($elements['body']), "\">\n";
echo "        <tr>\n";
echo "          <td colspan=\"3\" height=\"20\" style=\"background-color: #{$elements['navpage']}; color: #", contrastFont($elements['navpage']), "; font-size: 10px; font-weight: bold; text-decoration: none\">&nbsp;&nbsp;\n";
echo "            <a href=\"javascript:void(0)\" style=\"color: #", contrastFont($elements['navpage']), "\">{$lang['start']}</a>&nbsp;|&nbsp;\n";
echo "            <a href=\"javascript:void(0)\" style=\"color: #", contrastFont($elements['navpage']), "\">{$lang['messages']}</a>&nbsp;|&nbsp;\n";
echo "            <a href=\"javascript:void(0)\" style=\"color: #", contrastFont($elements['navpage']), "\">{$lang['links']}</a>&nbsp;|&nbsp;\n";
echo "            <a href=\"javascript:void(0)\" style=\"color: #", contrastFont($elements['navpage']), "\">{$lang['preferences']}</a>&nbsp;|&nbsp;\n";
echo "            <a href=\"javascript:void(0)\" style=\"color: #", contrastFont($elements['navpage']), "\">{$lang['profile']}</a>&nbsp;|&nbsp;\n";
echo "            <a href=\"javascript:void(0)\" style=\"color: #", contrastFont($elements['navpage']), "\">{$lang['admin']}</a>&nbsp;|&nbsp;\n";
echo "            <a href=\"javascript:void(0)\" style=\"color: #", contrastFont($elements['navpage']), "\">{$lang['logout']}</a>\n";
echo "          </td>\n";
echo "        </tr>\n";
echo "        <tr>\n";
echo "          <td width=\"240\" valign=\"top\" align=\"center\">\n";
echo "            <table width=\"220\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n";
echo "              <tr>\n";
echo "                <td class=\"postbody\" style=\"color: #", contrastFont($elements['body']), "\" colspan=\"2\" align=\"left\">\n";
echo "                  <img src=\"", style_image('post.png'), "\" height=\"15\" alt=\"{$lang['newdiscussion']}\" title=\"{$lang['newdiscussion']}\" />&nbsp;<a href=\"javascript:void(0)\" style=\"color: #", contrastFont($elements['body']), "\">{$lang['newdiscussion']}</a><br />\n";
echo "                  <img src=\"", style_image('poll.png'), "\" height=\"15\" alt=\"{$lang['createpoll']}\" title=\"{$lang['createpoll']}\" />&nbsp;<a href=\"javascript:void(0)\" style=\"color: #", contrastFont($elements['body']), "\">{$lang['createpoll']}</a><br />\n";
echo "                  <img src=\"", style_image('pmread.png'), "\" height=\"15\" alt=\"{$lang['pminbox']}\" title=\"{$lang['pminbox']}\" />&nbsp;<a href=\"javascript:void(0)\" style=\"color: #", contrastFont($elements['body']), "\">{$lang['pminbox']}</a><br />\n";
echo "                </td>\n";
echo "              </tr>\n";
echo "              <tr>\n";
echo "                <td colspan=\"2\">&nbsp;</td>\n";
echo "              </tr>\n";
echo "              <tr>\n";
echo "                <td colspan=\"2\" align=\"left\">\n";
echo "                  <form name=\"f_mode\" method=\"get\" action=\"\" onsubmit=\"return false\">\n";
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
echo "                    <input type=\"submit\" name=\"go\" value=\"{$lang['goexcmark']}\" class=\"button\" style=\"background-color: #{$elements['button']}; color: #", contrastFont($elements['button']), "\" onclick=\"return false\" />\n";
echo "                  </form>\n";
echo "                </td>\n";
echo "              </tr>\n";
echo "              <tr>\n";
echo "                <td colspan=\"2\" align=\"left\">\n";
echo "                  <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
echo "                    <tr>\n";
echo "                      <td class=\"foldername\"><img src=\"", style_image('folder.png'), "\" height=\"15\" alt=\"{$lang['folder']}\" title=\"{$lang['folder']}\" /><a href=\"javascript:void(0)\" style=\"color: #", contrastFont($elements['body']), "\">General</a></td>\n";
echo "                      <td class=\"folderpostnew\" width=\"15\"><a href=\"javascript:void(0)\"><img src=\"images/folder_hide.png\" border=\"0\" height=\"15\" alt=\"{$lang['folderinterest']}\" title=\"{$lang['folderinterest']}\" /></a></td>\n";
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
echo "                <td class=\"threads\" style=\"background-color: #{$elements['threads']}; color: #", contrastFont($elements['threads']), "; border-color: #", contrastFont($elements['box']), "; border-top-width: 0px\" colspan=\"2\">\n";
echo "                  <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
echo "                    <tr>\n";
echo "                      <td valign=\"top\" align=\"center\" nowrap=\"nowrap\" width=\"16\">\n";
echo "                        <img src=\"", style_image('current_thread.png'), "\" align=\"middle\" height=\"15\" alt=\"{$lang['currentthread']}\" title=\"{$lang['currentthread']}\" />&nbsp;\n";
echo "                      </td>\n";
echo "                      <td valign=\"top\"><a href=\"javascript:void(0)\" class=\"threadname\" style=\"color: #", contrastFont($elements['threads']), "\">{$lang['welcome']}</a>&nbsp;<img src=\"", style_image('high_interest.png'), "\" height=\"15\" alt=\"{$lang['highinterest']}\" title=\"{$lang['highinterest']}\" />&nbsp;<span class=\"threadxnewofy\" style=\"color: #", contrastFont($elements['threads']), "\">[2]</span></td>\n";
echo "                      <td valign=\"top\" nowrap=\"nowrap\" align=\"right\"><span class=\"threadtime\" style=\"color: #", contrastFont($elements['threads']), "\">16 Mar&nbsp;</span></td>\n";
echo "                    </tr>\n";
echo "                  </table>\n";
echo "                </td>\n";
echo "              </tr>\n";
echo "              <tr>\n";
echo "                <td>&nbsp;</td>\n";
echo "              </tr>\n";
echo "            </table>\n";
echo "            <table width=\"220\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
echo "              <tr>\n";
echo "                <td class=\"smalltext\" style=\"color: #", contrastFont($elements['body']), "\" colspan=\"2\" align=\"left\">{$lang['markasread']}:</td>\n";
echo "              </tr>\n";
echo "              <tr>\n";
echo "                <td>&nbsp;</td>\n";
echo "                <td class=\"smalltext\" style=\"color: #", contrastFont($elements['body']), "\" align=\"left\">\n";
echo "                  <form name=\"f_mark\" method=\"get\" action=\"\" onsubmit=\"return false\">\n";
echo "                    <input type=\"hidden\" name=\"tids\" class=\"bhinputtext\" value=\"1\" />\n";
echo "                    <select name=\"markread\" class=\"bhselect\">\n";
echo "                      <option value=\"0\" selected=\"selected\">{$lang['alldiscussions']}</option>\n";
echo "                      <option value=\"1\">{$lang['next50discussions']}s</option>\n";
echo "                      <option value=\"2\">{$lang['visiblediscussions']}</option>\n";
echo "                    </select>\n";
echo "                    <input type=\"submit\" name=\"go\" value=\"{$lang['goexcmark']}\" class=\"button\" style=\"background-color: #{$elements['button']}; color: #", contrastFont($elements['button']), "\" onclick=\"return false\" />\n";
echo "                  </form>\n";
echo "                </td>\n";
echo "              </tr>\n";
echo "            </table>\n";
echo "            <table width=\"220\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
echo "              <tr>\n";
echo "                <td class=\"smalltext\" style=\"color: #", contrastFont($elements['body']), "\" colspan=\"2\" align=\"left\">{$lang['navigate']}:</td>\n";
echo "              </tr>\n";
echo "              <tr>\n";
echo "                <td>&nbsp;</td>\n";
echo "                <td class=\"smalltext\" style=\"color: #", contrastFont($elements['body']), "\" align=\"left\">\n";
echo "                  <form name=\"f_nav\" method=\"get\" action=\"\" onsubmit=\"return false\">\n";
echo "                    <input type=\"text\" name=\"msg\" class=\"bhinputtext\" value=\"1.1\" size=\"10\" />\n";
echo "                    <input type=\"submit\" name=\"go\" value=\"{$lang['goexcmark']}\" class=\"button\" style=\"background-color: #{$elements['button']}; color: #", contrastFont($elements['button']), "\" onclick=\"return false\" />\n";
echo "                  </form>\n";
echo "                </td>\n";
echo "              </tr>\n";
echo "            </table>\n";
echo "          </td>\n";
echo "          <td bgcolor=\"#FFFFFF\" width=\"2\"></td>\n";
echo "          <td valign=\"top\">\n";
echo "            <div align=\"center\">\n";
echo "              <table width=\"96%\" border=\"0\">\n";
echo "                <tr>\n";
echo "                  <td style=\"color: #", contrastFont($elements['body']), "\"><p style=\"color: #", contrastFont($elements['body']), "\" align=\"left\"><img src=\"", style_image('folder.png'), "\" alt=\"{$lang['folder']}\" title=\"{$lang['folder']}\" />&nbsp;General: Welcome&nbsp;<img src=\"", style_image('high_interest.png'), "\" height=\"15\" alt=\"{$lang['highinterest']}\" title=\"{$lang['highinterest']}\" /></p></td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </div>\n";
echo "            <br />\n";
echo "            <div align=\"center\">\n";
echo "              <table width=\"96%\" class=\"box\" style=\"background-color: #{$elements['box']}; color: #", contrastFont($elements['box']), "; border-style: solid; border-width: 1px; border-color: #", contrastFont($elements['box']), "\" cellspacing=\"0\" cellpadding=\"0\">\n";
echo "                <tr>\n";
echo "                  <td>\n";
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
echo "                  <td>\n";
echo "                    <table width=\"100%\">\n";
echo "                      <tr align=\"right\">\n";
echo "                        <td colspan=\"3\"><span class=\"postnumber\" style=\"color: #", contrastFont($elements['box']), "\"><a href=\"javascript:void(0)\" style=\"color: #", contrastFont($elements['box']), "\">1.1</a> {$lang['inreplyto']} <a href=\"javascript:void(0)\" style=\"color: #", contrastFont($elements['box']), "\">1.2</a>&nbsp;</span></td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td class=\"postbody\" style=\"color: #", contrastFont($elements['box']), "\" align=\"left\">{$lang['messagepreview']}</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td>&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td class=\"postbody\"></td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                    <table width=\"100%\" class=\"postresponse\" style=\"background-color: #{$elements['body']}; color: #", contrastFont($elements['body']), "\" cellspacing=\"1\" cellpadding=\"0\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"center\">\n";
echo "                            <img src=\"", style_image('post.png'), "\" height=\"15\" border=\"0\" alt=\"{$lang['reply']}\" title=\"{$lang['reply']}\" />&nbsp;<a href=\"javascript:void(0)\" style=\"color: #", contrastFont($elements['box']), "\">{$lang['reply']}</a>&nbsp;&nbsp;\n";
echo "                            <img src=\"", style_image('delete.png'), "\" height=\"15\" border=\"0\" alt=\"{$lang['delete']}\" title=\"{$lang['delete']}\" />&nbsp;<a href=\"javascript:void(0)\" style=\"color: #", contrastFont($elements['box']), "\">{$lang['delete']}</a>&nbsp;&nbsp;\n";
echo "                            <img src=\"", style_image('edit.png'), "\" height=\"15\" border=\"0\" alt=\"{$lang['edit']}\" title=\"{$lang['edit']}\" />&nbsp;<a href=\"javascript:void(0)\" style=\"color: #", contrastFont($elements['box']), "\">{$lang['edit']}</a>&nbsp;&nbsp;\n";
echo "                            <img src=\"", style_image('admintool.png'), "\" height=\"15\" border=\"0\" alt=\"{$lang['privileges']}\" title=\"{$lang['privileges']}\" />&nbsp;<a href=\"javascript:void(0)\" style=\"color: #", contrastFont($elements['box']), "\">{$lang['privileges']}</a>\n";
echo "                        </td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </div>\n";
echo "            <p>&nbsp;</p>\n";
echo "            <div align=\"center\">\n";
echo "            <table width=\"96%\" class=\"messagefoot\" style=\"background-color: #{$elements['threads']}; color: #", contrastFont($elements['threads']), "\">\n";
echo "              <tr>\n";
echo "                <td align=\"center\">\n";
echo "                  <p align=\"center\" class=\"smalltext\" style=\"color: #", contrastFont($elements['threads']), "\">{$lang['showmessages']}: &nbsp;1 &nbsp;<a href=\"javascript:void(0)\" style=\"color: #", contrastFont($elements['threads']), "\">2</a></p>\n";
echo "                  <p align=\"center\"></p>\n";
echo "                  <form name=\"rate_interest\" target=\"_self\" action=\"\" method=\"post\">\n";
echo "                    {$lang['ratemyinterest']}\n";
echo "                    <span class=\"bhinputradio\"><input type=\"radio\" name=\"interest\" value=\"-1\" />{$lang['ignore']} </span>\n";
echo "                    <span class=\"bhinputradio\"><input type=\"radio\" name=\"interest\" value=\"0\" checked=\"checked\" />{$lang['normal']} </span>\n";
echo "                    <span class=\"bhinputradio\"><input type=\"radio\" name=\"interest\" value=\"1\" />{$lang['interested']} </span>\n";
echo "                    <span class=\"bhinputradio\"><input type=\"radio\" name=\"interest\" value=\"2\" />{$lang['subscribe']} </span>&nbsp;\n";
echo "                    <input type=\"submit\" name=\"submit\" value=\"{$lang['apply']}\" class=\"button\" style=\"background-color: #{$elements['button']}; color: #", contrastFont($elements['button']), "\" onclick=\"return false\" />\n";
echo "                  </form>\n";
echo "                  <p style=\"color: #", contrastFont($elements['threads']), "\">{$lang['adjtextsize']}: <a href=\"javascript:void(0)\" style=\"color: #", contrastFont($elements['threads']), "\">{$lang['smaller']}</a> 10 <a href=\"javascript:void(0)\" style=\"color: #", contrastFont($elements['threads']), "\">{$lang['larger']}</a></p>\n";
echo "                  <p align=\"center\"></p>\n";
echo "                  <div align=\"center\">\n";
echo "                    <table width=\"96%\" class=\"posthead\" style=\"background-color: #{$elements['threads']}; color: #", contrastFont($elements['threads']), "\">\n";
echo "                      <tr>\n";
echo "                        <td width=\"60%\" class=\"smalltext\" align=\"left\">\n";
echo "                          Beehive Forum &nbsp;|&nbsp;\n";
echo "                          <a href=\"javascript:void(0)\" style=\"color: #", contrastFont($elements['threads']), "\">{$lang['faq']}</a>&nbsp;|&nbsp;\n";
echo "                          <a href=\"javascript:void(0)\" target=\"_blank\" style=\"color: #", contrastFont($elements['threads']), "\">{$lang['docs']}</a> &nbsp;|&nbsp;\n";
echo "                          <a href=\"javascript:void(0)\" target=\"_blank\" style=\"color: #", contrastFont($elements['threads']), "\">{$lang['support']}</a>\n";
echo "                        </td>\n";
echo "                        <td width=\"40%\" align=\"right\" class=\"smalltext\">&copy;", date('Y'), " <a href=\"javascript:void(0)\" style=\"color: #", contrastFont($elements['threads']), "\">Project BeehiveForum</a></td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </div>\n";
echo "                </td>\n";
echo "              </tr>\n";
echo "            </table>\n";
echo "            </div>\n";
echo "            <p>&nbsp;</p>\n";
echo "            <h1 style=\"background-color: #{$elements['h1']}; color: #", contrastFont($elements['h1']), "\">{$lang['h1tag']}</h1>\n";
echo "            <p class=\"subhead\" style=\"background-color: #{$elements['subhead']}; color: #", contrastFont($elements['subhead']), "\">{$lang['subhead']}</p>\n";
echo "            <p>&nbsp;</p>\n";
echo "          </td>\n";
echo "        </tr>\n";
echo "      </table>\n";
echo "    </td>\n";
echo "  </tr>\n";
echo "</table>\n";
echo "</div>\n";
echo "<p>&nbsp;</p>\n";

html_draw_bottom();

?>