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

    var $window = $(window),
        $document = $(document),
        $messages = $('div#messages'),
        $navigation = $('.navigation'),
        $keep_reading = $('input#keep_reading.button'),
        loading_messages = false;

    var navigation_options = $navigation.prop("id")
        .match(/^navigation_(\d+)_(\d+)_(\d+)_(\d+)$/)
        .map(function (option) {
            return parseInt(option, 10);
        });

    $navigation.hide();
    $keep_reading.hide();

    $window.on('scroll', function () {

        if (loading_messages) {
            return;
        }

        //noinspection JSValidateTypes
        if ($window.scrollTop() < ($document.height() - $window.height())) {
            return;
        }

        if ($messages.find('.message').length == navigation_options[3]) {
            return;
        }

        loading_messages = true;

        var pid = navigation_options[2] + navigation_options[4],
            msg = navigation_options[1] + "." + Math.min(navigation_options[3] + 1, pid);

        $.ajax({

            cache: true,

            data: {
                webtag: beehive.webtag,
                msg: msg
            },

            url: beehive.forum_path + ((beehive.mobile_version) ? '/lmessages.php' : '/messages.php'),

            success: function (data) {

                var $data;

                if (beehive.mobile_version) {
                    $data = $(data).find('div#messages').children();
                } else {
                    $data = $(data).filter('div#messages').children();
                }

                if ($data.length > 0) {

                    $messages.append($data);
                    navigation_options[2] = pid;
                }

                loading_messages = false;
            }
        })
    });
});