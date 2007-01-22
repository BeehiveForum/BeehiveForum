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

                        // Required table elements: table, tbody, tr and td

                        var img_resize_table = document.createElement('table');
                        var img_resize_table_body = document.createElement('tbody');

                        var img_resize_table_row_txt = document.createElement('tr');
                        var img_resize_table_row_img = document.createElement('tr');

                        var img_resize_table_cell_txt = document.createElement('td');
                        var img_resize_table_cell_img = document.createElement('td');

                        // Assign the classes to the relevant table cells.

                        img_resize_table.className = 'image_resize_container';
                        img_resize_table_cell_txt.className = 'image_resize_text';
                        img_resize_table_cell_img.className = 'image_resize_image';

                        // Create the link to the full-sized image

                        var img_resize_link = document.createElement('a');
                        var img_resize_icon = document.createElement('img');
                        var img_resize_text = document.createTextNode(resizeText);
                        var img_resize_spcr = document.createTextNode(' ');

                        // Set up the link and the image.

                        img_resize_link.setAttribute('target', '_blank');                        
                        img_resize_link.setAttribute('href', img_tags[i].getAttribute('src'));

                        img_resize_icon.setAttribute('src', 'images/warning.png');
                        img_resize_icon.setAttribute('alt', '');

                        // Assign the notification icon a class so it can be customised.

                        img_resize_icon.className = 'image_resize_icon';

                        // Insert the icon, spacer and text into the link.

                        img_resize_link.appendChild(img_resize_icon);
                        img_resize_link.appendChild(img_resize_spcr);
                        img_resize_link.appendChild(img_resize_text);

                        // Insert the link into the relevant table cell.

                        img_resize_table_cell_txt.appendChild(img_resize_link);

                        // Resize the original image.

                        img_tags[i].style.width = Math.round(maxWidth * 0.9) + 'px';

                        // Get the original image's parent element.

                        var parent_node = img_tags[i].parentNode;

                        // If the parent is an anchor tag we need to grab that to stick
                        // inside our table cell so as to prevent the links from breaking.
                        // Either way we need to add the table to the page and move
                        // the original image into the other table cell we created.

                        if (parent_node.tagName.toUpperCase() == 'A') {
                            
                            var child_node = parent_node;
                            parent_node = parent_node.parentNode;
                            
                            parent_node.insertBefore(img_resize_table, child_node.nextSibling);
                            img_resize_table_cell_img.appendChild(child_node);
                        
                        }else {

                            parent_node.insertBefore(img_resize_table, img_tags[i].nextSibling);
                            img_resize_table_cell_img.appendChild(img_tags[i]);
                        }

                        // Insert the cells into the table rows.
                        
                        img_resize_table_row_txt.appendChild(img_resize_table_cell_txt);
                        img_resize_table_row_img.appendChild(img_resize_table_cell_img);

                        // Insert the rows into the table body.

                        img_resize_table_body.appendChild(img_resize_table_row_img);
                        img_resize_table_body.appendChild(img_resize_table_row_txt);

                        // Finally (!) insert the table body into the table.

                        img_resize_table.appendChild(img_resize_table_body);
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
