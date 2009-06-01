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

/* $Id: post.js,v 1.55 2009-06-01 20:51:01 decoyduck Exp $ */

var search_logon = false;
var menu_timeout = 0;

function checkToRadio(num)
{
    var to_radio_obj = getObjsByName('to_radio');
   
    if (typeof to_radio_obj[num] == 'object') {
        to_radio_obj[num].checked = true;
    }
}

function openLogonSearch(webtag, obj_name)
{
    if (typeof search_logon == 'object' && !search_logon.closed) {

        search_logon.focus();
    
    }else {
    
        var form_obj = getObjsByName(obj_name)[0];

        if (typeof form_obj == 'object') {
        
            search_logon = window.open('search_popup.php?webtag=' + webtag + '&type=1&selection=' + form_obj.value + '&obj_name=' + obj_name, 'search_logon', 'width=550, height=400, toolbar=0, location=0, directories=0, status=0, menubar=0, resizable=yes, scrollbars=yes');
        }
    }

    return false;
}

function returnSearchResult(obj_name, content)
{
    var form_obj = getObjsByName(obj_name)[0];

    if (typeof form_obj == 'object') {

        form_obj.value = content;

        var to_radio_obj = getObjsByName('to_radio');

        if (to_radio_obj.length > 0) {
            to_radio_obj[to_radio_obj.length - 1].checked = true;
        }

        return true;
    }

    return false;
}

function delayPostMenuClickHandler()
{
    menu_timeout = setTimeout('attachPostMenuClickHandler()', 100);
}

function attachPostMenuClickHandler()
{
    clearTimeout(menu_timeout);
    
    if (document.attachEvent) {
        document.attachEvent('onclick', closePostOptions);
    }else {
        document.addEventListener('click', closePostOptions, true);
    }
}

function cancelPostMenuClickHandler()
{
    if (document.detachEvent) {    
        document.detachEvent('onclick', closePostOptions);
    }else {
        document.removeEventListener('click', closePostOptions, false);
    }
}

function closePostOptions()
{
    var div_tags  = document.getElementsByTagName('div');
    var div_count = div_tags.length;

    for (var i = 0; i < div_count; i++)  {

        if (div_tags[i].className == 'post_options_container_opened') {                    

            div_tags[i].className = 'post_options_container_closed';
        }
    }

    cancelPostMenuClickHandler();
}

function openPostOptions(post_id)
{
    var IE = (document.all ? true : false);

    closePostOptions();
    
    var post_options_obj = getObjById('post_options_' + post_id);
    var post_options_container_obj = getObjById('post_options_container_' + post_id);

    if (typeof post_options_obj == 'object' && typeof post_options_container_obj == 'object') {

        if (post_options_container_obj.className == 'post_options_container_closed') {

            post_options_container_obj.style.left = '100px';

            post_options_container_obj.className = 'post_options_container_opened';

            post_options_container_obj.style.width = '0px';
            post_options_container_obj.style.height = '0px';

            if (IE) {

                var scroll_width = parseInt(post_options_container_obj.scrollWidth);

                while (parseInt(post_options_container_obj.scrollWidth) > scroll_width) {
                    scroll_width = parseInt(post_options_container_obj.scrollWidth);
                }

                var scroll_height = parseInt(post_options_container_obj.scrollHeight);

                while (parseInt(post_options_container_obj.scrollHeight) > scroll_height) {
                    scroll_height = parseInt(post_options_container_obj.scrollHeight);
                }

            }else {

                var scroll_width = post_options_container_obj.scrollWidth;
                var scroll_height = post_options_container_obj.scrollHeight;            
            }

            post_options_container_obj.style.width = scroll_width + 'px';
            post_options_container_obj.style.height = scroll_height + 'px';
            post_options_container_obj.style.overflow = 'hidden';

            var container_left = findPosX(post_options_obj);
            var container_top = findPosY(post_options_obj);

            container_top  = post_options_obj.height + container_top;
            container_left = (container_left - post_options_container_obj.scrollWidth) + post_options_obj.width;

            post_options_container_obj.style.left = container_left + 'px';
            post_options_container_obj.style.top = container_top + 'px';

            delayPostMenuClickHandler();
        }
    }
}

function toggleQuickReply(tid, message_id)
{
    var quick_reply_container = getObjById('quick_reply_container');

    var quick_reply_position = getObjById('quick_reply_' + message_id);

    if (typeof(quick_reply_container) == 'object' && typeof(quick_reply_position) == 'object') {

        if (quick_reply_container.parentNode.id != quick_reply_position.id) {

            quick_reply_position.appendChild(quick_reply_container);

            showQuickReply(tid, message_id);

        }else {

            if (quick_reply_container.className == 'quick_reply_container_closed') {

                showQuickReply(tid, message_id);

            }else {

                hideQuickReply();
            }
        }
    }
}

function showQuickReply(tid, message_id)
{
    var quick_reply_container = getObjById('quick_reply_container');

    var quick_reply_header = getObjById('quick_reply_header');

    var quick_reply_content = getObjsByName('t_content')[0];

    var quick_reply_pid = getObjsByName('t_rpid')[0];

    var quick_reply_post_button = getObjsByName('post')[0];

    if (typeof(quick_reply_container) == 'object' && typeof(quick_reply_pid) == 'object') {

        if (typeof(quick_reply_content) == 'object' && typeof(quick_reply_post_button) == 'object') {
            
            if (typeof(quick_reply_header) == 'object' || typeof(quick_reply_header) == 'function') {
            
                if (parseInt(message_id) > 0 && parseInt(tid) > 0) {

                    quick_reply_header.innerHTML = '#' + parseInt(tid) + '.' + parseInt(message_id);

                }else {

                    quick_reply_header.innerHTML = '';
                }
            }

            quick_reply_container.className = 'quick_reply_container_opened';

            quick_reply_pid.value = message_id;

            quick_reply_content.value = '';

            quick_reply_content.focus();

            quick_reply_post_button.scrollIntoView(false);
        }
    }
}

function hideQuickReply()
{
    var quick_reply_container = getObjById('quick_reply_container');

    if (typeof(quick_reply_container) == 'object' || typeof(quick_reply_container) == 'function') {

        if (quick_reply_container.className == 'quick_reply_container_opened') {

           quick_reply_container.className = 'quick_reply_container_closed';
        }
    }
}

function checkKeyPress(evt)
{
    var key = (evt.which || evt.keyCode);
    
    if (evt.ctrlKey && (key == 13 || key == 10)) {
    
        var quick_reply_post_button = getObjsByName('post')[0];

        if (typeof(quick_reply_post_button) == 'object' || typeof(quick_reply_post_button) == 'function') {

            if (validateQuickReply()) {

                quick_reply_post_button.click();
            }
        }   
    }
}

function validateQuickReply()
{
    var quick_reply_content = getObjsByName('t_content')[0];

    if (typeof(quick_reply_content) == 'object' || typeof(quick_reply_content) == 'function') {
        return quick_reply_content.value.trim().length > 0;
    }

    return false;
}

function registerQuickReplyHotKey()
{
    var quick_reply_content = getObjsByName('t_content')[0];

    if (document.attachEvent) {
        quick_reply_content.attachEvent('onkeypress', function(evt) { checkKeyPress(evt) });
    }else {
        quick_reply_content.addEventListener('keypress', checkKeyPress, true);
    }
}