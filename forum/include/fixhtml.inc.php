<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
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

// We shouldn't be accessing this file directly.
if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

require_once BH_INCLUDE_PATH. 'format.inc.php';
require_once BH_INCLUDE_PATH. 'html.inc.php';
require_once BH_INCLUDE_PATH. 'geshi.inc.php';
require_once BH_INCLUDE_PATH. 'lang.inc.php';

function fix_html($html, $emoticons = true, $links = true, $bad_tags = array('plaintext', 'applet', 'body', 'html', 'head', 'title', 'base', 'meta', '!doctype', 'button', 'embed', 'fieldset', 'form', 'frame', 'frameset', 'iframe', 'input', 'label', 'legend', 'link', 'noframes', 'noscript', 'optgroup', 'option', 'param', 'script', 'select', 'style', 'textarea', 'xmp'))
{
    $fix_html_code_text = 'code:';
    $fix_html_quote_text = 'quote:';

    $geshi_path = 'geshi/geshi';

    $code_highlighter = new GeSHi('', '', $geshi_path);

    $code_highlighter->set_link_target('_blank');
    $code_highlighter->set_encoding('UTF-8');

    $code_highlighter->error = false;
    $code_highlighter->strict_mode = false;

    $ret_text = '';

    if (!empty($html)) {

        if ($emoticons == false) {
            $html = '<noemots>'. $html. '</noemots>';
        }

        $html_parts = preg_split('/<([^<>]+)>/u', $html, -1, PREG_SPLIT_DELIM_CAPTURE);

        $html_tags = array(
            'a',
            'abbr',
            'acronym',
            'address',
            'applet',
            'area',
            'b',
            'base',
            'basefont',
            'bdo',
            'big',
            'blockquote',
            'body',
            'br',
            'button',
            'caption',
            'center',
            'cite',
            'code',
            'col',
            'colgroup',
            'dd',
            'del',
            'dfn',
            'dir',
            'div',
            'dl',
            'dt',
            'em',
            'fieldset',
            'flash',
            'font',
            'form',
            'frame',
            'frameset',
            'h1',
            'h2',
            'h3',
            'h4',
            'h5',
            'h6',
            'head',
            'hr',
            'html',
            'i',
            'iframe',
            'img',
            'input',
            'ins',
            'isindex',
            'kbd',
            'label',
            'legend',
            'li',
            'link',
            'map',
            'marquee',
            'menu',
            'meta',
            'noemots',
            'noframes',
            'noscript',
            'object',
            'ol',
            'optgroup',
            'option',
            'p',
            'param',
            'pre',
            'q',
            'quote',
            's',
            'samp',
            'script',
            'select',
            'small',
            'span',
            'spoiler',
            'strike',
            'strong',
            'style',
            'sub',
            'sup',
            'table',
            'tbody',
            'td',
            'textarea',
            'tfoot',
            'th',
            'thead',
            'title',
            'tr',
            'tt',
            'u',
            'ul',
            'var',
            'youtube'
        );

        $html_tags = array_diff($html_tags, $bad_tags);

        $bad_tags = array();

        for ($i = 0; $i < count($html_parts); $i++) {

            if ($i % 2) {

                $tag = explode(' ', $html_parts[$i]);

                if (substr($tag[0], 0, 1) == '/') {

                    $close = true;
                    $tag = mb_substr($tag[0], 1);

                } else {

                    $close = false;
                    $tag = $tag[0];
                }

                $tag = mb_strtolower($tag);

                if (in_array($tag, $html_tags)) {

                    if ($tag == 'code' && $close == true) {

                        $html_parts[$i] = '/pre';

                    } else if ($tag == 'code') {

                        $lang_tmp = array();

                        preg_match("/ language=[\"|']?([^\"|']+)/iu", $html_parts[$i], $lang_tmp);

                        $lang = isset($lang_tmp[1]) ? $lang_tmp[1] : '';

                        $tmpcode = '';

                        $html_parts[$i] = 'pre class="code"';

                        $open_code = 1;

                        for ($j = $i + 1; $j < count($html_parts); $j++) {

                            if ($j % 2) {

                                if (substr($html_parts[$j], 0, 5) == '/code') {

                                    if ($open_code == 1) {

                                        $html_parts[$j] = '/pre';

                                        $code_highlighter->set_source($tmpcode);

                                        $lang_geshi = $code_highlighter->get_language_name_from_extension(strtolower($lang));

                                        if (strlen($lang_geshi) > 0) {
                                            $code_highlighter->set_language($lang_geshi);
                                        } else {
                                            $code_highlighter->set_language(strtolower($lang));
                                        }

                                        set_error_handler('geshi_error_handler');

                                        $tmpcode = $code_highlighter->parse_code();
                                        $tmpcode = preg_replace("/<\\/?pre( [^>]*)?>/u", '', $tmpcode);

                                        restore_error_handler();

                                        array_splice($html_parts, $i + 1, $j - $i - 1, $tmpcode);

                                        $tmpcode = '<closed>';

                                        break;

                                    } else {

                                        $open_code--;
                                    }

                                } else if (substr($html_parts[$j], 0, 4) == 'code') {

                                    $open_code++;
                                }

                                $tmpcode.= '<'. $html_parts[$j]. '>';

                            } else {

                                $tmpcode.= $html_parts[$j];
                            }
                        }

                        if ($tmpcode != '<closed>') {

                            array_splice($html_parts, $i + 1, 0, array('', '/pre'));
                            $i += 2;
                        }

                        array_splice($html_parts, $i, 0, array("div class=\"quotetext\" id=\"code-$lang\"", '', 'b', $lang. ' '. $fix_html_code_text, '/b', '', '/div', ''));

                        $i += 10;

                    } else if ($tag == 'quote' && $close == true) {

                        $html_parts[$i] = '/div';

                    } else if ($tag == 'quote') {

                        $source_name = stristr($html_parts[$i], ' source=');
                        $source_name = mb_substr($source_name, 8);

                        if (strlen($source_name) > 0) {

                            $qu = mb_substr($source_name, 0, 1);

                            if ($qu == "\"" || $qu == "'") {

                                $source_pos = 1;

                            } else {

                                $source_pos = 0;
                                $qu = false;
                            }

                            for ($j = $source_pos; $j <= mb_strlen($source_name); $j++) {

                                $ctmp = mb_substr($source_name, $j, 1);

                                if (($qu != false && $ctmp == $qu) || ($qu == false && $ctmp == ' ')) {

                                    if ($ctmp != ' ') {
                                        $j--;
                                    }

                                    break;
                                }
                            }

                            $source_name = mb_substr($source_name, $source_pos, $j);

                        } else {

                            $source_name = '';
                        }

                        $url_name = stristr($html_parts[$i], ' url=');
                        $url_name = mb_substr($url_name, 5);

                        if (strlen($url_name) > 0) {

                            $qu = mb_substr($url_name, 0, 1);

                            if ($qu == "\"" || $qu == "'") {

                                $url_pos = 1;

                            } else {

                                $url_pos = 0;
                                $qu = false;
                            }

                            for ($j = $url_pos; $j <= mb_strlen($url_name); $j++) {

                                $ctmp = mb_substr($url_name, $j, 1);

                                if (($qu != false && $ctmp == $qu) || ($qu == false && $ctmp == ' ')) {

                                    if ($ctmp != ' ') {
                                        $j--;
                                    }

                                    break;
                                }
                            }

                            $url_name = mb_substr($url_name, $url_pos, $j);

                        } else {

                            $url_name = '';
                        }

                        if (mb_strlen(trim($url_name)) > 0) {

                            if ($source_name == '') {

                                $source_name = $url_name;
                            }

                            $html_parts[$i] = "div class=\"quote\"";

                            array_splice($html_parts, $i, 0, array("div class=\"quotetext\" id=\"quote\"", '', 'b', "$fix_html_quote_text ", '/b', '', "a href=\"$url_name\"", $source_name, '/a', '', '/div', ''));

                            $i += 12;

                        } else {

                            $html_parts[$i] = "div class=\"quote\"";
                            array_splice($html_parts, $i, 0, array("div class=\"quotetext\" id=\"quote\"", '', 'b', "$fix_html_quote_text ", '/b', $source_name, '/div', ''));
                            $i += 8;
                        }

                    } else if ($tag == 'spoiler' && $close == true) {

                        $html_parts[$i] = '/span';

                        array_splice($html_parts, $i, 0, array('/span', ''));

                        $i+= 2;

                    } else if ($tag == 'spoiler') {

                        $html_parts[$i] = 'span';

                        array_splice($html_parts, $i, 0, array('span class="spoiler"', ''));

                        $i+= 2;

                    } else if ($tag == 'youtube') {

                        if (!isset($html_parts[$i + 1], $html_parts[$i + 2]) || ($html_parts[$i + 2] !== '/youtube')) {

                            array_splice($html_parts, $i, 3, array('', '', ''));

                            $i+= 3;

                        } else {

                            $matches_array = array();
                            
                            preg_match('/^((http|https):\/\/)?(www\.)?((youtube\.com\/watch\?(feature=([^&]+)&)?v=([^&]+))|youtu\.be\/(.+))/su', trim($html_parts[$i + 1]), $matches_array);
                            
                            if (!isset($matches_array[2]) || strlen(trim($matches_array[2])) == 0) {
                                $matches_array[2] = 'http';
                            }
                            
                            if (isset($matches_array[8])) {

                                $html_parts[$i] = sprintf('iframe class="youtube" width="480" height="390" src="%1$s://www.youtube.com/embed/%2$s" title="%2$s" frameborder="0" allowfullscreen="true"', $matches_array[2], $matches_array[8]);

                                array_splice($html_parts, $i + 1, 2, array('', '/iframe'));

                                $i+= 3;

                            } else if (isset($matches_array[9])) {

                                $html_parts[$i] = sprintf('iframe class="youtube" width="480" height="390" src="%1$s://www.youtube.com/embed/%2$s" title="%2$s" frameborder="0" allowfullscreen="true"', $matches_array[2], $matches_array[9]);

                                array_splice($html_parts, $i + 1, 2, array('', '/iframe'));

                                $i+= 3;

                            } else {

                                array_splice($html_parts, $i, 3, array('', '', ''));

                                $i+= 3;
                            }
                        }

                    } else if ($tag == 'flash') {

                        $matches_array = array();

                        preg_match('/src="([^"]+)"/su', $html_parts[$i], $matches_array);

                        if (!isset($matches_array[1]) || strlen(trim($matches_array[1])) == 0) {

                            $html_parts[$i] = '';

                        } else {

                            $flash_attr_array = array(
                                'data' => sprintf('"%s"', $matches_array[1])
                            );

                            $matches_array = array();

                            preg_match('/width="([^"]+)"/su', $html_parts[$i], $matches_array);

                            if (isset($matches_array[1]) && is_numeric($matches_array[1])) {
                                $flash_attr_array['width'] = sprintf('"%s"', $matches_array[1]);
                            }

                            $matches_array = array();

                            preg_match('/height="([^"]+)"/su', $html_parts[$i], $matches_array);

                            if (isset($matches_array[1]) && is_numeric($matches_array[1])) {
                                $flash_attr_array['height'] = sprintf('"%s"', $matches_array[1]);
                            }

                            $matches_array = array();

                            preg_match('/wmode="(opaque|transparent)"/su', $html_parts[$i], $matches_array);

                            if (isset($matches_array[1]) && in_array($matches_array[1], array('window', 'opaque', 'transparent'))) {
                                $flash_wmode = $matches_array[1];
                            }

                            $flash_html_parts = array(
                                sprintf('object type="application/x-shockwave-flash" %s', implode_assoc($flash_attr_array, '=', ' '))
                            );

                            array_push($flash_html_parts, '', sprintf('param name="movie" value=%s /', $flash_attr_array['data']));

                            if (isset($flash_wmode) && strlen(trim($flash_wmode)) > 0) {
                                array_push($flash_html_parts, '', sprintf('param name="wmode" value="%s" /', $flash_wmode));
                            }

                            array_push($flash_html_parts, '', '/object');

                            array_splice($html_parts, $i, 1, $flash_html_parts);

                            $i+= sizeof($flash_html_parts) - 1;
                        }
                    }

                } else {

                    $html_parts[$i - 1].= '&lt;'. $html_parts[$i]. '&gt;';
                    $html_parts[$i] = '';
                }

            } else {

                $html_parts[$i] = str_replace('<', '&lt;', $html_parts[$i]);
                $html_parts[$i] = str_replace('>', '&gt;', $html_parts[$i]);
            }
        }

        $close = null;

        $open_tags = array();

        $last_tag = array();

        $single_tags = array(
            'br', 
            'img', 
            'hr', 
            'area', 
            'param'
        );

        $no_nest = array(
            'p' => array(
                'table', 
                'li'
            ),
            'li' => array(
                'ul', 
                'ol'
            ),
            'td' => array(
                'tr'
            ),
            'tr' => array(
                'table'
            )
        );

        $nest = array(
            'td' => array(
                'tr'
            ),
            'th' => array(
                'tr'
            ),
            'tr' => array(
                'table'
            ),
            'tbody' => array(
                'table'
            ),
            'tfoot' => array(
                'table'
            ),
            'thead' => array(
                'table'
            ),
            'caption' => array(
                'table'
            ),
            'colgroup' => array(
                'table'
            ),
            'col' => array(
                'table'
            ),
            'map' => array(
                'area'
            ),
            'param' => array(
                'object'
            ),
            'li' => array(
                'ul', 
                'ol'
            ),
        );

        for ($i = 0; $i < count($html_parts); $i++) {

            if ($i % 2) {

                if (substr($html_parts[$i], 0, 1) == '/') { // closing tag

                    $tag_bits = explode(' ', mb_substr($html_parts[$i], 1));

                    if (substr($tag_bits[0], -1) == '/') {

                        $tag_bits[0] = mb_substr($tag_bits[0], 0, -1);
                    }

                    $tag = mb_strtolower($tag_bits[0]);

                    if (!in_array($tag, array_keys($open_tags))) {

                        $open_tags[$tag] = 0;
                    }

                    $html_parts[$i] = '/'. $tag;

                    // filter 'bad' tags or single tags
                    if (in_array($tag, $bad_tags) || in_array($tag, $single_tags)) {

                        $html_parts[$i - 1].= $html_parts[$i + 1];

                        array_splice($html_parts, $i, 2);

                        $i -= 2;

                    } else {

                        $last_tag2 = array_pop($last_tag);

                        // tag is both opened/closed correctly
                        if ($open_tags[$tag] > 0 && $last_tag2 == $tag) {

                            $open_tags[$tag]--;

                        // tag hasn't been opened
                        } else if ($open_tags[$tag] <= 0) {

                            $html_parts[$i - 1].= $html_parts[$i + 1];

                            array_splice($html_parts, $i, 2);

                            $i--;

                            array_push($last_tag, $last_tag2);

                        // previous tag hasn't been closed
                        } else if ($last_tag2 != $tag) {

                            $ta = array(
                                '/'. $last_tag2, ''
                            );

                            $ws = array();

                            if (preg_match("/( )?\\s+$/u", $html_parts[$i - 1], $ws) > 0) {

                                $html_parts[$i - 1] = preg_replace("/( )?\\s+$/u", "$1", $html_parts[$i - 1]);
                                $ta[1] = $ws[0];
                            }

                            array_splice($html_parts, $i, 0, $ta);
                            $open_tags[$last_tag2]--;
                            $i++;
                        }
                    }

                } else {

                    if (substr($html_parts[$i], -1) == '/') {

                        $html_parts[$i] = mb_substr($html_parts[$i], 0, -1);
                    }

                    if (($first_space = mb_strpos($html_parts[$i], ' ')) !== false) {

                        $html_parts[$i] = clean_attributes($html_parts[$i]);

                        $tag = mb_substr($html_parts[$i], 0, $first_space);

                    } else {

                        $tag = mb_strtolower($html_parts[$i]);

                        $html_parts[$i] = $tag;
                    }

                    if (!in_array($tag, array_keys($open_tags))) {
                        $open_tags[$tag] = 0;
                    }

                    // filter 'bad' tags
                    if (in_array($tag, $bad_tags)) {

                        $html_parts[$i - 1].= $html_parts[$i + 1];

                        array_splice($html_parts, $i, 2);

                        $i -= 2;

                    } else if (!in_array($tag, $single_tags)) {

                        if (in_array($tag, array_keys($nest))) {

                            for ($nc = 0; $nc < count($nest[$tag]); $nc++) {

                                if (in_array($nest[$tag][$nc], array_keys($open_tags))) {

                                    if ($open_tags[$nest[$tag][$nc]] == 0) {

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
                                
                                $tmp_tags = array(
                                    $last_tag2
                                );
                                
                                $tmp_len = $i;

                                while (isset($nest[$tmp_nest])) {

                                    if (in_array($last_tag2, $nest[$tmp_nest])) {

                                        break;
                                    }

                                    array_splice($html_parts, $tmp_len, 0, array($nest[$tmp_nest][0], ''));

                                    $i += 2;

                                    array_splice($tmp_tags, 1, 0, $nest[$tmp_nest][0]);

                                    $last_tag2 = $tmp_tags[1];

                                    $tmp_nest = $nest[$tmp_nest][0];
                                }

                                $tmp_len = count($last_tag);

                                for ($j = 0; $j < count($tmp_tags); $j++) {

                                    if (strlen($tmp_tags[$j]) > 0) {

                                        array_push($last_tag, $tmp_tags[$j]);

                                        if ($j != 0) {

                                            if (in_array($tmp_tags[$j], array_keys($open_tags))) {

                                                $open_tags[$tmp_tags[$j]]++;

                                            } else {

                                                $open_tags[$tmp_tags[$j]] = 1;
                                            }
                                        }
                                    }
                                }
                            }
                        }

                        array_push($last_tag, $tag);

                        $open_tags[$tag]++;

                        if (in_array($tag, array_keys($no_nest))) {

                            $opencount = 0;

                            for ($j = 0; $j < count($no_nest[$tag]); $j++) {

                                if (in_array($no_nest[$tag][$j], array_keys($open_tags))) {

                                    $opencount += $open_tags[$no_nest[$tag][$j]];
                                }
                            }

                            if ($tag == 'p') $opencount++;

                            if ($open_tags[$tag] > $opencount) {

                                for ($j = count($last_tag) - 2; $j >= 0; $j--) {

                                    if ($last_tag[$j] == $tag) {

                                        array_splice($last_tag, $j, 1);
                                        break;

                                    } else {

                                        array_splice($html_parts, $i, 0, array('/'. $last_tag[$j], ''));

                                        if (preg_match("/( )?\\s+$/u", $html_parts[$i - 1], $ws) > 0) {

                                            $html_parts[$i - 1] = preg_replace("/( )?\\s+$/u", "$1", $html_parts[$i - 1]);
                                            $html_parts[$i + 1] = $ws[0]. $html_parts[$i + 1];
                                        }

                                        $open_tags[$last_tag[$j]]--;
                                        array_splice($last_tag, $j, 1);
                                        $i+= 2;
                                    }
                                }

                                array_splice($html_parts, $i, 0, array('/'. $tag, ''));

                                if (preg_match("/( )?\\s+$/u", $html_parts[$i - 1], $ws) > 0) {

                                    $html_parts[$i - 1] = preg_replace("/( )?\\s+$/u", "$1", $html_parts[$i - 1]);
                                    $html_parts[$i + 1] = $ws[0]. $html_parts[$i + 1];
                                }

                                $open_tags[$tag]--;
                                $i+= 2;
                            }
                        }

                    } else if (substr($html_parts[$i], -2) != ' /') {

                        if (substr($html_parts[$i], -1) != '/') {

                            $html_parts[$i].= ' /';

                        } else {

                            $html_parts[$i] = mb_substr($html_parts[$i], 0, -1). ' /';
                        }
                    }
                }
            }
        }

        // reconstruct the HTML
        $tag = '';

        $tag_code  = false;
        $tag_quote = false;

        $noemots = 0;
        $spoiler = 0;

        $atags = 0;

        for ($i = 0; $i < count($html_parts); $i++) {

            if ($i % 2) {

                $tag = $html_parts[$i];

                if (mb_strlen(trim($tag)) > 0 && $tag != '/') {

                    if (($tag == 'noemots' && $noemots > 0) || ($tag == '/noemots' && $noemots > 1)) {
                        // disallows <noemots> nesting
                    } else {
                        $ret_text.= '<'. $tag. '>';
                    }

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

                    if ($tag == 'span class="spoiler"' || (substr($tag, 0, 3) == 'span' && $spoiler > 0)) {
                        $spoiler++;
                    } else if ($spoiler > 0 && $tag == '/span') {
                        $spoiler--;
                    }

                    if ($tag_code == true && $tag == '/pre') {
                        $tag_code = false;
                    } else if ($tag_quote == true && $tag == '/div') {
                        $tag_quote = false;
                    }

                    if (substr($tag, 0, 2) == 'a ' || $tag == 'a') {
                        $atags++;
                    } else if ($tag == '/a') {
                        $atags--;
                    }
                }

            } else {

                if ($links == true && $atags == 0 && $tag_code == false && $spoiler == 0) {
                    $html_parts[$i] = make_links($html_parts[$i]);
                }

                $ret_text.= $html_parts[$i];
            }
        }

        $reverse_lt = array_reverse($last_tag);

        for ($i = 0; $i < count($reverse_lt); $i++) {

            if (strlen($reverse_lt[$i]) > 0) {

                $ret_text.= '</'. $reverse_lt[$i]. '>';
            }
        }

        return $ret_text;

    } else{

        return '';
    }
}

function clean_attributes($tag)
{
    $valid = array(
        '_global' => array(
            'style',
            'align',
            'class',
            'id',
            'title',
            'dir',
            'lang',
            'accesskey',
            'tabindex',
        ),
        'a' => array(
            'href',
            'title'
        ),
        'hr' => array(
            'size',
            'width',
            'noshade'
        ),
        'br' => array(
            'clear'
        ),
        'font' => array(
            'size',
            'color',
            'face'
        ),
        'blockquote' => array(
            'cite'
        ),
        'pre' => array(
            'width'
        ),
        'del' => array(
            'cite',
            'datetime'
        ),
        'ins' => array(
            'cite',
            'datetime'
        ),
        'iframe' => array(
            'src',
            'width',
            'height',
            'class',
            'frameborder',
            'allowfullscreen'
        ),
        'img' => array(
            'src',
            'width',
            'height',
            'alt',
            'border',
            'usemap',
            'longdesc',
            'vspace',
            'hspace',
            'ismap'
        ),
        'map' => array(
            'name'
        ),
        'area' => array(
            'shape',
            'coords',
            'href',
            'alt',
            'nohref'
        ),
        'table' => array(
            'border',
            'cellspacing',
            'cellpadding',
            'width',
            'height',
            'summary',
            'bgcolor',
            'background',
            'frame',
            'rules',
            'bordercolor'
        ),
        'tbody' => array(
            'char',
            'charoff',
            'valign'
        ),
        'tfoot' => array(
            'char',
            'charoff',
            'valign'
        ),
        'thead' => array(
            'char',
            'charoff',
            'valign'
        ),
        'th' => array(
            'abbr',
            'axis',
            'background',
            'bgcolor',
            'char',
            'charoff',
            'colspan',
            'height',
            'headers',
            'rowspan',
            'scope',
            'valign',
            'width',
            'nowrap'
        ),
        'td' => array(
            'abbr',
            'axis',
            'background',
            'bgcolor',
            'char',
            'charoff',
            'colspan',
            'height',
            'headers',
            'rowspan',
            'scope',
            'valign',
            'width',
            'nowrap'
        ),
        'tr' => array(
            'bgcolor',
            'char',
            'charoff',
            'valign'
        ),
        'colgroup' => array(
            'span',
            'width',
            'char',
            'charoff',
            'valign'
        ),
        'col' => array(
            'span',
            'width',
            'char',
            'charoff',
            'valign'
        ),
        'ul' => array(
            'type',
            'start'
        ),
        'ol' => array(
            'type',
            'start'
        ),
        'il' => array(
            'type',
            'start'
        ),
        'marquee' => array(
            'direction',
            'behavior',
            'loop',
            'scrollamount',
            'scrolldelay',
            'height',
            'width',
            'hspace',
            'vspace'
        ),
        'object' => array(
            'data',
            'type',
            'width',
            'height'
        ),
        'param' => array(
            'name',
            'value'
        ),
    );
    
    $urls = array(
        'href', 
        'background', 
        'src', 
        'pluginspage', 
        'pluginurl'
    );

    $split_tag = preg_split("/\\s+/u", $tag);

    for ($i = 1; $i < count($split_tag); $i++) {

        $quote = mb_substr($split_tag[$i], mb_strpos($split_tag[$i], '=') + 1, 1);

        if ($quote == '"' || $quote == "'") {

            $lastchar = mb_substr($split_tag[$i], -1);

            if ($lastchar != $quote) {

                $tempstr = $split_tag[$i];

                for ($j = $i + 1; $j < count($split_tag); $j++) {

                    $tempstr.= ' '. $split_tag[$j];
                    $lastchar = mb_substr($split_tag[$j], -1);

                    if ($lastchar == $quote) {

                        $split_tag[$i] = $tempstr;

                        array_splice($split_tag, $i + 1, $j - $i);

                        break;
                    }
                }
            }
        }
    }

    $tag_name = mb_strtolower($split_tag[0]);

    $valid_tags = array_keys($valid);

    if (in_array($tag_name, $valid_tags)) {

        for ($i = 1; $i < count($split_tag); $i++) {

            $attrib = explode('=', $split_tag[$i]);

            if (!in_array(strtolower($attrib[0]), $valid[$tag_name]) && !in_array(strtolower($attrib[0]), $valid['_global'])) {

                array_splice($split_tag, $i, 1);
                $i--;

            } else {

                $tmp_attrib = mb_strtolower($attrib[0]). "=";
                $attrib_value = mb_substr($split_tag[$i], mb_strlen($tmp_attrib));

                $first_char = mb_substr($attrib_value, 0, 1);
                $last_char = mb_substr($attrib_value, -1);

                if ($first_char == "\"" || $first_char == "'") {

                    $attrib_value = mb_substr($attrib_value, 1);
                }

                if ($last_char == "\"" || $last_char == "'") {

                    $attrib_value = mb_substr($attrib_value, 0, -1);
                }

                if ($tmp_attrib == 'style=') {

                    $attrib_value = clean_styles($attrib_value);
                }

                if (in_array(substr($tmp_attrib, 0, -1), $urls)) {

                    $attrib_value = preg_replace("/javascript:/ixu", '', $attrib_value);
                }

                $tmp_attrib.= "\"". $attrib_value. "\"";

                $split_tag[$i] = $tmp_attrib;
            }
        }

    } else {

        for ($i = 1; $i < count($split_tag); $i++) {

            $attrib = explode('=', $split_tag[$i]);

            if (!in_array(strtolower($attrib[0]), $valid['_global'])) {

                array_splice($split_tag, $i, 1);
                $i--;

            } else {

                $tmp_attrib = mb_strtolower($attrib[0]). '=';
                $attrib_value = mb_substr($split_tag[$i], mb_strlen($tmp_attrib));

                $first_char = mb_substr($attrib_value, 0, 1);
                $last_char = mb_substr($attrib_value, -1);

                if ($first_char == "\"" || $first_char == "'") {

                    $attrib_value = mb_substr($attrib_value, 1);
                }

                if ($last_char == "\"" || $last_char == "'") {

                    $attrib_value = mb_substr($attrib_value, 0, -1);
                }

                if ($tmp_attrib == 'style=') {

                    $attrib_value = clean_styles($attrib_value);
                }

                $tmp_attrib.= "\"". $attrib_value. "\"";

                $split_tag[$i] = $tmp_attrib;
            }
        }
    }

    $new_tag = $tag_name;

    for ($i = 1; $i < count($split_tag); $i++) {

        $new_tag.= ' '. $split_tag[$i];
    }

    return $new_tag;
}

function tidy_html_linebreaks($html)
{
    $html = preg_replace("/<br( [^>]*)?>(\n)?/iu", "\n", $html);
    $html = preg_replace("/<p( [^>]*)?>/iu", '', $html);
    $html = preg_replace("/<\\/p( [^>]*)?>(\n\n)?/iu", "\n\n", $html);    
    $html = preg_replace("/\n\\s*\n\\s*\n\\s*/", "\n\n", $html);
    
    return $html;
}

function tidy_html($html, $linebreaks = true, $links = true)
{
    // turn <br /> and <p>...</p> back into linebreaks
    // only if auto-linebreaks is enabled
    if ($linebreaks == true) {
        $html = tidy_html_linebreaks($html);
    }

    // turn autoconverted links back into text
    if ($links == true) {

        $html = preg_replace("/<a href=\"(http:\\/\\/)?([^\"]*)\">((http:\\/\\/)?\\2)<\\/a>/u", "$3", $html);
        $html = preg_replace("/<a href=\"(mailto:)?([^\"]*)\">((mailto:)?\\2)<\\/a>/u", "$3", $html);
    }

    // Make <code>..</code> tag, and html_entity_decode
    $html = preg_replace_callback('/<div class="quotetext" id="code-([^"]*)">.*?<\/div>.*?<pre class="code">(.*?)<\/pre>/isu', 'tidy_html_code_tag_callback', $html);

    // Quote tags
    $html = preg_replace_callback('/<div class="quotetext" id="quote">.+?(<a href="([^"]*)">)?([^<>]*)(<\/a>)?<\/div>\s*<div class="quote">(.*)<\/div>/isu', 'tidy_html_quote_tag_callback', $html);

    // Newer inline spoiler tag.
    $html = preg_replace('/<span class="spoiler"><span>(.*)<\/span><\/span>/isu', "<spoiler>\\1</spoiler>", $html);

    // Older block spoiler tag.
    $html = preg_replace('/<div class="quotetext" id="spoiler">.+?<\/div>.*?<div class="spoiler">(.*)<\/div>/isu', '<spoiler>\\1</spoiler>', $html);
    
    // Youtube tag - part 1
    $html = preg_replace('/<iframe class="youtube" width="480" height="390" src="[^"]+" title="(((http|https):\/\/)?(www\.)?(youtube\.com\/watch\?v=([^&|"]+)|youtu\.be\/([^"]+)))" frameborder="0" allowfullscreen="true"><\/iframe>/isu', '<youtube>\\1</youtube>', $html);
    
    // Youtube tag - part 2
    $html = preg_replace('/<iframe class="youtube" width="480" height="390" src="[^"]+" title="([^"]+)" frameborder="0" allowfullscreen="true"><\/iframe>/isu', '<youtube>http://www.youtube.com/watch?v=\\1</youtube>', $html);

    // Flash tag
    $html = preg_replace_callback('/<object type="application\/x-shockwave-flash" data="([^"]+)"( width="([^"]+)")?( height="([^"]+)")?><param name="movie" value="\1" \/>(<param name="wmode" value="(opaque|transparent)" \/>)?<\/object>/isu', 'tidy_html_flash_tag_callback', $html);

    return $html;
}

function tidy_tiny_mce($html)
{
    // No emotes tag
    $html = str_replace('<noemots>', '<span class="noemots">', $html);
    $html = str_replace('</noemots>', '</span>', $html);

    // Code tag
    $html = preg_replace_callback("/<pre class=\"code\">(.*?)<\\/pre>/isu", "tidy_html_pre_tag_callback", $html);
    
    // Youtube video tag = Part 1
    $html = preg_replace_callback('/<iframe class="youtube" width="480" height="390" src="[^"]+" title="(((http|https):\/\/)?(www\.)?(youtube\.com\/watch\?v=([^&|"]+)|youtu\.be\/([^"]+)))" frameborder="0" allowfullscreen="true"><\/iframe>/isu', 'tidy_tiny_mce_youtube_iframe_tag_callback', $html);
    
    // Youtube video tag - Part 2
    $html = preg_replace_callback('/<iframe class="youtube" width="480" height="390" src="[^"]+" title="([^"]+)" frameborder="0" allowfullscreen="true"><\/iframe>/isu', 'tidy_tiny_mce_youtube_iframe_tag_callback', $html);
    
    // Flash
    $html = preg_replace_callback('/<object type="application\/x-shockwave-flash" data="([^"]+)"( width="([^"]+)")?( height="([^"]+)")?><param name="movie" value="\1">(<param name="wmode" value="(opaque|transparent)">)?<\/object>/isu', 'tidy_tiny_mce_flash_object_tag_callback', $html);

    return $html;
}

function fix_tiny_mce_html($html)
{
    // Trim whitespace from around <br /> tags
    $html = preg_replace('/(\s)?<br( [^>]*)?>(\s)?(\n)?/i', "<br />\n", $html);
    
    // Youtube tag - Part 1
    $html = preg_replace_callback('/<img class="mceItem youtube" title="(((http|https):\/\/)?(www\.)?(youtube\.com\/watch\?v=([^&|"]+)|youtu\.be\/([^"]+)))" src="[^"]+" alt="([^"]+)"\s?\/>/isu', 'tidy_tiny_mce_youtube_img_tag_callback', $html);
    
    // Youtube tag - Part 2
    $html = preg_replace_callback('/<img class="mceItem youtube" src="[^"]+" alt="([^"]+)"\s?\/>/isu', 'tidy_tiny_mce_youtube_img_tag_callback', $html);

    // Convert flash image into real object tag.
    $html = preg_replace_callback('/<img class="mceItem flash" src="[^"]+" alt="(.+);wmode=(transparent|opaque)" width="([^"]+)" height="([^"]+)"[^>]+>/isu', 'tidy_tiny_mce_flash_img_tag_callback', $html);

    return $html;
}

function tidy_tiny_mce_youtube_img_tag_callback($matches_array)
{
    if (!isset($matches_array[2]) || strlen(trim($matches_array[2])) == 0) {
        $matches_array[2] = 'http://';
    }    
    
    if (isset($matches_array[7], $matches_array[8]) && ($matches_array[7] == $matches_array[8])) {

        return sprintf('<iframe class="youtube" width="480" height="390" src="%swww.youtube.com/embed/%s" title="%s" frameborder="0" allowfullscreen="true"></iframe>', $matches_array[2], $matches_array[8], $matches_array[1]);

    } else if (isset($matches_array[6], $matches_array[8]) && ($matches_array[6] == $matches_array[8])) {

        return sprintf('<iframe class="youtube" width="480" height="390" src="%swww.youtube.com/embed/%s" title="%s" frameborder="0" allowfullscreen="true"></iframe>', $matches_array[2], $matches_array[8], $matches_array[1]);
    
    } else if (isset($matches_array[1])) {
        
        return sprintf('<iframe class="youtube" width="480" height="390" src="http://www.youtube.com/embed/%1$s" title="%1$s" frameborder="0" allowfullscreen="true"></iframe>', $matches_array[1]);
    }

    return '';    
}

function tidy_tiny_mce_youtube_iframe_tag_callback($matches_array)
{
    if (isset($matches_array[1], $matches_array[7])) {

        return sprintf('<img src="http://img.youtube.com/vi/%1$s/0.jpg" class="mceItem youtube" alt="%1$s" />', $matches_array[7]);

    } else if (isset($matches_array[1], $matches_array[6])) {

        return sprintf('<img src="http://img.youtube.com/vi/%1$s/0.jpg" class="mceItem youtube" alt="%1$s" />', $matches_array[6]);
    
    } else if (isset($matches_array[1])) {
        
        return sprintf('<img src="http://img.youtube.com/vi/%1$s/0.jpg" class="mceItem youtube" alt="%1$s" />', $matches_array[1]);
    }

    return '';
}

function tidy_html_code_tag_callback($matches_array)
{
    return sprintf('<code language="%s">%s</code>', $matches_array[1], htmlentities_decode_array(strip_tags($matches_array[2])));
}

function tidy_html_quote_tag_callback($matches_array)
{
    return sprintf('<quote source="%s" url="%s">%s</quote>', $matches_array[3], $matches_array[2], $matches_array[5]);
}

function tidy_html_flash_tag_callback($matches_array)
{
    if (!isset($matches_array[1]) && strlen(trim($matches_array)) == 0) {
        return '';
    }

    $flash_html_attr = array(
        'src' => sprintf('"%s"', $matches_array[1])
    );

    if (isset($matches_array[3]) && is_numeric($matches_array[3])) {
        $flash_html_attr['width'] = sprintf('"%s"', $matches_array[3]);
    }

    if (isset($matches_array[5]) && is_numeric($matches_array[5])) {
        $flash_html_attr['height'] = sprintf('"%s"', $matches_array[5]);
    }

    if (isset($matches_array[7]) && in_array($matches_array[7], array('opaque', 'transparent'))) {
        $flash_html_attr['wmode'] = sprintf('"%s"', $matches_array[7]);
    }

    return sprintf("<flash %s />", implode_assoc($flash_html_attr, '=', ' '));
}

function tidy_tiny_mce_flash_img_tag_callback($matches_array)
{
    if (!isset($matches_array[1], $matches_array[2], $matches_array[3], $matches_array[4])) {
        return '';
    }

    return sprintf('<object type="application/x-shockwave-flash" data="%1$s" width="%3$s" height="%4$s"><param name="movie" value="%1$s"><param name="wmode" value="%2$s"></object>', urldecode($matches_array[1]), $matches_array[2], $matches_array[3], $matches_array[4]);
}

function tidy_tiny_mce_flash_object_tag_callback($matches_array)
{
    if (!isset($matches_array[1]) && strlen(trim($matches_array)) == 0) {
        return '';
    }

    if (isset($matches_array[3]) && is_numeric($matches_array[3])) {
        $flash_html_attr['width'] = sprintf('"%s"', $matches_array[3]);
    }

    if (isset($matches_array[5]) && is_numeric($matches_array[5])) {
        $flash_html_attr['height'] = sprintf('"%s"', $matches_array[5]);
    }

    if (isset($matches_array[7]) && in_array($matches_array[7], array('opaque', 'transparent'))) {
        $flash_wmode = $matches_array[7];
    } else {
        $flash_wmode = 'opaque';
    }

    return sprintf('<img class="mceItem flash" src="tiny_mce/plugins/flash/img/blank.gif" alt="%s;wmode=%s" %s />', urlencode($matches_array[1]), urlencode($flash_wmode), implode_assoc($flash_html_attr, '=', ' '));
}

function tidy_html_pre_tag_callback($matches)
{
    return sprintf('<pre class="code">%s</pre>', strip_tags($matches[1]));
}

function clean_styles($style)
{
    // Prevent inline comments
    $style = preg_replace('/\*+\/+|\/+\*+/xu', '', $style);

    // Prevent XSS javascript hacks
    $style = preg_replace('/url\(|expression\(/ixu', '', $style);

    // Array of premitted CSS attributes
    $valid_attributes_array = array(
        'font-family',
        'font-style',
        'font-variant',
        'font-weight',
        'font-size',
        'font',
        'color',
        'background-color',
        'word-spacing',
        'letter-spacing',
        'text-decoration',
        'vertical-align',
        'text-transform',
        'text-align',
        'text-indent',
        'line-height',
        'margin-top',
        'margin-bottom',
        'margin-left',
        'margin-right',
        'margin',
        'padding-top',
        'padding-bottom',
        'padding-left',
        'padding-right',
        'padding',
        'border-top-width',
        'border-top-width',
        'border-right-width',
        'border-bottom-width',
        'border-left-width',
        'border-width',
        'border-color',
        'border-style',
        'border-top',
        'border-right',
        'border-bottom',
        'border-left',
        'border',
        'width',
        'height',
        'float',
        'clear',
        'white-space',
        'list-style-type',
        'list-style-image',
        'list-style-position',
        'list-style',
    );

    // Convert arrays to strings for regular express matching
    $valid_attributes_preg = implode("$|^", array_map('preg_quote_callback', $valid_attributes_array));

    // Split the in-line style string into an array of attributes and values.
    $matches_array = array();

    if (preg_match_all('/(([^:]+):([^;]+));?/mu', trim($style), $matches_array) > 0) {

        // Clean up the attribute names and values (trim)
        $attribute_names_array  = array_map('trim', $matches_array[2]);
        $attribute_values_array = array_map('trim', $matches_array[3]);

        // Filter the attribute names by the valid list above.
        $attribute_names_array = preg_grep("/$valid_attributes_preg/u", $attribute_names_array);

        // Initialise our new array to store the permitted attributes and values.
        $clean_style_array = array();

        // Loop through the remaining and filter the restricted values.
        foreach ($attribute_names_array as $key => $attribute) {

            if (isset($attribute_values_array[$key]) && strlen($attribute_values_array[$key]) > 0) {

                $value = clean_styles_restrict($attribute_values_array[$key]);
                $clean_style_array[] = "$attribute: $value";
            }
        }

        if (sizeof($clean_style_array) > 0) {

            return implode('; ', $clean_style_array);
        }
    }

    return '';
}

function clean_styles_restrict($value)
{
    $matches = array();

    if (preg_match("/^([0-9]+)(.+)$/Du", trim($value), $matches) > 0) {

        if (isset($matches[2])) {

            switch($matches[2]) {

                case 'px':

                    if ($matches[1] < 0) return '0px';
                    if ($matches[1] > 350) return '350px';
                    break;

                case 'pt':

                    if ($matches[1] < 0) return '0pt';
                    if ($matches[1] > 250) return '250pt';
                    break;

                case 'em':

                    if ($matches[1] < 0) return '0em';
                    if ($matches[1] > 25) return '25em';
                    break;

                case '%':

                    if ($matches[1] < 0) return '0%';
                    if ($matches[1] > 100) return '100%';
                    break;
            }

        } else {

            if ($matches[2] < 0) return 0;
            if ($matches[2] > 350) return 350;
        }
    }

    return $value;
}

function add_paragraphs($html, $br_only = true)
{
    $html = str_replace("\r", '', $html);

    $tags = array(
        'table', 
        'div', 
        'pre', 
        'ul', 
        'ol', 
        'object', 
        'font'
    );

    $tags_nest = array(
        'table' => array(
            'td', 
            'th'
        ),
        'ul' => array(
            'li'
        ),
        'ol' => array(
            'li'
        ),
        'div' => array(
            true
        ),
        'pre' => array(
            false
        ),
        'object' => array(
            false
        ),
        'font' => array(
            true, 
            true
        ),
        'a' => array(
            true, 
            true
        ),
        'span' => array(
            true, 
            true
        ),        
    );

    $current_tag = '';

    $html_pos = 0;

    $html_array = array(
        $html
    );

    while (strlen(trim($html_array[count($html_array) - 1])) > 0) {

        $current_pos = mb_strlen($html_array[$html_pos]);

        for ($i = 0; $i < count($tags); $i++) {

            $open = mb_strpos($html_array[$html_pos], '<'. $tags[$i]);

            if ($open < $current_pos && is_integer($open)) {

                $current_pos = $open;
                $current_tag = $tags[$i];
            }
        }

        if ($current_pos >= mb_strlen($html_array[$html_pos])) break;

        $close = -1;

        $open_num = 0;

        $j = $current_pos + 1;

        while (1) {

            $open = mb_strpos($html_array[$html_pos], '<'. $current_tag, $j);
            $close = mb_strpos($html_array[$html_pos], '</'. $current_tag, $j);

            if (!is_integer($open)) {
                $open = $close + 1;
            }

            if ($close < $open && $open_num == 0) {

                break;

            } else if ($close < $open) {

                $open_num--;
                $open = $close;

            } else {

                $open_num++;
            }

            $j = $open + 1;
        }

        $close = mb_strpos($html_array[$html_pos], '>', $close) + 1;

        $html_array[$html_pos + 1] = mb_substr($html_array[$html_pos], $current_pos, $close - $current_pos);
        $html_array[$html_pos + 2] = mb_substr($html_array[$html_pos], $close);
        $html_array[$html_pos] = mb_substr($html_array[$html_pos], 0, $current_pos);

        $html_pos += 2;
    }
    
    $return = '';

    $p_open = false;

    for ($i = 0; $i < count($html_array); $i++) {

        if ($i % 2) {

            $tag = array();

            preg_match("/^<(\\p{L}+)(\\b[^<>]*)>/iu", $html_array[$i], $tag);

            if (isset($tag[1]) && isset($tags_nest[$tag[1]])) {

                if (!is_bool($tags_nest[$tag[1]][0])) {

                    $nest = $tags_nest[$tag[1]];

                    for ($j = 0; $j < count($nest); $j++) {

                        $offset = 0;

                        while (mb_strpos($html_array[$i], '<'. $nest[$j], $offset) !== false) {

                            $current_pos = mb_strpos($html_array[$i], '<'. $nest[$j], $offset);
                            $current_pos = mb_strpos($html_array[$i], '>', $current_pos) + 1;
                            
                            $k = $current_pos + 1;
                            
                            $open_num = 0;

                            while (1) {

                                $open = mb_strpos($html_array[$i], '<'. $current_tag, $k);
                                $close = mb_strpos($html_array[$i], '</'. $current_tag, $k);

                                if (!is_integer($open)) {
                                    $open = $close + 1;
                                }

                                if ($close < $open && $open_num == 0) {

                                    break;

                                } else if ($close < $open) {

                                    $open_num--;
                                    $open = $close;

                                } else {

                                    $open_num++;
                                }

                                $k = $open + 1;
                            }                            

                            $tmp = array();

                            $tmp[0] = mb_substr($html_array[$i], 0, $current_pos);
                            $tmp[1] = mb_substr($html_array[$i], $current_pos, $close - $current_pos);
                            $tmp[2] = mb_substr($html_array[$i], $close);

                            $tmp[1] = add_paragraphs($tmp[1], true);

                            $offset = mb_strlen($tmp[0]. $tmp[1]);

                            $html_array[$i] = $tmp[0]. $tmp[1]. $tmp[2];
                        }
                    }

                } else if ($tags_nest[$tag[1]][0] == true) {

                    $current_pos = mb_strpos($html_array[$i], '>') + 1;
                    $close = mb_strrpos($html_array[$i], '<');

                    $tmp = array();

                    $tmp[0] = mb_substr($html_array[$i], 0, $current_pos);
                    $tmp[1] = mb_substr($html_array[$i], $current_pos, $close - $current_pos);
                    $tmp[2] = mb_substr($html_array[$i], $close);

                    $tmp[1] = add_paragraphs($tmp[1], true);

                    $html_array[$i] = $tmp[0]. $tmp[1]. $tmp[2];
                }
            }

            if (isset($tag[1], $tags_nest[$tag[1]], $tags_nest[$tag[1]][1]) && ($tags_nest[$tag[1]][1] != true)) {

                if (trim($html_array[$i + 1]) == '') {

                    $return.= $html_array[$i]. "\n";

                } else {

                    $return.= $html_array[$i]. "\n\n";
                }

            } else {

                $return.= $html_array[$i];
            }

        } else if ($br_only == false) {

            $html_array[$i] = preg_replace("/(<br( [^>]*)?>)([^\n\r])/iu", "$1\n$3", $html_array[$i]);
            $html_array[$i] = preg_replace("/([^\n\r])(<p( [^>]*)?>)/iu", "$1\n\n$2", $html_array[$i]);
            $html_array[$i] = preg_replace("/(<\\/p( [^>]*)?>)([^\n\r])/iu", "</p>\n\n$3", $html_array[$i]);

            $tmp = explode("\n", $html_array[$i]);

            if (count($tmp) > 1) {

                $p_open = true;

                if (!preg_match("/(\\s*<[^<>]*>\\s*)*<p[ >]/u", $tmp[0])) {

                    $tmp[0] = '<p>'. $tmp[0];
                }
            }

            for ($j = 0; $j < count($tmp) - 1; $j++) {

                if (preg_match("/<\\/p>$/iu", $tmp[$j]) > 0) {

                    $p_open = false;

                    $tmp[$j + 1] = preg_replace("/^<p( [^>]*)?>/iu", '', $tmp[$j + 1]);
                    $tmp[$j + 1] = preg_replace("/<br( [^>]*)?>$/Diu", '', $tmp[$j + 1]);
                    $tmp[$j + 1] = preg_replace("/<\\/p>$/iu", '', $tmp[$j + 1]);

                    if (!isset($tmp[$j + 2])) break;

                    $p_open = true;

                    if (!preg_match("/(\\s*<[^<>]*>\\s*)*<p[ >]/u", $tmp[$j + 2])) {

                        $tmp[$j + 2] = '<p>'. $tmp[$j + 2];
                    }

                    $j++;

                } else if (!preg_match("/<br( [^>]*)?>$/Diu", $tmp[$j])) {

                    $tmp[$j + 1] = preg_replace("/^<p( [^>]*)?>/iu", '', $tmp[$j + 1]);
                    $tmp[$j + 1] = preg_replace("/<br( [^>]*)?>$/Diu", '', $tmp[$j + 1]);
                    $tmp[$j + 1] = preg_replace("/<\\/p>$/iu", '', $tmp[$j + 1]);

                    if (preg_match("/^\\s*$/u", $tmp[$j + 1]) > 0 && $p_open == true) {

                        $p_open = false;

                        $tmp[$j].= '</p>';

                        if (!isset($tmp[$j + 2])) break;

                        $p_open = true;

                        if (!preg_match("/(\\s*<[^<>]*>\\s*)*<p[ >]/u", $tmp[$j + 2])) {

                            $tmp[$j + 2] = '<p>'. $tmp[$j + 2];
                        }

                        $j++;

                    } else {
                        
                        $tmp[$j].= '<br />';
                    }

                } else {

                    $tmp[$j + 1] = preg_replace("/^<p( [^>]*)?>/iu", '', $tmp[$j + 1]);
                    $tmp[$j + 1] = preg_replace("/<br( [^>]*)?>$/Diu", '', $tmp[$j + 1]);
                    $tmp[$j + 1] = preg_replace("/<\\/p>$/iu", '', $tmp[$j + 1]);
                }
            }

            if ($p_open == true && !preg_match("/<\\/p>$/iu", $tmp[$j]) && mb_strlen(trim($tmp[$j])) > 0) {

                $tmp[$j].= '</p>';
            }

            $html_array[$i] = implode("\n", $tmp);
            $html_array[$i] = preg_replace("/(<p( [^>]*)?>)\\s*<\\/p>/iu", "$1&nbsp;</p>", $html_array[$i]);

            $tag = array();

            if (isset($html_array[$i]) && isset($html_array[$i + 1])) {

                if (preg_match('/^<(\p{L}+)(\b[^<>]*)>/iu', $html_array[$i + 1], $tag) > 0) {

                    if (isset($tags_nest[$tag[1]][1]) && $tags_nest[$tag[1]][1] != true && strlen(trim($html_array[$i])) > 0) {

                        $html_array[$i].= "\n\n";
                    }
                }
            }

            $return.= $html_array[$i];

        } else {

            $html_array[$i] = preg_replace("/(<br( [^>]*)?>)([^\n\r])/iu", "$1\n$3", $html_array[$i]);
            $html_array[$i] = preg_replace("/([^\n\r])(<p( [^>]*)?>)/iu", "$1\n$2", $html_array[$i]);
            $html_array[$i] = preg_replace("/(<\\/p( [^>]*)?>)([^\n\r])/iu", "</p>\n\n$3", $html_array[$i]);
            $html_array[$i] = preg_replace("/(<br( [^>]*)?>)|(<p( [^>]*)?>)|(<\\/p( [^>]*)?>)/iu", '', $html_array[$i]);

            $html_array[$i] = nl2br($html_array[$i]);

            $return.= $html_array[$i];
        }
    }

    return $return;
}

function make_html($html, $br_only = false, $emoticons = true, $links = true)
{
    $html = htmlentities_array($html);

    if ($links == true) {
        $html = make_links($html);
    }

    if ($emoticons == false) {
        $html = '<noemots>'. $html. '</noemots>';
    }

    $html = add_paragraphs($html, $br_only);

    return $html;
}

function make_links($html)
{
    $html = ' '. $html;

    // URL:
    $html = preg_replace("/(\\s|\\()(\\p{L}+:\\/\\/([^:\\s]+:?[^@\\s]+@)?[_\\.0-9a-z-]*(:\\d+)?([\\/?#]\\S*[^),\\.\\s])?)/iu", "$1<a href=\"$2\">$2</a>", $html);
    $html = preg_replace("/(\\s|\\()(www\\.[_\\.0-9a-z-]*(:\\d+)?([\\/?#]\\S*[^),\\.\\s])?)/iu", "$1<a href=\"http://$2\">$2</a>", $html);
    // MAIL:
    $html = preg_replace("/(\\s|\\()(mailto:)?([0-9a-z][_\\.0-9a-z-]*@[0-9a-z][_\\.0-9a-z-]*\\.[a-z]{2,})/iu", "$1<a href=\"mailto:$3\">$2$3</a>", $html);

    return mb_substr($html, 1);
}

?>