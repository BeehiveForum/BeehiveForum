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

/* $Id: dictionary.inc.php,v 1.5 2004-11-26 09:50:15 decoyduck Exp $ */

require_once('./include/db.inc.php');
require_once('./include/session.inc.php');
require_once('./include/format.inc.php');

class dictionary {

    var $ignored_words_array;
    var $suggestions_array;

    var $content_array;

    var $current_word;
    var $obj_id;

    var $check_complete;

    function dictionary($content, $ignored_words, $current_word, $obj_id) {

        $this->ignored_words_array = array();
        $this->suggestions_array = array();

        preg_match_all("/([abcdefghijklmnopqrstuvwxyz']+)|(.)/i", $content, $content_array);
        $this->content_array = $content_array[0];

        $this->ignored_words_array = explode(" ", $ignored_words);

        $this->current_word = $current_word;
        $this->obj_id = $obj_id;
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
        return implode("", $this->ignored_words_array);
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
        if (sizeof($this->suggestions_array) < 1) word_get_suggestions();
        return $this->suggestions_array;
    }

    function is_check_complete()
    {
        return $this->check_complete;
    }

    function pretty_print_content()
    {
        foreach($this->content_array as $key => $word) {

            if ($key == $this->current_word) {
                echo "<span class=\"highlight\">$word</span>";
            }else {
                echo "$word";
            }
        }
    }

    function add_custom_word($word)
    {
        $db_dictionary_add_custom_word = db_connect();

        $word = addslashes(trim($word));

        $uid = bh_session_get_value('UID');

        $sql = "INSERT INTO DICTIONARY (WORD, SOUND, UID) ";
        $sql.= "VALUES ('$word', SUBSTRING(SOUNDEX('$word'), 1, 4), '$uid')";

        return db_query($sql, $db_dictionary_add_custom_word);
    }

    function correct_current_word($change_to)
    {
        $this->content_array[$this->current_word] = $change_to;
    }

    function correct_all_word_matches($change_to)
    {
        $current_word = $this->content_array[$this->current_word];

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
        return (preg_match("/([abcdefghijklmnopqrstuvwxyz']+)/i", $this->content_array[$this->current_word]) > 0);
    }

    function word_is_ignored()
    {
        return _in_array($this->content_array[$this->current_word], $this->ignored_words_array);
    }

    function word_get_suggestions()
    {
        $db_dictionary_word_get_suggestions = db_connect();

        if (!isset($this->content_array[$this->current_word])) return false;

        $word = addslashes(trim($this->content_array[$this->current_word]));

        $uid = bh_session_get_value('UID');

        // Exact match

        $sql = "SELECT * FROM DICTIONARY WHERE WORD LIKE '$word' ";
        $sql.= "AND (UID = 0 OR UID = '$uid')";

        $result = db_query($sql, $db_dictionary_word_get_suggestions);

        if (db_num_rows($result) > 0) return false;

        // Soundex match

        $sql = "SELECT WORD FROM DICTIONARY WHERE ";
        $sql.= "SUBSTRING(SOUNDEX(WORD), 1, 4) = SUBSTRING(SOUNDEX('$word'), 1, 4) ";
        $sql.= "AND (UID = 0 OR UID = '$uid')";

        $result = db_query($sql, $db_dictionary_word_get_suggestions);

        while($row = db_fetch_array($result)) {

            $this->suggestions_array[] = $row['WORD'];
        }

        if (sizeof($this->suggestions_array) > 0) return $this->suggestions_array;

        return false;
    }

    function get_best_suggestion()
    {
        if (isset($this->suggestions_array[0])) return $this->suggestions_array[0];
        return "";
    }

    function find_next_word()
    {
        $this->current_word++;

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