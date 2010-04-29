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

/* $Id$ */

function word_spell_check($matches)
{
    // Our Word COM Object

    global $word_obj;

    // Our string to check

    $string_check = trim($matches[1]);

    echo "Checking: $string_check...<br />\n";

    // Create new document and paste in string.

    $word_obj->Visible = 1;
    $word_obj->Documents->Add();
    $word_obj->Selection->TypeText($string_check);

    // Check spelling and grammar.
    $word_obj->ActiveDocument->CheckSpelling();

    // Select the whole document.
    $word_obj->Selection->WholeStory();

    // Get the corrected string
    $string_corrected = $word_obj->Selection->Text;

    // Close the document and do not save changes.
    $word_obj->ActiveDocument->Close(false);

    // Trim the new string
    $string_corrected = trim($string_corrected);

    // Wrap it in quotes and return it.
    return "\"$string_corrected\";";
}

// Prevent time out

@set_time_limit(0);

// Initialise new Word COM object

$word_obj = new COM("word.application");

// Load the language file.

if (($langfile = file('./forum/include/languages/en.inc.php'))) {

    if (($fp = fopen('./forum/include/languages/en-new.inc.php', 'w'))) {

        foreach ($langfile as $line) {

            if (!preg_match('/^\$lang\[\'_/u', $line)) {

                $corrected_line = preg_replace_callback('/"([^"]+)";/u', 'word_spell_check', $line);

                fwrite($fp, $corrected_line);

                continue;
            }

            fwrite($fp, $line);
        }

        fclose($fp);

        echo "Spell checking has completed successfully.<br />\n";

    }else {

        echo "Could not open en.inc.php for writing.<br />\n";
    }

}else {

    echo "Could not open en.inc.php for reading.<br />\n";
}

?>