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

/* $Id: admin_make_style.php,v 1.30 2004-03-12 18:46:50 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

//Multiple forum support
include_once("./include/forum.inc.php");

include_once("./include/admin.inc.php");
include_once("./include/constants.inc.php");
include_once("./include/db.inc.php");
include_once("./include/form.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/make_style.inc.php");
include_once("./include/session.inc.php");

if (!bh_session_check()) {
    $uri = "./logon.php?webtag=$webtag&final_uri=". urlencode(get_request_uri());
    header_redirect($uri);
}

if (!(bh_session_get_value('STATUS') & USER_PERM_SOLDIER)) {
    html_draw_top();
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;
}

// Save the style

$success = false;

if (isset($HTTP_POST_VARS['submit'])) {

    if (isset($HTTP_POST_VARS['stylename']) && strlen(trim($HTTP_POST_VARS['stylename'])) > 0) {

        // Get the style filename
        
        $stylename = trim($HTTP_POST_VARS['stylename']);
        $stylename = strtolower(str_replace(" ", "_", $stylename));
        $stylename = preg_replace("/[^a-z|0-9|'_']/", "", $stylename);
        
        // Get the style desc - if no description use the filename.
        
        if (isset($HTTP_POST_VARS['styledesc']) && strlen(trim($HTTP_POST_VARS['styledesc'])) > 0) {
            $styledesc = trim($HTTP_POST_VARS['styledesc']);
        }else {
            $styledesc = $stylename;
        }
        
        clearstatcache();
        
        // Read in the master style sheet.
       
        $stylesheet = implode('', file("./styles/make_style.css"));
        
        // Modify it with the colours specified by the post data.
        
        foreach ($HTTP_POST_VARS['elements'] as $key => $value) {
            $stylesheet = str_replace("\$elements[$key]", strtoupper($value), $stylesheet);
            $stylesheet = str_replace("\$text_colour[$key]", strtoupper(contrastFont($value)), $stylesheet);
        }        
        
        // Save the style sheet

        if (!@file_exists("./styles/$stylename/style.css")) {

            /*if (@mkdir("./styles/$stylename", 0755)) {

                @chmod("./styles/$stylename", 0777);
                
                // Save the style desc

                if (@$fp = fopen("./styles/$stylename/desc.txt", "w")) {
                    
                    fwrite($fp, $styledesc);
                    fclose($fp);

                    if (@$fp = fopen("./styles/$stylename/style.css", "w")) {
   
                        fwrite($fp, $stylesheet);
                        fclose($fp);

                        $success = true;
                            
                        admin_addlog(0, 0, 0, 0, 0, 0, 17);
                        echo "<h2>{$lang['newstyle']} \"$stylename\" {$lang['successfullycreated']}</h2>\n";
                    }
                }
            }*/
            
            // We failed to save the style locally, so send it to the user
            // so they can then upload it to the server via FTP.
            
            if (!$success) {
                
                admin_addlog(0, 0, 0, 0, 0, 0, 17);
                
                $style_download = "/*======================================================================\n";
		$style_download.= "Copyright Project BeehiveForum 2002\n\n";
		$style_download.= "This file is part of BeehiveForum.\n\n";
		$style_download.= "BeehiveForum is free software; you can redistribute it and/or modify\n";
		$style_download.= "it under the terms of the GNU General Public License as published by\n";
		$style_download.= "the Free Software Foundation; either version 2 of the License, or\n";
		$style_download.= "(at your option) any later version.\n\n";
		$style_download.= "BeehiveForum is distributed in the hope that it will be useful,\n";
		$style_download.= "but WITHOUT ANY WARRANTY; without even the implied warranty of\n";
		$style_download.= "MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the\n";
		$style_download.= "GNU General Public License for more details.\n\n";
		$style_download.= "You should have received a copy of the GNU General Public License\n";
		$style_download.= "along with Beehive; if not, write to the Free Software\n";
		$style_download.= "Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307\n";
		$style_download.= "USA\n";
		$style_download.= "======================================================================\n\n";
                $style_download.= "*** Auto generated by BeehiveForum on ". date('d/m/Y', mktime()). "\n\n";
                $style_download.= "*** Beehive was unable to save this style locally to your\n";
                $style_download.= "*** server. Please upload this file to your forum styles\n";
                $style_download.= "*** folder, creating where neccesary the folder to hold\n";
                $style_download.= "*** this style.css file.\n\n";
                $style_download.= "======================================================================*/\n\n";
                $style_download.= $stylesheet;
                       
                $length = strlen($style_download);                
                
                header("Content-Type: application/x-ms-download", true);
                header("Content-Length: $length", true);
                header("Content-disposition: attachment; filename=\"style.css\"", true);                
                echo $style_download;
                exit;
            }            

        }else {
        
            echo "<h2>{$lang['stylealreadyexists']}</h2>\n";
        }

    }else {
    
        echo "<h2>{$lang['stylenofilename']}</h2>\n";    
    }
}

// Start Here

html_draw_top();

echo "<h1>{$lang['admin']} : {$lang['createforumstyle']}</h1>\n";

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

if (isset($HTTP_GET_VARS['mode']) && $HTTP_GET_VARS['mode'] == 'rand') {
    $mode = 'rand';
}else {
    $mode = '';
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


echo "<p>{$lang['styleexp']}</p>\n";
echo "<div align=\"center\">\n";
echo "  <table width=\"70%\" class=\"box\">\n";
echo "    <tr>\n";
echo "      <td class=\"posthead\">\n";
echo "        <table width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td colspan=\"2\" class=\"subhead\" align=\"left\">{$lang['stylecontrols']}</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td colspan=\"2\" class=\"posthead\">\n";
echo "              <table width=\"100%\">\n";
echo "                <tr>\n";

if (isset($HTTP_POST_VARS['submit'])) {

    $elements = $HTTP_POST_VARS['elements'];

    foreach ($HTTP_POST_VARS['elements'] as $key => $value) {

        echo "                  <td width=\"50\" class=\"posthead\" style=\"background-color: #", $value, "\" align=\"center\">\n";
        echo "                    <a href=\"admin_make_style.php?webtag=$webtag&seed=", $value, "&amp;mode=", $mode, "\" style=\"color: #", contrastFont($value), "\">", strtoupper($value), "</a>\n";
        echo "                  </td>\n";

    }


}else {

    foreach ($elements as $key => $value) {

        echo "                  <td width=\"50\" class=\"posthead\" style=\"background-color: #", $colour, "; color: #", contrastFont($colour), "\" align=\"center\">\n";
        echo "                    <a href=\"admin_make_style.php?webtag=$webtag&seed=", $colour, "&amp;mode=", $mode, "\" style=\"color: #", contrastFont($colour), "\">", strtoupper($colour), "</a>\n";
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
echo "                    {$lang['stylecolourexp']}\n";
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
echo "                    <a href=\"admin_make_style.php?webtag=$webtag&r=$r\">{$lang['standardstyle']}</a><br />\n";
echo "                    <a href=\"admin_make_style.php?webtag=$webtag&mode=med&amp;r=$r\">{$lang['rotelementstyle']}</a><br />\n";
echo "                    <a href=\"admin_make_style.php?webtag=$webtag&mode=rand&amp;r=$r\">{$lang['randstyle']}</a>\n";
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
echo "                    <a href=\"admin_make_style.php?webtag=$webtag&seed=$seed&amp;r=$r\">{$lang['standardstyle']}</a><br />\n";
echo "                    <a href=\"admin_make_style.php?webtag=$webtag&seed=$seed&amp;mode=medi&amp;r=$r\">{$lang['rotelementstyle']}</a><br />\n";
echo "                    <a href=\"admin_make_style.php?webtag=$webtag&seed=$seed&amp;mode=rand&amp;r=$r\">{$lang['randstyle']}</a>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td class=\"posthead\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td class=\"posthead\" align=\"left\">{$lang['enterhexcolour']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td class=\"posthead\" align=\"left\">\n";
echo "                    <form action=\"admin_make_style.php?webtag=$webtag\" method=\"get\">\n";
echo "                      ", form_input_text("seed", strtoupper($seed), 15, 6), "&nbsp;", form_submit('submit', $lang['go']), "\n";
echo "                    </form>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "            <td valign=\"top\" class=\"posthead\" align=\"left\">\n";
echo "              <table width=\"100%\" cellspacing=\"5\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\">{$lang['savestyle']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td class=\"posthead\">\n";
echo "                    <form action=\"admin_make_style.php?webtag=$webtag\" method=\"post\">\n";

foreach ($elements as $key => $value) {
    echo "                      ", form_input_hidden("elements[$key]", $value), "\n";
}

reset($elements);

echo "                      <table width=\"100%\" cellspacing=\"5\">\n";
echo "                        <tr>\n";
echo "                          <td class=\"posthead\">{$lang['filename']}:</td>\n";
echo "                          <td>", form_input_text("stylename", isset($HTTP_POST_VARS['stylename']) ? $HTTP_POST_VARS['stylename'] : '', 35, 10), "</td>\n";
echo "                        </tr>\n";
echo "                        <tr>\n";
echo "                          <td class=\"posthead\">{$lang['styledesc']}:</td>\n";
echo "                          <td>", form_input_text("styledesc", isset($HTTP_POST_VARS['styledesc']) ? $HTTP_POST_VARS['styledesc'] : '', 35, 20), "&nbsp;", form_submit('submit', 'Save'), "</td>\n";
echo "                        </tr>\n";
echo "                      </table>\n";
echo "                    </form>\n";
echo "                  </td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td class=\"posthead\">{$lang['fileallowedchars']}</td>\n";
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
<p><?php echo $lang['stylepreview']; ?>:</p>
<table width="96%" cellpadding="0" cellspacing="0" align="center" class="box">
  <tr>
    <td>
      <table border="0" cellpadding="0" cellspacing="0" width="100%" align="center" style="background-color: #<?php echo $elements['body']; ?>; color: #<?php echo contrastFont($elements['body']); ?>">
        <tr>
          <td colspan="3" height="20" style="background-color: #<?php echo $elements['navpage']; ?>; color: #<?php echo contrastFont($elements['navpage']); ?>; font-size: 10px; font-weight: bold; text-decoration: none"><bdo dir="<?php echo $lang['_textdir']; ?>">&nbsp;&nbsp;</bdo>
            <a href="#" style="color: #<?php echo contrastFont($elements['navpage'])."\">".$lang['start']; ?></a>&nbsp;|&nbsp;
            <a href="#" style="color: #<?php echo contrastFont($elements['navpage'])."\">".$lang['messages']; ?></a>&nbsp;|&nbsp;
            <a href="#" style="color: #<?php echo contrastFont($elements['navpage'])."\">".$lang['links']; ?></a>&nbsp;|&nbsp;
            <a href="#" style="color: #<?php echo contrastFont($elements['navpage'])."\">".$lang['preferences']; ?></a>&nbsp;|&nbsp;
            <a href="#" style="color: #<?php echo contrastFont($elements['navpage'])."\">".$lang['profile']; ?></a>&nbsp;|&nbsp;
            <a href="#" style="color: #<?php echo contrastFont($elements['navpage'])."\">".$lang['admin']; ?></a>&nbsp;|&nbsp;
            <a href="#" style="color: #<?php echo contrastFont($elements['navpage'])."\">".$lang['logout']; ?></a>
          </td>
        </tr>
        <tr>
          <td width="240" valign="top" align="center">
            <table width="220" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td class="postbody" style="color: #<?php echo contrastFont($elements['body']); ?>" colspan="2" align="left">
                  <img src="./images/post.png" height="15" alt="<?php echo $lang['newdiscussion']; ?>" />&nbsp;<a href="#" style="color: #<?php echo contrastFont($elements['body'])."\">".$lang['newdiscussion']; ?></a><br />
                  <img src="./images/poll.png" height="15" alt="<?php echo $lang['createpoll']; ?>" />&nbsp;<a href="#" style="color: #<?php echo contrastFont($elements['body'])."\">".$lang['createpoll']; ?></a><br />
                  <img src="./images/search.png" height="15" alt="<?php echo $lang['search']; ?>" />&nbsp;<a href="#" style="color: #<?php echo contrastFont($elements['body'])."\">".$lang['search']; ?></a><br />
                </td>
              </tr>
              <tr>
                <td colspan="2">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="2" align="left">
                  <form name="f_mode" method="get" action="">
                    <select name="mode" class="bhselect">
                      <option value="0" selected="selected"><?php echo $lang['alldiscussions']; ?></option>
                      <option value="1"><?php echo $lang['unreaddiscussions']; ?></option>
                      <option value="2"><?php echo $lang['unreadtome']; ?></option>
                      <option value="3"><?php echo $lang['todaysdiscussions']; ?></option>
                      <option value="4"><?php echo $lang['2daysback']; ?></option>
                      <option value="5"><?php echo $lang['7daysback']; ?></option>
                      <option value="6"><?php echo $lang['highinterest']; ?></option>
                      <option value="7"><?php echo $lang['unreadhighinterest']; ?></option>
                      <option value="8"><?php echo $lang['iverecentlyseen']; ?></option>
                      <option value="9"><?php echo $lang['iveignored']; ?></option>
                      <option value="10"><?php echo $lang['ivesubscribedto']; ?></option>
                      <option value="11"><?php echo $lang['startedbyfriend']; ?></option>
                      <option value="12"><?php echo $lang['unreadstartedbyfriend']; ?></option>
                    </select>
                    <input type="submit" name="go" value=<?php echo $lang['goexcmark']; ?> class="button" style="background-color: #<?php echo $elements['button']; ?>; color: #<?php echo contrastFont($elements['button']); ?>" onclick="return false" />
                  </form>
                </td>
              </tr>
              <tr>
                <td colspan="2" align="left">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="foldername"><img src="./images/folder.png" height="15" alt="<?php echo $lang['folder']; ?>" /><a href="#" style="color: #<?php echo contrastFont($elements['body']); ?>">General</a></td>
                      <td class="folderpostnew" width="15"><a href="#"><img src="images/folder_hide.png" border="0" height="15" alt="<?php echo $lang['folderinterest']; ?>" /></a></td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <td colspan="2" align="left">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="threads" style="background-color: #<?php echo $elements['threads']; ?>; color: #<?php echo contrastFont($elements['threads']); ?>; border-color: #<?php echo contrastFont($elements['box']); ?>; border-bottom-width: 0px; border-right-width: 0px" align="left" valign="top" width="50%" nowrap="nowrap">
                        <a href="#" class="folderinfo" style="color: #<?php echo contrastFont($elements['threads']); ?>">1 <?php echo $lang['thread']; ?></a>
                      </td>
                      <td class="threads" style="background-color: #<?php echo $elements['threads']; ?>; color: #<?php echo contrastFont($elements['threads']); ?>; border-color: #<?php echo contrastFont($elements['box']); ?>; border-bottom-width: 0px; border-left-width: 0px" align="right" valign="top" width="50%" nowrap="nowrap">
                        <a href="#" class="folderpostnew" style="color: #<?php echo contrastFont($elements['threads']); ?>"><?php echo $lang['postnew']; ?></a>
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
                        <img src="./images/current_thread.png" align="middle" height="15" alt="<?php echo $lang['currentthread']; ?>" />&nbsp;
                      </td>
                      <td valign="top"><a href="#" class="threadname" style="color: #<?php echo contrastFont($elements['threads']); ?>"><?php echo $lang['welcome']; ?></a>&nbsp;<img src="./images/high_interest.png" height="15" alt="<?php echo $lang['highinterest']; ?>" />&nbsp;<span class="threadxnewofy" style="color: #<?php echo contrastFont($elements['threads']); ?>">[2]</span></td>
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
                <td class="smalltext" style="color: #<?php echo contrastFont($elements['body']); ?>" colspan="2" align="left"><?php echo $lang['markasread']; ?>:</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td class="smalltext" style="color: #<?php echo contrastFont($elements['body']); ?>" align="left">
                  <form name="f_mark" method="get" action="">
                    <input type="hidden" name="tids" class="bhinputtext" value="1" />
                    <select name="markread" class="bhselect">
                      <option value="0" selected="selected"><?php echo $lang['alldiscussions']; ?></option>
                      <option value="1"><?php echo $lang['next50discussions']; ?>s</option>
                      <option value="2"><?php echo $lang['visiblediscussions']; ?></option>
                    </select>
                    <input type="submit" name="go" value="<?php echo $lang['goexcmark']; ?>" class="button" style="background-color: #<?php echo $elements['button']; ?>; color: #<?php echo contrastFont($elements['button']); ?>" onclick="return false" />
                  </form>
                </td>
              </tr>
            </table>
            <table width="220" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="smalltext" style="color: #<?php echo contrastFont($elements['body']); ?>" colspan="2" align="left"><?php echo $lang['navigate']; ?>:</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td class="smalltext" style="color: #<?php echo contrastFont($elements['body']); ?>" align="left">
                  <form name="f_nav" method="get" action="">
                    <input type="text" name="msg" class="bhinputtext" value="1.1" size="10" />
                    <input type="submit" name="go" value="<?php echo $lang['goexcmark']; ?>" class="button" style="background-color: #<?php echo $elements['button']; ?>; color: #<?php echo contrastFont($elements['button']); ?>" onclick="return false" />
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
                  <td style="color: #<?php echo contrastFont($elements['body']); ?>"><p style="color: #<?php echo contrastFont($elements['body']); ?>" align="left"><img src="./images/folder.png" alt="<?php echo $lang['folder']; ?>" />&nbsp;General: Welcome&nbsp;<img src="./images/high_interest.png" height="15" alt="<?php echo $lang['highinterest']; ?>" /></p></td>
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
                        <td width="1%" align="right" nowrap="nowrap"><span class="posttofromlabel" style="color: #<?php echo contrastFont($elements['threads']); ?>">&nbsp;<?php echo $lang['from']; ?>:&nbsp;</span></td>
                        <td nowrap="nowrap" width="98%" align="left"><span class="posttofrom"><a href="#" style="color: #<?php echo contrastFont($elements['threads']); ?>">User</a></span></td>
                        <td width="1%" align="right" nowrap="nowrap"><span class="postinfo" style="color: #<?php echo contrastFont($elements['threads']); ?>">14 Mar 23:56&nbsp;</span></td>
                      </tr>
                      <tr>
                        <td width="1%" align="right" nowrap="nowrap"><span class="posttofromlabel" style="color: #<?php echo contrastFont($elements['threads']); ?>">&nbsp;<?php echo $lang['to']; ?>:&nbsp;</span></td>
                        <td nowrap="nowrap" width="98%" align="left"><span class="posttofrom" style="color: #<?php echo contrastFont($elements['threads']); ?>"><?php echo $lang['all_caps']; ?></span></td>
                        <td align="right" nowrap="nowrap"><span class="postinfo" style="color: #<?php echo contrastFont($elements['threads']); ?>">1 <?php echo $lang['of']; ?> 2&nbsp;</span></td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td>
                    <table width="100%">
                      <tr align="right">
                        <td colspan="3"><span class="postnumber" style="color: #<?php echo contrastFont($elements['box']); ?>"><a href="#" style="color: #<?php echo contrastFont($elements['box']); ?>">1.1</a> <?php echo $lang['inreplyto']; ?> <a href="#" style="color: #<?php echo contrastFont($elements['box']); ?>">1.2</a>&nbsp;</span></td>
                      </tr>
                      <tr>
                        <td class="postbody" style="color: #<?php echo contrastFont($elements['box']); ?>" align="left"><?php echo $lang['messagepreview']; ?></td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                      </tr>
                      <tr>
                        <td class="postbody"></td>
                      </tr>
                    </table>
                    <table width="100%" class="postresponse" style="background-color: #<?php echo $elements['body']; ?>; color: #<?php echo contrastFont($elements['body']); ?>" cellspacing="1" cellpadding="0">
                      <tr>
                        <td align="center">
                            <img src="./images/post.png" height="15" border="0" alt="<?php echo $lang['reply']; ?>" />&nbsp;<a href="#" style="color: #<?php echo contrastFont($elements['box']); ?>"><?php echo $lang['reply']; ?></a><bdo dir="<?php echo $lang['_textdir']; ?>">&nbsp;&nbsp;</bdo>
                            <img src="./images/delete.png" height="15" border="0" alt="<?php echo $lang['delete']; ?>" />&nbsp;<a href="#" style="color: #<?php echo contrastFont($elements['box']); ?>"><?php echo $lang['delete']; ?></a><bdo dir="<?php echo $lang['_textdir']; ?>">&nbsp;&nbsp;</bdo>
                            <img src="./images/edit.png" height="15" border="0" alt="<?php echo $lang['edit']; ?>" />&nbsp;<a href="#" style="color: #<?php echo contrastFont($elements['box']); ?>"><?php echo $lang['edit']; ?></a><bdo dir="<?php echo $lang['_textdir']; ?>">&nbsp;&nbsp;</bdo>
                            <img src="./images/admintool.png" height="15" border="0" alt="<?php echo $lang['privileges']; ?>" />&nbsp;<a href="#" style="color: #<?php echo contrastFont($elements['box']); ?>"><?php echo $lang['privileges']; ?></a>
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
                  <p align="center" class="smalltext" style="color: #<?php echo contrastFont($elements['threads']); ?>"><?php echo $lang['showmessages']; ?>: &nbsp;1 &nbsp;<a href="#" style="color: #<?php echo contrastFont($elements['threads']); ?>">2</a></p>
                  <p align="center"></p>
                  <form name="rate_interest" target="_self" action="" method="post">
                    <?php echo $lang['ratemyinterest']; ?>t:
                    <span class="bhinputradio"><input type="radio" name="interest" value="-1" /><?php echo $lang['ignore']; ?> </span>
                    <span class="bhinputradio"><input type="radio" name="interest" value="0" checked="checked" /><?php echo $lang['normal']; ?> </span>
                    <span class="bhinputradio"><input type="radio" name="interest" value="1" /><?php echo $lang['interested']; ?> </span>
                    <span class="bhinputradio"><input type="radio" name="interest" value="2" /><?php echo $lang['subscribe']; ?> </span>&nbsp;
                    <input type="submit" name="submit" value="<?php echo $lang['apply']; ?>" class="button" style="background-color: #<?php echo $elements['button']; ?>; color: #<?php echo contrastFont($elements['button']); ?>" onclick="return false" />
                  </form>
                  <p style="color: #<?php echo contrastFont($elements['threads']); ?>"><?php echo $lang['adjtextsize']; ?>: <a href="#" style="color: #<?php echo contrastFont($elements['threads']); ?>"><?php echo $lang['smaller']; ?></a> 10 <a href="#" style="color: #<?php echo contrastFont($elements['threads']); ?>"><?php echo $lang['larger']; ?></a></p>
                  <p align="center"></p>
                  <div align="center">
                    <table width="96%" class="posthead" style="background-color: #<?php echo $elements['threads']; ?>; color: #<?php echo contrastFont($elements['threads']); ?>">
                      <tr>
                        <td width="60%" class="smalltext" align="left">
                          Beehive Forum &nbsp;|&nbsp;
                          <a href="#" style="color: #<?php echo contrastFont($elements['threads']); ?>"><?php echo $lang['faq']; ?></a>&nbsp;|&nbsp;
                          <a href="#" target="_blank" style="color: #<?php echo contrastFont($elements['threads']); ?>"><?php echo $lang['docs']; ?></a> &nbsp;|&nbsp;
                          <a href="#" target="_blank" style="color: #<?php echo contrastFont($elements['threads']); ?>"><?php echo $lang['support']; ?></a>
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
            <h1 style="background-color: #<?php echo $elements['h1']; ?>; color: #<?php echo contrastFont($elements['h1']); ?>"><?php echo $lang['h1tag']; ?></h1>
            <p class="subhead" style="background-color: #<?php echo $elements['subhead']; ?>; color: #<?php echo contrastFont($elements['subhead']); ?>"><?php echo $lang['subhead']; ?></p>
            <p>&nbsp;</p>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<p>&nbsp;</p>
<?php

html_draw_bottom();

?>