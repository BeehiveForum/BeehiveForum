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

/* $Id: dictionary.inc.php,v 1.39 2007-05-02 23:15:41 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "fixhtml.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");

class dictionary {

    var $ignored_words_array;
    var $suggestions_array;

    var $content_array;

    var $current_word;
    var $obj_id;

    var $check_complete;

    var $offset_match;
    var $word_suggestion_count;
    var $word_suggestion_result;

    function dictionary($content, $ignored_words, $current_word, $obj_id, $offset_match) {

        $this->ignored_words_array = array();
        $this->suggestions_array = array();

        $this->prepare_content($content);

        $this->ignored_words_array = explode(" ", $ignored_words);

        $this->current_word = $current_word;
        $this->obj_id = $obj_id;

        $this->check_complete = false;
        $this->offset_match = $offset_match;

        $this->word_suggestion_count = 0;
        $this->word_suggestion_result = 0;
    }

    function prepare_content($content)
    {
        $word_match = "([0-9\w'-]+)|([0-9]+)|(<[^>]+>)|(&[^;]+;)|(\w+'+\w+)|";
        $word_match.= "([\s+\.!\?,\[\]()\-+'\"=;&#0215;\$%\^&\*\/:{}]+)|";
        $word_match.= "(\w+:\/\/([^:\s]+:?[^@\s]+@)?[_\.0-9a-z-]*(:\d+)?([\/?#]\S*[^),\.\s])?)|";
        $word_match.= "(www\.[_\.0-9a-z-]*(:\d+)?([\/?#]\S*[^),\.\s])?)|";
        $word_match.= "([0-9a-z][_\.0-9a-z-]*@[0-9a-z][_\.0-9a-z-]*\.[a-z]{2,})";

        $this->content_array = preg_split("/$word_match/i", $content, -1, PREG_SPLIT_DELIM_CAPTURE);
    }

    function is_installed()
    {
        $db_dictionary_check_setup = db_connect();

        $sql = "SELECT WORD FROM DICTIONARY LIMIT 0, 1";
        $result = db_query($sql, $db_dictionary_check_setup);

        return (db_num_rows($result) > 0);
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

        $content = str_replace("'", "\'", $content);
        $content = str_replace("\n", "\\n", $content);
        $content = str_replace("\r", "\\r", $content);

        return $content;
    }

    function get_ignored_words()
    {
        return trim(implode(" ", $this->ignored_words_array));
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
        foreach($this->content_array as $key => $word) {

            if ($key == $this->current_word) {
                echo "<span class=\"highlight\" id=\"highlighted_word\">", nl2br(_htmlentities($word)), "</span>";
            }else {
                echo nl2br(_htmlentities($word));
            }
        }
    }

    function add_custom_word($word)
    {
        $db_dictionary_add_custom_word = db_connect();

        $metaphone = db_escape_string(metaphone(trim($word)));
        $word = db_escape_string(trim($word));

        if (($uid = bh_session_get_value('UID')) === false) return false;

        // Check to see if the word does actually exist

        $sql = "SELECT * FROM DICTIONARY WHERE WORD = '$word' ";
        $sql.= "AND (UID = 0 OR UID = '$uid') ";
        $sql.= "LIMIT 0, 1";

        $result = db_query($sql, $db_dictionary_add_custom_word);

        if (db_num_rows($result) < 1) {

            $sql = "INSERT INTO DICTIONARY (WORD, SOUND, UID) ";
            $sql.= "VALUES ('$word', '$metaphone', '$uid')";

            return db_query($sql, $db_dictionary_add_custom_word);
        }

        return false;
    }

    function correct_current_word($change_to)
    {
        $current_word = $this->content_array[$this->current_word];

        if (strtolower($current_word) == $current_word) {

            $this->content_array[$this->current_word] = strtolower($change_to);

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
        if (!in_array(strtolower($word), $this->ignored_words_array)) {

            $this->ignored_words_array[] = strtolower($word);
        }
    }

    function word_is_valid()
    {
        $current_word = $this->get_current_word();

        $word_match = "([0-9]+)|(<[^>]+>)|(&[^;]+;)|";
        $word_match.= "(\w+:\/\/([^:\s]+:?[^@\s]+@)?[_\.0-9a-z-]*(:\d+)?([\/?#]\S*[^),\.\s])?)|";
        $word_match.= "(www\.[_\.0-9a-z-]*(:\d+)?([\/?#]\S*[^),\.\s])?)|";
        $word_match.= "([0-9a-z][_\.0-9a-z-]*@[0-9a-z][_\.0-9a-z-]*\.[a-z]{2,})";

        if (preg_match("/$word_match/i", $current_word) < 1) {

            if (strlen($current_word) > 1 && strtoupper($current_word) != $current_word) return true;
        }

        return false;
    }

    function word_is_ignored()
    {
        return in_array(strtolower($this->get_current_word()), $this->ignored_words_array);
    }

    function word_get_metaphone()
    {
        return metaphone(trim($this->get_current_word()));
    }

    function word_get_suggestions()
    {
        $db_dictionary_word_get_suggestions = db_connect();

        if (!isset($this->content_array[$this->current_word])) return;

        // Fetch the current word

        $word = db_escape_string(strtolower($this->get_current_word()));

        if (!$this->word_is_valid($word)) return;

        // The offset of the metaphone results

        $offset = $this->offset_match;

        // The current user's UID

        if (($uid = bh_session_get_value('UID')) === false) return false;

        // Exact match

        $sql = "SELECT * FROM DICTIONARY WHERE WORD = '$word' ";
        $sql.= "AND (UID = 0 OR UID = '$uid') ";
        $sql.= "LIMIT 0, 1";

        $result = db_query($sql, $db_dictionary_word_get_suggestions);

        // If we found an exact match then they spelt it right?

        if (db_num_rows($result) > 0) {

            $this->word_suggestion_result = DICTIONARY_EXACT;
            return;
        }

        // Metaphone match (English pronounciation match)

        if ($metaphone = $this->word_get_metaphone()) {

            $metaphone = db_escape_string($metaphone);

            $sql = "SELECT WORD FROM DICTIONARY WHERE SOUND = '$metaphone' ";
            $sql.= "AND (UID = 0 OR UID = '$uid') ";
            $sql.= "ORDER BY WORD ASC LIMIT $offset, 10";

            $result = db_query($sql, $db_dictionary_word_get_suggestions);

            if (db_num_rows($result) > 0) {

                while($row = db_fetch_array($result)) {

                    $this->suggestions_array[] = $row['WORD'];
                }

            }else {

                if ($this->offset_match == 0) {

                    $this->word_suggestion_result = DICTIONARY_NOMATCH;
                    return;
                }

                $this->offset_match = 0;
                return $this->word_get_suggestions();
            }

            if (sizeof($this->suggestions_array) > 0) {

                $this->word_suggestion_result = DICTIONARY_SUGGEST;
                return;
            }
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
        $this->current_word++;
        $this->offset_match = 0;

        if ($this->current_word > (sizeof($this->content_array) - 1)) {

            $this->check_complete = true;
            return;

        }else {

            $this->word_get_suggestions();

            if ($this->word_suggestion_result == DICTIONARY_EXACT) {

                $this->find_next_word();
                return;
            }

            if (!$this->word_is_valid() || $this->word_is_ignored()) {

                $this->find_next_word();
            }
        }
    }
}

?>