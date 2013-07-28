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
require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'db.inc.php';
require_once BH_INCLUDE_PATH. 'forum.inc.php';
require_once BH_INCLUDE_PATH. 'user.inc.php';
// End Required includes

function word_filter_get($uid, &$word_filter_array)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    if (!is_array($word_filter_array)) $word_filter_array = array();

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT FID, MATCH_TEXT, REPLACE_TEXT, FILTER_TYPE ";
    $sql.= "FROM `{$table_prefix}WORD_FILTER` ";
    $sql.= "WHERE UID = '$uid' AND FILTER_ENABLED = 1 ";
    $sql.= "ORDER BY FID ";

    if ($uid <> 0) $sql.= "LIMIT 0, 20";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    while (($word_filter_data = $result->fetch_assoc()) !== null) {
        $word_filter_array[] = $word_filter_data;
    }

    return true;
}

function word_filter_get_from_session()
{
    $word_filter_array = array();

    if (isset($_SESSION['USE_ADMIN_FILTER']) && ($_SESSION['USE_ADMIN_FILTER'] == 'Y') || forum_get_setting('force_word_filter', 'Y')) {
        word_filter_get(0, $word_filter_array);
    }

    if (isset($_SESSION['USE_WORD_FILTER']) && ($_SESSION['USE_WORD_FILTER'] == 'Y')) {
        word_filter_get($_SESSION['UID'], $word_filter_array);
    }

    return word_filter_prepare($word_filter_array);
}

function word_filter_get_by_uid($uid)
{
    if (!is_numeric($uid)) return false;

    if (!($user_prefs = user_get_prefs($uid))) return false;

    static $word_filter_array = array();

    if (!isset($word_filter_array[$uid])) {

        $word_filter_array[$uid] = array();

        if ((isset($user_prefs['USE_ADMIN_FILTER']) && $user_prefs['USE_ADMIN_FILTER'] == 'Y') || forum_get_setting('force_word_filter', 'Y')) {
            word_filter_get(0, $word_filter_array[$uid]);
        }

        if (isset($user_prefs['USE_WORD_FILTER']) && $user_prefs['USE_WORD_FILTER'] == 'Y') {
            word_filter_get($uid, $word_filter_array[$uid]);
        }
    }

    return word_filter_prepare($word_filter_array[$uid]);
}

function word_filter_prepare($word_filter_array)
{
    if (!is_array($word_filter_array)) return false;

    $pattern_array = array();
    $replace_array = array();

    foreach ($word_filter_array as $filter) {

        if ($filter['FILTER_TYPE'] == WORD_FILTER_TYPE_WHOLE_WORD) {

            $pattern_array[] = sprintf('/\b%s\b/iu', preg_quote($filter['MATCH_TEXT'], "/"));

        } else if ($filter['FILTER_TYPE'] == WORD_FILTER_TYPE_PREG) {

            if (!preg_match('/^\/(.*)[^\]\/[imsxeADSUXu]*$/Diu', $filter['MATCH_TEXT'])) {
                $filter['MATCH_TEXT'] = "/{$filter['MATCH_TEXT']}/iu";
            }

            $pattern_array[] = $filter['MATCH_TEXT'];

        } else {

            $pattern_array[] = sprintf("/%s/iu", preg_quote($filter['MATCH_TEXT'], "/"));
        }

        if (strlen(trim($filter['REPLACE_TEXT'])) > 0) {

            $replace_array[] = $filter['REPLACE_TEXT'];

        } else {

            if ($filter['FILTER_TYPE'] == WORD_FILTER_TYPE_PREG) {

                $replace_array[] = "****";

            } else {

                $replace_array[] = str_repeat("*", mb_strlen($filter['MATCH_TEXT']));
            }
        }
    }

    return array(
        'pattern_array' => $pattern_array,
        'replace_array' => $replace_array
    );
}

function word_filter_add_ob_tags($content, $strip_html = false)
{
    $strip_html = ($strip_html) ? 'strip' : 'nostrip';
    return sprintf('<%1$s_%3$s>%2$s</%1$s_%3$s>', $strip_html, $content, $_SESSION['RAND_HASH']);
}

function word_filter_remove_ob_tags($content)
{
    return preg_replace(sprintf('/<\/?(strip|nostrip)_%s>/uU', $_SESSION['RAND_HASH']), "", $content);
}

function word_filter_ob_callback($content)
{
    if (!($user_wordfilter = word_filter_get_from_session())) {
        return word_filter_remove_ob_tags($content);
    }

    $pattern_array = $user_wordfilter['pattern_array'];
    $replace_array = $user_wordfilter['replace_array'];

    $pattern_match = sprintf('/<\/?strip_%1$s>/u', $_SESSION['RAND_HASH']);
    $content_array = preg_split($pattern_match, $content);

    foreach ($content_array as $key => $content_match) {

        if (($key % 2) && ($new_content = @preg_replace($pattern_array, $replace_array, $content_match))) {
            $content_array[$key] = strip_tags($new_content);
        }
    }

    $content = implode('', $content_array);

    $pattern_match = sprintf('/<\/?nostrip_%1$s>/u', $_SESSION['RAND_HASH']);
    $content_array = preg_split($pattern_match, $content);

    foreach ($content_array as $key => $content_match) {

        if (($key % 2) && ($new_content = @preg_replace($pattern_array, $replace_array, $content_match))) {
            $content_array[$key] = $new_content;
        }
    }

    $content = implode('', $content_array);

    return word_filter_remove_ob_tags($content);
}

function word_filter_apply($content, $uid, $strip_html = false)
{
    if (!is_numeric($uid)) return $content;

    if (($user_wordfilter = word_filter_get_by_uid($uid)) !== false) {

        $pattern_array = $user_wordfilter['pattern_array'];
        $replace_array = $user_wordfilter['replace_array'];

        if ((@$new_content = preg_replace($pattern_array, $replace_array, $content))) {
            return ($strip_html) ? strip_tags($new_content) : $new_content;
        }
    }

    return $content;
}

function word_filter_apply_limit_preg($matches)
{
    return preg_replace("/e/iu", "", $matches[0]);
}