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

    $('div#page_content select#folder').bind('change', function () {
        $(this).closest('form').submit();
    });

    $('#pm_delete_messages,#pm_save_messages,#pm_export_messages').bind('click', function () {

        if ($('input[name^="process"]:checked').length === 0) {
            return false;
        }

        if ($(this).prop('id') === 'pm_delete_messages') {

            //noinspection JSUnresolvedVariable
            if (!window.confirm(beehive.lang.deletemessagesconfirmation)) {
                return false;
            }

            $('#pm_delete_confirm').val('Y');
        }

        return true;
    });

    $('#pm_rename_success,#pm_delete_success,#pm_archive_success').each(function () {

        if (top.document.body.rows) {
            //noinspection JSUnresolvedVariable
            top.frames[beehive.frames.main].frames[beehive.frames.pm_folders].location.reload();
        } else if (top.document.body.cols) {
            //noinspection JSUnresolvedVariable
            top.frames[beehive.frames.pm_folders].location.reload();
        }

        return false;
    });

    $.ajax({
        cache: true,
        data: {
            webtag: beehive.webtag,
            ajax: true,
            action: 'pm_check_messages'
        },
        dataType: 'json',
        url: 'ajax.php',
        success: function (data) {

            try {

                $('#pm_message_count').html(data.text);

                //noinspection JSUnresolvedVariable
                if (data.notification && window.confirm(data.notification)) {

                    //noinspection JSUnresolvedVariable
                    top.frames[beehive.frames.main].location.replace('pm.php?webtag=' + beehive.webtag);
                }

            } catch (exception) {

                beehive.ajax_error(exception);
            }
        }
    });
});
