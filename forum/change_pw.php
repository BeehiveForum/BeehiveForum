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

/* $Id: change_pw.php,v 1.22 2004-03-12 18:46:50 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

//Multiple forum support
include_once("./include/forum.inc.php");

include_once("./include/config.inc.php");
include_once("./include/constants.inc.php");
include_once("./include/db.inc.php");
include_once("./include/form.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/user.inc.php");

if (isset($HTTP_POST_VARS['submit'])) {

    $valid = true;
    $error_html = "";

    if (isset($HTTP_POST_VARS['uid']) && is_numeric($HTTP_POST_VARS['uid'])) {
    
        if (isset($HTTP_POST_VARS['key']) && is_md5($HTTP_POST_VARS['key'])) {
        
            if (isset($HTTP_POST_VARS['pw']) && isset($HTTP_POST_VARS['cpw'])) {

                if (trim($HTTP_POST_VARS['pw']) == trim($HTTP_POST_VARS['cpw'])) {
        
                    if (_htmlentities(trim($HTTP_POST_VARS['pw'])) != trim($HTTP_POST_VARS['pw'])) {
                        $error_html.= "<h2>{$lang['passwdmustnotcontainHTML']}</h2>\n";
                        $valid = false;
                    }
       
                    if (!preg_match("/^[a-z0-9_-]+$/i", trim($HTTP_POST_VARS['pw']))) {
                        $error_html.= "<h2>{$lang['passwordinvalidchars']}</h2>\n";
                        $valid = false;
                    }      
      
                    if (strlen(trim($HTTP_POST_VARS['pw'])) < 6) {
                        $error_html.= "<h2>{$lang['passwdtooshort']}</h2>\n";
                        $valid = false;
                    }
            
                    if ($valid) {

                        if (user_change_pw($HTTP_POST_VARS['uid'], trim($HTTP_POST_VARS['pw']), $HTTP_POST_VARS['key'])) {

                            html_draw_top();
 
                            echo "<h1>{$lang['passwdchanged']}</h1>";
                            echo "<br />\n";
                            echo "<div align=\"center\">\n";
                            echo "<p>{$lang['passedchangedexp']}</p>\n";

                            form_quick_button("./index.php?webtag=$webtag", $lang['continue'], "", "", "_top");

                            echo "</div>\n";

                            html_draw_bottom();
                            exit;

                        }else {
                            $error_html = "<h2>{$lang['updatefailed']}.</h2>";
                            $valid = false;
                        }
                    }

                }else {
                    $error_html = "<h2>{$lang['passwdsdonotmatch']}</h2>";
                    $valid = false;
                }

            }else {
                $error_html = "<h2>{$lang['allfieldsrequired']}</h2>";
                $valid = false;
            }
    
        }else {
            $error_html = "<h2>{$lang['allfieldsrequired']}</h2>";
            $valid = false;
        }            

    }else {
        $error_html = "<h2>{$lang['allfieldsrequired']}</h2>";
        $valid = false;
    }
}

if (isset($HTTP_GET_VARS['u']) && is_numeric($HTTP_GET_VARS['u']) && isset($HTTP_GET_VARS['h']) && is_md5($HTTP_GET_VARS['h'])) {
    $uid = $HTTP_GET_VARS['u'];
    $key = $HTTP_GET_VARS['h'];
}elseif (isset($HTTP_POST_VARS['uid']) && is_numeric($HTTP_GET_VARS['uid']) && isset($HTTP_POST_VARS['key']) && is_md5($HTTP_GET_VARS['key'])) {
    $uid = $HTTP_POST_VARS['uid'];
    $key = $HTTP_POST_VARS['key'];
}else {
    html_draw_top();
    echo "<h1>{$lang['error']}</h1>\n";
    echo "<h2>{$lang['requiredinformationnotfound']}</h2>\n";
    html_draw_bottom();
    exit;
}

if ($user = user_get($uid, $key)) {
    $logon = strtoupper($user['LOGON']);
}else {
    html_draw_top();
    echo "<h1>{$lang['error']}</h1>\n";
    echo "<h2>{$lang['requiredinformationnotfound']}</h2></div>\n";
    html_draw_bottom();
    exit;
}

html_draw_top();

echo "<h1>{$lang['forgotpasswd']}</h1>";

if (isset($error_html)) {
    echo $error_html;
}else {
    echo "<br />\n";
}

echo "<div align=\"center\">\n";
echo "  <p class=\"smalltext\">{$lang['enternewpasswdforuser']} $logon</p>\n";
echo "  <form name=\"forgot_pw\" action=\"change_pw.php?webtag=$webtag\" method=\"POST\">\n";
echo "  ", form_input_hidden("uid", $uid), form_input_hidden("key", $key), "\n";
echo "    <table class=\"box\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\">\n";
echo "      <tr>\n";
echo "        <td>\n";
echo "          <table class=\"subhead\" width=\"100%\">\n";
echo "            <tr>\n";
echo "              <td>{$lang['forgotpasswd']}</td>\n";
echo "            </tr>\n";
echo "          </table>\n";
echo "          <table class=\"posthead\" width=\"100%\">\n";
echo "            <tr>\n";
echo "              <td align=\"right\">{$lang['newpasswd']}:</td>\n";
echo "              <td>", form_input_password("pw", ""), "</td>\n";
echo "            </tr>\n";
echo "            <tr>\n";
echo "              <td align=\"right\">{$lang['confirmpasswd']}:</td>\n";
echo "              <td>", form_input_password("cpw", ""), "</td>\n";
echo "            </tr>\n";
echo "          </table>\n";
echo "          <table class=\"posthead\" width=\"100%\">\n";
echo "            <tr>\n";
echo "              <td align=\"center\">", form_submit(), "</td>\n";
echo "            </tr>\n";
echo "          </table>\n";
echo "        </td>\n";
echo "      </tr>\n";
echo "    </table>\n";
echo "  </form>\n";
echo "</div>\n";

html_draw_bottom();

?>