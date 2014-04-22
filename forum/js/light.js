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

$(beehive).bind('init', function () {

    var $body = $('body'),
        $header = $('div#header'),
        $menu = $header.find('ul'),
        $message_vote_form = $('.message_vote_form'),
        $message_navigation = $('.message_navigation');

    $body.bind('click', function () {
        $body.find('div.menu').hide();
        $message_vote_form.removeClass('popup');
    });

    $('div#header ul li a').bind('click', function (event) {

        var $link = $(this),
            $menuItem = $body.find('div.menu.' + this.className),
            right = $menu.width() - $link.position().left - $menuItem.outerWidth(true);

        $body.find('div.menu').hide();

        if ($menuItem.length == 0) {
            return;
        }

        if (right < 5) {
            right = 5;
        }

        $menuItem.css('right', right);

        $menuItem.show();

        $message_vote_form.removeClass('popup');

        event.stopPropagation();
        event.preventDefault();
    });

    $body.on('focus', 'input,select,textarea',function () {
        $.mobile.zoom.disable(true);
    }).on('blur', 'input,select', function () {
        $.mobile.zoom.enable(true);
    });

    $body.on('click', '.message_vote_form', function (event) {

        $(this).addClass('popup');
        event.stopPropagation();
    });

    $body.on('click', '.message_vote_form.popup img', function (event) {

        var $button = $(this);

        var $container = $button.closest('.message_vote_form');

        event.preventDefault();

        $.ajax({

            cache: true,

            data: {
                webtag: beehive.webtag,
                ajax: 'true',
                action: 'post_vote',
                post_rating: $button.hasClass('post_vote_up') ? 1 : -1,
                mobile: 'true',
                msg: $container.data('msg')
            },

            url: beehive.forum_path + '/ajax.php',

            success: function (data) {

                try {

                    $container.html(data).show();

                } catch (exception) {

                    beehive.ajax_error(exception);
                }
            }
        });
    });

    /*$body.on('click', 'div#header a.navigation', function (event) {

     var $link = $(this);

     $message_navigation.css(
     {
     position: 'absolute',
     left: '50%',
     top: '50%',
     marginTop: ($message_navigation.height() / 2) * -1,
     marginLeft: ($message_navigation.width() / 2) * -1
     }
     )
     });*/

    $message_vote_form.show();
});