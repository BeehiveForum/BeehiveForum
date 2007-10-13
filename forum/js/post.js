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

/* $Id: post.js,v 1.37 2007-10-13 00:21:40 decoyduck Exp $ */

var search_logon = false;
var menu_timeout = 0;

function checkToRadio(num)
{
    document.f_post.to_radio[num].checked=true;
}

function openLogonSearch(webtag, obj_name)
{
    if (typeof search_logon == 'object' && !search_logon.closed) {

        search_logon.focus();
    
    }else {
    
        if (form_obj = getObjByName(obj_name)) {
        
            search_logon = window.open('search_popup.php?webtag=' + webtag + '&type=1&search_query=' + form_obj.value + '&obj_name=' + obj_name, 'search_logon', 'width=500, height=400, toolbar=0, location=0, directories=0, status=0, menubar=0, resizable=yes, scrollbars=yes');
        }
    }

    return false;
}

function returnSearchResult(obj_name, content)
{
    if (form_obj = getObjByName(obj_name)) {

        form_obj.value = content;

        var to_radio_obj = document.getElementsByName('to_radio');
        to_radio_obj[to_radio_obj.length - 1].checked = true;

        return true;
    }

    return false;
}

function findPosX(obj)
{
    var curleft = 0;

    if (obj.offsetParent) {
        
        while(1) {

            curleft += obj.offsetLeft;

            if(!obj.offsetParent) break;
            obj = obj.offsetParent;
        }

    }else if(obj.x) {

        curleft += obj.x;
    }
    
    return curleft;
}

function findPosY(obj)
{
    var curtop = 0;

    if (obj.offsetParent) {
        
        while(1) {

            curtop += obj.offsetTop;
            if(!obj.offsetParent) break;
            obj = obj.offsetParent;
        }

    } else if(obj.y) {
        
        curtop += obj.y;
    }

    return curtop;
}

function delayMenuClickHandler()
{
    menu_timeout = setTimeout('attachMenuClickHandler()', 100);
}

function attachMenuClickHandler()
{
    clearTimeout(menu_timeout);
    
    if (document.all) {
        document.attachEvent('onclick', closePostOptions);
    }else {
        document.addEventListener('click', closePostOptions, true);
    }
}

function cancelMenuClickHandler()
{
    if (document.all) {    
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

    cancelMenuClickHandler();
}

function openPostOptions(post_id)
{
    var IE = (document.all ? true : false);

    closePostOptions();
    
    if (post_options_obj = getObjById('post_options_' + post_id)) {
    
        if (post_options_container_obj = getObjById('post_options_container_' + post_id)) {

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

                delayMenuClickHandler();
            }
        }
    }
}
