<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

Beehive Forum is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
USA
======================================================================*/

/* $Id: errorhandler.inc.php,v 1.101 2007-11-09 10:17:45 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "install.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");

// Define PHP 5.0's new E_STRICT constant here if it's not defined.
// This will be meaningless to PHP versions below 5.0 but it saves
// us doing some dodgy if checking against the version number later.

if (!defined("E_STRICT")) {
    define("E_STRICT", 2048);
}

// Set the error reporting level to report all error messages.
// If this is changed to include E_STRICT Beehive will probably
// not work.

error_reporting(E_ALL);

// Debug Backtrace function argument array processor

function bh_error_handler_process_args($func_args_array)
{
    $arguments_array = array();

    foreach ($func_args_array as $func_arg) {
        if (is_array($func_arg) && sizeof($func_arg) > 0) {
            $arguments_string.= sprintf("Array(%s)", bh_error_handler_process_args($func_arg));
        }else {
            $arguments_array[] = is_array($func_arg) ? 'Array(void)' : "'$func_arg'";
        }
    }

    return implode(", ", _htmlentities($arguments_array));
}

// Beehive Error Handler Function

function bh_error_handler($errno, $errstr, $errfile = '', $errline = 0)
{
    if (isset($GLOBALS['show_friendly_errors']) && $GLOBALS['show_friendly_errors'] == true) {
        $show_friendly_errors = true;
    }else {
        $show_friendly_errors = false;
    }

    if (isset($GLOBALS['error_report_email_addr_to']) && strlen(trim(_stripslashes($GLOBALS['error_report_email_addr_to']))) > 0) {
        $error_report_email_addr_to = trim(_stripslashes($GLOBALS['error_report_email_addr_to']));
    }else {
        $error_report_email_addr_to = '';
    }

    if (isset($GLOBALS['error_report_email_addr_from']) && strlen(trim(_stripslashes($GLOBALS['error_report_email_addr_from']))) > 0) {
        $error_report_email_addr_from = trim(_stripslashes($GLOBALS['error_report_email_addr_from']));
    }else {
        $error_report_email_addr_from = '$error_report_email_addr_from';
    }

    // Bad Coding Practises Alert!!
    // We're going to ignore any E_STRICT error messages
    // which are caused by PHP/5.x because otherwise we'd
    // have to develop two seperate versions of Beehive
    // one for PHP/4.x and one for PHP/5.x.

    if (($errno & E_STRICT) > 0) return;

    // No REQUEST_URI in IIS.

    $request_uri = "{$_SERVER['PHP_SELF']}?";

    $request_array = array_merge($_GET, array('retry_error' => 'true'));

    parse_array($request_array, "&amp;", $request_uri);

    // Now we can carry on with any other errors.

    if (error_reporting()) {

        // Check for an installation error.

        if (($errno == ER_NO_SUCH_TABLE || $errno == ER_WRONG_COLUMN_NAME) && !defined("BEEHIVE_INSTALL_NOWARN")) {
            install_incomplete();
        }

        // Array to hold the error message strings.

        $error_msg_array = array();

        // Array to store our version strings.

        $version_strings = array();

        // Generate the error message itself.

        switch ($errno) {

            case E_USER_ERROR:

                $error_msg_array[] = "<b>E_USER_ERROR</b> [$errno] $errstr";
                break;

            case E_USER_WARNING:

                $error_msg_array[] = "<b>E_USER_WARNING</b> [$errno] $errstr";
                break;

            case E_USER_NOTICE:

                $error_msg_array[] = "<b>E_USER_NOTICE</b> [$errno] $errstr";
                break;

            default:

                $error_msg_array[] = "<b>Unknown error</b> [$errno] $errstr";
                break;
        }

        if ($debug_backtrace_array = debug_backtrace()) {

            $debug_backtrace_array = array_reverse($debug_backtrace_array);

            $error_msg_array[] = "<b>Backtrace Result</b>";

            foreach ($debug_backtrace_array as $debug_backtrace) {

                if (!isset($debug_backtrace['function'])) $debug_backtrace['function'] = 'PHP_CORE_FUNCTION';

                if (!in_array($debug_backtrace['function'], array('bh_error_handler', 'trigger_error'))) {

                    if (sizeof($debug_backtrace['args']) > 0) {

                        $debug_backtrace_file_line = sprintf("%s:%s", basename($debug_backtrace['file']), $debug_backtrace['line']);
                        $debug_backtrace_func_args = sprintf("%s(<i>%s</i>)", $debug_backtrace['function'], bh_error_handler_process_args($debug_backtrace['args']));

                        $error_msg_array[] = sprintf("%s:%s", $debug_backtrace_file_line, $debug_backtrace_func_args);

                    }else {

                        $debug_backtrace_file_line = sprintf("%s:%s", basename($debug_backtrace['file']), $debug_backtrace['line']);
                        $debug_backtrace_func_args = sprintf("%s(<i>void</i>)", $debug_backtrace['function']);

                        $error_msg_array[] = sprintf("%s:%s", $debug_backtrace_file_line, $debug_backtrace_func_args);
                    }
                }
            }
        }

        // Add the file and line number to the error message array

        if (strlen(trim(basename($errfile))) > 0) {
            $error_msg_array[] = sprintf("Error in line $errline of file %s", basename($errfile));
        }

        // Get the Beehive Forum Version

        if (defined('BEEHIVE_VERSION')) {
           $version_strings[] = sprintf("Beehive Forum %s", BEEHIVE_VERSION);
        }

        // Get PHP Version

        if ($php_version = phpversion()) {
            $version_strings[] = "on PHP/$php_version";
        }

        // Get PHP OS (WINNT, Linux, etc)

        if (defined('PHP_OS')) {
            $version_strings[] = PHP_OS;
        }

        // Get PHP interface (CGI, APACHE, IIS, etc)

        if ($php_sapi = php_sapi_name()) {
            $version_strings[] = strtoupper($php_sapi);
        }

        // Get MySQL version if available.

        if (db_fetch_mysql_version($mysql_version)) {
            $version_strings[] = "MySQL/$mysql_version";
        }else {
            $version_strings[] = "MySQL Version Unknown";
        }

        // Format the version info into a string.

        if (isset($version_strings) && sizeof($version_strings) > 0) {
            $error_msg_array[] = implode(", ", $version_strings);
        }

        // Check to see if we need to send the error report by email

        if (strlen($error_report_email_addr_to) > 0) {

            $error_log_email_message = strip_tags(implode("\n", $error_msg_array));

            $headers = "Return-path: $error_report_email_addr_from\n";
            $headers.= "From: \"Beehive Forum Error Report\" <$error_report_email_addr_from>\n";
            $headers.= "Reply-To: \"Beehive Forum Error Report\" <$error_report_email_addr_from>\n";
            $headers.= "Content-type: text/plain; charset=UTF-8\n";
            $headers.= "X-Mailer: PHP/". phpversion(). "\n";
            $headers.= "X-Beehive-Forum: Beehive Forum ". BEEHIVE_VERSION;

            @error_log($error_log_email_message, 1, $error_report_email_addr_to, $headers);
        }

        // Format the error array for adding to the system error log.

        $error_log_message = sprintf('BEEHIVE_ERROR: %s', strip_tags(implode(". ", $error_msg_array)));

        // Add the error to the log.

        @error_log($error_log_message);

        // Light mode / basic error message display.

        if ((isset($show_friendly_errors) && $show_friendly_errors === false) || defined("BEEHIVEMODE_LIGHT")) {

            echo "<p>An error has occured. Please wait a few moments before trying again.</p>\n";
            echo "<p>Details of the error have been saved to the default error log.</p>\n";
            if (defined("BEEHIVE_INSTALL_NOWARN")) echo "<p>", implode("</p>\n<p>", $error_msg_array), "</p>\n";
            exit;
        }

        // Flush the output buffer

        while (@ob_end_clean());
        ob_start("bh_gzhandler");
        ob_implicit_flush(0);

        // Prevent caching of error handler

        header_no_cache();

        // Full mode error message display with Retry button.

        echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
        echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
        echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"utf-8\" lang=\"en\" dir=\"ltr\">\n";
        echo "<head>\n";
        echo "<title>Beehive Forum - Error Handler</title>\n";
        echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
        echo "<link rel=\"icon\" href=\"images/favicon.ico\" type=\"image/ico\" />\n";
        echo "<link rel=\"stylesheet\" href=\"styles/default/style.css\" type=\"text/css\" />\n";
        echo "</head>\n";
        echo "<body>\n";
        echo "<h1>Error</h1>\n";
        echo "<br />\n";
        echo "<div align=\"center\">\n";
        echo "<form name=\"f_error\" method=\"post\" action=\"$request_uri\" target=\"_self\">\n";
        echo "  ", form_input_hidden_array(_stripslashes($_POST)), "\n";
        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
        echo "    <tr>\n";
        echo "      <td align=\"left\">\n";
        echo "        <table class=\"box\" width=\"100%\">\n";
        echo "          <tr>\n";
        echo "            <td align=\"left\" class=\"posthead\">\n";
        echo "              <table class=\"posthead\" width=\"100%\">\n";
        echo "                <tr>\n";
        echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">Error</td>\n";
        echo "                </tr>\n";
        echo "                <tr>\n";
        echo "                  <td align=\"center\">\n";
        echo "                    <table class=\"posthead\" width=\"95%\">\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\" class=\"postbody\">An error has occured. Please wait a few moments and then click the Retry button below. Details of the error have been saved to the default error log.</td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\">&nbsp;</td>\n";
        echo "                      </tr>\n";
        echo "                    </table>\n";
        echo "                  </td>\n";
        echo "                </tr>\n";
        echo "              </table>\n";
        echo "            </td>\n";
        echo "          </tr>\n";
        echo "        </table>\n";
        echo "      </td>\n";
        echo "    </tr>\n";
        echo "  </table>\n";

        if (isset($_GET['retry_error']) && isset($_POST['t_content']) && strlen(trim(_stripslashes($_POST['t_content']))) > 0) {

            echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
            echo "    <tr>\n";
            echo "      <td align=\"left\">\n";
            echo "        <table class=\"box\" width=\"100%\">\n";
            echo "          <tr>\n";
            echo "            <td align=\"left\" class=\"posthead\">\n";
            echo "              <table class=\"posthead\" width=\"100%\">\n";
            echo "                <tr>\n";
            echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">Repeated Error</td>\n";
            echo "                </tr>\n";
            echo "                <tr>\n";
            echo "                  <td align=\"center\">\n";
            echo "                    <table class=\"posthead\" width=\"95%\">\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\" class=\"postbody\">This error has occured more than once while attempting to post/preview your message. For your convienience we have included your message text and if applicable the thread and message number you were replying to below. You may wish to save a copy of the text elsewhere until the forum is available again.</td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\">&nbsp;</td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\"><textarea class=\"bhtextarea\" rows=\"15\" name=\"t_content\" cols=\"85\">", _htmlentities(_stripslashes($_POST['t_content'])), "</textarea></td>\n";
            echo "                      </tr>\n";

            if (isset($_GET['replyto']) && validate_msg($_GET['replyto'])) {

                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\" class=\"postbody\">Reply Message Number:</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\"><input class=\"bhinputtext\" type=\"text\" name=\"t_request_url\" value=\"{$_GET['replyto']}\"></td>\n";
                echo "                      </tr>\n";

            }

            echo "                    </table>\n";
            echo "                  </td>\n";
            echo "                </tr>\n";
            echo "              </table>\n";
            echo "            </td>\n";
            echo "          </tr>\n";
            echo "        </table>\n";
            echo "      </td>\n";
            echo "    </tr>\n";
            echo "  </table>\n";
        }

        if (defined("BEEHIVE_INSTALL_NOWARN")) {

            echo "  <br />\n";
            echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
            echo "    <tr>\n";
            echo "      <td align=\"left\">\n";
            echo "        <table class=\"box\" width=\"100%\">\n";
            echo "          <tr>\n";
            echo "            <td align=\"left\" class=\"posthead\">\n";
            echo "              <table class=\"posthead\" width=\"100%\">\n";
            echo "                <tr>\n";
            echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">Error Details</td>\n";
            echo "                </tr>\n";
            echo "                <tr>\n";
            echo "                  <td align=\"center\">\n";
            echo "                    <table class=\"posthead\" width=\"95%\">\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\">\n";
            echo "                          <div align=\"center\">\n";
            echo "                            <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"warning_msg\">\n";
            echo "                              <tr>\n";
            echo "                                <td valign=\"top\" width=\"25\" class=\"warning_msg_icon\"><img src=\"images/warning.png\" width=\"15\" height=\"15\" alt=\"Warning\" title=\"Warning\" /></td>\n";
            echo "                                <td valign=\"top\" class=\"warning_msg_text\">When reporting a bug in Project Beehive or when requesting support please include the details below</td>\n";
            echo "                              </tr>\n";
            echo "                            </table>\n";
            echo "                          </div>\n";
            echo "                        </td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td>\n";
            echo "                          <div class=\"error_handler_details\"><p>", implode("</p>\n<p>", $error_msg_array), "</p></div>\n";
            echo "                        </td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\">&nbsp;</td>\n";
            echo "                      </tr>\n";
            echo "                    </table>\n";
            echo "                  </td>\n";
            echo "                </tr>\n";
            echo "              </table>\n";
            echo "            </td>\n";
            echo "          </tr>\n";
            echo "        </table>\n";
            echo "      </td>\n";
            echo "    </tr>\n";
            echo "  </table>\n";
        }

        echo "  <br />\n";
        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
        echo "    <tr>\n";
        echo "      <td align=\"center\"><input class=\"button\" type=\"submit\" name=\"", md5(uniqid(mt_rand())), "\" value=\"Retry\" /></td>\n";
        echo "    </tr>\n";
        echo "  </table>\n";
        echo "</form>\n";
        echo "</div>\n";
        echo "</body>\n";
        echo "</html>\n";

        exit;
    }
}

set_error_handler("bh_error_handler");

?>