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

require_once('./include/db.inc.php');
require_once('./include/forum.inc.php');
require_once('./include/header.inc.php');
require_once('./include/html.inc.php');
require_once('./include/form.inc.php');
require_once('./include/format.inc.php');
require_once('./include/constants.inc.php');

function pm_markasread($mid)
{
    $db_pm_markasread = db_connect();
    $uid = bh_session_get_value('UID');

    // ------------------------------------------------------------
    // Update the row so it appears as read to the receipient
    // ------------------------------------------------------------

    $sql = "UPDATE ". forum_table("PM"). " SET TYPE = ". PM_READ. " WHERE MID = $mid AND TO_UID = $uid";
    $result = db_query($sql, $db_pm_markasread);

}

function pm_add_sentitem($mid)
{
    $db_pm_add_sentitem = db_connect();
    $uid = bh_session_get_value('UID');

    $sql = "SELECT PM.FROM_UID, PM.TO_UID, PM.SUBJECT, PM.CREATED, PM_CONTENT.CONTENT ";
    $sql.= "FROM ". forum_table("PM"). " PM ";
    $sql.= "LEFT JOIN ". forum_table("PM_CONTENT"). " PM_CONTENT ON ";
    $sql.= "(PM_CONTENT.MID = PM.MID) ";
    $sql.= "WHERE PM.MID = $mid";

    $result = db_query($sql, $db_pm_add_sentitem);
    $db_pm_add_sentitem_row = db_fetch_array($result);

    // ------------------------------------------------------------
    // Insert the original PM data as a new row to appear in the
    // sender's sent items
    // ------------------------------------------------------------

    $sql = "INSERT INTO ". forum_table("PM"). " (TYPE, FROM_UID, TO_UID, SUBJECT, CREATED) ";
    $sql.= "VALUES (". PM_SENT. ", {$db_pm_add_sentitem_row['FROM_UID']}, ";
    $sql.= "{$db_pm_add_sentitem_row['TO_UID']}, '{$db_pm_add_sentitem_row['SUBJECT']}', ";
    $sql.= "'{$db_pm_add_sentitem_row['CREATED']}')";

    $result  = db_query($sql, $db_pm_add_sentitem);
    $new_mid = db_insert_id($db_pm_add_sentitem);

    // ------------------------------------------------------------
    // Insert the original PM content as a new row to appear in
    // the sender's sent items
    // ------------------------------------------------------------

    $sql = "INSERT INTO ". forum_table("PM_CONTENT"). " (MID, CONTENT) ";
    $sql.= "VALUES ($new_mid, '{$db_pm_add_sentitem_row['CONTENT']}')";

    $result = db_query($sql, $db_pm_add_sentitem);
}

function pm_list_get($folder)
{
    $pms = array();

    $db_pm_list_get = db_connect();
    $uid = bh_session_get_value('UID');

    // ------------------------------------------------------------
    // Get a list of messages in the specified folder
    // ------------------------------------------------------------

    $sql = "SELECT PM.MID, PM.TYPE, PM.FROM_UID, PM.TO_UID, PM.SUBJECT, ";
    $sql.= "UNIX_TIMESTAMP(PM.CREATED) AS CREATED, ";
    $sql.= "FUSER.LOGON AS FLOGON, FUSER.NICKNAME AS FNICK, ";
    $sql.= "TUSER.LOGON AS TLOGON, TUSER.NICKNAME AS TNICK ";
    $sql.= "FROM ". forum_table("PM"). " PM ";
    $sql.= "LEFT JOIN " . forum_table("USER"). " FUSER ON (PM.FROM_UID = FUSER.UID) ";
    $sql.= "LEFT JOIN " . forum_table("USER"). " TUSER ON (PM.TO_UID = TUSER.UID) WHERE ";

    if (($folder == PM_FOLDER_INBOX)) {
        $sql.= "PM.TYPE = PM.TYPE & $folder AND PM.TO_UID = $uid ";
    }elseif (($folder == PM_FOLDER_SENT) || ($folder == PM_FOLDER_OUTBOX)) {
        $sql.= "PM.TYPE = PM.TYPE & $folder AND PM.FROM_UID = $uid ";
    }elseif ($folder == PM_FOLDER_SAVED) {
        $sql.= "(PM.TYPE = ". PM_SAVED_OUT. " AND PM.FROM_UID = $uid) OR ";
        $sql.= "(PM.TYPE = ". PM_SAVED_IN. " AND PM.TO_UID = $uid)";
    }

    $sql.= "ORDER BY CREATED DESC";
    $result = db_query($sql, $db_pm_list_get);

    while ($row = db_fetch_array($result)) {
        $pms[] = $row;
    }

    return $pms;
}

function pm_get_user($mid)
{
    $db_pm_get_user = db_connect();

    $sql = "SELECT FROM_UID FROM " . forum_table("PM") . " WHERE MID = $mid";
    $result = db_query($sql, $db_pm_get_user);

    if ($result) {
        $fa = db_fetch_array($result);
        $uid = $fa['FROM_UID'];
    } else {
        $uid = "";
    }

    return $uid;
}

function pm_draw_to_dropdown($default_uid)
{
    $html = "<select name=\"t_to_uid\">\n";

    $db_post_draw_to_dropdown = db_connect();

    if(isset($default_uid) && $default_uid != 0) {
        $top_sql = "select LOGON, NICKNAME from ". forum_table("USER"). " where UID = '" . $default_uid . "'";
        $result = db_query($top_sql,$db_post_draw_to_dropdown);
        if(db_num_rows($result)>0){
            $top_user = db_fetch_array($result);
            $fmt_username = format_user_name($top_user['LOGON'],$top_user['NICKNAME']);
            $html .= "<option value=\"$default_uid\" selected=\"selected\">$fmt_username</option>\n";
        }
    }

    $sql = "select U.UID, U.LOGON, U.NICKNAME, UNIX_TIMESTAMP(U.LAST_LOGON) as LAST_LOGON ";
    $sql.= "from ".forum_table("USER")." U where U.UID > 0 ";
    $sql.= "order by U.LAST_LOGON desc ";
    $sql.= "limit 0, 20";

    $result = db_query($sql, $db_post_draw_to_dropdown);

    while($row = db_fetch_array($result)){
        if(isset($row['LOGON'])){
           $logon = $row['LOGON'];
        } else {
         $logon = "";
        }
        if(isset($row['NICKNAME'])){
            $nickname = $row['NICKNAME'];
        } else {
            $nickname = "";
        }

        $fmt_uid = $row['UID'];
        $fmt_username = format_user_name($logon,$nickname);

        if($fmt_uid != $default_uid && $fmt_uid != 0 && $fmt_username != "Guest"){
            $html .= "<option value=\"$fmt_uid\">$fmt_username</option>\n";
        }
        //$html .= ">$fmt_username</option>\n";
    }

    $html .= "</select>\n";
    return $html;
}

function pm_single_get($mid, $folder, $uid = false)
{
    $db_pm_list_get = db_connect();
    if (!$uid) $uid = bh_session_get_value('UID');

    // ------------------------------------------------------------
    // Fetch the single message as specified by the MID
    // ------------------------------------------------------------

    $sql = "SELECT PM.TYPE, PM.FROM_UID, PM.SUBJECT, UNIX_TIMESTAMP(PM.CREATED) AS CREATED, ";
    $sql.= "USER.LOGON, USER.NICKNAME, PM_CONTENT.CONTENT ";
    $sql.= "FROM ". forum_table("PM"). " PM ";
    $sql.= "LEFT JOIN ". forum_table("USER"). " USER ON (USER.UID = PM.FROM_UID) ";
    $sql.= "LEFT JOIN ". forum_table("PM_CONTENT"). " PM_CONTENT ON (PM_CONTENT.MID = PM.MID) ";
    $sql.= "WHERE PM.MID = $mid AND ";

    if (($folder == PM_FOLDER_INBOX)) {
        $sql.= "PM.TYPE = PM.TYPE & $folder AND PM.TO_UID = $uid ";
    }elseif (($folder == PM_FOLDER_SENT) || ($folder == PM_FOLDER_OUTBOX)) {
        $sql.= "PM.TYPE = PM.TYPE & $folder AND PM.FROM_UID = $uid ";
    }elseif ($folder == PM_FOLDER_SAVED) {
        $sql.= "(PM.TYPE = ". PM_SAVED_OUT. " AND PM.FROM_UID = $uid) OR ";
        $sql.= "(PM.TYPE = ". PM_SAVED_IN. " AND PM.TO_UID = $uid) ";
    }

    $result = db_query($sql, $db_pm_list_get);

    if (db_num_rows($result) > 0) {

        $db_pm_list_get_row = db_fetch_array($result);

        // ------------------------------------------------------------
        // Check to see if we should add a sent item before delete
        // ------------------------------------------------------------

        if (($db_pm_list_get_row['TYPE'] == PM_NEW) || ($db_pm_list_get_row['TYPE'] == PM_UNREAD)) {
            pm_markasread($mid);
            pm_add_sentitem($mid);
        }

        return $db_pm_list_get_row;

    }else {
        return false;
    }

}

function draw_pm_message($pm_elements_array, $replyto = false)
{
    global $lang;

    echo "<div align=\"center\">\n";
    echo "  <table width=\"90%\" class=\"box\" cellspacing=\"0\" cellpadding=\"0\">\n";
    echo "    <tr>\n";
    echo "      <td>\n";
    echo "        <table width=\"100%\" class=\"posthead\" cellspacing=\"1\" cellpadding=\"0\">\n";
    echo "          <tr>\n";
    echo "            <td width=\"1%\" align=\"right\" nowrap=\"nowrap\"><span class=\"posttofromlabel\">&nbsp;{$lang['from']}&nbsp;</span></td>\n";
    echo "            <td nowrap=\"nowrap\" width=\"98%\" align=\"left\"><span class=\"posttofrom\">\n";
    echo "<a href=\"javascript:void(0);\" onclick=\"openProfile(" . $pm_elements_array['FROM_UID'] . ")\" target=\"_self\">\n";
    echo format_user_name($pm_elements_array['LOGON'], $pm_elements_array['NICKNAME']), "</a>\n";
    echo "</span></td>\n";
    echo "          </tr>\n";
    echo "          <tr>\n";
    echo "            <td width=\"1%\" align=\"right\" nowrap=\"nowrap\"><span class=\"posttofromlabel\">&nbsp;{$lang['subject']}:&nbsp;</span></td>\n";
    echo "            <td nowrap=\"nowrap\" width=\"98%\" align=\"left\"><span class=\"posttofrom\">".stripslashes($pm_elements_array['SUBJECT'])."</span></td>\n";
    echo "            <td align=\"right\" nowrap=\"nowrap\"><span class=\"postinfo\">", format_time($pm_elements_array['CREATED']), "&nbsp;</span></td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td>\n";
    echo "        <table width=\"100%\">\n";
    echo "          <tr align=\"right\">\n";
    echo "            <td colspan=\"3\"><span class=\"postnumber\"></span></td>\n";
    echo "          </tr>\n";
    echo "          <tr>\n";
    echo "            <td class=\"postbody\" align=\"left\">", $pm_elements_array['CONTENT'], "</td>\n";
    echo "          </tr>\n";
    echo "          <tr>\n";
    echo "            <td align=\"center\">\n";

    if ($replyto) {
        echo "<span class=\"postresponse\"><img src=\"./images/post.png\" height=\"15\" border=\"0\" alt=\"{$lang['reply']}\" />&nbsp;<a href=\"pm_write.php?replyto=$replyto\" target=\"_self\">{$lang['reply']}</a></span>\n";
    }

    echo "</td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</div>\n";
}

function draw_header_pm()
{
    global $lang;

    echo "<script language=\"javascript\" type=\"text/javascript\">\n";
    echo "<!--\n";
    echo "function launchOthers() {\n\n";
    echo "  newUser = prompt(\"{$lang['pleaseentermembername']}\",document.f_post.t_to_uid.options[0].text);\n";
    echo "  if (newUser != null) {\n";
    echo "    if (newUser != document.f_post.t_to_uid.options[0].text) {\n";
    echo "      document.f_post.t_to_uid.options[0] = new Option(newUser, \"U:\" + newUser, true, true);\n";
    echo "    }\n  }\n}\n";
    echo "//-->\n";
    echo "</script>\n";
}

function draw_new_pm($t_subject, $t_content, $t_to_uid, $t_post_html)
{
    global $lang;

    echo "<form name=\"f_post\" action=\"" . get_request_uri() . "\" method=\"post\" target=\"_self\">\n";
    echo "<table class=\"box\" cellpadding=\"0\" cellspacing=\"0\">\n";
    echo "  <tr>\n";
    echo "    <td>\n";
    echo "      <table class=\"posthead\" border=\"0\" width=\"100%\">\n";
    echo "        <tr>\n";
    echo "          <td align=\"right\" width=\"30\">{$lang['subject']}:</td>\n";
    echo "          <td>", form_field("t_subject", isset($t_subject) ? stripslashes(_htmlentities($t_subject)) : "", 32), "&nbsp;", form_submit("submit", $lang['post']), "</td>\n";
    echo "        </tr>\n";
    echo "        <tr>\n";
    echo "          <td align=\"right\">{$lang['to']}: </td>\n";
    echo "          <td>", pm_draw_to_dropdown($t_to_uid), "&nbsp;", form_button("others", $lang['others'], "onclick=\"javascript:launchOthers()\""), "</td>\n";
    echo "        </tr>\n";
    echo "      </table>\n";
    echo "      <table border=\"0\" class=\"posthead\">\n";
    echo "        <tr>\n";
    echo "          <td>".form_textarea("t_content", isset($t_content) ? _htmlentities($t_content) : "", 15, 85). "</td>\n";
    echo "        </tr>\n";
    echo "        <tr>\n";
    echo "          <td><span class=\"bhinputcheckbox\">", form_checkbox('t_post_html', 'Y', $lang['messagecontainsHTML'], ($t_post_html == 'Y')), "</td>\n";
    echo "        </tr>\n";
    echo "      </table>\n";
    echo "    </td>\n";
    echo "  </tr>\n";
    echo "</table>\n";
    echo form_submit('submit', $lang['post']), "&nbsp;", form_submit('preview', $lang['preview']), "&nbsp;";
    echo form_submit('submit', $lang['cancel']), "&nbsp;", form_submit('convert_html', $lang['converttoHTML']);
    echo "</form>\n";
}

function pm_send_message($tuid, $subject, $content)
{
    $db_pm_send_message = db_connect();

    $subject = addslashes($subject);
    $content = addslashes($content);
    $fuid = bh_session_get_value('UID');

    // ------------------------------------------------------------
    // Insert the main PM Data into the database
    // ------------------------------------------------------------

    $sql = "insert into ". forum_table("PM");
    $sql.= " (TYPE, TO_UID, FROM_UID, SUBJECT, CREATED) ";
    $sql.= "values (". PM_NEW. ", '$tuid', '$fuid', '$subject', NOW())";

    $result = db_query($sql, $db_pm_send_message);

    if ($result) {

      $new_mid = db_insert_id($db_pm_send_message);

      // ------------------------------------------------------------
      // Insert the PM Content into the database
      // ------------------------------------------------------------

      $sql = "insert into ". forum_table("PM_CONTENT"). " (MID, CONTENT) ";
      $sql.= "values ('$new_mid', '$content')";

      if (db_query($sql, $db_pm_send_message)) {
          return  $new_mid;
      }

    }

    return false;
}

function pm_delete_message($mid)
{
    $db_delete_pm = db_connect();

    // ------------------------------------------------------------
    // Get the PM data incase the sendee hasn't got a copy of it
    // in his Sent Items folder.
    // ------------------------------------------------------------

    $sql = "SELECT PM.TYPE FROM ". forum_table("PM"). " PM WHERE PM.MID = $mid";
    $result = db_query($sql, $db_delete_pm);
    $db_delete_pm_row = db_fetch_array($result);

    if (($db_delete_pm_row['TYPE'] == PM_NEW) || ($db_delete_pm_row['TYPE'] == PM_UNREAD)) {
        pm_add_sentitem($mid);
    }

    $sql = "DELETE FROM ". forum_table('PM'). " WHERE MID = $mid";
    $result = db_query($sql, $db_delete_pm);

    $sql = "DELETE FROM ". forum_table("PM_CONTENT"). " WHERE MID = $mid";
    return db_query($sql, $db_delete_pm);

}

function pm_archive_message($mid)
{
    $db_pm_archive_message = db_connect();
    $uid = bh_session_get_value('UID');

    // ------------------------------------------------------------
    // Check to see if the the sender need an item in
    // his Sent Items folder.
    // ------------------------------------------------------------

    $sql = "SELECT PM.TYPE FROM ". forum_table("PM"). " PM WHERE PM.MID = $mid";
    $result = db_query($sql, $db_pm_archive_message);
    $db_pm_archive_message_row = db_fetch_array($result);

    if (($db_pm_archive_message_row['TYPE'] == PM_NEW) || ($db_pm_archive_message_row['TYPE'] == PM_UNREAD)) {
        pm_add_sentitem($mid);
    }

    // ------------------------------------------------------------
    // Archive any PM that are in the User's Inbox
    // ------------------------------------------------------------

    $sql = "UPDATE ". forum_table("PM"). " SET TYPE = ". PM_SAVED_IN. " ";
    $sql.= "WHERE MID = $mid AND (TYPE = ". PM_NEW. " OR TYPE = ". PM_READ. " OR TYPE = ". PM_UNREAD. ") ";
    $sql.= "AND TO_UID = $uid";

    $result = db_query($sql, $db_pm_archive_message);

    // ------------------------------------------------------------
    // Archive any PM that are in the User's Sent Items
    // ------------------------------------------------------------

    $sql = "UPDATE ". forum_table("PM"). " SET TYPE = ". PM_SAVED_OUT. " ";
    $sql.= "WHERE MID = $mid AND TYPE = ". PM_SENT. " AND FROM_UID = $uid";

    $result = db_query($sql, $db_pm_archive_message);
}

function pm_new_check()
{
    $db_pm_new_check = db_connect();
    $uid = bh_session_get_value('UID');

    // ------------------------------------------------------------
    // Check to see if the user has any new PMs
    // ------------------------------------------------------------

    $sql = "SELECT MID FROM ". forum_table("PM"). " ";
    $sql.= "WHERE TYPE = ". PM_NEW. " AND TO_UID = $uid";

    $result = db_query($sql, $db_pm_new_check);

    $num_rows = db_num_rows($result);

    // ------------------------------------------------------------
    // We only want to notify the user once per every new
    // messages that arrives and NOT every time they reload
    // the page, so set all NEW messages to UNREAD.
    // ------------------------------------------------------------

    $sql = "UPDATE ". forum_table("PM"). " SET TYPE = ". PM_UNREAD. " ";
    $sql.= "WHERE TYPE = ". PM_NEW. " AND TO_UID = $uid";

    $result = db_query($sql, $db_pm_new_check);

    return ($num_rows > 0);
}

?>