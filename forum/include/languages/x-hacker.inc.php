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

/* $Id: x-hacker.inc.php,v 1.232 2007-05-02 23:49:00 decoyduck Exp $ */

// International English language file

// Language character set and text direction options -------------------

$lang['_isocode'] = "en";
$lang['_textdir'] = "ltr";

// Months --------------------------------------------------------------

$lang['month'][1]  = "j4Nu4RY";
$lang['month'][2]  = "f38ru@ry";
$lang['month'][3]  = "m4RCh";
$lang['month'][4]  = "aPR1L";
$lang['month'][5]  = "m4Y";
$lang['month'][6]  = "juNE";
$lang['month'][7]  = "julY";
$lang['month'][8]  = "augusT";
$lang['month'][9]  = "s3PT3mb3R";
$lang['month'][10] = "oc+083r";
$lang['month'][11] = "nOV3mber";
$lang['month'][12] = "d3C3MB3R";

$lang['month_short'][1]  = "j@n";
$lang['month_short'][2]  = "feb";
$lang['month_short'][3]  = "m4r";
$lang['month_short'][4]  = "aPR";
$lang['month_short'][5]  = "m4Y";
$lang['month_short'][6]  = "jUN";
$lang['month_short'][7]  = "juL";
$lang['month_short'][8]  = "aUG";
$lang['month_short'][9]  = "sEP";
$lang['month_short'][10] = "oCt";
$lang['month_short'][11] = "nOv";
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

$lang['date_periods']['year']   = "%s y34r";
$lang['date_periods']['month']  = "%s m0N+H";
$lang['date_periods']['week']   = "%s w33k";
$lang['date_periods']['day']    = "%s d4y";
$lang['date_periods']['hour']   = "%s H0UR";
$lang['date_periods']['minute'] = "%s M1Nut3";
$lang['date_periods']['second'] = "%s 5ec0nd";

// As above but plurals (2 years vs. 1 year, etc.)

$lang['date_periods_plural']['year']   = "%s YEaRs";
$lang['date_periods_plural']['month']  = "%s mON+hs";
$lang['date_periods_plural']['week']   = "%s W33kS";
$lang['date_periods_plural']['day']    = "%s D4Y\$";
$lang['date_periods_plural']['hour']   = "%s H0ur\$";
$lang['date_periods_plural']['minute'] = "%s m1nUteS";
$lang['date_periods_plural']['second'] = "%s \$3C0ndS";

// Short hand periods (example: 1y, 2m, 3w, 4d, 5hr, 6min, 7sec)

$lang['date_periods_short']['year']   = "%sy";    // 1y
$lang['date_periods_short']['month']  = "%sM";    // 2m
$lang['date_periods_short']['week']   = "%sw";    // 3w
$lang['date_periods_short']['day']    = "%sd";    // 4d
$lang['date_periods_short']['hour']   = "%sHR";   // 5hr
$lang['date_periods_short']['minute'] = "%smin";  // 6min
$lang['date_periods_short']['second'] = "%sSEc";  // 7sec

// Common words --------------------------------------------------------

$lang['percent'] = "pERceNt";
$lang['average'] = "av3R4ge";
$lang['approve'] = "apPROve";
$lang['banned'] = "b4nN3d";
$lang['locked'] = "l0ck3D";
$lang['add'] = "add";
$lang['advanced'] = "adV4nc3d";
$lang['active'] = "ac+IVe";
$lang['style'] = "style";
$lang['go'] = "g0";
$lang['folder'] = "folder";
$lang['ignoredfolder'] = "i9nor3d ph0LdeR";
$lang['folders'] = "f0Ld3rs";
$lang['thread'] = "thR34d";
$lang['threads'] = "tHR34D5";
$lang['threadlist'] = "thr34d l15+";
$lang['message'] = "m3\$S4GE";
$lang['messagenumber'] = "m3s\$49E nuM83r";
$lang['from'] = "fr0m";
$lang['to'] = "tO";
$lang['all_caps'] = "alL";
$lang['of'] = "oph";
$lang['reply'] = "rEply";
$lang['forward'] = "f0rw@rd";
$lang['replyall'] = "rEPLY +o 4ll";
$lang['pm_reply'] = "rEpLy @S pm";
$lang['delete'] = "del3te";
$lang['deleted'] = "deleted";
$lang['edit'] = "ed1+";
$lang['privileges'] = "prIvilege5";
$lang['ignore'] = "i9n0RE";
$lang['normal'] = "nORM@L";
$lang['interested'] = "in+ERESted";
$lang['subscribe'] = "sUBScR1BE";
$lang['apply'] = "aPPlY";
$lang['submit'] = "su8M1T";
$lang['download'] = "d0WNl04D";
$lang['save'] = "sAVE";
$lang['update'] = "upD4+e";
$lang['cancel'] = "c@ncel";
$lang['retry'] = "re+ry";
$lang['continue'] = "cOn+Inue";
$lang['attachment'] = "a+T4chment";
$lang['attachments'] = "att4chm3NtS";
$lang['imageattachments'] = "iM4GE 4++@chm3ntS";
$lang['filename'] = "f1lEn4m3";
$lang['dimensions'] = "diMEnsi0N5";
$lang['downloadedxtimes'] = "dOWNlO4ded: %d t1mes";
$lang['downloadedonetime'] = "dOWNLoad3D: 1 +1M3";
$lang['size'] = "sIZe";
$lang['viewmessage'] = "vI3w Me\$s49e";
$lang['deletethumbnails'] = "delete tHUmbn41l5";
$lang['logon'] = "lOG0N";
$lang['more'] = "mOr3";
$lang['recentvisitors'] = "r3CEnt v151+0Rs";
$lang['username'] = "u\$Ern@me";
$lang['clear'] = "cle@r";
$lang['action'] = "acti0n";
$lang['unknown'] = "unkn0Wn";
$lang['none'] = "n0NE";
$lang['preview'] = "pReV1ew";
$lang['post'] = "pO5T";
$lang['posts'] = "p05tS";
$lang['change'] = "cH@Nge";
$lang['yes'] = "ye5";
$lang['no'] = "n0";
$lang['signature'] = "s19N4+Ur3";
$lang['signaturepreview'] = "s1gN4+URe pr3v13w";
$lang['signatureupdated'] = "s1Gn4ture upda+ed";
$lang['back'] = "b4CK";
$lang['subject'] = "sUBj3ct";
$lang['close'] = "cl0\$e";
$lang['name'] = "nAM3";
$lang['description'] = "d3sCrIp+I0N";
$lang['date'] = "d4+E";
$lang['view'] = "vi3W";
$lang['enterpasswd'] = "enT3R p4\$sw0rd";
$lang['passwd'] = "p4SSwoRD";
$lang['ignored'] = "igN0r3d";
$lang['guest'] = "gU35+";
$lang['next'] = "n3x+";
$lang['prev'] = "pR3V1oUS";
$lang['others'] = "oTH3rS";
$lang['nickname'] = "nicKn4M3";
$lang['emailaddress'] = "eM@1L 4DDREs5";
$lang['confirm'] = "cONPhirm";
$lang['email'] = "em4il";
$lang['poll'] = "p0Ll";
$lang['friend'] = "friend";
$lang['error'] = "eRROr";
$lang['guesterror'] = "soRry, J00 ne3d +0 83 Lo9ged 1n t0 U\$e th15 phe4+uR3.";
$lang['loginnow'] = "l0g1n n0w";
$lang['on'] = "oN";
$lang['unread'] = "uNR34D";
$lang['all'] = "all";
$lang['allcaps'] = "alL";
$lang['permissions'] = "p3rM1S\$10n\$";
$lang['type'] = "tyP3";
$lang['print'] = "pRIn+";
$lang['sticky'] = "s+1cKy";
$lang['polls'] = "poLLs";
$lang['user'] = "u5er";
$lang['enabled'] = "eN48l3D";
$lang['disabled'] = "dIS48Led";
$lang['options'] = "oP+i0N\$";
$lang['emoticons'] = "eM0+icon5";
$lang['webtag'] = "w3BT4g";
$lang['makedefault'] = "m4ke d3F4Ul+";
$lang['unsetdefault'] = "uN\$Et dePH4Ult";
$lang['rename'] = "rEN@M3";
$lang['pages'] = "p@G3S";
$lang['used'] = "u\$ed";
$lang['days'] = "d4Ys";
$lang['usage'] = "us4ge";
$lang['show'] = "sH0w";
$lang['hint'] = "hINT";
$lang['new'] = "new";
$lang['referer'] = "rEph3R3r";

// Admin interface (admin*.php) ----------------------------------------

$lang['admintools'] = "aDMin tO0lS";
$lang['forummanagement'] = "f0rUm m@n49em3nT";
$lang['accessdeniedexp'] = "j00 d0 n0+ hAv3 perm15SI0n +0 use th1S sectiOn.";
$lang['managefolders'] = "m@N@G3 F0ld3r5";
$lang['manageforums'] = "mAN@gE PHorumS";
$lang['manageforumpermissions'] = "m@N49e ph0rum p3Rm15S1oN5";
$lang['foldername'] = "f0LDer NAm3";
$lang['move'] = "mOVe";
$lang['closed'] = "cLO\$3D";
$lang['open'] = "op3n";
$lang['restricted'] = "r35tRict3d";
$lang['iscurrentlyclosed'] = "is curr3n+lY CLo\$3d";
$lang['youdonothaveaccessto'] = "j00 D0 N0+ H4V3 4cces5 +O";
$lang['toapplyforaccessplease'] = "to 4pply PHor @cce5s pleas3 con+@C+ +3H phorUm 0wn3r.";
$lang['adminforumclosedtip'] = "iPh j00 W@n+ +o ch4n9e \$0Me sett1Ng\$ 0n YoUR phoRum clIck tHE 4dMin L1Nk iN +H3 N4vig@tI0N b4R 48Ov3.";
$lang['newfolder'] = "new F0ld3R";
$lang['forumadmin'] = "f0RUM ADm1N";
$lang['adminexp_1'] = "u\$e Teh m3Nu On +h3 LEphT tO m@N@g3 +HiN9s 1n yOuR PH0rum.";
$lang['adminexp_2'] = "<b>uSerS</b> 4LlOW5 j00 +o \$et 1NdivIdU4l U5eR peRm1S\$i0N\$, iNclUd1Ng 4PP01Nt1ng 3D1+0R\$ 4Nd G@9GING PE0Pl3.";
$lang['adminexp_3'] = "<b>uSER gr0Up\$</b> 4lL0w\$ J00 +0 cre4+3 UsEr Gr0UpS T0 @ss1gn pErmI5510ns +0 4S M@nY 0r 4\$ ph3w U5eR5 quicklY @nd ea\$1LY.";
$lang['adminexp_4'] = "<b>b@n c0n+Rol5</b> 4ll0Ws +He b@Nn1ng 4nd UN-b4Nn1ng 0f Ip 4ddR3s\$E5, U\$3Rn@MES, Em41l 4ddrE5SeS 4Nd NickN@m3s.";
$lang['adminexp_5'] = "<b>f0Ld3RS</b> 4lLoW\$ +eh cre4+I0n, m0dIphic@+1oN 4Nd D3lEt10N 0Ph F0Ld3rS.";
$lang['adminexp_6'] = "<b>r\$5 f3eds</b> @lL0w\$ j00 t0 cr34t3 4nd REmOV3 rSS FEEDs ph0R ProPO94+1on 1N+o Y0Ur F0rum.";
$lang['adminexp_7'] = "<b>prOF1Le5</b> lets j00 CUs+om153 +h3 1teMs TH@t 4Ppe@r iN T3h Us3R Pr0F1l3\$.";
$lang['adminexp_8'] = "<b>fOrum S3TTIng5</b> @Ll0w\$ J00 t0 cu5+0Mi53 yoUr pHOrum'5 n4m3, apPe4R4nce 4nd M@ny O+heR +HiN9S.";
$lang['adminexp_9'] = "<b>sT4rt p@ge</b> L3+\$ J00 cu5TomI\$e YoUr pH0RuM's St4r+ p49e.";
$lang['adminexp_10'] = "<b>fOrum S+yLE</b> 4lLowS j00 To cRe4+3 5tyleS Ph0R y0ur f0rum meMBERs To US3.";
$lang['adminexp_11'] = "<b>word pHil+Er</b> 4Ll0w5 J00 +0 Phil+er W0rdS J00 dON'+ w@n+ t0 83 u5ed On YOur PHorUM.";
$lang['adminexp_12'] = "<b>p0\$+in9 5T4+5</b> 9En3R4+es @ repoRt List1n9 +eh top 10 po5+er5 1N A dEf1n3d p3r10d.";
$lang['adminexp_13'] = "<b>f0RUM lINK5</b> LE+S j00 M4n49E tHe L1nk\$ dr0pd0wn 1n teH N4VIg4t10n b4r.";
$lang['adminexp_14'] = "<b>v13W l09</b> Li\$Ts rec3nt 4ct10N5 bY +He Ph0RuM mOd3r@Tor5.";
$lang['adminexp_15'] = "<b>mAN49E ph0RUM\$</b> LEtS j00 CrE4+3 @nd dEle+E 4nd CL0\$e 0R r3op3N pH0RUM\$.";
$lang['adminexp_16'] = "<b>gLob4L fORuM S3+TinGs</b> 4Ll0w\$ J00 +0 m0d1fy se+T1Ng5 WHICh @fph3ct 4Ll pH0rUmS.";
$lang['adminexp_17'] = "<b>poSt @PPr0V4l qUeu3</b> 4ll0W\$ J00 tO V1eW 4Ny PoS+\$ 4wA1+1n9 4pProV4L 8y @ m0Der4+0R.";
$lang['adminexp_18'] = "<b>v1si+0r L09</b> @LlOW\$ j00 +0 view an EXt3NDED li5T oPh Vi\$I+ORs inCluDiN9 tHEiR HT+P rEf3r3r5.";
$lang['createforumstyle'] = "cRe@+E 4 FOruM STylE";
$lang['newstylesuccessfullycreated'] = "n3W s+Yl3 %s SuccE5SfuLly cr34+ED.";
$lang['stylealreadyexists'] = "a STyl3 w1+H th4t pHIl3N@m3 4Lre4dy 3xi\$ts.";
$lang['stylenofilename'] = "j00 d1d NO+ en+eR a pH1len4m3 t0 s4Ve +eh s+yL3 w1Th.";
$lang['stylenodatasubmitted'] = "c0Uld n0t r3@d ph0Rum styl3 D4+@.";
$lang['styleexp'] = "use th1S p@9E t0 HelP cr3aT3 4 r@nd0Mly 9eN3r4+3D 5+yLE FoR yOUr Ph0ruM.";
$lang['stylecontrols'] = "c0n+R0lS";
$lang['stylecolourexp'] = "cLicK 0n 4 c0LoUr t0 M4ke 4 New \$TyLe 5H3Et 845ED 0n tHaT cOl0uR. CUrR3nt b@se colOUr I\$ F1r5t 1N l1s+.";
$lang['standardstyle'] = "s+4Nd4rd \$TylE";
$lang['rotelementstyle'] = "rO+4+3D 3lemEnt 5tYle";
$lang['randstyle'] = "r4nd0m \$tyl3";
$lang['thiscolour'] = "thi5 CoLouR";
$lang['enterhexcolour'] = "oR eN+3r 4 h3x COl0ur To b4\$e 4 n3W \$+yL3 \$HeE+ 0N";
$lang['savestyle'] = "s4v3 TH1s 5tyle";
$lang['styledesc'] = "s+yle Descr1pT10N";
$lang['fileallowedchars'] = "(lOWerc@5e l3tt3Rs (@-z), NuMbers (0-9) 4nd UnDER5c0re5 (_) OnlY)";
$lang['stylepreview'] = "s+YlE prev1EW";
$lang['welcome'] = "w3LCoME";
$lang['messagepreview'] = "m3SS493 pr3v1ew";
$lang['users'] = "u\$ErS";
$lang['usergroups'] = "u53r groUpS";
$lang['mustentergroupname'] = "j00 mU\$t 3nt3R 4 9r0up N@M3";
$lang['profiles'] = "pR0f1Le5";
$lang['manageforums'] = "mAn493 fOruM5";
$lang['forumsettings'] = "f0RuM s3TT1NGS";
$lang['globalforumsettings'] = "gl08@L fORuM SE++1N9S";
$lang['settingsaffectallforumswarning'] = "<b>n0TE:</b> Th3SE set+inG5 4fFec+ 4ll phOrum\$. wherE the s3t+ing I\$ DUpliC4ted 0N +eh indiv1dU4l PHoruM'\$ 53++1ng\$ p4g3 +haT WILL +4kE pr3CEdenc3 0vER +eh SettIng5 J00 ch4NG3 HEre.";
$lang['startpage'] = "st4R+ P4gE";
$lang['startpageerror'] = "y0ur S+4rt P4Ge c0ULd n0T B3 s4V3d Loc4lLY +0 +h3 \$erveR 83C4u5e permi\$5i0n w@5 dEn1Ed.<br /><br />to Ch@NGe y0UR \$+4rt P4g3 Pl345e clIcK +eh d0wnlOaD but+0n 83L0w Which wiLL prOMpT J00 +O \$@Ve t3H F1le tO yOUR H@RD DriVE. J00 c4n +hEn UplO4D tH1S PhiLe tO y0Ur s3rv3R 1nt0 +3H f0ll0Win9 PH0ld3r, 1f n3ceS54ry cR34T1n9 +3h FOLd3r STrucTuRE In th3 pr0ceS\$.<br /><br /><b>%s</b><br /><br />pL3@SE nO+3 TH4T SoMe BROW5eRS m@y ch4nGe +3H n4Me OPH t3H PhIlE upON DOWNl0@D.  wheN UPl0@dINg th3 f1Le Pl345e m4Ke 5urE ThAt 1+ 15 N4MEd \$t4rt_m41n.php oTHerWi5e Y0Ur 5+@R+ P@Ge W1Ll 4pP34r UNcH4N9Ed.";
$lang['failedtoopenmasterstylesheet'] = "yOUR Ph0ruM 5+yl3 c0Uld No+ 83 54v3d Bec4u53 +hE ma\$ter s+ylE 5HEEt C0uLD no+ 83 L04d3d. +o \$@v3 Y0uR sTylE +Eh M@5Ter S+yle SHe3T (m@k3_\$+YLE.c\$S) mu\$t bE l0C4+ed 1N +He S+YLe5 D1rEc+0ry of your 8e3hIve Ph0RUm InS+4Ll4+1ON.";
$lang['makestyleerror'] = "yOur FoRUm \$TYl3 COULd NO+ b3 S4VeD l0C@Lly +0 +eh \$erV3R bEc4uSE P3RmIS51oN w@S dEN1ed. +0 5@vE Y0UR PhOrUM \$+yL3 PLeA\$3 CL1Ck +eH DOwnL0@d 8UttON 83LoW Wh1CH W1Ll PR0Mpt j00 +0 \$4V3 +he fil3 To y0uR h4rD DRiVE. j00 C@n +heN UpLO@d +h15 PhIL3 +O YOUr sERV3R 1n+o %s F0LdEr, iF N3C35s4Ry crE4+iN9 tH3 pH0LdER stRUCtUR3 1N +He proc3S\$. J00 sH0ULD NO+E +h4T 5OMe 8R0WSERS M4y Ch4nGE +3h N4me OF T3h PhIL3 UPon DOWNL0aD. WHeN UpL0@d1Ng tH3 pHIlE pL34\$3 M@kE sUr3 Th4T 1T I\$ N4MeD \$+yLE.cSS O+H3RWi5E th3 PH0rUM \$TylE w1lL b3 unU\$48L3.";
$lang['uploadfailed'] = "y0Ur n3w 5t4r+ p@9e cOUld n0+ 8E uPlo@deD +o +He 53rver Bec4uS3 p3rmI\$510n w45 dEn1ed. pLe4Se ChEck th@t th3 w3b SerV3r / Php Proc3\$5 is 4bL3 t0 wri+3 +0 Th3 %s Phold3r On Y0ur SERv3r.";
$lang['makestylefailed'] = "y0uR new F0Rum stYl3 cOuld n0+ 8e 54ved T0 T3h \$ERv3r BEC4u\$e p3Rm1Ss1on wAs den1Ed. pLE45e cH3ck +h@+ +he web sERv3r / pHP pROc3sS 1s 48l3 +0 wri+3 to +HE %s ph0lDer On yOur \$3rVEr.";
$lang['forumstyle'] = "f0RUm 5TYlE";
$lang['wordfilter'] = "word F1lt3R";
$lang['forumlinks'] = "f0rUm link\$";
$lang['viewlog'] = "v13W l0g";
$lang['noprofilesectionspecified'] = "nO pr0f1l3 \$ectIoN sP3c1Fied.";
$lang['itemname'] = "i+Em n4m3";
$lang['moveto'] = "mOVe t0";
$lang['manageprofilesections'] = "m@n@ge PR0f1l3 \$3C+i0N\$";
$lang['sectionname'] = "sEct1On n@me";
$lang['items'] = "iT3m\$";
$lang['mustspecifyaprofilesectionid'] = "mUst SpecIfy @ pr0f1le SEc+1oN id";
$lang['mustsepecifyaprofilesectionname'] = "muS+ SpECiphy A pROF1Le seCt10N n4Me";
$lang['successfullyeditedprofilesection'] = "sUCC3\$\$PhUllY 3Di+3d PR0phiL3 \$ec+Ion";
$lang['addnewprofilesection'] = "add N3w pr0philE S3cti0n";
$lang['mustsepecifyaprofilesectionname'] = "muSt \$PecIphY @ Pr0Ph1l3 \$ECt10n n4ME";
$lang['successfullyremovedselectedprofilesections'] = "succe\$sfuLly rEMoV3d 53l3cteD prOPhIl3 s3cT10n\$";
$lang['failedtoremoveprofilesections'] = "f41Led tO r3mOv3 prOPhilE s3C+1ONS";
$lang['viewitems'] = "vI3w 1T3m\$";
$lang['successfullyremovedselectedprofileitems'] = "suCcE\$5PHuLly RemOv3d 5EleC+3D PrOphIle IteMS";
$lang['failedtoremoveprofileitems'] = "f@1l3D tO r3m0v3 PRophilE ItemS";
$lang['noexistingprofileitemsfound'] = "theRE @r3 N0 eXistiN9 pr0phiLE i+emS 1n Th1s s3c+10N. to @dd @ Pr0Fil3 i+3M cl1ck THE butT0n bEL0w.";
$lang['edititem'] = "ed1t iteM";
$lang['invaliditemidoritemnotfound'] = "inV4Lid 1Tem 1D 0r I+3M nO+ F0Und";
$lang['addnewitem'] = "aDD n3w IT3m";
$lang['startpageupdated'] = "sT4rt P493 upd4+3d";
$lang['viewupdatedstartpage'] = "v13W uPd4+eD \$T4r+ P4Ge";
$lang['editstartpage'] = "eD1+ 5t4r+ p4g3";
$lang['nouserspecified'] = "no us3r 5peC1fIEd.";
$lang['manageuser'] = "m4N4GE us3R";
$lang['manageusers'] = "m4N49e USerS";
$lang['userstatus'] = "u\$er ST4tU\$ (cUrr3Nt pH0rum)";
$lang['userdetails'] = "usER d3+@Il\$";
$lang['warning_caps'] = "w4Rnin9";
$lang['userdeleteallpostswarning'] = "aRE j00 SurE j00 w@N+ to dEle+3 4ll Oph +he 5el3Cted US3r'S po\$tS? 0nce tEh p0\$+s 4r3 dEl3ted tH3y C4nn0+ b3 rEtr13V3d 4ND w1lL 83 l05t ph0R3VER.";
$lang['postssuccessfullydeleted'] = "p0S+\$ wer3 SucceSsPhulLy dEl3tED.";
$lang['folderaccess'] = "fOLder 4CcE5s";
$lang['possiblealiases'] = "pos5I8L3 4lI4\$3\$";
$lang['userhistory'] = "usEr h1sTOry";
$lang['nohistory'] = "nO HIStOrY R3C0rD\$ 54veD";
$lang['userhistorychanges'] = "chaN93\$";
$lang['clearuserhistory'] = "cl3@r US3R hI5+ORy";
$lang['changedlogonfromto'] = "ch4n9Ed LO9On pHroM %s tO %s";
$lang['changednicknamefromto'] = "cH@nGed n1CKN4M3 PhR0M %s +0 %s";
$lang['changedemailfromto'] = "cH@nGed 3Mail PHR0M %s TO %s";
$lang['usersettingsupdated'] = "us3R \$EtTIng5 succ3sSFullY upDat3D";
$lang['nomatches'] = "n0 m4+Che5";
$lang['deleteposts'] = "d3L3t3 Po\$+S";
$lang['deleteallusersposts'] = "dELE+e 4lL 0ph +h15 uS3r's p0stS";
$lang['noattachmentsforuser'] = "nO 4++4chment5 phoR +his uSer";
$lang['forgottenpassworddesc'] = "ipH TH1s u\$er h4\$ f0rgoTT3n the1r p@s\$Word j00 c4n R3se+ iT f0r thEM H3re.";
$lang['manageusersexp'] = "thI5 LI\$+ ShOw\$ 4 sEL3cT1ON Of u53rS Who H4ve L0ggED oN +0 your pHorum, 50rt3d 8y %s. +0 @l+ER @ u\$eR's p3rMI\$S1oN5 cLick The1r n4m3.";
$lang['userfilter'] = "u5ER phiL+er";
$lang['onlineusers'] = "oNLin3 Us3Rs";
$lang['offlineusers'] = "oFPhl1ne uSErs";
$lang['usersawaitingapproval'] = "users Awa1TIn9 @ppR0v@l";
$lang['bannedusers'] = "b@NN3D uSErS";
$lang['lastlogon'] = "l4\$+ lOg0N";
$lang['sessionreferer'] = "s3\$510N r3F3r3r";
$lang['signupreferer'] = "s19N-UP r3ph3r3r:";
$lang['nouseraccountsmatchingfilter'] = "no u\$Er 4cCouN+5 m@+ch1Ng F1L+eR";
$lang['searchforusernotinlist'] = "se4Rch f0R @ uS3r nOt 1n L1s+";
$lang['adminaccesslog'] = "aDMIN accE55 Log";
$lang['adminlogexp'] = "tHIS l1\$+ shOwS the l4\$+ ACti0n5 S4nc+10N3d by u5Er5 w1th ADm1n pRivil39E\$.";
$lang['datetime'] = "d@t3/T1mE";
$lang['unknownuser'] = "unKnOWn U5er";
$lang['unknownfolder'] = "unkNOwN ph0ld3r";
$lang['ip'] = "ip";
$lang['lastipaddress'] = "l4st 1p 4dDr3\$S";
$lang['logged'] = "l099Ed";
$lang['notlogged'] = "nOT l099ED";
$lang['addwordfilter'] = "add w0Rd f1L+eR";
$lang['addnewwordfilter'] = "adD New w0rd F1l+3r";
$lang['wordfilterupdated'] = "w0Rd fil+er upd@+3D";
$lang['filtertype'] = "fiLt3r tYpe";
$lang['editwordfilter'] = "eD1+ W0RD f1L+3r";
$lang['nowordfilterentriesfound'] = "n0 3XIStiN9 Word filter enTRi3S pH0und. +0 @dd @ w0rd ph1lter clIcK +eh butTon 83LOw.";
$lang['mustspecifymatchedtext'] = "j00 MuSt sP3C1Fy M4+chEd +eXt";
$lang['mustspecifyfilteroption'] = "j00 mUST sp3c1pHY 4 Phil+3r op+i0n";
$lang['mustspecifyfilterid'] = "j00 mUs+ Sp3C1Fy @ F1l+eR Id";
$lang['invalidfilterid'] = "iNV4L1d F1l+er id";
$lang['failedtoupdatewordfilter'] = "f41Led +O UPda+e w0rd FilTer. cHEck Th4+ Th3 PHil+er s+ILL 3Xi\$Ts.";
$lang['allow'] = "aLLOw";
$lang['normalthreadsonly'] = "noRM4L +hr34d\$ Only";
$lang['pollthreadsonly'] = "p0LL tHrE4d\$ 0nly";
$lang['both'] = "bO+h tHr34d tyPES";
$lang['existingpermissions'] = "exIsT1N9 perM15si0n\$";
$lang['nousers'] = "no USerS";
$lang['searchforuser'] = "seaRch F0R UsEr";
$lang['browsernegotiation'] = "brOWSER ne9ot1AT3d";
$lang['largetextfield'] = "l@R93 +EXT Phi3lD";
$lang['mediumtextfield'] = "m3D1um +ex+ FielD";
$lang['smalltextfield'] = "sM@ll +eX+ FIeld";
$lang['multilinetextfield'] = "mUlt1-Lin3 +ExT PhIeld";
$lang['radiobuttons'] = "r@Di0 BUtT0n5";
$lang['dropdown'] = "dR0P d0wn";
$lang['threadcount'] = "thR3@d c0un+";
$lang['fieldtypeexample1'] = "foR R4d1o 8U+tON\$ 4nd DR0P D0wn fI3LD5 J00 Need +O \$epAr@tE THe Ph1Eldn4m3 @ND +He v4lu3S Wi+h 4 COL0n 4Nd e4ch v@lue \$HOULd B3 Sep4RateD By SEm1-coL0N5.";
$lang['fieldtypeexample2'] = "eX4mPle: to crE4+E 4 8@\$1c 93NDeR r4di0 8U++0nS, wi+H +w0 Sel3ct10n\$ phOr Male 4Nd Ph3m@l3, j00 wOuld 3N+3r: <b>geNdeR:m4le;Ph3MaL3</b> 1N +HE 1T3m n@me F1ElD.";
$lang['editedwordfilter'] = "ed1+ed w0rd phiL+3R";
$lang['editedforumsettings'] = "eDited FoRUM SET+In9S";
$lang['sessionsuccessfullyended'] = "succ3S\$fuLly 3ND3D S3s510nS F0r 53L3ct3d uS3R\$";
$lang['matchedtext'] = "m4TChed +3X+";
$lang['replacementtext'] = "rePL4c3m3NT teX+";
$lang['preg'] = "pR39";
$lang['wholeword'] = "wh0Le W0rD";
$lang['word_filter_help_1'] = "<b>aLl</b> M4+che5 @9@1Ns+ +h3 WHoL3 T3x+ 5O f1lt3r1Ng Mom +0 mum W1ll 4lS0 ch@ngE mOMenT t0 muMenT.";
$lang['word_filter_help_2'] = "<b>wh0l3 W0RD</b> Ma+CH3\$ 494inS+ WhOL3 wORD\$ onlY 50 f1l+ER1nG mOm +0 MUm WilL N0t cH4n9e m0men+ +0 Mument.";
$lang['word_filter_help_3'] = "<b>pr39</b> @lL0W5 J00 T0 U\$E peRl R39ul4r 3Xpr35510n\$ tO M4tch t3X+.";
$lang['nameanddesc'] = "n@M3 aND d3\$CriP+1On";
$lang['movethreads'] = "m0V3 +Hre4dS";
$lang['threadsmovedsuccessfully'] = "thrE4D\$ M0ved \$ucc355FulLy";
$lang['movethreadstofolder'] = "m0v3 thRe4Ds to ph0ld3r";
$lang['resetuserpermissions'] = "rE\$Et uS3r P3rMiS510nS";
$lang['userpermissionsresetsuccessfully'] = "u\$ER PermI5\$i0nS R3SeT 5Ucc3\$\$PHulLy";
$lang['allowfoldertocontain'] = "aLL0w ph0ld3r +0 ConT41N";
$lang['addnewfolder'] = "adD n3w F0ld3r";
$lang['mustenterfoldername'] = "j00 MU5t eN+3R 4 FolDER n4m3";
$lang['nofolderidspecified'] = "n0 f0ld3R id \$PEcIph1ed";
$lang['invalidfolderid'] = "inV4l1D pHoldeR 1d. checK th4+ 4 F0lD3r W1th Th15 id exi\$tS!";
$lang['successfullyaddedfolder'] = "succEsspHULLy 4dd3d fOLd3r";
$lang['successfullydeletedfolder'] = "sUcces\$FuLly DELeTED f0ld3R";
$lang['failedtodeletefolder'] = "f@1Led +0 deL3te PhoLd3r.";
$lang['folderupdatedsuccessfully'] = "fOLd3r Upd@+ED sucC3\$\$FUllY";
$lang['cannotdeletefolderwiththreads'] = "c@Nn0+ dEle+e phold3rs Th4+ 5till c0nT4in +hRe4d5.";
$lang['forumisnotrestricted'] = "f0RUM 1\$ n0+ re5tr1c+3D";
$lang['groups'] = "gROUpS";
$lang['nousergroups'] = "no uS3r GRouPS H4Ve 8een set up";
$lang['suppliedgidisnotausergroup'] = "sUppLI3d G1D 1S n0+ 4 Us3R 9rOup";
$lang['manageusergroups'] = "m4N4Ge usER 9rOup\$";
$lang['groupstatus'] = "grOUp \$T4tus";
$lang['addusergroup'] = "adD 9ROUp";
$lang['addremoveusers'] = "adD/r3moV3 uS3r\$";
$lang['nousersingroup'] = "tH3r3 4Re n0 u5Er5 1n Th15 GROUP";
$lang['useringroups'] = "tH15 u5eR i5 4 mEmb3r oF tH3 PholLowiN9 gR0upS";
$lang['usernotinanygroups'] = "tHI5 u5er 15 No+ 1N 4Ny uS3R 9r0UP\$";
$lang['usergroupwarning'] = "n0t3: th15 U5er M4Y be 1NHErit1ng @dd1+10n4l P3rm1s510Ns phROm @Ny u\$3R gr0up\$ liS+ed 8EL0w.";
$lang['successfullyaddedgroup'] = "sUcc3\$5PHUlly add3D 9r0up";
$lang['successfullydeletedgroup'] = "sUCcesSFulLy dEleT3d 9RouP";
$lang['usercanaccessforumtools'] = "usER c@n 4CcE\$5 PH0rum ToOl5 4Nd can crE4+e, dEl3t3 4ND Edi+ FOrUmS";
$lang['usercanmodallfoldersonallforums'] = "u5er C@n mOD3r4Te <b>alL FolD3rS</b> 0N <b>all PH0ruM\$</b>";
$lang['usercanmodlinkssectiononallforums'] = "uSER c4N mOd3r4+E L1nkS 5ecT1On ON <b>all F0Rum\$</b>";
$lang['emailconfirmationrequired'] = "em@1l C0nF1rM@+10n r3QuIred";
$lang['userisbannedfromallforums'] = "uSER 1\$ 8@NNed PHr0M <b>aLl f0rUm5</b>";
$lang['cancelemailconfirmation'] = "c4Nc3l eM4Il conF1Rma+i0n 4Nd @ll0W u\$er tO \$+4Rt P0Stin9";
$lang['resendconfirmationemail'] = "r3\$end cONPhIRM4+Ion 3M41l +0 u\$er";
$lang['donothing'] = "d0 N0+H1nG";
$lang['usercanaccessadmintools'] = "us3r H4\$ 4Cc3S5 +0 ph0rum 4DM1N t0ol5";
$lang['usercanaccessadmintoolsonallforums'] = "us3R h@5 @cc3\$S tO @dMiN +00Ls <b>on 4lL f0rum\$</b>";
$lang['usercanmoderateallfolders'] = "u\$3R c4N MOd3r@+E 4lL ph0ld3rs";
$lang['usercanmoderatelinkssection'] = "us3R c@n m0der4T3 l1NKs \$ECt1On";
$lang['userisbanned'] = "uSER 15 8@nn3d";
$lang['useriswormed'] = "uS3R 15 WOrm3D";
$lang['userispilloried'] = "us3R 1\$ P1llORi3d";
$lang['usercanignoreadmin'] = "u\$er c@n 1gnorE 4dmin15+r4T0RS";
$lang['groupcanaccessadmintools'] = "gRoup c4N acce5\$ 4dmin T0ol\$";
$lang['groupcanmoderateallfolders'] = "gR0up c@n m0D3r4+e 4Ll ph0ld3rs";
$lang['groupcanmoderatelinkssection'] = "gRoup c4n m0der@+e L1nk5 5Ect10n\$";
$lang['groupisbanned'] = "gR0up i5 b4nn3d";
$lang['groupiswormed'] = "gRoUp I\$ worm3d";
$lang['readposts'] = "re4D Po5ts";
$lang['replytothreads'] = "r3Ply t0 +hRe4D5";
$lang['createnewthreads'] = "cR34T3 nEw thRe4D\$";
$lang['editposts'] = "eDi+ Po\$tS";
$lang['deleteposts'] = "d3let3 PO\$TS";
$lang['uploadattachments'] = "uplO4d @+t4cHMenTS";
$lang['moderatefolder'] = "m0d3r4t3 PH0ld3R";
$lang['postinhtml'] = "po\$t iN html";
$lang['postasignature'] = "p05T 4 51gN4+Ur3";
$lang['editforumlinks'] = "eDI+ FOrUm LinK5";
$lang['editforumlinks_exp'] = "uS3 TH1s pa9E TO 4DD LInk5 to +He DRoP-dOwN LI\$T disPL4YEd 1n t3H +0p-R1Ght 0f +eh foRUm FR4MeSeT. 1f nO L1nkS @r3 \$e+, +eH DROP-dowN L1St wIll nO+ 8E DI\$Pl4y3D.";
$lang['notoplevellinktitlespecified'] = "n0 +0P L3v3l LInk ti+lE \$P3C1Fi3d";
$lang['toplinktitlesuccessfullyupdated'] = "tOP leVeL liNK t1+Le SUccE5\$fulLy uPD4T3D";
$lang['youmustenteralinktitle'] = "j00 Mu\$T 3nT3r @ liNK T1tLe";
$lang['alllinkurismuststartwithaschema'] = "aLL linK uriS muS+ S+4r+ WITh 4 sChEm@ (i.E. h+tp://, ph+p://, iRc://)";
$lang['noexistingforumlinksfound'] = "thErE 4re nO EX15t1ng f0rUm l1nK\$. +0 aDD @ ph0rUm l1nk Cl1CK TH3 8U++on BelOW.";
$lang['editlink'] = "ed1+ L1NK";
$lang['addnewforumlink'] = "aDd new PhOrUm l1nk";
$lang['forumlinktitle'] = "forUm link +1TL3";
$lang['forumlinklocation'] = "f0RuM L1nk LOCat10N";
$lang['successfullyaddedlink'] = "sUcces5PHULly 4dDed LinK: '%s'";
$lang['successfullyeditedlink'] = "sUCc3\$5fuLLY eDit3d liNK: '%s'";
$lang['invalidlinkidorlinknotfound'] = "inV4l1d lInk 1d 0r L1nK n0+ FouNd";
$lang['successfullyremovedselectedlinks'] = "sUcc3S\$FuLly r3MoV3D sELEC+3d LiNkS";
$lang['failedtoremovelinks'] = "f4Il3d t0 r3M0V3 \$3l3cted l1Nk5";
$lang['failedtoaddnewlink'] = "f4ILed to 4dd n3w L1nk: '%s'";
$lang['failedtoupdatelink'] = "f@ilEd +0 Upd4t3 L1nk: '%s'";
$lang['toplinkcaption'] = "toP liNK c4PtiON";
$lang['allowguestaccess'] = "aLL0w 9U3\$T 4CcEss";
$lang['searchenginespidering'] = "sE@rch eN91ne 5pid3Rin9";
$lang['allowsearchenginespidering'] = "alLOw Se4rch 3n91N3 \$piD3r1ng";
$lang['newuserregistrations'] = "nEw U53r r3915+r@ti0n5";
$lang['preventduplicateemailaddresses'] = "pReVEnt dUPlic@te em4IL 4ddr3\$53S";
$lang['allownewuserregistrations'] = "aLLoW New UsER re9iS+r4+10N5";
$lang['requireemailconfirmation'] = "r3QUiRe 3M@1l cOnfirM4+iOn";
$lang['usetextcaptcha'] = "u\$e T3X+-C4p+ch4";
$lang['textcaptchadir'] = "tExt-c4p+ch@ d1r3Ct0RY";
$lang['textcaptchakey'] = "tEx+-c4p+CH4 keY";
$lang['textcaptchafonterror'] = "teXT-c@p+ch4 h@S 833n d15@8L3d 4ut0maTic@LLy bec4U53 +hEre 4r3 nO +rU3 tYPe FOn+5 4v41L@8L3 ph0R 1+ To u\$e. ple4\$e upl04d Som3 +RU3 TYpE PHoN+\$ tO <b>%s</b> 0N y0uR \$eRveR.";
$lang['textcaptchadirerror'] = "text-CaP+ch4 H4\$ BEen D1S4bl3d b3c@Use TH3 TeX+_c@p+cH4 d1R3ctory 4Nd it'5 \$U8-direc+0ri3\$ @r3 nO+ wR1+4ble by teH w3B s3rV3r / Php Pr0c355.";
$lang['textcaptchagderror'] = "t3xT-c@PTCH4 H@s bEEn D15@8L3d 83c@uSe Y0ur SerV3r's pHp 5ETup d03s No+ pr0vID3 \$UPpoR+ f0r gd 1m4G3 m4NipuL4+i0n 4ND / 0R tTph Ph0N+ \$UpPoR+. 80Th 4RE Requ1r3D FoR +3x+-c4P+CH@ SuPpOr+.";
$lang['textcaptchadirblank'] = "text-c@p+ch4 d1R3c+oRy 15 bL4Nk!";
$lang['newuserpreferences'] = "n3W UsER prEF3rENces";
$lang['sendemailnotificationonreply'] = "em@Il nO+1ph1c@t1On 0N r3PLY +o uSer";
$lang['sendemailnotificationonpm'] = "eM@1l n0+IF1c4+1oN 0n PM +0 Us3R";
$lang['showpopuponnewpm'] = "sHOw P0pUp wH3N r3CE1V1n9 N3w pm";
$lang['setautomatichighinterestonpost'] = "s3+ 4UTOm4+ic h1Gh 1nteRe\$+ On pO5T";
$lang['top20postersforperiod'] = "t0p 20 PO\$TER5 pHor p3R1od %s to %s";
$lang['postingstats'] = "p0st1n9 St4+5";
$lang['nodata'] = "n0 D4+4";
$lang['totalposts'] = "tOT4L pO5t5";
$lang['totalpostsforthisperiod'] = "t0+4L Po\$TS ph0r +h15 pEr10D";
$lang['mustchooseastartday'] = "mus+ chOO\$e 4 \$T4r+ d4Y";
$lang['mustchooseastartmonth'] = "mU\$+ ChoO53 4 st4r+ mOn+h";
$lang['mustchooseastartyear'] = "mU\$t CHo0\$e 4 s+@R+ Ye4r";
$lang['mustchooseaendday'] = "mU\$T CH00\$e 4 3Nd D4Y";
$lang['mustchooseaendmonth'] = "mUst Ch0o\$e @ 3nd m0n+H";
$lang['mustchooseaendyear'] = "mu5t ch0O\$3 @ 3nd ye@r";
$lang['startperiodisaheadofendperiod'] = "sT4r+ per10d 1S 4he4d OF eNd p3r10d";
$lang['bancontrols'] = "b4n cOn+r0l\$";
$lang['addban'] = "adD B@n";
$lang['checkban'] = "ch3CK b@n";
$lang['editban'] = "edi+ b4n";
$lang['bantype'] = "b@N +ype";
$lang['bandata'] = "baN d4+4";
$lang['bancomment'] = "cOmment";
$lang['ipban'] = "iP 8an";
$lang['logonban'] = "lo90N b4N";
$lang['nicknameban'] = "n1CKn4M3 84n";
$lang['emailban'] = "em4IL 8@N";
$lang['refererban'] = "repH3R3R baN";
$lang['invalidbanid'] = "iNVAliD b@N iD";
$lang['affectsessionwarnadd'] = "tHiS 84n M4y @fF3Ct +He F0LLoW1Ng 4c+1V3 U53R 5ess10nS";
$lang['noaffectsessionwarn'] = "tHIS b@n 4Ff3c+s n0 4c+Ive ses51On\$";
$lang['mustspecifybantype'] = "j00 musT sP3C1Phy 4 b4N TYp3";
$lang['mustspecifybandata'] = "j00 mu\$+ \$PeCipHy SOmE B4n D4+@";
$lang['successfullyremovedselectedbans'] = "sUCCesSpHUllY rEm0Ved \$3l3cted B4Ns";
$lang['failedtoaddnewban'] = "f@1L3d To @DD n3W B4n";
$lang['failedtoremovebans'] = "f41L3D +0 r3mOv3 SoM3 Or @lL of +EH \$3L3ct3d 8@N5";
$lang['duplicatebandataentered'] = "duPlIc4+E b4n d@+4 3nT3red. pl345E ch3ck y0ur w1Ldc@rdS t0 s33 1f Th3Y @lR34Dy m4+Ch TEH d@+a 3N+3R3d";
$lang['successfullyaddedban'] = "sUCcESSPHUlLY 4dd3d b4N";
$lang['successfullyupdatedban'] = "sUCc3\$sphulLy uPd@+ed B4n";
$lang['noexistingbandata'] = "tH3R3 i\$ n0 eX15t1n9 84n d4+4. t0 4dd 5Om3 84n d4+4 PL3a\$e CL1cK +eh buTtON 83low.";
$lang['youcanusethepercentwildcard'] = "j00 CAN uSe Th3 p3rceNt (%) w1ldc@rd 5ymbOl 1N 4NY 0ph yoUR 8@n Li\$tS to 0b+@iN p4Rt14L m4+Che5, 1.E. '192.168.0.%' w0uLd B4n 4ll 1p @ddReSSeS 1n tH3 r4Nge 192.168.0.1 tHr0UgH 192.168.0.254";
$lang['cannotusewildcardonown'] = "j00 c4nn0t 4Dd % as @ wildC@rd m4TCh 0n I+'S oWN!";
$lang['requirepostapproval'] = "rEQuIRE po\$T 4ppr0v4l";
$lang['adminforumtoolsusercounterror'] = "th3r3 muST be 4t l34\$+ 1 User wI+h 4dM1n +00LS 4Nd FOrUm tOoL\$ 4cC3\$s oN 4ll fOruMs!";
$lang['postcount'] = "pO\$T c0unt";
$lang['resetpostcount'] = "r35Et p0\$t cOUn+";
$lang['postapprovalqueue'] = "pOS+ 4Ppr0v@l queU3";
$lang['nopostsawaitingapproval'] = "n0 p05tS 4r3 4W4itIn9 4ppr0V@L";
$lang['approveselected'] = "aPprov3 selectEd";
$lang['successfullyapproveduser'] = "sUCCeS5pHulLY 4pPRov3D s3lec+Ed U5eRs";                                                
$lang['kickselected'] = "k1ck 53L3c+ed";
$lang['visitorlog'] = "viSiToR lo9";
$lang['novisitorslogged'] = "n0 vi5iToR\$ L0g93D";
$lang['addselectedusers'] = "aDd seLEC+ed u5Ers";
$lang['removeselectedusers'] = "rEM0v3 S3l3cteD uS3R\$";
$lang['addnew'] = "add N3w";
$lang['deleteselected'] = "d3leT3 s3lect3D";
$lang['noprofilesectionsfound'] = "theRe 4r3 n0 EXi\$t1ng PrOph1le 5ec+iOns. +o 4DD a pr0ph1l3 \$3CTioN pl345E Cl1ck tH3 BUtTOn bEloW.";
$lang['addnewprofilesection'] = "aDd n3W PR0F1le S3Ct10N";
$lang['successfullyaddedsection'] = "succ3s\$fulLy add3d SECTi0N";

// Admin Log data (admin_viewlog.php) --------------------------------------------

$lang['changedstatusforuser'] = "cH4nGed U53r 5+4TU\$ F0R '%s'";
$lang['changedpasswordforuser'] = "cH@NGED p4s\$wOrd Phor '%s'";
$lang['changedforumaccess'] = "cH@Ng3D ForUM 4cceSs PErMIs510ns F0r '%s'";
$lang['deletedallusersposts'] = "del3t3D 4lL PO5+S ph0r '%s'";

$lang['createdusergroup'] = "crE@Ted us3r 9RoUp '%s'";
$lang['deletedusergroup'] = "dELet3d U\$er grouP '%s'";
$lang['updatedusergroup'] = "upd4tEd Us3r grouP '%s'";
$lang['addedusertogroup'] = "aDded usEr '%s' +0 gr0Up '%s'";
$lang['removeduserfromgroup'] = "r3M0V3 us3R '%s' pHr0m gr0Up '%s'";

$lang['addedipaddresstobanlist'] = "aDD3d 1p '%s' +0 8@n l1St";
$lang['removedipaddressfrombanlist'] = "r3M0v3d iP '%s' Phr0m b4N li5T";

$lang['addedlogontobanlist'] = "aDD3d L0g0n '%s' +0 84n LI5T";
$lang['removedlogonfrombanlist'] = "r3MOV3d Log0n '%s' phrOm 84N liS+";

$lang['addednicknametobanlist'] = "added Nickn@me '%s' tO 8@N List";
$lang['removednicknamefrombanlist'] = "r3Mov3d NIckN4m3 '%s' PhR0m b4n L15T";

$lang['addedemailtobanlist'] = "aDd3d 3M4il 4DDr3\$5 '%s' T0 8@N Li\$T";
$lang['removedemailfrombanlist'] = "r3M0V3D 3M4il addre\$S '%s' FroM 84n l15+";

$lang['addedreferertobanlist'] = "aDd3d r3feREr '%s' tO 84n lIS+";
$lang['removedrefererfrombanlist'] = "reM0ved R3ph3r3r '%s' Fr0M b4N l15T";

$lang['editedfolder'] = "eDi+ED pHOld3r '%s'";
$lang['movedallthreadsfromto'] = "moved alL +Hre4dS fr0M '%s' T0 '%s'";
$lang['creatednewfolder'] = "cRE4+3D New pH0ld3R '%s'";
$lang['deletedfolder'] = "deL3T3D ph0LD3r '%s'";

$lang['changedprofilesectiontitle'] = "chan93d Pr0FIL3 \$ect10N +i+Le PHrOm '%s' +0 '%s'";
$lang['addednewprofilesection'] = "adDed new pr0f1l3 Sec+i0N '%s'";
$lang['deletedprofilesection'] = "d3l3+3D prOF1l3 \$3c+i0N '%s'";

$lang['addednewprofileitem'] = "addEd neW prOpHilE it3M '%s' To \$ECtI0n '%s'";
$lang['changedprofileitem'] = "ch4N9Ed PRophil3 i+eM '%s'";
$lang['deletedprofileitem'] = "d3L3+ED pR0ph1le 1+3m '%s'";

$lang['editedstartpage'] = "edI+ed ST4R+ Pag3";
$lang['savednewstyle'] = "s@v3D New StyLe '%s'";

$lang['movedthread'] = "m0v3d +hRe@d '%s' phrOm '%s' tO '%s'";
$lang['closedthread'] = "clo5ed thrE4D '%s'";
$lang['openedthread'] = "oPEn3d THre4D '%s'";
$lang['renamedthread'] = "r3N@mED tHR34d '%s' t0 '%s'";

$lang['deletedthread'] = "deleTeD THre@D '%s'";
$lang['undeletedthread'] = "und3l3t3D thr34d '%s'";

$lang['lockedthreadtitlefolder'] = "locK3D +hread 0p+1ON\$ oN '%s'";
$lang['unlockedthreadtitlefolder'] = "unLOckEd thRe4d OP+I0N5 oN '%s'";

$lang['deletedpostsfrominthread'] = "dELE+ed P05+S phR0m '%s' 1N +hR3@d '%s'";
$lang['deletedattachmentfrompost'] = "deL3+ed @tt4chmeNt '%s' PhrOm p0S+ '%s'";

$lang['editedforumlinks'] = "eD1+3D ForUm lInkS";
$lang['editedforumlink'] = "eD1tED F0rum L1nk: '%s'";

$lang['addedforumlink'] = "adDeD ph0rUm LInK: '%s'";
$lang['deletedforumlink'] = "d3L3T3d pH0rUm LinK: '%s'";
$lang['changedtoplinkcaption'] = "ch4n9Ed +0p l1nk c4pti0n fr0M '%s' +O '%s'";

$lang['deletedpost'] = "d3L3T3d PO5t '%s'";
$lang['editedpost'] = "edI+3d p0\$+ '%s'";

$lang['madethreadsticky'] = "m4D3 +hRe4D '%s' sT1CkY";
$lang['madethreadnonsticky'] = "m4dE thR34d '%s' NoN-5T1ckY";

$lang['endedsessionforuser'] = "eND3d \$Ess10n for Us3r '%s'";

$lang['approvedpost'] = "aPprovEd pO\$t '%s'";

$lang['editedwordfilter'] = "edI+ed wOrd pH1l+er";

$lang['addedrssfeed'] = "aDD3D r55 pHeed '%s'";
$lang['editedrssfeed'] = "ed1+3d Rss Ph3ED '%s'";
$lang['deletedrssfeed'] = "deL3+3d r\$5 pHeEd '%s'";

$lang['updatedban'] = "uPd4+3D b4n '%s'. '%s' +O '%s', '%s' t0 '%s'.";

$lang['splitthreadatpostintonewthread'] = "spL1+ +hRe4D '%s' @+ p0st %s  1Nt0 n3w tHr34d '%s'";
$lang['mergedthreadintonewthread'] = "mer93d Thre4D5 '%s' @nd '%s' In+0 N3w Thr3@D '%s'";

$lang['approveduser'] = "aPpr0V3d Us3R '%s'";

$lang['adminlogempty'] = "aDmin L09 1s 3mpty";
$lang['clearlog'] = "cLE4r Log";

// Admin Forms (admin_forums.php) ------------------------------------------------

$lang['noexistingforums'] = "no EX1ST1n9 PHorUm\$ Ph0UND. +0 cRe@+e @ new ph0Rum pLE4S3 CL1Ck THe bUTTon bel0W.";
$lang['webtaginvalidchars'] = "wEB+4g C4n Only cOn+41N uPPerc@se 4-Z, 0-9 4Nd uNder\$C0re ch4r4Cter\$";
$lang['databasenameinvalidchars'] = "d4+4b@S3 N@ME c@n ONly coNta1N 4-Z, 4-Z, 0-9 anD uNdErSC0R3 Ch4R@c+ERS";
$lang['invalidforumidorforumnotfound'] = "iNv4L1d F0rum F1d F0R Ph0Rum no+ f0Und";
$lang['successfullyupdatedforum'] = "sUCc3\$5FullY uPda+ed fOrUM: '%s'";
$lang['failedtoupdateforum'] = "f4IL3D tO upD@+E pHOrUM: '%s'";
$lang['successfullycreatedforum'] = "suCC3s\$fulLY cr3@+ed PhoRUm: '%s'";
$lang['failedtocreateforum'] = "f@iLed T0 creA+e pH0RUM '%s'. pLe@sE ChECK +O M@k3 \$ure t3h w3bT4g 4nd tA8L3 n4m35 4ReN't 4lre@Dy 1N U\$E.";
$lang['forumdeleteconfirmation'] = "aRE j00 5Ur3 J00 w4nt tO d3le+3 4Ll Of TH3 \$ELect3d FOrUmS?";
$lang['forumdeletewarning'] = "pl3@se n0T3 +h@+ j00 C4nno+ ReC0v3r d3l3+3D F0RuMS. Onc3 d3leT3d @ f0Rum 4nd 4Ll 0F iT's 455oci4t3D dAta Is p3RMeN@n+lY remov3d pHroM TH3 D4t484s3. iF j00 d0 n0+ w1\$h +o d3l3t3 t3h \$eLec+ed ph0ruMS pl34S3 CL1Ck c4NcEl.";
$lang['successfullydeletedforum'] = "succE\$sPhuLLy dEleteD ph0rum: '%s'";
$lang['failedtodeleteforum'] = "f4ILEd tO DELE+3D fOruM: '%s'";
$lang['addforum'] = "add f0Rum";
$lang['editforum'] = "eDIT Ph0RUM";
$lang['visitforum'] = "vi\$IT F0Rum: %s";
$lang['accesslevel'] = "aCceS5 L3v3l";
$lang['usedatabase'] = "u5e D4+48@s3";
$lang['unknownmessagecount'] = "uNkNowN";
$lang['forumwebtag'] = "fOrum webT49";
$lang['defaultforum'] = "d3F4Ult ph0ruM";
$lang['forumdatabasewarning'] = "plE45e en5Ur3 j00 \$elect +H3 COrr3ct D4t4b4Se Wh3n crE4+iNG 4 N3w pH0ruM. OnC3 CRe4+ED @ neW ph0rUm c4nN0+ bE MovEd beTW3en 4V@1l4bLe d4+@b4S3s.";

// Admin Global User Permissions

$lang['globaluserpermissions'] = "gL08al U\$ER peRmiS510Ns";

// Admin Forum Settings (admin_forum_settings.php) -------------------------------

$lang['mustsupplyforumwebtag'] = "j00 muSt SUppLy 4 F0RuM wEbT@g";
$lang['mustsupplyforumname'] = "j00 muST sUPplY @ F0rUm n4mE";
$lang['mustsupplyforumemail'] = "j00 mu5t \$upPlY 4 PhoRUM 3M@iL @DDre5\$";
$lang['mustchoosedefaultstyle'] = "j00 MUST ch00\$E 4 D3ph4ulT PH0rum \$Tyl3";
$lang['mustchoosedefaultemoticons'] = "j00 MUsT cHo0Se dEph@uL+ Forum 3mo+ic0n\$";
$lang['mustsupplyforumaccesslevel'] = "j00 mu\$T sUpPly 4 ph0rum @cC3s5 L3v3l";
$lang['mustsupplyforumdatabasename'] = "j00 MUSt SuPPlY @ f0RUM d4+48@5e N4me";
$lang['unknownemoticonsname'] = "uNkNoWN 3m0+1c0NS n4m3";
$lang['mustchoosedefaultlang'] = "j00 mUs+ CH0053 4 d3ph@uLt phorum l4Ngu493";
$lang['activesessiongreaterthansession'] = "aC+iVe 5Es\$1on +iMeout c4nn0+ bE grE4+Er Th4n 5Es510n t1m30u+";
$lang['attachmentdirnotwritable'] = "aT+4ChM3N+ D1R3c+ORy @nD SY\$t3M t3mP0r@RY dIRecT0Ry / php.1N1 'UPl0@D_tMP_D1R' mU5+ b3 wr1t48l3 by t3H W3B serv3R / pHp prOc3s5!";
$lang['attachmentdirblank'] = "j00 MU\$T supPLy @ Dir3ctORy to 54v3 @T+4chM3ntS 1N";
$lang['mainsettings'] = "m@in SE++1N95";
$lang['forumname'] = "foRUm N4m3";
$lang['forumemail'] = "foruM em41L";
$lang['forumdesc'] = "f0RuM d3Scr1p+i0N";
$lang['forumkeywords'] = "foRUM KEyWoRD5";
$lang['defaultstyle'] = "d3PH@Ul+ StyL3";
$lang['defaultemoticons'] = "d3Ph@ul+ eMO+Ic0n\$";
$lang['defaultlanguage'] = "d3Ph@UL+ l@NGu493";
$lang['forumaccesssettings'] = "foRUM @cce55 Se+T1nGs";
$lang['forumaccessstatus'] = "f0RuM 4cc3\$5 5t4+u\$";
$lang['changepermissions'] = "ch@NGe perM1ss1oN\$";
$lang['changepassword'] = "cH@n9E p@5sWord";
$lang['passwordprotected'] = "p4\$sWOrd PR0+Ec+ed";
$lang['passwordprotectwarning'] = "j00 h@V3 nO+ 5E+ @ ForUm P4ssWoRd. 1F j00 dO n0t s3T 4 p4\$swORD +3h p45sw0Rd PRo+ECt1On FuNc+i0N4l1tY w1Ll Be @U+Om@TIc@LLy di548L3D!";
$lang['postoptions'] = "pOst oP+10nS";
$lang['allowpostoptions'] = "alloW p05T eD1+1NG";
$lang['postedittimeout'] = "p0\$T 3D1+ timeoUt";
$lang['posteditgraceperiod'] = "p0sT Edit 9R4c3 P3r10d";
$lang['wikiintegration'] = "w1kIWIk1 1N+eGr4+i0N";
$lang['enablewikiintegration'] = "eNAbl3 W1KIwik1 IN+eGrat10n";
$lang['enablewikiquicklinks'] = "enAbLE W1k1w1KI qU1Ck L1nkS";
$lang['wikiintegrationuri'] = "wIk1wikI l0C4+10n";
$lang['maximumpostlength'] = "m4xImUm Po\$+ len9th";
$lang['postfrequency'] = "p0\$T pHR3quENCY";
$lang['enablelinkssection'] = "en@ble l1nk5 S3c+i0n";
$lang['allowcreationofpolls'] = "alL0w cRe4+I0n 0F P0Ll\$";
$lang['allowguestvotesinpolls'] = "all0w GUeS+S +0 vO+3 1n p0LlS";
$lang['unreadmessagescutoff'] = "uNR34d MEs54geS cu+-0Phf";
$lang['unreadcutoffseconds'] = "seC0ND5";
$lang['disableunreadmessages'] = "di5@8L3 UNrEAd m3\$s4g35";
$lang['nocutoffdefault'] = "n0 cU+-OphpH (d3pH@ul+)";
$lang['1month'] = "1 MOn+H";
$lang['6months'] = "6 moN+hs";
$lang['1year'] = "1 Ye4r";
$lang['customsetbelow'] = "cU5+0M v4Lue (5e+ 83L0w)";
$lang['searchoptions'] = "s34rch 0p+i0n\$";
$lang['searchfrequency'] = "s34rch freqU3ncY";
$lang['sessions'] = "s3S510N\$";
$lang['sessioncutoffseconds'] = "seSS10N CuT 0phph (s3cOnd\$)";
$lang['activesessioncutoffseconds'] = "acTIv3 seS51ON cUt Ophf (second\$)";
$lang['stats'] = "stAtS";
$lang['hide_stats'] = "hId3 ST4+s";
$lang['show_stats'] = "sh0w St4ts";
$lang['enablestatsdisplay'] = "eN4ble St4+5 dI5PL4Y";
$lang['personalmessages'] = "p3Rs0n4L meS54gE\$";
$lang['enablepersonalmessages'] = "eN48L3 PERs0N4l mE5S4G3\$";
$lang['pmusermessages'] = "pM m3S\$4G3s p3r U53R";
$lang['allowpmstohaveattachments'] = "all0w p3r\$0N@L ME5S4g3S +0 h4vE 4+t4cHM3n+\$";
$lang['autopruneuserspmfoldersevery'] = "aU+0 pRun3 UseR'S pm f0ld3Rs 3veRY";
$lang['userandguestoptions'] = "uS3R and 9u3St OP+10n\$";
$lang['enableguestaccount'] = "en@8le gUeS+ 4Cc0unT";
$lang['listguestsinvisitorlog'] = "l1s+ 9uES+5 1n v151+0r lOG";
$lang['allowguestaccess'] = "allOW gu3\$T aCCesS";
$lang['userandguestaccesssettings'] = "u53R 4nd gU35t 4Cc3\$s \$Et+ingS";
$lang['allowuserstochangeusername'] = "allOW Users to cH@NG3 uSErn@me";
$lang['requireuserapproval'] = "rEQu1r3 U\$Er @PPR0V@L 8y @dMin";
$lang['enableattachments'] = "en4bl3 4++4chMEntS";
$lang['attachmentdir'] = "a+t4CHmeNt dIr";
$lang['userattachmentspace'] = "a++4chmen+ sp4ce per u5Er";
$lang['allowembeddingofattachments'] = "all0w 3M8eddING 0ph 4++4cHM3n+S";
$lang['usealtattachmentmethod'] = "usE 4l+eRN4tiv3 a++4CHM3nT m3+H0D";
$lang['allowgueststoaccessattachments'] = "aLL0w gU3st\$ +0 4ccE5s 4++@chmEn+S";
$lang['forumsettingsupdated'] = "f0Rum sEttIngs SUcce\$sfullY upD4+Ed";
$lang['forumstatusmessages'] = "f0Rum 5+@+u5 me5S4GeS";
$lang['forumclosedmessage'] = "fOrUm clOS3d ME5\$4GE";
$lang['forumrestrictedmessage'] = "f0ruM r3StRiCt3d M3\$\$4G3";
$lang['forumpasswordprotectedmessage'] = "f0RUm p45swOrd pR0+ected M3Ss49E";

// Admin Forum Settings Help Text (admin_forum_settings.php) ------------------------------

$lang['forum_settings_help_10'] = "<b>p0s+ Ed1+ t1meOut</b> 15 Th3 t1me 1N m1nut3s 4ph+eR p0\$TInG th4+ 4 uS3R c4n 3dI+ +HeiR p0\$T. 1F 53T tO 0 +H3re i\$ n0 L1m1T.";
$lang['forum_settings_help_11'] = "<b>m4xiMum pO\$T leng+h</b> 15 +3h m4x1mum NUmB3r 0F ch4rac+ERs +h4+ w1Ll bE d15pL4yed In A P0St. 1f 4 pO\$T 1s long3R +h4N +H3 Num83r OPh ch4R@c+ER5 D3PHiNED H3r3 I+ W1ll Be cu+ \$H0R+ 4nd 4 L1Nk 4Dd3d +0 +eh b0+T0m T0 4Ll0W u\$ERs +o r34d +3h whOL3 po5t On 4 S3p@r4tE P4Ge.";
$lang['forum_settings_help_12'] = "if j00 d0n'T w@N+ y0Ur uS3r\$ +0 83 4bL3 to cre4t3 POll\$ j00 c4n di54ble +H3 480vE Op+i0n.";
$lang['forum_settings_help_13'] = "tH3 L1nKS 5eCTi0N of 833H1Ve ProVIde5 4 pl4c3 PHoR Y0ur u5Ers to M4inT41n 4 li\$t oPh SItEs +HeY fRequEn+lY viSIt +H@+ OTh3r USErS mAy Phind uSEphUl. l1nKs c4n 83 d1vidEd 1nt0 C4te90r1e5 8Y pHoLDer @ND 4LLoW fOR coMm3n+S 4Nd R@TIn9S to b3 91vEn. in OrdEr to m0dEr4+3 th3 LiNk5 53cTi0N @ U5Er MuS+ b3 R@nTEd 9lO8@L M0DeR4tOR 5t4+u\$.";
$lang['forum_settings_help_15'] = "<b>sEsS1On cU+ 0FF</b> 1S +he M@x1Mum tImE b3For3 4 u53r'S se\$510N 1s d33m3d d34d @nD th3y 4RE lo99Ed OU+. 8Y D3f4UlT +H1\$ is 24 hOUrS (86400 s3cOndS).";
$lang['forum_settings_help_16'] = "<b>aC+1v3 \$eSSI0n cut 0fPh</b> IS thE m4X1mum time bEpHor3 4 U5ER'\$ s3SS10N 1s DEem3D 1N4c+1VE 4+ wh1Ch p0int +hey en+er an idl3 5T4T3. in thi5 ST4+3 +Eh user rem41nS l0G9ed 1N, Bu+ tH3y 4r3 r3m0v3d PhR0M th3 @ct1v3 us3r\$ L1S+ 1n th3 S+4+S dI5Pl4y. oncE tHey B3C0m3 4CTIv3 4941n theY wILl 8E R3-@dDEd To th3 l1s+. 8Y DePHauL+ tHI5 s3tTiN9 1S 5e+ TO 15 miNu+es (900 S3C0ndS).";
$lang['forum_settings_help_17'] = "eN4BL1ng +H1s 0p+I0n 4LlowS 8eeh1ve tO incLud3 4 \$T4+s d1Spl@y @+ +he 8o++OM 0f Th3 m3S54gE\$ p@nE S1m1l4r +O +hE one U\$3D by m@ny foruM 5oPHtw4Re T1TLe5. 0NC3 ENABLeD +3h dI5PL4y Oph +hE St4+S P4G3 c@n 83 +099led 1nd1V1du@lLY by E@ch U53r. 1F Th3y DoN't w@NT +0 5Ee i+ THeY C@N h1D3 i+ fROm v1Ew.";
$lang['forum_settings_help_18'] = "p3rsON4l mEs\$4g35 4r3 inv4Lu48l3 4s @ w4y 0ph +4KinG MorE prIV@+3 M4tT3Rs 0u+ OpH v1ew Of TH3 0+her meMb3R5. h0w3v3r 1F j00 doN'T w4Nt YOuR Us3RS +0 83 48L3 +0 SenD E@cH 0+HER PerS0n4l m3s\$49ES j00 C4N d1s48L3 +h15 0ptI0n.";
$lang['forum_settings_help_19'] = "perS0n4L meSS49eS CAn AlS0 conT41N 4tt4chmEN+\$ wh1Ch c@n 83 uS3PhuL PHOr EXCh@ngIN9 F1LE5 b3+W3eN u\$er5.";
$lang['forum_settings_help_20'] = "<b>nOt3:</b> th3 \$Pac3 4llOcati0n Ph0R pM @+t4Chm3N+\$ 15 t4ken PHROm 34cH u\$ERs' m4IN @t+4cHm3n+ 4LlOC4ti0N @nD Is NO+ in 4DD1+10n t0.";
$lang['forum_settings_help_21'] = "<b>en48le 9U3S+ @cc0Unt</b> 4ll0w5 v1sIT0rs +0 8ROw\$E yOUr pH0ruM and Re4d P0\$tS wi+h0u+ re9iStErIng A u\$Er aCC0uN+. @ usEr 4cC0Unt 1s \$+ILL r3QUirEd 1f +HEy w15h +o PO5t or cH@ng3 U5er Pr3pher3NcEs.";
$lang['forum_settings_help_22'] = "<b>l1\$T gUeS+5 1n VI5iTor Lo9</b> 4lLows J00 +0 sPEC1fY WH3tH3r OR N0T UnREg1s+eRed uSErS 4rE L15t3D on +He V1sitOR lO9 @lonG 51d3 re915teREd Us3r\$.";
$lang['forum_settings_help_23'] = "b33hiVE 4LL0w\$ 4++4cHmenTs +0 83 upl0@D3D +0 m3Ss4G35 when Po5Ted. 1f j00 H4V3 lIM1+Ed W3b \$P@cE J00 M4y whiCH tO DI548l3 @++4chM3Nt5 by cL34r1n9 +HE b0X @bOv3.";
$lang['forum_settings_help_24'] = "<b>a++4chmEN+ d1R</b> iS +eH loC@ti0N b3eh1ve \$HOuld \$tor3 i+'S 4t+@chmENt\$ 1n. THi\$ D1r3cToRY MuS+ 3xi5t 0N yOuR WEB sp4ce 4nD muST BE wr1T48lE by +He web \$ERver / phP proC3SS 0thERW15e UPl0@d5 w1Ll F4Il.";
$lang['forum_settings_help_25'] = "<b>at+4cHm3Nt Sp@c3 p3r u5er</b> 1s TH3 m4X1Mum 4m0unT OpH d15k \$p4c3 4 u53r HA\$ ph0r 4t+@cHmeN+5. ONcE THi5 \$P4C3 1S UsED uP t3h uSEr c4Nn0+ UPl04d 4Ny mOR3 4++4chM3nT5. bY DEPH4UlT +Hi5 I\$ 1mb 0Ph 5p4c3.";
$lang['forum_settings_help_26'] = "<b>alLow embeDd1ng 0f 4++4CHmen+\$ 1N me\$Sa93s / S19n@+ureS</b> 4LL0w\$ USErs +0 3M83d 4T+4ChMenT5 IN pOS+5. EN4bl1n9 +his 0P+i0n wH1Le U53Ful c4N INcre45E YouR b4NDw1d+H Us4Ge dr@5t1C4llY uNder cer+41n C0nF1GuR@+10n5 oF pHp. 1f J00 H4ve l1M1tED b4nDw1D+H 1t 1s r3CoMm3NdEd Th4T J00 D15@8LE th1\$ 0P+10n.";
$lang['forum_settings_help_27'] = "<b>usE 4Lt3rN@+1V3 4Tt4Chm3nT m3tH0D</b> F0rces BeEH1Ve to U\$3 4N AL+eRn4+1Ve reTRi3v4l M3thod fOR @+t4chm3Nt\$. 1F j00 rEC31VE 404 errOR m3\$\$4G3S WHeN +ry1N9 +0 dOWnlO@d 4tT4cHMenTS FR0m M3SS4g3\$ try en4blinG tH15 0PtION.";
$lang['forum_settings_help_28'] = "tH1S S3Ttin9 @llowS YoUr ph0Rum +0 83 spIdeRED 8y 5E4rch eng1Ne5 l1ke 9009l3, 4Lt4v1s+4 4nd Y@h00. 1pH j00 \$w1+cH TH1S opTi0n OFPH YOUR PH0rUM WiLl no+ bE InclUded 1N +heSe S3@rcH 3n91NES RE5ul+S.";
$lang['forum_settings_help_29'] = "<b>allOW N3w U5eR ReG15+r4+i0N5</b> @lL0WS 0r d154lLows tEH cRE4+Ion OF new usER @CC0UNt\$. sETTiNG +he oPtioN +o NO coMpL3t3lY DI\$@bLE5 +Eh r3915+r4+I0N f0rm.";
$lang['forum_settings_help_30'] = "<b>en4BLE Wik1w1kI 1Nte9ra+i0n</b> PR0v1dEs W1KiwOrd \$UPp0R+ 1n YoUR Ph0rUM POSt\$. 4 W1k1woRD 1s m@de uP OpH +wO or M0r3 ConC@+en@TEd WoRd5 With uppErc4\$E L3tt3R\$ (0F+en rePH3rRED +0 @5 C4M3lc@5e). Iph J00 Wr1+e 4 w0Rd +h15 w4y I+ W1lL 4U+OM@+1c4Lly b3 CH4nGed 1N+O @ HyP3rLiNk p0InTiNG +0 Your cho\$3N W1KiW1K1.";
$lang['forum_settings_help_31'] = "<b>en@Ble wik1W1ki Qu1Ck L1NKs</b> En48l3s +3H u\$e of MS9:1.1 @nd Us3R:lO90N \$tyle 3xt3Nd3D W1KilINK\$ wh1cH CRe4+E Hyperl1nkS +0 +eH \$peciF13d ME5S4g3 / usEr pRoPhIL3 oF tH3 speciPhiEd u5ER.";
$lang['forum_settings_help_32'] = "<b>wik1Wiki L0c@+10n</b> is U\$ED +0 sP3c1fy teh UR1 of youR wiK1Wik1. wH3n 3N+Er1ng TH3 uRi U5E [WIK1wOrd] +0 INDic@t3 WHEre 1n teH uRI Teh Wik1W0RD SH0uld 4pp34r, I.3.: <i>ht+P://3N.wIK1PEd14.0rg/WIk1/[W1kiw0rd]</i> wOULd LiNK YouR WIKiw0Rd5 To %s";
$lang['forum_settings_help_33'] = "<b>f0RUm @cc3sS sT4tU5</b> COntR0l5 how us3r\$ M4y 4cC3\$s your Ph0RuM.";
$lang['forum_settings_help_34'] = "<b>oPeN</b> WIlL 4llOW @ll U5eRS @Nd 9U3\$TS 4cC3s\$ to Y0uR pH0Rum WItHOUt r3sTRictI0n.";
$lang['forum_settings_help_35'] = "<b>cLo5ED</b> pR3V3n+\$ 4cc3\$5 pH0r 4Ll uS3rS, w1Th T3h eXCEPt1ON OpH thE 4dmiN WHO M@Y \$t1ll @cc3\$\$ t3H 4DMin P4n3l.";
$lang['forum_settings_help_36'] = "<b>r3\$+RIc+3D</b> 4ll0w\$ tO SeT 4 l1s+ 0ph u\$Er5 Wh0 4RE 4ll0WED 4cc3\$s +0 Y0ur PH0rUm.";
$lang['forum_settings_help_37'] = "<b>p455W0rd PrO+3Cted</b> @Ll0ws J00 to \$Et 4 p4ssw0Rd +0 91Ve OUT tO U5Er\$ S0 +HeY c4N 4cC3s5 YOuR FORuM.";
$lang['forum_settings_help_38'] = "when \$3+t1ng rES+r1C+ED 0R P@S5w0rd pR0tected Mod3 J00 will n33d To S4vE yOUr cH4n93s beph0re j00 C4n CH4ng3 th3 Us3R 4CCeS5 pr1V1l3Ge5 0r P@SSWOrD.";
$lang['forum_settings_help_39'] = "<b>Search Frequency</b> defines how long a user must wait before performing another search. Searches place a high demand on the database so it is recommended that you set this to at least 30 seconds to prevent \"search spamming\"pHR0M k1ll1n9 T3h 53rv3r.";
$lang['forum_settings_help_40'] = "<b>po\$T PHREquENcY</b> 1\$ t3h m1n1mum +ime 4 Us3R MuST w41t 83ph0rE tH3Y caN P0\$t @g4in. th1S SE+t1n9 4L\$0 @fph3cts Teh CrE4+10n 0Ph P0Ll5. s3+ +0 0 +0 DisA8l3 TH3 R35Tr1c+10n.";
$lang['forum_settings_help_41'] = "tHE 48Ove 0p+1On5 cH4nG3 t3H d3Ph@uLT V@lUe5 PhOr +Eh U5Er Re9iSTR@+10N F0rM. wh3Re 4ppL1C4blE 0th3R \$3TtiNgS W1lL Us3 tH3 ph0RuM'\$ 0wn d3F@Ul+ setTinGS.";
$lang['forum_settings_help_42'] = "<b>prEveN+ U53 oF DUplIc@+E em4iL addR3SSes</b> PH0rc3S 8e3Hiv3 +0 CHeCk +3h UseR 4Cc0uN+5 @941N\$+ +he EM@1L 4ddReSS +h3 USeR is R391STeriN9 WiTH @Nd PROmpt\$ theM t0 u5E 4n0+HEr IpH 1t 1s @LR34dy 1n U\$e.";
$lang['forum_settings_help_43'] = "<b>r3Quire Em4il C0NPhirM4tIon</b> WHen 3n48LeD w1lL 5End 4n EM4iL tO EAch neW U5Er wi+H 4 lInK TH@+ C4n bE u\$eD TO cONpH1rM +h31R eM4il @dDr3\$S. uN+1L tH3y cOnF1rM tH31r EM4il 4DdreSs +H3y wiLl No+ 83 @8L3 t0 pO5t UNl3s5 th3Ir U\$er perM1S51on\$ 4Re cH4ngEd m4nU4Lly BY 4N @dm1N.";
$lang['forum_settings_help_44'] = "<b>uS3 +eXT-c4pTch4</b> PResENtS +eH n3w USEr W1+H 4 M4n9lEd iM49E wh1Ch TH3y MUs+ cOPY @ nUmBEr Phr0m 1Nt0 4 t3X+ fielD 0N tEH r3G15TR4+1On PHorm. u\$E th1S Opti0n to pr3v3n+ 4u+om4+ed S1gn-up VI@ \$Cr1p+s.";
$lang['forum_settings_help_45'] = "<b>tEX+-c4ptcH@ direc+0ry</b> SPec1F1e5 +he Loc4+10n +ha+ 833H1v3 wiLl \$+0Re 1T'S T3X+-c4p+CHa im4gE\$ @Nd FoNtS In. tHi\$ D1reCt0rY mU\$+ 8E wR1t48le 8y +h3 w3b SerVeR / Php pR0ceSs 4nd MU\$t bE 4CC3\$51Bl3 VI@ H+tP. 4Ft3r J00 H4vE 3n48LeD +3x+-C4P+ch4 J00 must uPl04D \$0mE TRu3 TYpE ph0n+5 1NTo +3H PH0n+s 5UB-d1ReCT0ry 0Ph Y0UR m4IN t3x+-C4ptCH@ D1REcT0RY O+HERWI\$3 b33H1vE wiLL Skip The TEXt-c4P+Ch4 dUriN9 Us3r re91StR@t1oN.";
$lang['forum_settings_help_46'] = "<b>Text Captcha key</b> allows you to change the key used by Beehive for generating the text captcha code that appears in the image. The more unique you make the key the harder it will be for automated processes to \"guess\"T3H COde.";
$lang['forum_settings_help_47'] = "<b>pO\$T ediT Gr@C3 PerIOD</b> aLL0W\$ j00 +O d3F1n3 A pERIod 1N m1Nu+Es WHeR3 u\$3R5 m@y 3d1+ pos+5 W1th0U+ thE '3dit3d 8Y' +3x+ 4pP34r1nG 0n +h31r p0S+s. iPh \$3T +o 0 +H3 'eD1t3d 8y' t3X+ w1LL 4Lw@y\$ @Pp3@R.";
$lang['forum_settings_help_48'] = "<b>uNre4D M3S54Ges cut-0PHpH</b> 5Pec1fIe\$ how lOng UnrE4D m3ss49E\$ 4r3 re+41Ned. J00 M4Y cHOO\$3 From v4R10U5 Pr3set V@Lu35 or en+3r y0ur OwN cU+-0Phf PeR10D In SecOndS. THrE4DS mOd1F13D 3aRLi3R +H@n TH3 DEF1NeD cUT-0phPH p3r10d wIlL @UtOm4t1c4LlY @pPe4r 4\$ R34D.";
$lang['forum_settings_help_49'] = "cHo0sING <b>dIs48l3 UnR34D mes549eS</b> w1lL c0mpLe+ely reM0V3 uNr34d mEs54ge5 sUppoRt @ND R3Mov3 ThE reL3V4nt OPT10n\$ FrOm tHe DI\$CU\$s10N Type drOP d0wn ON +H3 THr34d L15+.";
$lang['forum_settings_help_50'] = "<b>r3Qu1r3 Us3r 4ppRoV@l 8y ADMiN</b> @LlOw\$ j00 T0 R3stric+ 4CcE5S 8y NEw uS3R5 UnTiL +heY H@VE 8e3N 4Ppr0V3d by 4 Moder4tOR 0R 4dM1N. W1+hou+ 4ppr0v@L 4 U53r C@nNot 4CCE\$s @NY 4Re4 0f t3H b33h1v3 FORum InST4LL@+10N INCludInG 1nD1V1du4L forUMs, Pm iNb0X 4ND MY FOrUm5 secTI0nS.";
$lang['forum_settings_help_51'] = "u5E <b>cLO\$3d m3Ss49e</b>, <b>r3\$+r1CT3d meS549E</b> 4nd <b>p@S5wORd pr0t3Ct3d Mes54ge</b> +0 CU\$+0mi\$E T3h ME\$s49e d1SPl@y3d wHen U\$3R\$ @cce55 your f0Rum iN +he v4R10u5 ST4TeS.";
$lang['forum_settings_help_52'] = "j00 Can u\$e h+Ml IN y0ur meS\$49Es. hypErLInk5 4nd 3m@Il @ddr3S\$E\$ wIll 4l50 83 4uTOm4tic4lLY ConV3Rt3d tO LInK\$. +O USe THe d3Ph4ulT B3eH1Ve foRuM M3S\$@93\$ cl34r +hE f1elD\$.";
$lang['forum_settings_help_53'] = "<b>aLl0W uSer\$ TO chAnge U5Ern4me</b> pERm1t\$ @lRE4dy r3915+eR3d us3r\$ tO cH4ngE th31r u\$eRN4m3. wHen en48LEd J00 c4n Tr4Ck teh ch@N9E5 4 U5er M@ke5 t0 TH31r u53rN4Me V14 THe 4DMIN Us3R tOOl5.";

// Attachments (attachments.php, get_attachment.php) ---------------------------------------

$lang['aidnotspecified'] = "aid nO+ \$pec1phI3D.";
$lang['upload'] = "upl04d";
$lang['uploadnewattachment'] = "uPlO@D n3w 4+T4chM3N+";
$lang['waitdotdot'] = "w41T..";
$lang['successfullyuploaded'] = "sUCcesSfULly upLO@dED";
$lang['failedtoupload'] = "f41Led to UPl04d";
$lang['complete'] = "comPl3t3";
$lang['uploadattachment'] = "uPL0@d 4 f1L3 F0r ATt4chm3N+ +0 +3h M3\$S@9E";
$lang['enterfilenamestoupload'] = "enT3r PHilEn4ME(s) t0 upLo4d";
$lang['attachmentsforthismessage'] = "at+4cHmEn+\$ fOr tHi\$ meS549e";
$lang['otherattachmentsincludingpm'] = "oTHEr 4ttAchm3n+5 (1nclUdiNg PM meS54ge5 @Nd 0TH3R PhoRum5)";
$lang['totalsize'] = "t0+4L s1Ze";
$lang['freespace'] = "fRE3 \$P4ce";
$lang['attachmentproblem'] = "thErE W4\$ 4 PRo8LEM dOwnlO4d1n9 tH15 4++4chM3n+. pl34Se +rY @g@iN l@+eR.";
$lang['attachmentshavebeendisabled'] = "at+4ChMen+5 h@v3 8E3N d154bl3d by +3H f0ruM 0Wn3r.";
$lang['canonlyuploadmaximum'] = "j00 c@N 0nLy uPlo@d 4 M4x1muM oF 10 F1LeS 4+ 4 +iMe";
$lang['deleteattachments'] = "d3LEtE 4+t4chm3Nt\$";
$lang['deleteattachmentsconfirm'] = "ar3 J00 \$urE J00 w@NT tO dEleT3 +Eh sel3cteD 4+T@chmeNts?";
$lang['deletethumbnailsconfirm'] = "aRe j00 SuRe j00 W4n+ to dELe+3 tH3 sEL3c+ed @+t4cHm3n+\$ tHum8N@iLs?";

// Changing passwords (change_pw.php) ----------------------------------

$lang['passwdchanged'] = "p4S\$WOrD CHaN93D";
$lang['passedchangedexp'] = "y0UR p455wORD haS b3En cHan9ed.";
$lang['updatefailed'] = "upDat3 PH41l3D";
$lang['passwdsdonotmatch'] = "p@s\$WorD\$ d0 nO+ m4tch.";
$lang['allfieldsrequired'] = "aLl f1elDs @R3 RequIr3D.";
$lang['requiredinformationnotfound'] = "rEQUiRed iNph0Rm4+10N n0+ F0unD";
$lang['forgotpasswd'] = "f0rGO+ p45sw0rd";
$lang['enternewpasswdforuser'] = "eN+eR 4 N3W p455wOrd F0r U\$Er %s";
$lang['resetpassword'] = "re53+ p@5Sw0RD";
$lang['resetpasswordto'] = "r3\$3+ p@5sWORd t0";

// Deleting messages (delete.php) --------------------------------------

$lang['nomessagespecifiedfordel'] = "nO m3S54ge SP3c1FIEd FoR D3L3+I0N";
$lang['deletemessage'] = "dEL3+3 meS\$493";
$lang['postdelsuccessfully'] = "p0\$t d3l3T3d \$UccE\$sPHuLly";
$lang['errordelpost'] = "erROr d3L3+IN9 pO\$t";
$lang['cannotdeletepostsinthisfolder'] = "j00 c@nnO+ D3Le+3 pO5Ts in th1s f0lD3r";

// Editing things (edit.php, edit_poll.php) -----------------------------------------

$lang['nomessagespecifiedforedit'] = "no meS\$4GE \$PeciFiED F0r 3D1+1NG";
$lang['cannoteditpollsinlightmode'] = "c4NN0+ Ed1T p0llS In l1gh+ Mod3";
$lang['editedbyuser'] = "edIT3D: %s 8Y %s";
$lang['editappliedtomessage'] = "edi+ 4pPlIed +o M3S54g3";
$lang['errorupdatingpost'] = "eRrOr Upd4tin9 p0\$+";
$lang['editmessage'] = "eD1+ M3\$S493 %s";
$lang['editpollwarning'] = "<b>no+e</b>: eDIt1ng c3R+@in 4SP3cTS 0f A pOLL W1lL VoiD 4ll thE cuRr3NT vO+ES 4ND @lLOW pe0Pl3 +0 v0+3 494In.";
$lang['hardedit'] = "h@Rd EDIT OpTi0N\$ (Vo+3\$ w1ll BE r3sE+):";
$lang['softedit'] = "s0f+ edi+ 0P+10n5 (V0t3S wiLl 8E r3+@1n3D):";
$lang['changewhenpollcloses'] = "ch4n9E wh3N +H3 Poll clo535?";
$lang['nochange'] = "n0 cH@ng3";
$lang['emailresult'] = "eM4il ReSul+";
$lang['msgsent'] = "mEs\$493 \$3N+";
$lang['msgsentsuccessfully'] = "m3s549E s3n+ 5ucce5SfULly.";
$lang['msgfail'] = "m3S\$493 pH4ILed";
$lang['mailsystemfailure'] = "m41L \$y5tEm PH41LUr3. M3\$s4G3 no+ \$En+.";
$lang['nopermissiontoedit'] = "j00 @rE N0t P3rm1Tt3D tO 3d1T th1S mES54g3.";
$lang['cannoteditpostsinthisfolder'] = "j00 c4nNoT 3D1+ P0S+5 1n TH15 PHolDer";
$lang['messagewasnotfound'] = "mE\$54Ge %s w@S NOt found";

// Email (email.php) ---------------------------------------------------

$lang['nouserspecifiedforemail'] = "nO us3R Sp3c1F1ED For 3m41liNg.";
$lang['entersubjectformessage'] = "en+ER @ 5ubj3cT foR thE meSS493";
$lang['entercontentformessage'] = "eNtER 5omE c0Nt3NT PhOr +HE mE55@ge";
$lang['msgsentfromby'] = "tHIS meS54g3 w4\$ seNt phR0M %s 8y %s";
$lang['subject'] = "su8JeC+";
$lang['send'] = "seNd";
$lang['hasoptedoutofemail'] = "h@S 0P+ED 0u+ Of 3M4il c0n+@c+";
$lang['hasinvalidemailaddress'] = "h4s 4n INv@Lid em41l @ddreSs";

// Message nofificaiton ------------------------------------------------

$lang['msgnotification_subject'] = "mE\$54ge n0t1fIc4+i0n FRom %s";
$lang['msgnotificationemail'] = "%s P0\$t3d @ m35s4ge tO J00 0n %s\n\n+he su8j3Ct I\$: %s\n\nTO r3Ad +H4+ M3ss4Ge 4Nd O+HERS in +h3 54ME d1scUSS1ON, 9O TO:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nNO+3: 1PH j00 dO nO+ wisH T0 r3ceive em@1L nOtIpHiC4+10n5 0Ph f0RuM ME\$S4g3S pO\$T3D +O y0U, gO +0: %s ClICK 0N MY c0NtR0L\$ +hEN 3maIl 4Nd Pr1v4Cy, uN\$EL3C+ +3H eM4iL No+IF1c4T1oN CH3cK80X 4ND Pre\$S \$UBm1T.";

// Thread Subscription notification ------------------------------------

$lang['subnotification_subject'] = "sU85cr1pti0n nOTifIc@TI0N fR0m %s";
$lang['subnotification'] = "%s pOSteD A M3\$\$@ge 1n 4 +hRE4d j00 H4VE \$u85cri83d +0 0N %s\n\ntHE \$ubjEct is: %s\n\nt0 R3AD +H4t m3\$s4G3 4Nd 0tH3r\$ 1n t3h \$4me d1sCussiON, 90 +O:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nn0+3: iF J00 d0 N0+ w15H +0 rEcE1vE 3maiL n0+1f1C4+i0nS 0ph NeW m35SaGE5 1N tHiS tHr34D, 9O tO: %s 4Nd @DjuST yoUR In+3R3\$t l3VeL 4+ ThE BO+tOm of T3h P4g3.";

// PM notification -----------------------------------------------------

$lang['pmnotification_subject'] = "pm n0tipHic@+10n PHR0m %s";
$lang['pmnotification'] = "%s p0St3D 4 pm to J00 0n %s\n\ntH3 \$U8j3ct 1S: %s\n\n+O r34d tEH m3S5493 90 +O:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nN0+e: 1F j00 DO NO+ w1sH +0 rec3Ive Em4il N0+1F1C4+i0N5 0Ph NEW pM Me\$54g3\$ p05t3D +0 y0U, 9o +0: %s Cl1cK mY c0N+r0l5 +HEN 3m@il 4Nd pR1v4Cy, Un5EL3C+ +H3 pm NO+IfIC4+10n CheCkBOX 4Nd Pr3\$S SU8M1t.";

// Password change notification ----------------------------------------

$lang['passwdchangenotification'] = "pa\$5WoRd cH4N9e n0+IF1c@T10n FR0m %s";
$lang['pwchangeemail'] = "tH1\$ @ NO+IF1c4+i0n eM4Il t0 iNForM J00 th4+ YouR P@55WORd 0n %s h@5 833N cH@n9ED.\n\n1+ h4\$ bEen ch@N9ED +0: %s 4Nd W45 Ch4n9Ed bY: %s\n\niF j00 h4v3 r3cE1vED ThIs 3m@1l 1N 3rrOR or W3R3 NO+ exP3cT1Ng 4 cH@ng3 To y0ur p@55WOrd ple4\$3 cOnT4cT T3H FORuM 0wn3R or @ m0Der4+oR ON %s iMm3DI4+elY +o C0rREcT I+.";

// Email confirmation notification -------------------------------------

$lang['emailconfirmationrequired'] = "em41L c0NPhiRm4+ioN REqU1Red ph0r %s";
$lang['confirmemail'] = "h3LlO %s,\n\nY0U R3cently Cr34+ed 4 neW u5Er 4ccouN+ 0N %s\n8Ef0r3 J00 C4N ST@Rt Po5T1n9 We n33d +0 cOnFirm your em4il ADdrEsS. d0N'+ wOrrY +h15 15 Qui+E 345y. 4LL J00 neEd +0 do IS cL1ck Th3 l1nK belOw (0R c0py @nd P4\$te i+ 1n+0 yOuR BRoWSeR):\n\n%s\n\nonce c0NFIrM@T1oN 15 cOMplEte j00 MaY l0gIN 4Nd ST4r+ P05t1n9 1mm3dI4T3Ly.\n\niF J00 dId N0t CrEAt3 4 u\$eR 4cCoUn+ ON %s PlE@53 4CcEPT 0UR ApOL09IeS 4nD F0Rw4rd +hi\$ em41L TO %s 5O +h4+ +h3 \$oURC3 0ph it m4Y 83 iNv3\$tIg4+3D.";

// Forgotten password notification -------------------------------------

$lang['forgotpwemail'] = "j00 r3QuEs+3D +h1\$ e-M4il PhroM %s B3caUse j00 h4v3 FOR9O+tEN yOuR p@5\$w0rd.\n\nCLicK +3h l1Nk b3loW (0r c0Py 4ND p4St3 iT 1NtO yoUr 8r0wsER) tO R3SE+ y0Ur P@5sWOrD:\n\n%s";

// Forgotten password form.

$lang['passwdresetrequest'] = "yoUR p@s\$w0rd REs3T r3QUe5t pHr0M %s";
$lang['passwdresetemailsent'] = "p4Ssw0rD R3\$3+ e-m41l 5En+";
$lang['passwdresetexp'] = "j00 Sh0ULD r3ce1v3 4n e-m41l COntA1n1N9 inSTrucT1ons pHor r3\$E+T1Ng Y0ur p45sWord SHOr+ly.";
$lang['validusernamerequired'] = "a V@lID U53rn4me 1S reQuiRed";
$lang['forgottenpasswd'] = "f0R9o+ p@5Sw0rd";
$lang['forgotpasswdexp'] = "if j00 h4ve pHORG0+TeN y0uR p4SSwoRd, J00 c4N ReQu3\$T +O h@ve 1+ ResET bY Ent3R1ng Y0Ur L0G0n N@mE belOw. inSTruct10n\$ On how t0 reSet your P@55word w1ll be 5en+ +0 yOuR r3915Ter3d EM4IL 4ddrE5S.";
$lang['couldnotsendpasswordreminder'] = "cOULD n0t \$End p@55word R3m1ndeR. plE4\$E C0Nt@c+ THe FOruM OWnER.";
$lang['request'] = "rEQUeST";

// Email confirmation (confirm_email.php) ------------------------------

$lang['emailconfirmation'] = "eM@Il CONf1rm4+10N";
$lang['emailconfirmationcomplete'] = "th4NK J00 pH0r C0NPhiRMinG Y0Ur 3M@IL 4DDRe5s. J00 m4y N0w L091N anD \$t4Rt Po5T1ng iMm3d14+3Ly.";
$lang['emailconfirmationfailed'] = "em4IL c0NpHirM4Ti0n H@5 f4ilED, Ple4S3 +ry 4g4in Lat3r. if j00 eNCoUnT3R ThI\$ eRr0r mULt1pLE Tim3\$ pl3A\$e c0N+4ct tEH phORUm 0WNer 0r @ M0d3R4+0R ph0r 45\$I5t4Nce.";

// Links database (links*.php) -----------------------------------------

$lang['toplevel'] = "tOP L3vEL";
$lang['maynotaccessthissection'] = "j00 M4y No+ 4cCe\$s TH1S 5EctI0N.";
$lang['toplevel'] = "t0P LevEl";
$lang['links'] = "l1NK\$";
$lang['viewmode'] = "viEw mOd3";
$lang['hierarchical'] = "h1ER4rchic@l";
$lang['list'] = "lI5t";
$lang['folderhidden'] = "tHI5 PhOlD3R I\$ HIdd3n";
$lang['hide'] = "hiD3";
$lang['unhide'] = "uNhid3";
$lang['nosubfolders'] = "no 5U8FOLd3R\$ In +hiS c@+E9oRy";
$lang['1subfolder'] = "1 su8PH0LdER IN ThI5 c@+e9ORY";
$lang['subfoldersinthiscategory'] = "su8F0ld3R\$ 1n Th1s C@+E9OrY";
$lang['linksdelexp'] = "entR13\$ 1n 4 DEleT3d PH0Lder w1ll 83 MoV3d T0 tH3 P4r3n+ f0ld3R. oNLy f0LdEr\$ WH1cH dO NOt C0n+41N SU8FoLd3R5 m4y be d3l3t3d.";
$lang['listview'] = "lI5+ v1Ew";
$lang['listviewcannotaddfolders'] = "c4NNO+ @DD phoLD3R\$ in tH15 v1EW. Sh0w1n9 20 Entr1es @+ 4 +im3.";
$lang['rating'] = "r4ting";
$lang['nolinksinfolder'] = "nO liNks in +h1s ph0lDEr.";
$lang['addlinkhere'] = "aDd Link H3R3";
$lang['notvalidURI'] = "tH4+ iS N0+ @ v@l1d ur1!";
$lang['mustspecifyname'] = "j00 muST Sp3C1fy 4 n4M3!";
$lang['mustspecifyvalidfolder'] = "j00 MU5T speciPhy @ v@lid fOld3r!";
$lang['mustspecifyfolder'] = "j00 mU\$T spEciFY 4 ph0ld3R!";
$lang['addlink'] = "add 4 l1nk";
$lang['addinglinkin'] = "aDd1N9 link 1n";
$lang['addressurluri'] = "adDrES5 (URL/Ur1)";
$lang['addnewfolder'] = "add 4 nEW pHoldeR";
$lang['addnewfolderunder'] = "aDdIn9 n3W Ph0Ld3r UndeR";
$lang['mustchooserating'] = "j00 mU\$+ ch00\$e @ r@tIN9!";
$lang['commentadded'] = "yoUR c0MmEnT W4S 4dd3D.";
$lang['musttypecomment'] = "j00 mU5+ +YP3 A c0MmeNt!";
$lang['mustprovidelinkID'] = "j00 mU\$t pROVidE 4 l1Nk 1D!";
$lang['invalidlinkID'] = "iNval1D Link 1d!";
$lang['address'] = "aDdr3\$\$";
$lang['submittedby'] = "sUbm1+teD 8Y";
$lang['clicks'] = "clIcK\$";
$lang['rating'] = "r@T1N9";
$lang['vote'] = "vOT3";
$lang['votes'] = "vo+ES";
$lang['notratedyet'] = "n0+ R@t3D 8y 4nYoN3 Y3t";
$lang['rate'] = "ra+3";
$lang['bad'] = "b@D";
$lang['good'] = "good";
$lang['voteexcmark'] = "vOtE!";
$lang['commentby'] = "c0MMent 8Y %s";
$lang['addacommentabout'] = "aDd 4 c0Mm3n+ @80ut";
$lang['modtools'] = "m0D3R4T10N tOoL5";
$lang['editname'] = "eDIT n@mE";
$lang['editaddress'] = "eD1+ @dDre\$\$";
$lang['editdescription'] = "edI+ de\$cRIp+I0n";
$lang['moveto'] = "movE TO";
$lang['linkdetails'] = "liNK dEt41l5";
$lang['addcomment'] = "aDD C0mmeNt";
$lang['voterecorded'] = "y0ur v0t3 h45 B3EN rec0rd3D";

// Login / logout (llogon.php, logon.php, logout.php) -----------------------------------------

$lang['loggedinsuccessfully'] = "j00 L09g3D 1n SuCCEssfUlLy.";
$lang['presscontinuetoresend'] = "prE5s coN+1nU3 T0 rE5END FORm d4T4 Or c4Ncel +0 R3lo@d p@G3.";
$lang['usernameorpasswdnotvalid'] = "teh U\$3Rn4Me Or p4sswORd j00 \$UPplIED 15 n0T v4lId.";
$lang['pleasereenterpasswd'] = "pLE@5E RE-EN+Er yOuR p4\$SWoRd @nD TRy 4g41N.";
$lang['rememberpasswds'] = "rem3M83R p45\$W0rD5";
$lang['rememberpassword'] = "rEmEM83R p4s5w0Rd";
$lang['enterasa'] = "eN+3r @5 4 %s";
$lang['donthaveanaccount'] = "d0N'+ H4V3 @n 4cc0Un+? %s";
$lang['registernow'] = "r3gisT3r noW.";
$lang['problemsloggingon'] = "pROBleMs lO991ng On?";
$lang['deletecookies'] = "dEleTE CoOKiEs";
$lang['cookiessuccessfullydeleted'] = "coOK1E5 succ3SsFUllY dEle+3d";
$lang['forgottenpasswd'] = "f0R90+TEn youR p455WorD?";
$lang['usingaPDA'] = "u5InG 4 pd4?";
$lang['lightHTMLversion'] = "l1gH+ html v3R\$I0n";
$lang['youhaveloggedout'] = "j00 h4VE l099eD Out.";
$lang['currentlyloggedinas'] = "j00 arE CurreN+LY L099ed 1n 4\$ %s";
$lang['logonbutton'] = "l0GoN";
$lang['otherbutton'] = "otH3r";

// My Forums (forums.php) ---------------------------------------------------------

$lang['myforums'] = "my phOrum5";
$lang['recentlyvisitedforums'] = "rec3ntly vIsi+eD fOruMs";
$lang['availableforums'] = "aV4il4bLe PHoRuM5";
$lang['favouriteforums'] = "f4V0Ur1+e FOruM\$";
$lang['lastvisited'] = "l4ST v1s1+ed";
$lang['forumunreadmessages'] = "%s UnRe4d ME\$sA93\$";
$lang['forummessages'] = "%s m3S\$@ge5";
$lang['forumunreadtome'] = "%s UNRE4D &quot;t0: m3&quot;";
$lang['forumnounreadmessages'] = "n0 UNRE4d me5s@93s";
$lang['removefromfavourites'] = "r3m0ve FRom PH@v0Ur1+eS";
$lang['addtofavourites'] = "adD To ph4V0Ur1tEs";
$lang['availableforums'] = "av4IL@8L3 PhorUm5";
$lang['noforumsavailable'] = "tHER3 4rE n0 F0rUms 4v@il@BLe.";
$lang['noforumsavailablelogin'] = "therE @rE N0 phOrUm5 4V4il4Ble. ple@s3 lOG1n t0 V1ew your f0RuMs.";
$lang['passwdprotectedforum'] = "p4SsWOrd pr0T3CTED phOrUM";
$lang['passwdprotectedwarning'] = "tHi5 PH0Rum i5 p4\$5wOrd Pro+ect3D. +0 g4in 4cceSs 3n+3r +he p4\$SWoRd beL0W.";

// Message composition (post.php, lpost.php) --------------------------------------

$lang['postmessage'] = "poS+ m3\$\$4GE";
$lang['selectfolder'] = "seLECt ph0lD3R";
$lang['mustenterpostcontent'] = "j00 MuS+ eNt3R s0m3 cont3n+ FOR t3h po5t!";
$lang['messagepreview'] = "mEss4G3 preV1Ew";
$lang['invalidusername'] = "inV4l1d u\$ern4m3!";
$lang['mustenterthreadtitle'] = "j00 MuST 3n+er 4 t1+le PHor +3h thre4d!";
$lang['pleaseselectfolder'] = "pl3aS3 \$3l3ct @ F0ld3R!";
$lang['errorcreatingpost'] = "eRror Cr34t1n9 Po\$t! pL34\$E try 494In iN 4 FEw m1nu+ES.";
$lang['createnewthread'] = "cR3@+E n3w ThrE@d";
$lang['postreply'] = "p0St r3pLy";
$lang['threadtitle'] = "thre4D T1Tl3";
$lang['messagehasbeendeleted'] = "m3S\$49e nO+ F0Und. cH3ck +H4T i+ h4Sn't BeEn d3l3+ed.";
$lang['messagenotfoundinselectedfolder'] = "mESs@9e nOt ph0und 1N 5elec+ed FOldEr. ch3ck th4t 1T H4\$n't BE3N mOved or Del3Ted.";
$lang['cannotpostthisthreadtypeinfolder'] = "j00 c4nno+ p0\$t +hi5 +HrE4d +yP3 1n Th@+ f0ld3R!";
$lang['cannotpostthisthreadtype'] = "j00 c@nn0+ p0s+ +h15 +HRe4d +ypE 4\$ +HeR3 4RE nO @v41l48LE fOlD3r\$ thaT 4Ll0w it.";
$lang['cannotcreatenewthreads'] = "j00 c@NnO+ cR3@tE new +hr34d5.";
$lang['threadisclosedforposting'] = "thiS +hre4d 1S CL0\$ed, J00 C4nnO+ P0St IN 1+!";
$lang['moderatorthreadclosed'] = "w4RNInG: +h15 +hrE4D 1\$ cL0\$ed f0r P0st1N9 t0 N0rm@L u5ErS.";
$lang['threadclosed'] = "thRE4d CL0sed";
$lang['usersinthread'] = "uS3R\$ iN tHr34d";
$lang['correctedcode'] = "c0rRect3d cod3";
$lang['submittedcode'] = "sU8Mitted COd3";
$lang['htmlinmessage'] = "hTml in Me5S493";
$lang['disableemoticonsinmessage'] = "d1s48l3 3MO+Ic0n\$ 1N MeS54Ge";
$lang['automaticallyparseurls'] = "autOM4tic4lly p@rse urL5";
$lang['automaticallycheckspelling'] = "au+Om@+ic4llY CH3ck 5PELlIN9";
$lang['setthreadtohighinterest'] = "s3T +hrE@D +0 H1Gh 1N+eReSt";
$lang['enabledwithautolinebreaks'] = "en4bL3D w1th 4UtO-LiNE-br34K5";
$lang['fixhtmlexplanation'] = "tH1\$ pHORum U53S html phiL+ER1ng. y0Ur \$U8m1+TEd Html H@5 8e3N M0D1F1ed 8Y Th3 f1lT3RS 1n S0Me W4Y.\\n\\nto vi3w YOuR OrIG1n4L c0DE, \$el3cT +hE \\'5U8Mi+T3d cODe\\' r4d10 8U+ToN.\\nt0 VI3w +h3 mOd1F1ed c0d3, S3L3c+ +Eh \\'c0rR3C+3D C0D3\\' R4Di0 8u+tON.";
$lang['messageoptions'] = "m3SS493 OP+10N\$";
$lang['notallowedembedattachmentpost'] = "j00 4r3 NO+ 4LlOweD to 3MB3d @+t4ChM3n+5 1N yOUr Po\$TS.";
$lang['notallowedembedattachmentsignature'] = "j00 4R3 N0+ 4llOWeD t0 eM83D @TT@chmeNt\$ 1n YOUr s1Gn4+ur3.";
$lang['reducemessagelength'] = "m3\$s4gE LEN9+H mU\$T BE uNDEr 65,535 cH4r4c+eRS (CURren+Ly:";
$lang['reducesiglength'] = "sIgN4+ure LENGth mU5t Be undEr 65,535 ch4R4Ct3rs (curR3NtlY:";
$lang['cannotcreatethreadinfolder'] = "j00 cANN0+ crE4+3 new +HR3@Ds 1n +h1S ph0Ld3r";
$lang['cannotcreatepostinfolder'] = "j00 c4Nn0+ rEplY +0 pO5tS 1n tHi\$ fOld3r";
$lang['cannotattachfilesinfolder'] = "j00 c4nN0+ po5T 4+t4chm3nT\$ In tH15 phOLD3r. ReMov3 4++4chM3Nt\$ +O cOn+InUE.";
$lang['postfrequencytoogreat'] = "j00 cAN ONlY p05T onC3 3V3Ry %s Sec0nd\$. Pl3asE TRy 4g4In l4ter.";
$lang['emailconfirmationrequiredbeforepost'] = "eM4il c0nFirM@T10n i5 ReqUir3d 83ph0r3 j00 cAn p0\$T. 1F j00 h4Ve no+ R3c31V3D @ c0npHIrm4+1On em@1l PLe@Se cl1ck +3H 8uT+0n 83LoW 4Nd 4 New 0n3 WIll 8e SEnt to YoU. IpH YoUR 3M@1L 4ddrE\$s neeDS ch4ngIN9 pL3@5E d0 SO 83phOr3 R3Qu35+in9 4 NEW c0nFIRm4+iOn 3M4Il. J00 M@y Ch4Nge yoUR 3M@iL 4DdReS5 by ClICk my c0Ntr0lS 48ovE 4nd theN uS3r DEt4ILs";
$lang['emailconfirmationfailedtosend'] = "c0NFIrm4+I0n 3M4il fA1l3d +O 53nd. pLe4\$e c0n+4c+ teH f0rum OwNER tO R3c+ifY tH15.";
$lang['emailconfirmationsent'] = "coNPHiRm4+i0n EM4il Ha\$ bEen r3\$3N+.";
$lang['resendconfirmation'] = "r3SENd c0NfirM@ti0N";
$lang['userapprovalrequiredbeforeaccess'] = "y0ur uSER @cc0UN+ need5 tO b3 @ppr0ved 8Y @ F0ruM @dM1n b3PhoR3 J00 c4N 4cce5S th3 r3quE5+3D pHoRUM.";

// Message display (messages.php & messages.inc.php) --------------------------------------

$lang['inreplyto'] = "iN r3ply +o";
$lang['showmessages'] = "sh0W mE5S49ES";
$lang['ratemyinterest'] = "r4+e My 1Nter3St";
$lang['adjtextsize'] = "adju\$t tex+ sIZe";
$lang['smaller'] = "sM4LleR";
$lang['larger'] = "larGEr";
$lang['faq'] = "f4Q";
$lang['docs'] = "dOC\$";
$lang['support'] = "sUppoRt";
$lang['donateexcmark'] = "don4Te!";
$lang['threadcouldnotbefound'] = "tH3 r3qu3S+3d +hr3ad C0uld No+ bE ph0Und 0r 4Cc3S\$ w@\$ dEn1ed.";
$lang['mustselectpolloption'] = "j00 mu5t \$El3CT 4N 0p+I0n +0 v0+e fOR!";
$lang['mustvoteforallgroups'] = "j00 MU\$+ Vo+3 1N ev3Ry gROup.";
$lang['keepreading'] = "ke3P re4DIn9";
$lang['backtothreadlist'] = "b4Ck t0 Thre4D L15t";
$lang['postdoesnotexist'] = "th4+ pO\$+ dOes N0+ EX15t 1N thIs +HRe@D!";
$lang['clicktochangevote'] = "cLicK +0 ch4Nge Vo+3";
$lang['youvotedforoption'] = "j00 vo+Ed phOr Op+I0n";
$lang['youvotedforoptions'] = "j00 VO+ed F0r 0P+i0n\$";
$lang['clicktovote'] = "cLICk +0 v0+3";
$lang['youhavenotvoted'] = "j00 h4v3 NO+ V0+ED";
$lang['viewresults'] = "vIew R35ultS";
$lang['msgtruncated'] = "mEsS4g3 +RUnc4+ed";
$lang['viewfullmsg'] = "vIeW FUll M3sS493";
$lang['ignoredmsg'] = "igN0r3d m3S54ge";
$lang['wormeduser'] = "wOrm3d USeR";
$lang['ignoredsig'] = "i9N0r3D \$1Gn4+uR3";
$lang['messagewasdeleted'] = "m3s5493 %s.%s w4\$ dEle+Ed";
$lang['stopignoringthisuser'] = "s+Op ign0rIn9 tH15 u\$er";
$lang['renamethread'] = "r3N4me Thre4d";
$lang['movethread'] = "mOv3 THr34d";
$lang['editthepoll'] = "eD1+ th3 pOLl";
$lang['torenamethisthread'] = "t0 R3Nam3 +hIs THRe4D";
$lang['closeforposting'] = "cl0\$e Ph0r pOS+in9";
$lang['until'] = "uN+1l 00:00 utc";
$lang['approvalrequired'] = "aPprOv4L rEquiRed";
$lang['messageawaitingapprovalbymoderator'] = "me5SAge %s.%s iS 4w@I+1Ng 4pPr0v4L bY 4 mODer4TOR";
$lang['postapprovedsuccessfully'] = "pO\$T 4PPrOvED Succ3SSpHuLLy";
$lang['postapprovalfailed'] = "po\$T 4pPr0v@l fa1l3d.";
$lang['postdoesnotrequireapproval'] = "pO\$T DOe5 nO+ reQu1RE 4ppr0v4L";
$lang['approvepost'] = "appRoVE pOsT pH0r diSpL4y";
$lang['approvedbyuser'] = "aPPRoV3d: %s By %s";
$lang['makesticky'] = "m4K3 sT1Cky";
$lang['messagecountdisplay'] = "%s 0Ph %s";
$lang['linktothread'] = "p3rM4neN+ link +o THi\$ THR34d";
$lang['linktopost'] = "l1NK +0 pO5T";
$lang['linktothispost'] = "l1nk t0 +h15 Po\$T";
$lang['imageresized'] = "tHI\$ 1M@gE H4\$ bEen reS1ZeD (Ori91n4L S1z3 %1\$sX%2\$\$). +O vIEw tH3 PhuLl-\$ize 1m4Ge Cl1ck heR3.";
$lang['messagedeletedbyuser'] = "m3\$54GE %s.%s dEletEd %s 8y %s";
$lang['messagedeleted'] = "m3S\$49e %s.%s W4S D3l3t3D";

// Moderators list (mods_list.php) -------------------------------------

$lang['cantdisplaymods'] = "c4Nn0+ d1Spl4Y ph0lD3r MOdeR@+ORs";
$lang['moderatorlist'] = "m0DeR@ToR l1st:";
$lang['modsforfolder'] = "m0dEr4+oR\$ FoR PH0LDEr";
$lang['nomodsfound'] = "n0 Mod3R4+OrS ph0Und";
$lang['forumleaders'] = "f0rUm le4DerS:";
$lang['foldermods'] = "f0ld3R mOD3r@+OrS:";

// Navigation strip (nav.php) ------------------------------------------

$lang['start'] = "s+4Rt";
$lang['messages'] = "meSS4g3\$";
$lang['pminbox'] = "inBOX";
$lang['startwiththreadlist'] = "s+4R+ p@ge W1+H tHr34d l15t";
$lang['pmsentitems'] = "sEN+ 1t3M5";
$lang['pmoutbox'] = "ou+bOX";
$lang['pmsaveditems'] = "sAVed I+3m\$";
$lang['pmdrafts'] = "dR@f+\$";
$lang['links'] = "l1NKS";
$lang['admin'] = "admin";
$lang['login'] = "l0giN";
$lang['logout'] = "l090Ut";

// PM System (pm.php, pm_write.php, pm.inc.php) ------------------------

$lang['privatemessages'] = "pr1V4te m3s\$49ES";
$lang['recipienttiptext'] = "s3P4R@+e REc1pienTS bY SemI-COl0n Or C0mm4";
$lang['maximumtenrecipientspermessage'] = "tH3rE 1S 4 lIMi+ 0f 10 reCiP1en+\$ per m3SS@9E. Pl34Se 4meNd yOuR R3cIp1En+ l1S+.";
$lang['mustspecifyrecipient'] = "j00 Mu5t sPECIphy @t l3@\$+ on3 rec1p13n+.";
$lang['usernotfound'] = "us3r %s nO+ FoUnd";
$lang['sendnewpm'] = "sENd n3w pM";
$lang['savemessage'] = "s4VE m3SS4gE";
$lang['timesent'] = "t1m3 SEN+";
$lang['nomessages'] = "nO mEs54gE5";
$lang['errorcreatingpm'] = "eRR0R cr34TIN9 pm! pLe45e Try a94in 1n 4 ph3w miNU+E5";
$lang['writepm'] = "wr1TE MES\$AGe";
$lang['editpm'] = "edi+ M3S549E";
$lang['cannoteditpm'] = "c4NNO+ eDi+ Thi5 Pm. 1+ h45 4LRe4dy be3n V13W3d By tEH recIpieN+ 0R +EH M3S\$4G3 D0e5 No+ EXI5t OR i+ 15 iN@cce5S18l3 by j00";
$lang['cannotviewpm'] = "c4nn0+ vIeW PM. meSS49E do3\$ n0+ EX1S+ OR i+ Is In@cc3S518l3 By J00";
$lang['pmmessagenumber'] = "mE\$S493 %s";

$lang['youhavexnewpm'] = "j00 H4V3 %d NEw m35SA93\$. wOUld J00 L1ke t0 go +0 yOUr iN80X NOW?";
$lang['youhave1newpm'] = "j00 h@V3 1 n3W m3\$\$@Ge. wOULd j00 LIke tO GO T0 Y0Ur 1nBoX N0w?";
$lang['youhave1newpmand1waiting'] = "j00 h4v3 1 New M3\$S@Ge.\\n\\nYOU 4l50 h@v3 1 M3s549E 4w41T1N9 dEL1veRy. t0 RecE1Ve thi5 M3\$sA93 PL3@s3 cL34r \$0m3 Sp4cE in y0uR 1N8OX.\\n\\nw0ULd J00 LIk3 +0 G0 +o YOUR IN80X Now?";
$lang['youhave1pmwaiting'] = "j00 h@ve 1 m3\$s@Ge 4w4i+1ng D3l1v3ry. t0 reC3ivE th15 mE5549e PLe@se cLe4r 5OmE SP4ce 1n Your IN80X.\\n\\nW0uld J00 liKe To 9O +0 Y0ur 1nbOX NOw?";
$lang['youhavexnewpmand1waiting'] = "j00 h@v3 %d n3w m3s\$49Es.\\n\\nyOu @L5o haV3 1 m3Ss@9E 4W41+inG D3l1very. tO R3c31ve THiS M3\$549E PL3@se cLe@r 5oME 5p4cE 1N y0Ur iNBoX.\\n\\nw0Uld j00 l1ke +0 90 +0 y0UR 1N8OX NOw?";
$lang['youhavexnewpmandxwaiting'] = "j00 haVE %d n3w mESSagEs.\\n\\nY0U 4lSO H@vE %d m3S\$493\$ 4w@1+1N9 D3lIVeRY. TO rec3ivE +hE\$e m3S\$493 pL34sE CLe4R SoMe \$P4Ce 1n YoUR 1nBox.\\n\\nw0UlD j00 L1ke t0 9o t0 y0Ur 1nBOX N0W?";
$lang['youhave1newpmandxwaiting'] = "j00 h4ve 1 NEW m3s5493.\\n\\nYOu @L50 h@ve %d M3\$s4Ge\$ 4w@it1N9 d3lIV3rY. tO r3Ce1v3 th35E MESS4Ges plE4SE cLE4r somE SP4ce 1N Y0ur IN80x.\\n\\nw0Uld j00 L1k3 T0 gO +O YOUr 1Nbox nOw?";
$lang['youhavexpmwaiting'] = "j00 H4vE %d m3S549e\$ 4w41t1N9 DEl1veRY. T0 R3c31vE +HeS3 m3\$54ge5 PlE4SE cLe4R SOM3 \$p4ce 1N yOuR IN80X.\\n\\nW0Uld J00 LIk3 +0 G0 +0 YoUr IN8ox N0w?";

$lang['youdonothaveenoughfreespace'] = "j00 d0 n0+ h4VE 3NoUgh Phr33 Sp4Ce t0 53nd +h15 MeS54ge.";
$lang['userhasoptedoutofpm'] = "%s h@s 0p+ed 0u+ OpH R3cE1Vin9 pErs0N4l mE5Sag3\$";
$lang['pmfolderpruningisenabled'] = "pm ph0ld3R PruN1NG is 3N48l3d!";
$lang['pmpruneexplanation'] = "tH1s f0rum u\$3s pM fOlD3r Prun1N9. +3h M3\$54ges j00 h4v3 S+0r3D IN YoUr inBoX @Nd \$enT 1tems\\nPh0LdeR5 4R3 \$UBJeC+ TO @Ut0m4+1c DElet10n. 4ny MEs5493\$ J00 w1\$h +o KEep SHOUld b3 Mov3d +0\\nyoUr \\'S4V3d 1+EMs\\' F0Ld3r SO TH4+ +H3Y 4re No+ D3l3+3D.";
$lang['yourpmfoldersare'] = "y0uR Pm foLD3r\$ 4re %s fuLl";
$lang['currentmessage'] = "curR3Nt MeS54ge";
$lang['unreadmessage'] = "unRe4D m3S\$4g3";
$lang['readmessage'] = "re@d meSS49e";
$lang['pmshavebeendisabled'] = "pER5On@L m3\$54GE5 H4v3 83en d1s4bL3d by th3 ph0ruM oWn3r.";
$lang['adduserstofriendslist'] = "aDD US3R5 to y0uR fR1enDs LI\$t +0 haV3 +HeM 4PP34R iN 4 DRop doWn On +H3 PM Wr1Te M3\$54gE P4Ge.";

$lang['messagesaved'] = "mEsS4Ge s4vEd";
$lang['messagewassuccessfullysavedtodraftsfolder'] = "mes5493 w@5 \$ucceS5PhulLy 54v3D to 'dr4Ph+5' F0LDEr";
$lang['couldnotsavemessage'] = "c0UlD N0+ \$4vE me\$549e. M4ke \$ure J00 h4V3 3NougH 4v@iL4bLe Phr3e sP4cE.";
$lang['pmtooltipxmessages'] = "%s m3\$S49eS";
$lang['pmtooltip1message'] = "1 Mes54g3";

// Preferences / Profile (user_*.php) ---------------------------------------------

$lang['mycontrols'] = "mY Contr0L5";
$lang['myforums'] = "mY ForUM\$";
$lang['menu'] = "meNu";
$lang['userexp_1'] = "uSE tH3 m3nu ON th3 lepH+ To M@n49e YOuR 53++1N9S.";
$lang['userexp_2'] = "<b>us3R d3+41ls</b> 4LloWs J00 +O cH@nG3 y0Ur N@Me, Em41l 4ddr35S 4nd p4\$\$WOrD.";
$lang['userexp_3'] = "<b>u\$3r PROF1l3</b> 4Ll0w5 J00 +0 3DIt YoUr useR PRoFiLe.";
$lang['userexp_4'] = "<b>ch4nge p@S\$word</b> 4Ll0w5 j00 +O ch4N93 y0uR Pa\$SWORD";
$lang['userexp_5'] = "<b>em@1L &amp; PRiV4Cy</b> Let\$ j00 CH4N93 H0w J00 C@n b3 Cont4c+3d 0N 4nD oFF +h3 f0RuM.";
$lang['userexp_6'] = "<b>f0rUM op+I0ns</b> LET5 J00 ch4n9E HoW +H3 F0RUm Lo0kS 4Nd WORkS.";
$lang['userexp_7'] = "<b>a+T4ChMEnT\$</b> 4llOW5 j00 +0 3d1T/deLet3 YOuR 4+T@chMeNtS.";
$lang['userexp_8'] = "<b>s1Gn@tUr3</b> L3+\$ j00 3D1+ y0uR s1Gn4+urE.";
$lang['userexp_9'] = "<b>rEL4T1on\$h1P5</b> L3t\$ j00 M4n@g3 YOuR reL4+1onsH1p w1+H oTh3r US3rS On +he ph0Rum.";
$lang['userexp_9'] = "<b>w0RD PhiLter</b> L3ts j00 3D1T y0ur P3R5on@l word philT3r.";
$lang['userexp_10'] = "<b>thre4d 5U8\$Cr1PT10n5</b> 4Ll0w5 J00 tO M4n4Ge Y0uR +Hre4d \$ubsCrip+10nS.";
$lang['userdetails'] = "u\$3R D3+41Ls";
$lang['userprofile'] = "uSEr ProFIlE";
$lang['emailandprivacy'] = "eM41L &amp; pRIvacY";
$lang['editsignature'] = "eD1+ \$iGN4turE";
$lang['norelationships'] = "j00 h4V3 nO U\$er reL4tI0nshIp5 SEt uP";
$lang['editwordfilter'] = "eDI+ WORd FiL+er";
$lang['userinformation'] = "u53R 1Nf0rM4T10N";
$lang['changepassword'] = "cH4NGe p4\$sW0rd";
$lang['currentpasswd'] = "cURrent P45SW0rd";
$lang['newpasswd'] = "nEW p45\$w0RD";
$lang['confirmpasswd'] = "c0Nph1Rm p4s5WOrD";
$lang['passwdsdonotmatch'] = "p4Ssw0rD5 do n0+ m@TCh!";
$lang['nicknamerequired'] = "nicKn@m3 1S R3qU1red!";
$lang['emailaddressrequired'] = "eM@1l 4DDRe\$5 iS reqU1rEd!";
$lang['logonnotpermitted'] = "l09on N0+ peRmitT3d. cHoO5e 4n0+Her!";
$lang['nicknamenotpermitted'] = "nickn4m3 no+ P3rm1tted. cHo053 4n0+h3r!";
$lang['emailaddressnotpermitted'] = "eM41l 4DDRE5S N0+ peRmITteD. ch00se 4N0+HeR!";
$lang['emailaddressalreadyinuse'] = "em@iL 4ddr3s5 4Lr3@dy in U\$E. ch00Se anotH3r!";
$lang['relationshipsupdated'] = "r3l4+i0N5H1Ps UPd4+Ed!";
$lang['relationshipupdatefailed'] = "reL4+10n5h1p UPDaT3D ph@1L3d!";
$lang['preferencesupdated'] = "prEF3r3NcES WeR3 suCces5Fully Upd4+3d.";
$lang['userdetails'] = "u53r det4IL\$";
$lang['memberno'] = "mem83r n0.";
$lang['firstname'] = "f1RST n4M3";
$lang['lastname'] = "l4st N4Me";
$lang['dateofbirth'] = "d@te OpH 81R+h";
$lang['homepageURL'] = "h0M3p@GE uRl";
$lang['pictureURL'] = "p1c+UrE URl";
$lang['forumoptions'] = "f0RUM OP+I0n5";
$lang['notifybyemail'] = "n0TIphy by em4iL Of PoS+\$ +O M3";
$lang['notifyofnewpm'] = "n0+1fY bY P0puP OPh N3w PM M3sS49ES tO mE";
$lang['notifyofnewpmemail'] = "nOT1fY 8Y 3m4iL 0ph n3w PM mE5\$493s To M3";
$lang['daylightsaving'] = "aDJU5T pH0r D4yLight \$@V1NG";
$lang['autohighinterest'] = "aU+0M4+ic@llY m4rK +hre4d5 1 po\$T 1N 4\$ h1gh INtereSt";
$lang['convertimagestolinks'] = "au+om4+1C4lLY cOnVert 3m83dd3d IM@GEs IN p0StS intO LinKS";
$lang['thumbnailsforimageattachments'] = "tHUmbN4iL5 Phor 1M4gE 4+T4cHM3N+5";
$lang['smallsized'] = "sm4lL 51Zed";
$lang['mediumsized'] = "m3d1um s1Zed";
$lang['largesized'] = "l4Rg3 SIzed";
$lang['globallyignoresigs'] = "glOb4lLy iGnor3 u\$3r \$1gn@+urEs";
$lang['allowpersonalmessages'] = "alLOW O+HEr U53R5 +0 \$enD me p3r5Onal meS54g3s";
$lang['allowemails'] = "alL0W 0th3r U53R\$ tO Send m3 3m4il5 Vi4 mY pROph1l3";
$lang['timezonefromGMT'] = "t1ME Z0nE";
$lang['postsperpage'] = "po\$TS p3r P4Ge";
$lang['fontsize'] = "f0N+ Siz3";
$lang['forumstyle'] = "foRuM \$tyle";
$lang['forumemoticons'] = "f0rUm 3mO+1c0NS";
$lang['startpage'] = "st4rt P4G3";
$lang['containsHTML'] = "con+4in5 html";
$lang['preferredlang'] = "prEFeRred l4n9u4g3";
$lang['donotshowmyageordobtoothers'] = "d0 N0+ \$h0w MY 4GE OR d4t3 0F B1r+h tO 0TH3r\$";
$lang['showonlymyagetoothers'] = "sHow onlY my 49E t0 Oth3r\$";
$lang['showmyageanddobtoothers'] = "sh0w 80tH mY 4GE 4nd D4T3 0f 8ir+h t0 0+hers";
$lang['showonlymydayandmonthofbirthytoothers'] = "sHow 0NLy mY d4Y 4nd MOn+h 0F 8ir+H To 0th3RS";
$lang['listmeontheactiveusersdisplay'] = "l1\$t m3 On +eH 4CTiv3 U\$3r\$ D1SpL4Y";
$lang['browseanonymously'] = "bRoWsE fORuM 4N0Nymou5LY";
$lang['allowfriendstoseemeasonline'] = "bR0wS3 4n0nym0U5ly, BuT 4lLOW frI3nds +o sE3 M3 45 ONL1n3";
$lang['revealspoileronmouseover'] = "r3VE@L SP01L3r\$ On m0uSE 0ver";
$lang['resizeimagesandreflowpage'] = "rEsIZ3 1m4935 4ND RePHl0w P4GE t0 PReVenT H0riZoNTal sCr0Ll1NG.";
$lang['showforumstats'] = "sHow fOruM St4+s @+ 80+T0m OF mEsS4G3 p4N3";
$lang['usewordfilter'] = "en4BL3 wOrD phIlt3r.";
$lang['forceadminwordfilter'] = "fOrCe u53 0Ph @dM1n wOrD PHil+eR 0N @Ll US3rS (iNC. 9uES+s)";
$lang['timezone'] = "t1me Z0n3";
$lang['language'] = "l4N9U@ge";
$lang['emailsettings'] = "eM4IL 4nd cOn+4c+ SEt+in9S";
$lang['forumanonymity'] = "f0RUm 4nOnym1+Y SE++1NGS";
$lang['birthdayanddateofbirth'] = "b1R+hd@y @nd d4t3 Oph 81r+h d1\$Pl@y";
$lang['includeadminfilter'] = "includ3 4Dm1n WOrD phILteR 1n my L1st.";
$lang['setforallforums'] = "sE+ ph0r 4Ll F0RUM5?";
$lang['containsinvalidchars'] = "cONT41NED 1NV4lId ch4R4c+erS!";
$lang['postpage'] = "p0st p@ge";
$lang['nohtmltoolbar'] = "no h+ml +00lB@r";
$lang['displaysimpletoolbar'] = "di\$pl4y \$IMplE H+ml +00l84r";
$lang['displaytinymcetoolbar'] = "d15pL@Y wyS1Wy9 hTmL +00l8@R";
$lang['displayemoticonspanel'] = "d1SPL4y EMo+1c0n5 p4nel";
$lang['displaysignature'] = "d1sPL4y \$1Gn4TuRe";
$lang['disableemoticonsinpostsbydefault'] = "d1\$48l3 3MO+1c0n5 1n ME5s4ge\$ by d3F4Ul+";
$lang['automaticallyparseurlsbydefault'] = "aU+0M@T1C@lLY P4r5E uRLS 1N meSs49ES 8y d3f4uLT";
$lang['postinplaintextbydefault'] = "poSt In pL41n +ext by d3pH4ult";
$lang['postinhtmlwithautolinebreaksbydefault'] = "p0\$t 1N H+ml W1+h 4u+O-LIne-8R3ak\$ 8y D3Ph4UL+";
$lang['postinhtmlbydefault'] = "po5T iN H+ml 8y dEPh@Ul+";
$lang['privatemessageoptions'] = "pRiV4T3 mE\$5493 Op+I0n\$";
$lang['privatemessageexportoptions'] = "prIV4+3 M3S\$493 3XpOrt Op+10n5";
$lang['savepminsentitems'] = "s4V3 4 copY OF 34ch Pm 1 seNd in My SEnt 1t3m5 PHolD3r";
$lang['includepminreply'] = "inclUde M3sS4g3 BOdy whEn r3ply1ng TO pm";
$lang['autoprunemypmfoldersevery'] = "auT0 prun3 my pm FolD3R\$ eV3ry:";
$lang['friendsonly'] = "frIEnd\$ 0nly?";
$lang['globalstyles'] = "gloB@l 5Tyle5";
$lang['forumstyles'] = "fORUm \$+yLEs";

// Polls (create_poll.php, poll_results.php) ---------------------------------------------

$lang['mustprovideanswergroups'] = "j00 mU5T Pr0v1De 50M3 @N5w3r 9RoupS";
$lang['mustprovidepolltype'] = "j00 MU5T PrOvid3 4 p0lL typE";
$lang['mustprovidepollresultsdisplaytype'] = "j00 MU5+ proviD3 R3\$uLT\$ d15pl@y +ype";
$lang['mustprovidepollvotetype'] = "j00 mu\$t prOvIde 4 p0ll VO+e typ3";
$lang['mustprovidepollguestvotetype'] = "j00 MUsT SpECIfY 1F gUeST\$ ShOulD be 4LlOwed +o vO+3";
$lang['mustprovidepolloptiontype'] = "j00 mUST pR0Vide 4 p0Ll Opti0N +Yp3";
$lang['mustprovidepollchangevotetype'] = "j00 MusT PR0v1dE @ P0ll CH4n93 vO+e type";
$lang['pleaseselectfolder'] = "pLE453 \$EL3ct @ F0ldeR";
$lang['mustspecifyvalues1and2'] = "j00 Mu\$+ specifY valU3\$ fOr 4n\$W3R5 1 @nd 2";
$lang['tablepollmusthave2groups'] = "tAbul4r pH0Rm@+ PoLL\$ mu5T H@VE PrEC1S3lY +wo v0TinG 9R0uP\$";
$lang['nomultivotetabulars'] = "t48UL4R fOrm4+ p0ll\$ C4nn0+ 83 MulT1-vo+e";
$lang['nomultivotepublic'] = "pUblic 8aLlO+S c@NNOt 8E mUltI-votE";
$lang['abletochangevote'] = "j00 wIll b3 A8L3 tO CH@n9e yoUr V0+e.";
$lang['abletovotemultiple'] = "j00 wIlL 8E 48l3 +0 vo+3 muL+iPle t1Me\$.";
$lang['notabletochangevote'] = "j00 w1lL n0T B3 48l3 +0 CH4N93 Y0Ur vo+e.";
$lang['pollvotesrandom'] = "n0+e: POLl V0tE\$ 4R3 R4nDoMly 9EneR@+eD PhOR PReV13w 0NLy.";
$lang['pollquestion'] = "p0lL qU35t10n";
$lang['possibleanswers'] = "po\$s18L3 ANSW3r\$";
$lang['enterpollquestionexp'] = "eN+3r teh an\$werS PHoR y0UR poll quE5t10n.. if y0ur poll i5 @ &quot;y3s/N0&quot; Qu3St1oN, \$1mplY eN+3R &quot;y3\$&quot; PhOR @N5Wer 1 @ND &quot;No&quot; ph0R @Nsw3r 2.";
$lang['numberanswers'] = "nO. @N5w3rS";
$lang['answerscontainHTML'] = "an5W3Rs cOnt4in Html (no+ 1nclud1ng SI9N4+Ure)";
$lang['optionsdisplay'] = "answ3R\$ dIsPl@y +YP3";
$lang['optionsdisplayexp'] = "how \$hould +3h @N\$W3rs 83 pR3SEn+Ed?";
$lang['dropdown'] = "a\$ drOp-d0wn LIs+(S)";
$lang['radios'] = "as 4 sErIES 0F r4d1O 8utT0N5";
$lang['votechanging'] = "v0T3 ch4nGINg";
$lang['votechangingexp'] = "c@N 4 perSON ch4n9e h15 Or h3R V0t3?";
$lang['guestvoting'] = "gU3\$+ VO+1n9";
$lang['guestvotingexp'] = "c@n gue\$ts vo+e in TH1\$ pOll?";
$lang['allowmultiplevotes'] = "alL0w Mul+iple vOt3S";
$lang['pollresults'] = "pOLl r3SuLtS";
$lang['pollresultsexp'] = "h0W w0uld j00 liKe +O D1SPL4y +H3 re5uL+\$ oF yOUR POLl?";
$lang['pollvotetype'] = "p0ll vO+iNG TYpe";
$lang['pollvotesexp'] = "h0W \$hOuld t3H p0Ll b3 conduc+Ed?";
$lang['pollvoteanon'] = "aN0NYm0U\$LY";
$lang['pollvotepub'] = "pUbl1C b4LLo+";
$lang['horizgraph'] = "h0r1ZOntal gr4ph";
$lang['vertgraph'] = "vER+1cAL 9R4PH";
$lang['tablegraph'] = "t@8ul@r Ph0Rmat";
$lang['polltypewarning'] = "<b>w4rN1ng</b>: +H15 i5 4 Public B@Ll0t. YOur N@m3 W1lL 83 V1sIble n3xt To tEh 0P+i0n J00 v0+E fOR.";
$lang['expiration'] = "exp1r@+I0n";
$lang['showresultswhileopen'] = "d0 j00 w4nt to Sh0w R3SultS Wh1l3 t3H p0Ll 15 op3n?";
$lang['whenlikepollclose'] = "wh3N w0uld J00 L1ke YouR POlL to @u+0m@+ic@Lly CLo\$E?";
$lang['oneday'] = "onE D4Y";
$lang['threedays'] = "thR33 d4Y\$";
$lang['sevendays'] = "s3V3N d4yS";
$lang['thirtydays'] = "tHiRty d4y\$";
$lang['never'] = "n3v3R";
$lang['polladditionalmessage'] = "aDdi+I0N4L m35\$@GE (OPti0N4l)";
$lang['polladditionalmessageexp'] = "do j00 w4NT +0 INCLud3 4N 4DDI+1on4L pOsT @fTer Th3 P0ll?";
$lang['mustspecifypolltoview'] = "j00 muST specIphy a pOll T0 V13W.";
$lang['pollconfirmclose'] = "aRe j00 \$ure j00 w4nt t0 clO5E tH3 pH0llOwing p0LL?";
$lang['endpoll'] = "eND p0ll";
$lang['nobodyvotedclosedpoll'] = "n0bOdY VO+eD";
$lang['votedisplayopenpoll'] = "%s aND %s H4VE vOt3D.";
$lang['votedisplayclosedpoll'] = "%s 4nD %s vO+ed.";
$lang['nousersvoted'] = "n0 U\$3R5";
$lang['oneuservoted'] = "1 U\$Er";
$lang['xusersvoted'] = "%s user5";
$lang['noguestsvoted'] = "n0 Gues+5";
$lang['oneguestvoted'] = "1 gUEs+";
$lang['xguestsvoted'] = "%s GU35tS";
$lang['pollhasended'] = "p0LL H@s 3ND3D";
$lang['youvotedforpolloptionsondate'] = "j00 VOt3D ph0r %s 0n %s";
$lang['thisisapoll'] = "tHI\$ is 4 p0Ll. clicK To VIew REsUL+S.";
$lang['editpoll'] = "eD1T pOll";
$lang['results'] = "r3sult5";
$lang['resultdetails'] = "r3Sult d3+@iL5";
$lang['changevote'] = "chAN93 Vo+e";
$lang['pollshavebeendisabled'] = "poLLS hav3 83en diSA8led 8Y +eH Ph0Rum 0WnER.";
$lang['answertext'] = "aNSWer T3X+";
$lang['answergroup'] = "an\$WEr 9RoUp";
$lang['previewvotingform'] = "prEvI3w V0+1Ng fORm";
$lang['viewbypolloption'] = "viEW bY P0Ll op+ioN";
$lang['viewbyuser'] = "vI3w 8Y Us3r";

// Profiles (profile.php) ----------------------------------------------

$lang['editprofile'] = "eDi+ PrOPH1L3";
$lang['profileupdated'] = "pr0Ph1l3 UPd@+ED.";
$lang['profilesnotsetup'] = "tHE PH0Rum 0Wner h45 nO+ 53T Up PRoF1LE\$.";
$lang['ignoreduser'] = "i9N0reD U\$ER";
$lang['lastvisit'] = "l@S+ V1S1t";
$lang['totaltimeinforum'] = "t0+@l T1me";
$lang['longesttimeinforum'] = "l0NGe\$T seSsI0N";
$lang['sendemail'] = "s3nd 3ma1L";
$lang['sendpm'] = "s3Nd pm";
$lang['visithomepage'] = "vISi+ h0mEpa93";
$lang['age'] = "age";
$lang['aged'] = "aG3D";
$lang['birthday'] = "b1R+Hd@y";
$lang['registered'] = "rE9iSteR3d";
$lang['findusersposts'] = "fiNd u\$ER'\$ p0S+\$";
$lang['findmyposts'] = "f1ND mY p0S+s";

// Registration (register.php) -----------------------------------------

$lang['newuserregistrationsarenotpermitted'] = "soRry, n3W u5Er rE915TR4+1On5 @r3 nO+ 4lL0w3D r1GHT n0w. PL3453 cHECk b@ck l4T3r.";
$lang['usernameinvalidchars'] = "u\$3rn@m3 C4n 0nlY Con+@1n @-z, 0-9, _ - cH@rac+Ers";
$lang['usernametooshort'] = "uS3rn4m3 MuS+ be 4 minImuM oph 2 ch@r4ct3rs Long";
$lang['usernametoolong'] = "u53Rn@m3 muS+ 8e 4 m4Ximum 0F 15 ch4r4Cter5 l0n9";
$lang['usernamerequired'] = "a Lo90n N@me 1s r3qu1R3d";
$lang['passwdmustnotcontainHTML'] = "p4S\$woRD MU\$+ No+ c0nt41n h+mL +4G5";
$lang['passwordinvalidchars'] = "p4\$5worD CAn ONly COn+@1n @-z, 0-9, _ - CH@rACt3r\$";
$lang['passwdtooshort'] = "p@SswORd MUsT 8e 4 MiniMuM 0Ph 6 ch4R4c+3Rs lon9";
$lang['passwdrequired'] = "a P4\$SWoRd i\$ REquiRed";
$lang['confirmationpasswdrequired'] = "a C0nf1rm@+i0N p@\$sw0RD 15 r3qU1Red";
$lang['nicknamerequired'] = "a n1Ckn4me is ReqUiRed";
$lang['emailrequired'] = "aN 3m41L 4Ddr3S5 i5 rEQUIrED";
$lang['passwdsdonotmatch'] = "p4\$sw0rd\$ d0 nO+ M4+CH";
$lang['usernamesameaspasswd'] = "us3rN@ME @nd P4S5word mu\$T b3 difph3reNt";
$lang['usernameexists'] = "s0Rry, 4 Us3r WIth th@+ n4Me @lre4dy 3XI5ts";
$lang['successfullycreateduseraccount'] = "succ355FULly CR34+3d US3R @ccOun+";
$lang['useraccountcreatedconfirmfailed'] = "yOur U5Er 4cc0uN+ h4\$ B3en cRe4+Ed but +Eh reQu1Red c0nFirM4+10n 3m41l W4\$ nO+ 5EnT. PleA\$E CON+4Ct T3H pH0Rum ownEr t0 R3ct1FY tH15. 1n THi5 m34nt1me ple4\$e CL1cK +He c0N+1Nu3 8UTT0n tO lOg1N 1n.";
$lang['useraccountcreatedconfirmsuccess'] = "yoUr Us3r 4CCOUn+ H4\$ beeN CRe4+3D 8ut b3PhoR3 j00 c4N \$T4r+ P0sT1N9 J00 Mu\$t c0Nf1Rm Your 3m41L 4dDr355. pLe@53 CHeck YoUr 3mAil ph0R a liNk +H4+ w1Ll @lL0W J00 to cONphIrm y0Ur 4DDR3S\$.";
$lang['useraccountcreated'] = "y0ur US3R 4CcoUnt h45 B33N cRe4T3d \$ucC355FulLY! cLICk th3 Cont1Nu3 8UTT0N 83l0W +O L091n";
$lang['errorcreatinguserrecord'] = "erROR CR34+1Ng U5Er recORD";
$lang['userregistration'] = "uSer rE91StR4Ti0N";
$lang['registrationinformationrequired'] = "reG1Str4+1On iNF0Rm4Ti0n (REQuIr3D)";
$lang['profileinformationoptional'] = "pR0phiLe 1nphoRm4+IoN (opti0n4L)";
$lang['preferencesoptional'] = "pR3pHerENc3S (OPTi0n@L)";
$lang['register'] = "reg1st3R";
$lang['rememberpasswd'] = "rEm3mbeR p455WorD";
$lang['birthdayrequired'] = "y0uR D@te OpH 81r+H 1S r3QU1red 0R i\$ 1nv4lid";
$lang['alwaysnotifymeofrepliestome'] = "n0Tiphy On REPLy To mE";
$lang['notifyonnewprivatemessage'] = "n0+1fy 0n NEw Pr1v4Te Me5S4ge";
$lang['popuponnewprivatemessage'] = "p0P uP 0N new priv@+e me5S49E";
$lang['automatichighinterestonpost'] = "aUTOm@tic hi9h 1n+ERe5t ON p0St";
$lang['confirmpassword'] = "conphiRM paS\$Word";
$lang['invalidemailaddressformat'] = "iNv4L1D EMa1l @ddRe\$\$ pHorm4+";
$lang['moreoptionsavailable'] = "m0Re PrOphILe 4Nd pREph3Renc3 op+iON\$ @Re 4V4Il48l3 onc3 j00 r39I5t3R";
$lang['textcaptchaconfirmation'] = "c0NpHiRm4+Ion";
$lang['textcaptchaexplain'] = "t0 +eh R1gh+ 15 4 +eX+-captcha 1MA93. Ple45e type TEh coDe J00 c@n SeE 1N Th3 Im@9E 1Nt0 +h3 1Nput pHi3LD 83Low IT.";
$lang['textcaptchaimgtip'] = "th1\$ 1s 4 c4p+ch@-p1c+Ur3. I+ i5 u5Ed tO pR3v3NT 4UtoMatiC R3gi\$tr4+i0n";
$lang['textcaptchamissingkey'] = "a COnFirmaTI0n cod3 15 R3qu1red.";
$lang['textcaptchaverificationfailed'] = "tex+-c4Ptch4 VERIph1C4+1On c0d3 w45 iNC0rrecT. plE4Se r3-3n+Er i+.";

// Recent visitors list  (visitor_log.php) -----------------------------

$lang['member'] = "m3m83r";
$lang['searchforusernotinlist'] = "s34Rch for 4 u\$3R n0t 1n L1S+";
$lang['yoursearchdidnotreturnanymatches'] = "yoUr \$E4rch D1d N0T r3+Urn 4Ny m4+che5. +rY 51mpl1phyIng YOur S34RCH P4R@m3+3R\$ 4nD trY 494in.";
$lang['hiderowswithemptyornullvalues'] = "h1De rOw\$ w1tH eMp+y 0R nUll v@lueS 1n 5ElectEd ColUMNs";
$lang['showregisteredusersonly'] = "sH0W r39I5TeR3d Us3rS 0Nly (h1de GUeS+5)";

// Relationships (user_rel.php) ----------------------------------------

$lang['relationships'] = "r3L@+10n5h1p5";
$lang['userrelationship'] = "u\$3R r3l4+10n\$HIp";
$lang['userrelationships'] = "uSEr REl4+10N\$HiP5";
$lang['friends'] = "fR1end\$";
$lang['ignoredcompletely'] = "i9nor3d COmPle+ely";
$lang['relationship'] = "reL4+I0nShIp";
$lang['restorenickname'] = "rES+0R3 uS3r'5 n1ckN4me";
$lang['friend_exp'] = "us3R'\$ po5tS M@rk3d w1Th 4 &quot;fRiend&quot; 1cOn.";
$lang['normal_exp'] = "us3r's p0\$+S 4pp34R @5 n0rm@L.";
$lang['ignore_exp'] = "useR'5 P0s+\$ 4r3 hIddeN.";
$lang['ignore_completely_exp'] = "thre@dS 4nd Po5ts +0 0R frOM u53r w1lL APPe4R del3teD.";
$lang['display'] = "diSpL4Y";
$lang['displaysig_exp'] = "u\$er'5 \$1GN4TUre I\$ d15pl4Y3D on +hE1r p0\$+s.";
$lang['hidesig_exp'] = "u\$3R'\$ 51gn@+uR3 is HIddeN oN +H3Ir pO5t\$.";
$lang['cannotignoremod'] = "j00 c4nno+ 1gnOre +h15 U\$ER, 4S th3y 4R3 A m0d3r4t0r.";

// Search (search.php) -------------------------------------------------

$lang['searchresults'] = "se4Rch r3SuL+S";
$lang['usernamenotfound'] = "tH3 US3rn4m3 j00 \$pec1FiEd 1n t3h tO 0r pHr0m PHIeLd W4\$ nO+ f0UNd.";
$lang['notexttosearchfor'] = "oNE or 4Ll 0F Y0Ur Se4rch KEyw0Rd5 W3re 1NV4lid. se4rCh Keyw0rD\$ mUSt 83 nO 5HorTEr th@N %d ch4RacTeR5, n0 l0Nger tH4n %d ch4R4Ct3rS ANd muSt N0+ 4pPe@R in teh %s";
$lang['mysqlstopwordlist'] = "my\$ql S+0PWord lis+";
$lang['foundzeromatches'] = "f0und: 0 M4+cheS";
$lang['found'] = "fOUnd";
$lang['matches'] = "m@+Ch35";
$lang['prevpage'] = "pr3vIOu\$ p@ge";
$lang['findmore'] = "f1nD m0Re";
$lang['searchmessages'] = "s3@rch m3\$54ge5";
$lang['searchdiscussions'] = "sEARch discuS\$10N\$";
$lang['find'] = "fInd";
$lang['additionalcriteria'] = "adD1+10nal cr1+Er14";
$lang['searchbyuser'] = "se4Rch 8y U\$ER (0pt1oN4l)";
$lang['folderbrackets_s'] = "fold3R(S)";
$lang['postedfrom'] = "p0\$Ted phr0M";
$lang['postedto'] = "p0s+3D +o";
$lang['today'] = "toD4y";
$lang['yesterday'] = "y3s+3rd@y";
$lang['daybeforeyesterday'] = "d@Y bePhOre y3StERd4y";
$lang['weekago'] = "%s wE3K @9O";
$lang['weeksago'] = "%s WeeK\$ 49O";
$lang['monthago'] = "%s m0NTH @Go";
$lang['monthsago'] = "%s MON+hs 4G0";
$lang['yearago'] = "%s Y3Ar 4g0";
$lang['beginningoftime'] = "begInN1ng 0Ph +1Me";
$lang['now'] = "n0W";
$lang['lastpostdate'] = "l4S+ p0S+ DA+e";
$lang['numberofreplies'] = "nUM83R OPh repl13s";
$lang['foldername'] = "fOLdeR N4Me";
$lang['authorname'] = "aUThOR n4me";
$lang['decendingorder'] = "nEW3\$+ ph1rs+";
$lang['ascendingorder'] = "olDE5t PhiR\$+";
$lang['keywords'] = "k3YW0rd5";
$lang['sortby'] = "s0r+ 8y";
$lang['sortdir'] = "sOR+ diR";
$lang['sortresults'] = "sORt R3SuL+\$";
$lang['groupbythread'] = "grOUP By THr3@d";
$lang['postsfromuser'] = "p05t\$ FrOM u\$Er";
$lang['poststouser'] = "poST\$ +0 U5er";
$lang['poststoandfromuser'] = "p0ST\$ tO @Nd FR0M u\$ER";
$lang['searchfrequencyerror'] = "j00 c4n Only 5E4rcH 0nCE ev3ry %s \$EC0NDs. pL34Se +ry 4G4in l@teR.";

// Search Popup (search_popup.php) -------------------------------------

$lang['select'] = "sElEct";
$lang['searchforthread'] = "s34RCH FOr +hre4d";
$lang['mustspecifytypeofsearch'] = "j00 MU\$T \$PecifY tYPE 0F 534rch +0 P3rPh0rm";
$lang['unkownsearchtypespecified'] = "uNkNOwN SE4rch tYpe SpecIF1eD";

// Start page (start_left.php) -----------------------------------------

$lang['recentthreads'] = "reC3n+ thR34ds";
$lang['startreading'] = "st4r+ ReaDIng";
$lang['threadoptions'] = "tHRE4d OP+i0n5";
$lang['editthreadoptions'] = "edI+ +hR3ad OPtiON\$";
$lang['morevisitors'] = "m0RE v1s1+0r\$";
$lang['forthcomingbirthdays'] = "f0r+hc0MiNg 8ir+hd4ys";

// Start page (start_main.php) -----------------------------------------

$lang['editstartpage_help'] = "j00 c@n 3DI+ +H1S p49E FR0m +Eh @dmiN 1NTErF4ce";
$lang['uploadstartpage'] = "uPLo@d \$TArt p4gE (%s)";
$lang['invalidfiletypeerror'] = "f1L3 +yp3 N0+ 5UppOr+3d. J00 c4n Only USe *.+Xt, *.PHp @ND *.HTM f1l3\$ 4\$ YouR St4Rt p4ge.";

// Thread navigation (thread_list.php) ---------------------------------

$lang['newdiscussion'] = "new D1ScUs5IoN";
$lang['createpoll'] = "cRe@Te POll";
$lang['search'] = "sE4RCh";
$lang['searchagain'] = "sE4rch @g41N";
$lang['alldiscussions'] = "all Di5cuS510n5";
$lang['unreaddiscussions'] = "uNr34d D15Cu\$5ioNS";
$lang['unreadtome'] = "uNR34d &quot;+o: m3&quot;";
$lang['todaysdiscussions'] = "tod@y's DI5cus\$10n\$";
$lang['2daysback'] = "2 D@yS 84ck";
$lang['7daysback'] = "7 D@y5 B4ck";
$lang['highinterest'] = "h19h 1ntereST";
$lang['unreadhighinterest'] = "uNRe4d H1gh In+3re5t";
$lang['iverecentlyseen'] = "i'V3 r3c3ntLy 5e3N";
$lang['iveignored'] = "i've ignOr3D";
$lang['byignoredusers'] = "bY i9nor3D U\$eRS";
$lang['ivesubscribedto'] = "i'Ve Su85cR183d +O";
$lang['startedbyfriend'] = "s+@rTeD BY phR1End";
$lang['unreadstartedbyfriend'] = "unREad std By fr1end";
$lang['startedbyme'] = "s+@r+3d by m3";
$lang['unreadtoday'] = "uNR34d tOD@y";
$lang['deletedthreads'] = "d3LE+ED thRe4dS";
$lang['goexcmark'] = "g0!";
$lang['folderinterest'] = "f0LD3r 1ntereSt";
$lang['postnew'] = "p0ST nEW";
$lang['currentthread'] = "cUrREN+ +hRead";
$lang['highinterest'] = "hI9H 1NtereSt";
$lang['markasread'] = "marK 4\$ rE4d";
$lang['next50discussions'] = "n3x+ 50 D15cUs\$i0n5";
$lang['visiblediscussions'] = "viSIBLe diScUs5i0nS";
$lang['selectedfolder'] = "sElect3d PH0lder";
$lang['navigate'] = "n4v1G@+E";
$lang['couldnotretrievefolderinformation'] = "th3r3 4re n0 f0lD3rs 4V@Il@bl3.";
$lang['nomessagesinthiscategory'] = "no Mes54ge5 1n +h15 c4t390ry. pl34\$E 5elec+ 4n0+her, 0r";
$lang['clickhere'] = "cLICK hER3";
$lang['forallthreads'] = "f0r 4ll ThR3@D5";
$lang['prev50threads'] = "pReVI0U\$ 50 thr3@ds";
$lang['next50threads'] = "nEx+ 50 +HreaD5";
$lang['nextxthreads'] = "n3X+ %s +hre4D5";
$lang['threadstartedbytooltip'] = "thR34d #%s \$t4rTED by %s. VIeW3d %s";
$lang['threadviewedonetime'] = "1 +1M3";
$lang['threadviewedtimes'] = "%d +1mes";
$lang['unreadthread'] = "uNr3AD +hr34d";
$lang['readthread'] = "r3@d ThRe4d";
$lang['unreadmessages'] = "unRE4D m3\$54g3S";
$lang['subscribed'] = "su8\$crIbED";
$lang['ignorethisfolder'] = "iGNoR3 THI5 pH0ldEr";
$lang['stopignoringthisfolder'] = "s+0p IgNOrIn9 +H1\$ phOldER";
$lang['stickythreads'] = "s+1cKy thr34d\$";
$lang['mostunreadposts'] = "m0\$T unre4d p0\$ts";
$lang['onenew'] = "%d n3W";
$lang['manynew'] = "%d N3W";
$lang['onenewoflength'] = "%d neW 0f %d";
$lang['manynewoflength'] = "%d New 0f %d";
$lang['ignorefolderconfirm'] = "aR3 J00 SuRe J00 w4n+ +O 19nOR3 TH15 Ph0ld3R?";
$lang['unignorefolderconfirm'] = "aRe j00 SurE j00 W@nT +O \$TOp ign0r1N9 Thi\$ pholder?";
$lang['gotofirstpostinthread'] = "g0 to F1R\$T P0\$+ 1n +hrE4d";
$lang['gotolastpostinthread'] = "g0 To L@5T pO\$+ 1N thre@d";
$lang['viewmessagesinthisfolderonly'] = "v13W meS\$49Es iN +h1S PHolDer 0NLy";
$lang['shownext50threads'] = "sH0w N3X+ 50 ThRE@d5";
$lang['showprev50threads'] = "sH0w PRev10u\$ 50 +hre4D5";
$lang['createnewdiscussioninthisfolder'] = "cRe@TE n3W dI\$cU55i0n 1N tH1S FOlD3R";

// HTML toolbar (htmltools.inc.php) ------------------------------------
$lang['bold'] = "boLd";
$lang['italic'] = "i+@l1c";
$lang['underline'] = "unDeRliNE";
$lang['strikethrough'] = "s+rik3THr0U9h";
$lang['superscript'] = "sUPEr5criP+";
$lang['subscript'] = "sUB\$CR1P+";
$lang['leftalign'] = "lEFt-4L1Gn";
$lang['center'] = "cENtER";
$lang['rightalign'] = "ri9Ht-4l1Gn";
$lang['numberedlist'] = "nuMb3red L1\$+";
$lang['list'] = "lIst";
$lang['indenttext'] = "iND3n+ +Ex+";
$lang['code'] = "c0D3";
$lang['quote'] = "qU0+e";
$lang['spoiler'] = "sPO1Ler";
$lang['horizontalrule'] = "hOr1Z0n+@l rul3";
$lang['image'] = "im4gE";
$lang['hyperlink'] = "hYP3rL1Nk";
$lang['noemoticons'] = "dI54bl3 3M0+IC0n\$";
$lang['fontface'] = "f0N+ PH4ce";
$lang['size'] = "s1ZE";
$lang['colour'] = "col0UR";
$lang['red'] = "r3D";
$lang['orange'] = "oR@ngE";
$lang['yellow'] = "y3Ll0w";
$lang['green'] = "grEeN";
$lang['blue'] = "bLUe";
$lang['indigo'] = "iND190";
$lang['violet'] = "v1OLEt";
$lang['white'] = "wH1t3";
$lang['black'] = "bl@Ck";
$lang['grey'] = "gRey";
$lang['pink'] = "pinK";
$lang['lightgreen'] = "lIght 9r33n";
$lang['lightblue'] = "l1ght bLU3";

// Forum Stats (messages.inc.php - messages_forum_stats()) -------------

$lang['forumstats'] = "fOrum 5t4+5";
$lang['usersactiveinthepasttimeperiod'] = "%s 4C+1ve 1n TeH p4St %s.";

$lang['numactiveguests'] = "<b>%s</b> 9u3stS";
$lang['oneactiveguest'] = "<b>1</b> 9U3St";
$lang['numactivemembers'] = "<b>%s</b> MEm83R\$";
$lang['oneactivemember'] = "<b>1</b> MEm83R";
$lang['numactiveanonymousmembers'] = "<b>%s</b> 4N0NymOU\$ memb3rS";
$lang['oneactiveanonymousmember'] = "<b>1</b> 4n0nym0u\$ memb3r";

$lang['numthreadscreated'] = "<b>%s</b> THre4d\$";
$lang['onethreadcreated'] = "<b>1</b> +hre4D";
$lang['numpostscreated'] = "<b>%s</b> PO\$TS";
$lang['onepostcreated'] = "<b>1</b> p05t";

$lang['younormal'] = "j00";
$lang['youinvisible'] = "j00 (Invi\$IbLe)";
$lang['viewcompletelist'] = "view compl3TE l15t";
$lang['ourmembershavemadeatotalofnumthreadsandnumposts'] = "our MEmB3rS H@ve Mad3 4 t0taL opH %s @Nd %s.";
$lang['longestthreadisthreadnamewithnumposts'] = "l0NG3St THr34D I5 <b>%s</b> w1+H %s.";
$lang['therehavebeenxpostsmadeinthelastsixtyminutes'] = "tHere H@vE BE3n <b>%s</b> P0\$Ts m@dE 1N tH3 l@s+ 60 minUt35.";
$lang['therehasbeenonepostmadeinthelastsxityminutes'] = "th3r3 H@5 been <b>1</b> pO\$t M4DE in tH3 l4\$+ 60 M1nuT3S.";
$lang['mostpostsevermadeinasinglesixtyminuteperiodwasnumposts'] = "mOS+ p0\$TS EVER m4d3 1n 4 s1N9l3 60 m1nUTe pEr10d 15 <b>%s</b> 0n %s.";
$lang['wehavenumregisteredmembersandthenewestmemberismembername'] = "wE H4ve <b>%s</b> r3Gi\$+3r3d M3mbeRs 4nd thE n3weSt Mem83R 1s <b>%s</b>.";
$lang['wehavenumregisteredmember'] = "wE h4vE %s r3GI5tER3d m3mb3R\$.";
$lang['wehaveoneregisteredmember'] = "wE h@vE 0Ne r391S+3rED m3M8er.";
$lang['mostuserseveronlinewasnumondate'] = "moS+ u\$er5 eVer Onl1ne W4\$ <b>%s</b> On %s.";
$lang['statsdisplayenabled'] = "st@tS d15pL4Y 3n4bled";

// Thread Options (thread_options.php) ---------------------------------

$lang['updatesmade'] = "upD4T3s m4d3";
$lang['useroptions'] = "u\$eR OpTi0N\$";
$lang['markedasread'] = "m4rk3D @S rE4D";
$lang['postsoutof'] = "pOS+\$ OuT 0F";
$lang['interest'] = "iN+3ReSt";
$lang['closedforposting'] = "cLo\$Ed Ph0r Po5tin9";
$lang['locktitleandfolder'] = "locK T1+le 4Nd F0lder";
$lang['deletepostsinthreadbyuser'] = "d3LETe pO\$tS IN THr34D by user";
$lang['deletethread'] = "d3lete thrE@d";
$lang['permenantlydelete'] = "p3rM3n4NTLy dEleTE";
$lang['movetodeleteditems'] = "mov3 +0 DELeT3D ThR3@ds";
$lang['undeletethread'] = "und3l3+3 +Hre4D";
$lang['threaddeletedpermenantly'] = "tHR3ad d3Let3D P3RM@nEN+lY. C4Nn0t UnDeLeTe.";
$lang['markasunread'] = "mARk 4S uNre4d";
$lang['makethreadsticky'] = "maKe tHR34d s+icky";
$lang['threareadstatusupdated'] = "thrE4D reaD 5t@TuS Upd@+ed \$Ucc3S5pHUllY";
$lang['interestupdated'] = "thRe4D INt3r3sT s+@tu\$ uPd4+ed Succ3\$5FullY";

// Dictionary (dictionary.php) -----------------------------------------

$lang['dictionary'] = "d1CTi0NARy";
$lang['spellcheck'] = "spelL cH3Ck";
$lang['notindictionary'] = "n0t 1n D1c+iON4ry";
$lang['changeto'] = "chAnG3 +O";
$lang['initialisingdotdotdot'] = "init14l1s1ng...";
$lang['spellcheckcomplete'] = "sP3Ll cH3Ck i5 cOmpl3t3. DO j00 wIsh t0 sT4r+ 4941n phRom The 8E9inn1n9?";
$lang['spellcheck'] = "sp3Ll Ch3CK";
$lang['noformobj'] = "nO pHOrm 0Bj3cT Sp3C1f13d F0r r3+urn tex+";
$lang['bodytext'] = "b0DY +eX+";
$lang['ignore'] = "i9N0r3";
$lang['ignoreall'] = "igNor3 4Ll";
$lang['change'] = "cH@n9e";
$lang['changeall'] = "cH4N9e 4lL";
$lang['add'] = "add";
$lang['suggest'] = "sU9G3S+";
$lang['nosuggestions'] = "(N0 Su9g3St1oN\$)";
$lang['ok'] = "ok";
$lang['cancel'] = "c@nC3l";
$lang['dictionarynotinstalled'] = "no DIC+I0n@RY H4s b3EN 1n\$t4ll3d. pL3453 c0nt4ct +h3 ph0ruM 0wneR +O rEm3dY +h1s.";

// Permissions keys ----------------------------------------------------

$lang['postreadingallowed'] = "p0\$T re4Ding @ll0w3d";
$lang['postcreationallowed'] = "p0s+ cr3@+I0n 4LlOw3d";
$lang['threadcreationallowed'] = "thRe4d cRe4+I0n @ll0wED";
$lang['posteditingallowed'] = "p0\$T 3d1+1nG aLl0W3d";
$lang['postdeletionallowed'] = "p0st D3L3+10N 4Ll0W3D";
$lang['attachmentsallowed'] = "a++@cHmenTS 4ll0W3d";
$lang['htmlpostingallowed'] = "hTml pO5t1Ng 4Ll0WeD";
$lang['signatureallowed'] = "sign4+uRE 4lL0Wed";
$lang['guestaccessallowed'] = "gu35T @cc3s\$ 4lloWeD";
$lang['postapprovalrequired'] = "po5T 4PPr0v4L requIr3d";

// RSS feeds gubbins

$lang['rssfeed'] = "rsS FeEd";
$lang['every30mins'] = "eV3RY 30 m1nUT3S";
$lang['onceanhour'] = "oNCe 4N H0ur";
$lang['every6hours'] = "eVerY 6 HOuR\$";
$lang['every12hours'] = "eveRy 12 HouRs";
$lang['onceaday'] = "once 4 D4Y";
$lang['rssfeeds'] = "r\$S FE3Ds";
$lang['feedname'] = "f33d n@Me";
$lang['feedfoldername'] = "f3ed phold3R n4m3";
$lang['feedlocation'] = "f33D loc4+i0N";
$lang['threadtitleprefix'] = "tHre4d +1+lE PrePh1X";
$lang['feednameandlocation'] = "f33D n4me 4ND Loc4+1On";
$lang['feedsettings'] = "fE3d \$3++INgS";
$lang['updatefrequency'] = "uPD4+E frEqU3Ncy";
$lang['rssclicktoreadarticle'] = "cL1cK Here to rE4d THiS @r+ICLe";
$lang['addnewfeed'] = "aDd New Ph33d";
$lang['editfeed'] = "ed1T Ph33d";
$lang['feeduseraccount'] = "fe3d uS3R 4CcOun+";
$lang['noexistingfeeds'] = "n0 3X1ST1n9 rs5 feeds f0Und. To 4dD 4 fEED plE4\$3 CL1CK th3 BUttOn b3LoW";
$lang['rssfeedhelp'] = "h3Re j00 c4n SetUP \$0ME rS5 PHEEdS PH0R aU+0M4+Ic ProP494+i0n 1n+0 y0UR ph0ruM. +He 1+eM\$ PhR0M +eH R\$s Fe3D5 J00 4DD w1ll b3 cR34+eD @S ThrE@D5 Wh1CH uS3r5 C@n R3pLy +0 4s iPH +hey wEr3 NoRM4l Pos+\$. +He R55 fe3d MUsT be @ccES51bl3 VI4 HtTp oR It wIlL NO+ wOrK.";
$lang['mustspecifyrssfeedname'] = "mUSt SpeciFy R55 PH3Ed N4ME";
$lang['mustspecifyrssfeeduseraccount'] = "muST \$P3c1Phy Rs5 PH33d useR acc0un+";
$lang['mustspecifyrssfeedfolder'] = "mus+ sPec1FY r55 pheEd phOLd3R";
$lang['mustspecifyrssfeedurl'] = "mUs+ sP3c1Fy r5S F3Ed url";
$lang['mustspecifyrssfeedupdatefrequency'] = "mUs+ \$PeciFy rSs Pheed uPd@te phR3qu3ncy";
$lang['unknownrssuseraccount'] = "uNKNOwn Rs5 US3R 4cC0unT";
$lang['rssfeedsupportshttpurlsonly'] = "r\$\$ f33d \$upPOr+S H++p Url\$ 0nLy. 5ECUre feeds (ht+p\$://) 4rE nOt \$UpPoRt3D.";
$lang['rssfeedurlformatinvalid'] = "rS5 F3ed URl fOrm@t 1s 1nV@lid. urL mUs+ include 5ch3Me (E.9. ht+P://) 4nd A hO5TN4me (e.9. www.hO5+NAm3.COM).";
$lang['rssfeeduserauthentication'] = "rs\$ feeD d03\$ n0t supPoRT hT+P uSEr 4uth3nTic@+I0n";
$lang['successfullyremovedselectedfeeds'] = "succ3S5fuLly ReMoV3D SELecTED pH3eds";
$lang['successfullyaddedfeed'] = "suCC3sSphUlLy 4Dd3D NeW FE3D";
$lang['successfullyeditedfeed'] = "succ3s\$fULLY ed1+3D F3Ed";
$lang['failedtoremovefeeds'] = "f41Led +O r3mOv3 s0me 0r ALl 0PH +H3 5El3C+Ed f33DS";
$lang['failedtoaddnewrssfeed'] = "fa1l3d T0 4dd n3w RS\$ PhE3d";
$lang['failedtoupdaterssfeed'] = "f@1Led +0 upd4+3 rs\$ F33D";
$lang['rssstreamworkingcorrectly'] = "r55 \$tReAm 4pPe4r\$ to B3 W0rkinG C0Rrec+LY";
$lang['rssstreamnotworkingcorrectly'] = "r\$S \$+re@m w@5 3mP+y 0r cOulD nO+ b3 pHOuNd";
$lang['invalidfeedidorfeednotfound'] = "inV4lId PHEed 1D 0R f3eD n0+ foUnd";

// PM Export Options

$lang['pmexportastype'] = "exPOR+ 4\$ TYP3";
$lang['pmexporthtml'] = "h+Ml";
$lang['pmexportxml'] = "xMl";
$lang['pmexportplaintext'] = "pL4IN +3x+";
$lang['pmexportmessagesas'] = "eXpoR+ M3S54ge5 4s";
$lang['pmexportonefileforallmessages'] = "oNE pH1L3 fOr 4LL m35s@G35";
$lang['pmexportonefilepermessage'] = "onE Fil3 P3r m3\$5@G3";
$lang['pmexportattachments'] = "exp0r+ A+t@chM3n+S";
$lang['pmexportincludestyle'] = "iNcLUDe ForuM 5tYl3 sH3ET";
$lang['pmexportwordfilter'] = "aPplY WORd fILT3R to m3s\$4geS";

// Thread merge / split options

$lang['threadsplit'] = "thrE4D H@\$ be3N \$PLiT";
$lang['threadmerge'] = "tHr34D h4\$ 8e3n m3rG3d";
$lang['mergesplitthread'] = "merg3 / \$pLI+ +HRE4D";
$lang['mergewiththreadid'] = "merGE w1tH ThRE@d 1D:";
$lang['postsinthisthreadatstart'] = "p0\$TS 1n +h15 THR3@D 4t \$T4r+";
$lang['postsinthisthreadatend'] = "poS+S 1n +h1\$ THr3@d 4+ eNd";
$lang['reorderpostsintodateorder'] = "rE-orDER p0s+5 iN+0 DAte oRD3R";
$lang['splitthreadatpost'] = "spl1+ THR34D 4+ po\$T:";
$lang['selectedpostsandrepliesonly'] = "s3lEc+Ed pO\$+ ANd r3plIEs 0nlY";
$lang['selectedandallfollowingposts'] = "s3L3c+ed 4Nd 4ll f0lL0w1nG pOS+s";

$lang['threadhere'] = "h3r3";
$lang['thisthreadhasmoved'] = "<b>thre4d\$ MeRG3d:</b> Thi5 thrEAd h45 M0v3D %s";
$lang['thisthreadwasmergedfrom'] = "<b>tHR34Ds M3rgEd:</b> THI\$ tHrE@D Wa\$ M3rGeD PHrOm %s";
$lang['somepostsinthisthreadhavebeenmoved'] = "<b>thRE@d Split:</b> sOM3 p0STS 1n Th15 +HR3AD H4VE be3n mOV3d %s";
$lang['somepostsinthisthreadweremovedfrom'] = "<b>thR34d \$pL1+:</b> S0m3 p05+\$ IN +hi5 +hre@D wer3 m0V3d PHr0m %s";

$lang['invalidfunctionarguments'] = "inVAl1d phuNcti0n @r9Um3NTs";
$lang['couldnotretrieveforumdata'] = "couLd N0+ r3tr1evE PhOrUm D4+@";
$lang['cannotmergepolls'] = "one 0R m0re tHr34d5 i5 4 Poll. J00 c4nn0T meRge P0llS";
$lang['couldnotretrievethreaddatamerge'] = "c0uLd nO+ RE+r1EV3 thr34d d4T@ fr0M 0n3 Or M0r3 thR34dS";
$lang['couldnotretrievethreaddatasplit'] = "coULd NO+ r3Tr13v3 +hR34d d4t4 pHr0m Source thR34d";
$lang['couldnotretrievepostdatamerge'] = "c0Uld nOt R3tr13VE P0\$T d4t4 phr0m On3 Or MoRe +hRE4d\$";
$lang['couldnotretrievepostdatasplit'] = "cOULd n0+ R3tRi3VE P0\$T data Phrom \$0uRce thre@d";
$lang['failedtocreatenewthreadformerge'] = "f41Led To cre@+e neW THr34d F0r M3r9e";
$lang['failedtocreatenewthreadforsplit'] = "f41LeD tO CRe@T3 N3w THR34D FoR SPLi+";

// Thread subscriptions

$lang['threadsubscriptions'] = "thrE4D Sub5crip+10n\$";
$lang['couldnotupdateinterestonthread'] = "c0ULd n0+ upd4+e iN+3r3S+ 0n +hrE4d '%s'";
$lang['threadinterestsupdatedsuccessfully'] = "tHrE4d inter3\$+s Upd4+3d SuCCEs5FUlly";
$lang['resetselected'] = "rE5ET \$3l3Ct3d";
$lang['allthreadtypes'] = "all thR3@d Typ35";
$lang['ignoredthreads'] = "i9N0Red ThrE@D5";
$lang['highinterestthreads'] = "hi9H 1nt3resT +HR34dS";
$lang['subscribedthreads'] = "su8scri83D tHr3@dS";
$lang['currentinterest'] = "cUrr3N+ 1n+EresT";

// Browseable user profiles

$lang['youcanonlyaddthreecolumns'] = "j00 c4N 0nly 4Dd 3 COluMN5. t0 @dd @ NEw c0luMn clO5E 4n 3XI\$T1ng 0ne";
$lang['columnalreadyadded'] = "j00 h4V3 4Lre@dY 4DdED +H1\$ c0lumn. if j00 w4n+ tO r3MovE 1+ cL1Ck i+'5 clos3 bU+t0n";

?>