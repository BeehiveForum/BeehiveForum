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

/* $Id: admin_prof_items.php,v 1.49 2004-04-04 21:03:38 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum webtag and settings
$webtag = get_webtag();
$forum_settings = get_forum_settings();

include_once("./include/admin.inc.php");
include_once("./include/constants.inc.php");
include_once("./include/db.inc.php");
include_once("./include/form.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/perm.inc.php");
include_once("./include/profile.inc.php");
include_once("./include/session.inc.php");

if (!$user_sess = bh_session_check()) {

    if (isset($HTTP_SERVER_VARS["REQUEST_METHOD"]) && $HTTP_SERVER_VARS["REQUEST_METHOD"] == "POST") {
        
        if (perform_logon(false)) {
	    
	    html_draw_top();

            echo "<h1>{$lang['loggedinsuccessfully']}</h1>";
            echo "<div align=\"center\">\n";
	    echo "<p><b>{$lang['presscontinuetoresend']}</b></p>\n";

            $request_uri = get_request_uri();

            echo "<form method=\"post\" action=\"$request_uri\" target=\"_self\">\n";

            foreach($HTTP_POST_VARS as $key => $value) {
	        form_input_hidden($key, _htmlentities(_stripslashes($value)));
            }

	    echo form_submit(md5(uniqid(rand())), $lang['continue']), "&nbsp;";
            echo form_button(md5(uniqid(rand())), $lang['cancel'], "onclick=\"self.location.href='$request_uri'\""), "\n";
	    echo "</form>\n";
	    
	    html_draw_bottom();
	    exit;
	}

    }else {
        html_draw_top();
        draw_logon_form(false);
	html_draw_bottom();
	exit;
    }
}

// Load the wordfilter for the current user

$user_wordfilter = load_wordfilter();

if (!(bh_session_get_value('STATUS') & USER_PERM_SOLDIER)) {
    html_draw_top();
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;
}

if (isset($HTTP_POST_VARS['cancel'])) {
    header_redirect('./admin_prof_sect.php');
}

if (isset($HTTP_GET_VARS['psid']) && is_numeric($HTTP_GET_VARS['psid'])) {

  $psid = $HTTP_GET_VARS['psid'];

}elseif (isset($HTTP_POST_VARS['t_psid']) && is_numeric($HTTP_POST_VARS['t_psid'])) {

  $psid = $HTTP_POST_VARS['t_psid'];

}else {

  html_draw_top();
  echo "<h1>{$lang['invalidop']}</h1>\n";
  echo "<p>{$lang['noprofilesectionspecified']}</p>\n";
  html_draw_bottom();
  exit;

}

if (isset($HTTP_POST_VARS['submit'])) {

    if (isset($HTTP_POST_VARS['t_piid'])) {

        foreach($HTTP_POST_VARS['t_piid'] as $piid => $value) {

            if (($HTTP_POST_VARS['t_name'][$piid] != $HTTP_POST_VARS['t_old_name'][$piid]) || ($HTTP_POST_VARS['t_move'][$piid] != $psid) || ($HTTP_POST_VARS['t_position'][$piid] != $HTTP_POST_VARS['t_old_position'][$piid]) || ($HTTP_POST_VARS['t_type'][$piid] != $HTTP_POST_VARS['t_old_type'][$piid])) {
                $new_name = (trim($HTTP_POST_VARS['t_name'][$piid]) != "") ? trim($HTTP_POST_VARS['t_name'][$piid]) : $HTTP_POST_VARS['t_old_name'][$piid];
                profile_item_update($HTTP_POST_VARS['t_piid'][$piid], $HTTP_POST_VARS['t_move'][$piid], $HTTP_POST_VARS['t_position'][$piid], $HTTP_POST_VARS['t_type'][$piid], $new_name);
                admin_addlog(0, 0, 0, 0, $psid, $HTTP_POST_VARS['t_piid'][$piid], 13);
            }
        }
    }

    if (trim($HTTP_POST_VARS['t_name_new']) != "" && trim($HTTP_POST_VARS['t_name_new']) != $lang['newitem']) {
        $new_piid = profile_item_create($psid, trim($HTTP_POST_VARS['t_name_new']), (isset($HTTP_POST_VARS['t_piid']) ? sizeof($HTTP_POST_VARS['t_piid']) : 1), $HTTP_POST_VARS['t_type_new']);
        admin_addlog(0, 0, 0, 0, $psid, $new_piid, 14);
    }

}elseif (isset($HTTP_POST_VARS['t_delete'])) {

    list($piid) = array_keys($HTTP_POST_VARS['t_delete']);
    profile_item_delete($piid);
    admin_addlog(0, 0, 0, 0, 0, $piid, 15);
}

html_draw_top();

// Draw the form
echo "<h1>{$lang['admin']} : {$lang['manageprofileitems']}<br />{$lang['section']}: ". profile_section_get_name($psid). "</h1>\n";
echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form name=\"f_sections\" action=\"admin_prof_items.php?webtag=$webtag\" method=\"post\">\n";
echo "  ", form_input_hidden("t_psid", $psid), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"96%\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" align=\"left\">&nbsp;{$lang['position']}</td>\n";
echo "                  <td class=\"subhead\" align=\"left\">&nbsp;{$lang['itemname']}</td>\n";
echo "                  <td class=\"subhead\" align=\"left\">&nbsp;{$lang['type']}</td>\n";
echo "                  <td class=\"subhead\" align=\"left\">&nbsp;{$lang['moveto']}</td>\n";
echo "                  <td class=\"subhead\" align=\"left\">&nbsp;{$lang['deleteitem']}</td>\n";
echo "                </tr>\n";

if ($profile_items = profile_items_get($psid)) {

    for($i = 0; $i < sizeof($profile_items); $i++) {

        echo "                <tr>\n";
        echo "                  <td valign=\"top\" align=\"left\">", form_dropdown_array("t_position[{$profile_items[$i]['PIID']}]", range(1, sizeof($profile_items) + 1), range(1, sizeof($profile_items) + 1), $i + 1), form_input_hidden("t_old_position[{$profile_items[$i]['PIID']}]", $i), form_input_hidden("t_piid[{$profile_items[$i]['PIID']}]", $profile_items[$i]['PIID']), "</td>\n";
        echo "                  <td valign=\"top\" align=\"left\">", form_field("t_name[{$profile_items[$i]['PIID']}]", $profile_items[$i]['NAME'], 64, 64), form_input_hidden("t_old_name[{$profile_items[$i]['PIID']}]", $profile_items[$i]['NAME']), "</td>\n";
        echo "                  <td valign=\"top\" align=\"left\">", form_dropdown_array("t_type[{$profile_items[$i]['PIID']}]", range(0, 5), array($lang['largetextfield'], $lang['mediumtextfield'], $lang['smalltextfield'], $lang['multilinetextfield'], $lang['radiobuttons'], $lang['dropdown']), $profile_items[$i]['TYPE']), form_input_hidden("t_old_type[{$profile_items[$i]['PIID']}]", $profile_items[$i]['TYPE']), "</td>\n";
        echo "                  <td valign=\"top\" align=\"left\">", profile_section_dropdown($psid, "t_move[{$profile_items[$i]['PIID']}]"), "</td>\n";
        echo "                  <td valign=\"top\" align=\"left\" width=\"100\">", form_submit("t_delete[{$profile_items[$i]['PIID']}]", $lang['delete']), "</td>\n";
        echo "                </tr>\n";
    }
}

// Draw a row for a new section to be created
echo "                <tr>\n";
echo "                  <td align=\"left\">{$lang['new_caps']}</td>\n";
echo "                  <td align=\"left\">", form_field("t_name_new", $lang['newitem'], 64, 64), "</td>";
echo "                  <td valign=\"top\" align=\"left\">", form_dropdown_array("t_type_new", range(0, 5), array($lang['largetextfield'], $lang['mediumtextfield'], $lang['smalltextfield'], $lang['multilinetextfield'], $lang['radiobuttons'], $lang['dropdown'])), "</td>\n";
echo "                  <td align=\"center\">&nbsp;</td>\n";
echo "                  <td align=\"center\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"4\">&nbsp;</td>\n";
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
echo "      <td align=\"center\">", form_submit("submit", $lang['save']), "&nbsp;", form_submit("cancel", $lang['back']), "</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td>&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td>{$lang['fieldtypeexample1']}</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td>&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td>{$lang['fieldtypeexample2']}</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";
echo "</div>\n";

html_draw_bottom();

?>