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

// Compress the output
require_once("./include/gzipenc.inc.php");

//Check logged in status
require_once("./include/session.inc.php");
require_once("./include/header.inc.php");

if(!bh_session_check()){

    $uri = "./logon.php?final_uri=". urlencode(get_request_uri());
    header_redirect($uri);

}

require_once("./include/search.inc.php");
require_once("./include/html.inc.php");
require_once("./include/form.inc.php");
require_once("./include/folder.inc.php");
require_once("./include/format.inc.php");
require_once("./include/user.inc.php");
require_once("./include/threads.inc.php");
require_once("./include/thread.inc.php");
require_once("./include/messages.inc.php");
require_once("./include/fixhtml.inc.php");
require_once("./include/poll.inc.php");
require_once("./include/config.inc.php");
require_once("./include/constants.inc.php");

// Check that required variables are set
if (!isset($HTTP_COOKIE_VARS['bh_sess_uid'])) {
    $user = 0; // default to UID 0 if no other UID specified
    if (!isset($HTTP_GET_VARS['mode'])) {
        if (!isset($HTTP_COOKIE_VARS['bh_thread_mode'])) {
            $mode = 0;
        }else{
            $mode = $HTTP_COOKIE_VARS['bh_thread_mode'];
        }
    } else {
        // non-logged in users can only display "All" threads or those in the past x days, since the other options would be impossible
        if ($HTTP_GET_VARS['mode'] == 0 || $HTTP_GET_VARS['mode'] == 3 || $HTTP_GET_VARS['mode'] == 4 || $HTTP_GET_VARS['mode'] == 5) {
            $mode = $HTTP_GET_VARS['mode'];
        } else {
            $mode = 0;
        }
    }
} else {
    $user = $HTTP_COOKIE_VARS['bh_sess_uid'];
    if (isset($mark_all_read)) threads_mark_all_read();
    if (!isset($HTTP_GET_VARS['mode'])) {
        if (!isset($HTTP_COOKIE_VARS['bh_thread_mode'])) {
            if (threads_any_unread()) { // default to "Unread" messages for a logged-in user, unless there aren't any
                $mode = 1;
            } else {
                $mode = 0;
            }
        }else {
            $mode = $HTTP_COOKIE_VARS['bh_thread_mode'];
        }
    } else {
        $mode = $HTTP_GET_VARS['mode'];
    }
}

// Base Query - The same for all searches

$basesql = "SELECT DISTINCT THREAD.FID, THREAD.TID, THREAD.TITLE, POST.TID, POST.PID, POST.FROM_UID, POST.TO_UID, ";
$basesql.= "UNIX_TIMESTAMP(POST.CREATED) AS CREATED, POST_CONTENT.CONTENT ";
$basesql.= "FROM ". forum_table("THREAD"). " THREAD ";
$basesql.= "LEFT JOIN ". forum_table("POST"). " POST ON (THREAD.TID = POST.TID) ";
$basesql.= "LEFT JOIN ". forum_table("POST_CONTENT"). " POST_CONTENT ON (POST.PID = POST_CONTENT.PID AND POST.TID = POST_CONTENT.TID) ";
$basesql.= "WHERE ";

html_draw_top();

// Construct the unique part of the query

if (isset($HTTP_POST_VARS['submit'])) {
  if (isset($HTTP_POST_VARS['search_string']) && strlen(trim($HTTP_POST_VARS['search_string'])) > 0) {
    $search_string = trim($HTTP_POST_VARS['search_string']);
    if (!search_construct_query($HTTP_POST_VARS, $searchsql, $urlquery, $error)) {
      echo "<h1>Search Results</h1>";
      if ($error = SEARCH_USER_NOT_FOUND) {
        echo "<h2>The username you specified in the to or from field was not found.</h2>\n";
      }elseif ($error = SEARCH_NO_KEYWORDS) {
        echo "<h2>You did not specify any words to search for or the words were under 3 characters long.</h2>\n";
      }
      html_draw_bottom();
      exit;
    }
  }else {
    echo "<h1>Search Results</h1>";
    echo "<h2>You did not specify any words to search for or the words were under 3 characters long.</h2>\n";
    html_draw_bottom();
    exit;
  }
}elseif (isset($HTTP_GET_VARS['sstart'])) {
  if (isset($HTTP_GET_VARS['search_string']) && strlen(trim($HTTP_GET_VARS['search_string'])) > 0) {
    $search_string = trim($HTTP_POST_VARS['search_string']);
    if (!search_construct_query($HTTP_GET_VARS, $searchsql, $urlquery, $error)) {
      echo "<h1>Search Results</h1>";
      if ($error = SEARCH_USER_NOT_FOUND) {
        echo "<h2>The username you specified in the to or from field was not found.</h2>\n";
      }elseif ($error = SEARCH_NO_KEYWORDS) {
        echo "<h2>You did not specify any words to search for or the words were under 3 characters long.</h2>\n";
      }
      html_draw_bottom();
      exit;
    }
  }else {
    echo "<h1>Search Results</h1>";
    echo "<h2>You did not specify any words to search for or the words were under 3 characters long.</h2>\n";
    html_draw_bottom();
    exit;
  }
}

if (isset($searchsql)) {

  echo "<img src=\"".style_image('post.png')."\" height=\"15\" alt=\"\" />&nbsp;<a href=\"post.php\" target=\"main\">New Discussion</a><br />\n";
  echo "<img src=\"".style_image('poll.png')."\" height=\"15\" alt=\"\" />&nbsp;<a href=\"create_poll.php\" target=\"main\">Create Poll</a><br />\n";
  echo "<img src=\"".style_image('search.png')."\" height=\"15\" alt=\"\" />&nbsp;<a href=\"search.php\" target=\"right\">New Search</a><br />\n";

  echo "      <form name=\"f_mode\" method=\"get\" action=\"thread_list.php\">\n        ";

  if ($HTTP_COOKIE_VARS['bh_sess_uid'] == 0) {

    $labels = array("All Discussions", "Today's Discussions", "2 Days Back", "7 Days Back");
    echo form_dropdown_array("mode", array(0, 3, 4, 5), $labels, $mode, "onchange=\"submit()\""). "\n        ";

  }else {

    $labels = array("All Discussions","Unread Discussions","Unread \"To: Me\"","Today's Discussions",
                    "2 Days Back","7 Days Back","High Interest","Unread High Interest",
                    "I've recently seen","I've ignored","I've subscribed to");

    echo form_dropdown_array("mode",range(0,10),$labels,$mode,"onchange=\"submit()\""). "\n        ";

  }

  echo form_submit("go","Go!"). "\n";
  echo "      </form>\n";
  echo "<h1>Search Results</h1>\n";

  $db  = db_connect();
  $sql = $basesql.$searchsql;

  if (isset($HTTP_GET_VARS['sstart'])) {
    $sstart = $HTTP_GET_VARS['sstart'];
  }else {
    $sstart = 0;
  }

  $result  = db_query($sql, $db);
  $numrows = db_num_rows($result);

  echo "<img src=\"".style_image('search.png')."\" height=\"15\" alt=\"\" />&nbsp;Found: ", $numrows, " matches<br />\n";

  if ($sstart >= 50) {
      echo "<img src=\"".style_image('current_thread.png')."\" height=\"15\" alt=\"\" />&nbsp;<a href=\"search.php?sstart=", $sstart - 50, $urlquery, "\">Previous Page</a>\n";
  }

  echo "<ol start=\"", $sstart + 1, "\">\n";

  while ($row = db_fetch_array($result)) {

    $message = messages_get($row['TID'], $row['PID']);
    $threaddata = thread_get($row['TID']);

    if (thread_is_poll($row['TID'])) {

      $message['TITLE']   = '';
      $message['CONTENT'] = strip_tags(_stripslashes($threaddata['TITLE']));

    }else {

      $message['TITLE']   = strip_tags(_stripslashes($threaddata['TITLE']));
      $message['CONTENT'] = strip_tags(message_get_content($row['TID'], $row['PID']));

    }

    // trunicate the search result at the last space in the first 50 chars.

    if (strlen($message['TITLE']) > 15) {

      if ($schar = strrpos($message['TITLE'], ' ')) {
        $message['TITLE'] = substr($message['TITLE'], 0, $schar);
      }else {
        $message['TITLE'] = substr($message['TITLE'], 0, 12). "...";
      }

    }

    if (strlen($message['CONTENT']) > 35) {

      $message['CONTENT'] = substr($message['CONTENT'], 0, 35);

      if ($schar = strrpos($message['CONTENT'], ' ')) {
        $message['CONTENT'] = substr($message['CONTENT'], 0, $schar);
      }else {
        $message['CONTENT'] = substr($message['CONTENT'], 0, 32). "...";
      }

    }

    echo "<li><p><a href=\"messages.php?msg=", $row['TID'], ".", $row['PID'], "&amp;search_string=", rawurlencode(trim($search_string)), "\" target=\"right\"><b>", $message['TITLE'], "</b><br />", wordwrap($message['CONTENT'], 25, '<br />', 1), "</a><br />\n";
    echo "<span class=\"smalltext\">&nbsp;-&nbsp;from ". format_user_name($message['FLOGON'], $message['FNICK']). ", ". format_time($message['CREATED'], 1). "</span></p></li>\n";

  }

  echo "</ol>\n";

  if ($numrows == 50) {
      echo "<img src=\"".style_image('current_thread.png')."\" height=\"15\" alt=\"\">&nbsp;<a href=\"search.php?sstart=", $sstart + 50, $urlquery, "\">Find More</a>\n";
  }

  html_draw_bottom();
  exit;

}

?>
<h1>Search Messages</h1>
<form method="post" action="search.php" target="left">
<?php echo form_input_hidden('sstart', '0'); ?>
<table border="0" width="550" align="center">
  <tr>
    <td class="postbody" colspan="2">Search Discussions...</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><?php echo form_dropdown_array("method", range(1,3), array("Containing all of the words", "Containing any of the words", "Containing the exact phrase"), 1). "&nbsp;". form_input_text("search_string", "", 20). "&nbsp;". form_submit("submit", "Find"); ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="postbody">Words shorter than <?php echo $search_min_word_length; ?> characters will not be included.</td>
  </tr>
  <tr>
    <td class="postbody" colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td class="postbody" colspan="2">Additional Criteria</td>
  </tr>
  <tr>
    <td align="right" class="postbody">Folder(s):</td>
    <td><?php echo folder_search_dropdown(); ?></td>
  </tr>
  <tr>
    <td align="right" class="postbody">To:</td>
    <td class="postbody"><?php echo search_draw_user_dropdown("to_uid"); ?> or <?php echo form_input_text("to_other", "", 20); ?></td>
  </tr>
  <tr>
    <td align="right" class="postbody">From:</td>
    <td class="postbody"><?php echo search_draw_user_dropdown("from_uid"); ?> or <?php echo form_input_text("from_other", "", 20); ?></td>
  </tr>
  <tr>
    <td align="right" class="postbody">Posted From:</td>
    <td><?php echo form_dropdown_array("date_from", range(1, 12), array("Today", "Yesterday", "Day before yesterday", "1 week ago", "2 weeks ago", "3 weeks ago", "1 month ago", "2 months ago", "3 months ago", "6 months ago", "1 year ago", "Beginning of time"), 7); ?></td>
  </tr>
  <tr>
    <td align="right" class="postbody">Posted To:</td>
    <td><?php echo form_dropdown_array("date_to", range(1, 12), array("Now", "Today", "Yesterday", "Day before yesterday", "1 week ago", "2 weeks ago", "3 weeks ago", "1 month ago", "2 months ago", "3 months ago", "6 months ago", "1 year ago"), 2); ?></td>
  </tr>
  <tr>
    <td align="right" class="postbody">Order by:</td>
    <td><?php echo form_dropdown_array("order_by", range(1, 3), array("Relevance", "Newest First", "Oldest First"), 1); ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><?php echo form_checkbox("me_only", "Y", "Only show messages to or from me", false); ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><?php echo form_submit("submit", "Find"); ?></td>
  </tr>
</table>
</form>

<?php

html_draw_bottom();

?>
