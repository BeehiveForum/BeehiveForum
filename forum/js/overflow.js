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

$(window.beehive).bind('init', function () {

    window.beehive = $.extend({}, window.beehive, {

        resize_image: function () {

            var max_width = beehive.get_resize_width.call(this);

            if ($(this).parent('div.image_resize_container').length > 0) {

                $(this).parent('div.image_resize_container').css('width', max_width * 0.95);

            } else {

                if ($(this).width() > max_width) {

                    var $parent_div = $('<div class="image_resize_container">');

                    var $resize_banner = $('<div class="image_resize_text">');

                    var $resize_icon = $('<span class="image_resize_icon image warning" />');

                    $resize_banner.append($resize_icon);

                    //noinspection JSUnresolvedVariable
                    $resize_banner.append($.sprintf(beehive.lang.imageresized, $(this).width(), $(this).height()));

                    $(this).wrap($parent_div).css('width', '100%');

                    $(this).parent('div').prepend($resize_banner);

                    var $image = $(this);

                    $resize_banner.bind('click', function () {
                        window.open($image.prop('src'));
                    });
                }
            }
        },

        check_overflow: function () {

            var max_width = beehive.get_resize_width.call(this);

            if ($(this).find('div.overflow_fix').length > 0) {

                $(this).find('div.overflow_fix').css('width', max_width * 0.95);

            } else {

                if ($(this).width() > max_width) {

                    var $overflow_container = $('<div class="overflow_fix"></div>');

                    $overflow_container.html($(this).html());

                    $overflow_container.css('width', max_width * 0.95);
                    $overflow_container.css('overflow', 'auto');

                    $(this).html($overflow_container);
                }
            }
        }
    });

    $(window).bind('resize', function () {

        $('.overflow_content img').each(beehive.resize_image);
        $('.overflow_content').each(beehive.check_overflow);
    });

    $('body').on('load', '.overflow_content img', beehive.resize_image);

    $(window).trigger('resize');
});