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

/* $Id: x-hacker.inc.php,v 1.300 2008-10-25 18:22:08 decoyduck Exp $ */

// British English language file

// Language character set and text direction options -------------------

$lang['_isocode'] = "en-gb";
$lang['_textdir'] = "ltr";

// Months --------------------------------------------------------------

$lang['month'][1]  = "j4nu@rY";
$lang['month'][2]  = "fE8Ru4Ry";
$lang['month'][3]  = "m@RCh";
$lang['month'][4]  = "aPR1l";
$lang['month'][5]  = "m@y";
$lang['month'][6]  = "jun3";
$lang['month'][7]  = "juLy";
$lang['month'][8]  = "aUGU\$+";
$lang['month'][9]  = "sept3mBeR";
$lang['month'][10] = "ocToBEr";
$lang['month'][11] = "noVeMB3r";
$lang['month'][12] = "dEcemb3R";

$lang['month_short'][1]  = "j4n";
$lang['month_short'][2]  = "fEB";
$lang['month_short'][3]  = "mAR";
$lang['month_short'][4]  = "apR";
$lang['month_short'][5]  = "m4y";
$lang['month_short'][6]  = "jUn";
$lang['month_short'][7]  = "jUl";
$lang['month_short'][8]  = "aug";
$lang['month_short'][9]  = "s3p";
$lang['month_short'][10] = "oCt";
$lang['month_short'][11] = "nov";
$lang['month_short'][12] = "d3c";

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

$lang['date_periods']['year']   = "%s Ye4R";
$lang['date_periods']['month']  = "%s M0N+h";
$lang['date_periods']['week']   = "%s We3K";
$lang['date_periods']['day']    = "%s d4y";
$lang['date_periods']['hour']   = "%s hOUR";
$lang['date_periods']['minute'] = "%s m1nUTE";
$lang['date_periods']['second'] = "%s SecOnd";

// As above but plurals (2 years vs. 1 year, etc.)

$lang['date_periods_plural']['year']   = "%s yE@RS";
$lang['date_periods_plural']['month']  = "%s moNTh\$";
$lang['date_periods_plural']['week']   = "%s w3EK5";
$lang['date_periods_plural']['day']    = "%s D4y\$";
$lang['date_periods_plural']['hour']   = "%s hOUR\$";
$lang['date_periods_plural']['minute'] = "%s M1NU+es";
$lang['date_periods_plural']['second'] = "%s sEc0NDs";

// Short hand periods (example: 1y, 2m, 3w, 4d, 5hr, 6min, 7sec)

$lang['date_periods_short']['year']   = "%sY";    // 1y
$lang['date_periods_short']['month']  = "%sM";    // 2m
$lang['date_periods_short']['week']   = "%sW";    // 3w
$lang['date_periods_short']['day']    = "%sD";    // 4d
$lang['date_periods_short']['hour']   = "%shr";   // 5hr
$lang['date_periods_short']['minute'] = "%sm1N";  // 6min
$lang['date_periods_short']['second'] = "%ssEc";  // 7sec

// Common words --------------------------------------------------------

$lang['percent'] = "pErC3nT";
$lang['average'] = "avER@93";
$lang['approve'] = "aPpRoV3";
$lang['banned'] = "bannEd";
$lang['locked'] = "lOcKed";
$lang['add'] = "add";
$lang['advanced'] = "aDV4nC3d";
$lang['active'] = "aC+1vE";
$lang['style'] = "stylE";
$lang['go'] = "gO";
$lang['folder'] = "f0Ld3R";
$lang['ignoredfolder'] = "iGN0red F0lDER";
$lang['subscribedfolder'] = "sUBScrI83D PHolD3r";
$lang['folders'] = "fOLDER5";
$lang['thread'] = "thrE4d";
$lang['threads'] = "thrE4D5";
$lang['threadlist'] = "tHr3@d LI\$t";
$lang['message'] = "m3ss4g3";
$lang['from'] = "fr0m";
$lang['to'] = "to";
$lang['all_caps'] = "aLl";
$lang['of'] = "oph";
$lang['reply'] = "rEPly";
$lang['forward'] = "f0RW4RD";
$lang['replyall'] = "r3PLY +0 4lL";
$lang['quickreply'] = "qU1Ck R3pLY";
$lang['quickreplyall'] = "qu1CK r3pLy +O 4Ll";
$lang['pm_reply'] = "rEpLY 4\$ PM";
$lang['delete'] = "d3l3+E";
$lang['deleted'] = "del3TEd";
$lang['edit'] = "eDI+";
$lang['export'] = "exp0r+";
$lang['privileges'] = "pR1v1l39e5";
$lang['ignore'] = "igNoRE";
$lang['normal'] = "nORM@L";
$lang['interested'] = "iN+ERE\$+Ed";
$lang['subscribe'] = "suBScRiBe";
$lang['apply'] = "aPplY";
$lang['enable'] = "eN@BLe";
$lang['download'] = "dOWnl0@D";
$lang['save'] = "saV3";
$lang['update'] = "uPd@+3";
$lang['cancel'] = "c4nC3L";
$lang['continue'] = "cOn+iNue";
$lang['attachment'] = "at+4chM3NT";
$lang['attachments'] = "a+tAChm3n+S";
$lang['imageattachments'] = "im@9e @T+4chmENT5";
$lang['filename'] = "f1L3N4Me";
$lang['dimensions'] = "d1M3N\$ION\$";
$lang['downloadedxtimes'] = "dOwNL0@ded: %d +1m3s";
$lang['downloadedonetime'] = "dOwnl0ADeD: 1 TIM3";
$lang['size'] = "siz3";
$lang['viewmessage'] = "v13w M3\$\$4g3";
$lang['deletethumbnails'] = "delE+3 +HumBn@iL5";
$lang['logon'] = "lOGON";
$lang['more'] = "m0r3";
$lang['recentvisitors'] = "reC3Nt ViSITOrS";
$lang['username'] = "u\$eRN4m3";
$lang['clear'] = "cLEAR";
$lang['reset'] = "r3s3T";
$lang['action'] = "actIoN";
$lang['unknown'] = "unknOWN";
$lang['none'] = "n0Ne";
$lang['preview'] = "pREv1eW";
$lang['post'] = "p0sT";
$lang['posts'] = "p05T\$";
$lang['change'] = "cH@n9e";
$lang['yes'] = "y3\$";
$lang['no'] = "n0";
$lang['signature'] = "s1gN4+ur3";
$lang['signaturepreview'] = "s1gN4+uR3 PREV1ew";
$lang['signatureupdated'] = "s19n4tURe UPd4TED";
$lang['signatureupdatedforallforums'] = "sI9NA+uR3 UPd4TEd FOR @LL pHORum5";
$lang['back'] = "b4cK";
$lang['subject'] = "sUBJEc+";
$lang['close'] = "cLos3";
$lang['name'] = "n4m3";
$lang['description'] = "de5Cr1p+ION";
$lang['date'] = "daT3";
$lang['view'] = "vIEW";
$lang['enterpasswd'] = "eNtER P@SSwoRD";
$lang['passwd'] = "p@s\$woRd";
$lang['ignored'] = "i9noR3D";
$lang['guest'] = "gU3s+";
$lang['next'] = "nEXt";
$lang['prev'] = "pREV10u\$";
$lang['others'] = "otH3r5";
$lang['nickname'] = "n1CkN@ME";
$lang['emailaddress'] = "em@1l 4ddrE\$\$";
$lang['confirm'] = "coNpH1rM";
$lang['email'] = "em41l";
$lang['poll'] = "polL";
$lang['friend'] = "fri3ND";
$lang['success'] = "sucC3\$S";
$lang['error'] = "erR0R";
$lang['warning'] = "wArN1nG";
$lang['guesterror'] = "s0rRy, J00 N3ED +0 83 L0gGed IN +0 uS3 tHis phEa+uRE.";
$lang['loginnow'] = "l09IN NOW";
$lang['unread'] = "unr34D";
$lang['all'] = "all";
$lang['allcaps'] = "aLl";
$lang['permissions'] = "p3Rmi5Sion\$";
$lang['type'] = "tYPE";
$lang['print'] = "prInT";
$lang['sticky'] = "stICky";
$lang['polls'] = "polLS";
$lang['user'] = "uSEr";
$lang['enabled'] = "eN4BL3D";
$lang['disabled'] = "d15@bLEd";
$lang['options'] = "op+1ON5";
$lang['emoticons'] = "em0T1c0n\$";
$lang['webtag'] = "w38+@9";
$lang['makedefault'] = "mAkE dEf4ulT";
$lang['unsetdefault'] = "un\$eT depH4UlT";
$lang['rename'] = "r3nam3";
$lang['pages'] = "p@9ES";
$lang['used'] = "u53D";
$lang['days'] = "d4Y\$";
$lang['usage'] = "us@9E";
$lang['show'] = "sH0w";
$lang['hint'] = "hINt";
$lang['new'] = "n3W";
$lang['referer'] = "rEfEr3R";
$lang['thefollowingerrorswereencountered'] = "tEh FOLLoW1Ng 3RroRs weR3 eNCOUnT3R3d:";

// Admin interface (admin*.php) ----------------------------------------

$lang['admintools'] = "adMin +OOL5";
$lang['forummanagement'] = "f0ruM M@n4gEM3nT";
$lang['accessdeniedexp'] = "j00 do N0t H@VE pERM15\$Ion +0 U53 THIs \$ecT10N.";
$lang['managefolder'] = "m@N493 f0lD3r";
$lang['managefolders'] = "m4n493 fOLd3R\$";
$lang['manageforums'] = "m@N@G3 F0rUM\$";
$lang['manageforumpermissions'] = "m4naG3 F0rum peRm1\$sI0ns";
$lang['foldername'] = "folD3r naM3";
$lang['move'] = "moVe";
$lang['closed'] = "cl0\$3d";
$lang['open'] = "oPEn";
$lang['restricted'] = "r3s+R1CT3d";
$lang['forumiscurrentlyclosed'] = "%s 1s CURRen+ly CLOS3D";
$lang['youdonothaveaccesstoforum'] = "j00 DO n0+ h4Ve @ccE\$\$ +O %s. %s";
$lang['toapplyforaccessplease'] = "tO 4pPLY F0r 4cce5\$ pL34\$3 coNt4c+ +3h %s.";
$lang['forumowner'] = "f0rum OWN3r";
$lang['adminforumclosedtip'] = "if j00 w4nT T0 CH4ng3 SomE S3ttIN9\$ ON Y0uR PHORUm CLICk TEh 4dM1n LINk iN tH3 n@V1g@TI0N B@r 4BOV3.";
$lang['newfolder'] = "new F0lD3R";
$lang['nofoldersfound'] = "no 3X1St1N9 Fold3rS F0UnD. +0 Add 4 F0lD3r CliCK TEh '@DD New' 8uT+0n BeLoW.";
$lang['forumadmin'] = "fOrUm 4DMIN";
$lang['adminexp_1'] = "use THE m3nU 0n +H3 l3fT +O MAN@9e +H1N9s 1n Y0uR f0rUM.";
$lang['adminexp_2'] = "<b>useR\$</b> 4lL0WS J00 +0 53t 1nDIVIdU@L u\$ER PErMi\$\$ION5, 1NCLuDiN9 4pP01ntin9 m0D3r4t0r\$ @ND 94G91N9 P3OpL3.";
$lang['adminexp_3'] = "<b>u\$ER Gr0UPS</b> aLLOW\$ J00 +O cRE@+3 US3r gr0uP\$ TO @\$S19n P3rmiS\$ion\$ t0 4\$ M4Ny or @S PhEW U53r5 Qu1CKly 4nd 34\$ily.";
$lang['adminexp_4'] = "<b>b@N c0Ntrols</b> 4Ll0w5 +eh b@nnIN9 @ND UN-b@NN1nG 0pH IP 4DDRe5\$3s, H+TP rEf3RErs, U\$3RnAM3\$, em@Il @DDr3s\$Es 4ND niCKNam3s.";
$lang['adminexp_5'] = "<b>fOldERS</b> 4llOwS Th3 CR3@+1oN, MOdiFIc@tIOn 4ND D3l3+ion 0PH F0lD3Rs.";
$lang['adminexp_6'] = "<b>r5s F33ds</b> AllOW5 J00 t0 M4N4g3 R5S PHEeDS Ph0R pr0p494+IOn int0 Y0Ur F0rum.";
$lang['adminexp_7'] = "<b>pr0pHILE\$</b> l3Ts j00 cuSTOmIS3 TH3 IT3m5 TH@+ 4PP34R 1N TH3 U\$3R pr0pH1le\$.";
$lang['adminexp_8'] = "<b>f0ruM set+1nGS</b> 4Ll0Ws J00 tO Cu\$+OMISE y0ur PHOruM'\$ N4mE, 4Pp34r4nc3 4nD M4nY 0thER +H1ngs.";
$lang['adminexp_9'] = "<b>s+4rT p@g3</b> lE+5 j00 CU\$+om1\$3 YOUr pHORum'\$ S+@RT p4g3.";
$lang['adminexp_10'] = "<b>f0Rum s+yLe</b> 4lL0wS J00 +o 9EN3R@+3 RanD0m s+yLes PHOR yOUR FoRum MEmBeRs t0 Use.";
$lang['adminexp_11'] = "<b>w0rD fiLTer</b> aLlOW\$ j00 TO Ph1lt3r WorD\$ J00 D0n't W@N+ +O 83 U\$3d ON YOur ph0rUm.";
$lang['adminexp_12'] = "<b>pOs+INg \$+@T5</b> g3N3R@+3s 4 R3p0r+ li\$+1nG thE T0p 10 POS+Er\$ 1n 4 D3fINeD PeRIOd.";
$lang['adminexp_13'] = "<b>f0ruM Link5</b> lET\$ j00 M@n@93 TH3 LINk\$ DROPDoWn 1N THE navig@tION 8@R.";
$lang['adminexp_14'] = "<b>view L09</b> l1\$+\$ r3C3nt AC+1OnS bY TH3 F0RUM M0Der4+oRS.";
$lang['adminexp_15'] = "<b>mAN4G3 F0rUMS</b> l3tS J00 CRE@Te @Nd D3LeT3 AND Cl0s3 Or r3oPEN foRumS.";
$lang['adminexp_16'] = "<b>gLo8@L f0RUm S3T+1nGS</b> 4LL0Ws j00 TO MoDIphY S3+tiNGS whIch 4FPHecT ALl ForUms.";
$lang['adminexp_17'] = "<b>p0S+ 4pPR0V4L qu3uE</b> @LL0W\$ J00 T0 vI3W 4nY POSts 4W@1Tin9 AppR0V4l by 4 m0d3r4+Or.";
$lang['adminexp_18'] = "<b>v1S1+OR Lo9</b> 4Llows J00 TO V1EW 4N EX+3ND3d L1\$t 0PH v1sIt0R\$ INclUd1n9 +HEiR ht+P r3f3rErs.";
$lang['createforumstyle'] = "cRE4t3 A PHORUM 5+yL3";
$lang['newstylesuccessfullycreated'] = "n3w 5+Yl3 5uCcE\$\$phULLY Cr34Ted.";
$lang['stylealreadyexists'] = "a 5+YLE w1TH ThaT Phil3n4m3 4lre@dY ExIs+\$.";
$lang['stylenofilename'] = "j00 D1D N0T 3nTER 4 Filen4ME +O s4vE tH3 STYL3 WI+h.";
$lang['stylenodatasubmitted'] = "coulD N0+ RE@D forUm \$+yL3 D4t4.";
$lang['stylecontrols'] = "c0N+Rol\$";
$lang['stylecolourexp'] = "cl1CK on @ cOl0ur +o M@K3 4 New 5+YL3 SHe3T 84\$3D ON tH4+ Col0uR. cURR3NT B4\$e C0L0UR I\$ FIrsT In L1s+.";
$lang['standardstyle'] = "s+4nd4rd s+YL3";
$lang['rotelementstyle'] = "rotAT3D El3MEnt \$+yl3";
$lang['randstyle'] = "r4nD0m \$+YL3";
$lang['thiscolour'] = "thI\$ coL0uR";
$lang['enterhexcolour'] = "or 3n+3r a H3x C0L0Ur to 84\$e @ N3W STYlE \$HE3T 0n";
$lang['savestyle'] = "sav3 +H1s \$+YL3";
$lang['styledesc'] = "s+yl3 D3\$criPtiON";
$lang['stylefilenamemayonlycontain'] = "s+YL3 FILen@Me M4Y 0nLY cON+@1N L0W3rC@S3 Let+3Rs (@-z), nUmB3rS (0-9) @Nd unDer\$CORe.";
$lang['stylepreview'] = "sTYl3 PR3v13w";
$lang['welcome'] = "w3lC0me";
$lang['messagepreview'] = "m35\$4g3 PR3vI3W";
$lang['users'] = "usErS";
$lang['usergroups'] = "u53R groupS";
$lang['mustentergroupname'] = "j00 MU\$+ ENteR 4 9r0uP N@Me";
$lang['profiles'] = "pROFIles";
$lang['manageforums'] = "m@nAge F0rUM5";
$lang['forumsettings'] = "foRUM 53tt1nG\$";
$lang['globalforumsettings'] = "gl084L fORUM sE++ing\$";
$lang['settingsaffectallforumswarning'] = "<b>nOTe:</b> +h3S3 \$3+TIn9S @Ff3c+ 4LL f0RUm5. Wh3RE tHe SE++1Ng I\$ DuPlic@TeD 0N +H3 INDividUAL f0rUM'5 S3tTIN9s P4gE tHAT w1lL +4ke preC3d3nC3 0V3r Teh S3+T1nGS j00 ch4nG3 hErE.";
$lang['startpage'] = "s+4R+ pAG3";
$lang['startpageerror'] = "yOuR \$+@RT p4G3 C0uld nOT 8e s4vEd LOC4lLY T0 TH3 S3rVEr 83c4U53 P3RM1\$\$1oN w4S dEnIeD.</p><p>t0 Ch4n93 yOUr 5+Art P4g3 PL3aSE cL1cK ThE d0wnl04d 8uTT0n 83l0w WHICH W1LL PR0Mp+ J00 +0 s4vE +h3 PHIle T0 y0ur H4rD DriV3. J00 CAN Th3N UPlo4d thI\$ pH1L3 +O YoUR s3rVER 1nT0 T3H F0Ll0w1nG PHOLD3R, IpH N3c3\$\$@Ry CR3@+1N9 +h3 pH0Lder s+rUC+uR3 in +h3 PR0c3\$s.</p><p><b>%s</b></p><p>plE4\$3 n0+3 tH4T somE BR0W53R\$ m4Y cH4ng3 +He nAME OpH T3h PHiLe UP0N DOwNl04d. Wh3N UpLo4DiN9 +hE Ph1L3 pl3@s3 M4Ke surE +h@t i+ Is n4M3D S+4R+_m4In.pHP 0THERw153 yOuR \$+@rT PaGE WIlL @pPE4R UNCH@nGED.";
$lang['uploadcssfile'] = "upl0aD C\$\$ 5tYle sh33T";
$lang['uploadcssfilefailed'] = "y0UR CS\$ \$+yLe \$hEE+ C0uLD NOT 83 UpLO4d3d T0 t3h sErV3r b3c4Us3 PERM1ssiON WA5 DEni3d.</p><p>t0 CHANG3 Y0ur S+@RT p4g3 c5\$ \$+yL3 she3+ PL3@\$e ensURe +EH FOLLOWinG F0lDErs 3x15+ 4ND 4r3 Wr1T48LE: </p><p><b>%s</b></p>";
$lang['invalidfiletypeerror'] = "iNv4l1d FILE +YPE, j00 C4n 0Nly UPLO4D CS\$ s+ylE sHEEt FILes";
$lang['failedtoopenmasterstylesheet'] = "y0ur PH0rum s+yL3 c0ULd NO+ 83 s@VEd 83c4us3 tH3 m4\$+er 5+yL3 sHe3T CoULd N0+ 83 L04d3d. +0 \$aV3 YOur 5+YLe Teh m4s+er \$+yLE SH3ET (m4kE_\$TYL3.CS\$) muS+ bE loC@tED In TH3 \$+YL3s DirEct0ry OF y0uR b33H1V3 F0rUM inS+4LL4T1on.";
$lang['makestyleerror'] = "y0uR f0rum sTYL3 COuld NO+ b3 5@Ved l0calLY +o T3h SERV3R 8eC@u\$3 P3rMi\$\$10n W@S DeNieD.</p><p>t0 s@v3 YOUr F0RUM 5+yle PLe4SE Cl1CK TH3 DOwnlo4d 8UTt0N 83l0w WHIch W1lL PR0mP+ J00 T0 5@vE +h3 PH1l3 t0 Your h4rd DRivE. J00 cAN TH3n Uplo4d +his FIL3 +0 y0ur \$3RvER 1n+O tHE PHOlL0w1NG PHOLD3r, IPH N3cE\$5@RY CRE4t1Ng +3h F0lD3r stRUctUR3 1N +H3 prOCe\$S.</p><p><b>%s</b></p><p>pl3@\$3 n0+3 tH4+ S0mE br0ws3R5 m@y ch4NG3 tH3 n4M3 oPH +H3 fIL3 up0N D0Wnl0@D. WHEN upl0@D1N9 +HE FILe plE@\$e M4k3 \$Ure th4+ 1t 1\$ n4M3D \$+YLe.cS\$ oThErW1SE +h3 Ph0RUM \$+yL3 WILL 83 Un4Va1l@8LE.";
$lang['forumstyle'] = "f0rUm 5+YLE";
$lang['wordfilter'] = "w0rd FILTeR";
$lang['forumlinks'] = "fORUM L1nkS";
$lang['viewlog'] = "viEw L09";
$lang['noprofilesectionspecified'] = "n0 Pr0pH1L3 S3c+1On sp3cIPH1ED.";
$lang['itemname'] = "it3m Nam3";
$lang['moveto'] = "m0Ve +O";
$lang['manageprofilesections'] = "m4n49e pR0PH1lE 53C+10NS";
$lang['sectionname'] = "sectI0n n4ME";
$lang['items'] = "i+eMS";
$lang['mustspecifyaprofilesectionid'] = "mU\$t \$p3ciphY a PR0PHIL3 SECt1ON 1D";
$lang['mustsepecifyaprofilesectionname'] = "mU5+ SP3CiPHy @ PROFil3 53C+10n NAM3";
$lang['noprofilesectionsfound'] = "n0 EXI\$+1ng PR0F1LE 53c+1oNS FOunD. t0 4DD 4 Pr0fil3 \$3C+ion CL1CK +3H '4dD n3w' 8u++on 83loW.";
$lang['addnewprofilesection'] = "aDd neW PropH1l3 53ctION";
$lang['successfullyaddedprofilesection'] = "sUCc3SSFUllY 4Dd3d PR0ph1L3 53cTION";
$lang['successfullyeditedprofilesection'] = "suCCe\$\$phULLY 3dI+3d pR0PH1l3 53c+ION";
$lang['addnewprofilesection'] = "aDD N3w pr0pHIl3 s3c+IOn";
$lang['mustsepecifyaprofilesectionname'] = "mU\$t 5P3CIPHY a pR0Ph1l3 53c+1oN N@Me";
$lang['successfullyremovedselectedprofilesections'] = "succEsSpHULly reMOVeD \$3LEcTEd pR0PH1le S3c+iON\$";
$lang['failedtoremoveprofilesections'] = "faiLEd t0 rEmOVE Pr0PH1L3 \$3CTioN5";
$lang['viewitems'] = "vIEW 1tEmS";
$lang['successfullyaddednewprofileitem'] = "succ3S5PhUlly @DD3d NEw PROF1lE iteM";
$lang['successfullyeditedprofileitem'] = "sUCc3\$SFULly eDi+ED pr0pHilE 1+Em";
$lang['successfullyremovedselectedprofileitems'] = "suCC3S\$PHuLlY R3mOVED 5EL3C+3D PROf1L3 1+EMS";
$lang['failedtoremoveprofileitems'] = "f4ileD +O R3mOV3 PRof1LE 1T3Ms";
$lang['noexistingprofileitemsfound'] = "tH3rE 4rE N0 3x1s+1ng PR0pHIl3 1t3mS IN Thi\$ SEc+i0n. +o 4DD 4N 1T3M ClICk +hE '4Dd New' 8uT+0N b3LOw.";
$lang['edititem'] = "edI+ 1+3m";
$lang['invalidprofilesectionid'] = "iNV4liD PR0ph1l3 53ct1on 1d 0R \$ECT1On N0t f0UNd";
$lang['invalidprofileitemid'] = "inv@LiD pRof1l3 1TEm 1d or I+3m not Ph0unD";
$lang['addnewitem'] = "adD N3w 1t3m";
$lang['youmustenteraprofileitemname'] = "j00 MUs+ 3NT3r 4 PROfil3 ItEm N4m3";
$lang['invalidprofileitemtype'] = "invaL1d PROPH1L3 I+3M +YP3 \$3l3cT3D";
$lang['youmustenteroptionsforselectedprofileitemtype'] = "j00 MUS+ 3NTER \$0mE 0PT1On\$ pH0R 5elEcT3d PRoFIL3 1Tem +yp3";
$lang['youmustentermorethanoneoptionforitem'] = "j00 MU\$+ 3nT3r MORE TH@n 0Ne OPtI0n F0r \$3leCtED pr0philE 1TEM tYP3";
$lang['profileitemhyperlinkssupportshttpurlsonly'] = "pROF1l3 1+3M HYPErlinks SUPP0R+ H++P uRl\$ ONly";
$lang['profileitemhyperlinkformatinvalid'] = "pr0F1L3 1+3m HYperl1NK ph0rm@+ 1NV4l1d";
$lang['youmustincludeprofileentryinhyperlinks'] = "j00 Mu5+ 1NCLUde <i>%s</i> 1n +h3 Url 0f Cl1CK@8L3 HYP3RLINKs";
$lang['failedtocreatenewprofileitem'] = "f41L3d T0 Cre@TE nEW PROph1l3 1+3m";
$lang['failedtoupdateprofileitem'] = "f@1L3d +o uPd4+E pR0PH1l3 1+3M";
$lang['startpageupdated'] = "st@rT P4G3 UPD@tED. %s";
$lang['cssfileuploaded'] = "cS5 \$+YLe she3+ upL0aDeD. %s";
$lang['viewupdatedstartpage'] = "v13W UPD4TED 5+@rT PAG3";
$lang['editstartpage'] = "eD1+ \$+@RT P4g3";
$lang['nouserspecified'] = "nO US3r \$p3C1fI3d.";
$lang['manageuser'] = "mana93 us3R";
$lang['manageusers'] = "m4N4G3 US3rs";
$lang['userstatusforforum'] = "u53r 5+@+u5 PH0r %s";
$lang['userdetails'] = "u53r D3t4iLS";
$lang['edituserdetails'] = "ed1+ U\$3R dEt4iL5";
$lang['warning_caps'] = "w4RniN9";
$lang['userdeleteallpostswarning'] = "ar3 j00 sURE J00 W@N+ +O d3l3+3 AlL 0ph +HE S3l3CTeD US3r'S P0sTs? ONc3 tEh POSTS 4rE Del3t3D +hEy C@NN0T 83 r3tRI3v3d 4nd w1lL 83 los+ F0r3vER.";
$lang['folderaccess'] = "fOlD3r 4CCESS";
$lang['possiblealiases'] = "pOs\$ibl3 4li45es";
$lang['ipaddressmatches'] = "ip 4ddR3\$\$ m4tcHES";
$lang['emailaddressmatches'] = "em@1l 4ddr3s\$ M4+CH3S";
$lang['passwdmatches'] = "p4\$Sw0RD m4+CH3s";
$lang['httpreferermatches'] = "ht+P reF3rER M@TcH3s";
$lang['userhistory'] = "u53R H1s+ory";
$lang['nohistory'] = "n0 H1S+orY reC0rDS \$aV3D";
$lang['userhistorychanges'] = "ch@n9ES";
$lang['clearuserhistory'] = "cle4r uSer HI\$torY";
$lang['changedlogonfromto'] = "cH@nGEd lOG0n Phr0m %s T0 %s";
$lang['changednicknamefromto'] = "cH4N9ed nIckNam3 FROm %s +O %s";
$lang['changedemailfromto'] = "cHaN93D 3m4IL FRom %s +0 %s";
$lang['successfullycleareduserhistory'] = "sucC3S\$PHULLy CL34r3D us3r hi5+ORY";
$lang['failedtoclearuserhistory'] = "f4iLED +0 CL3@R U\$er h15+OrY";
$lang['successfullychangedpassword'] = "sucCes\$pHUlly cHaN93d P4s5woRd";
$lang['failedtochangepasswd'] = "f41LeD t0 CH4NGe p4sSwORd";
$lang['approveuser'] = "aPPROv3 U\$3r";
$lang['viewuserhistory'] = "v1eW U5ER HIs+oRY";
$lang['viewuseraliases'] = "v13W US3r 4l1@\$3S";
$lang['searchreturnednoresults'] = "s34RCh Re+URN3d No r3SUlT\$";
$lang['deleteposts'] = "d3lETE pOST5";
$lang['deleteuser'] = "d3LET3 USER";
$lang['alsodeleteusercontent'] = "alS0 dElE+3 4lL 0pH +HE C0nTEN+ cR34+3d By +His USER";
$lang['userdeletewarning'] = "ar3 J00 SuRe J00 W@NT +O d3lE+e +H3 53lEC+3d usEr 4CCOun+? 0NCE tEH @Cc0un+ H4S BEEN DeLE+ED 1+ c4NN0t 83 RETri3vED 4ND w1lL 83 loS+ Phorev3r.";
$lang['usersuccessfullydeleted'] = "user 5UCcEsSPHULly dEl3teD";
$lang['failedtodeleteuser'] = "faIlED T0 D3Let3 USEr";
$lang['forgottenpassworddesc'] = "ipH +HiS User H4s pH0R90+T3n TH31r P@\$sWORd j00 C4n Re5eT It pHOR +Hem H3R3.";
$lang['failedtoupdateuserstatus'] = "fA1l3d +0 UPD4+E u\$er S+4+US";
$lang['failedtoupdateglobaluserpermissions'] = "f4ILED t0 UPd@+3 GL08aL UsER PerMI\$S10N5";
$lang['failedtoupdatefolderaccesssettings'] = "f41L3D +0 Upd4tE phOLDEr 4Cc3SS \$ET+1N95";
$lang['manageusersexp'] = "tH1s lI\$+ 5HOwS a \$3lecTiON 0F US3rS WHO havE l099eD 0N T0 YOUR pHORum, Sor+3d 8Y %s. T0 4lTER 4 UseR's P3Rm1s\$ion5 cl1CK TH31r N4mE.";
$lang['userfilter'] = "u\$Er FIl+Er";
$lang['withselected'] = "w1+h \$3L3CT3D";
$lang['onlineusers'] = "oNliNE u53RS";
$lang['offlineusers'] = "oFfL1ne U\$ER5";
$lang['usersawaitingapproval'] = "u53rs 4w@1tIN9 4pPr0v4l";
$lang['bannedusers'] = "b@nN3D U\$3rS";
$lang['lastlogon'] = "l@S+ l090n";
$lang['sessionreferer'] = "s3\$\$Ion REf3REr";
$lang['signupreferer'] = "s1Gn-up R3pH3rER:";
$lang['nouseraccountsmatchingfilter'] = "no u53r 4CCOun+S M4+Ching ph1LTer";
$lang['searchforusernotinlist'] = "se4RCH foR @ U\$3R Not in LIS+";
$lang['adminaccesslog'] = "aDmIn 4cC3s\$ L09";
$lang['adminlogexp'] = "thiS L1\$+ SHOW5 thE L4\$+ 4c+IONs 5@Nc+iONeD 8y US3R5 w1+H 4dMIN pRIVilEg35.";
$lang['datetime'] = "d4TE/T1mE";
$lang['unknownuser'] = "unkN0wn U\$3r";
$lang['unknownuseraccount'] = "uNkN0WN uSER 4ccOunt";
$lang['unknownfolder'] = "uNkNOWN phold3r";
$lang['ip'] = "ip";
$lang['lastipaddress'] = "l4s+ ip 4dDr3S\$";
$lang['hostname'] = "hos+N@ME";
$lang['unknownhostname'] = "unkNoWN hoS+N4M3";
$lang['logged'] = "l0ggEd";
$lang['notlogged'] = "nO+ L0g9eD";
$lang['addwordfilter'] = "adD w0Rd Ph1lT3R";
$lang['addnewwordfilter'] = "add NEW W0RD PH1L+3r";
$lang['wordfilterupdated'] = "w0rD PHIL+eR UpD4+3d";
$lang['wordfilterisfull'] = "j00 CanNOT 4Dd 4NY m0R3 W0rd ph1L+3r5. R3mOVE sOME uNu53d 0Ne\$ 0r 3d1t thE 3X1\$+1Ng 0NE5 Ph1RS+.";
$lang['filtername'] = "f1l+ER N4mE";
$lang['filtertype'] = "f1l+3r TYP3";
$lang['filterenabled'] = "f1lTER EN@BLeD";
$lang['editwordfilter'] = "ed1+ WORd fILT3R";
$lang['nowordfilterentriesfound'] = "nO 3X1\$+iN9 woRD Ph1L+3r 3nTRI3s PH0UND. +O 4Dd @ pH1l+3R cLICk +3H '4Dd new' 8UtT0N 8eL0W.";
$lang['mustspecifyfiltername'] = "j00 mU\$+ 5p3CiPhY 4 f1L+3r n4Me";
$lang['mustspecifymatchedtext'] = "j00 MuS+ \$p3CIPHY M@tCh3d +3xT";
$lang['mustspecifyfilteroption'] = "j00 mU\$+ 5pEC1Fy 4 pH1L+3r OP+1oN";
$lang['mustspecifyfilterid'] = "j00 MU\$T \$P3ciPHY @ FIltER 1D";
$lang['invalidfilterid'] = "iNv4lId ph1Lter 1D";
$lang['failedtoupdatewordfilter'] = "faiLeD T0 upd4+3 W0rd pHIL+3r. Ch3ck TH@+ TH3 FILTeR S+1lL ExiStS.";
$lang['allow'] = "aLlOW";
$lang['block'] = "bloCK";
$lang['normalthreadsonly'] = "n0RM@l +HRE4ds 0Nly";
$lang['pollthreadsonly'] = "p0ll +hrE4DS ONLY";
$lang['both'] = "b0th +Hre@d +YP3s";
$lang['existingpermissions'] = "eX1\$+1N9 PermiSsION5";
$lang['nousershavebeengrantedpermission'] = "n0 3XiS+INg uSerS PERmi\$\$10nS F0UnD. +O gr4N+ P3rMIS\$10N TO u\$3r\$ S34Rch f0R +heM b3Low.";
$lang['successfullyaddedpermissionsforselectedusers'] = "sucCes\$PhULLy 4dDeD P3rmIS510NS PH0R \$3LEcT3D US3rS";
$lang['successfullyremovedpermissionsfromselectedusers'] = "sUCCeS5PHully rEMOveD pERMi\$\$1oN\$ FR0m \$3LEctED USErs";
$lang['failedtoaddpermissionsforuser'] = "f41l3d +0 ADd PermIS\$iON5 F0r us3R '%s'";
$lang['failedtoremovepermissionsfromuser'] = "f4iLEd t0 RemOVe P3rM1\$siON5 Phr0m US3R '%s'";
$lang['searchforuser'] = "s34RcH phoR uSER";
$lang['browsernegotiation'] = "br0w\$3R n390+14+Ed";
$lang['textfield'] = "t3xt fiELd";
$lang['multilinetextfield'] = "mUltI-lin3 +3xt FieLD";
$lang['radiobuttons'] = "rADio Butt0ns";
$lang['dropdownlist'] = "dROP DOWN liST";
$lang['clickablehyperlink'] = "cl1CK@bLE HYpErL1Nk";
$lang['threadcount'] = "thre4d C0Un+";
$lang['clicktoeditfolder'] = "cL1Ck +0 ED1t pHOLD3r";
$lang['fieldtypeexample1'] = "to CR34tE r4dIo buTT0N\$ Or 4 Dr0P dowN L1s+ j00 n33D +O 3nT3r e@cH Ind1VIDu4L v4lUE oN 4 S3P@r4TE LIN3 iN THE OP+I0n5 ph13LD.";
$lang['fieldtypeexample2'] = "tO crE4+3 Cl1CK@8lE L1nKs En+3R TEH URl 1N +3H 0ptION5 pH13Ld 4Nd USE <i>%1\$5</i> wH3rE tEH 3NTRY PHROm +3h U53R'S pr0pH1l3 5hOuLd @pPE4r. 3X4mpL3\$: <p>mY\$P4cE: <i>hTtP://WWW.MYSP4cE.cOM/%1\$S</i><br />x8Ox l1vE: <i>httP://PR0filE.MYG4M3RcArD.n3+/%1\$\$</i></p>";
$lang['editedwordfilter'] = "edI+eD W0RD PH1L+ER";
$lang['editedforumsettings'] = "eDItEd FORum \$eT+1nGS";
$lang['successfullyendedusersessionsforselectedusers'] = "sucCE\$\$pHULLY eNDeD s3Ssi0NS PhOr \$ELEC+3D US3R5";
$lang['failedtoendsessionforuser'] = "f4iL3d +o 3ND S3\$\$ioN f0R us3r %s";
$lang['successfullyapproveduser'] = "succe\$SPHullY APProVED uSER";
$lang['successfullyapprovedselectedusers'] = "suCCe\$\$PHUlly 4PPROvED 53l3cTEd US3rs";
$lang['matchedtext'] = "mA+ChED +EXt";
$lang['replacementtext'] = "r3pl4cEM3Nt TEx+";
$lang['preg'] = "pRe9";
$lang['wholeword'] = "wh0lE worD";
$lang['word_filter_help_1'] = "<b>all</b> M4+cH3S 4g41NS+ th3 WH0lE +3xT S0 F1LtER1N9 M0M T0 MUM wiLL 4l\$o CH@n9e MOMen+ +0 MUMEn+.";
$lang['word_filter_help_2'] = "<b>wH0LE wORD</b> MATchE\$ 4g@IN5T WH0lE W0RD\$ oNLY \$O pH1LTEr1NG mom t0 Mum WIll NOt ChaN9e moMENt +o MUmEnt.";
$lang['word_filter_help_3'] = "<b>pre9</b> 4ll0w\$ j00 +0 us3 p3RL RegUL@R EXpRe5\$i0n5 T0 M4TCH t3xt.";
$lang['nameanddesc'] = "n4m3 4nd d3sCR1p+1on";
$lang['movethreads'] = "m0V3 tHR34dS";
$lang['movethreadstofolder'] = "mOV3 +HRe@DS t0 F0Ld3R";
$lang['failedtomovethreads'] = "f4il3D +0 m0vE THR34dS +o 5p3ciPHIeD pHOLD3r";
$lang['resetuserpermissions'] = "r3\$3+ U53R P3rM1\$\$i0nS";
$lang['failedtoresetuserpermissions'] = "f@1l3d tO R3sET US3r P3rMi5siOn5";
$lang['allowfoldertocontain'] = "alLow PHOLd3R +o c0Nt4in";
$lang['addnewfolder'] = "aDD NEw pHOLd3R";
$lang['mustenterfoldername'] = "j00 mu5+ 3nt3r 4 PHOLD3R N4M3";
$lang['nofolderidspecified'] = "n0 f0lDer ID spEc1FIED";
$lang['invalidfolderid'] = "iNv@lID phOLD3R Id. chEck +h4t 4 pHoLd3R W1+H thI\$ ID Exi\$+S!";
$lang['folderdisplayorderthreadsbyfolderview'] = "f0lD3R oRd3R ONLY 4PPL1Es Wh3N us3r H4\$ eN@blED '5oR+ thR3@D L1\$+ BY FolD3R\$' IN FORum OP+Ion\$.";
$lang['successfullyaddednewfolder'] = "sUCc3sSPHulLY 4Dd3d New PHolDer";
$lang['successfullyremovedselectedfolders'] = "succEs\$pHulLY REMovEd 53LEcTEd FOLd3R5";
$lang['successfullyeditedfolder'] = "sucCe\$\$PhUlly 3D1+3d F0lDer";
$lang['failedtocreatenewfolder'] = "fA1L3d +0 CreA+E n3w F0lD3r";
$lang['failedtodeletefolder'] = "faiLED T0 DElETe f0ld3r.";
$lang['failedtoupdatefolder'] = "f@1l3d +0 upD4tE PHOLd3R";
$lang['cannotdeletefolderwiththreads'] = "canNOT DelE+e F0LDers THa+ ST1LL c0NT@1n THR34dS.";
$lang['forumisnotsettorestrictedmode'] = "forum I\$ n0+ S3t +0 re5rICt3D m0D3. do J00 W4Nt +o En48lE 1+ NOW?";
$lang['forumisnotsettopasswordprotectedmode'] = "f0RUM 1\$ n0+ s3t TO P@s\$woRd PR0teCTEd MOD3. Do J00 w@nT +o EN48lE i+ Now?";
$lang['groups'] = "gR0uP5";
$lang['nousergroups'] = "n0 u\$3R GR0uPS h@Ve BE3N \$3+ UP. +0 4dD 4 9r0uP cL1CK +H3 '4DD nEw' Bu+T0N 8eL0W.";
$lang['suppliedgidisnotausergroup'] = "sUPPL1ED GiD 1\$ N0T 4 U53R 9R0uP";
$lang['manageusergroups'] = "m4n4G3 USEr gr0UP5";
$lang['groupstatus'] = "gR0uP S+4+us";
$lang['addusergroup'] = "aDD u53r 9r0up";
$lang['addemptygroup'] = "add 3mpTY 9R0up";
$lang['adduserstogroup'] = "aDd U\$3R\$ t0 GRouP";
$lang['addremoveusers'] = "add/R3m0vE U\$3RS";
$lang['nousersingroup'] = "th3rE @rE NO US3rS 1n This 9r0up. 4dD uSER\$ T0 THIS 9ROUP bY sE4rchiNG f0r THEm b3L0W.";
$lang['groupaddedaddnewuser'] = "sUcCE5\$fUlLY 4dDeD 9r0uP. 4DD USER5 T0 tH1\$ 9R0uP 8y 53@RCH1N9 fOR +H3M BeL0W.";
$lang['nousersingroupaddusers'] = "th3RE @rE N0 u\$3Rs 1N this 9r0UP. to 4dD U53R\$ CLIcK Th3 '4Dd/R3m0v3 usERs' bUtT0N 83l0W.";
$lang['useringroups'] = "tHI\$ u53r 1S A MEmBer 0Ph T3h PHoll0w1n9 GROUp\$";
$lang['usernotinanygroups'] = "thi\$ u53r 1\$ n0+ 1N @ny U53R 9ROUPS";
$lang['usergroupwarning'] = "nOTE: tHIS U\$3R MAY BE 1NHer1t1n9 4dDI+10N4l PerM1\$5ION\$ phR0m ANy US3r GROUps li5+3d 8eLOW.";
$lang['successfullyaddedgroup'] = "suCCeS\$pHUllY 4DDEd 9r0uP";
$lang['successfullyeditedgroup'] = "sUCc3SSPhully Ed1T3d 9R0Up";
$lang['successfullydeletedselectedgroups'] = "sUCc35\$phULLy D3let3d \$3lecT3D GroUPS";
$lang['failedtodeletegroupname'] = "f4il3D +O d3Let3 gROup %s";
$lang['usercanaccessforumtools'] = "u\$er C@n 4CCe5\$ PHOruM T00lS 4nD CAN CrEAT3, d3lE+3 4ND 3d1+ phORum\$";
$lang['usercanmodallfoldersonallforums'] = "u53R c4n modER4T3 <b>all F0lD3Rs</b> 0n <b>aLl F0rUm\$</b>";
$lang['usercanmodlinkssectiononallforums'] = "u53R c4N M0DeRA+E l1NK\$ S3c+Ion 0n <b>alL FORUMs</b>";
$lang['emailconfirmationrequired'] = "em@1L conphIRM@+iON REqU1R3D";
$lang['userisbannedfromallforums'] = "uSeR IS B@NNED From <b>all phoRUms</b>";
$lang['cancelemailconfirmation'] = "c4nC3L em4Il coNF1rM4+I0n 4nd @lloW u53R to \$+Art Post1n9";
$lang['resendconfirmationemail'] = "reS3ND c0nfirm4+1on em@IL tO Us3R";
$lang['failedtosresendemailconfirmation'] = "f4iLed T0 R3\$eND 3M@1l coNPH1RM4+ION +o u\$eR.";
$lang['donothing'] = "do NOTH1nG";
$lang['usercanaccessadmintools'] = "usEr h4\$ 4cCe5\$ T0 f0RUM 4DMIN +o0lS";
$lang['usercanaccessadmintoolsonallforums'] = "us3R H@S @cCe\$s TO 4DM1n T00l\$ <b>on 4Ll foRumS</b>";
$lang['usercanmoderateallfolders'] = "uSER c4n MOD3R4+3 4lL F0LD3rS";
$lang['usercanmoderatelinkssection'] = "uS3r C@N m0deR@Te linKS \$EC+i0n";
$lang['userisbanned'] = "u53r 15 b4nnEd";
$lang['useriswormed'] = "useR 15 W0rmEd";
$lang['userispilloried'] = "useR 15 pILloRI3D";
$lang['usercanignoreadmin'] = "us3R c4n IGN0rE ADM1NISTr4t0R5";
$lang['groupcanaccessadmintools'] = "gR0up c4N AcC3S\$ 4DMIn +00lS";
$lang['groupcanmoderateallfolders'] = "grouP c4N m0Der@TE 4lL PHOlD3r\$";
$lang['groupcanmoderatelinkssection'] = "gR0uP c4n mOd3r4+3 LINKS \$3c+IOns";
$lang['groupisbanned'] = "gr0Up I\$ b@NNeD";
$lang['groupiswormed'] = "gr0uP I\$ w0RMEd";
$lang['readposts'] = "rE@D POsts";
$lang['replytothreads'] = "r3PlY t0 +HReaDS";
$lang['createnewthreads'] = "cr34+3 NEw THR34Ds";
$lang['editposts'] = "eDit P0s+\$";
$lang['deleteposts'] = "del3+3 P0s+s";
$lang['postssuccessfullydeleted'] = "pOST5 sUcCE\$\$pHulLY deLe+3D";
$lang['failedtodeleteusersposts'] = "f@1L3d T0 DeL3+3 uS3R'\$ P0sTs";
$lang['uploadattachments'] = "upl0@d 4tt4CHM3n+S";
$lang['moderatefolder'] = "m0d3r4+3 f0LDer";
$lang['postinhtml'] = "p0\$+ 1N hTML";
$lang['postasignature'] = "p0\$t @ SI9N4tURE";
$lang['editforumlinks'] = "edIT ForUm Link5";
$lang['linksaddedhereappearindropdown'] = "lInk5 4ddED H3rE 4pPE@r IN 4 DROP d0wn In +H3 +OP ri9hT 0F TH3 FR4m3 S3t.";
$lang['linksaddedhereappearindropdownaddnew'] = "l1NK5 4dDeD H3rE @ppE@R in 4 DR0P dowN 1n +He T0p ri9h+ oph +3h PHR4ME \$3T. T0 4dD @ LInk cl1ck +He '4DD N3W' 8UTT0N 8el0W.";
$lang['failedtoremoveforumlink'] = "f41LeD TO RemOVE phORUm link '%s'";
$lang['failedtoaddnewforumlink'] = "faiL3d +O 4DD new pH0RUM L1NK '%s'";
$lang['failedtoupdateforumlink'] = "f41L3d +0 UPDA+3 phorum LinK '%s'";
$lang['notoplevellinktitlespecified'] = "no +0p L3V3l L1NK TI+lE speCiph13D";
$lang['youmustenteralinktitle'] = "j00 MU5+ en+Er 4 linK +i+Le";
$lang['alllinkurismuststartwithaschema'] = "all l1nK URIS mu5+ S+4rT w1TH @ Sch3m4 (I.E. ht+p://, F+P://, 1RC://)";
$lang['editlink'] = "ed1T L1nK";
$lang['addnewforumlink'] = "add NEW F0RUM LiNk";
$lang['forumlinktitle'] = "f0RUM LINK +ITL3";
$lang['forumlinklocation'] = "forUM L1nK l0c4+10N";
$lang['successfullyaddednewforumlink'] = "sUCc3sSfUlly aDdEd N3W FORum LInk";
$lang['successfullyeditedforumlink'] = "succeSSPHUlLY 3d1t3d PH0RUM L1nK";
$lang['invalidlinkidorlinknotfound'] = "iNV4L1d L1nk 1D 0r liNK n0T phOUNd";
$lang['successfullyremovedselectedforumlinks'] = "sUCCE\$5PHULLy REM0VEd SEL3CT3D L1nks";
$lang['toplinkcaption'] = "top link c@PTION";
$lang['allowguestaccess'] = "aLL0w 9u3s+ 4cC35\$";
$lang['searchenginespidering'] = "se4rCH en9in3 5p1d3r1nG";
$lang['allowsearchenginespidering'] = "aLLOW \$e4RCh EN9In3 SP1DERIN9";
$lang['sitemapenabled'] = "eN48L3 SIT3m@P";
$lang['sitemapupdatefrequency'] = "sitEMAP Upd4+3 FR3qU3NCY";
$lang['sitemappathnotwritable'] = "s1Tem4P D1R3c+ORY Mu\$+ 8E Wr1TAblE bY +3h W3B \$eRVeR / Php pr0CE5\$!";
$lang['newuserregistrations'] = "nEw US3r RegISTR4t10n5";
$lang['preventduplicateemailaddresses'] = "pREv3N+ DuPLIC4+3 eM41l AdDR3s\$35";
$lang['allownewuserregistrations'] = "allow N3w US3r RE9iS+RA+10nS";
$lang['requireemailconfirmation'] = "r3qU1r3 EM@iL COnpH1RM4+ion";
$lang['usetextcaptcha'] = "u\$3 +ext-C@PTcH4";
$lang['textcaptchafonterror'] = "t3XT-c4PTCh4 H45 Be3N d154BLEd 4ut0m4+IC4lLY 83C4uSE thErE @RE nO +rU3 TYPe Phon+\$ 4v@IL4bl3 for 1+ T0 USE. PL34se UPl04D 5OMe +ruE +YpE f0NT5 T0 <b>t3xT_c4pTCh4/F0NTS</b> 0N yoUR S3RV3r.";
$lang['textcaptchadirerror'] = "texT-C4pTch4 H4\$ bE3n diS48LED 83c4usE +EH tEx+_c4p+ch4 DirEcT0Ry @ND sU8-D1r3C+ORiEs 4R3 N0+ writ48LE By TEH wEb \$3rV3R / PhP prOCesS.";
$lang['textcaptchagderror'] = "text-C4pTch4 H4\$ b33n D1\$a8leD 8EcAU\$E Y0UR s3RV3R'\$ phP \$3+UP d035 N0+ PR0V1D3 sUpp0R+ pH0r gd im4G3 M4NIPul4tIon @Nd / 0R ++F FOnt \$upPOR+. B0+h 4R3 rEQu1R3D for +3XT-c4pTCH4 SUppORT.";
$lang['newuserpreferences'] = "n3w USER pR3PhEreNcE\$";
$lang['sendemailnotificationonreply'] = "em@iL Not1fIc4+10n on R3pLY tO US3R";
$lang['sendemailnotificationonpm'] = "emAIL N0TIPHIc@+10n 0n PM t0 USer";
$lang['showpopuponnewpm'] = "sH0W POPup WHen ReCeiVING n3w PM";
$lang['setautomatichighinterestonpost'] = "se+ @U+Om4+1C H1gH 1NtEr3S+ 0n PO5+";
$lang['postingstats'] = "p0S+IN9 \$+4+\$";
$lang['postingstatsforperiod'] = "p05+1nG \$+A+s PhoR P3r10D %s T0 %s";
$lang['nopostdatarecordedforthisperiod'] = "no p0sT d4+@ Rec0RD3d For +H15 P3R10d.";
$lang['totalposts'] = "to+4l P0s+5";
$lang['totalpostsforthisperiod'] = "t0+@L POsTs f0R +HIs Per10d";
$lang['mustchooseastartday'] = "mUSt chO0s3 4 S+@rt d4y";
$lang['mustchooseastartmonth'] = "mu5+ ChoO53 4 S+4rT MON+h";
$lang['mustchooseastartyear'] = "mUSt ch00\$3 4 5+@R+ yE@R";
$lang['mustchooseaendday'] = "mus+ ChoOS3 4 eND d4Y";
$lang['mustchooseaendmonth'] = "mu5+ CH00s3 4 3nD Mon+H";
$lang['mustchooseaendyear'] = "mu5+ chOos3 4 3nD ye@R";
$lang['startperiodisaheadofendperiod'] = "st@Rt PeR10d 1s 4h34D 0pH eNd Per1oD";
$lang['bancontrols'] = "b@n C0nTrOLS";
$lang['addban'] = "aDD B4N";
$lang['checkban'] = "chEcK 84N";
$lang['editban'] = "ed1+ B4N";
$lang['bantype'] = "b@n typE";
$lang['bandata'] = "ban D4t4";
$lang['banexpires'] = "b4n ExPIREs";
$lang['bancomment'] = "c0Mm3NT";
$lang['optionalbrackets'] = "(opT10n4l)";
$lang['ipban'] = "iP 84N";
$lang['logonban'] = "lo9on 84N";
$lang['nicknameban'] = "n1cKN4ME 8@N";
$lang['emailban'] = "eM4Il 84N";
$lang['refererban'] = "rePH3rEr B4n";
$lang['invalidbanid'] = "inV4l1d 84N ID";
$lang['affectsessionwarnadd'] = "th15 b4N M4y 4pHPH3c+ +eh F0lLOw1NG 4ct1v3 U\$3R \$35\$i0Ns";
$lang['noaffectsessionwarn'] = "tHi5 B4n 4fPh3C+5 nO 4c+1vE \$eS\$iOns";
$lang['mustspecifybantype'] = "j00 Mus+ 5P3ciPHY 4 B4N +YP3";
$lang['mustspecifybandata'] = "j00 mu\$t SPeC1fY sOM3 84n D@t4";
$lang['expirydateisinvalid'] = "expIrY D4+3 1S 1Nv4l1d";
$lang['successfullyremovedselectedbans'] = "suCc3s\$phULLY R3mOvEd \$3L3ct3d 8@NS";
$lang['failedtoaddnewban'] = "fAIl3D +o 4Dd nEw b4N";
$lang['failedtoremovebans'] = "f41leD To r3m0ve sOm3 OR 4LL 0PH TH3 SELec+eD B@N\$";
$lang['duplicatebandataentered'] = "dUpl1C4t3 B4N D@t4 EN+3R3d. pl34\$3 Ch3ck y0UR w1lDc4RDS t0 S3e IPh +HEY alr3@DY M4tch TH3 D@t4 En+ER3D";
$lang['successfullyaddedban'] = "sUCC3ssPHUllY 4DDeD 8@N";
$lang['successfullyupdatedban'] = "succEs\$phuLly UPd@TED 8@N";
$lang['noexistingbandata'] = "tHERE 1s NO 3x1S+IN9 B4n da+a. to 4DD 4 b4N cL1Ck th3 '@DD N3W' 8U++ON 83LOW.";
$lang['youcanusethepercentwildcard'] = "j00 C4n usE +hE PeRC3n+ (%) W1lDc4rd SYM8Ol IN aNY 0F YOuR 8@N LIS+s +O o8+@1n P4rti4l M@+Ch3S, I.3. '192.168.0.%' WOUlD 8@N ALL 1P 4DdrE5s3s 1n thE R4NG3 192.168.0.1 +HROUGh 192.168.0.254";
$lang['selecteddateisinthepast'] = "seLECT3d d@te 1s 1n TH3 P4sT";
$lang['cannotusewildcardonown'] = "j00 c4NN0+ 4dD % @5 4 w1ldC@Rd M4TCh 0n 1ts own!";
$lang['requirepostapproval'] = "r3qU1rE P0\$+ 4pPR0v@L";
$lang['adminforumtoolsusercounterror'] = "th3Re mu5+ B3 4+ LE@ST 1 US3r w1+H @DmIn +oOLS 4nD F0RUm +0oLS aCCES\$ 0n 4ll PH0RUM\$!";
$lang['postcount'] = "p0\$t C0uNT";
$lang['changepostcount'] = "cH@Ng3 POS+ COun+";
$lang['resetpostcount'] = "r3sET POs+ C0UNT";
$lang['successfullyresetpostcount'] = "sucCESSPHuLLY r3S3t POs+ coUnt";
$lang['successfullyupdatedpostcount'] = "suCCE\$\$phuLLY upD4+3D Po5+ c0un+";
$lang['failedtoresetuserpostcount'] = "f4ilED +0 R353T POST COUN+";
$lang['failedtochangeuserpostcount'] = "f4ILeD TO CH@NgE us3r POSt CouNT";
$lang['postapprovalqueue'] = "p05+ @PProVAL qUeU3";
$lang['nopostsawaitingapproval'] = "n0 pOsTs 4R3 4W41+In9 4PPROV@l";
$lang['failedtoapproveuser'] = "f@1L3D t0 4pPROVe USEr %s";
$lang['endsession'] = "eND S3Ss1oN (KIcK)";
$lang['visitorlog'] = "v1\$i+or L09";
$lang['novisitorslogged'] = "n0 v15iTOR\$ L09geD";
$lang['addselectedusers'] = "aDD 53lECteD uS3R\$";
$lang['removeselectedusers'] = "rEmov3 s3l3CT3D US3r\$";
$lang['addnew'] = "aDD new";
$lang['deleteselected'] = "dELE+e Sel3C+3d";
$lang['forumrulesmessage'] = "<p><b>f0RUM RUl3\$</b></p><p>\nr3915tr@+I0n +0 %1\$\$ 15 FR33! WE d0 1n\$1S+ tH@T j00 @b1DE 8Y TEh rulES AND POLIC1Es D3t4ileD b3L0w. Iph J00 A9rE3 t0 TEH t3Rm\$, pl34sE chEcK T3H 'I agrE3' CH3CK8oX AnD PRess T3h 'reG1s+ER' 8UtT0N 83LOW. 1f J00 w0UlD L1K3 To C4nC3L +H3 r39is+rA+ION, cl1ck %2\$s +0 r3tuRN +O TH3 PHORUM\$ 1ND3x.</p><p>\n4lth0ugh +H3 4DM1ni\$+r4+0Rs 4nd M0dErA+ORS OF %1\$S W1lL 4++3mpT +0 kEep @LL 0BjEcti0n48LE MES5@93s ophph THI\$ f0Rum, 1T I\$ IMPoS\$i8L3 for US T0 rEV1ew 4lL MES\$aG3\$. 4Ll m3Ss4G3\$ 3xPR3\$\$ +H3 vi3Ws 0ph +H3 4u+H0r, 4nd N3I+h3R The 0wNER\$ OpH %1\$S, NoR pRoJ3ct 833h1VE PHORUm anD i+'\$ 4FFiLi4+3\$ WIlL be HELD R3\$ponSiBl3 For tHE c0nT3n+ oPh 4ny M3\$\$@g3.</p><p>\nby 49R33ING +O Th3sE Rul3s, j00 w@rR@NT +H4+ J00 wILL N0t Po\$+ 4NY mess@g3S TH4+ @Re o8\$cEn3, vUl94r, 53xU4llY-0R13n+4T3d, H4+3fuL, tHr3@+eniN9, 0r OtheRWI5e ViOL4+1VE oF 4nY L4W\$.</p><p>thE 0WNERS OPH %1\$\$ R3S3rvE +3h rIgHt T0 R3movE, 3DIT, MOvE 0R cl0se @ny +hR3@d F0R 4nY rE4son.</p>";
$lang['cancellinktext'] = "h3Re";
$lang['failedtoupdateforumsettings'] = "f4ilEd t0 upD4tE pHORum S3++1NG\$. plE4s3 +RY 49@1n L4tEr.";
$lang['moreadminoptions'] = "m0r3 4dMIN 0pTION5";

// Admin Log data (admin_viewlog.php) --------------------------------------------

$lang['changedstatusforuser'] = "ch4nGEd US3R \$+4+US PH0r '%s'";
$lang['changedpasswordforuser'] = "ch4NGeD P@sswORd F0r '%s'";
$lang['changedforumaccess'] = "cH@NgeD PH0RUM 4CcE5\$ pErm1\$\$iON\$ pH0R '%s'";
$lang['deletedallusersposts'] = "dELETeD 4Ll P0sTS F0r '%s'";

$lang['createdusergroup'] = "crEa+ed u53R GROup '%s'";
$lang['deletedusergroup'] = "d3L3TEd U\$3R GrOUP '%s'";
$lang['updatedusergroup'] = "upd4T3D US3r 9r0UP '%s'";
$lang['addedusertogroup'] = "aDd3D us3R '%s' +O 9ROUP '%s'";
$lang['removeduserfromgroup'] = "remoV3 u53r '%s' phR0M GR0uP '%s'";

$lang['addedipaddresstobanlist'] = "adD3D IP '%s' T0 84n LI\$+";
$lang['removedipaddressfrombanlist'] = "rEmOVEd 1p '%s' fROM b4n lis+";

$lang['addedlogontobanlist'] = "adDED lO90N '%s' TO 8@N LIst";
$lang['removedlogonfrombanlist'] = "r3mOV3d L0gON '%s' FR0M 8aN Li\$+";

$lang['addednicknametobanlist'] = "adDED nIckNAMe '%s' +O 84N Li\$+";
$lang['removednicknamefrombanlist'] = "reM0v3d n1CkN@Me '%s' FROM 84n li\$+";

$lang['addedemailtobanlist'] = "adDeD eM@1L 4dDr3SS '%s' +O 8@n LIS+";
$lang['removedemailfrombanlist'] = "reMovEd 3m@il 4DDR3s\$ '%s' Fr0M 8aN liS+";

$lang['addedreferertobanlist'] = "adD3D r3FEREr '%s' T0 B@n l1\$+";
$lang['removedrefererfrombanlist'] = "r3M0v3D Ref3rER '%s' phROM B4N l1sT";

$lang['editedfolder'] = "eDITeD PHOlD3R '%s'";
$lang['movedallthreadsfromto'] = "mOVED 4lL thR34dS frOM '%s' +0 '%s'";
$lang['creatednewfolder'] = "cre4+3d n3w f0LDeR '%s'";
$lang['deletedfolder'] = "d3LETeD PhoLd3R '%s'";

$lang['changedprofilesectiontitle'] = "ch4Ng3d PropH1LE s3C+10n +i+Le phroM '%s' T0 '%s'";
$lang['addednewprofilesection'] = "adD3d nEw PRopH1LE S3c+ioN '%s'";
$lang['deletedprofilesection'] = "d3L3TED pROFILe \$3c+10n '%s'";

$lang['addednewprofileitem'] = "aDDEd N3w pROFilE 1+3m '%s' +o SEc+1oN '%s'";
$lang['changedprofileitem'] = "ch@Ng3d pRoFIL3 ITem '%s'";
$lang['deletedprofileitem'] = "deL3TED pR0FIL3 1+em '%s'";

$lang['editedstartpage'] = "editeD ST4rT P4g3";
$lang['savednewstyle'] = "s@v3d n3w s+YL3 '%s'";

$lang['movedthread'] = "mOV3D THrE@d '%s' Phr0m '%s' To '%s'";
$lang['closedthread'] = "clos3d +Hr3@D '%s'";
$lang['openedthread'] = "oPENeD threAD '%s'";
$lang['renamedthread'] = "r3nAM3D +HrEAd '%s' t0 '%s'";

$lang['deletedthread'] = "d3leTED +HReaD '%s'";
$lang['undeletedthread'] = "unD3lE+3D +hr34d '%s'";

$lang['lockedthreadtitlefolder'] = "l0ck3D THR34d 0Pt10ns ON '%s'";
$lang['unlockedthreadtitlefolder'] = "uNLock3d +HRe@D 0P+iON5 On '%s'";

$lang['deletedpostsfrominthread'] = "d3lET3d P0\$tS From '%s' 1N +Hr3@D '%s'";
$lang['deletedattachmentfrompost'] = "dELEt3d a++@CHmEnT '%s' frOM po5+ '%s'";

$lang['editedforumlinks'] = "eDiT3D PHORUm LinK5";
$lang['editedforumlink'] = "ed1T3d phorUM LINk: '%s'";

$lang['addedforumlink'] = "aDdeD PHORum LINK: '%s'";
$lang['deletedforumlink'] = "d3l3TEd F0RUM L1NK: '%s'";
$lang['changedtoplinkcaption'] = "ch4NG3d +0p l1NK c@P+10N phR0M '%s' +O '%s'";

$lang['deletedpost'] = "dEL3t3d POS+ '%s'";
$lang['editedpost'] = "ed1T3D POS+ '%s'";

$lang['madethreadsticky'] = "m4De +HReAD '%s' \$+ICky";
$lang['madethreadnonsticky'] = "m4dE THr3@D '%s' N0n-ST1CKY";

$lang['endedsessionforuser'] = "eND3d sE\$\$iON f0R USER '%s'";

$lang['approvedpost'] = "aPpR0VED P0St '%s'";

$lang['editedwordfilter'] = "eDi+3D WORd PH1l+ER";

$lang['addedrssfeed'] = "adD3D rs5 ph3eD '%s'";
$lang['editedrssfeed'] = "eD1tEd R\$\$ FE3D '%s'";
$lang['deletedrssfeed'] = "dEL3tEd r\$\$ FE3d '%s'";

$lang['updatedban'] = "upD4+3D B4n '%s'. chAN9eD +ypE From '%s' T0 '%s', CH4ng3D d4+@ frOM '%s' T0 '%s'.";

$lang['splitthreadatpostintonewthread'] = "spl1t tHRE4D '%s' 4t PO5+ %s  1n+O n3W THr34D '%s'";
$lang['mergedthreadintonewthread'] = "m3r93d ThrE@d\$ '%s' ANd '%s' IN+o n3w +hrEad '%s'";

$lang['ipaddressbanhit'] = "us3r '%s' 1\$ b4nnEd. 1p 4DDR35S '%s' M@tCh3d b@n D@+@ '%s'";
$lang['logonbanhit'] = "u\$er '%s' 1s b4NNeD. L09oN '%s' m@Tch3D 84n D4T4 '%s'";
$lang['nicknamebanhit'] = "u53r '%s' 1s B@nN3D. N1CKN@mE '%s' M4tcHEd B@n Da+@ '%s'";
$lang['emailbanhit'] = "usER '%s' is bAnn3d. 3M4IL @ddre\$\$ '%s' m4+Ch3d b4N da+4 '%s'";
$lang['refererbanhit'] = "uSeR '%s' 1\$ 8@NnED. HTtP R3FEReR '%s' M4+chEd B@n d@T4 '%s'";

$lang['modifiedpermsforuser'] = "mOd1pH13d pErm5 PH0r usER '%s'";
$lang['modifiedfolderpermsforuser'] = "m0DIPH13d F0ldeR PerM5 PH0r US3R '%s'";

$lang['userpermfoldermoderate'] = "foldER MOd3r4toR";

$lang['adminlogempty'] = "aDMIn L09 I\$ emp+Y";

$lang['youmustspecifyanactiontypetoremove'] = "j00 Mus+ \$PECiphy @n 4c+ION +YP3 T0 R3M0VE";

$lang['alllogentries'] = "aLL lOG en+RieS";
$lang['userstatuschanges'] = "u\$er 5+@+us Ch4NG3\$";
$lang['forumaccesschanges'] = "f0rum 4cCE\$\$ CHAn9Es";
$lang['usermasspostdeletion'] = "user M4s\$ p0s+ D3Le+ION";
$lang['ipaddressbanadditions'] = "ip 4dDRESs 8@N AdD1+10NS";
$lang['ipaddressbandeletions'] = "ip addR3S5 B4N d3le+ion\$";
$lang['threadtitleedits'] = "tHRe4d +ITl3 EDiTS";
$lang['massthreadmoves'] = "m4\$\$ THR34d M0v3s";
$lang['foldercreations'] = "f0lD3R Cr3@T10nS";
$lang['folderdeletions'] = "f0lDER D3lE+ioN5";
$lang['profilesectionchanges'] = "profILe s3C+IOn Ch@N9E\$";
$lang['profilesectionadditions'] = "prOfiLE seC+1ON @dDiTION5";
$lang['profilesectiondeletions'] = "prOphILe S3C+1oN DElETioN5";
$lang['profileitemchanges'] = "pR0FilE IT3m ch4N9es";
$lang['profileitemadditions'] = "pR0FIL3 i+3M @ddI+1oNs";
$lang['profileitemdeletions'] = "pROPH1LE 1+3M dEL3Ti0ns";
$lang['startpagechanges'] = "sT@R+ P@9e cH@nG3s";
$lang['forumstylecreations'] = "f0RuM STyl3 cr3@TionS";
$lang['threadmoves'] = "tHr34d mOVE\$";
$lang['threadclosures'] = "thrE4d cl0sURES";
$lang['threadopenings'] = "tHRe@D 0PEN1n9s";
$lang['threadrenames'] = "tHrE4D R3N4mE5";
$lang['postdeletions'] = "po\$+ DeLE+Ion5";
$lang['postedits'] = "pO\$+ EdiTS";
$lang['wordfilteredits'] = "w0rD FILtEr 3DI+s";
$lang['threadstickycreations'] = "thr34D ST1CKy cRE@T10n\$";
$lang['threadstickydeletions'] = "thRe@d 5+IcKY dEL3+10n5";
$lang['usersessiondeletions'] = "uSeR 53SSIOn DelE+ioN5";
$lang['forumsettingsedits'] = "f0Rum 5eT+InG\$ EDi+\$";
$lang['threadlocks'] = "thr3@d loCk\$";
$lang['threadunlocks'] = "tHR3aD uNl0Ck\$";
$lang['usermasspostdeletionsinathread'] = "u53R m4Ss p0s+ Del3+1oN\$ IN 4 ThR3@D";
$lang['threaddeletions'] = "thr3@D d3L3+ION\$";
$lang['attachmentdeletions'] = "a+T@chM3nT dElETION5";
$lang['forumlinkedits'] = "fORum LInK 3DI+S";
$lang['postapprovals'] = "pOs+ 4PpR0V4L\$";
$lang['usergroupcreations'] = "u53R gROUP CRe4T10ns";
$lang['usergroupdeletions'] = "u\$er GRouP D3lE+1On5";
$lang['usergroupuseraddition'] = "us3R GRouP U53r @dD1tION";
$lang['usergroupuserremoval'] = "uS3r GR0uP UsER RemOV@l";
$lang['userpasswordchange'] = "u53R P45\$wOrD Ch4n9e";
$lang['usergroupchanges'] = "u\$er gr0uP CH4NG3s";
$lang['ipaddressbanadditions'] = "iP ADdRES\$ 84n 4dDI+1oN\$";
$lang['ipaddressbandeletions'] = "ip 4dDRESS B@N DEl3t10NS";
$lang['logonbanadditions'] = "l0gon 84n ADd1+1ON\$";
$lang['logonbandeletions'] = "lOg0n 8@n D3lE+IOns";
$lang['nicknamebanadditions'] = "n1CkN@Me 8@N 4Dd1+10NS";
$lang['nicknamebanadditions'] = "n1ckN@Me b4N 4dDit10NS";
$lang['e-mailbanadditions'] = "e-m@1l B4n 4ddi+10nS";
$lang['e-mailbandeletions'] = "e-m4il 84n D3lE+10Ns";
$lang['rssfeedadditions'] = "rS\$ fEEd @DdiT1Ons";
$lang['rssfeedchanges'] = "r\$5 f3ed ch@N93\$";
$lang['threadundeletions'] = "tHrE@d UNd3LeTION\$";
$lang['httprefererbanadditions'] = "hTTP rEfEREr 84N 4DdiTIOn\$";
$lang['httprefererbandeletions'] = "http REph3rER 8aN dEL3Ti0ns";
$lang['rssfeeddeletions'] = "r5\$ F33d D3LE+1on\$";
$lang['banchanges'] = "b4n ch4n93S";
$lang['threadsplits'] = "tHre4D \$Pl1+\$";
$lang['threadmerges'] = "thRE@d M3R9es";
$lang['forumlinkadditions'] = "forUm L1nK @dDIT1onS";
$lang['forumlinkdeletions'] = "f0ruM link d3leT10ns";
$lang['forumlinktopcaptionchanges'] = "foruM l1nk +0p C4pT1ON Ch4N9e5";
$lang['folderedits'] = "fOld3R 3d1T\$";
$lang['userdeletions'] = "u53R D3L3TION5";
$lang['userdatadeletions'] = "user D4+A Del3t1oNS";
$lang['usergroupchanges'] = "u\$eR 9rOUp CH@N9E\$";
$lang['ipaddressbancheckresults'] = "ip 4dDrE\$S b4N cHEcK Re\$uL+\$";
$lang['logonbancheckresults'] = "lOG0n 8@n cheCK RE\$ulT\$";
$lang['nicknamebancheckresults'] = "nIckn@ME B4n ch3cK R3sUL+\$";
$lang['emailbancheckresults'] = "eM4iL 8@N Ch3ck re\$ULT\$";
$lang['httprefererbancheckresults'] = "ht+P R3Ph3rer 8@N cHEck r3sult5";

$lang['removeentriesrelatingtoaction'] = "r3M0VE 3nTRI3s R3l@+INg +O 4CTIon";
$lang['removeentriesolderthandays'] = "rEmOV3 3ntRIE\$ olDeR +hAN (D@YS)";

$lang['successfullyprunedadminlog'] = "sUCCes\$pHULLY prUn3D 4dm1N l09";
$lang['failedtopruneadminlog'] = "faIleD t0 PRuNE 4DMIN LO9";

$lang['successfullyprunedvisitorlog'] = "sUcc35\$pHulLY PRun3D V1s1+OR log";
$lang['failedtoprunevisitorlog'] = "f4IleD +o PRUn3 VisIT0r L09";

$lang['prunelog'] = "pRUn3 L09";

// Admin Forms (admin_forums.php) ------------------------------------------------

$lang['noexistingforums'] = "n0 EX1S+iNG F0RUM\$ PhoUNd. TO cRE@Te A NEw ForUm CL1CK +he '4dD nEW' 8UT+oN beL0W.";
$lang['webtaginvalidchars'] = "wEb+@9 C4n ONLY cONTain UPp3Rc4\$3 4-Z, 0-9 4nd unDersc0rE cH@R4CT3r5";
$lang['invalidforumidorforumnotfound'] = "iNv4l1D PH0RUM f1d 0R PHORum not phOunD";
$lang['successfullyupdatedforum'] = "succES\$phulLY UpD4+Ed F0rum";
$lang['failedtoupdateforum'] = "f@Il3D +0 UPd@Te PHOrum: '%s'";
$lang['successfullycreatednewforum'] = "sUcCes\$pHULLy Cr34+3D N3w ForuM";
$lang['selectedwebtagisalreadyinuse'] = "thE SELeCT3D W3Bt49 1s 4lRE@dY 1N u5E. pL3@S3 chO0\$3 4N0+H3r.";
$lang['selecteddatabasecontainsconflictingtables'] = "teH S3LECtED D4+@B4\$e c0n+41N5 C0nFL1cTINg Ta8Le\$. confl1cT1nG t48lE N@mES @rE:";
$lang['forumdeleteconfirmation'] = "ar3 J00 Sur3 J00 W4nt TO Del3Te 4ll OPh +HE \$eL3C+3D FOrumS?";
$lang['forumdeletewarning'] = "pL3@\$3 NOT3 TH@T J00 cANNO+ ReCov3R dEl3teD ForUMS. 0Nc3 d3l3T3D 4 forum ANd @LL oph +H3 A\$\$oCI@Ted D@T4 1s p3rM4nEn+LY ReMOVEd From +3h D@ta8@\$3. iph J00 DO N0T W15h t0 D3L3TE tEh S3lEcT3d F0rUM\$ PL3@s3 CL1CK c4NcEl.";
$lang['successfullyremovedselectedforums'] = "sucC3S\$PHUllY DeLET3D \$3leCtEd ph0ruMs";
$lang['failedtodeleteforum'] = "f@iLeD +O D3l3tEd pHORUM: '%s'";
$lang['addforum'] = "aDD phoRum";
$lang['editforum'] = "ed1t F0rum";
$lang['visitforum'] = "v151T F0RUM: %s";
$lang['accesslevel'] = "accEsS Lev3l";
$lang['forumleader'] = "f0RuM leAD3r";
$lang['usedatabase'] = "usE D@+484s3";
$lang['unknownmessagecount'] = "unKn0wN";
$lang['forumwebtag'] = "f0RUM wEBt4g";
$lang['defaultforum'] = "d3f@ulT f0rUM";
$lang['forumdatabasewarning'] = "pl3@S3 3nsUR3 J00 5EL3C+ Th3 cOrReCT d@t@b4S3 wh3N cRE@TIng 4 N3w F0rUM. onc3 Cr34+3D 4 New ph0rUM cANNOT bE Mov3D bETWe3n 4v4iL@bL3 D4+Ab4SEs.";

// Admin Global User Permissions

$lang['globaluserpermissions'] = "gl08@l us3r PeRm15\$1oN\$";

// Admin Forum Settings (admin_forum_settings.php) -------------------------------

$lang['mustsupplyforumwebtag'] = "j00 mUST \$upPLy 4 pHORum W38+@G";
$lang['mustsupplyforumname'] = "j00 MuS+ \$upPLy @ FOruM N4ME";
$lang['mustsupplyforumemail'] = "j00 muST 5uPPly 4 FORum 3m41l 4dDr3S\$";
$lang['mustchoosedefaultstyle'] = "j00 mus+ cHo0S3 4 dEf@ULT f0RUm \$+yL3";
$lang['mustchoosedefaultemoticons'] = "j00 MUS+ CHOOS3 D3pH4uL+ phoRUM eM0+Ic0N5";
$lang['mustsupplyforumaccesslevel'] = "j00 MU\$t 5uPPLy 4 pH0rum @CcE\$S L3v3l";
$lang['mustsupplyforumdatabasename'] = "j00 MUS+ SUPPLY a ph0RUm D4t4B453 N@mE";
$lang['unknownemoticonsname'] = "unknOWN 3MOt1CON\$ N4m3";
$lang['mustchoosedefaultlang'] = "j00 MU\$+ chO0\$e @ d3f4ULT f0rUM l4N9u@G3";
$lang['activesessiongreaterthansession'] = "ac+1Ve sE5\$ioN +iME0U+ cAnno+ 83 GrE4TEr +h@N \$e5\$Ion T1M3OU+";
$lang['attachmentdirnotwritable'] = "a+T4chMEn+ DirEc+0rY 4ND \$YS+3m +3mPOr4RY d1r3cTORY / PHP.1n1 'Upl04D_+mp_d1r' MU5t bE WriT4BL3 8y TEH w38 53RV3R / php pRoC3\$5!";
$lang['attachmentdirblank'] = "j00 Must 5UPplY 4 D1rECT0RY t0 5@Ve @TT@CHm3NT\$ 1n";
$lang['mainsettings'] = "ma1n \$ET+inG\$";
$lang['forumname'] = "f0rUM N4m3";
$lang['forumemail'] = "fORUM eMail";
$lang['forumnoreplyemail'] = "n0-R3ply EM4IL";
$lang['forumdesc'] = "f0rUM d3SCR1PTION";
$lang['forumkeywords'] = "fOrUM K3yW0RD\$";
$lang['forumcontentrating'] = "f0rum CoNT3nT R@T1N9";
$lang['defaultstyle'] = "depH4uL+ S+ylE";
$lang['defaultemoticons'] = "d3f4UL+ Em0+iC0nS";
$lang['defaultlanguage'] = "d3f4uL+ LAn9UAGe";
$lang['forumaccesssettings'] = "foRum 4Cc3\$s s3tT1n9S";
$lang['forumaccessstatus'] = "forUM @Cc3S\$ \$+4+uS";
$lang['changepermissions'] = "ch4NgE PErmISSion5";
$lang['changepassword'] = "ch4nG3 p@S5wORD";
$lang['passwordprotected'] = "p@5\$w0rD PROteC+3D";
$lang['passwordprotectwarning'] = "j00 H@V3 N0t sE+ 4 PHORUm Pa\$\$WorD. 1PH j00 Do N0+ \$3T @ P@sSW0rD teH P@\$\$W0RD PR0+Ect1oN FUnC+10n4li+Y wiLL 8E @U+oma+iCalLY D1\$@BL3d!";
$lang['postoptions'] = "p0ST OP+ions";
$lang['allowpostoptions'] = "aLLoW Po\$+ ED1TINg";
$lang['postedittimeout'] = "po5+ 3dI+ t1M3oU+";
$lang['posteditgraceperiod'] = "p0s+ eD1+ 9R4c3 p3rIOD";
$lang['wikiintegration'] = "wiKiW1k1 1NT3Gr4+ION";
$lang['enablewikiintegration'] = "en48le w1kIwIK1 1nTegR4+ION";
$lang['enablewikiquicklinks'] = "en@8LE wIK1w1kI Quick L1nKS";
$lang['wikiintegrationuri'] = "wIKIw1KI L0C4+Ion";
$lang['maximumpostlength'] = "m4XIMum p0S+ LeN9+H";
$lang['postfrequency'] = "p05+ phr3QU3NCy";
$lang['enablelinkssection'] = "en4BL3 LINks S3CT10n";
$lang['allowcreationofpolls'] = "all0W cr34+IOn 0pH POLl\$";
$lang['allowguestvotesinpolls'] = "all0w 9u3\$tS T0 votE 1N POLls";
$lang['unreadmessagescutoff'] = "unR3AD m3s\$@9e5 cUT-0Ff";
$lang['disableunreadmessages'] = "d1S@8LE UNr34d Mes\$@9eS";
$lang['thirtynumberdays'] = "30 D4y\$";
$lang['sixtynumberdays'] = "60 D4Y\$";
$lang['ninetynumberdays'] = "90 D@Ys";
$lang['hundredeightynumberdays'] = "180 D@YS";
$lang['onenumberyear'] = "1 y3@R";
$lang['unreadcutoffchangewarning'] = "dep3nD1n9 ON s3rvEr PERpH0rM4nc3 4ND +HE nUmB3r OPh +hRE@Ds YOur foRums ConT41N, CH4N91n9 ThE UnrE4D CUt-OPHf M4y +@Ke S3V3R4L MinU+E\$ T0 C0Mpl3+3. PHor This RE@son 1+ 15 r3COMMEnD3D +h4+ J00 4vOId Ch4n91NG TH1s S3ttiNG wHIL3 YOuR foRums ar3 Bu5y.";
$lang['unreadcutoffincreasewarning'] = "iNCR34\$iN9 +3H unre@d Cu+-0PHPh WILl m4k3 +HReadS M4rk3D 4s MoDiphIEd S1NCe 4nd +HRe@DS 0lD3R +H4n THe PRevioUS cU+-0Phf @PPe@R @s UNRe4d +O @lL USeRS";
$lang['confirmunreadcutoff'] = "aR3 J00 surE J00 w4n+ +O ch4n93 +3H Unr3@D CUT-0Phf?";
$lang['otherchangeswillstillbeapplied'] = "clIcK1n9 'n0' w1LL onLY C4NcEL +He Unr34d cu+-0PHPH Ch4nGe\$. O+H3r chAN9E\$ Y0u'v3 M@dE WIll S+1LL 83 54V3d.";
$lang['searchoptions'] = "s34Rch OP+1On5";
$lang['searchfrequency'] = "sE4RCh phrEQueNcy";
$lang['sessions'] = "sEs\$iON\$";
$lang['sessioncutoffseconds'] = "s35\$ioN Cu+ 0PHPH (\$eCONds)";
$lang['activesessioncutoffseconds'] = "ac+1V3 s3SSIon cU+ OfpH (\$3CONd\$)";
$lang['stats'] = "s+4+S";
$lang['hide_stats'] = "hid3 5+a+\$";
$lang['show_stats'] = "sHoW 5+@+S";
$lang['enablestatsdisplay'] = "eN48L3 \$+@TS DiSPL4Y";
$lang['personalmessages'] = "p3r\$0N4l M3s\$aG3s";
$lang['enablepersonalmessages'] = "en@BL3 PerS0n@L Mess49es";
$lang['pmusermessages'] = "pm m3\$\$@93S pER us3r";
$lang['allowpmstohaveattachments'] = "all0w p3r5oN4L M3S\$@93S +O h@VE @Tt4chmeN+\$";
$lang['autopruneuserspmfoldersevery'] = "auto pRUn3 U\$er'S pm ph0lD3rS eV3ry";
$lang['userandguestoptions'] = "uS3R 4nD 9uE\$+ 0P+I0N5";
$lang['enableguestaccount'] = "en48le Gu3S+ 4Cc0UN+";
$lang['listguestsinvisitorlog'] = "l1\$+ 9u3s+S 1n VI\$1+0R L09";
$lang['allowguestaccess'] = "alLOW 9U3s+ 4CC3\$s";
$lang['userandguestaccesssettings'] = "u53R @Nd GUE5+ 4Cc3\$\$ 53TTinG\$";
$lang['allowuserstochangeusername'] = "aLloW U53r\$ TO ch4n9e US3RNAM3";
$lang['requireuserapproval'] = "r3qUIRE us3r @pPROVAL 8y @dmIN";
$lang['requireforumrulesagreement'] = "r3qU1R3 u\$3R +O 49r33 +o F0RUM Rul3\$";
$lang['sendnewuseremailnotifications'] = "s3ND n0t1ph1c@t10n t0 GL084L ForUM 0WN3r";
$lang['enableattachments'] = "en@BL3 @TT4CHM3N+5";
$lang['attachmentdir'] = "aT+@chm3nT d1R";
$lang['userattachmentspace'] = "at+@ChM3nT SP4CE pER Us3R";
$lang['allowembeddingofattachments'] = "all0W emBeDD1n9 0f @+t4chMEN+s";
$lang['usealtattachmentmethod'] = "u53 4lTERna+iVe A+T4CHM3NT ME+HOD";
$lang['allowgueststoaccessattachments'] = "allOw 9U3\$+s +0 4CcE\$\$ @t+@chM3NT\$";
$lang['forumsettingsupdated'] = "fORUM sEtT1n9s SUcC3s5PhUlly upD4tEd";
$lang['forumstatusmessages'] = "f0rUM S+@tU\$ ME\$\$49Es";
$lang['forumclosedmessage'] = "fORuM Cl0S3d M3Ss493";
$lang['forumrestrictedmessage'] = "fORUM r3\$+RIcT3d Mes5@9e";
$lang['forumpasswordprotectedmessage'] = "f0RUM P4Ssw0rD protEcTED m3s\$4G3";
$lang['googleanalytics'] = "g00GLe @N4lYTIcs";
$lang['enablegoogleanalytics'] = "eN@8lE GOogL3 4N4lyTICs";
$lang['allowforumgoogleanalytics'] = "aLL0w 90O9l3 4n@LY+1cs ON e@cH PH0rUM";
$lang['googleanalyticsaccountid'] = "goO9LE an4lYTIc5 4ccOUNt Id";
$lang['googleadsense'] = "gOo9L3 4d\$3N\$3";
$lang['enablegoogleadsenseadverts'] = "sH0w 90O9L3 4D\$3nSE @DS";
$lang['displaygoogleadsenseadstousers'] = "d1\$Pl4Y 4d53nsE @DS fOr";
$lang['displaygoogleadsenseadsonpages'] = "dI5PL4y 4DS3n53 4d5 on";
$lang['googleadsenseclientid'] = "aDS3NS3 CLi3NT iD";
$lang['googleadsenseadchannel'] = "aD\$3NS3 4D cH4nnEL";
$lang['googleadsenseadtype'] = "aDsEN\$3 4D +YP3";
$lang['googleadsenseadbordercolour'] = "b0rDEr c0louR";
$lang['googleadsensebackgroundcolour'] = "b@CKgR0UnD C0LoUR";
$lang['googleadsenselinkcolour'] = "link C0lOUR";
$lang['googleadsenseurlcolour'] = "uRL COLOur";
$lang['googleadsensetextcolour'] = "t3x+ COL0uR";
$lang['allusers'] = "aLL U\$ER\$";
$lang['guestsonly'] = "gUE\$+\$ 0nlY";
$lang['allpages'] = "all P49e\$";
$lang['messagesonly'] = "meSs@9E5 oNLY";
$lang['usemydefaultaccountsetting'] = "uSE MY DEPHauL+ 4cCoUn+ 53tt1n9";
$lang['textonlyads'] = "text ONLY 4DS";
$lang['textandimageads'] = "tExt anD iM493 4D\$";
$lang['registertoremoveadverts'] = "r3Gi\$+Er +O R3M0VE TH3SE 4DV3r+5.";

// Admin Forum Settings Help Text (admin_forum_settings.php) ------------------------------

$lang['forum_settings_help_10'] = "<b>p0\$T 3D1T t1M3ou+</b> i\$ tEH +im3 IN miNU+E\$ 4fter P0s+1nG Tha+ @ us3r C4n 3DIt +H31r P0s+. ipH 53T +0 0 TH3r3 1S NO limi+.";
$lang['forum_settings_help_11'] = "<b>m@ximUM POsT Len9tH</b> i\$ The mAXIMUm NUMbER 0PH ch4r4CT3Rs TH4+ W1LL 8E D15Pl4yeD 1n A po\$t. 1f @ P05+ IS L0n9eR Th@N +hE NUm83r OPH Char4cTErS d3PHIN3D HeRe IT W1lL 83 CuT SHor+ 4ND @ liNK adDeD +o +Eh B0t+0M +o 4Ll0w u\$eR\$ T0 r34d T3H whoL3 P0ST ON 4 S3P4r@T3 P4G3.";
$lang['forum_settings_help_12'] = "iF j00 D0n'+ W4nT YOuR U\$ER\$ T0 83 4bl3 T0 CR3@Te P0LLS j00 c4n DI\$@BlE +Eh 4B0VE op+1On.";
$lang['forum_settings_help_13'] = "t3h L1nk\$ s3c+ION oph 83eHIVe PR0vIdE\$ 4 PL@cE ph0r YOUR uSers t0 M41nt4iN 4 l15+ OF \$iTe\$ THEy FREqU3nTLY ViS1+ +h4+ OThER UseRS m4Y FInD us3pHUL. LINk5 c4n bE D1V1D3D INT0 c4T39OR13S BY PhOldER 4ND 4LL0w F0R C0MMEn+S @nD ra+1nGs +0 83 9iV3N. IN 0RD3R +0 m0dER4+3 +hE L1nKs 53CT10N 4 Us3R muS+ 83 R@N+3d GL0B4l m0dER@+or 5+atU\$.";
$lang['forum_settings_help_15'] = "<b>seS\$iON cU+ ofPH</b> I\$ THE M4xiMum T1M3 B3pHOR3 4 USER'\$ \$E5\$iOn is d3EM3D d34D ANd +Hey 4re l099Ed 0uT. 8Y DePH4UlT Th1\$ 1S 24 HOURS (86400 \$3C0ND\$).";
$lang['forum_settings_help_16'] = "<b>aCTIVe \$3S\$iON CU+ 0PHph</b> iS TH3 M@XIMum t1M3 B3phoR3 4 U53r'S S3s\$10n 1\$ d33mEd IN4C+IVe @T Which p0iNT +hEY En+ER 4N 1DLE s+@+e. 1N +hI\$ S+4+3 TH3 U\$3r reM@1n\$ L0993d In, 8uT +HEy 4rE ReMov3d froM +3h @C+iVe U53rs lIS+ 1n tEH 5T4Ts di\$pl4y. 0nC3 theY B3CoME act1v3 4G@1n tH3y WILL 83 re-4dd3D +o TH3 lIs+. 8Y d3pH4uL+ ThIs \$3++1N9 Is \$3t +0 15 M1nu+E\$ (900 \$3conD\$).";
$lang['forum_settings_help_17'] = "eN48lING th1\$ 0pt1oN 4llow5 B33h1v3 +O 1NCLuD3 4 S+4tS DI\$PLAY 4+ +EH 80tT0m OPH +HE MEsS49e5 p4Ne sIm1l@r +O +He ONe U53d by m@ny PHORum SOFTW@rE ti+Le\$. 0nCE 3N4BL3D +3H D1SpLAY oF Th3 s+4tS p49e caN b3 T09GL3d INdiv1Du@lLY 8y 3@Ch U53r. 1f +Hey dOn't wAn+ T0 SE3 1t +H3Y c4N h1d3 iT PhR0m ViEW.";
$lang['forum_settings_help_18'] = "peR\$0N4l M3ss@9ES Ar3 InV4LUA8LE @\$ 4 w4y 0Ph +@king M0r3 PRiv4+3 M4T+eRs OU+ Of vI3W 0pH +3H 0+Her m3mb3rS. hOW3vER 1pH j00 dON'+ W4NT YoUR Us3rS +O B3 48lE To \$3nd 3aCH 0TH3R P3RSONAl M3s\$4G3s J00 c4n Dis@bL3 +H15 OP+ioN.";
$lang['forum_settings_help_19'] = "p3r50N4L M3\$\$4G3s CAN @Lso cON+4In 4+T4CHMEn+s wh1CH C4N 8E US3FUL f0r 3Xch4nGinG ph1l3\$ b3TWE3N users.";
$lang['forum_settings_help_20'] = "<b>n0+e:</b> TeH SP4cE @llOcaT10n FOR pm @+t4chm3nTS I\$ +@kEN PHR0M E4CH us3rs' M4iN @+T4CHMENT @LlOca+10N @Nd iS n0T in ADd1T10n tO.";
$lang['forum_settings_help_21'] = "<b>eN48le guEST AcCOun+</b> @lL0wS V1siT0Rs T0 8ROw5e YoUr ph0RUM 4nD R34D PO5T5 WI+H0ut Re91s+er1nG @ UsER @cc0UN+. @ u\$ER 4cC0UN+ 15 \$tilL r3QUireD IPH THEY W15h To po\$+ Or ch4n9e uSER PR3PH3rENc35.";
$lang['forum_settings_help_22'] = "<b>l15+ 9U3\$+s 1n V1\$i+OR lo9</b> @lL0ws J00 tO \$P3CIPHY Wh3thEr or not uNr391\$+3r3d usERs 4r3 LIS+eD ON thE Vi\$iT0r Lo9 4L0nG\$iDe Re9IS+Er3d usErs.";
$lang['forum_settings_help_23'] = "b3EHIvE @Llow\$ @tt4cHMen+\$ T0 83 UPlo4DED +0 M3s\$@9e\$ when P0s+3d. 1f J00 hAV3 L1M1+3D we8 SP4cE j00 m4y Wh1ch +O dI\$@BL3 4tT@chMen+S bY cL34r1NG TH3 80x A8OvE.";
$lang['forum_settings_help_24'] = "<b>a++@chm3nT dir</b> i5 TEH L0CA+1On be3h1v3 Sh0ULD S+0r3 4++aChm3N+5 1n. th1S diRECt0RY mUS+ Exi\$+ 0N Y0Ur we8 sp4c3 4nD mU5+ B3 WRIt4BL3 By +h3 W3B \$erv3r / PHP PR0cESS oTHERwI\$E Upl04DS W1lL f41l.";
$lang['forum_settings_help_25'] = "<b>aT+@CHMEn+ 5p@C3 PER U\$er</b> i5 The M4xiMum 4M0un+ Of D1\$K SP4CE 4 USer H4S PhoR 4+T4CHM3n+\$. 0nC3 Th1s 5P4CE iS U\$3D Up +HE User C@nN0t UpLo@d 4nY MOr3 4++@ChMENTs. 8y DEF@uL+ THi\$ 1S 1M8 OF \$P4cE.";
$lang['forum_settings_help_26'] = "<b>aLloW emBedDiN9 oF 4++4chM3Nt\$ 1n MES5@9e\$ / S19n4tURE\$</b> 4lL0ws us3rS T0 EmB3d 4TT@cHm3n+\$ 1n P0s+S. eN48L1n9 +HIS OPTIon WH1l3 U\$3fUL c4N 1nCR3@S3 Y0uR bAnDw1D+h U5@9E DRA5+IC@Lly UNd3R cER+4IN COnfi9uR4+i0nS 0f php. iph J00 H@Ve L1mI+eD 8@nDwIDTH 1t 1s r3C0MmENDed TH4+ J00 D1s@Ble TH1\$ Opt1ON.";
$lang['forum_settings_help_27'] = "<b>uSE ALTerN4+1Ve 4tT@cHm3nT M3tHOd</b> f0Rc35 bE3hiV3 TO Us3 4n @LT3rN4T1v3 r3triEV@L mE+hOD phOR 4t+4CHm3NTS. ipH J00 ReCEivE 404 eRRor ME\$\$aG3s wh3N TRYin9 +o d0WNLOAd 4+T4CHMen+S FR0M Me\$\$@9e\$ tRY en48l1n9 TH1s 0ptION.";
$lang['forum_settings_help_28'] = "th3\$3 S3t+in95 All0w5 Y0uR PHORUm +O 83 sP1D3reD BY 534Rch 3n91nE5 L1KE 90o9l3, AL+4vIS+@ 4ND y4HOO. 1F j00 Sw1+Ch +Hi\$ oP+1oN OFf Y0Ur PHoRUM wilL N0+ 83 1ncludED iN +H3s3 53@RCH eN91N3S RE5uL+5.";
$lang['forum_settings_help_29'] = "<b>alLOW neW UsER Re91\$+R4+IONS</b> @LLOws OR dI\$@LLOW5 th3 Cr34+ioN OPH n3w u53r @cCOUn+5. 53t+IN9 +HE 0Pt1on T0 n0 coMPL3T3Ly DIS48lE\$ TH3 Re915+R4+1ON ForM.";
$lang['forum_settings_help_30'] = "<b>eN@BLe w1kIW1kI 1n+EGR4+iON</b> ProVIdE\$ wIKIw0RD Supp0rT 1n YOUR f0RUm pOS+S. 4 WIK1Word Is m@de up 0ph TWO OR Mor3 c0nC4tEN4T3d WORd\$ W1+h upPERc@\$3 l3tT3Rs (0pHTEn r3pHErrED t0 4\$ C@MelC@se). IF j00 wr1tE @ W0rD +h1s WaY 1+ W1lL Aut0m4+ic@LLY BE ch@n9eD 1nT0 4 HYP3RLinK P01N+1n9 t0 Y0ur choS3N wiKIW1ki.";
$lang['forum_settings_help_31'] = "<b>eN@Bl3 W1k1W1k1 QU1cK L1NK\$</b> en48LE5 TH3 U\$3 0ph m\$9:1.1 @Nd USER:l090n 5Tyl3 EX+ENdEd W1KiL1nKS WHIcH crE@Te hYP3rLINks t0 ThE SP3CIPh13D M3S\$@9e / US3R PR0phil3 0ph thE \$pEc1FI3D US3r.";
$lang['forum_settings_help_32'] = "<b>w1K1WIK1 L0C4+10n</b> 1\$ U\$3D +O SPeC1fY T3h ur1 of yOUr WIK1wIK1. WH3N 3nt3R1nG T3h UR1 US3 <i>%1\$s</i> t0 1nD1C4+3 WH3rE 1n +Eh URI t3h wik1wORD ShoULD @pp34r, 1.e.: <i>hT+P://EN.w1KIPeDI4.0rG/W1kI/%1\$S</i> wOulD Link YOur WIk1W0rD\$ T0 %s";
$lang['forum_settings_help_33'] = "<b>f0rUm @cC3s\$ s+4+US</b> C0ntroL5 hoW u53rs M4y 4Cce\$s y0ur pHOruM.";
$lang['forum_settings_help_34'] = "<b>oPEN</b> w1ll 4LL0w 4Ll U\$3R\$ 4nd 9UEST\$ @CcE\$S T0 y0ur pH0RUM wITHOUT rES+R1CTI0n.";
$lang['forum_settings_help_35'] = "<b>cL0\$3D</b> PR3ven+S 4CC3S\$ F0R 4lL u\$ERS, W1+H +3H EXCeP+10n OPh +3h AdMIn who M@Y sTILL @CCesS Th3 4Dmin P@Nel.";
$lang['forum_settings_help_36'] = "<b>r35TR1CTEd</b> All0wS +o set 4 li\$+ 0Ph usER5 who 4R3 4lL0wEd @cC35\$ t0 Y0UR F0rUm.";
$lang['forum_settings_help_37'] = "<b>p4\$\$WorD PROt3C+3d</b> 4Ll0wS J00 TO \$ET @ P@\$sW0RD +o 91vE 0U+ +o u53R\$ s0 +H3y C4n 4CCe5\$ yoUR foRum.";
$lang['forum_settings_help_38'] = "wh3n \$3TT1n9 R3\$+rIcteD 0r P45\$woRd PROt3c+3d M0DE j00 w1ll N33d T0 54VE yOUr Ch4n9ES bEPHor3 J00 C@n Ch4n9E +hE UsER 4CcESS Pr1VIl3g3S 0R P4\$\$w0rd.";
$lang['forum_settings_help_39'] = "<b>Search Frequency</b> defines how long a user must wait before performing another search. Searches place a high demand on the database so it is recommended that you set this to at least 30 seconds to prevent \"search spamming\"fR0m K1lLIn9 +h3 \$3rv3r.";
$lang['forum_settings_help_40'] = "<b>p0\$+ PHR3qUenCy</b> is +3H MIn1MUM T1m3 @ UseR mu5+ W@it 8eFORE th3y c4n Pos+ 4g41N. THI\$ 53T+IN9 @l\$0 4pHF3Ct\$ THE CrE@T10n 0Ph poLLS. \$3t +0 0 to D1\$a8lE +h3 R3s+R1cT1On.";
$lang['forum_settings_help_41'] = "teH @b0V3 OPTIOn5 ChaNGE T3h d3FaUL+ V4lU3S FOR +3h USER R39I5+R@+ioN Ph0RM. wH3rE 4PPl1c4bl3 0+hER 53t+ING\$ W1LL USe +H3 PH0rUM'\$ 0WN DeF4ul+ s3T+IN9\$.";
$lang['forum_settings_help_42'] = "<b>pReV3NT USE 0PH DupLIc@TE 3M41L 4ddr3sS3\$</b> phOrC3\$ B33h1V3 +O chEck +He uSEr 4cCoun+\$ 494In\$T +3H em4Il aDdR35\$ +h3 US3r is REGisTER1NG W1+H 4nD pr0mP+5 TH3m TO U\$3 4NOTH3r IPH iT IS @LRE4DY IN Use.";
$lang['forum_settings_help_43'] = "<b>requir3 EM@1l coNFIRM4T1ON</b> when En@Bl3D W1LL \$3nD @N Em@IL t0 34ch N3W USer wi+H a L1nK +H4t C@n 83 u\$Ed To conPHirM +HeIR eM@1l 4ddrESS. un+IL +hEY C0NFirM +H31r em4IL 4dDRe5\$ +Hey WILl NOT 83 A8l3 T0 POS+ uNl3S\$ TH31r US3r P3rMISS1oNS 4r3 CH@Ng3d m@Nu@lLY BY @N 4DM1n.";
$lang['forum_settings_help_44'] = "<b>us3 +3x+-C4PtCh4</b> PrESentS +H3 N3W US3r WITH 4 M4NgL3d im@Ge wHIcH THEY mU\$T Copy 4 NumB3r FROM 1NT0 a +3xT PH1eLd oN +eH ReGiS+R4+10n F0rM. U53 Th1S OP+ION +O PR3VENt 4U+0M4+3D S19N-UP vi4 SCRiP+\$.";
$lang['forum_settings_help_47'] = "<b>po\$t 3di+ 9r@ce PEr1OD</b> 4Ll0W\$ J00 +0 D3pH1N3 4 P3r1oD iN mINU+e5 wH3RE U\$3r\$ m4y 3D1+ P0s+\$ WI+hoU+ t3h '3d1teD By' t3X+ 4pPeaR1nG on thEIR poS+\$. 1ph Se+ T0 0 +HE 'EDitEd 8y' +3Xt w1lL 4lW4Ys 4PpE4R.";
$lang['forum_settings_help_48'] = "<b>uNr34d m3Ss4g3s CUt-0Ff</b> 5P3CIPh13s H0w L0nG me\$\$@9e\$ Rem4in UnrE4D. +HRe@Ds M0dIPh1Ed N0 L4+3r +H4n TH3 P3rI0d \$EL3c+3D W1LL 4u+0M4+ic@LLY 4PP34r 4\$ R3@d.";
$lang['forum_settings_help_49'] = "choo\$in9 <b>d1s48LE UnRe4D meSSA9E\$</b> wiLL c0MPl3T3lY R3M0vE UNRe@D m3S\$4G3s supPORt @nD rEmov3 tEh R3LEV4NT 0P+ION\$ PhR0M +3H D15CU\$\$iON TyPE dr0p d0WN on tHe tHrE4d LIS+.";
$lang['forum_settings_help_50'] = "<b>rEqu1r3 u53r @PPROV4l 8Y @dmIN</b> aLlOW\$ j00 +0 R35+R1CT ACCEs\$ By N3w uS3rS Un+1l +H3Y H4V3 8E3n 4pPR0VED 8Y @ m0d3rA+OR or aDM1n. w1+HOU+ 4PPrOV4L 4 U\$3R c4NNot 4CCEss any 4REA oph +3h 83eh1V3 fORUm 1nS+@LL@t1on 1NClUDINg iNd1v1DU@l F0rUM5, Pm 1n80x 4ND mY PHORUMS SECti0Ns.";
$lang['forum_settings_help_51'] = "u\$e <b>clOS3D M3S\$49E</b>, <b>re5+r1cTeD M3s\$@GE</b> @Nd <b>p4SsW0RD prOTEc+3d ME5\$4G3</b> +o Cu\$+oMIS3 teH M3S\$4G3 diSPL@YED WheN u\$3RS 4Cc3Ss y0uR foRum 1N t3h VARIoU\$ s+4+3s.";
$lang['forum_settings_help_52'] = "j00 CAn U\$3 h+ML 1n YOur mE\$\$@9e\$. HYpERL1nK\$ 4nD 3M41l 4DDR3s\$3S WILl 4l5o 8E 4U+OM4tIc4llY C0NVerT3d +O LInk5. TO U\$3 TH3 D3pH4UL+ 8e3H1VE F0rum M3\$s@9eS CL3@R +H3 FI3LDS.";
$lang['forum_settings_help_53'] = "<b>all0W uSers TO Ch4NG3 USerN@Me</b> p3RMI+\$ 4lRE4DY R3GiS+er3d U53r5 +O cH4nGE +hEir us3rnAM3. WHen en@bL3D j00 C@N tR4Ck tEh ch4n9e5 A U\$3R M@kE\$ T0 tH31r U\$3RnaM3 VI@ T3H 4dMIn US3r T0OL\$.";
$lang['forum_settings_help_54'] = "uSE <b>fORUM rule\$</b> T0 ENtER 4n 4cCEp+4BL3 u\$3 pol1CY +h4+ eaCh US3R Mu\$+ 49r33 +0 83Phor3 Reg15+EriN9 0N Y0UR PH0rum.";
$lang['forum_settings_help_55'] = "j00 c4N uSe HTMl in yOUr f0rUM ruLes. HYPerl1nk5 4ND Em4iL AdDRe5s3s WIll @Lso 83 4U+Oma+1C@LLY C0nV3r+3D +o LINk5. +O USE tEH d3PH4UL+ bE3h1v3 F0Rum @Up ClE4r +He pH1Eld.";
$lang['forum_settings_help_56'] = "u53 <b>nO-RepLY em@1L</b> +o SPEc1fY @N em@1l 4DDrE5\$ th@T d03s NOT 3XI\$T 0r WILl n0t 83 mon1+ORED PH0r REpl13\$. +H15 EM@1L 4DDR3s\$ wIll bE u\$3D in t3H h34d3r\$ PHOr 4lL em4iL5 s3n+ PHR0m Your pH0rUM 1NCLuDING BU+ N0t LIm1+3D +o POS+ 4ND pm N0+IFic4+I0nS, USER 3m41lS AnD P@S\$wOrD R3MiNDErs.";
$lang['forum_settings_help_57'] = "it 15 R3c0mm3ND3D TH4T j00 U\$3 4N 3m@il 4Ddr3s\$ tHa+ d0es NOt 3xiS+ t0 H3LP cU+ d0wN On \$p4M +h4+ m4Y bE dIREcTEd @T yoUR m4in FORum em4iL aDdR3ss";
$lang['forum_settings_help_58'] = "in 4dD1+10n T0 51mplE SPId3R1Ng, 833hIV3 C4n 4LsO 9en3R4tE @ S1+3m4p F0r +He Forum t0 M@Ke I+ e@s1er F0r S3@Rch 3N91N3s +0 FINd @Nd 1NDex +HE M35s@GE5 P0\$+3d by y0ur uSErS.";
$lang['forum_settings_help_59'] = "si+EM4p5 4R3 4u+0M4+Ic@lly 5aV3D +o THe s1+3mApS \$u8-D1RECt0RY oPH YOur b3ehiVe PH0rUM 1N\$+ALL4TiON. 1f +HI5 D1RECt0ry d035n'T 3x1st J00 MU\$+ cr3a+E 1+ 4ND 3NsUR3 TH@t 1+ 15 WR1t4ble 8y THe SERV3r / PHp pr0ces\$. +0 4Ll0w \$34RCh 3n91N3s T0 pH1nD youR S1+eM4p J00 mus+ @Dd +hE URL +O yOUR r08Ots.+x+.";
$lang['forum_settings_help_60'] = "d3P3Nd1Ng on SErv3r PErFoRM@nC3 4nD tH3 nUmB3r OPH foRUMs 4nD +hRe@DS yoUr B3ehive 1n5t4LL4TI0n coN+Ain5, 9EN3R@+ing @ s1+3mAP M4Y +4K3 sEV3rAL miNut3S +o COMPL3TE. 1f PErpHOrm@Nc3 0Ph YOur SErVEr iS 4dV3R5elY AFPhECtED i+ 1\$ r3c0mM3ND J00 D1S@8LE 9enER@t10n 0PH +3h 5I+3M4p.";
$lang['forum_settings_help_61'] = "<b>senD 3M@il n0T1phIc@+10n +O 9l0B@L 4DmIN</b> wH3n 3n4bLeD WIll \$End @n EM@1L to TH3 GLObaL Ph0RUm oWNeRs WH3N @ N3W U\$3r @cCOunT I\$ Cr34+3D.";
$lang['forum_settings_help_61'] = "enTeR Y0UR <b>go0GL3 4naLYticS @cc0uNT ID</b> HEr3 T0 3n@8l3 GOOGl3 4n4Lyt1C TR@ckIn9 0f YOUR f0rum. 9o0gL3 @N4Ly+1C\$ W1ll +R4CK viSI+ORS +o YOUR sit3 4nD ReC0rD HOW LOng +hEY s+4y 4Nd wh1CH P@9Es TH3Y V151T. bY V1\$it1n9 +h3 9oO9L3 4n@LY+ICs \$I+E YOUR C4N SeE An 0V3rv1ew 0F h0w y0uR PhORUM 1s Us3d.";
$lang['forum_settings_help_62'] = "If you do not have a Google Analytics Account you will need to sign up for one by clicking <a href=\"https://www.google.com/analytics/\" target=\"_blank\">here</4 >.";
$lang['forum_settings_help_63'] = "If you do not have a Google AdSense Account you will need to sign up for one by clicking <a href=\"https://www.google.com/adsense/\" target=\"_blank\">here</4 >.";
$lang['forum_settings_help_64'] = "iph J00 wi\$h +O en@blE or diS48LE goOGL3 aDs3N53 4dS On 4 p@RtiCul4r FORum J00 C4n DO So 8y VIs1+In9 +h4+ Ph0RUm'S FORum sEt+1nGS P493.";
$lang['forum_settings_help_65'] = "t0 CH4n9E 9oOGL3 @Dsen\$e @ccouNt Det41l\$ 4nD otH3r \$3TtiNG\$ PL34s3 Se3 9L08al f0RUm SE++1NG\$";

// Attachments (attachments.php, get_attachment.php) ---------------------------------------

$lang['aidnotspecified'] = "aId N0t SpEC1fIeD.";
$lang['upload'] = "uPLo4d";
$lang['uploadnewattachment'] = "uPl0@D N3w 4++4CHM3nt";
$lang['waitdotdot'] = "w@i+..";
$lang['successfullyuploaded'] = "suCC3s\$pHullY UpL0@D3D: %s";
$lang['failedtoupload'] = "f4ILEd T0 UPl0@D: %s. ChECk PHRe3 4++4CHM3NT \$P4cE!";
$lang['complete'] = "c0mPLE+3";
$lang['uploadattachment'] = "uPlO@d A fiLe PHOr 4tTAcHM3nT +O +3h M3S\$A9E";
$lang['enterfilenamestoupload'] = "eNTEr FIlEn4Me(\$) +0 uplO4D";
$lang['attachmentsforthismessage'] = "a++@chm3nT\$ FOR th1\$ mE5S@Ge";
$lang['otherattachmentsincludingpm'] = "otH3r 4++@chMen+s (INclUD1ng PM M3s5@93s 4nD OTH3r ForUMS)";
$lang['totalsize'] = "t0+4L S1zE";
$lang['freespace'] = "fRE3 5P@c3";
$lang['attachmentproblem'] = "therE W4\$ a prO8LEM d0wnLO4d1nG +hi\$ 4++4Chm3nT. plE@s3 try AGA1n L4+3r.";
$lang['attachmentshavebeendisabled'] = "at+acHm3nT5 h4vE 8E3N d15A8LED 8Y thE PH0RUM 0WNer.";
$lang['canonlyuploadmaximum'] = "j00 c4N ONly uploaD 4 M@X1mum OPH 10 FIlEs a+ 4 tIM3";
$lang['deleteattachments'] = "dEl3+3 4++@cHmen+S";
$lang['deleteattachmentsconfirm'] = "aRE j00 5uRE j00 W@nt +O D3lE+e +He s3l3CTeD A++4chMen+\$?";
$lang['deletethumbnailsconfirm'] = "arE j00 \$ur3 j00 W4Nt to d3LE+E +He S3leC+3D @tt4CHMen+\$ ThuM8N4iL\$?";
$lang['failedtodeleteallselectedattachments'] = "f41L3D TO deL3TE 4LL OPh +3h 53leCt3d @+T4CHMen+\$";
$lang['failedtodeleteallselectedattachmentthumbnails'] = "f@il3d +O d3lET3 4lL Of teh s3L3C+3d @TT@CHmen+ +huM8N4il5";

// Changing passwords (change_pw.php) ----------------------------------

$lang['passwdchanged'] = "p@s\$w0rD ch4N9eD";
$lang['passedchangedexp'] = "yoUR P@s\$woRD H4\$ b3En ch@NG3d.";
$lang['updatefailed'] = "upD4t3 PH4il3D";
$lang['passwdsdonotmatch'] = "pA5\$woRD\$ D0 n0t M@+CH.";
$lang['newandoldpasswdarethesame'] = "new @ND oLd Pa\$\$WorD\$ 4r3 +H3 S@Me.";
$lang['requiredinformationnotfound'] = "reQu1r3d 1NF0rm4+1oN N0+ PH0UND";
$lang['forgotpasswd'] = "f0rG0+ P4sSWOrD";
$lang['resetpassword'] = "rE\$3+ PA\$\$WorD";
$lang['resetpasswordto'] = "reS3T pa\$sw0rd +O";
$lang['invaliduseraccount'] = "inv4l1D u53r 4CC0uN+ SPec1fi3d. CHeCK 3M4iL FOR C0Rr3C+ linK";
$lang['invaliduserkeyprovided'] = "iNV4L1D Us3R K3y pr0vIdeD. Ch3Ck 3MaIL foR C0rr3ct liNK";

// Deleting messages (delete.php) --------------------------------------

$lang['nomessagespecifiedfordel'] = "no m3S\$Ag3 5p3C1fi3d phor DEl3t1ON";
$lang['deletemessage'] = "dEl3+3 MESS@g3";
$lang['successfullydeletedpost'] = "suCC3s\$pHully D3L3+ED pOST %s";
$lang['errordelpost'] = "eRR0r DelEtiN9 pos+";
$lang['cannotdeletepostsinthisfolder'] = "j00 Cann0T d3LEtE PostS in ThiS PHOlDER";

// Editing things (edit.php, edit_poll.php) -----------------------------------------

$lang['nomessagespecifiedforedit'] = "n0 ME5\$@g3 SP3c1fIEd PH0R 3ditiN9";
$lang['cannoteditpollsinlightmode'] = "c4NN0T Ed1+ p0lls iN Li9H+ M0DE";
$lang['editedbyuser'] = "edi+3d: %s bY %s";
$lang['successfullyeditedpost'] = "sUCceS\$pHULLY eDItED post %s";
$lang['errorupdatingpost'] = "eRR0r UPD@+1nG POST";
$lang['editmessage'] = "eD1+ Me\$\$aG3 %s";
$lang['editpollwarning'] = "<b>n0+E</b>: ED1+ING cER+41n @SPectS 0PH 4 POll wiLL V0ID 4LL teH CUrr3n+ Vo+3s 4nD @Ll0W p3OPLe +O V0+3 494IN.";
$lang['hardedit'] = "h4rD 3dIT 0PT1oN\$ (VO+E\$ WILL 8e RESE+):";
$lang['softedit'] = "s0ft 3d1+ op+I0n5 (votES W1LL 8e REt4INeD):";
$lang['changewhenpollcloses'] = "ch4N9e WHEn TH3 P0LL cl0s35?";
$lang['nochange'] = "n0 CH@n9E";
$lang['emailresult'] = "emaiL Resul+";
$lang['msgsent'] = "mEss49e \$3NT";
$lang['msgsentsuccessfully'] = "m3S\$a9e \$3NT sUcCE\$SPhULLY.";
$lang['mailsystemfailure'] = "mail 5YsTEM Ph41LUR3. M3s\$@9e Not s3n+.";
$lang['nopermissiontoedit'] = "j00 4re nOT PeRm1++3D +O ed1+ THis M3\$\$4G3.";
$lang['cannoteditpostsinthisfolder'] = "j00 C@nN0T Ed1+ p0S+S 1N ThIs Phold3R";
$lang['messagewasnotfound'] = "meSs4G3 %s W4\$ n0+ F0uNd";

// Email (email.php) ---------------------------------------------------

$lang['sendemailtouser'] = "s3nD EM41L to %s";
$lang['nouserspecifiedforemail'] = "no U53R 5PEc1FI3D PHOr 3m4iLin9.";
$lang['entersubjectformessage'] = "en+3r @ \$UbjeC+ FOR thE mE\$\$a93";
$lang['entercontentformessage'] = "eNt3R \$0ME C0nteN+ F0R +3H M3\$\$@9e";
$lang['msgsentfromby'] = "th15 Me\$\$@9e W4\$ sEN+ PHRom %s 8Y %s";
$lang['subject'] = "sU8j3c+";
$lang['send'] = "s3Nd";
$lang['userhasoptedoutofemail'] = "%s h45 op+3D 0uT 0F 3M41l coN+@c+";
$lang['userhasinvalidemailaddress'] = "%s h4S @N Inv4l1d em@1l @dDr35\$";

// Message nofificaiton ------------------------------------------------

$lang['msgnotification_subject'] = "mE\$\$4G3 n0+1fIc@+10n PHr0M %s";
$lang['msgnotificationemail'] = "hEllo %s,\n\n%s pOs+3d 4 me5\$4G3 T0 j00 0n %s.\n\ntHe sU8J3ct I\$: %s.\n\ntO rEAD Th4T mE5s@g3 4nD 0THeR5 1n teH S@Me DI\$Cu\$\$1oN, 90 +O:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nnOTE: 1F J00 D0 N0t WIsh T0 reC31V3 EM@Il N0+iPH1Ca+IONS oph F0rUm M3ss@G3s P0S+3d +O y0u, G0 t0: %s cLICK ON mY ConTROlS +HEN 3M41L @ND pr1vACY, Un53lEC+ tH3 EM4il NO+1PH1c4tI0n CheCK80x 4nD pr3S\$ \$UBMI+.";

// Thread Subscription notification ------------------------------------

$lang['threadsubnotification_subject'] = "sub\$CrIp+1On N0+iphiC@TioN PhRoM %s";
$lang['threadsubnotification'] = "hell0 %s,\n\n%s pOST3D @ Me\$\$@9e 1N @ ThrE@D j00 @RE sU8\$CRIbED +o 0N %s.\n\ntH3 sU8JECt IS: %s.\n\n+o Re4d +H4+ Me\$\$@9E 4nD 0THer5 in thE \$4M3 D1SCUSS1ON, 90 t0:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nnoTE: 1PH J00 d0 NOT W1\$h t0 rEceIVE 3m41l n0+IPH1C4TI0Ns oPh NEW ME\$5@9eS 1N TH15 THR3aD, g0 to: %s 4ND 4DjUs+ y0UR iN+ERES+ L3veL 4+ T3H 8OTTOM 0pH Th3 P@G3.";

// Folder Subscription notification ------------------------------------

$lang['foldersubnotification_subject'] = "sUB5cRIpt1On n0t1fIC@+ION fROM %s";
$lang['foldersubnotification'] = "hELL0 %s,\n\n%s p0s+ED 4 M3\$549E 1N 4 PH0lDer J00 @re 5UbsCRI8eD T0 0N %s.\n\n+He \$U8j3c+ I\$: %s.\n\nto R34d TH@T me5\$@9e 4nd o+HEr\$ 1N +3h \$aMe DI\$CU\$\$10n, G0 t0:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nn0+E: 1f j00 d0 noT WISh +0 R3c3iVE EM41L NotIphiC4+i0n5 OF N3w ME\$5@g3S 1n +HI\$ THR3@D, G0 t0: %s @nd 4dJU\$+ y0uR InTERES+ l3v3l 8y cl1cKIN9 0n tEH pHOLDER'5 iCOn @+ T3h T0P 0ph p4gE.";

// PM notification -----------------------------------------------------

$lang['pmnotification_subject'] = "pM N0t1F1C@+ION PHR0M %s";
$lang['pmnotification'] = "h3LLO %s,\n\n%s pOStEd 4 pM To J00 oN %s.\n\ntH3 sUbJEcT IS: %s.\n\n+0 R34D +3H mE5\$4G3 go t0:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nn0t3: IPh j00 D0 N0T W1sh +0 R3CEIv3 3m4iL Not1PhIcaTioN\$ OPH n3w PM MesS49es pOs+3d +0 Y0u, 90 T0: %s CLICk MY c0NTroLs thEN Em41L 4ND PRIV4CY, UN\$3LEC+ +h3 PM NotipH1c4+1ON ch3Ck8Ox aND PRe5\$ \$u8m1t.";

// Password change notification ----------------------------------------

$lang['passwdchangenotification'] = "p4s\$WorD cH4N9E n0+1f1c4t1on Fr0m %s";
$lang['pwchangeemail'] = "hElL0 %s,\n\n+HIS 4 n0+1fIc@+10n 3m4il t0 Inph0RM j00 +h4+ Y0UR P4s5wORD 0N %s H@S b33n ch4ngeD.\n\n1T H4\$ 833n ch4n93d T0: %s 4nd W4s Ch4N9ED 8Y: %s.\n\nIPh J00 H4vE ReCEiV3d TH1\$ 3M41l 1n 3rR0r OR wEr3 NOT exP3C+iNG 4 Ch@NG3 T0 Y0ur p4\$SwoRd pL3@s3 ConTaCT TH3 F0Rum 0wN3R or 4 mOD3r4+oR 0n %s 1mM3d1@+3Ly +O c0RR3c+ IT.";

// Email confirmation notification -------------------------------------

$lang['emailconfirmationrequiredsubject'] = "emaIL C0NPH1rM4+ION reQuIRED f0R %s";
$lang['confirmemail'] = "h3ll0 %s,\n\ny0u R3c3N+LY cr3@TEd @ NEw U\$3r ACcoUNt on %s.\n\n8EPhore j00 C4n 5+@R+ p0S+Ing w3 N3ed +0 CONFiRm yOur 3M4Il @dDR3s\$. Don'T W0rRY th1s I\$ QU1t3 E4sY. 4lL J00 N3ED t0 D0 1\$ cL1ck +3h l1NK beL0W (0R C0PY 4nd P@STe 1t INTO Y0uR 8rOW53r):\n\n%s\n\nonCE CONph1RM@+1on I\$ c0MPLEt3 j00 M@y l0g1N 4nD 5+@rT P0\$+in9 iMmEDIA+3LY.\n\niPh j00 DiD N0+ CR34T3 4 Us3R 4cCoUNT On %s pL34s3 4Cc3Pt 0ur @POl09135 4ND F0RW4rD +HIS 3m@1L TO %s \$0 THAT +H3 \$oUrc3 0ph 1+ M@Y 8E 1NVE\$+I94+Ed.";
$lang['confirmchangedemail'] = "h3ll0 %s,\n\ny0u R3CeNTLy Ch@N9Ed YouR EM@1L On %s.\n\nB3f0r3 J00 C@n \$+4r+ PO\$+1ng 494in wE nEED +O COnfIrm yoUR N3W 3m41l 4DDR3\$\$. Don't W0rry +H1s I\$ qUItE 34\$y. @ll j00 NEeD +O d0 i\$ Cl1Ck THE L1nK 83lOW (or C0pY 4nD p4\$t3 1t in+O yOUR 8rowsEr):\n\n%s\n\n0nCe CONFIrm4+i0N 1\$ COMPL3+E J00 m4y C0n+1nU3 T0 u53 th3 pH0ruM 4\$ n0Rm@L.\n\nif J00 Wer3 n0+ exp3c+iNG TH1s EMA1L PHR0m %s PLE4\$3 4ccEPT 0uR ApOlO91e\$ 4nD F0rw4rD THIs 3m@1l tO %s \$0 TH@+ thE S0urCe oPh i+ M4y BE 1nvEsT19@TED.";

// Forgotten password notification -------------------------------------

$lang['forgotpwemail'] = "hELlo %s,\n\nyOU ReQUE\$+3d th15 E-M@il phR0M %s b3c4Us3 J00 HAVe Phorgot+En Y0UR P@s\$w0Rd.\n\nCLIcK Teh l1NK B3l0w (0R C0PY 4Nd P@STE i+ 1NT0 y0UR 8ROW\$3R) t0 re\$3t YOur PA\$\$wORd:\n\n%s";

// Admin New User Approval notification -----------------------------------------

$lang['newuserapprovalsubject'] = "nEW u\$3r 4pPROVAL n0+1FiCA+ION pHOR %s";
$lang['newuserapprovalemail'] = "Hello %s,\n\nA new user account has been created on %s.\n\nAs you are an Administrator of this forum you are required to approve this user account before it can be used by it's owner.\n\nTo approve this account please visit the Admin Users section and change the filter type to \"Users Awaiting Approval\"oR CL1CK +h3 LINk BElOW:\n\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nnotE: OThER 4dMin15+R4+OR5 oN +h15 f0rum W1LL 4LsO R3C31v3 TH1s N0tIPH1c4+10n @nD M@y H4VE @Lr34DY @C+ed up0N +h15 REQUeST.";

// Admin New User notification -----------------------------------------

$lang['newuserregistrationsubject'] = "nEw U53R 4cC0un+ n0t1f1C@t10N PhoR %s";
$lang['newuserregistrationemail'] = "h3Ll0 %s,\n\n@ n3W uSER @ccounT H@\$ 833n cr3@tED ON %s.\n\nto vI3w +H1\$ UseR 4CCOUNT pl3@S3 Vi\$1t +HE ADm1n U\$ER\$ S3c+10N 4ND CLiCk On TH3 n3W USer or cLicK th3 L1nK 8elOW:\n\n%s";

// User Approved notification ------------------------------------------

$lang['useraccountapprovedsubject'] = "uS3R 4Ppr0V@l n0+if1C4+10N F0R %s";
$lang['useraccountapprovedemail'] = "hELlO %s,\n\ny0uR us3r @CC0uNT @+ %s H@s Be3N 4PpROV3D. j00 c@n lO91n 4nd \$+@rt poST1nG 1mM3DIA+3LY BY cL1cK1n9 th3 L1nK 8eL0W:\n\n%s\n\n1pH J00 W3RE n0+ exP3C+In9 +his EmAiL fr0m %s PL34Se @CCEP+ our @poL0913\$ 4nD F0RWARd TH1s EM@Il +o %s 5o TH4T Teh 50urce 0f 1+ MaY Be INVEST1gATEd.";

// Admin Post Approval notification -----------------------------------------

$lang['newpostapprovalsubject'] = "p05+ @pPROvaL n0t1f1c4+ION pHOR %s";
$lang['newpostapprovalemail'] = "h3lLo %s,\n\n4 nEw P0s+ H4\$ B33n cR34+3D ON %s.\n\n4\$ j00 ARe @ M0d3r@T0r on +His PHORuM J00 @Re ReqU1r3d T0 @PPr0VE +his p0\$+ b3pHOr3 1+ C@N 83 Re@D 8y 0tH3R US3r5.\n\ny0u C4N 4pPROVe Thi\$ po\$+ @nD @NY oTH3rS P3NDING 4PPr0V4l 8y Vis1t1n9 +3h 4DmIn POS+ 4PPR0v4L \$3ct10N 0pH Y0ur FOrUM 0R BY cl1CKIn9 +h3 L1NK 83LOw:\n\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nn0+3: O+HER ADM1n1\$tR@+oRs oN +H1s f0Rum W1Ll 4LS0 R3CeIV3 +hi\$ Not1Fic4+iOn 4nD m@Y H4vE AlRE4dY @CT3D UP0n +HiS REQUe5T.";

// Forgotten password form.

$lang['passwdresetrequest'] = "yOUr P4s\$w0rD ResEt rEQUE5T frOM %s";
$lang['passwdresetemailsent'] = "p4ssw0rd r3\$3+ e-m4iL \$3NT";
$lang['passwdresetexp'] = "j00 ShouLd 5h0r+LY rEcEIVe 4n 3-m@1l coNt4IN1NG INS+ruCtIoNS foR R3sE++1NG YouR P4\$\$WoRd.";
$lang['validusernamerequired'] = "a v4l1D USerN@Me 1s REqUir3D";
$lang['forgottenpasswd'] = "f0r9OT P@s\$wORD";
$lang['couldnotsendpasswordreminder'] = "c0uld NOT \$3ND p@sswORD r3m1NDer. PlEa5e coN+@c+ TH3 PH0RuM 0WNer.";
$lang['request'] = "r3qU3\$+";

// Email confirmation (confirm_email.php) ------------------------------

$lang['emailconfirmation'] = "eM41l CONfirm4TI0n";
$lang['emailconfirmationcomplete'] = "tH@NK j00 for coNF1rMING yoUR 3m4iL 4DdrE\$s. j00 M4y NOW lOGIn 4nD s+4r+ po\$TIN9 IMMEd14TELy.";
$lang['emailconfirmationfailed'] = "eM@IL coNFIrm@TIon ha\$ PH4iL3D, plE4\$e +rY @94IN l4+3R. 1PH j00 ENcoUntER ThiS ErR0r Mul+1PL3 tim3s PL34\$3 cONT@CT +hE PH0RUM oWN3r OR @ M0Der4+OR for @\$Si5+@NC3.";

// Links database (links*.php) -----------------------------------------

$lang['toplevel'] = "tOp l3vEL";
$lang['maynotaccessthissection'] = "j00 m4y NOT 4CCe\$\$ THIS SeC+1On.";
$lang['toplevel'] = "t0P lEV3l";
$lang['links'] = "link\$";
$lang['externallink'] = "eXt3RN4l Link";
$lang['viewmode'] = "vIeW M0De";
$lang['hierarchical'] = "hIER4RCHIc4L";
$lang['list'] = "lIsT";
$lang['folderhidden'] = "tH1\$ pHOLd3r 1s HIdD3N";
$lang['hide'] = "h1DE";
$lang['unhide'] = "unH1d3";
$lang['nosubfolders'] = "no \$u8pHOlD3r\$ in THI\$ CA+EgoRy";
$lang['1subfolder'] = "1 \$u8FOlD3r IN +H1\$ C@TEgORY";
$lang['subfoldersinthiscategory'] = "suBPh0LDEr\$ 1n TH1\$ CA+390ry";
$lang['linksdelexp'] = "eNTrI3\$ 1N A dELe+3d FOLd3R wILL bE M0vEd +0 tEh P4ren+ PH0LDEr. 0NlY F0ld3R\$ WH1ch D0 N0T coN+@In \$UBPHOlD3r\$ M@Y 8E d3LE+ED.";
$lang['listview'] = "l1s+ V1Ew";
$lang['listviewcannotaddfolders'] = "c4nnoT @dd f0LD3r5 IN TH1s VI3w. SH0WiN9 20 Entri3S 4t @ TIm3.";
$lang['rating'] = "r4+1N9";
$lang['nolinksinfolder'] = "nO LINK5 IN +His F0lDeR.";
$lang['addlinkhere'] = "adD L1nK hEr3";
$lang['notvalidURI'] = "th@t I\$ N0+ 4 V4lId URI!";
$lang['mustspecifyname'] = "j00 MUS+ sp3CIPhy 4 N4M3!";
$lang['mustspecifyvalidfolder'] = "j00 mUST 5P3CIPHy 4 v4LId F0LD3r!";
$lang['mustspecifyfolder'] = "j00 mUS+ sPEC1PHY 4 PHOLd3r!";
$lang['successfullyaddedlinkname'] = "sUcCE5sPHULLy 4DD3D LINk '%s'";
$lang['failedtoaddlink'] = "f41L3d T0 4dD L1nK";
$lang['failedtoaddfolder'] = "f4iLEd t0 4dD f0lD3R";
$lang['addlink'] = "aDD 4 LINk";
$lang['addinglinkin'] = "aDDING liNk in";
$lang['addressurluri'] = "adDress";
$lang['addnewfolder'] = "add a NEW F0lDeR";
$lang['addnewfolderunder'] = "add1Ng New PH0lDer unDer";
$lang['editfolder'] = "edI+ F0ld3R";
$lang['editingfolder'] = "eD1TIN9 PHolD3r";
$lang['mustchooserating'] = "j00 MU\$+ ch00s3 4 R@t1N9!";
$lang['commentadded'] = "y0ur comm3NT wa5 4dD3D.";
$lang['commentdeleted'] = "c0mm3nT Wa5 DeLET3D.";
$lang['commentcouldnotbedeleted'] = "c0MmeNt C0uld NOT 83 D3lE+3D.";
$lang['musttypecomment'] = "j00 mU\$t tYP3 a c0MMen+!";
$lang['mustprovidelinkID'] = "j00 MU\$+ prOVIdE @ l1NK 1D!";
$lang['invalidlinkID'] = "iNV4lId L1NK 1D!";
$lang['address'] = "addr3s\$";
$lang['submittedby'] = "sUBmi+t3D 8y";
$lang['clicks'] = "cliCKS";
$lang['rating'] = "r4+in9";
$lang['vote'] = "v0t3";
$lang['votes'] = "vo+3\$";
$lang['notratedyet'] = "n0+ R4+3d By 4Nyon3 y3+";
$lang['rate'] = "r@+3";
$lang['bad'] = "baD";
$lang['good'] = "gO0d";
$lang['voteexcmark'] = "v0+3!";
$lang['clearvote'] = "cL3@r VOTE";
$lang['commentby'] = "c0mmEn+ By %s";
$lang['addacommentabout'] = "aDd a C0mm3nT AbOU+";
$lang['modtools'] = "mOd3r4+10N +00LS";
$lang['editname'] = "edi+ n4m3";
$lang['editaddress'] = "eD1t 4DDR3Ss";
$lang['editdescription'] = "ediT D3SCrIPTion";
$lang['moveto'] = "m0V3 To";
$lang['linkdetails'] = "lINk dE+@1LS";
$lang['addcomment'] = "aDd C0mm3n+";
$lang['voterecorded'] = "y0ur v0t3 h4\$ BE3n R3C0rD3D";
$lang['votecleared'] = "youR VO+3 h@s B33n cl3@RED";
$lang['linknametoolong'] = "l1NK N@M3 +00 L0Ng. M@xIMUm 1s %s CH4r4cTEr\$";
$lang['linkurltoolong'] = "l1Nk UrL +0o LONG. M4xImUM 1s %s cH4R@C+3RS";
$lang['linkfoldernametoolong'] = "f0Ld3r n@ME +oO l0NG. m@ximUM l3N9TH IS %s CH4r4CTER\$";

// Login / logout (llogon.php, logon.php, logout.php) -----------------------------------------

$lang['loggedinsuccessfully'] = "j00 L0993D 1n \$ucCes5pHuLlY.";
$lang['presscontinuetoresend'] = "pr3S5 C0n+INuE T0 R3\$3nD phORM da+a Or C4Nc3L +o REl04d p493.";
$lang['usernameorpasswdnotvalid'] = "t3H u53Rnam3 0r p@\$\$w0rd j00 SUPPLIED 1s NOT V4LID.";
$lang['rememberpasswds'] = "r3m3Mb3R p45SwoRd\$";
$lang['rememberpassword'] = "rEMEm83r P4\$\$w0rD";
$lang['enterasa'] = "ent3r 4s a %s";
$lang['donthaveanaccount'] = "don'T H@Ve AN 4Cc0uN+? %s";
$lang['registernow'] = "rE91S+3R NOW";
$lang['problemsloggingon'] = "pr08l3MS l0gGiNG 0N?";
$lang['deletecookies'] = "d3LetE CoOK13S";
$lang['cookiessuccessfullydeleted'] = "co0k1e\$ suCC3s5pHUllY d3L3+3d";
$lang['forgottenpasswd'] = "f0r9OT+3n YOur p@\$5woRd?";
$lang['usingaPDA'] = "usIn9 4 PD4?";
$lang['lightHTMLversion'] = "lIgHT HTmL VerS1ON";
$lang['youhaveloggedout'] = "j00 H@ve L0g9eD 0Ut.";
$lang['currentlyloggedinas'] = "j00 @R3 CurR3nTLY l0g9eD In 4\$ %s";
$lang['logonbutton'] = "loGON";
$lang['otherdotdotdot'] = "otheR...";
$lang['yoursessionhasexpired'] = "your 53S51oN h@5 3Xp1R3d. j00 wILL N3ED t0 LO9iN 4g4in to CONTINU3.";

// My Forums (forums.php) ---------------------------------------------------------

$lang['myforums'] = "my f0rUMs";
$lang['allavailableforums'] = "aLL 4V4il@Ble pHORumS";
$lang['favouriteforums'] = "f4vOUR1+3 PH0rUM\$";
$lang['ignoredforums'] = "i9n0reD F0RUMS";
$lang['ignoreforum'] = "igNoRE f0RUm";
$lang['unignoreforum'] = "unI9NOR3 F0RUM";
$lang['lastvisited'] = "l@s+ Visi+Ed";
$lang['forumunreadmessages'] = "%s UnR34d M3s5@9E\$";
$lang['forummessages'] = "%s mess49es";
$lang['forumunreadtome'] = "%s UNR34D &quot;+O: ME&quot;";
$lang['forumnounreadmessages'] = "nO UNRe@D m3s\$4935";
$lang['removefromfavourites'] = "r3mOv3 PHRom f4vOURitE\$";
$lang['addtofavourites'] = "adD +0 FAVoUr1T3s";
$lang['availableforums'] = "aV4IL48LE F0rUMS";
$lang['noforumsofselectedtype'] = "thEr3 4re N0 F0RUMs OF th3 S3lEcTEd +YP3 4v@1l48lE. pL34\$3 SEl3c+ A d1pHPHer3N+ +yp3.";
$lang['successfullyaddedforumtofavourites'] = "sUCc3SsPHUllY @DD3D phORum t0 f@VOurIte\$.";
$lang['successfullyremovedforumfromfavourites'] = "sUcc3\$\$PHulLY rEM0v3d PhORUM frOM f4voUR1+3s.";
$lang['successfullyignoredforum'] = "suCCe\$\$phullY i9n0rED f0RUm.";
$lang['successfullyunignoredforum'] = "sUcC3\$\$FULLY UNI9N0red FORum.";
$lang['failedtoupdateforuminterestlevel'] = "f@1L3D T0 UPD@tE pHORum INtErE5+ L3V3L";
$lang['noforumsavailablelogin'] = "th3r3 4r3 No F0rUMS 4v@ILa8LE. Pl34\$3 L091N +0 vIew Y0uR FORuMs.";
$lang['passwdprotectedforum'] = "p4s\$worD ProTECt3d PHORum";
$lang['passwdprotectedwarning'] = "tH15 ForuM 1s P4\$\$wOrd pROT3C+3D. T0 G@1N @cCE\$s eN+3R +HE pa5\$woRd 83l0w.";

// Message composition (post.php, lpost.php) --------------------------------------

$lang['postmessage'] = "po5T m3\$\$493";
$lang['selectfolder'] = "s3L3C+ FOLd3r";
$lang['mustenterpostcontent'] = "j00 MuS+ enT3R 50mE c0Nt3n+ pH0r +3h pO\$+!";
$lang['messagepreview'] = "m35\$4Ge pR3vIEw";
$lang['invalidusername'] = "iNValiD UsErN4m3!";
$lang['mustenterthreadtitle'] = "j00 MUS+ ENTeR 4 T1+L3 FOR tHe THRe4D!";
$lang['pleaseselectfolder'] = "pL3@SE S3l3c+ 4 FOLder!";
$lang['errorcreatingpost'] = "eRrOR Cr34+1Ng po5+! PL3@S3 tRY 494IN 1N 4 PHEW minU+35.";
$lang['createnewthread'] = "cR34+E New thrE4d";
$lang['postreply'] = "pO5+ R3pLY";
$lang['threadtitle'] = "thrEAd T1+l3";
$lang['foldertitle'] = "f0ldEr +1tL3";
$lang['messagehasbeendeleted'] = "mE5s49e Not F0UND. CHeCk +h4+ 1+ h4\$n'T 8E3n D3le+3d.";
$lang['messagenotfoundinselectedfolder'] = "m3S\$ag3 N0+ F0UnD 1N S3l3Ct3D Fold3r. cH3CK +hAT iT h@SN't 8e3N MOV3D OR d3l3TED.";
$lang['cannotpostthisthreadtypeinfolder'] = "j00 C4nNOT POS+ THIS +Hre4D TYpE 1n +H4T FolD3R!";
$lang['cannotpostthisthreadtype'] = "j00 C@nnO+ P0s+ +HIs thrE4d +ypE @\$ TH3rE 4R3 NO AV@ilA8L3 FOLD3RS TH@T 4lloW I+.";
$lang['cannotcreatenewthreads'] = "j00 C4nn0t Cr3@+3 n3w THRE4D5.";
$lang['threadisclosedforposting'] = "tH1\$ +HReAD 1\$ Clos3d, J00 C4NNOT poST 1N IT!";
$lang['moderatorthreadclosed'] = "w@rNiN9: TH1\$ ThR34d 1\$ cLOS3d PhoR P0S+ING T0 NORm4L u\$3RS.";
$lang['usersinthread'] = "us3R\$ in thR34d";
$lang['correctedcode'] = "c0rReC+eD coDE";
$lang['submittedcode'] = "sUBM1++3d c0D3";
$lang['htmlinmessage'] = "h+Ml In m3sS@9e";
$lang['disableemoticonsinmessage'] = "dIsA8L3 EM0t1CON\$ in mES549e";
$lang['automaticallyparseurls'] = "au+oM@+iC@llY p@RS3 URl5";
$lang['automaticallycheckspelling'] = "aUtOM4+Ic@LLY CheCK 5Pell1n9";
$lang['setthreadtohighinterest'] = "s3+ +HRe4d +o h1gH 1nTERe\$+";
$lang['enabledwithautolinebreaks'] = "eNA8l3d WI+H AuT0-L1nE-bRE4kS";
$lang['fixhtmlexplanation'] = "tH1\$ PHORum us3s H+ML filt3r1n9. YOur \$U8m1t+3D HTml H@s bE3n M0d1fi3d 8y +HE pH1lTErS 1n \$oM3 w4Y.\\n\\nTo VIew Y0uR 0rIG1N4l c0D3, SElECT +3h \\'Su8MIt+3d c0dE\\' r@Dio 8uTtON.\\nto V1ew TH3 M0dIPH13d c0D3, SeL3c+ THE \\'coRR3cT3d cod3\\' R@Dio 8u++On.";
$lang['messageoptions'] = "me\$\$493 0p+1On5";
$lang['notallowedembedattachmentpost'] = "j00 4r3 NoT 4lL0WED +0 EM8ED @TT4CHMenT5 1n YOuR posTs.";
$lang['notallowedembedattachmentsignature'] = "j00 aRE noT 4llow3d TO eMB3D A++@CHMEnts iN Your 5I9N4+Ure.";
$lang['reducemessagelength'] = "mE\$\$@9e l3n9Th mU\$+ b3 UNdER 65,535 ch@r4ctEr5 (cURRenTLY: %s)";
$lang['reducesiglength'] = "si9N4tUR3 L3nG+h must 83 UNdER 65,535 Ch@R4CT3r\$ (CuRr3nTLy: %s)";
$lang['cannotcreatethreadinfolder'] = "j00 c@nN0T cR3@TE n3W +HR3@DS IN +Hi\$ foLd3R";
$lang['cannotcreatepostinfolder'] = "j00 C4Nn0+ R3pLY T0 pOS+s 1n +HI5 F0lDER";
$lang['cannotattachfilesinfolder'] = "j00 cANn0T posT 4+t@CHMEn+\$ 1n +h1\$ F0lDEr. r3M0vE 4T+aChm3NTS +o C0N+1NuE.";
$lang['postfrequencytoogreat'] = "j00 C4n ONLY p0\$t 0nCE 3V3rY %s sec0nD5. PLE4S3 +Ry 4G@In L@+3r.";
$lang['emailconfirmationrequiredbeforepost'] = "em@1l CONPH1rM4+ION IS ReqU1r3d 83f0re j00 C4N P0\$t. IF j00 h4vE nOT REcE1V3d @ ConF1RM@+10n EM4Il Pl34\$3 cl1Ck t3h bUTT0N 83loW @nd A NEW 0NE wiLL b3 s3N+ +O yoU. 1pH Y0UR EMaiL 4DDr3\$5 NE3d\$ Ch@n91n9 PLE@s3 D0 SO b3Ph0Re REQuE\$+ING @ n3W ConfirmaTION EMAIL. J00 m4Y CH4n9E yOUR EM@IL 4DDRE\$\$ 8Y CLIck mY CONTR0ls 48Ov3 aNd +h3n uSEr Deta1l\$";
$lang['emailconfirmationfailedtosend'] = "c0NfIrmatioN 3m@IL f4iL3D T0 s3nD. plEa53 Con+@c+ th3 F0rum 0wn3R +o ReC+IPHY THIs.";
$lang['emailconfirmationsent'] = "cOnPHIRm4+ION 3M4iL HA\$ 833N re53nt.";
$lang['resendconfirmation'] = "resENd C0nf1RM4+10n";
$lang['userapprovalrequiredbeforeaccess'] = "yOUR User 4cCOun+ NE3D\$ T0 8e 4pPROVED 8y @ ph0rUm @Dm1N 8EFOR3 J00 C@n 4Cc3S\$ +3h reqUe\$+3d foRUM.";
$lang['reviewthread'] = "rEvIew THR3@d";
$lang['reviewthreadinnewwindow'] = "reV13w en+irE THre4D IN N3W W1nd0W";

// Message display (messages.php & messages.inc.php) --------------------------------------

$lang['inreplyto'] = "iN replY +0";
$lang['showmessages'] = "shOW m3SS4g3s";
$lang['ratemyinterest'] = "ra+3 My 1nt3r3\$+";
$lang['adjtextsize'] = "adjUS+ T3x+ 5iZE";
$lang['smaller'] = "sMALL3r";
$lang['larger'] = "l4rger";
$lang['faq'] = "faQ";
$lang['docs'] = "d0cS";
$lang['support'] = "suppORt";
$lang['donateexcmark'] = "dONA+E!";
$lang['fontsizechanged'] = "fOn+ S1Z3 Ch4N9eD. %s";
$lang['framesmustbereloaded'] = "fR4me\$ MU\$+ b3 rEL04dED m@NU@lLY +o S3E ch4N9es.";
$lang['threadcouldnotbefound'] = "tH3 rEQUE\$+eD THRE@D cOULd NO+ bE F0UND 0r @CcE\$\$ w@S dEnIEd.";
$lang['mustselectpolloption'] = "j00 MUS+ SEl3c+ 4n Op+ion +0 V0+3 F0R!";
$lang['mustvoteforallgroups'] = "j00 mU\$+ V0+E 1n 3vERy 9R0uP.";
$lang['keepreading'] = "kE3P rE4d1n9";
$lang['backtothreadlist'] = "b4cK TO +hr3@d l1sT";
$lang['postdoesnotexist'] = "tH@t POS+ D03s N0t 3x1ST IN +Hi\$ thre4D!";
$lang['clicktochangevote'] = "cl1CK +O cH4n9e vote";
$lang['youvotedforoption'] = "j00 v0tED F0r 0pTIOn";
$lang['youvotedforoptions'] = "j00 VOTeD f0R OPtIoN5";
$lang['clicktovote'] = "cl1ck +O VOTe";
$lang['youhavenotvoted'] = "j00 H4v3 Not V0tEd";
$lang['viewresults'] = "v1EW r3SuLTs";
$lang['msgtruncated'] = "m3\$5Age +RUnC4+3d";
$lang['viewfullmsg'] = "vIEW phUll M3s\$A9e";
$lang['ignoredmsg'] = "i9NORed M3s\$@9E";
$lang['wormeduser'] = "w0rmED U53r";
$lang['ignoredsig'] = "i9noR3D \$I9n4+ur3";
$lang['messagewasdeleted'] = "m35\$ag3 %s.%s W4\$ DElE+3D";
$lang['stopignoringthisuser'] = "s+0P IGn0RIn9 THI\$ useR";
$lang['renamethread'] = "r3n4mE THr34d";
$lang['movethread'] = "m0Ve +HRE@D";
$lang['torenamethisthreadyoumusteditthepoll'] = "t0 R3naM3 tHIS Thr34d J00 mu\$t 3DI+ tHe pOLL.";
$lang['closeforposting'] = "cl0\$3 PHor P0S+1nG";
$lang['until'] = "uN+iL 00:00 UtC";
$lang['approvalrequired'] = "aPpROVAL rEqUir3D";
$lang['messageawaitingapprovalbymoderator'] = "mess@9e %s.%s I\$ @w4it1N9 @PProV4L 8y @ m0d3RA+or";
$lang['successfullyapprovedpost'] = "suCC3s5PhULLY 4pPROVEd Pos+ %s";
$lang['postapprovalfailed'] = "pOS+ APprOV4l fail3D.";
$lang['postdoesnotrequireapproval'] = "pos+ d0ES NO+ REQUir3 4pPR0V@L";
$lang['approvepost'] = "aPpRoV3 POS+";
$lang['approvedbyuser'] = "apProV3d: %s BY %s";
$lang['makesticky'] = "maK3 S+1CKY";
$lang['messagecountdisplay'] = "%s 0F %s";
$lang['linktothread'] = "p3rM@NEnt LInK +o +hiS ThrE4D";
$lang['linktopost'] = "l1nk +o PO\$+";
$lang['linktothispost'] = "lINk +0 Th1\$ P0s+";
$lang['imageresized'] = "tH1\$ IM493 H@s b33N rE5iZeD (0ri91n4l 5iZe %1\$\$X%2\$\$). T0 VI3w +3h PHuLL-5IZE 1M@93 Cl1ck h3RE.";
$lang['messagedeletedbyuser'] = "mess@9e %s.%s DeL3t3d %s By %s";
$lang['messagedeleted'] = "meSS@G3 %s.%s W@\$ D3lE+Ed";
$lang['viewinframeset'] = "vIeW 1n PHR4m3s3T";
$lang['pressctrlentertoquicklysubmityourpost'] = "pR3S\$ C+rL+3n+er +O qU1CKly SUbM1+ Y0UR p0ST";
$lang['invalidmsgidornomessageidspecified'] = "iNv4l1d Me5Sag3 Id 0r NO M3\$s@9e 1D SPeC1fIEd.";

// Moderators list (mods_list.php) -------------------------------------

$lang['cantdisplaymods'] = "cANNOT D1SpL@Y FOLD3r MoD3r4+orS";
$lang['moderatorlist'] = "mOD3r4+or LIs+:";
$lang['modsforfolder'] = "m0d3R4+0rS PHOr F0Ld3R";
$lang['nomodsfound'] = "no MoD3R4+oRS F0uNd";
$lang['forumleaders'] = "forUM Le@Der\$:";
$lang['foldermods'] = "f0lDER moD3r4t0R\$:";

// Navigation strip (nav.php) ------------------------------------------

$lang['start'] = "sT@RT";
$lang['messages'] = "mE\$s49E\$";
$lang['pminbox'] = "inB0x";
$lang['startwiththreadlist'] = "s+4R+ P49e W1th THre4d L1\$+";
$lang['pmsentitems'] = "senT I+3mS";
$lang['pmoutbox'] = "ou+BOX";
$lang['pmsaveditems'] = "s4vED IteM\$";
$lang['pmdrafts'] = "dRAPH+S";
$lang['links'] = "l1nk\$";
$lang['admin'] = "aDMiN";
$lang['login'] = "logIN";
$lang['logout'] = "l090uT";

// PM System (pm.php, pm_write.php, pm.inc.php) ------------------------

$lang['privatemessages'] = "pr1V@+3 m3s\$49E5";
$lang['recipienttiptext'] = "s3p4R4+E R3CIP13nTS 8y 53m1-c0L0N 0r C0mm4";
$lang['maximumtenrecipientspermessage'] = "tHEr3 1\$ @ liM1t OpH 10 rEcip1eN+S pEr m3s5@9e. Pl3@S3 4m3nD y0UR rEc1PI3n+ l1St.";
$lang['mustspecifyrecipient'] = "j00 MUS+ spEc1FY 4T l3A\$+ 0nE rEcIp1eN+.";
$lang['usernotfound'] = "uSeR %s N0+ F0uNd";
$lang['sendnewpm'] = "s3Nd N3W PM";
$lang['saveselectedmessages'] = "s4V3 sELEc+eD m3S\$@9E\$";
$lang['deleteselectedmessages'] = "d3l3tE s3lEc+3d M35\$4G3s";
$lang['exportselectedmessages'] = "export SELeCTed M3s5@93\$";
$lang['nosubject'] = "no \$ubj3C+";
$lang['norecipients'] = "n0 r3C1piEnt\$";
$lang['timesent'] = "tIm3 S3n+";
$lang['notsent'] = "nO+ sEN+";
$lang['errorcreatingpm'] = "erROR CRE4+IN9 PM! Pl3@s3 +RY A94in in 4 PH3w m1nuTe\$";
$lang['writepm'] = "wR1+E mess@93";
$lang['editpm'] = "eD1+ ME5\$aG3";
$lang['cannoteditpm'] = "caNno+ eD1t +h1s PM. I+ h@\$ 4lrE4DY b33N VIew3d 8y THe REC1PIEnT or +he M35s493 doES Not 3X1S+ 0R 1+ 15 1nACc3S\$iblE BY J00";
$lang['cannotviewpm'] = "c@NNOT V1Ew PM. M3Ss49E D03s nO+ exI\$+ OR 1T is 1n4CcE5\$iBlE By J00";
$lang['pmmessagenumber'] = "m3s54ge %s";

$lang['youhavexnewpm'] = "j00 H@vE %d nEW mE\$\$ag3s. w0uLd J00 LIK3 t0 Go +0 y0uR 1nb0x n0w?";
$lang['youhave1newpm'] = "j00 h@V3 1 nEW M3s\$a9e. W0uLd J00 L1KE +0 9o +o YoUR INB0x N0W?";
$lang['youhave1newpmand1waiting'] = "j00 H4v3 1 N3w M3ss49E.\n\ny0u 4lsO H@vE 1 M3S\$4G3 4w@1TINg D3L1VERY. tO ReC31v3 THI\$ MESS493 pLe@\$3 CLe@R 5OmE \$P4CE in YOur 1N80X.\n\nwoULd J00 Lik3 t0 G0 TO Y0UR 1N8ox NOw?";
$lang['youhave1pmwaiting'] = "j00 H4VE 1 ME5\$@9E 4WAI+1NG d3L1v3rY. +0 R3C31V3 +H15 ME\$\$4G3 pLE@s3 CLe@R 5OME \$p4cE In YOUr in8Ox.\n\nw0ulD j00 LikE to 9O TO Y0uR In8OX NOW?";
$lang['youhavexnewpmand1waiting'] = "j00 H4V3 %d New m3Ss4g3s.\n\nyOU @LSO h@Ve 1 Mess@93 4W@1tING dEL1v3rY. +0 R3C3IvE +H1\$ mE\$\$@9e pL3@s3 cl3aR 50mE SP4cE 1n Y0UR InBOx.\n\nwOULd J00 LIK3 +o 90 +o YOUR iN8OX N0W?";
$lang['youhavexnewpmandxwaiting'] = "j00 h4ve %d NEw mE\$\$ag3s.\n\ny0u @LSO H@v3 %d M3s5@9E\$ @W41tiN9 D3l1v3rY. T0 REc3IVE tHES3 m3\$\$A9e PLE@s3 CL34r 5oM3 \$p4ce 1n YOUr 1nB0x.\n\nwoULd j00 LIk3 T0 G0 t0 Y0ur 1NBOX noW?";
$lang['youhave1newpmandxwaiting'] = "j00 H4v3 1 NEW mESS@93.\n\ny0u 4L\$o HAV3 %d M3sS493s 4w@1+1Ng D3Liv3ry. +0 R3C31v3 +HesE Mes5@GE\$ PL34\$3 CLE@r S0mE SPACE 1n Y0ur 1N8oX.\n\nwoulD J00 l1k3 +O 9O T0 Y0uR 1nBox N0w?";
$lang['youhavexpmwaiting'] = "j00 h4v3 %d mess@g3\$ 4w@1+iN9 d3LIvERY. t0 r3C31V3 +H3s3 M3\$\$@9e5 PL34sE cLE@r S0ME SP4Ce 1n Y0uR 1N8ox.\n\nwoulD j00 L1K3 +O 90 T0 Y0uR 1n8oX N0W?";

$lang['youdonothaveenoughfreespace'] = "j00 DO n0+ HAv3 En0u9H FR3E \$P4CE t0 53nd +h1S M3s\$4G3.";
$lang['userhasoptedoutofpm'] = "%s h45 0pTEd 0U+ 0PH R3cEIV1NG PErsOn4L m3S\$@GEs";
$lang['pmfolderpruningisenabled'] = "pm f0lD3R prun1ng 1s 3n@bL3D!";
$lang['pmpruneexplanation'] = "thi\$ PhORUm U\$ES PM ph0lDer PRUN1N9. THe MEss49ES J00 havE \$+ORED IN yoUR 1Nbox 4nD \$3NT i+EmS\\nf0LD3rS 4r3 SUbJECt +O 4u+0M4+1C dEL3tI0N. 4NY m3s\$Ag3s j00 W1SH T0 k33p \$hoULd B3 M0VEd +0\\nYOUR \\'S4V3d itEM\$\\' phOLD3r SO +H4T tHey @Re NOT dEL3TED.";
$lang['yourpmfoldersare'] = "yOUR Pm folD3r\$ 4rE %s phULL";
$lang['currentmessage'] = "cUrREN+ me5\$age";
$lang['unreadmessage'] = "unR3@d m3sS49e";
$lang['readmessage'] = "rE4D MESS@9E";
$lang['pmshavebeendisabled'] = "p3R\$on4l M3s5@9e\$ H4v3 833N d15@BLED 8Y +3H ForUm 0wN3r.";
$lang['adduserstofriendslist'] = "add US3rS T0 YouR PhRIENd\$ l1\$+ T0 H4V3 thEm 4ppEAR 1N A DROP DOwn ON +hE pM WR1+E ME5\$@9e P4g3.";

$lang['messagewassuccessfullysavedtodraftsfolder'] = "mes5@9e w4\$ sUCc3S5Phully s4v3d T0 'dr4pHTS' f0LDeR";
$lang['couldnotsavemessage'] = "c0ulD NOT \$4v3 M3s\$49e. M4ke surE J00 H4VE ENouGH 4V4IL@blE frE3 SP4CE.";
$lang['pmtooltipxmessages'] = "%s m3\$\$49e5";
$lang['pmtooltip1message'] = "1 ME\$\$@93";

$lang['allowusertosendpm'] = "aLLow USEr +0 S3ND P3rsONal MEss49ES +O M3";
$lang['blockuserfromsendingpm'] = "bL0ck u53R fRom \$3Nd1NG pER50n4l Me5\$@9es +O Me";
$lang['yourfoldernamefolderisempty'] = "y0uR %s folD3r 1s empTY";
$lang['successfullydeletedselectedmessages'] = "suCC3sSfUlly DEle+3d \$3lECT3D M3sS@GE5";
$lang['successfullyarchivedselectedmessages'] = "sUccESSPHully 4rCHIVeD seL3C+3d mess49e5";
$lang['failedtodeleteselectedmessages'] = "fa1l3d tO D3Let3 SeL3C+3d M3s\$493S";
$lang['failedtoarchiveselectedmessages'] = "faIl3D +O 4Rch1v3 S3L3ct3D M3sS4g3\$";
$lang['deletemessagesconfirmation'] = "aRe J00 sURe J00 w4n+ T0 d3L3+3 @ll OPH +3H SEL3C+3D M3s\$@9E\$?";
$lang['youmustselectsomemessages'] = "j00 Mu\$+ S3lEc+ SOMe ME\$\$@9e\$ T0 pR0CES\$";
$lang['successfullyrenamedfolder'] = "sUccEsSFulLY Ren@MEd FOLd3r";

// Preferences / Profile (user_*.php) ---------------------------------------------

$lang['mycontrols'] = "my CONTroLS";
$lang['myforums'] = "my PHorum\$";
$lang['menu'] = "mEnU";
$lang['userexp_1'] = "usE TH3 M3nu oN THe Lef+ +o M@N493 yOUR 53T+1nG5.";
$lang['userexp_2'] = "<b>u5er d3T4ilS</b> allow\$ j00 +o CH4n9E Y0UR n4M3, em4il 4Ddr35\$ 4Nd pA\$\$w0rD.";
$lang['userexp_3'] = "<b>uSER Pr0pH1l3</b> allow5 J00 TO 3D1+ YOUR u\$eR Pr0PH1L3.";
$lang['userexp_4'] = "<b>ch4NG3 p45\$wORd</b> @llows J00 T0 ch4N9e y0UR p4\$\$WoRd";
$lang['userexp_5'] = "<b>eMaIL &amp; prIV4CY</b> let\$ j00 Ch4N9e HOW J00 C@n 8E Con+@c+ed ON 4Nd ofPh Teh FORUM.";
$lang['userexp_6'] = "<b>f0rUM 0PT1oN5</b> L3+\$ J00 cH4n9e HOW +3h PHORUm LO0kS 4nD workS.";
$lang['userexp_7'] = "<b>at+acHm3nT5</b> 4LLOWs j00 To 3d1+/d3Le+3 YOUR 4+t4cHM3n+\$.";
$lang['userexp_8'] = "<b>sI9n4+ur3</b> l3T\$ J00 eD1t y0uR \$1Gn@tur3.";
$lang['userexp_9'] = "<b>r3La+1oN\$h1p\$</b> L3t\$ j00 Man@GE yOUR r3l@+I0n5hIP wi+H 0+HEr U\$3R5 ON +hE f0ruM.";
$lang['userexp_9'] = "<b>worD FIl+er</b> lET\$ j00 3dIT YOur P3r5oN@L W0rd philT3R.";
$lang['userexp_10'] = "<b>tHrE@d 5Ub\$cRIPt10ns</b> 4lLOW\$ J00 TO M4nA9E YOUr +HrEAd sU8ScRIp+1oN5.";
$lang['userdetails'] = "uSeR D3+@1l\$";
$lang['userprofile'] = "u\$3r pr0pHILe";
$lang['emailandprivacy'] = "em@iL &amp; PriV4cY";
$lang['editsignature'] = "ed1+ sIGN4+UR3";
$lang['norelationshipssetup'] = "j00 H4vE No USER rEl@+10n5HIP5 s3t uP. @dD 4 nEw U\$3R by \$34rCHIn9 B3L0w.";
$lang['editwordfilter'] = "ed1T WORD PH1l+3R";
$lang['userinformation'] = "u\$ER 1nPHORM@+1On";
$lang['changepassword'] = "ch4n9e P4\$\$W0rD";
$lang['currentpasswd'] = "cUrRen+ P@\$SW0rd";
$lang['newpasswd'] = "new P@5\$WoRD";
$lang['confirmpasswd'] = "c0NfiRM P4\$\$wORd";
$lang['currentpasswdrequired'] = "cUrRENT p@SSWorD 1\$ reqU1r3d";
$lang['newpasswdrequired'] = "nEw P@SSWORd i\$ r3qU1RED";
$lang['confirmpasswordrequired'] = "coNPHirM P@SSWorD 1\$ reqUIReD";
$lang['currentpasswddoesnotmatch'] = "cuRr3n+ P4S5woRD d0e\$ n0+ M@tCh s@veD p45\$woRd";
$lang['nicknamerequired'] = "nIcKN4m3 i\$ rEquIred!";
$lang['emailaddressrequired'] = "em@il @dDRess 1s R3QU1r3d!";
$lang['logonnotpermitted'] = "lO9on noT P3RM1tT3D. cH0oSE 4NOTheR!";
$lang['nicknamenotpermitted'] = "nICKN4m3 NOT P3RMITT3D. choo\$e @n0ther!";
$lang['emailaddressnotpermitted'] = "em@il 4dDr3S\$ n0t P3rMIT+eD. cH0o\$3 4N0+h3r!";
$lang['emailaddressalreadyinuse'] = "eMaIL aDDr3S\$ 4lR3@DY 1N U\$3. CHoo53 4n0+H3R!";
$lang['relationshipsupdated'] = "r3l@+ionships uPDAT3D!";
$lang['relationshipupdatefailed'] = "reL4TION\$H1p UPD4+3D Ph4ILeD!";
$lang['preferencesupdated'] = "prEpHERenC35 Wer3 sUcC3\$sFULLY uPD@+3d.";
$lang['userdetails'] = "u53R d3T41LS";
$lang['memberno'] = "mEmB3R N0.";
$lang['firstname'] = "f1rs+ N@mE";
$lang['lastname'] = "l@s+ N4mE";
$lang['dateofbirth'] = "d@T3 0Ph biRTH";
$lang['homepageURL'] = "hom3p4gE Url";
$lang['profilepicturedimensions'] = "pr0fILE p1C+UrE (M@X 95X95PX)";
$lang['avatarpicturedimensions'] = "aV@+@r PICTuRE (MAX 15x15PX)";
$lang['invalidattachmentid'] = "inV4L1d @TT4cHMEn+. Ch3CK th4t IS H4sN't Be3n DEl3+Ed.";
$lang['unsupportedimagetype'] = "un5UPPORt3D im@9E 4++4cHM3nT. j00 C4n 0Nly u\$3 JP9, 91f 4Nd pN9 iM4GE @tt4chmEN+S pH0r YOUr 4v@T4R 4nd PR0FiLe P1CTURE.";
$lang['selectattachment'] = "s3L3CT @+t4CHM3nT";
$lang['pictureURL'] = "p1C+URe URL";
$lang['avatarURL'] = "aV4t4r url";
$lang['profilepictureconflict'] = "to u\$3 4n @Tt@CHM3nt Phor YOUr Pr0pH1LE piCTUr3 +eh P1CTURe URL fiElD MUst 83 8l4nK.";
$lang['avatarpictureconflict'] = "t0 uS3 4N @++4CHMeN+ foR Y0UR 4VA+@R P1C+URe +H3 4v4+@r URL fi3lD mUS+ B3 8laNk.";
$lang['attachmenttoolargeforprofilepicture'] = "selEctEd 4++4cHM3nT Is T0o LARgE phor PRopH1L3 PIc+URe. m4x1mUM diM3nSION\$ 4rE %s";
$lang['attachmenttoolargeforavatarpicture'] = "sEl3cT3d @+t4chMenT Is to0 L@r9E ph0r @v4+AR piC+UR3. M4x1MUM DImEnsi0Ns 4R3 %s";
$lang['failedtoupdateuserdetails'] = "s0me OR ALL 0F Y0uR U\$3r 4CCOUN+ D3+4il5 C0ulD N0T 8e UpD4+3D. PL3@53 tRY @G4IN L4+ER.";
$lang['failedtoupdateuserpreferences'] = "s0ME OR 4lL 0pH Y0uR u53r Pr3PH3r3nc3\$ coULD nOT 83 UPd@TEd. PlEA\$3 Try 494IN l4T3r.";
$lang['emailaddresschanged'] = "em4Il 4dDR3s\$ H4s Be3n ChaN93d";
$lang['newconfirmationemailsuccess'] = "y0ur 3mAIL aDDR3ss h4s Be3N Ch@NGED @Nd 4 New ConFIRM4T1oN 3M4iL HA\$ b33N SenT. pL34\$3 chEck @ND RE@d +hE 3m4iL FOR phUR+hER 1ns+rUctION5.";
$lang['newconfirmationemailfailure'] = "j00 H4V3 CH@N9ED Y0ur EM@IL 4Ddr3s\$, 8uT W3 w3rE uN@bl3 T0 \$3nd @ C0NPHirM4+10N R3QUe\$+. ple45e coN+4CT TeH f0RUM 0WNEr for 4sSi\$+4NC3.";
$lang['forumoptions'] = "forUm 0PT10ns";
$lang['notifybyemail'] = "not1Fy By EM4iL Of pO5+S t0 ME";
$lang['notifyofnewpm'] = "n0tipHY 8Y P0PuP OF N3w PM M3ss@ge5 t0 Me";
$lang['notifyofnewpmemail'] = "no+iFY bY EM@1l Of new PM mE\$\$@9e\$ T0 m3";
$lang['daylightsaving'] = "aDJU\$+ PHOr D4YlIghT S4v1ng";
$lang['autohighinterest'] = "aUt0M4+1c@LLY M@rK +HR3@d\$ i p0\$+ IN 4\$ hI9h in+3rEst";
$lang['sortthreadlistbyfolders'] = "s0r+ THr34D Li\$t by phoLd3rs";
$lang['convertimagestolinks'] = "au+0m4+icaLLY C0nv3r+ 3m83dDEd 1m493s IN pos+S 1N+0 L1NK5";
$lang['thumbnailsforimageattachments'] = "thuMBn@1l5 pH0R Im@Ge 4++@CHmeNTS";
$lang['smallsized'] = "sm@Ll \$iZeD";
$lang['mediumsized'] = "m3dIUm SIZ3d";
$lang['largesized'] = "l4r9E sIZEd";
$lang['globallyignoresigs'] = "gl084LLY i9n0R3 USEr SI9N@+ur3s";
$lang['allowpersonalmessages'] = "all0w OTH3r US3rS T0 \$3nD Me Per\$On4L M3S5@9e5";
$lang['allowemails'] = "aLLOw oth3r USErs T0 SENd M3 em4ILS vi@ My PROFIl3";
$lang['timezonefromGMT'] = "tiM3 ZONe";
$lang['postsperpage'] = "p0s+\$ P3r P493";
$lang['fontsize'] = "foN+ 5IzE";
$lang['forumstyle'] = "fORUM \$+YL3";
$lang['forumemoticons'] = "f0Rum 3mOtIcoNS";
$lang['startpage'] = "s+4rT P@93";
$lang['signaturecontainshtmlcode'] = "sIgN@TUR3 C0nT4inS Html CoD3";
$lang['savesignatureforuseonallforums'] = "s4v3 SI9n4+ur3 PHOR Use ON 4LL PH0RuM\$";
$lang['preferredlang'] = "pR3FErr3D L4nGU49E";
$lang['donotshowmyageordobtoothers'] = "dO NO+ sH0W MY 4G3 0R d4TE oph 81r+H TO oTHeR\$";
$lang['showonlymyagetoothers'] = "shoW ONLY mY 4g3 t0 0+heR\$";
$lang['showmyageanddobtoothers'] = "sh0W 80+H my 4G3 @Nd d4+e OPH 8IRth to OThERs";
$lang['showonlymydayandmonthofbirthytoothers'] = "sHOW 0NLY My D4Y 4nD m0n+h 0f 81r+H T0 0+HER\$";
$lang['listmeontheactiveusersdisplay'] = "l1S+ mE oN +HE @C+1VE userS d15PL4y";
$lang['browseanonymously'] = "br0wS3 pH0rUM @NONYm0u\$lY";
$lang['allowfriendstoseemeasonline'] = "bROWse 4noNYm0U5lY, bU+ 4LloW Phri3nd5 TO \$33 me 4\$ oNlin3";
$lang['revealspoileronmouseover'] = "r3vE4l sP0IL3r5 ON moU53 0vER";
$lang['showspoilersinlightmode'] = "alW4Ys \$h0w 5po1l3r5 1n L1gHT moDe (u\$3S LIgh+3r PHONt C0L0uR)";
$lang['resizeimagesandreflowpage'] = "resIze 1m49ES anD r3fLOW p@9E to PRev3nT h0r1zON+4L ScR0lLiNg.";
$lang['showforumstats'] = "sHoW FORum 5+a+\$ 4+ bo++Om 0ph mE554g3 P@n3";
$lang['usewordfilter'] = "en@8l3 w0rD Ph1l+ER.";
$lang['forceadminwordfilter'] = "fOrCE U53 0PH 4DM1n W0rD fIlt3r 0n aLL uSERS (1NC. 9u3s+S)";
$lang['timezone'] = "tiMe zON3";
$lang['language'] = "l@nGu49E";
$lang['emailsettings'] = "eM41l @Nd C0n+@c+ S3tTIN9S";
$lang['forumanonymity'] = "f0rum 4NONyM1+Y SEt+Ing\$";
$lang['birthdayanddateofbirth'] = "b1r+Hd4Y 4Nd DatE Of B1rTH d1\$PlaY";
$lang['includeadminfilter'] = "iNCLUdE @DM1n W0rD pH1ltEr 1N MY LI\$+.";
$lang['setforallforums'] = "s3t for @Ll PHORUms?";
$lang['containsinvalidchars'] = "%s CONt4IN\$ Inv4l1D ch4r4cT3rS!";
$lang['homepageurlmustincludeschema'] = "h0M3pA93 URL MusT INclUde htTp:// sCh3m4.";
$lang['pictureurlmustincludeschema'] = "p1C+urE Url MUST 1NclUdE htTp:// \$CH3M4.";
$lang['avatarurlmustincludeschema'] = "av4+@r URl mus+ 1NCluD3 HT+p:// sCHem4.";
$lang['postpage'] = "p0\$+ p493";
$lang['nohtmltoolbar'] = "n0 H+mL +OOl8@R";
$lang['displaysimpletoolbar'] = "d15Pl4Y \$ImPLE HtmL +00LB@r";
$lang['displaytinymcetoolbar'] = "d1spl@Y wy\$iwYG htML +ooL8Ar";
$lang['displayemoticonspanel'] = "d1\$pL4Y 3m0+1CON5 P4N3L";
$lang['displaysignature'] = "d1SPL4Y 5i9n4+UR3";
$lang['disableemoticonsinpostsbydefault'] = "dI5Able 3m0TiCon5 IN M3s\$@9es by d3ph4UlT";
$lang['automaticallyparseurlsbydefault'] = "aUt0m4+1c4LLY p4R\$E URL\$ in m3s\$49E\$ by dEF@ul+";
$lang['postinplaintextbydefault'] = "pOs+ IN PL41n tEXT 8y d3PH4UlT";
$lang['postinhtmlwithautolinebreaksbydefault'] = "p0S+ 1n HTML wIth @U+o-l1N3-8rE@k\$ By d3fAULt";
$lang['postinhtmlbydefault'] = "po5t 1N HTML by d3PH@Ul+";
$lang['postdefaultquick'] = "u53 QU1CK R3PLY 8Y dEfAulT. (fULL r3pLY 1N mENU)";
$lang['privatemessageoptions'] = "pR1v4tE M3\$\$@9E OPTioN5";
$lang['privatemessageexportoptions'] = "pRiv4+E M3ssA9E 3xP0r+ 0p+iONs";
$lang['savepminsentitems'] = "s@vE @ copy 0F E4CH pm I \$3nD 1n MY SEN+ I+3mS PH0lDer";
$lang['includepminreply'] = "incluD3 M3s5@ge 80dY WHEn R3PLY1N9 +0 pM";
$lang['autoprunemypmfoldersevery'] = "aUT0 PrUNE mY PM phoLders 3vERY:";
$lang['friendsonly'] = "frI3ndS 0nLY?";
$lang['globalstyles'] = "gLO8@L 5+YL3S";
$lang['forumstyles'] = "forum S+YL3S";
$lang['youmustenteryourcurrentpasswd'] = "j00 MusT EntEr youR cuRREnt P@s\$w0rd";
$lang['youmustenteranewpasswd'] = "j00 MU\$t 3nT3R A New p4S\$wORD";
$lang['youmustconfirmyournewpasswd'] = "j00 Mu\$T C0nFIRm yOUR n3w P4\$\$wORD";
$lang['profileentriesmustnotincludehtml'] = "pR0f1LE En+rIE5 MU\$+ n0+ 1nclUD3 HTML";
$lang['failedtoupdateuserprofile'] = "f@Il3D +O uPd4+E U53r prOPH1l3";

// Polls (create_poll.php, poll_results.php) ---------------------------------------------

$lang['mustprovideanswergroups'] = "j00 mU\$+ proV1d3 soM3 @nSWer 9ROup\$";
$lang['mustprovidepolltype'] = "j00 muST pR0VId3 4 P0lL TypE";
$lang['mustprovidepollresultsdisplaytype'] = "j00 muS+ PR0v1de Re\$ulTS d1SPL4y +YP3";
$lang['mustprovidepollvotetype'] = "j00 Mu5+ PRov1dE 4 polL v0+E +Yp3";
$lang['mustprovidepollguestvotetype'] = "j00 mU\$+ 5PEC1Fy IPh 9u3\$+S SH0uLd B3 4lL0weD +0 V0tE";
$lang['mustprovidepolloptiontype'] = "j00 MUS+ PRovid3 @ POLl OPTIOn +YP3";
$lang['mustprovidepollchangevotetype'] = "j00 MuS+ ProvId3 @ P0lL Ch4N9E VOTE type";
$lang['pollquestioncontainsinvalidhtml'] = "oN3 oR MORe oF YouR P0Ll QU3s+iON\$ C0nTAINS 1NV4L1D HTML.";
$lang['pleaseselectfolder'] = "pl3453 sEL3C+ 4 PhOLD3R";
$lang['mustspecifyvalues1and2'] = "j00 mus+ SpEc1FY V4LUE\$ PhoR 4n\$WeRS 1 4ND 2";
$lang['tablepollmusthave2groups'] = "t48ul4r FORM4T POLLS mU\$+ h@VE Pr3c1SEly +W0 V0+1nG GR0UPS";
$lang['nomultivotetabulars'] = "t48uL@R F0rM@+ Poll\$ c@Nn0T bE MUlt1-VoT3";
$lang['nomultivotepublic'] = "pU8LIC B4lL0+S C@nn0+ 83 Mul+1-VOTE";
$lang['abletochangevote'] = "j00 WILL BE @bL3 tO Ch4N93 yOUR v0+E.";
$lang['abletovotemultiple'] = "j00 w1ll B3 48LE +o V0tE MulTIPl3 tIM3s.";
$lang['notabletochangevote'] = "j00 wiLL not BE @bL3 +0 Ch@Ng3 Y0ur vo+3.";
$lang['pollvotesrandom'] = "no+e: PolL V0+E5 @R3 R4NDOMLY 93neRA+3D PH0r PR3VIEw 0nLY.";
$lang['pollquestion'] = "p0LL qU3s+ION";
$lang['possibleanswers'] = "pos\$18l3 4nSWErs";
$lang['enterpollquestionexp'] = "en+Er +HE 4N\$wERS PH0r YOUR pOLL QuE5+ION.. ipH yoUR P0lL 15 4 &quot;Y3s/NO&quot; qU3st10n, simpLY 3NTER &quot;Yes&quot; pH0r An\$wER 1 4nD &quot;N0&quot; foR @nSW3R 2.";
$lang['numberanswers'] = "no. @N5W3r5";
$lang['answerscontainHTML'] = "an\$w3rs coNTAin h+ML (nOT iNCLuD1nG s1gNA+ur3)";
$lang['optionsdisplay'] = "an5W3rS dIsPl4y TYpe";
$lang['optionsdisplayexp'] = "h0w 5HOUlD +H3 @NSWers b3 pRe53NtEd?";
$lang['dropdown'] = "as DROP-DOWn L1S+(s)";
$lang['radios'] = "aS 4 \$Eri3S OPH r4d10 8utt0nS";
$lang['votechanging'] = "vot3 cH4N91N9";
$lang['votechangingexp'] = "c4N 4 PERs0N ch@N9E HIs oR Her V0+E?";
$lang['guestvoting'] = "gu35+ V0T1n9";
$lang['guestvotingexp'] = "c4n 9U3S+s V0+3 1n THI\$ p0lL?";
$lang['allowmultiplevotes'] = "aLl0w mul+1pLE voTes";
$lang['pollresults'] = "p0Ll reSulT\$";
$lang['pollresultsexp'] = "hOW WOULd J00 like +o Di\$pL@Y +3H Re5ULT\$ OPH y0UR PolL?";
$lang['pollvotetype'] = "p0ll V0tIN9 +YPe";
$lang['pollvotesexp'] = "h0w \$houlD +H3 poll b3 CONDuC+3D?";
$lang['pollvoteanon'] = "aNONYMoUsLy";
$lang['pollvotepub'] = "pU8LiC 84llOt";
$lang['horizgraph'] = "h0rIz0n+4L GR4pH";
$lang['vertgraph'] = "v3R+iC@L Gr4Ph";
$lang['tablegraph'] = "t@bUL@r F0Rm4t";
$lang['polltypewarning'] = "<b>w4rn1n9</b>: TH1s 1S 4 pUBlic B4ll0t. Y0Ur N4m3 WILL bE VISIbL3 next TO TH3 0pTION J00 v0+E FOR.";
$lang['expiration'] = "eXp1r@T10n";
$lang['showresultswhileopen'] = "do J00 w4n+ T0 5h0W REsuL+S WHiLe teh P0LL 1s 0p3n?";
$lang['whenlikepollclose'] = "wH3n W0uLd J00 L1k3 YOUr POLL +o 4utoM4+1c4lLy clOS3?";
$lang['oneday'] = "oN3 D4y";
$lang['threedays'] = "thrEE d4Ys";
$lang['sevendays'] = "s3ven d4y\$";
$lang['thirtydays'] = "th1r+Y d4ys";
$lang['never'] = "n3v3r";
$lang['polladditionalmessage'] = "adD1+ion4l M3\$\$4ge (0p+10n4l)";
$lang['polladditionalmessageexp'] = "d0 j00 W4nT +0 INClUDe 4n @dDi+10n@L p0ST 4pHT3r +He P0ll?";
$lang['mustspecifypolltoview'] = "j00 Mu\$t SP3ciphY 4 POll t0 vIew.";
$lang['pollconfirmclose'] = "aR3 J00 SUR3 j00 w@nT +O CLOSe TH3 Follow1n9 POLL?";
$lang['endpoll'] = "eND P0lL";
$lang['nobodyvotedclosedpoll'] = "noB0dY V0TED";
$lang['votedisplayopenpoll'] = "%s 4ND %s H4VE VOt3D.";
$lang['votedisplayclosedpoll'] = "%s 4ND %s V0tEd.";
$lang['nousersvoted'] = "no u53rS";
$lang['oneuservoted'] = "1 U\$3r";
$lang['xusersvoted'] = "%s uSERS";
$lang['noguestsvoted'] = "nO gUes+s";
$lang['oneguestvoted'] = "1 GU3S+";
$lang['xguestsvoted'] = "%s 9Ue5+\$";
$lang['pollhasended'] = "poLl H4S End3D";
$lang['youvotedforpolloptionsondate'] = "j00 VOTeD F0R %s on %s";
$lang['thisisapoll'] = "thi\$ 1\$ @ P0LL. cL1CK +O vieW RE\$ul+\$.";
$lang['editpoll'] = "ed1+ polL";
$lang['results'] = "re5Ul+\$";
$lang['resultdetails'] = "r3SULT D3t4iL5";
$lang['changevote'] = "ch@N9E VOTe";
$lang['pollshavebeendisabled'] = "poLl\$ h4ve 8e3n dis@bl3d by TH3 FORUm ownER.";
$lang['answertext'] = "aNsw3R t3xT";
$lang['answergroup'] = "answ3r GROUp";
$lang['previewvotingform'] = "pR3Vi3W v0T1N9 PHOrm";
$lang['viewbypolloption'] = "v13W By P0lL 0pT1On";
$lang['viewbyuser'] = "vi3W bY USEr";

// Profiles (profile.php) ----------------------------------------------

$lang['editprofile'] = "eD1t Pr0PH1l3";
$lang['profileupdated'] = "pr0f1lE UpD@TeD.";
$lang['profilesnotsetup'] = "tEH phorum 0wNer H@S noT s3+ Up pr0PHilES.";
$lang['ignoreduser'] = "iGn0rED USer";
$lang['lastvisit'] = "l45+ V1\$1+";
$lang['userslocaltime'] = "u\$Er'5 L0C4L +iMe";
$lang['userstatus'] = "sT@Tu\$";
$lang['useractive'] = "oNlINE";
$lang['userinactive'] = "iN4C+IvE / 0PHFLINe";
$lang['totaltimeinforum'] = "to+4l tIMe";
$lang['longesttimeinforum'] = "loNg35t S3s\$10n";
$lang['sendemail'] = "sEnD 3m4IL";
$lang['sendpm'] = "sEND PM";
$lang['visithomepage'] = "visI+ H0mEP49e";
$lang['age'] = "aG3";
$lang['aged'] = "a93D";
$lang['birthday'] = "b1R+HD4y";
$lang['registered'] = "rEgI\$+ered";
$lang['findpostsmadebyuser'] = "f1Nd pOs+S M4D3 8y %s";
$lang['findpostsmadebyme'] = "f1Nd POS+\$ M@de 8y M3";
$lang['findthreadsstartedbyuser'] = "finD THR34dS S+4r+3D By %s";
$lang['findthreadsstartedbyme'] = "f1ND +Hre4d\$ s+4rTEd 8y M3";
$lang['profilenotavailable'] = "profILE noT 4v4iL48le.";
$lang['userprofileempty'] = "thi\$ U\$3R H@s NOT PH1lLEd 1n TH31r PROf1LE oR IT is S3+ +o pr1va+e.";

// Registration (register.php) -----------------------------------------

$lang['newuserregistrationsarenotpermitted'] = "s0rrY, n3w us3R r39I\$+r4T10n5 @r3 NOT @LLowEd r19h+ n0w. PL3A\$3 ch3ck b4ck L4t3r.";
$lang['usernameinvalidchars'] = "u53RN4mE C4N 0nLY conT41n @-z, 0-9, _ - CHar@c+3r5";
$lang['usernametooshort'] = "u5ERN@M3 mus+ 83 4 M1nIMUm 0ph 2 CHar4c+ers LONg";
$lang['usernametoolong'] = "u53rN4m3 Mus+ Be 4 m4x1muM 0ph 15 Ch@RAc+ERS L0n9";
$lang['usernamerequired'] = "a Logon nam3 i\$ r3qU1r3d";
$lang['passwdmustnotcontainHTML'] = "p@S\$WOrd MUst N0t cont@1n HTMl TAG\$";
$lang['passwordinvalidchars'] = "p@5\$wORd C@N 0NLY C0nT4IN A-z, 0-9, _ - CH4r4c+3r5";
$lang['passwdtooshort'] = "p4SSWORd MUS+ 8e 4 M1nIMum 0ph 6 ch@R4C+3Rs LONG";
$lang['passwdrequired'] = "a p@s\$woRD 15 R3QUIRED";
$lang['confirmationpasswdrequired'] = "a cONF1RmA+1oN P4\$\$WOrD I\$ R3QUIREd";
$lang['nicknamerequired'] = "a NICKNAmE 1\$ r3qUIr3D";
$lang['emailrequired'] = "an 3m4il AdDrE\$\$ 1S R3quirEd";
$lang['passwdsdonotmatch'] = "p@S\$w0rD5 d0 N0t M@tCH";
$lang['usernamesameaspasswd'] = "u53Rn4me @Nd P4\$\$w0rD Mu\$t 83 DIPhf3rEN+";
$lang['usernameexists'] = "s0rRY, 4 Us3R W1+H Th4+ N4M3 4LrE4DY ex1sTS";
$lang['successfullycreateduseraccount'] = "sUCc3S\$PhUlly Cre4tEd uS3R AcC0un+";
$lang['useraccountcreatedconfirmfailed'] = "y0Ur uS3r AccOun+ h4S BE3n CRe@TEd BUt thE REqU1R3D coNFirmA+1oN 3m41l W4S n0+ S3n+. plE4s3 CONT@CT TEh PH0rUM OWn3R +0 R3c+IPHY th1s. In th1s Me@NT1mE pL3@s3 Cl1ck +3H cOnTINu3 bUTT0N +o L0gIN.";
$lang['useraccountcreatedconfirmsuccess'] = "yoUr uS3R @CCOuN+ H45 B33n Cr34TEd BU+ 83ph0rE j00 C4N \$+@R+ P0\$+1Ng j00 MU\$+ C0nfIRm y0uR EM@1L 4dDR3sS. PL34\$3 CH3cK Y0UR EMaiL FOR @ liNK thA+ w1Ll 4LLOW J00 t0 CONfIRM Y0uR @dDre5\$.";
$lang['useraccountcreated'] = "yoUr U\$3r 4CCOun+ H4s BeEn cr34+3d sUCceSSFulLY! Cl1CK +h3 C0nTINue bUT+On BeLOW +O l09IN";
$lang['errorcreatinguserrecord'] = "erRor crE4+In9 U53r ReC0rd";
$lang['userregistration'] = "u\$ER rEgI\$+r4+ION";
$lang['registrationinformationrequired'] = "r3g1sTR@+10n inPHORm@T10N (REquIR3D)";
$lang['profileinformationoptional'] = "pROfil3 INphorM@T10n (0Pt10N4L)";
$lang['preferencesoptional'] = "pr3F3rENc35 (0pT1oN4L)";
$lang['register'] = "r3g1SteR";
$lang['rememberpasswd'] = "reMEM8Er P4s5WoRD";
$lang['birthdayrequired'] = "d@t3 OF 8IrTH 1S R3QUIRed or IS 1nv4L1D";
$lang['alwaysnotifymeofrepliestome'] = "nO+iFY on REply +0 Me";
$lang['notifyonnewprivatemessage'] = "no+Iphy ON N3w pr1v@+E mE5\$A93";
$lang['popuponnewprivatemessage'] = "pop UP on n3w pr1vATe ME\$S@93";
$lang['automatichighinterestonpost'] = "aUToM4+1C H1gh 1n+3r3s+ on PO\$T";
$lang['confirmpassword'] = "cOnPHIRM p45SWORd";
$lang['invalidemailaddressformat'] = "inV4lid 3M4iL 4dDrE\$\$ pH0RM4+";
$lang['moreoptionsavailable'] = "m0re PR0PH1l3 4nD PreFeRenC3 Op+ioNS 4rE @v4il4bL3 onCE J00 Reg1s+ER";
$lang['textcaptchaconfirmation'] = "c0nF1rM4+1on";
$lang['textcaptchaexplain'] = "tO PR3V3NT aUT0M4t3d R391s+R4+10n5 tH1\$ PHORUm r3qUIre5 j00 3nteR 4 CONFirM4T10N C0D3. Th3 COd3 15 DI\$pl4y3D IN +H3 iM4g3 j00 t0 TH3 rigHT. Iph J00 Ar3 VISU4lLY 1MP41R3D 0R C4NN0t 0+H3RWI\$E Re4d t3h c0d3 PL3A5E Con+@C+ ThE %s.";
$lang['textcaptchaimgtip'] = "tHI5 1s 4 C@pTCh4-PIc+urE. I+ 1\$ USEd +0 PREv3NT 4u+oMA+1C R39i5+r4t10n";
$lang['textcaptchamissingkey'] = "a c0nFIRm4T10N C0d3 I\$ R3QU1r3D.";
$lang['textcaptchaverificationfailed'] = "teXT-c@PTcH4 VerIf1c@+10n Cod3 w4\$ 1NcoRrEct. pl345E rE-3nTER i+.";
$lang['forumrules'] = "f0rUM RUL3s";
$lang['forumrulesnotification'] = "iN ORd3R t0 PROc33d, J00 mus+ 49r33 WitH +Eh pholloW1N9 RuL3s";
$lang['forumrulescheckbox'] = "i H4v3 RE4D, @ND @9r33 +0 A8ID3 by TH3 ph0ruM RulEs.";
$lang['youmustagreetotheforumrules'] = "j00 MU\$+ 4GR33 +0 +He pH0RUM RuLES bEphOR3 J00 C4n C0Nt1nUe.";

// Recent visitors list  (visitor_log.php) -----------------------------

$lang['member'] = "memB3r";
$lang['searchforusernotinlist'] = "s34RCH F0r 4 USER noT 1N LIST";
$lang['yoursearchdidnotreturnanymatches'] = "yOUr \$3@rch DiD NO+ r3TUrn 4nY ma+Ch3s. TRY \$IMPL1fYING yoUR \$34rCh p4r4m3teRs 4ND +Ry @G4iN.";
$lang['hiderowswithemptyornullvalues'] = "hID3 R0wS W1+H EmpTY or nUll v4LU3\$ 1n S3L3c+3D c0LUmns";
$lang['showregisteredusersonly'] = "sh0w R391SteR3D U\$3rS ONlY (H1DE GuE\$T5)";

// Relationships (user_rel.php) ----------------------------------------

$lang['relationships'] = "rEL4+IONshIPS";
$lang['userrelationship'] = "u\$ER rEl4+IOn5H1P";
$lang['userrelationships'] = "uSer r3L4tION5h1p\$";
$lang['failedtoremoveselectedrelationships'] = "faiL3D +o R3M0vE S3l3CT3D R3l@+ION\$h1P";
$lang['friends'] = "fRi3nd\$";
$lang['ignoredcompletely'] = "i9n0REd COMpl3teLY";
$lang['relationship'] = "rel@+10NsH1P";
$lang['restorenickname'] = "rES+0r3 U\$3r'\$ NIcKNAM3";
$lang['friend_exp'] = "u5eR'S P0sTS m4RK3D WiTh a &quot;FR13nd&quot; 1coN.";
$lang['normal_exp'] = "u53R'5 P0s+S 4pPE@r 4\$ N0Rm4l.";
$lang['ignore_exp'] = "u53R'\$ PostS 4rE H1Dd3N.";
$lang['ignore_completely_exp'] = "thR3@Ds 4nD p0\$+\$ T0 0r PhrOM u53r w1ll @pP34r d3leTeD.";
$lang['display'] = "di\$pl4y";
$lang['displaysig_exp'] = "us3R'5 SI9n4TuR3 IS D15PL4YED 0N th3ir p0\$+\$.";
$lang['hidesig_exp'] = "u\$er'S \$1Gn@+Ur3 1\$ H1DDEn 0N +h31R P0sts.";
$lang['youcannotchangeuserrelationshipforownaccount'] = "j00 c@NN0t chAN93 U\$3R ReL@t10nsh1p F0R YouR oWN u\$3R AcCOUn+";
$lang['cannotignoremod'] = "j00 C@NN0+ IgnoR3 this U53r, 45 They 4rE 4 MODeR4+0r.";
$lang['previewsignature'] = "prEvI3W 519NA+ur3";

// Search (search.php) -------------------------------------------------

$lang['searchresults'] = "s34RCh rE\$ULT\$";
$lang['usernamenotfound'] = "tH3 USErn@Me J00 5P3CIFIED 1n THe t0 0r fr0m FI3lD Wa\$ NOT FouNd.";
$lang['notexttosearchfor'] = "oNE OR 4lL 0pH Y0UR \$3@rCH K3yW0RD\$ w3r3 1NV@L1d. \$34Rch KEYwoRD\$ MUS+ BE N0 SHor+3R +H4n %d Ch4r4c+3r5, n0 L0nG3r THan %d ch@RAcT3rS AND mUS+ NOT @ppe@R In T3H %s";
$lang['keywordscontainingerrors'] = "k3yWORdS CoNt41N1ng ERR0rS: %s";
$lang['mysqlstopwordlist'] = "mysqL STOPW0RD l15+";
$lang['foundzeromatches'] = "f0und: 0 mAtche\$";
$lang['found'] = "fOuND";
$lang['matches'] = "m4+che\$";
$lang['prevpage'] = "pREV10u5 Pa9E";
$lang['findmore'] = "fiNd MOr3";
$lang['searchmessages'] = "se@RCh ME\$S@935";
$lang['searchdiscussions'] = "s3@rCh Di5cu\$\$1Ons";
$lang['find'] = "fiNd";
$lang['additionalcriteria'] = "add1+10N4l cR1+eR1@";
$lang['searchbyuser'] = "s34RcH 8y U\$3R (oP+ION4l)";
$lang['folderbrackets_s'] = "f0lDER(s)";
$lang['postedfrom'] = "pOsTEd pHROM";
$lang['postedto'] = "pOS+Ed +O";
$lang['today'] = "t0D@Y";
$lang['yesterday'] = "y35+3RD@Y";
$lang['daybeforeyesterday'] = "d@y BEfore Yes+ErD4y";
$lang['weekago'] = "%s w33k 4go";
$lang['weeksago'] = "%s wE3ks 4gO";
$lang['monthago'] = "%s M0nth 4G0";
$lang['monthsago'] = "%s montHS a90";
$lang['yearago'] = "%s yE4r 4gO";
$lang['beginningoftime'] = "b3GINN1N9 0ph tIMe";
$lang['now'] = "nOW";
$lang['lastpostdate'] = "l4s+ PO\$T D4+E";
$lang['numberofreplies'] = "nuM83r 0ph r3pL1E\$";
$lang['foldername'] = "foLd3R nam3";
$lang['authorname'] = "autH0R n@me";
$lang['decendingorder'] = "new3S+ fir5+";
$lang['ascendingorder'] = "olDE5+ PH1rST";
$lang['keywords'] = "kEyworD\$";
$lang['sortby'] = "sort 8y";
$lang['sortdir'] = "soR+ dIR";
$lang['sortresults'] = "sORT R3\$Ul+\$";
$lang['groupbythread'] = "gROUp 8y +hRe4d";
$lang['postsfromuser'] = "p0s+\$ phr0M u53R";
$lang['threadsstartedbyuser'] = "thre@Ds s+4r+3d by u53r";
$lang['searchfrequencyerror'] = "j00 CAn oNLy 5E4rCh ONCe 3vERY %s s3C0nds. pl34SE Try @9A1n L4+3r.";
$lang['searchsuccessfullycompleted'] = "se@rCh SUCC3S\$PhUllY coMPlE+3d. %s";
$lang['clickheretoviewresults'] = "cL1CK hER3 +O v13W RE5uL+\$.";

// Search Popup (search_popup.php) -------------------------------------

$lang['select'] = "s3l3Ct";
$lang['currentselection'] = "cuRr3NT seleCt1on";
$lang['addtoselection'] = "aDd +O \$3lEc+1oN";
$lang['searchforthread'] = "sE4Rch F0r THr34D";
$lang['mustspecifytypeofsearch'] = "j00 MUS+ spEciPhy +YPe 0pH 53@rCH t0 P3RF0rm";
$lang['unkownsearchtypespecified'] = "uNkN0wN \$34RCh TYP3 \$p3ciPh1ED";
$lang['maximumselectionoftenlimitreached'] = "m@xiMUM S3LEctiOn liM1T OPH 10 h@\$ B3EN RE@CH3D";

// Start page (start_left.php) -----------------------------------------

$lang['recentthreads'] = "receN+ +HrE4dS";
$lang['startreading'] = "st@RT r34d1nG";
$lang['threadoptions'] = "tHrE@D 0PTionS";
$lang['editthreadoptions'] = "ed1+ +hrE4D 0PT1oNS";
$lang['morevisitors'] = "mOr3 V1\$I+or5";
$lang['forthcomingbirthdays'] = "f0R+Hc0mIN9 8irThD4y\$";

// Start page (start_main.php) -----------------------------------------

$lang['editstartpage_help'] = "j00 CAn 3Di+ +hiS P4gE PhROM +hE @Dmin 1NTErpH4C3";

// Thread navigation (thread_list.php) ---------------------------------

$lang['newdiscussion'] = "n3w D15CusS1ON";
$lang['createpoll'] = "cR3@TE POll";
$lang['search'] = "sE4RCH";
$lang['searchagain'] = "sE@rcH 494iN";
$lang['alldiscussions'] = "all DisCUSS1On5";
$lang['unreaddiscussions'] = "unr3@D d1scUsS1on5";
$lang['unreadtome'] = "uNr34D &quot;+O: M3&quot;";
$lang['todaysdiscussions'] = "tOD@y'S d1scuSs1oN\$";
$lang['2daysback'] = "2 D4YS b4ck";
$lang['7daysback'] = "7 d4y\$ B@Ck";
$lang['highinterest'] = "h1Gh INTErEs+";
$lang['unreadhighinterest'] = "uNr3@D hIgh INTEr3ST";
$lang['iverecentlyseen'] = "i'VE rEC3NTLY s3eN";
$lang['iveignored'] = "i'V3 19NOR3d";
$lang['byignoredusers'] = "bY 19N0RED Users";
$lang['ivesubscribedto'] = "i'v3 5UB5crI83d T0";
$lang['startedbyfriend'] = "st@rt3D 8y phriENd";
$lang['unreadstartedbyfriend'] = "uNRe4D STD BY Fr1ENd";
$lang['startedbyme'] = "s+4rteD 8y M3";
$lang['unreadtoday'] = "uNRE4d T0D4y";
$lang['deletedthreads'] = "del3t3d tHRE@DS";
$lang['goexcmark'] = "go!";
$lang['folderinterest'] = "fOLDer 1ntERES+";
$lang['postnew'] = "pO\$+ NEW";
$lang['currentthread'] = "cUrren+ +HRe4D";
$lang['highinterest'] = "hI9H 1NT3RE\$+";
$lang['markasread'] = "m4rK 4\$ rEAD";
$lang['next50discussions'] = "neXt 50 d1scUsSION\$";
$lang['visiblediscussions'] = "v1\$iBL3 D1sCuS\$10nS";
$lang['selectedfolder'] = "s3l3c+eD F0LD3r";
$lang['navigate'] = "n4V1G@TE";
$lang['couldnotretrievefolderinformation'] = "th3r3 4re nO FOLD3r5 @V41L4BL3.";
$lang['nomessagesinthiscategory'] = "n0 ME5s@Ges IN thi\$ CA+390RY. ple4\$3 \$3LeC+ 4N0th3r, OR %s F0r @Ll THR34ds";
$lang['clickhere'] = "cl1CK heRE";
$lang['prev50threads'] = "pR3VIou\$ 50 +hreaDS";
$lang['next50threads'] = "nEx+ 50 THR34ds";
$lang['nextxthreads'] = "nExt %s thr34ds";
$lang['threadstartedbytooltip'] = "tHRe4d #%s s+4R+Ed 8y %s. VI3WED %s";
$lang['threadviewedonetime'] = "1 +1m3";
$lang['threadviewedtimes'] = "%d +ImE\$";
$lang['readthread'] = "r3@d THRE4d";
$lang['unreadmessages'] = "unr3aD Me\$\$@9e\$";
$lang['subscribed'] = "subscribEd";
$lang['stickythreads'] = "sTICky THrE4ds";
$lang['mostunreadposts'] = "mO\$+ UNRE4D P0\$+s";
$lang['onenew'] = "%d n3W";
$lang['manynew'] = "%d n3W";
$lang['onenewoflength'] = "%d N3w 0PH %d";
$lang['manynewoflength'] = "%d nEW OPH %d";
$lang['confirmmarkasread'] = "ar3 j00 Sur3 J00 w4NT +O m4rK +HE s3lecTED +HR3@DS 4S RE@d?";
$lang['successfullymarkreadselectedthreads'] = "suCcEsSphully M4Rk3D \$3l3ct3D +Hr3@Ds 4s R34d";
$lang['failedtomarkselectedthreadsasread'] = "f41L3d +o M@rk SELeCT3d THrE4d5 @S R3@D";
$lang['gotofirstpostinthread'] = "go +0 Firs+ pos+ 1N THR34D";
$lang['gotolastpostinthread'] = "g0 +0 l4\$t pos+ 1n +HRe@D";
$lang['viewmessagesinthisfolderonly'] = "vIEW m3s5@9e\$ 1N tH1\$ PH0lD3R 0nLY";
$lang['shownext50threads'] = "shoW N3xt 50 +HRe4DS";
$lang['showprev50threads'] = "sh0W PR3v10U\$ 50 +HR3AD5";
$lang['createnewdiscussioninthisfolder'] = "cRE@+e N3W Di\$cU\$sIon iN ThIS PH0lD3R";
$lang['nomessages'] = "n0 m3s\$4g3S";

// HTML toolbar (htmltools.inc.php) ------------------------------------
$lang['bold'] = "bOLD";
$lang['italic'] = "it@L1C";
$lang['underline'] = "uNDERL1n3";
$lang['strikethrough'] = "s+RiK3+hROUGH";
$lang['superscript'] = "sUp3rScr1pT";
$lang['subscript'] = "su85cRIPT";
$lang['leftalign'] = "lEF+-@L1Gn";
$lang['center'] = "cEN+3r";
$lang['rightalign'] = "rIgH+-@lIGN";
$lang['numberedlist'] = "num83rEd li\$+";
$lang['list'] = "l1sT";
$lang['indenttext'] = "ind3n+ +ex+";
$lang['code'] = "cod3";
$lang['quote'] = "qUo+3";
$lang['unquote'] = "uNQu0+e";
$lang['spoiler'] = "sPoILEr";
$lang['horizontalrule'] = "hOR1Z0Nt4l RUlE";
$lang['image'] = "im@9e";
$lang['hyperlink'] = "hypERL1nK";
$lang['noemoticons'] = "d15A8LE 3mO+1CONS";
$lang['fontface'] = "fOn+ PH4CE";
$lang['size'] = "s1Ze";
$lang['colour'] = "cOl0UR";
$lang['red'] = "rED";
$lang['orange'] = "oR4nG3";
$lang['yellow'] = "y3lL0W";
$lang['green'] = "gR3En";
$lang['blue'] = "bLU3";
$lang['indigo'] = "iNd1g0";
$lang['violet'] = "vI0Le+";
$lang['white'] = "wHI+E";
$lang['black'] = "bl4ck";
$lang['grey'] = "grEy";
$lang['pink'] = "piNk";
$lang['lightgreen'] = "lI9HT 9RE3n";
$lang['lightblue'] = "l19h+ bLUE";

// Forum Stats --------------------------------

$lang['forumstats'] = "f0rUM 5+a+s";
$lang['userstats'] = "u5eR \$+4+\$";

$lang['usersactiveinthepasttimeperiod'] = "%s @CT1v3 in TH3 P4st %s. %s";

$lang['numactiveguests'] = "<b>%s</b> 9u3s+\$";
$lang['oneactiveguest'] = "<b>1</b> GU3\$+";
$lang['numactivemembers'] = "<b>%s</b> m3M8ERS";
$lang['oneactivemember'] = "<b>1</b> m3M83R";
$lang['numactiveanonymousmembers'] = "<b>%s</b> @N0nYM0u5 MEMbErS";
$lang['oneactiveanonymousmember'] = "<b>1</b> @n0nyMOu\$ mem83r";

$lang['numthreadscreated'] = "<b>%s</b> +Hr3@D5";
$lang['onethreadcreated'] = "<b>1</b> +HR34d";
$lang['numpostscreated'] = "<b>%s</b> P0s+5";
$lang['onepostcreated'] = "<b>1</b> POS+";

$lang['younormal'] = "j00";
$lang['youinvisible'] = "j00 (1nVISiBL3)";
$lang['viewcompletelist'] = "view cOMpLeTe LIS+";
$lang['ourmembershavemadeatotalofnumthreadsandnumposts'] = "ouR M3mB3Rs h4v3 M@d3 4 +ot4l 0Ph %s 4Nd %s.";
$lang['longestthreadisthreadnamewithnumposts'] = "l0NG3S+ THR34d 1\$ <b>%s</b> W1+H %s.";
$lang['therehavebeenxpostsmadeinthelastsixtyminutes'] = "tH3rE h@VE BeEN <b>%s</b> P0s+\$ m4D3 In TH3 L@5+ 60 miNut3\$.";
$lang['therehasbeenonepostmadeinthelastsxityminutes'] = "tH3RE HA5 83En <b>1</b> po\$t M4D3 in +eH LA\$T 60 m1nU+35.";
$lang['mostpostsevermadeinasinglesixtyminuteperiodwasnumposts'] = "mOSt PO5t\$ 3V3r m4dE In 4 S1nGle 60 minu+3 P3R10D 1s <b>%s</b> 0N %s.";
$lang['wehavenumregisteredmembersandthenewestmemberismembername'] = "we H@vE <b>%s</b> r3G1S+er3D M3M83RS @nD +eH N3w3s+ M3Mb3r 15 <b>%s</b>.";
$lang['wehavenumregisteredmember'] = "w3 H4V3 %s RegIS+er3D MemB3R\$.";
$lang['wehaveoneregisteredmember'] = "w3 H4V3 ONE rEg15+er3D mEm8ER.";
$lang['mostuserseveronlinewasnumondate'] = "m0sT U53rS EVEr onl1n3 w@\$ <b>%s</b> 0N %s.";
$lang['statsdisplaychanged'] = "s+A+S D1\$pl4y ch4n93d";

$lang['viewtop20'] = "vIEW +Op 20";

$lang['folderstats'] = "fOlder S+4+S";
$lang['threadstats'] = "thR34d S+4+\$";
$lang['poststats'] = "po5+ sT4ts";
$lang['pollstats'] = "p0Ll \$Ta+\$";
$lang['attachmentsstats'] = "a++4chm3nTs S+4+\$";
$lang['userpreferencesstats'] = "uSeR PREphEr3nC3S sT4+S";
$lang['visitorstats'] = "v1\$i+OR \$+4+\$";
$lang['sessionstats'] = "sEsSIOn S+@t5";
$lang['profilestats'] = "pR0F1l3 ST4t5";
$lang['signaturestats'] = "sI9n@tur3 sT4TS";
$lang['ageandbirthdaystats'] = "a9e 4nD 81R+HD4Y \$+4+s";
$lang['relationshipstats'] = "rEl4+1oN\$h1p s+@Ts";
$lang['wordfilterstats'] = "w0rD PH1lTer s+4+\$";

$lang['numberoffolders'] = "nuM83R 0pH FolD3RS";
$lang['folderwithmostthreads'] = "foLDEr W1th m0s+ THR34dS";
$lang['folderwithmostposts'] = "fOLD3R WI+h MOS+ p0\$+\$";
$lang['totalnumberofthreads'] = "tOTAL NUm8ER 0f thR34dS";
$lang['longestthread'] = "loNgEST +HRE@d";
$lang['mostreadthread'] = "mOSt R34d THre@d";
$lang['threadviews'] = "view\$";
$lang['averagethreadcountperfolder'] = "aV3R4g3 +HRE@d C0un+ Per FOLd3R";
$lang['totalnumberofthreadsubscriptions'] = "t0t4L nuM83R OPh +hRE4d suBsCR1pt1oN5";
$lang['mostpopularthreadbysubscription'] = "mO\$+ popuL4R Thr34d By \$UB\$CRIpt1oN";
$lang['totalnumberofposts'] = "tot4l NUmBER 0ph p05+\$";
$lang['numberofpostsmadeinlastsixtyminutes'] = "nuMB3r 0F POS+S M@DE 1N L4\$+ 60 M1NU+e\$";
$lang['mostpostsmadeinasinglesixtyminuteperiod'] = "m0\$+ P0STS M4D3 IN 0NE 60 m1nUT3 p3RI0D";
$lang['averagepostsperuser'] = "avER@9E pO5+\$ P3r USer";
$lang['topposter'] = "t0p P0s+ER";
$lang['totalnumberofpolls'] = "tOT4l NumBEr 0f POll\$";
$lang['totalnumberofpolloptions'] = "t0t4L Num83R OPH POLL 0P+ioNS";
$lang['averagevotesperpoll'] = "aver9e vote\$ Per POLL";
$lang['totalnumberofpollvotes'] = "t0+@L nUmBEr 0ph p0lL V0t3s";
$lang['totalnumberofattachments'] = "t0+al NUm83r OPH 4+t4chM3NT\$";
$lang['averagenumberofattachmentsperpost'] = "aVER@9E @tt4cHM3n+ COunT PeR POS+";
$lang['mostdownloadedattachment'] = "mO5T D0WNL04dED 4tT@chm3NT";
$lang['mostusedforumstyle'] = "mo5T us3d FORum STyl3";
$lang['mostusedlanguuagefile'] = "m05t U53d L4N9u49E PhIl3";
$lang['mostusedtimezone'] = "m0sT UsED tImeZ0n3";
$lang['mostusedemoticonpack'] = "mO\$+ U\$3d 3m0+1C0n PaCk";

$lang['numberofusers'] = "nUM83R OPH USers";
$lang['newestuser'] = "n3We5T u\$eR";
$lang['numberofcontributingusers'] = "numb3R 0pH C0n+R18u+ING U53RS";
$lang['numberofnoncontributingusers'] = "nUmB3R 0f N0n-coNTR18u+INg U53rs";
$lang['subscribers'] = "sU8sCriB3rS";

$lang['numberofvisitorstoday'] = "nUmB3r 0ph visi+0R\$ T0D4y";
$lang['numberofvisitorsthisweek'] = "num83R OPH v15I+OR\$ This We3k";
$lang['numberofvisitorsthismonth'] = "nUm83r 0Ph vISI+or\$ TH1\$ MON+h";
$lang['numberofvisitorsthisyear'] = "nUmbEr opH V1SiT0R\$ TH1\$ YE@r";

$lang['totalnumberofactiveusers'] = "tOT4L nuM83r 0pH aC+1VE USERs";
$lang['numberofactiveregisteredusers'] = "nuMb3r 0ph 4C+IVe REG1sTER3D U\$3Rs";
$lang['numberofactiveguests'] = "nUMBeR 0pH 4CT1V3 gU3s+S";
$lang['mostuserseveronline'] = "m05+ U\$3r5 3v3r ONLine";
$lang['mostactiveuser'] = "mo\$+ @C+iVe U53r";
$lang['numberofuserswithprofile'] = "nUm83R of u\$3R5 w1+H ProFILe";
$lang['numberofuserswithoutprofile'] = "numBEr 0ph U\$ERS w1+H0UT PR0PH1l3";
$lang['numberofuserswithsignature'] = "nUM83r 0Ph u\$3R\$ WI+H \$19N@TuR3";
$lang['numberofuserswithoutsignature'] = "nuMB3r 0pH us3R\$ w1tH0U+ \$19N4+uRe";
$lang['averageage'] = "aVeR@G3 4G3";
$lang['mostpopularbirthday'] = "m0\$+ P0pUl4r birthDay";
$lang['nobirthdaydataavailable'] = "n0 8IRTHD@y d4+@ 4v4iL48l3";
$lang['numberofusersusingwordfilter'] = "numbEr OF UseR\$ U\$iN9 wORD fiL+3r";
$lang['numberofuserreleationships'] = "num83r 0f U\$er REle4tIONSHip5";
$lang['averageage'] = "aVer@G3 4g3";
$lang['averagerelationshipsperuser'] = "aVer4g3 Rel@T10n5HIp5 P3r Us3R";

$lang['numberofusersnotusingwordfilter'] = "num83R oF USEr5 NO+ uSIng W0RD PH1L+Er";
$lang['averagewordfilterentriesperuser'] = "aV3RAg3 W0RD ph1lTER En+R13s p3R us3r";

$lang['mostuserseveronlinedetail'] = "%s on %s";

// Thread Options (thread_options.php) ---------------------------------

$lang['updatessavedsuccessfully'] = "upD4+3S \$4v3d SUcCesSFUlLy";
$lang['useroptions'] = "u53r 0pT10NS";
$lang['markedasread'] = "m@rKED 45 r3@D";
$lang['postsoutof'] = "p0\$+\$ 0u+ OPH";
$lang['interest'] = "iNtERE5t";
$lang['closedforposting'] = "cLO\$3D PHOr P0\$+iNG";
$lang['locktitleandfolder'] = "locK +1+LE 4nD pholD3r";
$lang['deletepostsinthreadbyuser'] = "d3l3te p0\$+\$ 1N THRE4D 8Y uS3r";
$lang['deletethread'] = "d3lEt3 thr34d";
$lang['permenantlydelete'] = "pERmAN3nTLY D3LE+3";
$lang['movetodeleteditems'] = "movE T0 DeLE+3D +HRE@D5";
$lang['undeletethread'] = "uNd3l3+3 ThRe4D";
$lang['markasunread'] = "m@rK @S UNRE4D";
$lang['makethreadsticky'] = "mak3 THRE4D STIcKY";
$lang['threareadstatusupdated'] = "thrE4d R34d 5+4+US UPd4+Ed 5UCc3SsfULLY";
$lang['interestupdated'] = "tHr34d 1nTErE\$+ StatUS upD@tEd 5uCcESSFULLy";
$lang['threadwassuccessfullydeleted'] = "thr34D W4\$ 5uCc3\$\$pHully d3L3tEd";
$lang['threadwassuccessfullyundeleted'] = "thRe@D WAs \$uCc3S\$PHulLY uNDel3TEd";
$lang['failedtoupdatethreadreadstatus'] = "f@1L3D T0 UPD@T3 +HRe@D r34D ST4tU\$";
$lang['failedtoupdatethreadinterest'] = "f@1L3d TO upD4+E +hRe@D iNteRE\$+";
$lang['failedtorenamethread'] = "f41L3D +0 R3n4Me +HRe@D";
$lang['failedtomovethread'] = "f4ILED +0 M0v3 Thr3@D +O SP3C1fIEd F0LDEr";
$lang['failedtoupdatethreadstickystatus'] = "f@il3d +O uPd4tE +Hr3@d S+ICKY 5+@TU\$";
$lang['failedtoupdatethreadclosedstatus'] = "f@1L3D +O uPD@te thRe4d CLOS3d s+4+U5";
$lang['failedtoupdatethreadlockstatus'] = "fAiL3D +O UPd4TE Thr3@D L0CK \$+4TU5";
$lang['failedtodeletepostsbyuser'] = "fA1l3d +0 D3LE+3 pos+\$ by SEL3cTed US3R";
$lang['failedtodeletethread'] = "fA1L3D T0 D3l3t3 tHrEaD.";
$lang['failedtoundeletethread'] = "f4ilEd T0 UN-d3lE+3 +hr3@D";

// Folder Options (folder_options.php) ---------------------------------

$lang['folderoptions'] = "fOLDeR op+10ns";
$lang['foldercouldnotbefound'] = "tHe REqu35+3D FOlder C0ulD NoT b3 fOUnD oR 4cC35S WA\$ DeN1eD.";
$lang['failedtoupdatefolderinterest'] = "f@iL3d t0 UPD@+3 pHOLd3R 1NterE5+";

// Dictionary (dictionary.php) -----------------------------------------

$lang['dictionary'] = "d1c+i0n4rY";
$lang['spellcheck'] = "sp3LL Ch3ck";
$lang['notindictionary'] = "no+ 1n dICT10N@rY";
$lang['changeto'] = "ch4ng3 +o";
$lang['restartspellcheck'] = "re\$+4R+";
$lang['cancelchanges'] = "c@nc3L CH4N9ES";
$lang['initialisingdotdotdot'] = "in1T14LI\$iN9...";
$lang['spellcheckcomplete'] = "sp3LL cH3cK 1s CoMPl3+3. +0 r3\$+@r+ speLl Ch3CK CL1cK res+@rt 8UTT0N below.";
$lang['spellcheck'] = "speLL CheCk";
$lang['noformobj'] = "n0 PH0rM Obj3C+ SPEc1fI3D F0r R3+URn +3xT";
$lang['bodytext'] = "bodY TEXT";
$lang['ignore'] = "i9NorE";
$lang['ignoreall'] = "i9nOre @lL";
$lang['change'] = "cH4NG3";
$lang['changeall'] = "cH@N9e @LL";
$lang['add'] = "aDD";
$lang['suggest'] = "sUg9e\$t";
$lang['nosuggestions'] = "(NO SUGG3s+10ns)";
$lang['cancel'] = "canC3l";
$lang['dictionarynotinstalled'] = "nO D1cT10n4ry H4\$ b33n 1N\$tALL3D. PL3A53 c0N+4CT th3 PHORUm own3r +O R3mEdY +Hi\$.";

// Permissions keys ----------------------------------------------------

$lang['postreadingallowed'] = "p0S+ Re4d1n9 4lL0weD";
$lang['postcreationallowed'] = "po5+ cr34+10n ALLOWeD";
$lang['threadcreationallowed'] = "thrE4d Cre@t10n ALL0WEd";
$lang['posteditingallowed'] = "po\$+ Edit1n9 ALLOWeD";
$lang['postdeletionallowed'] = "poS+ dEL3ti0N @LloweD";
$lang['attachmentsallowed'] = "upl04d1NG 4+T4CHm3n+s ALl0W3D";
$lang['htmlpostingallowed'] = "htmL P0s+INg @LLOWeD";
$lang['usersignatureallowed'] = "uSER s1Gn4+uR3 4ll0w3D";
$lang['guestaccessallowed'] = "gU3s+ 4CC3ss ALl0weD";
$lang['postapprovalrequired'] = "p0\$+ 4PPR0V4L rEQUIr3d";

// RSS feeds gubbins

$lang['rssfeed'] = "rSS phE3D";
$lang['every30mins'] = "evERY 30 MINU+3s";
$lang['onceanhour'] = "oNC3 @N HOUr";
$lang['every6hours'] = "eVerY 6 H0uRs";
$lang['every12hours'] = "eV3rY 12 HoUR5";
$lang['onceaday'] = "oNce a D4y";
$lang['onceaweek'] = "onC3 @ WE3K";
$lang['rssfeeds'] = "rs\$ PHe3d5";
$lang['feedname'] = "fEEd n@ME";
$lang['feedfoldername'] = "fE3D PHOlD3r n4M3";
$lang['feedlocation'] = "f33d LOc@+I0N";
$lang['threadtitleprefix'] = "tHr34d +1tL3 pR3Ph1x";
$lang['feednameandlocation'] = "f33d N@M3 @nD L0c@+Ion";
$lang['feedsettings'] = "fe3d S3tTIN95";
$lang['updatefrequency'] = "uPD@Te PHReqUenCy";
$lang['rssclicktoreadarticle'] = "cL1CK H3RE +o RE4D +h1S 4rt1clE";
$lang['addnewfeed'] = "adD N3w F33d";
$lang['editfeed'] = "eDIt f33D";
$lang['feeduseraccount'] = "f33d u53r @cCOUnt";
$lang['noexistingfeeds'] = "n0 3X1Stin9 RSS PhE3Ds F0uNd. +O ADD a phe3d CliCk +HE '4dD N3W' 8U++on 8ELOW";
$lang['rssfeedhelp'] = "hErE J00 c4N S3+UP S0M3 r\$\$ pHE3D\$ pHOR 4UT0M4+iC pROP@g4+Ion IntO Y0Ur phoRUm. +Eh 1+EM5 fROM tEH rs\$ PH33Ds J00 @dD W1LL bE crE4TED 4S +HrE@D5 WH1CH usErs c@n RePLY +o 4\$ 1f +Hey WerE NorMAL pOS+S. +Eh rSS f3eD MuSt 83 4cC3S\$iBl3 VI@ h+tp or IT WIll NOT WORk.";
$lang['mustspecifyrssfeedname'] = "mu\$t sPeC1fY R\$\$ fE3D N4ME";
$lang['mustspecifyrssfeeduseraccount'] = "mu5+ 5P3CIPHy R\$s fE3d US3r @cC0UNT";
$lang['mustspecifyrssfeedfolder'] = "mus+ \$pEc1FY R\$\$ PHEeD PH0LDer";
$lang['mustspecifyrssfeedurl'] = "mUs+ \$PEc1FY rs\$ PHe3d UrL";
$lang['mustspecifyrssfeedupdatefrequency'] = "mU5+ sPeCIFY RS\$ PHE3D UpD4+3 frEQUENCy";
$lang['unknownrssuseraccount'] = "unkN0wn RS\$ U\$ER 4CC0UNT";
$lang['rssfeedsupportshttpurlsonly'] = "rS\$ PH3eD SupPOR+s H+tp urL\$ ONLY. \$3cUR3 F33d5 (HT+pS://) 4r3 N0T SUpp0R+eD.";
$lang['rssfeedurlformatinvalid'] = "rs5 F3ed URL pHORm@+ 1\$ iNV@L1D. URl mu5+ INclUDe SchEME (E.9. ht+P://) @ND @ H0s+N4me (e.g. Www.HOS+N4Me.C0M).";
$lang['rssfeeduserauthentication'] = "rs\$ ph3eD d0es NOT SUppOR+ hT+p U\$ER AuTH3NtIc@+10N";
$lang['successfullyremovedselectedfeeds'] = "succ35\$phulLY RemOVEd \$3LeCT3d Ph3EDs";
$lang['successfullyaddedfeed'] = "sucC35SfULLY ADD3d N3w f33d";
$lang['successfullyeditedfeed'] = "sUcC3SsPHULLy Ed1T3D PH3ed";
$lang['failedtoremovefeeds'] = "f41l3d T0 REm0Ve S0mE or 4lL OPH +3h SELeCTeD f33dS";
$lang['failedtoaddnewrssfeed'] = "f4il3D T0 @dD New RSs PHeeD";
$lang['failedtoupdaterssfeed'] = "f41LEd t0 upDa+3 rS\$ Fe3d";
$lang['rssstreamworkingcorrectly'] = "r\$S s+r3@M 4PP3@rS T0 b3 W0RkING c0rr3C+ly";
$lang['rssstreamnotworkingcorrectly'] = "r\$s s+reaM W4\$ EMPTY 0R c0ulD nOT 8e FouNd";
$lang['invalidfeedidorfeednotfound'] = "iNVaLId pHEed ID 0R PH3Ed n0+ phOUnD";

// PM Export Options

$lang['pmexportastype'] = "exPorT @\$ TYP3";
$lang['pmexporthtml'] = "h+Ml";
$lang['pmexportxml'] = "xML";
$lang['pmexportplaintext'] = "pl4in +3x+";
$lang['pmexportmessagesas'] = "exP0rT m3ss@Ge\$ @S";
$lang['pmexportonefileforallmessages'] = "on3 PH1l3 F0r @LL m3s5@9E\$";
$lang['pmexportonefilepermessage'] = "on3 PH1l3 P3r M3S5a9E";
$lang['pmexportattachments'] = "exP0RT 4++4CHM3n+s";
$lang['pmexportincludestyle'] = "iNcLUD3 PH0rUM stYL3 5h3e+";
$lang['pmexportwordfilter'] = "applY W0RD FIlt3r to m3Ss49es";
$lang['failedtoexportmessages'] = "f4iLeD +o exp0rT MeSs4g3s";

// Thread merge / split options

$lang['threadhasbeensplit'] = "tHrE4D hA5 Be3N \$Pl1+";
$lang['threadhasbeenmerged'] = "tHR3@d H4s b33n M3rg3D";
$lang['mergesplitthread'] = "m3rg3 / SPL1+ +HRe@D";
$lang['mergewiththreadid'] = "meRG3 W1+H +HRE4D 1D:";
$lang['postsinthisthreadatstart'] = "p0\$Ts 1N +H1s THrE4D 4+ S+4R+";
$lang['postsinthisthreadatend'] = "pO\$t\$ in TH1s +HR34D A+ 3Nd";
$lang['reorderpostsintodateorder'] = "r3-0rDeR P0S+\$ iNTO D4Te 0RdER";
$lang['splitthreadatpost'] = "spL1+ THRe4d @T pOsT:";
$lang['selectedpostsandrepliesonly'] = "s3l3cteD P05+ 4ND REPL13S 0NLY";
$lang['selectedandallfollowingposts'] = "seLeCT3D @nd 4lL fOlL0WiN9 po\$+s";

$lang['threadmovedhere'] = "h3RE";

$lang['thisthreadhasmoved'] = "<b>tHre4dS M3r93d:</b> Th15 +HreAD h@s M0ved %s";
$lang['thisthreadwasmergedfrom'] = "<b>thr34DS M3RGED:</b> ThI5 +HREAd W@5 M3rG3d pHroM %s";
$lang['somepostsinthisthreadhavebeenmoved'] = "<b>thREAD \$pL1+:</b> s0ME Po\$+s 1N +hIs +HR34d H@Ve BE3N mOv3d %s";
$lang['somepostsinthisthreadweremovedfrom'] = "<b>thR34D 5pl1t:</b> \$OM3 POS+S In +HI\$ THRe4D were MoV3D pHR0M %s";

$lang['thisposthasbeenmoved'] = "<b>tHR34d SPLIT:</b> +H15 poSt H45 8EEn MovEd %s";

$lang['invalidfunctionarguments'] = "iNVALId FUNc+ION @r9uMEnT\$";
$lang['couldnotretrieveforumdata'] = "c0UlD n0+ r3tRi3V3 F0RUM Da+A";
$lang['cannotmergepolls'] = "on3 OR moRE +hReADS 1s 4 P0Ll. j00 C4NN0T M3RG3 POLl\$";
$lang['couldnotretrievethreaddatamerge'] = "could nOT R3tRI3vE +hrEad d@+4 PHR0M 0n3 0r M0R3 thR34dS";
$lang['couldnotretrievethreaddatasplit'] = "couLD n0T r3TRiEV3 +HrE@D D4+4 pHROm \$0UrCE +hRE@D";
$lang['couldnotretrievepostdatamerge'] = "cOuLD noT Re+R1EvE poS+ d@T@ Fr0m ON3 OR M0RE +Hr34D5";
$lang['couldnotretrievepostdatasplit'] = "c0ULd NO+ rE+r1eVe pO\$+ d@T4 pHR0M \$0Urce +hRE@D";
$lang['failedtocreatenewthreadformerge'] = "f4iLED +o cRE4+3 N3w +HRe@d FOr mer9E";
$lang['failedtocreatenewthreadforsplit'] = "f41l3d +0 crE4te nEw THRe4D PHor \$PLI+";
$lang['nopermissiontomergethreads'] = "j00 @r3 NOT P3RMITTeD +o M3R9e T3h SEl3c+3d +hRE@d5";

// Thread subscriptions

$lang['threadsubscriptions'] = "tHreaD su8sCRIP+ioN5";
$lang['couldnotupdateinterestonthread'] = "c0ulD n0t UPD4+3 inTer35+ 0n +hR3@D '%s'";
$lang['threadinterestsupdatedsuccessfully'] = "thr3Ad in+ER3S+S UpD4tEd \$UCc35\$pHULlY";
$lang['nothreadsubscriptions'] = "j00 4r3 n0+ su8\$cRI8ed TO 4nY +HRE4DS.";
$lang['nothreadsignored'] = "j00 Ar3 n0t 19nORIN9 ANY tHRE4DS.";
$lang['nothreadsonhighinterest'] = "j00 H4VE NO H19h 1N+3rE\$t THr34DS.";
$lang['resetselected'] = "res3t SEleCt3D";
$lang['ignoredthreads'] = "iGn0red THRe@D5";
$lang['highinterestthreads'] = "hi9h INTERe5+ thrE4D\$";
$lang['subscribedthreads'] = "sUB\$CRIB3d +HRe4d5";
$lang['currentinterest'] = "cuRrenT INTeRES+";

// Folder subscriptions

$lang['foldersubscriptions'] = "fOLDeR Su85CR1p+ION5";
$lang['couldnotupdateinterestonfolder'] = "c0ULD noT upd4+E 1n+Er35+ 0n ph0Ld3r '%s'";
$lang['folderinterestsupdatedsuccessfully'] = "f0Ld3R in+ER3s+\$ UPD4+Ed SUccES\$pHULLY";
$lang['nofoldersubscriptions'] = "j00 4RE N0T SU85crI83D +O 4nY f0Ld3R5.";
$lang['nofoldersignored'] = "j00 4re n0+ 1GnOR1nG 4nY FolD3rS.";
$lang['resetselected'] = "rE\$3T \$3lectED";
$lang['ignoredfolders'] = "i9noreD FOLd3rS";
$lang['subscribedfolders'] = "subScr183d foLdER\$";

// Browseable user profiles

$lang['youcanonlyaddthreecolumns'] = "j00 C4n ONLy aDD 3 C0LUMn\$. +O 4DD 4 N3W ColUmn Clo53 4n EXIStiNG onE";
$lang['columnalreadyadded'] = "j00 H4V3 AlrE4DY 4Dd3D +h15 ColumN. 1f J00 wAN+ +0 R3mOVE iT cliCK Its cL0\$e 8uT+On";

?>