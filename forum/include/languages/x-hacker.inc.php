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

/* $Id: x-hacker.inc.php,v 1.267 2007-12-30 22:38:16 decoyduck Exp $ */

// British English language file

// Language character set and text direction options -------------------

$lang['_isocode'] = "en";
$lang['_textdir'] = "ltr";

// Months --------------------------------------------------------------

$lang['month'][1]  = "jANU@ry";
$lang['month'][2]  = "fe8ru4RY";
$lang['month'][3]  = "m@RCH";
$lang['month'][4]  = "april";
$lang['month'][5]  = "m4Y";
$lang['month'][6]  = "jUN3";
$lang['month'][7]  = "july";
$lang['month'][8]  = "aUgust";
$lang['month'][9]  = "sePt3mBer";
$lang['month'][10] = "oCtoBEr";
$lang['month'][11] = "nov3mBEr";
$lang['month'][12] = "d3C3mber";

$lang['month_short'][1]  = "j4n";
$lang['month_short'][2]  = "fEB";
$lang['month_short'][3]  = "mAr";
$lang['month_short'][4]  = "apR";
$lang['month_short'][5]  = "m4Y";
$lang['month_short'][6]  = "jun";
$lang['month_short'][7]  = "juL";
$lang['month_short'][8]  = "aU9";
$lang['month_short'][9]  = "seP";
$lang['month_short'][10] = "oC+";
$lang['month_short'][11] = "nov";
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

$lang['date_periods']['year']   = "%s y34r";
$lang['date_periods']['month']  = "%s mON+h";
$lang['date_periods']['week']   = "%s we3k";
$lang['date_periods']['day']    = "%s D4y";
$lang['date_periods']['hour']   = "%s h0ur";
$lang['date_periods']['minute'] = "%s m1Nut3";
$lang['date_periods']['second'] = "%s 5econd";

// As above but plurals (2 years vs. 1 year, etc.)

$lang['date_periods_plural']['year']   = "%s y3ARS";
$lang['date_periods_plural']['month']  = "%s MoNTh\$";
$lang['date_periods_plural']['week']   = "%s W33ks";
$lang['date_periods_plural']['day']    = "%s d4ys";
$lang['date_periods_plural']['hour']   = "%s hoUrs";
$lang['date_periods_plural']['minute'] = "%s Minu+3s";
$lang['date_periods_plural']['second'] = "%s S3C0ND\$";

// Short hand periods (example: 1y, 2m, 3w, 4d, 5hr, 6min, 7sec)

$lang['date_periods_short']['year']   = "%sY";    // 1y
$lang['date_periods_short']['month']  = "%sm";    // 2m
$lang['date_periods_short']['week']   = "%sw";    // 3w
$lang['date_periods_short']['day']    = "%sD";    // 4d
$lang['date_periods_short']['hour']   = "%sHR";   // 5hr
$lang['date_periods_short']['minute'] = "%smIN";  // 6min
$lang['date_periods_short']['second'] = "%sSEC";  // 7sec

// Common words --------------------------------------------------------

$lang['percent'] = "p3RCEn+";
$lang['average'] = "av3r4ge";
$lang['approve'] = "aPprov3";
$lang['banned'] = "b4NNeD";
$lang['locked'] = "lOck3d";
$lang['add'] = "aDd";
$lang['advanced'] = "adv4NceD";
$lang['active'] = "ac+1v3";
$lang['style'] = "sTyl3";
$lang['go'] = "g0";
$lang['folder'] = "f0lder";
$lang['ignoredfolder'] = "iGn0ReD phold3R";
$lang['folders'] = "f0lDERs";
$lang['thread'] = "tHr34d";
$lang['threads'] = "tHREAds";
$lang['threadlist'] = "tHr34D li\$t";
$lang['message'] = "m3\$Sa9E";
$lang['messagenumber'] = "m3SSa93 NUM83r";
$lang['from'] = "fr0m";
$lang['to'] = "t0";
$lang['all_caps'] = "alL";
$lang['of'] = "of";
$lang['reply'] = "r3PLY";
$lang['forward'] = "fORW4rd";
$lang['replyall'] = "r3PLY t0 4lL";
$lang['pm_reply'] = "rePlY @5 Pm";
$lang['delete'] = "d3LEtE";
$lang['deleted'] = "d3l3+3D";
$lang['edit'] = "edI+";
$lang['privileges'] = "priviL393\$";
$lang['ignore'] = "i9noRE";
$lang['normal'] = "noRM4L";
$lang['interested'] = "iNTEr3s+3d";
$lang['subscribe'] = "subscr183";
$lang['apply'] = "aPPly";
$lang['download'] = "d0WNLo@d";
$lang['save'] = "s4V3";
$lang['update'] = "upD4t3";
$lang['cancel'] = "caNc3L";
$lang['continue'] = "c0n+INU3";
$lang['attachment'] = "at+aChmEnt";
$lang['attachments'] = "aTt4chm3nts";
$lang['imageattachments'] = "im49E @++achm3Nt\$";
$lang['filename'] = "filen4ME";
$lang['dimensions'] = "d1M3N\$1on\$";
$lang['downloadedxtimes'] = "dOwNL0AdeD: %d t1m3s";
$lang['downloadedonetime'] = "d0Wnlo4d3D: 1 tiM3";
$lang['size'] = "s1ZE";
$lang['viewmessage'] = "vIew mesSA93";
$lang['deletethumbnails'] = "deLE+e thUmBN41l\$";
$lang['logon'] = "l0gon";
$lang['more'] = "mOr3";
$lang['recentvisitors'] = "r3c3nt v1\$1+0RS";
$lang['username'] = "us3rn@ME";
$lang['clear'] = "cle4r";
$lang['action'] = "acTI0N";
$lang['unknown'] = "unKN0wN";
$lang['none'] = "n0NE";
$lang['preview'] = "prev13w";
$lang['post'] = "po5+";
$lang['posts'] = "poS+\$";
$lang['change'] = "chAN9E";
$lang['yes'] = "y3s";
$lang['no'] = "no";
$lang['signature'] = "si9n@tur3";
$lang['signaturepreview'] = "sI9n@+ur3 prEv13W";
$lang['signatureupdated'] = "sign@Ture UpDatED";
$lang['signatureupdatedforallforums'] = "si9n@+UR3 UPD@+3D F0r 4Ll ph0RUm5";
$lang['back'] = "b@ck";
$lang['subject'] = "sU8j3C+";
$lang['close'] = "clOse";
$lang['name'] = "n@ME";
$lang['description'] = "d3SCRip+10n";
$lang['date'] = "d4T3";
$lang['view'] = "vI3W";
$lang['enterpasswd'] = "enteR P4s\$W0RD";
$lang['passwd'] = "p@S\$Word";
$lang['ignored'] = "i9n0r3D";
$lang['guest'] = "gUE5+";
$lang['next'] = "neXt";
$lang['prev'] = "pr3vi0us";
$lang['others'] = "otHErs";
$lang['nickname'] = "nICkn4me";
$lang['emailaddress'] = "em@1l addr3S\$";
$lang['confirm'] = "c0nPH1rm";
$lang['email'] = "eM4iL";
$lang['poll'] = "p0ll";
$lang['friend'] = "fR13Nd";
$lang['success'] = "sucC3\$S";
$lang['error'] = "erR0r";
$lang['warning'] = "w4RnInG";
$lang['guesterror'] = "sorry, j00 NE3d +0 83 L0g9ED 1N t0 USE +his F3@+ure.";
$lang['loginnow'] = "l091n N0w";
$lang['unread'] = "unR34d";
$lang['all'] = "alL";
$lang['allcaps'] = "aLl";
$lang['permissions'] = "pErm1\$SI0n\$";
$lang['type'] = "type";
$lang['print'] = "pr1n+";
$lang['sticky'] = "s+iCky";
$lang['polls'] = "pOllS";
$lang['user'] = "uS3R";
$lang['enabled'] = "enabLED";
$lang['disabled'] = "d1\$4Bled";
$lang['options'] = "oPTI0N\$";
$lang['emoticons'] = "eM0+1COn\$";
$lang['webtag'] = "wE8+49";
$lang['makedefault'] = "m4ke D3ph4ulT";
$lang['unsetdefault'] = "unS3T deFault";
$lang['rename'] = "rEname";
$lang['pages'] = "p493s";
$lang['used'] = "useD";
$lang['days'] = "d4yS";
$lang['usage'] = "uS4g3";
$lang['show'] = "sh0w";
$lang['hint'] = "hin+";
$lang['new'] = "n3W";
$lang['referer'] = "rEf3r3r";
$lang['thefollowingerrorswereencountered'] = "thE foll0Wing 3Rr0r5 wEr3 3nc0UN+er3D:";

// Admin interface (admin*.php) ----------------------------------------

$lang['admintools'] = "aDM1n t0OL5";
$lang['forummanagement'] = "f0RUm m4n493mEnt";
$lang['accessdeniedexp'] = "j00 d0 no+ h@v3 p3rm1SSion +o usE +h1\$ \$eC+10N.";
$lang['managefolders'] = "m@N493 pH0LDER\$";
$lang['manageforums'] = "m4n49e foRum5";
$lang['manageforumpermissions'] = "m4N49E F0RUm peRM1\$\$10ns";
$lang['foldername'] = "foldeR namE";
$lang['move'] = "m0V3";
$lang['closed'] = "cLO53d";
$lang['open'] = "opEn";
$lang['restricted'] = "r3\$TR1cT3D";
$lang['forumiscurrentlyclosed'] = "%s 1S CUrrEntly ClosED";
$lang['youdonothaveaccesstoforum'] = "j00 d0 nO+ h4V3 4CceS\$ +0 %s";
$lang['toapplyforaccessplease'] = "to 4Pply f0r aCcEss ple4sE C0n+4CT +he F0Rum ownEr.";
$lang['adminforumclosedtip'] = "ipH J00 W@N+ +0 Ch4N93 s0m3 seTtIngs 0n yOUR forUm Cl1ck th3 4dmiN L1nk 1N t3h N@v1G4+1on B4R @bov3.";
$lang['newfolder'] = "neW phOlD3R";
$lang['nofoldersfound'] = "n0 EX1S+1ng PH0LDERs phounD. +0 aDD @ ph0LDEr CLiCK ThE '4DD new' 8U+toN 83l0w.";
$lang['forumadmin'] = "f0rum 4Dm1n";
$lang['adminexp_1'] = "us3 TH3 mENU on +he l3Ft to mAn4g3 thINg\$ 1n your phorum.";
$lang['adminexp_2'] = "<b>u\$ErS</b> 4llows J00 +0 s3T inD1V1du@l Us3r P3RM1\$\$1ons, 1NClUDIng @ppointInG m0d3r@tor\$ and g4GG1Ng p30PLE.";
$lang['adminexp_3'] = "<b>uS3r 9r0Ups</b> AlL0W\$ J00 +O cr34+E U53r gR0up\$ To @\$Si9n p3rm15s1ON5 +0 @\$ m@ny OR As f3W UserS qU1CkLY anD E@SIly.";
$lang['adminexp_4'] = "<b>b4n C0nTRol\$</b> AllOWs +He 84nn1n9 @nd un-8@nNIn9 0f ip 4Ddr3SS3s, H+tp rephErEr\$, u\$ERn@m3s, 3M41l 4DDRe\$Se5 AND niCkN4mES.";
$lang['adminexp_5'] = "<b>folDerS</b> 4llOWs +He crE@tion, M0d1PHICatI0N @nD dEl3T1on 0f ph0LD3RS.";
$lang['adminexp_6'] = "<b>rS\$ phe3Ds</b> @LLOw5 j00 +0 m@N49E r\$S ph33D\$ PH0r pR0pa94+1on iN+0 youR ph0ruM.";
$lang['adminexp_7'] = "<b>pROF1l35</b> l3ts j00 CUstomis3 th3 i+3Ms tH@+ 4pp34r 1n +hE u\$ER prophil3S.";
$lang['adminexp_8'] = "<b>foRUm sett1Ngs</b> All0W\$ j00 +O cu5+0m1se your PHORum'\$ n4m3, @pp34r@nCe anD m@ny OTH3r Things.";
$lang['adminexp_9'] = "<b>s+4rt p49E</b> l3t\$ J00 CU\$+omI\$e yoUr phorum's 5t4RT p@gE.";
$lang['adminexp_10'] = "<b>f0Rum style</b> 4lLow\$ J00 +0 93n3R4+3 r4ND0M s+yl3S f0r YoUr fOrum m3MBER\$ +0 u\$e.";
$lang['adminexp_11'] = "<b>word F1LT3R</b> 4ll0ws j00 +0 Ph1Lt3r woRD\$ J00 don'+ w@nt +0 83 Used 0N Y0UR phorUm.";
$lang['adminexp_12'] = "<b>p05+in9 s+@+s</b> g3ner4TE5 4 r3POr+ l1st1ng +h3 +op 10 p0s+ER\$ In @ D3f1ned pEr1oD.";
$lang['adminexp_13'] = "<b>fORUm L1nks</b> L3t5 j00 maN4GE +h3 L1NKs dropd0Wn IN +He n@V1G4TI0N BAr.";
$lang['adminexp_14'] = "<b>v13w l09</b> l1s+S rECENt @Ct10nS 8Y TEh f0Rum MOder4TORs.";
$lang['adminexp_15'] = "<b>m@n49e forum5</b> LEt\$ j00 cR34te anD D3l3+3 4nD Clo53 Or r30pen ph0rumS.";
$lang['adminexp_16'] = "<b>gLOB4L ph0RUm \$E++1NG\$</b> 4llow\$ J00 t0 modiPhy SETt1n9\$ Wh1CH 4fphECT 4ll ph0rUm\$.";
$lang['adminexp_17'] = "<b>p0\$t APprov@l qU3u3</b> 4llows j00 +o vi3w 4ny p05+S @W4i+1ng 4ppr0val 8Y 4 mOD3R4t0r.";
$lang['adminexp_18'] = "<b>vi5i+0R log</b> 4llow5 j00 to v13W 4N 3x+3NdeD li\$+ 0ph v1Sit0rs 1nClUD1N9 +H3Ir http rephErErs.";
$lang['createforumstyle'] = "cRe4+E 4 forum s+yL3";
$lang['newstylesuccessfullycreated'] = "n3w s+yl3 \$UCC3SsfUlly cr3@tED.";
$lang['stylealreadyexists'] = "a styl3 wI+h +h4+ fil3N4m3 4LrEaDY Exi\$+5.";
$lang['stylenofilename'] = "j00 d1d n0T En+3r a f1L3n@M3 T0 \$@V3 Th3 \$+yl3 W1+H.";
$lang['stylenodatasubmitted'] = "coUld nO+ r3aD F0RUM style D4T4.";
$lang['styleexp'] = "u\$3 TH1\$ p@g3 to h3lp CRe4+3 a r@nd0Mly GEnEr4t3D \$+YlE F0r y0UR ph0RUM.";
$lang['stylecontrols'] = "c0ntr0L\$";
$lang['stylecolourexp'] = "cl1ck on a colour +0 m@kE @ N3w styL3 sHeEt 8@seD oN +h4T Colour. CUrrEnt 84\$e C0l0ur is f1r5+ in l1st.";
$lang['standardstyle'] = "st4nDard \$+Yl3";
$lang['rotelementstyle'] = "roT@t3D El3M3Nt styl3";
$lang['randstyle'] = "r@nDOM 5+yl3";
$lang['thiscolour'] = "thI\$ ColOur";
$lang['enterhexcolour'] = "oR En+Er a h3X c0l0ur +o BAs3 a NEw s+yl3 \$heeT 0N";
$lang['savestyle'] = "s4V3 Th1\$ S+yl3";
$lang['styledesc'] = "s+Yl3 dEsCR1P+1oN";
$lang['stylefilenamemayonlycontain'] = "s+YL3 ph1lENAmE m@y OnlY c0NT@1N Low3Rc4SE LEttER5 (@-Z), nUmB3r5 (0-9) 4ND uND3R\$c0rE.";
$lang['stylepreview'] = "styl3 prEvi3w";
$lang['welcome'] = "welc0M3";
$lang['messagepreview'] = "m3\$s4g3 PR3V13w";
$lang['users'] = "userS";
$lang['usergroups'] = "u\$3r Gr0Up\$";
$lang['mustentergroupname'] = "j00 MUst en+3r 4 9roUP n@me";
$lang['profiles'] = "pROFilEs";
$lang['manageforums'] = "m@na93 PhoruMs";
$lang['forumsettings'] = "f0RUm 53tt1ngs";
$lang['globalforumsettings'] = "gloB4L forum \$3tt1Ngs";
$lang['settingsaffectallforumswarning'] = "<b>n0T3:</b> +h3\$e \$3++1n9s 4pHf3C+ @ll f0RUMs. wHErE +he 5e++1n9 1\$ DUPlICaTED oN +eh InD1VIDUaL Ph0RUm'5 s3Tt1NGS p@g3 +Hat will +4K3 Pr3c3DEnc3 0v3R +3H \$3t+1ngs j00 Ch4N93 HER3.";
$lang['startpage'] = "sT@R+ p@g3";
$lang['startpageerror'] = "y0ur st4rt p4G3 COUlD nO+ B3 s@ved L0C4Lly +0 ThE \$erv3R 8ec@usE p3Rm1\$\$10n W4S D3n13D.</p><p>t0 CHaNgE y0Ur 5+@rt p493 pl34se cliCk +3h DownLo@d 8UTTon 8El0w whiCh wilL pr0mp+ J00 +0 s4V3 +eh f1L3 +o yOUR h4rD DRiV3. j00 C@n +hen Upl0AD +h1s fil3 to your s3rver intO t3h PHoll0wiN9 ph0LDEr, 1f nEC3\$\$4ry creating +EH folD3r \$+ructUre in +h3 PRoC3sS.</p><p><b>%s</b></p><p>pLe4SE n0+e thAT s0ME 8R0wser\$ m4y ch4nG3 +HE n4me 0f +He file up0n Downl0ad.  wh3n Uplo4DIn9 +h3 Phil3 ple4\$3 m4K3 5UR3 That 1+ Is Named S+@r+_M@iN.php O+herwise yOUr sT4R+ p@93 w1ll aPp3@R uncH4n93D.";
$lang['failedtoopenmasterstylesheet'] = "yOUr pHORum \$+yl3 C0ULD no+ b3 \$4v3d 8EC@u53 +He master s+yle \$HE3T COUld No+ 8E l04d3d. +0 S4V3 YOur \$+YL3 +he m4st3R 5+yle \$HE3+ (maKe_\$TylE.C5\$) MUst 83 loc4+ED in +3H styl3s d1rEC+0ry oph y0Ur beeh1V3 phoRUM ins+ALL@+ion.";
$lang['makestyleerror'] = "yoUR forum s+yl3 COuLD n0t B3 s4vED L0C4Lly to Th3 serV3r 83C4U\$e P3rmi\$S1ON w@s D3N13D. to \$@VE yoUr phorum S+yLE PlEasE clICK +HE d0wnloaD 8utton beL0W wH1CH w1Ll prOMPt J00 to \$@VE +3H ph1L3 +0 y0Ur h@rd Driv3. j00 c4n TH3n uPL04D th1s fIl3 +o y0Ur 53rvEr iNTo %s phOLdEr, if NEC3ss4Ry cre4+ing TH3 folder \$tructure in t3h prOC3S\$. J00 \$H0uld n0t3 TH4t 5om3 BrowSErs m4y Ch4n93 teh n@ME 0ph +h3 Ph1LE uPOn D0wnlo4d. wh3n upLO@ding t3h pH1le PL34\$e M4ke sur3 +hat 1+ Is N4MED styl3.c\$S 0+heRW1se teh ForuM s+YLe w1ll be unu\$4ble.";
$lang['forumstyle'] = "f0RUm s+yle";
$lang['wordfilter'] = "w0RD phiL+er";
$lang['forumlinks'] = "f0RUm l1NKs";
$lang['viewlog'] = "vI3w L0g";
$lang['noprofilesectionspecified'] = "no prophiL3 \$3Cti0n sp3CIf13D.";
$lang['itemname'] = "it3m n4mE";
$lang['moveto'] = "mOve t0";
$lang['manageprofilesections'] = "m4N49E prophil3 sEC+1Ons";
$lang['sectionname'] = "sEc+I0n n4M3";
$lang['items'] = "i+em\$";
$lang['mustspecifyaprofilesectionid'] = "mUsT Sp3C1phY 4 proPHIl3 \$ection iD";
$lang['mustsepecifyaprofilesectionname'] = "muS+ sP3c1phy a prophil3 \$eCt10n n4mE";
$lang['noprofilesectionsfound'] = "no 3x1\$+1NG proph1lE seC+10ns phound. to @DD @ PR0ph1le \$EC+i0N CliCk thE '@dd nEw' 8U++on BEl0w.";
$lang['addnewprofilesection'] = "add N3W pr0Phil3 \$eCtioN";
$lang['successfullyaddedprofilesection'] = "sUcCes\$phUlly 4dd3D Pr0PHIl3 SECT10N";
$lang['successfullyeditedprofilesection'] = "succ3ssfully 3D1+3d prof1L3 \$ECT10N";
$lang['addnewprofilesection'] = "aDd new pRophile seC+i0n";
$lang['mustsepecifyaprofilesectionname'] = "mu\$+ sp3CIFY 4 prophil3 sectIon n4m3";
$lang['successfullyremovedselectedprofilesections'] = "sUCcEssfullY rem0V3d sel3C+ed pr0fil3 sect10n5";
$lang['failedtoremoveprofilesections'] = "f4IL3d +o r3mov3 PropHILe seC+i0n5";
$lang['viewitems'] = "vi3w 1TEm\$";
$lang['successfullyaddednewprofileitem'] = "sUcc3ssfUlly @dd3d nEw pr0PH1Le 1+Em";
$lang['successfullyeditedprofileitem'] = "succe\$SfuLly 3D1+eD pr0phIl3 i+3m";
$lang['successfullyremovedselectedprofileitems'] = "sUcc3\$SfUllY r3movED sEl3C+ED profil3 itEms";
$lang['failedtoremoveprofileitems'] = "f41LED +o r3movE pr0phil3 Items";
$lang['noexistingprofileitemsfound'] = "th3re 4R3 n0 3X1St1N9 Pr0Phil3 i+eMs in +h1\$ S3Ction. +o 4Dd 4n 1+3M Cl1CK thE '4DD New' 8UT+0n BEl0W.";
$lang['edititem'] = "edIt 1+em";
$lang['invalidprofilesectionid'] = "iNv4l1D Prophil3 sECTiOn id or s3C+10n not F0UnD";
$lang['invalidprofileitemid'] = "iNv4l1D proFil3 i+Em id or itEm not FOunD";
$lang['addnewitem'] = "aDd N3w 1teM";
$lang['youmustenteraprofileitemname'] = "j00 mU\$T eN+3R a pROPhil3 i+3m n4m3";
$lang['invalidprofileitemtype'] = "iNV4liD proF1L3 1Tem type \$eleCtED";
$lang['youmustenteroptionsforselectedprofileitemtype'] = "j00 mu5+ 3NT3R \$0M3 0P+i0n\$ Ph0r sel3c+ed pr0phil3 1+3m +ype";
$lang['youmustentermorethanoneoptionforitem'] = "j00 mU5+ enT3R morE th4n 0nE oP+I0n FOr \$3lECt3D Pr0F1l3 I+em +yp3";
$lang['profileitemhyperlinkssupportshttpurlsonly'] = "pr0PhiL3 1tEm hyPerlinKs \$upP0r+ h+tp Url\$ Only";
$lang['profileitemhyperlinkformatinvalid'] = "pR0philE ItEm hyp3Rl1nk phorm4+ invalID";
$lang['youmustincludeprofileentryinhyperlinks'] = "j00 must 1NCluDE <i>%s</i> 1n +he URL 0f CL1ck48LE hyP3rliNks";
$lang['failedtocreatenewprofileitem'] = "f@ILeD to CRE4+e nEw prophiLE 1+3m";
$lang['failedtoupdateprofileitem'] = "f@ileD +0 upD4T3 PR0f1l3 i+Em";
$lang['startpageupdated'] = "sT@r+ p4gE upD4+3D. %s";
$lang['viewupdatedstartpage'] = "v1eW upd@teD \$T4r+ p4ge";
$lang['editstartpage'] = "ed1t star+ p@g3";
$lang['nouserspecified'] = "no u53R sp3CIf13D.";
$lang['manageuser'] = "m4N@gE User";
$lang['manageusers'] = "m4N@93 u\$3RS";
$lang['userstatusforforum'] = "u\$3r s+a+us pH0r %s";
$lang['userdetails'] = "u5Er D3ta1L\$";
$lang['warning_caps'] = "wARN1n9";
$lang['userdeleteallpostswarning'] = "aRe J00 \$Ur3 J00 want t0 D3l3T3 @LL 0ph +3h sEl3CTeD usEr's p0\$+S? onCE the p0s+\$ 4re D3lEtED +hEy c4NN0t BE R3tr1Ev3D 4ND will 83 LO\$T f0REvEr.";
$lang['postssuccessfullydeleted'] = "pOsTS were \$ucc3Ssphully d3lEteD.";
$lang['folderaccess'] = "f0lder @CC3sS";
$lang['possiblealiases'] = "p0Ss18LE 4l14\$es";
$lang['userhistory'] = "u53r h1\$TOrY";
$lang['nohistory'] = "nO H1story ReCoRd\$ 54VED";
$lang['userhistorychanges'] = "cH4n93\$";
$lang['clearuserhistory'] = "cle4r u\$ER Hist0RY";
$lang['changedlogonfromto'] = "cH4ng3D l0G0N Fr0m %s t0 %s";
$lang['changednicknamefromto'] = "cH@N9eD niCkn4M3 Fr0m %s +0 %s";
$lang['changedemailfromto'] = "ch4nG3d 3M@il phr0m %s +O %s";
$lang['successfullycleareduserhistory'] = "suCC3S\$fulLY Cle@reD U\$ER h1STory";
$lang['failedtoclearuserhistory'] = "f4Il3d +0 ClEar User hI5+0ry";
$lang['successfullychangedpassword'] = "sUCCessfUlly CH4ng3D p4\$Sw0rd";
$lang['failedtochangepasswd'] = "f4IL3d +0 ch4NG3 p@\$sw0rD";
$lang['viewuserhistory'] = "v13w useR h1st0ry";
$lang['viewuseraliases'] = "vI3w User Al14sE5";
$lang['searchreturnednoresults'] = "s34rch r3tUrn3D no rE\$ulT5";
$lang['deleteposts'] = "deLe+e pOS+s";
$lang['deleteuser'] = "d3LEt3 U\$Er";
$lang['alsodeleteusercontent'] = "aL50 D3le+e 4Ll of th3 Cont3nT Cre4+3d 8y th1\$ User";
$lang['userdeletewarning'] = "aR3 j00 sUR3 j00 W@n+ +0 DEl3+3 THe sel3C+eD UsEr acCoUn+? 0ncE +Eh 4CCoUnt h4\$ b3EN del3+ED iT C4nn0+ bE rE+rIevEd @ND wiLl bE lo\$T phoR3vER.";
$lang['usersuccessfullydeleted'] = "uSER \$uCc3\$\$FUlly Dele+ed";
$lang['failedtodeleteuser'] = "f4iL3d +0 D3l3T3 uS3r";
$lang['forgottenpassworddesc'] = "iPh +h1S u\$3R h4\$ forgO++En +hE1R p45\$wORd J00 c@N R3sE+ 1T phOR +Hem h3Re.";
$lang['manageusersexp'] = "tH1\$ L1ST SHows a 53lEC+I0N 0F us3rs whO havE loGgeD 0n T0 Y0ur PHOrUm, sorT3D 8y %s. +0 4L+ER 4 User's p3RMISsiON5 CliCK tHE1R n4ME.";
$lang['userfilter'] = "u5ER PHIl+Er";
$lang['onlineusers'] = "oNl1N3 uSer\$";
$lang['offlineusers'] = "ofPHlINE Users";
$lang['usersawaitingapproval'] = "u\$3rS 4W4ITinG 4PProv4l";
$lang['bannedusers'] = "b@Nn3D Us3R5";
$lang['lastlogon'] = "l@ST lO9ON";
$lang['sessionreferer'] = "se\$S1On R3feRer";
$lang['signupreferer'] = "sI9N-uP reFer3R:";
$lang['nouseraccountsmatchingfilter'] = "no U5ER acCouNTs M4+cHInG philter";
$lang['searchforusernotinlist'] = "s3@rch FoR 4 U\$ER no+ IN l1s+";
$lang['adminaccesslog'] = "aDM1n 4cc3ss L09";
$lang['adminlogexp'] = "this LIs+ \$hOWs TeH l4sT 4CT1onS \$ANc+I0n3D by U\$er\$ Wi+H 4DM1n PRivIleGEs.";
$lang['datetime'] = "d@+3/tiMe";
$lang['unknownuser'] = "unKN0WN User";
$lang['unknownuseraccount'] = "unKNown us3r @CC0Unt";
$lang['unknownfolder'] = "unKN0Wn F0lDEr";
$lang['ip'] = "ip";
$lang['lastipaddress'] = "l4\$T ip 4DDress";
$lang['logged'] = "l0g9Ed";
$lang['notlogged'] = "no+ L0gGED";
$lang['addwordfilter'] = "aDd word F1lt3R";
$lang['addnewwordfilter'] = "aDd n3w worD Philter";
$lang['wordfilterupdated'] = "w0RD f1Lt3r UpD@+ed";
$lang['wordfilterisfull'] = "j00 c@nno+ @dD @ny mor3 worD phIl+er5. rem0V3 S0M3 UNuseD 0N3S 0r 3Di+ +H3 Ex1s+1Ng 0nEs ph1r\$T.";
$lang['filtername'] = "fIlt3R n@m3";
$lang['filtertype'] = "f1LT3r tyPE";
$lang['filterenabled'] = "f1LT3R 3n48LED";
$lang['editwordfilter'] = "eD1+ wORD Fil+3R";
$lang['nowordfilterentriesfound'] = "no 3xist1nG w0rD Ph1Lt3R enTr13s phOUND. T0 @DD a f1LtER CL1Ck tH3 '@DD n3W' BUt+0n 83LOw.";
$lang['mustspecifyfiltername'] = "j00 must sp3CiFy a f1LT3R n@mE";
$lang['mustspecifymatchedtext'] = "j00 mu\$T speCiphy m4+CHED +ext";
$lang['mustspecifyfilteroption'] = "j00 mUsT 5p3C1PHy @ fIl+3r 0PT1on";
$lang['mustspecifyfilterid'] = "j00 mUst spEc1fy a fiL+Er 1d";
$lang['invalidfilterid'] = "iNVALId F1LT3R iD";
$lang['failedtoupdatewordfilter'] = "faiL3d to upDat3 worD f1lT3r. CH3CK +H@t tEh pH1l+3r \$T1Ll Ex1S+s.";
$lang['allow'] = "aLlow";
$lang['block'] = "bL0Ck";
$lang['normalthreadsonly'] = "nORM4l +Hre4D\$ ONlY";
$lang['pollthreadsonly'] = "pOll THr34Ds only";
$lang['both'] = "b0th +Hre@D +ypEs";
$lang['existingpermissions'] = "eX1S+1ng p3Rm15\$10ns";
$lang['nousershavebeengrantedpermission'] = "no Exis+1n9 UsER\$ P3rmiSSIOn5 ph0Und. To 9R@Nt pErMissi0n t0 U53rs \$3@rCH for +HEm 83l0w.";
$lang['successfullyaddedpermissionsforselectedusers'] = "succ3sSFully addED pErm1s\$10Ns phor sel3C+eD User\$";
$lang['successfullyremovedpermissionsfromselectedusers'] = "sucCe\$SfullY rEmoveD p3Rm1\$SI0N\$ Phrom seleC+ED Us3Rs";
$lang['failedtoaddpermissionsforuser'] = "f@1l3d T0 4DD p3rmissi0n\$ ph0r u53R '%s'";
$lang['failedtoremovepermissionsfromuser'] = "f@il3D +O r3Mov3 p3Rm1Ssi0n\$ pHR0m u\$3R '%s'";
$lang['searchforuser'] = "se4rCh pHOr u\$3r";
$lang['browsernegotiation'] = "br0w53r nEg0+i@tED";
$lang['largetextfield'] = "l4RG3 tex+ fiElD";
$lang['mediumtextfield'] = "m3diuM +ex+ f13ld";
$lang['smalltextfield'] = "smAll t3xt phi3LD";
$lang['multilinetextfield'] = "muL+i-l1n3 +ext F13LD";
$lang['radiobuttons'] = "r4dio 8u+t0n\$";
$lang['dropdownlist'] = "dr0p Down li\$T";
$lang['clickablehyperlink'] = "cL1Ck4Ble hyPERlINk";
$lang['threadcount'] = "thr3@D c0Un+";
$lang['clicktoeditfolder'] = "clIck to ED1+ F0lD3R";
$lang['fieldtypeexample1'] = "t0 creAt3 R4di0 8uttonS or 4 Dr0p d0WN l1s+ j00 ne3D to en+3r 34ch indiv1DUal V4lu3 0n 4 \$3p4RAte l1NE 1n +HE option\$ F13ld.";
$lang['fieldtypeexample2'] = "to CRE4+e cl1Ck48L3 l1nkS 3NT3r +h3 url in +hE opTIons FIEld 4ND US3 <i>%1\$S</i> Wh3Re +3H en+ry fRom +3H u\$ER's pROFilE sh0uLD 4PpEar. Ex@mpl3S: <p>mY\$pac3: <i>hT+p://wWw.mY5P@C3.c0m/%1\$S</i><br />xBox l1ve: <i>h+tp://pr0PhIl3.myg4M3RC4Rd.n3t/%1\$S</i>";
$lang['editedwordfilter'] = "eDiTED word fil+er";
$lang['editedforumsettings'] = "ed1+3D foRUm \$3t+ings";
$lang['successfullyendedusersessionsforselectedusers'] = "suCC3\$\$PHUlly 3NDeD \$essI0n\$ for sel3C+eD Us3rs";
$lang['failedtoendsessionforuser'] = "fail3d t0 3nd sess10N phor Us3r %s";
$lang['successfullyapprovedselectedusers'] = "sUCce\$SfUlly 4pprovED \$3l3C+3d u\$3rs";
$lang['matchedtext'] = "m4+Ch3D tEXT";
$lang['replacementtext'] = "r3Pl4CEmEnt T3X+";
$lang['preg'] = "pReG";
$lang['wholeword'] = "wH0l3 w0rd";
$lang['word_filter_help_1'] = "<b>aLl</b> M4TChEs @94INSt teh wh0le +3x+ \$0 fiL+ErinG m0m To mum wilL @lso ch4N93 m0m3nt t0 muMeNt.";
$lang['word_filter_help_2'] = "<b>wHoLE word</b> M4tChes @G@ins+ wH0LE w0RDs 0Nly \$0 f1L+3RIN9 moM +0 mUM W1Ll N0T ch4N9e m0MEN+ +o mUM3nt.";
$lang['word_filter_help_3'] = "<b>pREg</b> All0wS J00 to use p3rl R39ULar 3Xpr3s\$i0n5 +o m4+CH text.";
$lang['nameanddesc'] = "n4me 4nD d3SCRip+10n";
$lang['movethreads'] = "m0Ve threaDs";
$lang['movethreadstofolder'] = "m0V3 +hR3@D\$ +0 pHold3R";
$lang['failedtomovethreads'] = "f@1L3D to M0vE +hrE4D\$ to SPEciphi3d f0ld3R";
$lang['resetuserpermissions'] = "r3Set u53r p3rm15si0n\$";
$lang['failedtoresetuserpermissions'] = "fA1l3D t0 resE+ u53r PErm1ss10N5";
$lang['allowfoldertocontain'] = "all0w folder to C0NT41n";
$lang['addnewfolder'] = "add n3W pholdEr";
$lang['mustenterfoldername'] = "j00 mu5+ Enter 4 F0lD3r n4ME";
$lang['nofolderidspecified'] = "n0 ph0ldEr 1D sp3C1PHI3D";
$lang['invalidfolderid'] = "inV@LiD foLDEr iD. Ch3ck +h@t 4 f0LDEr wi+h +hIs id Exis+S!";
$lang['successfullyaddednewfolder'] = "succE\$sphully 4DD3D n3w PHold3R";
$lang['successfullyremovedselectedfolders'] = "sUcCes\$fuLLy r3M0VeD s3lEC+3D FolD3rs";
$lang['successfullyeditedfolder'] = "succeSSFUlly 3D1+Ed FolDEr";
$lang['failedtocreatenewfolder'] = "f@1LED to CR34+e NEw ph0lder";
$lang['failedtodeletefolder'] = "f4iL3d t0 DELEt3 f0LDer.";
$lang['failedtoupdatefolder'] = "f@il3D +0 UpD4tE F0lD3R";
$lang['cannotdeletefolderwiththreads'] = "c4Nno+ d3Lete f0LDer\$ +ha+ sTILl c0N+41N thrE4d\$.";
$lang['forumisnotrestricted'] = "f0Rum 1s no+ rEs+R1CTeD";
$lang['groups'] = "gR0ups";
$lang['nousergroups'] = "n0 U\$er 9r0Ups h4VE 8E3n s3t uP. +0 4DD 4 9r0Up Cl1Ck th3 '@DD nEw' 8u+ton BEl0W.";
$lang['suppliedgidisnotausergroup'] = "sUPpl1eD 9Id is n0+ a U\$er 9r0Up";
$lang['manageusergroups'] = "m@na93 u\$er 9r0Ups";
$lang['groupstatus'] = "grOUp \$T4+u\$";
$lang['addusergroup'] = "add user 9roup";
$lang['addemptygroup'] = "add 3mpty 9r0up";
$lang['adduserstogroup'] = "add U\$ERs +0 9RouP";
$lang['addremoveusers'] = "aDd/R3mov3 u\$er5";
$lang['nousersingroup'] = "th3rE 4r3 no Us3r5 1n +H1\$ group. ADD u53rs +o +HIS group 8y s3@rCh1n9 ph0R +h3m 83L0W.";
$lang['groupaddedaddnewuser'] = "sUCCEs\$PHully @dD3D gr0UP. 4DD users to thi\$ 9R0up 8y \$e4rchIn9 for them 83l0w.";
$lang['nousersingroupaddusers'] = "tH3rE 4r3 n0 US3RS in +hiS Group. t0 4DD useR\$ CLiCk +h3 '@DD/rem0VE us3rs' bUtton BEL0W.";
$lang['useringroups'] = "tHi\$ uS3r 1s 4 m3mBEr of +hE ph0ll0WIn9 groups";
$lang['usernotinanygroups'] = "tHi\$ u\$er i\$ n0T 1n @ny User 9R0Ups";
$lang['usergroupwarning'] = "nOt3: +his UsEr M4Y 8E iNh3R1TINg 4dd1+i0n4L permIssion5 PhRom any usEr Group\$ l1stED 83l0w.";
$lang['successfullyaddedgroup'] = "sUCC35SFully adD3D group";
$lang['successfullyeditedgroup'] = "sUcc3s\$PhUlly ED1t3D Gr0Up";
$lang['successfullydeletedselectedgroups'] = "sUcc3SSfully D3LEt3D \$el3c+3D gr0UP\$";
$lang['failedtodeletegroupname'] = "f@il3D +0 Del3t3 groUp %s";
$lang['usercanaccessforumtools'] = "u\$ER C4N acCEss phorum tool\$ 4nd C4N CRe4T3, D3LEtE 4nD 3di+ forUms";
$lang['usercanmodallfoldersonallforums'] = "user C4n m0D3R@+e <b>alL F0lder5</b> 0n <b>aLL phOrUms</b>";
$lang['usercanmodlinkssectiononallforums'] = "uSEr Can moDEr4+3 liNks sec+i0N on <b>aLl forumS</b>";
$lang['emailconfirmationrequired'] = "eM@IL c0nPHIRm@+1on r3QU1r3D";
$lang['userisbannedfromallforums'] = "useR is 8ann3d from <b>aLl phorUms</b>";
$lang['cancelemailconfirmation'] = "c4ncel 3m4IL conF1RMatiON 4nD @llow u\$er t0 st4r+ p0s+IN9";
$lang['resendconfirmationemail'] = "rEsEND C0NFIrm4+I0N EmA1l tO u\$ER";
$lang['donothing'] = "d0 noThing";
$lang['usercanaccessadmintools'] = "u\$3r H4\$ aCCEss +0 PhorUm @dMin Tool\$";
$lang['usercanaccessadmintoolsonallforums'] = "u5eR h@s @cC3ss +0 AdmiN t00l5 <b>oN aLl F0Rums</b>";
$lang['usercanmoderateallfolders'] = "u5ER C4N m0Der4T3 @lL F0lders";
$lang['usercanmoderatelinkssection'] = "uSEr can m0D3RA+e l1NKs \$eCT1ON";
$lang['userisbanned'] = "u\$3r is 8ann3d";
$lang['useriswormed'] = "u\$3R is w0rmED";
$lang['userispilloried'] = "us3r I\$ P1llor1Ed";
$lang['usercanignoreadmin'] = "us3R c4n IGNorE @DM1nis+r4+0RS";
$lang['groupcanaccessadmintools'] = "gRoup cAN 4cC3S5 aDm1n tool\$";
$lang['groupcanmoderateallfolders'] = "gr0up c@n modEr4TE 4ll ph0Ld3rS";
$lang['groupcanmoderatelinkssection'] = "group C@n MODER4+3 Links S3ctiON5";
$lang['groupisbanned'] = "gR0UP i\$ 8anneD";
$lang['groupiswormed'] = "gr0up is w0rm3D";
$lang['readposts'] = "read po5ts";
$lang['replytothreads'] = "r3pLY t0 +HREaDs";
$lang['createnewthreads'] = "cr3@te new thr3@D\$";
$lang['editposts'] = "ed1+ po\$+s";
$lang['deleteposts'] = "d3le+3 p05+s";
$lang['postssuccessfullydeleted'] = "p0\$+\$ 5uCCEsspHUllY D3LET3d";
$lang['failedtodeleteusersposts'] = "fA1l3D To delEtE user'\$ po5+s";
$lang['uploadattachments'] = "uPlo4d @++@Chm3n+5";
$lang['moderatefolder'] = "m0D3rATE f0lD3R";
$lang['postinhtml'] = "poS+ in h+ml";
$lang['postasignature'] = "pO5T 4 519N4+Ur3";
$lang['editforumlinks'] = "eD1t forum L1nks";
$lang['linksaddedhereappearindropdown'] = "l1NKs @DD3D h3r3 4pPe4R 1N a Dr0p Down 1N +eh +0p Ri9H+ oph +3h Fr4ME sEt.";
$lang['linksaddedhereappearindropdownaddnew'] = "liNKs 4DD3D h3R3 4ppE4R in 4 Dr0p D0Wn 1n th3 +0p R1gHt 0Ph thE fR@me \$et. t0 @dd 4 L1nk cliCk +3h '4Dd nEw' BU++on B3Low.";
$lang['failedtoremoveforumlink'] = "f@1led t0 r3m0v3 Forum link '%s'";
$lang['failedtoaddnewforumlink'] = "f41L3D t0 4dD n3W f0RUM l1nK '%s'";
$lang['failedtoupdateforumlink'] = "f@il3d +o upDate F0RUm l1NK '%s'";
$lang['notoplevellinktitlespecified'] = "n0 +0P l3V3l link +1+l3 sp3ciphieD";
$lang['youmustenteralinktitle'] = "j00 mu\$+ enter 4 l1NK +itl3";
$lang['alllinkurismuststartwithaschema'] = "alL l1nk ur1\$ must sT4rt wi+h @ sChem4 (1.e. h++p://, ph+P://, irC://)";
$lang['editlink'] = "eD1t liNk";
$lang['addnewforumlink'] = "adD n3w phorUm l1Nk";
$lang['forumlinktitle'] = "f0Rum lINK t1+LE";
$lang['forumlinklocation'] = "f0Rum Link l0CaT10n";
$lang['successfullyaddednewforumlink'] = "sUCC3SsphuLLY 4DD3d n3w f0rum Link";
$lang['successfullyeditedforumlink'] = "sucCes\$PhUlly 3D1TeD pHorum LiNk";
$lang['invalidlinkidorlinknotfound'] = "iNV4lid linK 1d 0r liNk n0+ pHound";
$lang['successfullyremovedselectedforumlinks'] = "sUcC3Ssfully reMov3d sEl3C+ED link\$";
$lang['toplinkcaption'] = "t0p LINK Caption";
$lang['allowguestaccess'] = "aLl0W Gu3st 4Cc3Ss";
$lang['searchenginespidering'] = "sE4Rch en91n3 sp1D3Ring";
$lang['allowsearchenginespidering'] = "aLl0w se@rCh 3n9INE spID3r1ng";
$lang['newuserregistrations'] = "new Us3r rE9istr4+i0N\$";
$lang['preventduplicateemailaddresses'] = "prEvEnt Duplic4+E emA1l 4DDR3sses";
$lang['allownewuserregistrations'] = "all0w n3W us3r r391s+r4+10n5";
$lang['requireemailconfirmation'] = "r3qUIR3 Em4iL C0nphirMat10n";
$lang['usetextcaptcha'] = "u\$3 t3x+-c4P+cha";
$lang['textcaptchadir'] = "t3xt-c@p+Cha d1rEc+0ry";
$lang['textcaptchakey'] = "t3xt-c4p+Ch4 k3Y";
$lang['textcaptchafonterror'] = "teX+-c4P+ch@ h@\$ 8e3N dis4bLEd @u+0M4+1c4LlY 8EC@Us3 thEre @r3 n0 TRU3 typ3 f0N+s @v@1L4BlE F0r It +0 U\$E. pl34se upl0@D \$0mE trUE typ3 f0N+s +0 <b>%s</b> 0n y0Ur \$3rver.";
$lang['textcaptchadirerror'] = "teXt-C4PTch@ h4s 8E3n Di\$4BlED B3c4Use teh +Ext_CAptcH@ D1R3ctory @nd 1T'S sub-DIrECt0riES @r3 N0T wr1+@8lE 8Y +he w38 serv3R / php prOC3ss.";
$lang['textcaptchagderror'] = "teXt-c@p+cH4 H45 83en Dis4Bl3d b3C4u\$e youR serv3R's php sEtuP d03s n0+ providE sUpporT for Gd Im@ge m@n1PUl4Tion @nD / 0R ++f Ph0nt suppor+. 8o+h 4re r3QuIr3D pH0r +ext-c@p+Ch4 \$uPP0r+.";
$lang['textcaptchadirblank'] = "teX+-Cap+ch@ dIR3c+0Ry 1S BL@nk!";
$lang['newuserpreferences'] = "n3W u53r prEf3r3NC3s";
$lang['sendemailnotificationonreply'] = "em4il N0TiPhICat10n on reply +0 u\$3r";
$lang['sendemailnotificationonpm'] = "eM41L notifiC4TIoN 0N pm +o User";
$lang['showpopuponnewpm'] = "shoW popup wh3n r3c31v1Ng n3w PM";
$lang['setautomatichighinterestonpost'] = "s3+ 4u+omat1C h1gh iNt3r3St on p05+";
$lang['postingstats'] = "pOS+1n9 Stats";
$lang['postingstatsforperiod'] = "po5+in9 \$+4+s f0r p3RI0D %s +0 %s";
$lang['nopostdatarecordedforthisperiod'] = "nO po\$T D4+@ r3CorD3D ph0R Th1\$ PER10d.";
$lang['totalposts'] = "tot4l P0\$+S";
$lang['totalpostsforthisperiod'] = "toTal po\$+s f0r th1s p3ri0D";
$lang['mustchooseastartday'] = "muS+ Choos3 4 Star+ D@y";
$lang['mustchooseastartmonth'] = "mu\$T ChooSE @ \$tAR+ m0n+h";
$lang['mustchooseastartyear'] = "mu5+ chooS3 4 \$+4rt y3AR";
$lang['mustchooseaendday'] = "mU5t Ch0o5e @ enD D4Y";
$lang['mustchooseaendmonth'] = "mUs+ CHoos3 A 3nD m0nth";
$lang['mustchooseaendyear'] = "muST ch0O\$E @ 3nD y3@R";
$lang['startperiodisaheadofendperiod'] = "s+4r+ PERi0d 1s 4h3AD 0F 3nd p3ri0d";
$lang['bancontrols'] = "b4N C0N+rols";
$lang['addban'] = "adD 84n";
$lang['checkban'] = "cHeck B@n";
$lang['editban'] = "ed1t b4n";
$lang['bantype'] = "b@N +yp3";
$lang['bandata'] = "b4N DaT4";
$lang['bancomment'] = "c0MM3nt";
$lang['ipban'] = "iP 8aN";
$lang['logonban'] = "lOg0n 8an";
$lang['nicknameban'] = "nIckn4m3 B4N";
$lang['emailban'] = "eM41l 84n";
$lang['refererban'] = "reFEr3R 84n";
$lang['invalidbanid'] = "iNv4l1d b@n iD";
$lang['affectsessionwarnadd'] = "tH1\$ 8@N M4y @FfECT th3 phollow1Ng @CTiv3 u53R s3S\$10ns";
$lang['noaffectsessionwarn'] = "th1S B4N @FphECT\$ no @CT1vE sE5\$10ns";
$lang['mustspecifybantype'] = "j00 mU\$T 5P3C1fy @ Ban +yp3";
$lang['mustspecifybandata'] = "j00 must \$PEC1fy SOmE 8@n D4+4";
$lang['successfullyremovedselectedbans'] = "sUCC3\$SPHULLY r3moV3D seL3C+ed 8@Ns";
$lang['failedtoaddnewban'] = "faIl3d +0 4dD new B4N";
$lang['failedtoremovebans'] = "f41l3d t0 Rem0V3 s0M3 0r 4lL Oph +h3 s3lEC+3d 8ANs";
$lang['duplicatebandataentered'] = "dUPl1C@t3 8an dat@ eN+3r3D. ple453 CHeCk your wiLDC4RD5 To seE if +hEy alR3aDY m@+ch ThE D4T4 eNter3D";
$lang['successfullyaddedban'] = "sUccessphUlly @dd3D 8@n";
$lang['successfullyupdatedban'] = "sucCeSsphUlly Upda+ED 8@n";
$lang['noexistingbandata'] = "th3r3 1s no Ex1ST1Ng B@n d4T4. t0 4dD 4 Ban Cl1Ck thE '4Dd n3w' 8U++on BEl0w.";
$lang['youcanusethepercentwildcard'] = "j00 can USE +hE p3rcEnt (%) wIlDc@rD sym8ol 1N @ny oph your B4n li\$TS t0 oBTa1n par+1@l m4+ch3s, 1.3. '192.168.0.%' woUlD Ban 4Ll ip 4DDrEsses in +HE ran9e 192.168.0.1 +Hrou9H 192.168.0.254";
$lang['cannotusewildcardonown'] = "j00 c4NN0+ ADD % 45 4 wiLDC@rD mA+Ch on 1+'5 0wN!";
$lang['requirepostapproval'] = "r3QuIre po\$+ 4ppRov@L";
$lang['adminforumtoolsusercounterror'] = "tHere mU\$T bE 4+ le4s+ 1 USer w1+h 4Dm1n +o0Ls 4nD phorum tools 4cc3SS on @lL F0Rums!";
$lang['postcount'] = "p0ST coun+";
$lang['resetpostcount'] = "re5et pos+ C0unt";
$lang['failedtoresetuserpostcount'] = "f41led +0 rE\$et po\$+ C0UNt";
$lang['failedtochangeuserpostcount'] = "f@il3D to ch@Nge User p0St coUnt";
$lang['postapprovalqueue'] = "poS+ 4ppRov@l quEu3";
$lang['nopostsawaitingapproval'] = "n0 po\$T\$ @r3 4wa1+Ing 4ppr0v4l";
$lang['approveselected'] = "aPprov3 sEl3C+ED";
$lang['failedtoapproveuser'] = "f@il3d +0 appr0V3 U53r %s";
$lang['kickselected'] = "k1ck selEC+3D";
$lang['visitorlog'] = "vi\$1+0r log";
$lang['clearvisitorlog'] = "cl34r VI\$1+0r lO9";
$lang['novisitorslogged'] = "n0 V1SITor5 l099ed";
$lang['addselectedusers'] = "aDd s3l3c+3d uSERs";
$lang['removeselectedusers'] = "r3M0v3 seL3C+3d U53rs";
$lang['addnew'] = "aDD new";
$lang['deleteselected'] = "dElEt3 s3lEC+3d";
$lang['forumrulesmessage'] = "<p><b>fOrum RUL3s</b></p><p>\nreg15trA+10N To %1\$\$ 1\$ Phr33! w3 Do 1nsis+ +h4t j00 aB1D3 8y +hE ruleS 4nd P0lici3s de+4Il3d beL0w. 1F j00 Agr3e t0 The termS, ple4s3 CH3CK th3 'i @gr3e' Ch3CkB0x @Nd prESs +eh 'regist3r' 8U+T0n 8el0W. if J00 w0uLD l1KE +0 canc3L +eh RE9IStRAT10n, cl1Ck %2\$\$ t0 returN to +3H ph0rumS 1ndex.</p><p>\n4l+hou9h tH3 4dmin1S+r4+0Rs and M0D3r4+oRs 0ph %1\$s W1Ll 4+tempt To ke3p @LL 0bj3ct10n4BlE m3S\$49e5 ophF +h1S foruM, 1T 1\$ 1mp0s5i8le foR u\$ +o Revi3w 4lL M3Ssa9E\$. 4lL m3\$S4geS exPREsS th3 V1ewS 0pH +he 4uthOr, 4nd NEither +Eh OWn3rs 0f %1\$\$, N0r pRoj3C+ beeH1ve Phorum 4nd i+'\$ @ffil1@t3s w1ll 83 heLD R35pOns18l3 f0r TH3 CON+eNt 0f @NY mesS4ge.</p><p>\n8Y 49r33In9 +o TH353 Rul3\$, j00 w4rr4nT +h@+ j00 will n0+ p0sT 4ny M3\$s4g3\$ +h4+ 4re o8sc3n3, vul9@r, S3XUallY-0r1Ent4t3d, haT3PHUl, +hr34T3n1n9, oR o+herwIs3 VI0l4tiv3 Oph @Ny l4w5.</p><p>th3 owneRs OF %1\$s R3S3rve t3h Right T0 r3moVE, 3di+, m0v3 Or cloSE Any +hRE4d F0R 4ny REasoN.</p>";
$lang['cancellinktext'] = "h3r3";
$lang['failedtoupdateforumsettings'] = "f4il3d +o upD@+3 phorUm \$ET+ings. plE4\$3 tRY 4G4in latEr.";
$lang['moreadminoptions'] = "moRe 4dMin oPt10N\$";

// Admin Log data (admin_viewlog.php) --------------------------------------------

$lang['changedstatusforuser'] = "ch4n9eD User \$+4+U\$ Ph0R '%s'";
$lang['changedpasswordforuser'] = "chAn9ed p4s5worD f0r '%s'";
$lang['changedforumaccess'] = "cH@n9eD f0ruM 4CCE\$S p3rm1\$sION5 ph0R '%s'";
$lang['deletedallusersposts'] = "d3LEt3D 4LL po\$+s F0r '%s'";

$lang['createdusergroup'] = "cr3@tED u53r group '%s'";
$lang['deletedusergroup'] = "deletED U\$er 9roup '%s'";
$lang['updatedusergroup'] = "uPd@+ed u\$3r group '%s'";
$lang['addedusertogroup'] = "add3D u\$er '%s' +0 GroUp '%s'";
$lang['removeduserfromgroup'] = "r3M0V3 u\$er '%s' fr0M 9rOUP '%s'";

$lang['addedipaddresstobanlist'] = "aDd3d 1P '%s' +o 8@n l1s+";
$lang['removedipaddressfrombanlist'] = "reM0V3d ip '%s' phrom 8An list";

$lang['addedlogontobanlist'] = "aDd3D l0G0n '%s' t0 8@n L1st";
$lang['removedlogonfrombanlist'] = "rEM0Ved lo90n '%s' From b4n LI\$T";

$lang['addednicknametobanlist'] = "add3D n1Ckn4m3 '%s' +0 B4N l1s+";
$lang['removednicknamefrombanlist'] = "rem0v3D nicKn4mE '%s' phr0M ban Lis+";

$lang['addedemailtobanlist'] = "aDD3d em41L 4ddr3s\$ '%s' +0 bAN li\$+";
$lang['removedemailfrombanlist'] = "rEm0V3D 3m@il 4DDrEss '%s' From B@n lIst";

$lang['addedreferertobanlist'] = "adDED r3PH3R3R '%s' to B4n l1\$T";
$lang['removedrefererfrombanlist'] = "r3moV3d r3fEr3r '%s' fr0M 84n List";

$lang['editedfolder'] = "eDI+3D pholDEr '%s'";
$lang['movedallthreadsfromto'] = "m0VED 4LL +hr3ADS fr0M '%s' t0 '%s'";
$lang['creatednewfolder'] = "crE@t3D N3W phold3R '%s'";
$lang['deletedfolder'] = "d3L3T3d ph0LDer '%s'";

$lang['changedprofilesectiontitle'] = "cHan9eD pr0PhilE sECtiOn +ITLE from '%s' +0 '%s'";
$lang['addednewprofilesection'] = "added n3W prOFIl3 S3C+ion '%s'";
$lang['deletedprofilesection'] = "deLETED pR0FiL3 seCTion '%s'";

$lang['addednewprofileitem'] = "adD3D n3W pr0f1le 1tEm '%s' +0 sec+10N '%s'";
$lang['changedprofileitem'] = "ch@nGED pr0PH1le i+em '%s'";
$lang['deletedprofileitem'] = "deL3teD pr0fIL3 ITEm '%s'";

$lang['editedstartpage'] = "edI+Ed st4Rt P@g3";
$lang['savednewstyle'] = "s4veD n3w stYl3 '%s'";

$lang['movedthread'] = "m0veD +hre4D '%s' phr0m '%s' t0 '%s'";
$lang['closedthread'] = "cLosed thr34d '%s'";
$lang['openedthread'] = "op3NED +hRE4d '%s'";
$lang['renamedthread'] = "r3N4m3d thre4D '%s' +o '%s'";

$lang['deletedthread'] = "dElE+eD +hrE4d '%s'";
$lang['undeletedthread'] = "unDELetED +hr3AD '%s'";

$lang['lockedthreadtitlefolder'] = "lOCk3D +hre4D 0PTi0N5 ON '%s'";
$lang['unlockedthreadtitlefolder'] = "unlOCk3D thr3@D optIONs 0n '%s'";

$lang['deletedpostsfrominthread'] = "del3+3D p0s+\$ phrom '%s' in +hr3aD '%s'";
$lang['deletedattachmentfrompost'] = "d3LEt3D attaCHm3nt '%s' phr0M post '%s'";

$lang['editedforumlinks'] = "ed1teD ph0Rum l1NK5";
$lang['editedforumlink'] = "edItED phorUm lINK: '%s'";

$lang['addedforumlink'] = "aDdED f0rUm link: '%s'";
$lang['deletedforumlink'] = "dEl3+ED phorUm l1NK: '%s'";
$lang['changedtoplinkcaption'] = "cH4nG3d t0P l1Nk C@p+i0N fr0M '%s' +o '%s'";

$lang['deletedpost'] = "deL3t3d p0s+ '%s'";
$lang['editedpost'] = "eDI+ED po\$+ '%s'";

$lang['madethreadsticky'] = "mad3 +hread '%s' st1Cky";
$lang['madethreadnonsticky'] = "m4D3 +HR3aD '%s' N0N-st1CkY";

$lang['endedsessionforuser'] = "eNded se5Si0n ph0R us3r '%s'";

$lang['approvedpost'] = "apPRov3D p0\$+ '%s'";

$lang['editedwordfilter'] = "eD1TEd w0rD Filt3R";

$lang['addedrssfeed'] = "aDd3d rss ph3ed '%s'";
$lang['editedrssfeed'] = "eDiteD rs\$ ph3Ed '%s'";
$lang['deletedrssfeed'] = "deLEtED Rs\$ PhEED '%s'";

$lang['updatedban'] = "uPdat3D 84n '%s'. Ch@nGEd +ype phR0m '%s' +0 '%s', chan9ED d@+4 fr0M '%s' +o '%s'.";

$lang['splitthreadatpostintonewthread'] = "spL1+ +hre4D '%s' A+ P0st %s  1n+o nEw +hrE@D '%s'";
$lang['mergedthreadintonewthread'] = "m3R93D threaDs '%s' 4nd '%s' 1nto nEw thrE4D '%s'";

$lang['approveduser'] = "aPpr0VED U\$ER '%s'";

$lang['forumautoupdatestats'] = "f0RUM 4u+0 upD@+3: \$TAT5 upd@+Ed";
$lang['forumautoprunepm'] = "fORUm 4U+0 UPD4te: pm pholdER\$ PrUnED";
$lang['forumautoprunesessions'] = "fOrum @U+o upDATE: sE\$Si0n\$ prUnED";
$lang['forumautocleanthreadunread'] = "f0rum 4uTo uPD4TE: +hrE4d uNre4d d4+4 cl3anED";
$lang['forumautocleancaptcha'] = "f0rum @uTO upD@+E: tExt-c@ptCh4 1M49Es Cl34neD";

$lang['adminlogempty'] = "aDm1n lo9 is 3MPty";

$lang['youmustspecifyanactiontypetoremove'] = "j00 mu\$T spECiphY @n @cT10n TYP3 +0 rem0v3";

$lang['removeentriesrelatingtoaction'] = "r3mov3 3N+ri3s r3l4+iNg +0 actioN";
$lang['removeentriesolderthandays'] = "rEm0ve 3n+r1Es 0LD3r th4N (d4Y\$)";

$lang['successfullyprunedadminlog'] = "sUcCes5phUlly prUn3D @Dm1n L0g";
$lang['failedtopruneadminlog'] = "f4il3d +o Prune @Dm1n l0G";

$lang['prune_log'] = "pRuNE lo9";

// Admin Forms (admin_forums.php) ------------------------------------------------

$lang['noexistingforums'] = "n0 EX1st1ng f0Rums ph0unD. t0 CREatE a new f0rum CliCK the '@dd new' 8U++on 8El0W.";
$lang['webtaginvalidchars'] = "we8+49 c4n ONly ConT41n uppErC4\$e @-Z, 0-9 anD unD3R\$C0RE CH@r4c+3rS";
$lang['databasenameinvalidchars'] = "dat@b@s3 n4ME CaN ONLy Cont41n @-z, @-z, 0-9 4ND under\$coR3 Ch4R@C+Er\$";
$lang['invalidforumidorforumnotfound'] = "inv4LiD phORUm FiD oR forum n0T f0UND";
$lang['successfullyupdatedforum'] = "sUcce5\$phULLy upd@tED phorum";
$lang['failedtoupdateforum'] = "fail3d +o uPD4+3 phorum: '%s'";
$lang['successfullycreatednewforum'] = "succ3S\$Fully CRe4+3d new f0RuM";
$lang['selectedwebtagisalreadyinuse'] = "the sEL3c+3D wEb+49 1\$ @lre4DY 1n USe. plE453 chOosE @no+h3R.";
$lang['selecteddatabasecontainsconflictingtables'] = "tH3 sElECted D4+4b4\$e c0N+@1n5 C0nPHLiC+iN9 +48Les. C0NPHl1c+INg T4BL3 n4MES 4R3:";
$lang['forumdeleteconfirmation'] = "are J00 \$Ur3 J00 w4Nt t0 D3L3TE 4Ll oph tEh s3leC+ED phorums?";
$lang['forumdeletewarning'] = "pleaSE n0+3 th@+ j00 canno+ reCov3r D3L3T3d ph0rUM\$. 0nCE d3LeTED 4 PH0rUM 4Nd all 0PH i+'\$ 4sSOC14+eD D4ta 1\$ p3rm4n3nTly Rem0VED from +hE dat48a53. 1F J00 D0 n0+ wi\$h +0 DeLeTE +hE sel3C+ed phorUmS pl3@se cl1CK C@nCEL.";
$lang['successfullyremovedselectedforums'] = "sUCC35\$FUlly d3LE+Ed \$3leCTED ph0rUm\$";
$lang['failedtodeleteforum'] = "fAil3D +0 D3L3+3D f0RUm: '%s'";
$lang['addforum'] = "aDd f0Rum";
$lang['editforum'] = "ed1t f0rUM";
$lang['visitforum'] = "v1Si+ ph0Rum: %s";
$lang['accesslevel'] = "acC3Ss l3Vel";
$lang['forumleader'] = "foRUm le4D3r";
$lang['usedatabase'] = "use D4t48as3";
$lang['unknownmessagecount'] = "uNknOwn";
$lang['forumwebtag'] = "f0RUm w3B+4g";
$lang['defaultforum'] = "d3fAUlt forum";
$lang['forumdatabasewarning'] = "pL34SE 3n5UR3 j00 sel3C+ +3H c0RR3C+ D@t4B@\$e WH3N CREat1n9 4 NEw f0rum. onCE Cr34+eD @ n3W phorUm C4nn0t BE m0v3d b3twEEn 4v@iL@8Le D@+4B4SE5.";

// Admin Global User Permissions

$lang['globaluserpermissions'] = "gl0b4L u53r P3rM1\$S1onS";

// Admin Forum Settings (admin_forum_settings.php) -------------------------------

$lang['mustsupplyforumwebtag'] = "j00 mu\$+ \$UpplY a f0ruM wE8+4G";
$lang['mustsupplyforumname'] = "j00 mU\$T suPply @ PH0ruM Name";
$lang['mustsupplyforumemail'] = "j00 mus+ \$UPply A ph0rUm em4il adDr3S\$";
$lang['mustchoosedefaultstyle'] = "j00 mu\$T choose @ D3pH@ul+ ForUm \$TYl3";
$lang['mustchoosedefaultemoticons'] = "j00 mu5+ Cho0\$e D3faul+ PHoruM Em0+1C0N5";
$lang['mustsupplyforumaccesslevel'] = "j00 mu\$T \$Upply 4 phorum 4CCEss l3v3l";
$lang['mustsupplyforumdatabasename'] = "j00 mu5t supPly 4 FoRuM D@+4B4\$3 n4Me";
$lang['unknownemoticonsname'] = "unkNown 3Moticon5 n4m3";
$lang['mustchoosedefaultlang'] = "j00 Mus+ ch00se @ D3fault ph0Rum l4n9U@93";
$lang['activesessiongreaterthansession'] = "aC+1ve s3SS10n T1m3ou+ C4nno+ B3 gR34+3R tH4N \$35S10n tim3OUT";
$lang['attachmentdirnotwritable'] = "at+aChM3N+ diReCTorY @nd \$y\$Tem TeMp0R4RY dir3c+0Ry / php.1ni 'uplo@D_Tmp_dir' mU\$T 8e wr1T4Ble 8Y +he W3B sErvER / php pr0cEss!";
$lang['attachmentdirblank'] = "j00 must \$upPLY 4 dIr3C+0Ry tO \$4v3 a+taCHm3N+\$ IN";
$lang['mainsettings'] = "m4IN s3t+ings";
$lang['forumname'] = "f0RUm name";
$lang['forumemail'] = "fORUM 3Ma1L";
$lang['forumnoreplyemail'] = "n0-REPly 3M41l";
$lang['forumdesc'] = "f0ruM D3sCriPtioN";
$lang['forumkeywords'] = "fORUM k3yworDs";
$lang['defaultstyle'] = "depH4Ult STyle";
$lang['defaultemoticons'] = "d3Fault 3mo+iCon5";
$lang['defaultlanguage'] = "dEph4ul+ l4ngu49e";
$lang['forumaccesssettings'] = "foRUm @CCES5 SEttin95";
$lang['forumaccessstatus'] = "f0RUM @ccEs\$ s+@TU\$";
$lang['changepermissions'] = "ch4NG3 p3rmI5siOns";
$lang['changepassword'] = "cH4n93 P4s\$w0rD";
$lang['passwordprotected'] = "p@5\$WOrD pr0+3CtED";
$lang['passwordprotectwarning'] = "j00 h@vE n0+ 53T 4 phoruM p@ssw0RD. if j00 D0 no+ 53t 4 Pas\$W0rd +hE pAssw0RD pro+3C+10N fUnct10N@litY w1LL 83 4U+oM4+1c4Lly Dis@8LeD!";
$lang['postoptions'] = "p0St 0P+10n\$";
$lang['allowpostoptions'] = "alLow p05t 3ditIng";
$lang['postedittimeout'] = "p0St ED1+ +imE0Ut";
$lang['posteditgraceperiod'] = "pO\$+ 3Di+ 9r@C3 p3RI0d";
$lang['wikiintegration'] = "wikiwiKi 1NTE9r@ti0N";
$lang['enablewikiintegration'] = "eN4bl3 w1K1wik1 1NTE9r@+i0n";
$lang['enablewikiquicklinks'] = "en48le W1kiW1KI qu1CK l1Nk\$";
$lang['wikiintegrationuri'] = "w1KIW1KI LoC4+Ion";
$lang['maximumpostlength'] = "m4Ximum post leng+h";
$lang['postfrequency'] = "pos+ Phr3QU3ncy";
$lang['enablelinkssection'] = "eN4BlE links S3C+10N";
$lang['allowcreationofpolls'] = "aLLOw CrE4+1ON of poLl\$";
$lang['allowguestvotesinpolls'] = "alL0w 9U3ST5 To v0+3 1n polLS";
$lang['unreadmessagescutoff'] = "uNrE4d M3\$\$4gEs CU+-0Phf";
$lang['unreadcutoffseconds'] = "second\$";
$lang['disableunreadmessages'] = "di\$4bl3 uNr34D me5\$@gEs";
$lang['thirtynumberdays'] = "30 days";
$lang['sixtynumberdays'] = "60 D@ys";
$lang['ninetynumberdays'] = "90 D4ys";
$lang['hundredeightynumberdays'] = "180 d4y\$";
$lang['onenumberyear'] = "1 y3ar";
$lang['unreadcutoffchangewarning'] = "depeND1ng 0n 53RVEr pErf0RM@nce AnD tHe num8ER 0F +hreaD\$ your F0rum\$ C0n+41n, CHan9INg +he unR3@D CuT-0FPh m@Y t@k3 sEver@L m1Nu+3s +0 Compl3TE. ph0r +H15 REAS0N 1t is r3Commend3d that j00 avoid Ch4n9iN9 thi\$ se++1ng wHil3 y0Ur ph0Rum\$ 4re 8Usy.";
$lang['unreadcutoffincreasewarning'] = "iNCreas1Ng +he Unr34d Cu+-0fPh wiLl r3SULt 1N +hrE4d\$ oldEr +h4n th3 CurrEnT CUT-0FPH 4PpE4R1N9 45 unr34d phOr 4lL u53r\$.";
$lang['confirmunreadcutoff'] = "aR3 j00 sur3 j00 want t0 CH4Ng3 the uNreAD Cut-OpHph?";
$lang['otherchangeswillstillbeapplied'] = "cLick1ng 'No' w1ll only c@nC3l +h3 unrEaD Cu+-ophf ch4ngEs. o+h3r ch4n93s y0u'v3 M4de w1Ll \$+1ll 83 \$4V3D.";
$lang['searchoptions'] = "s34rCh opti0Ns";
$lang['searchfrequency'] = "s3ArcH phrEqu3NCY";
$lang['sessions'] = "sESs10nS";
$lang['sessioncutoffseconds'] = "se\$s10n Cut ophph (SEC0nDs)";
$lang['activesessioncutoffseconds'] = "acTivE \$3S\$i0n Cu+ opHPH (sECoNDs)";
$lang['stats'] = "sT4+s";
$lang['hide_stats'] = "h1D3 S+4+\$";
$lang['show_stats'] = "sH0w s+4+s";
$lang['enablestatsdisplay'] = "eN@8le sta+s D1spl@y";
$lang['personalmessages'] = "peR\$0n@l m3ss4G3S";
$lang['enablepersonalmessages'] = "eN48LE pErs0n@L ME5\$49e5";
$lang['pmusermessages'] = "pm M3Ss4g3s P3R U53r";
$lang['allowpmstohaveattachments'] = "alLow pErs0n@L mess493s to H4v3 at+@CHmEnt5";
$lang['autopruneuserspmfoldersevery'] = "au+o PRun3 u\$er's PM phOLDERs 3VEry";
$lang['userandguestoptions'] = "u\$3r @nD gU3s+ oP+i0n5";
$lang['enableguestaccount'] = "eNa8le 9UE5+ ACc0unt";
$lang['listguestsinvisitorlog'] = "li\$t gu3\$+5 in ViS1toR L09";
$lang['allowguestaccess'] = "alLow Gu3\$+ 4cc35s";
$lang['userandguestaccesssettings'] = "us3R @nd gu3St 4CCE\$S se+T1ngs";
$lang['allowuserstochangeusername'] = "alL0w us3R\$ to CH4NG3 u\$ern4M3";
$lang['requireuserapproval'] = "r3QuIrE Us3r 4PproVaL 8Y 4dmiN";
$lang['requireforumrulesagreement'] = "rEquir3 User to A9r33 +0 fORUm rUlEs";
$lang['enableattachments'] = "en@blE 4++4CHMent5";
$lang['attachmentdir'] = "atT4cHM3n+ D1r";
$lang['userattachmentspace'] = "att4chm3nT sp4CE pEr uSER";
$lang['allowembeddingofattachments'] = "alL0w EMBEDdin9 opH @++4CHmEn+\$";
$lang['usealtattachmentmethod'] = "uSe @l+erN@Tiv3 A+T4chm3Nt meThoD";
$lang['allowgueststoaccessattachments'] = "aLl0W GU3S+s to acCEs\$ 4T+4CHments";
$lang['forumsettingsupdated'] = "foRum \$ettin9\$ SUcCEssfUlly upd4T3D";
$lang['forumstatusmessages'] = "f0RUm 5T@+u\$ M3Ss4g3s";
$lang['forumclosedmessage'] = "f0ruM CloseD mess4G3";
$lang['forumrestrictedmessage'] = "f0Rum rEstric+3D m3ssa93";
$lang['forumpasswordprotectedmessage'] = "f0RUm P4\$sW0rd pr0+3c+3d mess493";

// Admin Forum Settings Help Text (admin_forum_settings.php) ------------------------------

$lang['forum_settings_help_10'] = "<b>poSt ED1+ +ime0ut</b> I\$ +hE +1M3 1N MInutes AfTEr p05+1Ng +h4T 4 UseR C4n 3DI+ +He1R p0s+. 1F \$3+ +0 0 +H3re iS No l1MI+.";
$lang['forum_settings_help_11'] = "<b>m@Ximum P0\$+ l3n9+h</b> 1s +h3 mAx1mum numB3R 0F Ch@r4CTErs +h@t will 83 Di\$pl@yeD in 4 p0\$+. 1f 4 pos+ IS lONGer +h@n +hE numB3R oph CH@r@Cters D3fInED h3RE 1+ wiLl 83 cU+ \$hoRT 4Nd 4 l1nK 4ddeD +0 t3H B0++0m to ALLOw users +0 re4D th3 wHol3 po5+ 0n @ 53pAratE p4ge.";
$lang['forum_settings_help_12'] = "iPH j00 d0N'+ w@nt yoUr users +o 8e @8lE t0 cR34+e polLS j00 C@n Dis@8LE +hE @8Ov3 0pt10N.";
$lang['forum_settings_help_13'] = "t3h L1nk\$ 5ecTion of 8eEH1v3 pr0VIDES @ pl4CE f0r YOur UsErs +0 MA1n+@IN @ L1\$t 0Ph s1+3\$ th3Y phr3qU3n+ly V1si+ +H4+ o+HEr usEr\$ m4y Find uSEphul. L1nks cAN 83 D1VID3D 1n+o CAtE90rIE5 By ph0lDEr 4nd 4Llow f0r c0mmen+s 4nd r@t1ngS +0 B3 91v3n. 1n ord3r +0 m0D3r4+e tEH link\$ SEcTi0n @ useR Mu\$t Be r4n+ed gl0Bal M0d3r4t0R sT@tu5.";
$lang['forum_settings_help_15'] = "<b>se\$s10N CUt ofph</b> 1s +he m4X1MUm +1ME B3fOR3 4 U\$3r'\$ s3ss1on i\$ D3eMed D34d 4ND th3y @Re logGeD oUt. 8Y D3F4Ul+ +h1\$ i\$ 24 h0Urs (86400 seconD5).";
$lang['forum_settings_help_16'] = "<b>ac+1VE sessI0N CU+ 0fph</b> 1\$ thE m4x1muM +iM3 83fore @ UsEr's SESsi0n 1S d3Em3d 1n4CTiv3 4t wHicH p01nt +hEy Enter 4N 1dl3 \$TATe. in th1\$ \$T4+3 +HE u5er r3MA1nS l0993D in, BU+ +H3Y @r3 R3M0v3d phrom +h3 4CtivE u53r\$ l1st iN +hE s+@+s d1spl4y. 0Nce +HEY b3COm3 aCtive 4g41N they Will 83 r3-4dd3d T0 +3H l1sT. 8Y D3Fault +HiS \$3T+in9 i\$ SE+ +O 15 M1nu+3S (900 seconds).";
$lang['forum_settings_help_17'] = "eNABLin9 th1\$ opTion @llows B3eh1v3 To 1NCLUD3 4 5+4t\$ DispL@y @+ th3 8O+t0m oph +3h mEsSa93s p@nE \$1m1L4r +0 +3h 0N3 UsED 8Y many forUm \$0ph+w4Re t1+L3s. ONC3 3N@BLed +hE D1\$pl4y 0F +He \$+4+s P@g3 C@n 83 tog9lED 1NdIviDu4LLy 8y E4CH usEr. iF +hey don't w@n+ to SE3 1+ THEy c4n hide 1+ fr0m vi3w.";
$lang['forum_settings_help_18'] = "peR\$0n4l mEss49es 4rE iNv4Lu@8LE 4\$ a W4Y 0ph taK1nG m0re priv4+3 m4++Ers ou+ 0Ph v1EW 0ph TH3 0thEr m3Mb3r\$. hOw3VEr Iph j00 d0N'+ w4N+ Y0Ur Us3rs +0 83 48l3 +o senD e4CH 0thEr pErs0N@l MEss4G3s j00 c@n Dis@8lE +H1S opt10n.";
$lang['forum_settings_help_19'] = "p3rsON4l m3\$\$@GEs caN @lso C0n+4in 4++4CHm3Nts wH1cH cAn BE UsEphUL f0R 3xch@ng1N9 fil3s 8ETw3en Us3rs.";
$lang['forum_settings_help_20'] = "<b>n0Te:</b> +hE sp@CE 4ll0C4tioN F0r PM att4chm3Nts 15 t@k3N fr0M eaCH us3Rs' Ma1N @++4ChmEnt @lloCA+1on @nD 1s N0t In aDDi+1ON to.";
$lang['forum_settings_help_21'] = "<b>en48l3 gu3S+ 4CCOUnT</b> @llOws vi\$It0RS t0 br0w\$3 y0Ur PhOrUm 4Nd rE@D p05+s wI+h0Ut REg1\$+erING @ usEr 4Ccoun+. 4 UsER @CC0unt iS \$t1ll r3qUir3D iF +HEy w1Sh +0 p0\$t 0r CH4ngE U\$er PRefEr3NCes.";
$lang['forum_settings_help_22'] = "<b>l1\$T gu3s+\$ iN Visi+Or l0G</b> 4ll0W\$ J00 +O \$PeC1fy wH3+h3R 0r N0t unrE915+EReD us3Rs ar3 lIsted On Th3 VIs1+Or Log @lon9 Sid3 R3g1s+3RED uSer\$.";
$lang['forum_settings_help_23'] = "b3EH1V3 @ll0Ws 4t+4ChM3nts To 8E uPl0AdEd +o M3ss49ES WH3n PO\$+ed. IPh J00 h4v3 l1M1+ED W3b \$p4C3 J00 m@Y whiCh +O dIS4bLE @+t4cHMeNT\$ bY cl34r1N9 t3h B0x 480V3.";
$lang['forum_settings_help_24'] = "<b>a++@Chm3Nt Dir</b> 1\$ t3H loc4+10n B33h1V3 sh0uLd 5+0re I+'S at+@ChM3nts iN. th1S Dir3c+0ry must ex15+ on yoUr wEB sp4CE and mus+ Be wrI+4BLE BY Th3 WEB s3rVeR / php Pr0CEss 0ThErwi53 uplo4D\$ w1ll f4il.";
$lang['forum_settings_help_25'] = "<b>aT+AChm3N+ \$P4c3 P3r U53R</b> iS t3h m4X1Mum 4M0UNt 0PH D1\$K sp@CE 4 uS3r h45 pHor @t+4ChmEnts. 0nCe +his spaC3 1S UseD uP +3h U\$ER c@Nn0+ upLo@d ANY m0rE 4t+@CHm3NTS. by D3faUlt th1s is 1mB 0ph 5PAC3.";
$lang['forum_settings_help_26'] = "<b>aLlow emBeDD1ng 0ph 4T+@CHmEnt5 1n m3Ssa93\$ / Si9n@tUr3S</b> @lL0w\$ user\$ +0 eM83d 4t+@chmEn+5 in p05+s. 3NaBL1N9 +h1\$ 0pt1ON wh1LE U\$3phul c@N iNcre4\$e yoUr B4NDW1DTh Us49E DRast1C4lly unDEr cEr+@1n COnf1gur4+i0N\$ 0f Php. If j00 H4ve l1m1+eD BandwID+h 1+ is r3commeNDED th@+ j00 d154Ble +h1s OP+10n.";
$lang['forum_settings_help_27'] = "<b>us3 4lt3rn@+iVE 4++4chment mEth0D</b> Ph0RCEs 8E3hive +0 us3 AN 4LtErn4t1VE rEtr13v4l meTH0D phor @tT4Chm3Nt5. if j00 r3CEiv3 404 3rr0R messa93s WHEn +RYIng t0 D0wnlo@D 4tt4ChmEn+\$ FR0m m3s\$A935 Try 3na8l1N9 this 0p+10n.";
$lang['forum_settings_help_28'] = "thI5 53++ing alLows y0uR Forum to BE \$pID3rED BY s34rch Engines L1kE g0O9LE, al+4v1sta 4ND Y4Ho0. if J00 SW1+CH thi\$ 0p+10n 0PHf youR pHorum WilL nOt B3 1nCluD3D in tH3sE \$E4RCh 3n91Ne\$ r3sul+s.";
$lang['forum_settings_help_29'] = "<b>all0W new user rEg1s+R4tions</b> 4llows 0r Dis4Ll0W\$ +hE CrE4Tion of nEw uSER @CC0unts. \$e++1ng +h3 OPt1on To no COmpl3TEly d1S4BLE\$ ThE re91\$+R4Tion F0rm.";
$lang['forum_settings_help_30'] = "<b>enABlE wiKiw1ki 1NtEgr4+i0n</b> pr0vId3S wik1W0rd 5UPP0Rt iN your phoruM po\$+s. @ w1k1W0rd i\$ m4D3 up of tw0 0r m0R3 C0nc4TeN4+3d W0rds w1+h upp3RCAsE l3Tt3R\$ (0ph+3n refErrED t0 4S C@MElC4\$E). if j00 wr1+3 A w0RD +his W4y i+ WIll @u+om4t1CALly b3 ch4NgED iNTo 4 HYp3RlinK P0in+in9 +o Y0Ur ch0s3n WIkiwIK1.";
$lang['forum_settings_help_31'] = "<b>en4blE wik1wIki qu1CK l1nKS</b> En4BlEs +hE u\$E oph mS9:1.1 4ND u5er:l090n s+yle ex+endeD w1K1lInK\$ wH1CH cre4t3 HYpErl1nks +0 thE sp3cIPHI3D mEs\$49E / uSer proFIL3 0F the sp3Cif1ed u\$er.";
$lang['forum_settings_help_32'] = "<b>wik1W1K1 l0C4t10n</b> I\$ usED +o sp3CIphy +Eh Ur1 oF YOur wik1wiKi. wh3n 3nter1ng +3h Ur1 us3 <i>%1\$S</i> to 1NdiC4+E wh3rE In +Eh urI +eh w1k1worD 5h0uLD 4pp34R, i.3.: <i>h+tp://EN.w1k1PEDia.0r9/wiki/%1\$\$</i> W0uld link y0ur w1k1WOrd\$ tO %s";
$lang['forum_settings_help_33'] = "<b>f0RUm @CCE\$S S+4tuS</b> con+rols h0w usEr\$ M@Y ACCESs yOur ph0ruM.";
$lang['forum_settings_help_34'] = "<b>oPEn</b> W1Ll aLl0W @Ll U\$3rs and 9U3STs 4cCE5\$ +0 yoUr ph0RUM wi+h0Ut r3strICtion.";
$lang['forum_settings_help_35'] = "<b>cL0SED</b> pr3v3NT\$ @Cc3ss fOR 4ll User\$, wi+h +h3 Exc3PT10n OPH t3H Adm1n Who m4Y still @CC3ss teH 4Dm1n p4N3l.";
$lang['forum_settings_help_36'] = "<b>r3STR1cTED</b> all0Ws to sET 4 Lis+ 0ph u\$3r5 WHo @r3 4LLow3D @CC3Ss +0 your f0Rum.";
$lang['forum_settings_help_37'] = "<b>p4Ssw0RD pro+3C+ED</b> ALlOws j00 t0 \$3t 4 p4ssworD t0 9iVE 0ut +O u\$ers \$0 th3Y C@n @CC3\$S your phorUm.";
$lang['forum_settings_help_38'] = "wHEN sett1Ng r3STric+3d 0r p4Ssw0rD pr0+3C+eD M0de j00 w1Ll ne3d +0 s4v3 Your CH4n93s B3f0r3 j00 c@n Ch@nG3 th3 usEr AccE\$\$ prIviL393\$ 0R p4\$SWorD.";
$lang['forum_settings_help_39'] = "<b>Search Frequency</b> defines how long a user must wait before performing another search. Searches place a high demand on the database so it is recommended that you set this to at least 30 seconds to prevent \"search spamming\"fr0m killiN9 +3h serv3R.";
$lang['forum_settings_help_40'] = "<b>poS+ phr3qU3ncy</b> is +HE m1NIMUm +1M3 a us3R mU5T w4iT 83F0RE +HEy C4N Pos+ 4GA1N. +hi\$ s3++in9 4L\$0 aFfeC+\$ TEh Cr34+i0n oph p0lLs. \$ET +0 0 +0 D1s4Ble +3H ResTRict10N.";
$lang['forum_settings_help_41'] = "t3H 4Bov3 0pt10n\$ changE +hE d3ph@ulT V4lu3\$ Ph0r +eh u53r r391\$tr4+1ON pH0rM. WhEr3 4PplIC@8LE o+HeR \$E+t1nGS wiLL usE +hE ph0RUM's own D3FaulT sEt+1Ngs.";
$lang['forum_settings_help_42'] = "<b>pRev3n+ usE 0f DUpl1CA+e 3M@il 4DDrEsses</b> PhorCE\$ 8e3hiv3 t0 ChECk tEh u53R @CC0unts 494In\$T teh 3M@il 4DDREss +3h U\$3r is r3Gistering wi+h @nd pr0Mpts th3m t0 U\$3 4no+heR iph 1+ is alr34dy in U\$E.";
$lang['forum_settings_help_43'] = "<b>reqUIrE Em4il conFIrm@+I0n</b> WH3n EN4bleD wiLl send 4N 3m@IL +0 EACh n3W U5ER w1+H 4 liNk +H4T C@N B3 U53D +0 Conphirm Th3ir 3m4iL 4ddress. un+1l th3Y C0NphiRm Th31r 3M@il adDr3ss +hEy w1ll n0t BE 4BLE t0 po5+ unless +h31R us3R permissi0N\$ 4Re Ch@ngeD M@NUally 8y 4n @Dm1n.";
$lang['forum_settings_help_44'] = "<b>u5E +ext-c@ptCh4</b> pr353nts +eH n3w User W1+h @ m4N9l3D 1M@G3 whiCH +hey Must copy A nUmBer phRom in+0 @ text ph13ld 0n tH3 R39I\$TR4+I0n pHORm. usE +h1s 0p+i0n to pr3VENt 4Utom@Ted \$ign-up vi@ \$CR1pt5.";
$lang['forum_settings_help_45'] = "<b>t3XT-C@p+cH4 DIR3ct0RY</b> \$p3ciphies +3H loC@+i0n that b3eh1Ve wIll \$+0r3 i+'\$ TEXt-cap+Ch@ 1m4g3s 4ND phon+s in. th1s DiR3CtOry Mus+ be Wri+@bl3 8y teh w38 SERvER / PHp pr0C355 @nD must 8e 4cC3ssi8LE v14 h++p. @Ph+er j00 h4Ve 3NaBL3D +EXt-C@ptCh4 j00 Mu\$T upl0@D \$Ome tru3 typ3 fON+\$ inTO +3h fon+S SUB-d1r3C+0Ry 0PH y0ur m4in +exT-C@p+ch@ DIR3c+0ry 0+herWIse 83Eh1Ve W1LL SK1P T3H t3x+-c4p+ch@ DUrin9 u\$Er rE915Tr4+1on.";
$lang['forum_settings_help_46'] = "<b>Text Captcha key</b> allows you to change the key used by Beehive for generating the text captcha code that appears in the image. The more unique you make the key the harder it will be for automated processes to \"guess\"teH coDe.";
$lang['forum_settings_help_47'] = "<b>p0\$T EDIt gr4ce pEr1OD</b> @lLOW\$ J00 +o DefiNE 4 per10d 1N m1nut3S wher3 User\$ m@y eD1+ p0\$ts wi+H0U+ +eH '3D1+ED BY' +3x+ aPp34R1ng 0N the1R p05+s. iph \$3T +o 0 +he '3D1+3D By' text w1ll alW4ys 4pp34R.";
$lang['forum_settings_help_48'] = "<b>unR3@d M3Ssa9e\$ CU+-0Phph</b> \$p3C1ph13\$ h0w L0Ng m3Ss4Ges Rema1N Unre4D. thre4D\$ M0dIPHI3D N0 l4TEr th@n +he p3RI0D \$ELeCTED w1ll @U+om4+Ic4lLy @PPE4R 4s R3@d.";
$lang['forum_settings_help_49'] = "choo\$iNG <b>dis4BlE unrE4D mEss4Ges</b> will COmPletEly r3Mov3 UnRE4D m3\$S4g3s supp0rt 4ND rEm0V3 +He rElEv4Nt 0P+1oN5 PHr0M tHe D1SCUss10n +yp3 DRop d0Wn 0N TH3 +Hr3aD l1\$+.";
$lang['forum_settings_help_50'] = "<b>r3Quir3 U\$Er Appr0v@l 8y 4dM1n</b> 4LL0W5 j00 +o r3\$+r1C+ 4CCE\$S 8Y n3W Us3r\$ un+1L th3Y h@vE 8EEn 4ppRov3D 8Y @ m0D3r@+0r 0r 4DM1N. wi+h0Ut 4PProv4L 4 us3r CAnnO+ 4cCEss @ny @R34 0f thE 8E3HIVe f0RUm inst4ll4+I0N 1nClUDinG indiv1DU4l PH0rum\$, pm 1nB0X @nD my ph0Rum\$ sec+10nS.";
$lang['forum_settings_help_51'] = "u5e <b>closed mEsS4g3</b>, <b>res+R1ctED meSsage</b> anD <b>paSswOrd pr0TEC+eD m3Ss4G3</b> To CUstomIse +hE m35s@ge Di\$PL@yED wHen Us3r\$ @cC3ss y0UR ph0RUm 1n thE v4R10u\$ s+4+e\$.";
$lang['forum_settings_help_52'] = "j00 C4n us3 htmL in yOur m3Ss493s. hyp3rLink\$ @ND 3m4il 4DDr3S\$3s will 4Lso b3 AU+0m4+1cally CoNV3r+ed To l1Nk5. +o UsE th3 D3ph@ult 8E3h1V3 f0rUm m3SS493\$ CL3aR +3H f13lds.";
$lang['forum_settings_help_53'] = "<b>all0w u\$3rs t0 Ch4ng3 u\$Ern4M3</b> peRMIts @lrE4dy r391\$+er3D Us3rs T0 CH4nGE th31r u\$ern@ME. When en48leD j00 can Tr4CK tHE Ch4NgEs 4 u\$er M4kes +0 thE1R u\$ern@Me v14 the 4DMIn us3R +00Ls.";
$lang['forum_settings_help_54'] = "u\$3 <b>fOrum rUles</b> TO 3Nt3R 4n @Ccep+@8Le UsE pOliCy +H4+ 3AcH User mUs+ @Gr3e +o 8Eph0re re9iSTerIng on your pHorUm.";
$lang['forum_settings_help_55'] = "j00 C@n u\$E h+Ml In y0ur phoRuM ruL3S. hyP3rLinkS 4nd 3M4il 4dDR3ss3s WilL @LS0 b3 @u+0M4t1C4lly C0NvErTed +0 L1nkS. t0 USe +he DEf4Ul+ 8eEhIVe F0rUM @up Cle4R +He fiElD.";
$lang['forum_settings_help_56'] = "u\$3 <b>n0-R3pLY 3m@il</b> to Sp3CIpHY 4N emA1L addrE\$\$ +h4+ D0ES no+ 3X1\$T 0R W1lL no+ 83 Moni+or3D ph0r REplie\$. ThiS 3m4Il 4DDR3\$S WIll 83 Us3D 1n +eh He4d3R5 phor @Ll EM4IL\$ \$3nT phRom Y0ur fORUm inclUd1N9 8ut NoT lIm1+3D +0 p0ST 4nD pm noTIFiC@+10n\$, u5eR 3MailS and P4\$\$WoRd rEM1NDer\$.";
$lang['forum_settings_help_57'] = "it 1S Rec0MMenD3D th@+ j00 uS3 4N eMa1L 4dDR3sS thAt Doe5 not exi\$T t0 hElp CU+ D0wn oN \$P@m +h@+ m@y Be DIrect3D a+ y0Ur m41N forUm Em41L 4dDre\$S";

// Attachments (attachments.php, get_attachment.php) ---------------------------------------

$lang['aidnotspecified'] = "a1D N0t sp3C1phi3d.";
$lang['upload'] = "uPL04D";
$lang['uploadnewattachment'] = "upL04d n3w 4+t4Chm3Nt";
$lang['waitdotdot'] = "w@It..";
$lang['successfullyuploaded'] = "sucCE\$SFully upLo@Ded: %s";
$lang['failedtoupload'] = "fAIL3d +o Upl04d: %s";
$lang['complete'] = "coMPLE+E";
$lang['uploadattachment'] = "upl04D @ pHil3 ph0R 4+TaCHm3nt t0 +Eh mEss49E";
$lang['enterfilenamestoupload'] = "eN+3R Phil3N4m3(S) +0 UpL04d";
$lang['attachmentsforthismessage'] = "aT+ACHmEnTs f0R th1\$ MEss@gE";
$lang['otherattachmentsincludingpm'] = "o+Her @+t4Chm3nTs (1nClUDing pM Mes5@GEs 4nD o+her ForuMs)";
$lang['totalsize'] = "tOt4l \$1ze";
$lang['freespace'] = "fRE3 \$P4c3";
$lang['attachmentproblem'] = "therE w4s @ pr0bLEm dowNlo4DIng thI\$ @t+4ChmENT. pl3@5e +ry 4g41n L4+3r.";
$lang['attachmentshavebeendisabled'] = "a+T@Chm3NT\$ h4v3 83eN D1\$4BlED BY +3H f0rUm 0wn3r.";
$lang['canonlyuploadmaximum'] = "j00 c4N only uplo@D @ maximUm oph 10 f1L3s @+ 4 t1ME";
$lang['deleteattachments'] = "dELEt3 4T+4chmEnt5";
$lang['deleteattachmentsconfirm'] = "aR3 j00 SUR3 j00 w4n+ t0 D3l3T3 +HE \$EL3c+3d 4++4chm3N+\$?";
$lang['deletethumbnailsconfirm'] = "aR3 J00 5ur3 j00 w@n+ +0 Del3+3 +h3 S3lec+3D @ttachm3Nt\$ +huM8n4ILs?";

// Changing passwords (change_pw.php) ----------------------------------

$lang['passwdchanged'] = "p4s\$wORD ChAn9Ed";
$lang['passedchangedexp'] = "y0uR p@ssW0rD haS 8e3n Chan93D.";
$lang['updatefailed'] = "upd4+E f41led";
$lang['passwdsdonotmatch'] = "p45\$WorDs Do no+ m4TCh.";
$lang['newandoldpasswdarethesame'] = "neW 4ND 0lD passworD\$ 4re +He 54m3.";
$lang['requiredinformationnotfound'] = "r3qu1Red inf0RM4+i0n no+ PHOund";
$lang['forgotpasswd'] = "f0R90t p4s\$WorD";
$lang['resetpassword'] = "rEset pasSWord";
$lang['resetpasswordto'] = "r3S3+ p4ssw0rd +o";
$lang['invaliduseraccount'] = "inV4l1D u\$3r 4CCouNt sp3C1f13d. ch3CK EMa1l for C0RREc+ l1nk";
$lang['invaliduserkeyprovided'] = "inv@l1D U\$er KEY provIDED. CheCK eM41L PHor Corr3CT l1nk";

// Deleting messages (delete.php) --------------------------------------

$lang['nomessagespecifiedfordel'] = "n0 mess493 5P3C1F13D F0r DEl3T10n";
$lang['deletemessage'] = "d3LetE mE5\$@GE";
$lang['postdelsuccessfully'] = "p0St del3+ed \$uCCe5SFUlly";
$lang['errordelpost'] = "eRror d3l3+Ing po\$T";
$lang['cannotdeletepostsinthisfolder'] = "j00 c@nnot DElE+E post5 1n +h1\$ F0ld3R";

// Editing things (edit.php, edit_poll.php) -----------------------------------------

$lang['nomessagespecifiedforedit'] = "n0 mEssage \$P3c1Phi3D f0r EDi+ing";
$lang['cannoteditpollsinlightmode'] = "c4Nno+ 3D1+ pollS in l19HT m0De";
$lang['editedbyuser'] = "eDI+Ed: %s 8y %s";
$lang['editappliedtomessage'] = "eD1+ 4PPlieD +o m3Ss49e";
$lang['errorupdatingpost'] = "erR0r UpD4+In9 p0\$t";
$lang['editmessage'] = "ed1+ mEssa93 %s";
$lang['editpollwarning'] = "<b>n0+e</b>: 3ditIng CER+4In 4speCt\$ oph 4 poll WIll v01d 4lL +H3 cUrr3N+ v0TEs @nd @ll0W pE0Pl3 +O V0+3 @9@iN.";
$lang['hardedit'] = "h4Rd 3d1+ 0P+i0Ns (votes will 83 R3set):";
$lang['softedit'] = "s0Ph+ eDit 0pt10N5 (v0+3s w1ll 8E r3TA1NeD):";
$lang['changewhenpollcloses'] = "ch4nge wh3n +h3 p0ll cL0\$3\$?";
$lang['nochange'] = "nO ch@n9E";
$lang['emailresult'] = "em41l Resul+";
$lang['msgsent'] = "mES5@GE \$En+";
$lang['msgsentsuccessfully'] = "m3sS49e SEN+ \$ucC3SsfUlly.";
$lang['mailsystemfailure'] = "m4iL sy\$tEm pha1LUR3. mEss4gE n0T sent.";
$lang['nopermissiontoedit'] = "j00 ARe N0+ p3rM1t+3D +0 ED1t +H1\$ MEss493.";
$lang['cannoteditpostsinthisfolder'] = "j00 Cannot 3d1T p05+S in +hiS f0lDEr";
$lang['messagewasnotfound'] = "mEsS493 %s was n0T phouND";

// Email (email.php) ---------------------------------------------------

$lang['sendemailtouser'] = "seND Em41l +0 %s";
$lang['nouserspecifiedforemail'] = "nO u5er speCiphi3D f0r Em4Iling.";
$lang['entersubjectformessage'] = "en+er a su8jEC+ pH0r +Eh MEsS@Ge";
$lang['entercontentformessage'] = "eN+3r \$0m3 ContEn+ f0r +EH M3ss4g3";
$lang['msgsentfromby'] = "tHis me\$S4gE w@\$ S3nT phR0M %s 8y %s";
$lang['subject'] = "sU8j3c+";
$lang['send'] = "sEND";
$lang['userhasoptedoutofemail'] = "%s H@s opt3D ou+ 0F 3M4il COn+4Ct";
$lang['userhasinvalidemailaddress'] = "%s h4s 4n inv4L1d ema1L addrE5\$";

// Message nofificaiton ------------------------------------------------

$lang['msgnotification_subject'] = "me5\$4ge no+iph1C4t10n phrom %s";
$lang['msgnotificationemail'] = "heLL0 %s,\n\n%s p0sT3d @ m3Ss4gE t0 j00 oN %s.\n\nTh3 SU8J3c+ is: %s.\n\n+0 r3aD +h4+ m3S\$@9e 4nD 0+h3Rs In +hE s@me DIsCu\$S1ON, 90 to:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nN0t3: 1f j00 D0 NO+ w1sh t0 reC31ve 3mail No+1phic@+10Ns oph Ph0rum MEs\$4G3\$ po\$T3d to yOU, 9o +O: %s Cl1Ck oN my c0n+rol\$ +H3n em41l AND pRIV4Cy, UnSELeCt +3h 3Ma1l nO+1Fic4Ti0n cheCk8oX @nd pr3SS subm1t.";

// Thread Subscription notification ------------------------------------

$lang['subnotification_subject'] = "sU8\$Cr1P+I0N n0tiphicat10n fr0m %s";
$lang['subnotification'] = "heLlO %s,\n\n%s po\$TED 4 M3ssagE 1n @ thr3ad j00 h4V3 sUBsCRi83d +0 on %s.\n\n+H3 \$UbjeC+ i\$: %s.\n\nT0 reaD +h4T m35\$4ge @nD 0Th3RS in +eh \$4m3 D1\$cUssion, G0 +o:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nNo+e: 1F j00 Do nO+ w1sh TO r3C31VE ema1l n0+iph1c@+10N\$ Of new ME5SA9Es In thi\$ THread, g0 to: %s 4nD 4Djust Y0ur 1nt3r3\$T l3vEl 4+ +he 80++om oph +eh P493.";

// PM notification -----------------------------------------------------

$lang['pmnotification_subject'] = "pm no+1phiC4tion fr0m %s";
$lang['pmnotification'] = "hEll0 %s,\n\n%s posted 4 pm +o j00 0N %s.\n\nThE sU8j3c+ is: %s.\n\n+0 R3aD +3H m3Ss49e g0 to:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nN0+e: 1Ph j00 d0 not w1\$h +0 rEceivE 3M@1l nO+ifIC@+I0n\$ 0f NEw pm messA93s po\$T3D +0 y0U, gO to: %s clICK mY c0ntR0l\$ tHEn em41l 4nD PrIvacy, uNs3L3c+ +he Pm N0+if1CAt10N ChEck8ox @ND pre5\$ su8mI+.";

// Password change notification ----------------------------------------

$lang['passwdchangenotification'] = "p455W0rd Ch4n93 N0TIpHIC4+I0N pHR0m %s";
$lang['pwchangeemail'] = "heLLo %s,\n\n+h1s 4 n0T1f1Cat10n em4il tO 1nf0rm j00 Tha+ YOur p@\$SW0rD on %s h@\$ 8een cHan93d.\n\n1+ h@s B3En CH4nGED +o: %s 4nd w4s Ch@nGed By: %s.\n\n1f j00 h4V3 r3c31ved +hIs em@1l in 3RR0r oR wEr3 not 3xpeC+1N9 4 CHan9E T0 y0Ur p4ssw0RD plE4\$3 Con+4C+ t3H phORum owner or a Moder4+or 0n %s imm3D14+ely tO C0RR3ct 1+.";

// Email confirmation notification -------------------------------------

$lang['emailconfirmationrequiredsubject'] = "em@1L C0nphirm@+10n REqUIrEd phor %s";
$lang['confirmemail'] = "hELlo %s,\n\nYOU rEC3N+ly Cr3at3d @ n3W U\$er acC0Unt 0N %s.\nbEphore J00 CaN star+ po5+1N9 WE n3ED +0 confIRM y0uR 3m@il 4DDrEss. DOn'+ woRry THI5 i\$ qUitE E45Y. @lL j00 ne3D +0 D0 1s Click tH3 liNk 8El0W (0r Copy 4nD p@s+e 1+ in+0 Y0UR 8r0W53r):\n\n%s\n\nonC3 C0nphirm4+10n i\$ complet3 j00 m4y lo9in AnD Start p05+1n9 1Mmed14T3LY.\n\n1f j00 did NOt cre4+e 4 User 4Cc0unt on %s please aCCep+ 0ur 4pologies 4nd pH0rwARD +h1s 3m@1l tO %s 5o +hat TEH \$0Urc3 0Ph iT m4y Be 1nVEs+ig4Ted.";
$lang['confirmchangedemail'] = "hElL0 %s,\n\nY0u r3c3NTLy Ch@n93d Y0ur em41l 0n %s.\n83f0re j00 CAN starT po\$+1n9 ag4in W3 ne3d +0 C0NPH1rm yoUr nEw em4IL 4DDRE5\$. don't w0rRy th1S i\$ QU1+e 3asy. @ll J00 nE3D t0 Do 1\$ cliCk +he L1Nk 83l0W (0R C0pY 4ND past3 i+ in+0 y0Ur Br0w\$eR):\n\n%s\n\noNCE conPH1rm@tIon i\$ compl3t3 j00 m4y C0n+1nu3 to U\$3 The f0rum AS norM4L.\n\nif J00 W3R3 no+ 3Xp3Ctin9 +h1s 3M@1l Phrom %s pLE4\$E @cc3Pt ouR 4pologies 4ND f0rw4RD +h15 3M41L t0 %s s0 tH@+ +he SourCe 0f It m4y be 1nVEst1gaT3D.";


// Forgotten password notification -------------------------------------

$lang['forgotpwemail'] = "heLlo %s,\n\nYOu r3qUestEd +h1\$ 3-ma1L phr0M %s 83C@UsE j00 havE f0rgo++3N your p@ssw0Rd.\n\ncLICk Th3 l1nk 8el0w (0r copy 4nD p4St3 1T Into youR BrOw\$3R) to resEt yoUr p@\$\$w0rD:\n\n%s";

// Forgotten password form.

$lang['passwdresetrequest'] = "your P4\$SWorD r3set r3qu35+ phrom %s";
$lang['passwdresetemailsent'] = "p45\$Word re53+ e-m41l sen+";
$lang['passwdresetexp'] = "j00 sh0uLD shortly r3c31ve @n e-m4il cont4Inin9 1N5+rUCTi0N5 Ph0r reset+ing your p4S\$W0RD.";
$lang['validusernamerequired'] = "a V4liD u53rn4M3 1s r3Qu1r3D";
$lang['forgottenpasswd'] = "f0r9O+ p4SSWORD";
$lang['couldnotsendpasswordreminder'] = "coULd no+ 53ND p45\$Word r3M1nd3r. pl3ASe cOnt4C+ +hE ph0rum ownEr.";
$lang['request'] = "reQU3s+";

// Email confirmation (confirm_email.php) ------------------------------

$lang['emailconfirmation'] = "eMa1l C0nfirM@+10N";
$lang['emailconfirmationcomplete'] = "th4nk j00 f0R ConFirmiNg yOUr 3ma1L addR3S5. J00 m4y nOw l0gin @nD \$+4r+ p0\$+1ng imMed14+Ely.";
$lang['emailconfirmationfailed'] = "em41l C0nPhirM@+10n has f4il3d, pl3a53 +Ry 494In latEr. iPh j00 3nc0UntEr ThiS 3rroR multiplE +1m3S plE4se C0nt4C+ th3 Forum 0wner 0R @ mod3R4+0r f0R 4\$\$1\$T4NCE.";

// Links database (links*.php) -----------------------------------------

$lang['toplevel'] = "t0p LEV3L";
$lang['maynotaccessthissection'] = "j00 m@y N0t 4CC3sS +hi\$ sEC+10n.";
$lang['toplevel'] = "top L3vel";
$lang['links'] = "l1nks";
$lang['viewmode'] = "v13w m0D3";
$lang['hierarchical'] = "h13rarCh1Cal";
$lang['list'] = "liSt";
$lang['folderhidden'] = "tH1s f0lDer 1S h1DDEN";
$lang['hide'] = "h1d3";
$lang['unhide'] = "unH1DE";
$lang['nosubfolders'] = "nO SuBFolders in +h1\$ C4+Eg0rY";
$lang['1subfolder'] = "1 suBfolDer in +his c4t390ry";
$lang['subfoldersinthiscategory'] = "sUBf0lDEr\$ 1N this c4+Eg0ry";
$lang['linksdelexp'] = "eN+ri3s in 4 D3leteD ph0LDer w1ll 8e m0v3D to thE p@r3n+ phold3r. 0NlY ph0lDEr\$ Which Do not c0NT4in SUBPholdErs m4Y 8E D3LEteD.";
$lang['listview'] = "l1\$t V13w";
$lang['listviewcannotaddfolders'] = "c4Nn0+ @Dd PholD3r\$ in +h1\$ Vi3W. \$HOwing 20 3ntrIes 4t 4 +imE.";
$lang['rating'] = "r@+1NG";
$lang['nolinksinfolder'] = "n0 l1Nks 1N thI\$ Ph0lder.";
$lang['addlinkhere'] = "add LINk h3Re";
$lang['notvalidURI'] = "th4t I\$ N0t @ v@l1D Uri!";
$lang['mustspecifyname'] = "j00 mU\$T spEc1phY a n4mE!";
$lang['mustspecifyvalidfolder'] = "j00 mUs+ \$P3cify @ val1D folDer!";
$lang['mustspecifyfolder'] = "j00 must sp3Cify a f0lDEr!";
$lang['successfullyaddedlinkname'] = "sUccessfully ADdeD L1nk '%s'";
$lang['failedtoaddlink'] = "f4il3D +0 aDD lInk";
$lang['failedtoaddfolder'] = "f4il3D t0 adD f0lD3R";
$lang['addlink'] = "aDd 4 l1nk";
$lang['addinglinkin'] = "adDinG l1nk 1n";
$lang['addressurluri'] = "aDDR3sS";
$lang['addnewfolder'] = "adD a neW PholdEr";
$lang['addnewfolderunder'] = "adDin9 n3W phold3R unDEr";
$lang['editfolder'] = "eD1T f0lD3r";
$lang['editingfolder'] = "edit1ng ph0LDEr";
$lang['mustchooserating'] = "j00 Must cho0sE 4 R4+InG!";
$lang['commentadded'] = "yOur c0MMEnt w45 adD3D.";
$lang['commentdeleted'] = "c0Mm3n+ W@s D3L3teD.";
$lang['commentcouldnotbedeleted'] = "cOMMen+ CoUlD not b3 DEl3TED.";
$lang['musttypecomment'] = "j00 mUst tYP3 4 CoMment!";
$lang['mustprovidelinkID'] = "j00 mus+ pR0V1d3 4 l1nk 1d!";
$lang['invalidlinkID'] = "inval1D link iD!";
$lang['address'] = "aDdre\$S";
$lang['submittedby'] = "su8m1+t3d BY";
$lang['clicks'] = "clicks";
$lang['rating'] = "r4tiNG";
$lang['vote'] = "vo+E";
$lang['votes'] = "v0tes";
$lang['notratedyet'] = "not R4+3D 8y @ny0N3 Y3t";
$lang['rate'] = "r4te";
$lang['bad'] = "b4D";
$lang['good'] = "gOod";
$lang['voteexcmark'] = "v0+E!";
$lang['clearvote'] = "cl34R vOt3";
$lang['commentby'] = "c0Mm3n+ BY %s";
$lang['addacommentabout'] = "adD a comM3nt AB0U+";
$lang['modtools'] = "mod3r4+I0n toOLS";
$lang['editname'] = "eDit naMe";
$lang['editaddress'] = "eD1T 4dDR3Ss";
$lang['editdescription'] = "edIT DE\$CR1p+I0n";
$lang['moveto'] = "move T0";
$lang['linkdetails'] = "linK D3+@il\$";
$lang['addcomment'] = "aDd C0mm3NT";
$lang['voterecorded'] = "y0uR v0+E h4\$ beEn reCOrD3D";
$lang['votecleared'] = "your v0+3 h4\$ 8E3N Cl3arED";
$lang['linknametoolong'] = "lInk N@mE +0O l0N9. m@ximUm i\$ %s Char@CTErs";
$lang['linkurltoolong'] = "l1NK urL +o0 L0n9. m4X1mum i\$ %s Ch4r4C+Er\$";
$lang['linkfoldernametoolong'] = "f0LdEr n4m3 t00 l0N9. m@x1mum lEn9+h 1\$ %s chAR4CT3r\$";

// Login / logout (llogon.php, logon.php, logout.php) -----------------------------------------

$lang['loggedinsuccessfully'] = "j00 l0993d 1n 5UcCES\$fully.";
$lang['presscontinuetoresend'] = "preSS con+inU3 to r3\$enD ph0RM d4tA Or c4NCEL to RElo4D p@gE.";
$lang['usernameorpasswdnotvalid'] = "teH usern4M3 Or P4ssw0RD j00 supPli3d i\$ n0t v4LiD.";
$lang['rememberpasswds'] = "reM3m8Er p4S\$W0rds";
$lang['rememberpassword'] = "r3mEMBEr pAssworD";
$lang['enterasa'] = "eNT3R @\$ @ %s";
$lang['donthaveanaccount'] = "dOn't H4V3 @n @cC0UNT? %s";
$lang['registernow'] = "r3G1\$ter n0w.";
$lang['problemsloggingon'] = "pRo8L3m5 logging 0N?";
$lang['deletecookies'] = "deL3te co0KI3S";
$lang['cookiessuccessfullydeleted'] = "coOki3\$ 5UCCEssfullY delE+ED";
$lang['forgottenpasswd'] = "fOr9o+TEN your p4ssw0RD?";
$lang['usingaPDA'] = "usIng @ pD@?";
$lang['lightHTMLversion'] = "lI9H+ HTMl vErs10N";
$lang['youhaveloggedout'] = "j00 h@vE lo993d 0ut.";
$lang['currentlyloggedinas'] = "j00 4r3 CUrrently l0993d 1N 4s %s";
$lang['logonbutton'] = "lO9oN";
$lang['otherbutton'] = "other";
$lang['yoursessionhasexpired'] = "yoUR ses5i0n has ExpiR3d. j00 will N3ed +o l0Gin @g@iN +0 cON+inu3.";

// My Forums (forums.php) ---------------------------------------------------------

$lang['myforums'] = "my PhorUms";
$lang['allavailableforums'] = "alL @v@il@8L3 ph0RUMs";
$lang['favouriteforums'] = "f@VOUr1+3 phoRUM\$";
$lang['ignoredforums'] = "i9n0ReD f0Rum5";
$lang['ignoreforum'] = "iGn0re forUm";
$lang['unignoreforum'] = "unIgn0Re ForuM";
$lang['lastvisited'] = "l4\$T v1siteD";
$lang['forumunreadmessages'] = "%s unR3@d m3ssa935";
$lang['forummessages'] = "%s MEss4G3\$";
$lang['forumunreadtome'] = "%s UNreaD &quot;+O: Me&quot;";
$lang['forumnounreadmessages'] = "no Unr34D m3\$\$4gEs";
$lang['removefromfavourites'] = "rem0vE phrom ph@V0uri+e\$";
$lang['addtofavourites'] = "add To ph4VOUrites";
$lang['availableforums'] = "aV4il@8LE f0Rums";
$lang['noforumsofselectedtype'] = "th3r3 AR3 no PhoruMS of TH3 s3LeCT3D typ3 4Va1l@ble. pl3@s3 \$elect 4 D1ffER3nt TYpe.";
$lang['successfullyaddedforumtofavourites'] = "suCCEssfUllY 4DDED ph0RUm +0 ph4VOuRi+Es.";
$lang['successfullyremovedforumfromfavourites'] = "sUcce\$SPhUlly r3mov3D f0RUm From ph@v0URi+Es.";
$lang['successfullyignoredforum'] = "succE\$SFUlly IGn0red f0rUm.";
$lang['successfullyunignoredforum'] = "sucCe\$sphully UN1gnor3D foruM.";
$lang['failedtoupdateforuminterestlevel'] = "f41led +0 Upd@tE ph0rUm 1n+Er3st l3Vel";
$lang['noforumsavailablelogin'] = "tHERE ar3 n0 F0rUms 4V41l48le. plEase lo9IN to v1Ew yoUr ph0RUMs.";
$lang['passwdprotectedforum'] = "pa\$Sword prO+3cteD ph0RUM";
$lang['passwdprotectedwarning'] = "th1s foRUM i\$ p@\$SW0rD pRo+3c+3D. +0 941n @CC3S5 3NT3R t3h pas\$w0rd 8El0W.";

// Message composition (post.php, lpost.php) --------------------------------------

$lang['postmessage'] = "pOs+ Mess4g3";
$lang['selectfolder'] = "s3leCt F0ldER";
$lang['mustenterpostcontent'] = "j00 mu5+ 3N+Er 5omE COnt3Nt phoR TEh pos+!";
$lang['messagepreview'] = "m35s@ge prEv13w";
$lang['invalidusername'] = "iNV4l1D usern4me!";
$lang['mustenterthreadtitle'] = "j00 mu\$t eNT3r 4 +1+l3 foR the +hr34d!";
$lang['pleaseselectfolder'] = "plE4S3 sElECt 4 pholDER!";
$lang['errorcreatingpost'] = "err0r CRE@+Ing Pos+! pLe453 try @g@1n In 4 f3W minUt3s.";
$lang['createnewthread'] = "cR34+E new +hr34d";
$lang['postreply'] = "poS+ reply";
$lang['threadtitle'] = "thRE4d tI+L3";
$lang['messagehasbeendeleted'] = "mESSA93 n0+ F0UnD. ch3CK +h4T 1+ h4Sn'T 83en D3l3t3D.";
$lang['messagenotfoundinselectedfolder'] = "m35s493 n0t pH0uND in \$eL3C+ed pholDEr. ch3CK +h4t 1+ h4\$n't 8e3n m0V3d oR DEl3tED.";
$lang['cannotpostthisthreadtypeinfolder'] = "j00 canNo+ po\$T +h1S thr3@D typ3 1n tH@+ pholD3R!";
$lang['cannotpostthisthreadtype'] = "j00 C@nnOt po5+ tHis +hr34D +yp3 4S th3R3 ar3 no 4v@Il4BLe ph0LD3rs +h@+ alloW I+.";
$lang['cannotcreatenewthreads'] = "j00 c@nn0+ CrE4T3 n3w thr3@Ds.";
$lang['threadisclosedforposting'] = "thiS +Hre4D 1\$ cl0\$eD, j00 c@nn0+ po\$+ 1n 1+!";
$lang['moderatorthreadclosed'] = "w@rNinG: THI\$ +hr34D is cloS3d phoR p0\$t1NG +0 NormaL Us3Rs.";
$lang['usersinthread'] = "u\$3rs 1n +hread";
$lang['correctedcode'] = "c0RR3C+eD C0D3";
$lang['submittedcode'] = "sUbmi+tEd CoDe";
$lang['htmlinmessage'] = "h+ml iN M3sS4g3";
$lang['disableemoticonsinmessage'] = "d1S4Bl3 emOTiCon5 1n M3Ss4G3";
$lang['automaticallyparseurls'] = "aU+0m4tIC@lly par\$e uRL\$";
$lang['automaticallycheckspelling'] = "aUToM@+iC@lly CheCK spell1n9";
$lang['setthreadtohighinterest'] = "sEt thre4D to H1gh iN+3rest";
$lang['enabledwithautolinebreaks'] = "eN48l3d Wi+h @U+0-linE-8REaks";
$lang['fixhtmlexplanation'] = "tHIs f0rUm u\$3s html PH1Lter1n9. y0Ur \$ubm1+Ted h+Ml h4s BeEn m0D1ph13D by +hE fiL+3rs in \$0m3 w4Y.\\n\\n+0 v13w Y0UR or1Gin4l CoD3, \$el3Ct teH \\'\$UBMi+tED C0D3\\' R4D10 BU++on.\\n+o vi3W tEH M0d1F1ED CoDE, seL3Ct th3 \\'C0RR3C+3D cODE\\' r@di0 BUT+0N.";
$lang['messageoptions'] = "me\$sA93 0P+I0N5";
$lang['notallowedembedattachmentpost'] = "j00 @r3 n0T 4lL0W3D +o 3mB3d @++achm3nt\$ 1n y0ur po\$+s.";
$lang['notallowedembedattachmentsignature'] = "j00 4R3 nO+ @ll0W3D +0 3M83D 4t+@Chm3nTS 1N yoUr 5Ign4TUr3.";
$lang['reducemessagelength'] = "m3s\$@93 l3n9TH mu\$t 83 UnDEr 65,535 CHAr4CTERs (cuRrEN+ly: %s)";
$lang['reducesiglength'] = "s19n@+uRE L3NG+H mus+ B3 unDEr 65,535 ch@r4CtErs (curr3N+ly: %s)";
$lang['cannotcreatethreadinfolder'] = "j00 C4Nno+ cr34+e n3w Thre4dS 1n +HI\$ Ph0lder";
$lang['cannotcreatepostinfolder'] = "j00 C4nno+ r3plY t0 p0sts iN +h1\$ F0LD3r";
$lang['cannotattachfilesinfolder'] = "j00 c@nn0t post 4++4CHMEnts 1n thI\$ F0lDER. rEM0vE @++@Chm3N+\$ +o c0n+1nUe.";
$lang['postfrequencytoogreat'] = "j00 C4N 0nlY post onc3 3vEry %s \$ecoND\$. pl34se +ry 4Ga1N Later.";
$lang['emailconfirmationrequiredbeforepost'] = "eM41l C0nf1RM@T1on I\$ R3QUIr3D BEPhorE j00 Can p0s+. if j00 H4V3 n0+ reC31V3D 4 conf1RM@tion EM41l pLe4SE cl1ck +3h 8Utton BEL0w 4ND a nEw 0n3 will 8E sen+ +0 y0U. if yoUr 3m4il aDDR3S\$ N33d\$ CHan91NG plEasE do \$0 83forE requ3s+in9 4 nEw Conphirm@T10n 3m4il. J00 m@y CHan9E your 3m4IL 4dDR3\$\$ 8y ClICk my con+R0Ls @Bove 4nd +hen u\$er d3+a1ls";
$lang['emailconfirmationfailedtosend'] = "c0NF1rm@+1on 3M@il fa1LeD +o send. Pl34sE COn+@CT TeH phoruM 0wN3R +0 rECT1fy +h1S.";
$lang['emailconfirmationsent'] = "coNFirm4+I0n 3m41l haS 8een r3Sen+.";
$lang['resendconfirmation'] = "r3SEnd ConphiRM4+10n";
$lang['userapprovalrequiredbeforeaccess'] = "yOur u\$Er 4CC0un+ nEeD\$ T0 be @pPr0v3D 8y @ PHorUM 4DmiN BEPhoRE j00 can 4cc3Ss +EH r3Qu35+3d F0Rum.";

// Message display (messages.php & messages.inc.php) --------------------------------------

$lang['inreplyto'] = "iN R3ply +0";
$lang['showmessages'] = "shoW m3S\$@GEs";
$lang['ratemyinterest'] = "r4tE My 1ntEres+";
$lang['adjtextsize'] = "adju5+ +Ext s1z3";
$lang['smaller'] = "sM@ller";
$lang['larger'] = "l@r9Er";
$lang['faq'] = "f4q";
$lang['docs'] = "d0c\$";
$lang['support'] = "sUpp0rt";
$lang['donateexcmark'] = "d0nAT3!";
$lang['fontsizechanged'] = "f0Nt \$1zE ch4n9Ed. %s";
$lang['framesmustbereloaded'] = "fr@M35 must 83 r3lo@DeD m@nualLy +o seE ChAnges.";
$lang['threadcouldnotbefound'] = "tEh reqU35+ed +hr3@D C0UlD n0t BE f0UnD 0R @CC3\$S w4S DEn13D.";
$lang['mustselectpolloption'] = "j00 must sELEc+ @n 0p+i0N +0 Vo+3 For!";
$lang['mustvoteforallgroups'] = "j00 must vo+3 In Every 9Roup.";
$lang['keepreading'] = "k3EP reaDin9";
$lang['backtothreadlist'] = "b4Ck t0 threaD l1sT";
$lang['postdoesnotexist'] = "th4+ Po\$+ D0es not Ex1s+ in +hiS +hre@D!";
$lang['clicktochangevote'] = "clICk t0 CH4ngE v0tE";
$lang['youvotedforoption'] = "j00 Vot3D f0r 0p+i0n";
$lang['youvotedforoptions'] = "j00 v0+eD for 0P+10n5";
$lang['clicktovote'] = "cliCk +o V0t3";
$lang['youhavenotvoted'] = "j00 havE N0+ v0T3d";
$lang['viewresults'] = "vI3W resul+\$";
$lang['msgtruncated'] = "m35s@G3 TRunC4TED";
$lang['viewfullmsg'] = "vIEw full m3\$\$49E";
$lang['ignoredmsg'] = "iGn0ReD mEs549E";
$lang['wormeduser'] = "w0rm3D u\$eR";
$lang['ignoredsig'] = "igN0R3D \$19n4+urE";
$lang['messagewasdeleted'] = "me\$s4G3 %s.%s W@\$ D3l3+3D";
$lang['stopignoringthisuser'] = "s+0P 1gnor1n9 +hIs user";
$lang['renamethread'] = "reNAMe thre4d";
$lang['movethread'] = "m0ve +hr3@D";
$lang['torenamethisthreadyoumusteditthepoll'] = "t0 REn4mE +h1\$ +hR34d J00 MUst Ed1+ +HE PolL.";
$lang['closeforposting'] = "cLosE F0r pos+ing";
$lang['until'] = "un+1L 00:00 uTC";
$lang['approvalrequired'] = "apProv4l rEqu1R3D";
$lang['messageawaitingapprovalbymoderator'] = "m3s\$@G3 %s.%s 1\$ 4w@i+1Ng 4pprov4L 8Y 4 MODEra+Or";
$lang['postapprovedsuccessfully'] = "po5T 4PPRoveD suCC3sSfully";
$lang['postapprovalfailed'] = "po\$T 4pprov@L Ph41lEd.";
$lang['postdoesnotrequireapproval'] = "p0\$+ d0ES nO+ rEqUir3 @ppr0V@l";
$lang['approvepost'] = "aPPr0V3 pos+ foR DispL@Y";
$lang['approvedbyuser'] = "aPPrOved: %s by %s";
$lang['makesticky'] = "m4k3 stiCky";
$lang['messagecountdisplay'] = "%s of %s";
$lang['linktothread'] = "peRm@Nent l1nk +o this thr3@d";
$lang['linktopost'] = "liNK +0 p0\$+";
$lang['linktothispost'] = "l1Nk +0 THIS p0\$+";
$lang['imageresized'] = "tHis 1m4g3 has 83EN r3SiZ3D (0Ri91n4l s1ZE %1\$Sx%2\$S). To v13w tHE fulL-s1z3 1m@g3 CL1CK HEr3.";
$lang['messagedeletedbyuser'] = "m3Ss4gE %s.%s DEl3TeD %s by %s";
$lang['messagedeleted'] = "meSs493 %s.%s w@\$ Del3+ED";

// Moderators list (mods_list.php) -------------------------------------

$lang['cantdisplaymods'] = "c4Nn0+ di\$PL@y pHolder moD3r4+0rs";
$lang['moderatorlist'] = "mOder4+0R l1S+:";
$lang['modsforfolder'] = "m0d3r4tors f0R f0LDEr";
$lang['nomodsfound'] = "no moD3r@T0R\$ Ph0uNd";
$lang['forumleaders'] = "forum lEadErs:";
$lang['foldermods'] = "fold3R m0DEr4+0Rs:";

// Navigation strip (nav.php) ------------------------------------------

$lang['start'] = "st4rt";
$lang['messages'] = "me\$S4Ge\$";
$lang['pminbox'] = "iN80X";
$lang['startwiththreadlist'] = "s+@R+ pa9E wi+h +hrE4D lis+";
$lang['pmsentitems'] = "s3nt 1+ems";
$lang['pmoutbox'] = "ouT8Ox";
$lang['pmsaveditems'] = "s@VEd 1+3M5";
$lang['pmdrafts'] = "dRaph+\$";
$lang['links'] = "l1nk\$";
$lang['admin'] = "adMIN";
$lang['login'] = "l0G1N";
$lang['logout'] = "l0gout";

// PM System (pm.php, pm_write.php, pm.inc.php) ------------------------

$lang['privatemessages'] = "pR1v4+3 mEss4g3s";
$lang['recipienttiptext'] = "seP4R4+3 reCipiEn+s 8Y s3m1-C0lon oR Comm@";
$lang['maximumtenrecipientspermessage'] = "tHEre 1\$ @ LimiT 0f 10 RECIp13nts pEr m3ss49e. pL3@\$3 amEnd yOuR r3c1piEnt li\$T.";
$lang['mustspecifyrecipient'] = "j00 MUST SpEc1fY @+ l3Ast 0N3 r3cIPi3n+.";
$lang['usernotfound'] = "u\$Er %s N0+ ph0und";
$lang['sendnewpm'] = "sEnD n3W PM";
$lang['savemessage'] = "s@v3 m3ssa93";
$lang['timesent'] = "tIM3 Sent";
$lang['errorcreatingpm'] = "erR0r Cre@tin9 Pm! PlE4\$e try @G4IN in @ ph3W m1nU+3s";
$lang['writepm'] = "wR1t3 messa93";
$lang['editpm'] = "eD1t mEss49E";
$lang['cannoteditpm'] = "c@nn0T ed1+ +his PM. 1+ h4S 4LrE4dy B3en v13w3d 8y +he reCIpien+ 0r +h3 mess4Ge do3S no+ 3X1st 0R i+ is in4CC3ssi8le 8y J00";
$lang['cannotviewpm'] = "c4Nn0T v13w pm. m3Ss4gE D03S n0+ Exi\$+ 0r i+ Is in@CC3SS1ble 8Y j00";
$lang['pmmessagenumber'] = "m3\$s@93 %s";

$lang['youhavexnewpm'] = "j00 h@V3 %d n3W M3\$s49es. woUlD J00 lik3 to 9o to Y0ur 1nBOX Now?";
$lang['youhave1newpm'] = "j00 h4v3 1 new m3Ss49E. woUlD j00 l1K3 To 90 +0 yoUr inbox n0w?";
$lang['youhave1newpmand1waiting'] = "j00 h@ve 1 n3W M3\$S4g3.\n\nYOu 4L\$0 have 1 M3ss4g3 Aw4i+inG D3lIVEry. t0 ReC31V3 +h1\$ mEs549e PlE4s3 CL34r s0m3 sp@CE in your 1n8Ox.\n\nw0ULD j00 l1KE t0 g0 to Y0Ur In80X n0W?";
$lang['youhave1pmwaiting'] = "j00 h4v3 1 m3ss49e 4w@i+1Ng D3l1V3ry. +0 recEivE th1\$ m35\$@GE Pl34\$3 cl34r SOmE \$P4c3 1n YOUr 1Nb0x.\n\nw0ulD j00 lik3 tO 90 TO y0ur IN8Ox now?";
$lang['youhavexnewpmand1waiting'] = "j00 h4Ve %d new mE\$s49e5.\n\nYOU 4Lso hav3 1 me5\$49e 4w4It1NG d3LIV3Ry. t0 r3C31VE th1s M3Ssa93 pl34\$e cl3@r \$0mE sp4CE 1N y0UR inB0X.\n\nwouLD j00 LikE +0 g0 +O Your inBoX now?";
$lang['youhavexnewpmandxwaiting'] = "j00 h4v3 %d new mesS4ges.\n\nYou @Ls0 h4V3 %d m3Ss4g3s 4w@it1NG d3livery. to r3C3ive +heS3 m3Ss4gE Pl3@\$e cl34r s0M3 \$P4CE in yoUr in8ox.\n\nW0Uld j00 l1k3 +o 90 +O y0ur in80x Now?";
$lang['youhave1newpmandxwaiting'] = "j00 h4vE 1 n3W mess49e.\n\ny0u 4lso h@V3 %d mess4G3S 4w@i+ing D3livery. +o rece1v3 THes3 MEss4G3s plE4s3 Cl3@R S0Me sP@ce iN yoUr inBox.\n\nwould j00 L1k3 +0 90 t0 y0uR 1n8ox now?";
$lang['youhavexpmwaiting'] = "j00 havE %d mesSA93\$ aw4i+1N9 D3liVEry. to reC3IvE +hE5E m3s\$@G3\$ Pl34sE Cl34r s0m3 sp4C3 1n your iNBox.\n\nWoUlD j00 lik3 To 90 +o y0ur 1nB0x now?";

$lang['youdonothaveenoughfreespace'] = "j00 d0 n0T haVe En0U9H Fr33 5paC3 TO sEND +H1S m3ssa93.";
$lang['userhasoptedoutofpm'] = "%s h@s 0ptEd ouT 0Ph RECE1ving p3R\$ON@l m3S\$A93S";
$lang['pmfolderpruningisenabled'] = "pm ph0LDEr PrUnin9 is 3n4bleD!";
$lang['pmpruneexplanation'] = "th1s phorum USES pM PhOLDER prUnIng. teh mEsS4g3\$ J00 h4VE s+or3D in y0Ur 1nB0x @nD sEn+ 1teMs\\nPhold3r\$ 4RE subJ3C+ +0 Au+0M4+ic dEl3+10n. @ny m3S5@g35 j00 w1\$H +0 K33p sh0uld 8e M0v3D +0\\nYoUr \\'s4veD I+Ems\\' PH0LDEr 5o +h4+ +hEy 4R3 no+ D3l3t3d.";
$lang['yourpmfoldersare'] = "y0ur PM ph0lder5 @Re %s FUll";
$lang['currentmessage'] = "cuRR3nt M3sS4ge";
$lang['unreadmessage'] = "uNR3aD mEss49E";
$lang['readmessage'] = "rEad mess4g3";
$lang['pmshavebeendisabled'] = "pEr5on4l mEssa93s havE B3En D1\$@8leD BY +h3 PHOrum 0WN3R.";
$lang['adduserstofriendslist'] = "aDD useR5 To y0UR frI3nD\$ li\$+ +0 H4vE +hEm 4pp3ar 1N 4 DR0P DoWn on +Eh pm wrI+E m3SSa93 P49E.";

$lang['messagesaved'] = "mE\$S49e s4v3D";
$lang['messagewassuccessfullysavedtodraftsfolder'] = "me\$S4g3 w4s \$UCCESsfully s4vED +o 'Dr@pH+S' fold3r";
$lang['couldnotsavemessage'] = "cOulD n0+ 5@v3 MEss4G3. m@kE suR3 j00 h4V3 3nou9H 4vA1L48LE fr33 \$P@CE.";
$lang['pmtooltipxmessages'] = "%s m3\$\$49ES";
$lang['pmtooltip1message'] = "1 M3\$\$49E";

$lang['allowusertosendpm'] = "aLl0W user TO \$EnD per50n4l mESs@gEs +0 m3";
$lang['blockuserfromsendingpm'] = "blOck us3r Fr0m \$3nd1N9 PErs0N@l mEs\$@GEs +0 m3";
$lang['yourfoldernamefolderisempty'] = "y0Ur %s Ph0LDEr 1S 3mpty";
$lang['successfullydeletedselectedmessages'] = "succ3\$SFULly d3L3t3D sel3C+eD m3ss4G3\$";
$lang['successfullyarchivedselectedmessages'] = "sUCCessphuLLY 4rchIvEd sEl3C+3d MEss4G3s";
$lang['failedtodeleteselectedmessages'] = "f41leD +0 DEL3T3 \$ELECTED m3S\$@G3\$";
$lang['failedtoarchiveselectedmessages'] = "f41L3d +0 arChivE \$El3ct3D me\$S49ES";

// Preferences / Profile (user_*.php) ---------------------------------------------

$lang['mycontrols'] = "mY c0N+r0LS";
$lang['myforums'] = "my pHorUMS";
$lang['menu'] = "m3NU";
$lang['userexp_1'] = "u\$E +H3 mENu oN +he l3FT to M4N493 YOur sE++1n9S.";
$lang['userexp_2'] = "<b>u5ER d3T@1Ls</b> 4lL0w\$ j00 +o ch4N93 Y0ur n4me, 3m4Il 4DDR3sS 4nd PAs5WORd.";
$lang['userexp_3'] = "<b>u\$3r proF1l3</b> ALL0W\$ j00 +0 Ed1+ yoUr u5eR Profil3.";
$lang['userexp_4'] = "<b>cHAN93 p4S\$W0rd</b> 4ll0W\$ j00 +0 Ch4N9e youR passw0RD";
$lang['userexp_5'] = "<b>ema1l &amp; priv4Cy</b> leTs j00 ChAngE how j00 c4n BE c0n+4C+ed on @nD ophph th3 F0RUM.";
$lang['userexp_6'] = "<b>foRUm oPTIOn\$</b> L3+s j00 ch4Nge h0W the ph0rUm lo0k\$ @nD woRKS.";
$lang['userexp_7'] = "<b>atT4chm3Nt\$</b> 4llows j00 to 3D1t/del3TE yOur 4+T4CHm3NTs.";
$lang['userexp_8'] = "<b>s19n@+ure</b> l3+s j00 eD1+ yoUr 5iGN4+URe.";
$lang['userexp_9'] = "<b>reL@t10n\$H1PS</b> LEt5 j00 man4G3 y0uR R3l4+i0Nship w1+h 0+h3R Us3R\$ on +Eh f0rUm.";
$lang['userexp_9'] = "<b>wOrd PHil+3R</b> l3ts j00 eD1+ yoUr pErs0n@L word f1l+3r.";
$lang['userexp_10'] = "<b>thR34d sUB\$crip+i0n5</b> 4ll0w\$ j00 t0 M@N@ge yoUr Thre4D \$UBsCr1Pti0Ns.";
$lang['userdetails'] = "u\$3r d3T@il\$";
$lang['userprofile'] = "u5Er prophIL3";
$lang['emailandprivacy'] = "em41l &amp; PrIV4Cy";
$lang['editsignature'] = "eDi+ S19n@tUr3";
$lang['norelationshipssetup'] = "j00 have No U\$ER Rel4+I0n5h1Ps s3t UP. 4DD 4 n3w u\$3r 8y searCh1Ng 8el0W.";
$lang['editwordfilter'] = "edI+ W0rd F1lt3R";
$lang['userinformation'] = "u\$3r 1nf0rm4TIoN";
$lang['changepassword'] = "ch@ng3 P@\$Sw0Rd";
$lang['currentpasswd'] = "cUrr3n+ p@\$SWord";
$lang['newpasswd'] = "n3w p@\$Sw0RD";
$lang['confirmpasswd'] = "c0NF1rM P4s\$w0rD";
$lang['passwdsdonotmatch'] = "p4\$sWorD\$ dO no+ m4tCh!";
$lang['nicknamerequired'] = "nIcknamE 1\$ r3Qu1r3D!";
$lang['emailaddressrequired'] = "em41l 4DDr3\$S i\$ r3Quir3D!";
$lang['logonnotpermitted'] = "lOgon no+ p3rmI+tED. Ch0Os3 4N0THEr!";
$lang['nicknamenotpermitted'] = "nIckn@m3 no+ perM1++ED. Cho053 4N0Th3r!";
$lang['emailaddressnotpermitted'] = "eM41l @dDr35\$ not perm1+t3D. Ch0O53 4n0tHER!";
$lang['emailaddressalreadyinuse'] = "eM41L aDDress @lre4Dy 1N U53. Ch0O\$E @n0TH3r!";
$lang['relationshipsupdated'] = "r3L@+10n\$h1ps upD4+3d!";
$lang['relationshipupdatefailed'] = "r3l4TionsHIP upD4teD F41L3d!";
$lang['preferencesupdated'] = "pr3f3R3nc3S w3re \$UCce5\$fuLLY upDAtED.";
$lang['userdetails'] = "u53r DE+4il\$";
$lang['memberno'] = "m3MBEr n0.";
$lang['firstname'] = "f1R\$t n4mE";
$lang['lastname'] = "l@\$t n4m3";
$lang['dateofbirth'] = "dAt3 0ph 8IRth";
$lang['homepageURL'] = "hoM3p@93 uRl";
$lang['profilepicturedimensions'] = "pr0f1l3 picTur3 (m@x 95x95px)";
$lang['avatarpicturedimensions'] = "av@t4r piC+UrE (m4x 15x15px)";
$lang['invalidattachmentid'] = "iNv4l1D @++4ChMEnt. ch3ck that i\$ h4\$n'+ B3en d3l3+ED.";
$lang['unsupportedimagetype'] = "uNSUpPort3d im@ge 4++@cHm3N+. j00 C@n 0NLy U53 jp9, 91ph AnD png 1M@ge 4T+@CHm3Nts f0R YoUr 4V4Tar @ND pr0PHiL3 pICtUr3.";
$lang['selectattachment'] = "seL3c+ 4t+@CHm3nT";
$lang['pictureURL'] = "pIc+ur3 Url";
$lang['avatarURL'] = "av@t4R url";
$lang['profilepictureconflict'] = "t0 USE 4N a+t4ChM3NT for your profilE P1C+uRE thE piCTur3 URl fi3ld musT 83 8L4Nk.";
$lang['avatarpictureconflict'] = "to U53 an 4++4CHMEnt Phor y0Ur 4V@+4R pictUr3 +he 4VAt4R url fiELD mu\$+ 8E 8l4nk.";
$lang['attachmenttoolargeforprofilepicture'] = "s3lec+ed at+4ChmEnt 1\$ +0o l4r9e F0r Prophil3 p1C+Ure. m@xImUm d1MENSi0Ns 4R3 %s";
$lang['attachmenttoolargeforavatarpicture'] = "sELeCtED 4++aChm3nt 1S +0O largE ph0r 4Vat4R PictUr3. M@Ximum D1mens1ons @r3 %s";
$lang['failedtoupdateuserdetails'] = "s0me OR 4Ll oF y0UR User aCCOUn+ D3T4ils c0ulD n0t 8E UpdatED. pL3453 try 494in la+Er.";
$lang['failedtoupdateuserpreferences'] = "sOm3 0r 4lL 0pH y0Ur User PR3pher3NCE5 coUld n0+ bE upD4t3D. pl3A53 +ry 494IN l@+3R.";
$lang['emailaddresschanged'] = "eM@Il 4ddr3sS h4\$ B33N ch4N9ed";
$lang['newconfirmationemailsuccess'] = "yOur em41l 4ddr3ss H4s 833n Ch4nG3D 4nd 4 n3w ConPhiRm4T10n Ema1L H4\$ b3En \$3n+. pl34s3 Ch3CK @nd r34d +H3 EMa1l f0r PHurtHEr In5+rUC+10NS.";
$lang['newconfirmationemailfailure'] = "j00 h4V3 CH@n93D y0Ur 3m4il aDDrE5\$, bU+ wE W3RE un@BLE t0 send @ C0nphiRM@+ion rEqUest. pl34\$3 coN+@CT th3 PhorUM 0wner f0R 4ss1ST4nce.";
$lang['forumoptions'] = "f0RUm opt10N\$";
$lang['notifybyemail'] = "nOT1PHY 8Y 3M@il oph p0\$+S +0 me";
$lang['notifyofnewpm'] = "n0TiphY By popuP 0PH nEw pm m3Ss@ge5 +0 m3";
$lang['notifyofnewpmemail'] = "n0tify by 3M41L 0PH n3w pm m3S5@G3s to me";
$lang['daylightsaving'] = "aDju\$t for d4Yl1Ght s4vinG";
$lang['autohighinterest'] = "aU+0m4+iCallY m4rk thR3aDs i posT IN 4\$ HiGh 1N+3r3ST";
$lang['convertimagestolinks'] = "au+0m@+1Cally conv3r+ 3mbEddeD 1Ma9Es in p0s+\$ Int0 liNk5";
$lang['thumbnailsforimageattachments'] = "thUmBn@il\$ F0R im49e @++4ChmenTs";
$lang['smallsized'] = "sm@LL siZ3d";
$lang['mediumsized'] = "mEDium sIZ3d";
$lang['largesized'] = "l4R9e SIz3D";
$lang['globallyignoresigs'] = "gL0BAlly ignore User 5i9n4Tur35";
$lang['allowpersonalmessages'] = "alloW OtheR U53r\$ t0 53ND m3 P3rson4L mEss4G3s";
$lang['allowemails'] = "alLow o+H3R U5Er\$ t0 53Nd M3 3Ma1L\$ vI@ MY prOphIl3";
$lang['timezonefromGMT'] = "t1M3 zoN3";
$lang['postsperpage'] = "pOS+s p3R p4G3";
$lang['fontsize'] = "f0Nt 51zE";
$lang['forumstyle'] = "fOrum STyL3";
$lang['forumemoticons'] = "foRum 3moTIcons";
$lang['startpage'] = "st4rt P@gE";
$lang['signaturecontainshtmlcode'] = "s1GN4TUre Con+41nS htmL COdE";
$lang['savesignatureforuseonallforums'] = "s4vE 519naTuRE for U\$3 0n @ll FOrUm\$";
$lang['preferredlang'] = "pREPhERr3D l@nGu493";
$lang['donotshowmyageordobtoothers'] = "dO n0T show MY 493 or D4te opH b1R+h +0 0Th3R5";
$lang['showonlymyagetoothers'] = "sH0w 0nlY mY a93 To others";
$lang['showmyageanddobtoothers'] = "sHoW 8o+h MY a9e @ND d@tE of B1R+H +0 0+hErs";
$lang['showonlymydayandmonthofbirthytoothers'] = "sHow 0nLY my D@y 4Nd m0N+H of B1r+h T0 othErs";
$lang['listmeontheactiveusersdisplay'] = "li5+ me 0N tEh 4C+1VE user\$ Displ4y";
$lang['browseanonymously'] = "bRoWSE ph0RUm @n0NYmou5Ly";
$lang['allowfriendstoseemeasonline'] = "brOw\$3 4N0nymoUSLy, 8ut @lLOW fr13nds tO 53e m3 @s 0Nl1N3";
$lang['revealspoileronmouseover'] = "reVE4l SP01l3rs 0N mouse 0v3R";
$lang['showspoilersinlightmode'] = "aLw4Y\$ SHow spoiLERs iN Ligh+ m0D3 (u\$eS l1gh+ER ph0Nt C0loUr)";
$lang['resizeimagesandreflowpage'] = "r3Siz3 1m4g3S 4ND REfL0w p@gE +0 PR3V3n+ h0rizon+4L scr0LlinG.";
$lang['showforumstats'] = "sh0w ph0rUm s+4+s 4T boTtom of M3S\$@G3 P4N3";
$lang['usewordfilter'] = "eN48LE w0RD ph1LT3r.";
$lang['forceadminwordfilter'] = "foRCE us3 oF 4DmIn w0rD fil+ER on 4Ll users (inC. 9u3\$+S)";
$lang['timezone'] = "t1M3 zoNE";
$lang['language'] = "l4ngu4g3";
$lang['emailsettings'] = "eM41l 4nd CoN+4C+ \$3t+ings";
$lang['forumanonymity'] = "foRum 4NOnymi+Y sEtt1Ngs";
$lang['birthdayanddateofbirth'] = "birtHD4y AnD d4+3 0ph birth D1spl4y";
$lang['includeadminfilter'] = "iNclude 4DMin W0rD fiL+3r iN MY l1\$+.";
$lang['setforallforums'] = "sE+ ph0r 4LL f0RUMs?";
$lang['containsinvalidchars'] = "%s c0nt41n\$ inV4L1d ch4r4ct3R\$!";
$lang['homepageurlmustincludeschema'] = "hoMep4g3 URL must 1nClUd3 h+tp:// \$CH3m4.";
$lang['pictureurlmustincludeschema'] = "pIc+urE Url Mu\$T incluD3 ht+p:// sCh3m4.";
$lang['avatarurlmustincludeschema'] = "aV@+4R url mu\$+ INcluDE h++P:// sch3m4.";
$lang['postpage'] = "p0S+ p4g3";
$lang['nohtmltoolbar'] = "n0 htMl T0olBAr";
$lang['displaysimpletoolbar'] = "d1\$PL@y s1mpl3 h+ml +o0lB@r";
$lang['displaytinymcetoolbar'] = "dI5PLay wYs1wyg h+ml Toolbar";
$lang['displayemoticonspanel'] = "dIspl4y Em0tIC0Ns P4nEl";
$lang['displaysignature'] = "d1spl4y s1gn@tUr3";
$lang['disableemoticonsinpostsbydefault'] = "d1S4BLe eM0+iCon\$ In Me\$s4G3\$ BY D3FAUl+";
$lang['automaticallyparseurlsbydefault'] = "aUTOmat1CallY p@r53 url\$ iN m3s5@ges By d3FAult";
$lang['postinplaintextbydefault'] = "pOST in PL@in +eXT By D3F4ul+";
$lang['postinhtmlwithautolinebreaksbydefault'] = "pOs+ In html w1+h 4U+0-liNe-8R3@ks 8Y D3ph4ul+";
$lang['postinhtmlbydefault'] = "p0S+ in html by D3F4ULt";
$lang['privatemessageoptions'] = "pr1v4+e mEss49E 0p+10n5";
$lang['privatemessageexportoptions'] = "pr1v4te me5\$@93 EXPoRt 0ption\$";
$lang['savepminsentitems'] = "s4Ve 4 C0Py of 34ch pm I s3nd 1n mY sent 1+3m\$ ph0Ld3r";
$lang['includepminreply'] = "iNClud3 M3sS49e BODy WhEn r3Ply1ng +o pm";
$lang['autoprunemypmfoldersevery'] = "auTo prUn3 my pm ph0lDErs 3vEry:";
$lang['friendsonly'] = "frienDs 0nly?";
$lang['globalstyles'] = "glO8@L \$+Yl3s";
$lang['forumstyles'] = "f0Rum \$tyl3s";
$lang['youmustenteryourcurrentpasswd'] = "j00 mu5t 3N+3R your CURr3n+ p4\$sw0rD";
$lang['youmustenteranewpasswd'] = "j00 mus+ 3n+3R 4 NEW P4SswORD";
$lang['youmustconfirmyournewpasswd'] = "j00 Must conphiRm your n3w p4Ssword";
$lang['profileentriesmustnotincludehtml'] = "pROphil3 Entr13s mU\$T N0+ inclUD3 H+ml";
$lang['failedtoupdateuserprofile'] = "f41L3d to upD4tE U\$ER profil3";

// Polls (create_poll.php, poll_results.php) ---------------------------------------------

$lang['mustprovideanswergroups'] = "j00 mu5+ prOVId3 S0M3 4n\$wEr 9R0UP\$";
$lang['mustprovidepolltype'] = "j00 Mu\$+ pr0viD3 4 p0LL type";
$lang['mustprovidepollresultsdisplaytype'] = "j00 mu5t provid3 r3SUlt\$ d1sPL4y +ype";
$lang['mustprovidepollvotetype'] = "j00 mu\$T prov1DE 4 p0ll V0te +ypE";
$lang['mustprovidepollguestvotetype'] = "j00 mu\$t SPEc1fY Iph 9U35+s should BE 4lL0W3d +0 vo+3";
$lang['mustprovidepolloptiontype'] = "j00 Mu5T proVID3 4 poll 0pt10N tyP3";
$lang['mustprovidepollchangevotetype'] = "j00 mus+ Provid3 4 poll CH4NG3 vo+3 +yp3";
$lang['pollquestioncontainsinvalidhtml'] = "oNe 0R m0re 0ph y0Ur p0ll qu3\$+10NS c0Nt41NS inV4l1d H+Ml.";
$lang['pleaseselectfolder'] = "ple4se s3lec+ 4 folder";
$lang['mustspecifyvalues1and2'] = "j00 mu\$T speC1fy v@lUe\$ F0R @nsWERs 1 and 2";
$lang['tablepollmusthave2groups'] = "t48ul@r ph0rmA+ pollS mu\$+ h4v3 PRECisely +w0 vo+ing gr0up\$";
$lang['nomultivotetabulars'] = "t48ul@r PHOrm@t poLL\$ C4nno+ BE mult1-v0te";
$lang['nomultivotepublic'] = "pUbl1C Ballo+s c4nn0T BE mult1-v0Te";
$lang['abletochangevote'] = "j00 wIll 83 48l3 +o ch@ng3 y0UR vo+3.";
$lang['abletovotemultiple'] = "j00 w1ll 83 4BLE +0 v0+3 multipl3 TiMEs.";
$lang['notabletochangevote'] = "j00 wilL n0+ 8E @8le +0 ch4NG3 your vo+E.";
$lang['pollvotesrandom'] = "n0+e: p0lL vot35 4rE r4ND0Mly g3N3r@+3D for prEv13W 0nly.";
$lang['pollquestion'] = "poLl qUes+10N";
$lang['possibleanswers'] = "pO5\$1blE 4NsW3rs";
$lang['enterpollquestionexp'] = "eN+er t3h an\$W3r\$ Ph0R y0Ur poll QUE5t10N.. iph yOur Poll 1s @ &quot;yes/no&quot; quest10n, s1mply enTer &quot;yEs&quot; PH0r @nSWEr 1 ANd &quot;n0&quot; phor answ3R 2.";
$lang['numberanswers'] = "nO. @n5W3rs";
$lang['answerscontainHTML'] = "aNSwerS C0nt4iN h+ML (n0+ IncluD1n9 s19n4tuRE)";
$lang['optionsdisplay'] = "aN5wER5 diSPl4y TypE";
$lang['optionsdisplayexp'] = "how sHOuld th3 4nSW3rS 8E prEsEnt3D?";
$lang['dropdown'] = "a\$ DR0p-Down l1\$T(\$)";
$lang['radios'] = "a\$ 4 ser1Es 0PH r4D10 8U++0NS";
$lang['votechanging'] = "v0te CH@nginG";
$lang['votechangingexp'] = "c4N 4 P3rson Ch4nGe his or hEr vo+3?";
$lang['guestvoting'] = "guES+ v0TIng";
$lang['guestvotingexp'] = "caN Gu3sts v0+3 IN +h1s poll?";
$lang['allowmultiplevotes'] = "aLLow Mul+iple v0+35";
$lang['pollresults'] = "poLl rEsul+s";
$lang['pollresultsexp'] = "hOW w0Uld j00 lik3 to displ@y th3 rEsult\$ oF your poll?";
$lang['pollvotetype'] = "poLL votinG +ypE";
$lang['pollvotesexp'] = "h0w 5houlD +Eh poll B3 C0NDUc+Ed?";
$lang['pollvoteanon'] = "an0NYmOu\$ly";
$lang['pollvotepub'] = "pu8l1c B4llo+";
$lang['horizgraph'] = "hOR1ZOnt4L 9rAPH";
$lang['vertgraph'] = "v3Rt1c@L 9R4ph";
$lang['tablegraph'] = "t4bul4r f0rmaT";
$lang['polltypewarning'] = "<b>w@Rn1n9</b>: tHIs i\$ 4 pUBL1C B@lLo+. your nAm3 w1lL 83 v1\$I8lE n3x+ to teh oPt10N j00 vo+e ph0R.";
$lang['expiration'] = "exPIr4+10n";
$lang['showresultswhileopen'] = "d0 J00 w4N+ +0 sh0w r35Ul+s WH1l3 TEH poll IS op3N?";
$lang['whenlikepollclose'] = "wheN WoulD j00 L1KE yoUr p0ll To aUt0M@+1CAlly clo\$e?";
$lang['oneday'] = "oN3 d4y";
$lang['threedays'] = "thr3e d4Ys";
$lang['sevendays'] = "s3veN D@Y\$";
$lang['thirtydays'] = "th1r+y D4ys";
$lang['never'] = "n3VER";
$lang['polladditionalmessage'] = "aDdit10N4l ME5s@g3 (0PT10n@l)";
$lang['polladditionalmessageexp'] = "d0 j00 W@n+ +0 1ncluDE 4N 4DD1+i0N@l p0s+ Aph+3R +3H p0lL?";
$lang['mustspecifypolltoview'] = "j00 mu\$t SPECipHy 4 p0ll to v1Ew.";
$lang['pollconfirmclose'] = "aR3 j00 \$Ure j00 wan+ tO Cl0\$3 teh f0LLowing polL?";
$lang['endpoll'] = "eNd poLL";
$lang['nobodyvotedclosedpoll'] = "n08ody v0+3D";
$lang['votedisplayopenpoll'] = "%s @Nd %s H4V3 voteD.";
$lang['votedisplayclosedpoll'] = "%s 4nd %s Vo+eD.";
$lang['nousersvoted'] = "nO u\$erS";
$lang['oneuservoted'] = "1 u5er";
$lang['xusersvoted'] = "%s usER\$";
$lang['noguestsvoted'] = "nO gu3St5";
$lang['oneguestvoted'] = "1 9Ue\$+";
$lang['xguestsvoted'] = "%s GUes+\$";
$lang['pollhasended'] = "polL hAs eNDEd";
$lang['youvotedforpolloptionsondate'] = "j00 v0+3D For %s On %s";
$lang['thisisapoll'] = "tH15 1S @ poll. cl1CK to v1EW re5UL+S.";
$lang['editpoll'] = "eD1+ poll";
$lang['results'] = "rESUlts";
$lang['resultdetails'] = "rE\$UL+ dEt4IL5";
$lang['changevote'] = "cH4ng3 v0+3";
$lang['pollshavebeendisabled'] = "p0Lls h@v3 BEen d1S4BlEd 8Y Th3 f0rum oWNER.";
$lang['answertext'] = "ansWER +3X+";
$lang['answergroup'] = "an\$WeR 9r0Up";
$lang['previewvotingform'] = "pR3v1Ew v0+1n9 f0rm";
$lang['viewbypolloption'] = "vieW By poll 0pt1oN";
$lang['viewbyuser'] = "v13w 8y u5ER";

// Profiles (profile.php) ----------------------------------------------

$lang['editprofile'] = "eD1T profiLE";
$lang['profileupdated'] = "pR0F1L3 UPD4+ED.";
$lang['profilesnotsetup'] = "the f0rum 0Wn3r H4S not set Up pR0fiLEs.";
$lang['ignoreduser'] = "ignoreD U5Er";
$lang['lastvisit'] = "l@S+ visi+";
$lang['userslocaltime'] = "u5er'\$ Loc4l T1M3";
$lang['userstatus'] = "st4+U\$";
$lang['useractive'] = "oNL1nE";
$lang['userinactive'] = "inAC+1V3 / 0phFLin3";
$lang['totaltimeinforum'] = "tO+aL tim3";
$lang['longesttimeinforum'] = "lOn935+ \$essi0n";
$lang['sendemail'] = "s3ND 3M4il";
$lang['sendpm'] = "s3ND pm";
$lang['visithomepage'] = "vi5i+ homep49e";
$lang['age'] = "a93";
$lang['aged'] = "aged";
$lang['birthday'] = "b1r+hDAY";
$lang['registered'] = "r3gistereD";
$lang['findpostsmadebyuser'] = "f1nd p0\$+S m4dE BY %s";
$lang['findpostsmadebyme'] = "fInd pOsts m4DE By m3";
$lang['profilenotavailable'] = "prOFil3 nO+ av4il@8lE.";
$lang['userprofileempty'] = "th1\$ U\$3r h4s n0+ fiLled 1n th31r prOPHile 0R 1+ i\$ S3T +o pr1V4+3.";

// Registration (register.php) -----------------------------------------

$lang['newuserregistrationsarenotpermitted'] = "s0Rry, new User RE9iSTr4+10n\$ @r3 N0t 4LLow3D r1GHT n0W. pleasE ChECk BACk l4+Er.";
$lang['usernameinvalidchars'] = "uS3rname C@n 0nly C0n+@iN 4-Z, 0-9, _ - Ch4r4CTEr\$";
$lang['usernametooshort'] = "usERn4mE Mus+ 83 4 m1niMum 0F 2 chAr4CtErs l0Ng";
$lang['usernametoolong'] = "us3rn4mE mU\$+ b3 @ m@ximUm oph 15 ch4R4C+ers l0Ng";
$lang['usernamerequired'] = "a l0GON n@m3 1\$ r3quIr3D";
$lang['passwdmustnotcontainHTML'] = "p4\$Sw0RD MU\$t N0t c0Nt41N h+ml T4g\$";
$lang['passwordinvalidchars'] = "p4sSWorD C4N onLy coN+@1N a-Z, 0-9, _ - CH4raC+Er5";
$lang['passwdtooshort'] = "p4Ssw0RD mus+ 83 4 M1n1MuM oph 6 CH@r4c+Ers lONG";
$lang['passwdrequired'] = "a PAs\$w0rD is R3qu1R3D";
$lang['confirmationpasswdrequired'] = "a COnph1rm@+i0N p4ssw0rD 1\$ R3QU1red";
$lang['nicknamerequired'] = "a N1ckn@me is r3qU1rED";
$lang['emailrequired'] = "aN 3mA1l adDr35S 1\$ requir3D";
$lang['passwdsdonotmatch'] = "p4s\$WorDS D0 no+ m@+Ch";
$lang['usernamesameaspasswd'] = "usern4mE @nD P4SswoRD must BE D1PhpH3R3nt";
$lang['usernameexists'] = "sOrry, @ user w1th THa+ n4m3 4LReady 3x1\$T5";
$lang['successfullycreateduseraccount'] = "sUcc3\$SFulLy CreateD Us3r 4CCoUnt";
$lang['useraccountcreatedconfirmfailed'] = "y0ur u\$eR @cCoUn+ h@\$ 8een CrE@+3d 8u+ +3h rEqU1REd C0nphirmation 3m4il Was n0T sent. ple4\$3 C0NtaCt tH3 f0RUm 0WN3r t0 rEc+ifY +His. 1n +h1\$ mE4nt1ME ple45e cliCk tEh con+1NUe 8UT+on TO l091n IN.";
$lang['useraccountcreatedconfirmsuccess'] = "y0UR us3R acc0unt h4s bEEn Cre4+3d 8u+ 8Efore J00 C4n \$T@r+ p0\$+1ng j00 mus+ cOnph1rm y0Ur Em4IL 4DDr3s\$. pl3ase cheCk yOur 3m@il f0r 4 liNk +ha+ WIll @llow j00 to Conph1rm y0Ur 4DDr3Ss.";
$lang['useraccountcreated'] = "y0ur u5er aCC0un+ H@5 B3en cr34+3D suCCEssfuLly! CliCk the Con+inue 8UTton 83l0w to l091n";
$lang['errorcreatinguserrecord'] = "err0r cr34t1ng usEr recOrd";
$lang['userregistration'] = "u\$3r REgi5+ration";
$lang['registrationinformationrequired'] = "r391str4+1ON inf0RM4+i0n (rEqU1r3D)";
$lang['profileinformationoptional'] = "prOF1l3 1nf0rm@+i0n (0PT10n4L)";
$lang['preferencesoptional'] = "prEPH3rEnc3s (oP+1on@l)";
$lang['register'] = "r3gi\$+3r";
$lang['rememberpasswd'] = "rem3Mber p4Ssw0rd";
$lang['birthdayrequired'] = "y0ur d4tE 0f 81r+H i5 REQU1RED or 1S inv4liD";
$lang['alwaysnotifymeofrepliestome'] = "nOTIphY on reply +0 mE";
$lang['notifyonnewprivatemessage'] = "n0+ify 0n n3W pr1v4t3 M3s\$@G3";
$lang['popuponnewprivatemessage'] = "p0p Up On New prIv4Te m3SS@g3";
$lang['automatichighinterestonpost'] = "aUT0M@T1C h1gh 1N+3r3ST oN poSt";
$lang['confirmpassword'] = "conFIrm pasSwORd";
$lang['invalidemailaddressformat'] = "iNValId em41l adDR3sS F0rMAt";
$lang['moreoptionsavailable'] = "m0rE pR0F1l3 4nD pr3Ph3REnC3 0P+10N5 @rE av4IlaBle once j00 rE9istEr";
$lang['textcaptchaconfirmation'] = "conFirM4+i0N";
$lang['textcaptchaexplain'] = "tO Th3 ri9Ht 1\$ 4 Tex+-c4PTcH4 im4Ge. pl34\$E tyP3 T3h c0DE j00 c@N \$eE 1N thE 1M@9E inTO tEh 1Nput F1elD 83lOW 1+.";
$lang['textcaptchaimgtip'] = "th1\$ 1S a c4pTcHA-pIctur3. I+ Is us3D +o Pr3V3NT 4ut0m4T1C REg1S+r@+I0n";
$lang['textcaptchamissingkey'] = "a C0nfIrm4+i0N coDe Is reqUir3D.";
$lang['textcaptchaverificationfailed'] = "tEX+-c4p+CH@ Verif1ca+10N CoD3 w4s 1NcoRRect. PLE4S3 RE-Ent3R 1+.";
$lang['forumrules'] = "fOrum RULeS";
$lang['forumrulesnotification'] = "iN 0RdER t0 PR0ceeD, j00 mU5+ A9rEE with tHe PhollOWIng rULes";
$lang['forumrulescheckbox'] = "i h4v3 R34D, @nd @gReE t0 ABIDe 8y +3h f0rum RUL3S.";
$lang['youmustagreetotheforumrules'] = "j00 mU\$+ 4gR3e +0 TEh PH0rum RUlEs 8Eph0RE j00 C4N Con+InU3.";

// Recent visitors list  (visitor_log.php) -----------------------------

$lang['member'] = "m3M8ER";
$lang['searchforusernotinlist'] = "sE4rCh ph0r 4 user N0t 1n li5+";
$lang['yoursearchdidnotreturnanymatches'] = "yOur se@RCh DiD no+ r3+urN 4ny mAtch3S. +ry simpliphy1n9 your 534rCH p4r4MEtErs 4ND tRy a9@1n.";
$lang['hiderowswithemptyornullvalues'] = "h1D3 r0w\$ Wi+h 3MptY 0R nUll v4LUes in s3LeC+ED Column5";
$lang['showregisteredusersonly'] = "shOw rE9ISt3r3D U5ers 0NLy (H1d3 gUE\$TS)";

// Relationships (user_rel.php) ----------------------------------------

$lang['relationships'] = "rel4t1onsh1P\$";
$lang['userrelationship'] = "u\$3r r3l4t10Nsh1p";
$lang['userrelationships'] = "us3r rel4TI0N\$H1P5";
$lang['failedtoremoveselectedrelationships'] = "f@ileD +0 R3m0vE s3lEC+3D rEL4Ti0N\$hip";
$lang['friends'] = "fr1enD5";
$lang['ignoredcompletely'] = "iGnoRED Completely";
$lang['relationship'] = "rEl@t10n\$h1P";
$lang['restorenickname'] = "reStore u\$er'5 nICKn4mE";
$lang['friend_exp'] = "u5ER'\$ pos+S M4Rk3D w1+h 4 &quot;phrienD&quot; 1COn.";
$lang['normal_exp'] = "user'S posT5 @PPE4R as n0rm4l.";
$lang['ignore_exp'] = "useR'\$ pO\$+S 4rE h1DD3n.";
$lang['ignore_completely_exp'] = "tHreaDs @nd pO\$+S t0 oR Fr0m U\$3r w1ll 4Pp34r DEL3+ed.";
$lang['display'] = "d15PL4y";
$lang['displaysig_exp'] = "uSER'5 5iGna+uRe 1s di\$PL@Yed 0N th31r pos+S.";
$lang['hidesig_exp'] = "u\$er'\$ S1gn4+Ure is HIDD3n ON +heiR pos+s.";
$lang['cannotignoremod'] = "j00 cann0+ 1Gnore th1s u53r, As tHEy 4rE @ modEr4tor.";
$lang['previewsignature'] = "pr3vI3W 5ign4tUr3";

// Search (search.php) -------------------------------------------------

$lang['searchresults'] = "s3@rCh r35ul+s";
$lang['usernamenotfound'] = "the US3rn4ME j00 sp3ciFied 1N +he +0 or From fIEld was n0t foUnD.";
$lang['notexttosearchfor'] = "onE or all of y0ur \$E4rCh k3Yw0RDS w3R3 1NV4l1D. s3@rCh KeyworD\$ muST 83 no 5h0RtEr +h4N %d ch4R4Ct3rs, no l0NG3r +h4n %d CH@r@CtEr\$ 4nd mu\$T n0T app34r 1N +he %s";
$lang['keywordscontainingerrors'] = "k3YW0rds COn+@1NINg 3Rrors: %s";
$lang['mysqlstopwordlist'] = "mySql \$+opw0RD l1ST";
$lang['foundzeromatches'] = "foUND: 0 M@+chE5";
$lang['found'] = "f0und";
$lang['matches'] = "m@TChes";
$lang['prevpage'] = "pR3vi0Us p@gE";
$lang['findmore'] = "f1nd MOR3";
$lang['searchmessages'] = "sE@rcH Mess4G3S";
$lang['searchdiscussions'] = "sE@rch D1\$cuss1ons";
$lang['find'] = "f1ND";
$lang['additionalcriteria'] = "addi+10N@l cri+Eri@";
$lang['searchbyuser'] = "sE@RCH 8y User (0P+10n4l)";
$lang['folderbrackets_s'] = "foldER(\$)";
$lang['postedfrom'] = "po5+eD frOM";
$lang['postedto'] = "poSTED +0";
$lang['today'] = "t0daY";
$lang['yesterday'] = "ye\$terd4Y";
$lang['daybeforeyesterday'] = "d4Y 83phorE yE5+ErD4y";
$lang['weekago'] = "%s w3Ek a90";
$lang['weeksago'] = "%s wE3k5 a90";
$lang['monthago'] = "%s M0nth 49o";
$lang['monthsago'] = "%s M0n+hs 490";
$lang['yearago'] = "%s YEar @g0";
$lang['beginningoftime'] = "beg1nn1NG of +1M3";
$lang['now'] = "n0w";
$lang['lastpostdate'] = "l45+ P0s+ D@te";
$lang['numberofreplies'] = "nUmb3r of repli3\$";
$lang['foldername'] = "f0ldeR n@me";
$lang['authorname'] = "au+h0R N4m3";
$lang['decendingorder'] = "neWE5+ Fir\$+";
$lang['ascendingorder'] = "oLd3\$+ F1RSt";
$lang['keywords'] = "kEYW0RDs";
$lang['sortby'] = "sORt 8Y";
$lang['sortdir'] = "sOrt D1R";
$lang['sortresults'] = "sOR+ r3sults";
$lang['groupbythread'] = "gROUP by +HRE4d";
$lang['postsfromuser'] = "p05+s from User";
$lang['poststouser'] = "pos+s to useR";
$lang['poststoandfromuser'] = "p0S+S t0 4ND pHrom u\$ER";
$lang['searchfrequencyerror'] = "j00 C4N only se4RCH 0nc3 evErY %s 53CoNDs. ple@\$e +RY 494in l@+eR.";
$lang['searchsuccessfullycompleted'] = "s34rch \$uccEssfulLy c0mPL3+3d. %s";
$lang['clickheretoviewresults'] = "clICk H3rE +0 viEw rEsulTs.";

// Search Popup (search_popup.php) -------------------------------------

$lang['select'] = "s3L3C+";
$lang['searchforthread'] = "s3@RcH for thRe@d";
$lang['mustspecifytypeofsearch'] = "j00 mu\$T speC1phy +Yp3 of \$3@rCh +0 p3RphoRm";
$lang['unkownsearchtypespecified'] = "uNkn0wn searCh +ypE sp3CiPh13D";
$lang['mustentersomethingtosearchfor'] = "j00 mu\$T enteR s0m3tH1n9 t0 se4rCh For";

// Start page (start_left.php) -----------------------------------------

$lang['recentthreads'] = "r3c3n+ thre@ds";
$lang['startreading'] = "sT4Rt r34ding";
$lang['threadoptions'] = "tHreaD 0p+10ns";
$lang['editthreadoptions'] = "eD1t THRE4d 0PT1Ons";
$lang['morevisitors'] = "mOr3 v1s1+Or\$";
$lang['forthcomingbirthdays'] = "f0R+hcOMIng 81r+hd@y\$";

// Start page (start_main.php) -----------------------------------------

$lang['editstartpage_help'] = "j00 c@n Ed1+ +H1\$ p@G3 phr0m th3 4Dmin 1nteRph@C3";

// Thread navigation (thread_list.php) ---------------------------------

$lang['newdiscussion'] = "neW d1SCuss10N";
$lang['createpoll'] = "cRE@t3 pOlL";
$lang['search'] = "s3ARCh";
$lang['searchagain'] = "s3@rch aG4in";
$lang['alldiscussions'] = "aLL d1SCU\$\$10Ns";
$lang['unreaddiscussions'] = "unr3@d d1sCUSsi0n\$";
$lang['unreadtome'] = "unR34D &quot;t0: mE&quot;";
$lang['todaysdiscussions'] = "t0DAy's dISCU\$S1ONS";
$lang['2daysback'] = "2 D4ys 8@cK";
$lang['7daysback'] = "7 days 84ck";
$lang['highinterest'] = "hI9h 1N+er3ST";
$lang['unreadhighinterest'] = "uNread H1gh INTEre\$T";
$lang['iverecentlyseen'] = "i've r3c3n+lY s33N";
$lang['iveignored'] = "i'VE i9N0r3d";
$lang['byignoredusers'] = "bY 19nor3D u\$3rs";
$lang['ivesubscribedto'] = "i'V3 5u8\$cr1B3d to";
$lang['startedbyfriend'] = "s+@r+ED 8Y phriEnD";
$lang['unreadstartedbyfriend'] = "uNR34D \$TD BY phrienD";
$lang['startedbyme'] = "s+ar+ED 8y mE";
$lang['unreadtoday'] = "uNread +oDay";
$lang['deletedthreads'] = "deLEteD +hr34ds";
$lang['goexcmark'] = "g0!";
$lang['folderinterest'] = "f0lder 1NTerEst";
$lang['postnew'] = "poSt nEw";
$lang['currentthread'] = "cuRr3n+ +hr3@D";
$lang['highinterest'] = "h19h 1NTer3\$+";
$lang['markasread'] = "m4Rk a5 Re4d";
$lang['next50discussions'] = "nExT 50 D1\$cU\$S1ons";
$lang['visiblediscussions'] = "viS1bLE disCuss10n\$";
$lang['selectedfolder'] = "s3L3c+ED F0lDER";
$lang['navigate'] = "n4vig4+3";
$lang['couldnotretrievefolderinformation'] = "tH3r3 4RE n0 f0lD3r\$ 4va1L@BlE.";
$lang['nomessagesinthiscategory'] = "no M3ss4G3S in +h1S C4+390RY. pl3@5e \$3lecT 4n0tH3r, 0R %s For @ll +hR34d\$";
$lang['clickhere'] = "cl1ck hEr3";
$lang['prev50threads'] = "prEVi0Us 50 +hre4D\$";
$lang['next50threads'] = "n3X+ 50 +Hr3@Ds";
$lang['nextxthreads'] = "n3x+ %s +hRE4d\$";
$lang['threadstartedbytooltip'] = "thRE4d #%s s+@r+3D 8Y %s. v1EwEd %s";
$lang['threadviewedonetime'] = "1 t1Me";
$lang['threadviewedtimes'] = "%d +1mes";
$lang['unreadthread'] = "unre4d tHre4d";
$lang['readthread'] = "rE4d thrE4D";
$lang['unreadmessages'] = "unRE4d m3ss4G3\$";
$lang['subscribed'] = "sU8\$crIbED";
$lang['ignorethisfolder'] = "i9NORe th1s Ph0lDEr";
$lang['stopignoringthisfolder'] = "s+op i9N0r1Ng +hi\$ Ph0lD3R";
$lang['stickythreads'] = "s+ICKy +hr3aDs";
$lang['mostunreadposts'] = "m0St UNre4D po\$+S";
$lang['onenew'] = "%d n3w";
$lang['manynew'] = "%d NEw";
$lang['onenewoflength'] = "%d NEw oph %d";
$lang['manynewoflength'] = "%d n3w OPH %d";
$lang['ignorefolderconfirm'] = "are J00 \$UR3 j00 W4nt to i9nor3 +his f0lDEr?";
$lang['unignorefolderconfirm'] = "are j00 5uRE j00 w4N+ to \$+0P I9Nor1Ng +His f0lDER?";
$lang['confirmmarkasread'] = "aRe j00 5UrE j00 want t0 m4rK Teh SEL3c+eD tHr34d\$ 4s r34d?";
$lang['successfullymarkreadselectedthreads'] = "sUccEssfully M@Rk3D sel3c+3d +hre4D\$ @s rEaD";
$lang['failedtomarkselectedthreadsasread'] = "f41l3d +0 M4rk \$EL3c+3D thr34Ds @\$ re4D";
$lang['gotofirstpostinthread'] = "go +0 Phirs+ p05+ in +hR3aD";
$lang['gotolastpostinthread'] = "gO +0 l4st p0sT 1n +HR3@D";
$lang['viewmessagesinthisfolderonly'] = "vI3w m3Ss4g3s 1N +His f0lder 0NLy";
$lang['shownext50threads'] = "sHow n3x+ 50 +hrE4D\$";
$lang['showprev50threads'] = "sh0w pr3V10us 50 ThreAD\$";
$lang['createnewdiscussioninthisfolder'] = "cR3@tE new discu\$siON 1n th1\$ F0lDEr";
$lang['nomessages'] = "nO meSSa935";

// HTML toolbar (htmltools.inc.php) ------------------------------------
$lang['bold'] = "bOLd";
$lang['italic'] = "iTAL1c";
$lang['underline'] = "underlin3";
$lang['strikethrough'] = "sTRIk3+HROu9h";
$lang['superscript'] = "sUp3r5CRip+";
$lang['subscript'] = "su8\$CR1p+";
$lang['leftalign'] = "lEPh+-4l1gn";
$lang['center'] = "c3nt3R";
$lang['rightalign'] = "r19H+-al1Gn";
$lang['numberedlist'] = "nUm8ErEd l1st";
$lang['list'] = "li\$+";
$lang['indenttext'] = "iNdEn+ +Ext";
$lang['code'] = "coDE";
$lang['quote'] = "qUo+e";
$lang['spoiler'] = "sP0il3r";
$lang['horizontalrule'] = "hOR1zonT4l rulE";
$lang['image'] = "iM@ge";
$lang['hyperlink'] = "hYp3RlInk";
$lang['noemoticons'] = "dI\$4BLE 3Mot1COn5";
$lang['fontface'] = "fON+ ph@c3";
$lang['size'] = "s1ze";
$lang['colour'] = "col0Ur";
$lang['red'] = "r3D";
$lang['orange'] = "oR4ng3";
$lang['yellow'] = "y3lloW";
$lang['green'] = "gR3en";
$lang['blue'] = "bLu3";
$lang['indigo'] = "iNDi9o";
$lang['violet'] = "vI0let";
$lang['white'] = "whi+e";
$lang['black'] = "bl@ck";
$lang['grey'] = "greY";
$lang['pink'] = "p1nK";
$lang['lightgreen'] = "lI9ht gr3En";
$lang['lightblue'] = "l19h+ blu3";

// Forum Stats (messages.inc.php - messages_forum_stats()) -------------

$lang['forumstats'] = "fOrum \$TAts";
$lang['usersactiveinthepasttimeperiod'] = "%s @c+ive iN +HE p@\$+ %s. %s";

$lang['numactiveguests'] = "<b>%s</b> Gues+5";
$lang['oneactiveguest'] = "<b>1</b> Guest";
$lang['numactivemembers'] = "<b>%s</b> Memb3Rs";
$lang['oneactivemember'] = "<b>1</b> MEmB3r";
$lang['numactiveanonymousmembers'] = "<b>%s</b> 4nonym0U\$ m3mBErs";
$lang['oneactiveanonymousmember'] = "<b>1</b> 4nonymOUS m3MBEr";

$lang['numthreadscreated'] = "<b>%s</b> ThrE4Ds";
$lang['onethreadcreated'] = "<b>1</b> +hr34d";
$lang['numpostscreated'] = "<b>%s</b> P05+S";
$lang['onepostcreated'] = "<b>1</b> Po5+";

$lang['younormal'] = "j00";
$lang['youinvisible'] = "j00 (1NV1s18lE)";
$lang['viewcompletelist'] = "vIEW COmpLete list";
$lang['ourmembershavemadeatotalofnumthreadsandnumposts'] = "ouR M3M8ErS h4v3 m4DE @ +0+@l 0pH %s 4nd %s.";
$lang['longestthreadisthreadnamewithnumposts'] = "l0N93\$t tHRE4d is <b>%s</b> w1+h %s.";
$lang['therehavebeenxpostsmadeinthelastsixtyminutes'] = "thER3 H4v3 BEEn <b>%s</b> po\$ts M4d3 in +h3 l4\$+ 60 minut3s.";
$lang['therehasbeenonepostmadeinthelastsxityminutes'] = "tHEre h@S 83en <b>1</b> Po\$+ m4D3 IN +h3 L4st 60 MInu+35.";
$lang['mostpostsevermadeinasinglesixtyminuteperiodwasnumposts'] = "mO5+ P0s+S 3V3r m4de 1N @ single 60 minu+3 p3RIod iS <b>%s</b> On %s.";
$lang['wehavenumregisteredmembersandthenewestmemberismembername'] = "we H@ve <b>%s</b> Regis+Er3D mEm83RS anD +hE nEWe\$T m3MBEr 1S <b>%s</b>.";
$lang['wehavenumregisteredmember'] = "w3 h4V3 %s REg1s+Er3D mEm83Rs.";
$lang['wehaveoneregisteredmember'] = "w3 h4ve 0N3 R391s+Er3D mEm83R.";
$lang['mostuserseveronlinewasnumondate'] = "m0S+ useR\$ Ever onl1n3 was <b>%s</b> on %s.";
$lang['statsdisplaychanged'] = "sT@+5 d1spl@y Chang3D";

// Thread Options (thread_options.php) ---------------------------------

$lang['updatessavedsuccessfully'] = "upd@tes \$4vED \$UCcessFully";
$lang['useroptions'] = "u5eR options";
$lang['markedasread'] = "m4RkED 4s r34D";
$lang['postsoutof'] = "p0s+S 0U+ oph";
$lang['interest'] = "iNt3rest";
$lang['closedforposting'] = "cLOseD phOr po\$+1ng";
$lang['locktitleandfolder'] = "lock T1Tl3 4ND phoLDeR";
$lang['deletepostsinthreadbyuser'] = "d3LE+3 pos+S in +hr3aD 8Y u\$er";
$lang['deletethread'] = "d3le+3 threaD";
$lang['permenantlydelete'] = "p3RM4nentLY d3l3t3";
$lang['movetodeleteditems'] = "moVE t0 D3l3teD +hRE4Ds";
$lang['undeletethread'] = "uNd3let3 +hr3Ad";
$lang['threaddeletedpermenantly'] = "thr34d dEl3+3D P3RM4n3N+Ly. c4Nno+ UnDEl3tE.";
$lang['markasunread'] = "mArk as unrEaD";
$lang['makethreadsticky'] = "m@k3 +hrE4D stiCKy";
$lang['threareadstatusupdated'] = "tHRE@D r3@D s+@+u\$ UpDA+ED 5UCCEssfulLy";
$lang['interestupdated'] = "tHRE4d In+3REst st4+Us Upd4+3D suCC3SsphuLly";
$lang['failedtoupdatethreadreadstatus'] = "f4il3d to Upda+e +hR34d rE4d s+@tu\$";
$lang['failedtoupdatethreadinterest'] = "fa1l3D t0 upD@+E +hR3@D In+3rEst";
$lang['failedtorenamethread'] = "f4Il3D t0 ren4M3 Thr3@D";
$lang['failedtomovethread'] = "f41L3D +0 mov3 thRE4D to spEC1f13D ph0LDeR";
$lang['failedtoupdatethreadstickystatus'] = "f41LEd +o UpD4+3 thr3@D 5+1cky 5+4Tus";
$lang['failedtoupdatethreadclosedstatus'] = "f41leD +0 upD4T3 thrE4D Clo\$ed \$T4tu\$";
$lang['failedtoupdatethreadlockstatus'] = "f@il3D to updatE thrE4D l0CK 5+4+us";
$lang['failedtodeletepostsbyuser'] = "f4iL3d t0 DEl3+3 po\$ts by \$eLECTED usEr";
$lang['failedtodeletethread'] = "f41L3d TO DeL3T3 +hR3ad.";
$lang['failedtoundeletethread'] = "f4il3D +o Un-dElETE thRe4d";

// Dictionary (dictionary.php) -----------------------------------------

$lang['dictionary'] = "d1ct10n@ry";
$lang['spellcheck'] = "sP3ll ch3CK";
$lang['notindictionary'] = "n0T 1n DiC+10NarY";
$lang['changeto'] = "chAN9e t0";
$lang['restartspellcheck'] = "rE\$t4R+";
$lang['cancelchanges'] = "c@Ncel Ch4ng3\$";
$lang['initialisingdotdotdot'] = "iN1TI4lising...";
$lang['spellcheckcomplete'] = "sp3ll cheCk is CompL3+e. t0 rest4R+ 5P3lL Ch3CK cl1Ck r3staR+ 8U+t0N B3l0w.";
$lang['spellcheck'] = "speLL CH3Ck";
$lang['noformobj'] = "nO fORM obJ3C+ \$P3cifiED ph0R r3+uRn +Ex+";
$lang['bodytext'] = "b0Dy +3x+";
$lang['ignore'] = "iGnore";
$lang['ignoreall'] = "iGn0Re 4ll";
$lang['change'] = "cH@N9E";
$lang['changeall'] = "ch@N93 all";
$lang['add'] = "aDd";
$lang['suggest'] = "sUgges+";
$lang['nosuggestions'] = "(nO \$U9gest10ns)";
$lang['cancel'] = "c4ncel";
$lang['dictionarynotinstalled'] = "nO dic+i0n@ry H4s BE3N inSt4LlED. pl3@sE c0N+4c+ +HE ph0RUm owN3r +0 R3m3DY th1S.";

// Permissions keys ----------------------------------------------------

$lang['postreadingallowed'] = "poS+ rEAd1NG @lloweD";
$lang['postcreationallowed'] = "p0st crE4+i0n @LL0w3d";
$lang['threadcreationallowed'] = "thrE4d creaT10n 4ll0W3d";
$lang['posteditingallowed'] = "p0st Ed1t1NG 4LLow3D";
$lang['postdeletionallowed'] = "p0st DelE+i0N 4ll0w3d";
$lang['attachmentsallowed'] = "a++4chM3nts @ll0Wed";
$lang['htmlpostingallowed'] = "h+Ml p0sT1ng @llow3D";
$lang['signatureallowed'] = "s1gN4+ure @Ll0W3D";
$lang['guestaccessallowed'] = "gUest 4CC3sS @lloWED";
$lang['postapprovalrequired'] = "p0\$T 4PPr0val requir3D";

// RSS feeds gubbins

$lang['rssfeed'] = "r\$\$ FEEd";
$lang['every30mins'] = "eVeRY 30 M1nu+3s";
$lang['onceanhour'] = "onc3 4n hoUr";
$lang['every6hours'] = "ev3ry 6 Hour5";
$lang['every12hours'] = "eV3Ry 12 HOurs";
$lang['onceaday'] = "once @ d@y";
$lang['rssfeeds'] = "r5s phE3Ds";
$lang['feedname'] = "fEed n4m3";
$lang['feedfoldername'] = "f33D folDer nAmE";
$lang['feedlocation'] = "fE3D l0c@t10N";
$lang['threadtitleprefix'] = "tHread t1Tl3 PREph1X";
$lang['feednameandlocation'] = "fe3d n@m3 4ND L0c4Tion";
$lang['feedsettings'] = "fE3d se++1n9s";
$lang['updatefrequency'] = "upd@+E fr3Qu3nCY";
$lang['rssclicktoreadarticle'] = "cL1ck here +0 r34D +his 4Rt1ClE";
$lang['addnewfeed'] = "add new FeED";
$lang['editfeed'] = "eD1+ f33d";
$lang['feeduseraccount'] = "fe3d u\$er aCCOUnt";
$lang['noexistingfeeds'] = "n0 3Xist1n9 R\$\$ FEEds F0UnD. +0 aDD @ Ph3ED CliCk thE '@dD n3W' 8U++on 83l0w";
$lang['rssfeedhelp'] = "hERE j00 C@n s3tUP som3 r\$\$ phE3Ds F0r @u+0Mat1c proPa9@+10n 1N+0 Y0ur phorUm. teh 1+3m\$ phrom t3H r5\$ FE3D5 j00 4dD w1ll 83 cr34+ED @\$ tHREaDs wh1Ch U\$3rs can r3PLy to a5 iph +HEY w3R3 norm4l p0s+\$. +3h r\$S fE3D mU\$T b3 AcCEs51blE vi4 Ht+p or it w1ll NO+ W0rk.";
$lang['mustspecifyrssfeedname'] = "mU\$+ \$P3cify rSS feED n@m3";
$lang['mustspecifyrssfeeduseraccount'] = "mU5T sp3Ciphy r5S fe3d U53R @cC0UNT";
$lang['mustspecifyrssfeedfolder'] = "mUsT 5peC1PHy rs\$ FeeD f0lDEr";
$lang['mustspecifyrssfeedurl'] = "mU\$+ \$P3cify r\$S ph3ED url";
$lang['mustspecifyrssfeedupdatefrequency'] = "mu\$+ sp3c1phy Rs\$ PHE3D upD@+e Phr3qU3nCY";
$lang['unknownrssuseraccount'] = "uNKNown rs5 U\$3r @CC0unt";
$lang['rssfeedsupportshttpurlsonly'] = "r5S ph3ED supp0RTs http Url\$ 0nly. SECUr3 FeEDs (H+tPS://) 4RE n0+ \$UPp0rTED.";
$lang['rssfeedurlformatinvalid'] = "rsS phE3D Url PhoRm@+ is iNv4L1D. uRl mUs+ INClUDE sCheMe (3.G. h+tp://) and 4 Ho\$+NAmE (3.g. wWw.hos+n4M3.coM).";
$lang['rssfeeduserauthentication'] = "r\$s f33D doEs n0t 5upp0R+ h+tp usEr 4U+hENT1CAt10n";
$lang['successfullyremovedselectedfeeds'] = "sucCE\$SPhullY rEm0vED \$eLECTED F33ds";
$lang['successfullyaddedfeed'] = "succ3sSPHUlly @DDED New fEED";
$lang['successfullyeditedfeed'] = "suCC3SsphuLLY 3D1TeD PhE3d";
$lang['failedtoremovefeeds'] = "fA1l3D t0 R3move s0m3 OR 4ll OF +h3 53L3C+3d fEEDS";
$lang['failedtoaddnewrssfeed'] = "f4il3d +0 aDd n3W r\$s ph3Ed";
$lang['failedtoupdaterssfeed'] = "f@IL3d +0 upd4+E rs\$ ph3ED";
$lang['rssstreamworkingcorrectly'] = "rSs \$tREAM 4Ppe4r5 To be w0rk1NG c0rRECTLy";
$lang['rssstreamnotworkingcorrectly'] = "rSs \$Tre4m w@\$ 3mpty 0R c0uLD n0+ B3 ph0uNd";
$lang['invalidfeedidorfeednotfound'] = "iNv@L1D phE3D 1D oR fEED no+ PHound";

// PM Export Options

$lang['pmexportastype'] = "eXPor+ @\$ +YpE";
$lang['pmexporthtml'] = "h+mL";
$lang['pmexportxml'] = "xMl";
$lang['pmexportplaintext'] = "pl@in tExt";
$lang['pmexportmessagesas'] = "expor+ MEss4G3s 4\$";
$lang['pmexportonefileforallmessages'] = "on3 f1l3 For 4ll m3ss4g3s";
$lang['pmexportonefilepermessage'] = "oN3 PHile pEr m3ss49e";
$lang['pmexportattachments'] = "eXp0r+ aT+@ChM3nts";
$lang['pmexportincludestyle'] = "iNCluDE F0rUm s+yl3 \$HEET";
$lang['pmexportwordfilter'] = "applY w0rd ph1L+3R +0 M3sS49es";

// Thread merge / split options

$lang['threadhasbeensplit'] = "tHread h4s BEEN \$PL1t";
$lang['threadhasbeenmerged'] = "tHreAD has 8E3N mErg3D";
$lang['mergesplitthread'] = "meRgE / \$pl1+ +hr34d";
$lang['mergewiththreadid'] = "m3R93 w1+H +hR34d iD:";
$lang['postsinthisthreadatstart'] = "p0St\$ in +hi\$ +hr3aD 4+ \$+4rt";
$lang['postsinthisthreadatend'] = "p0\$TS 1N thi\$ +hr34d aT enD";
$lang['reorderpostsintodateorder'] = "rE-order po\$+s Into d4+3 0rD3r";
$lang['splitthreadatpost'] = "sPL1+ +Hre4D 4+ p05t:";
$lang['selectedpostsandrepliesonly'] = "s3L3C+eD pos+ 4ND R3Pl1Es 0NlY";
$lang['selectedandallfollowingposts'] = "sELECTED 4nD all f0LL0wing p0s+S";

$lang['threadmovedhere'] = "heR3";

$lang['thisthreadhasmoved'] = "<b>thR3ADs mErg3D:</b> +h1\$ Thre4D H4\$ movED %s";
$lang['thisthreadwasmergedfrom'] = "<b>thR34d\$ MeRgED:</b> +His +hr34d W4S m3rgeD pHrom %s";
$lang['somepostsinthisthreadhavebeenmoved'] = "<b>thR34d \$PLi+:</b> \$0m3 P0st\$ IN +his THre4D H4VE 8E3N mov3D %s";
$lang['somepostsinthisthreadweremovedfrom'] = "<b>tHRE@D spli+:</b> SOm3 p0\$+S in +hiS +hr3aD w3R3 m0v3D from %s";

$lang['thisposthasbeenmoved'] = "<b>tHre4D \$pl1t:</b> +hIs po\$+ h4s 83en moveD %s";

$lang['invalidfunctionarguments'] = "inV4LID phunC+i0n aR9umEn+\$";
$lang['couldnotretrieveforumdata'] = "could n0T R3tr13ve f0RUM da+4";
$lang['cannotmergepolls'] = "oN3 0R m0rE +hr3AD\$ 1\$ A Poll. j00 canN0+ m3r93 P0ll\$";
$lang['couldnotretrievethreaddatamerge'] = "cOuld not r3+riEVe +hr34d D4+A phrom on3 0R m0RE thr34Ds";
$lang['couldnotretrievethreaddatasplit'] = "couLD not r3trieve +hr34d d4TA phR0m s0URce +hr3aD";
$lang['couldnotretrievepostdatamerge'] = "could n0+ retr13v3 p0\$+ d@t4 Phrom on3 0r M0re thrE4Ds";
$lang['couldnotretrievepostdatasplit'] = "cOuLD n0T retRIEvE pO\$+ D4t@ From 5OUrC3 +hrE4D";
$lang['failedtocreatenewthreadformerge'] = "f4il3D +0 CR3a+e new +hR34d phOr meRGE";
$lang['failedtocreatenewthreadforsplit'] = "f@il3d +0 cre4+e n3W ThrEaD F0r \$pL1+";

// Thread subscriptions

$lang['threadsubscriptions'] = "thr3@d \$ubsCr1P+i0NS";
$lang['couldnotupdateinterestonthread'] = "c0uLD no+ UpD4T3 1N+3REs+ on +hrE@D '%s'";
$lang['threadinterestsupdatedsuccessfully'] = "tHre4D inter3S+5 uPD4+3D suCc3SSfulLy";
$lang['nothreadsubscriptions'] = "j00 4rE no+ 5uB\$cr1B3d to ANy thr3@d\$.";
$lang['resetselected'] = "r3SEt s3lECT3D";
$lang['allthreadtypes'] = "all THr34d +yp3s";
$lang['ignoredthreads'] = "igN0red +hrE4D\$";
$lang['highinterestthreads'] = "h19H 1nt3R3S+ thrEads";
$lang['subscribedthreads'] = "sub\$Cr1b3D Thre4Ds";
$lang['currentinterest'] = "cUrRent 1ntEr35+";

// Browseable user profiles

$lang['youcanonlyaddthreecolumns'] = "j00 c4n 0NLY @DD 3 ColUmns. t0 4dd a n3w COlUmn Close @N 3XI\$t1ng on3";
$lang['columnalreadyadded'] = "j00 h4vE alr34dY add3d +h1s c0lUmn. 1F j00 w4nt T0 reM0v3 1+ cl1Ck i+s CL053 8uT+On";

?>
