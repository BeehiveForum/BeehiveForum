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

/* $Id: create_poll.php,v 1.96 2004-04-17 18:41:00 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum settings
$forum_settings = get_forum_settings();

include_once("./include/attachments.inc.php");
include_once("./include/config.inc.php");
include_once("./include/constants.inc.php");
include_once("./include/folder.inc.php");
include_once("./include/form.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/htmltools.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/messages.inc.php");
include_once("./include/poll.inc.php");
include_once("./include/post.inc.php");
include_once("./include/session.inc.php");
include_once("./include/thread.inc.php");

if (!$user_sess = bh_session_check()) {

    if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
        
        if (perform_logon(false)) {
	    
	    html_draw_top();

            echo "<h1>{$lang['loggedinsuccessfully']}</h1>";
            echo "<div align=\"center\">\n";
	    echo "<p><b>{$lang['presscontinuetoresend']}</b></p>\n";

            $request_uri = get_request_uri();

            echo "<form method=\"post\" action=\"$request_uri\" target=\"_self\">\n";

            foreach($_POST as $key => $value) {
	        form_input_hidden($key, _htmlentities(_stripslashes($value)));
            }

	    echo form_submit(md5(uniqid(rand())), $lang['continue']), "&nbsp;";
            echo form_button(md5(uniqid(rand())), $lang['cancel'], "onclick=\"self.location.href='$request_uri'\""), "\n";
	    echo "</form>\n";
	    
	    html_draw_bottom();
	    exit;
	}

    }else {
        html_draw_top();
        draw_logon_form(false);
	html_draw_bottom();
	exit;
    }
}

// Check we have a webtag

if (!$webtag = get_webtag()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?final_uri=$request_uri");
}

if (bh_session_get_value('UID') == 0) {
    html_guest_error();
    exit;
}

// Check to see if the forum owner has allowed the creation of polls

if (forum_get_setting('allow_polls', 'N', false)) {
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

$t_message_text = "";
$t_sig = "";
$t_message_html = "N";
$t_sig_html = "N";

$post_html = 0;
$sig_html = 0;

if (isset($_POST['t_message_html'])) {
    $t_message_html = $_POST['t_message_html'];
    if ($t_message_html == "enabled_auto") {
		$post_html = 1;
    } else if ($t_message_html == "enabled") {
		$post_html = 2;
    }
}
if (isset($_POST['t_sig_html'])) {
	$t_sig_html = $_POST['t_sig_html'];
	if ($t_sig_html != "N") {
		$sig_html = 2;
	}
}

$post = new MessageText($post_html);
$sig = new MessageText($sig_html);

if (isset($_POST['cancel'])) {

  $uri = "./discussion.php?webtag=$webtag";
  header_redirect($uri);

}elseif (isset($_POST['preview']) || isset($_POST['submit'])) {

  $valid = true;

  if (strlen(trim($_POST['question'])) == 0) {
    $error_html = "<h2>{$lang['mustenterpollquestion']}</h2>";
    $valid = false;
  }

  if ($valid && !isset($_POST['t_fid'])) {
    $error_html = "<h2>{$lang['pleaseselectfolder']}</h2>";
    $valid = false;
  }

  if ($valid && !folder_thread_type_allowed($_POST['t_fid'], FOLDER_ALLOW_POLL_THREAD)) {
      $error_html = "<h2>{$lang['cannotpostthisthreadtypeinfolder']}</h2>";
      $valid = false;
  }

  if ($valid && strlen(trim($_POST['answers'][0])) == 0) {
    $error_html = "<h2>{$lang['mustspecifyvalues1and2']}</h2>";
    $valid = false;
  }

  if ($valid && strlen(trim($_POST['answers'][1])) == 0) {
    $error_html = "<h2>{$lang['mustspecifyvalues1and2']}</h2>";
    $valid = false;
  }

  if ($valid && $_POST['pollvotetype'] == 1 && $_POST['changevote']  == 2) {
    $error_html = "<h2>{$lang['cannotcreatemultivotepublicballot']}</h2>";
    $valid = false;
  }

  if (isset($_POST['t_message_text']) && strlen(trim($_POST['t_message_text'])) > 0) {
    $t_message_text = trim($_POST['t_message_text']);
	$post->setContent($t_message_text);
	$t_message_text = $post->getContent();

	if (strlen($t_message_text) >= 65535) {
		$error_html = "<h2>{$lang['reducemessagelength']} ".number_format(strlen($t_message_text)).")</h2>";
		$valid = false;
	}

    if (attachment_embed_check($t_message_text) && $t_message_html == "Y") {
        $error_html = "<h2>{$lang['notallowedembedattachmentpost']}</h2>\n";
        $valid = false;
    }
  }

  if (isset($_POST['t_sig']) && strlen(trim($_POST['t_sig'])) > 0) {
    $t_sig = trim($_POST['t_sig']);
	$sig->setContent($t_sig);
	$t_sig = $sig->getContent();

	if (strlen($t_sig) >= 65535) {
		$error_html = "<h2>{$lang['reducesiglength']} ".number_format(strlen($t_sig)).")</h2>";
		$valid = false;
	}

    if (attachment_embed_check($t_sig) && $t_sig_html == "Y") {
        $error_html = "<h2>{$lang['notallowedembedattachmentpostsignature']}</h2>\n";
        $valid = false;
    }
  }

  $answer_group_check = array();

  for ($i = 0; $i < sizeof($_POST['answer_groups']); $i++) {
      if (!in_array($_POST['answer_groups'][$i], $answer_group_check)) {
          $answer_group_check[] = $_POST['answer_groups'][$i];
      }
  }

  if ($valid && (sizeof($answer_group_check) >= sizeof($_POST['answers']))) {
    $error_html = "<h2>{$lang['groupcountmustbelessthananswercount']}</h2>";
    $valid = false;
  }
}

if ($valid && isset($_POST['submit'])) {

  if (check_ddkey($_POST['t_dedupe'])) {
  
     $folderdata = folder_get($_POST['t_fid']);
     
     if ($folderdata['ACCESS_LEVEL'] == 2 && !folder_is_accessible($_POST['t_fid']) && !perm_is_moderator()) {
        
       html_draw_top();
                
       echo "<form name=\"f_post\" action=\"./create_poll.php?webtag=$webtag\" method=\"post\" target=\"_self\">\n";
       echo "<table class=\"posthead\" width=\"720\">\n";
       echo "<tr><td class=\"subhead\">".$lang['threadclosed']."</td></tr>\n";
       echo "<tr><td>\n";
       echo "<h2>".$lang['threadisclosedforposting']."</h2>\n";
       echo "</td></tr>\n";
 
       echo "<tr><td align=\"center\">\n";
       echo form_submit('cancel', $lang['cancel']);
       echo "</td></tr>\n";
       echo "</table></form>\n";
 
       html_draw_bottom();
       exit;
    }  

    // Work out when the poll will close.

    if ($_POST['closepoll'] == 0) {
      $poll_closes = gmmktime() + DAY_IN_SECONDS;
    }elseif ($_POST['closepoll'] == 1) {
      $poll_closes = gmmktime() + (DAY_IN_SECONDS * 3);
    }elseif ($_POST['closepoll'] == 2) {
      $poll_closes = gmmktime() + (DAY_IN_SECONDS * 7);
    }elseif ($_POST['closepoll'] == 3) {
      $poll_closes = gmmktime() + (DAY_IN_SECONDS * 30);
    }elseif ($_POST['closepoll'] == 4) {
      $poll_closes = false;
    }

    // Check HTML tick box, innit.
	$answers = array();
	$ans_h = 0;
	if (isset($_POST['t_post_html']) && $_POST['t_post_html'] == 'Y') {
		$ans_h = 2;
	}
    for ($i = 0; $i < sizeof($_POST['answers']); $i++) {
		$answers[$i] = new MessageText($ans_h, $_POST['answers'][$i]);
        $_POST['answers'][$i] = $answers[$i]->getContent();
    }

    $_POST['question'] = trim($_POST['question']);

    // Create the poll thread with the poll_flag set to Y and sticky flag set to N

    $t_tid = post_create_thread($_POST['t_fid'], $_POST['question'], 'Y', 'N');
    $t_pid = post_create($t_tid, 0, bh_session_get_value('UID'), 0, '');

    poll_create($t_tid, $_POST['answers'], $_POST['answer_groups'], $poll_closes, $_POST['changevote'], $_POST['polltype'], $_POST['showresults'], $_POST['pollvotetype']);

    if (isset($_POST['aid']) && forum_get_setting('attachments_enabled', 'Y', false)) {
        if (get_num_attachments($_POST['aid']) > 0) post_save_attachment_id($t_tid, $t_pid, $_POST['aid']);
    }

    if (strlen($t_message_text) > 0) {

      $t_message_text.= "\n<div class=\"sig\">$t_sig</div>";

      post_create($t_tid, 1, bh_session_get_value('UID'), 0, $t_message_text);

    }

    if (bh_session_get_value('MARK_AS_OF_INT')) thread_set_interest($t_tid, 1, true);

  }

  if (isset($t_tid) && $t_tid > 0) {

    $uri = "./discussion.php?webtag=$webtag&msg=$t_tid.1";

  }else {

    $uri = "./discussion.php?webtag=$webtag";
  }

  header_redirect($uri);

}

html_draw_top("basetarget=_blank", "openprofile.js", "post.js", "htmltools.js");

echo "<h1>{$lang['createpoll']}</h1>\n";

if (!isset($_POST['aid'])) {
  $aid = md5(uniqid(rand()));
}else{
  $aid = $_POST['aid'];
}

if ($valid && isset($_POST['preview'])) {

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
  $polldata['CONTENT'].= "          <td><h2>". _stripslashes($_POST['question']). "</h2></td>\n";
  $polldata['CONTENT'].= "        </tr>\n";
  $polldata['CONTENT'].= "        <tr>\n";
  $polldata['CONTENT'].= "          <td class=\"postbody\">\n";

  $pollresults = array();

  $max_value   = 0;
  $totalvotes  = 0;
  $optioncount = 0;

  $ans_h = 0;
  if (isset($_POST['t_post_html']) && $_POST['t_post_html'] == 'Y') {
	  $ans_h = 2;
  }

  foreach($_POST['answers'] as $key => $answer_text) {

		if (strlen(trim($answer_text)) > 0) {
			$answer_tmp = new MessageText($ans_h, $answer_text);
			$poll_answers_array[$key] = $answer_tmp->getContent();

          srand((double)microtime()*1000000);
          $poll_vote = rand(1, 10);

          if ($poll_vote > $max_value) $max_value = $poll_vote;

          $poll_votes_array[] = $poll_vote;
          $totalvotes += $poll_vote;
          $optioncount++;

      }else {

          unset($_POST['answers'][$key]);
          unset($_POST['answer_groups'][$key]);
      }
  }

  $poll_groups_array = $_POST['answer_groups'];

  // Construct the pollresults array that will be used to display the graph
  // Modified to handle the new Group ID.

  $pollresults = array('OPTION_ID'   => array_keys($poll_answers_array),
                       'OPTION_NAME' => $poll_answers_array,
                       'GROUP_ID'    => $poll_groups_array,
                       'VOTES'       => $poll_votes_array);

  if ($_POST['polltype'] == 1) {

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

  if ($_POST['changevote'] == 1) {
    $polldata['CONTENT'].= $lang['abletochangevote'];
  }elseif ($_POST['changevote'] == 2) {
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

    $polldata['CONTENT'] = $t_message_text."<div class=\"sig\">". $t_sig. "</div>";

    message_display(0, $polldata, 0, 0, false, false, false, true, $show_sigs, true);

  }
}

if (isset($error_html)) echo $error_html. "\n";

echo "<form name=\"f_poll\" action=\"create_poll.php?webtag=$webtag\" method=\"post\" target=\"_self\">\n";

if (isset($_POST['t_dedupe'])) {
    echo form_input_hidden("t_dedupe", $_POST['t_dedupe']);
}else{
    echo form_input_hidden("t_dedupe", date("YmdHis"));
}

if (isset($_GET['fid']) && is_numeric($_GET['fid'])) {
    $t_fid = $_GET['fid'];
}elseif (isset($_POST['t_fid']) && is_numeric($_POST['t_fid'])) {
    $t_fid = $_POST['t_fid'];
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
      <td><?php echo form_input_text("question", isset($_POST['question']) ? _htmlentities(_stripslashes($_POST['question'])) : '', 30, 64); ?>&nbsp;</bdo><?php echo form_submit("submit", $lang['post']); ?></td>
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
                  <td><?php echo $lang['numberanswers'].": ".form_dropdown_array('answercount', range(0, 3), array('5', '10', '15', '20'), isset($_POST['answercount']) ? $_POST['answercount'] : 0), " ", form_submit("changecount", $lang['change'])  ?></td>
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

                  if (isset($_POST['answercount'])) {
                    $answercount = $available_answers[$_POST['answercount']];
                  }else {
                    $answercount = 5;
                  }

                  for ($i = 0; $i < $answercount; $i++) {

                    echo "<tr>\n";
                    echo "  <td>", $i + 1, ". </td>\n";
                    echo "  <td>", form_input_text("answers[]", isset($_POST['answers'][$i]) ? _htmlentities(_stripslashes($_POST['answers'][$i])) : '', 40, 255), "</td>\n";
                    echo "  <td align=\"center\">", form_dropdown_array("answer_groups[]", range(1, $answercount), range(1, $answercount), (isset($_POST['answer_groups'][$i])) ? $_POST['answer_groups'][$i] : 1), "</td>\n";
                    echo "  <td>&nbsp;</td>\n";
                    echo "</tr>\n";

                  }

                ?>
                <tr>
                  <td>&nbsp;</td>
                  <td><?php echo form_checkbox("t_post_html", "Y", $lang['answerscontainHTML'], (isset($_POST['t_post_html']) && $_POST['t_post_html'] == "Y")); ?></td>
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
                  <td width="25%"><?php echo form_radio('changevote', '1', $lang['yes'], isset($_POST['changevote']) ? $_POST['changevote'] == 1 : true); ?></td>
                  <td width="25%"><?php echo form_radio('changevote', '0', $lang['no'], isset($_POST['changevote']) ? $_POST['changevote'] == 0 : false); ?></td>
                  <td><?php echo form_radio('changevote', '2', $lang['allowmultiplevotes'], isset($_POST['changevote']) ? $_POST['changevote'] == 2 : false); ?></td>
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
                  <td width="50%"><?php echo form_radio('polltype', '0', $lang['horizgraph'], isset($_POST['polltype']) ? $_POST['polltype'] == 0 : true); ?></td>
                  <td width="50%"><?php echo form_radio('polltype', '1', $lang['vertgraph'], isset($_POST['polltype']) ? $_POST['polltype'] == 1 : false); ?></td>
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
                  <td width="50%"><?php echo form_radio('pollvotetype', '0', $lang['pollvoteanon'], isset($_POST['pollvotetype']) ? $_POST['pollvotetype'] == 0 : true); ?></td>
                  <td width="50%"><?php echo form_radio('pollvotetype', '1', $lang['pollvotepub'], isset($_POST['pollvotetype']) ? $_POST['pollvotetype'] == 1 : false); ?></td>
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
                  <td width="50%"><?php echo form_radio('showresults', '1', $lang['yes'], isset($_POST['showresults']) ? $_POST['showresults'] == 1 : true); ?></td>
                  <td width="50%"><?php echo form_radio('showresults', '0', $lang['no'], isset($_POST['showresults']) ? $_POST['showresults'] == 0 : false); ?></td>
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
            <td><?php echo form_dropdown_array('closepoll', range(0, 4), array($lang['oneday'], $lang['threedays'], $lang['sevendays'], $lang['thirtydays'], $lang['never']), isset($_POST['closepoll']) ? $_POST['closepoll'] : 4); ?></td>
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
<?php
$tools = new TextAreaHTML("f_poll");
?>
          <tr>
            <td><?php echo $tools->toolbar(); ?></td>
          </tr>
          <tr>
            <td><?php echo $tools->textarea("t_message_text", $post->getTidyContent(), 15, 75); ?></td>
          </tr>
          <tr><td>
<?php
if ($post->isDiff()) {
	echo $tools->compare_original("t_message_text", $post->getOriginalContent());
}
echo "<h2>". $lang['htmlinmessage'] .":</h2>\n";

$tph_radio = $post->getHTML();

echo form_radio("t_message_html", "disabled", $lang['disabled'], $tph_radio == 0, "tabindex=\"6\"")." \n";
echo form_radio("t_message_html", "enabled_auto", $lang['enabledwithautolinebreaks'], $tph_radio == 1)." \n";
echo form_radio("t_message_html", "enabled", $lang['enabled'], $tph_radio == 2)." \n";

echo $tools->assign_checkbox("t_message_html[1]", "t_message_html[0]");
?>
          </td></tr>
          <tr>
            <td><?php echo $lang['signature']; ?>:<br /><?php echo $tools->textarea("t_sig", $sig->getTidyContent(), 5, 75), form_input_hidden("t_sig_html", $sig->getHTML() ? "Y" : "N"); ?></td>
          </tr>
<?php
if ($sig->isDiff()) {
	echo "          <tr><td>\n";
	echo $tools->compare_original("t_sig", $sig->getOriginalContent());
	echo "          </tr></td>\n";
}
?>
        </table>
      </td>
    </tr>
  </table>
<?php

	echo $tools->js(false);

    echo form_submit("submit", $lang['post']). "&nbsp;</bdo>". form_submit("preview", $lang['preview']). "&nbsp;</bdo>". form_submit("cancel", $lang['cancel']);

    if (forum_get_setting('attachments_enabled', 'Y', false)) {

      echo "&nbsp;</bdo>".form_button("attachments", $lang['attachments'], "onclick=\"launchAttachWin('{$aid}', '$webtag')\"");
      echo form_input_hidden("aid", $aid);

    }

    echo "</form>\n";

    html_draw_bottom();

?>