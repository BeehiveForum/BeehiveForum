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

var beehive = $.extend({}, beehive, {

    window_options : [ 'toolbox=0',
                       'location=0',
                       'directories=0',
                       'status=0',
                       'menubar=0',
                       'resizeable=yes',
                       'scrollbars=yes' ],

    process_frames : function(context, callback) {

        if ($('frame', context).length > 0) {

            $('frame', context).each(function() {

                beehive.process_frames(this.contentDocument, callback);

                if ($.isFunction(callback)) {
                     callback.call(this);
                }
            });
        }
    },

    reload_user_prefs : function() {

        if (top.document.body.rows) {
            top.document.body.rows = '60,' + Math.max(beehive.font_size * 2, 22) + ',*';
        }

        beehive.process_frames(top.document.body, function() {
            
            if (this.contentDocument) {
            
                beehive.reload_user_font.call($(this.contentDocument).find('head').get(0));
                beehive.reload_style_sheets.call($(this.contentDocument).find('head').get(0));
                
                if ($(this).attr('name') === beehive.frames.ftop) {
                    $(this).attr('src', 'styles/' + beehive.user_style + '/top.php');
                }
            }
        });
        
        beehive.reload_user_font.call($('body').parent().find('head').get(0));
        beehive.reload_user_font.call($('head', top.document).get(0));

        beehive.reload_style_sheets.call($('body').parent().find('head').get(0));       
        beehive.reload_style_sheets.call($('head', top.document).get(0));       
    },
    
    reload_user_font : function() {
        
        var $head = $(this);

        $.ajax({
            'url' : beehive.forum_path + '/font_size.php',
            'data' : { 'webtag' : beehive.webtag },
            'cache' : false,
            'success' : function(data) {
                $head.find('style[title="user_font"]').html(data).appendTo($head);
            }
        });
    },
    
    reload_style_sheets : function() {
        
        var $head = $(this);
        
        $head.find('link[id="user_style"]').attr('href', 'styles/' + beehive.user_style + '/style.css').appendTo($head);
        $head.find('link[id="emoticon_style"]').attr('href', beehive.emoticons).appendTo($head);
    },
    
    reload_frame : function(frame_name) {
        
        beehive.process_frames(top.document.body, function() {
            
            if ((this.contentDocument) && ($(this).attr('name') === frame_name)) {
                $(this).attr('src', $(this).attr('src'));
            }
        });
    },
    
    get_resize_width : function() {
        
        var $max_width = $(this).closest('.max_width[width]');
        
        if ($max_width.length > 0) {
            return $max_width.attr('width');
        }
        
        return $('body').attr('clientWidth');
    }
});

$.ajaxSetup({
    cache: true
});

$(beehive).bind('init', function() {

    $('.move_up_ctrl_disabled, .move_down_ctrl_disabled').bind('click', function() {
        return false;
    });

    $('#thread_mode').bind('change', function() {
        $(this).closest('form').submit();
    });

    $('a.popup').live('click', function() {

        var class_names = $(this).attr('class').split(' ');

        var window_options = beehive.window_options;

        for (var key in class_names) {

            if (dimensions = /^([0-9]+)x([0-9]+)$/.exec(class_names[key])) {

                window_options.unshift('width=' + dimensions[1], 'height=' + dimensions[2]);
            }
        }

        window.open($(this).attr('href'), $(this).attr('id'), window_options.join(','));

        return false;
    });

    $('input#close_popup').bind('click', function() {
        window.close();
    });

    $('select.user_in_thread_dropdown').bind('change', function() {
        $('input[name="to_radio"][value="in_thread"]').attr('checked', true);
    });

    $('select.recent_user_dropdown').bind('change', function() {
        $('input[name="to_radio"][value="recent"]').attr('checked', true);
    });
    
    $('select.friends_dropdown').bind('change', function() {
        $('input[name="to_radio"][value="friends"]').attr('checked', true);
    });

    $('input.post_to_others').bind('focus', function() {
        $('input[name="to_radio"][value="others"]').attr('checked', true);
    });

    $('input#toggle_all').bind('click', function() {
        $(this).closest('form').find('input:checkbox').attr('checked', $(this).attr('checked'));
    });

    $('a.font_size').live('click', function() {

        $parent = $(this).closest('td');
        
        if (beehive.uid == 0) return true;

        $.getJSON($(this).attr('href'), { 'json' : true }, function(data) {

            if (!data.success) return false;

            $parent.html(data.html);

            beehive.font_size = data.font_size;

            beehive.reload_user_prefs();
        });

        return false;
    });

    $('#preferences_updated').each(function() {

        beehive.reload_user_prefs();
        return false;
    });
    
    $('button#print').bind('click', function() {
        window.print();
    });
    
    $('a.button').bind('mousedown', function() {
        $(this).css('border', '1px inset');
    }).bind('mouseup mouseout', function() {
        $(this).css('border', '1px outset');
    });
    
    if ($('body').hasClass('window_title')) {
        top.document.title = document.title;
    }
});