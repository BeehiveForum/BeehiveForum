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

/* $Id: user_rel.php,v 1.23 2003-11-17 16:01:43 decoyduck Exp $ */

// Enable the error handler
require_once("./include/errorhandler.inc.php");

//Check logged in status
require_once("./include/session.inc.php");
require_once("./include/header.inc.php");
require_once("./include/messages.inc.php");
require_once("./include/lang.inc.php");

if(!bh_session_check()){

    $uri = "./logon.php?final_uri=". urlencode(get_request_uri());
    header_redirect($uri);

}

require_once("./include/html.inc.php");

if(bh_session_get_value('UID') == 0) {
        html_guest_error();
        exit;
}


if (isset($HTTP_GET_VARS['msg']) && validate_msg($HTTP_GET_VARS['msg'])) {
    $msg = $HTTP_GET_VARS['msg'];
}elseif (isset($HTTP_POST_VARS['msg']) && validate_msg($HTTP_POST_VARS['msg'])) {
    $msg = $HTTP_POST_VARS['msg'];
}else {
    $msg = messages_get_most_recent(bh_session_get_value('UID'));
}

require_once("./include/user.inc.php");
require_once("./include/user_rel.inc.php");
require_once("./include/constants.inc.php");
require_once("./include/form.inc.php");
require_once("./include/format.inc.php");

$my_uid = bh_session_get_value('UID');

if (isset($HTTP_POST_VARS['submit'])) {

    $rel = isset($HTTP_POST_VARS['rel']) ? $HTTP_POST_VARS['rel'] : 0;
    $rel+= isset($HTTP_POST_VARS['sig']) ? $HTTP_POST_VARS['sig'] : 0;

    $sig_global = isset($HTTP_POST_VARS['sig_global']) ? $HTTP_POST_VARS['sig_global'] : '';

    user_rel_update($my_uid, $HTTP_POST_VARS['uid'], $rel);

    user_update_global_sig($my_uid, $sig_global);

    // Update the User's Session to save them having to logout and back in
    bh_session_init(bh_session_get_value('UID'));
    header_redirect("./messages.php?msg=$msg");
}

if (isset($HTTP_POST_VARS['cancel'])) {
    header_redirect("./messages.php?msg=$msg");
}

if (isset($HTTP_GET_VARS['uid']) && is_numeric($HTTP_GET_VARS['uid'])) {
    $uid = $HTTP_GET_VARS['uid'];
    if (!$user = user_get($uid)) {
        html_draw_top();
        echo "<h1>{$lang['error']}:</h1>";
        echo "<p>{$lang['invalidusername']}</p>";
        html_draw_bottom();
        exit;
    }
    $uname = "<a href=\"javascript:void(0);\" onclick=\"openProfile(". $uid .")\" target=\"_self\">". format_user_name($user['LOGON'], $user['NICKNAME']) ."</a>";
}else {
    html_draw_top();
    echo "<h1>{$lang['error']}:</h1>";
    echo "<p>{$lang['nouserspecified']}</p>";
    html_draw_bottom();
    exit;
}

html_draw_top("openprofile.js");

$rel = user_rel_get($my_uid, $uid);

echo "<h1>{$lang['userrelationship']}: $uname</h1>\n";
?>

<div class="postbody">
  <form name="relationship" action="<?php echo $HTTP_SERVER_VARS['PHP_SELF']; ?>" method="post" target="_self">
<?php echo "    ", form_input_hidden("uid", $uid), "\n    ", form_input_hidden("msg", $msg), "\n"; ?>
    <table class="posthead" width="500">
<?php if (isset($uid)) { ?>
      <tr>
        <td class="subhead" colspan="2"><?php echo $lang['relationship']; ?></td>
      </tr>
      <tr>
        <td width="130"><?php echo form_radio("rel", "1", $lang['friend'], $rel & USER_FRIEND ? true : false); ?></td>
        <td width="370">: <?php echo $lang['friend_exp']; ?></td>
      </tr>
      <tr>
        <td width="130"><?php echo form_radio("rel", "0", $lang['normal'], !(($rel & USER_IGNORED) || ($rel & USER_FRIEND)) ? true : false); ?></td>
        <td width="370">: <?php echo $lang['normal_exp']; ?></td>
      </tr>
      <tr>
        <td width="130"><?php echo form_radio("rel", "2", $lang['ignored'], $rel & USER_IGNORED ? true : false); ?></td>
        <td width="370">: <?php echo $lang['ignore_exp']; ?></td>
      </tr>
<?php } ?>
      <tr>
        <td class="subhead" colspan="2"><?php echo $lang['signature']; ?></td>
      </tr>
<?php if (isset($uid)) { ?>
      <tr>
        <td width="130"><?php echo form_radio("sig", "0", $lang['display'], $rel ^ USER_IGNORED_SIG ? true : false); ?></td>
        <td width="370">: <?php echo $lang['displaysig_exp']; ?></td>
      </tr>
      <tr>
        <td width="130"><?php echo form_radio("sig", "4", $lang['ignore'], $rel & USER_IGNORED_SIG ? true : false); ?></td>
        <td width="370">: <?php echo $lang['hidesig_exp']; ?></td>
      </tr>
<?php } ?>
      <tr>
        <td width="130"><?php echo form_checkbox("sig_global", "Y", $lang['globallyignored'], user_get_global_sig(bh_session_get_value('UID')) == "Y"); ?></td>
        <td width="370">: <?php echo $lang['globallyignoredsig_exp']; ?></td>
      </tr>
    </table>
    <p><?php echo form_submit("submit", $lang['submit'])."&nbsp;".form_submit("cancel", $lang['cancel']); ?></p>
  </form>
</div>
<?php

  html_draw_bottom();

?>