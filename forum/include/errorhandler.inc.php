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

/* $Id: errorhandler.inc.php,v 1.23 2003-09-03 15:45:49 decoyduck Exp $ */

// Error Handler

require_once("./include/config.inc.php");
require_once("./include/html.inc.php");
require_once("./include/form.inc.php");
require_once("./include/lang.inc.php");

// Redefine the user error constants
define("FATAL", E_USER_ERROR);
define("ERROR", E_USER_WARNING);
define("WARNING", E_USER_NOTICE);

// Set the error reporting level (Default: FATAL | ERROR | WARNING)
error_reporting(E_ALL);

// Beehive Error Handler Function

function bh_error_handler($errno, $errstr, $errfile, $errline)
{
    if (error_reporting()) {

        global $HTTP_SERVER_VARS, $HTTP_GET_VARS, $HTTP_POST_VARS, $lang;

        $getvars = "";
        foreach ($HTTP_GET_VARS as $key => $value) {
          $getvars.= $key. '='. $value. '&';
        }

        if (!isset($HTTP_GET_VARS['retryerror'])) {
          $getvars.= "&retryerror=yes";
        }

        if (substr($getvars, 0, 1) == '&') $getvars = substr($getvars, 1);
        if (substr($getvars, -1) == '&') $getvars = substr($getvars, 0, -1);

        srand((double)microtime()*1000000);

        @ob_end_clean();
        ob_start("bh_gzhandler");

        if (defined("BEEHIVEMODE_LIGHT")) {

            light_html_draw_top();

            echo "<p>{$lang['errorpleasewaitandretry']}</p>\n";
            echo "<form name=\"f_error\" method=\"post\" action=\"", $HTTP_SERVER_VARS['PHP_SELF'], "?$getvars\" target=\"_self\">\n";

            foreach ($HTTP_POST_VARS as $key => $value) {
                form_input_hidden_array($key, $value);
            }

            echo form_submit(md5(uniqid(rand())), $lang['retry']);

            if (isset($HTTP_GET_VARS['retryerror']) && basename($HTTP_SERVER_VARS['PHP_SELF']) == 'post.php') {

                echo "<p>{$lang['multipleerroronpost']}</p>\n";
                echo form_textarea("t_content", _htmlentities(_stripslashes($HTTP_POST_VARS['t_content'])), 15, 85);

                if (isset($HTTP_GET_VARS['replyto'])) {

                    echo "<p>{$lang['replymsgnumber']}:</p>\n";
                    echo form_input_text("t_request_url", $HTTP_GET_VARS['replyto'], 10, 64);

                }

            }

            echo "<h2>{$lang['errormsgfordevs']}:</h2>\n";

            switch ($errno) {

                case FATAL:
                    echo "<p><b>FATAL</b> [$errno] $errstr</p>\n";
                    echo "<p>Fatal error in line $errline of file ", basename($HTTP_SERVER_VARS['PHP_SELF']), " (", basename($errfile), ")</p>\n";
                    break;
                case ERROR:
                    echo "<p><b>ERROR</b> [$errno] $errstr</p>\n";
                    echo "<p>Error in line $errline of file ", basename($HTTP_SERVER_VARS['PHP_SELF']), " (", basename($errfile), ")</p>\n";
                    break;
                case WARNING:
                    echo "<p><b>WARNING</b> [$errno] $errstr</p>\n";
                    echo "<p>Warning in line $errline of file ", basename($HTTP_SERVER_VARS['PHP_SELF']), " (", basename($errfile), ")</p>\n";
                    break;
                default:
                    echo "<p><b>Unknown error</b> [$errno] $errstr</p>\n";
                    echo "<p>Unknown error in line $errline of file ", basename($HTTP_SERVER_VARS['PHP_SELF']), " (", basename($errfile), ")</p>\n";
                    break;
            }

            echo "<p>PHP/", PHP_VERSION, " (", PHP_OS, ")</p>\n";
            echo "</form>\n";

            light_html_draw_bottom();
            exit;

        }else {

            html_draw_top();

            echo "<div align=\"center\">\n";
            echo "<form name=\"f_error\" method=\"post\" action=\"", $HTTP_SERVER_VARS['PHP_SELF'], "?$getvars\" target=\"_self\">\n";
            echo "<table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
            echo "  <tr>\n";
            echo "    <td>\n";
            echo "      <table border=\"0\" width=\"100%\">\n";
            echo "        <tr>\n";
            echo "          <td class=\"postbody\">{$lang['errorpleasewaitandretry']}</td>\n";
            echo "        </tr>\n";
            echo "        <tr>\n";
            echo "          <td>\n";

            foreach ($HTTP_POST_VARS as $key => $value) {
                    echo "            ", form_input_hidden_array($key, $value), "\n";
            }

            echo "          </td>\n";
            echo "        </tr>\n";
            echo "        <tr>\n";
            echo "          <td align=\"center\">", form_submit(md5(uniqid(rand())), $lang['retry']), "</td>\n";
            echo "        </tr>\n";

            if (isset($HTTP_GET_VARS['retryerror']) && basename($HTTP_SERVER_VARS['PHP_SELF']) == 'post.php') {

                echo "        <tr>\n";
                echo "          <td>&nbsp;</td>\n";
                echo "        </tr>\n";
                echo "        <tr>\n";
                echo "          <td><hr /></td>\n";
                echo "        </tr>\n";
                echo "        <tr>\n";
                echo "          <td class=\"postbody\">{$lang['multipleerroronpost']}</td>\n";
                echo "        </tr>\n";
                echo "        <tr>\n";
                echo "          <td>&nbsp;</td>\n";
                echo "        </tr>\n";
                echo "        <tr>\n";
                echo "          <td>", form_textarea("t_content", _htmlentities(_stripslashes($HTTP_POST_VARS['t_content'])), 15, 85), "</td>\n";
                echo "        </tr>\n";

                if (isset($HTTP_GET_VARS['replyto'])) {

                    echo "        <tr>\n";
                    echo "          <td>&nbsp;</td>\n";
                    echo "        </tr>\n";
                    echo "        <tr>\n";
                    echo "          <td class=\"postbody\">{$lang['replymsgnumber']}:</td>\n";
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
            echo "          <td><h2>{$lang['errormsgfordevs']}:</h2></td>\n";
            echo "        </tr>\n";
            echo "        <tr>\n";
            echo "          <td class=\"postbody\">\n";

            switch ($errno) {

                case FATAL:
                    echo "            <p><b>FATAL</b> [$errno] $errstr</p>\n";
                    echo "            <p>Fatal error in line $errline of file ", basename($HTTP_SERVER_VARS['PHP_SELF']), " (", basename($errfile), ")</p>\n";
                    break;
                case ERROR:
                    echo "            <p><b>ERROR</b> [$errno] $errstr</p>\n";
                    echo "            <p>Error in line $errline of file ", basename($HTTP_SERVER_VARS['PHP_SELF']), " (", basename($errfile), ")</p>\n";
                    break;
                case WARNING:
                    echo "            <p><b>WARNING</b> [$errno] $errstr</p>\n";
                    echo "            <p>Warning in line $errline of file ", basename($HTTP_SERVER_VARS['PHP_SELF']), " (", basename($errfile), ")</p>\n";
                    break;
                default:
                    echo "            <p><b>Unknown error</b> [$errno] $errstr</p>\n";
                    echo "            <p>Unknown error in line $errline of file ", basename($HTTP_SERVER_VARS['PHP_SELF']), " (", basename($errfile), ")</p>\n";
                    break;
            }

            echo "            <p>PHP/", PHP_VERSION, " (", PHP_OS, ")</p>\n";
            echo "          </td>\n";
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
    }
}

// set to the user defined error handler
if ($show_friendly_errors) set_error_handler("bh_error_handler");

?>