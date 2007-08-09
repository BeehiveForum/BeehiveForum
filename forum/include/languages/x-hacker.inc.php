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

/* $Id: x-hacker.inc.php,v 1.237 2007-08-09 22:55:44 decoyduck Exp $ */

// British English language file

// Language character set and text direction options -------------------

$lang['_isocode'] = "en";
$lang['_textdir'] = "ltr";

// Months --------------------------------------------------------------

$lang['month'][1]  = "j@nU4RY";
$lang['month'][2]  = "fE8ru4RY";
$lang['month'][3]  = "m@rch";
$lang['month'][4]  = "april";
$lang['month'][5]  = "m4y";
$lang['month'][6]  = "juN3";
$lang['month'][7]  = "july";
$lang['month'][8]  = "aU9u5T";
$lang['month'][9]  = "sEpT3mbER";
$lang['month'][10] = "oCtOB3R";
$lang['month'][11] = "n0V3mb3R";
$lang['month'][12] = "d3c3M83R";

$lang['month_short'][1]  = "j4N";
$lang['month_short'][2]  = "f38";
$lang['month_short'][3]  = "m@R";
$lang['month_short'][4]  = "aPr";
$lang['month_short'][5]  = "may";
$lang['month_short'][6]  = "jUN";
$lang['month_short'][7]  = "jul";
$lang['month_short'][8]  = "aU9";
$lang['month_short'][9]  = "seP";
$lang['month_short'][10] = "oC+";
$lang['month_short'][11] = "n0V";
$lang['month_short'][12] = "d3C";

// Dates ---------------------------------------------------------------

// Various date and time formats as used by BeehiveForum. All times are
// expressed as 24 hour time format.

$lang['daymonthyear'] = "%s %s %s";                  // 1 Jan 2005
$lang['monthyear'] = "%s %s";                        // Jan 2005
$lang['daymonthyearhourminute'] = "%s %s %s %s:%s";  // 1 Jan 2005 12:00
$lang['daymonthhourminute'] = "%s %s %s:%s";         // 1 Jan 12:00
$lang['daymonth'] = "%s %s";                         // 1 Jan
$lang['hourminute'] = "%s:%s";                       // 12:00

// Periods -------------------------------------------------------------

// Various time periods as used by BeehiveForum.

$lang['date_periods']['year']   = "%s YE4r";
$lang['date_periods']['month']  = "%s M0NtH";
$lang['date_periods']['week']   = "%s w33K";
$lang['date_periods']['day']    = "%s d@Y";
$lang['date_periods']['hour']   = "%s h0ur";
$lang['date_periods']['minute'] = "%s M1nu+e";
$lang['date_periods']['second'] = "%s SecOnd";

// As above but plurals (2 years vs. 1 year, etc.)

$lang['date_periods_plural']['year']   = "%s Y3arS";
$lang['date_periods_plural']['month']  = "%s M0N+Hs";
$lang['date_periods_plural']['week']   = "%s w33kS";
$lang['date_periods_plural']['day']    = "%s d@y5";
$lang['date_periods_plural']['hour']   = "%s HourS";
$lang['date_periods_plural']['minute'] = "%s M1NutES";
$lang['date_periods_plural']['second'] = "%s SecOND\$";

// Short hand periods (example: 1y, 2m, 3w, 4d, 5hr, 6min, 7sec)

$lang['date_periods_short']['year']   = "%sY";    // 1y
$lang['date_periods_short']['month']  = "%sM";    // 2m
$lang['date_periods_short']['week']   = "%sw";    // 3w
$lang['date_periods_short']['day']    = "%sd";    // 4d
$lang['date_periods_short']['hour']   = "%shR";   // 5hr
$lang['date_periods_short']['minute'] = "%sM1N";  // 6min
$lang['date_periods_short']['second'] = "%s\$3C";  // 7sec

// Common words --------------------------------------------------------

$lang['percent'] = "peRcEn+";
$lang['average'] = "aVeR49e";
$lang['approve'] = "appr0Ve";
$lang['banned'] = "baNneD";
$lang['locked'] = "l0CKEd";
$lang['add'] = "aDd";
$lang['advanced'] = "adV4nc3D";
$lang['active'] = "aCT1V3";
$lang['style'] = "sTyle";
$lang['go'] = "gO";
$lang['folder'] = "foLD3r";
$lang['ignoredfolder'] = "i9NoR3d PH0LD3r";
$lang['folders'] = "foLDerS";
$lang['thread'] = "thR34D";
$lang['threads'] = "thR3adS";
$lang['threadlist'] = "thRE4d l1S+";
$lang['message'] = "m3S\$4ge";
$lang['messagenumber'] = "m3S\$493 NUmb3r";
$lang['from'] = "from";
$lang['to'] = "to";
$lang['all_caps'] = "aLL";
$lang['of'] = "oF";
$lang['reply'] = "r3PLy";
$lang['forward'] = "fOrw4Rd";
$lang['replyall'] = "r3PLy T0 4lL";
$lang['pm_reply'] = "rePLY 45 pm";
$lang['delete'] = "d3LEt3";
$lang['deleted'] = "dELeT3d";
$lang['edit'] = "edIt";
$lang['privileges'] = "pr1V1Le93S";
$lang['ignore'] = "iGN0R3";
$lang['normal'] = "norm4L";
$lang['interested'] = "iN+Er3st3d";
$lang['subscribe'] = "subSCribE";
$lang['apply'] = "applY";
$lang['download'] = "d0wnL04d";
$lang['save'] = "s@v3";
$lang['update'] = "upd4te";
$lang['cancel'] = "cAncEL";
$lang['retry'] = "reTRy";
$lang['continue'] = "con+1NUe";
$lang['attachment'] = "aT+4chM3nT";
$lang['attachments'] = "atT@cHmen+s";
$lang['imageattachments'] = "iM@ge 4++4chM3N+\$";
$lang['filename'] = "f1Len4Me";
$lang['dimensions'] = "d1Men51onS";
$lang['downloadedxtimes'] = "d0WNL04D3d: %d +IMeS";
$lang['downloadedonetime'] = "d0Wnl0@d3d: 1 TIm3";
$lang['size'] = "siZ3";
$lang['viewmessage'] = "v13w m3sS@g3";
$lang['deletethumbnails'] = "d3Le+3 +huMbn4IlS";
$lang['logon'] = "l09On";
$lang['more'] = "mOr3";
$lang['recentvisitors'] = "r3ceN+ v1Si+OR5";
$lang['username'] = "u53RN4me";
$lang['clear'] = "clE4R";
$lang['action'] = "aCT1On";
$lang['unknown'] = "uNKNOwN";
$lang['none'] = "n0N3";
$lang['preview'] = "pr3ViEw";
$lang['post'] = "p0\$T";
$lang['posts'] = "pOsts";
$lang['change'] = "cH@n93";
$lang['yes'] = "y3\$";
$lang['no'] = "n0";
$lang['signature'] = "sI9N4+UrE";
$lang['signaturepreview'] = "sIGN4turE prevIew";
$lang['signatureupdated'] = "siGn4+UR3 upd4+ED";
$lang['signatureupdatedforallforums'] = "s1gn4Tur3 upd4+ED phOr @ll f0rumS";
$lang['back'] = "back";
$lang['subject'] = "sUbJEC+";
$lang['close'] = "cl0\$e";
$lang['name'] = "n@m3";
$lang['description'] = "d3\$CR1P+i0N";
$lang['date'] = "d@t3";
$lang['view'] = "v13w";
$lang['enterpasswd'] = "en+Er P4SSWord";
$lang['passwd'] = "p4sSW0rd";
$lang['ignored'] = "i9Nored";
$lang['guest'] = "guE5T";
$lang['next'] = "n3X+";
$lang['prev'] = "pREV10U5";
$lang['others'] = "othErS";
$lang['nickname'] = "n1cKN4m3";
$lang['emailaddress'] = "em4iL 4dDRES\$";
$lang['confirm'] = "c0NpH1rM";
$lang['email'] = "em4iL";
$lang['poll'] = "p0LL";
$lang['friend'] = "fr13ND";
$lang['error'] = "erR0r";
$lang['guesterror'] = "s0RRy, j00 neEd T0 b3 LOgg3d 1n TO U\$e thI\$ pH3@+uRE.";
$lang['loginnow'] = "lo9in n0W";
$lang['unread'] = "uNr3@D";
$lang['all'] = "aLL";
$lang['allcaps'] = "aLl";
$lang['permissions'] = "p3rMISsI0n5";
$lang['type'] = "tYPE";
$lang['print'] = "pRInt";
$lang['sticky'] = "s+1Cky";
$lang['polls'] = "poLlS";
$lang['user'] = "u5Er";
$lang['enabled'] = "enA8L3d";
$lang['disabled'] = "di\$4bled";
$lang['options'] = "op+I0nS";
$lang['emoticons'] = "em0+ic0n\$";
$lang['webtag'] = "wEBT4g";
$lang['makedefault'] = "m4KE D3phAult";
$lang['unsetdefault'] = "uNS3T dEf4Ul+";
$lang['rename'] = "r3N4me";
$lang['pages'] = "p4GeS";
$lang['used'] = "uS3D";
$lang['days'] = "d@YS";
$lang['usage'] = "u\$4G3";
$lang['show'] = "sH0w";
$lang['hint'] = "hIn+";
$lang['new'] = "nEW";
$lang['referer'] = "repH3R3r";

// Admin interface (admin*.php) ----------------------------------------

$lang['admintools'] = "admiN +o0l\$";
$lang['forummanagement'] = "foRUm M4N@9EMEnT";
$lang['accessdeniedexp'] = "j00 d0 N0t h4ve perM1S5i0n TO u\$3 +hI5 \$3c+10n.";
$lang['managefolders'] = "maN49e Ph0lderS";
$lang['manageforums'] = "m4N4G3 PHORum\$";
$lang['manageforumpermissions'] = "m4N@ge fOrUM PErm15S10n\$";
$lang['foldername'] = "fOlD3r N@ME";
$lang['move'] = "m0v3";
$lang['closed'] = "clOSeD";
$lang['open'] = "op3N";
$lang['restricted'] = "r35+riCted";
$lang['iscurrentlyclosed'] = "i5 CURr3n+LY clO\$ED";
$lang['youdonothaveaccessto'] = "j00 d0 nOt H@ve 4Cces5 tO";
$lang['toapplyforaccessplease'] = "tO 4ppLY ph0R 4cc3sS PLE4S3 c0n+@c+ +H3 fOrUm OWNEr.";
$lang['adminforumclosedtip'] = "iph j00 wAnT To cH4n9e S0M3 \$3t+1NG\$ 0n yOur FORuM Cl1cK +3H adMin l1Nk IN +eH n4v1g4+iOn b4r 48OV3.";
$lang['newfolder'] = "n3w pH0LDER";
$lang['forumadmin'] = "foruM 4dM1n";
$lang['adminexp_1'] = "us3 tHe M3nU On tH3 lePH+ To m@n@G3 THInGs 1N Y0uR PHOrUM.";
$lang['adminexp_2'] = "<b>uS3rS</b> @LL0Ws j00 +o 53+ InD1v1Du4l Us3r p3rMis\$IoNS, iNclUdInG 4pp0In+1N9 3d1+0rS 4ND g499ing pe0PL3.";
$lang['adminexp_3'] = "<b>u53r gr0Up5</b> @LLow5 j00 T0 CR34+E us3r GR0up\$ to 4s\$igN p3RmI\$510ns tO @5 m4NY 0R aS pheW uSEr5 qU1cKLY @Nd 34\$ILy.";
$lang['adminexp_4'] = "<b>b4n c0ntROL\$</b> @ll0w\$ TeH B@nn1ng 4Nd UN-8aNN1ng 0F iP 4dDreS53s, u5eRN4Me5, 3maIL 4ddr3ssE\$ @nd n1cKn@meS.";
$lang['adminexp_5'] = "<b>fOld3R5</b> @lL0Ws +he crE4+i0n, m0dipHIC@t10n And D3leT10n 0pH PH0LderS.";
$lang['adminexp_6'] = "<b>rS5 pH3eds</b> 4Ll0ws j00 tO cr34Te 4nd r3mov3 rSS ph33ds f0r ProPo94+I0n int0 yOUr ForUm.";
$lang['adminexp_7'] = "<b>prOf1l3S</b> le+5 J00 cuSToMi53 T3h i+3M5 th4t 4ppe4R 1n Teh US3R propHil3\$.";
$lang['adminexp_8'] = "<b>foRUM s3+tiN95</b> @lLow\$ j00 +0 cuSt0mi53 yOur f0RUm'5 N@m3, 4PpeaR@nc3 4ND m@ny o+heR tH1N9S.";
$lang['adminexp_9'] = "<b>sT@R+ p4gE</b> letS j00 cu\$TOmI5e y0Ur Ph0ruM'5 5t4R+ P4Ge.";
$lang['adminexp_10'] = "<b>fORum styL3</b> 4LL0W5 J00 tO CRe4+e STyl3\$ f0R yoUr F0Rum M3M8ers +0 U5e.";
$lang['adminexp_11'] = "<b>w0rd F1L+3r</b> @llOw5 J00 To PHil+3r w0Rds j00 dOn't w@n+ +O bE uSeD ON yoUr pH0rUm.";
$lang['adminexp_12'] = "<b>p0St1N9 \$ta+\$</b> 93nEr4+3S 4 Rep0r+ LI5t1N9 thE tOP 10 po\$ter5 iN 4 DEfINeD pER10D.";
$lang['adminexp_13'] = "<b>forUm LiNK5</b> l3TS j00 M@n4ge th3 L1NKs dr0Pd0wN IN +h3 N@v1g4Ti0n 84r.";
$lang['adminexp_14'] = "<b>vI3W LOg</b> L1s+\$ rec3Nt 4cti0nS bY +Eh PhorUm M0D3r4t0r\$.";
$lang['adminexp_15'] = "<b>m4n493 Ph0ruM5</b> lE+\$ j00 cr34+3 4ND DEL3t3 4nd ClO\$e 0r r30pen FOruM\$.";
$lang['adminexp_16'] = "<b>gl0B4l f0ruM 5ettiN9s</b> 4ll0w\$ j00 +0 M0d1fY \$ETtIn95 whICH @ff3c+ @lL f0RumS.";
$lang['adminexp_17'] = "<b>p0st APpRov4l QU3u3</b> 4lL0w5 j00 +0 V1ew 4ny poS+\$ 4W41tin9 4pPR0v@l 8Y 4 Mod3r4+0r.";
$lang['adminexp_18'] = "<b>v1si+OR lo9</b> @lLow\$ j00 +0 Vi3w 4n eX+3Nded lI5t oPH vI\$it0r5 incLUDing +HEIR h+TP rEF3RErs.";
$lang['createforumstyle'] = "cr3@+e 4 pH0rUM 5TYl3";
$lang['newstylesuccessfullycreated'] = "new STyl3 %s Succ3SSfulLy cR3aTed.";
$lang['stylealreadyexists'] = "a \$tyl3 w1tH Th4+ F1Len4ME 4lre4Dy 3xIs+5.";
$lang['stylenofilename'] = "j00 d1d NO+ enT3r 4 PHil3n@M3 +0 S4ve tEh STyL3 wi+H.";
$lang['stylenodatasubmitted'] = "cOuld noT r34d F0rum 5tyLE d4+4.";
$lang['styleexp'] = "uSe tH1\$ p@G3 +o help cR34+3 @ R4nd0mLY 9eN3r4+ED stYLe PH0r YOUr PHorUm.";
$lang['stylecontrols'] = "c0ntrolS";
$lang['stylecolourexp'] = "cL1ck 0n @ c0lOUr T0 M@Ke 4 n3w sTYL3 ShE3T b45Ed On +h4+ CoL0ur. cURreNt b4\$e cOlOur I5 F1r5t 1N l15+.";
$lang['standardstyle'] = "s+4nd@rd STyLe";
$lang['rotelementstyle'] = "r0+4+Ed 3L3men+ 5+yLE";
$lang['randstyle'] = "r4NDom 5tyL3";
$lang['thiscolour'] = "tH1S C0lOUR";
$lang['enterhexcolour'] = "oR EnteR 4 HEx c0l0ur To 8@\$e 4 nEW StyLe 5Heet on";
$lang['savestyle'] = "s@V3 +HIs \$TyLe";
$lang['styledesc'] = "styl3 dEScR1P+10n";
$lang['fileallowedchars'] = "(lOWErc4\$E lett3r\$ (@-z), num83rS (0-9) 4nd UndeR5C0R3S (_) 0Nly)";
$lang['stylepreview'] = "sTYL3 pr3v1EW";
$lang['welcome'] = "weLc0M3";
$lang['messagepreview'] = "mESS49e PREV1eW";
$lang['users'] = "uS3rS";
$lang['usergroups'] = "u\$ER 9rOuP\$";
$lang['mustentergroupname'] = "j00 Mu5t 3Nter 4 gr0Up n4Me";
$lang['profiles'] = "pr0f1Le5";
$lang['manageforums'] = "m4N49E Ph0RumS";
$lang['forumsettings'] = "f0ruM SET+INg5";
$lang['globalforumsettings'] = "gl0B@l ph0rum 5E++1Ng\$";
$lang['settingsaffectallforumswarning'] = "<b>no+E:</b> +heSe Sett1ngs 4fFec+ 4ll pH0ruM\$. WHer3 +he S3T+iNg I5 DupL1c4+ed on th3 1ndIv1Du@L f0rum's S3++1nG\$ pA9E th4+ w1lL +4k3 prEc3D3nce 0VER +He SE+T1n9S j00 ch4nGe hEre.";
$lang['startpage'] = "s+4rT p49E";
$lang['startpageerror'] = "yOUr st4rT P@gE c0Uld N0+ 83 \$4v3D l0c4Lly TO +EH ServEr bEC@uSE p3rmIs5Ion w4\$ DEn1ed.</p><p>t0 CH4N93 youR sT4r+ Pa93 Ple4\$3 click th3 D0wNl0@D 8U++ON 83loW wH1ch WIll prOmpt j00 +0 54v3 +HE F1L3 tO yOUr H4rd dr1V3. j00 C@N +HeN UPL0@d tHi5 phIl3 +O y0UR \$eRv3r InTO t3h F0Ll0w1Ng ph0lDER, 1PH NEcE\$S4ry CR34+in9 THE PH0ldER \$TrucTuRE 1N +3h pROcEsS.</p><p><b>%s</b></p><p>plE@53 nO+3 tH@+ s0M3 bR0wSeRS m@y cH@n93 +EH n4ME oPh +eH f1l3 UP0n DOWnL0@d.  wHEn upLO@d1nG TEh pHile pL3@SE m@k3 5uRe tH4+ 1T IS n@Med \$+4R+_m41N.PhP o+hERW15E YOUr ST4R+ P4ge wIll 4pP34R UnCH4n9Ed.";
$lang['failedtoopenmasterstylesheet'] = "yOUr phoRUm StYle cOulD No+ BE s4v3d 83c4USe th3 M4\$T3R 5tyLe \$HeE+ c0ulD n0+ 83 lO@DEd. +0 \$4vE Y0uR \$TYlE tHe m45teR \$tyLe \$H3ET (M@KE_StYLe.Css) mu5t 83 lOc4T3d 1N tH3 \$TYl3S D1RecToRY Of yoUR b33h1V3 FOrUm 1nST4ll@T1oN.";
$lang['makestyleerror'] = "y0ur pHORum 5+YL3 COuld n0+ 83 \$4v3d lOc4Lly +0 th3 \$erv3R 8ec4uSe p3rmI5s10n w@5 D3ni3d. t0 \$4v3 yOur Ph0rum \$+yL3 pLE4s3 cl1cK +eH downL04d 8u+T0N 83Low wH1ch wIll pr0mP+ j00 tO s4vE TH3 phILe +0 y0Ur H@RD dRiVe. J00 C4N +hEn upL0@d +HIS phILe TO YOUr 5ErVER 1Nt0 %s pH0Ld3r, 1F N3cesSaRY CRe4+IN9 t3H PhoLD3r S+ruCtURe iN +3h pr0C3\$S. J00 5houLd N0T3 +h4+ s0M3 bR0W\$3r\$ m4Y Ch4Nge Th3 N4mE 0pH +hE F1Le up0n dOwNLO@d. wHEn UpL04diN9 +hE F1LE PLE45E M@k3 5Ur3 Th@+ 1+ 15 n@med \$TYL3.C5s o+heRw1SE t3H F0rUM 5+YlE W1Ll be uNuS@8L3.";
$lang['uploadfailed'] = "yoUr neW \$t4RT P493 coulD nO+ bE UPL0@d3d +o T3h \$erv3r 8ec@uSe peRmIS51ON w45 den13d. pl34se ch3ck +h4t +Eh w3b 5erv3R / php pR0c3S\$ iS @8l3 +o Wri+3 tO T3h %s PHold3r oN YOur \$Erv3r.";
$lang['forumstyle'] = "f0rum sTYl3";
$lang['wordfilter'] = "woRd phil+eR";
$lang['forumlinks'] = "f0RUm L1nks";
$lang['viewlog'] = "v1Ew log";
$lang['noprofilesectionspecified'] = "no proph1L3 Sect10n \$Pec1PHiEd.";
$lang['itemname'] = "it3m N4M3";
$lang['moveto'] = "moV3 TO";
$lang['manageprofilesections'] = "m4N@Ge ProF1Le 53ctiOn\$";
$lang['sectionname'] = "sectI0n N@M3";
$lang['items'] = "i+3m\$";
$lang['mustspecifyaprofilesectionid'] = "mUst \$PEciFy 4 PrOPhilE s3CT10n id";
$lang['mustsepecifyaprofilesectionname'] = "mu\$T \$pec1fy @ pR0FilE sECt10N n@me";
$lang['successfullyeditedprofilesection'] = "succe\$sFulLy edi+ED prOF1lE \$3c+ion";
$lang['addnewprofilesection'] = "add N3W pR0fILE 53cT1on";
$lang['mustsepecifyaprofilesectionname'] = "mu\$+ \$p3ciPHy @ pR0PHile 5EcTI0n N@me";
$lang['successfullyremovedselectedprofilesections'] = "sUcc3SSPhuLly r3MovED S3lECTeD pR0File 5ec+I0n5";
$lang['failedtoremoveprofilesections'] = "f@1L3D +0 r3MOv3 PR0phIl3 \$ECTi0N5";
$lang['viewitems'] = "vieW 1+ems";
$lang['successfullyremovedselectedprofileitems'] = "succ35sfully r3MOv3d s3Lected prOph1le 1+3MS";
$lang['failedtoremoveprofileitems'] = "f41lEd tO r3m0ve pR0Ph1l3 1+EmS";
$lang['noexistingprofileitemsfound'] = "th3Re 4re nO 3XiS+1n9 Pr0phile ITemS iN th1\$ sec+i0N. +0 4dd 4 PR0phil3 1+EM CLicK th3 8uttON b3lOw.";
$lang['edititem'] = "edIT i+eM";
$lang['invaliditemidoritemnotfound'] = "iNv@l1d I+3M 1d OR 1TEM n0t phOunD";
$lang['addnewitem'] = "adD N3W i+em";
$lang['startpageupdated'] = "s+@Rt p4G3 UpD@+3D";
$lang['viewupdatedstartpage'] = "v1Ew upd4+3d st4rt Pa9E";
$lang['editstartpage'] = "eDI+ \$t4R+ p4g3";
$lang['nouserspecified'] = "nO U\$eR SPec1F13d.";
$lang['manageuser'] = "m4N49E uSEr";
$lang['manageusers'] = "m4N493 uSErS";
$lang['userstatusforforum'] = "u53R \$t4tU\$ Ph0R %s";
$lang['userdetails'] = "uSER det4il5";
$lang['warning_caps'] = "w@rn1n9";
$lang['userdeleteallpostswarning'] = "are j00 sUr3 J00 w4NT +0 DElet3 aLl 0pH +Eh \$El3c+ED u\$Er'S poST\$? 0ncE tHe PostS 4r3 Del3+ed +HeY c4Nno+ 83 re+r1ev3d and wIll 83 l0\$+ fOr3Ver.";
$lang['postssuccessfullydeleted'] = "p0ST\$ wEre SuCc355phUlLy DEl3+3D.";
$lang['folderaccess'] = "f0LD3R @Cc3SS";
$lang['possiblealiases'] = "pO\$s18le 4l14\$3\$";
$lang['userhistory'] = "uS3R H15toRY";
$lang['nohistory'] = "n0 H1ST0Ry REc0Rd5 \$4VEd";
$lang['userhistorychanges'] = "cH4n9es";
$lang['clearuserhistory'] = "cL3@R u5er HI\$tOry";
$lang['changedlogonfromto'] = "cH4N9ed lOg0n PHr0m %s tO %s";
$lang['changednicknamefromto'] = "chANGeD NIckN4Me pHr0m %s tO %s";
$lang['changedemailfromto'] = "cH@n93d 3m4IL fr0M %s TO %s";
$lang['nomatches'] = "no M4+ch3\$";
$lang['deleteposts'] = "del3+E Po\$TS";
$lang['deleteallusersposts'] = "deLe+e 4Ll OpH +HIs us3r'S Po\$TS";
$lang['noattachmentsforuser'] = "nO 4tT@chMentS PH0r +h15 u5er";
$lang['forgottenpassworddesc'] = "if +H15 UsER h@s FOrg0+teN tH31r P@S5w0rd J00 c4n R3SeT 1T fOr th3M H3r3.";
$lang['manageusersexp'] = "th1\$ LI\$t sh0W5 4 \$elEct1ON 0f U\$eRS who h@ve Log93d 0N tO Y0Ur FORum, Sor+ed by %s. t0 @Lt3r @ User's PErmIS\$i0nS CL1Ck ThE1R n@m3.";
$lang['userfilter'] = "u53R pHiL+3R";
$lang['onlineusers'] = "oNL1n3 US3r\$";
$lang['offlineusers'] = "oPHPhlIN3 useRs";
$lang['usersawaitingapproval'] = "u5eRS 4W4I+In9 4ppr0Val";
$lang['bannedusers'] = "b4Nn3D U5ErS";
$lang['lastlogon'] = "l4s+ lo9oN";
$lang['sessionreferer'] = "sE\$51on R3pH3rer";
$lang['signupreferer'] = "s1GN-Up R3Ph3r3R:";
$lang['nouseraccountsmatchingfilter'] = "nO US3R 4cC0un+S m4+CHiN9 F1LT3r";
$lang['searchforusernotinlist'] = "sE4Rch PhOr @ U\$ER nOt 1n l15+";
$lang['adminaccesslog'] = "aDm1N 4cCEs5 Log";
$lang['adminlogexp'] = "th15 l15t \$h0w\$ t3h l4sT 4c+i0nS 54nctIoN3D 8y U\$ErS W1+H @dm1N pR1v1l3g3\$.";
$lang['datetime'] = "d@+3/T1M3";
$lang['unknownuser'] = "uNkn0Wn u5Er";
$lang['unknownfolder'] = "uNkn0Wn F0LD3r";
$lang['ip'] = "iP";
$lang['lastipaddress'] = "l4st 1p 4DDr3\$S";
$lang['logged'] = "l0GG3D";
$lang['notlogged'] = "nO+ L0gged";
$lang['addwordfilter'] = "adD wOrd PHil+ER";
$lang['addnewwordfilter'] = "adD n3w W0rD FiltER";
$lang['wordfilterupdated'] = "woRD PH1lt3r UPD@T3D";
$lang['filtername'] = "fIlt3R N@mE";
$lang['filtertype'] = "f1L+3r TYPE";
$lang['filterenabled'] = "fIl+3r En@bL3d";
$lang['editwordfilter'] = "edit w0Rd Phil+Er";
$lang['nowordfilterentriesfound'] = "nO exI\$tIng WOrD fIl+er entr135 pH0uNd. T0 @DD @ w0rd pH1lter click +Eh bUt+ON 83L0w.";
$lang['mustspecifyfiltername'] = "j00 MU\$t Sp3c1fy 4 FilteR n@M3";
$lang['mustspecifymatchedtext'] = "j00 MuSt SPeciFy m@tchED +ext";
$lang['mustspecifyfilteroption'] = "j00 mu5t sp3c1Fy @ f1l+Er 0P+ion";
$lang['mustspecifyfilterid'] = "j00 mu\$T Sp3c1fy 4 PHilt3r 1d";
$lang['invalidfilterid'] = "inV4lId fiL+3r 1d";
$lang['failedtoupdatewordfilter'] = "f@ileD +O uPd4t3 word Ph1L+er. CH3ck tH@t t3h Ph1l+er ST1ll 3XiS+\$.";
$lang['allow'] = "alL0W";
$lang['block'] = "bLocK";
$lang['normalthreadsonly'] = "n0Rm@l +hre4Ds onLy";
$lang['pollthreadsonly'] = "polL tHr3AdS 0nly";
$lang['both'] = "bo+H thre4d TYPE5";
$lang['existingpermissions'] = "eX15t1ng pERmiS510N5";
$lang['nousers'] = "n0 u5erS";
$lang['searchforuser'] = "se4rcH PhoR u\$3r";
$lang['browsernegotiation'] = "broW\$3r N390+i4t3d";
$lang['largetextfield'] = "l4R9E teXt pHielD";
$lang['mediumtextfield'] = "m3DiUm +exT Ph1eLD";
$lang['smalltextfield'] = "sM4ll +Ext phI3ld";
$lang['multilinetextfield'] = "mULTI-LINe teXt pHi3lD";
$lang['radiobuttons'] = "r4dI0 8UTT0Ns";
$lang['dropdown'] = "drOP d0wn";
$lang['threadcount'] = "thR3Ad C0Unt";
$lang['fieldtypeexample1'] = "f0R rAD1O 8U++0nS 4Nd Drop d0wN fI3LDS j00 n33d TO 5ep4R4+3 TH3 PHielDn4M3 @nd +eh V4lUES WiTH 4 c0lon @Nd eACH V4luE ShOUld BE S3P@ratEd By sEmi-COl0N\$.";
$lang['fieldtypeexample2'] = "eX4mpLe: t0 CRe4Te 4 84SIC 9End3r r4dIO buT+0N\$, WI+H TW0 \$EL3ct1On\$ ph0R M4l3 @nd PHem4Le, j00 WoUld en+eR: <b>geNDeR:m4le;pH3maL3</b> in +HE I+eM NAmE PHI3LD.";
$lang['editedwordfilter'] = "edi+ed WoRD PhiLt3r";
$lang['editedforumsettings'] = "eDi+Ed PH0Rum 53T+In9s";
$lang['sessionsuccessfullyended'] = "suCC3S\$pHulLy ENd3d \$3\$510NS pH0R \$elEC+eD us3R\$";
$lang['matchedtext'] = "m4+CHed T3XT";
$lang['replacementtext'] = "r3PLaCEm3nt +3X+";
$lang['preg'] = "pRE9";
$lang['wholeword'] = "wh0l3 WOrd";
$lang['word_filter_help_1'] = "<b>all</b> m@+ch35 @G@in\$t tH3 wh0l3 T3Xt \$0 phiLteR1ng MoM +0 mUM WIll 4L5o chaN93 MOmen+ TO MUMEnt.";
$lang['word_filter_help_2'] = "<b>whol3 woRD</b> M4+cH3S @gain\$t WHol3 wOrd\$ 0nly s0 F1l+3r1nG Mom to muM wILl n0+ cH4n9e M0m3nt +O MUmeNt.";
$lang['word_filter_help_3'] = "<b>prE9</b> allOws j00 +o u\$3 P3rl REGUlar ExPre5510NS To M@+ch +eXt.";
$lang['nameanddesc'] = "n4Me 4nD de5crip+1oN";
$lang['movethreads'] = "m0vE tHr34DS";
$lang['threadsmovedsuccessfully'] = "tHRe4Ds movEd SUCC35sPhulLy";
$lang['movethreadstofolder'] = "m0V3 Thr34DS T0 f0LD3r";
$lang['resetuserpermissions'] = "rE\$et uSEr PErm1S5i0N5";
$lang['userpermissionsresetsuccessfully'] = "u53r PeRM1s510Ns re5Et SuCc3SsfUlly";
$lang['allowfoldertocontain'] = "aLlOw pH0ld3R tO C0n+@IN";
$lang['addnewfolder'] = "add NeW PH0ld3r";
$lang['mustenterfoldername'] = "j00 MUs+ eNteR 4 F0lder n4m3";
$lang['nofolderidspecified'] = "nO FoLD3r id spEc1F1ed";
$lang['invalidfolderid'] = "iNV@lID PH0lD3R 1d. cH3Ck +H4T a PH0LD3R With TH15 1d Ex15Ts!";
$lang['successfullyaddedfolder'] = "sUcce\$5pHUlly @dded PhOldEr";
$lang['successfullydeletedfolder'] = "succ35Sfully d3l3ted PhoLD3r";
$lang['failedtodeletefolder'] = "f4Il3d +0 d3L3+e pHoldEr.";
$lang['folderupdatedsuccessfully'] = "f0LD3R Upd@t3D sUcc3\$5phuLly";
$lang['cannotdeletefolderwiththreads'] = "c4nno+ DeLET3 pH0ld3Rs +h4+ St1ll c0NTAIn tHr34d5.";
$lang['forumisnotrestricted'] = "forum 15 No+ re5tr1C+ed";
$lang['groups'] = "gRouPs";
$lang['nousergroups'] = "nO UsER GR0UP5 h@VE beeN SE+ Up";
$lang['suppliedgidisnotausergroup'] = "sUppLIed 91d 15 nO+ 4 U5Er Gr0uP";
$lang['manageusergroups'] = "m4n@ge u5eR 9roUp\$";
$lang['groupstatus'] = "gr0Up 5+4tu\$";
$lang['addusergroup'] = "adD GR0up";
$lang['addremoveusers'] = "adD/rEmOv3 U5erS";
$lang['nousersingroup'] = "tHERe @re no U\$ERs 1n +hi5 9roUP";
$lang['useringroups'] = "tHIS USeR 1S 4 m3MBeR oPh +He PHOllOwiNg GR0UPS";
$lang['usernotinanygroups'] = "tHis Us3R 1s n0t In @nY u5Er 9rOUpS";
$lang['usergroupwarning'] = "n0t3: Thi\$ U5er m4y b3 1nher1+1ng 4DDI+I0N@l p3rm1SsI0n5 FroM 4nY u\$Er Gr0up\$ li\$T3d 83loW.";
$lang['successfullyaddedgroup'] = "sUcc35SFullY 4dD3d 9R0up";
$lang['successfullydeletedgroup'] = "sucCE55phulLY deLet3d 9rOUp";
$lang['usercanaccessforumtools'] = "u53r c4N @Cc3\$5 ph0rum t0Ol\$ 4nd caN cre4+3, d3l3T3 @nd 3DIT ph0rum\$";
$lang['usercanmodallfoldersonallforums'] = "u53R c@N m0Der@+e <b>alL FoLD3rS</b> 0n <b>alL PH0RuMs</b>";
$lang['usercanmodlinkssectiononallforums'] = "us3R c4n m0der4Te L1nk\$ 53c+1On 0N <b>all f0rum\$</b>";
$lang['emailconfirmationrequired'] = "em41l cOnF1RM4ti0n REqu1rEd";
$lang['userisbannedfromallforums'] = "u\$ER 1S 84nned fRom <b>alL fORum5</b>";
$lang['cancelemailconfirmation'] = "c4NC3L em4Il cOnphiRm@+i0n and @Ll0W uS3r +O \$T4r+ P0\$+in9";
$lang['resendconfirmationemail'] = "r3\$eND cONF1Rm4+i0n eM4Il +0 U\$er";
$lang['donothing'] = "do nO+H1n9";
$lang['usercanaccessadmintools'] = "u\$ER H@s 4cce\$\$ tO f0rum @dm1n +0oLs";
$lang['usercanaccessadmintoolsonallforums'] = "uS3r H4\$ @cc3s5 +0 @Dm1N t0oL\$ <b>oN 4Ll ph0ruM5</b>";
$lang['usercanmoderateallfolders'] = "uSER C4n m0D3r4+E @LL fold3rs";
$lang['usercanmoderatelinkssection'] = "u53r C4n M0dEr4+e l1nk\$ s3Ct10n";
$lang['userisbanned'] = "u\$Er 1s 84nNEd";
$lang['useriswormed'] = "u\$ER iS w0rmEd";
$lang['userispilloried'] = "usER 1S p1lL0rIEd";
$lang['usercanignoreadmin'] = "uS3r C4n ign0r3 4dm1ni5+r@t0R\$";
$lang['groupcanaccessadmintools'] = "grOup c4n 4cc3\$5 @dm1n ToOl5";
$lang['groupcanmoderateallfolders'] = "gROUP c4n mOD3r4+E aLl fOLD3r\$";
$lang['groupcanmoderatelinkssection'] = "gROup C4n m0D3r4t3 L1nkS 5Ect10N5";
$lang['groupisbanned'] = "grouP i5 8@nneD";
$lang['groupiswormed'] = "gr0uP I\$ w0rm3d";
$lang['readposts'] = "r3ad P0\$TS";
$lang['replytothreads'] = "r3Ply +0 +Hre4d5";
$lang['createnewthreads'] = "crE@tE n3w tHr34d\$";
$lang['editposts'] = "edIt Po\$+s";
$lang['deleteposts'] = "d3le+e Po\$tS";
$lang['uploadattachments'] = "upLo4D @tT4chm3n+S";
$lang['moderatefolder'] = "moDEr4+e pholDEr";
$lang['postinhtml'] = "p0\$+ 1n h+Ml";
$lang['postasignature'] = "p05T @ 51Gn4+uRe";
$lang['editforumlinks'] = "edi+ Ph0ruM l1NkS";
$lang['editforumlinks_exp'] = "uS3 +hIs P@g3 +0 @DD l1nks T0 +eH dRop-d0Wn Li5T dI\$pl@yed 1N +hE t0p-R1Ght 0f th3 foRum phr@m3\$et. 1f nO LinkS @rE SeT, TEh DrOp-d0wN lIsT WIll n0+ 83 DiSPl4yED.";
$lang['notoplevellinktitlespecified'] = "nO t0P l3v3L lInk T1tlE 5PecIphI3d";
$lang['toplinktitlesuccessfullyupdated'] = "t0P lev3L L1nk T1tlE sucCE\$5fUlLY UPd4ted";
$lang['youmustenteralinktitle'] = "j00 MUS+ ENter 4 lINK T1+Le";
$lang['alllinkurismuststartwithaschema'] = "aLl link uri5 mu\$T ST4rt W1+H 4 5cHem4 (1.e. h+tp://, ftp://, 1rc://)";
$lang['noexistingforumlinksfound'] = "th3R3 4R3 No 3xis+In9 F0rum linkS. +0 4dd 4 pHOrUM link click +Eh 8U++oN beL0w.";
$lang['editlink'] = "eD1T lInk";
$lang['addnewforumlink'] = "aDD new Forum l1nK";
$lang['forumlinktitle'] = "fORum L1nK +ITLe";
$lang['forumlinklocation'] = "f0RUm l1Nk LOc4ti0n";
$lang['successfullyaddedlink'] = "suCCe\$5fULly 4Dd3D L1Nk: '%s'";
$lang['successfullyeditedlink'] = "suCC3sSPhUllY ed1ted L1nK: '%s'";
$lang['invalidlinkidorlinknotfound'] = "inV4l1D l1nk 1d OR l1NK N0t FOuNd";
$lang['successfullyremovedselectedlinks'] = "sUcCe55Fully R3m0VED \$elec+eD liNk5";
$lang['failedtoremovelinks'] = "f@1l3D +0 rEm0Ve \$3L3ctEd l1nk5";
$lang['failedtoaddnewlink'] = "f@1LEd t0 @dD NeW L1nk: '%s'";
$lang['failedtoupdatelink'] = "f4ilED +0 upD4t3 l1nk: '%s'";
$lang['toplinkcaption'] = "t0p L1nk c4p+10n";
$lang['allowguestaccess'] = "aLL0w GUe5T @Cc3S5";
$lang['searchenginespidering'] = "s3ArCH 3ng1n3 \$PID3r1N9";
$lang['allowsearchenginespidering'] = "alLoW 5E4Rch eN91N3 \$pid3RIng";
$lang['newuserregistrations'] = "n3W u\$er r3915TR4tI0n5";
$lang['preventduplicateemailaddresses'] = "pr3v3n+ dUPLIc4t3 3M@IL @dDRe5Se5";
$lang['allownewuserregistrations'] = "aLl0W n3w u5Er Re915+R@+10n\$";
$lang['requireemailconfirmation'] = "r3qUIrE eM41l conF1Rm4+1On";
$lang['usetextcaptcha'] = "u\$3 T3XT-c4p+cHA";
$lang['textcaptchadir'] = "t3X+-C4p+ch@ d1r3CTOrY";
$lang['textcaptchakey'] = "teXT-c4ptcH@ KEY";
$lang['textcaptchafonterror'] = "t3x+-c@p+ch@ h45 833N di\$4bl3d @u+0Mat1c4llY BEc4uSe TH3re 4r3 NO tRU3 +Ype f0n+5 4Vail48l3 PhOr i+ +0 use. pLE45e UPl0@d 50me +RU3 +YP3 PH0nt\$ t0 <b>%s</b> 0n Y0ur 5Erv3r.";
$lang['textcaptchadirerror'] = "tex+-c4P+cH4 H4S 833n DIs4bl3d 83c4u\$e t3H +Ex+_c4P+CH4 DIrecToRy @nd 1t'\$ sU8-DIr3c+0R13s 4RE no+ WRIt48lE bY +hE wE8 seRv3R / PHp pR0ce\$S.";
$lang['textcaptchagderror'] = "text-c4p+ch4 H4s b33n Di\$4bled b3cau\$3 yoUR SerVer'S PHp \$3+Up dOE5 nOt ProV1De \$UppOr+ ph0r 9d 1M4G3 M4nIPuL@+I0n 4nD / Or ttph ph0N+ 5upp0rt. bo+h @Re r3qu1Red For teXt-c4pTch@ suPP0r+.";
$lang['textcaptchadirblank'] = "teXt-C4pTCh4 d1reCT0ry i5 bL4nk!";
$lang['newuserpreferences'] = "neW usER pR3fer3NCEs";
$lang['sendemailnotificationonreply'] = "em4il N0+1Fic@+I0n 0n R3Ply +o USEr";
$lang['sendemailnotificationonpm'] = "eM@1l noTiphIC@ti0N 0N pm +0 u\$3r";
$lang['showpopuponnewpm'] = "sHow P0pUp wHen reCe1V1n9 NeW Pm";
$lang['setautomatichighinterestonpost'] = "s3T 4U+Om@tIC high 1NTerest 0n P0\$+";
$lang['top20postersforperiod'] = "top 20 Po\$T3r5 phOr P3R1od %s t0 %s";
$lang['postingstats'] = "p0s+1Ng ST4+5";
$lang['nodata'] = "n0 d4t4";
$lang['totalposts'] = "t0T@l P0\$tS";
$lang['totalpostsforthisperiod'] = "t0T4L p0S+S PhOr Th1S P3R10d";
$lang['mustchooseastartday'] = "mU\$T CHooS3 a sT4rt D@y";
$lang['mustchooseastartmonth'] = "muST CH0o\$3 @ 5+4rt month";
$lang['mustchooseastartyear'] = "mUs+ choo53 @ 5t4Rt yE4r";
$lang['mustchooseaendday'] = "mU5T ch0O5E 4 end d@Y";
$lang['mustchooseaendmonth'] = "muS+ ChO0S3 @ ENd m0nth";
$lang['mustchooseaendyear'] = "muST CHO053 @ END Ye4R";
$lang['startperiodisaheadofendperiod'] = "sTarT Per1od iS 4hEad 0pH 3Nd p3ri0d";
$lang['bancontrols'] = "b4n coN+R0l\$";
$lang['addban'] = "adD 84n";
$lang['checkban'] = "chECk 8@n";
$lang['editban'] = "eDit b4n";
$lang['bantype'] = "b4n +YpE";
$lang['bandata'] = "baN d4+4";
$lang['bancomment'] = "cOmmeNT";
$lang['ipban'] = "ip 8an";
$lang['logonban'] = "lOG0n b4N";
$lang['nicknameban'] = "n1CKn@m3 84n";
$lang['emailban'] = "eMAIl 84n";
$lang['refererban'] = "repHERer ban";
$lang['invalidbanid'] = "inV@lId b4n 1D";
$lang['affectsessionwarnadd'] = "tH1S 84N m4Y @PhphEct th3 PH0LLowINg 4C+iv3 uSeR seS510N\$";
$lang['noaffectsessionwarn'] = "thiS 84N 4Fph3cts n0 4C+1ve SeS5i0n5";
$lang['mustspecifybantype'] = "j00 Mus+ sPec1fy @ 84N TYP3";
$lang['mustspecifybandata'] = "j00 mu5T 5peciFy 50m3 b4n d4t4";
$lang['successfullyremovedselectedbans'] = "sUcCeS5phUlLY r3M0v3d \$ElecT3d b4N5";
$lang['failedtoaddnewban'] = "f@1led To 4dd N3w 8@N";
$lang['failedtoremovebans'] = "fAIleD +0 r3mov3 \$0Me 0R 4ll oF +EH 5ELec+3D B@n\$";
$lang['duplicatebandataentered'] = "dupl1c@+E BAn d4+4 enT3reD. PLE4s3 cH3cK yoUR WIldc4RD5 To \$eE 1F +hEY 4LrE4dy M@tCh +hE d4+4 3NTEr3D";
$lang['successfullyaddedban'] = "sUCCes5pHulLY @DdEd B4N";
$lang['successfullyupdatedban'] = "succ3SSphully updATed B4n";
$lang['noexistingbandata'] = "tH3rE iS NO 3xiS+1N9 84N D4t4. +0 @dd SoM3 b4N d4+4 PLea\$3 clICK +eh bUTton 83lOw.";
$lang['youcanusethepercentwildcard'] = "j00 c4N usE +hE pErceNT (%) W1LDc4rd 5ym80l 1n ANy 0f Your b4n L1\$TS TO 0B+a1N paRt14l M4+cHEs, 1.e. '192.168.0.%' WOUld B4n 4ll 1p @DDrE5ses in THe r4ng3 192.168.0.1 tHrOUgH 192.168.0.254";
$lang['cannotusewildcardonown'] = "j00 c@nnO+ 4Dd % 45 A w1ldCarD M@tch on I+'s 0Wn!";
$lang['requirepostapproval'] = "rEqu1re POS+ @ppR0V@l";
$lang['adminforumtoolsusercounterror'] = "tH3Re mU5t be 4+ l34s+ 1 u\$er w1th 4Dmin +0Ol\$ @nd f0rum TOoLs 4ccEss oN @lL PH0rum5!";
$lang['postcount'] = "pO5t couNT";
$lang['resetpostcount'] = "rE5E+ P0S+ C0unt";
$lang['postapprovalqueue'] = "po5t @pPrOV4l QueUE";
$lang['nopostsawaitingapproval'] = "no p0\$T\$ AR3 4W41T1N9 4pProv@l";
$lang['approveselected'] = "apPRove \$3l3c+ED";
$lang['successfullyapproveduser'] = "succ3\$5Phully @PPr0V3D s3l3cT3d uSerS";
$lang['kickselected'] = "kicK S3l3C+3D";
$lang['visitorlog'] = "v1\$1t0R l09";
$lang['novisitorslogged'] = "nO V151t0rs l099ED";
$lang['addselectedusers'] = "aDD s3lectEd U\$eRS";
$lang['removeselectedusers'] = "reMove S3L3cted us3R\$";
$lang['addnew'] = "adD n3w";
$lang['deleteselected'] = "deLE+3 \$el3ctEd";
$lang['noprofilesectionsfound'] = "tHeRe 4R3 no 3X1\$+1N9 PRoPhiL3 \$ec+1oN\$. +0 @dd 4 pROf1le s3Ct10n PLeaSe CLick t3h 8UTT0n b3lOw.";
$lang['addnewprofilesection'] = "adD new PrOFil3 \$ect10n";
$lang['successfullyaddedsection'] = "suCC3s5FuLLY 4Dd3d 53ctI0n";
$lang['forumrulesmessage'] = "<p><b>f0rUm Rul3\$</b></p><p>\nR3g1stR4+10n +o %1\$5 i5 pHree! we Do IN\$ISt +h4+ J00 48ide by tH3 Rul3s 4Nd P0licies deT4iLed b3Low. If J00 49R33 TO +eH t3rms, pLe4se cHeck +eh '1 4Gre3' ch3Ckb0X 4nD PR3\$5 +Eh 'reG15+3r' 8u++0n bELOw. IPH J00 wOULd liKE T0 C@ncEl +Eh re91STrA+10N, cL1cK %2\$5 +0 ReTuRN TO +H3 Ph0RUMs InDeX.</p><p>\n4l+hoUgH +H3 4DM1n1\$tR@+Or\$ 4Nd M0d3r@+OR5 0ph %1\$s WILl 4+tEmp+ +O kE3P 4ll oBJecTiOn48L3 MeS\$493s 0PHf Th15 FOrUm, 1+ IS 1mposS1Bl3 ph0R us T0 REv13w @Ll m3\$S4g3S. @lL Me\$s@9ES 3XPrES\$ The vi3WS Of Th3 4u+hOR, 4Nd N3i+heR T3H OWNErS 0f %1\$\$, n0r pR0JEc+ b3eh1V3pH0RuM @Nd it'5 @fF1L1@t3s w1Ll b3 hELD RE\$PONSI8l3 f0R Th3 c0nTeNT 0f anY m3SS@9E.</p><p>\nBY @9r33iN9 +0 THESE RULE\$, j00 w4Rr@nT +H@t J00 wILL N0T Post 4Ny M3\$5493s TH4T 4r3 o8\$C3Ne, Vul94R, 5exU4lLy-0R13NT4+3d, HA+ePHuL, tHr34t3N1n9, oR o+h3rW1SE viOL4+iVe 0F @nY L4W5.</p><p>thE oWNEr\$ oF %1\$\$ r3\$3rVe TeH Ri9H+ t0 rEm0VE, eDI+, M0ve 0R ClO\$3 ANY +hre4D PH0R @nY R3@s0N.</p>";
$lang['cancellinktext'] = "h3r3";
$lang['failedtoupdateforumsettings'] = "f@Iled +0 upd@+e fORUM 5ettiNg5. ple4\$3 +Ry a94IN L@t3r.";

// Admin Log data (admin_viewlog.php) --------------------------------------------

$lang['changedstatusforuser'] = "ch4n9Ed uSer St4tUs F0r '%s'";
$lang['changedpasswordforuser'] = "cHAN9Ed P@S\$wORd For '%s'";
$lang['failedtoupdatepassword'] = "f@Il3D To upd4te p45SwOrd.";
$lang['changedforumaccess'] = "cH@n93d Ph0RuM @ccE\$s PerMis51oN\$ pHoR '%s'";
$lang['deletedallusersposts'] = "d3L3+3d ALl p0S+5 PhOr '%s'";

$lang['createdusergroup'] = "cr34+3d Us3r 9RoUP '%s'";
$lang['deletedusergroup'] = "deL3+ed useR 9roUp '%s'";
$lang['updatedusergroup'] = "updaT3d us3r grOUP '%s'";
$lang['addedusertogroup'] = "aDd3d U\$ER '%s' tO 9r0uP '%s'";
$lang['removeduserfromgroup'] = "r3M0VE U\$ER '%s' phr0m 9Roup '%s'";

$lang['addedipaddresstobanlist'] = "aDd3D Ip '%s' +0 84n L1St";
$lang['removedipaddressfrombanlist'] = "rEmoVEd 1p '%s' Phr0M 8@n L15T";

$lang['addedlogontobanlist'] = "addEd l0G0N '%s' +o b4n LI5t";
$lang['removedlogonfrombanlist'] = "rEM0v3d L0gON '%s' pHroM 84N lI5t";

$lang['addednicknametobanlist'] = "adD3D nIckn4M3 '%s' +o b@n LisT";
$lang['removednicknamefrombanlist'] = "r3MoveD nICkn@me '%s' phR0M 84n L1sT";

$lang['addedemailtobanlist'] = "aDdEd 3M@1l 4ddr3SS '%s' T0 B@n liS+";
$lang['removedemailfrombanlist'] = "rEm0v3D EM4iL @DDrE\$\$ '%s' PHrOm 8@N l1St";

$lang['addedreferertobanlist'] = "aDd3d R3PhER3r '%s' +O b4N l1S+";
$lang['removedrefererfrombanlist'] = "r3MOVeD rePh3ReR '%s' phr0m 84n LISt";

$lang['editedfolder'] = "ed1t3D Fold3R '%s'";
$lang['movedallthreadsfromto'] = "m0V3D @lL +Hre4D\$ phR0m '%s' +o '%s'";
$lang['creatednewfolder'] = "cR34Ted n3w F0ld3R '%s'";
$lang['deletedfolder'] = "deLET3D f0LdER '%s'";

$lang['changedprofilesectiontitle'] = "cH4n9ED prOPh1L3 S3ct1oN +i+le pHR0m '%s' tO '%s'";
$lang['addednewprofilesection'] = "adD3d N3W PrOPhilE Sec+10n '%s'";
$lang['deletedprofilesection'] = "d3le+ED pr0f1l3 \$3c+I0N '%s'";

$lang['addednewprofileitem'] = "aDDEd N3w PrOPhIle it3M '%s' +0 5ectI0N '%s'";
$lang['changedprofileitem'] = "cH@n9ED pRoFiL3 1T3M '%s'";
$lang['deletedprofileitem'] = "deLeT3d PRofILE it3m '%s'";

$lang['editedstartpage'] = "eDIT3D \$+4R+ p4ge";
$lang['savednewstyle'] = "s4v3D NEw stYl3 '%s'";

$lang['movedthread'] = "mOV3d +Hre4D '%s' phrOm '%s' t0 '%s'";
$lang['closedthread'] = "cLO\$ed Thre4d '%s'";
$lang['openedthread'] = "opeNeD thRE@d '%s'";
$lang['renamedthread'] = "r3n4MEd THre@D '%s' t0 '%s'";

$lang['deletedthread'] = "d3L3+eD ThR34d '%s'";
$lang['undeletedthread'] = "uNDeLe+3D +hRE4d '%s'";

$lang['lockedthreadtitlefolder'] = "l0ck3D Thr34d op+i0n5 0N '%s'";
$lang['unlockedthreadtitlefolder'] = "unLOck3d +hrE@d 0P+I0n\$ On '%s'";

$lang['deletedpostsfrominthread'] = "d3L3+3D pO\$TS FrOM '%s' IN +hr34D '%s'";
$lang['deletedattachmentfrompost'] = "d3LE+ED 4t+4chm3n+ '%s' FrOM pO\$+ '%s'";

$lang['editedforumlinks'] = "ed1+3D fOrUm L1nk5";
$lang['editedforumlink'] = "edI+3D Ph0rum l1nK: '%s'";

$lang['addedforumlink'] = "aDdeD fOruM LInK: '%s'";
$lang['deletedforumlink'] = "deLeT3d FoRum LiNk: '%s'";
$lang['changedtoplinkcaption'] = "chAN9ED +0P lInK c4P+10N pHRoM '%s' +O '%s'";

$lang['deletedpost'] = "d3L3+ED Po\$t '%s'";
$lang['editedpost'] = "edited Po\$T '%s'";

$lang['madethreadsticky'] = "m4dE +hre4d '%s' 5+IckY";
$lang['madethreadnonsticky'] = "m4D3 +hr34d '%s' n0n-5t1cKy";

$lang['endedsessionforuser'] = "eND3d \$Es5ION Ph0r u\$Er '%s'";

$lang['approvedpost'] = "aPPRoV3d pO5t '%s'";

$lang['editedwordfilter'] = "eD1+ED WORd PHilT3r";

$lang['addedrssfeed'] = "adD3D R55 PheeD '%s'";
$lang['editedrssfeed'] = "ed1+3D rSS Feed '%s'";
$lang['deletedrssfeed'] = "d3l3t3D RSs ph33d '%s'";

$lang['updatedban'] = "uPD4+3d B4n '%s'. ch@Nged +yP3 phROm '%s' +o '%s', CH4ng3d d4T4 FR0m '%s' +0 '%s'.";

$lang['splitthreadatpostintonewthread'] = "sPl1+ +Hr3@d '%s' 4+ P0\$T %s  In+0 neW Thr3@d '%s'";
$lang['mergedthreadintonewthread'] = "m3r9ed +hre4D\$ '%s' 4Nd '%s' INtO new THr34d '%s'";

$lang['approveduser'] = "apprOVed u\$ER '%s'";

$lang['adminlogempty'] = "aDMiN l0g 15 eMp+y";
$lang['clearlog'] = "cLEAR lO9";

// Admin Forms (admin_forums.php) ------------------------------------------------

$lang['noexistingforums'] = "no EX1s+In9 f0RumS ph0und. to cRe4+e 4 N3w PH0Rum ple4Se clIcK +eh bu++0n 8EloW.";
$lang['webtaginvalidchars'] = "web+@g caN ONly cON+41n uppeRc4S3 4-Z, 0-9 4nd uND3R\$c0r3 cH4R4ct3rs";
$lang['databasenameinvalidchars'] = "d4+484sE n4me C4n 0nly coN+4iN 4-z, 4-z, 0-9 @Nd uND3rsc0r3 CHar@c+erS";
$lang['invalidforumidorforumnotfound'] = "iNv@Lid ph0rUM pH1d PH0R fORum n0+ F0uNd";
$lang['successfullyupdatedforum'] = "sUcc3S\$FuLLy Upd4+ed f0RuM: '%s'";
$lang['failedtoupdateforum'] = "f4iLed +0 Upd4+e PH0rUM: '%s'";
$lang['successfullycreatedforum'] = "sUcCe5\$fulLY cr34+3D FOrUm: '%s'";
$lang['failedtocreateforum'] = "f4IL3d To cr34+E Ph0ruM '%s'";
$lang['selectedwebtagisalreadyinuse'] = "tH3 SeL3cTeD w3bt4g 1\$ @lr3adY 1n U\$3. pLe@5e CHo0se 4no+HeR.";
$lang['selecteddatabasecontainsconflictingtables'] = "tHe seleCTED d@+@8AS3 cOn+41n\$ conFL1c+1Ng +4bL3S. c0NphlIc+1Ng +4bL3 N4mEs 4r3:";
$lang['forumdeleteconfirmation'] = "ar3 j00 sURe J00 w4nt +o d3l3Te 4ll Of +he SEleCteD fORum\$?";
$lang['forumdeletewarning'] = "pL345E NO+e That j00 c4nnot R3coV3r deLet3d PhOrumS. Once del3T3d 4 f0rum 4ND 4ll 0f iT's 4\$S0Ci@+ed d@+4 1S P3RmEn4ntly RemoV3D phr0m +EH d@t48@Se. 1F j00 Do n0+ w15h +O d3Let3 tH3 sEleCTed PHoRumS pl345E CL1ck c@ncel.";
$lang['successfullydeletedforum'] = "sUcC3\$sphulLY DELet3D pH0Rum: '%s'";
$lang['failedtodeleteforum'] = "f41L3d +0 d3L3+ED fORuM: '%s'";
$lang['addforum'] = "add Ph0rum";
$lang['editforum'] = "ed1t F0rum";
$lang['visitforum'] = "vis1T Ph0rum: %s";
$lang['accesslevel'] = "aCC3\$\$ LeVel";
$lang['forumleader'] = "f0ruM L34der";
$lang['usedatabase'] = "u5E daT48@\$e";
$lang['unknownmessagecount'] = "unkNOWn";
$lang['forumwebtag'] = "fORum webT4G";
$lang['defaultforum'] = "d3PH@ul+ foRUm";
$lang['forumdatabasewarning'] = "pL3453 3N\$URe J00 SelEct +he C0Rr3ct D4T4845e wh3N crE4TinG 4 neW PH0rum. 0nce CRe4+ED 4 nEW Ph0ruM C4nNO+ B3 mOV3d 83+we3n @V4il@8L3 d4+4b@seS.";

// Admin Global User Permissions

$lang['globaluserpermissions'] = "gLO8@L US3r p3rm1SS10n\$";

// Admin Forum Settings (admin_forum_settings.php) -------------------------------

$lang['mustsupplyforumwebtag'] = "j00 MUst SuPPly a PhoRUm W38+@g";
$lang['mustsupplyforumname'] = "j00 mU5+ sUpplY 4 FoRum naM3";
$lang['mustsupplyforumemail'] = "j00 Must \$uPply 4 f0rUm Em@iL 4DDR3\$5";
$lang['mustchoosedefaultstyle'] = "j00 MUST cH00\$e A d3ph@ul+ F0rUm s+yle";
$lang['mustchoosedefaultemoticons'] = "j00 Mus+ ch00\$3 D3F4ul+ forUM EM0+IcOns";
$lang['mustsupplyforumaccesslevel'] = "j00 MUS+ SuPPLY @ ph0rum @cC3S5 l3v3L";
$lang['mustsupplyforumdatabasename'] = "j00 mU5T \$uPPlY 4 PH0rUm D@T48@\$e N@m3";
$lang['unknownemoticonsname'] = "unKNOWn eMO+1C0nS N@Me";
$lang['mustchoosedefaultlang'] = "j00 mUSt Choo5e a d3pHaUL+ fOrUm l4n9u493";
$lang['activesessiongreaterthansession'] = "aCtIve SeS\$10n +1m30Ut c@NN0+ b3 9R34t3R +h@n S35s10n timEoUt";
$lang['attachmentdirnotwritable'] = "a++4ChMen+ dIR3C+0Ry And \$yS+3M +Emp0r4Ry dir3C+0Ry / php.1N1 'UPlO@d_tMp_DIr' MU5+ B3 wR1+48Le By teh W3b 5ERV3r / php PRoC3sS!";
$lang['attachmentdirblank'] = "j00 mu5+ \$UPPLy 4 DiR3c+ORy +0 \$4V3 4+t4chmEnt\$ in";
$lang['mainsettings'] = "m4IN se++1n9S";
$lang['forumname'] = "forum n4mE";
$lang['forumemail'] = "f0RuM em4il";
$lang['forumnoreplyemail'] = "nO-R3Ply Em@iL";
$lang['forumdesc'] = "fORUm DeSCriP+10N";
$lang['forumkeywords'] = "foruM K3Yw0Rd5";
$lang['defaultstyle'] = "d3PH4Ul+ \$TylE";
$lang['defaultemoticons'] = "dEPH4ulT 3Mo+ic0n\$";
$lang['defaultlanguage'] = "deph4Ult L4N9u493";
$lang['forumaccesssettings'] = "foRuM @cC3SS S3t+iN95";
$lang['forumaccessstatus'] = "f0rUm 4CC3sS s+4+u5";
$lang['changepermissions'] = "cH4NGe PerMI\$s10n\$";
$lang['changepassword'] = "chAnG3 p@5SW0Rd";
$lang['passwordprotected'] = "p4\$swOrd pr0+eCTed";
$lang['passwordprotectwarning'] = "j00 haV3 N0+ sET A Ph0rum p45sw0rd. 1f j00 dO NO+ set 4 p45SwoRd +hE p@55W0rd Pr0+3Cti0N PHUnct10n4L1+y W1ll b3 4U+0m@+1C4lLY d154bl3D!";
$lang['postoptions'] = "p0st oPTi0n5";
$lang['allowpostoptions'] = "aLl0W P05t 3DiTiN9";
$lang['postedittimeout'] = "p0\$t 3dI+ +1MEOut";
$lang['posteditgraceperiod'] = "pO\$T ed1T 9rac3 pERI0d";
$lang['wikiintegration'] = "w1K1WIk1 In+E9R4+1ON";
$lang['enablewikiintegration'] = "en4BLe w1kIW1K1 INte9r4TI0n";
$lang['enablewikiquicklinks'] = "eN@8l3 W1kiw1kI QU1cK L1nks";
$lang['wikiintegrationuri'] = "wiK1w1ki l0c4tI0n";
$lang['maximumpostlength'] = "m@XImum pO\$T leN9TH";
$lang['postfrequency'] = "p0S+ Fr3quENCY";
$lang['enablelinkssection'] = "eN48L3 l1nkS \$ectIon";
$lang['allowcreationofpolls'] = "aLLOW CR34+10n 0ph POll\$";
$lang['allowguestvotesinpolls'] = "alL0W 9ue\$+s +0 V0T3 1N PolLs";
$lang['unreadmessagescutoff'] = "uNr34D m3554G3s CU+-0Ff";
$lang['unreadcutoffseconds'] = "s3C0NdS";
$lang['disableunreadmessages'] = "d1\$48l3 Unr34d MEs\$@ges";
$lang['nocutoffdefault'] = "no Cu+-0ff (dePh4UL+)";
$lang['1month'] = "1 mOnth";
$lang['6months'] = "6 MOn+hs";
$lang['1year'] = "1 y34r";
$lang['customsetbelow'] = "cU5t0m V@lue (\$3T BELow)";
$lang['searchoptions'] = "sE@rch 0p+10n5";
$lang['searchfrequency'] = "s34RcH pHr3qU3Ncy";
$lang['sessions'] = "s3S5I0n5";
$lang['sessioncutoffseconds'] = "seSsion cut OFf (53c0Nd5)";
$lang['activesessioncutoffseconds'] = "aC+iVe S3SS10n Cut off (s3CoNDS)";
$lang['stats'] = "sT4+S";
$lang['hide_stats'] = "h1DE St4+S";
$lang['show_stats'] = "shOW s+a+\$";
$lang['enablestatsdisplay'] = "en4blE 5T4+S DI\$PL@y";
$lang['personalmessages'] = "peRs0n@L mesS49es";
$lang['enablepersonalmessages'] = "eN48L3 p3RSoN@l m3S\$4g3s";
$lang['pmusermessages'] = "pm MES\$4G3S pER uSer";
$lang['allowpmstohaveattachments'] = "aLLow P3RSOn@l m3S54GE5 to h@ve @tt4chmen+5";
$lang['autopruneuserspmfoldersevery'] = "aUto prun3 u\$3r'S PM ph0ld3R5 3v3RY";
$lang['userandguestoptions'] = "u5ER 4nd gue5T 0p+10n\$";
$lang['enableguestaccount'] = "en48l3 9u35T 4CcouNt";
$lang['listguestsinvisitorlog'] = "li5t 9Ue5+S in v1S1T0R L09";
$lang['allowguestaccess'] = "aLL0w gUe5T @cc3S5";
$lang['userandguestaccesssettings'] = "u\$Er 4Nd gUeS+ 4ccEs5 s3T+Ing5";
$lang['allowuserstochangeusername'] = "aLL0w u\$3r\$ +O CH4nGe uS3Rn@m3";
$lang['requireuserapproval'] = "r3QU1Re U53R Appr0v@l 8Y 4dmIn";
$lang['requireforumrulesagreement'] = "r3QuIRe UseR tO 4Gree t0 f0rUm RulEs";
$lang['enableattachments'] = "en48Le 4T+4Chm3ntS";
$lang['attachmentdir'] = "a++4CHmEnt D1r";
$lang['userattachmentspace'] = "att4ChM3N+ 5p4C3 per usEr";
$lang['allowembeddingofattachments'] = "aLl0w 3M83DD1n9 of 4++4ChmenTS";
$lang['usealtattachmentmethod'] = "uSE @L+eRN4+1Ve 4++4ChMent M3tH0d";
$lang['allowgueststoaccessattachments'] = "aLl0W 9uE5ts t0 @ccesS 4Tt@chm3ntS";
$lang['forumsettingsupdated'] = "foRum s3TT1NgS 5ucc3\$sPhuLLY upd@+3D";
$lang['forumstatusmessages'] = "f0Rum 5t4+U\$ mEsS49es";
$lang['forumclosedmessage'] = "fORUm cLo53D meS549e";
$lang['forumrestrictedmessage'] = "f0RUm Re\$Tr1ct3d Mess4g3";
$lang['forumpasswordprotectedmessage'] = "f0rUM Pas5w0RD pr0+Ec+ED m3Ss@Ge";

// Admin Forum Settings Help Text (admin_forum_settings.php) ------------------------------

$lang['forum_settings_help_10'] = "<b>p0\$T Edi+ t1ME0u+</b> I5 +3H +1m3 in Minu+e5 @F+er p0ST1nG th@T 4 U\$ER can 3D1T tHe1r pO\$t. 1F 5et TO 0 +her3 15 n0 Lim1T.";
$lang['forum_settings_help_11'] = "<b>m@ximUm PO\$t lEN9TH</b> I5 +Eh m4x1MuM nuMbEr OPH ch@r4c+Ers th@+ W1Ll 83 di5Pl4yed in 4 Po5t. 1f 4 po\$+ 1s loN93r Th4n +eh nuM83r 0pH CHaR@C+ER5 deF1neD h3R3 1+ w1ll bE cU+ 5hORt 4Nd @ LiNk 4dd3d +0 T3H B0++0m To @lL0W u5ErS +O Re4D +He WhoLE P0S+ oN @ \$3p@R@te p@Ge.";
$lang['forum_settings_help_12'] = "iF j00 d0N'+ w4n+ y0ur US3r\$ tO 83 48l3 TO cRe4+e polLs J00 c4n dIS48l3 +he 48OVe OPtI0n.";
$lang['forum_settings_help_13'] = "tHe link\$ \$3ct10N 0f b3eHiv3 ProV1d3s @ PL@CE Ph0R y0ur usERs +0 m@1NT4In @ list OF sIT3S th3Y phR3quenTlY v1S1+ tH@+ 0+h3r UsERS M4Y PhinD USEphUl. L1nkS C@n bE d1v1D3d iN+O C@+egOri35 8y ph0Ld3r @nd 4lL0W pH0r C0Mm3NtS 4nd R@+1n9s t0 B3 Giv3n. 1N 0rd3r T0 M0D3R@t3 ThE LinK\$ \$ect10N 4 U\$eR MuST 83 r4n+Ed gLOb@L mOdEr@+Or \$tAtUs.";
$lang['forum_settings_help_15'] = "<b>sEsS10n cU+ oPhf</b> 15 Teh m4X1muM +1m3 befOr3 4 U5Er'5 \$eS\$iON i5 deemEd D34d @nd TH3y 4RE l0g9eD ouT. 8y dEF4ulT +HIs IS 24 H0UrS (86400 \$EConDS).";
$lang['forum_settings_help_16'] = "<b>aCTIV3 s3\$51oN Cu+ 0Ff</b> Is +eh M4X1Mum T1Me befORE 4 us3R'5 \$3\$S10n 1S d3EM3D 1n@c+iv3 4+ wH1cH pOInt +hEY eNt3R @N 1DlE \$t4T3. IN +H15 \$T@+e +He USeR REm4inS lO9geD 1N, 8U+ thEY 4R3 REMOv3d fr0M Th3 @C+IV3 uS3r\$ li5T iN +hE 5t@t\$ D15pL4y. 0Nce tHeY b3c0ME 4c+Iv3 4G@in +hEY W1Ll 8E RE-@Dd3D TO +H3 Li5T. 8Y deF@uL+ +Hi5 se+t1N9 1s \$3+ To 15 minUtE5 (900 53c0NDS).";
$lang['forum_settings_help_17'] = "eNA8LinG THi\$ 0P+10n @Ll0w\$ 833h1v3 To 1NclUde 4 St4+S D1splaY @T tHe Bo++0m oF TH3 M3\$s4gES p4N3 \$1m1L@r T0 +h3 ONE USeD 8y mANY F0rum 50FTW4R3 +1+lES. 0Nc3 3naBL3d +He Di5pL4y 0Ph +hE \$t4+5 P@gE c4N BE ToG9LeD 1nd1V1dU4LlY By E4Ch U\$eR. If th3y d0N'+ W4nT tO SE3 i+ tHEY C4N H1De i+ FrOM v1eW.";
$lang['forum_settings_help_18'] = "p3R\$on@l MeSs4GeS 4re 1nv4LU@blE 4\$ 4 w4y 0PH +4kin9 moR3 prIV4tE M4++3r\$ 0U+ 0f Vi3W OF teh o+HEr MemB3Rs. hoWevER 1f j00 D0N't w@NT Y0uR U5ERS +0 8E @8l3 To \$END e@cH O+her perSOn@l M3SS4Ges j00 c4N d1548l3 tH1\$ 0p+1ON.";
$lang['forum_settings_help_19'] = "p3RS0N4l M3s\$493S c4n @lSo COn+4iN @t+4chmEnts wH1CH C@N 8e u\$3FUL fOR 3XcH4Ng1Ng PhiLe\$ 83+We3N uS3rS.";
$lang['forum_settings_help_20'] = "<b>nO+E:</b> TH3 \$p4ce 4LL0cAtI0N f0R pm AT+4ChmeN+S 1S takEn PHr0M 3@CH useRS' mA1N @tt4cHmenT 4LLOc@t10N And 1\$ n0+ in @dd1T1On T0.";
$lang['forum_settings_help_21'] = "<b>en4BL3 9uEst 4Cc0un+</b> 4lLow5 Vi51t0r\$ +o 8RoW5E yOUr fOrUM 4nd R34D po\$+S with0U+ re91S+erIn9 @ u5eR @ccoun+. 4 useR 4CcOUnt I\$ 5till requirEd 1f +HEY w1Sh +0 p0sT or ch4n9E u\$3R PReFEr3ncEs.";
$lang['forum_settings_help_22'] = "<b>liSt 9ue5Ts 1n v151t0r lOG</b> 4ll0Ws j00 +0 \$pEC1fY wHeth3r 0R n0+ unR3g1sTerEd UserS @rE LI\$t3d on T3H v151+0r L09 4l0nG S1De R3g1SteRed us3Rs.";
$lang['forum_settings_help_23'] = "b3Eh1ve @LlOWs AtTachm3n+5 tO 8e upL04deD +0 M3S\$4geS wh3n po\$T3d. If j00 H4vE l1m1TeD W38 \$P4ce j00 m@y whIcH To di548l3 4T+4Chm3n+\$ bY cLe@R1N9 +hE BOX 48oV3.";
$lang['forum_settings_help_24'] = "<b>aTtaChmEN+ D1r</b> IS +Eh L0c4+10N 8Eeh1V3 shOuLD \$TOR3 i+'s @t+4ChM3nT\$ 1N. +h15 dirEc+0Ry mu\$t 3Xi5T oN Y0ur Web \$P@Ce 4nd Mu\$T 83 wri+4bL3 BY +h3 Web \$eRVer / pHp PR0c3\$\$ 0+h3RW1s3 Upl04DS wILL Ph@Il.";
$lang['forum_settings_help_25'] = "<b>a++4ChmeN+ Sp4c3 P3r U\$Er</b> IS +HE M4x1Mum 4M0Un+ of d15K 5p4ce 4 u\$ER H4s ph0r @+T4CHmEnT\$. 0Nce th1S \$P4CE IS u5Ed up +eh Us3r c4nN0+ UPl0@d 4NY M0R3 4tT@CHmeNt\$. By D3Ph@Ul+ Th1s 1S 1mb of sp4C3.";
$lang['forum_settings_help_26'] = "<b>aLlOW eMb3dd1N9 oPH a++4chMenT\$ 1N meSs4g3S / siGn4+ur3\$</b> 4Ll0WS US3R\$ t0 3M83D 4+t4ChmEN+\$ 1n pO\$tS. 3n48lIn9 +HI5 0p+I0n WHil3 U5epHuL C4n 1nCRe45e YouR b@nDWiDtH U\$493 dr@5T1c4LlY UnD3R cERt41N C0nPH1guR@+10n\$ Oph Php. 1f J00 H4ve lIm1T3D b4nDW1d+h 1+ 15 R3cOMmEnD3d Tha+ j00 Di\$4BL3 tHIS OPT1ON.";
$lang['forum_settings_help_27'] = "<b>u5E 4L+3rn4TiVe 4++@chm3N+ ME+H0d</b> F0rceS bEEh1vE to uSE 4n 4LtErn@t1V3 R3+r1Ev4l m3+h0d fOr 4+T4CHm3Nt5. If J00 REcEiV3 404 3RrOR mEsS493\$ Wh3n TRy1nG T0 DOwNl0@D 4++@cHm3Nt\$ Fr0m ME\$54GeS Try 3n4bl1ng TH1\$ 0ptI0N.";
$lang['forum_settings_help_28'] = "tH1\$ S3T+In9 4ll0W\$ YOuR PH0rUM +o 83 \$pid3r3D bY \$e4RCh 3Ng1nE\$ L1K3 90oglE, 4lTAvI5t4 4nd y4HO0. 1f j00 \$w1+ch thI5 0P+1oN OpHPH Y0uR ph0RUm W1Ll N0+ 83 InClUd3D in TH3sE 5E4rcH 3ngin3\$ r3SUltS.";
$lang['forum_settings_help_29'] = "<b>alL0W new us3r r391S+R4Ti0n\$</b> 4Ll0wS 0r d154ll0W\$ +h3 CR34+i0N oPh neW uSeR 4cC0uN+S. Se++in9 th3 Op+iON +o No C0mpL3+3lY D1S48lE5 TEh r391s+r@+1On ph0Rm.";
$lang['forum_settings_help_30'] = "<b>en4blE wik1Wik1 iN+e9R4t10n</b> PR0v1DEs w1k1w0rd \$upp0rt In Y0uR PhoRUM pO\$tS. @ W1k1w0rd I5 M@de up 0F tw0 0r mOR3 c0nc@+3N@+Ed WORds w1+H uPperC4\$e le++er5 (0PH+eN RephERRed t0 4\$ C@MelcAsE). 1f j00 WrI+3 @ WORD +Hi5 W@Y 1t wIlL AU+Om@T1C4LLy 8E cH4n93D 1N+O 4 HyPeRL1nK P0InTiN9 +o yOUr chOS3N wiK1W1k1.";
$lang['forum_settings_help_31'] = "<b>eN4BlE WIkIwiK1 qU1Ck LInK\$</b> eN48l3\$ T3H Us3 oF mSg:1.1 aNd U\$ER:l0G0N StYLe ex+3nd3D wIK1linKS Wh1ch cre4+e HYperLiNK\$ t0 +H3 \$peCif1ed m3SS493 / u\$3r prOFilE OPh +eh Sp3c1F1ed u5Er.";
$lang['forum_settings_help_32'] = "<b>wIK1WikI Loc@+10N</b> I\$ U\$Ed +0 \$PEc1fy the uRi 0f yOUr WiKiW1K1. wHEN 3ntERIn9 t3h URI U5E [Wik1wORd] +0 iNd1c4t3 WHeRE in t3h urI ThE w1K1w0rD ShOulD 4pp3@r, 1.E.: <i>h+tP://3N.W1k1pEDi4.0Rg/W1K1/[WiKIw0rd]</i> W0uld l1NK YoUR w1k1WORdS t0 %s";
$lang['forum_settings_help_33'] = "<b>foruM acceS5 \$T4+uS</b> C0N+R0l\$ hOw u\$3Rs m@y AcC3\$s Y0UR PhORuM.";
$lang['forum_settings_help_34'] = "<b>oP3N</b> W1ll @ll0W AlL uSErS 4nd gUEs+S 4cc3SS t0 yOUr fOruM WI+H0U+ restRIc+i0N.";
$lang['forum_settings_help_35'] = "<b>clO\$ed</b> pR3v3n+\$ 4Cc3\$5 pHor @Ll u\$Ers, W1+h Th3 3Xc3P+IoN oPh +he 4dmIn Who m@Y St1ll 4cc355 Th3 admin p4nel.";
$lang['forum_settings_help_36'] = "<b>r3STric+Ed</b> @lloW5 to 53+ @ li5t of u5erS wHo @r3 4LL0w3d 4cceS5 tO Y0uR F0rum.";
$lang['forum_settings_help_37'] = "<b>p4sSWord PRO+ec+ed</b> 4Ll0wS J00 +0 SEt 4 p45SwORd +o Giv3 0u+ t0 U5eR5 so +hey c4n 4cC3s5 YOur PhOrUm.";
$lang['forum_settings_help_38'] = "wHeN \$EtTIn9 reS+RIc+3D or P4S5wOrd pr0t3Ct3d M0De J00 wIlL n33D +O s4Ve Y0UR ch4NgE5 83PH0r3 J00 c@n CH@nGe t3H u\$er 4cceSs pR1v1L393S 0R P@5sWORd.";
$lang['forum_settings_help_39'] = "<b>Search Frequency</b> defines how long a user must wait before performing another search. Searches place a high demand on the database so it is recommended that you set this to at least 30 seconds to prevent \"search spamming\"FroM k1LliNg the SerV3R.";
$lang['forum_settings_help_40'] = "<b>pO\$t PHR3qU3ncY</b> 1s TH3 m1N1muM t1Me 4 usER mUs+ wa1t bEF0re th3Y c4n PoST 494in. THi\$ seTTiN9 @L5O @FfeC+s +eh CrE4+i0N 0f p0lL\$. 5et +0 0 t0 DIsa8l3 Th3 R3STr1c+ion.";
$lang['forum_settings_help_41'] = "tEh a8oVE OptI0n\$ ch4Ng3 t3h D3F4ulT v4lU3s F0r +eh User reG1S+r4+10n F0rM. Wh3RE 4Ppl1C@8l3 o+her SE+tiNg5 w1Ll Use t3H pH0rum'S oWn D3PH@ul+ 5eT+In9S.";
$lang['forum_settings_help_42'] = "<b>prEv3NT u\$e Of DuplIc4+3 eM41L 4ddr3\$53S</b> pHoRc3S B3EhiVe T0 ch3CK tH3 uS3R @cC0UnTS A94in5+ +h3 3m@1L @ddR3s5 TH3 u\$Er 15 Re91StEr1N9 wi+h 4Nd ProMp+S +HeM +0 Use 4N0+her 1f 1t 15 4lre4dy In uS3.";
$lang['forum_settings_help_43'] = "<b>r3qU1r3 em@1l cONfirM4+Ion</b> WHEN 3N48lED w1Ll SEND @N 3M@1L +O 3aCh N3W Us3R W1+H A l1Nk ThA+ c4N 8E uSed +0 c0NphIrm theIR em@Il 4ddr3S\$. Un+Il +h3Y c0NF1RM tH31r em@Il 4dDr3\$\$ Th3y WILL n0+ Be @8l3 +0 po5t UnL3\$5 +He1R USER p3RM15sI0N\$ ArE ch@n93D ManU4LLy 8Y 4n 4Dm1n.";
$lang['forum_settings_help_44'] = "<b>u\$e +ex+-c4ptcH4</b> preSEnTs +he n3w u53r W1th 4 M@nglEd 1m49E WhIcH +hEy MuST C0pY 4 nUM8eR Phr0m In+0 4 T3x+ FI3LD ON the reg15+R4+I0N fORm. UsE THiS Op+i0N T0 Pr3V3nT @U+0M@+Ed sI9n-UP V14 5cr1Pt\$.";
$lang['forum_settings_help_45'] = "<b>t3x+-c4ptch4 DIRec+OrY</b> 5Pec1pH1E5 t3H lOcAti0N +h4+ 833h1V3 w1LL \$tOr3 I+'\$ tEX+-c4P+cH4 1m4G3\$ 4nd Ph0n+\$ 1N. tHi\$ d1R3ctoRy muS+ BE wr1+4bL3 bY tH3 We8 \$ErvEr / php pR0c3sS @Nd Mu5+ b3 4cce5518Le Vi4 H++p. 4F+eR J00 H4Ve eN48L3d +exT-C4ptcHa j00 mUS+ uPlOAd 5om3 +RuE TYp3 pHoN+\$ iN+0 +HE phontS 5ub-DiR3C+0rY 0pH Y0Ur m4IN +eX+-c4p+cH4 d1ReCtORY OTHeRWI\$3 b33HiVe W1ll SK1p T3h tex+-C4P+cHa duR1N9 u\$ER R3G15Tr4+10N.";
$lang['forum_settings_help_46'] = "<b>Text Captcha key</b> allows you to change the key used by Beehive for generating the text captcha code that appears in the image. The more unique you make the key the harder it will be for automated processes to \"guess\"+H3 C0D3.";
$lang['forum_settings_help_47'] = "<b>post 3d1t gR@C3 p3r10d</b> 4LLOw\$ j00 To d3fIne 4 P3r10d In m1Nut3s wh3re uS3rS m4y ED1T p0sTs WIthOu+ th3 '3D1ted By' t3X+ app34r1NG 0n TH3Ir Po\$+S. 1F S3T +0 0 +he '3D1ted BY' t3X+ w1ll @lw4ys 4Pp34R.";
$lang['forum_settings_help_48'] = "<b>uNre4D m35sagEs cUT-0FPH</b> Sp3C1F1e5 H0W l0ng UnR34d m3\$\$agEs @rE REt41n3d. j00 m@y ChoOSe pHR0M v4r1Ou\$ PreS3t V4luEs 0r 3NT3R YoUr OWn Cu+-0Ff peri0d In 5Ec0nds. tHrE4DS M0DIphiED 3@rL1er tH4N +he D3PhiNed cu+-OPhF PEr10D W1Ll 4utOM@+1c4LlY 4pp34R @s rE@D.";
$lang['forum_settings_help_49'] = "cH00\$1N9 <b>disA8lE unr3ad mE\$\$49eS</b> wiLl COmPL3t3Ly rEm0v3 UNRE4d Me\$S4GEs 5UppOr+ 4Nd r3mOvE T3H r3l3V@N+ 0pt1On\$ FRom +he d15CuS\$i0N typE DRoP DOwn On th3 thR3@d lIST.";
$lang['forum_settings_help_50'] = "<b>reqUiRe uSeR 4ppROvAl by AdM1n</b> 4LlOW\$ j00 To r3\$TRiC+ 4CcESS by n3W UseR\$ Un+1L TH3y h@ve BEEN @PPR0Ved by 4 M0dER4+0R OR @dM1n. W1THoU+ @PPr0v@L @ uSeR C4nNO+ 4CceS\$ 4nY 4r34 oph +EH bE3Hiv3 pH0rUm 1n\$T4Ll4ti0n 1NcluDin9 1nd1V1du4l pH0RUM5, Pm 1n8ox 4Nd my fORuM5 \$ECT1ON5.";
$lang['forum_settings_help_51'] = "uSE <b>cl0\$ED mE\$5493</b>, <b>r3StR1cTed M3\$S493</b> 4Nd <b>pa\$5W0Rd pr0t3c+3D M3\$\$493</b> T0 CuS+oM1\$e t3H M35Sa93 d15PL@y3D wH3N u\$Er5 @cc35S y0ur F0rUM in TEH V4RI0u5 ST@+ES.";
$lang['forum_settings_help_52'] = "j00 c@N U\$e H+ml 1n yOUr m3S54GEs. Hyp3RliNk5 aNd 3M41l 4Ddre5s3S w1Ll 4Ls0 B3 4UtOm4+ic4LlY c0NveRt3d +O L1NkS. to u5e Th3 d3ph@Ul+ be3hIV3 PhoRUm MeSS@GES CLe4R +3h pHieLD5.";
$lang['forum_settings_help_53'] = "<b>aLLow uS3rS T0 Ch@n9e Us3rn@m3</b> PerMitS 4lRe4dy Regi\$T3Red U53R\$ tO CH4ng3 TH3ir u53rn@me. wh3n eN@8L3d j00 C@n +r4Ck Th3 cH4n93s A U5er M@ke5 +0 +HE1R U\$erN4me v14 ThE AdM1n U\$Er T0oL5.";
$lang['forum_settings_help_54'] = "uSe <b>fORum RuleS</b> +o 3N+3r 4N 4cC3+4BLE u5e pOL1cy +h4t 34CH U5Er must @Gr33 +0 83phORe REG1s+eR1n9 oN yOur F0ruM.";
$lang['forum_settings_help_55'] = "j00 c@N U5E H+ML 1N Y0ur F0ruM RUl3S. HyP3Rl1NKs 4Nd 3m4IL 4DdR3S53\$ W1lL 4l50 be 4UTOm4+ic4lLy c0NvERt3d +O L1Nk\$. +O USE TH3 DEpH4UL+ B33h1v3 phOrUM 4uP cLe4R +he f1ELd.";
$lang['forum_settings_help_56'] = "u\$E <b>n0-r3ply em41l</b> t0 \$PEciFy 4n 3m@Il @ddRe5s +H4+ d035 n0+ exisT OR WiLl n0T 8e m0niT0Red f0R rEpL1E\$. Th1s 3M4il @DdREs5 w1Ll 83 U5ED in th3 he@d3R5 FoR @lL 3M@1l\$ sEn+ FROM Y0uR PH0rUM 1NcLUDIn9 8UT N0+ l1mITed to p0\$t 4nD PM nO+1FIc4tI0N5, U\$eR eM41L\$ @ND p@sSw0Rd reMiND3rS.";
$lang['forum_settings_help_57'] = "it i5 R3CoMmend3d TH4t J00 UsE 4n 3M@Il @ddre5s +h4+ D03\$ no+ 3X15T t0 H3Lp cUt d0wN On 5P4m TH4t M4y b3 d1rEctED 4+ Y0uR m4iN fOrUm 3m@1L @dDre\$\$";

// Attachments (attachments.php, get_attachment.php) ---------------------------------------

$lang['aidnotspecified'] = "a1d nOT SpEc1F1ed.";
$lang['upload'] = "upL04D";
$lang['uploadnewattachment'] = "uPlO@d new 4++4cHM3nT";
$lang['waitdotdot'] = "w41T..";
$lang['successfullyuploaded'] = "suCc3SsPhulLy UpLo4DEd";
$lang['failedtoupload'] = "f41leD +0 upL0@D";
$lang['complete'] = "c0MPLet3";
$lang['uploadattachment'] = "upLO@d 4 f1L3 pH0r 4++4chmenT TO +eh m3s54Ge";
$lang['enterfilenamestoupload'] = "eNT3R PhiL3Nam3(\$) +0 uPLo4d";
$lang['attachmentsforthismessage'] = "a+T4Chm3n+\$ PH0R thI\$ MESs493";
$lang['otherattachmentsincludingpm'] = "o+HER @Tt4ChmEn+S (1ncLUd1N9 PM meSS493\$ 4Nd 0+Her ForUmS)";
$lang['totalsize'] = "tO+4L s1ze";
$lang['freespace'] = "fr3e Sp@ce";
$lang['attachmentproblem'] = "th3RE W45 4 pr0Bl3M dOWnlO4D1nG TH15 4++4ChM3Nt. plE4S3 +rY 4G@1n L4+3r.";
$lang['attachmentshavebeendisabled'] = "a++4cHmen+5 h4Ve 8eEn DIs@bL3d by th3 phOrUM 0wn3r.";
$lang['canonlyuploadmaximum'] = "j00 c4n OnLy UpLO@d 4 m4XImum 0f 10 ph1LeS 4+ 4 +1me";
$lang['deleteattachments'] = "deL3+e 4+t4chmENt\$";
$lang['deleteattachmentsconfirm'] = "arE j00 5Ur3 J00 W4nT t0 D3L3+3 +eh S3l3c+ED 4tt4chm3N+S?";
$lang['deletethumbnailsconfirm'] = "ar3 j00 \$ure j00 W4nT +O dEleTe +he S3L3ct3D 4tt@cHmeNTs +HumBN41lS?";

// Changing passwords (change_pw.php) ----------------------------------

$lang['passwdchanged'] = "p@S\$W0rd ch@n9ed";
$lang['passedchangedexp'] = "y0uR pA\$\$W0RD H45 bE3n cHANged.";
$lang['updatefailed'] = "uPd4TE PH@1l3d";
$lang['passwdsdonotmatch'] = "p@55wORd\$ do nO+ m4+CH.";
$lang['newandoldpasswdarethesame'] = "n3w @nD 0LD p45\$WOrD\$ 4rE The 54M3.";
$lang['allfieldsrequired'] = "all PH13lD\$ 4rE r3qU1rED.";
$lang['requiredinformationnotfound'] = "r3QUiREd INform4+I0N N0+ f0UND";
$lang['forgotpasswd'] = "for9Ot P@5SwOrd";
$lang['enternewpasswdforuser'] = "eN+eR 4 n3W P@S5w0rD f0r uS3R %s";
$lang['resetpassword'] = "r35ET p45Sw0rd";
$lang['resetpasswordto'] = "r3\$3t PaS5WoRd To";

// Deleting messages (delete.php) --------------------------------------

$lang['nomessagespecifiedfordel'] = "nO me5S4gE \$P3C1Fi3D fOR d3L3tI0n";
$lang['deletemessage'] = "d3L3T3 meSs4Ge";
$lang['postdelsuccessfully'] = "p05t d3lEt3d sUCCES5FulLY";
$lang['errordelpost'] = "errOr D3l3TINg po\$t";
$lang['cannotdeletepostsinthisfolder'] = "j00 caNn0T d3L3T3 POS+5 1n thI5 fOld3r";

// Editing things (edit.php, edit_poll.php) -----------------------------------------

$lang['nomessagespecifiedforedit'] = "n0 m3\$S49E SpeCiF1eD f0R ed1T1ng";
$lang['cannoteditpollsinlightmode'] = "c4NN0T 3D1t poll\$ 1n LigHT mOde";
$lang['editedbyuser'] = "ed1T3d: %s 8Y %s";
$lang['editappliedtomessage'] = "edI+ 4PplIED tO M3\$54GE";
$lang['errorupdatingpost'] = "err0R upD4t1Ng p05t";
$lang['editmessage'] = "eDI+ m3\$5493 %s";
$lang['editpollwarning'] = "<b>n0t3</b>: 3d1T1N9 c3rta1N 45pEC+S 0F 4 pOll WIll V0Id 4lL THe CURreNT v0+eS 4ND ALL0w p3OPL3 to v0+e 4G4iN.";
$lang['hardedit'] = "h4rd ed1t 0P+10N\$ (Vot3s w1Ll 83 R3\$Et):";
$lang['softedit'] = "s0PHt 3d1+ 0ptI0NS (VO+3\$ w1Ll bE rEt4in3D):";
$lang['changewhenpollcloses'] = "ch4N9e WHen the pOll cL05e\$?";
$lang['nochange'] = "no ch@n9E";
$lang['emailresult'] = "em4IL re5Ul+";
$lang['msgsent'] = "m3s\$493 5en+";
$lang['msgsentsuccessfully'] = "mE5\$4GE SeN+ \$Ucce\$SPhuLLY.";
$lang['mailsystemfailure'] = "m@1L \$YS+EM f@ILur3. Me5S4g3 nOT \$ENt.";
$lang['nopermissiontoedit'] = "j00 4r3 n0+ PeRMi+Ted +0 3dI+ thi\$ m3S54Ge.";
$lang['cannoteditpostsinthisfolder'] = "j00 c4NNo+ eDi+ P0\$+5 iN th1\$ FOlder";
$lang['messagewasnotfound'] = "meSS493 %s w4\$ nO+ FounD";

// Email (email.php) ---------------------------------------------------

$lang['nouserspecifiedforemail'] = "n0 u\$eR sPeciF1Ed Ph0R 3m41liN9.";
$lang['entersubjectformessage'] = "enT3r 4 SU8j3CT PH0r t3H M3S549E";
$lang['entercontentformessage'] = "en+Er SOmE c0n+enT pHor +h3 m3S\$4ge";
$lang['msgsentfromby'] = "tHi5 meS5@G3 w@s SEnt PHr0m %s 8y %s";
$lang['subject'] = "sUbjEc+";
$lang['send'] = "s3ND";
$lang['hasoptedoutofemail'] = "h@S 0P+ed 0U+ oph 3M41L COnt4c+";
$lang['hasinvalidemailaddress'] = "h@s 4N INv4L1d eM4Il 4ddrES5";

// Message nofificaiton ------------------------------------------------

$lang['msgnotification_subject'] = "me\$S@93 N0Tif1C4ti0n pHr0M %s";
$lang['msgnotificationemail'] = "h3LlO %s,\n\n%s PO\$T3D a MEs\$493 +0 j00 0n %s.\n\n+He Su8j3c+ i5: %s.\n\nt0 R34D th4t m3sS493 4Nd O+heRS 1N TEh \$4M3 D1SCuS\$1On, 9O to:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nNoT3: 1F J00 dO nOT w1\$h +o ReCEiv3 3M41L NO+1F1C4t1on\$ Of Ph0ruM MESS493s Po\$Ted +0 y0U, Go tO: %s clICK On my c0N+R0LS +h3N EM@il 4nD pr1v4cy, Un5eL3c+ T3H 3M@il nO+1pHIC@T1ON cHeCKbOX @Nd prE\$5 5UbMIt.";

// Thread Subscription notification ------------------------------------

$lang['subnotification_subject'] = "sUbsCR1p+10n NO+IF1c4+I0n FrOM %s";
$lang['subnotification'] = "h3LL0 %s,\n\n%s p0S+ed a Me\$s4gE 1N @ Thr34D j00 h4v3 5U8\$Cr18Ed +0 0n %s.\n\n+hE Subj3CT iS: %s.\n\nTO r3@d +h@t M3S\$4g3 4Nd 0+H3r5 1N T3h 5@m3 DIScUs510n, G0 +O:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nN0T3: iF j00 d0 nO+ WiSh T0 r3c3Iv3 3M41L NO+iF1c@+10nS 0f n3W m3S\$4G3s iN +h1s +Hr3@D, 9O +o: %s 4Nd @dJU\$T y0Ur INTErE\$t LEvEL 4+ tHE boTt0M OpH thE P@G3.";

// PM notification -----------------------------------------------------

$lang['pmnotification_subject'] = "pm Not1Ph1c@tI0n FR0m %s";
$lang['pmnotification'] = "h3LLO %s,\n\n%s Po5ted A pm +0 j00 0n %s.\n\n+H3 SUBJ3CT is: %s.\n\n+0 RE4d +HE M3S54g3 9O t0:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nn0+e: 1f j00 Do not w1Sh +o reC31ve Em@Il n0TifIC4+IOn\$ OPh nEw pM me5\$4GeS P0S+3D +o y0U, 90 +0: %s CLicK my c0N+RoLS th3N 3m41l @nD PRiV4cy, UnS3L3ct thE PM n0+iF1C4+Ion ChECkbOx 4ND pr3\$5 su8m1+.";

// Password change notification ----------------------------------------

$lang['passwdchangenotification'] = "p@\$\$W0Rd chAn9E N0T1FIC4tI0N Phr0m %s";
$lang['pwchangeemail'] = "heLlo %s,\n\nTHi5 4 No+If1C@+1oN 3M41l +0 inf0rm J00 +h4t Y0Ur p4S5WoRd 0N %s h45 b33N ch@nG3D.\n\n1T h45 bEeN ch4ng3d +0: %s 4Nd w45 ch@Ng3D by: %s.\n\nIF J00 h4v3 recE1vEd Th1S eM4Il in Error OR W3R3 nO+ EXpEc+In9 4 ch4nge T0 YOur p@5Sw0Rd pL3453 c0N+@C+ +he ph0RuM 0WnEr or 4 ModeR4+oR oN %s 1mm3Di4+3Ly to c0RrecT 1+.";

// Email confirmation notification -------------------------------------

$lang['emailconfirmationrequired'] = "em4il ConfirM4T1On R3qUir3D pHor %s";
$lang['confirmemail'] = "heLlO %s,\n\nY0U Rec3n+LY cRe4t3d 4 N3w u5eR @cC0uNT 0n %s.\n83pH0r3 J00 c@n 5T@r+ p0\$T1Ng wE N33d +0 coNFiRm Y0Ur 3ma1L 4ddRe\$s. D0n'+ W0Rry TH1S Is quI+3 34SY. 4Ll j00 ne3d tO Do I5 CLick +eh l1nK 83L0W (Or c0py 4nd PA\$TE it in+o youR 8R0w\$3r):\n\n%s\n\n0ncE CoNFIrm4T1oN 1S C0MpLe+E J00 m4Y loG1N and St4rt pO5+1Ng ImM3di4+elY.\n\nif j00 d1D N0+ cRE@t3 @ uSeR @cCoUN+ ON %s Ple45e @cC3P+ 0UR 4POl09Ie5 4nd fORW4rD +hIS eM@IL tO %s \$o +H4+ +3h 5oURcE OPH IT M4Y 83 INv3S+i94TeD.";
$lang['confirmchangedemail'] = "heLl0 %s,\n\ny0u r3cenTLy cH4n9Ed yoUr EM4il 0N %s.\nbepHORe J00 c@n S+4R+ POS+inG @G4iN w3 N33D +0 cONPhIrM YouR NEW 3M4il @ddR3ss. D0n't W0RRY +H15 1\$ quITe 34SY. 4ll j00 N3Ed +o DO is clICk +HE LInK b3lOW (0r cOpY And p@STe i+ iNt0 y0ur 8ROwS3r):\n\n%s\n\nOnCE cOnPHiRm@+10N 15 compL3TE J00 m@Y cON+1nU3 T0 u5E +h3 ForUM @s NoRm4L.\n\nIf j00 WERE NO+ eXPEcT1n9 +H15 Em@1L Phr0m %s pl3@SE 4Cc3pT 0ur @P0L0G1ES 4Nd pH0Rw4rD +Hi5 emA1L +o %s \$o TH@+ +H3 \$OuRC3 0f 1+ M4Y B3 1NvEST194teD.";


// Forgotten password notification -------------------------------------

$lang['forgotpwemail'] = "h3llo %s,\n\nYOU reqUEsTeD +H1s e-M@1L FroM %s 83C@u\$E J00 H4v3 pH0rGO+tEn y0uR pAs5WoRd.\n\nclicK the LInK BeLOW (oR coPY @nD P@StE It in+O yOUr bRowsEr) T0 re\$et Y0UR P455Word:\n\n%s";

// Forgotten password form.

$lang['passwdresetrequest'] = "yoUR p4s\$w0RD R3\$et reQU35t pHR0m %s";
$lang['passwdresetemailsent'] = "p4s\$w0Rd r3sE+ e-M@Il s3n+";
$lang['passwdresetexp'] = "j00 \$H0uLd Sh0R+Ly rEc31vE @N 3-M@il c0N+4IN1ng 1Ns+rUCTiOn\$ FoR R3s3+TiNg y0UR P4\$5w0Rd.";
$lang['validusernamerequired'] = "a v4l1D UsErn@mE is REQu1red";
$lang['forgottenpasswd'] = "f0rGOt P45\$W0Rd";
$lang['forgotpasswdexp'] = "iPh j00 h@V3 PHORGO+TEN Y0UR Pa\$\$W0Rd, j00 c@N reqUesT t0 H@v3 IT r3\$Et bY 3n+Er1ng YOUr L090n N4m3 beL0W. 1nS+RuctIOnS 0n h0W +O r3\$eT y0Ur P45SwOrd WilL bE SEnt T0 YOUr r391\$T3r3d 3m41l 4ddrES\$.";
$lang['couldnotsendpasswordreminder'] = "c0uld n0+ SeND p@S5woRD r3m1nd3R. pL34\$e cONtact +eH pHOruM OwneR.";
$lang['request'] = "r3QueSt";

// Email confirmation (confirm_email.php) ------------------------------

$lang['emailconfirmation'] = "eM@il c0nPHirm4T10n";
$lang['emailconfirmationcomplete'] = "tH4Nk j00 pH0r cOnfIrm1ng youR 3M@il @DDre5S. j00 M4y n0w L091n 4Nd 5t@R+ p05tinG 1Mm3dI4T3lY.";
$lang['emailconfirmationfailed'] = "em41L conF1Rm4T10n h4\$ pH@1led, ple4\$e Try @g4IN l4+Er. 1f J00 eNcoUNtEr +Hi5 3Rr0r MUl+iplE +1M3S pLE@\$e cONtAc+ tH3 PH0Rum OWneR 0R @ mOdEr4+0r FOR 4551s+4nCe.";

// Links database (links*.php) -----------------------------------------

$lang['toplevel'] = "t0P leV3L";
$lang['maynotaccessthissection'] = "j00 m@y no+ accES5 thIs 5ecT10n.";
$lang['toplevel'] = "t0P lEv3L";
$lang['links'] = "liNk\$";
$lang['viewmode'] = "vi3W mOD3";
$lang['hierarchical'] = "h1ER4rchIc4L";
$lang['list'] = "l15T";
$lang['folderhidden'] = "tH1s ph0ld3R 15 HIdden";
$lang['hide'] = "hiDe";
$lang['unhide'] = "unH1D3";
$lang['nosubfolders'] = "n0 5ubpH0LdErS 1n +H1S c4te9ory";
$lang['1subfolder'] = "1 SUbpH0lD3r 1n THI5 Cat39ory";
$lang['subfoldersinthiscategory'] = "sU8ph0LdeR5 In +h1s C4te9OrY";
$lang['linksdelexp'] = "eN+R13\$ 1N 4 deL3t3D fOld3R wIlL 83 mOv3d +0 +eH p@r3N+ Ph0ld3R. oNLY FoLD3r\$ wHIch D0 n0+ c0N+4IN Su8F0lDerS M4Y 8e DeLE+eD.";
$lang['listview'] = "li5T VieW";
$lang['listviewcannotaddfolders'] = "canno+ 4Dd PhOlDer5 in tH1S View. 5How1nG 20 3ntR1Es @+ 4 t1M3.";
$lang['rating'] = "r@t1N9";
$lang['nolinksinfolder'] = "n0 LiNk\$ 1n +hi5 PH0LD3r.";
$lang['addlinkhere'] = "aDd L1nK h3re";
$lang['notvalidURI'] = "tH4+ Is No+ 4 V@liD uRi!";
$lang['mustspecifyname'] = "j00 mu5+ 5pEc1fY 4 N4me!";
$lang['mustspecifyvalidfolder'] = "j00 Mu\$+ 5pec1phy 4 v4Lid FoLD3r!";
$lang['mustspecifyfolder'] = "j00 Mu5T \$pEC1Fy 4 FoLd3R!";
$lang['addlink'] = "aDD 4 l1Nk";
$lang['addinglinkin'] = "adD1N9 L1nK 1N";
$lang['addressurluri'] = "aDdR3s\$";
$lang['addnewfolder'] = "add 4 N3w F0lDer";
$lang['addnewfolderunder'] = "aDDin9 n3W FolDEr undeR";
$lang['editfolder'] = "eD1T Ph0lder";
$lang['editingfolder'] = "ed1T1N9 fOld3r";
$lang['mustchooserating'] = "j00 mUsT cH00\$3 4 r4+1n9!";
$lang['commentadded'] = "y0ur coMmeNT w@S 4dd3d.";
$lang['musttypecomment'] = "j00 mu\$t +YP3 4 COMmen+!";
$lang['mustprovidelinkID'] = "j00 MUS+ prOVIde 4 LInK 1D!";
$lang['invalidlinkID'] = "iNv4L1d L1Nk Id!";
$lang['address'] = "addRe5\$";
$lang['submittedby'] = "suBmITted 8y";
$lang['clicks'] = "cLiCKs";
$lang['rating'] = "r@+1ng";
$lang['vote'] = "v0te";
$lang['votes'] = "vot3\$";
$lang['notratedyet'] = "n0T R@+Ed bY 4nyON3 Ye+";
$lang['rate'] = "r4T3";
$lang['bad'] = "b@D";
$lang['good'] = "gO0D";
$lang['voteexcmark'] = "vO+3!";
$lang['clearvote'] = "cL34r V0Te";
$lang['commentby'] = "c0MmeNT 8Y %s";
$lang['addacommentabout'] = "aDD 4 c0mmeNT 4b0U+";
$lang['modtools'] = "m0deR4+i0n +0OL\$";
$lang['editname'] = "edi+ n4M3";
$lang['editaddress'] = "eDi+ 4DdrE\$5";
$lang['editdescription'] = "eDIT dEScr1P+iON";
$lang['moveto'] = "m0V3 +0";
$lang['linkdetails'] = "l1nk dEt41L5";
$lang['addcomment'] = "adD ComMEnT";
$lang['voterecorded'] = "y0ur vOT3 h@5 be3N r3C0rD3D";
$lang['votecleared'] = "yOUr v0+E h@5 beeN CleAR3d";

// Login / logout (llogon.php, logon.php, logout.php) -----------------------------------------

$lang['loggedinsuccessfully'] = "j00 LOG9eD 1n SuccES5phUlly.";
$lang['presscontinuetoresend'] = "pr3\$S c0NtiNUe t0 R3\$3Nd Ph0RM d4+4 0r C@nceL +O REl04d p4Ge.";
$lang['usernameorpasswdnotvalid'] = "the u53rn@M3 Or P4\$\$W0Rd J00 5UpplI3D 1\$ n0+ v4Lid.";
$lang['pleasereenterpasswd'] = "plE@se re-eNt3R yOur p4\$\$w0RD @Nd Try @9@In.";
$lang['rememberpasswds'] = "reM3m83r p4S\$W0rd\$";
$lang['rememberpassword'] = "rem3m83r P4\$sw0rd";
$lang['enterasa'] = "eN+eR 45 4 %s";
$lang['donthaveanaccount'] = "dON'+ h4Ve aN 4CCOUN+? %s";
$lang['registernow'] = "rEg1StER nOw.";
$lang['problemsloggingon'] = "pr0Bl3m5 LO99iN9 oN?";
$lang['deletecookies'] = "d3LeTe C0oKi3s";
$lang['cookiessuccessfullydeleted'] = "c0OKIe5 SUCc3\$5pHully D3lET3d";
$lang['forgottenpasswd'] = "f0R9O+tEn YOur p4\$SW0RD?";
$lang['usingaPDA'] = "uSIng 4 pd4?";
$lang['lightHTMLversion'] = "l1GhT HTmL vEr\$10n";
$lang['youhaveloggedout'] = "j00 h4ve L099ed Ou+.";
$lang['currentlyloggedinas'] = "j00 4R3 cUrr3n+LY l099Ed 1N a\$ %s";
$lang['logonbutton'] = "lO9on";
$lang['otherbutton'] = "o+hER";
$lang['yoursessionhasexpired'] = "y0ur S3S\$I0n h@5 exp1R3d. J00 Will need +o LogIn 4G4iN t0 c0n+Inu3.";

// My Forums (forums.php) ---------------------------------------------------------

$lang['myforums'] = "my PH0RUms";
$lang['allavailableforums'] = "all 4VAIl4Ble ForuM\$";
$lang['favouriteforums'] = "f4v0UR1te phoRUm5";
$lang['ignoredforums'] = "i9N0R3d PHOrumS";
$lang['ignoreforum'] = "i9n0R3 ph0RuM";
$lang['unignoreforum'] = "unI9N0Re Ph0rum";
$lang['lastvisited'] = "l@\$T v1sit3d";
$lang['forumunreadmessages'] = "%s UNRe@D MEsS4GeS";
$lang['forummessages'] = "%s mesS493s";
$lang['forumunreadtome'] = "%s uNRe4d &quot;to: Me&quot;";
$lang['forumnounreadmessages'] = "n0 UnRE4d MeS\$49ES";
$lang['removefromfavourites'] = "r3M0Ve Fr0M fAv0uRI+eS";
$lang['addtofavourites'] = "aDd T0 PH4v0UrI+3\$";
$lang['availableforums'] = "aV41L@Ble f0RuMs";
$lang['noforumsofselectedtype'] = "tHere @re No FoRuMS 0f tH3 5el3cT3d +yPe 4v4IlAbl3. PlE453 \$eL3Ct 4 diFF3r3n+ +ypE.";
$lang['noforumsavailablelogin'] = "tH3RE 4RE no pH0RuM\$ 4V@1l@8L3. Pl345e l091n +0 V1Ew Your PH0rumS.";
$lang['passwdprotectedforum'] = "p4\$SWORd Pr0+ECT3d FOruM";
$lang['passwdprotectedwarning'] = "tHis PhOrUm 1S p45\$WOrd pRo+ECteD. tO G41N 4cceS\$ Ent3r T3H P4SSw0Rd 83LoW.";

// Message composition (post.php, lpost.php) --------------------------------------

$lang['postmessage'] = "p05t MeS54ge";
$lang['selectfolder'] = "s3L3Ct FoLd3R";
$lang['mustenterpostcontent'] = "j00 MU5+ ent3r \$oMe c0N+3n+ f0R t3h pO\$t!";
$lang['messagepreview'] = "m3sS4G3 Pr3vIew";
$lang['invalidusername'] = "inv4l1D USeRn4me!";
$lang['mustenterthreadtitle'] = "j00 MUSt Ent3r 4 +i+lE ph0r T3h tHr34d!";
$lang['pleaseselectfolder'] = "pl34SE SELEC+ 4 ph0Ld3r!";
$lang['errorcreatingpost'] = "erROR cRe4+1Ng p05t! ple4SE TRy @G@in 1N 4 F3W M1Nut3S.";
$lang['createnewthread'] = "crEat3 N3w +hre4d";
$lang['postreply'] = "p0s+ rePlY";
$lang['threadtitle'] = "thR34d +ITlE";
$lang['messagehasbeendeleted'] = "m3sS4g3 N0+ Found. check tH@+ 1t h4\$n'+ B3en D3l3ted.";
$lang['messagenotfoundinselectedfolder'] = "m3\$s49e nOT f0Und 1N sel3cted phold3r. chEck th4+ i+ h4Sn'T 8Een Mov3d OR d3l3t3D.";
$lang['cannotpostthisthreadtypeinfolder'] = "j00 c@nn0+ P0\$T th1S +HR34d TYpe 1n Th4+ PHOldeR!";
$lang['cannotpostthisthreadtype'] = "j00 cann0T po\$+ +H15 +hrE4d tYP3 4s TH3r3 4Re nO @v@1L48Le FoLd3R\$ Th4T @lLOW I+.";
$lang['cannotcreatenewthreads'] = "j00 c4nno+ CRe@Te neW thR34d5.";
$lang['threadisclosedforposting'] = "tHI5 +hre4d 15 cL0\$ed, j00 c4Nn0T pO\$+ 1N it!";
$lang['moderatorthreadclosed'] = "w@rNIN9: tHi\$ thR34d IS CLo\$ed ph0r PO5t1n9 to n0Rm4L u\$eRS.";
$lang['threadclosed'] = "tHre4d Cl0S3d";
$lang['usersinthread'] = "u5er5 1n THRe@d";
$lang['correctedcode'] = "c0rR3C+3d cOde";
$lang['submittedcode'] = "sUBMitT3D c0D3";
$lang['htmlinmessage'] = "h+ML iN mESS4Ge";
$lang['disableemoticonsinmessage'] = "di5@8l3 3mo+1cONS In m3\$SA93";
$lang['automaticallyparseurls'] = "au+0m4+1c4LlY p4rSE uRlS";
$lang['automaticallycheckspelling'] = "auTOM4+1C4llY ch3Ck SpElL1Ng";
$lang['setthreadtohighinterest'] = "sET tHr3@D t0 HigH 1nt3reST";
$lang['enabledwithautolinebreaks'] = "eNA8lEd W1Th 4U+O-l1n3-bRE4k5";
$lang['fixhtmlexplanation'] = "tH15 PH0rUM US3s HtML pHil+eriNg. Y0ur sU8M1Tt3d HtmL H4S 8eEN MOD1f13d 8Y +3H F1L+er5 1N \$oM3 w4y.\\n\\nT0 ViEW YOuR ORI9In@l COd3, S3LeCt T3h \\'\$u8M1+tEd COD3\\' r@di0 8UttOn.\\n+0 VIeW TH3 m0diPH1eD C0de, s3L3cT +EH \\'CORRecT3D cODe\\' r@d10 8u+ton.";
$lang['messageoptions'] = "m3SS4Ge op+10nS";
$lang['notallowedembedattachmentpost'] = "j00 @Re n0+ @Ll0w3d +0 3M83D 4+t4chm3N+S In Y0Ur p0S+\$.";
$lang['notallowedembedattachmentsignature'] = "j00 @RE N0+ @Ll0WED tO EMbed @+T4chmENt\$ 1n YoUR \$1gn4+Ure.";
$lang['reducemessagelength'] = "meSS4Ge leNg+h must b3 Und3R 65,535 ch@r4ct3rS (cUrrentLy:";
$lang['reducesiglength'] = "s19N4+ure leng+h muSt 83 UND3R 65,535 ch4r4C+er5 (Curr3n+Ly:";
$lang['cannotcreatethreadinfolder'] = "j00 C@nno+ cr34+e N3w tHr34dS iN Th15 pH0Ld3R";
$lang['cannotcreatepostinfolder'] = "j00 c4nNo+ Reply +0 p0\$TS 1N +H15 ph0Lder";
$lang['cannotattachfilesinfolder'] = "j00 c@NN0+ Po5t @+t4Chm3n+\$ 1n ThiS fOldEr. rEM0ve 4+T4chm3ntS +O cONTiNu3.";
$lang['postfrequencytoogreat'] = "j00 c4n ONLy P0St onc3 3V3Ry %s seCoNd\$. plE45e +ry @g4in l4T3R.";
$lang['emailconfirmationrequiredbeforepost'] = "em@1l cONF1rm4T10N 15 RequIRed b3PhoR3 J00 C4n p0sT. Iph J00 h@ve No+ R3C3Iv3d a CoNf1Rm@+10N Em41l pl34SE cLIck +He 8Ut+0n 83lOw 4Nd 4 N3W 0n3 wILl 83 5EnT +o y0u. IPH y0uR 3M41L 4ddR3ss n33DS Ch@N9In9 PL34Se d0 \$0 BePh0R3 ReQUE\$t1n9 4 n3w c0NphiRM4T10N 3m41L. J00 m@y CHAngE y0UR eM41l 4dDRes\$ By cL1cK mY cONtR0l5 @80V3 @nD TH3N us3R dE+41l\$";
$lang['emailconfirmationfailedtosend'] = "cONpHiRm4t1On 3m@1l ph4il3D +0 sENd. pl3a\$3 CoNt4cT +He fORum 0WN3r TO RecTiFy +H1s.";
$lang['emailconfirmationsent'] = "c0NphiRM4+I0n eM4Il H4S 83eN r3\$3nt.";
$lang['resendconfirmation'] = "re53ND COnPHirMaTI0n";
$lang['userapprovalrequiredbeforeaccess'] = "y0ur u\$er 4ccOUNt N3Eds +O 8E 4ppROVED BY @ f0Rum @dm1n b3pHoR3 j00 c4N @cc3ss TH3 R3QueS+3d FORuM.";

// Message display (messages.php & messages.inc.php) --------------------------------------

$lang['inreplyto'] = "iN RepLy +0";
$lang['showmessages'] = "sh0W M3\$S4g35";
$lang['ratemyinterest'] = "ra+3 MY Int3rE\$T";
$lang['adjtextsize'] = "adjU5T +ex+ s1ze";
$lang['smaller'] = "sm4LleR";
$lang['larger'] = "l4Rg3r";
$lang['faq'] = "fAq";
$lang['docs'] = "dOcS";
$lang['support'] = "sUPport";
$lang['donateexcmark'] = "doNaT3!";
$lang['threadcouldnotbefound'] = "the ReqU3ST3d tHr34d cOuLd N0+ BE f0UND 0r 4cce55 w4\$ d3n1ed.";
$lang['mustselectpolloption'] = "j00 mUS+ 53l3CT 4N 0P+10n +0 v0+E fOR!";
$lang['mustvoteforallgroups'] = "j00 mu\$t Vo+e in EveRY GroUp.";
$lang['keepreading'] = "k3Ep re4DinG";
$lang['backtothreadlist'] = "b4cK to +hre4d LISt";
$lang['postdoesnotexist'] = "th4t POs+ D0E5 nO+ Ex15t 1N th15 thr3ad!";
$lang['clicktochangevote'] = "clICk +o CH@nGe VO+3";
$lang['youvotedforoption'] = "j00 vO+ED Ph0R Op+I0N";
$lang['youvotedforoptions'] = "j00 V0t3d ph0R Op+I0Ns";
$lang['clicktovote'] = "cLIcK +0 VO+E";
$lang['youhavenotvoted'] = "j00 H@ve n0+ vOt3d";
$lang['viewresults'] = "vIEW R3SulTS";
$lang['msgtruncated'] = "mEss4ge Trunc4+3D";
$lang['viewfullmsg'] = "vI3W FUll M3SS493";
$lang['ignoredmsg'] = "i9NOr3D Me\$54g3";
$lang['wormeduser'] = "w0rm3D U\$3r";
$lang['ignoredsig'] = "iGnOR3d 5ign4tuRE";
$lang['messagewasdeleted'] = "m35S4G3 %s.%s W@s d3L3+3D";
$lang['stopignoringthisuser'] = "sToP ignOR1n9 +h1S u\$3r";
$lang['renamethread'] = "r3n4m3 +hre4d";
$lang['movethread'] = "m0V3 tHr34d";
$lang['editthepoll'] = "eD1+ +H3 POll";
$lang['torenamethisthread'] = "to Ren4me tH1S thR34d";
$lang['closeforposting'] = "cLOse ph0R p05+in9";
$lang['until'] = "uNT1l 00:00 U+C";
$lang['approvalrequired'] = "aPpR0V4L REQu1red";
$lang['messageawaitingapprovalbymoderator'] = "mess4gE %s.%s i5 4w4ItIng @pPRoV4L 8y 4 mOdEr4+0R";
$lang['postapprovedsuccessfully'] = "po\$T 4ppr0Ved Succ3\$sfUlLy";
$lang['postapprovalfailed'] = "p0s+ 4PprOv@L f@1L3D.";
$lang['postdoesnotrequireapproval'] = "pO\$T do3\$ noT R3QuirE 4ppRoV4L";
$lang['approvepost'] = "appr0ve pO5T ph0r D15pl4Y";
$lang['approvedbyuser'] = "apProv3D: %s 8y %s";
$lang['makesticky'] = "m4ke STIckY";
$lang['messagecountdisplay'] = "%s OpH %s";
$lang['linktothread'] = "pERmAnEnt l1NK +0 +HiS +Hre4D";
$lang['linktopost'] = "l1NK +0 pO\$t";
$lang['linktothispost'] = "liNK +0 +H15 pO5T";
$lang['imageresized'] = "th1S 1M4ge H@S 8EEn R3\$ized (0R1G1n4l S1z3 %1\$5x%2\$s). +O v13w th3 FULl-S1Z3 IM49E cL1Ck h3Re.";
$lang['messagedeletedbyuser'] = "m3\$S4Ge %s.%s d3l3t3d %s by %s";
$lang['messagedeleted'] = "me554G3 %s.%s w4\$ d3let3d";

// Moderators list (mods_list.php) -------------------------------------

$lang['cantdisplaymods'] = "c4nn0+ D1spl4y pHOldEr M0deR@+orS";
$lang['moderatorlist'] = "m0d3R4tOR L1S+:";
$lang['modsforfolder'] = "m0Der4+or\$ PHoR f0LD3r";
$lang['nomodsfound'] = "n0 moD3r4+0R5 F0uND";
$lang['forumleaders'] = "f0RUm L34D3r\$:";
$lang['foldermods'] = "f0LD3R mOd3r4+0rS:";

// Navigation strip (nav.php) ------------------------------------------

$lang['start'] = "st4R+";
$lang['messages'] = "mEs\$@GE\$";
$lang['pminbox'] = "inB0X";
$lang['startwiththreadlist'] = "s+arT P@g3 WI+H +hr34d L1ST";
$lang['pmsentitems'] = "sent I+em\$";
$lang['pmoutbox'] = "oUtbox";
$lang['pmsaveditems'] = "s4V3d It3m\$";
$lang['pmdrafts'] = "dR@fts";
$lang['links'] = "liNks";
$lang['admin'] = "adm1N";
$lang['login'] = "lo9In";
$lang['logout'] = "l090uT";

// PM System (pm.php, pm_write.php, pm.inc.php) ------------------------

$lang['privatemessages'] = "pRIV4+E m3SsA93\$";
$lang['recipienttiptext'] = "s3p@r4+3 R3c1pientS 8y s3mI-C0l0N 0r Comm4";
$lang['maximumtenrecipientspermessage'] = "ther3 15 @ LiM1+ 0Ph 10 rec1pI3N+S per me5S4G3. Pl3@sE 4m3ND y0Ur r3c1pIEN+ li5t.";
$lang['mustspecifyrecipient'] = "j00 Mu\$T \$P3cipHy 4t l34S+ 0ne recIp1en+.";
$lang['usernotfound'] = "u53r %s nO+ ph0Und";
$lang['sendnewpm'] = "sEnd n3w PM";
$lang['savemessage'] = "s4ve m3SS49e";
$lang['timesent'] = "time \$ent";
$lang['nomessages'] = "nO me\$54g3S";
$lang['errorcreatingpm'] = "err0R cre4+1nG pM! PlE4se Try @94iN iN 4 fEw MInU+e\$";
$lang['writepm'] = "wri+E mESS@g3";
$lang['editpm'] = "edi+ m3S5493";
$lang['cannoteditpm'] = "c4nNo+ 3di+ +his pm. 1T h45 4lr34Dy 833n vi3w3D 8y t3h R3C1p13n+ 0r +3h mE\$\$493 dO3\$ No+ eXiST 0R It 1S in4cc3\$51bL3 8y j00";
$lang['cannotviewpm'] = "c4NN0+ VieW PM. m3S54Ge d0eS N0+ 3xiST 0r I+ 15 1n4cce\$Si8l3 BY j00";
$lang['pmmessagenumber'] = "m35S4ge %s";

$lang['youhavexnewpm'] = "j00 H@V3 %d N3w m3SS493S. w0uld J00 LIke to 9O T0 yOUr 1nBoX N0W?";
$lang['youhave1newpm'] = "j00 h@ve 1 N3w m3S\$49e. woUld J00 L1K3 tO 90 t0 youR 1N8oX N0w?";
$lang['youhave1newpmand1waiting'] = "j00 H@ve 1 NeW m3\$\$4GE.\\n\\ny0u 4Ls0 h@ve 1 meS54g3 4w41tiN9 del1veRY. to r3ce1Ve thi5 MeSS493 pL34\$e cl34r 5om3 Sp@C3 1N yOuR IN8oX.\\n\\nwOuld j00 lIkE To g0 +0 Y0ur In80x nOW?";
$lang['youhave1pmwaiting'] = "j00 h@ve 1 m3\$S4Ge 4w@1+1n9 d3l1V3ry. To r3c31v3 +h15 m3S\$49E PLe45E clE4r SOMe \$p4C3 IN YoUR in80x.\\n\\nw0uLd J00 l1K3 To 9O +0 YouR iNbOX nOW?";
$lang['youhavexnewpmand1waiting'] = "j00 h@v3 %d New m3s5493S.\\n\\ny0U 4lSo H4v3 1 m3SS4ge 4w41+1NG D3L1verY. t0 rECe1Ve Thi5 m3S54ge plE45E clE4R \$ome sp4Ce IN y0Ur In80x.\\n\\nw0UlD j00 l1ke tO 90 +o YOur inbox n0w?";
$lang['youhavexnewpmandxwaiting'] = "j00 h4Ve %d n3W me\$5@9e\$.\\n\\nY0U @l50 h4ve %d M3S5@g3\$ 4w@It1ng dEL1verY. TO R3ceiv3 +He5E M3\$549e pL345e clE4r 50me 5p@ce in Your 1NB0x.\\n\\nW0ULD j00 L1ke T0 g0 +0 y0ur iN80X n0w?";
$lang['youhave1newpmandxwaiting'] = "j00 havE 1 n3w M3554gE.\\n\\nyOU @l\$o H4V3 %d m3s54GE5 4W4it1n9 D3l1VerY. t0 REcE1vE +h3\$3 m3s54ge5 pL3@5E cLe@r \$omE 5p@ce 1N y0ur 1nbOx.\\n\\nW0uLD j00 liK3 +0 G0 To y0UR 1n80X n0W?";
$lang['youhavexpmwaiting'] = "j00 H4VE %d MEss4GES 4W41tinG DEl1v3ry. to R3cE1v3 +h3\$3 m3S54geS plE@5e cLE4r 5oM3 Sp4ce iN yOur in80X.\\n\\nwOulD j00 l1Ke TO g0 +O y0Ur 1N80x n0w?";

$lang['youdonothaveenoughfreespace'] = "j00 d0 n0t h4VE 3n0U9h phr3E sP4C3 +o 53nD +HI5 M3s5493.";
$lang['userhasoptedoutofpm'] = "%s H@s OPT3d Out OF r3c31v1ng p3rSoN4l m3\$5@ges";
$lang['pmfolderpruningisenabled'] = "pm F0lder pRuninG iS En4bL3d!";
$lang['pmpruneexplanation'] = "th1S ph0rum UsES Pm FOLd3R PRUn1Ng. TH3 MEsSAgeS j00 h4v3 5TorEd 1N YoUr InbOx 4Nd seNt iT3mS\\npH0LD3RS 4rE 5U8J3c+ t0 @U+0m@T1C D3Let1oN. @nY mEsS4G3s j00 WisH To k33p \$h0ULd Be m0VeD +0\\nYOUr \\'\$4Ved 1T3MS\\' fOLder sO +Ha+ Th3y @re n0+ D3L3+ed.";
$lang['yourpmfoldersare'] = "y0uR Pm ph0Ld3r5 aRE %s fUll";
$lang['currentmessage'] = "cURreN+ MeSS4Ge";
$lang['unreadmessage'] = "uNRead me5S4g3";
$lang['readmessage'] = "r34D m3S\$49e";
$lang['pmshavebeendisabled'] = "pErS0N4l MEs5493\$ h4ve b3en d154BLed 8Y +H3 ph0Rum OwN3R.";
$lang['adduserstofriendslist'] = "aDd US3rs +o Y0Ur FriEndS L1\$+ to H@ve th3M @pp3@r in 4 dr0P dOwN 0N +eH Pm WRi+3 Me5SA93 P@gE.";

$lang['messagesaved'] = "me\$54ge sAV3d";
$lang['messagewassuccessfullysavedtodraftsfolder'] = "m355493 W@S \$UccEssPHUlly S4vED +O 'dR4F+5' PHoLdeR";
$lang['couldnotsavemessage'] = "cOulD N0+ SAve M3\$54GE. m4k3 5Ur3 j00 h@VE 3noUgH 4v4Il@bLe Phr33 \$P@ce.";
$lang['pmtooltipxmessages'] = "%s MeSS4geS";
$lang['pmtooltip1message'] = "1 M3Ss493";

$lang['allowusertosendpm'] = "alL0W Us3R to \$end pEr\$on@l mes\$4g3S +0 m3";
$lang['blockuserfromsendingpm'] = "bLOCK u\$3r Phr0M S3ndin9 P3r\$ON4L M3\$\$4G3s to m3";

// Preferences / Profile (user_*.php) ---------------------------------------------

$lang['mycontrols'] = "my COn+r0l\$";
$lang['myforums'] = "mY fOrUm\$";
$lang['menu'] = "meNu";
$lang['userexp_1'] = "uS3 +3h m3nu oN TH3 left to M4na9e y0Ur SeTt1n9S.";
$lang['userexp_2'] = "<b>uS3R D3+@iL\$</b> alLOw5 j00 tO ch@Ng3 yOur N4me, em@il 4ddR3\$S 4nD p4\$5worD.";
$lang['userexp_3'] = "<b>usER PR0F1Le</b> 4lL0w\$ j00 +O Edi+ YouR uSeR PRoPh1L3.";
$lang['userexp_4'] = "<b>cH@n9e P4\$SW0Rd</b> @ll0wS j00 +0 cHange y0uR p@55WORd";
$lang['userexp_5'] = "<b>emaIL &amp; pr1V@cy</b> l3+S J00 cH4ng3 H0W j00 Can 83 coNTacTeD 0n @nd OFpH +3H FORum.";
$lang['userexp_6'] = "<b>f0ruM Op+I0nS</b> l3t5 J00 cHanGe HOw tEh phORum L00K\$ 4nd wORkS.";
$lang['userexp_7'] = "<b>at+4ChM3N+\$</b> 4lL0W5 j00 tO 3d1+/d3L3+3 YOuR 4+t4chM3N+5.";
$lang['userexp_8'] = "<b>s19N@+UrE</b> Le+5 j00 3d1+ y0uR \$IgN4+URe.";
$lang['userexp_9'] = "<b>r3L4+i0nSH1P5</b> lEt5 j00 M@N49E y0ur rel4+10n\$h1p w1+h 0+h3r USeRs oN +HE Ph0RuM.";
$lang['userexp_9'] = "<b>w0rd F1l+eR</b> l3t\$ j00 3DIt yOuR P3rSoN4L Word fiL+3R.";
$lang['userexp_10'] = "<b>thRE4D SU8Scr1P+1oN\$</b> 4LLoW\$ j00 +0 m@n4GE yOur +HRe4D sU8\$cr1P+i0N5.";
$lang['userdetails'] = "uSER deT@iL5";
$lang['userprofile'] = "us3R PRoPhiL3";
$lang['emailandprivacy'] = "em4il &amp; privACY";
$lang['editsignature'] = "edI+ s1Gn4+Ur3";
$lang['norelationships'] = "j00 h4vE No U\$3r r3L4tIOn5h1pS \$3+ Up";
$lang['editwordfilter'] = "ed1T w0Rd f1L+3R";
$lang['userinformation'] = "u53r InF0Rm4+I0N";
$lang['changepassword'] = "cH4Nge p455wOrd";
$lang['currentpasswd'] = "cUrr3N+ p@5SWORd";
$lang['newpasswd'] = "neW p4S5woRD";
$lang['confirmpasswd'] = "cOnFIrM P4\$SWorD";
$lang['passwdsdonotmatch'] = "p@S5W0Rd5 d0 nOT m4Tch!";
$lang['nicknamerequired'] = "n1CkN@me 1S r3qU1reD!";
$lang['emailaddressrequired'] = "eM4il 4DdRe5S i5 R3quIr3D!";
$lang['logonnotpermitted'] = "l0GOn nOt p3Rmi++ed. CHo0\$e 4n0tH3r!";
$lang['nicknamenotpermitted'] = "nicKn4me NO+ Perm1+ted. Cho0Se 4n0+HER!";
$lang['emailaddressnotpermitted'] = "eM41L @ddr3s5 No+ P3RM1+ted. ch00\$E 4no+her!";
$lang['emailaddressalreadyinuse'] = "em4il addr3\$5 @lR34dy 1n U5e. chOo5e @NO+heR!";
$lang['relationshipsupdated'] = "rEL4+iOn\$H1P\$ Upd4T3d!";
$lang['relationshipupdatefailed'] = "r3l4+10n\$HIp uPd4T3d pH@ILED!";
$lang['preferencesupdated'] = "pR3FeRenc3s W3r3 \$Ucc3s5PhuLly Upd4t3D.";
$lang['userdetails'] = "u53R deT@iL\$";
$lang['memberno'] = "mEm8Er nO.";
$lang['firstname'] = "fIr\$t n4Me";
$lang['lastname'] = "l@5t n4Me";
$lang['dateofbirth'] = "d@T3 Oph 8IR+H";
$lang['homepageURL'] = "h0M3P49e url";
$lang['profilepicturedimensions'] = "pr0F1le p1c+UR3 (M@x 95x95pX)";
$lang['avatarpicturedimensions'] = "aV4+4r p1cture (m@X 15x15Px)";
$lang['invalidattachmentid'] = "iNv@l1d 4+T4CHMEN+. cHeck THat 15 H45N'+ b3En D3l3t3D.";
$lang['unsupportedimagetype'] = "un\$uppOR+ed Im4gE 4+t4chm3n+. j00 C4n OnlY u\$3 JpG, 91PH @Nd Png 1M493 @tT4ChMeNt\$ foR Y0Ur 4v4T4r @nD pRofil3 P1ctUr3.";
$lang['selectattachment'] = "seL3C+ 4+t4cHm3n+";
$lang['pictureURL'] = "piCTUR3 URL";
$lang['avatarURL'] = "av4+4R uRl";
$lang['profilepictureconflict'] = "tO U\$3 @N 4++4CHm3nT ph0r y0uR pr0PhiL3 Pic+Ure TeH PIctuRe URl PHiEld mu5T b3 8l4Nk.";
$lang['avatarpictureconflict'] = "t0 uS3 4n 4+T4chM3N+ FoR Your 4v4t@R pic+urE +3H 4v4t@r Url f1ElD Mu\$t 8E 8l@NK.";
$lang['attachmenttoolargeforprofilepicture'] = "sEl3c+Ed 4tt@ChmENt 1s +00 l4r9e PHoR pROf1l3 p1C+uRe. m4X1muM d1meNS10N\$ @R3 95X95pX";
$lang['attachmenttoolargeforavatarpicture'] = "s3LEC+ed 4++4Chm3nt 1S +0o L@RG3 PH0r 4V4tAR p1c+Ure. M@XimUm D1MenS10N\$ @R3 15X15Px";
$lang['failedtoupdateuserdetails'] = "s0ME OR 4Ll oF yOur U\$er 4CCoUn+ D3+41ls C0uld NOt 83 upD4Ted. Pl3@5e trY @g4IN l@+Er.";
$lang['failedtoupdateuserpreferences'] = "s0m3 OR AlL OF Y0Ur us3r PRefERenCeS c0uLd N0+ be upd4Ted. pL3@\$3 Try 49A1n LATer.";
$lang['emailaddresschanged'] = "eM41l 4ddReS5 HaS bE3n ch4nGEd";
$lang['newconfirmationemailsuccess'] = "y0ur 3m41l 4ddREs5 H4\$ B33N CH@nGeD 4nD 4 nEw cOnPhIrm@tIoN eM@iL h45 B3EN 5enT. Pl3aSe cHecK 4ND rE4d tH3 EM4il pHoR Phur+her 1n\$TRuc+iON5.";
$lang['newconfirmationemailfailure'] = "j00 h@vE ch4Ng3d YoUR eM41L @dDre55, 8U+ w3 Wer3 uN@8L3 +o S3nd @ c0NfIRM4T10N ReqU3\$T. pl34\$3 c0n+4Ct +3h fORum 0wn3R f0R @S5iSt4Nce.";
$lang['forumoptions'] = "forUM 0PT10n5";
$lang['notifybyemail'] = "n0+1fY 8y 3M@iL OF p0\$T\$ +O m3";
$lang['notifyofnewpm'] = "n0TIphY by p0pUP oF new pm m3Ss4g3s +0 M3";
$lang['notifyofnewpmemail'] = "notiFY 8Y em4il 0f NEW pm Mes\$4g3S +0 M3";
$lang['daylightsaving'] = "adJUst f0R d4yL1ght \$4VInG";
$lang['autohighinterest'] = "aUT0M4t1c@LLY m@rk Thr34dS i P0sT 1n 4s hI9h 1n+ereST";
$lang['convertimagestolinks'] = "aut0m4TIC4LLy C0Nv3r+ em83DD3d 1M49eS In po\$tS 1nTO lInkS";
$lang['thumbnailsforimageattachments'] = "tHuM8n4ilS f0R Im@g3 @tT@CHMen+\$";
$lang['smallsized'] = "sm4lL \$1Zed";
$lang['mediumsized'] = "meDIum SIz3D";
$lang['largesized'] = "l@RgE SIzEd";
$lang['globallyignoresigs'] = "glOb4Lly 19NOre US3r \$1gN@tURe5";
$lang['allowpersonalmessages'] = "aLL0W O+hER u\$3R\$ +o \$enD mE P3r5on@l m3sS49es";
$lang['allowemails'] = "allOW 0+her USerS +0 5eNd m3 3M@il5 vI4 mY prOFil3";
$lang['timezonefromGMT'] = "tIM3 zOnE";
$lang['postsperpage'] = "po\$t\$ PeR P49e";
$lang['fontsize'] = "fON+ s1zE";
$lang['forumstyle'] = "f0rUM StyLe";
$lang['forumemoticons'] = "f0ruM 3m0+1c0n\$";
$lang['startpage'] = "s+4Rt P@ge";
$lang['signaturecontainshtmlcode'] = "siGN4tuRe c0n+4iNs HTml C0dE";
$lang['savesignatureforuseonallforums'] = "saV3 S1gn4+Ure FoR uS3 0n aLl pH0rum\$";
$lang['preferredlang'] = "pr3PH3rred l4N9U493";
$lang['donotshowmyageordobtoothers'] = "d0 n0t SH0w mY @g3 Or d@+e 0F 81RTH To 0TH3r5";
$lang['showonlymyagetoothers'] = "sHow 0NLY mY @ge +0 0TH3Rs";
$lang['showmyageanddobtoothers'] = "shOw 8O+h mY @G3 @nd da+e Of b1R+h tO 0th3rS";
$lang['showonlymydayandmonthofbirthytoothers'] = "shOw OnLy MY d@y ANd M0nth 0pH 8ir+h tO 0+h3r\$";
$lang['listmeontheactiveusersdisplay'] = "l15T me ON +EH 4Ct1ve U\$erS d1SpL4Y";
$lang['browseanonymously'] = "br0wSE ph0ruM @n0nyM0U5lY";
$lang['allowfriendstoseemeasonline'] = "br0wSE 4N0NymOuslY, but 4lloW frIENDs +0 \$E3 Me 4s OnlIne";
$lang['revealspoileronmouseover'] = "rEVe4l 5po1ler\$ 0n moU\$E ov3r";
$lang['resizeimagesandreflowpage'] = "r351Ze im4ge5 4nd RePhlOW p@GE to PR3VeNT hORizOnT4L \$CrollIng.";
$lang['showforumstats'] = "shOW f0RuM StatS 4+ Bo++om 0Ph mEs5493 P4ne";
$lang['usewordfilter'] = "en4bl3 w0rD pHil+eR.";
$lang['forceadminwordfilter'] = "foRcE USe 0f 4DMin WOrd Fil+Er 0N @ll u\$er5 (1NC. 9ueS+\$)";
$lang['timezone'] = "tiMe zoN3";
$lang['language'] = "l4nGU@GE";
$lang['emailsettings'] = "eM4IL 4nd CoNT4c+ 5Ett1N9\$";
$lang['forumanonymity'] = "f0RUm 4n0NYmI+Y \$ettIn9s";
$lang['birthdayanddateofbirth'] = "b1R+hD4y @nD d4+3 0ph 81r+h D1sPlAy";
$lang['includeadminfilter'] = "iNCludE 4Dm1n w0rd pHILTer in my l1S+.";
$lang['setforallforums'] = "s3+ fOR 4ll PH0rum5?";
$lang['containsinvalidchars'] = "coN+4Ined 1Nv4L1d ch@r4cTers!";
$lang['homepageurlmustincludeschema'] = "h0meP@gE uRL mu\$T 1NClud3 h++p:// \$CH3M4.";
$lang['pictureurlmustincludeschema'] = "pIctuRe urL mU\$T INclUd3 H++p:// 5cH3M@.";
$lang['avatarurlmustincludeschema'] = "aV4+4R uRL muSt iNcluD3 H+Tp:// \$cHEm@.";
$lang['postpage'] = "p05+ P493";
$lang['nohtmltoolbar'] = "no h+ml +O0lb@R";
$lang['displaysimpletoolbar'] = "dI5Pl4y simpLE htmL tO0lB4r";
$lang['displaytinymcetoolbar'] = "disPl4Y WYSIwYG HTML +Ool8@r";
$lang['displayemoticonspanel'] = "dispL4y Emo+ic0n5 p@nel";
$lang['displaysignature'] = "di\$PL4y S1gn4+Ure";
$lang['disableemoticonsinpostsbydefault'] = "diS48l3 emOTICon\$ in M3ssa9eS by dePh4ul+";
$lang['automaticallyparseurlsbydefault'] = "aUT0M4tIC4llY p4r5e Url5 in Me5S4g3s by dePh4uL+";
$lang['postinplaintextbydefault'] = "p0\$T 1n Pl41N tEX+ 8y Def4Ul+";
$lang['postinhtmlwithautolinebreaksbydefault'] = "pO\$t in h+mL w1TH 4u+0-linE-8r34K5 by d3f@Ul+";
$lang['postinhtmlbydefault'] = "p0ST in h+mL 8Y d3ph@ult";
$lang['privatemessageoptions'] = "pR1v4+e m3SS4Ge Op+1ON5";
$lang['privatemessageexportoptions'] = "pr1v4+E meS54Ge 3Xp0rt 0p+10n\$";
$lang['savepminsentitems'] = "s4VE @ c0Py 0ph 34Ch Pm i \$3nd iN mY \$ent i+eMS ph0lder";
$lang['includepminreply'] = "iNclud3 ME\$54GE b0Dy WheN R3PLYIng T0 PM";
$lang['autoprunemypmfoldersevery'] = "aU+o PRun3 My Pm PH0ldERS 3V3ry:";
$lang['friendsonly'] = "frIENDS 0nLY?";
$lang['globalstyles'] = "gLoB4l S+yl3\$";
$lang['forumstyles'] = "forUM 5TYleS";

// Polls (create_poll.php, poll_results.php) ---------------------------------------------

$lang['mustprovideanswergroups'] = "j00 MU\$T pR0vidE \$om3 @nSw3r 9roUP\$";
$lang['mustprovidepolltype'] = "j00 mus+ prOViDE 4 PoLl +ype";
$lang['mustprovidepollresultsdisplaytype'] = "j00 mUs+ pr0vid3 R3SUL+S d1\$PL4y +Ype";
$lang['mustprovidepollvotetype'] = "j00 Mu5t pR0v1dE 4 POll V0t3 TYp3";
$lang['mustprovidepollguestvotetype'] = "j00 muS+ \$pEC1Fy If Gu3\$tS \$hould B3 4LL0Wed To v0+E";
$lang['mustprovidepolloptiontype'] = "j00 MUs+ PrOV1de 4 PoLl Op+1On TYpE";
$lang['mustprovidepollchangevotetype'] = "j00 mu\$t PrOviDE A p0ll ChanGE vo+e tYPe";
$lang['pleaseselectfolder'] = "pL3453 \$ElEc+ 4 fOld3R";
$lang['mustspecifyvalues1and2'] = "j00 MU\$t Sp3c1Fy V@lue5 pH0r 4NsWerS 1 4nd 2";
$lang['tablepollmusthave2groups'] = "t48UL4r FORm@+ pOLlS muST h@ve Pr3C1sELy +w0 VOt1N9 9RoUp5";
$lang['nomultivotetabulars'] = "ta8UL4R f0Rm4+ p0lls c4nn0+ 8E MUlt1-vOt3";
$lang['nomultivotepublic'] = "publIC B@lLO+s c4nn0+ 8E MulT1-V0+3";
$lang['abletochangevote'] = "j00 wiLl 8e 48L3 TO cH@N9e yOur V0T3.";
$lang['abletovotemultiple'] = "j00 W1Ll bE @bl3 +0 V0+E mul+1pl3 t1m3s.";
$lang['notabletochangevote'] = "j00 will n0+ BE 48L3 +O ch4ng3 youR Vo+e.";
$lang['pollvotesrandom'] = "n0t3: PoLL V0+e5 4r3 r@Nd0Mly 93ner4ted ph0r PR3v1ew oNly.";
$lang['pollquestion'] = "p0LL Qu3St1on";
$lang['possibleanswers'] = "p0\$\$i8le an5WerS";
$lang['enterpollquestionexp'] = "en+Er +He 4NsWerS PH0r yOuR p0ll Qu3\$T1on.. 1F YOuR POlL IS @ &quot;y3\$/No&quot; qUESt10n, 51mpLY 3nt3R &quot;Y3\$&quot; F0R @nsW3R 1 4ND &quot;nO&quot; F0R aNsWeR 2.";
$lang['numberanswers'] = "no. 4NsWerS";
$lang['answerscontainHTML'] = "an\$WER5 cOnt41n HtmL (n0t incLudING 51GN4+ur3)";
$lang['optionsdisplay'] = "aN\$WEr5 DI\$pl4Y typE";
$lang['optionsdisplayexp'] = "h0w \$H0Uld TH3 @N5weRs b3 prE5EnteD?";
$lang['dropdown'] = "a5 dRoP-D0wn L1S+(s)";
$lang['radios'] = "a5 4 \$3r1Es oPH r4d10 8u++On5";
$lang['votechanging'] = "v0t3 Ch@N91ng";
$lang['votechangingexp'] = "c@n @ pErsON cH4N93 hi\$ or HEr vO+E?";
$lang['guestvoting'] = "gu3s+ vO+1ng";
$lang['guestvotingexp'] = "c4N gu3\$TS v0+e in thI\$ p0ll?";
$lang['allowmultiplevotes'] = "aLloW MUl+1pl3 Vo+Es";
$lang['pollresults'] = "p0ll re5ultS";
$lang['pollresultsexp'] = "hoW W0uLd J00 l1ke TO d1Spl@y +eh rEsULt\$ 0pH Y0ur p0ll?";
$lang['pollvotetype'] = "p0ll vO+in9 Type";
$lang['pollvotesexp'] = "h0W SH0uLD +eH pOll 83 c0nducT3d?";
$lang['pollvoteanon'] = "anONym0U\$Ly";
$lang['pollvotepub'] = "pUblIC 8@LLo+";
$lang['horizgraph'] = "hORiz0ntaL 9R4Ph";
$lang['vertgraph'] = "vERT1C@L Gr4pH";
$lang['tablegraph'] = "t@8UL4r ph0rM@t";
$lang['polltypewarning'] = "<b>w@rnInG</b>: th1\$ 1s 4 publ1c 84lL0+. yOur n@M3 w1ll be V1S18LE NeX+ TO +he oPt1On J00 VOT3 PHoR.";
$lang['expiration'] = "eXpiR4+i0n";
$lang['showresultswhileopen'] = "d0 J00 w4n+ +O \$H0W R3\$uLT\$ WH1l3 +3H polL i\$ oPEN?";
$lang['whenlikepollclose'] = "wh3N woULd j00 l1ke yoUr P0Ll +0 4U+0m@+ICalLY clO5e?";
$lang['oneday'] = "oNe d4Y";
$lang['threedays'] = "tHR33 D@Ys";
$lang['sevendays'] = "sEVen d4y5";
$lang['thirtydays'] = "thiR+Y d4yS";
$lang['never'] = "nEVEr";
$lang['polladditionalmessage'] = "aDDit10n@L Me5s49E (oPti0N4l)";
$lang['polladditionalmessageexp'] = "d0 j00 W4nt to iNcLud3 4n 4ddi+i0N4l pOs+ 4f+ER +HE p0ll?";
$lang['mustspecifypolltoview'] = "j00 mu\$t \$pecIFy 4 POll +O v13w.";
$lang['pollconfirmclose'] = "are j00 sur3 j00 w4NT +0 clO\$E th3 PH0llOW1n9 Poll?";
$lang['endpoll'] = "eND P0Ll";
$lang['nobodyvotedclosedpoll'] = "n08oDy v0+3D";
$lang['votedisplayopenpoll'] = "%s @nd %s h@vE V0ted.";
$lang['votedisplayclosedpoll'] = "%s @nd %s v0+3D.";
$lang['nousersvoted'] = "n0 u\$3r\$";
$lang['oneuservoted'] = "1 U\$er";
$lang['xusersvoted'] = "%s US3Rs";
$lang['noguestsvoted'] = "n0 9uE\$+S";
$lang['oneguestvoted'] = "1 9UESt";
$lang['xguestsvoted'] = "%s 9U3\$T\$";
$lang['pollhasended'] = "p0LL h@5 3Nd3d";
$lang['youvotedforpolloptionsondate'] = "j00 V0TeD FOr %s on %s";
$lang['thisisapoll'] = "th15 iS 4 p0ll. clIcK +0 vieW RE5UltS.";
$lang['editpoll'] = "eDit pOLl";
$lang['results'] = "reSUlTs";
$lang['resultdetails'] = "r3\$ULT D3t41l5";
$lang['changevote'] = "ch4nGe vO+e";
$lang['pollshavebeendisabled'] = "p0LLS h4v3 8e3n dI\$4bLED bY tH3 ph0rum 0WnEr.";
$lang['answertext'] = "aNSwEr teX+";
$lang['answergroup'] = "aN5w3R 9R0uP";
$lang['previewvotingform'] = "prEv1EW v0T1ng f0rM";
$lang['viewbypolloption'] = "vI3W 8y POLl 0PtIoN";
$lang['viewbyuser'] = "v13W By U5ER";

// Profiles (profile.php) ----------------------------------------------

$lang['editprofile'] = "eDI+ pROPh1le";
$lang['profileupdated'] = "pR0PHIle Updat3D.";
$lang['profilesnotsetup'] = "teh PHOruM 0WneR h4S No+ 53T Up pRoPhIl3\$.";
$lang['ignoreduser'] = "iGn0R3d U53r";
$lang['lastvisit'] = "l@S+ vI51+";
$lang['userslocaltime'] = "u\$ER'S Loc@L +iM3";
$lang['userstatus'] = "st4+U\$";
$lang['useractive'] = "onLInE";
$lang['userinactive'] = "in4c+ive / OPhphLinE";
$lang['totaltimeinforum'] = "toT4l tIm3";
$lang['longesttimeinforum'] = "l0N93ST \$ES5iON";
$lang['sendemail'] = "s3Nd EM@il";
$lang['sendpm'] = "sEnd PM";
$lang['visithomepage'] = "v1s1+ h0m3p4gE";
$lang['age'] = "a9E";
$lang['aged'] = "a9Ed";
$lang['birthday'] = "b1r+hDaY";
$lang['registered'] = "re91St3r3D";
$lang['findpostsmadebyuser'] = "fiND P05t\$ m4de By %s";
$lang['findpostsmadebyme'] = "f1ND P0\$+S m4D3 by M3";
$lang['profilenotavailable'] = "pROF1lE n0+ 4V@il@8L3.";
$lang['userprofileempty'] = "thI5 U5Er H4s N0t pHill3d in +h3iR prOfILe 0r 1+ 15 Set tO PR1v4T3.";

// Registration (register.php) -----------------------------------------

$lang['newuserregistrationsarenotpermitted'] = "sORrY, n3W U\$Er rE9i5TR4+i0ns 4RE n0+ 4llOwed right NOw. Ple@5e cHeck B4ck L4+er.";
$lang['usernameinvalidchars'] = "uS3RN4m3 c4N ONly CONT41n @-z, 0-9, _ - Ch4R@c+3r\$";
$lang['usernametooshort'] = "usERn4me musT Be @ Min1Mum 0Ph 2 CH4r@c+ER5 l0n9";
$lang['usernametoolong'] = "u\$ern@M3 MUS+ 83 @ M@x1mum 0F 15 ch@r4c+ERs l0NG";
$lang['usernamerequired'] = "a L0gOn n@ME is r3qUir3d";
$lang['passwdmustnotcontainHTML'] = "p@5\$WORd MU5t nO+ C0n+4in HtMl T4G5";
$lang['passwordinvalidchars'] = "p@5SwOrd c@N 0NLy c0n+@in @-z, 0-9, _ - Ch4rACTerS";
$lang['passwdtooshort'] = "p@s\$w0Rd MuST 8e 4 miNimum 0f 6 Ch4RACt3r5 LOn9";
$lang['passwdrequired'] = "a p45sWORd 15 REqU1RED";
$lang['confirmationpasswdrequired'] = "a c0NfIrm4+i0n P@s\$WorD is reQu1r3D";
$lang['nicknamerequired'] = "a NICKN4mE 15 R3Qu1R3d";
$lang['emailrequired'] = "an 3m4il ADdr3\$s IS REqUir3d";
$lang['passwdsdonotmatch'] = "p4sSW0rDs Do n0T M4+Ch";
$lang['usernamesameaspasswd'] = "uS3Rn4Me 4nd P4s5wOrd MU5T b3 d1phPHerEnt";
$lang['usernameexists'] = "soRRY, 4 uSEr Wi+H th4T n4m3 @LR3ady 3xiStS";
$lang['successfullycreateduseraccount'] = "suCcE5\$fULlY cr3AT3d u\$3R 4ccOuN+";
$lang['useraccountcreatedconfirmfailed'] = "youR UsEr 4CcOuNT h4S b33n Cr34TeD BUT T3H reQU1rED c0Nf1rm4+1ON EM41l WA\$ n0+ seN+. pLe@Se cONT4CT +hE pH0RUm 0wNeR +O rECtIPhY +H1s. 1N +h1s me4nTIM3 pLe@5E ClIcK +he cONTiNU3 BU++oN +0 l09IN iN.";
$lang['useraccountcreatedconfirmsuccess'] = "yOUr usER 4cC0Un+ h@5 83en cR34+ed 8ut b3ph0rE j00 c4N s+4r+ P05t1n9 J00 MuSt conF1Rm Y0Ur 3m41l @ddrEsS. ple4\$e Ch3CK y0uR 3m41l FOR @ linK +h4+ wiLl 4LlOw J00 +0 coNf1rm y0ur 4ddrES5.";
$lang['useraccountcreated'] = "y0UR u53r 4cc0UN+ h4\$ b3En cR34+ed 5UCCeS5FuLlY! Cl1ck tH3 c0NTinUe 8u++0n 83Low +O LOgIn";
$lang['errorcreatinguserrecord'] = "eRROr Cr34T1N9 U5Er R3C0Rd";
$lang['userregistration'] = "us3R Re91StrAT10n";
$lang['registrationinformationrequired'] = "r39I\$tr4+10n INpHorM@+10n (r3quIred)";
$lang['profileinformationoptional'] = "pr0pHILe 1NphOrm@+1On (op+i0nal)";
$lang['preferencesoptional'] = "pREFeRencE5 (OP+i0n@l)";
$lang['register'] = "rE9i\$teR";
$lang['rememberpasswd'] = "r3M3Mber pa\$swOrd";
$lang['birthdayrequired'] = "yOUr d4+3 0Ph 81rth 1\$ reQU1rEd 0r Is INVaL1d";
$lang['alwaysnotifymeofrepliestome'] = "nOTIfY on R3pLY To me";
$lang['notifyonnewprivatemessage'] = "noT1Fy On new pR1v4+E me\$S4gE";
$lang['popuponnewprivatemessage'] = "pop Up 0n new pr1V4t3 M3\$\$49E";
$lang['automatichighinterestonpost'] = "aUtom@t1C H1Gh 1NT3re\$+ oN P0\$T";
$lang['confirmpassword'] = "c0NPh1rM p4SSwOrD";
$lang['invalidemailaddressformat'] = "iNV4l1D Em4il 4DdR3ss ForMat";
$lang['moreoptionsavailable'] = "mOR3 PROF1l3 @nd Pr3ph3r3NCE OP+iOn\$ 4RE 4v@1L@8l3 0NC3 J00 r39ist3r";
$lang['textcaptchaconfirmation'] = "c0nFIrM@+10N";
$lang['textcaptchaexplain'] = "tO +he RI9hT 1s 4 +3X+-C@ptcH@ iM4g3. pLe4\$E +YP3 t3h cOD3 j00 c@N SE3 1N T3H 1m4Ge In+o +He InPu+ f1ELD b3LOW 1T.";
$lang['textcaptchaimgtip'] = "thIs 1s a cap+cH4-pic+ure. i+ 1\$ uSeD +0 PR3V3n+ 4U+0m@+1c r391STR4+10n";
$lang['textcaptchamissingkey'] = "a cONF1RM@t10n cOd3 1S r3Qu1red.";
$lang['textcaptchaverificationfailed'] = "t3xT-C@ptcH@ VeR1Ph1c4+iON CODE w4s iNc0Rr3c+. pl34Se re-En+ER 1+.";
$lang['forumrules'] = "f0rUm ruL3\$";
$lang['forumrulesnotification'] = "iN 0RdER TO Proc33D, J00 mUsT 4gRe3 wI+h +He FoLl0W1n9 Rule\$";
$lang['forumrulescheckbox'] = "i H4ve re4D, 4ND a9Ree +0 @8idE 8y +he FOrUm ruLeS.";
$lang['youmustagreetotheforumrules'] = "j00 mU\$t 4gre3 +O +He F0Rum Rul3S BeFoR3 J00 cAN c0N+inUe.";

// Recent visitors list  (visitor_log.php) -----------------------------

$lang['member'] = "m3m83r";
$lang['searchforusernotinlist'] = "se4RCh f0r 4 U5ER N0+ 1n L15t";
$lang['yoursearchdidnotreturnanymatches'] = "y0UR SE4rch d1D n0+ Re+URn 4Ny M4+Ch3\$. +ry 5imPl1fY1nG Y0uR S34Rch P4r4Me+ErS @nD Try @g4In.";
$lang['hiderowswithemptyornullvalues'] = "h1de rOWS W1tH 3mp+Y 0R NulL V4Lu3S in SeL3cT3D cOlUmNS";
$lang['showregisteredusersonly'] = "shoW R391ST3reD u\$3R\$ 0NlY (HiDe 9ueST5)";

// Relationships (user_rel.php) ----------------------------------------

$lang['relationships'] = "rel4+iOn5H1pS";
$lang['userrelationship'] = "uS3R r3la+10NSh1P";
$lang['userrelationships'] = "u53r rEl4T1on\$H1P5";
$lang['failedtoremoveselectedrelationships'] = "f4il3D To R3M0Ve SeL3c+ED r3l4t1OnSh1p";
$lang['friends'] = "fRi3nd5";
$lang['ignoredcompletely'] = "i9N0Red coMpl3+3ly";
$lang['relationship'] = "rEl4+1oN5h1p";
$lang['restorenickname'] = "reST0re u53R'5 nIckn@me";
$lang['friend_exp'] = "uSer'S PO5Ts mArkEd wi+H 4 &quot;FrIEnd&quot; 1c0N.";
$lang['normal_exp'] = "u53r'S p0\$ts 4pP3@R 4S NoRM4l.";
$lang['ignore_exp'] = "uSeR'S pO5T\$ 4rE h1Dd3n.";
$lang['ignore_completely_exp'] = "thr34DS 4nd P0\$TS +O 0r phr0M useR w1ll 4pp34R d3l3+ED.";
$lang['display'] = "d1Spl@y";
$lang['displaysig_exp'] = "u\$3r'S \$1Gn4+URe 15 Di5pl@y3d On th3Ir Po\$+S.";
$lang['hidesig_exp'] = "u53R's \$1gn4+ur3 1\$ HIDDen on th31r p0\$+S.";
$lang['cannotignoremod'] = "j00 c4Nn0+ iGNoR3 THi\$ uSer, 45 +HEy 4r3 4 m0dEr4t0r.";
$lang['previewsignature'] = "pREVIeW \$iGN4TuRe";

// Search (search.php) -------------------------------------------------

$lang['searchresults'] = "s34RCh RESuLtS";
$lang['usernamenotfound'] = "th3 uSERN4Me j00 sp3c1F1Ed In +eh to 0R fR0M fI3lD w@s n0+ F0UnD.";
$lang['notexttosearchfor'] = "on3 0r 4Ll 0f y0Ur se@rch KeyWORds WeR3 1nv4l1d. \$E4rcH K3yW0rD5 mU\$t 8E NO \$HoRt3r Th@n %d ch4r4C+eR\$, N0 L0nG3R +h4n %d cH4r4ct3R\$ 4nD Mu\$t n0+ 4PpE4R 1n +eH %s";
$lang['keywordscontainingerrors'] = "kEyW0rD5 cOnT4iNIn9 3rrOR\$";
$lang['mysqlstopwordlist'] = "mYSqL \$tOpWORD lis+";
$lang['foundzeromatches'] = "f0und: 0 m4+CheS";
$lang['found'] = "f0UNd";
$lang['matches'] = "m4tCH3S";
$lang['prevpage'] = "pR3vIoU5 p@ge";
$lang['findmore'] = "fIND mOr3";
$lang['searchmessages'] = "s34rCH me\$S4G3\$";
$lang['searchdiscussions'] = "s34RCh d15cu55iON\$";
$lang['find'] = "f1nd";
$lang['additionalcriteria'] = "adDiTi0N4l cRitErIa";
$lang['searchbyuser'] = "s34RcH bY u\$eR (op+10N@l)";
$lang['folderbrackets_s'] = "f0LDer(\$)";
$lang['postedfrom'] = "poST3d PhrOM";
$lang['postedto'] = "p0\$t3D t0";
$lang['today'] = "t0d@y";
$lang['yesterday'] = "y3St3Rd4y";
$lang['daybeforeyesterday'] = "d4Y BEf0RE y3Sterd@Y";
$lang['weekago'] = "%s w33K 49o";
$lang['weeksago'] = "%s w33K\$ 4g0";
$lang['monthago'] = "%s mON+h 4g0";
$lang['monthsago'] = "%s MONthS 4G0";
$lang['yearago'] = "%s yE4r 4G0";
$lang['beginningoftime'] = "b3G1nn1n9 0PH +ImE";
$lang['now'] = "noW";
$lang['lastpostdate'] = "l4\$t p05t d4+E";
$lang['numberofreplies'] = "nuMb3r OF r3pLieS";
$lang['foldername'] = "f0ld3R n4me";
$lang['authorname'] = "aU+H0r n4me";
$lang['decendingorder'] = "n3wE5+ F1r5t";
$lang['ascendingorder'] = "olde\$+ pH1r5T";
$lang['keywords'] = "kEYwoRDs";
$lang['sortby'] = "s0R+ By";
$lang['sortdir'] = "sORT dir";
$lang['sortresults'] = "sOrt Re5Ul+\$";
$lang['groupbythread'] = "gRouP 8Y +hr34d";
$lang['postsfromuser'] = "poST\$ frOm U53r";
$lang['poststouser'] = "p0\$TS to U\$3R";
$lang['poststoandfromuser'] = "p05T\$ To 4Nd PHR0M U\$ER";
$lang['searchfrequencyerror'] = "j00 C4n 0Nly S3@rch once 3v3ry %s Sec0Nd5. pLe@5E trY 4G41n l4+Er.";

// Search Popup (search_popup.php) -------------------------------------

$lang['select'] = "sel3C+";
$lang['searchforthread'] = "s34RcH F0R tHRe4d";
$lang['mustspecifytypeofsearch'] = "j00 mUS+ 5PECifY +YPe 0F 534rch +o p3rpH0Rm";
$lang['unkownsearchtypespecified'] = "unKNoWN S3@rch TYp3 spEc1f13d";

// Start page (start_left.php) -----------------------------------------

$lang['recentthreads'] = "rECeN+ +hre@D\$";
$lang['startreading'] = "sT4Rt RE4diNG";
$lang['threadoptions'] = "thre@D 0p+i0n5";
$lang['editthreadoptions'] = "eD1t THr34D Op+I0n5";
$lang['morevisitors'] = "m0r3 VISI+0r5";
$lang['forthcomingbirthdays'] = "fOrthcOm1N9 b1r+hd4Ys";

// Start page (start_main.php) -----------------------------------------

$lang['editstartpage_help'] = "j00 c4N 3D1t th1S p@GE phrOm +H3 4dM1n in+erF4c3";
$lang['uploadstartpage'] = "uPl0@D 5T4r+ p4GE (%s)";
$lang['invalidfiletypeerror'] = "f1L3 Typ3 NO+ supPOr+ed. j00 c4N ONLY u\$e %s pHileS 4s Y0uR 5t4r+ P4G3.";

// Thread navigation (thread_list.php) ---------------------------------

$lang['newdiscussion'] = "n3W DI\$Cu\$SI0N";
$lang['createpoll'] = "cR34+3 PolL";
$lang['search'] = "s34rCh";
$lang['searchagain'] = "sE@rch @94iN";
$lang['alldiscussions'] = "alL di5Cu\$sI0nS";
$lang['unreaddiscussions'] = "unR3Ad d15cu55i0n5";
$lang['unreadtome'] = "uNr34d &quot;+o: mE&quot;";
$lang['todaysdiscussions'] = "t0D@y'S di\$cuSsi0ns";
$lang['2daysback'] = "2 DaYs B4ck";
$lang['7daysback'] = "7 D4yS 84ck";
$lang['highinterest'] = "hi9H in+3res+";
$lang['unreadhighinterest'] = "uNr3@d HigH 1N+eRe\$t";
$lang['iverecentlyseen'] = "i'v3 R3c3NtlY S33n";
$lang['iveignored'] = "i've 19nORed";
$lang['byignoredusers'] = "bY 1gn0R3d U\$ERs";
$lang['ivesubscribedto'] = "i'V3 \$ubSCRi8ED +0";
$lang['startedbyfriend'] = "s+@RteD by pHr13nd";
$lang['unreadstartedbyfriend'] = "uNRE4d STd BY PHri3nd";
$lang['startedbyme'] = "sT@R+eD By m3";
$lang['unreadtoday'] = "unrE@D +0d@Y";
$lang['deletedthreads'] = "dELeTeD tHr34D\$";
$lang['goexcmark'] = "g0!";
$lang['folderinterest'] = "foLDeR 1n+3R3\$T";
$lang['postnew'] = "p0\$T n3w";
$lang['currentthread'] = "cUrreN+ Thr3@d";
$lang['highinterest'] = "hiGh in+3r3St";
$lang['markasread'] = "m4RK @S rE4d";
$lang['next50discussions'] = "nExt 50 d1ScU5\$10n\$";
$lang['visiblediscussions'] = "vISIbLe D15cu\$SI0N\$";
$lang['selectedfolder'] = "s3L3C+Ed pH0LD3R";
$lang['navigate'] = "n4V1G4t3";
$lang['couldnotretrievefolderinformation'] = "ther3 Ar3 nO PH0ld3Rs 4V@1l@8Le.";
$lang['nomessagesinthiscategory'] = "n0 M3s54Ges 1n +h1S C4+390ry. pl34\$e S3lecT an0TH3r, 0r";
$lang['clickhere'] = "cl1cK hERE";
$lang['forallthreads'] = "for 4ll THR34dS";
$lang['prev50threads'] = "pR3V10u\$ 50 +hrE4dS";
$lang['next50threads'] = "nex+ 50 THre4Ds";
$lang['nextxthreads'] = "n3XT %s +Hr34d\$";
$lang['threadstartedbytooltip'] = "tHr3@D #%s 5t@R+3D by %s. VIewEd %s";
$lang['threadviewedonetime'] = "1 tImE";
$lang['threadviewedtimes'] = "%d TImeS";
$lang['unreadthread'] = "unr3@D thRE4d";
$lang['readthread'] = "re4D tHR3ad";
$lang['unreadmessages'] = "uNrE4D ME\$54g3s";
$lang['subscribed'] = "subscR183D";
$lang['ignorethisfolder'] = "igNoRE +H15 phOldEr";
$lang['stopignoringthisfolder'] = "sTop igNoR1N9 THi5 F0ld3r";
$lang['stickythreads'] = "s+ICky thr34d5";
$lang['mostunreadposts'] = "mos+ unread P0St5";
$lang['onenew'] = "%d New";
$lang['manynew'] = "%d N3w";
$lang['onenewoflength'] = "%d neW 0f %d";
$lang['manynewoflength'] = "%d n3w OF %d";
$lang['ignorefolderconfirm'] = "aR3 j00 Sur3 j00 W4N+ T0 ignoRe th15 pHold3R?";
$lang['unignorefolderconfirm'] = "aRe J00 5urE J00 W4Nt +0 5tOp 19nOR1nG +HiS F0Ld3R?";
$lang['gotofirstpostinthread'] = "gO tO PHirS+ pOs+ 1n +hR34d";
$lang['gotolastpostinthread'] = "gO tO l@s+ p0St 1n Thr34d";
$lang['viewmessagesinthisfolderonly'] = "v1Ew mes54geS In +hiS F0ld3R OnlY";
$lang['shownext50threads'] = "sH0W N3XT 50 ThrE@dS";
$lang['showprev50threads'] = "sH0W pR3vI0U\$ 50 tHr34d\$";
$lang['createnewdiscussioninthisfolder'] = "cRe4+e NeW d1scUs510n In +h15 Ph0ld3r";

// HTML toolbar (htmltools.inc.php) ------------------------------------
$lang['bold'] = "b0LD";
$lang['italic'] = "iT4L1c";
$lang['underline'] = "uNdERLin3";
$lang['strikethrough'] = "s+r1keThROu9h";
$lang['superscript'] = "suP3RScr1Pt";
$lang['subscript'] = "su8scripT";
$lang['leftalign'] = "l3PH+-4L1Gn";
$lang['center'] = "ceNT3r";
$lang['rightalign'] = "ri9HT-aLIgn";
$lang['numberedlist'] = "nUmb3red L15t";
$lang['list'] = "l15T";
$lang['indenttext'] = "inDENt +eXT";
$lang['code'] = "c0d3";
$lang['quote'] = "qU0T3";
$lang['spoiler'] = "sp0ilER";
$lang['horizontalrule'] = "hoR1ZoN+4L ruL3";
$lang['image'] = "im49E";
$lang['hyperlink'] = "hYP3rl1Nk";
$lang['noemoticons'] = "d1s4bLe EMO+1C0N\$";
$lang['fontface'] = "f0nt pH@c3";
$lang['size'] = "sIZE";
$lang['colour'] = "c0lOur";
$lang['red'] = "rED";
$lang['orange'] = "oRAngE";
$lang['yellow'] = "yeLl0w";
$lang['green'] = "gr3En";
$lang['blue'] = "bLuE";
$lang['indigo'] = "iNd1GO";
$lang['violet'] = "vI0L3t";
$lang['white'] = "wh1T3";
$lang['black'] = "blaCk";
$lang['grey'] = "gr3Y";
$lang['pink'] = "p1nk";
$lang['lightgreen'] = "liGHt 9Re3n";
$lang['lightblue'] = "lIght 8luE";

// Forum Stats (messages.inc.php - messages_forum_stats()) -------------

$lang['forumstats'] = "forUM 5t4+s";
$lang['usersactiveinthepasttimeperiod'] = "%s acTiVe 1N tH3 p4ST %s.";

$lang['numactiveguests'] = "<b>%s</b> GUeSTs";
$lang['oneactiveguest'] = "<b>1</b> GuES+";
$lang['numactivemembers'] = "<b>%s</b> memb3r\$";
$lang['oneactivemember'] = "<b>1</b> MEm83R";
$lang['numactiveanonymousmembers'] = "<b>%s</b> 4NONyMOu5 M3M83Rs";
$lang['oneactiveanonymousmember'] = "<b>1</b> @N0NyMous M3mbEr";

$lang['numthreadscreated'] = "<b>%s</b> +hr34ds";
$lang['onethreadcreated'] = "<b>1</b> +hr34d";
$lang['numpostscreated'] = "<b>%s</b> POs+5";
$lang['onepostcreated'] = "<b>1</b> pO5t";

$lang['younormal'] = "j00";
$lang['youinvisible'] = "j00 (inViSI8l3)";
$lang['viewcompletelist'] = "vIEW c0MplE+e L1St";
$lang['ourmembershavemadeatotalofnumthreadsandnumposts'] = "ouR m3m8eR\$ h4V3 M@de 4 t0+@L 0Ph %s 4nD %s.";
$lang['longestthreadisthreadnamewithnumposts'] = "lon935T ThR34d i\$ <b>%s</b> WI+h %s.";
$lang['therehavebeenxpostsmadeinthelastsixtyminutes'] = "thER3 h4v3 833N <b>%s</b> POS+\$ M4D3 IN +eh l4ST 60 miNut3S.";
$lang['therehasbeenonepostmadeinthelastsxityminutes'] = "thEre h4s 8E3n <b>1</b> p0\$t MAd3 IN +3h L4\$t 60 mInuT3\$.";
$lang['mostpostsevermadeinasinglesixtyminuteperiodwasnumposts'] = "mOsT po5Ts eV3r M4dE 1N 4 51ngLe 60 MinU+3 pER10d 15 <b>%s</b> 0N %s.";
$lang['wehavenumregisteredmembersandthenewestmemberismembername'] = "w3 H4Ve <b>%s</b> r3G1S+3R3d M3m83RS 4ND +He NeWeSt MEMB3r i5 <b>%s</b>.";
$lang['wehavenumregisteredmember'] = "wE HaV3 %s r3915tER3D mEmbER5.";
$lang['wehaveoneregisteredmember'] = "w3 H@V3 0ne Regi5T3R3d m3MBeR.";
$lang['mostuserseveronlinewasnumondate'] = "m0ST UsER5 3v3R OnLinE W@5 <b>%s</b> ON %s.";
$lang['statsdisplayenabled'] = "s+4+s DIsPL4y 3n48Led";

// Thread Options (thread_options.php) ---------------------------------

$lang['updatesmade'] = "upd4+e\$ M4d3";
$lang['useroptions'] = "u\$eR OPT1oNS";
$lang['markedasread'] = "m4rK3d 4S r3@D";
$lang['postsoutof'] = "p0\$+5 ou+ 0pH";
$lang['interest'] = "intER35+";
$lang['closedforposting'] = "cl0s3d phoR PO\$+iN9";
$lang['locktitleandfolder'] = "lOCK t1+l3 @ND F0Ld3R";
$lang['deletepostsinthreadbyuser'] = "deLEte p05+\$ In +Hr34D 8Y user";
$lang['deletethread'] = "delETe THR34d";
$lang['permenantlydelete'] = "pErMEn@N+lY DeL3TE";
$lang['movetodeleteditems'] = "m0VE To deleTed +hr34d\$";
$lang['undeletethread'] = "uNdelE+3 tHRead";
$lang['threaddeletedpermenantly'] = "tHr34D d3L3t3D PeRm@N3NtLY. C@nNot unDeLE+3.";
$lang['markasunread'] = "m4RK 4S unr34D";
$lang['makethreadsticky'] = "m@k3 +Hre4d 5T1cky";
$lang['threareadstatusupdated'] = "thRE4d R3@D 5t@+Us upd4+ED SucC3S\$fuLlY";
$lang['interestupdated'] = "tHR3@d Int3ReSt 5t4+Us uPD@+3d \$Ucc3\$SfuLlY";

// Dictionary (dictionary.php) -----------------------------------------

$lang['dictionary'] = "d1cTI0N@ry";
$lang['spellcheck'] = "sp3ll cHecK";
$lang['notindictionary'] = "n0+ in DICt10N@ry";
$lang['changeto'] = "cH4ng3 T0";
$lang['restartspellcheck'] = "re\$+4r+";
$lang['cancelchanges'] = "cANC3l ch@n93\$";
$lang['initialisingdotdotdot'] = "in1+14LI\$1ng...";
$lang['spellcheckcomplete'] = "speLL cheCK 1\$ c0mpLET3. +O Re\$+@rT \$peLl cHecK CLicK RE\$t@rt buT+On b3L0W.";
$lang['spellcheck'] = "spELL cHeck";
$lang['noformobj'] = "no fOrM obJ3ct \$pec1F13d F0R RE+UrN TEXT";
$lang['bodytext'] = "bOdy T3xT";
$lang['ignore'] = "i9NOr3";
$lang['ignoreall'] = "iGn0re 4Ll";
$lang['change'] = "cH4N9e";
$lang['changeall'] = "ch4NgE 4ll";
$lang['add'] = "aDD";
$lang['suggest'] = "su9gest";
$lang['nosuggestions'] = "(N0 \$UG9esT10nS)";
$lang['cancel'] = "c@ncEL";
$lang['dictionarynotinstalled'] = "n0 d1c+10N4RY h4\$ b33n 1ns+4lleD. pL34\$E cONt4cT t3h PHorum OWnER +0 rEm3dY +Hi5.";

// Permissions keys ----------------------------------------------------

$lang['postreadingallowed'] = "pos+ r3ADiNg 4llow3D";
$lang['postcreationallowed'] = "p0ST cr3@+i0N 4LlOwed";
$lang['threadcreationallowed'] = "thr3Ad Cre4+10N @lLowEd";
$lang['posteditingallowed'] = "po\$+ ed1+iN9 aLLoWed";
$lang['postdeletionallowed'] = "p0\$t d3L3ti0N 4llOw3D";
$lang['attachmentsallowed'] = "a++@CHmeN+s @lLoW3d";
$lang['htmlpostingallowed'] = "h+ML po\$+in9 4Ll0w3D";
$lang['signatureallowed'] = "s19N4+urE 4Ll0wed";
$lang['guestaccessallowed'] = "gUE\$T @ccE55 @lL0W3d";
$lang['postapprovalrequired'] = "p05+ 4ppRoV4L r3qUired";

// RSS feeds gubbins

$lang['rssfeed'] = "r\$S ph3ed";
$lang['every30mins'] = "every 30 Minu+E5";
$lang['onceanhour'] = "oNCe 4N hOuR";
$lang['every6hours'] = "eV3RY 6 h0uR\$";
$lang['every12hours'] = "ev3RY 12 h0urS";
$lang['onceaday'] = "onC3 @ d4Y";
$lang['rssfeeds'] = "r5s f3edS";
$lang['feedname'] = "f3eD N4M3";
$lang['feedfoldername'] = "fe3D Ph0Ld3R n4mE";
$lang['feedlocation'] = "f3eD LOc@T1ON";
$lang['threadtitleprefix'] = "tHRe4D tI+Le PREf1x";
$lang['feednameandlocation'] = "feeD N4me and Loc4t1On";
$lang['feedsettings'] = "feEd \$ETtIN9s";
$lang['updatefrequency'] = "upd@+e phReQUenCy";
$lang['rssclicktoreadarticle'] = "cl1ck her3 t0 r3ad TH1\$ 4rT1cle";
$lang['addnewfeed'] = "adD NEw PH33D";
$lang['editfeed'] = "eD1T pH33d";
$lang['feeduseraccount'] = "fE3d UsER 4CC0Un+";
$lang['noexistingfeeds'] = "nO eXi5t1Ng RS5 phe3DS pH0und. +0 @dD 4 PHe3d Ple45E cL1ck TH3 bu++0N b3LOw";
$lang['rssfeedhelp'] = "h3re J00 c@n 5EtuP Som3 R5\$ Fe3ds FoR 4U+0m4t1c PRoP4g4ti0n iN+0 Y0ur F0Rum. +HE 1tEmS PHrOM +he rs5 fEEdS J00 ADD Will b3 CR34TeD 4S THR3@dS wh1ch u\$Ers c@n r3PlY T0 4\$ ipH +hEY wERE n0rm4l P0\$Ts. th3 rSS fEed Mus+ B3 @ccEs5IblE vI4 H++P Or It wiLl N0+ WORk.";
$lang['mustspecifyrssfeedname'] = "mU\$t \$P3ciFy RS5 ph33d N4m3";
$lang['mustspecifyrssfeeduseraccount'] = "mU5+ Spec1FY R55 PhEED u53r Acc0uNt";
$lang['mustspecifyrssfeedfolder'] = "muS+ \$pec1Fy r5\$ ph33D Phold3r";
$lang['mustspecifyrssfeedurl'] = "mUS+ \$PEcIfY RS\$ f33D UrL";
$lang['mustspecifyrssfeedupdatefrequency'] = "mU5t SpEc1Fy r5S FE3d Upd@te fr3Qu3ncY";
$lang['unknownrssuseraccount'] = "unKNOwn RS\$ User @ccounT";
$lang['rssfeedsupportshttpurlsonly'] = "r55 F3ed SUpPOR+\$ ht+P urL\$ 0nlY. \$3cUre PH33D5 (hTTp\$://) 4re No+ \$upp0R+ed.";
$lang['rssfeedurlformatinvalid'] = "r5S ph33d url f0Rm@+ iS 1Nv4lid. url musT iNClud3 \$cHEm3 (3.9. Ht+p://) 4Nd a H0sTN4mE (e.g. WwW.HO\$tn4m3.cOM).";
$lang['rssfeeduserauthentication'] = "rS5 pH33D dO3S NoT 5UpP0rT H+tp u\$er 4UTh3nt1c@t10n";
$lang['successfullyremovedselectedfeeds'] = "sUCCe55FuLLy Rem0v3d \$el3CT3D pH33dS";
$lang['successfullyaddedfeed'] = "succE\$5FuLly @dded N3W FEed";
$lang['successfullyeditedfeed'] = "sUcc35\$fully editED ph33d";
$lang['failedtoremovefeeds'] = "fAiLed +0 rEMov3 SoM3 oR @lL 0Ph +Eh 5EL3CT3d F33D\$";
$lang['failedtoaddnewrssfeed'] = "f4ilEd to @dd New r5s f3ed";
$lang['failedtoupdaterssfeed'] = "f4iled TO upd@T3 r\$\$ ph3Ed";
$lang['rssstreamworkingcorrectly'] = "rS\$ \$TrE@m 4PP34R5 +0 83 wORKIng corREctLy";
$lang['rssstreamnotworkingcorrectly'] = "rs5 \$+rE4M W45 eMp+y 0r COuLd N0+ 83 PhoUnd";
$lang['invalidfeedidorfeednotfound'] = "inV4liD fEEd iD 0R pHeed no+ fOUnd";

// PM Export Options

$lang['pmexportastype'] = "eXpor+ 45 tYp3";
$lang['pmexporthtml'] = "h+ML";
$lang['pmexportxml'] = "xML";
$lang['pmexportplaintext'] = "pL@1n T3XT";
$lang['pmexportmessagesas'] = "expoRt m3\$54ge5 45";
$lang['pmexportonefileforallmessages'] = "oN3 f1l3 PhOR @ll mE5S@ge\$";
$lang['pmexportonefilepermessage'] = "oNE phiL3 p3R meS54g3";
$lang['pmexportattachments'] = "eXPOr+ @tT4chmeNtS";
$lang['pmexportincludestyle'] = "inCLudE PhOrum STyL3 Sh33T";
$lang['pmexportwordfilter'] = "aPply W0Rd pHilT3r +O m3s\$4G3s";

// Thread merge / split options

$lang['threadhasbeensplit'] = "thr34D H45 b3en \$plIt";
$lang['threadhasbeenmerged'] = "tHre4D h45 beeN MEr9ed";
$lang['mergesplitthread'] = "mERG3 / sPl1+ thrE@D";
$lang['mergewiththreadid'] = "m3rGe w1+H +Hr34D 1d:";
$lang['postsinthisthreadatstart'] = "p0\$ts 1n th1s tHre4D AT 5t4R+";
$lang['postsinthisthreadatend'] = "p05T\$ in +Hi\$ Thr34d @+ End";
$lang['reorderpostsintodateorder'] = "rE-oRd3r Pos+\$ In+0 D4T3 0RD3r";
$lang['splitthreadatpost'] = "sPl1t thre@D 4+ pOs+:";
$lang['selectedpostsandrepliesonly'] = "seLect3D p0\$T @nd r3plieS 0nly";
$lang['selectedandallfollowingposts'] = "selECtED 4nd @ll F0Ll0w1nG p0StS";

$lang['threadmovedhere'] = "h3R3";

$lang['thisthreadhasmoved'] = "<b>thRE4d\$ mEr9Ed:</b> +h15 +HRe4d H4\$ M0veD %s";
$lang['thisthreadwasmergedfrom'] = "<b>thR34dS MERG3D:</b> TH15 +hre4d W@5 mERgeD PHrOm %s";
$lang['somepostsinthisthreadhavebeenmoved'] = "<b>thr3@d \$PLI+:</b> s0Me p05tS 1n TH1s THr34d h4vE bEen m0v3d %s";
$lang['somepostsinthisthreadweremovedfrom'] = "<b>thr34D sPl1t:</b> \$OmE p0\$tS in Thi\$ +HRe4d weR3 M0vEd Fr0M %s";

$lang['thisposthasbeenmoved'] = "<b>tHre4d SPl1t:</b> THi\$ p0S+ Ha\$ beEN m0VED %s";

$lang['invalidfunctionarguments'] = "inv4L1d Func+1on 4r9umEnts";
$lang['couldnotretrieveforumdata'] = "c0uLd No+ r3+rI3v3 phoRUM D@+4";
$lang['cannotmergepolls'] = "onE Or MOr3 tHR34d5 1S 4 poll. J00 C@nn0t M3r9e polLs";
$lang['couldnotretrievethreaddatamerge'] = "c0uld N0+ rEtr13V3 +Hr34D d4+4 PHr0m 0n3 0R m0r3 +hRe@D5";
$lang['couldnotretrievethreaddatasplit'] = "cOulD N0+ reTriEve thR34D d4+4 fr0m \$0urcE ThRe4d";
$lang['couldnotretrievepostdatamerge'] = "c0ULd no+ r3TR1eV3 PoSt d4ta FrOm One Or MoR3 +HRe4Ds";
$lang['couldnotretrievepostdatasplit'] = "coULd nO+ Re+r13v3 POS+ d@T4 PhR0m SoURCE tHr34d";
$lang['failedtocreatenewthreadformerge'] = "f4IL3d TO cRE4+3 n3W +hR34D phOr m3r9e";
$lang['failedtocreatenewthreadforsplit'] = "f@1Led To cr34+e n3W thR34d PH0R \$PL1t";

// Thread subscriptions

$lang['threadsubscriptions'] = "tHr34D SUb\$CRiP+10n5";
$lang['couldnotupdateinterestonthread'] = "c0uLD NO+ upd4te 1nteRE\$+ 0n thRe4D '%s'";
$lang['threadinterestsupdatedsuccessfully'] = "thR3@d 1n+3ReS+\$ upDAt3d \$uCC3SsFuLly";
$lang['resetselected'] = "rE\$ET \$3l3c+Ed";
$lang['allthreadtypes'] = "aLL thR34D +ypeS";
$lang['ignoredthreads'] = "igN0R3d ThR3@d5";
$lang['highinterestthreads'] = "hIGH 1nt3reST +Hre4d5";
$lang['subscribedthreads'] = "su8ScrIbeD tHr34d\$";
$lang['currentinterest'] = "cuRReN+ Int3rE\$+";

// Browseable user profiles

$lang['youcanonlyaddthreecolumns'] = "j00 c4n 0NlY @dD 3 C0luMN\$. T0 4dd 4 New c0lUmn ClO5E 4n eX15t1Ng one";
$lang['columnalreadyadded'] = "j00 haVe 4lR34dy @DDed +hIS c0LuMN. iph J00 W4nT t0 r3mOVe I+ cL1cK 1t'S Cl0S3 bU++0n";

?>