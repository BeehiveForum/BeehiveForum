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

/* $Id: bh_ms_word_spelling_check.php,v 1.1 2006-06-12 23:01:21 decoyduck Exp $ */

function load_language_file($filename)
{
    include("./forum/include/languages/$filename");
    return $lang;
}

class check_spelling
{
    var $word; // Microsoft Word COM object

    function check_spelling() {
        
        // Initialise new Word COM object
        $this->word = new COM("word.application");

        // Make it invisible.
        $this->word->Visible = 0;
    }

    private function word_spell_check($string) {
        
        echo "Checking: $string\n";
    
        // Create new document and paste in string.
        $this->word->Visible = 0;
        $this->word->Documents->Add();
        $this->word->Selection->TypeText($string);

        // Check spelling and grammar.
        $this->word->ActiveDocument->CheckSpelling();

        // Select the whole document.
        $this->word->Selection->WholeStory();

        // Get the corrected string        
        $corrected = $this->word->Selection->Text;

        // Close the document and do not save changes.
        $this->word->ActiveDocument->Close(false);

        return $corrected;
    }

    function parse_lang_array($lang)
    {
        if (is_array($lang)) {
            foreach($lang as $key => $string) {
                if (is_array($string)) {
                    $lang[$key] = $this->parse_lang_array($string);
                }else {
                    $lang[$key] = $this->word_spell_check($string);
                }
            }
        }else {
            $lang = $this->word_spell_check($lang);
        }

        return $lang;
    }
}

// Load language file
$lang = load_language_file("en.inc.php");

// Initialise our class
$check_spelling = new check_spelling();

// Do the work
$lang = $check_spelling->parse_lang_array($lang);

?>