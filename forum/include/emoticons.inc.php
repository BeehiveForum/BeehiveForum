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

// Standard emoticons
$emoticon[':-)'] = "smile";
$emoticon[':)'] = "smile";
$emoticon[';-)'] = "wink";
$emoticon[';)'] = "wink";
$emoticon[':-('] = "sad";
$emoticon[':('] = "sad";
$emoticon[':\'-('] = "cry";
$emoticon[':\'('] = "cry";
$emoticon[':-P'] = "tease";
$emoticon[':P'] = "tease";
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

// Peter Boughton's emoticons
$emoticon['}:>'] = "evil_cheeky";
$emoticon[':>'] = "cheeky";
$emoticon['B-)'] = "shades";
$emoticon['B)'] = "shades";
$emoticon['8-)'] = "shades";
$emoticon['8)'] = "shades";
$emoticon[':o)'] = "smile_big_nose";
$emoticon[':O)'] = "smile_big_nose";
$emoticon['>.<'] = "cringe";
$emoticon['^.^'] = "happy";


// --------------------------------------
// End emoticons
// --------------------------------------

function emoticons_convert ($content) {
	global $emoticon;

	if (!is_array($emoticon)) return $content;

	foreach ($emoticon as $k => $v) {
		$pattern_array[] = "/\B(". preg_quote(_htmlentities($k), "/"). ")\B/i";
		$replace_array[] = "<span class=\"e_$v\" title=\"$v\"><span>$k</span></span>";
	}

	if (@$new_content = preg_replace($pattern_array, $replace_array, $content)) {
		return $new_content;
	}
}
?>