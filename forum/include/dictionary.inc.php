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

/* $Id: dictionary.inc.php,v 1.17 2005-03-14 13:27:24 decoyduck Exp $ */

include_once(BH_INCLUDE_PATH. "/db.inc.php");
include_once(BH_INCLUDE_PATH. "/format.inc.php");
include_once(BH_INCLUDE_PATH. "/session.inc.php");

class dictionary {

    var $ignored_words_array;
    var $suggestions_array;

    var $content_array;

    var $current_word;
    var $obj_id;

    var $check_complete;

    var $offset_match;
    var $word_suggestion_count;

    function dictionary($content, $ignored_words, $current_word, $obj_id, $offset_match) {

        $this->ignored_words_array = array();
        $this->suggestions_array = array();

        preg_match_all("/([\w']+)|(.)/i", $content, $content_array);
        $this->content_array = $content_array[0];

        $this->ignored_words_array = explode(" ", $ignored_words);

        $this->current_word = $current_word;
        $this->obj_id = $obj_id;

        $this->check_complete = false;
        $this->offset_match = $offset_match;
        $this->word_suggestion_count = 0;
    }

    function get_obj_id()
    {
        return $this->obj_id;
    }

    function get_content()
    {
        return implode("", $this->content_array);
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

        $metaphone = addslashes(metaphone(trim($word)));
        $word = addslashes(trim($word));

        $uid = bh_session_get_value('UID');

        // Check to see if the word does actually exist

        $sql = "SELECT * FROM DICTIONARY WHERE WORD LIKE '$word' ";
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
        $this->content_array[$this->current_word] = $change_to;
    }

    function correct_all_word_matches($change_to)
    {
        $current_word = $this->get_current_word();

        foreach($this->content_array as $key => $word) {

            if (strtolower($word) == strtolower($current_word)) {
                $this->content_array[$key] = $change_to;
            }else {
                $this->content_array[$key] = $word;
            }
        }
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

        if (preg_match("/([\w']+)/i", $current_word) > 0) {

            if (preg_match("/([0-9]+)/", $current_word) < 1) {

                if (strlen($current_word) > 1 && strtoupper($current_word) != $current_word) return true;
            }
        }

        return false;
    }

    function word_is_ignored()
    {
        return _in_array($this->get_current_word(), $this->ignored_words_array);
    }

    function word_get_metaphone()
    {
        return metaphone(trim($this->get_current_word()));
    }

    function word_get_suggestions()
    {
        $db_dictionary_word_get_suggestions = db_connect();

        if (!isset($this->content_array[$this->current_word])) return false;

        // Fetch the current word and generate it's metaphone value

        $word = addslashes($this->get_current_word());
        $metaphone = addslashes($this->word_get_metaphone());

        // The offset of the metaphone results

        $offset = $this->offset_match;

        // The current user's UID

        $uid = bh_session_get_value('UID');

        // Exact match

        $sql = "SELECT * FROM DICTIONARY WHERE WORD LIKE '$word' ";
        $sql.= "AND (UID = 0 OR UID = '$uid') ";
        $sql.= "LIMIT 0, 1";

        $result = db_query($sql, $db_dictionary_word_get_suggestions);

        // If we found an exact match then they spelt it right?

        if (db_num_rows($result) > 0) return false;

        // Metaphone match (English pronounciation match)

        $sql = "SELECT COUNT(WORD) AS COUNT FROM DICTIONARY WHERE SOUND = '$metaphone' ";
        $sql.= "AND (UID = 0 OR UID = '$uid')";

        $result = db_query($sql, $db_dictionary_word_get_suggestions);
        list($this->word_suggestion_count) = db_fetch_array($result, DB_RESULT_NUM);

        $sql = "SELECT WORD FROM DICTIONARY WHERE SOUND = '$metaphone' ";
        $sql.= "AND (UID = 0 OR UID = '$uid') ";
        $sql.= "ORDER BY WORD ASC LIMIT $offset, 10";

        $result = db_query($sql, $db_dictionary_word_get_suggestions);

        if (db_num_rows($result) > 0) {

            while($row = db_fetch_array($result)) {

                $this->suggestions_array[] = $row['WORD'];
            }

        }else {

            if ($this->offset_match == 0) return false;

            $this->offset_match = 0;
            return $this->word_get_suggestions();
        }

        if (sizeof($this->suggestions_array) > 0) return $this->suggestions_array;

        return false;
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

            if (!$this->word_is_valid() || $this->word_is_ignored() || !$this->word_get_suggestions()) {

                $this->find_next_word();
            }
        }
    }
}

?>