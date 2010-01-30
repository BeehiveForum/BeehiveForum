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

/* $Id: post.js,v 1.60 2010/01/24 20:07:10 decoyduck Exp $ */

$(beehive).bind('init', function() {

    beehive.quote_list = [];

    $('.post_options_link').bind('click', function() {

        var $link = $(this);
        
        var $post_options_container = $link.next('.post_options_container');

        if ($post_options_container.length != 1) return;
        
        if ($post_options_container.is(':visible')) return;

        var link_offset = $link.offset();

        $post_options_container.show();

        var container_offset = $post_options_container.offset();

        if (((container_offset.top - $(window).scrollTop()) + $post_options_container.height()) > $(window).height()) {
            $post_options_container.css('top', link_offset.top - $post_options_container.height());
        } else {
            $post_options_container.css('top', link_offset.top + $link.height());
        }

        $post_options_container.find('*').css('margin-left', 0);
        $post_options_container.css('left', link_offset.left - ($post_options_container.width() - $link.width()));

        return false;
    });

    $('body').bind('click', function(e) {

        if ($(e.target).closest('div.post_options_container').length < 1) {

            $('.post_options_container').each(function() {
                
                var $post_options_container = $(this);
                
                var $link = $(this).prev('a.post_options_link');
                
                if ($link.length != 1) return;
                
                var link_offset = $link.offset();
                
                $post_options_container.hide();
                
                $post_options_container.css('top', link_offset.top + $link.height());
                
                $post_options_container.find('*').css('margin-left', -9999);
            });
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

    $('a[id^="quote_"]').bind('click', function() {

        var pid = $(this).attr('rel');

        if ($.inArray(pid, beehive.quote_list) < 0) {

            $('img#quote_img_' + pid).attr('src', beehive.images['quote_enabled.png']);

            $(this).html(beehive.lang['unquote']);

            beehive.quote_list.push(pid);

        } else {

            $('img#quote_img_' + pid).attr('src', beehive.images['quote_disabled.png']);

            $(this).html(beehive.lang['quote']);

            for (var check_post_id in beehive.quote_list) {

                if (beehive.quote_list[check_post_id] == pid) {
                    beehive.quote_list.splice(check_post_id, 1);
                }
            }
        }

        $('a[id^="reply_"]').each(function() {

            var query_string = $.parseQuery($(this).attr('href').split('?')[1]);

            query_string['quote_list'] = beehive.quote_list.join(',');

            $(this).attr('href', 'post.php?' + $.param(query_string));
        });

        return false;
    });
});