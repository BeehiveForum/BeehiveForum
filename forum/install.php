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

/* $Id: install.php,v 1.58 2006-07-30 16:19:27 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

// Installation checking functions
include_once(BH_INCLUDE_PATH. "install.inc.php");

// Multiple forum support
include_once(BH_INCLUDE_PATH. "forum.inc.php");

if (@file_exists(BH_INCLUDE_PATH. "config.inc.php")) {
    include_once(BH_INCLUDE_PATH. "config.inc.php");
}

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");

if (isset($_GET['force_install']) && $_GET['force_install'] == 'yes') {
    $force_install = true;
}elseif (isset($_POST['force_install']) && $_POST['force_install'] == 'yes') {
    $force_install = true;
}else {
    $force_install = false;
}

if (isset($_POST['install_method']) && (!defined('BEEHIVE_INSTALED') || $force_install)) {

    install_msie_buffer_fix();

    $valid = true;
    $config_saved = false;

    $error_array = array();

    if (isset($_POST['install_method']) && is_numeric($_POST['install_method'])) {

        $install_method = $_POST['install_method'];

    }else {

        $error_array[] = "You must choose an installation method.\n";
        $valid = false;
    }

    if (isset($_POST['forum_webtag']) && strlen(trim(_stripslashes($_POST['forum_webtag']))) > 0) {

        $forum_webtag = strtoupper(trim(_stripslashes($_POST['forum_webtag'])));

        if (!preg_match("/^[A-Z0-9_]+$/", $forum_webtag)) {

            $error_array[] = "The forum webtag can only conatin uppercase A-Z, 0-9 and underscore.\n";
            $valid = false;
        }

    }else {

        if (isset($install_method) && $install_method < 2) {

            $error_array[] = "You must specify a forum webtag for this type of installation.\n";
            $valid = false;
        }
    }

    if (isset($_POST['db_server']) && strlen(trim(_stripslashes($_POST['db_server']))) > 0) {
        $db_server = trim(_stripslashes($_POST['db_server']));
    }else {
        $error_array[] = "You must supply the hostname of your MySQL database.\n";
        $valid = false;
    }

    if (isset($_POST['db_database']) && strlen(trim(_stripslashes($_POST['db_database']))) > 0) {
        $db_database = trim(_stripslashes($_POST['db_database']));
    }else {
        $error_array[] = "You must supply the name of your MySQL database.\n";
        $valid = false;
    }

    if (isset($_POST['db_username']) && strlen(trim(_stripslashes($_POST['db_username']))) > 0) {
        $db_username = trim(_stripslashes($_POST['db_username']));
    }else {
        $error_array[] = "You must enter your username for your MySQL database.\n";
        $valid = false;
    }

    if (isset($_POST['db_password']) && strlen(trim(_stripslashes($_POST['db_password']))) > 0) {
        $db_password = trim(_stripslashes($_POST['db_password']));
    }else {
        $error_array[] = "You must enter your password for your MySQL database.\n";
        $valid = false;
    }

    if (isset($_POST['db_cpassword']) && strlen(trim(_stripslashes($_POST['db_cpassword']))) > 0) {
        $db_cpassword = trim(_stripslashes($_POST['db_cpassword']));
    }else {
        $db_cpassword = "";
    }

    if (isset($install_method) && ($install_method == 0 || $install_method == 1)) {

        if (isset($_POST['admin_username']) && strlen(trim(_stripslashes($_POST['admin_username']))) > 0) {
            $admin_username = trim(_stripslashes($_POST['admin_username']));
        }else {
            $error_array[] = "You must supply a username for your administrator account.\n";
            $valid = false;
        }

        if (isset($_POST['admin_password']) && strlen(trim(_stripslashes($_POST['admin_password']))) > 0) {
            $admin_password = trim(_stripslashes($_POST['admin_password']));
        }else {
            $error_array[] = "You must supply a password for your administrator account.\n";
            $valid = false;
        }

        if (isset($_POST['admin_cpassword']) && strlen(trim(_stripslashes($_POST['admin_cpassword']))) > 0) {
            $admin_cpassword = trim(_stripslashes($_POST['admin_cpassword']));
        }else {
            $admin_cpassword = "";
        }

        if (isset($_POST['admin_email']) && strlen(trim(_stripslashes($_POST['admin_email']))) > 0) {
            $admin_email = trim(_stripslashes($_POST['admin_email']));
        }else {
            $admin_email = "";
        }
    }

    if (isset($_POST['remove_conflicts']) && $_POST['remove_conflicts'] == 'Y') {
        $remove_conflicts = true;
    }else {
        $remove_conflicts = false;
    }

    if (isset($_POST['skip_dictionary']) && $_POST['skip_dictionary'] == 'Y') {
        $skip_dictionary = true;
    }else {
        $skip_dictionary = false;
    }

    if ($valid) {

        if ($install_method == 0 && ($admin_password != $admin_cpassword)) {
            $error_array[] = "Administrator account passwords do not match.\n";
            $valid = false;
        }

        if ($db_password != $db_cpassword) {
            $error_array[] = "MySQL database passwords do not match.\n";
            $valid = false;
        }
    }

    if ($valid) {

        if ($db_install = db_connect(false)) {

            if (($install_method == 5) && (@file_exists('./install/upgrade-06x-to-064.php'))) {

                include_once("./install/upgrade-06x-to-064.php");

            }elseif (($install_method == 4) && (@file_exists('./install/upgrade-05-to-064.php'))) {

                include_once("./install/upgrade-05-to-064.php");

            }elseif (($install_method == 1) && (@file_exists('./install/new-install.php'))) {

                $remove_conflicts = true;
                include_once("./install/new-install.php");

            }elseif (($install_method == 0) && (@file_exists('./install/new-install.php'))) {

                include_once("./install/new-install.php");
            }

            if ($valid) {

                $config_file = "";

                if (@$fp = fopen('./install/config.inc.php', 'r')) {

                    while (!feof($fp)) {

                        $config_file.= fgets($fp, 100);
                    }

                    fclose($fp);

                    // Database details

                    $config_file = str_replace('{db_server}',   $db_server,   $config_file);
                    $config_file = str_replace('{db_username}', $db_username, $config_file);
                    $config_file = str_replace('{db_password}', $db_password, $config_file);
                    $config_file = str_replace('{db_database}', $db_database, $config_file);

                    if (!defined('BEEHIVE_INSTALL_NOWARN')) {

                        if (@$fp = fopen(BH_INCLUDE_PATH. "config.inc.php", "w")) {

                            fwrite($fp, $config_file);
                            fclose($fp);

                            $config_saved = true;
                        }

                    }else {

                        $config_saved = true;
                    }

                    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
                    echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
                    echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\" dir=\"ltr\">\n";
                    echo "<head>\n";
                    echo "<title>BeehiveForum ", BEEHIVE_VERSION, " Installation</title>\n";
                    echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
                    echo "<link rel=\"icon\" href=\"./images/favicon.ico\" type=\"image/ico\" />\n";
                    echo "<link rel=\"stylesheet\" href=\"./styles/style.css\" type=\"text/css\" />\n";
                    echo "</head>\n";
                    echo "<h1>BeehiveForum ", BEEHIVE_VERSION, " Installation</h1>\n";
                    echo "<br />\n";
                    echo "<div align=\"center\">\n";

                    if ($config_saved) {

                        echo "<form method=\"post\" action=\"index.php\">\n";
                        echo "  <input type=\"hidden\" name=\"force_install\" value=\"", ($force_install) ? "yes" : "no", "\" />\n";
                        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
                        echo "    <tr>\n";
                        echo "      <td width=\"500\">\n";
                        echo "        <table class=\"box\" width=\"100%\">\n";
                        echo "          <tr>\n";
                        echo "            <td class=\"posthead\">\n";
                        echo "              <table class=\"posthead\" width=\"100%\">\n";
                        echo "                <tr>\n";
                        echo "                  <td class=\"subhead\">Installation Complete.</td>\n";
                        echo "                </tr>\n";
                        echo "                <tr>\n";
                        echo "                  <td>Installation of your Beehive Forum has completed successfully, but before you can use it you must delete both the install folder and install.php. Once this has been done you can click Continue below to start using your Beehive Forum.</td>\n";
                        echo "                </tr>\n";
                        echo "                <tr>\n";
                        echo "                  <td>&nbsp;</td>\n";
                        echo "                </tr>\n";
                        echo "                <tr>\n";
                        echo "                  <td width=\"500\"><span class=\"bhinputcheckbox\"><input type=\"checkbox\" name=\"install_remove_files\" id=\"install_remove_files\" value=\"Y\" checked=\"checked\"><label for=\"install_remove_files\">Attempt automatic removal of installation files (recommended)</label></span></td>\n";
                        echo "                </tr>\n";
                        echo "              </table>\n";
                        echo "            </td>\n";
                        echo "          </tr>\n";
                        echo "        </table>\n";
                        echo "      </td>\n";
                        echo "    </tr>\n";
                        echo "    <tr>\n";
                        echo "      <td>&nbsp;</td>\n";
                        echo "    </tr>\n";
                        echo "    <tr>\n";
                        echo "      <td align=\"center\"><input type=\"submit\" name=\"finish_install\" value=\"Continue\" class=\"button\" /></td>\n";
                        echo "    </tr>\n";
                        echo "  </table>\n";
                        echo "</form>\n";

                    }else {

                        echo "<form method=\"post\" action=\"install.php\">\n";
                        echo "  <input type=\"hidden\" name=\"force_install\" value=\"", ($force_install) ? "yes" : "no", "\" />\n";
                        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
                        echo "    <tr>\n";
                        echo "      <td width=\"500\">\n";
                        echo "        <table class=\"box\" width=\"100%\">\n";
                        echo "          <tr>\n";
                        echo "            <td class=\"posthead\">\n";
                        echo "              <table class=\"posthead\" width=\"100%\">\n";
                        echo "                <tr>\n";
                        echo "                  <td class=\"subhead\">Database Setup Completed</td>\n";
                        echo "                </tr>\n";
                        echo "                <tr>\n";
                        echo "                  <td>Your database has been succesfully setup for use with Beehive. However we were unable to automatically apply the changes to your config.inc.php.</td>\n";
                        echo "                <tr>\n";
                        echo "                  <td>&nbsp;</td>\n";
                        echo "                </tr>\n";
                        echo "                <tr>\n";
                        echo "                  <td>In order to complete the installation you will need to save a copy of your config.inc.php to your hard disc drive by clicking the 'Download Config' button below and from there upload it to your server into Beehive's 'include' folder. Once this is done you can click the Continue button below to start using your Beehive Forum.</td>\n";
                        echo "                </tr>\n";
                        echo "                <tr>\n";
                        echo "                  <td>&nbsp;</td>\n";
                        echo "                </tr>\n";
                        echo "              </table>\n";
                        echo "            </td>\n";
                        echo "          </tr>\n";
                        echo "        </table>\n";
                        echo "      </td>\n";
                        echo "    </tr>\n";
                        echo "    <tr>\n";
                        echo "      <td width=\"500\">&nbsp;</td>\n";
                        echo "    </tr>\n";
                        echo "    <tr>\n";
                        echo "      <td align=\"center\">\n";
                        echo "        <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
                        echo "          <tr>\n";
                        echo "            <td width=\"55%\" align=\"right\">\n";
                        echo "              <input type=\"hidden\" name=\"db_server\" value=\"$db_server\">\n";
                        echo "              <input type=\"hidden\" name=\"db_username\" value=\"$db_username\">\n";
                        echo "              <input type=\"hidden\" name=\"db_password\" value=\"$db_password\">\n";
                        echo "              <input type=\"hidden\" name=\"db_database\" value=\"$db_database\">\n";
                        echo "              <input type=\"submit\" name=\"download_config\" value=\"Download Config\" class=\"button\" />&nbsp;\n";
                        echo "            </td>\n";
                        echo "            <td width=\"45%\">\n";
                        echo "              <input type=\"submit\" name=\"finish_install\" value=\"Continue\" class=\"button\" />\n";
                        echo "            </td>\n";
                        echo "          </tr>\n";
                        echo "        </table>\n";
                        echo "      </td>\n";
                        echo "    </tr>\n";
                        echo "  </table>\n";
                        echo "</form>\n";
                    }

                    echo "</div>\n";
                    echo "</body>\n";
                    echo "</html>\n";
                    exit;

                }else {

                    $error_array[] = "Could not complete installation. Error was: failed to read config.inc.php\n";
                    $valid = false;
                }

            }else {

                if (($errno = db_errno($db_install)) > 0) {

                    $error_array[] = "<h2>Could not complete installation. Error was: ". db_error($db_install). " $sql</h2>\n";
                    $valid = false;
                }
            }

        }elseif ($valid) {

            $error_array[] = "<p>Database connection to '$db_server' could not be established. Please check your MySQL Database Configuration settings are correct and that you have permisison to access the database you've entered.</p>\n<p><b>Note:</b> The database must be created manually prior to the installation of the Beehive Forum software!</p>\n";
            $valid = false;
        }
    }

}elseif (isset($_POST['download_config']) && (!@file_exists(BH_INCLUDE_PATH. "config.inc.php") || $force_install)) {

    $config_file = "";

    if (@$fp = fopen('./install/config.inc.php', 'r')) {

        while (!feof($fp)) {

            $config_file.= fgets($fp, 100);
        }

        fclose($fp);

        if (isset($_POST['db_server']) && strlen(trim(_stripslashes($_POST['db_server']))) > 0) {
            $db_server = trim(_stripslashes($_POST['db_server']));
        }

        if (isset($_POST['db_database']) && strlen(trim(_stripslashes($_POST['db_database']))) > 0) {
            $db_database = trim(_stripslashes($_POST['db_database']));
        }

        if (isset($_POST['db_username']) && strlen(trim(_stripslashes($_POST['db_username']))) > 0) {
            $db_username = trim(_stripslashes($_POST['db_username']));
        }

        if (isset($_POST['db_password']) && strlen(trim(_stripslashes($_POST['db_password']))) > 0) {
            $db_password = trim(_stripslashes($_POST['db_password']));
        }

        if (isset($db_server) && isset($db_database) && isset($db_username) && isset($db_password)) {

            // Database details

            $config_file = str_replace('{db_server}',   $db_server,   $config_file);
            $config_file = str_replace('{db_database}', $db_database, $config_file);
            $config_file = str_replace('{db_username}', $db_username, $config_file);
            $config_file = str_replace('{db_password}', $db_password, $config_file);

            header("Content-Type: text/plain; name=\"config.inc.php\"");
            header("Content-disposition: attachment; filename=\"config.inc.php\"");

            echo $config_file;
            exit;

        }else {

            // Database details

            $config_file = str_replace('{db_server}',   "", $config_file);
            $config_file = str_replace('{db_database}', "", $config_file);
            $config_file = str_replace('{db_username}', "", $config_file);
            $config_file = str_replace('{db_password}', "", $config_file);

            install_msie_buffer_fix();

            echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
            echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
            echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\" dir=\"ltr\">\n";
            echo "<head>\n";
            echo "<title>BeehiveForum ", BEEHIVE_VERSION, " - Installation</title>\n";
            echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
            echo "<link rel=\"icon\" href=\"./images/favicon.ico\" type=\"image/ico\" />\n";
            echo "<link rel=\"stylesheet\" href=\"./styles/style.css\" type=\"text/css\" />\n";
            echo "</head>\n";

            echo "<h1>BeehiveForum ", BEEHIVE_VERSION, " Installation</h1>\n";
            echo "<br />\n";
            echo "<div align=\"center\">\n";
            echo "<table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
            echo "  <tr>\n";
            echo "    <td width=\"500\">\n";
            echo "      <table class=\"box\" width=\"100%\">\n";
            echo "        <tr>\n";
            echo "          <td class=\"posthead\">\n";
            echo "            <table class=\"posthead\" width=\"100%\">\n";
            echo "              <tr>\n";
            echo "                <td class=\"subhead\">Config Download Failed</td>\n";
            echo "              </tr>\n";
            echo "              <tr>\n";
            echo "                <td>Oops! It would appear that we don't have enough information to be able to send you your config.inc.php. This would only have happened if the previous page didn't send us the right information.</td>\n";
            echo "              </tr>\n";
            echo "              <tr>\n";
            echo "                <td>&nbsp;</td>\n";
            echo "              </tr>\n";
            echo "              <tr>\n";
            echo "                <td>Fortunately you can still get your Beehive Forum functional by following these simple instructions:</td>\n";
            echo "              <tr>\n";
            echo "                <td>\n";
            echo "                  <ol>\n";
            echo "                    <li><p>Copy and paste the text in the box below into a text editor.</p></li>\n";
            echo "                    <li><p>Edit the \$db_server, \$db_database, \$db_username and \$db_password entries near the top of the script to match those that you entered in the first step of this installation</p></li>\n";
            echo "                    <li><p>Save the file as config.inc.php (all in lowercase) and upload it to the 'include' folder of your Beehive installation.</p></li>\n";
            echo "                    <li><p>Delete the 'install' folder from the Beehive ditribution on your server.</p></li>\n";
            echo "                  </ol>\n";
            echo "                </td>\n";
            echo "              </tr>\n";
            echo "              <tr>\n";
            echo "                <td>&nbsp;</td>\n";
            echo "              </tr>\n";
            echo "              <tr>\n";
            echo "                <td>Once you've done all of that you can click the Continue button below to start using your Beehive Forum.</td>\n";
            echo "              </tr>\n";
            echo "              <tr>\n";
            echo "                <td>&nbsp;</td>\n";
            echo "              </tr>\n";
            echo "              <tr>\n";
            echo "                <td>&nbsp;<b>config.inc.php:</b></td>\n";
            echo "              </tr>\n";
            echo "              <tr>\n";
            echo "                <td align=\"center\"><textarea name=\"config_file\" rows=\"20\" cols=\"56\" wrap=\"off\">$config_file</textarea></td>\n";
            echo "              </tr>\n";
            echo "            </table>\n";
            echo "          </td>\n";
            echo "        </tr>\n";
            echo "      </table>\n";
            echo "    </td>\n";
            echo "  </tr>\n";
            echo "</table>\n";
            echo "<form method=\"post\" action=\"./install.php\">\n";
            echo "  <input type=\"hidden\" name=\"force_install\" value=\"", ($force_install) ? "yes" : "no", "\" />\n";
            echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
            echo "    <tr>\n";
            echo "      <td width=\"500\">&nbsp;</td>\n";
            echo "    </tr>\n";
            echo "    <tr>\n";
            echo "      <td align=\"center\"><input type=\"submit\" name=\"finish_install\" value=\"Continue\" class=\"button\" /></td>\n";
            echo "    </tr>\n";
            echo "  </table>\n";
            echo "</form>\n";
            echo "</div>\n";
            echo "</body>\n";
            echo "</html>\n";
            exit;
        }

    }else {

        $error_array[] = "Could not complete installation. Error was: failed to read config.inc.php\n";
        $valid = false;
    }
}

echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\" dir=\"ltr\">\n";
echo "<head>\n";
echo "<title>BeehiveForum ", BEEHIVE_VERSION, " - Installation</title>\n";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
echo "<link rel=\"icon\" href=\"./images/favicon.ico\" type=\"image/ico\" />\n";
echo "<link rel=\"stylesheet\" href=\"./styles/style.css\" type=\"text/css\" />\n";
echo "<script language=\"javascript\" type=\"text/javascript\" src=\"./js/install.js\"></script>\n";
echo "</head>\n";
echo "<body>\n";

if (!@file_exists(BH_INCLUDE_PATH. "config.inc.php") || $force_install) {

    echo "<form id=\"install_form\" method=\"post\" action=\"install.php\">\n";
    echo "<input type=\"hidden\" name=\"force_install\" value=\"", ($force_install) ? "yes" : "no", "\" />\n";
    echo "<h1>BeehiveForum ", BEEHIVE_VERSION, " Installation</h1>\n";
    echo "<div align=\"center\">\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
    echo "    <tr>\n";
    echo "      <td colspan=\"2\">\n";
    echo "        <p>Welcome to the BeehiveForum installation script. To get everything kicking off to a great start please fill out the details below and click the Install button!</p>\n";
    echo "        <p><b>WARNING</b>: Proceed only if you have performed a backup of your database! Failure to do so could result in loss of your forum. You have been warned!</p>\n";
    echo "      </td>\n";
    echo "    </tr>\n";

    if (isset($error_array) && sizeof($error_array) > 0) {

        echo "    <tr>\n";
        echo "      <td colspan=\"2\"><hr /></td>\n";
        echo "    </tr>\n";
        echo "    <tr>\n";
        echo "      <td><img src=\"./images/warning.png\" /></td>\n";
        echo "      <td><h2>The following errors need correcting before you continue:</h2></td>\n";
        echo "    </tr>\n";
        echo "    <tr>\n";
        echo "      <td colspan=\"2\">\n";
        echo "        <ul>\n";

        foreach ($error_array as $error_text) {
            echo "      <li>$error_text</li>\n";
        }

        echo "        </ul>\n";
        echo "      </td>\n";
        echo "    </tr>\n";
    }

    echo "  </table>\n";
    echo "  <br />\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
    echo "    <tr>\n";
    echo "      <td width=\"500\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td class=\"posthead\">\n";
    echo "              <table cellpadding=\"2\" cellspacing=\"0\" class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td nowrap=\"nowrap\" class=\"subhead\">Basic Configuration</td>\n";
    echo "                  <td nowrap=\"nowrap\" class=\"subhead\" align=\"right\"><a href=\"javascript:void(0)\" onclick=\"return show_install_help(0)\" tabindex=\"15\"><img src=\"./images/help.png\" border=\"0\" alt=\"Help!\" title=\"Help!\" /></a></td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\" colspan=\"2\">\n";
    echo "                    <table cellpadding=\"2\" cellspacing=\"0\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td width=\"220\" class=\"postbody\">Installation Method:</td>\n";
    echo "                        <td>\n";
    echo "                          <select name=\"install_method\" id =\"install_method\" class=\"install_dropdown\" tabindex=\"1\">\n";
    echo "                            <option value=\"\">Please select...</option>\n";
    echo "                            <option value=\"0\" ", (isset($install_method) && $install_method == 0) ? "selected=\"selected\"" : "", ">New Install</option>\n";
    echo "                            <option value=\"1\" ", (isset($install_method) && $install_method == 1) ? "selected=\"selected\"" : "", ">Reinstall</option>\n";
    echo "                            <option value=\"2\" ", (isset($install_method) && $install_method == 2) ? "selected=\"selected\"" : "", ">Reconnect</option>\n";
    echo "                            <option value=\"4\" ", (isset($install_method) && $install_method == 4) ? "selected=\"selected\"" : "", ">Upgrade 0.5 to 0.6.4</option>\n";
    echo "                            <option value=\"5\" ", (isset($install_method) && $install_method == 5) ? "selected=\"selected\"" : "", ">Upgrade 0.6RCx or 0.6.x to 0.6.4</option>\n";
    echo "                          </select>\n";
    echo "                        </td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td width=\"200\" valign=\"top\" class=\"postbody\">Default Forum Webtag:</td>\n";
    echo "                        <td><input type=\"text\" name=\"forum_webtag\" class=\"install_text\" value=\"", (isset($forum_webtag) ? $forum_webtag : ""), "\" size=\"36\" maxlength=\"64\" tabindex=\"2\" /></td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td colspan=\"2\">&nbsp;</td>\n";
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
    echo "  <br />\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
    echo "    <tr>\n";
    echo "      <td width=\"500\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td class=\"posthead\">\n";
    echo "              <table cellpadding=\"2\" cellspacing=\"0\" class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td nowrap=\"nowrap\" class=\"subhead\">MySQL Database Configuration</td>\n";
    echo "                  <td nowrap=\"nowrap\" class=\"subhead\" align=\"right\"><a href=\"javascript:void(0)\" onclick=\"return show_install_help(1)\" tabindex=\"16\"><img src=\"./images/help.png\" border=\"0\" alt=\"Help!\" title=\"Help!\" /></a></td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\" colspan=\"2\">\n";
    echo "                    <table cellpadding=\"2\" cellspacing=\"0\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td width=\"220\" class=\"postbody\">Hostname:</td>\n";
    echo "                        <td><input type=\"text\" name=\"db_server\" class=\"install_text\" value=\"", (isset($db_server) ? $db_server : "localhost"), "\" size=\"36\" maxlength=\"64\" tabindex=\"3\" /></td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td width=\"220\" class=\"postbody\">Database Name:</td>\n";
    echo "                        <td><input type=\"text\" name=\"db_database\" class=\"install_text\" value=\"", (isset($db_database) ? $db_database : ""), "\" size=\"36\" maxlength=\"64\" tabindex=\"4\" /></td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td width=\"220\" class=\"postbody\">Username:</td>\n";
    echo "                        <td><input type=\"text\" name=\"db_username\" class=\"install_text\" value=\"", (isset($db_username) ? $db_username : ""), "\" size=\"36\" maxlength=\"64\" tabindex=\"5\" /></td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td width=\"220\" class=\"postbody\">Password:</td>\n";
    echo "                        <td><input type=\"password\" name=\"db_password\" class=\"install_text\" value=\"\" size=\"36\" maxlength=\"64\" tabindex=\"6\" /></td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td width=\"220\" class=\"postbody\">Confirm Password:</td>\n";
    echo "                        <td><input type=\"password\" name=\"db_cpassword\" class=\"install_text\" value=\"\" size=\"36\" maxlength=\"64\" tabindex=\"7\" /></td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td colspan=\"2\">&nbsp;</td>\n";
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
    echo "  <br />\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
    echo "    <tr>\n";
    echo "      <td width=\"500\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td class=\"posthead\">\n";
    echo "              <table cellpadding=\"2\" cellspacing=\"0\" class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td nowrap=\"nowrap\" class=\"subhead\">Admin Account (New installations only)</td>\n";
    echo "                  <td nowrap=\"nowrap\" class=\"subhead\" align=\"right\"><a href=\"javascript:void(0)\" onclick=\"return show_install_help(2)\" tabindex=\"17\"><img src=\"./images/help.png\" border=\"0\" alt=\"Help!\" title=\"Help!\" /></a></td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\" colspan=\"2\">\n";
    echo "                    <table cellpadding=\"2\" cellspacing=\"0\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td width=\"220\" class=\"postbody\">Admin Username:</td>\n";
    echo "                        <td><input type=\"text\" name=\"admin_username\" class=\"install_text\" value=\"", (isset($admin_username) ? $admin_username : ""), "\" size=\"36\" maxlength=\"64\" tabindex=\"8\" /></td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td width=\"220\" class=\"postbody\">Admin Email Address:</td>\n";
    echo "                        <td><input type=\"text\" name=\"admin_email\" class=\"install_text\" value=\"", (isset($admin_email) ? $admin_email : ""), "\" size=\"36\" maxlength=\"64\" tabindex=\"9\" /></td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td width=\"220\" class=\"postbody\">Admin Password:</td>\n";
    echo "                        <td><input type=\"password\" name=\"admin_password\" class=\"install_text\" value=\"\" size=\"36\" maxlength=\"64\" tabindex=\"10\" /></td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td width=\"220\" class=\"postbody\">Confirm Password:</td>\n";
    echo "                        <td><input type=\"password\" name=\"admin_cpassword\" class=\"install_text\" value=\"\" size=\"36\" maxlength=\"64\" tabindex=\"11\" /></td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td colspan=\"2\">&nbsp;</td>\n";
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
    echo "  <br />\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
    echo "    <tr>\n";
    echo "      <td width=\"500\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td class=\"posthead\">\n";
    echo "              <table cellpadding=\"2\" cellspacing=\"0\" class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td nowrap=\"nowrap\" class=\"subhead\">Advanced Options</td>\n";
    echo "                  <td nowrap=\"nowrap\" class=\"subhead\" align=\"right\"><a href=\"javascript:void(0)\" onclick=\"return show_install_help(3)\" tabindex=\"18\"><img src=\"./images/help.png\" border=\"0\" alt=\"Help!\" title=\"Help!\" /></a></td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\" colspan=\"2\">\n";
    echo "                    <table cellpadding=\"2\" cellspacing=\"0\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td><span class=\"bhinputcheckbox\"><input type=\"checkbox\" name=\"remove_conflicts\" id=\"remove_conflicts\" value=\"Y\" tabindex=\"12\" /><label for=\"remove_conflicts\">Automatically remove tables that conflict with BeehiveForum's own.</label></span></td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td><span class=\"bhinputcheckbox\"><input type=\"checkbox\" name=\"skip_dictionary\" id=\"skip_dictionary\" value=\"Y\" tabindex=\"13\" /><label for=\"skip_dictionary\">Skip dictionary setup (recommended only if install fails to complete).</label></span></td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td colspan=\"2\">&nbsp;</td>\n";
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
    echo "    <tr>\n";
    echo "      <td>&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td><p>The installation process may take several minutes to complete. Please click the Install button once and once only. Clicking it multiple times may cause your installation to become corrupted.</p></td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td>&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"center\"><input type=\"submit\" name=\"install\" value=\"Install\" class=\"button\" onclick=\"return confirm_install(this);\" tabindex=\"14\" /></td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</form>\n";
    echo "</div>\n";

}else {

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "<form id=\"install_form\" method=\"get\" action=\"install.php\">\n";
    echo "  <input type=\"hidden\" name=\"force_install\" value=\"yes\" />\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
    echo "    <tr>\n";
    echo "      <td>\n";
    echo "        <table class=\"box\">\n";
    echo "          <tr>\n";
    echo "            <td class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"500\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\">Installation Already Complete</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td>Your BeehiveForum would appear to be already installed. If this is not the case or you need to perform an upgrade please click the ignore button below.</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td>&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "            </td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td>&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"center\"><input type=\"submit\" name=\"install\" value=\"Ignore\" class=\"button\" /></td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</form>\n";
    echo "</div>\n";
}

echo "</body>\n";
echo "</html>\n";

?>