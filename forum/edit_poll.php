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

/* $Id: edit_poll.php,v 1.45 2004-03-13 20:04:34 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

//Multiple forum support
include_once("./include/forum.inc.php");

include_once("./include/edit.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/messages.inc.php");
include_once("./include/poll.inc.php");
include_once("./include/post.inc.php");
include_once("./include/session.inc.php");

if (!$user_sess = bh_session_check()) {

    $uri = "./logon.php?webtag={$webtag['WEBTAG']}&final_uri=". urlencode(get_request_uri());
    header_redirect($uri);
}

// Load the wordfilter for the current user

$user_wordfilter = load_wordfilter();

if (isset($allow_polls) && !$allow_polls) {
    html_draw_top();
    echo "<h1>{$lang['pollshavebeendisabled']}</h1>\n";
    html_draw_bottom();
    exit;
}

if (isset($HTTP_GET_VARS['msg']) && validate_msg($HTTP_GET_VARS['msg'])) {

  list($edit_msg) = explode(' ', rawurldecode($HTTP_GET_VARS['msg']));
  list($tid, $pid) = explode('.', $edit_msg);

}elseif (isset($HTTP_POST_VARS['t_msg']) && validate_msg($HTTP_POST_VARS['t_msg'])) {

  list($edit_msg) = explode(' ', rawurldecode($HTTP_POST_VARS['t_msg']));
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

  $uri = "./discussion.php?webtag={$webtag['WEBTAG']}&msg=$edit_msg";
  header_redirect($uri);

}elseif (isset($HTTP_POST_VARS['preview']) || isset($HTTP_POST_VARS['submit'])) {

  if ($valid && strlen(trim($HTTP_POST_VARS['answers'][0])) == 0) {
    $error_html = "<h2>{$lang['mustspecifyvalues1and2']}</h2>";
    $valid = false;
  }

  if ($valid && strlen(trim($HTTP_POST_VARS['answers'][1])) == 0) {
    $error_html = "<h2>{$lang['mustspecifyvalues1and2']}</h2>";
    $valid = false;
  }

}

html_draw_top("openprofile.js");

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

  $poll_answers_array = array();
  $poll_groups_array  = array();
  $poll_votes_array   = array();

  $max_value   = 0;
  $totalvotes  = 0;
  $optioncount = 0;

  foreach($HTTP_POST_VARS['answers'] as $key => $answer_text) {

      if (strlen(trim($answer_text)) > 0) {

          if (isset($HTTP_POST_VARS['t_post_html']) && $HTTP_POST_VARS['t_post_html'] == 'Y') {
              $poll_answers_array[$key] = fix_html($answer_text);
          }else {
              $poll_answers_array[$key] = make_html($answer_text, true);
          }

          srand((double)microtime()*1000000);
          $poll_vote = rand(1, 10);

          if ($poll_vote > $max_value) $max_value = $poll_vote;

          $poll_votes_array[] = $poll_vote;
          $totalvotes += $poll_vote;
          $optioncount++;

      }else {

          unset($HTTP_POST_VARS['answers'][$key]);
          unset($HTTP_POST_VARS['answer_groups'][$key]);
      }
  }

  $poll_groups_array = $HTTP_POST_VARS['answer_groups'];

  // Construct the pollresults array that will be used to display the graph
  // Modified to handle the new Group ID.

  $pollresults = array('OPTION_ID'   => array_keys($poll_answers_array),
                       'OPTION_NAME' => $poll_answers_array,
                       'GROUP_ID'    => $poll_groups_array,
                       'VOTES'       => $poll_votes_array);

  if ($HTTP_POST_VARS['polltype'] == 1) {

    $polldata['CONTENT'].= poll_preview_graph_vert($pollresults);

  }else {

    $polldata['CONTENT'].= poll_preview_graph_horz($pollresults);
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
    $poll_closes = -1;
  }else {
    $poll_closes = false;
  }

  // Check HTML tick box, innit.

  for ($i = 0; $i < sizeof($HTTP_POST_VARS['answers']); $i++) {
    if (isset($HTTP_POST_VARS['t_post_html']) && $HTTP_POST_VARS['t_post_html'] == 'Y') {
      $HTTP_POST_VARS['answers'][$i] = fix_html($HTTP_POST_VARS['answers'][$i]);
    }else {
      $HTTP_POST_VARS['answers'][$i] = make_html($HTTP_POST_VARS['answers'][$i], true);
    }
  }

  poll_edit($tid, $HTTP_POST_VARS['question'], $HTTP_POST_VARS['answers'], $HTTP_POST_VARS['answer_groups'], $poll_closes, $HTTP_POST_VARS['changevote'], $HTTP_POST_VARS['polltype'], $HTTP_POST_VARS['showresults'], $HTTP_POST_VARS['pollvotetype']);
  post_add_edit_text($tid, 1);

  if (isset($HTTP_POST_VARS['aid']) && isset($attachments_enabled) && $attachments_enabled) {
    if (get_num_attachments($HTTP_POST_VARS['aid']) > 0) post_save_attachment_id($tid, $pid, $HTTP_POST_VARS['aid']);
  }  
  
  header_redirect("./discussion.php?webtag={$webtag['WEBTAG']}&msg=$tid.1");

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

  /*
  $max_value   = 0;
  $totalvotes  = 0;
  $optioncount = 0;

  for ($i = 0; $i < sizeof($pollresults['OPTION_ID']); $i++) {

    if (strlen(trim($pollresults['OPTION_NAME'][$i])) > 0) {

      if ($pollresults['VOTES'][$i] > $max_value) $max_value = $pollresults['VOTES'][$i];
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

  } */

  if ($polldata['SHOWRESULTS'] == 1) {

    if ($polldata['POLLTYPE'] == 1) {

      $polldata['CONTENT'].= poll_preview_graph_vert($pollresults);

    }else {

      $polldata['CONTENT'].= poll_preview_graph_horz($pollresults);
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
  $polldata['CONTENT'].= "<p>&nbsp;</p>\n";

  if (bh_session_get_value('UID') != $polldata['FROM_UID'] && !perm_is_moderator()) {
    edit_refuse($tid, $pid);
    exit;
  }

}

if (isset($error_html)) echo $error_html;

echo "<form name=\"f_edit_poll\" action=\"edit_poll.php?webtag={$webtag['WEBTAG']}\" method=\"POST\" target=\"_self\">\n";
echo form_input_hidden("t_msg", $edit_msg);
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
      <td>&nbsp;</td>
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
              <table border="0" class="posthead" cellpadding="0" cellspacing="0">
                <?php

                  $available_answers = array(5, 10, 15, 20);

                  if (isset($HTTP_POST_VARS['answercount'])) {
                    $answercount = $available_answers[$HTTP_POST_VARS['answercount']];
                    $answerselection = $HTTP_POST_VARS['answercount'];
                  }else {
                    if (sizeof($pollresults['OPTION_ID']) <= 5) {
                      $answercount = 5;
                      $answerselection = 0;
                    }elseif (sizeof($pollresults['OPTION_ID']) > 5 && sizeof($pollresults['OPTION_ID']) <= 10) {
                      $answercount = 10;
                      $answerselection = 1;
                    }elseif (sizeof($pollresults['OPTION_ID']) > 10 && sizeof($pollresults['OPTION_ID']) <= 15) {
                      $answercount = 15;
                      $answerselection = 2;
                    }elseif (sizeof($pollresults['OPTION_ID']) > 15) {
                      $answercount = 20;
                      $answerselection = 3;
                    }
                  }

                ?>
                <tr>
                  <td>&nbsp;</td>
                  <td><?php echo $lang['numberanswers'] ?>: <?php echo form_dropdown_array('answercount', range(0, 3), array('5', '10', '15', '20'), $answerselection), " ", form_submit("changecount", $lang['change'])  ?></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>Answer Text</td>
                  <td align="center">Answer Group</td>
                  <td>&nbsp;</td>
                </tr>
                <?php

                  $t_post_html = false;
                  
                  if (isset($HTTP_POST_VARS['t_post_html'])) {
                    if ($HTTP_POST_VARS['t_post_html'] == "Y") {
                      $t_post_html = true;
                    }else {
                      $t_post_html = false;
                    }
                  }

                  for ($i = 0; $i < $answercount; $i++) {

                    echo "<tr>\n";
                    echo "  <td>", ($i + 1), ". </td>\n";
                    echo "  <td>";

                    if (isset($HTTP_POST_VARS['answers'][$i])) {
                      echo form_input_text("answers[$i]", _htmlentities(_stripslashes($HTTP_POST_VARS['answers'][$i])), 40, 255);
                    }else {
                      if (isset($pollresults['OPTION_NAME'][$i])) {
                        if (strip_tags($pollresults['OPTION_NAME'][$i]) != $pollresults['OPTION_NAME'][$i]) {
                          if (!isset($HTTP_POST_VARS['t_post_html'])) $t_post_html = true;
                          echo form_input_text("answers[$i]", _htmlentities(_stripslashes($pollresults['OPTION_NAME'][$i])), 40, 255);
                        }else {
                          echo form_input_text("answers[$i]", _stripslashes($pollresults['OPTION_NAME'][$i]), 40, 255);
                        }
                      }else {
                        echo form_input_text("answers[$i]", '', 40, 255);
                      }
                    }

                    echo "  </td>\n";
                    echo "  <td align=\"center\">";

                    if (isset($HTTP_POST_VARS['answer_groups'][$i])) {
                      echo form_dropdown_array("answer_groups[]", range(1, $answercount), range(1, $answercount), $HTTP_POST_VARS['answer_groups'][$i]), "</td>\n";
                    }else {
                      if (isset($pollresults['GROUP_ID'][$i])) {
                        echo form_dropdown_array("answer_groups[]", range(1, $answercount), range(1, $answercount), $pollresults['GROUP_ID'][$i]), "</td>\n";
                      }else {
                        echo form_dropdown_array("answer_groups[]", range(1, $answercount), range(1, $answercount), 1), "</td>\n";
                      }
                    }

                    echo "  <td>&nbsp;</td>\n";
                    echo "</tr>\n";

                  }

                ?>
                <tr>
                  <td>&nbsp;</td>
                  <td><?php echo form_checkbox("t_post_html", "Y", $lang['answerscontainHTML'], $t_post_html); ?></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><h2><?php echo $lang['votechanging'] ?></h2></td>
          </tr>
          <tr>
            <td><?php echo $lang['votechangingexp'] ?></td>
          </tr>
          <tr>
            <td>
              <table border="0" width="500">
                <tr>
                  <td width="25%"><?php echo form_radio('changevote', '1', $lang['yes'], isset($HTTP_POST_VARS['changevote']) ? $HTTP_POST_VARS['changevote'] == 1 : $polldata['CHANGEVOTE'] == 1); ?></td>
                  <td width="25%"><?php echo form_radio('changevote', '0', $lang['no'], isset($HTTP_POST_VARS['changevote']) ? $HTTP_POST_VARS['changevote'] == 0 : $polldata['CHANGEVOTE'] == 0); ?></td>
                  <td><?php echo form_radio('changevote', '2', $lang['allowmultiplevotes'], isset($HTTP_POST_VARS['changevote']) ? $HTTP_POST_VARS['changevote'] == 2 : $polldata['CHANGEVOTE'] == 2); ?></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><h2><?php echo $lang['pollresults'] ?></h2></td>
          </tr>
          <tr>
            <td><?php echo $lang['pollresultsexp'] ?></td>
          </tr>
          <tr>
            <td>
              <table border="0" width="400">
                <tr>
                  <td width="50%"><?php echo form_radio('polltype', '0', $lang['horizgraph'], isset($HTTP_POST_VARS['polltype']) ? $HTTP_POST_VARS['polltype'] == 0 : $polldata['POLLTYPE'] == 0); ?></td>
                  <td width="50%"><?php echo form_radio('polltype', '1', $lang['vertgraph'], isset($HTTP_POST_VARS['polltype']) ? $HTTP_POST_VARS['polltype'] == 1 : $polldata['POLLTYPE'] == 1); ?></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><h2><?php echo $lang['pollvotetype']; ?></h2></td>
          </tr>
          <tr>
            <td><?php echo $lang['pollvotesexp']; ?></td>
          </tr>
          <tr>
            <td>
              <table border="0" width="400">
                <tr>
                  <td width="50%"><?php echo form_radio('pollvotetype', '0', $lang['pollvoteanon'], isset($HTTP_POST_VARS['pollvotetype']) ? $HTTP_POST_VARS['pollvotetype'] == 0 : $polldata['VOTETYPE'] == 0); ?></td>
                  <td width="50%"><?php echo form_radio('pollvotetype', '1', $lang['pollvotepub'], isset($HTTP_POST_VARS['pollvotetype']) ? $HTTP_POST_VARS['pollvotetype'] == 1 : $polldata['VOTETYPE'] == 1); ?></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
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
                  <td width="50%"><?php echo form_radio('showresults', '1', $lang['yes'], isset($HTTP_POST_VARS['showresults']) ? $HTTP_POST_VARS['showresults'] == 1 : $polldata['SHOWRESULTS'] == 1); ?></td>
                  <td width="50%"><?php echo form_radio('showresults', '0', $lang['no'], isset($HTTP_POST_VARS['showresults']) ? $HTTP_POST_VARS['showresults'] == 0 : $polldata['SHOWRESULTS'] == 0); ?></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><?php echo $lang['changewhenpollcloses']; ?></td>
          </tr>
          <tr>
            <td><?php echo form_dropdown_array('closepoll', range(0, 5), array($lang['oneday'], $lang['threedays'], $lang['sevendays'], $lang['thirtydays'], $lang['never'], $lang['nochange']), isset($HTTP_POST_VARS['closepoll']) ? $HTTP_POST_VARS['closepoll'] : 5); ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
<?php

  echo form_submit("submit", $lang['apply']). "&nbsp;". form_submit("preview", $lang['preview']). "&nbsp;". form_submit("cancel", $lang['cancel']);

  if ($aid = get_attachment_id($tid, $pid)) {
    echo "&nbsp;", form_button("attachments", $lang['attachments'], "onclick=\"launchAttachEditWin('$aid');\"");
    echo form_input_hidden('aid', $aid);
  }else {
    $aid = md5(uniqid(rand()));
    echo "&nbsp;", form_button("attachments", $lang['attachments'], "onclick=\"launchAttachEditWin('$aid');\"");
    echo form_input_hidden('aid', $aid);
  }

  echo "</form>\n";

  $threaddata = thread_get($tid);

  if ($valid) {
    echo "<h2>{$lang['messagepreview']}:</h2>";
    message_display($tid, $polldata, $threaddata['LENGTH'], $pid, true, false, false, false, $show_sigs, true);
  }

  html_draw_bottom();

?>