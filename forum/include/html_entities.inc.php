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

/* $Id: html_entities.inc.php,v 1.2 2005-06-17 17:38:43 decoyduck Exp $ */

// ================================================================
// |                                                              |
// |  IF YOU'RE GOING TO EDIT THIS SCRIPT MAKE SURE YOU DO IT     |
// |  WITH AN EDITOR THAT IS FULLY UTF-8 COMPLIANT OR YOU WILL    |
// |  BREAK THINGS.                                               |
// |                                                              |
// ================================================================


// Initialise the array

$html_entities = array();

// Named entities

$html_entities['&quot;'] = "\"";
$html_entities['&amp;'] = "&";
$html_entities['&lt;'] = "<";
$html_entities['&gt;'] = ">";
$html_entities['&iexcl;'] = "¡";
$html_entities['&cent;'] = "¢";
$html_entities['&pound;'] = "£";
$html_entities['&curren;'] = "¤";
$html_entities['&yen;'] = "¥";
$html_entities['&euro;'] = "€";
$html_entities['&brvbar;'] = "¦";
$html_entities['&sect;'] = "§";
$html_entities['&uml;'] = "¨";
$html_entities['&copy;'] = "©";
$html_entities['&ordf;'] = "ª";
$html_entities['&laquo;'] = "«";
$html_entities['&not;'] = "¬";
$html_entities['&shy;'] = "­";
$html_entities['&reg;'] = "®";
$html_entities['&trade;'] = "™";
$html_entities['&macr;'] = "¯";
$html_entities['&deg;'] = "°";
$html_entities['&plusmn;'] = "±";
$html_entities['&sup2;'] = "²";
$html_entities['&sup3;'] = "³";
$html_entities['&acute;'] = "´";
$html_entities['&micro;'] = "µ";
$html_entities['&para;'] = "¶";
$html_entities['&middot;'] = "·";
$html_entities['&cedil;'] = "¸";
$html_entities['&sup1;'] = "¹";
$html_entities['&ordm;'] = "º";
$html_entities['&raquo;'] = "»";
$html_entities['&frac14;'] = "¼";
$html_entities['&frac12;'] = "½";
$html_entities['&frac34;'] = "¾";
$html_entities['&iquest;'] = "¿";
$html_entities['&times;'] = "×";
$html_entities['&divide;'] = "÷";
$html_entities['&Agrave;'] = "À";
$html_entities['&Aacute;'] = "Á";
$html_entities['&Acirc;'] = "Â";
$html_entities['&Atilde;'] = "Ã";
$html_entities['&Auml;'] = "Ä";
$html_entities['&Aring;'] = "Å";
$html_entities['&AElig;'] = "Æ";
$html_entities['&Ccedil;'] = "Ç";
$html_entities['&Egrave;'] = "È";
$html_entities['&Eacute;'] = "É";
$html_entities['&Ecirc;'] = "Ê";
$html_entities['&Euml;'] = "Ë";
$html_entities['&Igrave;'] = "Ì";
$html_entities['&Iacute;'] = "Í";
$html_entities['&Icirc;'] = "Î";
$html_entities['&Iuml;'] = "Ï";
$html_entities['&ETH;'] = "Ð";
$html_entities['&Ntilde;'] = "Ñ";
$html_entities['&Ograve;'] = "Ò";
$html_entities['&Oacute;'] = "Ó";
$html_entities['&Ocirc;'] = "Ô";
$html_entities['&Otilde;'] = "Õ";
$html_entities['&Ouml;'] = "Ö";
$html_entities['&Oslash;'] = "Ø";
$html_entities['&Ugrave;'] = "Ù";
$html_entities['&Uacute;'] = "Ú";
$html_entities['&Ucirc;'] = "Û";
$html_entities['&Uuml;'] = "Ü";
$html_entities['&Yacute;'] = "Ý";
$html_entities['&THORN;'] = "Þ";
$html_entities['&szlig;'] = "ß";
$html_entities['&agrave;'] = "à";
$html_entities['&aacute;'] = "á";
$html_entities['&acirc;'] = "â";
$html_entities['&atilde;'] = "ã";
$html_entities['&auml;'] = "ä";
$html_entities['&aring;'] = "å";
$html_entities['&aelig;'] = "æ";
$html_entities['&ccedil;'] = "ç";
$html_entities['&egrave;'] = "è";
$html_entities['&eacute;'] = "é";
$html_entities['&ecirc;'] = "ê";
$html_entities['&euml;'] = "ë";
$html_entities['&igrave;'] = "ì";
$html_entities['&iacute;'] = "í";
$html_entities['&icirc;'] = "î";
$html_entities['&iuml;'] = "ï";
$html_entities['&eth;'] = "ð";
$html_entities['&ntilde;'] = "ñ";
$html_entities['&ograve;'] = "ò";
$html_entities['&oacute;'] = "ó";
$html_entities['&ocirc;'] = "ô";
$html_entities['&otilde;'] = "õ";
$html_entities['&ouml;'] = "ö";
$html_entities['&oslash;'] = "ø";
$html_entities['&ugrave;'] = "ù";
$html_entities['&uacute;'] = "ú";
$html_entities['&ucirc;'] = "û";
$html_entities['&uuml;'] = "ü";
$html_entities['&yacute;'] = "ý";
$html_entities['&thorn;'] = "þ";
$html_entities['&yuml;'] = "ÿ";
$html_entities['&OElig;'] = "Œ";
$html_entities['&oelig;'] = "œ";
$html_entities['&Scaron;'] = "Š";
$html_entities['&scaron;'] = "š";
$html_entities['&Yuml;'] = "Ÿ";
$html_entities['&circ;'] = "ˆ";
$html_entities['&tilde'] = "˜";
$html_entities['&ensp;'] = " ";
$html_entities['&emsp;'] = " ";
$html_entities['&thinsp'] = " ";
$html_entities['&zwnj;'] = "‌";
$html_entities['&zwj;'] = "‍";
$html_entities['&lrm;'] = "‎";
$html_entities['&rlm;'] = "‏";
$html_entities['&ndash;'] = "–";
$html_entities['&mdash;'] = "—";
$html_entities['&lsquo;'] = "‘";
$html_entities['&rsquo;'] = "’";
$html_entities['&sbquo;'] = "‚";
$html_entities['&ldquo;'] = "“";
$html_entities['&rdquo;'] = "”";
$html_entities['&bdquo;'] = "„";
$html_entities['&dagger;'] = "†";
$html_entities['&Dagger;'] = "‡";
$html_entities['&permil;'] = "‰";
$html_entities['&lsaquo;'] = "‹";
$html_entities['&rsaquo;'] = "›";
$html_entities['&fnof;'] = "ƒ";
$html_entities['&bull;'] = "•";
$html_entities['&hellip;'] = "…";
$html_entities['&prime;'] = "′";
$html_entities['&Prime;'] = "″";
$html_entities['&oline;'] = "‾";
$html_entities['&frasl;'] = "⁄";
$html_entities['&weierp;'] = "℘";
$html_entities['&image;'] = "ℑ";
$html_entities['&real;'] = "ℜ";
$html_entities['&alefsym;'] = "ℵ";
$html_entities['&larr;'] = "←";
$html_entities['&uarr;'] = "↑";
$html_entities['&rarr;'] = "→";
$html_entities['&darr;'] = "↓";
$html_entities['&harr;'] = "↔";
$html_entities['&crarr;'] = "↵";
$html_entities['&lArr;'] = "⇐";
$html_entities['&uArr;'] = "⇑";
$html_entities['&rArr;'] = "⇒";
$html_entities['&dArr;'] = "⇓";
$html_entities['&hArr;'] = "⇔";
$html_entities['&forall;'] = "∀";
$html_entities['&part;'] = "∂";
$html_entities['&exist;'] = "∃";
$html_entities['&empty;'] = "∅";
$html_entities['&nabla;'] = "∇";
$html_entities['&isin;'] = "∈";
$html_entities['&notin;'] = "∉";
$html_entities['&prod;'] = "∏";
$html_entities['&sum;'] = "∑";
$html_entities['&minus;'] = "−";
$html_entities['&lowast;'] = "∗";
$html_entities['&radic;'] = "√";
$html_entities['&prop;'] = "∝";
$html_entities['&infin;'] = "∞";
$html_entities['&ang;'] = "∠";
$html_entities['&and;'] = "∧";
$html_entities['&or;'] = "∨";
$html_entities['&cap;'] = "∩";
$html_entities['&cup;'] = "∪";
$html_entities['&int;'] = "∫";
$html_entities['&there4;'] = "∴";
$html_entities['&sim;'] = "∼";
$html_entities['&cong;'] = "≅";
$html_entities['&asymp;'] = "≈";
$html_entities['&ne;'] = "≠";
$html_entities['&equiv;'] = "≡";
$html_entities['&le;'] = "≤";
$html_entities['&ge;'] = "≥";
$html_entities['&sub;'] = "⊂";
$html_entities['&sup;'] = "⊃";
$html_entities['&nsub;'] = "⊄";
$html_entities['&sube;'] = "⊆";
$html_entities['&supe;'] = "⊇";
$html_entities['&oplus;'] = "⊕";
$html_entities['&otimes;'] = "⊗";
$html_entities['&sdot;'] = "⋅";
$html_entities['&lceil;'] = "⌈";
$html_entities['&rceil;'] = "⌉";
$html_entities['&lfloor;'] = "⌊";
$html_entities['&rfloor;'] = "⌋";
$html_entities['&lang;'] = "〈";
$html_entities['&rang;'] = "〉";
$html_entities['&loz;'] = "◊";
$html_entities['&spades;'] = "♠";
$html_entities['&clubs;'] = "♣";
$html_entities['&hearts;'] = "♥";
$html_entities['&diams;'] = "♦";
$html_entities['&Alpha;'] = "Α";
$html_entities['&Beta;'] = "Β";
$html_entities['&Gamma;'] = "Γ";
$html_entities['&Delta;'] = "Δ";
$html_entities['&Epsilon;'] = "Ε";
$html_entities['&Zeta;'] = "Ζ";
$html_entities['&Eta;'] = "Η";
$html_entities['&Theta;'] = "Θ";
$html_entities['&Iota;'] = "Ι";
$html_entities['&Kappa;'] = "Κ";
$html_entities['&Lambda;'] = "Λ";
$html_entities['&Mu;'] = "Μ";
$html_entities['&Nu;'] = "Ν";
$html_entities['&Xi;'] = "Ξ";
$html_entities['&Omicron;'] = "Ο";
$html_entities['&Pi;'] = "Π";
$html_entities['&Rho;'] = "Ρ";
$html_entities['&Sigma;'] = "Σ";
$html_entities['&Tau;'] = "Τ";
$html_entities['&Upsilon;'] = "Υ";
$html_entities['&Phi;'] = "Φ";
$html_entities['&Chi;'] = "Χ";
$html_entities['&Psi;'] = "Ψ";
$html_entities['&Omega;'] = "Ω";
$html_entities['&alpha;'] = "α";
$html_entities['&beta;'] = "β";
$html_entities['&gamma;'] = "γ";
$html_entities['&delta;'] = "δ";
$html_entities['&epsilon;'] = "ε";
$html_entities['&zeta;'] = "ζ";
$html_entities['&eta;'] = "η";
$html_entities['&theta;'] = "θ";
$html_entities['&iota;'] = "ι";
$html_entities['&kappa;'] = "κ";
$html_entities['&lambda;'] = "λ";
$html_entities['&mu;'] = "μ";
$html_entities['&nu;'] = "ν";
$html_entities['&xi;'] = "ξ";
$html_entities['&omicron;'] = "ο";
$html_entities['&pi;'] = "π";
$html_entities['&rho;'] = "ρ";
$html_entities['&sigmaf;'] = "ς";
$html_entities['&sigma;'] = "σ";
$html_entities['&tau;'] = "τ";
$html_entities['&upsilon;'] = "υ";
$html_entities['&phi;'] = "φ";
$html_entities['&chi;'] = "χ";
$html_entities['&psi;'] = "ψ";
$html_entities['&omega;'] = "ω";
$html_entities['&thetasym;'] = "ϑ";
$html_entities['&upsih;'] = "ϒ";
$html_entities['&piv;'] = "ϖ";

// Numbered entities (no named counter-part)

$html_entities['&#8480;'] = "℠";
$html_entities['&#8451;'] = "℃";
$html_entities['&#8453;'] = "℅";
$html_entities['&#8457;'] = "℉";
$html_entities['&#8470;'] = "№";
$html_entities['&#8471;'] = "℗";
$html_entities['&#8478;'] = "℞";
$html_entities['&#8486;'] = "Ω";
$html_entities['&#8487;'] = "℧";
$html_entities['&#9728;'] = "☀";
$html_entities['&#9729;'] = "☁";
$html_entities['&#9730;'] = "☂";
$html_entities['&#9731;'] = "☃";
$html_entities['&#9732;'] = "☄";
$html_entities['&#9733;'] = "★";
$html_entities['&#9734;'] = "☆";
$html_entities['&#9735;'] = "☇";
$html_entities['&#9736;'] = "☈";
$html_entities['&#9737;'] = "☉";
$html_entities['&#9738;'] = "☊";
$html_entities['&#9739;'] = "☋";
$html_entities['&#9740;'] = "☌";
$html_entities['&#9741;'] = "☍";
$html_entities['&#9742;'] = "☎";
$html_entities['&#9743;'] = "☏";
$html_entities['&#9744;'] = "☐";
$html_entities['&#9745;'] = "☑";
$html_entities['&#9746;'] = "☒";
$html_entities['&#9747;'] = "☓";
$html_entities['&#9754;'] = "☚";
$html_entities['&#9755;'] = "☛";
$html_entities['&#9756;'] = "☜";
$html_entities['&#9757;'] = "☝";
$html_entities['&#9758;'] = "☞";
$html_entities['&#9759;'] = "☟";
$html_entities['&#9760;'] = "☠";
$html_entities['&#9761;'] = "☡";
$html_entities['&#9762;'] = "☢";
$html_entities['&#9763;'] = "☣";
$html_entities['&#9764;'] = "☤";
$html_entities['&#9765;'] = "☥";
$html_entities['&#9766;'] = "☦";
$html_entities['&#9767;'] = "☧";
$html_entities['&#9768;'] = "☨";
$html_entities['&#9769;'] = "☩";
$html_entities['&#9770;'] = "☪";
$html_entities['&#9771;'] = "☫";
$html_entities['&#9772;'] = "☬";
$html_entities['&#9773;'] = "☭";
$html_entities['&#9774;'] = "☮";
$html_entities['&#9775;'] = "☯";
$html_entities['&#9776;'] = "☰";
$html_entities['&#9777;'] = "☱";
$html_entities['&#9778;'] = "☲";
$html_entities['&#9779;'] = "☳";
$html_entities['&#9780;'] = "☴";
$html_entities['&#9781;'] = "☵";
$html_entities['&#9782;'] = "☶";
$html_entities['&#9783;'] = "☷";
$html_entities['&#9784;'] = "☸";
$html_entities['&#9785;'] = "☹";
$html_entities['&#9786;'] = "☺";
$html_entities['&#9787;'] = "☻";
$html_entities['&#9789;'] = "☽";
$html_entities['&#9790;'] = "☾";
$html_entities['&#9791;'] = "☿";
$html_entities['&#9792;'] = "♀";
$html_entities['&#9793;'] = "♁";
$html_entities['&#9794;'] = "♂";
$html_entities['&#9795;'] = "♃";
$html_entities['&#9796;'] = "♄";
$html_entities['&#9797;'] = "♅";
$html_entities['&#9798;'] = "♆";
$html_entities['&#9799;'] = "♇";
$html_entities['&#9800;'] = "♈";
$html_entities['&#9801;'] = "♉";
$html_entities['&#9802;'] = "♊";
$html_entities['&#9803;'] = "♋";
$html_entities['&#9804;'] = "♌";
$html_entities['&#9805;'] = "♍";
$html_entities['&#9806;'] = "♎";
$html_entities['&#9807;'] = "♏";
$html_entities['&#9808;'] = "♐";
$html_entities['&#9809;'] = "♑";
$html_entities['&#9810;'] = "♒";
$html_entities['&#9811;'] = "♓";
$html_entities['&#9812;'] = "♔";
$html_entities['&#9813;'] = "♕";
$html_entities['&#9814;'] = "♖";
$html_entities['&#9815;'] = "♗";
$html_entities['&#9816;'] = "♘";
$html_entities['&#9817;'] = "♙";
$html_entities['&#9818;'] = "♚";
$html_entities['&#9819;'] = "♛";
$html_entities['&#9820;'] = "♜";
$html_entities['&#9821;'] = "♝";
$html_entities['&#9822;'] = "♞";
$html_entities['&#9823;'] = "♟";
$html_entities['&#9825;'] = "♡";
$html_entities['&#9826;'] = "♢";
$html_entities['&#9828;'] = "♤";
$html_entities['&#9831;'] = "♧";
$html_entities['&#9832;'] = "♨";
$html_entities['&#9833;'] = "♩";
$html_entities['&#9834;'] = "♪";
$html_entities['&#9835;'] = "♫";
$html_entities['&#9836;'] = "♬";
$html_entities['&#9837;'] = "♭";
$html_entities['&#9838;'] = "♮";
$html_entities['&#9839;'] = "♯";
$html_entities['&#9985;'] = "✁";
$html_entities['&#9986;'] = "✂";
$html_entities['&#9987;'] = "✃";
$html_entities['&#9988;'] = "✄";
$html_entities['&#9990;'] = "✆";
$html_entities['&#9991;'] = "✇";
$html_entities['&#9992;'] = "✈";
$html_entities['&#9993;'] = "✉";
$html_entities['&#9996;'] = "✌";
$html_entities['&#9997;'] = "✍";
$html_entities['&#9998;'] = "✎";
$html_entities['&#9999;'] = "✏";
$html_entities['&#10003;'] = "✓";
$html_entities['&#10004;'] = "✔";
$html_entities['&#10005;'] = "✕";
$html_entities['&#10006;'] = "✖";
$html_entities['&#10007;'] = "✗";
$html_entities['&#10008;'] = "✘";
$html_entities['&#10013;'] = "✝";
$html_entities['&#10014;'] = "✞";
$html_entities['&#10015;'] = "✟";
$html_entities['&#10016;'] = "✠";
$html_entities['&#10017;'] = "✡";
$html_entities['&#10075;'] = "❛";
$html_entities['&#10076;'] = "❜";
$html_entities['&#10077;'] = "❝";
$html_entities['&#10078;'] = "❞";

?>