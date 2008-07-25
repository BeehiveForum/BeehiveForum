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

/* $Id: word_filter.inc.php,v 1.50 2008-07-25 14:52:44 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

/**
* Get Word Filter entries
*
* Gets the word filter entries for the specified user UID. Don't call this function
* directly. Instead you should use word_filter_get_by_uid() or word_filter_get_by_sess_uid()
*
* @return bool
* @param integer $uid - User UID
* @param array $word_filter_array - By Reference array containing entries from database.
*/

function word_filter_get($uid, &$word_filter_array)
{
    if (!$db_word_filter_get = db_connect()) return false;

    if (!is_numeric($uid)) return false;

    if (!is_array($word_filter_array)) $word_filter_array = array();

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT FID, MATCH_TEXT, REPLACE_TEXT, FILTER_TYPE ";
    $sql.= "FROM {$table_data['PREFIX']}WORD_FILTER ";
    $sql.= "WHERE UID = '$uid' AND FILTER_ENABLED = 1 ";
    $sql.= "ORDER BY FID ";

    if ($uid <> 0) $sql.= "LIMIT 0, 20";

    if (!$result = db_query($sql, $db_word_filter_get)) return false;

    if (db_num_rows($result) > 0) {

        while ($word_filter_data = db_fetch_array($result)) {

            $word_filter_array[] = $word_filter_data;
        }
    }

    return true;
}

/**
* Get Word Filter entries for session user
*
* Gets the word filter entries for the current user by getting UID from their session
*
* @return array
* @param void
*/

function word_filter_get_by_sess_uid()
{
    if (($uid = bh_session_get_value('UID')) === false) return false;

    $word_filter_array = array();

    if (bh_session_get_value('USE_ADMIN_FILTER') == 'Y' || forum_get_setting('force_word_filter', 'Y', false)) {

        if (!word_filter_get(0, $word_filter_array)) {

            return false;
        }
    }

    if (bh_session_get_value('USE_WORD_FILTER') == "Y") {

        if (!word_filter_get($uid, $word_filter_array)) {

            return false;
        }
    }

    return word_filter_prepare($word_filter_array);
}

/**
* Get Word Filter entries for the specified user UID
*
* Gets the word filter entries for the specified user UID.
*
* @return array
* @param integer $uid - User UID
*/

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

/**
* Prepare word filter
*
* Seperates the results from the above functions into a multi-dimensional
* array to be used by the applying functions below.
*
* @return array
* @param array $word_filter_array - array of results from the database query.
*/

function word_filter_prepare($word_filter_array)
{
    if (!is_array($word_filter_array)) return false;

    $pattern_array = array();
    $replace_array = array();

    foreach ($word_filter_array as $filter) {

        if ($filter['FILTER_TYPE'] == WORD_FILTER_TYPE_WHOLE_WORD) {

            $pattern_array[] = "/\b". preg_quote($filter['MATCH_TEXT'], "/"). "\b/i";

        }elseif ($filter['FILTER_TYPE'] == WORD_FILTER_TYPE_PREG) {

            if (!preg_match("/^\/(.*)[^\\]\/[imsxeADSUXu]*$/i", $filter['MATCH_TEXT'])) {
                $filter['MATCH_TEXT'] = "/{$filter['MATCH_TEXT']}/i";
            }

            $pattern_array[] = $filter['MATCH_TEXT'];

        }else {

            $pattern_array[] = "/". preg_quote($filter['MATCH_TEXT'], "/"). "/i";
        }

        if (strlen(trim($filter['REPLACE_TEXT'])) > 0) {

            $replace_array[] = $filter['REPLACE_TEXT'];

        }else {

            if ($filter['FILTER_TYPE'] == WORD_FILTER_TYPE_PREG) {

                $replace_array[] = "****";

            }else {

                $replace_array[] = str_repeat("*", strlen($filter['MATCH_TEXT']));
            }
        }
    }

    return array('pattern_array' => $pattern_array,
                 'replace_array' => $replace_array);
}

/**
* Add word filter OB tags
*
* Adds output buffering compatible word filter tags to the content.
* Only to be used by content you want to be handled by the output
* buffer to the client. If you want to parse a string simply pass
* it through word_filter_apply.
*
* @return string
* @param string $content - string to be wrapped in OB tags.
*/

function word_filter_add_ob_tags($content)
{
    if (($rand_hash = bh_session_get_value('RAND_HASH')) === false) {
        return $content;
    }

    $rand_hash = preg_replace("/[^a-z]/i", "", $rand_hash);

    return "<$rand_hash>$content</$rand_hash>";
}

/**
* Remove word filter OB tags
*
* Removes the output buffering compatible word filter tags.
*
* @return string
* @param string $content - string to remove the OB tags from.
*/

function word_filter_rem_ob_tags($content)
{
    if (($rand_hash = bh_session_get_value('RAND_HASH')) === false) {
        return $content;
    }

    $rand_hash = preg_replace("/[^a-z]/i", "", $rand_hash);

    return preg_replace("/<\/?$rand_hash>/", "", $content);
}

/**
* Word filter OB function
*
* Used by the PHP output buffering function to filter content
* sent to the client. Will only filter content wrapped by
* word_filter_add_ob_tags().
*
* @return string
* @param string $content - string to remove the OB tags from.
*/

function word_filter_obstart($content)
{
    if (($rand_hash = bh_session_get_value('RAND_HASH')) === false) {
        return $content;
    }

    $rand_hash = preg_replace("/[^a-z]/i", "", $rand_hash);

    if (($user_wordfilter = word_filter_get_by_sess_uid())) {

        $pattern_array = $user_wordfilter['pattern_array'];
        $replace_array = $user_wordfilter['replace_array'];

        $content_array = preg_split("/<\/?$rand_hash>/i", $content);

        for ($i = 0; $i < sizeof($content_array); $i++) {

            if ($i % 2) {

                if (@$new_content = preg_replace($pattern_array, $replace_array, $content_array[$i])) {

                    $content_array[$i] = $new_content;
                }
            }
        }

        $content = implode("", $content_array);
    }

    return $content;
}

/**
* Apply word filter
*
* Apply specified user's word filter to string.
*
* @return string
* @param string $content - string to remove the OB tags from.
* @param integer $uid - User UID.
*/

function word_filter_apply($content, $uid)
{
    if (!is_numeric($uid)) return $content;

    if (($user_wordfilter = word_filter_get_by_uid($uid))) {

        $pattern_array = $user_wordfilter['pattern_array'];
        $replace_array = $user_wordfilter['replace_array'];

        if (@$new_content = preg_replace($pattern_array, $replace_array, $content)) {

            return $new_content;
        }
    }

    return $content;
}

/**
* Restrict PREG word filters
*
* The /../e preg modifier allows PHP code to be used in the replacement - bad!
*
* @return string
* @param array $matches - matches from preg_match / preg_match_all call.
*/

function word_filter_apply_limit_preg($matches)
{
    return preg_replace("/e/i", "", $matches[0]);
}

?>