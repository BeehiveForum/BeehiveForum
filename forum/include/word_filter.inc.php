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

if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'db.inc.php';
require_once BH_INCLUDE_PATH. 'forum.inc.php';
require_once BH_INCLUDE_PATH. 'session.inc.php';
require_once BH_INCLUDE_PATH. 'user.inc.php';

function word_filter_get($uid, &$word_filter_array)
{
    if (!$db_word_filter_get = db_connect()) return false;

    if (!is_numeric($uid)) return false;

    if (!is_array($word_filter_array)) $word_filter_array = array();

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT FID, MATCH_TEXT, REPLACE_TEXT, FILTER_TYPE ";
    $sql.= "FROM `{$table_prefix}WORD_FILTER` ";
    $sql.= "WHERE UID = '$uid' AND FILTER_ENABLED = 1 ";
    $sql.= "ORDER BY FID ";

    if ($uid <> 0) $sql.= "LIMIT 0, 20";

    if (!$result = db_query($sql, $db_word_filter_get)) return false;

    if (db_num_rows($result) == 0) return false;

    while (($word_filter_data = db_fetch_array($result))) {
        $word_filter_array[] = $word_filter_data;
    }

    return true;
}

function word_filter_get_by_sess_uid()
{
    if (($uid = session::get_value('UID')) === false) return false;

    $word_filter_array = array();

    if (session::get_value('USE_ADMIN_FILTER') == 'Y' || forum_get_setting('force_word_filter', 'Y', false)) {

        if (!word_filter_get(0, $word_filter_array)) {

            return false;
        }
    }

    if (session::get_value('USE_WORD_FILTER') == "Y") {

        if (!word_filter_get($uid, $word_filter_array)) {

            return false;
        }
    }

    return word_filter_prepare($word_filter_array);
}

function word_filter_get_by_uid($uid)
{
    if (!is_numeric($uid)) return false;

    static $word_filter_array = false;
    static $last_user_uid = false;

    if ((!is_array($word_filter_array)) || $last_user_uid !== $uid) {

        $last_user_uid = $uid;

        if (($user_prefs = user_get_prefs($uid))) {

            if ((isset($user_prefs['USE_ADMIN_FILTER']) && $user_prefs['USE_ADMIN_FILTER'] == 'Y') || forum_get_setting('force_word_filter', 'Y', false)) {

                if (!word_filter_get(0, $word_filter_array)) {

                    return false;
                }
            }

            if (isset($user_prefs['USE_WORD_FILTER']) && $user_prefs['USE_WORD_FILTER'] == 'Y') {

                if (!word_filter_get($uid, $word_filter_array)) {

                    return false;
                }
            }
        }
    }

    return word_filter_prepare($word_filter_array);
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

    return array('pattern_array' => $pattern_array,
                 'replace_array' => $replace_array);
}

function word_filter_add_ob_tags($content, $strip_html = false)
{
    if (($rand_hash = session::get_value('RAND_HASH')) === false) {
        return $content;
    }

    $rand_hash = preg_replace("/[^a-z]/iu", "", $rand_hash);
    
    $strip_html = ($strip_html) ? 'strip' : 'nostrip';

    return sprintf('<%1$s_%3$s>%2$s</%1$s_%3$s>', $strip_html, $content, $rand_hash);
}

function word_filter_rem_ob_tags($content)
{
    if (($rand_hash = session::get_value('RAND_HASH')) === false) {
        return $content;
    }

    $rand_hash = preg_replace("/[^a-z]/iu", "", $rand_hash);

    return preg_replace(sprintf('/<\/?(strip|nostrip)_%s>/uU', $rand_hash), "", $content);
}

function word_filter_ob_callback($content)
{
    if (($rand_hash = session::get_value('RAND_HASH')) === false) {
        return $content;
    }

    $rand_hash = preg_replace("/[^a-z]/iu", "", $rand_hash);

    if (!($user_wordfilter = word_filter_get_by_sess_uid())) {
        return $content;
    }
    
    $pattern_array = $user_wordfilter['pattern_array'];
    $replace_array = $user_wordfilter['replace_array'];
    
    $pattern_match = sprintf('/<\/?strip_%1$s>/u', $rand_hash);
    $content_array = preg_split($pattern_match, $content);

    foreach ($content_array as $key => $content_match) {

        if (($key % 2) && ($new_content = @preg_replace($pattern_array, $replace_array, $content_match))) {
            $content_array[$key] = strip_tags($new_content);
        }
    }
    
    $content = implode('', $content_array);
        
    $pattern_match = sprintf('/<\/?nostrip_%1$s>/u', $rand_hash);
    $content_array = preg_split($pattern_match, $content);

    foreach ($content_array as $key => $content_match) {

        if (($key % 2) && ($new_content = @preg_replace($pattern_array, $replace_array, $content_match))) {
            $content_array[$key] = $new_content;
        }
    }

    return implode('', $content_array);
}

function word_filter_apply($content, $uid, $strip_html = false)
{
    if (!is_numeric($uid)) return $content;

    if (($user_wordfilter = word_filter_get_by_uid($uid))) {

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

?>