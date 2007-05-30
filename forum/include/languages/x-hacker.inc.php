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

/* $Id: x-hacker.inc.php,v 1.233 2007-05-30 21:03:34 decoyduck Exp $ */

// British English language file

// Language character set and text direction options -------------------

$lang['_isocode'] = "en";
$lang['_textdir'] = "ltr";

// Months --------------------------------------------------------------

$lang['month'][1]  = "j4nU@rY";
$lang['month'][2]  = "f3Bru4RY";
$lang['month'][3]  = "m4rch";
$lang['month'][4]  = "aPr1l";
$lang['month'][5]  = "m@y";
$lang['month'][6]  = "jUn3";
$lang['month'][7]  = "july";
$lang['month'][8]  = "aUgUs+";
$lang['month'][9]  = "sEpT3M83R";
$lang['month'][10] = "oCt08ER";
$lang['month'][11] = "nOV3m83R";
$lang['month'][12] = "dEc3mb3r";

$lang['month_short'][1]  = "j4n";
$lang['month_short'][2]  = "f3B";
$lang['month_short'][3]  = "m4r";
$lang['month_short'][4]  = "aPr";
$lang['month_short'][5]  = "mAy";
$lang['month_short'][6]  = "jUn";
$lang['month_short'][7]  = "juL";
$lang['month_short'][8]  = "aU9";
$lang['month_short'][9]  = "s3P";
$lang['month_short'][10] = "oc+";
$lang['month_short'][11] = "n0V";
$lang['month_short'][12] = "dec";

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

$lang['date_periods']['year']   = "%s Y34R";
$lang['date_periods']['month']  = "%s mONTh";
$lang['date_periods']['week']   = "%s We3K";
$lang['date_periods']['day']    = "%s D@y";
$lang['date_periods']['hour']   = "%s HoUr";
$lang['date_periods']['minute'] = "%s MiNUTE";
$lang['date_periods']['second'] = "%s s3C0nD";

// As above but plurals (2 years vs. 1 year, etc.)

$lang['date_periods_plural']['year']   = "%s Ye4r\$";
$lang['date_periods_plural']['month']  = "%s moNtH\$";
$lang['date_periods_plural']['week']   = "%s we3k\$";
$lang['date_periods_plural']['day']    = "%s d@Ys";
$lang['date_periods_plural']['hour']   = "%s h0URS";
$lang['date_periods_plural']['minute'] = "%s MinUT3\$";
$lang['date_periods_plural']['second'] = "%s \$3coND5";

// Short hand periods (example: 1y, 2m, 3w, 4d, 5hr, 6min, 7sec)

$lang['date_periods_short']['year']   = "%sy";    // 1y
$lang['date_periods_short']['month']  = "%sM";    // 2m
$lang['date_periods_short']['week']   = "%sW";    // 3w
$lang['date_periods_short']['day']    = "%sd";    // 4d
$lang['date_periods_short']['hour']   = "%shr";   // 5hr
$lang['date_periods_short']['minute'] = "%sm1N";  // 6min
$lang['date_periods_short']['second'] = "%s\$3c";  // 7sec

// Common words --------------------------------------------------------

$lang['percent'] = "perceNt";
$lang['average'] = "aVer4G3";
$lang['approve'] = "aPPR0v3";
$lang['banned'] = "b@nn3d";
$lang['locked'] = "l0ckEd";
$lang['add'] = "aDd";
$lang['advanced'] = "adv4nc3d";
$lang['active'] = "aC+iV3";
$lang['style'] = "stYlE";
$lang['go'] = "gO";
$lang['folder'] = "f0ldEr";
$lang['ignoredfolder'] = "i9NoRed F0ld3R";
$lang['folders'] = "f0LD3r\$";
$lang['thread'] = "tHre4D";
$lang['threads'] = "thRe4D5";
$lang['threadlist'] = "tHre4d LIs+";
$lang['message'] = "m3s\$49E";
$lang['messagenumber'] = "mes\$49e nUm83r";
$lang['from'] = "from";
$lang['to'] = "to";
$lang['all_caps'] = "aLl";
$lang['of'] = "oPH";
$lang['reply'] = "rePly";
$lang['forward'] = "f0RW4rd";
$lang['replyall'] = "rEplY +0 4ll";
$lang['pm_reply'] = "r3PLY 4s PM";
$lang['delete'] = "dELe+3";
$lang['deleted'] = "dEleTed";
$lang['edit'] = "edI+";
$lang['privileges'] = "pR1vileG3S";
$lang['ignore'] = "i9NOR3";
$lang['normal'] = "norM@L";
$lang['interested'] = "iN+ereSt3d";
$lang['subscribe'] = "suB5cR183";
$lang['apply'] = "apPlY";
$lang['submit'] = "su8Mit";
$lang['download'] = "doWnL04d";
$lang['save'] = "s@V3";
$lang['update'] = "upd@TE";
$lang['cancel'] = "c4ncEL";
$lang['retry'] = "r3TRy";
$lang['continue'] = "c0N+1nUE";
$lang['attachment'] = "at+4cHM3n+";
$lang['attachments'] = "at+@chMenT\$";
$lang['imageattachments'] = "im4G3 4t+4Chm3n+\$";
$lang['filename'] = "f1L3N@mE";
$lang['dimensions'] = "dim3n\$I0n\$";
$lang['downloadedxtimes'] = "dOwNL04DEd: %d +1mes";
$lang['downloadedonetime'] = "doWNlO@Ded: 1 +Im3";
$lang['size'] = "siZ3";
$lang['viewmessage'] = "vi3W mES54gE";
$lang['deletethumbnails'] = "dELeT3 thuM8NaiL\$";
$lang['logon'] = "l0GOn";
$lang['more'] = "mORe";
$lang['recentvisitors'] = "rECenT VI\$1T0r5";
$lang['username'] = "u5ERn4M3";
$lang['clear'] = "cle@r";
$lang['action'] = "aC+ioN";
$lang['unknown'] = "unKn0wN";
$lang['none'] = "n0N3";
$lang['preview'] = "pReV1Ew";
$lang['post'] = "p0sT";
$lang['posts'] = "po5Ts";
$lang['change'] = "cH@n93";
$lang['yes'] = "y35";
$lang['no'] = "no";
$lang['signature'] = "si9N4tuRe";
$lang['signaturepreview'] = "s1GN4+UR3 PReV13W";
$lang['signatureupdated'] = "s1Gn4+uRe UPd@ted";
$lang['signatureupdatedforallforums'] = "s1Gn@+URe upd4+Ed phOR 4LL pH0RumS";
$lang['back'] = "b4Ck";
$lang['subject'] = "suBJ3Ct";
$lang['close'] = "clO\$e";
$lang['name'] = "n@me";
$lang['description'] = "dESCrip+1ON";
$lang['date'] = "dat3";
$lang['view'] = "v1ew";
$lang['enterpasswd'] = "eN+eR p4\$sW0rd";
$lang['passwd'] = "p4SSw0RD";
$lang['ignored'] = "ignOr3D";
$lang['guest'] = "gUe\$+";
$lang['next'] = "neX+";
$lang['prev'] = "pR3Vi0u5";
$lang['others'] = "o+h3rS";
$lang['nickname'] = "nicKn4me";
$lang['emailaddress'] = "eM41l 4Ddr3\$5";
$lang['confirm'] = "coNFirM";
$lang['email'] = "eM41L";
$lang['poll'] = "poLl";
$lang['friend'] = "fr13nd";
$lang['error'] = "err0R";
$lang['guesterror'] = "sORry, J00 neeD +0 B3 lOggED 1n +O u53 th1\$ f34TUR3.";
$lang['loginnow'] = "l091N N0W";
$lang['unread'] = "unre@d";
$lang['all'] = "all";
$lang['allcaps'] = "all";
$lang['permissions'] = "p3RMiSs10ns";
$lang['type'] = "tYp3";
$lang['print'] = "pR1Nt";
$lang['sticky'] = "sTIcky";
$lang['polls'] = "pOLL5";
$lang['user'] = "u\$Er";
$lang['enabled'] = "en48leD";
$lang['disabled'] = "diS@8LED";
$lang['options'] = "op+i0N5";
$lang['emoticons'] = "eMo+IcOnS";
$lang['webtag'] = "webt4G";
$lang['makedefault'] = "m@KE d3Ph@uL+";
$lang['unsetdefault'] = "uns3+ deF@uL+";
$lang['rename'] = "r3n4m3";
$lang['pages'] = "p49E\$";
$lang['used'] = "uSEd";
$lang['days'] = "d4YS";
$lang['usage'] = "uS@ge";
$lang['show'] = "sH0w";
$lang['hint'] = "h1nT";
$lang['new'] = "new";
$lang['referer'] = "r3FeReR";

// Admin interface (admin*.php) ----------------------------------------

$lang['admintools'] = "aDmIn +oOL5";
$lang['forummanagement'] = "f0rum M4NagemEn+";
$lang['accessdeniedexp'] = "j00 d0 NO+ H4Ve P3rmIsS1On +O UsE TH1s SEctI0n.";
$lang['managefolders'] = "m4n4ge PH0ld3Rs";
$lang['manageforums'] = "m@N49e phoRUm5";
$lang['manageforumpermissions'] = "m4n@93 phORum p3RMI\$s10N5";
$lang['foldername'] = "f0LdeR n4m3";
$lang['move'] = "m0v3";
$lang['closed'] = "cl0Sed";
$lang['open'] = "oPen";
$lang['restricted'] = "r3STr1c+ed";
$lang['iscurrentlyclosed'] = "i\$ cUrRentLy cL0\$Ed";
$lang['youdonothaveaccessto'] = "j00 D0 NO+ h@v3 @cc3S5 +0";
$lang['toapplyforaccessplease'] = "tO 4PpLy FOr @ccEsS plE4\$E COnT@C+ +eh PH0ruM oWNER.";
$lang['adminforumclosedtip'] = "if J00 w@NT To chaN93 S0M3 \$3++1ng\$ 0n y0Ur F0RuM cL1Ck +hE ADmIN l1Nk 1n the n@v1G4tIOn 8Ar A8oV3.";
$lang['newfolder'] = "n3w Ph0Ld3r";
$lang['forumadmin'] = "fORUm 4Dm1N";
$lang['adminexp_1'] = "uSE tH3 mENu 0n Th3 L3ph+ to m@n4g3 ThiNg\$ 1n y0Ur F0ruM.";
$lang['adminexp_2'] = "<b>u\$Er\$</b> 4Ll0w\$ j00 t0 5Et 1nD1viDU@l U5eR PermIs\$10N\$, 1ncLUd1n9 4PpoIn+1nG Ed1+OR\$ And 94g9in9 PE0PL3.";
$lang['adminexp_3'] = "<b>u\$er grouPS</b> 4ll0Ws J00 +O CRe4+e u5Er GR0up\$ t0 @5siGn P3rM1S5ion5 +0 A\$ m4ny 0r 45 pH3W u\$erS Qu1cKly 4Nd 3AS1Ly.";
$lang['adminexp_4'] = "<b>b4N coNtrOL\$</b> 4LlOw5 +He B4NnIn9 4Nd Un-B@nNiN9 oPh iP @Ddre553S, U5Ern4me5, 3m4il @ddRE\$SEs 4ND NIckN4Me5.";
$lang['adminexp_5'] = "<b>fOld3RS</b> @lL0wS the CR34T1On, moD1f1C4+I0n 4Nd dEl3tIon 0pH ph0ldERS.";
$lang['adminexp_6'] = "<b>rs5 pHeEds</b> 4llOwS j00 tO cr34+e @ND ReMoV3 R\$S ph33dS F0r PR0Pog4t1On iN+0 Y0uR ph0rUm.";
$lang['adminexp_7'] = "<b>prOPHileS</b> lETs J00 cUs+0MIs3 +he iTEM\$ +h4+ 4ppe4r 1n +3H U5er pr0phiLEs.";
$lang['adminexp_8'] = "<b>fOrUm \$EtT1N9S</b> ALL0w5 j00 +o cU\$Tom1\$e YOuR f0ruM's N@me, @pP34r@nC3 4nD m4ny 0th3R thIN9S.";
$lang['adminexp_9'] = "<b>sT4RT p4Ge</b> Let\$ j00 cu5+omIse y0ur pHOrUm'\$ sT4R+ P4ge.";
$lang['adminexp_10'] = "<b>f0RUm 5tYle</b> 4LLOwS J00 +0 CRe4+E stYLEs f0r y0ur phOrUm mEm83rS To u\$e.";
$lang['adminexp_11'] = "<b>w0RD fIL+ER</b> 4LL0w5 j00 +0 FiL+3R woRD\$ J00 d0n't W4Nt TO BE u\$ED 0n y0uR pHOrUm.";
$lang['adminexp_12'] = "<b>p0s+iN9 5T4+5</b> G3n3r4+3\$ 4 R3PorT lI5Tin9 tH3 t0p 10 POSteRs 1N 4 dephInED Per10d.";
$lang['adminexp_13'] = "<b>fOrum Link5</b> LE+S j00 M4n49e TH3 L1nK5 drOPd0wN iN Teh N@v1G@t1on b4R.";
$lang['adminexp_14'] = "<b>vi3w LO9</b> L15tS r3cen+ 4ct1OnS BY +EH f0ruM M0d3r4tOr\$.";
$lang['adminexp_15'] = "<b>m4N493 Ph0ruMS</b> L3tS J00 Cre@+e 4Nd deLEt3 4Nd cL0S3 OR r3OpEn PhOrum5.";
$lang['adminexp_16'] = "<b>gLo8@L F0rUm 5et+in9S</b> 4ll0W5 J00 tO M0diFy 5EtTin9\$ Wh1Ch 4pHFEcT 4ll PHoRumS.";
$lang['adminexp_17'] = "<b>p0st @ppR0V4L QuEUe</b> ALL0w5 j00 T0 VIeW 4nY poS+s @W41t1N9 4pPR0v4L bY 4 MoD3R4+0r.";
$lang['adminexp_18'] = "<b>v1sIt0r L0G</b> 4llOWS j00 t0 VIew 4N eX+ENded lis+ opH V1S1toR\$ inCludINg thE1r hTtp Reph3R3r5.";
$lang['createforumstyle'] = "cr34t3 @ F0RUM \$tyLe";
$lang['newstylesuccessfullycreated'] = "nEW \$tYle %s \$UCc3\$5FuLly CreaT3d.";
$lang['stylealreadyexists'] = "a 5+yl3 W1+h +H4+ pH1L3N@M3 4LRE4dY 3x1sT5.";
$lang['stylenofilename'] = "j00 D1D N0t 3nt3r 4 f1L3N@me +0 \$4Ve tH3 S+yl3 wiTH.";
$lang['stylenodatasubmitted'] = "couLD nO+ re4d F0ruM sTyLe d4+4.";
$lang['styleexp'] = "uSe th1s pag3 to hElp cr34+e 4 r4ND0mly gEneR4+3d 5tYl3 pH0r Y0ur ForUM.";
$lang['stylecontrols'] = "con+r0L\$";
$lang['stylecolourexp'] = "cl1ck ON 4 cOloUr TO m4Ke 4 N3w S+ylE sh33+ 8@Sed 0N th@+ c0lOur. cuRREN+ b4\$e c0l0uR i5 f1r5+ 1N li5T.";
$lang['standardstyle'] = "s+4Nd4rD 5tYl3";
$lang['rotelementstyle'] = "r0+4+eD El3M3N+ style";
$lang['randstyle'] = "r@nd0M 5tyl3";
$lang['thiscolour'] = "tHI5 c0l0Ur";
$lang['enterhexcolour'] = "oR 3nt3r @ HEx cOl0ur +0 8@5E 4 n3W 5tYle SHeeT 0n";
$lang['savestyle'] = "s4V3 tH15 \$TYl3";
$lang['styledesc'] = "s+yl3 DE\$CRip+10N";
$lang['fileallowedchars'] = "(LOwERCa\$E LET+ErS (@-Z), NUMb3R\$ (0-9) 4nD uNd3R5c0ReS (_) ONlY)";
$lang['stylepreview'] = "s+Yle Pr3v1EW";
$lang['welcome'] = "w3lc0m3";
$lang['messagepreview'] = "meS\$4G3 Pr3v1Ew";
$lang['users'] = "u53Rs";
$lang['usergroups'] = "u53r gROUps";
$lang['mustentergroupname'] = "j00 MU5T 3n+3R 4 GR0UP n4M3";
$lang['profiles'] = "pR0ph1L3\$";
$lang['manageforums'] = "m4n@GE f0ruM\$";
$lang['forumsettings'] = "f0RUm 5ettinGs";
$lang['globalforumsettings'] = "gL0BaL F0RUm 5e++IN9S";
$lang['settingsaffectallforumswarning'] = "<b>no+E:</b> TheS3 s3+tin9S 4FfecT 4ll f0RuMS. wH3r3 TH3 \$eT+1nG iS DUpLic4+ED 0n +HE 1Nd1VIduAl pH0Rum'S 53tTiNg5 p@93 tH4t W1lL +4K3 pr3c3D3ncE oV3R tH3 SEtTin9\$ j00 CHaNG3 H3R3.";
$lang['startpage'] = "s+@R+ P4Ge";
$lang['startpageerror'] = "y0Ur S+AR+ p4GE C0ULd N0t b3 s@V3d L0Cally +o +he SErveR 83c4u53 PerMisS1On W4\$ d3n1Ed.<br /><br />t0 ch@n9e YOur \$+4R+ P@ge pLe45e Cl1ck TH3 doWnlO@D 8U+t0N bel0w wh1ch wIll PROmPt J00 tO S4Ve T3H pH1l3 To yOUr H4RD dr1V3. j00 c4n +h3N uPl0@D +Hi\$ PhIL3 tO yOUR sErV3R INt0 +hE FoLlOWIn9 ph0lDeR, IPH NeCE554RY CrE4+1N9 +h3 PH0lD3R \$trUCtUr3 iN +eh Pr0c3S\$.<br /><br /><b>%s</b><br /><br />ple4\$e nO+3 +H4T \$0m3 Br0wS3RS M4Y cH4NgE tHe n4mE Of +3h f1L3 up0N d0WnlO@d.  wH3N uplO4diN9 +h3 FIl3 pl3453 m4KE 5URe th4+ 1t I5 N4MED ST4r+_M@In.pHP 0tHERwISE YOUr st4Rt p@gE WILl 4PpE4R UncH@n93D.";
$lang['failedtoopenmasterstylesheet'] = "y0Ur F0ruM STyle C0ULd N0+ 83 S4vEd b3C4u\$e +H3 m4s+3r stYL3 \$HeeT cOUld n0t BE lO@d3d. t0 \$4v3 yOUr \$+yLe TH3 M4\$+3r 5tYle Sh3et (m@k3_\$tylE.c5s) mU5T be L0C@teD 1n TEh \$TYle\$ d1r3CtOry of Y0Ur b33H1ve PHorUm 1nS+4LL4+i0n.";
$lang['makestyleerror'] = "youR PhORuM S+yL3 couLd NO+ bE s4Ved LOc@lLy +o Th3 \$ERv3r bEc4U53 Perm1ssiON w4S den1Ed. t0 s4ve y0UR ph0ruM 5TyLE pL345e Cl1ck +3h DOwnL0@d buT+0n 83Low whicH WIlL pROMp+ J00 To 54V3 +He phiLe TO youR H4Rd dR1V3. j00 c@N thEn UPL0@D tHI5 fil3 +0 y0UR \$3rV3r INtO %s PH0ldEr, iF N3c3s54rY cre4+1NG tEH pHOlDeR 5tRUctUrE iN ThE prOC3s\$. J00 \$h0ulD no+E +h4t 50mE brOW5ERs may cH@n9e t3h N4ME oPH +h3 phIlE UpOn DOWNl04d. wh3n uPlO4DIng Teh f1LE pL3@5E M4kE SuR3 +h4T 1+ 1S N@meD \$TYL3.cs\$ 0+H3RWi5E th3 F0rUM \$tYle wiLL b3 UnU548LE.";
$lang['uploadfailed'] = "y0UR neW St4r+ P@Ge coULd N0+ bE uPl0@DEd T0 +3h 53rvER 83c@U\$E p3rm15si0N Wa\$ DeNieD. pLe4\$e cHEck +h4t +eH web sErVEr / PHP pROC3s5 1s @BLe t0 WRi+3 +0 +Eh %s Ph0Ld3r ON Y0ur \$3RvEr.";
$lang['forumstyle'] = "f0RUM sTYl3";
$lang['wordfilter'] = "woRd fiLtEr";
$lang['forumlinks'] = "f0RUM l1nKS";
$lang['viewlog'] = "vi3W l0G";
$lang['noprofilesectionspecified'] = "no prof1Le sEC+10n 5pECipH1ed.";
$lang['itemname'] = "itEm N@Me";
$lang['moveto'] = "moV3 +o";
$lang['manageprofilesections'] = "m4n4ge pRopHILe \$3C+i0n\$";
$lang['sectionname'] = "sEC+1On n@mE";
$lang['items'] = "itEM5";
$lang['mustspecifyaprofilesectionid'] = "mus+ sPEc1fy 4 Pr0f1L3 \$ect1On 1D";
$lang['mustsepecifyaprofilesectionname'] = "mu\$t SpEc1PhY 4 prOF1L3 \$ect10N n@mE";
$lang['successfullyeditedprofilesection'] = "succESSpHulLy 3d1t3D pRoF1L3 \$ecTi0N";
$lang['addnewprofilesection'] = "add New Pr0fiLe 5EcTi0N";
$lang['mustsepecifyaprofilesectionname'] = "mU5t 5PeCiFY 4 prOphiLe SEc+10n n4M3";
$lang['successfullyremovedselectedprofilesections'] = "sUCCesSFulLy r3m0ved 5eleCt3D prOf1l3 \$EC+I0n5";
$lang['failedtoremoveprofilesections'] = "f@Il3d t0 RemOv3 pr0F1l3 \$3Cti0n\$";
$lang['viewitems'] = "v1eW i+3Ms";
$lang['successfullyremovedselectedprofileitems'] = "suCceS\$pHUllY rEm0Ved S3l3c+ed PR0F1L3 1tEMs";
$lang['failedtoremoveprofileitems'] = "f4iL3d +O R3mOvE prOPhiLE 1t3M5";
$lang['noexistingprofileitemsfound'] = "tHere @re nO 3x15+In9 pR0fiL3 I+em\$ 1n +H15 53c+10n. T0 @DD 4 PR0phiLe 1t3M cl1CK +hE Bu++0n 83L0W.";
$lang['edititem'] = "ed1T it3m";
$lang['invaliditemidoritemnotfound'] = "inV@l1D 1+eM 1D Or i+EM No+ Ph0uND";
$lang['addnewitem'] = "adD new ITem";
$lang['startpageupdated'] = "s+4rt p493 uPD4+eD";
$lang['viewupdatedstartpage'] = "vI3w uPdAt3d S+4rt p4G3";
$lang['editstartpage'] = "eD1+ st4R+ P@G3";
$lang['nouserspecified'] = "nO USeR SpEcipH13D.";
$lang['manageuser'] = "m4n@G3 U\$eR";
$lang['manageusers'] = "m4n@gE U5er5";
$lang['userstatusforforum'] = "usEr St4+u5 PHor %s";
$lang['userdetails'] = "u53r d3T41l5";
$lang['warning_caps'] = "w@rN1N9";
$lang['userdeleteallpostswarning'] = "aR3 J00 \$UR3 J00 W@nT +0 d3L3TE 4LL Of The Select3d USeR'S Po5+S? 0ncE t3h Po5Ts 4rE dEleTeD +Hey C@nNo+ 83 r3tr1eV3D 4nd wIll B3 LO\$t PH0Rev3R.";
$lang['postssuccessfullydeleted'] = "p0s+S werE \$ucce\$5pHullY deLET3D.";
$lang['folderaccess'] = "fOlD3r 4CceSS";
$lang['possiblealiases'] = "poS\$IBlE @Li4\$eS";
$lang['userhistory'] = "u\$eR h1s+0RY";
$lang['nohistory'] = "nO H1\$+0Ry R3C0RdS s4v3d";
$lang['userhistorychanges'] = "cH4N9eS";
$lang['clearuserhistory'] = "clE@r user H1\$t0rY";
$lang['changedlogonfromto'] = "cH4NGeD L090n FROm %s To %s";
$lang['changednicknamefromto'] = "ch4nGeD N1ckN4ME fR0M %s T0 %s";
$lang['changedemailfromto'] = "ch4N9Ed Em4Il fR0M %s To %s";
$lang['usersettingsupdated'] = "u\$Er 53t+In95 sUcc3S\$pHuLly updAtED";
$lang['nomatches'] = "n0 maTCH3\$";
$lang['deleteposts'] = "deLET3 P05t5";
$lang['deleteallusersposts'] = "dEl3T3 4lL 0f +H1S UsER'5 P0S+\$";
$lang['noattachmentsforuser'] = "no @+t4cHmENt\$ FoR +hIs u5Er";
$lang['forgottenpassworddesc'] = "ipH +hI5 uSeR H45 F0r9O+tEn +heir p@s5worD J00 c4n RE5et I+ pH0r tH3m h3R3.";
$lang['manageusersexp'] = "tH1S Li\$t SH0w5 4 s3lecT1On OF U5eR5 who H4v3 Lo99ed 0N +0 Y0UR fOrUM, SorTed by %s. +o 4l+ER 4 uS3r'S perM155i0ns CL1Ck +H31R n@me.";
$lang['userfilter'] = "us3r pHIl+eR";
$lang['onlineusers'] = "onl1nE UsER5";
$lang['offlineusers'] = "oPHFliNe uSerS";
$lang['usersawaitingapproval'] = "u5erS 4w@i+1n9 appR0vAl";
$lang['bannedusers'] = "b@Nn3D u\$Ers";
$lang['lastlogon'] = "l4s+ L0g0n";
$lang['sessionreferer'] = "se\$\$10n RepH3R3r";
$lang['signupreferer'] = "siGN-UP reph3r3r:";
$lang['nouseraccountsmatchingfilter'] = "no u\$eR 4cCoun+\$ m4+CHinG PHiltEr";
$lang['searchforusernotinlist'] = "s3arch F0R @ uS3R n0+ 1n Li\$t";
$lang['adminaccesslog'] = "adM1N 4cC3\$5 LO9";
$lang['adminlogexp'] = "tHiS l1s+ \$How\$ +eh l@ST 4ctIONS 54NC+10N3d BY u\$3R\$ Wi+h @Dm1n priV1LegeS.";
$lang['datetime'] = "d@T3/tIME";
$lang['unknownuser'] = "uNKnOWn u\$3R";
$lang['unknownfolder'] = "uNKNOwn PholD3R";
$lang['ip'] = "iP";
$lang['lastipaddress'] = "l@S+ 1P 4dDr3S5";
$lang['logged'] = "l0G9ED";
$lang['notlogged'] = "no+ Lo99ED";
$lang['addwordfilter'] = "aDD w0RD phIl+ER";
$lang['addnewwordfilter'] = "aDd nEW wORd FIlT3R";
$lang['wordfilterupdated'] = "w0RD phiL+3R upDaT3D";
$lang['filtername'] = "filt3r n@mE";
$lang['filtertype'] = "fILT3R tYp3";
$lang['filterenabled'] = "f1lT3R 3n@8L3D";
$lang['editwordfilter'] = "eDIt Word Fil+eR";
$lang['nowordfilterentriesfound'] = "n0 3XIs+1n9 Word PHiL+eR eNTR1e5 fOUnd. t0 4DD @ w0rd FIlT3r cLIck THe 8U++on 83lOw.";
$lang['mustspecifymatchedtext'] = "j00 MUsT SPeciFy M4+ched +eX+";
$lang['mustspecifyfilteroption'] = "j00 MUSt \$P3c1Fy 4 fil+Er OP+iOn";
$lang['mustspecifyfilterid'] = "j00 mu5+ 5PecIfy 4 Fil+ER 1d";
$lang['invalidfilterid'] = "inV4l1d PHilTer id";
$lang['failedtoupdatewordfilter'] = "f@1l3d +0 uPdA+e woRD f1l+3r. chECK +h4T tH3 pHIlt3r \$+1ll 3X15t\$.";
$lang['allow'] = "alL0W";
$lang['normalthreadsonly'] = "nORM4l +HR34d\$ 0Nly";
$lang['pollthreadsonly'] = "pOLL +hR3@D5 0Nly";
$lang['both'] = "b0+H +hRe4d +ype\$";
$lang['existingpermissions'] = "ex15+1N9 P3Rmi\$s10NS";
$lang['nousers'] = "n0 uS3RS";
$lang['searchforuser'] = "s34RCh f0R UsEr";
$lang['browsernegotiation'] = "bROw\$ER N39otI4t3D";
$lang['largetextfield'] = "l4r9e t3XT PHield";
$lang['mediumtextfield'] = "meDIuM TEX+ f1eLd";
$lang['smalltextfield'] = "sm4ll +eXT PHi3LD";
$lang['multilinetextfield'] = "muLT1-lIne t3X+ f1eld";
$lang['radiobuttons'] = "r4D1o BUtt0N\$";
$lang['dropdown'] = "dr0P dowN";
$lang['threadcount'] = "thR34d C0uN+";
$lang['fieldtypeexample1'] = "f0r r4DI0 8U+tON5 @Nd DRoP d0wn fI3ldS J00 n3Ed tO \$ep4R4te +he F1Eldn@mE 4Nd t3h V@lU3\$ w1+h 4 colON @nd E4CH ValUE 5hOUld B3 5EpaR@teD by \$Em1-CoLOnS.";
$lang['fieldtypeexample2'] = "eX4mPLe: +O cRE4+e 4 8451c 9eND3r R4D1o bU++0NS, w1th TWO 53L3Ct1OnS F0R m4l3 4Nd FEm4L3, j00 W0ulD 3Nt3r: <b>g3Nd3r:m4l3;PH3M4le</b> In Th3 1+Em N4me FieLd.";
$lang['editedwordfilter'] = "eD1t3d wORd F1L+Er";
$lang['editedforumsettings'] = "eDi+3D pHORum SeTT1n9\$";
$lang['sessionsuccessfullyended'] = "sucC3\$5PhUllY eNdeD se5510ns f0R 5elEct3D uSeR5";
$lang['matchedtext'] = "m@TChEd T3Xt";
$lang['replacementtext'] = "r3PL4Cem3nT +3x+";
$lang['preg'] = "pR39";
$lang['wholeword'] = "wh0Le Word";
$lang['word_filter_help_1'] = "<b>all</b> m@+cHes 4g4In5t teh wh0L3 +3X+ 5O pHiLteR1Ng MoM +0 mUM W1LL @L50 CH4n9e MomenT tO mumen+.";
$lang['word_filter_help_2'] = "<b>wHoL3 w0rd</b> M@Tches 4G41N5T WHol3 wOrD5 0NLy S0 fIL+er1Ng m0m +0 muM w1ll nO+ Ch4n9e moM3N+ tO MuMEnt.";
$lang['word_filter_help_3'] = "<b>pR3G</b> @lLOW5 j00 tO U\$e perl rE9ul@r 3xPre5S10N5 +0 m@+ch tEXT.";
$lang['nameanddesc'] = "nAme 4Nd D3scr1P+i0N";
$lang['movethreads'] = "m0V3 THr34d5";
$lang['threadsmovedsuccessfully'] = "thR34D5 M0veD SUcc3\$sFUllY";
$lang['movethreadstofolder'] = "m0VE tHrE4Ds to F0ld3r";
$lang['resetuserpermissions'] = "r3s3T UsER pERm15S10ns";
$lang['userpermissionsresetsuccessfully'] = "u\$3r perMIS510n5 ReSeT SUCCE5sPHulLy";
$lang['allowfoldertocontain'] = "alL0w F0Ld3r +0 cOnT4in";
$lang['addnewfolder'] = "aDd N3W f0ld3R";
$lang['mustenterfoldername'] = "j00 muS+ eNter 4 f0lD3r nAm3";
$lang['nofolderidspecified'] = "nO fOld3R id sp3c1f1eD";
$lang['invalidfolderid'] = "inv@lID pH0LdEr 1d. cHEcK +H4T @ PhOlDER w1tH THis 1D EXIST\$!";
$lang['successfullyaddedfolder'] = "sucC3\$SFulLy AddeD F0Ld3r";
$lang['successfullydeletedfolder'] = "sucCeS5PhULlY d3leT3d ph0ld3R";
$lang['failedtodeletefolder'] = "f4IlED +o d3l3+3 pH0ld3R.";
$lang['folderupdatedsuccessfully'] = "fOLD3R uPd@tEd \$uccEs\$PhuLly";
$lang['cannotdeletefolderwiththreads'] = "c4nnO+ deL3+e Fold3rS TH4T sT1ll C0nT4iN tHre4d5.";
$lang['forumisnotrestricted'] = "fORuM I5 N0+ Re\$TrICteD";
$lang['groups'] = "gR0up5";
$lang['nousergroups'] = "no U\$ER Gr0uP5 h@v3 83eN Set UP";
$lang['suppliedgidisnotausergroup'] = "suPPlIED 91d Is no+ 4 u\$3R grOuP";
$lang['manageusergroups'] = "m@n49E UsER 9r0UP\$";
$lang['groupstatus'] = "gR0up \$T@+uS";
$lang['addusergroup'] = "add GR0uP";
$lang['addremoveusers'] = "adD/r3m0v3 U\$er5";
$lang['nousersingroup'] = "th3R3 4re no u\$ERs 1n +h1S gr0uP";
$lang['useringroups'] = "tH1s u\$ER 15 4 mEMb3r OPH +HE pH0llOWin9 9R0uPS";
$lang['usernotinanygroups'] = "tHIs USer 15 N0+ in 4NY us3r 9R0uP\$";
$lang['usergroupwarning'] = "nO+E: tH1\$ u5er M4y be iNheRI+1ng 4DD1t10n@l peRm1S\$I0n\$ pHrOM @ny u\$er 9R0up\$ LI5T3d 8EL0w.";
$lang['successfullyaddedgroup'] = "suCCE5\$fUllY @dd3d 9rOup";
$lang['successfullydeletedgroup'] = "sUCC35SphULLy D3LeT3D 9roUP";
$lang['usercanaccessforumtools'] = "u\$eR C4n @CcEs5 pH0Rum toOL5 4nd c@N cRe4+E, D3l3T3 4nd 3di+ fORums";
$lang['usercanmodallfoldersonallforums'] = "uS3r c@N m0der4+e <b>alL ph0ldEr\$</b> ON <b>alL phOrUm5</b>";
$lang['usercanmodlinkssectiononallforums'] = "uS3r c4N m0DEr4+3 liNk5 \$ec+iON 0N <b>aLL f0RumS</b>";
$lang['emailconfirmationrequired'] = "eM@1l C0nPhIRm4tI0N rEqu1R3d";
$lang['userisbannedfromallforums'] = "us3r 1s b4Nn3d PHroM <b>alL fOrUMs</b>";
$lang['cancelemailconfirmation'] = "c4Nc3L 3M4il C0nphIrm4+10N 4ND 4llOw US3R t0 \$t4rt po5TIN9";
$lang['resendconfirmationemail'] = "rE53Nd conpH1Rm4+10n 3M@il +0 u\$eR";
$lang['donothing'] = "dO n0+H1ng";
$lang['usercanaccessadmintools'] = "u\$ER h@5 4cC3\$\$ t0 F0rUM @dmin t0Ol\$";
$lang['usercanaccessadmintoolsonallforums'] = "us3R H@5 4cc3SS +o 4Dm1N t00l5 <b>on 4ll foRum5</b>";
$lang['usercanmoderateallfolders'] = "u53R c4N M0d3R4TE 4ll ph0Ld3rS";
$lang['usercanmoderatelinkssection'] = "u\$3r c4N m0d3r4+3 l1NK\$ \$3c+I0N";
$lang['userisbanned'] = "u\$ER Is 84nNed";
$lang['useriswormed'] = "usER iS WoRM3D";
$lang['userispilloried'] = "uSER I5 p1lL0R1Ed";
$lang['usercanignoreadmin'] = "u\$eR C4n IgnOr3 @DmIniS+r4+0R\$";
$lang['groupcanaccessadmintools'] = "gRoup c4N 4cceS\$ 4dmIN +O0L5";
$lang['groupcanmoderateallfolders'] = "gR0uP c@N m0D3r4+E 4Ll f0Ld3r\$";
$lang['groupcanmoderatelinkssection'] = "groUP c@n moDEr4+E L1nKs \$3C+10N\$";
$lang['groupisbanned'] = "grOUp i5 B4nnEd";
$lang['groupiswormed'] = "gROUP 1s w0rMed";
$lang['readposts'] = "r3aD p05+\$";
$lang['replytothreads'] = "repLY To +hre4d5";
$lang['createnewthreads'] = "cr3At3 N3w +HrE4D\$";
$lang['editposts'] = "edI+ p0s+\$";
$lang['deleteposts'] = "dELEt3 pO\$tS";
$lang['uploadattachments'] = "uPl0@D 4Tt@cHmenT\$";
$lang['moderatefolder'] = "m0d3R4t3 PHoLd3R";
$lang['postinhtml'] = "po\$+ 1N h+mL";
$lang['postasignature'] = "poS+ @ SI9n4+uRe";
$lang['editforumlinks'] = "eDIt ForUm L1NKs";
$lang['editforumlinks_exp'] = "uS3 +hiS P4Ge T0 @dd l1nkS To +eH dROP-d0wn lI\$T di\$Pl4Y3d IN +he tOP-RigHT oPh t3H PH0rum pHr4m3S3T. iPH N0 liNKs 4r3 SEt, +he drOp-D0wn l1S+ W1Ll N0+ 8e D15pl4yeD.";
$lang['notoplevellinktitlespecified'] = "nO +Op L3v3l LInk t1+lE Sp3c1F1ed";
$lang['toplinktitlesuccessfullyupdated'] = "t0P LeVeL LInK +I+L3 SucCE\$\$FulLy UpD4+Ed";
$lang['youmustenteralinktitle'] = "j00 MuS+ Ent3r @ l1Nk +ItL3";
$lang['alllinkurismuststartwithaschema'] = "aLl lInk Uri5 MuST st4R+ w1+H @ \$CH3M4 (I.e. H++p://, ftP://, IrC://)";
$lang['noexistingforumlinksfound'] = "tHeR3 @Re NO eXiS+1N9 PH0rUM lInkS. +0 4Dd 4 fORUm L1nK cl1ck T3h 8UttON beLOw.";
$lang['editlink'] = "eD1T L1Nk";
$lang['addnewforumlink'] = "aDD N3W f0Rum LInk";
$lang['forumlinktitle'] = "fORuM l1nk +itLE";
$lang['forumlinklocation'] = "foRum l1Nk Loc4T10N";
$lang['successfullyaddedlink'] = "suCc35SPhUllY 4Dd3d L1Nk: '%s'";
$lang['successfullyeditedlink'] = "suCCe\$SPHUlLy Ed1T3d LINk: '%s'";
$lang['invalidlinkidorlinknotfound'] = "iNv4Lid L1NK 1d oR linK NO+ FoUND";
$lang['successfullyremovedselectedlinks'] = "sUcc3\$5PHUlLY rEM0V3D \$El3CTeD lINKS";
$lang['failedtoremovelinks'] = "f41LED t0 r3m0v3 \$3leCtED L1Nk5";
$lang['failedtoaddnewlink'] = "f4IL3D +o add NEw liNk: '%s'";
$lang['failedtoupdatelink'] = "f@ILed +O UpD4+e l1nk: '%s'";
$lang['toplinkcaption'] = "t0p LINK c@P+i0N";
$lang['allowguestaccess'] = "aLL0W 9u3St 4Cce5S";
$lang['searchenginespidering'] = "se4rCH 3NgiNe SPIder1n9";
$lang['allowsearchenginespidering'] = "aLl0W Se4RcH 3N91NE \$PiderIn9";
$lang['newuserregistrations'] = "neW U\$3r R3915tr4+10n5";
$lang['preventduplicateemailaddresses'] = "pReV3Nt DupL1C@+E 3M4il @DDreS5E\$";
$lang['allownewuserregistrations'] = "all0W NeW uSEr r391sTR4tIOnS";
$lang['requireemailconfirmation'] = "r3quIRE 3M4il cOnPHIrm@+i0N";
$lang['usetextcaptcha'] = "usE Tex+-C@P+cH4";
$lang['textcaptchadir'] = "teX+-c@p+cHA DIr3c+0ry";
$lang['textcaptchakey'] = "t3x+-CaP+cHa KEy";
$lang['textcaptchafonterror'] = "tEX+-c@P+Ch@ H4S 8e3N d1\$48Led Au+0M@T1CALlY 83Cau53 ThEr3 ar3 n0 +rUE typ3 PhonTS @v4iL48LE fOR IT TO u53. PLe@5e upl04D SOm3 +ru3 Type f0n+s +0 <b>%s</b> 0n YOur S3Rv3R.";
$lang['textcaptchadirerror'] = "tEX+-c4pTcH4 h@\$ BE3n diS48l3d 83C@U\$e tEh +Ex+_C4PtCha dIrEc+0ry 4nd 1+'\$ SUb-DIRECT0r1e\$ 4r3 N0T WR1+4BLe 8y +3H WEB \$ervEr / PhP pROCe5S.";
$lang['textcaptchagderror'] = "t3xT-c@PtcH4 h45 8eeN DISa8LeD 8Ec@U\$e yoUR SeRVeR'\$ pHP S3tup dO3\$ N0+ pR0v1dE suPP0rt Ph0r 9d 1m4G3 m@NipUL@+10n @nD / 0r ++f FON+ SUPpOR+. Bo+h 4r3 R3QuIrED ph0r T3x+-C4P+cH@ SuPP0rT.";
$lang['textcaptchadirblank'] = "text-c4P+CH4 D1reCTorY 15 BL4nk!";
$lang['newuserpreferences'] = "n3W u\$Er preFER3nCe\$";
$lang['sendemailnotificationonreply'] = "eM41l n0+if1C@t10n on rePly T0 U53R";
$lang['sendemailnotificationonpm'] = "eMA1L N0+iF1c4+Ion ON Pm +0 U5er";
$lang['showpopuponnewpm'] = "sh0W p0PUP WHen recE1Vin9 nEW Pm";
$lang['setautomatichighinterestonpost'] = "s3t 4u+0m@+1c h1Gh iNteR3ST ON P0\$t";
$lang['top20postersforperiod'] = "t0P 20 pO5+ERS PH0r PEr10D %s T0 %s";
$lang['postingstats'] = "po\$t1N9 St4+S";
$lang['nodata'] = "n0 d@+4";
$lang['totalposts'] = "toT4l pO5tS";
$lang['totalpostsforthisperiod'] = "to+@l Po\$TS pHOr +H1S PErI0D";
$lang['mustchooseastartday'] = "mU\$t cHo0\$3 @ 5t4R+ D@Y";
$lang['mustchooseastartmonth'] = "mu\$t chO0\$E 4 \$+4r+ M0nTh";
$lang['mustchooseastartyear'] = "mUst cHoO\$e 4 5tarT yE4R";
$lang['mustchooseaendday'] = "mu\$T ch0O5e 4 3Nd D@y";
$lang['mustchooseaendmonth'] = "mUs+ chO0se 4 3nD m0NtH";
$lang['mustchooseaendyear'] = "mU\$+ Ch00S3 4 End Ye@R";
$lang['startperiodisaheadofendperiod'] = "st4R+ p3r10d i\$ 4h34d opH eND peR10d";
$lang['bancontrols'] = "b4N C0ntROl\$";
$lang['addban'] = "adD 8@N";
$lang['checkban'] = "cHeck 8@N";
$lang['editban'] = "edIT B4n";
$lang['bantype'] = "b4N TYPe";
$lang['bandata'] = "b4n d4+@";
$lang['bancomment'] = "c0MM3nt";
$lang['ipban'] = "ip B4n";
$lang['logonban'] = "lO9oN 8@n";
$lang['nicknameban'] = "n1ckN4M3 8@n";
$lang['emailban'] = "em4IL 84N";
$lang['refererban'] = "r3pH3R3R b4n";
$lang['invalidbanid'] = "inV@l1D b4n 1d";
$lang['affectsessionwarnadd'] = "thI5 B4N maY @Ff3cT +hE Ph0LlOwInG 4ctIVE USEr \$eS5I0Ns";
$lang['noaffectsessionwarn'] = "tH1S B4n 4fFECTS NO 4c+1V3 \$eSS10n\$";
$lang['mustspecifybantype'] = "j00 MusT sPecIFy 4 8@N tyP3";
$lang['mustspecifybandata'] = "j00 MU5t sp3C1Fy \$oMe b4N d@T4";
$lang['successfullyremovedselectedbans'] = "suCC3\$SpHUlLy rem0VEd seL3C+ED b4nS";
$lang['failedtoaddnewban'] = "f41L3D +O @Dd NEw b4n";
$lang['failedtoremovebans'] = "fA1led t0 R3m0V3 sOm3 OR @ll OF the seLEctEd b4N5";
$lang['duplicatebandataentered'] = "dUplIc4t3 b4N d@+4 3n+3R3D. PlE4\$e Ch3CK Y0Ur wIldC@RDs +O \$E3 1F Th3y 4Lre4dy m@+cH +eh D4+a 3Nt3red";
$lang['successfullyaddedban'] = "sUcceSsfULly @DdEd b4n";
$lang['successfullyupdatedban'] = "suCC3sSFuLly upd@T3D b4n";
$lang['noexistingbandata'] = "th3r3 i5 N0 ex15t1n9 B@N d@+4. t0 4DD \$OM3 b4n d4+@ Ple4\$3 cl1Ck +eH bUT+0n 8eL0W.";
$lang['youcanusethepercentwildcard'] = "j00 c@n u\$E thE p3rceNT (%) wildc4rd \$ymBoL IN @nY OpH y0Ur b4N LI5ts +0 08t@1n p@rti4l M4+CHe\$, 1.E. '192.168.0.%' w0UlD 8@N 4Ll IP aDdRE\$s35 1n teh r4N93 192.168.0.1 +hR0u9h 192.168.0.254";
$lang['cannotusewildcardonown'] = "j00 c4NN0+ 4DD % 45 4 wilDc@rd m@tch 0N I+'5 0wN!";
$lang['requirepostapproval'] = "rEQu1Re P0St @PPr0v@L";
$lang['adminforumtoolsusercounterror'] = "ther3 mU\$T Be 4+ le4St 1 U5Er W1tH 4Dmin +00lS 4Nd PhoRUm +ooL5 4cc3\$\$ 0n 4Ll f0rUM\$!";
$lang['postcount'] = "p05+ cOUN+";
$lang['resetpostcount'] = "res3+ pOS+ C0Un+";
$lang['postapprovalqueue'] = "poST 4pPRoV@l qu3U3";
$lang['nopostsawaitingapproval'] = "no po5tS 4r3 4W@iT1ng 4PprOv4l";
$lang['approveselected'] = "apPRov3 \$eLectED";
$lang['successfullyapproveduser'] = "sUCceS5PhUllY 4PprOv3d 53l3ct3D UsER\$";                                                
$lang['kickselected'] = "kick seLEct3d";
$lang['visitorlog'] = "v15iTOr l0G";
$lang['novisitorslogged'] = "no VISitOr\$ l0g9Ed";
$lang['addselectedusers'] = "add \$el3cted U\$ers";
$lang['removeselectedusers'] = "reMOvE SELecteD USerS";
$lang['addnew'] = "adD N3w";
$lang['deleteselected'] = "d3LE+3 \$elEct3D";
$lang['noprofilesectionsfound'] = "tHER3 @re no EXi5t1n9 prOphIl3 5Ec+i0ns. +O @Dd 4 pr0phIle Sec+1ON pLe453 Cl1ck +He bUtt0n 8elOW.";
$lang['addnewprofilesection'] = "add nEW pROf1le \$ECt1On";
$lang['successfullyaddedsection'] = "sUCce\$sFuLly ADd3D seC+10n";

// Admin Log data (admin_viewlog.php) --------------------------------------------

$lang['changedstatusforuser'] = "ch4nGEd uS3R ST4+U\$ PHoR '%s'";
$lang['changedpasswordforuser'] = "cH@NG3d P455WoRd FoR '%s'";
$lang['changedforumaccess'] = "ch@N93D fORUM @cc3S\$ pErMISs1On5 PH0r '%s'";
$lang['deletedallusersposts'] = "dele+Ed 4Ll pO5ts fOR '%s'";

$lang['createdusergroup'] = "cR3At3D usER 9rOUp '%s'";
$lang['deletedusergroup'] = "d3L3+3d uSeR grOUp '%s'";
$lang['updatedusergroup'] = "upd4+3d U\$ER 9ROUp '%s'";
$lang['addedusertogroup'] = "adDED uSer '%s' +o 9R0UP '%s'";
$lang['removeduserfromgroup'] = "r3m0V3 U\$eR '%s' phr0M 9r0up '%s'";

$lang['addedipaddresstobanlist'] = "aDDEd Ip '%s' to b4N L15T";
$lang['removedipaddressfrombanlist'] = "rEm0V3d ip '%s' fr0m 8@n l1S+";

$lang['addedlogontobanlist'] = "aDDed lo9On '%s' +0 84n L15+";
$lang['removedlogonfrombanlist'] = "rEM0vEd L0G0N '%s' Phr0M 8@N l1\$t";

$lang['addednicknametobanlist'] = "aDd3D nIcKN4me '%s' to 84n Li5t";
$lang['removednicknamefrombanlist'] = "reM0VEd N1cKnaM3 '%s' phR0M 8@n LIs+";

$lang['addedemailtobanlist'] = "aDdED eM@iL 4DdrEsS '%s' +0 84N LI5+";
$lang['removedemailfrombanlist'] = "r3mOVED eMa1L 4DdRES\$ '%s' pHr0M 8@n L1St";

$lang['addedreferertobanlist'] = "aDded RepHEreR '%s' tO 8@N l1ST";
$lang['removedrefererfrombanlist'] = "r3M0V3D RefEr3R '%s' fROM 8@n LI5T";

$lang['editedfolder'] = "edI+3D Ph0LdEr '%s'";
$lang['movedallthreadsfromto'] = "m0V3D 4LL +hRE4d5 fr0m '%s' +O '%s'";
$lang['creatednewfolder'] = "cRE@t3d NeW fOLDeR '%s'";
$lang['deletedfolder'] = "d3LE+3d FOLd3r '%s'";

$lang['changedprofilesectiontitle'] = "cH4n93d PROF1l3 \$ecTi0n +ItLE Fr0M '%s' +O '%s'";
$lang['addednewprofilesection'] = "addED NEw pRopHiLE s3CTION '%s'";
$lang['deletedprofilesection'] = "d3l3+Ed pr0fIlE SEcT10n '%s'";

$lang['addednewprofileitem'] = "aDDEd New prOpHIlE 1tEm '%s' T0 \$eC+10n '%s'";
$lang['changedprofileitem'] = "cH@N93d PR0F1Le iT3M '%s'";
$lang['deletedprofileitem'] = "d3LE+3D prOPhIle 1+Em '%s'";

$lang['editedstartpage'] = "edI+ed ST4rt P@g3";
$lang['savednewstyle'] = "s@v3d NEw stYL3 '%s'";

$lang['movedthread'] = "m0V3d +hRe4D '%s' FR0M '%s' +O '%s'";
$lang['closedthread'] = "cLO5Ed ThrE4d '%s'";
$lang['openedthread'] = "open3D thr34D '%s'";
$lang['renamedthread'] = "rEn4m3D +hRe@D '%s' +0 '%s'";

$lang['deletedthread'] = "dElet3d +hRe4d '%s'";
$lang['undeletedthread'] = "unD3l3t3d +HreAd '%s'";

$lang['lockedthreadtitlefolder'] = "lockED Thr3@D 0PT1ON\$ On '%s'";
$lang['unlockedthreadtitlefolder'] = "uNL0CkEd ThR3@d 0ptI0N5 on '%s'";

$lang['deletedpostsfrominthread'] = "deL3+eD p0STS fr0m '%s' 1n thR34d '%s'";
$lang['deletedattachmentfrompost'] = "d3L3T3D 4++4chm3n+ '%s' PhrOm p0\$T '%s'";

$lang['editedforumlinks'] = "edIT3d FORuM LINks";
$lang['editedforumlink'] = "eD1+Ed F0RuM L1Nk: '%s'";

$lang['addedforumlink'] = "addeD phOrUm lInK: '%s'";
$lang['deletedforumlink'] = "d3LET3D pH0Rum LInK: '%s'";
$lang['changedtoplinkcaption'] = "cH@n9Ed ToP linK c@pT1oN frOm '%s' +o '%s'";

$lang['deletedpost'] = "deLEtED pO5+ '%s'";
$lang['editedpost'] = "eDit3D p0ST '%s'";

$lang['madethreadsticky'] = "m4D3 +HR34d '%s' St1ckY";
$lang['madethreadnonsticky'] = "m4dE THr34d '%s' N0n-S+iCKy";

$lang['endedsessionforuser'] = "enD3D \$3SS10n f0R U\$ER '%s'";

$lang['approvedpost'] = "aPProv3D Po5t '%s'";

$lang['editedwordfilter'] = "edi+ED worD f1L+Er";

$lang['addedrssfeed'] = "aDd3D r\$\$ ph33D '%s'";
$lang['editedrssfeed'] = "ed1+3d R5s pHEeD '%s'";
$lang['deletedrssfeed'] = "dEl3+3D r55 feEd '%s'";

$lang['updatedban'] = "upD4+eD 8@n '%s'. '%s' TO '%s', '%s' +0 '%s'.";

$lang['splitthreadatpostintonewthread'] = "splIT +HRe4d '%s' @t P05t %s  iNt0 N3W +Hre@d '%s'";
$lang['mergedthreadintonewthread'] = "mergEd +hr34D\$ '%s' 4Nd '%s' In+0 n3w ThRE4d '%s'";

$lang['approveduser'] = "apPR0V3D USER '%s'";

$lang['adminlogempty'] = "admIN L0G 1S 3mp+y";
$lang['clearlog'] = "cL3@R l0g";

// Admin Forms (admin_forums.php) ------------------------------------------------

$lang['noexistingforums'] = "n0 3xi5T1n9 phORUm5 F0uNd. +O cr34te 4 New ph0Rum PL345e cL1ck t3H 8ut+0n 8ELOw.";
$lang['webtaginvalidchars'] = "webT@g C@n OnLy C0n+41n uPp3rc45E 4-z, 0-9 4nD unD3rSC0r3 CH4rac+ER\$";
$lang['databasenameinvalidchars'] = "d4T@8@5E n4me c4n 0nlY Con+41n 4-z, 4-z, 0-9 @ND uNd3r\$C0RE cH4R4ctERS";
$lang['invalidforumidorforumnotfound'] = "inv4Lid f0Rum fId PHOr F0RuM N0+ pHOunD";
$lang['successfullyupdatedforum'] = "suCCE55PhULly upD@T3D PH0ruM: '%s'";
$lang['failedtoupdateforum'] = "f4IL3D +o Upd@TE F0rum: '%s'";
$lang['successfullycreatedforum'] = "sUcc35SfULlY CR3@tEd pHoRuM: '%s'";
$lang['failedtocreateforum'] = "f4iLEd T0 Cre4Te pH0RUM '%s'";
$lang['selectedwebtagisalreadyinuse'] = "tEh SEL3C+3d WEbT@G IS 4lR34DY in U\$e. pLE4\$e ch0O\$E @nO+H3R.";
$lang['selecteddatabasecontainsconflictingtables'] = "tEh 53L3Ct3D D@+A8@sE C0n+4InS c0NfLicTIn9 T48lE5. cONFl1ct1n9 +48le NAm3s 4rE:";
$lang['forumdeleteconfirmation'] = "aR3 J00 5UrE j00 W4n+ tO dELe+e 4Ll 0ph +hE SElEcT3D pH0RUm\$?";
$lang['forumdeletewarning'] = "pL34Se nO+E th4+ j00 c4nn0+ rEc0v3R d3L3ted F0ruM\$. OnC3 D3l3+eD @ fORum @ND 4ll 0ph I+'5 4s\$0C14t3d d@+4 Is pERmeN4ntlY REmoVED Phr0m the d4+4B45e. IF j00 d0 nO+ wI\$H +0 d3L3te th3 \$El3cT3D PH0ruMS pl34S3 CLiCk canc3L.";
$lang['successfullydeletedforum'] = "suCcEsSfUllY DEL3T3d pH0Rum: '%s'";
$lang['failedtodeleteforum'] = "fAIL3d tO dEle+3d F0RUM: '%s'";
$lang['addforum'] = "add pH0RUM";
$lang['editforum'] = "eD1t pH0RuM";
$lang['visitforum'] = "v1\$IT ph0Rum: %s";
$lang['accesslevel'] = "aCce\$S LEVEL";
$lang['usedatabase'] = "u\$3 d@t484sE";
$lang['unknownmessagecount'] = "uNkNoWn";
$lang['forumwebtag'] = "forUm wE8+4G";
$lang['defaultforum'] = "d3PH4UlT FORuM";
$lang['forumdatabasewarning'] = "pl345E en5Ure J00 5EleCt tH3 C0rr3ct d4T4b4Se Wh3n crE4TIng 4 neW FOrUm. 0NC3 crE4+3D A n3w PH0rum c@NN0+ 8e mOvEd betw33N 4V@1l4bl3 D4t48@5e\$.";

// Admin Global User Permissions

$lang['globaluserpermissions'] = "gL0b4l U5ER Perm1551ON5";

// Admin Forum Settings (admin_forum_settings.php) -------------------------------

$lang['mustsupplyforumwebtag'] = "j00 Mu\$t SUppLy 4 FoRUm WebT4G";
$lang['mustsupplyforumname'] = "j00 mUst SUPplY 4 ForuM N@ME";
$lang['mustsupplyforumemail'] = "j00 mu5T suPpLY 4 fORUm Em4iL @DDreSS";
$lang['mustchoosedefaultstyle'] = "j00 mU5t choO5E 4 D3pH@Ul+ PhOruM \$TyLE";
$lang['mustchoosedefaultemoticons'] = "j00 mUST CHO0sE DEPH4ulT PH0ruM 3m0+icOn5";
$lang['mustsupplyforumaccesslevel'] = "j00 MUST SuPPly @ Ph0Rum acceS\$ LevEl";
$lang['mustsupplyforumdatabasename'] = "j00 MU\$T 5UPPly 4 ph0RuM d@+48@Se n4me";
$lang['unknownemoticonsname'] = "unknoWN 3mo+1c0N\$ n4M3";
$lang['mustchoosedefaultlang'] = "j00 mUS+ chOO\$e 4 deF4UlT PH0Rum L@ngU4G3";
$lang['activesessiongreaterthansession'] = "ac+1V3 \$eSS1On +1MeOut c@NNo+ be 9re@+eR tH4N SE\$sioN +1meOUT";
$lang['attachmentdirnotwritable'] = "at+AChmEn+ d1RecTorY 4nD Sy5T3m t3mPOr@RY DiRec+0ry / Php.InI 'UpL04d_+Mp_diR' Mu\$t 83 wrI+4bl3 bY tH3 W3b sERvEr / phP pr0C3s5!";
$lang['attachmentdirblank'] = "j00 MU5T SupPly @ dirEC+0ry +0 S4Ve @t+4ChmEn+5 iN";
$lang['mainsettings'] = "m@IN SEt+In9S";
$lang['forumname'] = "foRUM N4ME";
$lang['forumemail'] = "f0RUM 3M4Il";
$lang['forumdesc'] = "f0rum DeSCrIp+10N";
$lang['forumkeywords'] = "f0rUm keYwOrd\$";
$lang['defaultstyle'] = "d3F@ult 5tYle";
$lang['defaultemoticons'] = "d3PHaUl+ Emo+1C0NS";
$lang['defaultlanguage'] = "dEF4UlT l4Ngu49E";
$lang['forumaccesssettings'] = "foRUm @cce5S 5etTIng\$";
$lang['forumaccessstatus'] = "f0RuM @Cc3S\$ St4+u5";
$lang['changepermissions'] = "cH4N9e PErmIS51onS";
$lang['changepassword'] = "cH4ngE p4\$SWOrd";
$lang['passwordprotected'] = "p4S5W0Rd pr0T3c+3D";
$lang['passwordprotectwarning'] = "j00 h4v3 N0t \$e+ A f0ruM p4s5wORd. if j00 d0 n0+ 53+ 4 P4SSW0rd the p4\$SWoRd PROtECtiOn fuNc+I0N4LitY wIll 83 @UTom@+1C4llY D1S4bLed!";
$lang['postoptions'] = "po\$T opTi0nS";
$lang['allowpostoptions'] = "alL0W P0\$t 3d1t1n9";
$lang['postedittimeout'] = "p0ST 3Di+ t1MeOu+";
$lang['posteditgraceperiod'] = "pO\$t 3D1t 9r4c3 p3R10D";
$lang['wikiintegration'] = "wIk1w1K1 1Nt39R4+10n";
$lang['enablewikiintegration'] = "eN@bL3 WIK1W1kI 1Nt39r4+i0N";
$lang['enablewikiquicklinks'] = "en4bLE w1KiWIki QUiCK LiNK5";
$lang['wikiintegrationuri'] = "w1KIw1K1 l0Cat10n";
$lang['maximumpostlength'] = "m4XImum PO5T LeN9tH";
$lang['postfrequency'] = "p0s+ phR3QueNCy";
$lang['enablelinkssection'] = "eN48L3 l1NK\$ S3C+10N";
$lang['allowcreationofpolls'] = "alL0W cR34+10n OF p0LlS";
$lang['allowguestvotesinpolls'] = "allOw 9U35t\$ tO V0+3 in pOLl\$";
$lang['unreadmessagescutoff'] = "uNRe4D M3S\$493s Cut-OFPh";
$lang['unreadcutoffseconds'] = "sec0ND\$";
$lang['disableunreadmessages'] = "d1s4Ble UNrE@D mE554G3\$";
$lang['nocutoffdefault'] = "nO CU+-oFf (d3ph@UlT)";
$lang['1month'] = "1 M0NTh";
$lang['6months'] = "6 moN+h\$";
$lang['1year'] = "1 YE@R";
$lang['customsetbelow'] = "cu\$+0m v@LU3 (\$3+ belOW)";
$lang['searchoptions'] = "s34Rch opTi0N\$";
$lang['searchfrequency'] = "sE4RcH fr3QUEncY";
$lang['sessions'] = "s35s10nS";
$lang['sessioncutoffseconds'] = "sE\$510N cu+ 0FF (\$eCoNdS)";
$lang['activesessioncutoffseconds'] = "acT1v3 SES5iON cU+ 0pHF (s3cONd5)";
$lang['stats'] = "stA+5";
$lang['hide_stats'] = "h1d3 st4+s";
$lang['show_stats'] = "sh0W \$T4+5";
$lang['enablestatsdisplay'] = "eN@bLE \$+4t5 Di5plAy";
$lang['personalmessages'] = "p3RSon4L m3SS493\$";
$lang['enablepersonalmessages'] = "eN48l3 P3r5On@L meS549es";
$lang['pmusermessages'] = "pm M35S4gE5 peR USeR";
$lang['allowpmstohaveattachments'] = "alL0W PeRs0N@l mE5S4GeS +0 HAv3 4Tt4cHmENts";
$lang['autopruneuserspmfoldersevery'] = "aU+0 PruNE u\$er'S Pm pholDErS eV3Ry";
$lang['userandguestoptions'] = "u\$3R aND GuEST OptION5";
$lang['enableguestaccount'] = "eNABLe 9U3st 4Cc0un+";
$lang['listguestsinvisitorlog'] = "lIst 9u3StS 1N v1sI+0R Log";
$lang['allowguestaccess'] = "aLL0W gU3\$t 4cc3S5";
$lang['userandguestaccesssettings'] = "u53R 4nD 9ue5t 4CceS5 \$3+t1NGs";
$lang['allowuserstochangeusername'] = "allOW u\$ERS +0 cH4n9E u\$3RN@me";
$lang['requireuserapproval'] = "rEqu1Re USEr 4PpROv@l 8Y 4dmiN";
$lang['enableattachments'] = "en@8L3 4+t4chMent\$";
$lang['attachmentdir'] = "a+TaChm3n+ D1r";
$lang['userattachmentspace'] = "aT+4CHmENt sP4Ce per Us3R";
$lang['allowembeddingofattachments'] = "alLOW 3m83ddIn9 0Ph @++4ChmEntS";
$lang['usealtattachmentmethod'] = "u53 @l+erN@+1v3 4T+@Chm3n+ m3+H0d";
$lang['allowgueststoaccessattachments'] = "aLl0w 9u3S+S +0 @cce\$5 4++4Chm3N+5";
$lang['forumsettingsupdated'] = "foRUM S3++1nG\$ sUcceSSFulLy UPd4+3d";
$lang['forumstatusmessages'] = "f0RuM \$t4Tus m3S54g3S";
$lang['forumclosedmessage'] = "forUM cL05ed M3\$54ge";
$lang['forumrestrictedmessage'] = "f0rUM rES+R1c+ED M3SS49E";
$lang['forumpasswordprotectedmessage'] = "f0RUM p4\$5woRD pRo+ec+ed meS5493";

// Admin Forum Settings Help Text (admin_forum_settings.php) ------------------------------

$lang['forum_settings_help_10'] = "<b>p0\$t edi+ +IMEOU+</b> i5 TEH TIme in MiNu+35 @Ft3R PO5TinG tH4+ @ U\$ER c4n ed1t The1r pO5T. ipH 5eT +O 0 +heRe 1s n0 l1m1t.";
$lang['forum_settings_help_11'] = "<b>m@X1muM P05t LEnGth</b> iS +He m4X1mUM Num83r 0ph Ch4R@c+ERS thAt W1Ll be DISpL@YEd In 4 P05T. iPh 4 p0s+ IS l0NgeR +h4N +HE nUMb3R Oph CH@r@ct3Rs DEF1N3d her3 iT w1ll b3 cUT SHOr+ 4nd @ L1nK 4DD3D T0 THE 80t+om TO @ll0W US3R\$ +O RE@d +hE WHOl3 P0S+ 0N 4 S3PAR4+3 p493.";
$lang['forum_settings_help_12'] = "iPh j00 d0n'+ W4N+ y0UR uSErS +O 8e @8LE To cre@T3 p0ll\$ J00 c@N d1s4Bl3 TH3 @8ov3 0pt10N.";
$lang['forum_settings_help_13'] = "tEh LInkS \$eCT10N oF 833H1ve pr0VidE5 4 PL4Ce F0r YOuR u\$3R\$ +o M@INt4in @ liS+ 0f \$1+3S +h3Y FreqUenTLy V1SIt th4T 0Th3r usERS M@Y pH1Nd U\$3phUl. l1Nk\$ c@n B3 DIViDed iN+0 c@Te90riEs 8Y PH0lder 4nD 4LL0w fOR c0MM3Nt5 @ND r@+1ngS TO bE g1vEn. in 0Rd3r +o mOd3r4T3 T3H LInK\$ \$3C+ION 4 uS3R Mu5T 83 r@NTeD 9Lo84L MoD3R4+or \$t4+uS.";
$lang['forum_settings_help_15'] = "<b>sE\$5i0N CuT 0phpH</b> 1s +EH M4X1muM Time bEph0Re 4 US3R'\$ s3SsiOn 1S d33M3d De4D 4nD +HeY @r3 loGGed oU+. by DepH4ul+ ThI5 1S 24 hoUr5 (86400 5Ec0NDs).";
$lang['forum_settings_help_16'] = "<b>aCt1V3 \$35s1ON cu+ OPHf</b> 15 tHe m4X1mUM +Ime b3FORe 4 uSer's SE\$si0n I5 dE3M3d IN4ctIVE @+ WhIcH pO1Nt tH3Y 3NtEr 4n 1dL3 s+@+E. 1N THi\$ 5t4+3 Th3 u53R ReM@In\$ lO99eD 1N, 8U+ th3y 4R3 r3MOv3D fr0M th3 @C+ivE uSer5 lI\$t 1n +He s+4TS D15Pl@Y. ONc3 THeY B3C0ME 4C+IV3 a94IN THeY w1ll be R3-4ddED +O t3h lis+. 8Y d3PhAuL+ +Hi5 Set+IN9 15 \$3t +0 15 miNUt3S (900 \$eC0nDS).";
$lang['forum_settings_help_17'] = "en@bL1Ng ThiS OPt10n 4lL0w\$ 8e3h1Ve To inclUD3 4 s+@Ts D15PlaY 4+ Teh 8o+toM 0f +H3 me\$SA93S p4Ne 5im1L4R +0 +3H 0n3 U5eD bY M4Ny ph0rUM sopH+W4r3 t1TlEs. 0nC3 3n4BL3d th3 D1SPl4Y 0pH +hE st4+S P493 C4N 83 TOggLeD 1ND1V1Du@lLy BY 34ch usER. 1Ph +Hey d0n'T w4Nt +o \$e3 1t Th3Y C@N h1DE 1t Fr0M view.";
$lang['forum_settings_help_18'] = "p3r50N@L M35s49ES 4Re Inv4lU48l3 As a w4Y Of t4KiN9 M0r3 prIv@+e m@++ER\$ Ou+ 0f V13w OpH th3 0tHER M3Mb3R\$. h0w3V3r 1f J00 d0n'+ W4NT y0uR U\$3r\$ TO be 4bL3 tO \$eNd 34ch o+h3R p3r\$0n4L MeSs4gES j00 C4N D1\$4bL3 THIs oP+i0n.";
$lang['forum_settings_help_19'] = "per\$0N4L m3s\$@9eS c@n 4l5o cOnt4in @tt4CHMenTs wHich C4n Be USEphUL f0r 3Xch4n9In9 PhiLEs betW33n u\$Er\$.";
$lang['forum_settings_help_20'] = "<b>no+3:</b> Th3 5P4Ce 4ll0c4T1ON for pm 4++4Chm3N+s I\$ tak3n PHr0m E4cH USErS' m41N 4++@chm3Nt @LLoC@tiOn @nd 1S N0+ 1n 4dD1T1ON +O.";
$lang['forum_settings_help_21'] = "<b>en4BL3 9U3St @ccoUN+</b> @llOWS v1Si+OR\$ tO 8R0wsE Your ph0Rum @nd R34d p05Ts W1THOut R39Is+3R1N9 4 u53R 4CcOUnT. 4 USER @Cc0uNT 1S sTILL reQuIReD if TH3Y WiSH tO P0\$t or ch@NgE U5eR pr3PH3R3nC3s.";
$lang['forum_settings_help_22'] = "<b>liST Gu3S+S 1N Vi\$1+Or Lo9</b> @lL0W\$ J00 +o \$pec1fY whE+HeR oR NOT UnR3G1St3rED u\$ers 4R3 l1\$t3D oN +3H vI51+0R lO9 4l0N9 \$1de r3915Ter3D u\$erS.";
$lang['forum_settings_help_23'] = "b3EH1v3 4LlOW5 @+t4ChmeNt\$ t0 8e Upl04dEd To M3\$54gE5 wH3n pO\$+3D. 1Ph j00 h4ve L1m1t3d w38 SP4cE J00 May WhiCh +o d1S4bl3 4+t4Chm3N+S 8Y Cle4r1N9 Th3 Box 4B0vE.";
$lang['forum_settings_help_24'] = "<b>atTAChmEn+ dir</b> 1S Teh loc@+10n 833Hiv3 \$h0ulD 5T0re It's 4+T@Chm3N+5 1N. tHI5 DiREc+0RY must 3xIST oN Y0Ur W3B \$P4C3 4ND musT b3 wrI+@blE by tH3 wEb \$ERV3R / phP proC3s5 o+H3Rw1Se UPLo@d5 w1Ll F4iL.";
$lang['forum_settings_help_25'] = "<b>aTt4ChM3N+ SP4C3 PEr u\$eR</b> I5 +eH m4X1MuM @moUNT oF dI\$k sP4C3 @ uSeR HA\$ Ph0R @T+@ChMeN+5. ONc3 +h1S sP4cE 1S UsEd uP THE U53r c4NnO+ uPlO@D 4nY mOr3 4++4cHMeNt\$. bY d3pH4Ul+ tH1S i\$ 1Mb 0PH sP4C3.";
$lang['forum_settings_help_26'] = "<b>all0w EM8eDdin9 OF 4TT4chM3Nt\$ 1n m3SS@gEs / \$i9N@tUR3s</b> @llOws USErS +0 em8ed 4+t4ChMeNt5 in p0\$+s. EN4blIN9 +hi5 0ptI0n WH1Le u5ePHuL c4N INcRe4\$e YOuR 84NdWID+H uS4Ge dr4S+ic@lLY undEr CeRt@1n cONF19Ur@+1On5 opH pHp. 1F j00 H@V3 Lim1+Ed b@NDwIDTh It 1S rEcOMM3NdEd +H4t j00 DIS48Le +H1\$ OP+10n.";
$lang['forum_settings_help_27'] = "<b>u53 aL+eRn4+1Ve @++4cHMEn+ me+h0d</b> Ph0rC3S be3hIVe +0 u5e @N 4l+Ern@+1v3 R3tr13V4l M3+H0D F0R 4Tt@ChM3NT\$. 1F J00 r3C31ve 404 erR0r m3\$\$4ge5 wHEn +Ry1NG +0 doWnL04d @t+@cHm3n+5 FROM mE5saGe5 TRy 3N48L1nG ThIS oPT10N.";
$lang['forum_settings_help_28'] = "tH1\$ Set+in9 alLOw5 y0ur ph0RuM +0 B3 Sp1D3reD bY se4rcH 3N91NEs Like 9OOGlE, 4lT4Vi5t4 @ND y4H0o. if J00 Sw1tch thI\$ 0p+I0N 0phF Y0Ur PH0rum WILl NOT b3 iNClUd3d IN tH3\$E Se4RCh EnG1N3S R3\$uL+s.";
$lang['forum_settings_help_29'] = "<b>alLOw NEw usEr rEGi5+R4Ti0n\$</b> 4LlOW5 0R D1S@ll0W\$ +3h Cr34t10N 0F n3W uSER 4Cc0Un+S. sETt1n9 TH3 0PtI0N +0 N0 c0mPLEt3Ly D1S4Bl3S +3H ReG15tr4tIOn fORM.";
$lang['forum_settings_help_30'] = "<b>enAblE wiK1w1K1 1nT39R4+IOn</b> prOV1d35 w1K1wOrD 5uPP0rT IN y0Ur pH0RUm pO\$Ts. 4 wIK1WoRD 15 M@De up oPH TwO 0R moRE c0nC4teN4Ted w0Rd5 W1TH upPerC@5e L3+TeRS (0FTen r3FerReD +0 @5 CaM3lc4sE). IpH j00 wrIt3 a W0rd th15 w@Y iT WilL @U+om4+1C4lLy b3 cHAngED iN+o 4 hYPErLInK p0iNTiN9 TO y0Ur ch05En w1K1wIK1.";
$lang['forum_settings_help_31'] = "<b>eNABle w1KiwIki QUIck l1NkS</b> 3N48LeS TEh uSE OpH M59:1.1 @ND USer:loGon sTylE 3XTEND3D W1kILiNk5 Wh1Ch Cr3@+e HYPErLinKS +0 +he SpEciF1Ed M3Ss4ge / uSER pR0phiLe OF teh \$P3c1Ph13D u\$eR.";
$lang['forum_settings_help_32'] = "<b>w1k1WIk1 LOc4+1On</b> i5 U\$3d +o SPecIpHy +Eh uR1 0Ph Y0Ur w1kIw1K1. wh3n eN+3R1N9 Th3 UR1 us3 [wiKIWOrD] t0 INDIc4+e wH3R3 1n +H3 uRi t3H wik1wOrD sHOUld 4PP34r, I.3.: <i>h+tP://3N.WIk1p3Dia.org/w1K1/[wIKiW0Rd]</i> w0ULD liNK y0uR W1kiw0RDS TO %s";
$lang['forum_settings_help_33'] = "<b>f0RUm @ccE\$s sT4Tu5</b> C0N+rOLS hOw u5Er5 M4Y 4Cces5 y0Ur ph0Rum.";
$lang['forum_settings_help_34'] = "<b>oP3N</b> W1Ll 4lLOw @ll u5eRS 4Nd gU3STs @ccE5S t0 YOUr PH0rUm w1TH0U+ rE\$+r1C+I0N.";
$lang['forum_settings_help_35'] = "<b>cl0S3D</b> PrevEn+5 4cc35S FOr 4ll U\$3r\$, w1Th T3H 3XcePt1oN oF T3H @DmiN wHO M@y \$+1lL 4cce\$s +h3 4dm1N p4Nel.";
$lang['forum_settings_help_36'] = "<b>reStr1CteD</b> 4Ll0w5 T0 5et 4 Li5t 0F UsErs Wh0 @rE 4Ll0w3d ACC3S\$ +O YOUr PHOrUm.";
$lang['forum_settings_help_37'] = "<b>p@\$5w0Rd prO+3c+Ed</b> @Ll0w5 J00 +0 \$et 4 p4S5wORD +0 G1VE ouT TO u5ER5 sO +H3y c4n 4cC3\$5 yOUR Ph0RUM.";
$lang['forum_settings_help_38'] = "wh3N SetTInG rEsTR1C+ed Or p45Sw0Rd Pr0+ec+3d M0D3 J00 W1Ll NeEd TO 54v3 Your ch4NGe5 BefoRE J00 C4n cH4n9E The us3R @CC35s PR1v1L39Es oR P@sSW0rd.";
$lang['forum_settings_help_39'] = "<b>Search Frequency</b> defines how long a user must wait before performing another search. Searches place a high demand on the database so it is recommended that you set this to at least 30 seconds to prevent \"search spamming\"pHR0m KilLIng TH3 53rv3R.";
$lang['forum_settings_help_40'] = "<b>po5T freQu3ncY</b> is TH3 MIniMUm Tim3 4 U5eR mU\$t W4I+ 8EfOR3 +H3Y c4N P0ST @G41n. +H1S 5et+1n9 4l\$o 4FfEctS TH3 crE4t1on 0F P0LlS. SE+ +O 0 +O d1S48l3 T3H rE5TRIC+1On.";
$lang['forum_settings_help_41'] = "tH3 48oVe 0ptIOn5 chAnGE tH3 dEph4Ul+ v4lue\$ foR T3h useR rE9IsTr4+i0N pH0rm. WhER3 aPPliC48l3 othER SeTtINgS WIll U\$3 th3 PHOrUm'S 0Wn D3ph4UlT SEtt1N9\$.";
$lang['forum_settings_help_42'] = "<b>preV3n+ usE 0f dUPLic@+3 Em@il 4dDreSSES</b> Ph0RceS 8Eeh1vE T0 cheCK +eh u\$er @cCOuN+\$ @g41n5t T3H eM4Il 4dDReSS teH U\$eR 15 re915ter1nG wi+h 4nD Pr0mpt5 +hem tO u5e Ano+H3r 1F 1+ 15 4lrE4Dy 1N uSE.";
$lang['forum_settings_help_43'] = "<b>r3Qu1R3 EM4il c0NfiRm4+I0n</b> WhEn 3n@8L3d W1Ll \$enD @N 3m4il +0 3@cH neW user W1+H A LiNK tH4t c4n 8E Us3D +0 cOnFIrm +he1R 3M@1l 4DdR3Ss. unT1L thEy COnFIRM th31r EM41l 4ddrEs\$ th3Y wIlL no+ 83 @BLe tO pO5t UNleS5 TH3Ir UsEr pERM1\$5i0NS 4Re CH@N93d M4Nu4Lly by @N 4dm1N.";
$lang['forum_settings_help_44'] = "<b>usE +3xt-c4pTCha</b> pr3SeNT\$ +He N3W uSER w1+H 4 m4N9l3d iM@93 whiCh tHey MUSt cOpY 4 nUMb3R phr0m iNto @ t3XT fI3ld ON +he r3915TR4ti0n F0Rm. usE ThIs 0P+I0N tO PrEVenT AU+Om4+ed 51gn-uP vI@ \$cRIpt\$.";
$lang['forum_settings_help_45'] = "<b>teXt-C4P+CH4 diREc+0Ry</b> \$P3C1fI3S Th3 Loc4Ti0N +h4T b3eHiV3 WilL 5tOr3 i+'\$ t3x+-c4P+cH4 IM@9eS @Nd ph0N+5 1N. Th1s d1r3c+ORy Mu\$t be wr1t4Bl3 BY T3H weB SErVer / pHp PR0ceSS 4ND mu\$t B3 4cc3sS1Bl3 VI4 h++P. 4ph+eR J00 h4VE eN48LEd +ex+-C4PtCh4 j00 mU\$T UpLO@d s0mE tRU3 tYP3 PH0n+s INtO +He F0n+s \$ub-D1r3C+0Ry 0F yOUR M@1n +3x+-cApTCH4 d1rEc+0Ry OTHErWise b33h1VE w1Ll SK1P t3H t3X+-C@p+cH@ DUrIN9 US3R r3915TR4Ti0N.";
$lang['forum_settings_help_46'] = "<b>Text Captcha key</b> allows you to change the key used by Beehive for generating the text captcha code that appears in the image. The more unique you make the key the harder it will be for automated processes to \"guess\"+EH C0d3.";
$lang['forum_settings_help_47'] = "<b>p0\$t 3Di+ 9R4c3 p3ri0d</b> aLl0w5 J00 +O DEphIN3 a p3R1od 1n m1nU+E5 WHerE U\$3R5 m4y 3D1+ pOs+S w1tH0U+ +3h 'Edi+3D 8y' +3xt 4pPe4RIn9 0N thE1R PO\$tS. 1f \$ET +0 0 +Eh '3DiT3D 8y' +EX+ wiLL 4Lw4y5 4PpE4R.";
$lang['forum_settings_help_48'] = "<b>uNR34D m3sS4GE5 cU+-0fF</b> SPec1ph13S H0w LOnG uNreAD m3\$sA93s 4R3 r3t4In3d. J00 m4Y ChO0\$3 frOm v@R10uS Pre\$Et v4Lu3s 0r eN+ER YouR 0WN cuT-OfF peRiOd IN S3cOnDs. +HRe@D5 mODiF1Ed 3@rl13r +H4n +Eh d3PhiNEd CU+-ofF p3ri0D WiLL 4utOM4+IC4llY 4pP34r A\$ Re@d.";
$lang['forum_settings_help_49'] = "ch00\$1N9 <b>dI548l3 UNRe4D m3\$54g3S</b> WIlL C0mPL3+ELY R3mOv3 UnR34d mESS4Ge5 SuPP0r+ 4nd RemOV3 tH3 R3L3V4N+ 0P+10N\$ FRom T3h Di\$cU\$s10N +yp3 drOP D0Wn 0N +h3 tHRe4d LisT.";
$lang['forum_settings_help_50'] = "<b>reqU1R3 UseR 4Ppr0vAL bY 4dMin</b> 4LlOWS J00 +o ReStR1cT 4Cce5S 8y NeW U5ErS uN+1L tHeY H4V3 83En @PproVed 8Y 4 m0deR4ToR OR 4dmIN. w1tHOUt 4PpROV4l a u53R c4NnO+ aCcess ANY @R34 0F the b33h1v3 PHOruM IN5T4LL@+I0N 1ncLud1N9 1nd1V1du4L foRumS, PM 1nb0X anD MY FORuMS 5Ect1ONS.";
$lang['forum_settings_help_51'] = "us3 <b>clo\$ed m3\$\$49e</b>, <b>r3sTRIct3d M3\$5@9E</b> 4nd <b>p4\$sword prO+EC+eD M3S549E</b> +o cUS+OM1\$3 +He m3S549e DI\$plAy3d wHEn U\$ER5 4CC35S y0uR PH0rUm In th3 V4Ri0U\$ \$t4T3S.";
$lang['forum_settings_help_52'] = "j00 C4n u53 H+ML 1n y0uR m3\$54gE5. hYpeRLinKs @nd em4Il @ddrEs5E\$ WiLl @L5O 83 4u+0m@+1c@lLy c0NveRT3d To lInks. t0 U5e tH3 d3PH4Ul+ 833H1Ve F0Rum m3\$54gE5 CL34r +he F1eld5.";
$lang['forum_settings_help_53'] = "<b>aLL0W uSerS T0 ch4nGe U5Ern4mE</b> pERM1tS 4Lr34Dy r3gi5TeRed U\$Er5 +0 cH4ng3 +He1R U\$3rn4m3. Wh3n En48leD J00 C4n tr4Ck +EH cH4NGE5 4 u5Er m@k3s tO +he1r u53rn4m3 vI@ tHE 4Dm1n USER +OOl\$.";

// Attachments (attachments.php, get_attachment.php) ---------------------------------------

$lang['aidnotspecified'] = "a1D n0T \$p3cIf1ed.";
$lang['upload'] = "uplO4D";
$lang['uploadnewattachment'] = "uPL0@d NEw @tt4chmEN+";
$lang['waitdotdot'] = "w41T..";
$lang['successfullyuploaded'] = "succeS5PhuLlY UPL0@DEd";
$lang['failedtoupload'] = "f@Il3d +o upLO@D";
$lang['complete'] = "c0mpL3+e";
$lang['uploadattachment'] = "upLo@d @ f1L3 PH0r 4Tt4cHm3n+ TO +eh m3SS49E";
$lang['enterfilenamestoupload'] = "enT3r PHil3N@me(S) +0 uplOad";
$lang['attachmentsforthismessage'] = "a+T@chMenTS F0r +H1s m3S5493";
$lang['otherattachmentsincludingpm'] = "otH3R 4tt4ChMenTS (1ncLUD1NG Pm M3sS4g3\$ 4nd 0+hEr pH0RuMs)";
$lang['totalsize'] = "tO+4l 5IZe";
$lang['freespace'] = "frE3 Sp@cE";
$lang['attachmentproblem'] = "therE W45 4 pR0Bl3M D0WNL04dIn9 +h1\$ 4T+@cHmeN+. Pl3@S3 +rY 494iN L@+3R.";
$lang['attachmentshavebeendisabled'] = "a+taCHMen+5 h4vE 8E3N D1548LeD By +H3 Ph0rUM 0wnER.";
$lang['canonlyuploadmaximum'] = "j00 c@n 0NLy upL04d @ M4X1MuM of 10 F1Le\$ 4+ @ TImE";
$lang['deleteattachments'] = "delEtE @t+4ChmeN+5";
$lang['deleteattachmentsconfirm'] = "ar3 J00 Sur3 j00 w4n+ +o d3l3+3 TH3 \$elECtED 4++4cHMeN+5?";
$lang['deletethumbnailsconfirm'] = "ar3 j00 5Ur3 J00 W@n+ +O D3l3T3 +3h s3L3ct3d 4+t@ChM3NTs +HUM8n41l\$?";

// Changing passwords (change_pw.php) ----------------------------------

$lang['passwdchanged'] = "p45SW0rD Ch4NG3D";
$lang['passedchangedexp'] = "y0ur pA\$Sw0RD H@5 B33N ch@N9Ed.";
$lang['updatefailed'] = "upd@+E pH4ilEd";
$lang['passwdsdonotmatch'] = "p4SswORd5 Do N0+ M4Tch.";
$lang['allfieldsrequired'] = "aLL ph1eLd5 4Re r3Qu1r3d.";
$lang['requiredinformationnotfound'] = "r3QU1R3d 1NfORMA+1ON NO+ pH0UND";
$lang['forgotpasswd'] = "f0Rg0+ p4\$\$WORD";
$lang['enternewpasswdforuser'] = "eNTer @ N3W P4SsW0rD fOr u\$3r %s";
$lang['resetpassword'] = "r35Et p45Sw0RD";
$lang['resetpasswordto'] = "r3SE+ P4\$\$worD +0";

// Deleting messages (delete.php) --------------------------------------

$lang['nomessagespecifiedfordel'] = "n0 M3SS49e 5p3c1f1ED fOR deLE+i0N";
$lang['deletemessage'] = "d3le+e mE\$s493";
$lang['postdelsuccessfully'] = "p0\$t D3L3TeD 5ucC3SsphULlY";
$lang['errordelpost'] = "eRROr D3L3t1nG Po\$t";
$lang['cannotdeletepostsinthisfolder'] = "j00 c4NnO+ del3T3 pO\$TS 1n thiS f0ld3r";

// Editing things (edit.php, edit_poll.php) -----------------------------------------

$lang['nomessagespecifiedforedit'] = "nO me\$54g3 sP3c1F1ed fOR eD1Tin9";
$lang['cannoteditpollsinlightmode'] = "c@NnO+ EdIt pOlL5 1n l1Ght m0d3";
$lang['editedbyuser'] = "eD1+3D: %s 8y %s";
$lang['editappliedtomessage'] = "ediT ApPL1eD +O MeS54ge";
$lang['errorupdatingpost'] = "eRR0r UPd4+inG Po\$T";
$lang['editmessage'] = "eDit M3s\$493 %s";
$lang['editpollwarning'] = "<b>n0T3</b>: 3d1+1Ng cErt4iN 4sP3Ct\$ Of 4 pOlL w1Ll VOid @Ll +hE CUrR3Nt v0t3s 4nd 4LlOW p30PLe T0 V0+E 4941n.";
$lang['hardedit'] = "h@rd 3di+ OP+1on\$ (vO+E\$ W1Ll 83 rEsE+):";
$lang['softedit'] = "sopH+ eD1+ OPt10n\$ (v0+35 W1Ll 83 R3+@1neD):";
$lang['changewhenpollcloses'] = "cH4n9E Wh3n tH3 POlL cLO\$3s?";
$lang['nochange'] = "n0 ch4ngE";
$lang['emailresult'] = "eM@1L reSuLT";
$lang['msgsent'] = "mESs49E SEnT";
$lang['msgsentsuccessfully'] = "mEs54ge \$3N+ SucC3\$\$FUlLY.";
$lang['msgfail'] = "mes54gE ph@IlEd";
$lang['mailsystemfailure'] = "m4iL \$YS+EM fAilUr3. m3\$54gE N0+ SeNT.";
$lang['nopermissiontoedit'] = "j00 @R3 N0T PErm1Tt3d +0 3Di+ ThIs m3SS493.";
$lang['cannoteditpostsinthisfolder'] = "j00 C@nnOT EdiT P0StS 1n +h15 ph0Ld3r";
$lang['messagewasnotfound'] = "mesS4g3 %s W4\$ n0+ phOUnd";

// Email (email.php) ---------------------------------------------------

$lang['nouserspecifiedforemail'] = "n0 uS3r 5pECif1Ed ph0r 3M@IlINg.";
$lang['entersubjectformessage'] = "eNT3R 4 \$u8J3C+ fOR tHE M3ss4G3";
$lang['entercontentformessage'] = "en+3r \$0ME C0NtEN+ Ph0r tHE m3\$s4GE";
$lang['msgsentfromby'] = "tH1S me\$S4G3 w4S 5enT pHR0m %s 8y %s";
$lang['subject'] = "suBJEc+";
$lang['send'] = "s3nD";
$lang['hasoptedoutofemail'] = "h45 0P+ED out 0Ph Em4IL c0nT4c+";
$lang['hasinvalidemailaddress'] = "h4\$ 4N inV4Lid em41L 4DdReS\$";

// Message nofificaiton ------------------------------------------------

$lang['msgnotification_subject'] = "m3\$s493 N0+ipHIc@+10N FROm %s";
$lang['msgnotificationemail'] = "heLl0 %s,\n\n%s po\$T3D 4 m3\$s49E To j00 0N %s\n\n+hE SuBJ3ct is: %s\n\n+0 R34d tH4+ mE\$s4g3 4nd 0+heRS 1N th3 \$4M3 D15cU5Si0n, 90 +O:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nNotE: If j00 D0 No+ WI5H TO r3c3iVE em@Il nO+iPhIc4+i0nS OpH pH0RuM MeSS4GE\$ P05T3d +o yOu, Go +O: %s Cl1cK on MY coNtROL5 TH3n em4iL 4nd PR1v4Cy, UnSELEcT +h3 3M41L n0+1f1C4+10N CHEck8oX 4Nd pR35S 5uBMIt.";

// Thread Subscription notification ------------------------------------

$lang['subnotification_subject'] = "sUB\$CR1PtI0N NO+iPhIC@+10n FROm %s";
$lang['subnotification'] = "hElL0 %s,\n\n%s p0SteD 4 m3SS493 1N 4 THre4d J00 h@ve 5U8\$CRi83d +O oN %s\n\n+HE 5u8J3c+ 1s: %s\n\nT0 Re4D +H4+ Mes54ge 4Nd O+heRS 1n TEh \$4M3 DI\$cU\$S1on, 90 +O:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nn0+E: 1f j00 dO n0+ w15H t0 r3C31V3 3M41L nO+ipHIC@+10N5 oPh NeW M3\$S@93s In +HI5 THRE4D, 9O +O: %s 4ND @dJUst yOUr iN+3r3ST LeV3L 4T +hE BOTtOM of +He p@Ge.";

// PM notification -----------------------------------------------------

$lang['pmnotification_subject'] = "pm n0T1f1ca+1ON phRom %s";
$lang['pmnotification'] = "hElLo %s,\n\n%s Po\$+Ed a PM +0 j00 oN %s\n\nTh3 SUbj3ct i5: %s\n\n+0 ReAD tH3 M3s54g3 g0 tO:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nno+e: iPh j00 Do n0+ w15H tO r3c3ive 3m@1L N0+IphIC@+10n5 0Ph N3W pM mEsS@93S Po5tEd +O yOu, 9O +0: %s Cl1ck mY c0nTR0lS thEN 3M41L 4nD pRiV@cy, UN\$eLEcT +H3 pM n0+1F1c4+10N Ch3ckB0X 4nd PrESS sU8M1+.";

// Password change notification ----------------------------------------

$lang['passwdchangenotification'] = "p4SSWOrd Ch4ngE N0+if1C@t1On fR0m %s";
$lang['pwchangeemail'] = "hELLO %s,\n\nThis 4 no+iPHic4t10n 3M4Il TO 1NfORM J00 +h4+ y0Ur p45swORD ON %s h@s b3en CH4n9Ed.\n\nI+ h45 B33N cH4N93d +0: %s 4nD w@5 ch@nGed BY: %s\n\niph j00 h@v3 r3Ce1v3d +H15 3M4IL iN eRror 0R WeRe n0T 3XPecT1NG 4 CH@N93 To y0UR P45SWoRD pL3@5e CoN+4c+ +3h FOrUM 0wNeR or 4 m0DerAtor ON %s ImMEdI4+Ely +o COrrEcT 1+.";

// Email confirmation notification -------------------------------------

$lang['emailconfirmationrequired'] = "em4IL c0nfiRM4tI0n r3quIR3d FOR %s";
$lang['confirmemail'] = "hEll0 %s,\n\nYOU R3c3nTly cre4+ED a n3W u\$3R Acc0Un+ on %s\n83fOR3 j00 CAN \$+4R+ P0\$+1Ng we NE3D +0 c0nphIRm Your 3M4Il addR3\$\$. D0N'+ W0rry +h1S IS Qui+e e4SY. @ll J00 n3ed tO D0 1s cLick The l1nk bEL0W (oR cOPy @nd P45T3 I+ iNt0 y0uR 8r0W\$eR):\n\n%s\n\nOnc3 C0NF1rm4+I0N 15 C0MplEt3 J00 m4y LOG1N 4nD ST4r+ Po\$TIN9 1Mm3dI@+ElY.\n\niF J00 diD nOt crE4Te 4 usER @CcOUnT 0N %s pl34S3 @cC3P+ oUR 4PoL0G1e5 4ND F0Rw4rD tH1S 3M41L +0 %s so Th@t +3h SoUrC3 opH iT m@Y be 1NvE\$t1G@+Ed.";

// Forgotten password notification -------------------------------------

$lang['forgotpwemail'] = "heLLo %s,\n\nY0U ReqU3S+3d +H1s E-M4il FR0m %s 8eC4uS3 J00 H4v3 Ph0rgO++En yOuR P@s\$worD.\n\nCLiCk Th3 l1nk belOW (0r c0pY 4nD P@5t3 1+ 1nTo Y0ur bROW5er) +0 R3\$Et Y0uR P4\$swOrd:\n\n%s";

// Forgotten password form.

$lang['passwdresetrequest'] = "yOUr Pa\$\$woRD ReSe+ reQuEST pHr0M %s";
$lang['passwdresetemailsent'] = "p45SWOrD rE5et E-M4il 53n+";
$lang['passwdresetexp'] = "j00 sh0uld SHoRTlY reCe1V3 4n E-m4iL C0N+41N1N9 1nStRUcT1ON5 For RE\$ET+1ng yOur P4SSWoRD.";
$lang['validusernamerequired'] = "a V4Lid u5Ern4mE is ReQuiRed";
$lang['forgottenpasswd'] = "f0RGo+ P455WoRD";
$lang['forgotpasswdexp'] = "ipH j00 h4V3 F0R9O++3n y0Ur pa\$\$W0rd, j00 c4N r3qUES+ tO H4V3 1T re\$3+ By 3N+er1n9 yOuR L09On n@ME B3Low. 1N\$tRuCt1On\$ oN H0W t0 r3\$ET youR P4S5WorD W1lL 83 S3nT TO y0Ur r39I\$Ter3D 3M@IL 4DDr3\$s.";
$lang['couldnotsendpasswordreminder'] = "coULd no+ S3ND p45SW0rD rEM1Nd3R. pL3ASE c0N+4C+ Th3 fORUm OWNeR.";
$lang['request'] = "r3QUES+";

// Email confirmation (confirm_email.php) ------------------------------

$lang['emailconfirmation'] = "eM@1L CoNFIrm4t10n";
$lang['emailconfirmationcomplete'] = "th4Nk J00 FoR c0nF1rM1n9 y0UR 3m41l 4ddreSS. J00 M4y nOw L091n 4Nd sT4r+ P0S+in9 iMmEd14+elY.";
$lang['emailconfirmationfailed'] = "em41l conpHiRM4t10n H4\$ f4IleD, Ple4\$E +ry @g4In L4+3R. 1f J00 eNc0Un+3r th1S ErROr MUlT1PlE t1m3S ple@se c0n+4c+ +he ph0RuM 0wn3R 0R 4 m0D3r4+0R f0r 45s15+4Nc3.";

// Links database (links*.php) -----------------------------------------

$lang['toplevel'] = "toP lEvEl";
$lang['maynotaccessthissection'] = "j00 M4Y n0t 4CcES5 +h15 Secti0n.";
$lang['toplevel'] = "tOp lEV3l";
$lang['links'] = "linkS";
$lang['viewmode'] = "v1EW M0DE";
$lang['hierarchical'] = "h1EraRCh1c4L";
$lang['list'] = "l1St";
$lang['folderhidden'] = "tH1\$ FOLd3r I\$ h1DdeN";
$lang['hide'] = "hIdE";
$lang['unhide'] = "unh1d3";
$lang['nosubfolders'] = "no \$U8F0LdeRS 1n +h15 C4+EGOry";
$lang['1subfolder'] = "1 5UbPh0LD3r 1n Th15 c@tE90ry";
$lang['subfoldersinthiscategory'] = "sUBPhOLd3R\$ iN ThI\$ c4+E9ORy";
$lang['linksdelexp'] = "en+r13S 1N 4 deLeT3D Ph0ld3r w1Ll 83 mOveD TO the P4rEN+ FOLd3R. 0NlY folDeRS wH1CH d0 NO+ c0nT4In 5U8FOlDERS m4y BE D3LET3d.";
$lang['listview'] = "l1\$T viEW";
$lang['listviewcannotaddfolders'] = "c@nN0+ 4Dd PH0Ld3r\$ 1N Th1\$ v1Ew. SHoW1Ng 20 3n+R1es 4T 4 T1m3.";
$lang['rating'] = "r4TINg";
$lang['nolinksinfolder'] = "nO l1nkS 1n Th1S Ph0LdeR.";
$lang['addlinkhere'] = "add L1nk here";
$lang['notvalidURI'] = "th4+ 1S nO+ 4 v@Lid UR1!";
$lang['mustspecifyname'] = "j00 muS+ Sp3c1Fy @ N4M3!";
$lang['mustspecifyvalidfolder'] = "j00 muS+ 5peC1Fy @ v4Lid pH0ld3r!";
$lang['mustspecifyfolder'] = "j00 mu5t SP3c1PHY 4 fOLdeR!";
$lang['addlink'] = "aDD 4 LinK";
$lang['addinglinkin'] = "adD1N9 L1nK IN";
$lang['addressurluri'] = "aDDreSS (uRl/uRi)";
$lang['addnewfolder'] = "aDd 4 n3W Ph0ld3R";
$lang['addnewfolderunder'] = "aDDIn9 n3w PH0ld3r uNdeR";
$lang['mustchooserating'] = "j00 MU5t Cho0\$E 4 RATinG!";
$lang['commentadded'] = "yOUR c0mM3n+ W4\$ 4dd3d.";
$lang['musttypecomment'] = "j00 MU5t +yPe 4 ComMeNT!";
$lang['mustprovidelinkID'] = "j00 mUS+ prOv1D3 4 LinK iD!";
$lang['invalidlinkID'] = "iNv4lID LINK 1d!";
$lang['address'] = "aDdR3S\$";
$lang['submittedby'] = "sU8m1+TEd 8y";
$lang['clicks'] = "cl1CK5";
$lang['rating'] = "r4+IN9";
$lang['vote'] = "v0+E";
$lang['votes'] = "v0T3S";
$lang['notratedyet'] = "nO+ r@+ed 8Y @ny0ne Ye+";
$lang['rate'] = "rATe";
$lang['bad'] = "b4d";
$lang['good'] = "g0oD";
$lang['voteexcmark'] = "vOTE!";
$lang['commentby'] = "cOMM3n+ 8Y %s";
$lang['addacommentabout'] = "add 4 coMMEn+ 48oUt";
$lang['modtools'] = "m0d3r4+i0N tOOL5";
$lang['editname'] = "eD1+ N4m3";
$lang['editaddress'] = "ed1+ @ddre\$\$";
$lang['editdescription'] = "ediT d35Cr1Pt1On";
$lang['moveto'] = "mOve T0";
$lang['linkdetails'] = "link D3T4Il5";
$lang['addcomment'] = "aDD COMm3N+";
$lang['voterecorded'] = "y0uR v0t3 H@5 BEen R3cORd3d";

// Login / logout (llogon.php, logon.php, logout.php) -----------------------------------------

$lang['loggedinsuccessfully'] = "j00 l0ggEd iN 5uCc3\$\$FUlLy.";
$lang['presscontinuetoresend'] = "pR3\$5 C0N+inU3 +0 R3send Ph0Rm d4+@ Or c4NceL +0 reL0@D p@9e.";
$lang['usernameorpasswdnotvalid'] = "tEH u5Ern4mE or P@s\$woRD j00 5UppLi3D i5 n0t V4l1D.";
$lang['pleasereenterpasswd'] = "pl34Se r3-3nT3r YouR p4\$5WOrd @nd +ry 4G41n.";
$lang['rememberpasswds'] = "rEm3M83r p4SSwOrd\$";
$lang['rememberpassword'] = "r3m3m83r P4\$\$WOrD";
$lang['enterasa'] = "eNT3r 4S 4 %s";
$lang['donthaveanaccount'] = "doN'+ hAV3 an @ccoUnt? %s";
$lang['registernow'] = "reG1STEr n0W.";
$lang['problemsloggingon'] = "pR0Bl3mS lOGg1ng 0n?";
$lang['deletecookies'] = "dELE+E c0OkiEs";
$lang['cookiessuccessfullydeleted'] = "cooK1E5 SUcc3\$\$PHUllY d3LeT3d";
$lang['forgottenpasswd'] = "f0R90Tt3n yOUr P@5SwoRd?";
$lang['usingaPDA'] = "uS1NG 4 PD4?";
$lang['lightHTMLversion'] = "l1GHT H+ml Ver51On";
$lang['youhaveloggedout'] = "j00 H@Ve lO993D OuT.";
$lang['currentlyloggedinas'] = "j00 4Re Curr3N+ly LO9g3d iN 4S %s";
$lang['logonbutton'] = "l0g0n";
$lang['otherbutton'] = "oTh3r";
$lang['yoursessionhasexpired'] = "y0UR s3SS10n h4S exPiR3D. J00 W1ll N3ed +0 l09iN 494iN tO c0Nt1nU3.";

// My Forums (forums.php) ---------------------------------------------------------

$lang['myforums'] = "my F0RuM\$";
$lang['recentlyvisitedforums'] = "rEceN+Ly viSiTEd F0Rum\$";
$lang['allavailableforums'] = "all 4V4Il48L3 ph0rUM\$";
$lang['favouriteforums'] = "f4V0URI+3 f0Rum5";
$lang['ignoredforums'] = "iGn0rEd Ph0rUM\$";
$lang['ignoreforum'] = "ign0R3 PH0ruM";
$lang['unignoreforum'] = "uniGn0R3 FOrUm";
$lang['lastvisited'] = "l@sT vI51TED";
$lang['forumunreadmessages'] = "%s UNrE@d meS\$4G3s";
$lang['forummessages'] = "%s M3\$s4GES";
$lang['forumunreadtome'] = "%s UnR3@d &quot;+o: m3&quot;";
$lang['forumnounreadmessages'] = "n0 UnR3ad M3\$s4gE5";
$lang['removefromfavourites'] = "r3M0Ve frOM FaV0UrItE\$";
$lang['addtofavourites'] = "add +0 f4V0uR1T3S";
$lang['availableforums'] = "av41L@8lE ph0RUM\$";
$lang['noforumsofselectedtype'] = "th3R3 @R3 n0 PH0rUm5 0ph +HE \$elect3d +YpE 4V@Il48l3. Pl34\$3 \$El3ct @ D1FPh3ReN+ tyP3.";
$lang['noforumsavailablelogin'] = "tHeR3 4RE n0 PH0ruM5 4V4Il@8le. plE45e L0G1n T0 v1Ew yOUR pH0RUm\$.";
$lang['passwdprotectedforum'] = "p@5swoRD pR0+EC+eD FOrUm";
$lang['passwdprotectedwarning'] = "tH1\$ FoRum i5 P455wOrd Pr0+EC+3d. t0 9@1N 4cCeS5 3N+eR +EH P455wORd 8elOW.";

// Message composition (post.php, lpost.php) --------------------------------------

$lang['postmessage'] = "p0st M3\$5493";
$lang['selectfolder'] = "sELEct pH0LdeR";
$lang['mustenterpostcontent'] = "j00 Mu5T ENt3r s0m3 cON+EN+ pH0R +he pO5t!";
$lang['messagepreview'] = "m3\$5493 Prev1ew";
$lang['invalidusername'] = "iNv4lID UsERn4m3!";
$lang['mustenterthreadtitle'] = "j00 mu5T 3n+ER A +ITl3 PHOr +he THr34D!";
$lang['pleaseselectfolder'] = "pl3@53 \$3l3Ct 4 F0ld3r!";
$lang['errorcreatingpost'] = "eRr0R cRE@+1Ng P05+! plE@5e Try 4gaIN in 4 f3w minu+e5.";
$lang['createnewthread'] = "cr3@+e N3w Thre@D";
$lang['postreply'] = "p05T r3plY";
$lang['threadtitle'] = "tHR3@D TI+le";
$lang['messagehasbeendeleted'] = "m3ss4g3 NOT Ph0Und. Ch3Ck +h4+ 1+ H4SN'+ 833n D3l3+ed.";
$lang['messagenotfoundinselectedfolder'] = "mesS@Ge NO+ fOUnD 1N Sel3ctED pH0lD3r. chEck TH4+ 1t H4\$N'T B33n M0V3D 0R d3l3t3D.";
$lang['cannotpostthisthreadtypeinfolder'] = "j00 c@nN0+ p05+ +H15 thR34d +ypE IN +h@t FoLD3r!";
$lang['cannotpostthisthreadtype'] = "j00 c4NNo+ pO\$T +H1S +hRE4d +Ype 4S +heRe 4r3 nO 4v4il48lE f0ldERS TH@+ 4LL0w It.";
$lang['cannotcreatenewthreads'] = "j00 C@nNo+ CrEat3 N3w +hRe4D\$.";
$lang['threadisclosedforposting'] = "tHI\$ THRE4D 1S cl0s3D, j00 caNN0T p0ST in 1T!";
$lang['moderatorthreadclosed'] = "w@RN1nG: ThIS thr34D iS Cl0\$Ed ph0r PO5tin9 +0 N0rMAl uSER\$.";
$lang['threadclosed'] = "tHR3Ad cLo5ed";
$lang['usersinthread'] = "useRS IN +hRe4d";
$lang['correctedcode'] = "cOrrECt3d COdE";
$lang['submittedcode'] = "suBM1tT3D cod3";
$lang['htmlinmessage'] = "html in M3\$s49E";
$lang['disableemoticonsinmessage'] = "d15@bL3 EmotICon\$ in M35S4g3";
$lang['automaticallyparseurls'] = "auT0m4T1c4llY P4RSe urLs";
$lang['automaticallycheckspelling'] = "aUt0M@+1C4Lly ch3cK \$P3Ll1N9";
$lang['setthreadtohighinterest'] = "sE+ thr34d t0 h1Gh In+ereST";
$lang['enabledwithautolinebreaks'] = "eN4BL3D W1+H aUT0-l1N3-bRe4K5";
$lang['fixhtmlexplanation'] = "tH1\$ fORum U\$es hTml FiLT3r1Ng. y0Ur Subm1Tt3d H+ml H4S 83eN m0dIf1ED by THe PhiLT3r5 IN \$0ME W4Y.\\n\\n+O viEw yOur orI9In4l c0dE, \$eLecT T3h \\'5U8Mi+ted coDE\\' R4dI0 8U++on.\\n+O vieW TH3 m0D1F13D COdE, \$eleCT +He \\'c0Rr3ct3D cOD3\\' R4DI0 BuTT0n.";
$lang['messageoptions'] = "m3s\$@93 oP+i0nS";
$lang['notallowedembedattachmentpost'] = "j00 4RE n0+ @lL0w3D +0 eMbeD @Tt4ChmeN+\$ In yoUr POs+s.";
$lang['notallowedembedattachmentsignature'] = "j00 4re NO+ @ll0Wed +0 3Mb3d 4t+4Chm3n+S IN yOur \$1Gn4+Ure.";
$lang['reducemessagelength'] = "m3\$54G3 L3N9th MUSt 8E uNdeR 65,535 CH4R@c+Er5 (CURRenTlY:";
$lang['reducesiglength'] = "sI9N4tuR3 Leng+H musT be undER 65,535 ch@r4C+ErS (CUrR3NTly:";
$lang['cannotcreatethreadinfolder'] = "j00 c4NNOT cRe@T3 N3w tHRe4dS 1N tH1S phOLd3r";
$lang['cannotcreatepostinfolder'] = "j00 C4NnO+ R3ply t0 P0S+5 iN th15 FolDer";
$lang['cannotattachfilesinfolder'] = "j00 c4nn0+ p0\$+ 4++@chm3nT\$ In ThI5 F0lD3R. RemOv3 4T+4CHMenTS t0 c0N+1NUE.";
$lang['postfrequencytoogreat'] = "j00 c4N 0Nly pOST 0Nc3 3VErY %s \$ECoNd\$. pL3@5e +rY a9@iN L4+3R.";
$lang['emailconfirmationrequiredbeforepost'] = "emA1L COnF1rM4+iON I\$ r3qUir3d 83PhOr3 j00 C4n PO5T. 1F J00 h4V3 NOt r3c3iVed 4 c0NfiRm4+I0N eM@1l pL34\$e Cl1ck Th3 BUT+oN 83lOW 4nD 4 n3w 0ne WIlL B3 \$en+ +0 Y0U. ipH yOur em4iL @ddr3\$S nE3DS cH@n91NG PL345e D0 5o 83ph0r3 r3qu35T1N9 @ NeW C0NphIrM@t1oN EM4il. j00 MaY ch@N9E yOur Em4iL @ddRes5 8y CLIcK My c0N+RoL5 48Ove @Nd thEN U5Er d3+41lS";
$lang['emailconfirmationfailedtosend'] = "c0NFirM4t1oN eM4Il f4IleD +0 s3nd. pl3@53 COn+4Ct +Eh fORuM OWneR +0 REc+1Fy Th1\$.";
$lang['emailconfirmationsent'] = "coNpHirMAt1on 3m4iL h4S been REseNt.";
$lang['resendconfirmation'] = "resEnd C0NFIRm4+1On";
$lang['userapprovalrequiredbeforeaccess'] = "y0Ur user 4Cc0uN+ NE3Ds to 8e 4PPrOv3d 8y 4 forum 4dM1N 8EPhOr3 j00 can AccES\$ thE REqu3\$tED PhOrum.";

// Message display (messages.php & messages.inc.php) --------------------------------------

$lang['inreplyto'] = "iN r3PlY +0";
$lang['showmessages'] = "shOW m3\$S493s";
$lang['ratemyinterest'] = "r4t3 mY 1nt3reSt";
$lang['adjtextsize'] = "aDJuS+ +ext 5IZE";
$lang['smaller'] = "sm@Ll3r";
$lang['larger'] = "l4R9eR";
$lang['faq'] = "fAQ";
$lang['docs'] = "doc\$";
$lang['support'] = "suPPOrt";
$lang['donateexcmark'] = "d0NaT3!";
$lang['threadcouldnotbefound'] = "teh REQue\$tED ThR34d cOuLD n0T B3 pHOUnd 0R 4cc3s\$ W45 d3n13d.";
$lang['mustselectpolloption'] = "j00 mUS+ SEleCt @n oP+ioN To v0T3 f0r!";
$lang['mustvoteforallgroups'] = "j00 muS+ v0+E 1n 3v3Ry GroUP.";
$lang['keepreading'] = "keep RE4DiN9";
$lang['backtothreadlist'] = "b@Ck tO +Hr34D LiST";
$lang['postdoesnotexist'] = "th@+ p0sT DOES N0+ EX1\$t 1n +HI\$ thRE4D!";
$lang['clicktochangevote'] = "cLIcK +0 cH4Ng3 V0+E";
$lang['youvotedforoption'] = "j00 v0+Ed phoR 0p+1ON";
$lang['youvotedforoptions'] = "j00 v0T3d FoR oP+I0Ns";
$lang['clicktovote'] = "cLiCk +O VO+3";
$lang['youhavenotvoted'] = "j00 H4V3 NO+ v0+ED";
$lang['viewresults'] = "v13w ResUL+5";
$lang['msgtruncated'] = "m3554ge TRUnc4T3d";
$lang['viewfullmsg'] = "v13W fULL MESs49e";
$lang['ignoredmsg'] = "i9NOr3d m3\$sa93";
$lang['wormeduser'] = "w0rmed u5ER";
$lang['ignoredsig'] = "i9NOR3d S1Gn4+UR3";
$lang['messagewasdeleted'] = "meS\$49E %s.%s w4S delET3D";
$lang['stopignoringthisuser'] = "st0p 19nORInG ThIs USer";
$lang['renamethread'] = "ren4Me thr34d";
$lang['movethread'] = "mov3 +hR3aD";
$lang['editthepoll'] = "eDI+ TH3 pOLL";
$lang['torenamethisthread'] = "tO r3N@ME THis thR34d";
$lang['closeforposting'] = "cLo5E Ph0R pO\$T1N9";
$lang['until'] = "uN+1L 00:00 u+c";
$lang['approvalrequired'] = "aPPr0V4L reQUIREd";
$lang['messageawaitingapprovalbymoderator'] = "mES54Ge %s.%s 15 4W4i+IN9 4pPrOV@L by 4 M0deR@tOR";
$lang['postapprovedsuccessfully'] = "pO\$T 4ppROV3d \$UCC3S5FuLLY";
$lang['postapprovalfailed'] = "p05t @ppR0val Ph@IlEd.";
$lang['postdoesnotrequireapproval'] = "p0sT dO3s noT reQu1R3 4pPr0v4L";
$lang['approvepost'] = "aPPr0V3 po5+ PHoR dI\$PL4y";
$lang['approvedbyuser'] = "apPR0VeD: %s BY %s";
$lang['makesticky'] = "m4k3 \$+1cky";
$lang['messagecountdisplay'] = "%s 0Ph %s";
$lang['linktothread'] = "pErm4nENt liNK to tH1s thR34D";
$lang['linktopost'] = "l1nk +0 p05+";
$lang['linktothispost'] = "lINk +O +H1s P0\$t";
$lang['imageresized'] = "thIs Im4g3 h@S beEn r3\$iZED (oRig1n4L \$1Ze %1\$sX%2\$5). to V13W +H3 phULL-S1Z3 im4Ge CL1ck h3R3.";
$lang['messagedeletedbyuser'] = "mE554gE %s.%s DElE+eD %s by %s";
$lang['messagedeleted'] = "mE\$s493 %s.%s W4\$ dEleT3D";

// Moderators list (mods_list.php) -------------------------------------

$lang['cantdisplaymods'] = "cANNo+ d1sPL4y f0LdeR mOd3r4T0rs";
$lang['moderatorlist'] = "m0DER4+OR l1S+:";
$lang['modsforfolder'] = "m0der4+0r\$ phOR f0Ld3R";
$lang['nomodsfound'] = "n0 m0D3R4+0R\$ F0uND";
$lang['forumleaders'] = "f0rum L34derS:";
$lang['foldermods'] = "foLD3r m0D3R4+0R5:";

// Navigation strip (nav.php) ------------------------------------------

$lang['start'] = "s+4rT";
$lang['messages'] = "mE\$s4ges";
$lang['pminbox'] = "iNB0X";
$lang['startwiththreadlist'] = "sT@RT p4G3 WitH +hr3Ad l15+";
$lang['pmsentitems'] = "s3N+ 1+3ms";
$lang['pmoutbox'] = "oUtbOx";
$lang['pmsaveditems'] = "s@v3D 1TeM5";
$lang['pmdrafts'] = "dR@Ph+s";
$lang['links'] = "l1Nks";
$lang['admin'] = "adMIn";
$lang['login'] = "l091N";
$lang['logout'] = "l09OU+";

// PM System (pm.php, pm_write.php, pm.inc.php) ------------------------

$lang['privatemessages'] = "priV4+3 Mes\$4ge5";
$lang['recipienttiptext'] = "seP4R@+e reciP13n+\$ by sem1-c0lon 0r CoMm@";
$lang['maximumtenrecipientspermessage'] = "tHere 15 4 liMI+ OPh 10 Rec1pi3N+S PEr m3\$S493. PLE4\$E 4mEnd y0uR r3c1PiEn+ l15T.";
$lang['mustspecifyrecipient'] = "j00 mu5T \$PEc1Fy 4+ L34S+ 0Ne R3c1PIent.";
$lang['usernotfound'] = "u\$3R %s nO+ FoUNd";
$lang['sendnewpm'] = "s3Nd nEw pm";
$lang['savemessage'] = "s@VE m3S\$49E";
$lang['timesent'] = "t1M3 \$ENt";
$lang['nomessages'] = "nO M3S\$@gE\$";
$lang['errorcreatingpm'] = "erR0R CR34+1Ng PM! ple45E tRy 4g4in 1N 4 pH3W MiNu+3s";
$lang['writepm'] = "wri+e M3\$s4Ge";
$lang['editpm'] = "eDi+ M355@ge";
$lang['cannoteditpm'] = "c4Nno+ ed1T THiS pm. It h4S ALRe4Dy 8E3n vI3W3d by th3 recIPiEnT 0R th3 mEss4Ge d03\$ n0T eXi5t Or i+ 1S 1n@cc3SS1blE bY J00";
$lang['cannotviewpm'] = "c4NnO+ v13w PM. ME5\$4Ge dO3S Not 3xIS+ oR 1T I5 In4CC3\$Si8L3 8Y J00";
$lang['pmmessagenumber'] = "m3s54GE %s";

$lang['youhavexnewpm'] = "j00 h4V3 %d New m3\$54gEs. W0uLd J00 lIke to 90 t0 YOuR InbOX noW?";
$lang['youhave1newpm'] = "j00 H4V3 1 N3w MES54G3. WoULd J00 L1k3 TO 9O +0 YoUR inb0X n0w?";
$lang['youhave1newpmand1waiting'] = "j00 h@V3 1 neW m3S\$49e.\\n\\nyOU @l\$O HAvE 1 m3SS493 4W@1+INg d3l1V3rY. TO recE1vE tHiS MeSS4GE PLe453 cLE4r 5OmE \$p4c3 1n Y0Ur 1nB0X.\\n\\nW0uLD j00 l1K3 +0 90 +0 yOUR Inb0X N0w?";
$lang['youhave1pmwaiting'] = "j00 h4VE 1 m3\$s4g3 @w4I+1Ng D3L1VeRY. +0 REcE1Ve thI5 meSS4g3 pLE4\$e Cl3AR S0Me sP4C3 1n YOUr In8OX.\\n\\nw0uLd j00 lIK3 +0 9O +0 Y0UR INBox nOW?";
$lang['youhavexnewpmand1waiting'] = "j00 H4VE %d n3w MeS54ge5.\\n\\ny0u @L\$O h@VE 1 M3S\$49E 4w41T1NG D3L1V3Ry. +0 R3cE1V3 THi5 m3S\$@gE pLe@S3 CLe4R Som3 \$pAc3 1n yOur 1nbox.\\n\\nwOuLD J00 L1Ke TO GO t0 YouR iNboX nOw?";
$lang['youhavexnewpmandxwaiting'] = "j00 H4ve %d n3w m3\$5493\$.\\n\\nY0U 4l\$0 h@ve %d m3SS4G3s 4w@iT1n9 d3LIveRY. tO r3CeIVE THeSE m3S54g3 pL34S3 CLe4r \$0m3 \$P4ce In y0Ur 1nbOX.\\n\\nWoULD J00 LIk3 to 90 t0 YouR 1N8OX n0W?";
$lang['youhave1newpmandxwaiting'] = "j00 H4vE 1 nEw M3\$\$@g3.\\n\\nYoU 4LsO h@vE %d m3sS4GES 4waI+iN9 d3L1vErY. To rEc31vE +HeS3 Mes54G35 pl3@se clE4R \$0M3 \$P4CE in YOuR iNbox.\\n\\nWoULD j00 L1K3 +0 9O t0 Y0uR 1N8Ox n0W?";
$lang['youhavexpmwaiting'] = "j00 h4V3 %d m3sS4g3s 4W@ItinG dEliV3rY. to REC3IVe +Hese M3Ss493S pl3@S3 cleAR \$oMe \$p@Ce iN Y0UR In8ox.\\n\\nW0Uld J00 LIKe TO 9o +O YOuR IN80x NOW?";

$lang['youdonothaveenoughfreespace'] = "j00 d0 nO+ H4v3 3n0U9h fR33 \$P4c3 to \$3ND tHiS mES54GE.";
$lang['userhasoptedoutofpm'] = "%s h4\$ opT3d ouT oF reC3IV1N9 P3RSoN@L Me\$\$@9e\$";
$lang['pmfolderpruningisenabled'] = "pM fOlDEr PrUnin9 I\$ 3n48L3d!";
$lang['pmpruneexplanation'] = "tHIS foRuM U5E\$ PM f0lDer PRUN1n9. TH3 mE5Sa935 j00 H4vE 5+0r3D In yOuR 1n8oX 4nd sEn+ 1Tem\$\\nPH0Ld3rS 4re su8J3ct +0 @u+0m@+1C d3Let1on. aNy M3\$54g3S J00 w15H t0 K3EP \$h0ULd bE moVEd +0\\nyoUr \\'S4v3D ITEm\$\\' PHOldER \$O +H4+ +hey 4R3 No+ del3T3d.";
$lang['yourpmfoldersare'] = "yoUR PM pHOldErS 4R3 %s FuLL";
$lang['currentmessage'] = "cURreN+ ME55493";
$lang['unreadmessage'] = "unrE4D M3ss493";
$lang['readmessage'] = "r3@d MESS4G3";
$lang['pmshavebeendisabled'] = "p3RsoN4L M3ss4GES H4VE B33N d1548l3D by t3h F0RuM OWN3R.";
$lang['adduserstofriendslist'] = "adD u53rs +0 Y0uR FR1enD\$ l1St to h4Ve Th3m @pPe4r In 4 dR0P D0wN On TH3 pm WrITE M35s4G3 PAGE.";

$lang['messagesaved'] = "m3s\$493 \$4v3D";
$lang['messagewassuccessfullysavedtodraftsfolder'] = "m35\$49E W45 \$Ucc3\$\$fuLlY s4veD +0 'dr@F+S' FOLd3r";
$lang['couldnotsavemessage'] = "c0ULd nOT \$4ve mesS4Ge. m4Ke SUR3 j00 h@v3 3N0u9h 4v41l@8L3 PhRe3 Sp4C3.";
$lang['pmtooltipxmessages'] = "%s M3S\$49eS";
$lang['pmtooltip1message'] = "1 M3\$5493";

// Preferences / Profile (user_*.php) ---------------------------------------------

$lang['mycontrols'] = "my c0N+r0Ls";
$lang['myforums'] = "mY pHOrUms";
$lang['menu'] = "m3Nu";
$lang['userexp_1'] = "us3 +hE m3nU ON +Eh l3pHT +O M@N49e Y0uR S3+T1n9S.";
$lang['userexp_2'] = "<b>uSER d3+@1l5</b> 4llOW\$ J00 +0 ch4n9E Y0Ur n@mE, eM4il @DDreS\$ 4nd p455wORD.";
$lang['userexp_3'] = "<b>uS3R PR0PH1LE</b> 4lLowS j00 +0 3D1t y0Ur USer Pr0ph1le.";
$lang['userexp_4'] = "<b>cH4ngE pAS5wOrd</b> 4Ll0wS J00 +0 cH4Nge yoUR p@55WOrD";
$lang['userexp_5'] = "<b>em4IL &amp; pr1v4Cy</b> LEtS j00 cH4N9E HoW j00 c@N b3 coN+4c+3D 0N @ND oPhPH th3 F0Rum.";
$lang['userexp_6'] = "<b>f0RUM oP+I0ns</b> LeT\$ j00 CH4Nge H0W +he fOrUM lO0K\$ 4nd w0rKS.";
$lang['userexp_7'] = "<b>aTT4chM3N+5</b> 4LLOw\$ J00 t0 3dI+/d3L3t3 yOUr 4+T4cHMenTs.";
$lang['userexp_8'] = "<b>si9n@+urE</b> lET\$ j00 ED1T YoUr \$ign4tur3.";
$lang['userexp_9'] = "<b>rel4TI0Nship5</b> letS J00 m4n4gE y0Ur rEl4ti0NsH1p wI+H o+Her u\$eRS 0N th3 ph0RuM.";
$lang['userexp_9'] = "<b>w0rd F1L+3r</b> L3TS J00 eD1T yOUR p3rSON@l w0RD f1L+3r.";
$lang['userexp_10'] = "<b>thR3@D sU8\$crIP+10N\$</b> 4LlOw5 j00 +0 m@n@g3 y0ur THre@d 5u85cR1P+10N5.";
$lang['userdetails'] = "u5ER D3+4IlS";
$lang['userprofile'] = "uS3R proFiLE";
$lang['emailandprivacy'] = "em41L &amp; pr1v4Cy";
$lang['editsignature'] = "ed1t s1Gn4+UR3";
$lang['norelationships'] = "j00 h4v3 No u5er REl4+i0N5h1Ps \$E+ up";
$lang['editwordfilter'] = "eD1+ W0rd pH1L+3r";
$lang['userinformation'] = "u5ER INf0Rm@+10n";
$lang['changepassword'] = "cH4n9E P4sSWOrd";
$lang['currentpasswd'] = "cUrrEn+ p@5sWORd";
$lang['newpasswd'] = "nEW p4S5w0Rd";
$lang['confirmpasswd'] = "c0NPHiRm Pa\$SwORd";
$lang['passwdsdonotmatch'] = "p4\$swOrd\$ dO N0+ m4tch!";
$lang['nicknamerequired'] = "nIcKN4me i5 REqu1R3d!";
$lang['emailaddressrequired'] = "eM4il ADdr3\$S Is requiREd!";
$lang['logonnotpermitted'] = "lOGOn N0T P3rmiTt3D. cH0O5E 4nO+Her!";
$lang['nicknamenotpermitted'] = "nIcKN@Me NO+ peRm1++eD. cHO0\$3 @n0+HEr!";
$lang['emailaddressnotpermitted'] = "em41L 4DdR3S\$ No+ P3RmItt3d. ch0O53 @no+HER!";
$lang['emailaddressalreadyinuse'] = "em41l @ddr3\$\$ 4lRe4dY 1N U\$E. cH0O\$E 4noTH3r!";
$lang['relationshipsupdated'] = "rELA+I0NSh1P\$ UpDat3D!";
$lang['relationshipupdatefailed'] = "r3LA+i0NsH1P uPd4+3D pH4Il3d!";
$lang['preferencesupdated'] = "pReFEr3nc3S w3R3 \$ucC3\$SFuLlY UPd4+eD.";
$lang['userdetails'] = "u\$Er d3+4IlS";
$lang['memberno'] = "mem83r N0.";
$lang['firstname'] = "f1R\$t n4me";
$lang['lastname'] = "l4\$+ n@mE";
$lang['dateofbirth'] = "daTE OPh b1Rth";
$lang['homepageURL'] = "h0M3P@93 Url";
$lang['profileandavatar'] = "prOFile 4nD 4v4+4r";
$lang['profileavatarpicexplain'] = "hErE j00 c4N S3Lec+ 4 PrOf1L3 piC+UR3 +O 8E 5HoWN 1n youR prOF1L3 P0PUP 4nd 0n tHE R3c3Nt viS1+OR loG. j00 c@n cHOo\$E T0 \$peCIphY +he UrL 0F 4n EX1sT1N9 1m49E +H4+ J00 haV3 H0\$ted elSewH3R3 0r TO Upl0@d 4n 1M493 45 @n @tT4cHm3n+.";
$lang['profilepicturedimensions'] = "pr0f1LE p1cTURe (m4X 150x150PX)";
$lang['avatarpicturedimensions'] = "av@+4R pic+uR3 (M@X 15x15px)";
$lang['selectattachment'] = "sELecT 4Tt4chMEn+";
$lang['pictureURL'] = "p1C+Ur3 UrL";
$lang['avatarURL'] = "av@t4R Url";
$lang['profilepictureconflict'] = "t0 USE @N 4+T4chM3Nt Ph0R Y0Ur Pr0fIL3 pIctUR3 +HE p1C+uRe urL F1ELd Mu5T b3 BL@NK.";
$lang['avatarpictureconflict'] = "tO uSE 4n 4T+4ChMeN+ FOr Y0uR @Va+@R p1c+UrE TEh AvAT4R uRL PhIeld MU5T 83 8L4nK.";
$lang['attachmenttoolargeforprofilepicture'] = "s3l3c+3d @TT@chmEnT iS T00 LaR9E PHOr PR0pHIlE P1C+Ur3. m4XImUm d1M3n51oNs 4R3 150x150pX";
$lang['attachmenttoolargeforavatarpicture'] = "sElectED @t+4CHM3NT i\$ +Oo L@R93 pH0R 4V@+4r PIC+uRE. M@x1MUM d1MEN\$10Ns 4RE 15x15Px";
$lang['forumoptions'] = "fORUm 0P+I0NS";
$lang['notifybyemail'] = "no+IfY by em@IL 0f PO\$tS To m3";
$lang['notifyofnewpm'] = "nOTIfy 8Y pOpUP 0ph n3w pm Me\$54geS T0 ME";
$lang['notifyofnewpmemail'] = "n0t1fY bY 3M41L Of neW PM M3\$54g35 +0 me";
$lang['daylightsaving'] = "aDJUSt Ph0r d4yl1GH+ S4Vin9";
$lang['autohighinterest'] = "auT0M4+1c@Lly MaRk +HRE4D5 1 po5t in 4s HIGh 1NT3reST";
$lang['convertimagestolinks'] = "aU+oM4+IcAlLy coNvERt EMbEdded 1M@9es 1n p0\$Ts 1N+0 L1Nk5";
$lang['thumbnailsforimageattachments'] = "thuMBN@1lS PH0r Im49E 4+t4chMEnT\$";
$lang['smallsized'] = "sm@ll \$1ZEd";
$lang['mediumsized'] = "meDIUm \$iZ3D";
$lang['largesized'] = "l4RgE SIzEd";
$lang['globallyignoresigs'] = "glo8@lly i9nOr3 U5Er \$IgN@tURES";
$lang['allowpersonalmessages'] = "allOw 0Th3r uSERS t0 s3nD M3 p3rS0n4L me\$S49ES";
$lang['allowemails'] = "alLoW o+HeR UsErS to s3ND m3 em@Il5 v14 MY pRopHIl3";
$lang['timezonefromGMT'] = "tIme zOn3";
$lang['postsperpage'] = "p0st\$ PEr P@g3";
$lang['fontsize'] = "f0n+ s1z3";
$lang['forumstyle'] = "f0RuM S+yL3";
$lang['forumemoticons'] = "forUM eMO+ic0NS";
$lang['startpage'] = "st4r+ PA93";
$lang['signaturecontainshtmlcode'] = "si9n4TuR3 CoN+4in5 H+ML c0de";
$lang['savesignatureforuseonallforums'] = "s4ve s1gn4+Ur3 F0R U\$3 ON 4Ll f0rUms";
$lang['preferredlang'] = "pR3ph3rRED L4n9u493";
$lang['donotshowmyageordobtoothers'] = "d0 NO+ \$H0W My @9E 0r d4+3 OPh B1r+H TO otH3RS";
$lang['showonlymyagetoothers'] = "sh0W 0Nly My 493 +0 0TH3R\$";
$lang['showmyageanddobtoothers'] = "sh0w 8o+H MY Ag3 4Nd D@+E 0Ph b1rth +o 0theRS";
$lang['showonlymydayandmonthofbirthytoothers'] = "sH0W 0Nly mY d4y 4nD mON+H 0ph 81RtH TO otHEr5";
$lang['listmeontheactiveusersdisplay'] = "lis+ ME on tHE @c+IVE USErS d1SPL4Y";
$lang['browseanonymously'] = "bR0ws3 FOrUM @noNYm0USLy";
$lang['allowfriendstoseemeasonline'] = "bR0w\$e 4n0NYm0USLy, 8U+ @LLoW FR1ENdS +0 \$eE Me 45 oNLiNe";
$lang['revealspoileronmouseover'] = "r3Ve4l \$Po1Lers oN MOU\$e oVER";
$lang['resizeimagesandreflowpage'] = "reS1ZE 1M4GeS 4nD r3PhLOw p4Ge To Pr3VenT H0Riz0n+@L ScR0LL1n9.";
$lang['showforumstats'] = "sH0w FORum \$t4+s 4+ 80++oM OF MeSS493 P4NE";
$lang['usewordfilter'] = "eN48L3 w0RD f1Lt3r.";
$lang['forceadminwordfilter'] = "f0RCe u53 0ph @Dmin woRD f1l+eR ON @LL uSeR5 (inc. guE5Ts)";
$lang['timezone'] = "tIME Z0Ne";
$lang['language'] = "l4N9U49e";
$lang['emailsettings'] = "em4Il 4ND coN+4Ct \$et+iNgS";
$lang['forumanonymity'] = "fOruM 4N0nyM1+Y SeTTInGs";
$lang['birthdayanddateofbirth'] = "bIRThdAY 4nd d4T3 oF 8IrtH D1SpL4Y";
$lang['includeadminfilter'] = "iNCLud3 4dm1n wORd phILTEr 1N MY liST.";
$lang['setforallforums'] = "seT phOR 4lL pHORumS?";
$lang['containsinvalidchars'] = "cOnT41ned Inv@l1d CH4R4c+3R\$!";
$lang['postpage'] = "po\$t p4ge";
$lang['nohtmltoolbar'] = "nO htML +0Olb4R";
$lang['displaysimpletoolbar'] = "diSpL@y siMPl3 h+ml +O0lb@r";
$lang['displaytinymcetoolbar'] = "d15Pl4Y wYSiWyg h+mL +O0LB4r";
$lang['displayemoticonspanel'] = "dIspLaY EmO+IC0N5 p4NeL";
$lang['displaysignature'] = "diSPl4y SI9n4+UR3";
$lang['disableemoticonsinpostsbydefault'] = "d1548l3 EMO+ic0NS 1N mE5S49eS 8y D3phAUl+";
$lang['automaticallyparseurlsbydefault'] = "aUT0M@t1c@lly P4R\$e uRlS in m3S54ges by d3F4ul+";
$lang['postinplaintextbydefault'] = "p0\$+ 1n Pl@1N +Ex+ BY d3f4Ul+";
$lang['postinhtmlwithautolinebreaksbydefault'] = "pO\$t In H+Ml W1Th aUTo-liN3-8r34kS 8Y dEF@ul+";
$lang['postinhtmlbydefault'] = "p05t In hTml 8Y d3F4ult";
$lang['privatemessageoptions'] = "prIV@tE m3S\$A93 0P+10N\$";
$lang['pmoptions'] = "pm 0P+I0NS";
$lang['privatemessageexportoptions'] = "pRIV4+e mESSa9e 3xPOrt op+i0Ns";
$lang['savepminsentitems'] = "sAV3 @ COPy 0f 3@cH Pm 1 5End In mY S3Nt 1+em\$ F0Ld3r";
$lang['includepminreply'] = "inClUde M3554gE b0Dy WheN rePly1Ng tO Pm";
$lang['autoprunemypmfoldersevery'] = "au+0 PRUne mY Pm f0Ld3r\$ eVeRY:";
$lang['friendsonly'] = "fRI3nDs 0NlY?";
$lang['globalstyles'] = "gL084l StYleS";
$lang['forumstyles'] = "fOruM S+YL3\$";

// Polls (create_poll.php, poll_results.php) ---------------------------------------------

$lang['mustprovideanswergroups'] = "j00 mu5T PROviD3 5OM3 @N5WeR 9R0UpS";
$lang['mustprovidepolltype'] = "j00 must pROVidE 4 Poll +yp3";
$lang['mustprovidepollresultsdisplaytype'] = "j00 mu5t PR0vide r3Sul+5 D1SpL4y tYpE";
$lang['mustprovidepollvotetype'] = "j00 muST pr0viDE 4 pOlL V0t3 +YPe";
$lang['mustprovidepollguestvotetype'] = "j00 musT \$p3C1Fy ipH gU3\$Ts SHoUlD 8e 4lL0W3d t0 vO+e";
$lang['mustprovidepolloptiontype'] = "j00 mu\$T pr0ViDe 4 P0Ll Op+i0N +yP3";
$lang['mustprovidepollchangevotetype'] = "j00 mU\$t pr0v1De 4 P0ll cH4Nge VO+e tYP3";
$lang['pleaseselectfolder'] = "pLe4Se sELeCt 4 ph0ldER";
$lang['mustspecifyvalues1and2'] = "j00 MUS+ SPeC1Phy V4lUeS Ph0r 4n\$W3R5 1 4ND 2";
$lang['tablepollmusthave2groups'] = "t48ul@R f0rM@t PoLls muST h4ve Pr3C1sElY +wO v0T1n9 9ROupS";
$lang['nomultivotetabulars'] = "t@8Ul4R pH0rm4+ PolLs c4nN0+ 83 mulT1-v0+e";
$lang['nomultivotepublic'] = "pU8lic b4LLO+5 C@nno+ b3 mulTi-vo+e";
$lang['abletochangevote'] = "j00 WILl be 48L3 to Ch@nG3 YOUr V0+3.";
$lang['abletovotemultiple'] = "j00 will 8e 48l3 tO v0+e mUlt1PlE tiM35.";
$lang['notabletochangevote'] = "j00 W1lL nO+ 83 ABLe to CHaN93 yOur vOt3.";
$lang['pollvotesrandom'] = "nO+e: pOLL vO+eS 4R3 r4nd0Mly g3n3R@+Ed PhOR Pr3Vi3w OnLY.";
$lang['pollquestion'] = "poLL qU3\$+10n";
$lang['possibleanswers'] = "p0\$518L3 @n5w3R5";
$lang['enterpollquestionexp'] = "en+3r +3h @N5w3RS FOr y0uR poLl Qu3sT1oN.. IF Y0Ur PoLl 1S 4 &quot;Yes/nO&quot; qUEST1on, \$1MPlY 3n+er &quot;y3s&quot; f0R @n5WEr 1 4nd &quot;nO&quot; F0R @n5W3R 2.";
$lang['numberanswers'] = "nO. 4N\$w3RS";
$lang['answerscontainHTML'] = "an5WERs C0Nt4IN H+mL (NO+ 1ncLUdIN9 51Gn4TuRe)";
$lang['optionsdisplay'] = "aNsW3r\$ d1SPl4y TyP3";
$lang['optionsdisplayexp'] = "hOw \$houLD +eh 4n5w3rS Be Pre53Nt3d?";
$lang['dropdown'] = "a\$ dR0p-D0Wn LIsT(5)";
$lang['radios'] = "as @ S3Ri3S opH R4Di0 8Ut+On5";
$lang['votechanging'] = "v0T3 cH4n9INg";
$lang['votechangingexp'] = "cAN @ peRS0n CH4n9e hI\$ OR h3r V0te?";
$lang['guestvoting'] = "gUES+ v0+1Ng";
$lang['guestvotingexp'] = "c@n gueS+5 vOt3 1N +hi5 Poll?";
$lang['allowmultiplevotes'] = "aLLOW MuL+IPle vO+E\$";
$lang['pollresults'] = "p0LL r3SuL+S";
$lang['pollresultsexp'] = "hOw w0uld J00 liKe T0 d1Spl4Y THe reSUL+S of y0uR pOLl?";
$lang['pollvotetype'] = "p0LL v0T1Ng TyP3";
$lang['pollvotesexp'] = "hoW \$HOuld Th3 POll b3 c0ndUcted?";
$lang['pollvoteanon'] = "aNONYm0U\$LY";
$lang['pollvotepub'] = "puBL1c 84LlO+";
$lang['horizgraph'] = "h0RIZ0N+4l 9r4Ph";
$lang['vertgraph'] = "vERt1c4L 9R4ph";
$lang['tablegraph'] = "t48uL@r FORm4t";
$lang['polltypewarning'] = "<b>w@rn1Ng</b>: th1S 15 4 pUbL1c 8@llO+. y0Ur N4m3 WilL 83 v1518l3 nEXt to th3 OP+ion j00 vO+3 pH0R.";
$lang['expiration'] = "eXpIr4+I0n";
$lang['showresultswhileopen'] = "dO J00 w@Nt +0 \$H0w Re\$ul+\$ Wh1l3 T3h pOlL Is 0p3n?";
$lang['whenlikepollclose'] = "wh3N W0Uld J00 l1k3 y0UR Poll to AuT0m4Tic@LLY Cl05E?";
$lang['oneday'] = "oNE D4y";
$lang['threedays'] = "tHRE3 d4Y\$";
$lang['sevendays'] = "sEv3n d@Y\$";
$lang['thirtydays'] = "th1RTY d@Y5";
$lang['never'] = "n3v3R";
$lang['polladditionalmessage'] = "adDI+1On@L M3\$sAge (0P+I0N4l)";
$lang['polladditionalmessageexp'] = "dO j00 W@n+ TO IncLud3 4n 4ddI+10N@L p05T @pH+3R th3 pOLL?";
$lang['mustspecifypolltoview'] = "j00 mU5T SPEC1Fy 4 p0Ll t0 V1ew.";
$lang['pollconfirmclose'] = "ar3 j00 suR3 J00 w4N+ +O clO\$E +h3 pHoLLowIn9 p0ll?";
$lang['endpoll'] = "enD poLl";
$lang['nobodyvotedclosedpoll'] = "n08ODy v0T3d";
$lang['votedisplayopenpoll'] = "%s @Nd %s H4V3 vO+3D.";
$lang['votedisplayclosedpoll'] = "%s 4Nd %s V0T3d.";
$lang['nousersvoted'] = "nO u\$erS";
$lang['oneuservoted'] = "1 U\$ER";
$lang['xusersvoted'] = "%s US3r\$";
$lang['noguestsvoted'] = "nO 9U3STS";
$lang['oneguestvoted'] = "1 GUE\$t";
$lang['xguestsvoted'] = "%s GuE5T\$";
$lang['pollhasended'] = "p0LL has EnD3D";
$lang['youvotedforpolloptionsondate'] = "j00 V0+ed Ph0R %s 0n %s";
$lang['thisisapoll'] = "thi5 1S @ p0Ll. CL1Ck +0 VieW R3SuL+s.";
$lang['editpoll'] = "ediT POLL";
$lang['results'] = "r35UL+s";
$lang['resultdetails'] = "re\$ULt d3+4IlS";
$lang['changevote'] = "ch4NgE VO+E";
$lang['pollshavebeendisabled'] = "p0LLS h4vE BEeN DI\$48LEd 8Y thE F0rum 0WN3R.";
$lang['answertext'] = "aN\$W3r TEx+";
$lang['answergroup'] = "aNSWer 9rOUp";
$lang['previewvotingform'] = "prEV13w vo+1nG Ph0Rm";
$lang['viewbypolloption'] = "vieW 8Y pOlL 0PtI0N";
$lang['viewbyuser'] = "vI3w by uSeR";

// Profiles (profile.php) ----------------------------------------------

$lang['editprofile'] = "eD1+ Pr0phIle";
$lang['profileupdated'] = "pROf1LE Upd4ted.";
$lang['profilesnotsetup'] = "thE PhoRuM 0WN3R h4S nOt 53+ up pROphIlE\$.";
$lang['ignoreduser'] = "iGN0rEd U5er";
$lang['lastvisit'] = "l4st Vi\$1+";
$lang['totaltimeinforum'] = "t0T@l +IM3";
$lang['longesttimeinforum'] = "lon9ES+ SE5SIon";
$lang['sendemail'] = "senD 3m@il";
$lang['sendpm'] = "s3nD Pm";
$lang['visithomepage'] = "v1Sit h0Mep4G3";
$lang['age'] = "agE";
$lang['aged'] = "a9ED";
$lang['birthday'] = "bIR+hd4Y";
$lang['registered'] = "re915T3Red";
$lang['findusersposts'] = "fInd U\$3R'S p05tS";
$lang['findmyposts'] = "f1nD my pOSTs";

// Registration (register.php) -----------------------------------------

$lang['newuserregistrationsarenotpermitted'] = "s0rrY, n3w U5Er rEgiS+R@+10n\$ 4R3 No+ 4lLoW3D r1gHT n0W. pl3@5e Ch3cK 84Ck l@+ER.";
$lang['usernameinvalidchars'] = "u\$ERn@m3 cAN 0nLy cON+41N 4-Z, 0-9, _ - Ch@R@cT3RS";
$lang['usernametooshort'] = "u\$erN@me mu\$T b3 4 miN1MuM OPH 2 CH4R4ct3Rs L0N9";
$lang['usernametoolong'] = "u\$ERNAm3 mU\$t be @ m@X1MuM oF 15 Ch4r4ctER5 LON9";
$lang['usernamerequired'] = "a L090N n@M3 15 r3QuIr3d";
$lang['passwdmustnotcontainHTML'] = "p4\$\$W0Rd Mu\$t No+ C0N+4in htML +@gS";
$lang['passwordinvalidchars'] = "p@S\$wOrD c@n ONlY cOnT41n 4-z, 0-9, _ - cH4R@cTeRs";
$lang['passwdtooshort'] = "pA5\$w0rD MU\$T be 4 mIN1mUM 0ph 6 cH@r4Ct3r5 lon9";
$lang['passwdrequired'] = "a P455w0RD 15 R3quIR3d";
$lang['confirmationpasswdrequired'] = "a c0Nf1rm4+1On p455woRd iS reQuirEd";
$lang['nicknamerequired'] = "a NicKN4m3 I5 rEquIReD";
$lang['emailrequired'] = "aN 3m4iL 4ddr35S 15 R3qU1R3D";
$lang['passwdsdonotmatch'] = "p@\$5WORdS DO N0+ m4tcH";
$lang['usernamesameaspasswd'] = "us3RN@m3 @nd P@5SW0rD mu\$+ 8e d1PHPh3R3n+";
$lang['usernameexists'] = "s0rRy, 4 U5eR w1Th +h4+ n@mE 4lr34DY eXIs+s";
$lang['successfullycreateduseraccount'] = "sUCc35\$fUllY cR34+Ed U53r 4ccOun+";
$lang['useraccountcreatedconfirmfailed'] = "your U\$er 4ccOUn+ H45 833N cr34+Ed bUt +he r3QuiR3d C0nPhiRm4+i0N 3m4Il W4\$ no+ SEnT. pl34S3 Cont4C+ TH3 Ph0RuM 0wN3r +0 Rec+1FY THI5. 1n +hI\$ M34Nt1Me plE453 cLiCK +hE c0N+inUE 8Ut+0N T0 l0G1n iN.";
$lang['useraccountcreatedconfirmsuccess'] = "y0ur U53R 4cc0UN+ H4S 8E3N cR34+ED BUt beph0r3 j00 c4N 5t4r+ P0\$t1ng j00 muST coNf1rm yOUR EM41L 4ddResS. pL345E cH3ck YoUr em4il pH0R 4 linK tH@+ wILL @lL0W J00 +0 c0nPh1rm Y0Ur 4DDR355.";
$lang['useraccountcreated'] = "your US3R @CcOunT h4s beeN CRE4+Ed SUCC3\$5FUlLy! cl1Ck th3 CON+1NuE bUTT0N 83L0w +0 l091n";
$lang['errorcreatinguserrecord'] = "err0R Cr34T1n9 uSER r3C0rd";
$lang['userregistration'] = "u\$3R R391sTr4+10n";
$lang['registrationinformationrequired'] = "r3Gi5TR4+i0n 1NfOrM4t10n (reqUiR3D)";
$lang['profileinformationoptional'] = "pR0PhIl3 1NpH0rm4+I0N (0p+I0N@l)";
$lang['preferencesoptional'] = "pr3phErENCE\$ (0P+i0N4l)";
$lang['register'] = "rEGI5Ter";
$lang['rememberpasswd'] = "r3member P@5SWoRd";
$lang['birthdayrequired'] = "y0ur d4TE oF b1rtH IS requ1rED Or 1S 1nv@LId";
$lang['alwaysnotifymeofrepliestome'] = "n0TIPhY On R3pLy To m3";
$lang['notifyonnewprivatemessage'] = "nOtIpHy 0n nEw pR1v4t3 m3S5493";
$lang['popuponnewprivatemessage'] = "poP uP 0n N3w pRiv4+E ME\$s493";
$lang['automatichighinterestonpost'] = "au+oM@tiC hIgh 1nT3re\$+ 0n P0\$t";
$lang['confirmpassword'] = "coNFiRM P4S5wOrD";
$lang['invalidemailaddressformat'] = "inValID 3M@Il 4DDR3\$5 PhOrM4+";
$lang['moreoptionsavailable'] = "mORE pR0PhILe 4nd pr3Ph3r3nc3 opT10n5 @re 4v@iL4blE 0Nce J00 Reg1S+3R";
$lang['textcaptchaconfirmation'] = "coNPhIrm4+10n";
$lang['textcaptchaexplain'] = "t0 TEH rIgh+ is 4 t3X+-C4PtcH@ 1m49e. pL34\$e tYp3 th3 cODE J00 C@N S33 1N +Eh im4Ge 1ntO tH3 InPuT f1ELD b3l0W It.";
$lang['textcaptchaimgtip'] = "thIS 1S a c4PtcH4-PIc+uRe. i+ 15 UsED tO preVEnT @U+OM@tic r3GiS+R4T10N";
$lang['textcaptchamissingkey'] = "a C0NpHirM4+IOn cod3 1\$ ReQU1rEd.";
$lang['textcaptchaverificationfailed'] = "tEX+-c4Ptch@ v3R1f1CatI0n c0De W@5 inc0rr3cT. PlE4S3 RE-eN+3r I+.";

// Recent visitors list  (visitor_log.php) -----------------------------

$lang['member'] = "mEMB3R";
$lang['searchforusernotinlist'] = "se4Rch FOR 4 U\$ER n0+ iN L15+";
$lang['yoursearchdidnotreturnanymatches'] = "yoUr Se4rcH DId N0t retUrn 4nY M4TcHeS. tRy siMPliFy1n9 Y0UR \$E4rch p@R@me+erS @nd try 4941n.";
$lang['hiderowswithemptyornullvalues'] = "h1DE r0WS W1+h eMp+Y 0r NUll v4lueS 1N SeL3CtEd colUmN5";
$lang['showregisteredusersonly'] = "sH0w rE9i5T3red u5eR5 0Nly (hIde guE5Ts)";

// Relationships (user_rel.php) ----------------------------------------

$lang['relationships'] = "r3L4+ioN\$h1P5";
$lang['userrelationship'] = "us3r reL@+10n5H1p";
$lang['userrelationships'] = "uSER Rel4+iON\$h1Ps";
$lang['failedtoremoveselectedrelationships'] = "f@ilEd +0 rEMOvE \$el3C+ED R3l4+10n5H1P";
$lang['friends'] = "fRi3ND5";
$lang['ignoredcompletely'] = "i9n0R3D c0mPl3+3Ly";
$lang['relationship'] = "r3l4+ioNSH1p";
$lang['restorenickname'] = "reS+oR3 uS3r'\$ NicKn4M3";
$lang['friend_exp'] = "us3r'\$ PO5TS m4Rk3d W1+H 4 &quot;FriENd&quot; ic0n.";
$lang['normal_exp'] = "u\$3R'S po\$TS 4pPe4r @5 NOrm@l.";
$lang['ignore_exp'] = "u\$eR'S p05tS 4re H1Dd3n.";
$lang['ignore_completely_exp'] = "thR34d5 4nD p0\$TS +0 0R pHR0m uSER w1ll 4ppe4R d3l3+3D.";
$lang['display'] = "d1SPl@y";
$lang['displaysig_exp'] = "u\$3R'5 SigN4+urE 15 di\$Pl4Y3d ON +hE1r P0\$tS.";
$lang['hidesig_exp'] = "uS3R'\$ 51Gn4+uRE is h1DDEn 0n th31r po\$tS.";
$lang['cannotignoremod'] = "j00 C4nn0+ 1gn0r3 th15 u5eR, 4s theY @r3 @ m0d3R4+0R.";
$lang['previewsignature'] = "pr3v1eW s1gN4+Ur3";

// Search (search.php) -------------------------------------------------

$lang['searchresults'] = "s34RCH r35UltS";
$lang['usernamenotfound'] = "tEH uS3Rn4m3 j00 \$Pec1f1Ed 1N tEH +0 or fR0M f1eLD W@S N0+ FoUNd.";
$lang['notexttosearchfor'] = "onE oR @ll 0f Y0ur \$3ARcH kEyWORd5 WEr3 1NV4L1d. \$34Rch kEyWoRds MU\$t be N0 SH0r+er TH@n %d ch@r4CtEr5, No L0NgEr +h4N %d CH@rAct3rS 4nD MU\$+ N0T 4pPE4r IN +3H %s";
$lang['keywordscontainingerrors'] = "k3YW0Rd5 cON+4iN1n9 errORS";
$lang['mysqlstopwordlist'] = "mySQL \$+OPW0rd LiSt";
$lang['foundzeromatches'] = "f0UNd: 0 M4+che5";
$lang['found'] = "f0Und";
$lang['matches'] = "m@TchE\$";
$lang['prevpage'] = "previOU\$ p493";
$lang['findmore'] = "f1nD m0R3";
$lang['searchmessages'] = "s3ARCH m355493S";
$lang['searchdiscussions'] = "s3ArCh d15cu55i0n5";
$lang['find'] = "fInD";
$lang['additionalcriteria'] = "aDD1+I0n4L cri+er1@";
$lang['searchbyuser'] = "s3ARch by USeR (0p+I0N@l)";
$lang['folderbrackets_s'] = "fOLDeR(\$)";
$lang['postedfrom'] = "po5+eD PhR0M";
$lang['postedto'] = "po5+3D +0";
$lang['today'] = "t0D4y";
$lang['yesterday'] = "y3\$tERd4y";
$lang['daybeforeyesterday'] = "d4y 83PH0rE YE5terD@Y";
$lang['weekago'] = "%s w33k 4GO";
$lang['weeksago'] = "%s W3Ek5 4g0";
$lang['monthago'] = "%s M0Nth @Go";
$lang['monthsago'] = "%s M0Nth\$ 49O";
$lang['yearago'] = "%s Y3@r @90";
$lang['beginningoftime'] = "b3GINniNg opH +1M3";
$lang['now'] = "now";
$lang['lastpostdate'] = "l4\$T po\$t D@+3";
$lang['numberofreplies'] = "nUM83r OPH R3Pl13\$";
$lang['foldername'] = "folD3R n4Me";
$lang['authorname'] = "aU+h0R NaME";
$lang['decendingorder'] = "n3W3st Ph1RSt";
$lang['ascendingorder'] = "oLD3s+ fIr\$+";
$lang['keywords'] = "k3YwORD\$";
$lang['sortby'] = "soR+ by";
$lang['sortdir'] = "s0RT DiR";
$lang['sortresults'] = "soR+ rE\$UL+s";
$lang['groupbythread'] = "groUP 8Y +hrE@d";
$lang['postsfromuser'] = "p05+5 PHROM UsER";
$lang['poststouser'] = "pOSTS TO U\$3r";
$lang['poststoandfromuser'] = "p05tS TO @ND FrOM us3r";
$lang['searchfrequencyerror'] = "j00 c4n 0NLY S34rcH 0Nc3 ev3Ry %s \$EC0Nd5. ple@5e tRy 4g4In L4T3r.";

// Search Popup (search_popup.php) -------------------------------------

$lang['select'] = "s3l3CT";
$lang['searchforthread'] = "se4RcH F0r +hrE4d";
$lang['mustspecifytypeofsearch'] = "j00 MU\$t SPEc1pHy TYP3 0F SE@Rch tO p3rFoRM";
$lang['unkownsearchtypespecified'] = "unKN0wn se4rch +yp3 \$PEc1fI3D";

// Start page (start_left.php) -----------------------------------------

$lang['recentthreads'] = "r3CeN+ ThR3ad5";
$lang['startreading'] = "s+@r+ rE4DinG";
$lang['threadoptions'] = "tHR3Ad 0pt10N5";
$lang['editthreadoptions'] = "ed1+ THrE4D 0pt10N\$";
$lang['morevisitors'] = "m0R3 vIS1+0R5";
$lang['forthcomingbirthdays'] = "f0R+hc0miNg b1rThd4y\$";

// Start page (start_main.php) -----------------------------------------

$lang['editstartpage_help'] = "j00 cAn ed1T tH1S P@9e fR0m tHe 4DmiN 1n+ERphAce";
$lang['uploadstartpage'] = "uPL04d s+@RT p493 (%s)";
$lang['invalidfiletypeerror'] = "f1LE type no+ 5uPp0rT3d. J00 c4n 0Nly Us3 *.Tx+, *.pHp @nd *.HTm f1Le5 45 Y0Ur 5t@RT p4G3.";

// Thread navigation (thread_list.php) ---------------------------------

$lang['newdiscussion'] = "n3W dIScU\$S1oN";
$lang['createpoll'] = "cr34+3 pOLl";
$lang['search'] = "s34RCH";
$lang['searchagain'] = "sE4rcH 494In";
$lang['alldiscussions'] = "alL d1scUS\$I0nS";
$lang['unreaddiscussions'] = "unreAD d1\$CU\$5i0N5";
$lang['unreadtome'] = "unRE4D &quot;To: M3&quot;";
$lang['todaysdiscussions'] = "toD4Y'\$ d15cUs\$i0nS";
$lang['2daysback'] = "2 D4yS 84ck";
$lang['7daysback'] = "7 D4yS B@CK";
$lang['highinterest'] = "h19H INt3re\$t";
$lang['unreadhighinterest'] = "unre4d HIGH in+ERe\$t";
$lang['iverecentlyseen'] = "i've r3C3n+LY 53eN";
$lang['iveignored'] = "i'V3 IgN0Red";
$lang['byignoredusers'] = "by 19N0r3D u5eRS";
$lang['ivesubscribedto'] = "i'v3 \$u8Scr1b3d +O";
$lang['startedbyfriend'] = "s+@r+3D bY FrI3Nd";
$lang['unreadstartedbyfriend'] = "unRe@d STd BY PHri3ND";
$lang['startedbyme'] = "s+@r+ed by me";
$lang['unreadtoday'] = "uNr3@D +OD@y";
$lang['deletedthreads'] = "deL3ted +Hr34DS";
$lang['goexcmark'] = "g0!";
$lang['folderinterest'] = "f0LDer in+3R35+";
$lang['postnew'] = "pO5+ nEW";
$lang['currentthread'] = "cuRr3N+ tHR34d";
$lang['highinterest'] = "hI9h Int3R3\$+";
$lang['markasread'] = "m4rK @5 re4D";
$lang['next50discussions'] = "nexT 50 D15cU55i0N5";
$lang['visiblediscussions'] = "vIs1Ble D1scU55i0N5";
$lang['selectedfolder'] = "s3l3Ct3d PHolD3R";
$lang['navigate'] = "n4VIG4+3";
$lang['couldnotretrievefolderinformation'] = "thERe 4R3 n0 f0Ld3r\$ 4V4iL@Bl3.";
$lang['nomessagesinthiscategory'] = "n0 m3\$54ge\$ 1N tHI5 c4+3g0Ry. pl34SE 5EL3ct 4No+HER, or";
$lang['clickhere'] = "cl1Ck H3r3";
$lang['forallthreads'] = "f0r 4ll THR3@Ds";
$lang['prev50threads'] = "prEVI0u\$ 50 ThREads";
$lang['next50threads'] = "n3x+ 50 tHrE@DS";
$lang['nextxthreads'] = "nEX+ %s tHR3@Ds";
$lang['threadstartedbytooltip'] = "thRe4d #%s \$t@r+3d bY %s. vi3w3D %s";
$lang['threadviewedonetime'] = "1 t1mE";
$lang['threadviewedtimes'] = "%d +IM3\$";
$lang['unreadthread'] = "uNRe4D ThRE4d";
$lang['readthread'] = "r3AD +HRe4d";
$lang['unreadmessages'] = "unrE@d MESS4GeS";
$lang['subscribed'] = "sUB5Cr183D";
$lang['ignorethisfolder'] = "i9NOR3 +h1s F0LdeR";
$lang['stopignoringthisfolder'] = "stOp IGn0r1Ng +H1s f0Ld3r";
$lang['stickythreads'] = "s+1ckY thRe4Ds";
$lang['mostunreadposts'] = "m0S+ unr34D po5Ts";
$lang['onenew'] = "%d NEW";
$lang['manynew'] = "%d neW";
$lang['onenewoflength'] = "%d NEW OPH %d";
$lang['manynewoflength'] = "%d n3w 0F %d";
$lang['ignorefolderconfirm'] = "aR3 j00 5ure j00 w4n+ t0 1GNOr3 tHI\$ Ph0ld3r?";
$lang['unignorefolderconfirm'] = "aRE j00 SUr3 J00 WAN+ +0 s+Op 1gNORinG +h1S ph0ldeR?";
$lang['gotofirstpostinthread'] = "g0 t0 pHIRsT PO\$T In +Hre@D";
$lang['gotolastpostinthread'] = "g0 t0 L4\$t PoSt iN +hr3ad";
$lang['viewmessagesinthisfolderonly'] = "vieW m355493\$ 1n Thi5 pHOLder onLY";
$lang['shownext50threads'] = "shOW n3X+ 50 +hRe4D\$";
$lang['showprev50threads'] = "shoW PR3vI0u\$ 50 thr34d\$";
$lang['createnewdiscussioninthisfolder'] = "cRe4Te New d1Scu5s10n 1N +H15 f0lD3r";

// HTML toolbar (htmltools.inc.php) ------------------------------------
$lang['bold'] = "b0lD";
$lang['italic'] = "iT4lic";
$lang['underline'] = "unD3Rl1n3";
$lang['strikethrough'] = "s+r1k3Thr0U9h";
$lang['superscript'] = "sUpEr5cR1p+";
$lang['subscript'] = "sUBScriPT";
$lang['leftalign'] = "lef+-4li9n";
$lang['center'] = "c3N+eR";
$lang['rightalign'] = "rigHT-4lI9n";
$lang['numberedlist'] = "nuMB3r3D li5T";
$lang['list'] = "l1st";
$lang['indenttext'] = "iND3N+ TeX+";
$lang['code'] = "c0D3";
$lang['quote'] = "quO+3";
$lang['spoiler'] = "sPoIleR";
$lang['horizontalrule'] = "h0RiZoN+4l rUl3";
$lang['image'] = "im4G3";
$lang['hyperlink'] = "hyp3rl1nk";
$lang['noemoticons'] = "d1548L3 3mo+iC0N5";
$lang['fontface'] = "f0NT f4C3";
$lang['size'] = "s1z3";
$lang['colour'] = "c0l0UR";
$lang['red'] = "red";
$lang['orange'] = "oR4n9E";
$lang['yellow'] = "y3lL0W";
$lang['green'] = "gREEn";
$lang['blue'] = "blUE";
$lang['indigo'] = "inD190";
$lang['violet'] = "viOL3t";
$lang['white'] = "wH1+3";
$lang['black'] = "bLacK";
$lang['grey'] = "gr3y";
$lang['pink'] = "pink";
$lang['lightgreen'] = "liGH+ 9rEen";
$lang['lightblue'] = "lI9HT bLu3";

// Forum Stats (messages.inc.php - messages_forum_stats()) -------------

$lang['forumstats'] = "f0RUM ST4+5";
$lang['usersactiveinthepasttimeperiod'] = "%s 4C+1VE 1N +he p@ST %s.";

$lang['numactiveguests'] = "<b>%s</b> 9Ue\$TS";
$lang['oneactiveguest'] = "<b>1</b> gueS+";
$lang['numactivemembers'] = "<b>%s</b> M3M83rS";
$lang['oneactivemember'] = "<b>1</b> m3mb3r";
$lang['numactiveanonymousmembers'] = "<b>%s</b> 4NOnyM0U5 MEmb3RS";
$lang['oneactiveanonymousmember'] = "<b>1</b> 4n0NyM0U\$ mEm8er";

$lang['numthreadscreated'] = "<b>%s</b> THre4DS";
$lang['onethreadcreated'] = "<b>1</b> Thr3ad";
$lang['numpostscreated'] = "<b>%s</b> P0\$+S";
$lang['onepostcreated'] = "<b>1</b> p0sT";

$lang['younormal'] = "j00";
$lang['youinvisible'] = "j00 (inV1SibLE)";
$lang['viewcompletelist'] = "view coMPl3+3 li5T";
$lang['ourmembershavemadeatotalofnumthreadsandnumposts'] = "ouR m3mbErS h@v3 M@d3 @ +OT4l 0f %s 4ND %s.";
$lang['longestthreadisthreadnamewithnumposts'] = "loNGesT ThR3ad 15 <b>%s</b> wiTH %s.";
$lang['therehavebeenxpostsmadeinthelastsixtyminutes'] = "th3r3 h4V3 BeeN <b>%s</b> Po\$+\$ m4dE 1n +H3 LA\$+ 60 mInUT3S.";
$lang['therehasbeenonepostmadeinthelastsxityminutes'] = "th3r3 H45 b3eN <b>1</b> P0sT m@De 1n +H3 lA\$t 60 M1nU+E\$.";
$lang['mostpostsevermadeinasinglesixtyminuteperiodwasnumposts'] = "mOs+ p0S+\$ 3veR M4D3 1N 4 \$iN9L3 60 MInU+3 P3r1Od 1\$ <b>%s</b> ON %s.";
$lang['wehavenumregisteredmembersandthenewestmemberismembername'] = "w3 H4V3 <b>%s</b> r3giSTer3d Mem8ers @nD The nEw3\$T mem8Er 1S <b>%s</b>.";
$lang['wehavenumregisteredmember'] = "w3 h4VE %s re91SteR3D M3m8Er\$.";
$lang['wehaveoneregisteredmember'] = "w3 H4vE 0n3 R3915Tered M3mB3r.";
$lang['mostuserseveronlinewasnumondate'] = "m05+ U5ErS 3vEr OnLin3 W@5 <b>%s</b> ON %s.";
$lang['statsdisplayenabled'] = "sta+S d1SPl@y 3N@8l3D";

// Thread Options (thread_options.php) ---------------------------------

$lang['updatesmade'] = "uPDat3s m4De";
$lang['useroptions'] = "u53r OpTi0nS";
$lang['markedasread'] = "m4RKeD 45 r34d";
$lang['postsoutof'] = "po\$Ts 0U+ Oph";
$lang['interest'] = "in+erEST";
$lang['closedforposting'] = "clO5eD foR pOST1n9";
$lang['locktitleandfolder'] = "loCK ti+LE @Nd FoLD3r";
$lang['deletepostsinthreadbyuser'] = "d3L3+3 pO5tS 1N ThrE@D 8Y u\$3r";
$lang['deletethread'] = "d3l3t3 tHR3@D";
$lang['permenantlydelete'] = "peRm3N4nTLy D3L3t3";
$lang['movetodeleteditems'] = "m0V3 tO dEL3tEd tHre4d\$";
$lang['undeletethread'] = "undELeTe +hrE4D";
$lang['threaddeletedpermenantly'] = "tHRE4d DEl3t3D p3Rman3n+ly. c4nNot UNdel3+e.";
$lang['markasunread'] = "m@rk @S unRe4D";
$lang['makethreadsticky'] = "m4k3 THr34D s+1CkY";
$lang['threareadstatusupdated'] = "tHR3@D re4d S+@+us Upd4+3D 5UCCeS5phUllY";
$lang['interestupdated'] = "tHRE4D 1nt3r3St \$T4+US UPd@+3d \$UcC3\$5FuLLy";

// Dictionary (dictionary.php) -----------------------------------------

$lang['dictionary'] = "d1c+1On@rY";
$lang['spellcheck'] = "sp3ll cHECk";
$lang['notindictionary'] = "nO+ 1N DicT1On@ry";
$lang['changeto'] = "cH4nge tO";
$lang['restartspellcheck'] = "resT4R+";
$lang['cancelchanges'] = "canc3L Ch@NGEs";
$lang['initialisingdotdotdot'] = "iNi+14LiSiNG...";
$lang['spellcheckcomplete'] = "spell Ch3Ck 1S cOmPlETe. to R3sT@R+ SP3ll chEck CLicK Re\$+4R+ 8u+tOn B3lOW.";
$lang['spellcheck'] = "sp3LL CheCk";
$lang['noformobj'] = "n0 PHOrM o8j3ct \$peCiF1Ed PHOr R3TUrn +3X+";
$lang['bodytext'] = "b0Dy T3Xt";
$lang['ignore'] = "ignOr3";
$lang['ignoreall'] = "iGnOrE 4Ll";
$lang['change'] = "ch4ng3";
$lang['changeall'] = "ch@N93 4Ll";
$lang['add'] = "adD";
$lang['suggest'] = "suGgeSt";
$lang['nosuggestions'] = "(no 5UgGEsT10N\$)";
$lang['ok'] = "ok";
$lang['cancel'] = "canceL";
$lang['dictionarynotinstalled'] = "n0 DIcTi0n4ry h4\$ bE3n 1N5t4Ll3d. pl3@5E COn+4Ct th3 pH0ruM OWn3r to R3MeDy TH1S.";

// Permissions keys ----------------------------------------------------

$lang['postreadingallowed'] = "pO\$t r34DiNG @ll0weD";
$lang['postcreationallowed'] = "p0ST CrE4+ION @Ll0W3D";
$lang['threadcreationallowed'] = "tHr3@D cR34ti0N 4llOw3d";
$lang['posteditingallowed'] = "pO\$+ Ed1T1n9 4LlOw3d";
$lang['postdeletionallowed'] = "pOst DEl3tI0n 4llOW3d";
$lang['attachmentsallowed'] = "a++4CHMeN+5 4LlOwED";
$lang['htmlpostingallowed'] = "html P05t1N9 4llOWeD";
$lang['signatureallowed'] = "sIGn4+ure 4LlOW3d";
$lang['guestaccessallowed'] = "gu3S+ 4cc3\$s @Ll0w3D";
$lang['postapprovalrequired'] = "p05t 4PpRoV4l R3quIr3D";

// RSS feeds gubbins

$lang['rssfeed'] = "rs\$ pHEEd";
$lang['every30mins'] = "eVERY 30 mInuTes";
$lang['onceanhour'] = "oNCe 4N hOur";
$lang['every6hours'] = "ev3ry 6 hOURs";
$lang['every12hours'] = "eVERy 12 hOUr5";
$lang['onceaday'] = "oNc3 4 d4y";
$lang['rssfeeds'] = "rS5 Fe3d\$";
$lang['feedname'] = "fE3d N@Me";
$lang['feedfoldername'] = "fE3d F0lDer n4Me";
$lang['feedlocation'] = "f3ED Loc4+i0n";
$lang['threadtitleprefix'] = "tHRE4d +ITle prePhIX";
$lang['feednameandlocation'] = "fe3D N4mE 4nd L0C4tI0n";
$lang['feedsettings'] = "fe3d 53T+1n95";
$lang['updatefrequency'] = "upd@+e pHReqUencY";
$lang['rssclicktoreadarticle'] = "cLicK hEr3 TO R34d +H1\$ 4rt1cl3";
$lang['addnewfeed'] = "aDd neW PHe3d";
$lang['editfeed'] = "edIt PH3ED";
$lang['feeduseraccount'] = "f33D U5Er 4Cc0un+";
$lang['noexistingfeeds'] = "n0 eX15TinG r\$\$ phEedS fOuNd. +0 4Dd 4 fEEd pLe@53 cL1CK +EH 8u+t0n b3LOW";
$lang['rssfeedhelp'] = "her3 J00 c@n SEtUp SOM3 r\$5 pH3ED\$ fOr @u+0M4Tic PRoP4g4+10N 1nTO Your FoRuM. t3H it3mS PHr0M +h3 R\$5 PH33DS j00 4dd wILL 83 cre@+eD 4s +HR34d5 WH1ch USers CaN R3Ply +0 4S If THey WeRE nOrM4L p0\$ts. Teh r5S PhEEd muS+ 83 @Cc3s51Bl3 vI4 H+tp or iT WILl n0+ WORK.";
$lang['mustspecifyrssfeedname'] = "muS+ spEc1Fy R55 Ph33D n4me";
$lang['mustspecifyrssfeeduseraccount'] = "mU5t \$PEcipHY rS5 ph3Ed U\$3r @cc0uNt";
$lang['mustspecifyrssfeedfolder'] = "mu5+ 5p3c1pHy Rs5 PHeeD Ph0Ld3R";
$lang['mustspecifyrssfeedurl'] = "mu5t \$p3C1FY rs5 PHe3D URL";
$lang['mustspecifyrssfeedupdatefrequency'] = "muS+ Sp3cIpHY rSS PhE3D upD4T3 pHreQuEnCY";
$lang['unknownrssuseraccount'] = "unKN0wn r5S UsER 4ccoUnT";
$lang['rssfeedsupportshttpurlsonly'] = "r\$s fEeD \$upp0RT5 hTtp Url\$ 0nlY. SeCuRe FE3D\$ (htTPS://) 4R3 No+ SUPp0r+3D.";
$lang['rssfeedurlformatinvalid'] = "r5S FeeD UrL ph0rM@+ iS INv4Lid. urL MUsT 1nclUD3 \$CH3Me (3.9. HtTP://) 4ND 4 HO5tn@m3 (e.g. wwW.Ho\$Tn4Me.com).";
$lang['rssfeeduserauthentication'] = "r5\$ pH3ed dO3S NO+ 5UPp0rt ht+p U5Er 4u+heNTic@+10N";
$lang['successfullyremovedselectedfeeds'] = "succes\$fUlLy R3mOVEd SEl3cTEd ph33d\$";
$lang['successfullyaddedfeed'] = "sUccE\$sphUlLy 4dd3D New ph33D";
$lang['successfullyeditedfeed'] = "sUCCe5\$fUlLY EditeD PHeEd";
$lang['failedtoremovefeeds'] = "f@ILed +0 REmoVe SOM3 0R 4Ll Of th3 \$eLEc+3D fE3D5";
$lang['failedtoaddnewrssfeed'] = "f41leD +0 4dd N3W RSS pH33d";
$lang['failedtoupdaterssfeed'] = "f41L3d T0 uPd4+e r\$5 PH3ed";
$lang['rssstreamworkingcorrectly'] = "r5\$ sTRe4m @ppe@R\$ T0 83 w0RK1n9 c0RrEC+lY";
$lang['rssstreamnotworkingcorrectly'] = "r5\$ S+Re4m w@5 EMptY 0r COuLd nOT 83 f0uNd";
$lang['invalidfeedidorfeednotfound'] = "iNV4lid feeD 1d OR ph33D n0+ FOUnd";

// PM Export Options

$lang['pmexportastype'] = "exPORt @5 TYpe";
$lang['pmexporthtml'] = "h+ml";
$lang['pmexportxml'] = "xml";
$lang['pmexportplaintext'] = "pl41N TeX+";
$lang['pmexportmessagesas'] = "exPOr+ Me\$\$4GE5 @S";
$lang['pmexportonefileforallmessages'] = "oNe PhILe phOR @LL M3\$s4ge\$";
$lang['pmexportonefilepermessage'] = "on3 PHIle p3R mESS4Ge";
$lang['pmexportattachments'] = "exPORt 4+T4Chm3ntS";
$lang['pmexportincludestyle'] = "incLuDE F0Rum 5tylE sH3Et";
$lang['pmexportwordfilter'] = "aPply W0rd phiL+ER +O m35\$4Ge5";

// Thread merge / split options

$lang['threadsplit'] = "tHRe4d H@5 beeN Spl1+";
$lang['threadmerge'] = "thRe4D H4\$ been mer9Ed";
$lang['mergesplitthread'] = "mEr93 / spLi+ +hrE4d";
$lang['mergewiththreadid'] = "m3rG3 W1th thr34D ID:";
$lang['postsinthisthreadatstart'] = "pO5TS in th1S Thr3@d 4+ st4r+";
$lang['postsinthisthreadatend'] = "pO5tS 1n +H15 +Hre4D @+ 3nd";
$lang['reorderpostsintodateorder'] = "r3-0Rd3r PO\$tS into d4t3 OrD3r";
$lang['splitthreadatpost'] = "spL1T THr34d At PoST:";
$lang['selectedpostsandrepliesonly'] = "s3lectED p0sT and r3pL1e5 0Nly";
$lang['selectedandallfollowingposts'] = "s3l3ct3d @ND 4ll F0LloWinG P0\$Ts";

$lang['threadhere'] = "hEre";
$lang['thisthreadhasmoved'] = "<b>thrE@d5 M3R9ed:</b> ThIS +hRe4D H@5 m0VEd %s";
$lang['thisthreadwasmergedfrom'] = "<b>tHre@D5 Mer9Ed:</b> th1\$ +Hre4d W@5 MER9eD frOm %s";
$lang['somepostsinthisthreadhavebeenmoved'] = "<b>thre4D sPLi+:</b> SOM3 Po\$T\$ 1n TH1S +hrE4D H4Ve 83En MOveD %s";
$lang['somepostsinthisthreadweremovedfrom'] = "<b>tHr3@d 5plIt:</b> \$0Me P05+s in +hi5 ThrE4D Wer3 M0vEd FROM %s";

$lang['invalidfunctionarguments'] = "inv4L1d PHuNc+10N 4rgUmEN+5";
$lang['couldnotretrieveforumdata'] = "c0ULD not r3Tr1evE PHOruM D4+@";
$lang['cannotmergepolls'] = "oNe OR M0R3 +hrE4d5 IS @ PoLL. J00 c4nNoT M3r93 P0LL\$";
$lang['couldnotretrievethreaddatamerge'] = "c0uLd n0+ RetR1eVe THr3@d d4+@ froM 0n3 OR M0R3 thR34d5";
$lang['couldnotretrievethreaddatasplit'] = "couLd NOt R3+rieV3 +HR34d d4+@ FR0m 50urcE THRead";
$lang['couldnotretrievepostdatamerge'] = "c0uld No+ R3+rIEve Po\$+ d4+@ fR0m 0Ne 0R M0re thrE@dS";
$lang['couldnotretrievepostdatasplit'] = "c0ULd nO+ retrI3V3 POSt d4+@ Phr0m \$OURc3 THr34d";
$lang['failedtocreatenewthreadformerge'] = "f4il3D TO cReaT3 neW THre@d pH0r M3rGE";
$lang['failedtocreatenewthreadforsplit'] = "f@1LeD t0 CR34t3 N3W +HrE4D FOR \$plI+";

// Thread subscriptions

$lang['threadsubscriptions'] = "thrE@D sU85CRiP+I0Ns";
$lang['couldnotupdateinterestonthread'] = "coUlD n0+ Upd4T3 1ntER3st On +HR34D '%s'";
$lang['threadinterestsupdatedsuccessfully'] = "thr34d 1NtER3\$+S uPD4t3D \$ucce\$spHulLy";
$lang['resetselected'] = "r3\$3T SEl3ct3D";
$lang['allthreadtypes'] = "aLl +hre4D +YPeS";
$lang['ignoredthreads'] = "i9NOREd THr34ds";
$lang['highinterestthreads'] = "hiGH IN+eREs+ +hR3@D5";
$lang['subscribedthreads'] = "suBSCri83D +HRe@d5";
$lang['currentinterest'] = "cURr3n+ in+3Re5t";

// Browseable user profiles

$lang['youcanonlyaddthreecolumns'] = "j00 c4n 0NLy 4DD 3 c0lUmn5. T0 @dd 4 N3w c0LumN cLo\$E 4n ex1sT1N9 oN3";
$lang['columnalreadyadded'] = "j00 h4ve 4LrE@DY @dded thI\$ c0lUmn. IF j00 W@n+ +O r3MovE iT cL1Ck i+'S cl053 bUT+0N";

?>