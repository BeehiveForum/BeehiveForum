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

/* $Id: errorhandler.inc.php,v 1.59 2004-12-22 22:21:10 decoyduck Exp $ */

if (@file_exists("./include/config.inc.php")) {
    include_once("./include/config.inc.php");
}

include_once("./include/constants.inc.php");

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

// Beehive Error Handler Function

function bh_error_handler($errno, $errstr, $errfile, $errline)
{
    // Bad Coding Practises Alert!!
    // We're going to ignore any E_STRICT error messages
    // which are caused by PHP/5.x because otherwise we'd
    // have to develop two seperate versions of Beehive
    // one for PHP/4.x and one for PHP/5.x.

    if (($errno & E_STRICT) > 0) return;

    // Now we can carry on with any other errors.

    if (error_reporting()) {

        srand((double)microtime()*1000000);

        @ob_end_clean();
        ob_start("bh_gzhandler");

        if (defined("BEEHIVEMODE_LIGHT")) {

            echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
            echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"DTD/xhtml1-transitional.dtd\">\n";
            echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\" dir=\"ltr\">\n";
            echo "<head>\n";
            echo "<title>Beehive Forum - Error Handler</title>\n";
            echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>\n";
            echo "</head>\n";
            echo "<body>\n";
            echo "<p>An error has occured. Please wait a few minutes and then click the Retry button below.</p>\n";
            echo "<form name=\"f_error\" method=\"post\" action=\"", get_request_uri(), "\" target=\"_self\">\n";

            foreach ($_POST as $key => $value) {
                echo "<input type=\"hidden\" name=\"$key}\" value=\"", _htmlentities($value), "\">\n";
            }

            echo "<input class=\"button\" type=\"submit\" name=\"", md5(uniqid(rand())), "\" value=\"Retry\" />\n";

            if (isset($_GET['retryerror']) && isset($_POST['t_content']) && strlen(trim(_stripslashes($_POST['t_content']))) > 0) {

                echo "<p>This error has occured more than once while attempting to post/preview your message. For your convienience we have included your message text and if applicable the thread and message number you were replying to below. You may wish to save a copy of the text elsewhere until the forum is available again.</p>\n";
                echo "<textarea class=\"bhtextarea\" rows=\"15\" name=\"t_content\" cols=\"85\">", _htmlentities(_stripslashes($_POST['t_content'])), "</textarea>\n";

                if (isset($_GET['replyto']) && validate_msg($_GET['replyto'])) {

                    echo "<p>Reply Message Number:</p>\n";
                    echo "<input class=\"bhinputtext\" type=\"text\" name=\"t_request_url\" value=\"{$_GET['replyto']}\">\n";

                }

            }

            echo "<h2>Error Message for server admins and developers:</h2>\n";

            switch ($errno) {

                case E_USER_ERROR:
                    echo "<p><b>E_USER_ERROR</b> [$errno] $errstr</p>\n";
                    echo "<p>Fatal error in line $errline of file ", basename($errfile), "</p>\n";
                    break;
                case E_USER_WARNING:
                    echo "<p><b>E_USER_WARNING</b> [$errno] $errstr</p>\n";
                    echo "<p>Error in line $errline of file ", basename($errfile), "</p>\n";
                    break;
                case E_USER_NOTICE:
                    echo "<p><b>E_USER_NOTICE</b> [$errno] $errstr</p>\n";
                    echo "<p>Warning in line $errline of file ", basename($errfile), "</p>\n";
                    break;
                default:
                    echo "<p><b>Unknown error</b> [$errno] $errstr</p>\n";
                    echo "<p>Unknown error in line $errline of file ", basename($errfile), "</p>\n";
                    break;
            }

            echo "<p>PHP/", PHP_VERSION, " (", PHP_OS, ")</p>\n";
            echo "</form>\n";
            echo "</body>\n";
            echo "</html>\n";

            die;

        }else {

            //$db_error_handler = db_connect();

            //if (db_errno($db_error_handler) == DB_ER_NO_SUCH_TABLE) install_incomplete();

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
            echo "<div align=\"center\">\n";
            echo "<form name=\"f_error\" method=\"post\" action=\"", get_request_uri(), "\" target=\"_self\">\n";
            echo "<table cellpadding=\"0\" cellspacing=\"0\" width=\"550\">\n";
            echo "  <tr>\n";
            echo "    <td>\n";
            echo "      <table border=\"0\" width=\"100%\">\n";
            echo "        <tr>\n";
            echo "          <td class=\"postbody\">An error has occured. Please wait a few minutes and then click the Retry button below.</td>\n";
            echo "        </tr>\n";
            echo "        <tr>\n";
            echo "          <td>\n";

            foreach ($_POST as $key => $value) {
                echo "<input type=\"hidden\" name=\"{$key}\" value=\"", _htmlentities($value), "\">\n";
            }

            echo "          </td>\n";
            echo "        </tr>\n";
            echo "        <tr>\n";
            echo "          <td align=\"center\"><input class=\"button\" type=\"submit\" name=\"", md5(uniqid(rand())), "\" value=\"Retry\" /></td>\n";
            echo "        </tr>\n";

            if (isset($_GET['retryerror']) && isset($_POST['t_content']) && strlen(trim(_stripslashes($_POST['t_content']))) > 0) {

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
                echo "          <td><textarea class=\"bhtextarea\" rows=\"15\" name=\"t_content\" cols=\"85\">", _htmlentities(_stripslashes($_POST['t_content'])), "</textarea></td>\n";
                echo "        </tr>\n";

                if (isset($_GET['replyto']) && validate_msg($_GET['replyto'])) {

                    echo "        <tr>\n";
                    echo "          <td>&nbsp;</td>\n";
                    echo "        </tr>\n";
                    echo "        <tr>\n";
                    echo "          <td class=\"postbody\">Reply Message Number:</td>\n";
                    echo "        </tr>\n";
                    echo "        <tr>\n";
                    echo "          <td><input class=\"bhinputtext\" type=\"text\" name=\"t_request_url\" value=\"{$_GET['replyto']}\"></td>\n";
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
            echo "          <td class=\"postbody\">\n";

            if ($errstr == BH_DB_CONNECT_ERROR) {

                echo "            <p><b>E_USER_ERROR</b> [$errno]</p>\n";
                echo "            <p>An error has occured while connecting to the database.</p>\n";
                echo "            <p>If you are the forum owner, please ensure the following variables in your config.inc.php are set correctly:</p>\n";
                echo "            <pre>\$db_server<br />\$db_username<br />\$db_password<br />\$db_database</pre>\n";
                echo "            <p>They should be set to the database details given to you by your hosting provider.</p>\n";

            }else {

                switch ($errno) {

                    case E_USER_ERROR:
                        echo "            <p><b>E_USER_ERROR</b> [$errno] $errstr</p>\n";
                        echo "            <p>Fatal error in line $errline of file $errfile</p>\n";
                        break;
                    case E_USER_WARNING:
                        echo "            <p><b>E_USER_WARNING</b> [$errno] $errstr</p>\n";
                        echo "            <p>Error in line $errline of file $errfile</p>\n";
                        break;
                    case E_USER_NOTICE:
                        echo "            <p><b>E_USER_NOTICE</b> [$errno] $errstr</p>\n";
                        echo "            <p>Warning in line $errline of file $errfile</p>\n";
                        break;
                    default:
                        echo "            <p><b>Unknown error</b> [$errno] $errstr</p>\n";
                        echo "            <p>Unknown error in line $errline of file $errfile</p>\n";
                        break;
                }
            }

            echo "            <p>Beehive Forum ", BEEHIVE_VERSION, " on PHP/", phpversion(), " ", PHP_OS, " ", strtoupper(php_sapi_name()), " MySQL/", db_fetch_mysql_version(), "</p>\n";
            echo "          </td>\n";
            echo "        </tr>\n";
            echo "      </table>\n";
            echo "    </td>\n";
            echo "  </tr>\n";
            echo "</table>\n";
            echo "</form>\n";
            echo "</div>\n";
            echo "</body>\n";
            echo "</html>\n";

            die;
        }
    }
}

// Should we enable our error handler?

if (isset($show_friendly_errors) && is_bool($show_friendly_errors) && $show_friendly_errors == true) {
    set_error_handler("bh_error_handler");
}

?>
