<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
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

// Set the default timezone
date_default_timezone_set('UTC');

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "../../../include/");

// Constant to define where the forum root is located
define("BH_FORUM_PATH", "../../..");

// Compress the output
include_once(BH_INCLUDE_PATH. "gzipenc.inc.php");

// Enable the error handler
include_once(BH_INCLUDE_PATH. "errorhandler.inc.php");

// Installation checking functions
include_once(BH_INCLUDE_PATH. "install.inc.php");

// Check that Beehive is installed correctly
check_install();

include_once(BH_INCLUDE_PATH. "attachments.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

// Get webtag
$webtag = get_webtag();

// See if we can try and logon automatically
logon_perform_auto();

// Check we're logged in correctly
if (!$user_sess = session_check()) {
    $request_uri = rawrawurlencode(get_request_uri());
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check we have a webtag
if (!forum_check_webtag_available($webtag)) {
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

// Function to format the display of people's names.
function formatname($filename)
{
    return ucfirst(strtolower($filename));
}

// Function to resize uploaded image.
function resize_image($image_file_path, $max_width, $max_height)
{
    if (!is_numeric($max_width)) $max_width = 150;
    if (!is_numeric($max_height)) $max_height = 150;

    // Required PHP image create from functions
    $required_read_functions  = array(1 => 'imagecreatefromgif',
                                      2 => 'imagecreatefromjpeg',
                                      3 => 'imagecreatefrompng');

    // Required PHP image output functions
    $required_write_functions = array(1 => 'imagegif',
                                      2 => 'imagejpeg',
                                      3 => 'imagepng');

    // Required GD read support
    $required_read_support = array(1 => array('GIF Read Support'),
                                   2 => array('JPG Support', 'JPEG Support'),
                                   3 => array('PNG Support'));

    // Required GD write support
    $required_write_support = array(1 => array('GIF Create Support'),
                                    2 => array('JPG Support', 'JPEG Support'),
                                    3 => array('PNG Support'));

    // Check the file exists and we can get some image data from it.
    if (!file_exists($image_file_path) || !($image_info = @getimagesize($image_file_path))) return false;

    // Check the gd_info function exists
    if (!function_exists('gd_info') || !($gd_info = gd_info())) return false;

    // Check 1: Is the image format in our list of supported image types.
    if (!isset($required_read_support[$image_info[2]])) return false;
    if (!isset($required_write_support[$image_info[2]])) return false;

    // Check 2: Check gd_info function indicates support for the image type.
    if (!attachments_get_gd_info_key($required_read_support[$image_info[2]])) return false;
    if (!attachments_get_gd_info_key($required_write_support[$image_info[2]])) return false;

    // Check 3: Even if GD says it supports the image format check the php functions actually exist!
    if (!function_exists($required_read_functions[$image_info[2]])) return false;
    if (!function_exists($required_write_functions[$image_info[2]])) return false;

    // Got this far, lets try reading the image.
    if (!($src = @$required_read_functions[$image_info[2]]($image_file_path))) return false;

    $target_width  = $image_info[0];
    $target_height = $image_info[1];

    while ($target_width > $max_width || $target_height > $max_height) {

        $target_width--;
        $target_height = $target_width * ($image_info[1] / $image_info[0]);
    }

    if (strcmp($gd_info['GD Version'], '2.0') > -1) {

        $dst = imagecreatetruecolor($target_width, $target_height);
        $dst = attachments_thumb_transparency($dst);

        imagecopyresampled($dst, $src, 0, 0, 0, 0, $target_width,
                           $target_height, $image_info[0], $image_info[1]);

    } else {

        $dst = imagecreate($target_width, $target_height);
        $dst = attachments_thumb_transparency($dst);

        imagecopyresized($dst, $src, 0, 0, 0, 0, $target_width,
                         $target_height, $image_info[0], $image_info[1]);
    }

    return $required_write_functions[$image_info[2]]($dst, $image_file_path);
}

// Load language file
$lang = load_language_file();

// Where are the images stored?
$images_dir = "../../../forumites";

// Initialise the array to store the images in
$images_array = array();

// Uploading an image?
if ((isset($_POST['upload'])) && (session_get_value('UID') > 0)) {

    if (isset($_FILES['userimage']['tmp_name']) && @is_readable($_FILES['userimage']['tmp_name'])) {

        $logon = session_get_value('LOGON');

        $temp_file = $_FILES['userimage']['tmp_name'];

        $image_file_path = "$images_dir/$logon";

        if (@($image_data = getimagesize($temp_file))) {

            if (@move_uploaded_file($temp_file, $image_file_path)) {

                if (resize_image($image_file_path, $image_file_path, 300, 300)) {

                    $modified_time = filemtime($image_file_path);

                    html_draw_top('user_profile.js', "stylesheet=gallery.css");

                    echo "<h1>Uploaded Image</h1>\n";
                    echo "<div class=\"image\">\n";
                    echo "<p><div align=\"center\"><a href=\"", html_get_forum_file_path("user_profile.php?webtag=$webtag&amp;logon=$logon"), "\" target=\"_blank\" class=\"popup 650x500\"><img src=\"$images_dir/", rawurlencode($logon), "?$modified_time\" border=\"0\" alt=\"", formatname($logon), "\" title=\"", formatname($logon), "\" /></a></div></p>\n";
                    echo "<p><div align=\"center\"><a href=\"", html_get_forum_file_path("user_profile.php?webtag=$webtag&amp;logon=$logon"), "\" target=\"_blank\" class=\"popup 650x500\">", formatname($logon), "</a></div></p>\n";
                    echo "<p><div align=\"center\">[<a href=\"gallery.php\">Random Image</a> | <a href=\"gallery.php?gallery\">Gallery</a> | <a href=\"?upload\">Upload different image</a>]</div></p>\n";
                    echo "</div>\n";

                    html_draw_bottom();
                    exit;
                }
            }
        }

        html_draw_top('user_profile.js', "stylesheet=gallery.css");

        echo "<h1>Error</h1>\n";
        echo "<p>Something went wrong. You'll be needing to try again.</p>";

        html_draw_bottom();
        exit;
    }
}

// Get the files here
if (@($dir = opendir($images_dir))) {

    while(($file = readdir($dir)) !== false) {

        if ($file != '.' && $file != '..' && !is_dir($file)) {

            if (@($image_info = getimagesize("$images_dir/$file"))) {

                $images_array[] = $file;
            }
        }
    }

    closedir($dir);
}

// Sort the files by name ASC
sort($images_array);

// Draw the HTML header
html_draw_top('user_profile.js', "stylesheet=gallery.css");

// Delete a selected image
if (isset($_GET['delete'])) {

    $image = basename($_GET['delete']);
    $logon = session_get_value('LOGON');

    if (session_check_perm(USER_PERM_ADMIN_TOOLS, 0) || strtolower($image) == strtolower($logon)) {

        $modified_time = filemtime("$images_dir/$image");

        echo "<h1>Delete Image</h1>\n";
        echo "<div class=\"image\">\n";
        echo "<p><div align=\"center\"><a href=\"", html_get_forum_file_path("user_profile.php?webtag=$webtag&amp;logon=$logon"), "\" target=\"_blank\" class=\"popup 650x500\"><img src=\"$images_dir/", rawurlencode($image), "?$modified_time\" border=\"0\" alt=\"", formatname($image), "\" title=\"", formatname($image), "\" /></a></div></p>\n";
        echo "<p><div align=\"center\"><a href=\"", html_get_forum_file_path("user_profile.php?webtag=$webtag&amp;logon=$logon"), "\" target=\"_blank\" class=\"popup 650x500\">", formatname($image), "</a></div></p>\n";
        echo "<p><div align=\"center\">[<a href=\"gallery.php?confirm_delete=$image\">Delete</a> | <a href=\"gallery.php?gallery\">Cancel</a>]</div></p>\n";
        echo "</div>\n";

        html_draw_bottom();
        exit;
    }

} else if (isset($_GET['confirm_delete'])) {

    $image = basename($_GET['confirm_delete']);
    $logon = session_get_value('LOGON');

    if (session_check_perm(USER_PERM_ADMIN_TOOLS, 0) || strtolower($image) == strtolower($logon)) {

        if (@file_exists("forums/$webtag/$images_dir/$image")) {

            if (!@unlink("forums/$webtag/$images_dir/$image")) {

                html_draw_top('user_profile.js', "stylesheet=start_main.css");
                echo "<h1>Error</h1>\n";
                echo "<p>Something went wrong. You'll be needing to try again.</p>";
                html_draw_bottom();
                exit;
            }
        }
    }
}

// Upload / Show Gallery / Random image
if ((isset($_GET['upload'])) && (session_get_value('UID') > 0)) {

    echo "<h1>Upload Image</h1>\n";
    echo "<br />\n";
    echo "<form enctype=\"multipart/form-data\" method=\"post\" action=\"gallery.php\">\n";
    echo "  ", form_input_hidden("webtag", htmlentities_array($webtag)), "\n";
    echo "  ", form_input_file("userimage", "", 40, 0), "\n";
    echo "  ", form_submit("upload", $lang['upload']), "\n";
    echo "  ", form_submit("cancel", $lang['cancel']), "\n";
    echo "</form>\n";

    echo "<p>Some rules:</p>\n";
    echo "<ol>\n";
    echo "  <li>You only get one image, which is stored as your forum logon.</li>\n";
    echo "  <li>Image will be automatically resized down to a max of 300x300px.</li>\n";
    echo "</ol>\n";

} else if (isset($_GET['gallery'])) {

    $images_array = array_pad($images_array, ceil(sizeof($images_array) / 3) * 3, '');

    echo "<h1>Convicts Gallery</h1>\n";
    echo "<ul class=\"gallery\">\n";

    foreach($images_array as $key => $image) {

        if ((@$image_info = getimagesize("$images_dir/$image"))) {

            $target_width  = $image_info[0];
            $target_height = $image_info[1];

            while ($target_width > 150 || $target_height > 150) {

                $target_width--;
                $target_height = floor($target_width * ($image_info[1] / $image_info[0]));
            }

            $css_margin = floor((175 - $target_height) / 2);

            $modified_time = filemtime("$images_dir/$image");

            echo "  <li>\n";
            echo "    <a href=\"gallery.php?view_image=", rawurlencode($image), "\"><img src=\"$images_dir/", rawurlencode($image), "?$modified_time\" alt=\"", formatname($image), "\" title=\"", formatname($image), "\" style=\"height: {$target_height}px; margin: {$css_margin}px 0;\"/></a>\n";
            echo "    <label><a href=\"", html_get_forum_file_path("user_profile.php?webtag=$webtag&amp;logon=$image"), "\" target=\"_blank\" class=\"popup 650x500\">", formatname($image), "</a></label>\n";
            echo "  </li>\n";
        }
    }

    echo "  <div class=\"clearer\"></div>\n";
    echo "</ul>\n";
    echo "<div class=\"footer\">\n";

    if (session_get_value('UID') > 0) {

        echo "  <a href=\"gallery.php\">Random Image</a>&nbsp;|&nbsp;\n";
        echo "  <a href=\"gallery.php?gallery\">Gallery</a>&nbsp;|&nbsp;\n";
        echo "  <a href=\"gallery.php?upload\">Upload an image</a>\n";

    } else {

        echo "  <a href=\"gallery.php\">Random Image</a>&nbsp;|&nbsp;\n";
        echo "  <a href=\"gallery.php?gallery\">Gallery</a>\n";
    }

    echo "</div>\n";

} else if (is_array($images_array) && sizeof($images_array) > 0) {

    $logon = session_get_value('LOGON');

    if (isset($_GET['view_image'])) {

        $image = $_GET['view_image'];

        if (!in_array($image, $images_array)) {

            echo "<h1>Convicts Gallery</h1>\n";
            echo "<h2>Oops. Can't find that person. Try again.</h2>\n";

            html_draw_bottom();
            exit;
        }

    } else {

        $random_image_id = mt_rand(0, sizeof($images_array) - 1);
        $image = $images_array[$random_image_id];
    }

    $modified_time = filemtime("$images_dir/$image");

    echo "<h1>", mb_convert_case($image, MB_CASE_TITLE), "</h1>\n";
    echo "<div class=\"profile_image\">\n";
    echo "  <a href=\"", html_get_forum_file_path("user_profile.php?webtag=$webtag&amp;logon=$image"), "\" target=\"_blank\" class=\"popup 650x500\"><img src=\"$images_dir/", rawurlencode($image), "?$modified_time\" border=\"0\" alt=\"", formatname($image), "\" title=\"", formatname($image), "\" /></a>\n";
    echo "</div>\n";
    echo "<div class=\"profile_link\">\n";
    echo "  <a href=\"", html_get_forum_file_path("user_profile.php?webtag=$webtag&amp;logon=$image"), "\" target=\"_blank\" class=\"popup 650x500\">", formatname($image), "</a>\n";
    echo "</div>\n";
    echo "<div class=\"footer\">\n";

    if (session_get_value('UID') > 0) {

        echo "  <a href=\"gallery.php\">Random Image</a>&nbsp;|&nbsp;\n";
        echo "  <a href=\"gallery.php?gallery\">Gallery</a>&nbsp;|&nbsp;\n";
        echo "  <a href=\"?upload\">Upload an image</a>";

        if (session_check_perm(USER_PERM_ADMIN_TOOLS, 0) || strtolower($image) == strtolower($logon)) {

            echo "&nbsp;|&nbsp;\n<a href=\"?delete=$image\">Delete</a>\n";
        }

    } else {

        echo "  <a href=\"gallery.php\">Random Image</a>&nbsp;|&nbsp;\n";
        echo "  <a href=\"gallery.php?gallery\">Gallery</a>\n";
    }

    echo "</div>\n";

} else {

    echo "<h1>Convicts Gallery</h1>\n";

    if (session_get_value('UID') > 0) {
        echo "<div align=\"center\"><p><a href=\"?upload\">Upload an image</a></p></div>\n";
    } else {
        echo "<div align=\"center\"><p>Gallery is empty</p></div>\n";
    }
}

html_draw_bottom();

?>