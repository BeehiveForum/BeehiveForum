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

    $('input#toggle_main').bind('click', function() {
        $(this).closest('table.posthead').find('input:checkbox').attr('checked', $(this).attr('checked'));
    });

    $('input#toggle_other').bind('click', function() {
        $(this).closest('table.posthead').find('input:checkbox').attr('checked', $(this).attr('checked'));
    });

    $('.upload_fields').css('display', 'block');

    $('input#upload').bind('click', function() {
        $(this).val(beehive.lang.waitdotdotdot);
    });

    $('input#complete').bind('click', function() {

        try {

            if (/edit_attachments\.php|edit_prefs\.php/.test(window.opener.location)) {
                window.opener.location.reload();
            }

        } catch(e) { }

        window.close();
    });

    $('.add_upload_field').bind('click', function() {

        $('#userfile').clone().prependTo($('.upload_fields'));

        if ($('.upload_fields #userfile').length > 8) {
            $('.upload_fields *:not(#userfile)').css('display', 'none');
        }
    });
});