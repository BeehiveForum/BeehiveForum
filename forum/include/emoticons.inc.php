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

// Emoticon filter file

// --------------------------------------
// Begin emoticons
// --------------------------------------

// Default emoticons
$emoticon[':-)'] = "smile";
$emoticon[':)'] = "smile";
$emoticon[';-)'] = "wink";
$emoticon[';)'] = "wink";
$emoticon[':-('] = "sad";
$emoticon[':('] = "sad";
$emoticon[':\'-('] = "cry";
$emoticon[':\'('] = "cry";
$emoticon[':-P'] = "tongue";
$emoticon[':P'] = "tongue";
$emoticon[':-D'] = "grin";
$emoticon[':D'] = "grin";
$emoticon[':-S'] = "confused";
$emoticon[':S'] = "confused";
$emoticon[':-|'] = "plain";
$emoticon[':|'] = "plain";
$emoticon[':-/'] = "unsure";
$emoticon[':/'] = "unsure";
$emoticon[':-O'] = "shock";
$emoticon[':O'] = "shock";
$emoticon[':-@'] = "angry";
$emoticon[':@'] = "angry";
$emoticon[':-$'] = "embarrassed";
$emoticon[':$'] = "embarrassed";
$emoticon['(a)'] = "angel";
$emoticon['(6)'] = "devil";
$emoticon['B-)'] = "shades";
$emoticon['B)'] = "shades";
$emoticon['(h)'] = "shades";

// Peter Boughton's emoticons
$emoticon[':>'] = "cheeky";
$emoticon[':->'] = "cheeky";
$emoticon['}:>'] = "evil_cheeky";
$emoticon['}:->'] = "evil_cheeky";
$emoticon[':O)'] = "smile_big_nose";
$emoticon['>.<'] = "cringe";
$emoticon['^.^'] = "happy";



// --------------------------------------
// End emoticons
// --------------------------------------

krsort($emoticon);
reset($emoticon);

$emoticon_text = array();
foreach ($emoticon as $k => $v) {
	$emoticon_text[$v][] = $k;
}

$pattern_array_2 = array();
$replace_array_2 = array();

$e_keys = array_keys($emoticon);
for ($i=0; $i<count($e_keys); $i++) {
	for ($j=0; $j<count($e_keys); $j++) {
		if ($i != $j) {
			$pos = strpos(strtolower($e_keys[$j]), strtolower($e_keys[$i]));
			if (is_int($pos)) {
				$a = $e_keys[$j];
				$b = $e_keys[$i];
				$v = $emoticon[$a];
				$a2 = urlencode($a);

				$a_f = preg_quote(substr($a, 0, $pos), "/");
				$a_m = preg_quote(urlencode(substr($a, $pos, strlen($b))), "/");
				$a_e = preg_quote(substr($a, $pos +strlen($b)), "/");

				$pattern_array_2[] = "/". $a_f."<span class=[^>]+><span>".$a_m."<\/span><\/span>".$a_e ."/i";
				$replace_array_2[] = "<span class=\"e_$v\" title=\"$a2\"><span>$a2</span></span>";
			}
		}
	}
}

function emoticons_convert ($content) {
//	$content = _htmlentities_decode($content);

	global $emoticon, $pattern_array_2, $replace_array_2;

	if (!is_array($emoticon)) return $content;

	foreach ($emoticon as $k => $v) {
		$k3 = _htmlentities($k);
		$k2 = urlencode($k3);

		//$front = ""; //'(?<!<span|title=\")';// "(?<!<span)((>|^)[^<]*?)";
		//$end = ""; //"(?!<\/span><\/span>)";

		$pattern_array[] = "/". preg_quote($k, "/") ."/i";
		$replace_array[] = "<span class=\"e_$v\" title=\"$k2\"><span>$k2</span></span>";

		if ($k != $k3) {
			$pattern_array[] = "/". preg_quote($k3, "/") ."/i";
			$replace_array[] = "<span class=\"e_$v\" title=\"$k2\"><span>$k2</span></span>";
		}
	}

	if (@$new_content = preg_replace($pattern_array, $replace_array, $content)) {
		$content = $new_content;
	}

	if (@$new_content = preg_replace($pattern_array_2, $replace_array_2, $content)) {
		$content = $new_content;
	}

	$content = preg_replace("/(<span class=\"e_[^\"]+\" title=\"[^\"]+\"><span>[^<]+<\/span>)/ie", "emoticons_regex_output('\\1')", $content);

	return $content;
}

function emoticons_regex_output($text) {
    $text = urldecode($text);
    // accounts for stripslashes 'bug' when using /e modifier
    // see comments at:
    // http://uk2.php.net/manual/en/function.preg-replace.php
    $text = str_replace('\"', '"', $text);
    return $text;
}

function emoticons_get_sets() {
	$sets = array();
	if ($dir = @opendir('emoticons')) {
		while (($file = readdir($dir)) !== false) {
			if (is_dir("emoticons/$file") && $file != '.' && $file != '..') {
				if (@file_exists("./emoticons/$file/style.css")) {
					if ($fp = fopen("./emoticons/$file/desc.txt", "r")) {
						$content = fread($fp, filesize("emoticons/$file/desc.txt"));
						$content = split("\n", $content);
						$sets[$file] = _htmlentities($content[0]);
						fclose($fp);
					}else {
						$sets[$file] = _htmlentities($file);
					}
				}
			}
		}
		closedir($dir);
	}

	asort($sets);
	reset($sets);

	$sets = array_merge(array('none' => 'None'), $sets);

	return $sets;
}

function emoticons_set_exists ($set) {
	if (file_exists('./emoticons/'.$set.'/style.css') || $set == 'none') {
		return true;
	}
	return false;
}

function emoticons_preview ($set, $width=200, $height=100) {
	global $emoticon_text;
	$html = "";

	if (emoticons_set_exists($set)) {
		$path = "./emoticons/$set";
		$fp = fopen("$path/style.css", "r");
		$style = fread($fp, filesize("$path/style.css"));

		preg_match_all("/\.e_([\w_]+) \{[^\}]*background-image\s*:\s*url\s*\([\"\']([^\"\']*)[\"\']\)[^\}]*\}/i", $style, $matches);

		for ($i=0; $i<count($matches[1]); $i++) {
			if (isset($emoticon_text[$matches[1][$i]])) {
				$emot_match[] = $emoticon_text[$matches[1][$i]];
				$emot_text[] = $matches[1][$i];
				$emot_image[] = $matches[2][$i];
			}
		}

		array_multisort($emot_match, $emot_text, $emot_image);

		$html.= "<div style=\"width:".$width."px; height:".$height."px\" class=\"emoticon_preview\">";
		for ($i=0; $i<count($emot_match); $i++) {
			$tmp = " ";
			for ($j=0; $j<count($emot_match[$i]); $j++) {
				$tmp.= $emot_match[$i][$j]." ";
			}
			$html.= "<a href=\"#\" onclick=\"emoticon('".urlencode($emot_match[$i][0])."');return false;\" target=\"_self\">";
			$html.= "<img src=\"$path/".$emot_image[$i]."\" title=\"".$tmp."\" border=\"0\" / ></a> ";
		}
		$html.= "</div>";
	}

	return $html;
}

?>