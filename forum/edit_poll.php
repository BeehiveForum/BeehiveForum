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

require_once("./include/html.inc.php");
require_once("./include/poll.inc.php");
require_once("./include/post.inc.php");
require_once("./include/edit.inc.php");

if (isset($HTTP_GET_VARS['msg'])) {

  $edit_msg = $HTTP_GET_VARS['msg'];
  list($tid, $pid) = explode('.', $HTTP_GET_VARS['msg']);

}elseif (isset($HTTP_POST_VARS['t_msg'])) {

  $edit_msg = $HTTP_POST_VARS['t_msg'];
  list($tid, $pid) = explode('.', $HTTP_POST_VARS['t_msg']);

}else {

  $valid = false;
  $error_html = "<h2>No message specified for editing</h2>";

}

$polldata    = poll_get($tid);
$pollresults = poll_get_votes($tid);

$valid = true;

if (isset($HTTP_POST_VARS['cancel'])) {

  $uri = "./discussion.php?msg=$edit_msg";
  header_redirect($uri);

}elseif (isset($HTTP_POST_VARS['preview']) || isset($HTTP_POST_VARS['submit'])) {

  if ($valid && strlen($HTTP_POST_VARS['answers'][1]) == 0) {
    $error_html = "<h2>You must specify values for answers 1 and 2</h2>";
    $valid = false;
  }

  if ($valid && strlen($HTTP_POST_VARS['answers'][2]) == 0) {
    $error_html = "<h2>You must specify values for answers 1 and 2</h2>";
    $valid = false;
  }

}

html_draw_top_script();

if ($valid && isset($HTTP_POST_VARS['preview'])) {

  $polldata['TLOGON'] = "ALL";
  $polldata['TNICK'] = "ALL";

  $preview_tuser = user_get($HTTP_COOKIE_VARS['bh_sess_uid']);

  $polldata['FLOGON']   = $preview_tuser['LOGON'];
  $polldata['FNICK']    = $preview_tuser['NICKNAME'];
  $polldata['FROM_UID'] = $preview_tuser['UID'];

  $polldata['CONTENT'] = "<br />\n";
  $polldata['CONTENT'].= "<table class=\"box\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\" width=\"475\">\n";
  $polldata['CONTENT'].= "  <tr>\n";
  $polldata['CONTENT'].= "    <td>\n";
  $polldata['CONTENT'].= "      <table width=\"95%\" align=\"center\">\n";
  $polldata['CONTENT'].= "        <tr>\n";
  $polldata['CONTENT'].= "          <td><h2>". thread_get_title($tid). "</h2></td>\n";
  $polldata['CONTENT'].= "        </tr>\n";
  $polldata['CONTENT'].= "        <tr>\n";
  $polldata['CONTENT'].= "          <td class=\"postbody\">\n";

  $pollresults = array();

  $max_value   = 0;
  $totalvotes  = 0;
  $optioncount = 0;

  for ($i = 1; $i <= sizeof($HTTP_POST_VARS['answers']); $i++) {

    if (strlen(trim($HTTP_POST_VARS['answers'][$i])) > 0) {

      if (isset($HTTP_POST_VARS['t_post_html']) && $HTTP_POST_VARS['t_post_html'] == 'Y') {
        $poll_option = fix_html($HTTP_POST_VARS['answers'][$i]);
      }else {
        $poll_option = make_html($HTTP_POST_VARS['answers'][$i]);
      }

      srand((double)microtime()*1000000);
      $poll_vote = rand(1, 10);

      if ($poll_vote > $max_value) $max_value = $poll_vote;

      $totalvotes += $poll_vote;
      $optioncount++;

      $pollresults[$i] = array('OPTION_ID' => $i, 'OPTION_NAME' => $poll_option, 'VOTES' => $poll_vote);

    }
  }

  if ($max_value > 0) {

    $horizontal_bar_width = floor((300 / $max_value));

    $vertical_bar_height = floor((200 / $max_value));
    $vertical_bar_width = floor((400 / $optioncount));

  }

  if ($HTTP_POST_VARS['polltype'] == 0) {

    $polldata['CONTENT'].= poll_horizontal_graph($pollresults, $horizontal_bar_width, $totalvotes);

  }else {

    $polldata['CONTENT'].= poll_vertical_graph($pollresults, $vertical_bar_height, $vertical_bar_width, $totalvotes);

  }

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
  $polldata['CONTENT'].= "<p class=\"postbody\" align=\"center\">Note: Poll votes are randomly generated for preview only.</p>\n";

}elseif ($valid && isset($HTTP_POST_VARS['submit'])) {

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
  }else {
    $poll_closes = false;
  }

  // Check HTML tick box, innit.

  for ($i = 1; $i <= sizeof($HTTP_POST_VARS['answers']); $i++) {
    if (isset($HTTP_POST_VARS['t_post_html']) && $HTTP_POST_VARS['t_post_html'] == 'Y') {
      $HTTP_POST_VARS['answers'][$i] = fix_html($HTTP_POST_VARS['answers'][$i]);
    }else {
      $HTTP_POST_VARS['answers'][$i] = make_html($HTTP_POST_VARS['answers'][$i]);
    }
  }

  poll_edit($tid, $HTTP_POST_VARS['answers'], $poll_closes, $HTTP_POST_VARS['changevote'], $HTTP_POST_VARS['polltype'], $HTTP_POST_VARS['showresults']);

  echo "<div align=\"center\">";
  echo "<p>Edit Applied to Poll $tid.$pid</p>";
  echo form_quick_button("discussion.php", "Continue", "msg", "$tid.$pid");
  echo "</div>";

  html_draw_bottom();
  exit;

}else {

  $polldata['TLOGON'] = "ALL";
  $polldata['TNICK'] = "ALL";

  $preview_tuser = user_get($polldata['FROM_UID']);

  $polldata['FLOGON']   = $preview_tuser['LOGON'];
  $polldata['FNICK']    = $preview_tuser['NICKNAME'];
  $polldata['FROM_UID'] = $preview_tuser['UID'];

  $polldata['CONTENT'] = "<br />\n";
  $polldata['CONTENT'].= "<table class=\"box\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\" width=\"475\">\n";
  $polldata['CONTENT'].= "  <tr>\n";
  $polldata['CONTENT'].= "    <td>\n";
  $polldata['CONTENT'].= "      <table width=\"95%\" align=\"center\">\n";
  $polldata['CONTENT'].= "        <tr>\n";
  $polldata['CONTENT'].= "          <td><h2>". thread_get_title($tid). "</h2></td>\n";
  $polldata['CONTENT'].= "        </tr>\n";
  $polldata['CONTENT'].= "        <tr>\n";
  $polldata['CONTENT'].= "          <td class=\"postbody\">\n";

  $max_value   = 0;
  $totalvotes  = 0;
  $optioncount = 0;

  for ($i = 1; $i <= sizeof($pollresults); $i++) {

    if (!empty($pollresults[$i]['OPTION_NAME'])) {

      if ($pollresults[$i]['VOTES'] > $max_value) $max_value = $pollresults[$i]['VOTES'];
      $optioncount++;

    }

  }

  if ($max_value > 0) {

    $horizontal_bar_width = floor((300 / $max_value));

    $vertical_bar_height = floor((200 / $max_value));
    $vertical_bar_width = floor((400 / $optioncount));

  }

  if ($polldata['SHOWRESULTS'] == 1) {

    if ($polldata['POLLTYPE'] == 0) {

      $polldata['CONTENT'].= poll_horizontal_graph($pollresults, $horizontal_bar_width, $totalvotes);

    }else {

      $polldata['CONTENT'].= poll_vertical_graph($pollresults, $vertical_bar_height, $vertical_bar_width, $totalvotes);

    }

  }else {

    $polldata['CONTENT'].= "            <ul>\n";

    foreach($pollresults as $pollquestion) {
      $polldata['CONTENT'].= "          <li>". $pollquestion['OPTION_NAME']. "</li>\n";
    }

    $polldata['CONTENT'].= "            </ul>\n";

  }

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

  if ($polldata['CHANGEVOTE'] == 1) {
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
  $polldata['CONTENT'].= "<p>&nbsp;</p>\n";

  if ($HTTP_COOKIE_VARS['bh_sess_uid'] != $polldata['FROM_UID'] && !perm_is_moderator()) {
    edit_refuse($tid, $pid);
    exit;
  }

}

if (isset($error_html)) echo $error_html;

echo "<form name=\"f_edit_poll\" action=\"", $HTTP_SERVER_VARS['PHP_SELF'], "\" method=\"POST\" target=\"_self\">\n";
echo form_input_hidden("t_msg", $edit_msg);
echo "<h2>Edit Poll: ", thread_get_title($tid), "</h2>\n";
//echo "<p><b>Note</b>: Editing any aspect of a poll will void all the current votes and allow people to vote again, regardless or not of the poll's ability to let them.</p>\n";

?>
  <table class="box" cellpadding="0" cellspacing="0" width="500">
    <tr>
      <td>
        <table border="0" class="posthead" width="500">
          <tr>
            <td><b>Note</b>: Editing any aspect of a poll will void all the current votes and allow people to vote again, regardless or not of the poll's ability to let them.</td>
          </tr>
          <tr>
            <td><hr /></td>
          </tr>
          <tr>
            <td><h2>Answers</h2></td>
          </tr>
          <tr>
            <td>
              <table class="posthead" cellpadding="0" cellspacing="0" width="500">
                <?php

                  $available_answers = array(5, 10, 15, 20);

                  if (isset($HTTP_POST_VARS['answercount'])) {
                    $answercount = $available_answers[$HTTP_POST_VARS['answercount']];
                    $answerselection = $HTTP_POST_VARS['answercount'];
                  }else {
                    if (sizeof($pollresults) <= 5) {
                      $answercount = 5;
                      $answerselection = 0;
                    }elseif (sizeof($pollresults) >= 10 && sizeof($pollresults) < 15) {
                      $answercount = 10;
                      $answerselection = 1;
                    }elseif (sizeof($pollresults) >= 15 && sizeof($pollresults) < 20) {
                      $answercount = 15;
                      $answerselection = 2;
                    }else {
                      $answercount = 20;
                      $answerselection = 3;
                    }
                  }

                ?>
                <tr>
                  <td>&nbsp;</td>
                  <td>No. Answers: <?php echo form_dropdown_array('answercount', range(0, 3), array('5', '10', '15', '20'), $answerselection), " ", form_submit("changecount", "Change")  ?></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <?php

                  for ($i = 1; $i <= $answercount; $i++) {

                    echo "<tr>\n";
                    echo "  <td>", $i, ". </td>\n";
                    echo "  <td>";

                    if (isset($HTTP_POST_VARS['answers'][$i])) {
                      echo form_input_text("answers[$i]", htmlspecialchars(_stripslashes($HTTP_POST_VARS['answers'][$i])), 40, 64);
                    }else {
                      if (isset($pollresults[$i]['OPTION_NAME'])) {
                        if (strip_tags($pollresults[$i]['OPTION_NAME']) != $pollresults[$i]['OPTION_NAME']) {
                          echo form_input_text("answers[$i]", htmlspecialchars($pollresults[$i]['OPTION_NAME']), 40, 64);
                        }else {
                          echo form_input_text("answers[$i]", $pollresults[$i]['OPTION_NAME'], 40, 64);
                        }
                      }else {
                        echo form_input_text("answers[$i]", '', 40, 64);
                      }
                    }

                    echo "  </td>\n";
                    echo "</tr>\n";

                  }

                ?>
                <tr>
                  <td>&nbsp;</td>
                  <td><?php echo form_checkbox("t_post_html", "Y", "Answers Contain HTML (not including signature)", (isset($HTTP_POST_VARS['t_post_html']) && $HTTP_POST_VARS['t_post_html'] == "Y")); ?></td>
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
                  <td><?php echo form_radio('changevote', '1', 'Yes', isset($HTTP_POST_VARS['changevote']) ? $HTTP_POST_VARS['changevote'] == 1 : $polldata['CHANGEVOTE'] == 1); ?></td>
                  <td><?php echo form_radio('changevote', '0', 'No', isset($HTTP_POST_VARS['changevote']) ? $HTTP_POST_VARS['changevote'] == 0 : $polldata['CHANGEVOTE'] == 0); ?></td>
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
            <td>How should the results of the poll be shown?</td>
          </tr>
          <tr>
            <td>
              <table border="0" width="300">
                <tr>
                  <td><?php echo form_radio('polltype', '0', 'Horizontal Bar graph', isset($HTTP_POST_VARS['polltype']) ? $HTTP_POST_VARS['polltype'] == 0 : $polldata['POLLTYPE'] == 0); ?></td>
                  <td><?php echo form_radio('polltype', '1', 'Vertical Bar graph', isset($HTTP_POST_VARS['polltype']) ? $HTTP_POST_VARS['polltype'] == 1 : $polldata['POLLTYPE'] == 1); ?></td>
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
            <td>Show results while the poll is open?</td>
          </tr>
          <tr>
            <td>
              <table border="0" width="300">
                <tr>
                  <td><?php echo form_radio('showresults', '1', 'Yes', isset($HTTP_POST_VARS['showresults']) ? $HTTP_POST_VARS['showresults'] == 1 : $polldata['SHOWRESULTS'] == 1); ?></td>
                  <td><?php echo form_radio('showresults', '0', 'No', isset($HTTP_POST_VARS['showresults']) ? $HTTP_POST_VARS['showresults'] == 0 : $polldata['SHOWRESULTS'] == 0); ?></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Change when the poll closes?</td>
          </tr>
          <tr>
            <td><?php echo form_dropdown_array('closepoll', range(0, 5), array('One Day', 'Three Days', 'Seven Days', 'Thirty Days', 'Never', 'No Change'), isset($HTTP_POST_VARS['closepoll']) ? $HTTP_POST_VARS['closepoll'] : 5); ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
<?php

  echo form_submit("submit", "Apply"). "&nbsp;". form_submit("preview", "Preview"). "&nbsp;". form_submit("cancel", "Cancel");

  if ($aid = get_attachment_id($tid, $pid)) {
    echo "&nbsp;".form_button("attachments", "Attachments", "onclick=\"window.open('edit_attachments.php?aid=". $aid. "', 'edit_attachments', 'width=640, height=300, toolbar=0, location=0, directories=0, status=0, menubar=0, resizable=0, scrollbars=yes');\"");
  }

  echo "</form>\n";

  if ($valid) {
    echo "<h2>Message Preview:</h2>";
    message_display(0, $polldata, 0, 0, false, false, false);
  }

  html_draw_bottom();

?>
