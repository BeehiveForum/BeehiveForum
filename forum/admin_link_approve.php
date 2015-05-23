<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
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

// Bootstrap
require_once 'boot.php';

// Required includes
require_once BH_INCLUDE_PATH . 'admin.inc.php';
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'form.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'header.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'links.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
require_once BH_INCLUDE_PATH . 'word_filter.inc.php';
// End Required includes

// Check we're logged in correctly
if (!session::logged_in()) {

    $request_uri = rawurlencode(get_request_uri());
    header_redirect("logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check we have Admin / Moderator access
if (!(session::check_perm(USER_PERM_ADMIN_TOOLS, 0))) {
    html_draw_error(gettext("You do not have permission to use this section."));
}

// Perform additional admin login.
admin_check_credentials();

// Array to hold error messages
$error_msg_array = array();

// Page number
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $page = ($_GET['page'] > 0) ? $_GET['page'] : 1;
} else {
    $page = 1;
}

// Are we returning somewhere?
if (isset($_GET['ret']) && strlen(trim($_GET['ret'])) > 0) {
    $ret = href_cleanup_query_keys($_GET['ret']);
} else if (isset($_POST['ret']) && strlen(trim($_POST['ret'])) > 0) {
    $ret = href_cleanup_query_keys($_POST['ret']);
} else {
    $ret = "admin_link_approve.php?webtag=$webtag";
}

// validate the return to page
if (isset($ret) && strlen(trim($ret)) > 0) {

    $available_files = array(
        'admin_link_approve.php',
        'links_detail.php',
        'links.php'
    );

    $available_files_preg = implode("|^", array_map('preg_quote_callback', $available_files));

    if (!preg_match("/^$available_files_preg/u", $ret)) {
        $ret = "admin_link_approve.php?webtag=$webtag";
    }
}

if (isset($_POST['cancel'])) {
    header_redirect($ret);
}

// Check POST and GET for message ID and check it is valid.
if (isset($_POST['lid'])) {

    if (is_numeric($_POST['lid'])) {

        $lid = $_POST['lid'];

    } else {

        html_draw_error(gettext("Invalid link id or link not found"), 'admin_link_approve.php', 'post', array('cancel' => gettext("Cancel")), array('ret' => $ret), '_self', 'center');
    }

} else if (isset($_GET['lid'])) {

    if (is_numeric($_GET['lid'])) {

        $lid = $_GET['lid'];

    } else {

        html_draw_error(gettext("Invalid link id or link not found"), 'admin_link_approve.php', 'post', array('cancel' => gettext("Cancel")), array('ret' => $ret), '_self', 'center');
    }
}

if (isset($lid) && is_numeric($lid)) {

    if (!session::check_perm(USER_PERM_LINKS_MODERATE, 0)) {
        html_draw_error(gettext("Cannot edit links"), 'admin_link_approve.php', 'post', array('cancel' => gettext("Cancel")), array('ret' => $ret), '_self', 'center');
    }

    if (!($link = links_get_single($lid, false))) {
        html_draw_error(gettext("Invalid link ID!"), 'admin_link_approve.php', 'post', array('cancel' => gettext("Cancel")), array('ret' => $ret), '_self', 'center');
    }

    if (isset($link['APPROVED']) && ($link['APPROVED'] > 0)) {
        html_draw_error(gettext("Link does not require approval"), 'admin_link_approve.php', 'post', array('cancel' => gettext("Cancel")), array('ret' => $ret), '_self', 'center');
    }

    if (isset($_POST['approve'])) {

        if (links_approve($lid)) {

            admin_add_log_entry(APPROVED_LINK, array($lid));

            if (preg_match("/^links_detail.php/u", $ret) > 0) {

                header_redirect("links_detail.php?webtag=$webtag&lid=$lid&link_approve_success=$lid");
                exit;

            } else {

                header_redirect("admin_link_approve.php?webtag=$webtag&link_approve_success=$lid");
                exit;
            }

        } else {

            $error_msg_array[] = gettext("Link approval failed");
        }

    } else if (isset($_POST['delete'])) {

        if (links_delete($lid)) {

            if (session::check_perm(USER_PERM_FOLDER_MODERATE, 0) && ($link['UID'] != $_SESSION['UID'])) {
                admin_add_log_entry(DELETE_LINK, array($lid));
            }

            if (preg_match("/^links_detail.php/u", $ret) > 0) {

                header_redirect("links_detail.php?webtag=$webtag&lid=$lid&link_approve_success=$lid");
                exit;

            } else {

                header_redirect("admin_link_approve.php?webtag=$webtag&link_approve_success=$lid");
                exit;
            }

        } else {

            $error_msg_array[] = gettext("Error deleting link");
        }
    }
}

if (isset($_POST['approve_links'])) {

    if (isset($_POST['process']) && is_array($_POST['process'])) {
        $process_links = array_filter($_POST['process'], 'is_numeric');
    } else {
        $process_links = array();
    }

    if (sizeof($process_links) > 0) {

        if (isset($_POST['approve_confirm']) && $_POST['approve_confirm'] == 'Y') {

            $valid = true;

            foreach ($process_links as $approve_lid) {

                $process_valid = true;

                if ($process_valid && !session::check_perm(USER_PERM_LINKS_MODERATE, 0)) {
                    $process_valid = false;
                }

                if ($process_valid && !($link = links_get_single($approve_lid, false))) {
                    $process_valid = false;
                }

                if ($process_valid && isset($link['APPROVED']) && ($link['APPROVED'] > 0)) {
                    $process_valid = false;
                }

                if ($process_valid && links_approve($approve_lid)) {
                    admin_add_log_entry(APPROVED_LINK, array($approve_lid));
                } else {
                    $valid = false;
                }
            }

            if ($valid) {

                header_redirect("admin_link_approve.php?webtag=$webtag&page=$page&approve_success=true");
                exit;

            } else {

                $error_msg_array[] = gettext("Failed to approve some links");
            }

        } else {

            html_draw_top(
                array(
                    'title' => gettext('Approve Links'),
                    'class' => 'window_title'
                )
            );

            html_display_msg(gettext("Approve"), gettext("Are you sure you want to approve all of the selected links?"), "admin_link_approve.php", 'post', array(
                'approve_links' => gettext("Yes"),
                'back' => gettext("No")
            ), array(
                'page' => $page,
                'process' => $process_links,
                'approve_confirm' => 'Y'
            ), '_self', 'center');

            html_draw_bottom();
            exit;
        }

    } else {

        $error_msg_array[] = gettext("You must select some links to approve");
        $valid = false;
    }

} else if (isset($_POST['delete_links'])) {

    if (isset($_POST['process']) && is_array($_POST['process'])) {
        $process_links = array_filter($_POST['process'], 'is_numeric');
    } else {
        $process_links = array();
    }

    if (sizeof($process_links) > 0) {

        if (isset($_POST['delete_confirm']) && $_POST['delete_confirm'] == 'Y') {

            $valid = true;

            foreach ($process_links as $delete_lid) {

                $process_valid = true;

                if ($process_valid && !session::check_perm(USER_PERM_LINKS_MODERATE, 0)) {
                    $process_valid = false;
                }

                if ($process_valid && !($link = links_get_single($delete_lid, false))) {
                    $process_valid = false;
                }

                if ($process_valid && isset($link['DELETED']) && ($link['DELETED'] > 0)) {
                    $process_valid = false;
                }

                if ($process_valid && links_delete($delete_lid)) {
                    admin_add_log_entry(DELETE_LINK, array($delete_lid));
                } else {
                    $valid = false;
                }
            }

            if ($valid) {

                header_redirect("admin_link_approve.php?webtag=$webtag&page=$page&delete_success=true");
                exit;

            } else {

                $error_msg_array[] = gettext("Failed to delete some links");
            }

        } else {

            html_draw_top(
                array(
                    'title' => gettext('Delete Links'),
                    'class' => 'window_title'
                )
            );

            html_display_msg(gettext("Delete"), gettext("Are you sure you want to delete all of the selected links?"), "admin_link_approve.php", 'post', array(
                'delete_links' => gettext("Yes"),
                'back' => gettext("No")
            ), array(
                'page' => $page,
                'process' => $process_links,
                'delete_confirm' => 'Y'
            ), '_self', 'center');

            html_draw_bottom();
            exit;
        }

    } else {

        $error_msg_array[] = gettext("You must select some links to delete");
        $valid = false;
    }
}

html_draw_top(
    array(
        'title' => gettext('Admin - Link Approval Queue'),
        'class' => 'window_title',
        'main_css' => 'admin.css'
    )
);

$link_approval_array = admin_get_link_approval_queue($page);

echo "<h1>", gettext("Admin"), html_style_image('separator'), gettext("Link Approval Queue"), "</h1>\n";

if (isset($_GET['link_approve_success']) && is_numeric($_GET['link_approve_success'])) {

    html_display_success_msg(sprintf(gettext("Successfully approved link %s"), $_GET['link_approve_success']), '86%', 'center');

} else if (isset($_GET['delete_success']) && is_numeric($_GET['delete_success'])) {

    html_display_success_msg(sprintf(gettext("Successfully deleted link %s"), $_GET['delete_success']), '86%', 'center');

} else if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '86%', 'center');

} else if (sizeof($link_approval_array['link_array']) < 1) {

    html_display_warning_msg(gettext("No links are awaiting approval"), '86%', 'center');
}

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form accept-charset=\"utf-8\" name=\"f_delete\" action=\"admin_link_approve.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_csrf_token_field(), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"86%\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\" colspan=\"3\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                 <tr>\n";

if (isset($link_approval_array['link_array']) && sizeof($link_approval_array['link_array']) > 0) {
    echo "                  <td class=\"subhead_checkbox\" align=\"center\" width=\"20\">", form_checkbox("toggle_all", "toggle_all"), "</td>\n";
} else {
    echo "                  <td align=\"left\" class=\"subhead\" width=\"20\">&nbsp;</td>\n";
}

echo "                   <td class=\"subhead\" align=\"left\">", gettext("Name"), "</td>\n";
echo "                   <td class=\"subhead\" align=\"left\">", gettext("Folder"), "</td>\n";
echo "                   <td class=\"subhead\" align=\"left\" width=\"200\">", gettext("User"), "</td>\n";
echo "                   <td class=\"subhead\" align=\"left\" width=\"200\">", gettext("Date/Time"), "</td>\n";
echo "                 </tr>\n";

if (sizeof($link_approval_array['link_array']) > 0) {

    foreach ($link_approval_array['link_array'] as $link_approval_entry) {

        echo "                 <tr>\n";
        echo "                   <td align=\"left\" width=\"20\">", form_checkbox("process[]", $link_approval_entry['LID']), "</td>\n";
        echo "                   <td align=\"left\"><a href=\"admin_link_approve.php?webtag=$webtag&lid={$link_approval_entry['LID']}\" target=\"_self\">", word_filter_add_ob_tags($link_approval_entry['TITLE'], true), "</a></td>\n";
        echo "                   <td align=\"left\">{$link_approval_entry['FOLDER_TITLE']}</td>\n";
        echo "                   <td align=\"left\"><a href=\"user_profile.php?webtag=$webtag&amp;uid={$link_approval_entry['UID']}\" target=\"_blank\" class=\"popup 650x500\">", word_filter_add_ob_tags(format_user_name($link_approval_entry['LOGON'], $link_approval_entry['NICKNAME']), true) . "</a></td>\n";
        echo "                   <td align=\"left\">", format_date_time($link_approval_entry['CREATED']), "</td>\n";
        echo "                 </tr>\n";
    }
}

echo "                 <tr>\n";
echo "                   <td align=\"left\" colspan=\"3\">&nbsp;</td>\n";
echo "                 </tr>\n";
echo "               </table>\n";
echo "             </td>\n";
echo "           </tr>\n";
echo "         </table>\n";
echo "       </td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\" width=\"33%\">&nbsp;</td>\n";
echo "      <td class=\"postbody\" align=\"center\" width=\"33%\">";

html_page_links("admin_link_approve.php?webtag=$webtag&ret=$ret", $page, $link_approval_array['link_count'], 10);

echo "      </td>\n";

if (isset($link_approval_array['link_array']) && sizeof($link_approval_array['link_array']) > 0) {

    echo "<td align=\"right\" width=\"33%\" valign=\"top\" style=\"white-space: nowrap\">";
    echo form_submit('approve_links', gettext("Approve"), sprintf('title="%s"', gettext("Approve Selected Links"))), "&nbsp;";
    echo form_submit('delete_links', gettext("Delete"), sprintf('title="%s"', gettext("Delete Selected Links"))), "&nbsp;";
    echo "</span></td>\n";

} else {

    echo "      <td align=\"left\">&nbsp;</td>\n";
}

echo "    </tr>\n";
echo "    <tr>\n";
echo "      <td align=\"left\">&nbsp;</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";

if (isset($lid, $link)) {

    echo "<br />\n";
    echo "<form accept-charset=\"utf-8\" name=\"f_delete\" action=\"admin_link_approve.php\" method=\"post\" target=\"_self\">\n";
    echo "  ", form_csrf_token_field(), "\n";
    echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
    echo "  ", form_input_hidden('lid', htmlentities_array($lid)), "\n";
    echo "  ", form_input_hidden("ret", htmlentities_array($ret)), "\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"86%\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">", gettext("Link Details"), "</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" style=\"white-space: nowrap\" valign=\"top\" width=\"120\">", gettext("Address"), ":</td>\n";
    echo "                        <td align=\"left\"><a href=\"links.php?webtag=$webtag&amp;lid=$lid&amp;action=go\" target=\"_blank\">", mb_strlen($link['URI']) > 35 ? htmlentities_array(mb_substr($link['URI'], 0, 35)) . '&hellip;' : htmlentities_array($link['URI']), "</a></td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" style=\"white-space: nowrap\" valign=\"top\">", gettext("Submitted by"), ":</td>\n";
    echo "                        <td align=\"left\">", (isset($link['LOGON']) ? word_filter_add_ob_tags(format_user_name($link['LOGON'], $link['NICKNAME']), true) : gettext("Unknown user")), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" style=\"white-space: nowrap\" valign=\"top\">", gettext("Description"), ":</td>\n";
    echo "                        <td align=\"left\">", word_filter_add_ob_tags($link['DESCRIPTION'], true), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" style=\"white-space: nowrap\" valign=\"top\">", gettext("Date"), ":</td>\n";
    echo "                        <td align=\"left\">", format_date_time($link['CREATED']), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\" colspan=\"3\">&nbsp;</td>\n";
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
    echo "      <td align=\"center\">", form_submit("approve", gettext("Approve")), "&nbsp;", form_submit("delete", gettext("Delete")), "&nbsp;", form_submit("cancel", gettext("Cancel")), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</form>\n";
}

echo "</div>\n";

html_draw_bottom();
