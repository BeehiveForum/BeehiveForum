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

    $('select#mail_function').bind('change', function () {

        var $smtp_settings = $('#smtp_settings').hide();
        var $sendmail_settings = $('#sendmail_settings').hide();

        switch (parseInt($(this).val(), 10)) {

            case 1:

                $smtp_settings.show();
                break;

            case 2:

                $sendmail_settings.show();
                break;
        }
    });

    $('#forum_created,#forum_updated,#forum_removed').each(function () {

        //noinspection JSUnresolvedVariable
        beehive.reload_frame(top.document, beehive.frames.fnav);
    });
});