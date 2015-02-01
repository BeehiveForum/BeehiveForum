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

$(top.window.beehive).bind('init', function () {

    //noinspection JSLint
    top.window.beehive.quote_list = [];

    function hide_post_options_containers() {

        $('.post_options_container').each(function () {

            var $post_options_container = $(this),
                $link = $(this).prev('span.post_options'),
                link_offset = $link.offset();

            $post_options_container.hide();

            $post_options_container.css('top', Math.floor(link_offset.top + $link.height()));

            $post_options_container.find('table').css('margin-left', -9999);
        });
    }

    function show_post_options_container() {

        var $link = $(this),
            $post_options_container = $link.next('.post_options_container'),
            container_offset = $post_options_container.offset(),
            link_offset = $link.offset();

        //noinspection JSValidateTypes
        if (((container_offset.top - $(window).scrollTop()) + $post_options_container.height()) > $(window).height()) {
            $post_options_container.css('top', Math.floor(link_offset.top - $post_options_container.height()));
        } else {
            $post_options_container.css('top', Math.floor(link_offset.top + $link.height()));
        }

        $post_options_container.find('*').css('margin-left', 0);
        $post_options_container.css('left', Math.floor(link_offset.left - ($post_options_container.width() - $link.width())));
        $post_options_container.show();
    }

    var $body = $('body');

    $body.on('click', '.message_vote_form span.vote', function (event) {

        var $button = $(this),
            $container = $button.closest('.message_vote_form');

        event.preventDefault();

        $.ajax({

            cache: true,

            data: {
                webtag: top.window.beehive.webtag,
                ajax: 'true',
                action: 'post_vote',
                post_rating: $button.hasClass('vote_up') ? 1 : -1,
                mobile: top.window.beehive.mobile_version ? 'Y' : 'N',
                msg: $container.data('msg')
            },

            url: top.window.beehive.forum_path + '/ajax.php',

            success: function (data) {

                try {

                    $container.html(data).show();

                } catch (exception) {

                    top.window.beehive.ajax_error(exception);
                }
            }
        });
    });

    $body.on('click', 'span.post_options', function (event) {

        var link = this,
            $link = $(link),
            options = $link.prop('id').match(/post_options_(\d+)_(\d+)_(\d+)/);

        if (!options) {
            return;
        }

        event.preventDefault();
        event.stopPropagation();

        hide_post_options_containers();

        if ($link.next('.post_options_container').length > 0) {

            show_post_options_container.call(this);
            return;
        }

        $.ajax({

            cache: true,

            data: {
                webtag: top.window.beehive.webtag,
                ajax: 'true',
                action: 'post_options',
                msg: options[1] + '.' + options[2],
                pid: options[3]
            },

            url: top.window.beehive.forum_path + '/ajax.php',

            success: function (data) {

                try {

                    $link.after(data);
                    show_post_options_container.call(link);

                } catch (exception) {

                    top.window.beehive.ajax_error(exception);
                }
            }
        });
    });

    $body.on('click', function () {
        hide_post_options_containers();
    });

    $body.on('click', '#quick_reply_container', function () {

        //noinspection JSLint
        if (CKEDITOR.instances.content) {
            CKEDITOR.instances.content.destroy();
        }

        $(this).hide();
    });

    $body.on('click', '.quick_reply_link', function () {

        var $post_options_container = $('.post_options_container').hide(),
            quick_reply_data = /^([0-9]+)\.([0-9]+)$/.exec($(this).data('msg')),
            $quick_reply_location,
            $quick_reply_container;

        $post_options_container.find('*').css('margin-left', -9999);

        //noinspection JSLint
        if (CKEDITOR.instances.content) {
            CKEDITOR.instances.content.destroy();
        }

        if (quick_reply_data.length === 3) {

            $quick_reply_location = $('#quick_reply_' + quick_reply_data[2]);

            $quick_reply_container = $('#quick_reply_container');

            if ($quick_reply_location.length === 1) {

                $quick_reply_container.find('input[name="reply_to"]').val(quick_reply_data[0]);

                $quick_reply_container.appendTo($quick_reply_location).show();

                $quick_reply_container.find('#content').each(top.window.beehive.editor);

                $quick_reply_container.find('input#post').get(0).scrollIntoView(false);
            }
        }
    });

    $body.on('click', 'a[id^="quote_"]', function () {

        var $link = $(this),
            $links = $body.find('a[id^="reply_"]').add($link),
            pid = $link.data('pid'),
            check_post_id;

        if ($.inArray(pid, top.window.beehive.quote_list) < 0) {

            $('span.image#quote_img_' + pid).removeClass('quote_disabled').addClass('quote_enabled');

            //noinspection JSUnresolvedVariable
            $link.html(top.window.beehive.lang.unquote);

            top.window.beehive.quote_list.push(pid);

        } else {

            $('span.image#quote_img_' + pid).addClass('quote_enabled').removeClass('quote_disabled');

            //noinspection JSUnresolvedVariable
            $link.html(top.window.beehive.lang.quote);

            for (check_post_id in top.window.beehive.quote_list) {

                if (top.window.beehive.quote_list.hasOwnProperty(check_post_id)) {

                    if (top.window.beehive.quote_list[check_post_id] === pid) {
                        top.window.beehive.quote_list.splice(check_post_id, 1);
                    }
                }
            }
        }

        $links.each(function () {

            var query_string = $.parseQuery($(this).prop('href').split('?')[1]);

            if (top.window.beehive.quote_list.length > 0) {
                query_string.quote_list = top.window.beehive.quote_list.join(',');
            } else {
                delete query_string.quote_list;
            }

            $(this).prop('href', 'post.php?' + $.param(query_string));
        });

        return false;
    });
});