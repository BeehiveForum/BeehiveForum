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

// Frameset for thread list and messages

// Enable the error handler
require_once("./include/errorhandler.inc.php");

// Compress the output
require_once("./include/gzipenc.inc.php");

//Check logged in status
require_once("./include/session.inc.php");
require_once("./include/header.inc.php");

if(!bh_session_check()){

    $uri = "./logon.php?final_uri=". urlencode(get_request_uri());
    header_redirect($uri);

}

require_once("./include/perm.inc.php");
require_once("./include/html.inc.php");
require_once("./include/forum.inc.php");
require_once("./include/db.inc.php");
require_once("./include/user.inc.php");
require_once("./include/constants.inc.php");
require_once("./include/form.inc.php");
require_once("./include/poll.inc.php");
require_once("./include/config.inc.php");
require_once("./include/edit.inc.php");
require_once("./include/ip.inc.php");
require_once("./include/admin.inc.php");

if(isset($HTTP_POST_VARS['cancel'])){
        header_redirect($HTTP_POST_VARS['ret']);
}

if (isset($HTTP_GET_VARS['ret'])) {
  $ret = $HTTP_GET_VARS['ret'];
}else {
  $ret = "admin_users.php";
}

html_draw_top();

if(!($HTTP_COOKIE_VARS['bh_sess_ustatus'] & USER_PERM_SOLDIER)){
    echo "<h1>Access Denied</h1>\n";
    echo "<p>You do not have permission to use this section.</p>";
    html_draw_bottom();
    exit;
}

if(isset($HTTP_GET_VARS['uid'])){
    $uid = $HTTP_GET_VARS['uid'];
} else if(isset($HTTP_POST_VARS['uid'])){
    $uid = $HTTP_POST_VARS['uid'];
} else {
    echo "<h1>Invalid Operation</h1>\n";
    echo "<p>No user specified for editing.</p>\n";
    html_draw_bottom();
    exit;
}

$db = db_connect();

$sql = "select LOGON, NICKNAME, STATUS, LOGON_FROM from ". forum_table("USER"). " where UID = $uid";
$result = db_query($sql,$db);

$user = db_fetch_array($result);

if (!isset($user['STATUS'])) {
  $user['STATUS'] = 0;
}

// Do updates
if(isset($HTTP_POST_VARS['submit'])) {

  if ($HTTP_POST_VARS['submit'] == 'Del') {

    unlink($attachment_dir. '/'. md5($HTTP_POST_VARS['aid']. _stripslashes($HTTP_POST_VARS['userfile'])));
    delete_attachment($uid, $HTTP_POST_VARS['aid'], rawurlencode(_stripslashes($HTTP_POST_VARS['userfile'])));
    admin_addlog($uid, 0, 0, 0, 0, 0, 6);

  }else {

    $t_soldier = (isset($HTTP_POST_VARS['t_soldier'])) ? $HTTP_POST_VARS['t_soldier'] : 0;
    $t_worker  = (isset($HTTP_POST_VARS['t_worker']))  ? $HTTP_POST_VARS['t_worker']  : 0;
    $t_worm    = (isset($HTTP_POST_VARS['t_worm']))    ? $HTTP_POST_VARS['t_worm']    : 0;
    $t_wasp    = (isset($HTTP_POST_VARS['t_wasp']))    ? $HTTP_POST_VARS['t_wasp']    : 0;
    $t_splat   = (isset($HTTP_POST_VARS['t_splat']))   ? $HTTP_POST_VARS['t_splat']   : 0;

    $new_status = $t_worker | $t_worm | $t_wasp | $t_splat;

    if ($HTTP_COOKIE_VARS['bh_sess_ustatus'] & USER_PERM_QUEEN) {
        $new_status = $new_status | $t_soldier;
    }

    $new_status = $new_status | ($user['STATUS'] & USER_PERM_SOLDIER);
    $new_status = $new_status | ($user['STATUS'] & USER_PERM_QUEEN);

    // Add lower ranks automatically
    if ($new_status & USER_PERM_QUEEN) $new_status |= USER_PERM_SOLDIER;
    if ($new_status & USER_PERM_SOLDIER) $new_status |= USER_PERM_WORKER;

    user_update_status($uid, $new_status);
    $user['STATUS'] = $new_status;

    // Add Log entry.
    admin_addlog($uid, 0, 0, 0, 0, 0, 1);

    $user['STATUS'] = $new_status;

    // Private folder permissions

    if (isset($HTTP_POST_VARS['t_fcount'])) {

      for($i = 0; $i < $HTTP_POST_VARS['t_fcount']; $i++){

        $uf[$i]['fid'] = $HTTP_POST_VARS['t_fid_'.$i];

        if (isset($HTTP_POST_VARS['t_fallow_'. $i])) {

          $uf[$i]['allowed'] = $HTTP_POST_VARS['t_fallow_'.$i];

        }else {

          $uf[$i]['allowed'] = 0;

        }

      }

      if (isset($uf)) {

        user_update_folders($uid, $uf);
        admin_addlog($uid, 0, 0, 0, 0, 0, 2);

      }

    }

    if (isset($HTTP_POST_VARS['t_confirm_delete_posts'])) {

      $sql = "SELECT TID, PID FROM ". forum_table("POST"). " WHERE FROM_UID = '$uid'";
      $result = db_query($sql, $db);

      while (list($tid, $pid) = db_fetch_array($result)) {
        post_delete($tid, $pid);
      }

      admin_addlog($uid, 0, 0, 0, 0, 0, 3);

    }

    if (isset($HTTP_POST_VARS['t_ban_ipaddress'])) {

      if (!empty($HTTP_SERVER_VARS['HTTP_X_FORWARDED_FOR'])) {
        $ipaddress = $HTTP_SERVER_VARS['HTTP_X_FORWARDED_FOR'];
      }else {
        $ipaddress = $HTTP_SERVER_VARS['REMOTE_ADDR'];
      }

      if ($HTTP_POST_VARS['t_ip_address'] != $ipaddress) {

        ban_ip($HTTP_POST_VARS['t_ip_address']);
        admin_addlog($uid, 0, 0, 0, 0, 0, 4);

      }

    }elseif (isset($HTTP_POST_VARS['t_ip_banned']) && !isset($HTTP_POST_VARS['t_ban_ipaddress'])) {

      unban_ip($HTTP_POST_VARS['t_ip_address']);
      admin_addlog($uid, 0, 0, 0, 0, 0, 5);

    }
  }
}

// Draw the form
echo "<h1>Manage User</h1>\n";
echo "<p>&nbsp;</p>\n";
echo "<div align=\"center\">\n";

echo "<form name=\"f_user\" action=\"" . $HTTP_SERVER_VARS['PHP_SELF'] . "\" method=\"post\">\n";
echo "<table width=\"50%\"><tr><td class=\"box\">";
echo "<table class=\"posthead\" width=\"100%\"><tr>\n";

if (isset($HTTP_POST_VARS['t_delete_posts'])) {

  echo "<td class=\"subhead\">User Status: ".$user['LOGON']."</td></tr>\n";
  echo "<tr><td><h2>WARNING</h2></td></tr>\n";
  echo "<tr><td>Are you sure you want to delete all of the selected user's posts? Once the posts are deleted they cannot be retrieved and will be lost forever.</td></tr>\n";
  echo "<tr><td>", form_checkbox("t_confirm_delete_posts", 1, "Confirm", false), "</td></tr>\n";
  echo "</table>\n";
  echo form_input_hidden("uid", $uid);
  echo form_input_hidden("ret", $ret);
  echo "</td></tr></table>\n";

}else if (isset($HTTP_POST_VARS['t_confirm_delete_posts'])) {

  echo "<td class=\"subhead\">User Status: ".$user['LOGON']."</td></tr>\n";
  echo "<tr><td>Posts were successfully deleted.</td></tr>\n";
  echo "</table>\n";
  echo form_input_hidden("uid", $uid);
  echo form_input_hidden("ret", $ret);
  echo "</td></tr></table>\n";

}else {

  echo "<td class=\"subhead\">User Status: ".$user['LOGON']."</td></tr>\n";

  if($HTTP_COOKIE_VARS['bh_sess_ustatus'] & USER_PERM_QUEEN){
    echo "<tr><td>".form_checkbox("t_soldier", USER_PERM_SOLDIER, "Soldier", isset($user['STATUS']) ? ($user['STATUS'] & USER_PERM_SOLDIER) : False)."</td></tr>\n";
  }

  echo "<tr><td>".form_checkbox("t_worker", USER_PERM_WORKER, "Worker", isset($user['STATUS']) ? ($user['STATUS'] & USER_PERM_WORKER) : False). "</td></tr>\n";
  echo "<tr><td>".form_checkbox("t_worm", USER_PERM_WORM, "Worm", isset($user['STATUS']) ? ($user['STATUS'] & USER_PERM_WORM) : False). "</td></tr>\n";
  echo "<tr><td>".form_checkbox("t_wasp", USER_PERM_WASP, "Wasp", isset($user['STATUS']) ? ($user['STATUS'] & USER_PERM_WASP) : False). "</td></tr>\n";
  echo "<tr><td>".form_checkbox("t_splat", USER_PERM_SPLAT, "Splat", isset($user['STATUS']) ? ($user['STATUS'] & USER_PERM_SPLAT) : FALSE). "</td></tr>\n";
  echo "<tr><td>&nbsp;</td></tr>\n";
  echo "<tr><td class=\"subhead\">Folder Access:</td></tr>\n";

  $sql = "select F.FID, F.TITLE, UF.ALLOWED from ".forum_table("FOLDER")." F ";
  $sql.= "left join ".forum_table("USER_FOLDER")." UF on (UF.UID = $uid and UF.FID = F.FID) ";
  $sql.= "where F.ACCESS_LEVEL = 1"; // Restricted folders

  $result = db_query($sql,$db);
  $count  = 0;

  if (db_num_rows($result)) {

    while($row = db_fetch_array($result)) {
      echo "<tr><td>".form_checkbox("t_fallow_$count", 1, $row['TITLE'], (isset($row['ALLOWED']) && $row['ALLOWED'] > 0));
      echo form_input_hidden("t_fid_$count", $row['FID']). "</td></tr>\n";
      $count++;
    }

    echo form_input_hidden("t_fcount", db_num_rows($result));

  }else {
    echo "<tr><td>No restricted folders</td></tr>\n";
  }

  echo "<tr><td>&nbsp;</td></tr>\n";
  echo "<tr><td class=\"subhead\">Possible Aliases";

  if (isset($user['LOGON_FROM']) && strlen($user['LOGON_FROM']) > 0) {
    echo "(IP: ", $user['LOGON_FROM'], ") ";
  }

  echo ":</td></tr>\n";

  $sql = "select UID, LOGON from ". forum_table("USER"). " where LOGON_FROM <> '' and LOGON_FROM = '". $user['LOGON_FROM']. "' and LOGON <> '". $user['LOGON']. "'";
  $result = db_query($sql, $db);

  if (db_num_rows($result)) {

    while($row = db_fetch_array($result)) {
      echo "<tr><td><a href=\"admin_user.php?uid=", $row['UID'], "\">", $row['LOGON'], "</a></td></tr>\n";
    }

  }else {
    echo "<tr><td>No matches</td></tr>\n";
  }

  echo "<tr><td>&nbsp;</td></tr>\n";

  if (isset($user['LOGON_FROM']) && strlen($user['LOGON_FROM']) > 0) {

    echo "<tr><td>";
    echo form_checkbox("t_ban_ipaddress", 1, "Ban this IP address", ip_is_banned($user['LOGON_FROM']));
    echo form_input_hidden("t_ip_address", $user['LOGON_FROM']);

    if (ip_is_banned($user['LOGON_FROM'])) {
      echo form_input_hidden("t_ip_banned", 1);
    }

    echo "</td></tr>\n";

  }else {

    echo "<tr><td class=\"smalltext\">There is no IP address record for this account. User cannot be banned by IP.</td></tr>\n";

  }

  echo "<tr><td>&nbsp;</td></tr>\n";
  echo "<tr><td class=\"subhead\">Delete Posts:</td></tr>\n";
  echo "<tr><td>", form_checkbox("t_delete_posts", 1, "Delete all of this user's posts", false), "</td></tr>\n";
  echo "<tr><td>&nbsp;</td></tr>\n";
  echo "<tr><td class=\"subhead\">Attachments:</td></tr>\n";
  echo "<tr><td>\n";
  echo "<table class=\"posthead\" width=\"100%\">\n";

  $attachments = get_users_attachments($uid);

  if (is_array($attachments)) {

    for ($i = 0; $i < sizeof($attachments); $i++) {

      echo "  <tr>\n";
      echo "    <td valign=\"top\" width=\"300\" class=\"postbody\"><img src=\"".style_image('attach.png')."\" width=\"14\" height=\"14\" border=\"0\" /><a href=\"getattachment.php?hash=". $attachments[$i]['hash']. "\" title=\"";

      if (strlen($attachments[$i]['filename']) > 16) {
        echo "Filename: ". $attachments[$i]['filename']. ", ";
      }

      if (@$imageinfo = getimagesize($attachment_dir. '/'. md5($attachments[$i]['aid']. rawurldecode($attachments[$i]['filename'])))) {
        echo "Dimensions: ". $imageinfo[0]. " x ". $imageinfo[1]. ", ";
      }

      echo "Size: ". format_file_size($attachments[$i]['filesize']). ", ";
      echo "Downloaded: ". $attachments[$i]['downloads'];

      if ($attachments[$i]['downloads'] == 1) {
        echo " time";
      }else {
        echo " times";
      }

      echo "\">";

      if (strlen($attachments[$i]['filename']) > 16) {
        echo substr($attachments[$i]['filename'], 0, 16). "...</a></td>\n";
      }else{
        echo $attachments[$i]['filename']. "</a></td>\n";
      }

      echo "    <td valign=\"top\" width=\"100\" class=\"postbody\"><a href=\"messages.php?msg=". get_message_tidpid($attachments[$i]['aid']). "\" target=\"_blank\">View Message</a></td>\n";
      echo "    <td align=\"right\" valign=\"top\" width=\"200\" class=\"postbody\">". format_file_size($attachments[$i]['filesize']). "</td>\n";
      echo "    <td align=\"right\" width=\"100\" class=\"postbody\" nowrap=\"nowrap\">\n";
      echo "      ". form_input_hidden('userfile', $attachments[$i]['filename']);
      echo "      ". form_input_hidden('aid', $attachments[$i]['aid']);
      echo "      ". form_submit('submit', 'Del'). "\n";
      echo "    </td>\n";
      echo "  </tr>\n";

      $total_attachment_size += $attachments[$i]['filesize'];

    }

  }else {

    echo "  <tr>\n";
    echo "    <td valign=\"top\" width=\"300\" class=\"postbody\">No attachments for this user</td>\n";
    echo "    <td align=\"right\" valign=\"top\" width=\"200\" class=\"postbody\">&nbsp;</td>\n";
    echo "    <td align=\"right\" width=\"100\" class=\"postbody\">&nbsp;</td>\n";
    echo "  </tr>\n";
    echo "  <tr>\n";
    echo "    <td width=\"300\" class=\"postbody\">&nbsp;</td>\n";
    echo "    <td width=\"200\" class=\"postbody\">&nbsp;</td>\n";
    echo "    <td width=\"100\" class=\"postbody\">&nbsp;</td>\n";
    echo "  </tr>\n";

  }

  echo "</table></td></tr>\n";
  echo "</table>\n";
  echo form_input_hidden("uid", $uid);
  echo form_input_hidden("ret", $ret);
  echo "</td></tr></table>\n";

}

echo "<p>", form_submit("submit", "Submit"), "&nbsp;", form_submit("cancel", "Cancel"), "</p>\n";
echo "</form>\n";

if (!isset($HTTP_POST_VARS['t_delete_posts']) && !isset($HTTP_POST_VARS['t_confirm_delete_posts'])) {

  echo "<p>&nbsp;</p>";
  echo "<table width=\"50%\" border=\"0\"><tr><td>";
  echo "<p><b>Soldiers</b> can access all moderation tools, but cannot create or remove other Soldiers.</p>\n";
  echo "<p><b>Workers</b> can edit or delete any post.</p>\n";
  echo "<p><b>Worms</b> can read messages and post as normal, but their messages will appear deleted to all other users.</p>\n";
  echo "<p><b>Wasps</b> can read messages, but cannot reply or post new messages.</p>";
  echo "<p><b>Splats</b> cannot access the forum. Use this to ban persistent idiots.</p>";
  echo "<p>&nbsp;</p>";
  echo "<p><b>Possible Aliases</b> a list of users who's last recorded IP address match this user.</p>\n";
  echo "</td></tr></table>\n";

}

echo "</div>\n";

html_draw_bottom();

?>