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

// Bootstrap
require_once 'boot.php';

// Required includes
require_once BH_INCLUDE_PATH . 'cache.inc.php';
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'server.inc.php';
// End Required includes

// User font size
if (isset($_SESSION['FONT_SIZE']) && is_numeric($_SESSION['FONT_SIZE'])) {
    $font_size = max(min($_SESSION['FONT_SIZE'], 15), 5);
} else {
    $font_size = 10;
}

// User style
if (isset($_SESSION['STYLE']) && strlen(trim($_SESSION['STYLE'])) > 0) {
    $user_style = $_SESSION['STYLE'];
} else {
    $user_style = forum_get_setting('default_style', 'strlen', 'default');
}

// User emoticons
if (isset($_SESSION['EMOTICONS']) && strlen(trim($_SESSION['EMOTICONS'])) > 0) {
    $user_emoticons = $_SESSION['EMOTICONS'];
} else {
    $user_emoticons = forum_get_setting('default_emoticons', 'strlen', 'default');
}

// Get the user's saved left frame width.
if (isset($_SESSION['LEFT_FRAME_WIDTH']) && is_numeric($_SESSION['LEFT_FRAME_WIDTH'])) {
    $left_frame_width = max(100, $_SESSION['LEFT_FRAME_WIDTH']);
} else {
    $left_frame_width = 280;
}

// Get the attachment max file size (default: 2MB)
if (($attachment_size_limit = forum_get_setting('attachment_size_limit', 'is_numeric', false)) === false) {
    $attachment_size_limit = convert_shorthand_filesize(ini_get('upload_max_filesize'));
}

// Construct the Javascript / JSON array
$json_data = array(
    'webtag' => $webtag,
    'uid' => $_SESSION['UID'],
    'lang' => array(
        'loadingdotdotdot' => gettext("Loading..."),
        'imageresized' => gettext("This image has been resized (original size %dx%d). To view the full-size image click here."),
        'deleteattachmentconfirmation' => gettext("Are you sure you want to delete the selected attachments?"),
        'deletemessagesconfirmation' => gettext("Are you sure you want to delete all of the selected messages?"),
        'unquote' => gettext("Unquote"),
        'quote' => gettext("Quote"),
        'searchsuccessfullycompleted' => gettext("Search successfully completed."),
        'confirmmarkasread' => gettext("Are you sure you want to mark the selected threads as read?"),
        'waitdotdotdot' => gettext("Wait..."),
        'more' => gettext("More"),
        'pollquestion' => gettext("Poll Question"),
        'deletequestion' => gettext("Delete question"),
        'allowmultipleoptions' => gettext("Allow multiple options to be selected"),
        'addnewoption' => gettext("Add new option"),
        'deleteoption' => gettext("Delete option"),
        'code' => gettext('Code'),
        'retry' => gettext('Retry'),
        'cancel' => gettext('Cancel'),
        'delete' => gettext('Delete'),
        'upload' => gettext('Upload'),
        'preferencesnotsaved' => gettext('Your preferences have not been saved'),
    ),
    'font_size' => $font_size,
    'user_style' => $user_style,
    'emoticons' => $user_emoticons,
    'top_frame' => html_get_top_page(),
    'left_frame_width' => max(100, $left_frame_width),
    'forum_path' => server_get_forum_path(),
    'use_mover_spoiler' => (isset($_SESSION['USE_MOVER_SPOILER']) && $_SESSION['USE_MOVER_SPOILER'] == 'Y') ? 'Y' : 'N',
    'show_share_links' => (isset($_SESSION['SHOW_SHARE_LINKS']) && $_SESSION['SHOW_SHARE_LINKS'] == 'Y') ? 'Y' : 'N',
    'auto_scroll_messages' => (isset($_SESSION['AUTO_SCROLL_MESSAGES']) && $_SESSION['AUTO_SCROLL_MESSAGES'] == 'Y') ? 'Y' : 'N',
    'attachment_size_limit' => $attachment_size_limit,
    'frames' => array(
        'index' => html_get_frame_name('index'),
        'admin' => html_get_frame_name('admin'),
        'start' => html_get_frame_name('start'),
        'discussion' => html_get_frame_name('discussion'),
        'user' => html_get_frame_name('user'),
        'pm' => html_get_frame_name('pm'),
        'main' => html_get_frame_name('main'),
        'ftop' => html_get_frame_name('ftop'),
        'fnav' => html_get_frame_name('fnav'),
        'left' => html_get_frame_name('left'),
        'right' => html_get_frame_name('right'),
        'pm_folders' => html_get_frame_name('pm_folders'),
        'pm_messages' => html_get_frame_name('pm_messages')
    )
);

// Decide on the correct Content-Type and encoding
// of the content. This allows Beehive to reload the
// JSON data via the same script, either for use
// in a <script> tag or via AJAX.
if (isset($_GET['json'])) {

    $content_type = 'application/json';

    $content = json_encode($json_data);

} else {

    $content_type = 'text/javascript';

    $content = sprintf('top.window.beehive = $.extend({}, top.window.beehive, %s);
                        $(document).ready(function() {
                          $(top.window.beehive).trigger("init");
                        });', json_encode($json_data));
}

// Send correct Content-Type header
header(sprintf('Content-type: %s; charset=UTF-8', $content_type), true);

// Check the cache of the file.
cache_check_last_modified(time(), md5($_SESSION['UID'] . $_SESSION['LOGON'] . $content));

// Output the content
echo $content;