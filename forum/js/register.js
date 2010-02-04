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

/* $Id$ */

$(beehive).bind('init', function() {

    $('#text_captcha_reload').bind('click', function() {

        $.getJSON('register.php', { 'webtag' : beehive.webtag, 'reload_captcha' : 'true' }, function(data) {

            $('#captcha_img').attr('src', data.image);
            $('#public_key').val(data.key).attr('maxLength', data.chars);
            $('#private_key').val('');
        });
    });
});