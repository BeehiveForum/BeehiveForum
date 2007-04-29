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

/* $Id: x-hacker.inc.php,v 1.231 2007-04-29 15:09:52 decoyduck Exp $ */

// International English language file

// Language character set and text direction options -------------------

$lang['_isocode'] = "en";
$lang['_textdir'] = "ltr";

// Months --------------------------------------------------------------

$lang['month'][1]  = "j4nU@RY";
$lang['month'][2]  = "f38rU4ry";
$lang['month'][3]  = "m4RCH";
$lang['month'][4]  = "apR1l";
$lang['month'][5]  = "m@y";
$lang['month'][6]  = "jUNE";
$lang['month'][7]  = "jULY";
$lang['month'][8]  = "aU9U\$+";
$lang['month'][9]  = "s3p+EmB3R";
$lang['month'][10] = "oC+O83r";
$lang['month'][11] = "nov3m8ER";
$lang['month'][12] = "d3Cem83R";

$lang['month_short'][1]  = "j4N";
$lang['month_short'][2]  = "f38";
$lang['month_short'][3]  = "m4R";
$lang['month_short'][4]  = "aPR";
$lang['month_short'][5]  = "mAY";
$lang['month_short'][6]  = "jUn";
$lang['month_short'][7]  = "jUL";
$lang['month_short'][8]  = "aU9";
$lang['month_short'][9]  = "s3p";
$lang['month_short'][10] = "ocT";
$lang['month_short'][11] = "nov";
$lang['month_short'][12] = "dEC";

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

$lang['date_periods']['year']   = "%s YeaR";
$lang['date_periods']['month']  = "%s mONTh";
$lang['date_periods']['week']   = "%s wE3k";
$lang['date_periods']['day']    = "%s d4y";
$lang['date_periods']['hour']   = "%s hOur";
$lang['date_periods']['minute'] = "%s M1NUte";
$lang['date_periods']['second'] = "%s s3cONd";

// As above but plurals (2 years vs. 1 year, etc.)

$lang['date_periods_plural']['year']   = "%s y3@r5";
$lang['date_periods_plural']['month']  = "%s mOn+H\$";
$lang['date_periods_plural']['week']   = "%s WE3K\$";
$lang['date_periods_plural']['day']    = "%s d4Ys";
$lang['date_periods_plural']['hour']   = "%s HouR\$";
$lang['date_periods_plural']['minute'] = "%s M1Nu+e5";
$lang['date_periods_plural']['second'] = "%s \$3COnd5";

// Short hand periods (example: 1y, 2m, 3w, 4d, 5hr, 6min, 7sec)

$lang['date_periods_short']['year']   = "%sY";    // 1y
$lang['date_periods_short']['month']  = "%sm";    // 2m
$lang['date_periods_short']['week']   = "%sw";    // 3w
$lang['date_periods_short']['day']    = "%sd";    // 4d
$lang['date_periods_short']['hour']   = "%sHr";   // 5hr
$lang['date_periods_short']['minute'] = "%sMin";  // 6min
$lang['date_periods_short']['second'] = "%ssEc";  // 7sec

// Common words --------------------------------------------------------

$lang['percent'] = "p3RC3N+";
$lang['average'] = "aVer@Ge";
$lang['approve'] = "aPPRove";
$lang['banned'] = "b@nNEd";
$lang['locked'] = "lock3D";
$lang['add'] = "adD";
$lang['advanced'] = "aDV4Nc3d";
$lang['active'] = "activ3";
$lang['style'] = "sTyl3";
$lang['go'] = "gO";
$lang['folder'] = "fOLd3R";
$lang['ignoredfolder'] = "iGNoR3D folDer";
$lang['folders'] = "f0Ld3R\$";
$lang['thread'] = "thR34D";
$lang['threads'] = "tHre4d5";
$lang['threadlist'] = "thRead l1st";
$lang['message'] = "m3\$S4G3";
$lang['messagenumber'] = "me\$S49E numB3R";
$lang['from'] = "froM";
$lang['to'] = "t0";
$lang['all_caps'] = "aLl";
$lang['of'] = "oPh";
$lang['reply'] = "r3PlY";
$lang['forward'] = "fOrward";
$lang['replyall'] = "r3ply +o @ll";
$lang['pm_reply'] = "rEPLy @5 PM";
$lang['delete'] = "dELE+3";
$lang['deleted'] = "dEL3+ed";
$lang['edit'] = "eDIT";
$lang['privileges'] = "pr1vIL393S";
$lang['ignore'] = "i9n0R3";
$lang['normal'] = "noRmAL";
$lang['interested'] = "iN+3R3\$T3d";
$lang['subscribe'] = "sub\$Cr18e";
$lang['apply'] = "appLY";
$lang['submit'] = "sUBM1+";
$lang['download'] = "d0wnLO4D";
$lang['save'] = "s4VE";
$lang['update'] = "upd4+3";
$lang['cancel'] = "c4NCEL";
$lang['continue'] = "c0NTiNU3";
$lang['attachment'] = "a+TachM3nT";
$lang['attachments'] = "aT+4ChM3N+S";
$lang['imageattachments'] = "iM493 @TtaCHm3n+S";
$lang['filename'] = "f1LEN4Me";
$lang['dimensions'] = "d1MensI0Ns";
$lang['downloadedxtimes'] = "d0WNl04D3D: %d tiMe\$";
$lang['downloadedonetime'] = "dOWNLo4d3D: 1 tim3";
$lang['size'] = "sIzE";
$lang['viewmessage'] = "v13W mEs54gE";
$lang['deletethumbnails'] = "deL3t3 +Hum8n4Il5";
$lang['logon'] = "l0G0n";
$lang['more'] = "m0RE";
$lang['recentvisitors'] = "rEcent viS1t0rs";
$lang['username'] = "usern4m3";
$lang['clear'] = "cL34R";
$lang['action'] = "act10N";
$lang['unknown'] = "unkNown";
$lang['none'] = "n0NE";
$lang['preview'] = "pR3V1Ew";
$lang['post'] = "poS+";
$lang['posts'] = "p0\$t5";
$lang['change'] = "cHanGE";
$lang['yes'] = "y3\$";
$lang['no'] = "n0";
$lang['signature'] = "si9N@tUr3";
$lang['signaturepreview'] = "sIgN4TuRe PR3vi3w";
$lang['signatureupdated'] = "s1gna+URe upD4+ED";
$lang['back'] = "b4CK";
$lang['subject'] = "su8jEct";
$lang['close'] = "cl0se";
$lang['name'] = "nAm3";
$lang['description'] = "d3\$cR1p+10n";
$lang['date'] = "d@t3";
$lang['view'] = "vi3W";
$lang['enterpasswd'] = "ent3R P4SsW0rD";
$lang['passwd'] = "p@\$\$WOrd";
$lang['ignored'] = "iGNoR3d";
$lang['guest'] = "gu3sT";
$lang['next'] = "nEXT";
$lang['prev'] = "pReVIOu5";
$lang['others'] = "o+H3Rs";
$lang['nickname'] = "niCKn4Me";
$lang['emailaddress'] = "em@il 4DdrEs5";
$lang['confirm'] = "c0NF1Rm";
$lang['email'] = "em41l";
$lang['poll'] = "p0ll";
$lang['friend'] = "fRIEnD";
$lang['error'] = "eRror";
$lang['guesterror'] = "s0rRY, J00 N33d +0 B3 LOgGeD iN +0 u\$E thIS FE4+URe.";
$lang['loginnow'] = "l0g1n NOW";
$lang['on'] = "oN";
$lang['unread'] = "unRe4D";
$lang['all'] = "aLl";
$lang['allcaps'] = "alL";
$lang['permissions'] = "peRMI5\$ion5";
$lang['type'] = "tyPe";
$lang['print'] = "pr1N+";
$lang['sticky'] = "sTicKY";
$lang['polls'] = "p0LlS";
$lang['user'] = "usEr";
$lang['enabled'] = "eN48l3d";
$lang['disabled'] = "diS48LEd";
$lang['options'] = "opT1OnS";
$lang['emoticons'] = "eMo+1CoN\$";
$lang['webtag'] = "wE8+Ag";
$lang['makedefault'] = "m@kE Def4ul+";
$lang['unsetdefault'] = "uN5et d3FaUlT";
$lang['rename'] = "r3N4mE";
$lang['pages'] = "p@GES";
$lang['used'] = "u5ed";
$lang['days'] = "d4YS";
$lang['usage'] = "us4Ge";
$lang['show'] = "shOW";
$lang['hint'] = "h1N+";
$lang['new'] = "nEW";
$lang['referer'] = "rePH3R3r";

// Admin interface (admin*.php) ----------------------------------------

$lang['admintools'] = "adM1N TO0l\$";
$lang['forummanagement'] = "foRum m4N4gemeNt";
$lang['accessdeniedexp'] = "j00 D0 NO+ h4V3 PErmISS1On T0 U\$E thI5 seC+I0N.";
$lang['managefolders'] = "m4N4Ge pH0Ld3rS";
$lang['manageforums'] = "m4N4GE ph0rUM\$";
$lang['manageforumpermissions'] = "m4N49E pH0RuM P3RmIS\$10nS";
$lang['foldername'] = "f0LD3r nAm3";
$lang['move'] = "mOV3";
$lang['closed'] = "clos3d";
$lang['open'] = "open";
$lang['restricted'] = "res+RICted";
$lang['iscurrentlyclosed'] = "i5 CURr3N+Ly CL05ed";
$lang['youdonothaveaccessto'] = "j00 d0 nOT h@v3 @Cc3\$s T0";
$lang['toapplyforaccessplease'] = "tO @PPlY PHoR AccesS pL3@SE C0nT4C+ Th3 FoRuM OwNER.";
$lang['adminforumclosedtip'] = "iPh j00 w4N+ +O Ch4n93 \$ome S3+t1n9S 0N yOuR phORum clIck t3H AdMIn LiNk 1N +h3 n4ViG@T1ON b4r 4b0vE.";
$lang['newfolder'] = "n3W F0ld3r";
$lang['forumadmin'] = "foRUM 4dmiN";
$lang['adminexp_1'] = "uS3 +Eh m3NU On tH3 lEft +0 m@na9E Th1n9\$ 1N y0Ur Ph0ruM.";
$lang['adminexp_2'] = "<b>useRs</b> 4ll0WS j00 t0 seT 1Nd1V1DU4L USEr peRmi55ION\$, 1NcLUd1NG 4pp01N+InG ed1t0RS 4Nd G49gIng peOPL3.";
$lang['adminexp_3'] = "<b>u5ER 9ROuP5</b> 4LlowS J00 to cr34t3 U5eR 9ROUpS +0 @5S19N p3Rmi5S10Ns to 4\$ M@nY 0r a\$ pHew uSERs qU1cKLY 4Nd e4\$iLy.";
$lang['adminexp_4'] = "<b>baN C0N+r0L5</b> @LL0w\$ THe B4nn1N9 4ND uN-B4NN1NG 0PH ip @ddR3sS3\$, u\$eRn@mE\$, em41L 4Ddr3ssES 4ND NiCKn4mES.";
$lang['adminexp_5'] = "<b>f0lD3rS</b> 4lL0W5 t3H Cre4T10n, m0DipHIc@+10N 4Nd dEL3T1oN 0ph F0LderS.";
$lang['adminexp_6'] = "<b>r\$S pheEDS</b> @lL0w\$ j00 +o cRE4+e 4Nd reMOVe r5S PHeEDS pH0R PRoPOG@T1oN inTo YoUr ph0RuM.";
$lang['adminexp_7'] = "<b>pR0FIlES</b> L3t5 j00 cUst0Mi\$E +he 1T3M\$ tHa+ @ppe4R 1N +hE u\$3R pROFilE\$.";
$lang['adminexp_8'] = "<b>f0RuM \$eT+InG\$</b> 4ll0w5 j00 +0 cUS+0m1sE y0uR FOrUM'\$ n@m3, 4Pp34R@ncE ANd m4ny 0TH3r +h1N9S.";
$lang['adminexp_9'] = "<b>sT4r+ p@Ge</b> Let\$ J00 cU\$tOm1sE Y0uR PH0rUM'5 st4r+ pa9E.";
$lang['adminexp_10'] = "<b>f0ruM S+yLe</b> @ll0W\$ j00 T0 cr34T3 STyLes foR YOur Ph0rUm MEm8ErS T0 U5E.";
$lang['adminexp_11'] = "<b>w0RD fil+3r</b> @Llow5 J00 t0 FiL+3r WoRD\$ J00 doN't W@Nt +0 b3 u\$3D 0n yoUr FoRuM.";
$lang['adminexp_12'] = "<b>p0st1N9 \$t@T5</b> 9ENEr4T3\$ 4 REp0r+ l15T1N9 +3H +0P 10 Po\$+3r\$ 1n 4 dEpHIN3D P3RI0d.";
$lang['adminexp_13'] = "<b>fORUm linkS</b> l3t5 J00 M4n@gE +H3 l1NKS dr0PdoWN iN tH3 NAv1g@T10n b4r.";
$lang['adminexp_14'] = "<b>vi3W l0g</b> L15Ts R3cENT 4c+i0N5 8y +hE PH0rUM mod3r4T0r\$.";
$lang['adminexp_15'] = "<b>m@n4Ge pH0ruM5</b> L3t\$ J00 CRe4+E 4Nd D3L3t3 4nd cl0\$e OR r3OpEn PH0rUMS.";
$lang['adminexp_16'] = "<b>gLo84L fOrUm Se+TiNG\$</b> @llOW5 j00 +o mOdIfY 5EtT1N9S WhiCH 4fPHEcT 4Ll f0rUmS.";
$lang['adminexp_17'] = "<b>p0\$+ @pPRoV4l QUeuE</b> AlLoWS J00 T0 v1Ew 4NY PO\$+S 4W@It1Ng 4ppRoV@L 8y a MoDerA+or.";
$lang['adminexp_18'] = "<b>vi5Itor lO9</b> 4LlOwS J00 +O v13w @N EXt3nd3d L1ST of V1SIt0R\$ iNcluDING TheIr ht+p r3FEREr\$.";
$lang['createforumstyle'] = "cr3@t3 A phORum 5TYle";
$lang['newstylesuccessfullycreated'] = "nEw S+Yle %s SUcC3sSPhuLly crE4+ed.";
$lang['stylealreadyexists'] = "a \$+ylE wI+h thaT ph1leN@ME 4lR34dy eX1STs.";
$lang['stylenofilename'] = "j00 diD N0+ ent3R @ f1lEN4me to S4ve t3H \$TYl3 Wi+h.";
$lang['stylenodatasubmitted'] = "c0uLD NoT RE@D fOrUm \$tyl3 D@t4.";
$lang['styleexp'] = "use tH1\$ P4ge T0 H3Lp Cr34+3 @ rANdOMly genEr4+Ed \$TyLe PhOR y0ur phORuM.";
$lang['stylecontrols'] = "c0N+r0l\$";
$lang['stylecolourexp'] = "click 0n 4 c0lOur To m4Ke 4 neW STyle sh3ET 8@5ED on +H4+ C0lOUr. CURrEN+ 8@53 coL0uR 15 f1R5t 1N l15T.";
$lang['standardstyle'] = "s+and4rd 5TYl3";
$lang['rotelementstyle'] = "ro+4t3D eLEMEnt \$TYLE";
$lang['randstyle'] = "r@nDoM \$TYL3";
$lang['thiscolour'] = "th1S C0L0Ur";
$lang['enterhexcolour'] = "or ENTER a hEx coLouR TO 845E A n3w \$+yLe SHeE+ 0N";
$lang['savestyle'] = "s4V3 +H1S s+Yle";
$lang['styledesc'] = "styLE D3\$crIp+1ON";
$lang['fileallowedchars'] = "(lOwErC4Se l3+Ters (4-z), nUmb3R\$ (0-9) 4nd UnDErsc0ReS (_) 0NlY)";
$lang['stylepreview'] = "sTyl3 pREv13w";
$lang['welcome'] = "wELCoME";
$lang['messagepreview'] = "me5S493 PR3V13w";
$lang['users'] = "u53r\$";
$lang['usergroups'] = "u53r 9roup\$";
$lang['mustentergroupname'] = "j00 MUS+ eN+ER 4 Gr0Up N4Me";
$lang['profiles'] = "pROF1L35";
$lang['manageforums'] = "m4N@9e ph0RuM5";
$lang['forumsettings'] = "f0rum \$ettINgS";
$lang['globalforumsettings'] = "gLoBaL PHOrUM \$3+tinGs";
$lang['settingsaffectallforumswarning'] = "<b>not3:</b> TheSe SEtTiNGs @phPhEc+ 4LL PH0rum5. wH3re Th3 5et+Ing 15 DUpL1C4t3D On +eH 1ndIV1du@l forUm's \$e++1NGS p493 TH@T w1ll +aKE pr3ceD3NCe 0V3R +eH 53+tiN9s J00 ChaN93 h3r3.";
$lang['startpage'] = "sTARt P493";
$lang['startpageerror'] = "yOur \$t@Rt P4Ge C0uLD no+ b3 \$4Ved Loc@LLY To ThE \$eRv3R 83C@U\$e p3rmIS\$1on WA\$ deNi3D. +O cH4NgE YoUR \$+@rT p4Ge pL3@sE CL1cK t3H DOwnLo4d bU++0N b3l0w WH1ch W1Ll pr0mP+ j00 t0 S4Ve +eH ph1lE +0 YOUr h4Rd dR1VE. j00 C4N +H3N upLOAd tHIS PHiLE TO yOUR \$3Rv3r IN+o %s FOLDeR, iF NeC3ss@Ry cR34+1N9 +eh FoLd3R \$+Ruc+UR3 IN +HE pR0CESS. pl34\$e NO+e +H4+ 5OM3 bR0WSeR\$ M@Y Ch4n9e +eH n4m3 0F tHE ph1l3 Up0N d0WNl0@d.  WH3N UPLO@d1nG The pH1Le ple4\$3 M4ke sure +H@T It is n@m3d star+_Ma1N.Php oThErW15E Y0UR St4r+ P49E WILL 4ppe@R UNcH4Ng3d.";
$lang['failedtoopenmasterstylesheet'] = "y0UR pHoRum S+Yl3 couLd N0t 83 \$4vED b3c4U5e +EH m4\$T3R 5tYlE ShEEt C0UlD n0+ 83 lo@DeD. tO 54vE YOUr STYle th3 M4\$TeR STyLe \$hE3t (m4k3_StyL3.C\$\$) mU5t b3 L0c4+Ed 1N +h3 \$+yLeS d1rectOrY Of yOuR b33hiv3 ph0ruM 1n\$t@LL4+1ON.";
$lang['makestyleerror'] = "yOUR phORuM StyL3 couLd No+ 8E S4Ved Loc@LLy +0 +H3 SeRv3r 8EC4U53 P3RmI5\$10n w45 DENI3d. +O 54VE YOur fORuM 5TYl3 Pl34Se clicK Th3 D0wNL0@D BUt+On 8elOw Wh1ch w1Ll Pr0Mp+ J00 TO \$4v3 thE F1LE +0 yOur h4Rd drIvE. J00 c@N +HEN UPl0@D +H1\$ f1L3 +0 yOUR S3RvEr 1N+0 %s phOLDeR, If nECe\$S4rY cR3@t1n9 +HE PH0lDER S+rUC+UR3 in thE Pr0C3S5. J00 sHOULD NO+E +HaT 5Ome br0WS3Rs MaY cH@N93 TH3 n@M3 0f TH3 F1LE UP0N dowNl04d. wH3N uPLo4dInG T3H f1LE plE4\$e M4k3 \$uRE +h@T 1t IS N@M3D sTYL3.c\$5 OtH3rw1SE tHe F0rUm STyL3 W1Ll B3 UnUSA8lE.";
$lang['uploadfailed'] = "yOUR N3w s+4r+ p493 C0Uld n0t 83 UPlO@d3D +0 T3h s3Rv3R 83c4U5E PERm1S5I0n w@\$ D3NieD. pLe@SE Ch3cK tH4+ +eh w3B S3rV3r / PhP PR0C3S\$ i\$ 48LE +0 WR1+E +O TH3 %s phold3R 0n y0ur 5erVer.";
$lang['makestylefailed'] = "y0Ur N3W PhORUm StYl3 cOUld N0t 8E S4V3d +0 +Eh 53rvEr 83C@USE PERMisS1oN w45 deN1ed. Pl3aS3 CHEcK TH@+ TH3 WEB \$eRV3R / pHP Pr0c3\$S 1s @8l3 tO WRI+E t0 +3h %s pH0lD3R oN y0uR \$eRv3r.";
$lang['forumstyle'] = "f0RUm \$+YLE";
$lang['wordfilter'] = "w0rd pHiL+3r";
$lang['forumlinks'] = "fORUM l1nk\$";
$lang['viewlog'] = "v1ew LOG";
$lang['noprofilesectionspecified'] = "n0 pr0Ph1Le s3c+1On \$pECIf1ED.";
$lang['itemname'] = "item N@m3";
$lang['moveto'] = "moV3 +O";
$lang['manageprofilesections'] = "m4N@9e prOPHilE \$3c+I0N5";
$lang['sectionname'] = "sEc+I0n N@me";
$lang['items'] = "i+Em\$";
$lang['mustspecifyaprofilesectionid'] = "mU\$+ \$p3C1phY 4 pr0pHIlE SeC+1on 1D";
$lang['mustsepecifyaprofilesectionname'] = "mu\$t sP3CiFy 4 pRoF1LE SEcT10N n@M3";
$lang['successfullyeditedprofilesection'] = "sucCE\$sFUlLy ediT3D PrOph1Le SEC+IOn";
$lang['addnewprofilesection'] = "add NEw prOPHil3 SEct10N";
$lang['mustsepecifyaprofilesectionname'] = "muST sPec1FY 4 PrOpHIle \$ectI0N N@mE";
$lang['successfullyremovedselectedprofilesections'] = "sUcC3s\$FULLy r3M0vEd seL3Ct3d pr0FiLe sEct1On\$";
$lang['failedtoremoveprofilesections'] = "fa1LEd T0 r3m0v3 Pr0PhIlE secTi0n\$";
$lang['viewitems'] = "vI3W 1temS";
$lang['successfullyremovedselectedprofileitems'] = "succeSSfULlY R3MOVed SEl3c+Ed PrOpHIlE 1T3mS";
$lang['failedtoremoveprofileitems'] = "f@IlED +0 rEM0vE Pr0pHiLe 1+3MS";
$lang['noexistingprofileitemsfound'] = "tH3RE 4RE nO 3X1s+IN9 pR0File 1tEm\$ iN thIS \$ec+10n. t0 4DD @ PRoPhiL3 1T3M cL1Ck +H3 BUTt0n 83lOW.";
$lang['edititem'] = "eDIT 1t3m";
$lang['invaliditemidoritemnotfound'] = "iNV4L1d 1T3M 1d 0R 1+eM NO+ Ph0UnD";
$lang['addnewitem'] = "adD n3W 1t3M";
$lang['startpageupdated'] = "s+@rT p4g3 upD4T3D";
$lang['viewupdatedstartpage'] = "vIew upd@T3D \$+4rt P49E";
$lang['editstartpage'] = "eDi+ \$t4r+ Pa93";
$lang['nouserspecified'] = "nO Us3r spec1F1ed.";
$lang['manageuser'] = "m4n4ge u53R";
$lang['manageusers'] = "m@N4g3 U5ER\$";
$lang['userstatus'] = "u\$3R \$T@+u5 (CUrReN+ FoRuM)";
$lang['userdetails'] = "u53r d3+41LS";
$lang['warning_caps'] = "w@RN1n9";
$lang['userdeleteallpostswarning'] = "ar3 J00 \$urE J00 w4NT t0 D3L3+E 4Ll OF t3h S3L3ctEd uSEr'S P0st\$? 0nce +eh P0st\$ 4R3 dELe+ED +HEy c4nnO+ b3 Re+r13V3D aNd W1LL 83 LOS+ Ph0r3VeR.";
$lang['postssuccessfullydeleted'] = "po5+\$ W3R3 \$uccE\$sFUlLY D3Le+Ed.";
$lang['folderaccess'] = "foLd3r @Cc3SS";
$lang['possiblealiases'] = "p0\$si8L3 4liA5e\$";
$lang['userhistory'] = "uSeR hiS+0ry";
$lang['nohistory'] = "no hi\$tory r3C0rDS S4vEd";
$lang['userhistorychanges'] = "cH@N93S";
$lang['clearuserhistory'] = "clE4r US3r H1\$TOrY";
$lang['changedlogonfromto'] = "ch4ng3D lO9On frOM %s TO %s";
$lang['changednicknamefromto'] = "ch@NGeD NIcKn4Me fRoM %s To %s";
$lang['changedemailfromto'] = "ch@N93D EMa1l frOM %s To %s";
$lang['usersettingsupdated'] = "u53R s3Tt1NGS \$uCc3S\$PHULlY UPd@t3d";
$lang['nomatches'] = "n0 M4TcHeS";
$lang['deleteposts'] = "deLe+e Po\$Ts";
$lang['deleteallusersposts'] = "delE+e 4LL 0F THiS uS3R'S poST\$";
$lang['noattachmentsforuser'] = "nO @T+4cHm3n+s fOR +H1s u\$3R";
$lang['forgottenpassworddesc'] = "if +HI\$ U\$Er H4\$ f0rgO+t3N ThE1R P4\$\$woRd j00 C4N rese+ 1T FOR +hEM H3re.";
$lang['manageusersexp'] = "thIS Li5T \$hoWS 4 SeL3c+10N Oph U\$ErS WH0 h@vE log9ED on +O your ph0RUm, \$OrT3d By %s. TO @L+3R 4 U\$eR's p3rm1SS10n\$ CLicK Th31r n4M3.";
$lang['userfilter'] = "u53r f1Lter";
$lang['onlineusers'] = "onl1NE u\$3r5";
$lang['offlineusers'] = "oPHfLiN3 U\$3R\$";
$lang['usersawaitingapproval'] = "useRS @w41TInG 4PpROV@l";
$lang['bannedusers'] = "b4NN3d uS3R5";
$lang['lastlogon'] = "l4\$+ LOgoN";
$lang['sessionreferer'] = "ses5i0N r3f3rEr";
$lang['signupreferer'] = "s1Gn-UP ReF3r3r:";
$lang['nouseraccounts'] = "no U53r 4CcoUn+s in D4t@B4\$e.";
$lang['nouseraccountsmatchingfilter'] = "n0 U\$er 4CcOUN+5 M4tCHinG phiL+ER";
$lang['searchforusernotinlist'] = "s34RCh fOR 4 US3R nO+ In l1S+";
$lang['adminaccesslog'] = "aDMIn 4cCEss LO9";
$lang['adminlogexp'] = "tH1s l1sT shOW5 teH L4St @C+1oN\$ \$4ncT1On3d 8Y U\$erS w1Th 4dMIN pR1Vil39es.";
$lang['datetime'] = "d4+3/TIme";
$lang['unknownuser'] = "uNkN0Wn U\$3r";
$lang['unknownfolder'] = "unknOwN pH0LdeR";
$lang['ip'] = "iP";
$lang['lastipaddress'] = "l@S+ iP 4Ddre\$5";
$lang['logged'] = "l0g93d";
$lang['notlogged'] = "noT loGGEd";
$lang['addwordfilter'] = "add w0Rd PhiLT3r";
$lang['addnewwordfilter'] = "aDD nEW W0rd F1LT3R";
$lang['wordfilterupdated'] = "w0Rd PHIl+eR UpD4+3D";
$lang['filtertype'] = "f1L+3R tyP3";
$lang['editwordfilter'] = "eD1+ WORd f1l+3r";
$lang['nowordfilterentriesfound'] = "n0 3XiST1n9 Word f1LTEr ENtRies f0UnD. +O 4dd 4 WORD phil+er cLICk Teh 8u+t0n 83L0w.";
$lang['mustspecifymatchedtext'] = "j00 mU\$T \$P3C1fY M4tcH3D +3xT";
$lang['mustspecifyfilteroption'] = "j00 Must sP3C1fY 4 f1l+er OptI0N";
$lang['mustspecifyfilterid'] = "j00 Mus+ sp3C1phY A PHiLt3R Id";
$lang['invalidfilterid'] = "iNv4lId pHilter ID";
$lang['failedtoupdatewordfilter'] = "f@ilED +o Upd4T3 W0RD F1LTEr. cH3ck +H4+ The PhIltEr \$TIll 3X15TS.";
$lang['allow'] = "alL0w";
$lang['normalthreadsonly'] = "noRM4L +Hr34DS ONlY";
$lang['pollthreadsonly'] = "polL thrE4D\$ 0nlY";
$lang['both'] = "bOth +hre4d TYp3\$";
$lang['existingpermissions'] = "eXIsT1N9 p3Rm1\$510Ns";
$lang['nousers'] = "n0 U5Er5";
$lang['searchforuser'] = "s3@rCH pH0r u\$3R";
$lang['browsernegotiation'] = "broWS3r N390+1@TeD";
$lang['largetextfield'] = "l4r9E +ex+ pH1eld";
$lang['mediumtextfield'] = "m3d1UM teXt fI3ld";
$lang['smalltextfield'] = "sM4Ll t3xt PHIelD";
$lang['multilinetextfield'] = "muL+1-l1Ne +eXT ph1ElD";
$lang['radiobuttons'] = "r@dIO 8UTtONS";
$lang['dropdown'] = "drOP doWN";
$lang['threadcount'] = "thR34D c0UNt";
$lang['fieldtypeexample1'] = "f0R R4DiO 8U+TONs 4nD DroP D0WN PhI3Ld5 J00 N3Ed +0 5ePaRAt3 +h3 PHIelDN@M3 4Nd +3H v4lU35 with 4 c0LON 4nD 3aCh v@LUe sH0Uld 8E sEp4r4TED By S3mi-C0LoN\$.";
$lang['fieldtypeexample2'] = "eX4MpLE: TO cre@+3 4 b@\$1C GENd3r R4Di0 BuT+0ns, w1+H +W0 S3LeCTi0n\$ pH0R M4l3 4nD pH3M4l3, J00 wOULd 3N+ER: <b>geND3R:MAl3;Ph3m4LE</b> 1N th3 1T3M n4ME pHi3LD.";
$lang['editedwordfilter'] = "ed1+eD WOrD Phil+Er";
$lang['editedforumsettings'] = "eD1+eD f0rUm SeTtiNGS";
$lang['sessionsuccessfullyended'] = "sUcc3s\$FulLy 3nd3D 5e5\$10nS Ph0r sEl3cted u\$3r5";
$lang['matchedtext'] = "m4+Ch3D +3xT";
$lang['replacementtext'] = "r3pl@c3m3Nt +3Xt";
$lang['preg'] = "prE9";
$lang['wholeword'] = "wH0L3 w0Rd";
$lang['word_filter_help_1'] = "<b>aLl</b> M@+cH3\$ 494InS+ +H3 WHoLe tEX+ sO f1l+ER1Ng mOM +0 muM WIlL @lSO ch4N9e M0m3nT tO MUm3NT.";
$lang['word_filter_help_2'] = "<b>wHOle W0rD</b> M@tch3\$ 4g@1Ns+ WhoL3 W0RD5 0nly \$o F1lTerInG Mom tO MUM w1Ll N0+ CH4Ng3 mOMenT +O MUmen+.";
$lang['word_filter_help_3'] = "<b>pR39</b> @LlOws J00 +0 uSE P3Rl REGUlaR 3XPr3\$SION\$ TO m4+cH +eX+.";
$lang['nameanddesc'] = "n4ME @Nd D3\$crIPT1ON";
$lang['movethreads'] = "m0ve +Hre@DS";
$lang['threadsmovedsuccessfully'] = "thr34D5 mOvED SuCCe\$SphULLY";
$lang['movethreadstofolder'] = "moVe tHr3@ds +0 pH0LDEr";
$lang['resetuserpermissions'] = "reseT U\$3r P3RmIsS10n5";
$lang['userpermissionsresetsuccessfully'] = "uS3r PERm1\$S10n5 RESEt \$UCc355phUlLY";
$lang['allowfoldertocontain'] = "alLOW PH0LdeR T0 c0n+41n";
$lang['addnewfolder'] = "add n3w foldER";
$lang['mustenterfoldername'] = "j00 MU5+ eNt3r 4 FOlD3R nAmE";
$lang['nofolderidspecified'] = "no FoldER 1d \$p3CIf13d";
$lang['invalidfolderid'] = "iNv4l1D FOLD3r id. cheCk th4t 4 Ph0LDEr w1+h This ID 3xi5ts!";
$lang['successfullyaddedfolder'] = "sUCC3SSFUlLy @dDED FoldER";
$lang['successfullydeletedfolder'] = "succESSpHULly deLEt3D fOLd3r";
$lang['failedtodeletefolder'] = "f41LEd +0 deLeT3 ph0ld3R.";
$lang['folderupdatedsuccessfully'] = "foLdEr upD4+Ed \$uCC355pHuLLy";
$lang['cannotdeletefolderwiththreads'] = "cAnNoT D3L3+E ph0LdErS TH@+ STilL cOn+4iN THr3aD5.";
$lang['forumisnotrestricted'] = "forUm Is nO+ re\$+R1Ct3D";
$lang['groups'] = "gRoUps";
$lang['nousergroups'] = "nO USeR 9r0uPs h@Ve 8e3n \$et Up";
$lang['suppliedgidisnotausergroup'] = "supPlI3d Gid 1s no+ 4 User 9rOUP";
$lang['manageusergroups'] = "m4N49e U\$ER gR0UpS";
$lang['groupstatus'] = "grOUp 5+4+U5";
$lang['addusergroup'] = "aDd 9r0uP";
$lang['addremoveusers'] = "aDd/rEm0v3 u\$3rS";
$lang['nousersingroup'] = "tHeRE 4Re No U5Er5 1N Th1s Gr0up";
$lang['useringroups'] = "th1\$ u5Er 15 4 m3mber of T3h PH0ll0winG 9r0UpS";
$lang['usernotinanygroups'] = "th1s uS3r 1S NO+ In 4Ny USer GRoUpS";
$lang['usergroupwarning'] = "n0+e: +hI\$ us3r m4Y b3 inH3RiT1Ng 4dD1tI0n@L peRMI5sI0N\$ Fr0m 4nY UseR GRoUpS liST3D 8eLOW.";
$lang['successfullyaddedgroup'] = "sucC3\$\$fUlLy 4Dd3d 9R0Up";
$lang['successfullydeletedgroup'] = "sUCceS5phUlly D3l3t3D 9RoUP";
$lang['usercanaccessforumtools'] = "uS3R caN 4cc3\$S fOrUM tO0LS 4nD CAn Cr3@+E, D3l3Te 4Nd eD1T Ph0RuM5";
$lang['usercanmodallfoldersonallforums'] = "u\$er c4n M0D3r4T3 <b>aLL fOLd3r5</b> 0N <b>aLL FoRUm\$</b>";
$lang['usercanmodlinkssectiononallforums'] = "uSER C4N MOd3r@T3 l1nKS \$EC+10n on <b>alL f0RUm\$</b>";
$lang['emailconfirmationrequired'] = "em41L c0Nf1rm4+1oN R3Qu1Red";
$lang['userisbannedfromallforums'] = "u53r 1\$ 8aNNED FR0m <b>all FORuMS</b>";
$lang['cancelemailconfirmation'] = "c4NceL eM41L cOnF1Rm4+i0n 4Nd 4lLoW USeR T0 \$t@rt P0stin9";
$lang['resendconfirmationemail'] = "r3s3nD C0nF1Rm4T10N em4iL tO uSer";
$lang['donothing'] = "d0 n0+H1N9";
$lang['usercanaccessadmintools'] = "useR H4\$ @Cc3ss +0 forUM @dm1N +o0L\$";
$lang['usercanaccessadmintoolsonallforums'] = "us3R hA5 Acc35S t0 4DMiN t00l\$ <b>on 4ll PH0rum5</b>";
$lang['usercanmoderateallfolders'] = "usEr C4N moD3rA+E @ll PHOld3rS";
$lang['usercanmoderatelinkssection'] = "usEr C@n mOd3R4+3 LInK5 \$3ctIoN";
$lang['userisbanned'] = "uS3r is BANN3D";
$lang['useriswormed'] = "u53r 15 w0RM3d";
$lang['userispilloried'] = "u5Er I5 PIllor1ED";
$lang['usercanignoreadmin'] = "usEr C4N 19nOr3 4dm1n1\$+r@T0rs";
$lang['groupcanaccessadmintools'] = "gr0uP c4n @ccESS 4DMIn +O0L5";
$lang['groupcanmoderateallfolders'] = "gRoUP c@n m0d3R4+3 4lL fOLd3rs";
$lang['groupcanmoderatelinkssection'] = "group c4n MoD3R@T3 l1nks \$3CTI0Ns";
$lang['groupisbanned'] = "gROUp 1S b4nNed";
$lang['groupiswormed'] = "gr0Up 1s WormEd";
$lang['readposts'] = "re4D Po\$+s";
$lang['replytothreads'] = "r3pLY TO +HR3@d5";
$lang['createnewthreads'] = "cR34+e N3W ThrE4ds";
$lang['editposts'] = "edI+ p0S+S";
$lang['deleteposts'] = "delE+3 p0STs";
$lang['uploadattachments'] = "uPlo4d 4TT4cHM3nT\$";
$lang['moderatefolder'] = "m0Der4Te Ph0ldER";
$lang['postinhtml'] = "p05t 1N htmL";
$lang['postasignature'] = "p0S+ 4 \$I9n4+uRe";
$lang['editforumlinks'] = "edI+ PhORum linkS";
$lang['editforumlinks_exp'] = "u5E +hiS P493 +O ADD L1NkS +o The Dr0p-D0WN l15t D1\$pL4yeD in t3H +0P-RI9Ht 0F the phOruM fr@m3s3T. iph n0 LINK\$ 4re S3+, +he dRoP-DowN l1\$+ w1Ll n0+ BE d1\$Pl4YED.";
$lang['notoplevellinktitlespecified'] = "n0 t0p leV3L LiNK T1tlE SP3CiPh1eD";
$lang['toplinktitlesuccessfullyupdated'] = "t0P l3vEL l1Nk t1+L3 SUCC3\$SPhulLY upd4ted";
$lang['youmustenteralinktitle'] = "j00 mu\$t 3N+3r 4 lINk +1+l3";
$lang['alllinkurismuststartwithaschema'] = "alL link URIs mUst \$+4R+ with 4 \$Chem@ (1.3. H+Tp://, Ph+p://, irC://)";
$lang['noexistingforumlinksfound'] = "th3R3 4r3 n0 EXisTInG ph0rUM l1nKS. +o 4DD @ FORuM L1NK clIck +EH 8u++ON belOW.";
$lang['editlink'] = "eD1+ lINK";
$lang['addnewforumlink'] = "aDD n3w pH0RUm linK";
$lang['forumlinktitle'] = "f0rum L1Nk +1+l3";
$lang['forumlinklocation'] = "f0RUm L1NK l0C@TIon";
$lang['successfullyaddedlink'] = "suCcEssPHULlY 4DDed l1nK: '%s'";
$lang['successfullyeditedlink'] = "sUCC3ssfully EDi+eD l1nk: '%s'";
$lang['invalidlinkidorlinknotfound'] = "inVal1D L1nK iD 0r LiNK noT pHOuNd";
$lang['successfullyremovedselectedlinks'] = "suCC3SSfuLLY rEm0ved Sel3CT3D LinKS";
$lang['failedtoremovelinks'] = "f4il3d +O r3Mov3 \$3Lect3d l1Nks";
$lang['failedtoaddnewlink'] = "f4ILED T0 @DD nEW LiNk: '%s'";
$lang['failedtoupdatelink'] = "f4IlED TO upDa+3 L1nK: '%s'";
$lang['toplinkcaption'] = "t0P LiNk C@p+I0N";
$lang['allowguestaccess'] = "aLlOW 9u3St 4CCe\$5";
$lang['searchenginespidering'] = "s3ArcH en91n3 \$p1D3RiNg";
$lang['allowsearchenginespidering'] = "allOw \$e@rCH EN9In3 5P1d3RiN9";
$lang['newuserregistrations'] = "neW US3R R3G1STr@+i0nS";
$lang['preventduplicateemailaddresses'] = "prEv3NT DUPlIc4T3 3M4iL 4ddR3\$\$E\$";
$lang['allownewuserregistrations'] = "aLLOW NeW u\$er R3G1Str@+1ons";
$lang['requireemailconfirmation'] = "r3QU1R3 EMaIl CoNFiRm@+I0N";
$lang['usetextcaptcha'] = "us3 t3xT-C@ptCh4";
$lang['textcaptchadir'] = "tExt-C4p+CH@ d1ReC+OrY";
$lang['textcaptchakey'] = "t3xt-c4PTch4 k3y";
$lang['textcaptchafonterror'] = "teXt-C4ptcH4 h4\$ b33n DIS48leD autom4t1c4Lly 83c4usE ThERe aRe no Tru3 TYP3 Ph0N+5 4v41l@Bl3 F0r IT T0 U\$3. pL345E UPl0ad \$0ME +Rue TyP3 FON+S to <b>%s</b> 0N Y0Ur SERv3r.";
$lang['textcaptchadirerror'] = "t3x+-C4p+Ch@ h4S b33n diS4Bl3D b3c@usE THe +ExT_C4p+ch@ DirECt0Ry 4nD 1t'5 \$UB-D1r3c+0R13S @re no+ WrIT48lE 8Y +h3 W38 \$eRv3r / Php PrOcES5.";
$lang['textcaptchagderror'] = "teX+-C@PTCh4 h@S B33n D1s48l3D 8eC4u53 Y0uR 5ErvEr's pHP \$3+uP dOE5 No+ prOVid3 \$UpPor+ ph0r 9D Im@G3 M@NipuL4T10n @nd / or ttpH FoN+ suPP0r+. 8O+H 4R3 r3Qu1R3D For t3x+-C4PTCH4 SuPP0R+.";
$lang['textcaptchadirblank'] = "tEx+-C4PTch4 dirEct0Ry IS BL@nk!";
$lang['newuserpreferences'] = "neW u53R pR3PheR3nc3S";
$lang['sendemailnotificationonreply'] = "eM@Il noTIpH1C@t10n 0N r3PlY tO uS3R";
$lang['sendemailnotificationonpm'] = "em41l nOt1PHic@+10N 0N PM TO USeR";
$lang['showpopuponnewpm'] = "show POPuP wHen R3cEIv1ng nEW Pm";
$lang['setautomatichighinterestonpost'] = "set 4UtOM4t1c HiGH 1n+eR3\$t 0n p05t";
$lang['top20postersforperiod'] = "t0p 20 PoS+Er\$ fOR peRi0d %s +O %s";
$lang['postingstats'] = "p0stiN9 s+4+s";
$lang['nodata'] = "n0 d@+4";
$lang['totalposts'] = "tot4L P0stS";
$lang['totalpostsforthisperiod'] = "t0t@l PoStS FOr THIS P3ri0d";
$lang['mustchooseastartday'] = "mu5T ch0053 4 st4R+ D@y";
$lang['mustchooseastartmonth'] = "mU\$+ Ch005e 4 St4R+ MONtH";
$lang['mustchooseastartyear'] = "mu5t ChO0SE 4 S+4r+ ye4R";
$lang['mustchooseaendday'] = "mu\$t Cho0Se 4 ENd D4Y";
$lang['mustchooseaendmonth'] = "mus+ cHO0SE @ 3ND MoNTh";
$lang['mustchooseaendyear'] = "mU5T ChO0S3 a ENd Y34R";
$lang['startperiodisaheadofendperiod'] = "st4r+ P3r10D IS @HE4D Oph 3nd PERioD";
$lang['bancontrols'] = "bAn c0n+rOL\$";
$lang['addban'] = "aDd ban";
$lang['checkban'] = "cH3cK b@N";
$lang['editban'] = "eDI+ b@N";
$lang['bantype'] = "b@n +yP3";
$lang['bandata'] = "b@N d@+4";
$lang['bancomment'] = "cOmm3nt";
$lang['ipban'] = "iP B@n";
$lang['logonban'] = "lo90N B4N";
$lang['nicknameban'] = "n1CkN4m3 84N";
$lang['emailban'] = "eM4il 8@N";
$lang['refererban'] = "r3pH3rER 8An";
$lang['invalidbanid'] = "iNv@L1D 8@n 1D";
$lang['affectsessionwarnadd'] = "thi\$ b4N m4Y aphPHEct The pHoLl0wIN9 aCTiVe USEr \$E5SIONS";
$lang['noaffectsessionwarn'] = "tHIS 84n 4FPHecT\$ N0 @c+IvE S3S\$1oNS";
$lang['mustspecifybantype'] = "j00 mUS+ 5P3ciFy 4 b4N +YPE";
$lang['mustspecifybandata'] = "j00 mU\$t \$p3ciFY \$om3 84N D4T4";
$lang['successfullyremovedselectedbans'] = "sUcC3sSPhUlLY rEmOveD \$3L3cT3D 84n\$";
$lang['failedtoaddnewban'] = "f@IL3D T0 4Dd neW 84N";
$lang['failedtoremovebans'] = "fA1L3D +o REm0vE S0M3 0r @lL oPh th3 SeL3C+Ed 8@NS";
$lang['duplicatebandataentered'] = "dUPLiC@T3 8@N d@+4 eN+Er3d. Ple4S3 chEck YOUR W1LDc4rd\$ To S33 if +HEy 4LrE4Dy m4+cH +H3 D4+4 eN+3R3D";
$lang['successfullyaddedban'] = "sUCCeS\$fUllY 4DdEd 8@n";
$lang['successfullyupdatedban'] = "sUCcEsSPHulLy UPd4tEd B@n";
$lang['noexistingbandata'] = "theRe is no 3XI5T1N9 b@N D@+4. +0 4DD 5OmE B4n D@T4 plE4\$3 CL1CK Th3 8Ut+On 83l0W.";
$lang['youcanusethepercentwildcard'] = "j00 C@n USE +H3 perCeNT (%) wildC@RD Sym8OL 1N @Ny oPH YOUR B4n L1st\$ +0 0B+4in P4rT14l M4+CH3\$, 1.3. '192.168.0.%' wOuLd B@n 4ll 1P 4DDRe\$\$es 1n +H3 r@NgE 192.168.0.1 thR0UGh 192.168.0.254";
$lang['cannotusewildcardonown'] = "j00 C4nN0+ @dD % A\$ @ W1lDc4Rd m@+ch On 1+'S 0Wn!";
$lang['requirepostapproval'] = "reQU1re P0S+ @pPrOvAl";
$lang['adminforumtoolsusercounterror'] = "tHEre MUSt 8E @+ le@st 1 u53R w1tH @DmiN To0Ls 4nd pH0ruM tO0ls 4Cc3sS 0n 4Ll f0rUM\$!";
$lang['postcount'] = "p05+ CoUnt";
$lang['resetpostcount'] = "r3S3t p0\$t CouNT";
$lang['postapprovalqueue'] = "p0\$t 4pPr0v4l QU3u3";
$lang['nopostsawaitingapproval'] = "nO p0\$+s @rE 4W41+1ng 4PPR0v4l";
$lang['approveselected'] = "aPpR0Ve \$ElEcTeD";
$lang['successfullyapproveduser'] = "sUccESSfULLY 4pprOVed s3lecT3D u5ERS";                                                
$lang['kickselected'] = "k1cK Sel3C+ed";
$lang['visitorlog'] = "vI\$1t0R LOg";
$lang['novisitorslogged'] = "n0 VIs1+ors lo993d";
$lang['addselectedusers'] = "aDD s3LeCtED UsEr5";
$lang['removeselectedusers'] = "r3MoV3 \$3leCtEd U\$eRS";
$lang['addnew'] = "adD nEw";
$lang['deleteselected'] = "d3L3T3 5El3ct3d";
$lang['noprofilesectionsfound'] = "tHERe @R3 n0 EXI5+In9 pROpH1le SectI0nS. To @DD @ pROf1LE S3c+i0n PLe@se cl1Ck t3H bu+ton b3LoW.";
$lang['addnewprofilesection'] = "adD nEW Pr0fIl3 S3CT1ON";
$lang['successfullyaddedsection'] = "sUCCeSsFULly 4ddEd s3cT1oN";

// Admin Log data (admin_viewlog.php) --------------------------------------------

$lang['changedstatusforuser'] = "cH4nG3D u\$eR \$+4+U\$ pHOR '%s'";
$lang['changedpasswordforuser'] = "cH4N93D P@S\$WORd for '%s'";
$lang['changedforumaccess'] = "ch4ng3d PHorUM @cc35S PErMiSSIoNS F0r '%s'";
$lang['deletedallusersposts'] = "deL3+ED @LL P0stS ph0R '%s'";

$lang['createdusergroup'] = "cRe@T3D U\$er 9roUp '%s'";
$lang['deletedusergroup'] = "dElE+ed U\$eR 9R0up '%s'";
$lang['updatedusergroup'] = "uPd4+eD us3r 9rOUp '%s'";
$lang['addedusertogroup'] = "add3d us3r '%s' +0 9r0UP '%s'";
$lang['removeduserfromgroup'] = "r3Mov3 uS3R '%s' FR0m grOUp '%s'";

$lang['addedipaddresstobanlist'] = "aDded ip '%s' To b4N LIS+";
$lang['removedipaddressfrombanlist'] = "remOv3d ip '%s' pHR0m 84n L1ST";

$lang['addedlogontobanlist'] = "addEd L09oN '%s' t0 8@n l1\$t";
$lang['removedlogonfrombanlist'] = "r3M0v3D LOGoN '%s' pHrOM B4N lIS+";

$lang['addednicknametobanlist'] = "aDD3D N1Ckn@M3 '%s' t0 8@N L1ST";
$lang['removednicknamefrombanlist'] = "r3m0V3D N1cKNAme '%s' pHR0M b4N L1\$T";

$lang['addedemailtobanlist'] = "aDDed 3m@Il ADdrE\$s '%s' t0 b4n L15+";
$lang['removedemailfrombanlist'] = "r3M0veD eMA1L 4DDr3\$S '%s' phROM B@n lIsT";

$lang['addedreferertobanlist'] = "aDd3D r3F3R3r '%s' t0 B4n l15T";
$lang['removedrefererfrombanlist'] = "r3mOv3D R3F3r3r '%s' fROm b4n l1\$+";

$lang['editedfolder'] = "eD1+ed fOld3R '%s'";
$lang['movedallthreadsfromto'] = "mOv3d 4ll thRE4d5 PHr0M '%s' +o '%s'";
$lang['creatednewfolder'] = "cr3@T3d nEW Ph0LdeR '%s'";
$lang['deletedfolder'] = "dEl3+ed Ph0lD3R '%s'";

$lang['changedprofilesectiontitle'] = "ch4nged pr0Phile s3C+iOn +1+le fr0M '%s' +O '%s'";
$lang['addednewprofilesection'] = "adDED N3W PrOpH1Le SecT1oN '%s'";
$lang['deletedprofilesection'] = "dEL3t3d Pr0phIL3 53C+10N '%s'";

$lang['addednewprofileitem'] = "aDDEd nEW pRofIle 1Tem '%s' TO 5EcT10n '%s'";
$lang['changedprofileitem'] = "ch@n9Ed prOF1lE 1T3m '%s'";
$lang['deletedprofileitem'] = "d3l3T3D PR0ph1l3 1T3M '%s'";

$lang['editedstartpage'] = "editeD st@rt P@93";
$lang['savednewstyle'] = "s@Ved NEW \$tYl3 '%s'";

$lang['movedthread'] = "mOv3D Thre@d '%s' Phr0m '%s' tO '%s'";
$lang['closedthread'] = "cL05ED +hre@d '%s'";
$lang['openedthread'] = "opEn3D +Hr3ad '%s'";
$lang['renamedthread'] = "rEn@med +hre4D '%s' +0 '%s'";

$lang['deletedthread'] = "d3Le+3D thr3@D '%s'";
$lang['undeletedthread'] = "uNd3leT3D +HRe@d '%s'";

$lang['lockedthreadtitlefolder'] = "l0CKEd +hre@d oPTi0N\$ on '%s'";
$lang['unlockedthreadtitlefolder'] = "uNLoCKEd +hr3@d oP+1oN\$ 0N '%s'";

$lang['deletedpostsfrominthread'] = "d3l3+3d PO5+s PHrOm '%s' In +hRe4d '%s'";
$lang['deletedattachmentfrompost'] = "deL3+3D @TT@cHmenT '%s' PhroM P05t '%s'";

$lang['editedforumlinks'] = "ediTeD PH0ruM lInKs";
$lang['editedforumlink'] = "edi+ED fORUM liNK: '%s'";

$lang['addedforumlink'] = "adD3D PH0rUm L1Nk: '%s'";
$lang['deletedforumlink'] = "dEl3+3d fORum lINK: '%s'";
$lang['changedtoplinkcaption'] = "cHAnG3D +Op L1nk C4PTIOn PhrOm '%s' +o '%s'";

$lang['deletedpost'] = "d3L3t3d p0St '%s'";
$lang['editedpost'] = "eD1t3d PO5t '%s'";

$lang['madethreadsticky'] = "m4D3 +hR3@d '%s' \$+IckY";
$lang['madethreadnonsticky'] = "maD3 tHR3@d '%s' noN-StiCky";

$lang['endedsessionforuser'] = "eNd3D \$3\$s1On FOr uS3r '%s'";

$lang['approvedpost'] = "aPPRoV3D p0\$T '%s'";

$lang['editedwordfilter'] = "edi+eD w0Rd f1L+ER";

$lang['addedrssfeed'] = "aDD3d r\$5 f3Ed '%s'";
$lang['editedrssfeed'] = "eD1T3d r5s FE3d '%s'";
$lang['deletedrssfeed'] = "d3Le+3D rSs f33d '%s'";

$lang['updatedban'] = "upd4tED 84n '%s'. '%s' +0 '%s', '%s' +O '%s'.";

$lang['splitthreadatpostintonewthread'] = "sPliT +Hr34D '%s' @+ pOS+ %s  In+0 n3W +hR34d '%s'";
$lang['mergedthreadintonewthread'] = "m3rgEd +hR34D\$ '%s' 4nd '%s' in+0 N3W THrE@d '%s'";

$lang['approveduser'] = "apProv3D UsEr '%s'";

$lang['adminlogempty'] = "adMIn lOg i\$ 3MPtY";
$lang['clearlog'] = "cL3AR L0G";

// Admin Forms (admin_forums.php) ------------------------------------------------

$lang['noexistingforums'] = "no EX1STIN9 FORuMS pHoUND. +o Cre4T3 @ N3W fOrUM pl3A53 CLIck +3H BuTTOn 83l0W.";
$lang['webtaginvalidchars'] = "wE8t49 C4N 0NLY c0Nt4In UpP3Rc@S3 4-z, 0-9 4Nd uNd3R\$CORe cH@R4C+3r\$";
$lang['databasenameinvalidchars'] = "d4+48@\$e n4M3 c4n oNly Con+4In 4-Z, @-Z, 0-9 4nd undEr\$c0R3 cHar@cT3r\$";
$lang['invalidforumidorforumnotfound'] = "iNV4l1D f0RuM phId F0r F0rUm no+ Ph0uNd";
$lang['successfullyupdatedforum'] = "suCc3S\$fuLLY UpD@+3d fORUm: '%s'";
$lang['failedtoupdateforum'] = "f@1lED +O Upd4t3 PH0rum: '%s'";
$lang['successfullycreatedforum'] = "sUCC3S5PhULly CR3A+eD PH0Rum: '%s'";
$lang['failedtocreateforum'] = "f41L3d To CrE@+3 Ph0ruM '%s'. pl34S3 cheCk T0 M4kE SuR3 +HE W38+4g @ND T@BL3 N@mE\$ 4rEN'T 4lREaDy 1N US3.";
$lang['forumdeleteconfirmation'] = "ar3 J00 suR3 j00 W@N+ tO DElET3 4Ll OF +eh 53l3CtEd Ph0RuMS?";
$lang['forumdeletewarning'] = "pLE453 NO+E tH4+ J00 c4NN0+ R3cOVeR DEl3+3D pH0Rum5. OncE deLEt3d 4 ForUM 4nd 4Ll 0F 1t'S 45S0C14TEd D4+4 1s pERm3n4n+LY r3M0vEd frOm +EH D4+48@5e. iF j00 do n0t WI5H T0 d3leTe THE 5eL3C+3D PhORUms pL34\$E CLIck c@NCeL.";
$lang['successfullydeletedforum'] = "sUccE\$\$FUlLY del3+ED FoRUm: '%s'";
$lang['failedtodeleteforum'] = "f@IL3D +o d3L3tED pH0ruM: '%s'";
$lang['addforum'] = "add fORUM";
$lang['editforum'] = "ed1+ ph0RUM";
$lang['visitforum'] = "v1SI+ F0rUM: %s";
$lang['accesslevel'] = "aCCE\$S L3VeL";
$lang['usedatabase'] = "uS3 D4T4845e";
$lang['unknownmessagecount'] = "unKN0wN";
$lang['forumwebtag'] = "f0rUM web+49";
$lang['defaultforum'] = "def@uLT PH0rUM";
$lang['forumdatabasewarning'] = "pLe453 3n5Ur3 J00 \$3LEc+ tH3 C0rR3C+ d4+4b45e wh3N cR34+in9 @ N3W PHORuM. 0ncE Cr34t3d @ N3w foRUm c4NnOt b3 M0v3d 8EtW33n 4v41LA8LE D@T@84Se5.";

// Admin Global User Permissions

$lang['globaluserpermissions'] = "gLoBal uSeR PErMI5s10n\$";

// Admin Forum Settings (admin_forum_settings.php) -------------------------------

$lang['mustsupplyforumwebtag'] = "j00 mU\$+ 5upplY @ pH0RUm we8T4g";
$lang['mustsupplyforumname'] = "j00 MUS+ SuPplY 4 forUm n4m3";
$lang['mustsupplyforumemail'] = "j00 must 5upPly 4 PH0rUM 3m@iL 4Ddr3s\$";
$lang['mustchoosedefaultstyle'] = "j00 mUs+ CH00S3 4 DepH4uL+ PH0RuM s+yL3";
$lang['mustchoosedefaultemoticons'] = "j00 mUsT cH00Se d3f@uLt fOruM 3mO+1CoN5";
$lang['mustsupplyforumaccesslevel'] = "j00 MUST \$UPPlY 4 F0RUm AcCESs L3v3l";
$lang['mustsupplyforumdatabasename'] = "j00 MUS+ \$upPlY 4 phORuM d@T484\$E N@m3";
$lang['unknownemoticonsname'] = "uNkN0WN emOtIc0n\$ N@ME";
$lang['mustchoosedefaultlang'] = "j00 MUS+ cHo0S3 4 D3phaUL+ Ph0rUm L4N9u4ge";
$lang['activesessiongreaterthansession'] = "act1vE S3S51oN TIM3Ou+ c4NnOt 83 9R3@tEr THaN S35s1oN T1m3oU+";
$lang['attachmentdirnotwritable'] = "at+4CHM3N+ D1RectORy 4ND sy\$T3m T3Mp0r@RY d1rEctOrY / Php.1N1 'Upl0@D_tmP_d1R' MUS+ 83 WR1+4Bl3 8Y +He we8 sErv3r / PhP pRoc3\$s!";
$lang['attachmentdirblank'] = "j00 MU5+ sUPpLy 4 d1ReCt0rY +0 54Ve 4+T4chm3n+S 1N";
$lang['mainsettings'] = "m41N 53tT1N9S";
$lang['forumname'] = "forUm NAmE";
$lang['forumemail'] = "f0rUm 3M4IL";
$lang['forumdesc'] = "forUM d3sCrIP+I0n";
$lang['forumkeywords'] = "f0RUm kEyW0RdS";
$lang['defaultstyle'] = "d3F4UlT \$+YlE";
$lang['defaultemoticons'] = "defaULT EmO+iCONS";
$lang['defaultlanguage'] = "dEF4Ult L4n9UAg3";
$lang['forumaccesssettings'] = "f0RUM 4cc3S\$ S3T+1N9S";
$lang['forumaccessstatus'] = "fOruM @ccE\$5 \$TatUS";
$lang['changepermissions'] = "cH4n9E P3RMi\$S10ns";
$lang['changepassword'] = "cH4Ng3 p45SwORD";
$lang['passwordprotected'] = "pA\$swORd prO+ecTeD";
$lang['passwordprotectwarning'] = "j00 H4V3 No+ \$3t 4 PH0rUm p@S\$W0rd. ipH j00 d0 n0+ s3t a Pa\$\$W0rD +EH P@ssW0RD pr0T3CtI0N FUnc+10n4Li+Y w1lL B3 @u+oM4+1C4LlY dI\$48l3d!";
$lang['postoptions'] = "po\$T 0p+10n5";
$lang['allowpostoptions'] = "all0w POs+ 3di+1N9";
$lang['postedittimeout'] = "poST 3dIT +Im3OU+";
$lang['posteditgraceperiod'] = "pOsT eDi+ 9r@Ce p3RIod";
$lang['wikiintegration'] = "w1K1W1K1 1N+3gR@T1ON";
$lang['enablewikiintegration'] = "en48Le wiK1w1K1 1N+e9r4+10N";
$lang['enablewikiquicklinks'] = "eN48le WIk1W1ki qUiCk LinKS";
$lang['wikiintegrationuri'] = "w1K1W1Ki LOC4+I0n";
$lang['maximumpostlength'] = "m@XImuM P0ST L3NGTH";
$lang['postfrequency'] = "p05T PHR3Qu3NCy";
$lang['enablelinkssection'] = "eN48le LiNkS \$ecT10N";
$lang['allowcreationofpolls'] = "aLloW Cre4t1oN oF POLlS";
$lang['allowguestvotesinpolls'] = "alloW 9UeST5 tO vo+3 1N POLLs";
$lang['unreadmessagescutoff'] = "uNre4d M3\$\$4gE\$ cUt-0PhF";
$lang['unreadcutoffseconds'] = "seCond\$";
$lang['disableunreadmessages'] = "diS4BLe unR3@D mess49E\$";
$lang['nocutoffdefault'] = "no CuT-oFpH (dEPh4uL+)";
$lang['1month'] = "1 M0ntH";
$lang['6months'] = "6 MOnTH\$";
$lang['1year'] = "1 Y3Ar";
$lang['customsetbelow'] = "cU\$+om v4luE (SET bElOW)";
$lang['searchoptions'] = "sE4Rch opT10N5";
$lang['searchfrequency'] = "se4RcH Fr3qu3NCY";
$lang['sessions'] = "sE\$\$ions";
$lang['sessioncutoffseconds'] = "sESs10N cUt oPhf (\$EcONds)";
$lang['activesessioncutoffseconds'] = "aCt1v3 se\$5i0N cu+ 0fPH (\$3CoNDS)";
$lang['stats'] = "s+4+\$";
$lang['hide_stats'] = "h1DE 5T@Ts";
$lang['show_stats'] = "shOw STat5";
$lang['enablestatsdisplay'] = "eN48L3 ST4+\$ DISpL4y";
$lang['personalmessages'] = "per\$0N4l m35S4g3S";
$lang['enablepersonalmessages'] = "en48l3 p3r\$on4L MESs4G3s";
$lang['pmusermessages'] = "pM MEs\$4g35 p3R USEr";
$lang['allowpmstohaveattachments'] = "all0W P3r\$on4l mE\$s4g35 +0 h4Ve 4+t4Chm3Nt5";
$lang['autopruneuserspmfoldersevery'] = "aU+o pruNe USeR'S PM fOlD3R\$ 3Very";
$lang['userandguestoptions'] = "u\$3r @Nd gu3sT opT1OnS";
$lang['enableguestaccount'] = "en4bLE 9u3ST 4CC0uNt";
$lang['listguestsinvisitorlog'] = "l1S+ 9uESt\$ 1n v1siT0r loG";
$lang['allowguestaccess'] = "aLlOW 9uE5T 4ccE\$\$";
$lang['userandguestaccesssettings'] = "uSer @Nd 9u3\$T @cc355 \$3+t1n9S";
$lang['allowuserstochangeusername'] = "aLL0W u\$3RS +0 cH@nG3 US3rN@ME";
$lang['requireuserapproval'] = "reQu1r3 Us3R aPpr0V4L 8y 4dm1n";
$lang['enableattachments'] = "eN4blE 4T+4CHMEn+s";
$lang['attachmentdir'] = "aT+4cHmeN+ d1R";
$lang['userattachmentspace'] = "a+t4cHM3N+ SP4CE peR U\$3R";
$lang['allowembeddingofattachments'] = "alL0w 3Mb3dd1NG 0F 4++@chM3n+S";
$lang['usealtattachmentmethod'] = "u\$e 4l+3RN4T1v3 @+t@Chm3n+ m3+h0D";
$lang['allowgueststoaccessattachments'] = "aLLow 9U3s+s tO 4CC3sS ATT@cHMENT5";
$lang['forumsettingsupdated'] = "fORUm \$3++1n9\$ sUccESSpHUlLy Upd4ted";
$lang['forumstatusmessages'] = "f0rum sT4tuS m3\$s4Ge\$";
$lang['forumclosedmessage'] = "foRUM CLoS3D m3\$S4g3";
$lang['forumrestrictedmessage'] = "foRuM RESTricT3d M3ss4g3";
$lang['forumpasswordprotectedmessage'] = "f0rum PAs\$W0rd PR0+ect3D m3\$54g3";

// Admin Forum Settings Help Text (admin_forum_settings.php) ------------------------------

$lang['forum_settings_help_10'] = "<b>po\$+ eDI+ +Im3oUT</b> 1S +h3 +ImE 1N MinU+3s afTEr po5tiN9 th4+ 4 Us3r C4N 3diT +HE1r POs+. if s3+ +O 0 THER3 1s n0 liMit.";
$lang['forum_settings_help_11'] = "<b>m4xIMuM PoST len9+H</b> 1S TH3 m@xImuM nUmB3R oF Ch4R@c+eRs +H4T w1ll 8E DiSpL4Y3D In a p05T. IF a Post Is L0n9Er th4N tH3 Num8Er oPH ch4r@c+3R5 dEPh1n3D H3R3 I+ W1lL 83 cUT \$hOR+ 4ND 4 link @dDED t0 thE B0TtOM +O 4Ll0w US3R5 t0 rEAD ThE WHOLE P0\$t ON 4 S3P@rA+E P4G3.";
$lang['forum_settings_help_12'] = "iPh j00 DoN'+ w4Nt y0Ur u\$eRs t0 83 4bLe +0 cRE4+e pOll5 j00 c4N dI548le +eh abov3 oP+1ON.";
$lang['forum_settings_help_13'] = "thE LINk\$ 5eCT1ON of B33HIv3 PR0vID3\$ 4 PL4c3 phoR yOUr uSErS +o m41ntAIN 4 L1S+ 0F 51T35 +hEY fREqUEn+ly vis1+ th4+ O+h3R u\$3r\$ m4Y FINd US3Ful. L1nkS c4N 8E DIV1DED Int0 c4+Egor1E\$ BY PHoldEr 4nd 4LlOw F0R cOmm3n+\$ ANd r4tINg\$ +o 83 9Iv3n. 1N 0rDer to M0D3R@t3 +3H l1NKs 53c+1oN @ U\$3R Mu\$+ 83 r@N+Ed gL084l M0DeR4+OR \$t4+U\$.";
$lang['forum_settings_help_15'] = "<b>sEs\$10n cU+ 0Ff</b> 1\$ t3H m4X1muM TIm3 83PhOR3 @ u\$3r'\$ \$e\$510n 1S d33m3D d34D 4ND th3Y @r3 l09g3D OUT. by DeF4UlT +h1\$ I5 24 hOURS (86400 \$3cOND5).";
$lang['forum_settings_help_16'] = "<b>aC+1V3 53\$SiON CuT 0FF</b> iS tH3 m@xIMuM +1Me 8EPh0rE 4 U5eR's \$3s5ION is D33MeD In4C+Iv3 @T WhICh PO1Nt +H3Y 3n+3r 4n IDle \$t@+3. in +H1s \$t4Te +H3 u\$3R Rem41n\$ logg3D 1N, 8u+ +hEy 4r3 r3m0v3D FR0m tEh 4c+iVe US3R\$ Li\$t in +H3 sT@+S DI\$PL4Y. oNC3 THEY becOM3 4Ct1VE @g4In tH3Y WIlL be rE-4dDEd t0 Th3 LI\$+. bY d3F4UlT +His SE+T1N9 IS \$Et +O 15 miNuT3\$ (900 \$eCONd\$).";
$lang['forum_settings_help_17'] = "eN48l1n9 th1s 0PT1on @lLOWs B3Eh1Ve +0 inCLud3 4 5+@t\$ dI5PL4Y 4+ +hE B0+tOM 0F THe M35549E\$ P@ne \$1M1l4R TO th3 0nE U53d 8Y m4nY f0rUM 5OpHtW@re ti+l3S. 0nCE 3N@8lEd t3h D15Pl4y 0F t3h 5T4+s p4gE c4N b3 +0g9leD 1ndIV1dU4Lly by E@Ch u\$3R. IpH +h3y d0n'+ W@NT +0 S3e I+ +HeY CaN h1D3 iT PhR0M View.";
$lang['forum_settings_help_18'] = "p3RsON@L m3\$S4GeS 4rE inVaLUa8L3 @S 4 waY 0Ph t4k1N9 m0R3 Priv4t3 m4++3r\$ 0u+ oF Vi3w 0f T3h o+Her m3M8ER\$. H0W3VeR 1f J00 DoN'T w4n+ yOuR UsERS tO 8e 48Le t0 \$3nd 3AcH 0th3R Per5On@L m3SS4G3\$ J00 C4N DIS4bl3 +HiS 0p+1on.";
$lang['forum_settings_help_19'] = "p3R5On4l m3\$s4gE5 c4N AlS0 Con+4IN @T+4cHmEN+S wHicH C4N be UseFUl fOr EXch@NgIn9 PH1l3S 83+w3En uSErS.";
$lang['forum_settings_help_20'] = "<b>nO+3:</b> TEh \$P@CE 4Ll0c4T1On ph0R PM 4+T@chM3N+S 1s +4keN fRoM E4ch U5Er\$' m@1N 4T+@cHM3n+ 4lLOC@t1ON 4nD 1\$ NO+ 1N 4dD1+i0n tO.";
$lang['forum_settings_help_21'] = "<b>ena8l3 Gue\$t @CCOUnT</b> 4lL0WS v1S1tOR\$ To 8R0w5e y0Ur fOrum @ND R3@d po\$+\$ wiTHout Re91S+3r1N9 4 usER ACcOuNT. 4 Us3r 4Cc0unT 1\$ \$t1Ll ReQu1r3D 1ph THeY WISH T0 p05T 0r CH4ngE U5Er PrEpH3RENcES.";
$lang['forum_settings_help_22'] = "<b>l1\$t GU3ST\$ 1n ViS1+OR loG</b> @Ll0W\$ j00 +0 sP3CiFY wH3+HEr OR Not UnRe9I\$+ER3D U\$3Rs @re l1\$TeD 0n +H3 VI5It0r log 4LoNg S1D3 R3GiS+EreD uS3Rs.";
$lang['forum_settings_help_23'] = "bE3HivE @LloW\$ @+t@chmeNt5 +0 bE UPl0ad3D +O ME\$s49eS Wh3n pO5T3d. If J00 h@vE liM1ted web sp@ce J00 maY WH1cH T0 diS4blE 4++4cHM3nTs by cL3@r1N9 +hE 80X 48oV3.";
$lang['forum_settings_help_24'] = "<b>a+T4CHM3N+ D1R</b> i5 T3H L0C@+10N BeEH1ve ShOuLD SToRE 1t'\$ 4T+4ChMEn+5 IN. +His Dir3C+0ry Mu5+ 3XIsT 0n Y0Ur we8 \$p@c3 4Nd mU\$t 83 wR1T@8Le By +hE weB 5ERV3R / pHP PrOc3\$S 0th3Rw1S3 upL0@d\$ wiLl F41L.";
$lang['forum_settings_help_25'] = "<b>aTT@chMeN+ \$p@Ce p3R U\$er</b> iS +Eh m4x1muM 4mOUnT 0F diSk \$P@cE A U53R H4\$ pH0R @Tt@chm3nTS. 0NC3 TH1s 5P@cE 15 u5eD uP +3H USeR C4Nn0+ UpLO4d 4nY mOr3 4T+4CHmEn+S. By DEpHAUL+ thI5 IS 1M8 oph \$p4cE.";
$lang['forum_settings_help_26'] = "<b>alLOW em8Edd1Ng oPh 4++4ChM3NtS IN meSs49es / sI9n4+Ure\$</b> 4LL0W5 u5er\$ T0 Em8ED @+t4ChMenT\$ 1n P0\$+S. 3n@8ling thIS oPT1oN wh1l3 U5EpHUl c4n 1NcrE@SE youR b@ndw1dtH u\$49e dr45+Ic4Lly UND3R CerT41n CoNF19Ur4+10NS 0PH php. if j00 H@Ve lIm1t3D 84ndW1Dth 1+ iS R3C0Mm3nD3D TH4T J00 diSA8l3 +H1\$ 0p+1On.";
$lang['forum_settings_help_27'] = "<b>us3 @L+eRn@T1ve 4++4chMen+ m3Th0d</b> FOrceS 833Hiv3 +0 u5E @n @LterN4TIvE R3TrIev4L m3+hOd Ph0r 4+t4Chm3Nt\$. 1F j00 rec31ve 404 erROR m3554G3\$ WhEN tRyiN9 +0 D0Wnlo@d 4T+4Chmen+s FROM M3SS@ges TRY 3N48l1ng +h1s OP+i0N.";
$lang['forum_settings_help_28'] = "thI\$ \$E+t1Ng @LlOW\$ YoUr F0rUM T0 8E SP1D3ReD bY 5eARcH 3N91Nes l1kE 90ogl3, @Lt4v1\$t@ 4nd Y4Ho0. iF J00 5W1tch th1S 0P+10N OPHF Y0UR F0RUm wiLl Not 83 InCLuD3D 1N +he\$e S3@rCh 3NGinE\$ R35ulTs.";
$lang['forum_settings_help_29'] = "<b>alL0W N3W Us3R R39i5TR@Ti0ns</b> 4LLoWS or DiS4lLOWs ThE cR3@+10N oPH neW uS3r 4cC0UNt\$. SE++in9 +He Op+IoN T0 n0 C0mpLE+3lY D1S48l35 Th3 r3Gi5tr4t1ON FOrM.";
$lang['forum_settings_help_30'] = "<b>eN@bl3 wIKIwiK1 1N+egR@+1On</b> pR0vid3S Wik1w0Rd \$UPp0r+ 1N y0uR PHOrUM POSt\$. 4 wiKiWoRD I\$ M@d3 up 0f +Wo 0r moRe coNc4+3n4+Ed WOrd\$ w1Th UPp3Rc4S3 L3+t3Rs (0FteN ReF3Rred +0 @\$ C@MElC4\$3). IF j00 wrI+3 4 wOrD ThIs W4Y It W1LL 4U+OM@t1c4LlY 8e ch4n93d iNT0 4 hYPeRL1NK pO1N+inG tO Your cHO5en WIkIW1KI.";
$lang['forum_settings_help_31'] = "<b>eN4bl3 w1k1W1k1 qu1cK lInK\$</b> EnaBL3s +h3 U\$e of M5g:1.1 4nd USeR:L0GON S+YLe 3xt3NDed W1k1liNKS WH1cH CRe@+e Hyp3rLinKS to th3 5PeCif13D Me\$S49e / u\$3r PrOF1le of tHe \$pec1FieD UsER.";
$lang['forum_settings_help_32'] = "<b>wiKIWik1 l0c4t1On</b> iS u\$eD +o \$peC1PhY +H3 uR1 0Ph y0uR w1kIWIk1. WheN ENt3r1nG +H3 Ur1 uS3 [WIkiWord] to 1nDIc4+E Wh3rE 1n +h3 urI TH3 WIk1w0rD shOuLD @PPeAR, i.E.: <i>hT+P://3n.w1Kipedi4.0R9/WIK1/[wiKIWoRD]</i> W0Uld LINk Y0UR wIKiW0Rds t0 %s";
$lang['forum_settings_help_33'] = "<b>foRum @CCe\$s \$T4+uS</b> c0NTrOlS HOw USeR\$ M4y 4Cc3SS YoUR f0Rum.";
$lang['forum_settings_help_34'] = "<b>opEn</b> w1ll 4lLOw 4ll U\$ERs @nD 9u3\$ts 4CCe\$s +0 yOuR PhORuM WI+H0U+ r35+RIctION.";
$lang['forum_settings_help_35'] = "<b>clOSEd</b> PReV3Nt5 4Cc3S\$ Ph0R 4lL u\$3r5, Wi+H thE 3XCep+ioN oF The @Dm1N wh0 m4Y StIlL 4CcESS +eh 4dMIN P4NeL.";
$lang['forum_settings_help_36'] = "<b>rE\$+R1Ct3d</b> 4lloW\$ +o SEt A l1s+ oph u5er\$ WhO 4re @lLOWed @cC3ss TO Y0UR pH0rUM.";
$lang['forum_settings_help_37'] = "<b>p@\$\$woRd Pr0+ECt3D</b> 4Llows j00 TO sE+ 4 P4s\$w0Rd +o GiV3 0u+ To uSerS 5o +h3Y c@n acCES\$ y0Ur pH0RuM.";
$lang['forum_settings_help_38'] = "whEn s3TTIn9 re5+RiC+3d 0R p4S5w0rD PR0+ec+3D moD3 j00 w1LL nEed +O s4vE yOuR cH4ngE\$ b3phorE J00 c4N cH4NG3 TEh US3R 4ccE5s prIvILe93S 0r p@SsW0RD.";
$lang['forum_settings_help_39'] = "<b>Search Frequency</b> defines how long a user must wait before performing another search. Searches place a high demand on the database so it is recommended that you set this to at least 30 seconds to prevent \"search spamming\"FROM KIlL1Ng th3 s3rV3r.";
$lang['forum_settings_help_40'] = "<b>p0sT FrEQU3Ncy</b> IS +HE Min1MUm t1me @ USeR mUs+ W4it 83PH0r3 Th3y C4N P0ST 4G41N. +h1s S3TtInG 4l\$0 4PHFeCt5 +He cRE@ti0N 0F P0LL5. S3T +O 0 +0 DIS48le +he r3\$+R1C+IOn.";
$lang['forum_settings_help_41'] = "thE 4B0Ve oPT1ON\$ cH@N93 +EH dePh@UlT V4Lu3\$ pHoR t3h USer rE9i5+R@Ti0N ph0rm. WH3R3 4PPL1cA8l3 0TH3R S3+t1n9S w1Ll usE +HE fORUM'S OwN DEf@uL+ \$E++ING5.";
$lang['forum_settings_help_42'] = "<b>pREv3n+ uSe opH duPl1c4T3 eMAil 4ddrE\$\$e\$</b> PH0rC35 8EEHIV3 To ch3Ck +h3 U53r @Cc0unTS 4G4iN\$t +H3 EMaiL 4dDRES5 thE USeR iS r3GiStERiNg Wi+h 4ND ProMPTs THem tO U5E 4NOTh3R Iph 1T I5 4lrE@DY IN US3.";
$lang['forum_settings_help_43'] = "<b>r3Qu1R3 3m4Il cONphIrM@tiON</b> WhEn eNA8l3D WiLL \$3nD 4n 3M@1L +o 34CH NEW uSer W1tH 4 LiNk +h4+ c@N 8E u\$3d To c0nPHIrM tHe1r 3M4Il 4dDr3S\$. UntiL THeY conphIRM +h31R 3M41L @ddR35\$ they W1Ll N0t 8E @bl3 +O PO\$t uNL3s\$ +h31r u53R p3RmISS1onS 4R3 CH4n93d M@nU4llY BY 4N 4DmIN.";
$lang['forum_settings_help_44'] = "<b>u\$e T3x+-C@p+Ch4</b> pRe\$En+s +he N3W USeR w1th 4 M4ngLEd 1ma93 whICh TH3Y MuST coPY 4 nuM8Er FR0m 1n+0 4 tEX+ pH1ELd 0n Th3 RE91s+R@+i0n FORM. U\$3 ThIS OP+ioN tO pReV3NT 4u+om4+ED \$IGN-UP vI@ \$Cr1p+S.";
$lang['forum_settings_help_45'] = "<b>t3x+-c4pTCh@ d1R3C+0rY</b> SP3c1Ph1e\$ +3h LOc4ti0n +H4t b33HiV3 w1LL 5tOR3 IT'5 Tex+-c4p+Ch4 1M49es aNd FON+S 1n. tH1s D1rEC+0ry Mu\$+ b3 WRiT48l3 8y +eh WE8 S3rvER / PhP PROc3\$\$ 4nD MU\$T 83 4cCES518Le v14 H++P. @fTER J00 H4V3 3N4bL3D +3X+-c@pTch4 j00 Mu\$+ UpL0AD 50m3 tRUE +YPE fONTS IN+0 +eH F0Nt\$ 5U8-D1R3CtORY 0pH yOUr mAIn +3XT-c4P+Ch4 D1R3C+ory O+HeRWI53 8EeHIv3 W1Ll SKIp TeH +3xt-C@PTCh4 dURINg u\$3R re9Istr@tI0N.";
$lang['forum_settings_help_46'] = "<b>Text Captcha key</b> allows you to change the key used by Beehive for generating the text captcha code that appears in the image. The more unique you make the key the harder it will be for automated processes to \"guess\"+He C0d3.";
$lang['forum_settings_help_47'] = "<b>po\$+ 3D1+ gR@ce PErI0D</b> 4Ll0WS J00 tO D3PhIN3 4 peRi0d 1N miNUtE\$ wHeR3 U5Er5 M4Y EdIT p0ST\$ W1+H0uT teH 'EDiT3D 8Y' tEX+ 4pPe@r1NG 0n +HEiR P0\$t\$. If \$3T t0 0 +EH '3D1+3d 8y' tEXT W1Ll 4lw4Y\$ @pPe4R.";
$lang['forum_settings_help_48'] = "<b>unr3@d ME\$\$4GE\$ cu+-0FF</b> SpecIf13S H0w l0Ng UNR34D m35S4G3s 4R3 REt41NED. j00 m4Y chOO5E PHROm v@ri0U\$ PrES3+ V4lUE5 OR En+er y0ur 0wN cu+-oFpH p3r1OD 1n \$3CoNdS. +hr3@dS mOd1PhIeD E@rLiER +haN +H3 DePHInEd cu+-OfF pErI0d WILL 4uTom4+ic4LLy 4Ppe@r @S R3aD.";
$lang['forum_settings_help_49'] = "ch0os1N9 <b>dIS48l3 UNRe4D Me55@9e\$</b> W1Ll c0mPL3+3lY rem0ve UnR3@D mesS@9e\$ sUpP0Rt @ND reMOVe +hE rEl3v4N+ 0Pt10nS PhROM tHE Di\$cUS5ioN TyP3 dRoP dOwN 0n ThE ThRE4d L1sT.";
$lang['forum_settings_help_50'] = "<b>rEquIr3 u53R aPprOv@l bY adM1N</b> alLOwS J00 tO RE\$+rICT @ccesS 8y n3W uS3RS un+iL THeY hAvE B33N 4ppr0vEd 8y @ moDEr@+or OR @dm1n. W1tHOU+ aPprOv@L 4 U53r c@nnOT 4cc3\$S aNy 4Re4 0F +h3 8E3Hiv3 F0RuM 1NsT4Ll@+I0n INcLUD1Ng 1NdiViDu@L FoRUm5, PM 1nBOX @Nd MY pHoRUM\$ \$EC+IONS.";
$lang['forum_settings_help_51'] = "u53 <b>cl05ed MEss4G3</b>, <b>rE5+r1cTED MeSS4G3</b> 4Nd <b>paSSW0rD pROT3C+ED m3ss49e</b> t0 cusTomIs3 +h3 M3Ssa93 di5PL4Y3d WheN us3RS aCcE\$s yOUR ph0RUM 1n +EH v@rIOUS 5+4+E\$.";
$lang['forum_settings_help_52'] = "j00 C4N U\$E h+ML in YOUR Me\$Sa93S. HYpERlInk5 @Nd 3m41l @DdRe\$\$E\$ WiLL 4ls0 b3 4UtOM@+1c@llY cOnV3RtEd +o liNKS. t0 u5e TeH D3F4uL+ 8e3Hiv3 ph0RuM M3\$\$4ge\$ cLe4R +eh f1ElDs.";
$lang['forum_settings_help_53'] = "<b>alLoW U5er\$ TO CH4Ng3 u\$erN4Me</b> P3RMItS 4lRE4dY rE91s+3R3D USEr5 +O Ch@n9E The1r U\$3RN@mE. wHeN En48L3d J00 C@n +R@Ck +H3 ch@N9eS 4 U\$eR M@K35 +0 +H31R USErn4mE Vi@ The 4DM1n U\$3R TO0L\$.";

// Attachments (attachments.php, get_attachment.php) ---------------------------------------

$lang['aidnotspecified'] = "aId NO+ \$pEciFIeD.";
$lang['upload'] = "uplo@d";
$lang['uploadnewattachment'] = "uPL04D n3W 4+TaCHmEn+";
$lang['waitdotdot'] = "w41t..";
$lang['successfullyuploaded'] = "suCC3S5PhUlLY UplO@deD";
$lang['failedtoupload'] = "f4iL3d +O UPl04D";
$lang['complete'] = "c0MPLEt3";
$lang['uploadattachment'] = "uPl04D @ f1l3 ph0r @t+4ChM3n+ tO +EH MesS4g3";
$lang['enterfilenamestoupload'] = "eN+eR PhilEN@me(\$) +0 upl0@d";
$lang['attachmentsforthismessage'] = "a+tACHMeNTS FOR +H1\$ Me\$s4Ge";
$lang['otherattachmentsincludingpm'] = "o+hER 4++4chMen+s (InClUD1nG pM M35S4Ge\$ 4Nd O+HeR pH0Rum\$)";
$lang['totalsize'] = "tOt4L Siz3";
$lang['freespace'] = "fR3e sp4c3";
$lang['attachmentproblem'] = "tH3r3 W4\$ @ Pr08L3M DoWNL0@D1n9 +hiS @t+4ChM3Nt. pl3@SE TrY 4G4in l4+er.";
$lang['attachmentshavebeendisabled'] = "att4chm3N+s h4VE 833N DisaBLed 8Y +Eh Forum 0wNeR.";
$lang['canonlyuploadmaximum'] = "j00 C4n 0NLY UPlo@D 4 M4X1MuM oF 10 f1le\$ 4+ 4 TIme";
$lang['deleteattachments'] = "d3l3TE 4tt@CHm3n+S";
$lang['deleteattachmentsconfirm'] = "aR3 J00 SUR3 j00 w4n+ t0 DeL3T3 +H3 SEleCT3D 4+t@ChMeNTS?";
$lang['deletethumbnailsconfirm'] = "arE j00 5ure j00 W4Nt tO D3L3T3 +He SeLecT3D A+tAChM3N+S ThUM8n41ls?";

// Changing passwords (change_pw.php) ----------------------------------

$lang['passwdchanged'] = "p@S\$w0Rd Chan9Ed";
$lang['passedchangedexp'] = "yOur P45sWoRD h@\$ 833n ch4ngED.";
$lang['updatefailed'] = "upd4tE F4ilED";
$lang['passwdsdonotmatch'] = "p4sswoRdS dO n0+ M4+Ch.";
$lang['allfieldsrequired'] = "alL f13lDs 4Re R3Qu1rED.";
$lang['requiredinformationnotfound'] = "r3QU1rEd 1nFORm4T1oN no+ Ph0UnD";
$lang['forgotpasswd'] = "for90T p@ssw0Rd";
$lang['enternewpasswdforuser'] = "enTER @ N3W p4\$\$wORD f0R uSER %s";
$lang['resetpassword'] = "rE\$E+ p@S5w0rd";
$lang['resetpasswordto'] = "rE\$3t p4s\$WORD +o";

// Deleting messages (delete.php) --------------------------------------

$lang['nomessagespecifiedfordel'] = "nO M3S54GE sp3c1phIED FOR dElE+10N";
$lang['deletemessage'] = "del3+3 mEss@G3";
$lang['postdelsuccessfully'] = "p0\$t Dele+eD sUCC3s\$pHULly";
$lang['errordelpost'] = "erR0R d3l3+iNg Po\$t";
$lang['cannotdeletepostsinthisfolder'] = "j00 CAnNOt d3LetE p0ST5 1n +hIS phold3R";

// Editing things (edit.php, edit_poll.php) -----------------------------------------

$lang['nomessagespecifiedforedit'] = "n0 mE\$5493 5P3CIpHiEd pH0r eD1T1n9";
$lang['cannoteditpollsinlightmode'] = "cAnNo+ 3D1+ P0ll5 1N LIgH+ MoDE";
$lang['editedbyuser'] = "edIt3D: %s 8Y %s";
$lang['editappliedtomessage'] = "eDi+ 4pPL13d +O meS\$4Ge";
$lang['errorupdatingpost'] = "eRR0R UPd@tInG p0ST";
$lang['editmessage'] = "ediT Mes\$49E %s";
$lang['editpollwarning'] = "<b>noT3</b>: 3Dit1N9 c3Rt41n 4specTS opH A P0lL w1ll v0Id 4Ll TH3 cUrREn+ v0+es @nd 4LL0W p3oplE T0 v0+3 4G41N.";
$lang['hardedit'] = "h4RD ED1T 0P+I0N5 (vo+E\$ w1Ll b3 R3\$Et):";
$lang['softedit'] = "sOFt 3D1t 0P+ionS (V0T3S WilL 8e reT@1neD):";
$lang['changewhenpollcloses'] = "cH4NgE WhEN +h3 Poll cL05e\$?";
$lang['nochange'] = "nO CH@N93";
$lang['emailresult'] = "em4IL Resul+";
$lang['msgsent'] = "m35\$4GE \$en+";
$lang['msgsentsuccessfully'] = "me\$s4g3 \$eN+ 5UCcE\$spHullY.";
$lang['msgfail'] = "m3\$\$4gE f4iLed";
$lang['mailsystemfailure'] = "m41L \$Y5+3m f@ILurE. M3ss493 n0+ SEnt.";
$lang['nopermissiontoedit'] = "j00 aR3 N0+ P3rmI+T3d +0 ED1T +H1S Me\$S4gE.";
$lang['cannoteditpostsinthisfolder'] = "j00 C4nn0T ED1+ POs+s 1n TH1S foLDeR";
$lang['messagewasnotfound'] = "m3s549e %s W45 n0+ Ph0UnD";

// Email (email.php) ---------------------------------------------------

$lang['nouserspecifiedforemail'] = "no U\$ER \$pec1F1ed phOR em41L1Ng.";
$lang['entersubjectformessage'] = "eN+Er 4 SUbJ3c+ f0R TH3 MEsS@GE";
$lang['entercontentformessage'] = "enT3r 5om3 c0nTEn+ pH0R +h3 mE5\$49E";
$lang['msgsentfromby'] = "th1s M3S5A9E W45 5En+ phRoM %s bY %s";
$lang['subject'] = "su8J3cT";
$lang['send'] = "seNd";
$lang['hasoptedoutofemail'] = "h45 OPTed 0UT oph em@1l COn+4c+";
$lang['hasinvalidemailaddress'] = "h4S @N 1NVAlID Em@1L 4DdRe\$S";

// Message nofificaiton ------------------------------------------------

$lang['msgnotification_subject'] = "m3s\$493 n0+IpHic4+10N pHR0m %s";
$lang['msgnotificationemail'] = "%s P0S+eD @ M3s\$4gE +0 J00 0N %s\n\n+he \$ubJ3C+ i\$: %s\n\nTo rE@D Th4+ Me\$s4GE @Nd oTHERS 1N +EH s@M3 d15cU5si0N, 9O tO:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nn0+3: iF J00 DO noT w1SH +O R3Ce1V3 3M41L nOT1pHIC4+1ONS oF PhORUm mE5\$49e\$ P0S+ed +o y0u, 90 t0: %s cL1CK ON mY con+R0LS tHEn Em41L 4ND PRIv4cY, uN\$3leC+ tHE Em@1L nO+IfIC@tIOn CH3CK80X 4ND PRe\$5 sUbM1T.";

// Thread Subscription notification ------------------------------------

$lang['subnotification_subject'] = "sU8scr1P+10N n0+if1c4+10n pHROM %s";
$lang['subnotification'] = "%s PoS+ed A m3\$s@9e in 4 thrE4d j00 h@V3 suBsCr1BeD +0 0N %s\n\n+H3 5UBJeC+ 15: %s\n\n+0 Re4D th4+ M3Ss@G3 4Nd o+HerS In tHe s4M3 DISCuS\$iOn, 9o +O:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nN0+3: Iph j00 DO noT W1SH T0 rEce1v3 em4Il N0+if1C4t1OnS OF neW M3\$5@g3\$ 1N THIs ThRe4d, gO +O: %s 4Nd @DJU\$+ y0UR 1Nter3S+ L3V3l 4T tHE b0+T0M 0Ph +EH p@93.";

// PM notification -----------------------------------------------------

$lang['pmnotification_subject'] = "pM NoT1F1Ca+10n PHr0m %s";
$lang['pmnotification'] = "%s Po5+eD 4 pM +0 J00 0n %s\n\nTHe \$U8jEc+ I5: %s\n\ntO Re4d THe me\$s4G3 90 t0:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nN0+3: IF j00 DO n0+ w1sH +0 REcEIvE 3m@1L N0+iF1C4+i0n5 0f n3W PM me\$S4g3S PO5tED t0 Y0u, GO To: %s cL1Ck My c0n+ROL\$ +H3N 3M41L 4Nd PrIv4Cy, UN\$eLeC+ t3H Pm n0T1Ph1C4+I0n cH3ckboX 4Nd pREss Su8m1t.";

// Password change notification ----------------------------------------

$lang['passwdchangenotification'] = "p@\$\$w0RD Ch4NG3 n0+IfICa+I0N PhR0m %s";
$lang['pwchangeemail'] = "tH1\$ A NO+If1CA+1on 3m@Il +o 1nPHOrM J00 TH4+ YOuR P4\$\$w0rd 0n %s hA\$ BEEN Ch@n9Ed.\n\n1t H4\$ B33N cH4n93D +O: %s @ND W@s cH@NGeD bY: %s\n\n1f J00 H4V3 r3ce1V3d tHiS 3m41l in 3rr0r 0r wEr3 NO+ EXP3CT1N9 @ CH4N9e To YOUR PA\$\$w0RD pL3@s3 cOnT@cT +Eh FORUm 0WN3R OR a M0deR4+0r 0N %s 1MMeD1@+eLY +0 corr3Ct 1T.";

// Email confirmation notification -------------------------------------

$lang['emailconfirmationrequired'] = "eM4iL C0NfirM4+1On reqUiR3D fOr %s";
$lang['confirmemail'] = "heLL0 %s,\n\nYOu rEc3ntLy cRe4+3D @ N3W U5Er 4CC0Un+ 0N %s\nB3Ph0RE J00 c@N 5T@r+ P0S+1N9 w3 n33D t0 coNF1rm y0Ur 3M@1l 4dDR355. dON't w0RrY tHiS IS qu1T3 3@5y. 4LL j00 N33d +O DO Is cL1Ck +3H Link 83l0W (oR C0Py 4nD P4ST3 I+ in+0 Y0Ur 8r0W53r):\n\n%s\n\nOncE cOnPhIRM@+10n 15 cOmPL3+3 J00 M@Y logiN And ST@r+ pOsTIN9 1mMEDI4teLY.\n\n1PH j00 d1D n0T cR3@TE a us3r 4CCOUN+ 0N %s PLeA\$3 4CCePT 0UR 4P0l09IE5 aND foRW@rD +HIS Em41l +0 %s s0 TH4+ +H3 soURce 0f 1T mAY 8E iNVESTIG@+ed.";

// Forgotten password notification -------------------------------------

$lang['forgotpwemail'] = "j00 r3qU35T3d tH1\$ E-M41l FrOm %s b3C@US3 J00 h4v3 phorgo+tEN Y0UR P45\$wORD.\n\ncL1CK +H3 Link 8ElOW (Or CopY 4nd P@S+e I+ INtO y0UR bR0w\$3R) +0 RE\$e+ y0ur p4sswOrD:\n\n%s";

// Forgotten password form.

$lang['passwdresetrequest'] = "yOUr P4s5WoRd rE\$e+ reQU3s+ PHr0M %s";
$lang['passwdresetemailsent'] = "p45sw0Rd r3S3t 3-m41l 5eNt";
$lang['passwdresetexp'] = "j00 ShOulD R3C31V3 @N e-M@1l coNt41NiNg inSTrUc+1OnS PHOr r3S3Ttin9 YoUr P@5SWoRd 5HORTLy.";
$lang['validusernamerequired'] = "a valId US3Rn4Me 1s reQU1r3D";
$lang['forgottenpasswd'] = "foRGO+ p4S5w0Rd";
$lang['forgotpasswdexp'] = "if J00 hAV3 phORG0++En y0ur pA\$\$WORd, j00 Can r3Qu3\$t +o h4V3 iT r35E+ bY enteR1N9 y0Ur LOgON n4Me B3LOW. 1N\$tRuC+i0nS 0N hOW tO r353T y0Ur p@sSwOrD wiLl 83 \$ENt TO y0Ur RE915tER3d Em4iL 4ddR3\$\$.";
$lang['couldnotsendpasswordreminder'] = "coUld N0+ 53nD P4SSWoRd R3M1NdEr. plEA\$E coNT4c+ +HE Ph0RuM 0WnEr.";
$lang['request'] = "r3qUe\$T";

// Email confirmation (confirm_email.php) ------------------------------

$lang['emailconfirmation'] = "em41L COnpH1rM@+ion";
$lang['emailconfirmationcomplete'] = "tH@nK j00 Ph0r C0NpHirMiNG y0Ur 3m@1L adDR35S. J00 mAy N0W L0giN aNd 5T@R+ po\$+in9 iMm3d14+ely.";
$lang['emailconfirmationfailed'] = "em41L coNFIRma+10N h45 F4iLed, PL3@se +ry 49@in l4+eR. if j00 Encount3R th1s 3RRoR muL+1pLe +Im3\$ pLe4\$e coN+aCT ThE forUm 0Wn3R 0R @ M0der@T0R for 4\$S1\$+4nce.";

// Links database (links*.php) -----------------------------------------

$lang['toplevel'] = "t0P LEV3l";
$lang['maynotaccessthissection'] = "j00 M4Y NoT 4CcEs\$ +H15 s3cTi0N.";
$lang['toplevel'] = "tOP L3v3L";
$lang['links'] = "l1nk\$";
$lang['viewmode'] = "viEW moD3";
$lang['hierarchical'] = "hi3r4rcHiC4L";
$lang['list'] = "l1St";
$lang['folderhidden'] = "thI\$ fOlDer 1S hiddEn";
$lang['hide'] = "hiD3";
$lang['unhide'] = "uNh1D3";
$lang['nosubfolders'] = "nO su8FOLdeR\$ 1N tH1S c4+EG0Ry";
$lang['1subfolder'] = "1 su8PH0ldeR 1n tH1S c4TegOrY";
$lang['subfoldersinthiscategory'] = "su8ph0LD3R5 in th1S c4+3goRY";
$lang['linksdelexp'] = "eN+Ri35 IN @ dELE+Ed phOLdER W1Ll b3 M0vED +0 THe P4r3n+ FoLd3R. 0nLY F0Ld3rs wh1cH DO n0t C0nTAiN \$U8FOLd3r\$ M4y 83 DEL3+ED.";
$lang['listview'] = "l1\$+ viEW";
$lang['listviewcannotaddfolders'] = "c4nnO+ 4dD FoLDerS 1n +h1S vieW. 5hOwiNG 20 3N+rIeS 4t @ +IMe.";
$lang['rating'] = "r@tiN9";
$lang['nolinksinfolder'] = "nO lInK\$ 1n +H1S fOldeR.";
$lang['addlinkhere'] = "aDD LinK hER3";
$lang['notvalidURI'] = "th@T i\$ nO+ 4 vAl1d Ur1!";
$lang['mustspecifyname'] = "j00 mU\$+ speciFy 4 N4M3!";
$lang['mustspecifyvalidfolder'] = "j00 mUSt 5Pec1phY @ v4LiD ph0ld3r!";
$lang['mustspecifyfolder'] = "j00 mu5T \$pecIfY 4 fOLdEr!";
$lang['addlink'] = "add 4 LiNk";
$lang['addinglinkin'] = "adDiNG lInK 1n";
$lang['addressurluri'] = "aDDrE\$S (uRl/urI)";
$lang['addnewfolder'] = "adD 4 NEw fOLdEr";
$lang['addnewfolderunder'] = "addiN9 nEW F0LD3R UND3r";
$lang['mustchooserating'] = "j00 mUS+ cHO053 4 r@+1Ng!";
$lang['commentadded'] = "your cOMm3NT w@5 4dD3D.";
$lang['musttypecomment'] = "j00 MU5+ tyP3 a COMm3N+!";
$lang['mustprovidelinkID'] = "j00 MuST PrOv1De @ lInk 1d!";
$lang['invalidlinkID'] = "iNV@lid liNK 1d!";
$lang['address'] = "aDdR3SS";
$lang['submittedby'] = "sU8mItT3D By";
$lang['clicks'] = "cl1Ck\$";
$lang['rating'] = "rAtiN9";
$lang['vote'] = "vo+3";
$lang['votes'] = "v0+eS";
$lang['notratedyet'] = "n0+ r@t3D 8Y 4Ny0Ne y3+";
$lang['rate'] = "raT3";
$lang['bad'] = "b@D";
$lang['good'] = "g00D";
$lang['voteexcmark'] = "v0+E!";
$lang['commentby'] = "c0mMENt 8y %s";
$lang['addacommentabout'] = "add @ c0Mm3n+ 4bOUt";
$lang['modtools'] = "moder4+1ON to0L\$";
$lang['editname'] = "ediT N4Me";
$lang['editaddress'] = "eDIT @dDreSS";
$lang['editdescription'] = "edIt d35cr1Pt1on";
$lang['moveto'] = "mOVE to";
$lang['linkdetails'] = "l1nk de+41L5";
$lang['addcomment'] = "add coMM3nT";
$lang['voterecorded'] = "y0uR vO+E h45 B3En r3C0RdEd";

// Login / logout (llogon.php, logon.php, logout.php) -----------------------------------------

$lang['loggedinsuccessfully'] = "j00 lOG93D IN \$UCcESSPHulLY.";
$lang['presscontinuetoresend'] = "pReS5 CoNTInU3 +O rES3ND ph0Rm d@t@ OR C@nc3L +o ReLO4D P4Ge.";
$lang['usernameorpasswdnotvalid'] = "t3h u5Ern@M3 0R P@5sW0RD j00 \$UPPl1ED i5 nO+ V4l1d.";
$lang['pleasereenterpasswd'] = "pl34se RE-eN+Er YOUr P4\$\$WORd 4ND TrY @g4iN.";
$lang['rememberpasswds'] = "rEM3mbeR P45\$W0rdS";
$lang['rememberpassword'] = "reM3Mb3R p4\$SWOrd";
$lang['enterasa'] = "eN+Er @S @ %s";
$lang['donthaveanaccount'] = "dON'+ h4v3 @n 4CCouN+? %s";
$lang['registernow'] = "rEG1\$TEr n0W.";
$lang['problemsloggingon'] = "pr08l3m5 Lo9G1ng 0n?";
$lang['deletecookies'] = "del3+3 c00kI3S";
$lang['cookiessuccessfullydeleted'] = "cO0KiE\$ \$UccE55pHuLLy d3LEt3d";
$lang['forgottenpasswd'] = "f0rgo+t3N yOur PA\$SW0Rd?";
$lang['usingaPDA'] = "us1N9 @ pD4?";
$lang['lightHTMLversion'] = "l19H+ h+ml Ver51On";
$lang['youhaveloggedout'] = "j00 h4v3 l0G9Ed 0ut.";
$lang['currentlyloggedinas'] = "j00 4rE CuRReN+LY L0G9ed 1N A\$ %s";
$lang['logonbutton'] = "lOgon";
$lang['otherbutton'] = "o+H3r";

// My Forums (forums.php) ---------------------------------------------------------

$lang['myforums'] = "my fOruM\$";
$lang['recentlyvisitedforums'] = "r3C3n+LY v1S1tED PhoRums";
$lang['availableforums'] = "aV4Il4blE F0RuM5";
$lang['favouriteforums'] = "f4v0uR1T3 PhOrUmS";
$lang['lastvisited'] = "l4\$+ VI51t3D";
$lang['forumunreadmessages'] = "%s uNrE4D MeSS493\$";
$lang['forummessages'] = "%s meS\$a9E5";
$lang['forumunreadtome'] = "%s uNRE@D &quot;+0: m3&quot;";
$lang['forumnounreadmessages'] = "nO uNr34D M3SSaGE\$";
$lang['removefromfavourites'] = "r3Mov3 fR0M Ph@v0Ur1t3\$";
$lang['addtofavourites'] = "aDD +O F4VOuRIt3\$";
$lang['availableforums'] = "av4iL48le FOruM\$";
$lang['noforumsavailable'] = "tHEre ar3 No F0RuM\$ @v4Il48L3.";
$lang['noforumsavailablelogin'] = "tHer3 4rE N0 f0rUMs 4v41l@8Le. pL34s3 lOg1n +0 VIEW YOUr pH0RuMS.";
$lang['passwdprotectedforum'] = "p4\$\$wOrd pr0+ECt3D F0RuM";
$lang['passwdprotectedwarning'] = "tHis f0Rum 1S P4SSw0RD prOteCTED. to 941N 4cC3\$s 3n+Er +eH pAs\$W0rd b3LoW.";

// Message composition (post.php, lpost.php) --------------------------------------

$lang['postmessage'] = "p0s+ m3\$S4G3";
$lang['selectfolder'] = "sEL3c+ PH0lD3r";
$lang['mustenterpostcontent'] = "j00 mUs+ 3NtEr 50me coNT3nT pH0R tEH P05t!";
$lang['messagepreview'] = "m3SS4Ge PR3ViEw";
$lang['invalidusername'] = "inv@Lid us3RN@M3!";
$lang['mustenterthreadtitle'] = "j00 MUs+ eN+eR 4 ti+le ph0r TH3 +Hre4D!";
$lang['pleaseselectfolder'] = "pL3a\$e s3LecT a F0LdeR!";
$lang['errorcreatingpost'] = "eRr0R Cr3A+1ng p0ST! pLe@SE TRy 4G@iN In @ f3W M1NuT35.";
$lang['createnewthread'] = "cr34t3 N3W tHr3@d";
$lang['postreply'] = "pos+ rEPLy";
$lang['threadtitle'] = "thR34D +1tLe";
$lang['messagehasbeendeleted'] = "m35\$493 H4s 8eEn d3L3t3D.";
$lang['cannotpostthisthreadtypeinfolder'] = "j00 C4NnO+ p0ST +h1s thRe4D tyPe 1n +h4T ph0ldER!";
$lang['cannotpostthisthreadtype'] = "j00 cANNo+ P0\$+ +H1S +hr3@d +yPe 4S +H3R3 ar3 N0 @vA1L4bL3 fOLderS +H@+ 4ll0W 1t.";
$lang['cannotcreatenewthreads'] = "j00 c4NN0T cRE4t3 new +hrE4Ds.";
$lang['threadisclosedforposting'] = "th1S +Hre4D 1S cL0S3D, j00 c@nn0+ p0\$t in i+!";
$lang['moderatorthreadclosed'] = "w4rN1N9: ThIs Thr34D 1s cL05ED F0R p0\$+in9 +O noRm4l USeR\$.";
$lang['threadclosed'] = "tHr3@D CL0SeD";
$lang['usersinthread'] = "u\$3R\$ 1n thrE4D";
$lang['correctedcode'] = "c0RrEct3d C0de";
$lang['submittedcode'] = "su8m1++3D coDE";
$lang['htmlinmessage'] = "h+Ml In meS\$4GE";
$lang['disableemoticonsinmessage'] = "d1\$48l3 3M0+1c0N\$ 1N mESS4Ge";
$lang['automaticallyparseurls'] = "aUT0m4T1c4LlY paRS3 URlS";
$lang['automaticallycheckspelling'] = "au+0m4T1c4LlY cH3CK SPElL1N9";
$lang['setthreadtohighinterest'] = "s3t +hR34d +0 hiGH 1N+eRE\$T";
$lang['enabledwithautolinebreaks'] = "eN4bL3D W1Th @U+0-LiNE-br34k5";
$lang['fixhtmlexplanation'] = "tHiS F0RuM uS3s hTmL f1Lt3R1ng. YOuR 5ubMIT+3D h+ML h@S b33N MOd1Ph13D By +HE pH1Lt3R5 1N SOME w4Y.\\n\\nT0 V1eW yoUR 0R1G1N4L coDE, \$3lEcT +he \\'\$U8mIt+3d CoD3\\' R4d1o 8uTTOn.\\nT0 v1EW +h3 MOd1FIED COD3, S3l3C+ TH3 \\'c0RREcTED C0De\\' R4diO Bu+Ton.";
$lang['messageoptions'] = "me\$\$4Ge Op+1On5";
$lang['notallowedembedattachmentpost'] = "j00 4r3 n0+ 4lL0WEd to EM83D 4tt@chm3N+S 1n y0ur P0\$+s.";
$lang['notallowedembedattachmentsignature'] = "j00 4R3 N0t 4llOwed t0 Em8eD 4++4ChmEnTs In your SiGn4+Ur3.";
$lang['reducemessagelength'] = "mE\$s49E l3n9tH mU\$t 83 UnD3R 65,535 ch4R4Ct3r\$ (currEn+ly:";
$lang['reducesiglength'] = "s19N4TuR3 l3N9+h mU\$+ be UNdeR 65,535 ch@r4C+er5 (cuRREn+lY:";
$lang['cannotcreatethreadinfolder'] = "j00 c4nNOt cR3@TE n3W +HrE4D5 In +HiS FoLDer";
$lang['cannotcreatepostinfolder'] = "j00 C4Nn0+ REply T0 Po5TS in +HI5 FolD3r";
$lang['cannotattachfilesinfolder'] = "j00 c@NnO+ pOS+ 4++4chM3NTs 1N +his f0LDeR. R3M0ve 4T+4cHmEn+s T0 Cont1nUE.";
$lang['postfrequencytoogreat'] = "j00 c4N 0NLy poSt Onc3 3V3ry %s seCoNDs. PL34\$3 Try @94IN L@teR.";
$lang['emailconfirmationrequiredbeforepost'] = "eM@1l C0nF1Rm4TIoN 1\$ rEQU1REd bePh0RE j00 c@n PO\$+. 1PH j00 H@v3 NOT rECE1V3d 4 c0NFiRM@tION Em@1L PL3a\$3 CLicK TEH bU+tON B3L0W anD 4 nEw 0N3 W1lL 8E seNT +o yOU. 1F yOUR eMa1l @DdR35S n33D\$ cH4ng1Ng ple4S3 dO \$O 8Ephor3 r3Qu3\$t1ng @ n3W ConPH1rM4+i0N 3M41L. j00 m4Y ChaNG3 Y0Ur 3M@1l @Ddre\$\$ By CL1cK MY cON+rOL\$ @bOVE @Nd TH3N u\$Er D3+AIL5";
$lang['emailconfirmationfailedtosend'] = "c0NF1Rma+i0n 3m@IL pH@1lED +0 \$3Nd. Ple4S3 cOnTaCT +h3 F0ruM OWnEr T0 R3C+1fY tHIS.";
$lang['resendconfirmation'] = "re\$3Nd c0Nf1rm4t1On";
$lang['userapprovalrequiredbeforeaccess'] = "youR u5Er @ccoUn+ N33D5 tO 8e 4pprOVeD bY @ ph0RuM ADmIN bEpHOR3 J00 c4N 4ccEsS +He R3QuEsT3d F0Rum.";

// Message display (messages.php & messages.inc.php) --------------------------------------

$lang['inreplyto'] = "in r3pLY T0";
$lang['showmessages'] = "show M3S\$Ag3S";
$lang['ratemyinterest'] = "r@+e MY 1nT3R3S+";
$lang['adjtextsize'] = "aDjus+ T3XT 5iZe";
$lang['smaller'] = "smALlER";
$lang['larger'] = "l4RGEr";
$lang['faq'] = "fAq";
$lang['docs'] = "docS";
$lang['support'] = "sUpP0RT";
$lang['donateexcmark'] = "d0NATE!";
$lang['threadcouldnotbefound'] = "th3 R3QuEs+3d THr3@d C0ULd N0+ b3 f0uND OR accE\$s wa\$ d3n13D.";
$lang['mustselectpolloption'] = "j00 MUST \$eL3ct 4N 0p+1On tO V0tE PH0R!";
$lang['mustvoteforallgroups'] = "j00 muST vO+e 1N eveRY gr0uP.";
$lang['keepreading'] = "k3ep rE4dinG";
$lang['backtothreadlist'] = "b4Ck tO +Hr3Ad liS+";
$lang['postdoesnotexist'] = "tHa+ PO5+ Does n0+ Ex1st In ThIS thR34d!";
$lang['clicktochangevote'] = "clICK t0 Ch4n9E V0T3";
$lang['youvotedforoption'] = "j00 VO+3D FoR oPt1ON";
$lang['youvotedforoptions'] = "j00 voT3d FOR Op+1oNs";
$lang['clicktovote'] = "cl1CK tO V0Te";
$lang['youhavenotvoted'] = "j00 h4V3 N0+ v0+ed";
$lang['viewresults'] = "v13w r35ult5";
$lang['msgtruncated'] = "m3s5@G3 trUNc4Ted";
$lang['viewfullmsg'] = "v1EW phULL MESs49E";
$lang['ignoredmsg'] = "iGN0rED Me\$S@gE";
$lang['wormeduser'] = "w0RmEd U\$3r";
$lang['ignoredsig'] = "ign0r3D S1Gn@+ur3";
$lang['messagewasdeleted'] = "m3\$s4ge %s.%s Wa\$ Del3+eD";
$lang['stopignoringthisuser'] = "sTOP 1gN0rIN9 +HiS U\$ER";
$lang['renamethread'] = "r3naM3 +hR34d";
$lang['movethread'] = "mOVe THRe4D";
$lang['editthepoll'] = "ediT +h3 p0lL";
$lang['torenamethisthread'] = "tO REn4mE TH1S ThrE4D";
$lang['closeforposting'] = "cL0\$3 PH0R P0\$T1ng";
$lang['until'] = "untiL 00:00 u+C";
$lang['approvalrequired'] = "aPPROV4l R3QuiREd";
$lang['messageawaitingapprovalbymoderator'] = "m3\$54G3 %s.%s i5 4wai+in9 @ppR0v4l 8y 4 M0D3R@+0R";
$lang['postapprovedsuccessfully'] = "p0\$+ 4PPROv3D \$UcC3\$\$pHUlly";
$lang['postapprovalfailed'] = "p0st 4PPR0v@L F41lED.";
$lang['postdoesnotrequireapproval'] = "p0St Does No+ rEqUIre apPr0V4l";
$lang['approvepost'] = "aPpR0v3 P05+ FOR d1spL4Y";
$lang['approvedbyuser'] = "aPPRoVEd: %s 8Y %s";
$lang['makesticky'] = "m@KE \$t1ckY";
$lang['messagecountdisplay'] = "%s Of %s";
$lang['linktothread'] = "p3rm@NENT l1Nk +O ThiS THr3@d";
$lang['linktopost'] = "lINK T0 p05t";
$lang['linktothispost'] = "liNk +0 thI5 pO\$+";
$lang['imageresized'] = "tH1\$ iMA9e h@S B33N r3\$1z3d (0r19InaL s1z3 %1\$sX%2\$s). +O vi3W ThE PHull-51z3 1M49E Cl1Ck H3r3.";
$lang['messagedeletedbyuser'] = "m3S\$4G3 %s.%s dELe+ed %s By %s";
$lang['messagedeleted'] = "meSS493 %s.%s w@s Del3T3d";

// Moderators list (mods_list.php) -------------------------------------

$lang['cantdisplaymods'] = "cANnO+ dISPl4y fOLd3r M0D3R4+OR\$";
$lang['moderatorlist'] = "mod3r4TOR l1St:";
$lang['modsforfolder'] = "m0dEr@+oR5 phOr pH0LdEr";
$lang['nomodsfound'] = "n0 mODeR4+or5 pH0UnD";
$lang['forumleaders'] = "fOrUM Le4DeRS:";
$lang['foldermods'] = "foLDER MoDEr4ToRS:";

// Navigation strip (nav.php) ------------------------------------------

$lang['start'] = "s+@R+";
$lang['messages'] = "mEsS4935";
$lang['pminbox'] = "in80x";
$lang['startwiththreadlist'] = "s+@R+ p493 WI+h thR34d L1\$+";
$lang['pmsentitems'] = "s3NT 1T3M\$";
$lang['pmoutbox'] = "oUt8OX";
$lang['pmsaveditems'] = "s4vED IT3M\$";
$lang['pmdrafts'] = "dR4fTS";
$lang['links'] = "lInK5";
$lang['admin'] = "adM1N";
$lang['login'] = "loG1N";
$lang['logout'] = "lOgOU+";

// PM System (pm.php, pm_write.php, pm.inc.php) ------------------------

$lang['privatemessages'] = "pRIv@+e Me\$s49e\$";
$lang['recipienttiptext'] = "sePar@+e R3C1P1en+\$ bY \$eMI-cOL0n 0r cOMm@";
$lang['maximumtenrecipientspermessage'] = "th3R3 IS @ L1miT OPH 10 R3ciPI3nT5 P3R M3SS4ge. pLe4Se @MeNd YoUr RECipi3n+ lIsT.";
$lang['mustspecifyrecipient'] = "j00 must 5P3c1PHy A+ L3@sT 0ne rec1PiEnT.";
$lang['usernotfound'] = "uSER %s N0t Ph0UNd";
$lang['sendnewpm'] = "s3nD nEw pm";
$lang['savemessage'] = "s4VE m3\$s49e";
$lang['timesent'] = "t1m3 5En+";
$lang['nomessages'] = "nO ME5sA93\$";
$lang['errorcreatingpm'] = "erRoR CRE4TiN9 Pm! ple4SE Try aG41n 1N @ feW MInUt3S";
$lang['writepm'] = "wRIt3 me\$s4g3";
$lang['editpm'] = "eDit MeS\$4ge";
$lang['cannoteditpm'] = "cAnn0T EDI+ +H1\$ pM. 1t H4s 4Lr34Dy 833n vIeWeD 8y th3 Rec1P1eN+ 0r T3h M3\$S493 dOE\$ N0t Ex1\$t 0R 1t IS 1N4cc3\$S1Bl3 8y J00";
$lang['cannotviewpm'] = "c4nN0+ ViEw PM. m3\$s49E D0E5 NO+ eX15t OR iT is 1n4CC3\$Si8L3 8Y j00";
$lang['pmmessagenumber'] = "m3\$S49E %s";

$lang['youhavexnewpm'] = "j00 h4V3 %d n3W Me\$s4GeS. w0Uld J00 LikE +0 GO +0 Y0Ur InbOx n0w?";
$lang['youhave1newpm'] = "j00 h4v3 1 New m3S5@93. WoulD J00 liKE +o G0 +O yOur 1Nb0X NoW?";
$lang['youhave1newpmand1waiting'] = "j00 h4v3 1 neW M3SS4Ge.\\n\\nY0U 4L5O h@vE 1 mE\$\$4G3 4w41+1ng DEl1V3rY. TO r3ce1V3 TH1\$ mE\$s493 pLE@5e Cl3@r SoM3 sPAc3 in yOuR 1N80X.\\n\\nWOUlD J00 liK3 +O 9O TO yOUr iN80X nOw?";
$lang['youhave1pmwaiting'] = "j00 haV3 1 ME5S49e Aw@1+1n9 D3l1v3rY. tO rEC3IvE +hIs m3\$\$49E PlE4s3 Cl3@r 5oMe 5p4Ce 1n Y0uR INBoX.\\n\\nw0Uld J00 LikE TO G0 +O y0Ur InbOx nOW?";
$lang['youhavexnewpmand1waiting'] = "j00 h@VE %d new meSS@GE\$.\\n\\nY0U Al\$O h4V3 1 MESS49E 4w4i+1n9 DELiVErY. +o RECE1V3 +h1\$ M3\$S49E Pl3@5e CL3@R \$om3 SpAce In yoUR Inb0X.\\n\\nWoUlD J00 LIKE +O G0 +o yoUR iN8OX N0W?";
$lang['youhavexnewpmandxwaiting'] = "j00 h4Ve %d neW m35S4g3\$.\\n\\nYoU @L\$O h4v3 %d m3S\$4g3S 4W4It1N9 dEL1V3RY. +0 r3cEive th3S3 mE\$S4g3 PLE4\$e cLe4R 5oM3 5p4ce 1N YOuR 1n8OX.\\n\\nwOUlD j00 LiKe +0 90 +O Y0Ur 1N80x N0w?";
$lang['youhave1newpmandxwaiting'] = "j00 H4v3 1 neW M3S\$4ge.\\n\\nyoU 4LsO h4v3 %d ME\$s4G3S @w41T1ng D3lIV3rY. +o REc3iV3 +HE\$e m3s\$493S PLe45e cLE4r SoMe \$p4C3 IN yOuR iNb0X.\\n\\nW0uLD J00 liK3 To g0 +0 yOUR In80x N0W?";
$lang['youhavexpmwaiting'] = "j00 h4VE %d m3\$S4g3\$ 4W4i+1N9 D3l1v3rY. +0 R3c31VE TH3\$E MEsS49e\$ Pl34Se cl3@r \$oMe sP4Ce 1N y0Ur 1nboX.\\n\\nW0ULD j00 LiKE +0 gO +O Y0Ur IN8OX NOW?";

$lang['youdonothaveenoughfreespace'] = "j00 d0 NoT h4V3 ENOuGH Fr33 5p4c3 +0 sEnD +Hi\$ Me\$\$aG3.";
$lang['userhasoptedoutofpm'] = "%s h@S oP+eD oUt 0F rEceIViN9 P3rS0N4L mE55@G3\$";
$lang['pmfolderpruningisenabled'] = "pM FOLdEr prUNIn9 15 EN48l3d!";
$lang['pmpruneexplanation'] = "thI\$ pH0RuM U53s PM FOLdeR PRuN1Ng. +hE m35\$4GeS J00 h4Ve \$+Or3d in y0uR in80X 4nD \$en+ 1t3m5\\npH0Ld3rS 4r3 \$u8J3Ct +0 4u+0m@t1c deLETi0n. 4ny me\$5493\$ J00 w1SH to Ke3p \$h0uLD 83 MOV3d TO\\nY0uR \\'54V3d IT3ms\\' PH0lDeR 5O +H@+ +h3Y ArE n0+ d3L3+Ed.";
$lang['yourpmfoldersare'] = "yoUr PM pH0Ld3rS @r3 %s PhULL";
$lang['currentmessage'] = "cuRr3n+ Mes\$4gE";
$lang['unreadmessage'] = "uNreaD M3\$\$4ge";
$lang['readmessage'] = "r3ad m3sS4g3";
$lang['pmshavebeendisabled'] = "p3R5ON4L M3SS4gE5 h@VE been DI\$4bLed 8Y th3 ph0rUM Owner.";
$lang['adduserstofriendslist'] = "aDD US3RS TO Y0Ur Fr1EndS l1\$+ To h4V3 thEm @pp34R IN 4 droP dOWN ON +3H Pm wR1T3 meSS@93 p4GE.";

$lang['messagesaved'] = "me\$s4g3 \$4vED";
$lang['messagewassuccessfullysavedtodraftsfolder'] = "m35\$493 w@\$ sUCc3\$\$FULly S@v3D +0 'dR4fTS' fOLd3r";
$lang['pmtooltipxmessages'] = "%s M3ssa93\$";
$lang['pmtooltip1message'] = "1 M3S\$493";

// Preferences / Profile (user_*.php) ---------------------------------------------

$lang['mycontrols'] = "my C0N+ROL5";
$lang['myforums'] = "mY f0RuMS";
$lang['menu'] = "meNU";
$lang['userexp_1'] = "us3 tEh menu 0N The L3PHt to M4N493 YoUr SE+T1n9s.";
$lang['userexp_2'] = "<b>u5Er d3+41LS</b> 4Ll0Ws J00 +O CH@N93 Your N4ME, emA1L 4DdRes5 @Nd p4\$\$Word.";
$lang['userexp_3'] = "<b>u5ER pR0F1lE</b> @llOWS j00 +0 EDit yOUr UsEr prOPH1Le.";
$lang['userexp_4'] = "<b>cH@N9e p@SswOrD</b> 4Ll0W\$ J00 t0 Ch@Ng3 y0Ur P@SSW0RD";
$lang['userexp_5'] = "<b>em@IL &amp; pr1V@Cy</b> L3+S J00 Ch4NG3 H0W J00 c4N B3 coNT4C+3d 0n @Nd oPHf +3h F0RuM.";
$lang['userexp_6'] = "<b>f0RUm 0p+10Ns</b> L3+S j00 Ch4NgE HoW Th3 FOrUM Lo0kS 4nd W0rKS.";
$lang['userexp_7'] = "<b>a+t4chMEN+S</b> 4Ll0W5 j00 +O 3diT/d3l3+3 y0UR 4+T4cHm3n+\$.";
$lang['userexp_8'] = "<b>s1gnA+uRe</b> L3TS j00 EDi+ Y0uR 5igN@tURe.";
$lang['userexp_9'] = "<b>r3L4ti0N5h1ps</b> L3TS j00 MAn@GE YOUr r3l@T1oNSh1p wItH OtH3R uSERs 0N th3 PH0RUM.";
$lang['userexp_9'] = "<b>w0Rd F1L+ER</b> L3+\$ j00 ed1+ Your Per5On4l w0rD F1l+3r.";
$lang['userexp_10'] = "<b>tHRe4D SUb\$cR1PtIOn5</b> 4Ll0wS J00 +o M4N4G3 yOUr +hR3@d sUbScR1PtI0Ns.";
$lang['userdetails'] = "uSEr det@ilS";
$lang['userprofile'] = "usER PRoF1le";
$lang['emailandprivacy'] = "eMaIL &amp; pR1V@cy";
$lang['editsignature'] = "edit \$1Gn4tUrE";
$lang['norelationships'] = "j00 h@vE N0 User reL4T10n\$H1p\$ S3T Up";
$lang['editwordfilter'] = "ed1T WOrd fILTER";
$lang['userinformation'] = "u53R InPH0rM4TiOn";
$lang['changepassword'] = "cH@N9E pASSwORd";
$lang['currentpasswd'] = "cuRren+ p45sW0RD";
$lang['newpasswd'] = "n3W pASsWOrd";
$lang['confirmpasswd'] = "coNpHiRm p@SSW0Rd";
$lang['passwdsdonotmatch'] = "p4SsW0RD5 d0 N0+ mATcH!";
$lang['nicknamerequired'] = "nickN4m3 iS R3QU1rED!";
$lang['emailaddressrequired'] = "eM41l 4dDR3ss iS ReQUiReD!";
$lang['logonnotpermitted'] = "l09ON NO+ p3rMI+TED. chOOsE @n0THeR!";
$lang['nicknamenotpermitted'] = "niCKnAME N0T pErM1++3D. cHO0\$3 4N0+hEr!";
$lang['emailaddressnotpermitted'] = "em41l @DdRE\$\$ n0+ P3rmIT+3D. chO05e @nO+h3r!";
$lang['emailaddressalreadyinuse'] = "em4il 4dDRE\$s @lRe4dy 1N use. CH0o5e 4n0+H3R!";
$lang['relationshipsupdated'] = "rEla+iON\$hIp5 UpD@TEd!";
$lang['relationshipupdatefailed'] = "rel4TI0n5H1p uPd@+3D PhA1L3D!";
$lang['preferencesupdated'] = "pR3PHerenc3S weR3 SUcC355phullY uPD4+eD.";
$lang['userdetails'] = "u\$eR DET41LS";
$lang['memberno'] = "meM83R nO.";
$lang['firstname'] = "f1r5T N4M3";
$lang['lastname'] = "l@s+ N@M3";
$lang['dateofbirth'] = "d@+3 OpH 81rTH";
$lang['homepageURL'] = "homeP4GE URl";
$lang['pictureURL'] = "pICtUr3 uRl";
$lang['forumoptions'] = "f0RUM OP+10nS";
$lang['notifybyemail'] = "notiFy 8y EM41l 0f p0S+\$ +0 ME";
$lang['notifyofnewpm'] = "notiPhY by popUp OPh N3w pm ME\$s4ge5 tO me";
$lang['notifyofnewpmemail'] = "nO+1PhY 8y eM41L 0Ph n3W Pm me\$54G3S To me";
$lang['daylightsaving'] = "aDjuST FOR d@yL1GH+ s4viN9";
$lang['autohighinterest'] = "au+Om4T1c4lLy MarK +Hr34ds 1 PoS+ 1N @s hIgh 1nt3R3S+";
$lang['convertimagestolinks'] = "aUToM4+Ic@LLY cONVerT 3m83DD3d IM@GeS IN po\$T\$ In+O LiNK5";
$lang['thumbnailsforimageattachments'] = "thUmbn4ILs pHoR 1m4gE 4+T4ChM3N+S";
$lang['smallsized'] = "smALl \$1zeD";
$lang['mediumsized'] = "m3D1Um siZ3D";
$lang['largesized'] = "l@r9E sIzEd";
$lang['globallyignoresigs'] = "gl0B@llY 1gn0Re Us3r SI9n@+ureS";
$lang['allowpersonalmessages'] = "aLL0w O+h3r U\$eR\$ To 5eNd ME P3R\$0N4l MeSSAg3S";
$lang['allowemails'] = "alL0w oTHEr usER5 To 5EnD me 3m@ILS V14 MY pR0F1lE";
$lang['timezonefromGMT'] = "tIM3 zOn3";
$lang['postsperpage'] = "pOsT\$ P3r P4G3";
$lang['fontsize'] = "f0NT SIZ3";
$lang['forumstyle'] = "f0Rum 5tYL3";
$lang['forumemoticons'] = "f0rUM 3m0+IcON\$";
$lang['startpage'] = "st4rT P4GE";
$lang['containsHTML'] = "coN+@iNs H+mL";
$lang['preferredlang'] = "pr3pHerR3D LanGU49E";
$lang['donotshowmyageordobtoothers'] = "dO n0t 5hOW my 4ge OR d4Te OPH BiR+H tO OTH3R5";
$lang['showonlymyagetoothers'] = "shoW OnlY mY @9e T0 0THERS";
$lang['showmyageanddobtoothers'] = "sh0w 80+h My 4Ge @ND d4+e Of b1r+H +0 0+h3rS";
$lang['showonlymydayandmonthofbirthytoothers'] = "shoW oNly mY d4y 4nd M0N+h oF B1r+h tO O+H3R\$";
$lang['listmeontheactiveusersdisplay'] = "l1\$+ m3 On ThE 4ct1V3 u\$3R\$ d1\$Pl@Y";
$lang['browseanonymously'] = "br0Ws3 FORuM @N0nyM0USLy";
$lang['allowfriendstoseemeasonline'] = "broWs3 4n0NyMOu\$LY, 8U+ @lL0w fRiEnDs To S3E ME @S 0nLINE";
$lang['revealspoileronmouseover'] = "rEVE4L SpO1LErs ON mOu53 0ver";
$lang['resizeimagesandreflowpage'] = "r3s1Ze 1M@93S 4ND r3fLOw p49E +o Pr3veNT H0RizOnTal \$cROLl1n9.";
$lang['showforumstats'] = "sH0W Ph0RUm ST@+s 4+ Bo+tom 0F ME\$\$@ge P4n3";
$lang['usewordfilter'] = "en@bL3 WoRD f1lTEr.";
$lang['forceadminwordfilter'] = "fOrc3 u53 OPH @DMiN w0rd F1l+3r ON 4LL Us3Rs (Inc. GuE5t\$)";
$lang['timezone'] = "tim3 ZON3";
$lang['language'] = "l@NgU@gE";
$lang['emailsettings'] = "em@IL aND c0nt@C+ S3TTIN9s";
$lang['forumanonymity'] = "f0ruM An0nYM1TY S3Tt1Ng\$";
$lang['birthdayanddateofbirth'] = "b1r+Hd@y 4ND da+3 0f B1RtH D1\$pl4y";
$lang['includeadminfilter'] = "incLudE admIn W0Rd f1ltEr 1N My li5T.";
$lang['setforallforums'] = "s3T PhOR 4LL FORuM\$?";
$lang['containsinvalidchars'] = "coN+4iN3D iNv4l1D cH@r4Ct3r5!";
$lang['postpage'] = "pOS+ P4G3";
$lang['nohtmltoolbar'] = "no h+ml T0OL84R";
$lang['displaysimpletoolbar'] = "di\$pl@y siMPLe HTml +o0l84R";
$lang['displaytinymcetoolbar'] = "d15PL4Y WYS1wy9 htmL +oOL8@R";
$lang['displayemoticonspanel'] = "d1SPL4y 3m0+iCoN\$ PAN3l";
$lang['displaysignature'] = "dIsPL4y S19n4Tur3";
$lang['disableemoticonsinpostsbydefault'] = "d1\$48l3 3M0TicOn\$ in m3\$5@gES 8y D3FaUL+";
$lang['automaticallyparseurlsbydefault'] = "auTom4T1c4lLy p@rSe uRl\$ in M35S4g3\$ bY dePH4uLT";
$lang['postinplaintextbydefault'] = "p05+ 1N pla1N tEXt 8Y DEph@ult";
$lang['postinhtmlwithautolinebreaksbydefault'] = "poS+ 1n Html w1Th 4u+O-liN3-BR3@Ks bY d3F4uL+";
$lang['postinhtmlbydefault'] = "pO\$+ in H+ML By depHAUl+";
$lang['privatemessageoptions'] = "pRIV4+e mEs\$493 oP+1onS";
$lang['privatemessageexportoptions'] = "pRIv4+E M3554Ge 3xpOR+ 0p+10NS";
$lang['savepminsentitems'] = "s@vE 4 c0Py 0f e4Ch pm I 53ND 1n My S3nt 1t3M\$ PH0LDEr";
$lang['includepminreply'] = "iNCluDe me554ge b0DY WheN rEplY1n9 +0 pm";
$lang['autoprunemypmfoldersevery'] = "aU+o PRUn3 MY PM FOld3R5 3VerY:";
$lang['friendsonly'] = "fRi3nDS oNLY?";
$lang['globalstyles'] = "gL0b@L s+YleS";
$lang['forumstyles'] = "f0RuM StylEs";

// Polls (create_poll.php, poll_results.php) ---------------------------------------------

$lang['mustprovideanswergroups'] = "j00 MUs+ Pr0V1DE \$OME 4N\$Wer 9roUP5";
$lang['mustprovidepolltype'] = "j00 mUS+ PrOv1d3 @ P0Ll +Yp3";
$lang['mustprovidepollresultsdisplaytype'] = "j00 MUs+ pr0v1dE R3sUL+5 d1\$pL4y TYPe";
$lang['mustprovidepollvotetype'] = "j00 Mu\$+ pROVid3 4 P0LL V0+e +yP3";
$lang['mustprovidepollguestvotetype'] = "j00 MU\$+ \$pEc1pHY IF GUE\$t\$ SH0uld B3 @lL0Wed +o V0Te";
$lang['mustprovidepolloptiontype'] = "j00 MU5T PROvidE A poLl 0P+1on Typ3";
$lang['mustprovidepollchangevotetype'] = "j00 mus+ PROv1De @ P0Ll CH@N93 Vo+e TYPe";
$lang['pleaseselectfolder'] = "ple@Se \$3LECT @ ph0Ld3r";
$lang['mustspecifyvalues1and2'] = "j00 MUst sPEc1PHy v4lU3\$ FOR an5WErs 1 4ND 2";
$lang['tablepollmusthave2groups'] = "t48UL4R foRm4t P0lL\$ MUS+ H@v3 PR3C15ElY tWO v0+1N9 9R0UPS";
$lang['nomultivotetabulars'] = "t48ul4R fORm4t p0LLS c4nN0T 8e MUl+i-V0TE";
$lang['nomultivotepublic'] = "pubL1c 84LLOt\$ C4Nn0t be MuL+1-vO+e";
$lang['abletochangevote'] = "j00 wILL b3 a8L3 tO cH4n93 y0ur v0+3.";
$lang['abletovotemultiple'] = "j00 W1LL be 4Bl3 T0 VO+3 muL+1PLE +iMes.";
$lang['notabletochangevote'] = "j00 w1ll N0T 8E 4bl3 +O ch4N9e Y0UR V0+3.";
$lang['pollvotesrandom'] = "n0+e: p0Ll V0Te\$ 4Re r@ndOMLy 93nErATeD F0R pR3ViEW 0NlY.";
$lang['pollquestion'] = "p0Ll Qu3s+1ON";
$lang['possibleanswers'] = "pOs5IbLE aN\$W3RS";
$lang['enterpollquestionexp'] = "eN+3R +h3 @NswErS PhOR YoUR P0Ll Qu3\$tI0N.. 1Ph y0Ur P0lL I5 @ &quot;Yes/N0&quot; qUES+I0N, 51MplY 3n+ER &quot;yEs&quot; ph0r 4NSw3R 1 4nd &quot;N0&quot; PhOr aN\$W3R 2.";
$lang['numberanswers'] = "nO. 4NSwER\$";
$lang['answerscontainHTML'] = "anSW3R\$ CONt4In h+mL (nO+ InclUdiNg s1Gn4+ure)";
$lang['optionsdisplay'] = "an\$wers dispL4Y TyPe";
$lang['optionsdisplayexp'] = "h0W shouLd T3h @NSwER\$ b3 Pr3\$ENt3d?";
$lang['dropdown'] = "aS dr0p-DowN List(\$)";
$lang['radios'] = "a5 @ 53R1eS oF R4D10 8u++oNs";
$lang['votechanging'] = "vO+E ch4n9iN9";
$lang['votechangingexp'] = "c4n 4 pER5On CHanGe hIs 0R h3R Vo+3?";
$lang['guestvoting'] = "gUESt vO+ing";
$lang['guestvotingexp'] = "c4N 9u35T\$ V0+E 1N +h1S poLL?";
$lang['allowmultiplevotes'] = "all0w mULT1pLE v0+e\$";
$lang['pollresults'] = "p0Ll REsULT\$";
$lang['pollresultsexp'] = "h0w W0uld J00 lik3 +o diSPl4Y tH3 rESuL+S oF Your P0lL?";
$lang['pollvotetype'] = "p0ll vO+INg +ypE";
$lang['pollvotesexp'] = "hoW sh0uld +3H P0ll bE CoNDuC+3d?";
$lang['pollvoteanon'] = "aNoNYm0u\$ly";
$lang['pollvotepub'] = "pu8l1C b@Ll0T";
$lang['horizgraph'] = "h0R1Z0N+4L GR4Ph";
$lang['vertgraph'] = "v3R+1c4L gR4Ph";
$lang['tablegraph'] = "t@BuL@r PH0RM@T";
$lang['polltypewarning'] = "<b>w@RN1nG</b>: Th1S 15 4 pUBliC 84lLoT. YOUr n@M3 WilL 83 vi\$I8Le nex+ +O +h3 0P+10n j00 v0+3 pH0r.";
$lang['expiration'] = "eXp1R4+I0N";
$lang['showresultswhileopen'] = "do j00 W4NT +O \$h0w rE5uLt\$ WHiLE +eh p0Ll I5 oPEN?";
$lang['whenlikepollclose'] = "wH3N would J00 l1k3 YOuR PolL To aUtOM4+ic4LLY cl0\$e?";
$lang['oneday'] = "on3 d@y";
$lang['threedays'] = "tHREE d4y\$";
$lang['sevendays'] = "sEv3N d4Y\$";
$lang['thirtydays'] = "tHiRtY d@YS";
$lang['never'] = "nEVEr";
$lang['polladditionalmessage'] = "aDD1t1oN4l me\$\$@93 (OpT1on4L)";
$lang['polladditionalmessageexp'] = "d0 J00 wAn+ To 1ncLUd3 4N 4ddITion4L P0sT 4pH+3r THE pOLL?";
$lang['mustspecifypolltoview'] = "j00 mUs+ 5p3CIfy @ POLl TO V13W.";
$lang['pollconfirmclose'] = "arE J00 SurE J00 wAN+ t0 cL0\$E +h3 f0ll0w1N9 pOlL?";
$lang['endpoll'] = "enD pOLL";
$lang['nobodyvotedclosedpoll'] = "n0b0Dy v0+ED";
$lang['votedisplayopenpoll'] = "%s @nd %s H@vE v0+3d.";
$lang['votedisplayclosedpoll'] = "%s @Nd %s v0T3D.";
$lang['nousersvoted'] = "n0 uS3r\$";
$lang['oneuservoted'] = "1 U\$er";
$lang['xusersvoted'] = "%s u5ER\$";
$lang['noguestsvoted'] = "n0 9U3S+s";
$lang['oneguestvoted'] = "1 9u35t";
$lang['xguestsvoted'] = "%s GueST\$";
$lang['pollhasended'] = "p0lL H@s 3Nd3D";
$lang['youvotedforpolloptionsondate'] = "j00 v0+eD fOR %s 0n %s";
$lang['thisisapoll'] = "tH15 IS @ p0lL. CliCk +0 ViEW r3sulT\$.";
$lang['editpoll'] = "eDi+ p0Ll";
$lang['results'] = "r35UL+S";
$lang['resultdetails'] = "r3\$ulT d3+4ILS";
$lang['changevote'] = "cH4ngE Vo+E";
$lang['pollshavebeendisabled'] = "p0llS haVe 8Een d15A8Led 8y THe fOrUM 0wNEr.";
$lang['answertext'] = "anSw3R +3X+";
$lang['answergroup'] = "aN\$w3R 9R0uP";
$lang['previewvotingform'] = "pReViEW vo+1N9 pH0Rm";
$lang['viewbypolloption'] = "vIEW bY p0ll 0P+I0N";
$lang['viewbyuser'] = "v1Ew bY usEr";

// Profiles (profile.php) ----------------------------------------------

$lang['editprofile'] = "eD1+ pr0F1lE";
$lang['profileupdated'] = "pR0f1L3 UPDa+3D.";
$lang['profilesnotsetup'] = "thE foRuM oWnER H45 No+ S3T uP PROFiL35.";
$lang['ignoreduser'] = "i9N0R3D usEr";
$lang['lastvisit'] = "l4St Vi51t";
$lang['totaltimeinforum'] = "tOt@l +im3";
$lang['longesttimeinforum'] = "l0NG3St \$E\$\$1oN";
$lang['sendemail'] = "sEnd Em41L";
$lang['sendpm'] = "s3Nd PM";
$lang['visithomepage'] = "v1\$1t h0MEp4G3";
$lang['age'] = "ag3";
$lang['aged'] = "aG3d";
$lang['birthday'] = "biRTHd4y";
$lang['registered'] = "rE9I\$t3r3D";
$lang['findusersposts'] = "f1Nd Us3R'\$ pO5t\$";
$lang['findmyposts'] = "f1nd My P0st\$";

// Registration (register.php) -----------------------------------------

$lang['newuserregistrationsarenotpermitted'] = "soRrY, NeW U53r R3G1\$tr@tIOn\$ 4rE N0T @lLoW3D rIGhT NOw. pl3@53 ch3Ck 84Ck L4t3R.";
$lang['usernameinvalidchars'] = "u53Rn4m3 C@n 0Nly coN+41N 4-z, 0-9, _ - cHaR@CTeRS";
$lang['usernametooshort'] = "uS3rn4Me Mu5t b3 4 mInimUm Of 2 ChArAc+ER5 L0n9";
$lang['usernametoolong'] = "u53RNaME mu\$+ b3 @ M4xIMuM 0F 15 cH@r4c+3rS lOn9";
$lang['usernamerequired'] = "a L09oN n4Me i\$ r3qU1R3d";
$lang['passwdmustnotcontainHTML'] = "p@sSw0RD MuS+ n0t C0N+4In h+ML t@GS";
$lang['passwordinvalidchars'] = "p@SSword c4N 0NlY C0N+4In A-Z, 0-9, _ - Ch@rAc+3R\$";
$lang['passwdtooshort'] = "p@\$sW0Rd mU5+ 83 4 min1MUm OpH 6 Ch4r4CTers L0N9";
$lang['passwdrequired'] = "a p@S\$w0rD i5 r3qUiR3D";
$lang['confirmationpasswdrequired'] = "a c0NpHIrma+IoN p4S\$Word 1\$ Requ1ReD";
$lang['nicknamerequired'] = "a N1CkN@m3 1s r3QuIreD";
$lang['emailrequired'] = "an 3MAiL 4DdR3\$s 1\$ R3Qu1r3D";
$lang['passwdsdonotmatch'] = "p@SSw0rds D0 no+ m4+Ch";
$lang['usernamesameaspasswd'] = "uS3Rn4m3 @ND P@S5W0Rd Mu\$T 8E dIPhPh3reNt";
$lang['usernameexists'] = "s0RRY, 4 U\$3r WIth th4t nAme 4lre4Dy exis+\$";
$lang['successfullycreateduseraccount'] = "sUCCeS5fullY CRE4tEd u\$3r 4cCoUn+";
$lang['useraccountcreatedconfirmfailed'] = "y0ur us3R 4ccOUN+ h@S b3En CrE@TED 8uT The R3QuIR3d CoNPhIrmA+10N 3M@1l Wa\$ N0+ S3N+. pLE4sE C0Nt@c+ +he F0RuM 0Wn3r t0 r3ct1phy Th1s. in +HI5 MeaNtime pLe453 cL1Ck teH c0n+INU3 8u+tON T0 l09IN 1n.";
$lang['useraccountcreatedconfirmsuccess'] = "yOUr uS3r 4cC0uNt h4s bE3n cR3@+3d 8UT b3Ph0r3 j00 c@N \$+4rT PO\$tin9 J00 mu5t c0NF1Rm y0uR 3M4il 4ddReS5. PLe4\$3 CHecK yOUR em4iL f0R 4 LInk Th@T WiLL 4LL0W j00 To c0NpH1Rm yoUr aDdres\$.";
$lang['useraccountcreated'] = "y0UR u\$3R 4cc0UnT H@s b33N cR3@TEd Succ35sFUlLy! cl1cK t3H cONTInuE BUt+oN b3l0w t0 LOg1n";
$lang['errorcreatinguserrecord'] = "erROr crEA+InG US3r r3cORD";
$lang['userregistration'] = "us3R re915+R4+10n";
$lang['registrationinformationrequired'] = "reGis+Ra+1oN 1NPh0rm4+i0N (R3qU1r3D)";
$lang['profileinformationoptional'] = "pr0PHIl3 INFoRM4ti0N (OPT10n4L)";
$lang['preferencesoptional'] = "pr3PHER3Nc35 (oP+10n4l)";
$lang['register'] = "r391\$t3R";
$lang['rememberpasswd'] = "rEM3m83r P@5sw0rd";
$lang['birthdayrequired'] = "y0UR D@T3 0f b1R+H 1S RequIr3D or i\$ 1nV4L1D";
$lang['alwaysnotifymeofrepliestome'] = "n0+1pHY 0n REPlY tO Me";
$lang['notifyonnewprivatemessage'] = "n0+1FY 0n n3w PRiv4+E M3S\$49E";
$lang['popuponnewprivatemessage'] = "poP uP On N3W PR1VaTe m3\$S493";
$lang['automatichighinterestonpost'] = "au+0M4+iC Hi9h INt3r3\$t On P0St";
$lang['confirmpassword'] = "c0NPH1rm paS\$WoRd";
$lang['invalidemailaddressformat'] = "iNV4l1D 3m@1L 4ddr35\$ ph0rm@t";
$lang['moreoptionsavailable'] = "moR3 PROF1lE 4nd prEFER3nC3 OPt1ONs 4Re 4v41lA8l3 onCe j00 r3G1sT3r";
$lang['textcaptchaconfirmation'] = "c0npHiRm4+I0N";
$lang['textcaptchaexplain'] = "t0 +hE R1Gh+ 1S 4 +EX+-c4P+cH@ 1m@ge. PleA\$3 +ype ThE cODe j00 C@N \$E3 In +H3 1M@93 1nTO +3H iNPuT F13Ld 83L0w I+.";
$lang['textcaptchaimgtip'] = "th15 iS a C@pTCH4-P1CTuRE. 1+ 1s UsEd T0 PR3VEn+ 4utOM4+1c RegIS+R@+ION";
$lang['textcaptchamissingkey'] = "a cOnF1Rm@tIon C0de 1\$ R3QuiReD.";
$lang['textcaptchaverificationfailed'] = "t3X+-c4ptCH4 V3RiF1C4+IoN cOdE W@s 1ncOrRect. pL3@se r3-3N+Er 1+.";

// Recent visitors list  (visitor_log.php) -----------------------------

$lang['member'] = "memB3r";
$lang['searchforusernotinlist'] = "s34rch PhOR @ U\$3r NOT iN List";
$lang['yoursearchdidnotreturnanymatches'] = "y0UR s34rCh d1D no+ r3tURn 4Ny M@+cH3\$. try \$1MpLiFy1N9 y0Ur \$34RcH P@r4m3T3RS 4nd +ry 4g4In.";
$lang['hiderowswithemptyornullvalues'] = "h1dE r0wS W1+H eMp+Y OR NUll V4lu35 1n SeL3Cted C0LumNs";
$lang['showregisteredusersonly'] = "sh0w rEgI5T3reD USeRS onLy (hid3 gU35TS)";

// Relationships (user_rel.php) ----------------------------------------

$lang['relationships'] = "r3l@Ti0n5Hip\$";
$lang['userrelationship'] = "uSeR R3LA+10n5H1P";
$lang['userrelationships'] = "us3R r3laTI0n5h1PS";
$lang['friends'] = "fRi3nd\$";
$lang['ignoredcompletely'] = "i9n0REd c0MplETelY";
$lang['relationship'] = "rEL4T1On5H1P";
$lang['restorenickname'] = "rE\$toR3 u5Er'S nickN@mE";
$lang['friend_exp'] = "u53R's poS+5 M4Rk3d w1+H 4 &quot;phrIEnd&quot; 1c0N.";
$lang['normal_exp'] = "u53R'S pO\$Ts @PP3@r 4s NOrM4L.";
$lang['ignore_exp'] = "u\$er'\$ p0sT\$ 4RE H1Dd3N.";
$lang['ignore_completely_exp'] = "thREaDS @nd po5T\$ tO 0R phR0M UsEr wILl @PPE4R dEL3t3d.";
$lang['display'] = "d1sPL4y";
$lang['displaysig_exp'] = "u53r'S s1GN@+Ur3 I5 dIsPl4y3D 0n tHeIr pOSt5.";
$lang['hidesig_exp'] = "u53r'\$ SI9N4+URE 15 HidDEn 0N th3Ir pO5t5.";
$lang['cannotignoremod'] = "j00 cannO+ iGnoR3 +HI5 usEr, @s Th3y ARE a MOd3R@T0R.";

// Search (search.php) -------------------------------------------------

$lang['searchresults'] = "sE@Rch R3\$UL+5";
$lang['usernamenotfound'] = "th3 u5erN@M3 J00 SPEcif13D In thE To oR FROm pH13ld W45 n0T Ph0UnD.";
$lang['notexttosearchfor'] = "one 0R 4lL OPh YoUr \$3Arch kEyW0RdS WErE inV4lid. \$E4rCH k3yW0rD\$ mUs+ 83 n0 sHOrTeR +h@n %d Ch4r@cTErS, n0 l0n9er +HaN %d cH4R4Ct3r\$ 4Nd MU5+ nO+ 4pP34R 1N +He %s";
$lang['mysqlstopwordlist'] = "mySql \$TOPw0rd lI\$+";
$lang['foundzeromatches'] = "fOuNd: 0 M4TCH35";
$lang['found'] = "fOunD";
$lang['matches'] = "m4+ch3S";
$lang['prevpage'] = "pRev10U5 p@g3";
$lang['findmore'] = "fINd mOrE";
$lang['searchmessages'] = "se@RcH M35\$493S";
$lang['searchdiscussions'] = "se@RCh d1ScuS\$1ON\$";
$lang['find'] = "f1Nd";
$lang['additionalcriteria'] = "add1t1OnaL cRi+3r14";
$lang['searchbyuser'] = "s3@Rch 8y U5Er (oP+i0n@L)";
$lang['folderbrackets_s'] = "f0Ld3r(S)";
$lang['postedfrom'] = "pOsTed frOm";
$lang['postedto'] = "po\$+eD +0";
$lang['today'] = "t0d4Y";
$lang['yesterday'] = "ye\$TErD4Y";
$lang['daybeforeyesterday'] = "d4Y b3Ph0R3 Y35+eRd@Y";
$lang['weekago'] = "%s W3EK 49o";
$lang['weeksago'] = "%s w33K5 49O";
$lang['monthago'] = "%s mON+h @g0";
$lang['monthsago'] = "%s Mon+h\$ 49O";
$lang['yearago'] = "%s Y34R 4G0";
$lang['beginningoftime'] = "be9InniN9 oF TImE";
$lang['now'] = "n0W";
$lang['lastpostdate'] = "l4st P05T dAte";
$lang['numberofreplies'] = "nUmb3R OpH R3Pl13S";
$lang['foldername'] = "f0lD3R N4mE";
$lang['authorname'] = "aUtHOR N4m3";
$lang['decendingorder'] = "newE\$t F1RsT";
$lang['ascendingorder'] = "oLde\$T phir\$+";
$lang['keywords'] = "k3YwOrd5";
$lang['sortby'] = "s0R+ bY";
$lang['sortdir'] = "s0rT dIR";
$lang['sortresults'] = "sOr+ rEsUl+s";
$lang['groupbythread'] = "gRouP By +hRe4D";
$lang['postsfromuser'] = "pOsT\$ FrOM uS3r";
$lang['poststouser'] = "p0ST5 to usER";
$lang['poststoandfromuser'] = "p05T\$ tO 4nD pHRoM user";
$lang['searchfrequencyerror'] = "j00 c@n 0nlY se4RCh 0NcE EVerY %s \$ecOnd\$. Pl34SE TRy @g4in l4T3R.";

// Search Popup (search_popup.php) -------------------------------------

$lang['select'] = "seLEC+";
$lang['searchforthread'] = "sE4RcH F0R +HRe4D";
$lang['mustspecifytypeofsearch'] = "j00 MU\$t \$pEcIfY tyP3 0f 534rCh +o P3rf0RM";
$lang['unkownsearchtypespecified'] = "unKNOWn S3@RCh TyP3 \$PEc1PHi3d";

// Start page (start_left.php) -----------------------------------------

$lang['recentthreads'] = "rEC3N+ ThreADs";
$lang['startreading'] = "s+ARt r34dIn9";
$lang['threadoptions'] = "thRE4d OP+10nS";
$lang['editthreadoptions'] = "eD1T +hR34D 0Pt1oNS";
$lang['morevisitors'] = "m0re vIS1+0rS";
$lang['forthcomingbirthdays'] = "fOrtHc0MIn9 B1r+Hd4YS";

// Start page (start_main.php) -----------------------------------------

$lang['editstartpage_help'] = "j00 c4N 3dIt Thi5 p493 phrOM TH3 4dM1n InTerF4c3";
$lang['uploadstartpage'] = "uPL04d St4r+ P4G3 (%s)";
$lang['invalidfiletypeerror'] = "fiLe +YpE N0T 5UpP0R+Ed. j00 C4N 0nlY U53 *.+XT, *.pHP 4nD *.h+m F1L3s @S y0UR s+@R+ p@9e.";

// Thread navigation (thread_list.php) ---------------------------------

$lang['newdiscussion'] = "n3w dIscu5S1on";
$lang['createpoll'] = "cR34+3 P0ll";
$lang['search'] = "se4Rch";
$lang['searchagain'] = "s3@RCH @94iN";
$lang['alldiscussions'] = "aLl d1SCu\$51OnS";
$lang['unreaddiscussions'] = "uNrEaD d1scUssIOn5";
$lang['unreadtome'] = "uNr3Ad &quot;To: Me&quot;";
$lang['todaysdiscussions'] = "tOd4Y'S D15CUsS1Ons";
$lang['2daysback'] = "2 D4y\$ b4cK";
$lang['7daysback'] = "7 d4Y\$ 84CK";
$lang['highinterest'] = "h19H iN+er3S+";
$lang['unreadhighinterest'] = "unr34D h19H 1Nt3r35t";
$lang['iverecentlyseen'] = "i've r3ceNtly s3en";
$lang['iveignored'] = "i'vE igN0Red";
$lang['byignoredusers'] = "by 1gNOrED U\$ERS";
$lang['ivesubscribedto'] = "i'VE su8\$CR1bed +O";
$lang['startedbyfriend'] = "sT@R+3D bY FRi3Nd";
$lang['unreadstartedbyfriend'] = "uNRe4D s+D 8Y FrI3Nd";
$lang['startedbyme'] = "st4rT3D 8y me";
$lang['unreadtoday'] = "unR34D T0D@y";
$lang['deletedthreads'] = "d3L3+3d ThR3@ds";
$lang['goexcmark'] = "g0!";
$lang['folderinterest'] = "f0Lder 1nt3r3\$t";
$lang['postnew'] = "pOsT nEw";
$lang['currentthread'] = "cURr3N+ thRE4d";
$lang['highinterest'] = "hI9h iN+3r3\$T";
$lang['markasread'] = "mARK @s r34D";
$lang['next50discussions'] = "n3X+ 50 DiScU\$s10n5";
$lang['visiblediscussions'] = "visI8l3 dISCuSsIoNS";
$lang['selectedfolder'] = "selEc+ed F0Ld3R";
$lang['navigate'] = "n@vig4+e";
$lang['couldnotretrievefolderinformation'] = "there 4R3 N0 f0LderS 4V4iL4Bl3.";
$lang['nomessagesinthiscategory'] = "nO M3SS@ges 1n TH15 c4+E9ORY. Pl34se seLect @n0+h3R, 0R";
$lang['clickhere'] = "cl1CK H3R3";
$lang['forallthreads'] = "f0R 4lL THrE4d5";
$lang['prev50threads'] = "preVI0uS 50 thR3@d\$";
$lang['next50threads'] = "n3x+ 50 ThR34DS";
$lang['nextxthreads'] = "nEx+ %s +Hr34d\$";
$lang['threadstartedbytooltip'] = "thr34D #%s st4RT3d 8Y %s. viEW3d %s";
$lang['threadviewedonetime'] = "1 T1Me";
$lang['threadviewedtimes'] = "%d +1m3S";
$lang['unreadthread'] = "unrE4D thr3ad";
$lang['readthread'] = "r34d +HR3Ad";
$lang['unreadmessages'] = "unrE4d M3\$\$4geS";
$lang['subscribed'] = "su8sCr18eD";
$lang['ignorethisfolder'] = "ign0re Th1s fOlDeR";
$lang['stopignoringthisfolder'] = "s+0P i9N0rInG +H1s Ph0LD3R";
$lang['stickythreads'] = "stIcKy tHr3AdS";
$lang['mostunreadposts'] = "mo\$+ UNr34d pO\$+5";
$lang['onenew'] = "%d N3W";
$lang['manynew'] = "%d N3W";
$lang['onenewoflength'] = "%d n3w Of %d";
$lang['manynewoflength'] = "%d n3W 0pH %d";
$lang['ignorefolderconfirm'] = "arE j00 sUR3 j00 W4N+ to 19noRE thI5 ph0Ld3r?";
$lang['unignorefolderconfirm'] = "aRe J00 \$ur3 j00 w4nT +o \$T0P iGnOr1n9 THIs PholDEr?";
$lang['gotofirstpostinthread'] = "g0 to F1rS+ P0\$t In +HR34D";
$lang['gotolastpostinthread'] = "go T0 L@S+ Po\$+ 1n ThrE@D";
$lang['viewmessagesinthisfolderonly'] = "v13W m3\$\$4gEs 1N +hI\$ ph0LdeR OnLy";
$lang['shownext50threads'] = "sH0W n3Xt 50 THR34d\$";
$lang['showprev50threads'] = "show PReV1ou\$ 50 +Hr3@d\$";
$lang['createnewdiscussioninthisfolder'] = "crE@+3 nEw D15cUSsIOn 1N +H1S ph0lD3R";

// HTML toolbar (htmltools.inc.php) ------------------------------------
$lang['bold'] = "b0Ld";
$lang['italic'] = "it4l1c";
$lang['underline'] = "unDErl1Ne";
$lang['strikethrough'] = "s+rIK3+HROuGH";
$lang['superscript'] = "suPeRsCRiP+";
$lang['subscript'] = "subSCr1P+";
$lang['leftalign'] = "leFT-@lI9n";
$lang['center'] = "c3n+Er";
$lang['rightalign'] = "rIgh+-4L19n";
$lang['numberedlist'] = "nuMb3ReD LISt";
$lang['list'] = "li5+";
$lang['indenttext'] = "iNdEN+ t3X+";
$lang['code'] = "c0d3";
$lang['quote'] = "qUo+3";
$lang['spoiler'] = "sp01l3R";
$lang['horizontalrule'] = "hOR1ZOnTAL rULE";
$lang['image'] = "iM4g3";
$lang['hyperlink'] = "hyP3rLiNk";
$lang['noemoticons'] = "d1548le EM0+1C0ns";
$lang['fontface'] = "f0N+ PH4C3";
$lang['size'] = "s1ZE";
$lang['colour'] = "coLOUr";
$lang['red'] = "r3D";
$lang['orange'] = "orANg3";
$lang['yellow'] = "y3lLoW";
$lang['green'] = "greeN";
$lang['blue'] = "blu3";
$lang['indigo'] = "inDIGo";
$lang['violet'] = "v1olet";
$lang['white'] = "wH1+3";
$lang['black'] = "bL4CK";
$lang['grey'] = "gr3Y";
$lang['pink'] = "p1NK";
$lang['lightgreen'] = "liGHT GREeN";
$lang['lightblue'] = "ligHt blUE";

// Forum Stats (messages.inc.php - messages_forum_stats()) -------------

$lang['forumstats'] = "f0Rum S+4+S";
$lang['usersactiveinthepasttimeperiod'] = "%s aC+1V3 1N tEh P@S+ %s.";

$lang['numactiveguests'] = "<b>%s</b> 9U3\$+\$";
$lang['oneactiveguest'] = "<b>1</b> GU35T";
$lang['numactivemembers'] = "<b>%s</b> m3Mber5";
$lang['oneactivemember'] = "<b>1</b> M3M8eR";
$lang['numactiveanonymousmembers'] = "<b>%s</b> 4N0Nym0u\$ memb3r\$";
$lang['oneactiveanonymousmember'] = "<b>1</b> AN0Nym0U\$ m3M8Er";

$lang['numthreadscreated'] = "<b>%s</b> tHRe4DS";
$lang['onethreadcreated'] = "<b>1</b> +hrE@d";
$lang['numpostscreated'] = "<b>%s</b> PO\$+S";
$lang['onepostcreated'] = "<b>1</b> P0sT";

$lang['younormal'] = "j00";
$lang['youinvisible'] = "j00 (inVIS18lE)";
$lang['viewcompletelist'] = "vI3W cOmpLeT3 L1s+";
$lang['ourmembershavemadeatotalofnumthreadsandnumposts'] = "our MeM8eR5 h@V3 m4d3 @ +0t4L 0pH %s 4nd %s.";
$lang['longestthreadisthreadnamewithnumposts'] = "longE\$T +hR3@d 1\$ <b>%s</b> WI+h %s.";
$lang['therehavebeenxpostsmadeinthelastsixtyminutes'] = "th3rE H@v3 b33n <b>%s</b> p0st\$ m@DE 1N +h3 l4\$t 60 m1Nut3\$.";
$lang['therehasbeenonepostmadeinthelastsxityminutes'] = "theRe hAs b3EN <b>1</b> pO\$T M@de 1N +HE L@5T 60 miNuTE5.";
$lang['mostpostsevermadeinasinglesixtyminuteperiodwasnumposts'] = "mO\$+ p0ST5 Ever M4DE in 4 SiN9le 60 mINUtE PErIOD i5 <b>%s</b> 0n %s.";
$lang['wehavenumregisteredmembersandthenewestmemberismembername'] = "wE h@V3 <b>%s</b> re9IsT3ReD M3mbErS 4Nd Teh neW3\$+ M3m8Er 1s <b>%s</b>.";
$lang['wehavenumregisteredmember'] = "we H@VE %s r39I\$TeRed MEm8ers.";
$lang['wehaveoneregisteredmember'] = "wE h4ve On3 r39i5T3r3D M3Mb3r.";
$lang['mostuserseveronlinewasnumondate'] = "m0S+ u\$3rs eV3R 0nL1Ne W4S <b>%s</b> oN %s.";
$lang['statsdisplayenabled'] = "st4+\$ dI5pL4y 3Na8L3d";

// Thread Options (thread_options.php) ---------------------------------

$lang['updatesmade'] = "upD4+3S m4De";
$lang['useroptions'] = "uS3R 0P+Ion5";
$lang['markedasread'] = "m4rk3D @5 rE4D";
$lang['postsoutof'] = "poST\$ Ou+ Oph";
$lang['interest'] = "in+er35t";
$lang['closedforposting'] = "cL0\$eD PHoR P0S+In9";
$lang['locktitleandfolder'] = "loCk tItl3 @ND Ph0Ld3r";
$lang['deletepostsinthreadbyuser'] = "d3l3tE Po5T\$ 1N +Hre4D By useR";
$lang['deletethread'] = "d3Let3 tHRe@D";
$lang['permenantlydelete'] = "p3Rmen@n+ly DeL3t3";
$lang['movetodeleteditems'] = "m0v3 +0 d3Le+ED +Hr34D\$";
$lang['undeletethread'] = "unD3lEtE +HRE@d";
$lang['threaddeletedpermenantly'] = "thr34D DEl3t3D PerM4n3nTly. c@nN0T Und3L3t3.";
$lang['markasunread'] = "m@Rk 4S Unre4d";
$lang['makethreadsticky'] = "m@kE ThRE@d \$t1CKy";
$lang['threareadstatusupdated'] = "thrE@D R3@d \$+4+US upd4tED sUCCe\$SfULlY";
$lang['interestupdated'] = "tHre4D 1nTeRe\$t \$t4tU\$ UpD@T3D 5Ucc3S5FUllY";

// Dictionary (dictionary.php) -----------------------------------------

$lang['dictionary'] = "dICTi0NaRy";
$lang['spellcheck'] = "sp3Ll Ch3cK";
$lang['notindictionary'] = "n0+ In diCtioN4ry";
$lang['changeto'] = "cH4n93 t0";
$lang['initialisingdotdotdot'] = "in1T14L1\$1n9...";
$lang['spellcheckcomplete'] = "sp3ll Ch3ck 15 C0Mpl3+E. dO j00 w1SH t0 \$+4r+ A941n FrOm tHe 839INNIN9?";
$lang['spellcheck'] = "sP3LL CH3CK";
$lang['noformobj'] = "n0 F0rM 08JEcT \$p3c1F13d f0r Re+uRN +3X+";
$lang['bodytext'] = "bODY +3XT";
$lang['ignore'] = "ign0rE";
$lang['ignoreall'] = "iGNoR3 alL";
$lang['change'] = "ch4n93";
$lang['changeall'] = "ch4NgE 4lL";
$lang['add'] = "aDD";
$lang['suggest'] = "su9GE\$t";
$lang['nosuggestions'] = "(n0 \$u993\$+10N\$)";
$lang['ok'] = "ok";
$lang['cancel'] = "c@ncEL";
$lang['dictionarynotinstalled'] = "n0 D1Ct10n4rY h4s B3EN 1NS+@lLEd. pl3a\$3 cONt@cT +Eh pH0RUm oWNer +0 rEmEDy tH1s.";

// Permissions keys ----------------------------------------------------

$lang['postreadingallowed'] = "p0\$+ re4DiNG @Ll0weD";
$lang['postcreationallowed'] = "p0S+ cre4TIoN 4Ll0wed";
$lang['threadcreationallowed'] = "tHrE4D cR3@+10n 4LlOW3d";
$lang['posteditingallowed'] = "pOst 3DIt1n9 4ll0W3D";
$lang['postdeletionallowed'] = "pO\$T DELeTiOn 4lLoW3D";
$lang['attachmentsallowed'] = "a++4ChM3NTs 4LlOWeD";
$lang['htmlpostingallowed'] = "htMl Post1NG 4llow3D";
$lang['signatureallowed'] = "sigN@TuR3 4LL0wed";
$lang['guestaccessallowed'] = "gu3\$T @CC3\$5 allOWed";
$lang['postapprovalrequired'] = "pO5t @pPR0v@L reQuIrED";

// RSS feeds gubbins

$lang['rssfeed'] = "r55 Fe3D";
$lang['every30mins'] = "eVerY 30 m1Nu+E\$";
$lang['onceanhour'] = "oNc3 4N H0UR";
$lang['every6hours'] = "eV3Ry 6 hOUrs";
$lang['every12hours'] = "evEry 12 H0Ur\$";
$lang['onceaday'] = "onCE @ DAy";
$lang['rssfeeds'] = "rs5 PhE3D\$";
$lang['feedname'] = "f33D n4Me";
$lang['feedfoldername'] = "feED fOLDer nAm3";
$lang['feedlocation'] = "fEed l0c@+10n";
$lang['threadtitleprefix'] = "tHrE4D +1tL3 pREph1x";
$lang['feednameandlocation'] = "fE3D N4ME and L0C@t1ON";
$lang['feedsettings'] = "f33d 5eTtIn9\$";
$lang['updatefrequency'] = "upD4+e PHr3qu3ncY";
$lang['rssclicktoreadarticle'] = "cliCK H3re to RE4d +H1s 4r+1cl3";
$lang['addnewfeed'] = "adD n3W pHe3d";
$lang['editfeed'] = "eDit Fe3D";
$lang['feeduseraccount'] = "f33D usEr acCoUn+";
$lang['noexistingfeeds'] = "nO EXIS+in9 RSs pHEeD\$ PHOUnd. to @dD @ Ph33D Pl34S3 CLiCK +EH 8U+toN 8El0W";
$lang['rssfeedhelp'] = "heRe j00 C4N seTuP s0mE RS\$ pH33D5 PHoR 4Ut0M@+1c pr0pa94T10n 1nt0 y0Ur F0RuM. T3H It3M\$ Phr0M ThE rsS F33D\$ j00 4Dd W1lL 83 cRe@T3d @S tHr3@D\$ Wh1cH uSerS c4N R3Ply tO 45 IpH +Hey WErE noRM4l P05t\$. T3H r5s Ph33D MusT 83 4cc3SS1BlE vi4 httP 0r It w1ll N0t WORK.";
$lang['mustspecifyrssfeedname'] = "mU\$+ \$p3CipHY R\$s ph3ed n@M3";
$lang['mustspecifyrssfeeduseraccount'] = "muS+ \$p3CiPHY rSS pH33d uS3R @cC0unT";
$lang['mustspecifyrssfeedfolder'] = "mU\$t \$P3ciphY R\$\$ F33d fold3R";
$lang['mustspecifyrssfeedurl'] = "mU\$T \$PEcIPHy R\$s ph33d uRl";
$lang['mustspecifyrssfeedupdatefrequency'] = "mus+ Spec1PhY rSS FeED upd@t3 frEqUEnCy";
$lang['unknownrssuseraccount'] = "unKN0wN R\$\$ USEr 4cC0unT";
$lang['rssfeedsupportshttpurlsonly'] = "r\$s Fe3d SUppOr+s Ht+p uRls onLY. 53CUre F33Ds (ht+Ps://) 4r3 NO+ sUpPoRT3d.";
$lang['rssfeedurlformatinvalid'] = "r5\$ PhE3D URL foRM4+ 1S 1nV@L1D. Url mU5t 1ncLUde \$Ch3M3 (E.g. Ht+P://) 4Nd @ HOStN4M3 (E.G. WWW.ho5+N4m3.c0m).";
$lang['rssfeeduserauthentication'] = "rSS f33D dOES nOt \$UPPORt htTP U\$3R 4UtH3Nt1c4+10N";
$lang['successfullyremovedselectedfeeds'] = "sUCc3\$sPhULLy REm0vEd \$3L3C+ED FeeDS";
$lang['successfullyaddedfeed'] = "sucC3s\$pHUlly 4dD3d nEW f3ed";
$lang['successfullyeditedfeed'] = "suCcE\$\$pHuLlY EDitED PH3Ed";
$lang['failedtoremovefeeds'] = "f@1L3d +0 R3m0v3 sOm3 oR @LL of +hE \$3l3Ct3D FeEDS";
$lang['failedtoaddnewrssfeed'] = "f@1L3D +o @DD N3W RSS f33D";
$lang['failedtoupdaterssfeed'] = "f41L3d t0 uPd@+3 rSS phEed";
$lang['rssstreamworkingcorrectly'] = "rSS 5+r34M aPpE@R5 tO BE WoRKiNg cORr3ctLY";
$lang['rssstreamnotworkingcorrectly'] = "rs\$ \$+reAm w@s EmpTy OR couLd NOt 8E fOuNd";
$lang['invalidfeedidorfeednotfound'] = "inV@l1D Phe3d 1d or fe3D nO+ F0UnD";

// PM Export Options

$lang['pmexportastype'] = "exPor+ aS TYP3";
$lang['pmexporthtml'] = "htML";
$lang['pmexportxml'] = "xmL";
$lang['pmexportplaintext'] = "pl4IN +EXt";
$lang['pmexportmessagesas'] = "exp0RT m3S54Ge\$ 4s";
$lang['pmexportonefileforallmessages'] = "oNE F1lE pH0R 4lL MESSA935";
$lang['pmexportonefilepermessage'] = "oNe f1l3 pEr Me\$sA93";
$lang['pmexportattachments'] = "eXpOR+ at+4ChM3NT5";
$lang['pmexportincludestyle'] = "inCLUD3 FoRUm StyL3 5heET";
$lang['pmexportwordfilter'] = "apPLY woRd pHIlt3r +o Me\$s49E\$";

// Thread merge / split options

$lang['threadsplit'] = "tHR3@d h@S B3eN \$pli+";
$lang['threadmerge'] = "tHRe4D HaS 8een MErgED";
$lang['mergesplitthread'] = "m3rG3 / SpL1t Thr34D";
$lang['mergewiththreadid'] = "mERG3 W1+H +Hr34D 1D:";
$lang['postsinthisthreadatstart'] = "p0s+5 In +H15 thR34d @+ \$t4r+";
$lang['postsinthisthreadatend'] = "poST\$ iN +h1S THre4D 4+ 3nd";
$lang['reorderpostsintodateorder'] = "re-0RdER Po\$TS 1NTo d4+E orDer";
$lang['splitthreadatpost'] = "sPLIt +hR34D 4+ pO5T:";
$lang['selectedpostsandrepliesonly'] = "select3d P0sT 4ND R3Pl13S 0Nly";
$lang['selectedandallfollowingposts'] = "s3Lec+3D @Nd 4Ll fOLlOw1nG POS+s";

$lang['threadhere'] = "h3r3";
$lang['thisthreadhasmoved'] = "<b>thrE4dS mER93D:</b> Th1\$ thRE4d HAS MoVEd %s";
$lang['thisthreadwasmergedfrom'] = "<b>thR34dS meRgeD:</b> +h1S ThrE4d w4\$ m3rGed phrOm %s";
$lang['somepostsinthisthreadhavebeenmoved'] = "<b>thR34D spl1+:</b> SoMe POStS 1n +Hi\$ +hr3@D h4v3 b33n MOv3d %s";
$lang['somepostsinthisthreadweremovedfrom'] = "<b>thReAD 5pL1+:</b> 50M3 POSTs 1N +H1s +hrE4D wErE MOv3d frOM %s";

$lang['invalidfunctionarguments'] = "iNV4L1D FuNctiON arGUMeN+\$";
$lang['couldnotretrieveforumdata'] = "c0ulD n0t r3+Ri3v3 F0RUM d4+4";
$lang['cannotmergepolls'] = "one 0R MOre +hReAds is 4 pOLl. j00 c4nnO+ M3RGe POLLS";
$lang['couldnotretrievethreaddatamerge'] = "cOuLD n0t R3tri3vE +Hr3@d d@t4 PhR0M ONe or m0rE +hre4DS";
$lang['couldnotretrievethreaddatasplit'] = "c0ULd NO+ R3TRiev3 +hr34d d4T4 fR0m sOurC3 +HRe4D";
$lang['couldnotretrievepostdatamerge'] = "c0Uld N0+ Re+R1ev3 P05+ Da+4 FRoM ONe 0r M0rE tHRe4D\$";
$lang['couldnotretrievepostdatasplit'] = "coUld N0t r3+rieV3 p0sT d4t@ FROm SOUrCE +hR34d";
$lang['failedtocreatenewthreadformerge'] = "f@1L3D To cre4+E n3w THrE4D fOR MErge";
$lang['failedtocreatenewthreadforsplit'] = "f@1lED t0 crE4TE nEW +hr34d Ph0r \$pLIt";

// Thread subscriptions

$lang['threadsubscriptions'] = "thRE4d \$UBscr1PtiOn\$";
$lang['couldnotupdateinterestonthread'] = "c0ulD N0t uPd4te iN+3Res+ ON ThRe4D '%s'";
$lang['threadinterestsupdatedsuccessfully'] = "thREAd 1N+3R3\$ts Upd4tEd 5ucce\$5pHULLy";
$lang['resetselected'] = "r35Et \$3L3CT3D";
$lang['allthreadtypes'] = "aLl +hrE@d Typ3\$";
$lang['ignoredthreads'] = "igNOR3D Thre4DS";
$lang['highinterestthreads'] = "h1gH 1N+ERe\$T +hr34d5";
$lang['subscribedthreads'] = "sU8Scr1Bed +Hr3@D\$";
$lang['currentinterest'] = "cuRR3Nt 1NTeRe\$t";

?>