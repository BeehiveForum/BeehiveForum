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

/* $Id$ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "compat.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "fixhtml.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");

class dictionary {

    private $ignored_words_array;
    private $suggestions_array;

    private $content_array;

    private $current_word;
    private $obj_id;

    private $check_complete;

    private $offset_match;
    private $word_suggestion_count;
    private $word_suggestion_result;

    function initialise($content, $ignored_words_array, $current_word, $obj_id, $offset_match)
    {
        $this->prepare_content($content);

        $this->ignored_words_array = is_array($ignored_words_array) ? $ignored_words_array : array();
        $this->suggestions_array = array();

        $this->current_word = $current_word;
        $this->obj_id = $obj_id;

        $this->offset_match = abs($offset_match);

        $this->check_complete = false;

        $this->word_suggestion_count = 0;
        $this->word_suggestion_result = 0;
    }

    function prepare_content($content)
    {
        $word_match = '([0-9]+)|(<[^>]+>)|(&[^;]+;)|(\p{L}+\-\p{L}+)|(\p{L}+\'+\p{L}+)|';
        $word_match.= '([\s+\.!\?,\[\]()\-+\'"=;&#0215;\$%\^&\*\/:{}]+)|';
        $word_match.= '(\p{L}+:\/\/([^:\s]+:?[^@\s]+@)?[_\.0-9a-z-]*(:\d+)?([\/?#]\S*[^),\.\s])?)|';
        $word_match.= '(www\.[_\.0-9a-z-]*(:\d+)?([\/?#]\S*[^),\.\s])?)|';
        $word_match.= '([0-9a-z][_\.0-9a-z-]*@[0-9a-z][_\.0-9a-z-]*\.[a-z]{2,})';

        $this->content_array = preg_split("/$word_match/iu", $content, -1, PREG_SPLIT_DELIM_CAPTURE);
    }

    function is_installed()
    {
        if (!$db_dictionary_check_setup = db_connect()) return false;

        $sql = "SELECT COUNT(WORD) FROM DICTIONARY";

        if (!$result = db_query($sql, $db_dictionary_check_setup)) return false;

        list($word_count) = db_fetch_array($result, DB_RESULT_NUM);

        return ($word_count > 0);
    }

    function get_obj_id()
    {
        return $this->obj_id;
    }

    function get_content()
    {
        return implode("", $this->content_array);
    }

    function get_js_safe_content()
    {
        $content = $this->get_content();
        return html_js_safe_str($content);
    }

    function get_ignored_words()
    {
        return $this->ignored_words_array;
    }

    function get_current_word_index()
    {
        return $this->current_word;
    }

    function get_current_word()
    {
        if (!isset($this->content_array[$this->current_word])) return "";
        return $this->content_array[$this->current_word];
    }

    function get_suggestions_array()
    {
        if ($this->word_suggestion_result == DICTIONARY_NOMATCH) return false;
        if (sizeof($this->suggestions_array) < 1) $this->word_get_suggestions();
        return $this->suggestions_array;
    }

    function get_offset_match()
    {
        return $this->offset_match;
    }

    function is_check_complete()
    {
        return $this->check_complete;
    }

    function get_word_suggestion_count()
    {
        return $this->word_suggestion_count;
    }

    function pretty_print_content()
    {
        $pretty_content = '';
        
        foreach ($this->content_array as $key => $word) {

            if ($key == $this->current_word) {
                $pretty_content.= sprintf('<span class="highlight" id="highlighted_word">%s</span>', nl2br(htmlentities_array($word)));
            }else {
                $pretty_content.= nl2br(htmlentities_array($word));
            }
        }
        
        return $pretty_content;
    }

    function add_custom_word($word)
    {
        if (!$db_dictionary_add_custom_word = db_connect()) return false;

        $word = db_escape_string(trim($word));

        if (($uid = bh_session_get_value('UID')) === false) return false;

        $sql = "INSERT IGNORE INTO DICTIONARY (WORD, SOUND, UID) ";
        $sql.= "VALUES ('$word', SOUNDEX('$word'), '$uid')";

        if (!db_query($sql, $db_dictionary_add_custom_word)) return false;

        return true;
    }

    function correct_current_word($change_to)
    {
        $current_word = $this->content_array[$this->current_word];

        if (mb_strtolower($current_word) == $current_word) {

            $this->content_array[$this->current_word] = mb_strtolower($change_to);

        }elseif (ucfirst($current_word) == $current_word) {

            $this->content_array[$this->current_word] = ucfirst($change_to);
        }

        $content = $this->get_content();
        $this->prepare_content($content);
    }

    function correct_all_word_matches($change_to)
    {
        $current_word = $this->get_current_word();

        $content = $this->get_content();

        $content = str_replace($current_word, $change_to, $content);
        $this->prepare_content($content);
    }

    function add_ignored_word($word)
    {
        if (!in_array(mb_strtolower($word), $this->ignored_words_array)) {

            $this->ignored_words_array[] = mb_strtolower($word);
        }
    }

    function word_is_valid()
    {
        $current_word = $this->get_current_word();

        $word_match = '([0-9]+)|(<[^>]+>)|(&[^;]+;)|';
        $word_match.= '(\p{L}+:\/\/([^:\s]+:?[^@\s]+@)?[_\.0-9a-z-]*(:\d+)?([\/?#]\S*[^),\.\s])?)|';
        $word_match.= '(www\.[_\.0-9a-z-]*(:\d+)?([\/?#]\S*[^),\.\s])?)|';
        $word_match.= '([0-9a-z][_\.0-9a-z-]*@[0-9a-z][_\.0-9a-z-]*\.[a-z]{2,})';

        if (preg_match("/$word_match/iu", $current_word) < 1) {

            if (strlen($current_word) > 1 && mb_strtoupper($current_word) != $current_word) return true;
        }

        return false;
    }

    function word_is_ignored()
    {
        return in_array(mb_strtolower($this->get_current_word()), $this->ignored_words_array);
    }

    function word_get_suggestions()
    {
        if (!$db_dictionary_word_get_suggestions = db_connect()) return;

        if (!isset($this->content_array[$this->current_word])) return;

        // Fetch the current word

        $word = db_escape_string($this->get_current_word());

        // Check it is valid.

        if (!$this->word_is_valid($word)) return;

        // The offset of the soundex results

        $offset = $this->offset_match;

        // The current user's UID

        if (($uid = bh_session_get_value('UID')) === false) return;

        // Exact match

        $sql = "SELECT WORD FROM DICTIONARY WHERE WORD = '$word' ";
        $sql.= "AND (UID = 0 OR UID = '$uid') ";
        $sql.= "LIMIT 0, 1";

        if (!$result = db_query($sql, $db_dictionary_word_get_suggestions)) return;

        // If we found an exact match then they spelt it right?

        if (db_num_rows($result) > 0) {

            $this->word_suggestion_result = DICTIONARY_EXACT;
            return;
        }

        // Soundex match.

        $sql = "SELECT WORD FROM DICTIONARY WHERE SOUND = SOUNDEX('$word') ";
        $sql.= "AND (UID = 0 OR UID = '$uid') ";
        $sql.= "ORDER BY WORD ASC LIMIT $offset, 10";

        if (!$result = db_query($sql, $db_dictionary_word_get_suggestions)) return;

        if (db_num_rows($result) > 0) {

            while (($spelling_data = db_fetch_array($result))) {

                $this->suggestions_array[$spelling_data['WORD']] = $spelling_data['WORD'];
            }

        }else {

            if ($this->offset_match == 0) {

                $this->word_suggestion_result = DICTIONARY_NOMATCH;
                return;
            }

            $this->offset_match = 0;
            $this->word_get_suggestions();
        }

        if (sizeof($this->suggestions_array) > 0) {

            $this->word_suggestion_result = DICTIONARY_SUGGEST;
            return;
        }

        $this->word_suggestion_result = DICTIONARY_NOMATCH;
    }

    function get_best_suggestion()
    {
        if (isset($this->suggestions_array[0])) return $this->suggestions_array[0];
        return "";
    }

    function get_more_suggestions()
    {
        $this->offset_match += 10;
        $this->word_get_suggestions();
    }

    function find_next_word()
    {
        while (($this->current_word < sizeof($this->content_array))) {

            $this->current_word = $this->current_word + 1;
            $this->offset_match = 0;

            if (($this->word_is_valid()) && (!$this->word_is_ignored())) {

                $this->word_get_suggestions();

                if ($this->word_suggestion_result != DICTIONARY_EXACT) {
                    return;
                }
            }
        }

        $this->check_complete = true;
        return;
    }
}

?>