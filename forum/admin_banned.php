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

/* $Id: admin_banned.php,v 1.21 2006-06-30 18:07:31 decoyduck Exp $ */

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

include_once(BH_INCLUDE_PATH. "admin.inc.php");
include_once(BH_INCLUDE_PATH. "attachments.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "edit.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "ip.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "poll.inc.php");
include_once(BH_INCLUDE_PATH. "post.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=admin.php%3Fpage%3D$request_uri");
}

// Load language file

$lang = load_language_file();

html_draw_top();

$error_html = "";
$valid = true;

// Add or remove IP address from ban list on URI query?

$ban_ipaddress = "";
$unban_ipaddress = "";

if (isset($_GET['ban_ipaddress']) && strlen(trim(_stripslashes($_GET['ban_ipaddress'])))) {

    $ban_ipaddress = trim(_stripslashes($_GET['ban_ipaddress']));

}elseif (isset($_GET['unban_ipaddress']) && strlen(trim(_stripslashes($_GET['unban_ipaddress'])))) {

    $unban_ipaddress = trim(_stripslashes($_GET['unban_ipaddress']));
}

// Are we returning somewhere?

if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {
    $ret = "./messages.php?webtag=$webtag&msg={$_GET['msg']}";
}elseif (isset($_POST['ret'])) {
    $ret = $_POST['ret'];
}

// Return to the page we came from.

if (isset($_POST['back'])) {
    header_redirect($ret);
}

if (isset($_POST['add_ipaddress'])) {

    if (isset($_POST['add_banned_ipaddress']) && strlen(trim(_stripslashes($_POST['add_banned_ipaddress'])))) {

        $add_banned_ipaddress = trim(_stripslashes($_POST['add_banned_ipaddress']));

        if (preg_match("/^%+$/", $add_banned_ipaddress) > 0) {

            $error_html.= "<h2>{$lang['cannotusewildcardonown']}</h2>\n";
            $valid = false;

        }else {

            if (!ip_is_banned($add_banned_ipaddress)) {

                add_ban_data('IPADDRESS', $add_banned_ipaddress);
                admin_add_log_entry(ADD_BANNED_IP, $add_banned_ipaddress);

            }else {

                $error_html.= "<h2>{$lang['ipaddressisalreadybanned']}</h2>\n";
                $valid = false;
            }
        }
    }

}else if (isset($_POST['remove_banned_ipaddress'])) {

    if (isset($_POST['banned_ipaddress']) && is_array($_POST['banned_ipaddress'])) {

        $banned_ipaddress_array = $_POST['banned_ipaddress'];

        foreach($banned_ipaddress_array as $banned_ipaddress) {

            $banned_ipaddress = trim(_stripslashes($banned_ipaddress));
            remove_ban_data('IPADDRESS', $banned_ipaddress);
            admin_add_log_entry(REMOVE_BANNED_IP, $banned_ipaddress);
        }
    }
}

if (isset($_POST['add_logon'])) {

    if (isset($_POST['add_banned_logon']) && strlen(trim(_stripslashes($_POST['add_banned_logon'])))) {

        $add_banned_logon = trim(_stripslashes($_POST['add_banned_logon']));

        if (preg_match("/^%+$/", $add_banned_logon) > 0) {

            $error_html.= "<h2>{$lang['cannotusewildcardonown']}</h2>\n";
            $valid = false;

        }else {

            if (!logon_is_banned($add_banned_logon)) {

                add_ban_data('LOGON', $add_banned_logon);
                admin_add_log_entry(ADD_BANNED_LOGON, $add_banned_logon);

            }else {

                $error_html.= "<h2>{$lang['logonisalreadybanned']}</h2>\n";
                $valid = false;
            }
        }
    }

}else if (isset($_POST['remove_banned_logon'])) {

    if (isset($_POST['banned_logon']) && is_array($_POST['banned_logon'])) {

        $banned_logon_array = $_POST['banned_logon'];

        foreach($banned_logon_array as $banned_logon) {

            $banned_logon = trim(_stripslashes($banned_logon));
            remove_ban_data('LOGON', $banned_logon);
            admin_add_log_entry(REMOVE_BANNED_LOGON, $banned_logon);
        }
    }
}

if (isset($_POST['add_nickname'])) {

    if (isset($_POST['add_banned_nickname']) && strlen(trim(_stripslashes($_POST['add_banned_nickname'])))) {

        $add_banned_nickname = trim(_stripslashes($_POST['add_banned_nickname']));

        if (preg_match("/^%+$/", $add_banned_nickname) > 0) {

            $error_html.= "<h2>{$lang['cannotusewildcardonown']}</h2>\n";
            $valid = false;

        }else {

            if (!nickname_is_banned($add_banned_nickname)) {

                add_ban_data('NICKNAME', $add_banned_nickname);
                admin_add_log_entry(ADD_BANNED_NICKNAME, $add_banned_nickname);

            }else {

                $error_html.= "<h2>{$lang['nicknameisalreadybanned']}</h2>\n";
                $valid = false;
            }
        }
    }

}else if (isset($_POST['remove_banned_nickname'])) {

    if (isset($_POST['banned_nickname']) && is_array($_POST['banned_nickname'])) {

        $banned_nickname_array = $_POST['banned_nickname'];

        foreach($banned_nickname_array as $banned_nickname) {

            $banned_nickname = trim(_stripslashes($banned_nickname));
            remove_ban_data('NICKNAME', $banned_nickname);
            admin_add_log_entry(REMOVE_BANNED_NICKNAME, $banned_nickname);
        }
    }
}

if (isset($_POST['add_email'])) {

    if (isset($_POST['add_banned_email']) && strlen(trim(_stripslashes($_POST['add_banned_email'])))) {

        $add_banned_email = trim(_stripslashes($_POST['add_banned_email']));

        if (preg_match("/^%+$/", $add_banned_email)) {

            $error_html.= "<h2>{$lang['cannotusewildcardonown']}</h2>\n";
            $valid = false;

        }else {

            if (!email_is_banned($add_banned_email)) {

                add_ban_data('EMAIL', $add_banned_email);
                admin_add_log_entry(ADD_BANNED_EMAIL, $add_banned_email);

            }else {

                $error_html.= "<h2>{$lang['emailisalreadybanned']}</h2>\n";
                $valid = false;
            }
        }
    }

}else if (isset($_POST['remove_banned_email'])) {

    if (isset($_POST['banned_email']) && is_array($_POST['banned_email'])) {

        $banned_email_array = $_POST['banned_email'];

        foreach($banned_email_array as $banned_email) {

            $banned_email = trim(_stripslashes($banned_email));
            remove_ban_data('EMAIL', $banned_email);
            admin_add_log_entry(REMOVE_BANNED_EMAIL, $banned_email);
        }
    }
}

echo "<h1>{$lang['admin']} : ", (isset($forum_settings['forum_name']) ? $forum_settings['forum_name'] : 'A Beehive Forum'), " : {$lang['bancontrols']}</h1>\n";

if (!$valid && strlen($error_html) > 0) echo $error_html;

// Get the ban data from the database

$ban_list_array = admin_get_ban_data();

if (sizeof($ban_list_array['IPADDRESS']) < 1) $ban_list_array['IPADDRESS'] = array('' => '(no entries)');
if (sizeof($ban_list_array['LOGON'])     < 1) $ban_list_array['LOGON']     = array('' => '(no entries)');
if (sizeof($ban_list_array['NICKNAME'])  < 1) $ban_list_array['NICKNAME']  = array('' => '(no entries)');
if (sizeof($ban_list_array['EMAIL'])     < 1) $ban_list_array['EMAIL']     = array('' => '(no entries)');

// Submit handling here later, chaps.

echo "<div align=\"center\">\n";
echo "<form name=\"admin_banned_form\" action=\"admin_banned.php\" method=\"post\">\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";

if (isset($ret)) {
    echo "  ", form_input_hidden("ret", $ret), "\n";
}

echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"670\">\n";
echo "    <tr>\n";
echo "      <td colspan=\"2\"><p>{$lang['youcanusethepercentwildcard']}</p></td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td width=\"50%\" align=\"center\">\n";
echo "        <table cellpadding=\"0\" cellspacing=\"0\" width=\"320\">\n";
echo "          <tr>\n";
echo "            <td>\n";
echo "              <table class=\"box\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"posthead\">\n";
echo "                    <table class=\"posthead\" width=\"100%\">\n";
echo "                      <tr>\n";
echo "                        <td class=\"subhead\">{$lang['bannedipaddresses']}</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td>Current banned IP Addresses:</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"center\">\n";
echo "                          <table class=\"posthead\" width=\"95%\">\n";
echo "                            <tr>\n";
echo "                              <td colspan=\"2\">", form_dropdown_array('banned_ipaddress[]', $ban_list_array['IPADDRESS'], $ban_list_array['IPADDRESS'], $unban_ipaddress, "multiple=\"multiple\"", "banned_dropdown"), "</td>\n";
echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td align=\"right\" width=\"250\">", form_submit('remove_banned_ipaddress', $lang['remove']), "</td>\n";
echo "                              <td>&nbsp;</td>\n";
echo "                            </tr>\n";
echo "                          </table>\n";
echo "                        </td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td>Add banned IP Address:</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"center\">\n";
echo "                          <table class=\"posthead\" width=\"95%\">\n";
echo "                            <tr>\n";
echo "                              <td>", form_input_text('add_banned_ipaddress', $ban_ipaddress, 28, 15), "&nbsp;", form_submit("add_ipaddress", $lang['add']), "</td>\n";
echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td>&nbsp;</td>\n";
echo "                            </tr>\n";
echo "                          </table>\n";
echo "                        </td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td>&nbsp;</td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "      <td width=\"50%\" align=\"center\">\n";
echo "        <table cellpadding=\"0\" cellspacing=\"0\" width=\"320\">\n";
echo "          <tr>\n";
echo "            <td>\n";
echo "              <table class=\"box\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"posthead\">\n";
echo "                    <table class=\"posthead\" width=\"100%\">\n";
echo "                      <tr>\n";
echo "                        <td class=\"subhead\">{$lang['bannedlogons']}</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td>Current banned logons:</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"center\">\n";
echo "                          <table class=\"posthead\" width=\"95%\">\n";
echo "                            <tr>\n";
echo "                              <td colspan=\"2\">", form_dropdown_array('banned_logon[]', $ban_list_array['LOGON'], $ban_list_array['LOGON'], false, "multiple=\"multiple\"", "banned_dropdown"), "</td>\n";
echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td align=\"right\" width=\"250\">", form_submit('remove_banned_logon', $lang['remove']), "</td>\n";
echo "                              <td>&nbsp;</td>\n";
echo "                            </tr>\n";
echo "                          </table>\n";
echo "                        </td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td>Add banned logon:</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"center\">\n";
echo "                          <table class=\"posthead\" width=\"95%\">\n";
echo "                            <tr>\n";
echo "                              <td>", form_input_text('add_banned_logon', '', 28, 32), "&nbsp;", form_submit("add_logon", $lang['add']), "</td>\n";
echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td>&nbsp;</td>\n";
echo "                            </tr>\n";
echo "                          </table>\n";
echo "                        </td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td>&nbsp;</td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"670\">\n";
echo "    <tr>\n";
echo "      <td width=\"50%\" align=\"center\">\n";
echo "        <table cellpadding=\"0\" cellspacing=\"0\" width=\"320\">\n";
echo "          <tr>\n";
echo "            <td>\n";
echo "              <table class=\"box\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"posthead\">\n";
echo "                    <table class=\"posthead\" width=\"100%\">\n";
echo "                      <tr>\n";
echo "                        <td class=\"subhead\">{$lang['bannednicknames']}</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td>Current banned nicknames:</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"center\">\n";
echo "                          <table class=\"posthead\" width=\"95%\">\n";
echo "                            <tr>\n";
echo "                              <td colspan=\"2\">", form_dropdown_array('banned_nickname[]', $ban_list_array['NICKNAME'], $ban_list_array['NICKNAME'], false, "multiple=\"multiple\"", "banned_dropdown"), "</td>\n";
echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td align=\"right\" width=\"250\">", form_submit('remove_banned_nickname', $lang['remove']), "</td>\n";
echo "                              <td>&nbsp;</td>\n";
echo "                            </tr>\n";
echo "                          </table>\n";
echo "                        </td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td>Add banned nickname:</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"center\">\n";
echo "                          <table class=\"posthead\" width=\"95%\">\n";
echo "                            <tr>\n";
echo "                              <td>", form_input_text('add_banned_nickname', '', 28, 32), "&nbsp;", form_submit("add_nickname", $lang['add']), "</td>\n";
echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td>&nbsp;</td>\n";
echo "                            </tr>\n";
echo "                          </table>\n";
echo "                        </td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td>&nbsp;</td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "      <td width=\"50%\" align=\"center\">\n";
echo "        <table cellpadding=\"0\" cellspacing=\"0\" width=\"320\">\n";
echo "          <tr>\n";
echo "            <td>\n";
echo "              <table class=\"box\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"posthead\">\n";
echo "                    <table class=\"posthead\" width=\"100%\">\n";
echo "                      <tr>\n";
echo "                        <td class=\"subhead\">{$lang['bannedemailaddresses']}</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td>Current banned Email address:</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"center\">\n";
echo "                          <table class=\"posthead\" width=\"95%\">\n";
echo "                            <tr>\n";
echo "                              <td colspan=\"2\">", form_dropdown_array('banned_email[]', $ban_list_array['EMAIL'], $ban_list_array['EMAIL'], false, "multiple=\"multiple\"", "banned_dropdown"), "</td>\n";
echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td align=\"right\" width=\"250\">", form_submit('remove_banned_email', $lang['remove']), "</td>\n";
echo "                              <td>&nbsp;</td>\n";
echo "                            </tr>\n";
echo "                          </table>\n";
echo "                        </td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td>Add banned Email Address:</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"center\">\n";
echo "                          <table class=\"posthead\" width=\"95%\">\n";
echo "                            <tr>\n";
echo "                              <td>", form_input_text('add_banned_email', '', 28, 80), "&nbsp;", form_submit("add_email", $lang['add']), "</td>\n";
echo "                            </tr>\n";
echo "                            <tr>\n";
echo "                              <td>&nbsp;</td>\n";
echo "                            </tr>\n";
echo "                          </table>\n";
echo "                        </td>\n";
echo "                      </tr>\n";
echo "                    </table>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td>&nbsp;</td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";

if (isset($ret)) {

    echo "    <tr>\n";
    echo "      <td colspan=\"2\" align=\"center\">", form_submit("back", $lang['back']), "</td>\n";
    echo "    </tr>\n";
}

echo "  </table>\n";
echo "</form>\n";
echo "</div>\n";

html_draw_bottom();

?>