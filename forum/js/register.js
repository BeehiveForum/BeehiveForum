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

    $('#text_captcha_reload').bind('click', function() {

        $.ajax({
            cache: true,
            data: {
                webtag: beehive.webtag,
                ajax: 'true',
                action: 'reload_captcha'
            },
            dataType: 'json',
            url: beehive.forum_path + '/ajax.php',
            success: function(data) {

                try {

                    $('#captcha_img').prop('src', data.image);

                    //noinspection JSUnresolvedVariable
                    $('#public_key').val(data.key).prop('maxLength', data.chars);
                    $('#private_key').val('');

                } catch (exception) {

                    beehive.ajax_error(exception);
                }
            }
        });
    });
});
