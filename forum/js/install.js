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

$(document).ready(function () {

    'use strict';

    $('#install_button').bind('click', function () {

        var confirm_text = '';

        switch (parseInt($('#install_method').val(), 10)) {

            case 1:

                confirm_text = 'Are you sure you want to perform a reinstall? Any existing Beehive Forum tables and their data will be permanently lost!\n\n';
                confirm_text += 'Please perform a backup of your database and files before proceeding.';
                break;

            case 2:

                confirm_text = 'Are you sure you want to perform a reconnect? Any customised values in your config.inc.php file will be lost!\n\n';
                confirm_text += 'Please perform a backup of your database and files before proceeding.';
                break;

            case 3:

                confirm_text = 'Are you sure you want to perform an upgrade?\n\n';
                confirm_text += 'Please make sure you have selected the correct upgrade path. The upgrade scripts are very\n';
                confirm_text += 'primitive and will not check the currently installed version before upgrading. If you have\n';
                confirm_text += 'selected the wrong upgrade path your forum will become unusable and you will have to\n';
                confirm_text += 'restore from backup before you can start the upgrade again.\n\n';
                confirm_text += 'Please perform a backup of your database and files before proceeding.';
                break;
        }

        if ((confirm_text.length > 0) && !window.confirm(confirm_text)) {
            return false;
        }

        $(this).prop('disabled', true);

        $('#install_form').submit();

        return true;
    });
});