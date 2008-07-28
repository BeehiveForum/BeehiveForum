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

/* $Id: dictionary.js,v 1.29 2008-07-28 21:05:57 decoyduck Exp $ */

function initialiseDictionary(obj_id)
{

    var dictObj = getObjsByName('dictionary')[0];
    var contObj = getObjsByName('content')[0];

    if ((typeof dictObj == 'object') && (typeof contObj == 'object')) {
  
        if (window.opener.readContent) {
        
            contObj.value = window.opener.readContent(obj_id);
            dictObj.submit();
        }
    }
}

function changeWord(obj)
{

    var change_to = getObjsByName('change_to')[0];

    if (typeof change_to == 'object') {
    
        change_to.value = obj.options[obj.selectedIndex].value;   
        return true;
    }

    return false;
}

function readContent(obj_id)
{

    if (self.tinyMCE) {
        return tinyMCE.getContent(obj_id);
    }

    var form_obj = getObjById(obj_id);

    if (typeof form_obj == 'object') {

        return form_obj.value;
    }
}

function updateContent(obj_id, content)
{

    if (self.tinyMCE) {
        return tinyMCE.setContent(content);
    }

    var form_obj = getObjById(obj_id);

    if (typeof form_obj == 'object') {

        form_obj.value = content;
    }
}

function showCurrentWord()
{

    var highlighted_word = getObjById('highlighted_word');

    if (typeof highlighted_word == 'object') {

        highlighted_word.scrollIntoView(false);
    }
}
