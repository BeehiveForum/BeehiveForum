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

//Check logged in status

require_once("./include/session.inc.php");
require_once("./include/header.inc.php");
require_once("./include/html.inc.php");

if(!bh_session_check()){

    $uri = "./logon.php?final_uri=". urlencode(get_request_uri());
    header_redirect($uri);

}

if($HTTP_COOKIE_VARS['bh_sess_uid'] == 0) {
    html_guest_error();
    exit;
}


require_once("./include/constants.inc.php");
require_once("./include/folder.inc.php");
require_once("./include/form.inc.php");
require_once("./include/post.inc.php");
require_once("./include/poll.inc.php");

if (isset($HTTP_POST_VARS['cancel'])) {

  $uri = "./discussion.php";
  header_redirect($uri);

}elseif (isset($HTTP_POST_VARS['preview']) || isset($HTTP_POST_VARS['submit'])) {

  $valid = true;

  if (empty($HTTP_POST_VARS['question'])) {
    $error_html = "<h2>You must enter a poll question</h2>";
    $valid = false;
  }

  if ($valid && !isset($HTTP_POST_VARS['t_fid'])) {
    $error_html = "<h2>Please select a folder</h2>";
    $valid = false;
  }

  if ($valid && empty($HTTP_POST_VARS['answers'][0])) {
    $error_html = "<h2>You must specify values for answers 1 and 2</h2>";
    $valid = false;
  }

  if ($valid && empty($HTTP_POST_VARS['answers'][1])) {
    $error_html = "<h2>You must specify values for answers 1 and 2</h2>";
    $valid = false;
  }

}

if ($valid && isset($HTTP_POST_VARS['submit'])) {

  $db = db_connect();

  $sql = "select DDKEY from ".forum_table("DEDUPE")." where UID = ".$HTTP_COOKIE_VARS['bh_sess_uid'];
  $result = db_query($sql,$db);

  if(db_num_rows($result) > 0) {

      db_query($sql, $db);
      list($ddkey) = db_fetch_array($result);
      $sql = "update ".forum_table("DEDUPE")." set DDKEY = \"".$HTTP_POST_VARS['t_dedupe']."\" where UID = ".$HTTP_COOKIE_VARS['bh_sess_uid'];

  }else{

      $sql = "insert into ".forum_table("DEDUPE")." (UID,DDKEY) values (".$HTTP_COOKIE_VARS['bh_sess_uid'].",\"".$HTTP_POST_VARS['t_dedupe']."\")";
      $ddkey = "";

  }

  db_query($sql,$db);
  db_disconnect($db);

  if($ddkey != $HTTP_POST_VARS['t_dedupe']) {

    // Work out when the poll will close.

    if ($HTTP_POST_VARS['closepoll'] == 0) {
      $poll_closes = gmmktime() + DAY_IN_SECONDS;
    }elseif ($HTTP_POST_VARS['closepoll'] == 1) {
      $poll_closes = gmmktime() + (DAY_IN_SECONDS * 3);
    }elseif ($HTTP_POST_VARS['closepoll'] == 2) {
      $poll_closes = gmmktime() + (DAY_IN_SECONDS * 7);
    }elseif ($HTTP_POST_VARS['closepoll'] == 3) {
      $poll_closes = gmmktime() + (DAY_IN_SECONDS * 30);
    }elseif ($HTTP_POST_VARS['closepoll'] == 4) {
      $poll_closes = 0;
    }

    // Check HTML tick box, innit.

    for ($i = 0; $i < 5; $i++) {
      if ($HTTP_POST_VARS['t_post_html'] == 'Y') {
        $HTTP_POST_VARS['answers'][$i] = fix_html($HTTP_POST_VARS['answers'][$i]);
      }else {
        $HTTP_POST_VARS['answers'][$i] = make_html($HTTP_POST_VARS['answers'][$i]);
      }
    }

    $HTTP_POST_VARS['question'] = trim($HTTP_POST_VARS['question']);

    // Create the poll thread with the poll_flag set to Y

    $tid = post_create_thread($HTTP_POST_VARS['t_fid'], $HTTP_POST_VARS['question'], 'Y');
    $pid = post_create($tid, 0, $HTTP_COOKIE_VARS['bh_sess_uid'], 0, '');
    poll_create($tid, $HTTP_POST_VARS['answers'], $poll_closes, $HTTP_POST_VARS['changevote'], $HTTP_POST_VARS['polltype'], $HTTP_POST_VARS['showresults']);

    if ($HTTP_COOKIE_VARS['bh_sess_markread']) thread_set_interest($tid, 1, true);

  }

  $uri = "./discussion.php?msg=$tid.1";
  header_redirect($uri);

}

html_draw_top();

if ($valid && isset($HTTP_POST_VARS['preview'])) {

  echo "<h2>Preview:</h2>";

  $polldata['TLOGON'] = "ALL";
  $polldata['TNICK'] = "ALL";

  $preview_tuser = user_get($HTTP_COOKIE_VARS['bh_sess_uid']);

  $polldata['FLOGON'] = $preview_tuser['LOGON'];
  $polldata['FNICK'] = $preview_tuser['NICKNAME'];
  $polldata['FROM_UID'] = $preview_tuser['UID'];

  $polldata['CONTENT'] = "<br>\n";
  $polldata['CONTENT'].= "<table class=\"box\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\" width=\"475\">\n";
  $polldata['CONTENT'].= "  <tr>\n";
  $polldata['CONTENT'].= "    <td>\n";
  $polldata['CONTENT'].= "      <table width=\"95%\" align=\"center\">\n";
  $polldata['CONTENT'].= "        <tr>\n";
  $polldata['CONTENT'].= "          <td><h2>". _stripslashes($HTTP_POST_VARS['question']). "</h2></td>\n";
  $polldata['CONTENT'].= "        </tr>\n";
  $polldata['CONTENT'].= "        <tr>\n";
  $polldata['CONTENT'].= "          <td class=\"postbody\">\n";
  $polldata['CONTENT'].= "            <ul>\n";

  for ($i = 0; $i < 5; $i++) {
    if (!empty($HTTP_POST_VARS['answers'][$i])) {
      if ($HTTP_POST_VARS['t_post_html'] == 'Y') {
        $polldata['CONTENT'].= "          <li>". fix_html($HTTP_POST_VARS['answers'][$i]). "</li>\n";
      }else {
        $polldata['CONTENT'].= "          <li>". make_html($HTTP_POST_VARS['answers'][$i]). "</li>\n";
      }
    }
  }

  $polldata['CONTENT'].= "            </ul>\n";
  $polldata['CONTENT'].= "          </td>\n";
  $polldata['CONTENT'].= "        </tr>\n";
  $polldata['CONTENT'].= "      </table>\n";
  $polldata['CONTENT'].= "    </td>\n";
  $polldata['CONTENT'].= "  </tr>\n";
  $polldata['CONTENT'].= "  <tr>\n";
  $polldata['CONTENT'].= "    <td>";
  $polldata['CONTENT'].= "      <table width=\"95%\" align=\"center\">\n";
  $polldata['CONTENT'].= "        <tr>\n";
  $polldata['CONTENT'].= "          <td class=\"postbody\">";

  if ($HTTP_POST_VARS['changevote'] == 1) {
    $polldata['CONTENT'].= "You will be able to change your vote.";
  }else {
    $polldata['CONTENT'].= "You will not be able to change your vote.";
  }

  $polldata['CONTENT'].= "          </td>";
  $polldata['CONTENT'].= "        </tr>\n";
  $polldata['CONTENT'].= "      </table>\n";
  $polldata['CONTENT'].= "    </td>";
  $polldata['CONTENT'].= "  </tr>\n";
  $polldata['CONTENT'].= "</table>\n";
  $polldata['CONTENT'].= "<br><br>\n";

  message_display(0, $polldata, 0, 0, false, false, false);

}

if(isset($error_html)) echo $error_html. "\n";

?>
<form name="f_poll" action="<?php echo $HTTP_SERVER_VARS['PHP_SELF']; ?>" method="POST" target="_self">
<?php

if(isset($HTTP_POST_VARS['t_dedupe'])) {
    echo form_input_hidden("t_dedupe", $HTTP_POST_VARS['t_dedupe']);
}else{
    echo form_input_hidden("t_dedupe", date("YmdHis"));
}

?>
  <table border="0" cellpadding="0" cellspacing="0" width="500">
    <tr>
      <td><h2>Select folder</h2></td>
    </tr>
    <tr>
      <td><?php echo folder_draw_dropdown($t_fid); ?></td>
    </tr>
    <tr>
      <td><h2>Poll Question</h2></td>
    </tr>
    <tr>
      <td><?php echo form_input_text("question", htmlspecialchars(_stripslashes($HTTP_POST_VARS['question'])), 30, 64); ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
  <table class="box" cellpadding="0" cellspacing="0" width="500">
    <tr>
      <td>
        <table border="0" class="posthead">
          <tr>
            <td><h2>Possible Answers</h2></td>
          </tr>
          <tr>
            <td>Enter the answers for your poll question.. If your poll is a "yes/no" question, simply enter "Yes" for Answer 1 and "No" for Answer 2.</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>
              <table class="posthead" cellpadding="0" cellspacing="0" width="500">
	        <tr>
		  <td>&nbsp;</td>
                  <td>No. Answers: <?php echo form_dropdown_array('answercount', range(0, 3), array('5', '10', '15', '20'), isset($HTTP_POST_VARS['answercount']) ? $HTTP_POST_VARS['answercount'] : 0), " ", form_submit("changecount", "Change")  ?></td>
	        </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <?php

	          $available_answers = array(5, 10, 15, 20);

	          if (isset($HTTP_POST_VARS['answercount'])) {
	            $answercount = $available_answers[$HTTP_POST_VARS['answercount']];
	          }else {
	            $answercount = 5;
	          }

	          for ($i = 0; $i < $answercount; $i++) {

		    echo "<tr>\n";
                    echo "  <td>", $i + 1, ". </td>\n";
                    echo "  <td>", form_input_text("answers[]", htmlspecialchars(_stripslashes($HTTP_POST_VARS['answers'][$i])), 40, 64), "</td>\n";
		    echo "</tr>\n";

		  }

		?>
		<tr>
                  <td>&nbsp;</td>
		  <td><?php echo form_checkbox("t_post_html", "Y", "Answers Contain HTML (not including signature)", ($HTTP_POST_VARS['t_post_html'] == "Y")); ?></td>
                </tr>
	      </table>
	    </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><h2>Vote Changing</h2></td>
          </tr>
          <tr>
            <td>Can a person change his or her vote?</td>
          </tr>
          <tr>
            <td>
              <table border="0" width="300">
                <tr>
                  <td><?php echo form_radio('changevote', '1', 'Yes', true); ?></td>
                  <td><?php echo form_radio('changevote', '0', 'No', false); ?></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><h2>Poll Results</h2></td>
          </tr>
          <tr>
            <td>How would you like to display the results of your poll?</td>
          </tr>
          <tr>
            <td>
              <table border="0" width="300">
                <tr>
                  <td><?php echo form_radio('polltype', '0', 'Horizontal Bar graph', true); ?></td>
                  <td><?php echo form_radio('polltype', '1', 'Vertical Bar graph', false); ?></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><h2>Expiration</h2></td>
          </tr>
          <tr>
            <td>Do you want to show results while the poll is open?</td>
          </tr>
          <tr>
            <td>
              <table border="0" width="300">
                <tr>
                  <td><?php echo form_radio('showresults', '1', 'Yes', true); ?></td>
                  <td><?php echo form_radio('showresults', '0', 'No', false); ?></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>When would you like your poll to automatically close?</td>
          </tr>
          <tr>
            <td><?php echo form_dropdown_array('closepoll', range(0, 4), array('One Day', 'Three Days', 'Seven Days', 'Thirty Days', 'Never'), 4); ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
<?php

    echo form_submit("submit", "Post"). "&nbsp;". form_submit("preview", "Preview"). "&nbsp;". form_submit("cancel", "Cancel");

    if ($attachments_enabled) {

      echo "&nbsp;".form_button("attachments", "Attachments", "onclick=\"window.open('attachments.php?aid=". $aid. "', 'attachments', 'width=640, height=480, toolbar=0, location=0, directories=0, status=0, menubar=0, resizable=0, scrollbars=yes');\"");
      echo form_input_hidden("aid", $aid);

    }

    echo "</form>\n";

    html_draw_bottom();

?>
