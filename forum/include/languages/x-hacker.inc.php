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

/* $Id: x-hacker.inc.php,v 1.255 2007-10-16 21:47:57 decoyduck Exp $ */

// British English language file

// Language character set and text direction options -------------------

$lang['_isocode'] = "en";
$lang['_textdir'] = "ltr";

// Months --------------------------------------------------------------

$lang['month'][1]  = "j4nuary";
$lang['month'][2]  = "f38ru4ry";
$lang['month'][3]  = "m@RCH";
$lang['month'][4]  = "aPrIL";
$lang['month'][5]  = "m4Y";
$lang['month'][6]  = "jUn3";
$lang['month'][7]  = "juLY";
$lang['month'][8]  = "auGUsT";
$lang['month'][9]  = "sEpt3mBER";
$lang['month'][10] = "oCt083r";
$lang['month'][11] = "n0VEM83r";
$lang['month'][12] = "deCEM83r";

$lang['month_short'][1]  = "jAn";
$lang['month_short'][2]  = "fe8";
$lang['month_short'][3]  = "mar";
$lang['month_short'][4]  = "aPr";
$lang['month_short'][5]  = "mAy";
$lang['month_short'][6]  = "jun";
$lang['month_short'][7]  = "jul";
$lang['month_short'][8]  = "auG";
$lang['month_short'][9]  = "sEp";
$lang['month_short'][10] = "oC+";
$lang['month_short'][11] = "nOV";
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

$lang['date_periods']['year']   = "%s y34r";
$lang['date_periods']['month']  = "%s mon+H";
$lang['date_periods']['week']   = "%s W3ek";
$lang['date_periods']['day']    = "%s DAy";
$lang['date_periods']['hour']   = "%s HOuR";
$lang['date_periods']['minute'] = "%s minU+3";
$lang['date_periods']['second'] = "%s SECOnD";

// As above but plurals (2 years vs. 1 year, etc.)

$lang['date_periods_plural']['year']   = "%s yE4r5";
$lang['date_periods_plural']['month']  = "%s M0N+hS";
$lang['date_periods_plural']['week']   = "%s weEk\$";
$lang['date_periods_plural']['day']    = "%s DaY\$";
$lang['date_periods_plural']['hour']   = "%s hour\$";
$lang['date_periods_plural']['minute'] = "%s M1nu+3S";
$lang['date_periods_plural']['second'] = "%s \$eConDS";

// Short hand periods (example: 1y, 2m, 3w, 4d, 5hr, 6min, 7sec)

$lang['date_periods_short']['year']   = "%sy";    // 1y
$lang['date_periods_short']['month']  = "%sm";    // 2m
$lang['date_periods_short']['week']   = "%sw";    // 3w
$lang['date_periods_short']['day']    = "%sd";    // 4d
$lang['date_periods_short']['hour']   = "%shr";   // 5hr
$lang['date_periods_short']['minute'] = "%sM1n";  // 6min
$lang['date_periods_short']['second'] = "%sSeC";  // 7sec

// Common words --------------------------------------------------------

$lang['percent'] = "peRCEN+";
$lang['average'] = "av3rage";
$lang['approve'] = "aPPR0VE";
$lang['banned'] = "bANn3D";
$lang['locked'] = "l0cked";
$lang['add'] = "aDd";
$lang['advanced'] = "aDVAnC3d";
$lang['active'] = "aC+ivE";
$lang['style'] = "s+YL3";
$lang['go'] = "gO";
$lang['folder'] = "f0LD3r";
$lang['ignoredfolder'] = "iGNoR3D FOLd3r";
$lang['folders'] = "f0Ld3R\$";
$lang['thread'] = "tHR34D";
$lang['threads'] = "tHR3@ds";
$lang['threadlist'] = "thR3@D Lis+";
$lang['message'] = "mE\$S4G3";
$lang['messagenumber'] = "m3ss4g3 Num8er";
$lang['from'] = "fR0M";
$lang['to'] = "t0";
$lang['all_caps'] = "aLl";
$lang['of'] = "oPh";
$lang['reply'] = "r3PlY";
$lang['forward'] = "f0Rw4RD";
$lang['replyall'] = "r3Ply +0 4Ll";
$lang['pm_reply'] = "rEPLy @5 pM";
$lang['delete'] = "d3L3TE";
$lang['deleted'] = "dEl3tED";
$lang['edit'] = "eD1+";
$lang['privileges'] = "pR1viL3G3S";
$lang['ignore'] = "i9n0re";
$lang['normal'] = "nOrm4L";
$lang['interested'] = "in+er3s+ED";
$lang['subscribe'] = "sU85cri8E";
$lang['apply'] = "apply";
$lang['download'] = "d0Wnl04d";
$lang['save'] = "saVe";
$lang['update'] = "uPd4TE";
$lang['cancel'] = "c4nc3L";
$lang['retry'] = "r3+RY";
$lang['continue'] = "cont1nu3";
$lang['attachment'] = "aT+4ChMEnt";
$lang['attachments'] = "aT+4ChMENTs";
$lang['imageattachments'] = "ima93 4++4chM3nts";
$lang['filename'] = "f1len4mE";
$lang['dimensions'] = "dIMENsi0n5";
$lang['downloadedxtimes'] = "dOwnloAD3D: %d +1m3s";
$lang['downloadedonetime'] = "dOWnL0@d3D: 1 T1m3";
$lang['size'] = "s1ze";
$lang['viewmessage'] = "v13w mEss49E";
$lang['deletethumbnails'] = "deL3+E +hum8n4iL\$";
$lang['logon'] = "lO90N";
$lang['more'] = "m0r3";
$lang['recentvisitors'] = "rEc3n+ VisiT0RS";
$lang['username'] = "u\$Ern4mE";
$lang['clear'] = "cL3@r";
$lang['action'] = "actI0n";
$lang['unknown'] = "unkN0WN";
$lang['none'] = "n0NE";
$lang['preview'] = "pR3v13w";
$lang['post'] = "p0st";
$lang['posts'] = "pOs+5";
$lang['change'] = "cHangE";
$lang['yes'] = "y3s";
$lang['no'] = "no";
$lang['signature'] = "sI9NaturE";
$lang['signaturepreview'] = "s19N4+UrE prev13w";
$lang['signatureupdated'] = "sI9N@+Ure UpD@+3d";
$lang['signatureupdatedforallforums'] = "sI9natur3 Updated Phor 4Ll FOrUmS";
$lang['back'] = "b@ck";
$lang['subject'] = "sU8j3CT";
$lang['close'] = "cLo\$3";
$lang['name'] = "n4m3";
$lang['description'] = "d3sCrip+10n";
$lang['date'] = "d@te";
$lang['view'] = "vI3w";
$lang['enterpasswd'] = "ent3r p@5\$w0rD";
$lang['passwd'] = "paSswoRD";
$lang['ignored'] = "iGn0rEd";
$lang['guest'] = "guE5+";
$lang['next'] = "nEXT";
$lang['prev'] = "pR3V10U\$";
$lang['others'] = "o+h3rs";
$lang['nickname'] = "nickn4ME";
$lang['emailaddress'] = "eM41L 4ddREs\$";
$lang['confirm'] = "c0nFIRm";
$lang['email'] = "em4IL";
$lang['poll'] = "poLl";
$lang['friend'] = "fr1enD";
$lang['success'] = "sUcCEss";
$lang['error'] = "erRor";
$lang['warning'] = "waRN1ng";
$lang['guesterror'] = "s0rry, j00 nEeD To 83 lOGg3d in +0 U\$3 +hiS pH34+uR3.";
$lang['loginnow'] = "l09in n0w";
$lang['unread'] = "unRE4d";
$lang['all'] = "all";
$lang['allcaps'] = "aLl";
$lang['permissions'] = "peRMIs\$1on5";
$lang['type'] = "tyP3";
$lang['print'] = "pr1nT";
$lang['sticky'] = "s+1cky";
$lang['polls'] = "p0LLs";
$lang['user'] = "u\$Er";
$lang['enabled'] = "eN@BlED";
$lang['disabled'] = "d1\$4bl3D";
$lang['options'] = "op+10n\$";
$lang['emoticons'] = "eM0+iCON\$";
$lang['webtag'] = "wE8tag";
$lang['makedefault'] = "m@k3 D3fAUl+";
$lang['unsetdefault'] = "uNsE+ D3f4ul+";
$lang['rename'] = "rEn4M3";
$lang['pages'] = "p4GES";
$lang['used'] = "u\$3d";
$lang['days'] = "d4YS";
$lang['usage'] = "u\$493";
$lang['show'] = "shOw";
$lang['hint'] = "h1n+";
$lang['new'] = "new";
$lang['referer'] = "r3PH3r3r";
$lang['thefollowingerrorswereencountered'] = "t3H F0LL0wing 3rRors w3rE ENCOun+ER3D:";

// Admin interface (admin*.php) ----------------------------------------

$lang['admintools'] = "aDm1n +0olS";
$lang['forummanagement'] = "foRUm M@n493M3n+";
$lang['accessdeniedexp'] = "j00 d0 no+ h4VE permi\$SI0n t0 Use +hI5 \$eCt10n.";
$lang['managefolders'] = "m4N4G3 f0LDEr\$";
$lang['manageforums'] = "m@N@GE pH0RUM\$";
$lang['manageforumpermissions'] = "m4N49e f0rum peRmIss1ons";
$lang['foldername'] = "fOLD3r name";
$lang['move'] = "m0v3";
$lang['closed'] = "clOsED";
$lang['open'] = "oP3n";
$lang['restricted'] = "rES+ricTED";
$lang['forumiscurrentlyclosed'] = "%s i5 CUrr3nTLY ClOseD";
$lang['youdonothaveaccesstoforum'] = "j00 do not h4v3 aCCE\$S +0 %s";
$lang['toapplyforaccessplease'] = "t0 @pplY F0r aCCEs\$ plE453 C0NT4c+ TEH f0rum oWn3r.";
$lang['adminforumclosedtip'] = "iPh J00 w@nT T0 CH@NG3 soM3 \$e++1n9S 0N YOUR PH0rum CLICK +hE @DM1N linK 1N t3H N4v194+10n B4r @b0V3.";
$lang['newfolder'] = "neW fold3R";
$lang['nofoldersfound'] = "n0 3xi\$+1NG pholDERS PhounD. +o 4DD A F0LDEr CLiCk +Eh '4dd n3w' 8u++0N BeLow.";
$lang['forumadmin'] = "foRum @dm1N";
$lang['adminexp_1'] = "u\$3 +he M3nU On +3h lePH+ to M4n@9E +hINGs 1N Your pHOrUm.";
$lang['adminexp_2'] = "<b>u53rs</b> 4LL0w\$ J00 t0 Se+ IndiVIDUal u5er pERm1S\$1ON\$, 1ncLUd1N9 @PPO1N+1ng m0d3R4+0R5 anD 949G1n9 P30pLE.";
$lang['adminexp_3'] = "<b>u\$3r gr0UP\$</b> aLLoW\$ j00 +o Cre4TE U53R Gr0upS +O @5S1gn p3RMi\$si0NS +0 4s many or @s ph3W U\$3RS QU1cKly 4ND E4S1ly.";
$lang['adminexp_4'] = "<b>b4N COn+r0lS</b> 4LL0w\$ +H3 B4nn1ng 4nD un-B4nn1ng oph 1P 4ddr3SseS, H++p reFER3R\$, UsErn@M3s, 3M41L @DDRe\$s3s @ND N1CKN4M3S.";
$lang['adminexp_5'] = "<b>fOLDER\$</b> @ll0W\$ +h3 cRE4+10N, m0d1PH1C4T10n 4nD dEl3T10n 0pH f0Lder\$.";
$lang['adminexp_6'] = "<b>rs5 Ph33Ds</b> 4Ll0w\$ j00 t0 M4NA93 rSS F3eds FoR pR0P4g4t10n Int0 y0UR FOrum.";
$lang['adminexp_7'] = "<b>pR0PH1leS</b> l3+s j00 cu5+0m153 tH3 1+ems th@+ appE@r 1n +he usEr pr0pHiLEs.";
$lang['adminexp_8'] = "<b>forUm sEtT1Ngs</b> Allow5 j00 +0 CUs+om1\$e yoUr f0rum's n@me, 4PpE4r4nCE 4ND m4ny othEr ThiN9s.";
$lang['adminexp_9'] = "<b>s+@R+ p@g3</b> l3+S J00 CU\$+0MIse YouR PH0rum'S st4R+ PA93.";
$lang['adminexp_10'] = "<b>f0Rum \$+yL3</b> 4LLOw\$ j00 t0 gEnER@+3 R@nDom s+yL3s pHoR y0Ur PhorUm m3M83rs +o UsE.";
$lang['adminexp_11'] = "<b>w0RD F1lTER</b> 4llows j00 +O PhIlTEr WorDS J00 D0n'+ W@N+ tO 83 UsED on yoUr pHorum.";
$lang['adminexp_12'] = "<b>p0St1N9 \$+4ts</b> 9en3R4+3S 4 R3P0r+ l1\$+1Ng ThE +0p 10 poSTEr5 in @ DEFin3d pErIoD.";
$lang['adminexp_13'] = "<b>fORUM lInKs</b> LEtS J00 m@N493 +3h linK\$ dr0PD0wn 1n T3h n@v1g4T10n B4r.";
$lang['adminexp_14'] = "<b>v13w l09</b> lists r3CEn+ 4cti0N\$ BY Th3 pHORUm m0dEr@+0RS.";
$lang['adminexp_15'] = "<b>m@n@GE f0rUMS</b> LETs j00 Cr34tE @nD D3l3+3 4nD CL0SE oR R30pEn F0RUM5.";
$lang['adminexp_16'] = "<b>glOB4l f0RUM 53tt1N95</b> 4LlowS j00 +0 m0D1fy Se+ting\$ wh1cH @phf3c+ AlL f0RuM\$.";
$lang['adminexp_17'] = "<b>p0st 4pproV4l Qu3U3</b> Allows j00 +o vi3W 4ny p0\$+s Aw4I+InG @pprov@L 8Y 4 MoD3R@+0r.";
$lang['adminexp_18'] = "<b>v1s1+0R LoG</b> AlLow5 j00 tO V13w 4N ExTEND3d lI\$+ OF V1SIT0R\$ inClUD1NG ThEIr http r3FER3R\$.";
$lang['createforumstyle'] = "cR34+e @ F0rum stYl3";
$lang['newstylesuccessfullycreated'] = "n3W \$+Yl3 SuCC3SsFUllY crE4+3d.";
$lang['stylealreadyexists'] = "a \$+yLE with +H4t pHiLEnam3 4Lr34Dy ExIs+\$.";
$lang['stylenofilename'] = "j00 d1d noT EntEr @ pHil3N4m3 +0 sav3 tEH \$+yLE Wi+h.";
$lang['stylenodatasubmitted'] = "cOUlD n0+ rEAD F0RUm 5+ylE D4T4.";
$lang['styleexp'] = "u53 +hI\$ pa93 +o h3LP cRE4+e @ R@nD0MLY gEn3RA+3d S+ylE F0r y0UR pHorUm.";
$lang['stylecontrols'] = "coNTRols";
$lang['stylecolourexp'] = "cl1ck on a COl0ur to M4K3 4 N3w S+yle sH33+ B4\$3d 0N Th4+ colour. CURRENt 84\$E C0l0uR 1s pH1r\$+ iN L1\$+.";
$lang['standardstyle'] = "st@ND4RD s+yL3";
$lang['rotelementstyle'] = "r0T4+3d 3lEMEn+ 5+YLe";
$lang['randstyle'] = "r@nd0M 5+yl3";
$lang['thiscolour'] = "tH1S COL0UR";
$lang['enterhexcolour'] = "or 3NTEr @ h3X COlouR +0 8AsE @ n3W s+yL3 \$hEE+ On";
$lang['savestyle'] = "s4v3 +h1\$ \$+yLE";
$lang['styledesc'] = "stYL3 d3SCR1p+ION";
$lang['stylefilenamemayonlycontain'] = "s+YLE f1L3n4M3 m4y only COnT4iN L0w3rC4\$e letTERs (@-Z), NuMBeR\$ (0-9) 4ND UnD3rsCORe.";
$lang['stylepreview'] = "stYLe prEV13w";
$lang['welcome'] = "w3LC0m3";
$lang['messagepreview'] = "mE5S49e PReV1ew";
$lang['users'] = "u\$ERs";
$lang['usergroups'] = "u53r 9roUp\$";
$lang['mustentergroupname'] = "j00 MU\$+ 3N+3r 4 9r0up N4m3";
$lang['profiles'] = "pR0f1l3s";
$lang['manageforums'] = "m4NA93 Phorums";
$lang['forumsettings'] = "f0rum s3tT1Ngs";
$lang['globalforumsettings'] = "gL0bal phorUm 53t+inGs";
$lang['settingsaffectallforumswarning'] = "<b>n0+3:</b> THEsE \$3tt1N9\$ @phf3c+ AlL F0RUm\$. WH3R3 +3h s3T+1nG Is dUpLiC@tEd On tH3 1ndiViDU4L F0RUm's 53tt1n9s P4g3 th4t wiLL +4k3 pR3C3denCE 0ver +3H 5ETt1N95 j00 Ch@Ng3 h3rE.";
$lang['startpage'] = "sT@R+ p@gE";
$lang['startpageerror'] = "y0Ur 5+@r+ Pa93 cOUlD nO+ BE s@vED l0c@lLy to teH 5ERvEr B3C4us3 p3rmis\$1on Was d3NIEd.</p><p>to ch@Ng3 y0ur st4RT p493 pl3AS3 clICK T3H D0wnlo4d BU++0n B3l0W WhIch wIll pR0mpt j00 To S@V3 +H3 Ph1l3 +0 y0ur h4RD DRIv3. j00 C@N th3n UpL04d tH1\$ Fil3 +0 y0UR s3rver in+0 th3 F0ll0Wing ph0LDEr, If n3C3ss4Ry cR34t1n9 th3 ph0lDeR \$+Ruc+ur3 in +EH pr0CEss.</p><p><b>%s</b></p><p>pLease n0+3 th4T \$Ome 8Rowser\$ m4y Ch4N9E tEh n4m3 0PH teh pHil3 up0n D0wnlo4d.  when upLo@din9 +eh fIL3 pLe45e M@ke sure that 1+ is n@Med \$+4RT_ma1n.php 0+hErw1\$e yoUr stARt p@G3 w1ll 4pPE4r UnCh@nged.";
$lang['failedtoopenmasterstylesheet'] = "yOur f0rum stYl3 COUld no+ Be s4V3D BEcAU\$e t3h M4\$+3r \$TYL3 \$h33+ C0ulD nO+ BE L04D3d. T0 \$@vE yoUR 5+yle +EH m4ster sTyL3 \$heET (MaKE_\$+ylE.C5s) mU\$+ 8E Loc4tED iN +3h 5tyle5 D1R3c+0ry oF Y0UR 83eH1V3 f0RUm IN\$+4ll4+I0N.";
$lang['makestyleerror'] = "yOur f0rUm \$+yle cOULd N0t 8e S@v3d loC4lLY to th3 seRV3r 8Ec4US3 pERM1SSI0n was deNi3D. t0 s4VE yOUr pHorum \$TYl3 plE4S3 cl1Ck th3 d0wNl0aD 8uT+on 8EL0w wh1CH W1LL pr0mP+ j00 To s@ve tH3 pHiL3 +0 Your h4Rd DrIV3. j00 C4n +HEN Uplo@D +h15 f1l3 T0 y0Ur 53rvER 1nto %s FoldeR, 1ph neCe\$\$@ry CR34+ing +eH f0lDER s+ructUr3 IN +h3 pr0c3ss. J00 \$H0uLD not3 th@+ S0M3 8row53r5 m4y ch4nge +Eh n4m3 0f the F1L3 Up0N d0wnlo@D. wh3n Upl0AD1Ng +HE f1L3 pl34\$e M4K3 sur3 th4+ I+ 15 N@m3d STyl3.c\$S 0+H3rwi5E thE PHorum \$+ylE wilL B3 uNU54Ble.";
$lang['uploadfailed'] = "y0UR n3W st4r+ Pa93 COuld n0+ BE UpLoaDED +o TEh \$ERV3r B3C4us3 PErmissIoN W4\$ Den13D. pl34\$3 ChECk th4+ +h3 weB sErV3R / pHp pRoCE\$S I\$ 48LE to wr1+3 +o +hE %s F0ldEr 0N yOuR \$3rver.";
$lang['forumstyle'] = "fOrum s+ylE";
$lang['wordfilter'] = "wORD phIlt3R";
$lang['forumlinks'] = "fOrum l1nk5";
$lang['viewlog'] = "vIew l0G";
$lang['noprofilesectionspecified'] = "n0 proph1LE sEC+10n sp3CIphI3D.";
$lang['itemname'] = "iTem n4mE";
$lang['moveto'] = "m0V3 +0";
$lang['manageprofilesections'] = "m4N@GE pr0PHIl3 s3C+I0n5";
$lang['sectionname'] = "s3c+i0n n@m3";
$lang['items'] = "i+3m\$";
$lang['mustspecifyaprofilesectionid'] = "mus+ SP3cify A PRofilE 53c+iOn ID";
$lang['mustsepecifyaprofilesectionname'] = "muSt \$PEc1fy 4 pR0pHil3 \$ec+1oN N@mE";
$lang['noprofilesectionsfound'] = "n0 Ex1st1NG pr0PHIle 5eCt10nS F0unD. +0 aDD 4 pR0philE sEC+10N Cl1ck TEh '@dD nEW' BU++0N B3l0w.";
$lang['addnewprofilesection'] = "aDd new pRoph1l3 s3C+i0N";
$lang['successfullyaddedprofilesection'] = "sucCE\$SFULly 4DDEd pr0pH1l3 \$ECT1on";
$lang['successfullyeditedprofilesection'] = "succ3sSFUlLy EDi+eD PropHil3 \$ect10n";
$lang['addnewprofilesection'] = "add n3w propHil3 s3CtiOn";
$lang['mustsepecifyaprofilesectionname'] = "must 5P3ciPHY 4 pr0Ph1l3 \$ECt10n name";
$lang['successfullyremovedselectedprofilesections'] = "sucC3\$\$PhullY ReMoV3D \$3leC+3d PR0fil3 \$Ec+10n\$";
$lang['failedtoremoveprofilesections'] = "f4Il3d +0 r3MoV3 PR0file s3C+i0n\$";
$lang['viewitems'] = "v13w 1+3M\$";
$lang['successfullyaddednewprofileitem'] = "sucC3sspHuLLY 4DdED nEw pRoph1L3 i+3M";
$lang['successfullyeditedprofileitem'] = "sucCE\$SFuLly 3Di+3d Pr0phil3 1tem";
$lang['successfullyremovedselectedprofileitems'] = "sUcCEs\$fully rEm0v3D \$3lECTeD pr0PHILe I+EMs";
$lang['failedtoremoveprofileitems'] = "f41l3d to rEmovE propHiL3 i+3m5";
$lang['noexistingprofileitemsfound'] = "ther3 arE no Ex1st1n9 prOFIle i+3ms 1n tH1\$ \$3C+1ON. t0 4dD 4N I+3M Cl1ck th3 'ADD n3W' BU+t0n B3low.";
$lang['edititem'] = "eDIT iTEm";
$lang['invalidprofilesectionid'] = "iNv4l1D pr0F1l3 s3C+i0n 1D oR \$3CtioN NO+ pH0UND";
$lang['invalidprofileitemid'] = "inV4l1d pRophiLE 1+3m ID oR iTem N0t foUnd";
$lang['addnewitem'] = "aDd n3w 1tEm";
$lang['youmustenteraprofileitemname'] = "j00 mU\$T Ent3r 4 pRofIl3 1+3M N4ME";
$lang['invalidprofileitemtype'] = "iNvaliD pR0PHilE 1+3m +YPE sEL3C+3d";
$lang['failedtocreatenewprofileitem'] = "f@1Led To CREa+e NEw Pr0ph1lE 1+em";
$lang['failedtoupdateprofileitem'] = "f41l3D to upd@+3 proPhIlE ITEm";
$lang['startpageupdated'] = "sTaR+ P@g3 UpD4+3D. %s";
$lang['viewupdatedstartpage'] = "v1ew upd4tED 5+@rt Pag3";
$lang['editstartpage'] = "eDIT sT4r+ p493";
$lang['nouserspecified'] = "n0 u\$3r \$p3C1Ph1ED.";
$lang['manageuser'] = "m4N493 u\$Er";
$lang['manageusers'] = "m4N@gE User5";
$lang['userstatusforforum'] = "u53r St4TUs for %s";
$lang['userdetails'] = "u\$3r D3tA1LS";
$lang['warning_caps'] = "waRN1ng";
$lang['userdeleteallpostswarning'] = "are j00 surE j00 w4N+ to DElE+E @ll oF tH3 sElECtEd U5Er'\$ p05+S? 0ncE +hE Posts 4Re D3lE+3D ThEY C@nn0+ 83 r3trIEv3d @nd wiLl B3 L0s+ pH0REVER.";
$lang['postssuccessfullydeleted'] = "p0St\$ w3rE \$ucCES5FUlLy D3l3+3d.";
$lang['folderaccess'] = "fOlder @ccEss";
$lang['possiblealiases'] = "p0Ss18LE @L1@s3s";
$lang['userhistory'] = "usER his+oRy";
$lang['nohistory'] = "n0 h1st0ry R3C0rd\$ \$4v3D";
$lang['userhistorychanges'] = "cH4nG3s";
$lang['clearuserhistory'] = "cl3@r user hiSt0ry";
$lang['changedlogonfromto'] = "cH4ng3d L090N Fr0m %s +0 %s";
$lang['changednicknamefromto'] = "ch@Nged niCKn4M3 fRom %s t0 %s";
$lang['changedemailfromto'] = "cH4N93d em@il phr0M %s +o %s";
$lang['successfullycleareduserhistory'] = "sUcC3\$sFULLy CLE4RED Us3R His+orY";
$lang['failedtoclearuserhistory'] = "f4Il3D +0 CL34r u\$ER h1S+0RY";
$lang['successfullychangedpassword'] = "sucC3SsphULly Ch4N93d Pa5sWorD";
$lang['failedtochangepasswd'] = "f4il3d +o ch4n9E p@sSW0rd";
$lang['viewuserhistory'] = "v13w UseR hI\$+0ry";
$lang['viewuseraliases'] = "vIew u53r 4li4\$e\$";
$lang['searchreturnednoresults'] = "se4rcH r3+URNED No rEsUltS";
$lang['deleteposts'] = "d3L3TE po\$+5";
$lang['deleteuser'] = "dEl3tE u5eR";
$lang['alsodeleteusercontent'] = "aLs0 dEl3TE 4Ll Oph +3h COn+3nT CR3@+3D 8y THI\$ user";
$lang['userdeletewarning'] = "aR3 j00 SUR3 j00 w@n+ +o DEl3TE +3H S3leC+3D Us3R 4ccoUn+? oNc3 THE 4ccOuNt has B3EN D3L3+3D I+ C4nnO+ 8e retr13veD 4ND w1Ll 8e losT F0REvEr.";
$lang['usersuccessfullydeleted'] = "uS3r \$ucC3SsfUllY DEL3TeD";
$lang['failedtodeleteuser'] = "f4Il3D +0 DelE+3 u53r";
$lang['forgottenpassworddesc'] = "iF Thi5 U\$3r h45 PHorg0++3n tH31r p@ssw0rD J00 c@N rEs3T 1t f0R +hEm h3R3.";
$lang['manageusersexp'] = "tH1\$ L1ST 5Hows 4 SEl3ct10N 0PH U\$ER5 wh0 H4V3 lo993d 0N t0 y0Ur foRUm, s0rt3D BY %s. +0 al+Er a UsEr'\$ p3RMiss10ns CliCK Their n@m3.";
$lang['userfilter'] = "user F1lter";
$lang['onlineusers'] = "oNlinE UsErs";
$lang['offlineusers'] = "ophphl1nE Us3rS";
$lang['usersawaitingapproval'] = "uS3rS 4wA1+inG @Ppr0val";
$lang['bannedusers'] = "b@NN3D u\$3rs";
$lang['lastlogon'] = "la\$+ LO90n";
$lang['sessionreferer'] = "s3ssi0n reFer3R";
$lang['signupreferer'] = "s1gN-Up rEFEr3R:";
$lang['nouseraccountsmatchingfilter'] = "n0 Us3R 4CC0unts m@+CH1Ng FiLt3r";
$lang['searchforusernotinlist'] = "se4rch ph0r @ Us3r NO+ iN L1\$t";
$lang['adminaccesslog'] = "aDMiN 4CCE\$s l0g";
$lang['adminlogexp'] = "thIs l1\$T sh0w\$ +h3 l@S+ @ct10Ns 54NC+1On3D 8Y UsEr\$ wi+h @dMIN Pr1v1L39e\$.";
$lang['datetime'] = "d4tE/+1m3";
$lang['unknownuser'] = "unKn0wN U\$er";
$lang['unknownuseraccount'] = "uNKn0WN U\$Er aCC0unt";
$lang['unknownfolder'] = "uNknown F0lDER";
$lang['ip'] = "iP";
$lang['lastipaddress'] = "l4\$+ Ip @DdRES\$";
$lang['logged'] = "lO99Ed";
$lang['notlogged'] = "n0+ L0G93D";
$lang['addwordfilter'] = "aDd wORD filtEr";
$lang['addnewwordfilter'] = "aDD new w0RD Ph1LTEr";
$lang['wordfilterupdated'] = "w0rd ph1ltEr uPd@+Ed";
$lang['filtername'] = "fIlter n@m3";
$lang['filtertype'] = "f1LtER tYP3";
$lang['filterenabled'] = "f1lter en@8LeD";
$lang['editwordfilter'] = "edi+ w0rD Fil+3r";
$lang['nowordfilterentriesfound'] = "no Ex1s+1ng woRD f1LTER 3N+rI3s F0UnD. +O @DD a F1lTER CL1ck tEH '@DD nEw' 8UttOn B3low.";
$lang['mustspecifyfiltername'] = "j00 mU\$t SpEcIFy 4 phiLt3r N@M3";
$lang['mustspecifymatchedtext'] = "j00 mu5+ \$p3Ciphy m4tChED tExT";
$lang['mustspecifyfilteroption'] = "j00 Mu\$T speC1Phy 4 ph1L+3R optiOn";
$lang['mustspecifyfilterid'] = "j00 musT Sp3ciphy 4 phILtEr id";
$lang['invalidfilterid'] = "iNvaliD ph1lt3r 1D";
$lang['failedtoupdatewordfilter'] = "f41l3D t0 uPDate w0rd phil+3R. cHeCk th4t thE f1Lter st1Ll 3xi\$+\$.";
$lang['allow'] = "aLLow";
$lang['block'] = "bl0ck";
$lang['normalthreadsonly'] = "norm4L threaDs only";
$lang['pollthreadsonly'] = "pOll thReaD\$ 0nly";
$lang['both'] = "boTh +hRe4d +yp3S";
$lang['existingpermissions'] = "eXi\$+1nG pErmi\$SI0NS";
$lang['nousershavebeengrantedpermission'] = "n0 ex1st1N9 uSERS PermIsSi0Ns f0unD. t0 gr4n+ peRmi\$SI0N T0 U\$3rs \$e@rCh F0R thEm 8el0W.";
$lang['successfullyaddedpermissionsforselectedusers'] = "sUCC3ssfulLy 4DD3d peRmIs\$10Ns F0r \$eL3CteD UsER\$";
$lang['successfullyremovedpermissionsfromselectedusers'] = "succe5sFULLy rEmOvED peRmi5S1ONs From sEl3C+3D UseR5";
$lang['failedtoaddpermissionsforuser'] = "f41l3d t0 4dD p3Rm1\$\$10Ns phor us3r '%s'";
$lang['failedtoremovepermissionsfromuser'] = "f4Il3d +o r3mOv3 p3RMI\$SIons PhrOm useR '%s'";
$lang['searchforuser'] = "se4Rch PHOr U\$3r";
$lang['browsernegotiation'] = "br0ws3R n3g0+i4ted";
$lang['largetextfield'] = "laR93 tExt f13LD";
$lang['mediumtextfield'] = "m3D1um tExt FIElD";
$lang['smalltextfield'] = "sm4ll tEx+ f13lD";
$lang['multilinetextfield'] = "muL+i-l1nE tex+ ph1elD";
$lang['radiobuttons'] = "r@Di0 8UttON\$";
$lang['dropdown'] = "dROP DOWn";
$lang['threadcount'] = "thr3aD CouN+";
$lang['clicktoeditfolder'] = "cL1Ck +0 EDi+ f0LD3R";
$lang['fieldtypeexample1'] = "fOr RAD10 8uT+Ons @nD DR0P dOWN phiElDS j00 nE3d +0 s3p4R4t3 +He phi3lDn@M3 4nD +Eh v4LU3S WI+H 4 c0lOn 4nD eaCh v4Lu3 SH0uld 8E sEp4r4tED 8Y 53Mi-c0lON\$.";
$lang['fieldtypeexample2'] = "ex4MPlE: +O CRE4+3 4 84siC 93NDER r4d1O 8U++0nS, w1+h tWo s3lECTi0nS F0r mal3 4nD PhEM@l3, J00 W0ULD 3ntER: <b>g3ndER:m4le;f3M4le</b> 1n +he 1+3M n@m3 F1elD.";
$lang['editedwordfilter'] = "ed1teD w0RD philTER";
$lang['editedforumsettings'] = "edI+Ed f0RUM sE+TiNgS";
$lang['successfullyendedusersessionsforselectedusers'] = "sUCC3\$sfUllY 3Nd3d s3ssI0ns F0R \$eL3CT3d usEr5";
$lang['failedtoendsessionforuser'] = "f4Il3D t0 EnD 5Es510n f0R U\$3r %s";
$lang['successfullyapprovedselectedusers'] = "suCC3S\$PHUlLy appRovED 53leC+3D us3rs";
$lang['matchedtext'] = "mA+ch3D +ext";
$lang['replacementtext'] = "r3Pl@C3MEnT tex+";
$lang['preg'] = "pR39";
$lang['wholeword'] = "wHOl3 W0rD";
$lang['word_filter_help_1'] = "<b>aLL</b> M4+chEs @G@ins+ tH3 wHoL3 +3X+ S0 fIL+3ring mOm T0 mUm w1LL @l\$0 Ch@N9e mom3N+ +o MUmENt.";
$lang['word_filter_help_2'] = "<b>wHol3 W0RD</b> MaTCH3S 4ga1n\$+ WH0le Words Only 50 f1LtERiN9 m0m To MUm W1Ll N0T CHAngE m0MENT +0 mum3nt.";
$lang['word_filter_help_3'] = "<b>pr3G</b> 4ll0ws J00 +0 Us3 P3rL r39ulAr 3xpREssi0N5 tO m@+CH +exT.";
$lang['nameanddesc'] = "n4ME @nD DESCrip+I0N";
$lang['movethreads'] = "m0Ve +hR34d5";
$lang['movethreadstofolder'] = "m0v3 +hr3@Ds +0 phoLDEr";
$lang['failedtomovethreads'] = "f41leD +0 MoVE +hr34d\$ +o SPeCIpHi3D foLD3r";
$lang['resetuserpermissions'] = "rE\$3+ usEr PErmi\$S1on\$";
$lang['failedtoresetuserpermissions'] = "fA1l3d tO rE\$ET useR pErM1\$\$1on5";
$lang['allowfoldertocontain'] = "aLLow f0LDEr t0 C0nta1N";
$lang['addnewfolder'] = "add nEw pholdER";
$lang['mustenterfoldername'] = "j00 mUst 3nT3R 4 fOLD3r n@M3";
$lang['nofolderidspecified'] = "nO PH0ld3R 1d sp3CIpHi3D";
$lang['invalidfolderid'] = "iNval1D ph0Ld3r Id. ch3CK thaT 4 folD3R Wi+H tHi\$ 1D 3x1\$+s!";
$lang['successfullyaddednewfolder'] = "sUcCe\$SFUlly aDd3d new pholDER";
$lang['successfullyremovedselectedfolders'] = "suCC3ssfulLy r3moVED sEl3C+3d F0LD3Rs";
$lang['successfullyeditedfolder'] = "sUcC3ssphUlly 3D1+3D f0lDER";
$lang['failedtocreatenewfolder'] = "f41led +o CRE4T3 n3w F0ldeR";
$lang['failedtodeletefolder'] = "f4IlED t0 DEL3+3 PHolDER.";
$lang['failedtoupdatefolder'] = "f41l3D t0 updatE F0lDER";
$lang['cannotdeletefolderwiththreads'] = "c@NN0t dEl3tE pH0LD3rs +h4t st1lL C0ntA1N tHrE4ds.";
$lang['forumisnotrestricted'] = "f0Rum 1S n0T rE\$+RicTED";
$lang['groups'] = "gR0upS";
$lang['nousergroups'] = "no usEr 9roUp5 H@v3 83EN \$e+ up. tO 4DD 4 9roUp CL1CK tEh 'aDd n3w' bU++0N 83LoW.";
$lang['suppliedgidisnotausergroup'] = "suPPli3d g1D 1\$ no+ @ us3R gr0Up";
$lang['manageusergroups'] = "m@N49e us3r Gr0ups";
$lang['groupstatus'] = "grOup st4TU\$";
$lang['addusergroup'] = "aDD user 9r0uP";
$lang['addemptygroup'] = "add EMpTy GROup";
$lang['adduserstogroup'] = "add U\$ERs to GR0up";
$lang['addremoveusers'] = "add/R3mov3 U53Rs";
$lang['nousersingroup'] = "th3RE aR3 N0 Us3r5 in +hi5 gRouP. 4DD U53R\$ +0 tH1\$ 9roup By 534rChinG Ph0R +h3M 8elow.";
$lang['groupaddedaddnewuser'] = "succE\$SFulLy @DD3d 9R0UP. add USEr\$ +O +HI\$ GR0up 8Y sE4rch1NG PHoR th3M 83L0W.";
$lang['nousersingroupaddusers'] = "th3R3 4rE n0 Us3R\$ 1N Th1S 9ROup. +0 @dD uSEr\$ CLiCK +eH '@DD/ReMOv3 U\$3rs' 8UTT0N B3loW.";
$lang['useringroups'] = "thI5 uS3r IS 4 MeMbER oF tEh pHOllowing 9R0UP\$";
$lang['usernotinanygroups'] = "thIs UseR 1S noT 1N @ny U\$3r 9RoUPs";
$lang['usergroupwarning'] = "n0t3: +h1\$ USeR m4Y be iNh3r1t1Ng 4dd1+i0NAl P3rM1ssion\$ PHrOM @nY u5ER 9R0up5 li5+eD b3LOw.";
$lang['successfullyaddedgroup'] = "sUCce5SFULly aDded GroUP";
$lang['successfullyeditedgroup'] = "suCCe\$\$fUlly EDiT3D 9ROuP";
$lang['successfullydeletedselectedgroups'] = "succ3\$5fUlly D3L3t3D s3L3c+3D GR0ups";
$lang['failedtodeletegroupname'] = "f4IL3d +o D3l3te GrOUp %s";
$lang['usercanaccessforumtools'] = "user c4n aCC3sS pH0RuM +O0L5 @Nd c4N Cre4tE, D3l3T3 @nD Edi+ f0RuM\$";
$lang['usercanmodallfoldersonallforums'] = "u\$er c@N mod3r4TE <b>all F0ld3rS</b> 0n <b>all ph0RUM5</b>";
$lang['usercanmodlinkssectiononallforums'] = "u53r CAn M0DER4+3 linK\$ \$3C+iOn oN <b>aLl ForUMs</b>";
$lang['emailconfirmationrequired'] = "eM4IL c0nPHIrM4+I0n r3QUIr3d";
$lang['userisbannedfromallforums'] = "u5ER 1S 84nn3d From <b>aLL pH0rUms</b>";
$lang['cancelemailconfirmation'] = "c4NCEL 3m4IL ConFiRm@+i0n AND 4ll0W us3R +0 s+4rt po\$+1ng";
$lang['resendconfirmationemail'] = "rESenD C0Nph1rm@+I0N Em4IL T0 U\$3r";
$lang['donothing'] = "d0 n0+H1ng";
$lang['usercanaccessadmintools'] = "user h@5 @cC3SS to F0Rum 4DMin +0OLs";
$lang['usercanaccessadmintoolsonallforums'] = "uSer h@\$ 4Ccess +o @Dm1n TOOls <b>on @Ll ph0rum\$</b>";
$lang['usercanmoderateallfolders'] = "uSEr c4n MODer4tE 4ll f0LDEr5";
$lang['usercanmoderatelinkssection'] = "u5Er C4N moD3R4te L1Nks \$3c+1ON";
$lang['userisbanned'] = "uS3r is 84nn3D";
$lang['useriswormed'] = "uSer 1s wormED";
$lang['userispilloried'] = "u\$Er is p1llor13d";
$lang['usercanignoreadmin'] = "u5Er C4n i9nore @Dm1n1\$+r@+0Rs";
$lang['groupcanaccessadmintools'] = "gROup Can acCE\$S @DmIn tool\$";
$lang['groupcanmoderateallfolders'] = "grOUP C@n moDER4t3 @Ll f0lDers";
$lang['groupcanmoderatelinkssection'] = "gR0up C4n m0DEr4t3 l1Nks seCT10ns";
$lang['groupisbanned'] = "gr0up Is 84NNED";
$lang['groupiswormed'] = "group i\$ w0rmed";
$lang['readposts'] = "r34d p0s+5";
$lang['replytothreads'] = "r3PLy To +hr3@ds";
$lang['createnewthreads'] = "cRe@+e n3w THre4ds";
$lang['editposts'] = "eDI+ p0Sts";
$lang['deleteposts'] = "dEL3T3 Po\$+S";
$lang['postssuccessfullydeleted'] = "pOs+\$ \$uCC3SsFUllY d3lE+ED";
$lang['failedtodeleteusersposts'] = "f41leD +o d3L3te U5ER's P0S+s";
$lang['uploadattachments'] = "uPl0@D AttaCHm3Nts";
$lang['moderatefolder'] = "mOder4+3 phoLDEr";
$lang['postinhtml'] = "p05t in h+ml";
$lang['postasignature'] = "pO\$+ 4 si9NATURe";
$lang['editforumlinks'] = "ed1+ F0rum l1Nks";
$lang['linksaddedhereappearindropdown'] = "l1nkS 4DDED H3r3 App3@r 1n 4 DR0P D0wn in tEh +0P r1gHt 0Ph TEh Phr@m3 SEt.";
$lang['linksaddedhereappearindropdownaddnew'] = "liNK\$ 4dD3D hEr3 4pPE4r in @ Dr0P D0wn In tHE +0p riGh+ oph th3 fr@M3 sE+. to 4dd 4 L1nk CLIcK tH3 'ADD N3W' 8U++0n bElow.";
$lang['failedtoremoveforumlink'] = "f4Il3d +0 r3MOve PhOrUm lInk '%s'";
$lang['failedtoaddnewforumlink'] = "fa1l3D T0 4dD N3w Forum l1NK '%s'";
$lang['failedtoupdateforumlink'] = "f@1L3D t0 UPDaTE pHoRUM l1nk '%s'";
$lang['notoplevellinktitlespecified'] = "n0 +op l3VeL Link +1+LE sp3CIPhI3D";
$lang['youmustenteralinktitle'] = "j00 mus+ 3NtEr @ l1Nk ti+L3";
$lang['alllinkurismuststartwithaschema'] = "aLl l1nk uR1s mUs+ \$+@rt w1+H @ \$chEm4 (I.3. h++p://, f+p://, iRc://)";
$lang['editlink'] = "eD1t l1nk";
$lang['addnewforumlink'] = "aDD nEw pHORUM l1nK";
$lang['forumlinktitle'] = "f0RUM Link +1+L3";
$lang['forumlinklocation'] = "f0rum L1nK loC4tiOn";
$lang['successfullyaddednewforumlink'] = "sUCC3\$sfULly aDD3d nEw foRUm lInK";
$lang['successfullyeditedforumlink'] = "sUcC3SsphuLly ED1+ed F0Rum l1Nk";
$lang['invalidlinkidorlinknotfound'] = "invALid l1NK iD or liNK nOt founD";
$lang['successfullyremovedselectedforumlinks'] = "sUcc3\$sFULlY r3M0v3D \$EL3ctED LinKs";
$lang['toplinkcaption'] = "top L1Nk caPT10N";
$lang['allowguestaccess'] = "aLl0w 9UE5+ 4CCeSS";
$lang['searchenginespidering'] = "sE@rch 3NgiN3 SpiDER1ng";
$lang['allowsearchenginespidering'] = "aLlow se4rch EN9inE \$pid3rin9";
$lang['newuserregistrations'] = "neW UseR rEg1\$+r4T10n\$";
$lang['preventduplicateemailaddresses'] = "pR3vent DUpLiC4+E 3M@il 4DDR3S\$e\$";
$lang['allownewuserregistrations'] = "all0w n3w u\$3r reg1S+R@+ions";
$lang['requireemailconfirmation'] = "rEQUIr3 3mail C0nph1Rm4+i0n";
$lang['usetextcaptcha'] = "uSe +ex+-caP+ChA";
$lang['textcaptchadir'] = "t3xt-C@PtCh4 d1R3C+0Ry";
$lang['textcaptchakey'] = "t3X+-C4PTCh@ k3y";
$lang['textcaptchafonterror'] = "tExt-c@p+cha h@s 8EEn DI\$@8leD 4U+0M4+1c4LLy 83c4U\$e +h3RE @r3 N0 trU3 TypE Ph0ntS @V@Il@8l3 F0r i+ +0 UsE. pLE@\$3 uplo4D som3 trUE +ype f0N+s +0 <b>%s</b> On y0ur servER.";
$lang['textcaptchadirerror'] = "teXT-c@ptch@ h4S 8EEn DI\$48l3D B3c4UsE t3h +Ext_CaP+ChA diR3CToRy AnD 1+'5 Su8-DIr3ctor13s @r3 N0T WriT48le 8y +h3 WEB s3Rv3r / pHp proC3SS.";
$lang['textcaptchagderror'] = "tEXT-c4P+CH@ H@\$ 8eEn Di\$@BLED b3C4UsE YouR \$3RV3R'5 Php sEtup Do3S n0t Prov1D3 5Upp0r+ ph0r 9D im493 mAnIpUL4t10n 4ND / 0R ++F Ph0N+ \$UPPoRT. BO+h @re rEQU1r3D F0R +3XT-C@p+CH4 sUppOr+.";
$lang['textcaptchadirblank'] = "tExt-c@ptCH4 D1R3ctory I\$ bl4Nk!";
$lang['newuserpreferences'] = "nEw user PrEpHer3nC3S";
$lang['sendemailnotificationonreply'] = "eM41L no+iPhiCAt10n 0N rEplY T0 us3R";
$lang['sendemailnotificationonpm'] = "emA1l nO+1phiC4+I0N on pm to U\$3r";
$lang['showpopuponnewpm'] = "show Popup WhEn R3C31ving n3W pm";
$lang['setautomatichighinterestonpost'] = "sET au+0m4t1C h1gH In+ER3S+ on pos+";
$lang['postingstats'] = "pOsting \$T4+s";
$lang['postingstatsforperiod'] = "poST1nG \$+4T\$ Phor p3R10d %s to %s";
$lang['nopostdatarecordedforthisperiod'] = "no po\$T d@t4 reCorDED f0R +His p3r1oD.";
$lang['totalposts'] = "t0t@L p0\$+S";
$lang['totalpostsforthisperiod'] = "toTAl po\$+s phoR th1S p3riod";
$lang['mustchooseastartday'] = "muS+ ch0053 a \$+4rt d4y";
$lang['mustchooseastartmonth'] = "mu5t ch00\$3 4 st4Rt MoNtH";
$lang['mustchooseastartyear'] = "muSt CHOo\$3 4 st4rt y34r";
$lang['mustchooseaendday'] = "muSt cho0sE 4 EnD D@Y";
$lang['mustchooseaendmonth'] = "mUS+ cHoo\$3 4 enD moN+H";
$lang['mustchooseaendyear'] = "muS+ Cho0\$3 4 enD Y34r";
$lang['startperiodisaheadofendperiod'] = "s+4r+ PEri0D 15 ahE4D 0F 3Nd peRi0d";
$lang['bancontrols'] = "b@N Contr0l\$";
$lang['addban'] = "adD B4n";
$lang['checkban'] = "cHECk B4N";
$lang['editban'] = "ed1+ b4N";
$lang['bantype'] = "b4n typ3";
$lang['bandata'] = "baN D4+@";
$lang['bancomment'] = "comMEn+";
$lang['ipban'] = "ip 8an";
$lang['logonban'] = "lOg0n 8an";
$lang['nicknameban'] = "nicKNAme 8@N";
$lang['emailban'] = "em@1l 8An";
$lang['refererban'] = "r3FEr3r 84N";
$lang['invalidbanid'] = "iNv@l1D B4n iD";
$lang['affectsessionwarnadd'] = "thIS B@n m@y 4Phf3C+ TEh F0LlowIn9 4C+ivE Us3r \$e\$Si0N\$";
$lang['noaffectsessionwarn'] = "thIS 8@n 4fFeCTs n0 4C+1V3 S3SSi0Ns";
$lang['mustspecifybantype'] = "j00 mUst sp3CIphy 4 B4N Typ3";
$lang['mustspecifybandata'] = "j00 musT sp3Cify s0M3 b@n D@+@";
$lang['successfullyremovedselectedbans'] = "sUCC3ssfUllY R3M0VED \$3l3CtED b@N\$";
$lang['failedtoaddnewban'] = "f@il3d +0 4DD new 84N";
$lang['failedtoremovebans'] = "f41L3D T0 REm0V3 \$OME or aLl 0f THE \$3l3c+3D 8ans";
$lang['duplicatebandataentered'] = "duPL1ca+3 b4n d4+@ EN+3r3d. pLE@53 ChECK yoUr wIlDC4rd5 To seE iPH They @LRE4DY MatCH thE D@+@ 3NtERED";
$lang['successfullyaddedban'] = "sucC3\$sfullY 4DDED BAN";
$lang['successfullyupdatedban'] = "sUcCE5\$phuLLY UPD@+eD B4N";
$lang['noexistingbandata'] = "th3rE is no 3X1\$+1Ng B4N d@T4. t0 4DD 4 8@N CLiCK +3h '@DD NEw' 8u++0N 83l0w.";
$lang['youcanusethepercentwildcard'] = "j00 c4N Us3 tEh peRCEN+ (%) wilDC4RD 5YMBol iN aNY 0F yOUr baN Li5+S +o o8+@in PaR+i@L matCh3s, 1.3. '192.168.0.%' woUlD B4n @ll 1P 4DDREss3S iN +he R4ngE 192.168.0.1 +HRou9H 192.168.0.254";
$lang['cannotusewildcardonown'] = "j00 C4nN0T aDD % 4\$ 4 wiLDC4rd m4TCh on 1t's owN!";
$lang['requirepostapproval'] = "r3QU1R3 PO\$+ 4pPR0val";
$lang['adminforumtoolsusercounterror'] = "tH3re must 83 4t l34S+ 1 U53R wI+h aDm1n Tool5 AnD f0RUM tooLs 4CCESs 0n 4ll pHorUM\$!";
$lang['postcount'] = "p0s+ COUnt";
$lang['resetpostcount'] = "rE\$et PO\$T C0unT";
$lang['failedtoresetuserpostcount'] = "f41l3D +o r3seT p0ST C0unt";
$lang['failedtochangeuserpostcount'] = "f@1L3D t0 Ch@n9E UseR p05+ C0UnT";
$lang['postapprovalqueue'] = "po\$+ 4pprov@L qUEu3";
$lang['nopostsawaitingapproval'] = "nO POs+s 4RE 4w4It1Ng 4PPRovAl";
$lang['approveselected'] = "apPRovE sel3cteD";
$lang['failedtoapproveuser'] = "f4il3D to 4PProv3 U53r %s";
$lang['kickselected'] = "k1CK s3l3Ct3d";
$lang['visitorlog'] = "v151tor lO9";
$lang['clearvisitorlog'] = "cLe4r V1\$it0R L09";
$lang['novisitorslogged'] = "n0 V1s1+0r5 l09g3D";
$lang['addselectedusers'] = "aDd \$el3CT3D UseR\$";
$lang['removeselectedusers'] = "rEm0v3 Sel3C+3d usER\$";
$lang['addnew'] = "aDd new";
$lang['deleteselected'] = "deLEtE \$eleCtED";
$lang['forumrulesmessage'] = "<p><b>foRum rUl3s</b></p><p>\nRe915+r@+I0n to %1\$S i\$ phRE3! we D0 InSi\$T Th4t j00 a81d3 8y +h3 RUlEs aNd pOl1CiEs D3+41leD 8Elow. iPh j00 @gr3e T0 the +3Rms, pl34\$3 Ch3ck +EH '1 49r3e' ChECKb0x 4Nd prES\$ +h3 'r3GIs+3R' BU+t0N BEloW. 1Ph J00 W0ULD l1K3 to C4nCEl t3H r39IS+r4Tion, clICk %2\$S to R3+urn +0 th3 f0rums inDEx.</p><p>\n4LthougH Th3 adm1ni5tr4Tor\$ @nD moD3r@t0r\$ Oph %1\$s will 4T+eMp+ t0 k3ep 4Ll o8jec+10n4Ble mEsS49es ophph +h1\$ fORum, 1t 1s IMp0\$\$18lE f0r us +0 r3vi3W all M3ssa93\$. 4Ll m3\$\$4ges 3xpre5\$ +hE v13W\$ 0ph +H3 au+H0r, aND ne1+her +he 0wn3rS of %1\$S, nor PRoj3C+ 83Eh1VE F0rum 4nD i+'\$ @Fphili4te\$ WIlL 83 h3LD r3SP0nSi8lE f0r teh C0n+en+ 0f @ny m3sS4GE.</p><p>\nbY 49ReE1Ng +o +Hese rulEs, J00 w4rr4nt th4+ j00 WIll N0+ p0st 4ny m35\$@GeS +h4+ 4RE ob5C3n3, vul9Ar, 53Xu4lly-0r13n+4T3d, h@TEFul, threa+en1n9, or 0+h3rwise v10L4+IVE oph 4ny L4Ws.</p><p>t3H 0wn3rs 0ph %1\$\$ R3\$3rve tH3 rigHT t0 remov3, eDi+, move oR Close @ny +hR3@D f0R 4ny r34Son.</p>";
$lang['cancellinktext'] = "heR3";
$lang['failedtoupdateforumsettings'] = "f@1LED To updAtE F0rUm s3++iN95. pLE4\$3 +ry a941n l4+3R.";
$lang['moreadminoptions'] = "mOR3 4dmIN op+1On\$";

// Admin Log data (admin_viewlog.php) --------------------------------------------

$lang['changedstatusforuser'] = "cH@N9ED Us3R Sta+U5 Ph0r '%s'";
$lang['changedpasswordforuser'] = "cH4ngeD pAssw0rd ph0R '%s'";
$lang['changedforumaccess'] = "cH@NgED FoRuM aCC3SS p3rMi5\$10ns F0r '%s'";
$lang['deletedallusersposts'] = "d3L3ted 4ll post5 pHor '%s'";

$lang['createdusergroup'] = "cRe4teD U\$3r grOUP '%s'";
$lang['deletedusergroup'] = "d3L3+ed UsEr 9r0up '%s'";
$lang['updatedusergroup'] = "upd4+3d USEr 9R0up '%s'";
$lang['addedusertogroup'] = "aDdeD U\$3r '%s' +0 9roup '%s'";
$lang['removeduserfromgroup'] = "reM0v3 us3r '%s' from 9RoUp '%s'";

$lang['addedipaddresstobanlist'] = "aDdEd Ip '%s' +0 84n lI\$t";
$lang['removedipaddressfrombanlist'] = "remOV3d ip '%s' phr0m BAn l1st";

$lang['addedlogontobanlist'] = "aDdED L090n '%s' t0 8@n l1\$+";
$lang['removedlogonfrombanlist'] = "reM0v3d l090N '%s' phRom B@n l15+";

$lang['addednicknametobanlist'] = "addeD n1Ckn4m3 '%s' to 8@n l1\$+";
$lang['removednicknamefrombanlist'] = "reM0V3d NICkN4M3 '%s' Phr0m 84N L1\$t";

$lang['addedemailtobanlist'] = "added em@il 4ddrEss '%s' +O B4n lIs+";
$lang['removedemailfrombanlist'] = "rEM0v3d 3m4il 4dDr3SS '%s' PhR0M B4n l1\$+";

$lang['addedreferertobanlist'] = "added rEPherer '%s' +O 8@n L1\$+";
$lang['removedrefererfrombanlist'] = "rEMOvED REPHER3r '%s' FrOm BAn lI\$t";

$lang['editedfolder'] = "eD1t3D pholdEr '%s'";
$lang['movedallthreadsfromto'] = "m0ved 4Ll thre4ds phroM '%s' +o '%s'";
$lang['creatednewfolder'] = "crE@+ED n3w phoLDEr '%s'";
$lang['deletedfolder'] = "d3le+3D F0LDEr '%s'";

$lang['changedprofilesectiontitle'] = "cH@n93d propH1L3 S3ct1ON +i+lE fR0M '%s' to '%s'";
$lang['addednewprofilesection'] = "addED n3W prOFiLE s3C+i0n '%s'";
$lang['deletedprofilesection'] = "dElet3D pr0PH1L3 S3cTi0n '%s'";

$lang['addednewprofileitem'] = "add3d new PrOphIL3 it3M '%s' t0 SEC+I0N '%s'";
$lang['changedprofileitem'] = "cHAN9eD Pr0Ph1l3 1+3M '%s'";
$lang['deletedprofileitem'] = "d3L3t3d pRof1L3 1+EM '%s'";

$lang['editedstartpage'] = "ed1+eD s+@r+ pa93";
$lang['savednewstyle'] = "savED n3w styL3 '%s'";

$lang['movedthread'] = "m0VED thrEAD '%s' From '%s' to '%s'";
$lang['closedthread'] = "cl0sed +hr34D '%s'";
$lang['openedthread'] = "op3n3D thrE4D '%s'";
$lang['renamedthread'] = "reN@MED +hr34d '%s' t0 '%s'";

$lang['deletedthread'] = "d3Leted +HR3@d '%s'";
$lang['undeletedthread'] = "undEl3+3d +hr3@D '%s'";

$lang['lockedthreadtitlefolder'] = "lock3D +hr34d opt10nS 0N '%s'";
$lang['unlockedthreadtitlefolder'] = "unL0ckeD +hr34D oPt10n\$ on '%s'";

$lang['deletedpostsfrominthread'] = "deL3teD P0sts From '%s' in +hRE4D '%s'";
$lang['deletedattachmentfrompost'] = "dEL3TED @T+4chM3Nt '%s' fr0m po\$T '%s'";

$lang['editedforumlinks'] = "ed1teD Phorum l1Nks";
$lang['editedforumlink'] = "eD1tED pHorum l1NK: '%s'";

$lang['addedforumlink'] = "aDd3d pH0rUm L1nk: '%s'";
$lang['deletedforumlink'] = "deletED F0rUm L1nk: '%s'";
$lang['changedtoplinkcaption'] = "cH4n93D Top link c4pT10n Fr0m '%s' +0 '%s'";

$lang['deletedpost'] = "d3LE+ED po5T '%s'";
$lang['editedpost'] = "edITED p0S+ '%s'";

$lang['madethreadsticky'] = "m4d3 thr34d '%s' st1Cky";
$lang['madethreadnonsticky'] = "m@de tHrE4D '%s' n0N-stickY";

$lang['endedsessionforuser'] = "ended 53s\$i0n f0R UseR '%s'";

$lang['approvedpost'] = "appROVeD posT '%s'";

$lang['editedwordfilter'] = "ed1teD w0rd FIl+3r";

$lang['addedrssfeed'] = "aDD3d r\$\$ pHE3D '%s'";
$lang['editedrssfeed'] = "eD1+eD rss ph3ED '%s'";
$lang['deletedrssfeed'] = "dEl3t3D rss fEED '%s'";

$lang['updatedban'] = "upd4+ED 8AN '%s'. Ch4N93D TyP3 pHr0m '%s' +0 '%s', Ch4NGED d4t4 Phr0m '%s' to '%s'.";

$lang['splitthreadatpostintonewthread'] = "spl1T THRE4D '%s' 4+ pO5+ %s  IN+O N3w +Hr34d '%s'";
$lang['mergedthreadintonewthread'] = "m3RgEd +HR3ADS '%s' 4ND '%s' InTO n3W +Hre@D '%s'";

$lang['approveduser'] = "apProVeD user '%s'";

$lang['forumautoupdatestats'] = "fORUm 4Ut0 uPD4tE: 5+@ts upd4tEd";
$lang['forumautoprunepm'] = "fOrum 4U+0 uPDate: Pm f0ldeRs pruneD";
$lang['forumautoprunesessions'] = "foRum 4Ut0 upD@tE: sEsSi0n5 pRUNEd";
$lang['forumautocleanthreadunread'] = "f0rum @u+O Upd4TE: THREAD Unr3AD D@+A ClE@neD";
$lang['forumautocleancaptcha'] = "f0Rum 4U+o UpD4tE: tex+-C@PtcH4 iM49e\$ cL34N3D";

$lang['adminlogempty'] = "adm1N lOg i\$ 3mp+y";

$lang['youmustspecifyanactiontypetoremove'] = "j00 mUs+ \$p3ciPHY An 4c+10n +ype t0 REmov3";

$lang['removeentriesrelatingtoaction'] = "reM0V3 3ntR13s R3l@tIng +O 4c+1oN";
$lang['removeentriesolderthandays'] = "r3mov3 eNtr1e\$ 0lDeR +H4n (d4Y\$)";

$lang['successfullyprunedadminlog'] = "sUCC35\$FULLY prUNED @DM1N L09";
$lang['failedtopruneadminlog'] = "f@il3d +0 prun3 @DMIN l0g";

$lang['prune_log'] = "pRuN3 lo9";

// Admin Forms (admin_forums.php) ------------------------------------------------

$lang['noexistingforums'] = "n0 3Xi\$+INg phOrUms phoUND. To Cr3@t3 4 NEW ph0rum ClICK +h3 '@dD nEW' BUt+ON BEL0w.";
$lang['webtaginvalidchars'] = "wE8+@G c4n ONLy C0n+@in UppeRCAs3 4-Z, 0-9 4nd uND3r\$c0RE CH4r4C+3r\$";
$lang['databasenameinvalidchars'] = "d4+@8@s3 n4m3 c4n 0NlY COnT41n a-z, @-z, 0-9 4nD UNDER5CORE CH4rac+3R\$";
$lang['invalidforumidorforumnotfound'] = "inv@L1d Ph0rum Ph1d Or F0RUM N0t f0UND";
$lang['successfullyupdatedforum'] = "sucC3\$sfullY UPD@+eD f0rum";
$lang['failedtoupdateforum'] = "f41l3d +0 UPD4TE PhoRUM: '%s'";
$lang['successfullycreatednewforum'] = "suCC35sfULlY CrEA+ED N3W f0rum";
$lang['selectedwebtagisalreadyinuse'] = "tHe sEl3c+3d WEBTa9 1s @Lr34dy In Us3. PlE453 CHoO\$3 4NotH3R.";
$lang['selecteddatabasecontainsconflictingtables'] = "tH3 s3LEC+3d D4T484\$3 Con+@IN\$ C0nphLiC+iN9 +@8LEs. C0NPHLICtIn9 +4blE NaMEs 4R3:";
$lang['forumdeleteconfirmation'] = "ar3 J00 SUre j00 w@Nt to D3lE+e 4lL oF +h3 s3lEC+Ed PHORUM\$?";
$lang['forumdeletewarning'] = "pLe@\$E n0+3 +h4+ J00 C4nNot rECOV3R DEL3+3D PhoRUmS. oNC3 d3leTeD 4 phOrUm @ND aLl oPh 1+'\$ 4ssoci@+3d D@t4 Is PErm4nenTlY R3m0V3d phrOm the D@+484sE. IF J00 Do no+ W15H t0 d3l3+3 +Eh \$3l3CTEd f0RUms pLE4se clICK C4NCEl.";
$lang['successfullyremovedselectedforums'] = "suCc3ssfUlly DEL3tED \$el3Ct3d phorUms";
$lang['failedtodeleteforum'] = "f@IlED +o dElE+3D F0RuM: '%s'";
$lang['addforum'] = "aDd phoruM";
$lang['editforum'] = "ed1+ forum";
$lang['visitforum'] = "vIs1t f0rUm: %s";
$lang['accesslevel'] = "acce\$s l3vEl";
$lang['forumleader'] = "foRUm l3AD3r";
$lang['usedatabase'] = "us3 d4+4b453";
$lang['unknownmessagecount'] = "unKn0wN";
$lang['forumwebtag'] = "f0RUm wEBt49";
$lang['defaultforum'] = "d3F4ul+ phoRUm";
$lang['forumdatabasewarning'] = "pl3@S3 en5URe J00 s3L3C+ +hE C0rr3C+ D@+@B@\$E wh3n CRE4T1n9 4 N3W f0RUm. 0NC3 cRE4+3D 4 NEW Ph0RUm C4nno+ B3 mov3D bEtWeEn 4VA1l@8LE d4+4B453s.";

// Admin Global User Permissions

$lang['globaluserpermissions'] = "glOBAl User pErmis\$10N\$";

// Admin Forum Settings (admin_forum_settings.php) -------------------------------

$lang['mustsupplyforumwebtag'] = "j00 mUst \$UPply 4 PhoruM w3b+49";
$lang['mustsupplyforumname'] = "j00 Mus+ \$upply 4 forUm n4M3";
$lang['mustsupplyforumemail'] = "j00 musT suPPLy @ PH0rUm Ema1l 4dDrEs\$";
$lang['mustchoosedefaultstyle'] = "j00 mu\$T chOo\$e 4 DeF4uLt F0RUm \$+YL3";
$lang['mustchoosedefaultemoticons'] = "j00 mu5+ chOos3 D3f4ul+ PHoRum 3mot1COn5";
$lang['mustsupplyforumaccesslevel'] = "j00 mUs+ \$UpPlY @ FoRum 4CC3ss l3V3l";
$lang['mustsupplyforumdatabasename'] = "j00 mus+ supPlY a pHorUm D@+4B45e n@mE";
$lang['unknownemoticonsname'] = "uNknown emO+iC0n\$ N4m3";
$lang['mustchoosedefaultlang'] = "j00 mus+ chOosE @ D3F4ul+ pHorum l4ngUa93";
$lang['activesessiongreaterthansession'] = "aC+ivE \$3\$\$1on t1Me0U+ C4nnO+ B3 9re4T3R Th@N sESs1oN +iM30Ut";
$lang['attachmentdirnotwritable'] = "a++4chMEN+ d1r3CT0Ry @nD 5ySTEM +3mp0raRy D1R3Ctory / pHp.1Ni 'Upl0@D_Tmp_D1R' mU\$+ 8E wR1+4BLE BY tEH w38 serv3r / php PROce\$S!";
$lang['attachmentdirblank'] = "j00 must sUppLy 4 Dir3C+0rY +O \$@ve @++4CHm3nts In";
$lang['mainsettings'] = "main 5E+t1nG\$";
$lang['forumname'] = "foRUm n@m3";
$lang['forumemail'] = "fOrum EM4il";
$lang['forumnoreplyemail'] = "n0-r3plY 3M4Il";
$lang['forumdesc'] = "f0rum DESCRip+1on";
$lang['forumkeywords'] = "f0Rum k3Yw0RDs";
$lang['defaultstyle'] = "dEPh4Ul+ s+yle";
$lang['defaultemoticons'] = "dEF4Ult 3m0t1c0N\$";
$lang['defaultlanguage'] = "d3ph@ULT l4N9U@ge";
$lang['forumaccesssettings'] = "f0rum aCCES5 s3tt1Ng\$";
$lang['forumaccessstatus'] = "foRUm @CC3SS \$+@+U\$";
$lang['changepermissions'] = "cH4n93 p3Rm1\$si0N5";
$lang['changepassword'] = "cH4NGe p4Ssw0Rd";
$lang['passwordprotected'] = "p@\$Sw0RD pR0T3cted";
$lang['passwordprotectwarning'] = "j00 h4V3 No+ \$3+ 4 pHoRum p4\$sw0rd. If J00 do no+ \$E+ a pAssw0RD tEH p4SSw0RD pRo+3C+I0n FUncT10n4l1+Y w1LL 8e 4Ut0m@+Ic4LlY D1\$4BlED!";
$lang['postoptions'] = "poS+ 0pT1on5";
$lang['allowpostoptions'] = "alL0W p0\$+ 3D1+iNG";
$lang['postedittimeout'] = "p05+ 3d1+ +imEou+";
$lang['posteditgraceperiod'] = "poS+ eDiT 9r@C3 p3Ri0D";
$lang['wikiintegration'] = "wIkiwiKI in+39r4T10n";
$lang['enablewikiintegration'] = "eN48L3 wikIwIki iNtegr4t10N";
$lang['enablewikiquicklinks'] = "eN48Le WiKiWikI qu1ck linkS";
$lang['wikiintegrationuri'] = "w1kIWIki l0ca+1ON";
$lang['maximumpostlength'] = "m4xiMUM p0\$+ lEN9+h";
$lang['postfrequency'] = "p0st fREqU3NCy";
$lang['enablelinkssection'] = "en4BlE L1nks 5ECT10n";
$lang['allowcreationofpolls'] = "alLOw cr3atiON 0PH p0ll\$";
$lang['allowguestvotesinpolls'] = "alL0w 9u3sts +o Vote in Polls";
$lang['unreadmessagescutoff'] = "unR34D mEss493\$ CU+-0Fph";
$lang['unreadcutoffseconds'] = "s3cOnDs";
$lang['disableunreadmessages'] = "di\$4Ble uNrE4d M3s\$49e\$";
$lang['nocutoffdefault'] = "nO cUT-ophPh (DeF4Ul+)";
$lang['1month'] = "1 mon+H";
$lang['6months'] = "6 m0N+h5";
$lang['1year'] = "1 Y3Ar";
$lang['customsetbelow'] = "cUSTOm v4lu3 (\$3t 8EL0W)";
$lang['searchoptions'] = "sE4rCh opt10ns";
$lang['searchfrequency'] = "se4rCh Fr3QU3nCY";
$lang['sessions'] = "sE\$s1on5";
$lang['sessioncutoffseconds'] = "s35s10n cut 0fpH (sECoNd\$)";
$lang['activesessioncutoffseconds'] = "ac+iv3 sEssi0N CUT 0fph (\$EC0nds)";
$lang['stats'] = "st4+s";
$lang['hide_stats'] = "hid3 stats";
$lang['show_stats'] = "shOW stats";
$lang['enablestatsdisplay'] = "eN@8Le s+4t\$ D1sPL4y";
$lang['personalmessages'] = "p3r5ON4l m3\$\$49E\$";
$lang['enablepersonalmessages'] = "en48le P3R\$0n@L MEss49e\$";
$lang['pmusermessages'] = "pm mEss49E\$ p3r Us3R";
$lang['allowpmstohaveattachments'] = "alL0w pers0N@l m3\$S@gES +o haVE @++4ChmEn+s";
$lang['autopruneuserspmfoldersevery'] = "aUt0 prune UseR's Pm f0LDErs 3VEry";
$lang['userandguestoptions'] = "u\$3R @nD 9U35+ opt10n5";
$lang['enableguestaccount'] = "eN@8lE Gu3S+ 4CC0unt";
$lang['listguestsinvisitorlog'] = "l1ST gu3S+s 1n Vi5i+0r Lo9";
$lang['allowguestaccess'] = "alLow 9ue5+ 4ccE\$S";
$lang['userandguestaccesssettings'] = "us3r 4Nd gu3sT 4CcEss s3+tINg5";
$lang['allowuserstochangeusername'] = "aLl0w u\$ER5 to CH4n9E USern4m3";
$lang['requireuserapproval'] = "r3QU1re U\$er @PpR0vAl 8y @dmIN";
$lang['requireforumrulesagreement'] = "reqU1r3 u53R +0 49rE3 +0 PhoruM rULEs";
$lang['enableattachments'] = "en48LE @+t@ChM3n+s";
$lang['attachmentdir'] = "a+T@ChMeN+ diR";
$lang['userattachmentspace'] = "at+4ChM3Nt \$P4C3 p3R UseR";
$lang['allowembeddingofattachments'] = "aLl0w em8edD1N9 0F 4+t@cHM3nts";
$lang['usealtattachmentmethod'] = "u5e 4ltern@+iV3 4++4chm3NT mEthOD";
$lang['allowgueststoaccessattachments'] = "aLlow gU3s+s +0 4CCEss @++4CHmEnTs";
$lang['forumsettingsupdated'] = "fOrum \$3++ings SUCcES\$fully upD@+ED";
$lang['forumstatusmessages'] = "foRUM s+@Tu\$ m3s\$@gE\$";
$lang['forumclosedmessage'] = "f0Rum clos3d m3ss493";
$lang['forumrestrictedmessage'] = "forum r3strICted M3ss49E";
$lang['forumpasswordprotectedmessage'] = "f0RUm P45\$WorD PR0+3ct3D m3SS493";

// Admin Forum Settings Help Text (admin_forum_settings.php) ------------------------------

$lang['forum_settings_help_10'] = "<b>po\$T ED1+ +IM3ou+</b> 1\$ TEH +1Me in MiNU+Es aphTER Post1n9 Th4T 4 user C@N 3d1T tH31r p0st. if sET +o 0 TH3rE 1\$ No L1mI+.";
$lang['forum_settings_help_11'] = "<b>maximUm P0\$+ l3NgTh</b> 1s +EH M4xImUm NUM83R OpH CH4R4C+ER\$ +h4T wiLl 83 Displ4YED iN 4 po\$+. 1F @ PoSt is LOn9Er th4n tHe numb3r 0f Ch4R4C+Ers D3PH1N3d h3RE I+ w1ll 83 Cu+ \$h0r+ @nD a l1NK 4dd3D +o TEH B0t+om +o 4LloW Us3Rs T0 rE4d +HE wh0L3 pos+ 0N 4 \$3par4Te p@ge.";
$lang['forum_settings_help_12'] = "iF j00 doN't w4N+ Your Us3Rs +O 8E @BLE t0 CREa+E Polls j00 CAn D1\$@8LE +H3 4b0v3 op+1oN.";
$lang['forum_settings_help_13'] = "tEH L1nks \$ecT10n 0Ph BEEH1v3 pr0v1DE\$ 4 pLaC3 ph0R youR U53r\$ +o m@1nT41n 4 l1s+ 0ph Si+Es +hEY FR3QU3NTLy v15it +h4+ 0tHER US3Rs M@Y F1Nd u\$ephUl. l1nk\$ C4n B3 D1viD3d iNto C4+Eg0r13s 8y F0LD3R 4nd 4llow f0R C0mm3NTS 4nd R4T1nGS +o 8e gIv3N. In 0rd3R +0 moDer@tE TeH L1nKS sec+i0n 4 USER MUst 83 r4n+3d gl0B4L moDEr4T0r 5+4+U\$.";
$lang['forum_settings_help_15'] = "<b>s3\$s1ON cU+ 0fph</b> Is +h3 m4x1mum +Im3 83f0RE 4 USER'5 53\$S10n is DE3mED DE@D 4ND THEY 4r3 l0g93d OUt. 8y d3F4ult Th1s Is 24 h0UR\$ (86400 seC0nDs).";
$lang['forum_settings_help_16'] = "<b>ac+1vE \$E\$S1on CU+ oPhF</b> 1\$ +Eh m@xiMUm Tim3 BEF0re @ UseR's \$E\$sion is D3EMED 1N4c+1V3 4T wHich P01N+ th3y 3Nt3r 4n IDl3 \$+4tE. iN +hi\$ \$+4te ThE user rEM4In5 lo993d in, 8UT +hEy @r3 Rem0V3d phr0M teh AC+1V3 USErs Lis+ In t3H \$+4+\$ Di\$pL4Y. oncE they b3cOM3 4Ctive a9@in tH3y w1ll 83 re-4DD3d +O the lis+. 8y dEf4ult THIs sET+1n9 1S set tO 15 m1nU+eS (900 \$ec0Nds).";
$lang['forum_settings_help_17'] = "eN4bL1ng +his 0P+1ON 4Ll0w\$ bEEhivE to 1ncluD3 @ \$+4ts dI\$plAy 4+ +He 8OT+Om opH the mE5s4g3s Pane \$1m1l4r to tEh 0NE UsEd BY m@ny phorum sophtw4rE T1+L3s. 0NCe 3NABLED ThE Di\$PL@y 0F th3 S+4t\$ p4G3 c@n BE +0G9l3D inDIviDu4LLy 8Y 34ch u53R. 1F +hey D0n'+ w@n+ t0 \$3E 1+ Th3y c4n H1d3 I+ fr0m v1ew.";
$lang['forum_settings_help_18'] = "p3R\$0n@l mess493s 4rE Inv@LU@8LE @\$ @ w4y OpH t4k1n9 mOrE pr1V@tE maTter\$ 0U+ Of v1EW 0f +h3 0+h3r M3m8ERs. h0WEVEr 1f J00 DON't w4N+ yoUr U\$3rs +0 83 4bl3 T0 SEND 3@CH 0+h3r pErS0n4l m3s5@9Es J00 C4n d1S4ble +His 0P+1on.";
$lang['forum_settings_help_19'] = "p3rs0n4L m3ss@gE\$ C4n al\$0 C0nt4in 4+T4CHmEN+s whicH CaN 8e useFUl F0R ExCHaN9inG Phil3S B3+we3N u5ers.";
$lang['forum_settings_help_20'] = "<b>n0+E:</b> the sp4C3 @LLoc4T10n for pM 4++4Chm3nTS i\$ +@K3n phr0M E4CH User\$' M41n 4TtaCHM3nt @ll0Ca+IoN 4nD I\$ N0+ 1N 4DDition tO.";
$lang['forum_settings_help_21'] = "<b>enABLE 9U3s+ 4CCoUNT</b> @LL0w5 v1Si+0Rs +0 brow\$E Y0UR PhOrUm @ND re@D P0\$ts w1TH0Ut r3gis+3rin9 4 u\$er 4cc0UNT. 4 usEr aCC0Un+ iS 5+1ll rEQU1R3D iF +h3y wIsh to Po5+ 0r CH4N9E UsEr Pr3fer3NC3s.";
$lang['forum_settings_help_22'] = "<b>l1St 9U3s+S in v1siT0R lo9</b> All0W\$ J00 +O \$p3ciPhY wh3THER oR N0T UnR3Gis+Er3d Us3rs @R3 l1\$+3D 0N tHE vi5I+0r lo9 @long s1De rEg1STERED Us3RS.";
$lang['forum_settings_help_23'] = "beehIV3 4lL0W\$ 4++4ChM3Nts T0 83 UPlO@d3d To m3SS@GE\$ WH3n PO\$+Ed. 1Ph J00 H@V3 LIMiTED w3b \$PAC3 j00 M4Y wH1ch t0 D1\$4Bl3 4++4CHM3NT\$ by CLE4R1N9 TH3 b0X @Bov3.";
$lang['forum_settings_help_24'] = "<b>a+T@Chm3nT DiR</b> i5 +Eh l0C4t10n 83ehiV3 sh0ULD sT0rE I+'\$ a+t4chmeN+s in. tH1\$ D1r3ctOry mus+ 3X1\$+ 0N YOur wEB sP4C3 4nd MuSt 8E wr1+4Bl3 8y t3h W38 sErv3R / Php pRoC3S5 0tH3rW1sE UpLo@D5 w1ll ph41l.";
$lang['forum_settings_help_25'] = "<b>atT4chMEnt Sp@CE P3r U\$er</b> IS +3h m4xiMUM 4M0UN+ 0PH DIsk \$P4c3 4 user h45 phor 4++4chm3nts. oncE tHi\$ \$PAC3 i\$ useD Up +HE User C4NN0+ Uplo@D 4Ny m0re 4tt4ChMeN+s. BY D3F4UL+ +hi\$ is 1MB 0f \$p4CE.";
$lang['forum_settings_help_26'] = "<b>aLL0w EM83DDIng oph 4+T@CHm3nTs In mEss@g3S / s1GN@+UREs</b> Allow5 uS3rs t0 EMB3d @+t@CHM3N+s in P0STs. 3N4Bl1n9 +hi\$ opt10n WhIl3 U\$3fUl C4n inCr3as3 youR B4NDW1d+H Us493 DR@\$T1c4Lly Und3r CER+4In C0nphi9ur@+i0Ns 0F PhP. Iph j00 h@v3 L1m1+3D BAnDW1D+h i+ is RECOmMeNDed +h@t j00 d1S@8le +h1S opt10N.";
$lang['forum_settings_help_27'] = "<b>uSe 4LTERn4+IVE @++@CHm3nt mE+HOD</b> ForcEs bE3H1v3 TO Us3 4n 4l+3Rn4t1VE RE+rI3v4l mETH0d ph0r 4tt4Chm3nts. 1F J00 reCE1V3 404 ERr0r mE\$s493S whEN +Ry1n9 +0 D0wnl0@D AT+4cHm3nts fRoM M3ss493\$ +ry 3N4BL1ng THi\$ 0P+1On.";
$lang['forum_settings_help_28'] = "thIs 5e+t1Ng 4LL0ws Y0ur foRuM +o 8e 5P1D3r3D 8Y seArCH EN9In3\$ l1K3 900gl3, 4L+4v1s+4 anD yah00. 1ph J00 \$w1tCh +hi5 op+i0N off youR phorum W1Ll n0+ bE 1NCLUDEd 1n +HE\$E s34rCh EnGin3\$ REsults.";
$lang['forum_settings_help_29'] = "<b>aLLOw nEw u53R reg1\$+r4T1ons</b> 4ll0Ws 0R DIs@Ll0w5 th3 Cre4t10n of nEW Us3R @CCOunTs. \$e++iNG +3H OpT10n To n0 complETELy Di\$4BL3s +Eh rE9is+R4+1ON Phorm.";
$lang['forum_settings_help_30'] = "<b>en48l3 wIkiwiki 1nTEgR4+1on</b> PROviDEs wIKiworD SuPp0r+ in yOuR PhOruM pOst5. a wikiWord i5 M@D3 UP 0f TW0 0R m0RE C0NC4TEnAtED w0Rds wI+H upPERcasE L3TtEr\$ (opHT3n reFErRED +0 @S CaMeLC4SE). 1Ph j00 wr1+3 a worD TH15 w@y 1+ W1LL 4uTom4+1CAllY 8E Ch@ngeD int0 a hyp3Rlink pointing +0 y0ur cho\$En wikiw1k1.";
$lang['forum_settings_help_31'] = "<b>en@8le W1k1wik1 QUiCK LinkS</b> En@8LEs ThE Us3 of ms9:1.1 AnD us3r:L0gon stYLE 3x+3ND3d Wik1l1nkS Wh1Ch cr3atE hYperLiNks +0 t3H spEC1ph13D mE5S@gE / UsEr Pr0F1l3 oph T3h \$p3ciFIeD UseR.";
$lang['forum_settings_help_32'] = "<b>w1kiwIKI lOc@+I0N</b> 1\$ U53d +0 SP3ciphY +he Uri oPh y0uR W1kiwIKI. wHEn 3nter1n9 th3 URi usE [W1kIw0rd] to 1nDIC4+e wH3R3 1N teh UR1 +H3 Wikiw0rD 5h0ULD 4PP3@r, i.3.: <i>h+tp://3N.w1k1P3DI4.0RG/wiKi/[W1kIw0Rd]</i> w0ULD link yoUr wik1W0rd\$ +0 %s";
$lang['forum_settings_help_33'] = "<b>f0rum 4CC3\$\$ \$+4Tus</b> coN+ROls h0W Us3R\$ M@y aCc3ss youR pHoRUm.";
$lang['forum_settings_help_34'] = "<b>op3n</b> w1ll 4Llow all U\$3rs @ND 9u3s+S 4CCES\$ t0 Y0Ur fOruM wi+h0uT R3S+r1c+ion.";
$lang['forum_settings_help_35'] = "<b>cl0seD</b> PrEvENTs 4CcEss F0r 4lL Us3Rs, W1+h t3h Exc3pt10n 0PH teh 4DMIn wHo m4y s+1LL @ccE5S +Eh @DMIN panEL.";
$lang['forum_settings_help_36'] = "<b>reS+riC+3d</b> @llOw\$ +0 sEt 4 L1st 0ph U5Ers wH0 4r3 4ll0wED @cC3SS +0 Y0ur PHoruM.";
$lang['forum_settings_help_37'] = "<b>p4s\$w0rd pr0TeCTED</b> @ll0W\$ j00 +0 se+ 4 p4SSW0RD +0 G1V3 0ut +0 u\$3rs so +h3y Can @Cce5s y0Ur PhOrum.";
$lang['forum_settings_help_38'] = "wHen sett1ng r3s+riCTED Or p4\$\$w0Rd pr0+3C+3D moD3 j00 w1ll nE3d t0 s4ve yOUr CH4N9ES 83pH0rE j00 C@n CH4n93 thE Us3R 4ccEss privIl393s 0R passw0RD.";
$lang['forum_settings_help_39'] = "<b>Search Frequency</b> defines how long a user must wait before performing another search. Searches place a high demand on the database so it is recommended that you set this to at least 30 seconds to prevent \"search spamming\"fR0m kiLLINg tHe \$3rveR.";
$lang['forum_settings_help_40'] = "<b>p0\$T freqUEnCY</b> 1S +eh miNimUm t1M3 4 UsER mU\$+ w41+ b3pHOR3 +HEY C@N p0\$T 494IN. thi\$ set+Ing 4l5O @fpHECT\$ +H3 crEa+1On oF polLs. \$E+ +0 0 +o dis48lE +HE r3STriCT1on.";
$lang['forum_settings_help_41'] = "tH3 48ov3 op+I0N5 Ch4N93 T3h D3F4Ult v4LU3S Ph0r +3h u5ER r391\$+r4tion phorm. wh3r3 4PpliC4bLE 0thER s3T+in9S wIll usE +h3 PHOrum'\$ own dEFaULt se+T1Ng\$.";
$lang['forum_settings_help_42'] = "<b>pR3v3Nt U5e of DUPl1c4+E 3Ma1l 4DDR3ssES</b> FOrc3\$ BEEH1V3 +0 ch3ck +EH U53r @CC0unTS @94in5+ +3h Em4Il 4dDr3Ss +H3 U\$er 1\$ rEGis+3R1N9 wi+h @nD proMptS +H3M T0 Us3 4n0thEr iF I+ 1S @lre4dy In use.";
$lang['forum_settings_help_43'] = "<b>r3QuiR3 3M@iL CONpHirM4+I0n</b> WH3N EN4BL3D wIlL sEND 4n em@iL to E4ch n3w U5Er w1th 4 l1nk th4+ CAN B3 UsEd to CoNpHirm +hEiR 3m4il 4DDR3ss. UNTil th3y CONpH1RM thEIr 3m41l 4dDrEss +h3y wILL n0t 83 @8LE +0 P0st uNlEs5 +h31r usEr pERm1\$\$i0ns 4rE chaN9ED m4NU4Lly BY 4n @Dmin.";
$lang['forum_settings_help_44'] = "<b>uS3 Tex+-C4PtCH@</b> Pr3Sen+5 t3H N3W U\$3r Wi+H @ mAnGl3D iM4g3 whICH +hey Mu\$+ cOpY A nUmB3R PHr0m 1nt0 @ t3XT FI3LD 0N +hE RE91\$+R@+I0N phorM. UsE +his opTioN to Pr3venT 4u+0M@t3d \$igN-Up vi@ sCr1p+\$.";
$lang['forum_settings_help_45'] = "<b>tex+-c4p+cHA dIR3c+Ory</b> sp3cIphi3S +HE loc@T10n +h4T beEhivE wiLL s+0r3 1T'\$ teX+-c4ptch@ ima93s 4Nd PhoN+S in. tH1\$ D1r3C+0RY MUS+ bE wrI+@ble 8y +3H We8 53RvER / phP pRoC3\$s AND mU\$T 83 4Cce\$S18LE vI@ h++p. 4PH+3R j00 h4VE en4blED +Ext-c@PTCha J00 mUSt upL0@D SomE +rue +yP3 f0N+5 1Nt0 +hE f0NTs Su8-Dir3C+oRY OPh Y0ur m4In tEXT-c@Ptch@ dir3cTOry oTHErw1\$3 B3EH1V3 wIll 5k1P +he t3x+-c4p+Ch@ dUriN9 u53R r3g1\$tr@TIoN.";
$lang['forum_settings_help_46'] = "<b>Text Captcha key</b> allows you to change the key used by Beehive for generating the text captcha code that appears in the image. The more unique you make the key the harder it will be for automated processes to \"guess\"th3 C0de.";
$lang['forum_settings_help_47'] = "<b>p0st ED1+ gr@CE p3ri0D</b> AlloWs J00 +o DEPH1N3 4 p3riOD 1N mInUtes Wh3R3 users m4y 3d1+ pOsts wiThoU+ +h3 '3di+3d 8Y' tExt @pPE4R1Ng 0n +h31r Po\$TS. 1F 53+ +0 0 th3 '3DI+3D 8y' tExt wIll 4LW4Ys 4pp34r.";
$lang['forum_settings_help_48'] = "<b>unRE@D me5\$49es cUt-0FpH</b> \$p3ciFiE\$ h0W l0n9 unr3aD m3ss@g3s @R3 r3t4IN3d. J00 m4Y Ch0osE fRoM V4RioUS Pr3SE+ V@luES oR 3nt3R y0UR OwN Cu+-opHph pEri0d in \$ec0Nd\$. Thre4DS m0d1FIeD 3@RL13R +h4N +Eh dEFiNED CU+-opHF PERi0d wiLl 4ut0M4T1cally 4ppe4R 4s READ.";
$lang['forum_settings_help_49'] = "cH0o\$INg <b>dis48le UnR34d mEs\$@G3s</b> W1Ll COMplE+Ely REmoVE UnrE4d m3Ss4g3S 5UpP0R+ @nD rEmov3 +h3 R3l3vant 0pt10Ns froM thE Di\$cus\$10N TypE dR0p down On tHE ThR34d lI5t.";
$lang['forum_settings_help_50'] = "<b>r3Qu1RE u\$3r @pPr0v@l by @DMin</b> 4lL0w5 j00 +0 r3S+R1C+ @CC3SS BY N3w UsEr\$ UNt1l +HEY HAvE 8e3N 4pPr0v3D BY @ mODEr@+0R 0r 4DMin. w1+h0U+ @PpRov@l a u53r c4NNo+ 4cC3s\$ @ny 4REa of TEh 8EEH1v3 Ph0ruM 1ns+4LL@+i0N 1ncluD1n9 inDIviDU4l pHORuM\$, pM inb0x @nd mY phorums \$eC+i0Ns.";
$lang['forum_settings_help_51'] = "us3 <b>cL0SED ME\$SA9e</b>, <b>r35+r1c+3D m3ss493</b> 4nD <b>paSSW0rd pRo+EC+ED Me5s4g3</b> +0 CusTom1\$e TH3 m3\$s4G3 dispL4y3D WhEN Users 4CCEs\$ yOur phorUm 1n t3H V4rI0Us \$+4+3S.";
$lang['forum_settings_help_52'] = "j00 C4N U\$e H+Ml 1N Y0ur M3ss493s. hyP3rlinkS @ND 3M41L 4ddrEss3S wIlL 4l5O 8e @uToMaTic@llY CoNV3R+ED +0 lINK\$. +o us3 th3 D3phault BE3h1vE pHorum mESs493S cL3AR th3 PH13ld\$.";
$lang['forum_settings_help_53'] = "<b>aLLow U53r5 +0 Ch@n93 U\$ern4m3</b> PErm1+5 @lreaDy r39is+3rED US3r\$ +0 Ch4NgE tH31r USErN4ME. wHEN EN48leD J00 C4N +r4Ck tHe Ch4ngE\$ 4 User m@k3S +0 +h31r usERname v1@ t3h 4Dm1n USeR T0Ols.";
$lang['forum_settings_help_54'] = "us3 <b>fOrUm rUl3s</b> to EntEr 4n @cc3P+4BlE USe p0l1CY +H4+ EaCH Us3r MUSt 49r3E To BEPHorE R39is+3RINg 0n y0ur phorUM.";
$lang['forum_settings_help_55'] = "j00 c4n Us3 h+Ml 1N Y0Ur fOrUm RulEs. hyPERlinks @nD 3M@Il @dDr3S\$es w1Ll 4L5O 8E 4utom4T1c@lLy CONVer+3D tO l1NKs. +0 Use +hE DEPh4ul+ B33H1VE Ph0ruM @UP CLe@r TEh pHi3lD.";
$lang['forum_settings_help_56'] = "uSe <b>no-REPLy 3ma1L</b> +0 sp3CiFy 4n 3m41l @DDRE\$S +hAt D0es N0T 3xI\$+ or wIlL N0T 83 m0n1+0rED ph0r rEpLIEs. thi\$ EM4IL ADDRE\$S Will 8E UsED 1n +3H hE4dEr\$ f0r @Ll em41l5 53nt fRoM y0ur phorUm 1ncluDInG BUt nO+ lImI+3d +0 po\$+ @nD pM Notificat10n\$, User 3m41ls 4nd p4\$Sw0RD r3M1NDer\$.";
$lang['forum_settings_help_57'] = "i+ is rEC0mm3NDED +h@+ J00 UsE @n 3m41l 4DDREs\$ +H4+ DO3s no+ 3x1\$t +o h3lp cU+ D0wn 0N sp4m th4+ m4y BE DIR3CTED @+ Y0UR M41N F0RUM EM41l ADDR3s5";

// Attachments (attachments.php, get_attachment.php) ---------------------------------------

$lang['aidnotspecified'] = "a1d no+ \$P3C1F13d.";
$lang['upload'] = "uPLO4d";
$lang['uploadnewattachment'] = "uPlOAD nEw aT+@CHMent";
$lang['waitdotdot'] = "wa1+..";
$lang['successfullyuploaded'] = "sUcc35SfUlLy Upl0@D3D: %s";
$lang['failedtoupload'] = "f@il3d to UploaD: %s";
$lang['complete'] = "cOmplEtE";
$lang['uploadattachment'] = "upl0@d 4 Fil3 PHoR @+t4CHM3nt T0 +3h Mess@gE";
$lang['enterfilenamestoupload'] = "eN+er phil3N4m3(\$) to Upl0AD";
$lang['attachmentsforthismessage'] = "at+aChm3Nts phor +hIs m3ss4g3";
$lang['otherattachmentsincludingpm'] = "o+H3r 4++4CHm3nts (1NCLUDIn9 PM MEs\$493s 4nD 0TH3r pHorUM\$)";
$lang['totalsize'] = "toTal \$1ze";
$lang['freespace'] = "fR3e Sp4CE";
$lang['attachmentproblem'] = "tH3R3 w4S a PRO8l3m D0WNL0@dinG TH15 @++4CHMEN+. pL34se +Ry 49@In L4+ER.";
$lang['attachmentshavebeendisabled'] = "a++aCHm3Nts h4vE 833N DIs@bLED by +3h f0RUM own3R.";
$lang['canonlyuploadmaximum'] = "j00 C4N 0nLy upl04D @ max1MUm Oph 10 f1lEs @+ @ tiM3";
$lang['deleteattachments'] = "d3l3t3 @TtACHmEN+s";
$lang['deleteattachmentsconfirm'] = "aR3 j00 SuRe j00 want +0 DEl3TE +hE sEl3c+eD 4++4CHmEN+\$?";
$lang['deletethumbnailsconfirm'] = "ar3 j00 \$ur3 j00 w4n+ to D3let3 +he \$3l3CTED @T+4chmEN+s +hUMBn41L\$?";

// Changing passwords (change_pw.php) ----------------------------------

$lang['passwdchanged'] = "p4\$sw0RD Ch4NG3d";
$lang['passedchangedexp'] = "yOUR P4\$SW0rd h4s 8EEN ChAnGED.";
$lang['updatefailed'] = "upd4+e F4IlED";
$lang['passwdsdonotmatch'] = "pA5\$W0rds Do no+ M4+CH.";
$lang['newandoldpasswdarethesame'] = "nEW @nd olD pASSW0Rds 4r3 tEh s@M3.";
$lang['requiredinformationnotfound'] = "reQu1RED Inphorm@+i0N nOt pHoUnd";
$lang['forgotpasswd'] = "foRG0T p4\$\$W0rd";
$lang['resetpassword'] = "r3S3t P@ssw0RD";
$lang['resetpasswordto'] = "r3\$et p@ssw0Rd to";
$lang['invaliduseraccount'] = "iNv@l1D User ACC0unT \$PECIfi3d. Ch3cK 3ma1l PH0R C0rr3Ct L1nk";
$lang['invaliduserkeyprovided'] = "iNv4L1d user k3y provIDEd. ch3CK 3m4il foR C0rr3C+ L1nK";

// Deleting messages (delete.php) --------------------------------------

$lang['nomessagespecifiedfordel'] = "no m3\$549E \$p3CIphi3D Phor D3le+I0N";
$lang['deletemessage'] = "d3L3te mE\$s@ge";
$lang['postdelsuccessfully'] = "pO5+ d3LE+eD SUCCES5fully";
$lang['errordelpost'] = "errOR del3tin9 p0\$t";
$lang['cannotdeletepostsinthisfolder'] = "j00 C4nn0T dEl3tE p0S+s iN thi\$ f0ldeR";

// Editing things (edit.php, edit_poll.php) -----------------------------------------

$lang['nomessagespecifiedforedit'] = "n0 meSs4g3 SP3cipHi3d pH0R 3d1+ing";
$lang['cannoteditpollsinlightmode'] = "c4nno+ 3d1+ p0LLs iN l1gHT M0de";
$lang['editedbyuser'] = "ed1teD: %s 8y %s";
$lang['editappliedtomessage'] = "eDi+ 4pPlieD +o M3ss@gE";
$lang['errorupdatingpost'] = "eRR0r UpD4+1n9 p0s+";
$lang['editmessage'] = "eDIt me\$s493 %s";
$lang['editpollwarning'] = "<b>no+E</b>: eDi+1N9 C3R+@In @\$PECT\$ of 4 P0ll will vO1D 4LL +H3 CUrreNt v0tEs 4ND 4llow Pe0Pl3 +o V0TE 4941N.";
$lang['hardedit'] = "h4rd 3di+ 0P+iOns (V0+3S wIlL 8e r3s3t):";
$lang['softedit'] = "soPh+ EDi+ opt10nS (Vo+es wIlL B3 r3t4in3D):";
$lang['changewhenpollcloses'] = "ch4ngE wh3N +hE poLL CLo\$3s?";
$lang['nochange'] = "no cH4nG3";
$lang['emailresult'] = "eM4il REsUl+";
$lang['msgsent'] = "m3Ss4G3 sEn+";
$lang['msgsentsuccessfully'] = "m35\$@gE 53Nt sUcC3ssphulLy.";
$lang['mailsystemfailure'] = "m@1l systEm fA1lUr3. M3ss@9E no+ \$3n+.";
$lang['nopermissiontoedit'] = "j00 @rE n0+ permItTED to ED1+ +hIs mESs49e.";
$lang['cannoteditpostsinthisfolder'] = "j00 C4nno+ 3d1+ POst\$ IN th1\$ PHoldEr";
$lang['messagewasnotfound'] = "m3\$S4Ge %s wAs not PhOUND";

// Email (email.php) ---------------------------------------------------

$lang['sendemailtouser'] = "sEND 3ma1L to %s";
$lang['nouserspecifiedforemail'] = "nO user 5P3C1ph13D f0r 3M@ilinG.";
$lang['entersubjectformessage'] = "eN+ER a suBJeCT f0R tHE M3ss49e";
$lang['entercontentformessage'] = "eNt3r \$0m3 Con+3nt F0r t3H m3sS49E";
$lang['msgsentfromby'] = "tHiS ME\$S4g3 w45 53NT fr0M %s 8y %s";
$lang['subject'] = "sUbj3C+";
$lang['send'] = "s3ND";
$lang['userhasoptedoutofemail'] = "%s h@s 0p+eD oU+ 0F eM41l C0nT@CT";
$lang['userhasinvalidemailaddress'] = "%s h@s 4n 1nv4L1D 3Ma1l 4ddrEs\$";

// Message nofificaiton ------------------------------------------------

$lang['msgnotification_subject'] = "me5s493 not1ph1C4+i0N fr0M %s";
$lang['msgnotificationemail'] = "h3Llo %s,\n\n%s po\$+3d 4 Mess49E +o j00 0N %s.\n\n+hE 5UBJ3C+ I\$: %s.\n\n+o R34D +h4t MEsS493 AND 0thER\$ IN Th3 S4Me d1SCUs\$10n, 90 +O:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nnO+3: If j00 Do N0+ wisH T0 rECE1v3 EmaIl N0tiphicAT10ns oph phorUm mess49eS po\$+3D +0 y0U, g0 +0: %s CliCk oN my con+r0Ls +hen Ema1L 4ND privacY, uns3l3c+ +Eh ema1l no+iphIC@+1on Ch3CK8oX 4nD Pr3Ss SUBMi+.";

// Thread Subscription notification ------------------------------------

$lang['subnotification_subject'] = "sUbscr1p+10N no+iphiCAt1on fr0m %s";
$lang['subnotification'] = "hEll0 %s,\n\n%s pos+eD @ mEss493 in 4 ThrE4D j00 H@V3 \$UB5cRi8ED +o 0n %s.\n\nth3 \$u8JeC+ is: %s.\n\nt0 R3AD +h@+ m3s5493 4nD otHer\$ 1n +hE \$@M3 d1\$cU\$\$1ON, g0 T0:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nn0+3: iph J00 Do no+ wish to RECe1vE Em4il no+IFIC@+1ONS of n3w M3sS4g3S in +h1S +hr34d, g0 +0: %s 4ND 4Djust YOur 1n+ere\$t l3V3L 4t +HE 8oT+Om 0ph th3 pA9e.";

// PM notification -----------------------------------------------------

$lang['pmnotification_subject'] = "pm noTiPhiCAT10n fR0M %s";
$lang['pmnotification'] = "hEll0 %s,\n\n%s Po\$+Ed @ pM t0 j00 0N %s.\n\n+h3 5u8j3C+ 1s: %s.\n\n+0 re4D thE m3SS4ge g0 +O:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nN0TE: If j00 Do No+ wI\$H +0 REC31ve Em41L nOt1PHiCaT1on\$ 0f new Pm MEss493s p0\$+ED +o you, 90 +0: %s click My coN+r0LS +hen ema1l anD priv@cy, Unsel3C+ +Eh pM No+ifiC@+i0N ChECkBox AND prEss SuBM1T.";

// Password change notification ----------------------------------------

$lang['passwdchangenotification'] = "p@\$SwOrd CH@n9E no+IpHic4tION phr0M %s";
$lang['pwchangeemail'] = "hEll0 %s,\n\n+His 4 noT1F1C4+i0N 3ma1L to 1NForm j00 tH4+ y0uR P4\$sw0RD oN %s H4\$ B33N ch4n93d.\n\n1+ h45 b33N Ch4ngeD +o: %s 4nD w@5 CH4NG3d 8y: %s.\n\nIF j00 h4V3 r3c31v3D +his 3MA1L 1N Error or w3r3 n0T 3XpECT1Ng @ cH@ng3 +0 y0Ur p4\$\$W0rd pL34\$3 COnt4c+ +he foruM owneR or 4 moder4Tor ON %s 1mMEDI4TEly +0 c0rR3Ct 1+.";

// Email confirmation notification -------------------------------------

$lang['emailconfirmationrequired'] = "eM41l c0NPhiRm4+1ON rEQuIr3D ph0R %s";
$lang['confirmemail'] = "h3Llo %s,\n\nyOu r3c3NtlY CRE4+3d @ n3W U\$eR 4cc0Unt 0n %s.\n83PHor3 j00 Can S+4RT PO5+1N9 W3 n33d T0 COnfiRM y0Ur EmAIl 4dDr3SS. D0n't w0rry +HiS i\$ QUiTE 345y. 4LL j00 nE3d TO d0 1S Cl1ck +3h l1Nk 83l0w (Or CopY 4ND p@stE It 1N+0 Y0uR bR0WsER):\n\n%s\n\nOnc3 confIrm@+10N i5 Compl3+3 j00 M4y Lo9IN @Nd 5TAr+ po\$t1N9 1MMeDi4+3lY.\n\n1f j00 D1d N0+ CreatE a user @Cc0Unt 0n %s Ple@se @CC3PT oUR @P0lo91E\$ aND PhorW@Rd thi\$ EM4il T0 %s s0 +h@T +h3 \$0urcE oPH 1t m4y 83 INv3\$t1g4+3D.";
$lang['confirmchangedemail'] = "h3Llo %s,\n\ny0U r3c3NTly CH@NG3d yoUr 3M4IL 0n %s.\nBEF0r3 j00 C4n \$+@R+ PoSt1NG @G41n w3 nE3D to CoNpHiRm Your n3W 3m@iL 4Ddre\$S. DOn'T WorrY +HI\$ i5 QuiTE 34\$y. aLl j00 NEEd +o D0 1\$ clicK +HE L1Nk 8el0W (or C0PY 4ND p@sTE 1+ iN+o your browseR):\n\n%s\n\n0nC3 C0nphirM@+i0n 1\$ COmplEte j00 may COnT1NU3 +0 usE +h3 f0Rum 45 n0rM4l.\n\n1f j00 weR3 not 3XPECtIng thi\$ EmaiL fr0M %s Ple4\$3 aCCep+ our 4p0Lo9IEs 4nD forwarD +his 3M4il +0 %s s0 th4+ +Eh s0urCE 0ph 1t m4Y 83 inVeST1g4tED.";


// Forgotten password notification -------------------------------------

$lang['forgotpwemail'] = "heLl0 %s,\n\ny0u reqU3\$+3d +His 3-M@1l phrOm %s bEC@UsE j00 h@v3 pH0rg0TtEn YOUR P4\$sw0RD.\n\nClICk +3H lInK BELow (0r C0py @nD P4stE 1T 1N+0 yOUR br0w\$3R) t0 re\$et y0ur P4\$SWoRD:\n\n%s";

// Forgotten password form.

$lang['passwdresetrequest'] = "your P@ssw0rD r3sE+ rEqU3S+ frOm %s";
$lang['passwdresetemailsent'] = "p4\$SworD REsE+ 3-m41l sEn+";
$lang['passwdresetexp'] = "j00 SHoUlD \$H0rtly r3C31VE @N 3-M41l Con+@inIn9 1n\$+RUC+10ns phor rEsEtt1ng yoUr p4\$Sw0rd.";
$lang['validusernamerequired'] = "a v4lid usERn@m3 1\$ REquIr3D";
$lang['forgottenpasswd'] = "fOrg0+ p4\$\$worD";
$lang['couldnotsendpasswordreminder'] = "could noT s3nd p4\$\$word ReMiNDER. pl34Se CoNt4c+ +3h f0RUm oWn3R.";
$lang['request'] = "r3QU3St";

// Email confirmation (confirm_email.php) ------------------------------

$lang['emailconfirmation'] = "eM4il CoNpHirm4+I0n";
$lang['emailconfirmationcomplete'] = "tH4nk J00 F0R C0nphiRm1Ng Y0Ur 3M4IL 4dDR3sS. J00 m@Y n0w l091n AND \$+4rt po5+1N9 imm3DI@tELY.";
$lang['emailconfirmationfailed'] = "eMA1L C0nfirM4T10n h@\$ f41l3d, pl34\$3 try A9@iN lATEr. if j00 enCOUNTER +Hi\$ 3rror mUlt1pl3 timEs pLEAsE C0n+4Ct +h3 FoRum oWn3r or 4 M0DER4ToR F0R @S\$1\$+@nc3.";

// Links database (links*.php) -----------------------------------------

$lang['toplevel'] = "toP LEvel";
$lang['maynotaccessthissection'] = "j00 May N0T 4cC3sS Thi\$ \$3C+i0n.";
$lang['toplevel'] = "t0P lEVEl";
$lang['links'] = "l1Nk\$";
$lang['viewmode'] = "v13w m0DE";
$lang['hierarchical'] = "h13r4rchiC4l";
$lang['list'] = "l1S+";
$lang['folderhidden'] = "th1\$ F0LDER i\$ HIDDEN";
$lang['hide'] = "hid3";
$lang['unhide'] = "unH1D3";
$lang['nosubfolders'] = "no suBfolDErs 1N Th1\$ c4+390Ry";
$lang['1subfolder'] = "1 suBf0ldeR 1n +HiS c4t390ry";
$lang['subfoldersinthiscategory'] = "sUBfolD3R\$ In +hi\$ c4+3g0ry";
$lang['linksdelexp'] = "en+RiES iN @ d3L3teD pH0LDER WiLl 83 m0v3d +0 +3h p@r3nt F0ldeR. 0NLY F0LD3rs WHiCH do n0t CONT4IN \$U8Ph0LD3r\$ m@y 8e D3l3+ED.";
$lang['listview'] = "l1ST vi3w";
$lang['listviewcannotaddfolders'] = "c@Nn0+ 4DD pHolD3rs 1N +his vI3W. \$HOwiN9 20 EN+RI3S 4+ a tiME.";
$lang['rating'] = "r4+ing";
$lang['nolinksinfolder'] = "no linKs 1n thI\$ pHOLDER.";
$lang['addlinkhere'] = "aDd l1nk hEr3";
$lang['notvalidURI'] = "tHat 15 N0t 4 v@l1d uri!";
$lang['mustspecifyname'] = "j00 mus+ \$P3c1Phy @ n4ME!";
$lang['mustspecifyvalidfolder'] = "j00 mU\$t 5p3cifY @ vAlid pHolDER!";
$lang['mustspecifyfolder'] = "j00 mu\$T sPECIphy 4 foLD3r!";
$lang['successfullyaddedlinkname'] = "sucC3\$\$fuLlY 4Dd3D l1nk '%s'";
$lang['failedtoaddlink'] = "fAil3D +0 4dd L1NK";
$lang['failedtoaddfolder'] = "fa1l3D +0 4DD pholDEr";
$lang['addlink'] = "aDD 4 Link";
$lang['addinglinkin'] = "addiNG l1nK in";
$lang['addressurluri'] = "aDdrE5s";
$lang['addnewfolder'] = "aDD @ N3w f0LDER";
$lang['addnewfolderunder'] = "addinG nEw PhoLDER uND3r";
$lang['editfolder'] = "edI+ PholDER";
$lang['editingfolder'] = "eDI+ing F0lDER";
$lang['mustchooserating'] = "j00 MU5+ CHo0\$3 a R@+1N9!";
$lang['commentadded'] = "y0ur ComMEn+ w@S 4DDEd.";
$lang['commentdeleted'] = "c0Mm3nt w4s DEl3T3D.";
$lang['commentcouldnotbedeleted'] = "coMM3nt c0UlD N0+ BE DELE+ED.";
$lang['musttypecomment'] = "j00 mU\$+ TYP3 4 CoMm3nT!";
$lang['mustprovidelinkID'] = "j00 MUst pROviD3 @ l1NK iD!";
$lang['invalidlinkID'] = "iNv4liD l1nk 1d!";
$lang['address'] = "adDr3\$S";
$lang['submittedby'] = "submi+tED by";
$lang['clicks'] = "clICKs";
$lang['rating'] = "r4+ing";
$lang['vote'] = "vote";
$lang['votes'] = "v0TEs";
$lang['notratedyet'] = "no+ rAtED 8y @nyoN3 y3t";
$lang['rate'] = "r@+3";
$lang['bad'] = "b@d";
$lang['good'] = "g00d";
$lang['voteexcmark'] = "v0te!";
$lang['clearvote'] = "cLe4r v0+3";
$lang['commentby'] = "c0MmeNt 8Y %s";
$lang['addacommentabout'] = "adD @ C0mm3nT 4BOu+";
$lang['modtools'] = "moD3r4tioN +0olS";
$lang['editname'] = "ed1t n@ME";
$lang['editaddress'] = "eD1+ @DDREs5";
$lang['editdescription'] = "ed1+ D3sCr1P+i0N";
$lang['moveto'] = "move +0";
$lang['linkdetails'] = "l1nk D3ta1LS";
$lang['addcomment'] = "add c0mm3Nt";
$lang['voterecorded'] = "y0ur v0+3 h45 B3eN rECOrdED";
$lang['votecleared'] = "y0Ur Vo+3 H@s B33n CLE4r3D";
$lang['linknametoolong'] = "l1nk N4me t0o LOn9. M4xiMUM 1s %s ch@r4cT3R\$";
$lang['linkurltoolong'] = "lINK uRL tOO l0n9. Max1mUm 1\$ %s ch4R4Cter5";
$lang['linkfoldernametoolong'] = "f0LDEr n4m3 t0o Lon9. m4XiMum l3NG+h i\$ %s ch4R4Cters";

// Login / logout (llogon.php, logon.php, logout.php) -----------------------------------------

$lang['loggedinsuccessfully'] = "j00 l0ggED 1N sUCcesSFULlY.";
$lang['presscontinuetoresend'] = "pr3s\$ Con+inU3 +0 r3sEND F0Rm D@+@ oR c4nCEL tO R3lO4D p49e.";
$lang['usernameorpasswdnotvalid'] = "the Usern4me 0r P@\$\$w0rd j00 \$uppli3d I5 no+ V4LiD.";
$lang['rememberpasswds'] = "r3M3m8er p4S\$w0rDs";
$lang['rememberpassword'] = "rEmeM8Er pA5\$w0rD";
$lang['enterasa'] = "enTER 4S 4 %s";
$lang['donthaveanaccount'] = "don't h4V3 4N 4CCoUnt? %s";
$lang['registernow'] = "r391\$TEr now.";
$lang['problemsloggingon'] = "pR08lEmS log91ng 0n?";
$lang['deletecookies'] = "d3L3t3 Co0kies";
$lang['cookiessuccessfullydeleted'] = "cOokI3S 5ucCESsFully DEL3TEd";
$lang['forgottenpasswd'] = "f0rG0++3n Y0Ur P4ssw0rD?";
$lang['usingaPDA'] = "uS1n9 4 pD4?";
$lang['lightHTMLversion'] = "lI9ht hTml v3Rs10n";
$lang['youhaveloggedout'] = "j00 H4v3 l0GgeD out.";
$lang['currentlyloggedinas'] = "j00 4rE CurREntLY l0gGed in @\$ %s";
$lang['logonbutton'] = "l0g0n";
$lang['otherbutton'] = "oTher";
$lang['yoursessionhasexpired'] = "y0UR \$es\$1oN Has 3XP1R3D. j00 wiLl N3ED To Login 4G@In +0 CoNt1NUE.";

// My Forums (forums.php) ---------------------------------------------------------

$lang['myforums'] = "my PHOruMs";
$lang['allavailableforums'] = "aLl @v41L48lE F0rUM\$";
$lang['favouriteforums'] = "f4v0ur1TE Ph0RUm\$";
$lang['ignoredforums'] = "i9nor3D F0RUms";
$lang['ignoreforum'] = "i9n0r3 PHorum";
$lang['unignoreforum'] = "uNIgn0RE f0rum";
$lang['lastvisited'] = "l4\$t vis1teD";
$lang['forumunreadmessages'] = "%s unrE4d mE5\$@ge\$";
$lang['forummessages'] = "%s mess@Ge\$";
$lang['forumunreadtome'] = "%s unre@D &quot;to: me&quot;";
$lang['forumnounreadmessages'] = "nO unr3aD M3ss@g3s";
$lang['removefromfavourites'] = "reM0v3 from Ph@v0ur1+Es";
$lang['addtofavourites'] = "add to f4V0uri+3s";
$lang['availableforums'] = "aV@ilaBL3 forUM5";
$lang['noforumsofselectedtype'] = "ther3 ar3 N0 F0rUms 0F +hE \$3leCTeD TYp3 4va1l@BLE. pleAsE 53L3c+ 4 D1Phph3r3nT typ3.";
$lang['successfullyaddedforumtofavourites'] = "sUCcES\$phully @DDED f0rum To Phav0uri+E\$.";
$lang['successfullyremovedforumfromfavourites'] = "succ3\$SphUlly ReMoveD Ph0rUm PhrOm f4v0uri+es.";
$lang['successfullyignoredforum'] = "sUCC3ssfUlly i9NOrED phoruM.";
$lang['successfullyunignoredforum'] = "sUcCE\$SfUlly Un1gN0rED phorUm.";
$lang['failedtoupdateforuminterestlevel'] = "f4il3D +0 upd@TE F0RUm 1NtERE\$+ LEvEL";
$lang['noforumsavailablelogin'] = "tH3RE @r3 n0 forum5 Ava1L48lE. pL345e loG1N to V13w Y0ur fOrUm5.";
$lang['passwdprotectedforum'] = "p4\$Sw0rD pRo+3Ct3d phoRUM";
$lang['passwdprotectedwarning'] = "tHis F0rUm 1\$ p@\$\$w0RD Pr0T3ctED. +o 941N aCCES\$ 3n+Er T3h p4S\$worD 83low.";

// Message composition (post.php, lpost.php) --------------------------------------

$lang['postmessage'] = "pOs+ me5\$@gE";
$lang['selectfolder'] = "sel3C+ f0LDER";
$lang['mustenterpostcontent'] = "j00 MUst en+eR s0m3 Con+3NT f0r +3h p05t!";
$lang['messagepreview'] = "mess49E prev13W";
$lang['invalidusername'] = "iNV@l1d UsErN@m3!";
$lang['mustenterthreadtitle'] = "j00 mu\$+ eNtEr @ t1+L3 f0r +H3 +hr3ad!";
$lang['pleaseselectfolder'] = "pL34S3 \$EL3C+ a F0LDER!";
$lang['errorcreatingpost'] = "erROR Cr34t1nG Pos+! pLE4sE +Ry a9@in 1N 4 few mINUTES.";
$lang['createnewthread'] = "cRe@+E n3W thRE@D";
$lang['postreply'] = "p0S+ rEplY";
$lang['threadtitle'] = "tHre4d t1+l3";
$lang['messagehasbeendeleted'] = "m3\$\$a9e n0t f0unD. CH3CK th4+ 1+ h@\$N't 83eN dEl3TEd.";
$lang['messagenotfoundinselectedfolder'] = "m3\$s4G3 NOT FoUnD in \$el3CTED F0lDEr. ch3ck +hAt 1+ h4sN'+ B33n mov3D or DElE+ED.";
$lang['cannotpostthisthreadtypeinfolder'] = "j00 C@nn0t P0S+ thI\$ +hR3AD +Yp3 1n +h4+ PhoLDER!";
$lang['cannotpostthisthreadtype'] = "j00 c4Nnot po\$+ +h1\$ +hR34D tYp3 as +H3r3 4RE n0 4V@Il@BLE F0LDER5 tHa+ 4ll0w 1+.";
$lang['cannotcreatenewthreads'] = "j00 cAnnot CR34te nEW +HR34dS.";
$lang['threadisclosedforposting'] = "this thr34D 1\$ cl0seD, j00 c4nno+ p05+ 1N i+!";
$lang['moderatorthreadclosed'] = "w@rN1n9: tHIs thR34D 1\$ cLo\$ed For p0\$+1n9 t0 n0Rm4l U53r\$.";
$lang['usersinthread'] = "u\$3rS In tHrE4D";
$lang['correctedcode'] = "coRr3C+Ed c0D3";
$lang['submittedcode'] = "sUbmi+Ted CoD3";
$lang['htmlinmessage'] = "hTml in m3SS@GE";
$lang['disableemoticonsinmessage'] = "d1S@8le eM0T1con\$ 1n ME\$S@G3";
$lang['automaticallyparseurls'] = "aut0m4t1CAlLy P4RsE Url\$";
$lang['automaticallycheckspelling'] = "aUt0m4t1c@lly ChEck 5P3ll1Ng";
$lang['setthreadtohighinterest'] = "s3+ +hr3@d +o H1gh 1N+Er3sT";
$lang['enabledwithautolinebreaks'] = "eN4BlEd wI+h aU+0-l1ne-8re4ks";
$lang['fixhtmlexplanation'] = "tH1S F0rum us3s htMl pH1LtER1Ng. Y0uR Su8M1t+3d htMl h@5 BE3n Mod1phi3d 8y th3 PHIL+3rs 1n somE WaY.\\n\\nTO v13W y0UR oR1GiN4L C0dE, sel3CT Th3 \\'SUBMI+tED C0De\\' R4d10 8u+T0n.\\nTo v13w +HE m0d1Ph1ED C0de, \$3l3c+ +hE \\'c0rRECtED C0d3\\' R4DIo 8u++0n.";
$lang['messageoptions'] = "m3SS4G3 0p+iOn\$";
$lang['notallowedembedattachmentpost'] = "j00 @rE no+ 4LL0WED to 3m8ED 4TT@chMEN+s 1N yoUR PosTs.";
$lang['notallowedembedattachmentsignature'] = "j00 4re n0T allow3D +0 em8ED @T+4cHments In y0UR si9N4tuR3.";
$lang['reducemessagelength'] = "mess49E LeN9tH MusT 83 undEr 65,535 ch4RACT3r\$ (CURr3ntLY: %s)";
$lang['reducesiglength'] = "si9n@Tur3 l3NG+h mu\$T 8E UnDER 65,535 cH4r4C+3rs (CURRENtlY: %s)";
$lang['cannotcreatethreadinfolder'] = "j00 c4nN0t crEA+3 nEw +hr34Ds in +H1s PhoLDER";
$lang['cannotcreatepostinfolder'] = "j00 CanNot REPly +0 p0sTS 1n tH1s folDEr";
$lang['cannotattachfilesinfolder'] = "j00 c@nN0T Post 4t+@ChmeNt5 1N +hi\$ Ph0LD3r. rEm0V3 @++@CHm3N+s To C0nt1Nu3.";
$lang['postfrequencytoogreat'] = "j00 can only po\$+ 0nC3 eVERy %s 53C0nDs. pl34s3 +rY A9@in lATer.";
$lang['emailconfirmationrequiredbeforepost'] = "eM@1L C0nphirm4+10n 1\$ REqUIR3d BeF0re j00 C4n posT. iPh j00 havE N0t r3c31v3d 4 C0Nf1rm4tiOn 3m4il Ple4\$3 ClICK The 8u++0n 83l0w 4nD 4 N3W on3 W1ll BE S3nT +o yOu. 1Ph Your Em4il 4ddr3SS n3ed\$ ch4N91Ng PlE@s3 D0 so 8EpH0Re r3QU3S+1n9 4 nEw C0nphIrm4tioN 3m@il. j00 m4y Ch4NgE your 3m4il 4ddr3ss 8y cl1CK my Con+r0ls 4BOvE 4nd thEn U\$3r D3t4IL\$";
$lang['emailconfirmationfailedtosend'] = "c0NPHirm4t10n eM4Il F4IL3d +0 SEnD. plE4\$3 C0n+@CT tHE F0Rum owN3R To rECt1phy Th1\$.";
$lang['emailconfirmationsent'] = "cOnphirm4+1ON 3M4Il H4\$ B33n R3senT.";
$lang['resendconfirmation'] = "r3\$EnD C0NpHIrm@+i0N";
$lang['userapprovalrequiredbeforeaccess'] = "y0uR Us3r @CCOUnt NEEDS +0 83 @pproV3D 8Y 4 f0rUm @DmIn B3fOrE j00 cAn @cC3ss +3h r3qu3s+ED phorUM.";

// Message display (messages.php & messages.inc.php) --------------------------------------

$lang['inreplyto'] = "iN R3ply +o";
$lang['showmessages'] = "sHow m3Ss493\$";
$lang['ratemyinterest'] = "r@T3 My 1N+er3s+";
$lang['adjtextsize'] = "adjus+ +Ext siZ3";
$lang['smaller'] = "sm@ll3r";
$lang['larger'] = "l@rgeR";
$lang['faq'] = "f@q";
$lang['docs'] = "docS";
$lang['support'] = "suPPor+";
$lang['donateexcmark'] = "d0NATe!";
$lang['fontsizechanged'] = "f0n+ \$IZ3 chanGeD. %s";
$lang['framesmustbereloaded'] = "fR@M3S mUst 83 r3L04D3d m4NU4Lly +0 s3E CHaN93s.";
$lang['threadcouldnotbefound'] = "t3H rEqU3sTED +hr34D c0uLD N0t BE Ph0UnD 0R aCceSS w4s D3N13D.";
$lang['mustselectpolloption'] = "j00 mUST sel3ct @N opt1on +0 v0+3 F0R!";
$lang['mustvoteforallgroups'] = "j00 mus+ V0tE 1n EvEry 9roup.";
$lang['keepreading'] = "ke3p r34d1N9";
$lang['backtothreadlist'] = "b4ck t0 Thre4D L1S+";
$lang['postdoesnotexist'] = "th@t P0S+ D0ES no+ 3X1s+ IN Th1\$ +hR3@D!";
$lang['clicktochangevote'] = "cLicK t0 ch4NG3 V0+3";
$lang['youvotedforoption'] = "j00 V0tED f0r 0P+Ion";
$lang['youvotedforoptions'] = "j00 vo+eD pH0r OPt1Ons";
$lang['clicktovote'] = "cl1Ck +0 vOtE";
$lang['youhavenotvoted'] = "j00 h4v3 noT v0t3D";
$lang['viewresults'] = "vI3W r3suLt\$";
$lang['msgtruncated'] = "meSS49e +ruNC4ted";
$lang['viewfullmsg'] = "v1ew fulL m3ss@gE";
$lang['ignoredmsg'] = "igN0reD ME\$\$49E";
$lang['wormeduser'] = "w0RmED Us3R";
$lang['ignoredsig'] = "ign0r3d S1gn4+urE";
$lang['messagewasdeleted'] = "m3sSA93 %s.%s w@\$ D3leteD";
$lang['stopignoringthisuser'] = "stOP 1gN0r1n9 Thi\$ US3r";
$lang['renamethread'] = "r3N4M3 +hr34D";
$lang['movethread'] = "mOve tHr3@D";
$lang['torenamethisthreadyoumusteditthepoll'] = "tO r3Name +h1S +HrEaD J00 mu\$t 3D1+ +3h p0lL.";
$lang['closeforposting'] = "cLose f0R pO\$+iNg";
$lang['until'] = "unT1l 00:00 Utc";
$lang['approvalrequired'] = "aPpr0V4l R3qUirED";
$lang['messageawaitingapprovalbymoderator'] = "m35\$49e %s.%s is @w41+InG 4pproVaL BY @ mODER@+0r";
$lang['postapprovedsuccessfully'] = "pOS+ @ppr0V3d \$uCCessfUlLy";
$lang['postapprovalfailed'] = "p0ST apPrOval f41l3D.";
$lang['postdoesnotrequireapproval'] = "po\$+ d0ES not R3Qu1R3 4PpR0v@l";
$lang['approvepost'] = "aPPR0V3 P0st f0R Di\$play";
$lang['approvedbyuser'] = "approveD: %s 8y %s";
$lang['makesticky'] = "m@kE sTiCKy";
$lang['messagecountdisplay'] = "%s OF %s";
$lang['linktothread'] = "p3Rm4N3n+ L1nk +o +hI\$ Thre4d";
$lang['linktopost'] = "link +0 p0s+";
$lang['linktothispost'] = "l1NK +0 thi\$ p0s+";
$lang['imageresized'] = "thIs IM@GE hAs 8eeN r3\$1zEd (0r1G1n@l s1Z3 %1\$SX%2\$S). TO V1EW tHE fulL-\$iz3 im493 CL1ck h3re.";
$lang['messagedeletedbyuser'] = "m3\$S4g3 %s.%s D3let3d %s by %s";
$lang['messagedeleted'] = "me\$Sa93 %s.%s w@5 D3l3TED";

// Moderators list (mods_list.php) -------------------------------------

$lang['cantdisplaymods'] = "c@NN0t d1\$pl4Y pHoLDER mOdeR@+0Rs";
$lang['moderatorlist'] = "modeR4T0R lis+:";
$lang['modsforfolder'] = "m0DER@toRs f0R ph0lder";
$lang['nomodsfound'] = "n0 m0DEr4tOR\$ F0unD";
$lang['forumleaders'] = "f0RUm l3ADERs:";
$lang['foldermods'] = "f0Ld3r moDeR4Tors:";

// Navigation strip (nav.php) ------------------------------------------

$lang['start'] = "s+@r+";
$lang['messages'] = "mEsS4GE5";
$lang['pminbox'] = "in80x";
$lang['startwiththreadlist'] = "s+@r+ pA9E w1th +hr34D l1\$+";
$lang['pmsentitems'] = "seN+ I+3ms";
$lang['pmoutbox'] = "ou+Box";
$lang['pmsaveditems'] = "s4v3D iTEms";
$lang['pmdrafts'] = "dr4pht\$";
$lang['links'] = "link5";
$lang['admin'] = "aDm1n";
$lang['login'] = "lo91N";
$lang['logout'] = "lOg0Ut";

// PM System (pm.php, pm_write.php, pm.inc.php) ------------------------

$lang['privatemessages'] = "pr1vat3 m3SS493s";
$lang['recipienttiptext'] = "s3P4rate R3C1pien+5 8y \$3M1-C0lon or COMM4";
$lang['maximumtenrecipientspermessage'] = "th3re i\$ 4 LImI+ 0PH 10 rEc1pi3NTs p3R m3sS@gE. PLEAsE @M3nD Y0Ur RECIPIeNt lI\$+.";
$lang['mustspecifyrecipient'] = "j00 Mu\$T 5p3CIphy 4+ lEA\$+ On3 R3cIpiEN+.";
$lang['usernotfound'] = "u\$er %s NOt pH0uNd";
$lang['sendnewpm'] = "s3nD n3w pm";
$lang['savemessage'] = "s4V3 m3ss4g3";
$lang['timesent'] = "t1M3 sent";
$lang['errorcreatingpm'] = "erR0R Cr34+iNG pm! plE4\$e +Ry 4G@In in 4 ph3W m1nu+3S";
$lang['writepm'] = "writ3 m3\$\$@ge";
$lang['editpm'] = "ed1+ m3sS4ge";
$lang['cannoteditpm'] = "caNNo+ Ed1+ +hIs Pm. It h@5 @lRE@Dy 8eeN V13WED By t3h R3C1p13Nt oR +hE ME\$S4G3 D0eS n0+ 3X1\$+ 0r 1t 1S In4cce\$sible 8Y j00";
$lang['cannotviewpm'] = "c4NN0+ v1ew pm. m35\$AgE D0es NoT 3x1s+ Or i+ is 1N@CC3551BLe 8Y J00";
$lang['pmmessagenumber'] = "m35\$a93 %s";

$lang['youhavexnewpm'] = "j00 H4v3 %d n3w M3Ss49es. w0ULD j00 l1K3 to G0 to y0Ur 1n80x Now?";
$lang['youhave1newpm'] = "j00 h4Ve 1 neW ME\$S@ge. WoUlD j00 likE +0 GO +0 Y0ur inB0X n0w?";
$lang['youhave1newpmand1waiting'] = "j00 h@VE 1 n3W mE\$S49E.\\n\\nY0u @lso h4V3 1 m3ss493 4waITIn9 d3LIv3rY. t0 R3CE1V3 +hI\$ mEss@g3 pLEAs3 Cl3@r s0ME \$p@ce In y0Ur In80X.\\n\\nWOulD j00 lIk3 to g0 t0 y0Ur 1N80x now?";
$lang['youhave1pmwaiting'] = "j00 hAvE 1 mE\$S493 4w@I+1n9 DELIv3ry. to R3c3IV3 +HI5 me\$s@g3 pL34SE CLE4R \$0m3 SP4cE 1N Y0ur In8Ox.\\n\\nWoUlD j00 liK3 +0 go +0 y0ur InB0x n0W?";
$lang['youhavexnewpmand1waiting'] = "j00 havE %d nEw M3ssa9es.\\n\\nY0U 4LSO h4vE 1 M3ss@gE @w@It1n9 D3liVERY. t0 r3C31V3 +hi\$ mE\$S@g3 pl34sE CL34r \$0m3 sp4CE iN Y0Ur 1n8Ox.\\n\\nW0uld J00 l1k3 +0 g0 +o yOUr 1N8OX now?";
$lang['youhavexnewpmandxwaiting'] = "j00 h4V3 %d neW mes5493s.\\n\\nYOU aL\$0 h4V3 %d mess@gE\$ @w@I+iN9 DEL1v3Ry. t0 rEcE1v3 +h3sE M3ss493 plE4\$3 CLe4R \$0M3 \$p@CE In your 1N80X.\\n\\nWOulD j00 lik3 to g0 to y0Ur 1N80x NOW?";
$lang['youhave1newpmandxwaiting'] = "j00 h4vE 1 N3W M3SS@GE.\\n\\ny0U @lso hAv3 %d Mess49e\$ 4wa1TINg dEL1V3ry. To REc3iVE +HEsE MEss@Ge\$ PlE4sE CLE4r soM3 sp@CE In y0UR InB0x.\\n\\nWouLD J00 l1K3 +0 90 To Y0Ur in8ox now?";
$lang['youhavexpmwaiting'] = "j00 havE %d MEss493s 4W@i+ing DElIv3ry. T0 reC31v3 +H3s3 mE\$S@G3S pL3@\$e CLE@r s0mE sp@cE iN Y0UR 1n8ox.\\n\\nw0ulD J00 l1Ke +0 90 +0 Y0UR 1N80X nOw?";

$lang['youdonothaveenoughfreespace'] = "j00 D0 No+ H4v3 3noU9h Fr3E 5pAC3 +0 sEnd +h1\$ Mess@gE.";
$lang['userhasoptedoutofpm'] = "%s H@s 0PtED 0UT 0pH RECE1v1nG pER50n4L mess4GE5";
$lang['pmfolderpruningisenabled'] = "pM F0lder prUN1Ng is 3N4BLEd!";
$lang['pmpruneexplanation'] = "tH1S f0ruM UsE\$ pm folD3R pRUn1NG. TEh m3SS49E\$ J00 h4Ve \$+0RED In yoUr iN80X @nd \$3nT 1+3mS\\nf0lD3R5 4R3 suBj3C+ to 4U+om@Tic DEL3+i0N. aNy m3SS@9es j00 w1\$H To keEp sH0ULD BE M0Ved +0\\nY0UR \\'S4V3d I+3ms\\' foldER s0 +h4+ Th3y ar3 n0t D3leted.";
$lang['yourpmfoldersare'] = "yoUR pm PHOLDErS 4RE %s phull";
$lang['currentmessage'] = "cURREn+ M3S\$@G3";
$lang['unreadmessage'] = "uNre4D m3ss493";
$lang['readmessage'] = "r34D MEsS49E";
$lang['pmshavebeendisabled'] = "p3R50nal mEsS493S h4VE b3EN dis@BLED By +h3 f0rum 0wn3r.";
$lang['adduserstofriendslist'] = "adD U\$3rs +0 y0UR phriEnD5 l1\$+ +0 h4Ve thEM 4ppe4R in 4 drop Down on TEH Pm wrI+3 m3ss493 P@9e.";

$lang['messagesaved'] = "m35\$@gE 5@v3D";
$lang['messagewassuccessfullysavedtodraftsfolder'] = "m3Ss49E w@\$ \$uCCEssphUllY s4VEd +0 'drAphTs' ph0ld3R";
$lang['couldnotsavemessage'] = "c0ULD n0+ S4v3 mEs5@gE. m4k3 \$URE j00 H4ve 3NOU9H aV41laBL3 fr3E 5p@cE.";
$lang['pmtooltipxmessages'] = "%s ME\$s@9E\$";
$lang['pmtooltip1message'] = "1 M3ss4g3";

$lang['allowusertosendpm'] = "alLOW usEr tO 53ND P3R\$0N4l mess@9Es +o m3";
$lang['blockuserfromsendingpm'] = "bl0Ck Us3R fRom senDINg P3r\$0n4L mESs493s +0 mE";
$lang['yourfoldernamefolderisempty'] = "your %s foLD3R 1S EMpTy";
$lang['successfullydeletedselectedmessages'] = "sUCCEs\$fully D3LetED sEl3CTED M3SS@gE\$";
$lang['successfullyarchivedselectedmessages'] = "succes5fuLlY @rCHIv3d sELEC+eD M3ss49ES";
$lang['failedtodeleteselectedmessages'] = "f@il3D to dElEtE \$EL3c+3D m3ss4g3S";
$lang['failedtoarchiveselectedmessages'] = "f4il3d T0 4rcHiv3 \$EL3C+3d m3ss49Es";

// Preferences / Profile (user_*.php) ---------------------------------------------

$lang['mycontrols'] = "mY COntroLs";
$lang['myforums'] = "my PH0rums";
$lang['menu'] = "mENu";
$lang['userexp_1'] = "u5E +hE m3Nu 0N +3h LEPh+ +0 m4n4G3 YoUr \$3ttin9S.";
$lang['userexp_2'] = "<b>u\$3R DE+4iLs</b> @Ll0w\$ j00 to cH@nG3 YoUr Nam3, 3Ma1L 4dDr3\$S @nD p4SSw0RD.";
$lang['userexp_3'] = "<b>user pR0phIl3</b> ALloW\$ J00 to EDI+ y0UR U\$er ProphIlE.";
$lang['userexp_4'] = "<b>ch4Nge PassW0rD</b> @LLOw\$ j00 +0 CHaNGe yOuR P@ssw0rd";
$lang['userexp_5'] = "<b>em4il &amp; pr1V4cy</b> Let\$ J00 CH@nGe h0W j00 C4n B3 C0nt4ctED 0N 4ND 0PHPh tHE F0Rum.";
$lang['userexp_6'] = "<b>f0RUM op+IoN\$</b> LETS j00 Ch4ng3 hOw +3h f0ruM look\$ @nd wOrKs.";
$lang['userexp_7'] = "<b>aT+@ChM3NT\$</b> 4ll0w\$ j00 to eDI+/DEl3T3 yOuR 4+t4CHm3ntS.";
$lang['userexp_8'] = "<b>siGN4TurE</b> L3+S j00 3D1+ yoUR 5ign4tur3.";
$lang['userexp_9'] = "<b>rEl4+10NSH1Ps</b> lEts j00 m4N@g3 YOUr reLaTi0N5HIP W1+H o+hEr U5ERs 0N tH3 f0rum.";
$lang['userexp_9'] = "<b>w0RD f1LtER</b> LEt\$ j00 3di+ y0UR pErs0n4l wOrD F1L+3r.";
$lang['userexp_10'] = "<b>thr3aD sUBSCRIp+i0n\$</b> 4ll0Ws j00 +0 Man49E yoUr ThrE4d su8\$cr1PT1On\$.";
$lang['userdetails'] = "us3r de+4il\$";
$lang['userprofile'] = "uS3R Pr0PHiL3";
$lang['emailandprivacy'] = "ema1L &amp; pr1V4cy";
$lang['editsignature'] = "eD1T s1Gn4TUr3";
$lang['norelationshipssetup'] = "j00 HAve N0 Us3R REl4T10nsh1ps se+ uP. 4dD 4 nEW usEr by SE4rcHinG 8El0w.";
$lang['editwordfilter'] = "eD1+ w0RD pHiltEr";
$lang['userinformation'] = "u5eR InphOrM@+i0n";
$lang['changepassword'] = "cH4Nge p4Ssw0rD";
$lang['currentpasswd'] = "cuRr3nt p@5SW0Rd";
$lang['newpasswd'] = "n3W P@\$Sw0rd";
$lang['confirmpasswd'] = "cOnphIRM P45\$WORd";
$lang['passwdsdonotmatch'] = "p@S\$w0rDs D0 N0+ m@tCH!";
$lang['nicknamerequired'] = "n1ckn@ME 1S r3QU1R3d!";
$lang['emailaddressrequired'] = "em41l 4ddr3s\$ I5 REqUIr3d!";
$lang['logonnotpermitted'] = "l090N no+ PeRmi+tED. Choos3 4no+H3r!";
$lang['nicknamenotpermitted'] = "nICknAmE No+ pErMiTtED. ChoO\$3 4No+HER!";
$lang['emailaddressnotpermitted'] = "eMa1l 4DDr35s n0T P3Rm1++3D. choo\$e @No+h3R!";
$lang['emailaddressalreadyinuse'] = "em@il @DDRE\$S aLr34Dy iN usE. Ch0oSE @n0+HER!";
$lang['relationshipsupdated'] = "reL@+10nshiP\$ UPD4teD!";
$lang['relationshipupdatefailed'] = "r3l4+1On5hIp updAtED F41l3d!";
$lang['preferencesupdated'] = "pr3ferenCEs W3rE suCCESsfUllY UpDa+3D.";
$lang['userdetails'] = "uSER DET41ls";
$lang['memberno'] = "meM83r nO.";
$lang['firstname'] = "f1r5+ N@m3";
$lang['lastname'] = "l@S+ n@M3";
$lang['dateofbirth'] = "d4+3 0Ph 8IRth";
$lang['homepageURL'] = "homep49E url";
$lang['profilepicturedimensions'] = "pR0FIlE p1CTURE (max 95x95Px)";
$lang['avatarpicturedimensions'] = "av4+4R p1C+UrE (mAx 15X15Px)";
$lang['invalidattachmentid'] = "inv@liD 4+T@CHM3NT. CHECK +h4+ 15 h@\$n'+ BEEN D3l3ted.";
$lang['unsupportedimagetype'] = "uN\$UppOr+3D im4g3 4TTAChmENt. j00 C4n onLy Us3 Jp9, g1f AND pN9 Im493 @+t4cHm3N+\$ F0R yoUR @v4t4r and prOpH1L3 piCTUre.";
$lang['selectattachment'] = "seLECT 4TT@CHmEnT";
$lang['pictureURL'] = "piCTur3 urL";
$lang['avatarURL'] = "av4t4r UrL";
$lang['profilepictureconflict'] = "to U5e @n AttacHmEnT F0R YoUr profiLE PiC+Ure Th3 pICTUR3 uRl FiElD MUsT BE 8L4Nk.";
$lang['avatarpictureconflict'] = "to uS3 4n 4TT4chmenT FoR youR 4v@tar p1CtUr3 +Eh 4v@+4r UrL phi3ld mus+ B3 bl4Nk.";
$lang['attachmenttoolargeforprofilepicture'] = "s3L3c+ED @++4CHMEnt I\$ +0o L@r9E Phor PropHile p1C+URE. m4XIMUm DimenSI0n\$ aR3 %s";
$lang['attachmenttoolargeforavatarpicture'] = "seL3cteD @tTacHm3nt 1s tO0 l4RGe FoR 4V4+@R p1c+UrE. M@x1MUm DimEN\$10N\$ 4r3 %s";
$lang['failedtoupdateuserdetails'] = "s0m3 0r 4Ll oph yoUR usEr ACC0unt D3T4il5 CouLD not BE Upd4TED. Pl34se try @g@iN l4+ER.";
$lang['failedtoupdateuserpreferences'] = "soMe 0R 4LL 0ph Y0ur u\$Er prEfER3Nc3s C0ulD not 8e UpD@teD. Pl3@5E +Ry @G@In la+Er.";
$lang['emailaddresschanged'] = "em@1l 4dDREs5 h@\$ bEEN cH4NG3d";
$lang['newconfirmationemailsuccess'] = "y0ur Em4il 4DDRE\$s h4s b33n Ch4n9ED @nD a nEw c0nphirM4+I0N EM41L has 83en s3NT. plE4\$3 ChECk aND RE4D +H3 Em@1L F0r fUrtHEr In5+RUC+I0ns.";
$lang['newconfirmationemailfailure'] = "j00 h4v3 Chan9ed YoUr Em@Il 4DDRES\$, bU+ we wer3 uN4ble +o \$3nD @ c0npH1Rm@+I0N r3qUE\$+. pL34se CONt4c+ +3H f0rum 0Wn3R PhOr ass1S+4NCE.";
$lang['forumoptions'] = "f0RUm op+i0NS";
$lang['notifybyemail'] = "n0T1Fy By 3Ma1l 0pH p0\$+S +0 me";
$lang['notifyofnewpm'] = "nOt1Fy 8Y popup OF N3W pM Mes5493S to ME";
$lang['notifyofnewpmemail'] = "n0+1phy 8Y 3mA1l oph NEW Pm mEss49E\$ +0 m3";
$lang['daylightsaving'] = "aDjus+ f0R d4yl19h+ 54ving";
$lang['autohighinterest'] = "aU+0Mat1C4lly m4RK thRE4ds i pos+ 1n 45 H1GH 1N+3REs+";
$lang['convertimagestolinks'] = "au+OM4TICAlLy C0nVEr+ 3M83DD3d im493s 1N p0S+s in+O l1nK\$";
$lang['thumbnailsforimageattachments'] = "tHum8n@iL\$ phor 1m49e @++4chm3nts";
$lang['smallsized'] = "sM4ll \$1zED";
$lang['mediumsized'] = "m3d1um s1zED";
$lang['largesized'] = "l4rg3 s1z3d";
$lang['globallyignoresigs'] = "gLOb4lLy I9Nor3 User 5IgN@tUR3s";
$lang['allowpersonalmessages'] = "aLl0W OtheR Us3Rs To sEND m3 PERsOn4l m3ss@G3s";
$lang['allowemails'] = "alLow o+h3R UsErs To senD m3 3ma1Ls v14 my pr0ph1l3";
$lang['timezonefromGMT'] = "tim3 zon3";
$lang['postsperpage'] = "pOS+s p3R p49e";
$lang['fontsize'] = "foN+ \$iz3";
$lang['forumstyle'] = "fORUm s+yl3";
$lang['forumemoticons'] = "fOrUm 3MotiC0n\$";
$lang['startpage'] = "sT4r+ p@ge";
$lang['signaturecontainshtmlcode'] = "s1Gn4+URE C0N+@1n\$ hTml CODE";
$lang['savesignatureforuseonallforums'] = "s@V3 sI9n4TuR3 f0r U53 on @LL ph0RUM\$";
$lang['preferredlang'] = "pr3ferr3d l4NgU4G3";
$lang['donotshowmyageordobtoothers'] = "dO No+ shoW mY @g3 0r d@+3 0pH BIr+H +o O+h3rs";
$lang['showonlymyagetoothers'] = "sh0w 0nly my 4G3 +0 otH3r\$";
$lang['showmyageanddobtoothers'] = "show 8otH my @G3 AnD DATE 0f 81rth +0 0th3r\$";
$lang['showonlymydayandmonthofbirthytoothers'] = "sH0w onlY my D4Y 4nd m0ntH of B1R+H +o otH3Rs";
$lang['listmeontheactiveusersdisplay'] = "l1S+ M3 0n tH3 acTivE U\$3rS di5PL4y";
$lang['browseanonymously'] = "br0ws3 phorum @N0nyMoUslY";
$lang['allowfriendstoseemeasonline'] = "bROw\$e @nonymousLy, 8U+ @llow fRi3NDs t0 S3e mE @\$ onl1n3";
$lang['revealspoileronmouseover'] = "r3v34L \$pOIL3rs 0N MousE 0ver";
$lang['showspoilersinlightmode'] = "alW@y\$ \$h0w sp01l3Rs In l19ht m0DE (UsE\$ L1gh+3R f0n+ C0l0uR)";
$lang['resizeimagesandreflowpage'] = "reSiz3 1m4Ge5 4ND R3FL0w p493 tO pR3V3N+ hOR1ZoNt4l sCroll1N9.";
$lang['showforumstats'] = "sh0w f0rum \$+4tS 4T 8o++0M 0Ph MEss493 P4Ne";
$lang['usewordfilter'] = "eN@8le wOrD f1l+ER.";
$lang['forceadminwordfilter'] = "fOrC3 U53 of @dmIn worD fil+3R on 4LL useRs (inC. 9U3s+s)";
$lang['timezone'] = "t1M3 z0n3";
$lang['language'] = "l4n9u@gE";
$lang['emailsettings'] = "eM@il @nD C0N+@CT sEtt1NG\$";
$lang['forumanonymity'] = "fORUM @n0NYm1+Y se+t1NGs";
$lang['birthdayanddateofbirth'] = "bIRTHD4Y @nD da+E 0f 8ir+H D1\$PL@y";
$lang['includeadminfilter'] = "iNcludE @DmIn w0RD pH1l+3r 1n My li\$t.";
$lang['setforallforums'] = "s3+ F0r @Ll F0RUm\$?";
$lang['containsinvalidchars'] = "%s con+@ins 1nV4l1D Ch4R4CTER\$!";
$lang['homepageurlmustincludeschema'] = "hOM3p49e url mu5+ inclUD3 H+tp:// sCh3M4.";
$lang['pictureurlmustincludeschema'] = "pIc+Ur3 urL must 1NClUDE h++p:// \$cheM4.";
$lang['avatarurlmustincludeschema'] = "aV4tar urL Mus+ incLUDe h+Tp:// 5CH3M4.";
$lang['postpage'] = "p0ST p@Ge";
$lang['nohtmltoolbar'] = "nO HtML +O0L8AR";
$lang['displaysimpletoolbar'] = "dI\$pl4y s1MPle h+Ml To0lB4r";
$lang['displaytinymcetoolbar'] = "d1\$PL@y wYsiWyg h+ml +0oLB4R";
$lang['displayemoticonspanel'] = "dI\$pl@y eM0+ic0N\$ p4n3L";
$lang['displaysignature'] = "disPLaY s19N4+ur3";
$lang['disableemoticonsinpostsbydefault'] = "d1s@8lE 3MOtIcon\$ iN M3sS4ges By DEPH@Ul+";
$lang['automaticallyparseurlsbydefault'] = "aUTom@+Ic4llY PaRs3 url\$ 1n m35\$49e5 BY D3f4ul+";
$lang['postinplaintextbydefault'] = "p0sT 1n pL4IN +Ex+ 8Y DEfAulT";
$lang['postinhtmlwithautolinebreaksbydefault'] = "p0\$+ 1n h+Ml W1+H aUtO-linE-BRE4Ks by dEpH@Ult";
$lang['postinhtmlbydefault'] = "p0S+ iN h+Ml By DEpH4ul+";
$lang['privatemessageoptions'] = "pr1V4tE mE\$S493 0PT1ON\$";
$lang['privatemessageexportoptions'] = "pR1vatE mEs\$49E 3xpOrt 0p+10ns";
$lang['savepminsentitems'] = "s@v3 4 c0py oph 3@Ch pM 1 \$3nD in mY 53nt i+3M5 f0LDER";
$lang['includepminreply'] = "incLUDE MEss@GE B0dy wHEN rEPlyiN9 +0 pm";
$lang['autoprunemypmfoldersevery'] = "aU+o prUne mY Pm Ph0LD3R5 3VeRy:";
$lang['friendsonly'] = "fRi3nd5 onlY?";
$lang['globalstyles'] = "gLob4L styl3S";
$lang['forumstyles'] = "f0ruM styl3S";
$lang['youmustenteryourcurrentpasswd'] = "j00 MU\$+ en+3R y0Ur Curr3N+ p45sword";
$lang['youmustenteranewpasswd'] = "j00 musT en+eR @ nEW p@\$SW0RD";
$lang['youmustconfirmyournewpasswd'] = "j00 mu\$t ConfiRM y0ur n3W P@\$SW0rD";
$lang['failedtoupdateuserprofile'] = "f41l3D +0 upD4t3 u\$eR prOpHilE";

// Polls (create_poll.php, poll_results.php) ---------------------------------------------

$lang['mustprovideanswergroups'] = "j00 musT proviDE \$0m3 @NsW3r 9R0Up\$";
$lang['mustprovidepolltype'] = "j00 must pRov1D3 4 p0Ll +yp3";
$lang['mustprovidepollresultsdisplaytype'] = "j00 mUst pr0v1D3 r3sult5 d1sPl4Y +ype";
$lang['mustprovidepollvotetype'] = "j00 MUst prov1D3 4 p0Ll Vote TyPE";
$lang['mustprovidepollguestvotetype'] = "j00 MUst sp3CIphY 1Ph 9U3S+s \$h0UlD BE all0WED +0 V0t3";
$lang['mustprovidepolloptiontype'] = "j00 mu\$t prov1D3 a p0Ll 0P+10N tYpE";
$lang['mustprovidepollchangevotetype'] = "j00 mus+ pr0vIde @ Poll CH4NG3 v0TE Typ3";
$lang['pollquestioncontainsinvalidhtml'] = "on3 0R mOrE oph y0Ur p0ll qu3S+1on\$ c0n+4ins inV@l1D h+ml.";
$lang['pleaseselectfolder'] = "pLea53 \$EL3CT 4 F0lDeR";
$lang['mustspecifyvalues1and2'] = "j00 mu\$t sPeC1PHY V@LuES pHOr 4n\$wEr\$ 1 @ND 2";
$lang['tablepollmusthave2groups'] = "t4bul4r F0rM4+ PolL\$ mUS+ h4v3 pr3cI\$ely +W0 V0+inG 9r0Up\$";
$lang['nomultivotetabulars'] = "t48ul@R phorm4+ polLs CAnn0+ 83 MUlT1-vo+3";
$lang['nomultivotepublic'] = "pU8liC b4lL0+\$ C4nn0t 83 muLt1-v0tE";
$lang['abletochangevote'] = "j00 w1Ll 8e 4ble +0 CH@Ng3 your VotE.";
$lang['abletovotemultiple'] = "j00 wiLl BE a8lE +0 votE MUl+1pl3 t1M3s.";
$lang['notabletochangevote'] = "j00 will N0t b3 4Bl3 +O ch@ng3 yoUr vo+3.";
$lang['pollvotesrandom'] = "nO+e: Poll vote\$ 4r3 r4ndOmLy g3ner@+3d for pr3V1EW 0nlY.";
$lang['pollquestion'] = "pOLL qu35+ion";
$lang['possibleanswers'] = "p0\$si8le @n\$weR\$";
$lang['enterpollquestionexp'] = "en+3R +hE 4n\$W3rs f0r youR p0ll qUE\$t1On.. iF yoUR P0Ll iS 4 &quot;Y3s/n0&quot; QU3st1On, s1mply 3ntEr &quot;y3s&quot; Phor 4nSW3r 1 and &quot;n0&quot; f0R 4n\$W3r 2.";
$lang['numberanswers'] = "no. @nsweR5";
$lang['answerscontainHTML'] = "an5w3Rs CoN+@In htMl (N0T 1nclUD1NG \$1gn@tUre)";
$lang['optionsdisplay'] = "an\$wer\$ D1splAY +yP3";
$lang['optionsdisplayexp'] = "h0W shOULd +3H 4n\$W3RS 8E prEs3Nt3d?";
$lang['dropdown'] = "a\$ DR0p-Down lis+(\$)";
$lang['radios'] = "a\$ 4 \$Eri3S 0pH r@d10 BUt+oN\$";
$lang['votechanging'] = "vote CH@ng1N9";
$lang['votechangingexp'] = "c4N a P3Rs0n ch@Ng3 h1s Or h3R VO+3?";
$lang['guestvoting'] = "guE\$+ VOting";
$lang['guestvotingexp'] = "c4N gU3S+s v0TE in +hI\$ pOLL?";
$lang['allowmultiplevotes'] = "aLlow mUl+iplE V0tEs";
$lang['pollresults'] = "p0Ll r3SUL+s";
$lang['pollresultsexp'] = "how W0uld j00 lik3 +o di5PL4y th3 r3SUL+s 0PH y0uR P0Ll?";
$lang['pollvotetype'] = "p0LL vo+ing TypE";
$lang['pollvotesexp'] = "h0w sHoulD +3h p0lL 8E CoNdUCTED?";
$lang['pollvoteanon'] = "aNonym0UslY";
$lang['pollvotepub'] = "pubLIC 8@ll0+";
$lang['horizgraph'] = "hOr1Zon+@L 9r@pH";
$lang['vertgraph'] = "vERt1C4l GR4ph";
$lang['tablegraph'] = "t48ul4R ph0Rm4t";
$lang['polltypewarning'] = "<b>w@RN1Ng</b>: +h15 i\$ 4 puBlIC 8Allo+. YoUr n4ME will 83 vI\$i8lE n3X+ T0 +3h oPTI0n J00 vO+3 phoR.";
$lang['expiration'] = "eXP1r@T1on";
$lang['showresultswhileopen'] = "d0 J00 w4N+ To \$h0w R3sUL+s whiL3 tH3 p0ll I5 OP3N?";
$lang['whenlikepollclose'] = "wh3n w0uld j00 lIK3 yOur PoLl To 4UT0M@+IC4lly CLos3?";
$lang['oneday'] = "oNE d4y";
$lang['threedays'] = "thREE D@y\$";
$lang['sevendays'] = "sev3n D4ys";
$lang['thirtydays'] = "thir+Y DAys";
$lang['never'] = "neveR";
$lang['polladditionalmessage'] = "addi+i0N@l MEss@Ge (OptIonAl)";
$lang['polladditionalmessageexp'] = "dO J00 want T0 1NCLUD3 @n @Ddi+I0nal p0S+ Af+eR ThE polL?";
$lang['mustspecifypolltoview'] = "j00 mu\$t \$P3Ciphy 4 p0lL +0 v1Ew.";
$lang['pollconfirmclose'] = "ar3 j00 5ure j00 want +0 CLoSE +hE pH0lL0W1n9 Poll?";
$lang['endpoll'] = "enD P0Ll";
$lang['nobodyvotedclosedpoll'] = "no8ODY v0T3d";
$lang['votedisplayopenpoll'] = "%s @nd %s h4VE VoteD.";
$lang['votedisplayclosedpoll'] = "%s 4nd %s v0+3D.";
$lang['nousersvoted'] = "nO us3rs";
$lang['oneuservoted'] = "1 U\$3r";
$lang['xusersvoted'] = "%s us3rs";
$lang['noguestsvoted'] = "nO gu3sTS";
$lang['oneguestvoted'] = "1 9UesT";
$lang['xguestsvoted'] = "%s 9uE5+5";
$lang['pollhasended'] = "p0lL H4S 3Nd3D";
$lang['youvotedforpolloptionsondate'] = "j00 v0t3D pH0R %s On %s";
$lang['thisisapoll'] = "thI5 i\$ @ polL. CliCk +o v1Ew R3suL+s.";
$lang['editpoll'] = "eDi+ poll";
$lang['results'] = "rEsul+\$";
$lang['resultdetails'] = "rE\$ULT D3+@IL\$";
$lang['changevote'] = "ch@nge v0+3";
$lang['pollshavebeendisabled'] = "p0Ll\$ h@ve 8e3N D1\$4bL3D 8y +H3 f0RuM own3R.";
$lang['answertext'] = "aN\$W3R +Ext";
$lang['answergroup'] = "aN\$w3r gr0up";
$lang['previewvotingform'] = "previ3w v0T1n9 pHorm";
$lang['viewbypolloption'] = "v13W 8Y poll op+I0n";
$lang['viewbyuser'] = "view By u\$er";

// Profiles (profile.php) ----------------------------------------------

$lang['editprofile'] = "ed1t prophil3";
$lang['profileupdated'] = "pr0F1l3 upD4+3D.";
$lang['profilesnotsetup'] = "tH3 forum 0wN3R h@\$ n0T s3T UP PRoPh1L3S.";
$lang['ignoreduser'] = "ign0reD u\$3r";
$lang['lastvisit'] = "l@s+ V1si+";
$lang['userslocaltime'] = "uSER'\$ loC4l +1me";
$lang['userstatus'] = "s+4TUS";
$lang['useractive'] = "oNline";
$lang['userinactive'] = "inact1v3 / OfflInE";
$lang['totaltimeinforum'] = "t0+4l Tim3";
$lang['longesttimeinforum'] = "l0N93S+ S3\$\$iON";
$lang['sendemail'] = "senD 3M4il";
$lang['sendpm'] = "s3Nd pM";
$lang['visithomepage'] = "vIsit H0M3p@9E";
$lang['age'] = "age";
$lang['aged'] = "aged";
$lang['birthday'] = "b1R+Hd4Y";
$lang['registered'] = "r3G1S+ered";
$lang['findpostsmadebyuser'] = "fINd p0S+5 m4dE By %s";
$lang['findpostsmadebyme'] = "f1nd P0s+S m4D3 8Y mE";
$lang['profilenotavailable'] = "propHIL3 N0t @v@ILa8L3.";
$lang['userprofileempty'] = "tHiS U\$3r H4\$ noT f1Ll3D in tH3Ir PRoph1lE oR 1t 1\$ 5E+ +0 PRiv4Te.";

// Registration (register.php) -----------------------------------------

$lang['newuserregistrationsarenotpermitted'] = "sOrry, neW U\$ER R39is+R4+1On\$ 4r3 n0+ 4Ll0w3D r1gHT Now. Pl3@5E CHeCK 84Ck La+3r.";
$lang['usernameinvalidchars'] = "u5ern4m3 c4n 0nly c0nt41N A-Z, 0-9, _ - CHar4c+ERS";
$lang['usernametooshort'] = "u5ERN4m3 mu\$+ 8E 4 M1n1MUM 0pH 2 char4ctEr5 loN9";
$lang['usernametoolong'] = "usERn@mE mUs+ 83 4 m@XimUm oph 15 Ch4r4C+Er5 LON9";
$lang['usernamerequired'] = "a lOG0n n4ME 1S rEqUir3D";
$lang['passwdmustnotcontainHTML'] = "p4SsWOrD mUsT n0+ c0NTa1n HTMl +@9S";
$lang['passwordinvalidchars'] = "p@s\$w0rD CAn 0NLY CoN+41n @-z, 0-9, _ - CH4r@C+ER\$";
$lang['passwdtooshort'] = "p4S\$W0rD must BE a m1niMUm 0ph 6 ch@r4cters l0n9";
$lang['passwdrequired'] = "a P@Ssw0RD is r3QU1red";
$lang['confirmationpasswdrequired'] = "a c0nPhIRMaT10N p4SSw0RD is r3qU1R3d";
$lang['nicknamerequired'] = "a n1Ckn@me is r3Qu1r3D";
$lang['emailrequired'] = "aN 3m4il @dDrEss Is reqUIrED";
$lang['passwdsdonotmatch'] = "p4\$Sw0Rd5 d0 no+ m4+cH";
$lang['usernamesameaspasswd'] = "uSErn@M3 4nD p@ssw0RD musT 83 DiPHphER3nt";
$lang['usernameexists'] = "sOrry, 4 u\$er w1+h +h4T nAM3 4lr3@DY 3xI\$+\$";
$lang['successfullycreateduseraccount'] = "sUcCesspHully cr34+ED UsEr aCC0unt";
$lang['useraccountcreatedconfirmfailed'] = "yOUR U\$3r 4CCOuNt H@\$ b33n CR34+3D 8u+ +3H r3qU1r3d COnPhirm4+10n 3M41l w4\$ NO+ 53nt. pl34\$E C0n+4ct +h3 ForUm 0wN3R To rECT1phy thI\$. 1N th1S m34n+Im3 pl34se CLiCK Teh c0nt1NuE 8U+t0N To l091n 1n.";
$lang['useraccountcreatedconfirmsuccess'] = "your u53r @CCOunT hAs B33n CRE4+ED BU+ BEFoRe J00 C4N \$+@r+ PosT1nG j00 mU\$+ c0NPH1rm yOUr EM@il 4dDRE\$S. pl3453 CHECk y0ur 3mA1l f0R 4 liNk th@+ W1Ll aLloW j00 To CONPhIrM y0uR @dDRE\$S.";
$lang['useraccountcreated'] = "your Us3r @CC0unt H4\$ BEEN CRE4tED sUCCEs\$FUlLy! ClICK teh CoN+1nuE 8utton B3l0w to Login";
$lang['errorcreatinguserrecord'] = "eRRor cR3@+inG us3r reCoRD";
$lang['userregistration'] = "uS3R reg1\$TR4t10N";
$lang['registrationinformationrequired'] = "r3G1\$+r4T10N 1nPh0rm4tioN (r3QUir3D)";
$lang['profileinformationoptional'] = "prOPhil3 INph0rM4+i0N (optioN@L)";
$lang['preferencesoptional'] = "pRef3r3Nc3s (0P+i0Nal)";
$lang['register'] = "reGIstER";
$lang['rememberpasswd'] = "r3MEM8Er Passw0rD";
$lang['birthdayrequired'] = "y0UR Da+E 0F B1R+h 1S r3QUir3d OR 1\$ inV4LID";
$lang['alwaysnotifymeofrepliestome'] = "nOt1fy on repLy +o M3";
$lang['notifyonnewprivatemessage'] = "n0t1fy on NEW Pr1V@+e m3Ss49E";
$lang['popuponnewprivatemessage'] = "pOp up on nEw pr1V4+3 ME\$s4g3";
$lang['automatichighinterestonpost'] = "aut0m4+iC H1gh inTer3ST 0N P0\$+";
$lang['confirmpassword'] = "conpHIRm p45\$W0rd";
$lang['invalidemailaddressformat'] = "iNv4liD Em4IL 4DDr3ss f0Rm4t";
$lang['moreoptionsavailable'] = "mOre Pr0f1lE 4nd pREfER3nC3 0pTi0n5 ar3 4V@iL48le 0Nc3 j00 re915+eR";
$lang['textcaptchaconfirmation'] = "c0NfiRm@+i0n";
$lang['textcaptchaexplain'] = "to TEh R19h+ i5 A TExt-C4P+Ch4 im4G3. pLe4S3 typE tHE C0d3 J00 C4N s3E In +3h iM49e In+o +he 1npU+ FiEld 8EL0w 1+.";
$lang['textcaptchaimgtip'] = "tH1s i\$ @ C@p+CHa-piCtUr3. i+ 1s U\$Ed +O PR3VENt 4ut0m4+IC r39is+r@Ti0N";
$lang['textcaptchamissingkey'] = "a c0nphiRm@+i0N CODe is REqU1R3D.";
$lang['textcaptchaverificationfailed'] = "t3Xt-C@p+ch4 V3rifiC4+1on COD3 w45 inCOrR3CT. pl34\$3 r3-En+3R I+.";
$lang['forumrules'] = "forum rUl3s";
$lang['forumrulesnotification'] = "iN ordeR T0 pr0cEED, J00 mU\$+ @gr33 with +Eh pH0Ll0w1n9 Rul3s";
$lang['forumrulescheckbox'] = "i h4vE r34d, @ND @9R3E +0 4B1d3 BY +he PhoRuM rul3S.";
$lang['youmustagreetotheforumrules'] = "j00 mu\$T 49reE +0 THE PH0RUm Rule5 b3F0r3 j00 cAn Con+inUE.";

// Recent visitors list  (visitor_log.php) -----------------------------

$lang['member'] = "m3MBEr";
$lang['searchforusernotinlist'] = "sE4RCH f0R 4 u\$3r n0T 1n l1\$+";
$lang['yoursearchdidnotreturnanymatches'] = "y0uR sE4RCh DID N0T r3+uRn 4Ny m@+CH3S. Try s1mplify1n9 YOUR \$e4rCH P4RaM3TEr5 @nD +rY 4941n.";
$lang['hiderowswithemptyornullvalues'] = "h1D3 r0WS wi+h EMP+Y 0R NULl v@LUES In \$el3CT3D c0luMns";
$lang['showregisteredusersonly'] = "sH0w r391s+3reD user\$ 0nlY (h1d3 gu3s+S)";

// Relationships (user_rel.php) ----------------------------------------

$lang['relationships'] = "r3L@t1ON\$h1ps";
$lang['userrelationship'] = "u5eR rEl4TIonsh1P";
$lang['userrelationships'] = "u\$3R r3l4T10NSh1P\$";
$lang['failedtoremoveselectedrelationships'] = "f41leD to rem0V3 \$EL3c+3D rEL4T10n\$HIp";
$lang['friends'] = "fRi3nds";
$lang['ignoredcompletely'] = "iGnorED C0mpL3TELy";
$lang['relationship'] = "r3l4tion\$H1P";
$lang['restorenickname'] = "rEst0rE U5er'S NiCkN4Me";
$lang['friend_exp'] = "uSer'\$ P0\$+S m4rKED W1+H 4 &quot;phRIEND&quot; 1con.";
$lang['normal_exp'] = "u\$3R'\$ P0sTS 4Pp34r as N0rm4L.";
$lang['ignore_exp'] = "uSer'\$ posTS @r3 HIDDen.";
$lang['ignore_completely_exp'] = "thRE4Ds 4ND p0ST5 tO oR fr0M usEr Will @pp34R deL3TED.";
$lang['display'] = "d1\$PL@y";
$lang['displaysig_exp'] = "us3r'\$ Si9n4TuR3 Is DIspl4yED 0n +HE1r pos+\$.";
$lang['hidesig_exp'] = "u5er'5 \$IGN@tUrE I\$ HIDDEN 0N thEiR posTs.";
$lang['cannotignoremod'] = "j00 C4NN0+ 1gN0Re +h1S us3r, @\$ +heY 4r3 4 modEr4+0r.";
$lang['previewsignature'] = "prEviEw sI9n4+Ur3";

// Search (search.php) -------------------------------------------------

$lang['searchresults'] = "s3@Rch r3\$uLTS";
$lang['usernamenotfound'] = "t3H us3RN4M3 J00 5PECIfI3D 1N tEh +o or PhRoM FIEld was N0T FouND.";
$lang['notexttosearchfor'] = "one 0r all Of y0UR s34rch k3ywOrD\$ W3r3 1nv@L1D. \$3arCh k3YWOrds Must 8e n0 Sh0r+ER +h4N %d Ch4r4C+ERs, n0 l0N93R +h@N %d cH4r4C+eR\$ 4nD mu\$+ no+ 4ppe4r In th3 %s";
$lang['keywordscontainingerrors'] = "keYw0Rd5 CON+41n1ng 3Rrors: %s";
$lang['mysqlstopwordlist'] = "mY\$Ql s+oPwoRd Lis+";
$lang['foundzeromatches'] = "found: 0 m@+CH3s";
$lang['found'] = "founD";
$lang['matches'] = "maTCHEs";
$lang['prevpage'] = "pr3v1ous p4GE";
$lang['findmore'] = "fiND M0r3";
$lang['searchmessages'] = "sE4rch mEss@GE\$";
$lang['searchdiscussions'] = "s3@rCH DisCUs\$1on\$";
$lang['find'] = "f1nd";
$lang['additionalcriteria'] = "adDI+i0n@l cr1+ERI4";
$lang['searchbyuser'] = "s3arch 8y Us3R (0P+10nal)";
$lang['folderbrackets_s'] = "f0LD3R(\$)";
$lang['postedfrom'] = "p0\$tED from";
$lang['postedto'] = "p0S+3D +0";
$lang['today'] = "tOd4Y";
$lang['yesterday'] = "ye\$+erd@y";
$lang['daybeforeyesterday'] = "d4y bePhoRE Y3s+3rd4Y";
$lang['weekago'] = "%s WEEK 490";
$lang['weeksago'] = "%s w3eks @g0";
$lang['monthago'] = "%s mon+H a9o";
$lang['monthsago'] = "%s M0n+hs 490";
$lang['yearago'] = "%s Y3@R 4g0";
$lang['beginningoftime'] = "beGiNn1ng oPh +1mE";
$lang['now'] = "nOw";
$lang['lastpostdate'] = "l4\$+ p0st D4+E";
$lang['numberofreplies'] = "nuMBEr 0PH RepL1es";
$lang['foldername'] = "fOlder n4Me";
$lang['authorname'] = "authOR N4mE";
$lang['decendingorder'] = "nEw3S+ ph1R\$T";
$lang['ascendingorder'] = "oLD3st phirst";
$lang['keywords'] = "k3ywORDs";
$lang['sortby'] = "sOR+ by";
$lang['sortdir'] = "sOrt Dir";
$lang['sortresults'] = "s0RT resul+\$";
$lang['groupbythread'] = "group by +hR3aD";
$lang['postsfromuser'] = "p0St5 Phr0m us3r";
$lang['poststouser'] = "poS+s +0 User";
$lang['poststoandfromuser'] = "p05+\$ +o @nd fR0M UsEr";
$lang['searchfrequencyerror'] = "j00 C4n 0Nly \$e4rCH oncE 3v3rY %s seCoNDs. Ple4\$3 try 4g4in L4+Er.";
$lang['searchsuccessfullycompleted'] = "sEARCh sUCCE5\$phUlLy C0mpl3tED. %s";
$lang['clickheretoviewresults'] = "clICk hER3 +o v13w R3sUl+s.";

// Search Popup (search_popup.php) -------------------------------------

$lang['select'] = "s3L3C+";
$lang['searchforthread'] = "sE4rCH phor ThR3@D";
$lang['mustspecifytypeofsearch'] = "j00 mUst \$P3c1FY +ypE 0Ph s3@rCH +0 P3Rf0rm";
$lang['unkownsearchtypespecified'] = "uNKN0wN \$3Arch typ3 sp3cif1ED";
$lang['mustentersomethingtosearchfor'] = "j00 mu5t 3nt3r sOmethInG tO se4rch pHor";

// Start page (start_left.php) -----------------------------------------

$lang['recentthreads'] = "rec3n+ +hre@Ds";
$lang['startreading'] = "s+ARt re4dING";
$lang['threadoptions'] = "tHrE4d 0pT1ons";
$lang['editthreadoptions'] = "eDiT +hr3@D 0pT10n5";
$lang['morevisitors'] = "m0re VisiT0rs";
$lang['forthcomingbirthdays'] = "fOr+hc0MIN9 81R+hD@ys";

// Start page (start_main.php) -----------------------------------------

$lang['editstartpage_help'] = "j00 C4n eDiT +h1\$ PA93 phR0M ThE 4dmin 1NTerpH@CE";
$lang['uploadstartpage'] = "uPloaD s+4R+ p493 (%s)";
$lang['invalidfiletypeerror'] = "fIl3 typ3 n0T SUpP0R+3d. j00 Can 0nLy use %s phil3S @s yoUr s+4RT p@G3.";

// Thread navigation (thread_list.php) ---------------------------------

$lang['newdiscussion'] = "n3w DisCU5si0N";
$lang['createpoll'] = "cr34+E poll";
$lang['search'] = "se4rCH";
$lang['searchagain'] = "sEARCH 4G4IN";
$lang['alldiscussions'] = "alL Di\$CUs\$1ons";
$lang['unreaddiscussions'] = "uNR34d d1\$Cus510NS";
$lang['unreadtome'] = "unr3aD &quot;+o: ME&quot;";
$lang['todaysdiscussions'] = "tod4y's di5CUssions";
$lang['2daysback'] = "2 d@Y\$ B@CK";
$lang['7daysback'] = "7 d@ys 84Ck";
$lang['highinterest'] = "hI9H in+eR3s+";
$lang['unreadhighinterest'] = "uNreaD h19h iNter3S+";
$lang['iverecentlyseen'] = "i'V3 REC3ntLy s33N";
$lang['iveignored'] = "i'V3 1gn0RED";
$lang['byignoredusers'] = "bY 19NoRED U\$3r\$";
$lang['ivesubscribedto'] = "i'V3 sU8sCr1B3d +0";
$lang['startedbyfriend'] = "st4rt3d By phri3ND";
$lang['unreadstartedbyfriend'] = "unRE4d 5tD 8Y phRi3ND";
$lang['startedbyme'] = "sT@r+eD BY m3";
$lang['unreadtoday'] = "uNr3AD +OD@y";
$lang['deletedthreads'] = "d3L3t3D thR3ad\$";
$lang['goexcmark'] = "g0!";
$lang['folderinterest'] = "foldER In+3rEsT";
$lang['postnew'] = "p0\$T new";
$lang['currentthread'] = "cUrRen+ +hr34D";
$lang['highinterest'] = "hi9H 1n+er3ST";
$lang['markasread'] = "m4Rk 4S r3@D";
$lang['next50discussions'] = "n3xt 50 Di5cUs\$I0n\$";
$lang['visiblediscussions'] = "v1\$1Ble D1sCUss1ON\$";
$lang['selectedfolder'] = "sEl3ctED F0LD3R";
$lang['navigate'] = "n4V19@+e";
$lang['couldnotretrievefolderinformation'] = "tHere @r3 N0 f0LD3r\$ 4v41L@8le.";
$lang['nomessagesinthiscategory'] = "no mess4G3\$ 1N thI\$ c@tEGory. pLe453 \$el3CT 4N0ther, Or %s PH0r 4Ll thr3@DS";
$lang['clickhere'] = "cLick hEr3";
$lang['prev50threads'] = "pRev10us 50 tHr34d\$";
$lang['next50threads'] = "n3x+ 50 +hr34ds";
$lang['nextxthreads'] = "n3xt %s +hr34D\$";
$lang['threadstartedbytooltip'] = "tHREAd #%s \$t4r+3D BY %s. viEW3d %s";
$lang['threadviewedonetime'] = "1 t1M3";
$lang['threadviewedtimes'] = "%d Tim3S";
$lang['unreadthread'] = "uNre4D tHrE4D";
$lang['readthread'] = "rE@D +Hr34D";
$lang['unreadmessages'] = "uNre4D mes\$49ES";
$lang['subscribed'] = "su8\$cR18ED";
$lang['ignorethisfolder'] = "i9NoR3 th1\$ foldeR";
$lang['stopignoringthisfolder'] = "st0p i9n0R1ng +HIs pHoLDER";
$lang['stickythreads'] = "st1Cky +hr3ads";
$lang['mostunreadposts'] = "m0s+ UNr34D P05+\$";
$lang['onenew'] = "%d NEW";
$lang['manynew'] = "%d n3w";
$lang['onenewoflength'] = "%d N3w 0f %d";
$lang['manynewoflength'] = "%d NEW 0f %d";
$lang['ignorefolderconfirm'] = "are j00 \$UR3 j00 w@n+ +0 19n0RE th1\$ pholD3r?";
$lang['unignorefolderconfirm'] = "aRe j00 SURE j00 w@n+ +0 st0P igNor1Ng Th1s PholDEr?";
$lang['confirmmarkasread'] = "ar3 j00 sURE j00 w4n+ t0 M@rK TEh \$eL3C+3D +hRe4ds @5 rE4d?";
$lang['successfullymarkreadselectedthreads'] = "sUcC3\$sfULly m@rKED \$3leCTED +HreaD\$ 4s r34d";
$lang['failedtomarkselectedthreadsasread'] = "fA1l3D t0 Mark \$3L3C+eD +hrE4ds 45 r3@D";
$lang['gotofirstpostinthread'] = "go to ph1rs+ POst 1N +hr34D";
$lang['gotolastpostinthread'] = "go +0 lAst Pos+ 1n +hreaD";
$lang['viewmessagesinthisfolderonly'] = "v13w mE5\$@Ges iN thI\$ PHolDEr oNly";
$lang['shownext50threads'] = "shOw n3x+ 50 thr3@D\$";
$lang['showprev50threads'] = "sh0W prEv10us 50 +hr34d5";
$lang['createnewdiscussioninthisfolder'] = "cRe4TE n3w D1\$CU\$SIoN iN +Hi\$ F0lDEr";
$lang['nomessages'] = "nO me\$S4G3s";

// HTML toolbar (htmltools.inc.php) ------------------------------------
$lang['bold'] = "b0LD";
$lang['italic'] = "i+4lIc";
$lang['underline'] = "und3RliN3";
$lang['strikethrough'] = "s+RikeTHr0U9h";
$lang['superscript'] = "sUPER\$criP+";
$lang['subscript'] = "su8\$Cript";
$lang['leftalign'] = "leph+-4liGn";
$lang['center'] = "ceN+3r";
$lang['rightalign'] = "ri9h+-4Lign";
$lang['numberedlist'] = "nuM83R3D L1St";
$lang['list'] = "lI\$+";
$lang['indenttext'] = "iNdEn+ TexT";
$lang['code'] = "codE";
$lang['quote'] = "qU0+3";
$lang['spoiler'] = "sPO1l3r";
$lang['horizontalrule'] = "h0rIZ0n+@l RuLe";
$lang['image'] = "iMa93";
$lang['hyperlink'] = "hyPERl1NK";
$lang['noemoticons'] = "di\$4bl3 emotiC0n\$";
$lang['fontface'] = "f0n+ ph4C3";
$lang['size'] = "siZ3";
$lang['colour'] = "c0L0ur";
$lang['red'] = "r3d";
$lang['orange'] = "oR4n93";
$lang['yellow'] = "y3lloW";
$lang['green'] = "gRe3n";
$lang['blue'] = "bLue";
$lang['indigo'] = "ind19O";
$lang['violet'] = "vIol3+";
$lang['white'] = "wh1+e";
$lang['black'] = "bl@CK";
$lang['grey'] = "gREy";
$lang['pink'] = "p1NK";
$lang['lightgreen'] = "l19HT gRe3N";
$lang['lightblue'] = "l19H+ 8LuE";

// Forum Stats (messages.inc.php - messages_forum_stats()) -------------

$lang['forumstats'] = "forUM S+@+S";
$lang['usersactiveinthepasttimeperiod'] = "%s 4C+Iv3 in t3h P@S+ %s.";

$lang['numactiveguests'] = "<b>%s</b> gu3\$tS";
$lang['oneactiveguest'] = "<b>1</b> gUESt";
$lang['numactivemembers'] = "<b>%s</b> memb3r5";
$lang['oneactivemember'] = "<b>1</b> m3m8Er";
$lang['numactiveanonymousmembers'] = "<b>%s</b> an0NYm0US M3mb3RS";
$lang['oneactiveanonymousmember'] = "<b>1</b> @n0NYM0u\$ M3mbER";

$lang['numthreadscreated'] = "<b>%s</b> THR3@ds";
$lang['onethreadcreated'] = "<b>1</b> THR3@d";
$lang['numpostscreated'] = "<b>%s</b> POS+s";
$lang['onepostcreated'] = "<b>1</b> P0St";

$lang['younormal'] = "j00";
$lang['youinvisible'] = "j00 (1nvI\$18l3)";
$lang['viewcompletelist'] = "v1Ew ComPl3TE l1S+";
$lang['ourmembershavemadeatotalofnumthreadsandnumposts'] = "ouR m3MB3r5 H@V3 m@D3 4 tOt@L of %s @ND %s.";
$lang['longestthreadisthreadnamewithnumposts'] = "loNgE\$+ +hre4D I\$ <b>%s</b> wI+H %s.";
$lang['therehavebeenxpostsmadeinthelastsixtyminutes'] = "th3re h4Ve 8EEN <b>%s</b> pOSts maD3 iN +he Las+ 60 M1nu+3S.";
$lang['therehasbeenonepostmadeinthelastsxityminutes'] = "tHER3 h4\$ b3EN <b>1</b> PO5+ m4DE 1n T3h l@st 60 minUtEs.";
$lang['mostpostsevermadeinasinglesixtyminuteperiodwasnumposts'] = "mO\$T po\$TS 3VeR m4D3 In @ s1n9Le 60 miNu+3 p3RioD 1\$ <b>%s</b> oN %s.";
$lang['wehavenumregisteredmembersandthenewestmemberismembername'] = "we H4VE <b>%s</b> REgis+3reD M3MB3rs @nd TeH NEw3S+ mEm8ER i\$ <b>%s</b>.";
$lang['wehavenumregisteredmember'] = "wE h4ve %s re9is+3rED m3Mb3r5.";
$lang['wehaveoneregisteredmember'] = "wE H@vE oN3 R39i\$+eR3D M3MB3r.";
$lang['mostuserseveronlinewasnumondate'] = "mo5+ user\$ 3ver 0nlIne w@\$ <b>%s</b> On %s.";
$lang['statsdisplayenabled'] = "s+@+\$ DisPlay 3N4bl3d";

// Thread Options (thread_options.php) ---------------------------------

$lang['updatessavedsuccessfully'] = "upd4+e\$ 54V3D \$UCcEssphulLy";
$lang['useroptions'] = "u\$er op+ioN\$";
$lang['markedasread'] = "m4rk3D @\$ REaD";
$lang['postsoutof'] = "poStS oU+ oph";
$lang['interest'] = "in+er3st";
$lang['closedforposting'] = "cLOSED phor po\$t1n9";
$lang['locktitleandfolder'] = "lOCK t1tl3 and PhoLDEr";
$lang['deletepostsinthreadbyuser'] = "d3l3+3 P0stS In +hR34d 8y u53r";
$lang['deletethread'] = "d3LET3 Thr34D";
$lang['permenantlydelete'] = "p3rM4N3ntly DElE+e";
$lang['movetodeleteditems'] = "moV3 +O DEL3+3d +hr3ADs";
$lang['undeletethread'] = "und3lEtE +hR34D";
$lang['threaddeletedpermenantly'] = "thR34d DEl3ted PErm@nEN+ly. C@Nn0+ und3le+E.";
$lang['markasunread'] = "m4rK 4S Unr3AD";
$lang['makethreadsticky'] = "m4K3 +Hre4D 5+1CKY";
$lang['threareadstatusupdated'] = "tHre4d RE4d S+4tus UpD4t3D sUCCESspHulLy";
$lang['interestupdated'] = "thR3@d inTEr3\$+ s+@+us upD4ted suCcessfULlY";
$lang['failedtoupdatethreadreadstatus'] = "f4IlEd T0 Upd4+3 thr34D re4d sT@Tu\$";
$lang['failedtoupdatethreadinterest'] = "f@Il3D +O uPD4Te thr3AD in+3R3St";
$lang['failedtorenamethread'] = "fA1led To rEn4M3 +hr34D";
$lang['failedtomovethread'] = "f41l3D +o m0V3 +Hr3aD +0 sP3cIfied PhOlDEr";
$lang['failedtoupdatethreadstickystatus'] = "f4IL3D T0 upD4TE ThrE4d s+1CKy st@tU\$";
$lang['failedtoupdatethreadclosedstatus'] = "fA1led +o upd@+E +hrE4D Cl0\$3D s+4tus";
$lang['failedtoupdatethreadlockstatus'] = "f41lEd +0 upD4+e +hr3@d lOck s+@+us";
$lang['failedtodeletepostsbyuser'] = "f4il3d +0 DEL3te post5 8Y sEl3CTEd user";
$lang['failedtodeletethread'] = "f4il3D +o D3LETE +hr34D.";
$lang['failedtoundeletethread'] = "f@1L3d +0 un-d3L3+3 +hre4d";

// Dictionary (dictionary.php) -----------------------------------------

$lang['dictionary'] = "dic+1on@rY";
$lang['spellcheck'] = "sp3Ll ch3CK";
$lang['notindictionary'] = "no+ IN dICt10n@rY";
$lang['changeto'] = "cH@nge +0";
$lang['restartspellcheck'] = "r3St4r+";
$lang['cancelchanges'] = "caNC3L CH@N9Es";
$lang['initialisingdotdotdot'] = "iN1tI@l1SInG...";
$lang['spellcheckcomplete'] = "spELl CH3ck 1S C0mpl3+3. To rE\$+4Rt \$P3ll Ch3cK Cl1ck r3st4r+ 8Ut+on BELow.";
$lang['spellcheck'] = "sPelL CHECk";
$lang['noformobj'] = "nO ph0Rm 0Bj3C+ \$peCipHI3D pH0R REtURn texT";
$lang['bodytext'] = "body +3xt";
$lang['ignore'] = "i9Nore";
$lang['ignoreall'] = "ignore 4Ll";
$lang['change'] = "cH@N93";
$lang['changeall'] = "cH@ngE @ll";
$lang['add'] = "aDD";
$lang['suggest'] = "sUg9est";
$lang['nosuggestions'] = "(NO sUg93stioNs)";
$lang['cancel'] = "cANcel";
$lang['dictionarynotinstalled'] = "n0 DICtIon4Ry h@5 B33N 1N\$+4llED. pl34\$E C0nt4CT TEh pHorUM 0wNER +o r3meDY +h1s.";

// Permissions keys ----------------------------------------------------

$lang['postreadingallowed'] = "pO\$+ r34D1ng 4lLow3D";
$lang['postcreationallowed'] = "pO5+ CR3@+Ion 4lL0w3D";
$lang['threadcreationallowed'] = "tHr3aD Cr3at1on @ll0WED";
$lang['posteditingallowed'] = "p0St eDI+1ng @ll0W3D";
$lang['postdeletionallowed'] = "p0S+ d3LEt1on 4llow3D";
$lang['attachmentsallowed'] = "a++@chmEnTs 4llowed";
$lang['htmlpostingallowed'] = "html po5+1n9 4lloW3D";
$lang['signatureallowed'] = "s1Gn@+Ure 4LLOWed";
$lang['guestaccessallowed'] = "gUes+ 4cc3S\$ @lL0W3D";
$lang['postapprovalrequired'] = "p0S+ @pprov@L REQuir3D";

// RSS feeds gubbins

$lang['rssfeed'] = "rSS fE3D";
$lang['every30mins'] = "eVEry 30 minUt3s";
$lang['onceanhour'] = "once 4N h0Ur";
$lang['every6hours'] = "every 6 h0URs";
$lang['every12hours'] = "eV3RY 12 hour\$";
$lang['onceaday'] = "oNC3 4 d4Y";
$lang['rssfeeds'] = "rss f33dS";
$lang['feedname'] = "fE3d n4Me";
$lang['feedfoldername'] = "f33D f0lDER name";
$lang['feedlocation'] = "f3eD l0c4+i0N";
$lang['threadtitleprefix'] = "thr34D +1+lE pr3phIx";
$lang['feednameandlocation'] = "fE3D nam3 4nd L0C4+1ON";
$lang['feedsettings'] = "fe3d sEtT1nGs";
$lang['updatefrequency'] = "upd4+3 fr3Qu3ncy";
$lang['rssclicktoreadarticle'] = "cL1ck herE +0 R34D tH1\$ 4RT1CL3";
$lang['addnewfeed'] = "adD New Ph3ED";
$lang['editfeed'] = "eD1t fe3d";
$lang['feeduseraccount'] = "fe3d User aCC0UnT";
$lang['noexistingfeeds'] = "n0 exis+1ng rss PhE3ds pHounD. +0 4dD @ Ph3ED CLiCk +3H '@dD nEW' Bu++oN b3low";
$lang['rssfeedhelp'] = "heR3 j00 C@n setUP s0M3 rss PHE3d5 pH0r @U+om@T1c pRop@G@+i0n 1n+0 Y0ur pHOrUM. th3 i+3Ms FR0m tEH Rss f3eds J00 4dD wILl 8E CRE4t3d @s +Hre4d\$ which usER\$ c4n rEPly +O 4\$ ipH +h3y w3r3 n0rm@l P0\$+s. TH3 Rs\$ PH3ed mUsT 8E @Cc3ss18L3 V14 HTTp oR 1+ will Not Work.";
$lang['mustspecifyrssfeedname'] = "mu5t speC1Fy Rs\$ ph3ED n@m3";
$lang['mustspecifyrssfeeduseraccount'] = "musT sp3cify rs\$ PH3ED US3r 4cC0unt";
$lang['mustspecifyrssfeedfolder'] = "musT \$p3Cify rsS Ph3ed phOlD3R";
$lang['mustspecifyrssfeedurl'] = "mu\$+ SpeciPhY Rss f33D url";
$lang['mustspecifyrssfeedupdatefrequency'] = "muS+ 5p3CiFy rss f3ED UPD4T3 Fr3quEnCY";
$lang['unknownrssuseraccount'] = "uNkN0wn r5S us3r 4CCOUn+";
$lang['rssfeedsupportshttpurlsonly'] = "r\$\$ PhE3d \$UpPor+s http UrL\$ oNLY. \$eCUr3 f3EDs (h++Ps://) @r3 n0T 5uppoRtED.";
$lang['rssfeedurlformatinvalid'] = "r5\$ fEED URl f0rM@+ 1s INV@l1d. URl mUs+ inCLUde \$ch3me (E.g. h+tp://) 4nd @ Ho\$+N@mE (e.g. Www.Ho\$+n4m3.COm).";
$lang['rssfeeduserauthentication'] = "r5S fEED DO3s N0T suPp0Rt hTtp User aU+h3NT1c4+I0n";
$lang['successfullyremovedselectedfeeds'] = "sucC3\$SFUlLy rEm0v3D 53l3c+3d f3EDs";
$lang['successfullyaddedfeed'] = "sUCcE\$\$FULLy @DDED NEW ph3ED";
$lang['successfullyeditedfeed'] = "succE5sFuLlY EDITeD FE3d";
$lang['failedtoremovefeeds'] = "f@1L3d +0 R3moV3 \$0mE 0R @Ll 0f thE 5eL3C+3D f3ED5";
$lang['failedtoaddnewrssfeed'] = "f4IL3D +O @DD n3w RS\$ ph3ED";
$lang['failedtoupdaterssfeed'] = "f4ilED To upD4+3 R\$S Ph3ed";
$lang['rssstreamworkingcorrectly'] = "rsS s+rE4M 4PpE4RS +0 8E w0rk1Ng C0rreCTLy";
$lang['rssstreamnotworkingcorrectly'] = "r\$\$ \$+r34M W4s 3mpty or CoUlD N0+ BE F0UND";
$lang['invalidfeedidorfeednotfound'] = "iNv@L1d phe3D ID oR fE3D N0T F0Und";

// PM Export Options

$lang['pmexportastype'] = "eXpORt 4S +yPE";
$lang['pmexporthtml'] = "hTml";
$lang['pmexportxml'] = "xml";
$lang['pmexportplaintext'] = "pl4in +3xt";
$lang['pmexportmessagesas'] = "exPoR+ m3S\$49Es aS";
$lang['pmexportonefileforallmessages'] = "oNe pH1lE F0R 4ll m3s\$49e5";
$lang['pmexportonefilepermessage'] = "oN3 Ph1l3 p3R m3ss49e";
$lang['pmexportattachments'] = "eXp0rt @T+4ChmEnts";
$lang['pmexportincludestyle'] = "iNclUd3 pHORum \$+yle sh3Et";
$lang['pmexportwordfilter'] = "aPpLY w0Rd Fil+3r +0 mEss49es";

// Thread merge / split options

$lang['threadhasbeensplit'] = "tHr3@d h4s BE3N spLi+";
$lang['threadhasbeenmerged'] = "tHr3@D h4s 8EEn M3r93d";
$lang['mergesplitthread'] = "m3rg3 / 5pLit +hr34D";
$lang['mergewiththreadid'] = "m3r9e witH +hr3AD ID:";
$lang['postsinthisthreadatstart'] = "p0S+s in +hI\$ +hR34d @t \$t4rt";
$lang['postsinthisthreadatend'] = "pOST5 IN +hIs +hRE4D At 3Nd";
$lang['reorderpostsintodateorder'] = "re-oRD3r po5T\$ in+o D@+3 0RDeR";
$lang['splitthreadatpost'] = "spL1t thrE4D a+ Po\$+:";
$lang['selectedpostsandrepliesonly'] = "s3l3C+ed P05+ 4nD R3pliE5 onlY";
$lang['selectedandallfollowingposts'] = "s3L3c+eD 4ND 4ll pHoll0W1ng p0sts";

$lang['threadmovedhere'] = "heR3";

$lang['thisthreadhasmoved'] = "<b>threads MeRg3D:</b> TH1\$ +hRE4d h4\$ moV3D %s";
$lang['thisthreadwasmergedfrom'] = "<b>thRE4D5 m3R9eD:</b> +H1S thrE4D w4\$ M3rGed phRom %s";
$lang['somepostsinthisthreadhavebeenmoved'] = "<b>thre@d 5pl1t:</b> S0m3 po\$+S in Th1s tHrE4d H4vE 8EEn m0ved %s";
$lang['somepostsinthisthreadweremovedfrom'] = "<b>tHre4d \$PL1+:</b> \$0m3 po5+5 iN tH1s +hREaD W3R3 m0VEd frOm %s";

$lang['thisposthasbeenmoved'] = "<b>thr3@d splI+:</b> TH1\$ p05+ H4\$ BE3n moVEd %s";

$lang['invalidfunctionarguments'] = "iNV4liD phUnCt10N 4r9um3nts";
$lang['couldnotretrieveforumdata'] = "c0UlD no+ REtrI3vE ph0RUM D4+4";
$lang['cannotmergepolls'] = "onE 0R morE +Hr34ds Is 4 polL. J00 C4nn0T mERg3 polLs";
$lang['couldnotretrievethreaddatamerge'] = "could no+ rETrIev3 THRe4d D4+@ FroM 0n3 0r mOr3 +hr34D5";
$lang['couldnotretrievethreaddatasplit'] = "c0ULD n0t r3+rIEvE +hREad D@+@ Fr0m s0urC3 tHRE@D";
$lang['couldnotretrievepostdatamerge'] = "cOUlD not retr13v3 p0S+ D@t4 fr0M 0n3 0R m0re +hr34d\$";
$lang['couldnotretrievepostdatasplit'] = "c0ulD not rE+Ri3VE p0S+ D@+4 FroM source +Hr34d";
$lang['failedtocreatenewthreadformerge'] = "f4IL3d +0 Cr3a+e N3w ThrE4d for m3R93";
$lang['failedtocreatenewthreadforsplit'] = "f41l3d to CrE4+3 new +Hr34d pHor sPl1+";

// Thread subscriptions

$lang['threadsubscriptions'] = "thR3ad suBSCr1P+i0N\$";
$lang['couldnotupdateinterestonthread'] = "couLD n0t UPD4+3 1nTEr3sT 0N thRE@D '%s'";
$lang['threadinterestsupdatedsuccessfully'] = "tHre4D 1NTEr3s+s UpD4TEd sucCEsspHulLy";
$lang['nothreadsubscriptions'] = "j00 4r3 NO+ \$ubsCR183d +0 4ny +HRE4dS.";
$lang['resetselected'] = "rES3T sEl3c+3D";
$lang['allthreadtypes'] = "alL +hr34d typ3S";
$lang['ignoredthreads'] = "i9N0r3d thre4d5";
$lang['highinterestthreads'] = "hiGh IntEr3st tHr3ADs";
$lang['subscribedthreads'] = "su8\$cri8ED +hr3ADs";
$lang['currentinterest'] = "curr3nt 1N+3rEsT";

// Browseable user profiles

$lang['youcanonlyaddthreecolumns'] = "j00 C4n oNly @DD 3 COlUmns. To 4DD 4 nEW colUmn ClOs3 4N 3XI\$+ING 0ne";
$lang['columnalreadyadded'] = "j00 h@V3 4Lr34Dy 4DDED thi\$ c0lumn. 1F j00 w4N+ to r3Mov3 i+ CLICk 1+'5 clo\$3 8Ut+on";

?>
