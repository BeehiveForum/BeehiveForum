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

/* $Id: logon.php,v 1.125 2004-03-22 15:17:46 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum webtag and settings
$webtag = get_webtag();
$forum_settings = get_forum_settings();

include_once("./include/beehive.inc.php");
include_once("./include/config.inc.php");
include_once("./include/constants.inc.php");
include_once("./include/form.inc.php");
include_once("./include/format.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/messages.inc.php");
include_once("./include/session.inc.php");
include_once("./include/user.inc.php");

if (isset($HTTP_GET_VARS['final_uri'])) {

    $final_uri = rawurldecode($HTTP_GET_VARS['final_uri']);

}elseif (isset($HTTP_GET_VARS['msg']) && validate_msg($HTTP_GET_VARS['msg'])) {

    $final_uri = "./discussion.php?webtag={$webtag['WEBTAG']}&msg=". $HTTP_GET_VARS['msg'];

}elseif (isset($HTTP_GET_VARS['folder']) && is_numeric($HTTP_GET_VARS['folder'])) {

    $final_uri = "./discussion.php?webtag={$webtag['WEBTAG']}&folder=". $HTTP_GET_VARS['folder'];

}elseif (isset($HTTP_GET_VARS['pmid']) && is_numeric($HTTP_GET_VARS['pmid'])) {

    $final_uri = "./pm.php?webtag={$webtag['WEBTAG']}&mid=". $HTTP_GET_VARS['pmid'];
}

if (isset($final_uri) && strstr($final_uri, 'logout.php')) {
    unset($final_uri);
}

if ($user_sess = bh_session_check() && bh_session_get_value('UID') != 0) {

    html_draw_top();
    echo "<div align=\"center\">\n";
    echo "<p>{$lang['user']} ", bh_session_get_value('LOGON'), " {$lang['alreadyloggedin']}.</p>\n";

    if (isset($final_uri)) {
        form_quick_button("./index.php", $lang['continue'], "final_uri", rawurlencode($final_uri), "_top");
    }else {
        form_quick_button("./index.php", $lang['continue'], false, false, "_top");
    }

    echo "</div>\n";
    html_draw_bottom();
    exit;

}

// Retrieve existing cookie data if any

// Username array

if (isset($HTTP_COOKIE_VARS['bh_remember_username']) && is_array($HTTP_COOKIE_VARS['bh_remember_username'])) {
    $username_array = $HTTP_COOKIE_VARS['bh_remember_username'];
}else {
    $username_array = array();
}

// Password array

if (isset($HTTP_COOKIE_VARS['bh_remember_password']) && is_array($HTTP_COOKIE_VARS['bh_remember_password'])) {
    $password_array = $HTTP_COOKIE_VARS['bh_remember_password'];
}else {
    $password_array = array();
}

// Passhash array

if (isset($HTTP_COOKIE_VARS['bh_remember_passhash']) && is_array($HTTP_COOKIE_VARS['bh_remember_passhash'])) {
    $passhash_array = $HTTP_COOKIE_VARS['bh_remember_passhash'];
}else {
    $passhash_array = array();
}

// Delete the user's cookie as requested and send them back to the login form.

if (isset($HTTP_GET_VARS['deletecookie']) && $HTTP_GET_VARS['deletecookie'] == 'yes') {

    for ($i = 0; $i < sizeof($username_array); $i++) {

        bh_setcookie("bh_remember_username[$i]", '', time() - YEAR_IN_SECONDS);
        bh_setcookie("bh_remember_password[$i]", '', time() - YEAR_IN_SECONDS);
        bh_setcookie("bh_remember_passhash[$i]", '', time() - YEAR_IN_SECONDS);
    }

    bh_session_end();

    if (isset($HTTP_SERVER_VARS['SERVER_SOFTWARE']) && !strstr($HTTP_SERVER_VARS['SERVER_SOFTWARE'], 'Microsoft-IIS')) {

        if (isset($final_uri)) {
            $final_uri = rawurlencode($final_uri);
            header_redirect("./index.php?webtag={$webtag['WEBTAG']}&final_uri=$final_uri");
        }else {
            header_redirect("./index.php?webtag={$webtag['WEBTAG']}");
        }

    }else {

        html_draw_top();

        // Try a Javascript redirect
        echo "<script language=\"javascript\" type=\"text/javascript\">\n";
        echo "<!--\n";
        
        if (isset($final_uri)) {
            $final_uri = rawurlencode($final_uri);
            echo "document.location.href = './index.php?webtag={$webtag['WEBTAG']}&final_uri=$final_uri';\n";
        }else {
            echo "document.location.href = './index.php?webtag={$webtag['WEBTAG']}';\n";
        }
        
        echo "//-->\n";
        echo "</script>";

        // If they're still here, Javascript's not working. Give up, give a link.
        echo "<div align=\"center\"><p>&nbsp;</p><p>&nbsp;</p>";
        echo "<p>{$lang['loggedinsuccessfully']}</p>";

        if (isset($final_uri)) {
            form_quick_button("./index.php", $lang['continue'], "final_uri", rawurlencode($final_uri), "_top");
        }else {
            form_quick_button("./index.php", $lang['continue'], false, false, "_top");
        }

        html_draw_bottom();
        exit;
    }
}

if (isset($HTTP_POST_VARS['submit'])) {

    if (isset($HTTP_POST_VARS['logon']) && isset($HTTP_POST_VARS['password'])) {
        
        if (preg_match("/^ +$/", _stripslashes($HTTP_POST_VARS['password']))) {
        
            if (isset($HTTP_POST_VARS['passhash']) && is_md5(_stripslashes($HTTP_POST_VARS['passhash']))) {
                
                $logon = _stripslashes($HTTP_POST_VARS['logon']);
                $passw = _stripslashes($HTTP_POST_VARS['password']);
                $passh = _stripslashes($HTTP_POST_VARS['passhash']);

                $luid = user_logon(strtoupper($HTTP_POST_VARS['logon']), $HTTP_POST_VARS['passhash'], true);
            }

        }else {
         
            $logon = _stripslashes($HTTP_POST_VARS['logon']);
            $passw = str_repeat(chr(32), strlen(_stripslashes($HTTP_POST_VARS['password'])));
            $passh = md5(_stripslashes($HTTP_POST_VARS['password']));
  
            $luid = user_logon(strtoupper($HTTP_POST_VARS['logon']), $HTTP_POST_VARS['password'], false);
        }

        if (isset($luid) && $luid > -1) {

            bh_setcookie('bh_thread_mode', '', time() - YEAR_IN_SECONDS);

            if ((strtoupper($HTTP_POST_VARS['logon']) == 'GUEST') && (strtoupper($HTTP_POST_VARS['password']) == 'GUEST')) {

                if (user_guest_enabled()) {

                    bh_session_init(0); // Use UID 0 for guest account.
                }

            }else {

                bh_session_init($luid);
        
                if (($key = _array_search($logon, $username_array)) !== false) {

                    unset($username_array[$key]);
                    unset($password_array[$key]);
                    unset($passhash_array[$key]);
                }

                array_unshift($username_array, $logon);
        
                if (isset($HTTP_POST_VARS['remember_user']) && ($HTTP_POST_VARS['remember_user'] == 'Y')) {
        
                    array_unshift($password_array, $passw);
                    array_unshift($passhash_array, $passh);

                }else {
        
                    array_unshift($password_array, "");
                    array_unshift($passhash_array, "");
                }

                // set / update the username and password cookies
        
                for ($i = 0; $i < sizeof($username_array); $i++) {

                    bh_setcookie("bh_remember_username[$i]", $username_array[$i], time() + YEAR_IN_SECONDS);
                        
                    if (isset($password_array[$i]) && isset($passhash_array[$i]) {
                        
                        bh_setcookie("bh_remember_password[$i]", $password_array[$i], time() + YEAR_IN_SECONDS);
                        bh_setcookie("bh_remember_passhash[$i]", $passhash_array[$i], time() + YEAR_IN_SECONDS);

                    }else {
                        
                        bh_setcookie("bh_remember_password[$i]", "", time() + YEAR_IN_SECONDS);
                        bh_setcookie("bh_remember_passhash[$i]", "", time() + YEAR_IN_SECONDS);
                    }
                }

                // set / update the cookie that remembers if the user
                // has any logon form data.

                bh_setcookie("bh_logon", "1", time() + YEAR_IN_SECONDS);
            }

            // IIS bug prevents redirect at same time as setting cookies.

            if (isset($HTTP_SERVER_VARS['SERVER_SOFTWARE']) && !strstr($HTTP_SERVER_VARS['SERVER_SOFTWARE'], 'Microsoft-IIS')) {

                if (isset($final_uri)) {
                    $final_uri = rawurlencode($final_uri);
                    header_redirect("./index.php?webtag={$webtag['WEBTAG']}&final_uri=$final_uri");
                }else {
                    header_redirect("./index.php?webtag={$webtag['WEBTAG']}");
                }

            }else {

                html_draw_top();

                // Try a Javascript redirect
                echo "<script language=\"javascript\" type=\"text/javascript\">\n";
                echo "<!--\n";

                if (isset($final_uri)) {
                    $final_uri = rawurlencode($final_uri);
                    echo "document.location.href = './index.php?webtag={$webtag['WEBTAG']}&final_uri=$final_uri';\n";
                }else {
                    echo "document.location.href = './index.php?webtag={$webtag['WEBTAG']}';\n";
                }
                
                echo "//-->\n";
                echo "</script>";

                // If they're still here, Javascript's not working. Give up, give a link.
                echo "<div align=\"center\">\n";
                echo "<p>{$lang['loggedinsuccessfully']}</p>\n";

                if (isset($final_uri)) {
                    form_quick_button("./index.php", $lang['continue'], "final_uri", rawurlencode($final_uri), "_top");
                }else {
                    form_quick_button("./index.php", $lang['continue'], false, false, "_top");
                }

                echo "</div>\n";
                html_draw_bottom();
                exit;
            }

        }else if (isset($luid) && $luid == -2) { // User is banned - everybody hide

            if (!strstr(php_sapi_name(), 'cgi')) {
                header("HTTP/1.0 500 Internal Server Error");
            }else {
                echo "<h1>HTTP/1.0 500 Internal Server Error</h1>\n";
            }
            exit;

        }else {

            bh_setcookie("bh_logon", '1', time() + YEAR_IN_SECONDS);

            html_draw_top();
            echo "<div align=\"center\">\n";
            echo "<h2>{$lang['usernameorpasswdnotvalid']}</h2>\n";
            echo "<h2>{$lang['pleasereenterpasswd']}</h2>\n";

            if (isset($final_uri)) {
                form_quick_button("./index.php", $lang['back'], "final_uri", rawurlencode($final_uri), "_top");
            }else {
                form_quick_button("./index.php", $lang['back'], false, false, "_top");
            }
            
            echo "<hr width=\"350\" />\n";
            echo "<h2>{$lang['problemsloggingon']}</h2>\n";
            
            if (isset($final_uri)) {
                $final_uri = rawurlencode($final_uri);
                echo "<p class=\"smalltext\"><a href=\"logon.php?webtag={$webtag['WEBTAG']}&deletecookie=yes&final_uri=$final_uri\" target=\"_top\">{$lang['deletecookies']}</a></p>\n";
                echo "<p class=\"smalltext\"><a href=\"forgot_pw.php?webtag={$webtag['WEBTAG']}&deletecookie=yes&final_uri=$final_uri\" target=\"_top\">{$lang['deletecookies']}</a></p>\n";
            }else {
                echo "<p class=\"smalltext\"><a href=\"logon.php?webtag={$webtag['WEBTAG']}&deletecookie=yes\" target=\"_top\">{$lang['deletecookies']}</a></p>\n";
                echo "<p class=\"smalltext\"><a href=\"forgot_pw.php?webtag={$webtag['WEBTAG']}&deletecookie=yes\" target=\"_top\">{$lang['deletecookies']}</a></p>\n";
            }

            html_draw_bottom();
            exit;
        }

    }else {

        $error_html = "<h2>{$lang['usernameandpasswdrequired']}</h2>";
    }
}

html_draw_top();

echo "<script language=\"javascript\" type=\"text/javascript\">\n";
echo "<!--\n\n";
echo "function changepassword() {\n\n";
echo "    var i = document.logonform.logonarray.selectedIndex;\n";
echo "    var password = eval(\"document.logonform.password\"+ i +\".value\");\n";
echo "    var passhash = eval(\"document.logonform.passhash\"+ i +\".value\");\n";
echo "    document.logonform.logon.value = document.logonform.logonarray.options[i].value;\n";
echo "    if (/^[A-Fa-f0-9]{32}$/.test(passhash) == true) {\n";
echo "        document.logonform.password.value = password;\n";
echo "        document.logonform.passhash.value = passhash;\n";
echo "        document.logonform.remember_user.checked = true;\n";
echo "    }else {\n";
echo "        document.logonform.password.value = '';\n";
echo "        document.logonform.passhash.value = '';\n";
echo "        document.logonform.remember_user.checked = false;\n";
echo "    }\n";
echo "}\n\n";
echo "var has_clicked = false;\n\n";
echo "//-->\n";
echo "</script>\n";

if (isset($error_html)) echo $error_html;

if (isset($HTTP_GET_VARS['other'])) {
    $otherlogon = true;
}else {
    $otherlogon = false;
}

echo "<p>&nbsp;</p>\n";
echo "<div align=\"center\">\n";
echo "  <form name=\"logonform\" action=\"". get_request_uri(). "\" method=\"post\" target=\"_top\" onsubmit=\"return has_clicked;\">\n";
echo "    <table class=\"box\" cellpadding=\"0\" cellspacing=\"0\">\n";
echo "      <tr>\n";
echo "        <td>\n";
echo "          <table class=\"subhead\" width=\"100%\">\n";
echo "            <tr>\n";
echo "              <td class=\"subhead\" align=\"left\">Logon</td>\n";
echo "            </tr>\n";
echo "          </table>\n";
echo "          <table class=\"posthead\" width=\"100%\">\n";

if ((sizeof($username_array) > 1) && $otherlogon == false) {

    echo "          <tr>\n";
    echo "            <td align=\"right\">{$lang['username']}:</td>\n";
    echo "            <td>";

    foreach ($username_array as $key => $value) {
        $usernames[$key] = _stripslashes($value);
    }

    echo form_dropdown_array('logonarray', $usernames, $usernames, "", "onchange='changepassword()' style=\"width: 135px\"");
    echo form_input_hidden('logon', _stripslashes($username_array[0]));

    for ($i = 0; $i < sizeof($username_array); $i++) {
    
        if (isset($password_array[$i]) && strlen($password_array[$i]) > 0) {
    
            if (isset($passhash_array[$i]) && is_md5($passhash_array[$i])) {
    
                echo form_input_hidden("password$i", $password_array[$i]);
                echo form_input_hidden("passhash$i", $passhash_array[$i]);

            }else {
      
                echo form_input_hidden("password$i", "");
                echo form_input_hidden("passhash$i", "");
            }

        }else {
    
            echo form_input_hidden("password$i", "");
            echo form_input_hidden("passhash$i", "");
        }
    }

    $request_uri = get_request_uri();

    if (strstr($request_uri, '?')) {
        $request_uri.= "&other=true";
    }else {
        $request_uri.= "?other=true";
    }

    echo "&nbsp;", form_button("other", "Other", "onclick=\"self.location.href='$request_uri';\""), "</td>\n";

    echo "          </tr>\n";
    echo "          <tr>\n";
    echo "            <td align=\"right\">{$lang['passwd']}:</td>\n";
    
    if (isset($password_array[0]) && strlen($password_array[0]) > 0) {
        if (isset($passhash_array[0]) && is_md5($passhash_array[0])) {
            echo "            <td>", form_input_password("password", $password_array[0]), form_input_hidden("passhash", $passhash_array[0]), "</td>\n";
        }else {
            echo "            <td>", form_input_password("password", ""), form_input_hidden("passhash", ""), "</td>\n";
        }
    }else {
        echo "            <td>", form_input_password("password", ""), form_input_hidden("passhash", ""), "</td>\n";    
    }
    
    echo "          </tr>\n";

}else {

    if ($otherlogon) {
    
        echo "          <tr>\n";
        echo "            <td align=\"right\">{$lang['username']}:</td>\n";
        echo "            <td>", form_input_text('logon', ""), "</td>\n";
        echo "          </tr>\n";
        echo "          <tr>\n";
        echo "            <td align=\"right\">{$lang['passwd']}:</td>\n";
        echo "            <td>", form_input_password('password', ""), "</td>\n";
        echo "          </tr>\n";
        echo "          </tr>\n";
        
    }else {

        echo "          <tr>\n";
        echo "            <td align=\"right\">{$lang['username']}:</td>\n";
        echo "            <td>", form_input_text('logon', (isset($username_array[0]) ? $username_array[0] : "")), "</td>\n";
        echo "          </tr>\n";
        echo "          <tr>\n";
        echo "            <td align=\"right\">{$lang['passwd']}:</td>\n";
        echo "            <td>", form_input_password('password', (isset($password_array[0]) ? $password_array[0] : "")), form_input_hidden('passhash', (isset($passhash_array[0]) ? $passhash_array[0] : "")), "</td>\n";
        echo "          </tr>\n";
        echo "          </tr>\n";
    }
}

echo "            <tr>\n";
echo "              <td>&nbsp;</td>\n";
echo "              <td>";

echo form_checkbox("remember_user", "Y", $lang['rememberpasswds'], (isset($password_array[0]) && isset($passhash_array[0]) && $otherlogon == false));

echo "</td>\n";
echo "            </tr>\n";
echo "          </table>\n";
echo "          <table class=\"posthead\" width=\"100%\">\n";
echo "            <tr>\n";
echo "              <td align=\"center\">", form_submit('submit', $lang['logon'], 'onclick="has_clicked = true"'), "</td>\n";
echo "            </tr>\n";
echo "          </table>\n";
echo "        </td>\n";
echo "      </tr>\n";
echo "    </table>\n";
echo "  </form>\n";

if (user_guest_enabled()) {

    echo "  <form name=\"guest\" action=\"", get_request_uri(), "\" method=\"POST\" target=\"_top\">\n";
    echo "    <p class=\"smalltext\">{$lang['enterasa']} ". form_input_hidden("logon", "guest"). form_input_hidden("password", "guest"). form_submit("submit", $lang['guest']). "</p>\n";
    echo "  </form>\n";
}

if (isset($final_uri)) {

    $final_uri = rawurlencode($final_uri);
    
    echo "  <p class=\"smalltext\">{$lang['donthaveanaccount']} <a href=\"register.php?webtag={$webtag['WEBTAG']}&final_uri=$final_uri\" target=\"_self\">Register now.</a></p>\n";
    echo "  <hr width=\"350\" />\n";
    echo "  <h2>{$lang['problemsloggingon']}</h2>\n";
    echo "  <p class=\"smalltext\"><a href=\"logon.php?webtag={$webtag['WEBTAG']}&deletecookie=yes&final_uri=$final_uri\" target=\"_top\">{$lang['deletecookies']}</a></p>\n";
    echo "  <p class=\"smalltext\"><a href=\"forgot_pw.php?webtag={$webtag['WEBTAG']}&final_uri=$final_uri\" target=\"_self\">{$lang['forgottenpasswd']}</a></p>\n";
    
}else {

    echo "  <p class=\"smalltext\">{$lang['donthaveanaccount']} <a href=\"register.php?webtag={$webtag['WEBTAG']}\" target=\"_self\">Register now.</a></p>\n";
    echo "  <hr width=\"350\" />\n";
    echo "  <h2>{$lang['problemsloggingon']}</h2>\n";
    echo "  <p class=\"smalltext\"><a href=\"logon.php?webtag={$webtag['WEBTAG']}&deletecookie=yes\" target=\"_top\">{$lang['deletecookies']}</a></p>\n";
    echo "  <p class=\"smalltext\"><a href=\"forgot_pw.php?webtag={$webtag['WEBTAG']}\" target=\"_self\">{$lang['forgottenpasswd']}</a></p>\n";
}
    
echo "  <hr width=\"350\" />\n";
echo "  <h2>{$lang['usingaPDA']}</h2>\n";
echo "  <p class=\"smalltext\"><a href=\"llogon.php?webtag={$webtag['WEBTAG']}\" target=\"_top\">{$lang['lightHTMLversion']}</a></p>\n";
echo "</div>\n";

echo "Debug for Quig (STOP BREAKING THE COOKIES :@):";
echo "<pre>\n";
print_r($username_array);
print_r($password_array);
print_r($passhash_array);
echo "</pre>\n";

html_draw_bottom();

?>