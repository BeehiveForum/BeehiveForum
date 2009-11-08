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

/* $Id: errorhandler.inc.php,v 1.144 2009-11-08 14:10:06 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

// If the config file exists include it.

if (@file_exists(BH_INCLUDE_PATH. 'config.inc.php')) {
    include_once(BH_INCLUDE_PATH. "config.inc.php");
}

if (@file_exists(BH_INCLUDE_PATH. "config-dev.inc.php")) {
    include_once(BH_INCLUDE_PATH. "config-dev.inc.php");
}

// Other include files we need.

include_once(BH_INCLUDE_PATH. "cache.inc.php");
include_once(BH_INCLUDE_PATH. "compat.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "install.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");

// Set the error reporting level to report all 
// error messages and PHP5 strict mode.

error_reporting(E_ALL | E_STRICT);

// Debug Backtrace function argument array processor

function bh_error_handler_process_args($func_args_array)
{
    $arguments_array = array();

    foreach ($func_args_array as $func_arg) {

        if (is_array($func_arg)) {

            $arguments_array[] = sprintf("Array(%s)", bh_error_handler_process_args($func_arg));

        }else if (is_object($func_arg)) {

            $arguments_array[] = sprintf("Class: %s", get_class($func_arg));

        }else if (is_resource($func_arg)) {

            $arguments_array[] = $func_arg;

        }else if (is_bool($func_arg)) {

            $arguments_array[] = ($func_arg === true) ? 'true' : 'false';

        }else if (is_string($func_arg)) {

            $arguments_array[] = "'$func_arg'";

        }else {

            $arguments_array[] = $func_arg;
        }
    }

    return implode(", ", $arguments_array);
}

// Beehive Error Handler to Exception Wrapper.

function bh_error_handler($code, $message, $file = '', $line = 0)
{
    if (error_reporting()) {
        throw new ErrorException($message, 0, $code, $file, $line);
    }
}

// Beehive Exception Handler Function

function bh_exception_handler($exception)
{
    if (isset($GLOBALS['show_friendly_errors']) && $GLOBALS['show_friendly_errors'] == true) {
        $show_friendly_errors = true;
    }else {
        $show_friendly_errors = false;
    }

    if (isset($GLOBALS['error_report_verbose']) && $GLOBALS['error_report_verbose'] == true) {
        $error_report_verbose = true;
    }else {
        $error_report_verbose = false;
    }

    if (isset($GLOBALS['error_report_email_addr_to']) && strlen(trim(stripslashes_array($GLOBALS['error_report_email_addr_to']))) > 0) {
        $error_report_email_addr_to = trim(stripslashes_array($GLOBALS['error_report_email_addr_to']));
    }else {
        $error_report_email_addr_to = '';
    }

    if (isset($GLOBALS['error_report_email_addr_from']) && strlen(trim(stripslashes_array($GLOBALS['error_report_email_addr_from']))) > 0) {
        $error_report_email_addr_from = trim(stripslashes_array($GLOBALS['error_report_email_addr_from']));
    }else {
        $error_report_email_addr_from = '';
    }
    
    // The requested script's filename
    
    $script_filename = basename(trim(stripslashes_array($_SERVER['PHP_SELF'])));    
    
    // Let's ignore PHP5's strict warnings.
    
    //if (($exception->code & E_STRICT) > 0) return;

    // Now we can carry on with any other errors.

    if (error_reporting()) {

        // Disable the HTTP cache.
        
        cache_disable();

        // Clean the output buffer

        while (@ob_end_clean());
        ob_start("bh_gzhandler");
        ob_implicit_flush(0);

        // Array to hold the error message strings.

        $error_msg_array = array();

        // Array to store our version strings.

        $version_strings = array();

        // Generate the error message itself.

        $error_msg_array[] = sprintf('<p><b>E_USER_ERROR</b> %s</p>', $exception->getMessage());

        // Add the file and line number to the error message array

        if (strlen(trim(basename($exception->getFile()))) > 0) {

            $error_msg_array[] = '<p><b>Error Message:</b></p>';
            $error_msg_array[] = sprintf('<p>Error in line %s of file %s</p>', $exception->getLine(), basename($exception->getFile()));
        }

        // Separator

        $error_msg_array[] = '<hr />';

        // Debug backtrace data.

        if (($exception_backtrace = $exception->getTrace())) {

            $exception_backtrace = array_reverse($exception_backtrace);

            $debug_backtrace_processed = false;

            $error_msg_array[] = '<p><b>Backtrace Result:</b></p>';

            foreach ($exception_backtrace as $debug_backtrace) {

                if (!isset($debug_backtrace['function'])) $debug_backtrace['function'] = 'PHP_CORE_FUNCTION';

                if (!in_array($debug_backtrace['function'], array('bh_error_handler', 'trigger_error', 'db_trigger_error'))) {

                    if (isset($debug_backtrace['file']) && isset($debug_backtrace['line']) && isset($debug_backtrace['args'])) {

                        $debug_backtrace_processed = true;

                        if (sizeof($debug_backtrace['args']) > 0) {

                            $debug_backtrace_file_line = sprintf('%s:%s', htmlentities_array(basename($debug_backtrace['file'])), htmlentities_array($debug_backtrace['line']));
                            $debug_backtrace_func_args = sprintf('%s(<i>%s</i>)', htmlentities_array($debug_backtrace['function']), htmlentities_array(bh_error_handler_process_args($debug_backtrace['args'])));

                            $error_msg_array[] = sprintf('<p>%s:%s</p>', $debug_backtrace_file_line, $debug_backtrace_func_args);

                        }else {

                            $debug_backtrace_file_line = sprintf('%s:%s', htmlentities_array(basename($debug_backtrace['file'])), htmlentities_array($debug_backtrace['line']));
                            $debug_backtrace_func_args = sprintf('%s(<i>void</i>)', htmlentities_array($debug_backtrace['function']));

                            $error_msg_array[] = sprintf('<p>%s:%s</p>', $debug_backtrace_file_line, $debug_backtrace_func_args);
                        }
                    }
                }
            }

            if ($debug_backtrace_processed == false) {
                $error_msg_array[] = '<p><i>(none)</i></p>';
            }
        }

        // Get the Beehive Forum Version

        if (defined('BEEHIVE_VERSION')) {
           $version_strings[] = sprintf('Beehive Forum %s', BEEHIVE_VERSION);
        }

        // Get PHP Version

        if (($php_version = phpversion())) {
            $version_strings[] = sprintf('on PHP/%s', $php_version);
        }

        // Get PHP OS (WINNT, Linux, etc)

        if (defined('PHP_OS')) {
            $version_strings[] = PHP_OS;
        }

        // Get PHP interface (CGI, APACHE, IIS, etc)

        if (($php_sapi = php_sapi_name())) {
            $version_strings[] = mb_strtoupper($php_sapi);
        }

        // Get MySQL version if available.

        $mysql_version = '';

        if (function_exists('db_fetch_mysql_version') && ($mysql_version = db_fetch_mysql_version())) {
            $version_strings[] = sprintf('MySQL/%s', $mysql_version);
        }else {
            $version_strings[] = sprintf('MySQL Version Unknown');
        }

        // Format the version info into a string.

        if (isset($version_strings) && sizeof($version_strings) > 0) {

            $error_msg_array[] = '<p><b>Version Strings:</b></p>';
            $error_msg_array[] = sprintf('<p>%s</p>', implode(', ', $version_strings));
        }

        // Verbose Error Data.

        if (isset($error_report_verbose) && $error_report_verbose == true) {

            // HTTP Request that caused the error

            $error_msg_array[] = '<p><b>HTTP Request:</b></p>';

            // The requested file name.

            $error_msg_array[] =  $_SERVER['PHP_SELF'];

            // Output the URL Query variables.

            if (isset($_GET) && sizeof($_GET) > 0) {

                $error_msg_array[] = '<p><b>$_GET:</b></p>';

                $get_vars = htmlentities(print_r($_GET, true));

                $error_msg_array[] = sprintf('<pre>%s</pre>', $get_vars);
            }

            // Output any Post Data

            if (isset($_POST) && sizeof($_POST) > 0) {

                $error_msg_array[] = '<p><b>$_POST:</b></p>';

                $post_vars = htmlentities(print_r($_POST, true));

                $error_msg_array[] = sprintf('<pre>%s</pre>', $post_vars);
            }

            // Output environment variables.

            if (isset($_ENV) && sizeof($_ENV) > 0) {

                $error_msg_array[] = '<p><b>$_ENV:</b></p>';

                $environment_vars = htmlentities(print_r($_ENV, true));

                $error_msg_array[] = sprintf('<pre>%s</pre>', $environment_vars);
            }

            // Output Server variables.

            if (isset($_SERVER) && sizeof($_SERVER) > 0) {

                $error_msg_array[] = '<p><b>$_SERVER:</b></p>';

                $server_vars = htmlentities(print_r($_SERVER, true));

                $error_msg_array[] = sprintf('<pre>%s</pre>', $server_vars);
            }
        }

        // Check to see if we need to send the error report by email

        if (strlen($error_report_email_addr_to) > 0) {

            $error_log_email_message = strip_tags(implode("\n\n", $error_msg_array));

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

        // Check for an installation error.

        if (($exception->getCode() == MYSQL_ERROR_NO_SUCH_TABLE) || ($exception->getCode() == MYSQL_ERROR_WRONG_COLUMN_NAME)) {

            if (!defined('BEEHIVE_INSTALL_NOWARN') && function_exists('install_incomplete')) {

                install_incomplete();
            }
        }

        // Check for file include errors

        if ((preg_match('/include|include_once/u', $exception->getMessage()) > 0)) {

            if (!defined('BEEHIVE_INSTALL_NOWARN') && function_exists('install_missing_files')) {

                install_missing_files();
            }
        }
        
        // If Ajax request force display of Lightmode error messages.
        
        if (in_array($script_filename, array('pm.php', 'user_stats.php'))) {
            
            if (isset($_GET['check_messages']) || isset($_GET['get_stats'])) {

                if (defined('BEEHIVE_INSTALL_NOWARN') || defined('BEEHIVEMODE_INSTALL')) {
                    echo implode("\n", $error_msg_array);
                }

                exit;
            }
        }

        // Light mode / basic error message display.

        if ((isset($show_friendly_errors) && $show_friendly_errors === false) || defined("BEEHIVEMODE_LIGHT")) {

            echo '<p>An error has occured. Please wait a few moments before trying again.</p>';
            echo '<p>Details of the error have been saved to the default error log.</p>';

            if (defined('BEEHIVE_INSTALL_NOWARN') || defined('BEEHIVEMODE_INSTALL')) {
                echo implode("\n", $error_msg_array);
            }

            exit;
        }

        // Full mode error message display with Retry button.

        echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
        echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
        echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"utf-8\" lang=\"en\" dir=\"ltr\">\n";
        echo "<head>\n";
        echo "<title>Beehive Forum - Error Handler</title>\n";
        echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
        echo "<link rel=\"icon\" href=\"images/favicon.ico\" type=\"image/ico\" />\n";
        echo "<link rel=\"stylesheet\" href=\"styles/default/style.css?", md5(uniqid(rand())), "\" type=\"text/css\" />\n";
        echo "</head>\n";
        echo "<body>\n";
        echo "<h1>Error</h1>\n";
        echo "<br />\n";
        echo "<div align=\"center\">\n";
        echo "<form accept-charset=\"utf-8\" name=\"f_error\" method=\"post\" action=\"\" target=\"_self\">\n";
        echo "  ", form_input_hidden_array(stripslashes_array($_POST)), "\n";
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

        if (isset($_GET['retry_error']) && isset($_POST['t_content']) && strlen(trim($_POST['t_content'])) > 0) {

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
            echo "                        <td align=\"left\"><textarea class=\"bhtextarea\" rows=\"15\" name=\"t_content\" cols=\"85\">", htmlentities(stripslashes($_POST['t_content'])), "</textarea></td>\n";
            echo "                      </tr>\n";

            if (isset($_GET['replyto'])) {

                echo "                      <tr>\n";
                echo "                        <td align=\"left\">&nbsp;</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\" class=\"postbody\">Reply Message Number:</td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\"><input class=\"bhinputtext\" type=\"text\" name=\"t_request_url\" value=\"", htmlentities(stripslashes($_GET['replyto'])), "\"></td>\n";
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

        if (defined('BEEHIVE_INSTALL_NOWARN') || defined('BEEHIVEMODE_INSTALL')) {

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
            echo "                                <td valign=\"top\" class=\"warning_msg_text\">When reporting a bug in Project Beehive or when requesting support please include the details below.</td>\n";
            echo "                              </tr>\n";
            echo "                            </table>\n";
            echo "                          </div>\n";
            echo "                        </td>\n";
            echo "                      </tr>\n";

            if (isset($error_report_verbose) && $error_report_verbose == true) {

                echo "                      <tr>\n";
                echo "                        <td align=\"left\">\n";
                echo "                          <div align=\"center\">\n";
                echo "                            <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"warning_msg\">\n";
                echo "                              <tr>\n";
                echo "                                <td valign=\"top\" width=\"25\" class=\"warning_msg_icon\"><img src=\"images/warning.png\" width=\"15\" height=\"15\" alt=\"Warning\" title=\"Warning\" /></td>\n";
                echo "                                <td valign=\"top\" class=\"warning_msg_text\">Please note that there may be sensitive information such as passwords displayed here.</td>\n";
                echo "                              </tr>\n";
                echo "                            </table>\n";
                echo "                          </div>\n";
                echo "                        </td>\n";
                echo "                      </tr>\n";
            }

            echo "                      <tr>\n";
            echo "                        <td>\n";
            echo "                          <div class=\"error_handler_details\">", implode("\n", $error_msg_array), "</div>\n";
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

set_error_handler('bh_error_handler');

set_exception_handler('bh_exception_handler');

?>