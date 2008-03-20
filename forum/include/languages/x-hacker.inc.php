<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
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

/* $Id: x-hacker.inc.php,v 1.275 2008-03-20 18:46:06 decoyduck Exp $ */

// British English language file

// Language character set and text direction options -------------------

$lang['_isocode'] = "en";
$lang['_textdir'] = "ltr";

// Months --------------------------------------------------------------

$lang['month'][1]  = "j@NU4ry";
$lang['month'][2]  = "fe8rU4rY";
$lang['month'][3]  = "marCH";
$lang['month'][4]  = "apr1L";
$lang['month'][5]  = "mAy";
$lang['month'][6]  = "jUn3";
$lang['month'][7]  = "jUlY";
$lang['month'][8]  = "auGU5T";
$lang['month'][9]  = "sEP+3mBeR";
$lang['month'][10] = "oc+O8Er";
$lang['month'][11] = "novEmbEr";
$lang['month'][12] = "deC3M83R";

$lang['month_short'][1]  = "j4n";
$lang['month_short'][2]  = "fe8";
$lang['month_short'][3]  = "m4r";
$lang['month_short'][4]  = "aPR";
$lang['month_short'][5]  = "m4Y";
$lang['month_short'][6]  = "jUN";
$lang['month_short'][7]  = "juL";
$lang['month_short'][8]  = "aU9";
$lang['month_short'][9]  = "sEP";
$lang['month_short'][10] = "oCT";
$lang['month_short'][11] = "nOv";
$lang['month_short'][12] = "dEc";

// Dates ---------------------------------------------------------------

// Various date and time formats as used by Beehive Forum. All times are
// expressed as 24 hour time format.

$lang['daymonthyear'] = "%s %s %s";                  // 1 Jan 2005
$lang['monthyear'] = "%s %s";                        // Jan 2005
$lang['daymonthyearhourminute'] = "%s %s %s %s:%s";  // 1 Jan 2005 12:00
$lang['daymonthhourminute'] = "%s %s %s:%s";         // 1 Jan 12:00
$lang['daymonth'] = "%s %s";                         // 1 Jan
$lang['hourminute'] = "%s:%s";                       // 12:00

// Periods -------------------------------------------------------------

// Various time periods as used by Beehive Forum.

$lang['date_periods']['year']   = "%s y34R";
$lang['date_periods']['month']  = "%s M0N+H";
$lang['date_periods']['week']   = "%s W3Ek";
$lang['date_periods']['day']    = "%s d4y";
$lang['date_periods']['hour']   = "%s hOur";
$lang['date_periods']['minute'] = "%s m1NU+E";
$lang['date_periods']['second'] = "%s \$3C0Nd";

// As above but plurals (2 years vs. 1 year, etc.)

$lang['date_periods_plural']['year']   = "%s yE4r\$";
$lang['date_periods_plural']['month']  = "%s m0N+H5";
$lang['date_periods_plural']['week']   = "%s weEk\$";
$lang['date_periods_plural']['day']    = "%s d4Y5";
$lang['date_periods_plural']['hour']   = "%s h0UR\$";
$lang['date_periods_plural']['minute'] = "%s MInU+35";
$lang['date_periods_plural']['second'] = "%s \$ec0NDs";

// Short hand periods (example: 1y, 2m, 3w, 4d, 5hr, 6min, 7sec)

$lang['date_periods_short']['year']   = "%sY";    // 1y
$lang['date_periods_short']['month']  = "%sM";    // 2m
$lang['date_periods_short']['week']   = "%sW";    // 3w
$lang['date_periods_short']['day']    = "%sD";    // 4d
$lang['date_periods_short']['hour']   = "%shr";   // 5hr
$lang['date_periods_short']['minute'] = "%sMIn";  // 6min
$lang['date_periods_short']['second'] = "%s\$eC";  // 7sec

// Common words --------------------------------------------------------

$lang['percent'] = "pErcEn+";
$lang['average'] = "aVEr49E";
$lang['approve'] = "aPPRoV3";
$lang['banned'] = "b4NNeD";
$lang['locked'] = "l0cKEd";
$lang['add'] = "adD";
$lang['advanced'] = "aDV@NcED";
$lang['active'] = "activE";
$lang['style'] = "sTYL3";
$lang['go'] = "g0";
$lang['folder'] = "f0lD3r";
$lang['ignoredfolder'] = "i9n0R3D FOld3r";
$lang['folders'] = "f0LDEr\$";
$lang['thread'] = "tHR3@d";
$lang['threads'] = "thr3Ad\$";
$lang['threadlist'] = "tHr34d l1\$+";
$lang['message'] = "m3sS49E";
$lang['from'] = "fr0m";
$lang['to'] = "to";
$lang['all_caps'] = "aLL";
$lang['of'] = "oPh";
$lang['reply'] = "repLY";
$lang['forward'] = "f0rW4Rd";
$lang['replyall'] = "rePLy +0 @ll";
$lang['pm_reply'] = "rEPlY 4S pm";
$lang['delete'] = "d3L3+3";
$lang['deleted'] = "delE+ed";
$lang['edit'] = "eDI+";
$lang['privileges'] = "priVIl3Ge\$";
$lang['ignore'] = "ignOr3";
$lang['normal'] = "norM4L";
$lang['interested'] = "iNTEr3\$+3D";
$lang['subscribe'] = "su8\$Cr1B3";
$lang['apply'] = "apPLy";
$lang['download'] = "dowNl0@D";
$lang['save'] = "s4VE";
$lang['update'] = "uPD4+3";
$lang['cancel'] = "c4nC3L";
$lang['continue'] = "c0nT1NU3";
$lang['attachment'] = "aT+@cHmeNt";
$lang['attachments'] = "at+4CHm3ntS";
$lang['imageattachments'] = "iM49e 4+t@chm3N+s";
$lang['filename'] = "fil3N4mE";
$lang['dimensions'] = "dim3N51ONS";
$lang['downloadedxtimes'] = "dOwNl04D3D: %d +ImE\$";
$lang['downloadedonetime'] = "dowNLO@DEd: 1 TiMe";
$lang['size'] = "sIz3";
$lang['viewmessage'] = "v13w mE\$5493";
$lang['deletethumbnails'] = "d3LEt3 ThumbN4IlS";
$lang['logon'] = "l0G0n";
$lang['more'] = "mOR3";
$lang['recentvisitors'] = "recEnt vIS1+OR5";
$lang['username'] = "uSERn@m3";
$lang['clear'] = "cL34R";
$lang['action'] = "aCT10N";
$lang['unknown'] = "unkNOwn";
$lang['none'] = "nON3";
$lang['preview'] = "prev1Ew";
$lang['post'] = "posT";
$lang['posts'] = "p0\$TS";
$lang['change'] = "chANg3";
$lang['yes'] = "ye\$";
$lang['no'] = "n0";
$lang['signature'] = "s19N4Tur3";
$lang['signaturepreview'] = "s1gNaTuRe PreV1Ew";
$lang['signatureupdated'] = "si9N4+URe UpD4T3D";
$lang['signatureupdatedforallforums'] = "si9N4+Ur3 uPd4+3D Ph0R @lL PHoRums";
$lang['back'] = "b4CK";
$lang['subject'] = "sUBJeC+";
$lang['close'] = "clos3";
$lang['name'] = "n4ME";
$lang['description'] = "d3\$crIp+iOn";
$lang['date'] = "d@t3";
$lang['view'] = "v13w";
$lang['enterpasswd'] = "entEr P4SswoRd";
$lang['passwd'] = "p4s5W0rD";
$lang['ignored'] = "i9n0REd";
$lang['guest'] = "gueS+";
$lang['next'] = "nEX+";
$lang['prev'] = "pR3Vi0Us";
$lang['others'] = "o+heRS";
$lang['nickname'] = "n1CKn4mE";
$lang['emailaddress'] = "emaIl 4DDreSS";
$lang['confirm'] = "conF1Rm";
$lang['email'] = "em@1L";
$lang['poll'] = "pOLL";
$lang['friend'] = "fri3ND";
$lang['success'] = "sucC3\$s";
$lang['error'] = "err0R";
$lang['warning'] = "w4rNinG";
$lang['guesterror'] = "soRRY, J00 NE3D TO 8E lOgG3d in tO USe +H1S Ph34+ure.";
$lang['loginnow'] = "l0g1N N0w";
$lang['unread'] = "uNR3Ad";
$lang['all'] = "aLl";
$lang['allcaps'] = "aLl";
$lang['permissions'] = "pErm1S5I0N\$";
$lang['type'] = "typ3";
$lang['print'] = "pR1Nt";
$lang['sticky'] = "s+icKy";
$lang['polls'] = "p0Ll5";
$lang['user'] = "u53R";
$lang['enabled'] = "eN4BL3d";
$lang['disabled'] = "dIsABl3d";
$lang['options'] = "opTIoN\$";
$lang['emoticons'] = "eM0+1cOn\$";
$lang['webtag'] = "w38T@9";
$lang['makedefault'] = "m@K3 d3Ph@uL+";
$lang['unsetdefault'] = "un\$3T DefAulT";
$lang['rename'] = "rENAmE";
$lang['pages'] = "p49e\$";
$lang['used'] = "u\$Ed";
$lang['days'] = "d4ys";
$lang['usage'] = "uS@93";
$lang['show'] = "sh0w";
$lang['hint'] = "hinT";
$lang['new'] = "n3w";
$lang['referer'] = "repH3R3R";
$lang['thefollowingerrorswereencountered'] = "tHE PhollOW1Ng 3Rr0RS W3Re EnC0Un+erED:";

// Admin interface (admin*.php) ----------------------------------------

$lang['admintools'] = "admIN +O0LS";
$lang['forummanagement'] = "f0rUM m@N@9emeN+";
$lang['accessdeniedexp'] = "j00 DO nOT HaVE pErm1\$5i0N +o U\$e +hIS sECt1on.";
$lang['managefolders'] = "m4N493 pHOld3rS";
$lang['manageforums'] = "m4nAGe f0RuMS";
$lang['manageforumpermissions'] = "m4n@9E fOruM pERmISSiONs";
$lang['foldername'] = "f0lDEr N@me";
$lang['move'] = "m0vE";
$lang['closed'] = "cL0S3D";
$lang['open'] = "oP3N";
$lang['restricted'] = "re\$TR1C+eD";
$lang['forumiscurrentlyclosed'] = "%s is CURr3N+ly cl0\$ED";
$lang['youdonothaveaccesstoforum'] = "j00 D0 n0+ hAvE @cC35S tO %s";
$lang['toapplyforaccessplease'] = "t0 4PpLy PhOr 4cC3\$\$ pLe453 C0n+4CT tH3 f0RUm 0wN3R.";
$lang['adminforumclosedtip'] = "if J00 w@NT +0 cH4N9E sOM3 sETt1n9S ON Y0ur PhORUm cLick +H3 @Dm1N L1Nk 1n +3h N@v1GAt10N B4r @80v3.";
$lang['newfolder'] = "n3w pHOlD3R";
$lang['nofoldersfound'] = "n0 eX1sT1Ng PHoLD3RS FOUnD. tO @DD A phOLdEr cl1CK +3h '@dD NeW' buTtON 8eL0W.";
$lang['forumadmin'] = "fORum 4DM1n";
$lang['adminexp_1'] = "u\$e TH3 M3nU On +h3 l3FT +o mAN4gE +h1NG\$ iN y0uR F0RuM.";
$lang['adminexp_2'] = "<b>u\$Er\$</b> all0wS j00 +0 SEt 1NDiV1DU@l us3R p3RmI\$SI0ns, 1NcLUdInG 4PPoIn+iNg MOd3R@ToR\$ And 94991N9 pe0PLE.";
$lang['adminexp_3'] = "<b>uSeR 9roUP\$</b> 4lLOwS j00 TO crE4+3 U5ER 9ROup5 +O @\$\$1Gn Perm1\$s1ON\$ +0 4S m@NY 0r 4\$ pH3W usERS qu1CkLY aNd 34s1LY.";
$lang['adminexp_4'] = "<b>ban COntR0ls</b> 4LlOWs tEH 84Nn1N9 4nD un-b@NniNG Of 1P 4DDr3SsES, H++p rEph3ReRS, u53RN4m3S, emA1l aDdr3\$5e5 @ND N1CKN4m3S.";
$lang['adminexp_5'] = "<b>f0lDER\$</b> ALL0w\$ +3H CrE4T1on, MoDIfIC4tiON 4ND D3l3T10n 0ph Ph0Ld3R\$.";
$lang['adminexp_6'] = "<b>rSs FE3d\$</b> 4LLoWS J00 +0 m@N@9e r55 Fe3dS f0R pR0pA94T1On 1N+0 y0UR pHoRUm.";
$lang['adminexp_7'] = "<b>pR0f1l3S</b> lE+5 j00 cU5TOm1s3 +3H I+Em5 tH4+ APP34R iN t3H USeR PROpHIl3s.";
$lang['adminexp_8'] = "<b>f0rUm \$3++1N95</b> 4LLoWs j00 T0 cusToMIs3 y0UR F0rUm'S n4Me, 4PPe4r4nC3 4nd M4nY 0+Her tHIN9\$.";
$lang['adminexp_9'] = "<b>s+4RT pAGe</b> lEtS J00 cuStOmI5E Y0Ur fOrum'S s+4R+ P493.";
$lang['adminexp_10'] = "<b>f0rUM s+yLE</b> 4LLoW5 j00 to g3nER4+3 rAnDOm sTYl3S fOr Y0uR phoRum MeM83RS +0 U\$3.";
$lang['adminexp_11'] = "<b>wOrD f1LteR</b> 4LloWs j00 +0 PhiLT3r W0rDS J00 dON'T W@n+ +0 8e U\$3D 0n y0UR f0RUm.";
$lang['adminexp_12'] = "<b>poST1N9 5+4+S</b> g3N3R4t3s 4 rEP0rT Li\$+1N9 +HE TOp 10 post3R\$ IN @ D3F1ned perIOd.";
$lang['adminexp_13'] = "<b>forUm l1nK\$</b> L3TS J00 MaN4GE +3h lINk\$ DRoPdOWN In th3 n4vI94+1ON 84R.";
$lang['adminexp_14'] = "<b>v13W L09</b> Li5+s Rec3NT 4CtI0n\$ bY +3H ph0RUm m0DeR4+0rs.";
$lang['adminexp_15'] = "<b>m4n@ge pHoRUm5</b> lE+S J00 Cre4+3 4nd dEL3+3 4ND cL0\$e OR ReOpeN PhORuM5.";
$lang['adminexp_16'] = "<b>gLO84L f0RuM Se++1ng5</b> 4lLOw\$ J00 To M0DIfY S3tTIng\$ Wh1cH 4PhPHeCt @lL Ph0RUmS.";
$lang['adminexp_17'] = "<b>p0sT ApProVAl qU3ue</b> 4LlOwS j00 +0 vi3w 4Ny pOS+S 4w41tiNg @Ppr0V@L 8Y 4 m0D3r4+0R.";
$lang['adminexp_18'] = "<b>vi\$1+OR LOg</b> 4Ll0ws j00 +O vIew 4N 3Xt3nDed Li5T OPh V1\$1ToRs IncLUDin9 theIr Ht+P r3FeReR\$.";
$lang['createforumstyle'] = "cr34+3 @ phOrUm S+yLe";
$lang['newstylesuccessfullycreated'] = "n3w 5+yLe SuCc3\$SfUlLY CrE@TEd.";
$lang['stylealreadyexists'] = "a 5tyL3 wItH ThA+ F1L3nAm3 4Lr34Dy EX1\$+s.";
$lang['stylenofilename'] = "j00 Did NoT eNT3r @ f1L3N@Me TO \$4v3 +3H sTyLE WiTh.";
$lang['stylenodatasubmitted'] = "c0uLd No+ r34D phOruM sTyL3 D@T@.";
$lang['styleexp'] = "use +h15 p49E tO hELp cr34T3 4 r@nDoMly GeNer4+3d s+ylE F0r YOuR FOruM.";
$lang['stylecontrols'] = "con+RolS";
$lang['stylecolourexp'] = "cLick oN @ c0LOuR +0 mAK3 4 neW s+YlE \$H3e+ B@s3D On +h4+ ColOuR. CurREnT Ba\$3 c0L0ur i\$ fIR\$+ in L1st.";
$lang['standardstyle'] = "s+4ND@rd S+yL3";
$lang['rotelementstyle'] = "roT@t3D 3l3m3nT \$+yl3";
$lang['randstyle'] = "ranDOM 5TyLe";
$lang['thiscolour'] = "tH1\$ C0L0ur";
$lang['enterhexcolour'] = "oR 3N+ER @ H3x cOl0Ur +0 84\$3 4 neW \$+yLe Sh3E+ 0N";
$lang['savestyle'] = "s4Ve +H1\$ \$tYlE";
$lang['styledesc'] = "s+YL3 D3SCR1P+10N";
$lang['stylefilenamemayonlycontain'] = "styLe FiLeN4m3 M4y oNlY coNt4iN lOw3Rc@\$e leTterS (@-Z), nUmb3RS (0-9) 4nD uNdEr\$cor3.";
$lang['stylepreview'] = "s+yL3 pr3V13w";
$lang['welcome'] = "wELC0me";
$lang['messagepreview'] = "m3\$Sa93 prEViEw";
$lang['users'] = "useRs";
$lang['usergroups'] = "us3r 9RoupS";
$lang['mustentergroupname'] = "j00 mUs+ 3ntEr @ 9r0Up n4M3";
$lang['profiles'] = "proF1L3s";
$lang['manageforums'] = "mAN49E ph0rUmS";
$lang['forumsettings'] = "f0rUM 53++1NGs";
$lang['globalforumsettings'] = "gLO84L Ph0RUm s3++1nG\$";
$lang['settingsaffectallforumswarning'] = "<b>no+E:</b> +h35E \$3TtINg\$ 4PhPh3C+ 4Ll f0RUm5. WhErE tHE s3++1nG 1\$ dUPl1C@+3d ON +hE inDiVIdU4L Ph0RuM's s3t+in95 P@gE Th4T WIlL +4K3 PRECeDeNCe OVEr +H3 SE++1Ng\$ J00 Ch@NgE hERE.";
$lang['startpage'] = "sT@r+ P@9e";
$lang['startpageerror'] = "y0ur \$T@R+ p@9e c0ULd NoT 8E S4veD lOcAlLY +0 tH3 5Erv3R bEC@USe p3rM1\$\$IoN W@s dENieD.</p><p>tO chAngE YoUR 5+4r+ P49e Pl34SE CLiCk +3h dOWnL0@d 8U++0n 83LoW wh1CH WilL PR0MpT j00 tO 54V3 +H3 Ph1L3 TO YoUr h4RD DrivE. J00 c4N Th3N uplOAd THiS F1Le To y0Ur SErV3R 1Nt0 TH3 fOLl0w1N9 FOlDeR, iF neC3SsARy cre4TinG The f0ld3R StRUcTUre 1N THe pRoc3\$5.</p><p><b>%s</b></p><p>pLE4\$3 noT3 tH@T 50Me 8RoW\$eRs m4y cH@n9E th3 n4M3 of TEH PHILE Up0N d0WnLo@D. WH3N UpLO@dInG Th3 fIl3 PL3a\$e M@K3 sUre tH@t 1+ iS N4M3d 5T@rT_MAIn.PHp OTh3rWI\$3 YOUr \$t@rt paG3 WilL 4PPEar UNcH4N9eD.";
$lang['failedtoopenmasterstylesheet'] = "youR PHorUM s+YlE C0UlD n0+ bE \$aVEd 83C4u\$3 th3 mA\$t3r S+yl3 SH33+ C0UlD No+ be lo@DED. +o 54Ve yOUr S+Yl3 +He m@s+3r \$+Yl3 \$H33T (M@K3_STYlE.c5\$) Mu5+ Be l0C@tED 1n ThE S+Yl35 dIR3cToRy OpH Y0ur 8e3HiVE PhORUm 1n\$+@Ll@T1on.";
$lang['makestyleerror'] = "yOuR fORuM s+Yl3 cOulD nO+ be S4vEd LoC4LlY tO t3H sErV3R b3C@u5E p3RmI\$\$10N w@S deNIeD.</p><p>t0 s4Ve y0Ur Ph0RuM s+YlE PL34\$3 cLIcK +h3 D0WnLo4D buT+ON beLOw Wh1Ch W1lL pRoMP+ J00 +0 S4vE +He phIl3 tO Y0uR HaRD Dr1Ve. j00 c4N +hEN UPl04D ThI\$ fil3 +O y0Ur 53RV3r 1N+0 +Eh F0LlOw1N9 f0LdEr, iF n3c3\$\$ArY cRe4+InG TH3 fOlD3R S+rUcTUr3 1N t3H PrOC355.</p><p><b>%s</b></p><p>ple4SE No+E tH4T \$0m3 BrOws3RS m4Y Ch4Nge tHE nAMe OpH T3H FIlE Up0N D0WnL0@d. WheN UpL04D1n9 +3h fIl3 PlEa\$E m4k3 \$uR3 th4+ It I\$ N4M3D \$tyLE.cs\$ 0THeRWiSE TEh F0RUM 5TYlE wILL b3 uN4VAil4bLE.";
$lang['forumstyle'] = "f0rUM \$+yL3";
$lang['wordfilter'] = "w0rD F1lTEr";
$lang['forumlinks'] = "f0rUm L1nKS";
$lang['viewlog'] = "vI3W loG";
$lang['noprofilesectionspecified'] = "n0 Pr0FiLE S3CtIOn \$PeCiF13d.";
$lang['itemname'] = "i+eM N@ME";
$lang['moveto'] = "mov3 +0";
$lang['manageprofilesections'] = "m4n4GE prOPhIl3 s3C+10N\$";
$lang['sectionname'] = "sECT10n n@m3";
$lang['items'] = "iTEM\$";
$lang['mustspecifyaprofilesectionid'] = "mUs+ 5p3C1PHy 4 Pr0PhIl3 5Ec+1oN 1D";
$lang['mustsepecifyaprofilesectionname'] = "mUSt 5PeCiFy 4 PrOPh1Le \$3cTIoN N4M3";
$lang['noprofilesectionsfound'] = "n0 ExIS+1Ng pr0FiL3 \$Ec+iONs pHouNd. To @DD a pR0PHiL3 \$eC+i0N Cl1cK t3H '4Dd n3W' 8u++on 8ELOw.";
$lang['addnewprofilesection'] = "aDD N3W PRof1L3 53cT1oN";
$lang['successfullyaddedprofilesection'] = "sUCce\$sphUlLY 4DDed pR0PhIL3 S3C+iOn";
$lang['successfullyeditedprofilesection'] = "succES\$pHullY Ed1+Ed Pr0PhIlE s3cT10N";
$lang['addnewprofilesection'] = "add n3w pR0FIl3 \$eCTi0N";
$lang['mustsepecifyaprofilesectionname'] = "mus+ \$pECiFy @ pROphIl3 5EcT10n N@M3";
$lang['successfullyremovedselectedprofilesections'] = "succ3\$5PHulLy r3mOV3D \$eL3C+3D prOfIl3 \$ectI0n5";
$lang['failedtoremoveprofilesections'] = "f@1L3D T0 r3MOvE PR0pH1lE \$eCTiOn\$";
$lang['viewitems'] = "vieW 1+eMs";
$lang['successfullyaddednewprofileitem'] = "sUCC3SSpHuLLy aDDed nEw pRoFIl3 i+3m";
$lang['successfullyeditedprofileitem'] = "sUCcE\$5PHuLLy eD1T3D ProPhIlE 1+eM";
$lang['successfullyremovedselectedprofileitems'] = "sUCcES5PhUlly R3m0V3d S3L3c+eD prOF1lE 1+eM5";
$lang['failedtoremoveprofileitems'] = "fA1l3D TO r3M0Ve pRoFilE 1+eM\$";
$lang['noexistingprofileitemsfound'] = "tHERe 4rE N0 Ex15TiNG pRoPHiL3 1t3M5 1N Th1\$ S3Cti0n. +0 aDd aN 1T3m Cl1Ck +h3 '@dD n3W' bU++On 8EloW.";
$lang['edititem'] = "eD1t 1TeM";
$lang['invalidprofilesectionid'] = "inv4LId PRoPhIl3 Sec+I0n 1D Or \$3Ct10N n0T PHOunD";
$lang['invalidprofileitemid'] = "inv4L1d pRofiLe ItEm id 0r 1t3M N0t ph0uNd";
$lang['addnewitem'] = "aDD n3W I+3M";
$lang['youmustenteraprofileitemname'] = "j00 Mu\$+ eNt3R @ pR0f1L3 I+eM N4m3";
$lang['invalidprofileitemtype'] = "iNV4L1D Pr0Phil3 1T3M +yP3 \$3lECt3D";
$lang['youmustenteroptionsforselectedprofileitemtype'] = "j00 MU\$T 3n+ER \$oM3 0p+10ns pH0R \$3lEct3D pROFiL3 I+eM TyP3";
$lang['youmustentermorethanoneoptionforitem'] = "j00 mUS+ enT3r m0RE Th@n ON3 0P+10N F0R S3L3c+3D ProF1L3 I+Em TyPE";
$lang['profileitemhyperlinkssupportshttpurlsonly'] = "pR0f1L3 1T3m hYPeRl1Nk\$ \$UpPor+ ht+P UrL\$ 0NlY";
$lang['profileitemhyperlinkformatinvalid'] = "pr0PHilE iT3m hYPeRl1Nk pH0rMA+ inv4LiD";
$lang['youmustincludeprofileentryinhyperlinks'] = "j00 mUSt 1ncLuD3 <i>%s</i> IN +eh uRl oF Cl1CK48L3 hYpeRlInK\$";
$lang['failedtocreatenewprofileitem'] = "f@1LEd To cRe4+3 nEw pr0PhIl3 1T3M";
$lang['failedtoupdateprofileitem'] = "f41l3d +0 UPDa+e prOPh1LE I+Em";
$lang['startpageupdated'] = "sT@Rt p49E uPd4teD. %s";
$lang['viewupdatedstartpage'] = "v1ew UpD4T3d \$t@Rt p4Ge";
$lang['editstartpage'] = "eDI+ \$+4R+ P4gE";
$lang['nouserspecified'] = "n0 U\$3R \$P3c1FIeD.";
$lang['manageuser'] = "m4n493 uSER";
$lang['manageusers'] = "m@N4ge US3rS";
$lang['userstatusforforum'] = "u53R s+AtuS Ph0R %s";
$lang['userdetails'] = "u53r d3T4IlS";
$lang['edituserdetails'] = "eD1+ Us3R d3+@IlS";
$lang['warning_caps'] = "w@rN1N9";
$lang['userdeleteallpostswarning'] = "aRE j00 5UR3 J00 W@NT T0 DeLE+E 4Ll 0Ph TEH S3L3cT3D u\$ER'\$ PoSTS? OnC3 +3H p0\$+S 4rE D3le+3d tH3Y C4NnOT 8E R3tR13V3D 4Nd w1Ll 8E lOsT pH0R3vEr.";
$lang['postssuccessfullydeleted'] = "posTs wER3 \$uCC3\$5FUlLY D3LeTeD.";
$lang['folderaccess'] = "f0lD3R acC3s\$";
$lang['possiblealiases'] = "p0SSIBl3 4Li4\$3S";
$lang['userhistory'] = "u\$ER h15+oRy";
$lang['nohistory'] = "nO HiSToRy reCoRdS \$@veD";
$lang['userhistorychanges'] = "ch4n9E\$";
$lang['clearuserhistory'] = "cL3@R US3r h15TOry";
$lang['changedlogonfromto'] = "ch@n93D l090n phRoM %s To %s";
$lang['changednicknamefromto'] = "ch@ngEd NiCkN@M3 phr0M %s To %s";
$lang['changedemailfromto'] = "ch4n9Ed 3m41L PhR0M %s +0 %s";
$lang['successfullycleareduserhistory'] = "sucCE\$SpHUlLy cL3Ar3D US3r h1S+0RY";
$lang['failedtoclearuserhistory'] = "f41leD tO cLE4r USeR h1S+0rY";
$lang['successfullychangedpassword'] = "sUCces5PHuLlY cH4NgEd P4\$sw0RD";
$lang['failedtochangepasswd'] = "f41LEd +0 cH@N9E p@ssw0RD";
$lang['viewuserhistory'] = "vi3w u5eR H1s+0Ry";
$lang['viewuseraliases'] = "viEW US3R @lI4SEs";
$lang['searchreturnednoresults'] = "s3@RcH rEtUrn3D No R35ulTS";
$lang['deleteposts'] = "dEL3+3 pO\$+S";
$lang['deleteuser'] = "dEle+E U\$eR";
$lang['alsodeleteusercontent'] = "al50 d3L3+3 4Ll oF +h3 C0ntEn+ CreA+eD by th1S U53R";
$lang['userdeletewarning'] = "ar3 j00 \$UrE J00 wAN+ tO dEl3+3 T3H 53L3C+Ed us3R AcC0Un+? onc3 +3H 4Cc0unT H4\$ be3N D3l3+3d 1+ C@nN0T 83 rEtr13V3d 4nd w1Ll Be lOSt Ph0R3v3R.";
$lang['usersuccessfullydeleted'] = "u53r SUcCe\$5PhUlLY D3lE+ED";
$lang['failedtodeleteuser'] = "fa1L3D +o dEle+E US3r";
$lang['forgottenpassworddesc'] = "iph +H1S usEr H@S Phor9O++3n Th31R p4\$SwOrd j00 c4N r3\$e+ i+ FOR tH3m herE.";
$lang['failedtoupdateuserstatus'] = "fa1L3D T0 uPD@T3 U5eR sT4tUS";
$lang['failedtoupdateglobaluserpermissions'] = "fA1L3d +0 Upd4+3 GlOb4l USeR peRmi\$S1ON\$";
$lang['failedtoupdatefolderaccesssettings'] = "f41L3D +0 UPd4+3 Ph0lD3r 4Cc35S S3+T1nGs";
$lang['manageusersexp'] = "th1\$ L1\$+ \$h0WS 4 \$eleC+10N 0F u\$er\$ Who H4v3 Lo9GeD ON +0 y0UR foRuM, S0r+ed 8Y %s. +O @lT3r @ uSer'5 p3RMi\$S1On\$ cL1ck +h3Ir nAme.";
$lang['userfilter'] = "u\$eR PhIL+eR";
$lang['onlineusers'] = "oNL1N3 usEr\$";
$lang['offlineusers'] = "ofpHliNE US3Rs";
$lang['usersawaitingapproval'] = "u\$3r\$ 4W4i+iNG @pPrOV4l";
$lang['bannedusers'] = "b@nn3D U\$ER\$";
$lang['lastlogon'] = "l4s+ lO90n";
$lang['sessionreferer'] = "s3\$s1oN R3fEREr";
$lang['signupreferer'] = "s1GN-Up r3FeR3r:";
$lang['nouseraccountsmatchingfilter'] = "nO UsER 4CcOuntS m@TcH1nG fIlT3R";
$lang['searchforusernotinlist'] = "s3aRcH pHOr 4 uS3R NOt 1n LiS+";
$lang['adminaccesslog'] = "aDMiN aCc35S lOg";
$lang['adminlogexp'] = "th1\$ l1ST SH0wS +hE L4\$t 4C+10nS \$4Nc+10NeD BY uSeRS W1+H @dMin prIViL3gEs.";
$lang['datetime'] = "d4T3/tiM3";
$lang['unknownuser'] = "unkN0Wn u\$3R";
$lang['unknownuseraccount'] = "unKNown u\$3R AcCOunt";
$lang['unknownfolder'] = "unkNOwN PhOLDeR";
$lang['ip'] = "iP";
$lang['lastipaddress'] = "lAs+ 1p 4DdR3s5";
$lang['hostname'] = "hOs+NamE";
$lang['unknownhostname'] = "uNKNoWn h05+NAmE";
$lang['logged'] = "l0g9eD";
$lang['notlogged'] = "n0+ L09GeD";
$lang['addwordfilter'] = "add w0RD F1L+3R";
$lang['addnewwordfilter'] = "aDD n3W W0rD PhIlT3r";
$lang['wordfilterupdated'] = "w0RD f1Lt3R UpD4T3d";
$lang['wordfilterisfull'] = "j00 C4nN0+ 4dD 4Ny moR3 WOrd ph1L+eR5. R3m0V3 \$0M3 UnuSEd oN3S oR Ed1T tH3 EX1\$+1Ng 0NeS FiRst.";
$lang['filtername'] = "fIl+3r n@mE";
$lang['filtertype'] = "f1L+3r +YPe";
$lang['filterenabled'] = "fIl+3R 3N4bLeD";
$lang['editwordfilter'] = "ed1t wOrD phILt3R";
$lang['nowordfilterentriesfound'] = "nO ExI\$+1NG WORd pHil+eR 3N+rIe\$ F0UnD. +0 @DD A pHILtEr cLIck +hE '4Dd nEw' 8Ut+0n 83LoW.";
$lang['mustspecifyfiltername'] = "j00 muSt sP3Cify 4 F1L+Er n@m3";
$lang['mustspecifymatchedtext'] = "j00 MuST sP3c1Fy M4+ChEd +EXt";
$lang['mustspecifyfilteroption'] = "j00 MUs+ SPeC1FY @ fIlT3R opTIOn";
$lang['mustspecifyfilterid'] = "j00 mU\$t SpEcIfY 4 Fil+Er iD";
$lang['invalidfilterid'] = "inv@Lid fIlT3r iD";
$lang['failedtoupdatewordfilter'] = "f41L3d TO uPd4+3 WoRD pHiLt3R. cH3cK thA+ tH3 PH1lt3R S+1ll ex1StS.";
$lang['allow'] = "aLLOw";
$lang['block'] = "bloCk";
$lang['normalthreadsonly'] = "n0RM4L +hR34d5 0nlY";
$lang['pollthreadsonly'] = "p0LL ThRe4Ds OnlY";
$lang['both'] = "b0tH +hR34d TyP3S";
$lang['existingpermissions'] = "eXIStIn9 p3rMIs51Ons";
$lang['nousershavebeengrantedpermission'] = "nO 3Xi\$+1n9 Us3Rs p3Rm1s\$1oN\$ foUnd. tO 9R@N+ p3RmI\$51On tO u5Er\$ Se4RCh f0R +H3m 83LOw.";
$lang['successfullyaddedpermissionsforselectedusers'] = "sUcCe\$SPHulLY @dD3D P3RmIS51on\$ FOR \$eL3C+3D USerS";
$lang['successfullyremovedpermissionsfromselectedusers'] = "suCCeSSPhULLy r3MoVed peRMiSSi0Ns FrOm \$eleCtEd UsEr\$";
$lang['failedtoaddpermissionsforuser'] = "f4iLED T0 4dD P3rM1Ss1ON\$ f0R u\$er '%s'";
$lang['failedtoremovepermissionsfromuser'] = "f4iLeD +0 ReM0vE p3rMI\$51On\$ PHr0M u5eR '%s'";
$lang['searchforuser'] = "s34Rch F0R U5ER";
$lang['browsernegotiation'] = "bROWs3r NEG0+14+ed";
$lang['largetextfield'] = "l4rGE +EX+ Ph1ElD";
$lang['mediumtextfield'] = "mEdIuM T3xt ph1ELd";
$lang['smalltextfield'] = "sM4LL +3x+ F1ELd";
$lang['multilinetextfield'] = "muL+1-LiN3 t3X+ F13lD";
$lang['radiobuttons'] = "r@dI0 8uTtoN\$";
$lang['dropdownlist'] = "dr0P d0Wn li\$t";
$lang['clickablehyperlink'] = "cL1Ck@8lE HyP3rL1nk";
$lang['threadcount'] = "tHR34D cOUnT";
$lang['clicktoeditfolder'] = "cl1cK +0 EDi+ f0ld3r";
$lang['fieldtypeexample1'] = "t0 Cr3@T3 r@DiO 8U++0N\$ 0R 4 droP D0Wn lISt j00 neEd tO 3n+ER 3aCh 1NdIV1dU4L V@lU3 oN @ S3P4r@t3 liNE 1N +3H OPtIOnS pH13LD.";
$lang['fieldtypeexample2'] = "to Cr34+E cLiCk@8Le l1Nk\$ enT3r Th3 uRl iN +eh 0pT1ON\$ fIeLd @nD Use <i>%1\$S</i> WH3r3 tHe 3N+Ry FR0m +hE useR'5 pR0FIl3 \$H0Uld 4ppe4R. EX4mPl35: <p>mY5p@C3: <i>ht+P://wWw.mY5P4Ce.C0M/%1\$\$</i><br />x8OX l1ve: <i>htTp://pR0Ph1l3.mYG4mErCaRD.N3+/%1\$S</i>";
$lang['editedwordfilter'] = "eD1+3d W0Rd F1l+eR";
$lang['editedforumsettings'] = "ed1+Ed FOrUM s3TT1nG\$";
$lang['successfullyendedusersessionsforselectedusers'] = "sUCC3SsFullY 3ND3D S3sS1On5 For SElEC+3D uSEr\$";
$lang['failedtoendsessionforuser'] = "f41L3d to 3nD SE\$5ioN pHoR uS3R %s";
$lang['successfullyapprovedselectedusers'] = "succ3\$\$PHully Appr0V3D 5eleCT3d U53R\$";
$lang['matchedtext'] = "m4+cH3d +eXt";
$lang['replacementtext'] = "rEpl4c3M3N+ +3Xt";
$lang['preg'] = "prE9";
$lang['wholeword'] = "whoL3 wOrD";
$lang['word_filter_help_1'] = "<b>alL</b> M@Tch3\$ 4g4iN\$+ +Eh wHoL3 TEX+ s0 pH1Lt3RiNg m0M t0 mum WilL @lS0 ch4Nge M0m3Nt +0 MuM3Nt.";
$lang['word_filter_help_2'] = "<b>wH0l3 WoRd</b> M4+chE5 4G4In\$+ Whol3 w0Rds Only s0 FiLt3r1ng mOM +0 mUm W1Ll No+ CH@N9E M0m3N+ To mUmenT.";
$lang['word_filter_help_3'] = "<b>pR39</b> @LL0WS J00 +0 uSE peRL R3guL4R 3XPr3S\$1ONS To mA+Ch T3x+.";
$lang['nameanddesc'] = "n@mE @nD d3\$cRIp+1On";
$lang['movethreads'] = "mOve +hRe4D\$";
$lang['movethreadstofolder'] = "m0V3 tHr34D\$ tO Fold3R";
$lang['failedtomovethreads'] = "f@1Led +O MOv3 THr34D5 To SPec1Fied pHOlD3r";
$lang['resetuserpermissions'] = "r3Se+ uS3r PeRmI5s1ONS";
$lang['failedtoresetuserpermissions'] = "fA1L3D TO rESeT U5Er P3rm1\$\$1ONs";
$lang['allowfoldertocontain'] = "aLlOw folD3R +0 c0NTa1N";
$lang['addnewfolder'] = "adD n3W f0Ld3R";
$lang['mustenterfoldername'] = "j00 MuS+ eN+ER A PH0ld3r N4mE";
$lang['nofolderidspecified'] = "no PhOld3R Id 5pEc1PhIEd";
$lang['invalidfolderid'] = "inv4LId fOLd3R iD. ChECk +h4+ a PHOLD3r W1tH +Hi\$ ID 3xI\$+5!";
$lang['successfullyaddednewfolder'] = "sucCEsSFulLy @DDed new ph0Ld3R";
$lang['successfullyremovedselectedfolders'] = "sucCeSSphUllY rEM0V3D SEl3c+eD f0LdeR\$";
$lang['successfullyeditedfolder'] = "sUccE\$5pHuLLy eDi+eD F0Ld3R";
$lang['failedtocreatenewfolder'] = "f@1lEd +0 cR3At3 new phOLd3r";
$lang['failedtodeletefolder'] = "f@1L3D t0 d3Le+e F0Ld3R.";
$lang['failedtoupdatefolder'] = "f@1LEd to UPd@+3 pHOLd3R";
$lang['cannotdeletefolderwiththreads'] = "c@nN0+ dEl3TE Ph0lD3rS TH@t S+iLl cONt@1N +hR34d\$.";
$lang['forumisnotrestricted'] = "foRUM 1\$ N0T rE\$+rIcT3D";
$lang['groups'] = "gR0uP\$";
$lang['nousergroups'] = "n0 US3r 9roUP\$ H4Ve 83En \$eT UP. +0 ADd 4 GroUP Cl1Ck +He '4Dd n3W' 8UT+0N B3LOW.";
$lang['suppliedgidisnotausergroup'] = "sUPpLI3D 9iD 1\$ N0T 4 uSEr 9ROup";
$lang['manageusergroups'] = "m@nA93 u53R 9r0UPS";
$lang['groupstatus'] = "gROUP S+a+U\$";
$lang['addusergroup'] = "aDD uSeR GrOup";
$lang['addemptygroup'] = "add EmP+Y 9ROuP";
$lang['adduserstogroup'] = "add U\$3RS +0 9R0Up";
$lang['addremoveusers'] = "adD/rEm0ve U\$3rS";
$lang['nousersingroup'] = "tH3r3 4Re nO uS3Rs iN tHi\$ GrOUP. 4Dd U\$eRs +0 +h1S 9r0UP 8Y 5e4RcHiNG FOr +H3M BeLOW.";
$lang['groupaddedaddnewuser'] = "sUCc3\$SpHuLLy 4dD3D GRoUP. @DD uSEr\$ +0 tHi\$ Gr0UP 8y \$E4RcH1ng FoR +HeM BelOw.";
$lang['nousersingroupaddusers'] = "thERe 4Re n0 u\$3Rs 1n +hIS 9R0Up. +0 4DD USer\$ CLiCK +3h '@Dd/R3MOv3 US3R5' 8U++0n beLoW.";
$lang['useringroups'] = "tHi\$ uSEr 1S 4 MembEr Of teH Ph0LloW1ng gROuPs";
$lang['usernotinanygroups'] = "thIS U5eR 1\$ no+ 1n @nY u5Er 9Roup5";
$lang['usergroupwarning'] = "n0+3: +H1S U\$3R m@y 83 inH3R1T1N9 @DdI+1oN4L p3RMi\$510NS phR0M 4NY u\$3R Gr0UP5 L1\$T3D bELow.";
$lang['successfullyaddedgroup'] = "suCC3\$sFuLLy @DdEd gROuP";
$lang['successfullyeditedgroup'] = "sUCCe5SFuLlY 3D1tEd 9r0UP";
$lang['successfullydeletedselectedgroups'] = "suCC3SsFuLLy d3Let3D 53L3c+ed GRoUpS";
$lang['failedtodeletegroupname'] = "f4ILeD +0 D3le+e gROuP %s";
$lang['usercanaccessforumtools'] = "u\$eR c4N 4Cc3\$\$ fOruM tO0l\$ 4nD c4N cRE4+3, D3Le+e 4Nd 3D1t PhOrUMS";
$lang['usercanmodallfoldersonallforums'] = "u\$ER C4n M0DeR4+E <b>aLl Ph0lDErS</b> 0n <b>aLl Ph0RuM\$</b>";
$lang['usercanmodlinkssectiononallforums'] = "u53R c4N moD3r4+3 LiNK\$ \$eCt1oN 0n <b>aLl F0rUm\$</b>";
$lang['emailconfirmationrequired'] = "eM4IL cONfIrm4+1ON r3QuIREd";
$lang['userisbannedfromallforums'] = "u\$Er 1\$ b4NnEd FrOm <b>all PhORuMS</b>";
$lang['cancelemailconfirmation'] = "c4nCEl 3M4iL COnFIrM4+1ON 4nD 4LlOW uSEr to S+aR+ P0\$+1Ng";
$lang['resendconfirmationemail'] = "res3ND conFIrm4+i0N Em4iL To UsER";
$lang['failedtosresendemailconfirmation'] = "f4il3d To ReSEnd Em@1l CoNFirM4+1oN tO u\$3r.";
$lang['donothing'] = "dO NOtHInG";
$lang['usercanaccessadmintools'] = "usER h@S @CcES5 +0 fOrUM 4DMiN TOoLS";
$lang['usercanaccessadmintoolsonallforums'] = "u53R h4S 4Cc355 +0 4DMiN ToolS <b>oN 4lL f0RuM5</b>";
$lang['usercanmoderateallfolders'] = "u53R c4N M0d3R4+e 4lL fOld3RS";
$lang['usercanmoderatelinkssection'] = "u\$3R cAn Mod3R4+3 L1Nk\$ S3cTiOn";
$lang['userisbanned'] = "u53R iS 8@NnEd";
$lang['useriswormed'] = "u\$eR 1\$ W0Rm3D";
$lang['userispilloried'] = "u53R 1\$ p1ll0rIEd";
$lang['usercanignoreadmin'] = "u53r c4N 1Gn0RE 4dM1N1\$Tr4t0RS";
$lang['groupcanaccessadmintools'] = "gRoUP C4N @CCeS\$ AdmiN +O0Ls";
$lang['groupcanmoderateallfolders'] = "gR0UP C4N M0d3R@Te 4Ll pH0lDeRs";
$lang['groupcanmoderatelinkssection'] = "gR0up C@N m0DeR4+e l1NkS 5eCtIonS";
$lang['groupisbanned'] = "gR0UP 15 b4NnED";
$lang['groupiswormed'] = "gr0Up i\$ W0RmEd";
$lang['readposts'] = "r34D po\$+S";
$lang['replytothreads'] = "r3ply tO tHrEad\$";
$lang['createnewthreads'] = "cr34+E NEw tHrEaDS";
$lang['editposts'] = "edi+ P0Sts";
$lang['deleteposts'] = "d3leT3 p0S+s";
$lang['postssuccessfullydeleted'] = "pos+\$ SuCCE\$SfUlLy d3L3+Ed";
$lang['failedtodeleteusersposts'] = "f41L3d +0 DEl3+3 US3r'\$ POs+S";
$lang['uploadattachments'] = "upl0@d a++4CHmEn+5";
$lang['moderatefolder'] = "m0D3R@Te Ph0lD3r";
$lang['postinhtml'] = "posT 1N H+mL";
$lang['postasignature'] = "pos+ 4 \$19n4Ture";
$lang['editforumlinks'] = "eD1T F0RUm l1Nk\$";
$lang['linksaddedhereappearindropdown'] = "l1nKS 4Dd3D HER3 @Ppe4R 1N 4 dROp d0WN IN tH3 tOp r19Ht 0f tH3 FR@m3 s3+.";
$lang['linksaddedhereappearindropdownaddnew'] = "l1nKs add3D HErE 4pp3aR in 4 dROP dOwn 1N +hE TOp RigH+ oF Th3 fr4M3 \$3+. +0 aDd 4 l1Nk cL1Ck +H3 '@Dd nEw' 8UtTON 8El0w.";
$lang['failedtoremoveforumlink'] = "f41l3D tO R3M0v3 pHOrUM LinK '%s'";
$lang['failedtoaddnewforumlink'] = "f@1L3D +0 aDd N3w pH0rUM liNk '%s'";
$lang['failedtoupdateforumlink'] = "f@1lEd T0 UpD@+3 F0rum L1Nk '%s'";
$lang['notoplevellinktitlespecified'] = "n0 TOp l3VEL LInK ti+l3 Sp3c1FIEd";
$lang['youmustenteralinktitle'] = "j00 mUsT 3N+er @ LinK t1TlE";
$lang['alllinkurismuststartwithaschema'] = "aLL LiNK uR1S MuSt \$T@r+ wI+H 4 \$ChEM@ (1.3. H++p://, FTp://, 1Rc://)";
$lang['editlink'] = "eD1+ liNk";
$lang['addnewforumlink'] = "adD nEw F0RuM L1nk";
$lang['forumlinktitle'] = "fORuM LinK +1+Le";
$lang['forumlinklocation'] = "fORuM l1Nk l0C@t10N";
$lang['successfullyaddednewforumlink'] = "sucC35\$phulLy @DdEd n3W FoRUm lINk";
$lang['successfullyeditedforumlink'] = "sucCeSSpHully eDi+eD f0RuM LInK";
$lang['invalidlinkidorlinknotfound'] = "iNvaLId l1Nk Id 0r l1Nk nO+ FOuND";
$lang['successfullyremovedselectedforumlinks'] = "sUcC3SsPhulLy REm0V3d \$EL3c+Ed L1nKs";
$lang['toplinkcaption'] = "tOP l1Nk c@p+1On";
$lang['allowguestaccess'] = "alloW 9UE\$t 4CcESS";
$lang['searchenginespidering'] = "s3@RcH Eng1N3 \$PidEr1ng";
$lang['allowsearchenginespidering'] = "all0W SE4RCh 3NGInE \$PiD3rIn9";
$lang['sitemapenabled'] = "en4Bl3 51T3m@P";
$lang['sitemapupdatefrequency'] = "sITEm@p UpD4T3 fReqU3nCy";
$lang['sitemaplocation'] = "s1tEM@p l0C4+1On";
$lang['sitemappathnotwritable'] = "s1+Em4P DiR3CtoRy mU5+ Be wr1T@8L3 by +3h WeB serV3R / PhP pR0cES\$!";
$lang['newuserregistrations'] = "new U\$3R REg1\$+RAtiONs";
$lang['preventduplicateemailaddresses'] = "pR3v3N+ DupLIc4+e eM41l 4dDr355E\$";
$lang['allownewuserregistrations'] = "alloW new U\$ER ReGi\$+R4+1ONs";
$lang['requireemailconfirmation'] = "rEQUir3 3M41L cONfIrM@t1On";
$lang['usetextcaptcha'] = "u53 TeX+-C4p+cH4";
$lang['textcaptchafonterror'] = "teXT-c4P+cH@ h4S 8een D1\$@8LeD @UtOm@+1c4LlY 83C@uS3 th3R3 4RE N0 +rU3 +yP3 phoNT\$ @V4iL48lE f0r 1+ To U\$3. pl34\$3 UpLO@d S0m3 tRue TYpE FOn+\$ T0 <b>tEXT_c4PtCH4/PHon+\$</b> 0N yOUr S3rV3R.";
$lang['textcaptchadirerror'] = "teXT-CApTCh4 H4\$ BE3n d1\$4BLEd 8Ec4Us3 +eH +3X+_C@pTCh4 DiR3cTOrY 4ND 1+'\$ \$Ub-DiR3CtorIES 4R3 noT Wr1T@8Le 8Y tH3 We8 S3RveR / pHP pRoC3s\$.";
$lang['textcaptchagderror'] = "tex+-C4p+cHa H4s b33n d1\$4Bl3D 8EC@u53 y0UR SErV3R'5 pHp 53TUp D0E\$ no+ pRoVId3 suppORT FOr 9d im@9e m@n1PUl4+10n 4ND / Or ++Ph pH0NT \$UpporT. 80+h @rE R3QuiREd Phor +eXT-C4pTch@ SUppOr+.";
$lang['newuserpreferences'] = "n3W us3r pREF3reNC3S";
$lang['sendemailnotificationonreply'] = "em4il No+1F1c4+10N on r3PlY +0 u\$ER";
$lang['sendemailnotificationonpm'] = "em4IL NoT1F1c@TioN 0n Pm T0 U5Er";
$lang['showpopuponnewpm'] = "shOw P0pUP wh3N r3C3IVIn9 NEw pM";
$lang['setautomatichighinterestonpost'] = "s3+ 4UT0m4+1C H19H 1N+ErESt oN p0S+";
$lang['postingstats'] = "p0sTInG s+Ats";
$lang['postingstatsforperiod'] = "pO\$T1Ng s+4+S FOr p3Ri0D %s To %s";
$lang['nopostdatarecordedforthisperiod'] = "n0 P0S+ d4+4 R3c0rdEd PhOr +H15 PeRIoD.";
$lang['totalposts'] = "tOT@l POSt\$";
$lang['totalpostsforthisperiod'] = "t0+AL pOS+S F0R tH1s pERi0d";
$lang['mustchooseastartday'] = "mUS+ cH0OS3 4 \$+@r+ DAy";
$lang['mustchooseastartmonth'] = "muS+ ChOo\$E @ s+@r+ M0Nth";
$lang['mustchooseastartyear'] = "mus+ ChoO\$E 4 \$TArT yEaR";
$lang['mustchooseaendday'] = "mU\$+ ChO0S3 @ 3nD d@y";
$lang['mustchooseaendmonth'] = "musT ChO0S3 @ End M0Nth";
$lang['mustchooseaendyear'] = "mu\$t CH0ose @ 3Nd Y34R";
$lang['startperiodisaheadofendperiod'] = "s+4R+ P3rI0d I\$ 4hE4d 0F 3Nd p3r10D";
$lang['bancontrols'] = "b4n COntr0Ls";
$lang['addban'] = "aDD B4n";
$lang['checkban'] = "cH3ck b4N";
$lang['editban'] = "ed1+ B4n";
$lang['bantype'] = "b4N +YpE";
$lang['bandata'] = "ban DAt4";
$lang['bancomment'] = "comM3Nt";
$lang['ipban'] = "ip bAN";
$lang['logonban'] = "lo90n bAn";
$lang['nicknameban'] = "nicKn@Me 8an";
$lang['emailban'] = "eM4Il b4N";
$lang['refererban'] = "rePH3rer 8An";
$lang['invalidbanid'] = "inV4liD b@N 1D";
$lang['affectsessionwarnadd'] = "thi\$ B4N M4y 4pHFECt +He F0lLoW1N9 4c+Ive U\$Er s3SSi0N5";
$lang['noaffectsessionwarn'] = "tHis b4N 4FpH3Cts n0 @C+1Ve S3\$51OnS";
$lang['mustspecifybantype'] = "j00 muS+ \$PeC1fY A 8AN tYp3";
$lang['mustspecifybandata'] = "j00 mUST \$p3C1Fy S0m3 8An d4+4";
$lang['successfullyremovedselectedbans'] = "sucCeS\$pHully R3mOvED sEleC+3d 8@Ns";
$lang['failedtoaddnewban'] = "f41L3d +0 4Dd n3W 8@N";
$lang['failedtoremovebans'] = "f@iLED +0 ReM0v3 s0ME OR alL OF +Eh s3L3C+3D b4Ns";
$lang['duplicatebandataentered'] = "dUpliCa+E 8@N D4+A 3N+3r3D. pLe@\$E cH3cK Y0Ur wILdcArD\$ TO S33 IF TH3Y 4Lr34DY Ma+ch t3H d@t4 3N+erED";
$lang['successfullyaddedban'] = "sUCcE\$sPHuLlY aDd3D b4N";
$lang['successfullyupdatedban'] = "sucC3SsPhUlLY uPDaT3d 84n";
$lang['noexistingbandata'] = "tH3Re Is n0 EXi\$+ing 8@n d4+@. TO 4DD A 8An cL1Ck t3H '@dd NeW' 8u+tOn 8El0W.";
$lang['youcanusethepercentwildcard'] = "j00 c4N uS3 Th3 p3RC3n+ (%) WilDcaRD sYmBol 1N 4Ny 0F YOUR 84N l1\$tS +0 08+@1N P4Rti4L M@TCh3\$, I.3. '192.168.0.%' W0uLD b4N aLl 1P 4Ddre55ES 1N Th3 r@nG3 192.168.0.1 ThRoU9H 192.168.0.254";
$lang['cannotusewildcardonown'] = "j00 C@nnoT @DD % 45 4 wIldc4Rd M@TcH 0n 1+'\$ 0Wn!";
$lang['requirepostapproval'] = "reqUiRE PoSt 4PprOV@l";
$lang['adminforumtoolsusercounterror'] = "tH3Re mU5+ Be 4+ l34S+ 1 U\$3R W1+H 4DM1N TOolS 4Nd FoRUm TOoL\$ 4Cc3sS ON 4LL pHorUm5!";
$lang['postcount'] = "pOST c0unT";
$lang['resetpostcount'] = "r3s3+ poS+ coUnT";
$lang['failedtoresetuserpostcount'] = "f@1LEd +o rE\$3+ p0S+ COuN+";
$lang['failedtochangeuserpostcount'] = "f@1l3D tO chAN9E UsER PoS+ cOUn+";
$lang['postapprovalqueue'] = "poS+ @PPROv4L qu3U3";
$lang['nopostsawaitingapproval'] = "nO P0S+S @R3 4W4i+ing 4pPRov4l";
$lang['approveselected'] = "aPprOvE \$3l3CtEd";
$lang['failedtoapproveuser'] = "f@1L3d +0 4PproVe uSEr %s";
$lang['kickselected'] = "k1cK s3L3C+Ed";
$lang['visitorlog'] = "vi\$ITOR LoG";
$lang['clearvisitorlog'] = "cL34r v151Tor l09";
$lang['novisitorslogged'] = "no v1\$1TOrs lOGGEd";
$lang['addselectedusers'] = "adD S3lEc+3d US3RS";
$lang['removeselectedusers'] = "r3m0Ve \$3LEc+3D uSEr\$";
$lang['addnew'] = "aDD neW";
$lang['deleteselected'] = "dEl3T3 s3L3c+3D";
$lang['forumrulesmessage'] = "<p><b>foRUm rul3S</b></p><p>\nr3GI\$+rAtI0n +0 %1\$s I\$ fr3E! W3 D0 iNsISt tH@t J00 @8iD3 bY t3H rUL3\$ 4Nd PoL1c135 DET4iL3D 83LOw. If j00 4gReE +0 +hE +ErM\$, pLe4S3 cheCk tH3 '1 aGr3E' cHeck80X 4nD Pr3\$S the 'ReGI5+3R' bUTtON 8ElOW. iPH J00 w0UlD L1k3 +0 c4Nc3L TH3 r3Gi\$+r@tioN, cL1Ck %2\$5 +0 ReTurN +0 Th3 pHORuM\$ iNdeX.</p><p>\n4LtHOu9H +He 4Dm1N15Tr4tOR\$ 4Nd MoDeR@t0RS 0f %1\$S WiLl @TteMp+ +O K3eP @Ll 08jEctIoN4bL3 mE\$54GEs 0Ff tHi\$ PHoRuM, 1t 1\$ 1mPO\$\$18L3 PHOR U\$ +0 rev1EW @Ll M3S5AGe\$. 4LL m3s\$@935 3XPRe5s +H3 v13WS 0Ph THe 4UThoR, 4nD N31ThER THE owN3RS of %1\$\$, noR PR0JEC+ BE3h1ve F0Rum 4ND I+'S 4pHPhILi4+ES wILL 83 HELd R3SP0N\$1BL3 F0r +H3 C0N+EN+ 0F 4NY ME\$SagE.</p><p>\n8Y 49r33iN9 T0 TH3sE rULE5, J00 W@rRANT tH@T J00 W1LL N0T POST @NY M3sS49e5 +H4+ 4R3 08\$C3n3, VUl9@r, \$3xu@LLY-OR13N+A+3D, H4t3fUL, THR3A+3N1N9, 0R OTHERW1\$E v1oL4T1v3 0f 4nY L@WS.</p><p>tHe 0wNer\$ of %1\$\$ RE5ERV3 TEh Ri9h+ +0 R3MOVE, 3D1+, M0vE 0R CLosE 4Ny +HrEAD phOR @Ny RE@Son.</p>";
$lang['cancellinktext'] = "h3r3";
$lang['failedtoupdateforumsettings'] = "f41leD TO uPD4+3 FOrUM \$3++1Ng\$. PLe4sE tRY @9A1N L4+3R.";
$lang['moreadminoptions'] = "m0RE 4Dmin 0pT10N\$";

// Admin Log data (admin_viewlog.php) --------------------------------------------

$lang['changedstatusforuser'] = "cH@n93D USEr S+@+uS phoR '%s'";
$lang['changedpasswordforuser'] = "ch4nGeD P@s5WORd fOR '%s'";
$lang['changedforumaccess'] = "ch4N9Ed FOrUm @cCEss P3Rm155I0NS PHoR '%s'";
$lang['deletedallusersposts'] = "d3lE+ED 4Ll p0s+s FoR '%s'";

$lang['createdusergroup'] = "cre4T3d USeR 9rOuP '%s'";
$lang['deletedusergroup'] = "d3LEt3D UsEr 9R0Up '%s'";
$lang['updatedusergroup'] = "uPd@t3D U\$eR 9roUP '%s'";
$lang['addedusertogroup'] = "aDDEd uS3R '%s' +0 9RoUP '%s'";
$lang['removeduserfromgroup'] = "r3m0V3 UsER '%s' FrOm 9r0uP '%s'";

$lang['addedipaddresstobanlist'] = "aDD3D 1p '%s' t0 b4N L15T";
$lang['removedipaddressfrombanlist'] = "r3m0VED Ip '%s' PhROM 84n LI5+";

$lang['addedlogontobanlist'] = "aDDeD l09On '%s' +0 84n L15+";
$lang['removedlogonfrombanlist'] = "rEMOveD l090N '%s' FRoM 8@n L1\$+";

$lang['addednicknametobanlist'] = "adD3d N1CKN4me '%s' to 8@N L1\$T";
$lang['removednicknamefrombanlist'] = "rem0VeD N1CkN4mE '%s' FR0m 84N Li\$+";

$lang['addedemailtobanlist'] = "addED eMAiL 4Ddre5S '%s' +0 Ban L1S+";
$lang['removedemailfrombanlist'] = "rEMOv3D Em4Il @dDrEs5 '%s' PhroM 84N L1s+";

$lang['addedreferertobanlist'] = "aDd3d REFer3R '%s' +0 8@n lIS+";
$lang['removedrefererfrombanlist'] = "remOvED REfEr3R '%s' FrOm 8an L1S+";

$lang['editedfolder'] = "eDiTed Ph0LD3R '%s'";
$lang['movedallthreadsfromto'] = "mov3D 4Ll +hR34Ds FroM '%s' tO '%s'";
$lang['creatednewfolder'] = "cre4T3D nEw f0LdEr '%s'";
$lang['deletedfolder'] = "del3+3D f0LD3R '%s'";

$lang['changedprofilesectiontitle'] = "ch4n9Ed PrOFiL3 \$eCtIOn +1tl3 FrOM '%s' +0 '%s'";
$lang['addednewprofilesection'] = "add3D neW pR0Ph1L3 \$3CtION '%s'";
$lang['deletedprofilesection'] = "deLETeD pRof1L3 secTIOn '%s'";

$lang['addednewprofileitem'] = "aDD3D nEW Pr0Ph1LE 1t3M '%s' +0 sEcT10N '%s'";
$lang['changedprofileitem'] = "cH4nGed pR0F1LE 1+Em '%s'";
$lang['deletedprofileitem'] = "delE+3D pR0pH1l3 iT3M '%s'";

$lang['editedstartpage'] = "ed1TeD S+4R+ p4Ge";
$lang['savednewstyle'] = "s4V3D NeW \$TyL3 '%s'";

$lang['movedthread'] = "mov3D +hrE4D '%s' PHrOm '%s' +0 '%s'";
$lang['closedthread'] = "cL0S3D +HR34d '%s'";
$lang['openedthread'] = "op3n3D +Hre4D '%s'";
$lang['renamedthread'] = "r3n4MEd +HRe4D '%s' +0 '%s'";

$lang['deletedthread'] = "dEL3+3D ThR34D '%s'";
$lang['undeletedthread'] = "und3LE+ED THr34D '%s'";

$lang['lockedthreadtitlefolder'] = "l0ckEd ThR34D oP+1On\$ oN '%s'";
$lang['unlockedthreadtitlefolder'] = "uNL0CK3d ThR3@D oP+1ON\$ 0N '%s'";

$lang['deletedpostsfrominthread'] = "dEl3T3D poS+S froM '%s' IN tHR34D '%s'";
$lang['deletedattachmentfrompost'] = "d3lEt3D aT+4chMeNT '%s' frOm P0ST '%s'";

$lang['editedforumlinks'] = "edI+eD fOrum l1NK5";
$lang['editedforumlink'] = "ediT3d F0rum l1NK: '%s'";

$lang['addedforumlink'] = "adD3D f0RuM l1Nk: '%s'";
$lang['deletedforumlink'] = "d3L3+3D f0RUm l1NK: '%s'";
$lang['changedtoplinkcaption'] = "ch@Nged tOp L1Nk c@p+1On fR0M '%s' +O '%s'";

$lang['deletedpost'] = "d3L3+3d P0S+ '%s'";
$lang['editedpost'] = "edit3D pO\$T '%s'";

$lang['madethreadsticky'] = "m4D3 +hRE4d '%s' \$tIcKY";
$lang['madethreadnonsticky'] = "m4dE ThRE4d '%s' non-S+1Cky";

$lang['endedsessionforuser'] = "eND3D \$e\$S1On pH0R UsEr '%s'";

$lang['approvedpost'] = "aPPr0V3d P0\$+ '%s'";

$lang['editedwordfilter'] = "eD1t3D w0Rd f1Lt3R";

$lang['addedrssfeed'] = "addeD r\$5 fEed '%s'";
$lang['editedrssfeed'] = "eD1+Ed rSS F3Ed '%s'";
$lang['deletedrssfeed'] = "d3L3+3D rSS feEd '%s'";

$lang['updatedban'] = "uPD4+3D 84N '%s'. cH4nGeD +yP3 fRoM '%s' tO '%s', ch4N9ed D4+A pHRoM '%s' T0 '%s'.";

$lang['splitthreadatpostintonewthread'] = "spl1T +Hre4D '%s' at Po\$t %s  inT0 n3W +Hr34D '%s'";
$lang['mergedthreadintonewthread'] = "m3r9Ed +hR34D5 '%s' @nD '%s' 1N+o new ThR34D '%s'";

$lang['approveduser'] = "aPPr0VEd USeR '%s'";

$lang['forumautoupdatestats'] = "f0rum 4U+0 UpD4T3: S+a+\$ UPd@+Ed";
$lang['forumautoprunepm'] = "f0rUM 4Uto UpD4+3: Pm pHOLdERs pRUN3d";
$lang['forumautoprunesessions'] = "forUm @uTO uPD4TE: Se5510nS pRuN3D";
$lang['forumautocleanthreadunread'] = "fORuM auTo UPd4+e: +hRe4D uNr34D D4+4 CLe4N3d";
$lang['forumautocleancaptcha'] = "forUM 4UTO Upd@T3: +3x+-C@pTCh@ 1M@9e5 cL34N3d";
$lang['forumautositemapupdated'] = "f0rUM @U+0 Upd@T3: S1+Em4P uPd@t3D";

$lang['ipaddressbanhit'] = "u5eR '%s' iS B4Nn3D. iP 4ddRe\$5 '%s' m4TcH3d B4n d4T4 '%s'";
$lang['logonbanhit'] = "uSER '%s' I\$ 84Nn3D. lOg0N '%s' M4+ChED 84N d4Ta '%s'";
$lang['nicknamebanhit'] = "uSER '%s' I\$ b4NnED. N1cKn@me '%s' m4+cHed 84N D4+4 '%s'";
$lang['emailbanhit'] = "uSER '%s' I\$ b4NNeD. EmAiL 4dDr3S\$ '%s' M@+cHed BaN d4+@ '%s'";
$lang['refererbanhit'] = "u5eR '%s' is B4Nn3D. H+tP r3pH3r3R '%s' M4+CHeD 8@N d4+4 '%s'";

$lang['userpermenabled'] = "ch4n93D pERm\$ FOr u5ER '%s'. 3N4bLEd: %s";
$lang['userpermdisabled'] = "cHAngeD P3RmS PhOR Us3r '%s'. Di\$48L3d: %s";

$lang['userpermbanned'] = "b4nN3D";
$lang['userpermwormed'] = "wOrMeD";
$lang['userpermfoldermoderate'] = "f0LD3r MODeR@t0R";
$lang['userpermadmintools'] = "adMIn +0Ols";
$lang['userpermforumtools'] = "forUm t00LS";
$lang['userpermlinksmod'] = "l1nK5 Mod3r@+0R";
$lang['userpermignoreadmin'] = "igN0r3 4DmIN";
$lang['userpermpilloried'] = "p1lLoR1Ed";

$lang['adminlogempty'] = "aDmIn l0G is 3MPTY";

$lang['youmustspecifyanactiontypetoremove'] = "j00 mUSt spEc1Fy 4N @CTIon TYp3 To R3M0ve";

$lang['alllogentries'] = "aLL L09 eN+RIeS";
$lang['userstatuschanges'] = "u\$eR S+@tu5 cH@NG35";
$lang['forumaccesschanges'] = "fOruM 4cCES\$ Ch4N9e\$";
$lang['usermasspostdeletion'] = "u\$eR m@s5 PO\$T DeLET1on";
$lang['ipaddressbanadditions'] = "iP 4DdReSS 84n 4dd1+1ON\$";
$lang['ipaddressbandeletions'] = "iP 4DdRe\$5 84n D3l3+ioNS";
$lang['threadtitleedits'] = "tHRe@d ti+L3 3D1tS";
$lang['massthreadmoves'] = "m455 +hR34d mOv35";
$lang['foldercreations'] = "foLD3r CRea+ION5";
$lang['folderdeletions'] = "foLD3r D3LE+i0N5";
$lang['profilesectionchanges'] = "pr0fIL3 \$EcTIoN CH4n93S";
$lang['profilesectionadditions'] = "pR0f1l3 \$ECti0N AdDi+I0Ns";
$lang['profilesectiondeletions'] = "pR0pH1LE \$3c+10n DELeTI0NS";
$lang['profileitemchanges'] = "propHIlE 1+3m ch4NGE\$";
$lang['profileitemadditions'] = "pR0F1L3 I+3M 4dD1+ion\$";
$lang['profileitemdeletions'] = "pR0ph1L3 I+em d3LE+10ns";
$lang['startpagechanges'] = "s+4rt P49E cH4NgE\$";
$lang['forumstylecreations'] = "fORUm \$+yLe CrE4+10NS";
$lang['threadmoves'] = "tHR34D mOV3s";
$lang['threadclosures'] = "tHre4D ClO\$uR3S";
$lang['threadopenings'] = "thRE4D 0PeNinG\$";
$lang['threadrenames'] = "tHRE4d REn@m3S";
$lang['postdeletions'] = "p0s+ DeL3+1oNs";
$lang['postedits'] = "post ED1tS";
$lang['wordfilteredits'] = "w0RD FiLt3R EDItS";
$lang['threadstickycreations'] = "tHRe@d St1CkY CrE4+10nS";
$lang['threadstickydeletions'] = "tHR3@d s+iCkY D3l3+I0ns";
$lang['usersessiondeletions'] = "uS3r sESS1oN D3l3+1On\$";
$lang['forumsettingsedits'] = "f0RuM 5EtTIn9\$ Ed1tS";
$lang['threadlocks'] = "thR34D lOcKS";
$lang['threadunlocks'] = "tHREAd UnL0Ck\$";
$lang['usermasspostdeletionsinathread'] = "uS3r masS p0S+ d3l3+i0N5 In 4 ThRE4D";
$lang['threaddeletions'] = "tHr3Ad Del3+1On\$";
$lang['attachmentdeletions'] = "atT@ChM3Nt DeLe+I0n\$";
$lang['forumlinkedits'] = "fOrUM l1nk EDi+S";
$lang['postapprovals'] = "posT @pProV4lS";
$lang['usergroupcreations'] = "us3R 9RoUp CRe4+1ONs";
$lang['usergroupdeletions'] = "u5Er 9ROuP DeleTiON\$";
$lang['usergroupuseraddition'] = "us3r 9ROuP USEr aDd1+i0N";
$lang['usergroupuserremoval'] = "u\$3R gROUp uS3R rem0V@L";
$lang['userpasswordchange'] = "usER p4S\$wORD ch4NgE";
$lang['usergroupchanges'] = "uS3R 9rOuP CH4N9eS";
$lang['ipaddressbanadditions'] = "iP 4dDre\$\$ B4N 4Ddi+IOnS";
$lang['ipaddressbandeletions'] = "iP 4DDrE55 B4N dELE+10NS";
$lang['logonbanadditions'] = "l09oN 8AN 4DDi+1ONS";
$lang['logonbandeletions'] = "l0gON 84n d3L3+I0ns";
$lang['nicknamebanadditions'] = "n1cKn4M3 8@n @Dd1+1ONs";
$lang['nicknamebanadditions'] = "n1CKNamE b4N @dDIti0NS";
$lang['e-mailbanadditions'] = "e-m4Il ban 4DdI+i0Ns";
$lang['e-mailbandeletions'] = "e-m41L b4N DeL3+1ONs";
$lang['rssfeedadditions'] = "r\$S fE3D 4DdI+ioNS";
$lang['rssfeedchanges'] = "rs\$ pH3ED cHang3S";
$lang['threadundeletions'] = "thR34D unD3L3+10N\$";
$lang['httprefererbanadditions'] = "ht+p R3FeR3R 84n 4dD1tION\$";
$lang['httprefererbandeletions'] = "h+tp R3Fer3R 84N D3lEtION\$";
$lang['rssfeeddeletions'] = "rS5 Fe3D Del3+I0n\$";
$lang['banchanges'] = "b4n cH4NgE\$";
$lang['threadsplits'] = "thR34D sPl1Ts";
$lang['threadmerges'] = "thrE4D M3RgE\$";
$lang['userapprovals'] = "uSEr @PprOv@lS";
$lang['forumlinkadditions'] = "fORUm lInK 4DD1+10n\$";
$lang['forumlinkdeletions'] = "forUm lInK D3letI0nS";
$lang['forumlinktopcaptionchanges'] = "f0RUM LiNk tOp C@p+1On Ch4N9es";
$lang['folderedits'] = "f0LDeR edI+\$";
$lang['userdeletions'] = "u5eR d3L3+1ONs";
$lang['userdatadeletions'] = "useR d4T4 D3l3TI0nS";
$lang['forumstatsautoupdates'] = "foruM s+@Ts 4U+0 UPd4+E5";
$lang['forumautopmpruning'] = "f0rUM @u+0 pm pRUn1Ng";
$lang['forumautosessionpruning'] = "forUm @uTO Se\$S1ON PrUn1NG";
$lang['forumautothreadunreaddataupdates'] = "f0rUm @UTO ThRe@D UnRE4D d4+@ uPD@TeS";
$lang['forumautotextcaptchacleanups'] = "forUM @uTo T3X+ C@P+ChA clEaN-up5";
$lang['forumautositemapupdates'] = "f0ruM 4u+O S1TEm@P UPd4T3S";
$lang['usergroupchanges'] = "u5eR GroUp cH@n9ES";
$lang['ipaddressbancheckresults'] = "ip @DdRe\$5 B4n Ch3Ck rESul+S";
$lang['logonbancheckresults'] = "l090N BaN cH3cK re\$UlTs";
$lang['nicknamebancheckresults'] = "niCKn4ME B4n cHeCK rE\$ULtS";
$lang['emailbancheckresults'] = "em@Il b4N ch3CK r3\$uLTS";
$lang['httprefererbancheckresults'] = "hT+P R3feReR BaN Ch3cK ReSultS";

$lang['removeentriesrelatingtoaction'] = "rEM0Ve 3n+RiE\$ R3L4+1Ng tO 4cTiOn";
$lang['removeentriesolderthandays'] = "r3m0v3 3N+RiEs oLd3R tHan (D4y\$)";

$lang['successfullyprunedadminlog'] = "sUCC3\$sFuLly Prun3D @DMin log";
$lang['failedtopruneadminlog'] = "f@1L3D To Prun3 4dM1n l09";

$lang['prune_log'] = "pRUN3 lOG";

// Admin Forms (admin_forums.php) ------------------------------------------------

$lang['noexistingforums'] = "n0 3XIs+1n9 ph0RuM5 F0unD. T0 cR3@+E 4 nEw PH0RUm cLiCk T3h '4Dd n3W' 8ut+0n bELoW.";
$lang['webtaginvalidchars'] = "w38+4G CaN 0Nly cON+41N UPpeRcA\$3 4-Z, 0-9 @nD uNDeR\$C0R3 cH@R4c+3rS";
$lang['databasenameinvalidchars'] = "d4tab4S3 n@M3 cAn 0Nly CoNtAiN 4-z, a-Z, 0-9 @nD unD3r\$cOR3 cH4R@Ct3Rs";
$lang['invalidforumidorforumnotfound'] = "iNv4LId PhoRuM F1d Or f0RUm nOT PH0UnD";
$lang['successfullyupdatedforum'] = "sUCCesSphULlY uPD@+3D FORum";
$lang['failedtoupdateforum'] = "fA1l3D to UPd4+E pHoRUm: '%s'";
$lang['successfullycreatednewforum'] = "sUcC3SSfULlY cRe@Ted n3W FORuM";
$lang['selectedwebtagisalreadyinuse'] = "thE SeLEC+3D w38+4G 1s 4LrEAdY IN USe. PL34se cH0oSE 4n0Th3R.";
$lang['selecteddatabasecontainsconflictingtables'] = "tEH Sel3C+Ed d4+4B45E CoN+@1n\$ cOnPhl1Ct1nG +@8Le\$. C0nPhL1c+InG T@8L3 N4mE\$ 4R3:";
$lang['forumdeleteconfirmation'] = "arE J00 sUrE J00 W4n+ TO d3L3t3 @Ll OpH +h3 \$3L3C+ED PhOrumS?";
$lang['forumdeletewarning'] = "pl3a\$3 n0T3 Th4+ J00 c@Nn0t recovER D3Le+eD f0RuMs. ONc3 D3l3T3D @ fOrUM aND @ll oF i+'s 4S\$oCi4T3D D4+@ I\$ P3Rm@neNTLy REmOVeD pHRom Th3 dAT48@s3. 1pH j00 d0 no+ W1\$h +0 d3LE+e tHE s3l3CT3d pHoruM\$ Pl34Se CLiCk c4ncEl.";
$lang['successfullyremovedselectedforums'] = "sucC3SsphUlLY D3Le+3D seL3c+3D pHorUm5";
$lang['failedtodeleteforum'] = "f4ILeD tO d3Le+3D phOrUm: '%s'";
$lang['addforum'] = "adD fORUm";
$lang['editforum'] = "edi+ ForUm";
$lang['visitforum'] = "vI5It PHoRUm: %s";
$lang['accesslevel'] = "acCE\$s l3V3L";
$lang['forumleader'] = "fOruM l34D3r";
$lang['usedatabase'] = "u53 d@tAb453";
$lang['unknownmessagecount'] = "unKN0wn";
$lang['forumwebtag'] = "fOrum wEb+49";
$lang['defaultforum'] = "d3f4UL+ F0RUm";
$lang['forumdatabasewarning'] = "pL3@Se 3N5uR3 j00 \$eLEc+ +He COrr3c+ d4+4845e WhEn cR34+1Ng @ n3W f0RuM. OnCe CrEaT3D 4 nEw PhOrUM C4NnoT 8E moV3D BEtWEeN @vaiL@8L3 d4+484SE5.";

// Admin Global User Permissions

$lang['globaluserpermissions'] = "gl08@L U\$eR P3RMi\$\$1ONs";

// Admin Forum Settings (admin_forum_settings.php) -------------------------------

$lang['mustsupplyforumwebtag'] = "j00 Mu\$t SUpPLY @ PhOrUm W3b+49";
$lang['mustsupplyforumname'] = "j00 muST 5uPply 4 ph0RUM N4Me";
$lang['mustsupplyforumemail'] = "j00 Mu\$T SuPpLY 4 ph0RUm 3M41l 4DDReSs";
$lang['mustchoosedefaultstyle'] = "j00 MUsT cH00\$e 4 dEF4Ul+ fOrUM \$+yL3";
$lang['mustchoosedefaultemoticons'] = "j00 mU\$+ CH0O\$E D3F4Ul+ F0ruM 3M0TIcONS";
$lang['mustsupplyforumaccesslevel'] = "j00 MuS+ 5UpPlY 4 PhoRUM 4cC3\$S l3VeL";
$lang['mustsupplyforumdatabasename'] = "j00 mUST 5UpPlY 4 F0RUm d4+4b4SE N@m3";
$lang['unknownemoticonsname'] = "uNkn0wN EM0tIc0Ns n4Me";
$lang['mustchoosedefaultlang'] = "j00 Mu\$+ CH0oSE @ DEfAUl+ F0rUm l4N9U4ge";
$lang['activesessiongreaterthansession'] = "ac+1V3 S3\$\$1oN +1Me0U+ C4nn0t be 9R3aT3R tH@N S3sS1on +1m30U+";
$lang['attachmentdirnotwritable'] = "att4CHM3n+ d1R3Ct0ry 4Nd Sy5+3m T3mPOr@ry dIR3cT0Ry / phP.1nI 'upLo4D_TMp_d1R' MU\$t bE wR1T48lE 8y +3H WE8 \$3RVeR / phP pR0c3SS!";
$lang['attachmentdirblank'] = "j00 Mu\$t SuPpLY 4 dir3Ct0Ry TO S4vE 4++aChmeN+\$ In";
$lang['mainsettings'] = "m@1N s3TTiN9\$";
$lang['forumname'] = "f0RUm n4me";
$lang['forumemail'] = "f0RUm eM41l";
$lang['forumnoreplyemail'] = "no-RePlY EM4iL";
$lang['forumdesc'] = "foRUm D3ScR1p+10N";
$lang['forumkeywords'] = "f0rUm k3YWoRDs";
$lang['defaultstyle'] = "dEF@UlT S+yLe";
$lang['defaultemoticons'] = "dEF4Ul+ eM0t1ConS";
$lang['defaultlanguage'] = "dEPH@Ult l4nGuAgE";
$lang['forumaccesssettings'] = "fORuM 4Cc3\$\$ se++INg\$";
$lang['forumaccessstatus'] = "foRUm 4CC3s\$ \$T4+US";
$lang['changepermissions'] = "ch@Nge pErm1\$S1OnS";
$lang['changepassword'] = "cH4NG3 P@Ssw0rD";
$lang['passwordprotected'] = "p4sSW0rD pR0t3Ct3D";
$lang['passwordprotectwarning'] = "j00 h@VE NOt se+ @ PHoRuM p@sSw0RD. 1F J00 dO noT sE+ @ P4s\$w0RD +HE pA\$\$woRd pR0+eCtIoN pHUnc+1ON4l1+y w1ll 8e 4UtomA+Ic4LLY D1\$48l3D!";
$lang['postoptions'] = "p0S+ oPt10Ns";
$lang['allowpostoptions'] = "allOW p0S+ eDI+1Ng";
$lang['postedittimeout'] = "pOSt 3Di+ +Im3OU+";
$lang['posteditgraceperiod'] = "p0\$+ Ed1t 9r@C3 p3r10D";
$lang['wikiintegration'] = "w1k1W1k1 iN+egR@+10N";
$lang['enablewikiintegration'] = "en@bL3 wIkIw1kI inT3gRA+I0N";
$lang['enablewikiquicklinks'] = "en48Le W1k1W1Ki QU1CK l1Nk\$";
$lang['wikiintegrationuri'] = "wik1WIKi l0C4+1On";
$lang['maximumpostlength'] = "m@X1MuM P0S+ Len9TH";
$lang['postfrequency'] = "p0St pHR3qU3NcY";
$lang['enablelinkssection'] = "eN@8Le L1Nk\$ \$3C+10N";
$lang['allowcreationofpolls'] = "allOw CrE@+10N 0F p0Ll5";
$lang['allowguestvotesinpolls'] = "aLL0W gue5tS tO Vo+e IN P0LlS";
$lang['unreadmessagescutoff'] = "unr34D mE\$54geS CuT-0PHph";
$lang['disableunreadmessages'] = "dis@8l3 uNr34D m35S493S";
$lang['thirtynumberdays'] = "30 D4yS";
$lang['sixtynumberdays'] = "60 D4Y\$";
$lang['ninetynumberdays'] = "90 D4Y5";
$lang['hundredeightynumberdays'] = "180 D@yS";
$lang['onenumberyear'] = "1 ye4r";
$lang['unreadcutoffchangewarning'] = "dEpENd1n9 0N 53RVeR PerF0rm4NCe @nD +3H Num8ER 0PH tHR34D\$ yOUR f0rUM\$ COnt4IN, CHaNgiN9 +He UNrE4D Cu+-0FF m4Y t@K3 \$3V3R4l MInU+3\$ +0 C0mPl3+3. pH0R +H1\$ r3aSON 1+ i5 R3COmMENdED +h4T j00 @vOId CHang1N9 +h1\$ \$3++1N9 wHIl3 Y0UR F0RUmS 4RE 8u\$Y.";
$lang['unreadcutoffincreasewarning'] = "iNCr3A\$1n9 thE UnrE4D CUt-oPhph wilL R3\$uLT 1N +hRE4Ds OLdER tH4N t3h CUrrEn+ Cu+-OFf @pPE4R1Ng @\$ UNRe4D FOr @Ll u\$3RS.";
$lang['confirmunreadcutoff'] = "ar3 J00 \$uRe J00 W4n+ +O cH4n93 +HE unRe4D cUT-Off?";
$lang['otherchangeswillstillbeapplied'] = "cl1CkIng 'n0' wiLL oNly CanC3L +3h uNRE4d cU+-0PhPh Ch4N9e5. OTh3R Ch@Ng3\$ Y0u'v3 m4De w1LL \$+1LL 8E \$@v3d.";
$lang['searchoptions'] = "sE@rCh OPti0Ns";
$lang['searchfrequency'] = "sE4RCh fR3qUENcy";
$lang['sessions'] = "sEsS1ON5";
$lang['sessioncutoffseconds'] = "sESS10N CUt OpHf (s3C0nD\$)";
$lang['activesessioncutoffseconds'] = "acT1VE Se\$SI0n cU+ oFf (5EcOnDS)";
$lang['stats'] = "s+4+s";
$lang['hide_stats'] = "hiD3 st4+\$";
$lang['show_stats'] = "sHoW St@T\$";
$lang['enablestatsdisplay'] = "en4bLe \$t@+s DispL4Y";
$lang['personalmessages'] = "perSON@l mESS49ES";
$lang['enablepersonalmessages'] = "eN48Le p3RS0N4l Me\$S4gES";
$lang['pmusermessages'] = "pM mE5\$493s pEr uSer";
$lang['allowpmstohaveattachments'] = "alL0W p3RSOn@l mEssa9ES to H@VE @t+4chm3NT\$";
$lang['autopruneuserspmfoldersevery'] = "aUtO PrUN3 UsEr'S PM pH0LdErS 3v3RY";
$lang['userandguestoptions'] = "u53r 4nd 9u3\$t 0P+1OnS";
$lang['enableguestaccount'] = "en@8Le Gu3\$+ 4CcOuNT";
$lang['listguestsinvisitorlog'] = "lisT GUe\$+S In Vi\$I+0R lO9";
$lang['allowguestaccess'] = "allOW 9U3\$T acC3\$s";
$lang['userandguestaccesssettings'] = "u\$3r 4nD GU3\$t @CCeSs \$e++INg\$";
$lang['allowuserstochangeusername'] = "all0W uSErS +0 cH4N9e U53Rn@M3";
$lang['requireuserapproval'] = "reqU1rE U53R 4PpR0V@L 8Y ADm1N";
$lang['requireforumrulesagreement'] = "reqUiRE u\$3r +0 @gr3e t0 pH0rum ruLE5";
$lang['sendnewuseremailnotifications'] = "s3ND n0T1pH1c4+1on t0 9L08Al F0rUm owNer";
$lang['enableattachments'] = "eN48L3 @tt@ChM3NtS";
$lang['attachmentdir'] = "a++4ChmENt d1R";
$lang['userattachmentspace'] = "at+ACHm3N+ SP@C3 p3R US3r";
$lang['allowembeddingofattachments'] = "allOw 3MbeDD1n9 0f @TTacHMeN+s";
$lang['usealtattachmentmethod'] = "u\$E @L+3rN4TIv3 4++4ChMen+ MeThOd";
$lang['allowgueststoaccessattachments'] = "aLL0W gu35+s +0 4CcEs5 4++@CHMeN+S";
$lang['forumsettingsupdated'] = "f0rUM S3++1Ngs \$uccE55FuLly UpD@t3D";
$lang['forumstatusmessages'] = "f0rUM sT@tUs MeSS4GEs";
$lang['forumclosedmessage'] = "f0RUM ClOS3D ME\$S49E";
$lang['forumrestrictedmessage'] = "forUM Re5+r1C+3d ME5549E";
$lang['forumpasswordprotectedmessage'] = "forUM P@S5W0rd pRO+3CT3d mEss49E";

// Admin Forum Settings Help Text (admin_forum_settings.php) ------------------------------

$lang['forum_settings_help_10'] = "<b>pOSt Ed1t +iM30U+</b> I\$ +Eh tIM3 In M1nUt3\$ 4phT3R POS+1Ng +h4+ 4 US3r c4N Edi+ tH31R pO5t. 1PH S3+ To 0 +HEr3 1\$ NO LImI+.";
$lang['forum_settings_help_11'] = "<b>m4XiMuM pOs+ LEng+h</b> 1S +HE M4XiMUm NUM8ER 0Ph CH4r4Ct3Rs +h4+ wIll 8E D1\$Pl@y3D 1n @ p0s+. iF @ pos+ 1S LoNger +haN TH3 NUmbeR Of Ch4R@C+3RS dEfinEd HeR3 1+ wiLl 8E cu+ sHoR+ 4Nd @ lInK AdDeD +0 +3H 80++0m +0 ALl0W U\$3Rs to rE4d Th3 wH0lE p0St 0N 4 S3p4Rate P4G3.";
$lang['forum_settings_help_12'] = "iF J00 D0n'+ W4nT yOur US3rs to 8E 4BlE +o cR3aT3 poLls j00 c@n d1\$4bLE Th3 @80V3 opT1oN.";
$lang['forum_settings_help_13'] = "the L1nKS s3Ct10N 0Ph b3Eh1V3 pR0ViD3\$ A pL@ce PhOr y0Ur u53Rs +0 M4iN+4in a l1S+ 0f 51tES +HeY PHreQu3ntLy V1\$1T +h4+ O+heR U\$ERs M4Y Ph1nd us3Ful. l1NK\$ c@N 8E DIvIdEd 1N+0 c4+3goRi3\$ By pHOlD3r aNd @LlOW phOr cOMmEnTs 4Nd r@+1Ng\$ +0 8e gIv3N. iN 0rDeR +o moDer@T3 t3H l1NK\$ \$3C+10N 4 Us3R MUS+ bE R4nTeD 9lO8@l MoD3R@+0r \$+AtUs.";
$lang['forum_settings_help_15'] = "<b>ses51ON CuT OPhph</b> IS +he M@xIMuM T1Me 8EPh0Re 4 user'S 5ESs1oN 1\$ dEeMed dE4d @nd +H3y 4Re L0Gg3d 0U+. 8Y d3F4UlT Th1\$ iS 24 h0Urs (86400 s3CONd5).";
$lang['forum_settings_help_16'] = "<b>aC+IVE s35SIOn Cut 0Phf</b> I\$ the M4XIMum t1M3 bEF0Re 4 uSEr'S 5ESs1oN 1\$ D33M3D iN4CT1Ve @t WhiCH PoInT +hEY 3N+Er An 1DL3 St4+3. 1n TH1S \$+4Te Th3 USEr REm41NS loGGeD IN, BUt ThEY 4r3 r3M0V3D PhROM t3H @C+1VE useRS lisT IN THe S+4+S DI\$PLAy. 0nCE Th3y 8EcoM3 @CtIV3 4g41N +hEy WiLL 8e R3-@dDED TO T3H l1\$t. 8Y D3FAUl+ +H1s \$3++1N9 1S \$Et +O 15 MiNuTE\$ (900 S3COnDS).";
$lang['forum_settings_help_17'] = "eN@8LIn9 +h15 0p+10N 4ll0WS BEeHivE tO 1nCLUd3 4 \$+4+s DI\$PL4y 4+ THe 8O+t0M oF +3H Me\$\$@9E\$ PanE s1MIlaR +0 tH3 One usEd 8Y m@NY FORuM SofTw4r3 +1+l3s. OnC3 EN4BlED +EH Di\$pLaY 0PH T3h S+4+5 pAge c4N BE tOGgL3D iNDiV1Du4LLy 8Y 34ch Us3r. If THeY dON'+ w4N+ TO s3E I+ +hEY C@N h1d3 1+ fR0M VIEw.";
$lang['forum_settings_help_18'] = "peR50N4L Me\$\$@9e\$ 4RE inV4Lu4BLe @S 4 W4y 0PH t@KIn9 MOr3 pR1V@t3 MA+t3RS 0U+ oF v1ew 0ph Th3 OTh3R m3MBeRS. hoW3V3R 1PH J00 D0N'T w4N+ Y0UR USEr\$ To 83 @8Le TO SEnD e4cH OtHeR p3r\$0n4L m3sSA93S j00 C4N DIs@8L3 +hI\$ Op+10N.";
$lang['forum_settings_help_19'] = "p3r\$on4L mE5\$@9E\$ c4N 4LsO COn+Ain 4T+4CHm3NT\$ WhIch C4n 83 us3FuL f0r excH4NgiNG FIL3\$ 83+w3En UserS.";
$lang['forum_settings_help_20'] = "<b>nOtE:</b> +H3 \$p@cE @LLoc@+10N F0R pM AtT4ChMEn+5 iS +@keN fROm 34Ch U\$eR\$' m4IN @Tt4CHm3N+ @lL0c@+10N 4nD i\$ No+ iN @DDIt1oN tO.";
$lang['forum_settings_help_21'] = "<b>eN48l3 GUesT @CcoUNt</b> 4lloWS VIsiTOrs +O BR0Ws3 Y0Ur FoRUm @Nd R34D p0STS WiTHOut rEgI\$t3R1Ng @ uSEr 4CC0UN+. 4 USer acC0UnT 1S 5+1lL R3Qu1R3D iF ThEy W1\$H +0 P0S+ 0R cH@nG3 U53R pR3FEr3NceS.";
$lang['forum_settings_help_22'] = "<b>l1St GUEsTS In V1sITor LO9</b> @LLOW\$ J00 TO SpeC1phy WH3+hER 0R N0t uNrEGI\$+3R3D u\$Ers @Re L1\$T3D On T3h v1\$1tOR LOG @Lon9 SIDe R3G1S+3R3D US3R\$.";
$lang['forum_settings_help_23'] = "b33h1v3 4LloWs 4Tt4chMEnTS +0 8E UpL04D3D TO m3\$S4GeS wHEn P0S+3D. 1Ph J00 H@v3 L1mIT3D w3B \$P@c3 J00 m@Y WHicH tO d1s48L3 4TTaCHmENtS by Cl3AR1NG TEh 80x 480V3.";
$lang['forum_settings_help_24'] = "<b>att4CHM3n+ D1R</b> is tH3 l0C@tION 83EHiVE \$h0ULd S+0R3 iT'S @++4CHmEN+\$ iN. +H1\$ d1REc+OrY mU\$T 3Xi\$T 0n Y0UR W3B sP4Ce @nD mUsT 8e Wr1T4bl3 bY T3H w3B SeRVeR / pHP PROcES5 O+HeRWI\$e UPlOAD\$ WilL F41L.";
$lang['forum_settings_help_25'] = "<b>a++4CHmEN+ 5PaC3 Per us3R</b> I\$ +HE M4x1MUM Am0UN+ OF dISk Sp@C3 @ U\$eR H@s F0R @TT@Chm3NT\$. 0Nc3 Th1\$ 5P4Ce 1s u5ED UP tH3 UseR C@nNO+ uPLo4d @NY m0RE 4Tt4CHmEN+s. 8y DePHaul+ Th1\$ 1S 1M8 0pH Sp4CE.";
$lang['forum_settings_help_26'] = "<b>allOW 3m83DD1N9 OpH 4++4Chm3n+\$ iN m3554GE5 / \$IGn4TUr35</b> 4LLoWS U\$3RS TO 3M8ED @T+4chmENts IN p0sTS. 3N4BL1N9 +h1\$ 0p+10N wH1L3 US3PHuL c4N INcre@\$E Y0UR 8ANDw1DTH U\$aGE dR4\$t1C@Lly undER cER+@1N C0NfI9UR4+10nS 0Ph PhP. IF J00 H4V3 l1MI+ED 84NDw1DTH 1+ IS r3COMmEnDED TH4+ j00 DI\$A8le +h1S 0PTiOn.";
$lang['forum_settings_help_27'] = "<b>u\$e 4l+ErN@T1ve 4++@ChmENt mE+h0D</b> pHOrceS beEH1V3 +0 USE 4N 4LTErN@T1VE rE+rIeV4L Me+H0D pHOr @tT4ChmENts. 1PH j00 RecEiVE 404 eRR0R mE\$\$@gES whEn TrYIng +O DOWnL0AD @tTAChM3NT5 fROm M3\$\$4G3\$ +RY 3n@8LIN9 +His 0PT10N.";
$lang['forum_settings_help_28'] = "thes3 SE+t1NGS @Ll0W\$ YoUR fORUM +0 B3 Sp1dER3D 8y S34RCH 3nG1N3\$ Like GOOGL3, @lT4V15T4 4ND YaH0o. 1pH J00 Sw1tCH +H1S 0Pt10N 0FF yOuR forUM WILl No+ BE iNclUdED 1N tH3S3 SE4RCh 3N9INE\$ rESUL+S.";
$lang['forum_settings_help_29'] = "<b>aLlOw N3w Us3r r39i\$+r4T1ONs</b> ALL0w\$ 0R d1\$@LL0W\$ ThE CR34+i0N 0Ph N3W us3r 4CcoUNts. Se+T1Ng ThE Opt1ON +0 N0 coMPlE+3Ly D1S@8LES +H3 R3915+R4+1ON F0rm.";
$lang['forum_settings_help_30'] = "<b>en@8LE wIKiwIkI 1NT3Gr@+IoN</b> PR0VIdE\$ W1KIwoRD sUpPORt In YoUR pHORum PosTs. @ WIkIWoRD 1s m4D3 uP Of Tw0 OR M0R3 c0NC@tEN4+ed W0Rds W1+h UpPErcAs3 LeTt3rS (0PHtEN REfErr3d tO @\$ C@M3LC@\$E). if J00 wRit3 4 W0rd ThI\$ w4Y iT W1Ll @UToM@+1C@llY BE CHanGeD iNTO 4 HyPeRL1NK pO1Nt1Ng TO YOUr ChoS3N wIK1W1K1.";
$lang['forum_settings_help_31'] = "<b>en@8lE W1KIw1K1 QUICk lINk\$</b> eN48LEs THe U\$e OF mS9:1.1 @ND U\$3R:LO90N S+YLE 3x+EnD3D w1KIl1NK\$ WhICh cr34T3 HyPErL1Nks +0 T3H Sp3C1F13D m35\$@93 / U\$3R pROPhIl3 OF t3H Spec1F13D UsER.";
$lang['forum_settings_help_32'] = "<b>wIK1wIKI l0C@+10N</b> 1S U5ED +0 Sp3c1Fy TEH Ur1 oF y0UR Wik1WIKi. Wh3N 3NT3RiNG t3H uR1 US3 <i>%1\$S</i> tO 1Nd1c@TE wHErE iN teH uri tH3 wIKiWORd SH0ULd 4PPe@r, 1.E.: <i>h++p://EN.WIkiP3D14.0r9/WiK1/%1\$5</i> WOUld l1Nk yoUr wIK1W0rDs tO %s";
$lang['forum_settings_help_33'] = "<b>f0rUM 4Cc355 5T4+u\$</b> cOn+ROlS h0w USErs m4Y 4Cc3\$5 YOuR FoRUm.";
$lang['forum_settings_help_34'] = "<b>oP3n</b> wIll 4Ll0W @LL u\$eRS 4nD guE\$T5 4CC3sS T0 y0UR PhoRUM W1Th0Ut R3s+RiCTiON.";
$lang['forum_settings_help_35'] = "<b>cL0\$3D</b> Pr3vEn+5 ACce\$\$ pHOr 4Ll UsERs, Wi+h t3H 3xceP+1ON 0f t3H @Dm1n Wh0 m@y ST1Ll @CCesS t3H 4DmIn P4NeL.";
$lang['forum_settings_help_36'] = "<b>rE\$TRiCT3D</b> AlL0WS +0 5e+ 4 L1S+ 0PH u\$3RS wHO @r3 aLL0WEd @cCE55 +0 yOUR f0ruM.";
$lang['forum_settings_help_37'] = "<b>p4ssWORd Pr0TEc+3D</b> @LL0wS j00 +0 Set 4 Pas5WORd +0 91Ve OUt +O uS3RS \$O +heY C4N 4Cc3\$5 Y0UR FOrUm.";
$lang['forum_settings_help_38'] = "wheN \$3T+InG r3\$TR1C+3D 0R p@ssw0RD pr0+eCTEd M0D3 j00 W1Ll NeED tO 5ave Y0Ur CH@N9E\$ bEF0Re J00 c@N cH4N9E tEH USEr 4Cce\$S Pr1ViLEGe\$ 0R p@SSwoRD.";
$lang['forum_settings_help_39'] = "<b>Search Frequency</b> defines how long a user must wait before performing another search. Searches place a high demand on the database so it is recommended that you set this to at least 30 seconds to prevent \"search spamming\"fROM kIlL1N9 +Eh S3rv3R.";
$lang['forum_settings_help_40'] = "<b>p05+ FR3qUEnCY</b> 15 +eh MINiMUm +1ME @ useR muSt W@1+ 83PhoR3 thEy C4N P0\$+ 494iN. ThIS \$3TtIN9 @LS0 4PhfEC+5 TeH Cr3AT10N 0PH p0lL\$. s3t TO 0 TO d1SAbLe T3H rESTrICt10N.";
$lang['forum_settings_help_41'] = "t3h 4bOV3 oPTiON5 cH@N93 +3H Def4uLT vALu3\$ F0r T3H UseR ReGI\$tR4+1On phorM. WhEr3 @Ppl1C4BLe oTH3R \$3tT1N95 Will US3 +he fOrUM's 0WN d3f4ULt SE++1N9s.";
$lang['forum_settings_help_42'] = "<b>pReVen+ us3 Of dUPL1c4t3 3M41l 4DdRE\$\$35</b> PH0rCE5 bEehIV3 +0 cHecK T3H uSer @cCoUNts @g4IN\$+ +Eh 3M@1l 4DDrE\$5 +hE U53R IS REGiStER1Ng W1Th 4Nd Pr0MP+s +H3m TO U53 aNo+HeR If I+ I5 @lRe4DY 1N u\$e.";
$lang['forum_settings_help_43'] = "<b>r3qUIrE 3M41L C0NfIrM@tION</b> wHEN en4BlED W1Ll S3ND 4n 3Ma1L +0 34CH New USEr WItH @ LInk +H4+ C@n BE usEd TO C0NPh1rM tHEiR Em41L 4DDRE\$5. uN+Il Th3Y c0nPh1rM tHEiR 3M41L 4DdR3sS +H3Y WILL no+ 83 4Bl3 TO p0sT UNlES5 Th31r U5ER PerM1S51oN5 4RE cH@n9Ed m@nu@LLy By 4N 4DMIn.";
$lang['forum_settings_help_44'] = "<b>u\$3 TEXT-C@p+ch@</b> pr35en+5 The N3W u53r W1Th 4 m4NGl3d IM4ge wh1Ch th3Y muSt cOPy 4 numBER PhR0M INTo @ T3xt ph1Eld 0n T3H r391s+R4+10N Ph0Rm. U5e tHIs 0P+1oN TO pr3V3N+ 4UToM@teD s19N-Up V1A 5CR1pTS.";
$lang['forum_settings_help_47'] = "<b>p0\$t 3D1T 9rACe PeRioD</b> @lLOW\$ J00 +O DEf1N3 4 pERi0d In M1NuT35 wH3R3 uS3RS m4Y 3DIt P0Sts WitHOUt TEh '3dI+eD 8Y' +Ext 4Pp34RiN9 On Their PosT5. 1F S3+ TO 0 +3h 'ed1+3D 8Y' +3X+ WIll @LW4y\$ 4PP3@r.";
$lang['forum_settings_help_48'] = "<b>uNRE@d M3\$5Age\$ cU+-0PHph</b> 5pEC1FI3s H0W LONg m355493\$ R3M4iN Unr3@D. Thre4D\$ modiPHi3D n0 L@t3R +Han +He P3r10d \$3L3Ct3D W1ll 4u+0M@t1caLLy @PpE@r 45 r34D.";
$lang['forum_settings_help_49'] = "cH0O\$1NG <b>dI\$48l3 uNRe4D mESs4gE\$</b> w1LL C0mPLe+ElY r3MOvE uNRE4d ME\$5@G3S \$uPp0R+ 4ND r3M0V3 +Eh R3LeV4Nt OP+I0Ns from +He dI\$CUS\$1oN +Yp3 Dr0p d0Wn 0n +hE THrE4d L1\$t.";
$lang['forum_settings_help_50'] = "<b>reqUIR3 us3r ApPRoV4L 8Y 4DMIn</b> 4LLOw\$ j00 +0 reSTR1ct ACc3\$\$ 8y N3w US3RS UN+IL +H3Y H4V3 b3EN @PProV3D 8y @ M0D3R@+0R Or AdMiN. w1+HouT @PPr0v4L a USeR caNN0t 4CCe55 4NY @R34 0PH TH3 beEHiVE PHOruM Ins+aLl4t10N IncLUd1nG 1ndiV1Du@L FoRuMS, pM 1N8OX @ND mY pHORuM5 \$ecTiONS.";
$lang['forum_settings_help_51'] = "u5E <b>cLOSed ME\$\$@9E</b>, <b>r3\$Tr1c+3D mES5AGe</b> 4nD <b>pA\$Sw0RD PR0T3c+Ed Mes549e</b> +0 CuS+0M1\$3 +3H M3S54GE D1\$PL@YEd whEn uSER\$ @cCe\$5 yoUr PhORuM in +H3 V@R1OUs ST4+e5.";
$lang['forum_settings_help_52'] = "j00 C4N u\$3 HtML iN Y0UR M3S549ES. HypErL1Nk5 @Nd 3M@1L @DDR3\$SES w1lL 4LS0 83 4UtoM@tIC@LLy CoNVeRT3D to L1NK\$. to uS3 Teh d3pH@ULt 8EEh1V3 F0RUm M3\$S@GES cLE4R t3H pHIELd5.";
$lang['forum_settings_help_53'] = "<b>alL0w Us3RS t0 cHAnGE UseRn4mE</b> peRmiT\$ 4lR34dy REGi\$t3R3D useR\$ +0 Ch4n9E Th3iR uS3rN4M3. wh3N En4BLEd J00 C@n +R4Ck TH3 Ch4ng35 4 U53R mAke\$ +o +H3IR u5ern@m3 VI4 +3h 4dMin uS3R +OOlS.";
$lang['forum_settings_help_54'] = "u53 <b>fORUm RulE\$</b> To 3NTeR @n @cCEp+@8le US3 p0lIcY +H4+ e4CH u53R mU\$+ 49R33 +0 8eF0Re R391\$+3R1Ng ON Y0ur PHORum.";
$lang['forum_settings_help_55'] = "j00 C@N USe H+mL 1N y0Ur Ph0Rum rUL3\$. HyPErL1Nk\$ 4ND Em4Il AdDrE\$SE\$ wILl @lSO 83 4U+0M4TiC@LLY cONvERteD +0 LiNks. tO U\$3 Th3 dEF4UlT b3EHIvE f0rUM @Up Cle4R +3h Fi3LD.";
$lang['forum_settings_help_56'] = "uSe <b>n0-REpLY 3M41L</b> +0 Sp3cIFy @N eM41L 4DdRE\$\$ tH4+ Do3s NoT 3X1\$+ 0r WiLl N0T 8E MoNI+0r3D pHOr R3pl1ES. +hI5 3m4IL aDDrE\$S wILl Be USed In +eH h34DeRS f0r 4LL eM4ILs \$3Nt PhR0M YOur PhoRum iNClUD1N9 BUT n0T lIM1+3D tO p0st 4Nd PM NO+IPh1c@T10ns, USeR 3M41ls 4Nd p4SSW0rd ReM1nDEr\$.";
$lang['forum_settings_help_57'] = "i+ iS r3C0MM3Nd3D tHA+ J00 USe @N eMaIL 4DDR35s tH@T dO3S noT 3x1\$+ +o h3LP CU+ D0Wn ON sP4M +H4+ MAy b3 DIrEC+3D 4+ yOUR M41N fORUm Em41L 4DdrE\$\$";
$lang['forum_settings_help_58'] = "iN AdD1Ti0n T0 S1mpL3 \$pIdeR1NG, be3HivE C@N 4l5o 93neR@t3 4 \$1+3M4P phOR +Eh PH0rUM TO m4k3 1+ eASI3R FOr \$34rCH eNg1NE\$ TO PH1ND 4nd 1NDex +h3 M3\$549E\$ PoST3d 8y YouR USeRS.";
$lang['forum_settings_help_59'] = "sIteM@PS 4Re @UtoM4TiC@LLY s4V3D +0 +3H S1+Em4pS sU8-diRect0Ry 0PH Y0UR 8EehIVe PhORUm 1N\$+@lLA+10N. IF +H1\$ D1REC+0rY DO3Sn't EX1\$+ j00 MusT cr34TE 1+ 4ND 3nSUrE +H@T I+ i\$ wRiT@8lE 8Y +h3 S3Rv3r / pHP proC3SS. tO 4LlOW s34RcH 3n9Ine\$ To Ph1nd y0UR Si+Em4P J00 MU\$t 4DD +He Url +0 YoUR ro8o+S.+x+.";
$lang['forum_settings_help_60'] = "dEp3ND1NG 0N \$3rv3R p3RPh0Rm@NCe 4ND +3h NUM8er OF F0RumS @ND THr34D5 YoUR 83EH1v3 In5+@Ll4+10N cON+41N\$, 93nEr4+1N9 4 \$i+3M4P m4Y T4k3 5EVEr4L mINuTES +0 COmPLe+3. IPh PeRFOrm@Nc3 0F YouR \$3RV3r I\$ 4dVEr\$LY 4FPH3CtED i+ i\$ r3c0MM3Nd J00 D1S@8LE gENEr@TIoN OpH TeH \$1TEm4p.";
$lang['forum_settings_help_61'] = "<b>senD emAIl N0PhItIC4+10N +0 9L0B4L @dM1n</b> WHEN EN4BLeD WILl SENd @n 3M4Il +0 Th3 9LO84L FOrUm OWn3r\$ wHEN 4 new USEr 4CCoUN+ i\$ cR34+ed.";

// Attachments (attachments.php, get_attachment.php) ---------------------------------------

$lang['aidnotspecified'] = "a1D NOt SPeCiFIEd.";
$lang['upload'] = "uPl04D";
$lang['uploadnewattachment'] = "uplO@D NEw 4+TacHmeN+";
$lang['waitdotdot'] = "w@1+..";
$lang['successfullyuploaded'] = "sUcC3\$5PhULly uPLO@D3D: %s";
$lang['failedtoupload'] = "f@1LEd T0 uPL04D: %s";
$lang['complete'] = "cOMPl3+E";
$lang['uploadattachment'] = "uPl0Ad 4 PhiL3 f0r 4++4ChMEN+ +0 +3H M3s549E";
$lang['enterfilenamestoupload'] = "en+3R F1l3n4M3(S) TO UPLO@D";
$lang['attachmentsforthismessage'] = "a++AcHm3N+S F0r +h1s mE\$5493";
$lang['otherattachmentsincludingpm'] = "oTh3R @++4CHmeN+S (inclUd1N9 Pm MESS@9ES 4Nd O+hER f0RuM\$)";
$lang['totalsize'] = "t0t@l s1Z3";
$lang['freespace'] = "fR3E Sp4cE";
$lang['attachmentproblem'] = "tH3RE W@s 4 pR08L3M D0WnLO@diNg tH1S 4++aChM3N+. PlE4SE tRy 494In la+Er.";
$lang['attachmentshavebeendisabled'] = "a+T4CHm3N+s H4Ve B3En DI\$4BL3D bY +3h pH0RuM 0Wn3R.";
$lang['canonlyuploadmaximum'] = "j00 C@N ONlY UPlO@D a MaXImUM of 10 FIlES 4+ A +1m3";
$lang['deleteattachments'] = "d3l3T3 4+T@ChMEn+S";
$lang['deleteattachmentsconfirm'] = "aR3 J00 SUr3 J00 wAN+ +0 dELe+E tH3 SEl3cTEd @tT4CHMeN+s?";
$lang['deletethumbnailsconfirm'] = "aRE j00 SUr3 J00 W4N+ +0 DELE+3 T3H \$3L3C+Ed 4++aCHM3N+s ThUM8N4ILs?";

// Changing passwords (change_pw.php) ----------------------------------

$lang['passwdchanged'] = "p4\$sw0RD CH@N9ED";
$lang['passedchangedexp'] = "your PA\$5WOrD H4s beeN cH4N9ED.";
$lang['updatefailed'] = "upd@t3 f41L3d";
$lang['passwdsdonotmatch'] = "p@s\$WORdS dO nOT M@tCh.";
$lang['newandoldpasswdarethesame'] = "n3w AnD OLd p4S5WoRD\$ 4rE T3H s4M3.";
$lang['requiredinformationnotfound'] = "reQU1R3D 1NF0rM4T10n N0+ FOUnD";
$lang['forgotpasswd'] = "f0rG0T P4\$\$woRD";
$lang['resetpassword'] = "r3seT P@S\$W0Rd";
$lang['resetpasswordto'] = "r3\$3T p@SSW0rd +0";
$lang['invaliduseraccount'] = "inv4LId USer aCc0UNt SPecIPh1ED. CH3Ck Em41L f0R cOrR3C+ L1nk";
$lang['invaliduserkeyprovided'] = "inv@L1D usEr K3Y pRovIdEd. CH3Ck 3m@1l pH0R coRr3Ct liNk";

// Deleting messages (delete.php) --------------------------------------

$lang['nomessagespecifiedfordel'] = "nO MessAGe Sp3C1PhI3D for d3L3ti0n";
$lang['deletemessage'] = "dEL3te m3sS@g3";
$lang['postdelsuccessfully'] = "p0s+ D3L3t3d 5UcC3ssFully";
$lang['errordelpost'] = "erROr D3LE+1n9 P05T";
$lang['cannotdeletepostsinthisfolder'] = "j00 C4NNO+ d3l3+3 pOS+S 1N tHI\$ Ph0ldEr";

// Editing things (edit.php, edit_poll.php) -----------------------------------------

$lang['nomessagespecifiedforedit'] = "nO m3ss@93 5P3C1PH1ed For ED1+IN9";
$lang['cannoteditpollsinlightmode'] = "c4NnOT 3D1+ PolL\$ In liGh+ M0d3";
$lang['editedbyuser'] = "eD1TEd: %s BY %s";
$lang['editappliedtomessage'] = "eD1+ 4pPl13D +0 M3SS4gE";
$lang['errorupdatingpost'] = "errOR UPd4+1Ng p0s+";
$lang['editmessage'] = "eD1+ meS\$AGe %s";
$lang['editpollwarning'] = "<b>nOTE</b>: Ed1+InG c3RT@iN @SpECTS 0PH 4 P0Ll WIlL VOId ALl t3H cURr3N+ Vo+E5 4ND 4LLOw PeOPL3 tO Vot3 49@In.";
$lang['hardedit'] = "h@RD 3dI+ OpT10NS (VO+e\$ W1LL 8e re\$3t):";
$lang['softedit'] = "s0pH+ EdI+ 0p+10Ns (voteS W1ll 8E R3+41NED):";
$lang['changewhenpollcloses'] = "ch@NGe wHEN tHe P0ll CLO\$3\$?";
$lang['nochange'] = "n0 CH4ngE";
$lang['emailresult'] = "eM41l R3SUl+";
$lang['msgsent'] = "mESS@9E SEnT";
$lang['msgsentsuccessfully'] = "mE\$S49E SenT SUcC3sSfuLLy.";
$lang['mailsystemfailure'] = "m4IL sys+3M f4iLure. M3SS493 N0T 5en+.";
$lang['nopermissiontoedit'] = "j00 4R3 N0+ PErm1++3D +0 3Dit tH1S m3\$s49E.";
$lang['cannoteditpostsinthisfolder'] = "j00 C@NNOt 3D1T POS+s IN Th1s FOlD3R";
$lang['messagewasnotfound'] = "m3Ss4gE %s W4\$ NOt FouND";

// Email (email.php) ---------------------------------------------------

$lang['sendemailtouser'] = "s3nd EMaIl +o %s";
$lang['nouserspecifiedforemail'] = "no US3R \$pEcIF1Ed PhoR 3M41lInG.";
$lang['entersubjectformessage'] = "eN+eR 4 \$uBj3CT pHOr +hE m3SS49e";
$lang['entercontentformessage'] = "eN+ER S0M3 coN+EN+ f0R tEH m35s49E";
$lang['msgsentfromby'] = "tHi\$ Me\$549E waS sen+ FrOM %s 8Y %s";
$lang['subject'] = "sUBJ3Ct";
$lang['send'] = "s3nd";
$lang['userhasoptedoutofemail'] = "%s h4s 0P+eD OuT OpH 3M41L cON+@C+";
$lang['userhasinvalidemailaddress'] = "%s h4s @n INv4L1D eM@il 4DdrEs5";

// Message nofificaiton ------------------------------------------------

$lang['msgnotification_subject'] = "m3sSa9E NOtIfIca+1On PhRom %s";
$lang['msgnotificationemail'] = "h3LL0 %s,\n\n%s POSt3D 4 mESS@GE tO j00 0n %s.\n\nthE su8J3Ct IS: %s.\n\ntO rE4D +H4+ ME55493 4Nd O+h3R5 In +3H S4Me Di\$cUs\$1oN, go to:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nnOT3: 1F j00 d0 N0+ WISH +0 rEc31V3 3M4IL NoTIph1C4+1on\$ 0PH phoruM mE\$5@93S P0S+eD +0 Y0U, 9O to: %s Cl1cK oN MY cOnTr0LS th3N eM41L 4ND pRiV4Cy, uN5ELecT +3H EM41L NO+1FIc@+10n CheCK80X @nD pRe\$\$ SU8mI+.";

// Thread Subscription notification ------------------------------------

$lang['subnotification_subject'] = "su8\$CRiPTIOn NoTIpHIC@t1oN PHr0M %s";
$lang['subnotification'] = "helLo %s,\n\n%s poSt3d 4 mEs\$49E In @ tHR34d J00 H4VE \$U8Scr183D +0 oN %s.\n\nTH3 sUbJEcT 1S: %s.\n\nt0 R34D th@t M3\$\$@93 ANd 0+heRs 1n +H3 sAMe d1\$CUSsI0N, G0 To:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nn0+3: 1F j00 DO N0T W1SH +0 ReC31V3 3M@1L n0tiFIc@TIon\$ OF New me\$s4gE\$ IN tH1\$ +hRE4D, G0 tO: %s 4ND 4dJuS+ Y0Ur 1n+3r35+ l3v3L 4+ +he BOtTOm OF t3H p@9e.";

// PM notification -----------------------------------------------------

$lang['pmnotification_subject'] = "pm NO+1ph1C@t10N FR0M %s";
$lang['pmnotification'] = "h3ll0 %s,\n\n%s P0ST3D 4 Pm +0 j00 0N %s.\n\n+H3 \$u8JEcT 15: %s.\n\n+0 rEAd t3h m355493 9O t0:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nn0+3: 1F J00 d0 N0t WIsH +0 Rec31V3 Em@1L N0+1PhIC@TIonS 0Ph NeW pm MeSSa9E5 p0S+Ed +0 Y0U, 90 TO: %s CLIcK MY C0NTroLS THeN 3M4Il 4Nd PRIv4cY, UNS3LecT t3H pM n0T1Fic4T10N cH3CkBOX 4Nd pR3SS \$UBm1+.";

// Password change notification ----------------------------------------

$lang['passwdchangenotification'] = "p4S\$WoRD cH@NGe NO+IPh1Ca+I0N FrOM %s";
$lang['pwchangeemail'] = "hell0 %s,\n\nTH1S @ n0T1F1CaTI0N 3M4IL tO iNF0Rm j00 TH@T Y0UR p4S5WORd On %s H@S bEEn cH4Ng3d.\n\nIT H@\$ bEEn CHaN93d To: %s And W@\$ Ch4N9ED By: %s.\n\n1f j00 h4VE r3C3IvEd +His EM@Il In 3RRoR 0R wEr3 No+ 3xPECTiN9 @ Ch4N9E tO Y0uR P455W0Rd PL3453 C0N+AcT +H3 PhORuM oWNEr Or 4 mOD3r4+0R oN %s 1MM3Di4+eLY +0 c0RrECT 1t.";

// Email confirmation notification -------------------------------------

$lang['emailconfirmationrequiredsubject'] = "eM41L c0NPh1RMa+I0n REQUIR3D pHOR %s";
$lang['confirmemail'] = "helLO %s,\n\ny0U REc3N+Ly CrEA+ED 4 NEw u\$3R 4Cc0Un+ 0N %s.\nb3fOr3 J00 C4N \$+@R+ PO\$+1N9 We NeEd To c0NfiRm YoUR eM41L 4dDRESS. d0N't W0Rry +H1S 1s QU1Te E45Y. alL j00 NeED +0 DO 1s cLiCK +hE l1Nk 83LOW (0R c0pY 4nD p@stE 1T 1N+O Y0uR 8R0WS3R):\n\n%s\n\nONc3 C0NPhiRmATI0N IS c0mPLe+3 j00 M4Y l0GIn 4ND \$+4RT P0S+1NG 1MmEDi4+ELy.\n\niF j00 DiD NO+ cRE4+3 4 US3R ACCoUNt oN %s ple4SE @cCepT 0UR 4POLoGIEs 4Nd fORW@RD +HI\$ EM4IL TO %s SO +H@t +3H sOURc3 OF I+ M@Y Be Inv35+1g@t3D.";
$lang['confirmchangedemail'] = "h3LLo %s,\n\nY0U ReCEnTlY Ch4N9Ed y0Ur Em41l ON %s.\n8ePhOR3 j00 c@N St@Rt P0S+iNG 494In We nE3D to c0NPhIrM yOUr n3w Em@1L addrE\$s. Don't WoRRy tH1S IS qUit3 E4\$Y. aLl J00 N3Ed +0 Do i5 cl1CK +h3 l1NK B3lOW (OR COpY 4ND P@S+3 1T 1N+0 y0UR BROw\$Er):\n\n%s\n\n0Nc3 COnPhIRm4+ION 1\$ COmPl3T3 j00 m4Y C0n+1Nu3 +0 usE +h3 Ph0rUM 4\$ n0RM4L.\n\nIF J00 wErE No+ EXpECT1nG +H1S eM41L pHR0m %s pLe4S3 4Cc3P+ 0Ur @p0Log135 4Nd fORWaRd thI\$ Em4iL TO %s SO Th4+ tEh SOUrCe 0F It M@Y 8e 1nVE5tiG4T3D.";

// Forgotten password notification -------------------------------------

$lang['forgotpwemail'] = "h3LLO %s,\n\nYOu reqU3S+Ed +H1s 3-m@1l pHr0M %s 8eC4u\$E J00 H4Ve f0r90TTen Y0uR P4sSWoRd.\n\ncLIcK T3h LinK b3l0W (0r cOPy @Nd p4S+3 1+ In+0 YOuR br0wSER) +o reSeT Y0ur p4\$5w0rD:\n\n%s";

// Admin New User Approval notification -----------------------------------------

$lang['newuserapprovalsubject'] = "nEW uSEr 4PpROvAl n0+iFiC4+1on F0r %s";
$lang['newuserapprovalemail'] = "Hello %s,\n\nA new user account has been created on %s.\n\nAs you are an Administrator of this forum you are required to approve this user account before it can be used by it's owner.\n\nTo approve this account please visit the Admin Users section and change the filter type to \"Users Awaiting Approval\"0r CliCk +EH L1Nk BElOw:\n\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nno+3: 0Th3R @DMIni\$+R4+Ors 0N Th15 F0rUM WiLL 4L\$O r3c31VE THi\$ N0tIFiC@t10N @nD M@y H4v3 4Lr34DY @C+3D Up0n THis r3qU3S+.";

// Admin New User notification -----------------------------------------

$lang['newuserregistrationsubject'] = "nEw us3R 4CCOUnT nOt1FIC@T10N phoR %s";
$lang['newuserregistrationemail'] = "hElL0 %s,\n\n@ NEw U\$eR @cCOuN+ H4s b33N cREa+Ed 0N %s.\n\nTo View +h1s u\$ER @Cc0unT pL34sE VIs1+ +He 4Dm1N USerS sECT10N @nD CliCk 0n +H3 nEw uSER OR clICk TeH liNK bEloW:\n\n%s";

// User Approved notification ------------------------------------------

$lang['useraccountapprovedsubject'] = "useR 4PPrOv4l nOtIPh1C4+10n F0r %s";
$lang['useraccountapprovedemail'] = "h3llo %s,\n\nY0Ur u\$er 4Cc0UNt @+ %s H@S BEen @pprOvED. j00 c4N L091n @ND St@R+ Po\$TiN9 IMmeDi4+lY BY Cl1CkinG THe LInK 83LoW:\n\n%s\n\nIF j00 wER3 NO+ exP3c+1n9 +hI\$ eM41L FRoM %s pl34\$3 @cCEp+ OUr 4P0l0GiE5 @nD phOrWaRd +H1\$ Em4iL +O %s s0 th4t T3h \$0UrC3 0ph 1+ m4Y 8E InVe\$+1g@+Ed.";

// Admin Post Approval notification -----------------------------------------

$lang['newpostapprovalsubject'] = "post @PpROV4l nOTiFIC4+I0N Ph0R %s";
$lang['newpostapprovalemail'] = "h3lL0 %s,\n\n4 nEW POs+ h4S b3EN cRe4+3d ON %s.\n\n4S J00 4rE @ M0dER@Tor 0n +H1S ph0rUM j00 4rE R3QUiReD +O 4PpROv3 +His pO5+ b3f0Re 1T CaN b3 r34D 8Y 0+h3R u5Er\$.\n\nyoU c4N 4Ppr0Ve +H1S pOST @nD 4nY OtH3Rs p3NdIn9 4PpRov4L 8Y V1sI+1Ng ThE AdMiN P05+ @pprov4L SEctIoN oF yOUr FoRUm or by CLicKing tHE L1Nk 8eL0W:\n\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nN0T3: otHeR @dM1Ni5Tr4+0Rs ON th1\$ f0RuM w1Ll @LSo ReCeivE ThI\$ No+1FiC@TI0n 4nD MAy h@v3 @Lr34DY 4CtED UPoN +HI\$ R3qUESt.";

// Forgotten password form.

$lang['passwdresetrequest'] = "yOuR p@SSw0Rd RE\$e+ r3qU3\$t PhrOm %s";
$lang['passwdresetemailsent'] = "p@sSWOrD RE5ET 3-M41l seN+";
$lang['passwdresetexp'] = "j00 \$H0UlD 5h0R+Ly ReCeIvE @n 3-m4Il c0N+@iN1NG In\$+rUC+10NS ph0R rE\$3t+iN9 Y0Ur pASsWoRd.";
$lang['validusernamerequired'] = "a v@l1D Us3RN4m3 1S r3qU1ReD";
$lang['forgottenpasswd'] = "f0r90T p4SSw0Rd";
$lang['couldnotsendpasswordreminder'] = "c0uLD N0T S3nD PaS5WoRd ReM1nDeR. PL3as3 c0Nt4C+ Teh PhOrUM 0wN3R.";
$lang['request'] = "rEQU3S+";

// Email confirmation (confirm_email.php) ------------------------------

$lang['emailconfirmation'] = "em4iL COnfIrM@TI0N";
$lang['emailconfirmationcomplete'] = "tH@Nk j00 for CONf1Rmin9 yOUr 3M41l addR3SS. j00 M4Y NOw l091N @Nd sT@r+ p0S+1nG 1mM3D1@teLy.";
$lang['emailconfirmationfailed'] = "eMAIL cOnF1rM@t1on H45 PH41l3D, PlE4sE +ry AG4iN l@t3r. 1F J00 3Nc0Un+3r +h1\$ 3Rr0R MUL+iPl3 t1M3S Pl34SE C0nT@Ct +HE PhoRum owneR 0r 4 MOdEr4TOR pH0R asSist@nCE.";

// Links database (links*.php) -----------------------------------------

$lang['toplevel'] = "toP l3V3L";
$lang['maynotaccessthissection'] = "j00 m@y Not 4Cce\$5 +HIs \$3cTI0n.";
$lang['toplevel'] = "t0p L3v3l";
$lang['links'] = "l1Nks";
$lang['externallink'] = "exTerN4L liNk";
$lang['viewmode'] = "v13w mod3";
$lang['hierarchical'] = "hI3rArcH1c4L";
$lang['list'] = "l1\$T";
$lang['folderhidden'] = "thI5 pHoLdEr 1S hidDEn";
$lang['hide'] = "h1D3";
$lang['unhide'] = "unhIde";
$lang['nosubfolders'] = "nO \$u8F0lD3rs In ThI5 c@TE9OrY";
$lang['1subfolder'] = "1 SUbfOLd3R IN +hi\$ C4+Eg0RY";
$lang['subfoldersinthiscategory'] = "su8phoLD3rS in tHI\$ caT3gOrY";
$lang['linksdelexp'] = "enTrIe\$ in @ DeL3t3D ph0Ld3R wiLl 8e m0Ved +O tEH P4r3N+ FOlDEr. ONly PhoLDeRs wH1ch d0 nOt C0NT@iN \$U8Ph0LDeRS M4y B3 d3L3+3D.";
$lang['listview'] = "li\$+ ViEW";
$lang['listviewcannotaddfolders'] = "c4nNO+ AdD FOlDeRs 1n THi5 v1eW. sHOwInG 20 3N+rI3\$ @T A +1Me.";
$lang['rating'] = "r@+1Ng";
$lang['nolinksinfolder'] = "n0 LinkS iN +h1\$ f0LdER.";
$lang['addlinkhere'] = "add L1NK HEre";
$lang['notvalidURI'] = "tHAT 1\$ n0T a V4l1D Ur1!";
$lang['mustspecifyname'] = "j00 mUSt Sp3c1Phy @ n@m3!";
$lang['mustspecifyvalidfolder'] = "j00 Mu\$t \$PEc1Phy 4 V4lID Ph0ldEr!";
$lang['mustspecifyfolder'] = "j00 mUSt Sp3CiFY 4 pH0lDEr!";
$lang['successfullyaddedlinkname'] = "sUCC3SsPhUlly 4dD3d lInk '%s'";
$lang['failedtoaddlink'] = "fAiL3D +0 4DD LiNK";
$lang['failedtoaddfolder'] = "f@iL3D +o AdD Ph0LdEr";
$lang['addlink'] = "add 4 lINk";
$lang['addinglinkin'] = "aDd1N9 Link 1n";
$lang['addressurluri'] = "aDDResS";
$lang['addnewfolder'] = "add 4 N3W ph0Ld3R";
$lang['addnewfolderunder'] = "add1N9 nEW PhOLdeR uNd3r";
$lang['editfolder'] = "edIt pH0Ld3R";
$lang['editingfolder'] = "edi+1NG FoLD3r";
$lang['mustchooserating'] = "j00 mU\$+ CHO0Se 4 RA+In9!";
$lang['commentadded'] = "y0uR c0MMEn+ w4S 4DDeD.";
$lang['commentdeleted'] = "cOmM3Nt Wa\$ dELe+Ed.";
$lang['commentcouldnotbedeleted'] = "c0mM3NT c0UlD NO+ be D3Le+eD.";
$lang['musttypecomment'] = "j00 mUST +YpE @ COmm3N+!";
$lang['mustprovidelinkID'] = "j00 must prOv1D3 4 l1nK Id!";
$lang['invalidlinkID'] = "inv4LiD linK iD!";
$lang['address'] = "addRE\$S";
$lang['submittedby'] = "su8Mi+teD By";
$lang['clicks'] = "cl1cKS";
$lang['rating'] = "r@tIng";
$lang['vote'] = "v0tE";
$lang['votes'] = "v0+3S";
$lang['notratedyet'] = "n0+ ratED 8y 4NyONE Y3T";
$lang['rate'] = "r@+3";
$lang['bad'] = "bad";
$lang['good'] = "g00D";
$lang['voteexcmark'] = "vo+E!";
$lang['clearvote'] = "cL3@R v0te";
$lang['commentby'] = "cOmM3N+ 8Y %s";
$lang['addacommentabout'] = "aDD 4 COmMeNT 4BOUt";
$lang['modtools'] = "mod3R4T10N +00L\$";
$lang['editname'] = "eDi+ n4M3";
$lang['editaddress'] = "edi+ 4DdReSS";
$lang['editdescription'] = "ed1+ d3scr1Pt10N";
$lang['moveto'] = "m0V3 +0";
$lang['linkdetails'] = "liNK D3+4iLS";
$lang['addcomment'] = "add C0MmEN+";
$lang['voterecorded'] = "youR v0+E H4S 8eEn REcoRd3D";
$lang['votecleared'] = "y0uR VO+e h4s bE3N cL3@R3D";
$lang['linknametoolong'] = "l1NK n@m3 +oo l0n9. M@XImUM i\$ %s cHAr4cters";
$lang['linkurltoolong'] = "liNK Url +0O l0Ng. M@x1MUm I5 %s CHaR4C+er\$";
$lang['linkfoldernametoolong'] = "fOLDer n4M3 +00 lOnG. M@X1MuM l3Ng+h i\$ %s Ch4r@cT3RS";

// Login / logout (llogon.php, logon.php, logout.php) -----------------------------------------

$lang['loggedinsuccessfully'] = "j00 L0G9Ed iN \$UcC3\$\$PhULlY.";
$lang['presscontinuetoresend'] = "pRESS conTiNu3 +0 rEsEnd f0Rm d4+4 0R C4NcEL To Rel0@D P4Ge.";
$lang['usernameorpasswdnotvalid'] = "tH3 U\$erN@mE 0r P4\$Sw0RD j00 sUpPlieD I5 n0T VaL1D.";
$lang['rememberpasswds'] = "remeMBeR P@sSWOrDS";
$lang['rememberpassword'] = "remeMBEr P4sSwOrD";
$lang['enterasa'] = "eN+3R 4S 4 %s";
$lang['donthaveanaccount'] = "d0n'+ h4VE 4n aCc0Unt? %s";
$lang['registernow'] = "r39IS+eR n0W";
$lang['problemsloggingon'] = "pR0bL3m\$ LoGgIn9 oN?";
$lang['deletecookies'] = "d3L3+E C0OKie5";
$lang['cookiessuccessfullydeleted'] = "co0KiES \$UCc3\$5PhUlLy dEl3+3D";
$lang['forgottenpasswd'] = "f0r9O++3N YoUR Pa\$5w0Rd?";
$lang['usingaPDA'] = "u\$In9 4 pD@?";
$lang['lightHTMLversion'] = "li9h+ HtML V3R\$1ON";
$lang['youhaveloggedout'] = "j00 H4v3 l0gGEd Out.";
$lang['currentlyloggedinas'] = "j00 aRE cURr3N+ly l0GGeD In @s %s";
$lang['logonbutton'] = "l09ON";
$lang['otherdotdotdot'] = "o+h3R...";
$lang['yoursessionhasexpired'] = "y0uR S3s51ON h45 EXpIrEd. J00 W1Ll n3Ed +0 lOG1n 4941n To cONt1NuE.";

// My Forums (forums.php) ---------------------------------------------------------

$lang['myforums'] = "my F0Rum\$";
$lang['allavailableforums'] = "all @VAIl4bLe FOruM\$";
$lang['favouriteforums'] = "fAv0Ur1+E PhOrUMs";
$lang['ignoredforums'] = "ign0R3d FOrUms";
$lang['ignoreforum'] = "iGN0r3 f0RuM";
$lang['unignoreforum'] = "un1gnOR3 f0RUm";
$lang['lastvisited'] = "l4s+ V1S1t3D";
$lang['forumunreadmessages'] = "%s uNR3AD mE\$S49E\$";
$lang['forummessages'] = "%s mEssAgE\$";
$lang['forumunreadtome'] = "%s uNReAD &quot;+0: M3&quot;";
$lang['forumnounreadmessages'] = "no uNreAd mE\$s4GE\$";
$lang['removefromfavourites'] = "reMoVE fROM Ph4V0Ur1+3\$";
$lang['addtofavourites'] = "adD +0 f4v0URiT3\$";
$lang['availableforums'] = "avaIl4bLe pHORuMS";
$lang['noforumsofselectedtype'] = "thERe Ar3 n0 F0rUm\$ 0f +H3 s3LeCt3D tYp3 4v41L48l3. pLe4\$3 \$3L3C+ 4 d1FfEren+ +yP3.";
$lang['successfullyaddedforumtofavourites'] = "sUcC3\$sFUlLy @DDed F0rum +0 pH@V0UrI+E5.";
$lang['successfullyremovedforumfromfavourites'] = "sucC3SSfuLly Rem0V3d F0rUm PhrOM f4VoUR1TeS.";
$lang['successfullyignoredforum'] = "sUCC3SSPhULLy 19N0R3d F0Rum.";
$lang['successfullyunignoredforum'] = "sUcCe5SFuLLy uN1gN0r3D F0ruM.";
$lang['failedtoupdateforuminterestlevel'] = "fA1L3D t0 uPdaT3 ph0RUm 1NtEr3ST lEvEl";
$lang['noforumsavailablelogin'] = "tHeRe 4RE N0 PhorUMs 4V4il48L3. Pl34Se lO9iN +0 v1Ew yOuR f0Rum5.";
$lang['passwdprotectedforum'] = "p@Ssw0RD PrOtEc+ed f0rUM";
$lang['passwdprotectedwarning'] = "tH1\$ F0RUm 1S p@SsW0Rd PrO+3CteD. TO 941N 4CC3\$\$ 3N+eR ThE P4SSw0RD 8eLow.";

// Message composition (post.php, lpost.php) --------------------------------------

$lang['postmessage'] = "pOs+ m35S493";
$lang['selectfolder'] = "s3l3C+ f0Lder";
$lang['mustenterpostcontent'] = "j00 muS+ EnTEr \$0M3 coN+3N+ F0r tH3 P0S+!";
$lang['messagepreview'] = "mEsS@9E PReV13w";
$lang['invalidusername'] = "iNVaL1d US3Rn4mE!";
$lang['mustenterthreadtitle'] = "j00 mU5T 3N+3r @ TiTl3 pHoR Th3 THRe4d!";
$lang['pleaseselectfolder'] = "pleaSE s3lec+ 4 FOlDeR!";
$lang['errorcreatingpost'] = "err0R Cr3@tin9 pO\$+! ple@s3 TrY @9aiN iN @ pH3w M1nU+eS.";
$lang['createnewthread'] = "cR34+3 nEW +hRe4D";
$lang['postreply'] = "posT rEPlY";
$lang['threadtitle'] = "thrE4d +1+lE";
$lang['messagehasbeendeleted'] = "m3\$s49e n0T PhoUNd. ChecK TH4+ iT h4Sn't 8E3n d3Le+Ed.";
$lang['messagenotfoundinselectedfolder'] = "me\$s4G3 n0+ PH0uND In s3L3C+Ed f0Ld3R. CH3CK +Ha+ i+ h4sN'+ 8EEn moVEd OR d3lE+3d.";
$lang['cannotpostthisthreadtypeinfolder'] = "j00 cAnNO+ P0\$+ +h1\$ +HR34d +yP3 IN +H4+ f0lDeR!";
$lang['cannotpostthisthreadtype'] = "j00 C@nnoT p0\$+ +H1\$ ThR3@d +ype 4S +HeRe 4Re N0 @v4Il4bLE FOlD3rs TH4t aLl0W I+.";
$lang['cannotcreatenewthreads'] = "j00 C@nNo+ Cr3@t3 N3w ThRe4d\$.";
$lang['threadisclosedforposting'] = "th1\$ tHr3@d 1\$ clOS3D, J00 C@nNO+ PosT 1n I+!";
$lang['moderatorthreadclosed'] = "w4rNiN9: th15 ThR34d 1S cl0S3d F0r pO\$+1n9 +0 nOrm@L uS3r\$.";
$lang['usersinthread'] = "uSeR\$ In THr3AD";
$lang['correctedcode'] = "c0Rr3C+ED COdE";
$lang['submittedcode'] = "sU8MI++3D c0D3";
$lang['htmlinmessage'] = "hTML in mE\$s493";
$lang['disableemoticonsinmessage'] = "dis@8lE 3MoTiCons iN MesS@9E";
$lang['automaticallyparseurls'] = "au+OM4T1C4lLY p@R5E uRLS";
$lang['automaticallycheckspelling'] = "aUTOm@TIc4Lly ChEcK sPeLlInG";
$lang['setthreadtohighinterest'] = "set THr34D +0 h19H 1n+EResT";
$lang['enabledwithautolinebreaks'] = "eN4Bled wi+h 4U+O-LiNe-8R3aK\$";
$lang['fixhtmlexplanation'] = "thi5 F0rUm uSes h+mL FiLtErINg. YoUr 5uBMI++Ed h+ml H4\$ b33N M0D1fIED bY +hE pHIL+eR5 In \$oM3 w4Y.\\n\\nT0 VIeW YouR 0rI9In4L c0D3, S3LeCt +H3 \\'5UbMi++3d cOdE\\' Radi0 8UttON.\\n+0 vIEw the MoDIPHiEd c0dE, S3LEc+ +h3 \\'cORrEc+Ed c0D3\\' R4D1O 8UTt0N.";
$lang['messageoptions'] = "mESS@93 OPTI0Ns";
$lang['notallowedembedattachmentpost'] = "j00 @R3 NO+ 4LLoWed +0 EmBEd 4+T@ChmENT\$ In YOuR p0\$TS.";
$lang['notallowedembedattachmentsignature'] = "j00 4Re no+ 4Ll0Wed +O 3M8eD 4++@chm3N+S In y0UR \$1gn4+uR3.";
$lang['reducemessagelength'] = "me\$SA93 l3N9Th mUS+ Be uNDeR 65,535 ch@R@C+3rS (cuRrenTly: %s)";
$lang['reducesiglength'] = "sIgnA+UR3 lEnG+h Mus+ Be UNdER 65,535 cH4RAct3R5 (CUrR3N+LY: %s)";
$lang['cannotcreatethreadinfolder'] = "j00 C@nnOt CrE4Te N3w tHr3Ad\$ iN ThIs phOlDeR";
$lang['cannotcreatepostinfolder'] = "j00 c4Nn0T RePlY tO p0S+s iN thIs Ph0LdER";
$lang['cannotattachfilesinfolder'] = "j00 c@nnOt p0ST A++achM3n+S In +H1\$ F0ld3r. REM0Ve @TT4CHm3N+S +o C0n+iNu3.";
$lang['postfrequencytoogreat'] = "j00 c@n oNly p0ST 0Nc3 eVeRY %s \$3cONdS. pL3A\$3 TrY @g4In L4T3r.";
$lang['emailconfirmationrequiredbeforepost'] = "eM@il c0NfIRm@TioN I\$ rEQu1reD 8EPhOR3 J00 c4N pO\$+. If J00 hAvE n0T ReCEiV3d 4 coNF1Rm@t10N 3MAiL Pl34\$3 Cl1ck +3H 8u+t0N 83LOw @Nd @ n3W 0N3 W1lL 83 \$3n+ T0 Y0U. 1ph Y0Ur 3m4iL 4DdR3Ss N3eD\$ cH@nGInG Pl34Se Do S0 8EpHOr3 r3QUeS+1ng @ neW C0NpHIrm@t10N 3m41L. J00 M4Y Ch@N9e YoUr Em4Il 4dDr355 bY clIcK my C0nTr0lS 48OVe @Nd Th3N US3r De+4Il\$";
$lang['emailconfirmationfailedtosend'] = "cOnFIrm4+1On eM41L F4iLed +0 sEnD. PlEa\$e cON+4ct t3H pH0rUm oWN3r to R3CtIFy thIS.";
$lang['emailconfirmationsent'] = "c0nFIrM@T1On em41L H4S 83EN R3sEN+.";
$lang['resendconfirmation'] = "r3\$3Nd CoNf1Rm4+1On";
$lang['userapprovalrequiredbeforeaccess'] = "yOUr uS3R 4Cc0UnT n33D\$ TO 8E @PpR0VeD By @ ph0RuM 4DM1n 83F0r3 j00 c@n @CCe\$S +eh reqU3St3D pH0rUm.";
$lang['reviewthread'] = "rEviEw tHr34D";
$lang['reviewthreadinnewwindow'] = "rEv13W 3N+iRe thr34D In N3W wINd0W";

// Message display (messages.php & messages.inc.php) --------------------------------------

$lang['inreplyto'] = "in R3PlY to";
$lang['showmessages'] = "sHOW MES549E5";
$lang['ratemyinterest'] = "r4+E my 1NteR3S+";
$lang['adjtextsize'] = "aDJU\$T +3xT S1Z3";
$lang['smaller'] = "sm4LLer";
$lang['larger'] = "l4rg3R";
$lang['faq'] = "f4Q";
$lang['docs'] = "d0cS";
$lang['support'] = "supP0R+";
$lang['donateexcmark'] = "d0n4TE!";
$lang['fontsizechanged'] = "f0NT S1Z3 cHangEd. %s";
$lang['framesmustbereloaded'] = "fr@M3s Mus+ B3 rEL04D3D M@nuALlY to sEe Ch4N9E\$.";
$lang['threadcouldnotbefound'] = "tHE rEqUE\$T3d thr34D C0UlD nO+ 8e F0uND 0R 4Cc355 W45 DENied.";
$lang['mustselectpolloption'] = "j00 Mus+ SELECT AN 0P+1ON +0 VoT3 F0r!";
$lang['mustvoteforallgroups'] = "j00 mUS+ vOT3 IN eVeRy gROuP.";
$lang['keepreading'] = "ke3p r34D1NG";
$lang['backtothreadlist'] = "b4CK +0 THr34D L1\$t";
$lang['postdoesnotexist'] = "tH4+ p05T Do3S n0+ ExiS+ iN +hIs tHr34D!";
$lang['clicktochangevote'] = "clicK +0 CH@NgE v0T3";
$lang['youvotedforoption'] = "j00 vOt3D PH0r 0PtioN";
$lang['youvotedforoptions'] = "j00 V0T3d phoR 0PtiOn\$";
$lang['clicktovote'] = "cLICk +0 voT3";
$lang['youhavenotvoted'] = "j00 H4vE NoT VO+3D";
$lang['viewresults'] = "vieW R3\$Ul+5";
$lang['msgtruncated'] = "mES\$@9E +rUnc4+3D";
$lang['viewfullmsg'] = "v1Ew pHull M3\$S4G3";
$lang['ignoredmsg'] = "i9N0rEd m3\$s4G3";
$lang['wormeduser'] = "w0rM3D USer";
$lang['ignoredsig'] = "iGn0R3d 5IgnATuR3";
$lang['messagewasdeleted'] = "mE5s4G3 %s.%s W45 deLeTED";
$lang['stopignoringthisuser'] = "s+0P 19noR1Ng This u\$3R";
$lang['renamethread'] = "rEN@M3 +HrE4D";
$lang['movethread'] = "movE THR34D";
$lang['torenamethisthreadyoumusteditthepoll'] = "t0 r3n@m3 +H1\$ +hR34D j00 mu\$+ eD1+ Teh pOlL.";
$lang['closeforposting'] = "cLoS3 f0R pO5+inG";
$lang['until'] = "uN+1L 00:00 U+C";
$lang['approvalrequired'] = "aPproVal ReQUiReD";
$lang['messageawaitingapprovalbymoderator'] = "me5549E %s.%s I\$ 4WAi+1NG 4pPr0v@l By 4 mODeR@tOr";
$lang['postapprovedsuccessfully'] = "pos+ 4PpR0vED \$ucCeS\$PHully";
$lang['postapprovalfailed'] = "p0sT 4PpROV@L F4Il3D.";
$lang['postdoesnotrequireapproval'] = "pos+ dO3s nO+ r3QUirE 4PpR0v4l";
$lang['approvepost'] = "appROV3 p0\$t";
$lang['approvedbyuser'] = "apPR0VeD: %s 8Y %s";
$lang['makesticky'] = "m4K3 \$+1Cky";
$lang['messagecountdisplay'] = "%s 0F %s";
$lang['linktothread'] = "p3RM@Nent L1nK tO thi\$ +hRE4d";
$lang['linktopost'] = "lINK tO P0\$+";
$lang['linktothispost'] = "link tO THi\$ PO\$+";
$lang['imageresized'] = "thi\$ 1m49E h4\$ b33N rE5iZ3D (Or1GiN4L \$1ze %1\$SX%2\$s). +O VieW Th3 phuLl-51Z3 iM49e CL1ck hERe.";
$lang['messagedeletedbyuser'] = "m3\$549E %s.%s DELe+3D %s 8y %s";
$lang['messagedeleted'] = "m3sS@9e %s.%s W@S D3le+3d";
$lang['viewinframeset'] = "vieW iN Fr@mESeT";

// Moderators list (mods_list.php) -------------------------------------

$lang['cantdisplaymods'] = "c4NNo+ Di\$pL4Y pHoLDeR M0dER@+OrS";
$lang['moderatorlist'] = "m0D3R4+Or lI\$+:";
$lang['modsforfolder'] = "m0DEr4ToRS pH0R Ph0LdER";
$lang['nomodsfound'] = "nO moDEr@tORS FOuNd";
$lang['forumleaders'] = "fORUm l34DerS:";
$lang['foldermods'] = "fOlD3R mOD3r4TOr5:";

// Navigation strip (nav.php) ------------------------------------------

$lang['start'] = "st@R+";
$lang['messages'] = "m3sS49E\$";
$lang['pminbox'] = "in8Ox";
$lang['startwiththreadlist'] = "s+aR+ Pag3 Wi+h +HrE4D lI\$+";
$lang['pmsentitems'] = "s3N+ i+3M\$";
$lang['pmoutbox'] = "out8oX";
$lang['pmsaveditems'] = "s@v3D 1+3m\$";
$lang['pmdrafts'] = "dr4fTS";
$lang['links'] = "lINk\$";
$lang['admin'] = "aDM1n";
$lang['login'] = "logiN";
$lang['logout'] = "l090Ut";

// PM System (pm.php, pm_write.php, pm.inc.php) ------------------------

$lang['privatemessages'] = "pRIVat3 M3\$s493\$";
$lang['recipienttiptext'] = "sEP@r@T3 REcIp1EN+5 bY s3M1-c0LoN 0r c0MM4";
$lang['maximumtenrecipientspermessage'] = "th3Re i\$ 4 l1MI+ OF 10 R3C1PiEntS peR M3sSaGe. Pl34S3 @M3nD YOuR r3cIpiENt l1\$T.";
$lang['mustspecifyrecipient'] = "j00 mUST sPEc1PHy A+ l3@S+ 0N3 R3CIpIenT.";
$lang['usernotfound'] = "u53R %s no+ FoUND";
$lang['sendnewpm'] = "s3nD NeW pM";
$lang['savemessage'] = "s@v3 MeSS4Ge";
$lang['timesent'] = "tiM3 sEn+";
$lang['errorcreatingpm'] = "erRor cREa+1nG pM! Ple4\$3 tRy 49aiN 1N @ pH3w minU+35";
$lang['writepm'] = "wRIt3 m3\$5Age";
$lang['editpm'] = "eD1+ ME5SagE";
$lang['cannoteditpm'] = "c4nN0T 3d1t ThIS Pm. i+ H@s 4lRe@Dy 8EeN vI3wEd By tH3 R3cIpIEnt or +Eh MeSS49E DOe\$ n0T 3x1s+ 0r i+ I\$ IN4cC3SS18Le 8Y J00";
$lang['cannotviewpm'] = "c@nNO+ ViEw pM. M35Sa93 DOe\$ n0T EX15T OR 1+ i5 iNAcCeSSIbL3 8Y j00";
$lang['pmmessagenumber'] = "m3\$sAgE %s";

$lang['youhavexnewpm'] = "j00 HAvE %d N3W m3sS@9E\$. wOULd J00 l1KE t0 g0 tO Y0ur 1N80X nOw?";
$lang['youhave1newpm'] = "j00 h4V3 1 NeW me\$s49E. W0UlD J00 likE TO 9O +0 YoUr 1nBOX n0W?";
$lang['youhave1newpmand1waiting'] = "j00 H4v3 1 nEw m3\$s493.\n\nY0u 4LsO h@v3 1 M3s\$49E 4W41+1n9 DeLiVErY. +0 rEcEIvE TH1\$ me\$s49E Pl3453 cLe4r S0Me Sp4CE In Y0Ur In8OX.\n\nwOUlD J00 lIkE +0 90 +0 Y0UR In80X nOw?";
$lang['youhave1pmwaiting'] = "j00 H@V3 1 M3S5agE 4w4I+1N9 D3l1VEry. +0 REcEiVe ThiS M3\$s493 Pl3@SE CL34R S0Me \$P4ce 1N YoUr iNbOX.\n\nwOuLd J00 L1k3 +0 G0 tO y0Ur iN8ox Now?";
$lang['youhavexnewpmand1waiting'] = "j00 H4v3 %d N3w mESS@gE\$.\n\nY0U 4LsO H4vE 1 me\$SaGE 4w4I+InG dEL1vErY. t0 ReCeIV3 tH1S MESS4ge PlEASE cLeaR 50m3 Sp@C3 in yOUr 1NboX.\n\nW0ULd J00 l1KE tO Go TO y0uR InB0X nOw?";
$lang['youhavexnewpmandxwaiting'] = "j00 H4VE %d New M35s49E\$.\n\nyOU ALs0 hav3 %d mE\$5AgE\$ 4W@i+1NG d3L1vERY. +0 rEc31Ve ThE\$E mEsS@g3 pLe4S3 cl3@R 50M3 \$p4CE 1n yOur inBOX.\n\nWOuLD J00 L1kE +O 90 +0 y0UR 1NBox N0W?";
$lang['youhave1newpmandxwaiting'] = "j00 h4V3 1 nEW M3Ss49E.\n\nyoU aLsO HAVe %d m3\$SaGe\$ 4W41+1n9 d3L1v3Ry. to R3cEiV3 +H353 Me\$549E\$ Pl34SE Cl34R sOm3 \$P@C3 in yOUR Inb0x.\n\nw0Uld j00 LIke tO 90 +0 y0Ur IN80x nOw?";
$lang['youhavexpmwaiting'] = "j00 h4V3 %d m3\$s49E5 4w@1+IN9 D3liVeRY. T0 r3C31VE ThE\$3 m3S549E\$ PL34S3 cL34r SOm3 5P4C3 in YoUr In80X.\n\nwOulD J00 L1ke To 90 to y0Ur 1N8ox nOW?";

$lang['youdonothaveenoughfreespace'] = "j00 Do nO+ H4V3 3N0U9h Fr3E \$P4Ce TO SeNd TH1\$ m3sS@9e.";
$lang['userhasoptedoutofpm'] = "%s h45 OPt3D 0U+ 0F R3c31VInG PEr\$on@l mE\$s@9Es";
$lang['pmfolderpruningisenabled'] = "pM F0ld3R PrUNiN9 I5 3N4BlED!";
$lang['pmpruneexplanation'] = "tHi\$ Ph0RUm U\$3\$ pm fOLdER PRuN1N9. thE M35s49Es j00 H4vE s+0R3D In YOUr InB0X @ND sEn+ i+eMS\\nPHolD3R\$ 4RE \$uBjECT TO Au+0M4+iC DelE+I0N. Any M3s549e5 J00 W1sh +0 kEeP sH0uLd B3 MoVed t0\\ny0uR \\'SAVeD i+Ems\\' f0Ld3R so tH@T tH3Y 4Re n0+ D3Le+ED.";
$lang['yourpmfoldersare'] = "your Pm F0ld3RS 4RE %s fULL";
$lang['currentmessage'] = "cURR3n+ MEss4G3";
$lang['unreadmessage'] = "uNREaD mE\$s49E";
$lang['readmessage'] = "re4D mESS4gE";
$lang['pmshavebeendisabled'] = "p3rSon@L M3\$5AGe\$ H4v3 83EN d1\$a8L3D 8Y THe Ph0RuM OWneR.";
$lang['adduserstofriendslist'] = "add U\$3RS +o Y0uR Fr13NDs lI\$T TO HaVe +h3M APpE4r 1n 4 drOp d0Wn oN +h3 pM wrI+3 m3SSaG3 p@G3.";

$lang['messagesaved'] = "m3SS@gE S4v3D";
$lang['messagewassuccessfullysavedtodraftsfolder'] = "m3\$S49E w4s 5UCC3\$SFUllY \$4V3D +0 'DRAFts' F0LD3R";
$lang['couldnotsavemessage'] = "cOULD n0+ \$4V3 MEs\$@9e. m@k3 \$ur3 j00 h4V3 3nOU9h 4V4iL@Bl3 FrEe Sp4Ce.";
$lang['pmtooltipxmessages'] = "%s m3SS49e\$";
$lang['pmtooltip1message'] = "1 M3s5493";

$lang['allowusertosendpm'] = "alL0W u53r tO SeNd pERs0n@L M3\$\$49E\$ +0 m3";
$lang['blockuserfromsendingpm'] = "bL0CK u\$3R Phr0m SeNd1NG pEr50N4L m3s5AGe\$ +0 ME";
$lang['yourfoldernamefolderisempty'] = "yOUR %s F0LdER is 3mPtY";
$lang['successfullydeletedselectedmessages'] = "sucC3\$SFUlLy D3Le+Ed \$3L3Ct3D mE\$\$@9e\$";
$lang['successfullyarchivedselectedmessages'] = "suCCE\$SphUlLy @rChIveD \$ELeCtEd m3S\$@935";
$lang['failedtodeleteselectedmessages'] = "f@il3d +0 D3lE+e \$3L3C+ED mE5SaGe\$";
$lang['failedtoarchiveselectedmessages'] = "f41leD +O 4rChIve 5El3C+eD me554GEs";

// Preferences / Profile (user_*.php) ---------------------------------------------

$lang['mycontrols'] = "mY C0NtR0LS";
$lang['myforums'] = "my FOrUmS";
$lang['menu'] = "m3nU";
$lang['userexp_1'] = "u\$E teH M3Nu On tH3 lEF+ +0 m@n4Ge YOuR SEtT1Ngs.";
$lang['userexp_2'] = "<b>u\$ER dET41ls</b> AlL0w\$ J00 To cH4N9E y0ur NAmE, 3m41L 4ddRe\$S @nd P4SSWOrD.";
$lang['userexp_3'] = "<b>uSeR pR0Ph1lE</b> @lL0w\$ J00 +0 3d1T y0Ur U5eR prOfIl3.";
$lang['userexp_4'] = "<b>cH@Nge PAssWOrD</b> @Llows J00 tO cHaNGe Y0uR p4SSW0rD";
$lang['userexp_5'] = "<b>eM41l &amp; PrIv4CY</b> LE+s J00 cH4n93 h0W J00 CAn b3 CoNt@cT3D ON 4Nd 0PhPH tHe FOrUm.";
$lang['userexp_6'] = "<b>f0RuM opt10nS</b> LeTS J00 cH@NgE HoW tHe pHoRuM L0Ok\$ 4Nd w0Rk5.";
$lang['userexp_7'] = "<b>at+4ChmEn+\$</b> 4LL0Ws j00 +O EdI+/delEtE y0Ur 4+t4CHm3NtS.";
$lang['userexp_8'] = "<b>s1gN4TuRe</b> L3+\$ J00 3D1t Y0Ur 51Gna+ur3.";
$lang['userexp_9'] = "<b>rEL4t10NShIpS</b> lE+\$ j00 m@n@Ge y0Ur rEl@TiOn\$H1P w1+h OtHEr uSErs oN TH3 f0Rum.";
$lang['userexp_9'] = "<b>wORd F1LtEr</b> leTS J00 eD1+ Y0ur pEr\$0N4L WOrD ph1lTEr.";
$lang['userexp_10'] = "<b>thrEad SuBScR1Pti0Ns</b> 4llOW\$ J00 +0 m4N49e YouR THr3Ad suBSCrIpTions.";
$lang['userdetails'] = "u\$ER D3+@ilS";
$lang['userprofile'] = "u53R pR0FIlE";
$lang['emailandprivacy'] = "eM41L &amp; PrIv4Cy";
$lang['editsignature'] = "ed1T S19n4+URe";
$lang['norelationshipssetup'] = "j00 h@Ve No UsER rEL4+1ON\$HIps 5E+ Up. 4Dd 4 New us3r bY s34RcHInG 8ElOw.";
$lang['editwordfilter'] = "ed1+ W0rd f1Lt3r";
$lang['userinformation'] = "u53R 1Nf0Rm4T1oN";
$lang['changepassword'] = "cH@Ng3 p4\$sW0Rd";
$lang['currentpasswd'] = "cURr3N+ PaSsw0rd";
$lang['newpasswd'] = "n3w p@ssW0Rd";
$lang['confirmpasswd'] = "conF1Rm p@SSw0RD";
$lang['passwdsdonotmatch'] = "pa\$Sw0RD\$ DO N0t M@+Ch!";
$lang['nicknamerequired'] = "nICknaM3 I\$ rEqU1r3D!";
$lang['emailaddressrequired'] = "eM41L ADdR3S5 1S rEqu1Red!";
$lang['logonnotpermitted'] = "lO90N nOt p3RmittEd. ch0OS3 4nO+hEr!";
$lang['nicknamenotpermitted'] = "n1cKN4mE n0T peRMiTt3D. cHOo\$3 aN0+HER!";
$lang['emailaddressnotpermitted'] = "em@1L @ddr35S No+ pERm1++3D. Ch0Ose @nOThER!";
$lang['emailaddressalreadyinuse'] = "eM4Il adDr3S5 4lRe4Dy 1n USe. cHOo\$3 @No+her!";
$lang['relationshipsupdated'] = "r3l4+10NSh1PS UPD4+3D!";
$lang['relationshipupdatefailed'] = "rEL@t10NsH1P UpD4t3D Fail3D!";
$lang['preferencesupdated'] = "prefErENC3s wEre SUcC3S\$pHuLLY UPd4T3D.";
$lang['userdetails'] = "u\$ER DE+aIl5";
$lang['memberno'] = "memB3R N0.";
$lang['firstname'] = "f1Rs+ naMe";
$lang['lastname'] = "l@s+ nAM3";
$lang['dateofbirth'] = "d@+3 0F 81R+h";
$lang['homepageURL'] = "hOmep@93 UrL";
$lang['profilepicturedimensions'] = "pr0F1Le p1C+uRE (m@X 95X95Px)";
$lang['avatarpicturedimensions'] = "av@+4r pic+uR3 (M4X 15x15PX)";
$lang['invalidattachmentid'] = "inv4L1D 4++acHM3n+. ch3Ck +h4T 1S h@\$N'+ bEeN DElE+Ed.";
$lang['unsupportedimagetype'] = "un\$UPPoRtEd 1mA93 @ttaChM3Nt. j00 C4n oNlY US3 jPG, 9IF 4ND Pn9 im49E @Tt@Chm3N+S F0r yoUr 4v4+@R 4nD ProFIl3 p1CtUR3.";
$lang['selectattachment'] = "sElEc+ 4Tt4CHm3N+";
$lang['pictureURL'] = "p1C+uR3 uRL";
$lang['avatarURL'] = "aV@t4R uRl";
$lang['profilepictureconflict'] = "to U\$3 4N 4+T@cHmENT Phor yOuR pR0F1L3 p1cTUr3 tH3 pIC+URe Url PHiELD MuS+ B3 8L4nK.";
$lang['avatarpictureconflict'] = "t0 U\$3 4N aTT4cHm3N+ FoR Your 4vat4R PiCtUre T3h @V@t4R uRl FiElD muSt b3 8l4nk.";
$lang['attachmenttoolargeforprofilepicture'] = "selECt3d 4+T@CHmEnT 15 +0O l4rGe F0R pR0phiL3 P1C+ure. M4x1Mum D1MENs10NS @re %s";
$lang['attachmenttoolargeforavatarpicture'] = "seL3C+3D 4T+4cHmEn+ I5 TOo larG3 PHor 4V4t@R p1CtUr3. mAxIMuM dimEn\$1On\$ @r3 %s";
$lang['failedtoupdateuserdetails'] = "s0ME Or 4LL 0F YouR Us3R 4cc0UnT d3+AiLS CouLd n0T 83 uPd4+3D. pLE4\$3 trY 4G4iN l4tEr.";
$lang['failedtoupdateuserpreferences'] = "sOm3 oR @lL 0F YoUR US3r Pr3Fer3NcEs c0ULD nOt bE uPd@TED. Pl3@s3 Try @94In lAT3r.";
$lang['emailaddresschanged'] = "eM@Il AdDrE\$5 h4S 83eN ch@N9eD";
$lang['newconfirmationemailsuccess'] = "y0uR EM41l AdDrEs5 H@s BeEN cH4nGed 4Nd 4 n3W C0nF1Rm@tioN eM41L H@S 8EEn \$3n+. plE@S3 cH3ck @Nd R3aD +h3 eM4Il f0R FuRtH3r 1Ns+ruCT10N5.";
$lang['newconfirmationemailfailure'] = "j00 HaVe Ch@NgEd Y0uR em41L 4dDrE\$5, BuT W3 wEr3 UN4bLe to S3Nd 4 coNfIrM@+10N reQu3\$t. Pl34\$3 c0N+4C+ Th3 Ph0RUm Own3R f0R 4\$51\$+AnC3.";
$lang['forumoptions'] = "f0RUM 0p+1On\$";
$lang['notifybyemail'] = "n0+1Fy 8y 3MaIL 0f p0stS +0 M3";
$lang['notifyofnewpm'] = "n0t1PHy By POpUp 0ph NeW pm MeS54GeS tO Me";
$lang['notifyofnewpmemail'] = "n0tiFY 8Y Em41L 0F n3W Pm mE\$S4GE\$ T0 M3";
$lang['daylightsaving'] = "aDju\$t Ph0r dayL19h+ 54vIng";
$lang['autohighinterest'] = "aUT0M4+1C@llY maRk +Hr3@dS 1 po\$t 1n 45 HiGh in+3R3\$+";
$lang['convertimagestolinks'] = "aU+0M4+Ic4Lly C0nVEr+ EmBeddEd iM@gEs 1n Po\$T5 1nTo L1nKs";
$lang['thumbnailsforimageattachments'] = "tHuMbN4Il\$ PH0r 1M49E A+taChM3N+S";
$lang['smallsized'] = "sM@ll 5iZEd";
$lang['mediumsized'] = "m3Dium S1Z3D";
$lang['largesized'] = "l@rG3 s1Z3d";
$lang['globallyignoresigs'] = "gL08allY 1GNOR3 uS3r SIgn4+uReS";
$lang['allowpersonalmessages'] = "aLLOw 0Th3R US3R5 t0 s3nD ME P3Rs0n4L mEs549e\$";
$lang['allowemails'] = "aLlOW O+H3R usERS T0 53nD Me em41Ls v1@ My proFiL3";
$lang['timezonefromGMT'] = "t1me Z0nE";
$lang['postsperpage'] = "pO\$+S p3R p@9E";
$lang['fontsize'] = "f0N+ siZe";
$lang['forumstyle'] = "fORUm S+yl3";
$lang['forumemoticons'] = "f0RuM Em0+iCon\$";
$lang['startpage'] = "sT4R+ P493";
$lang['signaturecontainshtmlcode'] = "s19N4+uRE CoN+41NS hTMl c0De";
$lang['savesignatureforuseonallforums'] = "s@V3 S1Gn4TUrE pHOr u\$3 oN 4ll Ph0RUm\$";
$lang['preferredlang'] = "pREFeRR3d l@Ngu@93";
$lang['donotshowmyageordobtoothers'] = "d0 nO+ 5h0w mY 4Ge or DAt3 0Ph 81R+h +o Oth3r\$";
$lang['showonlymyagetoothers'] = "sh0W 0nLY mY 493 +O 0THer\$";
$lang['showmyageanddobtoothers'] = "sh0w 80+H mY AGe 4ND D4+3 oF 81rTh to 0+hERs";
$lang['showonlymydayandmonthofbirthytoothers'] = "sHOW 0NLy mY d@Y 4Nd M0N+h 0Ph B1rTh +0 OTh3R5";
$lang['listmeontheactiveusersdisplay'] = "l1sT M3 On ThE @C+1vE U\$3rS d1\$Pl4Y";
$lang['browseanonymously'] = "brOws3 F0rUm 4N0NyM0usLY";
$lang['allowfriendstoseemeasonline'] = "bR0W\$3 4nOnYM0uslY, 8u+ 4llOw Phr1ENd\$ TO S3E ME @S 0nL1ne";
$lang['revealspoileronmouseover'] = "rEVe@L Sp01L3rS oN Mou\$e OVeR";
$lang['showspoilersinlightmode'] = "aLw@ys SHOw \$p01L3R5 iN L1gH+ moDE (uSES l1GHtEr phONt c0loUr)";
$lang['resizeimagesandreflowpage'] = "r3\$1zE iM4Ge\$ 4nD REfL0W p@gE T0 pReVen+ h0RiZoN+4l \$CR0lL1nG.";
$lang['showforumstats'] = "sHow F0RuM s+AtS 4+ 8ottoM Of mE554g3 P@Ne";
$lang['usewordfilter'] = "eN@blE w0Rd F1LteR.";
$lang['forceadminwordfilter'] = "f0rCE us3 Of 4DmIn WoRd pHILt3R oN @ll U\$er\$ (InC. 9U35tS)";
$lang['timezone'] = "t1ME z0n3";
$lang['language'] = "l4nGU@Ge";
$lang['emailsettings'] = "em41L and C0Nt4Ct S3+T1Ng\$";
$lang['forumanonymity'] = "f0rUm @N0nymItY S3++1N9\$";
$lang['birthdayanddateofbirth'] = "bir+Hd4y and d4T3 of 81RTh D1Spl4Y";
$lang['includeadminfilter'] = "iNCLuDe 4Dm1n W0Rd PhIlT3R In mY LisT.";
$lang['setforallforums'] = "sE+ f0R AlL f0rUm5?";
$lang['containsinvalidchars'] = "%s c0Nt@1NS inV4l1D ch4R4C+eRS!";
$lang['homepageurlmustincludeschema'] = "homEp@GE UrL muS+ iNcLUdE Http:// ScH3M@.";
$lang['pictureurlmustincludeschema'] = "pictUR3 URl mUSt 1NClUDE H+Tp:// scH3M4.";
$lang['avatarurlmustincludeschema'] = "av@T4r uRl Mu\$t 1NcLuD3 h++P:// ScH3m4.";
$lang['postpage'] = "po\$+ p4gE";
$lang['nohtmltoolbar'] = "n0 H+ml To0L84r";
$lang['displaysimpletoolbar'] = "disPL4Y \$1mPlE h+ml tOOL8aR";
$lang['displaytinymcetoolbar'] = "d1sPL4Y Wys1WyG hTmL +00lb4R";
$lang['displayemoticonspanel'] = "d1spL4Y 3MO+1C0N\$ P4NeL";
$lang['displaysignature'] = "d1\$pL4Y sIGn@tUre";
$lang['disableemoticonsinpostsbydefault'] = "d1s4BLe Em0T1C0NS 1N m3SS49e\$ By Def4ul+";
$lang['automaticallyparseurlsbydefault'] = "auTOma+1c4LLy p@Rse URls iN m3Ss@9e\$ bY dEFAul+";
$lang['postinplaintextbydefault'] = "p0S+ in pL@1n +3X+ 8y D3PH@UL+";
$lang['postinhtmlwithautolinebreaksbydefault'] = "p05+ 1n hTmL witH 4u+O-line-8re4kS 8y DeF@UL+";
$lang['postinhtmlbydefault'] = "pO\$+ IN html BY DEF4ul+";
$lang['privatemessageoptions'] = "pRiv4+3 Me\$s49E oP+I0N\$";
$lang['privatemessageexportoptions'] = "priV4Te Me5s49E 3XP0rt oPt1ON5";
$lang['savepminsentitems'] = "s4V3 4 c0pY 0f E4cH PM i SeND 1N MY \$eNT 1t3MS Ph0LDER";
$lang['includepminreply'] = "inCLUDe mE5S4Ge 80DY WH3N r3PlY1NG +0 pM";
$lang['autoprunemypmfoldersevery'] = "au+O prUnE MY Pm FOldEr\$ EVeRY:";
$lang['friendsonly'] = "fr1eND\$ 0NlY?";
$lang['globalstyles'] = "gl084l S+Yl3s";
$lang['forumstyles'] = "f0rUM \$+yl35";
$lang['youmustenteryourcurrentpasswd'] = "j00 mU\$T en+3R YoUR CuRr3NT p4S5w0Rd";
$lang['youmustenteranewpasswd'] = "j00 MUsT 3NteR @ NEw P@s5W0Rd";
$lang['youmustconfirmyournewpasswd'] = "j00 MUST c0NF1RM y0uR NEw P@\$5WOrD";
$lang['profileentriesmustnotincludehtml'] = "pr0File 3nTrIe\$ muSt N0t 1nCLuDE H+Ml";
$lang['failedtoupdateuserprofile'] = "f@1Led To UpD4+3 us3R pROF1LE";

// Polls (create_poll.php, poll_results.php) ---------------------------------------------

$lang['mustprovideanswergroups'] = "j00 mUS+ prOvIDe s0me 4N\$W3r 9ROuPs";
$lang['mustprovidepolltype'] = "j00 Mu\$t PRoViD3 4 pOll +Yp3";
$lang['mustprovidepollresultsdisplaytype'] = "j00 mU\$t PRoV1D3 RE5ulTs D1Spl@y +yp3";
$lang['mustprovidepollvotetype'] = "j00 MuST prOvid3 4 pOll V0+E +yP3";
$lang['mustprovidepollguestvotetype'] = "j00 Must \$pECIpHY 1PH 9uE5+s shOULd B3 4LloW3D +0 VoTe";
$lang['mustprovidepolloptiontype'] = "j00 MuS+ PR0ViDe 4 POlL OPt10N +yP3";
$lang['mustprovidepollchangevotetype'] = "j00 MuST pRoV1De 4 POlL CH@n93 Vo+E +yp3";
$lang['pollquestioncontainsinvalidhtml'] = "on3 Or mORe 0F Y0Ur PoLl qU3St1ON\$ cON+aIN\$ 1Nv4LiD h+ML.";
$lang['pleaseselectfolder'] = "pl3A\$E \$3LECt 4 F0lD3R";
$lang['mustspecifyvalues1and2'] = "j00 mUS+ SpEC1fY VaLU3s FoR @nSwEr\$ 1 @nD 2";
$lang['tablepollmusthave2groups'] = "t4bUl@R Ph0Rm4+ POlL\$ muSt H4V3 Pr3Ci\$3LY Tw0 v0Ting gRoUpS";
$lang['nomultivotetabulars'] = "t@8Ul4R foRM@T POlLs c@nN0t 8E muLtI-vOTe";
$lang['nomultivotepublic'] = "pu8L1C B4LL0+\$ c4NN0T 83 MUL+1-V0T3";
$lang['abletochangevote'] = "j00 W1lL Be @bL3 +0 cHAngE YoUr v0+3.";
$lang['abletovotemultiple'] = "j00 wIll Be @8l3 +0 vOt3 MUL+1Ple +imES.";
$lang['notabletochangevote'] = "j00 WIlL n0+ BE 48l3 +0 cH4N93 y0uR vo+3.";
$lang['pollvotesrandom'] = "n0T3: p0Ll v0T35 4RE r@Nd0MlY GEnER4+Ed pH0r pR3Vi3W oNly.";
$lang['pollquestion'] = "p0LL QUES+10N";
$lang['possibleanswers'] = "pOsS18L3 4n\$w3RS";
$lang['enterpollquestionexp'] = "entEr tH3 4nSwEr\$ F0R yOur pOlL quE5Ti0N.. If y0Ur P0ll I\$ 4 &quot;Y3\$/n0&quot; QuE\$+1ON, S1MplY En+Er &quot;y3S&quot; FOr 4N5w3R 1 4Nd &quot;n0&quot; FOR @NsweR 2.";
$lang['numberanswers'] = "nO. 4Nsw3Rs";
$lang['answerscontainHTML'] = "ansW3R\$ CON+41N H+Ml (n0+ INClUDInG \$19NA+URE)";
$lang['optionsdisplay'] = "aNsW3RS D15PL4y tYpe";
$lang['optionsdisplayexp'] = "hOW sh0ULd THe @n\$W3R5 b3 Pr3SEn+3D?";
$lang['dropdown'] = "a5 DROp-DowN L1ST(S)";
$lang['radios'] = "a5 4 sErIeS 0PH RaDi0 bU+TOn\$";
$lang['votechanging'] = "votE cHaNg1Ng";
$lang['votechangingexp'] = "c4n 4 pEr\$0N ch4Ng3 h1\$ 0r HeR voT3?";
$lang['guestvoting'] = "gu3\$+ v0Ting";
$lang['guestvotingexp'] = "c@n 9uE\$+s v0T3 iN tHi\$ P0lL?";
$lang['allowmultiplevotes'] = "alloW mULTipL3 vo+3\$";
$lang['pollresults'] = "pOLl r3SUlt5";
$lang['pollresultsexp'] = "h0W w0UlD j00 LiKE +0 D1\$pl@y tHE ReSul+s Of Y0uR PoLL?";
$lang['pollvotetype'] = "pOLL Vot1nG +YpE";
$lang['pollvotesexp'] = "hOW sH0ULd tH3 P0ll 83 cONDuCt3d?";
$lang['pollvoteanon'] = "aNoNyM0u\$ly";
$lang['pollvotepub'] = "pubLIC b4lLo+";
$lang['horizgraph'] = "hORIzOn+4l 9r4PH";
$lang['vertgraph'] = "v3rTiC@L Gr4Ph";
$lang['tablegraph'] = "t4buL4R pHormA+";
$lang['polltypewarning'] = "<b>wArnInG</b>: THis I\$ a pUbliC B@lLo+. YOur n4M3 WIll 83 VI\$18Le nEx+ +0 T3h Op+i0N J00 VoTE PhOr.";
$lang['expiration'] = "exP1R@+IOn";
$lang['showresultswhileopen'] = "d0 J00 w4N+ +O SH0w reSuLT\$ wHil3 +He P0Ll I\$ 0p3N?";
$lang['whenlikepollclose'] = "wheN WoUlD j00 L1kE Y0Ur Poll to AUtOM@TIc@lLY cLo\$3?";
$lang['oneday'] = "on3 D4Y";
$lang['threedays'] = "thrEE D4Y\$";
$lang['sevendays'] = "sevEN D4ys";
$lang['thirtydays'] = "th1R+y d4YS";
$lang['never'] = "nev3R";
$lang['polladditionalmessage'] = "aDdi+i0N@L m3SS@9E (0PtIon@L)";
$lang['polladditionalmessageexp'] = "d0 J00 WaNt tO 1NCLuDe 4n aDdIt10N4L P0St 4Pht3R +hE p0lL?";
$lang['mustspecifypolltoview'] = "j00 MU\$+ SpEC1Fy A P0Ll To V1EW.";
$lang['pollconfirmclose'] = "aRE j00 sUr3 j00 wAN+ +0 clO\$e +3H ph0LLoWIN9 polL?";
$lang['endpoll'] = "eNd poLl";
$lang['nobodyvotedclosedpoll'] = "nO80Dy V0TeD";
$lang['votedisplayopenpoll'] = "%s @ND %s H4vE V0+3D.";
$lang['votedisplayclosedpoll'] = "%s @nd %s v0T3d.";
$lang['nousersvoted'] = "n0 U\$eR\$";
$lang['oneuservoted'] = "1 u\$eR";
$lang['xusersvoted'] = "%s uS3R\$";
$lang['noguestsvoted'] = "nO GuEs+S";
$lang['oneguestvoted'] = "1 Gu3\$t";
$lang['xguestsvoted'] = "%s GU3Sts";
$lang['pollhasended'] = "p0LL h4S 3Nd3d";
$lang['youvotedforpolloptionsondate'] = "j00 V0tEd F0R %s 0n %s";
$lang['thisisapoll'] = "tH15 i\$ 4 p0ll. cLIck to V1ew R3\$UlTS.";
$lang['editpoll'] = "ed1T p0ll";
$lang['results'] = "resUlTS";
$lang['resultdetails'] = "rEsUl+ DEtaIlS";
$lang['changevote'] = "cH@NgE vOtE";
$lang['pollshavebeendisabled'] = "pollS H4vE 833N D1S@8L3D bY Th3 f0RUm 0wN3r.";
$lang['answertext'] = "aN\$WEr +Ex+";
$lang['answergroup'] = "an\$w3r groUP";
$lang['previewvotingform'] = "preVI3w v0+1n9 f0rM";
$lang['viewbypolloption'] = "v13W By PoLL Op+IoN";
$lang['viewbyuser'] = "v13W BY u5ER";

// Profiles (profile.php) ----------------------------------------------

$lang['editprofile'] = "edIT pR0PhIl3";
$lang['profileupdated'] = "pROF1L3 UPdA+ED.";
$lang['profilesnotsetup'] = "tH3 ForuM 0WNer hA\$ nOt \$3t up PR0F1LES.";
$lang['ignoreduser'] = "igNOrED us3R";
$lang['lastvisit'] = "l@\$T V15it";
$lang['userslocaltime'] = "us3R'\$ Loc4l t1M3";
$lang['userstatus'] = "s+4+us";
$lang['useractive'] = "oNl1ne";
$lang['userinactive'] = "in@Ct1V3 / 0pHFlinE";
$lang['totaltimeinforum'] = "to+4L Time";
$lang['longesttimeinforum'] = "l0N9es+ se\$SION";
$lang['sendemail'] = "s3nD eM41L";
$lang['sendpm'] = "senD pM";
$lang['visithomepage'] = "v15iT H0M3P493";
$lang['age'] = "ag3";
$lang['aged'] = "a9eD";
$lang['birthday'] = "bIR+hDaY";
$lang['registered'] = "r3gI\$+3REd";
$lang['findpostsmadebyuser'] = "f1nD pO\$+S M4d3 By %s";
$lang['findpostsmadebyme'] = "f1nD P0S+s M4dE 8Y mE";
$lang['profilenotavailable'] = "pr0phil3 nOT av4Il48lE.";
$lang['userprofileempty'] = "thi\$ U\$ER hAs N0+ PhIlLEd iN +h31R pROpH1Le 0r i+ i5 \$3+ T0 Pr1VaT3.";

// Registration (register.php) -----------------------------------------

$lang['newuserregistrationsarenotpermitted'] = "sORrY, NeW UsEr rEg15+R4+10Ns 4R3 N0t 4Ll0Wed R19h+ N0W. pL3aS3 cH3cK 8ACk LAteR.";
$lang['usernameinvalidchars'] = "u\$ERNam3 c4N 0nLy conT@1N 4-Z, 0-9, _ - Ch@r@C+3Rs";
$lang['usernametooshort'] = "us3Rn@mE MU5+ Be 4 MiNimUM OF 2 ChAr4Ct3RS L0N9";
$lang['usernametoolong'] = "u\$3Rn@m3 mUST 8E 4 m@XImuM Of 15 cH4R4cT3R\$ lONG";
$lang['usernamerequired'] = "a L090N n4M3 1S rEqU1r3D";
$lang['passwdmustnotcontainHTML'] = "pa55WOrD muSt N0t con+41n h+ml +@G\$";
$lang['passwordinvalidchars'] = "p4SSW0rD CAn oNly COn+@1N A-z, 0-9, _ - cH4R4cTeR\$";
$lang['passwdtooshort'] = "p4s\$wORd MuS+ BE 4 m1nIMuM OF 6 Ch@R@c+3r\$ LOng";
$lang['passwdrequired'] = "a P@SSW0rD 1S R3Qu1REd";
$lang['confirmationpasswdrequired'] = "a c0NpHIrM@+1on P@sSwORd iS reQU1r3D";
$lang['nicknamerequired'] = "a N1CkN4Me i\$ REQuIrEd";
$lang['emailrequired'] = "an 3M@Il AddRE\$s Is ReQU1R3D";
$lang['passwdsdonotmatch'] = "pASSworDs D0 nOt m@tCh";
$lang['usernamesameaspasswd'] = "u\$ErN4M3 AnD P4SSW0Rd mu\$+ B3 DifPH3R3n+";
$lang['usernameexists'] = "sorRY, 4 Us3R w1tH tHaT N4Me 4Lr34Dy EXI\$+S";
$lang['successfullycreateduseraccount'] = "sucC3\$SphUlLy cRe4+3d USeR 4Cc0UN+";
$lang['useraccountcreatedconfirmfailed'] = "y0uR u5er 4Cc0UNT h@\$ bE3N CR3@tED 8U+ +h3 r3qu1R3D c0nFirM4TI0N 3mAiL w4S n0t S3N+. Pl34\$3 coN+4C+ +3H pH0RuM oWN3r +0 ReCTIfY +H1S. In tHI\$ Me4Nt1mE pL3453 Cl1Ck +H3 C0n+1Nu3 bU++0n +O L091N 1N.";
$lang['useraccountcreatedconfirmsuccess'] = "yOUR US3R @CcOun+ hAS 8Een Cr3At3D bu+ beF0R3 j00 c@N S+4R+ p0St1NG J00 muSt cONPh1Rm y0UR EM41l aDDr3\$s. Pl3A\$3 cHEcK Y0ur eM41l foR 4 l1NK Th4T W1Ll 4LlOw J00 +0 C0nfIRm y0Ur @dDrESS.";
$lang['useraccountcreated'] = "yOUr u53r @cCOUnT h@S bE3N Cr34+ed succ3\$SpHUlLy! cLiCK T3h c0N+inUe 8U+t0N 83L0w +0 L0gIn";
$lang['errorcreatinguserrecord'] = "erroR cRe4+1ng u\$3r rECoRD";
$lang['userregistration'] = "us3R ReG15+r@tIOn";
$lang['registrationinformationrequired'] = "regi\$Tr4T1oN 1NFoRm4+1On (reQUiR3d)";
$lang['profileinformationoptional'] = "pROPh1L3 iNf0RMaTiOn (OP+1On4L)";
$lang['preferencesoptional'] = "pR3FEreNces (0PTiOn4L)";
$lang['register'] = "rE9ISt3R";
$lang['rememberpasswd'] = "rem3M8Er p4S5W0Rd";
$lang['birthdayrequired'] = "d4+3 0pH 81Rth 1S rEquIr3D 0R i\$ 1NV4lID";
$lang['alwaysnotifymeofrepliestome'] = "notIFy oN r3PlY +0 m3";
$lang['notifyonnewprivatemessage'] = "n0+1fy on NEW PRiV4+E m35S49E";
$lang['popuponnewprivatemessage'] = "p0P uP On nEw pRiV4+3 Me\$SaGe";
$lang['automatichighinterestonpost'] = "au+0M@TIc H1Gh iNt3Re\$+ 0n p0ST";
$lang['confirmpassword'] = "cONFiRm p4\$5W0rD";
$lang['invalidemailaddressformat'] = "inv@L1D em4Il AdDrE\$5 fORm4+";
$lang['moreoptionsavailable'] = "m0r3 PrOFil3 4ND prEF3R3NcE Op+i0NS 4R3 4V41L4bL3 0nC3 j00 rEGi\$T3R";
$lang['textcaptchaconfirmation'] = "cONPhIrM@t1on";
$lang['textcaptchaexplain'] = "t0 +3H RIgH+ is @ +EXT-C4PTcHa 1M493. pL34Se +yPe +H3 cODe j00 c@n s3e 1n t3H 1M4gE 1N+O T3h InPuT PHielD 8ElOW 1T.";
$lang['textcaptchaimgtip'] = "th1\$ I5 4 C4P+cH4-p1cTuRe. 1+ is u\$eD t0 PrEVEn+ 4u+0M4t1C REgI\$+rA+i0N";
$lang['textcaptchamissingkey'] = "a coNFIrm@TI0n C0DE Is ReQU1R3D.";
$lang['textcaptchaverificationfailed'] = "t3X+-c4P+CH4 V3R1Fic4+I0n C0dE w@S 1NcorR3cT. Pl3ASe r3-EN+ER 1+.";
$lang['forumrules'] = "fORUM rUl3\$";
$lang['forumrulesnotification'] = "iN ORdeR +0 pR0c33D, j00 mUS+ AgR33 W1+H +HE f0Ll0w1NG Rule5";
$lang['forumrulescheckbox'] = "i hAVe R34d, @ND 4Gr33 To Ab1De 8Y TEh f0rUm RuL3s.";
$lang['youmustagreetotheforumrules'] = "j00 MU\$+ aGr33 To TeH F0RuM ruLe\$ B3F0R3 j00 c@n COnTInU3.";

// Recent visitors list  (visitor_log.php) -----------------------------

$lang['member'] = "mEMbER";
$lang['searchforusernotinlist'] = "se4rch phOr 4 U\$eR nOT In li\$t";
$lang['yoursearchdidnotreturnanymatches'] = "youR \$34Rch dId No+ R3tuRN @nY m4+cH3\$. Try SImPLifY1ng yOUr \$34rCh P4r4M3+Er\$ 4Nd +Ry aG41n.";
$lang['hiderowswithemptyornullvalues'] = "h1dE R0w\$ W1tH 3MPtY 0R nuLl v4LUe\$ In S3lECteD C0lUMNs";
$lang['showregisteredusersonly'] = "sHOW R39IsT3ReD uSEr\$ 0NLy (hId3 9U3\$Ts)";

// Relationships (user_rel.php) ----------------------------------------

$lang['relationships'] = "rEL@t10N\$h1Ps";
$lang['userrelationship'] = "u53r ReL4+10NsH1p";
$lang['userrelationships'] = "us3r R3L4+1on\$H1Ps";
$lang['failedtoremoveselectedrelationships'] = "f4iL3D +0 rEmOV3 \$elec+3D ReL4+1On\$H1p";
$lang['friends'] = "fR1EnD\$";
$lang['ignoredcompletely'] = "i9NOr3D CompLe+eLY";
$lang['relationship'] = "rELA+10nSHiP";
$lang['restorenickname'] = "rEsToR3 u5eR'5 NIcKn@m3";
$lang['friend_exp'] = "u53R's p0Sts m4rKed Wi+H A &quot;pHR1enD&quot; 1COn.";
$lang['normal_exp'] = "us3R's Pos+S @Pp3Ar 4s NoRm4L.";
$lang['ignore_exp'] = "u\$eR'S PoS+\$ Ar3 H1dDEn.";
$lang['ignore_completely_exp'] = "tHRe4DS 4nD pO\$+S +0 0r Fr0M Us3R w1Ll 4ppE4r d3LeT3D.";
$lang['display'] = "d1sPL@y";
$lang['displaysig_exp'] = "us3R'S s19N@TuRE I\$ d1\$pL@Y3D 0N +H31R PO\$TS.";
$lang['hidesig_exp'] = "us3R'\$ sigN4+uRE I\$ HiDDeN 0N +H31R PO\$TS.";
$lang['cannotignoremod'] = "j00 c4nN0t IgN0r3 +H1S uSER, 4S +H3Y @r3 @ M0d3R@tOR.";
$lang['previewsignature'] = "prEV13W 519Na+UR3";

// Search (search.php) -------------------------------------------------

$lang['searchresults'] = "sE4RcH r3SUlT\$";
$lang['usernamenotfound'] = "t3H u5ERn4m3 j00 \$PeC1pHIeD IN +H3 to oR FROm PhIeLD wA\$ n0T pHOUnD.";
$lang['notexttosearchfor'] = "oN3 0R aLl 0Ph Y0uR S34RcH k3YwORdS w3R3 Inv4LiD. SeaRcH K3Yw0RdS mUS+ 8E n0 sH0Rt3R +h4N %d cH@R4c+Er\$, n0 lONGeR th@N %d cHar@Ct3r\$ 4ND Mu\$+ n0T aPp34R IN ThE %s";
$lang['keywordscontainingerrors'] = "keywoRdS CONt4InInG ErROr5: %s";
$lang['mysqlstopwordlist'] = "mY5QL 5+0pW0Rd l1\$+";
$lang['foundzeromatches'] = "f0und: 0 M4+cHes";
$lang['found'] = "f0UNd";
$lang['matches'] = "m4+CHes";
$lang['prevpage'] = "pR3VIoUS P@ge";
$lang['findmore'] = "f1nD m0RE";
$lang['searchmessages'] = "s3@RCh m3SS@9E5";
$lang['searchdiscussions'] = "s34RcH d1\$cU\$S10Ns";
$lang['find'] = "f1ND";
$lang['additionalcriteria'] = "addiTIOn@L Cr1T3Ri4";
$lang['searchbyuser'] = "s34RcH 8Y U\$eR (OP+1On4L)";
$lang['folderbrackets_s'] = "f0ldEr(\$)";
$lang['postedfrom'] = "pos+3D phR0m";
$lang['postedto'] = "pOs+3D +0";
$lang['today'] = "t0d4Y";
$lang['yesterday'] = "ye5+ErDay";
$lang['daybeforeyesterday'] = "d4Y 8ePhOr3 Y3\$+3Rd@Y";
$lang['weekago'] = "%s wEek 49O";
$lang['weeksago'] = "%s WEeKS 49O";
$lang['monthago'] = "%s MON+H Ag0";
$lang['monthsago'] = "%s MOn+hs 49O";
$lang['yearago'] = "%s y34R 4G0";
$lang['beginningoftime'] = "b391Nnin9 oF TimE";
$lang['now'] = "n0w";
$lang['lastpostdate'] = "l4\$T p0S+ dA+3";
$lang['numberofreplies'] = "numB3R oF repLie\$";
$lang['foldername'] = "f0LDer naM3";
$lang['authorname'] = "aU+Hor n4Me";
$lang['decendingorder'] = "n3W3st PhIrsT";
$lang['ascendingorder'] = "old3\$+ Ph1RsT";
$lang['keywords'] = "keyWOrDS";
$lang['sortby'] = "sor+ bY";
$lang['sortdir'] = "sorT d1R";
$lang['sortresults'] = "sOR+ r3SULtS";
$lang['groupbythread'] = "gRoUp 8y tHr34D";
$lang['postsfromuser'] = "p0STs phr0m USEr";
$lang['poststouser'] = "p0StS To U53r";
$lang['poststoandfromuser'] = "p0\$Ts +0 anD fRoM uS3R";
$lang['searchfrequencyerror'] = "j00 CAn ONlY sE4Rch OnC3 Ev3Ry %s s3coNds. PL34Se +Ry Ag41n L@t3R.";
$lang['searchsuccessfullycompleted'] = "s3@RcH suCC3ssfUlly cOMpLeTed. %s";
$lang['clickheretoviewresults'] = "cl1CK hERe To VieW r3\$uL+5.";

// Search Popup (search_popup.php) -------------------------------------

$lang['select'] = "selEcT";
$lang['searchforthread'] = "seArCH F0r +hRe4D";
$lang['mustspecifytypeofsearch'] = "j00 MuST SpecIfY +yP3 of \$34RcH +o pErF0RM";
$lang['unkownsearchtypespecified'] = "unKNOwN \$E4RcH tyPe \$P3C1fIeD";
$lang['mustentersomethingtosearchfor'] = "j00 MuS+ 3n+3r s0ME+HiNg To S34rCh pHOr";

// Start page (start_left.php) -----------------------------------------

$lang['recentthreads'] = "r3cEN+ +HrE4D\$";
$lang['startreading'] = "s+@rT ReAdInG";
$lang['threadoptions'] = "tHRe4D 0pTiON\$";
$lang['editthreadoptions'] = "ed1T ThReAd OPtiOns";
$lang['morevisitors'] = "m0R3 vI\$1tOrs";
$lang['forthcomingbirthdays'] = "f0r+HcoMinG bIrthd@ys";

// Start page (start_main.php) -----------------------------------------

$lang['editstartpage_help'] = "j00 c4N 3D1t +h15 P@ge fR0M Th3 aDMiN In+erf4Ce";

// Thread navigation (thread_list.php) ---------------------------------

$lang['newdiscussion'] = "new d1\$Cu\$51ON";
$lang['createpoll'] = "cR3@Te p0Ll";
$lang['search'] = "se4RCH";
$lang['searchagain'] = "sE@RcH 4GaIn";
$lang['alldiscussions'] = "aLL Di\$cUSsiOn\$";
$lang['unreaddiscussions'] = "unr34D d1SCuSS1On\$";
$lang['unreadtome'] = "uNrEaD &quot;to: m3&quot;";
$lang['todaysdiscussions'] = "tOD4Y'\$ Di\$cUSS10Ns";
$lang['2daysback'] = "2 D4Y\$ B4Ck";
$lang['7daysback'] = "7 D4Y\$ b4Ck";
$lang['highinterest'] = "hI9H iN+ErE\$+";
$lang['unreadhighinterest'] = "unrEAd h1Gh 1n+eRE\$t";
$lang['iverecentlyseen'] = "i'V3 rEcEN+Ly \$33N";
$lang['iveignored'] = "i'v3 iGn0REd";
$lang['byignoredusers'] = "by 19NoR3D U\$3rs";
$lang['ivesubscribedto'] = "i'V3 suB5cr183D To";
$lang['startedbyfriend'] = "sT@R+3d By FR1eNd";
$lang['unreadstartedbyfriend'] = "uNrE4d s+D BY PHR1enD";
$lang['startedbyme'] = "s+4r+3D By Me";
$lang['unreadtoday'] = "uNR34D +od4Y";
$lang['deletedthreads'] = "dEL3T3D ThR34Ds";
$lang['goexcmark'] = "go!";
$lang['folderinterest'] = "f0lDeR iNt3R3S+";
$lang['postnew'] = "p05T nEW";
$lang['currentthread'] = "cURrENt Thr34D";
$lang['highinterest'] = "higH in+EReS+";
$lang['markasread'] = "m@rK 4s R34D";
$lang['next50discussions'] = "n3x+ 50 d1SCUss1On5";
$lang['visiblediscussions'] = "vis18LE DiScuS\$1ONs";
$lang['selectedfolder'] = "sel3C+3d f0ld3R";
$lang['navigate'] = "n4v19A+E";
$lang['couldnotretrievefolderinformation'] = "th3re 4RE NO folD3R\$ 4V41LAblE.";
$lang['nomessagesinthiscategory'] = "n0 meSS4gEs 1N +h1s Ca+e9ORy. plE@Se S3l3C+ 4N0+HeR, or %s F0r All +hRe4Ds";
$lang['clickhere'] = "cLicK H3rE";
$lang['prev50threads'] = "pr3Vi0US 50 tHr34d\$";
$lang['next50threads'] = "n3x+ 50 tHR34ds";
$lang['nextxthreads'] = "n3xT %s thrE4Ds";
$lang['threadstartedbytooltip'] = "tHRE4d #%s 5+4r+3D BY %s. V1EwEd %s";
$lang['threadviewedonetime'] = "1 T1Me";
$lang['threadviewedtimes'] = "%d +1M3\$";
$lang['unreadthread'] = "uNrEaD tHre4D";
$lang['readthread'] = "r34D +hrE4D";
$lang['unreadmessages'] = "unr34d m3\$S493S";
$lang['subscribed'] = "su85Cr18Ed";
$lang['ignorethisfolder'] = "iGnORe +h1S pH0lD3r";
$lang['stopignoringthisfolder'] = "s+OP iGn0Rin9 +HiS pHOldEr";
$lang['stickythreads'] = "s+1CKy Thr34D\$";
$lang['mostunreadposts'] = "m0S+ UNreaD PO\$tS";
$lang['onenew'] = "%d neW";
$lang['manynew'] = "%d n3W";
$lang['onenewoflength'] = "%d nEW 0F %d";
$lang['manynewoflength'] = "%d NEw Oph %d";
$lang['ignorefolderconfirm'] = "ar3 j00 \$UrE J00 w4N+ +O 19NOrE tHi\$ f0LD3R?";
$lang['unignorefolderconfirm'] = "aRE j00 sUR3 J00 WaNt t0 S+0P igN0r1ng tH1S pholDEr?";
$lang['confirmmarkasread'] = "ar3 j00 5urE J00 w4N+ +0 M@rK THe \$eleC+ed +hr3@Ds @S rE@d?";
$lang['successfullymarkreadselectedthreads'] = "sUcc3SSfULlY M@rkED \$3l3CT3D THr3@dS 45 Re4d";
$lang['failedtomarkselectedthreadsasread'] = "fA1L3d t0 m4rk \$3LEctED tHR34d\$ 45 re4D";
$lang['gotofirstpostinthread'] = "go T0 Ph1R5+ p0s+ IN ThRE@d";
$lang['gotolastpostinthread'] = "g0 T0 La\$T p05+ in +Hr34d";
$lang['viewmessagesinthisfolderonly'] = "v13W m3sS4G3\$ 1N tH1\$ PH0lDEr 0NLY";
$lang['shownext50threads'] = "sh0W n3Xt 50 +hreAd\$";
$lang['showprev50threads'] = "shOW pr3v1OUs 50 +HRe4D\$";
$lang['createnewdiscussioninthisfolder'] = "cR34+e NEw d1ScuS5I0n 1N thi\$ FOLD3r";
$lang['nomessages'] = "nO m3\$549E\$";

// HTML toolbar (htmltools.inc.php) ------------------------------------
$lang['bold'] = "bOld";
$lang['italic'] = "i+4lIC";
$lang['underline'] = "uND3Rl1NE";
$lang['strikethrough'] = "s+r1K3+HR0u9H";
$lang['superscript'] = "suPEr5cRip+";
$lang['subscript'] = "sU8\$Cr1Pt";
$lang['leftalign'] = "l3PhT-4LigN";
$lang['center'] = "c3n+3R";
$lang['rightalign'] = "rIght-@l19N";
$lang['numberedlist'] = "nUm83ReD l1\$+";
$lang['list'] = "l1ST";
$lang['indenttext'] = "iNDenT TexT";
$lang['code'] = "cODE";
$lang['quote'] = "quoTe";
$lang['unquote'] = "uNQuo+3";
$lang['spoiler'] = "sP0ILeR";
$lang['horizontalrule'] = "h0rIZ0Nt4L ruLE";
$lang['image'] = "im49E";
$lang['hyperlink'] = "hYPERlINK";
$lang['noemoticons'] = "d1SaBlE eM0T1coN\$";
$lang['fontface'] = "f0nT ph@c3";
$lang['size'] = "s1zE";
$lang['colour'] = "cOL0Ur";
$lang['red'] = "rED";
$lang['orange'] = "oRaN9E";
$lang['yellow'] = "yeLLoW";
$lang['green'] = "greEn";
$lang['blue'] = "bLUE";
$lang['indigo'] = "indIg0";
$lang['violet'] = "vioL3T";
$lang['white'] = "whi+3";
$lang['black'] = "bl4cK";
$lang['grey'] = "gR3Y";
$lang['pink'] = "piNk";
$lang['lightgreen'] = "liGH+ greeN";
$lang['lightblue'] = "ligH+ 8lUe";

// Forum Stats (messages.inc.php - messages_forum_stats()) -------------

$lang['forumstats'] = "fORUm \$T@+S";
$lang['usersactiveinthepasttimeperiod'] = "%s 4c+Iv3 In +h3 PASt %s. %s";

$lang['numactiveguests'] = "<b>%s</b> 9u3\$t\$";
$lang['oneactiveguest'] = "<b>1</b> GU3S+";
$lang['numactivemembers'] = "<b>%s</b> m3M8Er\$";
$lang['oneactivemember'] = "<b>1</b> m3M83R";
$lang['numactiveanonymousmembers'] = "<b>%s</b> 4N0NyM0U5 Memb3rS";
$lang['oneactiveanonymousmember'] = "<b>1</b> @NOnyMouS m3mbEr";

$lang['numthreadscreated'] = "<b>%s</b> +HR3@DS";
$lang['onethreadcreated'] = "<b>1</b> +HrE@d";
$lang['numpostscreated'] = "<b>%s</b> p0st\$";
$lang['onepostcreated'] = "<b>1</b> p0sT";

$lang['younormal'] = "j00";
$lang['youinvisible'] = "j00 (InV1S1Bl3)";
$lang['viewcompletelist'] = "v13W CompL3+e L1\$T";
$lang['ourmembershavemadeatotalofnumthreadsandnumposts'] = "our M3MbErs h@V3 M4DE 4 TO+4L OF %s 4nD %s.";
$lang['longestthreadisthreadnamewithnumposts'] = "lOn93St tHr34D 1S <b>%s</b> W1+H %s.";
$lang['therehavebeenxpostsmadeinthelastsixtyminutes'] = "tH3RE H4V3 83en <b>%s</b> po\$+S m4d3 iN +He L@St 60 m1nUt3s.";
$lang['therehasbeenonepostmadeinthelastsxityminutes'] = "theRe h4s BeEN <b>1</b> P0St m4D3 IN ThE l4St 60 m1nu+3\$.";
$lang['mostpostsevermadeinasinglesixtyminuteperiodwasnumposts'] = "mos+ pO\$+S eVEr M4D3 1n A S1n9LE 60 m1Nu+E P3rI0d 1\$ <b>%s</b> oN %s.";
$lang['wehavenumregisteredmembersandthenewestmemberismembername'] = "w3 H@Ve <b>%s</b> R3Gi\$t3Red mEmBErS @nd +H3 NEwe\$+ m3m83R 1\$ <b>%s</b>.";
$lang['wehavenumregisteredmember'] = "w3 H4v3 %s Regi\$T3R3d m3M83r\$.";
$lang['wehaveoneregisteredmember'] = "w3 h4Ve 0N3 r3G1\$+3ReD m3MBeR.";
$lang['mostuserseveronlinewasnumondate'] = "m0sT u\$Er5 eV3R 0NLiNe W4s <b>%s</b> ON %s.";
$lang['statsdisplaychanged'] = "sta+s D15pl@Y cH@N9eD";

// Thread Options (thread_options.php) ---------------------------------

$lang['updatessavedsuccessfully'] = "uPd@+E\$ \$4V3d SUcC35SFUlLy";
$lang['useroptions'] = "u5er OptION\$";
$lang['markedasread'] = "m4rKeD @S rE4D";
$lang['postsoutof'] = "p0\$tS 0U+ 0F";
$lang['interest'] = "inT3r3S+";
$lang['closedforposting'] = "cLO5Ed F0r pO\$+1ng";
$lang['locktitleandfolder'] = "l0ck T1+Le 4Nd F0Ld3R";
$lang['deletepostsinthreadbyuser'] = "delET3 pO\$+S 1N +Hr34D 8Y U\$3R";
$lang['deletethread'] = "dEL3Te ThR3@D";
$lang['permenantlydelete'] = "pErManeN+LY DeLe+E";
$lang['movetodeleteditems'] = "m0v3 tO D3L3TEd +hR3adS";
$lang['undeletethread'] = "uND3LE+3 tHr34D";
$lang['threaddeletedpermenantly'] = "tHr3@D d3Le+ed pErM@n3N+Ly. c4Nn0T uNd3L3+3.";
$lang['markasunread'] = "m4Rk @\$ UnRe4D";
$lang['makethreadsticky'] = "m4K3 +HrE4d \$+1Cky";
$lang['threareadstatusupdated'] = "tHRe4D re4D \$T4+U\$ upD@TeD SuCcEssPhUlLY";
$lang['interestupdated'] = "tHR3@d 1N+3Re5+ s+4+U5 Upd4+Ed 5UcC3SSfULly";
$lang['failedtoupdatethreadreadstatus'] = "f41L3D TO UpDaT3 +hr34D Re4d S+@tUS";
$lang['failedtoupdatethreadinterest'] = "f4IleD +0 UpD4+e +HrE4D 1nT3R3ST";
$lang['failedtorenamethread'] = "f@1led to ReNAmE +hr34D";
$lang['failedtomovethread'] = "f41L3d +0 mOV3 +hRE4d +O \$P3c1F1ed PhOlDER";
$lang['failedtoupdatethreadstickystatus'] = "f4iLED +O Upd@+E THr34D \$TIcky 5T4tuS";
$lang['failedtoupdatethreadclosedstatus'] = "f@1L3d T0 UPd4T3 +hre4D Cl0\$Ed s+4+Us";
$lang['failedtoupdatethreadlockstatus'] = "f41L3d +0 uPD4+E +HrE@D LOcK S+4tuS";
$lang['failedtodeletepostsbyuser'] = "f4iL3D +0 dELE+3 pO\$+S BY SeLecTeD uSER";
$lang['failedtodeletethread'] = "f41L3D +0 dEl3+3 +HRe4D.";
$lang['failedtoundeletethread'] = "f41LEd tO uN-D3Le+E ThR34d";

// Dictionary (dictionary.php) -----------------------------------------

$lang['dictionary'] = "d1ct10N@rY";
$lang['spellcheck'] = "sPELl cH3CK";
$lang['notindictionary'] = "n0t 1n dICtI0N@rY";
$lang['changeto'] = "ch@NgE T0";
$lang['restartspellcheck'] = "rE\$+ArT";
$lang['cancelchanges'] = "c4nCEl Ch@n9e5";
$lang['initialisingdotdotdot'] = "iN1TI4LI\$1N9...";
$lang['spellcheckcomplete'] = "speLl CHeCk 1\$ COmPL3t3. To R3\$T@R+ Sp3LL CheCK cl1Ck Re5t@R+ 8U+TOn 8eL0W.";
$lang['spellcheck'] = "sP3LL cheCK";
$lang['noformobj'] = "n0 F0Rm o8JEcT SpECipHieD PhOr r3+UrN +3Xt";
$lang['bodytext'] = "b0dY +eX+";
$lang['ignore'] = "i9NOr3";
$lang['ignoreall'] = "iGnOr3 4lL";
$lang['change'] = "ch4n9E";
$lang['changeall'] = "ch@NGe 4LL";
$lang['add'] = "add";
$lang['suggest'] = "sug935+";
$lang['nosuggestions'] = "(No \$uGGeS+10Ns)";
$lang['cancel'] = "c4NceL";
$lang['dictionarynotinstalled'] = "n0 dIcT10n@Ry h4\$ Be3N 1n\$+@Ll3D. plE4Se c0Nt4C+ TeH phORum 0Wn3R t0 rEmEDy +H1s.";

// Permissions keys ----------------------------------------------------

$lang['postreadingallowed'] = "pos+ rE4D1nG 4LlOWEd";
$lang['postcreationallowed'] = "p0\$T CR3@TiOn @Ll0WED";
$lang['threadcreationallowed'] = "thRE4d CR34+10n aLl0WEd";
$lang['posteditingallowed'] = "pO\$T 3Di+1Ng @LloW3D";
$lang['postdeletionallowed'] = "p0\$T D3Le+1oN 4lL0Wed";
$lang['attachmentsallowed'] = "a++AchM3N+5 4Ll0Wed";
$lang['htmlpostingallowed'] = "h+ML pO\$T1NG AlL0wEd";
$lang['signatureallowed'] = "sigN4+ure 4llOwEd";
$lang['guestaccessallowed'] = "gu3s+ 4Cc3S5 4lLoWeD";
$lang['postapprovalrequired'] = "p0st 4pPr0V4l rEquiReD";

// RSS feeds gubbins

$lang['rssfeed'] = "rsS FeED";
$lang['every30mins'] = "eV3Ry 30 M1nuTe\$";
$lang['onceanhour'] = "onc3 4N H0Ur";
$lang['every6hours'] = "eVERy 6 HOuR5";
$lang['every12hours'] = "eVeRY 12 HOUrS";
$lang['onceaday'] = "oncE @ D4y";
$lang['onceaweek'] = "onc3 4 wEEK";
$lang['rssfeeds'] = "r\$\$ pH33D\$";
$lang['feedname'] = "fe3D n4M3";
$lang['feedfoldername'] = "f3eD F0lD3r n@M3";
$lang['feedlocation'] = "f33D L0c4T10n";
$lang['threadtitleprefix'] = "tHr3AD tI+le pR3FiX";
$lang['feednameandlocation'] = "f33d N4m3 4nD LOc4+10n";
$lang['feedsettings'] = "fe3D S3++1Ng\$";
$lang['updatefrequency'] = "uPd4t3 fR3qUEnCy";
$lang['rssclicktoreadarticle'] = "cl1cK h3re to r34D +h1S 4RTiClE";
$lang['addnewfeed'] = "aDD n3W fEeD";
$lang['editfeed'] = "ediT F33D";
$lang['feeduseraccount'] = "fE3D US3R aCc0UnT";
$lang['noexistingfeeds'] = "n0 3XI5T1Ng rS5 fEEDs F0uNd. +o @dd 4 FE3D ClICk +H3 '@Dd nEW' 8U++On 8ELoW";
$lang['rssfeedhelp'] = "h3rE j00 c4N S3tUP \$ome rSS ph3Ed\$ F0R 4u+OM4tIC Pr0P494T1On 1N+0 y0UR f0rUm. +Eh i+em\$ PHr0m th3 rSS pH3ed5 J00 AdD W1Ll b3 cR3@t3D 4s +Hr34Ds wHiCH USeR\$ C4n R3Ply to @\$ iF tH3y w3RE NoRm4l Po\$+5. th3 rsS FE3d mu\$+ BE Acce5518Le vI4 h++P oR I+ w1Ll nO+ W0rK.";
$lang['mustspecifyrssfeedname'] = "mu\$+ \$PeciPhy R\$5 F3Ed N@Me";
$lang['mustspecifyrssfeeduseraccount'] = "mU\$+ \$pecIfY rS\$ fEed U\$Er @Cc0UnT";
$lang['mustspecifyrssfeedfolder'] = "mu\$+ SPeCiFy rSS FEED f0Ld3R";
$lang['mustspecifyrssfeedurl'] = "mU5T sPECiFy Rss pH33D URl";
$lang['mustspecifyrssfeedupdatefrequency'] = "mU5+ SPeC1Fy r\$S Fe3D upD4+3 phReQUeNcY";
$lang['unknownrssuseraccount'] = "unkNOwN rSs us3R aCc0UN+";
$lang['rssfeedsupportshttpurlsonly'] = "rSS ph3Ed \$uPP0RtS h++p UrlS onlY. \$eCUr3 pHEeD5 (HtTpS://) Ar3 N0+ SuPpORt3D.";
$lang['rssfeedurlformatinvalid'] = "rs\$ F3Ed URl FORm4+ i\$ 1NV4l1d. UrL Mus+ inCLUd3 ScH3Me (e.9. h+tP://) 4Nd @ HOs+Nam3 (E.G. wwW.HOsTN@mE.C0M).";
$lang['rssfeeduserauthentication'] = "rSS F3ed D035 N0+ \$UpP0rT h+Tp UsEr @utHent1c4+i0N";
$lang['successfullyremovedselectedfeeds'] = "sUCcESSFuLLy r3M0v3d \$3l3C+Ed F33D\$";
$lang['successfullyaddedfeed'] = "sUCC3SspHuLLy @ddED N3W FeED";
$lang['successfullyeditedfeed'] = "succ3\$SpHuLLy Ed1+Ed F33D";
$lang['failedtoremovefeeds'] = "f41L3d +o Rem0V3 SOMe 0R @lL 0f +H3 sEL3cTeD phEeD\$";
$lang['failedtoaddnewrssfeed'] = "f41leD To 4Dd NeW rS5 Ph3ED";
$lang['failedtoupdaterssfeed'] = "f4iLEd TO upD4+E r\$\$ pH3ED";
$lang['rssstreamworkingcorrectly'] = "rSs s+rE4M 4Pp34R5 tO 83 WoRk1Ng CoRrECtLY";
$lang['rssstreamnotworkingcorrectly'] = "rS\$ \$+re4M W4S 3MpTY 0r coUlD N0t B3 F0Und";
$lang['invalidfeedidorfeednotfound'] = "inv@L1D Feed iD 0R feEd n0T pHoUnd";

// PM Export Options

$lang['pmexportastype'] = "eXPOr+ @S TYpE";
$lang['pmexporthtml'] = "h+Ml";
$lang['pmexportxml'] = "xml";
$lang['pmexportplaintext'] = "pL@1N TEx+";
$lang['pmexportmessagesas'] = "exP0RT m3S549E\$ 4s";
$lang['pmexportonefileforallmessages'] = "oNe fiL3 pH0R @LL m3\$549E5";
$lang['pmexportonefilepermessage'] = "on3 pH1L3 pER MEsSa93";
$lang['pmexportattachments'] = "exP0Rt @t+4ChM3n+\$";
$lang['pmexportincludestyle'] = "incLUd3 Ph0rUm StYLE \$HeE+";
$lang['pmexportwordfilter'] = "appLy w0Rd f1LTeR To m3S5aGES";

// Thread merge / split options

$lang['threadhasbeensplit'] = "thR34D H4S 8E3N spLiT";
$lang['threadhasbeenmerged'] = "thr3@D h@s Be3N mErGeD";
$lang['mergesplitthread'] = "m3r9E / \$pLIT tHr34D";
$lang['mergewiththreadid'] = "m3r9E WI+h +hrE4D 1d:";
$lang['postsinthisthreadatstart'] = "p0S+5 1N +h1\$ +hRe4d At STAr+";
$lang['postsinthisthreadatend'] = "pO\$+s In +hi\$ +HrE4D AT 3nD";
$lang['reorderpostsintodateorder'] = "rE-0RDeR p0\$+S iNtO d4T3 0rdER";
$lang['splitthreadatpost'] = "spl1T THr34D A+ pO\$+:";
$lang['selectedpostsandrepliesonly'] = "sEL3C+Ed pOST @nD rePLi35 onLy";
$lang['selectedandallfollowingposts'] = "s3l3C+3D 4nd @ll F0lLOwINg p0St5";

$lang['threadmovedhere'] = "h3R3";

$lang['thisthreadhasmoved'] = "<b>threAd5 mERgeD:</b> +H1s +hr34D h4S mOveD %s";
$lang['thisthreadwasmergedfrom'] = "<b>thrE4D\$ MergEd:</b> TH1S +Hr34D WaS M3rG3d fROM %s";
$lang['somepostsinthisthreadhavebeenmoved'] = "<b>tHRE4d Spli+:</b> som3 PoStS iN thi\$ THR34d h4V3 b3En MOvED %s";
$lang['somepostsinthisthreadweremovedfrom'] = "<b>tHRE@D SPl1+:</b> \$0m3 poSts 1n Th1\$ +HRe4D W3R3 M0V3d pHrom %s";

$lang['thisposthasbeenmoved'] = "<b>thrE4d SPl1t:</b> tHi\$ pO\$t H4S bEEn M0v3D %s";

$lang['invalidfunctionarguments'] = "inV4l1D PHunCt1ON aRGum3N+s";
$lang['couldnotretrieveforumdata'] = "couLd N0t r3+rIEve ForUM DAt4";
$lang['cannotmergepolls'] = "on3 0R m0R3 tHr3aD\$ 1S 4 pOLL. j00 c@nNOT M3rGE P0LLs";
$lang['couldnotretrievethreaddatamerge'] = "couLD N0+ R3+Ri3Ve tHR34D d4T4 fRom 0nE 0R MOR3 +HrE4D5";
$lang['couldnotretrievethreaddatasplit'] = "c0UlD N0T Re+Ri3V3 +hRE4D D4Ta PhR0M soUrCe +HRe4D";
$lang['couldnotretrievepostdatamerge'] = "coulD No+ reTr1eVe pO\$+ daT4 PhrOM 0N3 0R mOr3 +HrE4Ds";
$lang['couldnotretrievepostdatasplit'] = "cOUlD N0+ re+rIEve poSt d4+4 PhRom 5OuRcE +Hr34D";
$lang['failedtocreatenewthreadformerge'] = "f4IL3D +0 cRE4t3 nEw +hr34D f0R M3r9E";
$lang['failedtocreatenewthreadforsplit'] = "f@1l3D +O CrE4T3 N3w Thr34d FoR SPl1T";

// Thread subscriptions

$lang['threadsubscriptions'] = "thre4d 5Ub5cr1Pt10nS";
$lang['couldnotupdateinterestonthread'] = "cOuLD No+ UpDaTe InTer3S+ 0n tHr34D '%s'";
$lang['threadinterestsupdatedsuccessfully'] = "thRE4D 1N+ER3s+s uPD@T3d \$ucCE55fuLly";
$lang['nothreadsubscriptions'] = "j00 4R3 N0T SuB\$cRibed +0 @ny +hr34DS.";
$lang['resetselected'] = "r35e+ sEl3Ct3D";
$lang['allthreadtypes'] = "aLl +HrE4D tYpES";
$lang['ignoredthreads'] = "i9N0ReD ThR34dS";
$lang['highinterestthreads'] = "hIGH 1Nt3RE\$+ +HreAD\$";
$lang['subscribedthreads'] = "su8\$CRi8Ed ThrE4Ds";
$lang['currentinterest'] = "cURR3n+ InT3RE\$t";

// Browseable user profiles

$lang['youcanonlyaddthreecolumns'] = "j00 C@n ONlY 4dD 3 c0LuMn\$. t0 4dD 4 nEW c0Lumn clo\$3 4N eX1ST1ng 0nE";
$lang['columnalreadyadded'] = "j00 H4v3 @LrE4Dy 4dD3d +h1\$ COlUmN. 1F J00 W@nT To rEmoV3 1+ cl1Ck 1+\$ cl0S3 8u+toN";

?>
