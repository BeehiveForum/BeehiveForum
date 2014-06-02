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

    $('select#mode').bind('change', function () {
        $(this).closest('form').submit();
    });

    $('a.threadname').bind('click', function () {

        $('span.image.current_thread')
            .addClass('bullet')
            .removeClass('current_thread');

        $('span#' + $(this).data('tid'))
            .removeClass('bullet unread_thread')
            .addClass('current_thread');
    });

    $('#mark_read_submit').bind('click', function () {

        //noinspection JSUnresolvedVariable
        if (window.confirm(beehive.lang.confirmmarkasread)) {

            $('#mark_read_confirm').val('Y');
            return true;
        }

        return false;
    });
});