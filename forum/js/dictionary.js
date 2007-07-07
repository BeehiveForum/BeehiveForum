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

/* $Id: dictionary.js,v 1.21 2007-07-07 22:44:41 decoyduck Exp $ */

function initialiseDictionary(obj_id) {

    var dictObj = getObjByName('dictionary');
    var contObj = getObjByName('content');
  
    if (window.opener.readContent) {
        
        contObj.value = window.opener.readContent(obj_id);
        dictObj.submit();
    }
}

function changeWord(obj) {

    var change_to = getObjById('change_to'); 
    var i = obj.options[obj.selectedIndex].value;
    
    // IE doesn't like .value when <object>value</object> is used instead
    // of <object value="value">value</object> so we use innerText

    if (i.length == 0) i = obj.options[obj.selectedIndex].innerText;

    change_to.value = i;

}

function readContent(obj_id) {

    if (self.tinyMCE) {
        return tinyMCE.getContent(obj_id);
    }

    var form_obj = getObjById(obj_id);
    return form_obj.value;
}

function updateContent(obj_id, content) {

    if (self.tinyMCE) {
        return tinyMCE.setContent(unescape(content));
    }

    var form_obj = getObjById(obj_id);
    form_obj.value = unescape(content);
}

function showCurrentWord() {

    var highlighted_word = getObjById('highlighted_word');
    highlighted_word.scrollIntoView(false);
}
