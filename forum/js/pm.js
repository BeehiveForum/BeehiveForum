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

/* $Id: pm.js,v 1.29 2010-01-10 14:26:27 decoyduck Exp $ */

$(document).ready(function() {

    $('body').bind('init', function() {

        $.getJSON('pm.php', { 'webtag' : beehive.webtag, 'check_messages' : 'true' }, function(data) {

            if (data.text) $('#pm_message_count').html(data.text);

            if (data.notification && window.confirm(data.notification)) {
                top.frames[bh_frame_main].location.replace('pm.php?webtag=' + beehive.webtag);
            }
        });

        if (/folder_renamed/.test(window.location.search)) {

            if (top.document.body.rows) {
                top.frames[bh_frame_main].frames[bh_frame_pm_folders].location.reload();
            }else if (top.document.body.cols) {
                top.frames[bh_frame_pm_folders].location.reload();
            }
        }
    });
});