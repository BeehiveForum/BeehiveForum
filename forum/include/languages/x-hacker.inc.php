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

/* $Id: x-hacker.inc.php,v 1.265 2007-12-15 23:06:15 decoyduck Exp $ */

// British English language file

// Language character set and text direction options -------------------

$lang['_isocode'] = "en";
$lang['_textdir'] = "ltr";

// Months --------------------------------------------------------------

$lang['month'][1]  = "j4nu4ry";
$lang['month'][2]  = "fE8ru4rY";
$lang['month'][3]  = "m@rCh";
$lang['month'][4]  = "april";
$lang['month'][5]  = "m@Y";
$lang['month'][6]  = "jUn3";
$lang['month'][7]  = "jULY";
$lang['month'][8]  = "au9us+";
$lang['month'][9]  = "s3P+emB3r";
$lang['month'][10] = "oC+o8Er";
$lang['month'][11] = "n0V3m83r";
$lang['month'][12] = "d3cEMB3r";

$lang['month_short'][1]  = "j4N";
$lang['month_short'][2]  = "f38";
$lang['month_short'][3]  = "m4R";
$lang['month_short'][4]  = "aPR";
$lang['month_short'][5]  = "m@Y";
$lang['month_short'][6]  = "jun";
$lang['month_short'][7]  = "jUl";
$lang['month_short'][8]  = "aug";
$lang['month_short'][9]  = "sEp";
$lang['month_short'][10] = "oC+";
$lang['month_short'][11] = "n0v";
$lang['month_short'][12] = "dec";

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

$lang['date_periods']['year']   = "%s Y3ar";
$lang['date_periods']['month']  = "%s MonTH";
$lang['date_periods']['week']   = "%s WEEK";
$lang['date_periods']['day']    = "%s d@Y";
$lang['date_periods']['hour']   = "%s HOUr";
$lang['date_periods']['minute'] = "%s Minu+3";
$lang['date_periods']['second'] = "%s S3C0ND";

// As above but plurals (2 years vs. 1 year, etc.)

$lang['date_periods_plural']['year']   = "%s y3ars";
$lang['date_periods_plural']['month']  = "%s Mon+Hs";
$lang['date_periods_plural']['week']   = "%s w3Eks";
$lang['date_periods_plural']['day']    = "%s d4y\$";
$lang['date_periods_plural']['hour']   = "%s h0Ur\$";
$lang['date_periods_plural']['minute'] = "%s M1nU+Es";
$lang['date_periods_plural']['second'] = "%s 5eCOnD\$";

// Short hand periods (example: 1y, 2m, 3w, 4d, 5hr, 6min, 7sec)

$lang['date_periods_short']['year']   = "%sY";    // 1y
$lang['date_periods_short']['month']  = "%sm";    // 2m
$lang['date_periods_short']['week']   = "%sw";    // 3w
$lang['date_periods_short']['day']    = "%sd";    // 4d
$lang['date_periods_short']['hour']   = "%shr";   // 5hr
$lang['date_periods_short']['minute'] = "%smIn";  // 6min
$lang['date_periods_short']['second'] = "%s\$3c";  // 7sec

// Common words --------------------------------------------------------

$lang['percent'] = "p3RcEn+";
$lang['average'] = "av3r4gE";
$lang['approve'] = "aPPR0V3";
$lang['banned'] = "bANN3D";
$lang['locked'] = "l0CkED";
$lang['add'] = "add";
$lang['advanced'] = "aDVanC3d";
$lang['active'] = "aCtiv3";
$lang['style'] = "s+YL3";
$lang['go'] = "go";
$lang['folder'] = "fOLD3r";
$lang['ignoredfolder'] = "iGn0reD pH0LD3r";
$lang['folders'] = "fOLd3R\$";
$lang['thread'] = "thR3AD";
$lang['threads'] = "tHreaDs";
$lang['threadlist'] = "tHrE4D lI5T";
$lang['message'] = "m3sS4G3";
$lang['messagenumber'] = "m3\$S49e numB3R";
$lang['from'] = "fr0m";
$lang['to'] = "tO";
$lang['all_caps'] = "aLL";
$lang['of'] = "oPH";
$lang['reply'] = "r3Ply";
$lang['forward'] = "f0RW@rD";
$lang['replyall'] = "rEPly to All";
$lang['pm_reply'] = "rePlY 4S Pm";
$lang['delete'] = "d3L3+3";
$lang['deleted'] = "d3L3TED";
$lang['edit'] = "ed1+";
$lang['privileges'] = "pRivil393s";
$lang['ignore'] = "iGNOrE";
$lang['normal'] = "n0Rm4l";
$lang['interested'] = "in+ER35+3D";
$lang['subscribe'] = "sUBscr18e";
$lang['apply'] = "apply";
$lang['download'] = "d0wnl04d";
$lang['save'] = "s4V3";
$lang['update'] = "upD@tE";
$lang['cancel'] = "cancel";
$lang['continue'] = "c0nTInUE";
$lang['attachment'] = "aTt4ChM3Nt";
$lang['attachments'] = "at+4chmenT5";
$lang['imageattachments'] = "iM4g3 atTaCHM3Nts";
$lang['filename'] = "f1L3n@ME";
$lang['dimensions'] = "d1MensI0Ns";
$lang['downloadedxtimes'] = "doWnlo@D3d: %d +1m3S";
$lang['downloadedonetime'] = "dOwnl0@D3D: 1 t1m3";
$lang['size'] = "s1Z3";
$lang['viewmessage'] = "vIEw MEss49E";
$lang['deletethumbnails'] = "d3l3t3 +hUMBNa1l\$";
$lang['logon'] = "lOg0N";
$lang['more'] = "mOre";
$lang['recentvisitors'] = "rEC3n+ VI\$1torS";
$lang['username'] = "u5ern4Me";
$lang['clear'] = "cL3@r";
$lang['action'] = "aCT10n";
$lang['unknown'] = "unKN0WN";
$lang['none'] = "n0N3";
$lang['preview'] = "previEw";
$lang['post'] = "p05+";
$lang['posts'] = "p0s+S";
$lang['change'] = "chAN93";
$lang['yes'] = "y3S";
$lang['no'] = "no";
$lang['signature'] = "sI9n4+UrE";
$lang['signaturepreview'] = "sI9n4+UrE Prev13W";
$lang['signatureupdated'] = "sI9n@TUR3 upD@TeD";
$lang['signatureupdatedforallforums'] = "s1gn@tUrE upD@TED Phor 4LL pH0RUM\$";
$lang['back'] = "b4cK";
$lang['subject'] = "su8j3C+";
$lang['close'] = "cl0SE";
$lang['name'] = "n@m3";
$lang['description'] = "dE\$cr1p+i0N";
$lang['date'] = "d@+3";
$lang['view'] = "vI3w";
$lang['enterpasswd'] = "eN+er p4ssw0rd";
$lang['passwd'] = "pa5\$worD";
$lang['ignored'] = "i9NOreD";
$lang['guest'] = "gU3st";
$lang['next'] = "nEXT";
$lang['prev'] = "pR3vioUs";
$lang['others'] = "o+HEr5";
$lang['nickname'] = "n1ckn4Me";
$lang['emailaddress'] = "eM4il aDDr3Ss";
$lang['confirm'] = "c0nPH1rm";
$lang['email'] = "em41l";
$lang['poll'] = "pOLl";
$lang['friend'] = "fri3nd";
$lang['success'] = "sUcC3\$s";
$lang['error'] = "eRRor";
$lang['warning'] = "w4RNing";
$lang['guesterror'] = "sOrRY, j00 ne3d TO 83 l0G93D iN +0 u\$E Th1s ph34+urE.";
$lang['loginnow'] = "l09in n0W";
$lang['unread'] = "uNRE@D";
$lang['all'] = "all";
$lang['allcaps'] = "aLl";
$lang['permissions'] = "pErMIss10ns";
$lang['type'] = "tYPE";
$lang['print'] = "prIn+";
$lang['sticky'] = "stICky";
$lang['polls'] = "p0Ll5";
$lang['user'] = "uS3R";
$lang['enabled'] = "en48L3D";
$lang['disabled'] = "diS@8lEd";
$lang['options'] = "oPtion5";
$lang['emoticons'] = "eM0+1c0Ns";
$lang['webtag'] = "w38+@g";
$lang['makedefault'] = "m4KE D3F4ULt";
$lang['unsetdefault'] = "uN5E+ D3F4Ul+";
$lang['rename'] = "r3name";
$lang['pages'] = "p49Es";
$lang['used'] = "uS3D";
$lang['days'] = "dAy5";
$lang['usage'] = "u54ge";
$lang['show'] = "show";
$lang['hint'] = "hiN+";
$lang['new'] = "n3W";
$lang['referer'] = "reF3rer";
$lang['thefollowingerrorswereencountered'] = "t3h f0llow1ng 3rrors wEr3 ENCoUnTEr3d:";

// Admin interface (admin*.php) ----------------------------------------

$lang['admintools'] = "aDmin +0oLS";
$lang['forummanagement'] = "f0ruM M@n@93men+";
$lang['accessdeniedexp'] = "j00 d0 nOt h@v3 p3rMissi0N +o usE +hIs \$ECtIon.";
$lang['managefolders'] = "m@n49e F0LD3Rs";
$lang['manageforums'] = "m@n49e f0RUMs";
$lang['manageforumpermissions'] = "m4n@93 f0rUm pErMiS\$10Ns";
$lang['foldername'] = "f0LDEr n@m3";
$lang['move'] = "moV3";
$lang['closed'] = "cL0Sed";
$lang['open'] = "op3n";
$lang['restricted'] = "rE\$triC+3D";
$lang['forumiscurrentlyclosed'] = "%s I\$ curRentlY Clo5ED";
$lang['youdonothaveaccesstoforum'] = "j00 d0 NOT have 4CC3ss +o %s";
$lang['toapplyforaccessplease'] = "t0 @PpLy pH0R @CC3Ss plE4\$e C0nT4C+ +H3 f0rum owN3R.";
$lang['adminforumclosedtip'] = "ipH j00 waN+ To Ch4N9e \$0mE SEtTin9S oN Y0UR pHoRum CL1CK tEH 4dm1n liNk 1N +3h nAv194+i0N B4R 4BoV3.";
$lang['newfolder'] = "nEW f0ldEr";
$lang['nofoldersfound'] = "nO ex1st1NG pholDEr\$ F0und. to 4DD @ PhoLdeR CLiCK Teh 'aDD n3w' 8UT+on 83l0w.";
$lang['forumadmin'] = "foRUm @dmin";
$lang['adminexp_1'] = "u5E +he mEnu on teh L3phT T0 man4g3 tH1NG\$ iN y0ur phoRuM.";
$lang['adminexp_2'] = "<b>uS3r\$</b> @lloW5 j00 to sEt 1ndivIDU4L U\$er p3RM1s\$10NS, InclUDIng @ppo1nt1Ng MoD3r@+0rS 4ND 949G1Ng pEOpl3.";
$lang['adminexp_3'] = "<b>usEr grOups</b> 4LLOw5 j00 to CRE4+e usEr 9r0Ups +0 4\$siGN p3RMi\$Si0ns +0 As m4NY 0r @S ph3W Users QU1ckLy 4ND 3@5iLY.";
$lang['adminexp_4'] = "<b>b4n c0N+Rols</b> Allows thE B4NniNg AND UN-B4nNinG oph 1p 4DDrE\$\$Es, http rEPher3RS, usERn4MEs, EM41l @DDR3S\$e\$ 4nd n1cKN4M3s.";
$lang['adminexp_5'] = "<b>fOLD3Rs</b> ALlows +eh CRe4TioN, M0D1PH1ca+1On AnD DEL3+1on Oph pH0Ld3rS.";
$lang['adminexp_6'] = "<b>r5s pheEDs</b> 4ll0Ws j00 to m@n@9E R5\$ fE3D5 ph0R PR0P4G@+i0N 1N+0 y0uR ForuM.";
$lang['adminexp_7'] = "<b>pR0f1l3s</b> L3t5 J00 CUs+omisE the I+EMs +h4T 4PpE4R in +3h U5ER pRophil3S.";
$lang['adminexp_8'] = "<b>forum \$3++inGs</b> 4LlOw\$ j00 to cuS+om1\$e yoUR pH0RUm's n4ME, @pPE4RanC3 4nd m4Ny OthEr +HiNgs.";
$lang['adminexp_9'] = "<b>s+4rt p@G3</b> LE+\$ j00 Cus+0MI\$3 your PH0rum'5 s+4Rt p493.";
$lang['adminexp_10'] = "<b>fOrum \$+yl3</b> 4LLows J00 t0 gENEr@TE ranD0M styl3s f0R YoUr pHorUM m3MB3rs +o Use.";
$lang['adminexp_11'] = "<b>wORD F1l+Er</b> @LLows J00 T0 PhIltER W0RD\$ J00 d0N't W4N+ +O BE UsEd 0N Y0ur f0RuM.";
$lang['adminexp_12'] = "<b>poSt1n9 \$+4T\$</b> gEner@+E\$ 4 r3P0r+ l1\$t1ng +hE top 10 p0\$+er5 IN a D3FiNED P3R10D.";
$lang['adminexp_13'] = "<b>f0Rum l1nks</b> L3T\$ J00 m4N@G3 the LinKs Dropd0WN 1n +He N4V194+i0n 8@R.";
$lang['adminexp_14'] = "<b>v13w l0g</b> L1\$ts r3C3nt 4C+1ons 8y th3 F0RUm moD3R4+Or5.";
$lang['adminexp_15'] = "<b>m4n4g3 FOrum\$</b> lets j00 Cr34+3 ANd D3le+E @nd CLO\$e Or r3OpEN fOrums.";
$lang['adminexp_16'] = "<b>gL0bal f0rum \$e+t1ngs</b> @ll0ws J00 +0 moD1fy \$3tt1Ngs Which aPhf3CT all Forums.";
$lang['adminexp_17'] = "<b>po\$+ 4ppr0V@L qu3ue</b> @Ll0w\$ j00 T0 VIew 4ny P0\$+s 4wA1+INg @pPRov@L 8Y 4 moDER4ToR.";
$lang['adminexp_18'] = "<b>v1si+Or l09</b> @ll0w\$ j00 T0 VI3w 4N 3xtenDED liSt 0PH V1\$1+0Rs iNCLUdinG Th31r h++P rEfEr3R\$.";
$lang['createforumstyle'] = "cR34TE @ f0RUm \$+YlE";
$lang['newstylesuccessfullycreated'] = "new \$TYl3 \$ucC3\$SFuLly CrEaTED.";
$lang['stylealreadyexists'] = "a sTYl3 w1+H +h4t pHiL3N4m3 @lReADy 3x1s+s.";
$lang['stylenofilename'] = "j00 diD nO+ 3N+3R @ PhIL3N4m3 +o s4v3 +he StYl3 wI+h.";
$lang['stylenodatasubmitted'] = "cOulD n0+ re4d phOrUm styl3 d@+@.";
$lang['styleexp'] = "u5e +H1s P493 +O hElp cRe4T3 4 r4nd0Mly 93N3R@+ED styL3 F0R Y0ur phorum.";
$lang['stylecontrols'] = "c0NTrol5";
$lang['stylecolourexp'] = "cLICK 0n 4 C0LoUr t0 mAKE 4 n3W 5+YL3 \$H3et 845ED on +h@T COlour. CURREnt 84SE col0ur 1S Fir\$+ IN l1\$+.";
$lang['standardstyle'] = "s+AND4rd sTyL3";
$lang['rotelementstyle'] = "r0T4+ed el3mENt s+yl3";
$lang['randstyle'] = "r4ND0M S+yLE";
$lang['thiscolour'] = "this COl0uR";
$lang['enterhexcolour'] = "or 3Nt3r A hEx COl0UR +0 B45E 4 neW sTyLE sheE+ 0n";
$lang['savestyle'] = "s4V3 tH1\$ S+yle";
$lang['styledesc'] = "styL3 d3sCRip+i0n";
$lang['stylefilenamemayonlycontain'] = "s+yl3 phil3NAMe m@y Only c0nT41N L0WErc4\$E l3TtER\$ (4-z), nuMB3r\$ (0-9) and uNDER5COrE.";
$lang['stylepreview'] = "stYl3 PRev13w";
$lang['welcome'] = "wELC0M3";
$lang['messagepreview'] = "mE\$S49e pR3v13w";
$lang['users'] = "u\$3RS";
$lang['usergroups'] = "uSer 9R0Ups";
$lang['mustentergroupname'] = "j00 must eNtEr 4 9r0up n@M3";
$lang['profiles'] = "pR0f1l3s";
$lang['manageforums'] = "mAna93 f0rUms";
$lang['forumsettings'] = "forum Set+inG\$";
$lang['globalforumsettings'] = "gL0Bal f0RUM sett1NGS";
$lang['settingsaffectallforumswarning'] = "<b>nOt3:</b> Th3Se \$e++1ngS 4ff3CT @ll F0RUm5. WHEr3 THE \$3t+1NG is DUPLic@teD on th3 IndiViDU4l f0ruM'\$ S3+t1Ngs p4GE tH@+ W1Ll +4K3 preC3DENCE 0ver +H3 se++inGs J00 ch4N93 h3RE.";
$lang['startpage'] = "sT4rT P493";
$lang['startpageerror'] = "your STar+ p4g3 CoUlD n0t bE 5@vED L0C4lly to th3 \$ERVer 8EC@U53 p3rmiSSI0n wAS D3n1ED.</p><p>t0 CHaNgE yOUr \$+4rt p493 PlEase CLiCK T3h DowNl04d 8Ut+on BeLoW WhiCH w1lL PRompt j00 +0 S4V3 the Fil3 +0 y0UR H4RD DR1VE. j00 c4n TH3n upLo@D +hi\$ F1LE t0 Y0ur \$Erver 1n+o TH3 ph0ll0W1N9 f0LDEr, iPh n3C3SSary crE4+1NG +h3 folder 5TruCtuR3 in tEh ProcESs.</p><p><b>%s</b></p><p>pLEAse NO+3 that som3 BrowS3RS m4y Ch4ng3 TEh n4me 0ph th3 f1le up0N D0WNl0Ad.  when uplO@ding th3 fil3 pl34se m@ke sur3 th4+ i+ 1s n4M3d StaRT_m4In.php 0+HErwise yoUr \$+4Rt p4G3 w1LL 4Pp34r UNch@ngED.";
$lang['failedtoopenmasterstylesheet'] = "y0Ur forum \$tyl3 COuLD No+ BE s@veD BECAUS3 tEH mAster \$TYL3 sh3et COulD noT B3 l04d3D. +0 S@vE yoUr \$+yLE +HE m@\$+Er stylE 5HE3T (m4KE_s+YlE.C\$S) MU\$+ 83 LOc4+3D in +h3 s+yl3S Dir3CTory oph Y0ur b3Ehiv3 f0ruM 1Nst4lL4+i0n.";
$lang['makestyleerror'] = "your forum S+ylE C0ULD n0+ 8E s@V3D L0C@lLy +0 tEh sErv3r BEC@U53 p3rmissI0n W4\$ D3ni3D. +0 s4VE YoUr ph0RUM \$+Yl3 pl3@sE CL1CK +hE Downlo4D Bu++0N BEL0W wh1ch w1ll Pr0mp+ j00 +o \$@VE +hE phIl3 t0 y0UR h@Rd DriVE. J00 C4n +h3n UpL0@d TH1s ph1lE t0 Y0uR \$3rvER intO %s Folder, iph neC3Ss4ry Creat1n9 +eh f0LD3R \$tructurE in +h3 process. J00 sh0Uld n0+E +hat SOme 8row53Rs m4y Ch4ngE +he name 0f +3h phil3 up0N downlo@D. wh3n Uplo@d1ng +he f1l3 pl3as3 M4k3 sur3 th@+ it 1S n4meD 5Tyle.c5\$ 0TH3rw1sE +eH Forum Style W1ll 83 unU\$@8lE.";
$lang['forumstyle'] = "f0Rum \$TyL3";
$lang['wordfilter'] = "w0RD Phil+3r";
$lang['forumlinks'] = "f0Rum L1nKs";
$lang['viewlog'] = "vI3w l0G";
$lang['noprofilesectionspecified'] = "n0 pRoFIl3 S3ct1ON sp3CIphi3d.";
$lang['itemname'] = "iTem N4me";
$lang['moveto'] = "m0ve T0";
$lang['manageprofilesections'] = "m4n49E Pr0philE seC+I0ns";
$lang['sectionname'] = "sEct10n n@m3";
$lang['items'] = "i+3m5";
$lang['mustspecifyaprofilesectionid'] = "muSt spECiphy 4 proF1L3 s3C+1oN iD";
$lang['mustsepecifyaprofilesectionname'] = "mU5T sp3c1phY 4 pr0pH1L3 sECtIoN n@M3";
$lang['noprofilesectionsfound'] = "n0 Ex1St1NG prophile sEC+i0n5 PhounD. +0 ADD @ pr0f1LE \$Ect10N cL1CK THE '@DD nEW' 8U+t0n bEl0w.";
$lang['addnewprofilesection'] = "aDd n3w proFil3 sect10n";
$lang['successfullyaddedprofilesection'] = "succ35\$fullY 4DD3D PropH1l3 sEC+I0n";
$lang['successfullyeditedprofilesection'] = "sUcc3sSFUlly 3D1+3D pr0pHIlE sEC+10N";
$lang['addnewprofilesection'] = "add NEw PR0fiL3 seCTi0N";
$lang['mustsepecifyaprofilesectionname'] = "muS+ \$P3cify 4 profiL3 seCT10n n4M3";
$lang['successfullyremovedselectedprofilesections'] = "sUCCessfuLLY remov3D \$eL3C+3D pr0PHil3 SECt1ONS";
$lang['failedtoremoveprofilesections'] = "f@il3d T0 rEM0v3 pRopHil3 \$ECT10n\$";
$lang['viewitems'] = "vi3w 1+eMs";
$lang['successfullyaddednewprofileitem'] = "sUcC3s\$FULlY 4DD3D New pr0PhIl3 1+3M";
$lang['successfullyeditedprofileitem'] = "succe\$sfully 3D1tEd pr0Ph1L3 1+3m";
$lang['successfullyremovedselectedprofileitems'] = "sUcc3\$spHULly R3MOveD s3LECtED pr0PHiLe 1+3Ms";
$lang['failedtoremoveprofileitems'] = "f4il3D +0 rEm0V3 pr0Phil3 1t3M5";
$lang['noexistingprofileitemsfound'] = "therE @r3 n0 Ex1s+1NG pr0PHIle 1+3Ms 1n +HIS 53C+I0N. +0 4DD 4N i+Em Cl1CK thE '4DD n3w' 8u+T0N BElow.";
$lang['edititem'] = "ed1T iTem";
$lang['invalidprofilesectionid'] = "iNVAL1d pR0ph1L3 sEC+I0n 1D oR sECTion N0T FoUND";
$lang['invalidprofileitemid'] = "iNv4liD Pr0pHIl3 I+Em Id OR iTem n0+ Found";
$lang['addnewitem'] = "add N3w 1+eM";
$lang['youmustenteraprofileitemname'] = "j00 MU5+ 3N+3r 4 pROph1LE I+3m N4mE";
$lang['invalidprofileitemtype'] = "iNV@lid pR0PhIle ItEM typ3 \$Elected";
$lang['youmustenteroptionsforselectedprofileitemtype'] = "j00 must 3N+eR s0mE oP+1oNS ph0R s3L3CTeD pr0F1l3 1+3M Typ3";
$lang['youmustentermorethanoneoptionforitem'] = "j00 Mu\$T En+3R m0RE +h@N 0N3 opTion f0r \$el3C+3D pROphilE 1+EM TYp3";
$lang['profileitemhyperlinkssupportshttpurlsonly'] = "pR0Phil3 I+3m HypERl1NK\$ \$UPP0R+ ht+p urLs OnLy";
$lang['profileitemhyperlinkformatinvalid'] = "pr0phil3 i+3m hypERlink pH0Rm4+ 1Nv4L1D";
$lang['youmustincludeprofileentryinhyperlinks'] = "j00 mUs+ iNcluD3 <i>%s</i> In TEH uRl oph CliCk48lE hyP3rL1NKS";
$lang['failedtocreatenewprofileitem'] = "f4IL3D t0 Cre4te n3W ProFil3 I+Em";
$lang['failedtoupdateprofileitem'] = "f@1led +0 upDA+E ProphIlE 1t3m";
$lang['startpageupdated'] = "st4rt p49e Upd4+3D. %s";
$lang['viewupdatedstartpage'] = "v13W UPD@+3d st4Rt pA93";
$lang['editstartpage'] = "eDIT s+4RT P4g3";
$lang['nouserspecified'] = "n0 User \$P3c1fIED.";
$lang['manageuser'] = "m4N49e u\$3r";
$lang['manageusers'] = "m@n@ge Us3R\$";
$lang['userstatusforforum'] = "u5ER s+4Tus F0R %s";
$lang['userdetails'] = "uSer D3ta1L\$";
$lang['warning_caps'] = "w4rn1n9";
$lang['userdeleteallpostswarning'] = "aR3 j00 sur3 J00 w@nt T0 DElE+E @ll 0PH +h3 SEL3c+3D u\$3r's P0sts? 0NC3 +Eh p0STs @r3 deL3TED +H3Y C4nn0+ BE R3tRiEVED AnD w1ll B3 los+ F0REv3R.";
$lang['postssuccessfullydeleted'] = "po\$+S w3R3 suCC3SSfULly D3l3t3d.";
$lang['folderaccess'] = "f0LDEr @Cc3Ss";
$lang['possiblealiases'] = "p0Ss18le @li4sEs";
$lang['userhistory'] = "u\$3r h15+0RY";
$lang['nohistory'] = "nO h1\$tory reC0rDs 5@v3d";
$lang['userhistorychanges'] = "cHAn9E5";
$lang['clearuserhistory'] = "cle4r u\$3r H1\$t0ry";
$lang['changedlogonfromto'] = "ch@NgeD lO9On fR0M %s +o %s";
$lang['changednicknamefromto'] = "ch4ng3D n1cKN4m3 fR0M %s +0 %s";
$lang['changedemailfromto'] = "ch4ng3d em4IL phRom %s t0 %s";
$lang['successfullycleareduserhistory'] = "sUCC3SsfulLy Cl3AR3D u5er H1\$+ory";
$lang['failedtoclearuserhistory'] = "f@1leD to CLE4r uSER Hi\$+0ry";
$lang['successfullychangedpassword'] = "succ3SsfullY CH@n93D p@\$SW0Rd";
$lang['failedtochangepasswd'] = "f4Iled +0 Ch@Ng3 P45\$w0RD";
$lang['viewuserhistory'] = "vi3w usER hi\$+0ry";
$lang['viewuseraliases'] = "vi3w User ali@ses";
$lang['searchreturnednoresults'] = "se@RCh r3+urneD n0 rEsUl+S";
$lang['deleteposts'] = "deL3t3 p0STs";
$lang['deleteuser'] = "deL3+e Us3R";
$lang['alsodeleteusercontent'] = "al\$O Del3+3 4ll 0ph thE ContEn+ CrE4+3D 8Y Th1\$ u\$er";
$lang['userdeletewarning'] = "ar3 j00 surE j00 wAnt t0 DElEtE tH3 \$el3C+ED User aCC0unT? onCE +Eh @CCoUnT h45 BEEN D3LEt3d 1+ Cann0+ 8e rETr1EVED 4ND WilL 8e l0sT F0rever.";
$lang['usersuccessfullydeleted'] = "uS3r 5UCCESsFulLy D3l3teD";
$lang['failedtodeleteuser'] = "f@1leD +0 DEl3TE U\$3r";
$lang['forgottenpassworddesc'] = "if tHIs u\$3r h@s ph0Rgott3N th31r passw0Rd j00 c@N REsEt 1+ pHOR theM hEr3.";
$lang['manageusersexp'] = "th1S list sHow5 @ \$3lEC+i0N oPh u\$er\$ Wh0 H4v3 l0G93d 0n +o y0ur f0rUM, SorteD BY %s. TO 4l+er @ User's p3Rm1\$Si0N\$ CLICk th31r n4M3.";
$lang['userfilter'] = "usER philTEr";
$lang['onlineusers'] = "oNl1nE U53R\$";
$lang['offlineusers'] = "ofPHl1nE us3r\$";
$lang['usersawaitingapproval'] = "u\$3r\$ 4W4iT1ng 4PPR0v4l";
$lang['bannedusers'] = "b@nNeD Us3rs";
$lang['lastlogon'] = "lAS+ l0G0n";
$lang['sessionreferer'] = "sEsS10n R3f3RER";
$lang['signupreferer'] = "sI9n-Up rEfEr3R:";
$lang['nouseraccountsmatchingfilter'] = "n0 u\$3R 4ccouNts m4+chIng pHil+3R";
$lang['searchforusernotinlist'] = "se4RCH pHor a us3R no+ in lI\$+";
$lang['adminaccesslog'] = "aDm1n 4CC3S\$ log";
$lang['adminlogexp'] = "tH1s l1st sHOw\$ th3 lAs+ 4c+1On\$ 54nc+1ON3D 8Y UseR\$ WI+h 4dm1N PrIV1l3gEs.";
$lang['datetime'] = "d4+E/+iME";
$lang['unknownuser'] = "unKN0wN usEr";
$lang['unknownuseraccount'] = "uNknowN us3R 4CCOUnt";
$lang['unknownfolder'] = "uNKN0Wn F0lDER";
$lang['ip'] = "iP";
$lang['lastipaddress'] = "l@\$+ ip @DDREss";
$lang['logged'] = "l0g9ED";
$lang['notlogged'] = "n0+ log93d";
$lang['addwordfilter'] = "aDd WOrD pH1lteR";
$lang['addnewwordfilter'] = "aDD new W0RD f1ltEr";
$lang['wordfilterupdated'] = "woRD f1L+3R UpD@+Ed";
$lang['wordfilterisfull'] = "j00 C4nn0+ aDd 4NY m0rE w0rD fiL+Ers. R3mOvE somE UNusED 0nes 0r 3D1+ TEh 3X1ST1ng on3S Fir\$t.";
$lang['filtername'] = "f1Lt3r n4m3";
$lang['filtertype'] = "f1lt3r tYp3";
$lang['filterenabled'] = "f1lT3r 3N48leD";
$lang['editwordfilter'] = "edIt word fIl+3r";
$lang['nowordfilterentriesfound'] = "n0 eXI\$+1n9 w0RD fiL+3R 3N+Ri3S f0unD. to AdD 4 PH1l+er CLiCK +hE 'adD new' BU+T0N BELOw.";
$lang['mustspecifyfiltername'] = "j00 mu\$t sp3CiFy A F1LtEr n@m3";
$lang['mustspecifymatchedtext'] = "j00 Must speC1fy m@+cHeD +Ext";
$lang['mustspecifyfilteroption'] = "j00 Mu5+ Sp3CIfy 4 pHil+3r 0p+10n";
$lang['mustspecifyfilterid'] = "j00 mus+ \$P3CifY 4 pHIL+3r iD";
$lang['invalidfilterid'] = "inv4l1D pHiL+3r 1D";
$lang['failedtoupdatewordfilter'] = "f4IlED +0 UpD4+3 WORd f1L+3R. cH3Ck +H4T th3 ph1l+3r 5+1ll 3xi\$+s.";
$lang['allow'] = "aLLow";
$lang['block'] = "bl0CK";
$lang['normalthreadsonly'] = "n0Rmal +hre4d\$ Only";
$lang['pollthreadsonly'] = "poLL thr3adS 0Nly";
$lang['both'] = "boTh thRE4D Typ3S";
$lang['existingpermissions'] = "exi\$T1NG p3Rm15\$1on5";
$lang['nousershavebeengrantedpermission'] = "n0 3x15T1Ng U\$3rs p3Rm1\$S10n\$ f0UnD. T0 gr@nt p3RM1S\$10n To Us3RS sE4RCh Ph0r +heM 83Low.";
$lang['successfullyaddedpermissionsforselectedusers'] = "sucC35\$fully @DDED p3rM1ssi0n\$ f0R \$el3CTED User\$";
$lang['successfullyremovedpermissionsfromselectedusers'] = "suCCEssphuLlY R3moV3D P3Rm1sS10ns fRom \$3lEc+3D UsErs";
$lang['failedtoaddpermissionsforuser'] = "f@1leD t0 4DD pERm1\$\$10NS phor u53r '%s'";
$lang['failedtoremovepermissionsfromuser'] = "f4Il3D t0 reM0V3 P3rm1\$SIon5 FR0m usEr '%s'";
$lang['searchforuser'] = "s3@Rch PHOr U53r";
$lang['browsernegotiation'] = "bRowsEr n390t14T3d";
$lang['largetextfield'] = "laR93 tEx+ Phi3Ld";
$lang['mediumtextfield'] = "mEdiuM T3xt F13lD";
$lang['smalltextfield'] = "sm4ll +Ext F13lD";
$lang['multilinetextfield'] = "muLTI-l1N3 text pH13ld";
$lang['radiobuttons'] = "rAd10 Bu+t0n\$";
$lang['dropdownlist'] = "dR0P d0wN L15+";
$lang['clickablehyperlink'] = "clICk48le hypErlink";
$lang['threadcount'] = "tHr3@D C0uNt";
$lang['clicktoeditfolder'] = "cl1Ck to eDi+ pH0LDer";
$lang['fieldtypeexample1'] = "t0 CREat3 R4d10 8U+tOn\$ 0r a dR0P D0WN Li\$+ j00 neED +0 En+Er E4ch 1nd1V1du4L vALU3 0N 4 \$3p4RAtE l1NE 1n +H3 0Pt10N\$ pHi3LD.";
$lang['fieldtypeexample2'] = "t0 cr34te Cl1ck48lE lInK\$ 3n+3r +hE URl In +eh 0P+10ns Fi3LD @Nd usE <i>%1\$S</i> Wh3RE +3h entry PHrom th3 us3R's profil3 sHoulD 4Pp34R. 3XAmpLEs: <p>mysp4C3: <i>h++p://www.mYsp4cE.coM/%1\$s</i><br />x8OX liv3: <i>h+tp://Proph1lE.myg4M3rc@rD.n3+/%1\$S</i>";
$lang['editedwordfilter'] = "eDited W0RD F1LT3r";
$lang['editedforumsettings'] = "eD1t3D ph0rUM sett1ngs";
$lang['successfullyendedusersessionsforselectedusers'] = "suCCE\$SphUlLy ENDED \$3s5I0ns phor s3l3cTED User\$";
$lang['failedtoendsessionforuser'] = "f4Il3D to End 53ssi0n FoR U\$ER %s";
$lang['successfullyapprovedselectedusers'] = "sUCc35\$fULLy 4ppr0VED \$el3c+3D useR\$";
$lang['matchedtext'] = "m@+Ch3D +3x+";
$lang['replacementtext'] = "r3PL4c3m3nt text";
$lang['preg'] = "pReg";
$lang['wholeword'] = "wHolE Word";
$lang['word_filter_help_1'] = "<b>alL</b> MA+Ch3\$ @G4INst +hE Wh0LE +Ext so fiLt3RinG m0m to mUm wIlL 4LsO CH4n93 mom3nt +0 mumeN+.";
$lang['word_filter_help_2'] = "<b>wHOL3 wORD</b> m@+ch3S @g4IN\$T whoLE W0rd\$ 0nly \$o PHIlt3ring M0m +0 mUm will N0t CH4N9e m0M3nT T0 mumEn+.";
$lang['word_filter_help_3'] = "<b>pr39</b> 4ll0W\$ J00 t0 use p3Rl regUl4R exprEssi0ns TO M@+cH +Ext.";
$lang['nameanddesc'] = "n4m3 and DE\$crIP+10n";
$lang['movethreads'] = "mov3 +hr3@Ds";
$lang['movethreadstofolder'] = "m0ve +hr34ds +0 folD3R";
$lang['failedtomovethreads'] = "fa1l3D tO m0VE +hr3ADs +0 spec1F13D f0ld3r";
$lang['resetuserpermissions'] = "rEset UsEr permi\$S1ONs";
$lang['failedtoresetuserpermissions'] = "f4IleD +o RES3t Us3R pErm1Ss1on\$";
$lang['allowfoldertocontain'] = "alLOw foldER +0 Con+41n";
$lang['addnewfolder'] = "aDD n3w Ph0LDEr";
$lang['mustenterfoldername'] = "j00 mu\$t ENtER @ ph0ld3R n4m3";
$lang['nofolderidspecified'] = "nO ph0LDEr iD spEC1F1ED";
$lang['invalidfolderid'] = "iNV@liD pholD3r 1D. CheCK thAt 4 pholDeR W1+h +His 1d ex15+s!";
$lang['successfullyaddednewfolder'] = "sUcC3SsFuLly 4DDED n3w F0lder";
$lang['successfullyremovedselectedfolders'] = "succ35\$PHully r3M0v3D \$eL3C+3d pH0lDER5";
$lang['successfullyeditedfolder'] = "sUccEs\$fuLly 3di+eD f0Ld3R";
$lang['failedtocreatenewfolder'] = "f@IL3D t0 CR34+3 NEw Ph0LD3r";
$lang['failedtodeletefolder'] = "f4iL3d t0 D3l3T3 pH0LdEr.";
$lang['failedtoupdatefolder'] = "f4Il3d T0 UPd@+E foLD3R";
$lang['cannotdeletefolderwiththreads'] = "c4Nn0+ D3L3+3 phold3rs +h4+ 5+ill CoNt@1n +hREADs.";
$lang['forumisnotrestricted'] = "f0RUm 1s no+ rEstr1c+3d";
$lang['groups'] = "grOUP\$";
$lang['nousergroups'] = "n0 user gr0uP\$ H@ve 8EEN sE+ Up. +0 4DD 4 9roup ClICk +h3 '4DD new' BU+T0n B3Low.";
$lang['suppliedgidisnotausergroup'] = "suPpli3d G1d 1s N0T 4 UsEr 9RoUp";
$lang['manageusergroups'] = "m4n493 U5er 9roUps";
$lang['groupstatus'] = "gR0up s+@tu\$";
$lang['addusergroup'] = "aDd u\$er 9ROUp";
$lang['addemptygroup'] = "aDd 3mp+y GR0UP";
$lang['adduserstogroup'] = "aDd usEr\$ +0 gr0uP";
$lang['addremoveusers'] = "adD/rEM0v3 u\$ers";
$lang['nousersingroup'] = "tHer3 4RE n0 US3rs 1N +h1\$ 9R0up. 4DD u5eR\$ +0 th15 gr0up 8Y \$eaRCh1N9 PhOr tHEm B3L0w.";
$lang['groupaddedaddnewuser'] = "sUcce\$SfUlly 4dDED gRoUp. @dD U\$3rs +O +his 9R0up BY 534RCHinG Ph0R +HEM 8elow.";
$lang['nousersingroupaddusers'] = "tH3r3 aR3 no U\$er5 in th1S gr0up. +0 4DD useRs CL1CK +h3 '4DD/reM0V3 useRs' BUt+0n 83L0w.";
$lang['useringroups'] = "tH1S U\$3r is @ m3mBER oPh +3h PhoLlowING grouPs";
$lang['usernotinanygroups'] = "tH1s us3R i\$ n0t 1n @Ny uSEr gRoUps";
$lang['usergroupwarning'] = "n0+E: +h1\$ u\$er M@y BE iNhEritiNg 4DD1+i0N@L p3rm1S\$10NS phr0m @Ny us3r 9RoUp\$ L1s+eD 83l0w.";
$lang['successfullyaddedgroup'] = "sucCES\$FUlly 4DDED Gr0UP";
$lang['successfullyeditedgroup'] = "sucC3sSfUllY 3DIteD gr0UP";
$lang['successfullydeletedselectedgroups'] = "sUCc3SsFully DElEtED \$3l3C+3D Gr0Up\$";
$lang['failedtodeletegroupname'] = "f@1leD +0 DEL3t3 9R0up %s";
$lang['usercanaccessforumtools'] = "uSER Can @CC3SS F0RUM +o0ls 4nD C@n CrE4TE, D3LETE @ND 3di+ f0RUMs";
$lang['usercanmodallfoldersonallforums'] = "u\$3r c4n m0DER@te <b>all PH0ld3RS</b> On <b>aLl fOrUm\$</b>";
$lang['usercanmodlinkssectiononallforums'] = "u53r C4n M0d3R4te L1Nks sEct10n 0n <b>all f0rums</b>";
$lang['emailconfirmationrequired'] = "eM4il COnPH1RMAt10n r3QUiR3d";
$lang['userisbannedfromallforums'] = "u\$3r is 8ann3d fRom <b>aLl f0RuMs</b>";
$lang['cancelemailconfirmation'] = "c4nc3L 3M4il ConF1Rm@+Ion @nD aLlow USER to sTar+ pO\$+1n9";
$lang['resendconfirmationemail'] = "r3SenD ConfirM@+1oN 3M4iL TO us3R";
$lang['donothing'] = "d0 noThin9";
$lang['usercanaccessadmintools'] = "uSeR H@s @CC3ss +0 f0rUM @DmIn +o0ls";
$lang['usercanaccessadmintoolsonallforums'] = "u\$Er h4\$ @CC3Ss to 4Dm1N t0ol5 <b>on ALl phorUm5</b>";
$lang['usercanmoderateallfolders'] = "u\$3R Can moDer@tE @ll f0lders";
$lang['usercanmoderatelinkssection'] = "uSer C4N mOD3R@+E l1nks seCtIon";
$lang['userisbanned'] = "u\$3r 15 B@nn3D";
$lang['useriswormed'] = "u\$3r iS W0rmeD";
$lang['userispilloried'] = "useR Is p1lLor13d";
$lang['usercanignoreadmin'] = "us3R C4N iGn0RE @DmIn1\$+R4TOR5";
$lang['groupcanaccessadmintools'] = "gR0up c4N 4CCESS 4dMin +o0Ls";
$lang['groupcanmoderateallfolders'] = "grOUp c@N m0DeR4+3 @ll f0LdER5";
$lang['groupcanmoderatelinkssection'] = "gr0up C@n MOd3R4te LiNKs S3c+10NS";
$lang['groupisbanned'] = "gr0UP 1\$ 84nnEd";
$lang['groupiswormed'] = "gr0UP 1S woRMeD";
$lang['readposts'] = "re4d p0s+s";
$lang['replytothreads'] = "r3plY +O +Hr3@D\$";
$lang['createnewthreads'] = "cRE4T3 New +hR34D5";
$lang['editposts'] = "edi+ p0S+s";
$lang['deleteposts'] = "dELEt3 Pos+\$";
$lang['postssuccessfullydeleted'] = "p0s+S \$uCC3sSphuLLy deLEtED";
$lang['failedtodeleteusersposts'] = "fa1l3d T0 dElE+3 usEr's p0\$+S";
$lang['uploadattachments'] = "upL04d 4t+4cHMen+\$";
$lang['moderatefolder'] = "moDerATe f0LDeR";
$lang['postinhtml'] = "po\$+ iN H+Ml";
$lang['postasignature'] = "po\$+ 4 \$i9n@TUr3";
$lang['editforumlinks'] = "edI+ fOrum liNK5";
$lang['linksaddedhereappearindropdown'] = "l1NKs @Dd3D h3Re aPPeAR 1N 4 dr0P d0wn 1n teh ToP r1GHt oF +eH Phr4m3 53T.";
$lang['linksaddedhereappearindropdownaddnew'] = "linK5 4dDeD h3Re @pp34r in @ dROp D0wN 1N t3H +0P r19Ht Of T3h Phr@m3 s3t. T0 4dD 4 l1nk cl1ck +hE '@Dd NEW' bUT+0N Bel0W.";
$lang['failedtoremoveforumlink'] = "f41leD +0 r3M0v3 f0rum LiNk '%s'";
$lang['failedtoaddnewforumlink'] = "fa1LeD +0 4DD new f0RUm L1nK '%s'";
$lang['failedtoupdateforumlink'] = "f4Il3D +0 uPD4+3 F0rum lINk '%s'";
$lang['notoplevellinktitlespecified'] = "n0 top l3V3l l1nk +I+L3 Sp3CIpH1ED";
$lang['youmustenteralinktitle'] = "j00 mUst 3NtEr @ L1Nk +i+LE";
$lang['alllinkurismuststartwithaschema'] = "alL l1nK uR1s mU\$+ \$t4rt w1+h @ \$chEMa (I.3. H+TP://, FtP://, iRC://)";
$lang['editlink'] = "eDit l1Nk";
$lang['addnewforumlink'] = "add new F0RuM lInk";
$lang['forumlinktitle'] = "f0RUm l1nk +1+le";
$lang['forumlinklocation'] = "f0rum L1nk l0C4+i0N";
$lang['successfullyaddednewforumlink'] = "sucCEssfully @dD3d N3w f0RuM LinK";
$lang['successfullyeditedforumlink'] = "sucC3s\$phULly 3D1+Ed phoRUM lInk";
$lang['invalidlinkidorlinknotfound'] = "inV@l1D liNk iD or liNK n0t phoUnD";
$lang['successfullyremovedselectedforumlinks'] = "sucC3S\$PHullY rEm0V3D \$el3C+3D lInks";
$lang['toplinkcaption'] = "tOp link C@p+i0n";
$lang['allowguestaccess'] = "alL0W Gu3s+ aCcEsS";
$lang['searchenginespidering'] = "s34rch 3Ng1n3 SpiD3RInG";
$lang['allowsearchenginespidering'] = "allOW se4Rch 3n91N3 \$P1D3Ring";
$lang['newuserregistrations'] = "nEW U53r r39Is+r4tion\$";
$lang['preventduplicateemailaddresses'] = "pR3v3NT duPliCAtE em4IL 4ddres\$es";
$lang['allownewuserregistrations'] = "aLl0W n3W U\$Er r39I5+r4t10N5";
$lang['requireemailconfirmation'] = "r3Qu1r3 3mA1l C0npH1rm4tioN";
$lang['usetextcaptcha'] = "u\$3 +EX+-c@p+CH4";
$lang['textcaptchadir'] = "teXt-CapTCh@ d1R3Ct0rY";
$lang['textcaptchakey'] = "t3X+-C@p+Cha kEY";
$lang['textcaptchafonterror'] = "teXT-C4PTCHa h4\$ B33N Dis@8lEd @u+om@tiC@lLy 8ECAu\$e +hEr3 4rE N0 tRu3 +yP3 f0nT\$ 4va1l@BlE f0R I+ +0 u\$E. plE4S3 uPL0@d s0M3 tru3 +yp3 Fonts +O <b>%s</b> 0n Your 5eRV3r.";
$lang['textcaptchadirerror'] = "tex+-CAp+ch@ h@\$ 8een dIs4Bl3d B3c4UsE tH3 tExt_CaPtch@ D1r3ctory @ND it's \$ub-Dir3C+0R13s @r3 n0+ wr1+4blE 8y +hE w38 53rvEr / php pR0CEss.";
$lang['textcaptchagderror'] = "tEXT-Cap+ch@ h@s 83En dIs@BlED 8EC4U\$3 y0Ur sErv3R'\$ php se+up Do3s n0t pr0V1d3 \$UPP0RT F0R gD im49E m4nIpUl@+i0n 4nd / 0R +tf f0nt suppor+. B0+H 4R3 r3quIR3d f0R +ex+-C@p+Ch@ supP0R+.";
$lang['textcaptchadirblank'] = "t3xt-C@p+cH4 DIREC+0Ry i\$ Blank!";
$lang['newuserpreferences'] = "neW u\$er pr3pH3r3nc3S";
$lang['sendemailnotificationonreply'] = "emAil notIFiCat10n 0n rePly tO u\$er";
$lang['sendemailnotificationonpm'] = "em41l no+iF1C4+i0n 0N pm To U53R";
$lang['showpopuponnewpm'] = "sHow pOPUp Wh3n rEC31v1n9 NeW Pm";
$lang['setautomatichighinterestonpost'] = "s3+ au+0m@+iC h19H 1nter3s+ on p0\$t";
$lang['postingstats'] = "pOst1n9 \$+4t\$";
$lang['postingstatsforperiod'] = "p05+In9 \$T4+s f0R p3riOD %s +0 %s";
$lang['nopostdatarecordedforthisperiod'] = "nO poST D4+@ rEc0rD3d for +h1\$ PEr10d.";
$lang['totalposts'] = "t0+@L p0\$+5";
$lang['totalpostsforthisperiod'] = "t0TAl pos+S ph0R +his p3Riod";
$lang['mustchooseastartday'] = "muSt Ch0o\$3 a \$T4rt D4y";
$lang['mustchooseastartmonth'] = "muSt cHoos3 4 STar+ MoN+H";
$lang['mustchooseastartyear'] = "mU5t ch0o\$3 a s+4rt y3@r";
$lang['mustchooseaendday'] = "mu5t Ch005E @ 3ND d@y";
$lang['mustchooseaendmonth'] = "muSt Cho0SE 4 eNd m0N+H";
$lang['mustchooseaendyear'] = "mU\$+ cho0s3 4 enD yE4R";
$lang['startperiodisaheadofendperiod'] = "st4r+ p3Ri0d 1\$ @He4d 0PH 3nD P3ri0D";
$lang['bancontrols'] = "b@n CoN+roLs";
$lang['addban'] = "add 84n";
$lang['checkban'] = "cHeCk bAn";
$lang['editban'] = "ed1t b4n";
$lang['bantype'] = "b4N type";
$lang['bandata'] = "b4n d4+4";
$lang['bancomment'] = "c0MMen+";
$lang['ipban'] = "ip B4n";
$lang['logonban'] = "lO9ON 8An";
$lang['nicknameban'] = "n1ckn@me 84n";
$lang['emailban'] = "eM41l B4n";
$lang['refererban'] = "rePH3reR B4n";
$lang['invalidbanid'] = "inV@L1D B4n iD";
$lang['affectsessionwarnadd'] = "tH1s 8an May @phf3C+ +he pH0Ll0W1ng 4cTIVE U\$3r SE\$\$10NS";
$lang['noaffectsessionwarn'] = "tHIs 84N 4FfeCTs n0 4c+1v3 \$e\$SIon5";
$lang['mustspecifybantype'] = "j00 mu\$T Sp3CIfy @ Ban +Yp3";
$lang['mustspecifybandata'] = "j00 mUst spEC1fy somE 8aN D4+4";
$lang['successfullyremovedselectedbans'] = "sucC3\$5fulLy rEmoV3D \$eLEctED 8ans";
$lang['failedtoaddnewban'] = "f4IL3D to 4DD nEW 8An";
$lang['failedtoremovebans'] = "f4il3d t0 r3MOv3 S0me 0r 4Ll oPH +hE 5EL3c+3D B@n\$";
$lang['duplicatebandataentered'] = "dUPlic@tE 8@n D4TA 3n+3red. pl34\$e ChecK Y0Ur wIlDC4rds +0 se3 1Ph +h3y @lre4dY M4TCh TEh d@t@ En+Er3D";
$lang['successfullyaddedban'] = "sucC3s5PHULly aDDED 84n";
$lang['successfullyupdatedban'] = "succe5sfULlY UpD4teD 8AN";
$lang['noexistingbandata'] = "th3r3 I\$ n0 Ex1\$t1n9 84n d4t4. to 4dD a 84n CLiCk thE '@dD NEW' BUT+on B3L0w.";
$lang['youcanusethepercentwildcard'] = "j00 can UsE +3h p3RC3N+ (%) w1LDC@RD sym8ol 1N @ny oPh y0ur 8An li\$+s t0 Ob+@In PaRtI4L m4+ch3S, 1.3. '192.168.0.%' woUlD BAn 4LL Ip @DDrE5sEs iN +h3 r4ngE 192.168.0.1 +hr0ugh 192.168.0.254";
$lang['cannotusewildcardonown'] = "j00 C@Nn0+ @DD % 4S 4 wilDC4rD M@+Ch 0N i+'\$ OwN!";
$lang['requirepostapproval'] = "rEQu1re po\$+ 4ppr0vAL";
$lang['adminforumtoolsusercounterror'] = "tH3re mU5+ 8E 4+ l345+ 1 user Wi+H @dmin T00ls 4ND ForUm +o0Ls @CC3Ss 0N @ll ph0rUM\$!";
$lang['postcount'] = "pOs+ c0unt";
$lang['resetpostcount'] = "reSe+ po5+ C0unt";
$lang['failedtoresetuserpostcount'] = "f@il3D +0 r3sEt po\$+ coUNt";
$lang['failedtochangeuserpostcount'] = "f41lED to Ch4Ng3 user p0st CoUNt";
$lang['postapprovalqueue'] = "pOS+ apPR0val qUEU3";
$lang['nopostsawaitingapproval'] = "no p0sts @R3 4w41+iNg 4PPRov@l";
$lang['approveselected'] = "apPR0v3 \$el3C+3d";
$lang['failedtoapproveuser'] = "f41LED +0 4ppR0v3 u53R %s";
$lang['kickselected'] = "kICk \$el3C+ED";
$lang['visitorlog'] = "v1sI+or l0G";
$lang['clearvisitorlog'] = "cL34R v1\$1+0R loG";
$lang['novisitorslogged'] = "n0 VI\$It0r\$ l0GgeD";
$lang['addselectedusers'] = "add \$eL3C+ED UsER\$";
$lang['removeselectedusers'] = "rEM0ve SEleCtED U\$3r\$";
$lang['addnew'] = "aDd n3W";
$lang['deleteselected'] = "deL3Te sElECTED";
$lang['forumrulesmessage'] = "<p><b>f0RUm rUl3s</b></p><p>\nR39istr4tion +0 %1\$S i\$ phR3e! W3 Do iN\$1\$+ +h4+ J00 4b1d3 8Y TEh RUlEs @nD p0LiC1es D3t41L3d BEL0W. 1F j00 @9R33 +0 t3h +3Rm5, pl34SE chECK t3H 'i @gR3E' Ch3CKBOx @nd pR3s\$ +3H 'r3gi\$T3r' 8U+toN BEl0W. 1pH j00 w0UlD like +O c@nC3l +eh reg1\$+r4+10n, cl1ck %2\$s to re+urn +O teh ph0rums 1ndEx.</p><p>\n4l+HOu9h +eh 4dmini\$+r4+oR5 @nd M0D3r4+0Rs of %1\$S w1ll 4++empT +o K3ep 4ll 0BjeCtiON@8Le mEssA9eS 0Phf +hi5 ph0Rum, IT 1\$ imp05\$1Ble phor us +o REv13W 4Ll m3s5@gEs. 4ll M3s\$@935 Expr3ss +3h views OPh t3h aUthoR, 4nD n31TH3r +eh 0Wners of %1\$S, n0R pr0jeC+ b3eHIVe ph0Rum 4nD i+'S 4Phph1l14t3S will BE h3ld resp0n518le f0r Th3 C0nt3nt of 4ny m3s5@GE.</p><p>\n8Y 4gr3E1n9 +0 these rulEs, j00 W@rr4nt tHat J00 w1LL n0+ p0\$T any mesSA9es +h4+ 4R3 085Cene, vuLG4r, sEXUally-or13n+4+eD, h4t3phul, +hre@T3ning, or oTHErw1\$E v10L4t1ve 0Ph @nY L4ws.</p><p>tEH OwnERs 0pH %1\$S r3s3rVE teh r1ght to rEm0V3, 3d1T, m0v3 0R cloSE 4ny THRe@D pH0R 4Ny re4S0n.</p>";
$lang['cancellinktext'] = "h3r3";
$lang['failedtoupdateforumsettings'] = "f@il3D +0 UPd4+e phorUm se+t1Ngs. pL3asE +Ry A9a1N l4+3r.";
$lang['moreadminoptions'] = "m0re 4Dmin op+I0n5";

// Admin Log data (admin_viewlog.php) --------------------------------------------

$lang['changedstatusforuser'] = "ch4ngeD U53r \$+4+US PHOr '%s'";
$lang['changedpasswordforuser'] = "ch4ngeD paSsw0rd f0r '%s'";
$lang['changedforumaccess'] = "ch4ngeD pH0Rum @CCESs p3RM1\$Sion5 Phor '%s'";
$lang['deletedallusersposts'] = "del3t3d @ll pO\$+S Phor '%s'";

$lang['createdusergroup'] = "cR3atED u\$ER 9RoUp '%s'";
$lang['deletedusergroup'] = "deLEt3D u53R 9r0up '%s'";
$lang['updatedusergroup'] = "uPD@+3D usEr 9ROUp '%s'";
$lang['addedusertogroup'] = "adDED usEr '%s' TO 9r0Up '%s'";
$lang['removeduserfromgroup'] = "reM0v3 U5Er '%s' phroM gr0up '%s'";

$lang['addedipaddresstobanlist'] = "adD3D 1p '%s' T0 bAn lI\$t";
$lang['removedipaddressfrombanlist'] = "r3M0V3d ip '%s' Phr0m B4n l1\$t";

$lang['addedlogontobanlist'] = "aDd3d Lo90n '%s' +0 8@n lisT";
$lang['removedlogonfrombanlist'] = "r3M0v3D lo90N '%s' phr0M B4n L1\$T";

$lang['addednicknametobanlist'] = "aDDED n1cKN4m3 '%s' TO 8An l1\$+";
$lang['removednicknamefrombanlist'] = "r3mOV3D NickN4Me '%s' from BAn lI\$+";

$lang['addedemailtobanlist'] = "add3D 3m41l 4DDREss '%s' +o 8AN l1ST";
$lang['removedemailfrombanlist'] = "rEm0VeD em@1l adDr3Ss '%s' FroM B@N lIst";

$lang['addedreferertobanlist'] = "aDdeD r3Fer3R '%s' t0 BAn Li\$+";
$lang['removedrefererfrombanlist'] = "rEmoveD r3FErER '%s' fROM 8aN Li\$+";

$lang['editedfolder'] = "eDI+eD pHoldeR '%s'";
$lang['movedallthreadsfromto'] = "moVED 4lL +hre4d\$ phr0M '%s' t0 '%s'";
$lang['creatednewfolder'] = "cR3@+eD N3w PhoLDEr '%s'";
$lang['deletedfolder'] = "d3L3T3d f0LD3r '%s'";

$lang['changedprofilesectiontitle'] = "ch@n93D profIL3 S3C+i0N t1+lE pHrom '%s' t0 '%s'";
$lang['addednewprofilesection'] = "adDED new pR0Fil3 SECt1ON '%s'";
$lang['deletedprofilesection'] = "deL3t3D prOph1l3 \$EctioN '%s'";

$lang['addednewprofileitem'] = "adD3d n3W prophil3 1tem '%s' TO SeC+i0n '%s'";
$lang['changedprofileitem'] = "ch4n9ED pr0PhiL3 1TEm '%s'";
$lang['deletedprofileitem'] = "d3l3t3d pR0PhiL3 ItEm '%s'";

$lang['editedstartpage'] = "eD1+3D st4rt P4G3";
$lang['savednewstyle'] = "s@veD n3W s+yl3 '%s'";

$lang['movedthread'] = "moV3d THr34d '%s' phRom '%s' +0 '%s'";
$lang['closedthread'] = "cL0SED +HrEad '%s'";
$lang['openedthread'] = "openED +Hr34d '%s'";
$lang['renamedthread'] = "r3naMED ThrE4d '%s' +o '%s'";

$lang['deletedthread'] = "d3L3T3d +hr34D '%s'";
$lang['undeletedthread'] = "uNd3le+3D +Hr34d '%s'";

$lang['lockedthreadtitlefolder'] = "loCK3D tHrE4d opt10ns on '%s'";
$lang['unlockedthreadtitlefolder'] = "uNLoCk3D +Hr34d opT10n\$ on '%s'";

$lang['deletedpostsfrominthread'] = "dEl3+3D pO\$+S phr0M '%s' 1n +Hr34D '%s'";
$lang['deletedattachmentfrompost'] = "d3l3+ED attAcHM3nt '%s' phr0M PosT '%s'";

$lang['editedforumlinks'] = "eDItED phoRUm LiNks";
$lang['editedforumlink'] = "ed1t3d pH0Rum l1nK: '%s'";

$lang['addedforumlink'] = "aDdeD f0Rum L1nk: '%s'";
$lang['deletedforumlink'] = "d3l3t3D F0rUm L1Nk: '%s'";
$lang['changedtoplinkcaption'] = "cH4N9ed top liNk C4PT10n phr0m '%s' +0 '%s'";

$lang['deletedpost'] = "deLEt3d posT '%s'";
$lang['editedpost'] = "ed1+eD Pos+ '%s'";

$lang['madethreadsticky'] = "m4d3 +hREaD '%s' 5+1CKy";
$lang['madethreadnonsticky'] = "m@D3 ThrE4d '%s' non-sTicky";

$lang['endedsessionforuser'] = "eNdED sEss1ON PhoR u\$er '%s'";

$lang['approvedpost'] = "apPr0vED p0ST '%s'";

$lang['editedwordfilter'] = "eDIteD Word fiL+Er";

$lang['addedrssfeed'] = "aDd3D r5\$ Ph3ed '%s'";
$lang['editedrssfeed'] = "edI+ED R\$\$ pHEED '%s'";
$lang['deletedrssfeed'] = "deL3T3d r\$S pH3ED '%s'";

$lang['updatedban'] = "upd4teD B@n '%s'. cH4N9ed tYP3 fr0M '%s' t0 '%s', Ch4N9Ed d@+@ From '%s' +0 '%s'.";

$lang['splitthreadatpostintonewthread'] = "spl1T +hr34D '%s' 4t POs+ %s  into nEw tHr3aD '%s'";
$lang['mergedthreadintonewthread'] = "m3r93d +hr3aDs '%s' 4ND '%s' into nEw +hr34D '%s'";

$lang['approveduser'] = "aPPR0ved UsER '%s'";

$lang['forumautoupdatestats'] = "foRUm @u+o UpD4T3: \$+@tS UPD4+3D";
$lang['forumautoprunepm'] = "f0rum aUt0 upd@+E: Pm Ph0LD3Rs PrUn3D";
$lang['forumautoprunesessions'] = "foRum 4ut0 Upd@+E: 53sSI0n\$ pRUN3d";
$lang['forumautocleanthreadunread'] = "f0rum @u+0 uPDa+3: +HreAD Unre4D D4+4 ClE@N3D";
$lang['forumautocleancaptcha'] = "fOrum auT0 upD@tE: +Ext-c4PTCh4 1m49es ClE4NED";

$lang['adminlogempty'] = "adM1N l09 IS emptY";

$lang['youmustspecifyanactiontypetoremove'] = "j00 musT \$p3c1fy @N @Ct10n typ3 +0 R3m0v3";

$lang['removeentriesrelatingtoaction'] = "rEm0v3 eNtr13s r3L4+inG +0 aC+i0n";
$lang['removeentriesolderthandays'] = "reM0V3 enTRIe\$ 0lD3R Th4n (D4Ys)";

$lang['successfullyprunedadminlog'] = "succE\$sfully pRuN3D 4DM1N l0g";
$lang['failedtopruneadminlog'] = "f41l3D +o prunE @Dm1n l09";

$lang['prune_log'] = "prunE l09";

// Admin Forms (admin_forums.php) ------------------------------------------------

$lang['noexistingforums'] = "n0 3Xi\$T1nG F0RuMs phoUnD. +o cr3@+3 4 nEw phorum CliCk +eH '@dd New' BU+Ton beLow.";
$lang['webtaginvalidchars'] = "we8+@g C4n oNLY cOn+@In Upp3RCasE @-z, 0-9 AND undER5CoRE ChAr4C+eR5";
$lang['databasenameinvalidchars'] = "d@+48asE N@me C4n onLy Con+@iN @-z, @-z, 0-9 4nD Und3rSC0r3 ch@R4C+ERs";
$lang['invalidforumidorforumnotfound'] = "iNv4L1D Ph0RUm Ph1D or phOrum n0+ ph0UND";
$lang['successfullyupdatedforum'] = "suCc3ssfUllY Upd@+3d F0RuM";
$lang['failedtoupdateforum'] = "f4Il3d t0 uPD@+3 f0RuM: '%s'";
$lang['successfullycreatednewforum'] = "sUcc3S\$FULly CRE4+3d nEw F0rUm";
$lang['selectedwebtagisalreadyinuse'] = "the SEL3C+ED WeBtA9 1S @lR34Dy 1N u\$e. pl34SE CHoo\$E @n0+h3r.";
$lang['selecteddatabasecontainsconflictingtables'] = "the SEl3cteD D@+4B4\$E ConT4INs C0NFliCT1Ng t4bLEs. C0NPHl1C+iNg +@8le n4M3s 4re:";
$lang['forumdeleteconfirmation'] = "aRe j00 \$ur3 j00 W@NT to DEL3tE 4Ll oF +h3 s3LeC+3d ForUm5?";
$lang['forumdeletewarning'] = "pl3@\$E NOT3 +h4+ J00 C4NnOt REC0v3R D3leteD PhOrUms. 0nc3 d3letED @ Ph0rUM AnD 4ll oF i+'s @\$S0ci4+3d d@+4 1\$ PermanEnTly reMovED From t3H D4tab453. iF j00 d0 no+ wi5H +o dElETe tEh 5El3c+ed foRuMs pleasE CLiCk C4NCEl.";
$lang['successfullyremovedselectedforums'] = "sUccesSFUlly D3L3+3d s3l3cteD pHorUms";
$lang['failedtodeleteforum'] = "f@1led +o Del3TED f0rum: '%s'";
$lang['addforum'] = "aDD ph0rum";
$lang['editforum'] = "eD1+ f0RUM";
$lang['visitforum'] = "v1\$it f0rum: %s";
$lang['accesslevel'] = "access lEvEL";
$lang['forumleader'] = "f0RUm l3@D3r";
$lang['usedatabase'] = "uS3 d4+4b4Se";
$lang['unknownmessagecount'] = "unkn0Wn";
$lang['forumwebtag'] = "f0RUm wEBT4G";
$lang['defaultforum'] = "d3pH4ul+ phorum";
$lang['forumdatabasewarning'] = "ple4SE 3N5ure j00 sel3ct +hE c0rrEC+ dat4B@\$3 WhEn CrE4+inG 4 n3w forUM. onCe CrE4T3D @ N3w pHoRum C4NN0t bE m0vED B3+W33N @v4IlABl3 d@t4bases.";

// Admin Global User Permissions

$lang['globaluserpermissions'] = "gl08@l us3R p3Rm1SSIons";

// Admin Forum Settings (admin_forum_settings.php) -------------------------------

$lang['mustsupplyforumwebtag'] = "j00 mUst supplY @ Ph0RuM w3BT49";
$lang['mustsupplyforumname'] = "j00 must sUpply a F0Rum N4Me";
$lang['mustsupplyforumemail'] = "j00 muST supPly @ pH0Rum 3m4IL ADDr3ss";
$lang['mustchoosedefaultstyle'] = "j00 mUst Cho0sE @ d3faul+ pHorum stYlE";
$lang['mustchoosedefaultemoticons'] = "j00 must Ch00\$3 dEF4Ul+ F0RUM 3MotIC0n5";
$lang['mustsupplyforumaccesslevel'] = "j00 must supply @ ph0rum acCEss l3VEl";
$lang['mustsupplyforumdatabasename'] = "j00 mu\$T sUpPly @ phOrUm D@+4B4S3 n4m3";
$lang['unknownemoticonsname'] = "unKNOwn 3MO+icon\$ n4m3";
$lang['mustchoosedefaultlang'] = "j00 mUst Ch0053 4 deF4Ul+ ForUM l4nGU@g3";
$lang['activesessiongreaterthansession'] = "aCtive SE\$si0N +1ME0ut canNo+ BE gr34+3R +h4n 53ss10n +Im3out";
$lang['attachmentdirnotwritable'] = "a++4chmenT DiREC+0rY 4nd sY5+Em +EMpOr@Ry DiR3C+0ry / PHp.1n1 'Upl0@d_+Mp_DIr' mU5T B3 wrIt4bl3 8Y +h3 weB serV3r / PhP proC3S\$!";
$lang['attachmentdirblank'] = "j00 mUst supply 4 D1r3c+0RY +0 S4ve 4T+@CHm3Nts iN";
$lang['mainsettings'] = "m@1N s3++inGs";
$lang['forumname'] = "foRUM nAmE";
$lang['forumemail'] = "f0rum Em4Il";
$lang['forumnoreplyemail'] = "n0-r3PLy Ema1l";
$lang['forumdesc'] = "fOrum DEscr1PTion";
$lang['forumkeywords'] = "f0Rum kEyW0rds";
$lang['defaultstyle'] = "d3FAUlt styL3";
$lang['defaultemoticons'] = "deF4Ult EM0T1C0ns";
$lang['defaultlanguage'] = "d3FAULt l4NgUa93";
$lang['forumaccesssettings'] = "foRum 4CCESs s3++1n9S";
$lang['forumaccessstatus'] = "fOrum @CC3\$S 5+4tUs";
$lang['changepermissions'] = "ch@ngE p3RMissi0nS";
$lang['changepassword'] = "changE p4s\$W0rD";
$lang['passwordprotected'] = "p4S\$W0rd pR0t3C+ED";
$lang['passwordprotectwarning'] = "j00 h@VE n0+ 53t 4 forUm p45SW0rd. 1F j00 D0 not s3+ 4 p4\$SW0rd +h3 p@ssw0rD pr0t3C+i0N FUnct1ON4l1+y w1ll b3 @u+om@+IC@Lly dIs4BL3d!";
$lang['postoptions'] = "pO\$+ 0pt10n\$";
$lang['allowpostoptions'] = "aLlOW po5+ 3di+ING";
$lang['postedittimeout'] = "p0st ED1+ TiM30ut";
$lang['posteditgraceperiod'] = "po\$+ 3D1t gr@CE p3r1oD";
$lang['wikiintegration'] = "w1K1wik1 1ntegr4T10n";
$lang['enablewikiintegration'] = "eN@8l3 Wik1wik1 iNtEgr4+I0n";
$lang['enablewikiquicklinks'] = "enA8l3 wiK1wiK1 qUiCK l1Nks";
$lang['wikiintegrationuri'] = "wiKiwIki LoC4+i0N";
$lang['maximumpostlength'] = "m4X1mum p0\$+ lEn9tH";
$lang['postfrequency'] = "p0S+ fr3QUEnCy";
$lang['enablelinkssection'] = "en@8L3 links \$ect10n";
$lang['allowcreationofpolls'] = "alLow Cr34+i0N 0ph p0Lls";
$lang['allowguestvotesinpolls'] = "aLLow 9u3S+s +0 Vo+3 1n p0lLS";
$lang['unreadmessagescutoff'] = "uNre4d MEss4935 Cu+-off";
$lang['unreadcutoffseconds'] = "seconD5";
$lang['disableunreadmessages'] = "di\$4ble unr34d M3s\$49Es";
$lang['thirtynumberdays'] = "30 d4YS";
$lang['sixtynumberdays'] = "60 D4Y5";
$lang['ninetynumberdays'] = "90 DaY\$";
$lang['hundredeightynumberdays'] = "180 DAys";
$lang['onenumberyear'] = "1 y3@r";
$lang['searchoptions'] = "sE4rCh 0P+10ns";
$lang['searchfrequency'] = "s34rCh phr3qu3NCY";
$lang['sessions'] = "se\$S10N5";
$lang['sessioncutoffseconds'] = "s3Ss10N CUT oPhph (s3c0NDs)";
$lang['activesessioncutoffseconds'] = "ac+iV3 sess1on CU+ ophPh (SEC0nd5)";
$lang['stats'] = "s+4+S";
$lang['hide_stats'] = "h1de STats";
$lang['show_stats'] = "sh0w 5+@+s";
$lang['enablestatsdisplay'] = "en4Ble \$+4+5 Di\$pl4y";
$lang['personalmessages'] = "p3R\$0n4L mEss49eS";
$lang['enablepersonalmessages'] = "en@8le p3RS0N4l mess4G3s";
$lang['pmusermessages'] = "pm M3s\$@gEs p3r UsEr";
$lang['allowpmstohaveattachments'] = "allOW P3rS0n4L m3SS49Es T0 H4vE @+t4chMents";
$lang['autopruneuserspmfoldersevery'] = "au+O prUn3 u\$3r'\$ pm foLD3Rs 3VEry";
$lang['userandguestoptions'] = "uSeR AnD GU3st 0Ption\$";
$lang['enableguestaccount'] = "en@8lE gU3s+ aCC0unt";
$lang['listguestsinvisitorlog'] = "li\$t 9U3sts in V1\$i+0r Log";
$lang['allowguestaccess'] = "aLl0w GU3St 4CCESs";
$lang['userandguestaccesssettings'] = "u\$3r 4ND 9U3S+ @CC3\$\$ \$e++1NG\$";
$lang['allowuserstochangeusername'] = "aLL0w U\$eRS +0 ch4N93 U\$3rn4M3";
$lang['requireuserapproval'] = "reQU1rE UsEr 4ppRovAl 8Y aDm1n";
$lang['requireforumrulesagreement'] = "rEqu1r3 U\$3r t0 4GR3e +0 F0rum rUlE\$";
$lang['enableattachments'] = "eNAble @t+4chMEnts";
$lang['attachmentdir'] = "atTAChM3nT DIr";
$lang['userattachmentspace'] = "aTT4CHm3Nt sp4ce pEr User";
$lang['allowembeddingofattachments'] = "aLl0w 3mbEDd1n9 0ph aTtACHm3ntS";
$lang['usealtattachmentmethod'] = "u\$3 4l+eRn@+1v3 4Tt4CHMEnT m3+h0D";
$lang['allowgueststoaccessattachments'] = "alloW 9u3s+s t0 4CC3SS 4t+4CHments";
$lang['forumsettingsupdated'] = "f0ruM SEt+1N9\$ 5ucC3S\$fUllY Upd4+ED";
$lang['forumstatusmessages'] = "fORUm \$T4+us m3S\$a93s";
$lang['forumclosedmessage'] = "fOrum CLosed M35\$@Ge";
$lang['forumrestrictedmessage'] = "foruM Restr1CTeD m3S\$@93";
$lang['forumpasswordprotectedmessage'] = "f0rUM p4sSWOrd pRot3c+ED m3ss49e";

// Admin Forum Settings Help Text (admin_forum_settings.php) ------------------------------

$lang['forum_settings_help_10'] = "<b>poS+ 3Dit +1m3out</b> 1S +he +1M3 in m1NUt3S @ph+3r po\$+1ng +h4+ 4 Us3r CAn EDi+ +HEir p0s+. IPh set +0 0 +h3re I5 n0 lim1+.";
$lang['forum_settings_help_11'] = "<b>m@Ximum pos+ lEnGth</b> 1S tH3 m@x1MUm num83r oph CH4r4C+3r\$ +h4+ wilL 83 di\$pl4y3D in @ po\$+. ipH 4 pos+ is lon9Er tH@n +3H numBER 0F CHar4ct3r\$ D3F1N3d heR3 1t WILl 83 Cu+ sh0R+ 4ND 4 l1NK 4dd3d +0 +H3 80+t0m to ALLow UsER5 t0 rE4D tEH wH0Le Pos+ 0n 4 SEP4r4+e p4g3.";
$lang['forum_settings_help_12'] = "iPH j00 Don't wanT y0ur us3Rs +0 83 4blE +0 CrE4T3 Polls j00 C4N dis@8LE tHE @8Ov3 0Pt10N.";
$lang['forum_settings_help_13'] = "th3 l1Nks \$ECT1on 0F 8eeh1v3 Pr0Vid3s @ pl4c3 FOr y0UR U\$eR\$ +O m@in+@iN 4 l1\$+ OF s1+ES +HEy phREqU3NTlY vi\$i+ +H4T 0+Her u\$er\$ m4y Ph1nd u5eFUL. liNK\$ c@n B3 Div1d3D in+o Ca+E90ri3s 8Y foLD3R @nD @lL0W phor C0mmeNts 4ND r4+1n9S to 8E 9Iv3N. in 0RD3R t0 Mod3R4t3 +HE Link5 53c+i0n a Us3r mu\$T 83 R4nt3d glob@l modEratoR St4+u5.";
$lang['forum_settings_help_15'] = "<b>seS\$10n CuT 0Fph</b> 1S +3h MaxIMUm +im3 BEf0re 4 usER's sE\$SIon 1\$ D3emeD DEaD 4ND +h3y 4r3 l09ged OuT. 8Y D3f@Ul+ tHi\$ I\$ 24 HOurs (86400 seConD\$).";
$lang['forum_settings_help_16'] = "<b>aC+iv3 ses\$1on CUt ophph</b> 1\$ +he m@x1mum t1M3 beF0RE @ usEr's seSSI0n i\$ D3em3D 1n@C+iv3 4t WH1ch p01nt th3Y 3NTER @n IDl3 \$t4+3. iN +hI\$ S+4+3 +hE U\$Er r3M41N5 lo993D iN, bU+ +hEy @r3 r3MovED Fr0M tEH 4CT1vE U53r\$ lIS+ In +h3 s+4T5 d1SpL@y. oNC3 theY 83Com3 4C+ive 4G41n +hey w1ll 83 R3-aDDEd t0 +3h l1St. 8y D3f@ult +h1S setting is Set +0 15 Minu+ES (900 SEC0nd\$).";
$lang['forum_settings_help_17'] = "eN4Bling +h1\$ 0p+1ON @ll0W\$ 8eeh1v3 +0 1NclUDE 4 \$+@ts dIspl4Y @+ thE 8O++0m oph t3H M3ssa93s p@nE simIl4R +0 th3 0N3 UsED BY m4ny f0rUm \$OF+w@r3 +Itl3S. Onc3 EN@8lED +h3 d1\$PL@y oF tEh \$+A+s p@gE C4N 8E toggl3D iND1VIdU@llY BY 34Ch us3r. iph ThEy d0N'T w4nt to 5E3 1+ they can hid3 1+ FR0m view.";
$lang['forum_settings_help_18'] = "p3RsONAL ME\$S4g3\$ ARe inv4Lu4blE 4s 4 W4y oPH t4kING m0RE PRiv@+3 mA+TeR\$ 0Ut 0F Vi3W oph th3 o+hEr mEmbEr\$. how3VER iph j00 d0N't w4NT Y0UR User\$ +o 8e @8le +0 senD 3@Ch o+h3R pErsoNal m3ss49es j00 can D1\$@8le +h1S 0p+1on.";
$lang['forum_settings_help_19'] = "peR\$0n4l M3ss49es C4n @l50 COn+4in @++@CHm3NT\$ WHiCH C4n 8E u\$3fUL phOR 3xchan9ing Phile\$ b3+wEEn u\$3r5.";
$lang['forum_settings_help_20'] = "<b>nOTe:</b> +HE sp@CE @lLoCa+1ON F0R Pm 4+tachmEn+\$ IS +@kEn pHr0M 34Ch Us3Rs' mA1N @++@chm3NT alloC4+i0N aND 1S no+ 1N 4dD1T10n t0.";
$lang['forum_settings_help_21'] = "<b>en48lE gu3s+ aCC0unT</b> @LL0W\$ vis1+or\$ +o BRow\$3 your Ph0rUm aND r3@D p0\$TS wi+hoU+ reg1\$TERing 4 User 4CC0UnT. 4 Us3r 4CCOuN+ i\$ \$t1LL R3QuIr3D ipH +h3y WIsh t0 p0\$t 0R ChaNgE U\$eR pr3F3REnCE\$.";
$lang['forum_settings_help_22'] = "<b>l1S+ 9U3STs 1n vi\$iT0r lo9</b> 4ll0w\$ j00 +o \$p3CiPHY wh3+her Or n0+ unRE9I\$+3Red u53r\$ @R3 li\$+Ed On The vis1+0r LoG @loN9 \$IdE reG15+eR3d u5ERS.";
$lang['forum_settings_help_23'] = "b33H1ve @llow\$ @+T4chmEnTs t0 BE Upl04d3D tO mESS4g3s whEN Pos+ed. If j00 h@v3 LiMi+ED w38 sp@C3 j00 m@Y wh1CH t0 DIsaBL3 4++4chmeNts BY CL34rin9 the 8Ox @80v3.";
$lang['forum_settings_help_24'] = "<b>a+T@chMEn+ dIr</b> Is +h3 l0cA+1oN BEEH1ve shOulD \$TOr3 1T'\$ @tT4CHmENt5 1n. +hIs DiR3CToRY MU\$+ exis+ 0n y0ur w38 5PAC3 4nD mUs+ 8E Wri+4ble 8y +h3 wE8 sErv3R / PhP pr0c3\$S 0therWi\$e upL0ads will pHa1l.";
$lang['forum_settings_help_25'] = "<b>aTtaChmEnt sp4C3 P3r user</b> 1\$ Th3 m4xiMuM 4M0UN+ 0ph D1\$K sPacE 4 us3r h@5 f0R 4tt@CHmEnTs. onc3 +h1S \$P@CE 1\$ UsED Up th3 U\$3r C4NnO+ UpLo@D any m0r3 AttAChM3Nts. 8y D3F4ul+ +hiS Is 1M8 0PH sp4ce.";
$lang['forum_settings_help_26'] = "<b>alLOW 3MBEDding 0F 4t+@chm3nts in m3ss49es / s1gn@+Ur3s</b> alLOW\$ UseRs to 3m83d 4+t4CHm3nt\$ 1n P0\$+S. 3na8l1Ng +His Opti0N Wh1lE UsEFuL C4N iNCR3@S3 y0ur BAndWiD+h U\$4g3 DR4\$+1C@LlY Und3r cER+4In CoNFigurat10n\$ Oph php. 1F j00 H4ve l1Mit3D 84NDwid+h iT 1\$ R3C0mM3nded th4+ j00 di\$4ble th1s 0PT10N.";
$lang['forum_settings_help_27'] = "<b>u\$3 @Lt3rn@+1V3 4t+@CHMEnT mEtH0d</b> F0rcE\$ 8EEH1v3 t0 us3 An 4lterN4TivE rETrIEv4L ME+H0D f0r 4t+@CHmenT5. 1ph j00 r3c31v3 404 3RroR mEss4g3S wh3N +ryInG T0 D0WnLo4d aT+@ChmeNts Fr0M mESs@ges +rY 3N@BL1nG +His 0ptIOn.";
$lang['forum_settings_help_28'] = "tHIs se+t1ng @LL0w5 YOUr f0RUm +0 8e spID3r3D 8y s34rcH eNgiNEs lIKE G00gl3, @L+4Vi\$+4 AND yAhoo. 1ph J00 \$w1+Ch th1\$ 0p+I0N 0fph y0ur ph0RUM wiLl n0+ 8e incLUd3D in +h3se sE4Rch 3n9InEs r3sUlT5.";
$lang['forum_settings_help_29'] = "<b>aLL0w nEw U53R rE9IS+r4+10n\$</b> @LL0ws 0R Dis4LL0w\$ +H3 CRE4+1ON opH new u\$ER acC0unts. se++1NG th3 0pt10n t0 no C0mpletElY D1\$4BlEs +he r3g1s+R@+1On pH0Rm.";
$lang['forum_settings_help_30'] = "<b>eN48le w1K1w1ki In+egraT10n</b> PRovides wIkiw0rd 5UPp0rt IN your F0RuM po\$+s. a w1kiW0rd is m@D3 up 0Ph tw0 or MorE C0nc4TEn@+eD w0RdS W1th UpP3RC@se l3+tEr\$ (oph+3n rEfErrEd +0 4\$ c4m3LC@\$3). IPH j00 wr1+e @ wOrd th1\$ w@Y 1+ w1LL @Utomat1CALly 83 ch@ng3D int0 @ hyp3rlINk point1n9 +0 y0Ur cho\$EN wiK1w1kI.";
$lang['forum_settings_help_31'] = "<b>eN4Ble w1Kiw1KI qu1ck liNks</b> En4bl3s tEH usE 0Ph Ms9:1.1 @nD UsEr:l09On styL3 Ex+3NDED Wik1l1Nks wH1CH CRE4T3 HyP3rl1nks t0 TEH \$p3CiFi3D mEss49e / U5er pr0PHIl3 0pH th3 \$p3CIfiED uSEr.";
$lang['forum_settings_help_32'] = "<b>wiKIw1kI loc4+10n</b> Is u5eD t0 sp3ciFy T3h Ur1 0F Y0ur w1k1wiki. wH3n En+Ering +hE UR1 UsE <i>%1\$s</i> to 1nDic@+3 wHErE In +He uR1 +h3 WIKiw0RD \$HOUlD 4PPEar, 1.3.: <i>h+tP://En.wik1p3D14.or9/wIki/%1\$\$</i> woulD liNk youR w1K1WORd5 +O %s";
$lang['forum_settings_help_33'] = "<b>fOrum @CC3S\$ STATus</b> cONTr0L5 h0w US3r\$ m@Y 4CC3SS your F0rUM.";
$lang['forum_settings_help_34'] = "<b>op3n</b> w1LL 4LL0W 4Ll U\$3rs 4ND 9U3\$TS @cce\$s +o your fOrUm w1+H0U+ r3Str1C+10N.";
$lang['forum_settings_help_35'] = "<b>cl0SED</b> PrEvEnt\$ @cC3ss foR 4Ll uSER\$, W1+h +3H Exc3P+I0n 0Ph +3h 4Dmin who M4y st1Ll 4Ccess +eh @DM1n p4NeL.";
$lang['forum_settings_help_36'] = "<b>r3S+riCTed</b> 4llows tO \$3t a l1S+ of UsEr\$ WH0 4RE 4ll0W3D @Cc3ss t0 yoUr f0RUM.";
$lang['forum_settings_help_37'] = "<b>p4\$sworD pRotECteD</b> aLLOws j00 to \$3t 4 p4\$sw0Rd T0 9ive 0UT +0 U\$ER5 S0 theY C4N 4cC3ss YoUr Ph0rum.";
$lang['forum_settings_help_38'] = "wHen sett1N9 r3S+RiC+3d or p45\$worD pr0+3C+eD MoD3 j00 wiLl ne3d T0 savE yOUr cH@N93s b3F0R3 J00 C4N Ch@nG3 th3 u53r @CC3\$\$ pr1ViLEgE\$ OR p4\$SW0RD.";
$lang['forum_settings_help_39'] = "<b>Search Frequency</b> defines how long a user must wait before performing another search. Searches place a high demand on the database so it is recommended that you set this to at least 30 seconds to prevent \"search spamming\"frOm Killing +3h sErv3R.";
$lang['forum_settings_help_40'] = "<b>po5t fr3QU3nCy</b> iS Teh m1N1mum +1ME 4 U\$ER mU5T w41+ 83F0RE TH3y caN po\$+ 4941n. +h1\$ \$E++1ng @lso 4fFECTs +He CRE4tIon oph p0LLs. \$3t To 0 to D1S@8LE +h3 re\$TriC+i0N.";
$lang['forum_settings_help_41'] = "tHE A80ve op+i0N\$ Ch4ng3 +h3 D3f4uL+ v4lu3S phor tHe user rE9I\$tr4t10n phorm. Wh3RE @PPlic@BLe 0thER se+tin9s wIll usE +h3 forUm's oWN D3ph@ULt s3TT1n9\$.";
$lang['forum_settings_help_42'] = "<b>pR3venT usE 0PH DUPlIC@+3 3ma1l 4DdrE\$se\$</b> fORC3S 8e3HiV3 T0 ch3ck +3H UseR @CCoUnT\$ @94ins+ +HE 3M4Il 4dDR3ss +hE usEr 1\$ R39i\$+3r1Ng w1+H @nd pR0Mpt5 TH3m +0 U\$3 4no+hER 1f I+ i\$ alR3ADy 1n UsE.";
$lang['forum_settings_help_43'] = "<b>rEqu1r3 ema1L C0npH1rm4TiOn</b> WhEn 3n4BLED wIll \$eNd @n Em41l To e4ch N3W U\$3r wI+H @ l1nk +H4t C4N be u53d +0 C0nph1RM th31r 3M@iL 4DDR35s. UnT1l +hEY c0npHirm thE1r 3m@il 4DDrEss +h3Y will n0+ 83 @8Le +0 po5T unless tH31R u\$er permiss10N\$ ar3 Ch4n93d m4nu4lly 8y @N @dm1N.";
$lang['forum_settings_help_44'] = "<b>us3 TEx+-CaptCh@</b> PREsen+s tHE NeW U53r wiTH a m4ngl3d im493 wHiCH +hey MuS+ Copy 4 NUm83R Phrom 1Nt0 4 +Ex+ pH1ElD 0n tEh r3G1\$TR4TioN phorM. U\$e +Hi5 0P+10n +o prevENt 4UtoM@+3D SIgN-up v14 \$CRipts.";
$lang['forum_settings_help_45'] = "<b>t3x+-C4P+CH@ DIr3ctory</b> 5p3C1Ph13s tH3 l0C4+i0N thaT b33H1V3 w1ll \$+Ore i+'\$ +3xt-C@p+Ch4 1ma93s 4nD Fonts in. +his d1R3ctory Must 8e wr1+@8lE 8Y +3h wEB \$ErvEr / pHp pr0c3ss 4nD must B3 4cc3Ss1BLE vi@ ht+p. AfteR j00 H4ve enA8lED +Ex+-CaptCh@ J00 MUs+ upLO@d sOM3 trU3 +ype f0n+s into +h3 fon+S sub-D1R3C+oRY of YOur m4in +ex+-C4Ptch4 DIr3C+0ry 0+herwis3 BeEHiv3 W1LL 5kip +h3 Tex+-c4ptCha during U53r r391\$Tra+10n.";
$lang['forum_settings_help_46'] = "<b>Text Captcha key</b> allows you to change the key used by Beehive for generating the text captcha code that appears in the image. The more unique you make the key the harder it will be for automated processes to \"guess\"tHe coD3.";
$lang['forum_settings_help_47'] = "<b>poS+ ED1T gR@C3 p3riod</b> 4ll0ws j00 +o dEf1ne @ pEr1OD 1N MinU+3S wh3rE u\$3r\$ M4y edI+ p05+s Wi+H0U+ +H3 '3D1+eD BY' tExt 4PP34ring 0N tHEir p0S+5. 1f \$Et +0 0 +h3 '3di+ED BY' Text wiLL aLw@Ys app34r.";
$lang['forum_settings_help_48'] = "<b>unr3@D mEss4g3s cU+-oFF</b> speC1f13s h0W loN9 M3ssA93s REmA1N UnR34d. thrE4ds m0D1pHi3D n0 l4+3R Th@N T3h P3Ri0d \$el3CTED wiLl @UTom4t1CAlLy 4PPE4r 4S R3AD.";
$lang['forum_settings_help_49'] = "cH0o\$INg <b>d1s48L3 Unr34d Mess49Es</b> W1ll comPlE+ely rEmoV3 UnR34d mEss49e\$ supP0r+ @nD rEmov3 t3H r3l3Van+ oPt1ons from Th3 Di\$cuss1on +ypE DroP D0Wn On th3 THR3@D l1S+.";
$lang['forum_settings_help_50'] = "<b>r3qu1r3 u\$er 4PpRoV@L 8Y @DM1N</b> 4llow5 j00 +0 rEs+rICt 4ccess 8y NEw User\$ un+1L +h3y h4v3 8e3N 4Ppr0V3d by 4 moDEr@+0R 0R @dmIn. w1+H0Ut aPpr0V4L @ user C@nnot 4cc3ss 4ny 4Re4 0f tH3 B3eh1V3 f0RUm ins+@LlAt10n 1NClUDiNg InDiViDual f0rUm5, pm In8ox AnD my f0rUms seC+i0ns.";
$lang['forum_settings_help_51'] = "u\$3 <b>clo\$Ed M3\$SA9e</b>, <b>r3S+riCtEd m3SSage</b> @nD <b>p4ssW0rd ProtECT3D mEss@9E</b> T0 CU\$+OmIS3 the ME\$S493 dIspl@yEd Wh3N UseRS @cc3S\$ y0ur f0RUM 1N thE V@ri0Us 5T@tes.";
$lang['forum_settings_help_52'] = "j00 c4N U\$3 htMl iN y0UR MEs54G3s. hypERl1nkS 4nd EM@1L 4dDR3s\$3\$ wIlL @l\$o Be 4Utom4+iC4LlY CoNveRT3d +0 LInKs. +o UsE +eH D3PHauLT 83Eh1V3 f0RuM M3SSa93\$ CLe4R +eH F13lD\$.";
$lang['forum_settings_help_53'] = "<b>aLLow us3Rs +o ChAnge UsERN@ME</b> P3rm1+\$ 4lr3@Dy R3g1\$+ER3D Us3r\$ T0 Ch4Ng3 thEiR u\$eRN@M3. WH3n en@BleD j00 Can +r@CK tH3 Ch4N93s @ usEr M@k3s +0 +HE1r UserN4mE Vi4 TEh @Dmin USEr tools.";
$lang['forum_settings_help_54'] = "u\$3 <b>foRUM rulE\$</b> TO 3ntEr 4n 4Cc3pt48le U53 pol1CY +H4+ EaCh Us3R mU5+ 49R3E t0 BEForE r3g1s+3R1n9 on YoUr f0ruM.";
$lang['forum_settings_help_55'] = "j00 can U\$e htmL 1n y0Ur phoRUm Rul3S. hYp3Rl1nks 4ND em4IL 4ddRE\$S3s w1Ll @lso BE @utom4+1C4LLY ConVErt3D to lInks. to Us3 +H3 D3PH@ulT B3EH1v3 PH0rUm auP CL3@r +Eh f1ELD.";
$lang['forum_settings_help_56'] = "u\$3 <b>n0-REPLY 3m4Il</b> T0 sp3CIphY 4n 3M4Il 4dDrEsS +h@+ Do3S n0t Ex1\$+ or w1Ll n0t bE m0N1+0rED PhOr r3PLIE\$. tH1s 3M4il 4DDREss Will 83 useD in +H3 HE4D3r\$ f0R @Ll Ema1ls sEN+ froM yoUR phorUm iNCLud1ng 8u+ No+ l1M1t3D +0 po\$+ @nD Pm n0+1Ph1c4+10n5, user 3M4il\$ @ND p@s\$wORD r3MInd3rs.";
$lang['forum_settings_help_57'] = "i+ iS r3COmMEnD3d +h@+ j00 u\$3 4N EM41l @dDR3ss +H4+ do3S no+ 3X1s+ +0 help CUT D0WN on spam th4+ m4Y BE dir3cTED @T yoUr m@in Ph0RUm EM4Il 4DDREss";

// Attachments (attachments.php, get_attachment.php) ---------------------------------------

$lang['aidnotspecified'] = "a1D n0t sp3ciFieD.";
$lang['upload'] = "uPloaD";
$lang['uploadnewattachment'] = "uPlo4d NEw 4t+4chmEnt";
$lang['waitdotdot'] = "w4it..";
$lang['successfullyuploaded'] = "sUcCEs\$FULly upl04d3d: %s";
$lang['failedtoupload'] = "f@1lED +o UPl04D: %s";
$lang['complete'] = "cOMPl3T3";
$lang['uploadattachment'] = "upLO4d 4 phil3 For 4+T4chmenT to +he m3Ss49e";
$lang['enterfilenamestoupload'] = "eN+er f1l3N4me(s) +o UpLo@d";
$lang['attachmentsforthismessage'] = "at+aChm3n+\$ phor THI\$ m3sS4g3";
$lang['otherattachmentsincludingpm'] = "oTher at+@CHm3nts (InCLUD1NG pM MEss@Ges @nD oThEr phoRUm\$)";
$lang['totalsize'] = "t0t@L s1z3";
$lang['freespace'] = "fre3 5Pac3";
$lang['attachmentproblem'] = "tHER3 W45 @ pr0blEm Downlo4DInG +H1\$ at+@ChmEnt. pL34s3 tRy aG4in l4t3R.";
$lang['attachmentshavebeendisabled'] = "at+4ChMEn+s h4ve B3en Dis@8LED BY t3H F0ruM oWn3r.";
$lang['canonlyuploadmaximum'] = "j00 c@N onLY UpLo4D 4 M@ximum oph 10 f1L3s @+ @ +iM3";
$lang['deleteattachments'] = "d3L3+E @t+AChMEn+s";
$lang['deleteattachmentsconfirm'] = "aRe J00 5urE j00 w@nt t0 dEL3+3 +Eh \$3l3c+3d 4+t4CHmenTs?";
$lang['deletethumbnailsconfirm'] = "ar3 j00 sur3 j00 w@n+ +0 DEl3T3 +h3 SeL3c+3D @++4chMEn+s +hUm8n@iLs?";

// Changing passwords (change_pw.php) ----------------------------------

$lang['passwdchanged'] = "p@sSW0rd ch4NgED";
$lang['passedchangedexp'] = "y0Ur p45\$WORd H4S 83en ChaN9ED.";
$lang['updatefailed'] = "upd4+e F41l3D";
$lang['passwdsdonotmatch'] = "p4SsworDs do not M4+Ch.";
$lang['newandoldpasswdarethesame'] = "neW 4nD 0ld p4s\$w0rDs @r3 thE samE.";
$lang['requiredinformationnotfound'] = "r3QUIr3d INf0rma+1ON N0T F0UND";
$lang['forgotpasswd'] = "f0rGOT p4\$sworD";
$lang['resetpassword'] = "r3\$3+ PA5\$W0rd";
$lang['resetpasswordto'] = "re\$3+ p@\$sWORd +0";
$lang['invaliduseraccount'] = "inV@lid Us3R @CC0UnT sP3C1f13D. ch3ck 3M4IL f0r corReCT link";
$lang['invaliduserkeyprovided'] = "inv@Lid u\$3r K3y prOv1D3d. CHECk Em4il For CorRECT Link";

// Deleting messages (delete.php) --------------------------------------

$lang['nomessagespecifiedfordel'] = "n0 ME5\$49e \$p3CiPh13D Phor DEL3t1ON";
$lang['deletemessage'] = "deL3TE mEss49e";
$lang['postdelsuccessfully'] = "poS+ D3l3TED SuCCEssFUlLy";
$lang['errordelpost'] = "error DEl3+1N9 POs+";
$lang['cannotdeletepostsinthisfolder'] = "j00 CAnnO+ D3lete pOst5 in Th1\$ f0LDeR";

// Editing things (edit.php, edit_poll.php) -----------------------------------------

$lang['nomessagespecifiedforedit'] = "nO mEss493 \$p3cIfieD phoR Edi+ing";
$lang['cannoteditpollsinlightmode'] = "c4NN0+ 3d1+ poLl\$ IN li9h+ M0DE";
$lang['editedbyuser'] = "ed1Ted: %s 8y %s";
$lang['editappliedtomessage'] = "eD1t 4pPli3D +0 m3s\$@gE";
$lang['errorupdatingpost'] = "erR0r upD4T1N9 p05+";
$lang['editmessage'] = "ed1+ M3ss4G3 %s";
$lang['editpollwarning'] = "<b>nOte</b>: eD1+Ing CERt41n aSp3ct\$ 0f 4 p0Ll W1ll voiD @lL t3h CurrenT v0tEs 4nd AlL0W pE0pl3 +o v0+e @94In.";
$lang['hardedit'] = "h4rd ED1+ oPt10N\$ (voTes w1Ll be re\$e+):";
$lang['softedit'] = "s0ft ED1+ 0p+I0ns (v0T3s wilL 8e RE+@In3d):";
$lang['changewhenpollcloses'] = "cH@n93 wHEN +EH poLl CL0s35?";
$lang['nochange'] = "n0 CH@ng3";
$lang['emailresult'] = "em41l resUlt";
$lang['msgsent'] = "m3sS@GE \$3nt";
$lang['msgsentsuccessfully'] = "meSsa93 SENt suCC3S5phulLy.";
$lang['mailsystemfailure'] = "m@Il sy\$tEM ph4iluR3. m3Ss4g3 n0+ \$3nT.";
$lang['nopermissiontoedit'] = "j00 @re nOt pERmi+tED +0 3di+ +his m3SS4G3.";
$lang['cannoteditpostsinthisfolder'] = "j00 C@nn0+ 3dIT P0sTs 1n thI\$ F0lder";
$lang['messagewasnotfound'] = "m3ss4gE %s W4s no+ Ph0und";

// Email (email.php) ---------------------------------------------------

$lang['sendemailtouser'] = "seND Ema1L to %s";
$lang['nouserspecifiedforemail'] = "no u\$er \$p3CiFied phOr Em41ling.";
$lang['entersubjectformessage'] = "eNter @ \$UBJ3c+ f0R +3H mess@GE";
$lang['entercontentformessage'] = "enter \$0m3 COn+3NT F0R +3h m3s5493";
$lang['msgsentfromby'] = "thI\$ ME\$S4g3 W45 s3N+ Fr0m %s bY %s";
$lang['subject'] = "sU8j3C+";
$lang['send'] = "sEnd";
$lang['userhasoptedoutofemail'] = "%s H@s 0ptED 0Ut 0F 3M@Il COnTac+";
$lang['userhasinvalidemailaddress'] = "%s Has 4n 1Nv4Lid 3m4il 4dDrEss";

// Message nofificaiton ------------------------------------------------

$lang['msgnotification_subject'] = "m3Ssa93 notIPHiCA+10n fr0m %s";
$lang['msgnotificationemail'] = "h3ll0 %s,\n\n%s pOS+eD @ MESs@ge to j00 On %s.\n\n+h3 suBj3C+ i\$: %s.\n\n+o R34d th@+ m3ss49E 4nD 0thers in th3 s4m3 DI\$cu\$Si0N, g0 to:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nNOTe: if j00 DO no+ W1sh +0 r3c31VE 3mA1l nO+if1C4+ioN5 OF ph0rum Me\$S4g3s P0s+3d T0 yOU, 9o T0: %s cL1cK on my C0N+r0ls +h3n EM4il and prIV@cy, UN5el3C+ +3H 3m4Il no+IPh1CaTIOn ch3CkBox @nd preSS submi+.";

// Thread Subscription notification ------------------------------------

$lang['subnotification_subject'] = "sUbscRip+i0N noTipHic4+i0N Fr0m %s";
$lang['subnotification'] = "hElL0 %s,\n\n%s p0STED 4 M3ss49E iN @ +Hr3ad j00 h4v3 \$UbsCr18ED t0 On %s.\n\nthE sUBj3ct 1\$: %s.\n\nto Re4d +h4+ m3Ss49e 4ND 0+hErs In tEh 54m3 DiSCU5SIOn, g0 to:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nN0tE: iF j00 DO no+ Wi\$H t0 Rec31ve em4Il n0+if1C@+i0N\$ OF nEw mess4g3\$ in th1\$ threaD, g0 To: %s @nd 4Dju\$T y0ur 1NterESt leveL at TH3 80Ttom of +Eh p@93.";

// PM notification -----------------------------------------------------

$lang['pmnotification_subject'] = "pM N0+iPhiCA+1On Fr0M %s";
$lang['pmnotification'] = "h3ll0 %s,\n\n%s pos+3D @ Pm T0 J00 0N %s.\n\n+H3 5UBJECt is: %s.\n\nto re4D th3 Me\$S493 90 to:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nn0T3: 1f j00 DO n0T w1\$H to r3ceiv3 3m@IL no+iph1C@T1Ons 0Ph n3W pM m3ss4g3S p0St3D +0 y0U, g0 +o: %s cl1cK my contr0lS +hen 3m4il and prIV@cy, UN53LeC+ +HE pm n0+iph1C@tioN Check80X 4nd pr3\$S suBmi+.";

// Password change notification ----------------------------------------

$lang['passwdchangenotification'] = "p45\$WoRD ChAnge N0TiphiCA+I0N Fr0m %s";
$lang['pwchangeemail'] = "hell0 %s,\n\n+h1\$ 4 noT1f1C4+i0N Ema1l T0 inf0rM j00 +H4+ yoUr p4SsWorD 0n %s h4S B3en ch4N9ed.\n\nI+ h4S B33n CH@n9ED +o: %s 4Nd w4\$ CH4nged By: %s.\n\n1PH j00 h@vE r3C31v3D +his 3MA1l 1N 3rrOR Or wER3 n0T 3xpECT1Ng @ CHan9e +0 y0UR Passw0rd pLEasE coNt4C+ +3H phoRUM 0wnER or 4 M0DEr4+0R 0n %s iMM3d1@+ely +O C0rr3C+ it.";

// Email confirmation notification -------------------------------------

$lang['emailconfirmationrequired'] = "eM4il c0nPH1rm4+i0N ReQU1r3D F0r %s";
$lang['confirmemail'] = "h3Llo %s,\n\nyou r3Cen+Ly Cr34+3d 4 NEw UsEr AcC0un+ oN %s.\nb3forE j00 C@n s+4rT po\$+ing w3 Ne3d t0 ConphirM y0ur eM4IL adDRE\$s. DOn't w0Rry +H1\$ i\$ QUi+3 e4\$Y. 4Ll j00 NeeD +o Do I\$ clICk th3 link 8El0w (OR copy @nD p4\$+3 1+ in+0 yOur Br0W53r):\n\n%s\n\n0nC3 conf1rm@tiON 1\$ C0mpl3T3 j00 M@y l091N @nd 5+4rt p0\$+1ng 1mmeD14+Ely.\n\nIph j00 DID n0+ Cr3@+e a usER @cc0UNt on %s Pl34se @cC3P+ 0UR 4p0log13S 4nD f0rw4RD +h1s 3m@1l To %s so +h4+ +he 5OURce 0Ph 1+ m4y Be inv3St19@ted.";
$lang['confirmchangedemail'] = "heLl0 %s,\n\nyou rEC3n+ly CH@nG3d yoUr 3M4IL 0n %s.\nBEFOrE j00 C4n \$+@RT pos+inG a941N wE N3ED +o COnfIrm Y0uR n3W Em41l @DdRE\$s. d0n't w0rrY th1S i\$ Qu1+3 34sy. @ll j00 n3eD t0 Do 1\$ cL1Ck +3h l1Nk 8EL0w (0R c0py 4ND p@5+E i+ 1NT0 y0Ur BROw\$ER):\n\n%s\n\n0NC3 COnfirm4T10n 1s completE j00 m4Y c0n+inu3 t0 UsE +eh F0rum @s n0rm4l.\n\niph j00 w3re n0+ 3xpeC+inG th1\$ 3m@il fR0m %s pl34s3 4CC3pt 0Ur 4p0L0giE\$ 4nD forward +h1\$ Em4IL +O %s s0 +h@+ teh \$0uRC3 0ph 1+ m4y 8e 1nveSTi94+ED.";


// Forgotten password notification -------------------------------------

$lang['forgotpwemail'] = "h3Llo %s,\n\nYOU r3Qu3STED +H1s 3-m41l PhR0M %s 8EC@Use j00 h4V3 F0Rg0T+3N yoUR p45swoRD.\n\ncliCk th3 liNk b3LOW (or C0Py @ND P4sTE i+ iNt0 y0ur Br0wsEr) t0 RES3t y0UR p4\$\$W0rD:\n\n%s";

// Forgotten password form.

$lang['passwdresetrequest'] = "y0ur p4s\$WOrD R3s3t rEqUE5T Fr0M %s";
$lang['passwdresetemailsent'] = "pASsw0RD r3SE+ 3-m41L \$3nt";
$lang['passwdresetexp'] = "j00 5HouLd Shor+lY rEC31VE 4n e-m@iL C0NT4iN1n9 In\$+ruc+i0N\$ f0r R3\$E+t1ng yoUr PAsSWorD.";
$lang['validusernamerequired'] = "a V4L1d U\$3rN4Me Is REQU1R3d";
$lang['forgottenpasswd'] = "f0R9ot P4\$\$W0rD";
$lang['couldnotsendpasswordreminder'] = "couLd N0+ \$3Nd Passw0rd R3m1NdER. PlE4S3 C0nt4CT tHE Phorum 0wn3R.";
$lang['request'] = "r3queST";

// Email confirmation (confirm_email.php) ------------------------------

$lang['emailconfirmation'] = "em@1L Conf1Rm4t10N";
$lang['emailconfirmationcomplete'] = "th4nK j00 f0r cOnFIrm1Ng youR 3M4il 4ddR3\$5. j00 m4y NOw LogiN @nD s+4r+ p0ST1n9 IMMeDI4+3ly.";
$lang['emailconfirmationfailed'] = "eM4iL confIrm@+1On H4s FailED, pL3aS3 try 49a1N l@+eR. IF j00 EncouNTer tHi\$ 3rROR Mul+ipl3 TimeS pl345e C0nT@cT +eh F0RUm oWNer OR @ m0D3R4tor PH0r @sS1st4nCE.";

// Links database (links*.php) -----------------------------------------

$lang['toplevel'] = "tOP L3V3l";
$lang['maynotaccessthissection'] = "j00 M4y Not 4cC3Ss +hiS \$3C+1On.";
$lang['toplevel'] = "tOp lEvEl";
$lang['links'] = "l1NKs";
$lang['viewmode'] = "vi3w M0de";
$lang['hierarchical'] = "hi3r4RChiCAL";
$lang['list'] = "l1S+";
$lang['folderhidden'] = "th1s f0lDEr i\$ HiDDEN";
$lang['hide'] = "hIdE";
$lang['unhide'] = "unH1d3";
$lang['nosubfolders'] = "nO 5uBfoldEr\$ in th1S C4+390ry";
$lang['1subfolder'] = "1 \$U8f0lDEr in +Hi\$ c4+390ry";
$lang['subfoldersinthiscategory'] = "subf0LDErs iN +hI\$ C4+390ry";
$lang['linksdelexp'] = "en+RIES iN @ DElE+eD ph0lD3r wilL 83 m0VED +0 +hE p@REnt F0LDEr. 0NLy f0lD3r5 which D0 n0+ C0n+@1n SU8pholDER\$ M@Y 8e dEl3TED.";
$lang['listview'] = "l1s+ vi3W";
$lang['listviewcannotaddfolders'] = "c4Nno+ @dD pholDERs in +hi5 vi3w. \$hOW1Ng 20 en+r13s 4+ @ +iM3.";
$lang['rating'] = "r@t1NG";
$lang['nolinksinfolder'] = "n0 lINK\$ 1n Thi\$ pHOLDER.";
$lang['addlinkhere'] = "aDD l1nK h3re";
$lang['notvalidURI'] = "tH4t I\$ NOT @ v4liD Uri!";
$lang['mustspecifyname'] = "j00 mUst SPEC1fy a nAmE!";
$lang['mustspecifyvalidfolder'] = "j00 mUs+ 5P3C1fy a v4L1D F0lDER!";
$lang['mustspecifyfolder'] = "j00 must sp3CIphY 4 ph0LD3r!";
$lang['successfullyaddedlinkname'] = "sucC3\$SfuLLY aDDED l1Nk '%s'";
$lang['failedtoaddlink'] = "f@il3d +0 4dd LinK";
$lang['failedtoaddfolder'] = "f4Il3d +O 4DD ph0lder";
$lang['addlink'] = "adD 4 l1nk";
$lang['addinglinkin'] = "aDding l1nk 1N";
$lang['addressurluri'] = "adDR3s\$";
$lang['addnewfolder'] = "aDD 4 new F0lD3R";
$lang['addnewfolderunder'] = "adD1N9 N3w f0ldEr unD3r";
$lang['editfolder'] = "ed1+ pHoldEr";
$lang['editingfolder'] = "eDIT1nG FoldEr";
$lang['mustchooserating'] = "j00 mu\$+ chO05e @ R4T1N9!";
$lang['commentadded'] = "yOur COmm3nT w@s @DDED.";
$lang['commentdeleted'] = "c0mm3nt w4S DEl3T3D.";
$lang['commentcouldnotbedeleted'] = "c0mm3n+ C0UlD no+ BE D3l3t3D.";
$lang['musttypecomment'] = "j00 Must typ3 4 cOmMEnt!";
$lang['mustprovidelinkID'] = "j00 mu5+ proVID3 4 LINk iD!";
$lang['invalidlinkID'] = "inv4l1D l1Nk ID!";
$lang['address'] = "aDdr3ss";
$lang['submittedby'] = "subm1++ED 8y";
$lang['clicks'] = "cl1cks";
$lang['rating'] = "r@ting";
$lang['vote'] = "v0te";
$lang['votes'] = "voT3S";
$lang['notratedyet'] = "not r4+3D 8Y @ny0n3 Y3+";
$lang['rate'] = "raT3";
$lang['bad'] = "b4D";
$lang['good'] = "g00D";
$lang['voteexcmark'] = "v0+e!";
$lang['clearvote'] = "cL34r Vo+3";
$lang['commentby'] = "c0MM3nt by %s";
$lang['addacommentabout'] = "aDd 4 c0mM3nt a80ut";
$lang['modtools'] = "modEra+10N t00ls";
$lang['editname'] = "eD1+ n4M3";
$lang['editaddress'] = "eD1t 4dDres\$";
$lang['editdescription'] = "eDI+ d3SCR1p+i0n";
$lang['moveto'] = "m0VE t0";
$lang['linkdetails'] = "l1Nk DEt4il5";
$lang['addcomment'] = "aDd C0MM3nt";
$lang['voterecorded'] = "your vo+e h@\$ b3En reC0rd3d";
$lang['votecleared'] = "yoUr voT3 H4s 833n clEaRED";
$lang['linknametoolong'] = "l1nk n4M3 t00 l0n9. mAximuM 1S %s CH4R4CTER5";
$lang['linkurltoolong'] = "l1NK url Too lon9. M4x1mUm 1\$ %s ch@R4CT3r\$";
$lang['linkfoldernametoolong'] = "fOLdEr n4Me t0O Long. M4xiMUm LEn9+h 1S %s Ch4R4C+3r\$";

// Login / logout (llogon.php, logon.php, logout.php) -----------------------------------------

$lang['loggedinsuccessfully'] = "j00 l09GED in \$uccEssFUlly.";
$lang['presscontinuetoresend'] = "pR3sS Con+1NuE +0 rEs3nD F0Rm d4T@ or CAnC3L to rELo4D Pa93.";
$lang['usernameorpasswdnotvalid'] = "t3h usErn4m3 0R pA5\$w0rD j00 \$upPl13D Is n0T V4L1D.";
$lang['rememberpasswds'] = "reM3M8er P4s\$w0rds";
$lang['rememberpassword'] = "r3mEM8er p@\$sword";
$lang['enterasa'] = "eNt3r @\$ @ %s";
$lang['donthaveanaccount'] = "doN'T h@v3 4n 4CC0unt? %s";
$lang['registernow'] = "r3gISTEr now.";
$lang['problemsloggingon'] = "pro8l3ms lo99inG on?";
$lang['deletecookies'] = "deL3TE CooKi3S";
$lang['cookiessuccessfullydeleted'] = "cO0kie5 \$UCce5\$FULlY DEletED";
$lang['forgottenpasswd'] = "f0R9oT+3N yoUr p4\$sw0rD?";
$lang['usingaPDA'] = "us1NG 4 pD4?";
$lang['lightHTMLversion'] = "l19ht hTML vErs1On";
$lang['youhaveloggedout'] = "j00 h4V3 loGGED oUt.";
$lang['currentlyloggedinas'] = "j00 4RE CUrREntly l0g9ED iN 4s %s";
$lang['logonbutton'] = "lOg0n";
$lang['otherbutton'] = "o+H3R";
$lang['yoursessionhasexpired'] = "your 53sS10n h@\$ 3XP1r3d. j00 wILl n3ED +0 login @g4In +o C0nt1NuE.";

// My Forums (forums.php) ---------------------------------------------------------

$lang['myforums'] = "my Ph0rums";
$lang['allavailableforums'] = "alL 4V4il4bL3 PhorUms";
$lang['favouriteforums'] = "f4voURI+e PHOrums";
$lang['ignoredforums'] = "iGn0rED f0RUm5";
$lang['ignoreforum'] = "ignorE f0RUM";
$lang['unignoreforum'] = "uni9n0re F0rUm";
$lang['lastvisited'] = "l45+ Vi\$ITeD";
$lang['forumunreadmessages'] = "%s unre@D mE5\$49Es";
$lang['forummessages'] = "%s me5\$49ES";
$lang['forumunreadtome'] = "%s unrE@D &quot;t0: mE&quot;";
$lang['forumnounreadmessages'] = "n0 unre4d Mess49es";
$lang['removefromfavourites'] = "r3mov3 fr0M pH4VouR1+3S";
$lang['addtofavourites'] = "add +0 ph@v0Ur1+es";
$lang['availableforums'] = "avA1l48Le F0RuM\$";
$lang['noforumsofselectedtype'] = "tH3R3 ArE n0 F0rUM\$ 0f ThE \$3l3C+ED +yp3 4v@il48lE. ple4SE 53LEC+ a dIphF3rent +yp3.";
$lang['successfullyaddedforumtofavourites'] = "sucCEssfully 4DD3d ph0rum +0 f4vourItEs.";
$lang['successfullyremovedforumfromfavourites'] = "succE5\$PhuLly rEmoV3D F0rUm pHr0m ph4Vour1+3s.";
$lang['successfullyignoredforum'] = "sUCC3ssfUlly ign0RED F0RUm.";
$lang['successfullyunignoredforum'] = "succEs\$pHuLly Un1gn0rED F0rUm.";
$lang['failedtoupdateforuminterestlevel'] = "f@1lED +0 UPD4+3 f0RuM 1ntErEs+ LevEl";
$lang['noforumsavailablelogin'] = "ther3 ar3 No phorUms @v4iL@8le. PL34s3 Login +0 v13W y0uR PhorUms.";
$lang['passwdprotectedforum'] = "p4\$Sword ProtECT3D f0RUm";
$lang['passwdprotectedwarning'] = "tH1s f0Rum 1S p4Ssw0rD pr0teC+3D. +0 941N aCc3ss eNter thE P@5sw0RD 8ELOw.";

// Message composition (post.php, lpost.php) --------------------------------------

$lang['postmessage'] = "post mEsS49E";
$lang['selectfolder'] = "sELEC+ f0LDer";
$lang['mustenterpostcontent'] = "j00 mUst eN+er som3 COn+Ent F0r +h3 P0\$+!";
$lang['messagepreview'] = "m3Ss49e prev13w";
$lang['invalidusername'] = "inV@LiD U53rN4m3!";
$lang['mustenterthreadtitle'] = "j00 mus+ 3nter @ tItle f0r thE tHre4D!";
$lang['pleaseselectfolder'] = "pLE4se \$3lEC+ a f0ldEr!";
$lang['errorcreatingpost'] = "erR0r CREaT1ng po\$+! pl3Ase +ry 4g41n in A fEW m1NUTEs.";
$lang['createnewthread'] = "cRE4+e n3w Thre4d";
$lang['postreply'] = "p05+ r3ply";
$lang['threadtitle'] = "thRE4D t1+l3";
$lang['messagehasbeendeleted'] = "m3Ss4g3 N0+ phoUnd. ChECK Th4+ 1t h4SN'+ bEEN D3L3+3D.";
$lang['messagenotfoundinselectedfolder'] = "mE5s493 noT PhounD iN sEl3C+3D ph0lD3R. ChECK +h4+ i+ h@\$N'+ BEEn M0VED 0r d3L3TEd.";
$lang['cannotpostthisthreadtypeinfolder'] = "j00 C4nnOt P0\$+ +hiS +hrE4d +ype 1n tH4+ f0ld3R!";
$lang['cannotpostthisthreadtype'] = "j00 C4nnoT p0\$+ thi\$ +hr34d tyPe @\$ THer3 4re n0 4v4Il@Ble f0LDEr5 TH@t @lloW 1+.";
$lang['cannotcreatenewthreads'] = "j00 C4nN0t CRE4+E n3W thr3@Ds.";
$lang['threadisclosedforposting'] = "th1s +hre4D 1\$ Cl0SED, J00 C4Nn0+ post 1N I+!";
$lang['moderatorthreadclosed'] = "w4rn1n9: tH1\$ +hr34D 1\$ cl0SED foR p0\$+In9 t0 n0Rmal UsEr\$.";
$lang['usersinthread'] = "uSer\$ In +hr3Ad";
$lang['correctedcode'] = "c0RrEC+3D COD3";
$lang['submittedcode'] = "sU8M1+tEd C0dE";
$lang['htmlinmessage'] = "htMl 1N mEss@ge";
$lang['disableemoticonsinmessage'] = "d1S4Bl3 3m0t1Con\$ iN M3SS@gE";
$lang['automaticallyparseurls'] = "aUT0m@+1C4lly P4rse uRl\$";
$lang['automaticallycheckspelling'] = "aU+0m@+iC4Lly Ch3ck 5p3lLING";
$lang['setthreadtohighinterest'] = "sEt THrE4d +O h19h in+er3St";
$lang['enabledwithautolinebreaks'] = "enabled wIth 4Uto-l1NE-BR3AK5";
$lang['fixhtmlexplanation'] = "thIs f0rUm UsE\$ hTmL pHiLtEring. Your subm1+teD h+ml has 8EEn m0D1PHI3d 8Y Th3 F1lteRs In Som3 W4Y.\\n\\nTo vi3W y0UR 0RI9in4l CODE, sEl3ct +h3 \\'SuBMi++3D Code\\' r4d1O 8U++on.\\nT0 v13w teh m0D1fiED C0dE, \$3l3c+ thE \\'C0RrECtED CoD3\\' r4d10 8Utton.";
$lang['messageoptions'] = "meS\$4g3 0pt10ns";
$lang['notallowedembedattachmentpost'] = "j00 ArE not 4LL0w3D +0 em8ED @T+4chMEnts in y0ur p0\$+\$.";
$lang['notallowedembedattachmentsignature'] = "j00 @rE no+ @LloweD +o EM8Ed a+T4chMEn+s in yoUr 5I9n4+urE.";
$lang['reducemessagelength'] = "m3\$s493 l3N9th mu5+ 83 UnDer 65,535 Ch@R@C+eR\$ (CURr3Ntly: %s)";
$lang['reducesiglength'] = "sI9n4+Ure l3N9th mU\$t 8E UndEr 65,535 CH4R4c+3r\$ (CUrR3NtLy: %s)";
$lang['cannotcreatethreadinfolder'] = "j00 c@nN0+ CR34+E n3W +HRE4D5 in tHi\$ Ph0ld3R";
$lang['cannotcreatepostinfolder'] = "j00 c4nN0t reply to P0\$+s In thi\$ Ph0ldeR";
$lang['cannotattachfilesinfolder'] = "j00 C4nn0+ post 4+T@Chm3nts 1N tH1\$ F0LDER. R3M0v3 4++4CHM3NT\$ +0 COn+inU3.";
$lang['postfrequencytoogreat'] = "j00 caN only p0ST 0nCE 3V3Ry %s sec0nds. pl34s3 try 494in latEr.";
$lang['emailconfirmationrequiredbeforepost'] = "em41L ConfiRm@+i0n i\$ r3qU1red bef0rE J00 CaN po\$+. 1F j00 h4VE n0+ REC31v3D 4 ConFirm@+i0n eM41L pL34\$E clICK +H3 BU++on 83low @nD A N3w 0N3 w1lL bE sEn+ +0 y0u. 1F your Ema1l 4DdRE\$5 n3EDs Chang1N9 Pl34SE D0 S0 bef0RE r3QU3s+1Ng @ n3W C0nphIRM4t10N Em4il. j00 m4y ch4n93 YOur 3MA1l adDr3sS 8Y Cl1Ck My c0NTr0ls @8Ov3 anD +h3n User D3ta1L\$";
$lang['emailconfirmationfailedtosend'] = "c0NPhirm4t1on 3M4il f4IL3d +O s3nd. Pl3@s3 COn+4C+ +h3 f0RUM own3r +0 r3CTiFy th1\$.";
$lang['emailconfirmationsent'] = "cOnphirM4tiOn 3m4iL h4\$ 8eEn r3SEn+.";
$lang['resendconfirmation'] = "re53Nd COnphirm@t10n";
$lang['userapprovalrequiredbeforeaccess'] = "yOur us3r 4CCOuN+ n33ds +o 8e APpr0V3d 8Y 4 F0Rum 4dmiN BEf0re j00 C4N acCEs\$ th3 r3qu3\$+3D f0Rum.";

// Message display (messages.php & messages.inc.php) --------------------------------------

$lang['inreplyto'] = "in rePly To";
$lang['showmessages'] = "sH0w m3s5@G3s";
$lang['ratemyinterest'] = "r@+E my iN+Er3ST";
$lang['adjtextsize'] = "aDjus+ +3x+ s1Ze";
$lang['smaller'] = "sm4lL3R";
$lang['larger'] = "l4R9er";
$lang['faq'] = "f@q";
$lang['docs'] = "dOc\$";
$lang['support'] = "sUppoRT";
$lang['donateexcmark'] = "doNate!";
$lang['fontsizechanged'] = "f0N+ siz3 ChaN93D. %s";
$lang['framesmustbereloaded'] = "fr4m3\$ MUSt 8e R3lo4DED m4NU4lly To \$3e CHAngE\$.";
$lang['threadcouldnotbefound'] = "t3h r3QU3s+ED +hr3ad CoUld no+ B3 PHoUND or 4cCEss w@\$ DENI3D.";
$lang['mustselectpolloption'] = "j00 mu\$T seL3C+ @N opt1ON TO vo+3 Ph0r!";
$lang['mustvoteforallgroups'] = "j00 mus+ vo+3 1n 3vEry gr0up.";
$lang['keepreading'] = "keeP R3@Ding";
$lang['backtothreadlist'] = "b4ck +0 tHre4d l1sT";
$lang['postdoesnotexist'] = "th4+ po\$T D035 N0T Ex1St 1n +hi\$ Thr3@d!";
$lang['clicktochangevote'] = "cl1Ck t0 Ch4N9E v0t3";
$lang['youvotedforoption'] = "j00 VotED f0R 0pt1on";
$lang['youvotedforoptions'] = "j00 v0+ED pHor 0Pt1on\$";
$lang['clicktovote'] = "clICk +0 votE";
$lang['youhavenotvoted'] = "j00 h@v3 nO+ V0TED";
$lang['viewresults'] = "vIEW r3SUlt\$";
$lang['msgtruncated'] = "m3S\$A93 trUnC4+3D";
$lang['viewfullmsg'] = "vi3w fUll m35\$49E";
$lang['ignoredmsg'] = "iGN0RED mEss49e";
$lang['wormeduser'] = "w0rmeD usEr";
$lang['ignoredsig'] = "i9N0reD \$IGN4Tur3";
$lang['messagewasdeleted'] = "m3\$S4gE %s.%s W@5 d3L3+3D";
$lang['stopignoringthisuser'] = "sTOP 1gn0R1ng +H15 Us3r";
$lang['renamethread'] = "r3NamE tHre4D";
$lang['movethread'] = "mov3 +hre4d";
$lang['torenamethisthreadyoumusteditthepoll'] = "to reN@mE th1s +hr34d J00 Mu\$+ 3D1+ +h3 p0ll.";
$lang['closeforposting'] = "cL0\$e F0r po5+1ng";
$lang['until'] = "unTiL 00:00 UtC";
$lang['approvalrequired'] = "apProV4l REquIred";
$lang['messageawaitingapprovalbymoderator'] = "mEsS4g3 %s.%s 1s 4w4I+inG 4Ppr0V4L 8y A mOD3r4Tor";
$lang['postapprovedsuccessfully'] = "poS+ approvED suCCEssPhully";
$lang['postapprovalfailed'] = "pO\$T 4Pprov4L F4il3d.";
$lang['postdoesnotrequireapproval'] = "pOS+ do35 no+ reqUiR3 4PprovAl";
$lang['approvepost'] = "aPpr0V3 po\$+ ph0R D1sPL4y";
$lang['approvedbyuser'] = "aPprov3D: %s by %s";
$lang['makesticky'] = "m@k3 sTiCKY";
$lang['messagecountdisplay'] = "%s 0f %s";
$lang['linktothread'] = "p3rm4NEn+ l1nK +0 th1S thrEaD";
$lang['linktopost'] = "l1Nk +o p0st";
$lang['linktothispost'] = "link to Thi\$ Po5+";
$lang['imageresized'] = "tHis IM49e h4\$ BEEN R3s1z3d (or1gin4L siz3 %1\$5x%2\$\$). +O viEW thE full-\$ize 1m@ge cl1ck H3re.";
$lang['messagedeletedbyuser'] = "m3sS4g3 %s.%s DEL3t3d %s 8y %s";
$lang['messagedeleted'] = "m3\$s4g3 %s.%s W@S d3LETeD";

// Moderators list (mods_list.php) -------------------------------------

$lang['cantdisplaymods'] = "c4Nn0T D1\$Pl@Y f0LDEr mOD3r4t0R\$";
$lang['moderatorlist'] = "moDEr4+0r l1st:";
$lang['modsforfolder'] = "moder@t0Rs f0R ph0ldeR";
$lang['nomodsfound'] = "no MoDer4+0RS f0unD";
$lang['forumleaders'] = "foRUm lE4D3RS:";
$lang['foldermods'] = "f0lder moD3r@+0Rs:";

// Navigation strip (nav.php) ------------------------------------------

$lang['start'] = "sTArt";
$lang['messages'] = "m3ssa93\$";
$lang['pminbox'] = "iN8oX";
$lang['startwiththreadlist'] = "s+@r+ P49e with +HRE4d L1s+";
$lang['pmsentitems'] = "s3N+ I+3m\$";
$lang['pmoutbox'] = "ou+box";
$lang['pmsaveditems'] = "s4VED 1tEms";
$lang['pmdrafts'] = "dr4phT\$";
$lang['links'] = "liNks";
$lang['admin'] = "adMin";
$lang['login'] = "l09IN";
$lang['logout'] = "lO90UT";

// PM System (pm.php, pm_write.php, pm.inc.php) ------------------------

$lang['privatemessages'] = "prIV@+3 me5\$@gEs";
$lang['recipienttiptext'] = "s3P4r4tE rec1p1En+s By \$eM1-c0l0n or Comm@";
$lang['maximumtenrecipientspermessage'] = "tHeR3 is @ l1mit 0Ph 10 rECipI3NT5 p3r me\$S493. Ple@sE @mEND y0UR ReCiPi3nt lIst.";
$lang['mustspecifyrecipient'] = "j00 mus+ \$P3ciphy @+ l3@\$T 0NE reCIpi3nt.";
$lang['usernotfound'] = "u5Er %s n0+ PhOUnD";
$lang['sendnewpm'] = "s3ND n3w pM";
$lang['savemessage'] = "s4VE m3ss4ge";
$lang['timesent'] = "t1Me 53N+";
$lang['errorcreatingpm'] = "eRr0r CR3@+inG Pm! pLeA53 try 4g@1N 1n 4 FEW mInut3S";
$lang['writepm'] = "wr1t3 m3s5@G3";
$lang['editpm'] = "edI+ me\$s49E";
$lang['cannoteditpm'] = "caNN0t Edi+ +h1S pm. it H4\$ 4lr34Dy b3en V13weD 8Y +HE r3c1PiEN+ 0r th3 MES5493 Do3S noT 3X1st 0R i+ is 1N@CC3sS18lE 8Y j00";
$lang['cannotviewpm'] = "c4Nnot v13w pM. mEss4GE D0Es n0+ 3x1sT 0r i+ I5 in4cCE\$Si8lE 8y j00";
$lang['pmmessagenumber'] = "mESs4g3 %s";

$lang['youhavexnewpm'] = "j00 Hav3 %d neW mE\$S4g3s. woUld j00 l1KE To 90 +o yoUr iN80X noW?";
$lang['youhave1newpm'] = "j00 h4vE 1 n3W mEssa93. w0uld J00 L1k3 +0 9O +0 y0Ur 1n80X n0W?";
$lang['youhave1newpmand1waiting'] = "j00 h@v3 1 n3W MeSs49e.\n\nYoU @l5O H@V3 1 ME\$s4g3 4Wa1+iNg D3liVERY. To RECEIVe +hIs M3ss493 plEAse Cl34r S0m3 SP4C3 iN y0Ur 1N8ox.\n\nWOULd J00 l1k3 t0 g0 to yOuR inbox now?";
$lang['youhave1pmwaiting'] = "j00 h@vE 1 me\$S49E 4wa1+Ing dELiV3Ry. +o R3C31Ve tHis m3ss49E plE4S3 cl34R some sP4C3 1N y0UR inBox.\n\nwoulD j00 l1KE to 9O to yoUr in8OX n0w?";
$lang['youhavexnewpmand1waiting'] = "j00 h@v3 %d NEw m3Ss49es.\n\nyOU 4Ls0 HAVE 1 m3Ss@g3 4w@i+iNg D3l1v3Ry. +0 recE1ve +hI\$ M3Ss4g3 pL3asE CL3Ar sOmE sp@C3 1n your 1N8OX.\n\nw0ulD j00 liK3 T0 Go to Y0Ur 1N8oX noW?";
$lang['youhavexnewpmandxwaiting'] = "j00 h@vE %d nEw M3s\$@g3s.\n\nYOU aL\$0 h4v3 %d MEss493s 4W4i+1N9 d3LIV3ry. +0 r3CEIv3 thEs3 me\$s49E PlE453 CL3@r 50me sp4c3 1n Y0ur 1N8OX.\n\nW0ULD j00 Like +0 g0 To your 1N8oX nOw?";
$lang['youhave1newpmandxwaiting'] = "j00 H4Ve 1 n3w mEss49e.\n\nYoU 4LSO h4V3 %d mEss493s 4w@i+iN9 dElivERy. +o ReC31V3 thesE M3ssa93s pL3@s3 cl3@r s0m3 sPaC3 iN your inBox.\n\nWOuld j00 l1K3 to 90 to Y0Ur 1N8ox Now?";
$lang['youhavexpmwaiting'] = "j00 hav3 %d m3ssa9E\$ 4wa1tiNg D3LIVEry. +0 r3cEive +H3sE mE\$s4g3\$ pl34\$3 CLEar s0M3 sp4C3 1n your 1N8ox.\n\nWOuLD J00 l1kE to 90 tO y0Ur 1n8OX Now?";

$lang['youdonothaveenoughfreespace'] = "j00 Do NO+ H@vE 3NoUgh fr3e SP@CE +0 sEnD +hIs Me\$s49e.";
$lang['userhasoptedoutofpm'] = "%s H4s 0Pt3d OU+ 0Ph REce1ving p3R\$0n@L mEss4g3S";
$lang['pmfolderpruningisenabled'] = "pM PHolD3r prun1NG is 3N4bleD!";
$lang['pmpruneexplanation'] = "th1s f0Rum U53S pm f0LD3R Prun1NG. th3 m3s5@G3S j00 h4v3 \$+orED in YOUr Inbox @nD sEnt 1+Ems\\nfoLDERs @r3 sUBj3ct +0 au+0M4T1C dEl3T1oN. 4NY m3sS49eS j00 W1\$H +0 KEEp sH0UlD BE m0veD +0\\nYOUr \\'SaveD i+3m\$\\' f0LD3R s0 +h@+ +h3Y 4RE n0+ D3l3TEd.";
$lang['yourpmfoldersare'] = "yoUr pm PholDers 4Re %s phUll";
$lang['currentmessage'] = "cUrren+ mEss4g3";
$lang['unreadmessage'] = "unreaD m3s\$@G3";
$lang['readmessage'] = "re4d M3ss49e";
$lang['pmshavebeendisabled'] = "peR\$0n4l mEss4g3S h4V3 83en Dis4BL3d 8Y +H3 PHOruM 0WNer.";
$lang['adduserstofriendslist'] = "adD U\$3rs +0 y0Ur PHr13nds LIs+ to hAvE +H3M 4pp3ar in 4 DRop D0wn 0n teH Pm wRi+3 mE\$S493 p49E.";

$lang['messagesaved'] = "meSS493 s4V3D";
$lang['messagewassuccessfullysavedtodraftsfolder'] = "mEss4gE w@\$ \$uCcessfUllY \$4v3D +0 'Dr@pH+5' FolD3R";
$lang['couldnotsavemessage'] = "c0uld no+ \$@v3 mEss@Ge. m@k3 suRE J00 h@v3 eN0u9h @v@Il@8le phr3e \$P@Ce.";
$lang['pmtooltipxmessages'] = "%s m3s\$@g3\$";
$lang['pmtooltip1message'] = "1 m3Ss4G3";

$lang['allowusertosendpm'] = "alL0w usEr t0 \$3nD persoN4L mE\$S49es +o ME";
$lang['blockuserfromsendingpm'] = "bL0Ck USER PhRom s3nD1n9 p3R\$0Nal m3S\$@GEs +o M3";
$lang['yourfoldernamefolderisempty'] = "y0UR %s pH0lDEr 1S Emp+y";
$lang['successfullydeletedselectedmessages'] = "sUCCE5\$FUlly DeL3+3D \$3lec+3D M3ssA93s";
$lang['successfullyarchivedselectedmessages'] = "sUcCEs\$fully 4RcHivED \$3lEC+3D m3ss49es";
$lang['failedtodeleteselectedmessages'] = "f41L3d t0 DElE+e \$3lect3d m3sS4ge5";
$lang['failedtoarchiveselectedmessages'] = "f4il3D +0 aRCHiv3 s3lECT3D mEs\$49Es";

// Preferences / Profile (user_*.php) ---------------------------------------------

$lang['mycontrols'] = "my Con+r0LS";
$lang['myforums'] = "my PhoRUms";
$lang['menu'] = "mEnu";
$lang['userexp_1'] = "u\$E +HE m3Nu On +h3 l3PhT to M4n49e yoUr \$3tt1Ngs.";
$lang['userexp_2'] = "<b>usER dEt4IL\$</b> 4LL0w\$ J00 +0 ch@N93 your n@m3, 3m4iL @DDRE\$S @nD p45\$worD.";
$lang['userexp_3'] = "<b>u\$3r prophil3</b> allOw\$ j00 +0 eD1+ YoUr User PrOfIlE.";
$lang['userexp_4'] = "<b>ch@nge PasswORD</b> @Ll0w\$ J00 t0 cHAn93 Y0UR p@ssw0RD";
$lang['userexp_5'] = "<b>em41L &amp; PrIvAcy</b> lets j00 ChAngE h0w J00 C4N b3 ConT@cTED 0n 4nD opHpH thE pH0RUm.";
$lang['userexp_6'] = "<b>f0rum 0Pt10n\$</b> LEts J00 Ch4nge h0W t3h F0rum l0ok\$ @ND worKs.";
$lang['userexp_7'] = "<b>a++4ChmENTs</b> AlLow5 j00 tO ED1+/DELE+E Your 4Tt4chm3Nts.";
$lang['userexp_8'] = "<b>s1Gn4+Ur3</b> l3Ts j00 3d1+ Y0ur s1Gn4tur3.";
$lang['userexp_9'] = "<b>reL4+1ON\$H1p5</b> l3Ts j00 M4n49E your rEL4T1ON\$H1p w1+H 0THER us3RS 0N ThE ph0RUM.";
$lang['userexp_9'] = "<b>woRD phIlt3R</b> LET\$ j00 3D1+ your pER\$0n4l w0rD ph1l+3R.";
$lang['userexp_10'] = "<b>tHread suBsCRip+1ONs</b> 4LL0ws J00 +o man4g3 your +hrEaD \$UbsCRip+1ON\$.";
$lang['userdetails'] = "u5er dEt4IL5";
$lang['userprofile'] = "us3r pR0F1l3";
$lang['emailandprivacy'] = "ema1l &amp; Priv4cY";
$lang['editsignature'] = "eDIt S19N@+ure";
$lang['norelationshipssetup'] = "j00 haV3 n0 U\$ER r3LA+10n\$HIP5 53t up. 4dD 4 n3w us3R 8y \$e4RChin9 bELow.";
$lang['editwordfilter'] = "ed1t w0RD fil+3r";
$lang['userinformation'] = "u5er 1nf0RM4+i0n";
$lang['changepassword'] = "ch4ng3 p@s\$w0rD";
$lang['currentpasswd'] = "cuRr3Nt P@ssw0rd";
$lang['newpasswd'] = "n3W p4SSW0RD";
$lang['confirmpasswd'] = "c0nPh1Rm Passw0rd";
$lang['passwdsdonotmatch'] = "p4sSW0rds Do N0T m4+Ch!";
$lang['nicknamerequired'] = "n1cknaMe iS reqUir3D!";
$lang['emailaddressrequired'] = "eM41l @dDR3s\$ is requIr3D!";
$lang['logonnotpermitted'] = "loGOn no+ pErMit+eD. CHo0se @n0th3r!";
$lang['nicknamenotpermitted'] = "nIckn4m3 nOt pErMi+teD. Ch0OSE 4No+hER!";
$lang['emailaddressnotpermitted'] = "emAIl 4ddrEss n0+ pErMi++3d. ChOo53 4NO+h3R!";
$lang['emailaddressalreadyinuse'] = "em4il @DDRess 4LR34DY in us3. ChoO\$e @NO+hEr!";
$lang['relationshipsupdated'] = "rEl@+i0N\$HIp\$ upD@+3D!";
$lang['relationshipupdatefailed'] = "r3L@+1oN\$H1p updaTeD f41leD!";
$lang['preferencesupdated'] = "pr3fEr3nCEs wer3 \$UccEssFully UpDA+3D.";
$lang['userdetails'] = "user d3+41ls";
$lang['memberno'] = "mEm83r N0.";
$lang['firstname'] = "f1r\$+ n4M3";
$lang['lastname'] = "l4\$+ NAM3";
$lang['dateofbirth'] = "d@T3 of 81rth";
$lang['homepageURL'] = "hoMep4G3 UrL";
$lang['profilepicturedimensions'] = "prOF1l3 pIctUrE (m@x 95x95Px)";
$lang['avatarpicturedimensions'] = "aV4+4r piCTUR3 (m@x 15x15pX)";
$lang['invalidattachmentid'] = "inV4lid 4+T4chMENt. ChECK +H@+ Is h@5N'+ B33n dELE+3d.";
$lang['unsupportedimagetype'] = "unSUppoR+3D iM49E 4Tt@CHment. J00 c@n 0nlY usE jPg, 91f aND pn9 1ma93 4+t4cHm3NTs pH0R Your @V@+@r 4nD pRophil3 p1CTUR3.";
$lang['selectattachment'] = "sEl3Ct 4++4chment";
$lang['pictureURL'] = "pIc+ur3 url";
$lang['avatarURL'] = "aV@+ar url";
$lang['profilepictureconflict'] = "t0 UsE 4n @++4chMEnT F0R Your PrOpHIle PICTUR3 +3h PiCtUR3 URl PHiELD mU\$+ 8E 8l4nK.";
$lang['avatarpictureconflict'] = "tO us3 4N attaChm3NT phor yoUr @v4+@R pictUr3 +Eh 4V4+4R Url f13lD muSt 83 blanK.";
$lang['attachmenttoolargeforprofilepicture'] = "seLEC+3D atTaCHm3Nt 1S +o0 l@RgE f0R PR0ph1L3 piCTUre. m4X1muM DImEN510n\$ 4rE %s";
$lang['attachmenttoolargeforavatarpicture'] = "sEl3c+ED @tt@chMEn+ Is +o0 L4rge ph0R 4vAT4r picTuR3. max1mum d1M3ns1oN\$ 4re %s";
$lang['failedtoupdateuserdetails'] = "som3 0r @Ll 0Ph Y0Ur Us3R 4Cc0unT D3ta1l\$ C0ulD N0t BE Upd4TEd. pL34\$3 trY a9@IN LatEr.";
$lang['failedtoupdateuserpreferences'] = "s0M3 0r 4Ll oF yOuR U\$ER Pr3FeRenCEs CoUld not BE Upd@TED. pLe4Se trY A9A1N L4+3r.";
$lang['emailaddresschanged'] = "eM@il 4DDr3SS h4s 83EN ch4NG3d";
$lang['newconfirmationemailsuccess'] = "yOuR Em4il 4DDr3Ss has b33n ch@nG3D 4nd 4 n3W C0nphiRm@+ion 3m4iL haS B33n sEn+. Pl34se CH3ck ANd re4d tEh Em41l pHor fUrtH3r 1nstrUC+i0Ns.";
$lang['newconfirmationemailfailure'] = "j00 h4vE CH4nG3d your 3m4il @DDress, Bu+ W3 WERE Un4blE To senD 4 C0nphiRm4T1On rEQUeSt. pl3@SE C0nt4Ct +hE ph0Rum Own3R ph0r @sSIST4ncE.";
$lang['forumoptions'] = "f0RUm opT10N5";
$lang['notifybyemail'] = "n0Tiphy by 3m4iL Oph p0STs +0 m3";
$lang['notifyofnewpm'] = "n0tiphy by p0pup 0Ph nEW Pm mEss49Es +0 mE";
$lang['notifyofnewpmemail'] = "noTIPhy By ema1L opH N3w pm mEss49es +0 mE";
$lang['daylightsaving'] = "adJUsT For D4YL1gh+ s@vINg";
$lang['autohighinterest'] = "au+Om4T1CAlLy m@rk thre4d\$ i p05+ 1N 45 h1gH 1N+3rE5+";
$lang['convertimagestolinks'] = "aU+oM4+ic@llY CONvErt EmBEDD3D im@gE\$ In P0\$+s in+0 liNks";
$lang['thumbnailsforimageattachments'] = "thUm8n41Ls f0r im@93 @++4CHmEN+\$";
$lang['smallsized'] = "sM@ll S1z3d";
$lang['mediumsized'] = "med1um siz3D";
$lang['largesized'] = "l4r9e 51zED";
$lang['globallyignoresigs'] = "gl0Bally 19n0RE U53r \$19NATuREs";
$lang['allowpersonalmessages'] = "aLl0w O+hER U\$eR5 to \$3nD ME pErs0n@L m3\$549ES";
$lang['allowemails'] = "aLLow o+h3R UseR\$ +0 seNd m3 3m@ils V1@ My Prophil3";
$lang['timezonefromGMT'] = "tiM3 z0Ne";
$lang['postsperpage'] = "p05+s p3R P4g3";
$lang['fontsize'] = "fOnt \$iz3";
$lang['forumstyle'] = "foRUm \$+yl3";
$lang['forumemoticons'] = "fORum 3M0+iCon5";
$lang['startpage'] = "st4rt P@g3";
$lang['signaturecontainshtmlcode'] = "sI9N@+UrE c0n+41N\$ h+ml CoD3";
$lang['savesignatureforuseonallforums'] = "s4VE sign4+UrE phOr u\$3 0N All F0rums";
$lang['preferredlang'] = "prefErr3D lAn9U@gE";
$lang['donotshowmyageordobtoothers'] = "d0 N0+ shoW My a9E or d@tE of b1r+h +0 OThers";
$lang['showonlymyagetoothers'] = "sHow 0nly my a93 to 0+H3rs";
$lang['showmyageanddobtoothers'] = "shOw B0+H my 4g3 anD D@+E oph B1r+h +o o+her\$";
$lang['showonlymydayandmonthofbirthytoothers'] = "sHow only my D4Y 4Nd MOn+H oph B1R+H tO 0+hER\$";
$lang['listmeontheactiveusersdisplay'] = "l15+ m3 0n TEH 4cT1v3 us3r\$ DIspl4y";
$lang['browseanonymously'] = "brOW\$3 phoRUM @N0NYMouslY";
$lang['allowfriendstoseemeasonline'] = "brow\$E 4NonYm0usly, bUt 4LLow Fr13nDs T0 sEE m3 4\$ 0NLIn3";
$lang['revealspoileronmouseover'] = "r3VEal sp0il3R\$ 0n moUsE 0vEr";
$lang['showspoilersinlightmode'] = "alw4y\$ 5H0w sp01l3Rs in l1ght m0DE (use5 L19hTEr f0n+ C0l0Ur)";
$lang['resizeimagesandreflowpage'] = "reSiz3 1M@G3\$ 4nd r3Fl0W P@g3 TO pRevEnt h0r1zOn+@l sCr0lLINg.";
$lang['showforumstats'] = "sh0w f0rum staTs 4t B0Ttom opH m3SS@g3 p@N3";
$lang['usewordfilter'] = "en@8l3 W0rD philtER.";
$lang['forceadminwordfilter'] = "forc3 u53 0F aDmin W0RD pHilT3R On alL u\$er5 (1NC. 9U3\$+\$)";
$lang['timezone'] = "t1ME z0N3";
$lang['language'] = "l@ngu49e";
$lang['emailsettings'] = "em@1l @nd C0N+4C+ sE++1n9\$";
$lang['forumanonymity'] = "foRUm @N0nyM1+y 53tt1NGS";
$lang['birthdayanddateofbirth'] = "bIR+hD4Y @nd d@+e oph B1rth disPl4Y";
$lang['includeadminfilter'] = "iNcludE @DMIn worD f1LTER In mY li\$T.";
$lang['setforallforums'] = "s3T for 4lL f0rum5?";
$lang['containsinvalidchars'] = "%s C0n+@iNs InvAl1D Ch@R4Ct3r\$!";
$lang['homepageurlmustincludeschema'] = "hOM3p49E Url Mu5+ 1nCLUD3 ht+p:// scH3M4.";
$lang['pictureurlmustincludeschema'] = "p1ctur3 URl Must 1NCLUDE hTtp:// \$ChEm4.";
$lang['avatarurlmustincludeschema'] = "aVaT@R UrL mU\$t INClUDE HtTp:// 5ch3m4.";
$lang['postpage'] = "po\$+ p49E";
$lang['nohtmltoolbar'] = "n0 HTml +0Ol84R";
$lang['displaysimpletoolbar'] = "d1spL4Y \$1mPlE html +0OlB4r";
$lang['displaytinymcetoolbar'] = "dI\$pl4y wYs1wyG Html tooLB4R";
$lang['displayemoticonspanel'] = "dI5pl4Y Em0+IC0n\$ paNEl";
$lang['displaysignature'] = "dI\$plaY \$19n4+Ure";
$lang['disableemoticonsinpostsbydefault'] = "dIs4BLE 3Mo+iCon\$ in m3\$\$49Es 8Y DEPhauLt";
$lang['automaticallyparseurlsbydefault'] = "aU+om4+1CAlLy P4rsE Url\$ In M3s5@93s 8Y D3F4Ul+";
$lang['postinplaintextbydefault'] = "p0S+ In pl41n TEx+ by D3FaULt";
$lang['postinhtmlwithautolinebreaksbydefault'] = "p0\$+ In h+ml w1+H @utO-lInE-8re4k\$ bY DEPh4ult";
$lang['postinhtmlbydefault'] = "p05+ in h+ml By DEph4ult";
$lang['privatemessageoptions'] = "prIv4+3 mEss49e 0Pt1oNS";
$lang['privatemessageexportoptions'] = "priV@+E m3SS4gE 3XP0Rt 0ptions";
$lang['savepminsentitems'] = "s@V3 4 C0PY oph E4ch Pm 1 send 1n my 53nt i+Em\$ folDEr";
$lang['includepminreply'] = "incluDe Mess49e 80Dy WhEN rEPly1ng To PM";
$lang['autoprunemypmfoldersevery'] = "auT0 Prun3 my pm F0LDEr5 3vERy:";
$lang['friendsonly'] = "fR13nds 0nly?";
$lang['globalstyles'] = "gL084L \$+YL3s";
$lang['forumstyles'] = "fOrum 5+Yl3S";
$lang['youmustenteryourcurrentpasswd'] = "j00 mUst en+ER y0ur curREnt p4SsW0rD";
$lang['youmustenteranewpasswd'] = "j00 mu\$T 3n+3R 4 nEW p@\$\$wORd";
$lang['youmustconfirmyournewpasswd'] = "j00 mU\$T CoNfIrm Y0Ur nEW p4SSw0RD";
$lang['profileentriesmustnotincludehtml'] = "pR0PHiL3 EnTriE\$ Mu5+ no+ inCluD3 html";
$lang['failedtoupdateuserprofile'] = "f4iL3D +o uPD@+E us3r PRoPhiLE";

// Polls (create_poll.php, poll_results.php) ---------------------------------------------

$lang['mustprovideanswergroups'] = "j00 mu\$T provid3 \$0m3 4n5wer Gr0UP\$";
$lang['mustprovidepolltype'] = "j00 mus+ Pr0V1D3 a pOll tyP3";
$lang['mustprovidepollresultsdisplaytype'] = "j00 mu\$t prov1D3 R3sul+s D1\$PL4Y typ3";
$lang['mustprovidepollvotetype'] = "j00 mUst pRoviD3 4 p0LL v0+3 typ3";
$lang['mustprovidepollguestvotetype'] = "j00 mu\$t \$PEC1fy 1F 9u3stS \$HoUlD BE @lLow3D +o v0te";
$lang['mustprovidepolloptiontype'] = "j00 mus+ pRov1D3 4 p0Ll op+1ON type";
$lang['mustprovidepollchangevotetype'] = "j00 mu\$T provId3 4 p0Ll CH@n93 votE +yP3";
$lang['pollquestioncontainsinvalidhtml'] = "oN3 0R Mor3 oph yoUr PolL quEs+10ns CoNt41n\$ inv@liD h+Ml.";
$lang['pleaseselectfolder'] = "pL34S3 S3lecT 4 pholdER";
$lang['mustspecifyvalues1and2'] = "j00 musT sp3ciphy V4Lu3S f0r 4nsweRs 1 @nD 2";
$lang['tablepollmusthave2groups'] = "t4BUL4r pHORm@+ p0lls must have pReCIs3Ly tWo v0tIN9 groups";
$lang['nomultivotetabulars'] = "t48ul@r f0rm@+ p0lLS c4nnot B3 MUl+1-vo+3";
$lang['nomultivotepublic'] = "pu8L1C B4ll0ts C@nNo+ B3 muLt1-vO+3";
$lang['abletochangevote'] = "j00 Will 8e 4BlE +o CH4NgE y0Ur vo+3.";
$lang['abletovotemultiple'] = "j00 wiLL B3 4Bl3 +0 vOte mUlt1ple +IM3s.";
$lang['notabletochangevote'] = "j00 WiLL N0+ BE 48l3 tO Ch4N93 Y0Ur vote.";
$lang['pollvotesrandom'] = "n0+3: POlL vo+e\$ @rE r@nDomlY 9ENER@+ed foR PreViEw 0Nly.";
$lang['pollquestion'] = "p0ll Qu35+i0N";
$lang['possibleanswers'] = "pOsS18Le @NswEr5";
$lang['enterpollquestionexp'] = "en+3r thE @nswer\$ FoR y0Ur p0Ll QU3st10n.. If Your p0ll i\$ A &quot;yes/nO&quot; qU35tion, S1mPly 3nT3R &quot;Y3s&quot; f0R 4nsW3r 1 4ND &quot;n0&quot; f0r 4n\$W3r 2.";
$lang['numberanswers'] = "nO. 4n\$wer\$";
$lang['answerscontainHTML'] = "an\$w3r\$ C0n+@iN h+mL (n0T 1NClud1N9 s1gN@tUrE)";
$lang['optionsdisplay'] = "aNsW3r\$ DIsPl4y Typ3";
$lang['optionsdisplayexp'] = "h0w Sh0UlD tH3 @nswEr\$ 83 pr3SENt3D?";
$lang['dropdown'] = "a\$ dR0p-d0wn lIst(\$)";
$lang['radios'] = "a\$ a seri3s 0PH r4d10 8Utt0N\$";
$lang['votechanging'] = "v0te CHan9ing";
$lang['votechangingexp'] = "c4N @ per50n cH@nG3 H1\$ 0R h3R vo+3?";
$lang['guestvoting'] = "gu3st v0+1N9";
$lang['guestvotingexp'] = "c4N gu3sts V0+3 1N +hi\$ poll?";
$lang['allowmultiplevotes'] = "aLLow mUl+ipLE V0T3S";
$lang['pollresults'] = "p0ll rEsulTs";
$lang['pollresultsexp'] = "h0W w0ulD j00 l1k3 to d15pl4y tH3 rEsult\$ opH Y0Ur p0Ll?";
$lang['pollvotetype'] = "pOLL vo+Ing +yPE";
$lang['pollvotesexp'] = "h0w SHoUld thE pOLl 83 COnDuC+3d?";
$lang['pollvoteanon'] = "aN0nym0UslY";
$lang['pollvotepub'] = "pUBl1c B4lloT";
$lang['horizgraph'] = "h0RiZ0ntAl Gr@ph";
$lang['vertgraph'] = "vERT1C4l 9R4ph";
$lang['tablegraph'] = "t4BUl4r f0Rm4+";
$lang['polltypewarning'] = "<b>w4rn1ng</b>: thI\$ Is @ pu8lIC 8alLOT. y0Ur n@m3 w1ll 8E Vi\$i8l3 n3xt t0 thE 0Pt10n j00 v0+3 foR.";
$lang['expiration'] = "exP1R@t10n";
$lang['showresultswhileopen'] = "d0 j00 w4Nt +0 shoW REsUlTs Wh1LE +HE polL 1S 0pen?";
$lang['whenlikepollclose'] = "wH3n woulD j00 liKE Y0Ur PoLl to aU+oMa+1c4Lly Cl0S3?";
$lang['oneday'] = "oNe d4y";
$lang['threedays'] = "thr33 d@y\$";
$lang['sevendays'] = "s3VEn D4ys";
$lang['thirtydays'] = "thiR+y DAy\$";
$lang['never'] = "n3ver";
$lang['polladditionalmessage'] = "add1+i0N@l m3SsagE (opTional)";
$lang['polladditionalmessageexp'] = "dO j00 w4N+ +0 1nCLudE @n ADDI+1oN4l post 4F+3r +3h pOll?";
$lang['mustspecifypolltoview'] = "j00 MU5+ sP3C1fy 4 p0lL T0 v1EW.";
$lang['pollconfirmclose'] = "arE j00 sur3 j00 W4nt +0 Close +h3 pholl0W1ng p0LL?";
$lang['endpoll'] = "enD poll";
$lang['nobodyvotedclosedpoll'] = "nO80Dy vo+3d";
$lang['votedisplayopenpoll'] = "%s @nd %s h4v3 v0TED.";
$lang['votedisplayclosedpoll'] = "%s 4nd %s voteD.";
$lang['nousersvoted'] = "nO U\$ers";
$lang['oneuservoted'] = "1 uS3R";
$lang['xusersvoted'] = "%s U\$3r\$";
$lang['noguestsvoted'] = "n0 GUesTs";
$lang['oneguestvoted'] = "1 guEst";
$lang['xguestsvoted'] = "%s guests";
$lang['pollhasended'] = "pOll h@s 3NDED";
$lang['youvotedforpolloptionsondate'] = "j00 v0t3D PHOr %s 0n %s";
$lang['thisisapoll'] = "tHIs is 4 poLL. Cl1ck To v13w rEsults.";
$lang['editpoll'] = "eD1+ p0ll";
$lang['results'] = "rEsul+\$";
$lang['resultdetails'] = "rEsul+ D3+41ls";
$lang['changevote'] = "ch4n93 Vo+E";
$lang['pollshavebeendisabled'] = "p0Lls haVe 833N dIs@BLED By +h3 Forum Own3R.";
$lang['answertext'] = "aN\$WEr +3xt";
$lang['answergroup'] = "anSwEr gR0up";
$lang['previewvotingform'] = "pREviEW v0T1N9 FORm";
$lang['viewbypolloption'] = "view 8Y PoLl op+ioN";
$lang['viewbyuser'] = "v13w By U\$3r";

// Profiles (profile.php) ----------------------------------------------

$lang['editprofile'] = "ed1+ pRoPHIlE";
$lang['profileupdated'] = "pROpHiLE uPD4+3D.";
$lang['profilesnotsetup'] = "t3H ph0ruM own3R h@s n0t sE+ up pr0Ph1L3s.";
$lang['ignoreduser'] = "iGn0rED User";
$lang['lastvisit'] = "l45+ vi\$1+";
$lang['userslocaltime'] = "u\$3r'5 l0c4L +1ME";
$lang['userstatus'] = "s+@+u\$";
$lang['useractive'] = "onL1n3";
$lang['userinactive'] = "iN4CtIvE / 0pHPHlin3";
$lang['totaltimeinforum'] = "toTal Tim3";
$lang['longesttimeinforum'] = "lOn9Est s35s1on";
$lang['sendemail'] = "seND Ema1l";
$lang['sendpm'] = "s3Nd Pm";
$lang['visithomepage'] = "v1\$i+ h0m3p@g3";
$lang['age'] = "aGe";
$lang['aged'] = "aG3d";
$lang['birthday'] = "birthday";
$lang['registered'] = "r39istEr3d";
$lang['findpostsmadebyuser'] = "f1ND p05ts m@DE BY %s";
$lang['findpostsmadebyme'] = "f1ND p0\$+s M@D3 8Y mE";
$lang['profilenotavailable'] = "pR0fIl3 n0T 4v41l@8l3.";
$lang['userprofileempty'] = "th1s u\$3r H4\$ No+ fIllED In +H31r pRophiL3 0r 1+ Is \$ET +0 PRiV@TE.";

// Registration (register.php) -----------------------------------------

$lang['newuserregistrationsarenotpermitted'] = "sORRy, NeW UseR re91s+r@+1ons 4RE n0+ aLlow3d R1ght n0w. Ple4\$e CHeCk B4Ck L@+3r.";
$lang['usernameinvalidchars'] = "u\$Ern4M3 c4n ONLy C0N+@1n @-z, 0-9, _ - CH@r4cter\$";
$lang['usernametooshort'] = "u\$3rnaME Mu\$+ 8E @ minimUm Of 2 CH@R@C+3rs l0ng";
$lang['usernametoolong'] = "u\$3rn@mE musT 83 4 m4XImuM OF 15 Ch@r4cters lon9";
$lang['usernamerequired'] = "a LO9ON naME is r3QU1rED";
$lang['passwdmustnotcontainHTML'] = "p4Ssword mUst n0T C0nt4in htmL +@Gs";
$lang['passwordinvalidchars'] = "p4Ssw0RD C4N oNlY c0N+@iN @-z, 0-9, _ - CH4R4c+ers";
$lang['passwdtooshort'] = "p@\$SWoRd mUst B3 4 m1n1mUm 0ph 6 Ch@raC+Ers L0N9";
$lang['passwdrequired'] = "a P@s\$W0RD Is r3QU1RED";
$lang['confirmationpasswdrequired'] = "a c0nf1Rm@Ti0N p4\$\$w0rd 1\$ reqUir3D";
$lang['nicknamerequired'] = "a n1ckn4M3 IS r3qu1r3D";
$lang['emailrequired'] = "an 3m@il 4DDR3s\$ Is REqUiRed";
$lang['passwdsdonotmatch'] = "p4SsworD\$ Do N0T m4+ch";
$lang['usernamesameaspasswd'] = "uSern4M3 4nD P4\$Sw0rd MU\$+ 8e dIfph3ren+";
$lang['usernameexists'] = "soRry, @ U53R Wi+H +h@t n@me @LrE4dY 3Xis+s";
$lang['successfullycreateduseraccount'] = "sucCe\$SfuLly Cr34+eD Us3r @CC0unt";
$lang['useraccountcreatedconfirmfailed'] = "y0Ur Us3r @CC0Un+ h@s BeEN CRE4teD BUT +h3 r3quirED COnph1rm4T1on 3M@il w4\$ no+ 53n+. PlEAsE C0nt4CT teH Ph0RUM oWn3r +o r3C+IFy THi\$. 1n +Hi\$ M34N+1m3 pLE4\$e cL1CK +H3 c0n+iNuE 8utt0N tO l0GIN 1N.";
$lang['useraccountcreatedconfirmsuccess'] = "yOur uS3r 4ccouN+ H@\$ BEeN Crea+ED BU+ 8Eph0Re J00 CAn sT4r+ p0\$+1n9 J00 mUSt ConF1rm Y0ur eMA1l 4DdREss. Pl3AS3 CheCK yOur eM41l PH0R @ L1nk th@T WilL aLL0w J00 +o Conf1rM y0uR 4DDrES\$.";
$lang['useraccountcreated'] = "yOUR US3r @ccOun+ h4S B3en Cr3@teD sUcce5sfULly! CL1cK tHE COnT1Nu3 buTToN 8EloW to L0G1n";
$lang['errorcreatinguserrecord'] = "eRr0R cr3ATinG user REC0rd";
$lang['userregistration'] = "usER R391\$tr4tioN";
$lang['registrationinformationrequired'] = "reG1\$TR@+I0n InForM4+I0N (R3QUir3d)";
$lang['profileinformationoptional'] = "pR0ph1lE 1Nf0Rm4+i0n (0Pt1oN@L)";
$lang['preferencesoptional'] = "preph3r3nc3S (0P+10nAl)";
$lang['register'] = "r3g1\$tER";
$lang['rememberpasswd'] = "r3MEm83r pasSw0RD";
$lang['birthdayrequired'] = "y0ur d4+3 0F B1RTh 1\$ r3qu1R3D 0r 15 1Nv4L1D";
$lang['alwaysnotifymeofrepliestome'] = "n0+1phy 0N rEpLy +0 mE";
$lang['notifyonnewprivatemessage'] = "noTipHy 0n new prIv@+3 mE\$S4g3";
$lang['popuponnewprivatemessage'] = "p0p up on n3w PR1v4+3 MEss4g3";
$lang['automatichighinterestonpost'] = "au+0m@+ic h1GH iN+3RE\$+ 0n p0\$+";
$lang['confirmpassword'] = "c0NpH1RM P4\$\$worD";
$lang['invalidemailaddressformat'] = "inv4l1D 3Ma1l aDDrESs f0Rm4+";
$lang['moreoptionsavailable'] = "mOr3 pRoFILE @nd pR3fEr3NC3 0pt10n5 @R3 4v4il@8LE onCE j00 REg15+Er";
$lang['textcaptchaconfirmation'] = "c0nfirm@+ioN";
$lang['textcaptchaexplain'] = "t0 +H3 r1Gh+ is 4 t3xt-C4p+Cha iM493. pl3@sE tYpe +H3 CoDE j00 C4N 53E in +H3 im@9E in+0 +hE inPUt phi3LD b3low 1+.";
$lang['textcaptchaimgtip'] = "tH1s i\$ 4 C@P+ChA-p1c+urE. 1+ Is UsED +0 prEven+ 4U+omA+1c r39is+r4t10n";
$lang['textcaptchamissingkey'] = "a c0nphirM@+i0N CoD3 1S r3qu1R3D.";
$lang['textcaptchaverificationfailed'] = "tExT-C@ptChA vEriF1C@T10n c0DE w@\$ InC0RRECT. pLe4\$3 r3-eNtEr 1+.";
$lang['forumrules'] = "foRUm rUl3S";
$lang['forumrulesnotification'] = "iN 0rD3r to pR0C3eD, J00 must 49r3E w1+H +eh pHolL0wiNg rUl3s";
$lang['forumrulescheckbox'] = "i H4ve re4D, 4ND A9R3E +o @BID3 8Y t3H foRUm Rul3S.";
$lang['youmustagreetotheforumrules'] = "j00 mu5T 49r3E t0 THE f0rUM ruLE5 BEF0re j00 CaN CoN+inuE.";

// Recent visitors list  (visitor_log.php) -----------------------------

$lang['member'] = "m3M8ER";
$lang['searchforusernotinlist'] = "se4rCh ph0R @ Us3R n0t 1n l1ST";
$lang['yoursearchdidnotreturnanymatches'] = "your \$e4rCh D1d not rETUrn 4nY M4+ch3S. trY s1MpL1FYinG Y0Ur sEArch p4R4M3ters AnD +ry 4G4in.";
$lang['hiderowswithemptyornullvalues'] = "h1D3 r0WS w1+H empty or nUll v4LU3\$ In \$3lECT3D COLuMn5";
$lang['showregisteredusersonly'] = "sh0W rEG1S+eR3D uSEr\$ 0nly (H1DE 9uEsTs)";

// Relationships (user_rel.php) ----------------------------------------

$lang['relationships'] = "r3l4+1ON\$H1ps";
$lang['userrelationship'] = "u\$3r R3l4ti0N\$hip";
$lang['userrelationships'] = "usEr r3l4+IONsh1Ps";
$lang['failedtoremoveselectedrelationships'] = "f41l3D +0 ReMov3 sel3cTEd rEL4t10n\$hip";
$lang['friends'] = "fR1Ends";
$lang['ignoredcompletely'] = "i9noREd c0MPLeTEly";
$lang['relationship'] = "rEl4+10n\$HIp";
$lang['restorenickname'] = "re\$+orE Us3R's nICkN@m3";
$lang['friend_exp'] = "user'\$ pOS+s m@rk3D witH @ &quot;PHrienD&quot; 1c0N.";
$lang['normal_exp'] = "u5Er's po\$Ts 4Pp3aR @\$ n0rM4l.";
$lang['ignore_exp'] = "us3R'\$ po5+S are HiDD3n.";
$lang['ignore_completely_exp'] = "thRE4D\$ 4nd post\$ +0 0R From us3r W1ll @pPE4R D3lEteD.";
$lang['display'] = "d1Spl4y";
$lang['displaysig_exp'] = "u53R'S s1gn4tUR3 1\$ D1spl4Y3D 0N ThEIr P0\$+s.";
$lang['hidesig_exp'] = "uSEr'\$ 5I9n@+ure 1\$ hIDDEn 0N tH3Ir P0\$ts.";
$lang['cannotignoremod'] = "j00 C4NNoT 1Gn0re +his usEr, 4s tH3Y @R3 @ moDER@+0R.";
$lang['previewsignature'] = "pr3v13w s19na+ur3";

// Search (search.php) -------------------------------------------------

$lang['searchresults'] = "s3@rCh re5ults";
$lang['usernamenotfound'] = "the Us3rn4M3 J00 \$p3CifieD 1n +h3 to 0r Phrom Phi3LD w4\$ N0t PH0und.";
$lang['notexttosearchfor'] = "on3 0r 4ll of Y0Ur sE4RCh k3Yw0rds W3RE 1Nv4l1D. se4rCh k3Yw0rDs mus+ 83 n0 sh0r+3R tH@N %d Ch4RAC+3rs, n0 l0n9er +h4N %d CH@rActErs and Mu\$+ nO+ @Ppe4R 1n +3H %s";
$lang['keywordscontainingerrors'] = "k3yw0rDs CoN+@1N1n9 3RroRs: %s";
$lang['mysqlstopwordlist'] = "mYsQL s+opW0rD Li\$+";
$lang['foundzeromatches'] = "founD: 0 m@+Ch3S";
$lang['found'] = "foUND";
$lang['matches'] = "m4+CHEs";
$lang['prevpage'] = "pr3v10us P4ge";
$lang['findmore'] = "f1nd MorE";
$lang['searchmessages'] = "se4rcH mes\$49ES";
$lang['searchdiscussions'] = "sE4rCh di\$Cu\$\$ion\$";
$lang['find'] = "fInd";
$lang['additionalcriteria'] = "addi+10n4l CRi+erI@";
$lang['searchbyuser'] = "s34rCh by UseR (Op+i0N@L)";
$lang['folderbrackets_s'] = "f0LD3r(s)";
$lang['postedfrom'] = "p0S+3D phr0M";
$lang['postedto'] = "po5+3d t0";
$lang['today'] = "today";
$lang['yesterday'] = "y3\$terd4Y";
$lang['daybeforeyesterday'] = "d@Y 83Ph0RE YE\$tErdaY";
$lang['weekago'] = "%s We3k @g0";
$lang['weeksago'] = "%s W3EKs 490";
$lang['monthago'] = "%s month @g0";
$lang['monthsago'] = "%s m0nTh5 @GO";
$lang['yearago'] = "%s Ye@r @Go";
$lang['beginningoftime'] = "b3G1NNinG 0Ph t1M3";
$lang['now'] = "noW";
$lang['lastpostdate'] = "l4\$+ p0st D4+3";
$lang['numberofreplies'] = "nUMber of rEpl1es";
$lang['foldername'] = "fOLDER n4M3";
$lang['authorname'] = "aU+hor n4m3";
$lang['decendingorder'] = "nEw35+ phir\$+";
$lang['ascendingorder'] = "oLd3st f1RSt";
$lang['keywords'] = "k3YWorDs";
$lang['sortby'] = "sOr+ 8Y";
$lang['sortdir'] = "sor+ D1r";
$lang['sortresults'] = "s0Rt r3sUl+S";
$lang['groupbythread'] = "gr0up By tHrE4D";
$lang['postsfromuser'] = "poS+s fr0M u\$3r";
$lang['poststouser'] = "p0st\$ +0 usEr";
$lang['poststoandfromuser'] = "p05+5 To 4ND Phrom Us3r";
$lang['searchfrequencyerror'] = "j00 C4N oNlY \$3arch 0nC3 eV3Ry %s \$eC0nd\$. pLE4SE tRy 494IN La+er.";
$lang['searchsuccessfullycompleted'] = "se4rCh \$ucc3SSFully C0mpl3t3D. %s";
$lang['clickheretoviewresults'] = "click h3Re +o vIEw r3sULTs.";

// Search Popup (search_popup.php) -------------------------------------

$lang['select'] = "sELeC+";
$lang['searchforthread'] = "s34RCH phor THre4D";
$lang['mustspecifytypeofsearch'] = "j00 must \$p3C1fY +ypE 0f \$E4rch tO pErph0rM";
$lang['unkownsearchtypespecified'] = "unknowN \$3arCh typ3 spECIPhi3d";
$lang['mustentersomethingtosearchfor'] = "j00 mUs+ 3NtEr s0m3th1Ng +0 SEarCh F0R";

// Start page (start_left.php) -----------------------------------------

$lang['recentthreads'] = "rECent thRE4D\$";
$lang['startreading'] = "s+@R+ r3ad1Ng";
$lang['threadoptions'] = "tHread op+1ON\$";
$lang['editthreadoptions'] = "edIt +hr34D opt10n\$";
$lang['morevisitors'] = "m0re v1\$i+0R5";
$lang['forthcomingbirthdays'] = "f0r+hComing 81r+hd@Y\$";

// Start page (start_main.php) -----------------------------------------

$lang['editstartpage_help'] = "j00 C@N ED1+ tHi\$ P4g3 pHr0m the 4DM1n 1nterf4C3";

// Thread navigation (thread_list.php) ---------------------------------

$lang['newdiscussion'] = "n3w d1\$cu\$si0n";
$lang['createpoll'] = "cRe@te polL";
$lang['search'] = "se@rCh";
$lang['searchagain'] = "s3ARCh 4G@iN";
$lang['alldiscussions'] = "all disCU\$S1ons";
$lang['unreaddiscussions'] = "uNRE4d Di5CU\$S1ons";
$lang['unreadtome'] = "unR34d &quot;T0: mE&quot;";
$lang['todaysdiscussions'] = "t0Day'S D1\$CUssi0N\$";
$lang['2daysback'] = "2 D@Y5 8aCK";
$lang['7daysback'] = "7 days 84CK";
$lang['highinterest'] = "h1gH IntEr3ST";
$lang['unreadhighinterest'] = "unr3aD H19h iNter3ST";
$lang['iverecentlyseen'] = "i've rEC3N+ly \$e3N";
$lang['iveignored'] = "i'VE ign0rED";
$lang['byignoredusers'] = "bY 1gn0rEd us3rs";
$lang['ivesubscribedto'] = "i'v3 SU8sCr18eD +0";
$lang['startedbyfriend'] = "stARt3d BY phri3nD";
$lang['unreadstartedbyfriend'] = "uNreaD stD 8y Fr1EnD";
$lang['startedbyme'] = "s+@rt3D By m3";
$lang['unreadtoday'] = "unre4D +0D4y";
$lang['deletedthreads'] = "dEle+3d +hr34D\$";
$lang['goexcmark'] = "go!";
$lang['folderinterest'] = "f0LDEr In+3rest";
$lang['postnew'] = "poST nEw";
$lang['currentthread'] = "cuRR3nt thrE4D";
$lang['highinterest'] = "h1GH intEr3st";
$lang['markasread'] = "m4rk 4S r34D";
$lang['next50discussions'] = "n3x+ 50 Di\$cUs\$1oNs";
$lang['visiblediscussions'] = "v1\$1Ble D1ScUss1On\$";
$lang['selectedfolder'] = "s3LEC+eD phold3R";
$lang['navigate'] = "n@Vi94+3";
$lang['couldnotretrievefolderinformation'] = "tHER3 aR3 n0 PholdERs @v@Il@8LE.";
$lang['nomessagesinthiscategory'] = "n0 mEss4G3s 1n thi\$ C4+39Ory. plE453 \$3lECt 4noth3R, or %s Phor @ll +hr3ads";
$lang['clickhere'] = "cL1ck h3re";
$lang['prev50threads'] = "preV1Ou5 50 thR34D\$";
$lang['next50threads'] = "n3XT 50 +hr3ADs";
$lang['nextxthreads'] = "n3X+ %s thr34Ds";
$lang['threadstartedbytooltip'] = "tHr3AD #%s st4r+3d 8y %s. v1EweD %s";
$lang['threadviewedonetime'] = "1 +1ME";
$lang['threadviewedtimes'] = "%d times";
$lang['unreadthread'] = "uNr34D Thr3@D";
$lang['readthread'] = "r34d thrE@D";
$lang['unreadmessages'] = "uNr3@D me5\$49Es";
$lang['subscribed'] = "sU85Cri83d";
$lang['ignorethisfolder'] = "igN0re +his Ph0lD3R";
$lang['stopignoringthisfolder'] = "s+Op 1GN0R1ng +HI\$ PhOlDER";
$lang['stickythreads'] = "s+icky +Hr34d\$";
$lang['mostunreadposts'] = "mOs+ UNr3@D p0ST5";
$lang['onenew'] = "%d NEW";
$lang['manynew'] = "%d new";
$lang['onenewoflength'] = "%d n3W oph %d";
$lang['manynewoflength'] = "%d N3W oph %d";
$lang['ignorefolderconfirm'] = "are J00 \$ure j00 w4N+ +O 1gNorE +his ph0ldEr?";
$lang['unignorefolderconfirm'] = "aRe j00 \$UrE j00 w@n+ +o \$+0p ign0rinG this F0LDEr?";
$lang['confirmmarkasread'] = "aRe j00 sur3 J00 waNt t0 m4rK The \$el3ct3D +hr34D5 as r34d?";
$lang['successfullymarkreadselectedthreads'] = "sUcCEs\$PhUllY M@RkeD sEL3ct3d +HrE4D\$ a5 Re4D";
$lang['failedtomarkselectedthreadsasread'] = "f@ileD to m4Rk sel3C+3d +hR3ADs @s RE4d";
$lang['gotofirstpostinthread'] = "g0 t0 phir\$+ Pos+ 1n +hr34D";
$lang['gotolastpostinthread'] = "g0 tO lAst Po5T iN +hr34D";
$lang['viewmessagesinthisfolderonly'] = "vIew mEssa93S in +h1\$ phOld3r 0nly";
$lang['shownext50threads'] = "sH0w n3x+ 50 +hr3@ds";
$lang['showprev50threads'] = "shOW pr3vi0us 50 +hR34d\$";
$lang['createnewdiscussioninthisfolder'] = "cR34+3 N3w di\$cUs5I0N 1N +hi\$ pHoldER";
$lang['nomessages'] = "n0 mess4G3S";

// HTML toolbar (htmltools.inc.php) ------------------------------------
$lang['bold'] = "b0ld";
$lang['italic'] = "i+@l1C";
$lang['underline'] = "uNd3RL1n3";
$lang['strikethrough'] = "stRIk3+hRou9h";
$lang['superscript'] = "sUPER5Crip+";
$lang['subscript'] = "sUBscr1P+";
$lang['leftalign'] = "l3ft-ali9N";
$lang['center'] = "c3n+ER";
$lang['rightalign'] = "ri9H+-ali9N";
$lang['numberedlist'] = "nUm83r3D li\$+";
$lang['list'] = "l15+";
$lang['indenttext'] = "ind3nt tEx+";
$lang['code'] = "codE";
$lang['quote'] = "qUOt3";
$lang['spoiler'] = "sPo1L3R";
$lang['horizontalrule'] = "hOr1zon+@l rUl3";
$lang['image'] = "im4g3";
$lang['hyperlink'] = "hyperlink";
$lang['noemoticons'] = "d1\$@8LE 3motIc0ns";
$lang['fontface'] = "foNT phAC3";
$lang['size'] = "s1z3";
$lang['colour'] = "cOl0ur";
$lang['red'] = "red";
$lang['orange'] = "oR@n9E";
$lang['yellow'] = "y3Ll0w";
$lang['green'] = "gR3en";
$lang['blue'] = "bLu3";
$lang['indigo'] = "inD1g0";
$lang['violet'] = "vioLET";
$lang['white'] = "whI+e";
$lang['black'] = "bL4ck";
$lang['grey'] = "gR3y";
$lang['pink'] = "pInk";
$lang['lightgreen'] = "l19ht gr3En";
$lang['lightblue'] = "lI9h+ 8lUE";

// Forum Stats (messages.inc.php - messages_forum_stats()) -------------

$lang['forumstats'] = "f0Rum 5+@Ts";
$lang['usersactiveinthepasttimeperiod'] = "%s 4c+ive iN tEh p4St %s. %s";

$lang['numactiveguests'] = "<b>%s</b> gu3\$+s";
$lang['oneactiveguest'] = "<b>1</b> gu3st";
$lang['numactivemembers'] = "<b>%s</b> MemB3R5";
$lang['oneactivemember'] = "<b>1</b> M3m83R";
$lang['numactiveanonymousmembers'] = "<b>%s</b> anonymous MEmBERs";
$lang['oneactiveanonymousmember'] = "<b>1</b> @n0nymOUs m3M83r";

$lang['numthreadscreated'] = "<b>%s</b> Thre4DS";
$lang['onethreadcreated'] = "<b>1</b> Thr34D";
$lang['numpostscreated'] = "<b>%s</b> Po\$+5";
$lang['onepostcreated'] = "<b>1</b> posT";

$lang['younormal'] = "j00";
$lang['youinvisible'] = "j00 (invi\$i8le)";
$lang['viewcompletelist'] = "v1Ew C0mplETe li5t";
$lang['ourmembershavemadeatotalofnumthreadsandnumposts'] = "our m3MbeR\$ h@vE m4De 4 t0+4L Of %s 4nD %s.";
$lang['longestthreadisthreadnamewithnumposts'] = "lON9e5+ +Hr3Ad I\$ <b>%s</b> WiTH %s.";
$lang['therehavebeenxpostsmadeinthelastsixtyminutes'] = "tH3Re h4V3 B33n <b>%s</b> PO\$+s M4d3 iN +hE lAsT 60 mInU+35.";
$lang['therehasbeenonepostmadeinthelastsxityminutes'] = "tH3re hAs b3EN <b>1</b> P0S+ m@d3 In +3H l@s+ 60 m1nUt3S.";
$lang['mostpostsevermadeinasinglesixtyminuteperiodwasnumposts'] = "mO\$+ po\$+s 3V3r M4D3 IN @ \$iNgl3 60 MiNU+3 p3ri0D is <b>%s</b> 0n %s.";
$lang['wehavenumregisteredmembersandthenewestmemberismembername'] = "w3 h4v3 <b>%s</b> r391\$+3rED m3m83r\$ @Nd tEh nEwe\$+ M3MB3R is <b>%s</b>.";
$lang['wehavenumregisteredmember'] = "w3 h4Ve %s r39ISter3d mem8ERs.";
$lang['wehaveoneregisteredmember'] = "w3 h4v3 onE rEg1\$ter3D mEm8Er.";
$lang['mostuserseveronlinewasnumondate'] = "m0ST u\$3rS 3V3r onl1NE w@s <b>%s</b> on %s.";
$lang['statsdisplaychanged'] = "s+@ts D1\$pl4y cH4N93D";

// Thread Options (thread_options.php) ---------------------------------

$lang['updatessavedsuccessfully'] = "uPdates s4V3d \$uCCEssfuLlY";
$lang['useroptions'] = "u\$Er op+i0N5";
$lang['markedasread'] = "m4rk3d @s R34d";
$lang['postsoutof'] = "p05t\$ 0u+ of";
$lang['interest'] = "iN+ErEst";
$lang['closedforposting'] = "cL0S3D ph0R Po\$+inG";
$lang['locktitleandfolder'] = "l0ck +itlE @nD F0lD3r";
$lang['deletepostsinthreadbyuser'] = "d3L3T3 p05+5 1n +hR34d By usER";
$lang['deletethread'] = "dEl3t3 +HR34D";
$lang['permenantlydelete'] = "p3Rm4NentLy DElE+e";
$lang['movetodeleteditems'] = "m0v3 +O del3TED +hREaDs";
$lang['undeletethread'] = "uNd3letE +hr34d";
$lang['threaddeletedpermenantly'] = "tHr3@d DEl3t3d p3Rm@N3ntLy. C4nN0t uND3LEtE.";
$lang['markasunread'] = "m4Rk 45 uNrE4D";
$lang['makethreadsticky'] = "m4K3 thre4d s+1cKy";
$lang['threareadstatusupdated'] = "thR34d rEaD 5+@TU\$ UpD4ted suCCessfUllY";
$lang['interestupdated'] = "tHr34d In+3REst \$t4+us upD4T3D \$UCcessfuLly";
$lang['failedtoupdatethreadreadstatus'] = "fAiled To UPD@+3 tHR34d rE4D sT4+Us";
$lang['failedtoupdatethreadinterest'] = "f4Il3D +0 upd4+E +Hr34D iNt3R3st";
$lang['failedtorenamethread'] = "fa1l3D t0 renAMe Thre4D";
$lang['failedtomovethread'] = "f4iL3d +o MovE Thr3@D To sP3CifiEd FolDEr";
$lang['failedtoupdatethreadstickystatus'] = "f4ILeD TO updaTe +hr3Ad 5T1cKY sT4+uS";
$lang['failedtoupdatethreadclosedstatus'] = "f@ILed T0 UPD@t3 THr34D CL0SeD \$+@tU\$";
$lang['failedtoupdatethreadlockstatus'] = "f4Il3D t0 upda+e +hr34d L0cK \$+4TU5";
$lang['failedtodeletepostsbyuser'] = "f@ileD to DEl3+3 p0ST5 8Y 53L3C+3D US3R";
$lang['failedtodeletethread'] = "f41L3D to D3leTE THrEAD.";
$lang['failedtoundeletethread'] = "f4IL3d +0 uN-d3L3te thRe4d";

// Dictionary (dictionary.php) -----------------------------------------

$lang['dictionary'] = "d1c+iOn4ry";
$lang['spellcheck'] = "sP3LL CheCk";
$lang['notindictionary'] = "n0t 1N d1c+1on4RY";
$lang['changeto'] = "cH@nge +o";
$lang['restartspellcheck'] = "r3\$+@rt";
$lang['cancelchanges'] = "c@nc3l CH@nGEs";
$lang['initialisingdotdotdot'] = "iN1T14l151ng...";
$lang['spellcheckcomplete'] = "sp3ll cheCK 1S cOMplE+e. t0 r35t4r+ sP3lL ch3Ck CLiCk R3st4Rt 8UttOn 8Elow.";
$lang['spellcheck'] = "sP3ll ch3Ck";
$lang['noformobj'] = "n0 pH0RM O8j3CT SP3c1PH1Ed Ph0r rE+uRN T3X+";
$lang['bodytext'] = "b0DY +3Xt";
$lang['ignore'] = "i9n0re";
$lang['ignoreall'] = "i9n0rE 4Ll";
$lang['change'] = "cHang3";
$lang['changeall'] = "ch4nge @ll";
$lang['add'] = "aDd";
$lang['suggest'] = "sUg93s+";
$lang['nosuggestions'] = "(nO \$u9ges+10N5)";
$lang['cancel'] = "c@NCEL";
$lang['dictionarynotinstalled'] = "n0 DiCT10nARY h@\$ beEn Inst4llED. pl3ase coNt4C+ +hE F0rUm owN3r to r3mEDy +Hi\$.";

// Permissions keys ----------------------------------------------------

$lang['postreadingallowed'] = "p05+ RE4d1N9 @lLoW3D";
$lang['postcreationallowed'] = "po\$T CRE4+i0N alloWeD";
$lang['threadcreationallowed'] = "thr34D CR3A+1ON 4Ll0W3D";
$lang['posteditingallowed'] = "p0St 3D1t1ng @Ll0w3D";
$lang['postdeletionallowed'] = "p0st Del3+I0N 4lL0WED";
$lang['attachmentsallowed'] = "aTt4chmEn+s alLowED";
$lang['htmlpostingallowed'] = "htmL Po5+1n9 alL0w3D";
$lang['signatureallowed'] = "siGn4+uRe @ll0W3d";
$lang['guestaccessallowed'] = "gu3ST 4ccEss 4lL0W3d";
$lang['postapprovalrequired'] = "p0S+ appR0v@l r3qUir3D";

// RSS feeds gubbins

$lang['rssfeed'] = "rsS Fe3D";
$lang['every30mins'] = "eVery 30 minut3s";
$lang['onceanhour'] = "oNce @N h0ur";
$lang['every6hours'] = "ev3RY 6 hours";
$lang['every12hours'] = "eV3ry 12 h0urs";
$lang['onceaday'] = "oNce 4 Day";
$lang['rssfeeds'] = "rsS feED\$";
$lang['feedname'] = "fE3d n4M3";
$lang['feedfoldername'] = "f3eD f0lDeR Name";
$lang['feedlocation'] = "fE3D l0C@tI0N";
$lang['threadtitleprefix'] = "tHread +1+l3 prEPh1x";
$lang['feednameandlocation'] = "fE3d n4me @nd L0C4+i0N";
$lang['feedsettings'] = "f3ed \$et+in9S";
$lang['updatefrequency'] = "upd@te fR3qu3NCY";
$lang['rssclicktoreadarticle'] = "clICK hErE +0 r3@D Th1\$ @rticL3";
$lang['addnewfeed'] = "add new F33D";
$lang['editfeed'] = "eDit ph3eD";
$lang['feeduseraccount'] = "f33d usEr aCCOunT";
$lang['noexistingfeeds'] = "nO Exi\$+InG R5\$ PH3ed5 ph0unD. t0 @Dd @ ph3eD Click +hE 'add n3W' 8U++0n B3L0w";
$lang['rssfeedhelp'] = "h3R3 j00 Can sEtup \$0mE r\$s PH3ed5 F0r 4u+0m@+iC proP494tion iN+0 your ph0rUm. +Eh i+3M5 phROM +h3 r\$s f3EDs j00 4DD will 8e Cr3@+3D @s +Hr34d5 whICH user\$ c4n REPly +0 45 If +h3Y W3rE n0Rm4l p0STS. +h3 r\$S F33d must 83 4CCEss1BLe vi@ ht+P or 1+ wilL N0+ w0rk.";
$lang['mustspecifyrssfeedname'] = "mUst speCIfY r5\$ fE3D nAmE";
$lang['mustspecifyrssfeeduseraccount'] = "muSt 5P3CIfy rSS PH3ED U53R @CCOUnt";
$lang['mustspecifyrssfeedfolder'] = "muSt sp3Cify rs\$ FE3d f0LDer";
$lang['mustspecifyrssfeedurl'] = "muST sp3cipHy rSS FeeD Url";
$lang['mustspecifyrssfeedupdatefrequency'] = "mu\$+ sp3Ciphy R\$S FEED Upd@+E phREqU3nCy";
$lang['unknownrssuseraccount'] = "unKnown Rss u\$er 4CC0unt";
$lang['rssfeedsupportshttpurlsonly'] = "rsS FeED supPort\$ H++p urLs 0Nly. 53curE fE3ds (H++P\$://) ArE No+ 5UPp0RtED.";
$lang['rssfeedurlformatinvalid'] = "r\$\$ f3Ed uRl pHorm@t I\$ 1nv4L1D. urL MU\$+ 1nclUD3 SchemE (E.g. Http://) 4nD a h05+n4M3 (3.G. WwW.ho\$+n4m3.C0m).";
$lang['rssfeeduserauthentication'] = "r\$\$ Phe3D D0e\$ n0T 5UPport ht+p u\$3r @U+Hent1c4+i0n";
$lang['successfullyremovedselectedfeeds'] = "sUcC3ssfuLly rEmov3D \$ELEC+ED ph33d\$";
$lang['successfullyaddedfeed'] = "sUcCEssFulLy @DDEd N3w f33d";
$lang['successfullyeditedfeed'] = "sUcCE\$SFUlly 3D1+3D fEEd";
$lang['failedtoremovefeeds'] = "f@1L3d +o r3MOV3 \$0m3 Or 4lL Oph thE sEL3C+3D fe3D5";
$lang['failedtoaddnewrssfeed'] = "f4IL3D +0 adD n3w r\$s PH3ED";
$lang['failedtoupdaterssfeed'] = "f@il3D +0 UpDA+E r\$S pH3Ed";
$lang['rssstreamworkingcorrectly'] = "rss \$+RE4m 4PpE4rs +0 B3 worK1ng C0RrECtlY";
$lang['rssstreamnotworkingcorrectly'] = "r\$\$ s+R34m W@s 3Mp+y 0r COUlD No+ BE F0UND";
$lang['invalidfeedidorfeednotfound'] = "inV4L1D Phe3d iD oR FeeD No+ f0UND";

// PM Export Options

$lang['pmexportastype'] = "exP0rt 4\$ +yP3";
$lang['pmexporthtml'] = "h+ML";
$lang['pmexportxml'] = "xML";
$lang['pmexportplaintext'] = "pl@in t3xt";
$lang['pmexportmessagesas'] = "exP0R+ m3Ss4G3s @\$";
$lang['pmexportonefileforallmessages'] = "onE pH1lE F0R 4lL mEss49es";
$lang['pmexportonefilepermessage'] = "on3 f1LE p3R m3ss49e";
$lang['pmexportattachments'] = "exP0rt 4t+@chMEnts";
$lang['pmexportincludestyle'] = "iNCluDE phoruM sTyl3 sh3E+";
$lang['pmexportwordfilter'] = "aPply w0rd fiL+ER t0 M3ss493s";

// Thread merge / split options

$lang['threadhasbeensplit'] = "tHr34D H@s 8EEn SPl1+";
$lang['threadhasbeenmerged'] = "tHR3@d H4s 8EEn mEr9ED";
$lang['mergesplitthread'] = "m3R9e / \$pl1t Thr34d";
$lang['mergewiththreadid'] = "mEr9E wi+H +Hr34D id:";
$lang['postsinthisthreadatstart'] = "posts 1N +his +hr34D aT s+@rt";
$lang['postsinthisthreadatend'] = "p05+s iN +his thREaD @t 3ND";
$lang['reorderpostsintodateorder'] = "r3-0rder pOsts 1N+0 D4tE orDEr";
$lang['splitthreadatpost'] = "sPL1+ tHr34d 4+ Pos+:";
$lang['selectedpostsandrepliesonly'] = "seleC+eD p0S+ 4ND r3plies onLy";
$lang['selectedandallfollowingposts'] = "seLEC+Ed @nD 4Ll F0LloWiNg pO\$TS";

$lang['threadmovedhere'] = "hEre";

$lang['thisthreadhasmoved'] = "<b>tHR34ds merG3D:</b> tH1S tHrE4d h@\$ MoV3d %s";
$lang['thisthreadwasmergedfrom'] = "<b>thRE4D5 M3RGeD:</b> +H1S +hr34D w4s M3RGED phroM %s";
$lang['somepostsinthisthreadhavebeenmoved'] = "<b>tHR3AD spl1+:</b> SomE Pos+s 1n thi\$ +hrEAD H@v3 8EEn m0V3D %s";
$lang['somepostsinthisthreadweremovedfrom'] = "<b>tHr3aD spl1+:</b> SomE p0STs 1n thi\$ thre4d wER3 moV3d PHroM %s";

$lang['thisposthasbeenmoved'] = "<b>tHre4D 5pL1+:</b> +h1\$ Po5+ h@5 8EEn m0vEd %s";

$lang['invalidfunctionarguments'] = "inv@L1D PhUNC+1on @rGUmEn+\$";
$lang['couldnotretrieveforumdata'] = "c0uLD Not rE+ri3VE pH0RUm d4+4";
$lang['cannotmergepolls'] = "onE 0R m0RE +hrE4Ds 1s 4 PolL. J00 c4NNo+ MEr93 P0ll\$";
$lang['couldnotretrievethreaddatamerge'] = "c0uld no+ rEtri3Ve thR3@D D4+@ PHrom on3 0r M0RE +hr34Ds";
$lang['couldnotretrievethreaddatasplit'] = "c0ULD no+ rEtr13V3 +hreaD D@+4 fr0m sOuRC3 thr3AD";
$lang['couldnotretrievepostdatamerge'] = "c0ulD n0t rE+RiEv3 po\$+ D@t@ Phrom OnE 0R mOr3 ThR34d5";
$lang['couldnotretrievepostdatasplit'] = "c0Uld noT r3Tr13ve p05+ D@+@ PhR0M 5ouRC3 +HR34D";
$lang['failedtocreatenewthreadformerge'] = "f41l3D T0 CREa+e n3W +hr3AD f0r MErg3";
$lang['failedtocreatenewthreadforsplit'] = "f4Il3D +0 CrEAtE nEw +hR34d F0R \$Pli+";

// Thread subscriptions

$lang['threadsubscriptions'] = "thread sUBSCR1pT10n5";
$lang['couldnotupdateinterestonthread'] = "cOuld N0+ upD4TE in+3REs+ on +Hr34d '%s'";
$lang['threadinterestsupdatedsuccessfully'] = "tHRE4d 1nTEr3sts Upd4+3D 5UCCESsfUllY";
$lang['nothreadsubscriptions'] = "j00 4RE n0T sU8\$crib3d +O 4Ny +hrE4d\$.";
$lang['resetselected'] = "rEset \$EL3C+3d";
$lang['allthreadtypes'] = "all +Hr34d tYp3s";
$lang['ignoredthreads'] = "ignor3d +Hr34D\$";
$lang['highinterestthreads'] = "hIGh in+3r3\$+ +hR3Ad\$";
$lang['subscribedthreads'] = "su85crI8Ed +hR34d\$";
$lang['currentinterest'] = "cUrr3nt inter3ST";

// Browseable user profiles

$lang['youcanonlyaddthreecolumns'] = "j00 C4n onLy 4dD 3 c0LuMns. t0 4DD 4 n3W ColUMn Cl0SE 4n exis+ing onE";
$lang['columnalreadyadded'] = "j00 H4v3 4lr3ADy @DDED +His c0lUmn. IpH j00 w@n+ To R3MovE 1+ CliCk ITs Cl053 8u+ton";

?>
