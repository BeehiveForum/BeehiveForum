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
require_once("./include/lang.inc.php");

if (isset($HTTP_GET_VARS['msg'])) {

  $edit_msg = $HTTP_GET_VARS['msg'];
  list($tid, $pid) = explode('.', $HTTP_GET_VARS['msg']);

}elseif (isset($HTTP_POST_VARS['t_msg'])) {

  $edit_msg = $HTTP_POST_VARS['t_msg'];
  list($tid, $pid) = explode('.', $HTTP_POST_VARS['t_msg']);

}else {

  html_draw_top();
  echo "<h1>{$lang['invalidop']}</h1>\n";
  echo "<h2>{$lang['nomessagespecifiedforedit']}</h2>";
  html_draw_bottom();
  exit;

}

$polldata    = poll_get($tid);
$pollresults = poll_get_votes($tid);

// Check if the user is viewing signatures.
$show_sigs = !(bh_session_get_value('VIEW_SIGS'));

$valid = true;

if (isset($HTTP_POST_VARS['cancel'])) {

  $uri = "./discussion.php?msg=$edit_msg";
  header_redirect($uri);

}elseif (isset($HTTP_POST_VARS['preview']) || isset($HTTP_POST_VARS['submit'])) {

  if ($valid && strlen($HTTP_POST_VARS['answers'][1]) == 0) {
    $error_html = "<h2>{$lang['mustspecifyvalues1and2']}</h2>";
    $valid = false;
  }

  if ($valid && strlen($HTTP_POST_VARS['answers'][2]) == 0) {
    $error_html = "<h2>{$lang['mustspecifyvalues1and2']}</h2>";
    $valid = false;
  }

}

html_draw_top_script();

if ($valid && isset($HTTP_POST_VARS['preview'])) {

  $polldata['TLOGON'] = "ALL";
  $polldata['TNICK'] = "ALL";

  $preview_tuser = user_get(bh_session_get_value('UID'));

  $polldata['FLOGON']   = $preview_tuser['LOGON'];
  $polldata['FNICK']    = $preview_tuser['NICKNAME'];
  $polldata['FROM_UID'] = $preview_tuser['UID'];

  $polldata['CONTENT'] = "<br />\n";
  $polldata['CONTENT'].= "<table class=\"box\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\" width=\"475\">\n";
  $polldata['CONTENT'].= "  <tr>\n";
  $polldata['CONTENT'].= "    <td>\n";
  $polldata['CONTENT'].= "      <table width=\"95%\" align=\"center\">\n";
  $polldata['CONTENT'].= "        <tr>\n";
  $polldata['CONTENT'].= "          <td><h2>". (isset($HTTP_POST_VARS['question']) ? _htmlentities(_stripslashes($HTTP_POST_VARS['question'])) : thread_get_title($tid)). "</h2></td>\n";
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

    $horizontal_bar_width = round(300 / $max_value, 2);
    $vertical_bar_height  = round(200 / $max_value, 2);
    $vertical_bar_width   = round(400 / $optioncount, 2);

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
    $polldata['CONTENT'].= "{$lang['abletochangevote']}";
  }else {
    $polldata['CONTENT'].= "{$lang['notabletochangevote']}";
  }

  $polldata['CONTENT'].= "          </td>";
  $polldata['CONTENT'].= "        </tr>\n";
  $polldata['CONTENT'].= "      </table>\n";
  $polldata['CONTENT'].= "    </td>";
  $polldata['CONTENT'].= "  </tr>\n";
  $polldata['CONTENT'].= "</table>\n";
  $polldata['CONTENT'].= "<p class=\"postbody\" align=\"center\">{$lang['pollvotesrandom']}</p>\n";

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
  }elseif ($HTTP_POST_VARS['closepoll'] == 5) {
    $poll_closes = -1;
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

  poll_edit($tid, $HTTP_POST_VARS['question'], $HTTP_POST_VARS['answers'], $poll_closes, $HTTP_POST_VARS['changevote'], $HTTP_POST_VARS['polltype'], $HTTP_POST_VARS['showresults']);

  echo "<div align=\"center\">";
  echo "<p>{$lang['editappliedtopoll']} $tid.$pid</p>";
  echo form_quick_button("discussion.php", $lang['continue'], "msg", "$tid.$pid");
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

    $horizontal_bar_width = round(300 / $max_value, 2);
    $vertical_bar_height  = round(200 / $max_value, 2);
    $vertical_bar_width   = round(400 / $optioncount, 2);

  }else {

    $horizontal_bar_width = 0;
    $vertical_bar_height = 0;
    $vertical_bar_width = round(400 / $optioncount, 2);

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
    $polldata['CONTENT'].= $lang['abletochangevote'];
  }else {
    $polldata['CONTENT'].= $lang['notabletochangevote'];
  }

  $polldata['CONTENT'].= "          </td>";
  $polldata['CONTENT'].= "        </tr>\n";
  $polldata['CONTENT'].= "      </table>\n";
  $polldata['CONTENT'].= "    </td>";
  $polldata['CONTENT'].= "  </tr>\n";
  $polldata['CONTENT'].= "</table>\n";
  $polldata['CONTENT'].= "<p><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></p>\n";

  if (bh_session_get_value('UID') != $polldata['FROM_UID'] && !perm_is_moderator()) {
    edit_refuse($tid, $pid);
    exit;
  }

}

if (isset($error_html)) echo $error_html;

echo "<form name=\"f_edit_poll\" action=\"", $HTTP_SERVER_VARS['PHP_SELF'], "\" method=\"POST\" target=\"_self\">\n";
echo form_input_hidden("t_msg", $edit_msg);
//echo "<h2>Edit Poll: ", thread_get_title($tid), "</h2>\n";
echo "<p>{$lang['editpollwarning']}</p>\n";

?>
  <table border="0" cellpadding="0" cellspacing="0" width="500">
    <tr>
      <td><h2><?php echo $lang['pollquestion'] ?></h2></td>
    </tr>
    <tr>
      <td><?php echo form_input_text("question", isset($HTTP_POST_VARS['question']) ? _htmlentities(_stripslashes($HTTP_POST_VARS['question'])) : thread_get_title($tid), 30, 64); ?></td>
    </tr>
    <tr>
      <td><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></td>
    </tr>
  </table>
  <table class="box" cellpadding="0" cellspacing="0" width="500">
    <tr>
      <td>
        <table border="0" class="posthead" width="500">
          <tr>
            <td><h2><?php echo $lang['possibleanswers'] ?></h2></td>
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
                    }elseif (sizeof($pollresults) > 5 && sizeof($pollresults) <= 10) {
                      $answercount = 10;
                      $answerselection = 1;
                    }elseif (sizeof($pollresults) > 10 && sizeof($pollresults) <= 15) {
                      $answercount = 15;
                      $answerselection = 2;
                    }elseif (sizeof($pollresults) > 15) {
                      $answercount = 20;
                      $answerselection = 3;
                    }
                  }

                ?>
                <tr>
                  <td><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></td>
                  <td><?php echo $lang['numberanswers'] ?>: <?php echo form_dropdown_array('answercount', range(0, 3), array('5', '10', '15', '20'), $answerselection), " ", form_submit("changecount", $lang['change'])  ?></td>
                </tr>
                <?php

                  for ($i = 1; $i <= $answercount; $i++) {

                    echo "<tr>\n";
                    echo "  <td>", $i, ". </td>\n";
                    echo "  <td>";

                    if (isset($HTTP_POST_VARS['answers'][$i])) {
                      echo form_input_text("answers[$i]", _htmlentities(_stripslashes($HTTP_POST_VARS['answers'][$i])), 40, 255);
                    }else {
                      if (isset($pollresults[$i]['OPTION_NAME'])) {
                        echo form_input_text("answers[$i]", _htmlentities(_stripslashes($pollresults[$i]['OPTION_NAME'])), 40, 255);
                      }else {
                        echo form_input_text("answers[$i]", '', 40, 255);
                      }
                    }

                    echo "  </td>\n";
                    echo "</tr>\n";

                  }

                  if (isset($HTTP_POST_VARS['t_post_html'])) {
                    if ($HTTP_POST_VARS['t_post_html'] == "Y") {
                      $t_post_html = true;
                    }else {
                      $t_post_html = false;
                    }
                  }else {
                    if (strip_tags($pollresults[1]['OPTION_NAME']) != $pollresults[1]['OPTION_NAME']) {
                      $t_post_html = true;
                    }else {
                      $t_post_html = false;
                    }
                  }

                ?>
                <tr>
                  <td><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></td>
                  <td><?php echo form_checkbox("t_post_html", "Y", $lang['answerscontainHTML'], $t_post_html); ?></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></td>
          </tr>
          <tr>
            <td><h2><?php echo $lang['votechanging'] ?></h2></td>
          </tr>
          <tr>
            <td><?php echo $lang['votechangingexp'] ?></td>
          </tr>
          <tr>
            <td>
              <table border="0" width="300">
                <tr>
                  <td><?php echo form_radio('changevote', '1', $lang['yes'], isset($HTTP_POST_VARS['changevote']) ? $HTTP_POST_VARS['changevote'] == 1 : $polldata['CHANGEVOTE'] == 1); ?></td>
                  <td><?php echo form_radio('changevote', '0', $lang['no'], isset($HTTP_POST_VARS['changevote']) ? $HTTP_POST_VARS['changevote'] == 0 : $polldata['CHANGEVOTE'] == 0); ?></td>
                  <td><?php echo form_radio('changevote', '2', $lang['allowmultiplevotes'], isset($HTTP_POST_VARS['changevote']) ? $HTTP_POST_VARS['changevote'] == 2 : $polldata['CHANGEVOTE'] == 2); ?></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></td>
          </tr>
          <tr>
            <td><h2><?php echo $lang['pollresults'] ?></h2></td>
          </tr>
          <tr>
            <td><?php echo $lang['pollresultsexp'] ?></td>
          </tr>
          <tr>
            <td>
              <table border="0" width="300">
                <tr>
                  <td><?php echo form_radio('polltype', '0', $lang['horizgraph'], isset($HTTP_POST_VARS['polltype']) ? $HTTP_POST_VARS['polltype'] == 0 : $polldata['POLLTYPE'] == 0); ?></td>
                  <td><?php echo form_radio('polltype', '1', $lang['vertgraph'], isset($HTTP_POST_VARS['polltype']) ? $HTTP_POST_VARS['polltype'] == 1 : $polldata['POLLTYPE'] == 1); ?></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></td>
          </tr>
          <tr>
            <td><h2><?php echo $lang['expiration'] ?></h2></td>
          </tr>
          <tr>
            <td><?php echo $lang['showresultswhileopen'] ?></td>
          </tr>
          <tr>
            <td>
              <table border="0" width="300">
                <tr>
                  <td><?php echo form_radio('showresults', '1', $lang['yes'], isset($HTTP_POST_VARS['showresults']) ? $HTTP_POST_VARS['showresults'] == 1 : $polldata['SHOWRESULTS'] == 1); ?></td>
                  <td><?php echo form_radio('showresults', '0', $lang['no'], isset($HTTP_POST_VARS['showresults']) ? $HTTP_POST_VARS['showresults'] == 0 : $polldata['SHOWRESULTS'] == 0); ?></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></td>
          </tr>
          <tr>
            <td><?php echo $lang['changewhenpollcloses']; ?></td>
          </tr>
          <tr>
            <td><?php echo form_dropdown_array('closepoll', range(0, 5), array($lang['oneday'], $lang['threedays'], $lang['sevendays'], $lang['thirtydays'], $lang['never'], $lang['nochange']), isset($HTTP_POST_VARS['closepoll']) ? $HTTP_POST_VARS['closepoll'] : 5); ?></td>
          </tr>
          <tr>
            <td><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
<?php

  echo form_submit("submit", $lang['apply']). "<bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo>". form_submit("preview", $lang['preview']). "<bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo>". form_submit("cancel", $lang['cancel']);

  if ($aid = get_attachment_id($tid, $pid)) {
    echo "<bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo>".form_button("attachments", $lang['attachments'], "onclick=\"window.open('edit_attachments.php?aid=". $aid. "', 'edit_attachments', 'width=640, height=300, toolbar=0, location=0, directories=0, status=0, menubar=0, resizable=0, scrollbars=yes');\"");
  }

  echo "</form>\n";

  $threaddata = thread_get($tid);

  if ($valid) {
    echo "<h2>{$lang['messagepreview']}:</h2>";
    message_display($tid, $polldata, $threaddata['LENGTH'], $pid, true, false, false, false, $show_sigs, true);
  }

  html_draw_bottom();

?>
