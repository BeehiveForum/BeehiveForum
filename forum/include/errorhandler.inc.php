<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
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

// Required includes
require_once BH_INCLUDE_PATH . 'cache.inc.php';
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'db.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'header.inc.php';
require_once BH_INCLUDE_PATH . 'server.inc.php';
// End Required includes

function enable_error_reporting()
{
    // Disable deprecated notices if developer mode switched on
    $deprecations = defined('BEEHIVE_DEVELOPER_MODE') ? 0 : E_DEPRECATED;

    // Set the error reporting level to report all errors
    error_reporting(E_ALL & ~$deprecations);

    // Enable the error handler
    set_error_handler('bh_error_handler');

    // Attempt to handle fatal errors
    register_shutdown_function('bh_fatal_error_handler');

    // Enable the exception handler
    set_exception_handler('bh_exception_handler');

    // Don't output errors to the browser
    @ini_set('display_errors', '0');
}

function bh_error_handler($code, $message, $file, $line)
{
    if (error_reporting() == 0) {
        return;
    }

    if (error_reporting() & $code) {
        throw new ErrorException($message, $code, 1, $file, $line);
    }
}

function bh_fatal_error_handler()
{
    if (($error = error_get_last()) === null) {
        return;
    }

    if (!in_array($error['type'], array(E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_PARSE))) {
        return;
    }

    $exception = new ErrorException($error['message'], 0, $error['type'], $error['file'], $error['line']);

    bh_exception_handler($exception);
}

function bh_exception_handler($exception)
{
    try {

        $config = server_get_config();

        if (isset($config['error_report_verbose']) && $config['error_report_verbose'] == true) {
            $error_report_verbose = true;
        } else {
            $error_report_verbose = false;
        }

        cache_disable();

        while (@ob_end_clean()) ;

        ob_start();

        ob_implicit_flush(0);

        bh_error_send_email($exception);

        $error_msg_array = bh_error_process($exception);

        @error_log(implode(' ', $error_msg_array));

        header_status(500, 'Internal Server Error');

        echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
        echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
        echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en-gb\" lang=\"en-gb\" dir=\"ltr\">\n";
        echo "<head>\n";
        echo "<title>Beehive Forum - Error Handler</title>\n";
        echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
        echo "<link rel=\"icon\" href=\"styles/default/images/favicon.ico\" type=\"image/ico\" />\n";
        echo "<link rel=\"stylesheet\" href=\"styles/default/style.css?", md5(uniqid(rand())), "\" type=\"text/css\" />\n";
        echo "<link rel=\"stylesheet\" href=\"styles/default/images.css?", md5(uniqid(rand())), "\" type=\"text/css\" />\n";
        echo "</head>\n";
        echo "<body>\n";
        echo "<h1>Error</h1>\n";
        echo "<br />\n";

        if (defined('BEEHIVEMODE_LIGHT') && !defined('BEEHIVE_DEVELOPER_MODE')) {

            echo '<p>An error has occurred. Please wait a few moments before trying again.</p>';
            echo '<p>Details of the error have been saved to the default error log.</p>';

            if (isset($error_report_verbose) && $error_report_verbose == true) {

                echo '<p>When reporting a bug in Project Beehive or when requesting support please include the details below.</p>';

                echo "<table cellpadding=\"0\" cellspacing=\"0\" class=\"warning_msg\">\n";
                echo "  <tr>\n";
                echo "    <td valign=\"top\" width=\"25\" class=\"warning_msg_icon\"><span class=\"image warning\"></span></td>\n";
                echo "    <td valign=\"top\" class=\"warning_msg_text\">Please note that there may be sensitive information such as passwords displayed here.</td>\n";
                echo "  </tr>\n";
                echo "</table>\n";

                echo "<p>", implode("\n\n", htmlentities_array($error_msg_array)), "</p>\n";
            }

        } else {

            echo "<div align=\"center\">\n";
            echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"800\">\n";
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
            echo "                    <table class=\"posthead\" width=\"98%\">\n";
            echo "                      <tr>\n";
            echo "                        <td align=\"left\" class=\"postbody\">An error has occurred. Please wait a few moments and then click the Retry button below. Details of the error have been saved to the default error log.</td>\n";
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

            if ((isset($error_report_verbose) && ($error_report_verbose == true)) || defined('BEEHIVE_DEVELOPER_MODE')) {

                echo "  <br />\n";
                echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"800\">\n";
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
                echo "                    <table class=\"posthead\" width=\"98%\">\n";
                echo "                      <tr>\n";
                echo "                        <td align=\"left\">\n";
                echo "                          <div align=\"center\">\n";
                echo "                            <table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"warning_msg\">\n";
                echo "                              <tr>\n";
                echo "                                <td valign=\"top\" width=\"25\" class=\"warning_msg_icon\"><span class=\"image warning\"></span></td>\n";
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
                echo "                                <td valign=\"top\" width=\"25\" class=\"warning_msg_icon\"><span class=\"image warning\"></span></td>\n";
                echo "                                <td valign=\"top\" class=\"warning_msg_text\">Please note that there may be sensitive information such as passwords displayed here.</td>\n";
                echo "                              </tr>\n";
                echo "                            </table>\n";
                echo "                          </div>\n";
                echo "                        </td>\n";
                echo "                      </tr>\n";
                echo "                      <tr>\n";
                echo "                        <td>\n";
                echo "                          <div class=\"error_handler_details\">", implode("\n\n", htmlentities_array($error_msg_array)), "</div>\n";
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
            echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"800\">\n";
            echo "    <tr>\n";
            echo "      <td align=\"center\">\n";
            echo "        <button class=\"button\" type=\"button\" onclick=\"window.location.reload()\">Retry</button>\n";
            echo "      </td>\n";
            echo "    </tr>\n";
            echo "  </table>\n";
            echo "</div>\n";
        }

        echo "</body>\n";
        echo "</html>\n";
        exit;

    } catch (Exception $exception) {

        printf('Exception thrown when handling an exception: %s', $exception->getMessage());
        exit;
    }
}

function bh_error_process($exception)
{
    $error_msg_array = array();

    $version_strings = array();

    $error_msg_array[] = sprintf('E_USER_ERROR: %s', $exception->getMessage());

    if (strlen(trim(basename($exception->getFile()))) > 0) {

        $error_msg_array[] = 'Error Message:';
        $error_msg_array[] = sprintf('Error in line %s of file %s', $exception->getLine(), basename($exception->getFile()));
    }

    $stack_trace_array = $exception->getTrace();

    if (count($stack_trace_array) > 0) {

        $error_msg_array[] = 'Stack trace:';

        $stack_trace_result_array = [];

        foreach ($stack_trace_array as $key => $stack_trace_data) {

            $stack_trace_result_array[] = sprintf(
                '#%s %s(%s): %s%s%s(%s)',
                $key,
                isset($stack_trace_data['file']) ? $stack_trace_data['file'] : 'unknown',
                isset($stack_trace_data['line']) ? $stack_trace_data['line'] : 'unknown',
                isset($stack_trace_data['class']) ? $stack_trace_data['class'] : '',
                isset($stack_trace_data['type']) ? $stack_trace_data['type'] : '',
                isset($stack_trace_data['function']) ? $stack_trace_data['function'] : 'unknown',
                isset($stack_trace_data['args']) ? implode(', ', array_map('gettype', $stack_trace_data['args'])) : 'void'
            );
        }

        if (count($stack_trace_result_array) > 0) {
            $error_msg_array[] = implode("\n", $stack_trace_result_array);
        }
    }

    if (defined('BEEHIVE_VERSION')) {
        $version_strings[] = sprintf('Beehive Forum %s', BEEHIVE_VERSION);
    }

    if (($php_version = phpversion()) !== false) {
        $version_strings[] = sprintf('on PHP/%s', $php_version);
    }

    if (defined('PHP_OS')) {
        $version_strings[] = PHP_OS;
    }

    if (($php_sapi = php_sapi_name()) !== false) {
        $version_strings[] = mb_strtoupper($php_sapi);
    }

    try {

        $mysql_version = sprintf('MySQL/%s', db::get_version());

    } catch (Exception $exception) {

        $mysql_version = 'MySQL Version Unknown';
    }

    $version_strings[] = $mysql_version;

    if (isset($version_strings) && sizeof($version_strings) > 0) {

        $error_msg_array[] = 'Version Strings:';
        $error_msg_array[] = sprintf('%s', implode(', ', $version_strings));
    }

    $error_msg_array[] = sprintf('HTTP Request: %s', $_SERVER['PHP_SELF']);

    if (isset($_GET)) {

        $error_msg_array[] = sprintf(
            '$_GET = %s;',
            var_export($_GET, true)
        );
    }

    if (isset($_POST)) {

        $error_msg_array[] = sprintf(
            '$_POST = %s;',
            var_export($_POST, true)
        );
    }

    if (isset($_COOKIE)) {

        $error_msg_array[] = sprintf(
            '$_COOKIE = %s;',
            var_export($_COOKIE, true)
        );
    }

    if (isset($_SESSION)) {

        $error_msg_array[] = sprintf(
            '$_SESSION = %s;',
            var_export($_SESSION, true)
        );
    }

    if (isset($_ENV)) {

        $error_msg_array[] = sprintf(
            '$_ENV = %s;',
            var_export($_ENV, true)
        );
    }

    if (isset($_SERVER)) {

        $error_msg_array[] = sprintf(
            '$_SERVER = %s;',
            var_export($_SERVER, true)
        );
    }

    return $error_msg_array;
}

function bh_error_send_email($exception)
{
    $config = server_get_config();

    if (isset($config['error_report_email_addr_to']) && strlen(trim($config['error_report_email_addr_to'])) > 0) {
        $error_report_email_addr_to = trim($config['error_report_email_addr_to']);
    } else {
        $error_report_email_addr_to = '';
    }

    if (isset($config['error_report_email_addr_from']) && strlen(trim($config['error_report_email_addr_from'])) > 0) {
        $error_report_email_addr_from = trim($config['error_report_email_addr_from']);
    } else {
        $error_report_email_addr_from = 'no-reply@beehiveforum.co.uk';
    }

    if (strlen($error_report_email_addr_to) > 0 && !defined('BEEHIVE_DEVELOPER_MODE')) {

        $error_msg_array = bh_error_process($exception);

        $error_log_email_message = implode("\n\n", $error_msg_array);

        $headers = "Return-path: $error_report_email_addr_from\n";
        $headers .= "From: \"Beehive Forum Error Report\" <$error_report_email_addr_from>\n";
        $headers .= "Reply-To: \"Beehive Forum Error Report\" <$error_report_email_addr_from>\n";
        $headers .= "Content-type: text/plain; charset=UTF-8\n";
        $headers .= "X-Mailer: PHP/" . phpversion() . "\n";
        $headers .= "X-Beehive-Forum: Beehive Forum " . BEEHIVE_VERSION;

        @mail($error_report_email_addr_to, "Beehive Forum Error Report", $error_log_email_message, $headers);
    }
}
