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

/* $Id: spoiler.js,v 1.4 2007-04-23 20:51:23 decoyduck Exp $ */

function spoilerInitialise()
{
    var IE = (document.all ? true : false);

    var div_tags = document.getElementsByTagName('div');
    var div_count = div_tags.length;

    var div_child_array = new Array();
    var div_child_count = new Array();

    for (var i = 0; i < div_count; i++)  {

        if (div_tags[i].className == 'spoiler') {

            spoilerAttachEvent(div_tags[i]);
            spoilerProcessChildren(div_tags[i]);
        }
    }
}

function spoilerAttachEvent(element)
{
    if (is_defined(element.tagName)) {
        
        if (IE) {

            element.attachEvent("onmouseover", spoilerReveal);
            element.attachEvent("onmouseout", spoilerHide);

        }else {

            element.addEventListener("mouseover", spoilerReveal, true);
            element.addEventListener("mouseout", spoilerHide, true);
        }
    }
}

function spoilerProcessChildren(element)
{
    var element_child_array = element.childNodes;
    var element_child_count = element_child_array.length;

    for (var i = 0; i < element_child_count; i++) {

        spoilerAttachEvent(element_child_array[i]);
        spoilerProcessChildren(element_child_array[i]);
    }
}

function spoilerReveal(evt) {
    
    if (window.event) {
        if (window.event.srcElement.className == 'spoiler') {
            window.event.srcElement.className = 'spoiler_reveal';
        }
    }else if (evt.target) {                  
        if (evt.target.className == 'spoiler') {
            evt.target.className = 'spoiler_reveal';
        }
    }
}

function spoilerHide(evt) {
    
    if (window.event) {
        if (window.event.srcElement.className == 'spoiler_reveal') {
            window.event.srcElement.className = 'spoiler';
        }
    }else if (evt.target) {
        if (evt.target.className == 'spoiler_reveal') {
            evt.target.className = 'spoiler';
        }
    }
}
