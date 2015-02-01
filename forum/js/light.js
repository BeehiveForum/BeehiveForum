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

    var $body = $('body'),
        $header = $('div#header'),
        $menu = $header.find('ul');

    function render_message_form() {

        var $message_vote_form = $(this);

        $message_vote_form.addClass('popup');

        /*rating_position = $rating_text.position();

        $vote_down.css(
            {
                left: (($rating_text.width()) * 4) + (rating_position.left * 2),
                top: (($rating_text.height() - $vote_down.height()) / 2) * 4
            }
        );

        $vote_up.css(
            {
                left: (($rating_text.width() + $vote_down.width()) * 4) + (rating_position.left * 3),
                top: (($rating_text.height() - $vote_down.height()) / 2) * 4
            }
        );

        $message_vote_form.css(
            {
                width: (($vote_up.width() + $vote_down.width() + $rating_text.width()) * 4) + (rating_position.left * 4),
                height: $rating_text.height() * 4
            }
        );*/
    }

    $body.bind('click', function () {
        $body.find('div.menu').hide();
        $body.find('.message_vote_form').removeClass('popup');
    });

    $('div#header ul li a').bind('click', function (event) {

        var $link = $(this),
            $menuItem = $body.find('div.menu.' + this.className),
            right = $menu.width() - $link.position().left - $menuItem.outerWidth(true);

        if ($menuItem.length == 0) {
            return;
        }

        $body.find('div.menu').not($menuItem).hide();

        if (right < 5) {
            right = 5;
        }

        $menuItem.css('right', right);

        $menuItem.toggle();

        $body.find('.message_vote_form').removeClass('popup');

        event.stopPropagation();
        event.preventDefault();
    });

    $body.on('focus', 'input,select,textarea',function () {
        $.mobile.zoom.disable(true);
    }).on('blur', 'input,select', function () {
        $.mobile.zoom.enable(true);
    });

    $body.on('click', '.message_vote_form', function (event) {

        event.stopPropagation();
        render_message_form.call(this);
    });

    $body.on('click', '.message_vote_form.popup span.vote', function (event) {

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
                mobile: 'true',
                msg: $container.data('msg')
            },

            url: top.window.beehive.forum_path + '/ajax.php',

            success: function (data) {

                try {

                    $container.html(data).show();
                    render_message_form.call($container[0]);

                } catch (exception) {

                    top.window.beehive.ajax_error(exception);
                }
            }
        });
    });

    $body.find('.message_vote_form').show();
})
;