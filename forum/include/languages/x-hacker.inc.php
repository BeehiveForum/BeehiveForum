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

/* $Id: x-hacker.inc.php,v 1.288 2008-07-26 20:59:22 decoyduck Exp $ */

// British English language file

// Language character set and text direction options -------------------

$lang['_isocode'] = "en-gb";
$lang['_textdir'] = "ltr";

// Months --------------------------------------------------------------

$lang['month'][1]  = "j@nu4ry";
$lang['month'][2]  = "fe8RuarY";
$lang['month'][3]  = "m4RCH";
$lang['month'][4]  = "aPRIl";
$lang['month'][5]  = "m4Y";
$lang['month'][6]  = "jUne";
$lang['month'][7]  = "juLy";
$lang['month'][8]  = "augu$+";
$lang['month'][9]  = "seP+emB3r";
$lang['month'][10] = "oC+Ober";
$lang['month'][11] = "n0VEm8eR";
$lang['month'][12] = "d3cembER";

$lang['month_short'][1]  = "jAn";
$lang['month_short'][2]  = "f38";
$lang['month_short'][3]  = "m@R";
$lang['month_short'][4]  = "aPR";
$lang['month_short'][5]  = "m@y";
$lang['month_short'][6]  = "jUN";
$lang['month_short'][7]  = "jUl";
$lang['month_short'][8]  = "aU9";
$lang['month_short'][9]  = "sEp";
$lang['month_short'][10] = "ocT";
$lang['month_short'][11] = "n0V";
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

$lang['date_periods']['year']   = "%s ye4R";
$lang['date_periods']['month']  = "%s M0n+h";
$lang['date_periods']['week']   = "%s weEK";
$lang['date_periods']['day']    = "%s d@Y";
$lang['date_periods']['hour']   = "%s HoUr";
$lang['date_periods']['minute'] = "%s M1NU+3";
$lang['date_periods']['second'] = "%s 5EcOnD";

// As above but plurals (2 years vs. 1 year, etc.)

$lang['date_periods_plural']['year']   = "%s yE@rS";
$lang['date_periods_plural']['month']  = "%s MOnTH$";
$lang['date_periods_plural']['week']   = "%s WEEK$";
$lang['date_periods_plural']['day']    = "%s D4y$";
$lang['date_periods_plural']['hour']   = "%s HourS";
$lang['date_periods_plural']['minute'] = "%s Minu+3$";
$lang['date_periods_plural']['second'] = "%s $EC0nD$";

// Short hand periods (example: 1y, 2m, 3w, 4d, 5hr, 6min, 7sec)

$lang['date_periods_short']['year']   = "%sY";    // 1y
$lang['date_periods_short']['month']  = "%sM";    // 2m
$lang['date_periods_short']['week']   = "%sW";    // 3w
$lang['date_periods_short']['day']    = "%sd";    // 4d
$lang['date_periods_short']['hour']   = "%sHr";   // 5hr
$lang['date_periods_short']['minute'] = "%smin";  // 6min
$lang['date_periods_short']['second'] = "%ss3C";  // 7sec

// Common words --------------------------------------------------------

$lang['percent'] = "percEnt";
$lang['average'] = "aVEr4G3";
$lang['approve'] = "aPpR0VE";
$lang['banned'] = "b4nN3d";
$lang['locked'] = "l0CK3d";
$lang['add'] = "aDD";
$lang['advanced'] = "aDv4ncEd";
$lang['active'] = "aCTiV3";
$lang['style'] = "sTyLE";
$lang['go'] = "g0";
$lang['folder'] = "fOLd3r";
$lang['ignoredfolder'] = "igNOr3d FolDER";
$lang['subscribedfolder'] = "sUb$Cri8Ed Ph0LD3r";
$lang['folders'] = "f0Lder$";
$lang['thread'] = "tHrEAd";
$lang['threads'] = "thr34D$";
$lang['threadlist'] = "thr3@D liS+";
$lang['message'] = "m3$s493";
$lang['from'] = "fRoM";
$lang['to'] = "t0";
$lang['all_caps'] = "all";
$lang['of'] = "oF";
$lang['reply'] = "rePLY";
$lang['forward'] = "foRwARD";
$lang['replyall'] = "r3PLy +0 4LL";
$lang['quickreply'] = "qu1ck R3PlY";
$lang['quickreplyall'] = "qUICK r3PlY To 4ll";
$lang['pm_reply'] = "r3pLY 45 PM";
$lang['delete'] = "deL3TE";
$lang['deleted'] = "d3Le+3d";
$lang['edit'] = "ed1+";
$lang['privileges'] = "pRIVIle9e$";
$lang['ignore'] = "iGn0R3";
$lang['normal'] = "nORm4L";
$lang['interested'] = "iN+erEsTeD";
$lang['subscribe'] = "subScrIb3";
$lang['apply'] = "aPplY";
$lang['download'] = "downlO@d";
$lang['save'] = "s@V3";
$lang['update'] = "uPDat3";
$lang['cancel'] = "c4nC3l";
$lang['continue'] = "con+1Nu3";
$lang['attachment'] = "atT4cHMen+";
$lang['attachments'] = "att4cHMEN+5";
$lang['imageattachments'] = "im@gE @TTAChmEN+s";
$lang['filename'] = "f1LeN@m3";
$lang['dimensions'] = "dIMEnSIon$";
$lang['downloadedxtimes'] = "dowNL04DEd: %d T1m3S";
$lang['downloadedonetime'] = "doWNl0@DED: 1 tiMe";
$lang['size'] = "s1Ze";
$lang['viewmessage'] = "v1eW Me55@93";
$lang['deletethumbnails'] = "del3T3 ThuM8na1L$";
$lang['logon'] = "lo90N";
$lang['more'] = "moRe";
$lang['recentvisitors'] = "reC3NT VI$IT0rs";
$lang['username'] = "u53rn4mE";
$lang['clear'] = "cLe@R";
$lang['reset'] = "r353+";
$lang['action'] = "aC+1On";
$lang['unknown'] = "unKnoWN";
$lang['none'] = "noN3";
$lang['preview'] = "preViEw";
$lang['post'] = "p0$T";
$lang['posts'] = "p0$t$";
$lang['change'] = "ch@N93";
$lang['yes'] = "y3s";
$lang['no'] = "no";
$lang['signature'] = "sI9n@+URe";
$lang['signaturepreview'] = "s1gn4tUr3 pr3Vi3W";
$lang['signatureupdated'] = "s1GN4+Ur3 uPd4Ted";
$lang['signatureupdatedforallforums'] = "s19n@+ure Upd4T3d F0r 4LL f0RumS";
$lang['back'] = "b@cK";
$lang['subject'] = "suBJECt";
$lang['close'] = "cLO53";
$lang['name'] = "n4m3";
$lang['description'] = "descrIp+I0n";
$lang['date'] = "d4T3";
$lang['view'] = "vIeW";
$lang['enterpasswd'] = "en+3R P4$5W0rD";
$lang['passwd'] = "p4SSWoRd";
$lang['ignored'] = "i9NorEd";
$lang['guest'] = "gue5+";
$lang['next'] = "nEX+";
$lang['prev'] = "pR3v10U5";
$lang['others'] = "o+heRs";
$lang['nickname'] = "n1cKn4m3";
$lang['emailaddress'] = "eM@Il @DDRE5$";
$lang['confirm'] = "c0NpH1rm";
$lang['email'] = "eM4Il";
$lang['poll'] = "pOlL";
$lang['friend'] = "fRI3Nd";
$lang['success'] = "succ3Ss";
$lang['error'] = "eRroR";
$lang['warning'] = "w4RNINg";
$lang['guesterror'] = "sORry, J00 n33d +o b3 l0gG3d in T0 usE +h1S fE4TuRE.";
$lang['loginnow'] = "lOGiN n0W";
$lang['unread'] = "unrE4D";
$lang['all'] = "alL";
$lang['allcaps'] = "all";
$lang['permissions'] = "peRMIS$I0nS";
$lang['type'] = "typ3";
$lang['print'] = "pRin+";
$lang['sticky'] = "sT1CkY";
$lang['polls'] = "pOLL5";
$lang['user'] = "uSer";
$lang['enabled'] = "en@bl3d";
$lang['disabled'] = "dI54BlEd";
$lang['options'] = "oP+1on$";
$lang['emoticons'] = "emOt1C0N$";
$lang['webtag'] = "weBT@9";
$lang['makedefault'] = "m4K3 d3pH4Ul+";
$lang['unsetdefault'] = "uNSet D3F4ulT";
$lang['rename'] = "r3N@Me";
$lang['pages'] = "p49e5";
$lang['used'] = "u$3d";
$lang['days'] = "d4YS";
$lang['usage'] = "us493";
$lang['show'] = "sHOw";
$lang['hint'] = "h1n+";
$lang['new'] = "n3w";
$lang['referer'] = "rEfeR3R";
$lang['thefollowingerrorswereencountered'] = "teh phOll0w1n9 3rr0R5 W3r3 3NcoUN+3rEd:";

// Admin interface (admin*.php) ----------------------------------------

$lang['admintools'] = "aDm1n +0Ol$";
$lang['forummanagement'] = "f0RUM M4N4GemenT";
$lang['accessdeniedexp'] = "j00 D0 NO+ H4v3 pErM1ss1ON +0 Us3 +h1$ $EC+ion.";
$lang['managefolders'] = "m4NA93 f0lDErS";
$lang['manageforums'] = "m4N4gE pH0Rum5";
$lang['manageforumpermissions'] = "m4n@9E f0ruM pERMI5s1on$";
$lang['foldername'] = "folDER n@mE";
$lang['move'] = "m0v3";
$lang['closed'] = "clos3d";
$lang['open'] = "oP3n";
$lang['restricted'] = "rE$TR1c+3d";
$lang['forumiscurrentlyclosed'] = "%s 1s currENTlY cLOsED";
$lang['youdonothaveaccesstoforum'] = "j00 D0 no+ h@Ve 4cC3s$ tO %s";
$lang['toapplyforaccessplease'] = "to 4PplY FoR @cCe$$ PlE4$3 C0nt@CT ThE %s.";
$lang['forumowner'] = "forUM oWNeR";
$lang['adminforumclosedtip'] = "iph J00 w4NT T0 cHaN9E sOM3 $3ttiN9S ON your F0RUm Cl1cK THe @DMin L1NK 1n +H3 N4vIga+10N 84r 48ov3.";
$lang['newfolder'] = "nEw PHOlDeR";
$lang['nofoldersfound'] = "n0 3x15tIN9 Ph0lders phouND. T0 4DD 4 pH0lD3R Cl1ck +h3 '4DD N3W' bU++0n b3L0w.";
$lang['forumadmin'] = "f0RUM 4DMiN";
$lang['adminexp_1'] = "u53 +hE MenU oN +hE l3F+ +0 m4na9E +HiNgs IN Y0uR FORum.";
$lang['adminexp_2'] = "<b>userS</b> @LLOW5 J00 T0 S3t 1ndIv1DUAl usER P3rM15s1ons, 1nCludiN9 4PP0inTIng m0D3r@T0RS 4Nd G@9giNG p3Ople.";
$lang['adminexp_3'] = "<b>u$3r 9rOuPs</b> 4LloWs J00 +o CrE4+3 U$3R grouPS +o A5s1gN PErMI5sIOns +o @$ m@ny OR 4$ few u53R5 quiCKly @ND 34S1Ly.";
$lang['adminexp_4'] = "<b>b4n coN+rOl$</b> aLLOW$ +eh 8@NNiNG @nd uN-8@NNIN9 OPH 1P 4ddR3$S3$, H++P r3PH3r3rs, U5erN4MeS, Em@Il @DDREss3s 4Nd N1CKN@m3$.";
$lang['adminexp_5'] = "<b>f0ld3rS</b> @Ll0wS +h3 CRe4+1oN, mOd1FIC@+10n 4ND DelE+10n OpH PHOLd3r5.";
$lang['adminexp_6'] = "<b>r55 FEeDs</b> alLoW5 j00 +o M4NaG3 r5$ PhE3DS ph0r PR0P49@+10n iNto your ph0rUM.";
$lang['adminexp_7'] = "<b>pRoph1l35</b> Le+$ J00 Cu5+0M153 +3H 1tEMS Th4T aPp3ar 1n tHe uSEr PRopH1lE5.";
$lang['adminexp_8'] = "<b>f0ruM 5e+TinG5</b> 4lL0WS J00 +O CU$+OM1se yoUr F0RuM'$ n4Me, 4pP3Ar@NC3 4nd MaNY 0+h3R +h1N9s.";
$lang['adminexp_9'] = "<b>sT4Rt p49E</b> L3+$ j00 CUs+0MiSe Y0UR pHoRum'5 st4RT P@93.";
$lang['adminexp_10'] = "<b>foruM $+yLE</b> 4Ll0wS j00 t0 G3NEr4+E r4Nd0M S+yl3$ FoR Y0UR pH0Rum M3MBEr$ TO uS3.";
$lang['adminexp_11'] = "<b>w0RD pH1L+3r</b> 4LLows j00 T0 phiLT3R word5 J00 D0n'+ w4N+ +o B3 UsEd 0N Y0Ur phorum.";
$lang['adminexp_12'] = "<b>p0S+1Ng 5+4+s</b> g3N3R@+E$ 4 R3P0rT l1s+InG +h3 TOP 10 P05+ERs 1n 4 defineD P3r10d.";
$lang['adminexp_13'] = "<b>f0rUm L1nkS</b> l3+$ J00 M4N4ge The L1Nk5 DroPdown 1N The N@V1G@t10N bAR.";
$lang['adminexp_14'] = "<b>v1EW l09</b> l1$+S r3CEN+ 4C+I0n$ By +Eh F0ruM M0DEr@t0r5.";
$lang['adminexp_15'] = "<b>m@n49e F0RuMs</b> l3tS J00 Cr34T3 4ND DEl3+3 And CL0SE OR ReOp3n PHOruMS.";
$lang['adminexp_16'] = "<b>gLOB4l f0rUm SE++ing5</b> 4LlOw5 j00 +0 m0d1fY s3++inG$ Wh1Ch @phPH3cT 4ll Ph0ruM$.";
$lang['adminexp_17'] = "<b>pOS+ 4pPR0v@l qUEU3</b> 4ll0ws j00 +O V1eW 4ny Po5t$ @w41+In9 4Pprov@l by @ m0d3Rat0R.";
$lang['adminexp_18'] = "<b>vi$1t0R l0G</b> @LL0WS J00 T0 vIew 4N Ex+3Nd3D L1sT Oph VIsitoR5 1ncluDIN9 +HE1r H++P rEfeR3rS.";
$lang['createforumstyle'] = "cR3at3 4 fORuM S+YLe";
$lang['newstylesuccessfullycreated'] = "neW $+yL3 SucC3S5pHUlLy cReATed.";
$lang['stylealreadyexists'] = "a S+yle wI+H +h4t F1L3N4M3 4LrE4Dy 3X1$t$.";
$lang['stylenofilename'] = "j00 D1D n0t 3nt3R @ PhILen4ME +0 5aVe +hE $+yL3 wi+H.";
$lang['stylenodatasubmitted'] = "c0ULD NO+ re4d f0Rum $+yL3 dAt@.";
$lang['styleexp'] = "usE +Hi$ P4G3 to hELP cR34+3 4 R@ND0MlY 93nEr4+3D $tYl3 For yoUr PhOrUM.";
$lang['stylecontrols'] = "c0NTrol5";
$lang['stylecolourexp'] = "cl1CK ON @ c0l0ur T0 m4k3 4 NeW $+yle sHeet 84S3D 0n +H4+ C0LoUR. CURR3N+ B@Se CoL0uR 1$ pHIr$T 1N lis+.";
$lang['standardstyle'] = "s+@nDArD stYLE";
$lang['rotelementstyle'] = "rO+4t3d 3LEMEN+ sTYL3";
$lang['randstyle'] = "r4ND0M $+YL3";
$lang['thiscolour'] = "th1$ cOL0ur";
$lang['enterhexcolour'] = "or 3N+3R 4 HeX cOl0UR t0 84se 4 New 5TylE Sh3eT 0n";
$lang['savestyle'] = "s4v3 TH15 S+yLE";
$lang['styledesc'] = "stYL3 deScr1P+ion";
$lang['stylefilenamemayonlycontain'] = "s+YLE pH1L3NAM3 M4y 0nlY c0Nt4In L0WerC4SE l3++ERS (4-Z), num83rS (0-9) 4nd Under$CoRe.";
$lang['stylepreview'] = "s+yLe PR3VI3w";
$lang['welcome'] = "welCoMe";
$lang['messagepreview'] = "mEs$4g3 pr3vI3w";
$lang['users'] = "u5ERS";
$lang['usergroups'] = "u$3R 9R0UP$";
$lang['mustentergroupname'] = "j00 mUS+ Ent3r @ GroUp n@ME";
$lang['profiles'] = "pRof1l35";
$lang['manageforums'] = "m4n4GE F0rUms";
$lang['forumsettings'] = "fOrUm s3TTINGS";
$lang['globalforumsettings'] = "gLo84l PhoRUM Sett1n95";
$lang['settingsaffectallforumswarning'] = "<b>n0T3:</b> +h3$3 53++1n9s aphFECT @LL f0RUmS. wHEr3 T3h SEt+1n9 1$ duPL1C4+ed on +H3 iNd1vidu4L FORUm's S3+tIngs P4Ge +HA+ w1Ll t4KE pr3cEdEnCE 0V3R +He S3++1NG5 J00 cH4nG3 h3R3.";
$lang['startpage'] = "s+4r+ P493";
$lang['startpageerror'] = "yOuR STARt p4G3 c0uLD NOT 83 54VEd L0cAlLy +0 +EH 53rV3r 83c4u$E PERm15s10N W@5 DEn1ed.</p><p>to CH@N93 YouR 5T4R+ PAGe PLE45E CLIcK thE d0WNlo4d 8uTton b3l0W WHIch w1Ll ProMPT j00 To $AVe +3h pH1l3 +0 Y0uR h4RD Dr1Ve. J00 C@n th3n uPlOaD +H1S phil3 t0 yoUr s3RVEr In+0 TH3 fOLLow1N9 pH0LDer, if neCEs54Ry CrE4+1ng +H3 FolDER 5tRucTUre in +HE pR0c3$$.</p><p><b>%s</b></p><p>ple@$3 no+E Th4t soME Br0wsers May Ch4N9E the N4m3 oF +H3 f1l3 upOn DoWNLO4d. WHEn UPLO4d1n9 +He PhIl3 PL34$3 M@k3 sUr3 +h@+ IT 1$ n@m3D s+@r+_m41n.PHP o+Herwi$e Y0UR s+@R+ P493 W1Ll @ppE4R uNch4nG3d.";
$lang['uploadcssfile'] = "uPLo@d c$S s+YlE $h3eT";
$lang['uploadcssfilefailed'] = "y0UR C$$ $+YLe 5He3+ c0uld NO+ b3 uPl0@D3D +0 tHE 5erV3R b3C@U5E peRM1Ss10n W45 D3N1ed.</p><p>to Ch4N9E Y0Ur sT@Rt P4ge CsS 5+yl3 5H33+ Pl3453 EnSUR3 +HE follOwiN9 f0Ld3RS EXi5+ @nD 4R3 wR1+4Ble: </p><p><b>%s</b></p>";
$lang['invalidfiletypeerror'] = "iNv4lId pHIL3 +Yp3, j00 cAn oNlY upL04D CS$ $+yl3 sHeet pHileS";
$lang['failedtoopenmasterstylesheet'] = "yoUr Ph0RUM 5+Yl3 C0uLd No+ 83 $4Ved b3C4u5E ThE M@5+eR 5TyLe shee+ C0ULd Not BE l0adEd. +0 $@vE yoUR $tYLe +Eh mAS+er s+yl3 $HE3t (m4K3_5+yL3.css) mu$t be Loc4TED iN +hE s+yl3$ DIr3C+oRy 0ph YOUR b33H1v3 Ph0RuM 1n5T4Ll4+IoN.";
$lang['makestyleerror'] = "y0uR phoRUm s+YL3 C0uLD n0+ 83 s4vED lOC4LLy +0 tEh $eRvEr b3c4U5e p3rm1$$1On w4s D3NIED.</p><p>tO s@Ve Y0UR FOrUM sTYL3 pL3@$e clicK T3h DOwnLo4D 8U++oN 8ElOW whicH Will PromPt J00 T0 54v3 +hE pH1lE +0 YoUr H4rD dR1V3. J00 C4n THEn UpLO4d +hIs Ph1l3 T0 yOUR $3rVER 1n+O The Ph0LL0WIng foLD3r, IPH N3CES$4Ry cr34+InG th3 ph0LDER STrUc+ur3 1N +hE pR0c35S.</p><p><b>%s</b></p><p>pl3A5e N0tE tH@+ $Ome 8R0wSEr5 M4Y Ch4N93 +Eh N4me 0F Teh fIL3 upon downLo4d. wH3n uPlO@D1N9 th3 FIlE PLea$3 M4K3 $uR3 tH4+ IT 1S N@MEd 5tYLE.C5s 0therW1S3 +HE F0rUM StyL3 W1lL B3 unav@iL@8Le.";
$lang['forumstyle'] = "foruM 5TyLe";
$lang['wordfilter'] = "w0rd ph1lt3r";
$lang['forumlinks'] = "f0Rum lInk$";
$lang['viewlog'] = "v13W l0g";
$lang['noprofilesectionspecified'] = "no pROPHIle S3Ct1On SPEC1fied.";
$lang['itemname'] = "it3m N4Me";
$lang['moveto'] = "m0V3 +0";
$lang['manageprofilesections'] = "m4N4G3 pROfil3 $3C+IoNs";
$lang['sectionname'] = "sEC+i0N nAM3";
$lang['items'] = "i+eMS";
$lang['mustspecifyaprofilesectionid'] = "mU$+ SpEC1PHy @ pR0FilE SeCT1oN Id";
$lang['mustsepecifyaprofilesectionname'] = "mU5+ $PeciPhY @ PRofIl3 SECtI0n naME";
$lang['noprofilesectionsfound'] = "n0 3XI$tin9 PRopH1l3 $Ec+1On5 pHOuNd. tO 4dd @ pROPhIl3 Sec+1oN CLICk +3h '4dd NEW' bUT+0N 8eLoW.";
$lang['addnewprofilesection'] = "adD neW proFiLe secT10N";
$lang['successfullyaddedprofilesection'] = "sUcCeSsfuLlY @DdEd PRofILe S3C+10n";
$lang['successfullyeditedprofilesection'] = "suCc3$sPhuLLY EDi+ed PRoPH1lE s3ct10N";
$lang['addnewprofilesection'] = "add nEw proF1Le $ecTion";
$lang['mustsepecifyaprofilesectionname'] = "mU5+ 5peCIFy 4 Pr0F1l3 seC+iON n@m3";
$lang['successfullyremovedselectedprofilesections'] = "sUcc35spHuLly rem0v3d 53l3ct3D pRopHile seCtIOn$";
$lang['failedtoremoveprofilesections'] = "f4ilEd TO remov3 prOf1L3 $ectI0n5";
$lang['viewitems'] = "view 1+em$";
$lang['successfullyaddednewprofileitem'] = "suCCes$PHUlly 4DDED n3W pr0Ph1le iT3M";
$lang['successfullyeditedprofileitem'] = "suCc3$SfulLY 3DI+3D ProPhILe ITEM";
$lang['successfullyremovedselectedprofileitems'] = "suCCeSSFULLy rem0v3d $el3ctED PrOFILe iT3M5";
$lang['failedtoremoveprofileitems'] = "f41LeD T0 r3M0V3 PR0PhiL3 1+3M$";
$lang['noexistingprofileitemsfound'] = "tHERe @re no 3X1S+In9 prophilE iTeMS IN +Hi$ sECT10N. T0 @Dd 4n iT3M ClICk tEH '@dD n3w' butT0N 83LoW.";
$lang['edititem'] = "ed1T 1TEm";
$lang['invalidprofilesectionid'] = "invaL1d PR0philE s3c+10N id Or 5ECt1ON Not F0UNd";
$lang['invalidprofileitemid'] = "iNV4L1D pR0ph1Le itEm ID 0R iTeM n0+ phOUnd";
$lang['addnewitem'] = "add nEW 1+EM";
$lang['youmustenteraprofileitemname'] = "j00 MUsT eNTeR A ProPHIL3 iteM nAm3";
$lang['invalidprofileitemtype'] = "iNV4liD pRoPH1le 1+eM TyPe $el3Ct3d";
$lang['youmustenteroptionsforselectedprofileitemtype'] = "j00 Mu$+ 3N+3r SOm3 op+I0n$ phOR S3l3c+3d PR0F1l3 1tem tyPE";
$lang['youmustentermorethanoneoptionforitem'] = "j00 must 3nT3R Mor3 +h@N 0N3 0p+10n F0r S3l3c+ed proF1Le I+Em +YPE";
$lang['profileitemhyperlinkssupportshttpurlsonly'] = "prOpH1L3 IteM hyp3rl1NKs SuPp0rt h++p uRLs only";
$lang['profileitemhyperlinkformatinvalid'] = "pR0pH1l3 1+Em HYp3RL1NK phorm4T InV@L1D";
$lang['youmustincludeprofileentryinhyperlinks'] = "j00 MUSt 1NcLUD3 <i>%s</i> in +he URl 0F Cl1cK@Bl3 HYp3RLInKs";
$lang['failedtocreatenewprofileitem'] = "f41l3d T0 CRE4t3 NeW ProPH1l3 1tem";
$lang['failedtoupdateprofileitem'] = "f@iL3d t0 UpD4t3 pR0PhiLe ItEm";
$lang['startpageupdated'] = "s+4rT p@9E UpD4+3D. %s";
$lang['cssfileuploaded'] = "c$$ STyLe sHeEt uPLO4Ded. %s";
$lang['viewupdatedstartpage'] = "vI3W uPD4tEd 5+4R+ P4g3";
$lang['editstartpage'] = "eDi+ 5T4R+ P49e";
$lang['nouserspecified'] = "no U$3R $p3C1PHIeD.";
$lang['manageuser'] = "m4N@g3 uS3r";
$lang['manageusers'] = "m4N493 U$3rS";
$lang['userstatusforforum'] = "u5Er $t4+US pHOr %s";
$lang['userdetails'] = "uSer d3+4IlS";
$lang['edituserdetails'] = "ed1+ u$3r D3+4iLS";
$lang['warning_caps'] = "w4rn1N9";
$lang['userdeleteallpostswarning'] = "aR3 j00 $URe j00 w4N+ t0 d3l3te all 0pH ThE 53l3Ct3d U$eR'S P05+5? OnCe +h3 p0$+S @R3 dELE+3D +h3y cANNot b3 r3+rIeVEd 4nD W1LL Be lo$+ for3v3r.";
$lang['postssuccessfullydeleted'] = "posts weR3 $UCcE$spHulLy d3l3t3D.";
$lang['folderaccess'] = "f0lder @CcE$5";
$lang['possiblealiases'] = "p0s518L3 4Li@se5";
$lang['ipaddressmatches'] = "iP AdDR3s5 M@+ch3$";
$lang['emailaddressmatches'] = "emA1L @DDr3S$ MAtCH35";
$lang['passwdmatches'] = "p@$sw0rD M4TCH3S";
$lang['httpreferermatches'] = "ht+p REF3R3R M4+CHE$";
$lang['userhistory'] = "useR h1$T0RY";
$lang['nohistory'] = "n0 H1$T0rY rec0Rd5 S4V3d";
$lang['userhistorychanges'] = "cH4NG3s";
$lang['clearuserhistory'] = "cl3@r USEr h1s+oRY";
$lang['changedlogonfromto'] = "ch4Ng3d L090n FROM %s TO %s";
$lang['changednicknamefromto'] = "cHAn9Ed NicKN4m3 fr0m %s T0 %s";
$lang['changedemailfromto'] = "cH4N93D em41l pHr0m %s +o %s";
$lang['successfullycleareduserhistory'] = "sucC3s5FuLlY cL34r3d US3r His+OrY";
$lang['failedtoclearuserhistory'] = "f41Led +0 cl34R UseR h1$+ORy";
$lang['successfullychangedpassword'] = "succE5SpHuLLY ch4n9ED p4s$woRD";
$lang['failedtochangepasswd'] = "faILED +o cH@NGe p4S5w0Rd";
$lang['approveuser'] = "aPpROv3 UsER";
$lang['viewuserhistory'] = "vIEW u$eR H1S+0rY";
$lang['viewuseraliases'] = "vIew u$3r 4LI@$eS";
$lang['searchreturnednoresults'] = "sE4RcH r3+uRN3D No R35Ul+5";
$lang['deleteposts'] = "dELetE PO$+5";
$lang['deleteuser'] = "d3Let3 U53R";
$lang['alsodeleteusercontent'] = "aL$o d3l3TE @LL 0F +3h COnt3n+ CRe@T3D 8Y THiS Us3r";
$lang['userdeletewarning'] = "arE J00 5URe j00 W@nT tO DELeTE +he 53l3C+eD us3R @CCOUnt? oNcE tHe 4CcoUnt haS 833n DEL3t3d 1+ C@nN0T b3 r3+ri3vEd @ND w1Ll 83 LOs+ forEVeR.";
$lang['usersuccessfullydeleted'] = "us3R $uCce5sfUlLy d3l3+eD";
$lang['failedtodeleteuser'] = "f4IL3d T0 D3l3+E U53R";
$lang['forgottenpassworddesc'] = "if th15 UseR H4$ PHOrgOTt3N +HEIR p4s$W0Rd j00 C4n res3+ I+ F0r +h3M HER3.";
$lang['failedtoupdateuserstatus'] = "f4IlEd +O UPD@te uSEr $T@Tu$";
$lang['failedtoupdateglobaluserpermissions'] = "f41L3D T0 uPdAT3 Gl084l u$3r pErMiS510ns";
$lang['failedtoupdatefolderaccesssettings'] = "f@1l3D +0 UPd4te ph0lDeR accE55 $3+t1Ng$";
$lang['manageusersexp'] = "tH1$ Li$t ShOw5 4 SEl3C+1on 0f UseR5 WH0 H4V3 L09gEd oN +o YOuR fOrUm, 5oRT3d 8Y %s. t0 4LT3r @ Us3r'5 peRM1SSI0nS CLick +HeiR n4m3.";
$lang['userfilter'] = "uS3R ph1L+er";
$lang['onlineusers'] = "onl1NE u53r$";
$lang['offlineusers'] = "ophpHl1n3 uS3RS";
$lang['usersawaitingapproval'] = "u$Er5 4w@1+iNG aPpROV@L";
$lang['bannedusers'] = "b4nN3D U5ER$";
$lang['lastlogon'] = "l4$+ l0gON";
$lang['sessionreferer'] = "se5$10n R3PH3rEr";
$lang['signupreferer'] = "sigN-Up R3Ph3rEr:";
$lang['nouseraccountsmatchingfilter'] = "n0 User 4ccoUN+s M4+cH1ng f1lTER";
$lang['searchforusernotinlist'] = "se@rCh For @ uS3R N0T 1N liST";
$lang['adminaccesslog'] = "aDM1n @CcE5s lo9";
$lang['adminlogexp'] = "th1S LiST 5hOwS +eh L4s+ 4c+1onS S@NctiONed bY UseRS W1TH 4DmIn PrIVil3g35.";
$lang['datetime'] = "d4T3/T1me";
$lang['unknownuser'] = "uNKN0Wn U$3r";
$lang['unknownuseraccount'] = "unKn0WN uSEr ACcoun+";
$lang['unknownfolder'] = "uNKNown ph0ld3r";
$lang['ip'] = "ip";
$lang['lastipaddress'] = "l4sT 1P 4dDr3SS";
$lang['hostname'] = "h0S+n4me";
$lang['unknownhostname'] = "unkNOwN h0STN@mE";
$lang['logged'] = "l0g93d";
$lang['notlogged'] = "n0T L09g3D";
$lang['addwordfilter'] = "aDD w0rD fil+3R";
$lang['addnewwordfilter'] = "add NEW WORD PHIL+3r";
$lang['wordfilterupdated'] = "w0rD phil+ER uPD@teD";
$lang['wordfilterisfull'] = "j00 C4nN0t AdD @ny m0Re WORd fil+3r5. r3M0v3 $om3 UnuseD ON3s 0r ed1T teh Exi$t1NG ONeS F1r5T.";
$lang['filtername'] = "filter nAM3";
$lang['filtertype'] = "f1l+3r tYPE";
$lang['filterenabled'] = "filTER 3N48LeD";
$lang['editwordfilter'] = "eD1+ w0RD f1L+eR";
$lang['nowordfilterentriesfound'] = "no 3Xi5+iNG WoRd PhiL+er enTRIe5 fOunD. tO 4DD @ fIL+3r cL1Ck TH3 '@DD New' Bu++on 83l0w.";
$lang['mustspecifyfiltername'] = "j00 mU5t Sp3CiFY @ FilTeR n4me";
$lang['mustspecifymatchedtext'] = "j00 Mu$+ spEC1fY m@+chEd t3Xt";
$lang['mustspecifyfilteroption'] = "j00 MUSt SpeCIpHy 4 pHiLT3R opt10N";
$lang['mustspecifyfilterid'] = "j00 mUs+ $P3CIPhY 4 ph1L+eR Id";
$lang['invalidfilterid'] = "iNvaL1d f1l+er ID";
$lang['failedtoupdatewordfilter'] = "fa1l3D +O Upd4TE W0rD phIL+3r. CheCk +h@+ +h3 PHILt3R S+1LL 3x1s+5.";
$lang['allow'] = "alLOw";
$lang['block'] = "bLOCK";
$lang['normalthreadsonly'] = "n0Rm4L tHr3@D$ 0nly";
$lang['pollthreadsonly'] = "poLl +HRE4D$ 0NLY";
$lang['both'] = "bOTH +HRE@D +yP3s";
$lang['existingpermissions'] = "ex1S+1ng PERmi$510n5";
$lang['nousershavebeengrantedpermission'] = "n0 eX1$T1n9 UsER$ P3rm1SS10NS foUNd. +0 gr@N+ permi5S10n t0 US3RS S3@RcH F0R THem BElow.";
$lang['successfullyaddedpermissionsforselectedusers'] = "succes5pHUllY 4DD3D p3RMI$$I0NS f0r $eLEcTEd US3r$";
$lang['successfullyremovedpermissionsfromselectedusers'] = "sUCC3S5PhullY remOv3d p3rM1S51ONs PhR0M SELeC+ED u53R5";
$lang['failedtoaddpermissionsforuser'] = "f@1LED +o ADd Perm1Ss10ns pH0R U5eR '%s'";
$lang['failedtoremovepermissionsfromuser'] = "f4iLED +0 r3m0V3 pERmi5S10ns phrOM u$3r '%s'";
$lang['searchforuser'] = "s3@rCH PH0r U$3r";
$lang['browsernegotiation'] = "bR0w$3r n3g0+14T3d";
$lang['textfield'] = "t3XT F13LD";
$lang['multilinetextfield'] = "mulT1-l1N3 +EXt Ph13ld";
$lang['radiobuttons'] = "r4dIo BU+t0ns";
$lang['dropdownlist'] = "droP D0WN LI5+";
$lang['clickablehyperlink'] = "cLicK4Bl3 hYp3rL1nK";
$lang['threadcount'] = "thR34D c0un+";
$lang['clicktoeditfolder'] = "clICk TO 3dit fOlD3r";
$lang['fieldtypeexample1'] = "to CrE4+E R4d10 bu++on$ 0r 4 DR0p down l1S+ J00 nE3D +o EN+3R 34cH 1nd1V1DU4L vaLU3 On @ $3P4R4te lINE 1n tEH 0pT1ONS fIelD.";
$lang['fieldtypeexample2'] = "tO CRe4+e ClicK4BL3 lInK$ ENT3R tHE uRL iN The 0Pt1oN5 phieLD 4nd U$e <i>%1\$$</i> wHER3 +H3 entRy fr0m THe u53r's prOPhIlE shoULd 4pP34R. 3XAmpl35: <p>mySP4C3: <i>h++p://www.MysP@ce.Com/%1\$S</i><br />xBOX livE: <i>h+Tp://PrOphil3.mYG4M3RC@RD.neT/%1\$$</i>";
$lang['editedwordfilter'] = "eDit3d Word fIl+3r";
$lang['editedforumsettings'] = "ed1t3D F0RUM 5EtTIN9s";
$lang['successfullyendedusersessionsforselectedusers'] = "suCcE$$fuLly 3nD3D SE$S10N$ pH0R sELeC+3D U$3rs";
$lang['failedtoendsessionforuser'] = "f41led To 3nd S3S510n For uS3r %s";
$lang['successfullyapproveduser'] = "sUcCesspHulLy 4ppRov3D USer";
$lang['successfullyapprovedselectedusers'] = "sUCc3sSFulLY 4pPr0vED sELECT3D uS3R$";
$lang['matchedtext'] = "maTCheD teXT";
$lang['replacementtext'] = "r3pl4c3m3nt +Ex+";
$lang['preg'] = "pReg";
$lang['wholeword'] = "wH0Le Word";
$lang['word_filter_help_1'] = "<b>all</b> m4+Ch3$ 49A1N$T +EH WH0le +3xT 5o pHilTER1n9 mOM t0 mUM W1ll @L$0 cH@nG3 mOMEn+ +o mumENT.";
$lang['word_filter_help_2'] = "<b>wholE word</b> M4+Ch35 4G@1ns+ WHOlE W0Rd$ 0NLy So phILt3RInG M0m t0 MuM w1lL n0t cH4nge MoMEN+ +o Mum3n+.";
$lang['word_filter_help_3'] = "<b>prEg</b> @llow5 J00 +O uSE PERl RE9Ul@R EXpR3S$1oNs to m4TcH +3XT.";
$lang['nameanddesc'] = "naM3 4nd D3$cR1P+1on";
$lang['movethreads'] = "moV3 +HrE4ds";
$lang['movethreadstofolder'] = "mOve thr3@D$ To ph0LDEr";
$lang['failedtomovethreads'] = "f@1l3d +o M0V3 +hr34D$ T0 sP3C1fi3d F0ldEr";
$lang['resetuserpermissions'] = "r3SE+ u53r permis$1On$";
$lang['failedtoresetuserpermissions'] = "f@1lED T0 rESET u53r pErM1S5ION5";
$lang['allowfoldertocontain'] = "alL0W pholDer to c0NT41N";
$lang['addnewfolder'] = "adD N3W fOLd3R";
$lang['mustenterfoldername'] = "j00 MuS+ 3nt3r a pHolD3R N4mE";
$lang['nofolderidspecified'] = "no f0Ld3R ID SpEcIfIEd";
$lang['invalidfolderid'] = "inv@liD PHOLd3R id. ch3Ck tHAT @ FOld3r W1Th ThiS 1d exI$T5!";
$lang['successfullyaddednewfolder'] = "sUCcE$SfuLlY 4Dd3D New f0Ld3R";
$lang['successfullyremovedselectedfolders'] = "sUcc35sFULLY R3M0V3D $3LeCtED PHOLdEr$";
$lang['successfullyeditedfolder'] = "suCCES$fUlly 3D1tEd PH0ldeR";
$lang['failedtocreatenewfolder'] = "faIL3D t0 Cr3aT3 NEw pHoldEr";
$lang['failedtodeletefolder'] = "f@ILeD T0 D3l3t3 phoLd3r.";
$lang['failedtoupdatefolder'] = "f@1led TO UPD4+e fOlD3r";
$lang['cannotdeletefolderwiththreads'] = "c4Nn0t delE+E FOLders +H4T $+Ill c0NTA1N +HrE4d5.";
$lang['forumisnotrestricted'] = "fOrum I$ N0t re$+R1CT3d";
$lang['groups'] = "gr0uPS";
$lang['nousergroups'] = "n0 U$3r grOuPs h4V3 8Een 5et uP. To 4dD a gRoup CLiCK +H3 '4Dd new' ButT0n b3LoW.";
$lang['suppliedgidisnotausergroup'] = "supplIed 91D IS N0+ 4 usEr GR0UP";
$lang['manageusergroups'] = "m4N49E us3r 9r0uPs";
$lang['groupstatus'] = "gR0Up $ta+uS";
$lang['addusergroup'] = "aDD User GRouP";
$lang['addemptygroup'] = "aDD 3Mp+Y gR0Up";
$lang['adduserstogroup'] = "add U53RS +0 9R0Up";
$lang['addremoveusers'] = "aDD/rEMOve uSerS";
$lang['nousersingroup'] = "tHere 4r3 nO uSErs 1N tH1S GrOUp. 4dd Us3rs +o th15 GRoup By se@rch1NG F0R them BEl0w.";
$lang['groupaddedaddnewuser'] = "suCc3S$fully @dd3d gr0up. @DD USERs T0 +HI$ 9ROUp BY s34RcH1ng pHOr tH3M 8eLoW.";
$lang['nousersingroupaddusers'] = "th3R3 4re nO U$3RS IN +h1$ 9R0up. T0 4dD US3rS CLiCK +3h '@DD/ReMOV3 u53r$' 8UT+oN 83l0W.";
$lang['useringroups'] = "tH1s U$er i$ 4 MEmBeR oF T3H FOllowiNG 9ROupS";
$lang['usernotinanygroups'] = "tHiS US3r IS N0+ 1n 4nY uS3r gr0uP$";
$lang['usergroupwarning'] = "n0t3: +h1s us3R m@Y 8E 1nh3r1+1N9 4dd1T10n4L PErMI5510N$ FR0M Any Us3R 9r0UPs L1StED 8ELow.";
$lang['successfullyaddedgroup'] = "suCC3$sphUlLy 4DdED 9R0uP";
$lang['successfullyeditedgroup'] = "sucC3SsfuLLy 3Di+3d 9R0uP";
$lang['successfullydeletedselectedgroups'] = "succ3$sphULLy DeLe+3d seleCtEd gR0UpS";
$lang['failedtodeletegroupname'] = "f4Il3D +O DeL3tE gR0up %s";
$lang['usercanaccessforumtools'] = "uSer C4n 4cCeSs fORUM T0oL5 @nd CAn Cr34+e, DEle+3 4ND 3di+ ph0ruM5";
$lang['usercanmodallfoldersonallforums'] = "u53r c4N M0d3r4tE <b>aLL Ph0ldErS</b> 0N <b>all FORum5</b>";
$lang['usercanmodlinkssectiononallforums'] = "u$3r C@N M0deR4Te l1Nk5 $Ec+IOn 0n <b>aLl f0rUMs</b>";
$lang['emailconfirmationrequired'] = "em4il C0nPhIRm4ti0n reqU1R3D";
$lang['userisbannedfromallforums'] = "us3r iS 8@nN3d phroM <b>alL phoRUM$</b>";
$lang['cancelemailconfirmation'] = "c4nc3l em4iL CoNPhirm4+10N 4nd @ll0W u$er t0 S+@RT P0S+1n9";
$lang['resendconfirmationemail'] = "r3s3nd C0NpHIRM@tI0N 3m@1l +O USer";
$lang['failedtosresendemailconfirmation'] = "f4Il3d +o RE$EnD 3M4iL c0npH1rMa+I0n +0 u$er.";
$lang['donothing'] = "d0 No+hIn9";
$lang['usercanaccessadmintools'] = "u53r h45 @cc3S$ +0 PhORuM @Dm1n ToOLS";
$lang['usercanaccessadmintoolsonallforums'] = "u53R Has 4cC3$S tO 4Dm1N t0OL$ <b>oN @LL fOrUm5</b>";
$lang['usercanmoderateallfolders'] = "us3r C@n M0DEraTE all PH0Ld3r$";
$lang['usercanmoderatelinkssection'] = "u5ER C4n MoDer4T3 l1nK5 SEc+i0n";
$lang['userisbanned'] = "u$3R 15 B4NN3d";
$lang['useriswormed'] = "uSer 1S w0Rm3D";
$lang['userispilloried'] = "us3r i$ PilL0rIEd";
$lang['usercanignoreadmin'] = "u$3R c4N 1gn0re @dm1Ni$+r@toRS";
$lang['groupcanaccessadmintools'] = "gRoup can 4cc3sS 4Dm1n TooL5";
$lang['groupcanmoderateallfolders'] = "gR0Up c4N M0Der4TE 4Ll pH0LdErS";
$lang['groupcanmoderatelinkssection'] = "gr0Up C4n m0dEr4+3 lINKs $3cT10ns";
$lang['groupisbanned'] = "gRoUp i$ 84nN3D";
$lang['groupiswormed'] = "gr0UP 1$ wORMED";
$lang['readposts'] = "re@D P0$T$";
$lang['replytothreads'] = "r3pLy +0 +Hr34ds";
$lang['createnewthreads'] = "cre4+3 N3w thr34dS";
$lang['editposts'] = "eD1t pO$+S";
$lang['deleteposts'] = "delE+e POs+$";
$lang['postssuccessfullydeleted'] = "pOs+$ 5ucCESSpHullY d3L3TED";
$lang['failedtodeleteusersposts'] = "fa1l3D tO D3l3+3 U$3r'$ Po$ts";
$lang['uploadattachments'] = "uPl04D 4t+4CHm3N+s";
$lang['moderatefolder'] = "modeR@+3 F0LDER";
$lang['postinhtml'] = "pOS+ 1N HTML";
$lang['postasignature'] = "p0st 4 SI9n4+ur3";
$lang['editforumlinks'] = "eDiT Ph0RUm link$";
$lang['linksaddedhereappearindropdown'] = "lINk$ aDd3D HEr3 @PP34R in 4 DRoP D0WN In +3H Top Ri9Ht OPh the PHR4m3 Set.";
$lang['linksaddedhereappearindropdownaddnew'] = "lInks 4DDED H3rE 4ppE4r 1N @ DR0p D0Wn 1n +H3 t0p R1gh+ oPh +h3 Fr4m3 s3+. tO 4dD @ lInK cL1CK Th3 '4dD new' BUT+0n 8eLoW.";
$lang['failedtoremoveforumlink'] = "f41LeD +0 rEmOv3 foruM l1Nk '%s'";
$lang['failedtoaddnewforumlink'] = "f41lED +O @dD n3w f0RUm l1NK '%s'";
$lang['failedtoupdateforumlink'] = "f@1lED +0 uPd4+E PH0RUm l1nk '%s'";
$lang['notoplevellinktitlespecified'] = "no +Op lEVEl L1nk tI+lE SP3C1PhI3D";
$lang['youmustenteralinktitle'] = "j00 mUS+ EN+3r 4 L1nK +1TLE";
$lang['alllinkurismuststartwithaschema'] = "all LinK uRi5 MuSt 5t4rT W1+h 4 SCHem4 (1.E. h++P://, ph+p://, 1rC://)";
$lang['editlink'] = "eDI+ l1Nk";
$lang['addnewforumlink'] = "aDd n3W f0RUm LINk";
$lang['forumlinktitle'] = "forum lINk T1+Le";
$lang['forumlinklocation'] = "forum l1nK L0c4+iON";
$lang['successfullyaddednewforumlink'] = "sUcCe$5PHUllY 4DdEd n3w PHoRUM lINK";
$lang['successfullyeditedforumlink'] = "sucCe$5fUlLy 3dI+eD ph0RuM L1Nk";
$lang['invalidlinkidorlinknotfound'] = "inv@lId l1NK 1d 0r l1Nk N0T pH0unD";
$lang['successfullyremovedselectedforumlinks'] = "sucCe$$phulLy remOV3D $3lect3d l1nK5";
$lang['toplinkcaption'] = "t0P l1nk c4p+1on";
$lang['allowguestaccess'] = "alL0W 9u35t ACcESS";
$lang['searchenginespidering'] = "sE@rCh 3n91nE sP1d3R1n9";
$lang['allowsearchenginespidering'] = "all0w SE@Rch enG1N3 SP1D3R1N9";
$lang['sitemapenabled'] = "eN4Bl3 $IteM4P";
$lang['sitemapupdatefrequency'] = "si+em4p UpD@tE PhreqU3NcY";
$lang['sitemappathnotwritable'] = "s1T3m4P D1Rec+ory mUsT BE wri+A8l3 BY tEH w38 $3rV3R / PHP pR0c355!";
$lang['newuserregistrations'] = "n3W u$3R RE9IstR4+1On$";
$lang['preventduplicateemailaddresses'] = "pr3V3nt DUpLIc@te em4IL ADdr35SE5";
$lang['allownewuserregistrations'] = "alL0w nEw us3r re9Istr4+ion$";
$lang['requireemailconfirmation'] = "r3QU1R3 3Mail c0NF1RM@+1ON";
$lang['usetextcaptcha'] = "uSE t3X+-c@ptCH4";
$lang['textcaptchafonterror'] = "tEX+-C@P+chA h@s be3n D1S@bL3D 4UToMa+iC4lLY 8eC4U$E tH3r3 4R3 N0 +rU3 +yP3 FOnT$ 4VAIl4BL3 F0R i+ +0 Use. PL34$e UPLO4d $0mE tRuE TyPE PH0N+5 T0 <b>tEXT_caP+cHa/phON+5</b> 0n YoUr $ERv3R.";
$lang['textcaptchadirerror'] = "t3XT-C4PTChA H4$ 83en D1S4blEd 8eC@u5E +3h +eXT_c@p+ch4 dIREC+0RY 4nd $u8-d1r3c+OrIe$ @re N0+ Wri+@Bl3 8y +3H WEb $ErVEr / pHp PR0cE5$.";
$lang['textcaptchagderror'] = "t3x+-C4PtCh4 H4s B33n D1$@BlED BEC@u53 Y0Ur $eRv3r'$ pHp SETup D0E5 NoT pR0V1d3 5UPP0R+ ph0R 9d 1M493 M4nIPuL4Ti0N ANd / 0r TTf FOnT SuPp0RT. boTh @r3 reQuIR3D FoR t3XT-c4PTcHA sUPp0rt.";
$lang['newuserpreferences'] = "n3w useR pRef3r3nCe$";
$lang['sendemailnotificationonreply'] = "eM@1L nOT1f1c4+i0N On R3PlY +O usER";
$lang['sendemailnotificationonpm'] = "em41l notIfICAti0n on pm +0 uS3R";
$lang['showpopuponnewpm'] = "sh0W POPuP wh3n r3c3IviN9 n3w pm";
$lang['setautomatichighinterestonpost'] = "sE+ 4UT0m4+IC H1Gh 1NtER3ST 0n POS+";
$lang['postingstats'] = "pos+1NG 5+A+s";
$lang['postingstatsforperiod'] = "po5TinG s+4+s PH0r P3rIoD %s +0 %s";
$lang['nopostdatarecordedforthisperiod'] = "n0 Pos+ Da+4 REcORd3d F0R +H1$ PEr10d.";
$lang['totalposts'] = "t0+4l P05+$";
$lang['totalpostsforthisperiod'] = "t0+4l P0stS f0R tH1s p3r10d";
$lang['mustchooseastartday'] = "mU$T Cho0sE @ St4rt day";
$lang['mustchooseastartmonth'] = "muS+ ch0O53 4 $+@R+ M0NTH";
$lang['mustchooseastartyear'] = "mUsT cHO0$3 @ 5+@rt Y34R";
$lang['mustchooseaendday'] = "mUSt ch00$3 a 3nd D4y";
$lang['mustchooseaendmonth'] = "mU$+ ch00S3 4 END MON+h";
$lang['mustchooseaendyear'] = "mU$T ChOose @ 3nd yE4R";
$lang['startperiodisaheadofendperiod'] = "st@r+ pErIod is @h3Ad Of 3ND p3rI0D";
$lang['bancontrols'] = "b4N c0NtroL5";
$lang['addban'] = "add ban";
$lang['checkban'] = "cH3Ck b4n";
$lang['editban'] = "eD1+ Ban";
$lang['bantype'] = "b4N TYPE";
$lang['bandata'] = "b4N d4+4";
$lang['bancomment'] = "c0mm3nT";
$lang['ipban'] = "iP b4N";
$lang['logonban'] = "lOg0n 8@n";
$lang['nicknameban'] = "n1cKN@me 84N";
$lang['emailban'] = "em@1L b@N";
$lang['refererban'] = "refeReR 8an";
$lang['invalidbanid'] = "inV4Lid 84N 1D";
$lang['affectsessionwarnadd'] = "tH15 84n mAy 4FFECt Th3 FoLloW1N9 4cT1v3 u53r 5e$$i0n$";
$lang['noaffectsessionwarn'] = "thIs b4N 4Phf3Ct$ n0 @C+1V3 S3s$10NS";
$lang['mustspecifybantype'] = "j00 MU$T $P3c1Fy 4 8@n tyPE";
$lang['mustspecifybandata'] = "j00 musT 5P3cIfy s0m3 B4n D4ta";
$lang['successfullyremovedselectedbans'] = "sucC3$spHUlLY r3MOV3d s3l3C+ED bAnS";
$lang['failedtoaddnewban'] = "fAIL3d +0 @Dd n3W 8@N";
$lang['failedtoremovebans'] = "faILed T0 reM0v3 S0m3 0r 4LL OF Teh 5ElECt3d B4Ns";
$lang['duplicatebandataentered'] = "duPl1c4te b4N D@+4 EN+3ReD. PLe@5e Ch3CK yOuR W1LdC4Rd5 t0 $E3 Iph +h3Y 4lrE4dY M@+CH +h3 D4+@ EN+Er3d";
$lang['successfullyaddedban'] = "succ3$SFulLy 4dd3d BAN";
$lang['successfullyupdatedban'] = "sUccE$5fUlLy upD@+ed b@n";
$lang['noexistingbandata'] = "th3re 1S N0 eX1s+iNg 84n D4+@. to 4DD 4 84N cliCK +HE '4dd NEW' BuTt0N Bel0W.";
$lang['youcanusethepercentwildcard'] = "j00 c@n us3 +HE Perc3Nt (%) wilDc@rD sYM8OL 1n @NY 0ph y0Ur BAn L1STs +o o8+4iN P@RTIal m@+ChE5, 1.e. '192.168.0.%' w0UlD B4N 4lL IP @DdreS5e$ 1N th3 RaNGE 192.168.0.1 THrouGh 192.168.0.254";
$lang['cannotusewildcardonown'] = "j00 C4NNo+ 4Dd % 45 4 w1LdC4rD m4+Ch 0N 1t5 OWn!";
$lang['requirepostapproval'] = "r3QU1R3 PosT @Ppr0v@l";
$lang['adminforumtoolsusercounterror'] = "tHeRe Mu5+ BE 4+ Le4S+ 1 u5ER w1+h adm1n +0oL$ 4ND PHOrUm +OOls @cc3$$ oN @lL PH0rUmS!";
$lang['postcount'] = "p0s+ c0uN+";
$lang['resetpostcount'] = "re$3T P0s+ c0uN+";
$lang['failedtoresetuserpostcount'] = "f@1l3D to Re53+ PoSt coUN+";
$lang['failedtochangeuserpostcount'] = "f41lEd +o CH4n93 US3r p05+ cOuN+";
$lang['postapprovalqueue'] = "pO$T @pPr0V4L QU3u3";
$lang['nopostsawaitingapproval'] = "n0 p05TS 4rE @W@i+1Ng 4pProV4L";
$lang['approveselected'] = "aPPROve 53lec+3d";
$lang['failedtoapproveuser'] = "f4IL3d To 4PproVE uS3r %s";
$lang['kickselected'] = "k1Ck SeLEctED";
$lang['visitorlog'] = "vi$I+Or l09";
$lang['novisitorslogged'] = "no v1$IT0rS l09g3d";
$lang['addselectedusers'] = "add sEleCTED u5ER$";
$lang['removeselectedusers'] = "r3M0v3 53L3c+3d U$ErS";
$lang['addnew'] = "aDD N3W";
$lang['deleteselected'] = "delEt3 SEL3C+ed";
$lang['forumrulesmessage'] = "<p><b>fORUM rULES</b></p><p>\nreG1sTR4tI0n +0 %1\$s Is Fr33! wE D0 Ins15T THA+ J00 4Bide 8Y THe ruLes @nd POLIC1ES deT4IlEd 83Low. If J00 49r3E +0 TeH t3RMs, PL34$3 CheCK +Eh '1 4GRE3' chEck8ox 4nd Pr35$ TH3 'ReG1$T3r' 8u++0N 8elOW. iF j00 WOUlD LiKe t0 C@NcEl +H3 R3Gi5+R4t10N, ClICk %2\$S To R3turn +O +h3 f0RuM$ inD3x.</p><p>\n@lth0uGh +h3 4dm1n1s+R@toR5 @ND m0d3R@T0r$ opH %1\$S WILL @+t3MPt To K3Ep @ll 08j3c+ioN4Bl3 m3SsagES ophPH tH1S PH0ruM, 1t is 1MPOs$18L3 f0r Us T0 r3v13W 4Ll mes$4G3S. All M3$S4g35 eXPR3$S th3 viEWs OF TEH 4u+h0R, @nd N31+h3R thE 0WN3rs 0PH %1\$S, N0r Pr0JEC+ 8EeH1vE pH0RUM ANd 1t's 4PHPh1l14t3S wIll Be HelD rE5PoN$iBlE ph0r Th3 CoNT3nT 0f @NY M3$S@93.</p><p>\nby 4Gr331n9 +0 +He$3 RuL3S, J00 w4rRaNt +h4t j00 WILL nOT POS+ @nY me$549eS +H4+ @R3 08$C3ne, VUl94R, sExU4lLy-0R1EN+4T3D, H4+3Ful, thRe@T3NINg, 0R Oth3rWI53 v1ol@tiV3 0ph 4NY l@W$.</p><p>the 0wNerS 0F %1\$S R3s3rVe +H3 RigHT to REm0V3, 3DI+, m0v3 OR cloSe 4Ny thR3ad phOR @ny r3@$0n.</p>";
$lang['cancellinktext'] = "h3re";
$lang['failedtoupdateforumsettings'] = "f41LEd +0 upd4+3 pHORUM S3++1Ngs. Pl3@$3 +Ry 49@In l@Ter.";
$lang['moreadminoptions'] = "mOre 4dM1n OP+10n$";

// Admin Log data (admin_viewlog.php) --------------------------------------------

$lang['changedstatusforuser'] = "cH4N93D USEr st@tuS f0r '%s'";
$lang['changedpasswordforuser'] = "cH4nGED P@S5w0RD FOr '%s'";
$lang['changedforumaccess'] = "cHAN93d FOrUm @ccE5$ PERm1s5iON$ FoR '%s'";
$lang['deletedallusersposts'] = "dELeT3D @lL PO$+$ PHOR '%s'";

$lang['createdusergroup'] = "cr3@+ED USeR 9ROuP '%s'";
$lang['deletedusergroup'] = "del3teD US3r GROUp '%s'";
$lang['updatedusergroup'] = "upd4teD u$eR gR0Up '%s'";
$lang['addedusertogroup'] = "aDd3d US3R '%s' T0 GRoUP '%s'";
$lang['removeduserfromgroup'] = "r3MOve USER '%s' PhROm Gr0UP '%s'";

$lang['addedipaddresstobanlist'] = "aDD3d 1p '%s' To b4n li5+";
$lang['removedipaddressfrombanlist'] = "reM0VeD 1p '%s' phR0m 84N LiSt";

$lang['addedlogontobanlist'] = "add3d l0g0n '%s' +O B@n L1s+";
$lang['removedlogonfrombanlist'] = "rEM0v3d L0GON '%s' PHr0m baN L1S+";

$lang['addednicknametobanlist'] = "aDd3D NICKN4ME '%s' +0 84N LiS+";
$lang['removednicknamefrombanlist'] = "r3m0VeD n1CKN4mE '%s' PhRom 8an L1$+";

$lang['addedemailtobanlist'] = "add3d 3M@1L 4DDr3$S '%s' +0 B@N L1$+";
$lang['removedemailfrombanlist'] = "r3M0vEd Em41L 4DDReS$ '%s' Fr0m 84N l1S+";

$lang['addedreferertobanlist'] = "adDed r3Ph3REr '%s' T0 b4n Li$+";
$lang['removedrefererfrombanlist'] = "r3mOved R3PH3rEr '%s' FRom 84N l1s+";

$lang['editedfolder'] = "eDited ph0ld3R '%s'";
$lang['movedallthreadsfromto'] = "movED 4LL +HR34d$ fR0M '%s' +0 '%s'";
$lang['creatednewfolder'] = "cR34+3d n3w PholD3R '%s'";
$lang['deletedfolder'] = "d3Le+3D ph0LdER '%s'";

$lang['changedprofilesectiontitle'] = "ch4nged PR0fil3 $eCtI0N T1tle PHROm '%s' +0 '%s'";
$lang['addednewprofilesection'] = "adD3D N3w PR0PhIL3 $ecT1On '%s'";
$lang['deletedprofilesection'] = "d3leTED pR0phil3 SeC+1oN '%s'";

$lang['addednewprofileitem'] = "aDD3D N3W pr0F1Le IT3m '%s' +0 5eC+1On '%s'";
$lang['changedprofileitem'] = "chAn9ed pR0fiLe it3m '%s'";
$lang['deletedprofileitem'] = "d3l3t3d Pr0PHiL3 IteM '%s'";

$lang['editedstartpage'] = "edI+3D s+@R+ P@ge";
$lang['savednewstyle'] = "saVed N3W $+yl3 '%s'";

$lang['movedthread'] = "m0Ved +hRE4D '%s' pHr0M '%s' +o '%s'";
$lang['closedthread'] = "cLOsED +hRE4d '%s'";
$lang['openedthread'] = "op3N3d tHrE@d '%s'";
$lang['renamedthread'] = "r3N4MEd THRE@d '%s' to '%s'";

$lang['deletedthread'] = "d3L3+3D THre4D '%s'";
$lang['undeletedthread'] = "uNd3l3+ED +hr34D '%s'";

$lang['lockedthreadtitlefolder'] = "l0cK3d THR34D 0pTI0nS 0n '%s'";
$lang['unlockedthreadtitlefolder'] = "uNLOckEd +HRE4d opti0n5 0n '%s'";

$lang['deletedpostsfrominthread'] = "d3L3+eD P0$+S PHrom '%s' 1N +hR3@d '%s'";
$lang['deletedattachmentfrompost'] = "d3l3TEd 4tTACHmeNt '%s' Phr0m P0$+ '%s'";

$lang['editedforumlinks'] = "eD1+Ed fOrUm lINk5";
$lang['editedforumlink'] = "eDiT3D pH0RuM l1Nk: '%s'";

$lang['addedforumlink'] = "aDDEd pHORum L1nK: '%s'";
$lang['deletedforumlink'] = "d3LE+3d ForUM LINk: '%s'";
$lang['changedtoplinkcaption'] = "cH4nGeD +0P liNK c4pT10N pHROm '%s' t0 '%s'";

$lang['deletedpost'] = "d3L3teD P0s+ '%s'";
$lang['editedpost'] = "ed1+3d PoSt '%s'";

$lang['madethreadsticky'] = "m4dE +Hr34D '%s' 5+ICkY";
$lang['madethreadnonsticky'] = "m4d3 thr34D '%s' nON-$t1cKy";

$lang['endedsessionforuser'] = "enD3D 53$$ION Ph0r U5Er '%s'";

$lang['approvedpost'] = "aPProV3D p0st '%s'";

$lang['editedwordfilter'] = "ed1+ED W0rD f1l+Er";

$lang['addedrssfeed'] = "aDded rss FEeD '%s'";
$lang['editedrssfeed'] = "eDI+3d Rs$ f3eD '%s'";
$lang['deletedrssfeed'] = "dELe+eD r$s Fe3D '%s'";

$lang['updatedban'] = "upD4t3D BaN '%s'. Ch4NG3D tYPe FrOm '%s' +o '%s', cH4n93D D4+@ phRom '%s' +o '%s'.";

$lang['splitthreadatpostintonewthread'] = "sPlIT +HRE@d '%s' aT P0$+ %s  1n+0 NeW thre4d '%s'";
$lang['mergedthreadintonewthread'] = "mER93d Thr3aDS '%s' 4Nd '%s' inT0 N3w +Hre4d '%s'";

$lang['ipaddressbanhit'] = "u$3R '%s' 1S 84nNeD. ip 4DdR3s$ '%s' m@TchEd B@N d4T4 '%s'";
$lang['logonbanhit'] = "u53r '%s' 15 84nneD. L0gON '%s' m4tcH3d 8@N DAT4 '%s'";
$lang['nicknamebanhit'] = "uSer '%s' I$ B4nNeD. n1CKn@me '%s' m4tch3D b4N datA '%s'";
$lang['emailbanhit'] = "uSEr '%s' 1$ b4nned. 3M4iL Addr35$ '%s' m4+cHED 8@n D4+@ '%s'";
$lang['refererbanhit'] = "u53r '%s' 1S b@NN3d. HT+p REF3r3R '%s' M4TCH3D 8an D4+@ '%s'";

$lang['modifiedpermsforuser'] = "m0D1PhI3d p3RMS ph0r user '%s'";
$lang['modifiedfolderpermsforuser'] = "moDipHIeD f0ldeR PeRMs FOR U$3R '%s'";

$lang['userpermfoldermoderate'] = "fOlD3r MOD3rAtOr";

$lang['adminlogempty'] = "adm1n l0g I5 eMp+Y";

$lang['youmustspecifyanactiontypetoremove'] = "j00 mu$T SP3C1phY @N 4c+I0N TYp3 t0 R3MOV3";

$lang['alllogentries'] = "aLL loG 3N+RI3S";
$lang['userstatuschanges'] = "u$er 5t4+uS CH4ng3s";
$lang['forumaccesschanges'] = "fORUM 4cCe$$ CH4NG3S";
$lang['usermasspostdeletion'] = "u$3r Ma55 pO5+ D3l3T10N";
$lang['ipaddressbanadditions'] = "ip @Ddr3$s 84N @dD1tion$";
$lang['ipaddressbandeletions'] = "iP @DdRESS B4n DeLe+i0N$";
$lang['threadtitleedits'] = "thR3AD T1+lE 3DiT5";
$lang['massthreadmoves'] = "mASs +HRE4D mOVe5";
$lang['foldercreations'] = "foLder CrE@+i0ns";
$lang['folderdeletions'] = "f0lD3r d3l3T1On$";
$lang['profilesectionchanges'] = "pR0PHIl3 sEct1ON ch4N9E$";
$lang['profilesectionadditions'] = "pr0pHIl3 5ec+I0n 4Dd1T10n$";
$lang['profilesectiondeletions'] = "pr0ph1lE 53C+1oN delE+1On5";
$lang['profileitemchanges'] = "prOfiLe It3m CH@N9E$";
$lang['profileitemadditions'] = "pr0pHIL3 1t3m @DDitIoNs";
$lang['profileitemdeletions'] = "pR0Ph1le It3m d3lE+IOnS";
$lang['startpagechanges'] = "sT@rt pa9e Ch4n9e5";
$lang['forumstylecreations'] = "f0ruM S+YLe Cr3@ti0n5";
$lang['threadmoves'] = "tHR34D m0V3$";
$lang['threadclosures'] = "thr34D cL0$UrES";
$lang['threadopenings'] = "thr34D 0p3N1NgS";
$lang['threadrenames'] = "thRe4d rEn4MES";
$lang['postdeletions'] = "p0$t dEL3TIoNs";
$lang['postedits'] = "p0s+ 3D1+$";
$lang['wordfilteredits'] = "woRD pHIL+3r 3Di+5";
$lang['threadstickycreations'] = "tHREAd $+IckY CrE4+I0Ns";
$lang['threadstickydeletions'] = "thr3Ad $TIcKy DeLE+1oNS";
$lang['usersessiondeletions'] = "u5ER s3S5Ion deLe+i0N$";
$lang['forumsettingsedits'] = "f0Rum sET+in9$ 3D1+5";
$lang['threadlocks'] = "thr3Ad lOcKs";
$lang['threadunlocks'] = "thR34d UnlOCk$";
$lang['usermasspostdeletionsinathread'] = "u5Er m4$$ p0$t DEl3+i0n$ iN 4 +Hr3ad";
$lang['threaddeletions'] = "thR34D D3LET10NS";
$lang['attachmentdeletions'] = "aTtAcHM3n+ dEl3+ion5";
$lang['forumlinkedits'] = "f0rum link EDIT5";
$lang['postapprovals'] = "pOST 4PPR0VaL5";
$lang['usergroupcreations'] = "uSer 9ROup CRe4Ti0NS";
$lang['usergroupdeletions'] = "u$Er 9R0Up DEl3t10ns";
$lang['usergroupuseraddition'] = "u5Er 9rOUp USer @Ddi+10n";
$lang['usergroupuserremoval'] = "u$eR 9r0up US3r R3M0V4L";
$lang['userpasswordchange'] = "u5er PaSsWOrd cH4NGe";
$lang['usergroupchanges'] = "us3r 9rouP ChANGes";
$lang['ipaddressbanadditions'] = "ip 4DDR3$$ 84N 4Dd1ti0n5";
$lang['ipaddressbandeletions'] = "ip @DDRES5 B@n d3Le+i0N5";
$lang['logonbanadditions'] = "l0GoN 8@N 4dD1TiONS";
$lang['logonbandeletions'] = "lOg0N B4N D3l3tION$";
$lang['nicknamebanadditions'] = "niCKN@M3 84N 4DD1+Ion5";
$lang['nicknamebanadditions'] = "n1CkN4Me B4n @DD1T10N$";
$lang['e-mailbanadditions'] = "e-M@1l 84N 4DD1+I0NS";
$lang['e-mailbandeletions'] = "e-M@1L 84n D3l3T10N$";
$lang['rssfeedadditions'] = "r5S pHeEd 4Ddit10n$";
$lang['rssfeedchanges'] = "r5$ pH3ed CH@N93$";
$lang['threadundeletions'] = "thR34D UNDele+1on$";
$lang['httprefererbanadditions'] = "h+Tp REPH3rer BAN 4dD1+10n$";
$lang['httprefererbandeletions'] = "h++p RePhERer B@N DEl3+I0Ns";
$lang['rssfeeddeletions'] = "rss ph3eD deletI0n$";
$lang['banchanges'] = "b@n cH4N9es";
$lang['threadsplits'] = "tHRE4d 5PL1+5";
$lang['threadmerges'] = "thRE@D mER9E5";
$lang['forumlinkadditions'] = "f0RUM l1nK @DdIt1ons";
$lang['forumlinkdeletions'] = "forUm L1NK DEl3tI0ns";
$lang['forumlinktopcaptionchanges'] = "fOrUM Link t0p C4P+1On CH@NGE$";
$lang['folderedits'] = "f0lDER 3DI+5";
$lang['userdeletions'] = "uS3R D3L3+I0N$";
$lang['userdatadeletions'] = "user D4t@ dElE+i0N5";
$lang['usergroupchanges'] = "us3R 9R0up CHaNg3$";
$lang['ipaddressbancheckresults'] = "ip 4Ddre5s 84N ch3cK Re5uLT$";
$lang['logonbancheckresults'] = "l090N B@n CheCK r3Sul+S";
$lang['nicknamebancheckresults'] = "nICKNam3 8@n cHECk R3$Ul+$";
$lang['emailbancheckresults'] = "eM41l 8@n ch3Ck R35UlT$";
$lang['httprefererbancheckresults'] = "h++p rEpH3R3R b@n chECk re5ultS";

$lang['removeentriesrelatingtoaction'] = "r3mOV3 eNtRie$ ReL@+1nG +0 @C+I0N";
$lang['removeentriesolderthandays'] = "r3m0v3 eN+R1ES OLd3r +h@N (d@ys)";

$lang['successfullyprunedadminlog'] = "suCC3$$fuLlY PRuN3D 4dm1n l0g";
$lang['failedtopruneadminlog'] = "fA1l3d to prUn3 4dM1n L09";

$lang['successfullyprunedvisitorlog'] = "sUCC3S$FUllY pruneD vIsI+0R Lo9";
$lang['failedtoprunevisitorlog'] = "fAIL3D +O PrUN3 Vi$it0r LO9";

$lang['prunelog'] = "prUN3 lo9";

// Admin Forms (admin_forums.php) ------------------------------------------------

$lang['noexistingforums'] = "no eXi$+INg f0rUM5 fouNd. t0 cRE4Te 4 N3W pH0rum cl1CK +HE '4dD n3w' but+0N 8EloW.";
$lang['webtaginvalidchars'] = "w3BT49 C@n oNLy c0n+4In uPp3RC@S3 4-z, 0-9 4ND UNdER5c0RE cHaR@C+3R$";
$lang['databasenameinvalidchars'] = "dA+4b@53 n4m3 c4n 0nlY Con+Ain 4-Z, @-Z, 0-9 aNd Und3rScOr3 Ch4R@CteR5";
$lang['invalidforumidorforumnotfound'] = "iNv4lid f0RUM phiD Or ForUm N0+ Ph0uNd";
$lang['successfullyupdatedforum'] = "suCc355PHULLy UpDA+ed PH0RUm";
$lang['failedtoupdateforum'] = "f41LEd TO UPd@TE f0RUm: '%s'";
$lang['successfullycreatednewforum'] = "succ355pHuLLy cRe@t3d NEw ForUM";
$lang['selectedwebtagisalreadyinuse'] = "the 5ElEC+3D wE8t49 i$ 4lr3aDy 1n us3. pLE@5E cH00$e an0th3r.";
$lang['selecteddatabasecontainsconflictingtables'] = "tEh 53L3cted Da+48@s3 COn+@in$ COnfl1C+1n9 +4ble$. coNphLic+1n9 +48L3 N4M3$ @Re:";
$lang['forumdeleteconfirmation'] = "ar3 J00 $URe J00 W@n+ tO D3LET3 aLl 0ph THE $3leCted FoRuM5?";
$lang['forumdeletewarning'] = "pLE4se N0+3 th4+ j00 C@Nno+ r3C0V3R dElEted phORuM$. 0NC3 DeLE+eD 4 pH0rUm @Nd 4LL 0f +3H 4$sOc14+eD D4T@ i5 P3RM4n3N+lY rEm0v3D PHr0M +H3 D@+@845e. If j00 do n0+ W15h +0 D3lET3 tHE SELeC+3d PhoRUMS pLE4$3 cLIcK c@ncEL.";
$lang['successfullyremovedselectedforums'] = "sUcCE5sfuLLY D3L3tEd seleC+ED forUm5";
$lang['failedtodeleteforum'] = "f41LED +o Delet3D f0Rum: '%s'";
$lang['addforum'] = "adD PHoRum";
$lang['editforum'] = "ediT ph0Rum";
$lang['visitforum'] = "vI$1+ phORUm: %s";
$lang['accesslevel'] = "acc3s$ LevEL";
$lang['forumleader'] = "f0rUm l34DER";
$lang['usedatabase'] = "uSe D4T48@SE";
$lang['unknownmessagecount'] = "uNkNOWn";
$lang['forumwebtag'] = "f0Rum WEB+4G";
$lang['defaultforum'] = "dEpHAULt PHOruM";
$lang['forumdatabasewarning'] = "ple@$3 3NSuRE J00 $3LeCt +3h c0rrec+ D@T48aS3 WHEn CR3A+iN9 A NEW PHORum. 0nCe CR34+Ed 4 n3w foRUM c@nn0t 83 M0v3d B3TWeEn 4V41L4Bl3 D4+@B45eS.";

// Admin Global User Permissions

$lang['globaluserpermissions'] = "gLoB4L useR PeRm1$sIONs";

// Admin Forum Settings (admin_forum_settings.php) -------------------------------

$lang['mustsupplyforumwebtag'] = "j00 MusT $UPpLY @ F0rum w38+49";
$lang['mustsupplyforumname'] = "j00 MUst $UpPlY 4 ph0Rum n@M3";
$lang['mustsupplyforumemail'] = "j00 mUST suPPlY 4 PhoRuM EMAIl 4ddR3SS";
$lang['mustchoosedefaultstyle'] = "j00 MU$t cHo05E A d3PH4Ul+ fOruM $+Yle";
$lang['mustchoosedefaultemoticons'] = "j00 mu5t CH0O$E dEF@Ul+ ForuM EMO+ic0NS";
$lang['mustsupplyforumaccesslevel'] = "j00 MU$t supPlY 4 foruM @CcES5 l3V3l";
$lang['mustsupplyforumdatabasename'] = "j00 mU5t SUpPLY 4 f0RUm Dat484S3 naM3";
$lang['unknownemoticonsname'] = "uNKnoWn eM0+IconS n4mE";
$lang['mustchoosedefaultlang'] = "j00 MUs+ CH0Os3 @ dEPhAuL+ PhOrUM l4N9UA93";
$lang['activesessiongreaterthansession'] = "aCtiVE S3S$i0N timeOuT C4NNo+ 83 9r3@+3r +h@N sES$1on tImE0U+";
$lang['attachmentdirnotwritable'] = "a++4CHMeNT DIr3CtORy AND $YStEm +eMPOR4ry D1reC+0rY / php.1nI 'UPLo4d_tMp_D1r' MUst 83 Wri+Able BY Th3 we8 $ErVer / pHP PR0ceSS!";
$lang['attachmentdirblank'] = "j00 mUST 5upply 4 dir3ct0Ry tO $@v3 4++4ChMEn+S 1N";
$lang['mainsettings'] = "mA1N 5Et+In95";
$lang['forumname'] = "f0rum n@Me";
$lang['forumemail'] = "f0RUM 3M4iL";
$lang['forumnoreplyemail'] = "no-r3Ply EmAil";
$lang['forumdesc'] = "f0RUm D3sCR1P+i0N";
$lang['forumkeywords'] = "fORuM keYwOrd$";
$lang['defaultstyle'] = "depH4ULt $+Yle";
$lang['defaultemoticons'] = "dEF@ul+ emoT1c0N5";
$lang['defaultlanguage'] = "d3Ph@Ul+ l4n9u4g3";
$lang['forumaccesssettings'] = "f0rum @CCe$5 setT1NgS";
$lang['forumaccessstatus'] = "forum @ccE5$ $t@+US";
$lang['changepermissions'] = "cH4N9E P3RM1ssIONS";
$lang['changepassword'] = "ch4N93 p4$$W0Rd";
$lang['passwordprotected'] = "p45SwORD prot3CT3D";
$lang['passwordprotectwarning'] = "j00 h@vE no+ S3+ @ ph0RUm p@$Sw0RD. If j00 dO N0+ $3t 4 p45SWord +He p45$word Pr0+ect1oN pHuNCt1On4liTY WIll B3 4U+0M4+ic4lly dI$a8l3D!";
$lang['postoptions'] = "pO5+ 0P+1ons";
$lang['allowpostoptions'] = "alLOW PoS+ EdI+1ng";
$lang['postedittimeout'] = "p0ST 3d1t T1Me0U+";
$lang['posteditgraceperiod'] = "pOst eD1+ Gr4Ce p3Riod";
$lang['wikiintegration'] = "wIk1wiK1 iN+3gR4T1on";
$lang['enablewikiintegration'] = "en4BL3 wIKIWIkI INT3gr@Ti0N";
$lang['enablewikiquicklinks'] = "eNAbLE w1k1w1k1 quIcK Link5";
$lang['wikiintegrationuri'] = "w1k1wik1 loc4t10n";
$lang['maximumpostlength'] = "m4X1MuM P0sT lenGTh";
$lang['postfrequency'] = "p0ST phr3qUENCy";
$lang['enablelinkssection'] = "eN@BLE L1nk5 $3C+10N";
$lang['allowcreationofpolls'] = "alLow CR34+10n 0F pOlL$";
$lang['allowguestvotesinpolls'] = "aLl0w GU35Ts To v0T3 1N P0lL5";
$lang['unreadmessagescutoff'] = "unre@d m3$$@Ges cuT-0PHPh";
$lang['disableunreadmessages'] = "d15ABL3 uNR3@D m35s4935";
$lang['thirtynumberdays'] = "30 d4y5";
$lang['sixtynumberdays'] = "60 d4YS";
$lang['ninetynumberdays'] = "90 D4Y5";
$lang['hundredeightynumberdays'] = "180 D4yS";
$lang['onenumberyear'] = "1 Ye4R";
$lang['unreadcutoffchangewarning'] = "dEp3ND1N9 ON seRv3r P3Rph0rM@NC3 4nd THe NUM8Er 0Ph +HRE4dS y0ur pH0rUM$ c0NT@in, cH4N91n9 +He UNr34D CU+-oPhF m4y T@k3 $EVER4l MINU+35 tO ComplE+3. PHOR +HI5 R34s0n it 15 ReC0mM3NDeD tH4T J00 avO1d ch4Ng1N9 +hiS 53++InG Wh1LE Y0uR PH0RUm$ 4re bu$Y.";
$lang['unreadcutoffincreasewarning'] = "iNcr34S1ng +h3 unr3AD cU+-oFF wIlL r3sUl+ IN +hRE@D$ 0lD3r +H@n T3h cuRr3NT CuT-0fpH 4PPE4r1NG 4$ UNrE4d Ph0R @lL u53r5.";
$lang['confirmunreadcutoff'] = "aRE j00 suRE j00 w4N+ tO ch4n93 tEh UNR3@D cUt-OFf?";
$lang['otherchangeswillstillbeapplied'] = "cliCkIn9 'NO' wIlL 0NLY c4Nc3l teH Unre4D Cut-OfPH cH4N9es. 0THEr Ch4NgE5 Y0u'Ve M@d3 w1Ll 5+ilL 83 s4vED.";
$lang['searchoptions'] = "sE@rCh 0P+10N5";
$lang['searchfrequency'] = "se@Rch FrEQUenCY";
$lang['sessions'] = "s3$s1On$";
$lang['sessioncutoffseconds'] = "sEs$I0n CU+ 0pHF ($Ec0nDS)";
$lang['activesessioncutoffseconds'] = "aCt1v3 $3S$1on cut OPHF ($3c0nd$)";
$lang['stats'] = "s+4+$";
$lang['hide_stats'] = "hIdE 5t@T5";
$lang['show_stats'] = "sh0w 5+4tS";
$lang['enablestatsdisplay'] = "eN@8l3 5+4+s di5pl4Y";
$lang['personalmessages'] = "peRS0n@L m3s$4g35";
$lang['enablepersonalmessages'] = "eN48lE pERsOn@L M3S$493S";
$lang['pmusermessages'] = "pM m3SS4GE5 P3R U$er";
$lang['allowpmstohaveattachments'] = "alL0w P3RSOn4l M3Ss493$ +0 H4VE 4+T@ChMenT$";
$lang['autopruneuserspmfoldersevery'] = "aUT0 prUNe u$3r'S PM pH0lder$ Ev3rY";
$lang['userandguestoptions'] = "usER @Nd 9U3$t 0pt1On5";
$lang['enableguestaccount'] = "eNa8l3 9u3st 4Ccoun+";
$lang['listguestsinvisitorlog'] = "l1ST guE$ts 1n vIs1+Or l0g";
$lang['allowguestaccess'] = "aLl0w gu3s+ 4ccEs$";
$lang['userandguestaccesssettings'] = "u53R 4nd GU3$+ Acc355 5Ett1Ng$";
$lang['allowuserstochangeusername'] = "aLL0W uSER5 +o Ch@NGE usErN4ME";
$lang['requireuserapproval'] = "rEQuIrE useR 4pproV4L 8Y 4dm1n";
$lang['requireforumrulesagreement'] = "rEQU1re u53r +o @gR33 +o forUm RULE5";
$lang['sendnewuseremailnotifications'] = "s3nD N0T1F1c4+ion +0 gl084L PhORuM 0WN3r";
$lang['enableattachments'] = "en48l3 4++4CHmen+$";
$lang['attachmentdir'] = "a++@ChM3N+ dIR";
$lang['userattachmentspace'] = "a+t4cHM3n+ 5PaC3 P3R u$eR";
$lang['allowembeddingofattachments'] = "allow 3M83ddin9 oph AT+@CHm3Nts";
$lang['usealtattachmentmethod'] = "u$e 4L+3Rn4+1V3 4++@CHM3nt MethOD";
$lang['allowgueststoaccessattachments'] = "aLL0w gU3s+$ to aCc35$ at+@chMeN+$";
$lang['forumsettingsupdated'] = "f0RUM 53+t1n9S $UCc35$PhULLY Upd4ted";
$lang['forumstatusmessages'] = "f0RuM S+4Tu5 mEss4Ges";
$lang['forumclosedmessage'] = "f0RUM cl0$3d m3$$A9e";
$lang['forumrestrictedmessage'] = "f0ruM R35Tr1CTeD messAg3";
$lang['forumpasswordprotectedmessage'] = "forUM P4$SW0RD pR0+Ec+eD MesS493";

// Admin Forum Settings Help Text (admin_forum_settings.php) ------------------------------

$lang['forum_settings_help_10'] = "<b>pO5T ed1+ Tim3Ou+</b> Is +3H +iME 1N mINute5 @PHteR P0$TIN9 +h4t 4 US3r c@N 3dIt tHe1R P0sT. IF $3+ +o 0 +Her3 1s N0 l1m1+.";
$lang['forum_settings_help_11'] = "<b>m4XimUm P0st L3ngth</b> i$ Th3 m4XImUM NuM83r OF cH@R@C+eR$ +h@T Will be Di5pl@Y3d in @ p0$+. 1F 4 p0ST 1s loNG3R +H4N tH3 Num83R 0F cH4r4c+ErS dEf1nEd h3rE it W1Ll bE cUt sH0RT 4nD @ l1Nk 4dD3d +0 tH3 80t+0M +o alL0w U5eRs tO Re@D +eH WH0l3 pO5+ oN 4 s3p4R4t3 pag3.";
$lang['forum_settings_help_12'] = "if j00 DON'+ w4nt yOuR uSEr5 to Be Abl3 +O CrE4TE pOll$ j00 c4n d154BlE TEh 480V3 op+ION.";
$lang['forum_settings_help_13'] = "teh LINk$ s3C+I0n 0Ph B3EHiVE pr0vidE$ 4 pl4ce f0r YouR u$3Rs T0 M41N+@In @ LISt 0PH 51TeS ThEy PhrEquen+ly vi51+ +H4T 0TH3R uS3Rs M4y fInD u$eFUL. LInks C4N b3 div1d3d in+O C4T3g0rie5 By pH0lDEr @Nd @LLow f0R C0Mm3N+s 4nd r@+1N95 +o be 9iVeN. 1n oRd3R +o modER4T3 tH3 L1nKs 5eCt1On 4 Us3r mUsT 83 r4n+3D Gl084L MoD3R4t0r st4TU5.";
$lang['forum_settings_help_15'] = "<b>se$SI0N cu+ 0pHf</b> I5 +He m4ximuM +IM3 83F0RE 4 u$ER'S ses$i0N Is D33med DE@D 4ND +h3Y 4R3 Lo9geD ouT. 8Y dEF4uLT +h1s 1S 24 HoURS (86400 secONd$).";
$lang['forum_settings_help_16'] = "<b>aC+1V3 $eS510N cu+ OpHF</b> 1$ +EH M4xImUm +1mE 83PhOR3 @ U53r'S $Es$10n 1$ de3M3d iN4Ct1Ve 4+ wh1cH POInT +h3Y 3N+er 4n idL3 sT4+e. 1n Th15 s+a+3 th3 UseR R3Ma1Ns logg3D iN, but THeY aR3 reMoV3d frOM +3H 4C+IVe u53RS li5T In +H3 sTaTS DisPl@y. 0NcE TheY BEc0Me 4cTIve @9@1n tH3Y W1lL BE re-@dD3d t0 +3h li$t. 8Y deph@ulT +H1$ sEt+1n9 IS SE+ TO 15 m1Nut3S (900 s3C0NDs).";
$lang['forum_settings_help_17'] = "eN@8l1ng +HI$ 0p+iON 4lLoWs 83EHive +o 1nCLuD3 4 st@ts d15Pl4y 4t +H3 b0++OM OF tHe Me$S@gES p@n3 siMIL4r T0 +eH 0N3 usEd 8Y M@Ny foRUm Sof+W4r3 T1Tle$. oNc3 en4bLeD ThE D15pl@Y oF +he s+@+s P@93 c4n BE +o9gled InD1v1dU@LlY bY E4Ch u5Er. iF +H3y DoN'T w4Nt +0 S3E 1+ +Hey c@n h1De 1+ PhroM vi3W.";
$lang['forum_settings_help_18'] = "peRSoN@L m35S@gEs ArE INV@Lu4BLE @5 4 WAy OF +@k1N9 M0re PR1v4+3 m4+TER$ ou+ 0F V1Ew OPH +H3 0Ther m3m83rS. hOwEVer 1f J00 doN't W4Nt Y0UR u$3R$ +0 BE @8le +0 sENd 34cH O+Her p3RS0n4L MEsSAgES j00 C4n d1s4ble this opTi0n.";
$lang['forum_settings_help_19'] = "persoN@L M3$5@9E$ c@n 4l$0 c0Nt@1N @T+@chMeN+$ wH1Ch C4n 8e USepHul pHOr exCh4N9in9 F1L3s b3TW3En uS3R$.";
$lang['forum_settings_help_20'] = "<b>n0+3:</b> +He SpAC3 @LL0Ca+I0N ph0r PM 4tTAChmeNT$ 1S T4K3N FR0m 34cH Us3RS' MAIn 4+T@ChM3N+ @lLOC4+10N AnD I$ NOt iN 4dd1Ti0N to.";
$lang['forum_settings_help_21'] = "<b>eN4bL3 9UEsT 4CcOUN+</b> 4lloW5 V15i+ORS +O 8rOw$e Y0uR pHorUM 4ND R34D p0STS W1TH0u+ R3G1$Tering 4 u5eR @CCouNT. 4 UsER 4cCOunt is sT1Ll r3qU1rED If thEy W1$H t0 PO$t or cH4n9e uS3r PREPh3REnCeS.";
$lang['forum_settings_help_22'] = "<b>li$t gU3sTs in v1$ItoR l0G</b> 4lL0W$ J00 +O 5p3C1pHy wh3+H3r Or N0+ UNreGI5T3r3D uS3rs 4rE l1$+3d On +3h VISI+0r lOG aL0nG$1De RE915t3r3d USer$.";
$lang['forum_settings_help_23'] = "b3eHive AlL0ws 4+T4CHM3nt$ t0 83 upL04DeD +O m3sS493s WheN Po5teD. iF J00 h4V3 liM1t3D wEB Sp@c3 j00 M4Y WHIcH +O Di$48LE @++@CHm3NT5 bY Cl34rIn9 +3H 80x 48ov3.";
$lang['forum_settings_help_24'] = "<b>a+TAChm3NT d1R</b> IS t3H l0C4T1On 8E3H1v3 $HOuLD sT0re a++4chM3n+$ 1N. tHI5 D1R3cT0rY Mu5T 3Xist On yOur W3b $p@Ce and MUs+ 8E wRi+48L3 8Y Teh w38 s3rVEr / pHP Pr0c35s 0+HERW1Se UPLO4DS w1lL f4iL.";
$lang['forum_settings_help_25'] = "<b>aTT4ChmEnT 5P4CE P3R uS3r</b> I$ TeH m4X1MUM @m0UNT 0ph d1$k 5P4C3 A U$Er H45 f0R aTt4ChmEN+$. 0nc3 +H1S 5PAc3 1S u5ed UP tHe u53r c@NN0+ uPLo@D 4Ny M0R3 @++@chM3N+5. 8Y dEpH4UL+ th1s is 1M8 0f sp4CE.";
$lang['forum_settings_help_26'] = "<b>all0w emb3dDiN9 OF @+t4cHM3nT5 1n M355@GEs / S19N4+uR3s</b> 4LL0WS U53rS To 3Mb3D 4+T@CHMentS In P0s+5. eN4blIN9 +h1$ 0p+1oN Wh1L3 Us3fUl c4n 1NCr3@s3 Y0uR 84NdWIdTh Us4g3 dRA$+iC4lly UNDeR CERT@1N C0NfIGuR4TioN$ 0PH PhP. IpH j00 H4V3 L1mi+Ed B@ndWid+H iT Is r3cOMM3Nd3D +h@T j00 d1$48L3 +hi$ op+IoN.";
$lang['forum_settings_help_27'] = "<b>us3 4LtERN4+iV3 @++@cHM3n+ metHOd</b> pHorc3S 833HIv3 TO u$e @n 4lterN4tIve R3Tr1ev@L M3ThOD pH0R @T+AChm3NTS. if J00 R3C31vE 404 ERROR mEs$4GE$ wHeN TrY1n9 T0 d0WNlO4d 4++@cHm3n+S fr0M MeS$4G3$ +Ry 3N4blin9 +h1S 0p+1on.";
$lang['forum_settings_help_28'] = "tHeSe $3++1N9S 4llOw5 y0Ur PhoRUm +O 8e sPIDerEd By S34rCH 3NGine5 l1K3 g009L3, 4l+4vIS+4 aND Y4hO0. 1ph J00 Sw1tCh +HI$ OPt1ON 0ff Y0Ur f0ruM W1ll Not 83 1NClud3D 1N tH3$e s34RcH EN9inE$ r3Sul+$.";
$lang['forum_settings_help_29'] = "<b>allOW NEw u$3R r3G1S+R@+i0n$</b> 4Ll0WS Or di5alL0Ws THE cR3@tI0N 0F N3W uSer 4cCOUN+S. S3+TiNG teh OPT10n t0 n0 coMpLe+ElY dI$48L3s t3H r3giSTR4+iON F0rm.";
$lang['forum_settings_help_30'] = "<b>eN4bl3 W1KiW1Ki 1ntegR@+I0N</b> PRoV1d35 W1k1woRd 5uPPorT 1n y0ur PH0rum P0STS. 4 W1k1w0rD I5 m4De uP 0f +WO 0R M0Re coNC4T3N4teD wOrD5 WITH upperc45E LeT+3rS (0PHt3N R3f3rred +O 45 c4mElc@s3). IF j00 wR1+3 4 WoRD +H1S W@y 1T w1Ll @u+om@TICAlLy 83 cHAngeD iN+0 A HYPERLinK P0in+1N9 t0 YouR CHos3n w1k1wikI.";
$lang['forum_settings_help_31'] = "<b>en4bL3 WIK1Wik1 quiCK LinkS</b> 3n@8Le5 +EH UsE 0f msg:1.1 @nd u$3r:l09On stYLE EXt3ndeD wik1L1NKs Wh1ch Cr3@+3 HyPERLinK$ T0 tHE 5P3cIfi3D M35S4g3 / U$ER prOf1lE 0F +H3 SP3cIF13d U$3R.";
$lang['forum_settings_help_32'] = "<b>wIKiw1KI l0cA+1ON</b> 1S u$3d +0 sp3cIPHY +hE UR1 Oph yOUr WIk1wIk1. wh3n entErINg The uri uSe <i>%1\$5</i> T0 iNd1ca+e wheRE iN tHE URI +he w1K1w0rD sh0uld @pP34R, 1.E.: <i>hTtP://en.WIk1PEd14.0R9/W1kI/%1\$5</i> W0ULd liNk your wIk1w0RD5 to %s";
$lang['forum_settings_help_33'] = "<b>foruM @CCE$$ 5t4+U5</b> COnTRoLs h0W u$3r5 M4y @CCE$s y0UR F0ruM.";
$lang['forum_settings_help_34'] = "<b>opEN</b> w1LL ALLoW 4LL uSeRs 4nd GUE$+5 ACces5 T0 Y0UR f0rUm Wi+H0ut R35+RIC+IoN.";
$lang['forum_settings_help_35'] = "<b>cl0$3d</b> Pr3veNTs 4CCE55 PH0r @LL uS3r$, WItH +H3 eXc3P+i0n OPh +eh AdmIN WH0 m4y $+1lL 4CCe55 +EH 4DmIn P@N3L.";
$lang['forum_settings_help_36'] = "<b>rEStric+3d</b> 4llow$ +o sEt 4 lis+ OF US3R5 wh0 aR3 @ll0W3d 4cCe5$ +o Y0UR f0RuM.";
$lang['forum_settings_help_37'] = "<b>p4ssWoRd pRO+EcteD</b> 4LLowS J00 +0 $3t 4 Pas$W0rD T0 91V3 0Ut +0 U53r5 s0 thEY C4N @Cc3S$ YOur FORUm.";
$lang['forum_settings_help_38'] = "wHeN $3t+1N9 R35Tr1ctEd 0R p4$sw0Rd pRO+EcTed M0De j00 w1ll Ne3D +0 s4vE y0uR cH4NgES B3FORe J00 C4n chANGe th3 u$Er 4ccEs5 PR1v1L39e5 0r p@S5worD.";
$lang['forum_settings_help_39'] = "<b>Search Frequency</b> defines how long a user must wait before performing another search. Searches place a high demand on the database so it is recommended that you set this to at least 30 seconds to prevent \"search spamming\"fROm K1ll1NG +Eh S3RVeR.";
$lang['forum_settings_help_40'] = "<b>po$T PHR3Qu3nCY</b> 1$ +H3 m1n1mUm +ime 4 u$er mUS+ w41T 8EPh0rE +h3y C4n poS+ 4941n. tH1S se+T1ng 4l$O @PHpH3Cts ThE cR34tiON 0Ph PoLls. $3T t0 0 t0 Di$@8lE T3h r3s+riC+IoN.";
$lang['forum_settings_help_41'] = "t3H @8ov3 0pT1On$ cH4N9e tEH DEPhAUlT v4lu35 FoR ThE uS3r R391Str4t1On fOrM. WhER3 apPLIC48L3 oTH3R $3+T1N9s W1LL U5E Th3 f0RUM'$ oWN d3PH@uLT se+T1nGS.";
$lang['forum_settings_help_42'] = "<b>pR3v3N+ U$e OpH DupLiCATE 3M@IL @dDr35$3S</b> PHOrc3s beehiv3 to CheCK TH3 us3r 4cC0uN+S 4G4in5T TeH 3M@1L @DDr3$S +he uSeR 15 rEG1S+3R1N9 WI+h 4nd pr0mPT$ ThEm +0 u5E 4n0THER IF It 1S 4Lr34dy iN Use.";
$lang['forum_settings_help_43'] = "<b>requ1Re em41L C0NF1RM4Ti0n</b> wH3n eN@Bl3D W1LL SeNd 4n 3m41L t0 3@Ch n3w u$3r wi+H 4 L1Nk th4T Can 8E U$3d t0 CoNpHirm +heIR em4Il @dDres$. uNt1L TheY CoNPhiRM tHE1r EM4iL addREsS they WILl NO+ b3 4ble TO pOs+ UnL3s5 +heiR U5er pErm1S$10NS 4RE ch4ngeD m4nu@llY BY @N @DmIN.";
$lang['forum_settings_help_44'] = "<b>uS3 +3Xt-C@p+Ch4</b> PRe53n+$ +3h NeW u5eR Wi+h a m4n9L3d IM@G3 whICh tH3y MU5t CopY 4 NUmB3R phRom 1nt0 4 +ex+ Ph1ElD ON +eH reg1$TR4+ION PHoRM. uS3 th1s 0pT10N TO pr3Vent 4u+Om4t3d S1gn-Up v1@ $CRipT$.";
$lang['forum_settings_help_47'] = "<b>post edi+ gr4C3 P3ri0D</b> 4ll0W5 J00 t0 d3Ph1n3 4 PeRI0d iN m1nUtEs whEr3 Us3RS m@y 3d1+ p0S+$ W1+hou+ +he '3d1tED bY' TExt 4Ppe4R1N9 ON THEir P0$+s. 1pH $Et +o 0 tH3 '3d1+3d bY' +exT W1LL aLW4YS 4ppe4r.";
$lang['forum_settings_help_48'] = "<b>uNre@D M3$S@93$ CUT-off</b> spEC1pH13S HoW L0Ng m3S5@9es R3mA1n Unr3AD. +hR3@ds mOdIf1ed No L4+Er +h4N +h3 peRiOD SeLEcteD wilL @Ut0M4+1c4lLy 4pp3ar @5 r34D.";
$lang['forum_settings_help_49'] = "cHO0SiNG <b>d1$48le UnR3@d m3S$A93S</b> wIll COmpl3TelY REmoV3 unr34D MEsS@9E$ $uPp0r+ 4ND REM0v3 +3H REl3V@NT 0Pt10nS FroM tEh dI$CuSs10N tYp3 dr0P DOWn on +h3 thRE@D l15T.";
$lang['forum_settings_help_50'] = "<b>r3QUIr3 u$Er aPPR0V4L 8Y @Dm1N</b> AlL0W$ J00 +0 rE$+R1ct @cCE$S BY n3W uS3R5 UN+1L +h3y hAVe 8e3N @ppR0Ved 8Y @ m0D3r@T0r or 4DMIn. w1tHoUT AppR0V4l 4 US3R c4nN0t 4Cc3$s @NY AR34 0F +hE bE3hIVE phOruM 1NST4ll4+10n 1ncLUD1n9 iNDIvidu4l foRUMS, pM IN8oX 4nD mY fOrUms S3C+1oNs.";
$lang['forum_settings_help_51'] = "uSe <b>cLOseD ME5s@93</b>, <b>r3s+riC+3d ME$54gE</b> 4ND <b>p4$5w0Rd pRO+ec+Ed me$Sa93</b> T0 cuS+0Mi$3 +h3 M3s$@G3 DI$Pl@Yed WH3n uS3R$ 4cC3ss Y0UR forUm In +HE V4R1OUS S+4tes.";
$lang['forum_settings_help_52'] = "j00 C4n u$3 h+ml In yOuR M3$$49eS. hYpeRlINkS @nd em@1L 4ddR3s$ES w1ll @lso Be @U+om4+1C4lLy C0NveR+3d +O liNk$. TO USE +Eh DEf@UL+ 8eeHIV3 f0RuM ME5$49es ClEaR ThE pH13ldS.";
$lang['forum_settings_help_53'] = "<b>aLL0W U53rS +o ch4N9e Us3rN4ME</b> p3RMI+S 4Lr34dy r3g15+EREd US3r5 t0 ch4N9e +He1R us3rNAm3. When 3NAblED J00 c4n +R4cK Th3 cHAN93s @ u$3r M4K3$ TO tHEir U5eRN@me v1@ +HE 4dmIN U$eR toOl$.";
$lang['forum_settings_help_54'] = "u$E <b>f0RUM rUl3S</b> T0 3NT3r an 4CC3PT48L3 use pOLICy TH4t 3@Ch u53R mUs+ 4Gr3E +0 8ePHoRe R3gis+3r1N9 on Y0uR ForUm.";
$lang['forum_settings_help_55'] = "j00 C4N U53 hTmL 1N Y0UR PhoruM RUL3s. hyP3RlInK5 4ND EM4IL 4DdR35$3$ W1LL @L50 83 4Utom4+1c@LlY cONVER+3D t0 link5. +o u$E tEH dEpH@ul+ BEEH1ve PHOruM 4up clE4R tHe F13lD.";
$lang['forum_settings_help_56'] = "u$3 <b>no-r3Ply 3m@il</b> To 5peciPHY AN 3M4iL 4DdrE5$ th4t Does No+ EX1$+ 0R W1lL N0+ 8e moni+0Red pHoR R3PliE$. +h1$ Em4IL 4ddr3$S WiLl 83 Us3d 1N TH3 h34DErS F0R alL 3m@1lS seNt pHRom yoUR ph0rUm iNCluDiN9 8uT N0+ l1M1T3D +0 PO5+ 4nD PM No+if1C4TI0NS, USeR 3m4iL$ 4Nd P@55wORd rEm1nd3RS.";
$lang['forum_settings_help_57'] = "i+ I5 REC0mmEndeD tH4+ J00 us3 @n 3M@1L 4DDr35s +H@t DO3S n0t EXiS+ T0 HELp cu+ DOwN 0N sP4m tH4T M4Y b3 D1rEct3d 4+ y0Ur m4iN f0rUM eM@1l 4DdRESs";
$lang['forum_settings_help_58'] = "in 4DD1+IoN +0 $1MpLE SP1d3R1N9, bE3H1V3 C4n aL$0 gEnEr@t3 4 siTem@P fOR tHE pH0Rum t0 m4k3 1T E4SIER pHOR $34RCh eN9IN3$ TO FINd 4Nd INdeX th3 mEsSA93$ poS+ed 8y y0UR u$erS.";
$lang['forum_settings_help_59'] = "s1t3m4PS ARE 4U+OM4T1C@lLY S@V3d t0 +Eh $1+EM4pS $U8-d1R3C+oRy oPh y0UR b3EH1ve FORum 1N$T@ll4t1ON. IF Thi5 d1rec+oRY DOe$N'T eXI$+ J00 MuST CrE@t3 1t And 3N5uR3 TH4t I+ 1$ WR1+4Ble By thE S3Rv3r / PHp PR0c3$$. +O 4lLOw se4RCh 3N91n35 +0 FiND Your $1+3m4P J00 mUs+ 4dd teh URl +0 y0UR R0BO+5.tx+.";
$lang['forum_settings_help_60'] = "d3penDInG On Serv3r P3RfOrmaNc3 anD +Eh NUMB3R OPh PhOrUMS 4nd +Hr3adS YoUR 8eEHive INSt@LL4+1On C0nt@1NS, G3NEr4tIN9 a sITEm@P m4Y t4k3 5EvEr@L M1nU+E$ t0 c0mPl3t3. 1ph P3rFoRm@Nc3 oph y0UR 5erv3R 1S 4DvERsely @FPh3c+ed 1+ i$ r3C0mmenD J00 diS48L3 93ner4TioN 0f +He s1+3M@p.";
$lang['forum_settings_help_61'] = "<b>s3nD eMaiL Not1fiC4tioN tO Gl0b4l @dM1N</b> wH3n En4Bl3D wILL $3Nd 4n 3m4iL t0 t3h gL0B4L f0RUM oWn3rs Wh3n 4 new U$er acCOunt IS CrE4TeD.";

// Attachments (attachments.php, get_attachment.php) ---------------------------------------

$lang['aidnotspecified'] = "aID n0+ spEc1F13d.";
$lang['upload'] = "uPlOAD";
$lang['uploadnewattachment'] = "uplo4d N3W @+T4ChM3NT";
$lang['waitdotdot'] = "w4IT..";
$lang['successfullyuploaded'] = "suCCesSPhUlLY Upl0@D3d: %s";
$lang['failedtoupload'] = "f@1L3d +0 Upl04d: %s. CHeCK fre3 4++4ChM3nt sp@Ce!";
$lang['complete'] = "cOmpl3t3";
$lang['uploadattachment'] = "upLO@D 4 ph1Le FOr @T+@ChM3n+ to Teh MeSs493";
$lang['enterfilenamestoupload'] = "en+3r pH1L3n@mE(s) t0 uPlO@d";
$lang['attachmentsforthismessage'] = "a++4cHMEnTS Phor thIs Me$s@ge";
$lang['otherattachmentsincludingpm'] = "o+H3r 4++4CHMen+S (1nCLUDIN9 pm Mes$@93$ @ND otheR F0rum$)";
$lang['totalsize'] = "to+4l $IZe";
$lang['freespace'] = "fR3E spACE";
$lang['attachmentproblem'] = "thEr3 WA5 A PR08leM dOwnl0ad1n9 THIS 4++4cHMeN+. pLE4Se +RY 49@iN l4+eR.";
$lang['attachmentshavebeendisabled'] = "a++4Chm3n+$ H@vE bEeN d1S4BLeD By +EH FORUm 0WNEr.";
$lang['canonlyuploadmaximum'] = "j00 C@n onLY uplO@d 4 M@x1MUm 0F 10 phiL3$ 4T @ tIMe";
$lang['deleteattachments'] = "del3T3 4TT@cHM3N+s";
$lang['deleteattachmentsconfirm'] = "aRE J00 $Ure j00 W@n+ T0 D3LE+E tH3 $EL3CT3D 4+t@CHm3n+5?";
$lang['deletethumbnailsconfirm'] = "ar3 J00 sUr3 J00 W4nt +0 dELe+E +H3 SeL3c+3D @tt4chm3NTs tHum8na1ls?";

// Changing passwords (change_pw.php) ----------------------------------

$lang['passwdchanged'] = "pA$Sw0rD Ch4N9eD";
$lang['passedchangedexp'] = "yOUr P@sSW0rD h4S bE3N cH4N93D.";
$lang['updatefailed'] = "updA+E F4ILeD";
$lang['passwdsdonotmatch'] = "p@s$w0rD$ d0 NO+ maTch.";
$lang['newandoldpasswdarethesame'] = "neW 4ND 0Ld Pa$$wOrDs @RE +3h $4Me.";
$lang['requiredinformationnotfound'] = "reQU1r3D INFOrM4ti0N n0+ Ph0uNd";
$lang['forgotpasswd'] = "fOR9Ot P4$5worD";
$lang['resetpassword'] = "rE5eT p4s$W0RD";
$lang['resetpasswordto'] = "r3$ET Pa5$W0Rd t0";
$lang['invaliduseraccount'] = "inVAl1d U$Er 4cCOUn+ Sp3cif13d. cH3cK em41L Phor C0rreCT l1nk";
$lang['invaliduserkeyprovided'] = "inv@liD uS3R KEy pr0v1D3d. CHeCK em4Il for c0RR3c+ l1Nk";

// Deleting messages (delete.php) --------------------------------------

$lang['nomessagespecifiedfordel'] = "nO mes54g3 $pEC1F1ED For D3L3+IOn";
$lang['deletemessage'] = "deleTE ME$S@g3";
$lang['successfullydeletedpost'] = "suCce$SpHULLY DElETeD pos+ %s";
$lang['errordelpost'] = "eRRoR d3L3T1ng POSt";
$lang['cannotdeletepostsinthisfolder'] = "j00 c4nNO+ dEl3+3 P05+S 1N THi5 PH0lDer";

// Editing things (edit.php, edit_poll.php) -----------------------------------------

$lang['nomessagespecifiedforedit'] = "nO me$s493 SpEcIf13d ph0r ED1+in9";
$lang['cannoteditpollsinlightmode'] = "c4Nn0+ 3dit POLls 1N l1GHt m0de";
$lang['editedbyuser'] = "eDi+eD: %s by %s";
$lang['successfullyeditedpost'] = "sUcce$SPHuLlY 3DI+3D Po$+ %s";
$lang['errorupdatingpost'] = "erRoR UPD4+iNg p0$t";
$lang['editmessage'] = "eD1+ Me$S@gE %s";
$lang['editpollwarning'] = "<b>no+3</b>: 3Di+1N9 ceRt41n 4SP3ct$ oF @ P0lL wIll vOId 4ll th3 cuRReNT Vo+Es @Nd @Ll0w P3opLe To VOte @G41n.";
$lang['hardedit'] = "h4rd ED1T 0Pt1onS (V0T3S w1ll 83 R35ET):";
$lang['softedit'] = "s0F+ ed1T Op+1ON$ (VOt3s W1lL 8e rE+AinEd):";
$lang['changewhenpollcloses'] = "chaN93 Wh3N +3H P0LL ClOsES?";
$lang['nochange'] = "nO CH4Ng3";
$lang['emailresult'] = "eM41L r3SUL+";
$lang['msgsent'] = "mE$$@g3 $En+";
$lang['msgsentsuccessfully'] = "m3$S@9E 53n+ 5UcCEs$FuLLy.";
$lang['mailsystemfailure'] = "m4iL 5Y$+Em f4iluR3. mE5S493 NOt 53NT.";
$lang['nopermissiontoedit'] = "j00 4R3 NO+ PeRmI+T3d +0 3DI+ tH15 m3$$4G3.";
$lang['cannoteditpostsinthisfolder'] = "j00 c4nn0T eDiT pO$tS 1N Thi5 PhOLD3R";
$lang['messagewasnotfound'] = "mes54g3 %s w4S n0+ PhoUNd";

// Email (email.php) ---------------------------------------------------

$lang['sendemailtouser'] = "sEnd 3M41L TO %s";
$lang['nouserspecifiedforemail'] = "no u$eR SPeciPhieD foR em4iliN9.";
$lang['entersubjectformessage'] = "en+3R 4 SUBjEC+ F0r +he m3$$493";
$lang['entercontentformessage'] = "en+Er $0Me c0Nt3Nt f0R +h3 mESs49E";
$lang['msgsentfromby'] = "tHiS M35$4g3 w@$ $eN+ phr0M %s 8Y %s";
$lang['subject'] = "sU8jecT";
$lang['send'] = "s3nd";
$lang['userhasoptedoutofemail'] = "%s H@$ 0PTeD oUT 0pH 3m@il ConTAC+";
$lang['userhasinvalidemailaddress'] = "%s H@s @N Inv@lId 3m41l @dDre5$";

// Message nofificaiton ------------------------------------------------

$lang['msgnotification_subject'] = "m3sS4GE nOTIf1C4+I0n fR0m %s";
$lang['msgnotificationemail'] = "h3Llo %s,\n\n%s p0s+eD a MES54GE t0 j00 0n %s.\n\nTh3 $U8JeCt 1S: %s.\n\nTO rE4d tha+ M3$$49E AND 0Ther$ iN +H3 $4me Di$cuS5iON, 9o +o:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nnoTe: 1F j00 DO n0t w1sH T0 REcEiV3 em@1L n0+IpHic@tiOn5 OPh F0rUM m35$AGE$ POsT3D t0 yOu, g0 +o: %s CL1cK 0N mY C0ntroLS Then Em@iL 4ND pRIv@cy, UNSElec+ tH3 em@1L NoTIPH1cAti0n CH3ck8OX ANd pRE5s $ubmI+.";

// Thread Subscription notification ------------------------------------

$lang['threadsubnotification_subject'] = "su8ScrIPt10n Not1PH1C@ti0n Fr0m %s";
$lang['threadsubnotification'] = "helL0 %s,\n\n%s P0$+3d 4 me$S@G3 IN @ +hrE4D j00 4re Su8sCr183d T0 oN %s.\n\nTHE 5U8JECT 1$: %s.\n\n+0 R34d +h@+ m35$@9e 4nd 0+heRs 1N +h3 5@me dI$CuSS10N, g0 to:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nNO+E: 1ph J00 do nO+ W1$H +o r3C31v3 3m4il N0+1Phic@+10n5 0ph new mE5SAgES in +H1$ thRE4D, gO TO: %s 4nD @dju$+ yOUr 1Nt3R3ST lev3l 4+ TH3 Bo++Om 0f +3h P493.";

// Folder Subscription notification ------------------------------------

$lang['foldersubnotification_subject'] = "sU8SCRiPT10n n0+IFIC4+1ON phr0m %s";
$lang['foldersubnotification'] = "hEll0 %s,\n\n%s po$teD 4 m3sS@g3 1N @ PhOLD3R j00 4r3 SU8SCRI83d to 0n %s.\n\nthE $uBJECT I$: %s.\n\ntO re4D TH4+ m3s549e 4nd o+h3R$ In +eh 54m3 Di$Cu$Si0N, G0 +O:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nn0tE: iPH j00 D0 no+ wi$H +O R3cEIV3 3MA1L No+1Ph1c@ti0ns OF N3w M35S@9Es In thI$ thRe4d, 90 tO: %s 4ND adju5T Y0uR iNT3re5+ lEVEl 8Y CL1CK1ng On +3h PHoLdeR'S icoN 4T thE +OP 0pH P@g3.";

// PM notification -----------------------------------------------------

$lang['pmnotification_subject'] = "pM nOt1pHIca+I0n PHR0m %s";
$lang['pmnotification'] = "h3ll0 %s,\n\n%s PostEd @ Pm tO J00 0N %s.\n\nthE SUbj3c+ i5: %s.\n\n+o Re4d tH3 M3SS49E Go t0:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nn0t3: if j00 dO N0t WI5H +O R3C3iV3 3M4iL NO+IPhIc@t10NS 0ph neW Pm M3S54ge$ P0S+eD TO y0u, gO +0: %s clIck mY coN+ROL$ TH3N 3M41l @Nd priv4cY, UNseLeCt +h3 PM n0+1pH1ca+i0N cHeck80X 4Nd pr35S 5UBm1T.";

// Password change notification ----------------------------------------

$lang['passwdchangenotification'] = "p@$SWORD Ch@ng3 n0+iF1C4+10n froM %s";
$lang['pwchangeemail'] = "hEll0 %s,\n\n+HIs 4 No+1f1c4+1ON Ema1l t0 inf0RM J00 +H4+ y0UR P45sW0Rd On %s Ha$ 83eN Ch4nG3d.\n\niT H45 833N Ch@n9Ed +O: %s 4ND W4s chanG3d 8Y: %s.\n\niPH j00 H4v3 rEC3Iv3D THI5 em41l 1N ERrOr 0R w3re n0+ exp3c+1n9 4 Ch4N9e +O Y0uR P4$$WOrd pl3@$e c0nT@ct T3h Ph0RuM oWnEr 0r 4 moDer4+or On %s 1mMEd14+3Ly TO cOrrEc+ 1+.";

// Email confirmation notification -------------------------------------

$lang['emailconfirmationrequiredsubject'] = "ema1l c0NPh1RM4TION R3QuIRed foR %s";
$lang['confirmemail'] = "h3llo %s,\n\ny0U r3CEN+Ly Cre4+eD 4 NEw U5eR 4cCOUn+ On %s.\n\nBEpH0R3 j00 C@N St@Rt pO$+1nG we Ne3D +O c0nPH1RM Y0uR Em4il 4Ddr3sS. D0N'+ w0rRy +hiS i$ quI+3 E@$Y. 4lL J00 nE3d +0 DO I5 cL1cK tEh lInk 83L0w (Or C0Py 4nd p45t3 i+ iN+O yoUr 8ROW$eR):\n\n%s\n\nOnCe c0nPh1RM@+1On is C0mpl3+e J00 M4y L0gin @Nd St4rt P0$tin9 1MMEDi@t3LY.\n\n1pH j00 D1d NOt Cr34t3 4 U$eR 4cc0UN+ 0n %s pl34s3 4CCEPT 0UR AP0LOG1E$ 4nD F0RW4Rd THI5 Em41L +0 %s S0 TH4+ TH3 5OurCe 0f iT may 8E invE5+1G4T3D.";
$lang['confirmchangedemail'] = "hEllO %s,\n\nyOu r3CEnTLY CH4NgEd Y0uR em41l ON %s.\n\nBEPhORe j00 C4N st@R+ POs+in9 4941N We ne3d +0 C0Nfirm Y0ur N3W Em4IL 4ddr3$$. dOn'T w0rrY tHI5 1s qui+3 E@$y. 4ll J00 Ne3d +O Do 15 cL1cK +He L1NK BElOw (0R c0PY @nd P@St3 i+ 1N+0 yoUR brow$eR):\n\n%s\n\nonc3 c0Nf1rM@tI0N 15 C0MpletE j00 M4Y contInuE TO uSE T3H PH0ruM 45 norm@l.\n\n1PH J00 wEre n0T 3xp3c+InG +hI$ 3M4il pHrom %s pl34SE 4Cc3P+ OUR aPOL0GI35 4nD Ph0Rw@rD +HI5 Em41l TO %s s0 TH@+ +He sOURcE OPh 1t m@Y bE 1nV3$TIG4T3D.";

// Forgotten password notification -------------------------------------

$lang['forgotpwemail'] = "hEllO %s,\n\nyou r3QU3S+ED +H1$ 3-m41L fROM %s 83c@U$e j00 H@ve f0rgOt+EN Y0uR p4sSw0Rd.\n\nCLICk +eh link bEL0w (oR c0Py 4Nd p4s+e I+ 1nto y0uR bR0wS3r) +0 rE$3+ YoUr P4ssword:\n\n%s";

// Admin New User Approval notification -----------------------------------------

$lang['newuserapprovalsubject'] = "nEw uS3r 4PPR0v4L n0tiph1C@+1ON for %s";
$lang['newuserapprovalemail'] = "Hello %s,\n\nA new user account has been created on %s.\n\nAs you are an Administrator of this forum you are required to approve this user account before it can be used by it's owner.\n\nTo approve this account please visit the Admin Users section and change the filter type to \"Users Awaiting Approval\"or CLIck ThE link B3lOw:\n\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nnot3: 0th3R 4dM1n1$tr4t0r5 ON +H1S PhorUm W1Ll @L$o r3c3IVe tHiS N0+1phicatiON 4ND mAy h4V3 4LR34DY 4C+3D UP0N tHIs reQu3St.";

// Admin New User notification -----------------------------------------

$lang['newuserregistrationsubject'] = "n3w uSEr 4cCoUNT N0t1fiC4tiOn Ph0R %s";
$lang['newuserregistrationemail'] = "h3lL0 %s,\n\n4 n3w U$3r 4cc0UNT H4$ 8e3n cR34t3D 0n %s.\n\nto vi3w ThiS u5ER 4CcOUN+ PL34$E V1S1T +He 4dm1n uS3R$ $ec+i0N 4Nd CL1Ck 0N +eH New US3R 0R cLicK +he l1nk BeLoW:\n\n%s";

// User Approved notification ------------------------------------------

$lang['useraccountapprovedsubject'] = "us3r @Pprov4L N0+1phIC4+IoN F0r %s";
$lang['useraccountapprovedemail'] = "helL0 %s,\n\nYOUr uS3R 4CCOUNT 4+ %s H4S 833n @pProveD. J00 C4n l091N 4nd $t4RT po5+ing 1Mm3di4+3Ly by Cl1Ck1NG TH3 LInk 8ELoW:\n\n%s\n\n1f J00 W3Re N0+ exp3CtiN9 +H1$ EM@iL FRom %s PL3453 4cC3pt oUr 4P0L0GIE$ 4ND pH0Rw@rD +H15 eM@iL TO %s 50 th@T +Eh $0uRCE 0F iT mAy 83 iNveS+1G@+ed.";

// Admin Post Approval notification -----------------------------------------

$lang['newpostapprovalsubject'] = "p05t 4pprOv4l n0t1FiC@+1on phOr %s";
$lang['newpostapprovalemail'] = "helLO %s,\n\n4 N3W p05+ h4$ bEEN cr34t3d 0N %s.\n\n45 J00 4R3 4 MoDer4+OR 0N +h1$ PHoRUm J00 4rE r3qU1r3D T0 4ppROV3 +his PoSt 8efoR3 IT C@N 83 R34d bY OTh3R u53rS.\n\nYOu C4n 4ppr0v3 +H1s po5+ 4Nd 4Ny o+H3r$ penD1nG @PPr0V@l 8Y vis1+INg TH3 @Dm1n Po$+ 4PPRov4L 5ecTi0N 0pH your FoRUm OR 8Y cl1cKin9 +eh LinK Bel0W:\n\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nnOTE: O+Her @dM1nIS+R4+0r5 on +H1$ pH0Rum W1LL @l5o r3Ce1V3 tH1S NO+IPhic4TIOn @ND m@Y H@vE 4Lr3@Dy 4cT3D up0n +h15 ReqU3$+.";

// Forgotten password form.

$lang['passwdresetrequest'] = "yOUR P@sSw0rd ReS3T r3Qu3s+ phrom %s";
$lang['passwdresetemailsent'] = "p@sSwOrD r3s3t 3-m@1l 5EnT";
$lang['passwdresetexp'] = "j00 $HoUld sh0Rtly R3cE1VE @N E-M@iL ConT@in1N9 1NS+rUc+i0ns pHoR res3+TIng y0UR p4$5WORD.";
$lang['validusernamerequired'] = "a v4l1D US3rN4me I$ r3QUIr3D";
$lang['forgottenpasswd'] = "fOrGot P4sSW0rD";
$lang['couldnotsendpasswordreminder'] = "c0UlD N0T 5End P4s5woRd r3M1ND3R. Pl34$e Cont@c+ T3h Phorum oWnER.";
$lang['request'] = "reQU3$+";

// Email confirmation (confirm_email.php) ------------------------------

$lang['emailconfirmation'] = "eM@1l c0NfIrM@+I0n";
$lang['emailconfirmationcomplete'] = "th4nK j00 pH0r COnPh1rmIn9 Y0uR eMa1L aDDr3SS. j00 m4y NoW log1n 4nd s+@r+ P0sTiN9 1mm3Di@+eLY.";
$lang['emailconfirmationfailed'] = "eMAIl c0NPh1rmA+1ON h@s ph41L3d, ple@S3 trY 4941N l4+Er. 1f j00 EnC0Un+eR tHiS ErR0r mUL+IPL3 +ime$ pL34Se c0Nt@cT +Eh Ph0RuM owNeR 0r 4 mOdEr4ToR Ph0r 4SS1S+@Nce.";

// Links database (links*.php) -----------------------------------------

$lang['toplevel'] = "tOp lEVeL";
$lang['maynotaccessthissection'] = "j00 m4y NO+ 4cc35$ +H1S sec+10n.";
$lang['toplevel'] = "tOp l3V3l";
$lang['links'] = "lINk5";
$lang['externallink'] = "ex+eRN4l LInk";
$lang['viewmode'] = "v1eW M0DE";
$lang['hierarchical'] = "hi3r4RCH1C@L";
$lang['list'] = "lIST";
$lang['folderhidden'] = "tHI$ folDEr 1S H1Dd3n";
$lang['hide'] = "hiDe";
$lang['unhide'] = "unH1dE";
$lang['nosubfolders'] = "nO su8pholD3r$ IN +HI5 c4+e9orY";
$lang['1subfolder'] = "1 SubPH0lDEr 1n This ca+390RY";
$lang['subfoldersinthiscategory'] = "suBpHOLDEr$ iN +hI5 c4t3G0RY";
$lang['linksdelexp'] = "enTrIe$ IN @ DeLetED PHOlD3r wilL 8e M0v3d t0 +he p@rEN+ FoldER. 0nly Ph0ld3rs Wh1cH do NO+ coN+@IN SubPHoldeR5 m4y bE d3L3t3D.";
$lang['listview'] = "lis+ v1EW";
$lang['listviewcannotaddfolders'] = "c4nNOt @dd pHOlD3r5 1N TH1$ V1eW. SH0W1n9 20 3nTR1Es 4+ @ +im3.";
$lang['rating'] = "r4+iNg";
$lang['nolinksinfolder'] = "n0 LINK$ IN THis F0LD3r.";
$lang['addlinkhere'] = "add l1NK hErE";
$lang['notvalidURI'] = "tH4T 1$ nOt 4 V@liD uR1!";
$lang['mustspecifyname'] = "j00 mu$+ 5peCIfY 4 nAm3!";
$lang['mustspecifyvalidfolder'] = "j00 mU5+ spECIfY @ v4L1D f0LDeR!";
$lang['mustspecifyfolder'] = "j00 mu5t sPecIphy A foLdER!";
$lang['successfullyaddedlinkname'] = "suCc3S$PhUlLY 4dD3d Link '%s'";
$lang['failedtoaddlink'] = "f4IlEd +0 @Dd l1nk";
$lang['failedtoaddfolder'] = "f4ILED +o @Dd FolD3r";
$lang['addlink'] = "adD 4 LINk";
$lang['addinglinkin'] = "adD1ng L1Nk 1N";
$lang['addressurluri'] = "addRe$5";
$lang['addnewfolder'] = "aDD @ n3W PhOLd3R";
$lang['addnewfolderunder'] = "aDdIn9 nEw Ph0LD3r uNDEr";
$lang['editfolder'] = "edi+ fOlD3r";
$lang['editingfolder'] = "eDiT1N9 FoLDeR";
$lang['mustchooserating'] = "j00 mUs+ Ch005e a R4TIn9!";
$lang['commentadded'] = "yOur comM3nt wa5 4dDed.";
$lang['commentdeleted'] = "coMM3nt W45 d3lE+ed.";
$lang['commentcouldnotbedeleted'] = "c0MMEN+ C0uld nOT 8E d3LEtEd.";
$lang['musttypecomment'] = "j00 must typE @ c0MMEn+!";
$lang['mustprovidelinkID'] = "j00 MuSt Pr0vIDe 4 L1Nk Id!";
$lang['invalidlinkID'] = "inv@lID l1NK ID!";
$lang['address'] = "addR3$s";
$lang['submittedby'] = "sU8m1++ed 8Y";
$lang['clicks'] = "cL1CkS";
$lang['rating'] = "r4t1N9";
$lang['vote'] = "v0t3";
$lang['votes'] = "v0T3S";
$lang['notratedyet'] = "nOT r4tEd 8Y ANyOn3 YET";
$lang['rate'] = "r@T3";
$lang['bad'] = "b4D";
$lang['good'] = "gOoD";
$lang['voteexcmark'] = "v0Te!";
$lang['clearvote'] = "cle@R VO+3";
$lang['commentby'] = "cOmmEnT by %s";
$lang['addacommentabout'] = "aDd A COmMeN+ 480UT";
$lang['modtools'] = "moD3R@Ti0n +00L5";
$lang['editname'] = "ediT n@mE";
$lang['editaddress'] = "eDi+ 4DDR35s";
$lang['editdescription'] = "edI+ d3$CRIPTI0n";
$lang['moveto'] = "mOv3 TO";
$lang['linkdetails'] = "liNk DET@1L5";
$lang['addcomment'] = "aDD cOmM3N+";
$lang['voterecorded'] = "yOuR vOtE H4$ B33n R3C0rDed";
$lang['votecleared'] = "youR v0te h@S B33n cL3aR3d";
$lang['linknametoolong'] = "l1Nk n4mE t0o LONG. m4x1muM Is %s ch4r4C+3r5";
$lang['linkurltoolong'] = "l1Nk uRL +oO LonG. M4X1MUM Is %s CH@RAC+3rS";
$lang['linkfoldernametoolong'] = "f0ld3R n4m3 +00 LON9. M4x1mUm L3N9+H 15 %s Ch4R4c+3r$";

// Login / logout (llogon.php, logon.php, logout.php) -----------------------------------------

$lang['loggedinsuccessfully'] = "j00 LOG93D in $uCC3s$fUlLY.";
$lang['presscontinuetoresend'] = "prE$s cont1nu3 +O re$eNd F0rM d@+4 0R C@NC3l t0 r3loAd p4G3.";
$lang['usernameorpasswdnotvalid'] = "tEh u53rn4m3 or P4sswORd j00 $uPpliEd is noT v4l1d.";
$lang['rememberpasswds'] = "r3mEM83r p4ssw0rD5";
$lang['rememberpassword'] = "rEmEm83r P4$5Word";
$lang['enterasa'] = "eN+ER as @ %s";
$lang['donthaveanaccount'] = "doN'+ h4v3 4N 4cC0uN+? %s";
$lang['registernow'] = "r39i5+eR nOw";
$lang['problemsloggingon'] = "prO8lEmS LO9g1n9 0n?";
$lang['deletecookies'] = "d3L3te CO0kiEs";
$lang['cookiessuccessfullydeleted'] = "cO0kI3$ succes$FuLlY DeLE+3d";
$lang['forgottenpasswd'] = "forgO++En Y0uR p45$woRd?";
$lang['usingaPDA'] = "usIn9 a pd4?";
$lang['lightHTMLversion'] = "l1gh+ hTMl V3R5ion";
$lang['youhaveloggedout'] = "j00 h4vE Lo99ED 0ut.";
$lang['currentlyloggedinas'] = "j00 4r3 curR3Ntly l09g3d iN 45 %s";
$lang['logonbutton'] = "lO90N";
$lang['otherdotdotdot'] = "oth3R...";
$lang['yoursessionhasexpired'] = "y0Ur $Es$10N hAS 3XpIReD. J00 WILl ne3d To log1N 4G41N +0 C0nT1NUE.";

// My Forums (forums.php) ---------------------------------------------------------

$lang['myforums'] = "my forUMs";
$lang['allavailableforums'] = "aLl 4V4Il4bl3 foRumS";
$lang['favouriteforums'] = "f4vOurite ForUm5";
$lang['ignoredforums'] = "i9nOr3D PH0Rum$";
$lang['ignoreforum'] = "ign0r3 forUm";
$lang['unignoreforum'] = "uNi9NOre phOrum";
$lang['lastvisited'] = "l4st Vi51+Ed";
$lang['forumunreadmessages'] = "%s UNRE4D M3sS@9E5";
$lang['forummessages'] = "%s M3s$4ge$";
$lang['forumunreadtome'] = "%s unReaD &quot;+o: ME&quot;";
$lang['forumnounreadmessages'] = "n0 UNR34d m3Ss4ges";
$lang['removefromfavourites'] = "reMOVE Fr0M F4V0urIT3s";
$lang['addtofavourites'] = "aDd TO f4vOur1te5";
$lang['availableforums'] = "av4Il48Le PhoRuM$";
$lang['noforumsofselectedtype'] = "th3R3 are n0 pH0rum5 0F +3h seLECt3d TyPE @v@il4bLe. pL3453 S3L3Ct 4 DiphPH3rent +yp3.";
$lang['successfullyaddedforumtofavourites'] = "sUcce$$PhulLy @Dd3d ph0rum to Ph4VouR1+Es.";
$lang['successfullyremovedforumfromfavourites'] = "succe55phully R3m0ved phorUm pHR0M f@V0Ur1+ES.";
$lang['successfullyignoredforum'] = "sucCEsSfuLlY i9nor3d F0rum.";
$lang['successfullyunignoredforum'] = "succ3s$PhUlly UNi9NOr3D f0rum.";
$lang['failedtoupdateforuminterestlevel'] = "f4IL3d +o uPDAt3 F0ruM in+ere$+ lev3l";
$lang['noforumsavailablelogin'] = "th3R3 @re n0 fOruMs @v@il@8LE. ple4s3 L09In +0 Vi3W y0uR PhorumS.";
$lang['passwdprotectedforum'] = "p4SswoRD pr0t3c+3D f0RUm";
$lang['passwdprotectedwarning'] = "thi$ f0rum is P4$SWorD proT3C+3D. T0 g@IN 4cce$5 3nter +h3 P@S5WoRd 8ElOW.";

// Message composition (post.php, lpost.php) --------------------------------------

$lang['postmessage'] = "p0$+ m3S$@93";
$lang['selectfolder'] = "s3lEc+ f0Ld3R";
$lang['mustenterpostcontent'] = "j00 MUS+ 3n+3r 50Me c0n+Ent For TEh p05T!";
$lang['messagepreview'] = "m3s5a9E pRev13w";
$lang['invalidusername'] = "inV4L1d u$eRN4M3!";
$lang['mustenterthreadtitle'] = "j00 Mu5+ eNter @ +i+l3 foR t3h THR34d!";
$lang['pleaseselectfolder'] = "pl34sE sEleCt 4 foLD3r!";
$lang['errorcreatingpost'] = "erR0R CR34t1Ng post! plE4sE try @941N In a fEW m1nu+3$.";
$lang['createnewthread'] = "cr3ate n3W +hr34d";
$lang['postreply'] = "pO$t r3ply";
$lang['threadtitle'] = "thR34d t1+l3";
$lang['foldertitle'] = "fOLD3R t1+L3";
$lang['messagehasbeendeleted'] = "mE5S4gE not PH0UND. Check +h4T 1T h4$n't BE3n d3LEted.";
$lang['messagenotfoundinselectedfolder'] = "meS$4G3 Not ph0Und 1N 53LeCTEd foLd3r. ch3ck tHat it H45n't bE3N m0V3d 0r deL3+ED.";
$lang['cannotpostthisthreadtypeinfolder'] = "j00 C4nNO+ p0s+ th1$ Thr34D +yPe 1N +h4+ f0lD3r!";
$lang['cannotpostthisthreadtype'] = "j00 C4NN0T Po$+ +h1S thr3ad typE 4S tH3R3 are N0 4v@iL4BLE f0lders tH4t 4llow 1T.";
$lang['cannotcreatenewthreads'] = "j00 c4nnot CRe4T3 n3w tHr34d$.";
$lang['threadisclosedforposting'] = "th1s tHr34D I$ cLosEd, j00 c4nn0T post 1n i+!";
$lang['moderatorthreadclosed'] = "w4Rn1N9: +H1$ +hR34D 1s cLo53d f0r pOS+1NG to n0rm4L us3r5.";
$lang['usersinthread'] = "uS3RS 1N +hrE@D";
$lang['correctedcode'] = "c0RReC+ED c0d3";
$lang['submittedcode'] = "su8MI+tEd C0D3";
$lang['htmlinmessage'] = "h+ml in mes5493";
$lang['disableemoticonsinmessage'] = "dI54bLE 3m0TiCoNs 1N me5S4g3";
$lang['automaticallyparseurls'] = "au+0M4+iC@LlY P@r$3 URL$";
$lang['automaticallycheckspelling'] = "aU+0m4tic4LLY cheCK sPELL1nG";
$lang['setthreadtohighinterest'] = "se+ +hr3@D +0 hI9h 1n+3resT";
$lang['enabledwithautolinebreaks'] = "eNaBl3d wi+H 4Uto-lIN3-bRe@K$";
$lang['fixhtmlexplanation'] = "tH1S pH0ruM U535 HtMl pHiL+Er1N9. YoUr 5UbMIt+3D HTml h@s 8eeN M0DIPhIED 8Y +EH ph1ltER5 in 5oM3 w4Y.\\n\\n+O vIEw y0Ur 0ri91naL CoD3, 53l3c+ Th3 \\'5Ubmi++3D CoD3\\' r@d10 ButT0n.\\nT0 v1ew +he m0DiFIed C0d3, Sel3c+ +3h \\'COrreC+3d cOdE\\' R4DI0 bu+t0N.";
$lang['messageoptions'] = "mE$S@ge 0P+10ns";
$lang['notallowedembedattachmentpost'] = "j00 4re noT 4lLOW3D +0 3mBeD @t+4chm3n+s iN y0ur p0$TS.";
$lang['notallowedembedattachmentsignature'] = "j00 arE n0t @ll0w3d +0 EmB3d 4++@chMEn+S in Y0ur 5i9n4turE.";
$lang['reducemessagelength'] = "m35s4G3 LENGTh mu5+ b3 uNDeR 65,535 Ch4RACT3RS (CUrR3nTlY: %s)";
$lang['reducesiglength'] = "sI9n@+urE lENg+H Mu5+ 8E uND3r 65,535 Ch4r@c+3R$ (currEntLY: %s)";
$lang['cannotcreatethreadinfolder'] = "j00 C4nNO+ CRE4t3 NEW +HRe4ds in +H1$ pH0LdeR";
$lang['cannotcreatepostinfolder'] = "j00 c4nN0+ r3pLy +0 Po$t$ IN ThI$ pH0Ld3r";
$lang['cannotattachfilesinfolder'] = "j00 CaNNoT Po$+ 4tt4ChMEN+5 1n +HI$ fOld3r. R3moV3 4Tt4cHMENt$ +0 C0n+1nu3.";
$lang['postfrequencytoogreat'] = "j00 C4n oNlY P0$T 0NcE 3v3ry %s S3cOND5. pl34$3 +Ry @9aiN La+Er.";
$lang['emailconfirmationrequiredbeforepost'] = "eM@iL C0Nph1RMAt10N 1S rEQuIR3D B3PhORe j00 C4n p0s+. iPh J00 h4ve Not rEC3iv3d 4 c0nF1RM@+Ion em4Il pL3@Se cl1Ck Th3 8u++oN BELow @nd 4 nEW 0n3 W1lL BE S3N+ +0 y0U. 1ph YOUr 3M41L @ddr3s5 n3eDs CH4NG1n9 pLe@$E d0 5o bef0r3 R3qu35t1n9 4 n3W C0npHIRma+ion 3M4Il. J00 m@y ch@NG3 Y0UR 3m4iL @DDrE5s 8y clIcK My COn+roLS aBOv3 AnD +h3N uSeR D3+41lS";
$lang['emailconfirmationfailedtosend'] = "cOnPH1rM4tIOn 3m@il phailEd +0 $3nD. pl3ASE C0nT@ct tHe f0RUM 0WnEr T0 r3ct1fy TH1$.";
$lang['emailconfirmationsent'] = "cONf1RMA+iOn 3M4Il h@S 83en rES3NT.";
$lang['resendconfirmation'] = "rES3Nd c0NpHirMAT10n";
$lang['userapprovalrequiredbeforeaccess'] = "y0ur us3R @CCOUnt N3eDS T0 B3 4ppRoveD 8Y 4 phorUM @dm1n 8ephor3 j00 c4N @CCEss +Eh r3qUEsTeD F0rum.";
$lang['reviewthread'] = "rEvi3w +HrE4D";
$lang['reviewthreadinnewwindow'] = "rEVI3w ent1R3 Thre4d 1N n3W wInD0w";

// Message display (messages.php & messages.inc.php) --------------------------------------

$lang['inreplyto'] = "in R3ply +0";
$lang['showmessages'] = "sH0w MEs549es";
$lang['ratemyinterest'] = "r@te my 1n+ERes+";
$lang['adjtextsize'] = "aDJu$+ +EX+ siz3";
$lang['smaller'] = "sM@Ll3R";
$lang['larger'] = "l@R9er";
$lang['faq'] = "f4Q";
$lang['docs'] = "doc$";
$lang['support'] = "sUpp0r+";
$lang['donateexcmark'] = "don4t3!";
$lang['fontsizechanged'] = "font $1Z3 ch4n9ed. %s";
$lang['framesmustbereloaded'] = "fR4MEs mU5T Be r3l04ded M@nu@Lly t0 5EE Ch@n9ES.";
$lang['threadcouldnotbefound'] = "th3 ReQU3sTEd Thr34d COUlD N0t be founD 0r 4cC3S$ waS deniEd.";
$lang['mustselectpolloption'] = "j00 mu5+ $Elec+ aN 0ptIoN +0 V0+3 PHOR!";
$lang['mustvoteforallgroups'] = "j00 mU5t v0t3 in 3vEry groUP.";
$lang['keepreading'] = "k33p R3@d1Ng";
$lang['backtothreadlist'] = "bacK T0 +hr3@d l1st";
$lang['postdoesnotexist'] = "tH@t pO$T dOe$ No+ ExI$t in +His thR3@D!";
$lang['clicktochangevote'] = "cl1CK +o ch@N9e Vot3";
$lang['youvotedforoption'] = "j00 vo+eD f0r op+10n";
$lang['youvotedforoptions'] = "j00 vo+eD f0r op+IOn$";
$lang['clicktovote'] = "cLiCK t0 v0T3";
$lang['youhavenotvoted'] = "j00 h4VE n0+ V0t3D";
$lang['viewresults'] = "v1Ew RE5UL+5";
$lang['msgtruncated'] = "m3S$@93 +ruNC4+3d";
$lang['viewfullmsg'] = "vi3W PhUll m35549e";
$lang['ignoredmsg'] = "i9n0reD MESS493";
$lang['wormeduser'] = "w0rM3d us3R";
$lang['ignoredsig'] = "i9N0reD sI9N@TUr3";
$lang['messagewasdeleted'] = "mess493 %s.%s W45 Del3T3D";
$lang['stopignoringthisuser'] = "s+0p 19nOr1n9 tH1$ us3r";
$lang['renamethread'] = "rEn4M3 +HRE4d";
$lang['movethread'] = "m0V3 +Hr3aD";
$lang['torenamethisthreadyoumusteditthepoll'] = "to r3n4m3 +h15 +hrE4D j00 mu$t 3d1T +Eh p0ll.";
$lang['closeforposting'] = "cLo5e phor p0$+1N9";
$lang['until'] = "un+iL 00:00 u+C";
$lang['approvalrequired'] = "aPpr0V4l reQu1red";
$lang['messageawaitingapprovalbymoderator'] = "mESS493 %s.%s 1s 4wA1+iNg @ppRoV4L 8y 4 MODeR4Tor";
$lang['successfullyapprovedpost'] = "sUcce$$fulLY @PproV3d pos+ %s";
$lang['postapprovalfailed'] = "p0St @pPRoV@l f41l3D.";
$lang['postdoesnotrequireapproval'] = "pO5t d03$ nOt r3qUIrE 4pPrOv@L";
$lang['approvepost'] = "aPPR0VE po5+";
$lang['approvedbyuser'] = "apPR0vED: %s By %s";
$lang['makesticky'] = "m4ke 5t1ckY";
$lang['messagecountdisplay'] = "%s oPh %s";
$lang['linktothread'] = "pERM4N3n+ l1nk T0 This thR34d";
$lang['linktopost'] = "liNK to poS+";
$lang['linktothispost'] = "linK +0 +h1$ p0S+";
$lang['imageresized'] = "th1s 1m493 H4$ 833N rES1z3D (ORIgIn@l 5iZE %1\$Sx%2\$$). t0 V13W T3h PhUlL-$Iz3 1M4Ge Cl1cK H3r3.";
$lang['messagedeletedbyuser'] = "m3sS@G3 %s.%s DELeTEd %s By %s";
$lang['messagedeleted'] = "mes$@9e %s.%s W4s d3l3+eD";
$lang['viewinframeset'] = "v13w in phr@M3set";
$lang['pressctrlentertoquicklysubmityourpost'] = "pr3$$ c+rL+3N+er +o qUIcKlY 5uBMIt youR p0S+";

// Moderators list (mods_list.php) -------------------------------------

$lang['cantdisplaymods'] = "c4Nn0+ Di5pL4y f0lD3R M0dEr4+0r$";
$lang['moderatorlist'] = "m0DERa+0r Lis+:";
$lang['modsforfolder'] = "modER@+0r$ for PH0ld3r";
$lang['nomodsfound'] = "n0 M0d3R4tOR$ ph0UND";
$lang['forumleaders'] = "f0RUm L34D3rS:";
$lang['foldermods'] = "fOldEr moDEr@+0r$:";

// Navigation strip (nav.php) ------------------------------------------

$lang['start'] = "s+@rT";
$lang['messages'] = "mE$5@9e$";
$lang['pminbox'] = "in80x";
$lang['startwiththreadlist'] = "s+@rt p493 wi+h +HrE4d l1$T";
$lang['pmsentitems'] = "s3nt i+3ms";
$lang['pmoutbox'] = "oUT80X";
$lang['pmsaveditems'] = "sAv3D 1+EM5";
$lang['pmdrafts'] = "dr4phts";
$lang['links'] = "lINKs";
$lang['admin'] = "aDm1N";
$lang['login'] = "l0g1n";
$lang['logout'] = "l0gOUT";

// PM System (pm.php, pm_write.php, pm.inc.php) ------------------------

$lang['privatemessages'] = "pR1v4t3 mE554gEs";
$lang['recipienttiptext'] = "sep@R@t3 r3cip1en+$ By 53m1-c0Lon 0r comm4";
$lang['maximumtenrecipientspermessage'] = "tH3re 1s 4 Lim1+ oF 10 r3CIp1en+$ pEr m3S5AG3. Pl345E 4mend yoUr reCiPi3n+ Li5+.";
$lang['mustspecifyrecipient'] = "j00 MU5+ SpEc1fy 4t LE4st 0NE rEC1PIEnT.";
$lang['usernotfound'] = "u5er %s NO+ PH0UND";
$lang['sendnewpm'] = "seNd NEW pm";
$lang['savemessage'] = "s@V3 m3$S@G3";
$lang['nosubject'] = "n0 subJec+";
$lang['norecipients'] = "n0 r3CIPI3n+S";
$lang['timesent'] = "tim3 $3nt";
$lang['notsent'] = "n0+ $eN+";
$lang['errorcreatingpm'] = "eRr0r Cre4+1NG pM! plE4$3 trY 4g@1n 1n 4 ph3W m1nUTE5";
$lang['writepm'] = "wRITE m355@Ge";
$lang['editpm'] = "ed1+ Me$$A93";
$lang['cannoteditpm'] = "c@Nno+ 3d1t +h1s pm. it H4$ @lr34dY 833N vi3wed By +h3 r3C1p1en+ Or tEh mES$4ge doeS n0+ 3x1s+ 0r i+ IS 1N4CceSsibL3 bY J00";
$lang['cannotviewpm'] = "c@Nn0+ v13w Pm. m35S@93 d0es n0t eXIs+ 0R 1t i5 1n4ccE5si8l3 By J00";
$lang['pmmessagenumber'] = "m3$$49E %s";

$lang['youhavexnewpm'] = "j00 h4V3 %d n3W m355a9eS. w0ulD J00 l1k3 +O G0 t0 YoUr 1nbOx n0W?";
$lang['youhave1newpm'] = "j00 h@v3 1 NEW m3s5493. WOUld J00 l1K3 +o 9o +0 yoUr iNBOX N0W?";
$lang['youhave1newpmand1waiting'] = "j00 h@vE 1 n3W mE$549e.\n\nyou aL$0 hav3 1 mE$$4ge @w@i+IN9 D3l1VerY. +0 Rec3iVE th1$ M3S549e Pl34s3 Cle4r 50mE $P4c3 in y0Ur 1n8OX.\n\nw0uld J00 Lik3 +O 9o +0 Y0uR inB0x now?";
$lang['youhave1pmwaiting'] = "j00 H4v3 1 MEss493 @w41+In9 dEliv3ry. t0 ReC31v3 +H15 mES$@G3 PLE4s3 cl34r $oMe sPACe 1N y0ur 1NbOx.\n\nw0uld j00 l1KE tO g0 +o your inB0x N0w?";
$lang['youhavexnewpmand1waiting'] = "j00 h4ve %d N3w m3$$493$.\n\ny0u 4ls0 h4v3 1 m3$54g3 4W4i+1N9 D3lIv3ry. +o Rec3iV3 +h1$ M3s5@9E PLE@s3 cLE@r $0mE SP4Ce 1n Y0UR 1NBOx.\n\nwOUlD j00 l1ke +O g0 +0 Y0Ur 1n80x nOw?";
$lang['youhavexnewpmandxwaiting'] = "j00 h4vE %d NEw MeS$@geS.\n\ny0u 4LSO H@V3 %d m3$S@GEs aW@1+1Ng d3l1v3ry. +0 RECEiV3 TH3$3 m3s$4g3 pL34S3 cLe@R S0mE $p@CE 1n yOur iN8OX.\n\nw0uld J00 L1kE tO 9O tO y0ur 1nB0x now?";
$lang['youhave1newpmandxwaiting'] = "j00 h4ve 1 nEW mE$S4gE.\n\nYoU @L5o H4v3 %d M3$$49es 4W@I+Ing d3lIVEry. +0 r3CeiV3 th3se M3S54GeS Pl3A$3 cL34R $Ome $P4CE In y0Ur In8ox.\n\nw0UlD J00 l1KE +o 90 +0 YOuR in80x NOw?";
$lang['youhavexpmwaiting'] = "j00 h4V3 %d m3$$4g3s @W41+1n9 d3lIVERY. +0 Rec3ivE +h3$3 mEsS4g3s pLE4se CLE4R 50Me sp4ce 1n yoUR iNBOx.\n\nW0UlD J00 LIk3 +0 go to yOur In8ox N0W?";

$lang['youdonothaveenoughfreespace'] = "j00 Do no+ H4VE 3n0u9H pHRE3 Sp@Ce +o 5enD +HiS ME554GE.";
$lang['userhasoptedoutofpm'] = "%s H4s oP+3d 0uT OPH R3ce1V1n9 P3r5on4l Mes$493s";
$lang['pmfolderpruningisenabled'] = "pM pHOlD3R prUnIN9 IS EN4bl3d!";
$lang['pmpruneexplanation'] = "this phoruM uSE5 Pm f0lDEr pruniN9. +h3 mes54ges j00 h4ve $+or3d IN your 1nB0x 4nD $3N+ iTEM$\\nPHOLDEr5 4r3 5uBJEC+ +O 4U+Om4t1C DEl3+I0N. @nY ME554GeS J00 WI5h +O KEeP 5H0uld b3 mOV3d +O\\ny0ur \\'$@vEd 1tEMs\\' fOlD3R sO +H4+ +Hey @RE nOt D3LE+ED.";
$lang['yourpmfoldersare'] = "yoUr Pm pH0LdeR$ @r3 %s fulL";
$lang['currentmessage'] = "cuRr3N+ M3$54gE";
$lang['unreadmessage'] = "unReAd ME554g3";
$lang['readmessage'] = "rE4D mE5s49e";
$lang['pmshavebeendisabled'] = "p3r$0n4l meS549ES hav3 b3eN D15@8l3d BY TEH PHoRuM OwNeR.";
$lang['adduserstofriendslist'] = "aDd U$3Rs tO y0UR pHRIEnds LIST +o h4V3 thEm 4pp3@R IN A DROp DOWN 0N +HE PM WR1+3 MEs$4Ge p493.";

$lang['messagewassuccessfullysavedtodraftsfolder'] = "m3Ss493 W@5 5UCcE$$fUlLY saVED +o 'DR4Pht5' Phold3r";
$lang['couldnotsavemessage'] = "c0ulD No+ s4v3 mE5S@g3. m@K3 5URE J00 h@ve 3NoU9h Av@IL@8le PHR3E sp4c3.";
$lang['pmtooltipxmessages'] = "%s m3s$4g35";
$lang['pmtooltip1message'] = "1 M3$54gE";

$lang['allowusertosendpm'] = "all0W us3r +0 53nd p3r50N@l M3S54ge$ tO ME";
$lang['blockuserfromsendingpm'] = "blOCK U$3r Fr0M SeNdIng pEr50N@l M35S4GE$ +0 M3";
$lang['yourfoldernamefolderisempty'] = "yoUR %s FOldEr I5 3mpTY";
$lang['successfullydeletedselectedmessages'] = "sUCc3sspHullY DELE+ED sElEC+3d me$54935";
$lang['successfullyarchivedselectedmessages'] = "sucCE$spHULly @rcHIVeD 5eLEctEd m3$5a9es";
$lang['failedtodeleteselectedmessages'] = "f@1LeD t0 D3L3Te s3LeCTed mE$$4g3$";
$lang['failedtoarchiveselectedmessages'] = "f@Il3D +O 4rchIv3 $eLEc+ED mE554G3$";

// Preferences / Profile (user_*.php) ---------------------------------------------

$lang['mycontrols'] = "mY Con+R0L5";
$lang['myforums'] = "my phoRumS";
$lang['menu'] = "menU";
$lang['userexp_1'] = "u53 tH3 Menu oN +He L3f+ +0 m4N4Ge yoUr sE++In9$.";
$lang['userexp_2'] = "<b>uSER D3+a1Ls</b> @lloWs j00 +0 Ch4N93 y0Ur N@Me, em41l 4ddR3S5 4ND P4$5W0rD.";
$lang['userexp_3'] = "<b>u53r prOF1l3</b> 4lloWs J00 +o 3d1T YOuR u$3R pr0fil3.";
$lang['userexp_4'] = "<b>cH4NGe pa55word</b> All0WS J00 to CHan93 your P4sSw0RD";
$lang['userexp_5'] = "<b>em4IL &amp; pr1v4cy</b> le+$ J00 ch4n93 How j00 CaN Be C0n+ac+eD On 4Nd ophph Teh FOrum.";
$lang['userexp_6'] = "<b>forum 0p+Ion$</b> l3+S J00 CH4NG3 h0w thE FOrUm l0ok5 4Nd worK$.";
$lang['userexp_7'] = "<b>a+t@ChM3nT$</b> @ll0ws j00 +o Ed1+/Dele+3 y0ur 4+tACHMEN+S.";
$lang['userexp_8'] = "<b>s19n4tur3</b> L3+$ j00 3dI+ Y0uR sign4tuRe.";
$lang['userexp_9'] = "<b>r3L4tI0n$hIP$</b> lEts J00 m4n@ge Your rEl@T10n5hiP W1th 0thER UsER5 On +eh ph0Rum.";
$lang['userexp_9'] = "<b>word phIlt3R</b> L3+5 j00 3d1t YoUr p3Rs0n4l w0RD PHIl+3R.";
$lang['userexp_10'] = "<b>tHREad su8$CR1pT1ON$</b> @LLOw5 j00 To M4N@93 Y0uR tHR34d su8ScR1P+i0n5.";
$lang['userdetails'] = "u$3r DE+@1ls";
$lang['userprofile'] = "us3r ProfiLE";
$lang['emailandprivacy'] = "eM41l &amp; pR1V4CY";
$lang['editsignature'] = "eD1+ s19N4+uRE";
$lang['norelationshipssetup'] = "j00 H@v3 no us3r r3L4+ioNsH1pS $3t uP. AdD @ N3W U$3r BY $34RCHIN9 BelOw.";
$lang['editwordfilter'] = "edi+ wORD FilTER";
$lang['userinformation'] = "u$3R InpH0rm4+1on";
$lang['changepassword'] = "cH4nG3 p4s$woRd";
$lang['currentpasswd'] = "currEn+ P@$sW0rD";
$lang['newpasswd'] = "nEw p@$$WOrd";
$lang['confirmpasswd'] = "conFirm p@ssWOrD";
$lang['passwdsdonotmatch'] = "p4$5W0rDS d0 n0+ m4tch!";
$lang['nicknamerequired'] = "nIcknAM3 iS r3quir3d!";
$lang['emailaddressrequired'] = "eMa1l AdDr3s5 i$ r3quiReD!";
$lang['logonnotpermitted'] = "l0g0n n0T p3Rmi+ted. choosE @n0thEr!";
$lang['nicknamenotpermitted'] = "nicknAm3 n0+ perMi++eD. Cho0$3 4noth3R!";
$lang['emailaddressnotpermitted'] = "emA1l 4Ddres$ N0+ P3rm1++3d. cH00s3 @n0+her!";
$lang['emailaddressalreadyinuse'] = "eM4IL 4ddR3$$ 4lRe4Dy 1n Use. ch0os3 4no+her!";
$lang['relationshipsupdated'] = "rEl4+1ON$h1p$ upDa+ed!";
$lang['relationshipupdatefailed'] = "r3L4T1on$H1p uPd4+ed pH@il3d!";
$lang['preferencesupdated'] = "prEfereNC3s w3r3 $uCc3$sfULLY upd4TED.";
$lang['userdetails'] = "uSer d3+41l5";
$lang['memberno'] = "m3mB3r no.";
$lang['firstname'] = "f1r$+ n@Me";
$lang['lastname'] = "l4S+ N@m3";
$lang['dateofbirth'] = "d@t3 0Ph 8Ir+H";
$lang['homepageURL'] = "hOmeP493 urL";
$lang['profilepicturedimensions'] = "pROf1le P1Ctur3 (m4X 95x95px)";
$lang['avatarpicturedimensions'] = "av@+4r Pic+ure (m@x 15X15px)";
$lang['invalidattachmentid'] = "iNV4L1d 4t+4chm3Nt. CheCK th@+ 1s h@sn't B33N D3lEt3D.";
$lang['unsupportedimagetype'] = "unSUPp0rted 1m@93 4t+4chMEnt. j00 c@n ONly U5E jp9, 91f @nd pNG 1m4G3 4T+@cHmentS phoR Y0Ur Av4+@r 4ND Pr0Ph1l3 p1Ctur3.";
$lang['selectattachment'] = "s3lect 4++4ChM3N+";
$lang['pictureURL'] = "p1c+ur3 URl";
$lang['avatarURL'] = "aV4t4r url";
$lang['profilepictureconflict'] = "t0 U$e 4N 4++@chm3n+ ph0r y0UR profil3 P1C+URe +h3 p1C+ur3 url f13LD mU5+ Be bl@Nk.";
$lang['avatarpictureconflict'] = "t0 u5e @N @t+4cHMeNt for Your Av4+4R piC+urE The 4V4+Ar Url f1elD musT Be Bl4nk.";
$lang['attachmenttoolargeforprofilepicture'] = "s3l3c+eD 4+T4cHmen+ I5 t00 larg3 for pR0F1l3 piCtUr3. m4x1mUM d1men$i0n5 4re %s";
$lang['attachmenttoolargeforavatarpicture'] = "s3leCT3d 4T+@cHmen+ i$ toO L@rGe F0r 4v4taR piCTuRE. m@x1MUM DIm3nSion5 4RE %s";
$lang['failedtoupdateuserdetails'] = "s0me or @lL oPH yoUr U$3R AcC0UNT D3+4Il$ CoulD N0+ Be UpdA+ED. pLe4$E tRy 49@1n la+3R.";
$lang['failedtoupdateuserpreferences'] = "soM3 or 4Ll 0f y0ur U5eR pR3ph3r3nCE$ C0Uld no+ Be UpDa+eD. PLe4$e tRy 4G41n l4+er.";
$lang['emailaddresschanged'] = "em4IL @dDreS$ has B33N CH@n93D";
$lang['newconfirmationemailsuccess'] = "y0ur eM4il ADDre$5 h45 b3EN chan93D @nD 4 n3W cOnf1rm@+1oN 3M4il h45 8een $eNt. pLeA5E CHecK 4nd R34d +he em@1l pHoR pHur+her InstRuC+10n$.";
$lang['newconfirmationemailfailure'] = "j00 h4v3 cHan9ED YOUr eMa1L 4ddR3$$, 8U+ w3 w3r3 Un@8le tO s3nd a coNphirM@+ion REquest. PLE@$3 Con+ac+ th3 PHorum own3R f0r 4S5IST@NCE.";
$lang['forumoptions'] = "f0RuM 0Pt10ns";
$lang['notifybyemail'] = "no+ipHY by 3M41l 0f P0$T$ +0 m3";
$lang['notifyofnewpm'] = "n0+1phy BY poPUP 0ph N3w Pm m3s$49e5 +o me";
$lang['notifyofnewpmemail'] = "n0+iphy bY 3M4il 0F n3w pM Me$54G3s to m3";
$lang['daylightsaving'] = "aDjUst pH0r d4Yl19H+ 5@v1NG";
$lang['autohighinterest'] = "au+OM@t1c4lly m4RK +HR34Ds 1 P0S+ In @s H1Gh 1n+ErEs+";
$lang['convertimagestolinks'] = "au+om@+iC4lLy c0nV3r+ 3mbeddEd IM@935 in pO$+$ In+o l1NKS";
$lang['thumbnailsforimageattachments'] = "tHum8N@1LS pHor iM@9e @T+4cHmEnTs";
$lang['smallsized'] = "sM4ll siZeD";
$lang['mediumsized'] = "med1UM Siz3D";
$lang['largesized'] = "l4r9e 51z3d";
$lang['globallyignoresigs'] = "gL08@LLY I9nor3 uSER 5igN4tUr3S";
$lang['allowpersonalmessages'] = "aLl0w O+h3R U53r$ to SEnD me p3r$ON@l M3s5AgEs";
$lang['allowemails'] = "allow 0+h3r U$eR5 To SeNd m3 3M@il5 vI4 My pr0ph1le";
$lang['timezonefromGMT'] = "t1mE z0N3";
$lang['postsperpage'] = "p05+$ PER p@9e";
$lang['fontsize'] = "f0NT $iZ3";
$lang['forumstyle'] = "forum s+YL3";
$lang['forumemoticons'] = "fORUM EMOtIC0n5";
$lang['startpage'] = "sT4r+ p4GE";
$lang['signaturecontainshtmlcode'] = "sI9N4TuRE C0Nt4in$ H+ML C0d3";
$lang['savesignatureforuseonallforums'] = "s@v3 S19n@+urE PHOr uS3 oN @lL phOrUMS";
$lang['preferredlang'] = "pr3FERR3D L4NGu@g3";
$lang['donotshowmyageordobtoothers'] = "do N0+ Sh0W mY 493 oR D@T3 0Ph 81rtH +0 0+h3rs";
$lang['showonlymyagetoothers'] = "shOW oNly MY @93 To 0+h3R5";
$lang['showmyageanddobtoothers'] = "show Bo+H My 493 @nd dAt3 of BIr+H tO 0thers";
$lang['showonlymydayandmonthofbirthytoothers'] = "sHOW 0NLy mY d@y 4nD mON+h 0PH 8Ir+h +0 0THeRs";
$lang['listmeontheactiveusersdisplay'] = "lIs+ M3 ON THE 4CTIVe U53r5 Di$pL4y";
$lang['browseanonymously'] = "bR0ws3 PhorUM @NOnymoUsLy";
$lang['allowfriendstoseemeasonline'] = "bR0W$E 4noNyMoUslY, 8uT 4lLow pHr13Nd$ tO Se3 M3 4S 0nl1n3";
$lang['revealspoileronmouseover'] = "r3VE@l sPo1lEr$ On M0uS3 0V3R";
$lang['showspoilersinlightmode'] = "aLW4YS sH0W sp01L3r$ in ligH+ MOD3 (U$35 lI9HT3R f0nT c0l0uR)";
$lang['resizeimagesandreflowpage'] = "rE$1z3 1m4gEs @Nd RefloW P4G3 +0 pR3vEnT HOr1z0n+aL sCR0Ll1n9.";
$lang['showforumstats'] = "shOW pHORum $T@ts at 8O++0m of mES5@9e p4N3";
$lang['usewordfilter'] = "eNA8L3 worD fIL+3r.";
$lang['forceadminwordfilter'] = "forc3 U5e 0f 4dMin W0rD pH1L+3r on 4lL U$3r$ (inC. 9u35Ts)";
$lang['timezone'] = "t1M3 Z0n3";
$lang['language'] = "l@ngu@9e";
$lang['emailsettings'] = "em4IL 4Nd Con+4ct $3++in9s";
$lang['forumanonymity'] = "f0RUm 4nonYmITy $ET+IN9$";
$lang['birthdayanddateofbirth'] = "b1RthDaY 4nd d4+3 0ph 81rth DIspl4y";
$lang['includeadminfilter'] = "inCludE 4dm1n w0RD F1Lt3R 1N my l1$+.";
$lang['setforallforums'] = "s3T for 4lL phoRUMs?";
$lang['containsinvalidchars'] = "%s c0Nt4in5 1nV4lId cH4r4C+3R$!";
$lang['homepageurlmustincludeschema'] = "hOmeP4g3 URL mus+ InCluD3 H+tp:// sCheM4.";
$lang['pictureurlmustincludeschema'] = "p1C+ur3 Url mUS+ inCluD3 Http:// sChem4.";
$lang['avatarurlmustincludeschema'] = "av4+4R URl MuSt 1NClUdE h+tp:// $Ch3m@.";
$lang['postpage'] = "pO$+ pa93";
$lang['nohtmltoolbar'] = "no h+ml t00l8ar";
$lang['displaysimpletoolbar'] = "di5pL@y SimPLE hTMl +00Lb4R";
$lang['displaytinymcetoolbar'] = "d15PlAY WYs1wy9 HtMl +0ol84r";
$lang['displayemoticonspanel'] = "dIsPl4Y Em0+ICons P4nel";
$lang['displaysignature'] = "disPlaY s19na+uRE";
$lang['disableemoticonsinpostsbydefault'] = "d1$4bL3 em0+1con5 1n m3Ss4G3$ 8Y D3pH4uL+";
$lang['automaticallyparseurlsbydefault'] = "aut0m4+1c4LLY p4RS3 urLS in me5s@g3$ BY d3ph4ult";
$lang['postinplaintextbydefault'] = "pO$t 1n Pla1n T3X+ 8y D3F@ULt";
$lang['postinhtmlwithautolinebreaksbydefault'] = "poSt In H+Ml W1+h @U+0-l1N3-BR34KS 8Y D3pH@Ul+";
$lang['postinhtmlbydefault'] = "pO$T 1n h+mL By D3F4ULT";
$lang['postdefaultquick'] = "uS3 qU1CK rEpLy By DePH4uLt. (FulL R3PlY In mEnu)";
$lang['privatemessageoptions'] = "prIVAte M3SSAge 0Pt1Ons";
$lang['privatemessageexportoptions'] = "pr1V@+3 m3$S@gE 3Xp0R+ Op+IOn$";
$lang['savepminsentitems'] = "s4V3 4 C0py 0ph 34Ch Pm 1 senD 1n MY $Ent I+Ems FoLD3R";
$lang['includepminreply'] = "incLuDe M3$$4g3 BodY whEn REpLy1n9 +O pm";
$lang['autoprunemypmfoldersevery'] = "auT0 Prun3 MY pM PhoLdeR5 evErY:";
$lang['friendsonly'] = "fr13NDS 0nLY?";
$lang['globalstyles'] = "gLO8@l $+YlE$";
$lang['forumstyles'] = "forUM $TYLEs";
$lang['youmustenteryourcurrentpasswd'] = "j00 MuS+ 3NT3R yOUr cUrR3Nt P@$$W0rD";
$lang['youmustenteranewpasswd'] = "j00 mU5t 3nteR 4 nEw p4$5W0Rd";
$lang['youmustconfirmyournewpasswd'] = "j00 MU$+ C0nPH1rm y0ur N3w p@ssw0RD";
$lang['profileentriesmustnotincludehtml'] = "pR0fiL3 3n+ri3S mu5T n0T 1ncluDE H+mL";
$lang['failedtoupdateuserprofile'] = "fAilED t0 updat3 u$er pR0f1l3";

// Polls (create_poll.php, poll_results.php) ---------------------------------------------

$lang['mustprovideanswergroups'] = "j00 MU5T pR0vid3 5om3 4nswer 9rOUPs";
$lang['mustprovidepolltype'] = "j00 mU5t Pr0v1d3 4 p0Ll +yp3";
$lang['mustprovidepollresultsdisplaytype'] = "j00 mUsT Prov1d3 rESuLtS D1SpL4y +yPE";
$lang['mustprovidepollvotetype'] = "j00 MUsT pROv1d3 @ pOll VotE +ypE";
$lang['mustprovidepollguestvotetype'] = "j00 MU5+ 5PECIFy iph gu35+$ 5HOuLD 8E 4ll0w3D t0 vOT3";
$lang['mustprovidepolloptiontype'] = "j00 Mus+ pROvIde A P0LL oP+i0n +yp3";
$lang['mustprovidepollchangevotetype'] = "j00 mUsT Pr0VID3 4 P0ll CH4ngE votE +Yp3";
$lang['pollquestioncontainsinvalidhtml'] = "on3 0r M0r3 oF y0ur Poll quesT10nS C0Nt4In5 InV@lid h+ml.";
$lang['pleaseselectfolder'] = "pL3@$e s3lEC+ 4 ph0LDeR";
$lang['mustspecifyvalues1and2'] = "j00 mUs+ 5p3cipHY v4LUe$ for 4n5W3r$ 1 4nd 2";
$lang['tablepollmusthave2groups'] = "t4Bul@r ph0rm@T poLL$ muS+ h@Ve pRECis3LY Two votINg 9r0upS";
$lang['nomultivotetabulars'] = "t48UL4r Phorm4t polLs C4nn0+ b3 MUlTI-vOtE";
$lang['nomultivotepublic'] = "pu8LIc B@LL0ts c4nnot 8E MulT1-vo+3";
$lang['abletochangevote'] = "j00 WiLL 8e @bLe +o ch@nG3 y0uR VO+E.";
$lang['abletovotemultiple'] = "j00 wilL b3 4Ble +0 vOt3 Mul+iple +1mE$.";
$lang['notabletochangevote'] = "j00 wILl n0+ B3 @8le to ch4nge YOUr vO+E.";
$lang['pollvotesrandom'] = "nOT3: pOll V0+es 4Re r@ndomly g3NEr4t3D Ph0r prevI3w only.";
$lang['pollquestion'] = "p0ll qUEs+1ON";
$lang['possibleanswers'] = "p05$1Bl3 @nSW3rs";
$lang['enterpollquestionexp'] = "eN+ER the 4N5wer$ Ph0R YoUR P0lL qU3St1oN.. 1ph y0Ur pOLl i$ 4 &quot;yE5/N0&quot; qU3$+I0n, $1mPlY 3N+Er &quot;Y3$&quot; phor 4nswER 1 4ND &quot;n0&quot; FOr @n$w3r 2.";
$lang['numberanswers'] = "n0. 4Nswer$";
$lang['answerscontainHTML'] = "aN$w3r5 cont4in h+ml (NoT 1nCLUDin9 S19n4+uR3)";
$lang['optionsdisplay'] = "aNSWer5 D1$PL4y tYP3";
$lang['optionsdisplayexp'] = "hOW Sh0uLd TEh 4nSW3r$ 8e Pr3$en+ED?";
$lang['dropdown'] = "a$ Dr0P-D0wn li5t(s)";
$lang['radios'] = "a$ 4 SErie$ 0ph R@dI0 8u+T0n5";
$lang['votechanging'] = "v0t3 Ch4ngIng";
$lang['votechangingexp'] = "c4N 4 PErsOn CHAngE his or hEr v0tE?";
$lang['guestvoting'] = "guEs+ v0tiNG";
$lang['guestvotingexp'] = "c4n 9U3sts V0tE In +HIS POLl?";
$lang['allowmultiplevotes'] = "alloW mult1pl3 VO+3$";
$lang['pollresults'] = "poll r3$ul+s";
$lang['pollresultsexp'] = "h0W w0uLD j00 L1KE +0 di5pl4y +3h rESULts oPH y0ur P0lL?";
$lang['pollvotetype'] = "p0LL VotIN9 +ypE";
$lang['pollvotesexp'] = "h0w SH0ulD T3h POLl bE CoNduc+3D?";
$lang['pollvoteanon'] = "aN0nYmOuSlY";
$lang['pollvotepub'] = "pu8l1C 84Ll0+";
$lang['horizgraph'] = "hOriz0nt4l GR4ph";
$lang['vertgraph'] = "v3Rt1cAl gR@pH";
$lang['tablegraph'] = "t4BuL4r fOrm@+";
$lang['polltypewarning'] = "<b>w@rN1ng</b>: +hI$ 1s 4 pu8l1C bAlloT. y0ur nam3 w1ll BE vI$i8l3 nExT to tHe 0pti0N J00 votE for.";
$lang['expiration'] = "exP1r4+1on";
$lang['showresultswhileopen'] = "d0 J00 w4N+ tO shoW r3$UlTs wHiL3 teh p0LL i$ 0p3n?";
$lang['whenlikepollclose'] = "wH3n w0uLD J00 LiK3 y0Ur P0Ll to 4u+0m4tiC@Lly CL053?";
$lang['oneday'] = "oN3 d4Y";
$lang['threedays'] = "tHr33 D@Y$";
$lang['sevendays'] = "seVEN d4Ys";
$lang['thirtydays'] = "th1r+y DAys";
$lang['never'] = "nEVeR";
$lang['polladditionalmessage'] = "aDdi+10n4L Mes$aG3 (0pt1onal)";
$lang['polladditionalmessageexp'] = "dO j00 w4n+ +O 1nClUdE 4N 4ddIt10n@l P0$+ 4f+3r +hE P0ll?";
$lang['mustspecifypolltoview'] = "j00 Mu$t Sp3c1PHY A pOLL t0 vI3w.";
$lang['pollconfirmclose'] = "ar3 j00 suR3 j00 W4N+ T0 clOSe +h3 FOll0WiN9 pOlL?";
$lang['endpoll'] = "eNd P0ll";
$lang['nobodyvotedclosedpoll'] = "nob0dy vo+ED";
$lang['votedisplayopenpoll'] = "%s @nD %s h4v3 V0+eD.";
$lang['votedisplayclosedpoll'] = "%s @nD %s vo+3d.";
$lang['nousersvoted'] = "no useRS";
$lang['oneuservoted'] = "1 u$3R";
$lang['xusersvoted'] = "%s UseR5";
$lang['noguestsvoted'] = "n0 9uest$";
$lang['oneguestvoted'] = "1 9U3$+";
$lang['xguestsvoted'] = "%s 9uEsT$";
$lang['pollhasended'] = "p0ll h4S eNded";
$lang['youvotedforpolloptionsondate'] = "j00 vO+3D ph0r %s 0N %s";
$lang['thisisapoll'] = "tHi5 I$ 4 P0lL. CLICK +0 V13W ResUl+$.";
$lang['editpoll'] = "eDIt poLl";
$lang['results'] = "r3$UL+s";
$lang['resultdetails'] = "reSuL+ dE+4il5";
$lang['changevote'] = "ch4nG3 Vo+3";
$lang['pollshavebeendisabled'] = "p0LLs H4v3 833n D1$@8l3D BY t3H PH0rUm owNeR.";
$lang['answertext'] = "answeR T3x+";
$lang['answergroup'] = "an$weR GROuP";
$lang['previewvotingform'] = "pR3v1ew vOT1n9 F0rm";
$lang['viewbypolloption'] = "v13W 8y pOLl OPt10n";
$lang['viewbyuser'] = "vi3w 8Y U53r";

// Profiles (profile.php) ----------------------------------------------

$lang['editprofile'] = "edI+ prOf1lE";
$lang['profileupdated'] = "pR0pHIlE uPD4t3d.";
$lang['profilesnotsetup'] = "th3 Ph0RUM 0wNER h4S nOT S3T Up PR0F1l35.";
$lang['ignoreduser'] = "ign0R3d u$eR";
$lang['lastvisit'] = "l@s+ Vis1+";
$lang['userslocaltime'] = "u5ER'$ l0C4l +ImE";
$lang['userstatus'] = "st4Tus";
$lang['useractive'] = "onLine";
$lang['userinactive'] = "inAC+1ve / OPhphl1ne";
$lang['totaltimeinforum'] = "t0+@l t1ME";
$lang['longesttimeinforum'] = "l0ng3St $E5si0N";
$lang['sendemail'] = "seND 3M41L";
$lang['sendpm'] = "s3Nd PM";
$lang['visithomepage'] = "vi$1+ hom3p@g3";
$lang['age'] = "a93";
$lang['aged'] = "aged";
$lang['birthday'] = "bIRThd@y";
$lang['registered'] = "re9Ist3r3d";
$lang['findpostsmadebyuser'] = "f1ND POS+s M4D3 8Y %s";
$lang['findpostsmadebyme'] = "f1ND p0S+5 mad3 8y m3";
$lang['findthreadsstartedbyuser'] = "fiNd Thr34Ds St4R+ED 8Y %s";
$lang['findthreadsstartedbyme'] = "f1nD +HRe@ds S+@rt3d 8Y mE";
$lang['profilenotavailable'] = "prOPHILe nO+ @v4Il@BLe.";
$lang['userprofileempty'] = "tHi$ u$3R H45 N0+ PH1ll3D In th31R Pr0FiLE Or It 1S $ET +0 priV@+E.";

// Registration (register.php) -----------------------------------------

$lang['newuserregistrationsarenotpermitted'] = "s0rry, NEW USEr ReGisTr4T1ONs 4r3 N0t 4LL0WeD R1Ght N0w. ple@s3 CH3CK b4Ck l4t3r.";
$lang['usernameinvalidchars'] = "uS3rn4m3 C4N only C0NT41N 4-Z, 0-9, _ - CHar@C+3R5";
$lang['usernametooshort'] = "u$eRN4M3 Mu$t BE 4 minimUM OpH 2 cH4r4cter5 L0ng";
$lang['usernametoolong'] = "u$3RN4m3 MuST 83 4 m4X1mUM oph 15 ch4r4ct3RS LOng";
$lang['usernamerequired'] = "a Log0n n4Me 15 R3qU1r3d";
$lang['passwdmustnotcontainHTML'] = "p@Ssw0rd mu$+ Not con+4iN htMl TA95";
$lang['passwordinvalidchars'] = "p@$sw0rd C4N OnLy cont4iN @-z, 0-9, _ - charAC+3rS";
$lang['passwdtooshort'] = "p@s5w0rd mus+ BE 4 MinimUm 0f 6 Ch4R4CterS loNG";
$lang['passwdrequired'] = "a p4S$w0rd 15 R3QuIr3D";
$lang['confirmationpasswdrequired'] = "a c0NFirm@t1oN pa$5woRD 1s r3quIrEd";
$lang['nicknamerequired'] = "a n1cKname 15 REQUiRED";
$lang['emailrequired'] = "aN EM@iL @Ddres$ 1$ R3qu1R3D";
$lang['passwdsdonotmatch'] = "p45Sw0RdS DO no+ M4tch";
$lang['usernamesameaspasswd'] = "us3rn4me aND p4SSWOrD mu$+ b3 d1ff3r3N+";
$lang['usernameexists'] = "soRRy, 4 u$3r w1+H Th4T n4m3 4lr34DY EXIS+s";
$lang['successfullycreateduseraccount'] = "sUcC3$$FuLLY Cr34+3d UsER 4Cc0unt";
$lang['useraccountcreatedconfirmfailed'] = "y0ur US3R @ccOUN+ h45 BE3n Cr3@+3D BUt TH3 R3quIr3D c0NpH1rm@tIoN Em@Il w4$ n0T s3nT. pLE4s3 CoN+4c+ +3h fOruM 0WNer +o r3CtiFy +HIs. iN +His M34ntiM3 pL3@s3 cLiCk tHe CoN+INue BUT+0n t0 LOg1n.";
$lang['useraccountcreatedconfirmsuccess'] = "y0uR U53r Acc0uN+ h@$ b3EN CRE4tED But 83phOr3 j00 c@n $T4rt pO5+In9 j00 mU$T C0nPhIrM Y0ur Em4Il 4DdR35S. PLe453 cHecK Y0UR Em41L F0r 4 L1nk +h@T w1ll @LLoW J00 +0 CoNPhirm YOur 4ddR35s.";
$lang['useraccountcreated'] = "y0ur U53R 4cCoUNt h45 8e3n Cr3ATeD SUccE55PHuLly! cl1CK tH3 CON+1nUe BUT+On 83lOW +0 l091n";
$lang['errorcreatinguserrecord'] = "eRr0r cRe@tIn9 useR ReCORD";
$lang['userregistration'] = "us3R rEgIs+R4+iOn";
$lang['registrationinformationrequired'] = "re9i$tR4+1on INpH0rmATi0n (r3QUiR3d)";
$lang['profileinformationoptional'] = "pR0fIlE infOrMAt10n (0p+i0N@L)";
$lang['preferencesoptional'] = "pR3fER3NC3s (0pt1oN@l)";
$lang['register'] = "re9i$t3R";
$lang['rememberpasswd'] = "rEMEm8Er p4sSw0RD";
$lang['birthdayrequired'] = "d4T3 oph 8iRTh is r3QU1r3d 0R I$ 1nV@l1d";
$lang['alwaysnotifymeofrepliestome'] = "no+1fy 0n r3Ply t0 mE";
$lang['notifyonnewprivatemessage'] = "n0tIfY oN NeW Pr1v4+3 M3s$@9E";
$lang['popuponnewprivatemessage'] = "pOp up on nEW pRIV4te M3ss49e";
$lang['automatichighinterestonpost'] = "aUTOM4+ic hIGH Int3R3s+ 0N p05t";
$lang['confirmpassword'] = "c0nFiRM p45SworD";
$lang['invalidemailaddressformat'] = "inV4lid 3m41l 4dDre5s pHORm4+";
$lang['moreoptionsavailable'] = "m0R3 pr0pHilE AND pr3fer3nC3 0P+10N5 @r3 4v4iL48L3 0nC3 j00 R3gI5t3R";
$lang['textcaptchaconfirmation'] = "c0NPH1rm4+ioN";
$lang['textcaptchaexplain'] = "to +hE R19h+ 15 4 +3xt-cAptch4 im4ge. pl3@5E TyPE +3h COdE J00 c4N s3E 1n +3h 1m4G3 IntO THe iNPu+ PH1ElD B3l0w 1+.";
$lang['textcaptchaimgtip'] = "thIS i$ 4 C4p+cH4-p1c+URe. It 1s USEd +O pREv3Nt au+0m@t1C r39Istr4ti0N";
$lang['textcaptchamissingkey'] = "a conf1rm4+1on c0De Is R3qU1R3D.";
$lang['textcaptchaverificationfailed'] = "t3x+-C4p+Ch4 v3RIPH1C4TIon C0D3 w4S 1nC0rr3Ct. Pl345e Re-en+eR 1+.";
$lang['forumrules'] = "forUm rUlEs";
$lang['forumrulesnotification'] = "iN oRDer +0 proC33D, j00 Mu$+ 4grEe W1Th tH3 pH0llOW1ng rUL3$";
$lang['forumrulescheckbox'] = "i H4ve Re4d, 4nd 4gR33 To 4BIDe bY +h3 ph0rum ruL35.";
$lang['youmustagreetotheforumrules'] = "j00 mus+ @9ReE to +H3 ph0RuM rul3$ b3f0r3 j00 c4n con+inUe.";

// Recent visitors list  (visitor_log.php) -----------------------------

$lang['member'] = "m3M8er";
$lang['searchforusernotinlist'] = "s3@rCh PhOR @ uS3r nOT iN L1s+";
$lang['yoursearchdidnotreturnanymatches'] = "y0Ur 53arcH did n0+ rE+URn @ny m4+cH35. Try $1mpl1PHY1n9 your 53arCH paR4m3tERS anD TrY 4g4In.";
$lang['hiderowswithemptyornullvalues'] = "h1D3 RoWs wi+H eMpTy or nUll v4lue$ 1n seLeCteD C0LuMN5";
$lang['showregisteredusersonly'] = "sH0w rE9iS+erED Us3r$ 0NlY (H1d3 9U3STs)";

// Relationships (user_rel.php) ----------------------------------------

$lang['relationships'] = "r3L@+1OnshIps";
$lang['userrelationship'] = "uS3R Rel4tI0n5h1p";
$lang['userrelationships'] = "us3r REL4+1on5H1p$";
$lang['failedtoremoveselectedrelationships'] = "f4IL3d +0 ReMOV3 s3lec+3D r3L@TI0n5h1p";
$lang['friends'] = "fr13nds";
$lang['ignoredcompletely'] = "iGnOR3D CoMpL3+3ly";
$lang['relationship'] = "reLa+i0nshIp";
$lang['restorenickname'] = "r3S+0r3 u53R'$ nicKN4ME";
$lang['friend_exp'] = "u$3r'S p0$t$ m@rked W1th @ &quot;fri3nd&quot; ICOn.";
$lang['normal_exp'] = "u$Er'5 P0ST$ @Pp34r 4$ n0rM4l.";
$lang['ignore_exp'] = "uSeR'5 P0s+S @R3 HidD3N.";
$lang['ignore_completely_exp'] = "tHRe@D$ 4nd p0st5 +o 0r PHR0M U$Er W1lL 4PPe4R D3l3+3d.";
$lang['display'] = "dI$pl4Y";
$lang['displaysig_exp'] = "u$er's 519n4TuRE 1$ dI$pl4y3d 0n tHE1r pO5+$.";
$lang['hidesig_exp'] = "uS3R'$ $19N4tUR3 is h1Dd3n on +Heir p0$ts.";
$lang['cannotignoremod'] = "j00 C4nn0t 1gn0r3 this U$3r, 4S they 4Re 4 modeR4+0r.";
$lang['previewsignature'] = "prEVIEW SI9n4ture";

// Search (search.php) -------------------------------------------------

$lang['searchresults'] = "sE4rCh re$Ul+S";
$lang['usernamenotfound'] = "tH3 uSErn4m3 j00 5peC1PhiED 1n +hE +0 or pHrom ph13ld w4s no+ ph0UNd.";
$lang['notexttosearchfor'] = "on3 0r 4lL 0Ph yOur s34rcH keYW0Rds WERE Inv4L1d. S3@RcH k3YWorD$ MUs+ 83 n0 5h0r+3r +h4n %d cH@R@C+Er5, N0 l0n93R +h4n %d ch4r@CtErs 4ND mu$T N0+ 4ppE4r 1N +he %s";
$lang['keywordscontainingerrors'] = "kEyW0rds c0n+4in1nG eRr0rs: %s";
$lang['mysqlstopwordlist'] = "mySqL $ToPw0rd lis+";
$lang['foundzeromatches'] = "fouNd: 0 m4+Ch3$";
$lang['found'] = "found";
$lang['matches'] = "m@+Ch3S";
$lang['prevpage'] = "pR3vI0Us Page";
$lang['findmore'] = "fiND MOrE";
$lang['searchmessages'] = "s34RcH Me$$4ges";
$lang['searchdiscussions'] = "se4rch DisCuS$1On5";
$lang['find'] = "f1nD";
$lang['additionalcriteria'] = "addi+1oN4L Cri+er14";
$lang['searchbyuser'] = "s34rCh 8y U$3r (0pt1on4L)";
$lang['folderbrackets_s'] = "fOld3r($)";
$lang['postedfrom'] = "p0StEd FROm";
$lang['postedto'] = "po$+3D t0";
$lang['today'] = "t0D4y";
$lang['yesterday'] = "yEs+Erday";
$lang['daybeforeyesterday'] = "day b3ph0r3 ye5t3RD4y";
$lang['weekago'] = "%s W33K 49o";
$lang['weeksago'] = "%s W3ek$ 4g0";
$lang['monthago'] = "%s m0n+h @9O";
$lang['monthsago'] = "%s month$ 49O";
$lang['yearago'] = "%s Y3aR 4g0";
$lang['beginningoftime'] = "be9inniNG OF +imE";
$lang['now'] = "nOw";
$lang['lastpostdate'] = "l4sT P0S+ D4te";
$lang['numberofreplies'] = "nUMBer opH REPli3$";
$lang['foldername'] = "f0LDeR n@M3";
$lang['authorname'] = "au+HoR N4M3";
$lang['decendingorder'] = "nEwe$+ pHiR5t";
$lang['ascendingorder'] = "oLd3s+ fiR5t";
$lang['keywords'] = "k3YWord$";
$lang['sortby'] = "s0rt By";
$lang['sortdir'] = "sor+ D1r";
$lang['sortresults'] = "s0r+ rESULts";
$lang['groupbythread'] = "gR0UP by +HRe@D";
$lang['postsfromuser'] = "po$+s FR0M u53R";
$lang['threadsstartedbyuser'] = "tHre4ds 5t@RtEd bY user";
$lang['searchfrequencyerror'] = "j00 C4n 0Nly $3ARCH ONc3 3v3rY %s $3cONdS. PlE@$3 +Ry 4G41N l4tEr.";
$lang['searchsuccessfullycompleted'] = "s3@rCH SuCcE$5fullY c0mPl3+ED. %s";
$lang['clickheretoviewresults'] = "cliCk hERe T0 viEW RE$Ult$.";

// Search Popup (search_popup.php) -------------------------------------

$lang['select'] = "s3lEc+";
$lang['searchforthread'] = "s3@RCh F0r +hre@D";
$lang['mustspecifytypeofsearch'] = "j00 Mu$t $pECipHy +yp3 0f 534rCh tO p3rph0Rm";
$lang['unkownsearchtypespecified'] = "uNKN0Wn 5e@Rch tyP3 $PeC1phiEd";
$lang['mustentersomethingtosearchfor'] = "j00 Mu5t EN+ER SomE+Hing t0 5e@Rch Phor";

// Start page (start_left.php) -----------------------------------------

$lang['recentthreads'] = "r3cEn+ +hR3@Ds";
$lang['startreading'] = "s+4R+ re@D1NG";
$lang['threadoptions'] = "thr3@d opt1On$";
$lang['editthreadoptions'] = "ed1t +hR3@D 0p+1ONS";
$lang['morevisitors'] = "mOr3 vI5It0R5";
$lang['forthcomingbirthdays'] = "fOrTHCOM1nG b1R+HD@YS";

// Start page (start_main.php) -----------------------------------------

$lang['editstartpage_help'] = "j00 C4N EDIT tHiS P4g3 phrOm TH3 4dMin 1nTeRpH@C3";

// Thread navigation (thread_list.php) ---------------------------------

$lang['newdiscussion'] = "n3W D15cu$$10N";
$lang['createpoll'] = "crE@tE poLL";
$lang['search'] = "sE4rCh";
$lang['searchagain'] = "s34rCH @941n";
$lang['alldiscussions'] = "all Di5cusSi0ns";
$lang['unreaddiscussions'] = "unRE@D DIscus5iOns";
$lang['unreadtome'] = "unR34D &quot;+o: M3&quot;";
$lang['todaysdiscussions'] = "t0d4y'S D1scus5i0n$";
$lang['2daysback'] = "2 d4Y$ B4cK";
$lang['7daysback'] = "7 D4y5 B4Ck";
$lang['highinterest'] = "h19h 1nt3r3s+";
$lang['unreadhighinterest'] = "uNre@d hiGh 1n+3rE5T";
$lang['iverecentlyseen'] = "i'v3 RECeNtlY SEeN";
$lang['iveignored'] = "i'vE IgN0REd";
$lang['byignoredusers'] = "by 1GNOrED U53RS";
$lang['ivesubscribedto'] = "i'V3 sU8$Cr1BED +0";
$lang['startedbyfriend'] = "st@r+3d 8Y FR1ENd";
$lang['unreadstartedbyfriend'] = "unRe4d $tD 8Y FrI3nd";
$lang['startedbyme'] = "st4R+3d bY ME";
$lang['unreadtoday'] = "unr3@D ToD4y";
$lang['deletedthreads'] = "d3L3T3D tHR3AD$";
$lang['goexcmark'] = "gO!";
$lang['folderinterest'] = "fold3r InTeR3s+";
$lang['postnew'] = "pO$T N3w";
$lang['currentthread'] = "cURREnT tHr3ad";
$lang['highinterest'] = "h1Gh 1n+3rE$T";
$lang['markasread'] = "m@rk 45 rE4D";
$lang['next50discussions'] = "nex+ 50 DiScUs$1OnS";
$lang['visiblediscussions'] = "vI$1BLE dISCu5s10N5";
$lang['selectedfolder'] = "selec+3D Ph0ld3R";
$lang['navigate'] = "nav19@Te";
$lang['couldnotretrievefolderinformation'] = "tH3r3 4R3 n0 FoLd3rs 4V4il@8LE.";
$lang['nomessagesinthiscategory'] = "nO M3$S4g3$ 1n +h1s c4TEG0Ry. pl345E s3l3c+ @N0ThEr, Or %s FOr 4LL +HrEad5";
$lang['clickhere'] = "cl1cK H3rE";
$lang['prev50threads'] = "pReViouS 50 +HR34D$";
$lang['next50threads'] = "next 50 +hRe4d$";
$lang['nextxthreads'] = "nexT %s ThRe4Ds";
$lang['threadstartedbytooltip'] = "thr3@D #%s $T@rT3d 8y %s. V1EW3D %s";
$lang['threadviewedonetime'] = "1 +1m3";
$lang['threadviewedtimes'] = "%d tIMe$";
$lang['unreadthread'] = "uNrE4d Thr3@D";
$lang['readthread'] = "r3@d +hRE4d";
$lang['unreadmessages'] = "uNR34d mES$4g35";
$lang['subscribed'] = "suBsCriBED";
$lang['stickythreads'] = "s+iCky +hr34ds";
$lang['mostunreadposts'] = "moSt uNr34d PO$T5";
$lang['onenew'] = "%d new";
$lang['manynew'] = "%d N3W";
$lang['onenewoflength'] = "%d neW 0pH %d";
$lang['manynewoflength'] = "%d n3w 0f %d";
$lang['confirmmarkasread'] = "ar3 j00 5UR3 j00 w@n+ +o m4rk tHe $3L3CTed +HR3aDS 4$ RE@d?";
$lang['successfullymarkreadselectedthreads'] = "suCcE5$PhuLlY m4RKED 5eLEC+3d +hR3aD$ A5 rE@d";
$lang['failedtomarkselectedthreadsasread'] = "f@Il3d t0 M4rk 5EL3C+3d +HRE@d5 4s r34d";
$lang['gotofirstpostinthread'] = "gO +o pHIrSt p05T 1n +hrEaD";
$lang['gotolastpostinthread'] = "g0 to l4$t p05+ 1n ThRE4d";
$lang['viewmessagesinthisfolderonly'] = "vIeW mE5S4g3$ 1N +h1$ FoLDEr 0nlY";
$lang['shownext50threads'] = "show n3xt 50 ThR3@D$";
$lang['showprev50threads'] = "show PrEv10u5 50 tHRE@d5";
$lang['createnewdiscussioninthisfolder'] = "crE4+E NEw D1scU$$1on IN +h1S F0LDeR";
$lang['nomessages'] = "n0 mEss4Ge5";

// HTML toolbar (htmltools.inc.php) ------------------------------------
$lang['bold'] = "b0ld";
$lang['italic'] = "itAliC";
$lang['underline'] = "uNd3rliNe";
$lang['strikethrough'] = "stR1k3+hr0U9H";
$lang['superscript'] = "sUPeR5cRip+";
$lang['subscript'] = "sUbScR1p+";
$lang['leftalign'] = "lEph+-AL19N";
$lang['center'] = "cEn+Er";
$lang['rightalign'] = "rIGhT-4li9n";
$lang['numberedlist'] = "nUmB3R3d LI5T";
$lang['list'] = "lIS+";
$lang['indenttext'] = "inDeN+ T3x+";
$lang['code'] = "cOdE";
$lang['quote'] = "qU0tE";
$lang['unquote'] = "unQU0+3";
$lang['spoiler'] = "spo1lEr";
$lang['horizontalrule'] = "hOrizoNt@l rUl3";
$lang['image'] = "im4G3";
$lang['hyperlink'] = "hYP3rl1nK";
$lang['noemoticons'] = "di$ABLe 3m0+1C0Ns";
$lang['fontface'] = "foNt F@ce";
$lang['size'] = "s1ZE";
$lang['colour'] = "c0L0ur";
$lang['red'] = "r3D";
$lang['orange'] = "oR@ngE";
$lang['yellow'] = "y3LLoW";
$lang['green'] = "gr3eN";
$lang['blue'] = "blue";
$lang['indigo'] = "iNdIg0";
$lang['violet'] = "viOLe+";
$lang['white'] = "whIte";
$lang['black'] = "bl4Ck";
$lang['grey'] = "grey";
$lang['pink'] = "p1NK";
$lang['lightgreen'] = "l1GHt 9R3en";
$lang['lightblue'] = "ligh+ 8lue";

// Forum Stats --------------------------------

$lang['forumstats'] = "f0Rum st@tS";
$lang['userstats'] = "uS3r S+@T$";

$lang['usersactiveinthepasttimeperiod'] = "%s 4ct1V3 1n +h3 P4$t %s. %s";

$lang['numactiveguests'] = "<b>%s</b> gUe$+$";
$lang['oneactiveguest'] = "<b>1</b> 9u3st";
$lang['numactivemembers'] = "<b>%s</b> M3mB3Rs";
$lang['oneactivemember'] = "<b>1</b> MEM8ER";
$lang['numactiveanonymousmembers'] = "<b>%s</b> @n0nyMOu$ MeM83r5";
$lang['oneactiveanonymousmember'] = "<b>1</b> 4NonyM0US m3M83R";

$lang['numthreadscreated'] = "<b>%s</b> THRE@D5";
$lang['onethreadcreated'] = "<b>1</b> tHR3@D";
$lang['numpostscreated'] = "<b>%s</b> poSTs";
$lang['onepostcreated'] = "<b>1</b> POS+";

$lang['younormal'] = "j00";
$lang['youinvisible'] = "j00 (1nv15I8l3)";
$lang['viewcompletelist'] = "v13w c0mpL3+3 L1s+";
$lang['ourmembershavemadeatotalofnumthreadsandnumposts'] = "oUR m3M83rs h4v3 m4d3 4 +ot4L oph %s 4nd %s.";
$lang['longestthreadisthreadnamewithnumposts'] = "lONg3ST +HR34D 1s <b>%s</b> W1+h %s.";
$lang['therehavebeenxpostsmadeinthelastsixtyminutes'] = "theR3 h@V3 83eN <b>%s</b> PoST5 M4DE in +3H l4S+ 60 M1NU+35.";
$lang['therehasbeenonepostmadeinthelastsxityminutes'] = "th3R3 h4s BE3N <b>1</b> PoS+ m@de in Th3 l4st 60 miNUTeS.";
$lang['mostpostsevermadeinasinglesixtyminuteperiodwasnumposts'] = "mos+ p0S+$ evER m4DE 1n 4 $IN9l3 60 MinuTe p3r10d 15 <b>%s</b> 0n %s.";
$lang['wehavenumregisteredmembersandthenewestmemberismembername'] = "wE h4V3 <b>%s</b> Re91$TEr3D MeM83RS 4nd TeH nEWEsT m3mb3r 1S <b>%s</b>.";
$lang['wehavenumregisteredmember'] = "wE h4v3 %s REgIs+eR3D mEmB3R5.";
$lang['wehaveoneregisteredmember'] = "we h@V3 oNE R391s+3RED MeM83R.";
$lang['mostuserseveronlinewasnumondate'] = "m0$+ uS3r$ 3ver oNline W@$ <b>%s</b> on %s.";
$lang['statsdisplaychanged'] = "s+@Ts d1Spl4y ch@n93d";

$lang['viewtop20'] = "vIeW ToP 20";

$lang['folderstats'] = "f0lDER $t4+5";
$lang['threadstats'] = "tHrE4D 5t4+S";
$lang['poststats'] = "pOS+ s+@+$";
$lang['pollstats'] = "polL 5t@+$";
$lang['attachmentsstats'] = "aT+4CHM3NTs s+4tS";
$lang['userpreferencesstats'] = "useR PR3FER3nCE$ 5+@+S";
$lang['visitorstats'] = "v1$1toR St4T5";
$lang['sessionstats'] = "s3SsI0n $t4ts";
$lang['profilestats'] = "pr0Fil3 $+4+S";
$lang['signaturestats'] = "s19n4+ur3 s+4tS";
$lang['ageandbirthdaystats'] = "a9e 4nd BIRTHD@Y 5+4T$";
$lang['relationshipstats'] = "rEL@ti0n5H1P S+4+S";
$lang['wordfilterstats'] = "w0Rd pH1LtER st@+5";

$lang['numberoffolders'] = "numBeR 0PH fOld3r5";
$lang['folderwithmostthreads'] = "f0Lder Wi+H m05+ Thre4dS";
$lang['folderwithmostposts'] = "fOLdER w1+h Mo5t p0s+$";
$lang['totalnumberofthreads'] = "t0T@l nuM83r 0f +HR3@dS";
$lang['longestthread'] = "l0n9E$t tHre4D";
$lang['mostreadthread'] = "m05+ r3@d +hre4D";
$lang['threadviews'] = "v1Ew$";
$lang['averagethreadcountperfolder'] = "aVeR493 THr34d c0UNT p3R ph0Lder";
$lang['totalnumberofthreadsubscriptions'] = "toT4L nuM8ER 0F THR34D Sub5Crip+1oN$";
$lang['mostpopularthreadbysubscription'] = "mO5+ pOpul4R tHR3ad 8y 5U8$cRIP+1On";
$lang['totalnumberofposts'] = "t0+@L number OPh Po$Ts";
$lang['numberofpostsmadeinlastsixtyminutes'] = "nuM83R oF PO$T$ M4dE in l4st 60 m1Nu+ES";
$lang['mostpostsmadeinasinglesixtyminuteperiod'] = "m0$+ p0S+$ m4DE in ONE 60 mInU+e p3R1Od";
$lang['averagepostsperuser'] = "av3r493 PO5+$ p3R US3R";
$lang['topposter'] = "t0p p0s+Er";
$lang['totalnumberofpolls'] = "tOt4L num8er 0ph p0Ll5";
$lang['totalnumberofpolloptions'] = "t0t4l NuM8ER oF PoLL oPt10n5";
$lang['averagevotesperpoll'] = "aveR93 v0tEs pER p0lL";
$lang['totalnumberofpollvotes'] = "tO+4l nUMb3R Oph POLL vo+3s";
$lang['totalnumberofattachments'] = "t0t4L NuM8er of 4+t4cHment5";
$lang['averagenumberofattachmentsperpost'] = "av3r4gE @t+4ChMENt COUN+ PeR p0st";
$lang['mostdownloadedattachment'] = "mOS+ d0wnLOad3D 4+t4CHmEnT";
$lang['mostusedforumstyle'] = "m05+ useD pHORuM $TYlE";
$lang['mostusedlanguuagefile'] = "m0$+ uS3d L4ngu493 f1l3";
$lang['mostusedtimezone'] = "mO5T u$3D +1MEzoNE";
$lang['mostusedemoticonpack'] = "m0$t u$3d 3Mo+1c0n P4Ck";

$lang['numberofusers'] = "nUMbeR 0f uS3RS";
$lang['newestuser'] = "nEWEs+ uSER";
$lang['numberofcontributingusers'] = "nuM83r Of coNTr18u+ING us3Rs";
$lang['numberofnoncontributingusers'] = "nUm83r 0F N0n-c0ntr1bu+ING u53Rs";
$lang['subscribers'] = "sU8scrIB3rS";

$lang['numberofvisitorstoday'] = "nUmBeR 0ph v1$iT0Rs +oD4y";
$lang['numberofvisitorsthisweek'] = "numB3R 0f VIS1TORs +hi$ W3EK (P3r10D: %s +0 %s)";
$lang['numberofvisitorsthismonth'] = "nuM8Er 0F vI$1t0r5 thIS mONth";
$lang['numberofvisitorsthisyear'] = "nUM83R 0f VI51T0rs th1$ ye@R";

$lang['totalnumberofactiveusers'] = "t0T4l numBer OF @cTIv3 uS3r$";
$lang['numberofactiveregisteredusers'] = "nUm8er oF 4CT1V3 r39iS+3ReD uS3rs";
$lang['numberofactiveguests'] = "nUMB3R of @C+iv3 gU3S+$";
$lang['mostuserseveronline'] = "m0$+ U53R$ 3VEr OnlIn3";
$lang['mostactiveuser'] = "m0$+ @ct1V3 u$3r";
$lang['numberofuserswithprofile'] = "nUM8ER Oph Us3Rs W1th pRopHile";
$lang['numberofuserswithoutprofile'] = "num8er opH u$erS wiTh0ut prOphil3";
$lang['numberofuserswithsignature'] = "nuMbeR OPh uS3rs wI+h $19N4+UrE";
$lang['numberofuserswithoutsignature'] = "number OF u53r5 w1th0u+ SIgN@tuR3";
$lang['averageage'] = "aV3ra93 @9e";
$lang['mostpopularbirthday'] = "mO$+ poPulaR B1rthDay";
$lang['nobirthdaydataavailable'] = "nO 8iR+hd4y d4+a 4V41l4bL3";
$lang['numberofusersusingwordfilter'] = "nUMB3R 0Ph usErS u$1n9 woRD f1lter";
$lang['numberofuserreleationships'] = "nUmB3R 0f uS3r RELE@t1ONsH1ps";
$lang['averageage'] = "aV3R@g3 49E";
$lang['averagerelationshipsperuser'] = "av3r493 rel4t1onship$ p3R uS3R";

$lang['numberofusersnotusingwordfilter'] = "nuM83R 0pH us3rs no+ u$1ng W0RD fil+3r";
$lang['averagewordfilterentriesperuser'] = "av3Rag3 word phiLT3R en+r1ES PeR u53r";

$lang['mostuserseveronlinedetail'] = "%s 0n %s";

// Thread Options (thread_options.php) ---------------------------------

$lang['updatessavedsuccessfully'] = "uPd@Te5 s4v3d suCCes5FulLy";
$lang['useroptions'] = "uSEr op+ioN$";
$lang['markedasread'] = "m4rkED @$ rEad";
$lang['postsoutof'] = "pOSTs ou+ 0F";
$lang['interest'] = "inT3rES+";
$lang['closedforposting'] = "clOSeD F0r POstIN9";
$lang['locktitleandfolder'] = "lOCk t1tL3 4nD folD3r";
$lang['deletepostsinthreadbyuser'] = "dEl3+e po$t5 1n +Hre4d 8y U53R";
$lang['deletethread'] = "del3te +HRE@D";
$lang['permenantlydelete'] = "p3rm4N3nTly delEtE";
$lang['movetodeleteditems'] = "m0Ve t0 dEL3t3D thRe4d$";
$lang['undeletethread'] = "undel3+3 thrE4d";
$lang['markasunread'] = "m4RK @s unr3ad";
$lang['makethreadsticky'] = "m4Ke thrE4d $+ICKy";
$lang['threareadstatusupdated'] = "thR34d ReaD sT4tu$ upd4+Ed sucCE$$PHully";
$lang['interestupdated'] = "tHr3@d iN+3R3s+ s+A+u$ UpD@+3D sucCes$phullY";
$lang['failedtoupdatethreadreadstatus'] = "f4il3D to upd4+E +hrE@D r3aD st4+US";
$lang['failedtoupdatethreadinterest'] = "f4IleD TO uPDa+3 +hr34d 1nt3re$+";
$lang['failedtorenamethread'] = "f4il3D +o r3n4mE thr34D";
$lang['failedtomovethread'] = "f41L3d +O m0V3 +hrE@D +0 SPeCIPH1ed pH0LDEr";
$lang['failedtoupdatethreadstickystatus'] = "fAilED T0 UPD4+e +HreAD st1cky $+@+u5";
$lang['failedtoupdatethreadclosedstatus'] = "f@il3D +O upd4t3 tHr34d cL053D 5t4+uS";
$lang['failedtoupdatethreadlockstatus'] = "f41LED TO Upd4te thrE4d l0CK staTu$";
$lang['failedtodeletepostsbyuser'] = "faILeD +0 d3lE+e p0S+S By SEl3ct3d u53r";
$lang['failedtodeletethread'] = "f@il3d to d3l3+3 Thr34d.";
$lang['failedtoundeletethread'] = "fa1LED t0 un-D3lE+E THR3@d";

// Folder Options (folder_options.php) ---------------------------------

$lang['folderoptions'] = "fOLDer OPT10N$";
$lang['foldercouldnotbefound'] = "teh r3que$+3D pholD3r C0ulD N0+ 83 Found OR @CC3sS w@S deNIeD.";
$lang['failedtoupdatefolderinterest'] = "f41leD to upDAtE ph0Ld3r inT3r3$t";

// Dictionary (dictionary.php) -----------------------------------------

$lang['dictionary'] = "dic+iON@rY";
$lang['spellcheck'] = "sP3lL cHECk";
$lang['notindictionary'] = "nO+ in dIC+10N4ry";
$lang['changeto'] = "chaN93 +0";
$lang['restartspellcheck'] = "rEST@r+";
$lang['cancelchanges'] = "cAnCel Ch4NgEs";
$lang['initialisingdotdotdot'] = "in1+i4lIs1N9...";
$lang['spellcheckcomplete'] = "sP3Ll CHECk is c0MpL3+E. TO RES+@rT sp3ll CHECk Cl1ck R3S+4rt 8ut+0n B3LOw.";
$lang['spellcheck'] = "sP3Ll ch3cK";
$lang['noformobj'] = "n0 forM 08j3C+ 5peCIPH1ED PhoR r3TuRn t3X+";
$lang['bodytext'] = "bODy +3X+";
$lang['ignore'] = "i9nOR3";
$lang['ignoreall'] = "ignor3 4LL";
$lang['change'] = "ch@ngE";
$lang['changeall'] = "ch@n93 aLL";
$lang['add'] = "add";
$lang['suggest'] = "sUg93S+";
$lang['nosuggestions'] = "(N0 $Ugg3s+1Ons)";
$lang['cancel'] = "c4nc3L";
$lang['dictionarynotinstalled'] = "n0 diC+I0N4ry h@s B3En 1N$T4lleD. Pl3453 Con+4C+ +hE foRum ownEr tO rEm3dY +h1s.";

// Permissions keys ----------------------------------------------------

$lang['postreadingallowed'] = "pO5t r34din9 4Ll0W3D";
$lang['postcreationallowed'] = "p0st cr3@T1On 4lLOweD";
$lang['threadcreationallowed'] = "tHreaD CrE@+10n @lLoweD";
$lang['posteditingallowed'] = "pOsT eDitING 4Ll0W3d";
$lang['postdeletionallowed'] = "pOs+ DeL3+iOn @ll0WED";
$lang['attachmentsallowed'] = "aTt4ChmEnts 4lL0wed";
$lang['htmlpostingallowed'] = "html p0$Tin9 4ll0weD";
$lang['signatureallowed'] = "s1Gn@TuRE 4lL0w3d";
$lang['guestaccessallowed'] = "gUe$+ @CC3s$ 4LlOw3D";
$lang['postapprovalrequired'] = "p0st apprOV@l r3QUiR3D";

// RSS feeds gubbins

$lang['rssfeed'] = "rSS f3ED";
$lang['every30mins'] = "eVEry 30 M1nu+3s";
$lang['onceanhour'] = "oNcE 4n hour";
$lang['every6hours'] = "eVery 6 hoUr5";
$lang['every12hours'] = "evEry 12 HoUr$";
$lang['onceaday'] = "oNce @ d4y";
$lang['onceaweek'] = "oNcE 4 WE3K";
$lang['rssfeeds'] = "rSs PH3Ed$";
$lang['feedname'] = "fE3D n@me";
$lang['feedfoldername'] = "fE3d pHold3R N4Me";
$lang['feedlocation'] = "feed L0c4+1oN";
$lang['threadtitleprefix'] = "thr34D +1tl3 pr3PH1x";
$lang['feednameandlocation'] = "fEED nam3 4nd lOC4+1oN";
$lang['feedsettings'] = "f3Ed S3t+1N9S";
$lang['updatefrequency'] = "uPD4+E phr3QueNCy";
$lang['rssclicktoreadarticle'] = "cL1Ck h3Re +O R3@D TH1S 4RT1Cle";
$lang['addnewfeed'] = "aDd New FE3D";
$lang['editfeed'] = "eDiT pH3ed";
$lang['feeduseraccount'] = "fe3D U$er 4ccoun+";
$lang['noexistingfeeds'] = "no eX1S+1N9 rsS PheeDS PhouNd. +0 4dd 4 fe3d CLick tHe '4dD neW' BU+Ton 83LOw";
$lang['rssfeedhelp'] = "h3rE j00 c4N S3+uP s0m3 rss fE3ds pH0r 4UtoM4+1c Pr0P4g4+1oN IN+0 your pHoRUM. t3H 1t3ms fROm +he r$S fe3d$ j00 adD Will Be CR34+3D 4$ +hr34ds whiCH U$Er$ C4N Reply t0 @s 1Ph Th3y W3r3 nORM4l pos+$. teH rs$ F33D mUs+ bE 4ccES51BLe vI@ H+tP oR 1t w1ll no+ worK.";
$lang['mustspecifyrssfeedname'] = "mU$t 5pecIFy RSs FEEd Nam3";
$lang['mustspecifyrssfeeduseraccount'] = "mUS+ $PeCIPhY rsS fE3d us3R 4cC0un+";
$lang['mustspecifyrssfeedfolder'] = "muST spEC1fY rss phE3d Ph0lD3R";
$lang['mustspecifyrssfeedurl'] = "mUS+ sPeC1fy rss Ph33d urL";
$lang['mustspecifyrssfeedupdatefrequency'] = "mu5T sp3C1PhY rS$ phe3d UpD4+e PHr3qUenCY";
$lang['unknownrssuseraccount'] = "unkn0wn r$$ U$3r @CC0un+";
$lang['rssfeedsupportshttpurlsonly'] = "rSs f33d supP0r+$ ht+p URl5 0Nly. $3Cur3 Phe3d5 (H++Ps://) @R3 nO+ SuPpor+3d.";
$lang['rssfeedurlformatinvalid'] = "rSS FE3D urL FORm@T 1s INV4l1D. url mu$T INclud3 sCheME (e.9. H+tP://) 4ND A H0$tn4M3 (E.g. wwW.h05+n4Me.cOM).";
$lang['rssfeeduserauthentication'] = "rS$ phEed D035 not SUPpORt ht+p u$er 4u+H3nt1c4T1ON";
$lang['successfullyremovedselectedfeeds'] = "sUCCE$sfulLy rEm0veD selECTed ph33ds";
$lang['successfullyaddedfeed'] = "succE5sphullY 4dD3d n3W f3Ed";
$lang['successfullyeditedfeed'] = "sUcCe5$fUllY 3d1+3d f3eD";
$lang['failedtoremovefeeds'] = "fa1LED +o rEM0Ve soM3 0r @LL 0ph th3 $3leC+3D f33D$";
$lang['failedtoaddnewrssfeed'] = "f@ilEd t0 4DD n3w r5$ pH33d";
$lang['failedtoupdaterssfeed'] = "f@ilED +0 uPD4t3 rss fE3d";
$lang['rssstreamworkingcorrectly'] = "r5$ $treaM 4Pp3@RS +o b3 W0RkIN9 corr3ctLY";
$lang['rssstreamnotworkingcorrectly'] = "rss sTRe4m w@$ eMP+y oR CouLd n0+ BE ph0UnD";
$lang['invalidfeedidorfeednotfound'] = "iNv4l1d fEeD iD or ph33D n0+ foUND";

// PM Export Options

$lang['pmexportastype'] = "export @S typE";
$lang['pmexporthtml'] = "html";
$lang['pmexportxml'] = "xml";
$lang['pmexportplaintext'] = "pL41n TExT";
$lang['pmexportmessagesas'] = "exPOrt ME5$4g3s @S";
$lang['pmexportonefileforallmessages'] = "oN3 Phil3 for @Ll me$$@9ES";
$lang['pmexportonefilepermessage'] = "oN3 pH1le PER ME5$4gE";
$lang['pmexportattachments'] = "eXPOR+ @tT@Chm3nt$";
$lang['pmexportincludestyle'] = "incLuDe pHorUm $+YLE sh3e+";
$lang['pmexportwordfilter'] = "apPlY wOrd f1L+3r t0 me$$@gE5";

// Thread merge / split options

$lang['threadhasbeensplit'] = "thr3aD ha$ b33n 5Pl1t";
$lang['threadhasbeenmerged'] = "tHr3@d HA$ B33n m3R9eD";
$lang['mergesplitthread'] = "merg3 / 5pl1+ +hr34D";
$lang['mergewiththreadid'] = "mERG3 W1+H +hr34d 1d:";
$lang['postsinthisthreadatstart'] = "poST5 1N tH15 ThR3Ad @t star+";
$lang['postsinthisthreadatend'] = "p05TS iN Th1$ +hrE4d a+ End";
$lang['reorderpostsintodateorder'] = "re-0rDeR Pos+s Int0 D@t3 orD3r";
$lang['splitthreadatpost'] = "sPlit thr34D @t p05+:";
$lang['selectedpostsandrepliesonly'] = "sEleC+3D P0$t 4ND rEpl1eS only";
$lang['selectedandallfollowingposts'] = "sElEct3d 4ND @ll pH0lloW1NG po$+$";

$lang['threadmovedhere'] = "here";

$lang['thisthreadhasmoved'] = "<b>tHR3ADS MEr93D:</b> th1S +hR34d H4$ m0VEd %s";
$lang['thisthreadwasmergedfrom'] = "<b>thRe@ds M3r93d:</b> tH1S tHr34d W4S meRg3D fr0m %s";
$lang['somepostsinthisthreadhavebeenmoved'] = "<b>tHr3@d splI+:</b> Some pOS+$ 1n thi5 tHRe4D H4v3 b3en m0V3d %s";
$lang['somepostsinthisthreadweremovedfrom'] = "<b>thr34D $plI+:</b> S0m3 pOs+s 1n th1s tHr34d w3re M0VEd phRoM %s";

$lang['thisposthasbeenmoved'] = "<b>thRE@d $pL1+:</b> th1$ po5t h4$ 83eN Mov3d %s";

$lang['invalidfunctionarguments'] = "iNV4lid phUnCT10n 4rguM3Nts";
$lang['couldnotretrieveforumdata'] = "c0uld no+ R3tri3v3 phorum D4+@";
$lang['cannotmergepolls'] = "on3 or MorE +hr34dS is A pOll. j00 c4nNOT m3rG3 PolLs";
$lang['couldnotretrievethreaddatamerge'] = "couLd nOt R3+rIeV3 tHR3@d D4T4 Fr0m oNe 0r morE +hr34Ds";
$lang['couldnotretrievethreaddatasplit'] = "cOuLD nO+ rE+rI3v3 +hR3ad D@+4 froM 5oUrCe +hrE4D";
$lang['couldnotretrievepostdatamerge'] = "coUlD N0T ReTr13Ve p0s+ D4T4 pHROm oN3 0R mOre +hr3@D$";
$lang['couldnotretrievepostdatasplit'] = "c0ULD No+ rEtr1evE pO$T D@+A PhR0M $0Urc3 +hR34D";
$lang['failedtocreatenewthreadformerge'] = "f4IL3D T0 Cr3@t3 n3w +HRE4d f0r m3r93";
$lang['failedtocreatenewthreadforsplit'] = "f41L3d T0 Cr34+3 n3w +Hr3AD for $PlIt";

// Thread subscriptions

$lang['threadsubscriptions'] = "tHRE@d $U8scR1pti0Ns";
$lang['couldnotupdateinterestonthread'] = "c0ulD no+ uPd@T3 1n+3rE$t 0n thRe4d '%s'";
$lang['threadinterestsupdatedsuccessfully'] = "thR3AD INt3restS uPdaT3d $Ucc3SsfUlly";
$lang['nothreadsubscriptions'] = "j00 ARe n0t 5UB5cr18ed t0 @nY +HR34d$.";
$lang['nothreadsignored'] = "j00 4R3 nO+ 19NoRin9 4NY THr3@d5.";
$lang['nothreadsonhighinterest'] = "j00 h4V3 N0 HI9h iN+3r3$+ +hre4D5.";
$lang['resetselected'] = "r353t SeL3ctED";
$lang['ignoredthreads'] = "ign0Red thr3@d$";
$lang['highinterestthreads'] = "hiGh 1n+3RE5t tHRe@d$";
$lang['subscribedthreads'] = "sUBsCRI83d thr3@d5";
$lang['currentinterest'] = "cURReN+ 1NT3reSt";

// Folder subscriptions

$lang['foldersubscriptions'] = "f0lDER suB5cR1p+10n$";
$lang['couldnotupdateinterestonfolder'] = "c0ULd n0t upD4+e InTErEst oN FOLdEr '%s'";
$lang['folderinterestsupdatedsuccessfully'] = "f0LDer int3r3S+s Upd4Ted $ucc3S5PHuLLy";
$lang['nofoldersubscriptions'] = "j00 @R3 not Su8ScribEd to 4ny fOld3rS.";
$lang['nofoldersignored'] = "j00 ar3 n0+ 19n0R1n9 4Ny ph0LD3rS.";
$lang['resetselected'] = "reS3+ S3l3Ct3d";
$lang['ignoredfolders'] = "i9N0r3D FOLD3RS";
$lang['subscribedfolders'] = "sU8scRIbEd FOld3r5";

// Browseable user profiles

$lang['youcanonlyaddthreecolumns'] = "j00 c4N 0NLY @dd 3 c0luMnS. +O 4Dd 4 n3w CoLUMN clO5e 4n ExIst1N9 oN3";
$lang['columnalreadyadded'] = "j00 hAvE @lR3AdY 4DD3D ThIs ColuMN. IpH J00 wANT tO R3M0V3 It cl1Ck iTs Cl0$e 8ut+ON";

?>