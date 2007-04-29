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

/* $Id: x-hacker.inc.php,v 1.230 2007-04-29 14:28:34 decoyduck Exp $ */

// International English language file

// Language character set and text direction options -------------------

$lang['_isocode'] = "en";
$lang['_textdir'] = "ltr";

// Months --------------------------------------------------------------

$lang['month'][1]  = "j4nUaRY";
$lang['month'][2]  = "fE8ru4rY";
$lang['month'][3]  = "m4rCh";
$lang['month'][4]  = "aPR1L";
$lang['month'][5]  = "mAY";
$lang['month'][6]  = "jUN3";
$lang['month'][7]  = "julY";
$lang['month'][8]  = "aUGUs+";
$lang['month'][9]  = "s3P+3m83r";
$lang['month'][10] = "oc+083r";
$lang['month'][11] = "n0v3m83r";
$lang['month'][12] = "deceM8ER";

$lang['month_short'][1]  = "j4N";
$lang['month_short'][2]  = "fE8";
$lang['month_short'][3]  = "m4R";
$lang['month_short'][4]  = "aPR";
$lang['month_short'][5]  = "m@Y";
$lang['month_short'][6]  = "jun";
$lang['month_short'][7]  = "jUl";
$lang['month_short'][8]  = "aUg";
$lang['month_short'][9]  = "seP";
$lang['month_short'][10] = "ocT";
$lang['month_short'][11] = "nov";
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

$lang['date_periods']['year']   = "%s Ye@R";
$lang['date_periods']['month']  = "%s MOnth";
$lang['date_periods']['week']   = "%s week";
$lang['date_periods']['day']    = "%s d4y";
$lang['date_periods']['hour']   = "%s HOur";
$lang['date_periods']['minute'] = "%s mINu+e";
$lang['date_periods']['second'] = "%s \$ECOND";

// As above but plurals (2 years vs. 1 year, etc.)

$lang['date_periods_plural']['year']   = "%s y3@R5";
$lang['date_periods_plural']['month']  = "%s M0NTh\$";
$lang['date_periods_plural']['week']   = "%s week5";
$lang['date_periods_plural']['day']    = "%s d@Ys";
$lang['date_periods_plural']['hour']   = "%s h0Ur5";
$lang['date_periods_plural']['minute'] = "%s MiNut3\$";
$lang['date_periods_plural']['second'] = "%s 53C0nds";

// Short hand periods (example: 1y, 2m, 3w, 4d, 5hr, 6min, 7sec)

$lang['date_periods_short']['year']   = "%sY";    // 1y
$lang['date_periods_short']['month']  = "%sM";    // 2m
$lang['date_periods_short']['week']   = "%sW";    // 3w
$lang['date_periods_short']['day']    = "%sd";    // 4d
$lang['date_periods_short']['hour']   = "%shR";   // 5hr
$lang['date_periods_short']['minute'] = "%sm1n";  // 6min
$lang['date_periods_short']['second'] = "%ssec";  // 7sec

// Common words --------------------------------------------------------

$lang['percent'] = "pERCEnT";
$lang['average'] = "av3R4G3";
$lang['approve'] = "apPr0Ve";
$lang['banned'] = "b@NN3d";
$lang['locked'] = "l0CkED";
$lang['add'] = "aDD";
$lang['advanced'] = "aDV4Nc3D";
$lang['active'] = "aCt1VE";
$lang['style'] = "sTYle";
$lang['go'] = "g0";
$lang['folder'] = "f0lD3R";
$lang['ignoredfolder'] = "i9nOREd PH0Lder";
$lang['folders'] = "foldER5";
$lang['thread'] = "tHRE4d";
$lang['threads'] = "threAds";
$lang['threadlist'] = "tHrE4D l1s+";
$lang['message'] = "me\$S4gE";
$lang['messagenumber'] = "mE\$s49e NumbEr";
$lang['from'] = "fROM";
$lang['to'] = "t0";
$lang['all_caps'] = "all";
$lang['of'] = "oF";
$lang['reply'] = "rEPLy";
$lang['forward'] = "forw4rd";
$lang['replyall'] = "rEPLY to 4lL";
$lang['pm_reply'] = "rePlY As pM";
$lang['delete'] = "deL3+3";
$lang['deleted'] = "del3t3D";
$lang['edit'] = "eD1+";
$lang['privileges'] = "pRiVil3ge\$";
$lang['ignore'] = "iGn0re";
$lang['normal'] = "n0rm4L";
$lang['interested'] = "iN+3re5TEd";
$lang['subscribe'] = "suBsCRi83";
$lang['apply'] = "aPplY";
$lang['submit'] = "sU8m1+";
$lang['download'] = "d0WNl04d";
$lang['save'] = "s4VE";
$lang['update'] = "uPd4+3";
$lang['cancel'] = "c@nC3l";
$lang['continue'] = "con+Inu3";
$lang['attachment'] = "a++4chM3Nt";
$lang['attachments'] = "aT+4chm3n+5";
$lang['imageattachments'] = "iM493 a++achm3n+5";
$lang['filename'] = "fiLen@M3";
$lang['dimensions'] = "diMen51oNS";
$lang['downloadedxtimes'] = "d0wNl0@D3d: %d +im3s";
$lang['downloadedonetime'] = "doWNLO4d3d: 1 +1me";
$lang['size'] = "sIZ3";
$lang['viewmessage'] = "vi3W M3S5@9e";
$lang['deletethumbnails'] = "delet3 +humBN41lS";
$lang['logon'] = "lO90n";
$lang['more'] = "morE";
$lang['recentvisitors'] = "r3c3N+ V1S1+0RS";
$lang['username'] = "us3rn4M3";
$lang['clear'] = "clE@R";
$lang['action'] = "aCt10n";
$lang['unknown'] = "uNKN0Wn";
$lang['none'] = "nOne";
$lang['preview'] = "pr3ViEw";
$lang['post'] = "pO5t";
$lang['posts'] = "pO\$+\$";
$lang['change'] = "cH4N9e";
$lang['yes'] = "ye\$";
$lang['no'] = "no";
$lang['signature'] = "s19N4+UR3";
$lang['signaturepreview'] = "si9N@TuR3 PR3VI3w";
$lang['signatureupdated'] = "s1gn4TurE Upda+ED";
$lang['back'] = "b@Ck";
$lang['subject'] = "sU8J3c+";
$lang['close'] = "cL0S3";
$lang['name'] = "n4Me";
$lang['description'] = "d3sCR1pT10N";
$lang['date'] = "d@+e";
$lang['view'] = "viEW";
$lang['enterpasswd'] = "en+3R P@\$SW0rd";
$lang['passwd'] = "p45sWORd";
$lang['ignored'] = "i9N0RED";
$lang['guest'] = "gu35t";
$lang['next'] = "nExt";
$lang['prev'] = "prev10u\$";
$lang['others'] = "o+her\$";
$lang['nickname'] = "n1CKn@M3";
$lang['emailaddress'] = "em4Il 4dDrE\$\$";
$lang['confirm'] = "c0NPhiRm";
$lang['email'] = "eM@IL";
$lang['newcaps'] = "n3w";
$lang['poll'] = "pOlL";
$lang['friend'] = "fri3nd";
$lang['error'] = "err0R";
$lang['guesterror'] = "s0rrY, J00 NEEd T0 B3 L0G9ed 1N T0 US3 TH1s PH3@TUr3.";
$lang['loginnow'] = "lOgin N0W";
$lang['on'] = "oN";
$lang['unread'] = "unrE4d";
$lang['all'] = "aLL";
$lang['allcaps'] = "all";
$lang['permissions'] = "p3rM15sIoN5";
$lang['type'] = "tyP3";
$lang['print'] = "pR1n+";
$lang['sticky'] = "st1cKY";
$lang['polls'] = "pOlL5";
$lang['user'] = "u\$eR";
$lang['enabled'] = "eN4BlED";
$lang['disabled'] = "disA8l3d";
$lang['options'] = "op+1oN5";
$lang['emoticons'] = "eM0+IC0NS";
$lang['webtag'] = "w38t@9";
$lang['makedefault'] = "m@ke dEpH4Ult";
$lang['unsetdefault'] = "uNS3+ d3ph@UL+";
$lang['rename'] = "r3N@me";
$lang['pages'] = "p4Ge5";
$lang['used'] = "uS3d";
$lang['days'] = "d4y\$";
$lang['usage'] = "us49E";
$lang['show'] = "sh0w";
$lang['hint'] = "h1n+";
$lang['new'] = "n3W";
$lang['referer'] = "r3FEREr";

// Admin interface (admin*.php) ----------------------------------------

$lang['admintools'] = "adMIN t0OLs";
$lang['forummanagement'] = "fOruM M4n@G3M3n+";
$lang['accessdenied'] = "acce\$s d3nIed";
$lang['accessdeniedexp'] = "j00 d0 N0+ H4V3 P3rMI\$51ON +0 US3 +hIS seCT10N.";
$lang['managefolders'] = "m@n4Ge PhOld3rs";
$lang['manageforums'] = "m4n4ge PH0ruMs";
$lang['manageforumpermissions'] = "m4N49E f0RUm P3rM1\$siON\$";
$lang['foldername'] = "fOLd3R N4M3";
$lang['move'] = "m0v3";
$lang['closed'] = "cLo\$3D";
$lang['open'] = "op3N";
$lang['restricted'] = "r3\$+RiCt3d";
$lang['iscurrentlyclosed'] = "i\$ CurR3ntlY cL0\$ed";
$lang['youdonothaveaccessto'] = "j00 dO nO+ H4V3 acC35s T0";
$lang['toapplyforaccessplease'] = "to 4pPly pH0r @CCEs5 PlE45E C0NT4CT thE fORum 0Wner.";
$lang['adminforumclosedtip'] = "iPH j00 w@n+ T0 CH4NG3 50ME Se+t1n9\$ 0n yOUr forum cLick THe 4dm1n link in +eh N@v1g4t1oN B@r @bovE.";
$lang['newfolder'] = "n3w PhoLd3R";
$lang['forumadmin'] = "f0rUM 4DmIn";
$lang['adminexp_1'] = "u5E +HE m3nu 0N THE l3ft tO m4N@93 th1Ng\$ iN y0Ur f0ruM.";
$lang['adminexp_2'] = "<b>userS</b> 4LL0ws j00 +0 \$ET 1ndivIduaL u5eR P3rm15S10NS, iNcLUD1N9 4ppo1Nting 3dIT0R\$ @nd g49g1ng pEopl3.";
$lang['adminexp_3'] = "<b>u\$Er 9R0ups</b> 4LLOw5 J00 +O CreA+3 u5eR 9rOuPs T0 @ss19n p3rM15\$i0Ns +0 As m@NY oR 4\$ PH3w usER\$ Qu1CKlY 4Nd 3451Ly.";
$lang['adminexp_4'] = "<b>b@N coN+rOL5</b> alLoWS T3h B@NniNg @Nd un-B4nniNg oF IP aDdRE5\$35, USErN@mes, EM4iL 4Ddr3\$s3s 4ND N1CKN4m3s.";
$lang['adminexp_5'] = "<b>foldER\$</b> ALl0w\$ T3H Cr3@tion, M0D1PH1c4t1ON 4nd d3l3ti0N 0ph FolD3Rs.";
$lang['adminexp_6'] = "<b>rs5 F33D\$</b> All0w5 j00 to cR34+E 4nd r3m0V3 rs5 pheeds pHoR Pr0p094T10N 1n+O Y0UR f0rUm.";
$lang['adminexp_7'] = "<b>pRoPhil3S</b> L3tS j00 CuSt0M1SE The I+em\$ th@t 4PP34r IN Teh u53r PR0PhiL3s.";
$lang['adminexp_8'] = "<b>f0ruM S3+tIN9s</b> Allow5 J00 tO CUsT0M1s3 Y0Ur phoruM'\$ n4ME, @pP34R4NcE @Nd m@nY OTHer +HiN9s.";
$lang['adminexp_9'] = "<b>sT4rt p493</b> Le+5 j00 CUsTom1s3 yOur F0RuM'\$ s+@rT p4GE.";
$lang['adminexp_10'] = "<b>f0ruM 5tyle</b> 4lL0w\$ j00 +O crea+e STYl3S ph0R Y0Ur Ph0rUm M3mBers +O Use.";
$lang['adminexp_11'] = "<b>w0Rd PHiLter</b> 4ll0wS J00 T0 ph1L+3r W0rds J00 Don'+ w4Nt +0 b3 u\$eD 0n y0UR pH0rUM.";
$lang['adminexp_12'] = "<b>po5Ting s+@ts</b> g3n3ra+es 4 rEPOR+ LIS+Ing +eh +0P 10 p0s+ERS 1N @ D3FIN3D peR10D.";
$lang['adminexp_13'] = "<b>f0rum l1NK\$</b> l3ts J00 M@N@gE +h3 L1NK\$ dR0pDOWn IN Teh N4v1g4t1oN b4r.";
$lang['adminexp_14'] = "<b>v13W lo9</b> Li\$tS reC3nt @CT10NS by +h3 f0ruM MOD3r4tOrS.";
$lang['adminexp_15'] = "<b>m@na9e pHORUM5</b> L3+s J00 cR34te 4nD D3l3+3 @nd cl0s3 0r R3OP3n Ph0RuMS.";
$lang['adminexp_16'] = "<b>gL084L foRum 53ttiN9\$</b> 4Llows j00 To M0DIFY 53++iN95 WHiCH aPHFeC+ AlL PHoRUmS.";
$lang['adminexp_17'] = "<b>post APpRov@L qU3u3</b> @lL0WS J00 +o V13w ANy pO\$ts 4w41+iN9 4PpROV4L bY @ m0D3r4t0R.";
$lang['adminexp_18'] = "<b>vi5i+OR LOg</b> @lLOW\$ j00 +0 v13W @N 3X+EnDED LiSt 0f vi5i+or5 inCLUD1n9 +He1r htTp rEpHeRers.";
$lang['createforumstyle'] = "cRe@Te 4 PhorUm \$tYlE";
$lang['newstylesuccessfullycreated'] = "n3w styl3 %s \$ucce\$SphulLy CRE@T3D.";
$lang['stylealreadyexists'] = "a \$tYL3 wi+h TH4+ F1l3N4M3 @LrEADy 3Xi5+s.";
$lang['stylenofilename'] = "j00 d1D NOt eN+3r 4 ph1LEn4Me +0 s4Ve +EH S+YLe WI+H.";
$lang['stylenodatasubmitted'] = "c0uld n0+ R34d pH0Rum 5TYL3 D4+4.";
$lang['styleexp'] = "u\$3 +h1s P@gE +O hELP cr3@+E 4 RAND0mLY 93n3r4TED 5+YlE FOr y0Ur f0rum.";
$lang['stylecontrols'] = "coNTr0l5";
$lang['stylecolourexp'] = "clICK 0n 4 col0UR +0 M4k3 4 n3W \$Tyle \$h33T b4\$3D ON +H@+ ColouR. cURrEnT 84\$3 col0UR IS PhIRst 1n LI\$+.";
$lang['standardstyle'] = "st4nDarD 5+yL3";
$lang['rotelementstyle'] = "r0t4+3d 3lEMEnt \$+Yle";
$lang['randstyle'] = "r4ndom \$+YL3";
$lang['thiscolour'] = "thIS c0LOUr";
$lang['enterhexcolour'] = "or 3nteR @ h3X Col0uR +0 84\$E @ nEw s+YLe \$h33T on";
$lang['savestyle'] = "s4V3 th15 5tYl3";
$lang['styledesc'] = "s+Yle DEsCR1P+10N";
$lang['fileallowedchars'] = "(LoWerc@\$e l3+tEr\$ (4-Z), NUm83R\$ (0-9) @ND unD3r\$CoR3S (_) onLy)";
$lang['stylepreview'] = "sTyL3 prEv1ew";
$lang['welcome'] = "welCOM3";
$lang['messagepreview'] = "mEs54G3 pr3viEw";
$lang['users'] = "uSer\$";
$lang['usergroups'] = "u\$3r grOUpS";
$lang['mustentergroupname'] = "j00 mu\$T en+3R 4 9rOuP n@Me";
$lang['profiles'] = "pr0fIle\$";
$lang['manageforums'] = "m4N493 F0RumS";
$lang['forumsettings'] = "f0rUM S3+TiN9S";
$lang['globalforumsettings'] = "glo84L pH0rum 53t+1NGs";
$lang['settingsaffectallforumswarning'] = "<b>nO+e:</b> TH3se \$3t+InGS 4phPhEC+ 4ll fOruM5. wh3r3 +He 5ET+1Ng I5 DUpLiC@T3D 0n TEH 1nD1viDu@L PH0ruM'\$ \$3Tt1n9\$ P4ge +h4+ WilL T@k3 pR3CEDEnCE oV3r thE SE++1NG\$ J00 cH4N93 Her3.";
$lang['startpage'] = "sT@RT p@gE";
$lang['startpageerror'] = "yOUr st4R+ pA93 couLd no+ 83 s4vEd loC@llY +0 +H3 \$3RVer 8eCAu\$3 pErmis\$1on W@s dENi3d. +o ch4NGE y0uR sT4Rt P@9e pl3aS3 CL1ck th3 D0WnL0AD Butt0n 8EL0w wH1Ch w1lL PROMP+ J00 to \$AVE +He pHILe T0 y0ur H@rD dr1ve. j00 c@n +HeN uPL04d th15 PHiL3 t0 yOuR S3rVER in+0 %s ph0lDEr, if N3CEss4ry CRe@+ING +h3 f0lD3r 5TRUC+ur3 1N th3 PRoce5s. pLe4\$3 N0+3 TH4+ some 8ROws3rS M4Y Ch4N9E thE n@Me OF th3 PH1l3 UP0N DownL0@d.  wH3N Upl0@ding TEh F1l3 pl34se MAke 5Ure +H@t It iS NaMED \$T4R+_M41N.PHP o+hERWIS3 Y0ur s+4r+ P49E wiLL 4pPe@R UNCH4n9eD.";
$lang['failedtoopenmasterstylesheet'] = "y0uR ph0ruM 5Tyl3 C0ULd n0t Be 5@vED 8EC4USe thE M@s+3r sTYLe \$HEet coUlD No+ 8E lo4Ded. t0 s4ve y0ur \$TyLE TeH m45+Er S+Yl3 5H33+ (M4KE_\$TylE.cs5) MU\$+ 83 L0c4TED 1N ThE s+yLE5 dIRec+ORY Of y0Ur b3Eh1VE f0rum 1nst4lL4t10n.";
$lang['makestyleerror'] = "y0UR phORUM s+Yl3 C0uld N0T 83 s4v3d L0C@lLY to +he \$3rVEr B3c4Use p3rMI\$s1ON W4\$ deNi3D. tO S4V3 yOUr F0RUm STyL3 pl34S3 cl1ck tH3 DoWnl04D bu+T0N 8ELow Wh1CH W1ll Pr0MP+ J00 t0 \$4V3 +3h pH1l3 +0 Y0UR h4Rd dr1v3. j00 C@n tH3N UpLO4D tHIs fil3 TO y0uR \$3rV3R 1n+o %s fOLDER, 1f NEC3s\$4ry CR34+1n9 +h3 PH0Ld3r \$tRuc+Ur3 1N tHE pr0c35S. j00 \$hould No+3 +H@T sOME bR0w\$3r5 May CH@n9e +eH N4M3 oPh ThE ph1l3 UPon doWNL0@d. Wh3N uPL0AD1NG +3H pHIL3 PLe4Se m4KE \$Ure +HAt I+ Is N4med s+YLe.c\$\$ OTheRwI53 +Eh f0RUm \$+YLE WIlL be uNU\$ABL3.";
$lang['uploadfailed'] = "yOuR new \$t4r+ p49e COuld nO+ 8E UpL0@D3d TO tEH sERV3r 83c@usE PErM155I0N w45 dEniEd. pl34s3 Check +hAt +He WEB sErVER / PhP Proce55 1S 4BLE +0 WRi+3 t0 teh %s FoLd3r on yoUr s3rV3r.";
$lang['makestylefailed'] = "yOuR N3W Ph0Rum S+YL3 COuLD N0T 8E s@vEd +O +3H serVer BEc@U5E p3Rm1S\$iON W@S d3n13D. pLe4s3 cheCK +H4T +He wE8 \$3rV3r / phP pRoce\$5 1\$ @Bl3 t0 wRi+3 +0 T3H %s pHOlD3r On YOUR \$3RVER.";
$lang['forumstyle'] = "f0rum \$+yL3";
$lang['wordfilter'] = "wORd f1lTeR";
$lang['forumlinks'] = "fORum lINkS";
$lang['viewlog'] = "v1Ew Log";
$lang['noprofilesectionspecified'] = "n0 PRopH1l3 \$3cTi0N \$p3cIfi3d.";
$lang['itemname'] = "iTEM n@me";
$lang['moveto'] = "mOvE TO";
$lang['editsection'] = "eD1+ s3C+i0n";
$lang['manageprofilesections'] = "m4N49E pROphIle 53C+Ion\$";
$lang['sectionname'] = "s3c+10N N4mE";
$lang['items'] = "i+3m5";
$lang['mustspecifyaprofilesectionid'] = "must SpEC1PHy @ Pr0pHIL3 SeCT1On Id";
$lang['mustsepecifyaprofilesectionname'] = "mUs+ sPec1Phy 4 PRoF1l3 S3c+i0N N4me";
$lang['successfullyeditedprofilesection'] = "sUcCe\$sphully eDitED proFile SeCTIoN";
$lang['addnewprofilesection'] = "adD nEW PrOfiLE 53cTI0n";
$lang['mustsepecifyaprofilesectionname'] = "mUST Sp3c1FY @ pR0PHIlE 5eCtIOn N4mE";
$lang['successfullyremovedselectedprofilesections'] = "suCc35\$FUlly R3mOV3d S3LeCt3D pR0FiL3 \$ECT10N\$";
$lang['failedtoremoveprofilesections'] = "f4iled t0 R3MOv3 PROPH1L3 SeCt1on\$";
$lang['viewitems'] = "vI3w 1TEM5";
$lang['successfullyremovedselectedprofileitems'] = "suCceS5PhULly R3m0V3d seleCt3d PR0f1l3 1+3Ms";
$lang['failedtoremoveprofileitems'] = "f@1l3d +0 r3MoV3 ProPHil3 1+EM\$";
$lang['noexistingprofileitemsfound'] = "th3R3 4rE No 3X15t1N9 pr0pHIl3 Item\$ 1n +h1s S3CtI0N. tO 4dD 4 pr0FIlE 1tem CL1ck th3 but+0n B3l0w.";
$lang['edititem'] = "eDi+ i+eM";
$lang['invaliditemidoritemnotfound'] = "iNV@L1D i+3M 1D 0r i+3M noT f0UND";
$lang['addnewitem'] = "aDd NeW 1tem";
$lang['startpageupdated'] = "sT4RT P@9e upD@tEd";
$lang['viewupdatedstartpage'] = "vIeW UPD4TEd \$t@r+ p49e";
$lang['editstartpage'] = "edI+ ST4R+ p4g3";
$lang['nouserspecified'] = "n0 U\$eR \$peC1fI3D.";
$lang['manageuser'] = "m@NAGe U5ER";
$lang['manageusers'] = "m4NA9e US3r\$";
$lang['userstatus'] = "u5ER s+4+u\$ (CUrR3n+ pH0RUM)";
$lang['userdetails'] = "u\$3r Det4Il\$";
$lang['nicknameheader'] = "n1ckn4Me:";
$lang['warning_caps'] = "w@Rn1n9";
$lang['userdeleteallpostswarning'] = "ar3 j00 SUre j00 W4Nt +0 DEl3+3 4lL oPh tHe SEl3C+ED U\$3R's p05+s? 0ncE +Eh pOSt\$ 4Re d3LEt3D +h3y C4NN0t 83 rE+RI3vED @Nd w1ll 8E l0St fOR3VeR.";
$lang['postssuccessfullydeleted'] = "pOstS Wer3 SuCC3S\$FuLlY D3l3+3d.";
$lang['folderaccess'] = "f0lder @CcesS";
$lang['possiblealiases'] = "pO\$5i8lE aL1@SE5";
$lang['userhistory'] = "user H1\$torY";
$lang['nohistory'] = "n0 HISTORy REC0RD5 saV3d";
$lang['userhistorychanges'] = "cH@n93S";
$lang['clearuserhistory'] = "cl34R u53R h1S+0rY";
$lang['changedlogonfromto'] = "ch@n93D l090N PhR0m %s T0 %s";
$lang['changednicknamefromto'] = "ch4nG3d nICkN@mE PHRom %s T0 %s";
$lang['changedemailfromto'] = "cH4n9ed 3m41l PHr0M %s +0 %s";
$lang['usersettingsupdated'] = "uS3r 5E+t1n9\$ 5ucC3SsfuLLy UPD@+ed";
$lang['nomatches'] = "no m4+Che5";
$lang['deleteposts'] = "dele+3 p05TS";
$lang['deleteallusersposts'] = "d3L3+3 4ll oPh +h1S U53r'S P0\$T\$";
$lang['noattachmentsforuser'] = "n0 @+T@Chm3nT5 PHOR TH1s uS3R";
$lang['forgottenpassworddesc'] = "iph thIS uS3R HaS PhOrg0++eN TH3iR p@S\$woRD j00 c@n Re\$3+ IT phoR +heM H3rE.";
$lang['manageusersexp'] = "thI5 l1\$+ Sh0w\$ @ SEl3cTi0N 0Ph u\$er5 WH0 h@vE lo993d ON +o Y0UR f0RUm, 50RteD 8Y %s. +o @lt3r 4 usER's perM1\$\$10nS cliCK +h3iR naME.";
$lang['userfilter'] = "uS3r pHiL+eR";
$lang['onlineusers'] = "onL1N3 u\$3Rs";
$lang['offlineusers'] = "ofphliNe Us3Rs";
$lang['usersawaitingapproval'] = "uSeR\$ @w4IT1nG 4ppROv4L";
$lang['bannedusers'] = "bAnnEd U\$ER5";
$lang['lastlogon'] = "l4\$t L0G0n";
$lang['sessionreferer'] = "s35sIOn r3PhErEr";
$lang['signupreferer'] = "s19n-up rEf3R3R:";
$lang['nouseraccounts'] = "n0 u\$3r 4ccounT\$ iN d4+48453.";
$lang['nouseraccountsmatchingfilter'] = "n0 u5eR 4Cc0UNtS MatCh1ng pHIL+3R";
$lang['searchforusernotinlist'] = "s3@rCH F0r @ U53r NOt 1n li\$T";
$lang['adminaccesslog'] = "adMiN 4CCEsS lo9";
$lang['adminlogexp'] = "thi5 LI\$T \$h0WS +he L4\$T 4C+10NS 54nc+10Ned 8y uSErs W1Th @dM1n privIL3935.";
$lang['datetime'] = "date/+Ime";
$lang['unknownuser'] = "unKnOwN US3r";
$lang['unknownfolder'] = "unKN0WN PHoLdEr";
$lang['ip'] = "iP";
$lang['lastipaddress'] = "l45+ ip @ddR3SS";
$lang['logged'] = "l09G3d";
$lang['notlogged'] = "n0+ L0gg3D";
$lang['addwordfilter'] = "adD WOrD F1L+3r";
$lang['addnewwordfilter'] = "aDD neW W0rD pHIL+3r";
$lang['wordfilterupdated'] = "w0Rd phil+3R UPDA+ED";
$lang['filtertype'] = "fIlTER tYP3";
$lang['editwordfilter'] = "ed1+ W0rD PhiLT3R";
$lang['wordfilterexp_2'] = "p3Rl-comPA+1BL3 regUl4R 3XPR3s\$iON5 C4n 4l50 b3 U5ed t0 M4tCh W0rdS 1PH j00 Kn0W h0W.";
$lang['wordfilterexp_3'] = "uS3 +H1\$ p4g3 t0 3D1T Y0uR P3rSon@l W0rd ph1L+er. pL@C3 e@Ch WORD T0 8E f1L+EREd 0N @ n3W l1N3.";
$lang['wordfilterisfull'] = "j00 C4nNo+ 4dd 4Ny mOre Word f1lt3R\$. REMOVE s0mE uNu5Ed 0n3s Or ed1+ T3H 3x1\$TIN9 oN3\$ f1rs+.";
$lang['nowordfilterentriesfound'] = "n0 3x1\$TiN9 W0rD f1lT3R EnTR13S FOUNd. t0 4dD @ Word pHIlt3R cL1CK tHE butT0N b3LoW.";
$lang['mustspecifymatchedtext'] = "j00 MuST SPec1fy m4+ched TExt";
$lang['mustspecifyfilteroption'] = "j00 Mu5T 5Pec1FY 4 F1lTeR 0PT10N";
$lang['mustspecifyfilterid'] = "j00 mu\$+ \$p3CIphY 4 Philt3R ID";
$lang['invalidfilterid'] = "invaliD F1l+eR 1d";
$lang['failedtoupdatewordfilter'] = "f@iL3d +O UPD4+e wORD Filt3r. CH3CK +H@+ thE fILT3R StiLL Exi\$+\$.";
$lang['allow'] = "alL0W";
$lang['normalthreadsonly'] = "n0RM4L ThR34dS only";
$lang['pollthreadsonly'] = "p0Ll +HRe@ds 0NLY";
$lang['both'] = "b0+h +hR34D +yp35";
$lang['existingpermissions'] = "exIs+iN9 PerM1\$s10Ns";
$lang['nousers'] = "nO U\$3r\$";
$lang['searchforuser'] = "s3@Rch Phor USer";
$lang['browsernegotiation'] = "broW53R N3GOti4+eD";
$lang['largetextfield'] = "l@r9E +3X+ FI3ld";
$lang['mediumtextfield'] = "mEdiUm tEX+ fiELD";
$lang['smalltextfield'] = "smAlL +3XT f1Eld";
$lang['multilinetextfield'] = "muL+1-L1N3 +3X+ FiElD";
$lang['radiobuttons'] = "r4D10 Bu++0NS";
$lang['dropdown'] = "dROP DowN";
$lang['threadcount'] = "thre4d CounT";
$lang['fieldtypeexample1'] = "f0r r@di0 8Ut+0ns AND droP d0WN fIeLds J00 n33d +o sEP4R@t3 +hE phi3lDN@mE @nd tHe v4LUE\$ WITH @ coLOn 4ND 3AcH V4lue 5h0uld b3 s3p4R4ted 8Y 5eMi-c0lon5.";
$lang['fieldtypeexample2'] = "eX@mPLe: +O CRE4+E 4 8a\$1C 9END3R r@di0 8ut+0n5, WI+h tW0 5eLEc+i0N5 fOR MaL3 4ND F3male, J00 w0ULd eNTER: <b>g3Nder:m4L3;pHEm4LE</b> iN +h3 ITEM N4Me ph1ElD.";
$lang['editedwordfilter'] = "eD1Ted w0Rd PHIl+3r";
$lang['editedforumsettings'] = "ed1t3D PH0Rum 53tt1N95";
$lang['sessionsuccessfullyended'] = "suCc3\$5PhULly EnDeD 535siON5 phor SELEc+3D u53r5";
$lang['kickselectedwarning'] = "are J00 \$ur3 j00 WANt to kICk +3H 53LeC+3D uSERS?";
$lang['matchedtext'] = "m4tChEd +ex+";
$lang['replacementtext'] = "r3pLACeMEN+ Tex+";
$lang['preg'] = "pr3g";
$lang['wholeword'] = "whOle WOrD";
$lang['word_filter_help_1'] = "<b>alL</b> MATCh3s 4G4InS+ t3H Wh0lE T3xt \$o f1L+erin9 m0m +O MuM w1LL 4Lso CH@n9E mom3nT +0 MUm3nT.";
$lang['word_filter_help_2'] = "<b>wH0l3 wORd</b> MAtchE\$ aG@1NS+ wh0LE WOrdS 0NlY SO fIlT3R1N9 MOM +0 MUm w1Ll nO+ ch4N9E MOmen+ +O MUm3nT.";
$lang['word_filter_help_3'] = "<b>prE9</b> All0Ws j00 +O USE P3Rl rE9Ul4R ExPr3sSi0N5 T0 matCH +ex+.";
$lang['nameanddesc'] = "n@mE 4nD DeSCR1p+10n";
$lang['movethreads'] = "m0v3 +HRE4D\$";
$lang['threadsmovedsuccessfully'] = "tHr34d\$ M0v3D 5UCCesSFULly";
$lang['movethreadstofolder'] = "moVE THr34ds T0 ph0lDeR";
$lang['resetuserpermissions'] = "resE+ U\$3R PeRm1\$\$10n\$";
$lang['userpermissionsresetsuccessfully'] = "uS3R PeRM1SS1ON5 R3\$3T \$uCce\$SPhULLy";
$lang['allowfoldertocontain'] = "aLl0W Ph0LDeR +0 c0nt4In";
$lang['addnewfolder'] = "add neW PH0lD3r";
$lang['mustenterfoldername'] = "j00 mU5t 3nT3r @ ph0LdER n4m3";
$lang['nofolderidspecified'] = "n0 ph0ldER id 5pEc1f13D";
$lang['invalidfolderid'] = "inVal1D f0LD3R Id. CH3ck +H4t @ PholDeR W1tH +HI\$ 1D Ex1St\$!";
$lang['successfullyaddedfolder'] = "sUccE\$5pHUlLY 4dd3D FOld3R";
$lang['successfullydeletedfolder'] = "sUcc3s5pHuLLY d3l3+ED Ph0lDeR";
$lang['failedtodeletefolder'] = "f@1lEd +O dELE+3 ph0LDeR.";
$lang['folderupdatedsuccessfully'] = "fOLd3r uPD@T3d SUcC3S\$fuLLy";
$lang['cannotdeletefolderwiththreads'] = "c4nNo+ d3l3te FOld3r\$ THa+ \$+1ll cONT41N tHrE4D\$.";
$lang['forumisnotrestricted'] = "foruM 1s N0T re\$tRIc+ed";
$lang['groups'] = "gr0uP\$";
$lang['nousergroups'] = "n0 us3R 9Roup5 h@v3 b33N 53+ uP";
$lang['suppliedgidisnotausergroup'] = "sUPPLIEd G1D i5 n0t 4 US3R GROUp";
$lang['manageusergroups'] = "m4n49e u53R 9rOUPs";
$lang['groupstatus'] = "gROUp 5+4+U5";
$lang['addusergroup'] = "aDD 9roUP";
$lang['addremoveusers'] = "aDd/REMoV3 u5Er\$";
$lang['nousersingroup'] = "th3re @Re n0 u\$3Rs iN +Hi\$ gr0up";
$lang['useringroups'] = "tH1\$ user 1s @ mEMBer 0Ph Th3 Ph0ll0wIng 9ROUPS";
$lang['usernotinanygroups'] = "thi\$ U\$3r is no+ 1N anY U53R gr0uP\$";
$lang['usergroupwarning'] = "n0+3: +H15 uSER mAY be iNH3rIT1n9 4dD1+1ON@l Perm1Ss1onS pHr0M @NY uSER 9r0ups lI\$t3D 8EL0W.";
$lang['successfullyaddedgroup'] = "sucC35sPhULly 4DDed gR0Up";
$lang['successfullydeletedgroup'] = "sucCes5fuLlY DEl3t3D 9r0uP";
$lang['usercanaccessforumtools'] = "u\$Er c@n 4cCE55 PHorum +00Ls @Nd C4n cr3at3, DeL3t3 @nd 3di+ FORUms";
$lang['usercanmodallfoldersonallforums'] = "uS3R c@n MOd3R4TE <b>aLL ph0lDer\$</b> oN <b>alL F0rUMs</b>";
$lang['usercanmodlinkssectiononallforums'] = "usEr C@N M0dEr@+3 L1nKs S3CT1oN ON <b>all FORum5</b>";
$lang['emailconfirmationrequired'] = "eM@1L c0Nf1rM@+ion r3qUirED";
$lang['userisbannedfromallforums'] = "us3r 1s 84nn3d FrOM <b>aLL PhOrum5</b>";
$lang['cancelemailconfirmation'] = "c4nCeL Em41L c0Nphirm4+i0n @ND @LL0W usEr +0 \$t@Rt pOS+Ing";
$lang['resendconfirmationemail'] = "r3sEND cOnpHIrm4+i0N em41l +0 UsEr";
$lang['donothing'] = "dO N0TH1N9";
$lang['usercanaccessadmintools'] = "uSER H@s @Cce\$S +0 pH0RuM 4Dmin +0oLs";
$lang['usercanaccessadmintoolsonallforums'] = "us3r h4S @CcE\$S tO @dMin T00Ls <b>on ALL f0RUm5</b>";
$lang['usercanmoderateallfolders'] = "u53r c4N M0Der4+3 @ll fold3rS";
$lang['usercanmoderatelinkssection'] = "usEr c4n moD3r4T3 LInK\$ s3ct10n";
$lang['userisbanned'] = "u\$eR 1s b4NN3D";
$lang['useriswormed'] = "user i\$ WORMED";
$lang['userispilloried'] = "u5eR 1\$ Pillor1eD";
$lang['usercanignoreadmin'] = "u\$3R C@n 19n0R3 4DMiNi5TR@+Or5";
$lang['groupcanaccessadmintools'] = "grouP c@N @CC3\$\$ aDm1n +o0lS";
$lang['groupcanmoderateallfolders'] = "gRouP c4N mOdEr@+3 4lL fOld3r\$";
$lang['groupcanmoderatelinkssection'] = "gRoUP C@N M0deRAT3 lInKS s3Ct1Ons";
$lang['groupisbanned'] = "groUp i5 b@NN3d";
$lang['groupiswormed'] = "gR0UP 1S W0RMeD";
$lang['readposts'] = "re@D po\$T\$";
$lang['replytothreads'] = "r3PLY +0 +HRE4DS";
$lang['createnewthreads'] = "cr34+E N3w tHre4D5";
$lang['editposts'] = "edI+ P05T5";
$lang['deleteposts'] = "d3let3 POS+5";
$lang['uploadattachments'] = "upl0Ad 4+T4cHMEntS";
$lang['moderatefolder'] = "m0d3R@Te fOLdEr";
$lang['postinhtml'] = "p05T iN hTML";
$lang['postasignature'] = "p0St 4 siGn4+uR3";
$lang['editforumlinks'] = "ed1+ PhORUM L1NK\$";
$lang['editforumlinks_exp'] = "us3 ThI\$ P49E +o adD l1NK5 +O Th3 Dr0P-D0WN li\$t D1\$pl4YeD in thE +0p-r19H+ 0F TH3 f0rum fr@ME\$3T. IF N0 L1nKS ar3 5e+, +3h DROP-doWn lI\$t WIll noT be DIsPLAyed.";
$lang['notoplevellinktitlespecified'] = "n0 +0P levEl l1NK Ti+L3 speC1f13d";
$lang['toplinktitlesuccessfullyupdated'] = "top l3v3L LInK Ti+Le SuCC3s\$FULLY uPd4T3d";
$lang['youmustenteralinktitle'] = "j00 MusT eN+3r 4 lInk +iTlE";
$lang['alllinkurismuststartwithaschema'] = "aLL LInK Uris mU5T S+4RT w1th @ SCh3M@ (1.3. Ht+p://, FTp://, IRc://)";
$lang['noexistingforumlinksfound'] = "tH3r3 4re nO 3Xi\$t1N9 ph0ruM L1NkS. +O 4DD 4 phoRUm l1nk clICk the bU+T0n 8EloW.";
$lang['editlink'] = "ed1t l1Nk";
$lang['addnewforumlink'] = "aDD nEW foRUM liNK";
$lang['forumlinktitle'] = "f0rUM l1nk t1+Le";
$lang['forumlinklocation'] = "fOrum l1nK LOc@t1on";
$lang['successfullyaddedlink'] = "sUCCE5\$fULly @DdeD LiNk: '%s'";
$lang['successfullyeditedlink'] = "sUcC3\$5fully ed1TEd l1nK: '%s'";
$lang['invalidlinkidorlinknotfound'] = "inV4L1d l1nK Id 0r l1NK nO+ PhouND";
$lang['successfullyremovedselectedlinks'] = "sUCcE\$5fUlly Rem0ved \$eL3cTed l1nk\$";
$lang['failedtoremovelinks'] = "f4iL3d +o r3MOV3 Selec+eD L1NkS";
$lang['failedtoaddnewlink'] = "f4IL3D T0 4dd n3w lINk: '%s'";
$lang['failedtoupdatelink'] = "fAIl3d t0 UPD4tE link: '%s'";
$lang['toplinkcaption'] = "t0P L1nK cAPtion";
$lang['allowguestaccess'] = "aLl0w 9uES+ 4cc35\$";
$lang['searchenginespidering'] = "se@RcH eNG1ne \$P1Der1nG";
$lang['allowsearchenginespidering'] = "aLl0W 53aRcH 3N91n3 \$pIDERin9";
$lang['newuserregistrations'] = "n3w USeR reg1STr4+i0N5";
$lang['preventduplicateemailaddresses'] = "pREv3NT dUplIca+E EM41L 4DDR3s\$35";
$lang['allownewuserregistrations'] = "aLLOW New USER r39I\$tr@T1ON5";
$lang['requireemailconfirmation'] = "reQuIRE 3maIl C0nfirM4t1oN";
$lang['usetextcaptcha'] = "usE tEXT-CApTch4";
$lang['textcaptchadir'] = "teX+-C4PTCH4 d1rEcT0rY";
$lang['textcaptchakey'] = "tex+-C@p+cHa K3y";
$lang['textcaptchafonterror'] = "t3xT-c4ptcH4 h4s B33N D1SABLED @U+OMAtIC4Lly 83C4u\$E tH3R3 @R3 N0 TruE +yP3 PHOn+S @v@Il48L3 FOr 1+ +0 u\$e. PL3@S3 UPlO4d somE +ru3 TyPe pHOnt5 +o <b>%s</b> On y0ur \$ERV3R.";
$lang['textcaptchadirerror'] = "t3x+-CapTCh@ H4\$ Be3n dIs@8LeD 83c@USE T3h T3x+_caP+ch@ D1Rec+0RY 4ND i+'s 5ub-DiRECt0RiEs @R3 N0T WrIt@bl3 By +HE WE8 \$3RV3r / pHP pR0c3\$s.";
$lang['textcaptchagderror'] = "t3x+-C4PTCH@ h@S B3en DISa8LEd 83C@usE YoUr s3RVEr's pHp 5etUP d03\$ NO+ prOv1de sUPPoRT pH0R Gd 1m4G3 m@nipUl@ti0n @nD / or ttf PH0nt 5uPpORT. B0th 4R3 ReQuir3D FoR +Ext-cAP+ch4 5UpP0RT.";
$lang['textcaptchadirblank'] = "t3xt-c@pTcH4 d1ReCt0Ry I5 Bl@nK!";
$lang['newuserpreferences'] = "n3W u5eR PR3PheR3NC3S";
$lang['sendemailnotificationonreply'] = "em@1l No+if1c4+I0N 0n REplY T0 uSeR";
$lang['sendemailnotificationonpm'] = "emAiL no+if1C@+i0n On PM to U\$3R";
$lang['showpopuponnewpm'] = "sh0w poPup WHEN REC3IviN9 N3w pM";
$lang['setautomatichighinterestonpost'] = "s3T 4u+0M@T1c H19h iNteR3st ON p0s+";
$lang['top20postersforperiod'] = "tOp 20 pOsTErs F0r pEr1OD %s t0 %s";
$lang['postingstats'] = "pOS+1nG \$+4+S";
$lang['nodata'] = "n0 d4t4";
$lang['totalposts'] = "t0+4L P05T5";
$lang['totalpostsforthisperiod'] = "to+4l Po\$+5 f0R ThI5 P3RIod";
$lang['mustchooseastartday'] = "mU\$+ ch0O\$e @ sT@R+ D4Y";
$lang['mustchooseastartmonth'] = "mU\$T Cho0\$3 4 \$+4r+ m0ntH";
$lang['mustchooseastartyear'] = "must cH0Ose 4 st4rT yE4r";
$lang['mustchooseaendday'] = "mu5T ch0Ose 4 3ND D4Y";
$lang['mustchooseaendmonth'] = "mu\$+ CHooSE 4 END M0N+h";
$lang['mustchooseaendyear'] = "mus+ CHOOs3 4 END Ye4R";
$lang['startperiodisaheadofendperiod'] = "st4r+ PER1od i5 4He@d opH 3nD P3Ri0D";
$lang['bancontrols'] = "b@N C0N+rol5";
$lang['addban'] = "aDd B4n";
$lang['checkban'] = "cH3ck Ban";
$lang['editban'] = "edI+ b4n";
$lang['bantype'] = "b4N +YP3";
$lang['bandata'] = "b4n d4+@";
$lang['bancomment'] = "c0Mm3n+";
$lang['ipban'] = "iP B4n";
$lang['logonban'] = "lO9ON 84n";
$lang['nicknameban'] = "n1CKN@m3 B@N";
$lang['emailban'] = "eM@IL 8@n";
$lang['refererban'] = "rePHerEr 84N";
$lang['invalidbanid'] = "iNV4liD b4n 1d";
$lang['affectsessionwarnadd'] = "tHI5 B4n m@Y @pHFec+ +3h F0LLOWING 4C+IV3 U\$Er \$355ion5";
$lang['noaffectsessionwarn'] = "this b4N 4FPHEct5 n0 @ct1v3 5355i0n5";
$lang['mustspecifybantype'] = "j00 MU\$+ \$pec1fY @ B4N +yP3";
$lang['mustspecifybandata'] = "j00 Mus+ 5pECifY s0M3 B4n d4T@";
$lang['successfullyremovedselectedbans'] = "sUcCE\$5fULlY reM0VED 5eL3ct3d 8@Ns";
$lang['failedtoaddnewban'] = "f41l3D t0 4dd n3w B@N";
$lang['failedtoremovebans'] = "f41L3D tO REm0v3 s0mE Or 4Ll 0PH +He \$3LeC+Ed 8ANS";
$lang['duplicatebandataentered'] = "dupLiC4t3 84n DA+4 EnteR3D. PlE4se Ch3ck YOur w1ldC4RD\$ tO s33 iF TH3y 4lRE4dy M@+cH tH3 D@T4 eN+3Red";
$lang['successfullyaddedban'] = "sUcC3s\$fUlly @DdEd b4n";
$lang['successfullyupdatedban'] = "suCcEsSFulLY upD4+eD B@N";
$lang['noexistingbandata'] = "th3Re i5 N0 eX1StIn9 8aN D4+@. To @Dd soME B4n DaT4 ple4S3 cL1ck t3H 8U+TOn 8EL0W.";
$lang['youcanusethepercentwildcard'] = "j00 C4N u5E T3H PERC3nT (%) wiLDC@RD \$Ym80L 1n any 0f YOUr 84n li5ts TO obt@In PAr+14l m4+Ch3\$, i.e. '192.168.0.%' WOulD 84n 4ll Ip 4ddRESs3s 1n +H3 r4ngE 192.168.0.1 tHr0u9h 192.168.0.254";
$lang['cannotusewildcardonown'] = "j00 Cann0T 4dD % A5 4 W1LDc@rd M4tch 0N I+'\$ 0wn!";
$lang['requirepostapproval'] = "rEqU1rE P0\$t 4ppR0v4l";
$lang['adminforumtoolsusercounterror'] = "tHER3 Mus+ b3 A+ lE@sT 1 u\$ER W1+H 4dMIN +OoLs 4nd F0Rum toolS 4CCe\$S 0N 4lL foruMS!";
$lang['postcount'] = "post COuNT";
$lang['resetpostcount'] = "r3s3T Po5+ c0Un+";
$lang['postapprovalqueue'] = "p0\$+ @PprOV4L qUEuE";
$lang['nopostsawaitingapproval'] = "n0 PosT\$ @r3 4W@1+1N9 4PpRov@L";
$lang['approveselected'] = "apPr0VE \$eLECt3D";
$lang['successfullyapproveduser'] = "sucCe\$5PhulLY @PpROveD \$EL3CT3D US3rS";                                                
$lang['approveselectedwarning'] = "are j00 \$ure j00 W@n+ To 4PPr0v3 +EH \$3LECt3d uSer\$?";
$lang['kickselected'] = "k1ck seLec+3d";
$lang['visitorlog'] = "viSi+0r L0G";
$lang['novisitorslogged'] = "n0 ViS1TOrs LOG93D";
$lang['addselectedusers'] = "aDd \$ELEct3d u\$3RS";
$lang['removeselectedusers'] = "r3M0vE SeLecT3D uS3Rs";
$lang['addnew'] = "add NEw";
$lang['deleteselected'] = "dEL3+e 53L3C+ed";
$lang['noprofilesectionsfound'] = "tHEr3 4r3 no exi\$+iN9 Pr0phiL3 \$3ct10N\$. TO 4dd 4 PRofiL3 SECTIoN pL34\$3 CLICk tH3 8UTt0n 83l0w.";
$lang['addnewprofilesection'] = "aDD nEw ProPh1L3 \$eC+10n";
$lang['successfullyaddedsection'] = "sUCCES5phulLY 4dD3D s3C+1on";

// Admin Log data (admin_viewlog.php) --------------------------------------------

$lang['changedstatusforuser'] = "ch@nGeD user St4+U5 f0R '%s'";
$lang['changedpasswordforuser'] = "ch4n9ed p4SSwoRD f0R '%s'";
$lang['changedforumaccess'] = "ch4n93D ForuM @cC3Ss PerM1S\$10n5 f0r '%s'";
$lang['deletedallusersposts'] = "del3T3D @lL p0\$ts PH0r '%s'";

$lang['createdusergroup'] = "cre@+3d UseR gR0UP '%s'";
$lang['deletedusergroup'] = "d3l3+Ed u\$3R 9R0UP '%s'";
$lang['updatedusergroup'] = "upd4+3d U\$ER 9RoUP '%s'";
$lang['addedusertogroup'] = "aDDed us3r '%s' +o 9r0Up '%s'";
$lang['removeduserfromgroup'] = "rEm0V3 u\$er '%s' fR0M 9rOUP '%s'";

$lang['addedipaddresstobanlist'] = "aDDEd IP '%s' To baN L15+";
$lang['removedipaddressfrombanlist'] = "rEM0VEd Ip '%s' pHROM B@N L1ST";

$lang['addedlogontobanlist'] = "aDdEd L0g0n '%s' T0 B@N l1ST";
$lang['removedlogonfrombanlist'] = "rEmov3D L09on '%s' PhR0M 84n L1\$+";

$lang['addednicknametobanlist'] = "adD3d N1cKn@m3 '%s' TO 8@n Lis+";
$lang['removednicknamefrombanlist'] = "r3m0VEd nIckn4m3 '%s' pHRoM b@n lIst";

$lang['addedemailtobanlist'] = "adD3D Em4IL @DDr3S5 '%s' t0 8aN LI\$t";
$lang['removedemailfrombanlist'] = "r3m0V3D EM@1L @ddRE5s '%s' FroM 8@N l1sT";

$lang['addedreferertobanlist'] = "addeD Reph3ReR '%s' +O B@n L1sT";
$lang['removedrefererfrombanlist'] = "reM0VeD R3f3r3R '%s' pHr0M 84n l1S+";

$lang['editedfolder'] = "ed1T3D f0Ld3R '%s'";
$lang['movedallthreadsfromto'] = "moV3d 4Ll THr34d5 PHRom '%s' TO '%s'";
$lang['creatednewfolder'] = "cR3@+Ed neW pH0LD3R '%s'";
$lang['deletedfolder'] = "d3le+ed f0lder '%s'";

$lang['changedprofilesectiontitle'] = "chAN9Ed pR0phiL3 sEC+i0n Ti+lE pHR0M '%s' +O '%s'";
$lang['addednewprofilesection'] = "adDED neW prOf1l3 \$Ect10n '%s'";
$lang['deletedprofilesection'] = "d3l3+Ed prOF1l3 sECTiON '%s'";

$lang['addednewprofileitem'] = "add3d n3W pr0PhIle 1tEm '%s' +0 S3C+10N '%s'";
$lang['changedprofileitem'] = "cH4n93d PROfILe I+eM '%s'";
$lang['deletedprofileitem'] = "d3lETeD pr0F1lE ITEM '%s'";

$lang['editedstartpage'] = "edITed 5T@Rt P49e";
$lang['savednewstyle'] = "s4VEd N3W 5tYL3 '%s'";

$lang['movedthread'] = "mOv3D Thr3@d '%s' FR0m '%s' t0 '%s'";
$lang['closedthread'] = "closED +HRe4d '%s'";
$lang['openedthread'] = "oPenED thr3@d '%s'";
$lang['renamedthread'] = "reN@mED tHRE4D '%s' To '%s'";

$lang['deletedthread'] = "dEle+3d Thr3@d '%s'";
$lang['undeletedthread'] = "uND3L3+3D +HRE4D '%s'";

$lang['lockedthreadtitlefolder'] = "l0cKed thre@d opT1oNs 0N '%s'";
$lang['unlockedthreadtitlefolder'] = "uNL0cK3D +HR34D 0P+i0N5 0n '%s'";

$lang['deletedpostsfrominthread'] = "deLe+eD P0\$+s PHr0M '%s' 1N +HRE4d '%s'";
$lang['deletedattachmentfrompost'] = "d3L3ted 4++@ChM3NT '%s' FR0m p05+ '%s'";

$lang['editedforumlinks'] = "eD1+eD PhORuM lINk\$";
$lang['editedforumlink'] = "eD1+3d foruM link: '%s'";

$lang['addedforumlink'] = "aDded foruM l1nk: '%s'";
$lang['deletedforumlink'] = "deL3tED pHoRuM l1NK: '%s'";
$lang['changedtoplinkcaption'] = "cH@Ng3D +0p l1NK C4p+iOn FrOM '%s' +0 '%s'";

$lang['deletedpost'] = "d3le+ed post '%s'";
$lang['editedpost'] = "editeD P0\$T '%s'";

$lang['madethreadsticky'] = "mAdE tHrE4D '%s' 5ticKY";
$lang['madethreadnonsticky'] = "mADE +Hr34D '%s' nOn-S+1CkY";

$lang['endedsessionforuser'] = "endeD S3\$S1on FoR U\$ER '%s'";

$lang['approvedpost'] = "aPPr0veD P05+ '%s'";

$lang['editedwordfilter'] = "eDiT3d w0rd Ph1ltER";

$lang['addedrssfeed'] = "add3d r\$\$ f33D '%s'";
$lang['editedrssfeed'] = "eDIT3d rS\$ PHE3d '%s'";
$lang['deletedrssfeed'] = "delE+eD rsS PH33d '%s'";

$lang['updatedban'] = "uPDaTeD B4N '%s'. '%s' t0 '%s', '%s' +0 '%s'.";

$lang['splitthreadatpostintonewthread'] = "spl1+ +Hr34D '%s' @+ p0sT %s  Int0 N3w THrE4D '%s'";
$lang['mergedthreadintonewthread'] = "m3R93d tHr34ds '%s' 4nD '%s' inTo n3W +hRe4D '%s'";

$lang['approveduser'] = "aPprOv3d uS3R '%s'";

$lang['adminlogempty'] = "aDm1n L0G 1s EMP+Y";
$lang['clearlog'] = "cL34r LOG";

// Admin Forms (admin_forums.php) ------------------------------------------------

$lang['noexistingforums'] = "no 3XIST1Ng Phorums phouND. +0 CRe4t3 @ NeW foRuM PLe@\$E Click +h3 Bu+T0n 83l0W.";
$lang['webtaginvalidchars'] = "wEbta9 c@N 0NLY C0nT@1N upp3rC@s3 a-Z, 0-9 4ND UndeRSc0re cH4R4c+er5";
$lang['databasenameinvalidchars'] = "d4t4BA\$3 n4Me C4N ONLY C0nt@1n 4-z, 4-z, 0-9 4ND Und3R5cor3 Ch4r4CTEr\$";
$lang['invalidforumidorforumnotfound'] = "inv@l1d fORuM PH1d ph0R f0RUM no+ fouNd";
$lang['successfullyupdatedforum'] = "sucC3S\$FuLlY uPD4t3d foRUm: '%s'";
$lang['failedtoupdateforum'] = "f4il3D to Upd4+3 F0rum: '%s'";
$lang['successfullycreatedforum'] = "sUcCE\$sFULLY CRE4T3d PhoRUM: '%s'";
$lang['failedtocreateforum'] = "f4ILed +0 CRe@Te FoRUm '%s'. PlE4\$E cheCk T0 M@K3 5Ure tEh W38T@9 @nd +48le N@MeS 4REN'T aLR34dY 1N U53.";
$lang['forumdeleteconfirmation'] = "aR3 j00 sUrE j00 w@NT +0 d3LEt3 @Ll 0f TH3 \$EL3ct3d PHORumS?";
$lang['forumdeletewarning'] = "pLe453 N0te th4T j00 c4nN0T r3covEr dEle+3d phorUM\$. oNCE d3lEted 4 F0rUm 4Nd 4lL OPH It'5 4\$50C14+ED d4T4 I\$ p3rmeN4NTly reM0ved PhrOM T3H DA+48@\$e. iph j00 D0 N0+ Wi5H +0 DEL3+3 Teh SeL3CTed f0rUm5 pL3@se CliCK c4nCeL.";
$lang['successfullydeletedforum'] = "sUCcEs5PhULLy d3Le+Ed pHORum: '%s'";
$lang['failedtodeleteforum'] = "f4iL3d +0 DeL3+ed fOruM: '%s'";
$lang['addforum'] = "adD PH0RUm";
$lang['editforum'] = "edi+ f0RUm";
$lang['visitforum'] = "v1S1t FoRum: %s";
$lang['accesslevel'] = "acCeSs leV3L";
$lang['usedatabase'] = "us3 da+48@SE";
$lang['unknownmessagecount'] = "uNknOwn";
$lang['forumwebtag'] = "foRuM W38+A9";
$lang['defaultforum'] = "dePhaUl+ f0rum";
$lang['forumdatabasewarning'] = "plE4\$e 3nsure J00 5EleC+ +eH C0rrEcT D@t48@53 wh3N Cre4+1n9 4 NEW PH0rUM. 0Nc3 cRE4teD 4 nEw FOrum c4nn0+ Be M0VEd 83+W33N @V@IL@Bl3 d4+4b@SEs.";

// Admin Global User Permissions

$lang['globaluserpermissions'] = "gl084L u5eR P3RMIS\$iOn\$";

// Admin Forum Settings (admin_forum_settings.php) -------------------------------

$lang['mustsupplyforumwebtag'] = "j00 mU5+ SuPpLy 4 F0rUM W38+4G";
$lang['mustsupplyforumname'] = "j00 Mu\$t suPplY 4 fOrUm N4M3";
$lang['mustsupplyforumemail'] = "j00 MU\$t \$UpPLy @ F0RuM Em41l 4DdREss";
$lang['mustchoosedefaultstyle'] = "j00 mus+ Ch0053 @ dePh@ulT pHORUm \$tYl3";
$lang['mustchoosedefaultemoticons'] = "j00 mu5+ ch0osE dEph4ul+ Ph0rUm Em0+iC0NS";
$lang['mustsupplyforumaccesslevel'] = "j00 MuS+ Supply a fOrum @cces\$ l3veL";
$lang['mustsupplyforumdatabasename'] = "j00 mU5+ sUpPLy 4 FOrUM D4+@b4se N4ME";
$lang['unknownemoticonsname'] = "uNknown em0tiC0n\$ N@m3";
$lang['mustchoosedefaultlang'] = "j00 Mu\$T Cho0\$e a D3ph4ulT F0rUM L4Ngu4ge";
$lang['activesessiongreaterthansession'] = "aCTIVE SeSsi0N TImE0ut Cann0t b3 9R34T3r th4n s3ssioN TiM30uT";
$lang['attachmentdirnotwritable'] = "a+T@chm3Nt dir3C+0Ry @nd \$Ys+eM +3mPor@RY d1rEc+0rY / php.1Ni 'UPL04d_+mP_Dir' mu5T 8e WR1+ABl3 BY +3h we8 5ERvER / php PROC3Ss!";
$lang['attachmentdirblank'] = "j00 mU\$T 5uppLY @ d1rEcTORY +o \$4Ve aT+@cHM3ntS 1n";
$lang['mainsettings'] = "m4In S3Tt1n9s";
$lang['forumname'] = "f0rUm n4m3";
$lang['forumemail'] = "f0rUM 3Ma1L";
$lang['forumdesc'] = "f0rum DeScR1pT1on";
$lang['forumkeywords'] = "fORum k3yw0Rd5";
$lang['defaultstyle'] = "dEF4Ult \$+yL3";
$lang['defaultemoticons'] = "dEF@uLT emo+iCons";
$lang['defaultlanguage'] = "d3F4ul+ L4n9U4g3";
$lang['forumaccesssettings'] = "foRUM aCc3ss \$E+t1N95";
$lang['forumaccessstatus'] = "f0rum 4cce\$s S+@tUS";
$lang['changepermissions'] = "ch@nGe pErMI\$51ON\$";
$lang['changepassword'] = "cH@n93 p@5sWoRD";
$lang['passwordprotected'] = "pAs5wOrD prOtec+3D";
$lang['passwordprotectwarning'] = "j00 h@ve no+ \$3t 4 PH0ruM p4sSwoRd. 1PH J00 Do N0+ 53+ A PA\$sword +eH pAs\$W0RD PR0+ecTI0N PHUnCTIonalITY wilL 83 4UT0M4+Ic4LlY D1S48Led!";
$lang['postoptions'] = "p0\$t optioN\$";
$lang['allowpostoptions'] = "all0W P0ST eDIt1n9";
$lang['postedittimeout'] = "p0S+ Ed1t +1m3ou+";
$lang['posteditgraceperiod'] = "p0\$+ 3dI+ 9R4c3 PeR1od";
$lang['wikiintegration'] = "wiKiw1k1 1n+39rA+10n";
$lang['enablewikiintegration'] = "eN4Bl3 WIK1W1kI 1nT3GR4+IoN";
$lang['enablewikiquicklinks'] = "en48L3 wIk1wik1 qUICK L1nk\$";
$lang['wikiintegrationuri'] = "w1KIw1k1 L0C4TI0n";
$lang['maximumpostlength'] = "m4xIMuM P05+ l3n9+H";
$lang['postfrequency'] = "p0ST Frequ3NCY";
$lang['enablelinkssection'] = "en@Bl3 LInks Secti0N";
$lang['allowcreationofpolls'] = "allOw CR3AtIOn 0f pOlL5";
$lang['allowguestvotesinpolls'] = "alLoW 9u3STs to v0t3 1n POLl5";
$lang['unreadmessagescutoff'] = "unRe4d Me\$S@9e\$ CU+-0fF";
$lang['unreadcutoffseconds'] = "secOnds";
$lang['disableunreadmessages'] = "dI\$4bl3 UnRe@D M35549eS";
$lang['nocutoffdefault'] = "nO CUt-OFPH (d3ph4uL+)";
$lang['1month'] = "1 M0NTh";
$lang['6months'] = "6 mON+h\$";
$lang['1year'] = "1 YE@R";
$lang['customsetbelow'] = "cU\$+oM v4LU3 (Se+ 83l0w)";
$lang['searchoptions'] = "s34rCh op+1ONS";
$lang['searchfrequency'] = "sE4rch fREqu3NCy";
$lang['sessions'] = "s3SsIONs";
$lang['sessioncutoffseconds'] = "se5510N cu+ Off (\$eCOnD5)";
$lang['activesessioncutoffseconds'] = "aCt1Ve sES510n cuT oFF (s3c0nds)";
$lang['stats'] = "s+@t\$";
$lang['hide_stats'] = "h1DE 5+4t5";
$lang['show_stats'] = "sHoW \$+4T\$";
$lang['enablestatsdisplay'] = "eN@BL3 5+@T\$ dI5pL@y";
$lang['personalmessages'] = "p3Rs0n@l mE5\$a935";
$lang['enablepersonalmessages'] = "en4Bl3 p3r5ON4l M3Ss4Ge\$";
$lang['pmusermessages'] = "pm m3S\$@gES pER uS3R";
$lang['allowpmstohaveattachments'] = "aLL0W pER\$0N4l m3ss@G3\$ T0 h4V3 4t+4chmENT\$";
$lang['autopruneuserspmfoldersevery'] = "autO prUN3 usEr'5 pM FOldERs eV3rY";
$lang['userandguestoptions'] = "uSeR 4Nd GUES+ optI0ns";
$lang['enableguestaccount'] = "eN4bl3 9U3S+ 4cC0UN+";
$lang['listguestsinvisitorlog'] = "l1\$+ 9uEstS 1n V1S1+0r L09";
$lang['allowguestaccess'] = "aLlow guE\$+ @Cc3\$5";
$lang['userandguestaccesssettings'] = "uSer @Nd 9U3S+ @CCESS S3+tINgS";
$lang['allowuserstochangeusername'] = "aLl0W us3r5 +O ch4nge u\$3rN4M3";
$lang['requireuserapproval'] = "r3qu1re Us3R 4Ppr0v@l BY @DMiN";
$lang['enableattachments'] = "eN@Bl3 @ttachmENts";
$lang['attachmentdir'] = "att4CHmEN+ DIR";
$lang['userattachmentspace'] = "a++@CHM3n+ \$P4cE PEr U\$3R";
$lang['allowembeddingofattachments'] = "aLLoW 3mB3Dd1N9 Oph 4+T@CHMEnT\$";
$lang['usealtattachmentmethod'] = "use 4L+ErN4+1ve 4++4CHm3nt mETHOd";
$lang['allowgueststoaccessattachments'] = "aLLow 9UE5+S To 4cC3\$S 4+T4cHM3nT5";
$lang['forumsettingsupdated'] = "f0Rum se+tIngS \$Ucc3SSfuLLY Upd4t3D";
$lang['forumstatusmessages'] = "f0rUM S+4tUs mESs49Es";
$lang['forumclosedmessage'] = "f0Rum cLO\$3d M3S\$Ag3";
$lang['forumrestrictedmessage'] = "f0RUM r35+R1C+Ed mES5493";
$lang['forumpasswordprotectedmessage'] = "f0Rum p@SswORd Pro+3C+3d M3SS493";

// Admin Forum Settings Help Text (admin_forum_settings.php) ------------------------------

$lang['forum_settings_help_10'] = "<b>p0st 3dIT +iM30U+</b> i\$ +H3 +1M3 IN mINuT3\$ @Ph+3R p0STin9 THA+ 4 u\$3R C4n 3DIT +He1r p0\$T. 1F 5et TO 0 tH3rE 1S no l1Mi+.";
$lang['forum_settings_help_11'] = "<b>m4ximum pOSt l3nGth</b> iS THE M@ximUm nUM83R OF Char@C+3RS THAT w1lL b3 DI\$PL@yEd 1N @ P0S+. if @ P0\$t IS l0NG3r +h4n +H3 NuM8Er OF cH4RACT3Rs DEFINED H3Re 1+ W1ll be Cu+ ShoRt @ND @ l1NK AddeD +0 +eh 80+ToM to 4LL0w User\$ +o Re@D +HE WH0l3 p0S+ 0n 4 SEP4R4T3 P@ge.";
$lang['forum_settings_help_12'] = "iF J00 D0n'+ w@n+ yOur U\$Er\$ TO B3 4bLE +o cr34+3 POlLS j00 c@N di5@Bl3 +EH 4BOve Op+1oN.";
$lang['forum_settings_help_13'] = "teh linK\$ SEc+iOn 0pH bE3HIvE pRov1Des @ PL4cE fOR Y0ur U53R\$ t0 M@1N+41N 4 lI\$+ 0ph 51+E\$ THEY FRequEN+Ly V1\$I+ +ha+ 0ThEr Us3R5 M4Y PH1nd u5ephUl. liNKs c4n B3 DIv1DeD in+0 C4t3gOR13\$ 8y Folder 4nd 4Ll0w PHoR c0MMEnTS 4nd r4TIN9S tO be g1VeN. in 0RD3R T0 moDER@+E T3H L1nk5 sEc+1ON 4 us3r Mu5+ 83 RaNtEd GLob4l mOD3Rat0R \$t4tUS.";
$lang['forum_settings_help_15'] = "<b>sEsS1ON CUt 0fPH</b> 15 t3H M@x1MuM +1Me B3Ph0R3 a U53r'\$ sE5\$i0n 1\$ D3EMED D34d 4ND +hEY @R3 LOgGEd out. by d3F4Ul+ +hIS 1S 24 H0ur5 (86400 S3C0nds).";
$lang['forum_settings_help_16'] = "<b>aC+IVe 53s\$IOn CUT Off</b> i5 TEh M4X1mum t1Me 8epHOr3 4 u5Er'5 SEss10N is dE3MEd 1N@cTiv3 4t WHiCh P0IN+ +h3Y eNt3r 4n iDL3 \$+aTE. In +Hi5 st4+e +eH u5ER rem4iN\$ LO993d In, bU+ thEY 4r3 ReMOv3D PHroM +3h 4cTIv3 uSerS l1St in +eh St@+\$ DISPL4Y. 0NcE tH3y Bec0Me 4C+1v3 4g41n ThEy wIlL 8e rE-4DD3d +O thE L1ST. 8y d3F@ul+ +hi\$ \$et+iNG 15 53+ to 15 M1NU+35 (900 53C0Nd\$).";
$lang['forum_settings_help_17'] = "eN48L1Ng Th1\$ 0PT10N 4llOw\$ 833h1v3 tO 1nclUd3 4 \$+4TS d1splay @+ TH3 BOtTOm OPh +3H MES54G3S p4N3 sIm1L4r +0 The 0n3 U\$eD By m4Ny phOrum s0fTw@RE +1TL3\$. 0NcE eN4BLED +eH dI\$Pl4y OF th3 S+ATS P4g3 C@N 83 +o99L3d iNdiV1du4LLY 8Y 3@Ch U53r. Iph +H3Y d0n't wanT +O seE IT +hEy c4N H1D3 it PHRom v1ew.";
$lang['forum_settings_help_18'] = "peRs0Nal MEs\$493\$ 4re 1Nv4lU4BL3 4s @ way 0ph T4kinG MOr3 pr1v4TE M4t+eRS 0u+ Of V1Ew 0PH +he 0th3r Memb3R\$. hOWeVer iF j00 DON'+ W@n+ YoUr U53Rs T0 be 48LE T0 5eNd 3ACh 0+h3R p3rS0n4L Me5S@g3\$ j00 C4n d1\$ablE THI\$ oP+10n.";
$lang['forum_settings_help_19'] = "pEr\$0N4L ME5s@9ES Can @l\$0 Cont@In A++4cHM3n+s Wh1CH C@N 8e Us3FUl FoR Exch@NG1n9 Phil35 B3tW3En u5erS.";
$lang['forum_settings_help_20'] = "<b>noT3:</b> +eh Sp4c3 4lLoC4TIOn f0R pm aT+4CHmEn+\$ i5 +4kEn FrOM 34CH U53r5' M@1n 4Tt4Chm3nt 4lL0c4T10n 4nD 1S n0+ 1N @dD1T10n +0.";
$lang['forum_settings_help_21'] = "<b>eN4ble 9U3S+ @cc0Un+</b> @lL0w\$ vIsIt0R\$ TO 8R0w53 y0ur pHoRum 4nd r3ad p0st\$ wi+H0u+ ReGI\$+eRiNG 4 usEr 4CC0UN+. @ uS3R @Cc0UnT 1\$ \$t1Ll REQUirEd 1pH tHEY W1sh To Po\$T OR CH4n9e uS3R pr3pHERENC3\$.";
$lang['forum_settings_help_22'] = "<b>li5+ 9uEs+S IN V1s1+oR l0G</b> @LL0W5 J00 +0 sPEc1phy WHEThEr or n0+ UNr3GI\$t3rEd u\$3Rs 4r3 L1\$ted 0n +He vI\$I+oR l09 4L0NG siD3 r391\$+ereD u\$3r5.";
$lang['forum_settings_help_23'] = "b33Hive 4LLOW5 a++@CHMEn+s tO 8E uplo4deD T0 mE\$s@ge\$ WH3n Po\$+3d. IF J00 h4vE l1MIT3d wEb \$pac3 J00 m4y wH1cH +0 DI54Bl3 4++@cHMEnT\$ By CL3@rIN9 ThE 8Ox 48Ove.";
$lang['forum_settings_help_24'] = "<b>a+T@cHmenT dIR</b> 1s +Eh loC@TI0n b33h1vE Sh0uLd ST0R3 I+'s 4+t4chm3nt5 in. +H1\$ DIREctoRY Must 3xIS+ On yOUr W3b Sp4c3 @nd muS+ b3 wRI+48l3 8Y +3h we8 \$3rveR / pHP ProCeS\$ o+h3Rw15e UPl0@D\$ wILL Ph@Il.";
$lang['forum_settings_help_25'] = "<b>atT4chMeNt Sp4c3 P3R U\$3r</b> i5 +HE M@XIMUm 4moUnT 0F d1SK sP4CE 4 uSER H4\$ phOR @Tt@ChmEN+5. onc3 +hI5 \$P4Ce 1s UseD UP Teh U5Er c4Nn0+ UpLo4D @ny M0R3 A++@chM3ntS. bY dEF4ULt th1\$ I5 1mb 0F SP4C3.";
$lang['forum_settings_help_26'] = "<b>alLOW 3MbeDd1N9 of 4t+4Chm3nt\$ 1N meS549E\$ / 519n4TUr35</b> 4Ll0W5 u\$3r\$ TO EMB3d @++aCHm3n+s 1N p0\$+\$. 3n@8L1ng THIS 0pt1On Wh1LE uS3fUL c@N incR34s3 Y0Ur 8@nDw1D+h US4g3 dr4\$+icALLy UNdER c3r+a1n CONfIGUr4+10n5 oF Php. 1PH j00 h@V3 l1mI+3D 84NDw1d+h 1+ 1S rEcoMMeNDED +H@+ j00 D1\$48L3 +h15 0PTi0n.";
$lang['forum_settings_help_27'] = "<b>u53 4L+Ern4+iV3 @tt4cHmeNT M3tHod</b> PH0rC3S b3EH1Ve t0 U5E 4N 4Lt3rN@T1V3 rE+r13V4L m3tH0d Ph0R 4+t@ChmENt\$. IPH j00 r3c31VE 404 erRoR m3S\$493S wHEn +rYING +0 d0wnLO@D 4+t4CHM3n+s phr0M me5\$4Ge\$ TrY eN@8L1n9 +H1S 0Ption.";
$lang['forum_settings_help_28'] = "tHis 5EtT1NG 4lLow\$ y0ur FoRuM t0 83 5P1d3RED by 5E4rCH 3Ng1n3S LIK3 GooGL3, al+av15+@ @nd y@h00. 1ph J00 \$w1tcH Th1S 0p+10n Ofph YoUR PhORum w1LL n0+ 83 1nCLud3D in TH3\$3 Se4rcH 3n9ine\$ REsUl+5.";
$lang['forum_settings_help_29'] = "<b>allOw n3W U53R REGi5+r4+i0n\$</b> @Llows 0R di54LlowS +Eh cre4tiOn 0F new uS3r 4CcOUnTS. \$3+T1ng tH3 OptiOn T0 n0 cOMPLE+Ely d1SABLe5 thE R3GIs+R@TIOn ph0rm.";
$lang['forum_settings_help_30'] = "<b>eN48l3 w1kiW1kI 1NTEGR@T10n</b> pr0v1D3\$ WIk1w0rD \$upPorT In Your foRum p0\$t\$. 4 WIk1wOrD iS M4de up 0Ph TW0 0r MorE C0NC4+EN4tEd WOrdS W1+H Upp3RC@S3 let+Er\$ (0FteN rePhErReD +0 45 C@melc@\$e). 1pH j00 Wr1T3 4 w0RD +H15 W@y 1+ W1ll @U+0m@TiC@LLY Be ch@n93D 1nt0 4 HYP3rLiNK pOINtiNg +0 y0Ur cHOS3n WiKIw1K1.";
$lang['forum_settings_help_31'] = "<b>eN4Ble W1kiWIK1 QU1ck l1NKS</b> En4bl3s t3h U\$E oPH M59:1.1 @Nd us3r:l0GoN S+YLe 3XtEndEd Wik1L1NK5 WhICH cr34+3 hYpErLinK\$ tO +3H \$PeCiPHIEd m3\$S493 / U\$3R pROFil3 oph tHe \$P3CIPhi3D user.";
$lang['forum_settings_help_32'] = "<b>wiK1WIKI l0CA+i0n</b> I\$ US3D TO \$PeCiFy +eH Uri 0PH Y0UR wik1W1k1. wh3n 3nTER1Ng +hE UrI Us3 [wIk1W0RD] To INd1c4T3 WH3R3 IN t3h UR1 +3H wIKiw0Rd \$H0UlD APp3@R, I.E.: <i>h+TP://3n.w1k1p3DiA.or9/WIk1/[w1kiW0rd]</i> w0UlD LInk yOUr W1k1woRdS +0 %s";
$lang['forum_settings_help_33'] = "<b>fOruM 4CC3\$5 \$t4TU\$</b> Con+ROl\$ How u\$ErS maY @cc3S\$ Y0uR PhORUM.";
$lang['forum_settings_help_34'] = "<b>opEN</b> W1lL 4llow 4lL uSEr5 4nD GUeSTS @cC3s5 to y0uR PhORUM wi+h0U+ r3s+r1CT10N.";
$lang['forum_settings_help_35'] = "<b>cl05ed</b> Pr3v3nT5 4Cc355 for @ll UserS, w1+h +hE excEP+i0N 0ph +hE @dmiN WhO m4Y s+Ill 4cc3S5 +h3 ADM1N p4n3L.";
$lang['forum_settings_help_36'] = "<b>r3STr1CTED</b> 4LL0W5 +O s3+ @ L1st oPh UsEr5 wh0 @R3 4LLOWED 4CC3S\$ +o YouR forUm.";
$lang['forum_settings_help_37'] = "<b>p4Ssw0RD PRot3c+eD</b> All0ws J00 +0 s3T @ P4S5W0rd tO g1v3 0u+ T0 User\$ \$0 +h3y c4N @CCE\$5 y0Ur pHORUM.";
$lang['forum_settings_help_38'] = "wH3N \$E++1Ng RE\$+rIC+Ed oR P4S5w0RD Pro+3c+3d M0de J00 W1Ll NEeD To S4V3 yOUR CH@NGes 83pH0r3 J00 c@n CH4n93 +he u\$3r @ccESS pR1v1legeS 0r P4\$\$WoRd.";
$lang['forum_settings_help_39'] = "<b>Search Frequency</b> defines how long a user must wait before performing another search. Searches place a high demand on the database so it is recommended that you set this to at least 30 seconds to prevent \"search spamming\"pHroM k1LLInG +H3 sErvER.";
$lang['forum_settings_help_40'] = "<b>p0st PhR3queNCY</b> 1S +He m1N1MUM +1me @ U5er MUST w@It BePh0R3 +h3y c4n p05T 4g@1N. +Hi5 S3++1N9 aL\$0 @FFec+s +h3 Cr3@+ION 0f P0llS. s3T +0 0 tO d15@BlE th3 r35+R1cTiON.";
$lang['forum_settings_help_41'] = "tEh 48Ov3 op+1ONs CH4ng3 +H3 DeF4ult V@LU3\$ Phor t3h U53R R3g1sTr@+I0n form. wHere @ppLIc4BLE 0tHEr s3TT1NG\$ wiLL Us3 +eH F0rUm'\$ oWN dEph@ul+ s3+T1N9\$.";
$lang['forum_settings_help_42'] = "<b>pR3vEnt US3 OF dUPliC@+3 Em4IL AdDRe5S3\$</b> F0rc3s b33H1Ve t0 ch3CK T3H uSeR @cCoUN+\$ @g4iN5t t3h 3m4il @dDRe\$5 Teh U\$3R I\$ R39iSTERING W1+h 4Nd pr0mPt\$ +heM +O US3 4n0TH3R 1pH 1+ 15 @LrE4Dy 1n usE.";
$lang['forum_settings_help_43'] = "<b>r3QUIr3 3m@1L C0Nfirm@t10n</b> WH3n 3n@8L3D W1LL SEND @N eMAIL +0 E4ch n3W uSer w1+h 4 LInk +h@+ c4n Be u53D T0 COnf1Rm +h31r eM4IL @DdrES5. Un+iL ThEY C0NPh1RM thE1R 3m41L @ddR3\$s TH3Y W1Ll No+ B3 aBL3 tO p0S+ unL3Ss +he1r us3R p3rmI\$SIoNs 4R3 Ch4NG3D m@nUaLLy BY 4N aDmIn.";
$lang['forum_settings_help_44'] = "<b>usE tEXt-C4P+cH@</b> PreSeN+5 +h3 N3w U53r W1TH 4 m4N9l3D 1mAGe wh1ch +h3y mU5T cOpy 4 nuMb3r fR0m INt0 4 tEX+ pH1eld ON T3h rEgI\$+r4T1oN PHorm. U\$3 THI\$ 0P+1ON tO prEV3nT @u+0mA+3d \$IgN-uP vi@ 5Cr1P+\$.";
$lang['forum_settings_help_45'] = "<b>tex+-c4P+Ch@ d1ReCtoRy</b> Sp3ciPH13S +He loC@+i0N +h4T b33H1v3 WILl S+0r3 1+'s +3x+-CAp+ch4 iM493S @nD foNTs In. th1\$ d1REc+0Ry Mu\$T 83 wRI+4bL3 8Y thE WEb \$3rveR / PHp pRoCESs @nD mU5t 83 acCE\$s18L3 vI@ H++P. 4pHTeR j00 haV3 EN48lEd t3XT-cAptCH4 J00 mU\$T uplO@d s0m3 +rU3 +Yp3 ph0N+\$ in+O +He f0nT5 sUB-d1rEc+0RY OPH Y0ur M41n +3xT-C@p+Ch4 diR3ct0rY 0Th3Rw1Se 8E3HIV3 W1lL 5kIP +Eh T3x+-c4pTCHA duR1n9 u\$eR RE915+r@+10N.";
$lang['forum_settings_help_46'] = "<b>Text Captcha key</b> allows you to change the key used by Beehive for generating the text captcha code that appears in the image. The more unique you make the key the harder it will be for automated processes to \"guess\"+HE c0D3.";
$lang['forum_settings_help_47'] = "<b>poSt EdI+ GR4C3 p3RI0D</b> 4lloW5 j00 +0 defiN3 @ P3r1od in M1nuTe\$ wheR3 u53rS m4y eDIt P0s+S w1Th0ut +H3 'ed1+ed 8Y' teXt @pP3aRiN9 on tHe1R P0\$+S. 1PH 5E+ +O 0 t3H 'eD1T3d by' +3x+ WiLL 4lW4y5 appe@R.";
$lang['forum_settings_help_48'] = "<b>uNr34d M3ssaGEs CU+-0PhpH</b> SpEciphI35 HOW lOng unRe4D m3S\$@g3s 4RE R3t4inEd. j00 m@Y chOo53 phr0m V4RiouS PreS3+ V4LU3S 0r ENt3r youR OWN Cu+-0FpH p3RiOd in 5eC0ND5. THre4D\$ mOD1PH13d eARli3r +h4N the d3phiN3D cU+-0pHF p3R1oD w1Ll @uT0Ma+Ic@lLY 4pPE4r @s rE4d.";
$lang['forum_settings_help_49'] = "ch0Osin9 <b>dI\$abLE UNr3AD Me5S4g3\$</b> WilL c0MPl3teLY rem0V3 unre4d M35S493s \$UpP0rt 4ND rEMOve +EH R3L3v4N+ 0PtI0N\$ PHROm +he D1\$cU5\$1On +YP3 DrOp down 0N +he +hreAd lI\$+.";
$lang['forum_settings_help_50'] = "<b>r3quir3 Us3r 4PPRoV@l bY 4dMin</b> @LlowS j00 +0 R3STRiCt 4CCeSS BY nEw USer5 UN+iL +HEY H@VE B33n 4pprOv3D by 4 mOD3r4ToR 0R 4DM1N. w1THOut 4PPR0v4L 4 usEr c4Nn0T 4cCe5\$ @Ny @R34 0PH +he B3Eh1ve phoRUm IN\$+4ll4+10N INcLUDin9 IND1v1DU4L PHOrUm\$, pm in8Ox @Nd my f0RuMs 5ec+i0NS.";
$lang['forum_settings_help_51'] = "us3 <b>cL053d mE\$\$@g3</b>, <b>r3stR1CTEd M355@gE</b> 4nd <b>p@sSw0rD Pro+EC+Ed mES5@93</b> t0 cU\$+0MiS3 +h3 m3sS493 dI\$pl@yED when uS3r\$ 4CC35s y0UR pH0RUM in the v4rIOUS \$t@+ES.";
$lang['forum_settings_help_52'] = "j00 c4N u5E HTML 1N Y0ur Me\$S@93s. HYperLInK\$ 4Nd 3M4iL @ddrE\$S35 W1ll 4lso B3 4ut0M4T1c4LLy C0nV3RtEd tO l1nK\$. t0 uSE teh D3Ph4Ul+ 83eHiv3 PH0ruM m3s5@9e\$ Cle4r +He pHieLD5.";
$lang['forum_settings_help_53'] = "<b>alLow U53Rs +0 CH4nG3 U\$3RN@M3</b> Perm1+\$ 4lrEADy re9i\$+3Red u5erS T0 ChanGE THeir u\$ERn4Me. wHEN 3n@8l3d j00 c4N tr4CK +3h Ch@NGes @ us3R m4k3s +0 +heiR uS3Rn4ME v1@ +3h @dM1n uS3r T00Ls.";

// Attachments (attachments.php, get_attachment.php) ---------------------------------------

$lang['aidnotspecified'] = "aid NoT sp3CIPH13D.";
$lang['upload'] = "uPLO4d";
$lang['uploadnewattachment'] = "uPlo4D new A++AChMEN+";
$lang['waitdotdot'] = "w@IT..";
$lang['successfullyuploaded'] = "sUCc3s5fULly uplOAdeD";
$lang['failedtoupload'] = "f4iL3D +O UPlOaD";
$lang['complete'] = "cOmPL3T3";
$lang['uploadattachment'] = "uPlo@d @ phil3 PhOR 4T+@ChM3N+ +O tEh ME\$\$AGe";
$lang['enterfilenamestoupload'] = "eN+eR fIlEN4me(S) +O upL04d";
$lang['attachmentsforthismessage'] = "at+@cHMeNt\$ F0R THi5 mE\$\$@9E";
$lang['otherattachmentsincludingpm'] = "o+HeR @+t@cHMEnT\$ (inCLUdiNg pM M3SsaGE5 @Nd 0TH3R PH0rum5)";
$lang['totalsize'] = "tO+@l sIz3";
$lang['freespace'] = "fr3E SP4C3";
$lang['attachmentproblem'] = "tH3Re w4\$ A PR08l3m d0wnl04d1nG Th1\$ 4++@Chm3nt. pl3@S3 +rY @g4IN l4+Er.";
$lang['attachmentshavebeendisabled'] = "at+@ChmEN+5 H@Ve bEen di\$48L3D by t3h fORUm oWN3r.";
$lang['canonlyuploadmaximum'] = "j00 c@n 0NLy UplOAD a m@X1MuM OPh 10 PHil3\$ 4+ 4 +1m3";
$lang['deleteattachments'] = "dEl3T3 4Tt4chmeN+\$";
$lang['deleteattachmentsconfirm'] = "ar3 j00 \$URe J00 W4N+ t0 dEl3TE t3H s3l3CT3d 4Tt@CHMeN+\$?";
$lang['deletethumbnailsconfirm'] = "aRE J00 suRe J00 W4N+ t0 d3LE+e +H3 S3l3C+3D @+t@CHMeN+5 +HUmbN41l5?";

// Changing passwords (change_pw.php) ----------------------------------

$lang['passwdchanged'] = "p4\$5W0rD CH4Ng3d";
$lang['passedchangedexp'] = "y0uR PA\$sw0rd H@S 83EN CH4n93d.";
$lang['updatefailed'] = "uPd@+E f@1LED";
$lang['passwdsdonotmatch'] = "p4\$\$wOrdS D0 N0t M4+Ch.";
$lang['allfieldsrequired'] = "aLl f1eLD\$ 4RE r3qu1RED.";
$lang['requiredinformationnotfound'] = "r3QuiR3d InfoRmaTiON n0+ PHoUNd";
$lang['forgotpasswd'] = "f0r90+ p4SswOrd";
$lang['enternewpasswdforuser'] = "entER 4 n3W P@s\$w0Rd F0r U\$ER %s";
$lang['resetpassword'] = "res3t p4S5W0RD";
$lang['resetpasswordto'] = "r35e+ P45Sw0rD +o";

// Deleting messages (delete.php) --------------------------------------

$lang['nomessagespecifiedfordel'] = "no m3S\$@9E speC1ph1ED F0R D3l3t1on";
$lang['deletemessage'] = "d3Le+3 me\$S4GE";
$lang['postdelsuccessfully'] = "po5t dele+3D suCce\$\$fULLY";
$lang['errordelpost'] = "erR0r d3le+Ing pO\$t";
$lang['cannotdeletepostsinthisfolder'] = "j00 C@nnoT DeLE+e p05+\$ 1n +hI\$ Phold3R";

// Editing things (edit.php, edit_poll.php) -----------------------------------------

$lang['nomessagespecifiedforedit'] = "n0 mES549e SpeCIPHi3d PH0r eDITing";
$lang['cannoteditpollsinlightmode'] = "c@nnoT eD1+ POlLS 1N LIgh+ m0D3";
$lang['editedbyuser'] = "ed1+3d: %s By %s";
$lang['editappliedtomessage'] = "ed1T 4PPl1ed +0 MEs5@9E";
$lang['errorupdatingpost'] = "erR0R UpD@+iNG p0S+";
$lang['editmessage'] = "eDi+ m3s\$49E %s";
$lang['editpollwarning'] = "<b>n0T3</b>: edIt1n9 C3rT4iN 4\$p3C+S Oph 4 pOLl w1Ll v0id 4Ll tEH curr3NT vo+e5 @nd @LloW Pe0pL3 T0 v0+e @g41n.";
$lang['hardedit'] = "hArD 3dit 0P+IoN\$ (vo+35 W1LL 8E r3s3T):";
$lang['softedit'] = "sopHt 3D1T 0p+1oNs (vO+35 w1Ll 83 r3+41Ned):";
$lang['changewhenpollcloses'] = "chAN9e WH3N +eH P0Ll cL053S?";
$lang['nochange'] = "no cH4nG3";
$lang['emailresult'] = "eM4Il RESuL+";
$lang['msgsent'] = "meSS493 Sen+";
$lang['msgsentsuccessfully'] = "mE55@ge 5enT \$ucC3\$5FULLy.";
$lang['msgfail'] = "mes5a9E f41l3d";
$lang['mailsystemfailure'] = "m41L \$yStEm f4iLuRe. m3\$5Age n0+ s3NT.";
$lang['nopermissiontoedit'] = "j00 @RE N0T P3RmiTteD T0 3D1T thi\$ m3S\$4G3.";
$lang['pollediterror'] = "j00 C@nnot Ed1T Poll5";
$lang['cannoteditpostsinthisfolder'] = "j00 c4Nnot edI+ posT5 1n +Hi\$ FOLd3R";
$lang['messagewasnotfound'] = "me\$5AG3 %s W4s No+ pH0UNd";

// Email (email.php) ---------------------------------------------------

$lang['nouserspecifiedforemail'] = "nO Us3R \$peC1PH13D foR emaIlIn9.";
$lang['entersubjectformessage'] = "enTer @ \$uBJ3CT f0R +hE Me\$5@G3";
$lang['entercontentformessage'] = "eNTeR \$0me C0n+3N+ pHOr tHe ME\$5A93";
$lang['msgsentfromby'] = "thIs M3\$5@GE Wa\$ \$En+ PhroM %s 8Y %s";
$lang['subject'] = "sU8j3c+";
$lang['send'] = "s3ND";
$lang['hasoptedoutofemail'] = "h4s 0pt3d ou+ 0PH eMa1L C0nt@c+";
$lang['hasinvalidemailaddress'] = "h@5 AN invAliD 3m@1l @DDr3s\$";

// Message nofificaiton ------------------------------------------------

$lang['msgnotification_subject'] = "mE\$S4G3 no+1f1c@+Ion fr0m %s";
$lang['msgnotificationemail'] = "%s PO\$tEd 4 M35s493 T0 j00 oN %s\n\n+he \$U8J3C+ 1\$: %s\n\n+0 RE4d +h4+ m3Ss@9E @nd OtH3R\$ 1n the 5@M3 DiSCU5sI0N, 90 T0:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nn0+3: ipH j00 dO nO+ w1\$H +0 RECe1V3 em41l NotIf1C@T10n\$ OPH f0ruM me55@G35 PoSTEd t0 y0U, go to: %s ClIcK on My c0N+rOls tHEn eM@IL 4nd pRivacY, UnseL3Ct +hE Em41L n0t1F1CAtI0n ch3cKB0X @nd PRe\$S \$u8mIT.";

// Thread Subscription notification ------------------------------------

$lang['subnotification_subject'] = "su8scRiP+iOn No+1Ph1c4+1on fr0M %s";
$lang['subnotification'] = "%s p0StED 4 Mes\$AG3 1n @ thr3@D J00 H4v3 \$u8\$CRi83D +0 0n %s\n\nTh3 suBJ3c+ 15: %s\n\nT0 r3@d Th4+ ME5s49E @Nd 0+H3rS in Th3 s4mE D1SCuS\$I0N, g0 +0:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nn0t3: if j00 D0 no+ Wish +O ReC31VE 3M41L n0+1PhIc4tI0ns 0ph N3W M3\$s4gE\$ 1N +HIs +HR34D, 9O +O: %s 4nD @dJU5+ YouR 1N+er3\$+ L3V3L 4T Th3 80ttom oPh +H3 P4ge.";

// PM notification -----------------------------------------------------

$lang['pmnotification_subject'] = "pm no+1ph1c4+1ON PhRom %s";
$lang['pmnotification'] = "%s p0S+Ed @ Pm +0 J00 oN %s\n\n+h3 5ubj3C+ 1S: %s\n\nt0 R34D tH3 mESs493 90 tO:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nN0+3: IPH j00 DO not W1SH +0 r3ce1v3 Em41l N0+1FIC4TIOns OF n3w pM m3SS4Ge\$ po\$T3D T0 y0u, 9O tO: %s cL1CK my C0N+rOLs +h3N EM4Il ANd PR1V4cy, uNsEl3C+ +he PM noT1F1Ca+I0n ch3Ck80x 4nd Pr3SS \$UBMi+.";

// Password change notification ----------------------------------------

$lang['passwdchangenotification'] = "p455w0rD ch@nge notiPH1C@+10N PHr0M %s";
$lang['pwchangeemail'] = "thI\$ 4 notIph1CA+10n Em@il t0 InphORm j00 Th4T Your P4\$SW0rD 0N %s Ha5 b3en CH4n9ED.\n\nit H@5 BE3n ch4NG3d t0: %s And w4S CH4N93D By: %s\n\n1PH j00 H@Ve RecEiV3D +His 3M4Il iN ERR0r 0R WERe N0+ exPEctIng 4 Ch4ngE T0 YOUr pASsw0rD pLe4Se coN+@C+ +3h PHORuM OwN3r 0R 4 mOdeR4Tor oN %s 1mm3D1ATEly +o coRr3Ct 1+.";

// Email confirmation notification -------------------------------------

$lang['emailconfirmationrequired'] = "eM41l C0NFiRm4+Ion R3QU1rED F0R %s";
$lang['confirmemail'] = "h3lL0 %s,\n\nY0u rEC3Ntly cREA+3D A n3w USER @Cc0un+ oN %s\nBEf0RE j00 C4n s+@R+ pos+1ng we Ne3d tO ConFIrM YOuR 3m4iL 4Ddres\$. don'+ w0RRy +h1S I\$ Qu1+3 e4\$y. 4ll J00 n3ed T0 Do i5 CLicK +HE l1nK b3LOW (0r CoPY 4ND pa\$+E 1t 1N+0 Y0uR bROW\$3r):\n\n%s\n\nOnc3 C0nFIRm4TI0n 1s COMpl3tE J00 M4Y L09iN 4nD 5Tart p05+iNg 1MMEd14+elY.\n\n1F j00 d1d nO+ Cre4+3 @ u\$Er aCC0Un+ on %s Pl3@SE 4ccEpt ouR @PolOgi35 4Nd f0rwARD +hIS 3m41l t0 %s s0 tH4T teh 5OurC3 oPH 1t M4Y 83 INV3S+194+Ed.";

// Forgotten password notification -------------------------------------

$lang['forgotpwemail'] = "j00 R3qu35T3D TH15 e-mAil fR0M %s 8EC4usE j00 h4v3 phoRg0+T3N Y0ur P4\$\$word.\n\nCLICk The l1NK b3lOW (0R Copy 4ND P4S+e 1+ iNT0 yOuR BROW53R) +0 R3\$3t Y0ur p4\$SWorD:\n\n%s";

// Forgotten password form.

$lang['passwdresetrequest'] = "yoUr p@S5wOrd RES3T reQUESt FROm %s";
$lang['passwdresetemailsent'] = "p4\$Sw0rd r35eT E-m4IL SeN+";
$lang['passwdresetexp'] = "j00 sH0Uld rec31V3 aN 3-m41l coN+41NIn9 iN5TRUC+ioNs ph0r r3sET+inG Y0ur p@ssW0Rd Sh0rTly.";
$lang['validusernamerequired'] = "a V4L1D uS3RN4M3 1S rEqUirEd";
$lang['forgottenpasswd'] = "f0rGoT P4\$5WoRD";
$lang['forgotpasswdexp'] = "ipH j00 H4vE PhoR90T+en YOuR P4s5w0rd, j00 C4n reQueST To H@Ve 1t R35E+ By eN+ERIN9 Y0uR L0G0N NaME 8ELow. 1NSTRuction\$ ON H0w +o rE\$3+ y0uR P4s5wORD WiLL BE SEn+ To YOur rE91s+3R3D 3M4IL 4Ddr3S\$.";
$lang['couldnotsendpasswordreminder'] = "coulD n0+ sENd p@S\$wORd REmInd3r. pl34se C0n+act +eh PHoRum 0wnER.";
$lang['request'] = "r3QuESt";

// Email confirmation (confirm_email.php) ------------------------------

$lang['emailconfirmation'] = "eM@1L cOnFIRM@+1oN";
$lang['emailconfirmationcomplete'] = "tH4Nk J00 fOR C0nf1rM1Ng yOUR 3M@1l @DDresS. j00 m@Y NOw L09iN 4Nd \$+4r+ pO5+inG 1mMEd14+ElY.";
$lang['emailconfirmationfailed'] = "eM@IL C0npH1rM4Ti0N H4s f4Il3d, Pl3a5E TRy 49@IN l4t3R. 1Ph j00 3NcoUN+3R +H1\$ 3RR0r mult1pl3 +1M35 pl34\$3 c0nTAc+ +EH Ph0rUM 0Wn3r oR 4 M0der@t0r phor @ss1S+@nce.";

// Links database (links*.php) -----------------------------------------

$lang['toplevel'] = "t0p Lev3l";
$lang['maynotaccessthissection'] = "j00 MAY No+ 4CCe5s +hi\$ 53Ct10n.";
$lang['toplevel'] = "t0P L3V3l";
$lang['links'] = "linKs";
$lang['viewmode'] = "vi3w M0De";
$lang['hierarchical'] = "h13r4RcH1C4L";
$lang['list'] = "lI\$T";
$lang['folderhidden'] = "tHIS FOLd3R 1S HiDdeN";
$lang['hide'] = "hidE";
$lang['unhide'] = "unHID3";
$lang['nosubfolders'] = "no \$u8phOLdeRS 1N Th1S C@T390Ry";
$lang['1subfolder'] = "1 subpH0ld3r 1N +H15 C4tEgOry";
$lang['subfoldersinthiscategory'] = "subph0ldeRs iN +h1s ca+3gOrY";
$lang['linksdelexp'] = "eNtRIe5 iN 4 D3L3+3d phOLdEr WiLl 8E MoV3D To +hE p4REN+ f0ld3R. ONLy pH0Ld3rS WHiCh do N0T cOnT4in su8phOLd3Rs m@y b3 D3LeTED.";
$lang['listview'] = "li\$+ vI3w";
$lang['listviewcannotaddfolders'] = "cANN0T @Dd F0Ld3R5 1n +h1s ViEW. \$H0wiN9 20 en+RIES 4+ 4 Tim3.";
$lang['rating'] = "rATiNg";
$lang['commentsslashvote'] = "cOMMENT\$ / V0+3";
$lang['nolinksinfolder'] = "n0 L1nk5 iN tH1\$ fOLD3R.";
$lang['addlinkhere'] = "adD linK H3re";
$lang['notvalidURI'] = "th4+ iS n0T 4 v4Lid uR1!";
$lang['mustspecifyname'] = "j00 MuS+ 5p3c1Phy 4 N4m3!";
$lang['mustspecifyvalidfolder'] = "j00 MUsT \$P3cIPHy 4 vaLiD pH0Ld3r!";
$lang['mustspecifyfolder'] = "j00 Mu5+ 5pECIfy @ FoLD3R!";
$lang['addlink'] = "aDd 4 LinK";
$lang['addinglinkin'] = "aDdIN9 l1Nk in";
$lang['addressurluri'] = "adDReSS (Url/uRi)";
$lang['addnewfolder'] = "adD 4 N3W pH0Ld3r";
$lang['addnewfolderunder'] = "aDd1N9 n3W PH0ld3r und3R";
$lang['mustchooserating'] = "j00 Mu\$T choO53 @ R4T1ng!";
$lang['commentadded'] = "your ComM3N+ W45 4ddED.";
$lang['musttypecomment'] = "j00 Mu\$+ +yPe 4 C0mMent!";
$lang['mustprovidelinkID'] = "j00 MuST PRoVid3 4 link 1D!";
$lang['invalidlinkID'] = "iNV4l1D LinK 1D!";
$lang['address'] = "adDrE5\$";
$lang['submittedby'] = "su8M1tTed by";
$lang['clicks'] = "cl1ckS";
$lang['rating'] = "r4+1N9";
$lang['vote'] = "v0TE";
$lang['votes'] = "vOT3S";
$lang['notratedyet'] = "n0t r@Ted by 4ny0NE Ye+";
$lang['rate'] = "r4+3";
$lang['bad'] = "b@D";
$lang['good'] = "g00D";
$lang['voteexcmark'] = "v0TE!";
$lang['commentby'] = "coMM3nt By %s";
$lang['addacommentabout'] = "add @ c0mmeN+ @BOu+";
$lang['modtools'] = "mOdER@+1ON +0oLs";
$lang['editname'] = "edi+ n4me";
$lang['editaddress'] = "ed1+ 4dDrE5\$";
$lang['editdescription'] = "edI+ dEsCR1P+iON";
$lang['moveto'] = "m0VE to";
$lang['linkdetails'] = "l1Nk DE+4iLS";
$lang['addcomment'] = "aDd cOMMEn+";
$lang['voterecorded'] = "yOur VO+e H4\$ been ReCORD3D";

// Login / logout (llogon.php, logon.php, logout.php) -----------------------------------------

$lang['userID'] = "us3r Id";
$lang['loggedinsuccessfully'] = "j00 L0G93d IN sUccE5sFULLy.";
$lang['presscontinuetoresend'] = "pReS\$ CON+InUE +o REs3nD F0rm D4+4 0r C4NceL tO Rel0@D P493.";
$lang['usernameorpasswdnotvalid'] = "tHe U\$eRN4m3 Or paS5WORd j00 SuppLiEd 1S n0T v@liD.";
$lang['pleasereenterpasswd'] = "plE@s3 Re-enT3r y0UR P4S5wORD @Nd +Ry 4941n.";
$lang['rememberpasswds'] = "rEMEm8ER p4sSW0Rd5";
$lang['rememberpassword'] = "r3M3m83R Passw0Rd";
$lang['enterasa'] = "eNTer 4S 4 %s";
$lang['donthaveanaccount'] = "d0N'+ h4v3 4n 4cC0un+? %s";
$lang['registernow'] = "r391\$+eR N0w.";
$lang['problemsloggingon'] = "pR08L3MS lO9G1n9 On?";
$lang['deletecookies'] = "deL3TE cooK1E\$";
$lang['cookiessuccessfullydeleted'] = "c00k1Es SuCC35sPhUllY dEle+3D";
$lang['forgottenpasswd'] = "foRgotten y0uR P4s5wOrD?";
$lang['usingaPDA'] = "usin9 A pd4?";
$lang['lightHTMLversion'] = "l19HT HTMl V3R5i0N";
$lang['youhaveloggedout'] = "j00 h4V3 Logg3D 0UT.";
$lang['currentlyloggedinas'] = "j00 4R3 Curr3NtLy l09g3d iN @\$ %s";
$lang['logonbutton'] = "l0g0N";
$lang['otherbutton'] = "o+h3r";

// My Forums (forums.php) ---------------------------------------------------------

$lang['myforums'] = "mY f0rUm\$";
$lang['recentlyvisitedforums'] = "r3c3NtLy v1S1t3d Ph0rUM5";
$lang['availableforums'] = "ava1L4bLe Forum\$";
$lang['favouriteforums'] = "fAvOur1+3 f0RUm\$";
$lang['lastvisited'] = "l@\$T ViSiT3d";
$lang['forumunreadmessages'] = "%s UnrE4d M3\$s@9ES";
$lang['forummessages'] = "%s M3\$s4ge5";
$lang['forumunreadtome'] = "%s UnrE@d &quot;+O: ME&quot;";
$lang['forumnounreadmessages'] = "n0 UnR3@d MEs5@G3s";
$lang['removefromfavourites'] = "r3M0v3 Phr0M PH4VOur1t3s";
$lang['addtofavourites'] = "aDD +0 PH4Vour1T3s";
$lang['availableforums'] = "aVA1l4BL3 PHorUm\$";
$lang['noforumsavailable'] = "tHere 4r3 n0 phOrum5 @VAiLABL3.";
$lang['noforumsavailablelogin'] = "tHeR3 4r3 No F0rum\$ @V@1L4blE. pL34\$e l091n +O VIeW y0Ur foRUm\$.";
$lang['passwdprotectedforum'] = "p4s5wOrd pR0TEc+ed ForuM";
$lang['passwdprotectedwarning'] = "thI\$ fOrUM i\$ P4\$sword PRo+3c+ed. To 9@1n @cC3Ss 3nter TH3 P@sSWOrD 83l0w.";

// Message composition (post.php, lpost.php) --------------------------------------

$lang['postmessage'] = "p0\$+ ME5s@G3";
$lang['selectfolder'] = "s3l3c+ fOLDeR";
$lang['mustenterpostcontent'] = "j00 mu5+ 3NT3R s0m3 cON+3N+ PHor +He PoS+!";
$lang['messagepreview'] = "mEs549E Pr3v13W";
$lang['invalidusername'] = "inv4liD U53RN4m3!";
$lang['mustenterthreadtitle'] = "j00 MuS+ enT3r @ T1TL3 fOr +3h +hR34D!";
$lang['pleaseselectfolder'] = "pl34S3 SeL3ct @ F0Ld3r!";
$lang['errorcreatingpost'] = "erroR CRe@+1n9 Pos+! pL3@s3 +Ry ag4In IN @ Few m1nUTe\$.";
$lang['createnewthread'] = "cRE4+3 nEw +hRead";
$lang['postreply'] = "pO\$+ rEply";
$lang['threadtitle'] = "thRe4D T1tL3";
$lang['messagehasbeendeleted'] = "m3\$\$4g3 H@\$ b3En DELe+eD.";
$lang['pleaseentermembername'] = "pleas3 EN+eR @ memBEr N4Me:";
$lang['cannotpostthisthreadtypeinfolder'] = "j00 caNNOT P0st ThiS +Hr34D TyP3 1N +ha+ PhOlDEr!";
$lang['cannotpostthisthreadtype'] = "j00 c@Nn0+ P0S+ +HIs +hre4D +yPe 45 Th3R3 4Re NO @V@IL@8lE pHoLDERS +h4t 4ll0W 1+.";
$lang['cannotcreatenewthreads'] = "j00 C4nn0+ CRe4te NEW tHRE@D\$.";
$lang['threadisclosedforposting'] = "tHi\$ ThR34d 1\$ clo\$3d, j00 caNnO+ PO\$+ 1N i+!";
$lang['moderatorthreadclosed'] = "w4rN1N9: +h15 +HR34d 1S CLOsED PHor P05T1Ng +o N0rmaL Us3rs.";
$lang['threadclosed'] = "tHR3@d cL05eD";
$lang['usersinthread'] = "u5eR\$ 1n thr34d";
$lang['correctedcode'] = "c0rReC+eD COd3";
$lang['submittedcode'] = "submiT+eD C0dE";
$lang['htmlinmessage'] = "h+Ml 1n me\$54Ge";
$lang['disableemoticonsinmessage'] = "dis4BLE EmO+ICON5 iN M3sS49E";
$lang['automaticallyparseurls'] = "autOMa+1c4lly P@rSE uRLs";
$lang['automaticallycheckspelling'] = "auT0m4t1c@lly ChECk \$P3lliN9";
$lang['setthreadtohighinterest'] = "seT +Hre4d t0 H19h 1Nt3re5+";
$lang['enabledwithautolinebreaks'] = "eNA8L3d WI+H @uT0-LIN3-bR34k\$";
$lang['fixhtmlexplanation'] = "th1\$ pHoruM u5eS H+Ml PHiL+3RIn9. youR SUbmi+TeD HTML H@S 8Een m0d1F1ed 8Y +h3 PhilT3RS 1N \$OME W@y.\\n\\ntO v1ew YoUr 0ri91nAL C0D3, \$eLecT Teh \\'suBMiT+3d C0d3\\' r4diO buTT0n.\\n+o v1Ew +H3 mODIf13d coDE, \$eLeC+ +eH \\'C0Rr3ct3d c0de\\' R4DIO BuTTon.";
$lang['messageoptions'] = "mes\$@g3 opt1oN5";
$lang['notallowedembedattachmentpost'] = "j00 4rE NO+ @LLOWeD TO EmBed @++4cHm3N+5 1N Y0ur p05+\$.";
$lang['notallowedembedattachmentsignature'] = "j00 AR3 NO+ ALl0Wed T0 3m8ed @t+4CHM3NT5 IN yOUr SIGN4+urE.";
$lang['reducemessagelength'] = "m3\$5@g3 leN9Th mU\$T b3 UnDeR 65,535 Ch4R@C+3r\$ (cUrR3nTLY:";
$lang['reducesiglength'] = "siGN@tur3 l3N9+H MUs+ 8E undEr 65,535 CH4R4C+3R\$ (curR3nTLY:";
$lang['cannotcreatethreadinfolder'] = "j00 c@NN0+ Cre4+3 N3w thR3adS in ThIs PHolD3r";
$lang['cannotcreatepostinfolder'] = "j00 c4nN0+ rEpLY +0 P0S+\$ 1n TH1S F0lDER";
$lang['cannotattachfilesinfolder'] = "j00 CanN0T P0\$+ 4++4CHm3nTS 1n +hi5 F0LDer. R3M0vE a++@ChM3n+5 +o cont1nUE.";
$lang['postfrequencytoogreat'] = "j00 C@n oNLY P05+ oncE 3V3ry %s 53coNd5. Pl3@\$3 try 4gAIN l@TER.";
$lang['emailconfirmationrequiredbeforepost'] = "eMaIL c0nphIrm4tI0n I\$ REQuIR3d 83F0R3 J00 C4n poS+. iPh J00 h4v3 n0+ r3ce1veD 4 c0Nf1rM4+ioN 3m4iL Ple@se cliCk +3H 8u+TON BeLow @ND 4 N3w oN3 W1lL 8E \$En+ +O y0u. 1pH YOUr 3M41L 4dDRE\$\$ nEED\$ ch4N91NG PLE4\$3 D0 SO 83phoRe r3Qu3s+1nG 4 n3w CoNphIRM4Ti0n eM@iL. j00 M4y Ch4N9e Y0ur eM4iL aDDRES5 by cLICK mY C0NtR0lS 4Bove 4Nd +H3N U\$Er D3+AiL5";
$lang['emailconfirmationfailedtosend'] = "cONpHiRMaT1ON 3m@Il f41l3d +0 53Nd. pL3@53 CONt4cT +he pH0rUM owneR tO REcT1PhY +HIS.";
$lang['emailconfirmationsent'] = "conPhiRm@t10N Em41L H@S 83En r3s3n+.";
$lang['resendconfirmation'] = "resEnd CoNphIRm@+iON";
$lang['userapprovalrequired'] = "usEr 4pPR0v4l REQU1rED";
$lang['userapprovalrequiredbeforeaccess'] = "your U5er 4cc0Un+ n33dS tO bE @ppr0ved By 4 fOruM admIn 8EpHOR3 J00 C4n 4Cc3\$s t3h R3QuE\$T3D FORum.";

// Message display (messages.php & messages.inc.php) --------------------------------------

$lang['inreplyto'] = "in reply To";
$lang['showmessages'] = "shOW MeS\$49e\$";
$lang['ratemyinterest'] = "r4+E my 1n+eR3s+";
$lang['adjtextsize'] = "aDJus+ T3X+ S1z3";
$lang['smaller'] = "sm4LLER";
$lang['larger'] = "l4r9ER";
$lang['faq'] = "f4Q";
$lang['docs'] = "doC\$";
$lang['support'] = "supP0RT";
$lang['donateexcmark'] = "d0N4te!";
$lang['threadcouldnotbefound'] = "thE r3qU3s+eD tHre4d cOuLd n0+ bE f0UNd Or 4CC3\$\$ W@S d3ni3D.";
$lang['mustselectpolloption'] = "j00 mus+ S3lecT @n oPt1ON TO v0+E pHoR!";
$lang['mustvoteforallgroups'] = "j00 mUst Vo+3 iN eveRY GROUP.";
$lang['keepreading'] = "kE3p re4d1N9";
$lang['backtothreadlist'] = "bACK t0 +hR34D L1st";
$lang['postdoesnotexist'] = "th4+ P0\$+ doES noT 3X1ST 1N +Hi5 ThR3@d!";
$lang['clicktochangevote'] = "cl1ck +0 chaN9E vo+3";
$lang['youvotedforoption'] = "j00 vO+ED pH0R oP+I0N";
$lang['youvotedforoptions'] = "j00 V0t3D FOr Op+ioNS";
$lang['clicktovote'] = "cL1CK +0 v0+e";
$lang['youhavenotvoted'] = "j00 h4vE N0+ V0+ED";
$lang['viewresults'] = "v13w R3SUL+\$";
$lang['msgtruncated'] = "me5S4Ge TruNc@t3D";
$lang['viewfullmsg'] = "v13w FuLl m35S493";
$lang['ignoredmsg'] = "iGN0r3D Me\$54G3";
$lang['wormeduser'] = "w0Rm3d u5Er";
$lang['ignoredsig'] = "iGnORed S19n4+ure";
$lang['messagewasdeleted'] = "m3sS4G3 %s.%s W4s d3L3teD";
$lang['stopignoringthisuser'] = "sT0P igNOriNG Th1s us3R";
$lang['renamethread'] = "rEn4Me +hrE4d";
$lang['movethread'] = "mov3 Thr3ad";
$lang['editthepoll'] = "eDIt T3H POLL";
$lang['torenamethisthread'] = "t0 r3N@m3 +HiS +hRe4d";
$lang['closeforposting'] = "cloS3 F0r PO5t1Ng";
$lang['until'] = "unTIL 00:00 u+C";
$lang['approvalrequired'] = "apPROv4L ReQu1REd";
$lang['messageawaitingapprovalbymoderator'] = "mES549E %s.%s is 4w@ItiN9 4pprOv4l 8y 4 mod3r@t0r";
$lang['postapprovedsuccessfully'] = "p0\$T 4PPr0vED SUcC3\$5fUlly";
$lang['postapprovalfailed'] = "pOs+ @ppRoV4l F@1l3D.";
$lang['postdoesnotrequireapproval'] = "pO5+ D0es nO+ r3Qu1r3 4ppR0V@L";
$lang['approvepost'] = "aPpROve P0s+ F0r dIspl@y";
$lang['approvedbyuser'] = "appr0VEd: %s by %s";
$lang['makesticky'] = "m4k3 5T1Cky";
$lang['messagecountdisplay'] = "%s of %s";
$lang['linktothread'] = "pERM4nEn+ LInK +O THi\$ +hr34d";
$lang['linktopost'] = "liNK tO P05t";
$lang['linktothispost'] = "lInK +o +h15 po5t";
$lang['imageresized'] = "tHi\$ im@93 h4\$ beeN r3\$iZ3d (Ori91n4L 5Iz3 %1\$5x%2\$5). +O Vi3W +Eh phULL-S1Ze 1m4G3 cLIcK h3R3.";
$lang['messagedeletedbyuser'] = "m3ss4ge %s.%s D3L3+3D %s By %s";
$lang['messagedeleted'] = "mes5@ge %s.%s W4S DElE+3d";

// Moderators list (mods_list.php) -------------------------------------

$lang['cantdisplaymods'] = "c4NN0+ d15Pl@Y F0LDer MOdER4tOR5";
$lang['moderatorlist'] = "m0d3RaTOR lI5T:";
$lang['modsforfolder'] = "m0der@+Or\$ Ph0R pH0ld3R";
$lang['nomodsfound'] = "no MOdeR@TorS pHOUnd";
$lang['forumleaders'] = "f0rUm l3AdeR\$:";
$lang['foldermods'] = "foLD3R MoDEr4TOr\$:";

// Navigation strip (nav.php) ------------------------------------------

$lang['start'] = "st4R+";
$lang['messages'] = "m3sS4G3S";
$lang['pminbox'] = "inBoX";
$lang['startwiththreadlist'] = "st@R+ P4g3 WITh THr34D l1ST";
$lang['pmsentitems'] = "s3Nt IT3mS";
$lang['pmoutbox'] = "oU+bOX";
$lang['pmsaveditems'] = "s4V3d 1+3M\$";
$lang['pmdrafts'] = "dr4F+\$";
$lang['links'] = "lINK\$";
$lang['admin'] = "adM1n";
$lang['login'] = "log1N";
$lang['logout'] = "l09OU+";

// PM System (pm.php, pm_write.php, pm.inc.php) ------------------------

$lang['privatemessages'] = "pr1V@TE Me5S4gES";
$lang['recipienttiptext'] = "sep@R4te r3cIp1enT\$ bY \$EMI-c0l0N Or COmM4";
$lang['maximumtenrecipientspermessage'] = "tH3r3 1\$ 4 liMit Of 10 REc1P13N+s P3r ME5s4Ge. PL3A\$E @m3nd yoUR REciPiEn+ l1ST.";
$lang['mustspecifyrecipient'] = "j00 MU\$+ \$pEC1Fy 4+ lE4\$+ 0n3 REc1P1ENT.";
$lang['usernotfound'] = "u\$3R %s nO+ FoUnd";
$lang['sendnewpm'] = "s3nd neW pm";
$lang['savemessage'] = "s4V3 M3\$SA93";
$lang['timesent'] = "tiME 53nT";
$lang['nomessages'] = "n0 me5S4geS";
$lang['errorcreatingpm'] = "eRr0r Cre4TIn9 pm! ple4\$3 +Ry 494In 1N 4 FeW MInU+Es";
$lang['writepm'] = "wrI+3 Me\$s@93";
$lang['editpm'] = "eDi+ mesS4Ge";
$lang['cannoteditpm'] = "c4nno+ ED1t THi5 pM. 1+ H4\$ 4lR34dY bEen v1eWeD by teh r3c1pI3n+ 0R Th3 Mess4g3 do3S n0T eX1\$+ Or It is 1N4cc3\$\$ible bY j00";
$lang['cannotviewpm'] = "canN0t VieW pm. m3S\$493 dOES n0+ EXIst oR it 1s 1N4cc3\$SI8l3 8Y j00";
$lang['pmmessagenumber'] = "mE\$s49e %s";

$lang['youhavexnewpm'] = "j00 H4V3 %d n3W me\$S49eS. WOuLD J00 lIk3 To Go +0 YOuR 1N80X nOw?";
$lang['youhave1newpm'] = "j00 h4V3 1 neW m355@ge. WOUlD j00 l1K3 to 90 TO y0uR inB0X noW?";
$lang['youhave1newpmand1waiting'] = "j00 h4VE 1 n3W m3\$54G3.\\n\\nY0U 4ls0 h@Ve 1 Mes5@GE AW41T1NG Del1V3Ry. to reCE1V3 THIs m3\$S4ge PL345e cl3@R s0M3 \$p4C3 in yOUR In8Ox.\\n\\nWoUlD j00 l1K3 T0 G0 +0 yoUr 1NB0x n0w?";
$lang['youhave1pmwaiting'] = "j00 H4V3 1 Mes\$493 @w4I+INg D3Liv3rY. To R3cE1V3 THi5 m3S\$@gE pL3@\$3 cl3@R S0ME \$p4Ce in yoUR iNb0x.\\n\\nW0uLD J00 LiK3 To go t0 youR 1NBox n0w?";
$lang['youhavexnewpmand1waiting'] = "j00 h@V3 %d N3W M3\$\$4geS.\\n\\ny0U 4L\$o H4VE 1 mE5\$4Ge 4W4iTiNG deL1V3Ry. +0 R3Ce1Ve thIS MEss4G3 Pl3ase cL34r SOmE \$p4C3 1n yOUr iN80X.\\n\\nw0Uld j00 Like +0 gO +O Y0UR iNbOx NoW?";
$lang['youhavexnewpmandxwaiting'] = "j00 H@ve %d new m35S4GeS.\\n\\nyOu @l\$0 h@ve %d meSsA9ES 4w41tIn9 Del1V3ry. +0 ReCE1Ve ThES3 m3\$S4gE PL34\$3 cl3@R SOM3 5p4C3 1n y0Ur in80x.\\n\\nW0ulD J00 liK3 T0 9O To y0Ur 1NBOX NoW?";
$lang['youhave1newpmandxwaiting'] = "j00 Have 1 new m35S4G3.\\n\\nyOu 4L\$o h4Ve %d m35\$@935 aw4IT1N9 d3liV3Ry. +0 REcE1V3 ThE\$3 ME\$S4G3\$ Ple4\$3 CLe4R \$Ome SP@c3 1n yOur Inb0X.\\n\\nWould J00 LiK3 to 9O to y0Ur In80x NoW?";
$lang['youhavexpmwaiting'] = "j00 H4v3 %d Mess49E\$ 4w4It1nG d3l1vErY. +O ReC3iV3 +hESe mES54Ge\$ plE4SE CL3@r 50me sP4Ce 1N YOur 1NB0X.\\n\\nW0UlD j00 l1k3 T0 9o +0 y0Ur 1n8OX N0W?";

$lang['youdonothaveenoughfreespace'] = "j00 DO NO+ hAv3 3N0UgH pHREe Sp@C3 +0 \$3nd thi\$ m3\$S4g3.";
$lang['notenoughfreespace'] = "doE\$ nO+ h4ve enoU9H FR3e Sp4c3 To rec3Ive tH1s mE5S@G3";
$lang['userhasoptedoutofpm'] = "%s H4S 0p+3d ouT 0ph Rec3Iv1ng p3R\$on@L mesS4g3\$";
$lang['pmfolderpruningisenabled'] = "pM phOLd3r PrUN1ng I5 En48L3d!";
$lang['pmpruneexplanation'] = "tH15 F0RUm usE\$ Pm PhOlDeR prUnINg. thE ME\$s@9ES J00 h@Ve \$toRED In yOUR INb0x @nD \$3nT itEmS\\nph0lDEr5 4RE SU8JEcT +o @Utom4+1c DEL3TIOn. 4nY m3\$\$49E\$ J00 W15h +0 K33p \$h0ulD b3 MOV3D To\\nY0ur \\'\$@V3D it3m\$\\' FoldEr \$0 +H@+ They 4R3 n0+ delETEd.";
$lang['yourpmfoldersare'] = "y0uR pM PH0ldERS 4r3 %s pHuLl";
$lang['currentmessage'] = "cURREnT mEsS4G3";
$lang['unreadmessage'] = "uNr3@D m3\$\$4Ge";
$lang['readmessage'] = "re4D MeSsAG3";
$lang['pmshavebeendisabled'] = "pEr50n4l MES\$4Ge\$ h@V3 833n D1\$48L3D BY T3h f0rUM OwN3r.";
$lang['adduserstofriendslist'] = "aDD U\$3Rs +o y0Ur Phr1EnD5 L1S+ T0 H4VE TheM 4pP34r IN 4 DRop Down 0N +Eh pM Wr1T3 m3s\$493 P@gE.";

$lang['messagesaved'] = "meSs493 SAV3d";
$lang['messagewassuccessfullysavedtodraftsfolder'] = "m3SS4G3 w4\$ \$ucc3S5fULlY 54veD to 'dR@Fts' ph0Ld3R";
$lang['pmtooltipxmessages'] = "%s me\$s4ge\$";
$lang['pmtooltip1message'] = "1 ME5S49e";

// Preferences / Profile (user_*.php) ---------------------------------------------

$lang['mycontrols'] = "my C0NTroL5";
$lang['myforums'] = "mY F0rUMS";
$lang['menu'] = "mENU";
$lang['userexp_1'] = "usE thE MeNu oN tH3 Lef+ +O M4n@ge YoUr sE++1n9s.";
$lang['userexp_2'] = "<b>us3R DeT4Ils</b> aLl0wS J00 tO ch4N9e Y0uR N@me, 3m4iL @dDr3ss @nd P4ssw0rD.";
$lang['userexp_3'] = "<b>us3R pRof1L3</b> 4lLoW\$ J00 +0 3dIt Y0Ur u53R Proph1L3.";
$lang['userexp_4'] = "<b>cH@NgE P@S5w0RD</b> AlLOW5 J00 +0 Ch4N9e YOUR P@s5W0RD";
$lang['userexp_5'] = "<b>em@1L &amp; Pr1V4cY</b> lEt\$ j00 Ch@n9e HoW J00 C4N 83 COn+4C+3D ON 4nD OpHf ThE F0RUM.";
$lang['userexp_6'] = "<b>f0RUM oPt1ON5</b> lE+S J00 cH4n93 H0w +3H phorUM L00k\$ 4nd WOrK\$.";
$lang['userexp_7'] = "<b>att4chMenT\$</b> @ll0w\$ J00 To ed1t/d3LetE y0ur @++4ChMents.";
$lang['userexp_8'] = "<b>s19n4tuR3</b> lE+S J00 3di+ yOUr \$igN@+uRe.";
$lang['userexp_9'] = "<b>rEL4TIoNSHIPS</b> LET5 j00 M4N493 YOuR rEl4+iON5H1P W1+H o+H3R u\$3rS ON +3H pHoRUM.";
$lang['userexp_9'] = "<b>wORd PH1L+eR</b> l3+s j00 eD1T Y0UR p3Rson@l wOrd pHilt3r.";
$lang['userexp_10'] = "<b>tHrE4D \$UB\$Cr1pT1oN5</b> @lL0w\$ j00 +o m4N493 YOUr +hR34D 5UbSCR1PTIONs.";
$lang['userdetails'] = "u53R DE+41L5";
$lang['userprofile'] = "us3R Pr0phIl3";
$lang['emailandprivacy'] = "emaIL &amp; pR1V4Cy";
$lang['editsignature'] = "eDi+ \$19N@TUr3";
$lang['norelationships'] = "j00 h4V3 n0 usEr r3l4TI0n5hiPS 53+ uP";
$lang['editwordfilter'] = "edI+ WorD FiLT3r";
$lang['userinformation'] = "uSer Inf0Rm4TI0n";
$lang['changepassword'] = "ch@nG3 P@55WoRd";
$lang['currentpasswd'] = "cUrr3N+ p4\$5W0RD";
$lang['newpasswd'] = "neW p@s5wOrd";
$lang['confirmpasswd'] = "coNPhiRM P@5sW0RD";
$lang['passwdsdonotmatch'] = "p4SsW0rDS d0 N0+ M4+ch!";
$lang['nicknamerequired'] = "nICkN4M3 1\$ rEqUiRed!";
$lang['emailaddressrequired'] = "eM4IL @DdR3ss 1\$ requ1RED!";
$lang['logonnotpermitted'] = "loGoN No+ peRm1++ED. CHOoS3 @N0+heR!";
$lang['nicknamenotpermitted'] = "nicKN@M3 n0+ perM1Tt3D. CH0O\$3 4N0+her!";
$lang['emailaddressnotpermitted'] = "eM41L 4dDRes\$ NO+ PeRmI+t3d. ChO0\$E @No+hER!";
$lang['emailaddressalreadyinuse'] = "eM@1L @Ddr3s\$ @lrE4Dy iN U\$E. ChO0S3 4No+her!";
$lang['relationshipsupdated'] = "rela+10N5H1p5 UpdATeD!";
$lang['relationshipupdatefailed'] = "reL4+10N\$HIP UPd4+ed F41leD!";
$lang['preferencesupdated'] = "pRepHERenC35 w3R3 SUCcE\$SpHULly UPd@T3D.";
$lang['userdetails'] = "uSer D3t4iL\$";
$lang['memberno'] = "mEmbEr No.";
$lang['firstname'] = "f1rsT n4me";
$lang['lastname'] = "l4s+ n4M3";
$lang['dateofbirth'] = "d4t3 OF b1r+H";
$lang['homepageURL'] = "h0mep@93 URL";
$lang['pictureURL'] = "p1CTur3 uRL";
$lang['forumoptions'] = "foRUM opT1on5";
$lang['notifybyemail'] = "no+1pHY by eM41l opH POS+\$ To me";
$lang['notifyofnewpm'] = "n0+iFy By p0PuP 0F N3W pM meS54ge5 To ME";
$lang['notifyofnewpmemail'] = "nO+1fy 8Y 3M41L 0pH New Pm M3SS@Ge\$ tO M3";
$lang['daylightsaving'] = "aDjUsT PH0R d@YL1Ght S4viN9";
$lang['autohighinterest'] = "auT0M4+1C4LLY m@rK +HR34Ds I p0St 1N 4\$ h1Gh 1nt3res+";
$lang['convertimagestolinks'] = "au+0M4t1C4llY c0nvErt 3m83Dd3D 1m4GE5 in p0\$+\$ 1Nt0 liNK5";
$lang['thumbnailsforimageattachments'] = "tHUM8n4ilS fOR Im4g3 4T+AChM3NtS";
$lang['smallsized'] = "sM4Ll 51ZEd";
$lang['mediumsized'] = "m3D1um s1zed";
$lang['largesized'] = "l@RGe \$izEd";
$lang['globallyignoresigs'] = "gLoB@lLY igNorE uS3R s1gn4+urE\$";
$lang['allowpersonalmessages'] = "aLLow o+H3R u5Er5 t0 \$EnD Me p3rsOnAl me\$54G3s";
$lang['allowemails'] = "aLLOW 0+hEr u5Er\$ To sENd me 3m41lS v14 mY PRoPh1Le";
$lang['timezonefromGMT'] = "tIME zONE";
$lang['postsperpage'] = "p0ST\$ PeR p4gE";
$lang['fontsize'] = "f0N+ \$IzE";
$lang['forumstyle'] = "f0rum s+Yl3";
$lang['forumemoticons'] = "f0RuM EM0+iCONS";
$lang['startpage'] = "st4R+ p@G3";
$lang['containsHTML'] = "c0Nt4In5 htML";
$lang['preferredlang'] = "prEF3rreD l4ngU4G3";
$lang['donotshowmyageordobtoothers'] = "dO NoT 5H0w MY 493 0r d4T3 OF 8ir+H +0 O+hERS";
$lang['showonlymyagetoothers'] = "show ONlY mY 4G3 +0 0+hEr5";
$lang['showmyageanddobtoothers'] = "sH0W bO+h my @gE 4Nd D4t3 oph 8irth tO o+hERs";
$lang['showonlymydayandmonthofbirthytoothers'] = "sh0W oNLy MY D@y @nD moNTh OPh 8Ir+H t0 0+h3R\$";
$lang['listmeontheactiveusersdisplay'] = "l1\$T m3 0N tH3 @Ct1ve U\$3rs D1sPL4Y";
$lang['browseanonymously'] = "bR0W53 f0ruM @n0NymOU\$ly";
$lang['allowfriendstoseemeasonline'] = "bR0w53 4n0NyM0u\$LY, 8u+ 4LL0W PHR1ENDs T0 \$3E M3 4s ONLINe";
$lang['revealspoileronmouseover'] = "r3V34l spo1l3R5 ON m0u\$3 oVEr";
$lang['resizeimagesandreflowpage'] = "rE\$IZE IM@9E5 @nD rephLoW P4G3 t0 Pr3VeNt H0rIzOnt@l scROll1ng.";
$lang['showforumstats'] = "sH0w pH0rUm 5T@+\$ 4+ Bo++om 0ph Me\$s4gE p4N3";
$lang['usewordfilter'] = "eN48le w0RD ph1L+3R.";
$lang['forceadminwordfilter'] = "foRCE use 0f ADMIN word PH1lt3R On 4lL U\$er\$ (inc. 9U3\$+s)";
$lang['timezone'] = "tim3 z0n3";
$lang['language'] = "l@NgUA9E";
$lang['emailsettings'] = "emAiL 4ND cONTaCT 53TT1N9\$";
$lang['forumanonymity'] = "f0RUm 4n0nYMITy \$e+t1nGS";
$lang['birthdayanddateofbirth'] = "b1rThD4y 4nd D@+e 0f B1rtH D1\$Pl4Y";
$lang['includeadminfilter'] = "incLuD3 @DM1N WorD F1lter iN MY L1\$+.";
$lang['setforallforums'] = "s3+ pHOr 4LL foRumS?";
$lang['containsinvalidchars'] = "coNt41N3d iNV4lID cH4rAc+3Rs!";
$lang['postpage'] = "p05+ P493";
$lang['nohtmltoolbar'] = "n0 H+Ml To0lb4r";
$lang['displaysimpletoolbar'] = "d15PL@Y 51MPLe hTMl +0OLB@R";
$lang['displaytinymcetoolbar'] = "dIspL@Y WysiWyG htmL T0oL84R";
$lang['displayemoticonspanel'] = "d1SPL4y emOt1C0N\$ p4n3l";
$lang['displaysignature'] = "d1\$pL@Y 5ign4+uRE";
$lang['disableemoticonsinpostsbydefault'] = "dis4Bl3 emo+1cONs 1N mE5\$@geS 8y DeF4Ul+";
$lang['automaticallyparseurlsbydefault'] = "aU+0m4tIC4llY p4R\$e UrLs 1N ME\$SaGe5 8Y D3f@uLT";
$lang['postinplaintextbydefault'] = "p05t 1n pL@1N T3X+ bY D3f4Ult";
$lang['postinhtmlwithautolinebreaksbydefault'] = "p0s+ iN H+ML wiTh @UT0-lIn3-BRe4Ks 8y d3F@ult";
$lang['postinhtmlbydefault'] = "po5t In H+Ml 8Y dEF4uL+";
$lang['privatemessageoptions'] = "pRiv4+3 m3\$5@9e optI0nS";
$lang['privatemessageexportoptions'] = "priv@t3 M35\$493 3xpORt 0p+10Ns";
$lang['savepminsentitems'] = "s4v3 @ cOpY 0f eAch pM 1 S3ND 1n My \$eNT it3m\$ PhoLdER";
$lang['includepminreply'] = "iNCLUd3 MEss493 bodY WH3N REPly1n9 t0 pM";
$lang['autoprunemypmfoldersevery'] = "aut0 prUN3 My pM PholDER5 eV3RY:";
$lang['friendsonly'] = "fR1eND\$ 0nlY?";
$lang['globalstyles'] = "gLob@L 5TYlES";
$lang['forumstyles'] = "fORuM \$+yLe\$";

// Polls (create_poll.php, poll_results.php) ---------------------------------------------

$lang['mustprovideanswergroups'] = "j00 mU\$+ PR0v1De SoME 4nSw3r Gr0ups";
$lang['mustprovidepolltype'] = "j00 MUS+ pROviDe 4 pOlL +yPe";
$lang['mustprovidepollresultsdisplaytype'] = "j00 Mus+ PROVIdE R35UlTS DI5pL4Y TyPe";
$lang['mustprovidepollvotetype'] = "j00 MUST Pr0v1De @ poLl vo+3 +Yp3";
$lang['mustprovidepollguestvotetype'] = "j00 MUST 5Pec1pHY 1Ph gUEs+\$ \$H0ulD B3 @Ll0weD t0 voTE";
$lang['mustprovidepolloptiontype'] = "j00 mU5+ pr0vid3 @ pOll 0P+IOn TYp3";
$lang['mustprovidepollchangevotetype'] = "j00 mUs+ PRoviDE 4 POll Ch4NGE V0Te +Yp3";
$lang['pleaseselectfolder'] = "ple@SE \$3LEc+ @ PhOLDER";
$lang['mustspecifyvalues1and2'] = "j00 muST SPEcIpHY v@Lu35 F0R @nSw3R\$ 1 @Nd 2";
$lang['tablepollmusthave2groups'] = "ta8uL@R F0rm4+ pOlL5 MuST h4V3 PR3cI\$ely tWO Vo+1N9 gROUP\$";
$lang['nomultivotetabulars'] = "t48UlAr F0RMat p0Lls caNnO+ B3 mULtI-VotE";
$lang['nomultivotepublic'] = "publ1C B@llO+s c4Nn0+ be mult1-V0+E";
$lang['abletochangevote'] = "j00 w1LL 83 @bl3 T0 cH4N9E yoUr v0t3.";
$lang['abletovotemultiple'] = "j00 Will 83 4blE TO V0+E mUL+1pL3 +1m3\$.";
$lang['notabletochangevote'] = "j00 wIll NoT be 48L3 +O cH4n93 YoUR v0+e.";
$lang['pollvotesrandom'] = "n0T3: P0ll v0t35 @Re R@nDoMly g3N3R4t3d PhOR pR3v13W only.";
$lang['pollquestion'] = "p0ll qUe5T1On";
$lang['possibleanswers'] = "p0s\$18L3 4n5w3r\$";
$lang['enterpollquestionexp'] = "en+er +He 4n\$W3r\$ Ph0R Y0uR PolL Qu3\$tION.. IF y0ur pOLl iS 4 &quot;y3\$/n0&quot; que\$+I0n, \$1mPlY 3nt3R &quot;YEs&quot; pH0R AN\$WeR 1 aNd &quot;no&quot; fOr 4n5Wer 2.";
$lang['numberanswers'] = "n0. Answ3r\$";
$lang['answerscontainHTML'] = "aNsw3RS COn+4in HtmL (No+ iNcLUd1ng S1gn4+Ure)";
$lang['optionsdisplay'] = "aN\$WeR\$ D1SPl4y TYp3";
$lang['optionsdisplayexp'] = "h0w ShouLd +He 4nsw3RS bE pRE\$eNt3d?";
$lang['dropdown'] = "a5 dR0P-d0Wn LiSt(\$)";
$lang['radios'] = "as 4 S3R1es oF r@di0 8U++0nS";
$lang['votechanging'] = "vo+E cHanG1n9";
$lang['votechangingexp'] = "c@n 4 pErs0N ch@ngE hiS oR h3r V0+3?";
$lang['guestvoting'] = "gue5+ v0T1nG";
$lang['guestvotingexp'] = "c@n guEst\$ v0T3 In TH1\$ P0LL?";
$lang['allowmultiplevotes'] = "all0w mUl+1pLe vO+es";
$lang['pollresults'] = "pOLl r35Ult\$";
$lang['pollresultsexp'] = "h0w w0ulD j00 l1K3 T0 dISpl4Y ThE rE5UL+5 0f Y0Ur poLL?";
$lang['pollvotetype'] = "p0lL v0Tin9 +Ype";
$lang['pollvotesexp'] = "hOw \$houLD ThE Poll 83 c0NDUc+Ed?";
$lang['pollvoteanon'] = "aNoNYm0u5lY";
$lang['pollvotepub'] = "pU8LiC B4LlOt";
$lang['horizgraph'] = "hoRiz0nT4L 9r4ph";
$lang['vertgraph'] = "v3rT1CAl gR4PH";
$lang['tablegraph'] = "t@BulAR pH0rM4+";
$lang['polltypewarning'] = "<b>wArN1N9</b>: Th1s iS @ pUBl1C 84ll0T. y0ur N4ME wiLL 83 VI\$1bLE nEx+ To T3h oPTI0N J00 v0T3 phor.";
$lang['expiration'] = "eXpiRaT1ON";
$lang['showresultswhileopen'] = "do j00 W4Nt +o \$hoW re\$Ult\$ WH1LE t3H pOlL 1S oP3n?";
$lang['whenlikepollclose'] = "wheN WoULd J00 LIkE YOuR poLl +0 @u+Om@+1c@LLy clO\$E?";
$lang['oneday'] = "on3 d@y";
$lang['threedays'] = "thre3 d4Y\$";
$lang['sevendays'] = "s3v3N d@Y5";
$lang['thirtydays'] = "thiR+y D4Y\$";
$lang['never'] = "n3vER";
$lang['polladditionalmessage'] = "aDD1+1ON4L MESS493 (oP+1oN@L)";
$lang['polladditionalmessageexp'] = "d0 J00 W4nt +0 includ3 4N 4Dd1+iON4l pOS+ 4f+Er +h3 P0LL?";
$lang['mustspecifypolltoview'] = "j00 Mu5+ Sp3c1Fy 4 pOll TO v1eW.";
$lang['pollconfirmclose'] = "aR3 j00 Sur3 j00 W@nt +O CL0Se +hE pH0lLOWiN9 pOlL?";
$lang['endpoll'] = "eND pOlL";
$lang['nobodyvotedclosedpoll'] = "nOBody vo+eD";
$lang['votedisplayopenpoll'] = "%s 4ND %s H4Ve v0+3D.";
$lang['votedisplayclosedpoll'] = "%s 4ND %s V0+Ed.";
$lang['nousersvoted'] = "n0 User\$";
$lang['oneuservoted'] = "1 U\$3r";
$lang['xusersvoted'] = "%s uSEr5";
$lang['noguestsvoted'] = "nO 9UE\$+s";
$lang['oneguestvoted'] = "1 9u3S+";
$lang['xguestsvoted'] = "%s GueS+S";
$lang['pollhasended'] = "p0LL h4\$ End3d";
$lang['youvotedforpolloptionsondate'] = "j00 VoT3d Ph0R %s 0N %s";
$lang['thisisapoll'] = "tHis i\$ 4 p0ll. CliCk +0 V13w reSUl+5.";
$lang['editpoll'] = "ed1+ p0Ll";
$lang['results'] = "rE\$uLtS";
$lang['resultdetails'] = "r35Ul+ de+41ls";
$lang['changevote'] = "chAn93 Vo+e";
$lang['pollshavebeendisabled'] = "p0Ll\$ H4V3 83en DiS48L3D BY +h3 F0Rum 0wnER.";
$lang['answertext'] = "an\$Wer +3X+";
$lang['answergroup'] = "answER grOuP";
$lang['previewvotingform'] = "pr3v13W vO+ing pHOrm";
$lang['viewbypolloption'] = "viEw BY polL Opt10n";
$lang['viewbyuser'] = "v1Ew BY u53R";

// Profiles (profile.php) ----------------------------------------------

$lang['editprofile'] = "eD1+ pr0fIl3";
$lang['profileupdated'] = "proPH1lE upD4+3d.";
$lang['profilesnotsetup'] = "tHe pH0RuM OWN3r h45 N0T 5eT Up pr0PhIlE\$.";
$lang['ignoreduser'] = "i9noRed Us3r";
$lang['lastvisit'] = "l4\$+ v151+";
$lang['totaltimeinforum'] = "tO+Al +1ME";
$lang['longesttimeinforum'] = "loN9e5t Se\$S10n";
$lang['sendemail'] = "s3Nd em41l";
$lang['sendpm'] = "sEnd pM";
$lang['visithomepage'] = "v1\$i+ HOM3p@9E";
$lang['age'] = "agE";
$lang['aged'] = "a9ed";
$lang['birthday'] = "biR+Hd4Y";
$lang['registered'] = "r3G1ST3rED";
$lang['findusersposts'] = "f1Nd uSER'S p0\$tS";
$lang['findmyposts'] = "f1ND MY Po\$+s";

// Registration (register.php) -----------------------------------------

$lang['newuserregistrationsarenotpermitted'] = "sOrRY, neW U5Er REg1s+r4+iOn\$ @r3 n0+ 4lloWed r1gHt Now. PLe4\$e Ch3cK 84cK L@+Er.";
$lang['usernameinvalidchars'] = "uS3rN@ME c4N ONLy Con+41n 4-Z, 0-9, _ - CH@R4CT3RS";
$lang['usernametooshort'] = "u5ERN4mE MUS+ Be 4 M1N1MUm of 2 cH4r4C+Er\$ L0N9";
$lang['usernametoolong'] = "u\$3rn@Me muS+ 83 @ m4X1MuM 0F 15 Ch4R@ct3RS L0ng";
$lang['usernamerequired'] = "a LOgON N4m3 1\$ REqUir3d";
$lang['passwdmustnotcontainHTML'] = "p4ssw0Rd mUs+ n0t con+41n HTml +A9s";
$lang['passwordinvalidchars'] = "p45\$W0Rd C4N 0NlY c0n+4IN 4-z, 0-9, _ - Ch@R@C+3r\$";
$lang['passwdtooshort'] = "p4s\$wOrd MU5+ b3 4 mIn1MuM of 6 cH4r4c+ER5 l0n9";
$lang['passwdrequired'] = "a p@5swORd 15 rEqUiR3D";
$lang['confirmationpasswdrequired'] = "a CoNfirma+I0n P@\$\$wORd is r3Qu1rEd";
$lang['nicknamerequired'] = "a NicKN4me 1s rEqUIr3d";
$lang['emailrequired'] = "aN 3M41L @ddRESS 1s RequireD";
$lang['passwdsdonotmatch'] = "p@SSwOrD5 D0 nOt m4+ch";
$lang['usernamesameaspasswd'] = "us3rN4me anD P@S\$W0Rd Mu5T b3 DiFF3rENT";
$lang['usernameexists'] = "s0Rry, 4 U\$3r w1+h Th4t N@M3 Alre4DY EXiS+s";
$lang['successfullycreateduseraccount'] = "sUCCeSSfuLLY Cr34+3D u\$eR 4cC0Unt";
$lang['useraccountcreatedconfirmfailed'] = "y0ur u\$er 4CCOuN+ h4S BE3N cR3A+3D bU+ +eh R3Qu1RED c0NFiRm4TI0N 3M4Il w4\$ NO+ \$3n+. PLe@\$3 C0n+4c+ tH3 PH0rUm 0Wn3R +0 R3c+1fy +h15. in +Hi\$ M34nt1me Ple4S3 cL1ck +eH CoNT1NuE 8uTtON +O loG1N in.";
$lang['useraccountcreatedconfirmsuccess'] = "y0ur U53r @cC0UNt H45 Be3N CR34+ED 8UT bEf0Re J00 c4n S+4r+ PoStInG J00 MUsT conPhIRM y0UR 3m41l ADDREs\$. PLE4S3 CheCK y0uR 3m4Il f0r @ linK Th4+ W1ll @LLOw j00 +o c0NphIRM Y0ur 4dDreSs.";
$lang['useraccountcreated'] = "y0Ur Us3R aCC0UNt h4\$ be3n cr34T3D 5UCces\$Fully! CLicK t3H CoN+InuE 8Ut+0N beLow t0 LOg1n";
$lang['errorcreatinguserrecord'] = "erROr Cr34T1N9 us3r REcORD";
$lang['userregistration'] = "u53r Re91STR@tiOn";
$lang['registrationinformationrequired'] = "r3g1\$+r4+iON INform4TIon (R3quIr3d)";
$lang['profileinformationoptional'] = "pR0F1Le 1nPhormatI0n (0P+I0n@l)";
$lang['preferencesoptional'] = "pr3PH3R3NcEs (0pT10nAl)";
$lang['register'] = "r39iS+ER";
$lang['rememberpasswd'] = "rEmEmbER p4\$SW0RD";
$lang['birthdayrequired'] = "yOUR D4+e Oph 81rtH 1\$ R3qUir3D Or 1\$ 1NV4LId";
$lang['alwaysnotifymeofrepliestome'] = "n0+1PhY On REPly TO M3";
$lang['notifyonnewprivatemessage'] = "n0t1pHY ON n3W priV@+E m35S4ge";
$lang['popuponnewprivatemessage'] = "pOP up on n3W Pr1V4+E meS\$493";
$lang['automatichighinterestonpost'] = "au+0M4TIc hi9h 1nt3R35+ 0n pO\$+";
$lang['confirmpassword'] = "c0NpH1RM P@ssW0rD";
$lang['invalidemailaddressformat'] = "iNv4l1d 3m@1L @DDr3SS foRm4+";
$lang['moreoptionsavailable'] = "m0r3 PR0FilE 4nd pr3f3r3Nce 0Pt1oN\$ 4rE 4V41La8LE onCE J00 RE9I\$tEr";
$lang['textcaptchaconfirmation'] = "c0nfiRM4+I0N";
$lang['textcaptchaexplain'] = "tO THe r19ht 1s a tex+-c4p+ChA Im493. pl34s3 +ype t3H C0D3 j00 c4n See IN T3H Im493 int0 +H3 1nPU+ Ph1eld BelOw I+.";
$lang['textcaptchaimgtip'] = "th1s 15 4 c4pTcha-PIC+Ur3. 1t I\$ U5eD +0 PrEv3nt 4uT0M4+iC Regis+r4t10n";
$lang['textcaptchamissingkey'] = "a CONPHiRM4TIOn COD3 Is REQU1ReD.";
$lang['textcaptchaverificationfailed'] = "t3xT-CAP+Ch4 v3r1pH1cA+ion cOde W4\$ INc0Rr3C+. pLE@53 rE-3N+er 1t.";

// Recent visitors list  (visitor_log.php) -----------------------------

$lang['member'] = "mEmb3r";
$lang['searchforusernotinlist'] = "sE@RCh f0r 4 u53r nO+ 1N L1\$T";
$lang['yoursearchdidnotreturnanymatches'] = "yoUR \$34RCh D1d NOT rETURN @ny m@+cheS. TRY 51MPl1fY1ng y0ur 53ArCH p@RAM3+Ers @nd TRy 49@1N.";
$lang['hiderowswithemptyornullvalues'] = "h1De roWS w1th 3mp+Y 0r nuLl V@lU3\$ iN 5eL3CTed ColuMn\$";
$lang['showregisteredusersonly'] = "sh0w R3g1\$tERED U5Er5 0nlY (hID3 9U3\$T\$)";

// Relationships (user_rel.php) ----------------------------------------

$lang['relationships'] = "rEl4t10n5H1P\$";
$lang['userrelationship'] = "u\$er rel4T1oN\$h1P";
$lang['userrelationships'] = "us3r rEl4tion5H1pS";
$lang['friends'] = "fr1EnDs";
$lang['ignoredcompletely'] = "i9N0r3d COMPLE+ELY";
$lang['relationship'] = "r3L4t1ONSh1P";
$lang['restorenickname'] = "re5T0r3 u\$ER'5 N1ckN@Me";
$lang['friend_exp'] = "u5eR's Pos+s m4Rk3D w1+H A &quot;fr1eND&quot; ic0N.";
$lang['normal_exp'] = "uSer'5 P05T5 4pp34r 45 N0RM4l.";
$lang['ignore_exp'] = "u5eR'5 P05+s aRe hIdDEN.";
$lang['ignore_completely_exp'] = "tHre@D\$ 4Nd P0\$TS To 0r Fr0m u5er w1Ll 4pPe4r DEL3teD.";
$lang['display'] = "d1\$pl@Y";
$lang['displaysig_exp'] = "u53R'\$ s1gN4+urE 15 DIsPl@Y3D on TH3ir p0STS.";
$lang['hidesig_exp'] = "uSeR'5 S1gN4+ur3 15 h1Dden 0N +H31R p0STs.";
$lang['globallyignored'] = "gLo8@LLY 1gNORED";
$lang['globallyignoredsig_exp'] = "n0 519N@tuRE\$ Are d1\$PL4y3d.";
$lang['cannotignoremod'] = "j00 C4NnOt 19noRE +H1\$ USer, 45 +Hey 4R3 4 mOd3rA+0R.";

// Search (search.php) -------------------------------------------------

$lang['searchresults'] = "s34rCH R3SULtS";
$lang['usernamenotfound'] = "teh Us3Rn@m3 J00 5PECIph1eD 1N tHe +O 0r PhROM PHielD wAS N0t fOUnd.";
$lang['notexttosearchfor'] = "on3 0r 4LL OF y0UR 5E4RCH keYw0Rd\$ weRE iNv@lID. \$3@rcH k3yw0rDs MU5t b3 n0 Sh0R+3r th@n %d CH@R@c+3rs, nO loNGeR tH4n %d Ch@R4cTeRs 4nd mu5t n0+ 4PpE4r iN tH3 %s";
$lang['mysqlstopwordlist'] = "mY5QL \$TOpW0Rd L1St";
$lang['foundzeromatches'] = "fOuNd: 0 M4tChEs";
$lang['found'] = "f0Und";
$lang['matches'] = "m4Tche\$";
$lang['prevpage'] = "pr3vIou5 P4GE";
$lang['findmore'] = "f1Nd M0Re";
$lang['searchmessages'] = "s34rcH ME\$\$49E5";
$lang['searchdiscussions'] = "s34RcH D1SCu5\$IoN\$";
$lang['find'] = "f1nd";
$lang['additionalcriteria'] = "aDDI+10N@l Cri+eR14";
$lang['searchbyuser'] = "s34rCh 8Y uS3r (Op+i0n@l)";
$lang['folderbrackets_s'] = "folD3r(5)";
$lang['postedfrom'] = "p0\$+Ed pHR0m";
$lang['postedto'] = "p0S+eD T0";
$lang['today'] = "tod4Y";
$lang['yesterday'] = "yE\$+erDAy";
$lang['daybeforeyesterday'] = "dAy Bef0re Y3\$t3Rd@Y";
$lang['weekago'] = "%s w33K a90";
$lang['weeksago'] = "%s W3eK5 @90";
$lang['monthago'] = "%s mOnth 4Go";
$lang['monthsago'] = "%s m0N+h5 49o";
$lang['yearago'] = "%s Y3@r 4G0";
$lang['beginningoftime'] = "b3G1NnIn9 0f t1m3";
$lang['now'] = "now";
$lang['lastpostdate'] = "lasT P0S+ D@+3";
$lang['numberofreplies'] = "nUmBER 0F R3Pl13\$";
$lang['foldername'] = "foldEr N@ME";
$lang['authorname'] = "aUTHOr n4m3";
$lang['decendingorder'] = "nEw3st Ph1RS+";
$lang['ascendingorder'] = "olD3s+ PHir\$T";
$lang['keywords'] = "keYW0rd5";
$lang['sortby'] = "s0R+ by";
$lang['sortdir'] = "soR+ DIR";
$lang['sortresults'] = "s0RT RE\$uL+S";
$lang['groupbythread'] = "gR0up bY thre4d";
$lang['postsfromuser'] = "p0\$t\$ FroM US3R";
$lang['poststouser'] = "p0\$+S TO u5eR";
$lang['poststoandfromuser'] = "pOS+S to 4nD PhROM uSer";
$lang['searchfrequencyerror'] = "j00 C4N 0Nly S34RCH onCe 3VEry %s 5EC0ndS. Ple4\$3 tRy 49@iN l@t3r.";

// Search Popup (search_popup.php) -------------------------------------

$lang['select'] = "s3LeC+";
$lang['searchforthread'] = "s34rCH fOR tHre@D";
$lang['mustspecifytypeofsearch'] = "j00 Mu5+ sPEc1fy typ3 of \$3@RCh +o P3rF0rm";
$lang['unkownsearchtypespecified'] = "uNKn0Wn S34rCh +YPE \$p3C1pHieD";

// Start page (start_left.php) -----------------------------------------

$lang['recentthreads'] = "r3c3N+ tHRe@d\$";
$lang['startreading'] = "s+4RT READinG";
$lang['threadoptions'] = "tHRe4d 0pT10N\$";
$lang['editthreadoptions'] = "eD1T +Hr34d 0p+i0nS";
$lang['morevisitors'] = "mOR3 VI\$1t0rS";
$lang['forthcomingbirthdays'] = "fORThcOM1n9 81rTHdAys";

// Start page (start_main.php) -----------------------------------------

$lang['editstartpage_help'] = "j00 c4N 3DIT +h1\$ P@gE PHr0M T3H 4Dm1N 1NTERpH4C3";
$lang['uploadstartpage'] = "uPL04D 5+ArT p493 (%s)";
$lang['invalidfiletypeerror'] = "f1l3 +yPe N0T \$UPp0R+3d. j00 c4n 0Nly U\$e *.tx+, *.PhP And *.hTM f1L3S 4S y0ur 5T4rt p@9E.";

// Thread navigation (thread_list.php) ---------------------------------

$lang['newdiscussion'] = "nEW D1ScUs5IOn";
$lang['createpoll'] = "cr3@+e p0ll";
$lang['search'] = "s3ArCH";
$lang['searchagain'] = "s3ArcH 4G41n";
$lang['alldiscussions'] = "aLL dIScuS\$10ns";
$lang['unreaddiscussions'] = "uNR34D dIScu\$\$i0n\$";
$lang['unreadtome'] = "unre4d &quot;TO: mE&quot;";
$lang['todaysdiscussions'] = "toD@Y'5 D1\$cU\$sI0n\$";
$lang['2daysback'] = "2 D4Ys 8@cK";
$lang['7daysback'] = "7 d@y\$ 8@CK";
$lang['highinterest'] = "hiGh IN+3Res+";
$lang['unreadhighinterest'] = "unre4d H1Gh iN+eRE\$t";
$lang['iverecentlyseen'] = "i'v3 R3cen+lY 53EN";
$lang['iveignored'] = "i'V3 I9nOR3D";
$lang['byignoredusers'] = "by 19n0R3D UsEr5";
$lang['ivesubscribedto'] = "i'v3 sUbsCR1B3D +0";
$lang['startedbyfriend'] = "s+4RT3d bY PhriEnd";
$lang['unreadstartedbyfriend'] = "uNRE4d 5tD bY pHR13nd";
$lang['startedbyme'] = "s+@R+3D 8Y mE";
$lang['unreadtoday'] = "uNR3@d T0D4y";
$lang['deletedthreads'] = "d3LE+3D +hre4D\$";
$lang['goexcmark'] = "g0!";
$lang['folderinterest'] = "f0LD3R 1N+Er3ST";
$lang['postnew'] = "pOsT N3w";
$lang['currentthread'] = "curRen+ +HRE4D";
$lang['highinterest'] = "hIgH 1n+3R3s+";
$lang['markasread'] = "m4rK 4S r3Ad";
$lang['next50discussions'] = "n3Xt 50 dIscuS\$1on\$";
$lang['visiblediscussions'] = "v15iblE DIscus5I0nS";
$lang['selectedfolder'] = "s3LEC+3d PhoLD3r";
$lang['navigate'] = "n4ViG4+E";
$lang['couldnotretrievefolderinformation'] = "tHER3 4R3 No PholD3rs 4V4il@BLE.";
$lang['nomessagesinthiscategory'] = "n0 Me55Age\$ in THis CAteGORY. pLE4S3 53LEc+ @N0+heR, or";
$lang['clickhere'] = "cLiCk Here";
$lang['forallthreads'] = "f0r 4Ll thr34Ds";
$lang['prev50threads'] = "pR3V10U\$ 50 +hRe4ds";
$lang['next50threads'] = "nEXt 50 THre@d5";
$lang['nextxthreads'] = "neXt %s +Hr3@DS";
$lang['prevxthreads'] = "prev %s Thr34d\$";
$lang['threadstartedbytooltip'] = "thRE@D #%s \$t@Rt3D by %s. VI3WED %s";
$lang['threadviewedonetime'] = "1 t1m3";
$lang['threadviewedtimes'] = "%d +1M3\$";
$lang['unreadthread'] = "uNRe4d +hr34d";
$lang['readthread'] = "re4D THR34d";
$lang['unreadmessages'] = "uNre4D m35\$493s";
$lang['subscribed'] = "suBscRibed";
$lang['ignorethisfolder'] = "ignoR3 thI5 fOldeR";
$lang['stopignoringthisfolder'] = "stOP IGNOR1ng +HI\$ FoLd3R";
$lang['stickythreads'] = "sTIcKY +hr34d\$";
$lang['mostunreadposts'] = "m0\$+ uNr3aD POS+s";
$lang['onenew'] = "%d nEW";
$lang['manynew'] = "%d nEW";
$lang['onenewoflength'] = "%d NEw 0f %d";
$lang['manynewoflength'] = "%d n3w 0ph %d";
$lang['ignorefolderconfirm'] = "ar3 J00 SuRe J00 w4nT +0 I9noRE +h1s FoLD3R?";
$lang['unignorefolderconfirm'] = "aR3 j00 \$Ur3 j00 w@nT +O \$t0P 19n0r1NG thi\$ PHoLD3r?";
$lang['gotofirstpostinthread'] = "gO t0 phir5T pO5t 1N THr3@D";
$lang['gotolastpostinthread'] = "g0 +o La\$T p05T 1N THRe4d";
$lang['viewmessagesinthisfolderonly'] = "vIew M35sa93S In TH1\$ PH0ldER only";
$lang['shownext50threads'] = "sHOw NeXt 50 +HR3@d\$";
$lang['showprev50threads'] = "sHoW pR3v1Ou5 50 ThrE4D5";
$lang['createnewdiscussioninthisfolder'] = "cr34T3 N3W d1sCu55i0n iN +h15 PHOLd3r";

// HTML toolbar (htmltools.inc.php) ------------------------------------
$lang['bold'] = "bolD";
$lang['italic'] = "i+4liC";
$lang['underline'] = "underl1N3";
$lang['strikethrough'] = "sTRik3+HrOu9H";
$lang['superscript'] = "supERSCr1pt";
$lang['subscript'] = "sU8\$CRipt";
$lang['leftalign'] = "lephT-4li9N";
$lang['center'] = "cEn+Er";
$lang['rightalign'] = "r1GHt-4LIGn";
$lang['numberedlist'] = "nUMbeR3D L1sT";
$lang['list'] = "l1\$+";
$lang['indenttext'] = "iNDeN+ tex+";
$lang['code'] = "c0de";
$lang['quote'] = "qu0TE";
$lang['spoiler'] = "sPoil3r";
$lang['horizontalrule'] = "hOrIZon+4l RUL3";
$lang['image'] = "im@93";
$lang['hyperlink'] = "hYpeRl1nK";
$lang['noemoticons'] = "d15@8le emot1c0ns";
$lang['fontface'] = "foNT F4c3";
$lang['size'] = "sizE";
$lang['colour'] = "c0l0ur";
$lang['red'] = "r3d";
$lang['orange'] = "or4nGE";
$lang['yellow'] = "yelL0W";
$lang['green'] = "greEn";
$lang['blue'] = "bLU3";
$lang['indigo'] = "iND1go";
$lang['violet'] = "vi0L3+";
$lang['white'] = "wH1+E";
$lang['black'] = "blaCk";
$lang['grey'] = "gr3y";
$lang['pink'] = "p1Nk";
$lang['lightgreen'] = "li9Ht 9r3EN";
$lang['lightblue'] = "ligH+ 8lu3";

// Forum Stats (messages.inc.php - messages_forum_stats()) -------------

$lang['forumstats'] = "foRUM 5tA+\$";
$lang['usersactiveinthepasttimeperiod'] = "%s 4cT1ve 1n tHe P@s+ %s.";

$lang['numactiveguests'] = "<b>%s</b> 9U3S+S";
$lang['oneactiveguest'] = "<b>1</b> Gu3S+";
$lang['numactivemembers'] = "<b>%s</b> m3M83RS";
$lang['oneactivemember'] = "<b>1</b> m3mB3R";
$lang['numactiveanonymousmembers'] = "<b>%s</b> 4nonymOUS m3mB3r5";
$lang['oneactiveanonymousmember'] = "<b>1</b> anOnymOUs mem83R";

$lang['numthreadscreated'] = "<b>%s</b> +HrE@dS";
$lang['onethreadcreated'] = "<b>1</b> THR34D";
$lang['numpostscreated'] = "<b>%s</b> Post5";
$lang['onepostcreated'] = "<b>1</b> pO5+";

$lang['younormal'] = "j00";
$lang['youinvisible'] = "j00 (1NvisiblE)";
$lang['viewcompletelist'] = "vI3W CoMpl3tE L1ST";
$lang['ourmembershavemadeatotalofnumthreadsandnumposts'] = "oUr meMBER\$ H4ve M@d3 A +O+4L 0pH %s 4ND %s.";
$lang['longestthreadisthreadnamewithnumposts'] = "l0N9Es+ +hRE@D 1s <b>%s</b> w1+H %s.";
$lang['therehavebeenxpostsmadeinthelastsixtyminutes'] = "tH3re HAv3 8E3n <b>%s</b> p0s+s m4de In T3h l45+ 60 miNUtE5.";
$lang['therehasbeenonepostmadeinthelastsxityminutes'] = "tHErE h4S 833N <b>1</b> pOsT m4dE In +He l@5+ 60 M1NU+e5.";
$lang['mostpostsevermadeinasinglesixtyminuteperiodwasnumposts'] = "m0ST p0STS evEr m4d3 1n a \$IN9LE 60 M1Nute PEr1Od Is <b>%s</b> On %s.";
$lang['wehavenumregisteredmembersandthenewestmemberismembername'] = "we h4v3 <b>%s</b> REg1\$T3rED mEM8ERS 4Nd +3H N3W35+ meMb3r 1S <b>%s</b>.";
$lang['wehavenumregisteredmember'] = "w3 H4V3 %s REGI\$TeR3d M3mBErs.";
$lang['wehaveoneregisteredmember'] = "we H@vE one rEGISTereD M3MB3R.";
$lang['mostuserseveronlinewasnumondate'] = "m0St u\$3rs EV3R 0nLINe W@s <b>%s</b> on %s.";
$lang['statsdisplayenabled'] = "s+4+\$ Di5Pl4y en@bled";

// Thread Options (thread_options.php) ---------------------------------

$lang['updatesmade'] = "uPd4Tes m4de";
$lang['useroptions'] = "u5eR 0PTI0nS";
$lang['markedasread'] = "m@RKeD @s re4D";
$lang['postsoutof'] = "p05t\$ OuT 0Ph";
$lang['interest'] = "in+EREst";
$lang['closedforposting'] = "clOs3d fOr Po5T1n9";
$lang['locktitleandfolder'] = "lOCk +i+lE aND F0ld3R";
$lang['deletepostsinthreadbyuser'] = "dELE+E PO\$+s 1N +HRe@D bY U53R";
$lang['deletethread'] = "deletE +HRE@D";
$lang['permenantlydelete'] = "pErMENaN+ly d3Le+e";
$lang['movetodeleteditems'] = "m0vE +0 d3LE+3d ThrE@D\$";
$lang['undeletethread'] = "uNDeL3+3 THr34d";
$lang['threaddeletedpermenantly'] = "thRead dEL3Ted PErm4n3ntLy. c@NnO+ uND3lE+E.";
$lang['markasunread'] = "m4rK @S UNR34d";
$lang['makethreadsticky'] = "m@kE ThREad 5TicKY";
$lang['threareadstatusupdated'] = "thre@D RE@d \$T4tU\$ Upd4+ed \$uCc355fulLy";
$lang['interestupdated'] = "tHR3@d 1NT3RE\$+ sTa+u5 UpDA+3d SUcc3ssfulLY";

// Dictionary (dictionary.php) -----------------------------------------

$lang['dictionary'] = "d1C+ionaRY";
$lang['spellcheck'] = "speLl cHeck";
$lang['notindictionary'] = "noT iN dict10n4ry";
$lang['changeto'] = "ch@N93 To";
$lang['initialisingdotdotdot'] = "iNi+14LIs1n9...";
$lang['spellcheckcomplete'] = "sP3lL cHecK 1\$ cOMpl3+e. D0 j00 wi5h +0 \$t@Rt 494iN fr0m +He b391NniN9?";
$lang['spellcheck'] = "sPell CHEcK";
$lang['noformobj'] = "nO ph0rm OBJec+ sP3c1FiED pH0r re+urn +exT";
$lang['bodytext'] = "b0DY TExt";
$lang['ignore'] = "i9NoRe";
$lang['ignoreall'] = "i9noRE 4ll";
$lang['change'] = "cH@n93";
$lang['changeall'] = "ch4NGE @Ll";
$lang['add'] = "aDd";
$lang['suggest'] = "sU9g3\$+";
$lang['nosuggestions'] = "(no sU9GEs+10N5)";
$lang['ok'] = "oK";
$lang['cancel'] = "c@NCEL";
$lang['dictionarynotinstalled'] = "no d1Ct10n@RY h4S be3n 1nsT4ll3D. Ple453 CONtAC+ +he ph0rUM 0WN3R +0 r3meDY +H15.";

// Permissions keys ----------------------------------------------------

$lang['postreadingallowed'] = "p05+ read1ng 4LLoWeD";
$lang['postcreationallowed'] = "pos+ CR3@t10n @lloWED";
$lang['threadcreationallowed'] = "tHR34d cR34+I0n 4lLOW3d";
$lang['posteditingallowed'] = "p0\$t 3D1+InG all0w3d";
$lang['postdeletionallowed'] = "po\$+ delet10n 4Ll0w3D";
$lang['attachmentsallowed'] = "at+4ChM3N+s 4lL0w3d";
$lang['htmlpostingallowed'] = "hTml P05+InG @ll0Wed";
$lang['signatureallowed'] = "sigN4tURe 4LLOWEd";
$lang['guestaccessallowed'] = "gu3St acCES\$ @lLOW3D";
$lang['postapprovalrequired'] = "p0s+ apPr0v4l r3Qu1r3d";

// RSS feeds gubbins

$lang['rssfeed'] = "r\$\$ f33D";
$lang['every30mins'] = "eVEry 30 M1nU+e\$";
$lang['onceanhour'] = "onCe 4n h0Ur";
$lang['every6hours'] = "eveRy 6 H0UR\$";
$lang['every12hours'] = "eV3ry 12 HoURs";
$lang['onceaday'] = "onCE @ d4Y";
$lang['rssfeeds'] = "rsS f3eD\$";
$lang['feedname'] = "fEed n4mE";
$lang['feedfoldername'] = "feED PH0LDEr n4Me";
$lang['feedlocation'] = "f33d Loc@+10N";
$lang['threadtitleprefix'] = "thread +1TLe pREFix";
$lang['feednameandlocation'] = "f3ed n4M3 4nD l0C4+iOn";
$lang['feedsettings'] = "fEeD s3++inG\$";
$lang['updatefrequency'] = "uPD@+e PHREquenCy";
$lang['rssclicktoreadarticle'] = "cliCK h3R3 T0 R34d +h15 @R+1Cl3";
$lang['addnewfeed'] = "add NEw PHe3d";
$lang['editfeed'] = "ed1+ Phe3d";
$lang['feeduseraccount'] = "f3ED u5eR 4CC0UN+";
$lang['noexistingfeeds'] = "no 3x15T1NG rss fEEd5 Ph0uNd. +o @DD a PHeed Ple4\$E cl1Ck +eh 8ut+0n 8EL0w";
$lang['rssfeedhelp'] = "h3RE J00 c@n s3TUp 50me Rs\$ F3Ed\$ FoR aU+oM4t1c PROp494+10N 1n+0 YOUr F0rUM. +3h 1+3Ms PhROM +3h RS\$ FEEDS j00 4dd WIll B3 Cr3aTed @S +Hr34ds WhIch u5erS c4n r3pLy To 4S 1F They W3RE N0RM4L p0\$+\$. Teh r\$s fE3d muS+ be ACCesSiBLe v1@ H+Tp oR 1t wILL No+ WORk.";
$lang['mustspecifyrssfeedname'] = "mUST 5p3CIFY r\$S FE3d N@ME";
$lang['mustspecifyrssfeeduseraccount'] = "mU\$t SP3CIfy r\$S PheeD usEr @Cc0UN+";
$lang['mustspecifyrssfeedfolder'] = "mu5+ \$p3ciPHY r55 Ph3Ed FOLdeR";
$lang['mustspecifyrssfeedurl'] = "mu\$+ \$PECiphy rS5 fE3D urL";
$lang['mustspecifyrssfeedupdatefrequency'] = "mus+ sPEC1PHY RS\$ F3eD upd4+3 pHreQuEncY";
$lang['unknownrssuseraccount'] = "unkn0WN RS\$ uS3R 4cC0UnT";
$lang['rssfeedsupportshttpurlsonly'] = "rss PH3ED 5uPp0rt5 hT+p UrL\$ 0nlY. 5eCur3 phe3D5 (ht+ps://) 4re NOT 5upPorT3D.";
$lang['rssfeedurlformatinvalid'] = "rs\$ PH3Ed url F0Rm4+ I5 InV4L1D. uRl mu5t iNclUD3 \$cH3m3 (e.g. ht+P://) @nD a HO\$+n4m3 (3.9. WwW.H0\$+N4Me.c0M).";
$lang['rssfeeduserauthentication'] = "r55 F33D D03s N0+ \$uPP0rT HtTP U\$3r @U+H3n+IC@Tion";
$lang['successfullyremovedselectedfeeds'] = "suCce55pHuLly rEmoV3D s3L3c+ED Ph3Ed\$";
$lang['successfullyaddedfeed'] = "sUccEs\$fULlY 4dDed n3W ph3ed";
$lang['successfullyeditedfeed'] = "succe5\$PhUlly EDi+3D feED";
$lang['failedtoremovefeeds'] = "f4IL3d +0 R3mOV3 5oME or 4Ll oF +3H SeleC+3D phe3ds";
$lang['failedtoaddnewrssfeed'] = "f@IL3d t0 @DD N3W R55 FEed";
$lang['failedtoupdaterssfeed'] = "f41LEd +0 uPd4+3 r\$S phe3d";
$lang['rssstreamworkingcorrectly'] = "rs5 \$+r34m 4ppeaR\$ t0 Be w0RK1N9 C0RREcTly";
$lang['rssstreamnotworkingcorrectly'] = "r\$S StRE4m w4s emP+Y or CouLD NO+ B3 pH0uND";
$lang['invalidfeedidorfeednotfound'] = "iNV@LID pHEEd 1D 0r fe3D Not PHOUND";

// PM Export Options

$lang['pmexportastype'] = "eXpOrt @\$ +YPE";
$lang['pmexporthtml'] = "h+mL";
$lang['pmexportxml'] = "xml";
$lang['pmexportplaintext'] = "pL4iN +Ex+";
$lang['pmexportmessagesas'] = "eXP0R+ MES\$493S 4\$";
$lang['pmexportonefileforallmessages'] = "onE F1le PH0r 4LL me5S4GE\$";
$lang['pmexportonefilepermessage'] = "onE PHIl3 p3r M35\$493";
$lang['pmexportattachments'] = "eXporT @T+4chM3NT5";
$lang['pmexportincludestyle'] = "incluD3 pHOrUM S+yLe \$h33+";
$lang['pmexportwordfilter'] = "apPly WOrd F1LTer T0 m3s\$@93\$";

// Thread merge / split options

$lang['threadsplit'] = "tHREad h4S beEN spLi+";
$lang['threadmerge'] = "thRE4d H4S b3en mER93D";
$lang['mergesplitthread'] = "mErg3 / 5pl1+ +HR34D";
$lang['mergewiththreadid'] = "merge Wi+H THr34D id:";
$lang['postsinthisthreadatstart'] = "p0\$+S in TH1\$ +HR34D @T st@r+";
$lang['postsinthisthreadatend'] = "p0sts 1n +His +hR34d a+ eNd";
$lang['reorderpostsintodateorder'] = "r3-0RD3R po5T\$ in+O d4+3 ORD3r";
$lang['splitthreadatpost'] = "spL1+ +hRe@d 4+ P0sT:";
$lang['selectedpostsandrepliesonly'] = "sElEcteD pO5+ 4Nd r3pLI3s 0NLy";
$lang['selectedandallfollowingposts'] = "sEl3cTED 4nD @lL PhoLLOwiN9 pos+5";

$lang['threadhere'] = "h3R3";
$lang['thisthreadhasmoved'] = "<b>tHrE@D5 M3rGEd:</b> +h1\$ +hRe4D h@s mOvED %s";
$lang['thisthreadwasmergedfrom'] = "<b>thr3@D\$ MERgEd:</b> tH1\$ THr34d w45 M3RG3d fRom %s";
$lang['somepostsinthisthreadhavebeenmoved'] = "<b>thr34d \$PLit:</b> \$OM3 POSTS 1N +HiS thrE@D hAVe 833N MOV3d %s";
$lang['somepostsinthisthreadweremovedfrom'] = "<b>tHrE4d SPl1t:</b> 5Om3 POST\$ 1N +hi5 +Hr3@d W3R3 MOV3d FrOM %s";

$lang['threadmergefailed'] = "thrE@D MEr93 F41l3d";
$lang['threadsplitfailed'] = "thR34d sPlI+ F41l3d";

$lang['invalidfunctionarguments'] = "inV@LID PHUNCTIOn @Rgum3nt\$";
$lang['couldnotretrieveforumdata'] = "coULD n0T r3+Ri3VE phOrUm D4T4";
$lang['cannotmergepolls'] = "oN3 oR mOre thre4d5 1\$ 4 p0LL. J00 c4nN0T m3r9E p0ll5";
$lang['couldnotretrievethreaddatamerge'] = "c0uLd NO+ re+r1EVe +HR34D d@+@ From oNe OR m0RE +hRe4d5";
$lang['couldnotretrievethreaddatasplit'] = "cOulD not r3+riEVE +HRe4D d4t@ Fr0m SouRC3 THrE4D";
$lang['couldnotretrievepostdatamerge'] = "c0ULd n0T retri3v3 P0S+ d4t@ fR0M 0ne 0r moR3 +hRE@D\$";
$lang['couldnotretrievepostdatasplit'] = "coUlD no+ r3TrIev3 p0S+ daT4 Fr0m \$0urc3 thRe4d";
$lang['failedtocreatenewthreadformerge'] = "fAIL3D +o cR3a+E N3w thrE@d foR mergE";
$lang['failedtocreatenewthreadforsplit'] = "f41L3D t0 cR34T3 N3w +hRE4d PHOR Spl1T";

// Thread subscriptions

$lang['threadsubscriptions'] = "thRE4d SU8Scr1PT1ons";
$lang['couldnotupdateinterestonthread'] = "cOuld no+ Upd4+3 INT3re5+ 0N +hRe4D '%s'";
$lang['threadinterestsupdatedsuccessfully'] = "tHR3Ad 1Nt3R3stS upD4+3d \$ucce\$SFuLLy";
$lang['resetselected'] = "r35ET sEl3c+3D";
$lang['allthreadtypes'] = "alL ThR34D tYp35";
$lang['ignoredthreads'] = "iGnOrED thr3@d\$";
$lang['highinterestthreads'] = "higH 1n+eR3sT +Hr34d5";
$lang['subscribedthreads'] = "sU85CRib3D thREaDs";
$lang['currentinterest'] = "cURR3n+ 1nTer3\$t";

?>