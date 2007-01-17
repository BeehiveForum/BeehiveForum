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

function disable_button(button)
{
    button.className = 'button_disabled';
    
    if (document.all || document.getElementById) {
        button.disabled = true;
    }else if (button) {
        button.oldonclick = button.onclick;
        button.onclick = null;
    }

    return true;
}

function enable_button(button)
{
    button.className = 'button';
    
    if (document.all || document.getElementById) {
        button.disabled = false;
    }else if (button) {
        button.onclick = button.oldonclick;
    }

    return true;
}

function submit_form(form)
{
    var form_obj;

    if (document.getElementById) {
        form_obj = eval("document.getElementById('" + form + "')");
    }else if (document.all) {
        form_obj = eval("document.all." + form);
    }else if (document.layer) {
        form_obj = eval("document." + form);
    }else {
        return false;
    }
    
    form_obj.submit();
}        

function is_numeric(value)
{
   if ((isNaN(value)) || (value.length == 0)) return false;
   return true;
}

function is_defined(var_name)
{
   if (typeof(var_name) !="undefined") return true;
   return false;
}

function addOverflow(maxWidth)
{
        var IE = (document.all ? true : false);
        
        var body_tag = document.getElementsByTagName('body');
        var body_tag = body_tag[0];

        var td_tags = document.getElementsByTagName('td');
        var td_count = td_tags.length;

        if (!is_numeric(maxWidth)) {
            maxWidth = body_tag.clientWidth;
        }

        for (var i = 0; i < td_count; i++)  {

                if (td_tags[i].className == 'postbody') {
                        
                        if (td_tags[i].clientWidth >= maxWidth) {

                                var new_div = document.createElement('div');

                                new_div.style.overflowX = 'scroll';
                                new_div.style.overflowY = 'auto';

                                new_div.style.overflow = 'auto';

                                new_div.className = 'bhoverflowfix';
                        
                                new_div.style.width = (maxWidth * 0.94) + 'px';

                                while (td_tags[i].hasChildNodes()) {
                                        new_div.appendChild(td_tags[i].firstChild);
                                }

                                td_tags[i].style.width = (maxWidth * 0.98) + 'px';
                                td_tags[i].appendChild(new_div);
                        }
                }
        }

        if (IE) {
        
                window.attachEvent("onresize", function () { redoOverFlow(maxWidth) });
        }else {
        
                window.addEventListener("resize", function () { redoOverFlow(maxWidth) }, true);
        }
}

function redoOverFlow(maxWidth)
{
        var body_tag = document.getElementsByTagName('body');
        var body_tag = body_tag[0];

        var td_tags = document.getElementsByTagName('td');
        var td_count = td_tags.length;

        if (!is_numeric(maxWidth)) {
            maxWidth = body_tag.clientWidth;
        }

        for (var i = 0; i < td_count; i++)  {

                if (td_tags[i].className == 'postbody') {
                        
                        td_tags[i].style.width = (maxWidth * 0.98) + 'px';
                        
                        var div_tags = td_tags[i].getElementsByTagName('div');
                        var div_count = div_tags.length;

                        for (var j = 0; j < div_count; j++)  {

                                if (div_tags[j].className == 'bhoverflowfix') {

                                        div_tags[j].style.width = (maxWidth * 0.94) + 'px';
                                }
                        }
                }
        }
}

function resizeImages(maxWidth, resizeText)
{
        var body_tag = document.getElementsByTagName('body');
        var body_tag = body_tag[0];

        var img_tags = document.getElementsByTagName('img');
        var img_count = img_tags.length;

        if (!is_numeric(maxWidth) || maxWidth == 0) {
            maxWidth = body_tag.clientWidth;
        }

        if (!is_defined(resizeText)) {
            resizeText = 'This image has been resized. To view the full-size image click here.';
        }

        for (var i = 0; i < img_count; i++)  {

                if (img_tags[i].width >= maxWidth) {
                       
                        img_tags[i].style.width = Math.round(maxWidth * 0.9) + 'px';

                        var line_break = document.createElement('br');
                        var img_resize_link = document.createElement('a');

                        img_resize_link.setAttribute('target', '_blank');                        
                        img_resize_link.setAttribute('href', img_tags[i].getAttribute('src'));

                        img_resize_link.innerHTML = resizeText;

                        var parent_node = img_tags[i].parentNode;

                        if (parent_node.tagName.toUpperCase() == 'A') {
                            
                            var child_node = parent_node;

                            parent_node = parent_node.parentNode;

                            parent_node.insertBefore(img_resize_link, child_node.nextSibling);
                            parent_node.insertBefore(line_break, child_node.nextSibling);
                        
                        }else {

                            parent_node.insertBefore(img_resize_link, img_tags[i].nextSibling);
                            parent_node.insertBefore(line_break, img_tags[i].nextSibling);
                        }                        
                }
        }
}

function getFormObj(obj_id)
{
    var form_obj;

    if (document.getElementById) {
        form_obj = eval("document.getElementById('" + obj_id + "')");
    }else if (document.all) {
        form_obj = eval("document.all." + obj_id);
    }else if (document.layer) {
        form_obj = eval("document." + obj_id);
    }else {
        return false;
    }

    return form_obj;
}
