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

/* $Id$ */

// British English language file

// Language character set and text direction options -------------------

$lang['_isocode'] = "en-gb";
$lang['_textdir'] = "ltr";

// Months --------------------------------------------------------------

$lang['month'][1]  = "j4NUARy";
$lang['month'][2]  = "f3Bru4ry";
$lang['month'][3]  = "m@rch";
$lang['month'][4]  = "apRIL";
$lang['month'][5]  = "m@Y";
$lang['month'][6]  = "juN3";
$lang['month'][7]  = "jULy";
$lang['month'][8]  = "auGu\$+";
$lang['month'][9]  = "s3PtEMb3r";
$lang['month'][10] = "oCT08ER";
$lang['month'][11] = "n0V3mB3r";
$lang['month'][12] = "d3CEMb3R";

$lang['month_short'][1]  = "j4N";
$lang['month_short'][2]  = "fe8";
$lang['month_short'][3]  = "m4r";
$lang['month_short'][4]  = "apR";
$lang['month_short'][5]  = "m@y";
$lang['month_short'][6]  = "jUn";
$lang['month_short'][7]  = "jUL";
$lang['month_short'][8]  = "aUG";
$lang['month_short'][9]  = "s3p";
$lang['month_short'][10] = "oCt";
$lang['month_short'][11] = "n0V";
$lang['month_short'][12] = "deC";

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

$lang['date_periods']['year']   = "%s Ye4r";
$lang['date_periods']['month']  = "%s mOn+H";
$lang['date_periods']['week']   = "%s WE3k";
$lang['date_periods']['day']    = "%s DaY";
$lang['date_periods']['hour']   = "%s hOur";
$lang['date_periods']['minute'] = "%s m1NU+e";
$lang['date_periods']['second'] = "%s S3Cond";

// As above but plurals (2 years vs. 1 year, etc.)

$lang['date_periods_plural']['year']   = "%s Ye4rs";
$lang['date_periods_plural']['month']  = "%s M0N+H\$";
$lang['date_periods_plural']['week']   = "%s W3eks";
$lang['date_periods_plural']['day']    = "%s DAyS";
$lang['date_periods_plural']['hour']   = "%s H0UR5";
$lang['date_periods_plural']['minute'] = "%s MINU+e\$";
$lang['date_periods_plural']['second'] = "%s \$3CondS";

// Short hand periods (example: 1y, 2m, 3w, 4d, 5hr, 6min, 7sec)

$lang['date_periods_short']['year']   = "%sy";    // 1y
$lang['date_periods_short']['month']  = "%sm";    // 2m
$lang['date_periods_short']['week']   = "%sW";    // 3w
$lang['date_periods_short']['day']    = "%sD";    // 4d
$lang['date_periods_short']['hour']   = "%shR";   // 5hr
$lang['date_periods_short']['minute'] = "%sM1n";  // 6min
$lang['date_periods_short']['second'] = "%s53c";  // 7sec

// Common words --------------------------------------------------------

$lang['percent'] = "p3RcEnt";
$lang['average'] = "aV3r@93";
$lang['approve'] = "apPr0v3";
$lang['banned'] = "b4NN3D";
$lang['locked'] = "l0cK3d";
$lang['add'] = "adD";
$lang['advanced'] = "advAnC3d";
$lang['active'] = "acT1ve";
$lang['style'] = "sTyL3";
$lang['go'] = "g0";
$lang['folder'] = "fOLDer";
$lang['ignoredfolder'] = "igN0r3D FOLd3R";
$lang['subscribedfolder'] = "su8SCRIb3d Fold3R";
$lang['folders'] = "f0LDer\$";
$lang['thread'] = "thR34D";
$lang['threads'] = "thRE@d\$";
$lang['threadlist'] = "tHR34D LI\$t";
$lang['message'] = "m3\$s@93";
$lang['from'] = "fROm";
$lang['to'] = "t0";
$lang['all_caps'] = "all";
$lang['of'] = "opH";
$lang['reply'] = "r3ply";
$lang['forward'] = "foRw4rd";
$lang['replyall'] = "repLY T0 4lL";
$lang['quickreply'] = "quICk RePLY";
$lang['quickreplyall'] = "qUICk repLY +o All";
$lang['pm_reply'] = "rePly @\$ Pm";
$lang['delete'] = "d3L3t3";
$lang['deleted'] = "d3Le+3d";
$lang['edit'] = "eD1+";
$lang['export'] = "exp0R+";
$lang['privileges'] = "pR1vIl393S";
$lang['ignore'] = "i9NorE";
$lang['normal'] = "n0RM@l";
$lang['interested'] = "iNtER3\$t3d";
$lang['subscribe'] = "sUbSCri83";
$lang['apply'] = "apPly";
$lang['enable'] = "en48le";
$lang['download'] = "dOwNL0@d";
$lang['save'] = "s4VE";
$lang['update'] = "uPdA+3";
$lang['cancel'] = "c4nC3l";
$lang['continue'] = "cON+1nu3";
$lang['attachment'] = "att@chm3nt";
$lang['attachments'] = "a++4CHMEn+S";
$lang['imageattachments'] = "im4G3 @++4cHMentS";
$lang['filename'] = "f1Len4me";
$lang['dimensions'] = "d1M3NS10n5";
$lang['downloadedxtimes'] = "d0wNl04D3d: %d T1Me\$";
$lang['downloadedonetime'] = "doWnlO4D3D: 1 TIm3";
$lang['size'] = "sIZE";
$lang['viewmessage'] = "vIeW me\$S49E";
$lang['deletethumbnails'] = "d3Le+3 +hUM8n4Il\$";
$lang['logon'] = "lo9On";
$lang['more'] = "m0re";
$lang['recentvisitors'] = "reC3nt V1\$1+ORS";
$lang['username'] = "u\$3RN4ME";
$lang['clear'] = "cLe4r";
$lang['reset'] = "res3T";
$lang['action'] = "aCT1on";
$lang['unknown'] = "unkN0Wn";
$lang['none'] = "nOn3";
$lang['preview'] = "pr3vIEw";
$lang['post'] = "pOS+";
$lang['posts'] = "p0\$T\$";
$lang['change'] = "ch@Nge";
$lang['yes'] = "y3\$";
$lang['no'] = "nO";
$lang['signature'] = "sigNA+urE";
$lang['signaturepreview'] = "s19N4Ture pREviEW";
$lang['signatureupdated'] = "si9nA+UR3 UPD4teD";
$lang['signatureupdatedforallforums'] = "s19N4TUr3 uPD4+3D FOr ALl PH0ruMS";
$lang['back'] = "b4CK";
$lang['subject'] = "su8J3c+";
$lang['close'] = "cloS3";
$lang['name'] = "nAmE";
$lang['description'] = "deSCrIP+10N";
$lang['date'] = "d@+E";
$lang['view'] = "vI3W";
$lang['enterpasswd'] = "eNt3R p4sSword";
$lang['passwd'] = "p45\$woRD";
$lang['ignored'] = "i9n0red";
$lang['guest'] = "gUE5+";
$lang['next'] = "n3x+";
$lang['prev'] = "pRev10u\$";
$lang['others'] = "o+HERS";
$lang['nickname'] = "n1cKN4M3";
$lang['emailaddress'] = "eM41L 4dDr3\$S";
$lang['confirm'] = "coNph1RM";
$lang['email'] = "eM@1L";
$lang['poll'] = "p0ll";
$lang['friend'] = "fri3ND";
$lang['success'] = "succ3S\$";
$lang['error'] = "erR0R";
$lang['warning'] = "w4RNinG";
$lang['guesterror'] = "soRRY, j00 Ne3D TO 83 L0G93D 1n +o uSE Th1\$ PHe4+uRe.";
$lang['loginnow'] = "l0g1N n0W";
$lang['unread'] = "unRe4d";
$lang['all'] = "alL";
$lang['allcaps'] = "alL";
$lang['permissions'] = "pErm1ss10N5";
$lang['type'] = "tYP3";
$lang['print'] = "pRINt";
$lang['sticky'] = "sT1cky";
$lang['polls'] = "p0lL\$";
$lang['user'] = "uSER";
$lang['enabled'] = "eNa8l3d";
$lang['disabled'] = "d1s48L3D";
$lang['options'] = "oP+I0ns";
$lang['emoticons'] = "emO+icOns";
$lang['webtag'] = "w3b+49";
$lang['makedefault'] = "m4KE D3F4uL+";
$lang['unsetdefault'] = "uns3t deph4ult";
$lang['rename'] = "r3N4ME";
$lang['pages'] = "p@GES";
$lang['used'] = "u5Ed";
$lang['days'] = "d@Ys";
$lang['usage'] = "us4Ge";
$lang['show'] = "sH0w";
$lang['hint'] = "hInt";
$lang['new'] = "n3W";
$lang['referer'] = "rEpHEr3r";
$lang['thefollowingerrorswereencountered'] = "tHE phOLl0w1n9 erroRS Wer3 ENcOuN+3REd:";

// Admin interface (admin*.php) ----------------------------------------

$lang['admintools'] = "adMin t0OLS";
$lang['forummanagement'] = "fOrUM M4n493M3N+";
$lang['accessdeniedexp'] = "j00 D0 N0t H4VE pERM1\$\$10N to use +HI5 s3cti0n.";
$lang['managefolder'] = "m4N4ge FOld3r";
$lang['managefolders'] = "m4N@93 FOLdeRS";
$lang['manageforums'] = "m4n@93 f0ruMS";
$lang['manageforumpermissions'] = "m4n493 forUM permISsIOnS";
$lang['foldername'] = "fOLD3r N@m3";
$lang['move'] = "m0ve";
$lang['closed'] = "clOSEd";
$lang['open'] = "oP3N";
$lang['restricted'] = "r3StrICt3D";
$lang['forumiscurrentlyclosed'] = "%s 1\$ CURR3n+LY closed";
$lang['youdonothaveaccesstoforum'] = "j00 do Not h4v3 4CcE\$s +0 %s. %s";
$lang['toapplyforaccessplease'] = "t0 @PplY for 4cCes\$ PL3A\$3 c0n+@cT teh %s.";
$lang['forumowner'] = "fORUm Owner";
$lang['adminforumclosedtip'] = "iPh j00 w4N+ +O ChaN93 SOMe \$ETTin9s 0n Y0Ur f0rum cl1Ck +H3 4dmiN l1NK IN t3H n4v1g4ti0n 84r 480ve.";
$lang['newfolder'] = "neW FOld3r";
$lang['nofoldersfound'] = "no 3X1\$+ING pH0ldeRS ph0UNd. +O 4Dd 4 foLD3r cl1Ck THe '4Dd n3w' 8u+tON bEl0w.";
$lang['forumadmin'] = "f0Rum 4dmiN";
$lang['adminexp_1'] = "u\$e th3 menu on +Eh l3ph+ +0 MAn4gE +hiNGS IN YOUr f0ruM.";
$lang['adminexp_2'] = "<b>us3Rs</b> @LLoW\$ j00 +o \$e+ Individu4l u5er perM1sS1on5, 1ncLud1n9 4pp01N+inG MOdEr@T0Rs 4nd gaGGIn9 pe0ple.";
$lang['adminexp_3'] = "<b>uSEr 9roUPS</b> 4LLOW5 j00 t0 Cr3aTE UsEr groups T0 AssI9N p3rM1\$s10N\$ +0 @\$ m4nY oR 4s phew U\$3Rs qU1CKly 4nd e4\$iLy.";
$lang['adminexp_4'] = "<b>b@N c0nTrOls</b> 4ll0WS t3h 8@nn1nG 4nD UN-84nnIN9 of ip 4ddr3ss3s, hTTP rEph3RErS, Us3rN4Mes, Em41L @ddRE\$SeS ANd NIcKNAM3s.";
$lang['adminexp_5'] = "<b>fOLDER5</b> @LlOw\$ +hE CRE@T10n, M0Dif1c@+10N @nd d3let1On 0PH Folders.";
$lang['adminexp_6'] = "<b>rss ph3EDs</b> 4llOWS J00 +0 m4N4G3 rSS PH3ED5 fOR Pr0p@G4tI0n 1ntO YouR F0Rum.";
$lang['adminexp_7'] = "<b>pr0Philes</b> let5 j00 cu5+0mi53 Th3 i+3M5 +H4T 4pp3aR In +hE useR PRoF1L35.";
$lang['adminexp_8'] = "<b>f0Rum SE+TIn9s</b> 4LL0ws J00 TO cu\$T0m15E YoUR ph0rum'5 n4m3, @Ppe4r4ncE @ND M@nY O+h3r +hIN9S.";
$lang['adminexp_9'] = "<b>s+@r+ P@g3</b> LEts J00 cu\$t0MISE your phorum'5 \$+@r+ P@ge.";
$lang['adminexp_10'] = "<b>f0rum Style</b> 4lLOws J00 t0 93N3r@te RanD0m STyl3s For your fORum mem83R\$ +O use.";
$lang['adminexp_11'] = "<b>woRd ph1Lt3r</b> 4llOw5 j00 to PHilTEr w0rds J00 d0N'+ w@N+ T0 83 uSEd ON yOUr pH0ruM.";
$lang['adminexp_12'] = "<b>p0s+inG S+4t\$</b> gENer4t3s @ R3Por+ l1st1N9 +hE +op 10 poS+3rs In @ d3FiN3d P3ri0d.";
$lang['adminexp_13'] = "<b>f0Rum L1nkS</b> LET\$ j00 m@N@93 +h3 Links DroPd0wn In +Eh naV194+i0N B4R.";
$lang['adminexp_14'] = "<b>vI3W L0G</b> l1sT\$ r3cent @ctiONS BY The forum moder@T0rs.";
$lang['adminexp_15'] = "<b>m4n@g3 phorums</b> l3+S j00 Cr34+E 4nD D3L3t3 4Nd CloSE 0r reopen ph0Rum\$.";
$lang['adminexp_16'] = "<b>glOB@l Phorum seT+1n9s</b> 4LL0W\$ J00 +0 MOd1FY \$3++1ngs WhIch 4PHF3CT @lL phoRums.";
$lang['adminexp_17'] = "<b>po\$T @pPRov4l Qu3U3</b> AlLOws J00 +o vI3w 4ny pOS+s 4W41+in9 4ppr0v4l 8y a Mod3RA+0r.";
$lang['adminexp_18'] = "<b>vi\$1tor L0g</b> 4Ll0wS j00 +O v13W 4n ext3nD3D L1S+ 0f v1\$1+0r\$ 1ncLUD1n9 +h3ir Ht+p rEPh3ReRS.";
$lang['createforumstyle'] = "cR34+E 4 pH0RUm 5tylE";
$lang['newstylesuccessfullycreated'] = "n3W sTYl3 SUccE\$sphuLLY cR34TeD.";
$lang['stylealreadyexists'] = "a S+yle wi+H +h@T ph1LEnAM3 4lRE4Dy eX1\$T5.";
$lang['stylenofilename'] = "j00 D1D No+ 3n+eR @ PHilenaME +0 \$4V3 Th3 s+yl3 wITh.";
$lang['stylenodatasubmitted'] = "c0ulD noT r34d f0ruM \$TYL3 d4t4.";
$lang['stylecontrols'] = "coNTR0L\$";
$lang['stylecolourexp'] = "clicK on @ c0lOUr +0 Mak3 4 N3W stYL3 \$HEE+ B4sed 0n +H@T c0louR. curr3n+ B@se c0louR 15 ph1RST 1N l15+.";
$lang['standardstyle'] = "s+@ND4Rd stYLE";
$lang['rotelementstyle'] = "r0+4+ed elEmEnt \$Tyle";
$lang['randstyle'] = "r@nd0m sTYLE";
$lang['thiscolour'] = "tH1S C0lOUr";
$lang['enterhexcolour'] = "or Ent3r @ heX c0L0ur +0 b@\$3 @ NEw S+yl3 \$h3ET 0n";
$lang['savestyle'] = "s4V3 ThIs 5+yle";
$lang['styledesc'] = "s+yLE descr1pt10n";
$lang['stylefilenamemayonlycontain'] = "stYl3 fILen4M3 m@y 0nly cOnt@1n L0weRc@Se LE++3rs (4-z), nUm8erS (0-9) 4nD Under\$c0r3.";
$lang['stylepreview'] = "stYlE PREvi3w";
$lang['welcome'] = "welCOMe";
$lang['messagepreview'] = "m3S\$4g3 Previ3w";
$lang['users'] = "uS3RS";
$lang['usergroups'] = "u53R grOUP\$";
$lang['mustentergroupname'] = "j00 MU\$t ENt3r 4 Gr0up N4mE";
$lang['profiles'] = "pr0PH1l3\$";
$lang['manageforums'] = "mAn4G3 Ph0RumS";
$lang['forumsettings'] = "foRum 53++1n9s";
$lang['globalforumsettings'] = "gL0B@L fORum se+T1n9s";
$lang['settingsaffectallforumswarning'] = "<b>n0T3:</b> +he\$E \$e+TIngS @pHPHEC+ ALl PH0rumS. wH3r3 +H3 \$3+T1ng I\$ duPLic4+ed 0n tH3 ind1v1du@L forUM's \$E+T1N9S p@9E +ha+ Will T4K3 PR3c3d3NCe 0ver +He SE+t1N9\$ J00 Ch4N93 h3r3.";
$lang['startpage'] = "s+4RT p4ge";
$lang['startpageerror'] = "y0uR \$t@rt P4GE COUlD Not 83 S@V3d loc@Lly +O +h3 \$eRV3R 8eC@us3 PErm15si0n W4S DeNIeD.</p><p>t0 ch4n9e y0uR st4R+ p@9e PLe4SE CLIcK +eH d0wnlo@d BUT+0n 83LoW wHIcH Will pR0MPt j00 TO S4v3 +h3 pH1le To youR h4rD Dr1ve. J00 caN then uPL04D +HI5 f1l3 +O Y0Ur seRVEr In+0 +he PhOLL0W1N9 Phold3r, if N3ceSs@RY cr34tiNg +H3 f0ld3r S+ruCTUR3 in +H3 Pr0ce5\$.</p><p><b>%s</b></p><p>pLe4sE no+E Th4T s0me bR0wSERS maY ch4n9e T3h naM3 opH +h3 pH1lE uPon d0wNL0@d. Wh3N uPLO4D1N9 thE F1L3 Pl3ase MAke SUR3 +H4t 1+ is NAMed \$+@R+_mAIN.pHP O+HeRWISE yoUR S+@R+ p4GE WilL 4pP34r unCH4NGEd.";
$lang['uploadcssfile'] = "upl0@D c\$S sTYle 5H3E+";
$lang['uploadcssfilefailed'] = "yOUr CsS 5+yl3 sh3Et COUlD Not 83 uPLO@d3D to +h3 S3RvEr 83C4Use PeRm1\$sI0n w4s deNIeD.</p><p>t0 ch@Nge YOuR \$t@r+ P@gE C5S S+YLe SH3e+ pL34\$3 3nsur3 +h3 PH0ll0w1n9 ph0Ld3r\$ 3X1\$+ @nD Ar3 WRit@8le: </p><p><b>%s</b></p>";
$lang['invalidfiletypeerror'] = "inV@lid PHile +YPe, J00 c@n 0nLY upl04d cs5 \$Tyle sh3e+ PH1Les";
$lang['failedtoopenmasterstylesheet'] = "y0Ur ph0ruM s+Yle coULD n0+ 83 \$4V3d 83C@use th3 m4st3r STYLe \$H3E+ c0Uld n0T 83 L04DeD. +o saV3 youR \$TYLe +3h M45+eR S+YL3 sheet (M4ke_sTYl3.csS) MU\$T Be Loca+ed 1N THE style\$ DiR3ct0rY 0f y0ur 83ehiV3 Ph0RUm IN\$+4ll4+10N.";
$lang['makestyleerror'] = "y0Ur ForuM s+yl3 could nO+ b3 s4VEd lOC@Lly +0 tHE serveR 8eC4US3 permIss10n w4S d3Nied.</p><p>t0 \$4ve yoUR PH0ruM s+yle pLe4SE clicK +h3 doWNLO4d bu+T0N B3lOW Which WIll Pr0mpt J00 +0 \$4Ve +he f1LE tO y0uR H4rd Dr1ve. j00 can +H3N uPLO4d +HIS pHIle +O Y0UR S3RvER 1Nto T3h phoLlowIn9 fOlder, IF NEc3s\$4ry CR3A+1N9 +hE fOLd3r \$trUc+urE 1N +3H pr0CESS.</p><p><b>%s</b></p><p>ple4\$E nOt3 tH4T Som3 BR0W\$ERs MAY Ch4n93 +Eh n@m3 OpH +he Fil3 UpON D0WNl0@d. WHEN upLO4D1N9 tHE FiL3 PL34Se M@KE sur3 TH4+ i+ Is n@MEd S+yLe.cS\$ 0tHerw1\$3 +eh phOrum 5+YL3 WIll Be UNAV41LAblE.";
$lang['forumstyle'] = "f0RuM s+YLE";
$lang['wordfilter'] = "wOrD PhiL+er";
$lang['forumlinks'] = "f0rUM l1nkS";
$lang['viewlog'] = "vI3w LOg";
$lang['noprofilesectionspecified'] = "nO pr0ph1L3 53CtIOn 5p3c1f13d.";
$lang['itemname'] = "iteM N@ME";
$lang['moveto'] = "m0VE +O";
$lang['manageprofilesections'] = "m@N4G3 pr0PH1l3 sEC+10Ns";
$lang['sectionname'] = "sEctiOn n4me";
$lang['items'] = "itemS";
$lang['mustspecifyaprofilesectionid'] = "mu5+ \$Pecify 4 pR0F1Le S3ct10n 1d";
$lang['mustsepecifyaprofilesectionname'] = "mu\$+ sPEcifY 4 pROfiLE sec+ION n@me";
$lang['noprofilesectionsfound'] = "n0 exIs+1n9 PR0F1le \$EC+IonS f0UND. +O 4dD @ pr0FIle seCTioN CLick TEh '4Dd N3W' bUTt0n B3lOw.";
$lang['addnewprofilesection'] = "aDd N3w pROf1lE \$ECT10n";
$lang['successfullyaddedprofilesection'] = "suCCES\$FullY 4ddEd PR0fIL3 \$Ect1on";
$lang['successfullyeditedprofilesection'] = "sUCc3sSFullY edIT3d PRof1LE sEcti0n";
$lang['addnewprofilesection'] = "add n3W Pr0pH1LE \$Ec+10n";
$lang['mustsepecifyaprofilesectionname'] = "muSt SP3c1phy 4 PR0fil3 \$ECTI0n n4M3";
$lang['successfullyremovedselectedprofilesections'] = "suCCesSPhulLY R3M0Ved 5eLec+3d PR0f1l3 SECtIONS";
$lang['failedtoremoveprofilesections'] = "fa1l3D To r3M0Ve PR0F1l3 SECT1onS";
$lang['viewitems'] = "vI3w 1+emS";
$lang['successfullyaddednewprofileitem'] = "sUcc3S\$fully @DD3d n3W prOf1l3 I+3m";
$lang['successfullyeditedprofileitem'] = "sucCES5phUlly Ed1+ed PR0ph1le i+3m";
$lang['successfullyremovedselectedprofileitems'] = "suCCesSPhuLLy remoVEd S3L3c+3d ProFIle iT3M5";
$lang['failedtoremoveprofileitems'] = "f41led to R3M0V3 prOFil3 IT3m\$";
$lang['noexistingprofileitemsfound'] = "tHeR3 @r3 nO ex1S+1n9 pR0fiL3 It3m5 in +hiS \$eCt10N. +O add 4N 1Tem cLIck +eh '@dd n3w' BUT+0N 83L0w.";
$lang['edititem'] = "ed1T itEM";
$lang['invalidprofilesectionid'] = "iNV@l1D pROFIL3 5ect10n Id 0R S3ctiOn nO+ Ph0UND";
$lang['invalidprofileitemid'] = "iNval1D PR0f1le iT3M iD 0r 1TEM n0+ PH0und";
$lang['addnewitem'] = "add NEW i+EM";
$lang['youmustenteraprofileitemname'] = "j00 MU\$t Ent3r a PROFile 1+em N4ME";
$lang['invalidprofileitemtype'] = "iNV4lid Pr0fIL3 iTEm +yp3 \$eL3C+3D";
$lang['youmustenteroptionsforselectedprofileitemtype'] = "j00 MU5t En+3R 5Ome 0p+1oNS F0r SEl3c+3d prof1le i+3m TYpe";
$lang['youmustentermorethanoneoptionforitem'] = "j00 musT ENteR m0re Th4n oNE 0PTioN phOr 5el3c+ed proFile It3m +YPE";
$lang['profileitemhyperlinkssupportshttpurlsonly'] = "pr0ph1l3 It3M Hyp3rl1nk\$ Supp0r+ ht+P url5 0nLY";
$lang['profileitemhyperlinkformatinvalid'] = "pR0f1le IT3m hYPerlInk FORM@t Inv@LId";
$lang['youmustincludeprofileentryinhyperlinks'] = "j00 Mu5+ 1nclUDE <i>%s</i> In TEh url OPh CLick48Le HYp3rlINks";
$lang['failedtocreatenewprofileitem'] = "f@1l3d t0 cre@+3 nEW pr0Phil3 1+3M";
$lang['failedtoupdateprofileitem'] = "f4iLeD +o UPd@TE pr0FIl3 I+3m";
$lang['startpageupdated'] = "sT@Rt p49e upd4+ed. %s";
$lang['cssfileuploaded'] = "c\$s Style Sh33+ UPl04DEd. %s";
$lang['viewupdatedstartpage'] = "vi3w UPd4T3d 5+4r+ p4gE";
$lang['editstartpage'] = "eDIT st@R+ p4GE";
$lang['nouserspecified'] = "n0 useR SP3cified.";
$lang['manageuser'] = "m@N493 user";
$lang['manageusers'] = "m4n4ge US3Rs";
$lang['userstatusforforum'] = "us3R St@+uS PHor %s";
$lang['userdetails'] = "u53R d3+41l\$";
$lang['edituserdetails'] = "edi+ U\$ER dE+4Ils";
$lang['warning_caps'] = "w4rN1n9";
$lang['userdeleteallpostswarning'] = "ar3 J00 5URE j00 W4n+ +O D3L3T3 4ll 0PH +H3 \$El3ct3D User's pO\$t\$? 0nce T3h P0\$ts 4rE Del3t3d +H3Y caNNot 83 R3TRIEv3d 4nd w1LL 83 l0st For3V3r.";
$lang['folderaccess'] = "foLD3R 4cC3\$s";
$lang['possiblealiases'] = "p0\$S1bLe 4li4S3S";
$lang['ipaddressmatches'] = "iP ADdr3\$s m@+ches";
$lang['emailaddressmatches'] = "emaIL addRE\$S M4+CHE\$";
$lang['passwdmatches'] = "p@SsWOrd m@+Ch3S";
$lang['httpreferermatches'] = "hTTp r3F3R3r M4tches";
$lang['userhistory'] = "u\$Er h1sT0Ry";
$lang['nohistory'] = "nO h1stoRY RecoRd\$ \$4ved";
$lang['userhistorychanges'] = "ch@nges";
$lang['clearuserhistory'] = "cL3@R US3r H1\$TorY";
$lang['changedlogonfromto'] = "ch4N93D LOgoN phROM %s to %s";
$lang['changednicknamefromto'] = "cH4nged n1cKN@m3 Phr0m %s +O %s";
$lang['changedemailfromto'] = "cH4n93D eM4Il FRom %s +o %s";
$lang['successfullycleareduserhistory'] = "sUCcES\$PhULLy cl34r3D uSEr hIstoRY";
$lang['failedtoclearuserhistory'] = "f@Il3D +O CL34r U\$eR hIs+0ry";
$lang['successfullychangedpassword'] = "sucCEssPHulLY cH4N93D p4sSWORd";
$lang['failedtochangepasswd'] = "f4Il3d +O Ch@NgE P4\$SW0RD";
$lang['approveuser'] = "aPpROV3 Us3r";
$lang['viewuserhistory'] = "v1ew us3r H15+Ory";
$lang['viewuseraliases'] = "v1Ew u\$eR 4lIa\$e5";
$lang['searchreturnednoresults'] = "se4RCh r3+Urn3D N0 R3\$UL+S";
$lang['deleteposts'] = "d3le+E pOst\$";
$lang['deleteuser'] = "d3le+e useR";
$lang['alsodeleteusercontent'] = "aLS0 d3lE+3 4LL OF th3 c0N+3nT CreA+3d 8Y Th1\$ u5Er";
$lang['userdeletewarning'] = "aR3 j00 suR3 J00 W4nt +O dEle+3 Teh SEl3CteD uSeR 4cC0unt? ONCe +eh accoun+ H4s B3EN D3L3t3D 1+ cANnoT 83 re+rIEv3d and W1ll be LOsT phoREver.";
$lang['usersuccessfullydeleted'] = "u53R succ3SsPHulLY D3L3T3d";
$lang['failedtodeleteuser'] = "f@Il3d tO d3l3+3 user";
$lang['forgottenpassworddesc'] = "iF +his USEr h@s PH0r90++En the1R P@s\$wORd j00 C4n RESe+ I+ f0r tH3M heR3.";
$lang['failedtoupdateuserstatus'] = "f@Il3d TO upd4t3 USEr St@tU\$";
$lang['failedtoupdateglobaluserpermissions'] = "f@iL3D To upd4+e global uSer P3rmisS10NS";
$lang['failedtoupdatefolderaccesssettings'] = "f@il3D to Upd4+3 phOLd3r @cC3Ss SE+T1n9\$";
$lang['manageusersexp'] = "th1s l1s+ sh0W\$ 4 sel3CT1on OF UseR\$ who have l09gED on +0 y0UR F0Rum, soRT3d bY %s. TO 4L+3r 4 U\$er'S P3rm1\$SI0n5 clicK +h31r N4ME.";
$lang['userfilter'] = "u\$3r PH1l+Er";
$lang['withselected'] = "wiTh 5EL3cted";
$lang['onlineusers'] = "onlIn3 U\$Ers";
$lang['offlineusers'] = "oPhflINe uS3R5";
$lang['usersawaitingapproval'] = "u53rs @w4itIN9 4PPR0vAL";
$lang['bannedusers'] = "b4NN3d u\$3r\$";
$lang['lastlogon'] = "l@St lO90n";
$lang['sessionreferer'] = "sESS10N Reph3R3r";
$lang['signupreferer'] = "sIGn-uP REpHer3r:";
$lang['nouseraccountsmatchingfilter'] = "nO usEr 4cc0Un+5 M4+CHin9 phiL+3r";
$lang['searchforusernotinlist'] = "sEARcH F0r 4 u\$ER NOT iN l1\$t";
$lang['adminaccesslog'] = "adm1n @cce\$s l09";
$lang['adminlogexp'] = "th1\$ LIS+ Sh0W\$ +3H la\$T Act1ONS \$4NCti0n3D by u\$3r\$ w1Th admiN PR1V1L39E5.";
$lang['datetime'] = "d@+E/+1ME";
$lang['unknownuser'] = "uNKn0wn U\$eR";
$lang['unknownuseraccount'] = "unKn0wn Us3r @cCount";
$lang['unknownfolder'] = "unkn0WN f0LdER";
$lang['ip'] = "iP";
$lang['lastipaddress'] = "l4ST 1p 4ddr3sS";
$lang['logged'] = "l0G93D";
$lang['notlogged'] = "no+ l0g9eD";
$lang['addwordfilter'] = "add wOrd f1l+eR";
$lang['addnewwordfilter'] = "aDd N3W wORd f1LT3r";
$lang['wordfilterupdated'] = "w0rD philtER upd4+ed";
$lang['wordfilterisfull'] = "j00 c@NNo+ 4dd anY m0r3 W0rd Filt3r5. removE 5OMe Unus3d Ones 0r 3dI+ +3H eXIST1Ng on3\$ fir\$t.";
$lang['filtername'] = "fILt3R N4me";
$lang['filtertype'] = "f1lTeR TyPE";
$lang['filterenabled'] = "fILteR En48LEd";
$lang['editwordfilter'] = "eD1+ WOrd pH1LTer";
$lang['nowordfilterentriesfound'] = "n0 ex1s+inG w0rd phil+Er 3n+R1Es F0UND. +o @Dd 4 PH1lt3r CL1ck +Eh '4dd nEw' 8utTOn 83Low.";
$lang['mustspecifyfiltername'] = "j00 mus+ Sp3C1Fy @ phILTeR N4m3";
$lang['mustspecifymatchedtext'] = "j00 MUsT sP3c1phy M4+ched texT";
$lang['mustspecifyfilteroption'] = "j00 musT sp3cify @ ph1lt3r OP+iON";
$lang['mustspecifyfilterid'] = "j00 muS+ sP3c1fy @ fILtER id";
$lang['invalidfilterid'] = "inval1D F1LT3R id";
$lang['failedtoupdatewordfilter'] = "fAIl3d tO uPd4+3 wORd f1lt3R. ch3Ck TH4+ +H3 PHiLteR s+ill 3X1\$T5.";
$lang['allow'] = "alL0W";
$lang['block'] = "blOCk";
$lang['normalthreadsonly'] = "n0Rm@l Thre@D5 0Nly";
$lang['pollthreadsonly'] = "pOLL +HReaD\$ 0nly";
$lang['both'] = "bO+H +hre@d +YPes";
$lang['existingpermissions'] = "exISTinG pErM1ss10ns";
$lang['nousershavebeengrantedpermission'] = "no 3X1\$+iNg u\$erS P3RM1Ss10n\$ fOUnd. +0 gr4N+ P3rm1\$\$ion +0 USErs se@rch f0r +H3M 83lOW.";
$lang['successfullyaddedpermissionsforselectedusers'] = "succEs\$FUlLY 4ddEd p3rm1\$s10N\$ phOR s3lec+ed useRS";
$lang['successfullyremovedpermissionsfromselectedusers'] = "sUCc3SsphullY rem0V3d PErmISs10ns From SeL3C+3D us3R\$";
$lang['failedtoaddpermissionsforuser'] = "fA1l3d T0 4Dd PErm15\$1ons For U5Er '%s'";
$lang['failedtoremovepermissionsfromuser'] = "f@1LEd TO R3m0vE permIs51Ons Fr0M user '%s'";
$lang['searchforuser'] = "se4rch fOr U\$Er";
$lang['browsernegotiation'] = "brOw\$eR N39o+14t3d";
$lang['textfield'] = "teXt PH13ld";
$lang['multilinetextfield'] = "mULti-LIn3 TExt PHiEld";
$lang['radiobuttons'] = "r4d1O bu++0n\$";
$lang['dropdownlist'] = "dRoP d0wn lIST";
$lang['clickablehyperlink'] = "cliCk@Bl3 HYperLInk";
$lang['threadcount'] = "tHr34d couN+";
$lang['clicktoeditfolder'] = "cLICk +O 3D1+ FolD3R";
$lang['fieldtypeexample1'] = "t0 cR3@+3 r4d1o but+0n\$ or @ DroP d0WN L1ST j00 ne3d to 3N+er each 1nD1v1Du@L v@lu3 0n @ 5ep4R4te L1NE IN +he Op+1onS f13ld.";
$lang['fieldtypeexample2'] = "t0 Cr34+e cl1ck48lE L1NKS 3nt3r +h3 Url in +h3 op+10n\$ pH13Ld @nd u\$e <i>%1\$s</i> WHer3 +eH enTry frOm tH3 u\$3r'\$ proF1LE SHouLD 4pp34R. exaMPlES: <p>mYSP4c3: <i>ht+p://Www.MY5P@Ce.c0M/%1\$s</i><br />x80x L1v3: <i>hT+p://PROF1l3.myg4M3rc@Rd.N3+/%1\$\$</i></p>";
$lang['editedwordfilter'] = "edIteD Word f1lteR";
$lang['editedforumsettings'] = "eDI+eD fORum S3T+1n9\$";
$lang['successfullyendedusersessionsforselectedusers'] = "sUCc3s5fully 3nD3D SE\$s1oNs for sel3c+ed useRS";
$lang['failedtoendsessionforuser'] = "fA1LED +O end \$3\$S10n pHOR u\$Er %s";
$lang['successfullyapproveduser'] = "sUcC3\$\$fulLy 4ppROved user";
$lang['successfullyapprovedselectedusers'] = "sUCC3s\$fully @pPr0V3D sel3cT3d uSeR\$";
$lang['matchedtext'] = "m4tched text";
$lang['replacementtext'] = "r3PL4Cement TexT";
$lang['preg'] = "preG";
$lang['wholeword'] = "wh0le wORd";
$lang['word_filter_help_1'] = "<b>aLL</b> M@+che5 @94in\$+ +he WH0le TExt S0 ph1lterinG m0M +o MUm wilL 4Lso Chan93 MoM3nT +o MUmen+.";
$lang['word_filter_help_2'] = "<b>wholE W0Rd</b> M4tche\$ A94inSt WH0le WOrD\$ oNly \$O FilT3Ring M0M +0 mum Will n0+ ch4n9e m0m3n+ +o MUmen+.";
$lang['word_filter_help_3'] = "<b>pRe9</b> 4LL0w\$ j00 +o u\$e perl R39ul@R eXPr3s\$1on\$ +0 m4+ch T3XT.";
$lang['nameanddesc'] = "n@M3 4ND D35Cr1ptIOn";
$lang['movethreads'] = "m0v3 +hr34DS";
$lang['movethreadstofolder'] = "m0v3 tHR3ad\$ +O foLD3r";
$lang['failedtomovethreads'] = "f41LEd T0 M0V3 thR34D\$ +0 \$P3C1f13d F0ld3R";
$lang['resetuserpermissions'] = "rES3T u5er PerMIS510n\$";
$lang['failedtoresetuserpermissions'] = "f@1leD t0 r3SEt useR p3RMI5s10n\$";
$lang['allowfoldertocontain'] = "alLOW f0LD3r +O coNTaiN";
$lang['addnewfolder'] = "aDd N3w Fold3R";
$lang['mustenterfoldername'] = "j00 Mu\$T 3N+3r 4 pH0ld3R n4m3";
$lang['nofolderidspecified'] = "no FOLd3r 1D sp3CIFiEd";
$lang['invalidfolderid'] = "iNV4lid f0ld3R Id. ch3CK TH@+ a Fold3r W1+h +H1S id 3xiS+s!";
$lang['folderdisplayorderthreadsbyfolderview'] = "foLder orD3r 0nLy 4PPl13s WH3N uS3R h45 3n48led '\$ORT Thread L1\$+ bY F0LDeRS' 1n F0rUM OptIOnS.";
$lang['successfullyaddednewfolder'] = "sUCcESSpHUlLY 4DdeD n3W Folder";
$lang['successfullyremovedselectedfolders'] = "succesSphully Rem0v3d Sel3C+3d F0ld3RS";
$lang['successfullyeditedfolder'] = "suCCE\$\$phuLly 3d1+3d foLDEr";
$lang['failedtocreatenewfolder'] = "f@1leD TO cr34+3 n3w pHOld3r";
$lang['failedtodeletefolder'] = "f41lEd to d3le+E PhoLd3r.";
$lang['failedtoupdatefolder'] = "f4Il3d +o upD4+3 Ph0Ld3r";
$lang['cannotdeletefolderwiththreads'] = "c@nnOt deL3+E fOld3r\$ +H4T St1lL con+@1n +hR3ADS.";
$lang['forumisnotsettorestrictedmode'] = "f0rUM 1\$ noT s3+ TO rESTR1c+3d m0De. Do j00 W@n+ +0 3n@8le IT nOW?";
$lang['forumisnotsettopasswordprotectedmode'] = "f0RuM i5 NO+ 5et +0 p4\$sw0rd pr0TeC+ed M0dE. d0 J00 wAnT tO en4Ble 1+ N0w?";
$lang['groups'] = "gR0UP\$";
$lang['nousergroups'] = "n0 u5er 9ROuP5 h@v3 8E3n SE+ uP. +0 4dd 4 9RouP cL1Ck +H3 '@dd n3w' bu++oN b3l0W.";
$lang['suppliedgidisnotausergroup'] = "suPpl1ed 9Id 1\$ n0t @ u\$eR GrouP";
$lang['manageusergroups'] = "m4N@93 USEr 9r0ups";
$lang['groupstatus'] = "grOuP S+4+uS";
$lang['addusergroup'] = "add U\$eR 9rouP";
$lang['addemptygroup'] = "aDD emP+Y gr0up";
$lang['adduserstogroup'] = "adD UsER\$ TO gr0up";
$lang['addremoveusers'] = "aDd/R3m0ve u\$ERS";
$lang['nousersingroup'] = "theR3 @r3 no U5ERS IN thI\$ 9ROUp. @Dd users T0 +His 9rOUp 8Y \$3@rCHIng PH0r tHEm b3l0w.";
$lang['groupaddedaddnewuser'] = "sUCce\$sfully 4dd3d grOUp. 4dD UserS t0 TH1S 9roup 8y sE@rchiN9 PH0R th3m 8elOW.";
$lang['nousersingroupaddusers'] = "thErE @r3 n0 uS3RS 1N th1s 9roUP. TO 4dD UseRS cLIcK +h3 '@Dd/rEM0V3 useRs' 8UT+0N 83l0w.";
$lang['useringroups'] = "tH1\$ user 1\$ 4 mem8Er Of +eh PH0Ll0w1ng gRouPS";
$lang['usernotinanygroups'] = "th1s UseR 1\$ no+ 1N @ny U\$Er 9r0uP\$";
$lang['usergroupwarning'] = "no+E: ThiS usEr MAY Be INh3RIT1n9 4Ddit1on@L P3RM15\$1onS frOM @ny U\$Er Group\$ lisT3d 8ELOW.";
$lang['successfullyaddedgroup'] = "sUcCesSfULLy @DDed 9rOup";
$lang['successfullyeditedgroup'] = "succesSphULLy 3DITED 9r0UP";
$lang['successfullydeletedselectedgroups'] = "sUCC35sPHULly D3L3+3D Selec+3d Gr0UP\$";
$lang['failedtodeletegroupname'] = "f41led TO d3L3+3 9rOUP %s";
$lang['usercanaccessforumtools'] = "uSEr c4N 4cC3sS forum To0ls 4nd C@n cre@t3, dEL3+3 @Nd EDIt foRUms";
$lang['usercanmodallfoldersonallforums'] = "u53R c@n m0d3ra+e <b>all F0LD3r5</b> 0N <b>alL forUMs</b>";
$lang['usercanmodlinkssectiononallforums'] = "uS3r C4N m0der4t3 linkS SeCTion on <b>all f0rumS</b>";
$lang['emailconfirmationrequired'] = "em4IL C0npH1rM4+10N rEqUIR3D";
$lang['userisbannedfromallforums'] = "us3R 1S b@NNed PHr0m <b>aLl phoRUm\$</b>";
$lang['cancelemailconfirmation'] = "c4NCel eM41l C0NPH1rm4tI0n ANd @ll0w uSEr t0 \$+4rt POs+1N9";
$lang['resendconfirmationemail'] = "r353nd ConPHirm@+1On 3m@1L +0 u\$eR";
$lang['failedtosresendemailconfirmation'] = "f4Iled TO r3\$eNd 3m4iL c0NF1RM4Ti0n +o us3R.";
$lang['donothing'] = "dO n0+H1N9";
$lang['usercanaccessadmintools'] = "uS3r H@s 4cc3ss To F0ruM 4dmiN to0l\$";
$lang['usercanaccessadmintoolsonallforums'] = "u53r HA\$ @ccEs5 T0 4DmIn +o0lS <b>on 4Ll F0RUm\$</b>";
$lang['usercanmoderateallfolders'] = "u\$3R c4N m0dEr4te 4lL ph0lD3R\$";
$lang['usercanmoderatelinkssection'] = "uS3r C4N MoDer4+e l1Nks secTIOn";
$lang['userisbanned'] = "uS3r 1\$ b4nNED";
$lang['useriswormed'] = "uSER i5 W0rmeD";
$lang['userispilloried'] = "u5eR 15 p1ll0RIeD";
$lang['usercanignoreadmin'] = "u53R c4n Ign0r3 4dminIs+R4tOR\$";
$lang['groupcanaccessadmintools'] = "gR0up cAn 4ccE\$S @dmIn To0l\$";
$lang['groupcanmoderateallfolders'] = "gr0uP c4N moderA+e 4lL f0lDERs";
$lang['groupcanmoderatelinkssection'] = "gr0up C@n Mod3r@tE l1nk5 5ect10ns";
$lang['groupisbanned'] = "gROup 1s 8@nNEd";
$lang['groupiswormed'] = "gRoUp 1s w0Rm3D";
$lang['readposts'] = "r3@d PO5+s";
$lang['replytothreads'] = "rEpLY +0 THRe4DS";
$lang['createnewthreads'] = "cRe4+e neW +hRE4Ds";
$lang['editposts'] = "edI+ PO\$TS";
$lang['deleteposts'] = "d3le+E p0\$t\$";
$lang['postssuccessfullydeleted'] = "p0\$+\$ w3r3 5ucc3S5phullY d3Le+ed";
$lang['failedtodeleteusersposts'] = "fAIL3D To d3l3t3 u\$er'S poS+S";
$lang['uploadattachments'] = "uPl0@d A++4Chm3ntS";
$lang['moderatefolder'] = "mod3R@+3 foLDer";
$lang['postinhtml'] = "poS+ 1n HTMl";
$lang['postasignature'] = "poS+ 4 \$19nA+UrE";
$lang['editforumlinks'] = "eD1T phORum L1Nk\$";
$lang['linksaddedhereappearindropdown'] = "link\$ 4DD3D HEre @pp3@r 1n @ DroP DOWn In tH3 Top ri9ht 0F +hE phr4Me se+.";
$lang['linksaddedhereappearindropdownaddnew'] = "l1NkS @DD3d h3re 4PP34r iN 4 DROp d0wn IN teh +0P r1ght OF +eH fr4me \$e+. +o 4Dd a L1nk cl1Ck +H3 '@dD N3W' but+0n 83LOW.";
$lang['failedtoremoveforumlink'] = "f4Il3d +0 reMOve Phorum L1nK '%s'";
$lang['failedtoaddnewforumlink'] = "f4Il3d tO @dd n3w forum liNK '%s'";
$lang['failedtoupdateforumlink'] = "f4Il3d +0 upda+3 PHorum l1NK '%s'";
$lang['notoplevellinktitlespecified'] = "n0 T0P lev3l l1nk +ITle sP3c1PH1eD";
$lang['youmustenteralinktitle'] = "j00 musT eN+3r A l1nk +1+l3";
$lang['alllinkurismuststartwithaschema'] = "alL l1nk UR1\$ mUS+ S+4rt W1+h A sch3m@ (1.3. h+TP://, f+P://, irC://)";
$lang['editlink'] = "eDIT l1NK";
$lang['addnewforumlink'] = "aDd N3W ph0rum L1nk";
$lang['forumlinktitle'] = "foRUm LInK +1+l3";
$lang['forumlinklocation'] = "fORUM l1nk l0c4Ti0n";
$lang['successfullyaddednewforumlink'] = "sUccES5FullY 4DDEd new ph0rum LInK";
$lang['successfullyeditedforumlink'] = "sucCES\$FulLY 3D1+ed foRUm L1NK";
$lang['invalidlinkidorlinknotfound'] = "iNV4l1d LiNk 1D Or LINK N0t fOUnD";
$lang['successfullyremovedselectedforumlinks'] = "suCc3sSPhulLY rem0v3d SElEct3D LinkS";
$lang['toplinkcaption'] = "t0p l1Nk caPT10N";
$lang['allowguestaccess'] = "aLlOw 9ue\$T 4Cc3\$S";
$lang['searchenginespidering'] = "se4RCh enG1NE \$PiderINg";
$lang['allowsearchenginespidering'] = "aLLoW se@RCh eN9In3 \$pIderiN9";
$lang['showsearchenginebotsinvisitors'] = "sHoW SE4rch 3n9IN3 b0t\$ 1n v1\$1+0r L09";
$lang['showsearchenginebotsinactiveusers'] = "sHOw seArch ENG1ne 8O+\$ in 4C+1VE USErS";
$lang['sitemapenabled'] = "en@8L3 s1+em4p";
$lang['sitemapupdatefrequency'] = "sI+emaP UPd4te fR3QUency";
$lang['sitemappathnotwritable'] = "s1t3M4P D1r3C+ORy MUst 83 wR1+48LE 8y t3h wEb SeRVer / PHp proC3\$S!";
$lang['newuserregistrations'] = "nEw Us3R regi5+R4T1oNs";
$lang['preventduplicateemailaddresses'] = "preVeN+ Duplic4T3 3m41l 4Ddr3\$ses";
$lang['allownewuserregistrations'] = "aLloW N3w U\$eR reg1\$+R@tiONS";
$lang['requireemailconfirmation'] = "r3Qu1re 3maiL Confirm@t10n";
$lang['usetextcaptcha'] = "uS3 +eXT-cAPtch4";
$lang['textcaptchafonterror'] = "teXt-C4ptCH4 h@s B3EN dIS@bL3D @u+0m@+ic4LLY 83C4us3 +H3R3 ar3 NO tru3 typE FoNT\$ av4il48l3 pH0R it T0 us3. Pleas3 uPLo4D \$0me TrUE tYPe F0N+S tO <b>t3Xt_c4PTcH4/PH0n+S</b> 0N yOur \$eRV3r.";
$lang['textcaptchadirerror'] = "tEXt-c@pTCh4 HAs 833N disablEd 83C4uS3 the +exT_c4ptch4 direcT0ry ANd iT's \$UB-d1reC+0rIES @re nOT wRIt48L3 8Y T3H W38 seRVeR / Php Pr0cE5\$.";
$lang['textcaptchagderror'] = "t3X+-captCH4 H@s B3EN diSABl3D beC@u\$E y0ur s3rver'5 pHP s3TUP d0ES no+ pr0vIdE SUppOR+ fOR 9d 1m4g3 m@nIPul4TI0n 4ND / Or TTf f0N+ suPPoRT. botH 4RE rEquIr3D foR +eXT-C4ptch4 SUpp0rt.";
$lang['newuserpreferences'] = "nEW uSeR pR3f3REnces";
$lang['sendemailnotificationonreply'] = "eM@1L n0+iphica+1ON 0n REpLy tO u\$er";
$lang['sendemailnotificationonpm'] = "em4il n0+1pHIc4ti0n 0n Pm TO U5Er";
$lang['showpopuponnewpm'] = "sHow p0Pup When rec31v1n9 n3w pM";
$lang['setautomatichighinterestonpost'] = "s3+ @ut0m4t1C hi9h in+3rE\$t 0n PO5+";
$lang['postingstats'] = "poS+1N9 St@+\$";
$lang['postingstatsforperiod'] = "pO\$tiNg s+4+S f0r PEriod %s TO %s";
$lang['nopostdatarecordedforthisperiod'] = "n0 Pos+ D@+4 record3D FOr +H1\$ p3rIOd.";
$lang['totalposts'] = "toT4L p0S+S";
$lang['totalpostsforthisperiod'] = "tO+4l P05+S ph0r THIs period";
$lang['mustchooseastartday'] = "mU\$+ cho0SE @ \$t4R+ d4Y";
$lang['mustchooseastartmonth'] = "mU\$+ CH0Ose @ \$+@R+ M0n+h";
$lang['mustchooseastartyear'] = "muS+ ChO0\$E 4 s+@r+ YE4r";
$lang['mustchooseaendday'] = "mu\$+ ch0oSE @n end D4y";
$lang['mustchooseaendmonth'] = "mu\$+ CH0Os3 4N 3ND m0nTH";
$lang['mustchooseaendyear'] = "mUS+ Ch00sE 4n 3Nd y3@r";
$lang['startperiodisaheadofendperiod'] = "s+4R+ p3RI0d 1\$ 4h34D of 3nd P3rIOd";
$lang['bancontrols'] = "b4N c0n+rOL5";
$lang['addban'] = "add 8@n";
$lang['checkban'] = "ch3ck B@n";
$lang['editban'] = "ediT 8@n";
$lang['bantype'] = "bAN +Ype";
$lang['bandata'] = "b4n D4t@";
$lang['banexpires'] = "ban 3xPIR3S";
$lang['bancomment'] = "c0mM3nt";
$lang['optionalbrackets'] = "(oP+1oNAl)";
$lang['ipban'] = "iP 84N";
$lang['logonban'] = "l0GoN B4n";
$lang['nicknameban'] = "n1CKn@Me b@N";
$lang['emailban'] = "em@1l b@N";
$lang['refererban'] = "rEPHer3R B@N";
$lang['invalidbanid'] = "iNv@LId 8@N id";
$lang['affectsessionwarnadd'] = "this 84n maY aphph3ct th3 foLl0w1Ng aC+1Ve uSEr S3SS10ns";
$lang['noaffectsessionwarn'] = "th15 8@n 4PHf3CTS N0 4ctiV3 S3ss1on\$";
$lang['mustspecifybantype'] = "j00 MuS+ \$pecify A 8aN +YP3";
$lang['mustspecifybandata'] = "j00 MU5T Sp3c1PHy somE 8@n d4t4";
$lang['expirydateisinvalid'] = "eXp1ry d4+e 1S 1nv4L1D";
$lang['successfullyremovedselectedbans'] = "sucC3\$sfulLY R3M0V3D \$EL3c+3d BANS";
$lang['failedtoaddnewban'] = "f4Il3D tO 4DD neW b4N";
$lang['failedtoremovebans'] = "f4iL3D +o r3M0ve s0M3 0r @ll Of +h3 S3l3c+ed 8@n\$";
$lang['duplicatebandataentered'] = "dUpLic4Te b4n D@T@ EnT3red. Pl3@SE CH3Ck Y0Ur wILdc4Rds t0 \$Ee 1F +H3Y @lR34Dy MAtcH Teh D4+4 3n+er3D";
$lang['successfullyaddedban'] = "sUCCe5sphuLly 4DD3d B4n";
$lang['successfullyupdatedban'] = "sUcceSSphULly Upd4Ted 8@N";
$lang['noexistingbandata'] = "th3r3 Is nO EXi\$t1n9 b@n da+4. +0 ADD @ B@N Cl1Ck tHE '4Dd new' BuTT0N b3L0w.";
$lang['youcanusethepercentwildcard'] = "j00 c@n Use +he PerCenT (%) w1ldC4rd SYmBOL 1n @Ny OPH y0UR 84N l1S+5 +0 O8T4in P4rTi@l M@TCh3\$, i.e. '192.168.0.%' W0ULD 84N 4LL iP 4DdresSE\$ 1n teH raN93 192.168.0.1 +Hrou9h 192.168.0.254";
$lang['selecteddateisinthepast'] = "s3lec+3d d4tE Is 1n T3h p4ST";
$lang['cannotusewildcardonown'] = "j00 c4nn0+ @dd % 4\$ 4 Wildc4RD m4tch ON i+s 0WN!";
$lang['requirepostapproval'] = "rEQu1r3 p0sT 4ppRov@l";
$lang['adminforumtoolsusercounterror'] = "tH3r3 mu\$T 83 4t L34s+ 1 uS3R w1+H @dm1n +OOL5 AND pH0RUm to0l\$ 4CCeS\$ oN 4lL f0RUMs!";
$lang['postcount'] = "pOst C0unt";
$lang['changepostcount'] = "ch@n9e p0s+ cOunT";
$lang['resetpostcount'] = "r3\$E+ p0\$+ C0UN+";
$lang['successfullyresetpostcount'] = "succesSphuLLY r35e+ p0s+ cOUn+";
$lang['successfullyupdatedpostcount'] = "sUCcEs\$FULly Upd@Ted posT c0unt";
$lang['failedtoresetuserpostcount'] = "f@IleD T0 r3s3t pOS+ count";
$lang['failedtochangeuserpostcount'] = "f@iL3D tO ch4n93 usER PO\$+ Coun+";
$lang['postapprovalqueue'] = "p0\$t 4PproV@l qU3ue";
$lang['nopostsawaitingapproval'] = "n0 Po5+S @r3 @wAItiN9 4ppR0vaL";
$lang['failedtoapproveuser'] = "faiL3D tO 4ppR0V3 uSeR %s";
$lang['endsession'] = "end ses\$1On (kICk)";
$lang['visitorlog'] = "vI5itOR L09";
$lang['novisitorslogged'] = "no vis1toR\$ l0g9ed";
$lang['addselectedusers'] = "adD 5elEC+3d u\$eR\$";
$lang['removeselectedusers'] = "r3m0VE sEL3c+ed uS3R\$";
$lang['addnew'] = "aDd NEW";
$lang['deleteselected'] = "deL3T3 Select3D";
$lang['forumrulesmessage'] = "<p><b>fORum Rule\$</b></p><p>rEg1s+R4TIoN tO %1\$\$ is FR3E! w3 d0 1N\$1\$t th@+ j00 4b1dE 8Y THE rUL3\$ AND POLIc135 d3+4Il3d 83LOW. iPH j00 4gR3e TO t3h t3rmS, PL34SE ChECk +h3 'i agr3e' CH3ckBoX @nd PR3ss +eh 'R391s+er' bu++0N 83LoW. 1PH J00 W0ulD LIK3 tO canCEL +eH r391sTR@+10N, ClICK %2\$\$ To r3TurN +o thE FoRUmS 1nDeX.</p><p>aLtHOUgH t3h aDMin1S+r4tOr\$ 4nD M0d3r4+0R\$ 0f %1\$S WILL @++3mPt To K3EP 4lL OBJEC+10n@bL3 M3s\$493\$ 0phPh THIs FoRUM, I+ IS 1MP0S\$18L3 PhoR u5 to R3vI3W 4lL ME\$S@9es. alL M3\$s49es 3xPreSs Th3 VIEw\$ Oph +HE 4u+hOr, 4nd n31+h3r t3H 0wn3rS 0f %1\$s, nOr pRojEcT B33hIve ForuM ANd i+S 4fFILI4+3s wilL 83 HEld re5p0n\$18le pHor +H3 C0n+3N+ 0f 4NY me\$S49E.</p><p>bY 49r3EIn9 to tH3s3 RuLEs, j00 w4rrAnT tH4T j00 wIlL N0t pOsT aNy mEs\$493\$ +H@t 4R3 O85C3N3, VUL94R, Sexu@llY-ORieNT@+3D, h4TEFUl, thRe4t3Ning, 0r O+H3Rw15E iN Viol@+10N OF @NY l4w\$.</p><p>tH3 0wNErS OF %1\$s RE\$3Rve teh riGht +o r3M0v3, 3d1+, M0ve 0R cLO53 4nY Thr3@d ph0r 4nY r34SoN.</p>";
$lang['cancellinktext'] = "h3Re";
$lang['failedtoupdateforumsettings'] = "f41l3D +O upD@+3 PHorum S3T+1ng\$. ple4\$e +Ry 4g41N l@t3r.";
$lang['moreadminoptions'] = "m0RE 4dmIN 0pTI0ns";
$lang['mailfunction'] = "maIl fuNCtioN";
$lang['smtpserveraddr'] = "smTp Serv3r 4ddreSS";
$lang['smtpserverport'] = "smTp SErver P0Rt";
$lang['smtpserverusername'] = "sM+P Serv3R userN@M3";
$lang['smtpserverpassword'] = "sM+p SErver PAsSw0Rd";
$lang['sendmailpath'] = "sEnDM41l pA+H";
$lang['phpmailfunction'] = "u5E pHP m@1L phunc+10n";
$lang['smtpmailserver'] = "u53 sM+p \$eRv3R";
$lang['sendmail'] = "uS3 sendm@1L";

// Admin Log data (admin_viewlog.php) --------------------------------------------

$lang['changedstatusforuser'] = "cH@NGed u\$er s+4+u\$ pH0r '%s'";
$lang['changedpasswordforuser'] = "ch4NGed P@s\$W0rd ph0R '%s'";
$lang['changedforumaccess'] = "cH4n9ed F0RUm 4cCe\$s p3rm15\$10n\$ f0r '%s'";
$lang['deletedallusersposts'] = "d3lE+ED 4ll p0\$t\$ Phor '%s'";

$lang['createdusergroup'] = "cr34+ed usEr GR0up '%s'";
$lang['deletedusergroup'] = "d3l3t3d UseR 9r0up '%s'";
$lang['updatedusergroup'] = "uPd4T3d u\$Er 9ROup '%s'";
$lang['addedusertogroup'] = "aDdEd Us3r '%s' +o 9rOUp '%s'";
$lang['removeduserfromgroup'] = "r3mOV3 U\$Er '%s' phROm GROup '%s'";

$lang['addedipaddresstobanlist'] = "aDded 1P '%s' tO ban lis+";
$lang['removedipaddressfrombanlist'] = "r3mOVED 1p '%s' FroM b@n l1sT";

$lang['addedlogontobanlist'] = "add3d lOg0n '%s' +O 84n lI5+";
$lang['removedlogonfrombanlist'] = "rEM0V3D LogOn '%s' From 8@N L1\$+";

$lang['addednicknametobanlist'] = "aDdeD NiCkn4m3 '%s' +0 b4N liS+";
$lang['removednicknamefrombanlist'] = "rem0v3D NIcKn@m3 '%s' phRoM 8@N l1\$+";

$lang['addedemailtobanlist'] = "aDd3D Em4il 4ddr3S5 '%s' +O 8@n LIst";
$lang['removedemailfrombanlist'] = "rEM0Ved em4il @ddRe\$s '%s' PHR0m B@N LIS+";

$lang['addedreferertobanlist'] = "added R3F3R3R '%s' +O 8@n l1sT";
$lang['removedrefererfrombanlist'] = "reMoVEd repher3r '%s' fr0m b4N liST";

$lang['editedfolder'] = "eDI+3D F0Ld3R '%s'";
$lang['movedallthreadsfromto'] = "moV3d 4ll +hre4d5 FROM '%s' +0 '%s'";
$lang['creatednewfolder'] = "cr3@TEd N3W ph0Ld3R '%s'";
$lang['deletedfolder'] = "deLETed fOldEr '%s'";

$lang['changedprofilesectiontitle'] = "cH4N9ed PR0f1LE Sec+ion T1+l3 phrOm '%s' +0 '%s'";
$lang['addednewprofilesection'] = "aDD3d n3W PR0F1Le section '%s'";
$lang['deletedprofilesection'] = "deLE+Ed pR0ph1LE \$ec+I0N '%s'";

$lang['addednewprofileitem'] = "aDdED new PROfilE 1tEM '%s' T0 \$EC+10N '%s'";
$lang['changedprofileitem'] = "cHAN93D pr0PHilE 1+EM '%s'";
$lang['deletedprofileitem'] = "d3L3+ed pROfiLE 1+3M '%s'";

$lang['editedstartpage'] = "eD1+Ed s+4rT P4GE";
$lang['savednewstyle'] = "s@VEd n3w 5+YLe '%s'";

$lang['movedthread'] = "m0vEd tHRe@d '%s' PHRoM '%s' T0 '%s'";
$lang['closedthread'] = "cL0\$ed +HREaD '%s'";
$lang['openedthread'] = "opeN3D tHRe@d '%s'";
$lang['renamedthread'] = "r3n4M3D Thre4d '%s' tO '%s'";

$lang['deletedthread'] = "del3+ed THre@D '%s'";
$lang['undeletedthread'] = "unDEle+eD THR34D '%s'";

$lang['lockedthreadtitlefolder'] = "l0CKed +Hr34D 0P+10n\$ On '%s'";
$lang['unlockedthreadtitlefolder'] = "uNl0CK3d thread oPti0N5 0n '%s'";

$lang['deletedpostsfrominthread'] = "deL3+Ed POsT5 phR0M '%s' 1n +Hread '%s'";
$lang['deletedattachmentfrompost'] = "dele+Ed 4T+4chmen+ '%s' PhrOM P0s+ '%s'";

$lang['editedforumlinks'] = "ed1TEd Ph0Rum L1nKS";
$lang['editedforumlink'] = "ed1+Ed PHORum lINK: '%s'";

$lang['addedforumlink'] = "adDeD FORUm lINK: '%s'";
$lang['deletedforumlink'] = "d3L3ted foRUm L1NK: '%s'";
$lang['changedtoplinkcaption'] = "ch@NGEd +0p LINk c4ptI0N fr0m '%s' T0 '%s'";

$lang['deletedpost'] = "d3LE+3d P0St '%s'";
$lang['editedpost'] = "edIt3d pOs+ '%s'";

$lang['madethreadsticky'] = "m4D3 thREad '%s' S+1CKy";
$lang['madethreadnonsticky'] = "m4d3 +Hre@d '%s' NOn-STickY";

$lang['endedsessionforuser'] = "eNDed SE\$s10N FOr U53r '%s'";

$lang['approvedpost'] = "aPpROVed POSt '%s'";

$lang['editedwordfilter'] = "eD1TED w0Rd Filter";

$lang['addedrssfeed'] = "aDd3d rSS Fe3d '%s'";
$lang['editedrssfeed'] = "ed1+3d r\$s phe3d '%s'";
$lang['deletedrssfeed'] = "d3l3+ed R5\$ PhE3d '%s'";

$lang['updatedban'] = "upd@+3d ban '%s'. ch@n9eD Type PhrOM '%s' +O '%s', chaN93d D4+4 phrOM '%s' +0 '%s'.";

$lang['splitthreadatpostintonewthread'] = "spLi+ +hrE4d '%s' 4+ p0s+ %s  INTo N3W tHR34D '%s'";
$lang['mergedthreadintonewthread'] = "mer9ED tHre@ds '%s' @ND '%s' 1N+o N3W +hr34d '%s'";

$lang['ipaddressbanhit'] = "u53R '%s' 1s b@NNed. ip Addr3s\$ '%s' m4tch3d 8@n d4t4 '%s'";
$lang['logonbanhit'] = "u5ER '%s' I\$ 8@Nned. LOg0n '%s' M@+CHed 84n d@t@ '%s'";
$lang['nicknamebanhit'] = "us3r '%s' Is 8@NneD. nickn4m3 '%s' m4tch3D 84n d@t@ '%s'";
$lang['emailbanhit'] = "u53R '%s' 1s b@NneD. em4il @DDre\$s '%s' M4+ch3D b4N d4ta '%s'";
$lang['refererbanhit'] = "us3r '%s' I5 b4nn3d. H+Tp refer3r '%s' m@+ched 84n D@t@ '%s'";

$lang['modifiedpermsforuser'] = "moDiphied P3RMs PhoR US3r '%s'";
$lang['modifiedfolderpermsforuser'] = "m0DIF13d pH0LD3r perM\$ phoR U\$eR '%s'";

$lang['deleteduseraccount'] = "dEL3t3D uS3r @ccOuN+ '%s'";
$lang['deletedalluserdataforaccount'] = "d3Le+Ed 4ll u\$ER dat4 pH0R 4cCount '%s'";

$lang['userpermfoldermoderate'] = "foLder m0Der4+OR";

$lang['adminlogempty'] = "aDm1N L09 i\$ emp+Y";

$lang['youmustspecifyanactiontypetoremove'] = "j00 MUs+ \$Peciphy an @ctioN tYPe +O r3mOV3";

$lang['alllogentries'] = "aLl LO9 3n+RI3\$";
$lang['userstatuschanges'] = "user S+4+us Ch4N9eS";
$lang['forumaccesschanges'] = "fOrUM Acc3\$\$ ch4n93s";
$lang['usermasspostdeletion'] = "u\$3r m4s\$ P0s+ d3l3+iON";
$lang['ipaddressbanadditions'] = "ip 4DdR35s B4N 4DdI+ION\$";
$lang['ipaddressbandeletions'] = "iP @DDr3\$s 84n Del3+1on\$";
$lang['threadtitleedits'] = "thr34D +1+l3 3DIt\$";
$lang['massthreadmoves'] = "m@Ss +hre4d MOVE\$";
$lang['foldercreations'] = "f0Lder cr34t10ns";
$lang['folderdeletions'] = "f0ld3R del3tioNs";
$lang['profilesectionchanges'] = "pR0pH1L3 sec+iON cH@N9e\$";
$lang['profilesectionadditions'] = "pr0pH1l3 SEC+1oN @DdI+ionS";
$lang['profilesectiondeletions'] = "profiLE s3cti0n deL3T1Ons";
$lang['profileitemchanges'] = "pr0PhIL3 I+em Ch@N9E\$";
$lang['profileitemadditions'] = "pROPh1l3 1+EM 4dd1t1oNS";
$lang['profileitemdeletions'] = "pr0FILe 1tEm DeLeti0n\$";
$lang['startpagechanges'] = "s+@rt P@G3 ch@Ng35";
$lang['forumstylecreations'] = "f0RUm styL3 cR34+I0N5";
$lang['threadmoves'] = "tHRE@D mOV3s";
$lang['threadclosures'] = "tHrE4D cl05UR3s";
$lang['threadopenings'] = "tHRE4d oP3NIN9s";
$lang['threadrenames'] = "thREad rEn@m3s";
$lang['postdeletions'] = "post D3l3TIon\$";
$lang['postedits'] = "poS+ eD1+S";
$lang['wordfilteredits'] = "wOrD pH1Lter ed1+S";
$lang['threadstickycreations'] = "thR34D s+1CKY CRe4+10N\$";
$lang['threadstickydeletions'] = "thR34D \$T1CkY D3L3t1oNS";
$lang['usersessiondeletions'] = "uS3R SE\$si0n d3L3TI0n\$";
$lang['forumsettingsedits'] = "f0rUm SEtT1NgS eD1+\$";
$lang['threadlocks'] = "tHR3AD L0CK\$";
$lang['threadunlocks'] = "thRE4D unLOck5";
$lang['usermasspostdeletionsinathread'] = "u\$3r m45\$ p0s+ dELEti0ns 1N @ +hr3@d";
$lang['threaddeletions'] = "tHRE4D del3+ioNS";
$lang['attachmentdeletions'] = "aTt@Chm3n+ d3l3tiONS";
$lang['forumlinkedits'] = "foRUM L1nK 3d1+s";
$lang['postapprovals'] = "p0S+ 4PPr0V4L\$";
$lang['usergroupcreations'] = "u\$eR 9rouP cr34+1on\$";
$lang['usergroupdeletions'] = "uSer 9rOUP dEl3TionS";
$lang['usergroupuseraddition'] = "u5eR GR0Up uSer @ddi+1on";
$lang['usergroupuserremoval'] = "u\$ER gr0uP user R3m0v4l";
$lang['userpasswordchange'] = "u\$3R P@s\$word ch@nGE";
$lang['usergroupchanges'] = "us3R GR0UP cHan93\$";
$lang['ipaddressbanadditions'] = "iP 4ddr3s5 8an add1+10ns";
$lang['ipaddressbandeletions'] = "iP addr3s5 84n del3+1ONS";
$lang['logonbanadditions'] = "loGon 84n @DDi+i0nS";
$lang['logonbandeletions'] = "l0GOn B@n dele+1OnS";
$lang['nicknamebanadditions'] = "n1CKN4me 8An @ddITIoNS";
$lang['nicknamebanadditions'] = "nIcKn@m3 b4n @dd1+10NS";
$lang['e-mailbanadditions'] = "e-M41l 84n 4ddit10ns";
$lang['e-mailbandeletions'] = "e-M41L 8@n del3t10ns";
$lang['rssfeedadditions'] = "rsS Feed aDD1+i0n5";
$lang['rssfeedchanges'] = "r\$\$ phe3d Ch@n93S";
$lang['threadundeletions'] = "tHRe4d uND3lE+1Ons";
$lang['httprefererbanadditions'] = "ht+p R3PheRer 8AN 4dDIt10ns";
$lang['httprefererbandeletions'] = "h++P R3PhER3R 8@N DeL3+1ONs";
$lang['rssfeeddeletions'] = "r55 PHeEd d3le+I0nS";
$lang['banchanges'] = "b4N ch4ng3S";
$lang['threadsplits'] = "tHre@D \$pl1+S";
$lang['threadmerges'] = "thR3Ad m3R9e\$";
$lang['forumlinkadditions'] = "f0Rum L1nk @DdI+I0ns";
$lang['forumlinkdeletions'] = "fOrum link Del3TIons";
$lang['forumlinktopcaptionchanges'] = "foRum l1nk T0P c@pt1oN ChaN93S";
$lang['userdeletions'] = "uS3r D3LE+10n\$";
$lang['userdatadeletions'] = "u5Er d@+4 del3+10Ns";
$lang['usergroupchanges'] = "us3R gr0UP cH@N9e\$";
$lang['ipaddressbancheckresults'] = "iP 4ddr3\$s b4n cHEcK R3SulT5";
$lang['logonbancheckresults'] = "lOgON 84n cheCK r3sUL+\$";
$lang['nicknamebancheckresults'] = "nICKN4M3 B4n ch3ck REsULT5";
$lang['emailbancheckresults'] = "eM41l 84n CHEck r3\$UL+s";
$lang['httprefererbancheckresults'] = "h++P repHEr3r ban CheCk RE5UL+\$";

$lang['removeentriesrelatingtoaction'] = "r3m0ve eN+RIE\$ r3l@+1nG t0 AcT10N";
$lang['removeentriesolderthandays'] = "r3Move 3ntr1ES OldEr THAN (d4YS)";

$lang['successfullyprunedadminlog'] = "succ3sSphully pruNED @DM1N l09";
$lang['failedtopruneadminlog'] = "f41leD tO prUn3 @dM1N LO9";

$lang['successfullyprunedvisitorlog'] = "suCC3ssPHullY PRuned VIs1+OR L09";
$lang['failedtoprunevisitorlog'] = "f@Il3d TO PruNe vIs1+oR log";

$lang['prunelog'] = "pRUne L09";

// Admin Forms (admin_forums.php) ------------------------------------------------

$lang['noexistingforums'] = "n0 3xis+1nG phORum\$ PhOUnd. to Cre4+e 4 NEw f0ruM click +3h '4dd NeW' bu+T0n 83L0W.";
$lang['webtaginvalidchars'] = "wEBT49 C4N oNLy C0Nt41N upperc4\$E 4-Z, 0-9 4nd und3RscORE Ch4r4ct3r\$";
$lang['webtagmaxlength'] = "webt49 Must No loN93R 32 Ch4r@c+3RS 1N LenG+H";
$lang['invalidforumidorforumnotfound'] = "inv4l1d pH0ruM ph1d Or phORum NoT found";
$lang['successfullyupdatedforum'] = "sUCc35SPHUlly Updat3d FoRuM";
$lang['failedtoupdateforum'] = "f@iL3D +O upd4+e fOruM: '%s'";
$lang['successfullycreatednewforum'] = "sUccES5phuLlY cre4+eD New PhoRUM";
$lang['selectedwebtagisalreadyinuse'] = "t3h \$elecT3d w38+4g i\$ alRE4DY 1N u\$e. PL3a\$E cHO0se @No+H3r.";
$lang['selecteddatabasecontainsconflictingtables'] = "tEH SElec+ED d4t48AS3 CON+@1n\$ ConPhl1CT1NG +48L3\$. C0NpHL1CT1n9 T@Bl3 N@m3\$ ar3:";
$lang['forumdeleteconfirmation'] = "aRE j00 sure J00 wan+ +0 d3le+3 4ll 0F +eh S3l3C+3d foruMS?";
$lang['forumdeletewarning'] = "ple4SE n0te Th@+ j00 cAnNOt reCover d3L3T3d PH0RUMS. oNce deL3t3D @ ph0rum 4nD 4LL oPH t3H 4\$\$OCi@+ed d4+4 1s P3Rm4n3ntlY r3m0ved froM t3h d@t48A53. iPH j00 do No+ w15h to d3l3+3 tH3 \$EleC+3d forUMS ple@sE cL1ck c@nc3L.";
$lang['successfullyremovedselectedforums'] = "sUCces\$fuLLy dEL3t3d sel3Ct3D F0rum\$";
$lang['failedtodeleteforum'] = "f41LeD T0 d3l3+ed forUM: '%s'";
$lang['addforum'] = "aDD f0rUM";
$lang['editforum'] = "ed1T PHOrum";
$lang['visitforum'] = "v151+ phORum: %s";
$lang['accesslevel'] = "acC3Ss lEV3L";
$lang['forumleader'] = "foRUM l34d3R";
$lang['usedatabase'] = "us3 d@+4b4s3";
$lang['unknownmessagecount'] = "uNKN0wn";
$lang['forumwebtag'] = "f0RUm W38+4G";
$lang['defaultforum'] = "d3pH4uL+ pH0Rum";
$lang['forumdatabasewarning'] = "pLE4\$3 3n\$ur3 j00 SEl3C+ +eh c0Rr3C+ D4+4b4\$e When cR3A+1ng @ new f0rUM. onc3 Cre4T3d @ New ph0rum c@nn0+ 83 moveD 83TWe3n @vA1L4ble d4T48A\$E\$.";

// Admin Global User Permissions

$lang['globaluserpermissions'] = "gl0bAL U\$Er P3Rm1\$si0Ns";

// Admin Forum Settings (admin_forum_settings.php) -------------------------------

$lang['mustsupplyforumwebtag'] = "j00 mUSt SuppLy @ foruM web+4g";
$lang['mustsupplyforumname'] = "j00 mu\$+ \$UpPly 4 foRUm nAMe";
$lang['mustsupplyforumemail'] = "j00 mUS+ \$uppLY @ fORum 3m4il 4dDR3S5";
$lang['mustchoosedefaultstyle'] = "j00 Mu\$T ch00se 4 dEPH4ul+ foRuM \$+yLE";
$lang['mustchoosedefaultemoticons'] = "j00 MU\$+ ch0oSE DepH4ULt fOrum eMO+1c0n5";
$lang['mustsupplyforumaccesslevel'] = "j00 Mu5t suPply 4 pH0RUm @cC3sS lEV3l";
$lang['mustsupplyforumdatabasename'] = "j00 mus+ SUpply 4 fORum da+48@SE n4me";
$lang['unknownemoticonsname'] = "uNKNowN 3mO+Ic0N\$ n4me";
$lang['mustchoosedefaultlang'] = "j00 MuS+ CHo0se 4 D3PH@uL+ pHOrum Lan9u4ge";
$lang['activesessiongreaterthansession'] = "ac+IV3 SE5\$10N +1meout C4NNO+ b3 9r34TEr +h4N se5s10n t1MEout";
$lang['attachmentdirnotwritable'] = "a++4cHMEnt D1reC+0rY aNd sY\$T3m teMPor4Ry D1r3c+0ry / PHP.1n1 'UPlO@D_tMP_dir' muST B3 WriT48Le bY Th3 weB ServER / pHP pROc3S\$!";
$lang['attachmentdirblank'] = "j00 Must \$UpPLy @ D1rECtORY t0 s@Ve 4tT4cHmentS in";
$lang['mainsettings'] = "ma1n s3t+1NG\$";
$lang['forumname'] = "f0rUM N4me";
$lang['forumemail'] = "foRUM 3m4il";
$lang['forumnoreplyemail'] = "n0-reply em4il";
$lang['forumdesc'] = "f0rUM de\$CRIptI0N";
$lang['forumrooturi'] = "foruM ro0T ur1";
$lang['forumkeywords'] = "fOrum keywoRd5";
$lang['forumcontentrating'] = "fORUm C0n+3nt Ra+1nG";
$lang['defaultstyle'] = "d3f@Ult StylE";
$lang['defaultemoticons'] = "deFaul+ eM0t1cONs";
$lang['defaultlanguage'] = "d3f4UL+ l@NGu@93";
$lang['forumaccesssettings'] = "f0rUM 4CC3\$S \$3T+1ng\$";
$lang['forumaccessstatus'] = "foRum 4ccES\$ \$t4tus";
$lang['changepermissions'] = "ch4NGE PerMIS\$1On\$";
$lang['changepassword'] = "ch@nge P4s\$WORd";
$lang['passwordprotected'] = "p4S\$wORd PRot3Ct3d";
$lang['passwordprotectwarning'] = "j00 Have N0+ s3+ @ f0RUM P@S\$woRD. 1f J00 DO N0t SE+ @ p@S\$worD t3H PA\$SW0rd PR0teCT10N fuNC+10n@LITY wILl 83 4ut0m4T1c@LLY d1s@bled!";
$lang['postoptions'] = "po\$T 0pT10N\$";
$lang['allowpostoptions'] = "aLL0W P0S+ 3d1+1n9";
$lang['postedittimeout'] = "p05T eDI+ +im30u+";
$lang['posteditgraceperiod'] = "p0\$+ ed1+ 9R4c3 period";
$lang['wikiintegration'] = "w1K1wikI in+Egr4+10N";
$lang['enablewikiintegration'] = "eN@BlE wIK1Wik1 1nt39R4T10N";
$lang['enablewikiquicklinks'] = "en4ble W1K1w1ki Qu1ck L1nk5";
$lang['wikiintegrationuri'] = "wIkIw1ki L0c@+Ion";
$lang['maximumpostlength'] = "m4X1MUm P0S+ l3N9+H";
$lang['postfrequency'] = "pOSt Fr3Qu3ncy";
$lang['enablelinkssection'] = "en48L3 l1nk\$ SEc+1ON";
$lang['allowcreationofpolls'] = "aLLow Cr34+10n 0f p0lLs";
$lang['allowguestvotesinpolls'] = "allOw GU3\$T\$ +0 V0+3 1N PolL\$";
$lang['unreadmessagescutoff'] = "uNR3@d me\$s@ge\$ CuT-0Ff";
$lang['disableunreadmessages'] = "d1s@BL3 UNREad m3Ss@G3s";
$lang['thirtynumberdays'] = "30 d@Y5";
$lang['sixtynumberdays'] = "60 D4Y\$";
$lang['ninetynumberdays'] = "90 D4Y\$";
$lang['hundredeightynumberdays'] = "180 D4yS";
$lang['onenumberyear'] = "1 ye4r";
$lang['unreadcutoffchangewarning'] = "d3PEND1ng ON \$Erver PErF0rM4NCE 4nd +H3 NUM83r oph +HRe@d\$ Y0uR forUmS c0N+41N, ch4ngING +eH unR3Ad cUT-oPHPH m@y t4k3 \$EvER4l MiNU+eS tO comPle+e. PHOR tH1S re4Son I+ is r3comM3NdeD TH4+ j00 @v01d Ch@NG1N9 thIs se++inG wH1LE YouR phOrumS 4R3 8u\$y.";
$lang['unreadcutoffincreasewarning'] = "inCR34S1n9 THE unr3ad cut-0phF wiLL m4K3 Thr3ad\$ M4rK3D @\$ M0d1f13D S1NcE 4nd THr3@d\$ Old3r +H@n teH prev1oUS Cut-oFf @Pp3@r 4\$ unRE4D T0 4lL usERs";
$lang['confirmunreadcutoff'] = "ar3 J00 SUre J00 w@n+ +0 cH4N93 teh UnRE4D cUT-0ff?";
$lang['otherchangeswillstillbeapplied'] = "cL1ck1nG 'N0' W1LL oNLy C@NC3L +h3 uNR34D cU+-ofph cH@n9ES. oTH3r CH4n93\$ y0u'v3 m4de w1ll \$tILL 83 \$4veD.";
$lang['searchoptions'] = "se@rch 0P+1on\$";
$lang['searchfrequency'] = "s34RCh fR3qUEncy";
$lang['sessions'] = "sessI0n5";
$lang['sessioncutoffseconds'] = "s3ssI0N cU+ ofPh (\$3c0Nd5)";
$lang['activesessioncutoffseconds'] = "aCT1v3 \$eSsI0n cu+ 0fph (second\$)";
$lang['stats'] = "st4+S";
$lang['hide_stats'] = "hIde ST4t\$";
$lang['show_stats'] = "sHOw s+@t\$";
$lang['enablestatsdisplay'] = "eN48le S+4+s Di\$pL@y";
$lang['personalmessages'] = "pER\$0n4l M3Ss@g3S";
$lang['enablepersonalmessages'] = "eN@ble per\$On4L m3sSagE5";
$lang['pmusermessages'] = "pm me\$s493\$ P3r UseR";
$lang['allowpmstohaveattachments'] = "aLL0w p3r\$oN4L me\$S493s +O h4v3 4t+4ChM3nTS";
$lang['autopruneuserspmfoldersevery'] = "au+0 pRUn3 useR'S pm FoldeRs 3v3ry";
$lang['userandguestoptions'] = "uS3R @Nd GUest 0P+10ns";
$lang['enableguestaccount'] = "eN48L3 Guest 4cc0un+";
$lang['listguestsinvisitorlog'] = "lisT gu3s+s IN v151ToR L0g";
$lang['allowguestaccess'] = "aLlOw Gu3\$t 4cc3\$s";
$lang['userandguestaccesssettings'] = "useR 4nd GU3\$T @cc3S\$ \$3++1ngs";
$lang['allowuserstochangeusername'] = "allow User5 TO ch@ngE u53Rname";
$lang['requireuserapproval'] = "r3QUiRE Us3r @pPR0v4l BY 4dM1n";
$lang['requireforumrulesagreement'] = "reQuIR3 USeR To A9RE3 to Forum rULes";
$lang['sendnewuseremailnotifications'] = "sEnd N0T1f1c@TION t0 9LO84l Ph0rum 0wNEr";
$lang['enableattachments'] = "eN@bLE 4Tt4Chm3n+S";
$lang['enableattachmentthumbnails'] = "en48LE 4+T@Chm3NT iM@G3 +HuM8n4iL\$";
$lang['attachmentdir'] = "a++4CHMenT dIR";
$lang['userattachmentspace'] = "atT@chMEn+ sP@c3 peR user";
$lang['userattachmentspaceperpost'] = "a+tAChM3n+ 5P4CE p3R P0st";
$lang['allowembeddingofattachments'] = "allOw 3M83ddINg OF 4++4CHM3nTs";
$lang['usealtattachmentmethod'] = "u5E 4l+ern4TIve @+tachM3N+ Me+h0d";
$lang['allowgueststoaccessattachments'] = "allOw gU3S+s +o 4cC3\$s @T+aCHM3N+S";
$lang['allowedattachmentmimetypes'] = "alL0W3D 4tT4CHm3n+ m1M3-+yp3s";
$lang['forumsettingsupdated'] = "foRum \$3++1ngs SUCC3SsPHullY upda+ed";
$lang['forumstatusmessages'] = "f0ruM st@+uS m3sS4Ge5";
$lang['forumclosedmessage'] = "foRUM clO53d MES\$4G3";
$lang['forumrestrictedmessage'] = "foRUm re\$tR1C+Ed m3s\$4GE";
$lang['forumpasswordprotectedmessage'] = "fORUm p4sSw0rD ProTec+Ed m3S\$@93";
$lang['googleanalytics'] = "g0O9L3 4n@lyt1c5";
$lang['enablegoogleanalytics'] = "en48l3 gOo9LE 4N4lYTIc\$";
$lang['allowforumgoogleanalytics'] = "allow gOOGL3 4n@lyT1cs ON 3@ch phOruM";
$lang['googleanalyticsaccountid'] = "g0o9L3 4nalYtiCS 4ccOun+ Id";

$lang['googleadsense'] = "g0o9LE aDS3N\$E";
$lang['adsensepublisherid'] = "ad\$Ense pU8L1Sh3r 1d";
$lang['adsensemediumadid'] = "meD1UM s1zed (468x60) 4d \$L0T id";
$lang['adsensesmalladid'] = "sM4lL \$iZed (234x60) ad sL0+ 1D";
$lang['adsenseallusers'] = "aLL u\$3R5";
$lang['adsenseguestsonly'] = "gu3sTS onlY";
$lang['adsensenoone'] = "n0-One (di5a8leD)";
$lang['adsensedisplayadsforusers'] = "d1\$pl@Y @dSENS3 4D\$ phOR";
$lang['adsensedisplayadsonpages'] = "dI\$Pl4y 4dseNS3 4d\$ 0n";
$lang['adsenseallpages'] = "tOP 0pH EveRy P@93";
$lang['adsensetopofmessages'] = "t0P OF me5s4g3s";
$lang['adsenseafterfirstmessage'] = "aPH+er 1S+ M3S5A9E";
$lang['adsenseafterthirdmessage'] = "aPHt3r 3Rd m3s54ge";
$lang['adsenseafterfifthmessage'] = "aFTEr 5TH M3ss@G3";
$lang['adsenseaftertenthmessage'] = "aftER 10Th mes\$4g3";
$lang['adsenseafterrandommessage'] = "aph+Er 4 R4nd0m M3S5A93";
$lang['registertoremoveadverts'] = "reGiSt3R TO r3M0v3 +h3SE 4dv3r+s.";

// Admin Forum Settings Help Text (admin_forum_settings.php) ------------------------------

$lang['forum_settings_help_10'] = "<b>p0S+ Ed1+ +1m3ouT</b> I\$ +he +1m3 IN Minut3\$ aF+er P0s+ing +H4+ 4 uSEr c4n 3dIT theiR p0sT. If se+ +o 0 +HeRE iS n0 liMIt.";
$lang['forum_settings_help_11'] = "<b>mAx1muM poS+ L3N9+H</b> is +He m4Ximum nuMb3r 0ph Ch@r@c+3R\$ +h4t w1ll B3 d1\$Pl@Y3D 1n @ p0sT. iF @ p0ST i\$ l0n9Er Th4n +h3 nUMB3R 0f CH4r4Cters d3pH1n3D here IT wiLL 8E cut shoR+ 4ND 4 L1NK 4DDed +0 +eh BOt+Om +0 4ll0W uSErs +0 Re4D +H3 Wh0L3 p0S+ 0n @ sep@R4+E pA9E.";
$lang['forum_settings_help_12'] = "iPH j00 DON'+ WaNt Y0ur Users +o 83 @8le +O Cr34te pOLl\$ j00 CaN disAbl3 Th3 @80v3 opTIon.";
$lang['forum_settings_help_13'] = "tHE LiNk\$ seCt10n oPh 833h1VE Pr0vID3S @ Pl@C3 fOr yoUr USer\$ +O M@In+4In A LisT 0pH \$It3S +h3y phrequEnTLY v151+ tH4T OTher us3r\$ m@Y f1nd us3PhuL. LINKS C4N 8e dIvided 1NT0 c4t39Ori35 8Y fOLdEr 4ND allOw For comM3n+\$ 4nD R@+INGS +o 83 91V3N. in orDer t0 M0D3r4te The LINk\$ \$Ec+10N @ uS3r MUs+ B3 r4n+ed 9lo84l MOD3R4+Or sT@TUs.";
$lang['forum_settings_help_15'] = "<b>s3s5IoN cUT 0phph</b> 15 +3h m4X1MUm +1M3 83FoRE 4 USER'\$ \$ES\$1ON Is D3EM3d d3@D @ND tH3y aRe l0g9ed 0U+. 8Y DEf@Ult TH1s 1\$ 24 h0ur5 (86400 S3C0NdS).";
$lang['forum_settings_help_16'] = "<b>aCt1Ve SEs5I0n CUt 0FF</b> 15 Th3 m4XimuM +1ME b3PH0RE @ User'S \$e5si0N 1\$ d3EM3d 1n4c+iVE 4+ WHICh pO1Nt tHEy eN+eR 4n iDl3 \$T@te. 1n +HIS 5+4+E +3H usER R3m@iNS L0GGed IN, 8uT they 4re rEM0vED phROM +h3 @cTIV3 u\$eRS L1\$T 1n t3h s+4+s D1spl@Y. 0NC3 th3Y 83C0ME 4CtIV3 49@1N tH3y wilL 83 RE-4dd3d To +H3 li\$T. By d3PH@uLt Th1\$ setTinG 1\$ SE+ +0 15 mINU+3\$ (900 5Ec0ND\$).";
$lang['forum_settings_help_17'] = "eN4bl1N9 +hi\$ opT10N @lL0WS b3eHIV3 +O 1nclude 4 \$Ta+S d15pl4y @T +eh Bot+0M 0f +eh M3\$s4GeS p4nE s1m1lar +0 T3H oNe used 8y M@ny ph0rum SOF+w4R3 +1+les. 0nce 3n48l3d +3h DIspL4y opH the 5+4+S p4G3 c4N 83 +OGgled INd1V1Du4lly 8y e@ch uSEr. 1F they D0N'+ W4N+ +0 SEe 1+ +H3y c4n h1DE i+ pHR0m V1eW.";
$lang['forum_settings_help_18'] = "peRsoNAL mES\$4GEs 4Re INv@lU@Ble @S @ W4Y Oph Tak1n9 m0Re pR1V4te M4t+3rS 0U+ oF view oPH +h3 OTH3r M3M8eRS. hoWEver if J00 d0N'T w4nt youR u\$er5 +o BE @8Le +O S3nd e4ch 0theR p3r\$0naL me\$s4g3s J00 c@n d15aBL3 +HIs OP+1ON.";
$lang['forum_settings_help_19'] = "pERSONaL Me\$s493\$ cAN @L\$o cont@1n @+T4Chm3n+s which c4n 83 uSEful PHOR EXCh@NGing PhiL3\$ B3+W3en U5ers.";
$lang['forum_settings_help_20'] = "<b>no+E:</b> +Eh Sp@cE 4llOC4T10n fOR pM a++@Chment5 Is +4k3n FR0m e4Ch u5er\$' m4in 4++@chm3n+ 4ll0C4TI0N 4Nd iS n0T In add1+1on +o.";
$lang['forum_settings_help_21'] = "<b>eN4blE 9u3s+ @cC0unt</b> 4LloW\$ visIT0RS +o br0w\$e your pHOrum 4ND r3@d P0s+s WI+h0ut R39iS+eriNG a UsER 4cCoun+. @ UsER 4Cc0UNT IS s+ill R3qu1rEd 1f +H3Y wIsh +0 PO\$t 0r cHAn93 U\$eR PRef3R3NceS.";
$lang['forum_settings_help_22'] = "<b>l1ST 9u3\$ts 1N v151+0R lOg</b> @LL0W\$ J00 T0 SPeC1phY WH3thER 0r no+ unre9is+3R3d User\$ @rE lIst3D 0N +eH viS1tOr lo9 4l0ngS1DE REgISt3r3d u\$erS.";
$lang['forum_settings_help_23'] = "b33hIVE 4Ll0w\$ 4T+4chM3nt\$ +0 b3 uplo4D3D +0 M35s4g3s WH3n pOs+3D. 1f J00 h@Ve l1M1+ed w38 sp@C3 J00 m4y wH1ch +O dIS48le @++4chmentS 8y CLe4r1n9 +he 8ox 4B0ve.";
$lang['forum_settings_help_24'] = "<b>aTT4Chm3n+ dir</b> 1\$ +h3 l0C4+10n 83eh1v3 SHoULD s+0r3 4Tt@cHMeNT\$ 1n. tH1\$ d1r3C+0ry MUsT ExiS+ on YouR wE8 SP4cE 4nd MUst 83 wr1+48LE 8y t3h W38 SErv3r / PHP proc35s oTh3rw15E upl04Ds WIll f41l.";
$lang['forum_settings_help_25'] = "<b>a+taCHm3n+ 5p4cE P3r uSEr</b> I5 th3 m4X1mum @M0un+ 0f D15k SP4C3 4 useR haS PH0R 4++4chmeNtS. OnCE +hi\$ SP@Ce 1\$ used up +3h uS3R c@nnoT UPlo4d 4ny m0RE 4+T4chments. BY d3F4ul+ +hiS is 1M8 opH 5pac3.";
$lang['forum_settings_help_26'] = "<b>aLl0w eM8edd1N9 0ph 4t+Achm3n+5 IN M3ssAG3s / SIgn4+Ures</b> @LL0W\$ uSEr5 tO em83D @tt4chm3ntS 1N P0stS. 3n@8L1Ng TH1S 0ptioN WHil3 u\$EPHul c@N 1nCr34se y0uR B4ndw1dtH us493 dr4sTIc4LLY UnD3R C3r+41n c0nphI9URA+10N5 of PHp. 1F j00 H4ve L1M1+eD 84NdWID+H 1+ I\$ recoMmended TH4+ J00 di\$4ble Th1\$ 0p+I0n.";
$lang['forum_settings_help_27'] = "<b>u53 @L+3RN@tIv3 @+tacHM3N+ metHOd</b> Ph0rc3s 83EhiV3 to u\$3 4n 4lt3RN4+1ve ReTRI3v@l M3+hod fOR @T+@chm3n+S. 1f j00 rec31VE 404 Err0r Mes5A93\$ wh3n +RY1n9 TO dOWNLOAd 4ttachm3N+S fr0m mE\$s4ge\$ +ry enabl1n9 Th1\$ 0P+10N.";
$lang['forum_settings_help_28'] = "tH3\$e SeT+1nGS 4lloWs y0Ur forum t0 83 SP1D3red By SeArcH 3NG1n3\$ l1k3 g0ogL3, 4LT@V15+4 @nD Y4h00. iF j00 swITch +h1\$ op+iON 0PHf YOur fORuM w1ll n0+ Be 1nclud3D IN tHEsE \$eARcH 3nGInE\$ r3\$UlT\$.";
$lang['forum_settings_help_29'] = "<b>alLOW neW u\$Er Reg1\$tr@+IoNS</b> 4llOw\$ 0R DisALloWS +h3 CR3a+10n opH n3w US3r @ccOuntS. se+tIN9 +3h 0PT10n TO nO comple+3lY disabl3\$ +h3 r391\$TR4t10n FORm.";
$lang['forum_settings_help_30'] = "<b>eN4bl3 W1k1w1kI in+Egr@+1oN</b> Prov1Des w1kiwoRD 5upp0r+ in Y0ur pHOruM po\$T5. 4 w1kIW0rd iS m4D3 UP of +W0 0r mOR3 C0nc4+EN@+3d woRDs w1+H uPP3rc@SE Le+t3rs (0ften REpheRReD +O 4\$ C@MElc45e). iF j00 WRIt3 a wORd +HI\$ w@y It W1lL AU+om4T1C@lLY b3 ch4nGED 1n+0 @ hyp3rLInk P01n+1n9 T0 YoUR ChoSEn w1K1W1K1.";
$lang['forum_settings_help_31'] = "<b>eN48L3 w1k1WiKI qu1cK L1nk5</b> 3n4ble\$ t3h uS3 OF mS9:1.1 4ND usER:lOGon \$tYLE 3xTEndEd WIk1l1nk\$ WhiCH cr3@Te HYPerL1NkS +0 +H3 \$p3c1PH13d MES\$4GE / u\$eR pr0f1l3 0f +H3 \$PecipHIed us3r.";
$lang['forum_settings_help_32'] = "<b>wiKiWik1 loc4tioN</b> is uS3D +0 SpEC1PhY teh Uri 0PH Y0UR W1K1W1KI. wHEn enteRIng +h3 uR1 use <i>%1\$S</i> +0 1nd1C4+e wH3R3 in th3 ur1 the Wik1w0rd SH0uld @ppe@r, I.3.: <i>h++P://3N.WIkipedi4.0rG/wiKI/%1\$5</i> w0ULD l1nk yoUR w1K1WorDS tO %s";
$lang['forum_settings_help_33'] = "<b>fOrum 4CC3\$s \$+A+uS</b> C0n+ROLS h0w userS M@Y @Cc3S5 y0ur FOrUM.";
$lang['forum_settings_help_34'] = "<b>oP3n</b> wILL @ll0w @lL u5ERS 4Nd 9uesTs 4cC3ss t0 Y0uR f0RUm WIth0u+ R3\$Tric+iOn.";
$lang['forum_settings_help_35'] = "<b>cLos3D</b> pr3VEn+S 4cC3s\$ ph0r @Ll uS3RS, wITh +3H eXCEptION of tH3 admin WH0 m@Y STilL @Cc3Ss teh 4dmIN Pan3l.";
$lang['forum_settings_help_36'] = "<b>r3Stric+ED</b> 4LloW\$ +O sE+ 4 lISt 0F u5eRs WHo 4r3 4ll0wed 4Cce\$s +0 Y0ur f0rUM.";
$lang['forum_settings_help_37'] = "<b>p4S\$woRD Prot3CT3d</b> 4lLOw\$ j00 T0 \$ET 4 p4sSW0rd +0 Giv3 Ou+ +o USErs s0 they c4n @cCe\$s Y0UR ForuM.";
$lang['forum_settings_help_38'] = "whEn s3+tin9 re\$tricT3D 0r P@\$sw0rD ProTEC+Ed mODE j00 will Ne3D T0 s4ve your cH@NgE\$ b3phoR3 J00 C4n ch4nge th3 USEr @cc3\$S pR1vIL39Es oR p4\$\$Word.";
$lang['forum_settings_help_39'] = "<b>Search Frequency</b> defines how long a user must wait before performing another search. Searches place a high demand on the database so it is recommended that you set this to at least 30 seconds to prevent \"search spamming\"pHRom KiLLiNG +3H S3rVEr.";
$lang['forum_settings_help_40'] = "<b>poS+ frequenCY</b> Is teh mINiMum +Im3 4 U\$Er mus+ w4i+ bEphoRe +h3y C4n p0\$t 494IN. this 5E+Tin9 4lsO 4fPH3cT5 Teh cr34+1On 0f p0ll\$. \$Et to 0 T0 D15ABl3 +h3 R3S+r1C+10N.";
$lang['forum_settings_help_41'] = "the 480VE OPT10n\$ ch4n93 +H3 D3ph4ulT v4lues ph0R TeH Us3r Re91\$TR4+10n PHorM. wher3 4PPlic48l3 0th3r SE++in9S w1ll U5e tH3 pHoRUm'S oWN dEPH4ul+ S3T+inG\$.";
$lang['forum_settings_help_42'] = "<b>pReV3N+ Use 0f Dupl1CA+e 3m@1l 4ddre5ses</b> phoRCE\$ Be3h1ve +0 cHeck TH3 u\$eR 4cC0un+s @94insT TEh em41l 4ddr3SS the u\$Er 15 re91\$+3RIng WiTH @nd PrOMp+S +H3M t0 Us3 4N0theR 1f 1t I\$ ALREaDY in US3.";
$lang['forum_settings_help_43'] = "<b>r3QU1R3 3m@1L CoNPHIrm4+10n</b> wH3n eN@8led w1LL send 4n 3m@1L +0 e4ch N3w US3R w1Th 4 liNK +hA+ C4N BE U\$Ed tO c0npHIrm ThE1r 3m@1L 4Ddr3S\$. un+IL +H3Y c0NPHirM THeir eM4Il 4Ddr3sS +H3Y W1LL n0+ b3 @bl3 +o po\$+ uNLes5 +H31R U\$ER peRMisS10Ns aRE ch4NGed m4nu4LLY bY @N 4dM1n.";
$lang['forum_settings_help_44'] = "<b>u\$3 TEXT-c@p+cH4</b> pr3s3n+S tHE n3w User WI+H 4 m4NGl3d 1m@93 WHIcH Th3y MU5+ coPY A nuMb3r Phr0m In+0 A t3xT f13ld ON +Eh r39is+R@TI0N pH0Rm. u\$3 th1\$ 0PTION t0 pR3VEnt 4uTOM4t3d S1GN-up v1@ \$cripT\$.";
$lang['forum_settings_help_47'] = "<b>po\$T EdI+ gr4Ce P3RIOD</b> 4ll0W\$ J00 TO d3phiNE a P3rioD IN m1NUt3s Wh3r3 u\$erS M@Y 3d1T P0\$+s WitH0u+ +He 'edit3d 8y' t3x+ 4Pp34R1n9 0N ThE1r PoS+S. IF SE+ T0 0 t3h 'EDit3d By' t3x+ will 4lWAys App3@r.";
$lang['forum_settings_help_48'] = "<b>uNR3@D M3s5AGE\$ cu+-OFF</b> \$pEcifi3\$ H0w Lon9 m3S\$49E\$ R3M4IN unR34d. Thre4ds M0DiFIed nO l4ter Th4n Th3 p3ri0d S3L3C+ed wILl @U+Om4+1C@Lly 4Pp34R 4S read.";
$lang['forum_settings_help_49'] = "ch00siN9 <b>d1\$@ble unr34d me\$s493s</b> WilL c0mPLE+3LY r3mov3 uNR34d m3\$S4g3s \$uPP0R+ 4nd r3MOV3 +H3 r3l3v@Nt 0ptiONS phR0M +eh dIScu\$s1oN tyPe droP DOWn ON +h3 +hre4d lI\$T.";
$lang['forum_settings_help_50'] = "<b>r3qUir3 UseR @pPRoVal 8Y 4dmIN</b> AllOws J00 To R35TRIc+ 4cc3sS 8y N3W us3RS UntIL +H3y H4ve 83en 4Pprov3D bY 4 MOd3R@T0r Or @dMIN. w1+H0u+ AppROV4L a usER caNN0+ 4cce\$s 4NY 4RE@ OF tH3 Be3hiv3 fORum 1nSt@lL@t10N InCludin9 1ndiVIduaL f0rum\$, pm inBOx @nd My ph0RUM\$ 5EC+10n\$.";
$lang['forum_settings_help_51'] = "uSE <b>cL0S3D mE\$S@g3</b>, <b>r3S+R1cT3d mes\$493</b> 4Nd <b>p@\$sw0rd PRo+ec+3D m3\$s493</b> TO CU\$tOm1se +he Mes\$4gE D1\$pl4y3D when uS3RS @cc3SS y0ur phORum in Th3 VARious S+4te\$.";
$lang['forum_settings_help_52'] = "j00 c@N u\$e h+Ml 1N Y0ur M3s\$4g3S. hYPerl1NK\$ @nd 3m41l 4ddr3\$s3s WILl @l\$O 83 autoM@+1caLLy coNv3RTEd +0 LinkS. t0 u\$e +H3 deF4UL+ b3eh1v3 foRUm m3\$Sa9E\$ Cl3AR +HE f1ELdS.";
$lang['forum_settings_help_53'] = "<b>aLL0W u\$eRS +O cH4n9e usern4me</b> p3rmit\$ AlrEaDY r39i\$T3reD US3rS to ch4nGE +h31r uS3rN@me. wh3N En48LEd j00 c4n TR4CK +Eh ChaN9eS 4 usER m@K3s tO THe1R U\$Ern4me V1@ +he 4DM1n User tO0L5.";
$lang['forum_settings_help_54'] = "u53 <b>fOrum rULes</b> T0 enter AN 4CC3pt48le u5E Pol1Cy THa+ e4ch u\$3R musT 4gr33 T0 83ph0re Re91\$t3R1Ng 0n youR ph0rum.";
$lang['forum_settings_help_55'] = "j00 C@n u\$3 H+ml 1N y0UR forum rULes. hyperl1nk\$ anD eM@1l @ddres\$E\$ wilL 4lsO Be 4u+om4+1c4lLY CONverted t0 LInkS. to U5e T3h dEPH@ult 8e3HIv3 ph0ruM @up CL3@r +h3 pH13Ld.";
$lang['forum_settings_help_56'] = "usE <b>n0-R3plY 3mA1L</b> T0 spEC1PHY @n em41L @ddreS\$ tH4t d0E5 No+ 3xI\$T 0r W1Ll noT b3 mON1T0red fOr r3pLIe\$. tH1\$ Em4IL @DDr3\$s W1LL B3 uSEd iN th3 h34dERs pH0R @ll eM@1lS 5enT fRom Y0ur FOrum iNCluDING 8uT no+ lIMi+ed +o pOsT 4nD pm N0T1f1c4+1oN\$, UseR eM41Ls @nD p4SsW0RD ReM1ND3Rs.";
$lang['forum_settings_help_57'] = "iT is ReC0mM3nded TH@+ J00 us3 @n Em4IL Addr3\$S TH4t d0e\$ noT exi\$T +O h3lp cU+ d0WN ON 5p4m Th4t m4y b3 D1ReC+3D 4t YOUr m41n pHorUm 3M4il @ddres\$";
$lang['forum_settings_help_58'] = "in 4ddit10n TO S1mpL3 spiderIN9, 8e3hIV3 C4n @l5o 93N3r@T3 a s1+3MAP pHor TEh fOruM T0 m@K3 1+ 34s13r f0r se@Rch EnG1ne\$ +0 pH1Nd @Nd 1nd3x Th3 meSsaGes pOst3D 8Y yoUr USEr5.";
$lang['forum_settings_help_59'] = "si+3m@P\$ aRE 4uTOma+Ic@lLY \$@Ved tO T3H s1+3m4ps sub-dir3c+0ry Oph y0Ur beeh1v3 foRUm inSt@ll4Ti0n. 1F +hiS dir3c+0RY doesn'+ eX1\$T j00 mu\$t crE@t3 IT 4nd 3nSUr3 +h@t i+ 1\$ WR1+48LE By the SErver / PHp pr0c3\$\$. +0 4lLOW 5eaRcH 3ngiN3S +o Find YouR s1t3m4p j00 mu\$T 4dd Th3 uRL To Y0UR R08Ot\$.+XT.";
$lang['forum_settings_help_60'] = "dEPENdIn9 ON serVEr PErfoRM4ncE 4nD +eh numb3r OF FORums 4nd thRE@D\$ y0UR 833H1V3 InST@llA+1on c0n+@1N\$, GEnER@+iNG @ \$1+3M4P may tAKe SEv3r@L miNUte\$ +O c0mpLe+E. 1ph P3rPHOrm4nC3 oF your SErv3r 1s 4dv3r\$Ely 4fF3c+3D 1+ 1s rEcomM3nd j00 d1\$48l3 93n3R@+IoN OF +3h 51tem4P.";
$lang['forum_settings_help_61'] = "<b>s3nD em4iL N0tiPH1c4+i0n t0 9LO84l admIN</b> wh3n En4bled wILl SEnd AN 3m@1L t0 +3h 9lOb4l F0rum 0wNER5 Wh3n 4 N3W us3r 4ccoUNt 1S cr3a+eD.";
$lang['forum_settings_help_61'] = "en+er Y0uR <b>g0oGL3 4naLYTIcs 4cc0un+ 1d</b> H3RE tO 3n@8L3 G0oGL3 4n@LYT1c tR4ck1n9 of Y0Ur f0rUM. 900gl3 4N4ly+1C\$ w1lL tr4ck V1\$1ToRS T0 Y0uR si+3 @nD ReC0rd hoW lON9 theY ST4y 4Nd Wh1Ch pA9E\$ +h3y V1S1T. bY v1\$1+1NG +3h 9O0gL3 @N@lY+1C\$ 51+e J00 C@N s33 4N oVERVIEw OF hoW Y0Ur foRum I\$ uSEd.";
$lang['forum_settings_help_62'] = "If you do not have a Google Analytics Account you will need to sign up for one by clicking <a href=\"https://www.google.com/analytics/\" target=\"_blank\">here</4 >.";
$lang['forum_settings_help_63'] = "If you do not have a Google AdSense Account you will need to sign up for one by clicking <a href=\"https://www.google.com/adsense/\" target=\"_blank\">here</@ >.";
$lang['forum_settings_help_64'] = "iF j00 wi\$h +O en@BL3 0R D1\$48l3 go0gl3 @d\$En\$E @d\$ On @ p@R+icul@R forum J00 c@N dO So 8y v1\$1+inG th@T FoRUM's Phorum Set+1ng\$ p@93.";
$lang['forum_settings_help_65'] = "t0 cH@N9e GOO9LE 4DSEn\$3 4cc0uNT de+4ilS 4nd 0+h3r settIN9s pL34SE \$e3 9lO8@l PHOrum S3t+INg\$";
$lang['forum_settings_help_66'] = "yOur 8EEh1Ve forum Supp0R+s 2 d1phF3rent 5IZEs OF <b>g0oGl3 4dSen\$3</b> 4dveR+5. 3nter The 5l0t IDs 0PH teH r3l3V4nt \$iZEd @d5 iNTo tEh b0XeS 480Ve 4nD 83eh1ve wILl @Ut0m@T1c@LLy cho0SE +h3 coRR3C+ 4D pH0R 3ach p49E.";
$lang['forum_settings_help_67'] = "s3lEC+ +he <b>m@IL Phuncti0N</b> SuiT@8le PhoR Y0ur Server. bY deF4ulT yOUr b3eH1v3 FoRum WilL uS3 PHp'5 8UILt-1n m41L FuNc+10N. 1pH +HI5 DO3sN'+ W0rk oR J00 pr3pHEr +0 u\$3 an0tHer M3+hod +0 5eNd 3m41L\$ phrom Y0UR serV3R j00 Can 5eL3c+ 1t Her3.";
$lang['forum_settings_help_68'] = "<b>iMp0RT4N+:</b> iPH J00 4rE Un\$Ur3 wH4T se+tIN9S +0 uSE ph0r SEnD1nG 3M41l Pl3@\$e C0NsuLT Y0uR H05+1NG PROv1D3r's D0CuM3NT4T10N.";
$lang['forum_settings_help_69'] = "y0Ur <b>f0ruM r00T URi</b> Is Th3 4Ddre\$S +0 yOUr f0rum, 3XcLudING the F1le P4+H 4nd QUery \$tr1ng. eX@mplE: <i>h++P://www.b3ehiVEphoRUm.N3T/forum</i>";
$lang['forum_settings_help_70'] = "<b>impoRt4N+:</b> oNLy enTEr A <b>f0rum R0o+ UR1</b> 1F B3Ehiv3 pH4il5 TO 4UtomAt1C@lLY de+ecT y0ur ph0rUM'5 uRI 0r If i+ de+3ct5 TH3 wroN9 v4lue. enTEr1n9 4n IncorREC+ V4LU3 COUlD m4ke S0M3 4r3a\$ oF Y0ur B3EH1V3 pHORUm 1nst@Ll@tI0n In4Cc3SS18L3.";

// Attachments (attachments.php, get_attachment.php) ---------------------------------------

$lang['aidnotspecified'] = "a1d N0T sp3C1Ph13D.";
$lang['upload'] = "uPLo4d";
$lang['uploadnewattachment'] = "uPl04d new 4++aChM3N+";
$lang['waitdotdot'] = "wa1+..";
$lang['successfullyuploaded'] = "sUcCesSphulLY upL04ded: %s";
$lang['failedtoupload'] = "f4iL3d To UPL0@d: %s. ch3Ck pHr33 @T+4chM3n+ 5P@cE!";
$lang['mimetypenotallowed'] = "f4Il3D +O uPL04d: %s. PH1l3 +YPe IS N0T @ll0W3D!";
$lang['complete'] = "coMplE+3";
$lang['uploadattachment'] = "uPL04d @ pHIl3 PH0r @+tAcHM3n+ +0 +eh M3ssA9E";
$lang['enterfilenamestoupload'] = "ent3r fiLEN4m3(S) T0 UPLO@d";
$lang['uploadanotherattachment'] = "uplo4D 4no+her 4t+4Chm3NT";
$lang['attachmentsforthismessage'] = "atT@chment\$ pH0r +his MES\$a93";
$lang['otherattachmentsincludingpm'] = "otHeR 4T+4CHm3ntS (1nCLUd1Ng pM Me\$s@g3s @ND oTHer ForuM5)";
$lang['totalsize'] = "t0+4l \$1Z3";
$lang['freespace'] = "free \$pAc3";
$lang['attachmentproblem'] = "tHer3 w@S @ PRobLEm d0WNlo4d1ng +HIs Att@chmen+. PLe4\$e +ry 494in l4+er.";
$lang['attachmentshavebeendisabled'] = "a+t@ChMenTS H@v3 83en d1S48l3d 8y T3H F0ruM owN3R.";
$lang['canonlyuploadmaximum'] = "j00 c@n 0NLy upl0@d @ maX1MUm 0f 10 f1l3\$ 4t 4 T1Me";
$lang['deleteattachments'] = "dELe+e A+t@cHMENt5";
$lang['deleteattachmentsconfirm'] = "ar3 j00 suR3 J00 W@n+ +0 d3le+3 th3 Sel3C+3d 4TT@chmeNts?";
$lang['deletethumbnailsconfirm'] = "ar3 j00 5urE J00 w@N+ +O del3+e +h3 \$El3c+3D 4++AcHM3n+s Thumbn41L\$?";
$lang['failedtodeleteallselectedattachments'] = "f41l3D +0 D3l3+3 4ll Of +h3 \$eL3c+3D A+T@CHm3NTS";
$lang['failedtodeleteallselectedattachmentthumbnails'] = "faiL3D +0 D3lete @ll OPh +HE sELeCted 4t+4Chm3NT THuMbN@1lS";

// Changing passwords (change_pw.php) ----------------------------------

$lang['passwdchanged'] = "p@SSW0rd ch4ngeD";
$lang['passedchangedexp'] = "your p@\$sw0Rd H4S b3EN cH@nged.";
$lang['updatefailed'] = "upd@+3 ph4IL3d";
$lang['passwdsdonotmatch'] = "p@\$sw0Rd\$ d0 N0T m4tcH.";
$lang['newandoldpasswdarethesame'] = "n3w And oLD p4sSW0rd\$ ar3 +eh \$@M3.";
$lang['requiredinformationnotfound'] = "r3QU1reD 1NFOrmATIOn N0+ phOUnD";
$lang['forgotpasswd'] = "fOr90+ p4s\$w0rd";
$lang['resetpassword'] = "rESe+ P45sw0rD";
$lang['resetpasswordto'] = "r3Set P4S\$WoRD +O";
$lang['invaliduseraccount'] = "iNV@Lid UseR 4cc0UN+ \$peCIPh1eD. ch3CK 3m4IL phoR cORR3Ct liNK";
$lang['invaliduserkeyprovided'] = "inV4lid uSEr KEy prOv1Ded. checK Em@1l Ph0r c0rr3ct L1nk";

// Deleting messages (delete.php) --------------------------------------

$lang['nomessagespecifiedfordel'] = "n0 M3s\$4ge Sp3c1PH1ED phoR d3l3+iON";
$lang['deletemessage'] = "dEle+e M3s\$4G3";
$lang['successfullydeletedpost'] = "suCC3ssPhullY del3T3d P0\$t %s";
$lang['errordelpost'] = "erR0R d3L3tinG P0s+";
$lang['cannotdeletepostsinthisfolder'] = "j00 C4NnoT d3L3+e pO\$T5 In tHI\$ PH0lD3R";

// Editing things (edit.php, edit_poll.php) -----------------------------------------

$lang['nomessagespecifiedforedit'] = "nO ME\$S@9E \$P3c1Ph1ed F0R 3DI+ING";
$lang['cannoteditpollsinlightmode'] = "c@NnOT 3DI+ p0LLS IN L1gh+ M0dE";
$lang['editedbyuser'] = "eD1+ed: %s BY %s";
$lang['successfullyeditedpost'] = "succESsPHully ediT3D p0sT %s";
$lang['errorupdatingpost'] = "errOr upd@tIN9 P0S+";
$lang['editmessage'] = "eDI+ Mes\$4g3 %s";
$lang['editpollwarning'] = "<b>nOT3</b>: 3dit1n9 cerT4in A\$p3C+S oF @ p0lL W1LL vOId 4lL t3h cUrRen+ v0tes 4nd @LLow Pe0pl3 +0 v0+3 Ag41n.";
$lang['hardedit'] = "h4RD Ed1T 0p+1ons (VO+3S W1LL B3 Res3t):";
$lang['softedit'] = "s0Pht 3DI+ 0p+Ion\$ (vO+e5 w1ll b3 r3t@IN3d):";
$lang['changewhenpollcloses'] = "ch@NGE wh3N t3H PoLl cl0\$Es?";
$lang['nochange'] = "n0 ch@N9e";
$lang['emailresult'] = "eM41l r3\$Ul+";
$lang['msgsent'] = "m3Ss4g3 \$ENT";
$lang['msgsentsuccessfully'] = "me\$\$4GE \$EnT SUCcES\$Fully.";
$lang['mailsystemfailure'] = "m4iL Sy\$T3M ph@1lUR3. me\$sa93 n0+ \$enT.";
$lang['nopermissiontoedit'] = "j00 ARe no+ perm1+ted +0 EDi+ th15 M3\$S493.";
$lang['cannoteditpostsinthisfolder'] = "j00 c@NN0+ 3di+ p0S+s In tH1S pH0LDEr";
$lang['messagewasnotfound'] = "meSsa93 %s w@s No+ PH0Und";

// Email (email.php) ---------------------------------------------------

$lang['sendemailtouser'] = "s3nD 3M4il +o %s";
$lang['nouserspecifiedforemail'] = "n0 uSer \$peciPHIEd foR 3m@1liNG.";
$lang['entersubjectformessage'] = "en+er @ 5uBject foR +3H M35s4ge";
$lang['entercontentformessage'] = "eNT3r sOMe C0n+eNT Ph0r +h3 me5s493";
$lang['msgsentfromby'] = "th1\$ meS\$4G3 w@S \$eNT fr0M %s 8y %s";
$lang['subject'] = "sU8J3c+";
$lang['send'] = "s3nD";
$lang['userhasoptedoutofemail'] = "%s H4s 0ptED ou+ OF 3m41L C0N+4C+";
$lang['userhasinvalidemailaddress'] = "%s h4s @n INv4l1D 3m@1L 4ddr3sS";
$lang['useemailaddrtosendmsg'] = "uS3 MY r3al em4il @ddrE\$S +0 \$End tH1S m3\$\$@93";

// Message nofificaiton ------------------------------------------------

$lang['msgnotification_subject'] = "mES\$AGE NOTIfic@+ioN frOM %s";
$lang['msgnotificationemail'] = "hElLO %s,\n\n%s P05+3d 4 M3s54gE to J00 on %s.\n\n+h3 \$uBJ3c+ 1S: %s.\n\n+o r34D +H4T ME\$S49E @nD 0tH3R\$ iN TH3 s4me discusS10n, 90 +0:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nnotE: 1PH j00 D0 no+ wi\$h +O R3CEiv3 EM41l n0tif1c4+iOns 0F PH0ruM ME\$s49Es Po\$+eD T0 Y0u, Go T0: %s cl1CK 0N my CoNtrOls Then 3M4Il 4nd priv4cy, UN53LECT +hE 3M4IL nOtIFiC4TIOn Ch3ckb0x 4nD PreS\$ SUBmI+.";

// Thread Subscription notification ------------------------------------

$lang['threadsubnotification_subject'] = "su8sCr1p+ioN notific4+1ON fRoM %s";
$lang['threadsubnotification'] = "h3Llo %s,\n\n%s P0s+3D 4 m3\$s4gE iN 4 thR34d j00 h4ve \$UBscr1b3d TO On %s.\n\nThe 5ubjEc+ 1\$: %s.\n\ntO R34d +H4+ MeS54g3 4nd 0therS 1N +eH saM3 D1\$Cus\$1on, 90 +o:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nn0+e: 1f J00 dO N0+ w1sH t0 REc31ve Em4iL n0T1Ph1C@+10n\$ Of N3W me\$s@9e\$ IN +hiS THr34d, 9o +0: %s 4ND AdjusT YOUR INT3R3\$t L3V3L @+ +EH B0T+om 0F t3H P@9e.";

// Folder Subscription notification ------------------------------------

$lang['foldersubnotification_subject'] = "sUBscripTI0N notif1ca+1oN frOM %s";
$lang['foldersubnotification'] = "h3Llo %s,\n\n%s P0s+3d @ meS54ge 1n 4 ph0LD3R J00 @re \$u8\$CRI8ED +o 0n %s.\n\nTh3 \$uBjeCt 15: %s.\n\n+O r34D TH4+ Me\$S4ge 4ND 0thers 1N +eH same d1\$cU\$S10n, G0 t0:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nNot3: iPH j00 dO NOT WiSh +O rec3iV3 eMAiL NoT1f1C@TI0NS 0f new m3SsAGe5 In Th15 +hre@D, G0 To: %s @Nd @DJus+ yOuR 1nTEreSt lEv3l bY clICkiNg 0n +Eh pHoldeR'\$ ic0N 4+ +Eh +oP oPH P@9e.";

// PM notification -----------------------------------------------------

$lang['pmnotification_subject'] = "pm Not1f1C4+1ON fROm %s";
$lang['pmnotification'] = "h3Ll0 %s,\n\n%s POs+3D 4 pm t0 j00 0n %s.\n\ntHE \$Ubject I\$: %s.\n\nt0 r34d +H3 M3s\$4g3 90 +o:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nn0te: IPH j00 dO n0t w1sH TO r3CE1v3 3m@IL n0tIFIC4+10Ns oF NEw PM m3sSa9e\$ p0\$T3D t0 You, 90 +O: %s cLiCK my C0Ntr0l\$ +H3N EMaIl @nd PR1v4cY, UnSElecT +hE pM n0TipH1Cati0n ChECk8Ox 4Nd Pre\$\$ sU8M1+.";

// Password change notification ----------------------------------------

$lang['passwdchangenotification'] = "p4sSW0rd Ch4nge nOTif1c4t1oN FRom %s";
$lang['pwchangeemail'] = "h3Ll0 %s,\n\n+hi\$ 4 No+iFIC4+IOn eM41l TO inPHorM J00 +Ha+ y0Ur p4sSw0rD 0N %s h4s 8E3n Ch@n9ED.\n\nIt Ha\$ B3EN ch4n93d tO: %s @nd w@\$ Ch4ngEd 8Y: %s.\n\nIF j00 H4vE rec3iv3d +HiS 3M@1l IN 3rr0r OR wER3 NOt EXPeC+1NG 4 ch4nge +0 YOur PaSswoRD Plea\$E coNt@Ct tHE F0ruM 0Wn3r 0R 4 M0d3r4+Or 0N %s iMmed1aT3lY +0 c0RrecT 1+.";

// Email confirmation notification -------------------------------------

$lang['emailconfirmationrequiredsubject'] = "em41l cOnph1rma+10n R3qu1red PHor %s";
$lang['confirmemail'] = "hEllO %s,\n\nY0u recentLY cR3@T3d @ New u\$3r 4cC0Unt 0n %s.\n\nBEph0re J00 C@n s+4Rt P0STinG we n33d TO conPHirM y0ur 3m@1l ADDre5\$. d0n't WOrrY +hI5 I\$ qu1+e 34Sy. 4LL j00 ne3d +0 Do 1s click ThE LiNK b3Low (OR C0Py @nD P45+e 1t INtO Your BrowS3R):\n\n%s\n\nOnc3 c0NPhiRM4+10n I5 c0mPL3t3 j00 M4y L09in AND sT@r+ P0s+1nG imMEd1a+3lY.\n\niF J00 did Not cR34T3 @ User 4CCoUn+ 0n %s PLe4Se @Cc3P+ 0ur 4poLog13s 4ND F0Rw4RD +HIs 3m@1l +O %s \$o TH4T TEh \$0URCe oF i+ M4Y bE 1nve\$TI94ted.";
$lang['confirmchangedemail'] = "h3llo %s,\n\ny0u recenTly cH4n9ed YOUr 3m4il 0N %s.\n\nB3pH0Re j00 c4n S+4r+ P0sT1n9 49@1n WE need T0 C0npH1RM YOUr New Em4Il @DdR3\$s. Don'T Worry TH1\$ 1S qu1te 34sy. 4LL J00 NEEd TO dO 1\$ Cl1ck +h3 LInK B3l0w (0R C0Py And P4s+3 I+ 1nt0 YOUr br0wS3R):\n\n%s\n\noNC3 cOnPH1rM@t10n 1\$ c0mPL3T3 J00 m4y C0n+1nUE +0 u\$E The f0ruM @S n0Rm4l.\n\nipH j00 w3R3 N0t 3XP3Ct1n9 +hi\$ 3M@1l fRoM %s PLeA\$3 4ccEPT oUr @POLo913s 4Nd F0rW@rd +h1\$ 3M@1l +0 %s 50 tH4+ +h3 SouRC3 Of 1+ M4Y 83 Inves+1G4t3D.";

// Forgotten password notification -------------------------------------

$lang['forgotpwemail'] = "h3lL0 %s,\n\nY0u R3QU3\$+ed +hi\$ E-m@Il FR0M %s 83CAu53 j00 h@V3 phorgOt+3n Y0UR P4SsW0rd.\n\nCl1ck tH3 l1nk 83lOW (OR c0pY 4nD p@\$T3 iT 1ntO youR 8r0w\$er) T0 R35ET yoUR p4sSWoRD:\n\n%s";

// Admin New User Approval notification -----------------------------------------

$lang['newuserapprovalsubject'] = "neW us3r @Ppr0V@l n0+IphIc4tioN ph0r %s";
$lang['newuserapprovalemail'] = "Hello %s,\n\nA new user account has been created on %s.\n\nAs you are an Administrator of this forum you are required to approve this user account before it can be used by it's owner.\n\nTo approve this account please visit the Admin Users section and change the filter type to \"Users Awaiting Approval\"oR cLick TH3 lInk bel0w:\n\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nn0+3: 0th3r 4DMIN1s+r@toRs 0n ThiS F0RUm w1lL aLso r3c3iv3 +hiS No+1f1c@t1oN @nd MAY h4ve 4lre4DY @c+ed uPOn Th1S reQUes+.";

// Admin New User notification -----------------------------------------

$lang['newuserregistrationsubject'] = "n3w u\$Er 4cc0un+ n0+ipHiC4TIon PH0r %s";
$lang['newuserregistrationemail'] = "h3Ll0 %s,\n\n@ N3W u\$er 4cC0unt h4S b3EN cRE4tEd on %s.\n\nt0 view tH1s U\$er 4cCouN+ plE@\$3 v1\$i+ +Eh ADm1n u\$3r\$ 53cTI0N 4ND ClICk On TH3 NEw uSEr 0R CLicK tH3 L1nk Bel0W:\n\n%s";

// User Approved notification ------------------------------------------

$lang['useraccountapprovedsubject'] = "u53r 4ppR0V@l n0+1PHIc@t10n foR %s";
$lang['useraccountapprovedemail'] = "h3LLo %s,\n\ny0ur user @ccouN+ @+ %s HA\$ Been 4pPR0v3d. J00 c4n l0G1n 4nd st@r+ P0\$+1n9 Imm3d14t3Ly 8y clickinG +eh lINk b3L0w:\n\n%s\n\n1ph J00 w3re NOT 3xPEC+1n9 tHIs 3m@1l PHROm %s pL3@\$e 4Cc3p+ Our @polO9Ies @Nd FORw4rd Th1s Em@1l +0 %s So +ha+ +Eh S0urCE 0f I+ m4y 83 1NV3\$ti94t3D.";

// Admin Post Approval notification -----------------------------------------

$lang['newpostapprovalsubject'] = "p0S+ 4pPR0VAl NOtiF1c4+10N PhoR %s";
$lang['newpostapprovalemail'] = "h3lL0 %s,\n\n@ NEW P0S+ h@\$ B3eN cr34t3d 0N %s.\n\n4S j00 4re @ Moder@t0R 0n THIS phORum J00 @rE REqU1REd t0 4pPR0v3 +HIS P0s+ B3PH0Re 1+ can B3 r3AD 8y 0+H3R u5ERS.\n\nY0U c4N @PproV3 +h1s Po5+ 4nD 4NY 0tHEr5 p3NdING @ppROv@L By vIsit1n9 The @dM1n P0s+ 4PprOv@L SEc+I0N 0f yOUr phOruM 0R 8Y cLiCKInG +3H l1nK b3Low:\n\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nnO+3: oTher adMinIs+r@+0r\$ 0n tH1s phoRum wIll 4l\$0 rec3Iv3 +h1\$ NoTipH1C4+10n 4Nd M4y h4V3 @lreADy acT3d uPon tH1\$ reQU3S+.";

// Forgotten password form.

$lang['passwdresetrequest'] = "yOur P4ssword res3T rEQu3\$T fRoM %s";
$lang['passwdresetemailsent'] = "p4SSW0rD Rese+ e-mail SEn+";
$lang['passwdresetexp'] = "j00 5houLD SHOr+lY rEceIV3 4n 3-m4il c0n+4in1n9 1nsTRuC+i0n\$ PH0r rE\$3+Tin9 youR p4\$sw0rD.";
$lang['validusernamerequired'] = "a v@lID USErnAMe iS rEQUiR3d";
$lang['forgottenpasswd'] = "f0R9o+ p@sswORd";
$lang['couldnotsendpasswordreminder'] = "c0uLD N0t senD P4\$\$W0RD r3M1ndER. ple4se c0N+@C+ +He f0rum 0wn3r.";
$lang['request'] = "r3QU3S+";

// Email confirmation (confirm_email.php) ------------------------------

$lang['emailconfirmation'] = "em@1l conpHIRM4+1on";
$lang['emailconfirmationcomplete'] = "th4Nk J00 Ph0R C0nPHIRm1nG Y0ur Em@1L @ddRE\$s. j00 MAY n0w LO9iN 4Nd s+@rT p0s+1ng IMM3di@Tely.";
$lang['emailconfirmationfailed'] = "em41l coNPhiRM4+10n H4S ph4il3D, pl3a\$e TRy 4g4IN l@+3R. 1F j00 ENcOUnteR +His 3Rr0r MUL+ipL3 T1ME\$ PLe@SE C0n+4C+ +eH Ph0rum oWN3r oR @ Mod3r4+OR pH0R a5s1st@NC3.";

// Links database (links*.php) -----------------------------------------

$lang['toplevel'] = "t0p L3v3l";
$lang['maynotaccessthissection'] = "j00 m4y n0t @ccESS TH1\$ \$EC+1on.";
$lang['toplevel'] = "t0P leVeL";
$lang['links'] = "l1nKs";
$lang['externallink'] = "ex+ErN4l LINK";
$lang['viewmode'] = "v13w M0DE";
$lang['hierarchical'] = "h13r@RcH1c4l";
$lang['list'] = "li\$T";
$lang['folderhidden'] = "th1s FOlder 1S HIdD3N";
$lang['hide'] = "hIDE";
$lang['unhide'] = "uNHIde";
$lang['nosubfolders'] = "no 5u8ph0lder\$ 1N This C@t390RY";
$lang['1subfolder'] = "1 \$u8pH0LD3r 1n Th15 C@+390Ry";
$lang['subfoldersinthiscategory'] = "su8foLDErs 1N +hiS c@TEG0Ry";
$lang['linksdelexp'] = "entR135 1N @ D3l3+3d foLD3r w1ll b3 MOVeD +o THe P@ren+ phOld3r. ONlY ph0LDer5 WH1ch D0 n0t C0n+4iN \$U8phOld3r5 M4Y b3 D3LEt3d.";
$lang['listview'] = "liSt V1ew";
$lang['listviewcannotaddfolders'] = "c4nn0t @Dd f0ldeRS in +HI\$ View. \$H0w1ng 20 entr1ES 4+ a T1ME.";
$lang['rating'] = "r@+inG";
$lang['nolinksinfolder'] = "nO l1NKs IN th1\$ fOLd3r.";
$lang['addlinkhere'] = "adD LINK hER3";
$lang['notvalidURI'] = "th@T 1\$ NO+ 4 V4lID urI!";
$lang['mustspecifyname'] = "j00 MU5+ \$peCipHY 4 N4ME!";
$lang['mustspecifyvalidfolder'] = "j00 MU\$+ Sp3C1fy 4 V@lid fOld3R!";
$lang['mustspecifyfolder'] = "j00 MuS+ \$PecIFY 4 pH0ld3R!";
$lang['successfullyaddedlinkname'] = "sucCessPHULly 4dded lINk '%s'";
$lang['failedtoaddlink'] = "f41l3d t0 @dd L1Nk";
$lang['failedtoaddfolder'] = "f@Iled +o 4Dd fOLdEr";
$lang['addlink'] = "aDd 4 L1NK";
$lang['addinglinkin'] = "adD1N9 l1NK 1n";
$lang['addressurluri'] = "adDre5s";
$lang['addnewfolder'] = "aDD 4 N3W foLd3r";
$lang['addnewfolderunder'] = "add1n9 NeW Ph0lder UNdER";
$lang['editfolder'] = "eD1+ pHOlder";
$lang['editingfolder'] = "ediT1nG F0LdER";
$lang['mustchooserating'] = "j00 MU\$+ Ch0o5E 4 ra+1n9!";
$lang['commentadded'] = "y0Ur CommenT W4s 4DD3d.";
$lang['commentdeleted'] = "comM3n+ W4\$ d3l3+3d.";
$lang['commentcouldnotbedeleted'] = "coMment C0ulD nOt 8e deL3+ed.";
$lang['musttypecomment'] = "j00 mu\$t tYPe @ c0mM3nT!";
$lang['mustprovidelinkID'] = "j00 MUs+ ProV1DE @ Link id!";
$lang['invalidlinkID'] = "inV4lid l1nK 1d!";
$lang['address'] = "aDdREs5";
$lang['submittedby'] = "sUbmI+TEd 8y";
$lang['clicks'] = "cLickS";
$lang['rating'] = "rAT1N9";
$lang['vote'] = "vo+E";
$lang['votes'] = "v0+e\$";
$lang['notratedyet'] = "noT R4+eD bY 4NY0nE YE+";
$lang['rate'] = "ratE";
$lang['bad'] = "b4D";
$lang['good'] = "gooD";
$lang['voteexcmark'] = "vOT3!";
$lang['clearvote'] = "cL3@R voTE";
$lang['commentby'] = "c0Mm3nt 8Y %s";
$lang['addacommentabout'] = "adD 4 coMMenT aboU+";
$lang['modtools'] = "m0der@TIon +0OLs";
$lang['editname'] = "eDi+ N4mE";
$lang['editaddress'] = "edi+ 4dDres\$";
$lang['editdescription'] = "ed1T de\$cripTion";
$lang['moveto'] = "mOvE +O";
$lang['linkdetails'] = "linK D3+4ilS";
$lang['addcomment'] = "adD c0MMent";
$lang['voterecorded'] = "your v0t3 H4\$ b3en r3cord3D";
$lang['votecleared'] = "yOur VoTE h4\$ b3EN cl3AreD";
$lang['linknametoolong'] = "liNk N@m3 tO0 L0n9. M4xIMUm 1S %s cHAr4CTeRs";
$lang['linkurltoolong'] = "lInK urL t0o LOn9. m@X1Mum I\$ %s Ch@r@c+3r\$";
$lang['linkfoldernametoolong'] = "f0Ld3R N4M3 To0 L0n9. M4x1mUM L3ngtH 15 %s CHAR@Ct3r\$";

// Login / logout (llogon.php, logon.php, logout.php) -----------------------------------------

$lang['loggedinsuccessfully'] = "j00 l0G93d 1n 5ucce\$sphully.";
$lang['presscontinuetoresend'] = "prEs\$ c0N+Inu3 T0 R3S3nD F0Rm D4ta OR c4ncel +0 r3lo4d pA9e.";
$lang['usernameorpasswdnotvalid'] = "t3h Usern@Me Or p4\$\$w0RD j00 SUpPLI3D IS N0T vALiD.";
$lang['youhavesuccessfullyloggedout'] = "j00 H4V3 sUCCe\$SpHUllY l09g3d OUt.";
$lang['rememberpasswds'] = "reMem8er P@sSw0rd\$";
$lang['rememberpassword'] = "r3m3mb3R p4sSWORd";
$lang['logmeinautomatically'] = "lOG ME 1n 4UT0M4t1c@llY";
$lang['enterasa'] = "enTer 4\$ @ %s";
$lang['donthaveanaccount'] = "d0N't HAV3 4N @ccounT? %s";
$lang['registernow'] = "r3GI\$t3r Now";
$lang['problemsloggingon'] = "pro8lEm\$ L0991NG oN?";
$lang['deletecookies'] = "dELE+e c00ki3s";
$lang['cookiessuccessfullydeleted'] = "cO0k13s 5UccEs\$phuLLy dEle+ed";
$lang['forgottenpasswd'] = "for9oT+En yOUr p4s5WORd?";
$lang['usingaPDA'] = "u51ng 4 PD4?";
$lang['lightHTMLversion'] = "lI9HT HTML Ver5I0N";
$lang['logonbutton'] = "lOG0n";
$lang['otherdotdotdot'] = "o+HER...";
$lang['yoursessionhasexpired'] = "yOuR \$Es5i0n h45 exPir3D. J00 w1lL Ne3D +0 Lo9In ag41N +O CoN+1nue.";

// My Forums (forums.php) ---------------------------------------------------------

$lang['myforums'] = "mY pHorUM5";
$lang['allavailableforums'] = "aLl 4Va1l48lE PhORuM\$";
$lang['favouriteforums'] = "f4v0urIt3 PH0rUm\$";
$lang['ignoredforums'] = "igNor3d FoRumS";
$lang['ignoreforum'] = "igNor3 pH0RuM";
$lang['unignoreforum'] = "uN1GN0Re foRUM";
$lang['lastvisited'] = "l4\$T VIS1Ted";
$lang['forumunreadmessages'] = "%s UnR34D me\$sa93\$";
$lang['forummessages'] = "%s M3\$s@G35";
$lang['forumunreadtome'] = "%s uNre4d &quot;To: M3&quot;";
$lang['forumnounreadmessages'] = "nO Unr3@d mE5\$@9e\$";
$lang['removefromfavourites'] = "rEMov3 Phr0m PHav0uri+3S";
$lang['addtofavourites'] = "adD to f4v0uriT3s";
$lang['availableforums'] = "av@1l4Ble forum\$";
$lang['noforumsofselectedtype'] = "tHeRE aRE n0 Ph0ruM\$ of +Eh S3L3Cted +YPe 4v41l@8L3. PLe4se \$El3C+ A D1PHf3reNT type.";
$lang['successfullyaddedforumtofavourites'] = "suCC3ssphUlLY 4DdeD fOrum tO pH@v0UR1+E5.";
$lang['successfullyremovedforumfromfavourites'] = "sUCCes5fulLY ReM0v3d fORum PHRoM PH4vouR1te\$.";
$lang['successfullyignoredforum'] = "sUCcESSPhuLLy 1gnor3d f0rUM.";
$lang['successfullyunignoredforum'] = "sUccesSPHUllY UN1gn0rEd pH0ruM.";
$lang['failedtoupdateforuminterestlevel'] = "f4IL3d To upd4+e pHORUm 1n+3reS+ lev3l";
$lang['noforumsavailablelogin'] = "thEr3 @r3 N0 Ph0RumS 4v@1l48L3. pl34se LOgiN +O view Y0ur F0RUMs.";
$lang['passwdprotectedforum'] = "p@S5w0rd pROTEC+ed f0rum";
$lang['passwdprotectedwarning'] = "thIs fORum 1S p@SSW0rd Pr0t3C+3D. +o G41n 4Cc3\$s 3NT3r +h3 P@5sw0rD 83l0w.";

// Message composition (post.php, lpost.php) --------------------------------------

$lang['postmessage'] = "pOS+ m3s54ge";
$lang['selectfolder'] = "s3L3CT foLd3r";
$lang['mustenterpostcontent'] = "j00 Mu5t ENt3r SOme c0n+En+ Ph0r +eH pOs+!";
$lang['messagepreview'] = "mes\$4gE pR3viEW";
$lang['invalidusername'] = "iNv@L1D usern@M3!";
$lang['mustenterthreadtitle'] = "j00 Mu\$t eN+3R 4 TItl3 PHor T3h tHre4d!";
$lang['pleaseselectfolder'] = "plE4\$E SEl3CT 4 fold3r!";
$lang['errorcreatingpost'] = "err0R CR34+1ng poST! plE4S3 TrY 4941n In @ few mInu+es.";
$lang['createnewthread'] = "cre@+3 neW thr3@d";
$lang['postreply'] = "p0\$+ repLY";
$lang['threadtitle'] = "thrEaD TitLE";
$lang['foldertitle'] = "foLD3r Ti+L3";
$lang['messagehasbeendeleted'] = "m3\$S@Ge n0+ phOUnD. cH3ck Th4+ 1t H4Sn'+ b3en deLeted.";
$lang['messagenotfoundinselectedfolder'] = "m3Ss@G3 No+ Ph0UnD 1n S3lEcted folD3R. cHeck +H4+ IT h45n'T 8e3n MOVed OR deLe+3d.";
$lang['cannotpostthisthreadtypeinfolder'] = "j00 C4nnOT POS+ TH1\$ +Hr34D TYpe 1n +H@T folder!";
$lang['cannotpostthisthreadtype'] = "j00 C4nno+ P0\$t +hi\$ THr34d +ype 45 tHEre @re n0 4vaiL48l3 ph0ld3r\$ +H@T 4lLOW It.";
$lang['cannotcreatenewthreads'] = "j00 c@nN0t CRea+e NEw tHR3@D\$.";
$lang['threadisclosedforposting'] = "tHi\$ +HRE@D IS CLOsed, J00 c@nno+ PoS+ In 1+!";
$lang['moderatorthreadclosed'] = "w4rN1n9: +his +hrE@d IS cLoS3d PHOR pOst1n9 T0 N0RM@l U\$ErS.";
$lang['usersinthread'] = "u\$3r\$ in tHR34D";
$lang['correctedcode'] = "c0Rr3c+3d c0De";
$lang['submittedcode'] = "su8MI+ted codE";
$lang['htmlinmessage'] = "h+Ml 1n M3s\$49E";
$lang['disableemoticonsinmessage'] = "d154BL3 3mO+1cONS in Mes5a9e";
$lang['automaticallyparseurls'] = "auTom4+1C@LlY P4RS3 uRL\$";
$lang['automaticallycheckspelling'] = "aU+0MA+1c4lly CHECK \$p3lling";
$lang['setthreadtohighinterest'] = "set +HRe@d tO h19h In+er3\$T";
$lang['enabledwithautolinebreaks'] = "eN4bled w1th @U+0-l1n3-bre@k\$";
$lang['fixhtmlexplanation'] = "th1S pHORUm useS HTml Ph1lTEr1ng. yoUr sUBM1+t3d htML hA5 been M0D1f13d 8Y +he fiLt3r\$ In Some WAy.\n\nTO vieW your 0R1G1NAl c0de, S3l3cT Th3 'SUbM1+T3d cOde' r4D1o 8ut+0n.\nT0 VieW the moD1PH1ed cod3, 5El3C+ +h3 'c0rR3CTeD c0de' R@d10 But+On.";
$lang['messageoptions'] = "m3S54Ge Opti0n5";
$lang['notallowedembedattachmentpost'] = "j00 @re NO+ 4ll0WED +0 Em83D @+T4CHment5 1n YoUR Pos+S.";
$lang['notallowedembedattachmentsignature'] = "j00 4RE not 4Ll0w3d t0 3mbed 4t+4chm3n+5 In YOUR \$1gna+Ur3.";
$lang['reducemessagelength'] = "meS\$a9e LEngTh mu\$t 8E uNDEr 65,535 ch4r4c+3rs (cuRr3ntly: %s)";
$lang['reducesiglength'] = "s1Gn@+Ur3 l3N9+H mu\$+ 83 uNd3r 65,535 ch4r4c+ers (CUrr3n+Ly: %s)";
$lang['cannotcreatethreadinfolder'] = "j00 C4NN0t Cre@te N3W tHR3@D\$ 1N +hI5 Fold3r";
$lang['cannotcreatepostinfolder'] = "j00 C@nn0t RePLY +0 po\$t5 iN thI\$ pH0lD3R";
$lang['cannotattachfilesinfolder'] = "j00 C4nnOT PoS+ @++4CHMent\$ IN thI5 PHOLD3r. R3m0ve 4+t@cHMEntS +O cON+iNU3.";
$lang['postfrequencytoogreat'] = "j00 c@N oNLy PO5+ Once 3very %s 5Econd\$. pL3@SE Try 49@1n L4TEr.";
$lang['emailconfirmationrequiredbeforepost'] = "eM41L ConPHirM4T10n I5 R3QU1R3d 83FOr3 j00 c4n P0S+. 1PH j00 h@v3 N0t rec31VeD 4 C0nfiRM4+10n 3m@1l PL34\$E clICk +HE But+0N 8eloW @nd 4 N3W 0ne WIll 83 sEN+ +o yOU. 1pH YOur Em41L @dDrE\$s needs cH@n91n9 PL3A\$E D0 \$0 b3phore REquE\$tIn9 4 n3w conpH1RM@+1on EM4iL. j00 m4y CH@nG3 yOur 3M4il @Ddr3Ss 8Y cl1CK My C0N+R0Ls 48ov3 @ND TH3n UsEr d3+4iLs";
$lang['emailconfirmationfailedtosend'] = "conFIrm@+1ON em41l f41L3d tO \$end. PLe4se C0n+@ct T3H ph0rUM oWNer +0 rec+1pHY +HIS.";
$lang['emailconfirmationsent'] = "cONphiRM4+10n 3M4iL h4s 8e3n R3s3n+.";
$lang['resendconfirmation'] = "resEnD cONfiRM4+10N";
$lang['userapprovalrequiredbeforeaccess'] = "yoUr U5er 4CcouNT n33DS +o b3 APPR0v3D BY 4 PH0rum 4Dmin BefoRE J00 c@n acC3S\$ +EH reQU3\$t3d FoRUm.";
$lang['reviewthread'] = "rEV1ew ThrE4d";
$lang['reviewthreadinnewwindow'] = "reVIEW EntIRe +Hre4d 1N n3W WInD0W";

// Message display (messages.php & messages.inc.php) --------------------------------------

$lang['inreplyto'] = "iN r3plY +0";
$lang['showmessages'] = "sH0W meSS4ges";
$lang['ratemyinterest'] = "r@+E mY 1N+3re5+";
$lang['adjtextsize'] = "aDjusT T3Xt \$ize";
$lang['smaller'] = "sM4ller";
$lang['larger'] = "l4rgeR";
$lang['faq'] = "f4q";
$lang['docs'] = "d0cS";
$lang['support'] = "sUPp0R+";
$lang['donateexcmark'] = "doN4+3!";
$lang['fontsizechanged'] = "foN+ \$1ze CH4nged. %s";
$lang['framesmustbereloaded'] = "fr4m3s Mu\$+ b3 reL04d3d maNU4lly +0 5e3 Ch4n93s.";
$lang['threadcouldnotbefound'] = "tEH ReQUe\$T3d +hREAd CoULd NO+ B3 PH0Und 0r @CCES5 W4\$ denied.";
$lang['mustselectpolloption'] = "j00 MU\$t sel3c+ @N 0ptioN +0 V0T3 pH0r!";
$lang['mustvoteforallgroups'] = "j00 MU\$t VOte In 3v3RY gROup.";
$lang['keepreading'] = "k33p re4d1ng";
$lang['backtothreadlist'] = "b@CK TO thr34d li\$t";
$lang['postdoesnotexist'] = "tHa+ p0s+ does NoT 3x1s+ in th1\$ +Hr34D!";
$lang['clicktochangevote'] = "cLiCK +O ch@nge Vo+E";
$lang['youvotedforoption'] = "j00 VO+ed fOR 0ptI0n";
$lang['youvotedforoptions'] = "j00 vo+3D F0r OP+10n\$";
$lang['clicktovote'] = "cLick +O V0T3";
$lang['youhavenotvoted'] = "j00 HAVe not Vo+3d";
$lang['viewresults'] = "vi3w r3sULT\$";
$lang['msgtruncated'] = "mE\$\$@9e tRUnc@T3D";
$lang['viewfullmsg'] = "v1ew PHUll MES\$4Ge";
$lang['ignoredmsg'] = "i9N0REd ME5S4g3";
$lang['wormeduser'] = "wORMEd usER";
$lang['ignoredsig'] = "i9N0R3D s19N@+ure";
$lang['messagewasdeleted'] = "mes\$493 %s.%s W@S d3lE+ed";
$lang['stopignoringthisuser'] = "s+Op i9noR1NG thiS USEr";
$lang['renamethread'] = "r3nAME THREad";
$lang['movethread'] = "moV3 +hRE@d";
$lang['torenamethisthreadyoumusteditthepoll'] = "t0 reN@M3 +HIs +HRE@D j00 mus+ 3d1+ +h3 p0ll.";
$lang['closeforposting'] = "cloS3 ph0r p0StINg";
$lang['until'] = "un+1L 00:00 utc";
$lang['approvalrequired'] = "apPr0vaL reqUIrED";
$lang['messageawaitingapprovalbymoderator'] = "m3Ss4g3 %s.%s iS @W@1+ing APprOV4L 8Y 4 mODer4tOR";
$lang['successfullyapprovedpost'] = "suCCeS\$FuLLY 4ppROv3D P0st %s";
$lang['postapprovalfailed'] = "po\$T 4pPR0v4l f41l3d.";
$lang['postdoesnotrequireapproval'] = "pO\$t doe\$ n0+ reQU1Re 4PProV4l";
$lang['approvepost'] = "appR0v3 poS+";
$lang['approvedbyuser'] = "aPpr0V3D: %s By %s";
$lang['makesticky'] = "m@ke 5+1CKy";
$lang['messagecountdisplay'] = "%s oPH %s";
$lang['linktothread'] = "peRM@Nent l1nk +O tH1\$ +Hr34D";
$lang['linktopost'] = "l1Nk +0 p0s+";
$lang['linktothispost'] = "liNK +o +H1\$ P0S+";
$lang['imageresized'] = "thIs 1M4G3 H4\$ be3n R3\$1Z3d (0R1G1N4L \$1z3 %dx%d). T0 V1ew the PHulL-s1z3 1m4g3 cLIcK Here.";
$lang['messagedeletedbyuser'] = "mEsS493 %s.%s Del3t3D %s 8Y %s";
$lang['messagedeleted'] = "m3ss493 %s.%s W4\$ d3le+3d";
$lang['viewinframeset'] = "v1ew in fR@m3set";
$lang['pressctrlentertoquicklysubmityourpost'] = "pr3sS c+Rl+ENter +0 QuicklY 5U8M1+ Y0ur P0S+";
$lang['invalidmsgidornomessageidspecified'] = "inV4LId mE\$s493 ID 0R N0 MeS\$493 id SPecIFiEd.";

// Moderators list (mods_list.php) -------------------------------------

$lang['cantdisplaymods'] = "c4nN0t d1SPL@y FOld3r mODer@+0rs";
$lang['moderatorlist'] = "m0der4+0r L1St:";
$lang['modsforfolder'] = "m0d3r@+orS f0r PHold3r";
$lang['nomodsfound'] = "nO Mod3r4toR\$ phOund";
$lang['forumleaders'] = "f0rum LeaDErs:";
$lang['foldermods'] = "fold3r MODer4+ORs:";

// Navigation strip (nav.php) ------------------------------------------

$lang['start'] = "s+aRT";
$lang['messages'] = "me\$S49es";
$lang['pminbox'] = "iNB0X";
$lang['startwiththreadlist'] = "sT4Rt p4GE wI+h THread lIs+";
$lang['pmsentitems'] = "s3NT i+3mS";
$lang['pmoutbox'] = "ou+8oX";
$lang['pmsaveditems'] = "saVEd I+3m\$";
$lang['pmdrafts'] = "dR@pHt\$";
$lang['links'] = "linK5";
$lang['admin'] = "aDMin";
$lang['login'] = "lO91N";
$lang['logout'] = "l090U+";

// PM System (pm.php, pm_write.php, pm.inc.php) ------------------------

$lang['privatemessages'] = "pr1V@t3 mEs5a9e\$";
$lang['recipienttiptext'] = "s3Par4+e Recip1en+S By S3MI-COLoN 0r cOmm4";
$lang['maximumtenrecipientspermessage'] = "tHeR3 1s 4 l1Mi+ OF 10 r3CipI3NT5 p3r M35s493. PlE4\$E 4menD Y0ur RECiPIen+ li\$t.";
$lang['mustspecifyrecipient'] = "j00 MUs+ \$p3C1Fy @+ le4s+ on3 reCIP1ent.";
$lang['usernotfound'] = "u53R %s no+ fOUnd";
$lang['sendnewpm'] = "seND new PM";
$lang['saveselectedmessages'] = "sav3 \$eLECt3D M3ssaG3s";
$lang['deleteselectedmessages'] = "d3l3T3 \$El3C+ed m3S549e5";
$lang['exportselectedmessages'] = "eXp0rT S3L3Ct3d MEs5AGE\$";
$lang['nosubject'] = "no \$uBjec+";
$lang['norecipients'] = "n0 R3cIPIEn+s";
$lang['timesent'] = "timE S3N+";
$lang['notsent'] = "not s3nT";
$lang['errorcreatingpm'] = "erR0r cr3@tIN9 pm! PL3@SE try 4G41N 1n a FeW MinuTE\$";
$lang['writepm'] = "wrIt3 me\$S493";
$lang['editpm'] = "edI+ Mes\$4gE";
$lang['cannoteditpm'] = "c4nN0+ 3d1t thI\$ pm. IT h4\$ alREaDy B3eN vi3W3d by T3H r3C1pI3N+ OR +he m3ss4gE D03s NOT 3x1\$t 0r it 1s inacCes51Bl3 8Y J00";
$lang['cannotviewpm'] = "c4nNot vIEw PM. m3s\$a93 do3\$ n0+ 3xIs+ Or IT iS 1nacC3s\$1Ble by J00";
$lang['pmmessagenumber'] = "mess49E %s";

$lang['youhavexnewpm'] = "j00 H@v3 %d New ME\$S4Ge\$. wOuLD j00 likE tO 90 +o YOuR Inbox now?";
$lang['youhave1newpm'] = "j00 h@V3 1 nEW m3\$s4g3. WoUld j00 l1kE to 90 t0 Y0ur 1N80x NOW?";
$lang['youhave1newpmand1waiting'] = "j00 H4VE 1 N3W me5\$4GE.\n\nY0U 4LSO h4ve 1 MeSsage @W41+1N9 d3l1Very. +O rec31VE +HIS me\$s4g3 pl3@S3 cL34r 5oMe sP4cE 1N y0Ur 1n8oX.\n\nwOuld J00 liK3 +o GO t0 YOur iNBox N0W?";
$lang['youhave1pmwaiting'] = "j00 h4V3 1 M3s\$4ge @w4ITin9 d3liv3ry. t0 rec31V3 +HIS mE5S4GE PL34\$E cL3@r S0m3 SP4Ce IN y0ur INB0x.\n\nWoULd J00 l1k3 to go +0 yOUr 1n80X nOw?";
$lang['youhavexnewpmand1waiting'] = "j00 h4v3 %d n3W M3s5age5.\n\nYOU @L\$o h4Ve 1 MeSS493 4W@1+1n9 dEl1VEry. +0 r3Ceiv3 th15 me\$S4ge pL345E CL3@R soME SP4cE In YOur INbOX.\n\nwoulD J00 l1k3 TO g0 T0 your INBOx NOW?";
$lang['youhavexnewpmandxwaiting'] = "j00 h4v3 %d n3w mes549e\$.\n\nYou @l\$o h4v3 %d m3\$s4ge\$ aw4it1N9 d3lIV3RY. t0 R3Ceive TH3\$E mES\$49E Pl3@\$E cle4R 5ome sP@cE IN your InB0x.\n\nWoULd J00 LIkE +o G0 to Your in8oX now?";
$lang['youhave1newpmandxwaiting'] = "j00 H4V3 1 neW M3s\$49e.\n\nY0u @L50 H4Ve %d m3\$s4GE5 @wAit1N9 d3lIv3ry. +0 R3c31vE +H3s3 M3s549e\$ plEaS3 CL3@R SOme 5p@CE IN yOuR IN8ox.\n\nw0ULd J00 lik3 To GO t0 yOUr INbox NoW?";
$lang['youhavexpmwaiting'] = "j00 have %d Me\$\$4g3s @w4iT1N9 dEL1V3ry. to r3ceiv3 THE5E mE\$s@G3\$ pL3A5E Cl34R 50M3 \$p4cE 1n y0ur InbOx.\n\nW0ulD j00 l1ke tO 90 t0 y0ur 1nB0x NOW?";

$lang['youdonothaveenoughfreespace'] = "j00 Do N0t H@VE EN0u9h FR33 Sp@Ce +0 \$ENd +H1S m35\$@g3.";
$lang['userhasoptedoutofpm'] = "%s H@\$ oPteD OuT OPH R3ceiv1n9 P3R\$oN4l ME\$s493\$";
$lang['pmfolderpruningisenabled'] = "pM PholdeR pRUNIn9 1s 3N@8lEd!";
$lang['pmpruneexplanation'] = "tH1\$ PhoRum use\$ pM FOlD3R PruN1n9. tEh me\$s493\$ j00 H4ve 5+0Red 1n Y0Ur 1nB0X 4nD sENt 1tEms\npH0LDers 4Re \$u8jecT +0 4utom@+1C DEL3Ti0n. 4Ny MeSs@9e\$ j00 WIsH t0 k3ep SH0ulD 83 mOveD +0\nyOuR '\$4V3D i+ems' pH0ldeR \$0 +h4t +hEy @R3 NO+ D3l3+3D.";
$lang['yourpmfoldersare'] = "yOur Pm ph0ld3r\$ are %s PhuLL";
$lang['currentmessage'] = "curR3N+ M3\$S4g3";
$lang['unreadmessage'] = "unRE@D mes5agE";
$lang['readmessage'] = "rE4D m3sSAgE";
$lang['pmshavebeendisabled'] = "p3R\$0NAL M3\$S4GE5 h4V3 b3eN D154Bled 8y +He fORum 0WneR.";
$lang['adduserstofriendslist'] = "add u\$ERs +0 YoUR pHr13Nds LIS+ +o h@V3 TH3m 4pp34r IN @ DroP dowN on +eh PM WRi+E ME5s@ge P4GE.";

$lang['messagewassuccessfullysavedtodraftsfolder'] = "mesS@g3 w4S \$UcC3sSPhullY S4V3d +O 'Dr4pht\$' PHOlder";
$lang['couldnotsavemessage'] = "c0uld n0+ S4v3 meS\$4GE. m@K3 \$urE J00 h4Ve 3n0ugh 4VA1l4bl3 PHr33 5P@ce.";
$lang['pmtooltipxmessages'] = "%s MEs\$4G3s";
$lang['pmtooltip1message'] = "1 m3s\$4gE";

$lang['allowusertosendpm'] = "aLlOw USEr T0 s3nd p3r\$on4L M3\$S493\$ t0 M3";
$lang['blockuserfromsendingpm'] = "bLock UsER pHRom sENding P3R\$on4l M3S549E\$ +O m3";
$lang['yourfoldernamefolderisempty'] = "yOuR %s PH0ld3R 1\$ EmPTy";
$lang['successfullydeletedselectedmessages'] = "sUCce\$\$Fully d3le+3d SeL3c+3D Me\$s493s";
$lang['successfullyarchivedselectedmessages'] = "sUcCeSsphulLY @RCh1v3d SEl3c+3d MeSs4Ge5";
$lang['failedtodeleteselectedmessages'] = "f@ILed +0 D3l3t3 s3Lec+3D Me\$s4g3s";
$lang['failedtoarchiveselectedmessages'] = "f41L3D +0 4rchiv3 \$eLec+ed M3S\$4GE5";
$lang['deletemessagesconfirmation'] = "are J00 SUr3 J00 w4NT +o d3l3TE 4Ll 0f +He SEl3c+3D m3s\$4ge\$?";
$lang['youmustselectsomemessages'] = "j00 mu\$t s3lEc+ SOm3 m3\$s4G3S t0 pr0cE5s";
$lang['successfullyrenamedfolder'] = "suCCe\$\$pHULly Ren4M3d PH0ld3r";

// Preferences / Profile (user_*.php) ---------------------------------------------

$lang['mycontrols'] = "my C0N+rOl\$";
$lang['myforums'] = "mY forum5";
$lang['menu'] = "mENU";
$lang['userexp_1'] = "u5e the menu 0N +H3 LEpht +O M4n4g3 YOur S3tt1n9s.";
$lang['userexp_2'] = "<b>u\$3R D3+4ILs</b> 4LLows J00 to cH4N9E yOUR n4m3, eM4iL 4ddr3\$S @nd P4sSW0RD.";
$lang['userexp_3'] = "<b>u\$3r PROFIle</b> @LlOwS J00 T0 3d1T YoUR UsER PrOph1LE.";
$lang['userexp_4'] = "<b>cH@nG3 p4\$SWOrd</b> AllOW\$ j00 +O ch4n9E yoUR p4sSWorD";
$lang['userexp_5'] = "<b>email &amp; PRIV@CY</b> LEts J00 Ch4N9E h0w j00 C@N 83 COn+4ct3d 0n @ND oFph +h3 FoRUm.";
$lang['userexp_6'] = "<b>forUm oP+10nS</b> lE+5 j00 ch4N9e h0w TEH ph0RuM L0OkS 4Nd WoRks.";
$lang['userexp_7'] = "<b>aTt@chM3n+5</b> 4Ll0wS J00 To 3DI+/d3l3+E yOUr 4+t@cHMEN+5.";
$lang['userexp_8'] = "<b>sIgn4ture</b> le+S J00 3d1t Y0Ur \$igN@tURE.";
$lang['userexp_9'] = "<b>r3l@+1oN5HiP5</b> LetS J00 m@N49E yOUr R3L4Ti0nsh1p WI+h 0+H3R u\$ERS ON Th3 PHoruM.";
$lang['userexp_9'] = "<b>w0rd F1Lt3r</b> LETS J00 ed1t y0ur Person4L WOrd pHIL+er.";
$lang['userexp_10'] = "<b>thR34d su8SCrIP+10N\$</b> 4LlOW\$ J00 To M4n4ge YOUR +hr3@D SU8SCriP+10Ns.";
$lang['userdetails'] = "usEr DE+41L\$";
$lang['userprofile'] = "user PR0f1L3";
$lang['emailandprivacy'] = "eMail &amp; prIV@CY";
$lang['editsignature'] = "eDI+ \$1gn4+ure";
$lang['norelationshipssetup'] = "j00 h4ve NO Us3R Rel@tiOnshiPS sE+ UP. 4dD @ NeW U\$Er bY 5E4RChing B3LOW.";
$lang['editwordfilter'] = "edI+ W0Rd fiL+eR";
$lang['userinformation'] = "uS3r Inf0RMa+10N";
$lang['changepassword'] = "ch@NG3 p@\$sw0rd";
$lang['currentpasswd'] = "cUrReNT P4SswOrd";
$lang['newpasswd'] = "n3W p4\$sw0rd";
$lang['confirmpasswd'] = "c0NPH1Rm p4SsW0rd";
$lang['currentpasswdrequired'] = "cuRr3n+ P@\$Sw0RD i\$ r3qU1reD";
$lang['newpasswdrequired'] = "n3W p@5sw0rd Is reQU1red";
$lang['confirmpasswordrequired'] = "c0Nfirm p4sSw0Rd IS rEqU1r3d";
$lang['currentpasswddoesnotmatch'] = "cuRReNt p4\$\$w0rD doe\$ N0t M4tch 54VED P@\$sW0Rd";
$lang['nicknamerequired'] = "nIckn@ME 1\$ r3Quir3d!";
$lang['emailaddressrequired'] = "eM@1l @ddre\$S i5 r3quIr3d!";
$lang['logonnotpermitted'] = "l0goN nO+ p3rmITT3D. cH0O5E 4n0+h3r!";
$lang['nicknamenotpermitted'] = "nICKN4m3 N0+ p3rM1+T3D. CH0Os3 4N0TH3R!";
$lang['emailaddressnotpermitted'] = "eM41l 4ddr3\$\$ noT p3rm1+t3D. cH0os3 @N0Ther!";
$lang['emailaddressalreadyinuse'] = "eM@1l 4ddre5s 4LR3@DY 1n u\$e. ch0oSE AN0THer!";
$lang['relationshipsupdated'] = "reL4t10NSH1PS uPd4ted!";
$lang['relationshipupdatefailed'] = "rEl4+IonSH1P upD@+eD f41l3D!";
$lang['preferencesupdated'] = "pRephER3ncE\$ W3R3 \$ucCES5fUlly uPD@t3D.";
$lang['userdetails'] = "uS3r DE+4ilS";
$lang['memberno'] = "m3mB3r no.";
$lang['firstname'] = "fIRs+ n4M3";
$lang['lastname'] = "l4S+ n@Me";
$lang['dateofbirth'] = "d4TE oPH birth";
$lang['homepageURL'] = "h0m3p493 Url";
$lang['profilepicturedimensions'] = "pRofiL3 PIc+Ure (Max 95X95Px)";
$lang['avatarpicturedimensions'] = "aV4T4R pictuRE (m@x 15x15px)";
$lang['invalidattachmentid'] = "iNvAL1d 4tt@chmeNT. ch3Ck +h4T is Ha\$n't 83eN D3Le+ed.";
$lang['unsupportedimagetype'] = "unsUpp0r+ED 1m4GE 4Tt4chment. J00 c@N onLY use JP9, g1f @Nd Png IMA9e @+T4chmen+S phOR y0UR @v4+4r 4nd Pr0ph1lE P1C+uR3.";
$lang['selectattachment'] = "s3L3CT 4++4chm3n+";
$lang['pictureURL'] = "p1CtURe url";
$lang['avatarURL'] = "aV@+4r urL";
$lang['profilepictureconflict'] = "t0 u5e 4N @+tachm3n+ pH0R yOUR pROph1l3 p1C+ur3 +eH PIcTure urL fi3Ld MUst 83 bl4nK.";
$lang['avatarpictureconflict'] = "to Use @N 4tT@chment For Y0Ur 4V@t4r Pic+ur3 +h3 @V4+4r uRL PHIeld mus+ B3 bl4nk.";
$lang['attachmenttoolargeforprofilepicture'] = "s3lEc+Ed 4Tt@CHMen+ 15 TO0 l@Rg3 phOR pROf1l3 pIC+uR3. m@XIMum dim3N\$10n5 4rE %s";
$lang['attachmenttoolargeforavatarpicture'] = "s3leCted 4++4CHm3n+ Is +o0 l4r93 phOR 4v4t4r P1CTur3. maX1MUm dim3n\$1on\$ 4RE %s";
$lang['failedtoupdateuserdetails'] = "sOME or @LL 0f Your U5ER accoUnt DET@1Ls c0Uld N0+ b3 Upd4+3D. pl34S3 trY A94iN l4t3r.";
$lang['failedtoupdateuserpreferences'] = "s0M3 OR 4ll 0f Y0UR uSeR pr3pH3R3nc3\$ c0uld n0T B3 upd@ted. plEasE +ry @9@1n l@+3R.";
$lang['emailaddresschanged'] = "em@1L 4ddr35s h@S 83eN Ch@N93D";
$lang['newconfirmationemailsuccess'] = "y0Ur 3m@1L 4ddR3SS h4S 83En chan93D 4nd @ new c0nf1rm4+Ion 3m4il H4s b3en S3n+. PLe4se cHecK 4ND R3@d +eH Em@1L ph0r phUR+Her 1nStrUCtIONs.";
$lang['newconfirmationemailfailure'] = "j00 H4V3 ch4NGEd youR 3M@1l 4ddre5s, 8ut We Were UN48L3 +0 \$3nd 4 conPHirM4+1On reque5+. Plea\$e c0n+4ct +H3 ph0RUm OWNeR FOr a\$siS+4ncE.";
$lang['forumoptions'] = "foRum 0p+10n5";
$lang['notifybyemail'] = "nOTiFy 8Y 3M@1l 0f PO5+S +0 me";
$lang['notifyofnewpm'] = "noTiFY 8y P0Pup 0PH n3w pM m3s5493\$ t0 M3";
$lang['notifyofnewpmemail'] = "nOtIphy by 3m4iL 0f new Pm m3sS@g3\$ +0 m3";
$lang['daylightsaving'] = "aDjUsT fOR d@Yl1ght s@VinG";
$lang['autohighinterest'] = "autOM4+IC4Lly M4rK +hre@ds I p05+ in 4s Hi9h IN+er3st";
$lang['sortthreadlistbyfolders'] = "s0r+ +Hr34D liS+ by ph0ld3r\$";
$lang['convertimagestolinks'] = "aUt0M4tIC@Lly c0nv3r+ 3m8edD3d im@9es In P0s+s IN+0 LINKs";
$lang['thumbnailsforimageattachments'] = "tHuM8N4IL\$ f0R 1m49e @++4chMEn+S";
$lang['smallsized'] = "sM4ll \$ized";
$lang['mediumsized'] = "medium \$1z3d";
$lang['largesized'] = "l4r9E S1z3D";
$lang['globallyignoresigs'] = "gL084llY 1gn0RE u\$Er S19NATur3\$";
$lang['allowpersonalmessages'] = "aLL0W oTHer USeRS t0 \$eND me Pers0n@L me\$sages";
$lang['allowemails'] = "all0w OTH3R uS3rs +O send me 3M4iL5 Vi4 MY pr0phIle";
$lang['useemailaddr'] = "u\$3 MY 3m@1L 4DdR3SS wH3N \$EndINg 0th3r UsEr\$ 3M4il5 VIa tH31r PrOF1LEs";
$lang['timezonefromGMT'] = "tiME Z0NE";
$lang['postsperpage'] = "pO\$t\$ p3R P@9e";
$lang['fontsize'] = "f0n+ \$1z3";
$lang['forumstyle'] = "foRum s+yl3";
$lang['forumemoticons'] = "foRum eM0t1C0N\$";
$lang['startpage'] = "sT4rT p493";
$lang['signaturecontainshtmlcode'] = "sI9N@Ture c0N+4INs HTml code";
$lang['savesignatureforuseonallforums'] = "s@VE s19n4tURe phOr U\$E 0N 4ll PHOruMS";
$lang['preferredlang'] = "pReF3Rr3d lAN9u4ge";
$lang['donotshowmyageordobtoothers'] = "do nOT \$How mY 4Ge OR D4+3 of BIR+H t0 o+HERs";
$lang['showonlymyagetoothers'] = "sHoW oNly my @93 +o O+h3r\$";
$lang['showmyageanddobtoothers'] = "sh0W bO+H My @9e 4ND d4t3 0F 81R+h t0 OTh3r\$";
$lang['showonlymydayandmonthofbirthytoothers'] = "sh0w 0Nly MY d4Y @nd moN+h OPH BirtH +0 other\$";
$lang['listmeontheactiveusersdisplay'] = "lI\$+ ME ON TEh 4Ct1V3 US3rS d1SPl@Y";
$lang['browseanonymously'] = "bROW\$e FORum 4N0nYMousLy";
$lang['allowfriendstoseemeasonline'] = "broW\$E 4n0nyMOusLY, buT 4llOW fR1ENd\$ to s3E m3 4s 0NL1N3";
$lang['revealspoileronmouseover'] = "r3veAl sP0Ilers 0n MOUsE 0Ver";
$lang['showspoilersinlightmode'] = "aLW4yS sHOw SP0iL3R\$ IN L19h+ m0DE (usE\$ ligH+er FON+ coL0Ur)";
$lang['resizeimagesandreflowpage'] = "r3\$1ze Im49E\$ @ND r3fl0w P4g3 +0 Pr3VENT Hor1ZOnt4l \$Cr0ll1NG.";
$lang['showforumstats'] = "sHOW f0rUM \$t@T\$ 4t 80T+Om Of m3S5ag3 P4N3";
$lang['usewordfilter'] = "eNaBLe W0Rd Ph1lTEr.";
$lang['forceadminwordfilter'] = "fOrCe uS3 oF @dm1n w0rd pH1LTeR on aLL u\$eR\$ (INC. 9uE\$t\$)";
$lang['timezone'] = "t1m3 z0nE";
$lang['language'] = "l4NGu49e";
$lang['emailsettings'] = "em4Il 4ND con+4ct Set+1NG\$";
$lang['forumanonymity'] = "f0ruM @N0NyMITy se+TiNg\$";
$lang['birthdayanddateofbirth'] = "b1RThd4y 4nd daT3 0Ph bIRTH dI\$pl4Y";
$lang['includeadminfilter'] = "inClUD3 4DMIN w0RD Fil+eR 1n My L1\$+.";
$lang['setforallforums'] = "sET F0R ALl PHoRuMS?";
$lang['containsinvalidchars'] = "%s cONT41NS INV4L1d ch@R4cteRS!";
$lang['homepageurlmustincludeschema'] = "h0mep@93 urL MU\$T 1ncLUD3 hT+p:// \$ch3Ma.";
$lang['pictureurlmustincludeschema'] = "pICtur3 uRL Must iNClUd3 hT+p:// sch3m4.";
$lang['avatarurlmustincludeschema'] = "av4T4R url Mu5t inclUd3 Ht+p:// scheM@.";
$lang['postpage'] = "p0St P4ge";
$lang['nohtmltoolbar'] = "nO HTml +00L84r";
$lang['displaysimpletoolbar'] = "dI\$pl4y \$1Mpl3 hTml +ooL8aR";
$lang['displaytinymcetoolbar'] = "dI\$pL4Y WYs1WYG h+Ml +OolB@R";
$lang['displayemoticonspanel'] = "d1Spl4Y em0+1coNS P4N3l";
$lang['displaysignature'] = "d1SPL@y S1Gn@tur3";
$lang['disableemoticonsinpostsbydefault'] = "di54BL3 EM0t1c0n\$ IN Me\$S@g3\$ by DePH4Ult";
$lang['automaticallyparseurlsbydefault'] = "au+0M@tIC4Lly P4Rse uRLs IN M3s\$4ges bY d3F@uL+";
$lang['postinplaintextbydefault'] = "pOs+ 1n PL4in TEx+ By deph4ul+";
$lang['postinhtmlwithautolinebreaksbydefault'] = "p0\$T 1n H+mL WIth 4ut0-l1Ne-8R34Ks BY d3PH4ult";
$lang['postinhtmlbydefault'] = "poS+ 1N HTml 8Y deph4ult";
$lang['postdefaultquick'] = "u53 Quick r3plY 8y Deph@ULT. (phull Reply IN m3Nu)";
$lang['threadlinksgotolastpage'] = "tHR34d L1S+ lA\$T po5+ Link 903s +0 l@s+ P493 0F P0stS.";
$lang['privatemessageoptions'] = "priV4+e mes5a93 0p+1oN5";
$lang['privatemessageexportoptions'] = "priV4t3 me\$s493 3xP0rt 0PTiONs";
$lang['savepminsentitems'] = "s4V3 @ Copy 0F 3ach Pm I \$ENd 1N my sEnT It3MS foLDEr";
$lang['includepminreply'] = "iNclUD3 me\$s49e 80dy wh3n R3Ply1n9 TO PM";
$lang['autoprunemypmfoldersevery'] = "aU+o pRUn3 MY Pm F0lDeRS 3veRY:";
$lang['friendsonly'] = "fRI3nds 0nlY?";
$lang['globalstyles'] = "gLO84l s+Yles";
$lang['forumstyles'] = "fOrUM \$TyleS";
$lang['youmustenteryourcurrentpasswd'] = "j00 mu\$+ 3N+3r Y0ur CURr3n+ P4S5WorD";
$lang['youmustenteranewpasswd'] = "j00 Mus+ ent3r @ New P@ssW0rd";
$lang['youmustconfirmyournewpasswd'] = "j00 mus+ ConpH1rM youR n3w P4Ssw0Rd";
$lang['profileentriesmustnotincludehtml'] = "pR0fil3 entR13\$ mUST NOT 1ncLud3 H+ml";
$lang['failedtoupdateuserprofile'] = "f4iLEd TO upd4+e usER PR0pH1LE";

// Polls (create_poll.php, poll_results.php) ---------------------------------------------

$lang['mustprovideanswergroups'] = "j00 MU\$+ PR0v1de \$om3 4n\$W3r grOUP5";
$lang['mustprovidepolltype'] = "j00 MuST PROV1De @ POll TYPe";
$lang['mustprovidepollresultsdisplaytype'] = "j00 musT pR0Vide re5uL+\$ diSPL@y TYPE";
$lang['mustprovidepollvotetype'] = "j00 mu\$T pr0viDE @ P0lL voTe +Ype";
$lang['mustprovidepollguestvotetype'] = "j00 mu5T sP3C1PHy IPH 9UE\$+s \$H0ULd BE 4ll0wed t0 voTE";
$lang['mustprovidepolloptiontype'] = "j00 mUS+ PROv1d3 4 POll Op+10n tYPe";
$lang['mustprovidepollchangevotetype'] = "j00 MU\$t prOVIdE @ p0ll CHAn93 VO+E TYPe";
$lang['pollquestioncontainsinvalidhtml'] = "on3 or mORe 0F y0ur P0Ll QUesTions C0n+41Ns 1NV@lid HtmL.";
$lang['pleaseselectfolder'] = "pLe@\$3 S3L3CT 4 F0LDer";
$lang['mustspecifyvalues1and2'] = "j00 Mu\$+ Sp3C1fY vALUes For 4N5w3r\$ 1 @nd 2";
$lang['tablepollmusthave2groups'] = "t48uL@R PH0RM@T pOLl\$ must H@ve PR3CISEly +W0 v0+1Ng gr0UPS";
$lang['nomultivotetabulars'] = "t4bUL4r PH0rM4t p0lLS CAnnoT 83 MUl+1-VO+E";
$lang['nomultivotepublic'] = "pubL1C 84ll0T\$ cANN0t b3 muLTi-vo+e";
$lang['abletochangevote'] = "j00 wIll B3 @bl3 +o cH4n93 YOur VO+e.";
$lang['abletovotemultiple'] = "j00 WilL 83 a8L3 +o vo+3 mul+1Ple +1M3S.";
$lang['notabletochangevote'] = "j00 W1ll N0T B3 @8LE +0 ch@Nge yOUr V0t3.";
$lang['pollvotesrandom'] = "nO+E: P0lL v0teS 4re RAndoMLy gen3r4+ed FOR preview ONlY.";
$lang['pollquestion'] = "p0Ll QUesTION";
$lang['possibleanswers'] = "p0Ss18l3 ANsweR\$";
$lang['enterpollquestionexp'] = "eN+3r +H3 4N\$WeR\$ pHOR y0uR p0LL que5+1on.. 1PH Your P0ll I\$ 4 &quot;y3\$/n0&quot; quE\$Ti0N, s1mplY eN+eR &quot;Y3S&quot; fOR 4nsW3r 1 4nd &quot;n0&quot; pH0R anSW3r 2.";
$lang['numberanswers'] = "n0. 4N\$W3r\$";
$lang['answerscontainHTML'] = "aN\$W3Rs CONt@1n htML (n0+ includ1n9 s19na+ur3)";
$lang['optionsdisplay'] = "aNsW3R\$ D1\$pL@Y +yPE";
$lang['optionsdisplayexp'] = "h0W 5h0uld +3H anSW3r5 8E PREs3NT3d?";
$lang['dropdown'] = "as Dr0p-DoWN l1S+(5)";
$lang['radios'] = "a5 4 s3r13S 0f R4di0 8utt0N\$";
$lang['votechanging'] = "v0+3 Ch4n9in9";
$lang['votechangingexp'] = "c@n 4 PERS0N chaN93 H1\$ or HeR voTE?";
$lang['guestvoting'] = "gu35T v0+1ng";
$lang['guestvotingexp'] = "caN gu3S+S v0+3 IN tHI\$ p0lL?";
$lang['allowmultiplevotes'] = "aLlOw MulTIpl3 V0+eS";
$lang['pollresults'] = "p0lL RESUlt\$";
$lang['pollresultsexp'] = "h0W w0ULD j00 LIke tO DI\$PLAy TH3 re\$ul+S 0pH Y0ur PolL?";
$lang['pollvotetype'] = "p0LL v0tiNG +YP3";
$lang['pollvotesexp'] = "h0w Sh0uld +Eh P0Ll 83 C0ndUc+3D?";
$lang['pollvoteanon'] = "anoNYMouSly";
$lang['pollvotepub'] = "pUBLiC b@ll0+";
$lang['horizgraph'] = "h0R1Z0Nt4l GR@pH";
$lang['vertgraph'] = "v3r+1cal 9R@ph";
$lang['tablegraph'] = "t4buL@R PH0rM4+";
$lang['polltypewarning'] = "<b>warNIn9</b>: TH1\$ IS 4 pu8LIC b@ll0t. Y0uR N4ME w1ll be V1S1BlE neXT +o t3h 0pt1on j00 v0T3 pH0r.";
$lang['expiration'] = "expIRA+10n";
$lang['showresultswhileopen'] = "dO J00 W4n+ +O sh0w Re5ulT\$ wH1le th3 PolL I\$ 0pen?";
$lang['whenlikepollclose'] = "when WouLD J00 l1kE YOur P0Ll TO 4ut0M4+1C4LLY Cl0se?";
$lang['oneday'] = "oNe Day";
$lang['threedays'] = "thR33 d@Y\$";
$lang['sevendays'] = "sev3n D4Ys";
$lang['thirtydays'] = "th1RTy d4Y\$";
$lang['never'] = "nev3r";
$lang['polladditionalmessage'] = "aDd1+10N4l M3SS@Ge (Op+I0N4l)";
$lang['polladditionalmessageexp'] = "do j00 w4nt TO inCLuD3 an 4DDiTI0N@L pO5+ 4f+ER teh p0lL?";
$lang['mustspecifypolltoview'] = "j00 mu\$t SPec1fy @ p0LL to VIew.";
$lang['pollconfirmclose'] = "ar3 J00 \$Ur3 j00 W4nt T0 clOSe tH3 f0ll0win9 p0lL?";
$lang['endpoll'] = "eNd Poll";
$lang['nobodyvotedclosedpoll'] = "n0B0DY V0+Ed";
$lang['votedisplayopenpoll'] = "%s 4nd %s h4ve V0+3D.";
$lang['votedisplayclosedpoll'] = "%s 4ND %s VotED.";
$lang['nousersvoted'] = "no USErs";
$lang['oneuservoted'] = "1 U\$3R";
$lang['xusersvoted'] = "%s U5eRS";
$lang['noguestsvoted'] = "n0 GU3s+s";
$lang['oneguestvoted'] = "1 9u3s+";
$lang['xguestsvoted'] = "%s Gu35TS";
$lang['pollhasended'] = "polL H4s END3D";
$lang['youvotedforpolloptionsondate'] = "j00 vOTed PHoR %s on %s";
$lang['thisisapoll'] = "tHi5 iS @ P0lL. clIck +O VIew R3SultS.";
$lang['editpoll'] = "edIt P0ll";
$lang['results'] = "re\$UltS";
$lang['resultdetails'] = "re\$ULt det@1lS";
$lang['changevote'] = "ch4nGe V0te";
$lang['pollshavebeendisabled'] = "p0lL\$ h4v3 been diS48led 8y +H3 ph0Rum OWNer.";
$lang['answertext'] = "aNSw3r +eX+";
$lang['answergroup'] = "anSw3r GRoup";
$lang['previewvotingform'] = "pR3V13w VOt1n9 PH0Rm";
$lang['viewbypolloption'] = "v13w 8y poLL 0ptiOn";
$lang['viewbyuser'] = "v1eW 8Y u5ER";

// Profiles (profile.php) ----------------------------------------------

$lang['editprofile'] = "ed1t PrOf1Le";
$lang['profileupdated'] = "pROphil3 uPD@+3D.";
$lang['profilesnotsetup'] = "teh pH0Rum 0WNer H4S noT SEt UP pROFIl3s.";
$lang['ignoreduser'] = "iGnOred u5ER";
$lang['lastvisit'] = "l4S+ VIs1+";
$lang['userslocaltime'] = "us3r's L0C4L tiM3";
$lang['userstatus'] = "s+@+us";
$lang['useractive'] = "onLIN3";
$lang['userinactive'] = "iN4CTiv3 / 0FPHl1ne";
$lang['totaltimeinforum'] = "to+4l T1m3";
$lang['longesttimeinforum'] = "lON93\$t se\$s10n";
$lang['sendemail'] = "s3ND eM4Il";
$lang['sendpm'] = "s3Nd Pm";
$lang['visithomepage'] = "vI\$1+ hOmep@g3";
$lang['age'] = "a93";
$lang['aged'] = "agED";
$lang['birthday'] = "bIrtHD@Y";
$lang['registered'] = "reGiSter3d";
$lang['findpostsmadebyuser'] = "fINd p0sT5 M4de 8Y %s";
$lang['findpostsmadebyme'] = "finD POst\$ m4D3 by me";
$lang['findthreadsstartedbyuser'] = "f1nd thr3@d\$ s+4RT3d by %s";
$lang['findthreadsstartedbyme'] = "find +HRe@d\$ ST4r+3D By ME";
$lang['profilenotavailable'] = "proPH1l3 nO+ @V41L@BLe.";
$lang['userprofileempty'] = "thiS USeR h@S nO+ pHIlled IN tH3IR pROpH1L3 or i+ 1\$ set tO prIVa+e.";

// Registration (register.php) -----------------------------------------

$lang['newuserregistrationsarenotpermitted'] = "soRry, n3w us3R r391\$tR4+1ONs @re n0T @ll0W3d riGHt n0w. Pl3as3 ch3cK 8@ck l@+3R.";
$lang['usernametooshort'] = "useRN4m3 mUSt b3 4 mIN1MuM Oph 2 ch4r4ctER5 L0N9";
$lang['usernametoolong'] = "uS3RN4m3 MUs+ be 4 maX1mUm 0f 15 ch4r4c+3rS lONg";
$lang['usernamerequired'] = "a lo90n n@mE 1\$ r3qu1rEd";
$lang['passwdmustnotcontainHTML'] = "p4S\$word mus+ N0+ CoN+4in H+ml ta9s";
$lang['passwdtooshort'] = "p4\$SW0RD MusT 8e 4 min1mum 0F 6 cH4R4CtERS L0N9";
$lang['passwdrequired'] = "a p@ssw0rd 1s r3qu1r3d";
$lang['confirmationpasswdrequired'] = "a CoNph1Rma+1ON P4sSW0RD iS reqUIr3D";
$lang['nicknamerequired'] = "a N1CknAMe 1\$ r3Qu1red";
$lang['emailrequired'] = "an em@IL @ddre\$S i5 r3qu1reD";
$lang['passwdsdonotmatch'] = "p@Ssw0rd5 d0 N0T m4tCH";
$lang['usernamesameaspasswd'] = "u5eRN@m3 4nd P4SSw0rD MusT 83 diphpHEr3NT";
$lang['usernameexists'] = "s0rry, @ usER With tH4T n4M3 4LR34DY 3XIs+S";
$lang['successfullycreateduseraccount'] = "sUcc3\$SPHully Cr34ted u5er 4cc0UN+";
$lang['useraccountcreatedconfirmfailed'] = "y0Ur u\$er @CC0UNt H4s b3eN Cr3ated 8ut +H3 requ1r3d c0NPH1rM4+10n 3M4il W4s N0T sEN+. pl3as3 C0n+4C+ +h3 phORum 0WNer TO r3C+IpHy tH1\$. in Th1\$ m34n+im3 PL345E Cl1cK +he c0N+1nuE bU+toN +O loG1n.";
$lang['useraccountcreatedconfirmsuccess'] = "yoUr u5er 4cc0UnT h4\$ b3EN CRe4+ED 8U+ 83ph0re j00 c@n S+@RT POstin9 j00 must c0nph1rm y0UR Em@1l 4Ddr3sS. pL34Se Ch3Ck Y0ur Em4IL for A lINk +h@+ will 4LLOw J00 T0 CoNF1RM Your aDDr3sS.";
$lang['useraccountcreated'] = "yOUr U\$ER 4CCounT H@\$ B3En Cr3A+Ed SUcc3\$sphulLY! clicK +3h c0n+INu3 BU++0n 83l0w +o LOG1n";
$lang['errorcreatinguserrecord'] = "erROr CRea+ing UsER rec0rd";
$lang['userregistration'] = "us3R reg1STr@+10N";
$lang['registrationinformationrequired'] = "reG1s+RA+10n INpH0RM4+10n (Requ1r3d)";
$lang['profileinformationoptional'] = "pR0F1l3 InphoRm4t10n (opTIon4l)";
$lang['preferencesoptional'] = "pRePH3rence\$ (0P+ioN@l)";
$lang['register'] = "r391st3R";
$lang['rememberpasswd'] = "rEMEM83r p4sSw0rD";
$lang['birthdayrequired'] = "d4+E Of b1R+H 1s REquiR3D 0R is 1NV4lid";
$lang['alwaysnotifymeofrepliestome'] = "noTify On R3pLy +o ME";
$lang['notifyonnewprivatemessage'] = "n0T1phy 0n n3w pr1V4Te m3SS@G3";
$lang['popuponnewprivatemessage'] = "pOP up 0n n3W prIV4Te mE\$S@g3";
$lang['automatichighinterestonpost'] = "auT0m4+1C HI9h IN+3r3\$t ON P0sT";
$lang['confirmpassword'] = "coNPHIrm P4ssWORd";
$lang['invalidemailaddressformat'] = "iNv4l1D em4il @DdRE\$s PH0Rm4t";
$lang['moreoptionsavailable'] = "moRE Pr0F1le @Nd PR3pH3REnc3 0p+i0ns @R3 @vAIL48l3 0nC3 j00 REg1s+3R";
$lang['textcaptchaconfirmation'] = "c0nFIRM4+1on";
$lang['textcaptchaexplain'] = "t0 pr3VEN+ 4UTOm4t3D re91\$tR4t10n\$ +Hi5 forum REqu1Re\$ j00 ENTer a C0NPHIRM4+10N code. T3h CoD3 i\$ disPl4yeD In T3H 1m4ge j00 TO T3H ri9ht. 1Ph j00 4re V15u4llY 1mpAIRed oR c4NnoT otHeRWI5e RE@d +h3 code pL34SE c0n+4Ct Th3 %s.";
$lang['textcaptchaimgtip'] = "tHis I\$ a c@p+CH4-P1C+ur3. 1+ 1\$ us3d +O pr3V3Nt @U+0M@T1c r39isTR4+1on";
$lang['textcaptchamissingkey'] = "a ConPH1rM@+ION code iS reQU1R3d.";
$lang['textcaptchaverificationfailed'] = "t3x+-c4p+cha veR1phica+ioN code w4s 1Ncorr3ct. pLE4sE RE-3n+er I+.";
$lang['forumrules'] = "foRUm RuL3s";
$lang['forumrulesnotification'] = "in orD3r +o PR0c3ed, j00 mUS+ A9R3E W1+H T3h PH0ll0W1nG rul3s";
$lang['forumrulescheckbox'] = "i hAVe R3AD, and 49R33 +o 4b1DE 8y T3h f0rum Rul3\$.";
$lang['youmustagreetotheforumrules'] = "j00 mUST 4gr3e +0 +h3 ph0rum Rule\$ bephor3 j00 Can contiNU3.";

// Recent visitors list  (visitor_log.php) -----------------------------

$lang['member'] = "m3M83r";
$lang['searchforusernotinlist'] = "s34rch foR 4 us3r n0T In L1\$T";
$lang['yoursearchdidnotreturnanymatches'] = "yOUr SE4rCh dID no+ return @ny m@+Che\$. +RY s1MPLiphY1nG y0ur Se4rch p@r4me+3rS and try A94In.";
$lang['hiderowswithemptyornullvalues'] = "hIde R0Ws wITh 3MP+y 0r nULl v4lu3s In SEl3cT3d c0lumN\$";
$lang['showregisteredusersonly'] = "sHow R391\$+3R3d users OnlY (h1D3 9u3sT\$)";

// Relationships (user_rel.php) ----------------------------------------

$lang['relationships'] = "reLa+10N\$HipS";
$lang['userrelationship'] = "uSER r3L4TIONSHiP";
$lang['userrelationships'] = "usEr r3l@TioNShIp\$";
$lang['failedtoremoveselectedrelationships'] = "f41led +O R3M0VE seLEc+eD REl@tI0Nsh1P";
$lang['friends'] = "fr13nD\$";
$lang['ignoredcompletely'] = "i9nOreD c0mple+Ely";
$lang['relationship'] = "rEl4tIONSh1P";
$lang['restorenickname'] = "rEs+0r3 usER'\$ NIcKN4M3";
$lang['friend_exp'] = "us3r'S POS+S m@rKed w1th 4 &quot;fr13Nd&quot; 1con.";
$lang['normal_exp'] = "u\$3r's p0ST5 @pP3AR a\$ N0RM4l.";
$lang['ignore_exp'] = "us3R's p0s+S @R3 h1ddEn.";
$lang['ignore_completely_exp'] = "thr34dS and POSt\$ +o 0r phrOM user WIlL @pp34R d3Le+ed.";
$lang['display'] = "d1Spl@y";
$lang['displaysig_exp'] = "u53r'\$ \$1gN@+URe is D1\$pl@yed 0N TheiR poSt\$.";
$lang['hidesig_exp'] = "u\$3r's \$1Gn4+UR3 iS h1DdeN 0N the1R p0sTs.";
$lang['youcannotchangeuserrelationshipforownaccount'] = "j00 C@nnOT CH4N9e u\$er r3L4+10n\$hIP phoR your OWn useR 4Cc0un+";
$lang['cannotignoremod'] = "j00 c@nN0t i9NORe +H1s user, @s +h3y 4re @ moD3r4toR.";
$lang['previewsignature'] = "pr3vi3W s19n@tur3";

// Search (search.php) -------------------------------------------------

$lang['searchresults'] = "s3Arch REsul+s";
$lang['usernamenotfound'] = "tH3 uS3rN4ME j00 \$pEcifIed In tEh +0 Or PHr0m PHiELd w4\$ N0T fOUNd.";
$lang['notexttosearchfor'] = "onE 0R aLl 0F Y0ur seaRcH K3Yw0RDs W3rE inV4lid. \$e4RcH k3YW0rd\$ mUSt 83 no sH0Rt3R +h@N %d Ch@r4cT3r5, no l0N9ER th4n %d CH@rAc+3rS AND mus+ N0+ 4pp34R IN th3 %s";
$lang['keywordscontainingerrors'] = "k3Yword\$ cOn+4in1N9 3rr0rs: %s";
$lang['mysqlstopwordlist'] = "my5ql s+opwoRD l1\$t";
$lang['foundzeromatches'] = "f0uNd: 0 M@TcHe\$";
$lang['found'] = "f0UNd";
$lang['matches'] = "m4TChes";
$lang['prevpage'] = "pR3VI0Us p@93";
$lang['findmore'] = "fiNd m0Re";
$lang['searchmessages'] = "se4RCh MEss493S";
$lang['searchdiscussions'] = "s3@rCH dIScUs\$1On\$";
$lang['find'] = "f1Nd";
$lang['additionalcriteria'] = "aDditIon@L cr1Ter1A";
$lang['searchbyuser'] = "s3@RcH 8Y us3r (0p+1oNal)";
$lang['folderbrackets_s'] = "foLdEr(S)";
$lang['postedfrom'] = "p05T3D fr0M";
$lang['postedto'] = "po\$t3d +O";
$lang['today'] = "toD4y";
$lang['yesterday'] = "ye\$tERD@y";
$lang['daybeforeyesterday'] = "d@y B3f0r3 Y3\$T3rd@Y";
$lang['weekago'] = "%s w33k @90";
$lang['weeksago'] = "%s WE3k5 @90";
$lang['monthago'] = "%s M0n+h 490";
$lang['monthsago'] = "%s m0n+H5 4G0";
$lang['yearago'] = "%s ye@R 49o";
$lang['beginningoftime'] = "be91nNin9 Of +1ME";
$lang['now'] = "now";
$lang['lastpostdate'] = "l4sT POSt dA+e";
$lang['numberofreplies'] = "numBeR oF r3pL13s";
$lang['foldername'] = "f0lder N4m3";
$lang['authorname'] = "aU+h0r N4m3";
$lang['relevancy'] = "rel3v@NCY";
$lang['decendingorder'] = "nEWe\$T Ph1r5+";
$lang['ascendingorder'] = "olD3\$t f1RS+";
$lang['keywords'] = "keyw0Rd\$";
$lang['sortby'] = "sOr+ 8y";
$lang['sortdir'] = "sOr+ dIR";
$lang['sortresults'] = "sOrt RE\$Ul+S";
$lang['groupbythread'] = "gR0uP by thread";
$lang['postsfromuser'] = "p05+S FRom user";
$lang['threadsstartedbyuser'] = "thR34Ds sTArted 8y u\$er";
$lang['searchfrequencyerror'] = "j00 C4n 0NLy SE4Rch once ev3ry %s s3CoNDs. pl34\$3 +RY 4g41N L4tEr.";
$lang['searchsuccessfullycompleted'] = "seArch sUCC3SSfULLy c0MplEt3d. %s";
$lang['clickheretoviewresults'] = "cL1cK HEr3 +0 v13W reSuLts.";

// Search Popup (search_popup.php) -------------------------------------

$lang['select'] = "sELEC+";
$lang['currentselection'] = "cuRR3nt \$3leC+10N";
$lang['addtoselection'] = "add +o S3l3C+iOn";
$lang['searchforthread'] = "s34RCh f0r +Hr3Ad";
$lang['mustspecifytypeofsearch'] = "j00 MU5+ Sp3c1pHY +YP3 0f SE@rch to P3rPH0rM";
$lang['unkownsearchtypespecified'] = "uNKNOWn sE4rch Typ3 SP3cIPHI3d";
$lang['maximumselectionoftenlimitreached'] = "m@XImum \$ELeCt1oN l1m1+ OF 10 H4s b3EN r34Ch3D";

// Start page (start_left.php) -----------------------------------------

$lang['recentthreads'] = "rec3NT tHRe@d\$";
$lang['startreading'] = "s+4rt R34D1n9";
$lang['threadoptions'] = "thr34d op+ion\$";
$lang['editthreadoptions'] = "edit +hRE4D op+1On5";
$lang['morevisitors'] = "moR3 viSItorS";
$lang['forthcomingbirthdays'] = "f0R+hc0ming 81rthdayS";

// Start page (start_main.php) -----------------------------------------

$lang['editstartpage_help'] = "j00 Can 3Di+ +HIs P4ge FroM the 4dmIN iN+erPH4ce";

// Thread navigation (thread_list.php) ---------------------------------

$lang['newdiscussion'] = "n3W DIscu\$\$I0n";
$lang['createpoll'] = "cRe4+e POLL";
$lang['search'] = "s3@rCh";
$lang['searchagain'] = "s3@RCh @gAIn";
$lang['alldiscussions'] = "alL Discu5\$1oN\$";
$lang['unreaddiscussions'] = "unR3@d d15cu\$si0n\$";
$lang['unreadtome'] = "uNR34d &quot;to: m3&quot;";
$lang['todaysdiscussions'] = "t0D@y'S di\$cU\$Si0NS";
$lang['2daysback'] = "2 dAys 84ck";
$lang['7daysback'] = "7 D4Ys b@CK";
$lang['highinterest'] = "hI9h InTEr3\$t";
$lang['unreadhighinterest'] = "unr34D h1gH inT3REst";
$lang['iverecentlyseen'] = "i'Ve RECENTly seen";
$lang['iveignored'] = "i'VE I9noRED";
$lang['byignoredusers'] = "bY ign0REd u\$ERS";
$lang['ivesubscribedto'] = "i'VE SuBscr183D tO";
$lang['startedbyfriend'] = "s+@rted 8y PHR1End";
$lang['unreadstartedbyfriend'] = "uNR34d 5+4rTEd 8y fRIend";
$lang['startedbyme'] = "st4rt3D 8Y m3";
$lang['unreadtoday'] = "unrE@d TOD@y";
$lang['deletedthreads'] = "d3leted THR3@d\$";
$lang['goexcmark'] = "g0!";
$lang['folderinterest'] = "f0LDER 1n+3REs+";
$lang['postnew'] = "po\$t nEW";
$lang['currentthread'] = "cUrREN+ tHR34D";
$lang['highinterest'] = "hi9H 1nterES+";
$lang['markasread'] = "m4RK 4\$ read";
$lang['next50discussions'] = "nEX+ 50 D15Cu\$S1oN\$";
$lang['visiblediscussions'] = "vI\$1BLE Discu55iOn5";
$lang['selectedfolder'] = "sEL3C+3D FolDER";
$lang['navigate'] = "n@V194+e";
$lang['couldnotretrievefolderinformation'] = "theRe aRE no Ph0LdeRs 4V41l4bl3.";
$lang['nomessagesinthiscategory'] = "n0 mes\$4ge\$ 1n +hiS c4+E90ry. PlE45E sEL3C+ aN0+H3R, 0r %s FOR 4ll +hre@ds";
$lang['clickhere'] = "click hER3";
$lang['prev50threads'] = "pr3Vi0u\$ 50 +hre@dS";
$lang['next50threads'] = "neXT 50 +HR3@DS";
$lang['nextxthreads'] = "n3x+ %s +HReads";
$lang['threadstartedbytooltip'] = "tHRE4D #%s sT@rteD 8Y %s. V1EWEd %s";
$lang['threadviewedonetime'] = "1 t1me";
$lang['threadviewedtimes'] = "%d tiMES";
$lang['readthread'] = "r34d THr34D";
$lang['unreadmessages'] = "uNR3ad m3s54geS";
$lang['subscribed'] = "sU8\$Cri83d";
$lang['stickythreads'] = "s+1CKY tHR34ds";
$lang['mostunreadposts'] = "mO\$T Unre4d P0S+s";
$lang['onenew'] = "%d NEW";
$lang['manynew'] = "%d neW";
$lang['onenewoflength'] = "%d neW oph %d";
$lang['manynewoflength'] = "%d n3w oPH %d";
$lang['confirmmarkasread'] = "arE j00 sur3 j00 w4nt To MArK Th3 \$el3CT3d thr3ads 4S r34d?";
$lang['successfullymarkreadselectedthreads'] = "succ35sPHully M4rKeD seL3ct3d +HRe4ds @\$ r34D";
$lang['failedtomarkselectedthreadsasread'] = "f@iL3D T0 M@rk SELeC+ed +Hre@Ds 4\$ r34D";
$lang['gotofirstpostinthread'] = "g0 +O fIR\$T p0\$t 1n tHR3@d";
$lang['gotolastpostinthread'] = "gO T0 l@5t PO5+ 1n +Hr34d";
$lang['viewmessagesinthisfolderonly'] = "v13W meSs4g35 in ThiS ph0ld3R 0nLy";
$lang['shownext50threads'] = "shoW N3Xt 50 +hr34DS";
$lang['showprev50threads'] = "sH0w Pr3v1ouS 50 THReaDS";
$lang['createnewdiscussioninthisfolder'] = "cr3a+e new dISCu\$\$1On In +Hi5 FOLD3R";
$lang['nomessages'] = "n0 m3ssA9E\$";

// HTML toolbar (htmltools.inc.php) ------------------------------------
$lang['bold'] = "bOlD";
$lang['italic'] = "i+4lic";
$lang['underline'] = "unDErl1NE";
$lang['strikethrough'] = "s+RiK3Thr0U9h";
$lang['superscript'] = "suPERScr1pt";
$lang['subscript'] = "subscriP+";
$lang['leftalign'] = "lEPH+-4l19N";
$lang['center'] = "cEnTEr";
$lang['rightalign'] = "r1Ght-@Li9n";
$lang['numberedlist'] = "nUM8EREd L15+";
$lang['list'] = "li\$T";
$lang['indenttext'] = "inden+ +3Xt";
$lang['code'] = "c0DE";
$lang['quote'] = "qUoT3";
$lang['unquote'] = "unQu0te";
$lang['spoiler'] = "sp0iL3R";
$lang['horizontalrule'] = "h0R1Zon+4L rule";
$lang['image'] = "im49E";
$lang['hyperlink'] = "hyP3rl1NK";
$lang['noemoticons'] = "d1S48LE 3m0t1conS";
$lang['fontface'] = "f0n+ pH4C3";
$lang['size'] = "sIze";
$lang['colour'] = "colOUr";
$lang['red'] = "r3D";
$lang['orange'] = "oR4N9E";
$lang['yellow'] = "yElL0W";
$lang['green'] = "gre3N";
$lang['blue'] = "blu3";
$lang['indigo'] = "iNd1g0";
$lang['violet'] = "viOLeT";
$lang['white'] = "whiT3";
$lang['black'] = "bLack";
$lang['grey'] = "gr3y";
$lang['pink'] = "p1Nk";
$lang['lightgreen'] = "liGh+ 9reen";
$lang['lightblue'] = "lIgh+ Blue";

// Forum Stats --------------------------------

$lang['forumstats'] = "f0rum ST@T\$";
$lang['userstats'] = "us3r St4t\$";

$lang['usersactiveinthepasttimeperiod'] = "%s 4ctIV3 in Teh PAst %s.";

$lang['numactiveguests'] = "<b>%s</b> 9u3s+s";
$lang['oneactiveguest'] = "<b>1</b> 9u3\$T";
$lang['numactivemembers'] = "<b>%s</b> Mem8ER\$";
$lang['oneactivemember'] = "<b>1</b> m3m83R";
$lang['numactiveanonymousmembers'] = "<b>%s</b> @n0NymoUS MeM83r\$";
$lang['oneactiveanonymousmember'] = "<b>1</b> 4NOnYMOUs MEmb3r";

$lang['numthreadscreated'] = "<b>%s</b> THR34ds";
$lang['onethreadcreated'] = "<b>1</b> +hre@D";
$lang['numpostscreated'] = "<b>%s</b> po\$T5";
$lang['onepostcreated'] = "<b>1</b> POs+";

$lang['younormal'] = "j00";
$lang['youinvisible'] = "j00 (INvI5I8LE)";
$lang['viewcompletelist'] = "v1eW comPLet3 L1s+";
$lang['ourmembershavemadeatotalofnumthreadsandnumposts'] = "our M3M83Rs H@v3 m4de a +oTal 0ph %s 4nd %s.";
$lang['longestthreadisthreadnamewithnumposts'] = "lOn93s+ THR34D Is <b>%s</b> With %s.";
$lang['therehavebeenxpostsmadeinthelastsixtyminutes'] = "tH3r3 h4v3 b3en <b>%s</b> Po\$ts M@dE IN t3h L4st 60 m1nu+Es.";
$lang['therehasbeenonepostmadeinthelastsixtyminutes'] = "th3r3 h4S B3En <b>1</b> P0\$t m4de in THe L@ST 60 minute\$.";
$lang['mostpostsevermadeinasinglesixtyminuteperiodwasnumposts'] = "mo\$+ PO\$t\$ 3v3r m4de 1N 4 s1N9LE 60 m1nUtE pEr1OD iS <b>%s</b> 0N %s.";
$lang['wehavenumregisteredmembersandthenewestmemberismembername'] = "w3 H@v3 <b>%s</b> rE9Is+ER3D M3Mb3R5 4ND +h3 NeWesT mem83R i\$ <b>%s</b>.";
$lang['wehavenumregisteredmember'] = "we H4VE %s reg1\$t3r3D meM83r\$.";
$lang['wehaveoneregisteredmember'] = "w3 H@V3 0n3 RE91\$t3R3d M3M8ER.";
$lang['mostuserseveronlinewasnumondate'] = "m0St USEr\$ 3vER 0nl1Ne W4\$ <b>%s</b> On %s.";
$lang['statsdisplaychanged'] = "s+@+S Di\$pl4y ch@nGED";

$lang['viewtop20'] = "v13w +0P 20";

$lang['folderstats'] = "f0lder s+4tS";
$lang['threadstats'] = "tHr34d 5+4+S";
$lang['poststats'] = "p0\$T S+4+5";
$lang['pollstats'] = "pOlL s+4t\$";
$lang['attachmentsstats'] = "att@chMEnTs \$t@T\$";
$lang['userpreferencesstats'] = "u5eR PrEPher3nC3\$ \$+4+s";
$lang['visitorstats'] = "viS1+oR s+4t\$";
$lang['sessionstats'] = "seSs10n sT@t\$";
$lang['profilestats'] = "pRoPH1l3 s+4+s";
$lang['signaturestats'] = "sIgN@ture ST4t\$";
$lang['ageandbirthdaystats'] = "a93 4ND b1rthd4Y \$Ta+s";
$lang['relationshipstats'] = "reL4ti0n\$h1p S+4+s";
$lang['wordfilterstats'] = "wOrD phIL+Er S+4+S";

$lang['numberoffolders'] = "nuMB3r OPh Ph0ld3rs";
$lang['folderwithmostthreads'] = "fOlDeR w1+h MOst THread5";
$lang['folderwithmostposts'] = "f0Lder WitH m0s+ poST\$";
$lang['totalnumberofthreads'] = "tOTal NUMb3r oph tHR3@ds";
$lang['longestthread'] = "l0n93\$T thREad";
$lang['mostreadthread'] = "mo\$T rE@d +HrEAd";
$lang['threadviews'] = "v1Ews";
$lang['averagethreadcountperfolder'] = "aveR49e +HR3AD cOUN+ peR f0lDEr";
$lang['totalnumberofthreadsubscriptions'] = "tOT@l NUm8er 0f +hr3@D Su8\$CriP+1oNs";
$lang['mostpopularthreadbysubscription'] = "m0St pOPul@R THREad By Sub\$criPTioN";
$lang['totalnumberofposts'] = "tOt@L Num83r 0f P0st\$";
$lang['numberofpostsmadeinlastsixtyminutes'] = "numb3R 0ph PO5+s M4de in L@S+ 60 minU+e\$";
$lang['mostpostsmadeinasinglesixtyminuteperiod'] = "mOS+ Po\$t\$ m4De 1n 0N3 60 miNUTe period";
$lang['averagepostsperuser'] = "aVEr@G3 P0s+S peR user";
$lang['topposter'] = "tOP Po\$T3r";
$lang['totalnumberofpolls'] = "tOT@l num83r opH P0lLs";
$lang['totalnumberofpolloptions'] = "t0+@L NUmB3r OpH polL OP+1oN\$";
$lang['averagevotesperpoll'] = "aVEr4g3 vo+35 PeR P0LL";
$lang['totalnumberofpollvotes'] = "tO+@l nuMb3r oph P0Ll vo+3\$";
$lang['totalnumberofattachments'] = "tOt@L Num83R 0f 4T+4Chmen+5";
$lang['averagenumberofattachmentsperpost'] = "aV3R4g3 @t+4CHM3n+ C0UN+ per PoS+";
$lang['mostdownloadedattachment'] = "m0\$+ DownLO4deD 4++4chm3N+";
$lang['mostusedforumstyle'] = "m0\$+ uS3D f0rUM style";
$lang['mostusedlanguuagefile'] = "m0S+ Used l4n9u4gE FIle";
$lang['mostusedtimezone'] = "m0\$+ U\$ED tIM3 z0N3";
$lang['mostusedemoticonpack'] = "mOS+ U\$Ed eM0Ticon P4CK";

$lang['numberofusers'] = "nuM83R Oph UseRS";
$lang['newestuser'] = "newES+ u5ER";
$lang['numberofcontributingusers'] = "nUMB3r OF c0nTR1BuT1N9 uS3r5";
$lang['numberofnoncontributingusers'] = "nUMBer 0pH NON-C0n+rIBu+1n9 u53rs";
$lang['subscribers'] = "subSCri8erS";

$lang['numberofvisitorstoday'] = "numb3R 0F v1s1+0rs TOday";
$lang['numberofvisitorsthisweek'] = "numbEr 0f V1S1+0r\$ +H1s w33K";
$lang['numberofvisitorsthismonth'] = "nUMB3r OF ViSitor\$ +hiS moN+h";
$lang['numberofvisitorsthisyear'] = "nUm83r 0F V1\$1+ors +hiS YE4r";

$lang['totalnumberofactiveusers'] = "tOt@L Number OF @ctiV3 U5erS";
$lang['numberofactiveregisteredusers'] = "nUMB3R 0f 4ctiV3 RE9i\$T3reD U\$Ers";
$lang['numberofactiveguests'] = "nUmb3r of 4Ctiv3 9u3s+S";
$lang['mostuserseveronline'] = "mO\$T uS3r\$ Ever 0nL1N3";
$lang['mostactiveuser'] = "mo\$t 4ct1v3 u\$3R";
$lang['numberofuserswithprofile'] = "nuMB3r 0F U\$Ers WI+h PROph1L3";
$lang['numberofuserswithoutprofile'] = "nuM83r 0f USErs W1thOu+ pRof1le";
$lang['numberofuserswithsignature'] = "nUM83R 0f uSErs w1+H SI9NaTUR3";
$lang['numberofuserswithoutsignature'] = "nUm83R oF userS wi+h0UT \$1Gn@ture";
$lang['averageage'] = "aVER493 493";
$lang['mostpopularbirthday'] = "mO5T poPUlar 8ir+Hd4Y";
$lang['nobirthdaydataavailable'] = "no 8ir+HD4y Da+4 4v4iL@8le";
$lang['numberofusersusingwordfilter'] = "numb3r oph u\$eRs U\$1N9 woRD F1lter";
$lang['numberofuserreleationships'] = "nUM83R 0ph Us3r Rel@+I0nsHIPS";
$lang['averageage'] = "aV3r@93 493";
$lang['averagerelationshipsperuser'] = "aV3r4GE rel4+10N\$h1PS p3R uSEr";

$lang['numberofusersnotusingwordfilter'] = "nUm83r Oph U\$ErS n0t USIng wOrD PhiLTer";
$lang['averagewordfilterentriesperuser'] = "aVeR@93 wORd ph1lter entries pEr uSEr";

$lang['mostuserseveronlinedetail'] = "%s oN %s";

// Thread Options (thread_options.php) ---------------------------------

$lang['updatessavedsuccessfully'] = "uPD4+eS s@v3D SucCe\$SphuLLy";
$lang['useroptions'] = "useR oP+ION\$";
$lang['markedasread'] = "mark3D @s R34d";
$lang['postsoutof'] = "p0st\$ out 0f";
$lang['interest'] = "in+3r3s+";
$lang['closedforposting'] = "clOsed fOR p0S+1ng";
$lang['locktitleandfolder'] = "locK +1+L3 and fold3r";
$lang['deletepostsinthreadbyuser'] = "dEle+E p0\$t5 IN +HR3@d by uSEr";
$lang['deletethread'] = "d3lE+3 THrE4d";
$lang['permenantlydelete'] = "peRm@N3n+lY d3l3+3";
$lang['movetodeleteditems'] = "m0V3 TO d3leTED tHR3@d\$";
$lang['undeletethread'] = "unD3l3+e tHRe4d";
$lang['markasunread'] = "m4Rk a\$ unr34d";
$lang['makethreadsticky'] = "m@K3 +hRE4D \$ticky";
$lang['threareadstatusupdated'] = "tHR3ad R34D sTa+us UPD@ted succ3\$\$FullY";
$lang['interestupdated'] = "thre@d INTer3\$t s+4+us Upda+ED sUcce\$sphulLy";
$lang['threadwassuccessfullydeleted'] = "tHrE4d W@S suCcE\$sFUlly DEl3t3d";
$lang['threadwassuccessfullyundeleted'] = "thR3aD W@s sucC3\$spHUlly UNdele+ed";
$lang['failedtoupdatethreadreadstatus'] = "f@Il3d +O uPd4+e +hR3AD re4D St@tu\$";
$lang['failedtoupdatethreadinterest'] = "f41LED +0 upd4Te tHRe4d INter3St";
$lang['failedtorenamethread'] = "f@il3d To REn4m3 THr34D";
$lang['failedtomovethread'] = "f4ILED tO m0ve thRE4D +0 speC1F13D fOLdEr";
$lang['failedtoupdatethreadstickystatus'] = "f41l3D +0 UPdA+e +Hre4D \$tIcky \$ta+us";
$lang['failedtoupdatethreadclosedstatus'] = "f@iLEd +0 uPDa+e +hre4d CloSEd S+@TuS";
$lang['failedtoupdatethreadlockstatus'] = "f41L3D +0 upd4te THR3@d l0Ck st@+uS";
$lang['failedtodeletepostsbyuser'] = "f41LeD +o D3letE PoS+S 8y \$elected uSEr";
$lang['failedtodeletethread'] = "f41l3D +0 d3L3TE ThreaD.";
$lang['failedtoundeletethread'] = "f@ILeD +0 un-D3L3Te thre@d";

// Folder Options (folder_options.php) ---------------------------------

$lang['folderoptions'] = "foLDEr Opti0NS";
$lang['foldercouldnotbefound'] = "th3 R3qu3\$t3D PhOLd3R cOuld n0t 83 ph0und 0R @cC3Ss w4s DeNIED.";
$lang['failedtoupdatefolderinterest'] = "fa1l3d +0 upda+e f0lder 1nter3\$t";

// Dictionary (dictionary.php) -----------------------------------------

$lang['dictionary'] = "d1cTion4rY";
$lang['spellcheck'] = "sp3ll CHeCK";
$lang['notindictionary'] = "n0+ 1n d1ctiONaRY";
$lang['changeto'] = "ch4NGe TO";
$lang['restartspellcheck'] = "r3\$+4rt";
$lang['cancelchanges'] = "c4nCeL ch@N9eS";
$lang['initialisingdotdotdot'] = "in1+1Al1\$IN9...";
$lang['spellcheckcomplete'] = "sP3lL check iS C0MPlE+E. tO reST@r+ \$pELl ch3ck clIcK r3st@R+ 8u+ToN 83l0w.";
$lang['spellcheck'] = "speLl cheCK";
$lang['noformobj'] = "nO phOrm 08jec+ \$PeCiPhied f0r r3turN +3x+";
$lang['ignore'] = "igN0re";
$lang['ignoreall'] = "i9Nore @lL";
$lang['change'] = "ch@nG3";
$lang['changeall'] = "cH4N93 @ll";
$lang['add'] = "aDD";
$lang['suggest'] = "suG93st";
$lang['nosuggestions'] = "(nO sUgg3S+1on5)";
$lang['cancel'] = "c4nCEL";
$lang['dictionarynotinstalled'] = "no d1c+1oN@ry haS b3eN 1nS+4lleD. pl345E c0N+4C+ +he foRUm 0wn3R t0 remedy TH1S.";

// Permissions keys ----------------------------------------------------

$lang['postreadingallowed'] = "p05+ RE4D1ng 4lL0WeD";
$lang['postcreationallowed'] = "po\$t cr34TiOn 4ll0weD";
$lang['threadcreationallowed'] = "tHRe@D CR34+i0n @lL0w3d";
$lang['posteditingallowed'] = "pOSt eDItiN9 4LL0WEd";
$lang['postdeletionallowed'] = "poSt DEL3+10n 4LLOw3D";
$lang['attachmentsallowed'] = "upLO@d1n9 @tt@Chments 4LLOW3d";
$lang['htmlpostingallowed'] = "hTMl PO\$tIng 4lL0W3D";
$lang['usersignatureallowed'] = "u5eR s1Gn@+URe 4LLOw3d";
$lang['guestaccessallowed'] = "gU3St 4Cc3\$\$ @ll0W3d";
$lang['postapprovalrequired'] = "p05+ @Ppr0VAl REQUir3D";

// RSS feeds gubbins

$lang['rssfeed'] = "rS\$ PH33D";
$lang['every30mins'] = "evERY 30 M1nUT35";
$lang['onceanhour'] = "once 4n hour";
$lang['every6hours'] = "eVEry 6 hour5";
$lang['every12hours'] = "ev3ry 12 hOurs";
$lang['onceaday'] = "oNc3 4 d4y";
$lang['onceaweek'] = "oNc3 4 WEek";
$lang['rssfeeds'] = "r\$5 f3ed5";
$lang['feedname'] = "f33d n@m3";
$lang['feedfoldername'] = "f33d F0Ld3r N4me";
$lang['feedlocation'] = "f33d LOc4+10N";
$lang['threadtitleprefix'] = "tHR34d T1+LE PR3PHiX";
$lang['feednameandlocation'] = "fE3d N@m3 @nd l0ca+1on";
$lang['feedsettings'] = "f3eD Se+TIn9s";
$lang['updatefrequency'] = "upd4T3 phrEQuENCy";
$lang['maxitemcount'] = "maX ITem COUn+";
$lang['maxitemcounthint'] = "m1N: 1, m4x: 10";
$lang['rssclicktoreadarticle'] = "cl1cK h3r3 +o REad +h1s 4RtiCL3";
$lang['addnewfeed'] = "aDD N3w PH3Ed";
$lang['editfeed'] = "edIt f3ed";
$lang['feeduseraccount'] = "feed us3r 4ccOUNt";
$lang['noexistingfeeds'] = "n0 3X1\$tiN9 Rss ph33D\$ F0und. +0 4Dd @ fe3d cLIck t3h '4Dd NEw' BU+T0n 83lOW";
$lang['rssfeedhelp'] = "heRE j00 C4n \$E+uP sOM3 r5\$ F3edS ph0r @U+oM4Tic prOP4g4ti0n IN+o youR forum. the It3M\$ pHRom Th3 rSs pH3ED\$ J00 @dd w1ll b3 cre4t3D @\$ thR34ds Which u5er5 c@n rePLy +O 4s IF +h3y W3r3 noRm4L POS+s. +he R\$S PHeED muST BE @CCE\$s1Ble V1a HT+p 0r iT WIll n0t WORk.";
$lang['mustspecifyrssfeedname'] = "mUs+ \$peciphy RSS fE3d N@mE";
$lang['mustspecifyrssfeeduseraccount'] = "mu\$T sp3C1phy R5S fEed uSEr 4cc0Un+";
$lang['mustspecifyrssfeedfolder'] = "mu5t 5pecifY r5s fe3d PH0ld3r";
$lang['mustspecifyrssfeedurl'] = "mU5t Sp3CIFy Rs\$ f3eD Url";
$lang['mustspecifyrssfeedupdatefrequency'] = "muS+ \$P3C1PHy rs\$ ph3ED UpD4+e FR3Qu3ncy";
$lang['maxitemcountmustbebetween1and10'] = "m@x 1+em couNT MusT 83 b3tWEen 1 @ND 10";
$lang['unknownrssuseraccount'] = "uNkNoWn r5\$ U\$er 4Cc0uNT";
$lang['rssfeedsupportshttpurlsonly'] = "r\$s FE3D \$uppoRTS hT+P url\$ onLY. \$ECUre phe3d\$ (hT+ps://) 4R3 N0+ 5uPP0R+ed.";
$lang['rssfeedurlformatinvalid'] = "r55 pHE3d url PH0RM4t Is 1nvALid. URL MUst InClud3 Sch3m3 (E.g. h+TP://) aND @ Hos+n4me (e.9. wWw.H0Stnam3.cOM).";
$lang['rssfeeduserauthentication'] = "rs\$ FE3D doe\$ n0t sUPP0rT h+tP us3r @u+henTIc4+10N";
$lang['successfullyremovedselectedfeeds'] = "sUCC3s\$fulLY REM0V3d S3lEc+3D f3ed\$";
$lang['successfullyaddedfeed'] = "sUcCESsPhullY 4dd3D NEw PH33D";
$lang['successfullyeditedfeed'] = "sUccesSPhuLLY edit3d Fe3d";
$lang['failedtoremovefeeds'] = "f@Il3D TO reMovE \$om3 OR @ll 0ph TEh 5el3c+ed feeDs";
$lang['failedtoaddnewrssfeed'] = "faIl3d tO 4dD N3w rS\$ ph3eD";
$lang['failedtoupdaterssfeed'] = "f41led To upD4t3 RS5 pH3Ed";
$lang['rssstreamworkingcorrectly'] = "r5s stream 4pp3arS +0 b3 w0RK1n9 CoRR3Ctly";
$lang['rssstreamnotworkingcorrectly'] = "rSs 5+R34M w45 3MP+y OR CoULd noT b3 PHouNd";
$lang['invalidfeedidorfeednotfound'] = "iNvAl1d F3ED 1d OR Ph3Ed n0+ ph0und";

// PM Export Options

$lang['pmexportastype'] = "eXp0r+ as tYpe";
$lang['pmexporthtml'] = "h+Ml";
$lang['pmexportxml'] = "xMl";
$lang['pmexportplaintext'] = "pl4IN T3xT";
$lang['pmexportmessagesas'] = "eXPOR+ M3s54geS 4s";
$lang['pmexportonefileforallmessages'] = "one F1LE fOR @ll M3S\$4gES";
$lang['pmexportonefilepermessage'] = "onE f1LE per ME\$s4g3";
$lang['pmexportattachments'] = "expOr+ 4t+@ChmeNTS";
$lang['pmexportincludestyle'] = "inClUde PHOrUM STYlE sh3ET";
$lang['pmexportwordfilter'] = "apPlY w0rd f1lt3R to M3S\$@9es";
$lang['failedtoexportmessages'] = "fA1l3d tO 3xpor+ m3s\$49e\$";

// Thread merge / split options

$lang['threadhasbeensplit'] = "thRe@d Has 83EN \$pl1t";
$lang['threadhasbeenmerged'] = "tHR34D h4s 8E3n MerG3d";
$lang['mergesplitthread'] = "m3rG3 / 5PliT thrE@d";
$lang['mergewiththreadid'] = "meR9e w1+h THRead 1D:";
$lang['postsinthisthreadatstart'] = "p0\$t\$ IN tH15 +Hre4D @+ S+4R+";
$lang['postsinthisthreadatend'] = "pO5t\$ 1n ThiS +HRe4d @+ 3nd";
$lang['reorderpostsintodateorder'] = "r3-ord3R poST\$ in+0 d4+E 0rDer";
$lang['splitthreadatpost'] = "spl1+ +Hr34D @t pOs+:";
$lang['selectedpostsandrepliesonly'] = "s3LEcted POsT @Nd r3plie5 0nlY";
$lang['selectedandallfollowingposts'] = "sel3C+3d 4nd 4ll F0llow1n9 PosT\$";

$lang['threadmovedhere'] = "heRe";

$lang['thisthreadhasmoved'] = "<b>thRE4dS mer9eD:</b> +HIs +Hre@d h4\$ m0V3D %s";
$lang['thisthreadwasmergedfrom'] = "<b>thRe4DS mER93d:</b> th15 Thr3ad w@S MergeD phR0M %s";
$lang['somepostsinthisthreadhavebeenmoved'] = "<b>thre@D sPLIT:</b> \$0mE p0S+s In +hIS +hreAD h@v3 b3EN M0VED %s";
$lang['somepostsinthisthreadweremovedfrom'] = "<b>thrE4d \$pli+:</b> \$om3 poS+S IN +hiS +HRe4D weR3 M0ved pHRom %s";

$lang['thisposthasbeenmoved'] = "<b>thre@D sPL1+:</b> Th1\$ poS+ h4\$ B3en MOved %s";

$lang['invalidfunctionarguments'] = "inv4lID phUNc+10n @R9UM3NtS";
$lang['couldnotretrieveforumdata'] = "c0uLd nO+ r3+RI3vE ForuM d4+@";
$lang['cannotmergepolls'] = "oNe OR moRe thre4D\$ is @ p0ll. J00 c4NnO+ m3rge poLlS";
$lang['couldnotretrievethreaddatamerge'] = "coUlD n0+ Re+r1EVe thRE4D d@T@ phroM 0n3 0r M0RE +HRe4d5";
$lang['couldnotretrievethreaddatasplit'] = "c0uLD n0t RE+riev3 +hre4d d@TA FRom \$ouRce ThRE4D";
$lang['couldnotretrievepostdatamerge'] = "couLD n0+ R3Tr13v3 p0S+ Dat4 fr0m 0n3 0R M0re threads";
$lang['couldnotretrievepostdatasplit'] = "cOuLD n0T Re+rIev3 poST D@+4 fr0m \$ource tHRead";
$lang['failedtocreatenewthreadformerge'] = "f4ILED +0 crEa+e NeW ThrE4d f0r M3r93";
$lang['failedtocreatenewthreadforsplit'] = "f4IL3d tO cr34+e NEw thRe4d F0R 5pliT";
$lang['nopermissiontomergethreads'] = "j00 AR3 N0+ p3rmITted +O m3r9E Teh \$eLect3d ThrEAds";
$lang['failedtoexecutethreadmergequery'] = "f@1l3D to ex3Cu+3 thR34d merG3 quEry";
$lang['failedtoexecutethreadsplitquery'] = "f4Il3D +0 execut3 tHRE@D SPl1t Qu3ry";

// Thread subscriptions

$lang['threadsubscriptions'] = "tHR34d 5u85Cr1pTI0n\$";
$lang['couldnotupdateinterestonthread'] = "c0Uld n0t Upd@+e IN+3r3\$t 0n tHR34D '%s'";
$lang['threadinterestsupdatedsuccessfully'] = "tHR3@D 1nT3RE\$T5 Upda+3d SucC3sSphully";
$lang['nothreadsubscriptions'] = "j00 4rE NoT SU8\$Cri83D TO 4nY THr34dS.";
$lang['nothreadsignored'] = "j00 @RE not I9NorinG 4ny +HreAd\$.";
$lang['nothreadsonhighinterest'] = "j00 H@V3 no h19h inter3\$t +HReaD\$.";
$lang['resetselected'] = "re\$3t s3Lec+ed";
$lang['ignoredthreads'] = "igNoR3D +HRe4Ds";
$lang['highinterestthreads'] = "hIgH 1n+3r35T thread\$";
$lang['subscribedthreads'] = "sU8scRI83D THRE4dS";
$lang['currentinterest'] = "cURren+ int3r3sT";

// Folder subscriptions

$lang['foldersubscriptions'] = "fOlDEr 5UbscRIp+1ons";
$lang['couldnotupdateinterestonfolder'] = "coUlD N0T upd@+e 1n+3res+ on FoldEr '%s'";
$lang['folderinterestsupdatedsuccessfully'] = "f0ldEr 1nT3REsT\$ upd@ted SUcC3s\$fullY";
$lang['nofoldersubscriptions'] = "j00 @re nOT sUb\$Cri83D t0 4ny fOLdErs.";
$lang['nofoldersignored'] = "j00 4r3 n0t i9NOR1nG @ny PhoLDErs.";
$lang['resetselected'] = "r3SET \$EL3c+Ed";
$lang['ignoredfolders'] = "i9N0R3d F0lDERS";
$lang['subscribedfolders'] = "suBscR1b3D f0lD3Rs";

// Browseable user profiles

$lang['youcanonlyaddthreecolumns'] = "j00 C@n onLY add 3 coLUmnS. tO Add A N3w C0LumN cl0\$E @N exIs+1ng OnE";
$lang['columnalreadyadded'] = "j00 h@V3 4LreADy ADDeD +hi\$ C0lumN. if J00 W4Nt tO R3M0v3 1t CL1cK 1TS cLo5e 8U+t0N";

?>