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

/* $Id: word_filter.inc.php,v 1.21 2004-11-21 17:26:08 decoyduck Exp $ */

include_once("./include/forum.inc.php");
include_once("./include/session.inc.php");

// Loads the user's word filter into an array.
// Saves having to query the database every time
// the apply_wordfilter() function is called.

function load_wordfilter()
{
    $db_load_wordfilter = db_connect();

    static $user_wordfilter = false;

    if (!$user_wordfilter) {

        $uid = bh_session_get_value('UID');

        if (!$table_data = get_table_prefix()) return array();

        $filter_array = array();

        // Should we include the admin filters?

        if ((bh_session_get_value('USE_ADMIN_FILTER') == 'Y' && bh_session_get_value('USE_WORD_FILTER') != "Y") || forum_get_setting('admin_force_word_filter', 'Y', false)) {

            $sql = "SELECT * FROM {$table_data['PREFIX']}FILTER_LIST ";
            $sql.= "WHERE UID = 0 LIMIT 0, 20";

            $result = db_query($sql, $db_load_wordfilter);

            while ($row = db_fetch_array($result)) {
                $filter_array[] = $row;
            }
        }

        // Get the user's own filter.

        if (bh_session_get_value('USE_WORD_FILTER') == "Y") {

            $sql = "SELECT * FROM {$table_data['PREFIX']}FILTER_LIST ";
            $sql.= "WHERE UID = '$uid' LIMIT 0, 20";

            $result = db_query($sql, $db_load_wordfilter);

            while ($row = db_fetch_array($result)) {
                $filter_array[] = $row;
            }
        }

        $pattern_array = array();
        $replace_array = array();

        foreach ($filter_array as $filter) {

            if ($filter['FILTER_OPTION'] == 1) {
                $pattern_array[] = "/\b(". preg_quote($filter['MATCH_TEXT'], "/"). ")\b/i";
            }elseif ($filter['FILTER_OPTION'] == 2) {
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
                if ($filter['FILTER_OPTION'] == 2) {
                    $replace_array[] = "****";
                }else {
                    $replace_array[] = str_repeat("*", strlen($filter['MATCH_TEXT']));
                }
            }
        }

        $user_wordfilter = array("pattern_array" => $pattern_array,
                                 "replace_array" => $replace_array);
    }

    return $user_wordfilter;
}

// Applys the loaded word filter to the given content

function apply_wordfilter($content)
{
    if ($user_wordfilter = load_wordfilter()) {

        if (!is_array($user_wordfilter)) return $content;
        if (!isset($user_wordfilter['pattern_array'])) return $content;
        if (!isset($user_wordfilter['replace_array'])) return $content;

        $pattern_array = $user_wordfilter['pattern_array'];
        $replace_array = $user_wordfilter['replace_array'];

        if (@$new_content = preg_replace($pattern_array, $replace_array, $content)) {
            return $new_content;
        }
    }

    return $content;
}

// the /../e preg modifier allows PHP code to be used in the replacement - bad!

function filter_limit_preg ($matches)
{
    return preg_replace("/e/i", "", $matches[0]);
}

?>