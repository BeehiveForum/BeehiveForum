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

/* $Id: post.js 4775 2011-07-15 12:22:47Z decoyduck $ */

$(beehive).bind('init', function() {

    var add_process_running = false;

    var toggle_add_new_buttons = function()
    {
        $('button.add_question, button.add_answer').toggleClass('disabled', !($('ol.poll_answer_list li').length < 20));
    };

    $('button.delete_question').live('click', function() {

       if (!window.confirm('Are you sure you want to delete this question?')) {
           return false;
       }

       $(this).closest('fieldset').hide(300, function() {

           $(this).remove();

           toggle_add_new_buttons();
       });

       return false;
    });

    $('button.delete_answer').live('click', function() {

       if (!window.confirm('Are you sure you want to delete this answer?')) {
           return false;
       }

       $(this).closest('li').hide(300, function() {

           $(this).remove();

           toggle_add_new_buttons();
       });

       return false;
    });

    $('button.add_answer').live('click', function() {

        if ($(this).hasClass('disabled')) return false;

        if (add_process_running) return false;

        var $poll_question_fieldset = $(this).closest('fieldset.poll_question');

        var $poll_answer_list = $poll_question_fieldset.find('ol.poll_answer_list');

        var question_number = $('fieldset.poll_question').index($poll_question_fieldset);

        var answer_number = $poll_question_fieldset.find('li').length;

        add_process_running = true;

        $.ajax({

            'cache' : true,

            'data' : {
                'webtag' : beehive.webtag,
                'ajax' : 'true',
                'action' : 'poll_add_answer',
                'question_number' : question_number,
                'answer_number' : answer_number
            },

            'url' : beehive.forum_path + '/ajax.php',

            'success' : function(data) {

                $(data).hide().appendTo($poll_answer_list).show(200, function() {

                    $(this).css('display', 'list-item');

                    toggle_add_new_buttons();

                    add_process_running = false;
                });
            }
        });

        return false;
    });

    $('button#add_question').bind('click', function() {

        if ($(this).hasClass('disabled')) return false;

        if (add_process_running) return false;

        var $poll_question_container = $('.poll_question_container');

        var question_number = $poll_question_container.find('fieldset.poll_question').length;

        add_process_running = true;

        $.ajax({

            'cache' : true,

            'data' : {
                'webtag' : beehive.webtag,
                'ajax' : 'true',
                'action' : 'poll_add_question',
                'question_number' : question_number
            },

            'url' : beehive.forum_path + '/ajax.php',

            'success' : function(data) {

                $(data).hide().appendTo($poll_question_container).show(200);

                toggle_add_new_buttons();

                add_process_running = false;
            }
        });

        return false;
    });
});