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

/* $Id: dictionary.inc.php,v 1.1 2004-11-16 21:02:57 decoyduck Exp $ */

require_once('./include/db.inc.php');
require_once('./include/session.inc.php');

function dictionary_add_custom_word($word)
{
    $db_dictionary_add_custom_word = db_connect();

    $word = addslashes(trim($word));

    $uid = bh_session_get_value('UID');

    $sql = "INSERT INTO DICTIONARY (WORD, SOUND, UID) ";
    $sql.= "VALUES ('$word', SUBSTR(SOUNDEX('$word'), 1, 4), '$uid')";

    return db_query($sql, $db_dictionary_add_custom_word);
}

function dictionary_get_suggestions($word)
{
    $db_dictionary_get_suggestions = db_connect();

    $word = addslashes(trim($word));

    $uid = bh_session_get_value('UID');

    $suggestions_array = array();

    // Exact match

    $sql = "SELECT * FROM DICTIONARY WHERE WORD LIKE '$word' ";
    $sql.= "AND (UID = 0 OR UID = '$uid')";

    $result = db_query($sql, $db_dictionary_get_suggestions);

    if (db_num_rows($result) > 0) return false;

    // Soundex match

    $sql = "SELECT WORD FROM DICTIONARY WHERE ";
    $sql.= "SUBSTR(SOUNDEX(WORD), 1, 4) = SUBSTR(SOUNDEX('$word'), 1, 4) ";
    $sql.= "AND (UID = 0 OR UID = '$uid')";

    $result = db_query($sql, $db_dictionary_get_suggestions);

    while($row = db_fetch_array($result)) {

        $suggestions_array[] = $row['WORD'];
    }

    return $suggestions_array;
}

?>