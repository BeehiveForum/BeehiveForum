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

    get_resize_width : function() {
        
        var $max_width = $(this).closest('.max_width[width]');
        
        if ($max_width.length > 0) {
            return $max_width.attr('width');
        }
        
        return $('body').attr('clientWidth');
    },
    
    get_frame_name : function(frame_name) {
        
        for(var key in beehive.frames) {
            if (beehive.frames[key] == frame_name) return key;
        }
    }
});

$.ajaxSetup({
    cache: true
});

$(beehive).bind('init', function() {
    
    var $top = top.$;
   
    var $beehive_top = $top(top.beehive);

    var frame_resize_timeout;
    
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
            
            $beehive_top.trigger('reload_frame', [beehive.frames.ftop]);
            $beehive_top.trigger('reload_frame', [beehive.frames.fnav]);
            $beehive_top.trigger('reload_frame', [beehive.frames.left]);
        });

        return false;
    });

    $('#preferences_updated').each(function() {
        
        $beehive_top.trigger('reload_top_frame', [beehive.top_frame]);
        $beehive_top.trigger('reload_frame', [beehive.frames.fnav]);
        $beehive_top.trigger('reload_frame', [beehive.frames.left]);
    });
    
    $('input#print').bind('click', function() {
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
    
    $(window).bind('resize', function() {
        
        if ($(this).attr('name') != beehive.frames.left) return;
        
        window.clearTimeout(frame_resize_timeout);
        
        frame_resize_timeout = window.setTimeout(function() {
            
            $.ajax({
                'url' : beehive.forum_path + '/user.php',
                'cache' : false,
                'data' : { 
                    'webtag' : beehive.webtag,
                    'frame_resize' : this.innerWidth
                }
            });
            
        }, 500);    
    });
    
    $beehive_top.bind('reload_frame', function(event, frame_name) {
        
        if (frame_name == $top(window).attr('name')) {
            window.location.reload();
        }
    });
});