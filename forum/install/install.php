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

/* $Id: install.php,v 1.1 2004-05-08 23:56:37 decoyduck Exp $ */

include_once("../include/constants.inc.php");

if (isset($_POST['submit'])) {

    $valid = true;
    $error_html = "";

    if (isset($_POST['install_method']) && is_numeric($_POST['install_method'])) {
        if ($_POST['install_method'] == 0 || $_POST['install_method'] == 1) {
            $install_method = $_POST['install_method'];
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
        $forum_webtag.= "_";

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

    if ($valid && $install_method == 1) {

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

        if ($admin_password != $admin_cpassword) {
            $error_html.= "<h2>Administrator account passwords do not match.</h2>\n";
            $valid = false;
        }

        if ($db_password != $db_cpassword) {
            $error_html.= "<h2>MySQL database passwords do not match.</h2>\n";
            $valid = false;
        }
    }

    if ($valid) {

        if ($db_install = mysql_connect($db_server, $db_username, $db_password)) {

            if (mysql_select_db($db_database, $db_install)) {

                if ($install_method == 0) {
                    $schema_file = "install.sql";
                }else {
                    $schema_file = "upgrade.sql";
                }

                if (file_exists($schema_file)) {

                    $schema_array = file($schema_file);

                    foreach ($schema_array as $key => $schema_entry) {
                        if (substr($schema_entry, 0, 1) == "#") {
                            unset($schema_array[$key]);
                        }else {
                            $schema_entry = str_replace('{$forum_webtag}',   $forum_webtag,   $schema_entry);
                            $schema_entry = str_replace('{$admin_username}', $admin_username, $schema_entry);
                            $schema_entry = str_replace('{$admin_password}', $admin_password, $schema_entry);
                            $schema_entry = str_replace('{$admin_email}',    $admin_email,    $schema_entry);
                            $schema_array[$key] = $schema_entry;
                        }
                    }

                    $schema_array = explode(";", implode("", $schema_array));

                    foreach ($schema_array as $key => $schema_entry) {
                        if ($valid) {
                            if (!mysql_query(trim($schema_entry), $db_install)) {
                                $valid = false;
                            }
                        }
                    }

                    if ($valid) {

                        echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		        echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
		        echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\" dir=\"ltr\">\n";
		        echo "<head>\n";
		        echo "<title>BeehiveForum Installation</title>\n";
		        echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
		        echo "<link rel=\"icon\" href=\"images/favicon.ico\" type=\"image/ico\">\n";
		        echo "<link rel=\"stylesheet\" href=\"styles/style.css\" type=\"text/css\" />\n";
                        echo "</head>\n";
                        echo "<h1>BeehiveForum Installation</h2>\n";
                        echo "<div align=\"center\">\n";
                        echo "<form method=\"post\" action=\"index.php\">\n";
                        echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"500\">\n";
                        echo "    <tr>\n";
                        echo "      <td width=\"250\">\n";
                        echo "        <table class=\"box\" width=\"100%\">\n";
                        echo "          <tr>\n";
                        echo "            <td class=\"posthead\">\n";
                        echo "              <table class=\"posthead\" width=\"100%\">\n";
                        echo "                <tr>\n";
                        echo "                  <td class=\"subhead\">Installation Complete</td>\n";
                        echo "                </tr>\n";
                        echo "                <tr>\n";
                        echo "                  <td>Installation Completed Successfully!</td>\n";
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
                        echo "</div>\n";
                        echo "</body>\n";
                        echo "</html>\n";
                        exit;

                    }else {

                        $error_html.="<h2>Could not complete installation. Error was: ". mysql_error($db_install). "</h2>\n";
                        $valid = false;
                    }

                }else {

                   $error_html.= "<h2>Could not find the required schema file.</h2>\n";
                   $valid = false;
                }

            }elseif ($valid) {

                $error_html.= "<h2>Database '$db_database' does not exist or permission is denied.</h2>\n";
                $valid = false;
            }

        }elseif ($valid) {

            $error_html.= "<h2>Database connection to '$db_server' could not be established or permission is denied.</h2>\n";
            $valid = false;
        }
    }
}

echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\" dir=\"ltr\">\n";
echo "<head>\n";
echo "<title>BeehiveForum", BEEHIVE_VERSION, " - Installation</title>\n";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
echo "<link rel=\"icon\" href=\"../images/favicon.ico\" type=\"image/ico\">\n";
echo "<link rel=\"stylesheet\" href=\"../styles/style.css\" type=\"text/css\" />\n";
echo "</head>\n";

echo "<h1>BeehiveForum ", BEEHIVE_VERSION, " Installation (Doesn't work 100% yet!)</h2>\n";
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
echo "      <td width=\"250\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" colspan=\"2\">Basic Configuration</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"250\">Choose Installation Method:</td>\n";
echo "                  <td width=\"250\"><select name=\"install_method\" class=\"bhselect\" autocomplete=\"off\" dir=\"ltr\"><option value=\"0\" selected=\"selected\">New Install</option><option value=\"1\">Upgrade</option></select></td>\n";
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
echo "      <td width=\"250\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" colspan=\"2\">MySQL Database Configuration</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"250\">Hostname:</td>\n";
echo "                  <td width=\"250\"><input type=\"text\" name=\"db_server\" class=\"bhinputtext\" autocomplete=\"off\" value=\"\" size=\"36\" maxlength=\"64\" dir=\"ltr\" /></td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"250\">Database Name:</td>\n";
echo "                  <td width=\"250\"><input type=\"text\" name=\"db_database\" class=\"bhinputtext\" autocomplete=\"off\" value=\"\" size=\"36\" maxlength=\"64\" dir=\"ltr\" /></td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"250\">Username:</td>\n";
echo "                  <td width=\"250\"><input type=\"text\" name=\"db_username\" class=\"bhinputtext\" autocomplete=\"off\" value=\"\" size=\"36\" maxlength=\"64\" dir=\"ltr\" /></td>\n";
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
echo "      <td width=\"250\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" colspan=\"2\">Admin Account</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"250\">Admin Username:</td>\n";
echo "                  <td width=\"250\"><input type=\"text\" name=\"admin_username\" class=\"bhinputtext\" autocomplete=\"off\" value=\"\" size=\"36\" maxlength=\"64\" dir=\"ltr\" /></td>\n";
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
echo "                  <td width=\"250\">Admin Email Address:</td>\n";
echo "                  <td width=\"250\"><input type=\"text\" name=\"admin_email\" class=\"bhinputtext\" autocomplete=\"off\" value=\"\" size=\"36\" maxlength=\"64\" dir=\"ltr\" /></td>\n";
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
echo "</body>\n";
echo "</html>\n";

?>