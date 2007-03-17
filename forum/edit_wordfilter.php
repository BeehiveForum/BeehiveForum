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

/* $Id: edit_wordfilter.php,v 1.61 2007-03-17 15:26:17 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

// Compress the output
include_once(BH_INCLUDE_PATH. "gzipenc.inc.php");

// Enable the error handler
include_once(BH_INCLUDE_PATH. "errorhandler.inc.php");

// Installation checking functions
include_once(BH_INCLUDE_PATH. "install.inc.php");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once(BH_INCLUDE_PATH. "forum.inc.php");

// Fetch the forum settings
$forum_settings = forum_get_settings();

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.

if (bh_session_user_banned()) {

    html_user_banned();
    exit;
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

html_draw_top();

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = ($_GET['page'] > 0) ? $_GET['page'] : 1;
}else {
    $page = 1;
}

$word_filter_options = array(0 => $lang['all'],
                             1 => $lang['wholeword'],
                             2 => $lang['preg']);
$valid = true;
$error_html = "";

if (isset($_POST['cancel']) || isset($_POST['delete'])) {
    
    unset($_POST['addfilter'], $_POST['filter_id'], $_GET['addfilter'], $_GET['filter_id']);
}

if (isset($_POST['delete'])) {
    
    if (isset($_POST['delete_filters']) && is_array($_POST['delete_filters'])) {

        foreach($_POST['delete_filters'] as $filter_id => $delete_filter) {

            if (($delete_filter == "Y") && user_get_word_filter($filter_id)) {
                
                if (!user_delete_word_filter($filter_id)) {

                    $valid = false;
                    $error_html = "<h2>{$lang['failedtoupdatewordfilter']}</h2>\n";
                }
            }
        }

        if ($valid) {

            $redirect = "./edit_wordfilter.php?webtag=$webtag&updated=true";
            header_redirect($redirect, $lang['wordfilterupdated']);
            exit;
        }
    }

}elseif (isset($_POST['save'])) {

    if (isset($_POST['use_admin_filter']) && $_POST['use_admin_filter'] == "Y") {
        $user_prefs['USE_ADMIN_FILTER'] = "Y";
        $user_prefs_global['USE_ADMIN_FILTER'] = false;
    }else {
        $user_prefs['USE_ADMIN_FILTER'] = "N";
        $user_prefs_global['USE_ADMIN_FILTER'] = false;
    }

    if (isset($_POST['use_word_filter']) && $_POST['use_word_filter'] == "Y") {
        $user_prefs['USE_WORD_FILTER'] = "Y";
        $user_prefs_global['USE_WORD_FILTER'] = false;
    }else {
        $user_prefs['USE_WORD_FILTER'] = "N";
        $user_prefs_global['USE_WORD_FILTER'] = false;
    }

    $uid = bh_session_get_value('UID');
    
    user_update_prefs($uid, $user_prefs, $user_prefs_global);

    $redirect = "./edit_wordfilter.php?webtag=$webtag&updated=true";
    header_redirect($redirect, $lang['wordfilterupdated']);
    exit;

}elseif (isset($_POST['addfilter_submit'])) {
    
    if (isset($_POST['add_new_match_text']) && strlen(trim(_stripslashes($_POST['add_new_match_text'])))) {
       $add_new_match_text = trim(_stripslashes($_POST['add_new_match_text']));
    }else {
       $valid = false;
       $error_html.= "<h2>{$lang['mustspecifymatchedtext']}</h2>\n";
    }

    if (isset($_POST['add_new_filter_option']) && is_numeric($_POST['add_new_filter_option'])) {
       $add_new_filter_option = $_POST['add_new_filter_option'];
    }else {
       $valid = false;
       $error_html.= "<h2>{$lang['mustspecifyfilteroption']}</h2>\n";
    }

    if (isset($_POST['add_new_replace_text']) && strlen(trim(_stripslashes($_POST['add_new_replace_text'])))) {
       $add_new_replace_text = trim(_stripslashes($_POST['add_new_replace_text']));
    }else {
       $add_new_replace_text = "";
    }

    if ($valid) {

        if ($add_new_filter_option == 2 && preg_match("/e[^\/]*$/i", $add_new_match_text)) {
            $add_new_match_text = preg_replace_callback("/\/[^\/]*$/i", "filter_limit_preg", $add_new_match_text);
        }

        if (user_add_word_filter($add_new_match_text, $add_new_replace_text, $add_new_filter_option)) {

            $redirect = "./edit_wordfilter.php?webtag=$webtag&updated=true";
            header_redirect($redirect, $lang['wordfilterupdated']);
            exit;
        }
    }

}elseif (isset($_POST['editfilter_submit'])) {

    if (isset($_POST['filter_id']) && is_numeric($_POST['filter_id'])) {
       $filter_id = $_POST['filter_id'];
    }else {
       $valid = false;
       $error_html.= "<h2>{$lang['mustspecifyfilterid']}</h2>\n";
    }
    
    if (isset($_POST['match_text']) && strlen(trim(_stripslashes($_POST['match_text'])))) {
       $match_text = trim(_stripslashes($_POST['match_text']));
    }else {
       $valid = false;
       $error_html.= "<h2>{$lang['mustspecifymatchedtext']}</h2>\n";
    }

    if (isset($_POST['filter_option']) && is_numeric($_POST['filter_option'])) {
       $filter_option = $_POST['filter_option'];
    }else {
       $valid = false;
       $error_html.= "<h2>{$lang['mustspecifyfilteroption']}</h2>\n";
    }

    if (isset($_POST['replace_text']) && strlen(trim(_stripslashes($_POST['replace_text'])))) {
       $replace_text = trim(_stripslashes($_POST['replace_text']));
    }else {
       $replace_text = "";
    }

    if ($valid) {

        if ($filter_option == 2 && preg_match("/e[^\/]*$/i", $match_text)) {
            $match_text = preg_replace_callback("/\/[^\/]*$/i", "filter_limit_preg", $match_text);
        }

        if (user_update_word_filter($filter_id, $match_text, $replace_text, $filter_option)) {

            $redirect = "./edit_wordfilter.php?webtag=$webtag&updated=true";
            header_redirect($redirect, $lang['wordfilterupdated']);
            exit;

        }else {

            $error_html.= "<h2>{$lang['failedtoupdatewordfilter']}2</h2>\n";
        }
    }

}elseif (isset($_POST['addfilter'])) {

    $redirect = "./edit_wordfilter.php?webtag=$webtag&addfilter=true";
    header_redirect($redirect);
    exit;
}

if (isset($_GET['addfilter']) || isset($_POST['addfilter'])) {

    echo "<h1>{$lang['editwordfilter']}</h1>\n";

    if (isset($error_html) && strlen($error_html) > 0) echo $error_html;

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "<form name=\"startpage\" method=\"post\" action=\"edit_wordfilter.php\">\n";
    echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
    echo "  ", form_input_hidden('addfilter', 'true'), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"450\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\">{$lang['addnewwordfilter']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">{$lang['matchedtext']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_text("add_new_match_text", (isset($_POST['add_new_match_text']) ? _htmlentities(_stripslashes($_POST['add_new_match_text'])) : ""), 40), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">{$lang['replacementtext']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_text("add_new_replace_text", (isset($_POST['add_new_replace_text']) ? _htmlentities(_stripslashes($_POST['add_new_replace_text'])) : ""), 40), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" valign=\"top\">{$lang['filtertype']}:</td>\n";
    echo "                        <td align=\"left\">\n";
    echo "                          <table class=\"posthead\" width=\"100%\">\n";
    echo "                            <tr>\n";
    echo "                              <td align=\"left\">", form_radio("add_new_filter_option", "0", $lang['all'], (isset($_POST['add_new_filter_option']) && $_POST['add_new_filter_option'] == 0 ? true : false)), "</td>\n";
    echo "                            <tr>\n";
    echo "                            </tr>\n";
    echo "                              <td align=\"left\">", form_radio("add_new_filter_option", "1", $lang['wholeword'], (isset($_POST['add_new_filter_option']) && $_POST['add_new_filter_option'] == 0 ? true : false)), "</td>\n";
    echo "                            <tr>\n";
    echo "                            </tr>\n";
    echo "                              <td align=\"left\">", form_radio("add_new_filter_option", "2", $lang['preg'], (isset($_POST['add_new_filter_option']) && $_POST['add_new_filter_option'] == 0 ? true : false)), "</td>\n";
    echo "                            </tr>\n";
    echo "                          </table>\n";
    echo "                        </td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                      </tr>\n";
    echo "                    </table>\n";
    echo "                  </td>\n";
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
    echo "      <td colspan=\"2\" align=\"center\">", form_submit("addfilter_submit", $lang['add']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  <br />\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"450\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <p>{$lang['word_filter_help_1']}</p>\n";
    echo "        <p>{$lang['word_filter_help_2']}</p>\n";
    echo "        <p>{$lang['word_filter_help_3']}</p>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</div>\n";
    echo "</form>\n";

}elseif (isset($_POST['filter_id']) || isset($_GET['filter_id'])) {

    echo "<h1>{$lang['admin']} &raquo; ", forum_get_setting('forum_name', false, 'A Beehive Forum'), " &raquo; {$lang['wordfilter']} &raquo; {$lang['editwordfilter']}</h1>\n";

    if (isset($_POST['filter_id']) && is_numeric($_POST['filter_id'])) {
        $filter_id = $_POST['filter_id'];
    }elseif (isset($_GET['filter_id']) && is_numeric($_GET['filter_id'])) {
        $filter_id = $_GET['filter_id'];
    }else {
        echo "<h2>{$lang['mustspecifyfilterid']}</h2>\n";
        html_draw_bottom();
        exit;
    }

    if (!$word_filter_array = user_get_word_filter($filter_id)) {

        echo "<h2>{$lang['invalidfilterid']}</h2>\n";
        html_draw_bottom();
        exit;
    }

    if (isset($error_html) && strlen($error_html) > 0) echo $error_html;

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "<form name=\"startpage\" method=\"post\" action=\"edit_wordfilter.php\">\n";
    echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
    echo "  ", form_input_hidden('filter_id', _htmlentities($filter_id)), "\n";
    echo "  ", form_input_hidden("delete_filters[$filter_id]", 'Y'), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"450\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\">{$lang['editwordfilter']}</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">{$lang['matchedtext']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_text("match_text", _htmlentities($word_filter_array['MATCH_TEXT']), 40), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">{$lang['replacementtext']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_text("replace_text", _htmlentities($word_filter_array['REPLACE_TEXT']), 40), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" valign=\"top\">{$lang['filtertype']}:</td>\n";
    echo "                        <td align=\"left\">\n";
    echo "                          <table class=\"posthead\" width=\"100%\">\n";
    echo "                            <tr>\n";
    echo "                              <td align=\"left\">", form_radio("filter_option", "0", $lang['all'], ($word_filter_array['FILTER_OPTION'] == 0)), "</td>\n";
    echo "                            <tr>\n";
    echo "                            </tr>\n";
    echo "                              <td align=\"left\">", form_radio("filter_option", "1", $lang['wholeword'], ($word_filter_array['FILTER_OPTION'] == 1)), "</td>\n";
    echo "                            <tr>\n";
    echo "                            </tr>\n";
    echo "                              <td align=\"left\">", form_radio("filter_option", "2", $lang['preg'], ($word_filter_array['FILTER_OPTION'] == 2)), "</td>\n";
    echo "                            </tr>\n";
    echo "                          </table>\n";
    echo "                        </td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                      </tr>\n";
    echo "                    </table>\n";
    echo "                  </td>\n";
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
    echo "      <td colspan=\"2\" align=\"center\">", form_submit("editfilter_submit", $lang['save']), "&nbsp;", form_submit("delete", $lang['delete']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  <br />\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"450\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <p>{$lang['word_filter_help_1']}</p>\n";
    echo "        <p>{$lang['word_filter_help_2']}</p>\n";
    echo "        <p>{$lang['word_filter_help_3']}</p>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</div>\n";
    echo "</form>\n";

}else {

    echo "<h1>{$lang['editwordfilter']}</h1>\n";

    if (isset($_GET['updated'])) {
        echo "<h2>{$lang['wordfilterupdated']}</h2>\n";
    }

    // User's UID
    $uid = bh_session_get_value('UID');

    // Get User Prefs
    $user_prefs = user_get_prefs($uid);

    echo "<br />\n";
    echo "<form method=\"post\" action=\"edit_wordfilter.php\">\n";
    echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" width=\"20\">&nbsp;</td>\n";
    echo "                  <td align=\"left\" class=\"subhead\" nowrap=\"nowrap\" colspan=\"2\">{$lang['matchedtext']}&nbsp;</td>\n";
    echo "                  <td align=\"left\" class=\"subhead\" nowrap=\"nowrap\" colspan=\"2\">{$lang['replacementtext']}&nbsp;</td>\n";
    echo "                  <td align=\"left\" class=\"subhead\" nowrap=\"nowrap\">{$lang['filtertype']}&nbsp;</td>\n";
    echo "                </tr>\n";

    $start = floor($page - 1) * 10;
    if ($start < 0) $start = 0;

    $word_filter_array = user_get_word_filter_list($start);

    if (sizeof($word_filter_array['word_filter_array']) > 0) {

        foreach ($word_filter_array['word_filter_array'] as $filter_id => $word_filter) {

            echo "                <tr>\n";
            echo "                  <td align=\"center\">", form_checkbox("delete_filters[$filter_id]", "Y", false), "</td>\n";
            echo "                  <td align=\"left\" nowrap=\"nowrap\"><span style=\"overflow: hidden; display:block\"><a href=\"edit_wordfilter.php?webtag$webtag&amp;filter_id=$filter_id\">{$word_filter['MATCH_TEXT']}</a></span></td>\n";
            echo "                  <td align=\"left\" width=\"5\">&nbsp;</td>\n";
            echo "                  <td align=\"left\" nowrap=\"nowrap\"><span style=\"overflow: hidden; display:block\"><a href=\"edit_wordfilter.php?webtag$webtag&amp;filter_id=$filter_id\">{$word_filter['REPLACE_TEXT']}</a></span></td>\n";
            echo "                  <td align=\"left\" width=\"5\">&nbsp;</td>\n";
            echo "                  <td align=\"left\">{$word_filter_options[$word_filter['FILTER_OPTION']]}</td>\n";
            echo "                </tr>\n";
        }

    }else {

        echo "                <tr>\n";
        echo "                  <td align=\"left\">&nbsp;</td>\n";
        echo "                  <td align=\"left\" colspan=\"5\">{$lang['nowordfilterentriesfound']}</td>\n";
        echo "                </tr>\n";
    }

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
    echo "      <td class=\"postbody\" align=\"center\">", page_links(get_request_uri(false), $start, $word_filter_array['word_filter_count'], 10), "</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td colspan=\"2\" align=\"center\">", form_submit("addfilter", $lang['addnew']), "&nbsp;", form_submit("delete", $lang['deleteselected']), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "  <br />\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\">{$lang['options']}</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">", form_checkbox("use_word_filter", "Y", $lang['usewordfilter'], (isset($user_prefs['USE_WORD_FILTER']) && $user_prefs['USE_WORD_FILTER'] == "Y")), "</td>\n";
    echo "                      </tr>\n";

    if (!forum_get_setting('admin_force_word_filter', 'Y')) {

        echo "                      <tr>\n";
        echo "                        <td align=\"left\">", form_checkbox("use_admin_filter", "Y", $lang['includeadminfilter'], (isset($user_prefs['USE_ADMIN_FILTER']) && $user_prefs['USE_ADMIN_FILTER'] == 'Y')), "</td>\n";
        echo "                      </tr>\n";
    }

    echo "                      <tr>\n";
    echo "                        <td align=\"left\">&nbsp;</td>\n";
    echo "                      </tr>\n";
    echo "                    </table>\n";
    echo "                  </td>\n";
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
    echo "      <td align=\"center\">", form_submit("save", $lang['save']), "</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</form>\n";
}

html_draw_bottom();

?>