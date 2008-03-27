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

/* $Id: search.js,v 1.25 2008-03-27 21:50:27 decoyduck Exp $ */

var search_stop_words = false;
var search_logon = false;

function searchFormSubmit()
{
    var search_form = getObjById('search_form');

    var search_submit = getObjsByName('search_submit')[0];
    var search_reset = getObjsByName('search_reset')[0];

    if ((typeof search_form == 'object') && (typeof search_submit == 'object')) {

        disableButton(search_submit);
	disableButton(search_reset);

        search_form.submit();
    }
}

function displayMysqlStopwords(webtag, keywords)
{
    if (typeof search_thread == 'object' && !search_thread.closed) {
        search_stop_words.focus();
    }else {
        search_stop_words = window.open('search.php?webtag=' + webtag + '&show_stop_words=true&keywords=' + keywords, 'show_stop_words', 'width=580, height=450, scrollbars=yes, resizable=yes, scrolling=yes');
    }

    return false;
}

function openLogonSearch(webtag, obj_name)
{
    if (typeof search_thread == 'object' && !search_thread.closed) {

        search_logon.focus();

    }else {

        var form_obj = getObjsByName(obj_name)[0];
        
        if (typeof form_obj == 'object') {

            search_logon = window.open('search_popup.php?webtag=' + webtag + '&type=1&search_query=' + form_obj.value + '&obj_name='+ obj_name, 'search_logon', 'width=550, height=400, toolbar=0, location=0, directories=0, status=0, menubar=0, resizable=yes, scrollbars=yes');
        }
    }

    return false;
}

function returnSearchResult(obj_name, content)
{
    var form_obj = getObjsByName(obj_name)[0];

    if (typeof form_obj == 'object') {

        if (form_obj.value.length == 0) {

            form_obj.value = content;
            return true;

        }else {

            var content_array = form_obj.value.split(';');
            var content_array_unique = new Array();

            content_array[content_array.length] = content;
            content_array = content_array.unique();
            
            form_obj.value = content_array.join(';');1
            return true;
        }
    }

    return false;
}
