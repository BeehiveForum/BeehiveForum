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

/* $Id$ */

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
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "install.inc.php");

// Set the error reporting level to report all
// error messages and PHP5 strict mode.
error_reporting(E_ALL | E_STRICT);

// Beehive Error Handler to Exception Wrapper.
function bh_error_handler($code, $message, $file = '', $line = 0)
{
    if (error_reporting()) {
        throw new ErrorException($message, 0, $code, $file, $line);
    }
}

// Check for unclean shutdown.
function bh_shutdown_handler()
{
    if (($error = error_get_last()) && (error_reporting() == 0)) {
        throw new ErrorException($error['message'], 0, $error['type'], $error['file'], $error['line']);
    }
}

// Beehive Exception Handler Function
function bh_exception_handler(Exception $exception)
{
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
        $error_report_email_addr_from = 'no-reply@abeehiveforum.net';
    }

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

        // Stacktrace header
        $error_msg_array[] = '<p><b>Stack trace:</b></p>';

        // Stacktrace data.
        if (($trace_array = $exception->getTrace())) {
            $error_msg_array[] = sprintf('<pre>%s</pre>', print_r($trace_array, true));
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

        // Don't try and do this if we are having trouble connecting to the MySQL server.
        if (!in_array($exception->getCode(), array(MYSQL_ACCESS_DENIED, MYSQL_PERMISSION_DENIED))) {

            if (($mysql_version = db_fetch_mysql_version())) {
                $version_strings[] = sprintf('MySQL/%s', $mysql_version);
            }else {
                $version_strings[] = sprintf('MySQL Version Unknown');
            }
        }

        // Format the version info into a string.
        if (isset($version_strings) && sizeof($version_strings) > 0) {

            $error_msg_array[] = '<p><b>Version Strings:</b></p>';
            $error_msg_array[] = sprintf('<p>%s</p>', implode(', ', $version_strings));
        }

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

        // Check to see if we need to send the error report by email
        if (strlen($error_report_email_addr_to) > 0) {

            $error_log_email_message = strip_tags(implode("\n\n", $error_msg_array));

            $headers = "Return-path: $error_report_email_addr_from\n";
            $headers.= "From: \"Beehive Forum Error Report\" <$error_report_email_addr_from>\n";
            $headers.= "Reply-To: \"Beehive Forum Error Report\" <$error_report_email_addr_from>\n";
            $headers.= "Content-type: text/plain; charset=UTF-8\n";
            $headers.= "X-Mailer: PHP/". phpversion(). "\n";
            $headers.= "X-Beehive-Forum: Beehive Forum ". BEEHIVE_VERSION;

            @mail($error_report_email_addr_to, "Beehive Forum Error Report", $error_log_email_message, $headers);
        }

        // Format the error array for adding to the system error log.
        $error_log_message = sprintf('BEEHIVE_ERROR: %s', strip_tags(implode(". ", $error_msg_array)));

        // Add the error to the log.
        @error_log($error_log_message);

        // Status error header
        //header_status(500, 'Internal Server Error');

        // Check for an installation error.
        if (($exception->getCode() == MYSQL_ERROR_NO_SUCH_TABLE) || ($exception->getCode() == MYSQL_ERROR_WRONG_COLUMN_NAME)) {

            if (function_exists('install_incomplete')) {

                install_incomplete();
            }
        }

        // Check for file include errors
        if ((preg_match('/include|include_once/u', $exception->getMessage()) > 0)) {

            if (function_exists('install_missing_files')) {

                install_missing_files();
            }
        }

        // Light mode / AJAX / JSON error reporting.
        if (defined('BEEHIVEMODE_LIGHT')) {

            echo '<p>An error has occured. Please wait a few moments before trying again.</p>';
            echo '<p>Details of the error have been saved to the default error log.</p>';

            if (isset($error_report_verbose) && $error_report_verbose == true) {

                echo '<p>When reporting a bug in Project Beehive or when requesting support please include the details below.</p>';

                echo "<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"warning_msg\">\n";
                echo "  <tr>\n";
                echo "    <td valign=\"top\" width=\"25\" class=\"warning_msg_icon\"><img src=\"styles/default/images/warning.png\" alt=\"Warning\" title=\"Warning\" /></td>\n";
                echo "    <td valign=\"top\" class=\"warning_msg_text\">Please note that there may be sensitive information such as passwords displayed here.</td>\n";
                echo "  </tr>\n";
                echo "</table>\n";

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

        if (isset($error_report_verbose) && $error_report_verbose == true) {

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
            echo "                                <td valign=\"top\" width=\"25\" class=\"warning_msg_icon\"><img src=\"styles/default/images/warning.png\" alt=\"Warning\" title=\"Warning\" /></td>\n";
            echo "                                <td valign=\"top\" class=\"warning_msg_text\">When reporting a bug in Project Beehive or when requesting support please include the details below.</td>\n";
            echo "                              </tr>\n";
            echo "                            </table>\n";
            echo "                          </div>\n";
            echo "                        </td>\n";
            echo "                      </tr>\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\">\n";
            echo "                          <div align=\"center\">\n";
            echo "                            <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"warning_msg\">\n";
            echo "                              <tr>\n";
            echo "                                <td valign=\"top\" width=\"25\" class=\"warning_msg_icon\"><img src=\"styles/default/images/warning.png\" alt=\"Warning\" title=\"Warning\" /></td>\n";
            echo "                                <td valign=\"top\" class=\"warning_msg_text\">Please note that there may be sensitive information such as passwords displayed here.</td>\n";
            echo "                              </tr>\n";
            echo "                            </table>\n";
            echo "                          </div>\n";
            echo "                        </td>\n";
            echo "                      </tr>\n";
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

register_shutdown_function('bh_shutdown_handler');

?>