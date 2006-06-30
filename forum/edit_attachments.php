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

/* $Id: edit_attachments.php,v 1.98 2006-06-30 18:07:32 decoyduck Exp $ */

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

include_once(BH_INCLUDE_PATH. "attachments.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
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
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// If attachments are disabled then no need to go any further.

if (forum_get_setting('attachments_enabled', 'N')) {
    html_draw_top();
    echo "<h1>{$lang['attachmentshavebeendisabled']}</h1>\n";
    html_draw_bottom();
    exit;
}

// If the attachments directory is undefined we can't go any further

if (!$attachment_dir = attachments_check_dir()) {
    html_draw_top();
    echo "<h1>{$lang['attachmentshavebeendisabled']}</h1>\n";
    html_draw_bottom();
    exit;
}

if (bh_session_get_value('UID') == 0) {
    html_guest_error();
    exit;
}

html_draw_top("post.js");

// Get any UID from the GET or POST request
// or default to the current user if not specified.

if (isset($_GET['uid']) && is_numeric($_GET['uid'])) {

    $uid = $_GET['uid'];

}elseif (isset($_POST['uid']) && is_numeric($_POST['uid'])) {

    $uid = $_POST['uid'];

}else {

    $uid = bh_session_get_value('UID');
}

// Get any AID from the GET or POST request

if (isset($_GET['aid']) && is_md5($_GET['aid'])) {

    $aid = $_GET['aid'];

    if (!$t_fid = get_folder_fid($aid)) {
        $t_fid = 0;
    }

}elseif (isset($_POST['aid']) && is_md5($_POST['aid'])) {

    $aid = $_POST['aid'];

    if (!$t_fid = get_folder_fid($aid)) {
        $t_fid = 0;
    }

}else {

    $aid = "";
    $t_fid = 0;
}

// Check that the UID we have belongs to the current user
// or that it is an admin if we're viewing another user's
// attachments.

if (($uid != bh_session_get_value('UID')) && !(bh_session_check_perm(USER_PERM_FOLDER_MODERATE, $t_fid))) {

    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;
}

$users_free_space = get_free_attachment_space($uid);
$total_attachment_size = 0;

// Make sure the attachments directory exists

if (@!is_dir('attachments')) {

    mkdir('attachments', 0755);
    chmod('attachments', 0777);
}

if (isset($_POST['delete'])) {

    list($hash) = array_keys($_POST['delete']);
    delete_attachment($hash);

}elseif (isset($_POST['close'])) {

    echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
    echo "  window.close();\n";
    echo "</script>\n";

    html_draw_bottom();
    exit;
}

if (isset($_GET['popup']) && is_numeric($_GET['popup'])) {

    $popup = $_GET['popup'];

}elseif (isset($_POST['popup']) && is_numeric($_POST['popup'])) {

    $popup = $_POST['popup'];

}else {

    $popup = "";
}

echo "<h1>{$lang['attachments']}</h1>\n";
echo "<br />\n";
echo "<form method=\"post\" action=\"edit_attachments.php\">\n";
echo "  ", form_input_hidden('popup', $popup), "\n";
echo "  ". form_input_hidden('aid', $aid), "\n";
echo "  ". form_input_hidden('uid', $uid), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";

if (is_md5($aid)) {

    echo "                <tr>\n";
    echo "                  <td colspan=\"4\" class=\"subhead\">{$lang['attachmentsforthismessage']}</td>\n";
    echo "                </tr>\n";

    $attachment_result = get_attachments($uid, $aid, $attachments_array, $image_attachments_array);

}else {

    echo "                <tr>\n";
    echo "                  <td colspan=\"4\" class=\"subhead\">{$lang['attachments']}</td>\n";
    echo "                </tr>\n";

    $attachment_result = get_users_attachments($uid, $attachments_array, $image_attachments_array);
}

echo "              </table>\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";

if ($attachment_result) {

    if (is_array($attachments_array) && sizeof($attachments_array) > 0) {

        foreach ($attachments_array as $key => $attachment) {

            if ($attachment_link = attachment_make_link($attachment, false, true)) {

                echo "                      <tr>\n";
                echo "                        <td valign=\"top\" nowrap=\"nowrap\" class=\"postbody\">$attachment_link</td>\n";

                if (is_md5($aid) && is_md5($attachment['aid']) && $message_link = get_message_link($attachment['aid'])) {

                    echo "                        <td valign=\"top\" nowrap=\"nowrap\" class=\"postbody\"><a href=\"$message_link\" target=\"_blank\">{$lang['viewmessage']}</a></td>\n";

                }else {

                    echo "                        <td>&nbsp;</td>\n";
                }

                echo "                        <td align=\"right\" valign=\"top\" nowrap=\"nowrap\" class=\"postbody\">", format_file_size($attachment['filesize']), "</td>\n";
                echo "                        <td align=\"right\" nowrap=\"nowrap\" class=\"postbody\">\n";
                echo "                          ", form_submit("delete[{$attachment['hash']}]", $lang['del']), "\n";
                echo "                        </td>\n";
                echo "                      </tr>\n";

                $total_attachment_size += $attachment['filesize'];
            }
        }
    }

    if (is_array($image_attachments_array) && sizeof($image_attachments_array) > 0) {

        foreach ($image_attachments_array as $key => $attachment) {

            if ($attachment_link = attachment_make_link($attachment, false, true)) {

                echo "                      <tr>\n";
                echo "                        <td valign=\"top\" nowrap=\"nowrap\" class=\"postbody\">$attachment_link</td>\n";

                if (is_md5($aid) && is_md5($attachment['aid']) && $message_link = get_message_link($attachment['aid'])) {

                    echo "                        <td valign=\"top\" nowrap=\"nowrap\" class=\"postbody\"><a href=\"$message_link\" target=\"_blank\">{$lang['viewmessage']}</a></td>\n";

                }else {

                    echo "                        <td>&nbsp;</td>\n";
                }

                echo "                        <td align=\"right\" valign=\"top\" nowrap=\"nowrap\" class=\"postbody\">", format_file_size($attachment['filesize']), "</td>\n";
                echo "                        <td align=\"right\" nowrap=\"nowrap\" class=\"postbody\">\n";
                echo "                          ", form_submit("delete[{$attachment['hash']}]", $lang['del']), "\n";
                echo "                        </td>\n";
                echo "                      </tr>\n";

                $total_attachment_size += $attachment['filesize'];
            }
        }
    }

}else {

    echo "                      <tr>\n";
    echo "                        <td valign=\"top\" colspan=\"4\" class=\"postbody\">({$lang['none']})</td>\n";
    echo "                      </tr>\n";
}

echo "                      <tr>\n";
echo "                        <td colspan=\"4\">&nbsp;</td>\n";
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
echo "  </table>\n";
echo "  <br />\n";

if ($uid == bh_session_get_value('UID') && is_md5($aid)) {

    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
    echo "    <tr>\n";
    echo "      <td>\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td colspan=\"4\" class=\"subhead\">{$lang['otherattachmentsincludingpm']}</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";

    if (get_all_attachments(bh_session_get_value('UID'), $aid, $attachments_array, $image_attachments_array)) {

        if (is_array($attachments_array) && sizeof($attachments_array) > 0) {

            foreach ($attachments_array as $key => $attachment) {

                if ($attachment_link = attachment_make_link($attachment, false)) {

                    echo "                      <tr>\n";
                    echo "                        <td valign=\"top\" nowrap=\"nowrap\" class=\"postbody\">$attachment_link</td>\n";

                    if (is_md5($attachment['aid']) && $message_link = get_message_link($attachment['aid'])) {

                        echo "                        <td valign=\"top\" nowrap=\"nowrap\" class=\"postbody\"><a href=\"$message_link\" target=\"_blank\">{$lang['viewmessage']}</a></td>\n";

                    }else {

                        echo "                        <td>&nbsp;</td>\n";
                    }

                    echo "                        <td align=\"right\" valign=\"top\" nowrap=\"nowrap\" class=\"postbody\">", format_file_size($attachment['filesize']), "</td>\n";
                    echo "                        <td align=\"right\" nowrap=\"nowrap\" class=\"postbody\">\n";
                    echo "                          ", form_submit("delete[{$attachment['hash']}]", $lang['del']), "\n";
                    echo "                        </td>\n";
                    echo "                      </tr>\n";

                    $total_attachment_size += $attachment['filesize'];
                }
            }
        }

        if (is_array($image_attachments_array) && sizeof($image_attachments_array) > 0) {

            foreach ($image_attachments_array as $key => $attachment) {

                if ($attachment_link = attachment_make_link($attachment, false)) {

                    echo "                      <tr>\n";
                    echo "                        <td valign=\"top\" nowrap=\"nowrap\" class=\"postbody\">$attachment_link</td>\n";

                    if (is_md5($attachment['aid']) && $message_link = get_message_link($attachment['aid'])) {

                        echo "                        <td valign=\"top\" nowrap=\"nowrap\" class=\"postbody\"><a href=\"$message_link\" target=\"_blank\">{$lang['viewmessage']}</a></td>\n";

                    }else {

                        echo "                        <td>&nbsp;</td>\n";
                    }

                    echo "                        <td align=\"right\" valign=\"top\" nowrap=\"nowrap\" class=\"postbody\">", format_file_size($attachment['filesize']), "</td>\n";
                    echo "                        <td align=\"right\" nowrap=\"nowrap\" class=\"postbody\">\n";
                    echo "                          ", form_submit("delete[{$attachment['hash']}]", $lang['del']), "\n";
                    echo "                        </td>\n";
                    echo "                      </tr>\n";

                    $total_attachment_size += $attachment['filesize'];
                }
            }
        }

    }else {

        echo "                      <tr>\n";
        echo "                        <td valign=\"top\" colspan=\"4\" class=\"postbody\">({$lang['none']})</td>\n";
        echo "                      </tr>\n";
    }

    echo "                      <tr>\n";
    echo "                        <td colspan=\"4\">&nbsp;</td>\n";
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
    echo "  </table>\n";
    echo "  <br />\n";
}

echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td colspan=\"5\" class=\"subhead\">{$lang['usage']}</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td valign=\"top\" class=\"postbody\">{$lang['totalsize']}:</td>\n";
echo "                        <td valign=\"top\" class=\"postbody\">&nbsp;</td>\n";
echo "                        <td align=\"right\" valign=\"top\" class=\"postbody\">", format_file_size($total_attachment_size), "</td>\n";
echo "                        <td class=\"postbody\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td valign=\"top\" class=\"postbody\">{$lang['freespace']}:</td>\n";
echo "                        <td valign=\"top\" class=\"postbody\">&nbsp;</td>\n";
echo "                        <td align=\"right\" valign=\"top\" class=\"postbody\">", format_file_size(get_free_attachment_space($uid)), "</td>\n";
echo "                        <td class=\"postbody\">&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td colspan=\"5\">&nbsp;</td>\n";
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
echo "      <td>&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"center\">\n";

if (forum_get_setting('attachments_enabled', 'Y') && ($uid == bh_session_get_value('UID'))) {

    if (!is_md5($aid)) $aid = md5(uniqid(rand()));
    echo "        ", form_button("attachments", $lang['uploadnewattachment'], "tabindex=\"5\" onclick=\"launchAttachWin('{$aid}', '$webtag')\""), "&nbsp;";
}

if ($popup) {
    echo "        ", form_submit('close', $lang['close']), "&nbsp;\n";
}

echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";

html_draw_bottom();

?>