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

// Concept and Original code: Andrew Holgate
// Beehive-fitter-iner and dogs body: Matt Beale

// Enable the error handler
require_once("./include/errorhandler.inc.php");

// Compress the output
require_once("./include/gzipenc.inc.php");

require_once("./include/make_style.inc.php");
require_once("./include/html.inc.php");
require_once("./include/form.inc.php");
require_once("./include/constants.inc.php");
require_once("./include/db.inc.php");
require_once("./include/forum.inc.php");
require_once("./include/admin.inc.php");

// Start Here

html_draw_top();

echo "<h1>Create a Forum Style</h1>\n";

// Save the style

if (isset($HTTP_POST_VARS['submit'])) {

    if(isset($HTTP_COOKIE_VARS['bh_sess_ustatus']) && ($HTTP_COOKIE_VARS['bh_sess_ustatus'] & USER_PERM_SOLDIER)) {

        if (isset($HTTP_POST_VARS['stylename']) && strlen($HTTP_POST_VARS['stylename']) > 0) {

            $stylename = $HTTP_POST_VARS['stylename'];
            $stylename = strtolower(str_replace(" ", "_", $stylename));
            $stylename = preg_replace("/[^a-z|0-9|'_']/", "", $stylename);

            clearstatcache();

            if (!@file_exists("./styles/$stylename/style.css")) {

                if (@mkdir("./styles/$stylename", 0755)) {

                    chmod("./styles/$stylename", 0777);

                    $fp = fopen("./styles/$stylename/desc.txt", "w");
                    fwrite($fp, (isset($HTTP_POST_VARS['styledesc']) && strlen($HTTP_POST_VARS['styledesc']) > 0) ? $HTTP_POST_VARS['styledesc'] : $stylename);
                    fclose($fp);

                    $stylesheet = implode('', file("./styles/make_style.css"));

                    $fp = fopen("./styles/$stylename/style.css", "w");

                    foreach ($HTTP_POST_VARS['elements'] as $key => $value) {
                        $stylesheet = str_replace("\$elements[$key]", strtoupper($value), $stylesheet);
                        $stylesheet = str_replace("\$text_colour[$key]", strtoupper(contrastFont($value)), $stylesheet);
                    }

                    fwrite($fp, $stylesheet);
                    fclose($fp);

                    admin_addlog(0, 0, 0, 0, 0, 0, 17);

                    echo "<h2>New style \"$stylename\" successfully created.</h2>\n";

                }else {

                    echo "<h2>The styles directory is not writeable. Please CHMOD the styles directory and retry.</h2>\n";

                }

            }else {

                echo "<h2>A style with that filename already exists.</h2>\n";

            }

        }else {

            echo "<h2>You did not enter a filename to save the style with.</h2>\n";

        }

    }else {

        echo "<h2>You are not authorised to create forum styles.</h2>\n";

    }

}

// Check to see if any of the required variables were passed via the URL Query or POST_VARS
// Otherwise create some random numbers to work with.

if (isset($HTTP_GET_VARS['seed'])) {
    $seed = substr(preg_replace("/[^0-9|A-F]/i", "", $HTTP_GET_VARS['seed']), 0, 6);
    list ($red, $green, $blue) = hexToDec($seed);
}else {
    $red = rand(0, 255);
    $green = rand(0, 255);
    $blue = rand(0, 255);
}

if (isset($HTTP_GET_VARS['mode'])) {
    $mode = $HTTP_GET_VARS['mode'];
}else {
    $mode = "";
}

//Maximum variance for the colours

$max_var = 15;

// An array of all the Beehive CSS elements.

$elements = array ('navpage' => '', 'threads' => '', 'button' => '', 'subhead' => '', 'h1' => '', 'body' => '', 'box' => '');

if ($mode != "") {
    uasort($elements, randSort());
}

$colour = decToHex($red, $green, $blue);
$seed = $colour;

list ($r, $g, $b) = hexToDec($colour);

$steps = sizeof($elements);


echo "<p>Use this page to help create a randomly generated style for your forum.</p>\n";
echo "<div align=\"center\">\n";
echo "  <table width=\"70%\" class=\"box\">\n";
echo "    <tr>\n";
echo "      <td class=\"posthead\">\n";
echo "        <table width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td colspan=\"2\" class=\"subhead\" align=\"left\">Controls</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td colspan=\"2\" class=\"posthead\">\n";
echo "              <table width=\"100%\">\n";
echo "                <tr>\n";

if (isset($HTTP_POST_VARS['submit'])) {

    $elements = $HTTP_POST_VARS['elements'];

    foreach ($HTTP_POST_VARS['elements'] as $key => $value) {

        echo "                  <td width=\"50\" class=\"posthead\" style=\"background-color: #", $value, "\" align=\"center\">\n";
        echo "                    <a href=\"", $HTTP_SERVER_VARS['PHP_SELF'], "?seed=", $value, "&amp;mode=", $mode, "\" style=\"color: #", contrastFont($value), "\">", strtoupper($value), "</a>\n";
        echo "                  </td>\n";

    }


}else {

    foreach ($elements as $key => $value) {

        echo "                  <td width=\"50\" class=\"posthead\" style=\"background-color: #", $colour, "; color: #", contrastFont($colour), "\" align=\"center\">\n";
        echo "                    <a href=\"", $HTTP_SERVER_VARS['PHP_SELF'], "?seed=", $colour, "&amp;mode=", $mode, "\" style=\"color: #", contrastFont($colour), "\">", strtoupper($colour), "</a>\n";
        echo "                  </td>\n";

        $elements[$key] = $colour;
        list ($r, $g, $b) = hexToDec($colour);
        $colour = changeColour ($r, $g, $b, $max_var, $mode, $steps);
        $steps--;

    }

    reset($elements);

}

echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"", sizeof($elements), "\" class=\"posthead\" align=\"left\">\n";
echo "                    Click on a colour to make a new stylesheet based on that colour. Current base colour is first in list.\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "        <table width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\" width=\"250\">\n";
echo "              <table width=\"100%\" cellspacing=\"5\">\n";
echo "                <tr>\n";

list ($boxr, $boxg, $boxb) = hexToDec($elements['box']);

if (($boxr < 150 and $boxg < 150 and $boxb < 150) or (($boxr + $boxg + $boxb) / 3) < 85) {
    $text_colour = "#ffffff";
} else {
    $text_colour = "#000000";
}

$r = rand(0, 1000);

echo "                  <td class=\"subhead\" align=\"left\">New</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td class=\"posthead\" align=\"left\">\n";
echo "                    <a href=\"", $HTTP_SERVER_VARS['PHP_SELF'], "?r=$r\">Standard Style</a><br />\n";
echo "                    <a href=\"", $HTTP_SERVER_VARS['PHP_SELF'], "?mode=med&amp;r=$r\">Rotated Element Style</a><br />\n";
echo "                    <a href=\"", $HTTP_SERVER_VARS['PHP_SELF'], "?mode=rand&amp;r=$r\">Random Style</a>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td class=\"posthead\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" align=\"left\">This Colour</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td class=\"posthead\" align=\"left\">\n";
echo "                    <a href=\"", $HTTP_SERVER_VARS['PHP_SELF'], "?seed=$seed&amp;r=$r\">Standard Style</a><br />\n";
echo "                    <a href=\"", $HTTP_SERVER_VARS['PHP_SELF'], "?seed=$seed&amp;mode=medi&amp;r=$r\">Rotated Element Style</a><br />\n";
echo "                    <a href=\"", $HTTP_SERVER_VARS['PHP_SELF'], "?seed=$seed&amp;mode=rand&amp;r=$r\">Random Style</a>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td class=\"posthead\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td class=\"posthead\" align=\"left\">or enter a hex colour to base a new stylesheet on</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td class=\"posthead\" align=\"left\">\n";
echo "                    <form action=\"", $HTTP_SERVER_VARS['PHP_SELF'], "\" method=\"get\">\n";
echo "                      ", form_input_text("seed", strtoupper($seed), 15, 6), "&nbsp;", form_submit('submit', 'Go'), "\n";
echo "                    </form>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "            <td valign=\"top\" class=\"posthead\" align=\"left\">\n";
echo "              <table width=\"100%\" cellspacing=\"5\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\">Save this style</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td class=\"posthead\">\n";
echo "                    <form action=\"", $HTTP_SERVER_VARS['PHP_SELF'], "\" method=\"post\">\n";

foreach ($elements as $key => $value) {
    echo "                      ", form_input_hidden("elements[$key]", $value), "\n";
}

reset($elements);

echo "                      <table width=\"100%\" cellspacing=\"5\">\n";
echo "                        <tr>\n";
echo "                          <td class=\"posthead\">Filename:</td>\n";
echo "                          <td>", form_input_text("stylename", isset($HTTP_POST_VARS['stylename']) ? $HTTP_POST_VARS['stylename'] : '', 35, 10), "</td>\n";
echo "                        </tr>\n";
echo "                        <tr>\n";
echo "                          <td class=\"posthead\">Style Desc.:</td>\n";
echo "                          <td>", form_input_text("styledesc", isset($HTTP_POST_VARS['styledesc']) ? $HTTP_POST_VARS['styledesc'] : '', 35, 20), "&nbsp;", form_submit('submit', 'Save'), "</td>\n";
echo "                        </tr>\n";
echo "                      </table>\n";
echo "                    </form>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td class=\"posthead\">(lowercase letters (a-z), numbers (0-9) and underscores (_) only)</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</div>\n";

/*
?>
<pre>
    if ($sat > 0.8 && $rgb[2] == $b) {
      $text_colour = "FFFFFF";
    }elseif ($sat > 0.8) {
      if ($lum < 0.4) {
        $text_colour = "FFFFFF";
      }else {
        $text_colour = "000000";
      }
    }else {
      if ($lum < 0.6) {
        $text_colour = "FFFFFF";
      }else {
        $text_colour = "000000";
      }
    }
</pre>
<?php

foreach($elements as $key => $value) {
    echo "<p>", contrastFont($value, true), "</p>\n";
}

reset($elements);

*/

?>
<p>Style Preview:</p>
<table width="96%" cellpadding="0" cellspacing="0" align="center" class="box">
  <tr>
    <td>
      <table border="0" cellpadding="0" cellspacing="0" width="100%" align="center" style="background-color: #<?php echo $elements['body']; ?>; color: #<?php echo contrastFont($elements['body']); ?>">
        <tr>
          <td colspan="3" height="20" style="background-color: #<?php echo $elements['navpage']; ?>; color: #<?php echo contrastFont($elements['navpage']); ?>; font-size: 10px; font-weight: bold; text-decoration: none">&nbsp;&nbsp;
            <a href="#" style="color: #<?php echo contrastFont($elements['navpage']); ?>">Start</a>&nbsp;|&nbsp;
            <a href="#" style="color: #<?php echo contrastFont($elements['navpage']); ?>">Messages</a>&nbsp;|&nbsp;
            <a href="#" style="color: #<?php echo contrastFont($elements['navpage']); ?>">Links</a>&nbsp;|&nbsp;
            <a href="#" style="color: #<?php echo contrastFont($elements['navpage']); ?>">Preferences</a>&nbsp;|&nbsp;
            <a href="#" style="color: #<?php echo contrastFont($elements['navpage']); ?>">Profile</a>&nbsp;|&nbsp;
            <a href="#" style="color: #<?php echo contrastFont($elements['navpage']); ?>">Admin</a>&nbsp;|&nbsp;
            <a href="#" style="color: #<?php echo contrastFont($elements['navpage']); ?>">Logout</a>
          </td>
        </tr>
        <tr>
          <td width="240" valign="top" align="center">
            <table width="220" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td class="postbody" style="color: #<?php echo contrastFont($elements['body']); ?>" colspan="2" align="left">
                  <img src="./images/post.png" height="15" alt="New Discussion" />&nbsp;<a href="#" style="color: #<?php echo contrastFont($elements['body']); ?>">New Discussion</a><br />
                  <img src="./images/poll.png" height="15" alt="Create Poll" />&nbsp;<a href="#" style="color: #<?php echo contrastFont($elements['body']); ?>">Create Poll</a><br />
                  <img src="./images/search.png" height="15" alt="Search" />&nbsp;<a href="#" style="color: #<?php echo contrastFont($elements['body']); ?>">Search</a><br />
                </td>
              </tr>
              <tr>
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="2" align="left">
                  <form name="f_mode" method="get" action="">
                    <select name="mode" class="bhselect">
                      <option value="0" selected="selected">All Discussions</option>
                      <option value="1">Unread Discussions</option>
                      <option value="2">Unread &quot;To: Me&quot;</option>
                      <option value="3">Today's Discussions</option>
                      <option value="4">2 Days Back</option>
                      <option value="5">7 Days Back</option>
                      <option value="6">High Interest</option>
                      <option value="7">Unread High Interest</option>
                      <option value="8">I've recently seen</option>
                      <option value="9">I've ignored</option>
                      <option value="10">I've subscribed to</option>
                      <option value="11">Started by Friend</option>
                      <option value="12">Unread std by Friend</option>
                    </select>
                    <input type="submit" name="go" value="Go!" class="button" style="background-color: #<?php echo $elements['button']; ?>; color: #<?php echo contrastFont($elements['button']); ?>" onclick="return false" />
                  </form>
                </td>
              </tr>
              <tr>
                <td colspan="2" align="left">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="foldername"><img src="./images/folder.png" height="15" alt="Folder" /><a href="#" style="color: #<?php echo contrastFont($elements['body']); ?>">General</a></td>
                      <td class="folderpostnew" width="15"><a href="#"><img src="images/folder_hide.png" border="0" height="15" alt="Folder Interest" /></a></td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <td colspan="2" align="left">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="threads" style="background-color: #<?php echo $elements['threads']; ?>; color: #<?php echo contrastFont($elements['threads']); ?>; border-color: #<?php echo contrastFont($elements['box']); ?>; border-bottom-width: 0px; border-right-width: 0px" align="left" valign="top" width="50%" nowrap="nowrap">
                        <a href="#" class="folderinfo" style="color: #<?php echo contrastFont($elements['threads']); ?>">1 threads</a>
                      </td>
                      <td class="threads" style="background-color: #<?php echo $elements['threads']; ?>; color: #<?php echo contrastFont($elements['threads']); ?>; border-color: #<?php echo contrastFont($elements['box']); ?>; border-bottom-width: 0px; border-left-width: 0px" align="right" valign="top" width="50%" nowrap="nowrap">
                        <a href="#" class="folderpostnew" style="color: #<?php echo contrastFont($elements['threads']); ?>">Post New</a>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <td class="threads" style="background-color: #<?php echo $elements['threads']; ?>; color: #<?php echo contrastFont($elements['threads']); ?>; border-color: #<?php echo contrastFont($elements['box']); ?>; border-top-width: 0px" colspan="2">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td valign="top" align="center" nowrap="nowrap" width="16">
                        <img src="./images/current_thread.png" align="middle" height="15" alt="Current Thread" />&nbsp;
                      </td>
                      <td valign="top"><a href="#" class="threadname" style="color: #<?php echo contrastFont($elements['threads']); ?>">Welcome</a>&nbsp;<img src="./images/high_interest.png" height="15" alt="High Interest" />&nbsp;<span class="threadxnewofy" style="color: #<?php echo contrastFont($elements['threads']); ?>">[2]</span></td>
                      <td valign="top" nowrap="nowrap" align="right"><span class="threadtime" style="color: #<?php echo contrastFont($elements['threads']); ?>">16 Mar&nbsp;</span></td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table>
            <table width="220" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="smalltext" style="color: #<?php echo contrastFont($elements['body']); ?>" colspan="2" align="left">Mark as Read:</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td class="smalltext" style="color: #<?php echo contrastFont($elements['body']); ?>" align="left">
                  <form name="f_mark" method="get" action="">
                    <input type="hidden" name="tids" class="bhinputtext" value="1" />
                    <select name="markread" class="bhselect">
                      <option value="0" selected="selected">All Discussions</option>
                      <option value="1">Next 50 discussions</option>
                      <option value="2">Visible discussions</option>
                    </select>
                    <input type="submit" name="go" value="Go!" class="button" style="background-color: #<?php echo $elements['button']; ?>; color: #<?php echo contrastFont($elements['button']); ?>" onclick="return false" />
                  </form>
                </td>
              </tr>
            </table>
            <table width="220" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="smalltext" style="color: #<?php echo contrastFont($elements['body']); ?>" colspan="2" align="left">Navigate:</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td class="smalltext" style="color: #<?php echo contrastFont($elements['body']); ?>" align="left">
                  <form name="f_nav" method="get" action="">
                    <input type="text" name="msg" class="bhinputtext" value="1.1" size="10" />
                    <input type="submit" name="go" value="Go!" class="button" style="background-color: #<?php echo $elements['button']; ?>; color: #<?php echo contrastFont($elements['button']); ?>" onclick="return false" />
                  </form>
                </td>
              </tr>
            </table>
          </td>
          <td bgcolor="#FFFFFF" width="2"></td>
          <td valign="top">
            <div align="center">
              <table width="96%" border="0">
                <tr>
                  <td style="color: #<?php echo contrastFont($elements['body']); ?>"><p style="color: #<?php echo contrastFont($elements['body']); ?>" align="left"><img src="./images/folder.png" alt="Folder" />&nbsp;General: Welcome&nbsp;<img src="./images/high_interest.png" height="15" alt="High Interest" /></p></td>
                </tr>
              </table>
            </div>
            <br />
            <div align="center">
              <table width="96%" class="box" style="background-color: #<?php echo $elements['box']; ?>; color: #<?php echo contrastFont($elements['box']) ?>; border-style: solid; border-width: 1px; border-color: #<?php echo contrastFont($elements['box']);?>" cellspacing="0" cellpadding="0">
                <tr>
                  <td>
                    <table width="100%" class="posthead" style="background-color: #<?php echo $elements['threads']; ?>; color: #<?php echo contrastFont($elements['threads']); ?>" cellspacing="1" cellpadding="0">
                      <tr>
                        <td width="1%" align="right" nowrap="nowrap"><span class="posttofromlabel" style="color: #<?php echo contrastFont($elements['threads']); ?>">&nbsp;From:&nbsp;</span></td>
                        <td nowrap="nowrap" width="98%" align="left"><span class="posttofrom"><a href="#" style="color: #<?php echo contrastFont($elements['threads']); ?>">User</a></span></td>
                        <td width="1%" align="right" nowrap="nowrap"><span class="postinfo" style="color: #<?php echo contrastFont($elements['threads']); ?>">14 Mar 23:56&nbsp;</span></td>
                      </tr>
                      <tr>
                        <td width="1%" align="right" nowrap="nowrap"><span class="posttofromlabel" style="color: #<?php echo contrastFont($elements['threads']); ?>">&nbsp;To:&nbsp;</span></td>
                        <td nowrap="nowrap" width="98%" align="left"><span class="posttofrom" style="color: #<?php echo contrastFont($elements['threads']); ?>">ALL</span></td>
                        <td align="right" nowrap="nowrap"><span class="postinfo" style="color: #<?php echo contrastFont($elements['threads']); ?>">1 of 2&nbsp;</span></td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td>
                    <table width="100%">
                      <tr align="right">
                        <td colspan="3"><span class="postnumber" style="color: #<?php echo contrastFont($elements['box']); ?>"><a href="#" style="color: #<?php echo contrastFont($elements['box']); ?>">1.1</a> in reply to <a href="#" style="color: #<?php echo contrastFont($elements['box']); ?>">1.2</a>&nbsp;</span></td>
                      </tr>
                      <tr>
                        <td class="postbody" style="color: #<?php echo contrastFont($elements['box']); ?>" align="left">Message Preview</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td class="postbody"></td>
                      </tr>
                      <tr>
                        <td align="center">
                          <span class="postresponse">
                            <img src="./images/post.png" height="15" border="0" alt="Reply" />&nbsp;<a href="#" style="color: #<?php echo contrastFont($elements['box']); ?>">Reply</a>&nbsp;&nbsp;
                            <img src="./images/delete.png" height="15" border="0" alt="Delete" />&nbsp;<a href="#" style="color: #<?php echo contrastFont($elements['box']); ?>">Delete</a>&nbsp;&nbsp;
                            <img src="./images/edit.png" height="15" border="0" alt="Edit" />&nbsp;<a href="#" style="color: #<?php echo contrastFont($elements['box']); ?>">Edit</a>&nbsp;&nbsp;
                            <img src="./images/admintool.png" height="15" border="0" alt="Privileges" />&nbsp;<a href="#" style="color: #<?php echo contrastFont($elements['box']); ?>">Privileges</a>
                          </span>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </div>
            <p>&nbsp;</p>
            <div align="center">
            <table width="96%" class="messagefoot" style="background-color: #<?php echo $elements['threads']; ?>; color: #<?php echo contrastFont($elements['threads']); ?>">
              <tr>
                <td align="center">
                  <p align="center" class="smalltext" style="color: #<?php echo contrastFont($elements['threads']); ?>">Show messages: &nbsp;1 &nbsp;<a href="#" style="color: #<?php echo contrastFont($elements['threads']); ?>">2</a></p>
                  <p align="center"></p>
                  <form name="rate_interest" target="_self" action="" method="post">
                    Rate my interest:
                    <span class="bhinputradio"><input type="radio" name="interest" value="-1" />Ignore </span>
                    <span class="bhinputradio"><input type="radio" name="interest" value="0" checked="checked" />Normal </span>
                    <span class="bhinputradio"><input type="radio" name="interest" value="1" />Interested </span>
                    <span class="bhinputradio"><input type="radio" name="interest" value="2" />Subscribe </span>&nbsp;
                    <input type="submit" name="submit" value="Apply" class="button" style="background-color: #<?php echo $elements['button']; ?>; color: #<?php echo contrastFont($elements['button']); ?>" onclick="return false" />
                  </form>
                  <p style="color: #<?php echo contrastFont($elements['threads']); ?>">Adjust text size: <a href="#" style="color: #<?php echo contrastFont($elements['threads']); ?>">Smaller</a> 10 <a href="#" style="color: #<?php echo contrastFont($elements['threads']); ?>">Larger</a></p>
                  <p align="center"></p>
                  <div align="center">
                    <table width="96%" class="posthead" style="background-color: #<?php echo $elements['threads']; ?>; color: #<?php echo contrastFont($elements['threads']); ?>">
                      <tr>
                        <td width="60%" class="smalltext" align="left">
                          Beehive Forum &nbsp;|&nbsp;
                          <a href="#" style="color: #<?php echo contrastFont($elements['threads']); ?>">FAQ</a>&nbsp;|&nbsp;
                          <a href="#" target="_blank" style="color: #<?php echo contrastFont($elements['threads']); ?>">Docs</a> &nbsp;|&nbsp;
                          <a href="#" target="_blank" style="color: #<?php echo contrastFont($elements['threads']); ?>">Support</a>
                        </td>
                        <td width="40%" align="right" class="smalltext">&copy;<?php echo date('Y'); ?> <a href="#" style="color: #<?php echo contrastFont($elements['threads']); ?>">Project BeehiveForum</a></td>
                      </tr>
                    </table>
                  </div>
                </td>
              </tr>
            </table>
            </div>
            <p>&nbsp;</p>
            <h1 style="background-color: #<?php echo $elements['h1']; ?>; color: #<?php echo contrastFont($elements['h1']); ?>">H1 Tag</h1>
            <p class="subhead" style="background-color: #<?php echo $elements['subhead']; ?>; color: #<?php echo contrastFont($elements['subhead']); ?>">Subhead</p>
            <p>&nbsp;</p>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<p>&nbsp;</p>
<?php html_draw_bottom(); ?>