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

$(top.window.beehive).bind('init', function () {

    if (top.window.beehive.use_mover_spoiler == 'Y' && !top.window.beehive.mobile_version) {

        $('.spoiler').hover(function () {

            $(this).addClass('spoiler_reveal');

        }, function () {

            $(this).removeClass('spoiler_reveal');
        });

    } else {

        $('.spoiler').bind('click', function () {
            $(this).toggleClass('spoiler_reveal');
        });
    }
});