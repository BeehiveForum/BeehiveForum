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

/* $Id: install.php,v 1.4 2004-10-29 19:54:17 decoyduck Exp $ */

if (@file_exists("./include/config.inc.php")) {
    include_once("./include/config.inc.php");
}

include_once("./include/db.inc.php");
include_once("./include/constants.inc.php");

if (isset($_POST['submit']) && !defined('BEEHIVE_INSTALLED')) {

    $valid = true;
    $config_saved = false;

    $error_html = "";

    if (isset($_POST['install_method']) && strlen(trim($_POST['forum_webtag'])) > 0) {
        if (trim($_POST['install_method']) == 'install') {
            $install_method = 0;
        }else if (trim($_POST['install_method']) == 'upgrade') {
            $install_method = 1;
        }else {
            $error_html.= "<h2>You must choose an installation method.</h2>\n";
            $valid = false;
        }
    }else {
        $error_html.= "<h2>You must choose an installation method.</h2>\n";
        $valid = false;
    }

    if (isset($_POST['forum_webtag']) && strlen(trim($_POST['forum_webtag'])) > 0) {

        $forum_webtag = strtoupper(trim($_POST['forum_webtag']));

        if (!preg_match("/^[A-Z0-9_-]+$/", $forum_webtag)) {
            $error_html.= "<h2>The forum webtag can only conatin uppercase A-Z, 0-9 and hyphen (-) and underscore (_) characters</h2>\n";
            $valid = false;
        }

    }else {
        $forum_webtag = "";
    }

    if (isset($_POST['db_server']) && strlen(trim($_POST['db_server'])) > 0) {
        $db_server = trim($_POST['db_server']);
    }else {
        $error_html.= "<h2>You must supply the hostname of your MySQL database.</h2>\n";
        $valid = false;
    }

    if (isset($_POST['db_database']) && strlen(trim($_POST['db_database'])) > 0) {
        $db_database = trim($_POST['db_database']);
    }else {
        $error_html.= "<h2>You must supply the name of your MySQL database.</h2>\n";
        $valid = false;
    }

    if (isset($_POST['db_username']) && strlen(trim($_POST['db_username'])) > 0) {
        $db_username = trim($_POST['db_username']);
    }else {
        $error_html.= "<h2>You must enter your username for your MySQL database.</h2>\n";
        $valid = false;
    }

    if (isset($_POST['db_password']) && strlen(trim($_POST['db_password'])) > 0) {
        $db_password = trim($_POST['db_password']);
    }else {
        $error_html.= "<h2>You must enter your password for your MySQL database.</h2>\n";
        $valid = false;
    }

    if (isset($_POST['db_cpassword']) && strlen(trim($_POST['db_cpassword'])) > 0) {
        $db_cpassword = trim($_POST['db_cpassword']);
    }else {
        $db_cpassword = "";
    }

    if ($install_method == 0) {

        if (isset($_POST['admin_username']) && strlen(trim($_POST['admin_username'])) > 0) {
            $admin_username = trim($_POST['admin_username']);
        }else {
            $error_html.= "<h2>You must supply a username for your administrator account.</h2>\n";
            $valid = false;
        }

        if (isset($_POST['admin_password']) && strlen(trim($_POST['admin_password'])) > 0) {
            $admin_password = trim($_POST['admin_password']);
        }else {
            $error_html.= "<h2>You must supply a password for your administrator account.</h2>\n";
            $valid = false;
        }

        if (isset($_POST['admin_cpassword']) && strlen(trim($_POST['admin_cpassword'])) > 0) {
            $admin_cpassword = trim($_POST['admin_cpassword']);
        }else {
            $admin_cpassword = "";
        }

        if (isset($_POST['admin_email']) && strlen(trim($_POST['admin_email'])) > 0) {
            $admin_email = trim($_POST['admin_email']);
        }else {
            $admin_email = "";
        }
    }

    if ($valid) {

        if ($install_method == 0 && ($admin_password != $admin_cpassword)) {
            $error_html.= "<h2>Administrator account passwords do not match.</h2>\n";
            $valid = false;
        }

        if ($db_password != $db_cpassword) {
            $error_html.= "<h2>MySQL database passwords do not match.</h2>\n";
            $valid = false;
        }
    }

    if ($valid) {

        if ($db_install = db_connect()) {

            if (($install_method == 1) && (@file_exists('./install/upgrade_script.php'))) {

                include_once("./install/upgrade_script.php");

            }elseif (($install_method == 0) && (@file_exists('./install/install_script.php'))) {

                include_once("./install/install_script.php");

            }else {

                $error_html.= "<h2>Could not find the required script.</h2>\n";
                $valid = false;
            }

            if ($valid) {

                $config_file = implode("", file("./install/config.inc.php"));

                // Database details

                $config_file = str_replace('{db_server}',   $db_server,   $config_file);
                $config_file = str_replace('{db_username}', $db_username, $config_file);
                $config_file = str_replace('{db_password}', $db_password, $config_file);
                $config_file = str_replace('{db_database}', $db_database, $config_file);

                // Constant that says we're installed.

                $config_file = str_replace("// define('BEEHIVE_INSTALLED', 1);", "define('BEEHIVE_INSTALLED', 1);", $config_file);

                if ($fp = fopen("./include/config.inc.php", "w")) {

                    fwrite($fp, $config_file);
                    fclose($fp);

                    $config_saved = true;
                }

                echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
                echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
                echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\" dir=\"ltr\">\n";
                echo "<head>\n";
                echo "<title>BeehiveForum ", BEEHIVE_VERSION, " Installation</title>\n";
                echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
                echo "<link rel=\"icon\" href=\"./images/favicon.ico\" type=\"image/ico\">\n";
                echo "<link rel=\"stylesheet\" href=\"./styles/style.css\" type=\"text/css\" />\n";
                echo "</head>\n";
                echo "<h1>BeehiveForum ", BEEHIVE_VERSION, " Installation</h2>\n";
                echo "<br />\n";
                echo "<div align=\"center\">\n";

                if ($config_saved) {

                    echo "<form method=\"post\" action=\"./index.php\">\n";
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
                    echo "                  <td>Installation of your Beehive Forum has completed successfully, but before you can use it you must delete this install folder and the files it contains. Once this has been done you can click Continue below to start using your Beehive Forum.</td>\n";
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
                    echo "      <td width=\"250\">&nbsp;</td>\n";
                    echo "    </tr>\n";
                    echo "    <tr>\n";
                    echo "      <td align=\"center\"><input type=\"submit\" name=\"submit\" value=\"Continue\" autocomplete=\"off\" class=\"button\" /></td>\n";
                    echo "    </tr>\n";
                    echo "  </table>\n";
                    echo "</form>\n";

                }else {

                    echo "<table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
                    echo "  <tr>\n";
                    echo "    <td width=\"500\">\n";
                    echo "      <table class=\"box\" width=\"100%\">\n";
                    echo "        <tr>\n";
                    echo "          <td class=\"posthead\">\n";
                    echo "            <table class=\"posthead\" width=\"100%\">\n";
                    echo "              <tr>\n";
                    echo "                <td class=\"subhead\">Database Setup Completed</td>\n";
                    echo "              </tr>\n";
                    echo "              <tr>\n";
                    echo "                <td>Your database has been succesfully setup for use with Beehive. However we were unable to apply the changes to your config.inc.php.</td>\n";
                    echo "              <tr>\n";
                    echo "                <td>&nbsp;</td>\n";
                    echo "              </tr>\n";
                    echo "              <tr>\n";
                    echo "                <td>Don't worry this is can be perfectly normal on some systems. In order to complete the installation you will need to download the config data by clicking the 'Download Config' button below to save the config.inc.php to your hard disk drive. From there you will need to upload it to your server, into Beehive's 'include' folder. Once this is done you can click the Continue button below to start using your Beehive Forum.</td>\n";
                    echo "              </tr>\n";
                    echo "              <tr>\n";
                    echo "                <td>&nbsp;</td>\n";
                    echo "              </tr>\n";
                    echo "            </table>\n";
                    echo "          </td>\n";
                    echo "        </tr>\n";
                    echo "      </table>\n";
                    echo "    </td>\n";
                    echo "  </tr>\n";
                    echo "  <tr>\n";
                    echo "    <td width=\"500\">&nbsp;</td>\n";
                    echo "  </tr>\n";
                    echo "  <tr>\n";
                    echo "    <td align=\"center\">\n";
                    echo "      <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
                    echo "        <tr>\n";
                    echo "          <td width=\"55%\" align=\"right\">\n";
                    echo "            <form method=\"post\" action=\"install.php\">\n";
                    echo "              <input type=\"hidden\" name=\"db_server\" value=\"$db_server\">\n";
                    echo "              <input type=\"hidden\" name=\"db_username\" value=\"$db_username\">\n";
                    echo "              <input type=\"hidden\" name=\"db_password\" value=\"$db_password\">\n";
                    echo "              <input type=\"hidden\" name=\"db_database\" value=\"$db_database\">\n";
                    echo "              <input type=\"submit\" name=\"download_config\" value=\"Download Config\" autocomplete=\"off\" class=\"button\" />&nbsp;\n";
                    echo "            </form>\n";
                    echo "          </td>\n";
                    echo "          <td width=\"45%\">\n";
                    echo "            <form method=\"post\" action=\"./index.php\">\n";
                    echo "              <input type=\"submit\" name=\"submit\" value=\"Continue\" autocomplete=\"off\" class=\"button\" />\n";
                    echo "            </form>\n";
                    echo "          </td>\n";
                    echo "        </tr>\n";
                    echo "      </table>\n";
                    echo "    </td>\n";
                    echo "  </tr>\n";
                    echo "</table>\n";
                }

                echo "</div>\n";
                echo "</body>\n";
                echo "</html>\n";
                exit;

            }else {

                $error_html.="<h2>Could not complete installation. Error was: ". db_error($db_install). "</h2>\n";
                $valid = false;
            }

        }elseif ($valid) {

            $error_html.= "<h2>Database connection to '$db_server' could not be established or permission is denied.</h2>\n";
            $valid = false;
        }
    }

}elseif (isset($_POST['download_config']) && !defined('BEEHIVE_INSTALLED')) {

    $config_file = implode("", file("./install/config.inc.php"));

    if (isset($_POST['db_server']) && strlen(trim($_POST['db_server'])) > 0) {
        $db_server = trim($_POST['db_server']);
    }

    if (isset($_POST['db_database']) && strlen(trim($_POST['db_database'])) > 0) {
        $db_database = trim($_POST['db_database']);
    }

    if (isset($_POST['db_username']) && strlen(trim($_POST['db_username'])) > 0) {
        $db_username = trim($_POST['db_username']);
    }

    if (isset($_POST['db_password']) && strlen(trim($_POST['db_password'])) > 0) {
        $db_password = trim($_POST['db_password']);
    }

    if (isset($db_server) && isset($db_database) && isset($db_username) && isset($db_password)) {

        // Database details

        $config_file = str_replace('{db_server}',   $db_server,   $config_file);
        $config_file = str_replace('{db_database}', $db_database, $config_file);
        $config_file = str_replace('{db_username}', $db_username, $config_file);
        $config_file = str_replace('{db_password}', $db_password, $config_file);

        // Constant that says we're installed.

        $config_file = str_replace("// define('BEEHIVE_INSTALLED', 1);", "define('BEEHIVE_INSTALLED', 1);", $config_file);

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

        // Constant that says we're installed.

        $config_file = str_replace("// define('BEEHIVE_INSTALLED', 1);", "define('BEEHIVE_INSTALLED', 1);", $config_file);

        echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
        echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
        echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\" dir=\"ltr\">\n";
        echo "<head>\n";
        echo "<title>BeehiveForum ", BEEHIVE_VERSION, " - Installation</title>\n";
        echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
        echo "<link rel=\"icon\" href=\"./images/favicon.ico\" type=\"image/ico\">\n";
        echo "<link rel=\"stylesheet\" href=\"./styles/style.css\" type=\"text/css\" />\n";
        echo "</head>\n";

        echo "<h1>BeehiveForum ", BEEHIVE_VERSION, " Installation</h2>\n";
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
        echo "<form method=\"get\" action=\"./index.php\">\n";
        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
        echo "    <tr>\n";
        echo "      <td width=\"500\">&nbsp;</td>\n";
        echo "    </tr>\n";
        echo "    <tr>\n";
        echo "      <td align=\"center\"><input type=\"submit\" name=\"submit\" value=\"Continue\" autocomplete=\"off\" class=\"button\" /></td>\n";
        echo "    </tr>\n";
        echo "  </table>\n";
        echo "</form>\n";
        echo "</div>\n";
        echo "</body>\n";
        echo "</html>\n";
        exit;
    }
}

echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\" dir=\"ltr\">\n";
echo "<head>\n";
echo "<title>BeehiveForum ", BEEHIVE_VERSION, " - Installation</title>\n";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
echo "<link rel=\"icon\" href=\"./images/favicon.ico\" type=\"image/ico\">\n";
echo "<link rel=\"stylesheet\" href=\"./styles/style.css\" type=\"text/css\" />\n";
echo "</head>\n";

echo "<h1>BeehiveForum ", BEEHIVE_VERSION, " Installation</h2>\n";

if (!defined('BEEHIVE_INSTALLED')) {

    echo "<p>Welcome to the BeehiveForum installation script. To get everything kicking off to a great start please fill out the details below and click the Install button!</p>\n";
    echo "<p><b>WARNING</b>: Proceed only if you have performed a backup of your database! Failure to do so could result in loss of your forum. You have been warned!</p>\n";

    if (isset($error_html)) {
        echo $error_html;
        echo "<br />\n";
    }

    echo "<div align=\"center\">\n";
    echo "<form method=\"post\" action=\"install.php\">\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
    echo "    <tr>\n";
    echo "      <td width=\"500\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" colspan=\"2\">Basic Configuration</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td width=\"250\">Choose Installation Method:</td>\n";
    echo "                  <td width=\"250\"><select name=\"install_method\" class=\"bhselect\" autocomplete=\"off\" dir=\"ltr\"><option value=\"install\" selected=\"selected\">New Install</option><option value=\"upgrade\">Upgrade</option></select></td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td width=\"250\" valign=\"top\">Default Forum Webtag:</td>\n";
    echo "                  <td width=\"250\"><input type=\"text\" name=\"forum_webtag\" class=\"bhinputtext\" autocomplete=\"off\" value=\"default\" size=\"36\" maxlength=\"64\" dir=\"ltr\" /></td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td width=\"250\">&nbsp;</td>\n";
    echo "                  <td width=\"250\">(not applicable during upgrade)</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td colspan=\"2\">&nbsp;</td>\n";
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
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" colspan=\"2\">MySQL Database Configuration</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td width=\"250\">Hostname:</td>\n";
    echo "                  <td width=\"250\"><input type=\"text\" name=\"db_server\" class=\"bhinputtext\" autocomplete=\"off\" value=\"", (isset($db_server) ? $db_server : ""), "\" size=\"36\" maxlength=\"64\" dir=\"ltr\" /></td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td width=\"250\">Database Name:</td>\n";
    echo "                  <td width=\"250\"><input type=\"text\" name=\"db_database\" class=\"bhinputtext\" autocomplete=\"off\" value=\"", (isset($db_username) ? $db_username : ""), "\" size=\"36\" maxlength=\"64\" dir=\"ltr\" /></td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td width=\"250\">Username:</td>\n";
    echo "                  <td width=\"250\"><input type=\"text\" name=\"db_username\" class=\"bhinputtext\" autocomplete=\"off\" value=\"", (isset($db_username) ? $db_username : ""), "\" size=\"36\" maxlength=\"64\" dir=\"ltr\" /></td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td width=\"250\">Password:</td>\n";
    echo "                  <td width=\"250\"><input type=\"password\" name=\"db_password\" class=\"bhinputtext\" autocomplete=\"off\" value=\"\" size=\"36\" maxlength=\"64\" dir=\"ltr\" /></td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td width=\"250\">Confirm Password:</td>\n";
    echo "                  <td width=\"250\"><input type=\"password\" name=\"db_cpassword\" class=\"bhinputtext\" autocomplete=\"off\" value=\"\" size=\"36\" maxlength=\"64\" dir=\"ltr\" /></td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td colspan=\"2\">&nbsp;</td>\n";
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
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td class=\"subhead\" colspan=\"2\">Admin Account (New installations only)</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td width=\"250\">Admin Username:</td>\n";
    echo "                  <td width=\"250\"><input type=\"text\" name=\"admin_username\" class=\"bhinputtext\" autocomplete=\"off\" value=\"", (isset($admin_username) ? $admin_username : ""), "\" size=\"36\" maxlength=\"64\" dir=\"ltr\" /></td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td width=\"250\">Admin Email Address:</td>\n";
    echo "                  <td width=\"250\"><input type=\"text\" name=\"admin_email\" class=\"bhinputtext\" autocomplete=\"off\" value=\"", (isset($admin_email) ? $admin_email : ""), "\" size=\"36\" maxlength=\"64\" dir=\"ltr\" /></td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td width=\"250\">Admin Password:</td>\n";
    echo "                  <td width=\"250\"><input type=\"password\" name=\"admin_password\" class=\"bhinputtext\" autocomplete=\"off\" value=\"\" size=\"36\" maxlength=\"64\" dir=\"ltr\" /></td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td width=\"250\">Confirm Password:</td>\n";
    echo "                  <td width=\"250\"><input type=\"password\" name=\"admin_cpassword\" class=\"bhinputtext\" autocomplete=\"off\" value=\"\" size=\"36\" maxlength=\"64\" dir=\"ltr\" /></td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td colspan=\"2\">&nbsp;</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "            </td>\n";
    echo "          </tr>\n";
    echo "        </table>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td width=\"250\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"center\"><input type=\"submit\" name=\"submit\" value=\"Install\" autocomplete=\"off\" class=\"button\" /></td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</form>\n";
    echo "</div>\n";

}else {

    echo "<br />\n";
    echo "<div align=\"center\">\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
    echo "    <tr>\n";
    echo "      <td>\n";
    echo "        <table class=\"box\">\n";
    echo "          <tr>\n";
    echo "            <td class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"500\">\n";
    echo "                <tr>\n";
    echo "                  <td colspan=\"2\" class=\"subhead\">Installation Already Complete</td>\n";
    echo "                </tr>\n";
    echo "                <tr>\n";
    echo "                  <td>Your BeehiveForum would appear to be already installed, but you have not removed the install folder. You must delete the 'install' directory before your Beehive Forum can be used.</td>\n";
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
    echo "  </table>\n";
    echo "</div>\n";
    echo "</body>\n";
    echo "</html>\n";
}

?>