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

/* $Id: x-hacker.inc.php,v 1.294 2008-08-06 23:09:30 decoyduck Exp $ */

// British English language file

// Language character set and text direction options -------------------

$lang['_isocode'] = "en-gb";
$lang['_textdir'] = "ltr";

// Months --------------------------------------------------------------

$lang['month'][1]  = "j4Nu4rY";
$lang['month'][2]  = "f3BRu@RY";
$lang['month'][3]  = "m@RCh";
$lang['month'][4]  = "apR1L";
$lang['month'][5]  = "m@y";
$lang['month'][6]  = "june";
$lang['month'][7]  = "july";
$lang['month'][8]  = "au9U\$+";
$lang['month'][9]  = "sEP+EmB3r";
$lang['month'][10] = "ocT08ER";
$lang['month'][11] = "nOveM8er";
$lang['month'][12] = "dec3mbEr";

$lang['month_short'][1]  = "j@n";
$lang['month_short'][2]  = "f3b";
$lang['month_short'][3]  = "m4R";
$lang['month_short'][4]  = "apr";
$lang['month_short'][5]  = "m@y";
$lang['month_short'][6]  = "juN";
$lang['month_short'][7]  = "jUL";
$lang['month_short'][8]  = "aug";
$lang['month_short'][9]  = "s3P";
$lang['month_short'][10] = "oCt";
$lang['month_short'][11] = "nOV";
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

$lang['date_periods']['year']   = "%s YE4r";
$lang['date_periods']['month']  = "%s M0nth";
$lang['date_periods']['week']   = "%s we3k";
$lang['date_periods']['day']    = "%s d4Y";
$lang['date_periods']['hour']   = "%s Hour";
$lang['date_periods']['minute'] = "%s M1nu+3";
$lang['date_periods']['second'] = "%s Sec0nD";

// As above but plurals (2 years vs. 1 year, etc.)

$lang['date_periods_plural']['year']   = "%s Y34r5";
$lang['date_periods_plural']['month']  = "%s m0N+H\$";
$lang['date_periods_plural']['week']   = "%s W3ek5";
$lang['date_periods_plural']['day']    = "%s D4y\$";
$lang['date_periods_plural']['hour']   = "%s H0UrS";
$lang['date_periods_plural']['minute'] = "%s minUTe5";
$lang['date_periods_plural']['second'] = "%s \$3Cond\$";

// Short hand periods (example: 1y, 2m, 3w, 4d, 5hr, 6min, 7sec)

$lang['date_periods_short']['year']   = "%sy";    // 1y
$lang['date_periods_short']['month']  = "%sM";    // 2m
$lang['date_periods_short']['week']   = "%sW";    // 3w
$lang['date_periods_short']['day']    = "%sd";    // 4d
$lang['date_periods_short']['hour']   = "%sHR";   // 5hr
$lang['date_periods_short']['minute'] = "%sMIn";  // 6min
$lang['date_periods_short']['second'] = "%s\$3C";  // 7sec

// Common words --------------------------------------------------------

$lang['percent'] = "pERCENt";
$lang['average'] = "avEr49e";
$lang['approve'] = "aPprove";
$lang['banned'] = "b@NN3D";
$lang['locked'] = "l0CkEd";
$lang['add'] = "aDD";
$lang['advanced'] = "adVANCED";
$lang['active'] = "aC+1V3";
$lang['style'] = "stYL3";
$lang['go'] = "g0";
$lang['folder'] = "f0ld3r";
$lang['ignoredfolder'] = "igNOreD PholDEr";
$lang['subscribedfolder'] = "sU85cR183d PhOLdER";
$lang['folders'] = "f0Ld3r5";
$lang['thread'] = "thr3@d";
$lang['threads'] = "tHR34D5";
$lang['threadlist'] = "thR34D L1st";
$lang['message'] = "m35\$@93";
$lang['from'] = "from";
$lang['to'] = "tO";
$lang['all_caps'] = "aLl";
$lang['of'] = "opH";
$lang['reply'] = "rEPLY";
$lang['forward'] = "f0rwaRD";
$lang['replyall'] = "r3pLy +0 4lL";
$lang['quickreply'] = "qu1ck R3Ply";
$lang['quickreplyall'] = "quIcK R3PLY t0 @LL";
$lang['pm_reply'] = "r3plY 4\$ pM";
$lang['delete'] = "d3L3+e";
$lang['deleted'] = "d3L3+ED";
$lang['edit'] = "eDIt";
$lang['privileges'] = "prIvIle9es";
$lang['ignore'] = "igN0R3";
$lang['normal'] = "n0RM4l";
$lang['interested'] = "iNt3Res+3d";
$lang['subscribe'] = "sub\$cRIBe";
$lang['apply'] = "apPLY";
$lang['download'] = "doWNl0@d";
$lang['save'] = "sAVe";
$lang['update'] = "upD4T3";
$lang['cancel'] = "c4NcEL";
$lang['continue'] = "c0ntiNuE";
$lang['attachment'] = "a++@CHmeNT";
$lang['attachments'] = "at+aChMEnTs";
$lang['imageattachments'] = "iM49e @++4ChMEnT\$";
$lang['filename'] = "f1L3N4me";
$lang['dimensions'] = "d1MeN\$IoN\$";
$lang['downloadedxtimes'] = "d0WnL04d3d: %d +1mes";
$lang['downloadedonetime'] = "dOwnl0@dED: 1 T1me";
$lang['size'] = "sIz3";
$lang['viewmessage'] = "v13w M355@G3";
$lang['deletethumbnails'] = "d3L3tE tHUM8n@Ils";
$lang['logon'] = "lo9oN";
$lang['more'] = "mOr3";
$lang['recentvisitors'] = "r3C3NT V1S1ToRS";
$lang['username'] = "uS3RNamE";
$lang['clear'] = "cle@R";
$lang['reset'] = "r3S3+";
$lang['action'] = "aC+1oN";
$lang['unknown'] = "uNKN0wn";
$lang['none'] = "n0nE";
$lang['preview'] = "pr3VIew";
$lang['post'] = "p0sT";
$lang['posts'] = "p0\$+S";
$lang['change'] = "chaN9E";
$lang['yes'] = "y35";
$lang['no'] = "n0";
$lang['signature'] = "s19N@tUR3";
$lang['signaturepreview'] = "s19n4tuRE pReV13W";
$lang['signatureupdated'] = "s19N@+UR3 UPd4t3D";
$lang['signatureupdatedforallforums'] = "s19n@+UR3 UPd4TED FOR 4ll PhoRuM\$";
$lang['back'] = "b@CK";
$lang['subject'] = "su8JECT";
$lang['close'] = "cL0\$3";
$lang['name'] = "n4M3";
$lang['description'] = "dE\$CRiPTIon";
$lang['date'] = "d@t3";
$lang['view'] = "vi3w";
$lang['enterpasswd'] = "en+3R P@sSWOrD";
$lang['passwd'] = "p@ssWORd";
$lang['ignored'] = "i9N0R3D";
$lang['guest'] = "gu35+";
$lang['next'] = "n3XT";
$lang['prev'] = "preV10US";
$lang['others'] = "otH3R\$";
$lang['nickname'] = "nickN4M3";
$lang['emailaddress'] = "em41L @DDRess";
$lang['confirm'] = "cONPhirm";
$lang['email'] = "eM@il";
$lang['poll'] = "polL";
$lang['friend'] = "fR1EnD";
$lang['success'] = "sucC3SS";
$lang['error'] = "eRr0R";
$lang['warning'] = "w4rnIN9";
$lang['guesterror'] = "s0rRY, J00 N33D to 83 L0ggED IN T0 U\$3 Th1s Fe4+URe.";
$lang['loginnow'] = "lo91N noW";
$lang['unread'] = "unR3AD";
$lang['all'] = "all";
$lang['allcaps'] = "alL";
$lang['permissions'] = "p3rMi\$s1ON\$";
$lang['type'] = "typE";
$lang['print'] = "pR1n+";
$lang['sticky'] = "st1CKy";
$lang['polls'] = "p0ll5";
$lang['user'] = "user";
$lang['enabled'] = "enaBL3D";
$lang['disabled'] = "dISABlED";
$lang['options'] = "op+1oNS";
$lang['emoticons'] = "emo+1c0NS";
$lang['webtag'] = "wE8t4G";
$lang['makedefault'] = "m4ke D3Ph4uL+";
$lang['unsetdefault'] = "uNse+ DeFAul+";
$lang['rename'] = "rEn@Me";
$lang['pages'] = "pAgES";
$lang['used'] = "u\$ED";
$lang['days'] = "d4yS";
$lang['usage'] = "us49e";
$lang['show'] = "sH0W";
$lang['hint'] = "h1N+";
$lang['new'] = "nEw";
$lang['referer'] = "r3F3R3R";
$lang['thefollowingerrorswereencountered'] = "t3h F0LL0WiNG erROrS W3RE 3NC0Unt3R3D:";

// Admin interface (admin*.php) ----------------------------------------

$lang['admintools'] = "aDm1N t00L\$";
$lang['forummanagement'] = "f0ruM m4n49EM3NT";
$lang['accessdeniedexp'] = "j00 dO nO+ h4V3 PERmISSI0N +0 uSE Th1\$ \$3cTioN.";
$lang['managefolders'] = "m4n@93 F0LD3R\$";
$lang['manageforums'] = "m4n@93 PH0RuMS";
$lang['manageforumpermissions'] = "mAN493 F0RUm P3RMi\$s10nS";
$lang['foldername'] = "f0lD3R n4M3";
$lang['move'] = "m0V3";
$lang['closed'] = "cl0\$3d";
$lang['open'] = "open";
$lang['restricted'] = "r3\$tr1c+3d";
$lang['forumiscurrentlyclosed'] = "%s I5 CURR3N+lY cL0\$3D";
$lang['youdonothaveaccesstoforum'] = "j00 d0 NoT H4Ve 4CCES5 T0 %s";
$lang['toapplyforaccessplease'] = "tO @pPLy pHOR @CCEss ple4\$3 C0N+4C+ TH3 %s.";
$lang['forumowner'] = "forUM Own3R";
$lang['adminforumclosedtip'] = "if J00 W4nt +o chANGE \$0me \$3+t1NG\$ On YouR phOruM cL1cK +H3 @dMin LiNK 1N tH3 N4v1G4+I0N b4R 48oVe.";
$lang['newfolder'] = "n3w FOLDer";
$lang['nofoldersfound'] = "n0 eX1\$+IN9 PH0LDer5 Ph0UnD. tO @dD @ f0ldER cL1ck +3H '4Dd nEW' bu+T0N 83lOw.";
$lang['forumadmin'] = "forUM 4DM1n";
$lang['adminexp_1'] = "uSe +eh MENU On +h3 lEf+ TO m4nag3 +h1N9s 1N Y0Ur ph0Rum.";
$lang['adminexp_2'] = "<b>u\$Er5</b> 4lL0w5 j00 t0 set 1nd1VidU@l USer P3rM15S1On5, inCLud1NG 4PPO1N+1NG m0der@+orS anD gAgGINg p30plE.";
$lang['adminexp_3'] = "<b>us3R 9r0UPS</b> 4LL0WS J00 +o cR3A+e uS3R 9r0up\$ +0 @\$s1gN permI5siON\$ to 4s m@Ny 0R 4\$ Ph3W u5ErS qUIcKLy @Nd E4s1LY.";
$lang['adminexp_4'] = "<b>b@n CONtROl5</b> 4lLoW\$ +h3 B4NNINg @Nd UN-B4NN1NG oF Ip AddR3\$s35, H+tP RefERERS, UserN4ME\$, 3M41L AdDRE\$sES @nD N1CKn@mE\$.";
$lang['adminexp_5'] = "<b>fOLDErs</b> 4lL0WS +Eh CR3A+1ON, m0d1PHIC4+10N 4nD d3LE+10N 0F Ph0LDER\$.";
$lang['adminexp_6'] = "<b>r\$\$ PH33DS</b> @lLOW5 j00 t0 MAnAG3 R5s FE3D\$ F0R pR0P494+1ON in+O YOur f0rUM.";
$lang['adminexp_7'] = "<b>pR0PHil35</b> L3TS j00 Cu\$+OMI\$3 +h3 I+3m\$ +H@T APp3@R in +hE US3R pR0F1L3S.";
$lang['adminexp_8'] = "<b>f0ruM S3++1NG5</b> 4LL0WS j00 T0 CusT0M1\$3 YOur F0RUM's N4M3, aPPe@R4NC3 4Nd M4Ny o+H3R +h1NG5.";
$lang['adminexp_9'] = "<b>sT@RT pAGe</b> LE+S j00 CUStOM1SE yOUR F0RUM'S S+4R+ p4G3.";
$lang['adminexp_10'] = "<b>fORUM \$+Yle</b> ALL0WS J00 to 9eNER4T3 r4nDOM S+yl3S PHOr Y0UR F0RUM m3mbeR\$ +0 U\$3.";
$lang['adminexp_11'] = "<b>w0rd PHil+3R</b> 4ll0WS j00 +O Ph1l+3R woRDS j00 D0N't W4N+ +o B3 U53D ON yoUR ForUM.";
$lang['adminexp_12'] = "<b>poStiN9 ST4+S</b> 9enER4+3\$ A reP0R+ LIstIN9 +Eh TOP 10 POSt3R\$ In 4 d3PH1N3D p3rI0D.";
$lang['adminexp_13'] = "<b>f0RUM L1NK\$</b> l3+\$ J00 MaNAG3 TH3 LiNk\$ Dr0PDOwN IN +3H N4VIg4+1ON 8ar.";
$lang['adminexp_14'] = "<b>vieW L09</b> LI5+S r3CEnT @c+10NS by +H3 f0RUm Moder4+ORs.";
$lang['adminexp_15'] = "<b>m4n4g3 FORumS</b> le+s J00 crE@TE @nD D3le+E 4nD CLos3 0R R30P3N F0RuM\$.";
$lang['adminexp_16'] = "<b>glOB@l F0RuM SE++1nGS</b> @lL0w\$ J00 +0 MODIFy \$3++1NGS wH1Ch @FFEc+ 4LL pH0RUms.";
$lang['adminexp_17'] = "<b>p0\$t 4PPR0VaL qU3U3</b> @LLoW\$ j00 TO v1EW Any P0S+S 4w41TINg 4PPr0v4L by 4 M0D3r4tOR.";
$lang['adminexp_18'] = "<b>v1\$1+0R L0g</b> 4lLOw\$ J00 +O v1Ew 4N EXt3ND3D lI\$+ 0F vI51+0RS 1nCLUdING THEiR H+tP r3pH3R3R\$.";
$lang['createforumstyle'] = "cRE@+3 4 F0RUm \$+yLE";
$lang['newstylesuccessfullycreated'] = "new S+yLE \$uCC3\$sPHulLY Cr34t3D.";
$lang['stylealreadyexists'] = "a sTyLE wI+H +h4T PHIL3N4M3 ALr3ADY 3x1\$T\$.";
$lang['stylenofilename'] = "j00 DId No+ Ent3R @ PhIL3NAme +0 s@VE tHE 5+yL3 W1TH.";
$lang['stylenodatasubmitted'] = "c0ulD n0T READ pH0RuM s+yL3 D@t@.";
$lang['styleexp'] = "u5e TH1S P493 TO HELp CRE4TE @ R4NDOmLY GeNeR4T3D \$+yLE F0R y0UR phoRUM.";
$lang['stylecontrols'] = "cONTrolS";
$lang['stylecolourexp'] = "cLiCK oN a COLoUr To m4kE 4 NeW \$+YL3 \$h33+ bA\$3D 0N TH4T c0L0UR. cuRr3nt 8@SE cOLOUR 15 F1RS+ In LIS+.";
$lang['standardstyle'] = "s+aNDarD \$TYlE";
$lang['rotelementstyle'] = "ro+4t3d ELEm3nT s+YlE";
$lang['randstyle'] = "r4nDOm S+Yl3";
$lang['thiscolour'] = "tHI\$ coLouR";
$lang['enterhexcolour'] = "oR 3N+3R @ HEX c0LouR +0 Ba\$3 4 NeW \$+YlE 5H3e+ 0N";
$lang['savestyle'] = "s4VE +h1\$ sTYle";
$lang['styledesc'] = "s+YL3 DescR1PTI0n";
$lang['stylefilenamemayonlycontain'] = "sTYle PHILEn4M3 m4y OnLY C0N+@1N LoweRC4S3 l3++3R\$ (@-Z), nUMBEr\$ (0-9) 4Nd UNDeRsC0RE.";
$lang['stylepreview'] = "s+yL3 PR3ViEW";
$lang['welcome'] = "w3lC0M3";
$lang['messagepreview'] = "m3\$SAg3 PRevIEW";
$lang['users'] = "u\$er\$";
$lang['usergroups'] = "uS3R GR0UpS";
$lang['mustentergroupname'] = "j00 MUs+ eN+ER 4 GroUP n4m3";
$lang['profiles'] = "pr0Ph1LES";
$lang['manageforums'] = "m4n@GE F0rUMS";
$lang['forumsettings'] = "f0RUM sETtINGS";
$lang['globalforumsettings'] = "gL08@L F0ruM S3++1Ngs";
$lang['settingsaffectallforumswarning'] = "<b>n0tE:</b> THe\$3 \$3+T1NGS 4PHFEc+ @LL f0ruMS. whEre THe S3TTIN9 is dUPL1C4+3D 0n TH3 1NDIv1dU4L F0ruM'\$ \$3+TiNG\$ p49E Th4t W1LL T@K3 PR3ceD3NCe oVER tEH \$3++1nGs j00 CH4n93 HERE.";
$lang['startpage'] = "s+4r+ Pag3";
$lang['startpageerror'] = "y0UR \$+4R+ P@Ge COUlD n0+ 83 \$4V3D loC@lLY +O the S3rvEr b3C4U\$E p3rM1sS1ON W@S d3N1ED.</p><p>to cHAnGE yoUr \$+4rT P@9E pLE4S3 ClICK +3H doWNl04d 8U++0N BELOw WhiCH WilL ProMpT j00 tO S4V3 +Eh FILe +0 Y0uR h4RD dr1VE. j00 C@N THen UPLO4D thI\$ F1l3 TO Y0UR 5Erv3R 1N+0 THe FoLl0WiNG pHOLD3R, 1F NeCE5S4RY cr34+1NG TeH PHOld3R StruCturE IN TH3 ProCE\$S.</p><p><b>%s</b></p><p>ple4s3 NO+e +H4T SOme 8R0WS3R\$ m4Y cH@N93 ThE N4ME 0pH the Ph1l3 UP0N DownLO4D. WHEN uPlo4D1NG t3h F1LE pLeA53 M4Ke 5uR3 +H4+ 1+ I\$ n@MED \$+@rT_M4IN.Php 0THERW1\$3 YOUR 5t4r+ P49E W1LL 4pPEAR UNch@NGED.";
$lang['uploadcssfile'] = "upL04D CsS S+yLE \$H33+";
$lang['uploadcssfilefailed'] = "y0ur cSS sTyLE sh3ET couLD Not BE UPl04d3d T0 thE \$3RVER 83c4Us3 PERMi\$s10N W4S d3n13D.</p><p>t0 CH4n93 Y0uR \$T@R+ p49E CSS \$+YLE Sh33+ pLEA\$3 En\$Ur3 +H3 FolL0W1N9 folDErs 3x1\$t @Nd AR3 wrI+48L3: </p><p><b>%s</b></p>";
$lang['invalidfiletypeerror'] = "iNv@lID pHIl3 TyP3, j00 c4n oNLy UPlO@d Css S+YL3 \$h33T fiLE5";
$lang['failedtoopenmasterstylesheet'] = "your PHORuM StyL3 CouLd N0T 83 \$4V3D 83C4U\$3 +H3 ma\$t3r s+yLe 5HEE+ coUlD N0+ bE lo@DED. tO s4V3 YOuR StyL3 +h3 M@ST3R \$+YLe \$h33+ (mAKe_5+YlE.c\$S) MUSt 83 LOC@+ED iN +3h STYlES dIREc+0RY 0f y0uR B3EH1V3 pHORUm Ins+@LlA+10N.";
$lang['makestyleerror'] = "youR PhoRum S+yL3 C0UlD N0T 83 \$aV3D l0c@LLy T0 +3h \$3RV3R bEcaU5E P3RmI\$5I0N w@S D3N1ED.</p><p>t0 s4v3 y0UR fORUm StyLE PLe4s3 cL1CK tHe DoWNLo4d 8UT+0n 83L0w wH1CH W1Ll Pr0mPt j00 +0 \$4v3 +H3 Fil3 +0 y0UR h4RD dRiVE. J00 CAN THeN uPLO4D +HI\$ Ph1l3 +0 Y0UR 5ERvER 1N+0 Th3 F0LL0W1N9 pHOlDer, if N3Ce\$S@ry cRE4+1N9 +h3 PH0LdeR StRUcTUre In +hE pr0C3\$S.</p><p><b>%s</b></p><p>pl3@S3 N0TE +H4T S0M3 8R0WS3RS M4Y chAn9E THe N4M3 Of +H3 fiL3 up0N dOwnLO4D. WHeN UpLO4D1NG t3H f1L3 Pl34s3 MAke \$UrE +h4+ 1+ i\$ N4M3d STYL3.CSS O+HerW1s3 +3H PHorum STYl3 WILL 83 UN4V41L4bLE.";
$lang['forumstyle'] = "f0rUM 5+yL3";
$lang['wordfilter'] = "word PHiL+eR";
$lang['forumlinks'] = "f0rUM l1NKS";
$lang['viewlog'] = "v1EW lOG";
$lang['noprofilesectionspecified'] = "no Pr0f1LE \$3cTI0N SpECIFIeD.";
$lang['itemname'] = "it3M n4m3";
$lang['moveto'] = "m0vE +0";
$lang['manageprofilesections'] = "m@N493 Pr0fiL3 S3CTI0ns";
$lang['sectionname'] = "sECTi0n N@me";
$lang['items'] = "i+em\$";
$lang['mustspecifyaprofilesectionid'] = "mU5T SPEc1fY A PR0f1l3 SEc+IOn ID";
$lang['mustsepecifyaprofilesectionname'] = "mus+ \$pEc1fy @ PROf1Le SEc+10N N4M3";
$lang['noprofilesectionsfound'] = "nO 3x1stiN9 Pr0fIL3 s3cTIOn\$ f0uND. +o aDD 4 pR0FIl3 s3CT10N cLIcK TH3 'aDD nEW' 8U+TOn 8EL0w.";
$lang['addnewprofilesection'] = "aDd n3w pr0f1Le \$eC+1On";
$lang['successfullyaddedprofilesection'] = "sUcC3\$sFUlLY @DdeD PropH1lE S3CT1oN";
$lang['successfullyeditedprofilesection'] = "sucC3\$5FULLY 3d1tED PROfILe SEC+10n";
$lang['addnewprofilesection'] = "add NEW PR0f1LE s3c+1ON";
$lang['mustsepecifyaprofilesectionname'] = "muST SPEciPHy 4 Pr0fILE s3C+1ON NAMe";
$lang['successfullyremovedselectedprofilesections'] = "sUCC3\$SpHULLy R3M0Ved SEl3CTeD pROF1Le \$3CT1ONS";
$lang['failedtoremoveprofilesections'] = "f41L3d +0 REmov3 Pr0pHIL3 53cTI0NS";
$lang['viewitems'] = "v1eW I+eMS";
$lang['successfullyaddednewprofileitem'] = "sUCC3\$SPhULlY 4dD3D N3W PROfIL3 I+3m";
$lang['successfullyeditedprofileitem'] = "sucC3sSPhuLLy 3DI+3D PrOFIle 1+3M";
$lang['successfullyremovedselectedprofileitems'] = "sUcCESSPHUlLY R3M0VEd \$ELeC+eD ProFIL3 i+3MS";
$lang['failedtoremoveprofileitems'] = "f@IlED T0 RemOVe Pr0pHIlE I+3mS";
$lang['noexistingprofileitemsfound'] = "th3rE @R3 N0 3x1sTIn9 pR0FilE 1+Ems in th1\$ \$3ctIOn. +0 @Dd 4N i+3M CliCk +H3 '@Dd N3W' Bu+TOn 8EL0w.";
$lang['edititem'] = "ed1+ 1+3M";
$lang['invalidprofilesectionid'] = "invAL1D pR0PhIL3 S3C+1ON 1D 0R SEc+10N N0+ PhOUNd";
$lang['invalidprofileitemid'] = "iNv4lId PR0fiL3 I+3m Id OR I+Em NO+ f0unD";
$lang['addnewitem'] = "add New 1+3M";
$lang['youmustenteraprofileitemname'] = "j00 MUSt 3Nt3r 4 pr0F1l3 i+EM n4Me";
$lang['invalidprofileitemtype'] = "iNv4l1D PrOPH1LE 1+3m TyP3 S3LecT3D";
$lang['youmustenteroptionsforselectedprofileitemtype'] = "j00 Mu5+ ENt3R S0ME 0p+10N\$ PHOr \$3LEc+ed pROF1LE 1tEM tYpE";
$lang['youmustentermorethanoneoptionforitem'] = "j00 MU\$T 3N+3r MOR3 +H4n 0NE OPT10N PhOR s3l3C+3D PR0fIL3 1T3M +YP3";
$lang['profileitemhyperlinkssupportshttpurlsonly'] = "prOphIle 1T3m hYP3Rl1NKS sUPPOrT H++P uRLS 0nlY";
$lang['profileitemhyperlinkformatinvalid'] = "propHiLe I+Em HYpERLInk pH0RM4T 1NV@Lid";
$lang['youmustincludeprofileentryinhyperlinks'] = "j00 MUSt InCLUd3 <i>%s</i> 1n +3H URL oF cLICk@8Le HYp3Rl1NK5";
$lang['failedtocreatenewprofileitem'] = "f41l3D +0 Cre4T3 NEw PR0Ph1L3 I+em";
$lang['failedtoupdateprofileitem'] = "f@ILED +0 UpD4+3 pR0F1L3 I+3M";
$lang['startpageupdated'] = "s+4r+ P@GE upD4TeD. %s";
$lang['cssfileuploaded'] = "cSs \$TylE SHe3t UPLO@DED. %s";
$lang['viewupdatedstartpage'] = "v1Ew UPdA+3D ST4R+ PagE";
$lang['editstartpage'] = "eDit ST4R+ P49E";
$lang['nouserspecified'] = "no U\$3R SpECif1eD.";
$lang['manageuser'] = "m4n4gE us3r";
$lang['manageusers'] = "mAN@G3 U\$3R\$";
$lang['userstatusforforum'] = "u53R st4+US pHOR %s";
$lang['userdetails'] = "us3R DEt4iL\$";
$lang['edituserdetails'] = "edi+ U53R d3t@Ils";
$lang['warning_caps'] = "w@rN1Ng";
$lang['userdeleteallpostswarning'] = "aRe J00 \$URE J00 W4N+ +0 DELEte 4LL 0F THe \$3leC+3D US3R'S pO5+S? 0NC3 TEH pOSt\$ AR3 d3LE+3D +H3y C4nnoT B3 r3+R1evED 4ND WILL be l0sT PH0rev3r.";
$lang['postssuccessfullydeleted'] = "pOsTS w3Re sUCC3SSpHUlLY dElEtED.";
$lang['folderaccess'] = "f0ld3R @Cc3sS";
$lang['possiblealiases'] = "p0S5Ibl3 Al14s3\$";
$lang['ipaddressmatches'] = "iP 4DDREs\$ MAtCH3S";
$lang['emailaddressmatches'] = "eM41l 4DDreSs m@TcHE5";
$lang['passwdmatches'] = "p4ssWORd ma+ChE\$";
$lang['httpreferermatches'] = "ht+P rePheR3R m@Tch3s";
$lang['userhistory'] = "uSeR H1\$TOrY";
$lang['nohistory'] = "n0 H1s+ORY R3C0RD\$ s4veD";
$lang['userhistorychanges'] = "ch@nGES";
$lang['clearuserhistory'] = "cLE4R us3R H1\$T0RY";
$lang['changedlogonfromto'] = "cH@Nged LOGON PHroM %s TO %s";
$lang['changednicknamefromto'] = "cH@NGED nICKN@mE PHR0M %s +O %s";
$lang['changedemailfromto'] = "chaN9ED 3M41L pHR0M %s t0 %s";
$lang['successfullycleareduserhistory'] = "sUcc35sPHUllY CleAReD USer hisT0Ry";
$lang['failedtoclearuserhistory'] = "f@1LEd +0 cLE@r U\$eR H1s+ORy";
$lang['successfullychangedpassword'] = "sUcCEssPhULly Ch@Ng3D P4SsWORD";
$lang['failedtochangepasswd'] = "f41L3d +o Ch4N9E p@S5W0RD";
$lang['approveuser'] = "aPPR0v3 U\$3R";
$lang['viewuserhistory'] = "v13W U\$3R h1stORY";
$lang['viewuseraliases'] = "v13w USEr @Li4S35";
$lang['searchreturnednoresults'] = "s3ARCH RE+urNEd n0 R3SUL+s";
$lang['deleteposts'] = "dEl3+3 POstS";
$lang['deleteuser'] = "dEleTE U53R";
$lang['alsodeleteusercontent'] = "al\$o dEL3+e ALl OF +H3 coN+3n+ cRE4T3D 8Y tHI\$ US3R";
$lang['userdeletewarning'] = "ar3 J00 suR3 J00 w4NT +O D3LEtE Th3 SelECT3D u\$eR @Cc0UN+? oNc3 +he @CC0Unt h@5 83EN d3l3T3D I+ CaNNo+ 8E rETR1ev3d 4Nd W1Ll 83 lo5T FOR3V3R.";
$lang['usersuccessfullydeleted'] = "us3R \$UcCESSPHULly D3LET3D";
$lang['failedtodeleteuser'] = "f41LED TO deLe+E u\$3R";
$lang['forgottenpassworddesc'] = "if TH1s US3R HA5 FOR90TtEN +h3iR P4SSWORd J00 C4N RESet I+ foR ThEM HERe.";
$lang['failedtoupdateuserstatus'] = "f4iLEd T0 uPD4T3 USER s+4+U\$";
$lang['failedtoupdateglobaluserpermissions'] = "f@1lED +0 UPda+E 9L0B4L US3R PeRMi5s1oNs";
$lang['failedtoupdatefolderaccesssettings'] = "f4iLEd TO upd4+3 PhOLDEr @CCe\$S \$3t+1ngs";
$lang['manageusersexp'] = "this lI\$+ sHOws @ S3LEcTI0N 0f Us3r\$ WH0 h4v3 L0g93D 0N +o y0UR FoRUM, \$0R+3D by %s. +O @l+3R a US3R'5 PeRM15SI0N\$ Cl1cK +H3Ir N4M3.";
$lang['userfilter'] = "uSer PhILTer";
$lang['onlineusers'] = "onL1N3 U5ERS";
$lang['offlineusers'] = "oFpHLiN3 US3rS";
$lang['usersawaitingapproval'] = "u\$er\$ 4w4I+inG @pPr0VAl";
$lang['bannedusers'] = "b4nNEd UseRS";
$lang['lastlogon'] = "la5t L0G0N";
$lang['sessionreferer'] = "se\$S10N RepHErEr";
$lang['signupreferer'] = "s1gN-Up RePHer3R:";
$lang['nouseraccountsmatchingfilter'] = "no USEr AcC0UN+\$ m4TCH1n9 PHiLT3R";
$lang['searchforusernotinlist'] = "se4RCH PH0R a USer not 1N L1\$T";
$lang['adminaccesslog'] = "admIN 4CCE\$s LO9";
$lang['adminlogexp'] = "th1s Lis+ ShOWS +3H La\$T 4C+1ON\$ S4NC+I0neD 8Y u\$3R\$ W1+H 4DM1N pRiVIl39e5.";
$lang['datetime'] = "d4te/+iM3";
$lang['unknownuser'] = "uNKNOwN usER";
$lang['unknownuseraccount'] = "uNknown USer 4Cc0uNT";
$lang['unknownfolder'] = "unkNOWn F0LD3R";
$lang['ip'] = "iP";
$lang['lastipaddress'] = "l4\$+ ip 4DdrE\$S";
$lang['hostname'] = "h0stN@m3";
$lang['unknownhostname'] = "unkN0wn hO\$Tn@Me";
$lang['logged'] = "l09GED";
$lang['notlogged'] = "n0+ L0GgED";
$lang['addwordfilter'] = "add W0Rd PHilTER";
$lang['addnewwordfilter'] = "aDd New W0Rd pHIL+Er";
$lang['wordfilterupdated'] = "wOrd F1LT3R UPD@TEd";
$lang['wordfilterisfull'] = "j00 C4NN0+ @DD ANy MORe WoRd Ph1L+eR\$. R3M0Ve 50ME Unu\$3D 0n3s 0r ED1+ +eh ex1\$T1Ng ONe\$ F1R\$+.";
$lang['filtername'] = "f1LTEr N@ME";
$lang['filtertype'] = "f1ltER tYP3";
$lang['filterenabled'] = "fiLTER 3N48L3d";
$lang['editwordfilter'] = "ediT W0rd FiLT3R";
$lang['nowordfilterentriesfound'] = "n0 Ex1\$T1NG WOrD pH1LtER ENtRIes FOuND. TO @Dd 4 PhILt3R ClICk +h3 '4Dd NEw' 8ut+0N b3LOW.";
$lang['mustspecifyfiltername'] = "j00 MU\$+ SPecIPhY 4 pHIL+ER n4m3";
$lang['mustspecifymatchedtext'] = "j00 MUSt SPECiphy M4TCh3D T3XT";
$lang['mustspecifyfilteroption'] = "j00 MU\$t SpECIphY @ pHILt3r 0PTi0N";
$lang['mustspecifyfilterid'] = "j00 MU\$t sPEc1fY 4 FIlTER 1d";
$lang['invalidfilterid'] = "iNvAL1d FiLt3r id";
$lang['failedtoupdatewordfilter'] = "f41LEd +0 uPd@T3 W0rd pH1LT3R. ChECK tH@t +3h fiLT3R StILL ex1STS.";
$lang['allow'] = "allOW";
$lang['block'] = "bL0Ck";
$lang['normalthreadsonly'] = "n0rM@l THr3@DS 0NLy";
$lang['pollthreadsonly'] = "p0Ll THRe4d\$ ONLy";
$lang['both'] = "b0TH ThR34D tYpE\$";
$lang['existingpermissions'] = "exisT1N9 P3RM1ss1oNS";
$lang['nousershavebeengrantedpermission'] = "nO 3x15+In9 US3R5 P3rMI\$S1ONS f0UND. +O 9R4N+ PERMi\$S1ON +0 U\$3R\$ \$34Rch F0r tH3M B3L0W.";
$lang['successfullyaddedpermissionsforselectedusers'] = "sUCc3\$SFULlY @dDED p3RM1SS10nS pHOr \$3LEcT3D US3Rs";
$lang['successfullyremovedpermissionsfromselectedusers'] = "succE\$SFUllY REMOV3d P3RMI\$\$10N\$ FR0M SElECT3D us3RS";
$lang['failedtoaddpermissionsforuser'] = "f@1l3D To 4dD pERmISSI0N\$ fOR us3R '%s'";
$lang['failedtoremovepermissionsfromuser'] = "f41led +O r3MOVe P3RmisS1on\$ FroM uS3R '%s'";
$lang['searchforuser'] = "s34rCh FOR us3R";
$lang['browsernegotiation'] = "br0wS3R N39O+1@T3D";
$lang['textfield'] = "t3XT PHiELd";
$lang['multilinetextfield'] = "mULT1-l1NE +3xT pHIeLD";
$lang['radiobuttons'] = "r4DI0 8U+TONS";
$lang['dropdownlist'] = "dR0P DOWN LI\$T";
$lang['clickablehyperlink'] = "cLiCK48L3 HYp3rL1nk";
$lang['threadcount'] = "tHRE@d Coun+";
$lang['clicktoeditfolder'] = "cL1CK +0 3D1+ f0ld3R";
$lang['fieldtypeexample1'] = "to CRe4+3 R@DI0 BU++0NS oR a DRop doWn L1\$T J00 N3ED TO 3NT3R 34cH INd1viDU@l V4LUE 0N 4 \$ep4R4+3 l1ne In +h3 0P+10N\$ PHIelD.";
$lang['fieldtypeexample2'] = "t0 cR3A+3 cL1CK4Bl3 l1NK5 en+3R The UrL In TEh 0P+10NS Ph1eLd @ND Use <i>%1\$\$</i> WHERE t3H En+RY fR0M +3H USER'\$ Pr0pHIL3 SHOulD aPP34R. 3xAmpLes: <p>mySP4CE: <i>htTP://wWw.MYsp4cE.COM/%1\$\$</i><br />xB0X LIV3: <i>hTTp://Pr0fiLE.my94MERc4rD.N3+/%1\$5</i>";
$lang['editedwordfilter'] = "eD1tED w0rD fiLT3R";
$lang['editedforumsettings'] = "eD1T3D F0RUM sEtt1N9S";
$lang['successfullyendedusersessionsforselectedusers'] = "sUcC3\$SFUlly ENDed S35si0NS PH0R \$3l3C+3d uSeR\$";
$lang['failedtoendsessionforuser'] = "f4ILEd T0 3ND 5E\$S1ON pH0R u5ER %s";
$lang['successfullyapproveduser'] = "succE5sPHUlLY 4Ppr0VED us3R";
$lang['successfullyapprovedselectedusers'] = "sUccESSFuLLY @PpROVEd \$3LECT3D Us3rs";
$lang['matchedtext'] = "m4+cH3D +ext";
$lang['replacementtext'] = "r3PL4C3m3N+ +3xT";
$lang['preg'] = "pREG";
$lang['wholeword'] = "wholE W0RD";
$lang['word_filter_help_1'] = "<b>alL</b> m4tcH3S @G4IN\$+ +3H wHOL3 T3XT s0 PHIL+3rInG moM to Mum W1lL 4L\$O ch4N9E m0M3NT to muM3N+.";
$lang['word_filter_help_2'] = "<b>wHOLe W0RD</b> m4+CH3\$ @94InsT whOL3 woRD\$ 0nlY sO PhIL+eRInG mOM +0 MUm W1Ll NOt Ch4N9E Mom3NT t0 MUM3NT.";
$lang['word_filter_help_3'] = "<b>pRE9</b> @LLoWS J00 to USe p3rL r39UL4R 3xPRE\$s1Ons +0 m4+Ch T3x+.";
$lang['nameanddesc'] = "n4me 4nd D3SCr1PT10N";
$lang['movethreads'] = "m0v3 +Hr34Ds";
$lang['movethreadstofolder'] = "m0VE Thr34DS +o F0Ld3r";
$lang['failedtomovethreads'] = "f41lED to moVe +HRe4DS +O sP3CIF13D Ph0LD3R";
$lang['resetuserpermissions'] = "reS3t U\$3R p3RM1Ss10N\$";
$lang['failedtoresetuserpermissions'] = "f@ILed tO r3s3+ U\$3r P3RmI\$S10N\$";
$lang['allowfoldertocontain'] = "all0W pH0Ld3R T0 COn+AIN";
$lang['addnewfolder'] = "aDd n3W pH0LDER";
$lang['mustenterfoldername'] = "j00 mu\$t 3NT3R A f0LD3R nAMe";
$lang['nofolderidspecified'] = "nO F0LDeR 1D SPeCIFieD";
$lang['invalidfolderid'] = "inv4l1d PH0ld3r 1D. chECK tHA+ 4 PH0LdeR w1TH tHI\$ Id 3X1sTs!";
$lang['folderdisplayorderthreadsbyfolderview'] = "fOLD3R oRD3R onLY @PPLiES wh3n us3R H@s EnABl3d 'soRT +HREAd L1sT 8y pHOLDers' iN PHOrUM 0P+10NS.";
$lang['successfullyaddednewfolder'] = "sUcCEssfULlY @dDEd NeW Ph0LDeR";
$lang['successfullyremovedselectedfolders'] = "succE\$sfULLY rEM0V3D \$3LEC+3d PHOldeRS";
$lang['successfullyeditedfolder'] = "sUCCeSSFuLlY 3dI+3D pH0Ld3r";
$lang['failedtocreatenewfolder'] = "f41Led TO Cre4T3 NEW pHOLdER";
$lang['failedtodeletefolder'] = "f@1lED To d3LE+3 F0LDeR.";
$lang['failedtoupdatefolder'] = "f@1lED +O UpD4+E PH0Lder";
$lang['cannotdeletefolderwiththreads'] = "c4NNot D3Le+e F0LdER\$ +h@+ St1LL C0n+aIN thR34DS.";
$lang['forumisnotrestricted'] = "forUM 1s no+ r3stR1C+3D";
$lang['groups'] = "gr0uPS";
$lang['nousergroups'] = "no u\$Er GR0Up\$ h4v3 be3n S3+ up. +0 4DD A 9R0UP cLICk +h3 'Add N3W' 8u++ON 83low.";
$lang['suppliedgidisnotausergroup'] = "sUpPLi3D 9Id 1\$ N0t @ u\$3R gr0UP";
$lang['manageusergroups'] = "maN@gE UseR 9r0upS";
$lang['groupstatus'] = "gROuP ST@TUS";
$lang['addusergroup'] = "add US3R 9R0up";
$lang['addemptygroup'] = "aDD eMPTy GroUP";
$lang['adduserstogroup'] = "add uS3r\$ +0 GR0uP";
$lang['addremoveusers'] = "aDd/REmoVE us3R\$";
$lang['nousersingroup'] = "tH3rE 4RE n0 Us3r\$ 1N thI\$ GROup. 4DD USEr\$ +0 This gROUp By S3@RcHIn9 foR +H3M b3lOW.";
$lang['groupaddedaddnewuser'] = "sucC3sSFuLLY 4dDED 9R0uP. @dD u\$3RS +0 TH15 grOUp By \$E@RChING f0r +h3m bEloW.";
$lang['nousersingroupaddusers'] = "th3R3 @R3 No US3RS 1N tH1\$ 9ROuP. to @DD US3Rs Cl1CK TEH '@Dd/ReM0V3 US3R\$' 8U+T0N 83l0W.";
$lang['useringroups'] = "tHi5 uS3r 1\$ 4 mEmBER 0f T3H f0LL0WINg GR0UP\$";
$lang['usernotinanygroups'] = "th1\$ u53r 1S no+ 1N 4NY USEr GrOUPS";
$lang['usergroupwarning'] = "n0+3: +hi5 UsER MAY 8E INheRIt1nG 4DDiT10N@L perm15sI0N\$ FROM 4ny USeR 9RouPS L1\$+3D 83LOW.";
$lang['successfullyaddedgroup'] = "sUcC3\$SPhulLY 4dd3D 9r0up";
$lang['successfullyeditedgroup'] = "sUcCE\$SFULLy 3DITED 9R0uP";
$lang['successfullydeletedselectedgroups'] = "suCcESSphulLY D3LE+3d sEL3Ct3D 9rOuPS";
$lang['failedtodeletegroupname'] = "f@iLEd To D3lETe 9R0up %s";
$lang['usercanaccessforumtools'] = "u\$eR C4n @Cc3\$S PhorUm TO0LS 4nD C4n cr34T3, d3lE+3 4ND 3d1t PH0RUMs";
$lang['usercanmodallfoldersonallforums'] = "u\$eR CAn m0DeR@t3 <b>aLL fOLDer\$</b> ON <b>aLL PH0RUMs</b>";
$lang['usercanmodlinkssectiononallforums'] = "uS3R CAN M0DERATE liNK\$ SEC+10n ON <b>all PH0rUM\$</b>";
$lang['emailconfirmationrequired'] = "em@IL COnf1RM4+1ON rEQuIr3d";
$lang['userisbannedfromallforums'] = "u53r I\$ B4nneD FRom <b>aLl FORUMS</b>";
$lang['cancelemailconfirmation'] = "c4nC3L EMAIl C0NFIRM4+1oN 4Nd @Ll0W us3R to ST4RT P0STIN9";
$lang['resendconfirmationemail'] = "r3\$END ConFIRM4T10N 3M@1L to U\$3R";
$lang['failedtosresendemailconfirmation'] = "f@1l3D +0 RESEnD 3MAIL ConFIrM4TI0N +O u\$eR.";
$lang['donothing'] = "d0 n0+H1NG";
$lang['usercanaccessadmintools'] = "uSEr H4S 4CCe\$\$ +o FOruM 4Dm1n t00l\$";
$lang['usercanaccessadmintoolsonallforums'] = "u\$eR H@s 4CC3sS +0 4dM1N +o0LS <b>oN 4ll PH0RUM\$</b>";
$lang['usercanmoderateallfolders'] = "u\$eR C4n MoD3R4+3 4LL f0lD3R\$";
$lang['usercanmoderatelinkssection'] = "u\$er C4N M0D3R4T3 L1NK\$ SECt10N";
$lang['userisbanned'] = "uS3r 1\$ b4NN3D";
$lang['useriswormed'] = "uS3r 1\$ w0rM3D";
$lang['userispilloried'] = "u\$ER 1\$ pilLORieD";
$lang['usercanignoreadmin'] = "uS3r C4N 19NOR3 4DM1N1STR4TORS";
$lang['groupcanaccessadmintools'] = "groUP C4N @Cc3SS 4dM1n TO0LS";
$lang['groupcanmoderateallfolders'] = "gr0UP cAn MOdER4+3 @LL ph0LD3RS";
$lang['groupcanmoderatelinkssection'] = "grOUp C@N MOD3R@t3 LInKS SEcT10NS";
$lang['groupisbanned'] = "gR0UP 1s 8@NN3D";
$lang['groupiswormed'] = "gR0uP 1S W0RM3d";
$lang['readposts'] = "re4D P0STS";
$lang['replytothreads'] = "r3plY to tHr3aD\$";
$lang['createnewthreads'] = "cR3@+E n3W +HR34DS";
$lang['editposts'] = "eDI+ PO\$ts";
$lang['deleteposts'] = "d3L3Te P0STS";
$lang['postssuccessfullydeleted'] = "pos+5 SUcC3sSFUlLY D3L3+3D";
$lang['failedtodeleteusersposts'] = "f@1l3D +O d3L3+E Us3r'S poS+S";
$lang['uploadattachments'] = "uPLo@d A++ACHMen+s";
$lang['moderatefolder'] = "m0dER4T3 PH0LD3R";
$lang['postinhtml'] = "p0\$+ 1N H+mL";
$lang['postasignature'] = "p0S+ @ 51GNA+uRE";
$lang['editforumlinks'] = "eDi+ PHORum lINkS";
$lang['linksaddedhereappearindropdown'] = "linkS 4DD3D H3r3 4Pp3AR IN 4 DROp D0WN 1N tEH +0P riGh+ 0Ph T3H FR4ME \$3t.";
$lang['linksaddedhereappearindropdownaddnew'] = "l1nKs adD3D hER3 4PP3@r 1N A DR0P dOWn IN +3H +0p R19h+ 0f T3H pHRamE \$3+. to @DD 4 l1NK CLIck tHE '@DD n3w' BuT+0N 83low.";
$lang['failedtoremoveforumlink'] = "f4Il3D To REM0V3 phORUM LINk '%s'";
$lang['failedtoaddnewforumlink'] = "f41L3D +0 4DD nEW PHorum LinK '%s'";
$lang['failedtoupdateforumlink'] = "f41L3D +0 UpD4T3 Ph0RUM l1Nk '%s'";
$lang['notoplevellinktitlespecified'] = "nO TOP leVEL l1NK T1TL3 SPECIF1ED";
$lang['youmustenteralinktitle'] = "j00 muST 3nT3R 4 LiNK t1+lE";
$lang['alllinkurismuststartwithaschema'] = "all LInK Ur15 mU\$+ s+arT w1+H 4 scHEMa (I.3. h+TP://, fTp://, irc://)";
$lang['editlink'] = "edi+ LiNK";
$lang['addnewforumlink'] = "aDD n3w F0RUM LINk";
$lang['forumlinktitle'] = "f0RUM L1NK t1TLe";
$lang['forumlinklocation'] = "fOrUm LinK loca+1On";
$lang['successfullyaddednewforumlink'] = "sUCCes\$pHULlY 4DD3D n3W FORuM LiNK";
$lang['successfullyeditedforumlink'] = "sucCESSphULLY Ed1+eD phoRuM lINk";
$lang['invalidlinkidorlinknotfound'] = "inv4L1D lInK 1D OR LInk n0T ph0UND";
$lang['successfullyremovedselectedforumlinks'] = "sUCC35sFUllY reM0VEd sEl3C+3D l1Nks";
$lang['toplinkcaption'] = "top l1NK c4Pt10N";
$lang['allowguestaccess'] = "alloW Gu3sT @CCess";
$lang['searchenginespidering'] = "s3@RCh eN9INE sPIDERINg";
$lang['allowsearchenginespidering'] = "aLL0W \$3aRcH eNGinE SP1d3RiN9";
$lang['sitemapenabled'] = "eN48lE SIT3MaP";
$lang['sitemapupdatefrequency'] = "s1TEM@P uPd4t3 PhReqU3NCY";
$lang['sitemappathnotwritable'] = "s1+eM4P dIrEC+OrY mu5+ 83 WR1+aBL3 By teH We8 SErVER / pHP pROc3sS!";
$lang['newuserregistrations'] = "nEw us3R rEgI\$tr4tI0N\$";
$lang['preventduplicateemailaddresses'] = "pR3vEn+ dUPLic4+3 EM41l 4DDrES\$3S";
$lang['allownewuserregistrations'] = "aLLoW neW US3R REgIS+Ra+1oN\$";
$lang['requireemailconfirmation'] = "r3qUIR3 eM41L C0nFiRM@tiON";
$lang['usetextcaptcha'] = "uS3 Tex+-c4P+Cha";
$lang['textcaptchafonterror'] = "t3XT-C@P+cHA H4s B33N D1s48L3D 4UTOm@TiC4lLY 83C4uSE +H3R3 4RE no +ruE +yP3 PHON+s 4v4IL@8LE phor 1+ To USE. Ple4S3 UPlo@D soME +RUe TyP3 F0N+s +0 <b>t3xt_C4P+chA/F0Nt\$</b> 0n yoUr S3RVEr.";
$lang['textcaptchadirerror'] = "tex+-C@p+cHA h4s B33N D154bled Bec@U\$3 +Eh T3xT_C4P+ch4 D1RECTOry 4ND \$UB-diR3C+0R13\$ 4R3 N0+ wRI+@BL3 8Y Teh WEb \$3RV3R / PHp PROC3SS.";
$lang['textcaptchagderror'] = "tExT-C4P+cHA hA\$ B3EN d1\$@8LEd 83CAU\$3 yOur sERvER'S pHP \$3+Up d03S Not PR0Vide \$uPport PHOr 9D im@ge m4NIPUl@t10N 4Nd / or Ttf ph0n+ \$uppor+. 8o+H 4R3 REquIR3D PHor TEx+-c4PTCh@ SUPport.";
$lang['newuserpreferences'] = "n3w Us3R pRePh3R3NcE\$";
$lang['sendemailnotificationonreply'] = "em@iL n0tiF1C@ti0n 0N rEpLY t0 US3R";
$lang['sendemailnotificationonpm'] = "em@iL NOT1PH1C4T10N on Pm +O uS3R";
$lang['showpopuponnewpm'] = "sHoW POPUP wHEn R3cEIvINg New PM";
$lang['setautomatichighinterestonpost'] = "sE+ 4uT0M@TIc HI9H IN+ERE\$t 0N PO\$+";
$lang['postingstats'] = "pOsTInG s+4+S";
$lang['postingstatsforperiod'] = "pos+1N9 s+@T\$ Ph0r PERiOD %s TO %s";
$lang['nopostdatarecordedforthisperiod'] = "n0 p0\$T D4T4 Rec0RD3D ph0r Thi\$ P3Ri0d.";
$lang['totalposts'] = "t0t4l P0\$+S";
$lang['totalpostsforthisperiod'] = "t0+@L pOS+S f0r +H1\$ p3RIOd";
$lang['mustchooseastartday'] = "mUsT ch0O\$E 4 st4Rt D4Y";
$lang['mustchooseastartmonth'] = "mu\$+ ChO0\$3 4 \$+4rT mONtH";
$lang['mustchooseastartyear'] = "mu\$T cH00se @ s+aR+ y34R";
$lang['mustchooseaendday'] = "mu\$+ chO053 @ 3nD D4y";
$lang['mustchooseaendmonth'] = "mUsT CHoo\$e 4 EnD mon+h";
$lang['mustchooseaendyear'] = "mu\$T cH00S3 @ eND YeAR";
$lang['startperiodisaheadofendperiod'] = "s+@RT p3R10D i\$ 4hE4D Oph 3Nd P3R1OD";
$lang['bancontrols'] = "b4n C0n+ROLs";
$lang['addban'] = "aDD bAN";
$lang['checkban'] = "cH3CK BaN";
$lang['editban'] = "eDi+ b4n";
$lang['bantype'] = "bAN +Yp3";
$lang['bandata'] = "b@n D@+4";
$lang['bancomment'] = "commEnT";
$lang['ipban'] = "ip 8@N";
$lang['logonban'] = "l0GON 84N";
$lang['nicknameban'] = "n1ckN@me 8aN";
$lang['emailban'] = "eMAIl bAN";
$lang['refererban'] = "rEpHEr3R B4n";
$lang['invalidbanid'] = "iNV4L1D B@N 1D";
$lang['affectsessionwarnadd'] = "th1\$ B4N mAY @FPh3c+ t3h pHolLOWiN9 4C+1VE U\$er S3\$SioN\$";
$lang['noaffectsessionwarn'] = "thi5 B4N 4PhFecTS n0 @Ct1VE s3sS1oN\$";
$lang['mustspecifybantype'] = "j00 MUS+ \$pEC1Phy @ 84n +YpE";
$lang['mustspecifybandata'] = "j00 muSt SPEc1fY SoME 84N d4t@";
$lang['successfullyremovedselectedbans'] = "sucCE\$SPHulLY r3MOVeD \$eLEcT3D 8@nS";
$lang['failedtoaddnewban'] = "f@1LEd TO ADd NEW b@N";
$lang['failedtoremovebans'] = "f41LEd tO rEMOVE SOMe 0R 4Ll 0f THe S3l3CT3d 8@NS";
$lang['duplicatebandataentered'] = "dUPLIcaT3 B4N dA+A 3NT3r3D. PLE4SE cHecK Y0UR W1LDCArDS +O SeE If +H3Y @LRE4Dy M4TCH +eh da+a 3n+3RED";
$lang['successfullyaddedban'] = "sUCC3\$SFuLLY @DDeD 8AN";
$lang['successfullyupdatedban'] = "suCC3\$\$FULlY uPD@+ED bAN";
$lang['noexistingbandata'] = "th3Re 1S n0 3xIsT1N9 8@n D4T@. +0 4DD 4 B4n ClICK TH3 '@DD NEW' 8U++oN 83L0W.";
$lang['youcanusethepercentwildcard'] = "j00 C4N USE THE PErC3N+ (%) wILDCArd sYM8oL iN @ny OF Y0ur 8@N lis+S +0 Obt4IN PArTI4L m@TcH3\$, I.3. '192.168.0.%' WOuLD 8@n alL IP 4ddR3SS3\$ IN tHE R4N9E 192.168.0.1 tHr0u9H 192.168.0.254";
$lang['cannotusewildcardonown'] = "j00 c4nNO+ 4DD % @\$ 4 w1lDCaRD MA+ch oN Its 0WN!";
$lang['requirepostapproval'] = "r3qUIrE P0ST AppR0V4L";
$lang['adminforumtoolsusercounterror'] = "tH3rE muST 8e 4T lEAST 1 U\$3R wi+h 4DMIn T00L\$ @Nd F0RUm +o0LS acCESS 0N @lL F0ruMS!";
$lang['postcount'] = "pOsT c0uNT";
$lang['resetpostcount'] = "r3s3+ PO5+ c0UN+";
$lang['failedtoresetuserpostcount'] = "f41lED to rE\$3+ po\$t C0UN+";
$lang['failedtochangeuserpostcount'] = "f41L3D +O Ch@N9E U\$ER pOS+ coUnT";
$lang['postapprovalqueue'] = "p0st 4PProV4l qUEue";
$lang['nopostsawaitingapproval'] = "nO PO\$Ts @r3 4W@1T1N9 4PpRoV@l";
$lang['approveselected'] = "aPPR0VE \$ELec+ED";
$lang['failedtoapproveuser'] = "f4iL3D t0 4PPr0V3 US3R %s";
$lang['kickselected'] = "k1ck \$3L3cT3D";
$lang['visitorlog'] = "v151tOr L09";
$lang['novisitorslogged'] = "no V1s1TOrs L099Ed";
$lang['addselectedusers'] = "aDd sElEC+eD u5ER\$";
$lang['removeselectedusers'] = "r3mOV3 SEl3c+3D U\$3R\$";
$lang['addnew'] = "aDD N3w";
$lang['deleteselected'] = "d3l3T3 \$3LECt3d";
$lang['forumrulesmessage'] = "<p><b>fOrUM rul35</b></p><p>\nR39ISTr@T10n +0 %1\$\$ 1s phRe3! We D0 1N\$1S+ +H@T j00 4B1DE 8y tEH rUl3S 4ND P0L1C1E\$ D3+AiL3D BelOW. If J00 49REe TO T3H +3RM\$, Pl34\$3 CheCK TH3 'i @9RE3' CH3Ck80x 4Nd PResS tH3 'R3Gis+3R' buTTon 83LOW. 1PH J00 W0ULd L1K3 TO C4NC3L +3H R3GIS+Ra+10N, cl1CK %2\$\$ +0 RE+uRN to t3h Ph0rUMS 1ND3X.</p><p>\nALtH0uGH +EH 4dm1N1STR4+0RS 4ND m0DER4+ORS 0ph %1\$\$ W1LL @TTEmpT tO K3EP aLL O8JECtI0N4BLE m3\$S493s OFPh TH1\$ pH0RUM, I+ i\$ ImPO\$S18LE pH0R U\$ T0 REv1EW AlL MEss4GE\$. 4lL ME\$5493\$ 3xPRESs +3h V13wS 0F +H3 autH0R, aNd Ne1+H3R +he 0wNeR\$ 0f %1\$\$, N0R PROJECt 83EhIVE PH0rum 4Nd 1t's @FF1lI4tE\$ w1Ll 83 H3ld ReSP0nS1bL3 F0R +Eh cON+3NT OF 4NY M3Ss@Ge.</p><p>\nby 4Gr33inG tO +h3s3 RUl3s, j00 w@RR4n+ +H4+ J00 WIll n0+ pOsT @NY m3SS49Es TH4+ aR3 ObSc3n3, VUL9@r, SexU@lLY-ORI3N+@ted, H4T3PHUL, tHRe4+3nING, 0R 0+h3Rw1\$3 v1oLA+1ve Of 4nY l4wS.</p><p>thE oWN3R\$ 0pH %1\$5 RE5ErvE tHe R19ht TO r3m0v3, Edit, MOv3 or Cl0SE 4NY +HR34D PH0r 4ny R3@\$On.</p>";
$lang['cancellinktext'] = "h3RE";
$lang['failedtoupdateforumsettings'] = "f41lED T0 UpD@TE PHOrUM S3+t1nG5. PlE@s3 +RY 494IN L4+3R.";
$lang['moreadminoptions'] = "morE Adm1n 0PT1On5";

// Admin Log data (admin_viewlog.php) --------------------------------------------

$lang['changedstatusforuser'] = "cH4N9eD uS3R s+@tUS FOr '%s'";
$lang['changedpasswordforuser'] = "ch4N93D p@SSWoRD PHOR '%s'";
$lang['changedforumaccess'] = "cH@n9eD F0RUM 4CC3SS P3RMISS10ns F0R '%s'";
$lang['deletedallusersposts'] = "d3lE+3D 4lL PO\$TS F0R '%s'";

$lang['createdusergroup'] = "cR3ATed US3R 9ROUp '%s'";
$lang['deletedusergroup'] = "dEL3+3D US3R 9rOUP '%s'";
$lang['updatedusergroup'] = "upd4+3D Us3R 9ROuP '%s'";
$lang['addedusertogroup'] = "aDDEd US3R '%s' t0 gROUP '%s'";
$lang['removeduserfromgroup'] = "rem0vE U5ER '%s' PhROM 9R0UP '%s'";

$lang['addedipaddresstobanlist'] = "addED 1p '%s' TO 84N lI\$t";
$lang['removedipaddressfrombanlist'] = "reM0VEd IP '%s' pHR0M 84N L1sT";

$lang['addedlogontobanlist'] = "add3d LO90n '%s' +O 8@N lIS+";
$lang['removedlogonfrombanlist'] = "r3mOV3D lOG0N '%s' PhROM 8@N lIS+";

$lang['addednicknametobanlist'] = "aDD3d n1CKn4mE '%s' TO 8AN l1S+";
$lang['removednicknamefrombanlist'] = "rEm0VeD niCKN4M3 '%s' pHr0M b@n LI\$T";

$lang['addedemailtobanlist'] = "add3D 3M41l 4DDReS5 '%s' TO 84N LisT";
$lang['removedemailfrombanlist'] = "remOVEd EM@iL aDDrE\$S '%s' PhROM B@N lI\$+";

$lang['addedreferertobanlist'] = "add3d R3ph3REr '%s' +O bAN l1s+";
$lang['removedrefererfrombanlist'] = "rEm0v3D rEFEreR '%s' FroM 84N liS+";

$lang['editedfolder'] = "eD1TeD f0ld3R '%s'";
$lang['movedallthreadsfromto'] = "movED 4LL +Hr34ds FROm '%s' +0 '%s'";
$lang['creatednewfolder'] = "cR34+eD NEW Ph0LDER '%s'";
$lang['deletedfolder'] = "deL3T3D foLd3r '%s'";

$lang['changedprofilesectiontitle'] = "cH4N9ED pR0FIL3 sEC+I0N t1Tl3 PHr0M '%s' to '%s'";
$lang['addednewprofilesection'] = "addED nEw proFILE S3CTION '%s'";
$lang['deletedprofilesection'] = "d3LeT3D prOFiL3 S3CtiOn '%s'";

$lang['addednewprofileitem'] = "addED n3W pr0F1L3 i+3M '%s' +O s3CT1on '%s'";
$lang['changedprofileitem'] = "ch4NGED PR0FIl3 i+Em '%s'";
$lang['deletedprofileitem'] = "dEL3+3D Pr0FILe 1+3M '%s'";

$lang['editedstartpage'] = "eD1t3d StArT paGe";
$lang['savednewstyle'] = "s@V3D NeW \$+YL3 '%s'";

$lang['movedthread'] = "mOv3D +HrEAD '%s' fR0M '%s' +O '%s'";
$lang['closedthread'] = "cLoS3D +hRE4D '%s'";
$lang['openedthread'] = "op3N3D ThR34D '%s'";
$lang['renamedthread'] = "ren@MeD THR34d '%s' T0 '%s'";

$lang['deletedthread'] = "d3l3+3D +hRE4D '%s'";
$lang['undeletedthread'] = "uNDEl3+3D +HReAD '%s'";

$lang['lockedthreadtitlefolder'] = "l0ck3D +hRE4D opT10N\$ 0N '%s'";
$lang['unlockedthreadtitlefolder'] = "uNLOCKeD +hREaD optI0Ns On '%s'";

$lang['deletedpostsfrominthread'] = "dELE+ed PO\$+S phROM '%s' In THrE4D '%s'";
$lang['deletedattachmentfrompost'] = "d3L3+3D 4Tt@ChM3NT '%s' PhrOM p0sT '%s'";

$lang['editedforumlinks'] = "eD1+eD pH0Rum LInK5";
$lang['editedforumlink'] = "eD1+ED F0RUm L1Nk: '%s'";

$lang['addedforumlink'] = "aDd3d PhoRUm L1Nk: '%s'";
$lang['deletedforumlink'] = "d3l3T3D f0RUM lInK: '%s'";
$lang['changedtoplinkcaption'] = "ch@nGEd +0P LiNK c4PTi0N PHr0m '%s' t0 '%s'";

$lang['deletedpost'] = "dEL3T3D pOST '%s'";
$lang['editedpost'] = "eDI+Ed PO\$+ '%s'";

$lang['madethreadsticky'] = "m4De +Hr3@d '%s' S+1CKy";
$lang['madethreadnonsticky'] = "m4D3 tHR34D '%s' nON-sT1ckY";

$lang['endedsessionforuser'] = "eNd3D S35S1ON PH0R US3R '%s'";

$lang['approvedpost'] = "aPpROV3d P0\$+ '%s'";

$lang['editedwordfilter'] = "ed1+3D W0Rd FILtEr";

$lang['addedrssfeed'] = "addED rSS f33D '%s'";
$lang['editedrssfeed'] = "edi+3D rs\$ F3ED '%s'";
$lang['deletedrssfeed'] = "delET3D rss pH33D '%s'";

$lang['updatedban'] = "updA+eD B4N '%s'. Ch4N9ED TyPE frOm '%s' tO '%s', ChaNgeD d4+@ fR0M '%s' +0 '%s'.";

$lang['splitthreadatpostintonewthread'] = "sPL1t +HreAD '%s' AT p0sT %s  1N+0 N3W +hrE4D '%s'";
$lang['mergedthreadintonewthread'] = "m3R93D +HRe4ds '%s' 4ND '%s' 1N+0 N3W +HRe4D '%s'";

$lang['ipaddressbanhit'] = "u53R '%s' iS 84NnED. Ip 4DDr3sS '%s' MAtCH3D 8aN D4+@ '%s'";
$lang['logonbanhit'] = "usEr '%s' 1\$ B@NN3D. L090N '%s' M4TcH3D 8@n Da+A '%s'";
$lang['nicknamebanhit'] = "uSER '%s' I\$ b4NN3D. N1CkN4ME '%s' M4tCH3d b4N d@T@ '%s'";
$lang['emailbanhit'] = "uS3R '%s' IS 8@nN3D. eM4IL 4DDReSS '%s' Ma+ChED b4n D@T4 '%s'";
$lang['refererbanhit'] = "u\$er '%s' i\$ B4NNed. HtTP R3PHeR3R '%s' m@Tch3D B4n D4T4 '%s'";

$lang['modifiedpermsforuser'] = "m0dIFiED pErM\$ Phor uS3R '%s'";
$lang['modifiedfolderpermsforuser'] = "m0DIF1eD PHOLD3r p3rm\$ PH0R U\$3r '%s'";

$lang['userpermfoldermoderate'] = "foLDEr mOD3R4tOR";

$lang['adminlogempty'] = "admIN LOg I5 EMpTY";

$lang['youmustspecifyanactiontypetoremove'] = "j00 Mus+ \$PEcIFy 4N 4C+I0N +YpE +0 R3MOvE";

$lang['alllogentries'] = "aLl lo9 En+RIEs";
$lang['userstatuschanges'] = "us3R St@TUs CH@NgES";
$lang['forumaccesschanges'] = "forUM aCC3S\$ Ch4N9E5";
$lang['usermasspostdeletion'] = "u\$ER m@SS PO\$+ dELEtiON";
$lang['ipaddressbanadditions'] = "ip @DdR3S\$ b4n ADDI+10N\$";
$lang['ipaddressbandeletions'] = "ip 4Ddre5S B4N d3LETioN\$";
$lang['threadtitleedits'] = "thre4d TiTL3 ed1+S";
$lang['massthreadmoves'] = "m4sS +hrE4D m0VEs";
$lang['foldercreations'] = "f0lDER CR3@T10N\$";
$lang['folderdeletions'] = "f0LDer d3LE+1ONS";
$lang['profilesectionchanges'] = "pRoPh1L3 SEctION CH@N9E\$";
$lang['profilesectionadditions'] = "proPHIL3 SEC+1oN 4DDITI0N5";
$lang['profilesectiondeletions'] = "proPH1LE \$eCtIoN dEl3+10NS";
$lang['profileitemchanges'] = "proFIL3 i+em CH@n9E5";
$lang['profileitemadditions'] = "pr0F1Le 1+3m 4Dd1TIonS";
$lang['profileitemdeletions'] = "pROPHIL3 i+EM DEl3+10NS";
$lang['startpagechanges'] = "sT4r+ P49E cH4NgE\$";
$lang['forumstylecreations'] = "fORUm sTYLe CrE4TiON\$";
$lang['threadmoves'] = "thrE4D m0V3s";
$lang['threadclosures'] = "thR34D cL0\$uR3\$";
$lang['threadopenings'] = "thrE4d 0PEN1N9s";
$lang['threadrenames'] = "thrEAd r3N@M3\$";
$lang['postdeletions'] = "p0sT DElE+10NS";
$lang['postedits'] = "po\$+ 3DI+s";
$lang['wordfilteredits'] = "worD pHIl+3R 3di+S";
$lang['threadstickycreations'] = "thr3@D st1CKY Cr3A+1oN\$";
$lang['threadstickydeletions'] = "tHr3AD \$TIcKY DELe+10NS";
$lang['usersessiondeletions'] = "u5eR S3Ss1on D3L3ti0NS";
$lang['forumsettingsedits'] = "forUM SE+T1NGS ED1ts";
$lang['threadlocks'] = "thR3@d L0CkS";
$lang['threadunlocks'] = "tHRe4D uNLOck\$";
$lang['usermasspostdeletionsinathread'] = "u\$3r m4sS p0\$T dELEtI0NS 1n A THr34d";
$lang['threaddeletions'] = "thrE4D d3lE+1Ons";
$lang['attachmentdeletions'] = "a+T4CHm3N+ DEl3+10NS";
$lang['forumlinkedits'] = "f0rUM L1Nk ED1Ts";
$lang['postapprovals'] = "p05T 4PpROv4L\$";
$lang['usergroupcreations'] = "useR 9rOUP CRe4t1ON\$";
$lang['usergroupdeletions'] = "u53r 9roUp DeL3+10Ns";
$lang['usergroupuseraddition'] = "us3R 9ROup US3R @DD1+10N";
$lang['usergroupuserremoval'] = "useR 9ROup US3R R3MOv4L";
$lang['userpasswordchange'] = "u53R p@SSWOrd ChaNge";
$lang['usergroupchanges'] = "uS3R Gr0uP CH@NgeS";
$lang['ipaddressbanadditions'] = "ip 4DDRESS b@N 4DD1tI0N5";
$lang['ipaddressbandeletions'] = "iP @DdR3\$S b4N dELe+1oN\$";
$lang['logonbanadditions'] = "lo90N b4N 4Dd1Ti0ns";
$lang['logonbandeletions'] = "lo90N B4N d3L3TION\$";
$lang['nicknamebanadditions'] = "n1cKN4M3 B4n 4Dd1tI0Ns";
$lang['nicknamebanadditions'] = "n1ckN4Me b4n @dD1+1ON\$";
$lang['e-mailbanadditions'] = "e-M41L 8@N 4dD1TIonS";
$lang['e-mailbandeletions'] = "e-m4IL b4N DElE+i0n\$";
$lang['rssfeedadditions'] = "r\$\$ f3ed @dDI+i0NS";
$lang['rssfeedchanges'] = "r5S fEEd Ch4Nge\$";
$lang['threadundeletions'] = "thr34d unDEle+1On\$";
$lang['httprefererbanadditions'] = "httP rEPhEr3R 8@N 4ddi+1ON\$";
$lang['httprefererbandeletions'] = "htTP R3fEreR b@N D3LE+1oN5";
$lang['rssfeeddeletions'] = "rsS PH33D dEL3tI0N\$";
$lang['banchanges'] = "b4n Ch4N9E5";
$lang['threadsplits'] = "thrE4D SpLI+S";
$lang['threadmerges'] = "thr3AD mERGe\$";
$lang['forumlinkadditions'] = "f0rUM LinK 4Dd1TI0nS";
$lang['forumlinkdeletions'] = "f0rUM L1nk D3LE+ioN5";
$lang['forumlinktopcaptionchanges'] = "fORUM l1nK TOp C@p+10N cHAnGE\$";
$lang['folderedits'] = "f0lD3R 3d1t\$";
$lang['userdeletions'] = "u\$ER D3LE+10NS";
$lang['userdatadeletions'] = "u\$3R Da+4 d3l3+1ON\$";
$lang['usergroupchanges'] = "uSeR 9R0UP CH4N93S";
$lang['ipaddressbancheckresults'] = "ip 4DDR3\$S bAN CHeCK R3suLtS";
$lang['logonbancheckresults'] = "lO90n 8@N CHEcK ResULTS";
$lang['nicknamebancheckresults'] = "nicKNAM3 8AN cH3CK r3\$ULt\$";
$lang['emailbancheckresults'] = "eMAIL baN CH3ck R3\$ULt\$";
$lang['httprefererbancheckresults'] = "httP R3F3Rer b4n CHeCk Re5uLTS";

$lang['removeentriesrelatingtoaction'] = "r3m0VE 3n+rIEs r3L4+1N9 +o 4CTiON";
$lang['removeentriesolderthandays'] = "r3m0V3 En+R13S 0LdER tH@N (D4Y\$)";

$lang['successfullyprunedadminlog'] = "sucCE\$sPHuLLy PrUNeD 4DMIn LOg";
$lang['failedtopruneadminlog'] = "f41L3D +0 PRun3 4Dm1N loG";

$lang['successfullyprunedvisitorlog'] = "sucC3sSFulLY PrUNed V151toR l09";
$lang['failedtoprunevisitorlog'] = "f@ilED +0 pRUne Vis1+Or lO9";

$lang['prunelog'] = "pRUNE L0G";

// Admin Forms (admin_forums.php) ------------------------------------------------

$lang['noexistingforums'] = "no 3xI\$T1NG F0RuMS f0uND. +0 cR3@T3 a N3W f0rUm Cl1ck +eh '4Dd New' BUTtoN 83LOW.";
$lang['webtaginvalidchars'] = "w3b+A9 c4N 0NlY c0NT@iN uPP3rC4\$3 4-Z, 0-9 4ND UNd3RScoR3 chAR4Ct3R\$";
$lang['databasenameinvalidchars'] = "d4+aBA\$E n4m3 c4n ONLy C0N+41N 4-Z, @-z, 0-9 4ND unDer\$cOR3 cHAR4CtERs";
$lang['invalidforumidorforumnotfound'] = "inV@L1D pH0RUm PhId OR pHOrUM NOT pHOUnD";
$lang['successfullyupdatedforum'] = "sucC3SSFUlLY uPD4+3D fORum";
$lang['failedtoupdateforum'] = "f41LeD tO UpD4+e F0RUm: '%s'";
$lang['successfullycreatednewforum'] = "sucC35\$PhULlY Cre4T3D n3W PH0RuM";
$lang['selectedwebtagisalreadyinuse'] = "teh S3LEct3D WeB+49 I5 @LR34dY 1N u\$E. Pl34s3 CH00se @NOThER.";
$lang['selecteddatabasecontainsconflictingtables'] = "t3h \$3LECt3D D4+@84S3 c0N+Ain5 conPHL1c+1N9 +4bLes. CONflIcTiNG t48lE N4mEs @r3:";
$lang['forumdeleteconfirmation'] = "aRE J00 SuR3 j00 W4Nt To DElE+e 4Ll 0F T3h \$3l3C+ed PhoRUmS?";
$lang['forumdeletewarning'] = "pL3A\$3 N0+e +H@t j00 CANn0T REcoV3R DELe+3D PH0RUM5. ONC3 D3L3+3d @ F0rUM 4ND 4LL 0f tHE @\$s0cI4+3D D4T4 1\$ PERm@N3nTLY rEM0VED Phr0M TEH d4T@8@5E. 1F J00 D0 No+ W15H +O D3LE+3 T3h s3lEc+3d F0RUMS PLe4S3 CL1CK CAnc3l.";
$lang['successfullyremovedselectedforums'] = "sUcCe\$sPhUllY dEL3teD \$ELECt3D phOrUM5";
$lang['failedtodeleteforum'] = "f@1l3D +0 d3L3TEd F0RuM: '%s'";
$lang['addforum'] = "aDd ph0ruM";
$lang['editforum'] = "eDi+ F0RuM";
$lang['visitforum'] = "vIsI+ pHorUm: %s";
$lang['accesslevel'] = "aCc3sS L3VeL";
$lang['forumleader'] = "f0RuM L34DeR";
$lang['usedatabase'] = "u5E Da+AbA5E";
$lang['unknownmessagecount'] = "unKNOwN";
$lang['forumwebtag'] = "forUM w38+Ag";
$lang['defaultforum'] = "d3F4ULT PH0Rum";
$lang['forumdatabasewarning'] = "pLeASe EnSUR3 j00 5EleCT +3H COrRECT d4+48A\$3 WhEN CRe4+1N9 A N3W pH0RUm. oNC3 cR34+3D 4 nEw FOrUm C4NN0T 83 moVeD 83Tw3EN 4V@iL@8lE D4+AbA\$eS.";

// Admin Global User Permissions

$lang['globaluserpermissions'] = "gLo8AL u\$3R PErM1SS10N\$";

// Admin Forum Settings (admin_forum_settings.php) -------------------------------

$lang['mustsupplyforumwebtag'] = "j00 mU\$t sUpPLy 4 F0RUm W38T@g";
$lang['mustsupplyforumname'] = "j00 MuST suPPlY 4 pHORUm N4Me";
$lang['mustsupplyforumemail'] = "j00 MU\$+ supPLy @ fORuM 3m41l 4ddREss";
$lang['mustchoosedefaultstyle'] = "j00 MUsT chO0\$e 4 dEFAul+ FOrUM \$+Yl3";
$lang['mustchoosedefaultemoticons'] = "j00 Mu\$+ ch00sE d3F4ul+ ForuM EM0ticONs";
$lang['mustsupplyforumaccesslevel'] = "j00 mus+ sUPpLY @ foRum @ccEsS L3VEl";
$lang['mustsupplyforumdatabasename'] = "j00 MU5+ 5uPPLY 4 phOrUM D4t4b@5E n4m3";
$lang['unknownemoticonsname'] = "unkn0WN 3M0ticoN\$ N4m3";
$lang['mustchoosedefaultlang'] = "j00 MusT Ch0o\$3 4 DEF4ulT foRum L4NgU4G3";
$lang['activesessiongreaterthansession'] = "aC+1V3 Se55Ion T1meOut c4NNot b3 Gr34t3R TH4N 5E\$SI0N TIm30u+";
$lang['attachmentdirnotwritable'] = "att@Chm3Nt DiREc+0RY @nd SYS+3m t3MPOr4Ry D1R3ctoRY / Php.Ini 'upl04d_+Mp_d1R' must 83 wRit4blE bY teh W38 \$3rVER / php PR0C3\$s!";
$lang['attachmentdirblank'] = "j00 Mu5T SUPPlY 4 D1reCt0rY t0 \$@v3 4++@chMEn+5 1N";
$lang['mainsettings'] = "m@1n s3+TINgs";
$lang['forumname'] = "f0ruM N@M3";
$lang['forumemail'] = "f0RUm EM@iL";
$lang['forumnoreplyemail'] = "n0-R3PLy eM41L";
$lang['forumdesc'] = "f0rUM d3SCR1p+10N";
$lang['forumkeywords'] = "fOrUM K3YWOrDS";
$lang['defaultstyle'] = "d3F4uLT 5+YlE";
$lang['defaultemoticons'] = "dEpHauL+ EMoT1COn\$";
$lang['defaultlanguage'] = "d3fAUlt L4N9u@9E";
$lang['forumaccesssettings'] = "f0RUM aCC3SS 5e+T1N9S";
$lang['forumaccessstatus'] = "f0rUm @CcES5 \$+4TUs";
$lang['changepermissions'] = "ch4N9E P3Rm1sS10NS";
$lang['changepassword'] = "cH@Nge P4\$sW0RD";
$lang['passwordprotected'] = "pASswORD pRO+3C+3D";
$lang['passwordprotectwarning'] = "j00 H4V3 N0+ \$3+ 4 F0Rum p@\$5W0RD. If J00 DO NOt S3+ @ p4SSWorD tHE PAs\$W0Rd ProT3CtI0N FUNcT10N4LI+y w1lL 8E aUTom4+1C4Lly d1s@8L3D!";
$lang['postoptions'] = "p05+ OPt10NS";
$lang['allowpostoptions'] = "all0W posT 3di+1Ng";
$lang['postedittimeout'] = "p0sT 3Di+ +IMEoUT";
$lang['posteditgraceperiod'] = "p0s+ eD1T 9r4c3 pER10D";
$lang['wikiintegration'] = "w1kiWIkI 1N+EGr4T1ON";
$lang['enablewikiintegration'] = "eNA8L3 WIKiWikI INt39R@t10N";
$lang['enablewikiquicklinks'] = "en@8LE WikIw1K1 Qu1CK L1Nk\$";
$lang['wikiintegrationuri'] = "w1kIw1Ki L0ca+1ON";
$lang['maximumpostlength'] = "m4xiMuM P0s+ LEnGTh";
$lang['postfrequency'] = "posT pHR3Qu3NcY";
$lang['enablelinkssection'] = "eN48L3 LiNkS S3cT10N";
$lang['allowcreationofpolls'] = "all0W cR34T10n 0F p0lls";
$lang['allowguestvotesinpolls'] = "aLLOw 9U3S+S +O V0+e IN P0Ll\$";
$lang['unreadmessagescutoff'] = "uNR34D m3\$s49ES cU+-0FF";
$lang['disableunreadmessages'] = "d1S4blE UNrE4D me5SAgE5";
$lang['thirtynumberdays'] = "30 d4y\$";
$lang['sixtynumberdays'] = "60 d@YS";
$lang['ninetynumberdays'] = "90 D@YS";
$lang['hundredeightynumberdays'] = "180 D4YS";
$lang['onenumberyear'] = "1 yE4R";
$lang['unreadcutoffchangewarning'] = "d3peNd1N9 0n \$3rV3R perF0RMaNC3 4Nd +EH NUM8ER of Thr34Ds YOUR F0RUms cON+41N, CH4NGinG +H3 UnR34D Cu+-0FF M4Y +@ke \$EVEr4l MInuTEs +o C0mPlE+3. PhoR +H1\$ RE4s0N It IS RECOmMENd3D +hA+ J00 4VOID CH4N9IN9 +hI\$ 5e++1NG wH1LE y0UR FORumS 4RE 8uSY.";
$lang['unreadcutoffincreasewarning'] = "iNcR3A\$1NG ThE UnRE4D cu+-0fF WilL M4K3 tHReADS m4rKEd 4S MOdIPh1eD s1NC3 4ND +Hre@D\$ 0lD3R +HAN THE PREv10u\$ cu+-OfpH APPeaR 4S unR3@D +O ALL U\$3RS";
$lang['confirmunreadcutoff'] = "are J00 SuRE J00 W4Nt +0 CHaN93 th3 Unr34d cUT-0pHF?";
$lang['otherchangeswillstillbeapplied'] = "cliCKinG 'no' wILl 0NLy C4NCeL +3h UnR34D cuT-0ff ChANgES. oTh3R cH@n9e\$ YOU'vE M4D3 WiLL s+1Ll 8E S4vED.";
$lang['searchoptions'] = "sE4rCh Opt10N\$";
$lang['searchfrequency'] = "sE4rCh FR3qU3NCy";
$lang['sessions'] = "s3ss10NS";
$lang['sessioncutoffseconds'] = "seS\$10N CUt OpHF (s3C0Nds)";
$lang['activesessioncutoffseconds'] = "act1VE S3ss10N Cut OfF (s3c0NDs)";
$lang['stats'] = "st4t\$";
$lang['hide_stats'] = "h1D3 \$T@ts";
$lang['show_stats'] = "sHOW ST4TS";
$lang['enablestatsdisplay'] = "enabLE \$Ta+S d1\$Pl4Y";
$lang['personalmessages'] = "p3r50NAl m3\$s@GeS";
$lang['enablepersonalmessages'] = "eN4bLe PErsON4L MESS493\$";
$lang['pmusermessages'] = "pm MESs493\$ Per us3R";
$lang['allowpmstohaveattachments'] = "allow PEr\$0N4L Mess@GEs +O h@VE @+T4cHMeN+5";
$lang['autopruneuserspmfoldersevery'] = "aUtO PRunE USEr'S Pm pH0LdER\$ EV3Ry";
$lang['userandguestoptions'] = "us3R @Nd 9UES+ 0p+10NS";
$lang['enableguestaccount'] = "en48LE 9UE\$+ 4CCoUN+";
$lang['listguestsinvisitorlog'] = "lISt 9UEsTS 1N Vis1+0R lO9";
$lang['allowguestaccess'] = "aLl0W 9u3\$T @CcES5";
$lang['userandguestaccesssettings'] = "uSER 4nD Gu3St @cCe\$S \$eT+1Ng\$";
$lang['allowuserstochangeusername'] = "aLLOw U\$3RS to cHaNGE US3RN4M3";
$lang['requireuserapproval'] = "reqUIrE uS3R @pPr0V4L 8y @DmiN";
$lang['requireforumrulesagreement'] = "reqUiRE u\$3R TO 4grEE +0 FoRUm RUL3s";
$lang['sendnewuseremailnotifications'] = "s3nD N0TIfiC4+ion +o 9LOb4l pH0RUM 0WNER";
$lang['enableattachments'] = "eN@Bl3 At+4CHmEn+S";
$lang['attachmentdir'] = "a++4CHm3N+ D1r";
$lang['userattachmentspace'] = "at+4CHMeNT \$P4C3 p3R uS3R";
$lang['allowembeddingofattachments'] = "allOW eMBeDd1N9 0Ph 4+t4CHmEN+S";
$lang['usealtattachmentmethod'] = "u53 ALt3RN4+1V3 @TTaCHM3N+ MEtHOD";
$lang['allowgueststoaccessattachments'] = "allOW 9UEST\$ +0 @CCe\$\$ A++4CHm3N+s";
$lang['forumsettingsupdated'] = "f0rUM s3++1nGS \$uCcE\$SPhULlY uPDa+eD";
$lang['forumstatusmessages'] = "f0rUM sT4+U\$ Mes\$@9E5";
$lang['forumclosedmessage'] = "forUM clO\$3D ME\$S@9e";
$lang['forumrestrictedmessage'] = "f0rUM r3\$Tr1Ct3d mE\$S49E";
$lang['forumpasswordprotectedmessage'] = "f0RUM pASSwORd Pr0+EcTEd M3SsAgE";

// Admin Forum Settings Help Text (admin_forum_settings.php) ------------------------------

$lang['forum_settings_help_10'] = "<b>po5T 3DI+ TiM30U+</b> iS +3H +1m3 IN M1NUtE\$ 4pHtER PO\$+1N9 THa+ 4 U\$3R c@N 3d1t +h31r p0\$+. iF S3+ t0 0 +hERE i\$ no LIM1+.";
$lang['forum_settings_help_11'] = "<b>m4x1MUm P0S+ L3NG+H</b> Is T3H M4X1MUm Num8ER 0F cH@r4C+er\$ +H4t W1Ll 83 D1sPL4YED 1N @ p0\$+. IF @ P0\$+ i\$ lONgeR +H@N thE NUm83R 0f CH@r@C+3R\$ DEF1neD hERe It W1ll 83 Cu+ \$hOR+ 4Nd A LINk 4dDED +O THe 80++0m +o @LLow US3R\$ +0 r34D +h3 WhOL3 po\$+ oN a S3P@R@T3 P493.";
$lang['forum_settings_help_12'] = "iF J00 D0N't W4Nt Y0Ur U\$3rs t0 83 48L3 To Cr34T3 POlL\$ j00 c4N d1s@blE TEh @80vE 0P+1oN.";
$lang['forum_settings_help_13'] = "t3h LInk\$ 53cTioN 0f 83Eh1VE pRov1DES @ PL@c3 fOR yoUR UsERs +0 M@INT4IN a Li\$T Oph S1T3\$ +H3y FREQuEN+Ly V1\$It +HA+ 0tHEr usERS M4Y f1ND Us3fuL. lINK5 C@n B3 DIvIDed in+0 Ca+E9ORIe\$ BY PHOlD3r @ND 4LLOw FOr COMM3ntS @ND rA+1N9S +O b3 GIv3n. 1n 0RD3R +O mODEr4+3 TEH L1NK\$ S3cTi0n 4 U\$3r MUs+ Be R4N+3D gL084L M0DER4T0R ST4TUS.";
$lang['forum_settings_help_15'] = "<b>s3\$s10N cuT OpHF</b> 1S +3h M4X1MUm T1ME 8ePH0R3 4 U\$3R'S seSSIon 1\$ d33m3D de4D 4ND +H3Y @RE l0GGEd 0U+. By d3ph@ul+ +H1\$ I\$ 24 HOUr\$ (86400 S3C0NDS).";
$lang['forum_settings_help_16'] = "<b>act1V3 SEss1oN cu+ oFpH</b> I\$ +3H m4x1MUm +1ME 83F0RE 4 US3R's S3S51On 1S DeEMed In@C+1VE 4+ WhICh P01N+ THeY en+3R 4N 1DL3 ST4+3. 1n tH1\$ s+4T3 +eH us3R r3M@iNS loGgED iN, BU+ +Hey @re R3M0V3d FR0M +3h 4C+iVE US3RS Li\$t 1N Th3 ST4TS d1SPl4y. 0NcE +hEY 8EC0M3 4C+1Ve 4941N th3Y WiLL 83 R3-4DdED +0 ThE lIST. 8Y def4UL+ +H1\$ \$3+T1NG i\$ \$3+ +0 15 M1nU+es (900 \$3C0nD\$).";
$lang['forum_settings_help_17'] = "en48lINg +H1s 0PTIOn @lLOWS 83EHiVE To 1NClUDE 4 S+4+\$ d1SPL4y 4+ +H3 boTtoM oph tH3 mE\$saGES PAnE \$1MiL@R +o T3h 0nE uSEd By M@NY PHORuM SOpH+wAR3 +i+Les. oNc3 EN4bled +hE D15Pl4y Of THe \$T4+s PAgE c4n bE TOggl3D InD1VIdu@LlY bY 3Ach U\$ER. IF th3Y D0N'+ W4N+ +0 Se3 IT tH3Y CAn HidE iT pHr0m VIeW.";
$lang['forum_settings_help_18'] = "pERs0n4L MESs@93s @R3 inV4LU@8L3 @\$ @ W4Y of T4k1n9 M0r3 Pr1V4T3 M4+T3RS 0u+ 0Ph V13W oF tH3 O+H3R m3M83R\$. hOWeVER IF j00 D0n'+ W4NT Y0UR u\$3RS TO 8E 4BLe TO s3ND E4CH O+heR pEr\$ONaL M3\$s@9es j00 C@n d1s48LE ThiS 0pTioN.";
$lang['forum_settings_help_19'] = "p3r\$0NAl M3sS49E\$ c@n 4L\$o CoN+aIN 4+T@ChM3Nt\$ wH1CH c4N b3 usEful FOr ExCH4N91N9 F1LEs bE+w3en UseR\$.";
$lang['forum_settings_help_20'] = "<b>nO+3:</b> +hE \$P4C3 4lL0C@+1oN F0r pM @++@CHm3n+s I\$ t4Ken fR0m EaCH USErS' m41N 4T+4chmEN+ All0CA+1oN @ND 1\$ N0T 1N @ddI+1oN TO.";
$lang['forum_settings_help_21'] = "<b>eN4blE gUE\$+ ACC0unT</b> @LL0ws v151TOrs +O BRoW\$E yOUR F0RUm @nD r34D Po\$+S wITh0U+ reGiST3RInG @ u\$3R acC0UNt. 4 U\$er @CCouNT 1\$ STILl R3Qu1rEd If TH3Y w1\$h +0 P0ST 0R ch4N93 U\$3R Pr3pH3REncE\$.";
$lang['forum_settings_help_22'] = "<b>l15+ 9Ues+S 1N vI\$1+Or l09</b> 4LL0w5 j00 T0 \$pECIFy wHE+H3R Or N0T UnREgISTEr3D U\$3rs Ar3 LIS+3d 0N +H3 Vi\$I+OR LOG @L0Ng\$1dE r3GIS+3rED US3RS.";
$lang['forum_settings_help_23'] = "be3h1V3 @lLOws 4+T@cHm3NTS +0 8E uPLo@DeD tO M3ss493s wh3N p0\$+ed. 1F J00 h4VE l1Mi+ED w3B Sp@Ce J00 M4Y wH1CH TO D1\$@8L3 4+T4ChMENtS 8Y CL3AriNg Th3 8OX 480V3.";
$lang['forum_settings_help_24'] = "<b>aT+4CHmEN+ D1R</b> 1\$ +EH loCa+10N BE3HiVE \$HoulD SToR3 4++4cHM3NtS iN. THI\$ d1R3CTorY MUsT 3X1ST ON y0ur WEb Sp4C3 4ND MusT 8e WR1+48le 8y +h3 W3b \$ErVEr / PHp PrOC3\$S 0th3RW1S3 uPlo4DS WIll F4Il.";
$lang['forum_settings_help_25'] = "<b>aT+@CHm3nt sP4Ce P3r USEr</b> is +3h M4X1MUm @mOUnt 0F dISK SP4Ce 4 UsER h@S f0R @Tt4cHMeN+S. OnC3 +hiS sP@cE i\$ u\$3D Up Th3 USeR C4nn0T UpL0AD 4NY MOR3 4+tAChmEN+S. 8Y DeF4ULt +hI\$ i5 1M8 OF \$P4Ce.";
$lang['forum_settings_help_26'] = "<b>alloW embeDD1Ng OF 4++4ChMEnTS 1N mESS49ES / \$19NA+UR3S</b> ALl0W\$ Us3R\$ +0 3M8ED 4+T4ChMEn+S In p0\$+S. 3NaBL1n9 +H1S opT10N wH1L3 usEfUL C@N 1nCR34\$3 Y0Ur B4ndWIdtH US49E dr@StIC@LLy UNd3R cER+4In COnf1GUr@+10nS 0F pHP. IpH J00 h4V3 L1Mi+3D bANDW1dtH 1+ i\$ R3coMmENd3d Th@t J00 D1S4BL3 +HIS 0PTi0N.";
$lang['forum_settings_help_27'] = "<b>usE @L+3Rn4+1vE @tT4ChM3NT m3THOd</b> f0rCE\$ BE3HIvE TO uSe @n @L+3rN@+Ive R3+rIEV4L M3+HOd PH0R 4tT@CHM3n+\$. IF j00 R3C31Ve 404 3RroR MesS4G3\$ wHEn +RY1ng To D0WNlo4D @+T4CHmeNTS pHRoM Me\$s4G3\$ +RY 3n48L1N9 +hI\$ 0P+10n.";
$lang['forum_settings_help_28'] = "the\$E \$e+t1N9s aLl0w5 y0uR f0rUm To 8E \$pIdeRED 8Y \$3ARCH ENgIN3S l1K3 G0OGl3, @L+@v15+A 4Nd Y4Hoo. 1f J00 \$W1tCH THi5 OP+10N 0Phf YOuR Ph0RUM WILl N0+ Be IncLUdED 1N TH3S3 S34RCH EN91NES R3\$uLt5.";
$lang['forum_settings_help_29'] = "<b>aLLOW n3w UsER rEgIs+R4T1On\$</b> 4LLOwS Or d1\$4LLOw5 T3H CRea+1ON of n3W UsER 4CC0UNts. se++1n9 +H3 oPT10N TO nO C0mpLeT3LY D1\$48L3s +H3 rE9ISTr@T10N phoRM.";
$lang['forum_settings_help_30'] = "<b>eN4bLe wIK1Wiki 1Nt3GR4+1On</b> PR0ViD3S w1KiW0Rd 5UPp0Rt In YoUr F0RUm P0\$+S. a w1K1W0RD 1s m4DE UP oF tWO oR MOr3 C0NC@TEnAteD w0RDS Wi+H UpP3Rc@SE L3T+3R\$ (OF+3N R3F3RR3D T0 4s c4mElC4S3). IPh j00 Wr1TE 4 W0Rd +H1S wAY 1+ W1LL @u+OM4+1C@Lly B3 cH4NgED INT0 a hYPeRLInk P0In+1N9 +o YouR cH0\$3N w1KIwIKi.";
$lang['forum_settings_help_31'] = "<b>en4BLE WIkIW1k1 QUiCK L1NKs</b> 3n@8LE\$ +h3 U\$3 opH MS9:1.1 4ND u\$3r:lOG0N s+Yle 3xT3Nd3d W1k1l1NKS wH1CH CR34T3 HYp3RL1Nks +0 +3H \$PEciFieD mE\$s493 / US3R pROf1L3 oPh Teh \$pEC1PHiED usEr.";
$lang['forum_settings_help_32'] = "<b>w1kiWiK1 l0CA+1oN</b> i\$ US3D to SPeCIFy T3H uRi OF y0uR WIkIwiK1. WH3N enT3RIng +h3 Ur1 USE <i>%1\$S</i> to 1NDIc@T3 wHEre 1n Th3 UrI +He WiKiWOrD ShoULD @PpEAR, I.e.: <i>h+Tp://eN.wIKIP3d14.ORG/wIKI/%1\$\$</i> W0uLD l1NK y0uR wIKIWorDS +O %s";
$lang['forum_settings_help_33'] = "<b>foruM ACceSS sT@TUS</b> CoN+r0LS h0W u\$3RS mAY 4CC3SS yOuR FOrUm.";
$lang['forum_settings_help_34'] = "<b>oPen</b> WILl 4lLoW 4lL US3R5 4ND 9u35+S 4CC3Ss +0 YOUR f0RUM WiTHOUT re\$TR1c+ION.";
$lang['forum_settings_help_35'] = "<b>cloSeD</b> PR3V3Nts AcC3sS F0R @LL u5ER\$, wI+H TeH eXC3P+10n OF THe @dMIn WHo M4Y St1ll @CCE\$s +h3 4dM1N P4nEl.";
$lang['forum_settings_help_36'] = "<b>rES+R1c+ED</b> @LLOw\$ to \$3+ A L1\$+ 0f us3RS Who @R3 4LLOWed 4CC3sS +o Y0UR fOrum.";
$lang['forum_settings_help_37'] = "<b>p@SSWorD Pr0+3CT3D</b> 4Ll0WS j00 T0 \$3+ @ P4SSwoRd +O 9iVE 0U+ +0 US3Rs S0 tHeY C4N 4Cc3sS yoUR f0RUm.";
$lang['forum_settings_help_38'] = "wH3n \$E++1Ng R3\$tR1C+3D 0R p@SSwoRd PR0+3Ct3d moDE j00 wIlL N3ed +0 S@VE y0UR ChANg3\$ bEPhoR3 j00 C@n cH4N9E tH3 U\$eR @CcES5 pR1ViL3GEs 0R p45sW0RD.";
$lang['forum_settings_help_39'] = "<b>Search Frequency</b> defines how long a user must wait before performing another search. Searches place a high demand on the database so it is recommended that you set this to at least 30 seconds to prevent \"search spamming\"fRom KILl1nG tHE S3Rv3R.";
$lang['forum_settings_help_40'] = "<b>posT PhR3QU3NcY</b> 1S +H3 m1NiMUm Tim3 4 us3r mUST W4IT 8EPh0r3 +h3Y C4N PO5+ 4941N. +h1\$ \$e+T1Ng @lS0 4FPh3CT\$ +He Cre4TIOn OF POlLS. s3+ +O 0 +o Di5@8LE tHe R3s+rICtioN.";
$lang['forum_settings_help_41'] = "teH ABoV3 0p+10NS ch4NGe +eH def4UL+ VAlU3\$ phOr +3H uSEr REgI5TR@ti0N pHORm. wHeR3 4PPliC@8Le 0ThER s3+Tin9s W1ll U5E +3H foRum'S 0wn dEPH4uLT sE++iNGs.";
$lang['forum_settings_help_42'] = "<b>pReV3N+ U\$3 OF dUPlIc4t3 3M@il 4DDrE\$s35</b> F0RCeS beEHiV3 to chECk +h3 US3R @CCouNt\$ 4941n\$t +h3 EM41L aDDrE5S +hE Us3r 1s R3Gi5T3R1N9 w1+H 4ND pR0MPts +Hem T0 u5e 4nOThER 1f IT 1\$ 4Lre4DY IN US3.";
$lang['forum_settings_help_43'] = "<b>r3Qu1R3 3M@il COnpH1RMaTION</b> wh3N 3N@8LEd WilL 5End AN 3m@1L +o 34CH nEW useR WiTH 4 l1nK +H@+ C@n 83 uS3D +0 c0NPH1Rm THEiR 3M41L 4DDResS. UN+1l ThEY c0nF1RM TH31R 3maIl @DdRESS tHEy WILl NOt B3 4BLe +0 Po\$T Unl3sS +hE1r us3R P3RM1\$S10NS @R3 Ch@NGeD m4nu4LLY BY @N 4DMIn.";
$lang['forum_settings_help_44'] = "<b>uSe TEX+-c@PTchA</b> prESeNtS +h3 NeW us3R w1+H 4 M4n9L3D IM@ge Wh1CH +H3Y mus+ CoPY @ NUm8eR pHROm 1N+0 4 T3xT PHI3LD ON T3H rE915TR4+1ON Ph0RM. US3 tH1S OpT10N +O pR3V3n+ AUToM4+3D \$19N-uP V1@ scR1Pt\$.";
$lang['forum_settings_help_47'] = "<b>po\$t 3DiT 9R4CE P3RI0d</b> 4LLOws J00 to D3PhiNe 4 pERi0d 1N MInUTEs WHEre us3R5 M4Y EDi+ p0st\$ W1+H0Ut +H3 'EDI+eD BY' TEX+ 4PP34R1Ng On +hEIR pO\$tS. If S3+ +0 0 tH3 '3DI+ed by' +3x+ wILl @lW@ys @Pp34R.";
$lang['forum_settings_help_48'] = "<b>uNR3AD mE\$S4GE\$ cu+-0PHf</b> SPeC1F13S h0W lONg m3ss49E\$ R3M@1N unRe4D. THr34d\$ M0dif13D n0 L4T3R Th@N THe PeRIOd S3LEc+ED WIlL @uTOm4+1C@lLY 4pPE@R 4S R34D.";
$lang['forum_settings_help_49'] = "cH00S1NG <b>d1s4BL3 UNre4d MES\$@GE\$</b> w1LL C0MPL3t3ly reM0V3 uNRE4D mE\$SAGE5 \$UPp0R+ aND REmoV3 TH3 R3Lev4NT OP+1oN\$ pHROM +eH DI5Cuss1oN Type DROP d0wN 0n T3H THR3aD LI5T.";
$lang['forum_settings_help_50'] = "<b>rEqUIre US3r 4PPRoV4L 8Y 4DM1n</b> 4LLOwS j00 To R3\$TR1Ct 4CC3\$5 bY n3w us3R\$ uNTil ThEY h@V3 b33N 4PPr0VEd 8Y 4 moDeR@+or 0R 4Dm1n. W1+hoUt 4PProv4L @ us3R c@NN0t @CcESS @Ny 4R3@ of +H3 bEEH1V3 pHOruM 1nS+aLLA+1oN InCLUd1nG INdiVIDu4l pHORUms, pM 1nB0x 4ND mY F0RUm\$ \$3CT10NS.";
$lang['forum_settings_help_51'] = "us3 <b>cL0\$3D Me5s@9E</b>, <b>r3sTR1CTed mESS@g3</b> aND <b>p@\$5W0RD pR0t3c+ED M3\$S@9E</b> +0 cusToMIS3 +HE MESS@9E d1sPL@Y3D wH3N uS3R\$ @CC35\$ YOUr F0Rum 1N the V@RioUS s+@+3\$.";
$lang['forum_settings_help_52'] = "j00 CaN u\$e H+mL In Y0Ur me\$S@GeS. HYp3RL1nks ANd 3M41L 4Ddr3sSEs WIlL @L50 B3 4U+0m4+1c@lLY C0nVErT3D +0 l1nK\$. TO Us3 +h3 D3FaULt 8E3H1ve F0RUm m3SS49ES cLEaR Th3 F1ElDS.";
$lang['forum_settings_help_53'] = "<b>allOW U5erS +0 CHANGe US3Rn4M3</b> P3RM1T\$ @Lr3AdY rEG15+EReD U\$ERS +O chAngE THe1r USerN@ME. WH3N 3N@8LEd J00 c4n +r4CK ThE cHAngE5 4 User MaKE\$ +O +HEiR usERN4m3 VI4 +3h aDM1N usER TOoLS.";
$lang['forum_settings_help_54'] = "u5e <b>f0RUm RUle\$</b> +o 3N+3r @N 4CCePt4BLE u53 P0LiCy Th@T 3AcH u\$ER MUS+ @gR33 TO 83F0R3 rE91ST3riNG ON Y0Ur PH0RuM.";
$lang['forum_settings_help_55'] = "j00 C@n u\$3 HTml 1N Y0Ur F0RUM rULES. HYPerl1NKs 4ND 3M4IL aDDR3SsEs w1lL also 83 4u+0M@TIcALlY C0NV3R+eD +O LInKS. TO us3 Th3 D3PH@UL+ 8E3H1VE pHORUm @Up Cle4R teH FIelD.";
$lang['forum_settings_help_56'] = "use <b>n0-rePLy EmAil</b> TO sp3CIFY @n 3M4IL 4Ddr3sS THa+ d0e\$ N0+ 3xI\$T 0R w1LL n0t 83 MonITOr3d F0R R3PLiE\$. +H1S Em@1L @DDr3\$S w1LL b3 US3D iN Th3 H3Ad3RS pHOR @lL 3M@1L5 S3NT fR0M YOUR PH0RUm IncLUD1Ng Bu+ n0T L1M1TEd T0 P0ST @ND pM N0tIFIc4+10NS, uSEr 3M4ILS @Nd PA\$sw0RD r3m1ND3R\$.";
$lang['forum_settings_help_57'] = "i+ is R3comM3ND3d +h4T j00 US3 An EMaIL AdDRe\$s +h4t doe5 N0+ eX1\$+ +0 HELp Cu+ D0WN 0N SPaM TH4T m@Y 83 Dir3C+3d 4T yoUR M41N f0RUm EM41L 4DDr3s5";
$lang['forum_settings_help_58'] = "iN 4dD1TIoN +0 S1Mpl3 SPId3rINg, 833HiV3 c4n 4L\$0 9ENer4TE @ s1+EM4P ph0R th3 PH0RUm T0 MaK3 i+ e4s1eR ph0R SE4RCh 3nGin3s T0 PHiND 4ND inD3x +EH me\$\$@9e\$ P0ST3D BY y0UR US3rS.";
$lang['forum_settings_help_59'] = "sitEM@PS 4R3 4UTOm4+ic4LLy S4VeD tO Th3 S1t3m@ps SuB-dIR3C+0RY of y0UR B33H1V3 pHORuM 1NSt@Ll4+10N. IF +H1s D1R3c+0ry D03SN'+ Ex1ST J00 muS+ cRe4T3 1T 4Nd En5UR3 tH@t i+ I5 WR1+a8L3 8Y THe \$ERvEr / PhP PR0CesS. to aLLow S34RCH 3n9iNE\$ T0 phInD yOUr sIt3M@p J00 mU\$+ 4DD teH urL +0 Y0uR ROb0+s.+x+.";
$lang['forum_settings_help_60'] = "dEp3NDIN9 0N 5ErVEr pERF0rm@Nc3 4ND t3H NUm8ER OPh f0RUMS 4nd +hRe4d\$ yoUR B3EHiV3 InST@ll4TI0N c0N+@1NS, G3NER4+IN9 4 \$1t3M@p M4Y T4K3 5EV3R4L MiNUTES +o C0MPL3+3. 1PH pERForM4NC3 oF YouR SERV3R 1s 4dVERs3ly afF3CTED 1T 15 RecOMmeND J00 DIs48LE gENEr4+10N Of THE \$1+3M4P.";
$lang['forum_settings_help_61'] = "<b>s3Nd EM@iL notIfiC4tI0n TO gLOb4L 4DMin</b> wH3n 3N@BLed w1Ll \$3ND 4N 3m@iL +o ThE GL08Al Ph0rUm 0wNeR\$ wh3N 4 N3W U5Er 4CcOUnt I\$ creA+3D.";

// Attachments (attachments.php, get_attachment.php) ---------------------------------------

$lang['aidnotspecified'] = "aiD N0t sPeCIfIEd.";
$lang['upload'] = "upl04D";
$lang['uploadnewattachment'] = "uplO4D n3w A+tAcHMen+";
$lang['waitdotdot'] = "w41+..";
$lang['successfullyuploaded'] = "sUcC3\$SphuLlY uPLo4dED: %s";
$lang['failedtoupload'] = "f41l3D +0 Uplo@d: %s. CH3Ck FrEE 4++4cHMeN+ sp@C3!";
$lang['complete'] = "cOmPlET3";
$lang['uploadattachment'] = "uploAd 4 Ph1LE fOR @TT4ChmEn+ t0 +H3 mEs549E";
$lang['enterfilenamestoupload'] = "en+3R fIL3N4M3(\$) TO uPl04D";
$lang['attachmentsforthismessage'] = "aTT4CHmeN+S f0r +H1\$ M3\$S4G3";
$lang['otherattachmentsincludingpm'] = "oth3R @tt4cHMeNTS (1NClUDInG pm Me\$sagES 4ND O+H3R PHorUm\$)";
$lang['totalsize'] = "tO+@L \$IZ3";
$lang['freespace'] = "fr3e \$p4C3";
$lang['attachmentproblem'] = "tH3RE W@s @ Pr08L3M d0WNL0@D1N9 +hIS 4+t@ChM3NT. pLe4s3 tRY @94IN L@T3r.";
$lang['attachmentshavebeendisabled'] = "atT@cHM3N+s H4VE 83EN DI\$AblED 8Y +H3 F0RuM owNeR.";
$lang['canonlyuploadmaximum'] = "j00 C@N oNlY uPL04D a m4x1mUm OF 10 PH1L3s 4+ 4 +1Me";
$lang['deleteattachments'] = "delET3 @t+4CHmeNts";
$lang['deleteattachmentsconfirm'] = "are J00 5UR3 j00 W4nt +0 DeL3+3 Th3 \$3L3C+Ed 4TT@CHMenTs?";
$lang['deletethumbnailsconfirm'] = "ar3 j00 \$uR3 J00 W4Nt to d3l3+3 +eH SEL3ctED @TT@CHmEN+S +HUmBN41LS?";

// Changing passwords (change_pw.php) ----------------------------------

$lang['passwdchanged'] = "p4s5WoRD cHaNGeD";
$lang['passedchangedexp'] = "yOUR P4\$SWORD h4s BEen CHaNGED.";
$lang['updatefailed'] = "upd@T3 F41LEd";
$lang['passwdsdonotmatch'] = "p4sSW0Rds D0 N0+ M@TCh.";
$lang['newandoldpasswdarethesame'] = "nEW AnD OlD p4sSW0Rd\$ @rE +H3 S4Me.";
$lang['requiredinformationnotfound'] = "r3qU1R3D 1NF0rM4+1oN N0T phoUnD";
$lang['forgotpasswd'] = "f0R90T P4SSW0RD";
$lang['resetpassword'] = "r3\$3+ p@SSwoRD";
$lang['resetpasswordto'] = "rEs3+ PA\$SWORD T0";
$lang['invaliduseraccount'] = "inv4l1D US3r 4Cc0uNT sPEcIPH1ed. CHeCk 3MAiL foR COrR3CT LINK";
$lang['invaliduserkeyprovided'] = "iNvAL1d Us3r Key PROVIDED. cH3CK EM@1L f0R CORr3ct L1nK";

// Deleting messages (delete.php) --------------------------------------

$lang['nomessagespecifiedfordel'] = "no ME5S4GE SP3CIpHIeD F0R dELE+1ON";
$lang['deletemessage'] = "d3lete m3\$S@ge";
$lang['successfullydeletedpost'] = "sucCES5PHuLLy D3LE+3D Po\$T %s";
$lang['errordelpost'] = "err0R d3L3+InG p05+";
$lang['cannotdeletepostsinthisfolder'] = "j00 C4Nno+ DElET3 pO\$+S In +h1s pHOLdeR";

// Editing things (edit.php, edit_poll.php) -----------------------------------------

$lang['nomessagespecifiedforedit'] = "n0 M3\$S@GE SPECifIeD f0R edI+1nG";
$lang['cannoteditpollsinlightmode'] = "c@nNOT 3dI+ POLl\$ 1N lI9H+ M0D3";
$lang['editedbyuser'] = "edi+3D: %s 8Y %s";
$lang['successfullyeditedpost'] = "sUcCe\$SPHuLLy 3D1+Ed po\$t %s";
$lang['errorupdatingpost'] = "eRROr UPd@t1N9 p0sT";
$lang['editmessage'] = "edi+ ME5s@Ge %s";
$lang['editpollwarning'] = "<b>n0+E</b>: 3diTIn9 c3R+41N @5pec+\$ 0Ph @ pOlL w1Ll v01d 4lL +eh CUrR3Nt v0Tes @nD @lL0w P3OpLE +0 Vo+3 AG41n.";
$lang['hardedit'] = "h4rd edI+ OPt10NS (VO+es WiLl 8E reSE+):";
$lang['softedit'] = "s0PH+ eDiT OPT10n\$ (VOTes W1lL 83 R3+41NEd):";
$lang['changewhenpollcloses'] = "ch@Nge Wh3N thE POlL Clo\$3s?";
$lang['nochange'] = "nO Ch4N93";
$lang['emailresult'] = "eMA1L r3sUlT";
$lang['msgsent'] = "mE\$S@9e \$EN+";
$lang['msgsentsuccessfully'] = "mESS@93 S3NT sUcCEs\$PhULLY.";
$lang['mailsystemfailure'] = "m@il SY5T3M f41LURe. m3ss@Ge NO+ \$3N+.";
$lang['nopermissiontoedit'] = "j00 4Re NOT P3RMiTTEd To 3D1T th1\$ mE\$S@9e.";
$lang['cannoteditpostsinthisfolder'] = "j00 c4nNOT 3DI+ posTS In Th1\$ F0ld3R";
$lang['messagewasnotfound'] = "mESS@g3 %s W@s n0+ Ph0UNd";

// Email (email.php) ---------------------------------------------------

$lang['sendemailtouser'] = "senD 3MAiL +O %s";
$lang['nouserspecifiedforemail'] = "no US3R \$PEc1f1ED PHOr 3MAil1N9.";
$lang['entersubjectformessage'] = "eN+3R a SU8J3C+ F0R +he MesSAg3";
$lang['entercontentformessage'] = "eNTER s0Me CoNT3Nt FoR +H3 me\$SaGE";
$lang['msgsentfromby'] = "tH1s ME5s493 W@s S3N+ FroM %s 8Y %s";
$lang['subject'] = "sUBJEc+";
$lang['send'] = "s3Nd";
$lang['userhasoptedoutofemail'] = "%s h4s 0Pt3d out OF EM@IL coN+AC+";
$lang['userhasinvalidemailaddress'] = "%s h4s An 1Nv4lId Em41L 4dDResS";

// Message nofificaiton ------------------------------------------------

$lang['msgnotification_subject'] = "me\$s@93 n0TIfiC4+10N fR0M %s";
$lang['msgnotificationemail'] = "hell0 %s,\n\n%s P0sT3d @ MESS49E +O J00 0N %s.\n\ntHE sUBjeCT 1\$: %s.\n\n+o RE4D +h4+ m3\$s49E 4ND 0thER\$ in +H3 S@ME dISCUSs1oN, 90 TO:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nn0+3: iF J00 do NOt W1SH to R3CeiV3 3MAil nOTIFiC@T10NS 0F f0rUM ME\$SaG3\$ po\$+3d +0 y0u, g0 +0: %s ClICk 0N My CON+r0LS +h3N EM41L 4nd pr1VACy, uNSelEC+ +He EMaIL NOTifIc4+ION ch3cKB0X 4nD pr3sS \$UBM1+.";

// Thread Subscription notification ------------------------------------

$lang['threadsubnotification_subject'] = "sUb5cRiPTI0N nOt1pHiC4+1ON fR0M %s";
$lang['threadsubnotification'] = "hEll0 %s,\n\n%s P0sT3D 4 M3ss4GE iN 4 +hR3Ad J00 4Re \$uBSCR183d TO 0N %s.\n\ntH3 Su8JEc+ is: %s.\n\ntO R34D +H@+ mES5493 @ND o+h3r5 In tHE \$4ME d1\$cU5SI0n, Go +0:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nN0T3: iPh J00 do N0T w1sH t0 REcE1VE 3MAiL nOTiFiC4+1oNs 0F n3w M3SS4gES iN +H1s ThR34D, G0 +O: %s 4Nd 4DJuST y0UR 1N+3RE\$+ lEV3L @T teH bOTToM 0Ph +H3 p4g3.";

// Folder Subscription notification ------------------------------------

$lang['foldersubnotification_subject'] = "sUB\$cR1PT1ON N0+1F1C4T10N fr0M %s";
$lang['foldersubnotification'] = "h3lL0 %s,\n\n%s Po\$+eD @ M35s493 1N 4 PHoLD3R J00 4RE 5UBScR183D +0 0N %s.\n\nThE \$uBJeCT 1s: %s.\n\n+O r3AD +H4T m35s@93 4nd 0thEr\$ iN ThE \$4M3 D1\$CusS10N, 90 T0:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nn0+E: 1F J00 d0 N0+ W1SH +O rEc3iVE eM41L nOTifIc4+1ON\$ of n3w M3\$s49ES in tHi\$ THr3aD, 9o t0: %s 4ND @DjU\$+ yOUR INt3RE\$t LeVEL BY CL1CK1NG 0N t3h pH0ldER'S 1C0n 4+ +3H t0P oF pAGe.";

// PM notification -----------------------------------------------------

$lang['pmnotification_subject'] = "pm NOtiF1C4+10N phrOM %s";
$lang['pmnotification'] = "h3LL0 %s,\n\n%s POs+3D 4 Pm TO j00 on %s.\n\ntHE \$uBJ3CT 1s: %s.\n\ntO rEAD +H3 M35\$@Ge 9o +O:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nnO+e: 1PH J00 D0 n0t w1\$H +0 R3CE1v3 EmAiL NO+1fIC4TI0ns OF NEW PM m3\$s@9ES po\$+3d +o Y0U, GO +0: %s Cl1cK mY CON+rOLS +H3N 3MaIL and pR1V4cy, uNs3lEC+ TEh Pm NOTifIC4+IoN cHECkB0x 4ND PR3sS \$u8m1+.";

// Password change notification ----------------------------------------

$lang['passwdchangenotification'] = "p@\$SW0Rd ChAN93 n0T1PHic@tI0N FR0M %s";
$lang['pwchangeemail'] = "heLL0 %s,\n\ntH1S @ NOtIfiC@t10N 3M@iL TO INf0RM J00 Th@T Y0ur P4S\$WORd 0N %s H4\$ 833n ch@NGed.\n\ni+ h4S 8EEn CH4N93D +o: %s AnD W4s CH@NGeD by: %s.\n\niPh j00 H4V3 ReCeiV3D tHI\$ 3M4IL 1N ErROr 0R w3r3 NOt 3xP3C+IN9 @ Ch@NGe To Y0UR P4sSwORD PL3@SE C0N+4cT t3H forUM 0WneR 0r @ M0DEr4TOR 0N %s IMMED14T3LY TO CORr3C+ 1T.";

// Email confirmation notification -------------------------------------

$lang['emailconfirmationrequiredsubject'] = "em@iL c0nFiRMa+1oN r3QU1Red FoR %s";
$lang['confirmemail'] = "h3LLO %s,\n\nY0u R3ceN+lY cRE4T3D 4 nEW u\$Er @Cc0uNt 0N %s.\n\n83ph0R3 J00 C4N s+AR+ PO\$+In9 W3 N33D +0 C0NfIRm Your 3m@1L @Ddr3SS. d0N'+ WorRY +HI\$ 1S Qui+E 34\$y. 4LL J00 Ne3d t0 DO iS clICk +3H lINk BelOW (OR C0PY 4ND p@S+e I+ InTO Y0ur 8ROW53r):\n\n%s\n\n0NC3 C0NFiRM@tION 1s C0MplE+3 J00 M4Y L09IN @ND \$+4RT P0sTiN9 1Mm3dI4+ElY.\n\n1F J00 D1D n0t cR3A+e 4 USEr 4cC0Unt 0N %s PlEA\$E 4CCEp+ 0UR @P0LOG135 @nD Ph0RW4RD tHIS 3m@iL +0 %s s0 Th@T +He \$0URCe OF iT M@Y bE InV3s+1G4T3d.";
$lang['confirmchangedemail'] = "hElL0 %s,\n\nYou R3ceN+LY CH4N9Ed Y0uR eM4IL oN %s.\n\n83PHOr3 j00 C@n S+4R+ po\$+1N9 @g41N WE n3eD To C0NFiRM Y0UR N3W 3mAIl AdDR3SS. d0N'T WOrRY THIs IS QU1+3 E4SY. 4LL J00 Ne3D TO DO 1\$ CL1ck +EH L1NK 8ELOW (0R coPy 4ND P@STe 1T IN+o Y0UR 8ROWS3R):\n\n%s\n\n0NCe C0NFiRMA+I0N 1S C0MpL3+3 j00 M4Y CONtINU3 +0 USE tHE PHOrUM 4s N0RMaL.\n\n1f J00 WER3 N0T 3XpeCTiN9 +h1\$ 3M41L pHR0M %s PLe4sE 4CC3P+ oUr 4P0l0gie\$ 4ND pHORwARd TH1S em41L +0 %s \$o +h@t +H3 SoURCe oF i+ m4Y 8E InVESTIga+ED.";

// Forgotten password notification -------------------------------------

$lang['forgotpwemail'] = "h3lL0 %s,\n\nyou rEQUeSTEd +H1s 3-M41L Fr0m %s 83C@usE J00 haV3 F0R9O+t3N y0UR P@SswORd.\n\ncLiCK +HE l1nK 83loW (0R coPy AnD pAS+3 i+ 1Nt0 Y0UR 8R0WSEr) +0 Res3+ yoUR p4s5WORd:\n\n%s";

// Admin New User Approval notification -----------------------------------------

$lang['newuserapprovalsubject'] = "n3w U\$3r 4PpROV4L NO+1F1C4T10n F0R %s";
$lang['newuserapprovalemail'] = "Hello %s,\n\nA new user account has been created on %s.\n\nAs you are an Administrator of this forum you are required to approve this user account before it can be used by it's owner.\n\nTo approve this account please visit the Admin Users section and change the filter type to \"Users Awaiting Approval\"oR CL1ck ThE LINk bELoW:\n\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nn0+3: O+h3r 4DMIn1s+R4TORS 0n +h1\$ F0rum w1LL 4LS0 R3CeIVe THIS nOtIF1C@+1ON 4nd m@Y HAv3 4LrE4DY 4C+3D uPON +H1\$ rEQuEst.";

// Admin New User notification -----------------------------------------

$lang['newuserregistrationsubject'] = "new U\$eR 4Cc0uNT nO+1PhIC@T1ON PH0R %s";
$lang['newuserregistrationemail'] = "h3lL0 %s,\n\n4 N3W USEr 4CC0unT H4\$ b3EN Cr34+3D oN %s.\n\ntO v1EW +HIs US3R aCC0Un+ Pl3A\$3 v1s1+ +3h 4DM1n US3RS S3CtION @Nd CLick 0N tHE NEW US3R 0R CL1Ck The L1nK b3LOW:\n\n%s";

// User Approved notification ------------------------------------------

$lang['useraccountapprovedsubject'] = "u\$eR 4Ppr0V4L n0+IPhIc4TIOn PH0R %s";
$lang['useraccountapprovedemail'] = "h3ll0 %s,\n\nYouR USEr @cCOUNt 4T %s H4s B33N 4PPR0V3d. j00 C4n l0G1N 4nD s+@Rt P0\$T1NG IMm3dI4T3LY BY CLICkIN9 tHE l1nK bEl0W:\n\n%s\n\n1f J00 Were N0T 3xpECTiNG THis em@1L pHRoM %s Pl3aSE 4cC3P+ 0uR 4P0L0G1ES 4ND pHORw4rD +hIS eM@IL +0 %s \$O th4+ tH3 \$ouRC3 0f I+ M4Y be INV3s+194TED.";

// Admin Post Approval notification -----------------------------------------

$lang['newpostapprovalsubject'] = "p0sT @PpR0VAl nOTifIc@+1ON F0R %s";
$lang['newpostapprovalemail'] = "h3lLo %s,\n\n4 N3W pOs+ h4\$ Be3N cRE4T3D 0N %s.\n\n4S J00 4RE 4 M0DeR@TOr 0N tH1\$ f0RUM J00 4RE R3QUIrED To APProVe +H1S Pos+ 8eFOR3 1T c4N 8E r34D 8Y 0+HeR U\$3RS.\n\nY0U c@N @PPrOve THi\$ pO\$+ 4nD @ny 0THErs peNDInG 4PprOV4L 8y vI\$1TInG t3H 4DMIN POS+ @ppR0V4L \$ECtI0N 0f Y0UR f0RUm OR BY cLIckiNG +hE l1NK 8EL0W:\n\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nN0TE: 0+H3R 4DMiNIS+RAtoRS 0n ThIS F0RUM W1LL 4l\$0 R3CE1V3 +H1S n0tIF1C4T1oN 4Nd M@y H@VE @LReADY 4ct3D Up0n +H1\$ r3qUEsT.";

// Forgotten password form.

$lang['passwdresetrequest'] = "y0uR P@\$sWoRD r3s3+ R3qU3\$T pHROm %s";
$lang['passwdresetemailsent'] = "p@\$SW0RD RE53+ E-M@IL s3N+";
$lang['passwdresetexp'] = "j00 \$hOUlD sHORtLy RecEiVE @n E-m@iL Con+41N1Ng 1NStRUcTi0n5 F0R rEs3T+iN9 Y0Ur P@\$Sw0RD.";
$lang['validusernamerequired'] = "a v@L1D u\$3Rn4ME i\$ REQu1r3D";
$lang['forgottenpasswd'] = "for90T P4SSW0Rd";
$lang['couldnotsendpasswordreminder'] = "cOULd N0+ Send pAsSWOrD Rem1ND3R. Pl34s3 ConT4Ct T3H pH0Rum 0wNer.";
$lang['request'] = "reqUesT";

// Email confirmation (confirm_email.php) ------------------------------

$lang['emailconfirmation'] = "eMaIl C0NfirM4+1ON";
$lang['emailconfirmationcomplete'] = "th4NK J00 PHOR C0NFiRM1n9 Y0UR 3M@1L @DdRE\$s. j00 M4Y NOW l0g1N @nD st@rT pO5+1N9 1MM3D14+3lY.";
$lang['emailconfirmationfailed'] = "eM@1L C0NF1RmA+1ON H4\$ pH@1l3D, pLE4S3 trY 4G41N LatER. iF j00 ENCouNt3R TH1\$ 3Rr0R mULT1pL3 +imES PLe@Se C0nT4c+ tH3 FoRUM OWNer 0R 4 m0d3R4+OR f0r 4sS1\$T@Nc3.";

// Links database (links*.php) -----------------------------------------

$lang['toplevel'] = "top L3V3L";
$lang['maynotaccessthissection'] = "j00 m4Y nOT @cCEss +h1\$ \$Ec+I0N.";
$lang['toplevel'] = "t0P l3V3L";
$lang['links'] = "l1NK\$";
$lang['externallink'] = "eXTErn@l L1NK";
$lang['viewmode'] = "vI3w M0DE";
$lang['hierarchical'] = "h1eR4RCh1CAl";
$lang['list'] = "lI\$+";
$lang['folderhidden'] = "th1s PH0lDER 1\$ h1dDeN";
$lang['hide'] = "hidE";
$lang['unhide'] = "unh1d3";
$lang['nosubfolders'] = "n0 suBPh0LDER5 iN Th1s c@TEg0RY";
$lang['1subfolder'] = "1 SubF0LD3r IN THi\$ c4+39ORy";
$lang['subfoldersinthiscategory'] = "subF0LD3RS IN +H1\$ C@teGORY";
$lang['linksdelexp'] = "eN+Ri3\$ In @ D3L3+3D f0LDeR wILl 83 MOveD TO +3H p@R3N+ PH0lD3R. oNlY pHOLdERS WH1ch Do NOt cont41N Su8f0Ld3rS maY 8E dEL3+3D.";
$lang['listview'] = "li\$+ vIEW";
$lang['listviewcannotaddfolders'] = "c4nN0T 4Dd F0lD3rS 1n Th1\$ V13W. \$h0WINg 20 En+Rie\$ a+ 4 +1Me.";
$lang['rating'] = "r4tIn9";
$lang['nolinksinfolder'] = "n0 L1Nks iN +H1\$ FOld3R.";
$lang['addlinkhere'] = "add LInk h3RE";
$lang['notvalidURI'] = "th@+ i\$ n0+ A v4LID UR1!";
$lang['mustspecifyname'] = "j00 MU\$T SpeCIfy @ N@m3!";
$lang['mustspecifyvalidfolder'] = "j00 MUs+ SpEciFY A v4LId FOlD3R!";
$lang['mustspecifyfolder'] = "j00 Mus+ \$pECifY 4 pHOLd3R!";
$lang['successfullyaddedlinkname'] = "sUcC3S\$pHULlY @dDEd L1Nk '%s'";
$lang['failedtoaddlink'] = "f4iLEd +0 aDD L1nk";
$lang['failedtoaddfolder'] = "f@iLed +0 aDD pHOld3R";
$lang['addlink'] = "adD @ lINk";
$lang['addinglinkin'] = "aDDINg l1NK 1N";
$lang['addressurluri'] = "addRESs";
$lang['addnewfolder'] = "adD A New f0LD3r";
$lang['addnewfolderunder'] = "addiN9 nEW f0LD3r unD3r";
$lang['editfolder'] = "ed1+ PH0Ld3R";
$lang['editingfolder'] = "edI+1nG FOLd3R";
$lang['mustchooserating'] = "j00 Mu5+ cHOO\$3 4 rA+1N9!";
$lang['commentadded'] = "y0ur coMm3N+ W@\$ 4dDED.";
$lang['commentdeleted'] = "c0MM3N+ Wa\$ DeLEtED.";
$lang['commentcouldnotbedeleted'] = "cOmMEN+ CouLD N0+ B3 D3LE+3D.";
$lang['musttypecomment'] = "j00 Mu5+ +YP3 4 COmMEN+!";
$lang['mustprovidelinkID'] = "j00 MUSt ProVidE 4 L1NK 1D!";
$lang['invalidlinkID'] = "iNVAliD LInK Id!";
$lang['address'] = "aDDR3\$5";
$lang['submittedby'] = "subMi++3D 8y";
$lang['clicks'] = "cliCkS";
$lang['rating'] = "r4+1N9";
$lang['vote'] = "v0T3";
$lang['votes'] = "vOT3S";
$lang['notratedyet'] = "n0T r@+ed 8y 4NY0n3 YEt";
$lang['rate'] = "r4t3";
$lang['bad'] = "bAD";
$lang['good'] = "gooD";
$lang['voteexcmark'] = "vO+3!";
$lang['clearvote'] = "cLe@R V0T3";
$lang['commentby'] = "cOMM3Nt BY %s";
$lang['addacommentabout'] = "add @ C0MmEN+ @BOut";
$lang['modtools'] = "m0D3R4T1ON TO0LS";
$lang['editname'] = "eDi+ N4M3";
$lang['editaddress'] = "ed1t @ddRESs";
$lang['editdescription'] = "ed1+ D3SCR1PtION";
$lang['moveto'] = "m0v3 T0";
$lang['linkdetails'] = "liNK Det41LS";
$lang['addcomment'] = "add C0MMEn+";
$lang['voterecorded'] = "yOur V0+3 H4s beEn R3C0RD3D";
$lang['votecleared'] = "y0Ur VO+E h@\$ BEeN cL3@r3D";
$lang['linknametoolong'] = "l1nK N@M3 +0o l0Ng. m4xIMuM 1S %s Ch@R@c+3R\$";
$lang['linkurltoolong'] = "linK UrL t00 l0NG. M@x1MUm IS %s cH@r4c+3R\$";
$lang['linkfoldernametoolong'] = "fold3R N@mE +o0 L0n9. m4x1MUm L3Ng+H i\$ %s Ch4r4C+3RS";

// Login / logout (llogon.php, logon.php, logout.php) -----------------------------------------

$lang['loggedinsuccessfully'] = "j00 L09G3D IN \$uCceSSFuLLy.";
$lang['presscontinuetoresend'] = "pRE\$s COnT1NuE +0 R35enD f0Rm d@Ta 0R c@nC3L +o rELo4D p4gE.";
$lang['usernameorpasswdnotvalid'] = "tHe u\$Ern4M3 Or P4SSW0rD j00 SUpPLieD i\$ n0t v4LiD.";
$lang['rememberpasswds'] = "rEm3M8ER pA\$\$wORDS";
$lang['rememberpassword'] = "r3m3m83R p4ssWOrD";
$lang['enterasa'] = "eN+3R @S @ %s";
$lang['donthaveanaccount'] = "d0n'+ H4Ve 4N 4CcouNT? %s";
$lang['registernow'] = "r3g1s+Er n0W";
$lang['problemsloggingon'] = "pR0bL3m\$ l09G1Ng 0N?";
$lang['deletecookies'] = "d3LE+e cOOKiE\$";
$lang['cookiessuccessfullydeleted'] = "co0K1E\$ \$uCC3\$SFUlLY D3LetED";
$lang['forgottenpasswd'] = "for90TT3N y0uR P4sSW0RD?";
$lang['usingaPDA'] = "u\$iNG 4 Pd4?";
$lang['lightHTMLversion'] = "l19ht H+ml VErs10N";
$lang['youhaveloggedout'] = "j00 H4V3 L0GgED oUT.";
$lang['currentlyloggedinas'] = "j00 ArE CUrr3N+lY L09GEd IN @s %s";
$lang['logonbutton'] = "l0g0N";
$lang['otherdotdotdot'] = "othEr...";
$lang['yoursessionhasexpired'] = "y0UR s3\$S1ON h4s eXP1RED. J00 w1LL nEed TO l09In Ag41N tO C0N+iNUe.";

// My Forums (forums.php) ---------------------------------------------------------

$lang['myforums'] = "my Ph0rUms";
$lang['allavailableforums'] = "all 4V@1L48l3 F0RUm5";
$lang['favouriteforums'] = "f@VOuRI+3 PH0RUmS";
$lang['ignoredforums'] = "ignOREd F0RUms";
$lang['ignoreforum'] = "igNOR3 f0RUm";
$lang['unignoreforum'] = "un1GNOr3 PhORUM";
$lang['lastvisited'] = "l4ST V1\$1teD";
$lang['forumunreadmessages'] = "%s unR34D m3\$s4gES";
$lang['forummessages'] = "%s MEssAgE\$";
$lang['forumunreadtome'] = "%s uNR3@d &quot;+O: M3&quot;";
$lang['forumnounreadmessages'] = "no UNrE4D mEs54G3S";
$lang['removefromfavourites'] = "r3m0Ve PhrOM PH4v0uR1TE\$";
$lang['addtofavourites'] = "add TO F4VOurIt3s";
$lang['availableforums'] = "aV41L@8Le FOrUMs";
$lang['noforumsofselectedtype'] = "therE @RE N0 pHORUms 0pH tEH sELeCT3D +Ype @V4Il4BLE. PlE@s3 \$3L3C+ @ D1PhF3REnt tYPe.";
$lang['successfullyaddedforumtofavourites'] = "sUCc3sSFuLLy 4dd3D FoRUm +0 f4V0UR1tE\$.";
$lang['successfullyremovedforumfromfavourites'] = "suCCE5SphULlY R3M0VEd PHoRUm From f@vOUr1+3\$.";
$lang['successfullyignoredforum'] = "suCc355FULLy 1GN0R3d pH0RUm.";
$lang['successfullyunignoredforum'] = "sUCc35\$PHUllY UN19NOr3d phoRuM.";
$lang['failedtoupdateforuminterestlevel'] = "f41LED +O uPD@TE f0RUm InT3R3ST LEveL";
$lang['noforumsavailablelogin'] = "tH3RE 4R3 nO PhorumS 4V41l@BLE. pl3A\$3 L0G1N +0 view y0uR F0RUm5.";
$lang['passwdprotectedforum'] = "pa\$5w0RD PR0Tec+Ed F0RUm";
$lang['passwdprotectedwarning'] = "thi\$ FOruM 15 P4SSwoRd PRo+EctED. +0 941N 4CCe\$5 enTER +3H P@sSW0Rd 83LOw.";

// Message composition (post.php, lpost.php) --------------------------------------

$lang['postmessage'] = "po5+ Me\$s@9e";
$lang['selectfolder'] = "s3L3ct F0LD3R";
$lang['mustenterpostcontent'] = "j00 mU5+ en+3R 50m3 ConTENt phOR +H3 p0\$T!";
$lang['messagepreview'] = "m35s@93 pR3VIew";
$lang['invalidusername'] = "inV4liD U5Ern4M3!";
$lang['mustenterthreadtitle'] = "j00 MU\$+ enT3R @ +1tlE For +eH +HR34D!";
$lang['pleaseselectfolder'] = "pLE4s3 \$3L3C+ 4 foLd3R!";
$lang['errorcreatingpost'] = "err0r CRea+1nG P0S+! plEA\$3 +ry a941n 1n 4 PhEW MInUTe5.";
$lang['createnewthread'] = "cr34+3 n3W thrE4D";
$lang['postreply'] = "pO\$+ R3PLy";
$lang['threadtitle'] = "thR34D +1tle";
$lang['foldertitle'] = "f0lDEr t1+le";
$lang['messagehasbeendeleted'] = "mEss@Ge N0T FouND. CHEck tH4T 1t H4\$n'+ 8e3N D3L3+3D.";
$lang['messagenotfoundinselectedfolder'] = "mEsS49E N0T pH0UND 1N 5ELEct3D F0ld3r. cH3CK +H4T 1T H4sN'+ BeeN M0veD Or d3L3TEd.";
$lang['cannotpostthisthreadtypeinfolder'] = "j00 c@NnOT P0\$T +H1s +hRe@D +YPE 1n +H4+ pHOLDer!";
$lang['cannotpostthisthreadtype'] = "j00 CAnNO+ PosT +h1S +HRe4D +yp3 @s +H3RE 4rE no 4V4Il48Le FOlD3R\$ ThAT aLL0w It.";
$lang['cannotcreatenewthreads'] = "j00 C4Nn0t cr3ATe N3W +Hre4DS.";
$lang['threadisclosedforposting'] = "tHIs +hR3@D 1\$ cL0S3D, j00 c4nno+ PosT 1N 1+!";
$lang['moderatorthreadclosed'] = "w4rN1N9: THi\$ +HRe4D iS cLOS3D ph0R pOSTiNg TO nORm4L us3RS.";
$lang['usersinthread'] = "us3R\$ iN +hre4D";
$lang['correctedcode'] = "corr3CT3D c0DE";
$lang['submittedcode'] = "su8mITT3d COdE";
$lang['htmlinmessage'] = "html in m3\$S@ge";
$lang['disableemoticonsinmessage'] = "d1548LE EM0TicOnS 1N M3\$S4G3";
$lang['automaticallyparseurls'] = "aut0M@tIC@lLy p4R\$E URls";
$lang['automaticallycheckspelling'] = "autOM4+1c4llY ch3CK sPElL1Ng";
$lang['setthreadtohighinterest'] = "sEt +hRE4D +0 HIgH 1n+ErE5+";
$lang['enabledwithautolinebreaks'] = "eN@BleD WI+h 4uT0-LinE-BR3@KS";
$lang['fixhtmlexplanation'] = "tH1\$ pHORuM uS3\$ h+Ml F1LtER1Ng. Y0ur SuBM1tTEd HTmL H4\$ bEEn Mod1FIEd 8Y THe FIl+3R\$ 1N \$0m3 W4Y.\\n\\nto vIEW Y0UR OR19InAL CODe, \$3L3C+ tHe \\'Su8MItteD C0dE\\' RAd10 BU+TON.\\nT0 vIEW +H3 M0DIph1ED coDE, S3L3C+ THe \\'COrRECted coDe\\' R@D10 BU++ON.";
$lang['messageoptions'] = "m35S49E 0P+iON\$";
$lang['notallowedembedattachmentpost'] = "j00 aRE N0+ 4Ll0WED +O 3mb3D 4++@ChMEn+S In Y0UR P0\$+S.";
$lang['notallowedembedattachmentsignature'] = "j00 4R3 no+ 4LlOWeD to 3M8Ed 4TT@CHm3N+s IN yoUR \$1Gn4+Ure.";
$lang['reducemessagelength'] = "mes\$49E L3NG+H MU\$+ Be UND3R 65,535 CH@R@c+ER\$ (cuRrEN+LY: %s)";
$lang['reducesiglength'] = "s1gN4TURe L3Ng+H mu\$+ 8E Und3r 65,535 CHAR4C+eR\$ (cURr3N+Ly: %s)";
$lang['cannotcreatethreadinfolder'] = "j00 CANNOT crEA+E neW THR3ADS 1N +h1s PH0LDER";
$lang['cannotcreatepostinfolder'] = "j00 C4nNo+ RepLY +0 p0S+S in +h1S PH0LD3R";
$lang['cannotattachfilesinfolder'] = "j00 C4NNoT P0\$+ 4Tt@chM3N+s iN +hiS Ph0LDeR. REm0VE @Tt@CHM3nTS T0 C0N+1nUe.";
$lang['postfrequencytoogreat'] = "j00 C4n ONLY P0\$+ 0NC3 eVeRY %s sEC0NDs. pl3ASE TrY @9AIN L4+Er.";
$lang['emailconfirmationrequiredbeforepost'] = "emAIL c0nFiRMa+I0N 1\$ R3QU1REd BEf0rE j00 C4N p0sT. iF J00 h4V3 No+ ReC3IVeD A C0NFIrm4+10N eMaIL PL3A\$3 cLiCk TH3 bUtTOn 83LOw 4ND 4 N3W 0ne w1ll 83 \$3N+ T0 y0u. If youR Em41L @dDR3Ss NEeDS cH4N9InG PlEA\$3 DO sO b3f0RE r3Qu3S+iNg 4 n3W coNPh1RM4TioN EM41L. J00 m4y Ch@N9E y0uR EM41L 4DDR3SS BY cL1CK MY coNtR0LS aB0V3 4Nd +hEN us3r dE+@ILs";
$lang['emailconfirmationfailedtosend'] = "c0nFIrM4+1oN 3M@1L pH@1LEd +0 S3ND. Pl34sE cON+4C+ +h3 PhORUm 0WN3R T0 r3C+1Phy +HI\$.";
$lang['emailconfirmationsent'] = "c0NF1rm4t1ON eM41L HA\$ BEeN r35EN+.";
$lang['resendconfirmation'] = "rEsENd coNPh1RM4+10N";
$lang['userapprovalrequiredbeforeaccess'] = "y0uR usER 4Cc0uNT N3Ed5 +0 83 4pPR0V3D BY A F0RUm @dMIn BEf0R3 j00 caN 4Cc3ss +h3 R3QuES+3D F0RuM.";
$lang['reviewthread'] = "r3V1EW tHR34D";
$lang['reviewthreadinnewwindow'] = "r3vIeW EN+iR3 tHReAD iN N3W WInD0W";

// Message display (messages.php & messages.inc.php) --------------------------------------

$lang['inreplyto'] = "in R3PLy TO";
$lang['showmessages'] = "sH0W m3ss49ES";
$lang['ratemyinterest'] = "r4+3 mY 1Nt3RE5+";
$lang['adjtextsize'] = "adjUST t3xT S1zE";
$lang['smaller'] = "sm4lL3R";
$lang['larger'] = "l@rG3R";
$lang['faq'] = "f@q";
$lang['docs'] = "docS";
$lang['support'] = "sUPP0rt";
$lang['donateexcmark'] = "d0n@te!";
$lang['fontsizechanged'] = "f0nt \$1Z3 Ch4NGEd. %s";
$lang['framesmustbereloaded'] = "fr4Mes muS+ Be REl0@DeD m4Nu@LLy +0 S3e cH@N9E5.";
$lang['threadcouldnotbefound'] = "tEh R3Qu3s+3D +hrE4D c0uLD no+ B3 F0UND OR 4CC3SS W4\$ DENIEd.";
$lang['mustselectpolloption'] = "j00 mUS+ S3LEcT 4N 0Pti0N +O Vo+3 F0R!";
$lang['mustvoteforallgroups'] = "j00 MU5+ V0TE IN EVerY 9RouP.";
$lang['keepreading'] = "k3eP rE4D1N9";
$lang['backtothreadlist'] = "b4CK +0 THr3aD Li\$+";
$lang['postdoesnotexist'] = "th@T P0\$+ D0E\$ N0T 3x1\$+ 1n THi\$ +hrE@D!";
$lang['clicktochangevote'] = "cLiCk TO cH4N9E VOT3";
$lang['youvotedforoption'] = "j00 vO+3D pH0R 0P+10N";
$lang['youvotedforoptions'] = "j00 Vo+Ed Ph0r 0PtIOnS";
$lang['clicktovote'] = "cl1CK +0 Vote";
$lang['youhavenotvoted'] = "j00 HAVE NO+ VO+eD";
$lang['viewresults'] = "vI3W rE5UL+S";
$lang['msgtruncated'] = "mE5Sage TruNc@+eD";
$lang['viewfullmsg'] = "vIEW FUll mESs@93";
$lang['ignoredmsg'] = "i9nOReD mESS493";
$lang['wormeduser'] = "wORMeD us3r";
$lang['ignoredsig'] = "igN0RED \$1Gn@Tur3";
$lang['messagewasdeleted'] = "m3ss@gE %s.%s W4S dElE+3D";
$lang['stopignoringthisuser'] = "sToP Ign0RiN9 tH1\$ U\$3R";
$lang['renamethread'] = "rEN@mE tHrE4D";
$lang['movethread'] = "m0V3 +hrE4D";
$lang['torenamethisthreadyoumusteditthepoll'] = "t0 Ren@Me +h1\$ +HREad J00 MuST 3D1T T3H pOLl.";
$lang['closeforposting'] = "cL0S3 F0R p0\$t1nG";
$lang['until'] = "untIL 00:00 u+C";
$lang['approvalrequired'] = "appR0VAl r3QU1Red";
$lang['messageawaitingapprovalbymoderator'] = "meSs49E %s.%s IS @W41+1N9 @pPr0V@l By A mODeR@tOr";
$lang['successfullyapprovedpost'] = "sucC3SSPHuLLY 4PpR0Ved p0ST %s";
$lang['postapprovalfailed'] = "p0St 4PPROV@L F41led.";
$lang['postdoesnotrequireapproval'] = "post d0e\$ n0+ R3qUIr3 4PpR0V4L";
$lang['approvepost'] = "aPPR0V3 pO\$+";
$lang['approvedbyuser'] = "aPPR0VEd: %s 8Y %s";
$lang['makesticky'] = "mak3 STicKY";
$lang['messagecountdisplay'] = "%s oPH %s";
$lang['linktothread'] = "p3RM@n3NT LInK To Th1S tHR34D";
$lang['linktopost'] = "lINK to p0ST";
$lang['linktothispost'] = "l1NK tO tH1\$ p0s+";
$lang['imageresized'] = "tHI\$ 1m@GE H4s b3EN R3S1Z3D (OR1Gin4L S1z3 %1\$5X%2\$s). tO vIEw +HE fULl-S1Z3 1M493 CLiCk H3R3.";
$lang['messagedeletedbyuser'] = "m35s49e %s.%s d3L3T3D %s 8y %s";
$lang['messagedeleted'] = "mess4G3 %s.%s W4S D3l3+3D";
$lang['viewinframeset'] = "v1eW 1N fR@ME\$3+";
$lang['pressctrlentertoquicklysubmityourpost'] = "pRESs c+Rl+3n+er To QuiCKlY SuBMI+ Y0UR p05+";

// Moderators list (mods_list.php) -------------------------------------

$lang['cantdisplaymods'] = "caNNoT dI\$Pl@Y PH0ldEr M0DeR@toRs";
$lang['moderatorlist'] = "m0d3R4TOr Li5T:";
$lang['modsforfolder'] = "moD3R4+ORS fOr FOLd3r";
$lang['nomodsfound'] = "n0 M0DEr4+OR\$ Ph0uNd";
$lang['forumleaders'] = "f0rUm LeADERs:";
$lang['foldermods'] = "fOlD3R mODEr@+Ors:";

// Navigation strip (nav.php) ------------------------------------------

$lang['start'] = "staRt";
$lang['messages'] = "mEs\$4935";
$lang['pminbox'] = "in8OX";
$lang['startwiththreadlist'] = "s+ARt PAgE Wi+h THr3@D L1sT";
$lang['pmsentitems'] = "senT It3mS";
$lang['pmoutbox'] = "oU+B0x";
$lang['pmsaveditems'] = "s4V3D IT3Ms";
$lang['pmdrafts'] = "dr4pHTs";
$lang['links'] = "lINKs";
$lang['admin'] = "adMIN";
$lang['login'] = "lOGin";
$lang['logout'] = "l090UT";

// PM System (pm.php, pm_write.php, pm.inc.php) ------------------------

$lang['privatemessages'] = "pR1v4TE m3\$SAgES";
$lang['recipienttiptext'] = "sep@R4+e R3C1PiEN+S 8y \$3M1-c0LOn oR coMMa";
$lang['maximumtenrecipientspermessage'] = "thERe 15 A l1M1T 0F 10 ReCiP13NTs PEr M3\$sAGe. pL3@S3 4mEND yoUr r3CIp1eN+ L15T.";
$lang['mustspecifyrecipient'] = "j00 MUst SPeCIfY 4+ LE4s+ 0NE rEcIp1eNT.";
$lang['usernotfound'] = "u53R %s NoT PHOunD";
$lang['sendnewpm'] = "send NEW pM";
$lang['savemessage'] = "s4V3 m3sS@9E";
$lang['nosubject'] = "nO suBJeC+";
$lang['norecipients'] = "n0 REC1P13N+S";
$lang['timesent'] = "tIME 5EN+";
$lang['notsent'] = "n0T sEN+";
$lang['errorcreatingpm'] = "err0r CRe@TiNg PM! pLE4s3 TrY 4GaIn In a PHeW MiNUt35";
$lang['writepm'] = "wRiT3 me\$SaG3";
$lang['editpm'] = "edi+ mES\$@9E";
$lang['cannoteditpm'] = "c4nNOt 3DI+ +HIs Pm. 1T H4s @LREAdy 83EN v13W3D 8Y +h3 rECIPieN+ 0r +eH M3\$\$@9E d03s N0T 3XIS+ 0R 1T is 1n4CCE5SibL3 8Y j00";
$lang['cannotviewpm'] = "c4NNot VieW pm. mesS4GE d0E\$ NoT ex1\$T Or iT I\$ in@cCesSIblE BY J00";
$lang['pmmessagenumber'] = "m35s493 %s";

$lang['youhavexnewpm'] = "j00 H@vE %d New MesS4Ge\$. wOUlD J00 lik3 T0 g0 To y0ur 1n80X nOW?";
$lang['youhave1newpm'] = "j00 H@vE 1 NeW mESsa9e. w0ULD j00 LIKE +0 G0 +0 y0ur iNBOX N0W?";
$lang['youhave1newpmand1waiting'] = "j00 h4VE 1 NeW m3\$\$493.\n\nYOU Al\$O H4V3 1 mEsS@G3 4W@I+1Ng D3L1veRY. T0 rECE1V3 +H1s M3ss49E PleAS3 cl34R S0Me sP4C3 iN YOUr IN8Ox.\n\nW0ULd j00 LIK3 T0 90 tO YOur 1N8OX noW?";
$lang['youhave1pmwaiting'] = "j00 H@V3 1 mE\$\$@gE @w41TIng DeL1VeRY. TO REc3IVe +H1S mE5S@9e ple4s3 ClEAr 50M3 Sp4CE IN yoUr InB0x.\n\nWOulD J00 LiKe TO 90 +o Y0ur 1Nb0x NoW?";
$lang['youhavexnewpmand1waiting'] = "j00 H4VE %d N3W MEss@93\$.\n\nyOU aLSo H@VE 1 mEss4G3 aW41T1N9 D3L1v3RY. To RecEiVe thI\$ MESs4gE pL34sE CLe4R some \$P4ce iN yOUR INb0x.\n\nwOUlD j00 LiKE +o 9O TO Y0UR 1N8OX n0w?";
$lang['youhavexnewpmandxwaiting'] = "j00 H4Ve %d neW mESS49ES.\n\nyoU 4Lso h4VE %d M3SS49E\$ 4W@iTINg dEL1VeRY. TO REc31VE tH3S3 m3\$S49E pLEa\$3 CL3aR s0Me SP4CE in yoUr IN80x.\n\nW0ULd J00 l1KE tO 90 +o Y0uR 1Nb0X NoW?";
$lang['youhave1newpmandxwaiting'] = "j00 H4V3 1 nEW m3SSaGE.\n\ny0U 4LS0 H4vE %d M3ssAGe\$ 4w@1+1N9 dELiVErY. tO rECeIVE +He5E M3ssagE\$ pL34SE CLeAR s0ME SPaC3 iN Y0uR iNb0x.\n\nw0ULD J00 l1K3 +0 90 +O y0uR 1nBOX N0W?";
$lang['youhavexpmwaiting'] = "j00 H4VE %d mESSaGE\$ Aw4I+1N9 DelIvERY. +0 ReCEiV3 +h3s3 M3\$s@9E\$ PL34SE clE4R S0ME \$p@CE 1N y0uR 1N8oX.\n\nwOULd J00 L1KE TO 90 TO y0UR iNBOx N0W?";

$lang['youdonothaveenoughfreespace'] = "j00 D0 nOT HAve 3n0U9H fR33 Sp@CE +0 S3Nd ThI\$ mE\$s@Ge.";
$lang['userhasoptedoutofpm'] = "%s H@\$ 0Pt3d OUt OF REcEIVinG p3r50N4L m35s@93\$";
$lang['pmfolderpruningisenabled'] = "pm PHOlD3R PrUnIN9 iS eNA8L3D!";
$lang['pmpruneexplanation'] = "tH1s PH0RUm U\$eS pM Ph0LdER PRUn1nG. +h3 MESS4GEs J00 haVE \$TOR3D 1N YOuR iN80X 4Nd \$3n+ i+EmS\\nFoLD3RS @R3 SuBJEc+ +0 Au+0M@tiC D3L3+1ON. @NY MesS49ES J00 W1sH +O k3EP shoUlD be M0V3D +0\\nyoUr \\'\$@V3D ITEM\$\\' F0LDer SO TH@T tH3Y aR3 N0T d3LE+ED.";
$lang['yourpmfoldersare'] = "yOUr PM PH0Ld3RS @R3 %s FuLL";
$lang['currentmessage'] = "cURR3N+ mE\$sA9E";
$lang['unreadmessage'] = "uNRE4D m3\$S49E";
$lang['readmessage'] = "rE4d meSS493";
$lang['pmshavebeendisabled'] = "perSOn4L m3sS4G3\$ haVe 83en D1S4bl3D 8Y +3H F0RUm 0Wn3R.";
$lang['adduserstofriendslist'] = "add U\$3RS +O y0UR fR1EnDS l1S+ +0 H@v3 +h3M 4PPe4r 1N 4 DRoP D0Wn On tH3 pM WR1+3 M3SS49E PaGE.";

$lang['messagewassuccessfullysavedtodraftsfolder'] = "me\$s@93 w4\$ \$UCc3SSFuLLY S4V3D +0 'DR@pH+5' Ph0Ld3R";
$lang['couldnotsavemessage'] = "couLD N0T saVE MES\$493. m@K3 SuR3 j00 H4vE EnoU9h @v@1L48le FrE3 \$p4CE.";
$lang['pmtooltipxmessages'] = "%s m3\$sAgE\$";
$lang['pmtooltip1message'] = "1 mES\$@Ge";

$lang['allowusertosendpm'] = "all0W U\$3R TO s3ND PEr\$On@L mESS4Ges +0 m3";
$lang['blockuserfromsendingpm'] = "blOcK US3R PHr0M \$3nDInG Per\$oN4L m3ssA9ES T0 M3";
$lang['yourfoldernamefolderisempty'] = "y0uR %s ph0LD3R 1s eMPtY";
$lang['successfullydeletedselectedmessages'] = "sUccESSpHUllY DEl3T3D s3l3C+3D mE\$s49ES";
$lang['successfullyarchivedselectedmessages'] = "sucCE5SFUlLY 4RcHIVed s3lEc+3D m3S\$493\$";
$lang['failedtodeleteselectedmessages'] = "f41LED +O DEL3+3 SeL3CtED m3\$sAGes";
$lang['failedtoarchiveselectedmessages'] = "f@1LeD +o ArCH1V3 s3l3C+ED mESSaGe\$";

// Preferences / Profile (user_*.php) ---------------------------------------------

$lang['mycontrols'] = "my coN+ROLs";
$lang['myforums'] = "my PHOrUMS";
$lang['menu'] = "m3nU";
$lang['userexp_1'] = "u\$e t3h M3Nu On T3H L3Ph+ +0 m4N493 y0uR S3+TinGS.";
$lang['userexp_2'] = "<b>u\$ER d3+@1L\$</b> 4LLOw\$ j00 +0 cHaNGE y0UR n4m3, 3M@IL 4dDrESS @nD paSSwoRd.";
$lang['userexp_3'] = "<b>uS3R Pr0phILe</b> ALl0W\$ j00 +0 3D1T y0UR u\$3R PR0FIle.";
$lang['userexp_4'] = "<b>cH4N93 P4SSWoRD</b> ALl0w\$ J00 +o Ch4N9E Y0UR P4SSW0RD";
$lang['userexp_5'] = "<b>eM41L &amp; PrIV4cY</b> lE+S j00 CH4n9E hOW J00 cAN 83 c0N+4C+3D 0n 4ND OFF T3h F0RUm.";
$lang['userexp_6'] = "<b>fORum 0PtIOn\$</b> Le+S j00 Ch@ngE HOW +Eh Ph0rum LooKs 4Nd W0Rks.";
$lang['userexp_7'] = "<b>a++@ChMEn+S</b> 4LlOW\$ J00 +o 3D1+/DEl3+3 Y0Ur A+t4ChM3NtS.";
$lang['userexp_8'] = "<b>s1gNA+Ur3</b> LE+S j00 3D1T yOUR SIgn4TuRE.";
$lang['userexp_9'] = "<b>r3l4TI0Nsh1P\$</b> L3TS j00 MAn49E Y0Ur R3L4+I0nsH1P W1+H 0TH3r USer\$ 0N +3H pH0RuM.";
$lang['userexp_9'] = "<b>wORd f1l+3R</b> L3+S j00 EDi+ YouR p3RSOn@l WORD F1L+3R.";
$lang['userexp_10'] = "<b>thr34D SUbSCr1PTI0ns</b> 4LlowS J00 +o M4N4G3 Y0Ur +hRE4D sUBsCripT1oN\$.";
$lang['userdetails'] = "u\$3R D3T@1l5";
$lang['userprofile'] = "u53R PROfILE";
$lang['emailandprivacy'] = "eM@1L &amp; Pr1vaCY";
$lang['editsignature'] = "eDi+ SI9Na+ur3";
$lang['norelationshipssetup'] = "j00 HAV3 N0 us3R REl@TioNsH1pS \$3+ uP. 4dD 4 N3W us3R 8y SE4RcHIn9 83L0W.";
$lang['editwordfilter'] = "eD1+ W0rD pHIlt3R";
$lang['userinformation'] = "u\$3R inpH0Rm4+10N";
$lang['changepassword'] = "ch4n9E Pa\$SWorD";
$lang['currentpasswd'] = "cURREnt pA\$SwOrd";
$lang['newpasswd'] = "n3W P4SSWoRD";
$lang['confirmpasswd'] = "c0nf1Rm P4SSW0rD";
$lang['passwdsdonotmatch'] = "p4s\$wORdS do no+ M@TCH!";
$lang['nicknamerequired'] = "nIcKN4ME IS reQUiR3D!";
$lang['emailaddressrequired'] = "eM4IL 4DdrE\$S I\$ R3Qu1Red!";
$lang['logonnotpermitted'] = "lO90N N0t PErMi++3D. cHO0\$e 4N0+hER!";
$lang['nicknamenotpermitted'] = "n1cKN4m3 N0T pErM1+T3D. CH0O5E 4N0+heR!";
$lang['emailaddressnotpermitted'] = "eM4IL 4DDRe5s N0T PErMIt+ED. Ch0O\$E 4n0+H3R!";
$lang['emailaddressalreadyinuse'] = "em41L aDDre\$S 4LR3ADy 1N u\$E. Ch0o\$3 4N0+h3R!";
$lang['relationshipsupdated'] = "rel4TIOn\$H1P5 uPD4+3D!";
$lang['relationshipupdatefailed'] = "relA+10NSH1P uPDa+3D f41l3D!";
$lang['preferencesupdated'] = "pR3Ph3REnCE\$ WErE 5UccES5PHuLlY uPD4+3D.";
$lang['userdetails'] = "us3r De+41L\$";
$lang['memberno'] = "m3m83r no.";
$lang['firstname'] = "fIRST N@ME";
$lang['lastname'] = "l4\$T N@m3";
$lang['dateofbirth'] = "d4+3 Of 81RtH";
$lang['homepageURL'] = "h0M3P493 UrL";
$lang['profilepicturedimensions'] = "pr0PH1L3 p1CTUr3 (m@X 95X95PX)";
$lang['avatarpicturedimensions'] = "av4+4r P1CtURe (m4x 15X15PX)";
$lang['invalidattachmentid'] = "inv4lId 4Tt@CHm3NT. cheCK TH4t 1\$ h@Sn'+ 83EN DELe+3D.";
$lang['unsupportedimagetype'] = "uNsuPp0r+ED iM493 A+tAChMEN+. j00 CAn ONlY us3 Jpg, g1F AnD PNG 1M49e 4tT@chM3N+S F0R yOUR 4v@T@R 4ND pR0fIl3 P1CTUr3.";
$lang['selectattachment'] = "sel3C+ A++AChm3N+";
$lang['pictureURL'] = "pic+Ur3 URl";
$lang['avatarURL'] = "av4+4R uRL";
$lang['profilepictureconflict'] = "t0 U5E 4N 4TT4ChMEn+ F0R YOuR PrOFil3 P1CtuRe teH P1cTUre uRL f1eLD MU5+ B3 bL@Nk.";
$lang['avatarpictureconflict'] = "tO US3 4N a++acHMeN+ F0R yOUR @V4+4R PiCTUre tHE @V4+ar uRL PH1ELd MUS+ B3 bL@nK.";
$lang['attachmenttoolargeforprofilepicture'] = "seLeC+3d @TtaCHmEN+ Is T0O l4r9E f0r pR0FIl3 P1CtuRE. M@XiMuM d1mEnSI0N\$ 4RE %s";
$lang['attachmenttoolargeforavatarpicture'] = "s3LEc+3D a++aCHMEn+ iS Too lARg3 pH0R @V4T@R pIc+UR3. M@XiMUm DimEns1ON\$ 4Re %s";
$lang['failedtoupdateuserdetails'] = "s0me or aLL 0PH yOuR u\$3r AcC0UN+ Det4IL5 COUlD n0T b3 UpD4T3D. PlE4s3 TrY @G41n L4TeR.";
$lang['failedtoupdateuserpreferences'] = "sOm3 0R 4Ll 0F yOUR us3R PR3F3R3NcE5 coULD NOt 83 uPDatED. Pl3AS3 +rY @9aIN La+eR.";
$lang['emailaddresschanged'] = "eM@il 4DdR3SS h4s bE3N cHAnGeD";
$lang['newconfirmationemailsuccess'] = "youR EMaiL @DDreS\$ H4s 83eN ch4N9ED @ND a N3W C0nPh1RM4TION 3M@1L H@s BeEN \$ENT. pl34se CH3cK 4nD R34D +3h eMAIL Ph0R FuRTHer 1n\$tRUCTIONS.";
$lang['newconfirmationemailfailure'] = "j00 HAv3 Ch@NGeD yoUr 3M41L aDDR3Ss, 8UT wE Wer3 UN@8le To S3ND 4 cONFiRM@tIOn rEQU3\$+. PLeA\$3 c0N+4C+ +3H F0RUm OWneR PHoR @ssISt@NcE.";
$lang['forumoptions'] = "forUM 0PT10N\$";
$lang['notifybyemail'] = "nOT1PHy by 3M4Il OF pO\$tS +o Me";
$lang['notifyofnewpm'] = "n0tIFy By P0PUp OF new Pm Me\$SAgES +0 m3";
$lang['notifyofnewpmemail'] = "noT1PHY 8Y 3M@IL 0F nEW Pm ME\$S@GES +o m3";
$lang['daylightsaving'] = "aDJU\$t pHOr D4Yl1GHt 5@v1N9";
$lang['autohighinterest'] = "aUT0M4+1C@lLY m@Rk +Hre4dS 1 pOS+ In A\$ H19H 1nT3REs+";
$lang['sortthreadlistbyfolders'] = "s0r+ +HRE4d L1\$t 8Y f0LD3Rs";
$lang['convertimagestolinks'] = "autOM4+1C4lLY C0NvERt EmB3DdED 1mAG3s iN p0sTS iN+O lINKs";
$lang['thumbnailsforimageattachments'] = "tHUm8n@iLS fOR 1m493 @tt4CHm3N+s";
$lang['smallsized'] = "sMAll S1Z3D";
$lang['mediumsized'] = "m3dIUM s1Z3D";
$lang['largesized'] = "l4R93 S1ZeD";
$lang['globallyignoresigs'] = "glo8@LLy 19N0r3 uS3R s19N@tuREs";
$lang['allowpersonalmessages'] = "aLL0W o+H3R U53rs To SEnD m3 P3R\$0nAL ME\$s4GEs";
$lang['allowemails'] = "alloW 0+H3R u\$3RS +O S3ND ME EM4Il\$ V14 my pRopHIl3";
$lang['timezonefromGMT'] = "tiME ZON3";
$lang['postsperpage'] = "p0stS PER p493";
$lang['fontsize'] = "f0n+ S1Z3";
$lang['forumstyle'] = "f0rUm S+yl3";
$lang['forumemoticons'] = "f0rUm 3mOTiCONS";
$lang['startpage'] = "s+@R+ P49E";
$lang['signaturecontainshtmlcode'] = "s19N@+uRE CON+41Ns HtMl C0De";
$lang['savesignatureforuseonallforums'] = "s4VE \$1Gn4tUr3 f0R U\$3 On @ll PhORUm\$";
$lang['preferredlang'] = "prePh3RR3D L4N9UAGe";
$lang['donotshowmyageordobtoothers'] = "d0 n0+ sHOW mY ag3 OR D4tE 0f B1R+H to OTH3rs";
$lang['showonlymyagetoothers'] = "shOW 0Nly my 49e +0 0+h3rs";
$lang['showmyageanddobtoothers'] = "sHoW b0+H MY @93 4ND D@tE oPH BiRTh T0 0ThERs";
$lang['showonlymydayandmonthofbirthytoothers'] = "sH0w 0NLY my D@Y 4nd MoN+H 0F 81R+H t0 0+H3R\$";
$lang['listmeontheactiveusersdisplay'] = "l1st m3 0N +H3 4C+1VE usEr\$ dISPl4Y";
$lang['browseanonymously'] = "broWS3 F0rum @nONYmoUSlY";
$lang['allowfriendstoseemeasonline'] = "bROWs3 4NOnYMOu\$LY, 8u+ 4lLOW phR1EnD\$ +0 Se3 Me @S 0NlInE";
$lang['revealspoileronmouseover'] = "rEvE@l SP01LER\$ ON MOuS3 ovER";
$lang['showspoilersinlightmode'] = "aLw4Y\$ SH0W SP01LEr\$ IN l19hT MODe (u\$3\$ lIGhTer ph0N+ COlOUr)";
$lang['resizeimagesandreflowpage'] = "re5IzE im4GEs @nD rePhL0W P@9E T0 Pr3vEN+ H0R1ZoN+aL sCR0LlinG.";
$lang['showforumstats'] = "sH0W f0RUm S+4TS @T bO++Om 0Ph M3\$S@g3 P4N3";
$lang['usewordfilter'] = "en48L3 W0RD PhIL+3R.";
$lang['forceadminwordfilter'] = "f0rCe U\$3 of 4Dm1N WORd F1L+3R On @lL u53RS (1Nc. 9U3s+s)";
$lang['timezone'] = "tIME zOn3";
$lang['language'] = "l4N9U4GE";
$lang['emailsettings'] = "em41L aNd COn+4Ct S3+tIN9\$";
$lang['forumanonymity'] = "fORum 4NOnYm1+Y s3++1nGS";
$lang['birthdayanddateofbirth'] = "bIR+hD@y 4ND DA+e 0Ph B1RtH D1SPl4Y";
$lang['includeadminfilter'] = "iNcLuDE 4dM1N W0RD F1LTeR 1n mY l1\$+.";
$lang['setforallforums'] = "sEt FOr ALl f0RUms?";
$lang['containsinvalidchars'] = "%s coNt@inS 1Nv4LId Ch4R@CtErs!";
$lang['homepageurlmustincludeschema'] = "homEP49E urL mU5+ 1NclUDE H++P:// SCH3ma.";
$lang['pictureurlmustincludeschema'] = "p1CtURE uRL MUs+ InCLUDE h+TP:// SCheM4.";
$lang['avatarurlmustincludeschema'] = "aV4t4R uRL mUSt InCLUdE h+tP:// ScHEm4.";
$lang['postpage'] = "posT p49E";
$lang['nohtmltoolbar'] = "n0 H+ML toOl8@R";
$lang['displaysimpletoolbar'] = "d1sPL4Y S1Mpl3 hTmL TO0Lb4r";
$lang['displaytinymcetoolbar'] = "dI5pl@Y wysiwY9 hTmL +00L84R";
$lang['displayemoticonspanel'] = "di5PL4Y EM0+iCon\$ p@n3l";
$lang['displaysignature'] = "dIsPl4Y S1Gn4TUrE";
$lang['disableemoticonsinpostsbydefault'] = "d1s@8Le Emo+Icon\$ 1N m3\$S@GEs 8Y DEph@UlT";
$lang['automaticallyparseurlsbydefault'] = "aUTOM4+1c@LlY P@rS3 UrLS IN ME5S49E\$ BY D3FAul+";
$lang['postinplaintextbydefault'] = "p0\$T 1N pLA1n T3Xt By Def@ULT";
$lang['postinhtmlwithautolinebreaksbydefault'] = "pOS+ 1n HTMl W1TH 4u+0-LiN3-8R34KS bY D3f4ul+";
$lang['postinhtmlbydefault'] = "posT 1N h+Ml By D3Ph@Ul+";
$lang['postdefaultquick'] = "uS3 QuICK r3PlY 8Y D3ph@uL+. (PhULl rEPLy iN m3NU)";
$lang['privatemessageoptions'] = "pr1vA+E mE5s49E oPTioNS";
$lang['privatemessageexportoptions'] = "prIVa+3 m3sSAGe EXpORt 0Pt10NS";
$lang['savepminsentitems'] = "s4ve 4 CoPY oF e4CH PM I s3ND 1N mY s3N+ 1+3M\$ F0Ld3R";
$lang['includepminreply'] = "iNCLuD3 M3SS@g3 8ODy wHEn R3PlYiNG tO Pm";
$lang['autoprunemypmfoldersevery'] = "au+O prUNe mY Pm FoLD3RS 3VerY:";
$lang['friendsonly'] = "fR13ND\$ 0NLy?";
$lang['globalstyles'] = "glOb@l STylES";
$lang['forumstyles'] = "f0RUM stYl3\$";
$lang['youmustenteryourcurrentpasswd'] = "j00 MusT 3nT3R Y0uR cURr3nt P@SSW0rD";
$lang['youmustenteranewpasswd'] = "j00 muSt 3NTer @ n3W P4ssWOrD";
$lang['youmustconfirmyournewpasswd'] = "j00 MusT C0NF1rM yOUr N3W p@sSwORD";
$lang['profileentriesmustnotincludehtml'] = "pr0PhIL3 eN+RIes mU\$+ no+ 1nClUDE H+mL";
$lang['failedtoupdateuserprofile'] = "fa1L3D +0 uPD4+3 US3R PR0pHIl3";

// Polls (create_poll.php, poll_results.php) ---------------------------------------------

$lang['mustprovideanswergroups'] = "j00 Mu5+ ProViDe sOmE @n\$w3R 9rOUps";
$lang['mustprovidepolltype'] = "j00 mU5+ pROvIdE 4 poLL TyPe";
$lang['mustprovidepollresultsdisplaytype'] = "j00 MusT PRovidE R3SULTS d1\$pl@Y tYP3";
$lang['mustprovidepollvotetype'] = "j00 MU\$+ pr0V1D3 4 polL voTe +ypE";
$lang['mustprovidepollguestvotetype'] = "j00 musT SpECifY 1PH guE\$TS Sh0uLd Be 4LlowED TO VOTe";
$lang['mustprovidepolloptiontype'] = "j00 mU\$T PRoV1D3 4 POLl Op+10N +Yp3";
$lang['mustprovidepollchangevotetype'] = "j00 mU\$T pROvIDe 4 POlL cH@n9E V0t3 +Yp3";
$lang['pollquestioncontainsinvalidhtml'] = "oNe OR M0R3 of yoUr P0ll qU3S+1On\$ C0N+41N\$ 1Nv4LID H+mL.";
$lang['pleaseselectfolder'] = "ple4s3 \$3L3C+ 4 PhOLDeR";
$lang['mustspecifyvalues1and2'] = "j00 mU\$+ SpEC1PHy v4lUes PhoR ANSweRS 1 aND 2";
$lang['tablepollmusthave2groups'] = "t4bUL4R Ph0RM4t POll\$ mu\$+ H4v3 pr3Cis3ly +w0 VOtiNg 9R0Ups";
$lang['nomultivotetabulars'] = "t4bul@R PH0Rma+ POLL\$ CANn0+ b3 MuL+I-v0+e";
$lang['nomultivotepublic'] = "pu8LIc B4Ll0+S c@Nno+ bE mULT1-v0+e";
$lang['abletochangevote'] = "j00 W1Ll 83 4Ble TO Ch4N9E yOUR vOTE.";
$lang['abletovotemultiple'] = "j00 W1Ll b3 ABlE tO v0+3 MuL+1PLe TImE\$.";
$lang['notabletochangevote'] = "j00 WIlL N0+ bE 4blE t0 Ch4N93 y0UR v0T3.";
$lang['pollvotesrandom'] = "nOT3: p0Ll votE\$ 4R3 rAnDOmLy 9ENer4+3D pH0R PReV13W 0NLY.";
$lang['pollquestion'] = "poLL QuesT10N";
$lang['possibleanswers'] = "pO\$S1BlE @NSw3R\$";
$lang['enterpollquestionexp'] = "eNt3R tH3 4NSWeR\$ F0R YOUR P0lL QU3ST1ON.. 1PH Y0uR pOLl i\$ 4 &quot;Y3\$/NO&quot; qU3\$tiON, SImPLY 3N+3R &quot;Y3\$&quot; f0r @N\$W3r 1 anD &quot;NO&quot; for @NSwER 2.";
$lang['numberanswers'] = "no. 4NSWeR\$";
$lang['answerscontainHTML'] = "aN\$W3R\$ c0nT41N HTmL (nO+ INcLUd1n9 \$1GnA+UR3)";
$lang['optionsdisplay'] = "ansWERs D1\$PL4Y tYpE";
$lang['optionsdisplayexp'] = "h0w \$HoULD teH 4NSw3R\$ bE pRe5enT3D?";
$lang['dropdown'] = "a5 DR0p-down l15+(\$)";
$lang['radios'] = "aS 4 \$3rIE\$ OF R@D10 8u++0N\$";
$lang['votechanging'] = "v0+3 Ch4nG1ng";
$lang['votechangingexp'] = "c4n A PEr\$0N CH4N9E h1\$ 0R HER V0+e?";
$lang['guestvoting'] = "gue\$T v0+1NG";
$lang['guestvotingexp'] = "c4n 9u3S+S v0+3 1N +H1\$ polL?";
$lang['allowmultiplevotes'] = "allOW mUL+1pLE VO+e\$";
$lang['pollresults'] = "pOLl R3\$UlT\$";
$lang['pollresultsexp'] = "h0W woUlD j00 l1k3 tO dI\$pL@Y ThE rEsuLTS OpH y0UR POlL?";
$lang['pollvotetype'] = "poll V0TiNg Type";
$lang['pollvotesexp'] = "h0W \$H0UlD Th3 pOLL 8e coNdUC+3d?";
$lang['pollvoteanon'] = "anonYmOuSLy";
$lang['pollvotepub'] = "pU8L1C bALL0+";
$lang['horizgraph'] = "h0r1ZOn+@L 9R4Ph";
$lang['vertgraph'] = "v3r+1C4L GR@PH";
$lang['tablegraph'] = "t4bUL4R pHORM4+";
$lang['polltypewarning'] = "<b>w@Rn1NG</b>: +Hi\$ 1S A PUbL1C bALloT. Y0UR N4ME WIll 8E vI\$1Bl3 NEx+ +o tH3 Op+I0n J00 Vo+e f0R.";
$lang['expiration'] = "eXPIr4+10N";
$lang['showresultswhileopen'] = "d0 J00 W@NT +o 5HOw Re5uL+s wH1LE t3h poLL 1S 0pEN?";
$lang['whenlikepollclose'] = "wh3N W0ULd J00 l1K3 Y0Ur P0Ll T0 4U+om@T1C4LLy clO\$3?";
$lang['oneday'] = "on3 D4Y";
$lang['threedays'] = "threE DaYS";
$lang['sevendays'] = "s3vEn D4Y\$";
$lang['thirtydays'] = "th1RtY D4YS";
$lang['never'] = "neV3R";
$lang['polladditionalmessage'] = "adD1TI0N@l ME\$S493 (0P+10N4L)";
$lang['polladditionalmessageexp'] = "dO J00 W4N+ T0 1nCLUDe 4N @DdI+i0N4L pO\$t 4FT3R tHE P0Ll?";
$lang['mustspecifypolltoview'] = "j00 MU\$T SPeCIpHy A P0LL T0 V13w.";
$lang['pollconfirmclose'] = "arE J00 \$uRe J00 W@Nt To cLO\$3 THe pH0lLowING pOlL?";
$lang['endpoll'] = "end pOll";
$lang['nobodyvotedclosedpoll'] = "no80dY V0TED";
$lang['votedisplayopenpoll'] = "%s 4nD %s h@Ve v0T3d.";
$lang['votedisplayclosedpoll'] = "%s 4Nd %s v0+ed.";
$lang['nousersvoted'] = "n0 Us3r\$";
$lang['oneuservoted'] = "1 U53R";
$lang['xusersvoted'] = "%s user\$";
$lang['noguestsvoted'] = "n0 GU3ST\$";
$lang['oneguestvoted'] = "1 9U3sT";
$lang['xguestsvoted'] = "%s GU3S+S";
$lang['pollhasended'] = "p0LL h4s EndED";
$lang['youvotedforpolloptionsondate'] = "j00 Vot3D F0r %s 0N %s";
$lang['thisisapoll'] = "th1\$ 1s 4 Poll. clicK TO VI3W R3sUlt5.";
$lang['editpoll'] = "eD1+ pOLl";
$lang['results'] = "reSUl+s";
$lang['resultdetails'] = "r3sUL+ De+AilS";
$lang['changevote'] = "ch@NgE Vot3";
$lang['pollshavebeendisabled'] = "polLs h@VE 83eN dI\$ABl3D bY +h3 FORuM OwNEr.";
$lang['answertext'] = "an\$W3R Tex+";
$lang['answergroup'] = "aN\$W3R 9ROup";
$lang['previewvotingform'] = "preV13W VO+INg f0rM";
$lang['viewbypolloption'] = "vieW BY Poll oPT1ON";
$lang['viewbyuser'] = "vIEW bY u\$ER";

// Profiles (profile.php) ----------------------------------------------

$lang['editprofile'] = "eDiT PROfiLE";
$lang['profileupdated'] = "propHiL3 UPD4TeD.";
$lang['profilesnotsetup'] = "th3 Ph0RUM OWn3R H@s N0T S3+ UP PR0pHiL3S.";
$lang['ignoreduser'] = "i9n0R3D us3R";
$lang['lastvisit'] = "l@sT v1s1T";
$lang['userslocaltime'] = "uSeR'\$ L0c@L +im3";
$lang['userstatus'] = "st4tUS";
$lang['useractive'] = "oNLiNE";
$lang['userinactive'] = "iN4c+Iv3 / 0FPHL1N3";
$lang['totaltimeinforum'] = "toT4L TiME";
$lang['longesttimeinforum'] = "l0NG3ST \$E5SI0N";
$lang['sendemail'] = "sEnD 3M@1l";
$lang['sendpm'] = "sEnd Pm";
$lang['visithomepage'] = "v1S1+ h0mEP4g3";
$lang['age'] = "aG3";
$lang['aged'] = "a93d";
$lang['birthday'] = "b1r+HD4Y";
$lang['registered'] = "r3G1\$T3R3d";
$lang['findpostsmadebyuser'] = "fIND po\$+S MAde 8Y %s";
$lang['findpostsmadebyme'] = "f1nD POSt\$ mADE 8Y m3";
$lang['findthreadsstartedbyuser'] = "f1nD ThR34Ds \$t@R+eD bY %s";
$lang['findthreadsstartedbyme'] = "fInD THreAd\$ \$t@r+3D bY m3";
$lang['profilenotavailable'] = "pRoFIl3 no+ @V4IlA8LE.";
$lang['userprofileempty'] = "thIs UsER Ha\$ noT pH1Ll3D In +h3IR pROF1L3 or iT i\$ S3+ TO PRiV4+3.";

// Registration (register.php) -----------------------------------------

$lang['newuserregistrationsarenotpermitted'] = "sORRy, N3W US3r ReGIStRA+10n\$ ARe N0T @lL0WED R1gHT n0w. pL3@S3 CHECk 84cK L4+ER.";
$lang['usernameinvalidchars'] = "u\$3RN@m3 C4N 0NlY COnt41N 4-z, 0-9, _ - CH@r@c+3R5";
$lang['usernametooshort'] = "us3RN@m3 Mu5+ bE 4 Min1MUm OF 2 ChAR4C+3R5 lONG";
$lang['usernametoolong'] = "us3RN4M3 MU\$t 83 @ M@XImUM Of 15 cH4R4C+ER\$ LOnG";
$lang['usernamerequired'] = "a L0GOn N4M3 1S R3QU1R3D";
$lang['passwdmustnotcontainHTML'] = "paSSw0RD mUS+ N0t C0n+41N hTmL +49\$";
$lang['passwordinvalidchars'] = "p@s5W0Rd C@N oNLY CoN+4IN 4-Z, 0-9, _ - Ch4RAcTEr5";
$lang['passwdtooshort'] = "p4sSW0Rd mU\$T 8E 4 m1NImUm OPh 6 cH@raCt3RS lONg";
$lang['passwdrequired'] = "a P4SSw0Rd 1\$ R3Qu1REd";
$lang['confirmationpasswdrequired'] = "a cONpH1RM@+ioN p@SSwORd IS R3QuIR3D";
$lang['nicknamerequired'] = "a N1CKnAMe IS REqU1R3d";
$lang['emailrequired'] = "aN 3MaIl 4DDr3sS IS rEQU1reD";
$lang['passwdsdonotmatch'] = "p@\$sw0RDS d0 NO+ M4+CH";
$lang['usernamesameaspasswd'] = "u5ern@ME 4nD p4sSW0Rd Mu\$+ bE dIPHpH3ReN+";
$lang['usernameexists'] = "sORRY, @ US3R W1+H TH4T n4Me 4Lr3@Dy EXIsT\$";
$lang['successfullycreateduseraccount'] = "sUcCE\$sPhULLy Cre4T3d U5Er 4CcoUn+";
$lang['useraccountcreatedconfirmfailed'] = "yoUR uSeR 4CCouN+ H4S BeEN cREA+eD bU+ tEH ReQU1REd C0NphIRm4t10N 3M@IL W4S N0T S3N+. PL3@s3 CON+4c+ tEH Ph0RUm oWn3r T0 R3C+1fY +h1\$. IN +H1\$ M34NTImE PLE4s3 CL1CK +H3 C0NT1NUe BUt+On TO loGin.";
$lang['useraccountcreatedconfirmsuccess'] = "y0Ur U\$3R 4cCOuNT H@s bE3N crE4+3D buT 8ePHOR3 j00 C4N S+aRT p0sT1NG j00 MUSt COnFIRm YouR EMaIL 4dDreSS. pL34\$e CHecK Y0ur EMaIL pH0R 4 L1NK +H@t w1LL @Ll0w j00 T0 c0nFiRM y0uR 4Ddr3SS.";
$lang['useraccountcreated'] = "y0uR U\$3R @Cc0uNt h45 833N cRE4t3D SuCCEssPHuLLy! cl1CK +He C0ntINU3 BUtTON 83LOw TO l091N";
$lang['errorcreatinguserrecord'] = "errOR cRe@tIn9 U\$3R R3C0Rd";
$lang['userregistration'] = "us3r R3Gi5tRA+1ON";
$lang['registrationinformationrequired'] = "re91\$tr4+I0N 1NF0rM4T10N (R3qU1REd)";
$lang['profileinformationoptional'] = "pRoFIl3 Inf0Rm@T10N (Op+10N@l)";
$lang['preferencesoptional'] = "pRePhEReNCes (opt10n4L)";
$lang['register'] = "r3G1S+3R";
$lang['rememberpasswd'] = "r3meMb3R p4sSW0RD";
$lang['birthdayrequired'] = "d@+3 0F 81RTh i\$ ReQUiR3D 0R 1s Inv4lId";
$lang['alwaysnotifymeofrepliestome'] = "nOTiPHY oN repLy T0 M3";
$lang['notifyonnewprivatemessage'] = "nOtIphY oN n3W pRIv4T3 m3sS4Ge";
$lang['popuponnewprivatemessage'] = "pOP Up On nEW pR1V4+E Me\$s49E";
$lang['automatichighinterestonpost'] = "au+0M4Tic hIgH 1Nt3r3ST 0n p0sT";
$lang['confirmpassword'] = "conF1RM P4SSW0Rd";
$lang['invalidemailaddressformat'] = "inv4L1D EmaIl AdDRess F0Rm4+";
$lang['moreoptionsavailable'] = "moR3 PrOF1L3 4Nd PrEPH3r3NcE oP+10N\$ Ar3 @v4IL4ble 0NcE J00 R3G1\$+er";
$lang['textcaptchaconfirmation'] = "c0NPhIrm4+1ON";
$lang['textcaptchaexplain'] = "tO +hE rIgh+ I\$ 4 +3Xt-C4PtCh4 IM4gE. PlE4\$3 +YP3 +H3 C0De j00 CAn S33 1N +He iM49E 1nTO +3h InpUt PHiELd B3LOw I+.";
$lang['textcaptchaimgtip'] = "thIs 1s @ C4p+ch4-PiCTURE. 1+ i\$ US3d +0 PreVEN+ 4U+0MA+1c REgi\$+R4T10N";
$lang['textcaptchamissingkey'] = "a coNphiRM@tIOn C0dE is ReQU1r3D.";
$lang['textcaptchaverificationfailed'] = "t3Xt-C4P+cHa Verific@TIOn Cod3 wA\$ 1NcORr3ct. Ple@S3 R3-ENT3r 1T.";
$lang['forumrules'] = "fOrum Rul3s";
$lang['forumrulesnotification'] = "in 0Rd3r +o prOCEed, J00 mUst @gr3e Wi+H tH3 f0Ll0w1N9 rULES";
$lang['forumrulescheckbox'] = "i h4VE R34D, 4ND @gR3E +o 4BiD3 8Y +HE fORUm rul3\$.";
$lang['youmustagreetotheforumrules'] = "j00 Mu\$T @9r33 +0 T3h F0Rum RUleS bEf0RE j00 C4N con+INUE.";

// Recent visitors list  (visitor_log.php) -----------------------------

$lang['member'] = "m3MbeR";
$lang['searchforusernotinlist'] = "sE4RCH ph0R a US3r n0+ 1N lISt";
$lang['yoursearchdidnotreturnanymatches'] = "y0uR S34RCh diD nO+ R3+urN @Ny M@+cH3S. +rY \$imPLifYIn9 yoUr S34RcH p4R@mE+er\$ 4ND +rY @94IN.";
$lang['hiderowswithemptyornullvalues'] = "hID3 rOW\$ W1tH 3MptY 0R NUll vAlUES iN \$ELEcT3D COLuMNs";
$lang['showregisteredusersonly'] = "sHow r39IST3r3d U\$3RS 0NLY (H1D3 9U3S+S)";

// Relationships (user_rel.php) ----------------------------------------

$lang['relationships'] = "rEL@tION\$h1Ps";
$lang['userrelationship'] = "uS3R REl4T10NSh1P";
$lang['userrelationships'] = "uS3r R3LA+1ON\$H1PS";
$lang['failedtoremoveselectedrelationships'] = "f41LeD tO rEM0Ve 5eL3Ct3D r3L4T10NSh1p";
$lang['friends'] = "fR13NDs";
$lang['ignoredcompletely'] = "ignOR3D COmpL3+3lY";
$lang['relationship'] = "rEl@T10NSH1p";
$lang['restorenickname'] = "rEsToR3 Us3R'S N1CKN@M3";
$lang['friend_exp'] = "u53r'S PO\$tS m@RK3d wi+h 4 &quot;pHR1EnD&quot; 1C0n.";
$lang['normal_exp'] = "u53R'S Po\$TS 4PP34R 4\$ NOrM4L.";
$lang['ignore_exp'] = "u\$ER'5 p0\$tS 4R3 h1DDEN.";
$lang['ignore_completely_exp'] = "tHr34DS 4nD p0S+S +O Or PhROm UseR w1LL aPPeAR dElE+ED.";
$lang['display'] = "d1sPl4y";
$lang['displaysig_exp'] = "u\$ER's SiGn4TUre is d1\$PlAy3D 0N +H3Ir pOSTs.";
$lang['hidesig_exp'] = "u\$eR's \$1gnA+UR3 iS h1dDEn 0N THeIR pO\$+s.";
$lang['cannotignoremod'] = "j00 c4NNo+ 19NorE THIS u5Er, 4S +H3Y 4R3 4 MoDER@tOr.";
$lang['previewsignature'] = "pReVIeW 5IgnAtURe";

// Search (search.php) -------------------------------------------------

$lang['searchresults'] = "s34rcH R3\$uL+s";
$lang['usernamenotfound'] = "the Us3RN4M3 j00 Sp3Cif13D IN T3H +0 0R PHrOM ph1ELd W@S noT PHouND.";
$lang['notexttosearchfor'] = "on3 0R aLl OF y0uR S34rcH K3YWOrDS wER3 Inv4LID. s34RCH k3YWOrds muST 83 N0 ShoRT3R TH@n %d CH4r4C+Er\$, N0 l0nG3R +HAn %d CH@R4C+eR\$ 4Nd MUst noT 4Pp34r IN TH3 %s";
$lang['keywordscontainingerrors'] = "k3YW0RDS cON+AIn1Ng 3RR0r\$: %s";
$lang['mysqlstopwordlist'] = "mYsQL \$+OpWORd L1\$T";
$lang['foundzeromatches'] = "fouND: 0 M4TcH3\$";
$lang['found'] = "fOUND";
$lang['matches'] = "m4+CH3s";
$lang['prevpage'] = "pReVIous P@gE";
$lang['findmore'] = "fINd M0R3";
$lang['searchmessages'] = "s34RCH m3SS@G3S";
$lang['searchdiscussions'] = "s3@RCh D1sCusS10NS";
$lang['find'] = "fIND";
$lang['additionalcriteria'] = "addI+i0N4L crI+ER14";
$lang['searchbyuser'] = "s3@Rch by Us3r (0PT1ON4l)";
$lang['folderbrackets_s'] = "fOLDeR(\$)";
$lang['postedfrom'] = "posTEd FroM";
$lang['postedto'] = "p0sTEd to";
$lang['today'] = "tod4Y";
$lang['yesterday'] = "y3st3RD4y";
$lang['daybeforeyesterday'] = "d4y 83F0Re Y3S+3Rd@y";
$lang['weekago'] = "%s wEEK aG0";
$lang['weeksago'] = "%s We3ks 4go";
$lang['monthago'] = "%s m0N+H 49O";
$lang['monthsago'] = "%s M0N+hS 490";
$lang['yearago'] = "%s y34R @9o";
$lang['beginningoftime'] = "bEGinNIn9 OPh TImE";
$lang['now'] = "n0W";
$lang['lastpostdate'] = "l@\$T p0ST d4t3";
$lang['numberofreplies'] = "num8eR of R3Pl13s";
$lang['foldername'] = "f0lD3R nAme";
$lang['authorname'] = "au+h0R nAmE";
$lang['decendingorder'] = "n3wE\$t PH1rsT";
$lang['ascendingorder'] = "oLD3S+ FIr\$+";
$lang['keywords'] = "k3yWORds";
$lang['sortby'] = "s0R+ BY";
$lang['sortdir'] = "s0R+ dIR";
$lang['sortresults'] = "s0RT rESUlTS";
$lang['groupbythread'] = "grouP BY +HrE4d";
$lang['postsfromuser'] = "poST\$ PHr0m us3R";
$lang['threadsstartedbyuser'] = "thrE4D\$ \$T@r+3D 8Y US3r";
$lang['searchfrequencyerror'] = "j00 C@n ONlY sE@rcH OnCE EVErY %s S3C0ND\$. pLE4s3 TrY aGAiN la+ER.";
$lang['searchsuccessfullycompleted'] = "sE4Rch suCC3\$sPHuLLY c0MPlEt3d. %s";
$lang['clickheretoviewresults'] = "cLICk hERe T0 v13W RESuL+s.";

// Search Popup (search_popup.php) -------------------------------------

$lang['select'] = "sel3C+";
$lang['searchforthread'] = "s34rCH pH0R +HreaD";
$lang['mustspecifytypeofsearch'] = "j00 Mu\$T sPEcIFy +Ype 0F S34RcH tO PerFOrm";
$lang['unkownsearchtypespecified'] = "unkNoWn S34RCh TyP3 \$PEcIFIeD";
$lang['mustentersomethingtosearchfor'] = "j00 MusT 3n+3R SoMETHin9 +0 5E@Rch fOR";

// Start page (start_left.php) -----------------------------------------

$lang['recentthreads'] = "r3ceN+ +HRe4d5";
$lang['startreading'] = "s+@Rt RE4D1ng";
$lang['threadoptions'] = "thR3@D 0PTi0NS";
$lang['editthreadoptions'] = "eDi+ +Hre4D 0Pt1oNS";
$lang['morevisitors'] = "m0rE VI\$1tOrs";
$lang['forthcomingbirthdays'] = "f0RThC0MiN9 81RtHd4YS";

// Start page (start_main.php) -----------------------------------------

$lang['editstartpage_help'] = "j00 C@n eD1+ Th1s P4g3 PhroM +3H 4DM1N 1N+3RPh4CE";

// Thread navigation (thread_list.php) ---------------------------------

$lang['newdiscussion'] = "n3w Di5CUSs1oN";
$lang['createpoll'] = "cR34+3 P0Ll";
$lang['search'] = "sE4RCh";
$lang['searchagain'] = "s34RcH @g41N";
$lang['alldiscussions'] = "alL D1scUSS10Ns";
$lang['unreaddiscussions'] = "uNr34d D1\$CUSs1oN\$";
$lang['unreadtome'] = "unr3@D &quot;TO: M3&quot;";
$lang['todaysdiscussions'] = "t0DAY's Di\$CU\$s1oN\$";
$lang['2daysback'] = "2 DAYS B@CK";
$lang['7daysback'] = "7 dAYs BacK";
$lang['highinterest'] = "h19H In+3R3S+";
$lang['unreadhighinterest'] = "uNRE4D h1GH IN+3rEST";
$lang['iverecentlyseen'] = "i'v3 R3CenTLy S3EN";
$lang['iveignored'] = "i'vE iGN0R3D";
$lang['byignoredusers'] = "by 1GNOr3d US3rs";
$lang['ivesubscribedto'] = "i'V3 su8SCR1beD To";
$lang['startedbyfriend'] = "s+aRt3d 8Y PHr1END";
$lang['unreadstartedbyfriend'] = "unr3@D s+D BY PHR1enD";
$lang['startedbyme'] = "sT4RTed 8Y M3";
$lang['unreadtoday'] = "uNreAD +0D@Y";
$lang['deletedthreads'] = "dELE+3D +hRE4Ds";
$lang['goexcmark'] = "go!";
$lang['folderinterest'] = "foLD3R 1nTeR3\$t";
$lang['postnew'] = "pO5+ neW";
$lang['currentthread'] = "cUrReN+ +HrEAd";
$lang['highinterest'] = "h1gH 1N+eR3ST";
$lang['markasread'] = "m4rk @S RE@D";
$lang['next50discussions'] = "neX+ 50 D1\$cU\$s10NS";
$lang['visiblediscussions'] = "vI\$1BLE dIScU\$si0N\$";
$lang['selectedfolder'] = "selEC+ED F0Lder";
$lang['navigate'] = "n@vIg4+E";
$lang['couldnotretrievefolderinformation'] = "tH3r3 @rE n0 PhOLd3rS 4V41L@8L3.";
$lang['nomessagesinthiscategory'] = "n0 mE\$S@gES 1N THi\$ C@+390RY. plEasE \$eLEcT aN0Th3R, 0r %s FOR 4lL +HrE4DS";
$lang['clickhere'] = "cliCk H3R3";
$lang['prev50threads'] = "pR3VIoU\$ 50 ThR34DS";
$lang['next50threads'] = "nEX+ 50 tHR34d\$";
$lang['nextxthreads'] = "n3xt %s +hR34dS";
$lang['threadstartedbytooltip'] = "thrE4D #%s S+4RT3D BY %s. VIeWEd %s";
$lang['threadviewedonetime'] = "1 TIm3";
$lang['threadviewedtimes'] = "%d +ImES";
$lang['readthread'] = "r34d +HReAD";
$lang['unreadmessages'] = "uNR34D mE5\$@9E5";
$lang['subscribed'] = "suB\$cRIbeD";
$lang['stickythreads'] = "s+1cKY tHr34DS";
$lang['mostunreadposts'] = "mOsT UnRE4D PO\$tS";
$lang['onenew'] = "%d nEW";
$lang['manynew'] = "%d n3W";
$lang['onenewoflength'] = "%d NEW 0f %d";
$lang['manynewoflength'] = "%d n3W 0F %d";
$lang['confirmmarkasread'] = "aR3 J00 Sur3 J00 w4NT to M@rK T3H SEL3C+3D THr34D\$ @S REAd?";
$lang['successfullymarkreadselectedthreads'] = "sUCcessPhULlY M@Rk3d S3LeCTed +hR34D\$ 4s R3@d";
$lang['failedtomarkselectedthreadsasread'] = "f41l3D +0 M4rk SeLEcT3D thR34Ds 4S Re4d";
$lang['gotofirstpostinthread'] = "go +o FIRs+ poS+ 1n tHReAD";
$lang['gotolastpostinthread'] = "g0 +0 l4ST p05T 1N tHRe4D";
$lang['viewmessagesinthisfolderonly'] = "v1ew M3SS493s 1N +H1S f0LDEr 0NlY";
$lang['shownext50threads'] = "sHOW n3xT 50 +hR3@ds";
$lang['showprev50threads'] = "sH0w pREv10US 50 tHR34DS";
$lang['createnewdiscussioninthisfolder'] = "cRe4Te N3W d1scU\$\$10n 1N tHI\$ F0LD3R";
$lang['nomessages'] = "no ME\$s4g35";

// HTML toolbar (htmltools.inc.php) ------------------------------------
$lang['bold'] = "b0ld";
$lang['italic'] = "it4LiC";
$lang['underline'] = "uND3RL1n3";
$lang['strikethrough'] = "s+r1KEtHR0UGh";
$lang['superscript'] = "supeRSCrIPt";
$lang['subscript'] = "sUB\$cR1Pt";
$lang['leftalign'] = "lepH+-@L1Gn";
$lang['center'] = "c3N+ER";
$lang['rightalign'] = "rI9hT-4lIgN";
$lang['numberedlist'] = "nUM83R3D lISt";
$lang['list'] = "lIsT";
$lang['indenttext'] = "indENt T3XT";
$lang['code'] = "c0d3";
$lang['quote'] = "qu0Te";
$lang['unquote'] = "unqUOTe";
$lang['spoiler'] = "sp0iLER";
$lang['horizontalrule'] = "hORiZOn+AL RuLe";
$lang['image'] = "im493";
$lang['hyperlink'] = "hYp3Rl1NK";
$lang['noemoticons'] = "dI\$48L3 3M0TiCOn\$";
$lang['fontface'] = "f0nT Ph@Ce";
$lang['size'] = "s1Z3";
$lang['colour'] = "c0loUr";
$lang['red'] = "r3d";
$lang['orange'] = "oR4NGE";
$lang['yellow'] = "y3llOW";
$lang['green'] = "gr3En";
$lang['blue'] = "blUe";
$lang['indigo'] = "iNd1G0";
$lang['violet'] = "v1oL3+";
$lang['white'] = "whi+3";
$lang['black'] = "bl4cK";
$lang['grey'] = "gREY";
$lang['pink'] = "pinK";
$lang['lightgreen'] = "l19h+ Gr33N";
$lang['lightblue'] = "lI9hT bLu3";

// Forum Stats --------------------------------

$lang['forumstats'] = "fORUm \$+4T\$";
$lang['userstats'] = "u53R S+4+S";

$lang['usersactiveinthepasttimeperiod'] = "%s 4CtIVe in th3 P4\$+ %s. %s";

$lang['numactiveguests'] = "<b>%s</b> gUESts";
$lang['oneactiveguest'] = "<b>1</b> 9U3St";
$lang['numactivemembers'] = "<b>%s</b> MEM8Er\$";
$lang['oneactivemember'] = "<b>1</b> MEMb3r";
$lang['numactiveanonymousmembers'] = "<b>%s</b> 4nONyM0uS mEmbEr\$";
$lang['oneactiveanonymousmember'] = "<b>1</b> 4nONyM0U5 mEMbER";

$lang['numthreadscreated'] = "<b>%s</b> +hREAds";
$lang['onethreadcreated'] = "<b>1</b> +HREaD";
$lang['numpostscreated'] = "<b>%s</b> poSTs";
$lang['onepostcreated'] = "<b>1</b> po\$+";

$lang['younormal'] = "j00";
$lang['youinvisible'] = "j00 (INvI\$1BlE)";
$lang['viewcompletelist'] = "v13W coMpL3+3 l1\$+";
$lang['ourmembershavemadeatotalofnumthreadsandnumposts'] = "oUr MeM83RS h@vE M@dE @ +oT4L oPH %s @nD %s.";
$lang['longestthreadisthreadnamewithnumposts'] = "l0n93\$T +HrE4D I\$ <b>%s</b> wITh %s.";
$lang['therehavebeenxpostsmadeinthelastsixtyminutes'] = "th3re H4Ve b3en <b>%s</b> Po\$tS M4d3 In +HE l@S+ 60 mInuT3S.";
$lang['therehasbeenonepostmadeinthelastsxityminutes'] = "tHere H@\$ B3EN <b>1</b> P0ST M@d3 1N +3H L@S+ 60 mINut3S.";
$lang['mostpostsevermadeinasinglesixtyminuteperiodwasnumposts'] = "m0ST P0S+S EVER m4d3 1N @ SIngL3 60 miNuT3 PeRI0D 1\$ <b>%s</b> 0N %s.";
$lang['wehavenumregisteredmembersandthenewestmemberismembername'] = "w3 H4Ve <b>%s</b> r3G1\$T3R3D M3M83r\$ 4ND tHe N3W3St MEm83R 1\$ <b>%s</b>.";
$lang['wehavenumregisteredmember'] = "we h@VE %s r3G1STeR3D mEmBErs.";
$lang['wehaveoneregisteredmember'] = "w3 h4V3 0N3 R39ISt3r3D m3MBER.";
$lang['mostuserseveronlinewasnumondate'] = "mosT U\$3Rs 3VER ONl1NE W@\$ <b>%s</b> 0N %s.";
$lang['statsdisplaychanged'] = "sTa+5 d1sPl4Y CH4n93D";

$lang['viewtop20'] = "vi3W +Op 20";

$lang['folderstats'] = "folD3R S+@T\$";
$lang['threadstats'] = "thrE4D St4TS";
$lang['poststats'] = "pos+ s+a+s";
$lang['pollstats'] = "p0LL s+4TS";
$lang['attachmentsstats'] = "at+@ChM3N+\$ \$+@+s";
$lang['userpreferencesstats'] = "u\$3r pREPhER3NcES \$+4TS";
$lang['visitorstats'] = "vI\$1TOr \$t@t\$";
$lang['sessionstats'] = "s3s5ION \$+@tS";
$lang['profilestats'] = "pr0phIL3 S+a+S";
$lang['signaturestats'] = "sIGNa+Ur3 ST4+s";
$lang['ageandbirthdaystats'] = "ag3 @Nd B1R+HD4Y s+4+S";
$lang['relationshipstats'] = "rELa+10n\$HiP \$+@tS";
$lang['wordfilterstats'] = "w0rd Fil+Er ST@T\$";

$lang['numberoffolders'] = "nUMBEr Oph pHOlDErs";
$lang['folderwithmostthreads'] = "fOlD3R WI+h M0St THr34DS";
$lang['folderwithmostposts'] = "fOLD3R w1+H mo\$t P0Sts";
$lang['totalnumberofthreads'] = "tO+4L NUm8eR 0F tHr34DS";
$lang['longestthread'] = "l0nG3\$t ThRE4D";
$lang['mostreadthread'] = "m0\$t Re4D +hr34D";
$lang['threadviews'] = "viewS";
$lang['averagethreadcountperfolder'] = "aVEr49E tHr34D counT pER pHOLd3R";
$lang['totalnumberofthreadsubscriptions'] = "t0t@L num8ER Of THR34d \$Ub5cR1pTIOn5";
$lang['mostpopularthreadbysubscription'] = "m0s+ poPUl4R tHR34D bY suBScr1PTi0N";
$lang['totalnumberofposts'] = "t0t@L NUm8eR oF p0S+S";
$lang['numberofpostsmadeinlastsixtyminutes'] = "nUM83r OF p0STS m4d3 1n L4sT 60 MInU+3s";
$lang['mostpostsmadeinasinglesixtyminuteperiod'] = "m0ST p0s+S m4d3 In 0NE 60 m1nU+3 p3RI0d";
$lang['averagepostsperuser'] = "av3r4G3 p0\$+s PeR u\$3R";
$lang['topposter'] = "t0p P0\$+3r";
$lang['totalnumberofpolls'] = "t0T@L NUmB3R oF p0lL5";
$lang['totalnumberofpolloptions'] = "t0t4L NuM8Er Of P0LL OPt10NS";
$lang['averagevotesperpoll'] = "aVEr93 v0T3S p3R poLl";
$lang['totalnumberofpollvotes'] = "to+@L nUMbER 0F P0Ll V0+e5";
$lang['totalnumberofattachments'] = "to+4L NuM8ER 0F @Tt4CHmEN+5";
$lang['averagenumberofattachmentsperpost'] = "av3r49e 4+T4ChMEnt C0un+ P3R PO\$T";
$lang['mostdownloadedattachment'] = "mosT D0WNl0@DEd A+TAChm3N+";
$lang['mostusedforumstyle'] = "m05t US3D ph0RUm \$TyLE";
$lang['mostusedlanguuagefile'] = "m0St USEd L@n9u49e PHiL3";
$lang['mostusedtimezone'] = "m0St u\$eD +1M3z0Ne";
$lang['mostusedemoticonpack'] = "m0St USeD Em0TiC0n Pack";

$lang['numberofusers'] = "nUMB3R oPH uSEr5";
$lang['newestuser'] = "neW3S+ usEr";
$lang['numberofcontributingusers'] = "nUm8ER 0PH C0n+r18uTInG U\$3RS";
$lang['numberofnoncontributingusers'] = "nuM8Er OF N0N-c0n+Ri8Ut1Ng us3rs";
$lang['subscribers'] = "su85CR1B3r\$";

$lang['numberofvisitorstoday'] = "numB3r 0f VI51T0r\$ toD@y";
$lang['numberofvisitorsthisweek'] = "nUMber 0pH VI\$1t0R\$ +hIs WEek (p3R10D: %s to %s)";
$lang['numberofvisitorsthismonth'] = "nUM8Er 0F V1S1T0R\$ Th1S m0N+h";
$lang['numberofvisitorsthisyear'] = "nUM83R of visIT0R5 +h1\$ Ye@r";

$lang['totalnumberofactiveusers'] = "t0+@L nuM83R Of 4C+1VE User\$";
$lang['numberofactiveregisteredusers'] = "nuM8er OF 4C+1v3 Re91S+eR3D User5";
$lang['numberofactiveguests'] = "nuMb3R 0F @ctIvE gU3Sts";
$lang['mostuserseveronline'] = "m0ST u\$er5 3ver 0NlINe";
$lang['mostactiveuser'] = "m0ST acT1VE us3R";
$lang['numberofuserswithprofile'] = "nUm8ER oF U5ERS WI+h pR0fiLE";
$lang['numberofuserswithoutprofile'] = "nUM8ER 0F us3R\$ w1THou+ pR0phIle";
$lang['numberofuserswithsignature'] = "numbeR of U\$ER\$ WI+H 5i9n@TuR3";
$lang['numberofuserswithoutsignature'] = "nuM83R 0f US3Rs W1THoU+ \$1GN@+UrE";
$lang['averageage'] = "av3RAGE @Ge";
$lang['mostpopularbirthday'] = "mosT PopuLAr B1R+HD4Y";
$lang['nobirthdaydataavailable'] = "nO 81RtHDAy Da+a @V41L@8le";
$lang['numberofusersusingwordfilter'] = "num8eR oF us3RS US1N9 woRD f1L+3R";
$lang['numberofuserreleationships'] = "nUM83R 0F USer RElEATi0NShIPS";
$lang['averageage'] = "av3R49E 493";
$lang['averagerelationshipsperuser'] = "aV3R493 R3L4+10N\$H1P\$ P3R usER";

$lang['numberofusersnotusingwordfilter'] = "nuM8er 0Ph USEr\$ nO+ us1Ng w0RD FiL+eR";
$lang['averagewordfilterentriesperuser'] = "aver493 WorD pHIl+3R EnTR13S P3R U\$3r";

$lang['mostuserseveronlinedetail'] = "%s oN %s";

// Thread Options (thread_options.php) ---------------------------------

$lang['updatessavedsuccessfully'] = "uPD4TE\$ \$@v3D 5UCc3\$SfULLy";
$lang['useroptions'] = "u53R 0Pt10NS";
$lang['markedasread'] = "m4rK3D @\$ R34d";
$lang['postsoutof'] = "p0sTS 0Ut 0f";
$lang['interest'] = "iNTER3s+";
$lang['closedforposting'] = "cloS3D f0r pOsTiN9";
$lang['locktitleandfolder'] = "l0cK Ti+L3 4ND Ph0lDeR";
$lang['deletepostsinthreadbyuser'] = "dEl3+3 POsTS 1N tHre4D bY usEr";
$lang['deletethread'] = "d3lE+3 +hRE4D";
$lang['permenantlydelete'] = "p3rM4n3N+lY D3Le+E";
$lang['movetodeleteditems'] = "m0VE t0 D3L3+3D +hRE4DS";
$lang['undeletethread'] = "uNdElE+3 ThrE4D";
$lang['markasunread'] = "m4rK 4S unR34D";
$lang['makethreadsticky'] = "m4k3 THr3@D S+1CkY";
$lang['threareadstatusupdated'] = "tHrE4D Re4d \$T@Tus uPD@+3D \$uCC3\$SphULlY";
$lang['interestupdated'] = "thr3AD IN+3R3s+ st4+u\$ UpD@tED sUCc3\$SphUlLY";
$lang['failedtoupdatethreadreadstatus'] = "f@ilED +O upDa+3 +hRE4D RE4D S+A+U\$";
$lang['failedtoupdatethreadinterest'] = "f41L3D +O UPd4T3 +hRE4D 1N+3Re\$+";
$lang['failedtorenamethread'] = "f41L3D +0 RENaMe +hrE4D";
$lang['failedtomovethread'] = "f@1l3d +0 mOV3 tHR3Ad T0 SpECif13D F0ld3r";
$lang['failedtoupdatethreadstickystatus'] = "f@1LED TO uPd4+3 ThR3Ad \$+1cKY \$+4TUs";
$lang['failedtoupdatethreadclosedstatus'] = "f4ilED tO upD@TE THrE4D cL0\$ED \$+4+uS";
$lang['failedtoupdatethreadlockstatus'] = "f41LEd to UPd4+3 +HR34D lOCk S+a+U\$";
$lang['failedtodeletepostsbyuser'] = "f4IlED +0 DeL3+3 P0\$TS By S3L3C+ED us3R";
$lang['failedtodeletethread'] = "f4IlED +0 dEL3Te Thr3Ad.";
$lang['failedtoundeletethread'] = "f4IL3D +0 UN-d3L3+3 tHRe@d";

// Folder Options (folder_options.php) ---------------------------------

$lang['folderoptions'] = "fold3R oPT10NS";
$lang['foldercouldnotbefound'] = "the R3QueStED foLDEr CouLD N0T 83 PH0UNd 0R 4CcE5s w4\$ D3N1ed.";
$lang['failedtoupdatefolderinterest'] = "f@1lEd +o UpD4+3 Ph0lD3R inT3R3S+";

// Dictionary (dictionary.php) -----------------------------------------

$lang['dictionary'] = "dIc+i0n@RY";
$lang['spellcheck'] = "sp3LL cH3CK";
$lang['notindictionary'] = "n0T 1N d1c+10n@rY";
$lang['changeto'] = "chaN93 t0";
$lang['restartspellcheck'] = "re\$+@RT";
$lang['cancelchanges'] = "c@NCel cHAnGE\$";
$lang['initialisingdotdotdot'] = "iNI+1@lIS1NG...";
$lang['spellcheckcomplete'] = "sp3LL ChECK 1s cOMpLE+e. to rE\$+@R+ \$PElL CH3Ck CL1cK r3s+4R+ Bu++ON B3LOW.";
$lang['spellcheck'] = "sp3Ll Ch3CK";
$lang['noformobj'] = "no FOrM ObjEcT sPECifIEd FoR re+UrN +3XT";
$lang['bodytext'] = "bOdY +3X+";
$lang['ignore'] = "ign0R3";
$lang['ignoreall'] = "i9noR3 4LL";
$lang['change'] = "cHAngE";
$lang['changeall'] = "ch4n93 ALl";
$lang['add'] = "aDD";
$lang['suggest'] = "sUg93S+";
$lang['nosuggestions'] = "(No \$uGg35+1ON\$)";
$lang['cancel'] = "c@NCEL";
$lang['dictionarynotinstalled'] = "no D1C+10N4RY HAS 83EN iN\$T4LlED. plE453 c0nT@C+ tEH F0RuM OwnER +O REM3Dy ThI\$.";

// Permissions keys ----------------------------------------------------

$lang['postreadingallowed'] = "p05+ RE4DInG @lL0W3D";
$lang['postcreationallowed'] = "p0sT cr3@+10N @LlOWed";
$lang['threadcreationallowed'] = "tHR3@d cR3A+1on 4LLow3D";
$lang['posteditingallowed'] = "p0St 3D1+1N9 ALl0WED";
$lang['postdeletionallowed'] = "p0\$t D3L3TIoN 4LL0w3d";
$lang['attachmentsallowed'] = "a+T4ChMEn+s @lL0W3D";
$lang['htmlpostingallowed'] = "h+mL P0\$+1Ng @ll0W3D";
$lang['signatureallowed'] = "s19n@tUR3 AlL0Wed";
$lang['guestaccessallowed'] = "gu3\$t 4CcE\$s 4LLoWEd";
$lang['postapprovalrequired'] = "p0sT aPPr0V4L rEqUIR3d";

// RSS feeds gubbins

$lang['rssfeed'] = "r5s PH33D";
$lang['every30mins'] = "eV3RY 30 miNU+E5";
$lang['onceanhour'] = "onCE @n H0UR";
$lang['every6hours'] = "eVERy 6 H0UR\$";
$lang['every12hours'] = "ev3RY 12 H0URs";
$lang['onceaday'] = "onC3 4 D4Y";
$lang['onceaweek'] = "oNcE @ WEeK";
$lang['rssfeeds'] = "rS\$ F3eD\$";
$lang['feedname'] = "fE3D n4M3";
$lang['feedfoldername'] = "f3eD fOLD3R n4M3";
$lang['feedlocation'] = "f33d L0C4+1oN";
$lang['threadtitleprefix'] = "thR3AD tI+L3 pR3FIX";
$lang['feednameandlocation'] = "fE3D N4m3 @Nd L0Ca+10N";
$lang['feedsettings'] = "f3eD \$3tTInG\$";
$lang['updatefrequency'] = "upd@+E fREqUEnCY";
$lang['rssclicktoreadarticle'] = "cliCk H3r3 +O r3@D Th1\$ 4RtIcL3";
$lang['addnewfeed'] = "aDD N3w FeED";
$lang['editfeed'] = "eDi+ f3ED";
$lang['feeduseraccount'] = "f3eD USer 4Cc0UNt";
$lang['noexistingfeeds'] = "n0 3x1s+in9 RSs FEeDS f0UNd. To @dD @ PHeEd Cl1CK +Eh '4Dd N3W' 8UT+0n 8EL0W";
$lang['rssfeedhelp'] = "h3Re J00 c@N \$3+UP s0ME rSS FEeDs For @uTOM@Tic PrOP49A+1On iNTO Y0UR FOrUM. Th3 1T3ms fROM T3H RSs Ph3eds j00 add w1Ll Be CR34+3d 4S tHRe4DS wH1CH u5ERS C4N R3PlY +0 @S If +H3Y WErE n0RM4L p0\$ts. +EH RSS fEEd Mu\$+ bE 4Cc3S\$18L3 Vi4 H++P 0r 1+ WIll NoT WorK.";
$lang['mustspecifyrssfeedname'] = "mu\$+ \$PEcIFY rs5 Fe3d n4mE";
$lang['mustspecifyrssfeeduseraccount'] = "mUST sPeCIfy R\$S feED USeR @cC0UNT";
$lang['mustspecifyrssfeedfolder'] = "mUsT \$p3C1FY r\$s FEed pH0LD3R";
$lang['mustspecifyrssfeedurl'] = "mu\$t SpEcIFY r\$S FE3D urL";
$lang['mustspecifyrssfeedupdatefrequency'] = "mU\$+ sPEcIFy RSS Ph3ED upD@t3 FReQUeNCy";
$lang['unknownrssuseraccount'] = "unkNowN rsS us3R 4CC0UNt";
$lang['rssfeedsupportshttpurlsonly'] = "r55 FEeD \$uPPoR+S h+Tp UrLS 0NLy. sEcurE FeeDs (hTTPs://) aR3 n0t SUpP0Rt3D.";
$lang['rssfeedurlformatinvalid'] = "r\$\$ f3ed Url F0RM@t 1\$ iNV4Lid. URl MUSt 1NClUDe SCH3m3 (E.9. hTTP://) 4ND a HOStN@Me (E.g. wWW.HO\$tN4M3.COm).";
$lang['rssfeeduserauthentication'] = "r5\$ FeeD d03\$ nO+ SupPoRT H++P us3R @U+h3n+Ic4T1on";
$lang['successfullyremovedselectedfeeds'] = "sUCc35\$phULlY r3MOveD SeL3CTeD FeED\$";
$lang['successfullyaddedfeed'] = "sucCESSpHUlLy 4DDeD N3W ph3ED";
$lang['successfullyeditedfeed'] = "succ3ssFULly Ed1+Ed Fe3d";
$lang['failedtoremovefeeds'] = "f@1L3D +0 Rem0VE S0ME OR 4LL 0f T3H \$3L3C+3D PH33D\$";
$lang['failedtoaddnewrssfeed'] = "f4ILEd +0 aDd NeW Rs\$ pH3ED";
$lang['failedtoupdaterssfeed'] = "f@1LED +O uPDa+3 Rss Ph33D";
$lang['rssstreamworkingcorrectly'] = "r\$\$ STrE4M aPp3ARS +O b3 WorKiNG c0RREc+Ly";
$lang['rssstreamnotworkingcorrectly'] = "rSS \$+REAm W4\$ 3MPTy 0R cOULd Not B3 f0uND";
$lang['invalidfeedidorfeednotfound'] = "inv4L1D fe3D Id OR PHeED n0T pHOUnD";

// PM Export Options

$lang['pmexportastype'] = "expoRt A\$ +Yp3";
$lang['pmexporthtml'] = "h+mL";
$lang['pmexportxml'] = "xML";
$lang['pmexportplaintext'] = "pL41n +3XT";
$lang['pmexportmessagesas'] = "expor+ MesS4GEs 4\$";
$lang['pmexportonefileforallmessages'] = "oNE pHiL3 pHOr 4LL M3\$S@9E\$";
$lang['pmexportonefilepermessage'] = "on3 fILe P3R ME\$s4gE";
$lang['pmexportattachments'] = "expoRT 4tt4CHmENtS";
$lang['pmexportincludestyle'] = "incLudE forUM \$tYLE sh3E+";
$lang['pmexportwordfilter'] = "aPPLY wORd PhiLT3R TO m3sS49E\$";

// Thread merge / split options

$lang['threadhasbeensplit'] = "thr3AD ha\$ BEEN SpL1+";
$lang['threadhasbeenmerged'] = "tHr3AD h4\$ 83eN MER93D";
$lang['mergesplitthread'] = "mERGe / 5PL1+ +hrE4D";
$lang['mergewiththreadid'] = "m3rGE WITh +HreAD 1D:";
$lang['postsinthisthreadatstart'] = "p0sTS 1N +h1s tHR34d 4T S+4R+";
$lang['postsinthisthreadatend'] = "p0S+S iN th1S +hRE4D a+ eND";
$lang['reorderpostsintodateorder'] = "r3-0RD3r PosTS 1Nto d4+3 ORd3R";
$lang['splitthreadatpost'] = "splIT tHR34D a+ pO5T:";
$lang['selectedpostsandrepliesonly'] = "s3l3C+3D P0\$+ 4ND r3PlIEs 0NLy";
$lang['selectedandallfollowingposts'] = "sEl3C+3D 4nd aLL FOLl0w1NG P0\$t\$";

$lang['threadmovedhere'] = "h3R3";

$lang['thisthreadhasmoved'] = "<b>thR3Ad\$ mERGEd:</b> +His thR34D H4s M0V3D %s";
$lang['thisthreadwasmergedfrom'] = "<b>tHr34DS mEr93D:</b> +hI\$ +HrE4D wA\$ m3R93D PHRom %s";
$lang['somepostsinthisthreadhavebeenmoved'] = "<b>tHr34d SPL1+:</b> \$omE POStS In Th1\$ +hREaD h4V3 83EN MOVed %s";
$lang['somepostsinthisthreadweremovedfrom'] = "<b>thre4D SPLi+:</b> S0M3 p0\$+S In THI\$ +HRe4d WERe MoVED phROM %s";

$lang['thisposthasbeenmoved'] = "<b>thR3@D sPlI+:</b> +h15 P0\$T H@s BE3n MOV3D %s";

$lang['invalidfunctionarguments'] = "iNv@l1D FUncT10N 4r9UMeN+s";
$lang['couldnotretrieveforumdata'] = "c0uLD n0T Re+R1EVe Ph0RUM D4T4";
$lang['cannotmergepolls'] = "oNE 0R M0R3 tHR34Ds Is 4 poll. J00 CaNN0T M3RgE p0Lls";
$lang['couldnotretrievethreaddatamerge'] = "c0uLD N0+ rE+RIeVE tHr34D d4T@ fR0M ON3 oR m0R3 ThrE4DS";
$lang['couldnotretrievethreaddatasplit'] = "cOulD nOT RE+rI3VE +Hr34D d4Ta PhROm \$0UrCE THR3@D";
$lang['couldnotretrievepostdatamerge'] = "c0ULD NOt r3+RIeVE p0\$T D@t4 from 0NE 0R m0Re tHr34D\$";
$lang['couldnotretrievepostdatasplit'] = "coULD N0+ R3+r13V3 P0\$t D@+4 PHROm S0uRC3 THRE4D";
$lang['failedtocreatenewthreadformerge'] = "f@1l3D +0 CR3@Te N3W +hrE4D f0R mErgE";
$lang['failedtocreatenewthreadforsplit'] = "f4iL3D +0 Cr3aTe N3W THr3ad F0R SPl1t";
$lang['nopermissiontomergethreads'] = "j00 4RE no+ P3RMi+T3D t0 m3R93 tH3 S3L3c+3D tHr3AD\$";

// Thread subscriptions

$lang['threadsubscriptions'] = "tHR3Ad \$UbscR1P+10NS";
$lang['couldnotupdateinterestonthread'] = "cOuLD NOt UpD4T3 In+erE\$t 0N +HrEaD '%s'";
$lang['threadinterestsupdatedsuccessfully'] = "thrEAd In+3RESTs UPd@TEd \$UCcESsPHUlLY";
$lang['nothreadsubscriptions'] = "j00 4Re NOT SUb5CRi8ED +0 4Ny THrE4DS.";
$lang['nothreadsignored'] = "j00 4rE n0T 19NORiNg 4NY tHrE4DS.";
$lang['nothreadsonhighinterest'] = "j00 H4V3 N0 HI9H IN+3rE\$T tHR34DS.";
$lang['resetselected'] = "r3S3+ \$3LECt3D";
$lang['ignoredthreads'] = "iGN0R3d thR34DS";
$lang['highinterestthreads'] = "h19h IN+3rest THr34DS";
$lang['subscribedthreads'] = "su8SCr18ed ThR3@DS";
$lang['currentinterest'] = "cuRR3N+ IN+3RE\$+";

// Folder subscriptions

$lang['foldersubscriptions'] = "f0lD3R SubScR1PTIon\$";
$lang['couldnotupdateinterestonfolder'] = "coulD NO+ uPD4Te InT3RE\$T 0N PHolD3R '%s'";
$lang['folderinterestsupdatedsuccessfully'] = "fOlDER 1n+3RESTs UpD@t3d SUcCES\$fuLLy";
$lang['nofoldersubscriptions'] = "j00 4RE nO+ Su8scRiBEd T0 aNy Ph0LDeR\$.";
$lang['nofoldersignored'] = "j00 aRe N0T 19NORiN9 @NY phOLdeR\$.";
$lang['resetselected'] = "rEsE+ \$3L3cteD";
$lang['ignoredfolders'] = "igNoR3D f0ld3RS";
$lang['subscribedfolders'] = "sU8\$cRIbeD PhOlDERs";

// Browseable user profiles

$lang['youcanonlyaddthreecolumns'] = "j00 C4N 0nLY 4DD 3 C0LumN\$. t0 4DD @ n3W coLUMn cL0S3 @n 3x1sTiN9 0N3";
$lang['columnalreadyadded'] = "j00 H4V3 4lRE4Dy @dD3D +H1S cOLUMn. 1F j00 wAN+ +0 R3MoV3 1T CL1cK 1T\$ Clo5E buTtoN";

?>