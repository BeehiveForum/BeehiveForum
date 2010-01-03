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

/* $Id: post.js,v 1.56 2010-01-03 15:19:36 decoyduck Exp $ */

$(document).ready(function() {

   $('.post_options_link').bind('click', function() {

       var $post_options_container = $('#post_options_container_' + $(this).attr('rel'));

       if ($post_options_container.length != 1) return;

       var link_offset = $(this).offset();

       $post_options_container.show();

       var container_offset = $post_options_container.offset();

       if (($post_options_container.height() + container_offset.top) > $(window).height()) {
           $post_options_container.css('top', link_offset.top - $post_options_container.height());
       } else {
           $post_options_container.css('top', link_offset.top + $(this).height());
       }

       $post_options_container.find('*').css('margin-left', 0);
       $post_options_container.css('left', link_offset.left - ($post_options_container.width() - $(this).width()));

       return false;
   });

   $('body').bind('click', function(e) {

       if ($(e.target).closest('div.post_options_container').length < 1) {

           $('.post_options_container').hide();
           $('.post_options_container').find('*').css('margin-left', -9999);
       }
   });

   $('#quick_reply_container #t_content').bind('keyup', function(e) {

       if ($(this).val().trim().length < 1) return;

       if (e.ctrlKey && e.which == 13) {

           $('#quick_reply_container button#post').click();
       }
   });

   $('#quick_reply_container button#post').bind('click', function() {
       if ($(this).val().trim().length < 1) return false;
   });

   $('#quick_reply_container button#cancel').bind('click', function() {
       $('#quick_reply_container').hide();
   });

   $('.quick_reply_link').bind('click', function() {

       $('.post_options_container').hide();

       $('.post_options_container').find('*').css('margin-left', -9999);

       var quick_reply_data = /^([0-9]+)\.([0-9]+)$/.exec($(this).attr('rel'));

       if (quick_reply_data.length != 3) return;

       $quick_reply_location = $('#quick_reply_' + quick_reply_data[2]);

       if ($quick_reply_location.length != 1) return;

       $('#quick_reply_container #t_rpid').val(quick_reply_data[2]);

       $('#quick_reply_container').appendTo($quick_reply_location).show();

       $('#quick_reply_container #t_content').focus();

       $('#quick_reply_container #t_content').get(0).scrollIntoView(false);
   });
});

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