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

/* $Id: x-hacker.inc.php,v 1.286 2008-07-06 18:27:00 decoyduck Exp $ */

// British English language file

// Language character set and text direction options -------------------

$lang['_isocode'] = "en-gb";
$lang['_textdir'] = "ltr";

// Months --------------------------------------------------------------

$lang['month'][1]  = "j4nU@rY";
$lang['month'][2]  = "fE8RU4RY";
$lang['month'][3]  = "m@RCH";
$lang['month'][4]  = "aPRIL";
$lang['month'][5]  = "m@y";
$lang['month'][6]  = "juN3";
$lang['month'][7]  = "jULY";
$lang['month'][8]  = "aUGUSt";
$lang['month'][9]  = "sEp+3MB3R";
$lang['month'][10] = "oC+o8ER";
$lang['month'][11] = "n0veM8ER";
$lang['month'][12] = "d3C3Mb3r";

$lang['month_short'][1]  = "j4n";
$lang['month_short'][2]  = "f3b";
$lang['month_short'][3]  = "m@R";
$lang['month_short'][4]  = "apR";
$lang['month_short'][5]  = "m4y";
$lang['month_short'][6]  = "jUN";
$lang['month_short'][7]  = "jUl";
$lang['month_short'][8]  = "aug";
$lang['month_short'][9]  = "s3p";
$lang['month_short'][10] = "oc+";
$lang['month_short'][11] = "nOv";
$lang['month_short'][12] = "dEC";

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

$lang['date_periods']['year']   = "%s Y34R";
$lang['date_periods']['month']  = "%s m0N+H";
$lang['date_periods']['week']   = "%s WE3k";
$lang['date_periods']['day']    = "%s dAY";
$lang['date_periods']['hour']   = "%s hoUR";
$lang['date_periods']['minute'] = "%s m1nU+3";
$lang['date_periods']['second'] = "%s s3cONd";

// As above but plurals (2 years vs. 1 year, etc.)

$lang['date_periods_plural']['year']   = "%s ye4R\$";
$lang['date_periods_plural']['month']  = "%s m0nTH\$";
$lang['date_periods_plural']['week']   = "%s wE3K5";
$lang['date_periods_plural']['day']    = "%s D@Ys";
$lang['date_periods_plural']['hour']   = "%s houRS";
$lang['date_periods_plural']['minute'] = "%s M1NUte\$";
$lang['date_periods_plural']['second'] = "%s 53C0Nds";

// Short hand periods (example: 1y, 2m, 3w, 4d, 5hr, 6min, 7sec)

$lang['date_periods_short']['year']   = "%sY";    // 1y
$lang['date_periods_short']['month']  = "%sm";    // 2m
$lang['date_periods_short']['week']   = "%sw";    // 3w
$lang['date_periods_short']['day']    = "%sd";    // 4d
$lang['date_periods_short']['hour']   = "%sHr";   // 5hr
$lang['date_periods_short']['minute'] = "%sm1n";  // 6min
$lang['date_periods_short']['second'] = "%s\$eC";  // 7sec

// Common words --------------------------------------------------------

$lang['percent'] = "peRCEN+";
$lang['average'] = "av3r49E";
$lang['approve'] = "appr0Ve";
$lang['banned'] = "bAnnED";
$lang['locked'] = "l0CkED";
$lang['add'] = "add";
$lang['advanced'] = "aDV4NCED";
$lang['active'] = "aC+1VE";
$lang['style'] = "s+yL3";
$lang['go'] = "go";
$lang['folder'] = "f0Ld3r";
$lang['ignoredfolder'] = "iGNOr3d PH0lD3R";
$lang['folders'] = "f0LDER5";
$lang['thread'] = "thre4D";
$lang['threads'] = "thr3aD\$";
$lang['threadlist'] = "thre4D Li\$t";
$lang['message'] = "m3\$54GE";
$lang['from'] = "frOM";
$lang['to'] = "t0";
$lang['all_caps'] = "aLL";
$lang['of'] = "oF";
$lang['reply'] = "rEplY";
$lang['forward'] = "f0rWARd";
$lang['replyall'] = "rePLY TO 4LL";
$lang['quickreply'] = "qu1CK R3Ply";
$lang['quickreplyall'] = "qUiCk REpLY TO 4LL";
$lang['pm_reply'] = "r3plY a\$ pM";
$lang['delete'] = "dEL3T3";
$lang['deleted'] = "d3l3TEd";
$lang['edit'] = "eD1+";
$lang['privileges'] = "pRIvIL39E\$";
$lang['ignore'] = "i9noR3";
$lang['normal'] = "norm4L";
$lang['interested'] = "iNtER3sT3D";
$lang['subscribe'] = "sub\$cRI8E";
$lang['apply'] = "aPpLY";
$lang['download'] = "d0wNl04D";
$lang['save'] = "sAVE";
$lang['update'] = "uPd@T3";
$lang['cancel'] = "c4nC3L";
$lang['continue'] = "c0nTInU3";
$lang['attachment'] = "at+@CHmEN+";
$lang['attachments'] = "a+t4CHMEn+S";
$lang['imageattachments'] = "im@93 4+t@CHm3NTs";
$lang['filename'] = "fILEN@mE";
$lang['dimensions'] = "d1mEN\$I0N5";
$lang['downloadedxtimes'] = "dOwNlo@dED: %d +1ME\$";
$lang['downloadedonetime'] = "downl04d3D: 1 +1m3";
$lang['size'] = "siZE";
$lang['viewmessage'] = "v13w M3ss49e";
$lang['deletethumbnails'] = "deleT3 ThUm8n@1LS";
$lang['logon'] = "lO90N";
$lang['more'] = "m0rE";
$lang['recentvisitors'] = "rECENt V1SI+Ors";
$lang['username'] = "u\$eRnAM3";
$lang['clear'] = "cL34r";
$lang['reset'] = "r353+";
$lang['action'] = "aC+1oN";
$lang['unknown'] = "unkNOWN";
$lang['none'] = "nOn3";
$lang['preview'] = "pRevIEw";
$lang['post'] = "poS+";
$lang['posts'] = "p0sT\$";
$lang['change'] = "cH4NGe";
$lang['yes'] = "y35";
$lang['no'] = "n0";
$lang['signature'] = "si9nA+Ur3";
$lang['signaturepreview'] = "sigN4TUr3 Pr3VIeW";
$lang['signatureupdated'] = "s19n4+uR3 UPDATEd";
$lang['signatureupdatedforallforums'] = "sigNA+UR3 UpD@t3d F0R 4lL FORuM\$";
$lang['back'] = "b4CK";
$lang['subject'] = "sUBjEC+";
$lang['close'] = "cLos3";
$lang['name'] = "n@M3";
$lang['description'] = "dE\$CR1PtI0N";
$lang['date'] = "d@tE";
$lang['view'] = "v13W";
$lang['enterpasswd'] = "entEr PASswORD";
$lang['passwd'] = "p4ssW0Rd";
$lang['ignored'] = "iGn0R3D";
$lang['guest'] = "gUE\$t";
$lang['next'] = "n3x+";
$lang['prev'] = "preVI0US";
$lang['others'] = "o+heR\$";
$lang['nickname'] = "nIcKnAME";
$lang['emailaddress'] = "eM41L ADDres5";
$lang['confirm'] = "c0NPhIRm";
$lang['email'] = "em41L";
$lang['poll'] = "p0lL";
$lang['friend'] = "fRiENd";
$lang['success'] = "succ3\$S";
$lang['error'] = "err0R";
$lang['warning'] = "w4rNIng";
$lang['guesterror'] = "sORRY, j00 NEEd TO 83 LoGGEd 1N +0 uSE th1S pH34TURe.";
$lang['loginnow'] = "lO91N noW";
$lang['unread'] = "unREAD";
$lang['all'] = "aLL";
$lang['allcaps'] = "aLl";
$lang['permissions'] = "p3rm1\$SIOn\$";
$lang['type'] = "type";
$lang['print'] = "pRINt";
$lang['sticky'] = "s+1CKy";
$lang['polls'] = "pOlLS";
$lang['user'] = "us3R";
$lang['enabled'] = "en4BL3d";
$lang['disabled'] = "dis4BLEd";
$lang['options'] = "opt10n\$";
$lang['emoticons'] = "eM0tIcoN\$";
$lang['webtag'] = "w3b+4G";
$lang['makedefault'] = "m4K3 dEpH@ul+";
$lang['unsetdefault'] = "uN\$3t D3FAUL+";
$lang['rename'] = "rENAmE";
$lang['pages'] = "p4gEs";
$lang['used'] = "u\$ED";
$lang['days'] = "d4yS";
$lang['usage'] = "u\$4ge";
$lang['show'] = "sHoW";
$lang['hint'] = "h1n+";
$lang['new'] = "n3w";
$lang['referer'] = "rEfER3R";
$lang['thefollowingerrorswereencountered'] = "teh PHoLL0W1N9 ErrORs WeR3 Enc0UN+3rED:";

// Admin interface (admin*.php) ----------------------------------------

$lang['admintools'] = "aDM1N +00lS";
$lang['forummanagement'] = "f0ruM m@N4G3MEn+";
$lang['accessdeniedexp'] = "j00 DO n0+ h@VE p3RMi\$S1oN t0 US3 ThI\$ SEc+10N.";
$lang['managefolders'] = "m4n4gE F0lDEr5";
$lang['manageforums'] = "m4n493 PhoRUms";
$lang['manageforumpermissions'] = "m@N@GE pHoRuM P3RMIssI0N\$";
$lang['foldername'] = "fOLD3R N4ME";
$lang['move'] = "mOV3";
$lang['closed'] = "cl0s3D";
$lang['open'] = "open";
$lang['restricted'] = "r3\$+RicTEd";
$lang['forumiscurrentlyclosed'] = "%s is CURr3nTlY cLOSed";
$lang['youdonothaveaccesstoforum'] = "j00 D0 n0t HaVE 4CC3SS to %s";
$lang['toapplyforaccessplease'] = "to @PPly F0R 4Cc3\$S PL3@s3 c0nT4C+ THE %s.";
$lang['forumowner'] = "f0Rum OWnER";
$lang['adminforumclosedtip'] = "iF J00 w4NT +0 chAnG3 S0M3 53+t1N9\$ 0N y0uR F0RuM clICk +h3 4DMIn l1NK 1n thE N4V1G4+ioN 8@r 480VE.";
$lang['newfolder'] = "n3w F0LD3R";
$lang['nofoldersfound'] = "n0 3X1\$Tin9 F0LD3R\$ f0uND. +0 ADD A pH0Ld3R ClICk T3H '@DD N3W' 8U+ToN 8el0W.";
$lang['forumadmin'] = "fORum @DMiN";
$lang['adminexp_1'] = "u5E th3 MENU 0N +H3 LeF+ +0 M@Nag3 thiNg\$ In YOUr FOrUM.";
$lang['adminexp_2'] = "<b>uSERS</b> 4LLOWS j00 TO SE+ 1NDivIDU4L US3R P3rmI\$si0NS, iNClUDInG 4PPOINtING MODeR@T0RS anD g@GgINg P30PLE.";
$lang['adminexp_3'] = "<b>u\$3R 9R0UPS</b> 4lLOw\$ J00 +0 Cre4T3 Us3R gRoUPS +0 @ssI9N p3rmisSioN\$ +0 @s m4nY or 4S fEW uS3rS QuICKly 4ND EA\$1lY.";
$lang['adminexp_4'] = "<b>b4N COn+R0L\$</b> AlL0W\$ +EH 8@NniN9 4Nd Un-B4Nn1NG of 1P 4ddrESS3s, h++P rePh3R3R\$, UseRn@M3S, 3mAIl @Ddr3S\$ES 4ND n1CKN4Me\$.";
$lang['adminexp_5'] = "<b>f0LD3R5</b> 4lLOw\$ +h3 CR3A+1on, mODIfIC@t10n @ND d3LETi0n 0F fOLdERS.";
$lang['adminexp_6'] = "<b>r5s FEedS</b> @lLOWS j00 T0 M@N493 RSs FE3DS f0R pROP49@Ti0n 1N+0 Y0UR pHORum.";
$lang['adminexp_7'] = "<b>pR0PHilES</b> lE+s J00 cUS+0Mi\$E THE 1+3M\$ Tha+ APpEAR In thE usEr ProF1L3\$.";
$lang['adminexp_8'] = "<b>f0ruM \$3T+1NG\$</b> @lloWS J00 T0 Cu\$+0m1se Y0UR f0ruM'S n4m3, 4ppE4RaNCe 4ND M4nY oTHEr tH1N9s.";
$lang['adminexp_9'] = "<b>st@RT p49e</b> L3+s J00 Cu\$TOmIS3 YOur Ph0rUM'S \$t@R+ p493.";
$lang['adminexp_10'] = "<b>f0ruM \$tYLE</b> 4Ll0W\$ j00 +o 93N3R4T3 r@ND0M \$tyLE\$ FOr YOUr FOrUM MEm8eR\$ +o USe.";
$lang['adminexp_11'] = "<b>wOrD f1LT3R</b> @lLOws J00 to pH1L+3R w0RD\$ J00 DoN't W4NT +O 8e U\$3d ON yOur FOrUM.";
$lang['adminexp_12'] = "<b>p0sTING sTa+s</b> 9EN3R@TE5 4 rEPOrT Li\$tIng +h3 +0P 10 pO5TERs 1n 4 DEph1N3D pERI0D.";
$lang['adminexp_13'] = "<b>f0RuM l1NKS</b> l3+S J00 MAn493 +3H L1Nk5 DR0pd0Wn In +h3 N4V1ga+ion 84R.";
$lang['adminexp_14'] = "<b>vIEW l0g</b> LIsT5 R3C3nt @CT10NS 8Y +EH f0rUM MOd3R@+0RS.";
$lang['adminexp_15'] = "<b>m4N4g3 PhoRUM5</b> L3tS j00 Cr3@T3 4Nd DEl3+3 4Nd cL0SE or r3oP3N F0RUM\$.";
$lang['adminexp_16'] = "<b>gl0B4L PH0RuM sEttINg5</b> ALl0WS j00 TO mOdIFy S3++1NgS Wh1CH aFPh3C+ aLL Ph0RUMs.";
$lang['adminexp_17'] = "<b>po\$T AppROVaL quEUE</b> 4LL0W\$ J00 T0 vIEW ANY p0\$+s 4W4I+1Ng @PprOv@l By @ m0DER@+Or.";
$lang['adminexp_18'] = "<b>vis1t0R LO9</b> 4lLOWs j00 TO V1EW 4n 3X+3ND3d LISt OF VI\$i+0rS iNCLuDing +hEIr htTp R3pH3REr5.";
$lang['createforumstyle'] = "cR34TE @ PHorUM \$+Yle";
$lang['newstylesuccessfullycreated'] = "n3W 5+Yl3 SUCc3ssPHUlLY Cr34TeD.";
$lang['stylealreadyexists'] = "a 5+YlE wI+H tH4+ f1l3N@M3 4LRE4dy 3xiST\$.";
$lang['stylenofilename'] = "j00 D1d N0T 3nT3R @ PhiL3Nam3 T0 S@vE The \$+yLe W1TH.";
$lang['stylenodatasubmitted'] = "couLd N0t ReAD f0RUm STYlE D4T@.";
$lang['styleexp'] = "us3 ThI\$ p@Ge To heLP crE4TE 4 R4NDoMLy 93N3R@TEd \$tYLe F0R YOUR F0RUM.";
$lang['stylecontrols'] = "con+r0LS";
$lang['stylecolourexp'] = "cliCK ON @ cOLOur +0 M@K3 4 n3W \$+yl3 \$h33T 8A\$Ed 0N +H4+ COlouR. CuRRenT B4s3 Col0UR 1S ph1R\$+ in l1\$+.";
$lang['standardstyle'] = "staNDard S+Yl3";
$lang['rotelementstyle'] = "r0+@TED 3lEM3NT 5+YLe";
$lang['randstyle'] = "r@ndOM 5+YlE";
$lang['thiscolour'] = "tH1S COLOUr";
$lang['enterhexcolour'] = "oR 3N+3R @ H3X COloUr TO 84S3 4 new \$+Yl3 \$h33+ 0N";
$lang['savestyle'] = "s4VE +h1s stYL3";
$lang['styledesc'] = "sTYL3 d3sCriP+1oN";
$lang['stylefilenamemayonlycontain'] = "styl3 fIlEn@Me M@Y 0NLy COn+Ain L0W3Rca\$3 l3++3RS (4-z), numBER\$ (0-9) 4ND UND3RSC0R3.";
$lang['stylepreview'] = "sTYLE pREv1ew";
$lang['welcome'] = "wElC0Me";
$lang['messagepreview'] = "m3SS4ge PReV1EW";
$lang['users'] = "uSeRS";
$lang['usergroups'] = "u\$eR 9r0UpS";
$lang['mustentergroupname'] = "j00 MUSt 3N+3R @ 9ROup N4Me";
$lang['profiles'] = "pr0F1L3S";
$lang['manageforums'] = "m4n4G3 FOrUms";
$lang['forumsettings'] = "f0RUM s3++1Ngs";
$lang['globalforumsettings'] = "gLO84L pH0RUm \$3++1nGS";
$lang['settingsaffectallforumswarning'] = "<b>nO+e:</b> THe\$3 s3++1NG5 4FF3CT @LL PH0RUMS. wh3RE tH3 \$3T+InG I\$ DUpLiC@+3d 0N +H3 INDiVidU4L Ph0rUM's SE+T1NGS p49E +h4+ WilL TAK3 pR3cEDeNCE oVER tH3 \$3TTiNG\$ J00 Ch@NgE H3RE.";
$lang['startpage'] = "staRt P4GE";
$lang['startpageerror'] = "youR 5T@r+ P@gE c0UlD n0+ b3 s4V3D L0CAlLY +o TH3 sERv3R 8EcaUS3 P3rmisSIOn W4\$ dENiEd.</p><p>t0 cH@nG3 yOUr STaRt P49e PLe4\$3 cL1CK th3 doWNl04D bU++ON 8eL0W Wh1CH WILL PrOMpt J00 +O S@vE +hE F1LE T0 yOur H4rD dRIve. J00 cAn ThEN UPloAd +hIS fIlE tO y0Ur SErV3R 1nTO TH3 phOlLOW1nG f0lD3R, IF n3C3SSaRY CRE4+1N9 +3H ph0lD3R S+rUc+UR3 1n T3H Pr0C35s.</p><p><b>%s</b></p><p>pLEA\$3 NO+E +h4+ s0mE bRoWS3RS M4Y cH4Ng3 t3H n4M3 OpH +H3 pH1Le UP0N d0WNL04d. wHEn Upl0@DiNg +h3 PH1l3 PlE4S3 m4K3 \$uRE th4t 1T 1\$ N4m3d ST@rt_M41n.Php 0+H3RW1SE YOUR ST4rT p493 W1lL 4pPEar UNCH4NG3d.";
$lang['failedtoopenmasterstylesheet'] = "y0uR FORUM S+YL3 CouLD N0T 83 S@vED 8EC@Us3 T3H m4S+3R s+YL3 \$H33+ C0ULd N0+ be Lo4D3D. TO SAve yoUr S+yl3 +hE m4STeR S+yLe \$H33t (M@kE_StYLe.cs\$) MUS+ BE LOcA+3D iN Th3 S+yl3s dIR3C+0rY OF yoUR 8EEh1VE FORuM in\$T@LL4+10N.";
$lang['makestyleerror'] = "yOur ph0rUM stYL3 couLD N0t 8E S4VEd LOC4Lly TO T3H \$3RV3r b3C@us3 P3RM1\$s1ON wAs D3nIeD.</p><p>to S@VE y0uR ph0RuM s+YL3 pleASE cLICk Th3 D0WNLO@d 8U+T0N 83lOW wHIch W1Ll pR0MPt J00 +O savE +3h PHIL3 to Y0UR h4rd DR1VE. J00 C4N +H3N UPl04d +H1S PhiL3 TO y0UR S3RveR 1N+0 th3 f0LL0W1NG FOLd3R, 1F n3CES\$4rY CR34tINg THe PHOLDer STRuC+urE In +3h PROc3\$s.</p><p><b>%s</b></p><p>pl3a\$3 NO+E th@T Some 8ROW\$3rS M@y cH4N9E TH3 N4M3 0PH teh F1Le uP0N D0WNl0@d. wh3N UpLO4d1nG +HE pHiLE PLE4S3 M4k3 surE TH4+ 1T 1\$ N4m3d \$TYLE.c\$5 o+h3rw1\$e t3H ph0RUm 5+yLE W1LL B3 un4V@1l48le.";
$lang['forumstyle'] = "foRUm STYLe";
$lang['wordfilter'] = "word phIl+3R";
$lang['forumlinks'] = "f0rUM L1Nks";
$lang['viewlog'] = "v1EW LOG";
$lang['noprofilesectionspecified'] = "nO Pr0f1L3 S3CT10N sPEc1PHI3d.";
$lang['itemname'] = "i+3M naM3";
$lang['moveto'] = "mOVE tO";
$lang['manageprofilesections'] = "manAgE Pr0fIL3 \$3Ct10N\$";
$lang['sectionname'] = "sec+10n n4M3";
$lang['items'] = "i+3ms";
$lang['mustspecifyaprofilesectionid'] = "mUs+ 5PecIfY @ PR0pHiL3 S3C+10N ID";
$lang['mustsepecifyaprofilesectionname'] = "mu\$+ spECiFY A prOFILe \$eC+I0N n4M3";
$lang['noprofilesectionsfound'] = "n0 EXI\$+1NG pr0Ph1LE s3CTioNS phOUNd. +0 @DD A Pr0PHIl3 \$ec+10N cliCK t3H '4dd n3W' 8U++0N bELOw.";
$lang['addnewprofilesection'] = "aDD n3w pR0FIlE S3ctION";
$lang['successfullyaddedprofilesection'] = "sucCE\$sphulLY @dDEd PR0FIl3 \$3CT10N";
$lang['successfullyeditedprofilesection'] = "sucC3SsPhULLy Edi+Ed ProFil3 SEctiON";
$lang['addnewprofilesection'] = "add N3W pR0F1L3 S3C+1oN";
$lang['mustsepecifyaprofilesectionname'] = "mus+ SpECifY @ PrOF1lE seC+10N n4mE";
$lang['successfullyremovedselectedprofilesections'] = "sUcC3ssFuLLy Rem0VED sEL3CT3d pR0FIl3 SECT10NS";
$lang['failedtoremoveprofilesections'] = "f@1LED t0 ReM0V3 Pr0FIl3 \$3CTi0nS";
$lang['viewitems'] = "vIEW ITem\$";
$lang['successfullyaddednewprofileitem'] = "sUcC3sSPHulLY 4DD3D NEw Pr0fiL3 I+eM";
$lang['successfullyeditedprofileitem'] = "sUCc3\$SPhuLly eD1t3D PR0fIl3 IT3M";
$lang['successfullyremovedselectedprofileitems'] = "sUCC3\$SfuLLY R3MOv3d \$3lEcTeD proF1L3 i+EMs";
$lang['failedtoremoveprofileitems'] = "f@1lED to REMoV3 pr0PHiL3 I+3MS";
$lang['noexistingprofileitemsfound'] = "theRE @r3 NO 3xIStiN9 pROFIL3 1tEMS in ThI\$ \$3cTI0N. t0 @Dd AN i+3M cL1CK T3h '@DD neW' 8U+TON 8ELOW.";
$lang['edititem'] = "edI+ I+EM";
$lang['invalidprofilesectionid'] = "inv@L1D PrOFIL3 SEct1oN 1D oR \$3cTIOn NOt PhoUND";
$lang['invalidprofileitemid'] = "inv4l1d pRoF1L3 I+3M iD Or 1t3M nOt PH0und";
$lang['addnewitem'] = "add N3w 1+3M";
$lang['youmustenteraprofileitemname'] = "j00 mu5+ enTER @ Pr0PhIL3 iteM n4m3";
$lang['invalidprofileitemtype'] = "inv4LID prOFIL3 i+em TyP3 seL3C+3D";
$lang['youmustenteroptionsforselectedprofileitemtype'] = "j00 MU\$t 3NTeR soMe 0Pt1oN\$ PhOR \$3lEC+3D pR0FIl3 I+3M TyPe";
$lang['youmustentermorethanoneoptionforitem'] = "j00 MUS+ Ent3R m0Re +h@N 0NE Op+10N pH0R \$eLECtED pR0PH1Le I+eM tYPe";
$lang['profileitemhyperlinkssupportshttpurlsonly'] = "prOPH1Le I+EM hYp3rL1nK\$ sUPp0R+ hTTp URL\$ ONLY";
$lang['profileitemhyperlinkformatinvalid'] = "pr0f1LE 1+3m HypErL1NK fORM@t 1NV4lID";
$lang['youmustincludeprofileentryinhyperlinks'] = "j00 mUS+ 1NCLudE <i>%s</i> 1n +H3 uRL oPH cL1CK@Bl3 HyP3Rl1nK5";
$lang['failedtocreatenewprofileitem'] = "f41lEd TO CreA+E n3w pRof1L3 1T3M";
$lang['failedtoupdateprofileitem'] = "f@1led +O UPD4+3 PrOPhIL3 I+EM";
$lang['startpageupdated'] = "s+4R+ P@gE UPdaTed. %s";
$lang['viewupdatedstartpage'] = "vI3w UPd4+3D \$+@RT p49E";
$lang['editstartpage'] = "eDIT St4r+ P@GE";
$lang['nouserspecified'] = "n0 US3R sPEc1pHiED.";
$lang['manageuser'] = "m4naG3 US3R";
$lang['manageusers'] = "m@n4G3 USErs";
$lang['userstatusforforum'] = "uSeR sT4+U\$ FOR %s";
$lang['userdetails'] = "uSER d3+4ILS";
$lang['edituserdetails'] = "eDiT US3R dE+Ails";
$lang['warning_caps'] = "w4rN1Ng";
$lang['userdeleteallpostswarning'] = "aRe J00 SUrE J00 w4Nt +O D3L3T3 4Ll 0PH Th3 S3LECtED uS3R'\$ P0STS? oNC3 teH P0\$+S 4rE d3L3T3D +H3y C4NNO+ BE R3+RI3VeD 4ND w1Ll 8E Lo\$+ PhoREvER.";
$lang['postssuccessfullydeleted'] = "p05+S WerE SUCC3sSFULlY d3l3+3D.";
$lang['folderaccess'] = "f0Ld3r ACc3\$s";
$lang['possiblealiases'] = "po\$s18l3 @l14S3\$";
$lang['userhistory'] = "usEr HI5+0RY";
$lang['nohistory'] = "nO Hi5+ORy reCord\$ S4V3D";
$lang['userhistorychanges'] = "cHaN9Es";
$lang['clearuserhistory'] = "cl3@R u53R h1sTOry";
$lang['changedlogonfromto'] = "ch4NGeD loG0N PhR0M %s +0 %s";
$lang['changednicknamefromto'] = "cH4nGED NICknAME fROM %s +0 %s";
$lang['changedemailfromto'] = "ch@nGEd 3m4IL PHr0m %s +0 %s";
$lang['successfullycleareduserhistory'] = "sUcCEs\$PHULlY cLe4r3D us3R h1\$TORy";
$lang['failedtoclearuserhistory'] = "f@ILeD to cLE4R uSEr HIstoRY";
$lang['successfullychangedpassword'] = "sucC3\$SFULlY CHan9ED p4sSWOrD";
$lang['failedtochangepasswd'] = "f4iLED +0 CHangE pASSW0Rd";
$lang['approveuser'] = "apprOvE us3R";
$lang['viewuserhistory'] = "v13W u\$3R HI\$+0rY";
$lang['viewuseraliases'] = "vieW uS3R aLI4\$3S";
$lang['searchreturnednoresults'] = "s3aRCH r3TUrNED no R3SULts";
$lang['deleteposts'] = "d3L3TE p0sTS";
$lang['deleteuser'] = "d3l3+3 US3R";
$lang['alsodeleteusercontent'] = "al\$o d3Le+3 4Ll Of +H3 c0N+eN+ Cr34+3D bY tHIs U\$ER";
$lang['userdeletewarning'] = "aRe J00 SUr3 J00 W4n+ +0 Del3TE T3H S3L3C+3D uSER 4CcoUn+? oNce +H3 4CCOUNT h4\$ be3N DelEt3d I+ C@nn0t 83 r3+r13V3D 4nd W1LL 83 L0\$+ PhorEveR.";
$lang['usersuccessfullydeleted'] = "uS3R SUCc3sSPhULly d3lE+3D";
$lang['failedtodeleteuser'] = "f@1LEd +0 d3l3+3 UseR";
$lang['forgottenpassworddesc'] = "iph Th1\$ Us3r h@\$ f0R90++3n thEIr P@5sW0rD J00 C4N R3s3+ I+ F0r +h3M heR3.";
$lang['failedtoupdateuserstatus'] = "f@1LeD TO uPd4TE u5Er ST4+U\$";
$lang['failedtoupdateglobaluserpermissions'] = "f41lED t0 Upd@TE glo8AL u\$3r p3Rmi\$S1ON\$";
$lang['failedtoupdatefolderaccesssettings'] = "fA1lED TO UPd4+3 fOlD3R 4CCesS SE++ING\$";
$lang['manageusersexp'] = "tH15 l1ST sHowS @ S3L3Cti0n 0F Us3rS wHO h@VE l099ED On +0 yoUR FORUm, Sor+3D 8y %s. t0 4L+3R @ Us3r'S P3rm1SSI0n5 CLiCK +H31R n4m3.";
$lang['userfilter'] = "uSer F1L+3r";
$lang['onlineusers'] = "oNL1N3 US3RS";
$lang['offlineusers'] = "ofFLInE us3R\$";
$lang['usersawaitingapproval'] = "userS 4W@iTiNG 4PPR0v@L";
$lang['bannedusers'] = "b4nN3D us3RS";
$lang['lastlogon'] = "l4s+ l0gON";
$lang['sessionreferer'] = "sEsS1ON R3Ph3R3r";
$lang['signupreferer'] = "s19N-up R3PH3r3r:";
$lang['nouseraccountsmatchingfilter'] = "nO US3R @CC0UNts MatChINg PHIl+3R";
$lang['searchforusernotinlist'] = "se@rCh PHOr A us3R No+ In L15+";
$lang['adminaccesslog'] = "aDmIn 4CCess loG";
$lang['adminlogexp'] = "tHIS L15+ \$HOWs +3H l@sT 4C+1ON\$ \$@Nc+10N3D By USeR\$ wI+h 4DM1N PRivIlEGE\$.";
$lang['datetime'] = "d4+3/TIme";
$lang['unknownuser'] = "unkNOwN Us3r";
$lang['unknownuseraccount'] = "unkN0WN u\$3R ACcoUnT";
$lang['unknownfolder'] = "uNKN0wn fOLD3R";
$lang['ip'] = "iP";
$lang['lastipaddress'] = "l4s+ Ip @dDRE\$s";
$lang['hostname'] = "hOsTN4M3";
$lang['unknownhostname'] = "unkNOwN h0\$+N@mE";
$lang['logged'] = "l09G3D";
$lang['notlogged'] = "no+ l099eD";
$lang['addwordfilter'] = "aDD W0RD f1L+3R";
$lang['addnewwordfilter'] = "add nEW woRd Ph1l+3R";
$lang['wordfilterupdated'] = "wORD phil+eR Upd4+3D";
$lang['wordfilterisfull'] = "j00 C4NNO+ 4dD 4NY m0r3 W0RD Ph1lTER5. r3M0vE \$Om3 uNUSED oN3s OR 3D1+ +H3 ex1\$T1NG 0NE\$ F1RSt.";
$lang['filtername'] = "f1LTER n@ME";
$lang['filtertype'] = "fIL+ER +Ype";
$lang['filterenabled'] = "fil+3R 3N4BLEd";
$lang['editwordfilter'] = "edi+ w0RD Fil+3R";
$lang['nowordfilterentriesfound'] = "n0 EX1sT1NG WORD F1L+3R 3n+R1ES pH0UnD. T0 4DD 4 F1L+eR clICk tEH '@DD N3w' bUT+ON 8EL0W.";
$lang['mustspecifyfiltername'] = "j00 Mu\$T SPeCIFy A fILtER nAme";
$lang['mustspecifymatchedtext'] = "j00 Mus+ \$P3C1PHy M@tCH3D +3X+";
$lang['mustspecifyfilteroption'] = "j00 mu\$+ sPEcIFY @ PhILtER op+10N";
$lang['mustspecifyfilterid'] = "j00 MUS+ sPeCIfy a fiLt3r 1D";
$lang['invalidfilterid'] = "inv4l1D fILt3r 1D";
$lang['failedtoupdatewordfilter'] = "f4ILEd T0 UPD4Te Word F1LTeR. checK Th@t t3h Ph1LTeR \$+IlL 3X1sTs.";
$lang['allow'] = "allOW";
$lang['block'] = "bl0CK";
$lang['normalthreadsonly'] = "nORMaL +HrE@ds 0nlY";
$lang['pollthreadsonly'] = "p0lL +hRE@DS ONlY";
$lang['both'] = "b0+h tHR3@D +Yp3S";
$lang['existingpermissions'] = "eXi\$+1n9 p3RM1SSi0n\$";
$lang['nousershavebeengrantedpermission'] = "n0 3x15+1N9 Us3r\$ peRM15s1ON\$ Ph0UnD. +O 9R4nt P3rm1\$sION +0 U5ErS \$34rCH Ph0R tHEm Bel0w.";
$lang['successfullyaddedpermissionsforselectedusers'] = "succES5FULLy 4Dd3d P3RmiS51ONS f0R \$ELeCTEd US3Rs";
$lang['successfullyremovedpermissionsfromselectedusers'] = "suCCE\$SphULLy R3MOVEd PerMIS\$1oN\$ pHR0M s3LecT3D U\$3RS";
$lang['failedtoaddpermissionsforuser'] = "f@1LEd tO 4Dd PERm1s51ONS pHOR u\$ER '%s'";
$lang['failedtoremovepermissionsfromuser'] = "f@1LED TO r3m0vE p3RM1\$s1oN\$ pHR0M uS3R '%s'";
$lang['searchforuser'] = "sE4rCH pH0R us3R";
$lang['browsernegotiation'] = "brOws3R ne90T14T3D";
$lang['textfield'] = "+ext FIELd";
$lang['multilinetextfield'] = "mUlT1-LiN3 TexT Ph1elD";
$lang['radiobuttons'] = "r4d10 8U+toNS";
$lang['dropdownlist'] = "dROP DOWn Lis+";
$lang['clickablehyperlink'] = "cl1CKAblE HYpERLink";
$lang['threadcount'] = "tHRE4d C0un+";
$lang['clicktoeditfolder'] = "cL1cK to EdI+ pHOLd3R";
$lang['fieldtypeexample1'] = "to cRE4+E r4dI0 BuT+Ons 0R A drOP DOwN l1\$t j00 Ne3d +0 3NT3R 3@Ch INDiV1DU4L v@LUe 0N 4 seP4R4T3 L1ne 1N +h3 OP+ION\$ f1ELD.";
$lang['fieldtypeexample2'] = "tO Cr34t3 CL1CK48LE l1NKS 3n+er THE uRL IN tH3 0p+10Ns PHi3Ld 4ND uS3 <i>%1\$S</i> wHER3 ThE enTRY pHROM +H3 US3R's PR0F1l3 \$hoULD @pPE@r. 3X4mPL3S: <p>mysP@Ce: <i>h+TP://WwW.MysPAC3.c0m/%1\$s</i><br />x80x LiVE: <i>h++p://pr0fIle.my94M3RCArd.NE+/%1\$\$</i>";
$lang['editedwordfilter'] = "eD1+3D W0Rd FILt3r";
$lang['editedforumsettings'] = "eD1+3d PhORUm S3T+1NG\$";
$lang['successfullyendedusersessionsforselectedusers'] = "sUcc3sSPHULLY enDEd \$3sSI0n\$ f0R s3LECT3d US3RS";
$lang['failedtoendsessionforuser'] = "f@1l3D T0 3ND S3sSI0N phoR U53R %s";
$lang['successfullyapproveduser'] = "sUcC3sSPHULly @ppROV3D US3r";
$lang['successfullyapprovedselectedusers'] = "suCC3ssFULly 4PPR0veD \$3L3C+Ed US3r\$";
$lang['matchedtext'] = "m4+CH3D TEXt";
$lang['replacementtext'] = "rEpL4CEm3n+ T3XT";
$lang['preg'] = "prE9";
$lang['wholeword'] = "wHOL3 W0RD";
$lang['word_filter_help_1'] = "<b>aLL</b> m@+CH3S 49aIn\$+ +h3 WhoL3 +3x+ \$0 fIL+eRin9 M0M TO MUM W1LL 4L\$O CH4N9E MOmeN+ t0 MUm3n+.";
$lang['word_filter_help_2'] = "<b>wh0L3 W0RD</b> MA+Ch35 @9@INST wH0L3 W0Rds ONLY \$0 PHiLT3RIN9 M0M +0 mUM w1lL N0+ cH@NgE MoM3N+ +0 MumEnt.";
$lang['word_filter_help_3'] = "<b>pre9</b> 4lLOWS j00 +0 u\$3 P3rL r39uL4R EXpRE\$S10n\$ +0 M4TCH teX+.";
$lang['nameanddesc'] = "nam3 4Nd DESCR1P+I0n";
$lang['movethreads'] = "mOvE tHR3ADS";
$lang['movethreadstofolder'] = "m0v3 +HREAd\$ +O Ph0LD3R";
$lang['failedtomovethreads'] = "f41L3d TO M0V3 THr3adS TO SpECIPh1Ed Ph0lD3R";
$lang['resetuserpermissions'] = "re5e+ US3R PErM1s\$iON\$";
$lang['failedtoresetuserpermissions'] = "f4IL3D +0 RE\$3+ us3r P3RMI\$S1oNS";
$lang['allowfoldertocontain'] = "aLl0w PHOlder +0 cont41N";
$lang['addnewfolder'] = "aDD n3W F0LD3R";
$lang['mustenterfoldername'] = "j00 MUST 3Nt3R @ f0lD3R N4M3";
$lang['nofolderidspecified'] = "no ph0LDER ID \$pECIPhi3D";
$lang['invalidfolderid'] = "iNv4lID F0LD3R 1D. cH3CK tH4+ 4 F0LD3R wIth Th1\$ ID exIsTS!";
$lang['successfullyaddednewfolder'] = "suCce\$sPHULLY @DDED NEW FOLd3R";
$lang['successfullyremovedselectedfolders'] = "sucC3ssFUlly REm0vED SEl3cTed FOLd3r\$";
$lang['successfullyeditedfolder'] = "suCce\$SPHULLY eD1TED PH0LD3r";
$lang['failedtocreatenewfolder'] = "f41l3d +0 CR3A+3 N3W PH0Ld3R";
$lang['failedtodeletefolder'] = "f4ILEd TO d3l3tE F0LDEr.";
$lang['failedtoupdatefolder'] = "f4il3d +O upd4+3 F0LD3R";
$lang['cannotdeletefolderwiththreads'] = "c4nnOT d3l3+3 F0lD3R\$ TH4T S+1lL c0N+41n ThREAd\$.";
$lang['forumisnotrestricted'] = "f0RUM i\$ n0t R3\$TrIC+3D";
$lang['groups'] = "gROUPS";
$lang['nousergroups'] = "n0 u5ER GrouP\$ h4v3 BEEN \$3+ UP. T0 4DD A groUP clICK th3 '@DD neW' 8u+T0N 8eL0W.";
$lang['suppliedgidisnotausergroup'] = "sUppLI3D 91D 1\$ N0+ 4 usER grOUp";
$lang['manageusergroups'] = "m@n49E US3R gr0UP\$";
$lang['groupstatus'] = "gr0up sT@tuS";
$lang['addusergroup'] = "add u\$3R 9ROUP";
$lang['addemptygroup'] = "add 3MPty 9R0UP";
$lang['adduserstogroup'] = "aDD U\$3RS +O GROup";
$lang['addremoveusers'] = "add/R3mOVE USERS";
$lang['nousersingroup'] = "tH3rE 4RE N0 us3RS 1N thIS 9R0uP. 4dD Us3rS +O +H1s 9ROUP bY sE4RCHIng PHOr +H3M 83low.";
$lang['groupaddedaddnewuser'] = "sucC3s\$pHUllY 4DD3d 9R0uP. 4DD u5eR\$ T0 +His 9ROUP 8y \$34RCHiN9 F0R tHEM 83LOW.";
$lang['nousersingroupaddusers'] = "th3rE 4RE N0 US3r\$ in THI\$ GROUp. +0 @DD usER\$ cl1cK +he '4dd/R3M0Ve US3R5' 8U++0n 8EL0W.";
$lang['useringroups'] = "thI\$ U5er 1\$ 4 M3m8ER oF +hE Ph0ll0W1N9 9R0UPs";
$lang['usernotinanygroups'] = "tH1\$ U\$3R 1S N0t IN @NY U\$eR 9ROUPS";
$lang['usergroupwarning'] = "no+E: +H1s US3R M4Y B3 1NHER1+1n9 AdDI+1oN4L P3RMi\$s1on5 Fr0M 4NY U\$3R 9ROUP5 LIST3D BeL0w.";
$lang['successfullyaddedgroup'] = "sUcCE5SPHulLY @DDeD gROUP";
$lang['successfullyeditedgroup'] = "sUcC3\$SPhulLY 3D1TeD 9ROup";
$lang['successfullydeletedselectedgroups'] = "suCcessFULly Del3T3D \$3l3CTEd GROUPS";
$lang['failedtodeletegroupname'] = "fA1LEd TO DEL3+3 Gr0UP %s";
$lang['usercanaccessforumtools'] = "u\$er CAn 4CC3sS FORuM +ooLs 4nD C4N cr34+3, deL3T3 @ND 3D1T PhoRUms";
$lang['usercanmodallfoldersonallforums'] = "u5ER C@N modER@tE <b>aLL f0lD3RS</b> 0n <b>aLL PhorUMS</b>";
$lang['usercanmodlinkssectiononallforums'] = "us3r C4N m0d3RA+3 l1NkS \$3CT10n oN <b>aLL F0RUMS</b>";
$lang['emailconfirmationrequired'] = "em4iL CoNF1RM@+10N ReQU1Red";
$lang['userisbannedfromallforums'] = "u53R 1\$ B@nn3D FROM <b>all FORUm\$</b>";
$lang['cancelemailconfirmation'] = "c4nC3L 3M41l C0nFIRm4tI0N 4ND @lLOW US3R TO S+4Rt P0sTIn9";
$lang['resendconfirmationemail'] = "re\$3nd C0nFIRM4+1oN 3M4IL TO us3R";
$lang['failedtosresendemailconfirmation'] = "f@iLED tO R3\$3Nd Em41L CONf1rM@+10n +o U\$3R.";
$lang['donothing'] = "d0 n0+HIn9";
$lang['usercanaccessadmintools'] = "u53R h4S 4Cc3sS +O ph0RUM adMiN +0oLs";
$lang['usercanaccessadmintoolsonallforums'] = "u\$ER h@\$ Acc3\$S +O ADM1n toOLS <b>oN 4lL F0RUms</b>";
$lang['usercanmoderateallfolders'] = "u\$ER C4N m0D3R@t3 4LL pH0LD3R\$";
$lang['usercanmoderatelinkssection'] = "us3R C4N M0deR@TE l1NK\$ \$ec+I0N";
$lang['userisbanned'] = "uS3r 1\$ 8@NN3D";
$lang['useriswormed'] = "uS3R 15 WORm3d";
$lang['userispilloried'] = "u\$eR i\$ PiLLOr1eD";
$lang['usercanignoreadmin'] = "u5eR Can 1GNOr3 @DmINiSTr@+oR\$";
$lang['groupcanaccessadmintools'] = "gR0UP C4n 4CCe\$s ADmIN +0OLs";
$lang['groupcanmoderateallfolders'] = "gROUP C4n MoDER4+3 4LL F0LD3R\$";
$lang['groupcanmoderatelinkssection'] = "gr0Up C4n MODer@+e L1NKS \$3CTi0NS";
$lang['groupisbanned'] = "gR0uP IS B4nN3d";
$lang['groupiswormed'] = "gR0uP 1\$ W0RM3d";
$lang['readposts'] = "r3@D P0\$+S";
$lang['replytothreads'] = "r3pLY To THR3ADs";
$lang['createnewthreads'] = "cr34+3 N3W ThREAD\$";
$lang['editposts'] = "edi+ PosTs";
$lang['deleteposts'] = "dEL3+E PO\$Ts";
$lang['postssuccessfullydeleted'] = "p0St\$ \$Ucc3sSFULly D3LE+3D";
$lang['failedtodeleteusersposts'] = "f@1lED TO D3LE+3 USER'S postS";
$lang['uploadattachments'] = "uPL04d 4++@cHM3N+s";
$lang['moderatefolder'] = "m0DeR4T3 FOLD3R";
$lang['postinhtml'] = "pOST 1N HTml";
$lang['postasignature'] = "pOST A s19N4TUr3";
$lang['editforumlinks'] = "ed1+ phORUM LINks";
$lang['linksaddedhereappearindropdown'] = "l1nK\$ 4dD3d HEre 4PP34R IN @ Dr0p D0WN iN thE +OP R1GH+ 0F T3H fR4M3 5E+.";
$lang['linksaddedhereappearindropdownaddnew'] = "lInK\$ adD3d H3r3 4PPE4R 1N 4 DR0P DOwn IN thE toP RIgH+ 0f +HE FR4M3 S3t. +0 ADD 4 l1nK CL1CK +h3 '@DD N3W' 8U+TON 8EL0W.";
$lang['failedtoremoveforumlink'] = "f41L3D +0 REM0VE FORum L1NK '%s'";
$lang['failedtoaddnewforumlink'] = "f41L3d +0 @DD n3W fORUm LInk '%s'";
$lang['failedtoupdateforumlink'] = "f@1LED TO UPd4t3 F0RUM l1nK '%s'";
$lang['notoplevellinktitlespecified'] = "n0 +OP leVEL LinK +I+le \$PECIfIEd";
$lang['youmustenteralinktitle'] = "j00 mU5+ ENT3R @ LiNK +1tl3";
$lang['alllinkurismuststartwithaschema'] = "aLl l1NK Ur15 MUS+ s+ART w1+H @ SCh3M4 (1.e. H++P://, ph+p://, 1RC://)";
$lang['editlink'] = "edi+ L1nK";
$lang['addnewforumlink'] = "aDD N3w Ph0Rum LiNK";
$lang['forumlinktitle'] = "fOrUM l1nK +1+LE";
$lang['forumlinklocation'] = "fOruM L1NK l0CA+I0N";
$lang['successfullyaddednewforumlink'] = "sUcCE\$sphULLY @DD3D N3W f0RUM l1nK";
$lang['successfullyeditedforumlink'] = "succE\$SPHUllY EDI+eD f0RuM LiNK";
$lang['invalidlinkidorlinknotfound'] = "inv@Lid l1nk 1D 0R L1NK NOT FOUND";
$lang['successfullyremovedselectedforumlinks'] = "sucC35SPHULLy REmovEd S3L3C+ED L1NKS";
$lang['toplinkcaption'] = "t0p LInk CAptI0N";
$lang['allowguestaccess'] = "all0w 9u3sT 4CC3ss";
$lang['searchenginespidering'] = "s3arCH ENG1ne sP1D3R1N9";
$lang['allowsearchenginespidering'] = "aLLOW S34rch 3nGIne \$PIDer1N9";
$lang['sitemapenabled'] = "en@BLE \$1TEM@p";
$lang['sitemapupdatefrequency'] = "sI+EM@P UPD4T3 FR3QUenCY";
$lang['sitemappathnotwritable'] = "sit3mAP D1R3CT0RY MU\$T Be WR1+@blE 8Y +he WEB \$ERVEr / PHP pR0C3\$s!";
$lang['newuserregistrations'] = "nEw US3r R3Gi\$TR4tIOn\$";
$lang['preventduplicateemailaddresses'] = "pr3VENT duPL1c@TE 3M@1L adDRE\$S3\$";
$lang['allownewuserregistrations'] = "all0w N3W USER re9i5+R4+10N\$";
$lang['requireemailconfirmation'] = "r3qu1rE EM4IL C0nF1RM4+10n";
$lang['usetextcaptcha'] = "uSe +3X+-C@p+cHA";
$lang['textcaptchafonterror'] = "tex+-C4pTch@ H4s B3EN dI\$@8LED 4u+0m4TIC@llY B3C4uS3 THERe 4r3 N0 TRUE TypE FON+\$ 4V4IL4BLE foR 1+ +0 USe. PL3A\$3 UPLO4d \$0M3 +RU3 TYPE f0n+S To <b>t3xt_C4p+ch4/FoN+5</b> oN YOUR \$3RveR.";
$lang['textcaptchadirerror'] = "teXT-c@P+cHA H4S BeeN DI\$@8lEd BEc@uS3 the T3XT_c4pTCH4 D1RECt0rY 4ND 1T'S Su8-DIr3cTOR1ES 4RE no+ wR1+@8lE 8Y tH3 W38 SERv3r / pHP pr0C3sS.";
$lang['textcaptchagderror'] = "teX+-C@PtCH@ HA\$ B3eN DI\$48LEd BEC4US3 YOUR 5eRV3R'\$ pHP SETUP D03S no+ pr0VIDE SUPPOR+ FOR gD IM@ge M4NIpuLatI0N @nD / oR ttPH phON+ 5uPP0RT. Bo+H 4rE R3QU1R3d PhOR +EXT-C4pTCh4 SUppORT.";
$lang['newuserpreferences'] = "n3W US3R PREpH3rENce5";
$lang['sendemailnotificationonreply'] = "eM4iL n0TiFIc@T1oN 0n repLY to UseR";
$lang['sendemailnotificationonpm'] = "eM4IL nO+iph1C@TION oN Pm tO U53R";
$lang['showpopuponnewpm'] = "shoW p0Pup Wh3N ReCe1V1n9 N3W pm";
$lang['setautomatichighinterestonpost'] = "s3+ 4utOM4+1c H19H 1n+eR3\$T 0n p0St";
$lang['postingstats'] = "p0StiN9 5t4+\$";
$lang['postingstatsforperiod'] = "pOsTING s+@+5 Ph0R P3ri0D %s +O %s";
$lang['nopostdatarecordedforthisperiod'] = "no pO\$+ d@T@ rECOrd3D Ph0r +h1S peRI0D.";
$lang['totalposts'] = "to+4L pO\$TS";
$lang['totalpostsforthisperiod'] = "t0+4L P0st5 f0R thiS perI0D";
$lang['mustchooseastartday'] = "mU\$T cH005e @ st@R+ Day";
$lang['mustchooseastartmonth'] = "mu\$+ Ch0o\$3 4 \$T@R+ M0N+H";
$lang['mustchooseastartyear'] = "mU\$+ ch0O\$E @ 5+@R+ Y34R";
$lang['mustchooseaendday'] = "muS+ ChO0s3 4 END DAY";
$lang['mustchooseaendmonth'] = "musT CH0ose 4 3Nd MoN+H";
$lang['mustchooseaendyear'] = "mU\$+ CH0O5e 4 enD Y34r";
$lang['startperiodisaheadofendperiod'] = "stAR+ PErIod IS @h34d 0f 3nD p3RI0D";
$lang['bancontrols'] = "b@n C0n+r0LS";
$lang['addban'] = "adD 84n";
$lang['checkban'] = "ch3CK b@N";
$lang['editban'] = "ed1+ 84n";
$lang['bantype'] = "b4n +YP3";
$lang['bandata'] = "b4N D@T@";
$lang['bancomment'] = "c0mMENt";
$lang['ipban'] = "ip B4n";
$lang['logonban'] = "l090N B@N";
$lang['nicknameban'] = "n1ckN@m3 B4N";
$lang['emailban'] = "em41L b@n";
$lang['refererban'] = "rEFereR b@N";
$lang['invalidbanid'] = "inv4lID B4N 1D";
$lang['affectsessionwarnadd'] = "tH1\$ B4n M4Y AFPH3CT tEH F0LLoWInG 4C+1VE US3R seSSIOns";
$lang['noaffectsessionwarn'] = "tH1\$ 8AN AFF3CT\$ N0 @ctIve SE\$s10N\$";
$lang['mustspecifybantype'] = "j00 muST Spec1Fy 4 84n TYPE";
$lang['mustspecifybandata'] = "j00 MUST spEC1FY S0mE B4N DAT4";
$lang['successfullyremovedselectedbans'] = "succ3\$sPHUllY rEMOV3D \$3L3C+Ed B4N\$";
$lang['failedtoaddnewban'] = "f41L3D +0 @Dd N3W 8AN";
$lang['failedtoremovebans'] = "fAiL3D +O REm0VE soME oR 4LL 0f T3h sEL3c+3d 8@Ns";
$lang['duplicatebandataentered'] = "dupL1c4te 8@N d4+A EN+3R3d. Ple4sE chECK y0Ur WiLdc4RDS t0 \$EE 1F +HeY @LRE4DY m4TCH TEh d4+A 3nt3REd";
$lang['successfullyaddedban'] = "sucC3\$SFULLY 4dDED 84N";
$lang['successfullyupdatedban'] = "sUcCE5SPhuLLY UPD4+3D B4n";
$lang['noexistingbandata'] = "theRe IS NO 3x1\$t1N9 8AN d4+4. T0 @Dd 4 B4N Cl1cK ThE '4DD N3W' 8u++On 8eL0W.";
$lang['youcanusethepercentwildcard'] = "j00 CaN U\$e +eH P3Rc3n+ (%) WilDC@rd \$yMBOL 1n @nY 0pH YouR 8@N l1s+S +O o8+AIN PaR+1AL m4+CHes, 1.3. '192.168.0.%' WoulD 8@N aLL IP 4DDRes\$3\$ IN thE rAnGE 192.168.0.1 THroU9H 192.168.0.254";
$lang['cannotusewildcardonown'] = "j00 C@NNOt 4DD % @s @ WILDc@RD mA+Ch oN i+'\$ 0WN!";
$lang['requirepostapproval'] = "rEQUIR3 Po\$+ 4PPR0V4L";
$lang['adminforumtoolsusercounterror'] = "thEre MUST b3 4+ L34sT 1 U\$3R WI+h 4dM1N TO0L5 4ND f0RUM tOOLS aCCe\$S 0n @lL PHORuM\$!";
$lang['postcount'] = "poST C0uNT";
$lang['resetpostcount'] = "rE5eT POST c0UN+";
$lang['failedtoresetuserpostcount'] = "f41Led TO r3s3t P0\$+ COUn+";
$lang['failedtochangeuserpostcount'] = "f4iLED +0 CHANg3 Us3R PO\$t COUNt";
$lang['postapprovalqueue'] = "p05+ APPr0v4l QuEUE";
$lang['nopostsawaitingapproval'] = "n0 post\$ 4r3 AWAitINg 4PPROv@l";
$lang['approveselected'] = "aPpR0V3 \$3LEc+3D";
$lang['failedtoapproveuser'] = "f41l3d +0 4PproVE us3R %s";
$lang['kickselected'] = "kick SELEctED";
$lang['visitorlog'] = "v1\$1+0r L0G";
$lang['novisitorslogged'] = "no V1\$1+0Rs LOg93d";
$lang['addselectedusers'] = "aDd \$3LEc+eD us3r\$";
$lang['removeselectedusers'] = "remOVe \$3lEC+Ed US3Rs";
$lang['addnew'] = "aDD N3W";
$lang['deleteselected'] = "deL3te s3LECTed";
$lang['forumrulesmessage'] = "<p><b>f0rum RUL3s</b></p><p>\nR39I\$+r4t10N TO %1\$\$ 1s PHre3! W3 Do iN5is+ tH@T j00 481d3 BY ThE rUl3\$ AND POL1C1ES De+41lED BelOW. if J00 49REe +0 TH3 +3RMS, pLe4\$3 CH3CK T3h '1 4grEE' CHEcK80x 4ND Pr3s\$ +H3 'RE9I\$+ER' bU++0N 83lOW. 1F J00 WOULd LiKE t0 C4NCEL tH3 R3g1sTR4TION, CL1CK %2\$s +0 REtURN +0 Teh f0ruMS 1ND3X.</p><p>\n4L+H0U9H +He 4DMINISTR@tORS ANd M0DER4+OR\$ Of %1\$S WiLL AT+eMP+ TO kEEP alL O8JeCt10N4BLe m3SS49e\$ 0PHF +HIS F0RUM, 1+ I5 IMPO\$S18LE f0r US t0 Rev1eW 4LL M3s\$@9Es. @LL mES5@Ge\$ 3xpress +H3 V1ews 0F +h3 4U+HOr, aND N31THEr +H3 own3rS 0f %1\$s, nor PR0jeCT 8e3HiVe f0rum AND 1+'\$ @fF1lia+es WILL BE h3LD RESp0ns1BlE f0r TEh CON+3n+ opH ANy MESs4ge.</p><p>\n8Y 49rE31ng +o THeS3 RULEs, J00 w4rr@N+ +h@T j00 wILl No+ Po\$T @NY Me\$S4Ges +h4+ 4r3 08ScenE, VuLG@R, \$3xu4lly-0rienT@+Ed, HA+3ful, THr3A+3n1N9, or 0+H3rW153 VI0l4+iv3 of 4nY L@Ws.</p><p>thE 0WNERs 0Ph %1\$s rEsERV3 +H3 righT +O r3moVe, Ed1T, m0v3 or CL0s3 4ny ThR34D PH0r @Ny RE@SOn.</p>";
$lang['cancellinktext'] = "her3";
$lang['failedtoupdateforumsettings'] = "f41LeD TO upD4t3 FORUM s3+T1NG\$. PL3@S3 TRY 4GAin LA+Er.";
$lang['moreadminoptions'] = "m0r3 4dMIN 0pTIOns";

// Admin Log data (admin_viewlog.php) --------------------------------------------

$lang['changedstatusforuser'] = "ch@nGED US3r S+@TU\$ PHOr '%s'";
$lang['changedpasswordforuser'] = "ch@nGED P@ssWOrD PhoR '%s'";
$lang['changedforumaccess'] = "ch4NGED FoRUm 4CC3s5 P3rMI\$S1oN\$ F0r '%s'";
$lang['deletedallusersposts'] = "del3T3D 4ll P0\$+S PhoR '%s'";

$lang['createdusergroup'] = "cRe@TED us3r 9ROUp '%s'";
$lang['deletedusergroup'] = "dEL3+3D US3R 9ROUp '%s'";
$lang['updatedusergroup'] = "upd4tED UseR 9ROUP '%s'";
$lang['addedusertogroup'] = "aDD3D USER '%s' +0 GROup '%s'";
$lang['removeduserfromgroup'] = "rEmovE usER '%s' froM GROuP '%s'";

$lang['addedipaddresstobanlist'] = "addED Ip '%s' +O 8An l1\$+";
$lang['removedipaddressfrombanlist'] = "rEMOVeD 1P '%s' PHRom 84N li\$+";

$lang['addedlogontobanlist'] = "aDDEd LOG0N '%s' TO 8An Li\$T";
$lang['removedlogonfrombanlist'] = "r3m0VED L0G0N '%s' PhROM b4n LI\$T";

$lang['addednicknametobanlist'] = "aDd3d N1cKN4M3 '%s' +O b@N liST";
$lang['removednicknamefrombanlist'] = "rem0v3d NICkN4M3 '%s' fR0M 8AN LIS+";

$lang['addedemailtobanlist'] = "addED EMAIl 4ddrE5S '%s' +O 8aN L1S+";
$lang['removedemailfrombanlist'] = "rEM0v3D Em41l 4DDreSs '%s' PhrOM 84n L1s+";

$lang['addedreferertobanlist'] = "adD3D r3f3rER '%s' +O 8@N lI\$T";
$lang['removedrefererfrombanlist'] = "rem0veD R3FereR '%s' PHrOM 8@N lISt";

$lang['editedfolder'] = "edI+3D F0LD3R '%s'";
$lang['movedallthreadsfromto'] = "m0v3D 4LL THr3aDS From '%s' T0 '%s'";
$lang['creatednewfolder'] = "cr34T3d N3W PH0LDer '%s'";
$lang['deletedfolder'] = "d3leT3D F0LD3R '%s'";

$lang['changedprofilesectiontitle'] = "ch4NGED pr0PHILe sECT10N +I+lE FR0M '%s' TO '%s'";
$lang['addednewprofilesection'] = "aDDED NEw PR0F1L3 \$3CT10N '%s'";
$lang['deletedprofilesection'] = "dEl3+3d ProFIlE S3CTI0N '%s'";

$lang['addednewprofileitem'] = "aDd3D N3W Pr0PH1Le I+3m '%s' +0 S3CTI0N '%s'";
$lang['changedprofileitem'] = "ch4NgeD PROfiL3 1t3M '%s'";
$lang['deletedprofileitem'] = "d3l3+3D Pr0FIlE 1+3M '%s'";

$lang['editedstartpage'] = "eDi+3D \$T@R+ p493";
$lang['savednewstyle'] = "sav3d NEW \$+YLe '%s'";

$lang['movedthread'] = "m0v3d +HreAD '%s' fr0M '%s' +o '%s'";
$lang['closedthread'] = "cl0S3D +HRE4D '%s'";
$lang['openedthread'] = "opEn3d THR3@D '%s'";
$lang['renamedthread'] = "r3N4m3d THR34d '%s' +0 '%s'";

$lang['deletedthread'] = "del3t3d +HREAd '%s'";
$lang['undeletedthread'] = "und3lE+3D +Hr3@D '%s'";

$lang['lockedthreadtitlefolder'] = "lock3D +HreaD 0P+10ns 0n '%s'";
$lang['unlockedthreadtitlefolder'] = "uNL0cKED THRE4D 0p+10ns 0N '%s'";

$lang['deletedpostsfrominthread'] = "d3LE+3D PO5+S fR0m '%s' 1N +HRe4d '%s'";
$lang['deletedattachmentfrompost'] = "d3l3+3d At+4CHM3N+ '%s' pHROM posT '%s'";

$lang['editedforumlinks'] = "ed1TED FORUm LinK\$";
$lang['editedforumlink'] = "eDI+3D Ph0RUM l1Nk: '%s'";

$lang['addedforumlink'] = "addeD Ph0RUM L1NK: '%s'";
$lang['deletedforumlink'] = "d3L3+3D f0RUM l1nK: '%s'";
$lang['changedtoplinkcaption'] = "cH@NGed +OP l1NK caPt10n PhR0M '%s' T0 '%s'";

$lang['deletedpost'] = "dEl3+3d po\$+ '%s'";
$lang['editedpost'] = "edi+3D PO\$+ '%s'";

$lang['madethreadsticky'] = "m4d3 +hRE4D '%s' \$+1CKY";
$lang['madethreadnonsticky'] = "m@DE Thr3@D '%s' N0N-sT1cky";

$lang['endedsessionforuser'] = "end3D SESSION f0r USEr '%s'";

$lang['approvedpost'] = "appRoV3d POs+ '%s'";

$lang['editedwordfilter'] = "ed1+3d W0RD f1l+3R";

$lang['addedrssfeed'] = "aDd3d Rs\$ PH3ED '%s'";
$lang['editedrssfeed'] = "ed1+3d RS\$ FEED '%s'";
$lang['deletedrssfeed'] = "dEleTeD RS\$ pH33d '%s'";

$lang['updatedban'] = "upD4T3d B4N '%s'. ch4NG3D TYPe FROM '%s' T0 '%s', Ch4N9ED DAT4 Fr0M '%s' TO '%s'.";

$lang['splitthreadatpostintonewthread'] = "splIT THr3@D '%s' 4+ POST %s  IN+O N3W +Hre4D '%s'";
$lang['mergedthreadintonewthread'] = "mERgeD thR3aDS '%s' 4nD '%s' 1NTO nEW +hRE4D '%s'";

$lang['approveduser'] = "apPROV3D USER '%s'";

$lang['forumautoupdatestats'] = "f0rUM @Uto UPDa+e: ST@Ts UPd@TED";
$lang['forumautocleanthreadunread'] = "forUM 4U+O UPd@+3: +hrE4d UNRE4D DA+a CLe4nED";

$lang['ipaddressbanhit'] = "u\$ER '%s' IS B4NN3d. 1P ADDRE5S '%s' M@TCH3D baN D4T4 '%s'";
$lang['logonbanhit'] = "u\$er '%s' i\$ B4NNEd. l0G0N '%s' m4+CHeD b4N d4+4 '%s'";
$lang['nicknamebanhit'] = "u\$eR '%s' I5 B4NNED. N1CKN4M3 '%s' M4tch3D 8@N D4+A '%s'";
$lang['emailbanhit'] = "useR '%s' I\$ B4nnED. 3M@il 4DDR3SS '%s' MA+CHed B4N d4+@ '%s'";
$lang['refererbanhit'] = "uSeR '%s' I\$ b4nn3d. Http R3FERER '%s' M@TCh3d 8@N Dat4 '%s'";

$lang['modifiedpermsforuser'] = "m0DIf1ed PERm\$ fOR us3r '%s'";
$lang['modifiedfolderpermsforuser'] = "m0DIFieD FOLD3R perM\$ f0r US3R '%s'";

$lang['userpermfoldermoderate'] = "f0LDer m0d3R4T0R";

$lang['adminlogempty'] = "aDM1n L0g IS 3MP+y";

$lang['youmustspecifyanactiontypetoremove'] = "j00 MU\$t SpEciFY 4N ActION tyPE To R3m0VE";

$lang['alllogentries'] = "all LO9 EN+Ri35";
$lang['userstatuschanges'] = "u\$eR S+A+U\$ cHANGe5";
$lang['forumaccesschanges'] = "foRUm AcC3ss CH@NGes";
$lang['usermasspostdeletion'] = "u53R m@SS p0\$+ D3LE+1on";
$lang['ipaddressbanadditions'] = "ip @DdR35s 8AN 4DD1T10NS";
$lang['ipaddressbandeletions'] = "ip 4dDR3Ss B4N DeL3tiONS";
$lang['threadtitleedits'] = "tHreAD +1tL3 ED1t\$";
$lang['massthreadmoves'] = "m@SS +Hre4d MOVes";
$lang['foldercreations'] = "fOlD3r cREA+10n\$";
$lang['folderdeletions'] = "folDER D3LE+10nS";
$lang['profilesectionchanges'] = "pR0PHILE sECTIOn CHAngES";
$lang['profilesectionadditions'] = "pRoF1l3 \$Ec+10N @dDI+1oNS";
$lang['profilesectiondeletions'] = "pR0PHIl3 \$ec+10N D3LETION\$";
$lang['profileitemchanges'] = "pROFIL3 1T3M cH4n9E\$";
$lang['profileitemadditions'] = "proPHIL3 I+3M 4dd1+1ON\$";
$lang['profileitemdeletions'] = "pr0F1L3 I+em Del3T1ONS";
$lang['startpagechanges'] = "st4r+ P49e CH4n9es";
$lang['forumstylecreations'] = "f0ruM STYle CRe4t10NS";
$lang['threadmoves'] = "tHre4D MOVE5";
$lang['threadclosures'] = "thr3@D cl0\$UR3\$";
$lang['threadopenings'] = "tHRead oP3N1NG\$";
$lang['threadrenames'] = "thr3ad R3N@M3s";
$lang['postdeletions'] = "p05+ D3L3+10nS";
$lang['postedits'] = "pO5t Ed1t\$";
$lang['wordfilteredits'] = "worD PH1L+3r ED1t5";
$lang['threadstickycreations'] = "tHR3AD 5+1CKY cR34+10NS";
$lang['threadstickydeletions'] = "tHR3AD \$t1cKY dEL3T10nS";
$lang['usersessiondeletions'] = "uS3r S35\$10n DEle+1ONS";
$lang['forumsettingsedits'] = "f0rUM Set+1NG5 ed1tS";
$lang['threadlocks'] = "tHR3Ad l0cks";
$lang['threadunlocks'] = "thr3@D UNl0CK\$";
$lang['usermasspostdeletionsinathread'] = "uS3r M4SS PO\$+ D3LE+10NS In A +HRE4D";
$lang['threaddeletions'] = "tHRE4d D3LE+i0nS";
$lang['attachmentdeletions'] = "at+4cHMENt D3L3+1ONS";
$lang['forumlinkedits'] = "fORUM LINK 3dI+5";
$lang['postapprovals'] = "p0st APprOV4l\$";
$lang['usergroupcreations'] = "us3R 9ROUP cREa+1ons";
$lang['usergroupdeletions'] = "uS3R 9roUP Del3T1ON\$";
$lang['usergroupuseraddition'] = "u\$3R 9R0UP Us3R AdDITIOn";
$lang['usergroupuserremoval'] = "useR Gr0uP U\$3R REm0v@L";
$lang['userpasswordchange'] = "u\$er PA\$SW0RD cH4NG3";
$lang['usergroupchanges'] = "u\$ER 9roUP Ch4n9es";
$lang['ipaddressbanadditions'] = "ip 4ddr3s5 b4n 4dD1TI0N\$";
$lang['ipaddressbandeletions'] = "ip 4dDrE\$s Ban D3L3T10nS";
$lang['logonbanadditions'] = "l090n B4N ADdi+I0N\$";
$lang['logonbandeletions'] = "l090n 8AN del3+10NS";
$lang['nicknamebanadditions'] = "n1cKN4M3 B4N 4DD1+I0Ns";
$lang['nicknamebanadditions'] = "nICKN@M3 B@n @Ddi+IONS";
$lang['e-mailbanadditions'] = "e-m4iL BAn 4DD1TI0NS";
$lang['e-mailbandeletions'] = "e-mAIl B@n D3LE+1ON\$";
$lang['rssfeedadditions'] = "r\$S fE3d 4DD1TI0N5";
$lang['rssfeedchanges'] = "rs\$ PHEED cH4N93s";
$lang['threadundeletions'] = "tHr34d UND3LE+1On\$";
$lang['httprefererbanadditions'] = "hTTP R3Ph3rer 84N aDd1+1oNS";
$lang['httprefererbandeletions'] = "h++p R3PHER3r 84N d3L3+1ON\$";
$lang['rssfeeddeletions'] = "rSS PHE3D DEL3T1ON5";
$lang['banchanges'] = "b4N ch4N9E\$";
$lang['threadsplits'] = "thr34d sPL1T\$";
$lang['threadmerges'] = "thre4D M3RGe\$";
$lang['userapprovals'] = "u5eR @PPr0v@lS";
$lang['forumlinkadditions'] = "f0RuM lINK @DDI+1ONS";
$lang['forumlinkdeletions'] = "f0ruM L1NK deLE+i0n\$";
$lang['forumlinktopcaptionchanges'] = "fOruM l1nK TOp C4PT1oN Ch@NGES";
$lang['folderedits'] = "folDER edi+S";
$lang['userdeletions'] = "u53R D3LE+10n\$";
$lang['userdatadeletions'] = "u\$3R DA+a DELe+1oN\$";
$lang['forumstatsautoupdates'] = "f0RUM \$+@ts 4U+O uPD@TE\$";
$lang['forumautothreadunreaddataupdates'] = "fORUM 4U+0 thR34D UNre4D D4T@ UPd@T3S";
$lang['usergroupchanges'] = "u\$3r 9ROuP Ch4N93\$";
$lang['ipaddressbancheckresults'] = "ip 4dDrESS b@N CheCk RESULt\$";
$lang['logonbancheckresults'] = "l090n 84N CH3CK rE\$Ul+s";
$lang['nicknamebancheckresults'] = "n1CKN@mE B4N cHECK rE\$uL+5";
$lang['emailbancheckresults'] = "eMaIL B4n cHECK R3\$UL+s";
$lang['httprefererbancheckresults'] = "h++p R3pHerER Ban cH3CK r3\$ulT\$";

$lang['removeentriesrelatingtoaction'] = "r3moVE 3Ntr13S R3L4TINg TO @c+10n";
$lang['removeentriesolderthandays'] = "r3m0v3 ENTR1e\$ 0LD3R +h4N (D@ys)";

$lang['successfullyprunedadminlog'] = "sUCCE\$\$phuLLY PRUNEd 4DMIN LOG";
$lang['failedtopruneadminlog'] = "faIl3d +0 PRUN3 @DmIN LOG";

$lang['successfullyprunedvisitorlog'] = "sUCCESSPHuLlY prUN3D V1\$ITOr lOG";
$lang['failedtoprunevisitorlog'] = "faiLED TO prUN3 Vi\$1+0r lOG";

$lang['prunelog'] = "pRUN3 LOG";

// Admin Forms (admin_forums.php) ------------------------------------------------

$lang['noexistingforums'] = "no 3X1sT1NG f0rUMS FOUNd. T0 CR34T3 4 NEw FORUm CLiCk TH3 '@dd N3W' bUTTon 8eL0W.";
$lang['webtaginvalidchars'] = "w3B+Ag C@N 0NLy C0NT41n UpP3RC@s3 4-Z, 0-9 @ND UND3R5COR3 ch4RAC+er\$";
$lang['databasenameinvalidchars'] = "d4T4BA\$E N4m3 cAN oNly CONT41N 4-Z, 4-Z, 0-9 4ND uNDeRsC0r3 CH@R@c+eR\$";
$lang['invalidforumidorforumnotfound'] = "inV4LId PHORUM f1D OR f0rUM nO+ F0Und";
$lang['successfullyupdatedforum'] = "suCC3SSPHulLY Upd4+3D PH0RUM";
$lang['failedtoupdateforum'] = "f@1lED +O upD@T3 foRUM: '%s'";
$lang['successfullycreatednewforum'] = "sUcCESSFULLy CRE4tED N3W phORUm";
$lang['selectedwebtagisalreadyinuse'] = "th3 S3L3c+3D WeB+49 1s 4LR3@DY in US3. Pl34s3 Cho0s3 4n0+Her.";
$lang['selecteddatabasecontainsconflictingtables'] = "tH3 S3L3C+3D D@T@B4s3 CONT4iNS c0nFLICtiN9 T4BLE\$. c0NFlICT1Ng T4BLe n4M3s @R3:";
$lang['forumdeleteconfirmation'] = "aR3 j00 SURE j00 W4N+ +0 DEl3+E ALl OF Th3 SEL3C+3d PH0rUMS?";
$lang['forumdeletewarning'] = "ple4s3 N0+3 THA+ J00 C@nn0+ rECOVEr D3LETED f0ruM\$. ONCE d3lE+3d 4 F0RUM 4ND 4LL 0F i+'5 @Ss0C14t3D D4+@ IS P3rM4N3NTLY rEM0vED From +Eh D4TABA\$3. 1F J00 D0 N0t WI\$H T0 D3l3TE +3H S3LeCTEd Ph0ruM\$ Pl34SE clICK c4nC3L.";
$lang['successfullyremovedselectedforums'] = "sucCE\$SPhuLLY DELE+3d S3LEC+3D Ph0RumS";
$lang['failedtodeleteforum'] = "fA1lEd t0 D3L3T3D F0RUM: '%s'";
$lang['addforum'] = "aDd PHORum";
$lang['editforum'] = "eD1T pHORUm";
$lang['visitforum'] = "v15I+ f0RUM: %s";
$lang['accesslevel'] = "aCc3Ss L3VEL";
$lang['forumleader'] = "fOrUm L3ADER";
$lang['usedatabase'] = "u\$e DAT4B@S3";
$lang['unknownmessagecount'] = "uNkN0wN";
$lang['forumwebtag'] = "f0ruM We8T@g";
$lang['defaultforum'] = "d3PH4UL+ f0Rum";
$lang['forumdatabasewarning'] = "pLE@SE 3N5UR3 J00 53L3C+ +3H C0rrEC+ d@T@8@S3 WHen CR34T1NG 4 NEW fORUm. ONCe CRE4T3D 4 N3W F0Rum C4NNo+ be moVEd 83+W3EN 4v@IL4Ble D4+ABa\$ES.";

// Admin Global User Permissions

$lang['globaluserpermissions'] = "gLoB4L UsER peRMI\$S1ON\$";

// Admin Forum Settings (admin_forum_settings.php) -------------------------------

$lang['mustsupplyforumwebtag'] = "j00 Mu\$+ \$UppLY 4 FORUM wE8+Ag";
$lang['mustsupplyforumname'] = "j00 mU\$T sUPpLY A pH0RUM n4ME";
$lang['mustsupplyforumemail'] = "j00 mUST SupplY 4 f0RUM 3M@iL 4DDRE\$S";
$lang['mustchoosedefaultstyle'] = "j00 MUST cH00s3 4 DEph4UlT PH0rUM STyLe";
$lang['mustchoosedefaultemoticons'] = "j00 MUST CHo0S3 Def4ULT PHORUm 3M0tIC0n\$";
$lang['mustsupplyforumaccesslevel'] = "j00 MU5+ SuPPly 4 PHORUM 4CC3\$S L3V3L";
$lang['mustsupplyforumdatabasename'] = "j00 Must \$UPplY a f0RUM d4+AbAs3 N4ME";
$lang['unknownemoticonsname'] = "unkn0WN EMotICON\$ N4M3";
$lang['mustchoosedefaultlang'] = "j00 MUS+ cH00S3 4 DEF4ULT pHORuM L4N9u@GE";
$lang['activesessiongreaterthansession'] = "ac+1V3 \$eSs1on +1meOU+ c@NN0T 83 GREa+3R +h4N \$3\$S1oN +1M3OUT";
$lang['attachmentdirnotwritable'] = "a+T4cHM3N+ DireCTORy @Nd SYS+EM TEMp0r4RY diRectORy / PHp.INI 'UPL0@D_+MP_DIr' MUS+ b3 wr1+48L3 BY +3H W3B \$3RV3R / PhP pROC3Ss!";
$lang['attachmentdirblank'] = "j00 muS+ suPplY 4 d1r3CtoRY TO 54V3 4TT@cHm3N+\$ 1N";
$lang['mainsettings'] = "m41N \$3T+1NGS";
$lang['forumname'] = "f0ruM N@m3";
$lang['forumemail'] = "foruM 3M@IL";
$lang['forumnoreplyemail'] = "nO-R3pLY Em41l";
$lang['forumdesc'] = "f0RUM D3\$CR1PTIon";
$lang['forumkeywords'] = "f0rUM k3yW0Rds";
$lang['defaultstyle'] = "d3FAULT s+YL3";
$lang['defaultemoticons'] = "def4uL+ EMOtiCOn5";
$lang['defaultlanguage'] = "d3f4Ul+ l4n9u@gE";
$lang['forumaccesssettings'] = "forUM @CceSs SET+in95";
$lang['forumaccessstatus'] = "foRUM 4CC3\$\$ ST@+us";
$lang['changepermissions'] = "cH4N9E P3RMi\$S10NS";
$lang['changepassword'] = "ch@nGE p4\$Sw0rD";
$lang['passwordprotected'] = "p@ssW0rD PRO+ECT3D";
$lang['passwordprotectwarning'] = "j00 H4V3 N0+ \$3+ 4 PH0rum P4\$SW0RD. 1f J00 DO NOT S3+ 4 P4ssW0RD +H3 PA\$SWoRD PROTEC+10N PHUNC+1ONal1+Y W1Ll BE 4Ut0m@T1C4LLY di\$48l3d!";
$lang['postoptions'] = "p0\$T OP+10NS";
$lang['allowpostoptions'] = "aLL0W p0st ED1+in9";
$lang['postedittimeout'] = "p0S+ 3DI+ +1me0U+";
$lang['posteditgraceperiod'] = "p05+ ED1+ GR@ce P3R1od";
$lang['wikiintegration'] = "wik1w1KI 1NT3GR4+1ON";
$lang['enablewikiintegration'] = "en4BLE WiK1w1KI 1n+39RA+1oN";
$lang['enablewikiquicklinks'] = "eN48le w1k1wiKi quICK L1nk5";
$lang['wikiintegrationuri'] = "w1kIWIki L0C4T1oN";
$lang['maximumpostlength'] = "m@XIMUM p0ST LEn9+H";
$lang['postfrequency'] = "p0\$T PHREQUenCy";
$lang['enablelinkssection'] = "eN48LE l1NKS S3c+1ON";
$lang['allowcreationofpolls'] = "alLOW cR34+1oN OF poLls";
$lang['allowguestvotesinpolls'] = "alL0W 9U3sT\$ +0 VOT3 in P0LLS";
$lang['unreadmessagescutoff'] = "uNr3@D m3\$S4g3S Cu+-0FF";
$lang['disableunreadmessages'] = "d1SABL3 uNR3AD mE\$S4G35";
$lang['thirtynumberdays'] = "30 D4Y\$";
$lang['sixtynumberdays'] = "60 D4YS";
$lang['ninetynumberdays'] = "90 dAYS";
$lang['hundredeightynumberdays'] = "180 d4ys";
$lang['onenumberyear'] = "1 y34R";
$lang['unreadcutoffchangewarning'] = "d3p3nDINg ON \$3Rv3r PERfORM4NC3 4ND +3H nuM83R 0F ThR34DS YouR F0RUM5 C0N+AIn, Ch@N91nG Th3 uNr3ad CUt-OFF M@Y +4K3 5EVEr4L m1nU+es TO c0MPLe+3. FOR thI5 R3ASON 1T 1S reCOMmeNDED tH@T j00 @VOiD CHAnGIng ThIS S3TTiNG wh1LE YOUr PhoRUMS 4rE 8U\$Y.";
$lang['unreadcutoffincreasewarning'] = "iNcrEA\$1NG teH UnRE4D cUT-0fpH W1LL reSULT 1N +HRe4dS OLDEr TH4N +Eh CUrreNT CUt-0fF APpeAR1N9 @5 uNR34D phoR @lL US3R5.";
$lang['confirmunreadcutoff'] = "arE j00 SUR3 J00 W4NT +o CH4n9E The UNRE4D cu+-0PHF?";
$lang['otherchangeswillstillbeapplied'] = "clickIng 'NO' w1LL 0Nly C4NCel TEH uNR3@D cUT-OFF CH4NG35. oTH3r CH@ng3s YOU'V3 M@dE WIll \$+1LL 83 \$4vED.";
$lang['searchoptions'] = "se4rCH opt1ON\$";
$lang['searchfrequency'] = "sE4rCH PhrEQUenCY";
$lang['sessions'] = "sess10Ns";
$lang['sessioncutoffseconds'] = "s3\$5ioN cu+ 0PHF (S3CONDS)";
$lang['activesessioncutoffseconds'] = "aC+IVe \$3\$SION cUT OfpH (s3CONd\$)";
$lang['stats'] = "s+4T5";
$lang['hide_stats'] = "hId3 \$T@tS";
$lang['show_stats'] = "sh0W \$tA+S";
$lang['enablestatsdisplay'] = "enaBLE ST@TS d1\$pL@y";
$lang['personalmessages'] = "p3rsON4L m3ss4G3s";
$lang['enablepersonalmessages'] = "en@blE PERSONAL mESSAGes";
$lang['pmusermessages'] = "pM M3\$S49e\$ p3r USER";
$lang['allowpmstohaveattachments'] = "allOW PerSONAL me5\$49e\$ +0 H4ve @Tt4CHMENTS";
$lang['autopruneuserspmfoldersevery'] = "auT0 PRUNe uSER'S pM PHOldEr\$ 3VERY";
$lang['userandguestoptions'] = "u53R @nD gUesT OP+10N\$";
$lang['enableguestaccount'] = "en@8lE Gu3\$T 4CC0UN+";
$lang['listguestsinvisitorlog'] = "lisT 9u3sT5 IN vi\$i+0R LOg";
$lang['allowguestaccess'] = "aLLoW GUEST 4CCESS";
$lang['userandguestaccesssettings'] = "usER @nD GUE\$t ACCess \$3+TINGs";
$lang['allowuserstochangeusername'] = "aLloW USeR\$ +0 cH4N93 UsERn4mE";
$lang['requireuserapproval'] = "requIR3 U\$3R AppRovAl BY 4dmin";
$lang['requireforumrulesagreement'] = "r3quIRE us3r TO A9R33 +0 PH0Rum RULE\$";
$lang['sendnewuseremailnotifications'] = "send NOTIphIC4+1oN TO 9LoBAl F0RUM 0wN3R";
$lang['enableattachments'] = "eN4BL3 AT+ACHMEn+s";
$lang['attachmentdir'] = "aTT4CHmeN+ diR";
$lang['userattachmentspace'] = "att@CHM3Nt sP4CE peR US3r";
$lang['allowembeddingofattachments'] = "aLL0W 3M8eDD1NG of A+TACHM3N+S";
$lang['usealtattachmentmethod'] = "usE @l+3rN4+1VE 4+T4CHMEn+ ME+h0d";
$lang['allowgueststoaccessattachments'] = "aLLoW 9UES+S +0 Acc3\$\$ 4+t4CHMenTs";
$lang['forumsettingsupdated'] = "fORUM s3++1NG5 \$UccESSFUllY uPD@+3D";
$lang['forumstatusmessages'] = "foruM \$+@TUS M3\$s4G3S";
$lang['forumclosedmessage'] = "f0ruM clOSED m3Ss49e";
$lang['forumrestrictedmessage'] = "f0rUM R3S+riCT3D MES\$@GE";
$lang['forumpasswordprotectedmessage'] = "forum P@SSwORD pr0T3CT3d ME\$S493";

// Admin Forum Settings Help Text (admin_forum_settings.php) ------------------------------

$lang['forum_settings_help_10'] = "<b>post 3d1+ TiME0UT</b> 1\$ +eh TIME IN miNU+3\$ 4PH+er P0sTIn9 +h4T 4 USer CAn eDI+ +HeIR P05+. 1F \$Et +0 0 Th3rE i\$ N0 LIm1t.";
$lang['forum_settings_help_11'] = "<b>m4ximUM P0ST Len9+H</b> I\$ +h3 M@xiMUM NUmb3R 0F Ch4r4C+3R\$ TH4+ WiLL BE di5PL@YEd IN 4 PO5+. 1f 4 PO\$T 1\$ LONger +han T3H nUMBer OF Ch4rAC+3RS Deph1n3D HErE It w1LL 8e CUT \$hor+ @ND @ LinK 4Dd3d T0 +3h BO++OM tO @LloW USeR\$ +0 reAD t3H Wh0le Po5t 0N 4 \$3paR4TE P4G3.";
$lang['forum_settings_help_12'] = "iph J00 D0N't W@N+ y0UR U\$3RS to 83 @Bl3 +0 CR3ATE p0lL\$ J00 c4n Dis4BLE th3 48OVE 0pt10N.";
$lang['forum_settings_help_13'] = "t3h L1NKS SecTI0N of 833HIV3 pr0v1DE5 4 PL@C3 F0R yoUR us3r\$ +0 M41n+4IN @ l1\$T 0PH S1T3\$ +h3Y PhR3QU3NTlY VIS1T Th4+ 0+HEr U\$3RS M@y F1ND USEPHul. lINKs C@n 83 DiV1DED iN+o C4TEG0ri3s 8Y ph0Ld3r aND All0W F0R coMM3N+S @ND r4+1NG\$ +O 8E gIV3N. iN oRd3r tO MOdeRaTE +H3 L1Nks S3c+1oN 4 US3R mUS+ be r4n+3D Gl084L MoDER4+0r sT@TUS.";
$lang['forum_settings_help_15'] = "<b>s3S51oN CU+ OfpH</b> 1\$ +H3 M4XImuM T1ME 83pH0RE @ USER's \$3\$S10n 1\$ d3eMeD D34d 4ND +H3Y AR3 lOGGED oU+. by DEF4ulT Thi\$ IS 24 H0UR\$ (86400 \$ECondS).";
$lang['forum_settings_help_16'] = "<b>aCtIV3 SE\$S10n cuT OFf</b> is ThE M4XIMUM +1m3 BEf0R3 4 user's \$3sS10n IS d3EmeD 1NAct1Ve 4+ WH1CH P01N+ +heY 3nTer 4n idLE \$+4T3. In Th1\$ s+4+3 +h3 U53r r3M41N\$ loGged 1N, bU+ +h3y 4rE r3mOv3D fR0m tEh 4cTIVE usEr\$ Lis+ IN +3H ST4+S dISPL@Y. 0nCe +HEy 8EC0M3 4C+IVe 4GaIN THey W1Ll B3 RE-@DD3D +0 +He L1ST. 8y D3FAULT +hI\$ sE++1NG 1S \$3+ +O 15 m1NUTES (900 s3C0Nd\$).";
$lang['forum_settings_help_17'] = "eNaBL1NG +HI\$ 0PT10N ALloWS 8e3hIvE t0 IncLuDE A Sta+s d15PL@y 4T +H3 8OTtoM OpH +3H MES\$@9ES p@Ne SIm1L4R T0 +h3 ON3 us3D 8Y m4Ny Ph0RUm SOF+WaR3 +1Tl3\$. 0NC3 3N@8LeD +H3 DisPL@y Of +eH S+a+S P4Ge C@N B3 +OG9leD INd1V1Du4LLY 8Y 34cH U\$3R. iF tH3Y D0N'T W@n+ +O S3E I+ +H3y C4n HId3 1T pHR0M VIEW.";
$lang['forum_settings_help_18'] = "p3Rs0N4L ME\$S@GEs @r3 INv4lU4BLe 4s @ wAY of T@k1n9 MOr3 PR1V4+3 MaTT3r\$ 0UT oF vI3W of +HE 0TH3R mEMB3RS. hOWEv3r if J00 D0N'T W@N+ Y0UR u53R\$ +0 83 48Le t0 S3ND 3AcH OtH3R P3R\$ONAL Mes\$4GE\$ J00 C4N DI\$@bL3 +h1\$ 0P+10N.";
$lang['forum_settings_help_19'] = "per5oN4L m3SS@ge\$ C4N 4LSo C0Nt4iN 4t+@chm3n+S WhiCH can 8E usEFul F0R ExcHaNGiNG Fil3s B3TWEEn uS3RS.";
$lang['forum_settings_help_20'] = "<b>note:</b> ThE \$p@Ce AlL0C4+10N pH0R pM at+4chM3N+S 15 T4K3N frOM E@ch Us3rs' m41N 4+T4ChMENT 4lLOc@+1ON @ND 1s N0T 1n 4DD1+1oN +0.";
$lang['forum_settings_help_21'] = "<b>eN48LE gUESt 4CCOUn+</b> aLl0wS v1S1T0RS +o 8ROWS3 Y0UR pHoruM and rE@d P0\$+S wI+hOUt RE91stEr1NG A U5Er 4CCOUnt. A US3R @cCOUNt i\$ S+1LL rEQU1rED 1Ph +h3y WI5H T0 P0ST oR cH4N9E USEr Pr3f3R3NC3\$.";
$lang['forum_settings_help_22'] = "<b>l1St 9UES+S iN V1S1TOr L0G</b> @LL0WS j00 +0 SPeCIPhY wH3+H3R oR n0T unREG1\$T3RED u\$3RS aR3 L1s+3d 0N +h3 VisI+0R l09 4LONg S1D3 R39I\$t3rED u\$ers.";
$lang['forum_settings_help_23'] = "be3h1v3 @ll0W\$ 4TT4CHmeNts T0 8E UPl0@D3D +0 Me5S@93s WH3N pO\$+3d. IPh j00 H@ve L1mITed wEB 5P4ce J00 May Wh1cH +O D1\$a8le @+T4CHm3N+5 by Cl34r1n9 TH3 b0x 480ve.";
$lang['forum_settings_help_24'] = "<b>aT+4cHM3n+ d1r</b> is +eh L0Ca+10N b33H1VE \$HouLD \$TOre i+'\$ At+acHMEnTS In. +H1\$ d1r3C+0rY MUS+ 3X1\$T On Y0uR WEB SP4CE 4nd Mus+ 8E wR1T48LE 8y th3 WeB \$3rV3R / PhP Pr0C3SS OtHERwI\$3 uPLO4D\$ WiLL PH41L.";
$lang['forum_settings_help_25'] = "<b>at+@cHMEn+ SP4CE P3R usEr</b> IS +3h M4XIMuM 4MOunT 0f Di\$k Sp4C3 4 US3R H@S Ph0R 4+T@CHmENtS. 0nce +HIS SP@cE 1\$ u\$3D Up +H3 u\$3R cANn0t UPlO4D 4NY m0R3 4+t@Chm3NT\$. 8Y DefAuLT Th1s 1\$ 1m8 0F SpaCE.";
$lang['forum_settings_help_26'] = "<b>aLLOW em8EDd1N9 OF 4TT4Chm3NTs 1N m3\$SAgES / S1GnA+ur3s</b> @ll0W\$ US3Rs TO EMBEd 4Tt4cHm3n+S 1N P0\$+s. ENAblIN9 tHIS oPtI0N wh1Le US3PHuL C@n 1NCrEA\$e y0Ur BaNDW1D+H Us493 DR4STiC@LlY unD3R c3R+@1N c0NPhiGuR@+i0NS oF PhP. IPh J00 H4V3 l1M1TEd B4NDwIDTh 1+ iS reC0MmENd3D +h@T J00 DisAbLe +HiS 0PTioN.";
$lang['forum_settings_help_27'] = "<b>u\$3 4l+3RNa+1VE @T+4CHmENt M3th0d</b> pH0RCes BeEH1VE t0 US3 4N 4L+erN4TIvE r3+RiEVAL MEtHOd PHOr A++AcHM3N+s. 1Ph J00 ReCe1vE 404 3RR0R mE\$SAGes wHEN +rYiNG TO doWnLO4D 4+T4chmENts PhROm M3Ss49ES +ry eNA8L1n9 +h15 0P+10n.";
$lang['forum_settings_help_28'] = "tH3SE S3ttIN9\$ 4LL0W\$ yOUr FOrUM +0 83 \$PidEred BY s34rch EN9In3s L1KE G0OGL3, @L+4VIS+@ 4ND y@HO0. IF J00 sW1+Ch TH1S 0P+10N opHph YouR f0RUm W1LL no+ b3 INclUD3D iN +H3\$3 \$34RcH 3n9IN3\$ rESUlTS.";
$lang['forum_settings_help_29'] = "<b>aLlOW neW U\$3r rE91sTRa+1ON\$</b> @llOW\$ OR dIS4LloWs +he CR34tION of n3W U5ER ACcoUN+s. SE++1NG +eH opT10N to NO c0mpL3+Ely d1s48lES +H3 R3G15+RAt10n phORM.";
$lang['forum_settings_help_30'] = "<b>eN4bL3 w1K1w1k1 In+3GR4+1ON</b> pR0VId3\$ w1K1W0Rd sUPp0rT iN Y0UR PH0RUM poSTS. @ wiKIw0RD is m4d3 uP Of +Wo 0r M0Re CONc@+3N4T3D W0Rd\$ W1TH uPp3RC@\$3 L3+TERS (OF+3N R3FERr3d +O as C@m3LC4s3). Iph J00 WR1+e A WORD +h15 W4Y IT W1LL 4u+OM4+1C@LLY BE CH@Nged INTo 4 HYpeRLINk P0IN+1N9 +0 YOuR cHO\$3n WikIW1kI.";
$lang['forum_settings_help_31'] = "<b>en48LE w1KIW1ki qU1CK l1NK\$</b> 3N@8LeS +3H U\$E oF MsG:1.1 4Nd US3R:LO9ON \$tYLE 3XTeNDed W1K1liNks WhICh Cr3@Te HYp3rLiNK\$ +0 +3H SPEciPhI3D M3\$\$493 / US3R PR0FiL3 0Ph ThE 5PEc1pHIeD uS3R.";
$lang['forum_settings_help_32'] = "<b>wikIw1KI LOc@tiOn</b> 1\$ U\$3d +o \$peCiFY +eH uRI 0Ph y0uR wIKiW1K1. wHEN 3Nt3RiN9 Th3 Ur1 us3 <i>%1\$S</i> T0 1ND1c4t3 WHEre in +HE ur1 +He W1KIw0rD sH0ULD APp34R, 1.3.: <i>h+tp://3N.wIK1PEd14.0r9/wIKI/%1\$S</i> w0ulD lINk YOUr WIk1w0RDS t0 %s";
$lang['forum_settings_help_33'] = "<b>f0rUm 4CC3sS sT@tus</b> C0n+r0L\$ HOw U\$3RS m4y AccESS y0uR FoRUM.";
$lang['forum_settings_help_34'] = "<b>opeN</b> WilL 4LLoW 4LL u\$3R\$ 4ND 9UEs+S 4cC3Ss +o Y0UR f0RUM wI+hOU+ R3S+r1C+I0N.";
$lang['forum_settings_help_35'] = "<b>clOS3D</b> pR3vEnT5 4cCESS f0R @Ll UsER\$, W1TH +3H 3XceP+1ON 0PH T3H ADM1N Wh0 M@Y StilL 4cC35s THE @dMIN P@NEL.";
$lang['forum_settings_help_36'] = "<b>re\$TrICt3d</b> 4LL0W\$ +0 S3+ 4 L1S+ 0F USeR\$ wHO ARe 4LLOw3d 4CCes\$ T0 y0UR F0RUM.";
$lang['forum_settings_help_37'] = "<b>p45sWORd Pr0teC+3d</b> 4lLOwS J00 +O SE+ 4 p4sSW0Rd TO 91V3 OU+ TO US3R\$ S0 theY c4N 4Cc3ss YOUr PhORuM.";
$lang['forum_settings_help_38'] = "wh3N S3++1n9 ResTR1cT3D oR p4\$sw0rD prO+ec+3D M0d3 j00 W1LL NEEd +0 S@vE y0UR cH4N935 83PhoR3 j00 C4N CHANG3 the u\$3r @cC3\$S pr1viL39ES OR PASsWORD.";
$lang['forum_settings_help_39'] = "<b>Search Frequency</b> defines how long a user must wait before performing another search. Searches place a high demand on the database so it is recommended that you set this to at least 30 seconds to prevent \"search spamming\"fR0m kiLl1NG th3 5ERvEr.";
$lang['forum_settings_help_40'] = "<b>poST fReqU3Ncy</b> i\$ +3h mIn1MUM tImE 4 U\$eR mUS+ W@it 8epHor3 +heY C4N po\$+ @g4iN. +h1S setTiN9 @L5o 4fphect\$ th3 CReA+i0N of pOLl\$. s3+ +O 0 +o dI5@BLe +3H r3s+rIcti0N.";
$lang['forum_settings_help_41'] = "tH3 48oVE 0p+IOn\$ cH@N9e +h3 Def4UL+ V4LU3S f0r +3H UseR rE9I\$+R4TIon f0RM. WHerE 4PpLIc@ble O+hER S3+T1Ng5 WIlL Us3 +H3 F0RUM's 0Wn DEF4Ul+ \$3+TIng\$.";
$lang['forum_settings_help_42'] = "<b>pr3VEnT usE of DUplic4+3 Em@1L AdDR3SS3S</b> f0Rc3\$ 8E3H1Ve +0 CH3Ck ThE usER @cC0UNt\$ Ag41N\$T TEh 3M@iL aDDrESS +H3 U5ER IS rE91STErInG With 4ND PROmP+\$ +HeM +0 Us3 4NO+H3R 1Ph i+ 15 4lr3@Dy In US3.";
$lang['forum_settings_help_43'] = "<b>rEqUiR3 EM@1L C0NphiRm4TI0N</b> wHEn En@BL3D w1LL sEnD 4N Em@Il TO e4cH n3w U\$3R WI+H A L1NK +H4+ c4N 83 U\$eD +o C0NPHIrm tHE1R 3m4IL @dDResS. UN+IL TheY CONF1Rm ThE1R em4iL 4Ddr35S Th3y WILl noT 83 4BLE t0 PO\$+ UnlESS +h3IR u\$3R P3Rm1ssIONs 4R3 CH4n93D M4nu@LlY bY 4N aDMIN.";
$lang['forum_settings_help_44'] = "<b>usE +3xT-CaPTchA</b> pRES3N+s t3H NeW US3r W1+H 4 M4N9LEd Im49E wHICH +H3Y MusT c0PY @ NUMb3r PhROm 1N+0 @ TexT pHi3lD 0N TH3 re91sTRa+1ON ForM. US3 ThI\$ 0P+10N +O prEVen+ 4U+0ma+3D \$1GN-UP v14 SCrIP+S.";
$lang['forum_settings_help_47'] = "<b>p05+ 3D1+ 9R4c3 PeR1OD</b> AlLow5 J00 +0 DePH1N3 A PER1oD in mINu+Es wh3RE us3R\$ M4Y 3DIt P0\$+S W1+h0UT T3H '3D1T3D By' +3xT 4pP3@r1NG 0n +HeIR p0sTS. if \$3+ +0 0 +3H '3DI+3D bY' TExt w1lL @lW4YS @PPe4r.";
$lang['forum_settings_help_48'] = "<b>unr34d M3\$S@G3s CUT-OFF</b> SPeCIfIE5 hOW l0N9 mESS4G35 rEM4In UNre4D. THr34DS M0Dif1ED N0 L@teR tH4N +eH P3r1oD \$3L3C+3d WiLL @UTom4+1C4LlY 4PP3aR @\$ R34D.";
$lang['forum_settings_help_49'] = "cHo0sINg <b>di\$@bLe UnR34D m3SS4G3s</b> WIlL coMPl3+3Ly REm0ve UNrE4D MesSAG3\$ \$uPPOr+ 4ND REmoV3 +H3 rel3V4NT 0P+I0N\$ FROM tEh DisCUss1oN +YP3 dR0P DoWN on TH3 tHR34D lis+.";
$lang['forum_settings_help_50'] = "<b>reqUIRE us3R aPPrOV4L 8Y @dMin</b> 4Ll0w\$ J00 +0 RES+RIC+ @Cc3\$5 8Y n3W Us3rS un+1L +h3Y H@vE 833N 4Ppr0V3D By @ moDeR4+OR 0R aDM1N. WI+HOu+ @pPrOV4L @ USeR C4Nno+ 4CcEsS 4NY ARea OF +He 833HiV3 f0ruM INS+ALl@T1ON 1nClUDiNG inD1V1DU4L PH0RUms, Pm InBOX aND my PhORUms S3CTioN\$.";
$lang['forum_settings_help_51'] = "u53 <b>cLO\$eD mES\$@G3</b>, <b>r3\$TRiC+3D m3\$S@9E</b> 4ND <b>p4ssWORD PRoTEcT3D M3\$saGE</b> t0 CU\$+0M1SE tHE mES5@93 DI5pl@yeD wHEn uSERS 4cce\$S YOUr F0RUM 1N +3h v4rI0US \$tA+3\$.";
$lang['forum_settings_help_52'] = "j00 C@N U\$3 htML In YOUr M3\$S@9ES. hYpERl1NKs 4nD 3MAiL adDR3sSES wIll aLSO 83 4U+om4TIc@LlY ConV3RtED T0 L1NKs. to U\$3 TeH dEPh@ULt 8E3H1Ve F0RuM mESS4Ges Cl3aR +3H PHieLDS.";
$lang['forum_settings_help_53'] = "<b>alLOw US3RS TO ch4N93 US3rn4m3</b> PERm1tS @LReAdy Re9I\$t3rED USEr\$ +O CH4N93 th3IR USErNAmE. wHeN 3nA8L3D j00 C@n TrAcK TEh cH@n93\$ a US3R m@K3S t0 +h31R usErnAmE v14 +h3 4dMIn USEr tO0LS.";
$lang['forum_settings_help_54'] = "us3 <b>fORum ruL3S</b> +0 3N+3r 4N 4cC3P+a8L3 US3 POl1CY tH@t 3ACH u\$3r MUS+ 4GREe +0 8ePh0r3 REGisT3RInG on yoUR F0rUM.";
$lang['forum_settings_help_55'] = "j00 C4N u\$3 H+ML in y0Ur PH0rum rUL3S. hYPeRLinKS 4nD 3M@1L @DDreSSes w1LL 4lS0 83 @uTOM@TIc4LLY c0Nv3RTeD +0 L1Nks. TO u\$3 +h3 DEpH4uL+ B3EH1ve f0rUM aUP CLe4R ThE F13LD.";
$lang['forum_settings_help_56'] = "uS3 <b>n0-R3PLY 3m@iL</b> +o SPEC1pHY AN EM41l AdDRESS +h@+ Doe\$ N0+ ex1sT 0R w1LL NO+ BE m0NITOr3d f0R rEpL13\$. tHis 3MAIl AddRESs W1LL 83 U\$ed 1N +H3 He4D3rs PH0R aLl EMaiL\$ \$3NT frOM YOUr F0RUm INcLUdINg 8u+ n0+ L1Mi+ED +0 PO\$+ aND pM nO+1F1C4+1oNS, US3R 3m@iLS 4ND p@SSwoRD reMInderS.";
$lang['forum_settings_help_57'] = "it 1s R3C0mMeND3D TH4+ j00 USe @n EmaIL adDre\$S +h@+ d0eS No+ ex1\$T +0 h3lP Cu+ D0WN On SP4m +hA+ m4y 8E D1R3CTED @+ Y0UR main F0rUM 3M@iL 4DDrE5S";
$lang['forum_settings_help_58'] = "in @dDITi0N +O simPlE SP1DERIN9, 8eEh1V3 C4N 4lS0 9EN3R@Te 4 SI+em@P Ph0r T3H f0ruM +0 M@KE iT 3@sI3R F0r S3aRCH En9iNES +0 PHiND @nD IND3X +3H m3SS@93s P0\$t3d 8Y YOur U\$ERS.";
$lang['forum_settings_help_59'] = "s1+EM@p\$ 4Re 4uTOm4+1C4LLy S4V3D +o tHE \$1TEm4pS sUb-D1rECT0RY OF y0uR 833H1V3 PHorum 1N\$T@LL4TI0N. IF +h1\$ d1rEc+0RY doeSN't 3X1\$T J00 MU\$t cre4T3 1+ 4ND 3n\$Ur3 +h@t 1T 1s WRI+48lE by th3 S3RVER / PhP PRocESS. +O @lLoW s3ARcH 3N91N3\$ +0 F1ND yoUR s1TEM4P j00 MUs+ add +3h URL +0 Y0UR r08OTS.TX+.";
$lang['forum_settings_help_60'] = "dePENd1nG 0N S3rV3R pERPhORMaNC3 4ND THE NUmB3R Of FORumS 4ND +HReADS y0uR 833HIV3 IN5+@LlA+10N c0n+AInS, 9EN3R4+1N9 4 \$itEM4P M4y T@K3 S3VER@l mINUt3s +0 C0MpLETe. iPH perF0RM@nC3 0F youR SErVER 1\$ @dV3RSLy 4fFec+3D I+ 1S rEC0MM3ND j00 DISable Gen3R4+1ON 0pH THe sI+3M@p.";
$lang['forum_settings_help_61'] = "<b>senD emAil noPh1+iC4T1ON +0 9LO8@L 4dM1N</b> wH3N 3N4BLEd W1LL S3nD @n EM@iL +o t3H 9LO8@l F0RUm 0WNEr5 Wh3n 4 n3W us3r @Cc0uN+ IS CRE4+3d.";

// Attachments (attachments.php, get_attachment.php) ---------------------------------------

$lang['aidnotspecified'] = "a1d N0T spEc1PH13D.";
$lang['upload'] = "upL0@D";
$lang['uploadnewattachment'] = "uplO@D NEw 4+T@CHmeN+";
$lang['waitdotdot'] = "w@1+..";
$lang['successfullyuploaded'] = "sUCC3sSFUlLY upl04D3D: %s";
$lang['failedtoupload'] = "f41lED t0 UPl0@D: %s";
$lang['complete'] = "c0mPLE+E";
$lang['uploadattachment'] = "upL0@D 4 f1L3 ph0r @tT4CHm3n+ +o +H3 M3\$S@GE";
$lang['enterfilenamestoupload'] = "eN+3R f1l3N@Me(\$) T0 UpLO@D";
$lang['attachmentsforthismessage'] = "att4CHm3n+\$ FOR +H1S m3s\$aG3";
$lang['otherattachmentsincludingpm'] = "o+h3r @+t@CHm3nTS (1nClUDIn9 PM MES5@Ge\$ 4nD O+h3R PhoRUMS)";
$lang['totalsize'] = "to+AL s1Z3";
$lang['freespace'] = "freE \$p4cE";
$lang['attachmentproblem'] = "th3Re W4S 4 prOBLEM d0wNlo4D1NG tH1s 4TT@CHM3Nt. PL3A\$3 +RY AgAIN LA+3r.";
$lang['attachmentshavebeendisabled'] = "aT+@ChmeN+S h4v3 BE3n DIS48LEd BY +3H F0RUm 0WN3R.";
$lang['canonlyuploadmaximum'] = "j00 c4N 0NlY uPLO4d 4 M4XimUm OF 10 PhiL3S aT a TiMe";
$lang['deleteattachments'] = "dELEtE @Tt4cHmeN+s";
$lang['deleteattachmentsconfirm'] = "ar3 j00 SuRE j00 W4nT TO D3lE+3 tEh Sel3C+3d 4Tt@ChM3N+s?";
$lang['deletethumbnailsconfirm'] = "aRe j00 5uRe J00 W4N+ +0 D3Le+3 The \$3lEC+ED @TT4chMENtS +HUm8naILS?";

// Changing passwords (change_pw.php) ----------------------------------

$lang['passwdchanged'] = "p4\$sWORD CH4N9ED";
$lang['passedchangedexp'] = "y0ur P4\$SW0RD h@S 83EN cH4N9ED.";
$lang['updatefailed'] = "updA+3 fAiLEd";
$lang['passwdsdonotmatch'] = "p4SSWOrDS DO n0+ m4+Ch.";
$lang['newandoldpasswdarethesame'] = "nEw 4ND 0Ld P4SSWoRDs Are Th3 \$@M3.";
$lang['requiredinformationnotfound'] = "r3qUIRed iNFORm@Ti0n N0+ FOUnd";
$lang['forgotpasswd'] = "fOr90T p4s5W0Rd";
$lang['resetpassword'] = "rE\$3+ p4sswORd";
$lang['resetpasswordto'] = "r3\$e+ P@\$swoRd To";
$lang['invaliduseraccount'] = "iNV4L1D U\$3R @ccOUn+ SpeCIf1ED. cHEcK Em41L For COrR3CT L1NK";
$lang['invaliduserkeyprovided'] = "iNV@l1d US3R k3Y PRoV1D3D. CH3CK 3m@1L f0R c0RrEC+ l1NK";

// Deleting messages (delete.php) --------------------------------------

$lang['nomessagespecifiedfordel'] = "n0 M3ss@gE sP3CIpH1ED fOR d3L3+10N";
$lang['deletemessage'] = "delE+3 MeSS493";
$lang['successfullydeletedpost'] = "sUcC3\$SPhuLlY d3L3+3D pO\$t %s";
$lang['errordelpost'] = "erroR d3LE+1N9 p0\$T";
$lang['cannotdeletepostsinthisfolder'] = "j00 C@nN0T D3le+3 PosTS 1N +hIS f0Ld3r";

// Editing things (edit.php, edit_poll.php) -----------------------------------------

$lang['nomessagespecifiedforedit'] = "n0 ME\$s@Ge Sp3CIf13D phoR 3DI+1n9";
$lang['cannoteditpollsinlightmode'] = "c4nNO+ EDi+ POLls 1N L1GH+ m0dE";
$lang['editedbyuser'] = "edi+3D: %s BY %s";
$lang['successfullyeditedpost'] = "suCCE\$SFULlY edI+3D p0\$+ %s";
$lang['errorupdatingpost'] = "eRr0r uPd@tIN9 p0sT";
$lang['editmessage'] = "eDi+ me5sA93 %s";
$lang['editpollwarning'] = "<b>nOt3</b>: eDi+1N9 CeRT@in 4spEC+S 0F 4 P0lL wILL v01d 4LL the CuRR3N+ VO+es anD 4Ll0W p3oPLE t0 Vo+3 4G@iN.";
$lang['hardedit'] = "h4RD 3D1+ OpT1oNS (v0TE\$ WIll BE r3\$3t):";
$lang['softedit'] = "soPht EDI+ 0p+10n\$ (vo+e\$ W1ll b3 Re+@1NEd):";
$lang['changewhenpollcloses'] = "ch4N9e wHEn T3h polL Clos35?";
$lang['nochange'] = "n0 CHanGE";
$lang['emailresult'] = "eM@1L R35ul+";
$lang['msgsent'] = "m3\$S@g3 s3n+";
$lang['msgsentsuccessfully'] = "me\$s49E SEnt SUcC3SsphulLy.";
$lang['mailsystemfailure'] = "m41l Syst3M pH@1LURe. Me\$\$49E n0t SEn+.";
$lang['nopermissiontoedit'] = "j00 4RE No+ peRmI++3D +0 3D1t tH1\$ ME\$S@ge.";
$lang['cannoteditpostsinthisfolder'] = "j00 cANnot Ed1T p0\$tS 1N thI\$ FOlD3R";
$lang['messagewasnotfound'] = "mEss4g3 %s W4\$ N0+ F0unD";

// Email (email.php) ---------------------------------------------------

$lang['sendemailtouser'] = "s3ND 3M41l TO %s";
$lang['nouserspecifiedforemail'] = "n0 U\$3R \$PeCIFi3D F0R eM41Lin9.";
$lang['entersubjectformessage'] = "eN+3R A \$UBJEct foR th3 ME\$\$493";
$lang['entercontentformessage'] = "en+3R \$0ME coNT3Nt PHoR t3H MESS4G3";
$lang['msgsentfromby'] = "tHi\$ MESSag3 Was \$3n+ FR0M %s 8Y %s";
$lang['subject'] = "sUBJ3C+";
$lang['send'] = "s3nD";
$lang['userhasoptedoutofemail'] = "%s HAs 0P+3D 0Ut OF EMAil C0N+4C+";
$lang['userhasinvalidemailaddress'] = "%s ha\$ 4n 1Nv@L1D eM41L @dDR3SS";

// Message nofificaiton ------------------------------------------------

$lang['msgnotification_subject'] = "m3\$S4g3 N0TiFIc4T10N fr0M %s";
$lang['msgnotificationemail'] = "h3ll0 %s,\n\n%s POsTEd 4 ME\$S49E +0 J00 On %s.\n\n+HE \$UBjEC+ is: %s.\n\nto R34d TH4T m3\$S4G3 AnD 0+h3RS 1n +eh \$aME d1\$cu5\$10n, G0 t0:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nNOTe: 1PH J00 DO NO+ wISh T0 RecEIV3 3mAiL no+IfiC4TI0ns 0F FOrUm MEssAGE\$ p0sT3D +0 YOU, g0 +O: %s cLIcK 0n my COn+R0LS +h3N eMaIL @ND pR1V@cy, uN\$3LEct tHE 3MaiL n0+1PhiC4T10N ch3cKB0X @nD Pr3\$S 5UBM1+.";

// Thread Subscription notification ------------------------------------

$lang['threadsubnotification_subject'] = "suB\$CRIp+1on NO+iFIc4tI0N pHROm %s";
$lang['threadsubnotification'] = "hElL0 %s,\n\n%s P0s+3d 4 mESSaGE IN 4 tHR3@d J00 H4Ve \$U8\$crIb3d t0 0N %s.\n\n+h3 SUbjEc+ IS: %s.\n\nt0 re4D +h4t M3S\$@93 4ND 0THerS iN +3H S@m3 D1ScuSS1ON, 9O T0:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nn0+E: IF J00 do N0T W1\$h +O rECe1v3 eMAil no+IpHIc@TI0N\$ Of new MESs49eS 1N th1s tHR3AD, 90 To: %s @ND ADJusT y0ur iNTeR3ST lEVEl @+ +3H B0++0M 0F +h3 P@ge.";

// PM notification -----------------------------------------------------

$lang['pmnotification_subject'] = "pM NO+1F1C@tI0N from %s";
$lang['pmnotification'] = "h3ll0 %s,\n\n%s P0\$t3D a Pm +0 j00 0N %s.\n\n+h3 \$UbJEcT I5: %s.\n\n+0 ReAD tHE MESs@ge 9O +o:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nNO+3: 1F J00 DO no+ WI\$h +0 r3CEIv3 3M@1L NO+iFIc4+IOn\$ 0F n3W PM MES549ES poS+3D +0 Y0U, 90 T0: %s Cl1Ck My C0N+roL\$ +H3N em41L @nD PRiV4Cy, uNS3L3CT tEH pm N0TIfic4+10N cHECk80x @nd PResS SUbMI+.";

// Password change notification ----------------------------------------

$lang['passwdchangenotification'] = "p@SsW0Rd CH4N9E n0T1PHiC@tI0N pHRom %s";
$lang['pwchangeemail'] = "heLlO %s,\n\ntH1\$ @ N0+1F1C@t10n 3MAil to 1NF0RM J00 +h@T y0UR p4\$SWoRD on %s H@s Be3N ChANgeD.\n\n1T H4\$ 833N Ch4n9ED t0: %s 4nd W@S Ch4N9ED bY: %s.\n\nif J00 H4vE R3CeiV3D THi\$ em@IL 1n ERROr OR WERe NO+ exp3C+1ng A CH@NGe +0 Y0UR p4S\$woRD Pl3@S3 C0N+@CT tHE pHOrUM OwN3R 0R A MOd3r4TOr 0N %s Imm3D1ATEly +o coRR3C+ 1+.";

// Email confirmation notification -------------------------------------

$lang['emailconfirmationrequiredsubject'] = "em41L c0NF1RmA+i0N R3QuIREd F0R %s";
$lang['confirmemail'] = "heLL0 %s,\n\ny0u r3c3NTlY cR34T3D a N3W u\$3R @CC0UNt On %s.\n\nb3fORE j00 C@N S+@R+ pO\$T1NG w3 NEed To C0NF1Rm YOuR EmaIl AdDRE5s. D0n'+ w0rRY tHI\$ IS qU1+E e4sY. 4LL J00 NeeD +0 do 1S CliCK tHE l1NK 83LOW (oR COPy 4ND P4stE 1+ 1nt0 Y0Ur 8R0WS3R):\n\n%s\n\n0nCe C0Nf1rM@Ti0N 1\$ COmpl3+3 J00 M4Y l0giN ANd sT4R+ PO\$t1NG 1MM3DiaTely.\n\n1f J00 D1D n0t Cr3@TE 4 U\$er @Cc0unT On %s pLEASe AcCEP+ 0UR 4POlOGIes 4ND foRw4Rd +h1\$ EM@IL t0 %s s0 Th@+ THe \$0URcE 0Ph 1+ M4y b3 INvEST1G4+3D.";
$lang['confirmchangedemail'] = "hEll0 %s,\n\ny0U ReCEnTlY Ch4N9Ed YOuR eM@1L oN %s.\n\nB3F0RE J00 cAN \$T@R+ POS+1NG 4941n w3 NeeD +O CONf1rM Y0Ur N3W 3M@Il 4DdRE\$s. d0N'+ W0RrY THI5 IS qUiTE eA\$Y. aLl j00 NE3d T0 do 1\$ ClICk Th3 LInk 83L0W (0R C0Py 4Nd P@ST3 i+ iNtO yoUr BrOW5ER):\n\n%s\n\noNcE conpHIrM@tIOn 1\$ coMpL3+E J00 M4y C0N+1nU3 +0 u\$3 +h3 fORuM a\$ n0RM@L.\n\nIPh J00 wERE NO+ eXPEcTiNG tHi\$ EMAiL PHROm %s PLE@5E 4CC3p+ ouR 4P0LOg1ES 4Nd PH0rW@rD th15 eMAiL +O %s SO tH4T +H3 \$0URc3 OF i+ m@Y 83 Inv3S+IgA+Ed.";

// Forgotten password notification -------------------------------------

$lang['forgotpwemail'] = "h3lLO %s,\n\ny0U REque\$+3d +h1\$ E-m4IL PHROm %s 83C@Us3 J00 H4VE f0r90tT3N y0uR P@ssW0RD.\n\nCL1CK tH3 L1NK bELOw (0R c0pY @ND p45+3 1+ iN+0 y0UR Br0w53R) +o R3\$3+ yoUR p@SSWOrd:\n\n%s";

// Admin New User Approval notification -----------------------------------------

$lang['newuserapprovalsubject'] = "nEW us3r 4PPr0v4L no+1PhIC@+I0N FOR %s";
$lang['newuserapprovalemail'] = "Hello %s,\n\nA new user account has been created on %s.\n\nAs you are an Administrator of this forum you are required to approve this user account before it can be used by it's owner.\n\nTo approve this account please visit the Admin Users section and change the filter type to \"Users Awaiting Approval\"0R clICK +3H lINK 83LOW:\n\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nnOTe: 0+H3R @DMiNIStr4+ORs oN THIs FORuM wILL 4LS0 r3cE1VE THi\$ N0TIf1c@Ti0N 4ND M@y H@v3 4LReaDy @CTeD uP0N ThIS reQueST.";

// Admin New User notification -----------------------------------------

$lang['newuserregistrationsubject'] = "nEw U\$3r 4CC0UNT N0+1PH1C4TIOn F0R %s";
$lang['newuserregistrationemail'] = "h3lL0 %s,\n\n4 N3W u5ER @cc0uNt H@S b33N cR34t3D oN %s.\n\nTO v1EW +H1\$ uSEr @cCouN+ PLe4s3 Vi\$1+ +3h 4Dm1N us3RS sEC+10N @nD CLiCK ON +3H n3w USEr 0R ClICk +3H LiNK bEL0W:\n\n%s";

// User Approved notification ------------------------------------------

$lang['useraccountapprovedsubject'] = "u5eR @pPrOVaL No+1PHiC4T10N PH0R %s";
$lang['useraccountapprovedemail'] = "heLLO %s,\n\nyouR U\$eR @cC0uNT 4+ %s H4S 8E3n AppR0VED. j00 C4N L091N 4ND \$+@R+ pO\$TIng imMed14+LY by CLicK1N9 +HE L1NK B3L0W:\n\n%s\n\n1F J00 WerE No+ EXPEc+1N9 ThI\$ em@Il phROm %s pl34sE ACCEP+ 0uR aPOLOGieS 4ND FORw@Rd +hIS 3M41L TO %s \$O Th4+ +HE \$ouRcE OF I+ m4Y Be Inv3sTiG@TED.";

// Admin Post Approval notification -----------------------------------------

$lang['newpostapprovalsubject'] = "pOs+ apPROv4l NoTIf1C@t10n Ph0r %s";
$lang['newpostapprovalemail'] = "hELLO %s,\n\n@ nEW po\$+ H@\$ BE3N CR3A+ED 0N %s.\n\n4s J00 @R3 4 m0DER@tOR On ThiS Ph0rUM j00 4r3 REQuiR3D +o 4pPr0vE +H1s P0\$+ 83f0RE I+ C@n 83 R3@D 8y 0THer U\$3r\$.\n\nY0U C@n @ppROVe tHi\$ PO\$t 4ND 4nY O+HERs pend1NG 4pProV@l BY vISIt1n9 TEh @dM1N p0sT 4PProV@L s3c+10n 0F YOUR Ph0rUM Or BY CLiCK1NG TEH l1NK 83LOW:\n\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nNOTe: OthER 4dm1N1STR@t0RS oN +HIS fORUm wILL 4l\$O R3CE1VE +h1\$ N0TIfiC@+10n 4ND M4y H4V3 4lr3ADY @CtED uPON tH1S R3Qu3\$T.";

// Forgotten password form.

$lang['passwdresetrequest'] = "yOUR p4ssW0RD RESe+ r3QUes+ fR0M %s";
$lang['passwdresetemailsent'] = "p@sSWoRD re\$3+ E-M41l sENT";
$lang['passwdresetexp'] = "j00 sH0ULD sh0Rtly R3C31V3 4N 3-Ma1L c0nT41N1N9 1nSTRuc+I0NS phOR reS3T+1N9 YouR P@\$5wORD.";
$lang['validusernamerequired'] = "a v4liD useRNamE i\$ rEQU1rED";
$lang['forgottenpasswd'] = "fOr90+ p@\$SWoRD";
$lang['couldnotsendpasswordreminder'] = "couLD N0T \$eNd PA\$sWORd RemINd3r. PLe@s3 C0NT4C+ TEH f0RUM oWn3R.";
$lang['request'] = "r3qUE\$t";

// Email confirmation (confirm_email.php) ------------------------------

$lang['emailconfirmation'] = "eM41L C0NPh1RM4+1ON";
$lang['emailconfirmationcomplete'] = "tH4NK j00 FOr c0NF1Rm1N9 Y0Ur EMa1L @Ddr3SS. j00 m4y n0w Login 4ND ST@R+ pO\$+1N9 1MM3D14+3LY.";
$lang['emailconfirmationfailed'] = "eM4Il COnF1RM4Ti0N h4\$ pH@1LeD, pLe4s3 +rY 49AIn lA+3r. If J00 3NcoUnTEr +h1s erR0r MUl+1PlE +1M3S pl34s3 c0N+4C+ The FoRUm OWneR oR 4 mODeR4+0R fOR 4S\$1S+4NC3.";

// Links database (links*.php) -----------------------------------------

$lang['toplevel'] = "top L3VEL";
$lang['maynotaccessthissection'] = "j00 M4Y n0t @CCess THi\$ seCtI0N.";
$lang['toplevel'] = "t0P l3vEL";
$lang['links'] = "linK5";
$lang['externallink'] = "eX+3RN4L liNK";
$lang['viewmode'] = "vi3w M0D3";
$lang['hierarchical'] = "hI3R4rCh1c@L";
$lang['list'] = "lIST";
$lang['folderhidden'] = "th1s FOld3R IS hIDd3n";
$lang['hide'] = "h1D3";
$lang['unhide'] = "uNHIDE";
$lang['nosubfolders'] = "n0 SUBf0LDers 1N tHi\$ C4teG0RY";
$lang['1subfolder'] = "1 sUBf0lDeR 1N tHI5 C@T39oRY";
$lang['subfoldersinthiscategory'] = "su8PHOLDER\$ In THIs c@tEG0RY";
$lang['linksdelexp'] = "en+RIEs In 4 DelE+3d F0LD3r WiLL 83 M0VEd To tEH P@REnT pHOlD3R. ONly F0LdERS Wh1CH do n0+ cON+41N 5uBF0LDeRS mAY B3 DeL3TED.";
$lang['listview'] = "l1S+ VieW";
$lang['listviewcannotaddfolders'] = "c@nnOT @dd PH0Ld3r\$ 1n +hi\$ VIEw. Sh0WInG 20 3NTR13S 4T 4 +1M3.";
$lang['rating'] = "r@+INg";
$lang['nolinksinfolder'] = "no L1NKS iN +hI\$ F0LDeR.";
$lang['addlinkhere'] = "add l1nK hErE";
$lang['notvalidURI'] = "th4t 1\$ N0T 4 v4lId URi!";
$lang['mustspecifyname'] = "j00 Mus+ SpeCIpHY 4 NAmE!";
$lang['mustspecifyvalidfolder'] = "j00 MusT sPeCIFY 4 v4L1D F0LDer!";
$lang['mustspecifyfolder'] = "j00 Mus+ SpeCIPhY 4 FoLDeR!";
$lang['successfullyaddedlinkname'] = "sUCCESSpHULlY 4DD3d lINk '%s'";
$lang['failedtoaddlink'] = "f41l3D +o aDD l1NK";
$lang['failedtoaddfolder'] = "f41LEd +0 @DD F0Ld3r";
$lang['addlink'] = "aDd @ LInK";
$lang['addinglinkin'] = "aDDINg LInk 1N";
$lang['addressurluri'] = "adDR3\$S";
$lang['addnewfolder'] = "add 4 N3w ph0LdeR";
$lang['addnewfolderunder'] = "aDdinG N3W ph0lDEr UNd3R";
$lang['editfolder'] = "eD1+ f0lD3R";
$lang['editingfolder'] = "edi+1n9 F0Ld3r";
$lang['mustchooserating'] = "j00 Mus+ CH00\$3 4 R4T1NG!";
$lang['commentadded'] = "yOuR c0mMeNT w4\$ @DdED.";
$lang['commentdeleted'] = "cOMMen+ w@S d3l3TED.";
$lang['commentcouldnotbedeleted'] = "comMENT CouLD N0+ bE D3L3TeD.";
$lang['musttypecomment'] = "j00 MU5+ +YP3 4 CommEN+!";
$lang['mustprovidelinkID'] = "j00 MUS+ pR0ViDE @ L1NK 1d!";
$lang['invalidlinkID'] = "inv4LId LInk iD!";
$lang['address'] = "aDdR3\$S";
$lang['submittedby'] = "su8m1t+3D 8y";
$lang['clicks'] = "cL1ckS";
$lang['rating'] = "r4tINg";
$lang['vote'] = "v0te";
$lang['votes'] = "vo+ES";
$lang['notratedyet'] = "nOT RA+3d BY @NyoN3 Ye+";
$lang['rate'] = "r4T3";
$lang['bad'] = "b4D";
$lang['good'] = "gOod";
$lang['voteexcmark'] = "v0+E!";
$lang['clearvote'] = "clE4R Vo+E";
$lang['commentby'] = "cOMMEN+ bY %s";
$lang['addacommentabout'] = "aDD 4 C0mm3N+ 480UT";
$lang['modtools'] = "mODEr4tI0N +O0LS";
$lang['editname'] = "edi+ N4ME";
$lang['editaddress'] = "eDi+ 4DDR3ss";
$lang['editdescription'] = "ed1+ D3SCriPTIOn";
$lang['moveto'] = "m0v3 t0";
$lang['linkdetails'] = "linK d3+Ail\$";
$lang['addcomment'] = "aDD coMmENt";
$lang['voterecorded'] = "y0uR V0+3 H4s B33N reCORd3d";
$lang['votecleared'] = "y0uR VOt3 h4s B3EN Cle@R3d";
$lang['linknametoolong'] = "liNK n4M3 +00 LoNG. M4X1MUM 1\$ %s Ch4racTEr\$";
$lang['linkurltoolong'] = "linK UrL +O0 LoNG. m@XimUm i\$ %s CH4R4c+3r\$";
$lang['linkfoldernametoolong'] = "f0LD3R n@mE +OO loNG. M@x1muM LenG+H I\$ %s Ch4R4C+3R5";

// Login / logout (llogon.php, logon.php, logout.php) -----------------------------------------

$lang['loggedinsuccessfully'] = "j00 L0G9ED IN suCC3s\$FUlLY.";
$lang['presscontinuetoresend'] = "pReSS c0NT1NU3 +0 Res3ND foRm DA+@ 0R C4Nc3l +0 REl0@D p493.";
$lang['usernameorpasswdnotvalid'] = "t3H U\$3RN4M3 0R p@SSWOrd j00 \$uPPl1eD i\$ N0T VAl1D.";
$lang['rememberpasswds'] = "rem3mB3R pa\$\$W0rdS";
$lang['rememberpassword'] = "r3m3mb3r P4\$swORd";
$lang['enterasa'] = "en+3R 4\$ 4 %s";
$lang['donthaveanaccount'] = "d0N'+ h4vE 4N 4CC0UNT? %s";
$lang['registernow'] = "rE91\$T3R n0W";
$lang['problemsloggingon'] = "pR0bL3MS loGgiN9 On?";
$lang['deletecookies'] = "del3+3 CO0K13s";
$lang['cookiessuccessfullydeleted'] = "co0K1e\$ SUcCESSpHULlY del3+3D";
$lang['forgottenpasswd'] = "fOr90T+en y0uR P4s\$W0Rd?";
$lang['usingaPDA'] = "us1nG 4 Pd4?";
$lang['lightHTMLversion'] = "l19h+ HTmL VErsiON";
$lang['youhaveloggedout'] = "j00 H4VE LOgGED ou+.";
$lang['currentlyloggedinas'] = "j00 4RE cURr3N+Ly LoGGEd IN 4S %s";
$lang['logonbutton'] = "l0goN";
$lang['otherdotdotdot'] = "o+HER...";
$lang['yoursessionhasexpired'] = "y0uR SesS10N hAS exPIR3d. J00 WilL NEEd +O LogIN @G@IN +O c0NtINu3.";

// My Forums (forums.php) ---------------------------------------------------------

$lang['myforums'] = "my PHorUm\$";
$lang['allavailableforums'] = "all 4Va1l@bLE pH0RUMs";
$lang['favouriteforums'] = "f4v0uR1TE F0RuMS";
$lang['ignoredforums'] = "iGN0R3d foRUMs";
$lang['ignoreforum'] = "i9nOR3 F0RUm";
$lang['unignoreforum'] = "un1Gn0R3 F0Rum";
$lang['lastvisited'] = "l4st v1S1+3D";
$lang['forumunreadmessages'] = "%s uNReaD MES\$AGeS";
$lang['forummessages'] = "%s m3ss@Ge\$";
$lang['forumunreadtome'] = "%s unR3@D &quot;TO: M3&quot;";
$lang['forumnounreadmessages'] = "n0 UnRe4d M3\$s@gES";
$lang['removefromfavourites'] = "r3m0vE FR0M fAv0uR1Te\$";
$lang['addtofavourites'] = "add tO PHav0uR1+3\$";
$lang['availableforums'] = "av4Il@8L3 F0RumS";
$lang['noforumsofselectedtype'] = "tHER3 4r3 No PhoRum5 0PH tHE 5eLEcTED +YPe @V41l@BL3. pL3@SE s3L3CT A D1fFERenT +YPE.";
$lang['successfullyaddedforumtofavourites'] = "sUCC3SSFuLLY 4dDEd PhoRum +0 Ph4VOURi+3s.";
$lang['successfullyremovedforumfromfavourites'] = "suCcE5sPHullY r3m0V3D F0RuM PhroM pH4vouRi+ES.";
$lang['successfullyignoredforum'] = "sucCE\$SPHULLy 1gNOr3D PH0RUM.";
$lang['successfullyunignoredforum'] = "sUCC3sSFuLLy UnIGn0R3D phORuM.";
$lang['failedtoupdateforuminterestlevel'] = "f41led to UpdA+e F0Rum In+3R3sT LEvEL";
$lang['noforumsavailablelogin'] = "th3rE aR3 No Ph0rUMS 4vAiL4BLe. PLe4sE L091n +o VieW YoUR pHOruM\$.";
$lang['passwdprotectedforum'] = "p45SwoRD pRoTEctED F0RUm";
$lang['passwdprotectedwarning'] = "tHI\$ PHORum is p4sSWOrd PrOT3C+eD. TO 94IN @CceSS eN+3R t3H P@\$\$WORd BEl0W.";

// Message composition (post.php, lpost.php) --------------------------------------

$lang['postmessage'] = "post m3ss@93";
$lang['selectfolder'] = "sElECT PH0LD3R";
$lang['mustenterpostcontent'] = "j00 MUsT eNTEr S0ME C0N+eN+ pHOr +3H PosT!";
$lang['messagepreview'] = "m35S49e PrEV13W";
$lang['invalidusername'] = "iNV4LID U\$3rN@M3!";
$lang['mustenterthreadtitle'] = "j00 MU5T 3N+3r A +i+LE f0R +H3 +HRE4D!";
$lang['pleaseselectfolder'] = "plE@\$3 \$3LEC+ 4 FOLd3R!";
$lang['errorcreatingpost'] = "eRr0r CreAT1Ng P0\$+! plEAse +RY aG41N iN 4 pHEW m1NU+3\$.";
$lang['createnewthread'] = "cre4TE NeW thR3@D";
$lang['postreply'] = "p0S+ REpLY";
$lang['threadtitle'] = "tHr3@D tITL3";
$lang['messagehasbeendeleted'] = "me5saGE N0T PH0UnD. cheCK TH@t 1+ H4Sn'+ 8eEn Dele+3D.";
$lang['messagenotfoundinselectedfolder'] = "me5S4G3 NOt PhoUNd IN s3lECtED F0lD3R. cHEcK tH@t 1+ hASn'+ bE3N m0VEd 0R dELe+3D.";
$lang['cannotpostthisthreadtypeinfolder'] = "j00 c@NNO+ P0S+ +h1s +hreAD +yP3 1N +H4+ PHOldEr!";
$lang['cannotpostthisthreadtype'] = "j00 C4NNOt P0\$+ tH1\$ tHRE4D +ypE @S Th3RE 4RE n0 4V4il@BLe Ph0LD3Rs +H@T @LLOw I+.";
$lang['cannotcreatenewthreads'] = "j00 C4Nno+ cRE@TE n3W +Hr3AdS.";
$lang['threadisclosedforposting'] = "tHi\$ +hREaD Is CL05Ed, J00 cANn0+ p0sT 1N I+!";
$lang['moderatorthreadclosed'] = "w4RN1N9: +h1\$ +hR34D 1\$ CLO\$eD pHOr P05TiN9 to N0Rm@L US3RS.";
$lang['usersinthread'] = "uS3rS 1N +hREAd";
$lang['correctedcode'] = "c0rR3C+3D c0D3";
$lang['submittedcode'] = "su8Mi+T3D COd3";
$lang['htmlinmessage'] = "h+mL In M3sS@G3";
$lang['disableemoticonsinmessage'] = "d15ABle Em0TiC0NS in ME\$S@9E";
$lang['automaticallyparseurls'] = "aU+OmA+1C@lly P@rs3 UrL\$";
$lang['automaticallycheckspelling'] = "aU+oMa+1C4LLy Ch3cK spELl1NG";
$lang['setthreadtohighinterest'] = "sE+ +HR3AD +O hI9H INTer3sT";
$lang['enabledwithautolinebreaks'] = "eN@bleD W1Th 4U+0-LiN3-br3AK\$";
$lang['fixhtmlexplanation'] = "tH1\$ PhoRUm US3S hTML fIL+EriNG. Y0UR \$u8m1+T3D h+Ml H@s 83EN m0dIf1eD 8Y The FIlT3RS IN S0ME w4Y.\\n\\nTO v1eW yoUr Or1gIN4L c0DE, sElEc+ +eH \\'SUbmI++3D Cod3\\' r4D10 8U++oN.\\nT0 vIEW The M0D1phiED coDE, s3L3Ct +h3 \\'c0RREc+3D codE\\' R4D10 8U++0n.";
$lang['messageoptions'] = "mEsS493 OPtIonS";
$lang['notallowedembedattachmentpost'] = "j00 @RE no+ AlLOWeD +o EM83D @+T4CHmEN+S 1N yOUR p0sT5.";
$lang['notallowedembedattachmentsignature'] = "j00 4R3 N0T @ll0W3D +0 EM83D @TT4CHm3n+s In YouR sI9N@tUR3.";
$lang['reducemessagelength'] = "m3ss@GE L3N9+H mU5+ b3 UNDer 65,535 Ch@R4CTer\$ (curR3nTLY: %s)";
$lang['reducesiglength'] = "s1GN@tuRE l3nGth MUS+ bE UndEr 65,535 Ch@RaCTers (cURr3N+LY: %s)";
$lang['cannotcreatethreadinfolder'] = "j00 C4NNo+ CrE@tE New +hRE4D\$ IN THI\$ PHOLD3R";
$lang['cannotcreatepostinfolder'] = "j00 C4NNOT rePLY T0 P0STS 1n THi5 FOLd3r";
$lang['cannotattachfilesinfolder'] = "j00 C@NNO+ pO\$+ @T+4CHmeNT\$ IN th1S FolDEr. r3MOVe 4TT4CHm3n+S +o C0NTINuE.";
$lang['postfrequencytoogreat'] = "j00 C4N 0nLy PO\$t oNCE ev3RY %s \$3Conds. pl3A\$e tRY 494In L4TEr.";
$lang['emailconfirmationrequiredbeforepost'] = "em@iL conF1RM@TiON i\$ ReQU1REd Bef0R3 J00 C@N Po5+. 1F J00 h4V3 N0+ REc31VEd 4 C0NfiRM@TI0n 3MAIL pL3@SE CLiCk ThE bUTtON 83L0W @ND 4 NeW 0N3 W1Ll 83 S3Nt +0 y0u. 1Ph Y0UR EM@iL 4ddRESs N33D\$ CH4N91N9 pLE@53 d0 S0 8ePH0R3 R3QU3S+in9 @ n3w C0NPhIRM@TION EMaiL. j00 M4Y ch4NGE Y0uR eMAIl 4DDRe5s By CL1CK mY Con+rOLS 480VE 4Nd ThEN U5eR deT@1LS";
$lang['emailconfirmationfailedtosend'] = "c0npHIrmA+1oN Em4IL PHAiLED TO \$3ND. pL3@S3 c0n+4C+ +H3 f0rum 0WN3R +o R3CTifY Th1S.";
$lang['emailconfirmationsent'] = "conF1rM4+ioN EMail HA\$ b3eN rE53NT.";
$lang['resendconfirmation'] = "rEsENd ConFiRM@tI0N";
$lang['userapprovalrequiredbeforeaccess'] = "yoUr US3R 4CcoUnT nEEds tO 8E @PPr0v3D 8Y a f0rUM @dM1N 8EPHoR3 J00 c4N @Cc3\$s +H3 R3qU3s+ed Ph0RUm.";
$lang['reviewthread'] = "r3vIEw +Hr34D";
$lang['reviewthreadinnewwindow'] = "r3vIEw eN+1RE +HRe4D 1N nEW WiND0W";

// Message display (messages.php & messages.inc.php) --------------------------------------

$lang['inreplyto'] = "iN R3PLY t0";
$lang['showmessages'] = "sH0w m3\$S4GES";
$lang['ratemyinterest'] = "r4+3 MY IN+3r3\$+";
$lang['adjtextsize'] = "aDJUSt T3XT S1Z3";
$lang['smaller'] = "sm4llEr";
$lang['larger'] = "l4r93r";
$lang['faq'] = "f4Q";
$lang['docs'] = "dOC\$";
$lang['support'] = "sUPPORT";
$lang['donateexcmark'] = "doN@t3!";
$lang['fontsizechanged'] = "f0nT \$1Z3 ch4N9ED. %s";
$lang['framesmustbereloaded'] = "fr@M3S Mu\$T 8E rEL0@d3d m4NU@LLy TO s33 CH4N9Es.";
$lang['threadcouldnotbefound'] = "tEH reQUe\$TEd ThR34D c0UlD NO+ B3 f0uND oR ACC3SS w4s Den13D.";
$lang['mustselectpolloption'] = "j00 MuS+ sELeCt AN 0p+1oN t0 v0t3 F0R!";
$lang['mustvoteforallgroups'] = "j00 mu\$t VO+3 IN Ev3RY gROuP.";
$lang['keepreading'] = "kE3P rE4D1N9";
$lang['backtothreadlist'] = "b@cK TO +HRE4d LisT";
$lang['postdoesnotexist'] = "th@T PosT D0ES n0T 3X1\$t 1N +Hi\$ tHR3@d!";
$lang['clicktochangevote'] = "clicK +O cH@n93 V0T3";
$lang['youvotedforoption'] = "j00 V0+Ed F0R 0p+10N";
$lang['youvotedforoptions'] = "j00 VO+3d f0R 0p+ION\$";
$lang['clicktovote'] = "cL1Ck +o V0+3";
$lang['youhavenotvoted'] = "j00 HaVE N0T VO+eD";
$lang['viewresults'] = "vIew r3sUL+s";
$lang['msgtruncated'] = "m3\$s@93 TRunC4T3D";
$lang['viewfullmsg'] = "v1eW FulL m3sSAGE";
$lang['ignoredmsg'] = "ign0rEd ME5S493";
$lang['wormeduser'] = "worMED US3R";
$lang['ignoredsig'] = "iGNOreD \$1GNAtUR3";
$lang['messagewasdeleted'] = "me\$S@gE %s.%s w4s D3LeT3D";
$lang['stopignoringthisuser'] = "s+0p 1GN0R1N9 Th1s U\$3R";
$lang['renamethread'] = "r3NaME THR34d";
$lang['movethread'] = "mov3 THR3@D";
$lang['torenamethisthreadyoumusteditthepoll'] = "t0 rEN@mE tH1\$ tHr3ad J00 MUST 3d1+ +3H poLl.";
$lang['closeforposting'] = "cl053 PH0R P0ST1N9";
$lang['until'] = "uNT1L 00:00 U+c";
$lang['approvalrequired'] = "appr0V4L REQu1r3D";
$lang['messageawaitingapprovalbymoderator'] = "mESs@93 %s.%s iS @w@i+iNG 4PPRov@L 8Y 4 m0der4Tor";
$lang['successfullyapprovedpost'] = "sUcCE5\$phully 4PPR0V3D P0sT %s";
$lang['postapprovalfailed'] = "p0\$T 4PProV4l pHaILEd.";
$lang['postdoesnotrequireapproval'] = "pO\$T DoeS noT ReQU1Re 4PPROVAL";
$lang['approvepost'] = "aPPROv3 P0\$+";
$lang['approvedbyuser'] = "appr0VEd: %s 8Y %s";
$lang['makesticky'] = "m@KE sT1CKY";
$lang['messagecountdisplay'] = "%s OPh %s";
$lang['linktothread'] = "p3rmANEn+ lINk T0 +H1S +hRE4D";
$lang['linktopost'] = "l1nK +O P0\$+";
$lang['linktothispost'] = "l1nK T0 +H1\$ pOST";
$lang['imageresized'] = "tH1\$ 1MAGe H@\$ B33n RES1Z3D (oR1GIN4L 5iZe %1\$sX%2\$S). +o V1EW t3H phULl-SIZe Im49e Cl1CK h3RE.";
$lang['messagedeletedbyuser'] = "m3\$S@93 %s.%s D3L3T3d %s BY %s";
$lang['messagedeleted'] = "m3SS4GE %s.%s W@S d3l3+3d";
$lang['viewinframeset'] = "v1eW In Fr4M3\$3T";
$lang['pressctrlentertoquicklysubmityourpost'] = "preSs C+RL+3NT3R To qU1CKLy \$uBM1+ youR pO\$+";

// Moderators list (mods_list.php) -------------------------------------

$lang['cantdisplaymods'] = "c@nn0t d1\$pL4Y f0ldER M0DEr4+ORs";
$lang['moderatorlist'] = "mODER@T0R lI\$+:";
$lang['modsforfolder'] = "m0DEr4Tor\$ f0r PHoLDeR";
$lang['nomodsfound'] = "nO MoDEr@TORs F0UNd";
$lang['forumleaders'] = "f0ruM LeADEr\$:";
$lang['foldermods'] = "f0ldER moDER4torS:";

// Navigation strip (nav.php) ------------------------------------------

$lang['start'] = "s+4R+";
$lang['messages'] = "m3sS4gES";
$lang['pminbox'] = "iN80x";
$lang['startwiththreadlist'] = "s+arT PAG3 Wi+H +Hre4d lI\$+";
$lang['pmsentitems'] = "s3nT 1+3M\$";
$lang['pmoutbox'] = "oUt80X";
$lang['pmsaveditems'] = "s4vED I+ems";
$lang['pmdrafts'] = "dr@PH+s";
$lang['links'] = "lInKS";
$lang['admin'] = "adMIN";
$lang['login'] = "l0GIn";
$lang['logout'] = "l090U+";

// PM System (pm.php, pm_write.php, pm.inc.php) ------------------------

$lang['privatemessages'] = "pr1VA+e m3\$s@gES";
$lang['recipienttiptext'] = "s3p4rA+3 R3C1P1EN+s 8Y \$EMI-c0lON OR c0MM4";
$lang['maximumtenrecipientspermessage'] = "theRE I\$ a l1m1T of 10 ReCIpi3Nts p3r m3sS@9e. PLE4S3 4M3Nd Y0UR R3C1P1ENt L1S+.";
$lang['mustspecifyrecipient'] = "j00 muS+ sPEc1PHy 4+ l3@ST oNe R3CiP13N+.";
$lang['usernotfound'] = "u5eR %s NOt PH0Und";
$lang['sendnewpm'] = "sEnd n3W pm";
$lang['savemessage'] = "s4v3 MESs@9e";
$lang['nosubject'] = "no \$uBJect";
$lang['norecipients'] = "nO R3C1PIEn+s";
$lang['timesent'] = "t1ME S3N+";
$lang['notsent'] = "not \$3NT";
$lang['errorcreatingpm'] = "erroR cr3A+1NG pM! PLeASE tRY 4GaIn 1n 4 feW M1NU+3s";
$lang['writepm'] = "wri+E mES5@Ge";
$lang['editpm'] = "ed1t m3\$S@g3";
$lang['cannoteditpm'] = "c4NNo+ Ed1+ +H1s pM. 1t H4S 4Lr3@dY bEEN VIEWed By +H3 rECIP13n+ 0R +3h M3\$S49E doE\$ nOT 3xIsT Or 1+ I\$ 1N4CCEsSIbL3 BY j00";
$lang['cannotviewpm'] = "c4nNot VI3w pm. m3S\$493 DOes no+ 3xI\$t 0R 1+ IS 1N4Cc3ss18L3 8Y J00";
$lang['pmmessagenumber'] = "m3\$S@9E %s";

$lang['youhavexnewpm'] = "j00 h4V3 %d N3W m3sS@9ES. w0UlD j00 LIk3 +0 90 TO y0UR iNB0x n0w?";
$lang['youhave1newpm'] = "j00 H4V3 1 New mESSAge. WoULd J00 LIkE +0 90 TO YOUr INboX now?";
$lang['youhave1newpmand1waiting'] = "j00 h4VE 1 neW m3\$\$49E.\n\nYOu @lS0 H@VE 1 MEs\$Age 4w@1+In9 dElIVeRY. TO R3C31VE +H1S m3s\$49E PlE4s3 cL34R 5oME Sp4C3 iN YouR iN80X.\n\nW0Uld J00 l1KE +0 90 tO YouR iNB0x N0W?";
$lang['youhave1pmwaiting'] = "j00 HAvE 1 M3SS49E 4W4I+1nG deL1V3Ry. TO r3CEIve +H1\$ m3\$S@Ge PLe4\$e cLE4R SOm3 SP4C3 1N y0ur iNBOX.\n\nWOUlD J00 l1ke t0 G0 To Y0UR 1n80X N0W?";
$lang['youhavexnewpmand1waiting'] = "j00 HAVe %d N3W m3\$S@9ES.\n\nYOU aLSO h@ve 1 ME\$S@9E @w41T1N9 D3LIvERy. +o REc3iVe THi\$ M3\$s4g3 pL34\$3 CleAr S0m3 SP4ce IN Y0UR iNBox.\n\nwoULd J00 LikE TO 90 +O YOUR iN80x NOW?";
$lang['youhavexnewpmandxwaiting'] = "j00 haV3 %d New m3sS49Es.\n\nYOU 4Ls0 H4V3 %d MESS49ES 4W41+1nG dELiVEry. t0 rECeIVe ThESE M3\$S4g3 Pl3@S3 Cle4R \$0M3 SPaCE iN yoUr INb0x.\n\nWOULd J00 L1KE T0 g0 +0 YouR iNBox NOw?";
$lang['youhave1newpmandxwaiting'] = "j00 h@Ve 1 NEW m3\$5493.\n\nY0U 4LSO H@VE %d mESs4G3S 4W@1+1NG DELIveRY. +0 R3CEIve +HES3 Me5S@9ES pLE4SE CLe4r SOm3 SPAcE 1N YOUr INb0x.\n\nwOULd J00 L1KE +O 90 To y0Ur 1N80X noW?";
$lang['youhavexpmwaiting'] = "j00 H4vE %d MesS49es @W41TINg DeL1VEry. T0 reCeIVe TH3S3 M3SS@Ge\$ pl345E CLe4R \$0ME \$P4CE iN Y0ur INbOX.\n\nwOUlD J00 L1K3 +O 9o +O YOur 1N8OX n0w?";

$lang['youdonothaveenoughfreespace'] = "j00 D0 NOt H@V3 En0U9H frEE SP4C3 t0 S3ND +h1S M3\$S@93.";
$lang['userhasoptedoutofpm'] = "%s H@\$ 0P+ED 0UT 0pH reCE1VIng P3RSON4L mESs@935";
$lang['pmfolderpruningisenabled'] = "pm F0LDer pRuNIN9 1s EN48l3D!";
$lang['pmpruneexplanation'] = "th1s PH0Rum Us3s Pm pHOLD3r PrUN1n9. thE M3SS@gE\$ j00 hAVe \$t0R3D 1N Y0UR INBox aNd \$3N+ i+EM\$\\nph0Ld3R\$ 4r3 SuBjEc+ T0 AUt0M4+1C d3lE+1oN. aNy M3ss49E5 j00 wISH t0 K3ep \$H0ULd b3 M0vED +O\\ny0UR \\'5AVeD 1TEmS\\' PH0LdER sO tH@T +h3Y 4RE NO+ DeLE+ed.";
$lang['yourpmfoldersare'] = "y0UR pM pHOLdERS @RE %s fULl";
$lang['currentmessage'] = "curr3N+ m3sSAg3";
$lang['unreadmessage'] = "unrE4D m3sS@93";
$lang['readmessage'] = "re@D Mes\$@GE";
$lang['pmshavebeendisabled'] = "peRSOn4L Me\$S@9ES H4V3 833N D1S@bl3D 8Y TH3 F0RUm 0WNeR.";
$lang['adduserstofriendslist'] = "aDd US3RS tO yOUR frI3Nd\$ li\$t +O H@vE +h3m 4PPe4R 1N 4 dROP DOwN On Th3 Pm Wr1t3 MEss4G3 p@Ge.";

$lang['messagewassuccessfullysavedtodraftsfolder'] = "mEss4GE W@S suCC3SSphULlY 54V3D +O 'dR@F+S' F0LD3r";
$lang['couldnotsavemessage'] = "cOuLD n0+ s4V3 MeSS49e. M@K3 sURe J00 H@Ve 3NOUgH @V41L48L3 FrEE sP@c3.";
$lang['pmtooltipxmessages'] = "%s mESS@93s";
$lang['pmtooltip1message'] = "1 m3\$S@GE";

$lang['allowusertosendpm'] = "aLL0W US3R To 5END pERSOn4l Me\$S@Ges +0 mE";
$lang['blockuserfromsendingpm'] = "bl0CK US3R pHROM s3ND1NG P3RSOn@L ME\$SaGEs +0 m3";
$lang['yourfoldernamefolderisempty'] = "y0Ur %s FOLD3R 1S 3Mp+Y";
$lang['successfullydeletedselectedmessages'] = "sUCC3SSFulLY D3L3T3D 5EleC+ED M3sS49ES";
$lang['successfullyarchivedselectedmessages'] = "succEsSpHUllY 4RCh1VEd \$eL3C+3D MESS4geS";
$lang['failedtodeleteselectedmessages'] = "f41LeD T0 D3LEt3 S3LEcTeD Me\$S@9ES";
$lang['failedtoarchiveselectedmessages'] = "f@ILEd TO 4rChIve SEl3CTeD Me\$\$49es";

// Preferences / Profile (user_*.php) ---------------------------------------------

$lang['mycontrols'] = "my C0NTroLS";
$lang['myforums'] = "my PH0RUmS";
$lang['menu'] = "menU";
$lang['userexp_1'] = "u\$e TH3 meNu On +h3 L3PHt T0 M@N49E Y0Ur s3++1N9S.";
$lang['userexp_2'] = "<b>us3R d3T4il\$</b> 4Ll0WS j00 TO cH4N9E YoUR N4m3, eM@1L @DdR3S5 @nD pASSW0RD.";
$lang['userexp_3'] = "<b>u\$3R pROpH1LE</b> 4lL0WS j00 +O eD1T y0UR uSer PrOF1L3.";
$lang['userexp_4'] = "<b>ch@NG3 P4sSW0RD</b> 4LloW\$ J00 +O CH4nGE y0UR P4SsWOrD";
$lang['userexp_5'] = "<b>em@1L &amp; PRIvACy</b> L3+S J00 ChAnge h0W j00 C4N B3 C0n+AcTeD oN 4Nd 0FF +3H PhoRuM.";
$lang['userexp_6'] = "<b>foRUM oPT1ONS</b> lET\$ j00 CH4N93 HOW tH3 F0RUM Lo0ks @nD WorKS.";
$lang['userexp_7'] = "<b>a+t@CHM3ntS</b> 4LL0WS J00 TO 3d1T/d3lE+3 y0UR 4tt4CHmEN+s.";
$lang['userexp_8'] = "<b>sI9n@tuRE</b> l3tS j00 EDi+ Y0UR S1GNa+UrE.";
$lang['userexp_9'] = "<b>rELA+ioN\$hIPS</b> l3+S J00 M@n493 Y0Ur R3L4+1OnsH1P wI+H o+H3R u\$3rs ON T3H F0RUm.";
$lang['userexp_9'] = "<b>w0RD PhILtER</b> l3TS j00 3D1+ yOUR p3R\$oN4L w0RD F1lteR.";
$lang['userexp_10'] = "<b>tHre@D su8SCR1p+I0NS</b> 4lL0WS J00 To M4NAg3 Y0ur thR3AD SUB5Cr1P+1ONS.";
$lang['userdetails'] = "us3R D3T41L\$";
$lang['userprofile'] = "u\$3r Pr0PHIlE";
$lang['emailandprivacy'] = "eM41L &amp; PriV4cY";
$lang['editsignature'] = "edi+ \$1GN4TurE";
$lang['norelationshipssetup'] = "j00 H4V3 no US3R r3LA+10N\$h1pS SEt Up. 4DD 4 NEW US3R by SE4rcHInG 83LOw.";
$lang['editwordfilter'] = "edi+ w0RD pHiLT3R";
$lang['userinformation'] = "uS3R Inf0RM4TioN";
$lang['changepassword'] = "chan9e P4\$sw0RD";
$lang['currentpasswd'] = "curReN+ P@5SWOrD";
$lang['newpasswd'] = "new P@\$SW0RD";
$lang['confirmpasswd'] = "confIRM p45sW0Rd";
$lang['passwdsdonotmatch'] = "p4\$sW0RD\$ D0 n0T m4+Ch!";
$lang['nicknamerequired'] = "nicKnaM3 I\$ REqUIR3d!";
$lang['emailaddressrequired'] = "emaIL ADdR3sS is R3qu1REd!";
$lang['logonnotpermitted'] = "lOGOn NO+ P3rM1TtED. ChooS3 4N0TheR!";
$lang['nicknamenotpermitted'] = "nicKN@M3 N0T pERm1TT3D. CH0OS3 4N0+hER!";
$lang['emailaddressnotpermitted'] = "em41L @DDR3SS NO+ P3Rm1++3d. ChooSE 4nOtHEr!";
$lang['emailaddressalreadyinuse'] = "em41L addr3sS 4LRe4dY iN uS3. Ch0o\$3 4NO+HEr!";
$lang['relationshipsupdated'] = "r3l@+i0n5H1PS uPD@tED!";
$lang['relationshipupdatefailed'] = "r3l@TI0NshIp UpD4+3D F41LEd!";
$lang['preferencesupdated'] = "pr3F3ReNCe\$ W3re SUcC3SSFUlLy UpDA+Ed.";
$lang['userdetails'] = "u53r det@1L\$";
$lang['memberno'] = "meMb3r no.";
$lang['firstname'] = "firs+ nAM3";
$lang['lastname'] = "l4st n4ME";
$lang['dateofbirth'] = "d4tE 0f B1R+h";
$lang['homepageURL'] = "h0mEP@93 UrL";
$lang['profilepicturedimensions'] = "pr0F1lE p1ctuR3 (m4x 95X95PX)";
$lang['avatarpicturedimensions'] = "av4+4R piCTuR3 (mAX 15x15PX)";
$lang['invalidattachmentid'] = "invAlID @++4CHmEN+. cH3CK +h4+ 1s hASn'T 83en d3L3T3D.";
$lang['unsupportedimagetype'] = "un\$UppoRT3d 1M@GE at+4ChM3N+. J00 cAn 0NLy US3 jP9, 9IF 4ND pN9 1M@93 @++AchM3Nt\$ pH0R Y0UR 4V4+4R @Nd PR0F1le pIC+UR3.";
$lang['selectattachment'] = "s3L3C+ @TT4CHmEN+";
$lang['pictureURL'] = "p1cTUR3 URl";
$lang['avatarURL'] = "av4+4R url";
$lang['profilepictureconflict'] = "t0 U5e 4n At+acHmeN+ F0r y0UR prOfilE p1CTure +h3 P1c+uR3 uRl FielD mu5t be 8L4Nk.";
$lang['avatarpictureconflict'] = "tO USe 4N 4tt4CHMEnt Ph0R yOur 4Va+4r PiCTuR3 teh @V4+@r uRL pHi3Ld mu\$T be Bl@nK.";
$lang['attachmenttoolargeforprofilepicture'] = "s3l3ct3D 4tt4CHMEN+ 1\$ +0O L@R9e F0R PR0F1l3 pIc+uR3. m4X1mUM DiM3Ns10NS @re %s";
$lang['attachmenttoolargeforavatarpicture'] = "s3Lec+3D 4TT@cHMEnT 1\$ +00 L4R9E PHOR @V4+AR pIC+Ure. MaxIMum DiM3NSIONS ar3 %s";
$lang['failedtoupdateuserdetails'] = "s0mE Or AlL Of YOUr US3R @cc0UNT d3+aiLS coUld n0T 8E uPDa+3D. pLe@S3 +rY 4941N l4T3R.";
$lang['failedtoupdateuserpreferences'] = "s0ME Or @Ll OF Y0uR US3R pR3FEReNCe5 c0ULd noT 83 UPdAtED. PlE4S3 TrY 4GAIn LaT3R.";
$lang['emailaddresschanged'] = "eM@il 4dDRE\$s H4\$ B3EN CH4n9ed";
$lang['newconfirmationemailsuccess'] = "y0ur 3MAiL 4DDresS h4S BE3n Ch4NgED anD @ N3W c0NPh1rM4TIoN EM41L hA\$ b3eN S3N+. Pl3@Se cH3Ck 4nD R3AD +H3 EM41L pHOR PHur+H3R iN\$+RucTION\$.";
$lang['newconfirmationemailfailure'] = "j00 h4ve cH@NG3D YOuR EM@1L 4DDR3SS, 8u+ we WeRE un48L3 to \$3Nd 4 C0Nph1RMa+10N reQU3\$+. Pl3AS3 con+AcT thE PhoRUM oWNer pH0R 4SSIST4Nc3.";
$lang['forumoptions'] = "f0ruM 0PTi0nS";
$lang['notifybyemail'] = "n0TifY 8Y 3mAiL Of pOSTS +O mE";
$lang['notifyofnewpm'] = "n0tipHy By P0PUP OF neW Pm MESS493S +o M3";
$lang['notifyofnewpmemail'] = "nOTIFY 8Y 3m@1L OF neW pM m3sS4G3\$ to m3";
$lang['daylightsaving'] = "adjUsT PHOr D@Yli9HT 54V1ng";
$lang['autohighinterest'] = "autOM4TIc4LLy MarK tHrE4D\$ i po5+ 1N 4S hiGh In+ERE\$t";
$lang['convertimagestolinks'] = "aUTOM4TiC@Lly c0NVErT emB3Dd3d 1M49ES 1n PO\$+S 1N+o L1NK\$";
$lang['thumbnailsforimageattachments'] = "tHUM8N41LS pHOR 1m49E 4+T4chMeN+S";
$lang['smallsized'] = "sM4lL sIz3D";
$lang['mediumsized'] = "medIUM s1ZEd";
$lang['largesized'] = "l4RGE \$1Z3D";
$lang['globallyignoresigs'] = "gl084lLy IGnoR3 Us3r S1gN4TuRES";
$lang['allowpersonalmessages'] = "aLlOW o+H3R us3RS t0 sEnD Me P3rsONAl MesS@gES";
$lang['allowemails'] = "aLl0W O+hEr US3R\$ TO s3nD m3 Em41L\$ v1@ mY PrOPhiLE";
$lang['timezonefromGMT'] = "t1mE ZONe";
$lang['postsperpage'] = "p0St5 P3R p4gE";
$lang['fontsize'] = "font S1ZE";
$lang['forumstyle'] = "fORUM s+yL3";
$lang['forumemoticons'] = "fORUM EM0+1c0NS";
$lang['startpage'] = "s+AR+ paG3";
$lang['signaturecontainshtmlcode'] = "si9n@TURe COn+41N\$ h+mL C0DE";
$lang['savesignatureforuseonallforums'] = "s@vE 5I9N@TURe F0R usE on 4LL PH0RuMS";
$lang['preferredlang'] = "pReF3RReD l4NGu@93";
$lang['donotshowmyageordobtoothers'] = "dO N0+ sH0W mY a9E Or D@+E oPh 81RTH +O O+H3RS";
$lang['showonlymyagetoothers'] = "shoW 0Nly mY 49E +0 O+hER\$";
$lang['showmyageanddobtoothers'] = "sHOw b0tH MY 49e 4ND d4+3 Of B1RtH +o 0THer5";
$lang['showonlymydayandmonthofbirthytoothers'] = "sH0W oNlY mY DAy @nD m0N+h oF 81R+h +o O+herS";
$lang['listmeontheactiveusersdisplay'] = "li5+ M3 0N tHE 4c+1VE usEr\$ D1Spl4Y";
$lang['browseanonymously'] = "bR0WSe F0RUm @NOnYM0USly";
$lang['allowfriendstoseemeasonline'] = "br0WS3 4nONyM0USLy, BU+ 4LL0W PhR13NDS +0 S33 Me 4s 0NLinE";
$lang['revealspoileronmouseover'] = "r3v3AL sP0iLeRS 0n M0USe 0veR";
$lang['showspoilersinlightmode'] = "aLw4Y\$ sH0W SP0IL3RS IN l19Ht MOdE (u\$eS LiGh+3R FON+ COLOur)";
$lang['resizeimagesandreflowpage'] = "r3\$1ze Im493\$ 4nD rePHlOW P49E +0 PR3v3n+ H0r1z0NT4L \$cr0LlINg.";
$lang['showforumstats'] = "sH0W F0rUM \$T4TS 4+ BOtT0m 0f Me\$\$49E p@NE";
$lang['usewordfilter'] = "eNaBLe w0RD pHIlTEr.";
$lang['forceadminwordfilter'] = "foRcE US3 0PH @DM1N W0Rd F1lTeR 0N @LL us3rs (INc. 9U3sT\$)";
$lang['timezone'] = "tim3 ZON3";
$lang['language'] = "l@N9u493";
$lang['emailsettings'] = "em41L 4Nd C0NT4C+ \$3++iN9S";
$lang['forumanonymity'] = "fORUm 4N0NyM1+Y S3+TinGS";
$lang['birthdayanddateofbirth'] = "b1r+Hd4Y @Nd d@+e 0F 81Rth D1\$pL4Y";
$lang['includeadminfilter'] = "inclUdE @dM1N woRD fILteR 1n mY L1\$+.";
$lang['setforallforums'] = "s3+ PH0R 4LL PH0RUm\$?";
$lang['containsinvalidchars'] = "%s cON+41Ns 1Nv4LID CH4R@CT3RS!";
$lang['homepageurlmustincludeschema'] = "h0m3P493 URL Mu\$+ InCLUd3 H++P:// \$CH3M4.";
$lang['pictureurlmustincludeschema'] = "p1c+URe UrL mUST 1NcLUDE h+tp:// SCh3m4.";
$lang['avatarurlmustincludeschema'] = "aVaT4R urL mU\$+ InCLuDE htTp:// SchEMa.";
$lang['postpage'] = "poS+ p493";
$lang['nohtmltoolbar'] = "no H+mL +OOl84R";
$lang['displaysimpletoolbar'] = "di5Pl@Y SIMPl3 H+ML +00L8Ar";
$lang['displaytinymcetoolbar'] = "di\$pL@Y wysIwYg H+mL +00L8Ar";
$lang['displayemoticonspanel'] = "d1SPl@Y em0TIcon5 p@NEL";
$lang['displaysignature'] = "diSpL4Y \$1GN4+uRE";
$lang['disableemoticonsinpostsbydefault'] = "dIsaBL3 3m0TICOn\$ 1N mESS49es bY D3PH4UL+";
$lang['automaticallyparseurlsbydefault'] = "aut0M@T1CallY P4R\$3 URls 1N Me\$S@9E\$ 8y D3PH@UL+";
$lang['postinplaintextbydefault'] = "po5t IN pLAiN Tex+ By DEpH@UL+";
$lang['postinhtmlwithautolinebreaksbydefault'] = "p0st 1N htMl Wi+h 4uTO-L1NE-8R3Aks By DEfAUlt";
$lang['postinhtmlbydefault'] = "p0St 1N hTMl By DEf4uL+";
$lang['postdefaultquick'] = "u\$3 qUICK r3PLy by D3F4UL+. (FUlL R3PLy IN m3nU)";
$lang['privatemessageoptions'] = "pRiV4+3 Me\$S@9E 0P+10N\$";
$lang['privatemessageexportoptions'] = "pRIv4tE m3sS@g3 EXP0Rt 0Pt10n\$";
$lang['savepminsentitems'] = "sAVE @ C0PY opH 34CH pM I SeND IN MY SenT 1TEMS fOLder";
$lang['includepminreply'] = "iNcluDE M3\$S4G3 bODY WH3N REPLyINg +0 PM";
$lang['autoprunemypmfoldersevery'] = "aut0 PRUne My Pm PH0ld3R\$ EVerY:";
$lang['friendsonly'] = "friENds 0NLy?";
$lang['globalstyles'] = "glO8@L \$tYLE\$";
$lang['forumstyles'] = "fORUM sTyLE\$";
$lang['youmustenteryourcurrentpasswd'] = "j00 MUS+ EnT3R Y0UR cuRr3n+ P4SSWORD";
$lang['youmustenteranewpasswd'] = "j00 MUST 3N+3R @ NeW P4\$SWord";
$lang['youmustconfirmyournewpasswd'] = "j00 mu\$+ c0Nph1RM YoUR nEW P@\$SW0RD";
$lang['profileentriesmustnotincludehtml'] = "pr0PhIl3 EN+Ri3\$ Mus+ N0T 1ncLuDE hTMl";
$lang['failedtoupdateuserprofile'] = "f4iL3D +0 UpdA+3 US3R prOFILe";

// Polls (create_poll.php, poll_results.php) ---------------------------------------------

$lang['mustprovideanswergroups'] = "j00 MUST PROvID3 \$0me 4NSwER 9rOUpS";
$lang['mustprovidepolltype'] = "j00 MU\$+ PRoVId3 @ p0LL TYPE";
$lang['mustprovidepollresultsdisplaytype'] = "j00 mU\$+ pROv1dE rE\$ul+S D1\$PL4Y tYpE";
$lang['mustprovidepollvotetype'] = "j00 Must PROvID3 4 PolL V0+3 TyPE";
$lang['mustprovidepollguestvotetype'] = "j00 mu\$T sPEciPHy iF 9ueStS sh0uLd B3 4LlowED t0 VOt3";
$lang['mustprovidepolloptiontype'] = "j00 MU5T prOViDE 4 pOll OPT1ON +YPe";
$lang['mustprovidepollchangevotetype'] = "j00 Mu5t PROv1DE 4 poLL CHaNGe VOT3 +yPE";
$lang['pollquestioncontainsinvalidhtml'] = "oN3 0R MOr3 0PH YOUr POlL qU3\$TIOn\$ c0NT4Ins Inv4L1D html.";
$lang['pleaseselectfolder'] = "ple4s3 \$3leCT @ foLd3r";
$lang['mustspecifyvalues1and2'] = "j00 mUST sPecIFy vALU3s F0R aNSWeR\$ 1 4ND 2";
$lang['tablepollmusthave2groups'] = "t4bUL4R FORM4+ PoLL\$ MuS+ h4V3 pr3C1S3Ly TwO vO+1N9 gROuPS";
$lang['nomultivotetabulars'] = "t48UL4R pHOrM@t P0ll\$ c4Nn0+ B3 mUL+1-voT3";
$lang['nomultivotepublic'] = "pU8l1C b4lLo+s CANnoT 8e MUl+1-VO+3";
$lang['abletochangevote'] = "j00 WIlL be a8L3 t0 CH4N93 Y0UR v0T3.";
$lang['abletovotemultiple'] = "j00 WILl b3 48L3 +0 voTE mul+1PLE +IM3\$.";
$lang['notabletochangevote'] = "j00 WIlL n0T 8e @8L3 TO CH@NGe YoUR vOT3.";
$lang['pollvotesrandom'] = "n0+3: pOlL Vo+ES 4RE r4NDOmLy 93N3R4TEd F0R pR3V1EW 0NLy.";
$lang['pollquestion'] = "p0lL qU3S+1ON";
$lang['possibleanswers'] = "pOsSI8Le 4NSW3RS";
$lang['enterpollquestionexp'] = "eN+ER +He AN\$weRS PHor Y0UR p0ll Qu3stiON.. IpH y0uR P0ll 1S 4 &quot;y3\$/N0&quot; qU3sTioN, sIMPlY eN+3R &quot;YE\$&quot; F0R 4nSWer 1 4ND &quot;N0&quot; PhoR 4n\$w3R 2.";
$lang['numberanswers'] = "n0. @n\$w3rS";
$lang['answerscontainHTML'] = "aNSWEr\$ C0NT4In H+Ml (N0T 1NClUD1N9 \$1GN4TUrE)";
$lang['optionsdisplay'] = "an5W3RS D1\$PL@y TyPE";
$lang['optionsdisplayexp'] = "h0W SH0ulD +HE aN\$WErS bE PREs3n+3D?";
$lang['dropdown'] = "as DRop-DowN L1\$+(s)";
$lang['radios'] = "a\$ @ SErIE5 0F Rad1O 8U++onS";
$lang['votechanging'] = "vote cH4NG1NG";
$lang['votechangingexp'] = "c@n 4 Per\$0N cH@nGE h1\$ 0r HeR V0+3?";
$lang['guestvoting'] = "gU3ST voTInG";
$lang['guestvotingexp'] = "c4n GUeS+S V0+3 1N +H1\$ pOLl?";
$lang['allowmultiplevotes'] = "alL0W mUL+1Pl3 VOteS";
$lang['pollresults'] = "pOLL rESULt\$";
$lang['pollresultsexp'] = "how WOUlD j00 Lik3 +O d1SPl@Y +hE rE\$ULTs OF YOUr POll?";
$lang['pollvotetype'] = "p0lL vOTIn9 +Yp3";
$lang['pollvotesexp'] = "h0W \$hoULD t3H poLl Be C0NDucTeD?";
$lang['pollvoteanon'] = "aNoNYm0uSLy";
$lang['pollvotepub'] = "publ1C 84Ll0+";
$lang['horizgraph'] = "h0rIZ0NT4L 9R@pH";
$lang['vertgraph'] = "v3RTiC4L GRaPH";
$lang['tablegraph'] = "t48ul4R f0RM@t";
$lang['polltypewarning'] = "<b>w@RNIN9</b>: th1S 1s @ pUBLiC 8ALlOT. YOUr N4M3 WIll BE v1S1BLE N3x+ tO ThE opT10N j00 V0+e fOR.";
$lang['expiration'] = "eXp1R@+I0N";
$lang['showresultswhileopen'] = "do J00 W@N+ +O sh0W ResuL+s WH1L3 tHE P0LL 1\$ 0P3N?";
$lang['whenlikepollclose'] = "wH3N WOULD J00 Lik3 Y0uR P0LL +O @uToMA+1C@Lly CLOse?";
$lang['oneday'] = "one D4Y";
$lang['threedays'] = "thrEE d@YS";
$lang['sevendays'] = "sev3n D4yS";
$lang['thirtydays'] = "tHIR+Y d@yS";
$lang['never'] = "nev3r";
$lang['polladditionalmessage'] = "aDD1+10N4L mESSaG3 (0PtI0N@L)";
$lang['polladditionalmessageexp'] = "d0 j00 W4n+ +O 1NClUD3 @n @Dd1tI0N@L p0sT AFt3r ThE P0LL?";
$lang['mustspecifypolltoview'] = "j00 MU\$+ SpeCIfY @ PolL t0 ViEw.";
$lang['pollconfirmclose'] = "are J00 SUR3 j00 W@nT +o ClO\$3 +3h F0Ll0w1NG P0LL?";
$lang['endpoll'] = "eNd POLl";
$lang['nobodyvotedclosedpoll'] = "no8oDY VotED";
$lang['votedisplayopenpoll'] = "%s AND %s H4V3 V0+3d.";
$lang['votedisplayclosedpoll'] = "%s 4nD %s VotEd.";
$lang['nousersvoted'] = "no uS3RS";
$lang['oneuservoted'] = "1 U53R";
$lang['xusersvoted'] = "%s us3RS";
$lang['noguestsvoted'] = "no 9U3\$tS";
$lang['oneguestvoted'] = "1 9Ues+";
$lang['xguestsvoted'] = "%s GU3Sts";
$lang['pollhasended'] = "p0lL H4s eND3D";
$lang['youvotedforpolloptionsondate'] = "j00 V0+3d F0R %s 0N %s";
$lang['thisisapoll'] = "tHI5 1s 4 PoLL. CL1Ck TO V13W R3SULtS.";
$lang['editpoll'] = "edi+ POLL";
$lang['results'] = "r35uLts";
$lang['resultdetails'] = "r3\$ult DEt41L\$";
$lang['changevote'] = "cH4N93 V0+3";
$lang['pollshavebeendisabled'] = "pOlL5 H4v3 B33N dI\$@BLED By TeH PH0RUm owNER.";
$lang['answertext'] = "aN\$W3R tEX+";
$lang['answergroup'] = "aN\$W3R 9rOUP";
$lang['previewvotingform'] = "pr3v1EW v0TING fORm";
$lang['viewbypolloption'] = "v1ew 8Y P0Ll 0P+10N";
$lang['viewbyuser'] = "vIew BY US3r";

// Profiles (profile.php) ----------------------------------------------

$lang['editprofile'] = "edi+ PR0F1L3";
$lang['profileupdated'] = "prOFiLE UPd4t3D.";
$lang['profilesnotsetup'] = "th3 PhoRUM oWNER H4s N0+ 5ET up ProF1LES.";
$lang['ignoreduser'] = "ignOr3D uS3r";
$lang['lastvisit'] = "l@sT v1sI+";
$lang['userslocaltime'] = "uSer'\$ lOC4L T1M3";
$lang['userstatus'] = "sta+u\$";
$lang['useractive'] = "onl1n3";
$lang['userinactive'] = "in@cTiV3 / opHFliNE";
$lang['totaltimeinforum'] = "tOT4l +1M3";
$lang['longesttimeinforum'] = "l0N93\$T S3SSI0N";
$lang['sendemail'] = "sENd 3m4IL";
$lang['sendpm'] = "seNd pM";
$lang['visithomepage'] = "vi\$1+ H0M3P@93";
$lang['age'] = "ag3";
$lang['aged'] = "a9ED";
$lang['birthday'] = "bir+HD@y";
$lang['registered'] = "rEg1\$+3r3D";
$lang['findpostsmadebyuser'] = "f1ND pO\$+s M4D3 8y %s";
$lang['findpostsmadebyme'] = "f1nD p0st5 M4d3 8y M3";
$lang['findthreadsstartedbyuser'] = "f1Nd +Hre4DS sTArT3D 8Y %s";
$lang['findthreadsstartedbyme'] = "f1nd +hRE4ds 5t4Rt3D 8Y me";
$lang['profilenotavailable'] = "proFILE Not av41l@8Le.";
$lang['userprofileempty'] = "tH1s US3R H@s nOT fILl3D In +hE1R prOF1l3 OR It 1\$ S3T t0 PR1v4+e.";

// Registration (register.php) -----------------------------------------

$lang['newuserregistrationsarenotpermitted'] = "s0rrY, nEw uSeR reg15+R4+i0ns AR3 NOT 4LloWeD r1GhT nOW. PLE@5e CHeck 84Ck L4+3R.";
$lang['usernameinvalidchars'] = "u53RNam3 C@n ONlY C0n+aiN 4-z, 0-9, _ - CH@r4C+3R\$";
$lang['usernametooshort'] = "u\$3rN@M3 mus+ Be 4 Min1Mum OF 2 Ch4R4C+eR\$ lONg";
$lang['usernametoolong'] = "u53rN@m3 MUSt B3 A m4XIMUM of 15 Ch4r4C+3RS L0N9";
$lang['usernamerequired'] = "a lOGOn N@ME 1S r3qUIr3d";
$lang['passwdmustnotcontainHTML'] = "p@s\$WORd MUSt NO+ cONt41N HtML +49S";
$lang['passwordinvalidchars'] = "p4SSWOrD C4N 0Nly Con+41N 4-z, 0-9, _ - cH@r4C+3R\$";
$lang['passwdtooshort'] = "p4s\$WORd MuS+ 83 4 mIN1MUm 0F 6 ch4R4c+3Rs L0nG";
$lang['passwdrequired'] = "a P@5SWOrD 15 R3QU1ReD";
$lang['confirmationpasswdrequired'] = "a coNf1RM4TI0n P4\$SwoRD 1\$ rEQu1red";
$lang['nicknamerequired'] = "a NIcKN4mE i5 R3QUIreD";
$lang['emailrequired'] = "aN EM@iL aDdRE\$S i\$ REquIr3d";
$lang['passwdsdonotmatch'] = "paSSW0RD5 D0 NOt M@tCH";
$lang['usernamesameaspasswd'] = "u53RnAME 4ND PASSw0Rd muS+ 8e D1FF3REN+";
$lang['usernameexists'] = "sORRY, 4 U\$3r WitH tH4T n4ME 4LR34DY EX1st\$";
$lang['successfullycreateduseraccount'] = "sucC3ssPHULly Cr34TED u5eR @Cc0uNT";
$lang['useraccountcreatedconfirmfailed'] = "y0ur U\$3R 4CCouNt H4\$ 8E3N CRe4+3D bU+ Teh R3QuIR3D c0NF1Rm@T10N 3M@IL W@s N0+ 5ENt. pLEA\$3 con+4C+ t3H pHOrUM 0wNeR +o REcT1FY +H1S. 1N tHI\$ m34Nt1m3 Pl3@SE cLIcK tHE C0N+1nUe BUTtoN +O loGin.";
$lang['useraccountcreatedconfirmsuccess'] = "y0UR USEr @cc0UNT h@5 83EN cR3@T3D 8U+ B3F0R3 J00 c4N \$+@R+ Po\$+1N9 J00 MUST cONpHIRm Y0UR 3m@1L 4DDr3SS. PLe4s3 CHEcK y0uR emaIL PHOr @ lINK +H4+ WiLL 4LloW J00 +0 C0NFiRM Y0UR ADDR3SS.";
$lang['useraccountcreated'] = "yOUR Us3r 4CCOUnt hA\$ BeEN cR34+3D \$UCC3sSFuLLY! Cl1CK thE COn+InUE BUTtoN 83L0w +0 L0GiN";
$lang['errorcreatinguserrecord'] = "erR0R cr3@t1N9 Us3r r3C0Rd";
$lang['userregistration'] = "u53R R39i\$+r4tI0N";
$lang['registrationinformationrequired'] = "r3g1sTR4+1ON INf0rM4+10N (R3QUIReD)";
$lang['profileinformationoptional'] = "proPHilE InF0RM@TIoN (oPT1ONaL)";
$lang['preferencesoptional'] = "pR3PhERence\$ (OptIOn4L)";
$lang['register'] = "re91\$T3r";
$lang['rememberpasswd'] = "remEMBEr pASSWorD";
$lang['birthdayrequired'] = "d4+3 0f 81rTH i\$ r3QUir3D 0R is InV4LId";
$lang['alwaysnotifymeofrepliestome'] = "n0+IFY 0N r3pLY +0 mE";
$lang['notifyonnewprivatemessage'] = "noTIFy ON NEw PRIv@TE MeSS@9E";
$lang['popuponnewprivatemessage'] = "pop UP 0n NEW pr1V@te mE\$S4GE";
$lang['automatichighinterestonpost'] = "aU+omA+1C H1gh InT3R3S+ on P0S+";
$lang['confirmpassword'] = "cOnfIRm P4SsWoRD";
$lang['invalidemailaddressformat'] = "iNVal1d 3M@iL aDDrESS phORm4+";
$lang['moreoptionsavailable'] = "morE PR0Ph1LE 4nd Pr3PhER3Nc3 OP+1oN\$ 4RE aV4Il4BLE 0nc3 J00 r39I\$t3R";
$lang['textcaptchaconfirmation'] = "cOnPh1RM4+10N";
$lang['textcaptchaexplain'] = "t0 +3H R19HT 1\$ 4 +3X+-C4P+CH4 1M4G3. pL3A\$3 +yp3 +H3 COd3 J00 C@N S33 IN THe 1M49E iN+0 +3H 1Npu+ pHI3Ld b3l0W iT.";
$lang['textcaptchaimgtip'] = "th1\$ 1\$ 4 C4P+CHa-P1CTUr3. 1+ is us3d +0 pr3V3NT aUt0m@t1c rE9i\$tr@T1On";
$lang['textcaptchamissingkey'] = "a c0nFirmaTI0N COD3 iS reQUiREd.";
$lang['textcaptchaverificationfailed'] = "teXT-C4p+CH4 VErif1C@tI0N c0de W@s 1nC0RREC+. Pl34\$3 Re-3N+Er I+.";
$lang['forumrules'] = "foRUM RUL35";
$lang['forumrulesnotification'] = "iN ORD3R +o Pr0c33D, j00 MUST @GR33 Wi+H +h3 F0LLOw1nG rULE\$";
$lang['forumrulescheckbox'] = "i HaVE r3@D, AnD aGr33 +o @biDe By +H3 pHoRUm RUl3s.";
$lang['youmustagreetotheforumrules'] = "j00 MUst @gR33 T0 t3H PH0RUm Rul3s 83PHor3 J00 c4N c0NT1Nu3.";

// Recent visitors list  (visitor_log.php) -----------------------------

$lang['member'] = "m3m83R";
$lang['searchforusernotinlist'] = "s3ARCH fOR 4 U53R N0+ in l1\$T";
$lang['yoursearchdidnotreturnanymatches'] = "y0ur SeARcH d1d NO+ R3+URn 4Ny M4+ChE5. tRY siMPlIPHy1ng yoUr \$3ARcH paR@mE+3RS ANd Try @gAIn.";
$lang['hiderowswithemptyornullvalues'] = "h1dE R0ws w1+H EMptY 0R nULl V4lU3s 1N s3lECteD COlUMN5";
$lang['showregisteredusersonly'] = "sHOW r391sTEr3d usER\$ OnLy (h1dE gU3s+S)";

// Relationships (user_rel.php) ----------------------------------------

$lang['relationships'] = "rel@TI0nshIPS";
$lang['userrelationship'] = "uS3R R3lA+ioNShIP";
$lang['userrelationships'] = "us3r RelA+1ONShiP\$";
$lang['failedtoremoveselectedrelationships'] = "f41lED +0 R3M0VE seL3C+3D R3L@tIONSh1p";
$lang['friends'] = "fr1ENd5";
$lang['ignoredcompletely'] = "i9NOR3D COMPle+ElY";
$lang['relationship'] = "rEL@ti0nSH1p";
$lang['restorenickname'] = "r3\$+OR3 US3r's n1CKN4M3";
$lang['friend_exp'] = "uS3R's po\$TS m4RKed w1TH @ &quot;FrIenD&quot; 1C0n.";
$lang['normal_exp'] = "u\$eR'S PO\$TS 4PPE4R 4\$ nORM@L.";
$lang['ignore_exp'] = "u53r'\$ poSt\$ Ar3 H1DdeN.";
$lang['ignore_completely_exp'] = "thrE4D\$ 4ND pOSTS +O 0R PHr0m U\$3r W1Ll AppEAr D3Le+Ed.";
$lang['display'] = "dISPL4Y";
$lang['displaysig_exp'] = "u53R'S S1GN@+Ure 15 DiSPl4yED 0N THe1r p0st\$.";
$lang['hidesig_exp'] = "u\$eR'S s19N4+URe I\$ HIDd3n 0N +He1r PoS+S.";
$lang['cannotignoremod'] = "j00 c4nN0T 1gNOR3 +H1S USer, 4S +hEY @RE a MOd3R4+OR.";
$lang['previewsignature'] = "pR3V1EW \$19n4TUR3";

// Search (search.php) -------------------------------------------------

$lang['searchresults'] = "se@RCh R3SUL+s";
$lang['usernamenotfound'] = "tHe US3RN@M3 J00 \$p3c1PH13D iN +H3 to OR pHR0M fIElD w@5 N0T pH0Und.";
$lang['notexttosearchfor'] = "oN3 0R @lL 0F Y0uR 5eArCH K3ywORD\$ wER3 1nV4LId. 5EARcH k3yW0RD\$ MU\$t B3 N0 SHOrT3R TH4n %d ch@r4cTErs, N0 loNGEr +H4N %d CH4R4C+3R\$ 4ND mus+ n0+ 4PP3AR 1N Th3 %s";
$lang['keywordscontainingerrors'] = "k3yW0Rds C0NT41N1NG 3rRORS: %s";
$lang['mysqlstopwordlist'] = "mySQl ST0Pw0RD li\$t";
$lang['foundzeromatches'] = "f0und: 0 m4+cH3\$";
$lang['found'] = "f0und";
$lang['matches'] = "m4tch3S";
$lang['prevpage'] = "pr3vI0US p49E";
$lang['findmore'] = "fiND M0r3";
$lang['searchmessages'] = "sE4RcH MessaG3S";
$lang['searchdiscussions'] = "s3ARch D1sCUSS10nS";
$lang['find'] = "fIND";
$lang['additionalcriteria'] = "addiTi0n4L cRiTERiA";
$lang['searchbyuser'] = "s3ARCh BY usER (0PT10N4l)";
$lang['folderbrackets_s'] = "fOlD3R(5)";
$lang['postedfrom'] = "p05+3D PhROM";
$lang['postedto'] = "p0ST3d +O";
$lang['today'] = "t0D4Y";
$lang['yesterday'] = "y3s+3RD4y";
$lang['daybeforeyesterday'] = "d@y 8EPh0RE ye\$+3RD@Y";
$lang['weekago'] = "%s w33K Ag0";
$lang['weeksago'] = "%s WE3KS 490";
$lang['monthago'] = "%s mon+h 490";
$lang['monthsago'] = "%s m0N+HS ag0";
$lang['yearago'] = "%s y3aR @9O";
$lang['beginningoftime'] = "b391nN1NG 0pH +1m3";
$lang['now'] = "now";
$lang['lastpostdate'] = "l@sT P0sT D4+3";
$lang['numberofreplies'] = "nUM8ER 0f R3PL1ES";
$lang['foldername'] = "folD3R N@ME";
$lang['authorname'] = "autHOR N4M3";
$lang['decendingorder'] = "n3wE\$+ phIRST";
$lang['ascendingorder'] = "oLD3\$+ F1RSt";
$lang['keywords'] = "keywORD5";
$lang['sortby'] = "sor+ 8Y";
$lang['sortdir'] = "soRT Dir";
$lang['sortresults'] = "s0r+ R3sUL+S";
$lang['groupbythread'] = "gr0UP 8y ThR3@d";
$lang['postsfromuser'] = "p0st\$ FR0M u\$3R";
$lang['threadsstartedbyuser'] = "thrE4D\$ \$t@R+3D 8y U\$3R";
$lang['searchfrequencyerror'] = "j00 C4N OnLY seARcH 0NcE Ev3RY %s SECondS. pLE@sE TRY @9@iN l4+3R.";
$lang['searchsuccessfullycompleted'] = "s3aRCh \$uCCESspHUlLY COMplET3D. %s";
$lang['clickheretoviewresults'] = "cl1cK H3re T0 V13W resULtS.";

// Search Popup (search_popup.php) -------------------------------------

$lang['select'] = "s3leC+";
$lang['searchforthread'] = "se4rch F0r +Hr34D";
$lang['mustspecifytypeofsearch'] = "j00 MU5+ SpEC1PHY +Yp3 0f S3ARcH TO P3Rph0RM";
$lang['unkownsearchtypespecified'] = "unkNOwn S3Arch +Yp3 \$PeC1F1eD";
$lang['mustentersomethingtosearchfor'] = "j00 MUSt EnT3R soM3THiN9 t0 S3ARcH PhOR";

// Start page (start_left.php) -----------------------------------------

$lang['recentthreads'] = "rEc3N+ +HRE@DS";
$lang['startreading'] = "s+4R+ REaD1NG";
$lang['threadoptions'] = "tHr3@D 0PTIoNS";
$lang['editthreadoptions'] = "eD1+ +hRE4D OP+10Ns";
$lang['morevisitors'] = "mOr3 v1sITOrS";
$lang['forthcomingbirthdays'] = "f0R+HcomIN9 B1R+hD@YS";

// Start page (start_main.php) -----------------------------------------

$lang['editstartpage_help'] = "j00 C@N edIt +H1S P@GE FR0M +H3 4dMIN INTeRPHaC3";

// Thread navigation (thread_list.php) ---------------------------------

$lang['newdiscussion'] = "n3W d1\$cUSsI0N";
$lang['createpoll'] = "cR3A+3 P0ll";
$lang['search'] = "sE@Rch";
$lang['searchagain'] = "s34rCH 4941N";
$lang['alldiscussions'] = "aLL D1\$Cu\$s10NS";
$lang['unreaddiscussions'] = "uNrE@d D1sCu55i0N\$";
$lang['unreadtome'] = "unrE4D &quot;to: m3&quot;";
$lang['todaysdiscussions'] = "t0D@Y's dISCusS10NS";
$lang['2daysback'] = "2 daYS BacK";
$lang['7daysback'] = "7 d@YS 8Ack";
$lang['highinterest'] = "hiGh 1N+3RESt";
$lang['unreadhighinterest'] = "uNR3AD HIGh 1N+er3\$T";
$lang['iverecentlyseen'] = "i'v3 rECEnTLy S3EN";
$lang['iveignored'] = "i'v3 1GN0R3D";
$lang['byignoredusers'] = "bY I9nOREd US3R\$";
$lang['ivesubscribedto'] = "i'vE sUbscr1B3D +O";
$lang['startedbyfriend'] = "s+aRT3D 8y PhR1ENd";
$lang['unreadstartedbyfriend'] = "unR34d StD 8y FR1EnD";
$lang['startedbyme'] = "st4R+3D bY m3";
$lang['unreadtoday'] = "unRE@D tOD@y";
$lang['deletedthreads'] = "d3le+3D +HR3@d\$";
$lang['goexcmark'] = "go!";
$lang['folderinterest'] = "f0ldER INt3rES+";
$lang['postnew'] = "pO5T n3w";
$lang['currentthread'] = "cUrR3NT +Hr34d";
$lang['highinterest'] = "h1gh In+3R3s+";
$lang['markasread'] = "m4RK 4S r3AD";
$lang['next50discussions'] = "n3xT 50 D1SCusSIOn\$";
$lang['visiblediscussions'] = "visiBL3 D1\$Cu\$S10N\$";
$lang['selectedfolder'] = "s3L3C+Ed pHOldER";
$lang['navigate'] = "n4v1G4+E";
$lang['couldnotretrievefolderinformation'] = "tHer3 4RE no pHOld3RS 4VaIl4BL3.";
$lang['nomessagesinthiscategory'] = "n0 M3SS@gE\$ 1N THis c@TEg0RY. pl3@S3 s3L3C+ 4N0+HeR, 0R %s Ph0R 4ll ThR34DS";
$lang['clickhere'] = "cL1Ck HErE";
$lang['prev50threads'] = "prEv1oUS 50 ThR3AD\$";
$lang['next50threads'] = "n3xT 50 THr34D\$";
$lang['nextxthreads'] = "nEX+ %s THr34dS";
$lang['threadstartedbytooltip'] = "thrE@D #%s STarTED bY %s. V1eW3D %s";
$lang['threadviewedonetime'] = "1 +im3";
$lang['threadviewedtimes'] = "%d t1MEs";
$lang['unreadthread'] = "unrE4D tHRE4D";
$lang['readthread'] = "r34d +hREaD";
$lang['unreadmessages'] = "uNr3@D mE\$s@gE\$";
$lang['subscribed'] = "sU8sCR18eD";
$lang['ignorethisfolder'] = "iGn0RE +H1S f0LDER";
$lang['stopignoringthisfolder'] = "s+OP 19n0r1N9 Th1s PHOldEr";
$lang['stickythreads'] = "sTiCkY tHre4d\$";
$lang['mostunreadposts'] = "m0ST UNRe4D Po\$TS";
$lang['onenew'] = "%d NEw";
$lang['manynew'] = "%d n3w";
$lang['onenewoflength'] = "%d nEW 0f %d";
$lang['manynewoflength'] = "%d nEW 0F %d";
$lang['ignorefolderconfirm'] = "aRe J00 \$URE j00 W4N+ +0 19N0r3 +h1\$ phOLd3R?";
$lang['unignorefolderconfirm'] = "aRe j00 SUR3 J00 w@N+ +0 StoP iGN0R1NG THi\$ F0LdER?";
$lang['confirmmarkasread'] = "aRe j00 SUrE J00 W@nT tO m4rK tEH s3LEc+3D +HR34DS 4\$ Re4d?";
$lang['successfullymarkreadselectedthreads'] = "sucC3\$\$pHULlY maRKed \$3lEC+3d +HRe4dS A\$ R3@D";
$lang['failedtomarkselectedthreadsasread'] = "f@1lED +O m@rK \$3Lec+3d tHR34D\$ a\$ r34D";
$lang['gotofirstpostinthread'] = "gO To F1R\$+ POs+ 1N +hr34D";
$lang['gotolastpostinthread'] = "g0 to l4sT P0\$t 1N +hRE4d";
$lang['viewmessagesinthisfolderonly'] = "v1EW MESS493\$ iN +HIs FOLd3r ONLY";
$lang['shownext50threads'] = "show N3XT 50 +HrE4D\$";
$lang['showprev50threads'] = "shOw pREv1oU\$ 50 thRE4Ds";
$lang['createnewdiscussioninthisfolder'] = "cRE@+3 neW D1\$cu\$S10N 1N Thi\$ F0LDER";
$lang['nomessages'] = "n0 M3sS493s";

// HTML toolbar (htmltools.inc.php) ------------------------------------
$lang['bold'] = "b0lD";
$lang['italic'] = "it4l1c";
$lang['underline'] = "undeRL1NE";
$lang['strikethrough'] = "s+RIK3+HR0U9h";
$lang['superscript'] = "sUP3RSCript";
$lang['subscript'] = "sU8Scr1P+";
$lang['leftalign'] = "l3fT-@lIgN";
$lang['center'] = "c3n+3R";
$lang['rightalign'] = "r1GH+-AL1GN";
$lang['numberedlist'] = "nUmb3R3D lISt";
$lang['list'] = "l1\$+";
$lang['indenttext'] = "indEN+ +3XT";
$lang['code'] = "c0D3";
$lang['quote'] = "quotE";
$lang['unquote'] = "uNquO+3";
$lang['spoiler'] = "sP01lER";
$lang['horizontalrule'] = "hOrIZ0NT4l RULE";
$lang['image'] = "iM49e";
$lang['hyperlink'] = "hYperLInk";
$lang['noemoticons'] = "dI\$A8LE 3MO+1cONS";
$lang['fontface'] = "foN+ F4c3";
$lang['size'] = "siz3";
$lang['colour'] = "coL0UR";
$lang['red'] = "r3d";
$lang['orange'] = "oR4NGE";
$lang['yellow'] = "yeLl0W";
$lang['green'] = "gre3N";
$lang['blue'] = "bLu3";
$lang['indigo'] = "indIG0";
$lang['violet'] = "vI0le+";
$lang['white'] = "wHIT3";
$lang['black'] = "bL@CK";
$lang['grey'] = "gReY";
$lang['pink'] = "p1NK";
$lang['lightgreen'] = "l19hT 9R33n";
$lang['lightblue'] = "l1ghT 8LU3";

// Forum Stats (messages.inc.php - messages_forum_stats()) -------------

$lang['forumstats'] = "forUM St@+s";
$lang['usersactiveinthepasttimeperiod'] = "%s @C+IV3 1N THE PAS+ %s. %s";

$lang['numactiveguests'] = "<b>%s</b> guESt\$";
$lang['oneactiveguest'] = "<b>1</b> GU3ST";
$lang['numactivemembers'] = "<b>%s</b> M3M83R\$";
$lang['oneactivemember'] = "<b>1</b> m3m83R";
$lang['numactiveanonymousmembers'] = "<b>%s</b> @NONyMoU\$ mEM8ER\$";
$lang['oneactiveanonymousmember'] = "<b>1</b> 4nONYm0uS M3M8ER";

$lang['numthreadscreated'] = "<b>%s</b> +hRe@DS";
$lang['onethreadcreated'] = "<b>1</b> THReaD";
$lang['numpostscreated'] = "<b>%s</b> po5+S";
$lang['onepostcreated'] = "<b>1</b> p0\$T";

$lang['younormal'] = "j00";
$lang['youinvisible'] = "j00 (1NVI5IBlE)";
$lang['viewcompletelist'] = "vieW coMPlETe L1s+";
$lang['ourmembershavemadeatotalofnumthreadsandnumposts'] = "oUr mEm83r\$ h4V3 M4d3 4 +Ot4L OF %s ANd %s.";
$lang['longestthreadisthreadnamewithnumposts'] = "l0nG3\$+ +HReaD i\$ <b>%s</b> wiTh %s.";
$lang['therehavebeenxpostsmadeinthelastsixtyminutes'] = "tH3rE h4V3 b3eN <b>%s</b> P0sTS m@De In TH3 l4s+ 60 mINUtES.";
$lang['therehasbeenonepostmadeinthelastsxityminutes'] = "tH3RE H4s B3EN <b>1</b> pO\$T M@dE 1N The L@ST 60 M1NU+3\$.";
$lang['mostpostsevermadeinasinglesixtyminuteperiodwasnumposts'] = "mo5t p0\$TS 3VEr MaDE iN 4 \$1N9LE 60 m1NUT3 p3R1OD 1s <b>%s</b> 0N %s.";
$lang['wehavenumregisteredmembersandthenewestmemberismembername'] = "we H4V3 <b>%s</b> R39IS+3rED meM8Er\$ 4nd tHE NEWe\$t M3Mb3R 1S <b>%s</b>.";
$lang['wehavenumregisteredmember'] = "w3 H4V3 %s RE9IS+3REd m3M8ERs.";
$lang['wehaveoneregisteredmember'] = "we H4VE 0n3 RE9I\$+3REd memBeR.";
$lang['mostuserseveronlinewasnumondate'] = "moST USERS 3V3R 0NlINe W4\$ <b>%s</b> ON %s.";
$lang['statsdisplaychanged'] = "s+4T\$ dIsPL@Y ch@ngED";

// Thread Options (thread_options.php) ---------------------------------

$lang['updatessavedsuccessfully'] = "uPDa+3s \$@V3D SUcC3sSPhULLy";
$lang['useroptions'] = "u\$3r OPti0NS";
$lang['markedasread'] = "m@RK3d AS r3AD";
$lang['postsoutof'] = "p0STS ouT 0F";
$lang['interest'] = "iNtER3ST";
$lang['closedforposting'] = "cl0S3d PH0R poSTiN9";
$lang['locktitleandfolder'] = "lOcK T1+le 4ND pHOLd3r";
$lang['deletepostsinthreadbyuser'] = "d3LE+3 P0ST\$ 1N tHReaD By U\$3r";
$lang['deletethread'] = "dELE+e +HrE4D";
$lang['permenantlydelete'] = "perM@NEn+LY D3LE+3";
$lang['movetodeleteditems'] = "m0vE T0 d3lE+3D Thr3ADS";
$lang['undeletethread'] = "uNDElE+3 ThR3AD";
$lang['markasunread'] = "m4rK @\$ UNRe4d";
$lang['makethreadsticky'] = "m4ke tHR3@D sTiCKY";
$lang['threareadstatusupdated'] = "thr34d r3AD \$+@tU\$ UpD@t3D \$UcC3s\$fuLLy";
$lang['interestupdated'] = "thrE4d 1NT3R3\$t ST@tuS uPd4+3D \$uCCes5fUllY";
$lang['failedtoupdatethreadreadstatus'] = "f41lEd +O Upd4T3 THre4D rEAd ST4+U\$";
$lang['failedtoupdatethreadinterest'] = "f41LeD +o UPd@+3 ThREaD iN+3R3St";
$lang['failedtorenamethread'] = "f41l3D +o REN@m3 +Hr3AD";
$lang['failedtomovethread'] = "f41lED +O m0VE THR34D T0 SPec1fIED fOLd3R";
$lang['failedtoupdatethreadstickystatus'] = "f41L3D +0 UpDA+3 THr34d S+1cKy \$T@TUS";
$lang['failedtoupdatethreadclosedstatus'] = "f41leD +0 UpD@te ThR34D cL0S3D \$T4+U\$";
$lang['failedtoupdatethreadlockstatus'] = "fA1leD to UPd4T3 ThR34D lOCk S+@+uS";
$lang['failedtodeletepostsbyuser'] = "f41L3d +0 DEL3t3 PO\$+s by S3L3C+3D useR";
$lang['failedtodeletethread'] = "f4ilED +0 DelE+3 Thr3@D.";
$lang['failedtoundeletethread'] = "f4IL3D +0 uN-D3LE+3 Thre4d";

// Dictionary (dictionary.php) -----------------------------------------

$lang['dictionary'] = "d1C+i0N4RY";
$lang['spellcheck'] = "sp3lL ChECk";
$lang['notindictionary'] = "nO+ 1N d1CTi0n4RY";
$lang['changeto'] = "cH4n93 +0";
$lang['restartspellcheck'] = "rE5+@R+";
$lang['cancelchanges'] = "c4NC3L ch4N93\$";
$lang['initialisingdotdotdot'] = "iniT14L1S1NG...";
$lang['spellcheckcomplete'] = "sPELL CHEcK 1S C0MPL3+e. t0 RES+aRt SpeLL cH3CK CLicK R3\$T@r+ Bu+TON 83lOW.";
$lang['spellcheck'] = "sP3ll cHEcK";
$lang['noformobj'] = "n0 PhoRm OBj3C+ SpEcIFIED f0R r3TURN TEX+";
$lang['bodytext'] = "b0DY +3xT";
$lang['ignore'] = "iGNOR3";
$lang['ignoreall'] = "iGNOR3 @Ll";
$lang['change'] = "chaN9e";
$lang['changeall'] = "cH@N9E @Ll";
$lang['add'] = "add";
$lang['suggest'] = "suG9EST";
$lang['nosuggestions'] = "(N0 5UGgES+10N\$)";
$lang['cancel'] = "c4nC3L";
$lang['dictionarynotinstalled'] = "no dICt1oN4Ry H4S BE3N In\$t@LLeD. PLe@5E ConT4C+ +H3 Ph0RUM OWN3R +O REm3dy Th1s.";

// Permissions keys ----------------------------------------------------

$lang['postreadingallowed'] = "p0\$+ rEAD1Ng ALL0weD";
$lang['postcreationallowed'] = "p05t cr3@tI0N 4LloWEd";
$lang['threadcreationallowed'] = "tHR34D cRE4T10N 4LloWeD";
$lang['posteditingallowed'] = "p0sT 3DI+1nG @lL0WeD";
$lang['postdeletionallowed'] = "pOST d3LE+10N @LLoWED";
$lang['attachmentsallowed'] = "att4CHMEN+s 4LLOwED";
$lang['htmlpostingallowed'] = "htmL pO\$+1N9 @LLow3D";
$lang['signatureallowed'] = "siGN4+URe 4LLoWED";
$lang['guestaccessallowed'] = "gu35T 4CCesS aLL0Wed";
$lang['postapprovalrequired'] = "p05+ aPPROV4l r3QUirED";

// RSS feeds gubbins

$lang['rssfeed'] = "r\$S Fe3d";
$lang['every30mins'] = "evERY 30 mINU+3s";
$lang['onceanhour'] = "oNC3 4N h0uR";
$lang['every6hours'] = "everY 6 HOURS";
$lang['every12hours'] = "eV3rY 12 H0URS";
$lang['onceaday'] = "oNcE a D4Y";
$lang['onceaweek'] = "oNc3 4 W33K";
$lang['rssfeeds'] = "r\$s FE3DS";
$lang['feedname'] = "f3eD N4M3";
$lang['feedfoldername'] = "fEED F0LDEr n4M3";
$lang['feedlocation'] = "f3Ed L0C4T10N";
$lang['threadtitleprefix'] = "thre4D +1+LE pR3F1X";
$lang['feednameandlocation'] = "fEeD N4M3 4Nd L0C4TI0n";
$lang['feedsettings'] = "f3ed s3++1NGs";
$lang['updatefrequency'] = "uPd4+3 phR3QueNCY";
$lang['rssclicktoreadarticle'] = "cL1CK h3RE To R3Ad +H1S aRTiCLe";
$lang['addnewfeed'] = "add N3W ph33D";
$lang['editfeed'] = "eD1+ FE3D";
$lang['feeduseraccount'] = "f3eD US3R 4cCOuNT";
$lang['noexistingfeeds'] = "no Exis+1NG rS\$ pH33D5 foUNd. +0 @dD 4 F3ED cL1CK +H3 '@dD NeW' bU++0N 83LOW";
$lang['rssfeedhelp'] = "h3r3 J00 c@N SE+Up \$0ME r\$S fEedS pHOr 4UToM4+1C pROP@g4+10N 1n+0 y0UR PH0ruM. +3H I+3M\$ PHr0M thE RSS FE3D\$ j00 aDD W1LL bE cRE4+eD 4\$ +HRead\$ WHiCH U\$3RS c4N rEPlY to @s 1F +Hey WeRE NOrm4L p0\$+s. TeH rS\$ FE3d mU\$T b3 4CCeSSIbLe VI4 h++P 0R I+ w1LL nOt wORK.";
$lang['mustspecifyrssfeedname'] = "musT SPeCIFy rsS FE3d N4ME";
$lang['mustspecifyrssfeeduseraccount'] = "mu5t SPECIFY RSS PH3eD US3R AcCOUN+";
$lang['mustspecifyrssfeedfolder'] = "mu\$t SP3CIFy R\$s PH33D ph0LD3R";
$lang['mustspecifyrssfeedurl'] = "mU5t SPeCIfY R5S FEeD urL";
$lang['mustspecifyrssfeedupdatefrequency'] = "mu5T sPEc1PhY RSs Fe3D UpD4+3 Fr3QUenCY";
$lang['unknownrssuseraccount'] = "unkN0WN r\$s U\$3R 4CcoUnT";
$lang['rssfeedsupportshttpurlsonly'] = "rSs PH33d \$UppORTS htTP urL\$ 0NLY. S3cUR3 PHE3ds (HT+P\$://) @R3 N0t SuPP0r+ED.";
$lang['rssfeedurlformatinvalid'] = "rss PH33d URl PH0Rm4+ is Inv4LiD. urL mu\$+ INcLUD3 SChEME (E.9. h+Tp://) @ND A hOSTnaME (3.G. wWW.H0\$+n@M3.coM).";
$lang['rssfeeduserauthentication'] = "r\$\$ PheED D0ES N0+ \$uPpoR+ h+tP us3R @uTH3N+1C4T1ON";
$lang['successfullyremovedselectedfeeds'] = "sucC3\$SpHUlLY r3MOVeD \$3l3C+3D PH3EDS";
$lang['successfullyaddedfeed'] = "sUcCe\$\$PhuLlY @dDEd NeW F3ED";
$lang['successfullyeditedfeed'] = "sUcC3\$sPHuLLy 3D1+ED FE3D";
$lang['failedtoremovefeeds'] = "f4il3D +o REm0V3 \$0m3 OR 4ll 0F tH3 S3L3C+3D fEeDS";
$lang['failedtoaddnewrssfeed'] = "f4ILED +0 AdD neW rSS f3Ed";
$lang['failedtoupdaterssfeed'] = "f41Led tO UPDaTE Rss pHEeD";
$lang['rssstreamworkingcorrectly'] = "r5S sTR34M aPP34R\$ T0 b3 W0rK1Ng C0RReC+ly";
$lang['rssstreamnotworkingcorrectly'] = "rSS STr3AM w4s eMpTY 0R COUld N0T B3 PhOUnD";
$lang['invalidfeedidorfeednotfound'] = "inv4LID f33D 1D oR F3Ed N0T foUNd";

// PM Export Options

$lang['pmexportastype'] = "exp0RT @s +yP3";
$lang['pmexporthtml'] = "h+ml";
$lang['pmexportxml'] = "xML";
$lang['pmexportplaintext'] = "pL41n T3X+";
$lang['pmexportmessagesas'] = "exP0RT me5S493\$ A\$";
$lang['pmexportonefileforallmessages'] = "onE F1lE pH0R 4LL M3S\$@g3\$";
$lang['pmexportonefilepermessage'] = "on3 ph1LE pER m3SS@gE";
$lang['pmexportattachments'] = "exPOrT @tT4cHM3NTS";
$lang['pmexportincludestyle'] = "iNcLUDe fORUm \$TyLE \$h33T";
$lang['pmexportwordfilter'] = "applY WOrD F1L+3R +0 mE\$S@9ES";

// Thread merge / split options

$lang['threadhasbeensplit'] = "tHr34D h4s BeEN \$PLIt";
$lang['threadhasbeenmerged'] = "thR34d H4S be3N mERG3D";
$lang['mergesplitthread'] = "m3R9E / sPli+ +HReAD";
$lang['mergewiththreadid'] = "mEr93 Wi+H +HR34D iD:";
$lang['postsinthisthreadatstart'] = "p0st\$ iN +HIs +HreAD 4t s+@r+";
$lang['postsinthisthreadatend'] = "p0\$t\$ 1N th1s +hRE4D @T 3Nd";
$lang['reorderpostsintodateorder'] = "r3-ORdeR P0\$+s In+0 D@T3 0Rd3r";
$lang['splitthreadatpost'] = "spl1T +hR3@D AT P0ST:";
$lang['selectedpostsandrepliesonly'] = "s3l3C+3D pO\$t @ND REpL1ES OnLy";
$lang['selectedandallfollowingposts'] = "sEl3C+3D anD AlL f0lL0W1N9 pOSTs";

$lang['threadmovedhere'] = "h3R3";

$lang['thisthreadhasmoved'] = "<b>tHRE4D\$ meR93d:</b> thi\$ THR3ad H4s m0vEd %s";
$lang['thisthreadwasmergedfrom'] = "<b>tHr34d\$ MErgED:</b> th1\$ tHREad W4\$ MeR9ED PHr0M %s";
$lang['somepostsinthisthreadhavebeenmoved'] = "<b>tHre@D \$PLIT:</b> \$oM3 POS+S In +H1S +hREaD H4V3 b33N Mov3D %s";
$lang['somepostsinthisthreadweremovedfrom'] = "<b>thr3Ad SPl1t:</b> sOMe POS+s 1N thI5 thR34D wERE MOVEd FR0M %s";

$lang['thisposthasbeenmoved'] = "<b>tHr34D Spli+:</b> tHIS p0ST haS bE3N m0VEd %s";

$lang['invalidfunctionarguments'] = "inv4l1D FunCti0N 4RguM3N+S";
$lang['couldnotretrieveforumdata'] = "couLd N0t R3+r13V3 F0RUm D4+A";
$lang['cannotmergepolls'] = "on3 oR MoR3 +hRE4D\$ iS 4 p0lL. J00 C4NN0T M3RGE POLls";
$lang['couldnotretrievethreaddatamerge'] = "coulD NO+ r3tR13VE thR34D dA+4 fR0M onE Or M0r3 +hRE4D\$";
$lang['couldnotretrievethreaddatasplit'] = "c0ULd NOt rE+riEvE +HRe4d d@T@ FRom \$OURCe +HrE4D";
$lang['couldnotretrievepostdatamerge'] = "c0ULd NOT R3+RI3ve POst D4+A phR0M 0ne Or MOr3 ThR3ADS";
$lang['couldnotretrievepostdatasplit'] = "couLD N0T rETR13V3 P0sT d4+A Fr0M \$0uRCe Thr3@D";
$lang['failedtocreatenewthreadformerge'] = "f4iL3D t0 CreAte NeW tHRe4d F0R mERge";
$lang['failedtocreatenewthreadforsplit'] = "f@iLED tO CreATe New +HR3ad F0R \$PL1+";

// Thread subscriptions

$lang['threadsubscriptions'] = "tHR3@D su8sCRiPTiONS";
$lang['couldnotupdateinterestonthread'] = "c0ULD n0+ UpD@Te IN+Ere\$T 0N ThrEAd '%s'";
$lang['threadinterestsupdatedsuccessfully'] = "thre4d IN+eRe5T5 UpD4+3D \$uCC3SSFuLLy";
$lang['nothreadsubscriptions'] = "j00 @re NOt SuBSCR1B3D +0 @Ny tHR3@dS.";
$lang['resetselected'] = "r3\$3+ S3LeCT3D";
$lang['allthreadtypes'] = "alL tHReaD +YP3s";
$lang['ignoredthreads'] = "ign0r3D +hrE4D\$";
$lang['highinterestthreads'] = "hi9h INteRES+ +Hr34d\$";
$lang['subscribedthreads'] = "su8\$CRIb3d +hRE4D5";
$lang['currentinterest'] = "curreN+ In+3RES+";

// Browseable user profiles

$lang['youcanonlyaddthreecolumns'] = "j00 C@n OnLY 4DD 3 COlUMn5. +o @dD 4 n3W cOLumN cLOse @n 3X1\$tIN9 oN3";
$lang['columnalreadyadded'] = "j00 HAVe 4LReAdY Add3D +HI\$ COLUmN. 1f J00 W4Nt TO rEm0V3 I+ Cl1CK 1+s Cl0s3 BU++ON";

?>