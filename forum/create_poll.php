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

/* $Id: create_poll.php,v 1.44 2003-08-10 17:30:51 decoyduck Exp $ */

// Enable the error handler
require_once("./include/errorhandler.inc.php");

// Compress the output
require_once("./include/gzipenc.inc.php");

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

  $t_sig = (isset($HTTP_POST_VARS['t_sig'])) ? $HTTP_POST_VARS['t_sig'] : "";
  $t_sig_html = (isset($HTTP_POST_VARS['t_sig_html'])) ? $HTTP_POST_VARS['t_sig_html'] : "";
  $t_message_text = (isset($HTTP_POST_VARS['t_message_text'])) ? $HTTP_POST_VARS['t_message_text'] : "";

}

$t_message_html = (isset($HTTP_POST_VARS['t_message_html'])) ? $HTTP_POST_VARS['t_message_html'] : "";

if ($valid) {

    if($t_message_html == "Y") {
        $t_message_text = fix_html($t_message_text);
    }

    if(isset($t_sig)) {
        if($t_sig_html == "Y") {
            $t_sig = fix_html($t_sig);
        }
    }

}else {

    if($t_message_html == "Y") {
        $t_message_text = _stripslashes($t_message_text);
    }

    if(isset($t_sig)) {
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

    $tid = post_create_thread($HTTP_POST_VARS['t_fid'], $HTTP_POST_VARS['question'], 'Y', 'N');
    $pid = post_create($tid, 0, bh_session_get_value('UID'), 0, '');

    poll_create($tid, $HTTP_POST_VARS['answers'], $poll_closes, $HTTP_POST_VARS['changevote'], $HTTP_POST_VARS['polltype'], $HTTP_POST_VARS['showresults'], $HTTP_POST_VARS['pollvotetype']);

    if (get_num_attachments($HTTP_POST_VARS['aid']) > 0) post_save_attachment_id($tid, $pid, $HTTP_POST_VARS['aid']);

    if (strlen($t_message_text) > 0) {

      if($t_message_html != "Y") $t_message_text = make_html($t_message_text);

      if($t_sig) {

        if($t_sig_html != "Y") $t_sig = make_html($t_sig);
        $t_message_text.= "\n<div class=\"sig\">". $t_sig. "</div>";

      }

      post_create($tid, 1, bh_session_get_value('UID'), 0, $t_message_text);

    }

    if (bh_session_get_value('MARK_AS_OF_INT')) thread_set_interest($tid, 1, true);

  }

  $uri = "./discussion.php?msg=$tid.1";
  header_redirect($uri);

}

html_draw_top_script();
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

  for ($i = 0; $i < sizeof($HTTP_POST_VARS['answers']); $i++) {

    if (isset($HTTP_POST_VARS['answers'][$i]) && strlen(trim($HTTP_POST_VARS['answers'][$i])) > 0) {

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

      $pollresults[$i + 1] = array('OPTION_ID' => $i + 1, 'OPTION_NAME' => $poll_option, 'VOTES' => $poll_vote);

    }
  }

  if ($max_value > 0) {

    $horizontal_bar_width = round(300 / $max_value, 2);
    $vertical_bar_height = round(200 / $max_value, 2);
    $vertical_bar_width = round(400 / $optioncount, 2);

  }else {

    $horizontal_bar_width = 0;
    $vertical_bar_height = 0;
    $vertical_bar_width = round(400 / $optioncount, 2);

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

    if($t_sig) {
      if($t_sig_html != "Y") {
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
<form name="f_poll" action="<?php echo $HTTP_SERVER_VARS['PHP_SELF']; ?>" method="post" target="_self">
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

if($t_message_html != "Y") $t_message_text = isset($t_message_text) ? _stripslashes($t_message_text) : "";
//if(isset($t_sig)) $t_sig = _stripslashes($t_sig);

if (isset($HTTP_GET_VARS['fid'])) {
    $t_fid = $HTTP_GET_VARS['fid'];
}elseif(isset($HTTP_POST_VARS['t_fid'])) {
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
              <table class="posthead" cellpadding="0" cellspacing="0" width="500">
                <tr>
                  <td>&nbsp;</td>
                  <td><?php echo $lang['numberanswers'].": ".form_dropdown_array('answercount', range(0, 3), array('5', '10', '15', '20'), isset($HTTP_POST_VARS['answercount']) ? $HTTP_POST_VARS['answercount'] : 0), " ", form_submit("changecount", $lang['change'])  ?></td>
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
                    echo "  <td>", form_input_text("answers[]", isset($HTTP_POST_VARS['answers'][$i]) ? _htmlentities(_stripslashes($HTTP_POST_VARS['answers'][$i])) : '', 40, 255), "</td>\n";
                    echo "</tr>\n";

                  }

                ?>
                <tr>
                  <td>&nbsp;</td>
                  <td><?php echo form_checkbox("t_post_html", "Y", $lang['answerscontainHTML'], (isset($HTTP_POST_VARS['t_post_html']) && $HTTP_POST_VARS['t_post_html'] == "Y")); ?></td>
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
            <td><?php echo form_textarea("t_message_text", _htmlentities($t_message_text), 15, 75); ?></td>
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
