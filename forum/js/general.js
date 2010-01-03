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

/* $Id: general.js,v 1.47 2010-01-03 15:19:36 decoyduck Exp $ */

var beehive = {

    window_options : [ 'toolbox=0',
                       'location=0',
                       'directories=0',
                       'status=0',
                       'menubar=0',
                       'resizeable=yes',
                       'scrollbars=yes' ]
}

$(document).ready(function() {

    $.ajaxSetup({
        cache: false
    });

    var process_frames = function(context, callback) {

        if (!$('frame', context).length) return;

        $('frame', context).each(function() {

            process_frames(this.contentDocument, callback);
            callback.call(this);
        });
    }

    $.getJSON('json_data.php', { 'webtag' : webtag }, function(data) {
        if (data.valid) beehive = $.extend({}, beehive, data);
    });

    $('.move_up_ctrl_disabled, .move_down_ctrl_disabled').bind('click', function() {
        return false;
    });

    $('#thread_mode').bind('change', function() {
        $(this).closest('form').submit();
    });

    $('a.popup').bind('click', function() {

        var class_names = $(this).attr('class').split(' ');

        var window_options = beehive.window_options;

        for (var key in class_names) {

            if (dimensions = /^([0-9]+)x([0-9]+)$/.exec(class_names[key])) {

                window_options.unshift('width=' + dimensions[1], 'height=' + dimensions[2]);
            }
        }

        window.open($(this).attr('href'), $(this).attr('id'), window_options.join(','));

        return false;
    });

    $('button.close_popup').bind('click', function() {
        window.close();
    });

    var check_overflow = function() {

        $('td.postbody').each(function() {

            if ($(this).find('div.overflow_fix').length > 0) {

                $(this).find('div.overflow_fix').css('width', $('body').attr('clientWidth') * 0.95);

            } else {

                if ($(this).width() > $('body').attr('clientWidth')) {

                    var $overflow_container = $('<div class="overflow_fix"></div>');

                    $overflow_container.html($(this).html());

                    $overflow_container.css('width', $('body').attr('clientWidth') * 0.95);
                    $overflow_container.css('overflow', 'auto');

                    $(this).html($overflow_container);
                }
            }
        });
    }

    var resize_images = function() {

        $('td.postbody img').each(function() {

            $image = $(this);

            if ($(this).parent('span.resized_image').length > 0) {

                $(this).parent('span.resized_image').css('width', $('body').attr('clientWidth') * 0.95);

            } else {

                if ($(this).width() > $('body').attr('clientWidth')) {

                    $(this).wrap('<span class="resized_image"></span>');

                    $parent_span = $(this).parent('span.resized_image');

                    $parent_span.prepend('<span class="resize_banner"></span>');

                    $resize_banner = $parent_span.find('span.resize_banner');

                    $parent_span.css( { 'display' : 'block',
                                        'width' : $('body').attr('clientWidth') * 0.95 } );

                    $image.css('width', '100%');

                    $resize_banner.html('Image Resized').css('display', 'block');

                    $resize_banner.bind('click', function() {
                        console.log($image.attr('src'));
                        window.open($image.attr('src'));
                    });
                }
            }
        });
    }

    $(window).bind('resize', function() {

        resize_images();

        check_overflow();
    });

    resize_images();

    check_overflow();

    $('select.user_in_thread_dropdown').bind('change', function() {
        $('input[name="to_radio"][value="in_thread"]').attr('checked', true);
    });

    $('select.recent_user_dropdown').bind('change', function() {
        $('input[name="to_radio"][value="recent"]').attr('checked', true);
    });

    $('input.post_to_others').bind('focus', function() {
        $('input[name="to_radio"][value="others"]').attr('checked', true);
    });

    $('input#toggle_all').bind('click', function() {
        $(this).closest('form').find('input:checkbox').attr('checked', $(this).attr('checked'));
    });

    $('a.font_size').live('click', function() {

        $parent = $(this).closest('td');

        $.getJSON($(this).attr('href'), { 'json' : true }, function(data) {

            if (!data.success) return false;

            $parent.html(data.html);

            top.document.body.rows = '60,' + Math.max(data.font_size * 2, 22) + ',*';

            process_frames(top.document.body, function() {

                var $head = $(this.contentDocument).find('head');

                $.ajax({
                    'url' : 'font_size.php',
                    'data' : { 'webtag' : webtag },
                    'success' : function(data) {
                        $head.find('style[title="user_font"]').html(data).appendTo($head);
                    }
                });
            });
        });

        return false;
    });
});