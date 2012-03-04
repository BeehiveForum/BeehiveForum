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

var htmltools = function()
{
    var selected_text = '';

    var active_field;

    var auto_spell_check_started = false;

    return {

        set_focus : function()
        {
            active_field.focus();
        },

        active_text : function(t, dbl)
        {
            if (t.createTextRange) {

                var selection = document.selection;

                try {

                    var range = selection.createRange();
                    t.caretPos = range.duplicate();
                    active_field.t = '';

                }catch (e) {

                }
            }

            active_field = t;

            if (!active_field.createTextRange && !active_field.setSelectionRange) {
                return;
            }

            if (dbl === true) {

                var s = this.get_selection();

                if (s.charAt(s.length-1) === ' ') {

                    var ss = this.get_selection_start();
                    var se = this.get_selection_end() - 1;

                    if (active_field.setSelectionRange) {

                        active_field.focus();
                        active_field.setSelectionRange(ss, se);

                    }else if (active_field.createTextRange) {

                        t.caretPos.moveEnd('character', -1);
                        t.caretPos.select();
                    }
                }
            }
        },

        active_page_text : function()
        {
            selected_text = (document.all) ? document.selection.createRange().text : window.getSelection();
        },

        get_selection : function()
        {
            if (active_field.createTextRange) {

                return document.selection.createRange().text;

            }else if (active_field.setSelectionRange) {

                var selLength = active_field.textLength;
                var selStart = active_field.selectionStart;
                var selEnd = active_field.selectionEnd;

                if (selEnd == 1 || selEnd == 2) {
                    selEnd = selLength;
                }

                return (active_field.value).substring(selStart, selEnd);

            }else {

                return window.getSelection();
            }
        },

        get_selection_start : function()
        {
            if (active_field.setSelectionRange) {

                return active_field.selectionStart;

            }else if (active_field.createTextRange) {

                var s = active_field.caretPos.duplicate();
                var t = active_field.value;
                var u = s.text;
                var i = 0;
                var last_s;
                var tmp_s;
                var count = 0;
                var no_sel = false;

                var gap = Math.ceil(t.length/2);

                if (u.length === 0) {

                    no_sel = true;
                    gap = 1;
                }

                while (true) {

                    if (++i > t.length * 5) {
                        break;
                    }

                    last_s = s.duplicate();
                    tmp_s  = s.duplicate();

                    tmp_s.moveStart("character", -gap);

                    if (t.indexOf(tmp_s.text) > -1) {

                        s.moveStart("character", -gap);

                        // yet another IE bug - if there is no selection, just a placed cursor,
                        // then moveStart will ignore any combinations of \r\n until it hits a
                        // non-linebreak character. "Argh".

                        if (no_sel === true) {

                            if (last_s.text == s.text) {

                                count++;

                            }else {

                                no_sel = 0;
                                gap = Math.ceil(t.length/2);
                            }
                        }

                    }else if (gap > 1) {

                        gap = Math.ceil(gap/2);

                    }else {

                        break;
                    }
                }

                if (no_sel === 0) {
                    count*= 2;
                }

                // Remove 'junk' characters before the textfield
                // See textarea() in htmltools.inc.php

                var re = new RegExp("^" + String.fromCharCode(9999) + "*\r?\n?");
                var u2 = s.text.replace(re, "");

                return (u2.length + count - u.length);
            }
        },

        get_selection_end : function()
        {
            if (active_field.setSelectionRange) {

                return active_field.selectionEnd;

            }else if (active_field.createTextRange) {

                var s = active_field.caretPos.duplicate();
                var u = s.text;

                return (this.get_selection_start() + u.length);
            }
        },

        parse_attributes : function(attributes)
        {
            if (attributes === undefined || attributes === null) return '';

            attributes = $.map(attributes, function(value, index) {
                return index + '="' + value + '"';
            }).join(' ');

            return (attributes.length > 0) ? ' ' + attributes : '';
        },

        add_tag : function(tag, attributes, enclose)
        {
            if (!active_field) {
                return;
            }

            var single_tags = {br : true, img : true, hr : true, area : true, flash : true};

            var open_tag, close_tag, valid, ca, i, j, re, list_tmp;

            if (!active_field.createTextRange && !active_field.setSelectionRange) {

                if (!single_tags[tag]) {

                    open_tag = '<' + tag + this.parse_attributes(attributes) + '>';
                    close_tag = '</' + tag + '>';

                }else {

                    open_tag = '';
                    close_tag = '<' + tag + this.parse_attributes(attributes) + '>';
                }

                active_field.value+= open_tag + close_tag;
                return;
            }

            var str = this.get_selection();
            var str_enclose = str;

            var ss = this.get_selection_start();
            var se = ss + str.length;

            if (ss != se && str.length === 0) {
                 ss = se;
            }

            var left_bound = active_field.value.substr(0, ss);
            var right_bound = active_field.value.substr(se);

            var extra_left = "", extra_right = "";

            if (/^[^<>]*>/.test(str) === true) {

                valid = false;

                for (i = left_bound.length - 1; i >= 0; i--) {

                    ca = left_bound.charAt(i);

                    if (ca == "<") {

                        valid = true;
                        break;

                    }else if (ca == ">") {

                        valid = false;
                        break;
                    }
                }

                if (valid === true) {

                    extra_left = left_bound.substr(i) + extra_left;
                    left_bound = left_bound.substr(0, i);
                }

            }else if (/<[^<>]*$/.test(left_bound) === true && /^[^<>]*>/.test(right_bound) === true) {

                re = new RegExp("<[^<>]*$");

                re = re.exec(left_bound);

                extra_left = re[0] + extra_left;

                left_bound = left_bound.substr(0, left_bound.length - re[0].length);
            }

            var mark = valid;

            str_enclose = str;

            str_enclose = extra_left + str_enclose;

            var str_enclose_left = left_bound;

            valid = null;

            for (i = left_bound.length - 1; i >= 0 && valid !== false; i--) {

                if (left_bound.charAt(i) != ">") {

                    break;

                }else {

                    i--;
                }

                valid = false;

                for (j = i; j >= 0; j--) {

                    ca = left_bound.charAt(j);

                    if (ca == "<") {

                        valid = true;
                        break;

                    }else if (ca == ">") {

                        valid = false;
                        break;
                    }
                }

                if (valid === true) {

                    extra_left = left_bound.substr(j) + extra_left;
                    left_bound = left_bound.substr(0, j);
                    i = j;
                }
            }

            valid = null;

            if (/<[^<>]*$/.test(str) === true) {

                valid = false;

                for (i = 0; i < right_bound.length; i++) {

                    ca = right_bound.charAt(i);

                    if (ca == ">") {

                        valid = true;
                        break;

                    }else if (ca == "<") {

                        valid = false;
                        break;
                    }
                }

                if (valid === true) {

                    extra_right+= right_bound.substr(0, i + 1);
                    right_bound = right_bound.substr(i + 1);
                }

            }else if (/^[^<>]*>/.test(right_bound) === true && /<[^<>]*$/.test(left_bound) === true) {

                re = new RegExp("^[^<>]*>");

                re = re.exec(right_bound);

                extra_right+= re[0];

                right_bound = right_bound.substr(re[0].length);
            }

            mark = valid;

            str_enclose+= extra_right;

            var str_enclose_right = right_bound;

            valid = null;

            for (i = 0; i <= right_bound.length && valid !== false; i++) {

                if (right_bound.charAt(i) != "<") {

                    break;

                }else {

                    i++;
                }

                valid = false;

                for (j = i; j <= right_bound.length; j++) {

                    ca = right_bound.charAt(j);

                    if (ca == ">") {

                        valid = true;
                        break;

                    }else if (ca == "<") {

                        valid = false;
                        break;
                    }
                }

                if (valid === true) {

                    extra_right+= right_bound.substr(0, j + 1);
                    right_bound = right_bound.substr(j + 1);
                    i = -1;
                }
            }

            str = extra_left + str + extra_right;

            re = new RegExp("^(<[^<>]+>)*(<" + tag + "( [^<>]*)?>)", "i");

            var open = re.exec(str);

            re = new RegExp("<\/" + tag + "( [^<>]*)?>(<[^<>]+>)*$", "i");

            var close = re.exec(str);

            list_tmp = 0;

            if (open !== null && close !== null && enclose !== true) {

                if (attributes !== null) {

                    var newstr = this.change_attribute(open[2], attributes);

                    re = new RegExp("<" + tag + "( [^<>]*)?>", "i");

                    str = str.replace(re, newstr);

                }else {

                    re = new RegExp("<" + tag + "( [^<>]*)?>", "i");

                    str = str.replace(re, "");

                    re = new RegExp("<\/" + tag + "( [^<>]*)?>((.|\n)*)$", "i");

                    str = str.replace(re, "$2");
                }

                var text_start = 0;

                var mark_open = false;

                var mark_close = false;

                for (i = 0; i <= str.length; i++) {

                    if (str.charAt(i) == "<" && mark_open === false) {
                         mark_open = true;
                    }

                    if (str.charAt(i) == ">" && str.charAt(i + 1) != "<" && mark_open === true) {

                        text_start = i+1;
                        break;
                    }
                }

                var text_end = str.length;

                for (i = str.length; i >= 0; i--) {

                    if (str.charAt(i) == ">" && mark_close === false) {
                         mark_close = true;
                    }

                    if (str.charAt(i) == "<" && str.charAt(i - 1) != ">" && mark_close === true) {

                        text_end = i;
                        break;
                    }
                }

                active_field.value = active_field.value.substr(0, ss - extra_left.length) + str + active_field.value.substr(se + extra_right.length);

                ss = ss - extra_left.length + text_start;
                se = ss + text_end - text_start;

            }else {

                var str_mid = str;
                var str_left = "";
                var str_right = "";

                var open_found = false;
                var close_found = false;

                if (/^<[^<>]*>$/.test(str_enclose) !== true && enclose !== true) {

                    for (i = 0; i < str_mid.length; i++) {

                        ca = str_mid.charAt(i);

                        if (i === 0 && ca != "<") {
                             break;
                        }

                        open_found = true;

                        str_left+= ca;

                        if (ca == ">" && str_mid.charAt(i+1) != "<") {

                            open_found = false;
                            i++;
                            break;
                        }
                    }

                    for (j = str_mid.length-1; j>i; j--) {

                        ca = str_mid.charAt(j);

                        if (j == str_mid.length - 1 && ca != ">") {
                            break;
                        }

                        close_found = true;

                        str_right = ca + str_right;

                        if (ca == "<" && str_mid.charAt(j - 1) != ">") {

                            close_found = false;
                            j--;
                            break;
                        }
                    }

                    if (close_found === true && open_found === false) {

                        j = str_mid.length - 1;
                        str_right = "";
                    }

                    if (str_left != str) {

                        str_mid = str_mid.substr(i, j-i+1);

                    }else {

                        str_left = str_right = "";
                    }

                    if (tag == "list") {

                        open_tag = "";
                        close_tag = "";

                        list_tmp = this.parse_list(str_mid, false);

                        str_mid = list_tmp;
                        list_tmp = list_tmp.split("\n").length - 1;

                    }else if (tag == 'numberedlist') {

                        open_tag = "";
                        close_tag = "";

                        list_tmp = this.parse_list(str_mid, true);

                        str_mid = list_tmp;
                        list_tmp = list_tmp.split("\n").length - 1;

                    }else if (tag == "quote") {

                        open_tag = "<quote source=\"\" url=\"\">";
                        close_tag = "</quote>";

                    }else if (tag == 'flash') {

                        open_tag = '';
                        close_tag = '<flash src="" width="" height="" wmode="transparent" />';

                    }else if (!single_tags[tag]) {

                        open_tag = '<' + tag + this.parse_attributes(attributes) + '>';
                        close_tag = '</' + tag + '>';

                    }else {

                        open_tag = '';
                        close_tag = '<' + tag + this.parse_attributes(attributes) + '>';
                    }

                    str = str_left + open_tag + str_mid + close_tag + str_right;

                    active_field.value = active_field.value.substr(0, ss - extra_left.length) + str + active_field.value.substr(se + extra_right.length);

                    ss = ss - extra_left.length + (str_left + open_tag).length;
                    se = ss + str_mid.length;

                    if (single_tags[tag] === true) {
                         ss = se;
                    }

                }else {

                    if (tag == "list") {

                        open_tag = "";
                        close_tag = "";

                        if (/^<[^<>]+>$/.test(str_enclose) === false) {

                            list_tmp = this.parse_list(str_enclose, false);
                            str_enclose = list_tmp;

                        }else {

                            list_tmp = this.parse_list("", false);
                            str_enclose+= list_tmp;
                        }

                        list_tmp = list_tmp.split("\n").length - 1;

                    }else if (tag == "numberedlist") {

                        open_tag = "";
                        close_tag = "";

                        if (/^<[^<>]+>$/.test(str_enclose) === false) {

                            list_tmp = this.parse_list(str_enclose, true);
                            str_enclose = list_tmp;

                        }else {

                            list_tmp = this.parse_list("", true);
                            str_enclose+= list_tmp;
                        }

                        list_tmp = list_tmp.split("\n").length - 1;

                    }else if (tag == "quote") {

                        open_tag = "<quote source=\"\" url=\"\">";
                        close_tag = "</quote>";

                    }else if (!single_tags[tag]) {

                        open_tag = '<' + tag + this.parse_attributes(attributes) + '>';
                        close_tag = '</' + tag + '>';

                    }else {

                        open_tag = '';
                        close_tag = '<' + tag + this.parse_attributes(attributes) + '>';
                    }

                    active_field.value = str_enclose_left + open_tag + str_enclose + close_tag + str_enclose_right;

                    ss = str_enclose_left.length + open_tag.length;
                    se = ss + str_enclose.length;

                    if (single_tags[tag] === true) {
                         ss = se;
                    }
                }
            }

            if (active_field.setSelectionRange) {

                active_field.focus();
                active_field.setSelectionRange(ss, se);

            }else if (active_field.createTextRange) {

                ss-= active_field.value.substr(0, ss+1).split(/\n/).length - 1;
                se-= active_field.value.substr(0, se+1).split(/\n/).length - 1;
                se+= list_tmp;

                var range = active_field.createTextRange();

                range.collapse(true);
                range.moveEnd('character', se);
                range.moveStart('character', ss);
                range.select();
            }

            return str;
        },

        add_text : function(text)
        {
            if (!active_field.createTextRange && !active_field.setSelectionRange) {

                active_field.value+= text;
                return;
            }

            var str = this.get_selection();

            var ss = this.get_selection_start();

            var se = ss + str.length; // get_selection_end();

            ss = se;

            var left_bound = active_field.value.substr(0, ss);

            var right_bound = active_field.value.substr(ss);

            if (/<[^<>]*$/.test(left_bound) === true) {

                var re = new RegExp("^[^<>]*>");

                re = re.exec(right_bound);

                ss+= (re !== null) ? re[0].length : 0;
            }

            active_field.value = active_field.value.substr(0, ss) + text + active_field.value.substr(ss);

            if (active_field.setSelectionRange) {

                active_field.focus();

                active_field.setSelectionRange(ss, ss + text.length);

            }else if (active_field.createTextRange) {

                ss-= active_field.value.substr(0, ss+1).split(/\n/).length-1;

                var range = active_field.createTextRange();

                range.collapse(true);

                range.moveEnd('character', ss + text.length);

                range.moveStart('character', ss);

                range.select();
            }

            return;
        },

        get_content : function()
        {
            return active_field.value;
        },

        set_content : function(content)
        {
            active_field.value = content;
        },

        change_attribute : function(tag, attributes)
        {
            var $tag = $(tag);

            for (attr_match in attributes) {
                $tag.attr(attr_match, attributes[attr_match]);
            }

            return $('<div>').append($tag).html().split(/(^[^>]+>)<\//)[1];
        },

        add_link : function()
        {
            var url = window.prompt("URL:", "http://");

            if (url !== null && url.length > 0 && url != 'http://') {
                htmltools.add_tag("a", { "href" : url });
            }

            return;
        },

        add_image : function()
        {
            var url = window.prompt("Image URL:", "http://");

            if (url !== null && url.length > 0 && url != 'http://') {
                htmltools.add_tag("img", { "src" : url }, true);
            }

            return;
        },

        add_youtube_video : function()
        {
            var url = window.prompt("Youtube URL:", "http://");

            if (url !== null && url.length > 0 && url != 'http://') {

                htmltools.add_text(url);
                htmltools.add_tag("youtube", { }, true);
            }

            return;
        },

        auto_spell_check : function()
        {
            if (!active_field || active_field.value.length === 0) {
                 return true;
            }

            if ($('#t_check_spelling').is(':checked') && !auto_spell_check_started) {

                auto_spell_check_started= true;

                this.open_spell_check();

                return false;
            }
        },

        open_spell_check : function()
        {
            if (active_field && active_field.value.length > 0) {
                window.open('dictionary.php?webtag=' + beehive.webtag + '&obj_id=' + active_field.id, 'spellcheck','width=550, height=480, resizable=yes, scrollbars=yes');
            }
        },

        open_emoticons : function(pack)
        {
            window.open('display_emoticons.php?webtag=' + beehive.webtag + '&pack=' + pack, 'emoticons','width=500, height=400, resizable=yes, scrollbars=yes');
        },

        toggle_html : function()
        {
            $('input[type="radio"][name="t_post_html"]').each(function() {

                if ($('input[type="radio"][name="t_post_html"][value!="disabled"][checked]').length === 0) {

                    $('input[type="radio"][name="t_post_html"][value!="enabled"]').attr('checked', true);
                    return false;
                }
            });

            $('input:checkbox[name="t_post_html"]').attr('checked', true);
        },

        parse_list : function(a, num)
        {
            var nl = a.split(/[\n\r]+/);

            var re = new RegExp("^[^0-9a-z]*([0-9]+|[a-z]+)([^0-9a-z])[ ]*", "i");

            var result = re.exec(nl[0]);

            var type = 3;

            var start = 1;

            var func, str, n, c, count, i;

            if (num === true) {

                if (result !== null) {

                    n = result[1];

                    if (!isNaN(parseInt(n, 10))) {

                        type = 0;

                    }else {

                        c = 0; // lowercase

                        if (n.toLowerCase() != n) {

                            c = 1; // uppercase
                            n = n.toLowerCase();
                        }

                        if (n.length == 1) {

                            if (this.pl_roman(re.exec(nl[1])[1]) == this.pl_roman(n) + 1) {

                                func = this.pl_roman;

                            } else {

                                func = this.pl_alpha;
                            }

                        }else {

                            func = this.pl_roman;
                        }
                    }

                    start = func(n);

                    count = start;

                    for (i = 1; i < nl.length; i++) {

                        n = re.exec(nl[i])[1];

                        if (func(n) != ++count) {

                            func = this.pl_alpha;
                            break;
                        }
                    }
                }

                if (type < 3) {

                    var types = ["1", "a", "A", "i", "I"];

                    if (type > 0) {

                        type = " type=\"" + types[(type * 2 - 1) + c] + "\"";

                    }else {

                        type = "";
                    }

                    if (start > 1) {

                        start = " start=\"" + start + "\"";

                    }else {

                        start = "";
                    }

                    str = "<ol" + type + start + ">\n";

                    for (i=0; i<nl.length; i++) {

                        nl[i] = nl[i].replace(re, "");
                        nl[i] = "<li>" + nl[i] + "</li>\n";

                        str+= nl[i];
                    }

                    str+= "</ol>";

                }else {

                    str = "<ol>\n";

                    for (i = 0; i < nl.length; i++) {

                        nl[i] = "<li>" + nl[i] + "</li>\n";
                        str+= nl[i];
                    }

                    str+= "</ol>";
                }

            }else {

                str = "<ul>\n";

                for (i = 0; i < nl.length; i++) {

                    nl[i] = "<li>" + nl[i] + "</li>\n";
                    str+= nl[i];
                }

                str+= "</ul>";
            }

            return str;
        },

        pl_roman : function(b)
        {
            var a = b.toLowerCase();

            var numerals = {
                i : 1,
                v : 5,
                x : 10,
                l : 50,
                c : 100,
                d : 500,
                m : 1000
            };

            var ca, n = 0;

            for (var i = 0; i < a.length; i++) {

                ca = a.charAt(i);

                if (i == a.length - 1) {
                    return (n + numerals[ca]);
                }

                var nextca = a.charAt(i + 1);

                if ((ca == 'i' || ca == 'x' || ca == 'c') && (numerals[ca] < numerals[nextca])) {

                    n-= numerals[ca];

                }else {

                    n+= numerals[ca];
                }
            }

            return n;
        },

        pl_alpha : function(b)
        {
            var ab = "abcdefghijklmnopqrstuvwxyz";
            return (ab.indexOf(b.toLowerCase()) + 1);
        }
    };
}();

$(beehive).bind('init', function() {

    $('textarea.htmltools').each(function() {

        $(this).bind('keypress keydown keyup click change select', function() {

            htmltools.active_text(this);

        }).bind('dblclick', function() {

            htmltools.active_text(this, true);
        });

        $(this).closest('form').bind('submit', function() {
            $('textarea.htmltools').attr('caretPos', '');
        });
    });

    $(window).bind('unload', function() {
        $('textarea.htmltools').attr('caretPos', '');
    });

    $('select[name="font_face"]').bind('change', function() {

        htmltools.add_tag('font', { 'face' : $(this).val() });

        htmltools.toggle_html();

        $(this).attr('selectedIndex', 0);
    });

    $('select[name="font_size"]').bind('change', function() {

        htmltools.add_tag('font', { 'size' : $(this).val() });

        htmltools.toggle_html();

        $(this).attr('selectedIndex', 0);
    });

    $('select[name="font_colour"]').bind('change', function() {

        htmltools.add_tag('font', { 'color' : $(this).val() });

        htmltools.toggle_html();

        $(this).attr('selectedIndex', 0);
    });

    $('div.tools input').bind('click', function() {

        if (htmltools.auto_spell_check()) {
            htmltools.clear_focus();
        }
    });

    $('div.tools img').bind('mouseover', function() {

        $(this).addClass('tools_over');

    }).bind('mouseout', function() {

        $(this).removeClass('tools_over');

    }).bind('mousedown', function() {

        $(this).addClass('tools_down');

    }).bind('mouseup', function() {

        $(this).removeClass('tools_down');

    }).bind('click', function() {

        var $button = $(this).parent('a.toolbar_button');

        if ($button.length != 1) {
             return;
        }

        switch (true) {

            case $button.hasClass('button_bold'):

                htmltools.add_tag('b');
                break;

            case $button.hasClass('button_italic'):

                htmltools.add_tag('i');
                break;

            case $button.hasClass('button_underline'):

                htmltools.add_tag('u');
                break;

            case $button.hasClass('button_strikethrough'):

                htmltools.add_tag('s');
                break;

            case $button.hasClass('button_superscript'):

                htmltools.add_tag('sup');
                break;

            case $button.hasClass('button_subscript'):

                htmltools.add_tag('sub');
                break;

            case $button.hasClass('button_leftalign'):

                htmltools.add_tag('div', { 'align' : 'left' });
                break;

            case $button.hasClass('button_center'):

                htmltools.add_tag('div', { 'align' : 'center' });
                break;

            case $button.hasClass('button_rightalign'):

                htmltools.add_tag('div', { 'align' : 'right' });
                break;

            case $button.hasClass('button_numberedlist'):

                htmltools.add_tag('numberedlist', null, true);
                break;

            case $button.hasClass('button_list'):

                htmltools.add_tag('list', null, true);
                break;

            case $button.hasClass('button_indenttext'):

                htmltools.add_tag('blockquote', null, true);
                break;

            case $button.hasClass('button_code'):

                htmltools.add_tag('code', { 'language' : '' }, true);
                break;

            case $button.hasClass('button_quote'):

                htmltools.add_tag('quote', { 'source' : '' }, true);
                break;

            case $button.hasClass('button_spoiler'):

                htmltools.add_tag('spoiler', null, true);
                break;

            case $button.hasClass('button_horizontalrule'):

                htmltools.add_tag('hr', null, true);
                break;

            case $button.hasClass('button_image'):

                htmltools.add_image();
                break;

            case $button.hasClass('button_hyperlink'):

                htmltools.add_link();
                break;

            case $button.hasClass('button_spellcheck'):

                htmltools.open_spell_check();
                break;

            case $button.hasClass('button_noemoticons'):

                htmltools.add_tag('noemots', null, true);
                break;

            case $button.hasClass('button_emoticons'):

                htmltools.open_emoticons();
                break;

            case $button.hasClass('button_youtubevideo'):

                htmltools.add_youtube_video();
                break;

            case $button.hasClass('button_flash'):

                htmltools.add_tag('flash');
                break;
        }

        htmltools.toggle_html();
    });

    $('div.tools').css('display', 'block');

    $('textarea.htmltools.auto_focus').each(function() {

        htmltools.active_text(this);
        htmltools.set_focus();
    });

    $('span.fix_html_compare input[type="radio"]').bind('click', function() {

        var textarea_name = /^co_(.*)_rb$/.exec($(this).attr('name'));

        if (textarea_name[1]) {

            var $textarea = $('textarea.htmltools[name=' + textarea_name[1] + ']');

            if ($textarea.length > 0) {

                $textarea.val($(this).val());
            }
        }
    });

    $('a.fix_html_help').bind('click', function() {
        window.alert(beehive.lang.fixhtmlexplanation);
    });
});