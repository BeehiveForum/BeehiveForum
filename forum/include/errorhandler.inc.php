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
require_once BH_INCLUDE_PATH. 'cache.inc.php';
require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'db.inc.php';
require_once BH_INCLUDE_PATH. 'format.inc.php';
require_once BH_INCLUDE_PATH. 'header.inc.php';
require_once BH_INCLUDE_PATH. 'server.inc.php';
// End Required includes

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

function bh_error_handler($errno, $errstr, $errfile, $errline)
{
    if (error_reporting() == 0) {
        return;
    }

    if (error_reporting() & $errno) {
        throw new Error($errstr, 0, $errno, $errfile, $errline);
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

    $exception = new Error($error['message'], 0, $error['type'], $error['file'], $error['line']);

    bh_exception_handler($exception);
}

function bh_exception_handler(Exception $exception)
{
    try {

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

        $forum_path = server_get_forum_path();

        echo "<!DOCTYPE html>\n";
        echo "<html lang=\"en-gb\" dir=\"ltr\">\n";
        echo "<head>\n";
        echo "<title>Beehive Forum - Error Handler</title>\n";
        echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
        echo "<link rel=\"icon\" href=\"images/favicon.ico\" type=\"image/ico\" />\n";
        echo "<link rel=\"stylesheet\" href=\"", rtrim($forum_path, '/'), "/styles/default/style.css?", md5(uniqid(rand())), "\" type=\"text/css\" />\n";
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
                echo "    <td valign=\"top\" width=\"25\" class=\"warning_msg_icon\"><img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAKcSURBVDjLpZPLa9RXHMU/d0ysZEwmMQqZiTaP0agoaKGJUiwIxU0hUjtUQaIuXHSVbRVc+R8ICj5WvrCldJquhVqalIbOohuZxjDVxDSP0RgzyST9zdzvvffrQkh8tBs9yy9fPhw45xhV5X1U8+Yhc3U0LcEdVxdOVq20OA0ooQjhpnfhzuDZTx6++m9edfDFlZGMtXKxI6HJnrZGGtauAWAhcgwVnnB/enkGo/25859l3wIcvpzP2EhuHNpWF9/dWs/UnKW4EOGDkqhbQyqxjsKzMgM/P1ymhlO5C4ezK4DeS/c7RdzQoa3x1PaWenJjJZwT9rQ1gSp/js1jYoZdyfX8M1/mp7uFaTR8mrt29FEMQILr62jQ1I5kA8OF59jIItVA78dJertTiBNs1ZKfLNG+MUHX1oaURtIHEAOw3p/Y197MWHEJEUGCxwfHj8MTZIcnsGKxzrIURYzPLnJgbxvG2hMrKdjItjbV11CYKeG8R7ygIdB3sBMFhkem0RAAQ3Fuka7UZtRHrasOqhYNilOwrkrwnhCU/ON5/q04vHV48ThxOCuoAbxnBQB+am65QnO8FqMxNCjBe14mpHhxBBGCWBLxD3iyWMaYMLUKsO7WYH6Stk1xCAGccmR/Ozs/bKJuXS39R/YgIjgROloSDA39Deit1SZWotsjD8pfp5ONqZ6uTfyWn+T7X0f59t5fqDhUA4ry0fYtjJcWeZQvTBu4/VqRuk9/l9Fy5cbnX+6Od26s58HjWWaflwkusKGxjm1bmhkvLXHvh1+WMbWncgPfZN+qcvex6xnUXkzvSiYP7EvTvH4toDxdqDD4+ygT+cKMMbH+3MCZ7H9uAaDnqytpVX8cDScJlRY0YIwpAjcNcuePgXP/P6Z30QuoP4J7WbYhuQAAAABJRU5ErkJggg==\" /></td>\n";
                echo "    <td valign=\"top\" class=\"warning_msg_text\">Please note that there may be sensitive information such as passwords displayed here.</td>\n";
                echo "  </tr>\n";
                echo "</table>\n";

                echo "<p>", implode("</p><p>", $error_msg_array), "</p>\n";
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
                echo "                                <td valign=\"top\" width=\"25\" class=\"warning_msg_icon\"><img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAKcSURBVDjLpZPLa9RXHMU/d0ysZEwmMQqZiTaP0agoaKGJUiwIxU0hUjtUQaIuXHSVbRVc+R8ICj5WvrCldJquhVqalIbOohuZxjDVxDSP0RgzyST9zdzvvffrQkh8tBs9yy9fPhw45xhV5X1U8+Yhc3U0LcEdVxdOVq20OA0ooQjhpnfhzuDZTx6++m9edfDFlZGMtXKxI6HJnrZGGtauAWAhcgwVnnB/enkGo/25859l3wIcvpzP2EhuHNpWF9/dWs/UnKW4EOGDkqhbQyqxjsKzMgM/P1ymhlO5C4ezK4DeS/c7RdzQoa3x1PaWenJjJZwT9rQ1gSp/js1jYoZdyfX8M1/mp7uFaTR8mrt29FEMQILr62jQ1I5kA8OF59jIItVA78dJertTiBNs1ZKfLNG+MUHX1oaURtIHEAOw3p/Y197MWHEJEUGCxwfHj8MTZIcnsGKxzrIURYzPLnJgbxvG2hMrKdjItjbV11CYKeG8R7ygIdB3sBMFhkem0RAAQ3Fuka7UZtRHrasOqhYNilOwrkrwnhCU/ON5/q04vHV48ThxOCuoAbxnBQB+am65QnO8FqMxNCjBe14mpHhxBBGCWBLxD3iyWMaYMLUKsO7WYH6Stk1xCAGccmR/Ozs/bKJuXS39R/YgIjgROloSDA39Deit1SZWotsjD8pfp5ONqZ6uTfyWn+T7X0f59t5fqDhUA4ry0fYtjJcWeZQvTBu4/VqRuk9/l9Fy5cbnX+6Od26s58HjWWaflwkusKGxjm1bmhkvLXHvh1+WMbWncgPfZN+qcvex6xnUXkzvSiYP7EvTvH4toDxdqDD4+ygT+cKMMbH+3MCZ7H9uAaDnqytpVX8cDScJlRY0YIwpAjcNcuePgXP/P6Z30QuoP4J7WbYhuQAAAABJRU5ErkJggg==\" /></td>\n";
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
                echo "                                <td valign=\"top\" width=\"25\" class=\"warning_msg_icon\"><img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAKcSURBVDjLpZPLa9RXHMU/d0ysZEwmMQqZiTaP0agoaKGJUiwIxU0hUjtUQaIuXHSVbRVc+R8ICj5WvrCldJquhVqalIbOohuZxjDVxDSP0RgzyST9zdzvvffrQkh8tBs9yy9fPhw45xhV5X1U8+Yhc3U0LcEdVxdOVq20OA0ooQjhpnfhzuDZTx6++m9edfDFlZGMtXKxI6HJnrZGGtauAWAhcgwVnnB/enkGo/25859l3wIcvpzP2EhuHNpWF9/dWs/UnKW4EOGDkqhbQyqxjsKzMgM/P1ymhlO5C4ezK4DeS/c7RdzQoa3x1PaWenJjJZwT9rQ1gSp/js1jYoZdyfX8M1/mp7uFaTR8mrt29FEMQILr62jQ1I5kA8OF59jIItVA78dJertTiBNs1ZKfLNG+MUHX1oaURtIHEAOw3p/Y197MWHEJEUGCxwfHj8MTZIcnsGKxzrIURYzPLnJgbxvG2hMrKdjItjbV11CYKeG8R7ygIdB3sBMFhkem0RAAQ3Fuka7UZtRHrasOqhYNilOwrkrwnhCU/ON5/q04vHV48ThxOCuoAbxnBQB+am65QnO8FqMxNCjBe14mpHhxBBGCWBLxD3iyWMaYMLUKsO7WYH6Stk1xCAGccmR/Ozs/bKJuXS39R/YgIjgROloSDA39Deit1SZWotsjD8pfp5ONqZ6uTfyWn+T7X0f59t5fqDhUA4ry0fYtjJcWeZQvTBu4/VqRuk9/l9Fy5cbnX+6Od26s58HjWWaflwkusKGxjm1bmhkvLXHvh1+WMbWncgPfZN+qcvex6xnUXkzvSiYP7EvTvH4toDxdqDD4+ygT+cKMMbH+3MCZ7H9uAaDnqytpVX8cDScJlRY0YIwpAjcNcuePgXP/P6Z30QuoP4J7WbYhuQAAAABJRU5ErkJggg==\" /></td>\n";
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

    } catch (Exception $e) {

        printf('Exception thrown when handling an exception: %s', $exception->getMessage());
        exit;
    }
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

    if (($php_version = phpversion()) !== false) {
        $version_strings[] = sprintf('on PHP/%s', $php_version);
    }

    if (defined('PHP_OS')) {
        $version_strings[] = PHP_OS;
    }

    if (($php_sapi = php_sapi_name()) !== false) {
        $version_strings[] = mb_strtoupper($php_sapi);
    }

    if (!in_array($exception->getCode(), array(MYSQL_CONNECT_ERROR, MYSQL_ACCESS_DENIED, MYSQL_PERMISSION_DENIED))) {

        try {

            $mysql_version = db::get_version();

        } catch (Exception $e){

            $mysql_version = 'MySQL Version Unknown';
        }

        $version_strings[] = $mysql_version;
    }

    if (isset($version_strings) && sizeof($version_strings) > 0) {

        $error_msg_array[] = '<p><b>Version Strings:</b></p>';
        $error_msg_array[] = sprintf('<p>%s</p>', implode(', ', $version_strings));
    }

    $error_msg_array[] = '<p><b>HTTP Request:</b></p>';

    $error_msg_array[] =  $_SERVER['PHP_SELF'];

    if (isset($_GET)) {

        $error_msg_array[] = '<p><b>$_GET:</b></p>';

        $get_vars = htmlentities_array(print_r($_GET, true));

        $error_msg_array[] = sprintf('<pre>%s</pre>', $get_vars);
    }

    if (isset($_POST)) {

        $error_msg_array[] = '<p><b>$_POST:</b></p>';

        $post_vars = htmlentities_array(print_r($_POST, true));

        $error_msg_array[] = sprintf('<pre>%s</pre>', $post_vars);
    }

    if (isset($_COOKIE)) {

        $error_msg_array[] = '<p><b>$_COOKIE:</b></p>';

        $cookie_vars = htmlentities_array(print_r($_COOKIE, true));

        $error_msg_array[] = sprintf('<pre>%s</pre>', $cookie_vars);
    }

    if (isset($_SESSION)) {

        $error_msg_array[] = '<p><b>$_SESSION:</b></p>';

        $session_vars = htmlentities_array(print_r($_SESSION, true));

        $error_msg_array[] = sprintf('<pre>%s</pre>', $session_vars);
    }

    if (isset($_ENV)) {

        $error_msg_array[] = '<p><b>$_ENV:</b></p>';

        $environment_vars = htmlentities_array(print_r($_ENV, true));

        $error_msg_array[] = sprintf('<pre>%s</pre>', $environment_vars);
    }

    if (isset($_SERVER)) {

        $error_msg_array[] = '<p><b>$_SERVER:</b></p>';

        $server_vars = htmlentities_array(print_r($_SERVER, true));

        $error_msg_array[] = sprintf('<pre>%s</pre>', $server_vars);
    }

    return $error_msg_array;
}

function bh_error_stack_trace_tidy($trace_data)
{
    $ignore_functions = array(
        'bh_error_display',
        'bh_error_handler',
        'bh_error_process',
        'bh_error_send_email',
        'bh_error_stack_trace_tidy',
        'bh_exception_handler',
        'bh_fatal_error_handler',
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