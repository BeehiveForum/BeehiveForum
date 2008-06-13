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

/* $Id: pm.js,v 1.22 2008-06-13 19:53:31 decoyduck Exp $ */

var pm_logon_search = false;

var pm_timeout;

var pm_notification = new xml_http_request();

function pmToggleAll()
{
    for (var i = 0; i < document.pm.elements.length; i++) {

        if (document.pm.elements[i].type == 'checkbox') {

            if (document.pm.toggle_all.checked == true) {

                document.pm.elements[i].checked = true;

            }else {

                document.pm.elements[i].checked = false;
            }
        }
    }
}

function openRecipientSearch(webtag, obj_name)
{
    if (typeof pm_logon_search == 'object' && !pm_logon_search.closed) {
    
        pm_logon_search.focus();

    }else {

        var form_obj = getObjsByName(obj_name)[0];

        if (typeof form_obj == 'object') {

            pm_logon_search = window.open('search_popup.php?webtag=' + webtag + '&allow_multi=1&type=1&search_query=' + form_obj.value + '&obj_name='+ obj_name, 'pm_logon_search', 'width=550, height=400, toolbar=0, location=0, directories=0, status=0, menubar=0, resizable=yes, scrollbars=yes');
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

function checkToRadio(num)
{
    var to_radio_obj = getObjsByName('to_radio');

    if (typeof to_radio_obj[num] == 'object') {
        to_radio_obj[num].checked = true;
    }
}

function pm_notification_initialise()
{
    pm_timeout = setTimeout('pm_notification_check_messages()', 2000);
    return true;
}

function pm_notification_check_messages()
{
    clearTimeout(pm_timeout);
    pm_notification.set_handler(pm_notification_handler);
    pm_notification.get_url('pm.php?webtag=' + webtag + '&check_messages=true');
}

function pm_notification_abort()
{
    pm_notification.abort();
    pm_notification.close();
    delete pm_notification;
}

function pm_notification_handler()
{
    var response_xml = pm_notification.get_response_xml();
    var pm_message_count_obj = getObjById('pm_message_count');

    if (typeof(pm_message_count_obj) == 'object' && pm_message_count_obj.getElementsByTagName) {

        var pm_unread_element = response_xml.getElementsByTagName('unread')[0];
        var pm_new_element = response_xml.getElementsByTagName('new')[0];

        if (typeof(pm_unread_element) == 'object' && typeof(pm_new_element) == 'object') {

            var pm_unread_count = pm_unread_element.childNodes[0].nodeValue;
            var pm_new_count = pm_new_element.childNodes[0].nodeValue;

            if (pm_new_count > 0) {
               pm_message_count_obj.innerHTML = '[' + pm_new_count + ' ' + lang['new'] + ']';
            }else if (pm_unread_count > 0) {
               pm_message_count_obj.innerHTML = '[' + pm_unread_count + ' ' + lang['unread'] + ']';
            }
        }
    }

    var message_array = response_xml.getElementsByTagName('notification')[0];

    if (typeof(message_array) == 'object') {

        var message_display_text = message_array.childNodes[0].nodeValue;

        if (message_display_text.length > 0) {

            if (window.confirm(message_display_text)) {

                top.frames[bh_frame_main].location.replace('pm.php?webtag=' + webtag);
            }
        }
    }
    return true;
}