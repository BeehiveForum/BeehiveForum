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
//            (e.g. close open tags, filter certain tags)
//            N.B. filtering comments (!--) or xmp tags will
//            also filter everything within the tag pair

// "$bad_tags" is an array of tags to be filtered
function fix_html($html, $bad_tags = array("plaintext", "applet", "body", "html", "head", "title", "base", "meta", "!doctype", "button", "fieldset", "form", "frame", "frameset", "iframe", "input", "label", "legend", "link", "noframes", "noscript", "object", "optgroup", "option", "param", "script", "select", "style", "textarea"))
{
	if (!empty($html)) {
		$html = stripslashes($html);

		$open_pos = strpos($html, "<");
		$next_open_pos = strpos($html, "<", $open_pos+1);
		$close_pos = strpos($html, ">");
		$html_parts = array();

		while(is_integer($open_pos) || is_integer($close_pos)){
			if(substr($html, $open_pos+1, 3) == "!--"){
				$end_comment = strpos($html, "-->", $open_pos);
				if(!is_integer($end_comment)){
					$html = substr_replace($html, " -->", $open_pos+4, 0);
					$end_comment = $open_pos+5;
				}
				if(substr($html, $open_pos+4, 1) != " "){
					$html = substr_replace($html, " ", $open_pos+4, 0);
					$end_comment++;
				}
				array_push($html_parts, substr($html, 0, $open_pos));
				array_push($html_parts, substr($html, $open_pos+1, $end_comment-$open_pos+1));

				$html = substr($html, $end_comment+3);

			} else if(substr($html, $open_pos+1, 3) == "xmp"){
				$html = substr_replace($html, "", $open_pos+4, $close_pos-$open_pos-4);
				$end_xmp = strpos($html, "</xmp", $open_pos);
				if(!is_integer($end_xmp)){
					$html = substr_replace($html, "</xmp>", $open_pos+5, 0);
					$end_xmp = $open_pos+5;
				} else {
					$close_pos = strpos($html, ">", $closepos);
					$html = substr_replace($html, "", $end_xmp+5, $close_pos-$end_xmp-4);
				}
				array_push($html_parts, substr($html, 0, $open_pos));
				array_push($html_parts, substr($html, $open_pos+1, $end_xmp-$open_pos+4));

				$html = substr($html, $end_xmp+6);

			} else if(!is_integer($open_pos) || $close_pos < $open_pos){
				// > by itself
				$html = substr_replace($html, "&gt;", $close_pos, 1);

			} else if(!is_integer($close_pos)){
				// < by itself
				$html = substr_replace($html, "&lt;", $open_pos, 1);

			} else if($next_open_pos < $close_pos && is_integer($next_open_pos)){
				// < inside <..>
				$html = substr_replace($html, "&lt;", $open_pos, 1);

			} else if($open_pos+1 == $close_pos || substr($html, $open_pos+1, 1) == " "){
				// empty tag < >
				$html = substr_replace($html, "&lt;", $open_pos, 1);
				$html = substr_replace($html, "&gt;", $close_pos+3, 1);

			} else {
				// normal <..>
				array_push($html_parts, substr($html, 0, $open_pos));
				array_push($html_parts, substr($html, $open_pos+1, $close_pos-$open_pos-1));

				$html = substr($html, $close_pos+1);
			}

			$html_length = strlen($html);

			$open_pos = strpos($html, "<");
			if($open_pos < $html_length){
				$next_open_pos = strpos($html, "<", $open_pos+1);
				$close_pos = strpos($html, ">");
			} else {
				$next_open_pos = false;
				$close_pos = false;
			}
		}
		$html_parts[count($html_parts)] .= $html;

		$opentags = array();
		$last_tag = array();
		$single_tags = array("br", "img", "hr", "!--", "area", "embed", "xmp");
		$no_nest = array("p");

		for($i=0; $i<count($html_parts); $i++){
			if($i%2){
				if(substr($html_parts[$i],0,1) == "/"){ // closing tag
					$tag_bits = explode(" ", substr($html_parts[$i],1));
					if(substr($tag_bits[0], -1) == "/"){
						$tag_bits[0] = strtolower(substr($tag_bits[0], 0, -1));
					}

					$tag = $tag_bits[0];

					// filter 'bad' tags
					if(in_array($tag, $bad_tags)){
						$html_parts[$i-1] .= $html_parts[$i+1];
						array_splice($html_parts, $i, 2);
						$i -= 2;

					} else {
						$last_tag2 = array_pop($last_tag);

						// tag is both opened/closed correctly
						if($opentags[$tag] > 0 && $last_tag2 == $tag){
							$opentags[$tag]--;

						// tag hasn't been opened
						} else if($opentags[$tag] <= 0){
							$html_parts[$i-1] .= $html_parts[$i+1];
							array_splice($html_parts, $i, 2);
							$i--;

						// tag hasn't been closed
						} else if ($last_tag2 != $tag){
							array_splice($html_parts, $i, 0, array("/".$last_tag2,""));
							$opentags[$last_tag2]--;
							$i++;

						}
					}

				} else {
					if(substr($html_parts[$i], -1) == "/"){
						$html_parts[$i] = substr($html_parts[$i], 0, -1);
					}

					$firstspace = strpos($html_parts[$i], " ");

					$firstthree = substr($html_parts[$i], 0, 3);
					if($firstthree == "!--" || $firstthree == "xmp"){
						$tag = $firstthree;

					} else if(is_integer($firstspace)){
						$html_parts[$i] = clean_attributes($html_parts[$i]);

						$tag = substr($html_parts[$i], 0, $firstspace);

					} else {
						$tag = strtolower($html_parts[$i]);

						$html_parts[$i] = $tag;
					}

					// filter 'bad' tags
					if(in_array($tag, $bad_tags)){
						$html_parts[$i-1] .= $html_parts[$i+1];
						array_splice($html_parts, $i, 2);
						$i -= 2;

					} else if(!in_array($tag, $single_tags)){
						$opentags[$tag]++;
						array_push($last_tag, $tag);

						// make sure certain tags can't nest within themselves, e.g. <p><p>
						if(in_array($tag, $no_nest) && $opentags[$tag] > (1 + $opentags["table"])){

							for($j=count($last_tag)-2;$j>=0;$j--){
								if($last_tag[$j] == $tag){
									array_splice($last_tag, $j, 1);
									break;
								} else {
									array_splice($html_parts, $i, 0, array("/".$last_tag[$j], ""));
									$opentags[$last_tag[$j]]--;
									array_splice($last_tag, $j, 1);	
									$i+=2;
								}
							}
							array_splice($html_parts, $i, 0, array("/".$tag, ""));
							$opentags[$tag]--;
							$i+=2;
						}
					// make XHTML single tag
					} else if(substr($html_parts[$i], -2) != "--" && substr($html_parts[$i], -2) != " /" && substr($html_parts[$i], -3) != "xmp"){
						if(substr($html_parts[$i], -1) != "/"){
							$html_parts[$i] .= " /";
						} else {
							$html_parts[$i] = substr($html_parts[$i], 0, -1)." /";
						}
					}
				}
			}
		}
		// reconstruct the HTML
		for($i=0; $i<count($html_parts); $i++){
			if($i%2){
				$ret_text .= "<$html_parts[$i]>";
			} else {
				$ret_text .= $html_parts[$i];
			}
		}
		$reverse_ot = array_reverse($opentags);

		// add unclosed/unnested tags
		foreach($reverse_ot as $tag => $n){
			for($i=0;$i<$n;$i++){
				$ret_text .= "</$tag>";
			}
		}
		return $ret_text;

	}else{
		return "";
	}
}

// $tag being everything with the < and >, e.g. $tag = 'a href="file.html"';
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

	$valid["table"] = array("border", "cellspacing", "cellpadding", "width", "height", "summary", "bgcolor", "background", "frame", "rules");
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


	$split_tag = preg_split("/\s+/", $tag);
	for($i=1; $i<count($split_tag); $i++){
		$quote = substr($split_tag[$i], strpos($split_tag[$i], "=")+1, 1);
		if($quote == "\"" || $quote == "'"){
			$lastchar = substr($split_tag[$i], -1);
			if($lastchar != $quote){
				$tempstr = $split_tag[$i];
				for($j=$i+1; $j<count($split_tag); $j++){
					$tempstr .= " ".$split_tag[$j];
					$lastchar = substr($split_tag[$j], -1);
					if($lastchar == $quote){
						$split_tag[$i] = $tempstr;
						array_splice($split_tag, $i+1, $j-$i);
						break;
					}
				}
			}
		}
	}
	$tag_name = strtolower($split_tag[0]);

	$valid_tags = array_keys($valid);
	if(in_array($tag_name, $valid_tags)){
		for($i=1;$i<count($split_tag);$i++){
			$attrib = explode("=", $split_tag[$i]);

			if(!in_array(strtolower($attrib[0]), $valid[$tag_name]) && !in_array(strtolower($attrib[0]), $valid["_global"])){
				array_splice($split_tag, $i, 1);
				$i--;
			} else {
				$tmp_attrib = strtolower($attrib[0])."=";
				$attrib_value = substr($split_tag[$i], strlen($tmp_attrib));

				$first_char = substr($attrib_value, 0, 1);			
				$last_char = substr($attrib_value, -1);

				if($first_char == "\"" || $first_char == "'"){
					$attrib_value = substr($attrib_value, 1);
				}
				if($last_char == "\"" || $last_char == "'"){
					$attrib_value = substr($attrib_value, 0, -1);
				}

				$tmp_attrib .= "\"".$attrib_value."\"";

				$split_tag[$i] = $tmp_attrib;
			}
		}
	} else {
		for($i=1;$i<count($split_tag);$i++){
			$attrib = explode("=", $split_tag[$i]);

			if(!in_array(strtolower($attrib[0]), $valid["_global"])){
				array_splice($split_tag, $i, 1);
				$i--;
			} else {
				$tmp_attrib = strtolower($attrib[0])."=";
				$attrib_value = substr($split_tag[$i], strlen($tmp_attrib));

				$first_char = substr($attrib_value, 0, 1);			
				$last_char = substr($attrib_value, -1);

				if($first_char == "\"" || $first_char == "'"){
					$attrib_value = substr($attrib_value, 1);
				}
				if($last_char == "\"" || $last_char == "'"){
					$attrib_value = substr($attrib_value, 0, -1);
				}

				$tmp_attrib .= "\"".$attrib_value."\"";

				$split_tag[$i] = $tmp_attrib;
			}
		}
	}

	$new_tag = $tag_name;
	for($i=1;$i<count($split_tag);$i++){
		$new_tag .= " ".$split_tag[$i];
	}

	return $new_tag;
}

// $text to be filtered
// $regex expression, e.g. "(word1|word2)", to be unimaginative
// $join is the replacement text, e.g. "<font color=\"white\">\\0</font>"
function preg_filter($text, $regex, $join)
{
	$ret_text = preg_replace("/".$regex."/i", $join, $text);
	return $ret_text;
}

?>