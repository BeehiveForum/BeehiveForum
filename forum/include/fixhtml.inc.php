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

/* $Id: fixhtml.inc.php,v 1.82 2004-08-02 00:32:29 tribalonline Exp $ */

include_once("./include/beautifier.inc.php");
include_once("./include/emoticons.inc.php");
include_once("./include/html.inc.php");

$fix_html_code_text = 'code:';
$fix_html_quote_text = 'quote:';
$fix_html_spoiler_text = 'spoiler:';

// fix_html - process html to prevent it breaking the forum
//            (e.g. close open tags, filter certain tags)

// "$bad_tags" is an array of tags to be filtered

function fix_html ($html, $emoticons = true, $bad_tags = array("plaintext", "applet", "body", "html", "head", "title", "base", "meta", "!doctype", "button", "fieldset", "form", "frame", "frameset", "iframe", "input", "label", "legend", "link", "noframes", "noscript", "object", "optgroup", "option", "param", "script", "select", "style", "textarea", "xmp"))
{

	global $fix_html_code_text;
	global $fix_html_quote_text;
	global $fix_html_spoiler_text;

	global $beaut_highlighter;

	$ret_text = '';

	if (!empty($html)) {
		$html_parts = preg_split('/<([^<>]+)>/', $html, -1, PREG_SPLIT_DELIM_CAPTURE);

		$htmltags = array("a", "abbr", "acronym", "address", "applet", "area", "b", "base", "basefont", "bdo", "big", "blockquote", "body", "br", "button", "caption", "center", "cite", "code", "col", "colgroup", "dd", "del", "dfn", "dir", "div", "dl", "dt", "em", "embed", "fieldset", "font", "form", "frame", "frameset", "h1", "h2", "h3", "h4", "h5", "h6", "head", "hr", "html", "i", "iframe", "img", "input", "ins", "isindex", "kbd", "label", "legend", "li", "link", "map", "marquee", "menu", "meta", "noemots", "noframes", "noscript", "object", "ol", "optgroup", "option", "p", "param", "pre", "q", "quote", "s", "samp", "script", "select", "small", "span", "spoiler", "strike", "strong", "style", "sub", "sup", "table", "tbody", "td", "textarea", "tfoot", "th", "thead", "title", "tr", "tt", "u", "ul", "var");

		$htmltags = array_diff($htmltags, $bad_tags);
		$bad_tags = array();

		for ($i=0;$i<count($html_parts);$i++) {
			if ($i%2) {
				// remove trailing / in single tags: <  />
				$html_parts[$i] = preg_replace("/\s*\/?$/", "", $html_parts[$i]);

				// BH tag <code> replace
				// <code><b>Text</b></code>
				// with
				// <pre>&lt;b&gt;Text&lt;b&gt;</pre>
				$tag = explode(" ", $html_parts[$i]);
				if (substr($tag[0], 0, 1) == "/") {
					$close = true;
					$tag = substr($tag[0], 1);
				} else {
					$close = false;
					$tag = $tag[0];
				}
				$tag = strtolower($tag);
				if (in_array($tag, $htmltags)) {
					if ($tag == "code" && $close == true) {
						$html_parts[$i] = "/pre";
					} else if ($tag == "code") {
						$lang_tmp = array();
						preg_match("/ language=[\"\']?([^\"\']+)/i", $html_parts[$i], $lang_tmp);
						$lang = isset($lang_tmp[1]) ? $lang_tmp[1] : "";

						$tmpcode = "";
						$html_parts[$i] = "pre class=\"code\"";
						$open_code = 1;
						for ($j=$i+1;$j<count($html_parts);$j++) {
							if ($j%2) {
								if (substr($html_parts[$j], 0, 5) == "/code") {
									if ($open_code == 1) {
										$html_parts[$j] = "/pre";

										if (isset($beaut_highlighter[strtolower($lang)])) {
											set_error_handler("fix_html_error_handler");
											$tmpcode = $beaut_highlighter[strtolower($lang)]->highlight_text($tmpcode);
											restore_error_handler();

					//						$tmpcode = str_replace("        ", "\t", $tmpcode);
										} else {
											$tmpcode = _htmlentities($tmpcode);
										}

										array_splice($html_parts, $i+1, $j-$i-1, $tmpcode);
										$tmpcode = "<closed>";
										break;
									} else {
										$open_code--;
									}

								} else if (substr($html_parts[$j], 0, 4) == "code") {
									$open_code++;
								}
								$tmpcode .= "<".$html_parts[$j].">";

							} else {
								$tmpcode .= $html_parts[$j];
							}
						}
						if ($tmpcode != "<closed>") {
							array_splice($html_parts, $i+1, 0, array("", "/pre"));
							$i += 2;
						}
						if ($lang != "") $lang = "-".$lang;
						array_splice($html_parts, $i, 0, array("div class=\"quotetext\" id=\"code$lang\"", "", "b", $fix_html_code_text, "/b", "", "/div", ""));
						$i += 10;

					} else if ($tag == "quote" && $close == true) {
						$html_parts[$i] = "/div";
					} else if ($tag == "quote") {
						$source_name = stristr($html_parts[$i], " source=");
						$source_name = substr($source_name, 8);
						if (strlen($source_name) > 0) {
							$qu = substr($source_name, 0, 1);
							if ($qu == "\"" || $qu == "'") {
								$source_pos = 1;
							} else {
								$source_pos = 0;
								$qu = false;
							}
							for ($j=$source_pos; $j<=strlen($source_name); $j++) {
								$ctmp = substr($source_name, $j, 1);
								if (($qu != false && $ctmp == $qu) || ($qu == false && $ctmp == " ")) {
									if ($ctmp != " ") {
										$j--;
									}
									break;
								}
							}
							$source_name = substr($source_name, $source_pos, $j);
						} else {
							$source_name = "";
						}

						$url_name = stristr($html_parts[$i], " url=");
						$url_name = substr($url_name, 5);
						if (strlen($url_name) > 0) {
							$qu = substr($url_name, 0, 1);
							if ($qu == "\"" || $qu == "'") {
								$url_pos = 1;
							} else {
								$url_pos = 0;
								$qu = false;
							}
							for ($j=$url_pos; $j<=strlen($url_name); $j++) {
								$ctmp = substr($url_name, $j, 1);
								if (($qu != false && $ctmp == $qu) || ($qu == false && $ctmp == " ")) {
									if ($ctmp != " ") {
										$j--;
									}
									break;
								}
							}
							$url_name = substr($url_name, $url_pos, $j);
						} else {
							$url_name = "";
						}

						if ($url_name != "") {
							if ($source_name == "") {
								$source_name = $url_name;
							}
							$html_parts[$i] = "div class=\"quote\"";
							array_splice($html_parts, $i, 0, array("div class=\"quotetext\" id=\"quote\"", "", "b", "$fix_html_quote_text ", "/b", "", "a href=\"$url_name\"", $source_name, "/a", "", "/div", ""));
							$i += 12;
						} else {
							$html_parts[$i] = "div class=\"quote\"";
							array_splice($html_parts, $i, 0, array("div class=\"quotetext\" id=\"quote\"", "", "b", "$fix_html_quote_text ", "/b", $source_name, "/div", ""));
							$i += 8;
						}

					} else if ($tag == "spoiler" && $close == true) {
						$html_parts[$i] = "/div";
					} else if ($tag == "spoiler") {
						$html_parts[$i] = "div class=\"spoiler\"";
						array_splice($html_parts, $i, 0, array("div class=\"quotetext\" id=\"spoiler\"", "", "b", "$fix_html_spoiler_text ", "/b", "", "/div", ""));
						$i += 8;
					}
				} else {
					$html_parts[$i-1].= "&lt;".$html_parts[$i]."&gt;";
					$html_parts[$i] = "";
				}
			} else {
				$html_parts[$i] = str_replace("<", "&lt;", $html_parts[$i]);
				$html_parts[$i] = str_replace(">", "&gt;", $html_parts[$i]);
			}
		}

		$close = "";

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

		for($i=0; $i<count($html_parts); $i++){
			if($i%2){
				if(substr($html_parts[$i],0,1) == "/"){ // closing tag
					$tag_bits = explode(" ", substr($html_parts[$i],1));
					if(substr($tag_bits[0], -1) == "/"){
						$tag_bits[0] = substr($tag_bits[0], 0, -1);
					}

					$tag = strtolower($tag_bits[0]);

					if (!in_array($tag, array_keys($opentags))) {
						$opentags[$tag] = 0;
					}

					$html_parts[$i] = "/".$tag;

					// filter 'bad' tags or single tags
					if(in_array($tag, $bad_tags) || in_array($tag, $single_tags)){
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

							array_push($last_tag, $last_tag2);

						// previous tag hasn't been closed
						} else if ($last_tag2 != $tag){
							// wrap white-text
							$ta = array("/".$last_tag2, "");
							if (preg_match("/( )?\s+$/", $html_parts[$i-1], $ws)) {
								$html_parts[$i-1] = preg_replace("/( )?\s+$/", "$1", $html_parts[$i-1]);
								$ta[1] = $ws[0];
							}
							array_splice($html_parts, $i, 0, $ta);
							$opentags[$last_tag2]--;
							$i++;

						}
					}


				} else {
					if(substr($html_parts[$i], -1) == "/"){
						$html_parts[$i] = substr($html_parts[$i], 0, -1);
					}

					$firstspace = strpos($html_parts[$i], " ");

					if(is_integer($firstspace)){
						$html_parts[$i] = clean_attributes($html_parts[$i]);

						$tag = substr($html_parts[$i], 0, $firstspace);

					} else {
						$tag = strtolower($html_parts[$i]);

						$html_parts[$i] = $tag;
					}

					if (!in_array($tag, array_keys($opentags))) {
						$opentags[$tag] = 0;
					}

					// filter 'bad' tags
					if(in_array($tag, $bad_tags)){
						$html_parts[$i-1] .= $html_parts[$i+1];
						array_splice($html_parts, $i, 2);
						$i -= 2;

					} else if(!in_array($tag, $single_tags)){
						if(in_array($tag, array_keys($nest))) {
							for ($nc=0; $nc<count($nest[$tag]); $nc++) {
								if (in_array($nest[$tag][$nc], array_keys($opentags))) {
									if ($opentags[$nest[$tag][$nc]] == 0) {
										$tmptmptmp = 1;
									} else {
										$tmptmptmp = 0;
										break;
									}

								} else {
									$tmptmptmp = 1;
								}
							}

							if ($tmptmptmp == 1) {
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
								for($j=0;$j<count($tmp_tags);$j++){
									if (strlen($tmp_tags[$j]) > 0) {
										array_push($last_tag, $tmp_tags[$j]);
										if ($j != 0) {
											if (in_array($tmp_tags[$j], array_keys($opentags))) {
												$opentags[$tmp_tags[$j]]++;
											} else {
												$opentags[$tmp_tags[$j]] = 1;
											}
										}
									}
								}
							}
						}

						array_push($last_tag, $tag);

						$opentags[$tag]++;


						// make sure certain tags can't nest within themselves, e.g. <p><p>
						if(in_array($tag, array_keys($no_nest))) {
							$opencount = 0;
							for ($j=0; $j<count($no_nest[$tag]); $j++) {
								if (in_array($no_nest[$tag][$j], array_keys($opentags))) {
									$opencount += $opentags[$no_nest[$tag][$j]];
								}
							}
							if ($tag == "p") $opencount++;

							if ($opentags[$tag] > $opencount) {
								for($j=count($last_tag)-2;$j>=0;$j--){
									if($last_tag[$j] == $tag){
										array_splice($last_tag, $j, 1);
										break;
									} else {
										array_splice($html_parts, $i, 0, array("/".$last_tag[$j], ""));

										// wrap white-text
										if (preg_match("/( )?\s+$/", $html_parts[$i-1], $ws)) {
											$html_parts[$i-1] = preg_replace("/( )?\s+$/", "$1", $html_parts[$i-1]);
											$html_parts[$i+1] = $ws[0].$html_parts[$i+1];
										}

										$opentags[$last_tag[$j]]--;
										array_splice($last_tag, $j, 1);
										$i+=2;
									}
								}

								array_splice($html_parts, $i, 0, array("/".$tag, ""));

								// wrap white-text
								if (preg_match("/( )?\s+$/", $html_parts[$i-1], $ws)) {
									$html_parts[$i-1] = preg_replace("/( )?\s+$/", "$1", $html_parts[$i-1]);
									$html_parts[$i+1] = $ws[0].$html_parts[$i+1];
								}

								$opentags[$tag]--;
								$i+=2;
							}
						}
					// make XHTML single tag
					} else if(substr($html_parts[$i], -2) != " /"){
						if(substr($html_parts[$i], -1) != "/"){
							$html_parts[$i] .= " /";
						} else {
							$html_parts[$i] = substr($html_parts[$i], 0, -1)." /";
						}
					}
				}
			} // else { normal text }
		}
		// reconstruct the HTML
		$tag = "";
		$tag_code = false;
		$tag_quote = false;
		$noemots = 0;
		for($i=0; $i<count($html_parts); $i++){
			if($i%2){
				$tag = $html_parts[$i];
				if ($tag != "" && $tag != "/") {
					$ret_text .= "<".$tag.">";

					if ($tag == 'noemots') {
						$noemots++;
					} else if ($tag == '/noemots') {
						$noemots--;
					}

					if ($tag == 'pre class="code"') {
						$tag_code = true;
					} else if ($tag == 'div class="quotetext"') {
						$tag_quote = true;
					}

					if ($tag_code == true && $tag == '/pre') {
						$tag_code = false;
					} else if ($tag_quote == true && $tag == '/div') {
						$tag_quote = false;
					}
				}
			} else {
				if ($emoticons == true && $tag_quote == false && $tag_code == false && $noemots == 0) {
					$html_parts[$i] = emoticons_convert($html_parts[$i]);
				}
				$ret_text .= $html_parts[$i];
			}
		}

		$reverse_lt = array_reverse($last_tag);
		for($i=0;$i<count($reverse_lt);$i++) {
			if (strlen($reverse_lt[$i]) > 0) {
				$ret_text .= "</".$reverse_lt[$i].">";
			}
		}

		return $ret_text;

	}else{
		return "";
	}
}

function fix_html_error_handler () {
	return;
}

// $tag being everything with the < and >, e.g. $tag = 'a href="file.html"';
function clean_attributes ($tag)
{
	$valid = array();
	$valid["_global"] = array("style", "align", "class", "id", "title", "dir", "lang", "accesskey", "tabindex");

	$valid["a"] = array("href", "title");
	$valid["hr"] = array("size", "width", "noshade");
	$valid["br"] = array("clear");
	$valid["font"] = array("size", "color", "face");
	$valid["blockquote"] = array("cite");
	$valid["pre"] = array("width");
	$valid["del"] = array("cite", "datetime");
	$valid["ins"] = $valid["del"];


	$valid["img"] = array("src", "width", "height", "alt", "border", "usemap", "longdesc", "vspace", "hspace", "ismap");
	$valid["map"] = array("name");
	$valid["area"] = array("shape", "coords", "href", "alt", "nohref");

	$valid["table"] = array("border", "cellspacing", "cellpadding", "width", "height", "summary", "bgcolor", "background", "frame", "rules", "bordercolor");
	$valid["tbody"] = array("char", "charoff", "valign");
	$valid["tfoot"] = $valid["tbody"];
	$valid["thead"] = $valid["tbody"];
	$valid["td"] = array("abbr", "axis", "background", "bgcolor", "char", "charoff", "colspan", "height", "headers", "rowspan", "scope", "valign", "width", "nowrap");
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

				if($tmp_attrib == "style=") {
					$attrib_value = clean_styles($attrib_value);
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

				if($tmp_attrib == "style=") {
					$attrib_value = clean_styles($attrib_value);
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

function tidy_html ($html, $linebreaks = true)
{
	// turn <br /> and <p>...</p> back into linebreaks
	// only if auto-linebreaks is enabled
	if ($linebreaks == true) {
		$html = preg_replace("/<br( [^>]*)?>(\n)?/i", "\n", $html);
		$html = preg_replace("/<p( [^>]*)?>/i", "\n\n", $html);
		$html = preg_replace("/<\/p( [^>]*)?>/i", "\n\n", $html);
	}

	// make <code>..</code> tag, and html_entity_decode
	$html = preg_replace_callback("/<div class=\"quotetext\" id=\"code(-[^\"]+)?\"><b>.*?<\/b><\/div>\s*<pre class=\"code\">(.*?)<\/pre>/is", "tidy_html_callback", $html);

	// make <quote source=".." url="..">..</quote> tag
	$html_left = "";
	$html_right = $html;
	while (($pos = strpos($html_right, "<div class=\"quotetext\" id=\"quote\"><b>")) > -1) {
		$html_left .= substr($html_right, 0, $pos);
		$matches = array();

		if (preg_match("/^<div class=\"quotetext\" id=\"quote\"><b>.*?<\/b>(<a href=\"([^\"]*)\">)?([^<]*)(<\/a>)?<\/div>\s*<div class=\"quote\">.*<\/div>/is",
						substr($html_right, $pos), $matches)) {
			$html_left .= "<quote source=\"".$matches[3]."\" url=\"".$matches[2]."\">";

			$search = "class=\"quote\"";
			$j = strpos($html_right, $search);

			$first = $j + strlen($search) + 1;
			$open_num = 1;
			while (1 != 2) {
				$open = strpos($html_right, "<div", $j);
				$close = strpos($html_right, "</div>", $j);
				if (!is_integer($open)) {
					$open = $close+1;
				}
				if ($close < $open && $open_num == 1) {
					$j = $close;
					break;
				} else if ($close < $open) {
					$open_num--;
					$open = $close;
				} else {
					$open_num++;
				}
				$j = $open+1;
			}

			$html_left .= substr($html_right, $first, $j-$first)."</quote>";
			$html_left = tidy_html($html_left);
			$html_right = substr($html_right, $j + strlen("</div>"));

		} else {
			$html_left .= substr($html_right, $pos, 1);
			$html_right = substr($html_right, $pos + 1);
		}
	}
	$html = $html_left.$html_right;

	// make <spoiler>..</spoiler> tag
	$html_left = "";
	$html_right = $html;
	while (($pos = strpos($html_right, "<div class=\"quotetext\" id=\"spoiler\"><b>")) > -1) {
		$html_left .= substr($html_right, 0, $pos);
		$matches = array();

		if (preg_match("/^<div class=\"quotetext\" id=\"spoiler\"><b>.*?<\/b><\/div>\s*<div class=\"spoiler\">.*<\/div>/is",
						substr($html_right, $pos), $matches)) {
			$html_left .= "<spoiler>";

			$search = "class=\"spoiler\"";
			$j = strpos($html_right, $search);

			$first = $j + strlen($search) + 1;
			$open_num = 1;
			while (1 != 2) {
				$open = strpos($html_right, "<div", $j);
				$close = strpos($html_right, "</div>", $j);
				if (!is_integer($open)) {
					$open = $close+1;
				}
				if ($close < $open && $open_num == 1) {
					$j = $close;
					break;
				} else if ($close < $open) {
					$open_num--;
					$open = $close;
				} else {
					$open_num++;
				}
				$j = $open+1;
			}

			$html_left .= substr($html_right, $first, $j-$first)."</spoiler>";
			$html_left = tidy_html($html_left);
			$html_right = substr($html_right, $j + strlen("</div>"));

		} else {
			$html_left .= substr($html_right, $pos, 1);
			$html_right = substr($html_right, $pos + 1);
		}
	}
	$html = $html_left.$html_right;

//	$html = preg_replace("/<div class=\"quotetext\"><b>quote: <\/b>(<a href=\"([^\"]*)\">([^<]*)?<\/a>)?<\/div>[^\"]+\"quote\">((.|\s)*)<\/div>/i",
//						"<quote source=\"$3\" url=\"$2\">$4</quote>", $html);


	// convert smileys back to plain text
	$html = clean_emoticons($html);

	return $html;
}

function tidy_html_callback ($matches)
{
	$lang = "";
	if (isset($matches[1])) $lang = substr($matches[1], 1);

    return "<code language=\"$lang\">"._htmlentities_decode(strip_tags($matches[2]))."</code>";
}

function clean_emoticons($html)
{
	return preg_replace("/<span class=\"e_[^>]*\" title=\"[^>]*\"><span[^>]*>([^<]*)<\/span><\/span>/i", "$1", $html);
}

function clean_styles ($style)
{
	$style = preg_replace("/position\s*:\s*absolute\s*;?/", "", $style);
	return $style;
}

function add_paragraphs ($html, $base = true, $br_only = true)
{
	$html = str_replace("\r", "", $html);

	$tags = array("table", "div", "pre", "ul", "ol", "object", "font");

	$tags_nest = array();
	// = array of nested tags which contain content, or
	// = array (a, b)
	//      a == true when you want linebreaks added (default false)
	//      b == true when tag is inline (default false)
	$tags_nest["table"] = array("td", "th");
	$tags_nest["ul"] = array("li");
	$tags_nest["ol"] = array("li");
	$tags_nest["div"] = array(true);
	$tags_nest["pre"] = array(false);
	$tags_nest["object"] = array(false);
	$tags_nest["font"] = array(true, true);
	$tags_nest["a"] = array(true, true);
	$tags_nest["span"] = array(true, true);

	$cur_tag = "";

	$html_a = array($html);
	$html_p = 0;

	while (trim($html_a[count($html_a)-1]) != "") {
		$cur_pos = strlen($html_a[$html_p]);

		for ($i=0; $i<count($tags); $i++) {
			$open = strpos($html_a[$html_p], "<".$tags[$i]);
			if ($open < $cur_pos && is_integer($open)) {
				$cur_pos = $open;
				$cur_tag = $tags[$i];
			}
		}

		if ($cur_pos >= strlen($html_a[$html_p])) break;

		$close = -1;
		$open_num = 0;
		$j = $cur_pos+1;
		while (1 != 2) {
			$open = strpos($html_a[$html_p], "<".$cur_tag, $j);
			$close = strpos($html_a[$html_p], "</".$cur_tag, $j);
			if (!is_integer($open)) {
				$open = $close+1;
			}
			if ($close < $open && $open_num == 0) {
				break;
			} else if ($close < $open) {
				$open_num--;
				$open = $close;
			} else {
				$open_num++;
			}
			$j = $open+1;
		}

		$close = strpos($html_a[$html_p], ">", $close)+1;
		$html_a[$html_p+1] = substr($html_a[$html_p], $cur_pos, $close-$cur_pos);
		$html_a[$html_p+2] = substr($html_a[$html_p], $close);
		$html_a[$html_p] = substr($html_a[$html_p], 0, $cur_pos);

//		$html_a[$html_p] = preg_replace("/\n$/", "", $html_a[$html_p]);
//		$html_a[$html_p+2] = preg_replace("/^\n{1,2}/", "", $html_a[$html_p+2]);

		$html_p += 2;
	}

	$return = "";
	$p_open = false;

	for ($i=0; $i<count($html_a); $i++) {
		if ($i%2) {
			$tag = array();
			preg_match("/^<(\w+)(\b[^<>]*)>/i", $html_a[$i], $tag);

			if (!is_bool($tags_nest[$tag[1]][0])) {
				$nest = $tags_nest[$tag[1]];
				for ($j=0; $j<count($nest); $j++) {
					$offset = 0;
					while (is_integer(strpos($html_a[$i], "<".$nest[$j], $offset))) {
						$cur_pos = strpos($html_a[$i], "<".$nest[$j], $offset);
						$cur_pos = strpos($html_a[$i], ">", $cur_pos)+1;
						$k = $cur_pos;
						$open_num = 0;
						while (1 != 2) {
							$open = strpos($html_a[$i], "<".$nest[$j], $k);
							$close = strpos($html_a[$i], "</".$nest[$j], $k);
							if (!is_integer($open)) {
								$open = $close+1;
							}
							if ($close < $open && $open_num == 0) {
								break;
							} else if ($close < $open) {
								$open_num--;
								$open = $close;
							} else {
								$open_num++;
							}
							$k = $open+1;
						}

						$tmp = array();
						$tmp[0] = substr($html_a[$i], 0, $cur_pos);
						$tmp[1] = substr($html_a[$i], $cur_pos, $close-$cur_pos);
						$tmp[2] = substr($html_a[$i], $close);

						$tmp[1] = add_paragraphs($tmp[1], false, true);

						$offset = strlen($tmp[0].$tmp[1]);

						$html_a[$i] = $tmp[0].$tmp[1].$tmp[2];
					}
				}
			} else if ($tags_nest[$tag[1]][0] == true) {
				$cur_pos = strpos($html_a[$i], ">")+1;
				$close = strrpos($html_a[$i], "<");

				$tmp = array();
				$tmp[0] = substr($html_a[$i], 0, $cur_pos);
				$tmp[1] = substr($html_a[$i], $cur_pos, $close-$cur_pos);
				$tmp[2] = substr($html_a[$i], $close);

				$tmp[1] = add_paragraphs($tmp[1], false, true);

				$html_a[$i] = $tmp[0].$tmp[1].$tmp[2];
			}

			if (isset($tags_nest[$tag[1]][1]) && $tags_nest[$tag[1]][1] != true) {
				if (trim($html_a[$i+1]) == "") {
					$return .= $html_a[$i]."\n";
				} else {
					$return .= $html_a[$i]."\n\n";
				}
			} else {
				$return .= $html_a[$i];
			}

		} else if ($br_only == false) {
			$html_a[$i] = preg_replace("/(<br( [^>]*)?>)([^\n\r])/i", "$1\n$3", $html_a[$i]);
			$html_a[$i] = preg_replace("/([^\n\r])(<p( [^>]*)?>)/i", "$1\n\n$2", $html_a[$i]);
			$html_a[$i] = preg_replace("/(<\/p( [^>]*)?>)([^\n\r])/i", "</p>\n\n$3", $html_a[$i]);

			$tmp = split("\n", $html_a[$i]);
			if (count($tmp) > 1) {
				$p_open = true;
				if (!preg_match("/(\s*<[^<>]*>\s*)*<p[ >]/", $tmp[0])) {
					$tmp[0] = "<p>".$tmp[0];
				}
			}

			for ($j=0; $j<count($tmp)-1; $j++) {
				if (preg_match("/<\/p>$/i", $tmp[$j])) {
					$p_open = false;
					$tmp[$j+1] = preg_replace("/^<p( [^>]*)?>/i", "", $tmp[$j+1]);
					$tmp[$j+1] = preg_replace("/<br( [^>]*)?>$/i", "", $tmp[$j+1]);
					$tmp[$j+1] = preg_replace("/<\/p>$/i", "", $tmp[$j+1]);
					if (!isset($tmp[$j+2])) break;
					$p_open = true;
					if (!preg_match("/(\s*<[^<>]*>\s*)*<p[ >]/", $tmp[$j+2])) {
						$tmp[$j+2] = "<p>".$tmp[$j+2];
					}
					$j++;
				} else if (!preg_match("/<br( [^>]*)?>$/i", $tmp[$j])) {
					$tmp[$j+1] = preg_replace("/^<p( [^>]*)?>/i", "", $tmp[$j+1]);
					$tmp[$j+1] = preg_replace("/<br( [^>]*)?>$/i", "", $tmp[$j+1]);
					$tmp[$j+1] = preg_replace("/<\/p>$/i", "", $tmp[$j+1]);
					if (preg_match("/^\s*$/", $tmp[$j+1]) && $p_open == true) {
						$p_open = false;
						$tmp[$j] .= "</p>";
						if (!isset($tmp[$j+2])) break;
						$p_open = true;
						if (!preg_match("/(\s*<[^<>]*>\s*)*<p[ >]/", $tmp[$j+2])) {
							$tmp[$j+2] = "<p>".$tmp[$j+2];
						}
						$j++;
					} else {
						$tmp[$j] .= "<br />";
					}
				} else {
					$tmp[$j+1] = preg_replace("/^<p( [^>]*)?>/i", "", $tmp[$j+1]);
					$tmp[$j+1] = preg_replace("/<br( [^>]*)?>$/i", "", $tmp[$j+1]);
					$tmp[$j+1] = preg_replace("/<\/p>$/i", "", $tmp[$j+1]);
				}
			}
			if ($p_open == true && !preg_match("/<\/p>$/i", $tmp[$j]) && trim($tmp[$j]) != "") {
				$tmp[$j] .= "</p>";
			}
			$html_a[$i] = implode("\n", $tmp);
			$html_a[$i] = preg_replace("/(<p( [^>]*)?>)\s*<\/p>/i", "$1&nbsp;</p>", $html_a[$i]);


			$tag = array();
			if (isset($html_a[$i+1])) {
				preg_match("/^<(\w+)(\b[^<>]*)>/i", $html_a[$i+1], $tag);
				if ($tags_nest[$tag[1]][1] != true && trim($html_a[$i]) != "") {
					$html_a[$i] .= "\n\n";
				}
			}
			$return .= $html_a[$i];

		} else {

			$html_a[$i] = preg_replace("/(<br( [^>]*)?>)([^\n\r])/i", "$1\n$3", $html_a[$i]);
			$html_a[$i] = preg_replace("/([^\n\r])(<p( [^>]*)?>)/i", "$1\n\n$2", $html_a[$i]);
			$html_a[$i] = preg_replace("/(<\/p( [^>]*)?>)([^\n\r])/i", "</p>\n\n$3", $html_a[$i]);
			$html_a[$i] = preg_replace("/(<br( [^>]*)?>)|(<p( [^>]*)?>)|(<\/p( [^>]*)?>)/i", "", $html_a[$i]);

			$html_a[$i] = nl2br($html_a[$i]);

			$return .= $html_a[$i];
		}
	}

	return $return;
}

function make_html ($html, $br_only = false, $emoticons = true)
{
    $html = _htmlentities($html);
    $html = format_url2link($html);

	if ($emoticons == true) {
		$h_s = preg_split("/(<a[^>]+>[^<]+<\/a>)/", $html, -1, PREG_SPLIT_DELIM_CAPTURE);
		for ($i=0; $i<count($h_s); $i+=2) {
			$h_s[$i] = emoticons_convert($h_s[$i]);
		}
		$html = implode("", $h_s);
	}

    $html = add_paragraphs($html, true, $br_only);

    return $html;
}

?>