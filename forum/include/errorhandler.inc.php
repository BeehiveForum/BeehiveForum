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

// Error Handler

function error_handler($errno, $errstr, $errfile, $errline)
{

    global $HTTP_SERVER_VARS, $HTTP_GET_VARS, $HTTP_POST_VARS;

    $getvars = "";
    foreach ($HTTP_GET_VARS as $key => $value) {
      $getvars.= $key. '='. $value. '&';
    }

    $getvars = substr($getvars, 0, -1);

    if (!isset($HTTP_GET_VARS['retryerror'])) {
      $getvars.= "&retryerror=yes";
    }

    html_draw_top();

    echo "<div align=\"center\">\n";
    echo "<form name=\"f_error\" method=\"post\" action=\"", $HTTP_SERVER_VARS['PHP_SELF'], "?$getvars\" target=\"_self\">\n";
    echo "<table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
    echo "  <tr>\n";
    echo "    <td>\n";
    echo "      <table border=\"0\" width=\"100%\">\n";
    echo "        <tr>\n";
    echo "          <td class=\"postbody\">An error has occured. Please wait a few minutes and then click the Retry button below.</td>\n";
    echo "        </tr>\n";
    echo "        <tr>\n";
    echo "          <td>";

    foreach ($HTTP_POST_VARS as $key => $value) {
      echo form_input_hidden($key, htmlspecialchars(_stripslashes($value))), "\n";
    }

    echo "          </td>\n";
    echo "        </tr>\n";

    srand((double)microtime()*1000000);

    echo "        <tr>\n";
    echo "          <td align=\"center\">", form_submit(md5(uniqid(rand())), 'Retry'), "</td>\n";
    echo "        </tr>\n";

    if (isset($HTTP_GET_VARS['retryerror']) && basename($HTTP_SERVER_VARS['PHP_SELF']) == 'post.php') {

      echo "        <tr>\n";
      echo "          <td>&nbsp;</td>\n";
      echo "        </tr>\n";
      echo "        <tr>\n";
      echo "          <td><hr /></td>\n";
      echo "        </tr>\n";
      echo "        <tr>\n";
      echo "          <td class=\"postbody\">This error has occured more than once while attempting to post/preview your message. For your convienience we have included your message text and if applicable the thread and message number you were replying to below. You may wish to save a copy of the text elsewhere until the forum is available again.</td>\n";
      echo "        </tr>\n";
      echo "        <tr>\n";
      echo "          <td>&nbsp;</td>\n";
      echo "        </tr>\n";
      echo "        <tr>\n";
      echo "          <td>", form_textarea("t_content", htmlspecialchars(_stripslashes($HTTP_POST_VARS['t_content'])), 15, 85), "</td>\n";
      echo "        </tr>\n";

      if (isset($HTTP_GET_VARS['replyto'])) {

        echo "        <tr>\n";
        echo "          <td>&nbsp;</td>\n";
        echo "        </tr>\n";
        echo "        <tr>\n";
        echo "          <td class=\"postbody\">Reply Message Number:</td>\n";
        echo "        </tr>\n";
        echo "        <tr>\n";
        echo "          <td>", form_input_text("t_request_url", $HTTP_GET_VARS['replyto'], 10, 64), "</td>\n";
        echo "        </tr>\n";

      }

    }

    echo "        <tr>\n";
    echo "          <td>&nbsp;</td>\n";
    echo "        </tr>\n";
    echo "        <tr>\n";
    echo "          <td><hr /></td>\n";
    echo "        </tr>\n";
    echo "        <tr>\n";
    echo "          <td><h2>Error Message for server admins and developers:</h2></td>\n";
    echo "        </tr>\n";
    echo "        <tr>\n";
    echo "          <td class=\"postbody\">";

    switch ($errno) {

        case FATAL:
            echo "<p><b>FATAL</b> [$errno] $errstr</p>\n";
            echo "<p>Fatal error in line $errline of file ", basename($HTTP_SERVER_VARS['PHP_SELF']), " (", basename($errfile), ")</p>\n";
            break;
        case ERROR:
            echo "<b>ERROR</b> [$errno] $errstr<br />\n";
            echo "<p>Error in line $errline of file ", basename($HTTP_SERVER_VARS['PHP_SELF']), " (", basename($errfile), ")</p>\n";
            break;
        case WARNING:
            echo "<b>WARNING</b> [$errno] $errstr<br />\n";
            echo "<p>Warning in line $errline of file ", basename($HTTP_SERVER_VARS['PHP_SELF']), " (", basename($errfile), ")</p>\n";
            break;
        default:
            echo "<b>Unknown error</b> [$errno] $errstr<br />\n";
            echo "<p>Unknown error in line $errline of file ", basename($HTTP_SERVER_VARS['PHP_SELF']), " (", basename($errfile), ")</p>\n";
            break;
    }

    echo "<p>PHP/", PHP_VERSION, " (", PHP_OS, ")</p>\n";
    echo "</td>\n";
    echo "        </tr>\n";
    echo "      </table>\n";
    echo "    </td>\n";
    echo "  </tr>\n";
    echo "</table>\n";
    echo "</form>\n";
    echo "</div>\n";

    html_draw_bottom();
    exit;

}

define ("FATAL", E_USER_ERROR);
define ("ERROR", E_USER_WARNING);
define ("WARNING", E_USER_NOTICE);

error_reporting (FATAL | ERROR | WARNING);
set_error_handler('error_handler');

?>