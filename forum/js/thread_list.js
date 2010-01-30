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

    $('a.threadname').bind('click', function() {

        $('img.thread_bullet[src$="current_thread.png"]').attr('src', beehive.images['bullet.png']);
        $('#' + $(this).attr('rel')).attr('src', beehive.images['current_thread.png']);
    });

    $('#mark_read_submit').bind('click', function() {

        if (window.confirm(beehive.lang['confirmmarkasread'])) {

            $('#mark_read_confirm').val('Y');
            return true;
        }

        return false;
    });
});