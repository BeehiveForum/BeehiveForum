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
require_once BH_INCLUDE_PATH . 'adsense.inc.php';
require_once BH_INCLUDE_PATH . 'browser.inc.php';
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'emoticons.inc.php';
require_once BH_INCLUDE_PATH . 'fixhtml.inc.php';
require_once BH_INCLUDE_PATH . 'folder.inc.php';
require_once BH_INCLUDE_PATH . 'form.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'header.inc.php';
require_once BH_INCLUDE_PATH . 'messages.inc.php';
require_once BH_INCLUDE_PATH . 'server.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
require_once BH_INCLUDE_PATH . 'styles.inc.php';
require_once BH_INCLUDE_PATH . 'thread.inc.php';
require_once BH_INCLUDE_PATH . 'user.inc.php';
require_once BH_INCLUDE_PATH . 'word_filter.inc.php';
// End Required includes

function html_guest_error()
{
    $frame_top_target = html_get_top_frame_name();

    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    $final_uri = sprintf("logon.php?webtag=%s&final_uri=%s", $webtag, rawurlencode(get_request_uri(true, false)));

    $available_popup_files_preg = implode("|^", array_map('preg_quote_callback', get_available_popup_files()));

    $available_support_pages_preg = implode("|^", array_map('preg_quote_callback', get_available_support_files()));

    if (preg_match("/^$available_popup_files_preg/", $final_uri) > 0) {

        html_draw_error(gettext("Sorry, you need to be logged in to use this feature."), null, 'post', array('close_popup' => gettext("Close")));

    } else if (preg_match("/^$available_support_pages_preg/", $final_uri) > 0) {

        html_draw_error(gettext("Sorry, you need to be logged in to use this feature."));

    } else {

        html_draw_error(gettext("Sorry, you need to be logged in to use this feature."), html_get_forum_file_path('logout.php'), 'post', array('submit' => gettext("Login now"), 'register' => gettext("Register")), array('final_uri' => $final_uri), $frame_top_target);
    }
}

function html_display_msg($header_text, $string_msg, $href = null, $method = 'get', array $buttons = array(), array $vars = array(), $target = "_self", $align = "left", $id = null)
{
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    if (!is_string($header_text)) return;
    if (!is_string($string_msg)) return;

    $available_methods = array(
        'get',
        'post'
    );

    if (!in_array($method, $available_methods)) $method = 'get';

    $available_alignments = array(
        'left',
        'center',
        'right'
    );

    if (!in_array($align, $available_alignments)) $align = 'left';

    echo "<h1>$header_text</h1>\n";
    echo "<br />\n";

    if (is_string($href) && strlen(trim($href)) > 0) {

        echo "<form accept-charset=\"utf-8\" action=\"$href\" method=\"$method\" target=\"$target\">\n";

        if ($method == 'post') {
            echo "  ", form_csrf_token_field(), "\n";
        }

        echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";

        if (is_array($vars)) {

            echo "  ", form_input_hidden_array($vars), "\n";
        }
    }

    echo "  <div align=\"$align\"", ($id ? " id=\"$id\"" : ""), ">\n";
    echo "    <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\" class=\"message_box\">\n";
    echo "      <tr>\n";
    echo "        <td align=\"left\">\n";
    echo "          <table class=\"box\" width=\"100%\">\n";
    echo "            <tr>\n";
    echo "              <td align=\"left\" class=\"posthead\">\n";
    echo "                <table class=\"posthead\" width=\"100%\">\n";
    echo "                  <tr>\n";
    echo "                    <td align=\"left\" class=\"subhead\">$header_text</td>\n";
    echo "                  </tr>\n";
    echo "                  <tr>\n";
    echo "                    <td align=\"center\">\n";
    echo "                      <table class=\"posthead\" width=\"95%\">\n";
    echo "                        <tr>\n";
    echo "                          <td align=\"left\">$string_msg</td>\n";
    echo "                        </tr>\n";
    echo "                      </table>\n";
    echo "                    </td>\n";
    echo "                  </tr>\n";
    echo "                  <tr>\n";
    echo "                    <td align=\"left\">&nbsp;</td>\n";
    echo "                  </tr>\n";
    echo "                </table>\n";
    echo "              </td>\n";
    echo "            </tr>\n";
    echo "          </table>\n";
    echo "        </td>\n";
    echo "      </tr>\n";
    echo "      <tr>\n";
    echo "        <td align=\"left\">&nbsp;</td>\n";
    echo "      </tr>\n";

    if (is_string($href) && strlen(trim($href)) > 0) {

        $button_html_array = array();

        if (is_array($buttons) && sizeof($buttons) > 0) {

            foreach ($buttons as $button_name => $button_label) {
                $button_html_array[] = form_submit(htmlentities_array($button_name), htmlentities_array($button_label));
            }
        }

        if (sizeof($button_html_array) > 0) {

            echo "      <tr>\n";
            echo "        <td align=\"center\">", implode("&nbsp;", $button_html_array), "</td>\n";
            echo "      </tr>\n";
        }
    }

    echo "    </table>\n";
    echo "  </div>\n";

    if (is_string($href) && strlen(trim($href)) > 0) {
        echo "</form>\n";
    }
}

function html_display_error_array(array $error_list, $width = '600', $align = 'center', $id = null)
{
    if (!preg_match('/^[0-9]+%?$/u', $width)) $width = '600';

    $error_list = array_filter($error_list, 'is_string');

    if (sizeof($error_list) == 0) return;

    if (sizeof($error_list) == 1) {

        html_display_error_msg(array_shift($error_list), $width, $align, $id);
        return;
    }

    $available_alignments = array(
        'left',
        'center',
        'right'
    );

    if (!in_array($align, $available_alignments)) $align = 'left';

    echo "<div align=\"$align\"", ($id ? " id=\"$id\"" : ""), ">\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"$width\" class=\"error_msg\">\n";
    echo "    <tr>\n";
    echo "      <td rowspan=\"2\" valign=\"top\" width=\"25\" class=\"error_msg_icon\">", html_style_image('error', gettext("Error")), "</td>\n";
    echo "      <td class=\"error_msg_text\">", gettext("The following errors were encountered:"), "</td>\n";
    echo "    </tr>\n";
    echo "    <tr>\n";
    echo "      <td>\n";
    echo "        <ul>\n";
    echo "          <li>", implode("</li>\n        <li>", $error_list), "</li>\n";
    echo "        </ul>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</div>\n";
}

function html_display_success_msg($message, $width = '600', $align = 'center', $id = null)
{
    if (!preg_match('/^[0-9]+%?$/u', $width)) $width = '600';

    if (!is_string($message)) return;

    $available_alignments = array(
        'left',
        'center',
        'right'
    );

    if (!in_array($align, $available_alignments)) $align = 'left';

    echo "<div align=\"$align\"", ($id ? " id=\"$id\"" : ""), ">\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"$width\" class=\"success_msg\">\n";
    echo "    <tr>\n";
    echo "      <td valign=\"top\" width=\"25\" class=\"success_msg_icon\">", html_style_image('success', gettext("Success")), "</td>\n";
    echo "      <td valign=\"top\" class=\"success_msg_text\">$message</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</div>\n";
}

function html_display_error_msg($message, $width = '600', $align = 'center', $id = null)
{
    if (!preg_match('/^[0-9]+%?$/u', $width)) $width = '600';

    if (!is_string($message)) return;

    $available_alignments = array(
        'left',
        'center',
        'right'
    );

    if (!in_array($align, $available_alignments)) $align = 'left';

    echo "<div align=\"$align\"", ($id ? " id=\"$id\"" : ""), ">\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"$width\" class=\"error_msg\">\n";
    echo "    <tr>\n";
    echo "      <td valign=\"top\" width=\"25\" class=\"error_msg_icon\">", html_style_image('error', gettext("Error")), "</td>\n";
    echo "      <td valign=\"top\" class=\"error_msg_text\">$message</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</div>\n";
}

function html_display_warning_msg($message, $width = '600', $align = 'center', $id = null)
{
    if (!preg_match('/^[0-9]+%?$/u', $width)) $width = '600';

    if (!is_string($message)) return;

    $available_alignments = array(
        'left',
        'center',
        'right'
    );

    if (!in_array($align, $available_alignments)) $align = 'left';

    echo "<div align=\"$align\"", ($id ? " id=\"$id\"" : ""), ">\n";
    echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"$width\" class=\"warning_msg\">\n";
    echo "    <tr>\n";
    echo "      <td valign=\"top\" width=\"25\" class=\"warning_msg_icon\">", html_style_image('warning', gettext("Warning")), "</td>\n";
    echo "      <td valign=\"top\" class=\"warning_msg_text\">$message</td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</div>\n";
}

function html_user_banned()
{
    header_status(500, 'Internal Server Error');
    exit;
}

function html_user_require_approval()
{
    html_draw_error(gettext("Your user account needs to be approved by a forum admin before you can access the requested forum."));
}

function html_email_confirmation_error()
{
    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return;

    $user_array = user_get($_SESSION['UID']);

    html_draw_error(gettext("Email confirmation is required before you can post. If you have not received a confirmation email please click the button below and a new one will be sent to you. If your email address needs changing please do so before requesting a new confirmation email. You may change your email address by click My Controls above and then User Details"), 'confirm_email.php', 'get', array('resend' => gettext("Resend Confirmation")), array('uid' => $user_array['UID'],
        'resend' => 'Y'
    ));
}

function html_message_type_error()
{
    html_draw_error(gettext("You cannot post this thread type as there are no available folders that allow it."));
}

function html_get_user_style_path()
{
    static $user_style = false;

    if ($user_style === false) {

        if (isset($_SESSION['STYLE']) && strlen(trim($_SESSION['STYLE'])) > 0) {
            $user_style = $_SESSION['STYLE'];
        } else {
            $user_style = forum_get_setting('default_style', 'strlen', 'default');
        }

        if (!style_exists($user_style)) {
            $user_style = forum_get_setting('default_style', 'strlen', 'default');
        }
    }

    return $user_style;
}

function html_get_style_file($filename, $allow_cdn = true)
{
    if (!($user_style = html_get_user_style_path())) $user_style = 'default';
    return html_get_forum_file_path(sprintf('styles/%s/%s', basename($user_style), $filename), $allow_cdn);
}

function html_get_top_page($allow_cdn = true)
{
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    if (!($user_style = html_get_user_style_path())) $user_style = 'default';

    return html_get_forum_file_path(sprintf("styles/%s/top.php?webtag=$webtag", basename($user_style)), $allow_cdn);
}

function html_get_emoticon_style_sheet($emoticon_set = false, $allow_cdn = true)
{
    if (($emoticon_set) && emoticons_set_exists($emoticon_set)) {

        $user_emoticon_pack = basename($emoticon_set);

    } else if (isset($_SESSION['EMOTICONS']) && strlen(trim($_SESSION['EMOTICONS'])) > 0) {

        $user_emoticon_pack = $_SESSION['EMOTICONS'];

    } else {

        $user_emoticon_pack = forum_get_setting('default_emoticons', 'strlen', 'default');
    }

    if (emoticons_set_exists($user_emoticon_pack)) {
        return html_get_forum_file_path(sprintf('emoticons/%s/style.css', basename($user_emoticon_pack)), $allow_cdn);
    }

    return false;
}

function html_get_forum_keywords()
{
    return forum_get_setting('forum_keywords', null, '');
}

function html_get_forum_description()
{
    return forum_get_setting('forum_desc', null, '');
}

function html_get_forum_content_rating()
{
    $content_ratings_array = array(
        FORUM_RATING_GENERAL => 'General',
        FORUM_RATING_FOURTEEN => '14 Years',
        FORUM_RATING_MATURE => 'Mature',
        FORUM_RATING_RESTRICTED => 'Restricted',
    );

    if (!($forum_content_rating = forum_get_setting('forum_content_rating'))) {
        return $content_ratings_array[FORUM_RATING_GENERAL];
    }

    if (!isset($content_ratings_array[$forum_content_rating])) {
        return $content_ratings_array[FORUM_RATING_GENERAL];
    }

    return $content_ratings_array[$forum_content_rating];
}

function html_get_forum_email()
{
    return forum_get_setting('forum_email', null, '');
}

function html_get_frame_name($basename)
{
    $forum_uri = html_get_forum_uri();

    $webtag = get_webtag();

    if (forum_check_webtag_available($webtag)) {

        $frame_md5_hash = md5(sprintf('%s-%s-%s', $forum_uri, $webtag, $basename));
        return sprintf('bh_frame_%s', preg_replace('/[^a-z]+/iu', '', $frame_md5_hash));
    }

    $frame_md5_hash = md5(sprintf('%s-%s', $forum_uri, $basename));
    return sprintf('bh_frame_%s', preg_replace('/[^a-z]+/iu', '', $frame_md5_hash));
}

function html_get_top_frame_name()
{
    $config = server_get_config();

    if (!isset($config['frame_top_target']) || strlen(trim($config['frame_top_target'])) == 0) {
        return '_top';
    }

    return $config['frame_top_target'];
}

function html_include_javascript($script_filepath, $id = null)
{
    $path_parts = path_info_query($script_filepath);

    if (!array_keys_exist($path_parts, 'basename', 'filename', 'extension', 'dirname')) return null;

    if (!isset($path_parts['query'])) $path_parts['query'] = null;

    if (forum_get_setting('use_minified_scripts', 'Y')) {
        $path_parts['basename'] = sprintf('%s.min.%s', $path_parts['filename'], $path_parts['extension']);
    }

    $path_parts['query'] = html_query_string_add($path_parts['query'], 'version', BEEHIVE_VERSION, '&amp;');

    $script_filepath = rtrim($path_parts['dirname'], '/') . '/' . $path_parts['basename'] . '?' . $path_parts['query'];

    return sprintf(
        "<script type=\"text/javascript\" src=\"%s\"%s></script>\n",
        htmlentities_array($script_filepath),
        isset($id) ? sprintf(" id=\"%s\"", htmlentities_array($id)) : ''
    );
}

function html_include_css($script_filepath, $media = 'screen', $id = null)
{
    $path_parts = path_info_query($script_filepath);

    if (!array_keys_exist($path_parts, 'basename', 'filename', 'extension', 'dirname')) return null;

    if (!isset($path_parts['query'])) $path_parts['query'] = null;

    if (forum_get_setting('use_minified_scripts', 'Y')) {
        $path_parts['basename'] = sprintf('%s.min.%s', $path_parts['filename'], $path_parts['extension']);
    }

    $path_parts['query'] = html_query_string_add($path_parts['query'], 'version', BEEHIVE_VERSION, '&amp;');

    $script_filepath = rtrim($path_parts['dirname'], '/') . '/' . $path_parts['basename'] . '?' . $path_parts['query'];

    return sprintf(
        "<link rel=\"stylesheet\" href=\"%s\" type=\"text/css\" media=\"%s\"%s />\n",
        htmlentities_array($script_filepath),
        htmlentities_array($media),
        isset($id) ? sprintf(" id=\"%s\"", htmlentities_array($id)) : ''
    );
}

function html_draw_top(array $options = array())
{
    $title = null;

    $class = null;

    $base_target = null;

    $robots = null;

    $main_css = null;

    $images_css = null;

    $inline_css = null;

    $emoticons = null;

    $frame_set_html = false;

    $pm_popup_disabled = false;

    $js = array();

    $css = array();

    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    $forum_name = forum_get_setting('forum_name', null, 'A Beehive Forum');

    foreach ($options as $key => $value) {

        switch ($key) {

            case 'title':
            case 'class':
            case 'base_target':
            case 'robots':
            case 'main_css':
            case 'images_css':
            case 'inline_css':
            case 'emoticons':

                $$key = (!isset($$key) && isset($value) ? $value : $$key);
                break;

            case 'frame_set_html':
            case 'pm_popup_disabled':

                $$key = is_bool($value) ? $value : $$key;
                break;

            case 'js':
            case 'css':

                if (!is_array($value) || count(array_filter($value, 'is_string')) <> count($value)) {

                    throw new InvalidArgumentException(
                        sprintf(
                            'Expecting html_draw_top argument %s to be an array of strings',
                            $key
                        )
                    );
                }

                $$key = $value;
                break;

            default:

                throw new InvalidArgumentException(
                    sprintf(
                        'Unknown html_draw_top argument "%s"',
                        $key
                    )
                );

                break;
        }
    }

    if (!isset($main_css)) {
        $main_css = 'style.css';
    }

    if (!isset($images_css)) {
        $images_css = 'images.css';
    }

    if ($frame_set_html === false) {

        echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
        echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";

    } else {

        echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Frameset//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd\">\n";
    }

    echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"", gettext('en-gb'), "\" lang=\"", gettext('en-gb'), "\" dir=\"", gettext('ltr'), "\">\n";
    echo "<head>\n";
    echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />\n";

    // Default Meta keywords and description.
    $meta_keywords = html_get_forum_keywords();
    $meta_description = html_get_forum_description();

    if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

        list($tid, $pid) = explode('.', $_GET['msg']);

        message_get_meta_content($_GET['msg'], $meta_keywords, $meta_description);

        if (isset($_SESSION['POSTS_PER_PAGE']) && is_numeric($_SESSION['POSTS_PER_PAGE'])) {
            $posts_per_page = max(min($_SESSION['POSTS_PER_PAGE'], 30), 10);
        } else {
            $posts_per_page = 20;
        }

        if (($thread_data = thread_get($tid)) !== false) {

            echo "<title>", word_filter_add_ob_tags($thread_data['TITLE'], true), " - ", word_filter_add_ob_tags($forum_name, true), "</title>\n";
            echo "<link rel=\"canonical\" href=\"", html_get_forum_uri("index.php?webtag=$webtag&amp;msg=$tid.1"), "\" />\n";

            if ($thread_data['LENGTH'] > $posts_per_page) {

                $prev_page = ($pid - $posts_per_page > 0) ? $pid - $posts_per_page : 1;
                $next_page = ($pid + $posts_per_page < $thread_data['LENGTH']) ? $pid + $posts_per_page : $thread_data['LENGTH'];
                $last_page = (floor($thread_data['LENGTH'] / $posts_per_page) * $posts_per_page) + 1;

                echo "<link rel=\"first\" href=\"", html_get_forum_uri("index.php?webtag=$webtag&amp;msg=$tid.1"), "\" />\n";
                echo "<link rel=\"last\" href=\"", html_get_forum_uri("index.php?webtag=$webtag&amp;msg=$tid.$last_page"), "\" />\n";

                if (($pid + $posts_per_page) < $thread_data['LENGTH']) {
                    echo "<link rel=\"next\" href=\"", html_get_forum_uri("index.php?webtag=$webtag&amp;msg=$tid.$next_page"), "\" />\n";
                }

                if ($pid > 1) {
                    echo "<link rel=\"prev\" href=\"", html_get_forum_uri("index.php?webtag=$webtag&amp;msg=$tid.$prev_page"), "\" />\n";
                }
            }

        } else if (isset($title)) {

            echo "<title>", word_filter_add_ob_tags($title, true), " - ", word_filter_add_ob_tags($forum_name, true), "</title>\n";

        } else {

            echo "<title>", word_filter_add_ob_tags($forum_name, true), "</title>\n";
        }

    } else if (isset($title)) {

        echo "<title>", word_filter_add_ob_tags($title, true), " - ", htmlentities_array($forum_name), "</title>\n";

    } else {

        echo "<title>", htmlentities_array($forum_name), "</title>\n";
    }

    $forum_content_rating = html_get_forum_content_rating();

    echo "<meta name=\"generator\" content=\"Beehive Forum ", BEEHIVE_VERSION, "\" />\n";
    echo "<meta name=\"keywords\" content=\"", word_filter_add_ob_tags($meta_keywords, true), "\" />\n";
    echo "<meta name=\"description\" content=\"", word_filter_add_ob_tags($meta_description, true), "\" />\n";
    echo "<meta name=\"rating\" content=\"$forum_content_rating\" />\n";

    if (forum_get_setting('allow_search_spidering', 'N') || (isset($pid) && $pid > 1)) {

        echo "<meta name=\"robots\" content=\"noindex,nofollow\" />\n";

    } else if (isset($robots)) {

        echo "<meta name=\"robots\" content=\"", htmlentities_array($robots), "\" />\n";
    }

    printf("<meta name=\"application-name\" content=\"%s\" />\n", htmlentities_array(word_filter_add_ob_tags($forum_name, true)));
    printf("<meta name=\"msapplication-tooltip\" content=\"%s\" />\n", htmlentities_array(word_filter_add_ob_tags($meta_description, true)));

    if (forum_check_webtag_available($webtag)) {

        printf("<meta name=\"msapplication-task\" content=\"name=%s;action-uri=%s;icon-uri=%s\" />\n", gettext('Messages'), htmlentities_array(html_get_forum_file_path("index.php?webtag=$webtag&final_uri=discussion.php%3Fwebtag%3D$webtag")), html_get_style_file('images/msie/unread_thread.ico', true, true));

        if (forum_get_setting('show_links', 'Y')) {
            printf("<meta name=\"msapplication-task\" content=\"name=%s;action-uri=%s;icon-uri=%s\" />\n", gettext('Links'), htmlentities_array(html_get_forum_file_path("index.php?webtag=$webtag&final_uri=links.php%3Fwebtag%3D$webtag")), html_get_style_file('images/msie/link.ico', true, true));
        }
    }

    if (forum_get_setting('show_pms', 'Y')) {
        printf("<meta name=\"msapplication-task\" content=\"name=%s;action-uri=%s;icon-uri=%s\" />\n", gettext('Inbox'), htmlentities_array(html_get_forum_file_path("index.php?webtag=$webtag&final_uri=pm.php%3Fwebtag%3D$webtag")), html_get_style_file('images/msie/pm_unread.ico', true, true));
    }

    if (forum_check_webtag_available($webtag)) {
        printf("<meta name=\"msapplication-task\" content=\"name=%s;action-uri=%s;icon-uri=%s\" />\n", gettext('My Controls'), htmlentities_array(html_get_forum_file_path("index.php?webtag=$webtag&final_uri=user.php%3Fwebtag%3D$webtag")), html_get_style_file('images/msie/user_controls.ico', true, true));
    }

    if (session::logged_in() && (session::check_perm(USER_PERM_FORUM_TOOLS, 0) || session::check_perm(USER_PERM_ADMIN_TOOLS, 0) || session::get_folders_by_perm(USER_PERM_FOLDER_MODERATE))) {
        printf("<meta name=\"msapplication-task\" content=\"name=%s;action-uri=%s;icon-uri=%s\" />\n", gettext('Admin'), htmlentities_array(html_get_forum_file_path("index.php?webtag=$webtag&final_uri=admin.php%3Fwebtag%3D$webtag")), html_get_style_file('images/msie/admin_tool.ico', true, true));
    }

    printf("<meta name=\"msapplication-starturl\" content=\"%s\" />\n", htmlentities_array(html_get_forum_file_path("index.php?webtag=$webtag")));

    $rss_feed_path = html_get_forum_file_path("threads_rss.php?webtag=$webtag");

    printf("<link rel=\"alternate\" type=\"application/rss+xml\" title=\"%s - %s\" href=\"%s\" />\n", htmlentities_array($forum_name), htmlentities_array(gettext('RSS Feed')), htmlentities_array($rss_feed_path));

    if (($folders_array = folder_get_available_details()) !== false) {

        foreach ($folders_array as $folder) {

            $rss_feed_path = html_get_forum_file_path("threads_rss.php?webtag=$webtag&amp;fid={$folder['FID']}");
            printf("<link rel=\"alternate\" type=\"application/rss+xml\" title=\"%s - %s - %s\" href=\"%s\" />\n", htmlentities_array($forum_name), htmlentities_array($folder['TITLE']), htmlentities_array(gettext('RSS Feed')), htmlentities_array($rss_feed_path));
        }
    }

    if (($user_style_path = html_get_user_style_path()) !== false) {

        printf("<link rel=\"apple-touch-icon\" href=\"%s\" />\n", htmlentities_array(html_get_forum_file_path(sprintf('styles/%s/images/apple-touch-icon-57x57.png', $user_style_path))));
        printf("<link rel=\"apple-touch-icon\" sizes=\"72x72\" href=\"%s\" />\n", htmlentities_array(html_get_forum_file_path(sprintf('styles/%s/images/apple-touch-icon-72x72.png', $user_style_path))));
        printf("<link rel=\"apple-touch-icon\" sizes=\"114x114\" href=\"%s\" />\n", htmlentities_array(html_get_forum_file_path(sprintf('styles/%s/images/apple-touch-icon-114x114.png', $user_style_path))));
        printf("<link rel=\"apple-touch-icon\" sizes=\"144x144\" href=\"%s\" />\n", htmlentities_array(html_get_forum_file_path(sprintf('styles/%s/images/apple-touch-icon-144x144.png', $user_style_path))));

        printf("<link rel=\"shortcut icon\" type=\"image/ico\" href=\"%s\" />\n", htmlentities_array(html_get_forum_file_path(sprintf('styles/%s/images/favicon.ico', $user_style_path))));
    }

    $opensearch_path = html_get_forum_uri(sprintf('search.php?webtag=%s&opensearch', $webtag));

    printf("<link rel=\"search\" type=\"application/opensearchdescription+xml\" title=\"%s\" href=\"%s\" />\n", htmlentities_array($forum_name), htmlentities_array($opensearch_path));

    if (($style_sheet = html_get_style_file($main_css)) !== false) {
        echo html_include_css($style_sheet);
    }

    if (($emoticon_style_sheet = html_get_emoticon_style_sheet($emoticons)) !== false) {
        echo html_include_css($emoticon_style_sheet, 'print, screen');
    }

    if (($images_style_sheet = html_get_style_file($images_css)) !== false) {
        echo html_include_css($images_style_sheet);
    }

    if (isset($inline_css)) {

        echo "<style type=\"text/css\">\n";
        echo "<!--\n\n", $inline_css, "\n\n//-->\n";
        echo "</style>\n";
    }

    // Font size (not for Guests)
    if (session::logged_in()) {
        echo html_include_css(html_get_forum_file_path(sprintf('font_size.php?webtag=%s', $webtag)), 'screen', 'user_font');
    }

    if ($base_target) echo "<base target=\"", htmlentities_array($base_target), "\" />\n";

    echo html_include_javascript(html_get_forum_file_path('js/jquery.min.js'));
    echo html_include_javascript(html_get_forum_file_path('js/jquery.placeholder.min.js'));
    echo html_include_javascript(html_get_forum_file_path('js/jquery.ui.autocomplete.min.js'));
    echo html_include_javascript(html_get_forum_file_path('js/jquery.parsequery.min.js'));
    echo html_include_javascript(html_get_forum_file_path('js/jquery.sprintf.min.js'));
    echo html_include_javascript(html_get_forum_file_path('js/jquery.url.min.js'));
    echo html_include_javascript(html_get_forum_file_path('js/general.js'));

    if ($frame_set_html === false) {

        // Check for any new PMs.
        if (session::logged_in()) {

            // Check to see if the PM popup is disabled on the current page.
            if ($pm_popup_disabled === false) {

                // Pages we don't want the popup to appear on
                $pm_popup_disabled_pages = get_pm_popup_disabled_files();

                // Check that we're not on one of the pages.
                if ((!in_array(basename($_SERVER['PHP_SELF']), $pm_popup_disabled_pages))) {
                    echo html_include_javascript(html_get_forum_file_path('js/pm.js'));
                }
            }

            // Overflow auto-resize functionality.
            $resize_images_page = get_image_resize_files();

            if (in_array(basename($_SERVER['PHP_SELF']), $resize_images_page)) {

                if (isset($_SESSION['USE_OVERFLOW_RESIZE']) && ($_SESSION['USE_OVERFLOW_RESIZE'] == 'Y')) {
                    echo html_include_javascript(html_get_forum_file_path('js/overflow.js'));
                }
            }

            // Mouseover spoiler pages
            $message_display_pages = get_message_display_files();

            if (in_array(basename($_SERVER['PHP_SELF']), $message_display_pages)) {
                echo html_include_javascript(html_get_forum_file_path('js/spoiler.js'));
            }
        }

        // Stats Display pages
        $stats_display_pages = array(
            'messages.php'
        );

        if (in_array(basename($_SERVER['PHP_SELF']), $stats_display_pages)) {
            echo html_include_javascript(html_get_forum_file_path('js/stats.js'));
        }
    }

    foreach ($css as $css_file) {
        echo html_include_css(html_get_forum_file_path($css_file));
    }

    foreach ($js as $js_file) {
        echo html_include_javascript(html_get_forum_file_path($js_file));
    }

    echo html_include_javascript(html_get_forum_file_path("json.php?webtag=$webtag"));

    if (($frame_set_html === true) && $google_analytics_code = html_get_google_analytics_code()) {

        echo "<script type=\"text/javascript\">\n\n";
        echo "  var _gaq = _gaq || [];\n";
        echo "  _gaq.push(['_setAccount', '$google_analytics_code']);\n";
        echo "  _gaq.push(['_trackPageview']);\n\n";
        echo "  (function() {\n";
        echo "    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;\n";
        echo "    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';\n";
        echo "    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);\n";
        echo "  })();\n\n";
        echo "</script>\n";
    }

    echo "</head>\n\n";

    if ($frame_set_html === false) {

        $classes = array(basename($_SERVER['PHP_SELF'], '.php'));

        if ($class) {
            $classes[] = $class;
        }

        printf(
            "<body class=\"%s\">\n",
            implode(' ', htmlentities_array($classes))
        );

        if (html_output_adsense_settings() && adsense_check_user() && adsense_check_page()) {

            adsense_output_html();
            echo "<br />\n";
        }

        echo '<div id="fb-root"></div>';
    }
}

function html_draw_bottom($frame_set_html = false)
{
    if (!is_bool($frame_set_html)) $frame_set_html = false;

    if ($frame_set_html === false) {

        if (($page_footer = html_get_page_footer()) !== false) {
            echo fix_html($page_footer);
        }

        if (adsense_publisher_id() && adsense_check_user() && adsense_check_page_bottom()) {
            echo '<br>';
            adsense_output_html();
        }

        if (($google_analytics_code = html_get_google_analytics_code()) !== false) {

            echo "<script type=\"text/javascript\">\n\n";
            echo "  var _gaq = _gaq || [];\n";
            echo "  _gaq.push(['_setAccount', '$google_analytics_code']);\n";
            echo "  _gaq.push(['_trackPageview']);\n\n";
            echo "  (function() {\n";
            echo "    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;\n";
            echo "    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';\n";
            echo "    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);\n";
            echo "  })();\n\n";
            echo "</script>\n";
        }

        echo "</body>\n";
    }

    echo "</html>\n";
}

function html_draw_error($message, $href = null, $method = 'get', array $buttons = array(), array $vars = array(), $target = "_self", $align = "left", $id = null)
{
    html_draw_top(
        array(
            'title' => gettext('Error')
        )
    );
    html_display_msg(gettext("Error"), $message, $href, $method, $buttons, $vars, $target, $align, $id);
    html_draw_bottom();
    exit;
}

class html_frameset
{
    protected $id;
    protected $framespacing = 0;
    protected $frameborder = 0;
    protected $allowtransparency = '';
    private $frames_array = array();

    public function html_frame($src, $name, $frameborder = 0, $scrolling = '', $noresize = '')
    {
        array_push($this->frames_array, new html_frame($src, $name, $frameborder, $scrolling, $noresize));
    }

    public function get_frames()
    {
        return $this->frames_array;
    }
}

class html_frameset_rows extends html_frameset
{
    private $rows = '';

    public function __construct($id, $rows, $framespacing = 0, $frameborder = 0)
    {
        $this->id = $id;

        if (preg_match('/^[0-9,\*%]+$/D', $rows)) {
            $this->rows = $rows;
        }

        if (is_numeric($framespacing)) {
            $this->framespacing = $framespacing;
        } else {
            $this->framespacing = 0;
        }

        if (is_numeric($frameborder)) {
            $this->frameborder = $frameborder;
        } else {
            $this->frameborder = 0;
        }

        if (browser_check(BROWSER_MSIE)) {
            $this->allowtransparency = ' allowtransparency="true"';
        }
    }

    public function output_html($close_frameset = true)
    {
        printf(
            "<frameset id=\"%s\" rows=\"%s\" framespacing=\"%s\" border=\"%s\"%s>\n",
            htmlentities_array($this->id),
            htmlentities_array($this->rows),
            $this->framespacing,
            $this->frameborder,
            $this->allowtransparency
        );

        /** @var html_frame[] $frames_array */
        $frames_array = parent::get_frames();

        foreach ($frames_array as $frame) {
            $frame->output_html();
        }

        if ($close_frameset) echo "</frameset>\n";
    }
}

class html_frameset_cols extends html_frameset
{
    private $cols = '';

    public function __construct($id, $cols, $framespacing = 4, $frameborder = 4)
    {
        $this->id = $id;

        if (preg_match('/^[0-9,\*%]+$/D', $cols)) {
            $this->cols = $cols;
        }

        if (is_numeric($framespacing)) {
            $this->framespacing = $framespacing;
        } else {
            $this->framespacing = 4;
        }

        if (is_numeric($frameborder)) {
            $this->frameborder = $frameborder;
        } else {
            $this->frameborder = 4;
        }

        if (browser_check(BROWSER_MSIE)) {
            $this->allowtransparency = ' allowtransparency="true"';
        }
    }

    public function output_html($close_frameset = true)
    {
        printf(
            "<frameset id=\"%s\" cols=\"%s\" framespacing=\"%s\" border=\"%s\"%s>\n",
            htmlentities_array($this->id),
            htmlentities_array($this->cols),
            $this->framespacing,
            $this->frameborder,
            $this->allowtransparency
        );

        /** @var html_frame[] $frames_array */
        $frames_array = parent::get_frames();

        foreach ($frames_array as $frame) {
            $frame->output_html();
        }

        if ($close_frameset) echo "</frameset>\n";
    }
}

class html_frame
{
    private $src;
    private $name;
    private $frameborder;
    private $scrolling;
    private $noresize;
    private $allowtransparency = '';

    function html_frame($src, $name, $frameborder = 0, $scrolling = '', $noresize = '')
    {
        $this->src = $src;
        $this->name = $name;

        if (in_array($scrolling, array('yes', 'no'))) {
            $this->scrolling = sprintf(' scrolling="%s"', htmlentities_array($scrolling));
        }

        if (in_array($noresize, array('noresize'))) {
            $this->noresize = sprintf(' noresize="%s"', htmlentities_array($noresize));
        }

        if (browser_check(BROWSER_WEBKIT)) {
            $this->frameborder = 1;
        } else {
            $this->frameborder = (is_numeric($frameborder)) ? $frameborder : 0;
        }

        if (browser_check(BROWSER_MSIE)) {
            $this->allowtransparency = ' allowtransparency="true"';
        }
    }

    function output_html()
    {
        printf(
            "<frame src=\"%s\" name=\"%s\" frameborder=\"%s\" class=\"%s\"%s%s%s/>\n",
            htmlentities_array($this->src),
            htmlentities_array($this->name),
            htmlentities_array($this->frameborder),
            htmlentities_array(basename(parse_url($this->src, PHP_URL_PATH), '.php')),
            $this->scrolling,
            $this->noresize,
            $this->allowtransparency
        );
    }
}

function html_get_page_footer()
{
    if (($page_footer = forum_get_setting('forum_page_footer')) !== false) {
        return (strlen(trim($page_footer)) > 0) ? $page_footer : false;
    }

    return false;
}

function html_get_google_analytics_code()
{
    if (forum_get_global_setting('allow_forum_google_analytics', 'Y')) {

        if (forum_get_setting('enable_google_analytics', 'Y')) {

            if (($google_analytics_code = forum_get_setting('google_analytics_code')) !== false) {
                return (strlen(trim($google_analytics_code)) > 0) ? $google_analytics_code : false;
            }
        }

    } else {

        if (forum_get_global_setting('enable_google_analytics', 'Y')) {

            if (($google_analytics_code = forum_get_global_setting('google_analytics_code')) !== false) {
                return (strlen(trim($google_analytics_code)) > 0) ? $google_analytics_code : false;
            }
        }
    }

    return false;
}

function html_output_adsense_settings()
{
    // Check the required settings!
    if (($adsense_publisher_id = adsense_publisher_id()) !== false) {

        // Default banner size and type
        $ad_type = 'medium';
        $ad_width = 468;
        $ad_height = 60;

        // Get banner size and type
        adsense_get_banner_type($ad_type, $ad_width, $ad_height);

        // Get the slot id from the forum settings.
        $ad_slot_id = adsense_slot_id($ad_type);

        // Output the settings Javascript.
        echo "<script type=\"text/javascript\">\n";
        echo "<!--\n\n";
        echo "google_ad_client = \"$adsense_publisher_id\";\n";
        echo "google_ad_slot = \"$ad_slot_id\";\n";
        echo "google_ad_width = $ad_width\n";
        echo "google_ad_height = $ad_height\n\n";
        echo "//-->\n";
        echo "</script>\n";

        return true;
    }

    return false;
}

function html_js_safe_str($str)
{
    $unsafe_chars_tbl = array(
        '\\' => '\\\\',
        "'" => "\\'",
        '"' => '\\"',
        "\r" => '\\r',
        "\n" => '\\n',
        '<' => '\\074',
        '>' => '\\076',
        '&' => '\\046',
        '--' => '\\055\\055'
    );

    return strtr($str, $unsafe_chars_tbl);
}

function html_style_image($class, $title = null, $id = null, array $css = array())
{
    $classes = array('image', $class);

    $html = sprintf('<span class="%s"', implode(' ', $classes));

    if (count($css) > 0) {
        $html .= sprintf('style="%s"', implode_assoc($css, ':', ';'));
    }

    if (isset($title) && is_string($title)) {
        $html .= sprintf(' title="%s"', htmlentities_array($title));
    }

    if (isset($id) && is_string($id)) {
        $html .= sprintf(' id="%s"', htmlentities_array($id));
    }

    return $html . '></span>';
}

function html_set_cookie($name, $value, $expires = 0, $path = '/')
{
    $cookie_secure = (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on');
    return setcookie($name, $value, $expires, $path, '', $cookie_secure, true);
}

function html_get_cookie($cookie_name, $callback = null, $default = null)
{
    if (!isset($_COOKIE[$cookie_name])) return $default;

    if (function_exists($callback) && is_callable($callback)) {
        return $callback($_COOKIE[$cookie_name]);
    } else if (is_scalar($callback)) {
        return mb_strtoupper($_COOKIE[$cookie_name]) == mb_strtoupper($callback);
    }

    return $_COOKIE[$cookie_name];
}

function html_remove_all_cookies()
{
    if (isset($_SERVER['HTTP_COOKIE'])) {

        $cookies = array_map('trim', explode(';', $_SERVER['HTTP_COOKIE']));

        foreach ($cookies as $key => $cookie) {
            list($cookies[$key]) = explode('=', $cookie, 2);
        }

    } else {

        $cookies = array_keys($_COOKIE);
    }

    foreach ($cookies as $cookie) {

        html_set_cookie($cookie, '', time() - YEAR_IN_SECONDS);
        html_set_cookie($cookie, '', time() - YEAR_IN_SECONDS, '/');
    }
}

function href_cleanup_query_keys($uri, $remove_keys = null)
{
    $uri_array = parse_url($uri);

    if (isset($uri_array['query'])) {

        $uri_query_array = array();

        parse_str($uri_array['query'], $uri_query_array);

        if (is_array($remove_keys)) {
            $uri_query_array = array_diff_key($uri_query_array, $remove_keys);
        } else if (is_string($remove_keys)) {
            unset($uri_query_array[$remove_keys]);
        }

        $uri_array['query'] = http_build_query($uri_query_array, null, '&');
    }

    return build_url_str($uri_array);
}

function html_query_string_add($query_string, $key, $value, $arg_separator = '&')
{
    parse_str($query_string, $query_array);

    $query_array[$key] = $value;

    return http_build_query($query_array, null, $arg_separator);
}

function html_query_string_remove($query_string, $key, $value = null, $arg_separator = '&')
{
    parse_str($query_string, $query_array);

    if ((isset($query_array[$key]) && ($query_array[$key] == $value)) || $value = null) {
        unset($query_array[$key]);
    }

    return http_build_query($query_array, null, $arg_separator);
}

function html_page_links($uri, $page, $record_count, $rows_per_page, $page_var = "page")
{
    $uri = href_cleanup_query_keys($uri, $page_var);

    $page_count = ceil($record_count / $rows_per_page);

    $sep = strstr($uri, '?') ? "&amp;" : "?";

    if ($page < 1) $page = 1;

    if ($page > $page_count) $page = $page_count;

    if ($page_count > 1) {

        echo "<span class=\"pagenum_text\">", gettext("Pages"), "&nbsp;($page_count):&nbsp;";

    } else {

        echo "<span class=\"pagenum_text\">", gettext("Pages"), ":&nbsp;";
    }

    if ($page_count > 1) {

        if ($page == 1) {

            $end_page = (($page + 2) <= $page_count) ? ($page + 2) : $page_count;
            $start_page = $page;

        } else if ($page == $page_count) {

            $start_page = (($page - 2) > 0) ? ($page - 2) : 1;
            $end_page = $page_count;

        } else {

            $start_page = (($page - 2) > 0) ? ($page - 2) : 1;
            $end_page = (($page + 2) <= $page_count) ? ($page + 2) : $page_count;

            if (($end_page - $start_page) < 2) {

                if (($start_page - 2) < 1) {

                    $end_page = (($start_page + 2) <= $page_count) ? ($start_page + 2) : $page_count;

                } else if (($end_page + 1) > $page_count) {

                    $start_page = (($end_page - 4) > 0) ? ($end_page - 4) : 1;
                }
            }
        }

        if ($start_page > 1) {

            if (($start_page - 1) > 1) {
                echo "<a href=\"{$uri}{$sep}{$page_var}=1\" target=\"_self\">1</a>&nbsp;&hellip;&nbsp;";
            } else {
                echo "<a href=\"{$uri}{$sep}{$page_var}=1\" target=\"_self\">1</a>&nbsp;";
            }
        }

        for ($next_page = $start_page; $next_page <= $end_page; $next_page++) {

            if ($next_page == $page) {
                echo "<a href=\"{$uri}{$sep}{$page_var}={$next_page}\" target=\"_self\"><span class=\"pagenum_current\">$next_page</span></a>&nbsp;";
            } else {
                echo "<a href=\"{$uri}{$sep}{$page_var}={$next_page}\" target=\"_self\">{$next_page}</a>&nbsp;";
            }
        }

        if ($end_page < $page_count) {

            if (($end_page + 1) < $page_count) {
                echo "&hellip;&nbsp;<a href=\"{$uri}{$sep}{$page_var}={$page_count}\" target=\"_self\">{$page_count}</a>";
            } else {
                echo "<a href=\"{$uri}{$sep}{$page_var}={$page_count}\" target=\"_self\">{$page_count}</a>";
            }
        }

    } else {

        echo "<a href=\"{$uri}{$sep}{$page_var}=1\" target=\"_self\"><b>[1]</b></a>&nbsp;";
    }

    echo "</span>";
}

function html_get_forum_domain($return_array = false)
{
    $uri_array = @parse_url($_SERVER['PHP_SELF']);

    $uri_array['path'] = dirname($uri_array['path']);

    if (!isset($uri_array['scheme'])) {

        if (isset($_SERVER['HTTP_SCHEME']) && strlen(trim($_SERVER['HTTP_SCHEME'])) > 0) {

            $uri_array['scheme'] = $_SERVER['HTTP_SCHEME'];

        } else if (isset($_SERVER['HTTPS']) && strlen(trim($_SERVER['HTTPS'])) > 0) {

            $uri_array['scheme'] = (mb_strtolower($_SERVER['HTTPS']) != 'off') ? 'https' : 'http';

        } else {

            $uri_array['scheme'] = 'http';
        }
    }

    if (!isset($uri_array['host'])) {

        if (isset($_SERVER['HTTP_HOST']) && strlen(trim($_SERVER['HTTP_HOST'])) > 0) {

            if (mb_strpos($_SERVER['HTTP_HOST'], ':') > 0) {

                list($uri_array['host'], $uri_array['port']) = explode(':', $_SERVER['HTTP_HOST']);

            } else {

                $uri_array['host'] = $_SERVER['HTTP_HOST'];
            }

        } else if (isset($_SERVER['SERVER_NAME']) && strlen(trim($_SERVER['SERVER_NAME'])) > 0) {

            $uri_array['host'] = $_SERVER['SERVER_NAME'];
        }
    }

    if (!isset($uri_array['port'])) {

        if (isset($_SERVER['SERVER_PORT']) && strlen(trim($_SERVER['SERVER_PORT'])) > 0) {

            if ($_SERVER['SERVER_PORT'] != '80') {

                $uri_array['port'] = $_SERVER['SERVER_PORT'];
            }
        }
    }

    if ($return_array) return $uri_array;

    $server_uri = (isset($uri_array['scheme'])) ? "{$uri_array['scheme']}://" : '';
    $server_uri .= (isset($uri_array['host'])) ? "{$uri_array['host']}" : '';
    $server_uri .= (isset($uri_array['port'])) ? ":{$uri_array['port']}" : '';

    return $server_uri;
}

function html_get_forum_uri($append_path = null)
{
    $uri_array = html_get_forum_domain(true);

    if (!isset($uri_array['path'])) {

        if (isset($_SERVER['PATH_INFO']) && strlen(trim($_SERVER['PATH_INFO'])) > 0) {

            $path = @parse_url($_SERVER['PATH_INFO']);

        } else {

            $path = @parse_url($_SERVER['PHP_SELF']);
        }

        if (isset($path['path'])) {

            $uri_array['path'] = $path['path'];
        }
    }

    $uri_array['path'] = str_replace(DIRECTORY_SEPARATOR, '/', dirname(rtrim($uri_array['path'], '/') . '/a'));

    if (strlen(trim($append_path)) > 0) {
        $uri_array['path'] = rtrim($uri_array['path'], '/') . '/' . $append_path;
    }

    $server_uri = (isset($uri_array['scheme'])) ? "{$uri_array['scheme']}://" : '';
    $server_uri .= (isset($uri_array['host'])) ? "{$uri_array['host']}" : '';
    $server_uri .= (isset($uri_array['port'])) ? ":{$uri_array['port']}" : '';
    $server_uri .= (isset($uri_array['path'])) ? "{$uri_array['path']}" : '';

    return $server_uri;
}

function html_get_forum_file_path($file_path, $allow_cdn = true)
{
    // Cache of requested file paths.
    static $file_path_cache_array = array();

    // Check if the path is in the cache.
    if (!isset($file_path_cache_array[$file_path])) {

        // Get the BH_FORUM_PATH prefix.
        $forum_path = server_get_forum_path();

        // HTTP schema
        $http_scheme = (isset($_SERVER['HTTPS']) && mb_strtolower($_SERVER['HTTPS']) == 'on') ? 'https' : 'http';

        // Disable CDN for everything but CSS, icons, images and Javascript
        if (($url_file_path = @parse_url($file_path, PHP_URL_PATH)) !== false) {
            $allow_cdn = (preg_match('/\.png$|\.css$|\.ico$|\.js$/Diu', $url_file_path) > 0) ? $allow_cdn : false;
        }

        // If CDN is allowed, get the CDN path including the domain.
        if (($allow_cdn === true) && ($cdn_domain = forum_get_content_delivery_path($file_path))) {
            $final_file_path = sprintf('%s://%s/%s', $http_scheme, trim($cdn_domain, '/'), $file_path);
        } else {
            $final_file_path = rtrim($forum_path, '/') . '/' . $file_path;
        }

        // Add final file path to the cache.
        $file_path_cache_array[$file_path] = $final_file_path;
    }

    // Return the cached entry.
    return $file_path_cache_array[$file_path];
}
