/*======================================================================
Copyright Project BeehiveForum 2002

This file is part of BeehiveForum.

BeehiveForum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

BeehiveForum is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
USA
======================================================================*/

/* $Id: htmltools.js,v 1.27 2007-03-30 00:54:49 decoyduck Exp $ */

var selected_text = "";
var active_field = "";

var auto_check_spell_started = false;

function set_focus() {
        active_field.focus();
}

// -------------------------------------------
// Functions to retrieve the current selection
// -------------------------------------------
function active_text (t, dbl) {
        if (t.createTextRange) {        
        t.caretPos = document.selection.createRange().duplicate();      
                active_field.t = "";
        }
        active_field = t;

        if (!active_field.createTextRange && !active_field.setSelectionRange) {
                return;
        }

        if (dbl == true) {
                var s = get_selection();
                if (s.charAt(s.length-1) == " ") {
                        var ss = get_selection_start();
                        var se = get_selection_end()-1;

                        if (active_field.setSelectionRange) {
                                active_field.focus();
                                active_field.setSelectionRange(ss, se);

                        } else if (active_field.createTextRange) {
                                t.caretPos.moveEnd('character', -1);
                                t.caretPos.select();
                        }
                }
        }
}
function active_page_text () { 
        selected_text = (document.all) ? document.selection.createRange().text : window.getSelection();
}

function get_selection() {
        if (active_field.createTextRange) {
                return document.selection.createRange().text;
        } else if (active_field.setSelectionRange) {
                var selLength = active_field.textLength;
                var selStart = active_field.selectionStart;
                var selEnd = active_field.selectionEnd;
                if (selEnd == 1 || selEnd == 2) {
                        selEnd = selLength;
                }
                return (active_field.value).substring(selStart, selEnd);
        } else {
                return window.getSelection();
        }
}
function get_selection_start () {
        if (active_field.setSelectionRange) {
                return active_field.selectionStart;

        } else if (active_field.createTextRange) {
                var s = active_field.caretPos.duplicate();
                var t = active_field.value;
                var u = s.text;
                var i = 0;
                var last_s;
                var tmp_s;
                var count = 0;
                var no_sel = false;

                var gap = Math.ceil(t.length/2);
                if (u.length == 0) {
                        no_sel = true;
                        gap = 1;
                }
                while(true) {
                        if (++i > t.length * 5) { // something's gone wrong
                                break;
                        }
                        last_s = s.duplicate();
                        tmp_s = s.duplicate();

                        tmp_s.moveStart("character", -gap);

                        if (t.indexOf(tmp_s.text) > -1) {
                                s.moveStart("character", -gap);

                                // yet another IE bug - if there is no selection, just a placed cursor,
                                // then moveStart will ignore any combinations of \r\n until it hits a 
                                // non-linebreak character. "Argh".
                                if (no_sel == true) {
                                        if (last_s.text == s.text) {
                                                count++;
                                        } else {
                                                no_sel = 0;
                                                gap = Math.ceil(t.length/2);
                                        }
                                }
                        } else if (gap > 1) {
                                gap = Math.ceil(gap/2);
                        } else {
                                break;
                        }
                }

                // oldskool method - a lotlot slower than ^that, but it works, the above is "experimental"
                /*while(t.indexOf(s.text) > -1) {
                        last_s = s.duplicate();
                        s.moveStart("character", -1);

                        // yet another IE bug - if there is no selection, just a placed cursor,
                        // then moveStart will ignore any combinations of \r\n until it hits a 
                        // non-linebreak character. "Argh".
                        if (u.length == 0) {
                                if (last_s.text == s.text) {
                                        count++;
                                }
                        }
                        if (++i > t.length * 2) { // something's gone wrong
                                break;
                        }
                }*/

                if (no_sel == 0) {
                        count *= 2;
                }

                // Remove 'junk' characters before the textfield
                // See textarea() in htmltools.inc.php
                var re = new RegExp("^" + String.fromCharCode(9999) + "*\r?\n?");
                var u2 = s.text.replace(re, "");

                return (u2.length + count - u.length);
        }
}
function get_selection_end () {
        if (active_field.setSelectionRange) {
                return active_field.selectionEnd;

        } else if (active_field.createTextRange) {
                var s = active_field.caretPos.duplicate();
                var u = s.text;

                return (get_selection_start() + u.length);
        }
}
// -------------------------------------------



// ------------------------------------
// Functions to compare/update the text
// ------------------------------------
function add_tag (tag, a, v, enclose) {

        if (self.tools_feedback){
                tools_feedback();
        }

        var single_tags = {br:true, img:true, hr:true, area:true, embed:true};

//      var ua = navigator.userAgent.toLowerCase();
//      if (ua.indexOf('opera') > -1 || ua.indexOf('safari') > -1 || ua.indexOf('konqueror') > -1) {
        if (!active_field.createTextRange && !active_field.setSelectionRange) {
                if (!single_tags[tag]) {
                        var open_tag = "<" + tag + (a != null  ? " " + a + "=\"" + v + "\">" : ">");
                        var close_tag = "</" + tag + ">";
                } else {
                        var open_tag = "";
                        var close_tag = "<" + tag + (a != null  ? " " + a + "=\"" + v + "\" />" : " />");
                }
                active_field.value += open_tag + close_tag;
                return;
        }

        var str = get_selection();
        var str_enclose = str;

        var ss = get_selection_start();
        var se = ss + str.length; // get_selection_end();

        if (ss != se && str.length == 0) {
                ss = se;
        }

        var left_bound = active_field.value.substr(0, ss);
        var right_bound = active_field.value.substr(se);

        var extra_left = "", extra_right = "";
        // extra left
        if (/^[^<>]*>/.test(str) == true) {
                valid = false;
                for (var i=left_bound.length-1; i>=0; i--) {
                        var ca = left_bound.charAt(i);
                        if (ca == "<") {
                                var valid = true;
                                break;
                        } else if (ca == ">") {
                                var valid = false;
                                break;
                        }
                }
                if (valid == true) {
                        extra_left = left_bound.substr(i) + extra_left;
                        left_bound = left_bound.substr(0, i);
                }/* else {
                        str = str.replace(/(^[^<>]*)>/, "$1&gt;");
                        str_enclose = str;
                        se += 3;
                }*/
        } else if (/<[^<>]*$/.test(left_bound) == true && /^[^<>]*>/.test(right_bound) == true) {
                var re = new RegExp("<[^<>]*$");
                re = re.exec(left_bound);
                extra_left = re[0] + extra_left;
                left_bound = left_bound.substr(0, left_bound.length - re[0].length);
        }

        var mark = valid;
/*      for (i=0; i<str.length; i++) {
                ca = str.charAt(i);
                if (ca == ">" && mark != true) {
                        str = str.substr(0, i) + "&gt;" + str.substr(i+1);
                        se += 3;
                } else if (ca == ">" && mark == true) {
                        mark = false;
                } else if (ca == "<") {
                        mark = true;
                }
        }*/
        str_enclose = str;

        str_enclose = extra_left + str_enclose;
        var str_enclose_extra_left = extra_left.length;
        var str_enclose_left = left_bound;

        valid = null;
        for (var i=left_bound.length-1; i>=0 && valid != false; i--) {
                if (left_bound.charAt(i) != ">") {
                        break;
                } else {
                        i--;
                }
                valid = false;
                for (var j=i; j>=0; j--) {
                        var ca = left_bound.charAt(j);
                        if (ca == "<") {
                                var valid = true;
                                break;
                        } else if (ca == ">") {
                                var valid = false;
                                break;
                        }
                }
                if (valid == true) {
                        extra_left = left_bound.substr(j) + extra_left;
                        left_bound = left_bound.substr(0, j);
                        i = j;
                }
        }

        // extra right
        valid = null;
        if (/<[^<>]*$/.test(str) == true) {
                valid = false;
                for (var i=0; i<right_bound.length; i++) {
                        var ca = right_bound.charAt(i);
                        if (ca == ">") {
                                var valid = true;
                                break;
                        } else if (ca == "<") {
                                var valid = false;
                                break;
                        }
                }
                if (valid == true) {
                        extra_right += right_bound.substr(0, i+1);
                        right_bound = right_bound.substr(i+1);
                }/* else {
                        str = str.replace(/<([^<>]*$)/, "&lt;$1");
                        str_enclose = str_enclose.replace(/<([^<>]*$)/, "&lt;$1");
                        se += 3;
                }*/
        } else if (/^[^<>]*>/.test(right_bound) == true && /<[^<>]*$/.test(left_bound) == true) {
                var re = new RegExp("^[^<>]*>");
                re = re.exec(right_bound);
                extra_right += re[0];
                right_bound = right_bound.substr(re[0].length);
        }

        var mark = valid;
/*      for (i=str.length; i>=0; i--) {
                ca = str.charAt(i);
                if (ca == "<" && mark != true) {
                        str = str.substr(0, i) + "&lt;" + str.substr(i+1);
                        se += 3;
                } else if (ca == "<" && mark == true) {
                        mark = false;
                } else if (ca == ">") {
                        mark = true;
                }
        }*/

        str_enclose += extra_right;
        var str_enclose_extra_right = extra_right.length;
        var str_enclose_right = right_bound;

        valid = null;
        for (var i=0; i<=right_bound.length && valid != false; i++) {
                if (right_bound.charAt(i) != "<") {
                        break;
                } else {
                        i++;
                }
                valid = false;
                for (var j=i; j<=right_bound.length; j++) {
                        var ca = right_bound.charAt(j);
                        if (ca == ">") {
                                var valid = true;
                                break;
                        } else if (ca == "<") {
                                var valid = false;
                                break;
                        }
                }
                if (valid == true) {
                        extra_right += right_bound.substr(0, j+1);
                        right_bound = right_bound.substr(j+1);
                        i = -1;
                }
        }

        str = extra_left + str + extra_right;

        var re = new RegExp("^(<[^<>]+>)*(<" + tag + "( [^<>]*)?>)", "i");
        var open = re.exec(str);

        var re = new RegExp("<\/" + tag + "( [^<>]*)?>(<[^<>]+>)*$", "i");
        var close = re.exec(str);

        var list_tmp = 0;

        if (open != null && close != null && enclose != true) {
                if (a != null) {
                        var newstr = change_attribute(open[2], a, v);
                        re = new RegExp("<" + tag + "( [^<>]*)?>", "i");
                        str = str.replace(re, newstr);
                } else {
                        re = new RegExp("<" + tag + "( [^<>]*)?>", "i");
                        str = str.replace(re, "");
                        re = new RegExp("<\/" + tag + "( [^<>]*)?>((.|\n)*)$", "i");
                        str = str.replace(re, "$2");
                }

                var text_start = 0;

                var mark_open = false;
                var mark_close = false;

                for (i=0; i<=str.length; i++) {
                        if (str.charAt(i) == "<" && mark_open == false) {
                                mark_open = true;
                        }
                        if (str.charAt(i) == ">" && str.charAt(i+1) != "<" && mark_open == true) {
                                text_start = i+1;
                                break;
                        }
                }
                var text_end = str.length;
                for (i=str.length; i>=0; i--) {
                        if (str.charAt(i) == ">" && mark_close == false) {
                                mark_close = true;
                        }
                        if (str.charAt(i) == "<" && str.charAt(i-1) != ">" && mark_close == true) {
                                text_end = i;
                                break;
                        }
                }

                active_field.value = active_field.value.substr(0, ss-extra_left.length) + str + active_field.value.substr(se+extra_right.length);

                ss = ss - extra_left.length + text_start;
                se = ss + text_end - text_start;

        } else {
                var str_mid = str;
                var str_left = "";
                var str_right = "";

                var open_found = false;
                var close_found = false;

                if (/^<[^<>]*>$/.test(str_enclose) != true && enclose != true) {
                        for (i=0; i<str_mid.length; i++) {
                                var ca = str_mid.charAt(i);
                                if (i==0 && ca != "<") {
                                        break;
                                }
                                open_found = true;
                                str_left += ca;
                                if (ca == ">" && str_mid.charAt(i+1) != "<") {
                                        open_found = false;
                                        i++;
                                        break
                                }
                        }
                        for (j=str_mid.length-1; j>i; j--) {
                                var ca = str_mid.charAt(j);
                                if (j==str_mid.length-1 && ca != ">") {
                                        break;
                                }
                                close_found = true;
                                str_right = ca + str_right;
                                if (ca == "<" && str_mid.charAt(j-1) != ">") {
                                        close_found = false;
                                        j--;
                                        break
                                }
                        }

                        if (close_found == true && open_found == false) {
                                j = str_mid.length-1;
                                str_right = "";
                        }

                        if (str_left != str) {
                                str_mid = str_mid.substr(i, j-i+1);
                        } else {
                                str_left = str_right = "";
                        }

                        if (tag == "list") {
                                var open_tag = "";
                                var close_tag = "";

                                var list_tmp = parse_list(str_mid, a);
                                str_mid = list_tmp;
                                list_tmp = list_tmp.split("\n").length - 1;
                        } else if (tag == "quote") {
                                var open_tag = "<quote source=\"\" url=\"\">";
                                var close_tag = "</quote>";
                        } else if (!single_tags[tag]) {
                                var open_tag = "<" + tag + (a != null  ? " " + a + "=\"" + v + "\">" : ">");
                                var close_tag = "</" + tag + ">";
                        } else {
                                var open_tag = "";
                                var close_tag = "<" + tag + (a != null  ? " " + a + "=\"" + v + "\" />" : " />");
                        }

                        str = str_left + open_tag + str_mid + close_tag + str_right;

                        active_field.value = active_field.value.substr(0, ss-extra_left.length) + str + active_field.value.substr(se+extra_right.length);

                        ss = ss - extra_left.length + (str_left + open_tag).length;
                        se = ss + str_mid.length;
                        if (single_tags[tag] == true) {
                                ss = se;
                        }

                } else {
                        if (tag == "list") {
                                var open_tag = "";
                                var close_tag = "";

                                if (/^<[^<>]+>$/.test(str_enclose) == false) {
                                        var list_tmp = parse_list(str_enclose, a);
                                        str_enclose = list_tmp;
                                } else {
                                        var list_tmp = parse_list("", a)
                                        str_enclose += list_tmp;
                                }
                                list_tmp = list_tmp.split("\n").length - 1;
                        } else if (tag == "quote") {
                                var open_tag = "<quote source=\"\" url=\"\">";
                                var close_tag = "</quote>";
                        } else if (!single_tags[tag]) {
                                var open_tag = "<" + tag + (a != null  ? " " + a + "=\"" + v + "\">" : ">");
                                var close_tag = "</" + tag + ">";
                        } else {
                                var open_tag = "";
                                var close_tag = "<" + tag + (a != null  ? " " + a + "=\"" + v + "\" />" : " />");
                        }

                        active_field.value = str_enclose_left + open_tag + str_enclose + close_tag + str_enclose_right;

                        ss = str_enclose_left.length + open_tag.length;
                        se = ss + str_enclose.length;
                        if (single_tags[tag] == true) {
                                ss = se;
                        }
                }
        }

        if (active_field.setSelectionRange) {
                active_field.focus();
                active_field.setSelectionRange(ss, se);

        } else if (active_field.createTextRange) {
                ss -= active_field.value.substr(0, ss+1).split(/\n/).length-1;
                se -= active_field.value.substr(0, se+1).split(/\n/).length-1;
                se += list_tmp;
                var range = active_field.createTextRange();
                range.collapse(true);
                range.moveEnd('character', se);
                range.moveStart('character', ss);
                range.select();
        }
        

        return str;
}


function add_text(text) {

        // Unescape the URLencoded emoticon text.
        // We need this to remain XHTML compliant.
        
        text = unescape(text);

        if (!active_field.createTextRange && !active_field.setSelectionRange) {
                active_field.value += text;
                return;
        }

        var str = get_selection();

        var ss = get_selection_start();
        var se = ss + str.length; // get_selection_end();

        ss = se;

        var left_bound = active_field.value.substr(0, ss);
        var right_bound = active_field.value.substr(ss);

        var extra_left = "", extra_right = "";

        if (/<[^<>]*$/.test(left_bound) == true) {
                var re = new RegExp("^[^<>]*>");
                re = re.exec(right_bound);
                ss += (re != null) ? re[0].length : 0;
        }

        active_field.value = active_field.value.substr(0, ss) + text + active_field.value.substr(ss);

        if (active_field.setSelectionRange) {
                active_field.focus();
                active_field.setSelectionRange(ss, ss + text.length);

        } else if (active_field.createTextRange) {
                ss -= active_field.value.substr(0, ss+1).split(/\n/).length-1;
                var range = active_field.createTextRange();
                range.collapse(true);
                range.moveEnd('character', ss + text.length);
                range.moveStart('character', ss);
                range.select();
        }

        return;
}

function change_attribute(tag, a, v){
        tag = tag.substr(1, tag.length-2);
        var split_tag = tag.split(/\s+/);
        for(var i=1; i<split_tag.length; i++){
                var quote = split_tag[i].substr(split_tag[i].indexOf("=")+1, 1);
                if(quote == "\"" || quote == "'"){
                        var lastchar = split_tag[i].substr(split_tag[i].length-1);
                        if(lastchar != quote){
                                var tempstr = split_tag[i];
                                for(var j=i+1; j<split_tag.length; j++){
                                        tempstr += " "+split_tag[j];
                                        lastchar = split_tag[j].substr(split_tag[j].length-1);
                                        if(lastchar == quote){
                                                split_tag[i] = tempstr;
                                                split_tag.splice(i+1, j-i);
                                                break;
                                        }
                                }
                        }
                }
        }

        tempstr = split_tag[0];
        var found = false;

        for(i=1; i<split_tag.length; i++) {
                split_tag[i] = split_tag[i].split("=");
                if (split_tag[i][0] == a) {
                        split_tag[i] = a + "=\"" + v + "\"";
                        found = true;
                } else {
                        if (/^[\"\']/.test(split_tag[i][1]) == true) {
                                split_tag[i][1] = split_tag[i][1].substr(1);
                        }
                        if (/[\"\']$/.test(split_tag[i][1]) == true) {
                                split_tag[i][1] = split_tag[i][1].substr(0, split_tag[i][1].length-1);
                        }
                        split_tag[i] = split_tag[i][0] + "=\"" + split_tag[i][1] + "\"";
                }
        }
        if (found == false) {
                split_tag.push(a + "=\"" + v + "\"");
        }
        for(i=1; i<split_tag.length; i++) {
                tempstr += " " + split_tag[i];
        }

        return ("<" + tempstr + ">");
}

// Tag prompt functions
function add_link () {
        var url = prompt("URL:", "http://");
        if (url != null) {
                add_tag("a", "href", url);
        }
        return;
}

function add_image () {
        var url = prompt("Image URL:", "http://");
        if (url != null) {
                add_tag("img", "src", url, true);
        }
        return;
}

// Spell-check gubbins

var auto_check_spell_started = false;

function autoCheckSpell(webtag) {

    var form_obj;

    if (document.getElementsByName) {
        form_obj = document.getElementsByName('t_check_spelling')[0];
    }else if (document.all) {
        form_obj = document.all.t_check_spelling;
    }else if (document.layer) {
        form_obj = document.t_check_spelling;
    }else {
        return true;
    }

    if (active_field.value.length == 0) return true;

    if (form_obj.checked == true && !auto_check_spell_started) {

        auto_check_spell_started = true;
        openSpellCheck(webtag);
                return false;
    }
}

function openSpellCheck(webtag) {
    
    if (active_field.value.length > 0) {
    
        dictionarywin = window.open('dictionary.php?webtag=' + webtag + '&obj_id=' + active_field.id, 'spellcheck','width=450, height=550, resizable=yes, scrollbars=yes');
    }
}

// Emoticon preview popup
function openEmoticons(pack, webtag) {
        window.open('display_emoticons.php?webtag=' + webtag + '&pack=' + pack, 'emoticons','width=500, height=400, resizable=yes, scrollbars=yes');
}

// Used in auto-list-thing
function parse_list (a, num) {
        var nl = a.split(/[\n\r]+/);
        var ab = "abcdefghijklmnopqrstuvwxyz";
        var funcs = ["parseInt", "pl_alpha", "pl_roman"];

        var re = new RegExp("^[^0-9a-z]*([0-9]+|[a-z]+)([^0-9a-z])[ ]*", "i");
        var result = re.exec(nl[0]);

        var type = 3;
        var start = 1;
        if (num == true) {
                if (result != null) {
                        var n = result[1];
                        if (!isNaN(parseInt(n))) {
                                type = 0;
                        } else {
                                var c = 0; // lowercase
                                if (n.toLowerCase() != n) {
                                        c = 1; // uppercase
                                        n = n.toLowerCase();
                                }
                                
                                if (n.length == 1) {
                                        if (pl_roman(re.exec(nl[1])[1]) == pl_roman(n) + 1) {
                                                type = 2;
                                        } else {
                                                type = 1;
                                        }
                                } else {
                                        type = 2;
                                }
                        }
                        start = eval(funcs[type])(n);
                        var count = start;

                        for (var i=1; i<nl.length; i++) {
                                n = re.exec(nl[i])[1];
                                if (eval(funcs[type])(n) != ++count) {
                                        type = 3;
                                        break
                                }
                        }
                }

                if (type < 3) {
                        var types = ["1", "a", "A", "i", "I"];
                        if (type > 0) {
                                type = " type=\"" + types[(type*2 - 1) + c] + "\"";
                        } else {
                                type = "";
                        }

                        if (start > 1) {
                                start = " start=\"" + start + "\"";
                        } else {
                                start = "";
                        }

                        var str = "<ol" + type + start + ">\n";
                        for (i=0; i<nl.length; i++) {
                                nl[i] = nl[i].replace(re, "");
                                nl[i] = "<li>" + nl[i] + "</li>\n";
                                
                                str += nl[i];
                        }
                        str += "</ol>";
                } else {
                        var str = "<ol>\n";
                        for (i=0; i<nl.length; i++) {
                                nl[i] = "<li>" + nl[i] + "</li>\n";
                                str += nl[i];
                        }
                        str += "</ol>";
                }
        } else {
                var str = "<ul>\n";
                for (i=0; i<nl.length; i++) {
                        nl[i] = "<li>" + nl[i] + "</li>\n";
                        str += nl[i];
                }
                str += "</ul>";
        }

        return str;
}
function pl_roman (b) {
        var a = b.toLowerCase();

        var numerals = new Array();
        numerals['i'] = 1;
        numerals['v'] = 5;
        numerals['x'] = 10;
        numerals['l'] = 50;
        numerals['c'] = 100;
        numerals['d'] = 500;
        numerals['m'] = 1000;

        var n = 0;
        for (var i = 0; i<a.length; i++) {
                var ca = a.charAt(i);
                if (i == a.length-1) {
                        return (n + numerals[ca]);
                }
                var nextca = a.charAt(i+1);
                if ((ca == 'i' || ca == 'x' || ca == 'c') && numerals[ca] < numerals[nextca]) {
                        n -= numerals[ca];
                } else {
                        n += numerals[ca];
                }
        }
        return n;
}
function pl_alpha (b) {
        var ab = "abcdefghijklmnopqrstuvwxyz";
        return (ab.indexOf(b.toLowerCase()) + 1);
}

function _escape(a) {
        a = escape(a);
        a = a.replace(/\//g,"%2F");
        a = a.replace(/\?/g,"%3F");
        a = a.replace(/=/g,"%3D");
        a = a.replace(/&/g,"%26");
        a = a.replace(/@/g,"%40");
        return a;
}
// ------------------------------------



// -----------------------------
// Toolbar-related DHTML scripts
// -----------------------------
function show_hide(layer_ref, state) { 
        if (document.all) { //IS IE 4 or 5 (or 6 beta) 
                eval( "document.all." + layer_ref + ".style.display = state"); 
        } else if (document.layers) { //IS NETSCAPE 4 or below 
                document.layers[layer_ref].display = state; 
        } else if (document.getElementById &&!document.all) { 
                var hza = document.getElementById(layer_ref); 
                hza.style.display = state; 
        } 
} 

function m_ov (b) {
        b.className = "tools_over";
}

function m_ou (b) {
        b.className = "tools_up";
}

function m_d (b) {
        b.className = "tools_down";
}

function m_u (b) {
        b.className = "tools_over";
}
// -----------------------------
