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

// "$bad_tags" is an array of tags to be filtered
function fix_html($html, $bad_tags = array("plaintext","horg","!--"))
{
	$html_parts = split('<[[:space:]]*|[[:space:]]*>', $html);

	$opentags = array();
	$last_tag = array();
	$single_tags = array("br","img","hr");
	$no_nest = array("p");

	for($i=0; $i<count($html_parts); $i++){
		if($i%2){
			if(substr($html_parts[$i],0,1) == "/"){ // closing tag
				$tag_bits = explode(" ", strtolower(substr($html_parts[$i],1)));
				$tag = $tag_bits[0];

				// filter 'bad' tags
				if(in_array($tag, $bad_tags)){
					$html_parts[$i] = "####";

				} else {
					$last_tag2 = array_pop($last_tag);

					// tag is both opened/closed correctly
					if($opentags[$tag] > 0 && $last_tag2 == $tag){
						$opentags[$tag]--;

					// tag hasn't been opened
					} else if($opentags[$tag] <= 0){
						array_push($last_tag, $last_tag2);
						array_splice($html_parts, $i-1, 0, array("",$tag));
						$i+=2;

					// tag hasn't been closed
					} else if ($last_tag2 != $tag){
						array_splice($html_parts, $i, 0, array("/".$last_tag2,""));
						$opentags[$last_tag2]--;
						$i++;

					}
				}

			} else {
				// check for XHTML single tag
				if(substr($html_parts[$i],-1) != "/"){
					$tag_bits = explode(" ", strtolower($html_parts[$i]));
					$tag = $tag_bits[0];

					// filter 'bad' tags
					if(in_array($tag, $bad_tags)){
						$html_parts[$i] = "####";

					} else if(!in_array($tag, $single_tags)){
						$opentags[$tag]++;
						array_push($last_tag, $tag);

						// make sure certain tags can't nest within themselves, e.g. <p><p>
						if(in_array($tag, $no_nest) && $opentags[$tag] > 1){
							array_splice($html_parts, $i, 0, array("/$tag", ""));
							$opentags[$tag]--;
							$i+=2;
						}

					// make XHTML single tag
					} else {
						$html_parts[$i] .= " /";
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
}
?>