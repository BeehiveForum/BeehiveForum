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

/* $Id: x-hacker.inc.php,v 1.279 2008-04-03 20:40:35 decoyduck Exp $ */

// British English language file

// Language character set and text direction options -------------------

$lang['_isocode'] = "en-gb";
$lang['_textdir'] = "ltr";

// Months --------------------------------------------------------------

$lang['month'][1]  = "jAnU@ry";
$lang['month'][2]  = "febrU4RY";
$lang['month'][3]  = "marCH";
$lang['month'][4]  = "aPRiL";
$lang['month'][5]  = "m4Y";
$lang['month'][6]  = "juNe";
$lang['month'][7]  = "july";
$lang['month'][8]  = "aU9us+";
$lang['month'][9]  = "s3PtEm8eR";
$lang['month'][10] = "oC+08er";
$lang['month'][11] = "nOVEm8Er";
$lang['month'][12] = "d3c3mBer";

$lang['month_short'][1]  = "j4n";
$lang['month_short'][2]  = "fE8";
$lang['month_short'][3]  = "m4R";
$lang['month_short'][4]  = "aPr";
$lang['month_short'][5]  = "m@Y";
$lang['month_short'][6]  = "jUN";
$lang['month_short'][7]  = "jUl";
$lang['month_short'][8]  = "aUG";
$lang['month_short'][9]  = "sEP";
$lang['month_short'][10] = "oC+";
$lang['month_short'][11] = "nOv";
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

$lang['date_periods']['year']   = "%s Y34R";
$lang['date_periods']['month']  = "%s m0NtH";
$lang['date_periods']['week']   = "%s W33k";
$lang['date_periods']['day']    = "%s dAy";
$lang['date_periods']['hour']   = "%s H0Ur";
$lang['date_periods']['minute'] = "%s m1NUt3";
$lang['date_periods']['second'] = "%s SeCOnd";

// As above but plurals (2 years vs. 1 year, etc.)

$lang['date_periods_plural']['year']   = "%s YE4r5";
$lang['date_periods_plural']['month']  = "%s m0NTHs";
$lang['date_periods_plural']['week']   = "%s W33KS";
$lang['date_periods_plural']['day']    = "%s DAys";
$lang['date_periods_plural']['hour']   = "%s HOurS";
$lang['date_periods_plural']['minute'] = "%s MiNutES";
$lang['date_periods_plural']['second'] = "%s SeC0ndS";

// Short hand periods (example: 1y, 2m, 3w, 4d, 5hr, 6min, 7sec)

$lang['date_periods_short']['year']   = "%sy";    // 1y
$lang['date_periods_short']['month']  = "%sm";    // 2m
$lang['date_periods_short']['week']   = "%sW";    // 3w
$lang['date_periods_short']['day']    = "%sD";    // 4d
$lang['date_periods_short']['hour']   = "%sHR";   // 5hr
$lang['date_periods_short']['minute'] = "%sm1N";  // 6min
$lang['date_periods_short']['second'] = "%s5Ec";  // 7sec

// Common words --------------------------------------------------------

$lang['percent'] = "pERceNT";
$lang['average'] = "aveRa9e";
$lang['approve'] = "approv3";
$lang['banned'] = "baNned";
$lang['locked'] = "loCkeD";
$lang['add'] = "adD";
$lang['advanced'] = "adV@NceD";
$lang['active'] = "aCT1vE";
$lang['style'] = "s+yL3";
$lang['go'] = "g0";
$lang['folder'] = "foLdEr";
$lang['ignoredfolder'] = "igNoReD pH0ldEr";
$lang['folders'] = "folDer\$";
$lang['thread'] = "thr34d";
$lang['threads'] = "tHRe4Ds";
$lang['threadlist'] = "thReAd LiSt";
$lang['message'] = "m3S54ge";
$lang['from'] = "fR0m";
$lang['to'] = "t0";
$lang['all_caps'] = "aLl";
$lang['of'] = "of";
$lang['reply'] = "r3PLy";
$lang['forward'] = "foRW4Rd";
$lang['replyall'] = "r3pLy t0 @Ll";
$lang['quickreply'] = "qu1Ck r3Ply";
$lang['quickreplyall'] = "qUICK r3pLy +0 4lL";
$lang['pm_reply'] = "r3PlY @s pm";
$lang['delete'] = "d3L3tE";
$lang['deleted'] = "deL3+ED";
$lang['edit'] = "eD1T";
$lang['privileges'] = "pr1vIlEgeS";
$lang['ignore'] = "ignorE";
$lang['normal'] = "nOrM@l";
$lang['interested'] = "iNT3r3\$+ED";
$lang['subscribe'] = "sUB\$cR18e";
$lang['apply'] = "aPply";
$lang['download'] = "dOwnLoAd";
$lang['save'] = "s@V3";
$lang['update'] = "upD4t3";
$lang['cancel'] = "c@Nc3l";
$lang['continue'] = "c0NtINuE";
$lang['attachment'] = "a++achm3n+";
$lang['attachments'] = "aT+acHm3n+5";
$lang['imageattachments'] = "iM49E ATT@Chm3NT5";
$lang['filename'] = "fiL3n@ME";
$lang['dimensions'] = "diMension\$";
$lang['downloadedxtimes'] = "d0WnL04Ded: %d T1M3\$";
$lang['downloadedonetime'] = "d0WnlO4DeD: 1 +iM3";
$lang['size'] = "s1ze";
$lang['viewmessage'] = "vi3W mE\$\$4Ge";
$lang['deletethumbnails'] = "dELe+e thum8n4iLs";
$lang['logon'] = "l0GON";
$lang['more'] = "mOr3";
$lang['recentvisitors'] = "reC3n+ v1si+Or\$";
$lang['username'] = "u\$3Rn@Me";
$lang['clear'] = "cle@r";
$lang['reset'] = "r3SEt";
$lang['action'] = "acTiOn";
$lang['unknown'] = "unKnOwN";
$lang['none'] = "n0n3";
$lang['preview'] = "prev13w";
$lang['post'] = "pO5T";
$lang['posts'] = "p05+5";
$lang['change'] = "ch4ng3";
$lang['yes'] = "y35";
$lang['no'] = "n0";
$lang['signature'] = "sI9N4+uR3";
$lang['signaturepreview'] = "s19Na+UR3 pr3Vi3w";
$lang['signatureupdated'] = "si9N4+urE UpD4t3d";
$lang['signatureupdatedforallforums'] = "sign@+UrE Upd@T3d fOR 4LL F0rumS";
$lang['back'] = "baCk";
$lang['subject'] = "sU8ject";
$lang['close'] = "cl0S3";
$lang['name'] = "n@ME";
$lang['description'] = "deSCr1ptION";
$lang['date'] = "d4+E";
$lang['view'] = "vI3W";
$lang['enterpasswd'] = "enT3r P4S\$w0rd";
$lang['passwd'] = "p4\$5word";
$lang['ignored'] = "iGN0reD";
$lang['guest'] = "gUE5+";
$lang['next'] = "n3X+";
$lang['prev'] = "preVi0Us";
$lang['others'] = "o+HeR5";
$lang['nickname'] = "niCkn4Me";
$lang['emailaddress'] = "email 4DDr3\$\$";
$lang['confirm'] = "c0Nf1Rm";
$lang['email'] = "em41l";
$lang['poll'] = "pOLL";
$lang['friend'] = "fR1ENd";
$lang['success'] = "sUCcE5\$";
$lang['error'] = "eRROr";
$lang['warning'] = "w4Rn1n9";
$lang['guesterror'] = "sorrY, J00 need To 83 L09g3D 1n t0 us3 +H15 PH3@+uRe.";
$lang['loginnow'] = "l0GIN N0w";
$lang['unread'] = "unRe4d";
$lang['all'] = "all";
$lang['allcaps'] = "all";
$lang['permissions'] = "peRmIs5iOn\$";
$lang['type'] = "tYPe";
$lang['print'] = "pr1NT";
$lang['sticky'] = "sticKy";
$lang['polls'] = "poLlS";
$lang['user'] = "u\$ER";
$lang['enabled'] = "eN48lEd";
$lang['disabled'] = "diS4bLED";
$lang['options'] = "op+i0n\$";
$lang['emoticons'] = "eM0+icOn\$";
$lang['webtag'] = "w38+4g";
$lang['makedefault'] = "mAKe DeF@ul+";
$lang['unsetdefault'] = "uNseT deF@UlT";
$lang['rename'] = "r3N@mE";
$lang['pages'] = "p4G3\$";
$lang['used'] = "u\$eD";
$lang['days'] = "d4y5";
$lang['usage'] = "uS4G3";
$lang['show'] = "sHOw";
$lang['hint'] = "h1N+";
$lang['new'] = "n3W";
$lang['referer'] = "rEph3r3r";
$lang['thefollowingerrorswereencountered'] = "t3h FoLl0w1n9 ERRorS wEr3 EnC0Un+er3D:";

// Admin interface (admin*.php) ----------------------------------------

$lang['admintools'] = "aDM1n +0ol5";
$lang['forummanagement'] = "foruM m4N49em3nt";
$lang['accessdeniedexp'] = "j00 D0 nOt HaVe PeRm1S51On +0 uSE tH15 sect10n.";
$lang['managefolders'] = "m4N@ge Ph0lDerS";
$lang['manageforums'] = "maN49E phorUmS";
$lang['manageforumpermissions'] = "m4N@9E ph0rUm pERm1\$\$10Ns";
$lang['foldername'] = "f0LD3r N4m3";
$lang['move'] = "m0vE";
$lang['closed'] = "clo\$eD";
$lang['open'] = "oP3N";
$lang['restricted'] = "r3S+R1cT3d";
$lang['forumiscurrentlyclosed'] = "%s IS cUrr3nTly cL0sEd";
$lang['youdonothaveaccesstoforum'] = "j00 DO nOt H4v3 @Cce\$\$ TO %s";
$lang['toapplyforaccessplease'] = "t0 4ppLy F0r 4Cce5\$ pLe4\$e C0n+4ct +He phOrUm 0WNeR.";
$lang['adminforumclosedtip'] = "iF J00 W4n+ t0 ch@n93 \$0m3 sE+TiNgS 0n y0Ur Ph0rUm cl1Ck TEh 4dM1n lINK In Th3 N@vig4T1On B4r 480V3.";
$lang['newfolder'] = "n3W pHolDer";
$lang['nofoldersfound'] = "nO eXIs+iN9 pH0ldeRS fOunD. t0 4dd 4 FolDer cl1cK tHe '4dD n3w' bUtton BelOw.";
$lang['forumadmin'] = "fOrUm @dMin";
$lang['adminexp_1'] = "us3 ThE M3nU 0n +hE lEfT t0 M@n4g3 +H1N9s 1n Y0ur foRum.";
$lang['adminexp_2'] = "<b>uSER\$</b> @LloW5 j00 T0 sE+ 1nDIV1Du4l us3R pErmIs5iOn5, inClUd1NG 4ppoIN+1nG m0dEr4+OrS @nd 9@9g1n9 p30PL3.";
$lang['adminexp_3'] = "<b>u53R Gr0uP\$</b> 4Ll0w5 j00 +0 CR3@t3 U53R 9r0uPs tO @S\$19n PermiSsIonS +0 4s mAny or 4\$ phew u5eR\$ qu1CklY 4nd e@silY.";
$lang['adminexp_4'] = "<b>b@n C0n+R0L5</b> 4lL0w\$ +eH b4Nn1n9 @nd un-b4nNin9 0Ph 1p 4ddR3\$535, ht+p R3feR3rS, U\$Ern4Mes, em@il @Ddr3S\$E\$ @nd N1ckN4M3\$.";
$lang['adminexp_5'] = "<b>f0LDeR5</b> @Ll0W5 tEh Cr34t1On, M0dIf1c4+Ion 4nD D3l3+Ion of ph0lDer5.";
$lang['adminexp_6'] = "<b>r\$\$ f3edS</b> 4Ll0w5 j00 To m4n4g3 rSs pH3Ed5 Ph0r pr0p494+1On 1Nt0 YOuR f0RuM.";
$lang['adminexp_7'] = "<b>prof1L35</b> L3ts j00 Cu\$T0m15e T3h 1T3Ms +h4t apP34r in +3h uSer prof1l35.";
$lang['adminexp_8'] = "<b>fORUm s3+T1n9S</b> 4LL0w5 j00 +O Cus+0m1SE yOuR forUm's N4ME, 4ppe4r4nCE @nD m@nY othEr +HiN9\$.";
$lang['adminexp_9'] = "<b>sT@rt p@G3</b> l3+5 j00 Cu\$+Om1Se Y0ur ph0rUm's s+@rT p@9E.";
$lang['adminexp_10'] = "<b>f0RUM StyL3</b> 4LL0wS J00 T0 GeN3r@Te r4Nd0M \$+Yl3\$ For y0UR phoRuM meMBeRs t0 use.";
$lang['adminexp_11'] = "<b>w0RD Ph1l+3r</b> aLlOwS j00 +O fiL+3r w0rd\$ J00 d0n'T W@nT +O bE u5Ed on y0ur pHorUm.";
$lang['adminexp_12'] = "<b>p0s+inG S+@t5</b> gEn3R@+3S 4 r3p0R+ L1\$+1N9 t3h +0p 10 P05+Er\$ iN @ deFIN3d p3riOd.";
$lang['adminexp_13'] = "<b>f0rum l1NKs</b> le+S J00 m4n49e thE L1nk\$ DrOpDoWn in +eh n4V194tIon 84R.";
$lang['adminexp_14'] = "<b>v1ew LOg</b> liSt\$ r3cEnt 4cTi0N5 by TEH f0RUm m0d3r4+0r\$.";
$lang['adminexp_15'] = "<b>m@N@93 foRuM\$</b> l3tS J00 cre@t3 ANd Del3TE @nD cL0s3 oR rEopEN pH0rUmS.";
$lang['adminexp_16'] = "<b>glo84L PH0RUM 5eTt1nG\$</b> 4LloWs J00 +0 m0diFy \$ETt1nGs wH1CH aFph3c+ 4lL pHorUm\$.";
$lang['adminexp_17'] = "<b>po\$t @PpR0v@L qu3Ue</b> @Ll0w\$ J00 tO Vi3w @ny Po5+\$ 4W4iTiN9 4Ppr0V4l 8Y A m0d3rA+Or.";
$lang['adminexp_18'] = "<b>vI\$i+oR lo9</b> @lL0wS j00 to vI3w @n 3xT3Nd3d l1S+ oF v1SiTOr\$ iNcLuD1Ng thE1r hTtP Ref3R3r\$.";
$lang['createforumstyle'] = "crE@+3 @ forum s+YL3";
$lang['newstylesuccessfullycreated'] = "n3W styl3 sUCc3\$\$pHulLy Cr34t3d.";
$lang['stylealreadyexists'] = "a S+Yl3 W1th th4T FiLen4m3 4Lr34dy 3X1\$+\$.";
$lang['stylenofilename'] = "j00 d1d nOT 3NT3r 4 ph1l3n@me +o 54v3 +Eh styLe WIth.";
$lang['stylenodatasubmitted'] = "c0ULd noT Re@d Ph0rUm 5+YL3 d4T4.";
$lang['styleexp'] = "uSE tH1S P@93 +0 H3lp Cre@t3 4 r@ND0mlY g3nEr@+eD 5+Yle phOr Y0uR pHorUm.";
$lang['stylecontrols'] = "c0NtRoLs";
$lang['stylecolourexp'] = "cL1CK 0n 4 Col0Ur to M4k3 @ NeW styLe 5heET 845Ed 0n th@+ colour. CuRREnt 84S3 cOL0Ur 1s fiRs+ In Li5+.";
$lang['standardstyle'] = "s+And4rD 5+Yle";
$lang['rotelementstyle'] = "r0T4ted 3LemEnT 5+yL3";
$lang['randstyle'] = "r4Nd0m s+Yle";
$lang['thiscolour'] = "thI\$ c0l0UR";
$lang['enterhexcolour'] = "oR eNter a HeX c0l0Ur +0 84sE A n3W \$+yL3 sH3eT 0n";
$lang['savestyle'] = "s@v3 +h1S s+yl3";
$lang['styledesc'] = "s+Yle d3sCr1p+iOn";
$lang['stylefilenamemayonlycontain'] = "s+YLe f1leN@m3 m4Y 0nLY ConT@1N LoWerc4\$e L3++erS (4-z), nUmbEr5 (0-9) @nd unDerscoRe.";
$lang['stylepreview'] = "sTYl3 Pr3vI3W";
$lang['welcome'] = "w3LcomE";
$lang['messagepreview'] = "mE\$s@93 pR3vi3W";
$lang['users'] = "uS3R\$";
$lang['usergroups'] = "uSER 9RouP\$";
$lang['mustentergroupname'] = "j00 mUst eNt3r @ Gr0Up n4m3";
$lang['profiles'] = "pR0pH1LEs";
$lang['manageforums'] = "m@n493 fOruM\$";
$lang['forumsettings'] = "f0Rum 5ett1n9s";
$lang['globalforumsettings'] = "gLOB4l ph0ruM 5e++IN9S";
$lang['settingsaffectallforumswarning'] = "<b>not3:</b> TH3Se sE++1N9s @fPH3ct aLl ForUMs. wH3r3 Th3 \$Et+1nG 1s dUpLic4+ed oN +He inD1V1Du4l PhoRum's \$e+tiN9s P4ge Th4t wiLl T4Ke PreC3d3nCe Ov3R +He \$e++1ngs j00 CH4nG3 heRe.";
$lang['startpage'] = "s+4rt P4G3";
$lang['startpageerror'] = "yOUr s+4rt P@93 c0uLD nOt 8E 54veD lOc4lly T0 +EH \$3RveR 8Ec4U\$3 PerM1S5I0N W@s d3nI3d.</p><p>t0 Ch@Ng3 Y0Ur s+4r+ p@93 pLe45E ClIck tHe dOwNlO4D 8Ut+0n 8eLoW WH1cH will Pr0mP+ J00 To \$4vE +He Ph1lE tO Y0Ur h@rD DrIv3. j00 c@n +h3n upl04D +hi5 filE T0 YouR SeRvER Int0 +HE ph0lLOWiNg PhOlDer, iF NeC3\$\$4rY CRE@+1nG Th3 FoLd3r S+Ruc+ure 1n +eH pR0c3\$\$.</p><p><b>%s</b></p><p>pl34\$E no+e th4T 50Me brow53r\$ M4Y cH@n93 tH3 n@mE oPh +eh fiL3 UPon d0WnlOad. wHeN Upl04dIn9 +h3 PH1L3 pLea53 M@K3 sUre tH4+ 1T 1S N4med \$+4R+_m@1n.pHP O+H3rWIsE yOuR s+4rT p4GE w1Ll 4Pp34R UnCH4n9Ed.";
$lang['failedtoopenmasterstylesheet'] = "y0uR PH0rUm 5+yL3 C0ULd n0t Be s4VeD bEc@U5e tH3 m4\$+Er 5+yL3 shE3t C0ULd NOT 8E l04DEd. +0 \$4ve YoUr 5+yl3 t3H m45t3r \$+YL3 shE3t (M4K3_S+yle.c\$\$) mU5+ 83 l0c4+Ed 1N T3H StyLe\$ DiR3CtOry 0ph yOUR B3eh1v3 FoRum in5T4ll@+10N.";
$lang['makestyleerror'] = "youR FOrUm S+YlE C0uld noT 83 \$4Ved L0c4LLy To +3H S3Rv3R 8eC4UsE peRmIs5iON W@S D3N1Ed.</p><p>t0 S@v3 Y0ur phoRuM S+yL3 plE4sE cliCk +H3 downLo@d 8uTt0N b3loW WH1cH W1ll pRomP+ j00 +0 54v3 T3h pH1L3 t0 y0uR h4RD drIv3. j00 c4n tH3n UPlOAd +h15 FIL3 T0 Y0Ur SERVeR iNt0 tH3 fOlloWiN9 PH0LDeR, if N3cE5\$ArY CrE@t1n9 +He pHOldER S+Ruc+Ur3 In t3H PrOc3\$\$.</p><p><b>%s</b></p><p>ple4\$3 nO+3 th4+ s0m3 8rOWSERs m@y CH4n93 +h3 n@m3 Of thE fIl3 uP0n dOWnl04D. when uPLo4d1n9 tEh ph1L3 PlE4\$E M4ke \$ur3 Th4+ it iS N4M3D STyL3.c\$5 O+HeRWi\$E tEh F0rUM \$+YLE W1Ll BE uNAv41LaBLe.";
$lang['forumstyle'] = "foRUM \$+yl3";
$lang['wordfilter'] = "w0rd pHIlT3R";
$lang['forumlinks'] = "fORUm LInK\$";
$lang['viewlog'] = "v1EW L09";
$lang['noprofilesectionspecified'] = "n0 pROpH1l3 S3c+ion \$P3cIPH1eD.";
$lang['itemname'] = "i+em n@m3";
$lang['moveto'] = "m0v3 +O";
$lang['manageprofilesections'] = "m@n4g3 proF1L3 \$ec+I0n5";
$lang['sectionname'] = "s3Ct1On n4m3";
$lang['items'] = "i+Ems";
$lang['mustspecifyaprofilesectionid'] = "mUS+ sPeCiFY 4 pr0fil3 \$eCt10n 1d";
$lang['mustsepecifyaprofilesectionname'] = "mUSt 5pec1PHy 4 ProF1L3 SEC+10n n@mE";
$lang['noprofilesectionsfound'] = "nO 3X1s+In9 PrOf1l3 sections Phound. +O aDd 4 pr0pH1Le \$EcTI0n cL1cK +Eh '@Dd N3w' buT+On b3LOw.";
$lang['addnewprofilesection'] = "aDD n3W Pr0pH1Le SeC+iOn";
$lang['successfullyaddedprofilesection'] = "suCc3s\$FulLy 4dDed pR0ph1l3 53CTiOn";
$lang['successfullyeditedprofilesection'] = "sUCceSsFuLLy EdIteD pR0Ph1l3 sec+Ion";
$lang['addnewprofilesection'] = "aDD N3w PrOpH1L3 SEct1oN";
$lang['mustsepecifyaprofilesectionname'] = "mU\$+ 5pec1PhY 4 ProPh1l3 \$3cTion n4m3";
$lang['successfullyremovedselectedprofilesections'] = "sUCcEs\$PHULlY r3mOved seLecT3D pRopH1Le \$EcT1On\$";
$lang['failedtoremoveprofilesections'] = "f@1Led to r3mov3 PROpH1Le sec+ioN5";
$lang['viewitems'] = "vI3W 1t3Ms";
$lang['successfullyaddednewprofileitem'] = "sUCc3s\$pHulLY @Dd3d NeW pRopHiLE it3m";
$lang['successfullyeditedprofileitem'] = "succ3S5FullY 3dIT3d PrOph1L3 1t3m";
$lang['successfullyremovedselectedprofileitems'] = "suCcEsSfuLly reMov3D S3L3CtED pR0ph1L3 1T3m\$";
$lang['failedtoremoveprofileitems'] = "fAIL3d To r3M0v3 pr0pH1Le 1T3M\$";
$lang['noexistingprofileitemsfound'] = "th3Re @R3 N0 Exis+ing pROph1L3 1+3mS 1N thiS \$Ect1ON. tO 4dd @N 1+Em clIcK Teh '4DD n3w' bu++0n b3L0W.";
$lang['edititem'] = "ediT 1t3M";
$lang['invalidprofilesectionid'] = "inv4L1D pR0PH1lE \$EcTion Id 0r \$EcT1oN n0t F0UNd";
$lang['invalidprofileitemid'] = "iNV4liD proPh1l3 1Tem 1d 0R 1+Em N0+ fouNd";
$lang['addnewitem'] = "aDD NEw 1t3m";
$lang['youmustenteraprofileitemname'] = "j00 muSt EnT3R @ pR0F1l3 1tEm n@Me";
$lang['invalidprofileitemtype'] = "iNV@lId pRoF1l3 i+3m tyPe 53lEctEd";
$lang['youmustenteroptionsforselectedprofileitemtype'] = "j00 mus+ 3nT3r SoM3 0p+1On5 phOr 5EL3c+3d Pr0ph1L3 It3m +yP3";
$lang['youmustentermorethanoneoptionforitem'] = "j00 muS+ 3nT3r Mor3 Th4n on3 opT1On Ph0R \$3l3cted pr0ph1L3 It3m Typ3";
$lang['profileitemhyperlinkssupportshttpurlsonly'] = "pR0Ph1Le itEm HYp3rl1nkS \$UppOR+ Ht+p Url5 OnLy";
$lang['profileitemhyperlinkformatinvalid'] = "pROFil3 item HYp3rl1nk foRm@T InV4L1D";
$lang['youmustincludeprofileentryinhyperlinks'] = "j00 mu\$T 1nCLuDe <i>%s</i> 1n +HE url of clIck48LE HypeRliNk5";
$lang['failedtocreatenewprofileitem'] = "f4Il3D tO cR34t3 N3W PrOfiL3 1+Em";
$lang['failedtoupdateprofileitem'] = "f4il3d +0 uPd4+3 pRoph1LE ITeM";
$lang['startpageupdated'] = "st4rT p4G3 upD4t3d. %s";
$lang['viewupdatedstartpage'] = "vIEw upd4+ed st@r+ Pa93";
$lang['editstartpage'] = "eDIt \$T4rt p493";
$lang['nouserspecified'] = "nO uSeR \$Pec1fi3D.";
$lang['manageuser'] = "m4NagE uSer";
$lang['manageusers'] = "m4n4g3 U5eR5";
$lang['userstatusforforum'] = "uSeR S+4+Us f0r %s";
$lang['userdetails'] = "u53R d3+4iLs";
$lang['edituserdetails'] = "eDi+ u53R dEt@1Ls";
$lang['warning_caps'] = "wARn1N9";
$lang['userdeleteallpostswarning'] = "aR3 j00 sure j00 W4Nt to dEL3tE 4lL 0pH th3 sel3C+3d uSER'\$ Po\$+\$? 0NcE THe p0s+s @R3 d3l3+3D ThEY CaNnO+ Be Re+R13v3d 4ND W1ll be l0s+ For3V3r.";
$lang['postssuccessfullydeleted'] = "posts w3R3 sUccE\$\$FuLly delEt3d.";
$lang['folderaccess'] = "foLdEr 4cc3S5";
$lang['possiblealiases'] = "p0551bl3 4l1@5E\$";
$lang['userhistory'] = "u5Er hI5+0Ry";
$lang['nohistory'] = "n0 Hi\$TorY Rec0rds S4V3D";
$lang['userhistorychanges'] = "cH4NGE\$";
$lang['clearuserhistory'] = "cL3@R uSer H15+0Ry";
$lang['changedlogonfromto'] = "ch@NgeD lOg0n PhR0m %s t0 %s";
$lang['changednicknamefromto'] = "ch4N93d nIcKN4m3 fRoM %s To %s";
$lang['changedemailfromto'] = "ch4NgeD 3m4Il FRom %s +0 %s";
$lang['successfullycleareduserhistory'] = "suCc3S\$FulLy CL34rED u5Er His+oRY";
$lang['failedtoclearuserhistory'] = "faIL3D +0 cL34R U\$3r Hi\$+oRY";
$lang['successfullychangedpassword'] = "sUcc3S\$FuLly ch@Ng3D p4SswOrd";
$lang['failedtochangepasswd'] = "f@1L3d +0 ch@n93 P4\$\$word";
$lang['viewuserhistory'] = "v13w U5er hi\$+0RY";
$lang['viewuseraliases'] = "vI3w u5eR 4L1@5es";
$lang['searchreturnednoresults'] = "se4Rch r3tUrn3D nO re\$UL+5";
$lang['deleteposts'] = "dEl3+3 P05+\$";
$lang['deleteuser'] = "d3L3t3 uS3r";
$lang['alsodeleteusercontent'] = "alsO d3l3+e @Ll of +HE C0N+Ent cR34TeD 8y th1\$ U5Er";
$lang['userdeletewarning'] = "ar3 j00 Sur3 j00 w@n+ To deL3Te +H3 Sel3C+eD u5eR 4cC0un+? 0Nce thE @CcOun+ h@5 833N d3l3t3d i+ c4nNot Be RetRieVed 4ND WiLl 83 l0\$t Ph0r3v3R.";
$lang['usersuccessfullydeleted'] = "uSeR 5ucc355FUllY deletEd";
$lang['failedtodeleteuser'] = "f41lEd +o d3l3+e UsER";
$lang['forgottenpassworddesc'] = "if +h1\$ U5eR h@5 pHor9Otten +HEiR p@55wORD J00 c4N rEs3t 1+ for +Hem HEr3.";
$lang['failedtoupdateuserstatus'] = "fA1L3d +0 uPd4T3 U5eR st@tUs";
$lang['failedtoupdateglobaluserpermissions'] = "f4ilEd +o upD4te 9LOB4l us3R pERM1S5IOn\$";
$lang['failedtoupdatefolderaccesssettings'] = "f41l3D tO uPd@t3 phoLdER 4CC3\$\$ 5e++ingS";
$lang['manageusersexp'] = "tH1S L1S+ shOWs @ SelEc+10n oF uSers wh0 h4vE Lo993d 0N +O Y0ur f0rUm, 50r+eD 8Y %s. t0 4lTeR 4 u\$Er'S p3Rm1s5i0Ns cliCk +H3ir n4me.";
$lang['userfilter'] = "usEr Fil+3r";
$lang['onlineusers'] = "onL1nE uSeR5";
$lang['offlineusers'] = "opHfL1n3 UsERs";
$lang['usersawaitingapproval'] = "u5ERs @wAIt1NG 4PProV4l";
$lang['bannedusers'] = "b@Nn3D uS3r5";
$lang['lastlogon'] = "l@5+ lOgoN";
$lang['sessionreferer'] = "sES\$10n R3ferER";
$lang['signupreferer'] = "si9N-Up R3F3r3R:";
$lang['nouseraccountsmatchingfilter'] = "n0 UseR 4cC0Un+\$ M4+cH1N9 fILT3r";
$lang['searchforusernotinlist'] = "s34RcH pHor @ uS3r N0+ iN lI5t";
$lang['adminaccesslog'] = "adm1n 4CceS\$ lo9";
$lang['adminlogexp'] = "tHIS L1s+ shOw\$ tH3 l4S+ @c+1onS Sanct1On3d 8Y u\$Er\$ wITh @dM1n pRiv1lege\$.";
$lang['datetime'] = "d4T3/t1mE";
$lang['unknownuser'] = "uNKnOwn us3r";
$lang['unknownuseraccount'] = "unkN0wn u\$Er 4Cc0uN+";
$lang['unknownfolder'] = "unKn0wN pHolDer";
$lang['ip'] = "ip";
$lang['lastipaddress'] = "l45+ ip 4dDReSs";
$lang['hostname'] = "hOStN4Me";
$lang['unknownhostname'] = "unKNoWN hO\$+N@M3";
$lang['logged'] = "loGged";
$lang['notlogged'] = "n0T l099eD";
$lang['addwordfilter'] = "add WoRD PhiLt3r";
$lang['addnewwordfilter'] = "aDd nEw WOrD Ph1l+Er";
$lang['wordfilterupdated'] = "w0rd fIL+eR UPd4+ed";
$lang['wordfilterisfull'] = "j00 c4nN0+ 4Dd 4Ny M0Re WoRd Ph1L+eR5. Rem0ve 50m3 UnUsEd 0Ne\$ OR EdiT +H3 EXIs+1n9 0N3\$ FIrS+.";
$lang['filtername'] = "fiLt3R n4M3";
$lang['filtertype'] = "fiLteR tYpe";
$lang['filterenabled'] = "f1Lt3r en48l3D";
$lang['editwordfilter'] = "edIt w0rD pH1lt3R";
$lang['nowordfilterentriesfound'] = "no eXi5+iN9 wOrd fiLTEr EntRi35 PHoUnD. +0 4dD 4 PH1LTeR cl1cK +EH '4dD nEw' bUtt0N bEl0w.";
$lang['mustspecifyfiltername'] = "j00 mUst \$PecIphY 4 pHIl+3R N4m3";
$lang['mustspecifymatchedtext'] = "j00 mUs+ sP3cIfy m@Tch3d TExt";
$lang['mustspecifyfilteroption'] = "j00 MuSt 5pEciPhy 4 pH1lt3R 0pT10n";
$lang['mustspecifyfilterid'] = "j00 mu\$+ \$pEC1FY 4 fil+er 1D";
$lang['invalidfilterid'] = "inv4lId Ph1Lt3R 1d";
$lang['failedtoupdatewordfilter'] = "f@Il3D To Upd4Te W0rD pHilTEr. cHecK th4+ Th3 phiL+eR s+ilL eX1s+\$.";
$lang['allow'] = "aLL0w";
$lang['block'] = "blOcK";
$lang['normalthreadsonly'] = "n0rM4l +hR3@dS oNlY";
$lang['pollthreadsonly'] = "poLl +hR34Ds Only";
$lang['both'] = "bo+H +Hr3@d +yP3s";
$lang['existingpermissions'] = "eX1\$T1N9 peRmissiONs";
$lang['nousershavebeengrantedpermission'] = "no 3X1s+In9 U\$Er\$ P3RmiS\$1On\$ FoUnD. T0 9R4nT pErm1S5IoN T0 uSeR5 \$E@rCh Ph0r Th3m BeL0w.";
$lang['successfullyaddedpermissionsforselectedusers'] = "sUCcEsSfuLly 4dd3d PerM1\$\$10nS pHor \$3LEC+3D uSerS";
$lang['successfullyremovedpermissionsfromselectedusers'] = "sUcC3SsPhUlLy REm0V3d Permi55I0N5 PHr0M sEl3cT3d u5er5";
$lang['failedtoaddpermissionsforuser'] = "f@1L3D To 4dd p3rm1\$5IoN\$ FOr U\$eR '%s'";
$lang['failedtoremovepermissionsfromuser'] = "f@Il3D to R3MoV3 PeRM1s\$10nS fR0m UsEr '%s'";
$lang['searchforuser'] = "sE4rCh for u5Er";
$lang['browsernegotiation'] = "br0W\$ER NegOt14TED";
$lang['largetextfield'] = "laR9E TEX+ PH13ld";
$lang['mediumtextfield'] = "med1uM +eXT f1eLd";
$lang['smalltextfield'] = "sMALL +Ex+ fi3ld";
$lang['multilinetextfield'] = "mULti-LinE +3X+ Fi3lD";
$lang['radiobuttons'] = "r4DIo BUtT0N5";
$lang['dropdownlist'] = "dROp d0Wn Li5+";
$lang['clickablehyperlink'] = "cl1Ck48lE Hyp3RLink";
$lang['threadcount'] = "thR3aD cOUNt";
$lang['clicktoeditfolder'] = "cLIck to 3di+ FOlD3r";
$lang['fieldtypeexample1'] = "t0 cRe@t3 r4diO bUT+0n5 oR @ DroP Down l1S+ J00 N3eD +0 EnT3R E4ch inD1v1Du4L v4Lu3 on @ s3p4r@t3 l1ne in +hE OpT1On\$ fi3lD.";
$lang['fieldtypeexample2'] = "tO cRe@T3 cL1ck4bL3 lINk5 3Nt3r +h3 url In +h3 0pT1On5 pH13Ld 4nd U5E <i>%1\$S</i> wHeR3 +H3 3NTRy PHrOm +eh usER'\$ PrOPh1l3 5HouLd 4pp34r. 3X4mpL3s: <p>mYspac3: <i>htTp://Www.MySp4c3.c0m/%1\$S</i><br />xBoX lIve: <i>hTTp://Prof1l3.MY94M3rC4Rd.ne+/%1\$s</i>";
$lang['editedwordfilter'] = "editED WoRd Ph1lt3r";
$lang['editedforumsettings'] = "ed1+3d f0rUm \$E+t1n9S";
$lang['successfullyendedusersessionsforselectedusers'] = "sUCcE\$\$FULly enDed 5es\$I0nS pH0R sel3Ct3D u53r5";
$lang['failedtoendsessionforuser'] = "faIl3D +0 EnD Se\$\$i0n foR uSer %s";
$lang['successfullyapprovedselectedusers'] = "sUCCes5FuLLy 4PpR0V3d \$el3ctEd U5er5";
$lang['matchedtext'] = "m4+ch3d +eXt";
$lang['replacementtext'] = "repl4c3m3Nt +eXt";
$lang['preg'] = "pr39";
$lang['wholeword'] = "wH0Le W0rD";
$lang['word_filter_help_1'] = "<b>alL</b> M4+cHe\$ @94In\$+ Th3 WhoLe tExT 5O Ph1l+erIn9 m0M t0 mUm WiLl @lS0 Ch4n9E m0mEnT +o mUm3nT.";
$lang['word_filter_help_2'] = "<b>wHol3 WOrd</b> m4+chEs @94in5T whOl3 W0Rd\$ ONLy 50 Fil+3riN9 m0M +O Mum w1ll n0+ ch@ngE m0MenT +0 Mum3N+.";
$lang['word_filter_help_3'] = "<b>pr3G</b> aLl0WS j00 +0 uSE pErl r39uL4r 3xPR3\$\$iOn5 +0 m4+ch +3xt.";
$lang['nameanddesc'] = "n4mE @ND D3Scr1p+1oN";
$lang['movethreads'] = "mOVe +hrE4Ds";
$lang['movethreadstofolder'] = "moV3 +hrEadS T0 pHolD3R";
$lang['failedtomovethreads'] = "fAIl3d t0 M0ve thR34Ds t0 5pEc1f13D pH0ld3r";
$lang['resetuserpermissions'] = "rE\$e+ uSeR P3rmI5\$i0N\$";
$lang['failedtoresetuserpermissions'] = "f@Il3d t0 ResEt Us3r PerMis\$IOn\$";
$lang['allowfoldertocontain'] = "alLow phOldEr To C0nt@1n";
$lang['addnewfolder'] = "aDd NEW F0ldEr";
$lang['mustenterfoldername'] = "j00 mu5+ eN+eR 4 PholDer n@ME";
$lang['nofolderidspecified'] = "n0 ph0LdEr 1d \$p3CipH1ed";
$lang['invalidfolderid'] = "iNV4lId Ph0ldEr Id. ch3cK +H4t 4 PHOld3R w1+H tHis id 3xI5+\$!";
$lang['successfullyaddednewfolder'] = "suCcE\$sFULlY adDed nEw F0ld3R";
$lang['successfullyremovedselectedfolders'] = "sUcC3s\$FuLLy R3moVed \$EL3C+3d FoLD3rS";
$lang['successfullyeditedfolder'] = "sUcCeSsFuLlY Ed1+eD F0Ld3R";
$lang['failedtocreatenewfolder'] = "f4il3D tO cR3@t3 NeW pH0ldEr";
$lang['failedtodeletefolder'] = "f@IL3D To deL3t3 FoLDEr.";
$lang['failedtoupdatefolder'] = "f41l3d +O UpD4TE f0LD3r";
$lang['cannotdeletefolderwiththreads'] = "c4NnoT dELE+e Ph0LDEr5 +h@T \$tILl c0n+4in ThrE4D5.";
$lang['forumisnotrestricted'] = "fORum I5 not R35trIcTEd";
$lang['groups'] = "gr0Ups";
$lang['nousergroups'] = "no u53r GROuP\$ h@V3 83EN 5e+ uP. TO @Dd @ 9R0uP cL1CK +h3 '4dd N3w' 8utT0n 8ELOW.";
$lang['suppliedgidisnotausergroup'] = "sUPplI3d 9ID Is NO+ 4 U\$eR Gr0Up";
$lang['manageusergroups'] = "maN49e U53R gRouP\$";
$lang['groupstatus'] = "gRoUP st@+u\$";
$lang['addusergroup'] = "adD U\$eR grouP";
$lang['addemptygroup'] = "aDd 3mPTY GrOUP";
$lang['adduserstogroup'] = "add uSErs t0 GrOUp";
$lang['addremoveusers'] = "aDd/r3M0ve USeRs";
$lang['nousersingroup'] = "tHeR3 4rE n0 Us3rS 1n tHIS Group. @DD us3rS TO +hi5 9R0uP 8Y s34rCH1ng fOR +hEm BEloW.";
$lang['groupaddedaddnewuser'] = "suCC3SsfUlLY 4DD3D 9roUp. 4dD u\$ERs t0 +his 9r0up 8y SE4RCHIN9 pHOR +hEm BeloW.";
$lang['nousersingroupaddusers'] = "theRe 4R3 N0 u5Er\$ 1N +h1s grOuP. To 4Dd US3rs cLicK T3H '4dD/R3M0V3 us3R5' BuTT0n 83L0W.";
$lang['useringroups'] = "thIs USer 1S @ MEmBer Of +he Phollow1ng 9rOuP\$";
$lang['usernotinanygroups'] = "tHI\$ u5er 1S nO+ 1N 4NY UsEr GR0uP\$";
$lang['usergroupwarning'] = "n0+E: +h1\$ U\$Er M4y BE 1nh3Rit1N9 4dD1t1On4l peRmi\$\$Ion\$ Fr0M 4ny uSeR GR0uPs L1St3d bEl0W.";
$lang['successfullyaddedgroup'] = "suCC3s\$fUllY 4dD3d 9r0uP";
$lang['successfullyeditedgroup'] = "sUcC3S\$fUllY 3dIteD 9r0Up";
$lang['successfullydeletedselectedgroups'] = "sUCC35\$pHuLly d3l3+Ed 5eL3cTed grOup\$";
$lang['failedtodeletegroupname'] = "f@1l3D +o dEl3+E 9r0UP %s";
$lang['usercanaccessforumtools'] = "u5ER c4n 4Cc3S\$ f0RuM T0OLs 4nd C4n Cre4+3, D3lEt3 @Nd 3D1+ fORuM\$";
$lang['usercanmodallfoldersonallforums'] = "uSEr C4N M0D3R4te <b>aLl folDer5</b> 0N <b>aLl ph0RumS</b>";
$lang['usercanmodlinkssectiononallforums'] = "u5eR c4N m0D3R4+e L1nks 53c+iON on <b>aLl f0Rum5</b>";
$lang['emailconfirmationrequired'] = "em@iL cOnFirM4t10n R3qUir3D";
$lang['userisbannedfromallforums'] = "u53R Is B4nn3D Phr0m <b>alL phORUm5</b>";
$lang['cancelemailconfirmation'] = "c@nC3l 3M@1l CONFirM4+IoN 4nD 4ll0W u\$eR to \$+arT pOs+In9";
$lang['resendconfirmationemail'] = "r3seNd CoNfiRm4t10n Em@1L to uSeR";
$lang['failedtosresendemailconfirmation'] = "fAIl3D +0 R353nD 3m@1l C0nph1rm@+10n tO UsEr.";
$lang['donothing'] = "dO n0+HiN9";
$lang['usercanaccessadmintools'] = "u\$3R H@5 @Cc3\$\$ +o f0RUM 4Dmin +ooLs";
$lang['usercanaccessadmintoolsonallforums'] = "u\$3r h4\$ @Cc3\$\$ To 4Dmin T0oLs <b>on @LL F0rUMs</b>";
$lang['usercanmoderateallfolders'] = "u\$er c@N mOd3r@Te 4LL Ph0lD3rS";
$lang['usercanmoderatelinkssection'] = "u5ER c@N Moder@+e l1nKs Sec+ioN";
$lang['userisbanned'] = "u\$3R 1\$ 84nN3d";
$lang['useriswormed'] = "user 1S wOrm3D";
$lang['userispilloried'] = "u5Er 15 PilL0Ri3D";
$lang['usercanignoreadmin'] = "uSEr C4n i9n0rE 4dM1Ni\$TR4Tors";
$lang['groupcanaccessadmintools'] = "gr0uP c4N 4cC3Ss 4dmIn +0Ol\$";
$lang['groupcanmoderateallfolders'] = "gr0Up c@N moD3r@+e @ll phOld3Rs";
$lang['groupcanmoderatelinkssection'] = "gr0Up c@N m0Der@+3 LinK5 SEcT1ON\$";
$lang['groupisbanned'] = "gr0UP 15 84nnEd";
$lang['groupiswormed'] = "gr0UP iS w0Rm3d";
$lang['readposts'] = "r34D p05ts";
$lang['replytothreads'] = "rePlY tO +Hr34D5";
$lang['createnewthreads'] = "cR3A+E neW +Hre@d\$";
$lang['editposts'] = "edi+ po\$Ts";
$lang['deleteposts'] = "dELEtE pOstS";
$lang['postssuccessfullydeleted'] = "po\$+\$ sUcc35\$FuLLY d3l3+3d";
$lang['failedtodeleteusersposts'] = "f@1Led t0 D3L3+e u\$eR'S pO\$+\$";
$lang['uploadattachments'] = "uPLO4d AtT@chM3nt5";
$lang['moderatefolder'] = "mODeR@t3 PhoLd3r";
$lang['postinhtml'] = "pOST In hTml";
$lang['postasignature'] = "pO5+ 4 5iGn4+Ure";
$lang['editforumlinks'] = "ed1T fOrum l1Nk5";
$lang['linksaddedhereappearindropdown'] = "l1Nk5 aDd3D HerE 4pp34r IN 4 Dr0p D0wn 1N +eh +oP RI9hT OpH tHe Phr4m3 set.";
$lang['linksaddedhereappearindropdownaddnew'] = "lINk\$ @Dded h3r3 4pPe4r in 4 dr0p DowN 1n +h3 +0p R1ght oph +hE pHr4me \$Et. +o 4dd @ L1nK cL1ck teH '4dD nEw' 8utTOn 8eloW.";
$lang['failedtoremoveforumlink'] = "faIl3D T0 rEMoVe PhORUm L1nk '%s'";
$lang['failedtoaddnewforumlink'] = "f41L3D t0 4dd NeW F0RuM lInk '%s'";
$lang['failedtoupdateforumlink'] = "faIl3D t0 upd@t3 ph0rUm lInk '%s'";
$lang['notoplevellinktitlespecified'] = "no +OP lEv3l lInk +itLE Sp3ciF13d";
$lang['youmustenteralinktitle'] = "j00 mu\$+ enT3R 4 lINk tiTle";
$lang['alllinkurismuststartwithaschema'] = "alL L1Nk ur1s mU\$+ 5+Art wiTH 4 sCh3m@ (1.3. h++p://, ftP://, Irc://)";
$lang['editlink'] = "edIt lINk";
$lang['addnewforumlink'] = "adD n3w pH0rUm l1nk";
$lang['forumlinktitle'] = "fOrUm LInk t1tlE";
$lang['forumlinklocation'] = "fOrUm L1nk l0c4t1On";
$lang['successfullyaddednewforumlink'] = "suCc3S\$PhUlLy 4DdEd New f0rUm L1nk";
$lang['successfullyeditedforumlink'] = "sUcC3s5FULly ed1T3d PhOrUm LinK";
$lang['invalidlinkidorlinknotfound'] = "iNV@lId linK 1d oR lInk noT pHouNd";
$lang['successfullyremovedselectedforumlinks'] = "sUCC3\$5FuLly reMovEd S3lec+3d linK\$";
$lang['toplinkcaption'] = "tOP L1Nk c@P+IoN";
$lang['allowguestaccess'] = "aLLoW Gu3\$+ acc3S\$";
$lang['searchenginespidering'] = "sE4RCH Eng1N3 spId3r1N9";
$lang['allowsearchenginespidering'] = "aLLoW 5e4Rch 3n9IN3 5PIdER1N9";
$lang['sitemapenabled'] = "eN48l3 \$it3M4p";
$lang['sitemapupdatefrequency'] = "sIT3m4P uPd4+3 fR3Qu3Ncy";
$lang['sitemappathnotwritable'] = "s1+3m@p d1rEcTorY MU5T bE Wr1TabLe 8y +3h W38 \$ErV3r / phP pR0ce\$S!";
$lang['newuserregistrations'] = "n3W u\$eR rEgiStR@+IoN5";
$lang['preventduplicateemailaddresses'] = "preVenT dUplIcaTe Em@1l 4DDrESsE\$";
$lang['allownewuserregistrations'] = "aLLoW N3W U\$eR R3gisTr4tI0N5";
$lang['requireemailconfirmation'] = "rEQUiR3 eM4Il c0nPh1rm4+IoN";
$lang['usetextcaptcha'] = "uSE t3x+-C4PtCH4";
$lang['textcaptchafonterror'] = "t3x+-c4ptch4 h@5 8eEn dIS48l3d 4UtOm4TIc4LlY 8Ec4U\$e Th3rE 4R3 nO +rUe TYp3 pHoN+\$ @V4iL4bLe ph0R 1t +0 u5e. pLeAse uPlO4d s0ME +rUe tYP3 FOnt\$ +o <b>t3Xt_C@P+CH4/pHoN+S</b> 0n yOUR \$eRvEr.";
$lang['textcaptchadirerror'] = "t3xT-C@PTcH4 h@s 8e3n Dis48L3D 8eC@u53 THE tEx+_c4ptCH4 DirecT0Ry @nD 1T'\$ \$ub-d1ReCt0RiE5 Ar3 No+ WrIt4bLe 8y +h3 WE8 \$ErvEr / pHP pR0ce\$\$.";
$lang['textcaptchagderror'] = "t3xT-C4ptch4 h4S 8een D1548leD Bec4UsE Y0Ur SeRv3r's Php 5eTUp d03s NoT PR0vId3 SuPpoR+ FOR 9d im49E m4NipUL@t10n 4nd / oR t+f Ph0n+ Supp0r+. b0+H @rE R3qu1r3D pHOr t3X+-c4P+cH@ \$Upp0R+.";
$lang['newuserpreferences'] = "nEW User pREfEreNc3s";
$lang['sendemailnotificationonreply'] = "eM4iL nOt1pH1c4T1oN 0n RePly +0 UseR";
$lang['sendemailnotificationonpm'] = "eM@1l N0+if1C4T10n On pM +0 u5Er";
$lang['showpopuponnewpm'] = "shOw pOpUp wh3N rEceIviNg NeW Pm";
$lang['setautomatichighinterestonpost'] = "sET 4U+0M4+iC hI9h 1nTErEs+ ON Po\$+";
$lang['postingstats'] = "pos+1ng s+4TS";
$lang['postingstatsforperiod'] = "po5T1n9 St@+5 for P3ri0D %s +O %s";
$lang['nopostdatarecordedforthisperiod'] = "no POS+ D4+4 r3CoRDEd FOR tHiS p3r1Od.";
$lang['totalposts'] = "to+4l poST5";
$lang['totalpostsforthisperiod'] = "tO+Al p0\$+\$ pHor thIs PeR1oD";
$lang['mustchooseastartday'] = "mU\$+ ch005e 4 St@r+ d4y";
$lang['mustchooseastartmonth'] = "mu\$T ChOo5E 4 s+@rT mOn+H";
$lang['mustchooseastartyear'] = "mU\$+ Ch00S3 @ 5+@r+ Y3@R";
$lang['mustchooseaendday'] = "mUST ch0O5E 4 EnD d4Y";
$lang['mustchooseaendmonth'] = "mu5+ Ch0o53 @ 3Nd monTh";
$lang['mustchooseaendyear'] = "mu5+ Ch00Se 4 3Nd yeaR";
$lang['startperiodisaheadofendperiod'] = "st4R+ P3riOd 1S @He@d Oph end p3r1Od";
$lang['bancontrols'] = "b4N C0n+ROL5";
$lang['addban'] = "aDD Ban";
$lang['checkban'] = "checK 84N";
$lang['editban'] = "eDI+ b@n";
$lang['bantype'] = "b@n +yPe";
$lang['bandata'] = "b4N D4T4";
$lang['bancomment'] = "coMm3nT";
$lang['ipban'] = "iP 8AN";
$lang['logonban'] = "lo9on 8an";
$lang['nicknameban'] = "niCkN4M3 B@n";
$lang['emailban'] = "em41l 84n";
$lang['refererban'] = "r3PH3r3r 84N";
$lang['invalidbanid'] = "inv4l1d B4n 1d";
$lang['affectsessionwarnadd'] = "thi\$ 84n m4Y AfPHEct +Eh phOLL0W1nG 4Ct1v3 u5Er \$35sion5";
$lang['noaffectsessionwarn'] = "tH1\$ 84n 4fF3CT5 n0 4CtiVe se\$\$ioNs";
$lang['mustspecifybantype'] = "j00 mUs+ sp3C1fy 4 b4n +yP3";
$lang['mustspecifybandata'] = "j00 MuS+ sP3c1Fy \$0me B4n D@+4";
$lang['successfullyremovedselectedbans'] = "sUcce\$SfUllY r3MoVed selecT3d 8@N5";
$lang['failedtoaddnewban'] = "f@1L3d +0 4Dd n3w b@n";
$lang['failedtoremovebans'] = "f4iLed +o ReMoV3 \$om3 0r 4ll oF teh \$3L3c+ed 84ns";
$lang['duplicatebandataentered'] = "duplIc4T3 84N d4t@ eN+eR3d. plE45e Ch3cK yOuR wIldC4Rd\$ To \$ee 1ph +hEy 4Lre4dY m4+ch +h3 D4+4 eNt3REd";
$lang['successfullyaddedban'] = "sUCc3sSpHUllY aDdEd B4n";
$lang['successfullyupdatedban'] = "suCc35SFuLly upD4+ed 84n";
$lang['noexistingbandata'] = "tH3r3 Is nO exiS+In9 84n d4+4. +o @Dd 4 b4N cL1ck +h3 'add n3W' BU++0N b3LoW.";
$lang['youcanusethepercentwildcard'] = "j00 c4N uSe +eh PerCEn+ (%) WilDC4rd syM80l 1n 4Ny oph yOUr B4n LI5ts t0 08t@1N p@r+i@L M4tcHES, I.3. '192.168.0.%' WoulD b4N 4lL 1p adDr3S\$3S iN t3h r4n93 192.168.0.1 +hrOugH 192.168.0.254";
$lang['cannotusewildcardonown'] = "j00 c4nNoT @dD % 4S @ WiLdc4rD m@tcH oN IT'\$ OwN!";
$lang['requirepostapproval'] = "reQuIr3 Po\$+ 4PPR0V4L";
$lang['adminforumtoolsusercounterror'] = "tHERE mU5+ 8e 4t Le@st 1 u\$ER w1tH aDm1n +oOls @nD FOruM tO0l\$ @cCeS\$ on 4lL FoRUm\$!";
$lang['postcount'] = "p0st cOuN+";
$lang['resetpostcount'] = "re\$e+ pO5+ coUn+";
$lang['failedtoresetuserpostcount'] = "fAil3d T0 r353+ Po5t cOun+";
$lang['failedtochangeuserpostcount'] = "f4Il3d to Ch@Ng3 USer p05t C0unt";
$lang['postapprovalqueue'] = "p05+ @pPrOv4l qu3Ue";
$lang['nopostsawaitingapproval'] = "n0 P0\$+\$ @rE @W4it1Ng 4PProv4l";
$lang['approveselected'] = "aPPrOvE Sel3Ct3d";
$lang['failedtoapproveuser'] = "fAiL3d +0 4pprov3 U\$Er %s";
$lang['kickselected'] = "kICk 5El3C+3d";
$lang['visitorlog'] = "vI\$iT0r l09";
$lang['clearvisitorlog'] = "cLE@r v1s1+0R l09";
$lang['novisitorslogged'] = "nO ViSIt0r5 L0993d";
$lang['addselectedusers'] = "aDD \$3L3c+Ed USEr\$";
$lang['removeselectedusers'] = "r3M0Ve \$EL3cT3d Us3r\$";
$lang['addnew'] = "adD N3w";
$lang['deleteselected'] = "dELe+E s3L3Ct3D";
$lang['forumrulesmessage'] = "<p><b>f0Rum rUlEs</b></p><p>\nr3gIStr4t1On tO %1\$\$ i5 PHrEe! w3 Do inSI5T +h4t J00 48IDe 8y +eH rul3\$ @Nd P0l1CIeS D3T4IL3D BeL0w. Iph j00 49re3 t0 +h3 t3rM5, ple4Se chEck TeH '1 4Gr33' Checkb0X 4Nd pr3\$\$ t3h 'R39is+er' Bu+tOn 8ElOw. iF J00 wOulD LIK3 tO C@ncEl +H3 RegIstR4+IoN, cl1cK %2\$s t0 RETuRn +O +h3 fOrUM\$ 1Nd3X.</p><p>\n@L+H0U9h +h3 @Dm1nIs+r4+0rs 4Nd mOD3r@T0r\$ 0F %1\$S WiLL @T+Emp+ +O K33p alL O8J3c+ioN48L3 M35S49eS ofPh +hI5 PHorUm, I+ 1\$ 1mp0S\$I8LE pH0R Us +0 r3vi3W 4lL m3\$5@9e5. 4lL me\$\$4gE\$ EXpR3\$\$ +hE vi3Ws 0F +HE Au+h0R, @nD nEith3R +hE own3R\$ Of %1\$\$, nOr prOJ3cT 8EEhiv3 fORum 4nD I+'\$ 4fF1Li4+35 WiLL bE hELD rE\$p0NsIbl3 f0R TeH C0Nt3N+ OF 4nY M3s54GE.</p><p>\n8Y @9Re31NG TO The\$3 RUlE\$, j00 w4RR@nt +H4+ j00 wIlL n0+ POS+ 4nY m3s549E\$ +h4T @r3 ob\$cEnE, VuL94r, \$3XU4Lly-ORi3N+4+eD, h4+3FUL, +hre4T3NiN9, 0R 0TH3rW1\$3 V10l4TiVe 0F @Ny l4w\$.</p><p>t3H OWn3RS 0F %1\$S ReSErVe +h3 r1GhT t0 r3MoVE, 3D1t, M0Ve 0r ClOSE anY tHrE4D f0R 4NY r34\$oN.</p>";
$lang['cancellinktext'] = "hER3";
$lang['failedtoupdateforumsettings'] = "f4IlEd To Upd@+E phOruM 5eTt1ng\$. PlE4sE Try 494In l4+3r.";
$lang['moreadminoptions'] = "moR3 @Dm1N Opt10nS";

// Admin Log data (admin_viewlog.php) --------------------------------------------

$lang['changedstatusforuser'] = "ch4nGed us3R \$+4TU\$ f0R '%s'";
$lang['changedpasswordforuser'] = "ch4ng3d p4S\$WoRd Ph0r '%s'";
$lang['changedforumaccess'] = "cH4nG3d Ph0rUm 4Cc3\$\$ peRm1\$\$IOn\$ PHOr '%s'";
$lang['deletedallusersposts'] = "d3Le+eD @Ll pos+\$ For '%s'";

$lang['createdusergroup'] = "cr3ated usER 9roUp '%s'";
$lang['deletedusergroup'] = "d3Le+3d u\$Er Gr0Up '%s'";
$lang['updatedusergroup'] = "upd@t3d u\$Er 9rOuP '%s'";
$lang['addedusertogroup'] = "adD3d User '%s' t0 9r0Up '%s'";
$lang['removeduserfromgroup'] = "rEmOVe u5Er '%s' pHr0m group '%s'";

$lang['addedipaddresstobanlist'] = "aDd3d 1P '%s' To 84n li\$T";
$lang['removedipaddressfrombanlist'] = "r3MOv3d ip '%s' PhRom 84n lisT";

$lang['addedlogontobanlist'] = "add3D l09On '%s' +0 B4n List";
$lang['removedlogonfrombanlist'] = "r3M0v3D L09On '%s' phR0m B4n liS+";

$lang['addednicknametobanlist'] = "adD3d N1CKnAMe '%s' +0 8@n Li5+";
$lang['removednicknamefrombanlist'] = "rEM0V3D niCkn@m3 '%s' Phr0M b@n lis+";

$lang['addedemailtobanlist'] = "aDDeD 3m41l 4ddre5\$ '%s' +0 b4n li5+";
$lang['removedemailfrombanlist'] = "r3M0veD 3M@Il @dDr3Ss '%s' fRom b4N LI\$+";

$lang['addedreferertobanlist'] = "adD3D refEr3r '%s' t0 B4n lIs+";
$lang['removedrefererfrombanlist'] = "rEm0vEd Ref3R3R '%s' fRoM 84n Li5+";

$lang['editedfolder'] = "eD1Ted phOldEr '%s'";
$lang['movedallthreadsfromto'] = "m0VeD @Ll +HrE@d\$ PHr0M '%s' T0 '%s'";
$lang['creatednewfolder'] = "cr3@t3d nEw PH0LdER '%s'";
$lang['deletedfolder'] = "deL3+ed FoLdEr '%s'";

$lang['changedprofilesectiontitle'] = "ch4nGeD ProPh1le seC+1On +i+L3 pHr0m '%s' tO '%s'";
$lang['addednewprofilesection'] = "aDDeD n3W pr0fiL3 5eC+iOn '%s'";
$lang['deletedprofilesection'] = "dElEt3d Proph1l3 S3C+10n '%s'";

$lang['addednewprofileitem'] = "aDd3d nEw Proph1l3 it3M '%s' +0 \$eCt1oN '%s'";
$lang['changedprofileitem'] = "cH4NG3d Pr0ph1l3 Item '%s'";
$lang['deletedprofileitem'] = "d3L3t3D pr0pH1L3 1t3m '%s'";

$lang['editedstartpage'] = "eDIT3d 5t4Rt P493";
$lang['savednewstyle'] = "s@V3D N3w StYL3 '%s'";

$lang['movedthread'] = "mOVed thR34d '%s' fRoM '%s' t0 '%s'";
$lang['closedthread'] = "cLO5Ed thR34D '%s'";
$lang['openedthread'] = "oPEn3d thRe4d '%s'";
$lang['renamedthread'] = "rEn@mEd Thre@d '%s' +o '%s'";

$lang['deletedthread'] = "deLe+eD thr34d '%s'";
$lang['undeletedthread'] = "uNDEL3+3D Thr34D '%s'";

$lang['lockedthreadtitlefolder'] = "l0CkEd +hrE@d 0pt10nS oN '%s'";
$lang['unlockedthreadtitlefolder'] = "uNLOCkEd +hre4d oP+iOn5 0n '%s'";

$lang['deletedpostsfrominthread'] = "d3L3+Ed Pos+\$ PHr0m '%s' iN +Hr34d '%s'";
$lang['deletedattachmentfrompost'] = "dELE+Ed 4t+4ChmEnt '%s' FroM p05t '%s'";

$lang['editedforumlinks'] = "eDIt3d foRum l1nK\$";
$lang['editedforumlink'] = "edit3D PHoRum liNk: '%s'";

$lang['addedforumlink'] = "adD3D ph0Rum liNk: '%s'";
$lang['deletedforumlink'] = "dEl3t3D PHoRum l1nK: '%s'";
$lang['changedtoplinkcaption'] = "ch4n9ed +0p linK c4pT10n frOM '%s' +O '%s'";

$lang['deletedpost'] = "dElEt3D pOs+ '%s'";
$lang['editedpost'] = "ed1t3d pO5+ '%s'";

$lang['madethreadsticky'] = "m4dE +Hr34D '%s' s+IcKy";
$lang['madethreadnonsticky'] = "m@De ThRe4D '%s' n0N-\$T1cky";

$lang['endedsessionforuser'] = "eNDed \$3\$\$iOn F0r U\$Er '%s'";

$lang['approvedpost'] = "apPRoV3d P0\$+ '%s'";

$lang['editedwordfilter'] = "eDItEd WorD pH1Lt3r";

$lang['addedrssfeed'] = "adDeD rS5 ph3Ed '%s'";
$lang['editedrssfeed'] = "eD1+ED r5s pH33d '%s'";
$lang['deletedrssfeed'] = "dEL3tEd R5\$ f3ed '%s'";

$lang['updatedban'] = "uPD4+eD b4N '%s'. cH4nged +Yp3 Phr0M '%s' +0 '%s', cH@nG3D D4t@ froM '%s' T0 '%s'.";

$lang['splitthreadatpostintonewthread'] = "spl1T tHr34d '%s' @+ pOS+ %s  1n+0 NEw +hR34D '%s'";
$lang['mergedthreadintonewthread'] = "merG3D tHre4d\$ '%s' 4Nd '%s' 1nT0 neW ThR34d '%s'";

$lang['approveduser'] = "aPpR0v3d U5eR '%s'";

$lang['forumautoupdatestats'] = "fORuM 4Ut0 uPd@+E: \$+4tS UPD4+3d";
$lang['forumautocleanthreadunread'] = "foruM AUtO UpD4T3: thR34D UnrE@d D4t@ CLe4N3D";

$lang['ipaddressbanhit'] = "us3R '%s' I5 84nNED. 1P 4dDre\$\$ '%s' m4tCh3D B@n D@t4 '%s'";
$lang['logonbanhit'] = "us3r '%s' 1\$ 84Nn3D. Lo90n '%s' m4+Ch3d 84n d4+4 '%s'";
$lang['nicknamebanhit'] = "us3R '%s' 1\$ 84nN3D. n1cKn4m3 '%s' m@+cH3d b4N d4+@ '%s'";
$lang['emailbanhit'] = "u\$eR '%s' 1\$ 84nnEd. em@1l 4DDrE\$s '%s' M4TCHed b4n D4+4 '%s'";
$lang['refererbanhit'] = "uSEr '%s' 1\$ 84Nn3D. Ht+p r3ph3ReR '%s' M4+cH3d B@n d4t@ '%s'";

$lang['userpermenabled'] = "cH4nged P3rm5 for uSer '%s'. en@8L3d: %s";
$lang['userpermdisabled'] = "cHANg3D peRmS PhOr uSEr '%s'. D1548lEd: %s";

$lang['userpermbanned'] = "b@Nn3d";
$lang['userpermwormed'] = "worM3d";
$lang['userpermfoldermoderate'] = "fOLDeR mOd3r4+0R";
$lang['userpermadmintools'] = "aDMIn +00Ls";
$lang['userpermforumtools'] = "f0Rum +OoLs";
$lang['userpermlinksmod'] = "l1NKs mOdEr4+0r";
$lang['userpermignoreadmin'] = "igN0Re @dmIn";
$lang['userpermpilloried'] = "pILLOR13d";

$lang['adminlogempty'] = "aDmIn l09 1S 3mpTy";

$lang['youmustspecifyanactiontypetoremove'] = "j00 mU\$t \$P3cIpHY @n 4C+1On tyP3 +o r3m0vE";

$lang['alllogentries'] = "alL L0g 3n+r1E5";
$lang['userstatuschanges'] = "u\$3R S+aTu5 Ch4N9Es";
$lang['forumaccesschanges'] = "foRum aCc3\$\$ cH4n93\$";
$lang['usermasspostdeletion'] = "uS3r m4\$\$ P0s+ deL3+iOn";
$lang['ipaddressbanadditions'] = "ip @ddR3s\$ 84n 4dd1t1ON5";
$lang['ipaddressbandeletions'] = "iP 4dDres\$ 84n D3l3t1ONS";
$lang['threadtitleedits'] = "tHRE@D +ItLE 3Dit5";
$lang['massthreadmoves'] = "mA\$\$ thR34D M0VEs";
$lang['foldercreations'] = "f0Ld3r cr34t1oN5";
$lang['folderdeletions'] = "f0LdEr D3L3T1oN\$";
$lang['profilesectionchanges'] = "prOPH1lE Section ch4Nge5";
$lang['profilesectionadditions'] = "pR0FilE \$3c+IoN 4dDI+10n5";
$lang['profilesectiondeletions'] = "pr0PH1lE \$ECt1On Del3Ti0nS";
$lang['profileitemchanges'] = "prOPH1lE 1+3m ch@ngE5";
$lang['profileitemadditions'] = "pROFiL3 1+3m @dDition5";
$lang['profileitemdeletions'] = "propH1l3 I+3m d3l3tIon\$";
$lang['startpagechanges'] = "s+@Rt pAGE CH4n935";
$lang['forumstylecreations'] = "f0ruM \$TylE cRe@T1on\$";
$lang['threadmoves'] = "tHR34D moves";
$lang['threadclosures'] = "thre4d cLoSuR3\$";
$lang['threadopenings'] = "tHrE4D 0PEnIn9S";
$lang['threadrenames'] = "thRe@d Ren@mE\$";
$lang['postdeletions'] = "post DEl3+10ns";
$lang['postedits'] = "po5+ 3dit\$";
$lang['wordfilteredits'] = "wORd phil+eR 3Dit5";
$lang['threadstickycreations'] = "tHRe@d \$+ICkY crE4t1on5";
$lang['threadstickydeletions'] = "thre4d 5t1cky dEl3+Ion\$";
$lang['usersessiondeletions'] = "u\$Er \$eS\$i0n D3leT1oN\$";
$lang['forumsettingsedits'] = "f0RUM S3++1NGs ed1t5";
$lang['threadlocks'] = "tHR34d l0cK\$";
$lang['threadunlocks'] = "tHRe4D uNl0ck\$";
$lang['usermasspostdeletionsinathread'] = "u\$er m@5\$ p0St D3l3t1on\$ 1n @ +hr3@D";
$lang['threaddeletions'] = "thRE4d dEl3tIoNs";
$lang['attachmentdeletions'] = "at+4cHm3Nt DeL3t10NS";
$lang['forumlinkedits'] = "foRuM l1nK Ed1tS";
$lang['postapprovals'] = "po5+ @ppr0v4lS";
$lang['usergroupcreations'] = "u5ER grOUp Cr34+IoN\$";
$lang['usergroupdeletions'] = "u5ER 9r0uP d3L3TiOns";
$lang['usergroupuseraddition'] = "uS3r gR0uP Us3r 4ddIt10n";
$lang['usergroupuserremoval'] = "u5eR 9rOup u5eR r3mOv4l";
$lang['userpasswordchange'] = "user P4s\$WoRd Ch4n93";
$lang['usergroupchanges'] = "u\$er gr0Up Ch@NgEs";
$lang['ipaddressbanadditions'] = "iP aDdRe\$S B4n 4Dd1T1ONs";
$lang['ipaddressbandeletions'] = "iP @dDr3\$\$ 84n D3L3T1ONs";
$lang['logonbanadditions'] = "lO9On 84N @DdiTIoN5";
$lang['logonbandeletions'] = "l09On BaN dEl3t10nS";
$lang['nicknamebanadditions'] = "n1CkN4ME 84n @ddIt1on\$";
$lang['nicknamebanadditions'] = "n1cKn4m3 84n 4DD1+Ion5";
$lang['e-mailbanadditions'] = "e-M4iL b4N ADd1T10nS";
$lang['e-mailbandeletions'] = "e-M4il b4n DelE+Ion\$";
$lang['rssfeedadditions'] = "rS5 ph33d 4ddit1On5";
$lang['rssfeedchanges'] = "r55 f3ed cH4n9E\$";
$lang['threadundeletions'] = "tHR34d uNDEl3tIon\$";
$lang['httprefererbanadditions'] = "h+TP R3ph3R3R 84n 4DDIt1oN\$";
$lang['httprefererbandeletions'] = "ht+p REfER3R 8@N d3L3+10N\$";
$lang['rssfeeddeletions'] = "r55 Phe3d deL3T1oNS";
$lang['banchanges'] = "b4N Ch@N93s";
$lang['threadsplits'] = "tHR34D 5pL1ts";
$lang['threadmerges'] = "thRe4d meR9Es";
$lang['userapprovals'] = "us3R 4pPrOv@Ls";
$lang['forumlinkadditions'] = "f0Rum lInk 4dd1T1On5";
$lang['forumlinkdeletions'] = "foRUM LInk d3l3+IoN\$";
$lang['forumlinktopcaptionchanges'] = "foRuM l1nk +0P c4Pt10N ch@ngE5";
$lang['folderedits'] = "f0LD3r edIt5";
$lang['userdeletions'] = "u\$ER D3let1ON\$";
$lang['userdatadeletions'] = "uS3r d4t@ d3Le+10nS";
$lang['forumstatsautoupdates'] = "fORUm \$+4Ts @U+0 uPdAte5";
$lang['forumautothreadunreaddataupdates'] = "f0ruM 4U+0 THr3@d uNRE4D D4T@ UpD4+e\$";
$lang['usergroupchanges'] = "us3R grouP Ch@n93\$";
$lang['ipaddressbancheckresults'] = "ip 4dDReS5 b4N cH3ck Result\$";
$lang['logonbancheckresults'] = "lO9ON B4n Ch3ck r35ul+\$";
$lang['nicknamebancheckresults'] = "nICKN@mE 84N CH3cK r3Sul+\$";
$lang['emailbancheckresults'] = "eM4iL 84n cHecK rE\$ULt\$";
$lang['httprefererbancheckresults'] = "hT+p reF3rER 84N cHecK r3Sul+\$";

$lang['removeentriesrelatingtoaction'] = "rem0vE 3nTr13S Rel@tiN9 T0 4CT1on";
$lang['removeentriesolderthandays'] = "remOv3 3Ntr1Es OLdeR +Han (d4ys)";

$lang['successfullyprunedadminlog'] = "sUCCessfUlLy PRuN3d 4DmIn LoG";
$lang['failedtopruneadminlog'] = "f@1L3d +0 Prune @DmiN l09";

$lang['prune_log'] = "prUNe loG";

// Admin Forms (admin_forums.php) ------------------------------------------------

$lang['noexistingforums'] = "n0 3XIsTing PhoRum\$ phouNd. +0 CRe@t3 @ neW Ph0RUm clIcK t3h '4dD nEw' 8uttOn B3loW.";
$lang['webtaginvalidchars'] = "wEbT@9 C4n 0Nly CoNt4in upPerC453 @-z, 0-9 4nd Und3R\$C0rE Ch@R4Ct3R5";
$lang['databasenameinvalidchars'] = "d4+484\$e N4m3 CaN 0nLy ConT4IN 4-Z, @-Z, 0-9 4nD uNd3rSc0r3 ch4r4CT3r5";
$lang['invalidforumidorforumnotfound'] = "iNV4l1D ph0rUm PH1d 0r PhOruM n0+ pHoUnD";
$lang['successfullyupdatedforum'] = "sUcCeS\$FuLly upD4t3d PhOruM";
$lang['failedtoupdateforum'] = "f41Led T0 upd4+3 fOruM: '%s'";
$lang['successfullycreatednewforum'] = "suCcEs\$FuLlY cR34TeD new fORum";
$lang['selectedwebtagisalreadyinuse'] = "tHE S3lEct3D w38+Ag 1S @lR34dy 1n usE. PLe4S3 cHoOsE @N0Ther.";
$lang['selecteddatabasecontainsconflictingtables'] = "th3 s3L3CteD d4t484sE CoNt4iN5 cONFl1Ct1ng t48lE\$. cOnFl1c+1N9 t4bL3 nAm3s 4re:";
$lang['forumdeleteconfirmation'] = "aRE j00 5UR3 J00 w4nt +0 dEl3t3 @lL 0pH +H3 sElECT3D pH0RuM\$?";
$lang['forumdeletewarning'] = "pl3aSe N0t3 Th4+ J00 C@nn0+ r3cOV3R dele+ed ph0Rum\$. 0NCe d3l3T3D 4 pHorUm @nd @lL oPh It'\$ @s\$OcI@teD D4T@ 15 P3Rm4n3nTly reMovEd frOm Th3 d@+484Se. IF j00 d0 N0+ w1\$H +0 del3t3 +eH 5el3cteD pH0RuM5 PLE4sE clIck C4nC3L.";
$lang['successfullyremovedselectedforums'] = "sUCC3S\$FULlY dElE+Ed 53leC+eD PhoRUm5";
$lang['failedtodeleteforum'] = "f4IL3D +0 DeL3+eD PH0rUm: '%s'";
$lang['addforum'] = "adD F0ruM";
$lang['editforum'] = "edIt F0rUM";
$lang['visitforum'] = "v1si+ PH0RuM: %s";
$lang['accesslevel'] = "acCEsS Lev3l";
$lang['forumleader'] = "foRum l34der";
$lang['usedatabase'] = "u5e D4+484s3";
$lang['unknownmessagecount'] = "unKnOwn";
$lang['forumwebtag'] = "f0RUm we8T4g";
$lang['defaultforum'] = "d3f4uL+ PhORum";
$lang['forumdatabasewarning'] = "ple4S3 3n5Ur3 J00 53l3C+ Th3 cOrrEct D@T484SE WheN cr3@t1ng @ N3w phOrUM. oNce cr34t3d 4 n3w f0rum c4nnot Be M0veD bE+w33n @v@IL4blE D@t4b4S35.";

// Admin Global User Permissions

$lang['globaluserpermissions'] = "gL084l U5ER P3rm1\$SiONs";

// Admin Forum Settings (admin_forum_settings.php) -------------------------------

$lang['mustsupplyforumwebtag'] = "j00 mu\$+ \$uPpLY 4 foruM we8+aG";
$lang['mustsupplyforumname'] = "j00 MuS+ 5UpPLy 4 FoRum N@mE";
$lang['mustsupplyforumemail'] = "j00 mu\$+ supPly @ PhoRum 3M@iL @DDr3\$\$";
$lang['mustchoosedefaultstyle'] = "j00 mU\$+ choO5E @ dEfAuL+ FoRum \$+ylE";
$lang['mustchoosedefaultemoticons'] = "j00 mU\$t cH0O5E DeF4ul+ phOruM eMot1C0ns";
$lang['mustsupplyforumaccesslevel'] = "j00 mUS+ 5UppLy 4 Ph0rUm 4cCE5s l3vEl";
$lang['mustsupplyforumdatabasename'] = "j00 Mu5+ SUpPly 4 PH0Rum d4t484\$e N4mE";
$lang['unknownemoticonsname'] = "unkn0WN 3m0T1coNs N4m3";
$lang['mustchoosedefaultlang'] = "j00 MUs+ cH00\$e 4 dEf4uL+ FORuM l@n9U@93";
$lang['activesessiongreaterthansession'] = "acT1v3 se\$S1oN T1MeOut c@nn0+ Be 9re4+eR +h4N 5EsS1On +Ime0ut";
$lang['attachmentdirnotwritable'] = "a++@chmeNt DiRECt0rY 4nd 5yS+eM +EmP0r4rY d1RecT0ry / PhP.1n1 'Uplo@d_+MP_d1r' Mu\$+ 8E WrI+48le by thE W38 SerVeR / phP pRoc3\$\$!";
$lang['attachmentdirblank'] = "j00 mU\$+ \$uPplY A d1Rect0ry +0 54Ve @++4cHmEntS 1n";
$lang['mainsettings'] = "m41n seTT1n95";
$lang['forumname'] = "foRUm n@M3";
$lang['forumemail'] = "f0rUm 3m4Il";
$lang['forumnoreplyemail'] = "nO-r3Ply eM41L";
$lang['forumdesc'] = "f0RUm de\$cRipT1oN";
$lang['forumkeywords'] = "f0RuM K3yw0rDs";
$lang['defaultstyle'] = "dEph4uLt StyL3";
$lang['defaultemoticons'] = "d3F4UL+ eM0+1cOnS";
$lang['defaultlanguage'] = "dePh@Ul+ l4n9U@9E";
$lang['forumaccesssettings'] = "f0RUm 4CceS5 setTINg\$";
$lang['forumaccessstatus'] = "fOrUM @Cc35S s+4Tu5";
$lang['changepermissions'] = "ch4N9e PerMiS\$iOn\$";
$lang['changepassword'] = "ch4nGe P455W0Rd";
$lang['passwordprotected'] = "p45\$w0Rd prOT3C+3d";
$lang['passwordprotectwarning'] = "j00 hAv3 N0+ s3+ 4 PH0Rum p4S5wOrd. 1PH J00 d0 No+ 5ET a P4s5wORD +hE p@\$SwOrD pROteC+i0n FUnC+i0n4li+y WIlL 83 @U+0m@Tic@llY dI\$4BL3D!";
$lang['postoptions'] = "p05+ oP+IoN5";
$lang['allowpostoptions'] = "alloW p0S+ 3DiTIn9";
$lang['postedittimeout'] = "p0\$+ 3dit +1m3Ou+";
$lang['posteditgraceperiod'] = "poST ed1T gR4C3 peR10D";
$lang['wikiintegration'] = "w1k1W1KI In+E9r@TioN";
$lang['enablewikiintegration'] = "eN@8Le wIK1w1ki 1ntE9ra+10n";
$lang['enablewikiquicklinks'] = "en48le wiK1Wik1 qu1Ck L1Nk\$";
$lang['wikiintegrationuri'] = "wIK1W1K1 lOc@+1On";
$lang['maximumpostlength'] = "m4X1muM post LEnGth";
$lang['postfrequency'] = "p0\$+ pHr3quenCy";
$lang['enablelinkssection'] = "en@8lE l1nK\$ seC+10N";
$lang['allowcreationofpolls'] = "alLoW cr3@+iOn 0ph poLls";
$lang['allowguestvotesinpolls'] = "alL0w Gue\$tS tO V0+e 1n pOlL\$";
$lang['unreadmessagescutoff'] = "uNR3Ad m3\$\$49Es Cu+-0fpH";
$lang['disableunreadmessages'] = "d15@8L3 UNR34d M35\$a9E\$";
$lang['thirtynumberdays'] = "30 D4Y5";
$lang['sixtynumberdays'] = "60 d4Ys";
$lang['ninetynumberdays'] = "90 d@yS";
$lang['hundredeightynumberdays'] = "180 dAY5";
$lang['onenumberyear'] = "1 Y3@r";
$lang['unreadcutoffchangewarning'] = "dEP3nd1N9 On S3rvEr P3rpHorM4Nc3 4ND +Eh nUmbER 0PH Thr34dS y0uR PH0rUm5 ConT4in, cH4n91N9 +eh UNrEad cuT-0pHPh m@y +@Ke seveR4l MinU+eS +O cOmpL3+E. fOr TH15 rE4s0n 1t Is RecoMmeNdeD +H4+ J00 @vOId CH@nging +Hi5 53t+1N9 wh1L3 y0uR f0rum5 4rE 8uSy.";
$lang['unreadcutoffincreasewarning'] = "incr345in9 TH3 UnRe4d cuT-0phf will re\$ulT iN +hre4dS 0LdeR TH4n +eH cURR3nT cU+-0PhPh 4PpE4R1n9 @5 UnrEad PH0r 4ll U\$3R5.";
$lang['confirmunreadcutoff'] = "aR3 J00 sUR3 J00 w4nt +o cH@N93 t3H uNr3AD cuT-0phPh?";
$lang['otherchangeswillstillbeapplied'] = "cLiCK1n9 'no' WIlL 0nLy C4NceL +eh UnrE4D CU+-ofF cH@nG3\$. 0+hER Ch4n9e\$ Y0U'V3 m4d3 w1ll 5+1LL 8E S4veD.";
$lang['searchoptions'] = "se4Rch op+10Ns";
$lang['searchfrequency'] = "s3ArCh Fr3qUeNCy";
$lang['sessions'] = "s35\$IoNs";
$lang['sessioncutoffseconds'] = "sES\$i0n Cut 0phPH (\$ecoND\$)";
$lang['activesessioncutoffseconds'] = "aC+1V3 \$3\$\$IoN cU+ ophPh (\$EcoNdS)";
$lang['stats'] = "st4+5";
$lang['hide_stats'] = "hId3 s+4ts";
$lang['show_stats'] = "sHOW \$T4t5";
$lang['enablestatsdisplay'] = "en48L3 5+4t\$ D1spL4y";
$lang['personalmessages'] = "p3r\$0n@l M3\$5493\$";
$lang['enablepersonalmessages'] = "eN4bL3 pers0n@l Mes54Ges";
$lang['pmusermessages'] = "pM me\$\$4g3\$ p3R u5er";
$lang['allowpmstohaveattachments'] = "aLlOW p3RsoN@l m3S54gEs +O h4v3 @+t@ChmEnt5";
$lang['autopruneuserspmfoldersevery'] = "autO pRun3 u\$Er'\$ Pm FolDeRs 3VEry";
$lang['userandguestoptions'] = "useR 4nD GU35t 0p+Ion\$";
$lang['enableguestaccount'] = "eNA8l3 9u3\$+ @cCoUn+";
$lang['listguestsinvisitorlog'] = "lIS+ 9uE\$+\$ in V1sIt0r L09";
$lang['allowguestaccess'] = "aLloW GUE\$+ 4CcE\$\$";
$lang['userandguestaccesssettings'] = "u5ER 4nD 9ue\$t 4CC3s\$ S3T+InG5";
$lang['allowuserstochangeusername'] = "aLLoW USer\$ +0 Ch4NG3 U5ern4m3";
$lang['requireuserapproval'] = "r3quir3 U5eR aPPR0V@l By 4dM1N";
$lang['requireforumrulesagreement'] = "rEqUiRE UseR +0 4gR33 To Forum rUl3\$";
$lang['sendnewuseremailnotifications'] = "seNd nO+1pH1C4Ti0N To gLOb4L f0RUm 0WN3R";
$lang['enableattachments'] = "en@8lE @+t4Chm3NTs";
$lang['attachmentdir'] = "a+TachmenT d1R";
$lang['userattachmentspace'] = "at+4ChMen+ \$P4c3 P3r us3r";
$lang['allowembeddingofattachments'] = "alLoW EM83dDiNg oph 4+t@chM3n+5";
$lang['usealtattachmentmethod'] = "u\$3 @l+Ern@+1ve @++4cHm3n+ MEtH0D";
$lang['allowgueststoaccessattachments'] = "aLlOW gUe\$+5 t0 4CcE\$\$ Att4cHMEnt5";
$lang['forumsettingsupdated'] = "fOruM s3++in9S SucCeSsfUllY uPd4teD";
$lang['forumstatusmessages'] = "f0rUm \$+4tu5 m3S54935";
$lang['forumclosedmessage'] = "forUm cLoS3D M3sS4G3";
$lang['forumrestrictedmessage'] = "foruM R3S+riCt3d mEs\$4Ge";
$lang['forumpasswordprotectedmessage'] = "f0RuM p@5\$W0rD pRot3c+3D mES\$@9e";

// Admin Forum Settings Help Text (admin_forum_settings.php) ------------------------------

$lang['forum_settings_help_10'] = "<b>po5+ eD1t +IM3ou+</b> IS t3H +IM3 1n miNu+3\$ @pHt3r pO5t1n9 Th4t 4 us3r C@n ed1T +heir p0\$+. 1f sE+ To 0 th3R3 1\$ N0 LimI+.";
$lang['forum_settings_help_11'] = "<b>m@xImuM p0s+ l3n9tH</b> is TH3 MaXiMUM nUm8er 0PH ch4R4ct3rS th4+ wiLl 8e d15Pl4y3d 1n 4 p0S+. 1f A p0St 1S L0ng3r +h4N +Eh NUmbEr 0f ch4Rac+erS d3F1n3D hEr3 I+ w1ll be CuT 5h0RT 4Nd 4 l1nk adD3d +0 +3H 80++0m T0 4lL0W USeR\$ +o rE4d Th3 wh0LE pO\$+ On 4 SeP4rAte P@9e.";
$lang['forum_settings_help_12'] = "iPH J00 d0n't W4nt yoUr UsEr5 T0 bE @8l3 tO cR3@t3 poLlS j00 C4N d1S@bl3 +eh @b0Ve Op+IoN.";
$lang['forum_settings_help_13'] = "tHe L1nkS SEct10N oF 8EeHiVe PrOv1D3\$ @ pl@c3 phOR y0ur u5Er5 To M4INt@1N 4 l1S+ 0Ph 5It3S +H3y Phr3QueNtLy V1sIt +h4T oTh3r uS3RS M4y PhInd u5EfUL. L1Nk\$ c@n BE Div1D3D 1Nt0 c@+egOr13\$ bY pHOldeR @nD aLl0w pHoR cOmMenT5 4nD r4+ings to 8e 91v3n. 1n ord3R +0 m0deratE Th3 L1nKs \$ECt1On 4 u5eR Mu\$+ 8E r@n+Ed 9L084L mOd3r4+0R \$+4+u\$.";
$lang['forum_settings_help_15'] = "<b>s35\$i0n cu+ OpHph</b> 1s +he m4XiMum +imE 8EfOR3 A U53R'5 Se5\$I0n 1\$ D33m3D De4D 4nd +h3Y 4r3 l099ed 0u+. By dEf@uLT +Hi5 1S 24 hOUR5 (86400 53CondS).";
$lang['forum_settings_help_16'] = "<b>aCT1Ve SE\$\$IoN Cut 0pHPh</b> 1S ThE m4XiMum T1Me bEfOr3 @ U5ER'\$ \$eS5i0N i\$ de3m3d In4cT1V3 @T WhIcH poInT +HeY 3nT3R 4n 1dL3 sTaTe. in +hIS \$+4t3 th3 USer r3M4In5 Lo9g3d in, 8u+ THEy 4r3 reM0vEd pHR0m +He @c+iVE U53RS LI5+ 1N +3H 5+4t5 di\$Pl4y. OncE +h3y becoM3 @cT1v3 4941n +h3Y wIlL 8E r3-4DdEd to +h3 l1S+. 8y D3F4Ul+ +hIS Se++Ing 1s sEt +0 15 mInU+3S (900 5EcONds).";
$lang['forum_settings_help_17'] = "en4BLinG THis Op+ioN 4lLoWs bE3H1v3 +0 IncLuDe 4 5+@T5 d1\$Pl4Y 4t +he b0++oM 0pH Th3 m35S4g35 P4ne sIm1L4R +0 thE on3 u\$ed bY m4Ny FoRum 5opHtW4r3 T1tl3\$. oNc3 en48leD +Eh dI\$Pl4Y 0Ph +eh 5T4+\$ p4g3 Can bE +099l3d 1nDiv1du4lLY 8Y E4cH u\$Er. 1f TheY doN'+ W4nt +0 \$E3 IT +h3y c@n h1dE iT frOm vIew.";
$lang['forum_settings_help_18'] = "pErs0n@L m3\$s4g3\$ ar3 1NV4lU@bLE 4\$ @ w@Y of +4kiNg M0Re PRiV@tE m4++eR5 OUt oF VI3w oPH +h3 0+hEr mEM83r\$. h0weV3r IF J00 D0n'T W4nt YoUr U5erS +0 Be @8L3 T0 \$enD eacH 0THeR p3R\$0n4l meSS49eS J00 C4n D1\$48le +Hi5 OP+1oN.";
$lang['forum_settings_help_19'] = "pER\$0n4l m3S\$4g3S c@n 4LsO c0Nt41n @T+@chM3nt5 wh1cH C4n 8E u53fUL F0r 3xch4nG1n9 Fil3\$ 8E+w3En U\$eRs.";
$lang['forum_settings_help_20'] = "<b>n0+E:</b> Th3 5pac3 4ll0C@+Ion pHor pm @++@cHm3nT5 1S t@keN fROm 34CH uSEr5' M4iN 4+t@ChmEnt 4llOc@+10n 4nd 1\$ nOT In 4Dd1t1oN +O.";
$lang['forum_settings_help_21'] = "<b>eN4bL3 9u3sT 4CCoUnT</b> @llow5 V1sIT0r5 To 8RoW53 Y0uR pH0RuM 4nd r34D pos+\$ W1Th0u+ reGISt3R1Ng 4 U53R 4cCOUn+. 4 UsEr 4cCouN+ 15 \$tilL ReQU1RED ipH TheY WIsH t0 poSt 0r cH4N93 U\$Er Pr3f3reNc35.";
$lang['forum_settings_help_22'] = "<b>lI\$t 9u3\$T\$ 1n viSIToR lO9</b> 4Ll0Ws J00 +O \$P3C1fy Wh3tH3r Or no+ Unr3G15+3ReD u5Er\$ 4R3 L15+3D On t3H vI\$1TOr lO9 @Lon9 siDE ReGIs+3r3d u\$Er5.";
$lang['forum_settings_help_23'] = "b33H1V3 aLl0ws @t+4ChMEn+\$ To be Upl04d3d t0 MeS5@9eS WhEn P0steD. if J00 h4v3 Lim1t3D wE8 sP4c3 j00 m4Y wHicH to d1S48Le 4++4cHmeNt5 8y clE@r1Ng T3h b0X @80VE.";
$lang['forum_settings_help_24'] = "<b>a+t4cHm3NT Dir</b> i\$ Th3 Loc4+IOn 8eeHIve 5HOUlD StOr3 It'5 @t+4CHm3Nt\$ in. tHis d1rEC+0rY mU5t eXiS+ On YOur we8 sp@Ce @nD Mu\$+ 8e wrIt48L3 8Y +He WE8 5ERV3r / php pR0ce\$\$ otHeRw1Se Upl0@d\$ w1lL Ph@1l.";
$lang['forum_settings_help_25'] = "<b>aTTAchMent \$p@c3 P3r usEr</b> 1\$ tH3 m4XiMUm amOUN+ oF d15k Sp@Ce @ useR h4S f0r @++4Chm3nTs. oNc3 Th1S 5p4Ce 1S U5ed UP Th3 u5er c@nn0+ uPl0@D 4Ny Mor3 4Tt@chM3nts. bY dEf4uLT +h1S iS 1mB oPh sP4C3.";
$lang['forum_settings_help_26'] = "<b>all0W em8EdD1N9 0pH 4tt@chM3n+5 in m3\$54ges / \$19n@+uR3\$</b> 4Ll0w\$ U5erS t0 em8ed 4+T@cHM3nT5 1n P05+\$. 3n@bl1N9 tHi\$ op+ion wHIlE u\$eFul c4n 1ncR34\$3 YOur b4NdwId+h u549e Dr4St1c@llY under C3r+Ain conPh19uR4t1oN5 oF PHp. 1pH J00 h4v3 Lim1T3D b4NdwIdth iT 15 RecOmMenD3d +h4t J00 di\$48lE ThiS 0PT1oN.";
$lang['forum_settings_help_27'] = "<b>u\$e 4Lt3rN4T1V3 @tT4chMen+ mE+H0D</b> F0rc3\$ 8eeh1vE t0 uS3 4n Al+eRN4+Ive reTrIEV@l M3thOd ph0R @++4cHmEn+\$. 1f j00 ReC3Iv3 404 3rRor m3\$\$4gE\$ wHen trY1N9 to d0wNL0@d @t+4cHmEn+s phR0m m3s\$@9ES tRy enA8lInG tHis option.";
$lang['forum_settings_help_28'] = "tH3\$E \$eTT1n9s 4Ll0W5 y0ur foruM t0 bE 5p1Der3D 8y \$e4Rch 3n9in3\$ LIk3 Goo9l3, 4l+4vis+4 And y4hO0. if j00 \$W1tCh thi\$ 0PTi0n 0FF Y0ur f0Rum wiLl No+ bE IncLud3D In The\$e \$E4rCh 3NGIn3s R3SuLt5.";
$lang['forum_settings_help_29'] = "<b>alL0w N3w U\$Er r391\$+RATIOn\$</b> 4Ll0w5 or Di5@Ll0w\$ tHe Cr34+Ion oPH New uSeR 4cCouN+5. \$3++1ng +3h 0p+ion t0 N0 cOmPLeT3ly d1\$@8L3\$ The rEgis+r@+Ion f0rM.";
$lang['forum_settings_help_30'] = "<b>en48L3 Wik1W1K1 1Nt3gr4+IoN</b> Pr0v1D3s W1KiW0rd supP0r+ 1n Y0uR FoRum p0s+\$. 4 w1k1wORD 15 MAd3 Up 0Ph +wO 0R mOre c0nC4T3N4+3d word5 wiTh uPp3rC4s3 leTt3r5 (0pH+3N R3Ph3RR3d +0 4\$ c4mElc4SE). if J00 wRit3 @ W0Rd Thi\$ W4Y 1T wiLl @utom@+1C4LlY b3 ch4NgeD 1nto 4 HypErlINk po1nt1n9 +o Y0ur chOsEN WIK1w1K1.";
$lang['forum_settings_help_31'] = "<b>eN48L3 w1K1W1k1 QuICK linK\$</b> eN@8L3\$ T3h u\$e 0Ph m59:1.1 4nd uSeR:l090N sTyLe 3xTENd3d wIk1L1NkS WhiCh Cr3@+e hyp3rL1nkS +0 tEh \$pEc1ph13D M3sS4g3 / u\$eR PR0pHile OpH +He 5P3ciF1ed u\$eR.";
$lang['forum_settings_help_32'] = "<b>wIK1wikI loc@+1ON</b> I\$ uS3D t0 5P3ciFy +h3 urI Oph your W1k1wIk1. wH3N 3NT3r1Ng t3h urI u\$E <i>%1\$\$</i> to 1nDIc@+3 Wher3 IN +eH Ur1 +h3 W1K1W0Rd Sh0uld 4ppE4R, 1.e.: <i>hTtP://3n.wikiP3di4.0r9/Wik1/%1\$\$</i> wOuLd l1nK y0UR WikIw0rd5 t0 %s";
$lang['forum_settings_help_33'] = "<b>forUM @cC35s s+@tU\$</b> c0N+roL5 HoW U5Ers M@y 4CceS5 yoUr phorUm.";
$lang['forum_settings_help_34'] = "<b>oP3n</b> W1lL 4LL0W 4ll usER5 4nD GU3\$+\$ 4ccE\$\$ To yOuR pH0rum wIth0U+ R3\$+R1c+10n.";
$lang['forum_settings_help_35'] = "<b>cl0sED</b> PrEv3n+5 @CC3s5 phoR 4LL user5, W1tH +3H 3xC3p+iOn Of +HE 4Dmin whO m4y st1ll 4CC3\$S The @dMin p@NeL.";
$lang['forum_settings_help_36'] = "<b>rE\$+R1cTed</b> 4ll0ws +O 53+ a L1st 0Ph Us3r\$ wH0 @r3 @LLoWED 4CcE\$\$ +O y0Ur Ph0ruM.";
$lang['forum_settings_help_37'] = "<b>p455w0Rd pr0T3ctEd</b> AlL0w5 J00 t0 53+ 4 p4\$5WorD +0 giVe oU+ +o u\$eRs So They c4n 4ccE5\$ Your pH0ruM.";
$lang['forum_settings_help_38'] = "wH3N S3tt1n9 ReS+RIc+ed 0R p4\$\$W0Rd Pr0t3c+Ed M0De j00 wIll Ne3D tO \$4V3 y0Ur CHaNg3S 8eFoR3 j00 c4N cHan93 Th3 u5ER 4ccES5 PRIv1lEg35 0r P4s\$Word.";
$lang['forum_settings_help_39'] = "<b>Search Frequency</b> defines how long a user must wait before performing another search. Searches place a high demand on the database so it is recommended that you set this to at least 30 seconds to prevent \"search spamming\"fr0m K1lLIn9 +HE 5ERvER.";
$lang['forum_settings_help_40'] = "<b>p05+ fR3QUeNcy</b> iS t3H m1nImum tiMe @ u\$eR mu\$+ waIt B3phOre +HEy c@N po\$+ @G4In. th1S 5E++1ng 4l50 4FpH3Ct5 t3H Cr34+1ON Of pOll5. 5et to 0 tO dIs48lE THe rE\$+r1ct1On.";
$lang['forum_settings_help_41'] = "t3H 4bov3 0pT1ON5 cH4n93 The d3f@Ul+ v4lUe5 foR T3H U\$Er R3gi5+R@t1On fOrM. Wh3rE 4PplIc@BlE 0TH3R Se+T1n9S w1LL UsE +he ph0Rum's OwN d3F@uL+ 5ett1n95.";
$lang['forum_settings_help_42'] = "<b>prEvENT UsE oPh DUpl1C4T3 3m@il @dDr3\$535</b> PH0rcES 8e3hiv3 T0 cHecK tEh U\$er 4cC0uN+s 4g@1N5+ teH 3maIl 4ddre\$\$ The us3R 1\$ reGi5+3Rin9 W1th @nD pR0MpTs +Hem t0 USE 4NotH3r IpH i+ 1\$ aLR3@dY 1n usE.";
$lang['forum_settings_help_43'] = "<b>reQUiR3 3m4il confIrm@+iON</b> wHeN 3n4Bl3d wIll send 4N 3m4Il +0 E4cH NeW uSeR WIth 4 lInk +h@t C4n 83 UsEd +0 C0nph1rm thEiR 3m4IL @dDR3S5. Unt1L +H3y C0nf1rm tH3Ir EM41L 4ddRes5 th3Y wIll not 83 4bL3 +O p0S+ UnlEs\$ +h31r USEr p3rMiS5I0ns 4RE cH4n9ED M4nU4llY 8y 4N 4dm1n.";
$lang['forum_settings_help_44'] = "<b>u\$3 t3x+-c4PtcH4</b> pR3\$En+\$ T3H N3W U\$eR w1+h 4 m4nGl3D im4Ge Wh1cH +H3y muST c0pY 4 Num8ER fRoM iN+0 4 teXt ph1Eld 0n t3h reGiStr4+ioN FoRm. usE Th1\$ oP+IoN To Pr3v3nT 4U+0M4+3d s19N-Up V14 scR1p+5.";
$lang['forum_settings_help_47'] = "<b>pOs+ 3D1T Gr@CE Per1OD</b> 4LlOw\$ J00 +0 d3Fin3 @ P3RiOd In MiNu+3\$ WheR3 uS3rS m4Y 3dIt PoS+S W1Th0U+ +H3 'EdiT3d BY' T3xt 4pp3@r1N9 0N Th31r pos+\$. 1Ph SeT +0 0 +H3 'Edit3D bY' T3xt WiLl aLw4y5 4Pp34r.";
$lang['forum_settings_help_48'] = "<b>uNR34D ME\$\$@9E5 cu+-opHPH</b> 5P3CiPh13S How loNg MeSs49E\$ Rem41n UnrE@D. Thr3@D5 M0d1PH13d n0 l@Ter +h4n +3h p3rIod \$3lEctEd WilL @U+0m@t1c4LlY 4pP3aR 4\$ R3@D.";
$lang['forum_settings_help_49'] = "choOSin9 <b>d1S@Bl3 UnrE4d mess4GeS</b> w1ll COMpl3+ely r3mOve unRe4d mEs54gEs \$uPP0r+ 4nd reM0V3 TeH rElev@N+ Op+IonS FR0m t3h d1\$Cu5\$1ON +yP3 dr0p DoWn 0N T3H tHr3@d L15+.";
$lang['forum_settings_help_50'] = "<b>rEQu1R3 u\$3r 4pprOv@l 8y 4dM1N</b> ALl0w5 j00 +0 R3\$+R1c+ 4CcE\$\$ 8Y nEw User5 Unt1L +H3Y h4v3 BeEN 4PpRov3D by 4 mOdEraT0r 0r @dMIn. w1Th0Ut @ppRov4L 4 U\$3r c@nn0t 4ccE\$\$ 4NY 4r3@ opH tHe 8EeH1Ve phoruM 1N5+4LL4t1on 1nCluDin9 1NdIv1dU4l FOrum5, Pm Inb0X @Nd my f0RuM\$ \$Ect1ON\$.";
$lang['forum_settings_help_51'] = "us3 <b>cloS3d me\$s49E</b>, <b>rE\$+r1c+3d M35S@93</b> AnD <b>p4s\$WoRd pr0T3c+eD mE55493</b> +0 Cu\$+0M1sE t3H m3\$\$49e dI5pl4YeD when uS3R\$ aCc3\$\$ YOur f0RUM 1n teH V4R10u5 \$+4Tes.";
$lang['forum_settings_help_52'] = "j00 C4n U5E H+ML 1N Y0ur m3\$\$49E\$. hYp3rL1nKs 4ND Em@IL @Ddre\$\$3S W1lL @l\$0 be @U+0m4Tic4Lly cOnvErt3D +0 LInKs. to UsE +He D3ph4uLt 8eeH1VE pHorUm M3S\$4g3S CLE4r t3H pH13ld5.";
$lang['forum_settings_help_53'] = "<b>alL0W u5ErS tO ch4ng3 us3rn4m3</b> P3rM1t5 @lReady R3gi5+ER3D u\$Er5 t0 ChaN93 TheIr useRn4m3. wh3n 3n@8lEd j00 C@n +r4Ck +eH cH@Nge5 4 u\$Er m@k3S t0 +h31r u53RN@me vI4 +h3 4Dm1N u\$ER +00L5.";
$lang['forum_settings_help_54'] = "use <b>fORum RUl3S</b> +O 3nT3r 4N @Ccep+4BlE U\$3 P0LIcY tH4+ E4CH u\$3R mU5T 4Gr3e T0 befOrE R3G1s+3rinG on yOUR pH0RUm.";
$lang['forum_settings_help_55'] = "j00 c4n u53 hTML 1n yOuR pHoRuM rulE\$. HYpeRlINKs 4nD 3M@Il 4Ddr3\$53\$ w1lL @L\$0 83 Au+0M@+Ic@lLY C0NveRtEd +0 LINK\$. T0 u\$E tEh DEF4uL+ Beeh1v3 PHORuM 4up cL34r +h3 f13LD.";
$lang['forum_settings_help_56'] = "u\$E <b>n0-RePlY 3M@1l</b> To 5P3cIFy @N 3m4iL 4dDR3s5 th4+ d03S nOT Ex1S+ oR wIll n0t 8E moN1t0rEd f0r rePL135. tHIs 3mAiL @Ddre\$\$ w1Ll 8E usEd in +3h heAD3Rs fOr @ll 3m@1L\$ sent from y0uR PHoRUM 1nclUDiNg 8U+ Not l1M1teD t0 Po\$+ @nd pM notiF1C4+iOn5, u\$eR em41ls 4nD P4\$\$w0Rd R3mInder5.";
$lang['forum_settings_help_57'] = "i+ i\$ r3cOMMeNd3d +H@t J00 U\$3 4n 3m4iL 4dDR3\$\$ TH4t d03\$ not 3X1st +0 help cu+ dOwN On sP@m tH@+ m@y be dIrEC+ED 4+ yoUr M4iN f0rum eM41l 4ddrES\$";
$lang['forum_settings_help_58'] = "iN 4DdIti0n +0 \$impl3 \$PIDer1N9, bE3h1v3 c4n 4L50 93N3r4+e @ 5ITeMaP Ph0r T3h Ph0rUm +0 m@KE 1t E4SI3r ph0R sE@Rch 3n9IN3s T0 Ph1nD @Nd INdeX +EH MEsS49eS pOStED 8y Y0uR u\$eRs.";
$lang['forum_settings_help_59'] = "s1T3M4P5 aR3 4Ut0m4+ic4lLy 54v3d t0 +he 51TEmaPs SU8-DIReCtoRy 0pH Y0uR bEeH1Ve foRuM 1N\$t@Ll@t1On. 1f +h15 d1r3CT0rY d03\$N'+ eXIs+ J00 Mu\$t cR34T3 1t 4nd 3NSur3 +H4t 1+ is wr1T48lE 8y +eH SErver / Php prOCES\$. +0 4LL0W 5E@rch 3N91n3\$ to pH1Nd yoUR 5iTem4p j00 Mu5t @dd +h3 url TO Y0ur roBoTs.tXt.";
$lang['forum_settings_help_60'] = "dEP3nD1n9 on \$erveR p3RFoRm4Nc3 4nD +EH nUmB3R 0f fORuMs and +hr34dS Y0uR 8EEh1V3 1n5T4ll@T10n COn+@1n5, 93n3rAt1N9 4 s1+3M@P m4Y T4K3 \$Ev3R4L M1Nu+e\$ tO CoMpL3+e. 1F PeRphOrm4NCe 0ph Your servEr i\$ 4DVerSlY 4pHphEcTeD 1t iS r3C0mmENd J00 D1s48Le 93n3RAtI0n Of tHe siteM4p.";
$lang['forum_settings_help_61'] = "<b>s3nd EmaIL nOpH1t1C4+IoN +0 Glo84L 4dM1n</b> WhEn 3n@8leD WilL S3Nd @n 3M41l t0 t3H 9LoB4L ph0RUm 0wN3r\$ WH3n @ nEW Us3R 4ccOuN+ i\$ Cr34+ed.";

// Attachments (attachments.php, get_attachment.php) ---------------------------------------

$lang['aidnotspecified'] = "aID nOt Sp3cIFI3d.";
$lang['upload'] = "uPL0Ad";
$lang['uploadnewattachment'] = "uPLO4D n3w 4tt4cHmeNt";
$lang['waitdotdot'] = "w4it..";
$lang['successfullyuploaded'] = "suCc3SspHulLy Upl04DEd: %s";
$lang['failedtoupload'] = "fail3D T0 upL0@d: %s";
$lang['complete'] = "c0mplet3";
$lang['uploadattachment'] = "uPL0@D 4 File phor 4tt4ChMeN+ TO +3h me5\$49E";
$lang['enterfilenamestoupload'] = "eN+eR FilEn4m3(s) +O uPLo4D";
$lang['attachmentsforthismessage'] = "a+t4cHM3nT5 pHor th1S me\$\$493";
$lang['otherattachmentsincludingpm'] = "o+H3r @+T@cHM3Nt5 (iNClUd1nG pM m3s549e5 @nd oTheR forum5)";
$lang['totalsize'] = "tO+@l 5Iz3";
$lang['freespace'] = "fRe3 sPac3";
$lang['attachmentproblem'] = "th3rE w@5 @ Pr08l3m d0wNl04DiN9 +HiS ATt4cHmeNt. ple@5e try 494In l4t3r.";
$lang['attachmentshavebeendisabled'] = "a+T4CHmeNt5 H@vE 8eEn Di548l3d 8y +he Ph0rum 0WNeR.";
$lang['canonlyuploadmaximum'] = "j00 c4n 0NlY Upl0@D @ m@x1mUM oPh 10 ph1l3S @+ a +1m3";
$lang['deleteattachments'] = "d3LE+e Att4chM3nt5";
$lang['deleteattachmentsconfirm'] = "arE J00 \$UrE J00 W4n+ tO D3le+E +3H \$eLecTed 4tT@ChMEn+s?";
$lang['deletethumbnailsconfirm'] = "aRE j00 \$ur3 j00 w4Nt To d3LetE tH3 \$EleCT3D 4t+achment5 THUm8N4ilS?";

// Changing passwords (change_pw.php) ----------------------------------

$lang['passwdchanged'] = "p4\$5WOrd ch4n9Ed";
$lang['passedchangedexp'] = "y0UR p45\$W0rD h@5 b3En Ch4nG3d.";
$lang['updatefailed'] = "uPD4+e Ph@1L3D";
$lang['passwdsdonotmatch'] = "p4\$\$W0RDS dO NOT m4+cH.";
$lang['newandoldpasswdarethesame'] = "nEW 4nD 0Ld p4\$sWoRD\$ 4rE +3h 5ame.";
$lang['requiredinformationnotfound'] = "requIR3d InpH0rM4T10N N0t f0UnD";
$lang['forgotpasswd'] = "f0R9OT P@s\$w0rD";
$lang['resetpassword'] = "r3\$3t p@s\$W0rd";
$lang['resetpasswordto'] = "r3SET p@s\$WOrD T0";
$lang['invaliduseraccount'] = "inV@l1D u\$eR 4cC0un+ 5p3c1Fi3d. cH3ck Em41l F0r C0rr3ct l1nK";
$lang['invaliduserkeyprovided'] = "inv4l1D u5Er kEy pR0v1Ded. cH3Ck em4iL pHoR CorR3Ct L1nk";

// Deleting messages (delete.php) --------------------------------------

$lang['nomessagespecifiedfordel'] = "n0 M3S549e \$pEc1pH13d Ph0r d3lEt10n";
$lang['deletemessage'] = "d3lE+E M3S\$4g3";
$lang['postdelsuccessfully'] = "p0ST DeL3T3d 5Ucc35\$PhUlly";
$lang['errordelpost'] = "eRR0R dEl3T1Ng P05+";
$lang['cannotdeletepostsinthisfolder'] = "j00 C4NN0+ D3Le+e P05+\$ in th1S PhOlDeR";

// Editing things (edit.php, edit_poll.php) -----------------------------------------

$lang['nomessagespecifiedforedit'] = "n0 m3\$549e 5p3c1FI3D pH0r eD1T1n9";
$lang['cannoteditpollsinlightmode'] = "c@NnOT 3d1t p0LL5 1n lI9H+ m0de";
$lang['editedbyuser'] = "eD1+ed: %s bY %s";
$lang['editappliedtomessage'] = "edIT 4pPl1ed +0 Me5\$49e";
$lang['errorupdatingpost'] = "eRRoR UpdAtinG p05+";
$lang['editmessage'] = "ed1T Me\$\$aGe %s";
$lang['editpollwarning'] = "<b>not3</b>: EdIt1n9 C3rt@iN @sp3ct5 oPH 4 P0Ll W1ll v01d 4Ll TH3 cuRrent vot3S @nD aLl0W p30Pl3 To v0Te 4G4In.";
$lang['hardedit'] = "h4rd 3dit 0p+Ion\$ (v0t3S WilL bE rE\$Et):";
$lang['softedit'] = "soPht ed1T 0p+Ion5 (v0+e\$ W1LL 8E rEt41n3D):";
$lang['changewhenpollcloses'] = "ch@Nge wHen t3h PolL cL05e\$?";
$lang['nochange'] = "nO Ch4n9e";
$lang['emailresult'] = "em4Il R3\$Ult";
$lang['msgsent'] = "m3S\$49e sEn+";
$lang['msgsentsuccessfully'] = "m3s\$49e SEN+ 5uCc3S5FuLly.";
$lang['mailsystemfailure'] = "m@iL \$Y\$+3m F41LuR3. mE\$\$A9E n0+ \$Ent.";
$lang['nopermissiontoedit'] = "j00 4rE NO+ P3Rm1t+ed +O 3Dit +h1s Me\$\$4g3.";
$lang['cannoteditpostsinthisfolder'] = "j00 c4Nn0+ Ed1t Po\$+\$ 1N +his ph0ldEr";
$lang['messagewasnotfound'] = "m3s5@9E %s W4s N0+ fOuNd";

// Email (email.php) ---------------------------------------------------

$lang['sendemailtouser'] = "seNd em@1L +0 %s";
$lang['nouserspecifiedforemail'] = "nO uS3r SPec1Fi3d fOr Em@1L1Ng.";
$lang['entersubjectformessage'] = "en+ER 4 suBJ3c+ fOr THE m3S\$4G3";
$lang['entercontentformessage'] = "enT3r 50me c0n+EnT FoR T3H Mes\$agE";
$lang['msgsentfromby'] = "th1s Me5\$49e W4S \$eNT FR0M %s 8y %s";
$lang['subject'] = "suBj3c+";
$lang['send'] = "s3Nd";
$lang['userhasoptedoutofemail'] = "%s h4s 0P+ed ou+ oF 3m@1l CON+4Ct";
$lang['userhasinvalidemailaddress'] = "%s H4S 4N Inv4l1D 3m4Il 4ddre55";

// Message nofificaiton ------------------------------------------------

$lang['msgnotification_subject'] = "meS\$agE N0TiPh1c4Ti0n Phr0M %s";
$lang['msgnotificationemail'] = "h3Ll0 %s,\n\n%s POs+ed 4 m3\$\$4Ge tO J00 0n %s.\n\n+hE 5u8J3ct is: %s.\n\nto re@d +h4+ m3\$\$@9e 4nd 0+HerS 1N +3H S@M3 discu\$\$Ion, 9o +0:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nN0te: 1pH j00 Do nOt wi\$H to ReC3iv3 Em4Il nOt1ph1C4+iOnS OpH pHORuM Me\$\$4geS PoSt3D +0 you, 90 +0: %s ClIck 0N mY cOn+R0l\$ +h3N 3m4IL 4Nd Pr1v4cy, UNs3l3cT +HE 3M@iL nOtiF1cATi0N cHeCkBox @nd pr3S\$ sUbM1t.";

// Thread Subscription notification ------------------------------------

$lang['subnotification_subject'] = "suB5crIptIon nO+iF1CaT10N From %s";
$lang['subnotification'] = "h3Ll0 %s,\n\n%s p0s+3d @ Me5\$49E 1N 4 +hr34d j00 H4v3 Su85Cri83d +0 0n %s.\n\n+h3 \$u8j3Ct i\$: %s.\n\nT0 RE@d +h@+ m3s\$4Ge @nD otHeRs 1N +Eh s4Me D1scu5\$IoN, 9O T0:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nN0tE: 1Ph j00 d0 n0+ W15h t0 R3C31vE 3m@1l Not1Ph1c4+1On5 OpH new me\$\$49Es 1N +hi5 ThR34D, 9O +0: %s 4Nd 4djusT YoUR 1NTeR3\$T lEv3l 4t +He BO++0M 0ph +h3 p4g3.";

// PM notification -----------------------------------------------------

$lang['pmnotification_subject'] = "pm nO+1fIc4+1oN fRoM %s";
$lang['pmnotification'] = "h3llO %s,\n\n%s P0\$+3d @ pm +0 j00 0n %s.\n\n+he Su8JeC+ iS: %s.\n\nt0 r34d +3h MEs\$4g3 GO +0:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nNoTe: 1pH j00 d0 n0+ wI5h T0 rec3iv3 3M41L n0T1phIc4T10N5 oph NeW Pm Me\$\$4G3S PO5+ed +0 Y0u, 9O +0: %s CLicK my con+rolS TheN Em41L 4Nd pR1V4cy, Un\$eL3Ct +EH Pm N0t1pH1cA+1On ch3CkB0x 4ND PR3\$\$ 5U8Mit.";

// Password change notification ----------------------------------------

$lang['passwdchangenotification'] = "p@\$SwoRd ch4Ng3 N0T1Fic4+iOn frOm %s";
$lang['pwchangeemail'] = "hElL0 %s,\n\ntH1\$ a N0T1ph1c@+iOn 3M41l +o 1nf0rM J00 TH@+ yOuR p45\$W0rd On %s H4s bEeN Ch@nGed.\n\nIT H45 8eEn CH@n93D +0: %s 4nD W4\$ Ch4n9Ed bY: %s.\n\nipH j00 h4vE rEc3IvEd ThIS Em4iL 1N 3rROR 0R weR3 noT 3Xp3Ct1n9 4 cH@NgE tO YOuR P4\$\$W0rD pL3@Se c0N+aCt +Eh Ph0RuM 0wNeR Or @ M0Der@t0r 0n %s 1mM3d14+Ely tO COrr3Ct i+.";

// Email confirmation notification -------------------------------------

$lang['emailconfirmationrequiredsubject'] = "eM@Il Confirm4T1On reQu1r3d ph0r %s";
$lang['confirmemail'] = "h3LLo %s,\n\nYou R3C3NtLy cRe@T3d 4 n3w uSer 4cc0Unt 0n %s.\n8Ef0rE j00 C@N s+4R+ p0S+In9 We neEd +0 CoNph1rM yOuR 3M@1l 4Ddr3\$\$. d0n'+ wOrrY +H1S i5 qu1t3 34sY. @Ll j00 nEed +0 dO 1S cLicK +Eh LinK 8Elow (Or CoPy 4Nd P45T3 it int0 yoUr 8RoW5Er):\n\n%s\n\nOncE c0nfIrM4t1oN 15 C0mpl3+e j00 m4Y l09in @Nd S+4rt pOs+in9 1MMedI@+3Ly.\n\n1f J00 d1d n0t cRE4t3 4 u\$eR 4CcoUn+ on %s pL34\$3 @cCePt 0ur 4poL091Es @ND FOrW4Rd +h1\$ 3M4il +o %s S0 Th4+ +eh 50urC3 OpH i+ m4Y 83 inVe\$+Igat3d.";
$lang['confirmchangedemail'] = "h3lLO %s,\n\ny0U r3CenTly ch@ngeD y0Ur 3M@1l on %s.\n8EFoRE J00 C@n \$+4RT Po5+iNg @941n we nEEd +O C0npH1rm yOur n3W em41l 4ddReS\$. D0N't wOrRY ThiS 1\$ qu1T3 34\$y. alL j00 n3ed +0 do 1S cLicK +3H LinK bElOw (oR c0pY 4nD P@5+e 1t INtO Y0uR 8R0WsEr):\n\n%s\n\n0ncE C0nfiRm@+10N 1\$ c0Mpl3+e j00 M@y c0n+InU3 +0 u\$E TeH PHoRuM as n0rm4L.\n\niF j00 w3Re n0T eXP3CtIng Thi\$ 3M@1l phR0M %s pLe4s3 @ccEp+ Our 4pOl091E5 @nD F0rw4rD TH1S Em@1l tO %s \$0 Th@+ th3 S0uRC3 0Ph 1+ M4y Be 1Nves+I94+3d.";

// Forgotten password notification -------------------------------------

$lang['forgotpwemail'] = "hELL0 %s,\n\nYoU r3Qu35+Ed ThiS e-mAil phrom %s BeC4Us3 j00 H4Ve pH0r9oT+En Y0ur p@\$sWoRd.\n\ncLiCk +eh liNK 8ELow (Or CoPy @nD pAS+3 i+ iNtO YouR 8rOw5ER) t0 RE\$3t YoUR P4\$\$WOrD:\n\n%s";

// Admin New User Approval notification -----------------------------------------

$lang['newuserapprovalsubject'] = "n3W U\$er 4pPr0v4l nOtIF1c@tiOn PH0R %s";
$lang['newuserapprovalemail'] = "Hello %s,\n\nA new user account has been created on %s.\n\nAs you are an Administrator of this forum you are required to approve this user account before it can be used by it's owner.\n\nTo approve this account please visit the Admin Users section and change the filter type to \"Users Awaiting Approval\"OR cLicK tHE lInk BeLow:\n\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nn0tE: OTHEr 4dM1N1\$Tr4toR5 on +H1S fOrUm W1Ll 4Ls0 r3c3iVe Th15 Not1pHic@+iOn And m@Y h4V3 ALr3@dY @CteD uP0n +H1s ReqU3\$+.";

// Admin New User notification -----------------------------------------

$lang['newuserregistrationsubject'] = "n3W U\$3r 4cC0unT nOt1f1C4+ion PHoR %s";
$lang['newuserregistrationemail'] = "h3llO %s,\n\nA n3W u\$eR 4cCOuN+ h4S 8eEn cr3@+3d 0n %s.\n\n+0 ViEw +HI5 uS3r 4Cc0uN+ pL34S3 vI51t +H3 4dM1n u\$eRs s3ct1on 4nD ClICk 0n Th3 N3w u\$Er Or CliCk +he lInk 83L0w:\n\n%s";

// User Approved notification ------------------------------------------

$lang['useraccountapprovedsubject'] = "u\$er 4ppR0v4l NoT1f1c@+10n FoR %s";
$lang['useraccountapprovedemail'] = "h3lL0 %s,\n\nyoUR u5Er 4cC0uN+ 4t %s h4S b33N 4pPr0veD. J00 c@N Lo91n 4Nd 5+@Rt P0s+1nG 1mMedI@+ly 8Y CliCkiN9 THe link below:\n\n%s\n\niF J00 WEr3 not 3XPEc+1ng +h15 3m@Il FRom %s Ple@sE 4Cc3PT 0Ur 4PoL09I3s 4nD FoRw4rD +h1S em4il +0 %s \$0 +haT +HE 50UrC3 0pH I+ M@y 83 InvEs+19@Ted.";

// Admin Post Approval notification -----------------------------------------

$lang['newpostapprovalsubject'] = "post 4Pprov4l N0t1pH1c@+10N f0R %s";
$lang['newpostapprovalemail'] = "h3lLO %s,\n\n4 nEW PoS+ h@s 8EeN Cr34T3D oN %s.\n\n45 j00 4Re @ m0D3RaT0r on +hI5 phOrum j00 aR3 REQuir3D +0 4pPr0ve ThIS p05+ 8EphOR3 1+ c4n Be Re4D by 0THeR UserS.\n\ny0U c@N 4pPrOve thI\$ Po5+ 4Nd @nY o+h3rs peND1n9 @PpR0V@L 8y vISi+iN9 +eh AdM1N PoS+ @ppROv@L S3ct1On OPh yOuR PhORum Or bY cl1CK1N9 +hE liNk B3lOW:\n\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nn0T3: OtHeR @dM1n15Tr@+0Rs oN +HiS f0RuM W1LL 4LSo r3CeiV3 Th1S noT1f1C@+I0n 4nD M@Y H@v3 @lR34Dy 4cT3d UpoN +hI\$ R3QuE\$+.";

// Forgotten password form.

$lang['passwdresetrequest'] = "youR PAs5wOrD R3\$E+ R3qU3\$+ fR0m %s";
$lang['passwdresetemailsent'] = "p4s5WorD rE\$Et E-M4Il \$eNT";
$lang['passwdresetexp'] = "j00 sHouLd 5H0RtlY r3C3Iv3 @n e-m4Il CoNt4In1n9 1n5+ruc+iON\$ fOr R3\$3t+1nG yOUr P4\$5woRd.";
$lang['validusernamerequired'] = "a v@l1D u\$eRn4me 1s ReqU1r3d";
$lang['forgottenpasswd'] = "f0rG0+ p@s\$W0rd";
$lang['couldnotsendpasswordreminder'] = "c0UlD NOt s3ND p@5\$w0Rd Rem1Nd3r. pl34\$E c0nT4ct +hE F0RuM 0wNer.";
$lang['request'] = "rEQu3S+";

// Email confirmation (confirm_email.php) ------------------------------

$lang['emailconfirmation'] = "em41l c0npHirM@+10n";
$lang['emailconfirmationcomplete'] = "tH@nk j00 PH0R C0NfIrm1n9 YOUR 3m@1L 4DdRes5. j00 M4Y N0W L09in 4Nd 5+@rT po5+iNg 1MmeD1aT3Ly.";
$lang['emailconfirmationfailed'] = "em@1l cOnpH1rm4t1ON h4s f@1L3d, PlE@5E tRy 4g4IN LatEr. if j00 3nCoUn+er +h15 errOR mUl+1pLe +1me5 Pl34Se C0nt4c+ t3H pH0rum oWneR 0r 4 m0Der@+0r fOR 4S\$I\$+@Nce.";

// Links database (links*.php) -----------------------------------------

$lang['toplevel'] = "t0P L3veL";
$lang['maynotaccessthissection'] = "j00 m4y nOt 4cc3S\$ th15 S3ct1ON.";
$lang['toplevel'] = "t0p Lev3L";
$lang['links'] = "l1nK\$";
$lang['externallink'] = "ex+erN@l l1nK";
$lang['viewmode'] = "vIEw modE";
$lang['hierarchical'] = "h1er4rChiC4l";
$lang['list'] = "liS+";
$lang['folderhidden'] = "thIs phOLDeR iS h1dD3n";
$lang['hide'] = "h1D3";
$lang['unhide'] = "unhidE";
$lang['nosubfolders'] = "n0 \$U8pHOld3Rs 1n +hIs C@t3gOry";
$lang['1subfolder'] = "1 SUbfOld3r 1n THiS cAteGOrY";
$lang['subfoldersinthiscategory'] = "su8pholdErs 1n +hiS c4+E9ory";
$lang['linksdelexp'] = "enTr13\$ In 4 dEl3tEd pH0lDer w1lL 8e m0veD +0 +h3 paREn+ FolDer. oNly f0lD3r5 wH1Ch D0 NOT con+41n 5uBf0lDerS m@y 83 D3L3+Ed.";
$lang['listview'] = "l1\$+ vI3W";
$lang['listviewcannotaddfolders'] = "c@NN0+ @dd phOldErs 1n Th15 v13w. \$HOwIn9 20 3NtrIes at 4 tiM3.";
$lang['rating'] = "ra+iNg";
$lang['nolinksinfolder'] = "n0 l1nK5 1n thI\$ F0ldEr.";
$lang['addlinkhere'] = "aDD LINk Her3";
$lang['notvalidURI'] = "tH4+ 1\$ n0T 4 v4LiD uRi!";
$lang['mustspecifyname'] = "j00 mu5+ sP3C1fY 4 n4m3!";
$lang['mustspecifyvalidfolder'] = "j00 MU\$+ sPeCIpHy @ v4L1d FOld3r!";
$lang['mustspecifyfolder'] = "j00 mUS+ speCiPHY @ F0ldEr!";
$lang['successfullyaddedlinkname'] = "suCc3sSfULLY 4Dd3d linK '%s'";
$lang['failedtoaddlink'] = "f@Il3D +0 4dD l1nk";
$lang['failedtoaddfolder'] = "f4Il3d tO 4dD fOldEr";
$lang['addlink'] = "aDd 4 lInK";
$lang['addinglinkin'] = "aDDin9 Link iN";
$lang['addressurluri'] = "adDRe\$\$";
$lang['addnewfolder'] = "aDD @ neW foldEr";
$lang['addnewfolderunder'] = "aDd1N9 n3W fOLdeR uNdEr";
$lang['editfolder'] = "eD1t Ph0ldEr";
$lang['editingfolder'] = "eD1TinG FOldER";
$lang['mustchooserating'] = "j00 mu5+ ch00se a r4t1n9!";
$lang['commentadded'] = "youR c0Mm3n+ W4S 4ddEd.";
$lang['commentdeleted'] = "c0MmeNt W45 d3l3T3D.";
$lang['commentcouldnotbedeleted'] = "c0MMeNT cOULd n0t Be dEl3+Ed.";
$lang['musttypecomment'] = "j00 mu\$+ TypE a COmm3N+!";
$lang['mustprovidelinkID'] = "j00 mU\$+ pR0v1d3 4 l1nK ID!";
$lang['invalidlinkID'] = "inV4l1d liNk 1d!";
$lang['address'] = "aDdRE5\$";
$lang['submittedby'] = "su8mIt+eD by";
$lang['clicks'] = "cliCk5";
$lang['rating'] = "r@TiNG";
$lang['vote'] = "vo+3";
$lang['votes'] = "vO+Es";
$lang['notratedyet'] = "n0+ r4+ed 8y 4ny0Ne Y3t";
$lang['rate'] = "r4+3";
$lang['bad'] = "b4D";
$lang['good'] = "g0Od";
$lang['voteexcmark'] = "vo+E!";
$lang['clearvote'] = "cle@r V0T3";
$lang['commentby'] = "c0Mm3n+ bY %s";
$lang['addacommentabout'] = "adD 4 c0mmEn+ 48Ou+";
$lang['modtools'] = "mODEr@tioN +0oL\$";
$lang['editname'] = "eD1+ NaM3";
$lang['editaddress'] = "ediT 4dDre\$\$";
$lang['editdescription'] = "eDI+ DeScr1P+1oN";
$lang['moveto'] = "m0VE t0";
$lang['linkdetails'] = "l1nK D3+@Il\$";
$lang['addcomment'] = "aDD cOmmEN+";
$lang['voterecorded'] = "your v0T3 H4s BeEn R3coRd3d";
$lang['votecleared'] = "youR v0t3 h4\$ 8E3n Cl34r3D";
$lang['linknametoolong'] = "lInk n4me Too lon9. M4X1MuM 1\$ %s cH@R4C+3rS";
$lang['linkurltoolong'] = "lInK Url +00 l0ng. m4X1MuM 1\$ %s Ch4R@c+er5";
$lang['linkfoldernametoolong'] = "foLdEr N4m3 toO L0n9. m4XimUm Len9+H 1\$ %s Ch4r4C+3rS";

// Login / logout (llogon.php, logon.php, logout.php) -----------------------------------------

$lang['loggedinsuccessfully'] = "j00 l0Gg3d 1N 5ucC35SfUllY.";
$lang['presscontinuetoresend'] = "preS\$ cOn+InUe To r3\$End foRm d@+4 Or C4Nc3L +0 R3L04D p@93.";
$lang['usernameorpasswdnotvalid'] = "tEH U5ErN4me or p4\$SwOrd J00 \$upPl13d I5 NoT v4lId.";
$lang['rememberpasswds'] = "rEMeM83r P4S5WoRd\$";
$lang['rememberpassword'] = "rEM3M8eR p4\$SwOrD";
$lang['enterasa'] = "ent3r 4\$ A %s";
$lang['donthaveanaccount'] = "don'+ h4vE @N @cCouN+? %s";
$lang['registernow'] = "r39Ist3r noW";
$lang['problemsloggingon'] = "pRObL3ms Lo991n9 On?";
$lang['deletecookies'] = "dElE+E Co0k13s";
$lang['cookiessuccessfullydeleted'] = "coOk1Es \$UCcE\$5FulLY d3L3ted";
$lang['forgottenpasswd'] = "fORg0++3N YoUr P@5\$wOrd?";
$lang['usingaPDA'] = "u51N9 @ pd4?";
$lang['lightHTMLversion'] = "l19hT htmL v3R5ioN";
$lang['youhaveloggedout'] = "j00 hAve L09Ged 0u+.";
$lang['currentlyloggedinas'] = "j00 4r3 CurRenTly l09gED 1n 4S %s";
$lang['logonbutton'] = "loG0n";
$lang['otherdotdotdot'] = "oTHER...";
$lang['yoursessionhasexpired'] = "y0ur \$E\$SiOn H4s 3xp1R3D. j00 wIll n33D T0 l091N 4G4In +0 c0N+iNu3.";

// My Forums (forums.php) ---------------------------------------------------------

$lang['myforums'] = "my Ph0RUm\$";
$lang['allavailableforums'] = "aLL 4V@1l4bL3 f0rUmS";
$lang['favouriteforums'] = "f@VOuR1+e f0ruMs";
$lang['ignoredforums'] = "i9n0rEd F0rUms";
$lang['ignoreforum'] = "iGn0R3 pH0RuM";
$lang['unignoreforum'] = "uN19nOR3 F0RuM";
$lang['lastvisited'] = "l4S+ V1SiTEd";
$lang['forumunreadmessages'] = "%s UNre4d me\$\$4gE\$";
$lang['forummessages'] = "%s M3\$\$4G3\$";
$lang['forumunreadtome'] = "%s UNre@D &quot;tO: Me&quot;";
$lang['forumnounreadmessages'] = "n0 unR34d mE5\$49Es";
$lang['removefromfavourites'] = "rem0v3 PhROM Ph4vOurite\$";
$lang['addtofavourites'] = "aDD To Ph4V0uR1t3S";
$lang['availableforums'] = "av4il@8l3 ForUM5";
$lang['noforumsofselectedtype'] = "tH3R3 4Re No foRums oPh +h3 \$eL3c+eD +YPe aV4iL48Le. pl34sE 53leCT 4 d1FPh3R3NT +YpE.";
$lang['successfullyaddedforumtofavourites'] = "sUCceS\$FuLly 4DdeD phorUm +0 pH4Vour1t3\$.";
$lang['successfullyremovedforumfromfavourites'] = "suCc3\$SfUllY rEm0vEd F0ruM FRom f4V0urIt3s.";
$lang['successfullyignoredforum'] = "suCc35\$PHUlLy 1Gn0ReD pHorUm.";
$lang['successfullyunignoredforum'] = "suCcEsSfUllY uN19nOrED ForUm.";
$lang['failedtoupdateforuminterestlevel'] = "f41l3d t0 Upd4+e Ph0RUM 1N+ER3\$+ Lev3L";
$lang['noforumsavailablelogin'] = "tHERe @r3 n0 pHorUm\$ @V4Il@8L3. pl34\$E l09iN +0 v13w Y0UR PhORUm\$.";
$lang['passwdprotectedforum'] = "p45\$WoRd PRot3cTEd f0rUm";
$lang['passwdprotectedwarning'] = "tH1S ForUm I\$ p4SsworD PR0+3c+ed. to 9@1n 4Cce5\$ 3nTEr t3h p4s\$w0rD bELow.";

// Message composition (post.php, lpost.php) --------------------------------------

$lang['postmessage'] = "p0\$+ m3s\$4g3";
$lang['selectfolder'] = "sELec+ pholDeR";
$lang['mustenterpostcontent'] = "j00 mus+ En+Er \$oMe C0N+eNt f0r T3h P05+!";
$lang['messagepreview'] = "meS\$4Ge Pr3v1Ew";
$lang['invalidusername'] = "inV@L1d UsErn4m3!";
$lang['mustenterthreadtitle'] = "j00 mU5T 3Nt3r 4 T1+l3 PhOr +h3 +hrE@d!";
$lang['pleaseselectfolder'] = "pl3@Se s3l3Ct 4 FolD3r!";
$lang['errorcreatingpost'] = "eRR0r CreatiN9 pOst! PLe4S3 tRy Ag41n 1N A pH3W m1Nut3\$.";
$lang['createnewthread'] = "cR3At3 NeW +hre@d";
$lang['postreply'] = "pO\$+ r3pLy";
$lang['threadtitle'] = "tHre4d T1tlE";
$lang['messagehasbeendeleted'] = "me\$54g3 N0+ fOuNd. ChEcK +h4t 1t h4sN'+ 8eEn D3l3+ED.";
$lang['messagenotfoundinselectedfolder'] = "mES\$49E N0T Found In SEl3c+3d pholDeR. CHeCk th4+ it h4\$N'T B3eN M0veD or dEL3+3d.";
$lang['cannotpostthisthreadtypeinfolder'] = "j00 c4nNoT P05+ +H1\$ THr3@D TYpe in thAT ph0ldEr!";
$lang['cannotpostthisthreadtype'] = "j00 C4Nn0+ po5+ tHIs thRe4d +yP3 4\$ +hEr3 @r3 N0 av@il@8L3 FoLDErs Th@+ 4lLOW 1t.";
$lang['cannotcreatenewthreads'] = "j00 C4NnOt cr34t3 n3w Thr34d\$.";
$lang['threadisclosedforposting'] = "thI\$ thRe4D 1s cL0S3d, j00 c@NnoT PoS+ 1n i+!";
$lang['moderatorthreadclosed'] = "w@rnIng: this +HrE@d 1s Cl0Sed f0R p0S+1N9 +0 norm@L u\$eR5.";
$lang['usersinthread'] = "u\$ErS 1n +Hre@d";
$lang['correctedcode'] = "corREc+3D C0d3";
$lang['submittedcode'] = "sU8m1TTeD cOd3";
$lang['htmlinmessage'] = "h+Ml in Me\$\$493";
$lang['disableemoticonsinmessage'] = "dIS48l3 EmOt1c0N5 iN Me\$\$49E";
$lang['automaticallyparseurls'] = "aUT0m4+Ic@lLY p4rsE urL5";
$lang['automaticallycheckspelling'] = "aut0M@+Ic4lLy Ch3cK \$P3ll1NG";
$lang['setthreadtohighinterest'] = "s3+ Thr34d T0 hiGH 1n+er3\$T";
$lang['enabledwithautolinebreaks'] = "eN@8LED W1+h 4U+0-l1n3-8rE@k5";
$lang['fixhtmlexplanation'] = "tH1\$ FoRuM u5E\$ HtMl FiL+eR1n9. yoUr \$U8miTteD H+mL H4s 8EEn mOdIfI3d 8y +eH pHilTer\$ In 50ME w4y.\\n\\nTo viEw Your or1giN4l C0de, 5eL3cT +he \\'\$u8MiTt3D cOd3\\' r@d1O BUTt0n.\\nTo vi3w thE m0d1f1eD cOD3, 5eL3ct +eH \\'corr3cT3d C0d3\\' R4DIo butT0n.";
$lang['messageoptions'] = "m3s5@9e oP+iOn\$";
$lang['notallowedembedattachmentpost'] = "j00 @Re Not 4lL0W3D +0 EmbEd aT+@Chm3nts 1N Y0Ur POs+\$.";
$lang['notallowedembedattachmentsignature'] = "j00 4r3 NoT 4lL0w3d To em83D 4TTaChm3nT5 1n yoUr 5I9N4tuRe.";
$lang['reducemessagelength'] = "mES\$49E l3n9Th Mus+ bE unDeR 65,535 cH@R@C+3Rs (CuRreNtlY: %s)";
$lang['reducesiglength'] = "sIGN4TUrE lEn9th mu5+ 8e unD3r 65,535 CH4R4Ct3rS (CuRreN+lY: %s)";
$lang['cannotcreatethreadinfolder'] = "j00 C@Nn0t crE4t3 n3w +HrE4dS 1n +hI5 fOlDer";
$lang['cannotcreatepostinfolder'] = "j00 c@nNot rePly t0 P05+\$ In thi\$ PhoLdeR";
$lang['cannotattachfilesinfolder'] = "j00 c4NnOT pOs+ 4+t@CHM3nT5 1n +h1\$ fOldeR. reMove 4T+4CHm3nT5 t0 cOn+1NUe.";
$lang['postfrequencytoogreat'] = "j00 c4N 0NlY PoS+ once 3very %s SEcOnd\$. Pl34se try 4gAiN L@TEr.";
$lang['emailconfirmationrequiredbeforepost'] = "eMail conpH1rm@t1oN i\$ r3Qu1r3D 8eF0rE J00 C4n p05+. 1f j00 H4V3 Not r3c3iV3d 4 coNfIRm4t1on em41l Ple@\$3 click +eh buT+0n 83l0W 4nd 4 nEw 0N3 wiLl 8e 5ENT +o Y0u. 1PH YoUr emA1L 4dDres\$ n3eD5 ch4N91N9 pl3a53 d0 so bEfORE r3Qu3s+inG A nEw C0nfIrm4tI0N eM@1l. j00 m4Y ch4N93 Y0ur Em41l 4ddReS\$ 8Y CLiCk My C0N+rols @8oV3 @ND tH3N u\$3R DeT@1lS";
$lang['emailconfirmationfailedtosend'] = "cONph1Rm4t1On EM@1l fa1lEd t0 s3Nd. PL34Se c0n+@cT +h3 PhoRum oWnEr +O R3c+iFy +hiS.";
$lang['emailconfirmationsent'] = "confirm4+IOn Em41L H4s 8Een reS3n+.";
$lang['resendconfirmation'] = "r35ENd ConPH1rm4T10N";
$lang['userapprovalrequiredbeforeaccess'] = "yOUr u\$Er 4Cc0Un+ n33Ds +0 Be @pPr0v3d bY 4 FoRuM 4dM1n BefOre j00 C@n @cCe\$\$ the reQu35t3d Ph0rUm.";
$lang['reviewthread'] = "reViEW +Hr34D";
$lang['reviewthreadinnewwindow'] = "r3Vi3w 3N+iR3 tHre4D in neW wIndow";

// Message display (messages.php & messages.inc.php) --------------------------------------

$lang['inreplyto'] = "in Reply +0";
$lang['showmessages'] = "sHOw meS54g35";
$lang['ratemyinterest'] = "r4+e my in+erE\$+";
$lang['adjtextsize'] = "aDJu5+ t3xt 5IzE";
$lang['smaller'] = "sM@lLer";
$lang['larger'] = "l4R93r";
$lang['faq'] = "f@Q";
$lang['docs'] = "d0cs";
$lang['support'] = "supp0R+";
$lang['donateexcmark'] = "d0N4T3!";
$lang['fontsizechanged'] = "f0N+ sIz3 Ch@n93d. %s";
$lang['framesmustbereloaded'] = "fR4mEs mu\$+ 8e R3l0@Ded m4nu4LLy +0 Se3 ch@n93s.";
$lang['threadcouldnotbefound'] = "tHE rEqu3St3d tHRE4d cOuLd N0T b3 PH0Und or 4cc3\$5 w@5 d3Ni3d.";
$lang['mustselectpolloption'] = "j00 Mu\$t \$eL3Ct 4n 0P+iOn +0 v0tE pHOR!";
$lang['mustvoteforallgroups'] = "j00 muS+ VOTe 1n ev3ry 9RoUP.";
$lang['keepreading'] = "kE3P r34d1n9";
$lang['backtothreadlist'] = "b@cK +0 +Hr34d L1s+";
$lang['postdoesnotexist'] = "th4T pos+ dO35 no+ 3X1ST 1N TH15 tHR34d!";
$lang['clicktochangevote'] = "cl1cK +0 ChAng3 v0Te";
$lang['youvotedforoption'] = "j00 v0+3d for 0PtiON";
$lang['youvotedforoptions'] = "j00 V0+3D Ph0R OP+Ions";
$lang['clicktovote'] = "cL1CK To v0T3";
$lang['youhavenotvoted'] = "j00 hav3 N0T V0+Ed";
$lang['viewresults'] = "vI3W rEsults";
$lang['msgtruncated'] = "mesS4Ge trUnC4T3d";
$lang['viewfullmsg'] = "vi3w pHUlL mES\$4gE";
$lang['ignoredmsg'] = "i9NOred m3\$54gE";
$lang['wormeduser'] = "w0RmeD u\$eR";
$lang['ignoredsig'] = "iGn0rEd s19N4+UrE";
$lang['messagewasdeleted'] = "m3S\$4G3 %s.%s w4s d3L3TED";
$lang['stopignoringthisuser'] = "sT0p 1Gn0rIn9 Thi\$ u5Er";
$lang['renamethread'] = "r3n@Me tHr34d";
$lang['movethread'] = "moV3 +hRe@D";
$lang['torenamethisthreadyoumusteditthepoll'] = "to rEn@M3 +H1s +Hr3@D J00 mu\$t eD1+ The p0LL.";
$lang['closeforposting'] = "clOS3 PhoR Po\$T1NG";
$lang['until'] = "uNTiL 00:00 UtC";
$lang['approvalrequired'] = "appRoVaL R3qU1rEd";
$lang['messageawaitingapprovalbymoderator'] = "me\$\$@Ge %s.%s 1\$ 4w@1T1Ng @pPR0v@l BY 4 moder4t0R";
$lang['postapprovedsuccessfully'] = "p05+ @ppR0VeD sUCC3s5FulLy";
$lang['postapprovalfailed'] = "pO\$+ 4ppRov4l ph@1led.";
$lang['postdoesnotrequireapproval'] = "p05t Do3\$ n0t r3Qu1RE @ppR0V4L";
$lang['approvepost'] = "aPPRov3 p0s+";
$lang['approvedbyuser'] = "aPPrOV3D: %s 8Y %s";
$lang['makesticky'] = "m4k3 St1Cky";
$lang['messagecountdisplay'] = "%s 0F %s";
$lang['linktothread'] = "p3Rm4Nen+ l1nK tO +h1S thr34D";
$lang['linktopost'] = "l1Nk TO P05t";
$lang['linktothispost'] = "lInK +0 +hIs p0s+";
$lang['imageresized'] = "tH1S Ima93 H@5 833n rESIz3D (0RI9in4l 5iZ3 %1\$sX%2\$\$). +0 vi3w th3 fUlL-5iZe 1m49e cLiCk Her3.";
$lang['messagedeletedbyuser'] = "mE\$S4ge %s.%s D3le+eD %s 8y %s";
$lang['messagedeleted'] = "m3S549E %s.%s waS d3LeT3D";
$lang['viewinframeset'] = "v1eW 1n Fr4mESE+";
$lang['pressctrlentertoquicklysubmityourpost'] = "prESS cTrL+ent3R TO qUicKlY \$ubM1T Your p0s+";

// Moderators list (mods_list.php) -------------------------------------

$lang['cantdisplaymods'] = "c@nN0t D15Pl4Y pH0ldEr moD3r@T0R5";
$lang['moderatorlist'] = "m0Der@+0R l1\$+:";
$lang['modsforfolder'] = "m0DeR4T0r\$ fOR fOlder";
$lang['nomodsfound'] = "no m0d3R@+0r\$ FouNd";
$lang['forumleaders'] = "f0rum l34d3R\$:";
$lang['foldermods'] = "foLder m0deR4+0Rs:";

// Navigation strip (nav.php) ------------------------------------------

$lang['start'] = "sTAr+";
$lang['messages'] = "m35\$4G3\$";
$lang['pminbox'] = "iNbOx";
$lang['startwiththreadlist'] = "st@r+ p@9E Wi+H tHrE4D lI\$+";
$lang['pmsentitems'] = "sEN+ 1+em5";
$lang['pmoutbox'] = "oU+80X";
$lang['pmsaveditems'] = "saV3D It3M\$";
$lang['pmdrafts'] = "dR@Ph+s";
$lang['links'] = "l1Nk5";
$lang['admin'] = "aDMin";
$lang['login'] = "loGiN";
$lang['logout'] = "lOGouT";

// PM System (pm.php, pm_write.php, pm.inc.php) ------------------------

$lang['privatemessages'] = "pRIv4t3 m3S\$49e5";
$lang['recipienttiptext'] = "sEP4r@t3 R3c1p1ent5 bY \$Emi-cOlOn or COmm4";
$lang['maximumtenrecipientspermessage'] = "tH3r3 1\$ @ l1MIt Of 10 reCipIenT5 p3R m3S\$4G3. pL3@SE 4MEnD yOuR R3Cip13n+ LI5+.";
$lang['mustspecifyrecipient'] = "j00 MU\$+ 5PeC1phY @+ lEaSt 0ne rec1P13n+.";
$lang['usernotfound'] = "u\$3R %s NOt pH0und";
$lang['sendnewpm'] = "seNd N3w Pm";
$lang['savemessage'] = "s4V3 M3\$\$4gE";
$lang['timesent'] = "tiMe sEnT";
$lang['errorcreatingpm'] = "eRror CR34+In9 PM! Pl34sE TRy 494iN IN 4 f3w mINU+e\$";
$lang['writepm'] = "wRI+3 Me\$\$493";
$lang['editpm'] = "eDI+ m3s\$4ge";
$lang['cannoteditpm'] = "c4nn0t ed1T +H1\$ Pm. 1+ H4s 4LrE4Dy Be3n vI3w3d by +hE R3cIpiEn+ oR +H3 m3S\$493 dO3S no+ eX1\$+ oR it is 1N@cc3S\$1bLE 8y j00";
$lang['cannotviewpm'] = "c4nn0+ V13w pM. Me\$\$49e D03S No+ 3xIS+ Or it i\$ 1n@Cc3\$\$I8LE By j00";
$lang['pmmessagenumber'] = "m35\$49E %s";

$lang['youhavexnewpm'] = "j00 HavE %d NEw MeS5a9e\$. W0ULD J00 Lik3 TO g0 to yOur 1N80X nOw?";
$lang['youhave1newpm'] = "j00 h@v3 1 neW Me5\$49e. woUlD j00 l1K3 +0 g0 +o Y0ur 1nb0x Now?";
$lang['youhave1newpmand1waiting'] = "j00 H4Ve 1 NeW ME\$5@93.\n\nY0U 4l\$0 H4ve 1 m3S54Ge Aw@1T1Ng D3liV3Ry. To RecEiv3 tH1S Mes5493 PLe4s3 CleAr S0m3 Sp4c3 1n YOur iNb0X.\n\nWOuLD J00 lIk3 +0 go to y0uR iN8oX now?";
$lang['youhave1pmwaiting'] = "j00 h@Ve 1 MeSs4G3 4w@1t1n9 deL1V3ry. t0 rEc3IV3 Thi\$ m3S\$49e Pl34\$e cLe4r \$0m3 sP4c3 in y0uR iN8oX.\n\nw0ULD J00 L1k3 +0 Go T0 yOUR 1n80X nOW?";
$lang['youhavexnewpmand1waiting'] = "j00 h4Ve %d n3W m3S\$49ES.\n\nY0U 4LsO H4V3 1 M3\$\$4G3 @w4iTinG d3l1V3ry. +O R3ceIv3 thI\$ M3Ss493 plE4sE cLe@R \$Om3 sP4C3 IN YoUr inBox.\n\nW0ULd j00 L1K3 +o 90 +0 y0Ur 1Nb0x nOw?";
$lang['youhavexnewpmandxwaiting'] = "j00 h@v3 %d NeW mEs\$49e\$.\n\nYOu Al\$0 h4V3 %d M3S\$4G3s aW@1+1NG D3l1V3Ry. +0 rEC3iV3 +hESE MeS\$4G3 pLe@5e cle4r soMe sP4C3 1N Y0ur 1Nb0x.\n\nW0UlD j00 LiK3 T0 90 T0 y0UR 1nB0x Now?";
$lang['youhave1newpmandxwaiting'] = "j00 h4v3 1 nEw m3S\$49e.\n\nYou @l50 H@V3 %d me\$\$4GES aW4itIng deL1v3ry. t0 RECeiV3 thE\$3 M3s5Ag3S pLe4s3 cl34r Some 5p4ce in y0uR 1n80X.\n\nwOulD J00 likE +o g0 +0 YoUr 1n80x now?";
$lang['youhavexpmwaiting'] = "j00 h@V3 %d mes\$49e\$ @W4ItIN9 d3lIv3rY. +0 reC31VE th3Se m3\$\$@9eS Pl34\$E cLeaR \$0ME sp@Ce 1N y0Ur 1NB0X.\n\nWoUld j00 l1k3 +0 gO +O YOuR 1nB0x N0w?";

$lang['youdonothaveenoughfreespace'] = "j00 d0 n0t H4ve 3n0U9h Fr33 sP@C3 +0 5enD tHiS m3S\$49E.";
$lang['userhasoptedoutofpm'] = "%s h4S 0p+ed 0u+ 0Ph reC3iv1N9 pEr50n4l me\$\$4G3S";
$lang['pmfolderpruningisenabled'] = "pM pholdEr PRun1n9 1s 3naBl3d!";
$lang['pmpruneexplanation'] = "tHI5 PHOrUM u535 Pm phOLdeR PruNiN9. +eH MEs549E\$ J00 h4v3 \$Tor3d 1n y0ur iNB0x @Nd 5En+ 1+Em5\\nF0ld3rS 4R3 \$U8jeCT to 4UtoM4+ic deLET10N. 4Ny m35sagEs J00 w1sH +0 Ke3P \$Hould 83 M0VEd +0\\ny0ur \\'54v3d 1TeM\$\\' PHOldEr 50 +H4t THey 4r3 No+ d3L3+eD.";
$lang['yourpmfoldersare'] = "y0ur pm f0Ld3r\$ 4Re %s FuLl";
$lang['currentmessage'] = "curR3nT mE\$\$4g3";
$lang['unreadmessage'] = "uNR3ad M3S5493";
$lang['readmessage'] = "rE@D M3sS493";
$lang['pmshavebeendisabled'] = "p3r\$0naL Me5\$4G35 h4v3 833n D1S4BlEd By +he pH0RuM OwnEr.";
$lang['adduserstofriendslist'] = "adD UsErS t0 y0uR pHr1ends li\$t +0 H4V3 tHeM @PP34r In 4 DrOp Down On +he pm wr1t3 M3s\$@9e P493.";

$lang['messagesaved'] = "m3ss4Ge S4v3d";
$lang['messagewassuccessfullysavedtodraftsfolder'] = "mess4Ge w4S \$ucCe5\$FulLy S4v3D t0 'Dr4f+\$' Ph0lDeR";
$lang['couldnotsavemessage'] = "coULD NoT S4vE MeSS4g3. m@K3 \$Ur3 j00 h4Ve 3N0ugH @v4iL@8L3 frE3 5p4c3.";
$lang['pmtooltipxmessages'] = "%s MEs54G3\$";
$lang['pmtooltip1message'] = "1 MeSs49e";

$lang['allowusertosendpm'] = "alLOw U\$er t0 sEnD PeR50N@L Me\$\$493\$ +0 me";
$lang['blockuserfromsendingpm'] = "bLOck uSEr fr0m 5EnDIN9 PER\$0n4L MEs\$49Es t0 M3";
$lang['yourfoldernamefolderisempty'] = "y0ur %s PH0LDeR 1\$ EmpTy";
$lang['successfullydeletedselectedmessages'] = "sucC3\$5FulLy d3Let3d 53Lec+ed m3S\$4G3\$";
$lang['successfullyarchivedselectedmessages'] = "sUCc3s\$fUlLY 4rcHiv3D 53Lec+eD mE\$\$@g3S";
$lang['failedtodeleteselectedmessages'] = "f4ILEd t0 dEl3te SeL3C+3D mes\$@g3S";
$lang['failedtoarchiveselectedmessages'] = "f4iL3d +0 ArCH1v3 SeL3ctEd M3S\$4g3s";

// Preferences / Profile (user_*.php) ---------------------------------------------

$lang['mycontrols'] = "mY coNtr0Ls";
$lang['myforums'] = "mY pHorUm\$";
$lang['menu'] = "m3nu";
$lang['userexp_1'] = "usE Teh mENu on +h3 l3PHt to m4n@93 Y0ur SeT+In9s.";
$lang['userexp_2'] = "<b>u53R Det@1lS</b> 4Ll0w\$ j00 t0 cHan9E yOur n@Me, Em41l 4ddREs\$ @ND p4\$\$WOrd.";
$lang['userexp_3'] = "<b>us3r prOPh1l3</b> 4LL0WS J00 T0 3d1t yOuR u5Er Pr0ph1L3.";
$lang['userexp_4'] = "<b>cH4N93 P4\$\$woRd</b> 4llOws j00 To CH4n9E y0Ur paS5wOrD";
$lang['userexp_5'] = "<b>eM@IL &amp; Pr1V@cY</b> Le+5 j00 CH4nge how J00 CAn 8E Con+4ct3D On 4Nd opHpH +Eh PhOrUm.";
$lang['userexp_6'] = "<b>f0Rum 0p+ioNS</b> L3+s J00 Ch4n9E h0W +HE pHoRum l00ks 4nd woRKs.";
$lang['userexp_7'] = "<b>a++4chm3Nt5</b> @lL0W5 j00 t0 EdIT/d3L3+e y0uR 4++@chMeN+\$.";
$lang['userexp_8'] = "<b>s19N@+urE</b> Le+\$ j00 Ed1T YOur sIgN4tuRE.";
$lang['userexp_9'] = "<b>rel4+iOnsH1p5</b> L3tS j00 m4n4G3 Y0UR Rel@+10nSH1P wIth OthEr U\$eRs 0n tEH foRuM.";
$lang['userexp_9'] = "<b>w0Rd pHil+er</b> lEt5 j00 eD1+ y0Ur P3r\$0N4L wOrd ph1LTeR.";
$lang['userexp_10'] = "<b>tHR34D 5U8scRip+Ion\$</b> 4Ll0w5 J00 T0 M4n@93 y0Ur tHR34D \$uB\$CR1p+ion5.";
$lang['userdetails'] = "uSEr Det4ils";
$lang['userprofile'] = "uSer pRopH1l3";
$lang['emailandprivacy'] = "eM41l &amp; PR1v4cY";
$lang['editsignature'] = "eD1T Si9N@+uR3";
$lang['norelationshipssetup'] = "j00 H4Ve nO u\$eR r3LatIoNshIp\$ \$eT Up. @dd 4 n3w u\$ER 8Y Se4rcHin9 BeL0w.";
$lang['editwordfilter'] = "ed1T WorD phIl+Er";
$lang['userinformation'] = "uSEr 1nPhorm4TIon";
$lang['changepassword'] = "cH4Ng3 P4\$\$wORD";
$lang['currentpasswd'] = "cUrRen+ pAs\$wOrD";
$lang['newpasswd'] = "new p4ssword";
$lang['confirmpasswd'] = "c0NFirM p@5\$wOrd";
$lang['passwdsdonotmatch'] = "pa\$\$WorD\$ Do nOT m4+cH!";
$lang['nicknamerequired'] = "niCKn4mE 1\$ r3Qu1R3D!";
$lang['emailaddressrequired'] = "em41L addr3\$\$ I\$ R3quIr3d!";
$lang['logonnotpermitted'] = "lo90N n0+ p3rmItT3d. Ch0Ose @n0+h3r!";
$lang['nicknamenotpermitted'] = "n1CkN4m3 nO+ PerM1TTeD. Ch00sE @NoThEr!";
$lang['emailaddressnotpermitted'] = "eM@Il @Ddr3S\$ NOT pErm1t+3d. ch0OsE 4n0Th3r!";
$lang['emailaddressalreadyinuse'] = "eM41L 4ddres5 @lR34dY iN uSe. cHo05e aN0ThER!";
$lang['relationshipsupdated'] = "r3Lat1ONShip\$ UpD4+ED!";
$lang['relationshipupdatefailed'] = "reL@+i0n5H1p uPd4ted Ph@IleD!";
$lang['preferencesupdated'] = "pREpHerEnCe\$ wer3 \$uCCES5fUlLy upD@t3D.";
$lang['userdetails'] = "uSEr DetAILs";
$lang['memberno'] = "member nO.";
$lang['firstname'] = "f1r5+ n4m3";
$lang['lastname'] = "l4S+ n@me";
$lang['dateofbirth'] = "d@+3 oF Bir+h";
$lang['homepageURL'] = "h0M3p4gE url";
$lang['profilepicturedimensions'] = "pR0Ph1l3 pIcTuR3 (M@x 95x95Px)";
$lang['avatarpicturedimensions'] = "avA+4R P1C+Ure (m@x 15X15PX)";
$lang['invalidattachmentid'] = "inv@LiD @++4CHm3nt. cH3Ck +h4T i\$ h45n'+ 8eEN d3l3+ed.";
$lang['unsupportedimagetype'] = "un\$UpP0RtEd 1M4gE AtT@cHmenT. J00 C4n OnLY us3 Jp9, 9if @nD Png 1m4g3 @+T4chMeNT5 foR YoUr 4V@+4R @Nd PRofiL3 p1C+uR3.";
$lang['selectattachment'] = "s3l3C+ 4tT@Chm3n+";
$lang['pictureURL'] = "p1c+uR3 URL";
$lang['avatarURL'] = "aV4+@R uRl";
$lang['profilepictureconflict'] = "to u53 4N 4++4CHMent FoR yOur pROFil3 pic+uRe +h3 p1cTurE url fI3ld mUs+ 8e 8L4NK.";
$lang['avatarpictureconflict'] = "t0 U\$3 @N 4++4ChmEnt FoR yOuR 4v4t@R p1CturE tEh @v4t@r URL Fi3ld mU\$+ 8e 8L4nk.";
$lang['attachmenttoolargeforprofilepicture'] = "sel3Ct3d @++4ChmEnt Is +00 l4r93 For pr0ph1L3 P1C+Ure. m4X1mum diM3n\$IoNs 4R3 %s";
$lang['attachmenttoolargeforavatarpicture'] = "s3L3cT3d 4++4chMeNt 1\$ t0O l4R9e Ph0R @V4+@r P1CtUr3. m4X1mUm d1m3n5iOn\$ 4Re %s";
$lang['failedtoupdateuserdetails'] = "s0Me or 4Ll 0pH y0uR U5Er 4Cc0uNt D3+4iLs C0ulD Not 83 uPD@+ed. plE4SE TRy 4G41n l4t3R.";
$lang['failedtoupdateuserpreferences'] = "sOM3 Or 4LL oph YoUr u5Er PreFer3nCe5 c0ulD n0T b3 upd@+eD. Ple4\$e try 4g41n l4+3r.";
$lang['emailaddresschanged'] = "eM@1l 4Ddr3S\$ h@5 b3en ch@n9eD";
$lang['newconfirmationemailsuccess'] = "y0Ur eM41l adDrEs\$ H@5 833n Ch4n93d 4nd 4 n3W cOnPH1rM4tiOn EM@1l H@5 8EeN \$EnT. Pl34\$E Ch3cK 4nD RE4d +Eh 3M@il Ph0R fuR+HeR INs+ruct1On5.";
$lang['newconfirmationemailfailure'] = "j00 H@V3 ch4n9ED yOUr 3m@1l @DDR3\$5, bUt We wERE uNa8lE +0 5eND 4 C0nph1rMaTioN R3qU3\$+. pL34\$e c0n+@ct +H3 PhOrUm 0wNer ph0R 455iS+4nCe.";
$lang['forumoptions'] = "f0ruM 0p+10n5";
$lang['notifybyemail'] = "nOT1fy 8y 3m4iL oF p05t5 +0 mE";
$lang['notifyofnewpm'] = "n0T1pHy 8y popup of n3w pm meS\$4g3S +o Me";
$lang['notifyofnewpmemail'] = "n0T1fy 8y 3m@1l OF n3w pm me5\$49e\$ tO me";
$lang['daylightsaving'] = "aDjUs+ FoR D@YliGhT \$4vING";
$lang['autohighinterest'] = "aUtOm@t1C4lLy m4Rk tHrE@D5 I P05+ In 45 h1gh 1n+3R3\$+";
$lang['convertimagestolinks'] = "au+oM4t1C4lLy C0NVeRt EM8Edd3d iM@93\$ In PoS+S in+0 L1Nk5";
$lang['thumbnailsforimageattachments'] = "tHUM8N4Il5 phOr 1m493 4++4cHM3nT\$";
$lang['smallsized'] = "sm4ll s1Z3D";
$lang['mediumsized'] = "m3D1um S1zEd";
$lang['largesized'] = "l4rG3 \$1z3D";
$lang['globallyignoresigs'] = "gloB4lLY IgN0re u5Er 5IgNaTureS";
$lang['allowpersonalmessages'] = "aLL0w 0+hER US3R5 t0 \$eND M3 peRsOn@L M35\$49eS";
$lang['allowemails'] = "aLLoW 0tH3R USErS To 53nd mE 3M@Il\$ Vi@ mY pR0phIle";
$lang['timezonefromGMT'] = "t1me z0n3";
$lang['postsperpage'] = "pO5+5 per p49e";
$lang['fontsize'] = "f0Nt 5iZ3";
$lang['forumstyle'] = "fORuM 5+Yle";
$lang['forumemoticons'] = "f0ruM eM0T1C0nS";
$lang['startpage'] = "sT4rT p493";
$lang['signaturecontainshtmlcode'] = "s19N4tUr3 con+AiNs H+Ml CoD3";
$lang['savesignatureforuseonallforums'] = "sAVE 5I9N@tUr3 For u5e oN 4lL pH0RuM\$";
$lang['preferredlang'] = "pRefERRed l@NGu@93";
$lang['donotshowmyageordobtoothers'] = "do nOT 5HOW mY 4g3 Or Dat3 0ph Bir+h To 0+HerS";
$lang['showonlymyagetoothers'] = "show onLy My @g3 +0 0theRs";
$lang['showmyageanddobtoothers'] = "sh0W b0+H mY @9e @nd D4+e 0pH BiR+h t0 0Th3r\$";
$lang['showonlymydayandmonthofbirthytoothers'] = "sh0w 0nLy MY D4Y 4nd m0n+h Oph biR+h t0 0tH3r5";
$lang['listmeontheactiveusersdisplay'] = "liS+ m3 On +he 4C+IVe u5eRs Di5Pl@Y";
$lang['browseanonymously'] = "br0w5e phOrUm 4NoNyMOu5Ly";
$lang['allowfriendstoseemeasonline'] = "br0W5E aN0nyMoU5Ly, bUt 4llow PhrI3nd5 t0 53e m3 @5 oNLiNe";
$lang['revealspoileronmouseover'] = "rEVe4l spO1lerS 0N m0u\$E 0vER";
$lang['showspoilersinlightmode'] = "aLW4Y\$ ShOw SpoileR5 iN l1Ght Mode (Us3s l19hT3R fOnt coloUR)";
$lang['resizeimagesandreflowpage'] = "rE\$iZ3 1m@93\$ @nD r3Fl0w pa93 To PreV3nT Hor1z0N+4l ScrOlliNg.";
$lang['showforumstats'] = "sHow Ph0rUm S+@T5 aT b0++oM 0ph meS\$493 P@nE";
$lang['usewordfilter'] = "eN@8l3 WorD pH1l+Er.";
$lang['forceadminwordfilter'] = "f0Rc3 us3 0ph adm1N WoRd pH1l+Er 0N @Ll U\$eRs (1Nc. 9UeS+\$)";
$lang['timezone'] = "tIm3 zonE";
$lang['language'] = "l4NGu4G3";
$lang['emailsettings'] = "eMA1l 4Nd CoNt4cT 5ETt1Ng\$";
$lang['forumanonymity'] = "fORuM @nOnym1+y sEt+in9\$";
$lang['birthdayanddateofbirth'] = "b1rThD@y 4Nd D4+3 0f bIr+H d1SPl@y";
$lang['includeadminfilter'] = "iNClUdE @dM1n woRD f1lTer 1n My LI5+.";
$lang['setforallforums'] = "sE+ f0r 4LL FORuMs?";
$lang['containsinvalidchars'] = "%s c0N+41n5 1Nv4L1D ch4R4Ct3RS!";
$lang['homepageurlmustincludeschema'] = "hoM3P@g3 Url Mu5+ 1NClUde h++P:// 5Ch3m4.";
$lang['pictureurlmustincludeschema'] = "piCtUr3 Url Mu5+ incLUDe ht+p:// SchEm4.";
$lang['avatarurlmustincludeschema'] = "av@T4r uRL Mu5t 1NcLUdE hT+p:// \$ch3M@.";
$lang['postpage'] = "p0St p4gE";
$lang['nohtmltoolbar'] = "nO htMl +0olb@R";
$lang['displaysimpletoolbar'] = "d1sPl4y 5impL3 hTml +00Lb4r";
$lang['displaytinymcetoolbar'] = "dispL@Y Wy5iWyg htML +0Ol84r";
$lang['displayemoticonspanel'] = "d15PLaY eM0t1c0n\$ P4nEL";
$lang['displaysignature'] = "dI\$pL@Y SiGn4+UR3";
$lang['disableemoticonsinpostsbydefault'] = "d1S48le 3mOt1c0n5 in Mes\$49e\$ 8y deF@UL+";
$lang['automaticallyparseurlsbydefault'] = "aUT0m4tiC4llY p4RsE uRl5 1N mE\$\$49e\$ By D3f4uL+";
$lang['postinplaintextbydefault'] = "pOS+ 1N pL41N +eX+ By Def4Ult";
$lang['postinhtmlwithautolinebreaksbydefault'] = "p0\$T 1N H+ml WiTh Au+0-l1n3-8rE@k5 8y d3PH4UL+";
$lang['postinhtmlbydefault'] = "poS+ in H+Ml 8Y DepH@ulT";
$lang['postdefaultquick'] = "use quIcK REply by d3PH4Ul+. (Full reply 1N M3nU)";
$lang['privatemessageoptions'] = "prIV4+e m3S\$4Ge 0P+ions";
$lang['privatemessageexportoptions'] = "pr1V4te m3\$\$49E 3xPoR+ Op+10nS";
$lang['savepminsentitems'] = "s4V3 A c0py 0ph e@CH pM 1 Send 1N mY 53N+ iTEM5 PhoLdeR";
$lang['includepminreply'] = "inClude m3S5@G3 8oDy wH3n R3plYIn9 T0 pm";
$lang['autoprunemypmfoldersevery'] = "aU+0 pRUnE mY pm f0ld3r5 3v3Ry:";
$lang['friendsonly'] = "fr13ndS 0nLy?";
$lang['globalstyles'] = "gL0b4l \$+ylE\$";
$lang['forumstyles'] = "f0Rum StyL3\$";
$lang['youmustenteryourcurrentpasswd'] = "j00 MuSt 3Nt3r Y0ur CuRr3N+ p4\$Sword";
$lang['youmustenteranewpasswd'] = "j00 mUS+ 3n+eR 4 n3w p4\$\$w0RD";
$lang['youmustconfirmyournewpasswd'] = "j00 MU\$t C0nf1rM your neW p@55wOrD";
$lang['profileentriesmustnotincludehtml'] = "pR0Ph1L3 3ntrIeS MU\$T N0+ IncLUD3 htML";
$lang['failedtoupdateuserprofile'] = "f4Il3D t0 uPD4t3 UsEr pr0F1le";

// Polls (create_poll.php, poll_results.php) ---------------------------------------------

$lang['mustprovideanswergroups'] = "j00 MU5+ PR0vidE S0ME @n\$WEr Group\$";
$lang['mustprovidepolltype'] = "j00 mU\$t pR0Vid3 a p0LL +yp3";
$lang['mustprovidepollresultsdisplaytype'] = "j00 MU\$T pRoV1DE R3SuL+5 dI5PL4y +ype";
$lang['mustprovidepollvotetype'] = "j00 mu\$T PRov1de a POll VOt3 TYP3";
$lang['mustprovidepollguestvotetype'] = "j00 must \$p3CifY if 9uE5T\$ 5houlD 83 4lLowED +0 Vot3";
$lang['mustprovidepolloptiontype'] = "j00 MuS+ prOV1dE 4 PolL OP+ion +yP3";
$lang['mustprovidepollchangevotetype'] = "j00 mU\$t pROVide @ PolL cH4ngE V0+e TyPe";
$lang['pollquestioncontainsinvalidhtml'] = "on3 oR m0Re Oph YOuR P0Ll qu3\$+iOn\$ cON+41n\$ Inv4L1d htmL.";
$lang['pleaseselectfolder'] = "pLe@5e 5eL3Ct 4 Ph0ld3R";
$lang['mustspecifyvalues1and2'] = "j00 MU5+ \$PEc1Phy v@lu3S fOr 4N5W3Rs 1 4nd 2";
$lang['tablepollmusthave2groups'] = "t@bUl4r f0rM4t p0lLs muS+ H@V3 pR3C1sElY TW0 VoT1N9 9R0upS";
$lang['nomultivotetabulars'] = "t48Ul4r phOrm4T pOll5 c4nnOt 83 mUltI-vOt3";
$lang['nomultivotepublic'] = "pUbLic b4ll0+S C4nNot 8E MulT1-v0+e";
$lang['abletochangevote'] = "j00 w1lL bE 48L3 +0 Ch@Nge Y0Ur V0+e.";
$lang['abletovotemultiple'] = "j00 w1ll 8E @8l3 T0 v0+e MulT1pl3 +imE\$.";
$lang['notabletochangevote'] = "j00 WiLl N0t BE 48l3 +0 CH@Nge yOur vO+e.";
$lang['pollvotesrandom'] = "nOT3: poLl vo+e\$ ar3 r4nD0mly 93n3R@tED f0R pR3V13W 0nLy.";
$lang['pollquestion'] = "pOLl Qu35+iOn";
$lang['possibleanswers'] = "possI8LE @N\$wER\$";
$lang['enterpollquestionexp'] = "eNT3R T3h 4NswEr\$ f0R Y0Ur poll qUe\$+I0N.. if y0uR P0LL 1s 4 &quot;y3s/nO&quot; qUe\$+ion, s1mpLy 3Nt3R &quot;Y3s&quot; phOr @n5wEr 1 @Nd &quot;nO&quot; FOr 4n5wEr 2.";
$lang['numberanswers'] = "nO. @n5wErs";
$lang['answerscontainHTML'] = "aN\$Wers c0N+4iN h+ml (n0t inCluDIN9 S19N@+Ur3)";
$lang['optionsdisplay'] = "an5WerS d15Pl4y +yp3";
$lang['optionsdisplayexp'] = "how ShOuLD th3 @n5W3rs 8E pREseNtED?";
$lang['dropdown'] = "a5 DRoP-dOwN lIs+(5)";
$lang['radios'] = "aS 4 sEr13s oph r4d1O bUTt0N\$";
$lang['votechanging'] = "v0T3 Ch@N91n9";
$lang['votechangingexp'] = "c4n @ Per5On CH@Ng3 H15 Or H3r voTe?";
$lang['guestvoting'] = "gu3S+ Vo+In9";
$lang['guestvotingexp'] = "caN 9U3\$+5 V0tE 1n th1S pOlL?";
$lang['allowmultiplevotes'] = "aLL0w multiplE Vot3\$";
$lang['pollresults'] = "poLL re5UlT5";
$lang['pollresultsexp'] = "hOW w0Uld J00 Lik3 t0 DIspL4Y +hE rE\$uL+\$ OpH yOur poLl?";
$lang['pollvotetype'] = "pOlL vO+iN9 tYP3";
$lang['pollvotesexp'] = "h0w SH0uLd +eH p0ll b3 CoNDucTED?";
$lang['pollvoteanon'] = "an0nYMOu5ly";
$lang['pollvotepub'] = "pU8l1c b4lL0T";
$lang['horizgraph'] = "h0RIz0n+4L gR4Ph";
$lang['vertgraph'] = "v3rtIc4l 9R4ph";
$lang['tablegraph'] = "tA8UlaR fOrm4+";
$lang['polltypewarning'] = "<b>warn1Ng</b>: +His i5 4 pu8l1c B4LloT. YOuR n4m3 w1lL 8e visi8l3 NEX+ +o +eH 0p+IoN j00 V0tE pH0r.";
$lang['expiration'] = "eXP1r4T1On";
$lang['showresultswhileopen'] = "d0 j00 w@n+ t0 \$H0W r3SuL+\$ wH1Le T3h pOLL 1S 0PEN?";
$lang['whenlikepollclose'] = "wH3n w0uLd J00 L1kE Y0UR pOlL t0 4ut0M4+ic4Lly clO53?";
$lang['oneday'] = "oNE d@Y";
$lang['threedays'] = "tHRee daY5";
$lang['sevendays'] = "s3V3n d4y5";
$lang['thirtydays'] = "tH1R+Y d4y5";
$lang['never'] = "n3veR";
$lang['polladditionalmessage'] = "aDDi+IoN@l m3S\$4Ge (oPTI0n@l)";
$lang['polladditionalmessageexp'] = "dO j00 wanT +0 inCluDe @N 4DDiT10n@l P0St @ph+er +eH pOLL?";
$lang['mustspecifypolltoview'] = "j00 Mu\$+ \$P3c1Fy 4 p0ll +o V13w.";
$lang['pollconfirmclose'] = "aR3 J00 \$UrE j00 w4n+ +0 Clo5E THE fOlLow1N9 P0Ll?";
$lang['endpoll'] = "end PoLl";
$lang['nobodyvotedclosedpoll'] = "nOb0dY v0t3D";
$lang['votedisplayopenpoll'] = "%s 4Nd %s HavE v0TeD.";
$lang['votedisplayclosedpoll'] = "%s @Nd %s VoTEd.";
$lang['nousersvoted'] = "n0 uS3r5";
$lang['oneuservoted'] = "1 U\$eR";
$lang['xusersvoted'] = "%s uS3r5";
$lang['noguestsvoted'] = "no GuE\$T5";
$lang['oneguestvoted'] = "1 9U3\$T";
$lang['xguestsvoted'] = "%s Gue\$+5";
$lang['pollhasended'] = "poLL h4\$ eNd3d";
$lang['youvotedforpolloptionsondate'] = "j00 v0t3D fOr %s 0N %s";
$lang['thisisapoll'] = "tHI\$ I\$ @ poLl. clIck +O vI3W Re\$Ul+\$.";
$lang['editpoll'] = "edI+ p0Ll";
$lang['results'] = "reSuLtS";
$lang['resultdetails'] = "r3\$uL+ D3+@1lS";
$lang['changevote'] = "ch4ng3 V0t3";
$lang['pollshavebeendisabled'] = "poLl\$ H@v3 8eeN DiS48l3d By +h3 f0ruM 0wNer.";
$lang['answertext'] = "anSwEr +Ext";
$lang['answergroup'] = "aNSw3R gRoUP";
$lang['previewvotingform'] = "prEV1ew v0+1n9 phORM";
$lang['viewbypolloption'] = "v13W 8y P0Ll 0p+10n";
$lang['viewbyuser'] = "v1Ew 8Y User";

// Profiles (profile.php) ----------------------------------------------

$lang['editprofile'] = "eD1t pr0PH1lE";
$lang['profileupdated'] = "proFilE upd4+3d.";
$lang['profilesnotsetup'] = "tEH FOruM owN3r H4s n0+ set up pr0Fil3S.";
$lang['ignoreduser'] = "i9NOR3d UsEr";
$lang['lastvisit'] = "l45+ v1SiT";
$lang['userslocaltime'] = "uSER'5 L0c4L +IMe";
$lang['userstatus'] = "st4TU5";
$lang['useractive'] = "oNLiN3";
$lang['userinactive'] = "inaCt1vE / OffL1ne";
$lang['totaltimeinforum'] = "t0+4l +1me";
$lang['longesttimeinforum'] = "l0N93St seS5ioN";
$lang['sendemail'] = "seND 3m41L";
$lang['sendpm'] = "sENd Pm";
$lang['visithomepage'] = "v1siT h0MepAg3";
$lang['age'] = "a9e";
$lang['aged'] = "aGEd";
$lang['birthday'] = "bir+Hd@Y";
$lang['registered'] = "r39I\$+ered";
$lang['findpostsmadebyuser'] = "fInd p0S+s m@De 8Y %s";
$lang['findpostsmadebyme'] = "f1ND Po5+S M@d3 by me";
$lang['profilenotavailable'] = "prOPHiL3 nOt 4v41L4Bl3.";
$lang['userprofileempty'] = "tHi\$ usEr h@5 NOt Fill3d 1N tHeiR pR0pH1l3 0r it iS sEt +0 pR1v4tE.";

// Registration (register.php) -----------------------------------------

$lang['newuserregistrationsarenotpermitted'] = "s0rry, n3W uSEr R3Gi5+r@T1ons 4rE no+ 4ll0w3D r19HT Now. Ple45E cHecK B4Ck l@+eR.";
$lang['usernameinvalidchars'] = "uS3Rn4mE C4n 0Nly cOnt4In 4-z, 0-9, _ - CH4r@cters";
$lang['usernametooshort'] = "u53rn@mE mUs+ 8E @ miN1Mum oPh 2 ch4r@C+Er5 l0nG";
$lang['usernametoolong'] = "u5ErN4me muS+ 8E @ M@x1MUm 0ph 15 Ch4r@c+er5 L0N9";
$lang['usernamerequired'] = "a LO9On N@m3 I5 r3qU1reD";
$lang['passwdmustnotcontainHTML'] = "p4\$\$WOrd muS+ N0t coN+41N HtmL +4G\$";
$lang['passwordinvalidchars'] = "p@S\$worD CaN 0Nly cOn+4in @-z, 0-9, _ - Ch4r@c+eR5";
$lang['passwdtooshort'] = "p@s5woRd mU\$+ BE 4 m1n1mUm 0Ph 6 cH@r4Ct3Rs loN9";
$lang['passwdrequired'] = "a p4s5wOrD iS r3quir3d";
$lang['confirmationpasswdrequired'] = "a c0Nph1rM4+IOn P@5swOrd 1\$ ReQu1r3d";
$lang['nicknamerequired'] = "a n1Ckn4ME 1s reQU1R3D";
$lang['emailrequired'] = "aN 3M41l 4DDrEs\$ is rEqu1Red";
$lang['passwdsdonotmatch'] = "p@\$5WorD\$ d0 N0t M@tCh";
$lang['usernamesameaspasswd'] = "u5Ern4m3 @nd p4\$\$w0rD Mu5+ 8e dIFfer3N+";
$lang['usernameexists'] = "soRrY, a uSeR w1th +h4+ n4m3 @LRe@dY 3Xi5+\$";
$lang['successfullycreateduseraccount'] = "suCc3s5FuLly Cre4tEd uSeR 4cC0unt";
$lang['useraccountcreatedconfirmfailed'] = "yoUR user 4cC0UN+ h@s 8E3n CRE@+eD 8uT tEH rEqu1Red c0nph1rM@t1ON EM@1L w@5 N0T \$ENT. pLe@Se c0n+acT +He Ph0ruM 0WneR tO RecT1Phy +hIs. 1n This m3@Nt1mE pLe4Se cl1cK +3H c0NTiNue 8uT+oN +o l09In 1N.";
$lang['useraccountcreatedconfirmsuccess'] = "yOUr u\$ER 4ccOunt h@5 8e3n cr34+3d 8ut bEfOrE j00 C4N St4rt post1n9 J00 mu5+ C0nfIrM Y0ur eM@1l 4Ddre\$\$. Pl3@S3 CheCk yOur 3mAiL fOr @ lInK Th4T W1LL 4LL0W J00 +0 CoNpH1rm yOuR 4dDrEs\$.";
$lang['useraccountcreated'] = "your u\$Er AcCoUnT hAS 833n Cr3aTed \$UcCe\$SFULly! click +H3 c0nT1NuE 8u+ton 8elOW +0 L09In";
$lang['errorcreatinguserrecord'] = "eRRor cRe4+In9 U\$er r3c0Rd";
$lang['userregistration'] = "u\$er re91S+r@T10n";
$lang['registrationinformationrequired'] = "r3GIS+Ra+IOn InPH0rM4t1oN (R3qU1r3d)";
$lang['profileinformationoptional'] = "profIl3 1nFoRm4T10N (0P+iOn4L)";
$lang['preferencesoptional'] = "prepH3renCe\$ (oP+iOn4l)";
$lang['register'] = "rEgIS+Er";
$lang['rememberpasswd'] = "r3M3m8er p4S5w0rD";
$lang['birthdayrequired'] = "d@+3 0ph biRth 1\$ r3qU1REd oR i5 inv4l1D";
$lang['alwaysnotifymeofrepliestome'] = "nO+1fY 0N R3plY T0 mE";
$lang['notifyonnewprivatemessage'] = "not1Fy 0N n3w prIv4+e M3s\$4Ge";
$lang['popuponnewprivatemessage'] = "pOp uP 0n neW pRiv4T3 m3\$\$49e";
$lang['automatichighinterestonpost'] = "aU+OM@+1c HI9H 1nTerE\$+ oN pOSt";
$lang['confirmpassword'] = "c0Nf1rM p4Ssword";
$lang['invalidemailaddressformat'] = "inv@LId 3m@1l 4DdReS\$ f0rm@t";
$lang['moreoptionsavailable'] = "m0r3 pr0F1l3 @Nd PREf3R3nCe OpTi0N\$ 4Re 4V@1l48L3 oNcE j00 r39Is+Er";
$lang['textcaptchaconfirmation'] = "coNfIrm4+iOn";
$lang['textcaptchaexplain'] = "t0 Th3 r19hT is 4 T3Xt-c@p+Ch4 iM4g3. pL34Se tYp3 t3h c0de j00 c4N SE3 iN +h3 1m@93 INt0 +he inPUT FiELd beL0w i+.";
$lang['textcaptchaimgtip'] = "thIS i\$ @ C4PtCh4-PicTur3. 1+ 1S u5Ed +0 Pr3vEN+ 4ut0M@+1c r39i\$+r4+i0N";
$lang['textcaptchamissingkey'] = "a ConPh1rM@tI0N c0d3 iS r3qU1r3d.";
$lang['textcaptchaverificationfailed'] = "tExT-capTcH4 verIpH1C4tION CODe W4\$ inc0RR3Ct. pl34\$E R3-3nt3r 1+.";
$lang['forumrules'] = "foRuM rUl3\$";
$lang['forumrulesnotification'] = "in ordeR +0 prOcEed, J00 Mu5+ 49ReE W1+h tH3 PhOLl0Win9 RULe\$";
$lang['forumrulescheckbox'] = "i hAve rE@D, @ND @9Re3 +0 4BId3 By T3h F0RUm RulE\$.";
$lang['youmustagreetotheforumrules'] = "j00 MU\$+ 49Re3 To +h3 forum RulEs 8EfORE j00 c4N c0n+iNu3.";

// Recent visitors list  (visitor_log.php) -----------------------------

$lang['member'] = "mem8er";
$lang['searchforusernotinlist'] = "s3@rch pH0r 4 U5eR Not In l1\$+";
$lang['yoursearchdidnotreturnanymatches'] = "y0ur s34rcH D1D n0t R3tuRn 4Ny M4tChEs. tRy SiMpl1Fy1n9 yoUr se4RCh p4r@m3t3Rs @Nd Try 4GaIN.";
$lang['hiderowswithemptyornullvalues'] = "h1d3 R0Ws wiTh 3Mp+Y 0r NulL vAluE\$ 1n \$el3CT3d cOLUmns";
$lang['showregisteredusersonly'] = "sH0w re91\$+er3D u\$Er5 OnLY (HiD3 gu3\$+\$)";

// Relationships (user_rel.php) ----------------------------------------

$lang['relationships'] = "reL4t1On5hiP5";
$lang['userrelationship'] = "u5eR rEl4+IoN5H1P";
$lang['userrelationships'] = "u\$eR r3L@t10nShIp\$";
$lang['failedtoremoveselectedrelationships'] = "f41led t0 RemOvE SeL3CtEd Rel4+iONship";
$lang['friends'] = "fr1ENDS";
$lang['ignoredcompletely'] = "iGN0r3D c0mPl3+3LY";
$lang['relationship'] = "relaT10n\$hIp";
$lang['restorenickname'] = "r3s+0R3 uSer'\$ N1ckN4m3";
$lang['friend_exp'] = "us3R'S p0Sts m4RKEd w1+H @ &quot;fr13Nd&quot; 1C0n.";
$lang['normal_exp'] = "u\$Er'5 p0s+\$ @pPe@R @5 nOrM4L.";
$lang['ignore_exp'] = "u5eR'S P0s+S 4RE H1dDen.";
$lang['ignore_completely_exp'] = "thre4d\$ anD P05+\$ To 0R pHr0m U5er WiLl 4pPe4r dEl3+ed.";
$lang['display'] = "d1spl4Y";
$lang['displaysig_exp'] = "u\$Er'5 SI9n4tuRe 1S D15pl4Yed oN +H31R Pos+\$.";
$lang['hidesig_exp'] = "us3R'S Si9n@Tur3 1S h1dDen 0N +H31r P0s+S.";
$lang['cannotignoremod'] = "j00 c4nn0T i9nor3 ThiS u53R, @s +Hey 4r3 @ mOdeR@+Or.";
$lang['previewsignature'] = "prEV13W 5i9N4+ur3";

// Search (search.php) -------------------------------------------------

$lang['searchresults'] = "sE4Rch re\$UlTs";
$lang['usernamenotfound'] = "t3H u\$ErN@m3 j00 5P3C1fi3d 1n tH3 tO 0r phR0M fI3ld w@5 nO+ fOUnD.";
$lang['notexttosearchfor'] = "one Or 4LL of y0UR 5E@rCH K3yWord\$ W3R3 1nv4lId. 5e4rCh KeyW0Rd\$ mU5+ BE N0 sHoR+eR tH4N %d CH4r4C+3rS, N0 loN93R +h4n %d Ch4r@c+3r\$ @Nd mU\$T n0T aPp34r 1n +He %s";
$lang['keywordscontainingerrors'] = "kEyW0rd\$ C0Nt4In1ng 3rr0Rs: %s";
$lang['mysqlstopwordlist'] = "mYSQl StoPwOrD li5+";
$lang['foundzeromatches'] = "f0unD: 0 m@+cHe\$";
$lang['found'] = "f0und";
$lang['matches'] = "m4+ches";
$lang['prevpage'] = "prEv1Ou5 P4G3";
$lang['findmore'] = "f1nd moR3";
$lang['searchmessages'] = "s34RcH m3\$\$4G3\$";
$lang['searchdiscussions'] = "s3@rCh D15Cu5\$IoNs";
$lang['find'] = "fINd";
$lang['additionalcriteria'] = "adDit10n@L cRiTeR1@";
$lang['searchbyuser'] = "s3ArCh 8y Us3R (Op+Ion4L)";
$lang['folderbrackets_s'] = "folD3R(5)";
$lang['postedfrom'] = "p05+Ed phrom";
$lang['postedto'] = "poStEd +0";
$lang['today'] = "t0D4Y";
$lang['yesterday'] = "y3s+erd4y";
$lang['daybeforeyesterday'] = "d4Y bEf0r3 Y35+erD4y";
$lang['weekago'] = "%s W3eK 4go";
$lang['weeksago'] = "%s W3EkS @90";
$lang['monthago'] = "%s moNth 4g0";
$lang['monthsago'] = "%s M0NtH5 @90";
$lang['yearago'] = "%s y3Ar 4go";
$lang['beginningoftime'] = "begINn1n9 opH +Ime";
$lang['now'] = "nOW";
$lang['lastpostdate'] = "l@\$t pO5t D@t3";
$lang['numberofreplies'] = "num8Er oF rEplIeS";
$lang['foldername'] = "fOLDer N4m3";
$lang['authorname'] = "auThOr Name";
$lang['decendingorder'] = "nEw3\$+ fir5+";
$lang['ascendingorder'] = "olDeS+ PhiRs+";
$lang['keywords'] = "kEYw0Rd\$";
$lang['sortby'] = "s0RT bY";
$lang['sortdir'] = "sORt diR";
$lang['sortresults'] = "soR+ ResUl+\$";
$lang['groupbythread'] = "gR0Up 8y +Hr34D";
$lang['postsfromuser'] = "p0\$+5 pHrOm USEr";
$lang['threadsstartedbyuser'] = "tHRe4dS 5+aRt3D By uSer";
$lang['searchfrequencyerror'] = "j00 c4n oNly se4Rch 0NcE 3v3rY %s sEcOnd5. Pl345E TrY 4g4iN l4+er.";
$lang['searchsuccessfullycompleted'] = "sE@rCH 5ucC35sFuLLy COMPl3ted. %s";
$lang['clickheretoviewresults'] = "cLIcK h3r3 To v13w R3\$Ult\$.";

// Search Popup (search_popup.php) -------------------------------------

$lang['select'] = "sELect";
$lang['searchforthread'] = "s34RcH for +hr34D";
$lang['mustspecifytypeofsearch'] = "j00 muS+ 5PEC1fY +yPe of 5E4RCh +0 P3rfOrM";
$lang['unkownsearchtypespecified'] = "uNKn0wn \$E@rCh +yP3 sP3ciF13d";
$lang['mustentersomethingtosearchfor'] = "j00 MuSt 3N+eR s0mEtH1n9 +0 5E4RcH FoR";

// Start page (start_left.php) -----------------------------------------

$lang['recentthreads'] = "reCent +HR34D\$";
$lang['startreading'] = "s+4rT R34DiNG";
$lang['threadoptions'] = "thr34D 0pt1ON5";
$lang['editthreadoptions'] = "ed1T +hr34d 0P+iOn5";
$lang['morevisitors'] = "moRE V1SIt0R\$";
$lang['forthcomingbirthdays'] = "f0RthCom1N9 B1rtHd4y5";

// Start page (start_main.php) -----------------------------------------

$lang['editstartpage_help'] = "j00 can 3diT +h1\$ p4g3 pHr0m +eH 4dM1n iN+3rPh4c3";

// Thread navigation (thread_list.php) ---------------------------------

$lang['newdiscussion'] = "nEW D1sCU\$\$iOn";
$lang['createpoll'] = "cr34T3 p0ll";
$lang['search'] = "sE@rCh";
$lang['searchagain'] = "sE@rcH 4g4iN";
$lang['alldiscussions'] = "aLL d1\$CU5510n\$";
$lang['unreaddiscussions'] = "uNR34D Di5cUsS1oNS";
$lang['unreadtome'] = "unR34D &quot;+0: m3&quot;";
$lang['todaysdiscussions'] = "t0D4y'\$ DI5Cuss1oN\$";
$lang['2daysback'] = "2 D4y\$ 84Ck";
$lang['7daysback'] = "7 d4Ys 84cK";
$lang['highinterest'] = "h1Gh 1n+erEs+";
$lang['unreadhighinterest'] = "uNRe@d hiGH 1n+3R3\$+";
$lang['iverecentlyseen'] = "i'V3 rEc3n+ly \$eeN";
$lang['iveignored'] = "i'V3 1gN0R3d";
$lang['byignoredusers'] = "bY I9n0R3D U\$Er5";
$lang['ivesubscribedto'] = "i'v3 SuB\$Cr18eD +0";
$lang['startedbyfriend'] = "s+4rT3D 8y fR13nD";
$lang['unreadstartedbyfriend'] = "unRe4d 5+D 8y PhRi3nD";
$lang['startedbyme'] = "stArTed bY mE";
$lang['unreadtoday'] = "unR34D +od@y";
$lang['deletedthreads'] = "dELEt3d Thr34dS";
$lang['goexcmark'] = "g0!";
$lang['folderinterest'] = "foLd3R 1N+3R3\$+";
$lang['postnew'] = "pO\$T N3w";
$lang['currentthread'] = "cURrEnt thRE4d";
$lang['highinterest'] = "h19H 1nT3RE\$+";
$lang['markasread'] = "m4Rk 4\$ r34d";
$lang['next50discussions'] = "nex+ 50 DiSCU5\$i0nS";
$lang['visiblediscussions'] = "v1\$18l3 d1scu5SioN5";
$lang['selectedfolder'] = "sEL3c+ed f0lD3r";
$lang['navigate'] = "n@vi94tE";
$lang['couldnotretrievefolderinformation'] = "therE 4Re No pH0Ld3r\$ @V@1l4bL3.";
$lang['nomessagesinthiscategory'] = "n0 m35\$@g3s in +h1\$ C4+e90Ry. Ple4S3 \$3l3C+ 4N0THeR, Or %s PHoR 4ll ThRe@D5";
$lang['clickhere'] = "cL1Ck h3R3";
$lang['prev50threads'] = "pR3V1OuS 50 +hr3@D5";
$lang['next50threads'] = "n3xt 50 tHre4Ds";
$lang['nextxthreads'] = "n3X+ %s tHrE@d5";
$lang['threadstartedbytooltip'] = "tHRe4d #%s \$+@r+eD BY %s. v13w3D %s";
$lang['threadviewedonetime'] = "1 TImE";
$lang['threadviewedtimes'] = "%d +iM3S";
$lang['unreadthread'] = "uNrE@D +HR34D";
$lang['readthread'] = "r3@d +Hr34D";
$lang['unreadmessages'] = "uNRe4d Me\$\$@9Es";
$lang['subscribed'] = "sUBscr18Ed";
$lang['ignorethisfolder'] = "iGN0R3 +h15 pHolDer";
$lang['stopignoringthisfolder'] = "s+OP iGn0riNg +hI5 pholDer";
$lang['stickythreads'] = "st1Cky +hR34dS";
$lang['mostunreadposts'] = "m0s+ uNRE4d p0St5";
$lang['onenew'] = "%d NeW";
$lang['manynew'] = "%d New";
$lang['onenewoflength'] = "%d N3w 0ph %d";
$lang['manynewoflength'] = "%d NEw opH %d";
$lang['ignorefolderconfirm'] = "aRE J00 SuR3 j00 w@N+ To 19nOrE ThiS fOLdEr?";
$lang['unignorefolderconfirm'] = "aR3 j00 sur3 J00 W4Nt +O s+op i9nOr1N9 +Hi5 PhoLdeR?";
$lang['confirmmarkasread'] = "arE j00 5Ur3 J00 w4N+ t0 m4rK +he 5EL3ctEd +hR34Ds 4\$ r3@d?";
$lang['successfullymarkreadselectedthreads'] = "sUCc3S5fuLlY m4rk3d \$eL3Ct3d +hR34D\$ 4\$ R34d";
$lang['failedtomarkselectedthreadsasread'] = "f41l3D +O m@rk 5eL3c+3d +hr3@Ds 4\$ r34D";
$lang['gotofirstpostinthread'] = "g0 +0 FirS+ p0S+ In Thre4d";
$lang['gotolastpostinthread'] = "go To L4s+ p0St In +hr34D";
$lang['viewmessagesinthisfolderonly'] = "vieW m3\$\$49e\$ 1N thIs F0ld3r 0nlY";
$lang['shownext50threads'] = "sh0W nExt 50 tHr3aDs";
$lang['showprev50threads'] = "show pr3V1oU5 50 +HRE4Ds";
$lang['createnewdiscussioninthisfolder'] = "cRe4Te New d1\$cU\$51oN iN +H1\$ FolDer";
$lang['nomessages'] = "nO MeS\$4gE\$";

// HTML toolbar (htmltools.inc.php) ------------------------------------
$lang['bold'] = "bOLd";
$lang['italic'] = "i+@L1c";
$lang['underline'] = "unD3rL1N3";
$lang['strikethrough'] = "sTR1ketHrOu9H";
$lang['superscript'] = "sUP3r5Cr1pt";
$lang['subscript'] = "su8SCR1PT";
$lang['leftalign'] = "l3pHt-4li9N";
$lang['center'] = "cEntER";
$lang['rightalign'] = "riGh+-4li9n";
$lang['numberedlist'] = "nUMBEr3d LI\$+";
$lang['list'] = "l15+";
$lang['indenttext'] = "iND3nT +3X+";
$lang['code'] = "c0d3";
$lang['quote'] = "qUot3";
$lang['unquote'] = "uNQu0T3";
$lang['spoiler'] = "sPOiL3R";
$lang['horizontalrule'] = "hoRiZ0n+4l rUle";
$lang['image'] = "im493";
$lang['hyperlink'] = "hyP3Rl1NK";
$lang['noemoticons'] = "dis48le 3mOtIcONS";
$lang['fontface'] = "f0n+ faC3";
$lang['size'] = "siZe";
$lang['colour'] = "c0l0Ur";
$lang['red'] = "reD";
$lang['orange'] = "oRaNG3";
$lang['yellow'] = "y3lLow";
$lang['green'] = "gRe3n";
$lang['blue'] = "blu3";
$lang['indigo'] = "ind1Go";
$lang['violet'] = "vi0Le+";
$lang['white'] = "whIt3";
$lang['black'] = "bl@cK";
$lang['grey'] = "gREy";
$lang['pink'] = "p1nK";
$lang['lightgreen'] = "lIgHt 9r33n";
$lang['lightblue'] = "lighT bLu3";

// Forum Stats (messages.inc.php - messages_forum_stats()) -------------

$lang['forumstats'] = "foRuM 5+4+5";
$lang['usersactiveinthepasttimeperiod'] = "%s 4cT1v3 1n +3h p4\$+ %s. %s";

$lang['numactiveguests'] = "<b>%s</b> 9u3\$+5";
$lang['oneactiveguest'] = "<b>1</b> 9U35+";
$lang['numactivemembers'] = "<b>%s</b> M3MbEr5";
$lang['oneactivemember'] = "<b>1</b> M3mBer";
$lang['numactiveanonymousmembers'] = "<b>%s</b> @N0NyMou\$ mEmB3rs";
$lang['oneactiveanonymousmember'] = "<b>1</b> @N0nYMOUs M3m83r";

$lang['numthreadscreated'] = "<b>%s</b> thr3Ad5";
$lang['onethreadcreated'] = "<b>1</b> THrE4D";
$lang['numpostscreated'] = "<b>%s</b> p05+\$";
$lang['onepostcreated'] = "<b>1</b> PO\$+";

$lang['younormal'] = "j00";
$lang['youinvisible'] = "j00 (1nvIs1bl3)";
$lang['viewcompletelist'] = "v13W C0MpL3T3 lIs+";
$lang['ourmembershavemadeatotalofnumthreadsandnumposts'] = "oUr mEM8eRs h4v3 m@DE @ +0+4l 0ph %s 4nd %s.";
$lang['longestthreadisthreadnamewithnumposts'] = "l0Nge5+ thReaD 1s <b>%s</b> W1+h %s.";
$lang['therehavebeenxpostsmadeinthelastsixtyminutes'] = "th3R3 h@ve 8een <b>%s</b> p05+5 Mad3 1N +eh l4s+ 60 mInuTeS.";
$lang['therehasbeenonepostmadeinthelastsxityminutes'] = "tHEr3 has B3En <b>1</b> pO\$+ M4de 1n tH3 l4S+ 60 mInu+es.";
$lang['mostpostsevermadeinasinglesixtyminuteperiodwasnumposts'] = "mO5t pO5+s ev3r M@dE in 4 Sin9L3 60 M1nU+E P3R1Od is <b>%s</b> 0N %s.";
$lang['wehavenumregisteredmembersandthenewestmemberismembername'] = "wE h4VE <b>%s</b> R3G1\$+eR3d M3M83RS 4nd +h3 N3W3\$+ M3m8eR iS <b>%s</b>.";
$lang['wehavenumregisteredmember'] = "w3 H@ve %s r39iS+3Red mEmbER5.";
$lang['wehaveoneregisteredmember'] = "wE haV3 oNe R39ist3R3D Mem83r.";
$lang['mostuserseveronlinewasnumondate'] = "mOST u5er5 3vEr 0Nl1n3 w4\$ <b>%s</b> 0N %s.";
$lang['statsdisplaychanged'] = "sT@t5 DI5pL4y Ch4nG3d";

// Thread Options (thread_options.php) ---------------------------------

$lang['updatessavedsuccessfully'] = "upd@+ES S4v3d 5ucC35sFULly";
$lang['useroptions'] = "u\$3r oP+iOns";
$lang['markedasread'] = "m@Rk3D 4S R34D";
$lang['postsoutof'] = "p0ST\$ 0uT 0PH";
$lang['interest'] = "in+eRe\$+";
$lang['closedforposting'] = "cl0\$3d ph0r p0sTiN9";
$lang['locktitleandfolder'] = "l0Ck +itL3 4nD ph0ldEr";
$lang['deletepostsinthreadbyuser'] = "d3L3t3 P05tS iN +Hr34D BY u\$Er";
$lang['deletethread'] = "dELe+e tHr34D";
$lang['permenantlydelete'] = "p3Rm@n3ntLy DeLE+3";
$lang['movetodeleteditems'] = "moV3 tO dElE+eD +Hr3@D5";
$lang['undeletethread'] = "uNd3l3t3 +hR3@d";
$lang['markasunread'] = "mARk 4S unrEad";
$lang['makethreadsticky'] = "m4Ke +hR34d s+IcKy";
$lang['threareadstatusupdated'] = "thr34d Re4d st@tu\$ UPd@T3D \$Ucce\$\$FulLy";
$lang['interestupdated'] = "thrE4d 1NtER35+ \$+@Tu\$ Upd4T3d 5ucC3\$\$FUllY";
$lang['failedtoupdatethreadreadstatus'] = "f4ilED t0 Upd@+e +hRE4d reAd 5+4tu\$";
$lang['failedtoupdatethreadinterest'] = "f41l3d +O UPd@t3 tHr34d InT3reSt";
$lang['failedtorenamethread'] = "f@Il3d TO r3NamE thRe4d";
$lang['failedtomovethread'] = "f4Il3d to mOvE ThR34d t0 \$PeC1pH1ED fOLDeR";
$lang['failedtoupdatethreadstickystatus'] = "f4IlEd T0 upD4+e thRe@D \$+icKy \$+4tu\$";
$lang['failedtoupdatethreadclosedstatus'] = "fAil3d +O uPd4+E tHre4d cl0SEd s+4+us";
$lang['failedtoupdatethreadlockstatus'] = "f@1L3D t0 upd4+e tHr3@D L0Ck \$+4+uS";
$lang['failedtodeletepostsbyuser'] = "f41L3D To D3leT3 p0S+\$ 8y \$3LeCt3d u\$Er";
$lang['failedtodeletethread'] = "fail3D +0 DeLe+3 +hRe4d.";
$lang['failedtoundeletethread'] = "f@Il3D t0 uN-dEl3+e thRE4d";

// Dictionary (dictionary.php) -----------------------------------------

$lang['dictionary'] = "dICt1On4rY";
$lang['spellcheck'] = "sP3lL cH3ck";
$lang['notindictionary'] = "not 1n diCT10N4Ry";
$lang['changeto'] = "ch@n93 To";
$lang['restartspellcheck'] = "re\$+4rT";
$lang['cancelchanges'] = "c4nc3l ch@ng3\$";
$lang['initialisingdotdotdot'] = "iN1T14l1sin9...";
$lang['spellcheckcomplete'] = "speLl CheCk Is c0Mpl3+e. +o r35t@R+ 5p3lL cH3ck cliCk R3\$+aRt ButT0n b3lOw.";
$lang['spellcheck'] = "sPeLL cHecK";
$lang['noformobj'] = "n0 FoRM 0bjEc+ SpeCiPh13D Ph0R R3tUrN +Ext";
$lang['bodytext'] = "boDY +ext";
$lang['ignore'] = "ign0re";
$lang['ignoreall'] = "iGN0r3 4LL";
$lang['change'] = "ch4NG3";
$lang['changeall'] = "ch4ng3 4LL";
$lang['add'] = "aDD";
$lang['suggest'] = "suG9Es+";
$lang['nosuggestions'] = "(n0 sUg9e5+iON5)";
$lang['cancel'] = "c@Nc3l";
$lang['dictionarynotinstalled'] = "nO dIc+10N@ry H@\$ 833N in\$t4lL3D. PLe4se c0n+4ct +h3 foRum 0Wn3r +0 r3MEdY th1S.";

// Permissions keys ----------------------------------------------------

$lang['postreadingallowed'] = "po\$+ r34dIN9 @llOweD";
$lang['postcreationallowed'] = "pOS+ crE4t1ON 4Ll0w3d";
$lang['threadcreationallowed'] = "tHR34d CrE@+10n @LlOweD";
$lang['posteditingallowed'] = "p05+ 3DIt1N9 4lL0Wed";
$lang['postdeletionallowed'] = "p0S+ d3L3t1On 4LlOW3d";
$lang['attachmentsallowed'] = "aTT4ChMeNTS @lLow3d";
$lang['htmlpostingallowed'] = "h+ml pOs+INg 4lL0w3D";
$lang['signatureallowed'] = "si9N@+ur3 4LLow3D";
$lang['guestaccessallowed'] = "gU35+ @CceS\$ 4Ll0W3D";
$lang['postapprovalrequired'] = "p0\$+ 4PPR0v4L R3quIr3d";

// RSS feeds gubbins

$lang['rssfeed'] = "rsS f3ed";
$lang['every30mins'] = "ev3Ry 30 m1NU+es";
$lang['onceanhour'] = "onCe 4N HOur";
$lang['every6hours'] = "everY 6 hour\$";
$lang['every12hours'] = "ev3Ry 12 h0Urs";
$lang['onceaday'] = "onC3 @ d4Y";
$lang['onceaweek'] = "oNc3 @ We3k";
$lang['rssfeeds'] = "r5\$ fe3d\$";
$lang['feedname'] = "fE3D N4M3";
$lang['feedfoldername'] = "f33D ph0ldEr n4M3";
$lang['feedlocation'] = "fe3d l0c4+1on";
$lang['threadtitleprefix'] = "thR3@d Ti+lE PR3FiX";
$lang['feednameandlocation'] = "fEed n4m3 @nd l0c4+ion";
$lang['feedsettings'] = "f3ED sEt+1n9S";
$lang['updatefrequency'] = "upD@t3 pHR3quEncY";
$lang['rssclicktoreadarticle'] = "cLIcK h3R3 t0 re4d +hIs 4R+iCle";
$lang['addnewfeed'] = "aDD New f33D";
$lang['editfeed'] = "ediT Fe3d";
$lang['feeduseraccount'] = "f33D Us3r @cCOUn+";
$lang['noexistingfeeds'] = "n0 3X1St1n9 rS\$ f3ed5 phOund. tO @Dd 4 Ph3Ed ClicK tH3 '4Dd N3w' 8uT+0n 83low";
$lang['rssfeedhelp'] = "h3r3 j00 C@N setuP s0Me r\$5 fE3D\$ phOr @U+0M4+iC pROp@94T1on InT0 y0Ur phorUm. +eH 1+3M\$ Fr0m +eH Rs\$ Fe3Ds J00 4dd w1lL 8e cReaTED 4\$ ThR34D5 wH1Ch u\$Ers c@N R3PLy +0 @s 1Ph +hey weR3 N0rM4L PO\$+\$. +Eh r\$\$ Ph3ED MuSt 8e 4cCeS\$Ibl3 v1@ H+tp oR It w1lL N0T W0rK.";
$lang['mustspecifyrssfeedname'] = "mu5+ \$P3c1Fy RS\$ Fe3d n4m3";
$lang['mustspecifyrssfeeduseraccount'] = "mU\$T Sp3c1Fy rs\$ Fe3d U53r 4CcOuN+";
$lang['mustspecifyrssfeedfolder'] = "musT Sp3cIphy rSs f33d f0ldEr";
$lang['mustspecifyrssfeedurl'] = "mus+ sPEc1FY R5\$ F3eD uRl";
$lang['mustspecifyrssfeedupdatefrequency'] = "mUST 5p3cify r5\$ f3ed uPd@T3 pHreQu3nCy";
$lang['unknownrssuseraccount'] = "uNkNoWn RS\$ u\$3R 4cc0Un+";
$lang['rssfeedsupportshttpurlsonly'] = "r\$\$ feEd 5upP0rtS HT+P uRlS 0Nly. sEcURe ph33Ds (h+tP\$://) 4R3 n0+ supp0R+eD.";
$lang['rssfeedurlformatinvalid'] = "r\$s fe3D URL fOrMA+ 1s Inv4Lid. uRl mu5+ iNclud3 \$Ch3Me (e.9. ht+p://) 4nd 4 H0StN4m3 (e.9. Www.h0STn4m3.com).";
$lang['rssfeeduserauthentication'] = "r\$\$ Fe3d d03\$ No+ \$uppOrt ht+p U\$er 4u+h3N+iC@+10n";
$lang['successfullyremovedselectedfeeds'] = "sucCeS\$PhuLly reMoV3D \$3lEc+3D pHe3D\$";
$lang['successfullyaddedfeed'] = "sUCcES\$fUlLy 4dD3D nEw Ph33D";
$lang['successfullyeditedfeed'] = "sUCcEs\$FuLlY eDitEd Ph3eD";
$lang['failedtoremovefeeds'] = "f41l3d t0 ReMOVe SoM3 oR 4lL OpH +eH \$El3C+3D pH3eds";
$lang['failedtoaddnewrssfeed'] = "f@1l3d +0 4dD nEw r5S f3Ed";
$lang['failedtoupdaterssfeed'] = "f41l3d +0 UpDAtE r\$S Ph3eD";
$lang['rssstreamworkingcorrectly'] = "r55 StrE@m 4pP34rs tO B3 WoRkINg cOrREc+lY";
$lang['rssstreamnotworkingcorrectly'] = "r\$\$ \$+Re4m W4S EMp+y or CoUlD n0T bE pHOUnD";
$lang['invalidfeedidorfeednotfound'] = "inV4liD Fe3d 1D Or pHeEd NOT F0uND";

// PM Export Options

$lang['pmexportastype'] = "exp0R+ 4S typ3";
$lang['pmexporthtml'] = "h+mL";
$lang['pmexportxml'] = "xML";
$lang['pmexportplaintext'] = "pL4In TeX+";
$lang['pmexportmessagesas'] = "exPoRt ME\$S49e5 as";
$lang['pmexportonefileforallmessages'] = "oN3 fILe fOR 4Ll M3S\$4g3s";
$lang['pmexportonefilepermessage'] = "oNE fiLe Per M3\$5AGE";
$lang['pmexportattachments'] = "eXPoR+ 4tt@ChM3ntS";
$lang['pmexportincludestyle'] = "inCLuD3 f0rUm 5TyLe 5H3e+";
$lang['pmexportwordfilter'] = "aPpLY w0rd fiL+3r to m3\$5@9Es";

// Thread merge / split options

$lang['threadhasbeensplit'] = "tHR3@D H4s B3en sPl1t";
$lang['threadhasbeenmerged'] = "tHR34d H@5 8EEN m3rged";
$lang['mergesplitthread'] = "mer9E / spL1t +Hr34D";
$lang['mergewiththreadid'] = "meRgE w1Th +hR34d 1D:";
$lang['postsinthisthreadatstart'] = "p0S+\$ In +h1s tHR34d 4+ 5+@Rt";
$lang['postsinthisthreadatend'] = "poS+\$ 1N +hIS thrE4D A+ 3ND";
$lang['reorderpostsintodateorder'] = "rE-oRd3r P0S+\$ Into D@+3 0rDer";
$lang['splitthreadatpost'] = "sPL1t THr3@d 4t Po5t:";
$lang['selectedpostsandrepliesonly'] = "sEL3ct3d pos+ @nd rePli3S 0NLY";
$lang['selectedandallfollowingposts'] = "selECt3D 4nD 4ll f0lLow1N9 pOsT\$";

$lang['threadmovedhere'] = "h3R3";

$lang['thisthreadhasmoved'] = "<b>thre4DS m3rG3d:</b> +hIs +hR3@d h@5 moVED %s";
$lang['thisthreadwasmergedfrom'] = "<b>tHr3ads mErg3D:</b> +hI5 tHRe4D W@5 MEr93d fr0m %s";
$lang['somepostsinthisthreadhavebeenmoved'] = "<b>thr34d 5Pli+:</b> 50mE p05+\$ in +h1s thR3ad h@vE 8E3n mov3d %s";
$lang['somepostsinthisthreadweremovedfrom'] = "<b>thRe4d Spl1+:</b> S0mE p05+\$ IN +hi5 thRe4d weR3 MoV3d PhR0M %s";

$lang['thisposthasbeenmoved'] = "<b>thrE4D SpL1t:</b> +hi5 P0s+ H4S bE3n MoV3d %s";

$lang['invalidfunctionarguments'] = "inV4l1d pHuNct1ON 4rgUment\$";
$lang['couldnotretrieveforumdata'] = "c0ulD N0+ R3+r1Ev3 Ph0ruM d@+4";
$lang['cannotmergepolls'] = "on3 0R M0rE thRe4ds 1\$ @ P0ll. j00 c4NnOT mer93 P0LL5";
$lang['couldnotretrievethreaddatamerge'] = "coUlD N0T r3+r13V3 tHR34d d4t@ fr0m oN3 0r moRe Thre@d\$";
$lang['couldnotretrievethreaddatasplit'] = "c0ulD No+ rE+r13ve thR3@d d4t4 fR0M S0UrC3 +hRE4D";
$lang['couldnotretrievepostdatamerge'] = "could n0T R3+R13v3 p0\$+ D@+4 pHr0M 0ne OR MorE tHr34ds";
$lang['couldnotretrievepostdatasplit'] = "cOUlD N0t Re+r1eV3 p0S+ D@+4 Phr0m \$0UrC3 tHR34D";
$lang['failedtocreatenewthreadformerge'] = "f4IleD t0 cR34t3 NeW +Hre4D pH0r mErge";
$lang['failedtocreatenewthreadforsplit'] = "f4Il3D +0 cr34+E N3W +Hr34d foR 5pLit";

// Thread subscriptions

$lang['threadsubscriptions'] = "tHR34d su8sCr1pt10N5";
$lang['couldnotupdateinterestonthread'] = "could n0+ upD4+e 1N+eR3s+ oN tHre4D '%s'";
$lang['threadinterestsupdatedsuccessfully'] = "tHRe4d 1ntEr3\$+\$ upD@+3D \$UccE\$\$FUllY";
$lang['nothreadsubscriptions'] = "j00 Are n0+ su85Cri8eD +0 4NY +hRe4ds.";
$lang['resetselected'] = "r3sEt 53lected";
$lang['allthreadtypes'] = "aLl tHR34d tyP3s";
$lang['ignoredthreads'] = "i9N0r3d +HR34dS";
$lang['highinterestthreads'] = "h1gH 1ntEre\$+ thReaDs";
$lang['subscribedthreads'] = "sUB\$cr183d +HRe@D5";
$lang['currentinterest'] = "cURRen+ iNt3r35+";

// Browseable user profiles

$lang['youcanonlyaddthreecolumns'] = "j00 c@N 0NLY @dD 3 C0LumNs. TO 4Dd 4 N3w C0luMn Cl05E 4n 3XiSTIng One";
$lang['columnalreadyadded'] = "j00 h@V3 4lr3@Dy 4dd3D tHi5 cOluMn. 1F j00 W@N+ to reMoVe It CliCk I+\$ cLo\$e Bu++On";

?>