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
function fix_html($html, $bad_tags = array("plaintext"))
{
	$open_pos = strpos($html, "<");
	$next_open_pos = strpos($html, "<", $open_pos+1);
	$close_pos = strpos($html, ">");

	$html_parts = array();

	while(is_integer($open_pos) || is_integer($close_pos)){
		if(substr($html, $open_pos+1, 3) == "!--"){
			$end_comment = strpos($html, "-->", $open_pos);
			if(!is_integer($end_comment)){
				$html = substr($html, 0, $open_pos+4)." -->".substr($html, $open_pos+4);
				$end_comment = $open_pos+5;
			}
			if(substr($html, $open_pos+4, 1) != " "){
				$html = substr($html, 0, $open_pos+4)." ".substr($html, $open_pos+4);
				$end_comment++;
			}

			array_push($html_parts, substr($html, 0, $open_pos));
			array_push($html_parts, substr($html, $open_pos+1, $end_comment-$open_pos+1));

			$html = substr($html, $end_comment+3);

		} else if(!is_integer($open_pos) || $close_pos < $open_pos){
			// > by itself
			$html = substr($html, 0, $close_pos)."&gt;".substr($html, $close_pos+1);

		} else if(!is_integer($close_pos)){
			// < by itself
			$html = substr($html, 0, $open_pos)."&lt;".substr($html, $open_pos+1);

		} else if($next_open_pos < $close_pos && is_integer($next_open_pos)){
			// < inside <..>
			$html = substr($html, 0, $open_pos)."&lt;".substr($html, $open_pos+1);

		} else if($open_pos+1 == $close_pos || substr($html, $open_pos+1, 1) == " "){
			// empty tag < >
			$html = substr($html, 0, $open_pos)."&lt;".substr($html, $open_pos+1, $close_pos-$open_pos-1)."&gt;". substr($html, $close_pos+1);

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

	//$html_parts = split('<[[:space:]]*|[[:space:]]*>', $html);

	$opentags = array();
	$last_tag = array();
	$single_tags = array("br","img","hr","!--");
	$no_nest = array("p");

	for($i=0; $i<count($html_parts); $i++){
		if($i%2){
			if(substr($html_parts[$i],0,1) == "/"){ // closing tag
				$tag_bits = explode(" ", strtolower(substr($html_parts[$i],1)));

				if(substr($tag_bits[0], -1) == "/"){
					$tag_bits[0] = substr($tag_bits[0], 0, -1);
				}

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
				$tag_bits = explode(" ", strtolower($html_parts[$i]));

				if(substr($tag_bits[0], -1) == "/"){
					$tag_bits[0] = substr($tag_bits[0], 0, -1);
				}

				$tag = $tag_bits[0];

				// filter 'bad' tags
				if(in_array($tag, $bad_tags)){
					$html_parts[$i] = "####";

				} else if(!in_array($tag, $single_tags)){
					$opentags[$tag]++;
					array_push($last_tag, $tag);

					// make sure certain tags can't nest within themselves, e.g. <p><p>
					if(in_array($tag, $no_nest) && $opentags[$tag] > 1){

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
				} else if(substr($html_parts[$i], -2) != "--"){
					if(substr($html_parts[$i], -1) != "/" && substr($html_parts[$i], -2) != " /"){
						$html_parts[$i] .= " /";
					} else if (substr($html_parts[$i], -1) == "/"){
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
}
?>