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

// Enable the error handler
require_once("./include/errorhandler.inc.php");

// Compress the output
require_once("./include/gzipenc.inc.php");

//Check logged in status
require_once("./include/session.inc.php");
require_once("./include/header.inc.php");

if (!bh_session_check()) {
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
require_once("./include/pm.inc.php");

if (isset($HTTP_POST_VARS['delete'])) {
  if (is_array($HTTP_POST_VARS['delete'])) {
    for ($i = 0; $i < sizeof($HTTP_POST_VARS['delete']); $i++) {
      pm_delete_message($HTTP_POST_VARS['delete'][$i]);
    }
  }
}

html_draw_top_script();

echo "<h1>{$lang['privatemessages']}: {$lang['pminbox']}</h1>\n";
echo "<div align=\"right\"><a href=\"pm.php\" target=\"_self\">{$lang['pminbox']}</a> | <a href=\"pm_write.php\" target=\"_self\">{$lang['sendnewpm']}</a></div><br />\n";

if (isset($HTTP_GET_VARS['mid'])) {

    $pm_elements_array = array();

    if ($pm_elements_array = pm_single_get($HTTP_GET_VARS['mid'])) {
        draw_pm_message($pm_elements_array, $HTTP_GET_VARS['mid']);
        echo "<p>&nbsp;</p>\n";
    }else {
        echo "<p>{$lang['messagehasbeendeleted']}</p>\n";
    }
}

// new array
$listmessages_array = array();

// get message list

$listmessages_array = pm_list_get(bh_session_get_value('TO_UID'));

echo "<form action=\"pm.php\" method=\"POST\" target=\"_self\">\n";
echo "  <table width=\"95%\" align=\"center\">\n";
echo "    <tr>\n";
echo "      <td width=\"20\" align=\"center\">&nbsp;</td>\n";
echo "      <td class=\"posthead\" width=\"50%\">&nbsp;{$lang['subject']}</td>\n";
echo "      <td class=\"posthead\">&nbsp;{$lang['sentby']}</td>\n";
echo "      <td class=\"posthead\">&nbsp;{$lang['timesent']}</td>\n";
echo "      <td class=\"posthead\">&nbsp;{$lang['delete']}</td>\n";
echo "    </tr>\n";

if (sizeof($listmessages_array) == 0) {

    echo "    <tr>\n";
    echo "      <td class=\"postbody\"></td><td class=\"postbody\">{$lang['nomessages']}</td>\n";
    echo "    </tr>\n";

}else {

    for ($i = 0; $i < sizeof($listmessages_array); $i++) {

        echo "    <tr>\n";
        echo "      <td class=\"postbody\">";

        if (isset($HTTP_GET_VARS['mid'])){
            $mid = $HTTP_GET_VARS['mid'];
        }else {
            $mid = NULL;
        }

        if ($mid == $listmessages_array[$i]['MID']) {
            echo "<img src=\"".style_image('current_thread.png')."\" align=\"middle\" height=\"15\" alt=\"\"/>";
        }else {
            if ($listmessages_array[$i]['VIEWED'] > 0) {
                echo "<img src=\"".style_image('bullet.png')."\" align=\"middle\" height=\"15\" alt=\"\"/>";
            }else {
                echo "<img src=\"".style_image('unread_thread.png')."\" align=\"middle\" height=\"15\" alt=\"\"/>";
            }
        }

        echo "</td>\n";

        echo "      <td class=\"postbody\">";
        echo "<a href=\"pm.php?mid=".$listmessages_array[$i]['MID']."\" target=\"_self\">", stripslashes($listmessages_array[$i]['SUBJECT']), "</a>";
        echo "</td>\n";

        echo "      <td class=\"postbody\">";
        echo "<a href=\"javascript:void(0);\" onclick=\"openProfile(" . $listmessages_array[$i]['FROM_UID'] . ")\" target=\"_self\">";
        echo format_user_name($listmessages_array[$i]['LOGON'], $listmessages_array[$i]['NICKNAME']) . "</a>";
        echo "</td>\n";

        echo "      <td class=\"postbody\">", format_time($listmessages_array[$i]['CREATED']), "</td>\n";
        echo "      <td class=\"postbody\">", form_checkbox('delete[]', $listmessages_array[$i]['MID'], ''), "</td>\n";
        echo "    </tr>\n";
    }

    echo "    <tr>\n";
    echo "      <td class=\"postbody\" colspan=\"4\">&nbsp;</td>\n";
    echo "      <td class=\"postbody\">", form_submit("Delete", $lang['delete']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</form>\n";
}

html_draw_bottom ();

?>