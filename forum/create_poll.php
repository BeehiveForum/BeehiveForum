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

/* $Id: create_poll.php,v 1.65 2004-01-14 20:42:26 decoyduck Exp $ */

// Compress the output
require_once("./include/gzipenc.inc.php");

// Enable the error handler
require_once("./include/errorhandler.inc.php");

//Check logged in status
require_once("./include/session.inc.php");
require_once("./include/header.inc.php");
require_once("./include/html.inc.php");
require_once("./include/constants.inc.php");

if(!bh_session_check()){
    $uri = "./logon.php?final_uri=". urlencode(get_request_uri());
    header_redirect($uri);
}

if(bh_session_get_value('UID') == 0) {
    html_guest_error();
    exit;
}

require_once("./include/constants.inc.php");
require_once("./include/folder.inc.php");
require_once("./include/form.inc.php");
require_once("./include/post.inc.php");
require_once("./include/poll.inc.php");
require_once("./include/lang.inc.php");

// Check to see if the forum owner has allowed the creation of polls

if (isset($allow_polls) && !$allow_polls) {
    html_draw_top();
    echo "<h1>{$lang['pollshavebeendisabled']}</h1>\n";
    html_draw_bottom();
    exit;
}

// Check that there are some available folders for this thread type

if (!folder_get_by_type_allowed(FOLDER_ALLOW_POLL_THREAD)) {
    html_message_type_error();
    exit;
}

// Check if the user is viewing signatures.
$show_sigs = !(bh_session_get_value('VIEW_SIGS'));

$valid = true;

if (isset($HTTP_POST_VARS['cancel'])) {

  $uri = "./discussion.php";
  header_redirect($uri);

}elseif (isset($HTTP_POST_VARS['preview']) || isset($HTTP_POST_VARS['submit'])) {

  $valid = true;

  if (strlen(trim($HTTP_POST_VARS['question'])) == 0) {
    $error_html = "<h2>{$lang['mustenterpollquestion']}</h2>";
    $valid = false;
  }

  if ($valid && !isset($HTTP_POST_VARS['t_fid'])) {
    $error_html = "<h2>{$lang['pleaseselectfolder']}</h2>";
    $valid = false;
  }

  if ($valid && !folder_thread_type_allowed($HTTP_POST_VARS['t_fid'], FOLDER_ALLOW_POLL_THREAD)) {
      $error_html = "<h2>{$lang['cannotpostthisthreadtypeinfolder']}</h2>";
      $valid = false;
  }

  if ($valid && strlen(trim($HTTP_POST_VARS['answers'][0])) == 0) {
    $error_html = "<h2>{$lang['mustspecifyvalues1and2']}</h2>";
    $valid = false;
  }

  if ($valid && strlen(trim($HTTP_POST_VARS['answers'][1])) == 0) {
    $error_html = "<h2>{$lang['mustspecifyvalues1and2']}</h2>";
    $valid = false;
  }

  if ($valid && $HTTP_POST_VARS['pollvotetype'] == 1 && $HTTP_POST_VARS['changevote']  == 2) {
    $error_html = "<h2>{$lang['cannotcreatemultivotepublicballot']}</h2>";
    $valid = false;
  }

  if (isset($HTTP_POST_VARS['t_message_html']) && $HTTP_POST_VARS['t_message_html'] == "Y") {
    $t_message_html = "Y";
  }else {
    $t_message_html = "N";
  }

  if (isset($HTTP_POST_VARS['t_sig_html']) && $HTTP_POST_VARS['t_sig_html'] == "Y") {
    $t_sig_html = "Y";
  }else {
    $t_sig_html = "N";
  }

  if (isset($HTTP_POST_VARS['t_message_text']) && strlen(trim($HTTP_POST_VARS['t_message_text'])) > 0) {

    $t_message_text = trim($HTTP_POST_VARS['t_message_text']);
    $t_message_test_check = preg_replace('/\&\#([0-9]+)\;/me', "chr('\\1')", rawurldecode($t_message_text));

    if (preg_match("/<.+(src|background|codebase|background-image)(=|s?:s?).+getattachment.php.+>/ ", $t_message_test_check) && $t_message_html == "Y") {
      $error_html = "<h2>{$lang['notallowedembedattachmentpost']}</h2>\n";
      $valid = false;
    }

  }else {
    $t_message_text = "";
  }

  if (isset($HTTP_POST_VARS['t_sig']) && strlen(trim($HTTP_POST_VARS['t_sig'])) > 0) {

    $t_sig = trim($HTTP_POST_VARS['t_sig']);
    $t_sig_check = preg_replace('/\&\#([0-9]+)\;/me', "chr('\\1')", rawurldecode($t_sig));

    if (preg_match("/<.+(src|background|codebase|background-image)(=|s?:s?).+getattachment.php.+>/ ", $t_sig_check) && $t_sig_html == "Y") {
      $error_html = "<h2>{$lang['notallowedembedattachmentpostsignature']}</h2>\n";
      $valid = false;
    }

  }else {
    $t_sig = "";
  }

  $answer_group_check = array();

  for ($i = 0; $i < sizeof($HTTP_POST_VARS['answer_groups']); $i++) {
      if (!in_array($HTTP_POST_VARS['answer_groups'][$i], $answer_group_check)) {
          $answer_group_check[] = $HTTP_POST_VARS['answer_groups'][$i];
      }
  }

  if ($valid && (sizeof($answer_group_check) >= sizeof($HTTP_POST_VARS['answers']))) {
    $error_html = "<h2>{$lang['groupcountmustbelessthananswercount']}</h2>";
    $valid = false;
  }
}

if ($valid) {

    if (isset($t_message_html) && $t_message_html == "Y") {
        $t_message_text = fix_html($t_message_text);
    }

    if (isset($t_sig)) {
        if($t_sig_html == "Y") {
            $t_sig = fix_html($t_sig);
        }
    }

}else {

    if ($t_message_html == "Y") {
        $t_message_text = _stripslashes($t_message_text);
    }

    if (isset($t_sig)) {
        if($t_sig_html == "Y") {
          $t_sig = _stripslashes($t_sig);
        }
    }
}

if ($valid && isset($HTTP_POST_VARS['submit'])) {

  if (check_ddkey($HTTP_POST_VARS['t_dedupe'])) {

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
      $poll_closes = false;
    }

    // Check HTML tick box, innit.

    for ($i = 0; $i < sizeof($HTTP_POST_VARS['answers']); $i++) {
      if (isset($HTTP_POST_VARS['t_post_html']) && $HTTP_POST_VARS['t_post_html'] == 'Y') {
        $HTTP_POST_VARS['answers'][$i] = fix_html($HTTP_POST_VARS['answers'][$i]);
      }else {
        $HTTP_POST_VARS['answers'][$i] = make_html($HTTP_POST_VARS['answers'][$i]);
      }
    }

    $HTTP_POST_VARS['question'] = trim($HTTP_POST_VARS['question']);

    // Create the poll thread with the poll_flag set to Y and sticky flag set to N

    $t_tid = post_create_thread($HTTP_POST_VARS['t_fid'], $HTTP_POST_VARS['question'], 'Y', 'N');
    $t_pid = post_create($t_tid, 0, bh_session_get_value('UID'), 0, '');

    poll_create($t_tid, $HTTP_POST_VARS['answers'], $HTTP_POST_VARS['answer_groups'], $poll_closes, $HTTP_POST_VARS['changevote'], $HTTP_POST_VARS['polltype'], $HTTP_POST_VARS['showresults'], $HTTP_POST_VARS['pollvotetype']);

    if (get_num_attachments($HTTP_POST_VARS['aid']) > 0) post_save_attachment_id($t_tid, $pid, $HTTP_POST_VARS['aid']);

    if (strlen($t_message_text) > 0) {

      if($t_message_html != "Y") $t_message_text = make_html($t_message_text);

      if ($t_sig) {

        if($t_sig_html != "Y") $t_sig = make_html($t_sig);
        $t_message_text.= "\n<div class=\"sig\">$t_sig</div>";

      }

      post_create($t_tid, 1, bh_session_get_value('UID'), 0, $t_message_text);

    }

    if (bh_session_get_value('MARK_AS_OF_INT')) thread_set_interest($t_tid, 1, true);

  }

  if (isset($t_tid) && $t_tid > 0) {

    $uri = "./discussion.php?msg=$t_tid.1";

  }else {

    $uri = "./discussion.php";
  }

  header_redirect($uri);

}

html_draw_top("basetarget=_blank", "openprofile.js");

echo "<h1>{$lang['createpoll']}</h1>\n";

if (!isset($HTTP_POST_VARS['aid'])) {
  $aid = md5(uniqid(rand()));
}else{
  $aid = $HTTP_POST_VARS['aid'];
}

if ($valid && isset($HTTP_POST_VARS['preview'])) {

  echo "<h2>{$lang['preview']}:</h2>";

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
  $polldata['CONTENT'].= "          <td><h2>". _stripslashes($HTTP_POST_VARS['question']). "</h2></td>\n";
  $polldata['CONTENT'].= "        </tr>\n";
  $polldata['CONTENT'].= "        <tr>\n";
  $polldata['CONTENT'].= "          <td class=\"postbody\">\n";

  $pollresults = array();

  $max_value   = 0;
  $totalvotes  = 0;
  $optioncount = 0;

  foreach($HTTP_POST_VARS['answers'] as $key => $answer_text) {

      if (strlen(trim($answer_text)) > 0) {

          if (isset($HTTP_POST_VARS['t_post_html']) && $HTTP_POST_VARS['t_post_html'] == 'Y') {
              $poll_answers_array[$key] = fix_html($answer_text);
          }else {
              $poll_answers_array[$key] = make_html($answer_text);
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
    $polldata['CONTENT'].= $lang['abletochangevote'];
  }elseif ($HTTP_POST_VARS['changevote'] == 2) {
    $polldata['CONTENT'].= $lang['abletovotemultiple'];
  }else {
    $polldata['CONTENT'].= $lang['notabletochangevote'];
  }

  $polldata['CONTENT'].= "          </td>";
  $polldata['CONTENT'].= "        </tr>\n";
  $polldata['CONTENT'].= "      </table>\n";
  $polldata['CONTENT'].= "    </td>";
  $polldata['CONTENT'].= "  </tr>\n";
  $polldata['CONTENT'].= "</table>\n";
  $polldata['CONTENT'].= "<p class=\"postbody\" align=\"center\">{$lang['pollvotesrandom']}</p>\n";

  message_display(0, $polldata, 0, 0, false, false, false, true, $show_sigs, true);

  if (strlen($t_message_text) > 0) {

    if($t_message_html != "Y") {
      $polldata['CONTENT'] = make_html($t_message_text);
    }else{
      $polldata['CONTENT'] = _stripslashes($t_message_text);
    }

    if ($t_sig) {
      if ($t_sig_html != "Y") {
        $preview_sig = make_html($t_sig);
      }else{
        $preview_sig = $t_sig;
      }
      $polldata['CONTENT'].= "<div class=\"sig\">". $preview_sig. "</div>";
    }else{
      $t_sig = " ";
    }

    message_display(0, $polldata, 0, 0, false, false, false, true, $show_sigs, true);

  }
}

if(isset($error_html)) echo $error_html. "\n";

?>
<form name="f_poll" action="./create_poll.php" method="post" target="_self">
<?php

if(isset($HTTP_POST_VARS['t_dedupe'])) {
    echo form_input_hidden("t_dedupe", $HTTP_POST_VARS['t_dedupe']);
}else{
    echo form_input_hidden("t_dedupe", date("YmdHis"));
}

if(!isset($t_sig) || !$t_sig) {
    $has_sig = user_get_sig(bh_session_get_value('UID'), $t_sig, $t_sig_html);
}else{
    $has_sig = true;
}

if (isset($t_message_html) && $t_message_html != "Y") {
    $t_message_text = isset($t_message_text) ? _stripslashes($t_message_text) : "";
}

if (isset($HTTP_GET_VARS['fid']) && is_numeric($HTTP_GET_VARS['fid'])) {
    $t_fid = $HTTP_GET_VARS['fid'];
}elseif(isset($HTTP_POST_VARS['t_fid']) && is_numeric($HTTP_POST_VARS['t_fid'])) {
    $t_fid = $HTTP_POST_VARS['t_fid'];
}else {
    $t_fid = 1;
}

?>
  <table border="0" cellpadding="0" cellspacing="0" width="500">
    <tr>
      <td><h2><?php echo $lang['selectfolder']; ?></h2></td>
    </tr>
    <tr>
      <td><?php echo folder_draw_dropdown($t_fid,"t_fid","",FOLDER_ALLOW_POLL_THREAD); ?></td>
    </tr>
    <tr>
      <td><h2><?php echo $lang['pollquestion']; ?></h2></td>
    </tr>
    <tr>
      <td><?php echo form_input_text("question", isset($HTTP_POST_VARS['question']) ? _htmlentities(_stripslashes($HTTP_POST_VARS['question'])) : '', 30, 64); ?>&nbsp;</bdo><?php echo form_submit("submit", $lang['post']); ?></td>
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
            <td><h2><?php echo $lang['possibleanswers']; ?></h2></td>
          </tr>
          <tr>
            <td><?php echo $lang['enterpollquestionexp']; ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>
              <table border="0" class="posthead" cellpadding="0" cellspacing="5">
                <tr>
                  <td>&nbsp;</td>
                  <td><?php echo $lang['numberanswers'].": ".form_dropdown_array('answercount', range(0, 3), array('5', '10', '15', '20'), isset($HTTP_POST_VARS['answercount']) ? $HTTP_POST_VARS['answercount'] : 0), " ", form_submit("changecount", $lang['change'])  ?></td>
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

                  $available_answers = array(5, 10, 15, 20);

                  if (isset($HTTP_POST_VARS['answercount'])) {
                    $answercount = $available_answers[$HTTP_POST_VARS['answercount']];
                  }else {
                    $answercount = 5;
                  }

                  for ($i = 0; $i < $answercount; $i++) {

                    echo "<tr>\n";
                    echo "  <td>", $i + 1, ". </td>\n";
                    echo "  <td>", form_input_text("answers[]", isset($HTTP_POST_VARS['answers'][$i]) ? _htmlentities(_stripslashes($HTTP_POST_VARS['answers'][$i])) : '', 40, 255), "</td>\n";
                    echo "  <td align=\"center\">", form_dropdown_array("answer_groups[]", range(1, $answercount), range(1, $answercount), (isset($HTTP_POST_VARS['answer_groups'][$i])) ? $HTTP_POST_VARS['answer_groups'][$i] : 1), "</td>\n";
                    echo "  <td>&nbsp;</td>\n";
                    echo "</tr>\n";

                  }

                ?>
                <tr>
                  <td>&nbsp;</td>
                  <td><?php echo form_checkbox("t_post_html", "Y", $lang['answerscontainHTML'], (isset($HTTP_POST_VARS['t_post_html']) && $HTTP_POST_VARS['t_post_html'] == "Y")); ?></td>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><h2><?php echo $lang['votechanging']; ?></h2></td>
          </tr>
          <tr>
            <td><?php echo $lang['votechangingexp']; ?></td>
          </tr>
          <tr>
            <td>
              <table border="0" width="500">
                <tr>
                  <td width="25%"><?php echo form_radio('changevote', '1', $lang['yes'], isset($HTTP_POST_VARS['changevote']) ? $HTTP_POST_VARS['changevote'] == 1 : true); ?></td>
                  <td width="25%"><?php echo form_radio('changevote', '0', $lang['no'], isset($HTTP_POST_VARS['changevote']) ? $HTTP_POST_VARS['changevote'] == 0 : false); ?></td>
                  <td><?php echo form_radio('changevote', '2', $lang['allowmultiplevotes'], isset($HTTP_POST_VARS['changevote']) ? $HTTP_POST_VARS['changevote'] == 2 : false); ?></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><h2><?php echo $lang['pollresults']; ?></h2></td>
          </tr>
          <tr>
            <td><?php echo $lang['pollresultsexp']; ?></td>
          </tr>
          <tr>
            <td>
              <table border="0" width="400">
                <tr>
                  <td width="50%"><?php echo form_radio('polltype', '0', $lang['horizgraph'], isset($HTTP_POST_VARS['polltype']) ? $HTTP_POST_VARS['polltype'] == 0 : true); ?></td>
                  <td width="50%"><?php echo form_radio('polltype', '1', $lang['vertgraph'], isset($HTTP_POST_VARS['polltype']) ? $HTTP_POST_VARS['polltype'] == 1 : false); ?></td>
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
                  <td width="50%"><?php echo form_radio('pollvotetype', '0', $lang['pollvoteanon'], isset($HTTP_POST_VARS['pollvotetype']) ? $HTTP_POST_VARS['pollvotetype'] == 0 : true); ?></td>
                  <td width="50%"><?php echo form_radio('pollvotetype', '1', $lang['pollvotepub'], isset($HTTP_POST_VARS['pollvotetype']) ? $HTTP_POST_VARS['pollvotetype'] == 1 : false); ?></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><h2><?php echo $lang['expiration']; ?></h2></td>
          </tr>
          <tr>
            <td><?php echo $lang['showresultswhileopen']; ?></td>
          </tr>
          <tr>
            <td>
              <table border="0" width="400">
                <tr>
                  <td width="50%"><?php echo form_radio('showresults', '1', $lang['yes'], isset($HTTP_POST_VARS['showresults']) ? $HTTP_POST_VARS['showresults'] == 1 : true); ?></td>
                  <td width="50%"><?php echo form_radio('showresults', '0', $lang['no'], isset($HTTP_POST_VARS['showresults']) ? $HTTP_POST_VARS['showresults'] == 0 : false); ?></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><?php echo $lang['whenlikepollclose']; ?></td>
          </tr>
          <tr>
            <td><?php echo form_dropdown_array('closepoll', range(0, 4), array($lang['oneday'], $lang['threedays'], $lang['sevendays'], $lang['thirtydays'], $lang['never']), isset($HTTP_POST_VARS['closepoll']) ? $HTTP_POST_VARS['closepoll'] : 4); ?></td>
          </tr>
          <tr>
            <td><hr /></td>
          </tr>
          <tr>
            <td><h2><?php echo $lang['polladditionalmessage']; ?></h2></td>
          </tr>
          <tr>
            <td><?php echo $lang['polladditionalmessageexp']; ?></td>
          </tr>
          <tr>
            <td><?php echo form_textarea("t_message_text", (isset($t_message_html)) ? _htmlentities($t_message_text) : "", 15, 75); ?></td>
          </tr>
          <tr>
            <td><?php echo $lang['signature']; ?>:<br /><?php echo form_textarea("t_sig", _htmlentities($t_sig), 5, 75), form_input_hidden("t_sig_html", $t_sig_html); ?></td>
          </tr>
          <tr>
            <td><?php echo form_checkbox("t_message_html", "Y", "{$lang['messagecontainsHTML']} {$lang['notincludingsignature']}", (isset($HTTP_POST_VARS['t_message_html']) && $HTTP_POST_VARS['t_message_html'] == "Y")); ?></td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
<?php

    echo form_submit("submit", $lang['post']). "&nbsp;</bdo>". form_submit("preview", $lang['preview']). "&nbsp;</bdo>". form_submit("cancel", $lang['cancel']);

    if ($attachments_enabled) {

      echo "&nbsp;</bdo>".form_button("attachments", $lang['attachments'], "onclick=\"window.open('attachments.php?aid=". $aid. "', 'attachments', 'width=640, height=480, toolbar=0, location=0, directories=0, status=0, menubar=0, resizable=0, scrollbars=yes');\"");
      echo form_input_hidden("aid", $aid);

    }

    echo "</form>\n";

    html_draw_bottom();

?>