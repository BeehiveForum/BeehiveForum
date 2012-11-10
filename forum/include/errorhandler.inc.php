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

if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

require_once BH_INCLUDE_PATH. 'cache.inc.php';
require_once BH_INCLUDE_PATH. 'server.inc.php';

class Error extends Exception
{
    protected $severity;

    public function __construct($message, $code, $severity, $file, $line)
    {
        $this->message = $message;
        $this->code = $code;
        $this->severity = $severity;
        $this->file = $file;
        $this->line = $line;
    }

    public function getSeverity()
    {
        return $this->severity;
    }
}

function bh_error_handler($errno, $errstr, $errfile, $errline, $errcontext)
{
    if (error_reporting() == 0) {
        return;
    }

    if (error_reporting() & $errno) {
        throw new Error($errstr, 0, $errno, $errfile, $errline);
    }
}

function bh_shutdown_handler()
{
    if (($error = error_get_last()) && ($error['type'] == E_ERROR)) {
        bh_exception_handler(new Error($error['message'], 0, $error['type'], $error['file'], $error['line']));
    }
}

function bh_exception_handler(Exception $exception)
{
    $config = server_get_config();

    if (isset($config['error_report_verbose']) && $config['error_report_verbose'] == true) {
        $error_report_verbose = true;
    } else {
        $error_report_verbose = false;
    }

    cache_disable();

    while (@ob_end_clean());

    ob_start();

    ob_implicit_flush(0);

    bh_error_send_email($exception);

    $error_msg_array = bh_error_process($exception);

    $error_log_message = sprintf('BEEHIVE_ERROR: %s', strip_tags(implode(". ", $error_msg_array)));

    @error_log($error_log_message);

    header_status(500, 'Internal Server Error');

    if (($exception->getCode() == MYSQL_ERROR_NO_SUCH_TABLE) || ($exception->getCode() == MYSQL_ERROR_WRONG_COLUMN_NAME)) {

        if (function_exists('install_incomplete') && !defined('BEEHIVE_DEVELOPER_MODE')) {

            install_incomplete();
        }
    }

    if ((preg_match('/include|include_once/u', $exception->getMessage()) > 0)) {

        if (function_exists('install_missing_files') && !defined('BEEHIVE_DEVELOPER_MODE')) {

            install_missing_files();
        }
    }

    $forum_path = server_get_forum_path();

    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
    echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
    echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"utf-8\" lang=\"en\" dir=\"ltr\">\n";
    echo "<head>\n";
    echo "<title>Beehive Forum - Error Handler</title>\n";
    echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
    echo "<link rel=\"icon\" href=\"images/favicon.ico\" type=\"image/ico\" />\n";
    echo "<link rel=\"stylesheet\" href=\"", $forum_path, "/styles/default/style.css?", md5(uniqid(rand())), "\" type=\"text/css\" />\n";
    echo "</head>\n";
    echo "<body>\n";
    echo "<h1>Error</h1>\n";
    echo "<br />\n";

    if (defined('BEEHIVEMODE_LIGHT') && !defined('BEEHIVE_DEVELOPER_MODE')) {

        echo '<p>An error has occured. Please wait a few moments before trying again.</p>';
        echo '<p>Details of the error have been saved to the default error log.</p>';

        if (isset($error_report_verbose) && $error_report_verbose == true) {

            echo '<p>When reporting a bug in Project Beehive or when requesting support please include the details below.</p>';

            echo "<table cellpadding=\"0\" cellspacing=\"0\" class=\"warning_msg\">\n";
            echo "  <tr>\n";
            echo "    <td valign=\"top\" width=\"25\" class=\"warning_msg_icon\"><img src=\"", html_style_image("warning.png", false), "\" alt=\"Warning\" title=\"Warning\" /></td>\n";
            echo "    <td valign=\"top\" class=\"warning_msg_text\">Please note that there may be sensitive information such as passwords displayed here.</td>\n";
            echo "  </tr>\n";
            echo "</table>\n";

            echo "<p>", implode("</p><p>", $error_msg_array), "</p>\n";
        }

    } else {

        echo "<div align=\"center\">\n";
        echo "<form accept-charset=\"utf-8\" name=\"f_error\" method=\"post\" action=\"\" target=\"_self\">\n";
        echo "  ", form_input_hidden_array($_POST), "\n";
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
            echo "                                <td valign=\"top\" width=\"25\" class=\"warning_msg_icon\"><img src=\"", html_style_image("warning.png", false), "\" alt=\"Warning\" title=\"Warning\" /></td>\n";
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
            echo "                                <td valign=\"top\" width=\"25\" class=\"warning_msg_icon\"><img src=\"", html_style_image("warning.png", false), "\" alt=\"Warning\" title=\"Warning\" /></td>\n";
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
        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"800\">\n";
        echo "    <tr>\n";
        echo "      <td align=\"center\"><input class=\"button\" type=\"submit\" name=\"", md5(uniqid(mt_rand())), "\" value=\"Retry\" /></td>\n";
        echo "    </tr>\n";
        echo "  </table>\n";
        echo "</form>\n";
        echo "</div>\n";
    }

    echo "</body>\n";
    echo "</html>\n";

    exit;
}

function bh_error_process(Exception $exception)
{
    $error_msg_array = array();

    $version_strings = array();

    $error_msg_array[] = sprintf('<p><b>E_USER_ERROR</b> %s</p>', $exception->getMessage());

    if (strlen(trim(basename($exception->getFile()))) > 0) {

        $error_msg_array[] = '<p><b>Error Message:</b></p>';
        $error_msg_array[] = sprintf('<p>Error in line %s of file %s</p>', $exception->getLine(), basename($exception->getFile()));
    }

    $error_msg_array[] = '<hr />';

    $stack_trace = array_values(array_filter($exception->getTrace(), 'bh_error_stack_trace_tidy'));

    if (count($stack_trace) > 0) {

        $error_msg_array[] = '<p><b>Stack trace:</b></p>';

        foreach ($stack_trace as $key => $trace_data) {

            $error_msg_array[] = sprintf(
                '#%s %s(%s): %s%s%s(%s)<br />',
                $key,
                isset($trace_data['file']) ? $trace_data['file'] : 'unknown',
                isset($trace_data['line']) ? $trace_data['line'] : 'unknown',
                isset($trace_data['class']) ? $trace_data['class'] : '',
                isset($trace_data['type']) ? $trace_data['type'] : '',
                isset($trace_data['function']) ? $trace_data['function'] : 'unknown',
                isset($trace_data['args']) ? implode(', ', array_map('gettype', $trace_data['args'])) : 'void'
            );
        }
    }

    if (defined('BEEHIVE_VERSION')) {
       $version_strings[] = sprintf('Beehive Forum %s', BEEHIVE_VERSION);
    }

    if (($php_version = phpversion())) {
        $version_strings[] = sprintf('on PHP/%s', $php_version);
    }

    if (defined('PHP_OS')) {
        $version_strings[] = PHP_OS;
    }

    if (($php_sapi = php_sapi_name())) {
        $version_strings[] = mb_strtoupper($php_sapi);
    }

    $mysql_version = '';

    if (!in_array($exception->getCode(), array(MYSQL_CONNECT_ERROR, MYSQL_ACCESS_DENIED, MYSQL_PERMISSION_DENIED))) {

        if (($mysql_version = db::get_version())) {
            $version_strings[] = sprintf('MySQL/%s', $mysql_version);
        } else {
            $version_strings[] = sprintf('MySQL Version Unknown');
        }
    }

    if (isset($version_strings) && sizeof($version_strings) > 0) {

        $error_msg_array[] = '<p><b>Version Strings:</b></p>';
        $error_msg_array[] = sprintf('<p>%s</p>', implode(', ', $version_strings));
    }

    $error_msg_array[] = '<p><b>HTTP Request:</b></p>';

    $error_msg_array[] =  $_SERVER['PHP_SELF'];

    if (isset($_GET) && sizeof($_GET) > 0) {

        $error_msg_array[] = '<p><b>$_GET:</b></p>';

        $get_vars = htmlentities_array(print_r($_GET, true));

        $error_msg_array[] = sprintf('<pre>%s</pre>', $get_vars);
    }

    if (isset($_POST) && sizeof($_POST) > 0) {

        $error_msg_array[] = '<p><b>$_POST:</b></p>';

        $post_vars = htmlentities_array(print_r($_POST, true));

        $error_msg_array[] = sprintf('<pre>%s</pre>', $post_vars);
    }

    if (isset($_ENV) && sizeof($_ENV) > 0) {

        $error_msg_array[] = '<p><b>$_ENV:</b></p>';

        $environment_vars = htmlentities_array(print_r($_ENV, true));

        $error_msg_array[] = sprintf('<pre>%s</pre>', $environment_vars);
    }

    if (isset($_SERVER) && sizeof($_SERVER) > 0) {

        $error_msg_array[] = '<p><b>$_SERVER:</b></p>';

        $server_vars = htmlentities_array(print_r($_SERVER, true));

        $error_msg_array[] = sprintf('<pre>%s</pre>', $server_vars);
    }

    return $error_msg_array;
}

function bh_error_stack_trace_tidy($trace_data)
{
    $ignore_functions = array(
        'bh_exception_handler',
        'bh_error_handler',
        'bh_shutdown_handler',
        'bh_error_display',
        'bh_error_process',
        'bh_error_stack_trace_tidy',
        'bh_error_send_email',
    );

    return !(isset($trace_data['function']) && in_array($trace_data['function'], $ignore_functions));
}

function bh_error_send_email(Exception $exception)
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

        $error_log_email_message = implode("\n\n", array_filter(array_map('strip_tags', $error_msg_array), 'strlen'));

        $headers = "Return-path: $error_report_email_addr_from\n";
        $headers.= "From: \"Beehive Forum Error Report\" <$error_report_email_addr_from>\n";
        $headers.= "Reply-To: \"Beehive Forum Error Report\" <$error_report_email_addr_from>\n";
        $headers.= "Content-type: text/plain; charset=UTF-8\n";
        $headers.= "X-Mailer: PHP/". phpversion(). "\n";
        $headers.= "X-Beehive-Forum: Beehive Forum ". BEEHIVE_VERSION;

        @mail($error_report_email_addr_to, "Beehive Forum Error Report", $error_log_email_message, $headers);
    }
}

?>