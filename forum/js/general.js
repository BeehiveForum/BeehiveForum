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

/* $Id: general.js,v 1.31 2007-10-16 17:09:23 decoyduck Exp $ */

var IE = (document.all ? true : false);

function forumGetURL()
{
    var domain = document.domain;
    var pathname = location.pathname.substring(0, location.pathname.lastIndexOf('\/') + 1);
    
    return domain + pathname;
}

function disableButton(button)
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

function enableButton(button)
{
    button.className = 'button';
    
    if (document.all || document.getElementById) {
        button.disabled = false;
    }else if (button) {
        button.onclick = button.oldonclick;
    }

    return true;
}

function getObjById(obj_id)
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

function getObjsByName(obj_name)
{
    var form_obj;

    if (document.getElementsByName) {
        form_obj = eval("document.getElementsByName('" + obj_name + "')");
    }else if (document.all) {
        form_obj = eval("document.all." + obj_name);
    }else if (document.layer) {
        form_obj = eval("document." + obj_name);
    }else {
        return false;
    }

    return form_obj;
}

function getImageMaxWidth()
{
    if (typeof(document.maxWidth) != 'undefined' && document.maxWidth > 0) {
        return document.maxWidth;
    }

    var body_tag = document.getElementsByTagName('body');
    return body_tag[0].clientWidth;
}

function getImageResizeText()
{
    if (typeof(document.resizeText) != 'undefined' && document.resizeText.length > 0) {
        return unescape(document.resizeText);
    }

    return 'This image has been resized (original size %1$sx%2$s). To view the full-size image click here.';
}

function addOverflow()
{
    var body_tag = document.getElementsByTagName('body');
    var body_tag = body_tag[0];

    var td_tags = document.getElementsByTagName('td');
    var td_count = td_tags.length;

    var maxWidth = getImageMaxWidth();

    resizeImages();

    for (var i = 0; i < td_count; i++)  {

        if (td_tags[i].className == 'postbody') {
            
            if (td_tags[i].clientWidth >= maxWidth) {

                if (typeof(td_tags[i].resized) == 'undefined') {
                
                    var new_div = document.createElement('div');

                    if (IE) {

                        new_div.style.overflowX = 'scroll';
                        new_div.style.overflowY = 'auto';

                    }else {

                        new_div.style.overflow = 'auto';
                    }

                    new_div.className = 'bhoverflowfix';

                    td_tags[i].style.width = (maxWidth * 0.94) + 'px';
                    new_div.style.width = (maxWidth * 0.94) + 'px';

                    while (td_tags[i].hasChildNodes()) {
                        new_div.appendChild(td_tags[i].firstChild);
                    }

                    td_tags[i].appendChild(new_div);
                
                }else {

                    alert(td_tags[i].width);
                }
            }
        }
    }

    if (IE) {
    
        window.attachEvent("onresize", redoOverFlow);

    }else {
    
        window.addEventListener("resize", redoOverFlow, true);
    }
}

function redoOverFlow()
{
    var body_tag = document.getElementsByTagName('body');
    var body_tag = body_tag[0];

    var td_tags = document.getElementsByTagName('td');
    var td_count = td_tags.length;

    var maxWidth = getImageMaxWidth();

    resizeImages();

    for (var i = 0; i < td_count; i++)  {

        if (td_tags[i].className == 'postbody') {
            
            td_tags[i].style.width = (maxWidth * 0.94) + 'px';
            
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

function attachListener(obj, img_id)
{
    if (document.all) {
        obj.attachEvent('onclick', function() { popupImage(img_id) } );
    }else {
        obj.addEventListener('click', function() { popupImage(img_id) }, true);
    }
}

function resizeImages()
{
    var forum_url = forumGetURL();
    
    var body_tag = document.getElementsByTagName('body');
    var body_tag = body_tag[0];

    var img_tags = document.getElementsByTagName('img');
    var img_count = img_tags.length;

    for (var index = 0; index < img_count; index++)  {
        
        if ((img_tags[index].src.indexOf(forum_url)) < 0) {
        
            resizeImage(img_tags[index], index);
        }
    }
}

function resizeImage(img, index)
{
    if (typeof(img.original_width) == 'undefined') {

       img.original_width = img.width;
       img.original_height = img.height;
    }

    var maxWidth = getImageMaxWidth();

    var resizeText = getImageResizeText();

    if (img.original_width > maxWidth) {

        if (typeof(img.resize_container_id) == 'undefined') {
        
            // Give the image an ID to track it later
    
            img.id = 'image_resize_image_' + index;
    
            // Generate the info tip IDs.
    
            img.resize_container_id  = 'img_resize_container_' + index;
            img.resize_info_bar_id = 'img_resize_info_bar_' + index;
    
            // Generate the popup window ID.
    
            img.popup_id  = 'image_popup_' + index;

            // Create container div and assign it an id.

            var img_resize_container = document.createElement('div');
            img_resize_container.id = 'img_resize_container_' + index;

            // Create the info bar div

            var img_resize_info_bar = document.createElement('div');
            img_resize_info_bar.id = 'img_resize_info_bar_' + index;

            // Set the info bar class name

            img_resize_info_bar.className = 'image_resize_text';
   
            // Set up an onclick handler for the info bar
        
            attachListener(img_resize_info_bar, img.id);
        
            // Stick the original dimensions of the image in the text and
            // create the link to the full-sized image.
        
            var img_resize_icon = document.createElement('img');
            var img_resize_text = document.createTextNode(unescape(resizeText.replace('%1$s', img.original_width).replace('%2$s', img.original_height)));
        
            // Set up the link and the image.
        
            img_resize_icon.setAttribute('src', 'images/warning.png');
            img_resize_icon.setAttribute('alt', '');
            img_resize_icon.className = 'image_resize_icon';
        
            // Insert the icon into the icon column of the text row.
        
            img_resize_info_bar.appendChild(img_resize_icon);
        
            // Insert text into the text column of the text row
        
            img_resize_info_bar.appendChild(img_resize_text);
        
            // Get the original image's parent element.
        
            var parent_node = img.parentNode;
        
            // If the parent is an anchor tag we need to grab that to stick
            // inside our container div so as to prevent the links from breaking.
        
            if (parent_node.tagName.toLowerCase() == 'a') {
        
                var child_node = parent_node;
                parent_node = parent_node.parentNode;
        
                parent_node.insertBefore(img_resize_container, child_node.nextSibling);
                img_resize_container.appendChild(child_node);
        
            }else {
        
                parent_node.insertBefore(img_resize_container, img.nextSibling);
                img_resize_container.appendChild(img);
            }
        
            // Insert the info bar div into the container div.
        
            img_resize_container.appendChild(img_resize_info_bar);

            // Resize the image container

            img_resize_container.style.width = Math.round(maxWidth * 0.8) + 'px';

            // Resize the image to fill the container div

            img.style.width = '100%';
                    
        }else {

            if (img_resize_container = getObjById(img.resize_container_id)) {              
                img_resize_container.style.width = Math.round(maxWidth * 0.8) + 'px';
            }

            if (img_resize_info_bar = getObjById(img.resize_info_bar_id)) {
                img_resize_info_bar.style.display = 'block';
            }
        }
    
    }else if (typeof(img.resize_info_bar_id) != 'undefined') {

        if (img_resize_container = getObjById(img.resize_container_id)) {
            img_resize_container.style.width = img.original_width + 'px';
        }
        
        if (img_resize_info_bar = getObjById(img.resize_info_bar_id)) {
            img_resize_info_bar.style.display = 'none';
        }
    }
}    

function popupImage(img_id)
{   
    var img_obj = document.getElementById(img_id);
   
    if (typeof(img_obj.popup_window) == 'undefined') img_obj.popup_window = false;

    if (!img_obj.popup_window.closed && img_obj.popup_window.location) {

        img_obj.popup_window.focus();

    }else {

        img_obj.popup_window = window.open(img_obj.src);
        img_obj.popup_window.id = img_obj.popup_id;
    }

    return false;
}
