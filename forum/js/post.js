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

$(beehive).bind('init', function() {

    beehive.quote_list = [];

    var hide_post_options_containers = function() {

        $('.post_options_container').each(function() {

            var $post_options_container = $(this);

            var $link = $(this).prev('span.post_options');

            if ($link.length == 1) {

                var link_offset = $link.offset();

                $post_options_container.hide();

                $post_options_container.css('top', link_offset.top + $link.height());

                $post_options_container.find('*').css('margin-left', -9999);
            }
        });
    };

    var $body = $('body').on('click', 'input.post_vote_up, input.post_vote_down', function(event) {

        var $button = $(this);

        var $form = $button.closest('form');

        event.preventDefault();

        $.ajax({

            'cache' : true,

            'data' : {
                'webtag' : beehive.webtag,
                'ajax' : 'true',
                'action' : 'post_vote',
                'post_rating' : $button.hasClass('post_vote_up') ? 1 : -1,
                'msg' : $form.data('msg')
            },

            'url' : beehive.forum_path + '/ajax.php',

            'success' : function(data) {

                try {

                    $form.replaceWith($(data));

                } catch (exception) {

                    beehive.ajax_error(exception);
                }
            }
        });
    });

    $('span.post_options').each(function() {

        var $link = $(this);

        $link.html(beehive.lang.more +'&nbsp;<img class="post_options" src="' + beehive.images['post_options.png'] + '" border="0" />');

        $link.bind('click', function() {

            hide_post_options_containers();

            if ($link.next('.post_options_container').length < 1) {

                $.ajax({

                    'cache' : true,

                    'data' : {
                        'webtag' : beehive.webtag,
                        'ajax'   : 'true',
                        'action' : 'post_options',
                        'msg'    : $link.prop('id').match(/post_options_([^\.]+\.[^\.]+)/)[1]
                    },

                    'url' : beehive.forum_path + '/ajax.php',

                    'success' : function(data) {

                        try {

                            $link.after(data);

                            $link.triggerHandler('click');

                        } catch (exception) {

                            beehive.ajax_error(exception);
                        }
                    }
                });

                return;
            }

            var $post_options_container = $link.next('.post_options_container');

            if ($post_options_container.length != 1) {
                 return;
            }

            var link_offset = $link.offset();

            $post_options_container.show();

            var container_offset = $post_options_container.offset();

            //noinspection JSValidateTypes
            if (((container_offset.top - $(window).scrollTop()) + $post_options_container.height()) > $(window).height()) {
                $post_options_container.css('top', Math.floor(link_offset.top - $post_options_container.height()));
            } else {
                $post_options_container.css('top', Math.floor(link_offset.top + $link.height()));
            }

            $post_options_container.find('*').css('margin-left', 0);
            $post_options_container.css('left', Math.floor(link_offset.left - ($post_options_container.width() - $link.width())));
        });
    });

    $body.bind('click', function() {
        hide_post_options_containers();
    });

    $('#quick_reply_container').find('input#cancel').bind('click', function() {

        if (CKEDITOR.instances.content) {
            CKEDITOR.instances.content.destroy();
        }

        $('#quick_reply_container').hide();
    });

    $body.on('click', '.quick_reply_link', function() {

        var $post_options_container = $('.post_options_container').hide();

        $post_options_container.find('*').css('margin-left', -9999);

        var quick_reply_data = /^([0-9]+)\.([0-9]+)$/.exec($(this).data('msg'));

        if (CKEDITOR.instances.content) {
            CKEDITOR.instances.content.destroy();
        }

        if (quick_reply_data.length === 3) {

            var $quick_reply_location = $('#quick_reply_' + quick_reply_data[2]);

            var $quick_reply_container = $('#quick_reply_container');

            if ($quick_reply_location.length == 1) {

                $quick_reply_container.find('input[name="replyto"]').val(quick_reply_data[0]);

                $quick_reply_container.appendTo($quick_reply_location).show();

                $quick_reply_container.find('#content').each(beehive.editor);

                $quick_reply_container.find('input#post').get(0).scrollIntoView(false);
            }
        }
    });

    $('a[id^="quote_"]').bind('click', function() {

        var pid = $(this).data('pid');

        if ($.inArray(pid, beehive.quote_list) < 0) {

            $('img#quote_img_' + pid).prop('src', beehive.images['quote_enabled.png']);

            //noinspection JSUnresolvedVariable
            $(this).html(beehive.lang.unquote);

            beehive.quote_list.push(pid);

        } else {

            $('img#quote_img_' + pid).prop('src', beehive.images['quote_disabled.png']);

            $(this).html(beehive.lang.quote);

            for (var check_post_id in beehive.quote_list) {

                if (beehive.quote_list.hasOwnProperty(check_post_id)) {

                    if (beehive.quote_list[check_post_id] == pid) {
                        beehive.quote_list.splice(check_post_id, 1);
                    }
                }
            }
        }

        $('a[id^="reply_"]').each(function() {

            var query_string = $.parseQuery($(this).prop('href').split('?')[1]);

            query_string.quote_list = beehive.quote_list.join(',');

            $(this).prop('href', 'post.php?' + $.param(query_string));
        });

        return false;
    });
});