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

function changeword() {

    var i = document.dictionary.suggestion.selectedIndex;
    document.dictionary.change_to.value = document.dictionary.suggestion.options[i].value;
}

function openSpellCheck(webtag, obj_id) {
    
    var form_obj;
    var content;

    if (document.getElementById) {
        form_obj = eval("document.getElementById('" + obj_id + "')");
    }else if (document.all) {
        form_obj = eval("document.all." + obj_id);
    }else if (document.layer) {
        form_obj = eval("document." + obj_id);
    }else {
        return false;
    }

    content = form_obj.value;
    window.open('dictionary.php?webtag=' + webtag + '&obj_id=' + obj_id + '&content=' + content, 'spellcheck','width=450, height=550, scrollbars=1');
}

function updateFormObj(obj_id, content) {

    var form_obj;
    
    content = unescape(content);

    if (document.getElementById) {
        form_obj = eval("document.getElementById('" + obj_id + "')");
    }else if (document.all) {
        form_obj = eval("document.all." + obj_id);
    }else if (document.layer) {
        form_obj = eval("document." + obj_id);
    }else {
        return false;
    }

    form_obj.value = content;
}
