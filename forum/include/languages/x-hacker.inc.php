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

/* $Id: x-hacker.inc.php,v 1.254 2007-10-13 20:41:22 decoyduck Exp $ */

// British English language file

// Language character set and text direction options -------------------

$lang['_isocode'] = "en";
$lang['_textdir'] = "ltr";

// Months --------------------------------------------------------------

$lang['month'][1]  = "j4nu@RY";
$lang['month'][2]  = "fe8rU4rY";
$lang['month'][3]  = "m@Rch";
$lang['month'][4]  = "aPr1l";
$lang['month'][5]  = "m@Y";
$lang['month'][6]  = "juN3";
$lang['month'][7]  = "jULy";
$lang['month'][8]  = "auGUst";
$lang['month'][9]  = "s3P+3MbEr";
$lang['month'][10] = "oc+OBER";
$lang['month'][11] = "n0vem83r";
$lang['month'][12] = "deceMbEr";

$lang['month_short'][1]  = "j@N";
$lang['month_short'][2]  = "f38";
$lang['month_short'][3]  = "mAr";
$lang['month_short'][4]  = "apR";
$lang['month_short'][5]  = "m4y";
$lang['month_short'][6]  = "jUN";
$lang['month_short'][7]  = "juL";
$lang['month_short'][8]  = "aU9";
$lang['month_short'][9]  = "s3P";
$lang['month_short'][10] = "oc+";
$lang['month_short'][11] = "n0v";
$lang['month_short'][12] = "d3C";

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
$lang['date_periods']['month']  = "%s m0nTH";
$lang['date_periods']['week']   = "%s w3ek";
$lang['date_periods']['day']    = "%s DAy";
$lang['date_periods']['hour']   = "%s H0ur";
$lang['date_periods']['minute'] = "%s MInUT3";
$lang['date_periods']['second'] = "%s 5eConD";

// As above but plurals (2 years vs. 1 year, etc.)

$lang['date_periods_plural']['year']   = "%s yE4r\$";
$lang['date_periods_plural']['month']  = "%s mon+HS";
$lang['date_periods_plural']['week']   = "%s WEEks";
$lang['date_periods_plural']['day']    = "%s D4y\$";
$lang['date_periods_plural']['hour']   = "%s H0ur\$";
$lang['date_periods_plural']['minute'] = "%s m1Nu+E\$";
$lang['date_periods_plural']['second'] = "%s seCoNDs";

// Short hand periods (example: 1y, 2m, 3w, 4d, 5hr, 6min, 7sec)

$lang['date_periods_short']['year']   = "%sy";    // 1y
$lang['date_periods_short']['month']  = "%sm";    // 2m
$lang['date_periods_short']['week']   = "%sW";    // 3w
$lang['date_periods_short']['day']    = "%sD";    // 4d
$lang['date_periods_short']['hour']   = "%shr";   // 5hr
$lang['date_periods_short']['minute'] = "%sM1N";  // 6min
$lang['date_periods_short']['second'] = "%sSEc";  // 7sec

// Common words --------------------------------------------------------

$lang['percent'] = "p3RC3n+";
$lang['average'] = "avER4g3";
$lang['approve'] = "appR0v3";
$lang['banned'] = "baNn3d";
$lang['locked'] = "lOck3d";
$lang['add'] = "add";
$lang['advanced'] = "aDv4nCED";
$lang['active'] = "aCtivE";
$lang['style'] = "s+YlE";
$lang['go'] = "gO";
$lang['folder'] = "foLDER";
$lang['ignoredfolder'] = "iGn0REd pHoLDER";
$lang['folders'] = "f0ld3Rs";
$lang['thread'] = "tHR34D";
$lang['threads'] = "thr34D\$";
$lang['threadlist'] = "thRE4D L1ST";
$lang['message'] = "mE\$s4g3";
$lang['messagenumber'] = "m3\$s49e number";
$lang['from'] = "fR0m";
$lang['to'] = "t0";
$lang['all_caps'] = "aLL";
$lang['of'] = "oPh";
$lang['reply'] = "r3Ply";
$lang['forward'] = "fORW4RD";
$lang['replyall'] = "rePlY T0 alL";
$lang['pm_reply'] = "reply @s Pm";
$lang['delete'] = "deL3+3";
$lang['deleted'] = "deL3TED";
$lang['edit'] = "edI+";
$lang['privileges'] = "pRiv1l3gEs";
$lang['ignore'] = "iGnor3";
$lang['normal'] = "noRM4l";
$lang['interested'] = "iNT3re\$TED";
$lang['subscribe'] = "suBscr183";
$lang['apply'] = "aPPLY";
$lang['download'] = "d0wNLo4d";
$lang['save'] = "s@VE";
$lang['update'] = "upD4+E";
$lang['cancel'] = "caNCEl";
$lang['retry'] = "rE+ry";
$lang['continue'] = "cONt1NUE";
$lang['attachment'] = "a+tacHm3n+";
$lang['attachments'] = "a++@CHMENts";
$lang['imageattachments'] = "im4g3 4t+@ChmEnTs";
$lang['filename'] = "fil3N@me";
$lang['dimensions'] = "dIm3n\$10ns";
$lang['downloadedxtimes'] = "d0WnL0@D3d: %d +im3\$";
$lang['downloadedonetime'] = "dOwnl0@D3D: 1 +Im3";
$lang['size'] = "siZ3";
$lang['viewmessage'] = "vi3w mESs493";
$lang['deletethumbnails'] = "d3L3+3 THum8n@1Ls";
$lang['logon'] = "lO90n";
$lang['more'] = "mORE";
$lang['recentvisitors'] = "rec3N+ visi+0Rs";
$lang['username'] = "u\$3rn4M3";
$lang['clear'] = "cle4r";
$lang['action'] = "act10n";
$lang['unknown'] = "unKNowN";
$lang['none'] = "none";
$lang['preview'] = "pr3V1eW";
$lang['post'] = "po\$+";
$lang['posts'] = "pO5t\$";
$lang['change'] = "cH@ngE";
$lang['yes'] = "y3S";
$lang['no'] = "n0";
$lang['signature'] = "s1GN4+uRe";
$lang['signaturepreview'] = "si9na+ur3 Pr3VIew";
$lang['signatureupdated'] = "siGN@tUr3 upD4+3D";
$lang['signatureupdatedforallforums'] = "s1GN4TUR3 UpD4T3d F0R ALl FOrUM5";
$lang['back'] = "bACk";
$lang['subject'] = "su8Ject";
$lang['close'] = "cL0SE";
$lang['name'] = "n@ME";
$lang['description'] = "d3\$CriP+i0n";
$lang['date'] = "d4T3";
$lang['view'] = "vI3W";
$lang['enterpasswd'] = "enT3R p@\$SWoRD";
$lang['passwd'] = "p4sswORd";
$lang['ignored'] = "i9N0ReD";
$lang['guest'] = "gU3\$T";
$lang['next'] = "n3XT";
$lang['prev'] = "prEV10uS";
$lang['others'] = "o+HeRs";
$lang['nickname'] = "nickn@m3";
$lang['emailaddress'] = "emaIL @dDRe\$s";
$lang['confirm'] = "cOnf1Rm";
$lang['email'] = "eM41L";
$lang['poll'] = "polL";
$lang['friend'] = "fRi3ND";
$lang['success'] = "sUcCEss";
$lang['error'] = "erR0R";
$lang['warning'] = "w@rn1N9";
$lang['guesterror'] = "s0Rry, j00 n3ed +0 8e l0G93D In +o U\$e thi\$ Ph34+Ure.";
$lang['loginnow'] = "l09in N0w";
$lang['unread'] = "unRE4D";
$lang['all'] = "aLL";
$lang['allcaps'] = "aLL";
$lang['permissions'] = "pErMIssi0Ns";
$lang['type'] = "tyPE";
$lang['print'] = "pRin+";
$lang['sticky'] = "stICKy";
$lang['polls'] = "p0ll\$";
$lang['user'] = "u\$3r";
$lang['enabled'] = "eN@8leD";
$lang['disabled'] = "di\$4BLED";
$lang['options'] = "opTi0n\$";
$lang['emoticons'] = "eMOT1Con\$";
$lang['webtag'] = "wE8t4g";
$lang['makedefault'] = "m4k3 dEph4UL+";
$lang['unsetdefault'] = "uNSet Def4ul+";
$lang['rename'] = "r3N4m3";
$lang['pages'] = "p49es";
$lang['used'] = "u5Ed";
$lang['days'] = "d4yS";
$lang['usage'] = "us@93";
$lang['show'] = "sHow";
$lang['hint'] = "h1N+";
$lang['new'] = "n3W";
$lang['referer'] = "rEfer3R";
$lang['thefollowingerrorswereencountered'] = "t3H f0ll0winG 3RrOrs wEr3 3nC0un+3rED:";

// Admin interface (admin*.php) ----------------------------------------

$lang['admintools'] = "aDM1n toOLs";
$lang['forummanagement'] = "fOrUm m@n4gEm3nt";
$lang['accessdeniedexp'] = "j00 D0 not h4V3 P3RmissI0N To Us3 Th1\$ 53c+i0N.";
$lang['managefolders'] = "m4n4G3 pHolDers";
$lang['manageforums'] = "m4n49E F0rUm\$";
$lang['manageforumpermissions'] = "m@N@9E ph0rum PErMi\$SI0N5";
$lang['foldername'] = "f0LD3r n4m3";
$lang['move'] = "mov3";
$lang['closed'] = "clOS3d";
$lang['open'] = "oPen";
$lang['restricted'] = "rE\$TRiCTEd";
$lang['forumiscurrentlyclosed'] = "%s I\$ currENtlY Clo\$eD";
$lang['youdonothaveaccesstoforum'] = "j00 do No+ h@V3 4CC3ss +o %s";
$lang['toapplyforaccessplease'] = "t0 apPLY f0r 4CC3SS pL3asE c0n+@Ct +hE ph0rUm own3R.";
$lang['adminforumclosedtip'] = "iPH j00 w@n+ +o CH4Ng3 som3 s3tT1NG\$ on y0ur phOrUm clICk tH3 4DM1n lInK 1n +H3 n4v1g@T1On b4r @8OVE.";
$lang['newfolder'] = "nEw ph0ld3r";
$lang['nofoldersfound'] = "nO ex1st1ng F0LDER5 phoUnD. tO 4dD 4 PhOlDER CLick +Eh 'aDD N3W' BUt+0n bel0W.";
$lang['forumadmin'] = "foRUM adM1N";
$lang['adminexp_1'] = "u\$E Th3 mENU oN tHE lephT +0 m4N@G3 +hInGs 1N Y0Ur pHorUm.";
$lang['adminexp_2'] = "<b>uSErs</b> ALLOw\$ J00 to seT indiVIDU4l u\$3r PERmIsSi0nS, 1ncLUDING 4PPo1n+iNg MoDEr4t0R\$ AND 949g1ng p30pl3.";
$lang['adminexp_3'] = "<b>u\$3r GR0up\$</b> 4ll0W\$ J00 +0 Cr34t3 us3r 9roupS T0 @\$sign pERm15\$1oN\$ to 4\$ M4Ny 0r @s ph3w USer\$ qu1ckLy @nD E4\$ILY.";
$lang['adminexp_4'] = "<b>b4N Con+Rols</b> allOws tHE 84nn1NG 4ND Un-B4nniNg 0Ph 1P ADDREs\$ES, h+tP REf3rer\$, us3rN@ME\$, 3m41L adDRESsE\$ @nD n1Ckn4m3s.";
$lang['adminexp_5'] = "<b>f0lder5</b> 4ll0w\$ +3h CrE4T10N, moD1Ph1C4+10n 4nD D3LEt10n oPh PhoLdEr\$.";
$lang['adminexp_6'] = "<b>r\$s FE3Ds</b> 4ll0w5 j00 tO mAn493 rS5 Phe3ds Ph0r pr0P@G4+i0n INt0 y0ur pHORUM.";
$lang['adminexp_7'] = "<b>pROfiL3S</b> L3+S J00 cUs+0Mi\$3 +Eh 1+3m5 Tha+ @PP3AR 1N tH3 usER Pr0f1l35.";
$lang['adminexp_8'] = "<b>f0Rum \$E++iNgs</b> 4LL0WS J00 t0 CUS+0mISE yoUR pHoRUm's N4ME, aPp3@R@NCe @ND M4Ny 0Th3r +HiN9s.";
$lang['adminexp_9'] = "<b>sT4r+ p@9E</b> let\$ j00 cu\$+0m1s3 Y0ur FoRum's 5+@R+ p49E.";
$lang['adminexp_10'] = "<b>f0RUM s+ylE</b> ALlow5 J00 +o 93nEr@+e R4nD0M 5+yles F0R Y0Ur phoRuM M3m83Rs +o USE.";
$lang['adminexp_11'] = "<b>woRD F1LtER</b> AllOws j00 +0 phil+3R WorDs j00 DON'T W4Nt +0 83 usEd 0N YoUr ForUM.";
$lang['adminexp_12'] = "<b>p0sTIN9 \$T4+\$</b> 9ener4tes a r3p0r+ L15+iNg +H3 +0P 10 pOsTer5 in 4 D3FiNEd P3RI0d.";
$lang['adminexp_13'] = "<b>foRUm l1NKs</b> LeTs J00 m4NA93 +hE l1nK\$ dr0PD0WN 1n +HE n4vi9@+IOn 8ar.";
$lang['adminexp_14'] = "<b>vi3w l09</b> Li5+s rECeNT 4ct1ON\$ BY ThE F0RUM M0D3ra+0Rs.";
$lang['adminexp_15'] = "<b>m@n49E F0RUm\$</b> l3tS J00 CRE4+3 4nd D3L3tE @nD CL053 0R r30PEn forum5.";
$lang['adminexp_16'] = "<b>gLOB@L pHoRUm sE++1N9\$</b> 4Llows j00 T0 MoDify sE+tING\$ whICH 4PHFECT 4Ll pHoRum\$.";
$lang['adminexp_17'] = "<b>po\$+ 4pproV@L qUEU3</b> ALl0w\$ J00 +0 ViEw 4NY PO\$+\$ 4w4itING 4pprOV4L BY A ModER4t0R.";
$lang['adminexp_18'] = "<b>v15i+0r log</b> 4llows j00 To viEW 4N 3x+3ND3D Li\$+ Of vi\$i+0r5 inClUDIn9 +h3ir Ht+p r3FER3r\$.";
$lang['createforumstyle'] = "cRe4+3 a F0RuM s+yl3";
$lang['newstylesuccessfullycreated'] = "nEW \$tyl3 \$uCCESsfULlY CR3AtED.";
$lang['stylealreadyexists'] = "a \$+ylE wI+h +h@+ Ph1L3NamE 4LR3ady Exis+s.";
$lang['stylenofilename'] = "j00 D1d no+ ENtER 4 PhIl3namE +0 s@V3 TEh \$+yle w1tH.";
$lang['stylenodatasubmitted'] = "c0uld no+ rE4D phorUm Styl3 D@+@.";
$lang['styleexp'] = "usE +hIs p4GE +0 h3LP Cr34te 4 r4NDomLy 9EnER4T3d styLE PHor y0Ur pHOrUM.";
$lang['stylecontrols'] = "conTR0ls";
$lang['stylecolourexp'] = "clicK 0N @ C0l0ur To M4K3 @ N3w S+ylE 5H3et B453d on tH4+ C0l0UR. CURREnt 8asE C0l0UR 1\$ Phirst iN L1\$t.";
$lang['standardstyle'] = "s+4nd@RD stYlE";
$lang['rotelementstyle'] = "r0+@tED 3L3m3Nt \$+Yl3";
$lang['randstyle'] = "r@ND0M \$+yle";
$lang['thiscolour'] = "tHIs c0loUr";
$lang['enterhexcolour'] = "oR 3Nt3r 4 hEx coLOUR T0 BAs3 @ n3w s+YLE sh3et 0N";
$lang['savestyle'] = "s4V3 +hi5 \$+yL3";
$lang['styledesc'] = "sTyle de\$cr1PT10n";
$lang['stylefilenamemayonlycontain'] = "s+yl3 F1LEN4m3 m@y only CONt4IN l0w3RCas3 L3+teR\$ (a-Z), NUm8er\$ (0-9) @nD unDER\$corE.";
$lang['stylepreview'] = "s+YLE PRev13w";
$lang['welcome'] = "welc0ME";
$lang['messagepreview'] = "mE5\$49E PrEV13w";
$lang['users'] = "u5eRS";
$lang['usergroups'] = "us3r 9R0up5";
$lang['mustentergroupname'] = "j00 mUs+ EN+Er @ gr0Up N4m3";
$lang['profiles'] = "prOphiL3s";
$lang['manageforums'] = "m@N49e pHorUMs";
$lang['forumsettings'] = "f0RUm sE++1nG\$";
$lang['globalforumsettings'] = "glO84l Ph0rUm 53tt1N9s";
$lang['settingsaffectallforumswarning'] = "<b>n0TE:</b> +hEse 53t+1ngs @phpH3c+ aLl Forums. wHEr3 +3h s3tT1nG 1S dUpL1caTeD oN tEH iND1V1DU4L Ph0rum's \$3tt1nG\$ P4g3 +h4t W1LL tAkE PrEC3d3Nc3 0VER THE s3Tt1ng\$ J00 Ch4n93 h3R3.";
$lang['startpage'] = "stARt p@g3";
$lang['startpageerror'] = "yOUr S+@Rt p@gE C0ulD n0+ 8E s@vED Loc4llY T0 +HE 5erv3r 83C4U5e pErM1s\$1on w@\$ dEN1eD.</p><p>t0 CH4N9E YoUr s+@rT P49e plE4SE CLICK +eh DOwNLo4d 8U+T0n BELOw wHich w1ll PrOmp+ J00 +O \$@v3 +EH FIlE t0 your h4RD DR1V3. j00 C@N +h3N UpL0AD +hI\$ PHIl3 +0 youR s3rveR Int0 thE pholl0wing f0lD3R, 1PH n3c3s\$@ry CrE4+in9 +hE f0LD3r s+RUc+ure In +HE proc3Ss.</p><p><b>%s</b></p><p>pL34s3 NO+3 th4+ \$0m3 8r0w\$ER\$ m4y CH4n93 +eh N@M3 OPH +3h f1l3 Up0n DownloAD.  wh3n Upl0@Ding +hE phiL3 plE453 m4K3 sURE +h@t 1+ is N4med 5+4r+_mA1n.phP 0th3rW153 your st4rt P49e w1Ll 4PPE4r unCh@ng3d.";
$lang['failedtoopenmasterstylesheet'] = "y0ur f0RUM styL3 c0uLD No+ bE \$@veD 83CAuse +Eh m4\$+Er \$+yl3 sHEET COUlD N0T be l0AD3d. to 5@V3 youR sTyLE +eH mAsTEr s+ylE \$HeEt (M4K3_STYl3.cs5) mU\$+ 8e l0c4+3d 1N TEh s+Yl3\$ DIR3ct0Ry 0F YoUr 8eeh1V3 PH0rum inSt4Llat10n.";
$lang['makestyleerror'] = "yOur pHoruM 5tylE C0ulD NOT BE \$@v3D l0CALlY +o +h3 serVeR 8ECaUsE p3Rmi\$5i0n w@s DEN13d. +0 s4VE YoUr ph0RUM 5TYL3 pl34\$3 cliCk TEh DowNLO4d 8U+T0n beLow wh1CH w1Ll Pr0Mpt j00 t0 s4V3 teh f1le +0 y0Ur h@rD driv3. j00 C4n tHeN Upl0aD +hi\$ fiL3 +o Your s3rver int0 %s FolDEr, iph N3c3ssary cre@+ing +he f0LDEr struCTur3 1n +hE pr0CE\$S. j00 SH0UlD n0t3 +h4T sOmE 8rowS3rs M@Y Ch4Ng3 tEh name 0F th3 phil3 Upon d0Wnl0@D. when UPl0@D1n9 TH3 F1LE pl34se M4Ke Sur3 th@t 1+ i\$ N4m3D stylE.Cs5 o+herw1\$e +3h phorUM styl3 w1ll 83 unu\$@8LE.";
$lang['uploadfailed'] = "youR NEw \$t4R+ p4g3 COULD not B3 upl0@d3D +o +h3 s3Rv3r 8ecaU\$e pERMi\$si0n W@\$ D3n13D. pl3453 chECK TH4+ tH3 W38 serVEr / php proC3ss is 4BLE +0 wr1+3 +0 +hE %s pHOlDer oN y0ur s3rver.";
$lang['forumstyle'] = "fOrum s+YlE";
$lang['wordfilter'] = "wORD Fil+3r";
$lang['forumlinks'] = "f0Rum l1NKs";
$lang['viewlog'] = "vIew Log";
$lang['noprofilesectionspecified'] = "n0 Pr0pHIL3 s3C+Ion 5PeCifi3D.";
$lang['itemname'] = "i+3m n4M3";
$lang['moveto'] = "mOVE +0";
$lang['manageprofilesections'] = "m4N4g3 pr0fIL3 \$ECt10n5";
$lang['sectionname'] = "sect10n nam3";
$lang['items'] = "iT3M\$";
$lang['mustspecifyaprofilesectionid'] = "mu\$+ 5p3c1Phy @ pR0Ph1l3 s3cti0n 1D";
$lang['mustsepecifyaprofilesectionname'] = "muS+ 5p3C1fy 4 Pr0PhIlE s3CTIoN N4m3";
$lang['noprofilesectionsfound'] = "nO 3xi\$+1NG prophiL3 \$ect1ONs PhounD. To aDD @ pRoPh1L3 SeC+1ON Cl1Ck +Eh 'adD nEW' BUtt0n B3L0w.";
$lang['addnewprofilesection'] = "aDd new ProFile sEct1on";
$lang['successfullyaddedprofilesection'] = "sUCC3\$sfUlLy 4DDED Pr0file s3C+I0N";
$lang['successfullyeditedprofilesection'] = "sUcCEssFUlLy eDi+ED pR0PhIlE s3C+I0n";
$lang['addnewprofilesection'] = "add new PRophIlE s3C+1on";
$lang['mustsepecifyaprofilesectionname'] = "mUs+ spECIphy a ProF1L3 s3ctioN nAme";
$lang['successfullyremovedselectedprofilesections'] = "sucC3ssphUlly rEm0VED \$el3C+3D PRof1L3 s3C+i0nS";
$lang['failedtoremoveprofilesections'] = "f4iLED +o r3mov3 pr0pHILe s3c+i0N\$";
$lang['viewitems'] = "v13w 1+Em\$";
$lang['successfullyaddednewprofileitem'] = "sUcce\$sfullY 4dD3d n3W Pr0FiL3 1+3m";
$lang['successfullyeditedprofileitem'] = "sUcCE5\$FULLY eD1+3D pR0PH1l3 iTEm";
$lang['successfullyremovedselectedprofileitems'] = "succ3sspHulLy remoVED 53l3C+3d prOph1L3 itEMs";
$lang['failedtoremoveprofileitems'] = "fa1lED +O remOvE pr0phiLE I+ems";
$lang['noexistingprofileitemsfound'] = "th3RE @RE nO 3x1STinG ProFil3 1t3MS in +h1S S3C+I0N. +0 @Dd @n I+Em CL1cK t3H '@Dd n3W' But+on 83low.";
$lang['edititem'] = "ed1T IT3m";
$lang['invalidprofilesectionid'] = "iNV4Lid pr0Phil3 SECT10N 1d 0r S3c+10n n0t PhOUND";
$lang['invalidprofileitemid'] = "iNv4l1D Pr0F1l3 1TEM 1D or 1T3M n0T f0UnD";
$lang['addnewitem'] = "aDd n3W 1+Em";
$lang['youmustenteraprofileitemname'] = "j00 Mu\$+ en+3R 4 PRofilE i+3M N4Me";
$lang['invalidprofileitemtype'] = "iNV@L1d PRoPHilE iT3m Typ3 s3LEctED";
$lang['failedtocreatenewprofileitem'] = "f4ileD t0 CrE@+3 n3W pR0F1l3 1t3M";
$lang['failedtoupdateprofileitem'] = "f41l3D +0 upDa+3 PRophil3 iT3m";
$lang['startpageupdated'] = "s+4R+ P4Ge Upd@tEd. %s";
$lang['viewupdatedstartpage'] = "v1ew Upd4tED s+4RT p@93";
$lang['editstartpage'] = "eDIt S+@RT P@G3";
$lang['nouserspecified'] = "n0 U53R 5P3c1Ph13d.";
$lang['manageuser'] = "m@N4gE us3r";
$lang['manageusers'] = "m4N@G3 us3Rs";
$lang['userstatusforforum'] = "u\$er s+4tUs ph0R %s";
$lang['userdetails'] = "us3R d3T4iL5";
$lang['warning_caps'] = "w4rNIng";
$lang['userdeleteallpostswarning'] = "aR3 J00 \$UrE j00 W4N+ +0 DEl3+e 4lL opH +EH seL3CTED U\$3r's pO5+s? OnCe +h3 poS+5 4r3 Del3teD tH3Y C4nnO+ b3 reTR1ev3d 4nd wILl B3 l0\$+ PH0revEr.";
$lang['postssuccessfullydeleted'] = "po\$+S w3R3 sucC3S5fuLlY DEl3ted.";
$lang['folderaccess'] = "f0ldEr 4CCE\$S";
$lang['possiblealiases'] = "poSs18l3 4liase\$";
$lang['userhistory'] = "u53r hi\$+0ry";
$lang['nohistory'] = "n0 hI5+0Ry ReCorD\$ 5@v3D";
$lang['userhistorychanges'] = "chAn93\$";
$lang['clearuserhistory'] = "cl3@r u\$er hi\$+ORY";
$lang['changedlogonfromto'] = "ch4n9eD lo90N Phr0m %s TO %s";
$lang['changednicknamefromto'] = "cH4N9eD n1CKn@m3 FR0M %s +O %s";
$lang['changedemailfromto'] = "cH4nGed 3m4Il fr0m %s +0 %s";
$lang['successfullycleareduserhistory'] = "suCCEssfULLy CL34r3d USER Hi\$+0rY";
$lang['failedtoclearuserhistory'] = "f41l3D +0 cle4R U\$er h1Story";
$lang['successfullychangedpassword'] = "suCCE\$sphUlly CH4NgED passW0rd";
$lang['failedtochangepasswd'] = "f4iL3D +0 cH@n93 p45\$W0rD";
$lang['viewuserhistory'] = "vi3w u5er h1S+0rY";
$lang['viewuseraliases'] = "v13w Us3r 4l1ases";
$lang['searchreturnednoresults'] = "s34RCh r3tUrn3d no REsULts";
$lang['deleteposts'] = "dEl3+3 p0s+S";
$lang['deleteuser'] = "d3l3+3 u\$3r";
$lang['alsodeleteusercontent'] = "al\$O D3L3+e 4ll opH +h3 COn+3N+ cr34+ED 8y thI5 UsER";
$lang['userdeletewarning'] = "aRe j00 \$urE j00 want +0 dEl3T3 +h3 s3LECTEd U\$ER 4ccoUnt? OnCE tHe 4Cc0unT hAs B3EN D3l3TEd I+ CaNnOt B3 R3trieV3D 4nd WiLl 83 l0\$+ F0REvER.";
$lang['usersuccessfullydeleted'] = "u\$ER 5uCCE5SPhUlLy dElE+ED";
$lang['failedtodeleteuser'] = "f4il3D +o dEL3tE UsER";
$lang['forgottenpassworddesc'] = "ipH Th1S u\$ER h4\$ PhoR90t+3N th31r p@5SW0RD j00 C@N rESE+ 1+ F0R +h3M hER3.";
$lang['manageusersexp'] = "thIS l1ST sh0ws @ \$el3C+i0N 0pH Us3Rs Wh0 h4VE Lo993d on +0 yoUR ph0RUM, \$0rteD BY %s. +0 aL+3R @ UsER'\$ PERMi\$SI0Ns CL1CK +HEir name.";
$lang['userfilter'] = "u\$Er F1lT3R";
$lang['onlineusers'] = "oNLInE UseR\$";
$lang['offlineusers'] = "oFflinE UsER\$";
$lang['usersawaitingapproval'] = "u5er\$ 4w4ItiNg @Ppr0val";
$lang['bannedusers'] = "b4NNeD usEr\$";
$lang['lastlogon'] = "l4s+ loGon";
$lang['sessionreferer'] = "se5\$10n r3fEr3R";
$lang['signupreferer'] = "sI9N-up rEF3REr:";
$lang['nouseraccountsmatchingfilter'] = "n0 UsEr aCCoUN+s M4TChING F1lT3R";
$lang['searchforusernotinlist'] = "s34rCh Ph0R 4 U\$3r not 1N L1\$+";
$lang['adminaccesslog'] = "adMin @cC3S\$ L09";
$lang['adminlogexp'] = "tHis LI\$t \$h0w\$ teH L4s+ @CT10n\$ 5@nC+I0N3D by u\$ers with @DMiN priViL3GEs.";
$lang['datetime'] = "d@t3/T1me";
$lang['unknownuser'] = "uNKN0wn u\$er";
$lang['unknownuseraccount'] = "uNkn0wn UsEr aCC0unt";
$lang['unknownfolder'] = "unKNown ph0LDEr";
$lang['ip'] = "ip";
$lang['lastipaddress'] = "l45t ip 4DDrEss";
$lang['logged'] = "l0G9ED";
$lang['notlogged'] = "not L0gged";
$lang['addwordfilter'] = "add worD fIl+3r";
$lang['addnewwordfilter'] = "aDd n3w woRD phIl+3r";
$lang['wordfilterupdated'] = "w0rD Filt3R UpD@+3d";
$lang['filtername'] = "filTeR n@m3";
$lang['filtertype'] = "f1L+er +ypE";
$lang['filterenabled'] = "f1LtEr en@8leD";
$lang['editwordfilter'] = "ed1+ w0RD Fil+3R";
$lang['nowordfilterentriesfound'] = "n0 3XI\$+INg wOrD F1ltEr 3ntRi3s F0UnD. To ADD @ fIl+ER CLicK +3H '@DD NEW' bU++0N beL0w.";
$lang['mustspecifyfiltername'] = "j00 mUst sp3cIphY 4 phIlTeR nAmE";
$lang['mustspecifymatchedtext'] = "j00 Mus+ sp3CIpHy m4TCHED TEx+";
$lang['mustspecifyfilteroption'] = "j00 mu5+ \$P3CiPhy 4 philtER oPt1ON";
$lang['mustspecifyfilterid'] = "j00 MUsT sp3cify a FiL+3R iD";
$lang['invalidfilterid'] = "iNv4lID f1LTEr 1d";
$lang['failedtoupdatewordfilter'] = "f4Il3D t0 uPD@+3 w0rD fil+3R. ChECK tH4+ +3H fIl+3r \$+ill Ex1\$+S.";
$lang['allow'] = "all0w";
$lang['block'] = "bl0ck";
$lang['normalthreadsonly'] = "norm4L +HrE4d5 OnlY";
$lang['pollthreadsonly'] = "pOLL +hr34D\$ 0nly";
$lang['both'] = "both thR3AD +yP3s";
$lang['existingpermissions'] = "eX1s+inG p3rm1\$Si0n5";
$lang['nousershavebeengrantedpermission'] = "n0 Exis+1nG User\$ PERm1\$si0Ns F0unD. tO 9r4nt p3rMISSi0n T0 usEr5 534rCH pHoR tHEm 83l0w.";
$lang['successfullyaddedpermissionsforselectedusers'] = "sUcC3\$sfullY 4DDed perMiSs10N\$ PHOr sEL3C+3d UsEr\$";
$lang['successfullyremovedpermissionsfromselectedusers'] = "sucCEssfully REmoveD PeRm1S\$10N5 fr0M sel3c+3D U\$3r\$";
$lang['failedtoaddpermissionsforuser'] = "f4il3D +0 4dD PErM1\$S10Ns f0r u53r '%s'";
$lang['failedtoremovepermissionsfromuser'] = "f@il3D t0 rem0V3 p3RMIssion5 fr0m UsEr '%s'";
$lang['searchforuser'] = "se@RCH FoR Us3R";
$lang['browsernegotiation'] = "bRow\$3R n390tI@+3d";
$lang['largetextfield'] = "l@R9e tExt f13lD";
$lang['mediumtextfield'] = "m3D1UM tExt F1ELD";
$lang['smalltextfield'] = "sM@lL tExt F13lD";
$lang['multilinetextfield'] = "muLti-l1nE tEx+ FiEld";
$lang['radiobuttons'] = "r@dio buT+on\$";
$lang['dropdown'] = "dR0p doWn";
$lang['threadcount'] = "thR34D C0UNt";
$lang['clicktoeditfolder'] = "cL1CK to eD1+ PhOLDER";
$lang['fieldtypeexample1'] = "fOr rad10 8UtToNs 4Nd Drop D0wn pHi3lDS J00 nE3d +0 sEp4r4tE Th3 F13lDN4ME 4nD TEH v@lU3s w1+h @ C0L0n 4nd E4ch v4LU3 \$houlD b3 SEP@R4+3D by sEm1-c0l0n\$.";
$lang['fieldtypeexample2'] = "ex@mplE: tO Cr34+E @ BAs1C 9EnD3r rAD1O BUT+Ons, W1+h tWo 5ELECTion5 pH0R M@l3 4nD pH3M4L3, j00 W0UlD 3NtER: <b>gEnd3r:M@l3;ph3m4L3</b> 1n +hE 1+3m nAm3 FIElD.";
$lang['editedwordfilter'] = "edi+eD w0RD FiL+3R";
$lang['editedforumsettings'] = "eDITED ph0ruM 53+t1N9\$";
$lang['successfullyendedusersessionsforselectedusers'] = "sUcC35\$PHUllY enDED \$3ssi0ns f0r \$EL3ct3d usEr5";
$lang['failedtoendsessionforuser'] = "f4Il3d to EnD ses\$10n fOr us3R %s";
$lang['successfullyapprovedselectedusers'] = "sUcC3\$sphUlLY 4PprOvED s3l3C+3d Us3Rs";
$lang['matchedtext'] = "m4TCH3d text";
$lang['replacementtext'] = "r3PLaCemENT +3xt";
$lang['preg'] = "prEG";
$lang['wholeword'] = "wHol3 w0RD";
$lang['word_filter_help_1'] = "<b>alL</b> m4+CH3s @G4In5+ +3h Wh0l3 +3XT S0 f1ltEr1Ng moM T0 MUm WiLl 4LS0 ch@n93 mOmEnT T0 mUM3Nt.";
$lang['word_filter_help_2'] = "<b>wh0l3 w0rd</b> M4TCH3S @G@iN\$+ whol3 wOrDs onLy \$0 phIl+3r1n9 m0m to mUM wiLL No+ Ch@N93 M0ment +0 mUmeN+.";
$lang['word_filter_help_3'] = "<b>pR3g</b> @Llow5 j00 tO U5e P3Rl rEGul4R 3XPrE5S1on5 +0 m4Tch +3X+.";
$lang['nameanddesc'] = "n@M3 and DE\$crip+10n";
$lang['movethreads'] = "mOve thr34ds";
$lang['movethreadstofolder'] = "m0v3 Thr3ad\$ +0 F0LDER";
$lang['failedtomovethreads'] = "f41LED +o MOv3 +Hr34ds +0 5PECifi3d F0LD3r";
$lang['resetuserpermissions'] = "rE\$e+ U\$3r perMi5sionS";
$lang['failedtoresetuserpermissions'] = "f4il3D +0 R3set USeR PeRmI5SI0n5";
$lang['allowfoldertocontain'] = "alLow phOLDER tO COnT@In";
$lang['addnewfolder'] = "add n3W pholD3R";
$lang['mustenterfoldername'] = "j00 mu\$+ 3n+3R @ FoLD3r n4ME";
$lang['nofolderidspecified'] = "n0 ph0LD3r iD \$PECIFi3d";
$lang['invalidfolderid'] = "iNV4l1D pHoLDER 1d. CH3CK +hA+ @ ph0LD3r witH th1\$ id ex1\$+\$!";
$lang['successfullyaddednewfolder'] = "sucCE\$sFuLLy 4dD3D N3w f0ldER";
$lang['successfullyremovedselectedfolders'] = "succ3SsFUlly rEMOvED s3leC+3d pholDER\$";
$lang['successfullyeditedfolder'] = "sUcC3\$SfULly EdI+ED PhOlDeR";
$lang['failedtocreatenewfolder'] = "faIl3D +0 CR34+3 n3w f0lDEr";
$lang['failedtodeletefolder'] = "f4iL3d +0 DEL3TE F0LD3r.";
$lang['failedtoupdatefolder'] = "faiL3d to UpD4t3 F0LDER";
$lang['cannotdeletefolderwiththreads'] = "c4Nno+ d3L3+e f0LD3rS +h4t st1Ll C0nt@1n +hr3@Ds.";
$lang['forumisnotrestricted'] = "forum is no+ rEsTrICtED";
$lang['groups'] = "gr0up5";
$lang['nousergroups'] = "nO u\$er 9r0Up\$ H4V3 b3En \$e+ up. +o 4DD 4 9r0UP cLiCK ThE '4DD NEw' BuTtOn B3low.";
$lang['suppliedgidisnotausergroup'] = "sUPPLI3D g1d 1\$ N0+ 4 U\$3r 9roup";
$lang['manageusergroups'] = "m4N@G3 u\$er 9roups";
$lang['groupstatus'] = "gRoUp 5+4TUs";
$lang['addusergroup'] = "add US3r 9RoUp";
$lang['addemptygroup'] = "aDd 3mp+y gRoUP";
$lang['adduserstogroup'] = "adD U53r\$ +0 gr0UP";
$lang['addremoveusers'] = "aDd/r3m0ve User5";
$lang['nousersingroup'] = "tH3RE 4re n0 Us3R\$ in +his 9ROup. @DD U\$3rs to Th1\$ 9r0UP BY sE4rCH1ng FoR thEm 8EL0w.";
$lang['groupaddedaddnewuser'] = "succ3S\$FULLy 4dDED gRoup. 4DD U\$3r\$ +O +hI\$ groUp by SE4rcHinG pH0R +h3m 8EL0W.";
$lang['nousersingroupaddusers'] = "tHerE 4rE N0 u\$Er5 1n +H1\$ 9roup. +0 4DD U\$3R\$ CLICk ThE '@DD/R3M0v3 usER\$' BU+T0N bel0w.";
$lang['useringroups'] = "tH1s user is @ m3mBer 0f tH3 Ph0llowIn9 GROuPs";
$lang['usernotinanygroups'] = "th1\$ usEr I\$ No+ iN 4ny U\$3r gr0UP\$";
$lang['usergroupwarning'] = "nO+E: Th1S Us3r m4Y 8E InHERi+ing @DDI+i0n@L p3rmi\$\$10nS Phrom 4nY u53r 9ROups l1s+3D B3LOW.";
$lang['successfullyaddedgroup'] = "sUcC3\$sFULLy ADD3d gr0up";
$lang['successfullyeditedgroup'] = "succ3SsFULly 3D1+3d 9roup";
$lang['successfullydeletedselectedgroups'] = "sUCc3ssFUlly D3Le+ED sEl3c+3d group\$";
$lang['failedtodeletegroupname'] = "f@IL3D to d3l3+E grOUp %s";
$lang['usercanaccessforumtools'] = "user c@n 4CCESs PH0RUm t0ols 4nd C4n CR34t3, D3L3+e @ND EDIT f0rum\$";
$lang['usercanmodallfoldersonallforums'] = "u\$3R C4n modER4TE <b>aLL Ph0ld3Rs</b> on <b>aLl ph0rum\$</b>";
$lang['usercanmodlinkssectiononallforums'] = "user c4N moD3r@+3 L1nkS 5eC+1ON on <b>alL Ph0rUM\$</b>";
$lang['emailconfirmationrequired'] = "em@Il C0nph1Rm4T1On r3QUiR3D";
$lang['userisbannedfromallforums'] = "uSer i\$ BAnNED pHRom <b>aLL F0RUm5</b>";
$lang['cancelemailconfirmation'] = "c4nc3L 3m4IL CoNphirm@+i0n 4nD Allow Us3r +0 s+4R+ p0ST1N9";
$lang['resendconfirmationemail'] = "r3S3nd C0npHirm4+i0N EM41l to us3r";
$lang['donothing'] = "dO noth1N9";
$lang['usercanaccessadmintools'] = "uSEr h@\$ 4cces\$ +0 pHorUM @dmIn +0oLs";
$lang['usercanaccessadmintoolsonallforums'] = "user h@s @CC3ss +0 4DMiN tool\$ <b>on @ll Ph0rUm\$</b>";
$lang['usercanmoderateallfolders'] = "uSer c4N MoD3R@Te @lL PH0lD3rs";
$lang['usercanmoderatelinkssection'] = "u\$3r C4n moD3R4te L1Nks \$3CTioN";
$lang['userisbanned'] = "uS3r is 8anneD";
$lang['useriswormed'] = "us3r is W0RmED";
$lang['userispilloried'] = "user 1s PILL0r13d";
$lang['usercanignoreadmin'] = "uSer C4n 1Gn0RE 4DM1nis+r@+oRs";
$lang['groupcanaccessadmintools'] = "gR0Up C4N 4cC3ss @dMin tO0lS";
$lang['groupcanmoderateallfolders'] = "gR0up c@n M0D3R4te @Ll F0LD3R\$";
$lang['groupcanmoderatelinkssection'] = "gRoup C4n m0der4+3 link\$ \$3c+i0n5";
$lang['groupisbanned'] = "gR0uP iS 8annEd";
$lang['groupiswormed'] = "grOUP is w0Rm3d";
$lang['readposts'] = "r34D posts";
$lang['replytothreads'] = "rEPly t0 +hr34ds";
$lang['createnewthreads'] = "cR3a+e nEw +hrEad\$";
$lang['editposts'] = "eDit PoS+s";
$lang['deleteposts'] = "dELETE pOs+s";
$lang['postssuccessfullydeleted'] = "p05+S \$ucc3SsfulLy D3LEtED";
$lang['failedtodeleteusersposts'] = "fAil3d +0 D3Le+e usER'S p0S+s";
$lang['uploadattachments'] = "upLO4D @++4CHm3nts";
$lang['moderatefolder'] = "mOdEr4t3 f0LDER";
$lang['postinhtml'] = "po5t iN h+ml";
$lang['postasignature'] = "pOs+ 4 s1GN4tur3";
$lang['editforumlinks'] = "eDi+ phoRuM L1NkS";
$lang['linksaddedhereappearindropdown'] = "l1nKS 4dDED h3R3 aPpE4r iN @ Dr0p D0Wn In +3h t0p r1Ght of thE FR@M3 s3+.";
$lang['linksaddedhereappearindropdownaddnew'] = "l1Nks @dd3D h3re @pp3@r 1n a DRoP D0wn 1N +EH +0p R1GhT 0F +EH pHramE \$3+. +0 4DD 4 L1nk CL1ck th3 '@DD NEw' 8uttON 8eloW.";
$lang['failedtoremoveforumlink'] = "f@1leD +0 r3Mov3 f0RUm LinK '%s'";
$lang['failedtoaddnewforumlink'] = "fa1L3d t0 4DD nEW Ph0rum L1Nk '%s'";
$lang['failedtoupdateforumlink'] = "f@IL3D +0 UPDAtE pH0rUM lInK '%s'";
$lang['notoplevellinktitlespecified'] = "nO top L3VEL LiNk ti+L3 \$P3cIpHi3D";
$lang['youmustenteralinktitle'] = "j00 muS+ 3ntEr @ l1NK Ti+lE";
$lang['alllinkurismuststartwithaschema'] = "alL L1nk UrI\$ MUst s+Ar+ wi+h @ SCH3ma (1.3. h++P://, fTp://, 1RC://)";
$lang['editlink'] = "edI+ L1Nk";
$lang['addnewforumlink'] = "add n3W fOrum l1nk";
$lang['forumlinktitle'] = "f0rum liNk +i+l3";
$lang['forumlinklocation'] = "f0rUM link lOC4+i0N";
$lang['successfullyaddednewforumlink'] = "sUCCE5sFULLY 4dDEd NEW F0RUm link";
$lang['successfullyeditedforumlink'] = "sUcC3\$SFUlLy EDITED PhorUM l1nk";
$lang['invalidlinkidorlinknotfound'] = "iNv@L1D lInK iD 0r link N0t F0UnD";
$lang['successfullyremovedselectedforumlinks'] = "sUCC3\$SfULlY REMOvED sEL3cteD L1NKs";
$lang['toplinkcaption'] = "t0P l1Nk C4Ption";
$lang['allowguestaccess'] = "alL0W Gu3S+ ACC3s\$";
$lang['searchenginespidering'] = "s3arch En9InE sP1D3R1Ng";
$lang['allowsearchenginespidering'] = "allow \$34rCh 3N91N3 \$pIDEr1ng";
$lang['newuserregistrations'] = "n3W UsEr rEg1\$Tr4t10ns";
$lang['preventduplicateemailaddresses'] = "pR3v3n+ DUPl1C4+e 3ma1l 4DDRE\$s3s";
$lang['allownewuserregistrations'] = "alLoW NEW Us3R RE9iS+R@+10n\$";
$lang['requireemailconfirmation'] = "r3QUiR3 EM41l c0NFiRm@+10n";
$lang['usetextcaptcha'] = "u5e +3x+-C@p+Cha";
$lang['textcaptchadir'] = "tEXT-C@PtCH4 D1RECTOrY";
$lang['textcaptchakey'] = "t3xt-CaPtch@ k3y";
$lang['textcaptchafonterror'] = "teXt-CAptCH@ h4S 8EEN Dis48LEd 4UTOM@+ic4Lly BEc@uSE ThErE @rE n0 +RUe typ3 F0nts 4Va1L4blE ph0R i+ +0 U\$3. plE4\$e UPLo4D somE +rUE +yp3 Phon+S +o <b>%s</b> on yOuR \$3rvEr.";
$lang['textcaptchadirerror'] = "t3Xt-C@p+ch4 has 8een D15@8LED 8ec4us3 teH tEXt_C@p+ch4 D1r3CtoRY @nD 1+'s 5U8-D1r3C+0r13s 4rE N0T WriT4BL3 By +h3 w3B sErv3R / phP Pr0c3\$s.";
$lang['textcaptchagderror'] = "t3X+-C@p+Ch@ has 8EEn DiS@8leD B3c4use your \$3rvEr's php S3tUP DoEs n0t PROvID3 \$upPor+ f0r GD 1m@GE M4n1PUl@+i0N 4nd / 0r ++f pH0nT sUpp0R+. b0+h 4r3 r3QU1r3D F0R +3X+-C4p+ch@ supp0R+.";
$lang['textcaptchadirblank'] = "t3x+-c4PtcH@ DIREC+0ry 1s BL4nK!";
$lang['newuserpreferences'] = "n3W u53r prePhER3Nc3\$";
$lang['sendemailnotificationonreply'] = "em@Il no+IFiC4+1on on repLy +O Us3r";
$lang['sendemailnotificationonpm'] = "em41l not1PH1C4ti0N 0n Pm t0 UseR";
$lang['showpopuponnewpm'] = "sH0w poPUp when R3c31vinG n3w PM";
$lang['setautomatichighinterestonpost'] = "s3+ 4UTom4TIC h1gH In+Er35+ oN pOsT";
$lang['postingstats'] = "pOSTiNg staTs";
$lang['postingstatsforperiod'] = "pOst1ng 5tATS f0R p3RioD %s To %s";
$lang['nopostdatarecordedforthisperiod'] = "n0 P0st dat4 rECorDED f0R +hIs PEri0d.";
$lang['totalposts'] = "tO+4L po\$+s";
$lang['totalpostsforthisperiod'] = "toTAl pos+s PHOr th1s pER1oD";
$lang['mustchooseastartday'] = "mUST Ch0OsE 4 St@rt D@y";
$lang['mustchooseastartmonth'] = "mu5t Ch0o\$3 a start mon+H";
$lang['mustchooseastartyear'] = "mu\$+ cH0o\$3 a \$t4rt y34r";
$lang['mustchooseaendday'] = "mu\$T CHoo53 4 3nD day";
$lang['mustchooseaendmonth'] = "mU\$+ ChOo53 4 enD m0n+H";
$lang['mustchooseaendyear'] = "mUST CHoO\$E @ EnD y3ar";
$lang['startperiodisaheadofendperiod'] = "s+4rt p3RI0d 15 @he@D Oph END pEr1OD";
$lang['bancontrols'] = "b4N c0N+rols";
$lang['addban'] = "add B@n";
$lang['checkban'] = "checK B4n";
$lang['editban'] = "eD1t 8An";
$lang['bantype'] = "b4N typE";
$lang['bandata'] = "b4N DA+a";
$lang['bancomment'] = "c0MMen+";
$lang['ipban'] = "iP 8an";
$lang['logonban'] = "logON Ban";
$lang['nicknameban'] = "niCKn@mE B4n";
$lang['emailban'] = "eM@il ban";
$lang['refererban'] = "refEr3r 84n";
$lang['invalidbanid'] = "iNv4L1d b@n 1D";
$lang['affectsessionwarnadd'] = "tH1s b4N M@y AFfec+ teh F0Ll0w1NG @Ct1Ve Us3r s3ss1On\$";
$lang['noaffectsessionwarn'] = "tHIs 84N 4Phph3CT5 no 4Ct1ve \$ess10ns";
$lang['mustspecifybantype'] = "j00 must sP3cify a 8@n typ3";
$lang['mustspecifybandata'] = "j00 Must \$pec1fy som3 8An D4t@";
$lang['successfullyremovedselectedbans'] = "sUCC35\$PhUlly REmoved sEl3C+ED b4n5";
$lang['failedtoaddnewban'] = "f4IL3D To 4DD NEw B@N";
$lang['failedtoremovebans'] = "f@il3d +0 r3movE sOmE 0r 4ll oF tH3 \$3l3CTED ban5";
$lang['duplicatebandataentered'] = "dupliCatE 8@n D4t@ 3n+3reD. PlE4\$3 CHeCK Y0UR W1lDC@RDS +0 se3 If TH3Y 4lr34dY m4Tch TEH d4+4 3ntEr3D";
$lang['successfullyaddedban'] = "sucC3s\$fully 4dD3d 8An";
$lang['successfullyupdatedban'] = "sUcce\$SFULly UpD@+3d BAn";
$lang['noexistingbandata'] = "th3re 1\$ No Ex1\$+1ng B4n D4+@. +o 4dd 4 84n CLICK +Eh '4dD N3W' 8U++on BEL0w.";
$lang['youcanusethepercentwildcard'] = "j00 c@N U5E +3H pERC3nt (%) wiLDc4rd \$ymb0l iN 4ny 0ph Y0ur B4n l1\$+S +O OBT4in paRt14l mATCH3S, 1.3. '192.168.0.%' W0ULD B4n 4Ll 1P 4ddr3S\$e\$ IN +3H rAN93 192.168.0.1 ThrOUgh 192.168.0.254";
$lang['cannotusewildcardonown'] = "j00 C@nn0T AdD % 4\$ @ w1ldc4rD M@+Ch 0N 1+'\$ own!";
$lang['requirepostapproval'] = "r3qu1r3 po5+ 4PPRoV4L";
$lang['adminforumtoolsusercounterror'] = "th3re mu5+ 8e 4+ LEas+ 1 Us3r WI+h @dMin tools @ND phOrUm +o0ls @CCe\$\$ 0N 4Ll foRUms!";
$lang['postcount'] = "pO5+ C0Unt";
$lang['resetpostcount'] = "r3s3+ p0\$T coUnt";
$lang['failedtoresetuserpostcount'] = "f@1lED +0 r3sEt Post CoUnT";
$lang['failedtochangeuserpostcount'] = "f4il3D T0 CH@Ng3 U\$3r pO\$+ COUnt";
$lang['postapprovalqueue'] = "p0St 4PProv4L QuEU3";
$lang['nopostsawaitingapproval'] = "no P0\$+5 4r3 aW41+ing @pPr0VaL";
$lang['approveselected'] = "apPR0vE Sel3cTED";
$lang['failedtoapproveuser'] = "f41l3d T0 @ppR0vE USEr %s";
$lang['kickselected'] = "k1ck \$3lEC+3D";
$lang['visitorlog'] = "vi5i+0R lOg";
$lang['clearvisitorlog'] = "cl3@r v1SI+or log";
$lang['novisitorslogged'] = "n0 v1\$1+0rs logG3d";
$lang['addselectedusers'] = "add sEL3c+ED U\$Ers";
$lang['removeselectedusers'] = "rEmOv3 \$ELec+ed Us3rs";
$lang['addnew'] = "add N3W";
$lang['deleteselected'] = "deLETE 53l3C+ED";
$lang['forumrulesmessage'] = "<p><b>fORuM ruLEs</b></p><p>\nRE9Is+r4+10n to %1\$s i\$ pHr3e! We Do 1n\$is+ Tha+ J00 4b1D3 8Y +he rUlES @ND p0l1C13S D3t41l3d 83low. 1f j00 49r3e +0 tEH tErM\$, pl34s3 CH3ck +EH 'I @Gr3e' ch3CK80X 4ND Pr355 Th3 'r39is+er' BU+t0n B3Low. iph j00 w0UlD lik3 to C4nCel +h3 reg1\$tr4t1on, cliCk %2\$S to RetUrn +0 th3 f0RUms INDex.</p><p>\n4LthoU9h +Eh 4Dm1n1\$+R4+0r5 @ND modEr4+0rS of %1\$S w1ll attEmpt T0 K33P @ll obj3Ct1on4Ble m3\$S4g3\$ OFf +H1s f0rum, i+ iS imp0Ss18LE F0r u5 To reV1ew 4ll Mess@gEs. 4lL mes\$49es 3XPress +He v13w5 oph +he @U+H0r, @nd nei+her +h3 0Wner\$ 0F %1\$\$, n0r proj3Ct b33h1ve ForuM 4nD i+'s @PhphiLI4T3S will B3 HELD r3sp0n\$1bl3 f0r +h3 C0n+En+ 0ph @nY m3Ss4GE.</p><p>\n8y 4gr3E1n9 +0 TH3s3 rul3s, j00 w4rr@nt +hat j00 W1ll n0t pO\$+ 4ny mess4g3S th@+ @r3 obsC3n3, VUL94r, SEXU4lLY-ori3n+@ted, h@+efUl, +HREa+eN1n9, or o+Herw1\$E vi0l4t1v3 0f @NY l@wS.</p><p>tH3 0wn3rS 0F %1\$S r3sERV3 +he rIght T0 r3moV3, ed1+, mov3 or cLO\$E 4ny +hR34d f0R any REas0n.</p>";
$lang['cancellinktext'] = "h3R3";
$lang['failedtoupdateforumsettings'] = "f4il3D +o upD4+3 phoRuM 5eTt1nG\$. PLE4SE try a9@iN l4+Er.";
$lang['moreadminoptions'] = "m0RE 4DM1n 0PtionS";

// Admin Log data (admin_viewlog.php) --------------------------------------------

$lang['changedstatusforuser'] = "cH4NG3D us3R stAtU5 f0R '%s'";
$lang['changedpasswordforuser'] = "cH4n93D P@\$SW0RD PhOr '%s'";
$lang['changedforumaccess'] = "cH4n93D F0RUm @CC3ss PERMis5ion5 f0r '%s'";
$lang['deletedallusersposts'] = "d3le+ED All p05+\$ For '%s'";

$lang['createdusergroup'] = "crE4+ed UsER 9R0up '%s'";
$lang['deletedusergroup'] = "dEl3tED U\$3r Group '%s'";
$lang['updatedusergroup'] = "upd@+ED usEr 9r0up '%s'";
$lang['addedusertogroup'] = "add3d u\$3r '%s' t0 9r0up '%s'";
$lang['removeduserfromgroup'] = "remov3 US3r '%s' fr0m 9RouP '%s'";

$lang['addedipaddresstobanlist'] = "aDDeD IP '%s' T0 ban liS+";
$lang['removedipaddressfrombanlist'] = "r3m0veD 1p '%s' PHROM 84n l1\$t";

$lang['addedlogontobanlist'] = "adDED Logon '%s' to b4N LI\$+";
$lang['removedlogonfrombanlist'] = "rEm0Ved lOG0N '%s' fR0M B@N L15+";

$lang['addednicknametobanlist'] = "aDDED n1CknAm3 '%s' +0 B4N L1ST";
$lang['removednicknamefrombanlist'] = "r3Mov3D nICKN@M3 '%s' fR0m B4n l1sT";

$lang['addedemailtobanlist'] = "adD3d em4Il 4DDREss '%s' to B4N L1ST";
$lang['removedemailfrombanlist'] = "r3mOV3d 3m@il 4DDREss '%s' Fr0m BAn l1ST";

$lang['addedreferertobanlist'] = "add3d refER3R '%s' t0 8aN LIsT";
$lang['removedrefererfrombanlist'] = "r3Mov3D r3phEREr '%s' FRom B4N l15t";

$lang['editedfolder'] = "eD1+eD folDEr '%s'";
$lang['movedallthreadsfromto'] = "m0v3D 4ll +HR34D\$ fR0M '%s' T0 '%s'";
$lang['creatednewfolder'] = "cr3atED N3w F0lD3R '%s'";
$lang['deletedfolder'] = "d3le+ED pH0lDER '%s'";

$lang['changedprofilesectiontitle'] = "cH4n93d pRopHil3 \$eC+10n ti+L3 pHr0M '%s' to '%s'";
$lang['addednewprofilesection'] = "add3D n3w propHil3 \$eCT10N '%s'";
$lang['deletedprofilesection'] = "d3l3+Ed Pr0fILE seCT10n '%s'";

$lang['addednewprofileitem'] = "aDdED n3W pR0F1le 1+Em '%s' +o \$EcT10n '%s'";
$lang['changedprofileitem'] = "ch4n93d pRoPHIlE 1+3m '%s'";
$lang['deletedprofileitem'] = "dEletED pr0phiLE I+EM '%s'";

$lang['editedstartpage'] = "eDi+eD \$+4rt P49E";
$lang['savednewstyle'] = "s4V3D nEw \$TYL3 '%s'";

$lang['movedthread'] = "mOVEd thrE4D '%s' fr0M '%s' +o '%s'";
$lang['closedthread'] = "clOsED +Hr34d '%s'";
$lang['openedthread'] = "opEN3D +hre4d '%s'";
$lang['renamedthread'] = "r3N4m3D tHr3aD '%s' +o '%s'";

$lang['deletedthread'] = "deL3t3D thrE4d '%s'";
$lang['undeletedthread'] = "undEle+3d +Hr34d '%s'";

$lang['lockedthreadtitlefolder'] = "loCK3D tHrEad oP+IOn\$ 0n '%s'";
$lang['unlockedthreadtitlefolder'] = "unl0CK3D +hR34d Op+1on\$ 0N '%s'";

$lang['deletedpostsfrominthread'] = "dEl3+3D p0sTs FROM '%s' 1n +hr3@d '%s'";
$lang['deletedattachmentfrompost'] = "dELet3D @tt4ChMent '%s' phrom poST '%s'";

$lang['editedforumlinks'] = "edITED pHorum L1Nks";
$lang['editedforumlink'] = "eD1ted f0RUM L1NK: '%s'";

$lang['addedforumlink'] = "added phoRum Link: '%s'";
$lang['deletedforumlink'] = "dEleteD F0RuM LiNk: '%s'";
$lang['changedtoplinkcaption'] = "cH4NGED +0P lInk c4pT1on fr0M '%s' +o '%s'";

$lang['deletedpost'] = "dEleTeD p0S+ '%s'";
$lang['editedpost'] = "eDi+3d Po5+ '%s'";

$lang['madethreadsticky'] = "mADe +hR3@d '%s' 5TICKY";
$lang['madethreadnonsticky'] = "m@D3 +hr3Ad '%s' non-5+1CKy";

$lang['endedsessionforuser'] = "eND3d ses\$1on Phor u\$er '%s'";

$lang['approvedpost'] = "apPRov3d pO\$+ '%s'";

$lang['editedwordfilter'] = "ed1tEd woRD FIl+3R";

$lang['addedrssfeed'] = "aDded r5\$ fe3D '%s'";
$lang['editedrssfeed'] = "eD1t3D Rss fe3D '%s'";
$lang['deletedrssfeed'] = "dEL3T3D rs\$ PHeED '%s'";

$lang['updatedban'] = "upD4TED B4n '%s'. cH4nGED +yP3 Fr0M '%s' T0 '%s', ch@Ng3d DAt@ fr0M '%s' to '%s'.";

$lang['splitthreadatpostintonewthread'] = "sPlit +HRE@D '%s' 4T P0st %s  1n+0 NEW +hRE4d '%s'";
$lang['mergedthreadintonewthread'] = "mEr9ED +hr34Ds '%s' 4nD '%s' 1N+0 new +HrEAD '%s'";

$lang['approveduser'] = "apPR0V3d USEr '%s'";

$lang['forumautoupdatestats'] = "fORum @Uto UpD@t3: \$+4t\$ UPD@+3D";
$lang['forumautoprunepm'] = "fORUM 4u+0 UpD4+E: Pm FolD3r\$ PruN3D";
$lang['forumautoprunesessions'] = "fORUm @u+0 upD4+3: \$3ss10Ns PrUned";
$lang['forumautocleanthreadunread'] = "f0RUm 4u+0 UpD4te: +hrE4d UnR34D D4t4 CL34N3d";
$lang['forumautocleancaptcha'] = "f0RUm @Ut0 UpD4+3: tExt-C@PtCH4 1m49Es CL34n3d";

$lang['adminlogempty'] = "adM1n lo9 i5 3MptY";

$lang['youmustspecifyanactiontypetoremove'] = "j00 muSt spEc1phy 4N aC+I0n tYp3 T0 r3mOVE";

$lang['removeentriesrelatingtoaction'] = "r3m0ve 3nTri35 rel@+IN9 t0 aC+Ion";
$lang['removeentriesolderthandays'] = "r3MoVE Entr1es OLD3r TH4n (d4Ys)";

$lang['successfullyprunedadminlog'] = "succE\$sfully pRUn3D 4DM1N L09";
$lang['failedtopruneadminlog'] = "fa1l3D +O pRUnE @DM1N lOg";

$lang['prune_log'] = "prun3 loG";

// Admin Forms (admin_forums.php) ------------------------------------------------

$lang['noexistingforums'] = "nO EX1\$T1n9 f0RUms pHounD. +0 Cr3@tE @ n3w PHOrUM CLiCK the '@dD N3W' 8Utt0n beL0w.";
$lang['webtaginvalidchars'] = "wEB+@g CAN 0NlY C0N+41n Upp3Rc4s3 4-Z, 0-9 @Nd uND3rsCOre Ch@r@cTEr\$";
$lang['databasenameinvalidchars'] = "d4+4b4s3 N4M3 Can 0NlY C0nt41N A-Z, @-z, 0-9 anD UnD3rsCore ChAr4C+Ers";
$lang['invalidforumidorforumnotfound'] = "inv4liD f0rum F1D oR F0RuM nOt Ph0UND";
$lang['successfullyupdatedforum'] = "sUCCE\$\$PHUlly uPD@+ED forUm";
$lang['failedtoupdateforum'] = "f41leD To UpD4+3 F0RUm: '%s'";
$lang['successfullycreatednewforum'] = "sUcCE\$sfUllY CR34+3d NEw ph0rum";
$lang['selectedwebtagisalreadyinuse'] = "th3 \$elECTED W3BT49 15 alr34DY in UsE. pl34\$E Ch0Os3 4no+her.";
$lang['selecteddatabasecontainsconflictingtables'] = "tH3 selECTED D4+4B45e C0nt41N\$ c0nPhL1CT1ng +@8le\$. c0nphL1cT1ng t48LE n4MES 4r3:";
$lang['forumdeleteconfirmation'] = "ar3 j00 SUr3 J00 w4n+ To DEl3te 4LL of +3H s3l3C+eD PhoRUM\$?";
$lang['forumdeletewarning'] = "ple@5e n0te +h4+ J00 C4Nn0+ r3Cov3r DEL3+3D FoRUm\$. 0nCE DELe+3d 4 ForUm @nD all of I+'s 45S0C1@+3D D@T4 I5 PErManEN+ly reM0VED From tEH D4t48As3. ipH J00 D0 n0t w1\$H +0 d3LEtE TEh sel3c+3D F0Rums pLE4\$3 CL1CK C4nC3l.";
$lang['successfullyremovedselectedforums'] = "sUcce\$SFULly D3L3tEd \$elEC+ED pH0RUm\$";
$lang['failedtodeleteforum'] = "f4Il3d +0 D3lEted f0rum: '%s'";
$lang['addforum'] = "aDd F0rum";
$lang['editforum'] = "edit f0rum";
$lang['visitforum'] = "vi\$1+ f0RUM: %s";
$lang['accesslevel'] = "aCc3sS l3v3L";
$lang['forumleader'] = "forum L34D3R";
$lang['usedatabase'] = "u5e d4+4B4se";
$lang['unknownmessagecount'] = "unKN0WN";
$lang['forumwebtag'] = "forum W38t@g";
$lang['defaultforum'] = "def4uLt F0RUm";
$lang['forumdatabasewarning'] = "pL34sE 3NsuRE j00 sEl3C+ tEH CorREC+ d@+48ase wh3N CRE4+Ing @ NEW F0RUm. 0NC3 CrE4T3D @ nEW Forum C@Nn0+ bE mOV3d 8E+WEEn 4V41L48le D@+@84\$es.";

// Admin Global User Permissions

$lang['globaluserpermissions'] = "gL084l u\$er perm1\$SI0ns";

// Admin Forum Settings (admin_forum_settings.php) -------------------------------

$lang['mustsupplyforumwebtag'] = "j00 mu5t SUpply 4 foRum w3bt49";
$lang['mustsupplyforumname'] = "j00 Must \$upplY 4 phORUm N4m3";
$lang['mustsupplyforumemail'] = "j00 mU5+ \$uppLy 4 PHorum Em@il @dDRE\$S";
$lang['mustchoosedefaultstyle'] = "j00 mUsT ChoO53 4 dEf4UL+ pHorUm \$+YLE";
$lang['mustchoosedefaultemoticons'] = "j00 MUst choo\$3 DEpH@ult ForUM 3m0tiC0N\$";
$lang['mustsupplyforumaccesslevel'] = "j00 mU5+ supply @ forum 4cC3S5 l3vEl";
$lang['mustsupplyforumdatabasename'] = "j00 mus+ \$UpPlY 4 phorum d@t4BAsE n4ME";
$lang['unknownemoticonsname'] = "unkN0wn em0+1CoN\$ n@m3";
$lang['mustchoosedefaultlang'] = "j00 mU\$T CH00\$3 4 DEph4ult F0ruM l4N9u493";
$lang['activesessiongreaterthansession'] = "aC+1vE ses510N +1m3ouT C4NNO+ 83 gRE4TEr tH@N ses5I0n t1m30U+";
$lang['attachmentdirnotwritable'] = "a+T4cHMEN+ d1r3C+Ory @nD Sy5+eM tEMP0R@ry Dir3C+0Ry / PhP.1n1 'upl0@D_Tmp_DiR' mUst 83 wr1T4Ble 8Y +hE WEB SErV3R / php Pr0c35\$!";
$lang['attachmentdirblank'] = "j00 mUs+ 5Upply 4 dIR3C+OrY +0 s4v3 4++4ChMEnts iN";
$lang['mainsettings'] = "mA1n S3Tt1NG5";
$lang['forumname'] = "foRUm N4mE";
$lang['forumemail'] = "f0RUm 3M@Il";
$lang['forumnoreplyemail'] = "nO-r3ply 3M@1l";
$lang['forumdesc'] = "foruM DE5cr1Ption";
$lang['forumkeywords'] = "fOrum K3yw0RDs";
$lang['defaultstyle'] = "dePH4Ul+ sTyLE";
$lang['defaultemoticons'] = "d3PH4Ult EM0+iCOn\$";
$lang['defaultlanguage'] = "dEf4uLT l@Ngu49e";
$lang['forumaccesssettings'] = "f0rUM 4ccEss s3++iNg\$";
$lang['forumaccessstatus'] = "f0rum 4CC3\$\$ \$+4tus";
$lang['changepermissions'] = "ch@n93 p3rm1\$SI0ns";
$lang['changepassword'] = "chAn9e p@\$sw0rD";
$lang['passwordprotected'] = "p@ssWORd protEC+ED";
$lang['passwordprotectwarning'] = "j00 HaVe n0+ s3t 4 ForUM p@5\$w0rD. 1f j00 D0 n0+ s3+ @ Passw0RD TeH P4Ssw0RD proTEC+I0N fuNCT10n@l1tY W1Ll 83 4u+0M@t1c@LLY Di\$4bLED!";
$lang['postoptions'] = "pO\$t 0Pt10n5";
$lang['allowpostoptions'] = "aLl0w p0st ED1+1Ng";
$lang['postedittimeout'] = "poST ED1T +Im30U+";
$lang['posteditgraceperiod'] = "poS+ 3dI+ 9R4c3 p3r10d";
$lang['wikiintegration'] = "wIk1W1K1 1NT39R@+IOn";
$lang['enablewikiintegration'] = "eN@8lE wiKiWIk1 1nTE9r4+I0n";
$lang['enablewikiquicklinks'] = "eN4ble wiKiwIki qU1CK LiNKS";
$lang['wikiintegrationuri'] = "wik1w1KI loC4+iOn";
$lang['maximumpostlength'] = "m4x1mUM p0\$t l3NG+H";
$lang['postfrequency'] = "poST FR3Qu3ncy";
$lang['enablelinkssection'] = "en@8le liNK\$ \$eCT10n";
$lang['allowcreationofpolls'] = "aLl0w Cr3At10N oph poLl\$";
$lang['allowguestvotesinpolls'] = "aLL0w 9u3ST5 t0 v0+3 1n p0Ll\$";
$lang['unreadmessagescutoff'] = "uNre4d MEssA93S cU+-0fPh";
$lang['unreadcutoffseconds'] = "s3conds";
$lang['disableunreadmessages'] = "d15@8LE Unre4D Mess49es";
$lang['nocutoffdefault'] = "nO Cu+-0fPh (D3f4uL+)";
$lang['1month'] = "1 m0n+H";
$lang['6months'] = "6 mon+hs";
$lang['1year'] = "1 Y3@r";
$lang['customsetbelow'] = "cu\$+0m V@lu3 (set 8EL0w)";
$lang['searchoptions'] = "s3@rch 0pt10ns";
$lang['searchfrequency'] = "sE4rch phr3QuENCY";
$lang['sessions'] = "seS\$10nS";
$lang['sessioncutoffseconds'] = "sE\$si0n CuT oPhF (53Cond5)";
$lang['activesessioncutoffseconds'] = "ac+1v3 \$e\$\$10N Cu+ 0FF (\$3cOnD\$)";
$lang['stats'] = "sT4+\$";
$lang['hide_stats'] = "hIde sta+s";
$lang['show_stats'] = "shOW \$t4tS";
$lang['enablestatsdisplay'] = "eN@8l3 \$TAt5 D1Spl4Y";
$lang['personalmessages'] = "p3Rs0nal M3ss49ES";
$lang['enablepersonalmessages'] = "en@8l3 pErs0n4L mess493s";
$lang['pmusermessages'] = "pm m3ss493S p3r user";
$lang['allowpmstohaveattachments'] = "all0W p3Rs0nal m3S\$49E5 +0 Hav3 AT+4CHmENt\$";
$lang['autopruneuserspmfoldersevery'] = "aUto prun3 U\$3r's pm folD3RS 3very";
$lang['userandguestoptions'] = "user 4nD 9u3\$T oPti0nS";
$lang['enableguestaccount'] = "eNAble gu3s+ 4ccOUnt";
$lang['listguestsinvisitorlog'] = "li5+ gueSt5 1n vI5Itor l0g";
$lang['allowguestaccess'] = "aLlow 9U3sT 4cCE5s";
$lang['userandguestaccesssettings'] = "uS3r 4Nd 9u3S+ @cC3sS S3TT1Ngs";
$lang['allowuserstochangeusername'] = "alLOw us3R5 t0 Ch@ngE Us3RnaME";
$lang['requireuserapproval'] = "rEqU1re us3R @pPRoV@l BY @DmIn";
$lang['requireforumrulesagreement'] = "r3QU1re usEr to a9RE3 +0 forum rUl3S";
$lang['enableattachments'] = "en@8le 4+T4chmeNts";
$lang['attachmentdir'] = "a++4CHMEnT diR";
$lang['userattachmentspace'] = "att4ChM3NT sp@CE p3R UsEr";
$lang['allowembeddingofattachments'] = "all0w 3m83dDIng oph 4+t4chMEN+S";
$lang['usealtattachmentmethod'] = "uS3 4lt3RN4+iv3 at+@chm3nt methoD";
$lang['allowgueststoaccessattachments'] = "alLOw guEs+\$ +O @CC3SS 4T+4chmen+s";
$lang['forumsettingsupdated'] = "foRUM s3ttIngs sUcC3S\$FULly UpD@+ED";
$lang['forumstatusmessages'] = "forum 5T4+us ME\$s@ge\$";
$lang['forumclosedmessage'] = "f0RUm Cl0SED M3SS493";
$lang['forumrestrictedmessage'] = "fORum r3Str1cteD m3SS493";
$lang['forumpasswordprotectedmessage'] = "f0RUm p4s\$WOrD proteC+3d m3sS49E";

// Admin Forum Settings Help Text (admin_forum_settings.php) ------------------------------

$lang['forum_settings_help_10'] = "<b>p0st ED1+ +1m30u+</b> i\$ +3h t1ME 1N mInUT3S AphT3R P0\$+iNg +h4+ @ usER C@n 3D1t +H31r p05+. 1Ph 53+ tO 0 +hER3 Is n0 liM1+.";
$lang['forum_settings_help_11'] = "<b>m4ximum p0ST l3N9+h</b> 1S +H3 M4ximuM nUMB3r of Ch@r4CTERs +h@t wIlL B3 displ4YEd 1N a po\$+. if @ P05+ i\$ loN93r tH4n +he NumBER opH CH@r@CTEr\$ d3Fin3d H3R3 1+ wIlL 8E CU+ 5hor+ And @ l1nk 4DD3D +o +h3 8Ot+om +O @ll0w Us3rS +0 R34D th3 whole Po\$+ on 4 SEP@R4+e P49e.";
$lang['forum_settings_help_12'] = "iF j00 D0n't w4nt y0UR u\$er\$ +o BE 48lE T0 CR3@TE PolL\$ j00 CAn dIs@ble +H3 A8OV3 0pt1on.";
$lang['forum_settings_help_13'] = "tH3 L1nks \$3C+i0N oph bEEHIvE pr0V1D3S 4 pl4CE F0r YOur u53r\$ +0 M4IN+41N 4 lI5+ 0PH s1+e\$ +H3Y fr3QuEn+Ly v1\$it +h4+ o+h3r us3Rs m4y Ph1ND U53PhUl. lINK5 c4n Be DIviD3D in+o C4+390r13S 8y F0lD3r @ND @lL0W phor c0MM3n+\$ 4nD r@+ing5 +0 8E 9iv3n. 1N ordER +0 mod3R4+3 Th3 liNks sec+I0N 4 useR MU\$+ b3 rANted GL0bAL m0Der4+0R \$tatus.";
$lang['forum_settings_help_15'] = "<b>sES\$ION cUt 0Phf</b> 1s +eh m@XImum +1mE 8ef0RE 4 us3R'\$ \$e5SI0n is d3EMEd DE4d AND +h3y 4re Log9ED 0uT. 8y Deph4ul+ +h1s i\$ 24 hoURs (86400 secoNds).";
$lang['forum_settings_help_16'] = "<b>aCT1VE sEss1on CU+ ophPh</b> 1\$ +hE m4xiMum t1me 8EpHorE 4 useR's s3\$Si0n 1\$ d3eMED in@ct1vE @t whiCH p01Nt tHey 3N+er an Idl3 sT4+e. 1n +H1S \$t4+3 +Eh User rEm41ns lo9geD in, bu+ +hEy @r3 r3Mov3d fr0m tEH 4ct1ve useR\$ L1ST in +EH St4+s d15pl4Y. oNCe tHey 8Ecome @ctIve @g4in +Hey wilL bE R3-4DD3D +0 TEh li5+. By D3PH@Ult thIs SE++1ng 1\$ se+ to 15 m1NU+E5 (900 \$econds).";
$lang['forum_settings_help_17'] = "en@8lINg +His OpT10n 4Ll0WS 8E3hIV3 t0 1nCluD3 a sT4+5 DI\$PL4y @+ +3h 8O++0M of +H3 meSS@GE\$ p@n3 S1m1Lar +0 +He oNe UseD BY m@Ny phoruM 5OpH+W4re +1tLes. onCe 3n4bLEd Teh DI\$PL4Y oPH the S+4t\$ p4g3 c@N be +09gl3d INdiVIdu4Lly By 34CH Us3R. 1PH +HEy DON'T w4NT TO 53E 1+ +hey C4N hid3 1+ PHr0M Vi3W.";
$lang['forum_settings_help_18'] = "peR50N@l M3s5@ge5 4rE INV4Lu4bLE @\$ 4 waY oF +4k1nG m0r3 Pr1V4TE m4T+3rs ou+ 0Ph v13w of +h3 0Ther m3mB3r\$. h0W3ver IF j00 DON'+ w4NT Y0ur USERs tO BE A8le +0 sEND 34CH O+h3R peR50N4l m3Ss493s j00 C@N D1\$4BlE +hi\$ option.";
$lang['forum_settings_help_19'] = "pERson4L mess493s C@N 4l\$0 Con+41n @t+4ChMEnts whiCh C4n 83 usEpHUl ph0r 3xCH@nGIng pHIL3s B3+we3n u\$3r\$.";
$lang['forum_settings_help_20'] = "<b>nOtE:</b> TEh sp@C3 4ll0c4+I0n fOr Pm 4++@CHmEN+s 1\$ t@k3n FRom E4ch U\$3R\$' m@iN @++4ChM3Nt @lL0c@ti0N 4nd 1\$ NOt In @DD1+1oN To.";
$lang['forum_settings_help_21'] = "<b>eN@8L3 GUE5+ 4Cc0uNt</b> @lL0W\$ VI\$it0rs +0 BROwsE yOUr fOrum 4ND R34D p0S+\$ W1th0U+ RE91\$tErInG @ usEr aCCOun+. @ u\$er AcCOUN+ iS 5+1ll REquIr3d If +h3y W1sh +0 P0st 0R CHaN93 U\$er pr3FER3NC3S.";
$lang['forum_settings_help_22'] = "<b>l1s+ 9u3sts iN vi5IT0r l0G</b> @ll0w\$ j00 +0 SpEC1fy whE+HEr or nOt UnrEg1\$TEr3d usEr\$ 4rE lIs+ed on th3 v15I+0r l0G @lon9 siDe re915+3reD U53r\$.";
$lang['forum_settings_help_23'] = "b3Eh1V3 @ll0W\$ @T+@chmen+s +O 8E UPL0adED +0 m3ss493S whEn Po5+eD. iPh j00 h@ve l1M1t3d W3B \$p4C3 j00 m@y wH1Ch To D1s@8lE 4T+@CHm3ntS BY CLE4r1Ng tHE BOx @80V3.";
$lang['forum_settings_help_24'] = "<b>a+T4chm3NT DiR</b> 1s t3H lOCA+10n BEEH1ve 5h0uLD stoRE i+'\$ 4tt@ChMen+s In. +Hi\$ DIREC+0ry muSt 3XI\$+ 0N y0UR WEb sPaC3 @nD musT B3 wri+@8le bY +Eh W38 s3Rv3r / phP ProC3ss O+hErW1se UpLo@Ds w1LL f41l.";
$lang['forum_settings_help_25'] = "<b>aTT4chm3nT sp@CE p3R U53r</b> i\$ +3H max1MUm @M0UNt 0PH d1sK sp4c3 4 user H4\$ f0R 4T+@CHm3Nts. onc3 +h1\$ \$p@c3 is us3D up tEh u\$3r C4Nn0t UPl0AD @ny mOre @++4Chm3nts. 8y D3PH4Ul+ This is 1m8 0PH sp@C3.";
$lang['forum_settings_help_26'] = "<b>alL0w Em83DDIn9 0f 4Tt4ChM3N+\$ 1n m3Ss4g35 / s1GN4+ur3\$</b> 4llOw5 U\$3rs +0 EM8ed @++4chm3N+s 1n p0Sts. 3n4BlIng +hi\$ 0pt10n whilE UsEFul C4n iNCr34\$E y0ur B4NDWidTh U\$@GE DR4st1c4Lly uND3r C3rt4in C0nf19URat10n\$ 0f pHp. If j00 h4V3 lIMI+ed B4ndwID+h I+ i5 reCommeND3d TH4+ j00 dIS4ble thi\$ 0Pti0N.";
$lang['forum_settings_help_27'] = "<b>u\$E @L+3rn4+iV3 4T+@Chmen+ m3tH0d</b> Ph0rc3s b33hive +0 U\$3 4n aL+ERn4+1v3 r3tr13v4L me+H0D F0r 4t+@cHmENTs. 1f j00 r3c31v3 404 3Rror mE\$S@gE\$ WH3n TRy1n9 to D0WNlo@D 4++4cHm3n+\$ PHrom mEs\$49es +ry 3N@bL1NG +Hi\$ 0PT10n.";
$lang['forum_settings_help_28'] = "thIS sE++1n9 @LloWs Y0Ur Ph0Rum To BE \$piD3R3D 8y SE4rch 3NGin3S L1ke g00gl3, Alt@viST4 and y@H0O. 1ph J00 \$wi+ch tHi\$ Opt10N ophph y0ur f0rUM Will N0T BE inCludeD In Th3SE searCH EnG1n3S r3SULT5.";
$lang['forum_settings_help_29'] = "<b>all0w n3w u\$3r rE915+r4T10n\$</b> 4LLows 0R d1s4Ll0ws +3h cREa+10n 0ph NeW U\$Er ACc0UnT5. s3tt1nG +H3 0Pt10N t0 NO C0mplE+ElY d1s4BLe\$ +hE r3g1\$+R4T10N phoRm.";
$lang['forum_settings_help_30'] = "<b>en48le w1KiwIkI INTEgr@+1on</b> Pr0VID3s w1K1WorD \$UPp0rt 1N YouR pHoRUm Po5+S. a WiKiW0RD I\$ M@D3 uP Of +W0 Or m0RE COnC4+3n4teD wOrd\$ w1+h uPp3rc@5e lettEr\$ (oph+3N r3Pherr3D +0 4\$ c4m3lCAse). If j00 wr1+3 4 W0rD th1\$ w4y 1T WIll 4utom@t1c4Lly 83 CHan9ED inTo a Hyp3Rl1nk pointiNg t0 your cH0Sen w1kiwik1.";
$lang['forum_settings_help_31'] = "<b>en@BLE wikiwIKi qUiCK linKs</b> EN@BL3\$ TH3 u53 of msg:1.1 4nD UsEr:l090n 5+YlE 3X+3Nd3d wIKILinK\$ wHiCh CR34+3 HYp3rl1Nks to +hE sp3C1F13d M3s5@ge / u\$3r pR0philE 0f the \$P3cIphi3d uSER.";
$lang['forum_settings_help_32'] = "<b>wik1wiki l0c4Tion</b> IS us3D +o spECIFy The Ur1 oF yOuR w1KiWiKi. wHEN 3N+ERIn9 +3h uR1 U\$e [w1KIwoRD] +o 1NDIC4te wh3RE in tHE Ur1 Th3 wikIW0rd \$H0ULD 4pPE4r, I.E.: <i>h++p://3N.w1K1p3D14.0Rg/WikI/[w1kiWord]</i> WoUld Link yoUr wiKiwOrDS +0 %s";
$lang['forum_settings_help_33'] = "<b>f0RUm 4Cc3ss \$+4tuS</b> c0n+roLs h0w U\$eR5 m4Y 4Cc3ss yoUr pHorUm.";
$lang['forum_settings_help_34'] = "<b>open</b> wilL 4Ll0W @lL U53rs 4ND gU3STs @Cc3ss +0 yoUR phorUM WI+Hou+ rE5+r1c+I0n.";
$lang['forum_settings_help_35'] = "<b>cL0\$ED</b> Pr3veNt5 accE\$S F0r 4LL us3rs, w1+h +hE ExCEPtion Oph tH3 @dm1N who MaY 5+ilL @CC3ss +HE @DMin pAnEl.";
$lang['forum_settings_help_36'] = "<b>r35tric+3D</b> 4LL0w\$ t0 Set 4 liS+ 0Ph U\$3r\$ Wh0 4RE 4lloWED 4cC355 tO Y0Ur PhOrUm.";
$lang['forum_settings_help_37'] = "<b>p4\$\$WorD pR0+3cTED</b> AlLOw5 j00 to sE+ 4 p@5sw0rD +0 g1V3 0U+ +o US3R\$ \$0 TheY C4n 4cC3ss youR pHOrum.";
$lang['forum_settings_help_38'] = "wHEn sETt1N9 r3sTriCteD or p45\$w0rD pr0+3C+Ed moDE J00 w1ll nE3d +0 s4Ve yoUr Ch4Nge5 8ef0rE J00 c@n CH4nGE tH3 U53r @CC3Ss Priv1legEs or p@5sw0RD.";
$lang['forum_settings_help_39'] = "<b>Search Frequency</b> defines how long a user must wait before performing another search. Searches place a high demand on the database so it is recommended that you set this to at least 30 seconds to prevent \"search spamming\"fR0M kilLinG +H3 seRV3r.";
$lang['forum_settings_help_40'] = "<b>pOst fr3QuEncy</b> 1\$ +hE mInimUM +1m3 4 us3R Must W@i+ 8ef0re +hEY C@N Post 49@in. +h1s \$3tT1nG aL\$0 4PhPh3cT\$ THE crE4+i0n 0F pollS. SE+ +o 0 To Dis4BLE tH3 rEsTrICTIon.";
$lang['forum_settings_help_41'] = "the @8ov3 0p+10nS CH4n9e +h3 DEF4UL+ v@lU3S f0r +hE U53R reG1\$+r@+i0n phoRM. WH3r3 4PplIC4BlE oTH3R sEtT1NGs w1ll U\$3 +hE PH0RUM'5 owN DEph4UL+ \$eT+1ng\$.";
$lang['forum_settings_help_42'] = "<b>prev3Nt usE oF duPlICA+3 ema1l 4ddrE\$SE\$</b> phOrC3S BEEh1vE +O Ch3CK t3h u\$3R 4CCOUnts 494in5+ +h3 Em4Il 4ddrEss +H3 U\$er 1\$ rE9is+Er1n9 Wi+h @ND prOMp+\$ +H3M +0 uS3 4nOTH3r IPH 1t IS alr3ADY 1n UsE.";
$lang['forum_settings_help_43'] = "<b>rEQUiR3 em4il CONpH1Rm@+I0N</b> Wh3n 3N4bl3d w1ll \$3nd AN Em41l +0 e4CH nEW User w1+h @ L1NK Th4+ C4n bE UsED +O c0nfiRm +H31R 3m41l 4ddrEs\$. un+1l th3Y COnphirm the1R 3m4IL 4DDR3S5 +h3y wIll n0T 8e 4BL3 +0 pOs+ uNLEs5 +h31r Us3r PErmi\$SI0n5 ar3 Ch@ng3D manU4lly by an 4dm1n.";
$lang['forum_settings_help_44'] = "<b>u\$3 +Ext-c4ptCh@</b> Pr3sEnts Th3 n3w u\$3r wi+h @ maNgl3d IM@g3 WH1ch +HEy mU\$+ COpY a nUMB3r PHR0M InTO A +3xt f1eld On ThE r3g1\$+R@+i0n FOrm. U\$3 th1s opT10n +0 pr3ven+ @U+0m4+3d \$IGN-Up v14 sCR1Pts.";
$lang['forum_settings_help_45'] = "<b>t3X+-C4ptCh4 d1r3CToRy</b> spECIPhIE5 tHE loC4+ion tH@+ 83EhiVE w1LL S+0re I+'\$ t3xt-C4p+Cha iM493s 4ND pH0NTS in. +HI\$ DIREc+Ory mU\$+ BE WrITa8le By +H3 weB s3rv3R / pHP Pr0c3SS 4ND MU\$T 8e @ccE\$s1BL3 V1@ Ht+p. 4FtER j00 haVE 3na8l3D tExT-C@pTCH4 j00 must upl0@D s0M3 tRU3 +yP3 font\$ in+0 th3 f0N+\$ Sub-diR3c+0RY 0ph Y0ur m41N +3xt-C4Ptch4 D1rec+0Ry 0+HErw1\$3 83EH1V3 w1ll \$K1P thE Tex+-Captch@ dUr1ng UsEr reg1s+r4+10n.";
$lang['forum_settings_help_46'] = "<b>Text Captcha key</b> allows you to change the key used by Beehive for generating the text captcha code that appears in the image. The more unique you make the key the harder it will be for automated processes to \"guess\"tEh cod3.";
$lang['forum_settings_help_47'] = "<b>p0S+ ED1t 9R@CE P3Ri0D</b> @Ll0Ws j00 +0 DeFiNe @ pER10D iN MiNUt3s WHErE UsEr5 m4Y 3d1+ P0s+S Wi+h0U+ teh '3dItED BY' t3XT 4pP3@R1NG on +h31R p0stS. 1ph \$e+ +O 0 the '3d1ted by' +3X+ w1ll 4Lw@ys ApP3@r.";
$lang['forum_settings_help_48'] = "<b>uNRE4d mESs49es CUT-0ff</b> \$p3C1f13S h0w L0N9 unrE4d m3ss49e\$ @r3 rEt4in3D. j00 m@y Ch005e PHR0m VARI0u5 Pre\$e+ v@lu3s 0r 3NteR yOuR 0wn cuT-oPhF P3Ri0d 1N \$3CoNDs. +hR3@D5 moD1fiEd EArl1er Th4n tEh D3Ph1neD cut-0pHF PER10d wIlL 4U+om@+iC4lly app34r 45 reAD.";
$lang['forum_settings_help_49'] = "choosiNg <b>d1s4BlE UnrE4d m35s493s</b> WiLl c0mpl3tElY r3MOvE unR3@D mE\$s@ge\$ \$uPPoRt @ND R3MoVE The R3LEv4nt 0P+1ons PHrOm +H3 Di5cU\$si0N +Yp3 dr0P DoWn on +hE +HrE4d lis+.";
$lang['forum_settings_help_50'] = "<b>r3QuiR3 u\$ER 4PPrOv4L 8y 4dM1N</b> Allow\$ j00 TO reSTrICT 4cC3\$5 8Y n3w uS3rs UN+il tHeY h4V3 8eEn @ppr0vEd BY 4 mOD3R4+0R 0R 4dM1N. Wi+h0u+ 4Ppr0V4l 4 usEr C4nn0t 4CCE\$5 @Ny 4re4 0f +h3 833h1V3 pHoruM 1nS+4lL@ti0n 1NclUd1N9 ind1viDu@L phorUm\$, pm InB0X And MY Ph0rUms 53c+1Ons.";
$lang['forum_settings_help_51'] = "u5E <b>clOSeD m3SS4ge</b>, <b>r3\$Trict3d M3ss@g3</b> @ND <b>p4\$\$w0Rd pROteCt3D m3s\$4gE</b> +O cu5+0M1Se +HE MEsS@9e dISplAy3d wH3n Us3Rs AcC3\$s yOuR f0rum 1N +h3 v@r1oUS \$+@T3s.";
$lang['forum_settings_help_52'] = "j00 C4n US3 hTml 1N YOuR m3SS@gE\$. hYpERL1NKS @nD 3m4Il 4DDRES\$eS W1LL 4ls0 B3 4ut0m4T1C4lLy C0Nv3R+3d tO L1nks. tO usE +3h dEph4ul+ BeEhIv3 f0rUM me\$S@g3S Cl34R +eH FiELDS.";
$lang['forum_settings_help_53'] = "<b>alL0w UsEr\$ +0 CH@nG3 u\$ERN4m3</b> pErM1+s alR34dY r3G1\$TER3d UseRs +0 ch@nG3 tHE1R U53rn4M3. WH3n 3n4Bl3d j00 C4N Tr4cK +3H Ch@nG3s 4 us3R m@kEs +0 +hE1r u53rn4M3 vI4 THE 4DM1N u53r +00ls.";
$lang['forum_settings_help_54'] = "use <b>fORUm RUl3s</b> +o 3ntEr 4n @CC3PT4blE Us3 p0L1cy Th4+ 34CH usEr mUs+ 49R3E +0 8ephoRE r3GIs+3R1n9 0N YOur f0ruM.";
$lang['forum_settings_help_55'] = "j00 C4N u\$e h+mL 1N y0ur Ph0RuM RulEs. Hyp3rLiNks 4nD 3MA1L 4ddr3SSe\$ WIlL 4Ls0 B3 4UtOmat1c4Lly C0nvER+Ed tO LiNKS. to U\$e +hE DEF4ul+ BE3H1v3 ph0rum @Up CL3@R ThE fi3lD.";
$lang['forum_settings_help_56'] = "use <b>n0-r3Ply 3M4il</b> to sp3CiPhy 4n 3m4iL 4dDre5S +h4+ Do3s N0T Ex1\$+ oR w1LL N0T B3 m0NI+0red FOr R3PLi3S. +hi\$ eMa1l ADDr3sS WILl 8e U53d iN +He h34D3rs pHor alL Em4ils sen+ fRoM y0ur pHorum iNCLUD1nG 8U+ no+ l1Mi+3D +O po5+ 4nD pm Not1phic@+I0Ns, U53r 3M@il\$ @nD p45\$w0rd r3mind3rs.";
$lang['forum_settings_help_57'] = "it I5 rec0mm3ND3D +h4t j00 UsE 4N EM@il @DDR3SS +h4t Do3S n0T Ex1\$+ to HElp cut DoWn On spaM +h4T M4Y 8e DiREC+3D AT youR M@iN f0RUm 3MA1L @DDRes\$";

// Attachments (attachments.php, get_attachment.php) ---------------------------------------

$lang['aidnotspecified'] = "aId N0t spECipHi3D.";
$lang['upload'] = "upL0@d";
$lang['uploadnewattachment'] = "upLo4D n3w 4t+@ChM3nT";
$lang['waitdotdot'] = "w@1+..";
$lang['successfullyuploaded'] = "suCC3S\$FUlLY UpLo@D3D: %s";
$lang['failedtoupload'] = "f41l3D +o UpLo@D: %s";
$lang['complete'] = "c0mPL3T3";
$lang['uploadattachment'] = "upLo@D 4 pH1l3 ph0r 4ttaCHm3n+ +0 thE mess@GE";
$lang['enterfilenamestoupload'] = "ent3r Phil3n4M3(5) to upl04D";
$lang['attachmentsforthismessage'] = "att4Chm3NtS phor +hIs m3S\$49E";
$lang['otherattachmentsincludingpm'] = "o+h3r @+taCHm3nts (InCLUDIN9 pM mEs549es 4nD 0+H3R PhoRUms)";
$lang['totalsize'] = "t0+4L s1ze";
$lang['freespace'] = "fr3E sp4CE";
$lang['attachmentproblem'] = "thERE w4\$ 4 probL3M DownL0@Din9 thi\$ 4T+@cHmen+. pLE453 try 494In l4+3r.";
$lang['attachmentshavebeendisabled'] = "a++@CHm3Nt5 H4v3 83eN D1S48L3D By +HE F0rUm own3r.";
$lang['canonlyuploadmaximum'] = "j00 c4N onLy uPl04D a m4ximUm oph 10 FIL3s @T a T1m3";
$lang['deleteattachments'] = "dEL3+E 4++@Chm3NTS";
$lang['deleteattachmentsconfirm'] = "aRe j00 \$URE j00 w4N+ +o Del3T3 +h3 5el3ct3D 4+T4CHmENtS?";
$lang['deletethumbnailsconfirm'] = "aR3 J00 \$UR3 J00 w4nT tO D3l3tE +3h sel3c+3D @tT4CHMENts thUM8N4Ils?";

// Changing passwords (change_pw.php) ----------------------------------

$lang['passwdchanged'] = "p@\$SworD CHaNgeD";
$lang['passedchangedexp'] = "y0Ur p@ssw0RD h@\$ 8eEn Ch@N9ED.";
$lang['updatefailed'] = "uPD@t3 PH41l3D";
$lang['passwdsdonotmatch'] = "p@\$swords D0 noT m4+Ch.";
$lang['newandoldpasswdarethesame'] = "n3w @nD old p@\$SW0RDs @r3 th3 \$4m3.";
$lang['requiredinformationnotfound'] = "rEquir3D 1NPH0Rm4+i0n n0+ phoUnd";
$lang['forgotpasswd'] = "f0R90+ P4s\$w0rD";
$lang['resetpassword'] = "rE5E+ p4Ssw0RD";
$lang['resetpasswordto'] = "r3seT P@ssw0RD +o";
$lang['invaliduseraccount'] = "iNv@l1D U\$3R @cC0unt \$P3cipHi3D. ChECK 3m4il F0r COrrECT link";
$lang['invaliduserkeyprovided'] = "iNV4l1d USer k3Y pr0VIDED. Ch3ck Em@1l f0R C0rrecT lINk";

// Deleting messages (delete.php) --------------------------------------

$lang['nomessagespecifiedfordel'] = "n0 m3\$s@g3 sp3c1Ph1eD Phor D3lE+I0N";
$lang['deletemessage'] = "d3LE+3 Mess493";
$lang['postdelsuccessfully'] = "poST dEl3+3d \$ucCEssfUlLy";
$lang['errordelpost'] = "erR0r del3+1n9 p05t";
$lang['cannotdeletepostsinthisfolder'] = "j00 C@nn0T DEL3te p0STs IN +hI\$ PhOlDEr";

// Editing things (edit.php, edit_poll.php) -----------------------------------------

$lang['nomessagespecifiedforedit'] = "nO mEss4g3 speCipHi3D Ph0r ED1+iNg";
$lang['cannoteditpollsinlightmode'] = "c4nnoT 3d1+ P0lls IN l1gHT m0DE";
$lang['editedbyuser'] = "edItED: %s 8y %s";
$lang['editappliedtomessage'] = "eD1+ 4PPLi3d +0 mEss493";
$lang['errorupdatingpost'] = "eRRor uPD4+iNg p05+";
$lang['editmessage'] = "ed1t mEs\$49E %s";
$lang['editpollwarning'] = "<b>n0t3</b>: 3Di+1N9 CER+41n @sp3c+\$ 0f 4 p0Ll WIll V0ID 4ll +h3 Curr3NT v0T3s @ND @lLow PE0pl3 +o V0+3 494in.";
$lang['hardedit'] = "h4RD 3DI+ Op+i0Ns (VoT3s WilL B3 RES3t):";
$lang['softedit'] = "s0Ph+ 3D1+ op+ionS (vo+3S w1LL BE REt@iN3D):";
$lang['changewhenpollcloses'] = "ch@nGE wH3n tHE poll CL0SEs?";
$lang['nochange'] = "n0 ch@ngE";
$lang['emailresult'] = "eM@1L rEsUl+";
$lang['msgsent'] = "meS\$@g3 seN+";
$lang['msgsentsuccessfully'] = "meSs4G3 sEn+ \$UCcesSFully.";
$lang['mailsystemfailure'] = "m41L \$Y\$+3m faiLUr3. m3ssA93 NOt S3N+.";
$lang['nopermissiontoedit'] = "j00 4r3 nO+ P3RM1+T3d to eDiT this M3sS4G3.";
$lang['cannoteditpostsinthisfolder'] = "j00 C4NnO+ 3d1+ Post5 1n th1s pholDER";
$lang['messagewasnotfound'] = "meSs4G3 %s w45 nOt phOUnD";

// Email (email.php) ---------------------------------------------------

$lang['sendemailtouser'] = "send 3Ma1L +o %s";
$lang['nouserspecifiedforemail'] = "no usER 5p3C1f13d f0R 3M@il1N9.";
$lang['entersubjectformessage'] = "eNter 4 5ubjEct f0R Th3 mEss4G3";
$lang['entercontentformessage'] = "eNT3r 5OME C0ntEnt foR th3 m3ss49e";
$lang['msgsentfromby'] = "tH1s Mes\$@GE W4S 5EN+ PhRoM %s 8y %s";
$lang['subject'] = "su8J3C+";
$lang['send'] = "s3ND";
$lang['userhasoptedoutofemail'] = "%s H4s 0p+3D 0U+ 0PH Em41l Con+@Ct";
$lang['userhasinvalidemailaddress'] = "%s h@s 4n 1Nv4liD 3M4iL 4dDRe\$S";

// Message nofificaiton ------------------------------------------------

$lang['msgnotification_subject'] = "m3\$S4g3 N0TIFiC4tiON pHrOm %s";
$lang['msgnotificationemail'] = "heLL0 %s,\n\n%s P0S+ED 4 mESS49e +0 J00 0N %s.\n\n+he \$uBj3c+ Is: %s.\n\nT0 RE4D +H4+ mESs@93 4Nd OtHER5 in tEH s4me D15cu5\$i0n, g0 t0:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nNOTE: 1F J00 D0 N0t wIsH to rEC31v3 Em41l n0+1PHIc4+i0n5 oPh ph0RUM M3ss4gES pO5+ed T0 y0u, g0 +o: %s Cl1cK On mY Con+r0Ls +hEN em@1L And pr1V4cY, Uns3leC+ +H3 em4Il n0t1FiC@+10N ch3CKB0x @ND press \$UbmI+.";

// Thread Subscription notification ------------------------------------

$lang['subnotification_subject'] = "sUbscriP+i0n N0+iphIC4+i0n Phr0m %s";
$lang['subnotification'] = "h3LlO %s,\n\n%s P0sT3D A ME5S@gE In @ thr3@d j00 h@v3 \$ubsCR1b3d tO on %s.\n\nth3 \$uBJECT 1\$: %s.\n\nT0 re4d +H4+ M3SS493 4ND 0+H3R\$ in +H3 s4me d1\$cU5\$10n, 90 t0:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nN0te: 1F j00 d0 NO+ Wi\$H +o reC31v3 Ema1L no+iph1c4+i0N\$ of n3w mEss@ges IN +his +hr34d, go to: %s 4ND 4djU\$T Your intEr3\$+ l3VEl @+ +hE 80+t0m of +he PA9e.";

// PM notification -----------------------------------------------------

$lang['pmnotification_subject'] = "pm n0+1phicA+1on Phr0M %s";
$lang['pmnotification'] = "hEllo %s,\n\n%s p0S+ED 4 Pm +o j00 0n %s.\n\n+hE \$uBj3Ct 15: %s.\n\n+0 r3@d tHE m3\$s493 90 +0:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nnoTE: 1ph J00 D0 nO+ w1SH +0 R3C31v3 3M@il n0+IphICA+1On\$ oF neW Pm m35s@G3S pO5+ED to Y0U, 90 to: %s Cl1CK mY C0n+R0LS +h3n Ema1l 4nD Priv4CY, uns3lEC+ +eh pm n0+1ph1C4tion ch3ckBox @nD pr3ss subm1+.";

// Password change notification ----------------------------------------

$lang['passwdchangenotification'] = "p4SsW0rd CH4N93 NOt1FIc4+1ON phr0M %s";
$lang['pwchangeemail'] = "h3LL0 %s,\n\nThI\$ @ nO+ifiC4+i0N Em41l +o INphorm J00 th4+ YoUr p4ssw0RD 0n %s H4s bE3n cH4N9ED.\n\n1+ h4s B33n cH4NG3d t0: %s @nd W4s CHAnGED 8Y: %s.\n\nIPh j00 h4vE r3cEiv3d +hi\$ 3ma1l 1n 3Rror 0R wEr3 n0T 3XPeCT1N9 4 Ch4ng3 t0 Y0ur PassW0rD plE4\$E C0n+4Ct +h3 ph0rUM 0wn3R 0R 4 mod3r@t0r 0n %s imMED14t3Ly +0 corr3C+ i+.";

// Email confirmation notification -------------------------------------

$lang['emailconfirmationrequired'] = "em@1l C0npH1Rm@+1ON rEQUIr3d f0R %s";
$lang['confirmemail'] = "hEllo %s,\n\nY0U r3c3ntLy CR34+3D @ nEw U5ER 4CC0UNt 0N %s.\n8eph0rE j00 C@N Star+ P05+ing W3 nE3d to ConPh1rm YoUR 3m4iL 4DDR3ss. D0N't w0rrY +h15 Is qu1+e 34sy. @Ll j00 n3ed +o DO 1\$ ClICk +EH LinK beLow (0r Copy 4nD P@S+3 1+ 1nt0 y0Ur BROWSER):\n\n%s\n\nonCE ConFirm@+i0n i\$ C0MplEtE j00 M@Y l091N 4ND st4rt po\$T1Ng immEDi4t3ly.\n\niph J00 D1d N0+ Cre4+3 4 User ACcoun+ on %s Pl3ase 4CCepT our 4Polo9ies 4nd pHorw@rd +his 3m@il +o %s So tH@T +3H \$OUrc3 OF 1+ m4y 8e 1NVE5+1g4+eD.";
$lang['confirmchangedemail'] = "h3llo %s,\n\nYou r3CEn+ly CH@n9ed YouR Em41L 0n %s.\n8ePHOrE j00 CaN s+4r+ po\$+InG @g@In w3 n3ed +0 COnFirm y0UR new Em@il @DdrEss. Don'+ w0rrY tHi\$ 1s QU1+3 3@5Y. @ll j00 nEED To do Is CL1CK tHE l1nK B3loW (or cOpy 4nD p4ste i+ IN+0 y0Ur Br0wsEr):\n\n%s\n\n0ncE CoNph1rma+10n 1\$ COmpleTE j00 may coN+InU3 T0 UsE +eh f0rUm @S n0rm4l.\n\n1f j00 W3re NO+ 3xp3c+inG +h1\$ Em41L phrom %s PLe4\$e 4cC3pt oUr 4pol0913\$ @nd Forw4rD thi\$ 3M@il +o %s so th@t +3H S0urcE Of It M4y 83 INv3S+i94+ed.";


// Forgotten password notification -------------------------------------

$lang['forgotpwemail'] = "h3Llo %s,\n\ny0U r3QU3s+ED TH1s E-m41L Phrom %s 8Ec@USe j00 h4v3 F0Rg0+tEn y0ur P@\$\$wOrD.\n\ncLiCK The L1NK 8elOW (Or COpy 4ND P4\$+E i+ In+o yOuR 8rowseR) T0 res3t Y0ur PAS5w0rD:\n\n%s";

// Forgotten password form.

$lang['passwdresetrequest'] = "y0ur passw0RD R3se+ REQU3st fRom %s";
$lang['passwdresetemailsent'] = "p45\$W0rd RE53+ e-m41l sEnT";
$lang['passwdresetexp'] = "j00 5HOUlD sH0RtLY rEce1vE aN E-m4iL COnT41NIng iNs+rUC+ions pHoR r3SE+T1Ng y0Ur p4SSw0RD.";
$lang['validusernamerequired'] = "a VaL1D usERn@M3 iS r3qu1RED";
$lang['forgottenpasswd'] = "f0RG0T P4\$\$W0rd";
$lang['couldnotsendpasswordreminder'] = "cOulD N0+ \$enD p4SSw0Rd r3mind3r. Pl34se CoNT4C+ +h3 f0Rum owNER.";
$lang['request'] = "reQu3s+";

// Email confirmation (confirm_email.php) ------------------------------

$lang['emailconfirmation'] = "em@1l CoNpHirm4+1oN";
$lang['emailconfirmationcomplete'] = "tH@nk j00 PH0r c0nphirMiNG Y0UR EM4il aDDr3ss. J00 m@Y n0w lo9In 4nd st4rt Pos+iNg iMmEDI4T3Ly.";
$lang['emailconfirmationfailed'] = "emAIl ConPhIRM4T10n has Ph41l3d, PL34s3 tRY 494IN laTER. 1f j00 3NCOUNTER thI\$ 3rrOr MUlt1pLE T1m3s ple4S3 c0n+@Ct +3h foRum Own3R OR 4 moDeR4+0r f0r @S5Is+4NCE.";

// Links database (links*.php) -----------------------------------------

$lang['toplevel'] = "t0P l3Vel";
$lang['maynotaccessthissection'] = "j00 m@Y N0t 4CC3\$s +H1\$ 53C+i0N.";
$lang['toplevel'] = "t0P l3vEL";
$lang['links'] = "liNKs";
$lang['viewmode'] = "vi3w m0dE";
$lang['hierarchical'] = "hierarCh1C4L";
$lang['list'] = "li5+";
$lang['folderhidden'] = "th1\$ f0LDER i5 hIDD3N";
$lang['hide'] = "h1dE";
$lang['unhide'] = "uNhiD3";
$lang['nosubfolders'] = "n0 su8ph0lD3R\$ iN tH1s C4+egory";
$lang['1subfolder'] = "1 \$u8phOlDER in tH1S c4te90ry";
$lang['subfoldersinthiscategory'] = "sUBF0LDEr\$ in +His C4+EG0ry";
$lang['linksdelexp'] = "eN+RiEs in @ D3L3teD F0lDER w1Ll 8e M0V3D +0 TEh p@r3Nt F0LD3r. 0NLY pholDErs wH1cH D0 NOT cOn+@in \$U8PholDER\$ M@y 8E del3TED.";
$lang['listview'] = "l1\$t v1Ew";
$lang['listviewcannotaddfolders'] = "c4Nn0+ 4Dd f0LD3rs in +his vi3W. \$h0wIn9 20 3nTr1es @t @ +im3.";
$lang['rating'] = "r@tiNg";
$lang['nolinksinfolder'] = "n0 liNk\$ IN th1\$ pHolDER.";
$lang['addlinkhere'] = "adD L1nK hER3";
$lang['notvalidURI'] = "tH4+ is no+ @ v@l1D Uri!";
$lang['mustspecifyname'] = "j00 mU\$t \$P3cipHy 4 N@M3!";
$lang['mustspecifyvalidfolder'] = "j00 mU\$T \$P3cipHy 4 v@l1d pHOlD3R!";
$lang['mustspecifyfolder'] = "j00 mus+ 5PEcify a pHoldER!";
$lang['successfullyaddedlinkname'] = "sUcC3ssfUllY 4DD3d L1Nk '%s'";
$lang['failedtoaddlink'] = "f@1L3d t0 4Dd L1nk";
$lang['failedtoaddfolder'] = "f@1lED +0 4dd f0LDER";
$lang['addlink'] = "aDD @ L1nk";
$lang['addinglinkin'] = "addiNG l1nK 1n";
$lang['addressurluri'] = "aDdr3ss";
$lang['addnewfolder'] = "aDd @ n3W f0LDER";
$lang['addnewfolderunder'] = "adDin9 n3w fOLDer UNDEr";
$lang['editfolder'] = "ed1+ FolD3r";
$lang['editingfolder'] = "eD1TIng ph0lDer";
$lang['mustchooserating'] = "j00 mus+ Choose 4 r@tIng!";
$lang['commentadded'] = "y0ur C0mMen+ w@\$ 4ddeD.";
$lang['commentdeleted'] = "cOMMEnT W4S D3L3ted.";
$lang['commentcouldnotbedeleted'] = "coMmEnt coUlD no+ 8E D3lE+ED.";
$lang['musttypecomment'] = "j00 mU\$t typ3 4 c0MMenT!";
$lang['mustprovidelinkID'] = "j00 mu\$T ProViD3 4 liNk iD!";
$lang['invalidlinkID'] = "iNv4liD L1nk 1D!";
$lang['address'] = "address";
$lang['submittedby'] = "sUbmi+Ted 8Y";
$lang['clicks'] = "click5";
$lang['rating'] = "r4Tin9";
$lang['vote'] = "vOte";
$lang['votes'] = "v0T3s";
$lang['notratedyet'] = "n0T r@tEd BY @ny0NE y3t";
$lang['rate'] = "r4te";
$lang['bad'] = "b4d";
$lang['good'] = "g00D";
$lang['voteexcmark'] = "v0te!";
$lang['clearvote'] = "cle4r v0te";
$lang['commentby'] = "cOmm3nt BY %s";
$lang['addacommentabout'] = "aDd 4 CoMm3nt 4BOUT";
$lang['modtools'] = "m0DEr@ti0N t0Ol5";
$lang['editname'] = "eDi+ n4ME";
$lang['editaddress'] = "ed1t 4ddR3Ss";
$lang['editdescription'] = "eD1t d3SCR1P+I0n";
$lang['moveto'] = "m0V3 +o";
$lang['linkdetails'] = "l1Nk DE+41ls";
$lang['addcomment'] = "aDd c0mmEn+";
$lang['voterecorded'] = "yoUr Vo+3 h45 B3en r3C0rdED";
$lang['votecleared'] = "y0uR v0tE H4s 8EEn ClE4red";
$lang['linknametoolong'] = "lInk n4m3 +0o l0N9. M@ximUM 1\$ %s CH4ract3rs";
$lang['linkurltoolong'] = "lINk Url +0o loN9. M@x1mUM I\$ %s Ch4R4cter5";
$lang['linkfoldernametoolong'] = "f0lder n@Me too l0n9. m@x1mUm l3N9TH i\$ %s ch4R4ctErs";

// Login / logout (llogon.php, logon.php, logout.php) -----------------------------------------

$lang['loggedinsuccessfully'] = "j00 l0993d In \$UCcE5\$fUlly.";
$lang['presscontinuetoresend'] = "pR3\$S c0n+1NUE T0 rEsEnD PhOrm D4Ta 0r CanC3L +o R3LO@D P493.";
$lang['usernameorpasswdnotvalid'] = "the u\$ERn4me or P4\$SW0rd j00 sUPPL13D i\$ n0T V4l1D.";
$lang['rememberpasswds'] = "r3M3M8er p@5\$W0RDS";
$lang['rememberpassword'] = "remeM83r p4\$\$wOrD";
$lang['enterasa'] = "ent3r 4s @ %s";
$lang['donthaveanaccount'] = "dOn'T H4v3 4n ACcOUN+? %s";
$lang['registernow'] = "re915+er NoW.";
$lang['problemsloggingon'] = "pr0BlEms lo99ing on?";
$lang['deletecookies'] = "d3L3+E Co0kIE5";
$lang['cookiessuccessfullydeleted'] = "c0oki3s \$UCC3ssphUlly DEL3tED";
$lang['forgottenpasswd'] = "f0r9ottEn y0UR p@\$sw0rD?";
$lang['usingaPDA'] = "uS1NG A PD4?";
$lang['lightHTMLversion'] = "l19ht h+ml vEr\$i0n";
$lang['youhaveloggedout'] = "j00 h4ve lOggED ouT.";
$lang['currentlyloggedinas'] = "j00 @Re CURr3nTLY l0GG3D in a5 %s";
$lang['logonbutton'] = "l090n";
$lang['otherbutton'] = "o+h3r";
$lang['yoursessionhasexpired'] = "y0ur ses\$10N H45 Exp1r3d. j00 w1ll nE3D t0 l091N 49@in +o C0NT1nu3.";

// My Forums (forums.php) ---------------------------------------------------------

$lang['myforums'] = "my ph0rums";
$lang['allavailableforums'] = "aLl 4v@il@ble PhoRUms";
$lang['favouriteforums'] = "f@v0Uri+e f0Rum\$";
$lang['ignoredforums'] = "igNoRed f0RUms";
$lang['ignoreforum'] = "iGN0RE f0rum";
$lang['unignoreforum'] = "uNignOre ForuM";
$lang['lastvisited'] = "l45+ visi+eD";
$lang['forumunreadmessages'] = "%s unr34d mEs\$49Es";
$lang['forummessages'] = "%s mess49es";
$lang['forumunreadtome'] = "%s UNRe@D &quot;To: m3&quot;";
$lang['forumnounreadmessages'] = "n0 unR34d mess@ges";
$lang['removefromfavourites'] = "rEMOVE fR0M f4v0URi+e\$";
$lang['addtofavourites'] = "aDd to f4v0URites";
$lang['availableforums'] = "av41l48lE ph0rUm\$";
$lang['noforumsofselectedtype'] = "th3r3 4re n0 FOrum\$ 0f tEh s3lEcteD +yPE 4V4ILA8l3. plEAs3 s3LEC+ a D1pHpH3ren+ tyP3.";
$lang['successfullyaddedforumtofavourites'] = "succ3\$SfUlLY @DDEd f0rum TO PH4V0UR1TEs.";
$lang['successfullyremovedforumfromfavourites'] = "sucC3SsphuLlY R3movED F0rum phRom phav0URITes.";
$lang['successfullyignoredforum'] = "sucCEssphulLy i9noreD pH0rum.";
$lang['successfullyunignoredforum'] = "sUCC3SSFully un1gNOReD F0RUM.";
$lang['noforumsavailablelogin'] = "there 4Re no Ph0RuM\$ 4v4iL@BLE. pL34\$3 l091n to v13w y0UR ph0rum5.";
$lang['passwdprotectedforum'] = "p4\$5w0RD proT3C+3d F0rum";
$lang['passwdprotectedwarning'] = "tHis PHOrum is p@\$\$WORD PR0+3C+3d. +0 G4IN 4CC3\$\$ 3nt3R +Eh p4s\$WOrD B3l0w.";

// Message composition (post.php, lpost.php) --------------------------------------

$lang['postmessage'] = "po5+ mEss49E";
$lang['selectfolder'] = "s3L3C+ f0LdER";
$lang['mustenterpostcontent'] = "j00 mus+ 3ntEr \$0me Con+EnT for ThE PO\$+!";
$lang['messagepreview'] = "mesS@Ge PreView";
$lang['invalidusername'] = "inv4l1d usern4m3!";
$lang['mustenterthreadtitle'] = "j00 muST 3n+er a +ITlE ph0R +h3 thRe4D!";
$lang['pleaseselectfolder'] = "pL34se s3l3ct @ phOLD3R!";
$lang['errorcreatingpost'] = "eRR0R cr3@T1nG pos+! ple4sE +ry 4g@1N 1n @ phew minutE5.";
$lang['createnewthread'] = "cr34+3 new tHrE4D";
$lang['postreply'] = "p0S+ rEply";
$lang['threadtitle'] = "tHr3aD T1+l3";
$lang['messagehasbeendeleted'] = "m3\$5@ge no+ Ph0und. CH3CK +h@+ I+ h@sn'+ 833N dEl3+ed.";
$lang['messagenotfoundinselectedfolder'] = "meS54g3 Not found in s3lEC+3D F0LDeR. CH3CK tH@t i+ h4SN'+ 8e3N mov3d 0R D3L3t3D.";
$lang['cannotpostthisthreadtypeinfolder'] = "j00 c4nN0t p0\$t THi\$ +hR34D +ypE 1n tH@+ pH0ldEr!";
$lang['cannotpostthisthreadtype'] = "j00 C@nnoT pOS+ +hiS +hr3ad tyPe @\$ th3R3 4Re N0 aV4iLA8lE Ph0ld3r\$ +H4T 4Ll0W I+.";
$lang['cannotcreatenewthreads'] = "j00 c4nn0+ CrE@Te n3w thR34d5.";
$lang['threadisclosedforposting'] = "tHI\$ thREAD 1\$ Cl0SED, j00 c4NNo+ P0\$t 1N 1+!";
$lang['moderatorthreadclosed'] = "w4RniNG: +his +Hr34D I\$ cl0S3d F0R pO\$+1n9 +O N0Rm@l U\$3rs.";
$lang['usersinthread'] = "uS3rs 1N +HREad";
$lang['correctedcode'] = "c0rr3c+ed c0dE";
$lang['submittedcode'] = "sUBmIT+3D c0D3";
$lang['htmlinmessage'] = "hTMl in mes\$49e";
$lang['disableemoticonsinmessage'] = "d1S4bl3 3MOt1Con\$ In Me5\$4GE";
$lang['automaticallyparseurls'] = "aU+om@+1cally P@rs3 urlS";
$lang['automaticallycheckspelling'] = "aU+om4T1c4lly CH3CK speLl1n9";
$lang['setthreadtohighinterest'] = "se+ +HrE4d +o Hi9H 1ntEr3s+";
$lang['enabledwithautolinebreaks'] = "eN48LED Wi+h 4U+0-lInE-8r34K\$";
$lang['fixhtmlexplanation'] = "th1s f0rUm usE\$ h+ml pHILtErin9. yOUR \$u8m1++3D h+ml h4S BEEN m0D1phi3d 8y +eH PhIlTEr\$ iN Some w@y.\\n\\n+0 v1ew yoUR oRI91n4L CODE, s3L3Ct TEh \\'sU8M1+TeD C0dE\\' r4di0 BU++0N.\\n+o Vi3W +hE Mod1PHI3d codE, s3lEC+ +h3 \\'C0rR3C+3d C0DE\\' r4D10 8UTt0n.";
$lang['messageoptions'] = "meS\$49e 0P+10Ns";
$lang['notallowedembedattachmentpost'] = "j00 4R3 no+ 4llow3D +0 EmB3d 4+t4cHmENTs in yOUR Po5+S.";
$lang['notallowedembedattachmentsignature'] = "j00 4r3 n0t all0WED +0 EM83D @+t4cHMen+s IN y0ur si9N4+UR3.";
$lang['reducemessagelength'] = "m35SA9e l3n9+H mU\$+ Be UND3R 65,535 chaR4CT3r\$ (CURr3n+ly: %s)";
$lang['reducesiglength'] = "si9n4ture lEngth MU\$t b3 unD3r 65,535 Ch@R4c+er5 (curR3n+ly: %s)";
$lang['cannotcreatethreadinfolder'] = "j00 CAnNo+ crE4t3 n3W ThR34d\$ In +hI\$ f0lD3r";
$lang['cannotcreatepostinfolder'] = "j00 c@Nn0T RePLy +0 p0S+s iN +hi\$ f0LDER";
$lang['cannotattachfilesinfolder'] = "j00 CAnn0t pos+ aTtaCHm3nTS in +H1\$ Ph0ld3R. reMoV3 @tT4ChMeNts To con+1NuE.";
$lang['postfrequencytoogreat'] = "j00 c4n 0nLy p05t 0nce 3V3ry %s sEconds. pL3@s3 tRy A9@In l@+Er.";
$lang['emailconfirmationrequiredbeforepost'] = "eMa1L CoNFiRm@+10n i\$ r3qu1r3D BEF0RE J00 can p0S+. 1Ph j00 H4Ve n0T R3ce1vED 4 conF1RMat10N 3mA1l pL3ase cl1ck +h3 8U++On B3loW AnD @ n3w 0N3 WILl BE 5EN+ +0 Y0u. 1f your 3m4il aDDR3ss nEED5 Ch4ng1NG plE@S3 Do s0 8ePHor3 Requ3\$t1ng @ n3w C0NPhirm4+10n EM4Il. j00 m4Y Ch4n9e your 3m41l @ddr35\$ By Cl1CK my contrOls a80v3 4nd TH3N User d3+4iL\$";
$lang['emailconfirmationfailedtosend'] = "c0NFirM4T1on eM4Il F@1leD +o senD. pL3AS3 COnT4CT ThE pHoruM 0Wn3r to rECTIfy This.";
$lang['emailconfirmationsent'] = "c0NphirM@+10n 3m@1l h@S 833n r353n+.";
$lang['resendconfirmation'] = "rEsenD c0Nph1RM@+i0n";
$lang['userapprovalrequiredbeforeaccess'] = "yOUr UsER ACC0unt n3eDs +0 83 @ppr0vED 8Y @ Ph0rum ADM1N BEF0RE j00 c4n 4Cces\$ +3h rEqUEStED pHorUM.";

// Message display (messages.php & messages.inc.php) --------------------------------------

$lang['inreplyto'] = "iN REpLy +o";
$lang['showmessages'] = "sH0w m3ss@GE\$";
$lang['ratemyinterest'] = "r4+3 MY In+Er3St";
$lang['adjtextsize'] = "aDJu5+ +eXT s1ZE";
$lang['smaller'] = "sm@Ll3r";
$lang['larger'] = "l@r93R";
$lang['faq'] = "f@Q";
$lang['docs'] = "doc\$";
$lang['support'] = "supP0r+";
$lang['donateexcmark'] = "dOn4+E!";
$lang['fontsizechanged'] = "f0NT s1z3 Ch@n9eD. %s";
$lang['framesmustbereloaded'] = "fr@MeS mus+ B3 r3lO@D3d M@NU4lly +0 s3E CHANgE\$.";
$lang['threadcouldnotbefound'] = "the R3QU3sTed +hr34d C0uld n0T BE f0UnD 0R 4cc3s5 w@s DEnieD.";
$lang['mustselectpolloption'] = "j00 MUst sEL3ct @n opTiOn +O votE For!";
$lang['mustvoteforallgroups'] = "j00 MUs+ vot3 In 3VERy 9ROUp.";
$lang['keepreading'] = "kE3p R34dIng";
$lang['backtothreadlist'] = "b4CK T0 ThRE4d li\$+";
$lang['postdoesnotexist'] = "th4+ po\$+ D0es n0T Exi5+ iN th1S +Hr34D!";
$lang['clicktochangevote'] = "cLiCk +o CH@n9e V0+e";
$lang['youvotedforoption'] = "j00 V0+3D F0R oP+1On";
$lang['youvotedforoptions'] = "j00 votEd F0R 0p+1On\$";
$lang['clicktovote'] = "cliCk +0 vo+3";
$lang['youhavenotvoted'] = "j00 H@vE n0T Vot3D";
$lang['viewresults'] = "vieW Re\$ult5";
$lang['msgtruncated'] = "m3S\$@GE +Runc4TEd";
$lang['viewfullmsg'] = "v1eW Phull mEss4G3";
$lang['ignoredmsg'] = "iGN0rED mE\$S493";
$lang['wormeduser'] = "w0RmEd us3r";
$lang['ignoredsig'] = "i9Nor3d s1gn@TUre";
$lang['messagewasdeleted'] = "me\$S4ge %s.%s W@S Del3tED";
$lang['stopignoringthisuser'] = "s+0p iGnor1NG +his UseR";
$lang['renamethread'] = "r3N@me +hr3AD";
$lang['movethread'] = "moV3 +hR3@D";
$lang['torenamethisthreadyoumusteditthepoll'] = "t0 ren4ME th1\$ +HR34D j00 mUsT 3D1+ t3H poll.";
$lang['closeforposting'] = "cl053 pHOR p0ST1ng";
$lang['until'] = "un+il 00:00 u+C";
$lang['approvalrequired'] = "apPrOval rEqu1Red";
$lang['messageawaitingapprovalbymoderator'] = "m3\$S49e %s.%s 1S @w@i+1NG @Ppr0vAL 8Y @ M0DER@t0r";
$lang['postapprovedsuccessfully'] = "p0St 4PPR0V3D 5uCCESsfulLy";
$lang['postapprovalfailed'] = "p0S+ approval f41L3d.";
$lang['postdoesnotrequireapproval'] = "pO5+ d03s n0+ requIR3 @ppr0V4l";
$lang['approvepost'] = "apPr0v3 PO\$+ f0r DI\$PL4y";
$lang['approvedbyuser'] = "aPPR0veD: %s by %s";
$lang['makesticky'] = "m4ke 5t1CKy";
$lang['messagecountdisplay'] = "%s of %s";
$lang['linktothread'] = "p3rm4N3n+ L1nK +0 tHi\$ +hr34d";
$lang['linktopost'] = "l1nK to p0\$+";
$lang['linktothispost'] = "l1Nk to thi5 Pos+";
$lang['imageresized'] = "tH1S im4g3 h4s B3en r3S1zeD (0R1g1N@L siz3 %1\$\$X%2\$S). T0 V13w +HE FULl-s1Z3 im@G3 CL1CK h3re.";
$lang['messagedeletedbyuser'] = "m3\$S@g3 %s.%s d3lEtED %s BY %s";
$lang['messagedeleted'] = "me\$SAgE %s.%s W4s DEl3t3D";

// Moderators list (mods_list.php) -------------------------------------

$lang['cantdisplaymods'] = "c4NNot dispL@y f0LDER mod3R4tors";
$lang['moderatorlist'] = "m0der@TOr lis+:";
$lang['modsforfolder'] = "mOder4Tors f0R f0ld3R";
$lang['nomodsfound'] = "n0 M0der4+0rs phoUnD";
$lang['forumleaders'] = "foRum lEaD3Rs:";
$lang['foldermods'] = "fOlD3R m0d3r4TOr\$:";

// Navigation strip (nav.php) ------------------------------------------

$lang['start'] = "st4rt";
$lang['messages'] = "me\$SagE5";
$lang['pminbox'] = "in8ox";
$lang['startwiththreadlist'] = "st4rt p@gE w1th +hrEaD L1\$t";
$lang['pmsentitems'] = "s3Nt 1+3Ms";
$lang['pmoutbox'] = "out8ox";
$lang['pmsaveditems'] = "saV3d i+3M5";
$lang['pmdrafts'] = "dR4pH+s";
$lang['links'] = "l1Nks";
$lang['admin'] = "adM1n";
$lang['login'] = "l0G1n";
$lang['logout'] = "l0G0U+";

// PM System (pm.php, pm_write.php, pm.inc.php) ------------------------

$lang['privatemessages'] = "priV@Te M3SS49Es";
$lang['recipienttiptext'] = "s3P@r@tE REcipI3NtS 8y s3M1-c0Lon 0r COmm@";
$lang['maximumtenrecipientspermessage'] = "th3r3 i5 @ L1M1T 0f 10 reCIpien+s PER M3ss493. plE4\$3 4menD yOUr R3C1piEN+ lI\$+.";
$lang['mustspecifyrecipient'] = "j00 Mus+ sp3c1FY At l3aST onE rEciP13N+.";
$lang['usernotfound'] = "u\$Er %s N0t F0und";
$lang['sendnewpm'] = "s3nd n3W pm";
$lang['savemessage'] = "s@vE Mess@GE";
$lang['timesent'] = "t1M3 sent";
$lang['errorcreatingpm'] = "erR0r Cr3@+INg Pm! pLE4\$3 +ry 4G41n in @ fEw MiNU+3s";
$lang['writepm'] = "wr1t3 mess4g3";
$lang['editpm'] = "ed1+ m3\$s@g3";
$lang['cannoteditpm'] = "c@NNOt 3di+ +H15 pm. i+ h@s alr3aDy BEeN V1EWED By +3h R3cip13nt 0r tHE m3ss@g3 D0es NoT 3x1\$t 0R i+ i\$ IN@cC3SSI8le 8Y j00";
$lang['cannotviewpm'] = "c4nn0+ view pM. m3s5@GE DO3s noT 3X15+ 0R i+ i\$ IN@CC3SSiBLE By j00";
$lang['pmmessagenumber'] = "mE\$Sa93 %s";

$lang['youhavexnewpm'] = "j00 h@Ve %d new m3ss493\$. W0UlD j00 liK3 to g0 to Y0Ur 1N8oX n0w?";
$lang['youhave1newpm'] = "j00 H4V3 1 n3w mess493. w0uLD J00 liKE +0 g0 tO y0ur inBox Now?";
$lang['youhave1newpmand1waiting'] = "j00 h4vE 1 nEW m3sS4g3.\\n\\nY0u Al\$0 h4VE 1 M3ss49E 4wa1+iNg DEl1v3ry. +0 r3CEivE tH1s m3Ss@G3 plE4\$3 ClEar \$ome sp@Ce IN y0ur inBOX.\\n\\nW0uld J00 like +0 g0 +o yoUr In80x N0w?";
$lang['youhave1pmwaiting'] = "j00 h4vE 1 me\$\$4g3 4w@i+in9 DEl1very. +0 r3c31v3 +hIs m3SS@g3 plE4\$3 clE4r \$0m3 \$p@CE 1n youR 1nB0X.\\n\\nW0ULD j00 l1kE t0 g0 +O your inBox noW?";
$lang['youhavexnewpmand1waiting'] = "j00 h@vE %d n3W m3SS4ges.\\n\\nY0u @LsO HavE 1 M3sS@GE @w@I+InG D3L1VERy. +o REC31v3 +h15 m3SS@g3 ple4\$e CL34R 50m3 \$P4Ce 1n Y0ur 1NBOx.\\n\\nWoUlD j00 l1k3 +o g0 T0 y0Ur 1N8oX Now?";
$lang['youhavexnewpmandxwaiting'] = "j00 h4VE %d NEw m3ss49e\$.\\n\\nY0u 4LS0 h4v3 %d m35s49Es aW41+1n9 D3liv3RY. tO R3C3iV3 ThES3 M3ss@9E plE4sE CL34r s0mE \$p@cE iN yOUr in80x.\\n\\nWoulD j00 l1K3 t0 GO +0 yOUr iN80X n0w?";
$lang['youhave1newpmandxwaiting'] = "j00 haVE 1 n3W Mess493.\\n\\nY0u 4L\$0 H4V3 %d m35S@Ge\$ @W4It1ng D3LIv3ry. T0 rece1V3 thes3 MeS\$493S pLe4Se clE4R s0m3 \$p4CE in Y0Ur 1NB0x.\\n\\nW0Uld J00 LIK3 to go t0 y0Ur IN8OX N0W?";
$lang['youhavexpmwaiting'] = "j00 h@v3 %d m3ss4g3s @W@i+1Ng DEl1v3ry. +0 r3C31V3 +hesE M3s\$493s pLE@53 ClE4r \$0M3 \$p@cE iN YoUr 1n8Ox.\\n\\nWOULD j00 LIK3 +0 G0 t0 y0ur inB0X now?";

$lang['youdonothaveenoughfreespace'] = "j00 do no+ h4v3 3NOU9H PhR3E 5p@CE +0 sEND +HIs m3sS@Ge.";
$lang['userhasoptedoutofpm'] = "%s H4S 0p+3D 0Ut opH R3C31V1n9 p3r\$oN@l mess@gE\$";
$lang['pmfolderpruningisenabled'] = "pm PH0lder PrUnINg 1S 3N4BlED!";
$lang['pmpruneexplanation'] = "tHiS F0Rum USe\$ Pm f0ldeR PruN1NG. tHE mE\$S493S j00 H4v3 \$t0rED In YoUR iN8Ox 4nd s3n+ i+3Ms\\nPHoldER\$ @R3 su8JECT To 4U+0m4+IC D3lEt1on. 4NY Mess4g3S j00 w1SH tO k33P \$H0ulD 8E M0V3D To\\ny0Ur \\'s4V3d itEms\\' pHolD3r \$0 th4T TheY aRE n0T DELET3d.";
$lang['yourpmfoldersare'] = "y0ur pm F0lD3Rs 4re %s phuLl";
$lang['currentmessage'] = "cUrr3NT m3sS49E";
$lang['unreadmessage'] = "unR34D m3Ss49E";
$lang['readmessage'] = "r34d me\$S493";
$lang['pmshavebeendisabled'] = "pErSON4l m3ss49Es h@v3 83en Di\$@bLED 8y +he f0rUm 0wn3r.";
$lang['adduserstofriendslist'] = "add user\$ +0 Your FrIEnDS Lis+ +O H4VE +H3M 4PPE4r in @ DR0P D0wn on Th3 pM wr1T3 mes\$49e P4GE.";

$lang['messagesaved'] = "m3ss49E \$av3D";
$lang['messagewassuccessfullysavedtodraftsfolder'] = "mE5s49e w4s suCC3\$sfUlLy s4VED +0 'dr@f+S' PHOlDER";
$lang['couldnotsavemessage'] = "c0uld no+ \$4v3 M3Ss49E. MakE \$ur3 j00 H4V3 en0u9H @V@IL@8L3 pHrE3 sp4c3.";
$lang['pmtooltipxmessages'] = "%s Mess@gES";
$lang['pmtooltip1message'] = "1 m3S\$a93";

$lang['allowusertosendpm'] = "alLoW Us3R +0 sEnD p3R\$0n@l MEss493S +0 ME";
$lang['blockuserfromsendingpm'] = "bLOCk u\$3r fRom \$3Nd1n9 p3r\$0n4L mEss@Ge5 +0 me";
$lang['yourfoldernamefolderisempty'] = "y0Ur %s folD3R i\$ 3mpTY";
$lang['successfullydeletedselectedmessages'] = "succEs\$PHulLy d3L3teD sEl3C+3d M3sS493\$";
$lang['successfullyarchivedselectedmessages'] = "sUCC3\$SFULlY 4rCH1VED SEl3c+3D M3sS4ges";
$lang['failedtodeleteselectedmessages'] = "f4IL3D t0 D3LEtE sEL3CTed m3s5@9es";
$lang['failedtoarchiveselectedmessages'] = "fA1l3D +0 4rCHIv3 selEc+ED M3ss4G3s";

// Preferences / Profile (user_*.php) ---------------------------------------------

$lang['mycontrols'] = "mY c0NTRols";
$lang['myforums'] = "mY f0rUms";
$lang['menu'] = "m3NU";
$lang['userexp_1'] = "uSe tEh mEnU oN TEh l3pht T0 MAn49E yOur \$3tT1Ng5.";
$lang['userexp_2'] = "<b>user D3ta1Ls</b> 4llow\$ J00 t0 CH4N9E YoUR n4ME, 3m4IL 4DDR3Ss @ND P4SsW0RD.";
$lang['userexp_3'] = "<b>user pr0ph1l3</b> @ll0W5 j00 to eDi+ yOuR us3r pROf1L3.";
$lang['userexp_4'] = "<b>cH4ng3 p@\$\$w0rd</b> @ll0W\$ J00 +0 CHAn93 yoUr p4\$sw0RD";
$lang['userexp_5'] = "<b>eM41l &amp; PrivACY</b> Let5 j00 ch@n9e h0w j00 C4n b3 Con+@CTEd 0n 4nD off tEH PhOrum.";
$lang['userexp_6'] = "<b>foRUM opT10n\$</b> l3ts j00 CH4ngE hOw th3 PHOrUm LooK\$ @ND WORks.";
$lang['userexp_7'] = "<b>a++@CHm3n+s</b> 4lloW\$ j00 to EDi+/D3L3TE YoUr @++@chMEntS.";
$lang['userexp_8'] = "<b>si9natUR3</b> LEts j00 EDi+ YoUR \$19N@+UR3.";
$lang['userexp_9'] = "<b>r3l@t1onsh1Ps</b> Lets J00 M@n@G3 yOUr REl@T1oN5h1P wi+H 0+h3r uSEr5 on +3h forum.";
$lang['userexp_9'] = "<b>w0Rd phIL+3r</b> Le+5 j00 ED1+ YOuR pER\$0n@l W0rd FiL+3R.";
$lang['userexp_10'] = "<b>thRE4d su8Scr1P+10N\$</b> 4LLow5 j00 +o M@N@ge yoUr ThReaD 5u8\$cr1Pt10ns.";
$lang['userdetails'] = "u\$3R D3+41l\$";
$lang['userprofile'] = "u53r prophIl3";
$lang['emailandprivacy'] = "em@1L &amp; pRiv@Cy";
$lang['editsignature'] = "ed1+ sign4+urE";
$lang['norelationshipssetup'] = "j00 h4V3 nO U53r rEL4T10nsh1PS \$ET Up. 4DD 4 n3W Us3R 8y \$e4RChin9 8Elow.";
$lang['editwordfilter'] = "ed1+ Word FIL+3r";
$lang['userinformation'] = "us3r 1NF0Rm4Tion";
$lang['changepassword'] = "cHAN9e P@\$sw0rD";
$lang['currentpasswd'] = "cuRRENt p4SSW0rd";
$lang['newpasswd'] = "nEw p4ssw0RD";
$lang['confirmpasswd'] = "c0NF1rm p4\$\$w0RD";
$lang['passwdsdonotmatch'] = "p45\$w0RDs D0 not ma+Ch!";
$lang['nicknamerequired'] = "nickn4mE I\$ R3quirED!";
$lang['emailaddressrequired'] = "eMa1L adDRE5\$ 1S REQUiR3D!";
$lang['logonnotpermitted'] = "l0GOn No+ PErmiT+eD. CH0OS3 4NotH3r!";
$lang['nicknamenotpermitted'] = "n1cKNAmE N0T pERMi++ed. CHo0se @n0tHER!";
$lang['emailaddressnotpermitted'] = "eM4Il 4ddr3SS n0t P3Rmitt3D. CHo0\$e @no+h3r!";
$lang['emailaddressalreadyinuse'] = "eM4il aDDr3sS 4lre4DY 1N U5e. cH0OSe 4NO+h3r!";
$lang['relationshipsupdated'] = "reL4+i0N\$HIP\$ upD@+3D!";
$lang['relationshipupdatefailed'] = "r3L4+ion\$h1p uPD4+3D Ph@Il3D!";
$lang['preferencesupdated'] = "pref3REnC3S W3re 5UCCessfuLlY UpD@+3D.";
$lang['userdetails'] = "us3R d3t4IL5";
$lang['memberno'] = "m3mbER n0.";
$lang['firstname'] = "fir\$T n4M3";
$lang['lastname'] = "l45t n@mE";
$lang['dateofbirth'] = "daT3 0ph b1R+h";
$lang['homepageURL'] = "hoM3P49E Url";
$lang['profilepicturedimensions'] = "pROf1LE p1CTUR3 (M4x 95x95pX)";
$lang['avatarpicturedimensions'] = "aV4+4R PiC+URE (m4X 15x15px)";
$lang['invalidattachmentid'] = "inv@l1D 4T+@CHM3N+. CH3CK Th@t i\$ h@sn't B3en D3Le+ed.";
$lang['unsupportedimagetype'] = "unSUPp0R+3d im@9E @+t4cHmen+. j00 c4N onLy usE JPG, G1f @Nd PN9 1M49E @++@chM3nTs Ph0r yOUR AV4+4R @ND PR0f1L3 P1c+URE.";
$lang['selectattachment'] = "s3LeC+ 4T+@chM3Nt";
$lang['pictureURL'] = "p1C+Ur3 URl";
$lang['avatarURL'] = "av@+4R Url";
$lang['profilepictureconflict'] = "t0 Us3 @N @tt4cHMenT f0r YoUR pR0PhILE P1c+URE +hE p1CtuR3 URl phi3LD MUS+ B3 8L4NK.";
$lang['avatarpictureconflict'] = "to U\$E @n aT+AchMEnt pH0R y0ur av4t4r p1CTUR3 +H3 aV@T4R uRl F1Eld MU\$T b3 8l4Nk.";
$lang['attachmenttoolargeforprofilepicture'] = "s3L3c+3d @t+@CHm3NT 15 +0O L4R9E Phor pRoPhiLe pICTUR3. M@xiMUm DiMeNsi0ns 4RE %s";
$lang['attachmenttoolargeforavatarpicture'] = "s3L3c+eD 4+t4CHMEnt i5 t0O L4r93 F0R 4v4+4R pICTUR3. M@xImum D1m3N510ns 4re %s";
$lang['failedtoupdateuserdetails'] = "s0ME or 4ll 0F yOuR usER @cC0un+ D3T4il\$ coUlD N0T BE UpD@+ED. PlEAse +rY 4941N L@+er.";
$lang['failedtoupdateuserpreferences'] = "sOM3 0r 4ll 0F your usER Pr3FEr3nc3s C0uld n0t 83 upD@tED. pL3@sE TrY 49a1N l4+3R.";
$lang['emailaddresschanged'] = "eMa1l aDDR3s\$ H4\$ BE3n CH4n9eD";
$lang['newconfirmationemailsuccess'] = "y0Ur Ema1l 4Ddre\$S h@\$ B33N CH@NgED @nD @ neW conphirM4+10n em4il h4\$ BEEn \$3nt. pL3@53 chECK 4ND RE4D tH3 3mA1l f0r fUR+HEr iNstRUC+ions.";
$lang['newconfirmationemailfailure'] = "j00 h@vE Ch@n9ED Your 3M4il 4DDR3ss, BU+ w3 W3r3 UnabLE +O \$end a conPH1rm@+I0N r3qU3st. pLE4sE C0N+4c+ +h3 F0RUm oWn3r Phor 4\$\$i5+4nce.";
$lang['forumoptions'] = "fORum 0P+1on\$";
$lang['notifybyemail'] = "nO+ify BY 3m4il 0ph P0\$+s +0 mE";
$lang['notifyofnewpm'] = "nOT1fy bY p0puP oph N3W pM MES5493s +o ME";
$lang['notifyofnewpmemail'] = "nO+IfY 8y EmA1L 0ph n3w pM m3s\$49E\$ +0 M3";
$lang['daylightsaving'] = "adJUST ph0R D4YLIGht s@vInG";
$lang['autohighinterest'] = "aU+0MAT1callY M4Rk thR34ds 1 p0ST 1n as hIgH in+3RESt";
$lang['convertimagestolinks'] = "auT0m@+iC@lLy ConVErT 3m8EDD3d im4G3s in p0\$ts in+0 Link5";
$lang['thumbnailsforimageattachments'] = "tHUmbn4ILs phor im@gE @++@chmEnts";
$lang['smallsized'] = "sMALl S1z3D";
$lang['mediumsized'] = "mEDium s1zED";
$lang['largesized'] = "l@RgE \$IZ3D";
$lang['globallyignoresigs'] = "gLob@lly i9norE u\$3r s1gn4+Ur3\$";
$lang['allowpersonalmessages'] = "aLl0W 0+h3R u5erS T0 seND me PErson4L mEss@g3s";
$lang['allowemails'] = "allow 0+h3r U53rs +o \$3nd m3 eMaIl5 v1@ my proPh1L3";
$lang['timezonefromGMT'] = "t1M3 zON3";
$lang['postsperpage'] = "pOS+s p3R p4gE";
$lang['fontsize'] = "f0nt s1zE";
$lang['forumstyle'] = "f0RUm \$tYL3";
$lang['forumemoticons'] = "foRUm 3mot1con\$";
$lang['startpage'] = "sT@r+ P4ge";
$lang['signaturecontainshtmlcode'] = "sI9n4+URe COn+4iN\$ h+ml c0dE";
$lang['savesignatureforuseonallforums'] = "s@ve s1gn@+uRE f0R usE On all phOrUm\$";
$lang['preferredlang'] = "pREPherrEd l4n9U@Ge";
$lang['donotshowmyageordobtoothers'] = "d0 n0+ 5h0w My @9e 0r D@+E 0f b1r+h To 0+H3rs";
$lang['showonlymyagetoothers'] = "show ONLy mY 4ge +o o+hEr5";
$lang['showmyageanddobtoothers'] = "show bo+H mY a93 4nd D4TE 0ph B1r+h t0 oTH3r\$";
$lang['showonlymydayandmonthofbirthytoothers'] = "shOW 0nly mY DAY @nD m0n+H OpH B1rth TO 0tH3rs";
$lang['listmeontheactiveusersdisplay'] = "lIs+ me 0N +h3 @ctiV3 U\$3r\$ Displ4Y";
$lang['browseanonymously'] = "brOw\$3 f0RuM @N0NymoUsly";
$lang['allowfriendstoseemeasonline'] = "bR0wsE 4n0nyM0UsLy, 8u+ @LLow FRi3nDs +0 SEE m3 4S 0NLiN3";
$lang['revealspoileronmouseover'] = "rEvE4l spoIlerS oN M0Us3 0v3R";
$lang['showspoilersinlightmode'] = "aLWAYs \$how sp01l3RS 1n l1GH+ mOD3 (Us3s lIGh+Er F0nt C0LoUr)";
$lang['resizeimagesandreflowpage'] = "rEsize iM49es 4ND R3Fl0w p49E +0 pR3VENT hOR1Zon+4l \$CR0llIN9.";
$lang['showforumstats'] = "sh0w F0rUM \$+4t\$ 4+ 80+t0M OF M3ssage pAnE";
$lang['usewordfilter'] = "en4bL3 wOrD PHiLter.";
$lang['forceadminwordfilter'] = "f0rce UsE opH 4dmin woRD fiLtEr oN 4ll uSER5 (iNC. gUests)";
$lang['timezone'] = "t1me zoNE";
$lang['language'] = "l4NgU@ge";
$lang['emailsettings'] = "em4il anD C0N+4C+ 53+T1Ngs";
$lang['forumanonymity'] = "foRUm @n0nym1ty se+t1N9s";
$lang['birthdayanddateofbirth'] = "bIrTHD4Y AnD d4+3 OF B1rth D1\$PL4y";
$lang['includeadminfilter'] = "incluDE 4DM1N W0RD fIl+3R 1N MY l1\$+.";
$lang['setforallforums'] = "sEt ph0r @ll pHoRUm\$?";
$lang['containsinvalidchars'] = "%s c0NTa1nS 1nv@l1d CH@R@ct3r\$!";
$lang['homepageurlmustincludeschema'] = "h0mep49E url MU5+ 1nCLUD3 h++p:// \$ch3M4.";
$lang['pictureurlmustincludeschema'] = "pIc+Ure UrL mUs+ inCLUD3 h+tp:// \$ch3M4.";
$lang['avatarurlmustincludeschema'] = "avAT4R url mu\$+ incluDE h++p:// sCh3mA.";
$lang['postpage'] = "p0St p@G3";
$lang['nohtmltoolbar'] = "nO html +0OLB4r";
$lang['displaysimpletoolbar'] = "d15pl4Y \$1mpl3 HTMl +Oolbar";
$lang['displaytinymcetoolbar'] = "dIspl@y wYsIwYg H+ML +O0l84R";
$lang['displayemoticonspanel'] = "dIsPLAy 3M0+ICon\$ p4n3L";
$lang['displaysignature'] = "displ4y s19nATUrE";
$lang['disableemoticonsinpostsbydefault'] = "d1S@BLE 3mO+iC0n\$ in m3s\$493S 8y d3PHAult";
$lang['automaticallyparseurlsbydefault'] = "aUtOM@+iC4LLY p4r\$E UrL5 1N m3sS@G3s by DEPH4ul+";
$lang['postinplaintextbydefault'] = "pOSt 1N pL@1n +3XT 8y D3F4ULT";
$lang['postinhtmlwithautolinebreaksbydefault'] = "po5+ in h+ml W1Th 4u+o-L1N3-BR34k\$ 8y dePh4ult";
$lang['postinhtmlbydefault'] = "p0s+ In HtmL By d3fAULt";
$lang['privatemessageoptions'] = "pr1v4T3 m3SSA93 0ptIoN\$";
$lang['privatemessageexportoptions'] = "pR1V4+E ME5S493 Expor+ 0Pt10ns";
$lang['savepminsentitems'] = "s4VE @ C0py of 3aCH Pm 1 \$end In mY \$3Nt 1+3m5 PholDeR";
$lang['includepminreply'] = "iNcluD3 m3\$S@g3 8ODy wHEn r3PLy1ng +o pm";
$lang['autoprunemypmfoldersevery'] = "aUT0 PRUnE My pm f0LDER5 3very:";
$lang['friendsonly'] = "fR1ends only?";
$lang['globalstyles'] = "glob4L styl3S";
$lang['forumstyles'] = "forum STyL3\$";
$lang['youmustenteryourcurrentpasswd'] = "j00 mU5t 3NTER YoUr CurR3NT p4sSW0rd";
$lang['youmustenteranewpasswd'] = "j00 mu\$T 3NTEr @ NeW p@ssw0RD";
$lang['youmustconfirmyournewpasswd'] = "j00 MUst conPhiRm Y0Ur NeW pa5SWOrd";
$lang['failedtoupdateuserprofile'] = "f4il3d +0 upd@+3 u\$eR ProFiL3";

// Polls (create_poll.php, poll_results.php) ---------------------------------------------

$lang['mustprovideanswergroups'] = "j00 musT pROvIDe s0M3 4n\$w3R GRoup\$";
$lang['mustprovidepolltype'] = "j00 must pr0V1d3 4 p0ll +ypE";
$lang['mustprovidepollresultsdisplaytype'] = "j00 mU5+ proviD3 r3sUL+\$ displ4y +YP3";
$lang['mustprovidepollvotetype'] = "j00 mU5+ pr0ViD3 @ P0lL vOt3 +yPE";
$lang['mustprovidepollguestvotetype'] = "j00 mUst sp3C1fy iph 9U3S+s 5H0uld 83 4llow3d +0 V0+3";
$lang['mustprovidepolloptiontype'] = "j00 mus+ pr0v1D3 a p0Ll op+ion +ype";
$lang['mustprovidepollchangevotetype'] = "j00 muS+ PrOv1DE 4 p0Ll ChanGE Vo+3 TyPE";
$lang['pollquestioncontainsinvalidhtml'] = "one 0r M0RE Of yoUR p0ll qu3S+I0n\$ C0n+@ins Inv@lID hTMl.";
$lang['pleaseselectfolder'] = "pl3@S3 \$el3C+ @ f0LD3r";
$lang['mustspecifyvalues1and2'] = "j00 Mu\$T speC1FY vaLu3S PHor 4NSw3rS 1 anD 2";
$lang['tablepollmusthave2groups'] = "t@8UL@r PhormaT p0lls mu\$+ h@v3 PR3c1\$3Ly two Vo+iNg 9r0Up\$";
$lang['nomultivotetabulars'] = "t4buL@r phorm4+ polLs Cann0t 83 MuLt1-VO+3";
$lang['nomultivotepublic'] = "pUbl1C BALlo+5 C4nnO+ bE mUL+1-votE";
$lang['abletochangevote'] = "j00 w1Ll B3 4BL3 +0 ch@nG3 y0ur v0+3.";
$lang['abletovotemultiple'] = "j00 w1ll 8E A8le +0 voTe MUlt1plE +1M3s.";
$lang['notabletochangevote'] = "j00 wilL n0+ 8e @8LE +o Ch4ng3 yoUR v0te.";
$lang['pollvotesrandom'] = "n0+E: Poll VotES 4Re r4Nd0mly g3ner@TED pHor pR3Vi3w onLy.";
$lang['pollquestion'] = "p0LL qU3S+10n";
$lang['possibleanswers'] = "posS1blE answEr\$";
$lang['enterpollquestionexp'] = "en+3r +h3 4N\$W3rs phOr y0ur p0LL QUES+1on.. iF y0UR PolL 1s @ &quot;y3s/N0&quot; quE5+1on, SImPlY En+3R &quot;y3S&quot; pHoR 4n\$W3r 1 @nd &quot;N0&quot; pH0R @nsw3r 2.";
$lang['numberanswers'] = "no. 4n5WeR\$";
$lang['answerscontainHTML'] = "anSwErs c0N+@IN hTmL (n0+ inCLUDIng s1GN4TuR3)";
$lang['optionsdisplay'] = "aN\$wERs DIsplay +yPE";
$lang['optionsdisplayexp'] = "hOW sh0uld +EH ansWERs bE pResEn+ED?";
$lang['dropdown'] = "as drop-D0wn l1\$+(s)";
$lang['radios'] = "a\$ 4 5eri3S 0Ph r4diO BUtton\$";
$lang['votechanging'] = "vOTe CH4NgIng";
$lang['votechangingexp'] = "c4N a p3Rson Ch4n93 h1S oR hEr voTe?";
$lang['guestvoting'] = "gU35+ vo+1Ng";
$lang['guestvotingexp'] = "caN 9u3\$+s V0tE 1N Th1s POll?";
$lang['allowmultiplevotes'] = "aLl0W muLt1Pl3 voTE\$";
$lang['pollresults'] = "pOll resUlts";
$lang['pollresultsexp'] = "hOW w0uld J00 l1K3 To DIspl4Y TH3 r3sUlT\$ oph Y0Ur PolL?";
$lang['pollvotetype'] = "p0lL vo+1Ng Type";
$lang['pollvotesexp'] = "hOW shoUlD tEH Poll 83 C0nDUC+3D?";
$lang['pollvoteanon'] = "aN0NYm0Usly";
$lang['pollvotepub'] = "puBLIc 8@Ll0+";
$lang['horizgraph'] = "h0Riz0n+4l Gr@ph";
$lang['vertgraph'] = "v3R+iC@L 9R4Ph";
$lang['tablegraph'] = "t48Ul@R Phorm4+";
$lang['polltypewarning'] = "<b>w4rn1N9</b>: thI\$ i\$ 4 PubliC B4ll0+. y0Ur n4m3 w1lL 8e vIs1BLE n3XT tO Th3 0P+i0N J00 v0+3 f0r.";
$lang['expiration'] = "eXP1r4Tion";
$lang['showresultswhileopen'] = "d0 j00 W4nt +0 5h0W r3SulT\$ WhIL3 +3H P0Ll 1\$ Op3n?";
$lang['whenlikepollclose'] = "wheN W0uld j00 l1ke YoUR p0ll +O @UtOmAt1C4lly Clos3?";
$lang['oneday'] = "oN3 Day";
$lang['threedays'] = "thr3e D4ys";
$lang['sevendays'] = "sEv3N D4y5";
$lang['thirtydays'] = "tH1R+Y daY\$";
$lang['never'] = "nev3r";
$lang['polladditionalmessage'] = "aDD1t1On4l MESS@g3 (OP+i0n4L)";
$lang['polladditionalmessageexp'] = "do j00 want T0 1NcluDE 4N 4DD1+1On@L P05+ 4FTEr TEh pOlL?";
$lang['mustspecifypolltoview'] = "j00 muST sP3CipHy 4 pOll tO v1ew.";
$lang['pollconfirmclose'] = "aRe j00 SUR3 J00 waNT +0 clos3 +H3 FoLLowIN9 p0lL?";
$lang['endpoll'] = "eNd pOlL";
$lang['nobodyvotedclosedpoll'] = "nO8odY v0+3D";
$lang['votedisplayopenpoll'] = "%s 4nD %s h4V3 V0TED.";
$lang['votedisplayclosedpoll'] = "%s @nD %s VOTeD.";
$lang['nousersvoted'] = "n0 u\$ER5";
$lang['oneuservoted'] = "1 uS3R";
$lang['xusersvoted'] = "%s Users";
$lang['noguestsvoted'] = "n0 gu3S+5";
$lang['oneguestvoted'] = "1 9Uest";
$lang['xguestsvoted'] = "%s gueSTs";
$lang['pollhasended'] = "pOll ha5 EnDED";
$lang['youvotedforpolloptionsondate'] = "j00 Vo+ED Ph0r %s 0N %s";
$lang['thisisapoll'] = "tH1\$ I\$ @ poLl. cl1CK +0 V13W REsUl+5.";
$lang['editpoll'] = "ed1t P0Ll";
$lang['results'] = "rE5ul+s";
$lang['resultdetails'] = "r3\$ult dEt41ls";
$lang['changevote'] = "cH@Ng3 vote";
$lang['pollshavebeendisabled'] = "pOLl\$ h4V3 8een D15@8LED BY t3H ForUM oWN3R.";
$lang['answertext'] = "anSw3R TEx+";
$lang['answergroup'] = "aNSW3r gr0Up";
$lang['previewvotingform'] = "pRev13w vo+inG pH0Rm";
$lang['viewbypolloption'] = "view By pOll opt10n";
$lang['viewbyuser'] = "v13w 8y u53R";

// Profiles (profile.php) ----------------------------------------------

$lang['editprofile'] = "eDI+ pr0Phil3";
$lang['profileupdated'] = "prOPhIl3 upD4+3D.";
$lang['profilesnotsetup'] = "t3H pHorUm 0Wn3r h@5 not \$3t up pRoPhIl3s.";
$lang['ignoreduser'] = "igNor3D u\$3r";
$lang['lastvisit'] = "l4S+ v1SI+";
$lang['userslocaltime'] = "u5eR'\$ lOC4l +IME";
$lang['userstatus'] = "s+4tus";
$lang['useractive'] = "oNl1n3";
$lang['userinactive'] = "iN4ct1VE / oPhPhL1N3";
$lang['totaltimeinforum'] = "t0T@l +1m3";
$lang['longesttimeinforum'] = "l0N93s+ \$3ssI0n";
$lang['sendemail'] = "seND 3M4IL";
$lang['sendpm'] = "seND pm";
$lang['visithomepage'] = "v1\$i+ h0Mep4ge";
$lang['age'] = "a9e";
$lang['aged'] = "a93d";
$lang['birthday'] = "b1RthDay";
$lang['registered'] = "re91ST3r3D";
$lang['findpostsmadebyuser'] = "f1ND pOsts m4D3 BY %s";
$lang['findpostsmadebyme'] = "fIND posts m4D3 8y m3";
$lang['profilenotavailable'] = "pRof1Le no+ Av4IL@8LE.";
$lang['userprofileempty'] = "tH1s u\$ER H@5 n0+ PHIllED In +hEir PR0f1l3 0r It 15 set +O pRiv@+3.";

// Registration (register.php) -----------------------------------------

$lang['newuserregistrationsarenotpermitted'] = "s0RRy, nEw UsER R3G1s+R@+I0N\$ 4rE N0t 4LL0weD RiGh+ N0W. ple4\$3 Ch3ck B4ck LAtER.";
$lang['usernameinvalidchars'] = "uSeRN@mE c@n OnlY C0NT4in 4-z, 0-9, _ - CH@R4c+3Rs";
$lang['usernametooshort'] = "u5erN@me mUst b3 @ miNImUM oPh 2 cH4r4C+ers l0N9";
$lang['usernametoolong'] = "u5eRn4M3 muS+ 8E 4 M@X1MuM 0pH 15 cH4R4ctER\$ Lon9";
$lang['usernamerequired'] = "a l09On n4M3 1\$ rEqUIr3d";
$lang['passwdmustnotcontainHTML'] = "p45\$w0RD MUst noT c0Nta1n hTmL T@gs";
$lang['passwordinvalidchars'] = "p@5\$W0rD c4N 0nLY C0n+4In 4-z, 0-9, _ - cH4R4C+3Rs";
$lang['passwdtooshort'] = "pA\$\$w0rD mu\$+ bE 4 minIMUm oF 6 CH4r4C+3r5 l0n9";
$lang['passwdrequired'] = "a p@SSW0Rd 1\$ R3qU1r3D";
$lang['confirmationpasswdrequired'] = "a conF1RM@+i0n PAsswoRd Is r3QU1R3D";
$lang['nicknamerequired'] = "a N1Ckn4M3 I\$ rEqU1R3D";
$lang['emailrequired'] = "aN em4Il @DDr3SS I\$ R3qU1REd";
$lang['passwdsdonotmatch'] = "pA5\$words d0 N0+ Ma+CH";
$lang['usernamesameaspasswd'] = "uS3rn@mE @nd p@\$SW0rD mUSt 8e DifFeR3Nt";
$lang['usernameexists'] = "s0rry, 4 u\$Er W1+H tha+ n4M3 @Lre4Dy Exists";
$lang['successfullycreateduseraccount'] = "sUCce\$\$PhuLly CRE4TED Us3R ACC0unt";
$lang['useraccountcreatedconfirmfailed'] = "your u5Er 4CCOUNT H45 B33N crE4+3D 8uT +Eh rEqU1R3d C0NpHiRmAt1On 3M41L w@5 N0t senT. plE453 C0n+4C+ +hE ph0rum 0WN3R +0 R3ctiFY Th1\$. 1N +Hi\$ M34NTim3 Ple453 Cl1Ck +hE c0N+1nue Bu++0n to login in.";
$lang['useraccountcreatedconfirmsuccess'] = "y0Ur useR 4ccOUnT h4\$ BeEN CR3a+ED BU+ BepHORE J00 CAn s+@Rt po5+1N9 j00 mUst CONPh1rm Your EMa1l 4DDR3SS. pL34s3 cHECK YoUr 3M4Il F0R @ l1nk +h@t wiLl @llow j00 +0 C0Nphirm y0ur 4DDresS.";
$lang['useraccountcreated'] = "y0ur us3r @CCOUnt h4\$ b33N CR34tED SUCCESsFULlY! CL1ck teH C0N+INUE 8UTT0n b3L0W t0 l09In";
$lang['errorcreatinguserrecord'] = "errOR CrE4+1n9 U\$er rECOrd";
$lang['userregistration'] = "u5Er R39I\$TR4tioN";
$lang['registrationinformationrequired'] = "reGI\$+R4tION infOrm@+I0n (R3QuIreD)";
$lang['profileinformationoptional'] = "pr0file InF0Rm@+I0N (0pt10n4L)";
$lang['preferencesoptional'] = "pReph3rEnC3s (0P+1on4L)";
$lang['register'] = "r3g1\$+Er";
$lang['rememberpasswd'] = "remembEr p4s\$w0rD";
$lang['birthdayrequired'] = "y0ur DATE 0ph B1R+H i\$ REQUIr3D oR i\$ inv4l1d";
$lang['alwaysnotifymeofrepliestome'] = "n0T1fy on REplY +0 ME";
$lang['notifyonnewprivatemessage'] = "n0+ify on NEw pr1v4te ME\$S@93";
$lang['popuponnewprivatemessage'] = "p0p up 0N n3w pRiV4T3 m3sS493";
$lang['automatichighinterestonpost'] = "aU+om4TIC HiGh 1N+er3st 0n POS+";
$lang['confirmpassword'] = "coNphIrm p4\$\$w0RD";
$lang['invalidemailaddressformat'] = "iNV4L1D EM41l 4DDRess PH0Rm4+";
$lang['moreoptionsavailable'] = "m0r3 PRophil3 4nd Pr3FErENCE 0p+i0N\$ @RE 4v4IL4ble 0NCE j00 r39is+3r";
$lang['textcaptchaconfirmation'] = "c0nf1rmatioN";
$lang['textcaptchaexplain'] = "tO +eH r1GH+ Is 4 text-C@pTCH4 iM4GE. pL34SE TypE +HE C0de j00 c@N SEE In +3h IM@gE InTo t3h inpU+ f1elD bEl0w 1+.";
$lang['textcaptchaimgtip'] = "thi\$ i\$ 4 c@P+CHa-p1c+ure. IT I\$ usEd +0 PrEvENt 4UtOm@T1C R39is+r@tI0N";
$lang['textcaptchamissingkey'] = "a ConFirM@+i0N COD3 is rEQu1R3d.";
$lang['textcaptchaverificationfailed'] = "t3Xt-C4pTCh4 VERiFiC@+I0N cODE W45 inC0Rr3C+. Pl34s3 R3-eN+3r i+.";
$lang['forumrules'] = "foRUM rUlEs";
$lang['forumrulesnotification'] = "iN 0RdeR to pR0C3eD, j00 mUsT aGre3 W1+h +3H f0LL0win9 RUl3s";
$lang['forumrulescheckbox'] = "i h4VE reAd, anD 4Gr3e +0 A8IDE 8Y +hE F0Rum RulEs.";
$lang['youmustagreetotheforumrules'] = "j00 mu\$t 4gr3E +0 ThE f0ruM rUl3s 8ephorE j00 cAn C0nt1nU3.";

// Recent visitors list  (visitor_log.php) -----------------------------

$lang['member'] = "m3M83R";
$lang['searchforusernotinlist'] = "se@rCH pHor @ u\$3r n0t In li\$+";
$lang['yoursearchdidnotreturnanymatches'] = "y0UR s3@Rch D1D n0t R3tURn 4Ny m4+Ch3s. try \$impl1phy1n9 yOUr se4RCh p4r4m3ter5 @nd tRy 4G4in.";
$lang['hiderowswithemptyornullvalues'] = "h1de roW\$ W1+h eMP+y 0R NulL v@lUEs in sEL3ct3D C0lumNs";
$lang['showregisteredusersonly'] = "sH0w R3g1\$TER3D UsEr\$ 0nly (h1D3 guEsts)";

// Relationships (user_rel.php) ----------------------------------------

$lang['relationships'] = "rEL4+ionSH1P\$";
$lang['userrelationship'] = "user R3L4+i0n\$h1p";
$lang['userrelationships'] = "u5Er r3L4TioN\$H1ps";
$lang['failedtoremoveselectedrelationships'] = "f4Il3D +o r3M0V3 \$El3c+ED REL@+1On\$h1p";
$lang['friends'] = "fr1enDs";
$lang['ignoredcompletely'] = "i9N0rEd C0MPl3+ELY";
$lang['relationship'] = "relATIon\$HIp";
$lang['restorenickname'] = "re\$+ore usEr's nickNamE";
$lang['friend_exp'] = "u\$er'\$ p0St5 m@RKeD Wi+H @ &quot;friEND&quot; 1c0N.";
$lang['normal_exp'] = "user's p0\$+s @ppE4R as n0Rm4L.";
$lang['ignore_exp'] = "u5eR'S po5T\$ @r3 hiDden.";
$lang['ignore_completely_exp'] = "thR3adS 4Nd p0\$+s +o or pHr0m useR w1Ll 4PpE4R D3le+ED.";
$lang['display'] = "dispL@y";
$lang['displaysig_exp'] = "us3r'\$ s19n4+urE iS d1\$pl@yED 0N ThE1R p0STs.";
$lang['hidesig_exp'] = "u\$3r'\$ sIgNa+URE 1\$ HIDDEn oN tH31r p05+s.";
$lang['cannotignoremod'] = "j00 c@nno+ I9NOR3 +His u\$eR, 45 th3y ARE 4 moD3R4TOR.";
$lang['previewsignature'] = "pR3vi3w \$19natUr3";

// Search (search.php) -------------------------------------------------

$lang['searchresults'] = "se@rCH rE\$uLTs";
$lang['usernamenotfound'] = "the us3RN4m3 J00 spEC1fi3D 1N tH3 +0 0r pHR0m phi3Ld W@\$ n0T f0UND.";
$lang['notexttosearchfor'] = "oN3 or 4ll oPh y0uR \$e4RCH KEYw0rds w3RE 1nv4l1D. sE4RCh K3yw0rDs mUst 8E n0 ShoRtEr +h@n %d ch@R4CTER5, no L0N93r +han %d cH@R4C+Er\$ 4nD MUs+ not aPP34r IN +h3 %s";
$lang['keywordscontainingerrors'] = "k3YWOrd\$ c0N+@In1nG 3rrors: %s";
$lang['mysqlstopwordlist'] = "mY\$Ql sT0PWORd l1ST";
$lang['foundzeromatches'] = "fOund: 0 m4tchEs";
$lang['found'] = "f0uND";
$lang['matches'] = "m4TCHE\$";
$lang['prevpage'] = "previ0Us pa93";
$lang['findmore'] = "f1ND m0r3";
$lang['searchmessages'] = "se4rCh mE5\$a93S";
$lang['searchdiscussions'] = "s3ArCh D1\$CusSi0n\$";
$lang['find'] = "fInd";
$lang['additionalcriteria'] = "add1+ional CrI+ErI@";
$lang['searchbyuser'] = "se@rch 8y User (Opt1on@l)";
$lang['folderbrackets_s'] = "f0LD3R(\$)";
$lang['postedfrom'] = "p0st3D fr0m";
$lang['postedto'] = "pOs+3d +o";
$lang['today'] = "tod4y";
$lang['yesterday'] = "y3sTERD@y";
$lang['daybeforeyesterday'] = "d@y 83f0R3 y3St3RD@y";
$lang['weekago'] = "%s WEEK @g0";
$lang['weeksago'] = "%s we3K5 a90";
$lang['monthago'] = "%s Month 490";
$lang['monthsago'] = "%s M0N+H\$ @GO";
$lang['yearago'] = "%s YE4r @90";
$lang['beginningoftime'] = "be9innin9 0ph t1M3";
$lang['now'] = "now";
$lang['lastpostdate'] = "l4s+ Po\$+ D@+E";
$lang['numberofreplies'] = "nUm8er 0pH r3pli3s";
$lang['foldername'] = "foLDER N@ME";
$lang['authorname'] = "au+H0r n4me";
$lang['decendingorder'] = "new3s+ PhirS+";
$lang['ascendingorder'] = "oldeST ph1RS+";
$lang['keywords'] = "k3Yword5";
$lang['sortby'] = "soRt BY";
$lang['sortdir'] = "soRT DiR";
$lang['sortresults'] = "sOrt R3suL+\$";
$lang['groupbythread'] = "gRoup BY +HREAD";
$lang['postsfromuser'] = "p0STS fr0M u\$3r";
$lang['poststouser'] = "pOsts +o U\$3r";
$lang['poststoandfromuser'] = "p0st\$ To aND FRom uSEr";
$lang['searchfrequencyerror'] = "j00 C@n ONly \$3arcH 0ncE 3V3ry %s secoND\$. pl3453 +Ry 4941n l4+ER.";
$lang['searchsuccessfullycompleted'] = "sE4rCh sUCC3ssfullY COmplEtEd. %s";
$lang['clickheretoviewresults'] = "cL1Ck her3 +0 v1Ew r3sUlt5.";

// Search Popup (search_popup.php) -------------------------------------

$lang['select'] = "seLEC+";
$lang['searchforthread'] = "seARCH F0R tHrE4d";
$lang['mustspecifytypeofsearch'] = "j00 mU5T sp3C1pHY +ypE 0f \$E4rch To P3Rf0Rm";
$lang['unkownsearchtypespecified'] = "uNkn0Wn \$e4rCh +Yp3 \$p3C1fiEd";
$lang['mustentersomethingtosearchfor'] = "j00 muS+ 3NTER \$0m3+H1Ng +0 SE4RCh f0R";

// Start page (start_left.php) -----------------------------------------

$lang['recentthreads'] = "r3c3nt thR3AD\$";
$lang['startreading'] = "sT@rt r34din9";
$lang['threadoptions'] = "tHR3aD 0P+1onS";
$lang['editthreadoptions'] = "edI+ +hr34d OP+1on\$";
$lang['morevisitors'] = "morE v1SI+0rS";
$lang['forthcomingbirthdays'] = "f0RthCOmIN9 81R+hd@Y\$";

// Start page (start_main.php) -----------------------------------------

$lang['editstartpage_help'] = "j00 c4N 3d1+ thi\$ P4g3 fr0m THE 4dmin 1n+3Rf4c3";
$lang['uploadstartpage'] = "uPLo4D \$T4rt p49E (%s)";
$lang['invalidfiletypeerror'] = "fiL3 Typ3 N0+ suppOrtED. j00 C@n 0NLY us3 %s fil3S @\$ YOUR \$+4rt p@g3.";

// Thread navigation (thread_list.php) ---------------------------------

$lang['newdiscussion'] = "n3w D1\$cuss1On";
$lang['createpoll'] = "cr3@+e poll";
$lang['search'] = "s3@RCH";
$lang['searchagain'] = "searCh 49@1N";
$lang['alldiscussions'] = "aLl DiscU\$sion5";
$lang['unreaddiscussions'] = "unr3@D DIsCu\$si0N5";
$lang['unreadtome'] = "unRE@D &quot;t0: ME&quot;";
$lang['todaysdiscussions'] = "tOd@y'\$ d1SCusS1on\$";
$lang['2daysback'] = "2 d4ys 8ACK";
$lang['7daysback'] = "7 days 84ck";
$lang['highinterest'] = "h19h 1N+3REs+";
$lang['unreadhighinterest'] = "unr34D h19H in+3REst";
$lang['iverecentlyseen'] = "i'v3 R3C3ntlY \$E3n";
$lang['iveignored'] = "i'v3 19norED";
$lang['byignoredusers'] = "bY 19NOrED USEr\$";
$lang['ivesubscribedto'] = "i've \$U8scrI8Ed +o";
$lang['startedbyfriend'] = "s+4r+eD 8Y Fr1enD";
$lang['unreadstartedbyfriend'] = "unR3@d sTD 8y pHr1end";
$lang['startedbyme'] = "sT4Rt3d by mE";
$lang['unreadtoday'] = "uNr3aD +0d4Y";
$lang['deletedthreads'] = "d3l3teD +hR34d\$";
$lang['goexcmark'] = "g0!";
$lang['folderinterest'] = "fOLDER iNtEREs+";
$lang['postnew'] = "pO5+ nEw";
$lang['currentthread'] = "cUrrent +hR3@D";
$lang['highinterest'] = "h1gh iNtEr3s+";
$lang['markasread'] = "m4RK 4\$ re4D";
$lang['next50discussions'] = "n3X+ 50 di\$CUsSI0N5";
$lang['visiblediscussions'] = "v1\$1Ble DIsCUsSi0n\$";
$lang['selectedfolder'] = "s3leCtED phOlder";
$lang['navigate'] = "n4V1ga+e";
$lang['couldnotretrievefolderinformation'] = "ther3 Ar3 n0 phOlDEr5 aV4ila8lE.";
$lang['nomessagesinthiscategory'] = "nO mEss4g3s 1N ThIs c4tE90RY. PlE4\$e \$3LECT 4no+h3R, or %s f0R 4lL THre4Ds";
$lang['clickhere'] = "cl1cK HEr3";
$lang['prev50threads'] = "pr3v10us 50 thre@D5";
$lang['next50threads'] = "n3x+ 50 +hr3ADs";
$lang['nextxthreads'] = "nEXt %s +hre4DS";
$lang['threadstartedbytooltip'] = "thr34d #%s st4RTED 8Y %s. v1EWED %s";
$lang['threadviewedonetime'] = "1 T1mE";
$lang['threadviewedtimes'] = "%d tIMEs";
$lang['unreadthread'] = "uNre4d tHrE4D";
$lang['readthread'] = "r3@d +hr34D";
$lang['unreadmessages'] = "uNr3aD m3SSaGes";
$lang['subscribed'] = "su8scR1B3d";
$lang['ignorethisfolder'] = "i9N0re tH1\$ F0ldeR";
$lang['stopignoringthisfolder'] = "s+Op i9nor1N9 thi\$ Ph0LdeR";
$lang['stickythreads'] = "sT1ckY +Hr3@DS";
$lang['mostunreadposts'] = "mOST UnR3aD pOsT5";
$lang['onenew'] = "%d new";
$lang['manynew'] = "%d NEW";
$lang['onenewoflength'] = "%d nEW 0F %d";
$lang['manynewoflength'] = "%d new 0Ph %d";
$lang['ignorefolderconfirm'] = "aR3 j00 sur3 J00 w4nt t0 1Gnor3 tHI\$ phold3R?";
$lang['unignorefolderconfirm'] = "ar3 j00 Sur3 j00 W4NT +0 5ToP igN0R1N9 ThiS pHoLDER?";
$lang['confirmmarkasread'] = "aRE j00 sur3 J00 W4n+ +0 Mark +hE 5ElEC+3D ThRE4Ds 45 rE4d?";
$lang['successfullymarkreadselectedthreads'] = "sUcc3SSFullY M4RK3D \$3leC+3D THR3@DS 4s RE4d";
$lang['failedtomarkselectedthreadsasread'] = "f4IL3d +0 mArK \$3l3c+Ed tHRE4d\$ as r34D";
$lang['gotofirstpostinthread'] = "go +o ph1r5+ po\$+ in tHrE4d";
$lang['gotolastpostinthread'] = "gO +0 L4\$+ Po\$+ In tHRe4D";
$lang['viewmessagesinthisfolderonly'] = "v13w mESS493S 1n thI\$ PholDER 0NlY";
$lang['shownext50threads'] = "shOW n3X+ 50 +Hr34D\$";
$lang['showprev50threads'] = "sh0w pRevi0uS 50 THre4D5";
$lang['createnewdiscussioninthisfolder'] = "cR3@t3 nEw d1ScUs\$10N 1N +h1\$ ph0ld3R";
$lang['nomessages'] = "no MEs549Es";

// HTML toolbar (htmltools.inc.php) ------------------------------------
$lang['bold'] = "b0ld";
$lang['italic'] = "iT@liC";
$lang['underline'] = "underl1N3";
$lang['strikethrough'] = "sTRIk3+Hrou9H";
$lang['superscript'] = "suP3R\$crIpt";
$lang['subscript'] = "sU8\$crip+";
$lang['leftalign'] = "l3Ft-4l1Gn";
$lang['center'] = "cenTEr";
$lang['rightalign'] = "riGh+-aLigN";
$lang['numberedlist'] = "nUMb3rEd l1\$+";
$lang['list'] = "lIST";
$lang['indenttext'] = "iNd3N+ t3xt";
$lang['code'] = "c0De";
$lang['quote'] = "qUot3";
$lang['spoiler'] = "sPOIL3R";
$lang['horizontalrule'] = "h0riZON+4l RUl3";
$lang['image'] = "iM493";
$lang['hyperlink'] = "hYperl1Nk";
$lang['noemoticons'] = "d1\$4BlE 3Mo+iC0n5";
$lang['fontface'] = "f0NT phaC3";
$lang['size'] = "siz3";
$lang['colour'] = "coLour";
$lang['red'] = "r3d";
$lang['orange'] = "oR4ng3";
$lang['yellow'] = "yellow";
$lang['green'] = "gR3En";
$lang['blue'] = "bLue";
$lang['indigo'] = "iNd1gO";
$lang['violet'] = "v1olET";
$lang['white'] = "wh1+3";
$lang['black'] = "bl4Ck";
$lang['grey'] = "gr3Y";
$lang['pink'] = "pINk";
$lang['lightgreen'] = "li9H+ gr33n";
$lang['lightblue'] = "li9ht BLuE";

// Forum Stats (messages.inc.php - messages_forum_stats()) -------------

$lang['forumstats'] = "f0RUm 5+@+s";
$lang['usersactiveinthepasttimeperiod'] = "%s AC+1v3 iN +h3 P@\$T %s.";

$lang['numactiveguests'] = "<b>%s</b> 9ueS+S";
$lang['oneactiveguest'] = "<b>1</b> GU3\$+";
$lang['numactivemembers'] = "<b>%s</b> m3MBEr\$";
$lang['oneactivemember'] = "<b>1</b> M3MBER";
$lang['numactiveanonymousmembers'] = "<b>%s</b> 4NonYMoUs M3mB3rs";
$lang['oneactiveanonymousmember'] = "<b>1</b> 4NOnymoU5 memBER";

$lang['numthreadscreated'] = "<b>%s</b> +hr34D\$";
$lang['onethreadcreated'] = "<b>1</b> thr3AD";
$lang['numpostscreated'] = "<b>%s</b> Po5+s";
$lang['onepostcreated'] = "<b>1</b> P0St";

$lang['younormal'] = "j00";
$lang['youinvisible'] = "j00 (iNvI\$I8l3)";
$lang['viewcompletelist'] = "v13w COmpL3T3 lIST";
$lang['ourmembershavemadeatotalofnumthreadsandnumposts'] = "ouR m3mB3r\$ H@v3 M4D3 @ +O+@L 0F %s 4nD %s.";
$lang['longestthreadisthreadnamewithnumposts'] = "lon93\$+ thrE4d 1s <b>%s</b> w1tH %s.";
$lang['therehavebeenxpostsmadeinthelastsixtyminutes'] = "ther3 h4V3 8e3N <b>%s</b> P0s+5 m@D3 IN t3H L@\$t 60 mInU+Es.";
$lang['therehasbeenonepostmadeinthelastsxityminutes'] = "ther3 h4S B33N <b>1</b> P0\$t M@D3 iN +h3 L@\$+ 60 M1nU+3s.";
$lang['mostpostsevermadeinasinglesixtyminuteperiodwasnumposts'] = "m0s+ p0S+5 3Ver m@D3 1n @ \$iNGL3 60 m1NUtE P3ri0d i5 <b>%s</b> ON %s.";
$lang['wehavenumregisteredmembersandthenewestmemberismembername'] = "we HavE <b>%s</b> R3915+ER3D mEm8ers and th3 newE\$t mEmB3r i\$ <b>%s</b>.";
$lang['wehavenumregisteredmember'] = "wE H@v3 %s r39i\$tEr3D mEm8er5.";
$lang['wehaveoneregisteredmember'] = "w3 h@v3 0N3 REGi5+Er3d mEM8er.";
$lang['mostuserseveronlinewasnumondate'] = "m0\$t users eV3r 0NL1n3 w4s <b>%s</b> 0n %s.";
$lang['statsdisplayenabled'] = "s+4+s DisplAy 3n4Bl3d";

// Thread Options (thread_options.php) ---------------------------------

$lang['updatessavedsuccessfully'] = "uPd4+e\$ s@ved \$uCcE\$SFULLy";
$lang['useroptions'] = "us3r Op+i0ns";
$lang['markedasread'] = "m4RkED @5 re@D";
$lang['postsoutof'] = "p05+s 0U+ 0Ph";
$lang['interest'] = "iN+EREst";
$lang['closedforposting'] = "closeD ph0R Po5+Ing";
$lang['locktitleandfolder'] = "lOCK ti+l3 4nd f0LD3r";
$lang['deletepostsinthreadbyuser'] = "deLEt3 P05+S 1N Thre4d BY usEr";
$lang['deletethread'] = "d3L3TE thREAD";
$lang['permenantlydelete'] = "pErm@n3NTLy D3lE+3";
$lang['movetodeleteditems'] = "mov3 to del3TED +hr3aDs";
$lang['undeletethread'] = "unDELE+3 +Hr3ad";
$lang['threaddeletedpermenantly'] = "threaD D3L3+ED pERm4n3n+Ly. c@Nn0+ UnDEL3te.";
$lang['markasunread'] = "m4Rk @s unre4d";
$lang['makethreadsticky'] = "m4K3 +Hr34D sTICKy";
$lang['threareadstatusupdated'] = "thr3aD r3AD s+4tuS UpD4+3d SuCc3ssphUlly";
$lang['interestupdated'] = "thREaD iNtERe\$t st4+us Upd4teD sUCC3SsfULlY";
$lang['failedtoupdatethreadreadstatus'] = "f4Il3D +0 UpD@+3 thr34D R3@D stAtu5";
$lang['failedtoupdatethreadinterest'] = "f4Il3d +0 Upd4+e +Hr34D inTER3ST";
$lang['failedtorenamethread'] = "f41l3D t0 REN@mE ThREad";
$lang['failedtomovethread'] = "f4Il3D t0 m0V3 THR3aD to \$PECIFI3d folDeR";
$lang['failedtoupdatethreadstickystatus'] = "f41l3d +0 updaTE +hR34d stiCkY s+@+U\$";
$lang['failedtoupdatethreadclosedstatus'] = "f41lED +o Upd4+e +Hr34d cloSED \$+@+U\$";
$lang['failedtoupdatethreadlockstatus'] = "f4il3D +0 UpD4t3 +hR34d L0ck sta+U5";
$lang['failedtodeletepostsbyuser'] = "f41leD to DEl3te pO\$+\$ 8y 53L3c+3D U\$ER";
$lang['failedtodeletethread'] = "f41L3d +0 DelEtE +hREAd.";
$lang['failedtoundeletethread'] = "f4iL3d +o Un-DEL3t3 +hR34d";

// Dictionary (dictionary.php) -----------------------------------------

$lang['dictionary'] = "dict10n4rY";
$lang['spellcheck'] = "sPell ch3cK";
$lang['notindictionary'] = "not 1N Dic+10nary";
$lang['changeto'] = "cHAN9e +0";
$lang['restartspellcheck'] = "rES+@r+";
$lang['cancelchanges'] = "c4ncEl ch4N9Es";
$lang['initialisingdotdotdot'] = "ini+1@li\$INg...";
$lang['spellcheckcomplete'] = "sP3ll chEck 15 C0mPlEtE. +0 r3ST4RT sPElL CH3CK CLICK r3s+4r+ 8UTTon 83LOw.";
$lang['spellcheck'] = "sP3ll ch3CK";
$lang['noformobj'] = "n0 PH0rm 0bj3C+ \$p3C1f13d f0r r3+urn t3XT";
$lang['bodytext'] = "b0dY +ext";
$lang['ignore'] = "iGn0rE";
$lang['ignoreall'] = "ign0re @ll";
$lang['change'] = "ch4ngE";
$lang['changeall'] = "ch@n9E 4Ll";
$lang['add'] = "adD";
$lang['suggest'] = "sU99est";
$lang['nosuggestions'] = "(No \$U993ST10n5)";
$lang['cancel'] = "c4ncEl";
$lang['dictionarynotinstalled'] = "n0 dIC+10nARy has b33N 1Ns+@LleD. Pl34SE C0nt4CT thE ph0RUM 0wN3R to REMEDY tH1\$.";

// Permissions keys ----------------------------------------------------

$lang['postreadingallowed'] = "po5+ r34D1ng @lLow3d";
$lang['postcreationallowed'] = "p0S+ CR3At10N 4LL0w3D";
$lang['threadcreationallowed'] = "tHRE4d CrEa+1oN @lloWeD";
$lang['posteditingallowed'] = "poS+ 3d1+in9 @LLow3D";
$lang['postdeletionallowed'] = "p0St DeL3t10N 4ll0W3D";
$lang['attachmentsallowed'] = "aT+4CHMents 4lL0wED";
$lang['htmlpostingallowed'] = "hTml p0\$+1nG alLow3d";
$lang['signatureallowed'] = "s1gn4tur3 4ll0W3d";
$lang['guestaccessallowed'] = "gueST 4cCE5\$ @lLow3d";
$lang['postapprovalrequired'] = "pO5+ 4ppr0v4l REQuIr3D";

// RSS feeds gubbins

$lang['rssfeed'] = "rs5 ph3ed";
$lang['every30mins'] = "ev3rY 30 minUTE\$";
$lang['onceanhour'] = "oNcE @n H0ur";
$lang['every6hours'] = "eVeRY 6 h0Urs";
$lang['every12hours'] = "eVery 12 Hours";
$lang['onceaday'] = "oNCe a Day";
$lang['rssfeeds'] = "rs\$ f3Eds";
$lang['feedname'] = "feed n@m3";
$lang['feedfoldername'] = "fE3d FolDEr N@mE";
$lang['feedlocation'] = "fE3d L0C@Tion";
$lang['threadtitleprefix'] = "tHR3AD +1+L3 pREpH1x";
$lang['feednameandlocation'] = "fE3D n4mE 4ND LoC@+I0N";
$lang['feedsettings'] = "f3ed seTTingS";
$lang['updatefrequency'] = "update fR3QUeNCY";
$lang['rssclicktoreadarticle'] = "clICK her3 to rE4d th15 @rt1CLE";
$lang['addnewfeed'] = "add NEw pHE3d";
$lang['editfeed'] = "ed1+ fe3d";
$lang['feeduseraccount'] = "fE3d u\$3r 4CCOUnT";
$lang['noexistingfeeds'] = "n0 3xi\$+1ng Rss f33d\$ Ph0uND. t0 @dd 4 phe3d CLiCK thE '@Dd n3W' 8utt0N 8eLOW";
$lang['rssfeedhelp'] = "hER3 j00 C4N s3tUp SomE rs\$ PHE3DS pHor aU+0m@TiC proPa9@+1oN 1n+0 Your ph0rum. thE i+3Ms Fr0m +EH rss ph3eD\$ J00 4dD Will 8e crE@TeD 4s +hR34D\$ whiCh u\$er5 C4N rEPly t0 4\$ IPh +H3Y w3RE n0rm4L p0\$+5. Th3 r\$s ph3ED MUsT B3 @Cc3\$\$1BL3 v1@ h+tp oR 1+ w1ll n0t W0rK.";
$lang['mustspecifyrssfeedname'] = "mU5+ sp3cIfy rSS f3ed n4mE";
$lang['mustspecifyrssfeeduseraccount'] = "mU5T sP3ciPhy r\$s f33D us3R 4cc0UNT";
$lang['mustspecifyrssfeedfolder'] = "mu5t SpECify rss f3ed f0LDeR";
$lang['mustspecifyrssfeedurl'] = "mu\$t speCIpHy R\$S PH3ED URl";
$lang['mustspecifyrssfeedupdatefrequency'] = "mUst sP3C1pHy Rss feED UPD4te fR3qUENCY";
$lang['unknownrssuseraccount'] = "uNKnOWn rss u53r @CC0unt";
$lang['rssfeedsupportshttpurlsonly'] = "rsS FE3D \$upp0rt5 h++P UrLs 0nly. 53cur3 PH3ed\$ (h++p\$://) @rE n0t \$upP0rt3D.";
$lang['rssfeedurlformatinvalid'] = "rs\$ fe3d URL f0rM@t 1\$ inv4LID. url MUs+ 1NClUDE \$CHEme (e.9. h++p://) 4nD 4 Hos+NAme (e.9. www.H0S+N4m3.C0M).";
$lang['rssfeeduserauthentication'] = "r\$\$ Ph33d Doe5 N0t 5Upp0rt h+tP U53R @UthENt1c4+I0n";
$lang['successfullyremovedselectedfeeds'] = "succESSPHULly rEmOvEd \$el3C+ED PH33Ds";
$lang['successfullyaddedfeed'] = "sucCes5phULlY 4DDED n3w FE3d";
$lang['successfullyeditedfeed'] = "sucC3ssFUlLy 3Dited fE3D";
$lang['failedtoremovefeeds'] = "f4IL3D +0 rEmovE Some OR 4ll oPh Teh seL3cTeD F33Ds";
$lang['failedtoaddnewrssfeed'] = "f4IleD t0 @DD NEW rSs phe3D";
$lang['failedtoupdaterssfeed'] = "fAILeD +0 upD@+3 r\$S f33D";
$lang['rssstreamworkingcorrectly'] = "r5S \$TR34m 4Ppe4RS t0 b3 W0rkInG coRr3c+ly";
$lang['rssstreamnotworkingcorrectly'] = "r\$S s+r34m was 3MPty oR COULD no+ 8e f0uNd";
$lang['invalidfeedidorfeednotfound'] = "inv4L1D f3ED 1d oR f3Ed n0+ PH0UnD";

// PM Export Options

$lang['pmexportastype'] = "exP0Rt @s +ype";
$lang['pmexporthtml'] = "h+mL";
$lang['pmexportxml'] = "xMl";
$lang['pmexportplaintext'] = "pL4in tEx+";
$lang['pmexportmessagesas'] = "eXP0rt mE\$s@9e\$ 4s";
$lang['pmexportonefileforallmessages'] = "oNE pH1Le F0r 4lL M3Ss49ES";
$lang['pmexportonefilepermessage'] = "on3 ph1LE p3r m3ssA93";
$lang['pmexportattachments'] = "eXPOr+ 4+t4chM3NTs";
$lang['pmexportincludestyle'] = "iNCLuD3 F0RUm s+yl3 \$hEET";
$lang['pmexportwordfilter'] = "apPly word f1l+3r T0 m3s\$@g3S";

// Thread merge / split options

$lang['threadhasbeensplit'] = "thR3@D h45 B3en SPL1+";
$lang['threadhasbeenmerged'] = "thrEAD h@\$ B3en mErg3d";
$lang['mergesplitthread'] = "m3RgE / spl1+ +hrEad";
$lang['mergewiththreadid'] = "m3Rg3 W1th +HRE4d id:";
$lang['postsinthisthreadatstart'] = "pOs+\$ in +h15 +hR34D At st4Rt";
$lang['postsinthisthreadatend'] = "p0sT\$ in +h15 +hr3@D at END";
$lang['reorderpostsintodateorder'] = "rE-ord3r pos+s in+0 DatE 0rdEr";
$lang['splitthreadatpost'] = "sPl1+ +hrE4d @+ p0\$+:";
$lang['selectedpostsandrepliesonly'] = "sel3c+Ed po\$+ @nD REPlie\$ 0Nly";
$lang['selectedandallfollowingposts'] = "sEleCT3D @nD @lL ph0lL0w1nG po\$TS";

$lang['threadmovedhere'] = "hErE";

$lang['thisthreadhasmoved'] = "<b>tHR34DS M3R9ed:</b> +h1s tHrEad H4S moved %s";
$lang['thisthreadwasmergedfrom'] = "<b>tHrEADs merG3D:</b> +h1\$ +hR3AD W45 mergED pHroM %s";
$lang['somepostsinthisthreadhavebeenmoved'] = "<b>thrE@D split:</b> S0m3 po\$+S in tHis thre4d h4V3 8eEn movED %s";
$lang['somepostsinthisthreadweremovedfrom'] = "<b>tHrEAd \$Pli+:</b> s0me p0sts 1N +h1s +hrEad w3rE mov3D Fr0m %s";

$lang['thisposthasbeenmoved'] = "<b>thRE4D spli+:</b> Th1S post h4\$ B33n M0VED %s";

$lang['invalidfunctionarguments'] = "iNv@l1d PhUnCt1ON 4rGUM3nts";
$lang['couldnotretrieveforumdata'] = "cOulD n0+ retr13ve F0RUm D4+@";
$lang['cannotmergepolls'] = "oN3 OR m0rE thr34d5 I\$ @ pOLl. J00 c@nn0+ mergE pOll5";
$lang['couldnotretrievethreaddatamerge'] = "c0ulD No+ r3tr13VE +hr3ad d4T@ Phrom oNE 0r m0R3 +Hr34D\$";
$lang['couldnotretrievethreaddatasplit'] = "c0ulD no+ R3+r1evE +Hr34D D4t4 Fr0m 5OURcE +hr34D";
$lang['couldnotretrievepostdatamerge'] = "c0uld N0T REtriEve Post D@t4 fr0m 0N3 0r M0re +hr34d\$";
$lang['couldnotretrievepostdatasplit'] = "c0uld No+ rEtRIEVE pO5+ Da+4 Fr0M \$0urC3 +hR34d";
$lang['failedtocreatenewthreadformerge'] = "f4IlED +o Cr3a+e NEW thrEaD f0r mErG3";
$lang['failedtocreatenewthreadforsplit'] = "f41leD +o cr34+e neW +hr34d phor sPLi+";

// Thread subscriptions

$lang['threadsubscriptions'] = "tHrE4d subsCR1p+10n5";
$lang['couldnotupdateinterestonthread'] = "c0UlD n0t uPD@+e 1NTEr35t 0n tHr3AD '%s'";
$lang['threadinterestsupdatedsuccessfully'] = "tHr3ad In+er3Sts UPDateD \$ucCEssphUlLy";
$lang['nothreadsubscriptions'] = "j00 4rE noT su8\$crIB3D +0 Any +HrE@D5.";
$lang['resetselected'] = "r3se+ \$3leC+3D";
$lang['allthreadtypes'] = "alL thrE4D Type5";
$lang['ignoredthreads'] = "i9n0r3D +hR3AdS";
$lang['highinterestthreads'] = "hI9H IN+er3\$+ THrE4d\$";
$lang['subscribedthreads'] = "sUBScr18ED +hr34Ds";
$lang['currentinterest'] = "cUrrent 1N+3REst";

// Browseable user profiles

$lang['youcanonlyaddthreecolumns'] = "j00 c@n onlY @DD 3 c0luMN5. tO AdD 4 n3w cOlumn Cl0sE 4n exI\$+ing 0NE";
$lang['columnalreadyadded'] = "j00 h4ve @LRe4dy 4DDED +his C0lumN. if j00 w4N+ +o rEm0ve it Click I+'s Cl053 8Utt0N";

?>
