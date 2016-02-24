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

$(document).bind('beehive.init', function ($event, beehive) {

    'use strict';

    var $window = $(window),
        $body = $('body'),
        $document = $(document),
        $messages = $('div#messages'),
        $keep_reading = $('input#keep_reading.button'),
        loading_messages = false,
        navigation_options;

    //noinspection JSUnresolvedVariable
    if (beehive.auto_scroll_messages === 'Y') {

        navigation_options = $messages.data('navigation')
            .split('_').map(function (option) {
                return parseInt(option, 10);
            });

        $keep_reading.hide();

        $window.on('scroll', function () {

            if (loading_messages) {
                return;
            }

            //noinspection JSValidateTypes
            if ($window.scrollTop() < ($document.height() - $window.height())) {
                return;
            }

            loading_messages = true;

            var pid = navigation_options[1] + navigation_options[3],
                msg = navigation_options[0] + '.' + Math.min(navigation_options[2] + 1, pid),
                last_pid;

            last_pid = $messages.find('.message').last()
                .prop('id').match(/^message_(\d+)_(\d+)$/)[2];

            if (last_pid >= navigation_options[2]) {
                return;
            }

            $.ajax({

                cache: true,

                data: {
                    webtag: beehive.webtag,
                    msg: msg
                },

                url: (beehive.mobile_version) ? '/lmessages.php' : '/messages.php',

                success: function (data) {

                    var $data;

                    if (beehive.mobile_version) {
                        $data = $(data).find('div#messages').children();
                    } else {
                        $data = $(data).filter('div#messages').children();
                    }

                    if ($data.length > 0) {

                        $messages.append($data);
                        $messages.find('.message_vote_form').show();
                        navigation_options[1] = pid;
                    }

                    loading_messages = false;
                }
            });
        });

        $body.on('click', '.navigation a', function (event) {

            var $anchor = $('a[name="a' + $.url($(this).attr('href')).param('msg').replace('.', '_') + '"]');

            if ($anchor.length > 0) {

                event.preventDefault();
                event.stopPropagation();

                //noinspection JSValidateTypes,JSCheckFunctionSignatures
                $window.scrollTop(Math.floor($anchor.offset().top));
            }
        });
    }
});