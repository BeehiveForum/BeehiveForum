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

/* $Id: admin_prof_sect.php,v 1.42 2004-03-27 19:46:59 decoyduck Exp $ */

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

html_draw_top();

if (!(bh_session_get_value('STATUS') & USER_PERM_SOLDIER)) {
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;
}

// Do updates

if (isset($HTTP_POST_VARS['submit'])) {

    if (isset($HTTP_POST_VARS['t_psid'])) {

        foreach($HTTP_POST_VARS['t_psid'] as $psid => $value) {

            if (($HTTP_POST_VARS['t_name'][$psid] != $HTTP_POST_VARS['t_old_name'][$psid]) || ($HTTP_POST_VARS['t_position'][$psid] != $HTTP_POST_VARS['t_old_position'][$psid])) {

                $new_name = (trim($HTTP_POST_VARS['t_name'][$psid]) != "") ? $HTTP_POST_VARS['t_name'][$psid] : $HTTP_POST_VARS['t_old_name'][$psid];
                profile_section_update($HTTP_POST_VARS['t_psid'][$psid], $HTTP_POST_VARS['t_position'][$psid], $new_name);
                admin_addlog(0, 0, 0, 0, $HTTP_POST_VARS['t_psid'][$psid], 0, 10);
            }
        }

    }

    if (trim($HTTP_POST_VARS['t_name_new']) != "" && trim($HTTP_POST_VARS['t_name_new']) != $lang['newsection']) {

        $new_psid = profile_section_create(trim($HTTP_POST_VARS['t_name_new']), (isset($HTTP_POST_VARS['t_psid']) ? sizeof($HTTP_POST_VARS['t_psid']) : 1));
        admin_addlog(0, 0, 0, 0, $new_psid, 0, 11);

    }

}elseif (isset($HTTP_POST_VARS['t_delete'])) {

    list($psid) = array_keys($HTTP_POST_VARS['t_delete']);
    profile_section_delete($psid);
    admin_addlog(0, 0, 0, 0, 0, $psid, 15);

}

// Draw the form
echo "<h1>{$lang['admin']} : {$lang['manageprofilesections']}</h1>\n";
echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form name=\"f_sections\" action=\"admin_prof_sect.php?webtag={$webtag['WEBTAG']}\" method=\"post\">\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"96%\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" align=\"left\">{$lang['position']}</td>\n";
echo "                  <td class=\"subhead\" align=\"left\">{$lang['sectionname']}</td>\n";
echo "                  <td class=\"subhead\" align=\"left\">&nbsp;{$lang['items']}</td>\n";
echo "                  <td class=\"subhead\" align=\"left\">&nbsp;{$lang['deletesection']}</bdo></td>\n";
echo "                </tr>\n";

if ($profile_sections = profile_sections_get()) {

    for ($i = 0; $i < sizeof($profile_sections); $i++) {

        echo "                <tr>\n";
        echo "                  <td valign=\"top\" align=\"left\">", form_dropdown_array("t_position[{$profile_sections[$i]['PSID']}]", range(1, sizeof($profile_sections) + 1), range(1, sizeof($profile_sections) + 1), $i + 1), form_input_hidden("t_old_position[{$profile_sections[$i]['PSID']}]", $i), form_input_hidden("t_psid[{$profile_sections[$i]['PSID']}]", $profile_sections[$i]['PSID']), "</td>\n";
        echo "                  <td valign=\"top\" align=\"left\">", form_field("t_name[{$profile_sections[$i]['PSID']}]", $profile_sections[$i]['NAME'] ,64, 64), form_input_hidden("t_old_name[{$profile_sections[$i]['PSID']}]", $profile_sections[$i]['NAME']), "</td>\n";
        echo "                  <td valign=\"top\" align=\"left\">", form_button("items", $lang['items'], "onclick=\"document.location.href='admin_prof_items.php?webtag={$webtag['WEBTAG']}&psid={$profile_sections[$i]['PSID']}'\""), "</a></td>\n";

        if (!profile_items_get($profile_sections[$i]['PSID'])) {
            echo "                  <td>", form_submit("t_delete[{$profile_sections[$i]['PSID']}]", $lang['delete']), "</td>\n";
        }else{
            echo "                  <td>&nbsp;</td>\n";
        }

        echo "                </tr>\n";
    }
}

// Draw a row for a new section to be created
echo "                <tr>\n";
echo "                  <td align=\"left\">NEW</td>\n";
echo "                  <td align=\"left\">", form_field("t_name_new", $lang['newsection'], 64, 64), "</td>\n";
echo "                  <td align=\"center\" colspan=\"2\">&nbsp;</td>\n";
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
echo "      <td align=\"center\">", form_submit("submit", $lang['save']), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";
echo "</div>\n";

html_draw_bottom();

?>