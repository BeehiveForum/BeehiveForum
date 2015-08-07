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
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'form.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'server.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
require_once BH_INCLUDE_PATH . 'user.inc.php';
// End Required includes

function logon_perform()
{
    // Check to see if the user is logging in as a guest or a normal user.
    if (isset($_POST['guest_logon'])) {

        // Check the Guest account is enabled.
        if (!user_guest_enabled()) return false;

        // Initialise Guest user session.
        session::start(0);

        // Generate new CSRF token
        session::refresh_csrf_token();

        // Update the visitor log
        session::update_visitor_log(0, true);

        // Success
        return true;

    } else if (isset($_POST['user_logon']) && isset($_POST['user_password'])) {

        // Extract the submitted username
        $user_logon = $_POST['user_logon'];

        // Extract the submitted password
        $user_password = $_POST['user_password'];

        // Try and login the user.
        if (($uid = user_logon($user_logon, $user_password)) !== false) {

            // Initialise a user session.
            session::start($uid);

            // Generate new CSRF token
            session::refresh_csrf_token();

            // Update User's last forum visit
            forum_update_last_visit($uid);

            // Update the visitor log
            session::update_visitor_log($uid, true);

            // Check if we should save a token to allow auto logon,
            if (isset($_POST['user_remember']) && ($_POST['user_remember'] == 'Y')) {

                // Get a token for the entered password.
                $user_token = user_generate_token($uid);

                // Set a cookie with the logon and the token.
                html_set_cookie('user_logon', $user_logon, time() + YEAR_IN_SECONDS);
                html_set_cookie('user_token', $user_token, time() + YEAR_IN_SECONDS);

            } else {

                // Remove the cookie.
                html_set_cookie('user_logon', '', time() - YEAR_IN_SECONDS);
                html_set_cookie('user_token', '', time() - YEAR_IN_SECONDS);
            }

            // Success
            return true;
        }
    }

    // Failed
    return false;
}

function logon_draw_form($logon_options)
{
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    // Make sure logon form argument is valid.
    if (!is_numeric($logon_options)) $logon_options = LOGON_FORM_DEFAULT;

    // Check for previously failed logon.
    if (isset($_GET['logout_success']) && $_GET['logout_success'] == 'true') {
        html_display_success_msg(gettext("You have successfully logged out."), '500', 'center');
    } else if (isset($_GET['logon_failed']) && !($logon_options & LOGON_FORM_SESSION_EXPIRED)) {
        html_display_error_msg(gettext("The username or password you supplied is not valid."), '500', 'center');
    }

    // Get the original requested page url.
    $request_uri = get_request_uri();

    // If the request is for logon.php then we are performing
    // a normal login, otherwise potentially a failed session.
    if (stristr($request_uri, 'logon.php')) {
        echo "  <form accept-charset=\"utf-8\" name=\"logonform\" method=\"post\" action=\"$request_uri\" target=\"", html_get_top_frame_name(), "\">\n";
        echo "    ", form_csrf_token_field(), "\n";
    } else {
        echo "  <form accept-charset=\"utf-8\" name=\"logonform\" method=\"post\" action=\"$request_uri\" target=\"_self\">\n";
        echo "    ", form_csrf_token_field(), "\n";
    }

    // Check for any post data that we need to include in the form.
    unset($_POST['user_logon'], $_POST['user_password'], $_POST['logon'], $_POST['webtag'], $_POST['register']);

    // Add any post data into the form.
    if (isset($_POST) && is_array($_POST) && sizeof($_POST) > 0) {
        echo form_input_hidden_array($_POST);
    }

    echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
    echo "  <br />\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"325\">\n";
    echo "    <tr>\n";
    echo "      <td align=\"left\">\n";
    echo "        <table class=\"box\" width=\"100%\">\n";
    echo "          <tr>\n";
    echo "            <td align=\"left\" class=\"posthead\">\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\">", gettext("Logon"), "</td>\n";
    echo "                </tr>\n";
    echo "              </table>\n";
    echo "              <table class=\"posthead\" width=\"100%\">\n";
    echo "                <tr>\n";
    echo "                  <td align=\"center\">\n";
    echo "                    <table class=\"posthead\" width=\"95%\">\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"right\" width=\"90\">", gettext("Username"), ":</td>\n";
    echo "                        <td align=\"left\">", form_input_text('user_logon', null, 24, 32, null, 'bhinputlogon'), "</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"right\" width=\"90\">", gettext("Password"), ":</td>\n";
    echo "                        <td align=\"left\">", form_input_password('user_password', null, 24, 32, null, 'bhinputlogon'), "</td>\n";
    echo "                      </tr>\n";

    if (!($logon_options & LOGON_FORM_HIDE_TICKBOX) && !($logon_options & LOGON_FORM_SESSION_EXPIRED)) {

        echo "                      <tr>\n";
        echo "                        <td align=\"left\" colspan=\"2\"><hr class=\"bhseparatorlogon\" /></td>\n";
        echo "                      </tr>\n";
        echo "                    </table>\n";
        echo "                    <table class=\"posthead\" width=\"95%\">\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"right\" width=\"90\">", form_checkbox('user_remember', 'Y', null, (html_get_cookie('user_logon') && html_get_cookie('user_token'))), "</td>\n";
        echo "                        <td align=\"left\"><label for=\"user_remember\">", gettext("Remember me"), "</label></td>\n";
        echo "                      </tr>\n";
        echo "                      <tr>\n";
        echo "                        <td align=\"left\">&nbsp;</td>\n";
        echo "                        <td align=\"left\"><span class=\"bhinputlogon_warning\">", gettext("Not recommended for shared computers"), "</span></td>\n";
        echo "                      </tr>\n";
    }

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
    echo "    <tr>\n";
    echo "      <td align=\"left\">&nbsp;</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td align=\"center\" colspan=\"2\">", form_submit('logon', gettext("Logon")), "</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</form>\n";
    echo "<br />\n";

    if (!($logon_options & LOGON_FORM_HIDE_LINKS)) {

        echo "<hr class=\"bhlogonseparator\" />\n";

        if (user_guest_enabled()) {

            echo "<form accept-charset=\"utf-8\" name=\"guest\" action=\"logon.php?webtag=$webtag\" method=\"post\" target=\"", html_get_top_frame_name(), "\">\n";
            echo "  ", form_csrf_token_field(), "\n";
            echo "  <p>", sprintf(gettext("Enter as a %s"), form_submit('guest_logon', gettext("Guest"))), "</p>\n";
            echo "</form>\n";
        }

        if (isset($_GET['final_uri']) && strlen(trim($_GET['final_uri'])) > 0) {

            $available_files_preg = implode("|^", array_map('preg_quote_callback', get_available_files()));

            if (preg_match("/^$available_files_preg/u", trim($_GET['final_uri'])) > 0) {
                $final_uri = href_cleanup_query_keys($_GET['final_uri']);
            }
        }

        if (isset($final_uri)) {

            $final_uri = rawurlencode($final_uri);

            $register_link = rawurlencode("register.php?webtag=$webtag&final_uri=$final_uri");
            $forgot_pw_link = rawurlencode("forgot_pw.php?webtag=$webtag&final_uri=$final_uri");

            echo "<p>", sprintf(gettext("Don't have an account? %s"), "<a href=\"index.php?webtag=$webtag&amp;final_uri=$register_link\" target=\"" . html_get_top_frame_name() . "\">" . gettext("Register now") . "</a>") . "</p>\n";
            echo "<hr class=\"bhlogonseparator\" />\n";
            echo "<h2>", gettext("Problems logging on?"), "</h2>\n";
            echo "<p><a href=\"logon.php?webtag=$webtag&amp;delete_cookie=yes&amp;final_uri=$final_uri\" target=\"", html_get_top_frame_name(), "\">", gettext("Delete Cookies"), "</a></p>\n";
            echo "<p><a href=\"index.php?webtag=$webtag&amp;final_uri=$forgot_pw_link\" target=\"", html_get_top_frame_name(), "\">", gettext("Forgotten your password?"), "</a></p>\n";

        } else {

            echo "<p>", sprintf(gettext("Don't have an account? %s"), "<a href=\"index.php?webtag=$webtag&amp;final_uri=register.php%3Fwebtag%3D$webtag\" target=\"" . html_get_top_frame_name() . "\">" . gettext("Register now") . "</a>"), "</p>\n";
            echo "<hr class=\"bhlogonseparator\" />\n";
            echo "<h2>", gettext("Problems logging on?"), "</h2>\n";
            echo "<p><a href=\"logon.php?webtag=$webtag&amp;delete_cookie=yes\" target=\"", html_get_top_frame_name(), "\">", gettext("Delete Cookies"), "</a></p>\n";
            echo "<p><a href=\"index.php?webtag=$webtag&amp;final_uri=forgot_pw.php%3Fwebtag%3D$webtag\" target=\"", html_get_top_frame_name(), "\">", gettext("Forgotten your password?"), "</a></p>\n";
        }

        echo "<hr class=\"bhlogonseparator\" />\n";
        echo "<h2>", gettext("Using a mobile device?"), "</h2>\n";
        echo "<p><a href=\"index.php?webtag=$webtag&amp;view=mobile\" target=\"", html_get_top_frame_name(), "\">", gettext("Mobile version"), "</a></p>\n";
    }
}