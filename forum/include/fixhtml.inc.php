<?php
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

// fix_html - process html to prevent it breaking the forum
//        (e.g. close open tags, filter certain tags)

// "$bad_tags" is an array of tags to be filtered
function fix_html($html, $bad_tags = array("plaintext", "applet", "body", "html", "head", "title", "base", "meta", "!doctype", "button", "fieldset", "form", "frame", "frameset", "iframe", "input", "label", "legend", "link", "noframes", "noscript", "object", "optgroup", "option", "param", "script", "select", "style", "textarea", "xmp"))
{

    $ret_text = '';
    $html = preg_replace("/<!--[^>]*>/", "", $html);

    if (!empty($html)) {

        $html = _stripslashes($html);

        $open_pos = strpos($html, "<");
        $next_open_pos = strpos($html, "<", $open_pos+ 1);
        $close_pos = strpos($html, ">");

        $html_parts = preg_split('/<([^<>]+ )>/', $html, -1, PREG_SPLIT_DELIM_CAPTURE);

        for ($i = 0; $i < count($html_parts); $i++) {
            if ($i % 2) {
                if (substr($html_parts[$i], 0, 4) == "code") {
                    $tmpcode = "";
                    $html_parts[$i] = "pre";
                    for ($j = $i+ 1; $j<count($html_parts); $j++) {
                        if ($j % 2) {
                            if (substr($html_parts[$j], 0, 5) == "/code") {
                                $html_parts[$j] = "/pre";
                                array_splice($html_parts, $i+ 1, $j-$i-1, $tmpcode);
                                $tmpcode = "<closed>";
                                break;
                            }else {
                                $tmpcode.= "<".$html_parts[$j].">";
                            }
                        }else {
                            $tmpcode.= $html_parts[$j];
                        }
                    }
                    if ($tmpcode != "<closed>") {
                        array_splice($html_parts, $i+ 1, 0, array("", "/pre"));
                        $i += 2;
                    }
                }
            }else {
                $html_parts[$i] = htmlspecialchars($html_parts[$i]);
            }
        }

        $opentags = array();
        $last_tag = array();
        $single_tags = array("br", "img", "hr", "area", "embed");

        $no_nest = array();
        $no_nest["p"] = array("table", "li");
        $no_nest["li"] = array("ul", "ol");
        $no_nest["td"] = array("tr");
        $no_nest["tr"] = array("table");

        $nest = array();
        $nest["td"] = array("tr");
        $nest["th"] = array("tr");
        $nest["tr"] = array("table");
        $nest["tbody"] = array("table");
        $nest["tfoot"] = array("table");
        $nest["thead"] = array("table");
        $nest["caption"] = array("table");
        $nest["colgroup"] = array("table");
        $nest["col"] = array("table");

        $nest["map"] = array("area");
        $nest["param"] = array("object");
        $nest["li"] = array("ul", "ol");

        for ($i = 0; $i<count($html_parts); $i++) {
            if ($i % 2) {
                if (substr($html_parts[$i], 0, 1) == "/") { // closing tag
                    $tag_bits = explode(" ", substr($html_parts[$i], 1));
                    if (substr($tag_bits[0], -1) == "/") {
                        $tag_bits[0] = substr($tag_bits[0], 0, -1);
                    }
                    $tag = strtolower($tag_bits[0]);
                    $html_parts[$i] = "/".$tag;
                    // filter 'bad' tags or single tags
                    if (in_array($tag, $bad_tags) || in_array($tag, $single_tags)) {
                        $html_parts[$i-1].= $html_parts[$i+ 1];
                        array_splice($html_parts, $i, 2);
                        $i -= 2;
                    }else {
                        $last_tag2 = array_pop($last_tag);
                        if ($opentags[$tag] > 0 && $last_tag2 == $tag) { // tag is both opened/closed correctly
                            $opentags[$tag]--;
                        }else if ($opentags[$tag] <= 0) { // tag hasn't been opened
                            $html_parts[$i-1].= $html_parts[$i+ 1];
                            array_splice($html_parts, $i, 2);
                            $i--;
                            array_push($last_tag, $last_tag2);
                        }else if ($last_tag2 != $tag) { // previous tag hasn't been closed
                            // wrap white-text
                            if (preg_match("/( )?\s+ $/", $html_parts[$i-1], $ws)) {
                                $html_parts[$i-1] = preg_replace("/( )?\s+ $/", "$1", $html_parts[$i-1]);
                            }
                            array_splice($html_parts, $i, 0, array("/".$last_tag2, $ws[0]));
                            $opentags[$last_tag2]--;
                            $i++;
                        }
                    }
                }else {
                    if (substr($html_parts[$i], -1) == "/") {
                        $html_parts[$i] = substr($html_parts[$i], 0, -1);
                    }
                    $firstspace = strpos($html_parts[$i], " ");
                    if (is_integer($firstspace)) {
                        $html_parts[$i] = clean_attributes($html_parts[$i]);
                        $tag = substr($html_parts[$i], 0, $firstspace);
                    }else {
                        $tag = strtolower($html_parts[$i]);
                        $html_parts[$i] = $tag;
                    }
                    // filter 'bad' tags
                    if (in_array($tag, $bad_tags)) {
                        $html_parts[$i-1].= $html_parts[$i+ 1];
                        array_splice($html_parts, $i, 2);
                        $i -= 2;
                    }else if (!in_array($tag, $single_tags)) {
                        $opentagcount = 0;
                        if (isset($nest[$tag])) {
                            for ($j = 0; $j<count($nest[$tag]); $j++) {
                                if (isset($opentags[$nest[$tag][$j]])) {
                                    $opentagcount += $opentags[$nest[$tag][$j]];
                                }
                            }
                        }
                        if (isset($nest[$tag]) && $opentagcount == 0) {
                            $tmp_nest = $tag;
                            $last_tag2 = array_pop($last_tag);
                            $tmp_tags = array($last_tag2);
                            $tmp_len = $i;
                            while (isset($nest[$tmp_nest])) {
                                if (in_array($last_tag2, $nest[$tmp_nest])) {
                                    break;
                                }
                                array_splice($html_parts, $tmp_len, 0, array($nest[$tmp_nest][0], ""));
                                $i += 2;
                                array_splice($tmp_tags, 1, 0, $nest[$tmp_nest][0]);
                                $last_tag2 = $tmp_tags[1];
                                $tmp_nest = $nest[$tmp_nest][0];
                            }
                            $tmp_len = count($last_tag);
                            for ($j = 0; $j<count($tmp_tags); $j++) {
                                if (strlen($tmp_tags[$j]) > 0) {
                                    array_push($last_tag, $tmp_tags[$j]);
                                    if ($j != 0) {
                                        if (isset($opentags[$tmp_tags[$j]])) {
                                            $opentags[$tmp_tags[$j]]++;
                                        }else {
                                            $opentags[$tmp_tags[$j]] = 1;
                                        }
                                    }
                                }
                            }
                        }

                        array_push($last_tag, $tag);
                        if (in_array($tag, array_keys($opentags))) {
                            $opentags[$tag]++;
                        }else {
                            $opentags[$tag] = 1;
                        }
                        // make sure certain tags can't nest within themselves, e.g. <p><p>
                        if (isset($no_nest[$tag])) {
                            $opencount = 0;
                            for ($j = 0; $j<count($no_nest[$tag]); $j++) {
                                if (in_array($no_nest[$tag][$j], array_keys($opentags))) {
                                    $opencount += $opentags[$no_nest[$tag][$j]];
                                }else {
                                    $opencount++; //$opentags[$no_nest[$tag][$j]];
                                }
                            }
                            if ($tag == "p") $opencount++;
                            if ($opentags[$tag] > $opencount) {
                                for ($j = count($last_tag)-2; $j >= 0; $j--) {
                                    if ($last_tag[$j] == $tag) {
                                        array_splice($last_tag, $j, 1);
                                        break;
                                    }else {
                                        array_splice($html_parts, $i, 0, array("/".$last_tag[$j], ""));
                                        // wrap white-text
                                        if (preg_match("/( )?\s+ $/", $html_parts[$i-1], $ws)) {
                                            $html_parts[$i-1] = preg_replace("/( )?\s+ $/", "$1", $html_parts[$i-1]);
                                            $html_parts[$i+ 1] = $ws[0].$html_parts[$i+ 1];
                                        }
                                        $opentags[$last_tag[$j]]--;
                                        array_splice($last_tag, $j, 1);
                                        $i+= 2;
                                    }
                                }
                                array_splice($html_parts, $i, 0, array("/".$tag, ""));
                                // wrap white-text
                                if (preg_match("/( )?\s+ $/", $html_parts[$i-1], $ws)) {
                                    $html_parts[$i-1] = preg_replace("/( )?\s+ $/", "$1", $html_parts[$i-1]);
                                    $html_parts[$i+ 1] = $ws[0].$html_parts[$i+ 1];
                                }
                                $opentags[$tag]--;
                                $i+= 2;
                            }
                        }
                    }else if (substr($html_parts[$i], -2) != " /") { // make XHTML single tag
                        if (substr($html_parts[$i], -1) != "/") {
                            $html_parts[$i].= " /";
                        }else {
                            $html_parts[$i] = substr($html_parts[$i], 0, -1)." /";
                        }
                    }
                }
            }
        }
        // reconstruct the HTML
        for ($i = 0; $i<count($html_parts); $i++) {
            if ($i % 2) {
                $ret_text.= "<$html_parts[$i]>";
            }else {
                $ret_text.= $html_parts[$i];
            }
        }

        $reverse_lt = array_reverse($last_tag);
        for ($i = 0; $i<count($reverse_lt); $i++) {
            $ret_text.= "</".$reverse_lt[$i].">";
        }

        return $ret_text;

    }else {
        return "";
    }
}

// $tag being everything with the < and >, e.g. $tag = 'a href = "file.html"';
function clean_attributes($tag)
{
    $valid = array();
    $valid["_global"] = array("style", "align", "class", "id", "title", "dir", "lang", "accesskey", "tabindex");
    $valid["a"] = array("href", "title");
    $valid["hr"] = array("size", "width", "noshade");
    $valid["font"] = array("size", "color", "face");
    $valid["blockquote"] = array("cite");
    $valid["del"] = array("cite", "datetime");
    $valid["ins"] = $valid["del"];
    $valid["img"] = array("src", "width", "height", "alt", "border", "usemap", "longdesc", "vspace", "hspace", "ismap");
    $valid["map"] = array("name");
    $valid["area"] = array("shape", "coords", "href", "alt", "nohref");
    $valid["table"] = array("border", "cellspacing", "cellpadding", "width", "height", "summary", "bgcolor", "background", "frame", "rules", "bordercolor");
    $valid["tbody"] = array("char", "charoff", "valign");
    $valid["tfoot"] = $valid["tbody"];
    $valid["thead"] = $valid["tbody"];
    $valid["td"] = array("abbr", "axis", "bgcolor", "char", "charoff", "colspan", "height", "headers", "rowspan", "scope", "valign", "width", "nowrap");
    $valid["th"] = $valid["td"];
    $valid["tr"] = array("bgcolor", "char", "charoff", "valign");
    $valid["colgroup"] = array("span", "width", "char", "charoff", "valign");
    $valid["col"] = $valid["colgroup"];
    $valid["ul"] = array("type", "start");
    $valid["ol"] = $valid["ul"];
    $valid["il"] = $valid["ul"];
    $valid["embed"] = array("src", "type", "pluginspage", "pluginurl", "border", "frameborder", "height", "width", "units", "hidden", "hspace", "vspace", "name", "palette", "wmode", "menu", "bgcolor");
    $valid["object"] = array("archive", "classid", "codebase", "codetype", "data", "declare", "height", "width", "name", "standby", "type", "usemap");
    $valid["param"] = array("name", "id", "value", "valuetype", "type");
    $valid["marquee"] = array("direction", "behavior", "loop", "scrollamount", "scrolldelay", "height", "width", "hspace", "vspace");
    $split_tag = preg_split("/\s+ /", $tag);
    for ($i = 1; $i<count($split_tag); $i++) {
        $quote = substr($split_tag[$i], strpos($split_tag[$i], " = ")+ 1, 1);
        if ($quote == "\"" || $quote == "'") {
            $lastchar = substr($split_tag[$i], -1);
            if ($lastchar != $quote) {
                $tempstr = $split_tag[$i];
                for ($j = $i+ 1; $j<count($split_tag); $j++) {
                    $tempstr.= " ".$split_tag[$j];
                    $lastchar = substr($split_tag[$j], -1);
                    if ($lastchar == $quote) {
                        $split_tag[$i] = $tempstr;
                        array_splice($split_tag, $i+ 1, $j-$i);
                        break;
                    }
                }
            }
        }
    }
    $tag_name = strtolower($split_tag[0]);
    $valid_tags = array_keys($valid);
    if (in_array($tag_name, $valid_tags)) {
        for ($i = 1; $i<count($split_tag); $i++) {
            $attrib = explode(" = ", $split_tag[$i]);
            if (!in_array(strtolower($attrib[0]), $valid[$tag_name]) && !in_array(strtolower($attrib[0]), $valid["_global"])) {
                array_splice($split_tag, $i, 1);
                $i--;
            }else {
                $tmp_attrib = strtolower($attrib[0])." = ";
                $attrib_value = substr($split_tag[$i], strlen($tmp_attrib));
                $first_char = substr($attrib_value, 0, 1);
                $last_char = substr($attrib_value, -1);
                if ($first_char == "\"" || $first_char == "'") {
                    $attrib_value = substr($attrib_value, 1);
                }
                if ($last_char == "\"" || $last_char == "'") {
                    $attrib_value = substr($attrib_value, 0, -1);
                }
                $tmp_attrib.= "\"".$attrib_value."\"";
                $split_tag[$i] = $tmp_attrib;
            }
        }
    }else {
        for ($i = 1; $i<count($split_tag); $i++) {
            $attrib = explode(" = ", $split_tag[$i]);
            if (!in_array(strtolower($attrib[0]), $valid["_global"])) {
                array_splice($split_tag, $i, 1);
                $i--;
            }else {
                $tmp_attrib = strtolower($attrib[0])." = ";
                $attrib_value = substr($split_tag[$i], strlen($tmp_attrib));
                $first_char = substr($attrib_value, 0, 1);
                $last_char = substr($attrib_value, -1);
                if ($first_char == "\"" || $first_char == "'") {
                    $attrib_value = substr($attrib_value, 1);
                }
                if ($last_char == "\"" || $last_char == "'") {
                    $attrib_value = substr($attrib_value, 0, -1);
                }
                $tmp_attrib.= "\"".$attrib_value."\"";
                $split_tag[$i] = $tmp_attrib;
            }
        }
    }
    $new_tag = $tag_name;
    for ($i = 1; $i<count($split_tag); $i++) {
        $new_tag.= " ".$split_tag[$i];
    }
    return $new_tag;
}

// $text to be filtered
// $regex expression, e.g. "(word1|word2)", to be unimaginative
// $join is the replacement text, e.g. "<font color = \"white\">\\0</font>"
function preg_filter($text, $regex, $join)
{
    $ret_text = preg_replace("/".$regex."/i", $join, $text);
    return $ret_text;
}

?>