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
require_once('./include/attachments.inc.php');

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

    $sql = "SELECT PM.MID, PM.FROM_UID, PM.TO_UID, PM.SUBJECT, PM.CREATED, PM_CONTENT.CONTENT, AT.AID ";
    $sql.= "FROM ". forum_table("PM"). " PM ";
    $sql.= "LEFT JOIN ". forum_table("PM_CONTENT"). " PM_CONTENT ON (PM_CONTENT.MID = PM.MID) ";
    $sql.= "LEFT JOIN ". forum_table("PM_ATTACHMENT_IDS"). " AT ON (AT.MID = PM.MID) ";
    $sql.= "WHERE PM.MID = $mid GROUP BY PM.MID";

    $result = db_query($sql, $db_pm_add_sentitem);
    $db_pm_add_sentitem_row = db_fetch_array($result);

    // ------------------------------------------------------------
    // Insert the original PM data as a new row to appear in the
    // sender's sent items
    // ------------------------------------------------------------

    $sql = "INSERT INTO ". forum_table("PM"). " (TYPE, FROM_UID, TO_UID, SUBJECT, CREATED) ";
    $sql.= "VALUES (". PM_SENT. ", {$db_pm_add_sentitem_row['FROM_UID']}, ";
    $sql.= "{$db_pm_add_sentitem_row['TO_UID']}, '". addslashes($db_pm_add_sentitem_row['SUBJECT']). "', ";
    $sql.= "'{$db_pm_add_sentitem_row['CREATED']}')";

    $result  = db_query($sql, $db_pm_add_sentitem);
    $new_mid = db_insert_id($db_pm_add_sentitem);

    // ------------------------------------------------------------
    // Insert the original PM content as a new row to appear in
    // the sender's sent items
    // ------------------------------------------------------------

    $sql = "INSERT INTO ". forum_table("PM_CONTENT"). " (MID, CONTENT) ";
    $sql.= "VALUES ($new_mid, '". addslashes($db_pm_add_sentitem_row['CONTENT']). "')";

    $result = db_query($sql, $db_pm_add_sentitem);

    // ------------------------------------------------------------
    // Insert a duplicate attachment ID so that it appears in
    // the sender's Sent Items
    // ------------------------------------------------------------

    if (get_num_attachments($db_pm_add_sentitem_row['AID'])) {

        $sql = "INSERT INTO ". forum_table("PM_ATTACHMENT_IDS"). " (MID, AID) ";
        $sql.= "VALUES ($new_mid, '{$db_pm_add_sentitem_row['AID']}')";

        $result = db_query($sql, $db_pm_add_sentitem);

    }

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
    $sql.= "TUSER.LOGON AS TLOGON, TUSER.NICKNAME AS TNICK, AT.AID ";
    $sql.= "FROM ". forum_table("PM"). " PM ";
    $sql.= "LEFT JOIN ". forum_table("USER"). " FUSER ON (PM.FROM_UID = FUSER.UID) ";
    $sql.= "LEFT JOIN ". forum_table("USER"). " TUSER ON (PM.TO_UID = TUSER.UID) ";
    $sql.= "LEFT JOIN ". forum_table("PM_ATTACHMENT_IDS"). " AT ON (AT.MID = PM.MID) WHERE ";

    if (($folder == PM_FOLDER_INBOX)) {
        $sql.= "PM.TYPE = PM.TYPE & $folder AND PM.TO_UID = $uid ";
    }elseif (($folder == PM_FOLDER_SENT) || ($folder == PM_FOLDER_OUTBOX)) {
        $sql.= "PM.TYPE = PM.TYPE & $folder AND PM.FROM_UID = $uid ";
    }elseif ($folder == PM_FOLDER_SAVED) {
        $sql.= "(PM.TYPE = ". PM_SAVED_OUT. " AND PM.FROM_UID = $uid) OR ";
        $sql.= "(PM.TYPE = ". PM_SAVED_IN. " AND PM.TO_UID = $uid)";
    }

    $sql.= "GROUP BY PM.MID ORDER BY CREATED DESC";
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

    $sql = "SELECT PM.MID, PM.TYPE, PM.TO_UID, PM.FROM_UID, PM.SUBJECT, UNIX_TIMESTAMP(PM.CREATED) AS CREATED, ";
    $sql.= "TUSER.LOGON AS TLOGON, TUSER.NICKNAME AS TNICK, FUSER.LOGON AS FLOGON, FUSER.NICKNAME AS FNICK, ";
    $sql.= "PM_CONTENT.CONTENT, AT.AID FROM ". forum_table("PM"). " PM ";
    $sql.= "LEFT JOIN ". forum_table("USER"). " TUSER ON (TUSER.UID = PM.TO_UID) ";
    $sql.= "LEFT JOIN ". forum_table("USER"). " FUSER ON (FUSER.UID = PM.FROM_UID) ";
    $sql.= "LEFT JOIN ". forum_table("PM_CONTENT"). " PM_CONTENT ON (PM_CONTENT.MID = PM.MID) ";
    $sql.= "LEFT JOIN ". forum_table("PM_ATTACHMENT_IDS"). " AT ON (AT.MID = PM.MID) ";
    $sql.= "WHERE PM.MID = $mid ";

    if (($folder == PM_FOLDER_INBOX)) {
        $sql.= "AND PM.TYPE = PM.TYPE & $folder AND PM.TO_UID = $uid ";
    }elseif (($folder == PM_FOLDER_SENT) || ($folder == PM_FOLDER_OUTBOX)) {
        $sql.= "AND PM.TYPE = PM.TYPE & $folder AND PM.FROM_UID = $uid ";
    }elseif ($folder == PM_FOLDER_SAVED) {
        $sql.= " AND ((PM.TYPE = ". PM_SAVED_OUT. " AND PM.FROM_UID = $uid) OR ";
        $sql.= "(PM.TYPE = ". PM_SAVED_IN. " AND PM.TO_UID = $uid)) ";
    }

    $sql.= "GROUP BY PM.MID";
    $result = db_query($sql, $db_pm_list_get);

    if (db_num_rows($result) > 0) {

        $db_pm_list_get_row = db_fetch_array($result);

        // ------------------------------------------------------------
        // Check to see if we should add a sent item before delete
        // ------------------------------------------------------------

        if ($folder == PM_FOLDER_INBOX && ($db_pm_list_get_row['TYPE'] == PM_NEW) || ($db_pm_list_get_row['TYPE'] == PM_UNREAD)) {
            pm_markasread($mid);
            pm_add_sentitem($mid);
        }

        return $db_pm_list_get_row;

    }else {
        return false;
    }

}

function draw_pm_message($pm_elements_array)
{
    global $HTTP_SERVER_VARS, $lang;

    $uid = bh_session_get_value('UID');

    echo "<div align=\"center\">\n";
    echo "  <table width=\"90%\" class=\"box\" cellspacing=\"0\" cellpadding=\"0\">\n";
    echo "    <tr>\n";
    echo "      <td>\n";
    echo "        <table width=\"100%\" class=\"posthead\" cellspacing=\"1\" cellpadding=\"0\">\n";
    echo "          <tr>\n";

    if ($pm_elements_array['FOLDER'] == PM_FOLDER_INBOX) {
        echo "            <td width=\"1%\" align=\"right\" nowrap=\"nowrap\"><span class=\"posttofromlabel\">&nbsp;{$lang['from']}:&nbsp;</span></td>\n";
        echo "            <td nowrap=\"nowrap\" width=\"98%\" align=\"left\"><span class=\"posttofrom\">";
        echo "<a href=\"javascript:void(0);\" onclick=\"openProfile(" . $pm_elements_array['FROM_UID'] . ")\" target=\"_self\">";
        echo format_user_name($pm_elements_array['FLOGON'], $pm_elements_array['FNICK']), "</a>";
        echo "</span></td>\n";
    }else {
        echo "            <td width=\"1%\" align=\"right\" nowrap=\"nowrap\"><span class=\"posttofromlabel\">&nbsp;{$lang['to']}:&nbsp;</span></td>\n";
        echo "            <td nowrap=\"nowrap\" width=\"98%\" align=\"left\"><span class=\"posttofrom\">";
        echo "<a href=\"javascript:void(0);\" onclick=\"openProfile(" . $pm_elements_array['TO_UID'] . ")\" target=\"_self\">";
        echo format_user_name($pm_elements_array['TLOGON'], $pm_elements_array['TNICK']), "</a>";
        echo "</span></td>\n";
    }

    echo "          </tr>\n";
    echo "          <tr>\n";
    echo "            <td width=\"1%\" align=\"right\" nowrap=\"nowrap\"><span class=\"posttofromlabel\">&nbsp;{$lang['subject']}:&nbsp;</span></td>\n";
    echo "            <td nowrap=\"nowrap\" width=\"98%\" align=\"left\"><span class=\"posttofrom\">", _stripslashes($pm_elements_array['SUBJECT']), "</span></td>\n";
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

    if (isset($pm_elements_array['AID'])) {

        $aid = $pm_elements_array['AID'];
        $attachments = get_attachments($pm_elements_array['FROM_UID'], $aid);

        if (is_array($attachments)) {

            echo "          <tr>\n";
            echo "            <td>&nbsp;</td>\n";
            echo "          </tr>\n";
            echo "          <tr>\n";
            echo "            <td class=\"postbody\" align=\"left\">\n";
            echo "              <b>{$lang['attachments']}:</b><br />\n";

            for ($i = 0; $i < sizeof($attachments); $i++) {

                echo "              <img src=\"".style_image('attach.png')."\" height=\"15\" border=\"0\" align=\"middle\" alt=\"{$lang['attachment']}\" />";
                echo "<a href=\"getattachment.php/", $attachments[$i]['hash'], "/", $attachments[$i]['filename'], "\" target=\"_blank\" title=\"";

                if ($imageinfo = @getimagesize($attachment_dir. '/'. md5($attachments[$i]['aid']. rawurldecode($attachments[$i]['filename'])))) {
                    echo "{$lang['dimensions']}: ". $imageinfo[0]. " x ". $imageinfo[1]. ", ";
                }

                echo "{$lang['size']}: ". format_file_size($attachments[$i]['filesize']). ", ";
                echo "{$lang['downloaded']}: ". $attachments[$i]['downloads'];

                if ($attachments[$i]['downloads'] == 1) {
                    echo " {$lang['time']}";
                }else {
                    echo " {$lang['times']}";
                }

                echo "\">". $attachments[$i]['filename']. "</a><br />\n";

            }

            echo "            </td>\n";
            echo "          </tr>\n";

        }

    }

    echo "          <tr>\n";
    echo "            <td align=\"center\">\n";

    if (isset($pm_elements_array['MID'])) {
        echo "<span class=\"postresponse\"><img src=\"./images/post.png\" height=\"15\" border=\"0\" alt=\"{$lang['reply']}\" />&nbsp;<a href=\"pm_write.php?replyto={$pm_elements_array['MID']}\" target=\"_self\">{$lang['reply']}</a></span>\n";
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

function pm_save_attachment_id($mid, $aid)
{

    // ------------------------------------------------------------
    // Save the attachment ID for the PM
    // ------------------------------------------------------------

    $db_pm_save_attachment_id = db_connect();
    $sql = "INSERT INTO ". forum_table("PM_ATTACHMENT_IDS"). " (MID, AID) values ($mid, '$aid')";

    $result = db_query($sql, $db_pm_save_attachment_id);
    return $result;
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
    $uid = bh_session_get_value('UID');

    // ------------------------------------------------------------
    // Get the PM data incase the sendee hasn't got a copy of it
    // in his Sent Items folder.
    // ------------------------------------------------------------

    $sql = "SELECT PM.TYPE, PM.TO_UID, PM.FROM_UID, PAF.FILENAME, AT.AID ";
    $sql.= "FROM ". forum_table("PM"). " PM ";
    $sql.= "LEFT JOIN ". forum_table("PM_ATTACHMENT_IDS"). " AT ON (AT.MID = PM.MID) ";
    $sql.= "LEFT JOIN ". forum_table("POST_ATTACHMENT_FILES"). " PAF ON (PAF.AID = AT.AID) ";
    $sql.= "WHERE PM.MID = $mid";

    $result = db_query($sql, $db_delete_pm);
    $db_delete_pm_row = db_fetch_array($result);

    // ------------------------------------------------------------
    // Add the Sent Item
    // ------------------------------------------------------------

    if (($db_delete_pm_row['TO_UID'] == $uid) && (($db_delete_pm_row['TYPE'] == PM_NEW) || ($db_delete_pm_row['TYPE'] == PM_UNREAD))) {
        pm_add_sentitem($mid);
    }

    // ------------------------------------------------------------
    // If it is the author deleting his Sent Item then
    // delete the attachment as well.
    // ------------------------------------------------------------

    if ($db_delete_pm_row['TYPE'] == PM_SENT) {
        delete_attachment($db_delete_pm_row['FROM_UID'], $db_delete_pm_row['AID'], $db_delete_pm_row['FILENAME']);
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