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

/* $Id: x-hacker.inc.php,v 1.268 2008-01-06 20:59:28 decoyduck Exp $ */

// British English language file

// Language character set and text direction options -------------------

$lang['_isocode'] = "en";
$lang['_textdir'] = "ltr";

// Months --------------------------------------------------------------

$lang['month'][1]  = "j@NU4ry";
$lang['month'][2]  = "fEbruarY";
$lang['month'][3]  = "m@rch";
$lang['month'][4]  = "aPr1l";
$lang['month'][5]  = "m4y";
$lang['month'][6]  = "jUNE";
$lang['month'][7]  = "july";
$lang['month'][8]  = "auGUs+";
$lang['month'][9]  = "sEPT3MBER";
$lang['month'][10] = "ocT0B3r";
$lang['month'][11] = "noV3M83R";
$lang['month'][12] = "dEcEmBEr";

$lang['month_short'][1]  = "j4n";
$lang['month_short'][2]  = "f38";
$lang['month_short'][3]  = "m4R";
$lang['month_short'][4]  = "aPR";
$lang['month_short'][5]  = "m4Y";
$lang['month_short'][6]  = "jUn";
$lang['month_short'][7]  = "jUL";
$lang['month_short'][8]  = "aUG";
$lang['month_short'][9]  = "sEP";
$lang['month_short'][10] = "oc+";
$lang['month_short'][11] = "nOV";
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

$lang['date_periods']['year']   = "%s YEar";
$lang['date_periods']['month']  = "%s M0n+h";
$lang['date_periods']['week']   = "%s W3ek";
$lang['date_periods']['day']    = "%s d4y";
$lang['date_periods']['hour']   = "%s H0Ur";
$lang['date_periods']['minute'] = "%s m1nu+e";
$lang['date_periods']['second'] = "%s \$3c0ND";

// As above but plurals (2 years vs. 1 year, etc.)

$lang['date_periods_plural']['year']   = "%s y34rs";
$lang['date_periods_plural']['month']  = "%s mON+hs";
$lang['date_periods_plural']['week']   = "%s W33K\$";
$lang['date_periods_plural']['day']    = "%s d4Y\$";
$lang['date_periods_plural']['hour']   = "%s h0uRs";
$lang['date_periods_plural']['minute'] = "%s M1Nu+3\$";
$lang['date_periods_plural']['second'] = "%s SEC0NDS";

// Short hand periods (example: 1y, 2m, 3w, 4d, 5hr, 6min, 7sec)

$lang['date_periods_short']['year']   = "%sY";    // 1y
$lang['date_periods_short']['month']  = "%sM";    // 2m
$lang['date_periods_short']['week']   = "%sW";    // 3w
$lang['date_periods_short']['day']    = "%sd";    // 4d
$lang['date_periods_short']['hour']   = "%sHR";   // 5hr
$lang['date_periods_short']['minute'] = "%sm1n";  // 6min
$lang['date_periods_short']['second'] = "%s\$3c";  // 7sec

// Common words --------------------------------------------------------

$lang['percent'] = "p3rc3N+";
$lang['average'] = "aver@93";
$lang['approve'] = "apProvE";
$lang['banned'] = "b4NN3D";
$lang['locked'] = "l0CKEd";
$lang['add'] = "aDd";
$lang['advanced'] = "adV4nceD";
$lang['active'] = "ac+1VE";
$lang['style'] = "stYL3";
$lang['go'] = "g0";
$lang['folder'] = "fOld3R";
$lang['ignoredfolder'] = "i9N0R3D f0lDEr";
$lang['folders'] = "f0LdErs";
$lang['thread'] = "tHrEAD";
$lang['threads'] = "tHR3@ds";
$lang['threadlist'] = "thR3aD lis+";
$lang['message'] = "me\$Sa93";
$lang['messagenumber'] = "mE\$s4g3 nUm83R";
$lang['from'] = "frOm";
$lang['to'] = "tO";
$lang['all_caps'] = "alL";
$lang['of'] = "of";
$lang['reply'] = "rEpLY";
$lang['forward'] = "f0rwARD";
$lang['replyall'] = "r3Ply +0 4ll";
$lang['pm_reply'] = "r3Ply as PM";
$lang['delete'] = "d3l3+e";
$lang['deleted'] = "dELEtED";
$lang['edit'] = "edIt";
$lang['privileges'] = "prIVilegEs";
$lang['ignore'] = "igN0re";
$lang['normal'] = "n0RMal";
$lang['interested'] = "iN+3res+eD";
$lang['subscribe'] = "subsCr1B3";
$lang['apply'] = "apply";
$lang['download'] = "d0wnl0aD";
$lang['save'] = "s@Ve";
$lang['update'] = "upd@+3";
$lang['cancel'] = "c4ncel";
$lang['continue'] = "cOntinU3";
$lang['attachment'] = "a++4Chm3NT";
$lang['attachments'] = "a++AChmEnT5";
$lang['imageattachments'] = "im@GE 4t+@chm3nts";
$lang['filename'] = "filen@me";
$lang['dimensions'] = "d1MEnsiONs";
$lang['downloadedxtimes'] = "d0wnl0@D3D: %d t1mE\$";
$lang['downloadedonetime'] = "doWnlOadeD: 1 t1me";
$lang['size'] = "s1Z3";
$lang['viewmessage'] = "vi3W mes\$49E";
$lang['deletethumbnails'] = "deL3+3 THUmBN4ILs";
$lang['logon'] = "l0Gon";
$lang['more'] = "m0Re";
$lang['recentvisitors'] = "rEcen+ v1S1+0Rs";
$lang['username'] = "us3rnamE";
$lang['clear'] = "cl3@r";
$lang['action'] = "ac+I0n";
$lang['unknown'] = "unKnoWn";
$lang['none'] = "n0n3";
$lang['preview'] = "pReVIEW";
$lang['post'] = "p05+";
$lang['posts'] = "poS+s";
$lang['change'] = "cH4Nge";
$lang['yes'] = "ye\$";
$lang['no'] = "n0";
$lang['signature'] = "sI9n4+uRE";
$lang['signaturepreview'] = "s19n4+ur3 pREv13W";
$lang['signatureupdated'] = "siGn4+URe UpD@+ED";
$lang['signatureupdatedforallforums'] = "s1Gn4+URE upd4+3D F0R @ll pHorUms";
$lang['back'] = "b@ck";
$lang['subject'] = "sUbj3C+";
$lang['close'] = "clO53";
$lang['name'] = "nAm3";
$lang['description'] = "d3scrIP+i0n";
$lang['date'] = "d4+e";
$lang['view'] = "v13W";
$lang['enterpasswd'] = "eN+Er Password";
$lang['passwd'] = "pA5\$WorD";
$lang['ignored'] = "i9N0red";
$lang['guest'] = "gu35+";
$lang['next'] = "n3xT";
$lang['prev'] = "pR3Vious";
$lang['others'] = "otHErs";
$lang['nickname'] = "niCKn@M3";
$lang['emailaddress'] = "em@iL 4ddr35s";
$lang['confirm'] = "c0nfiRM";
$lang['email'] = "eM4il";
$lang['poll'] = "poLl";
$lang['friend'] = "fR13nD";
$lang['success'] = "succe\$S";
$lang['error'] = "eRroR";
$lang['warning'] = "w4Rn1n9";
$lang['guesterror'] = "s0rry, j00 ne3D +0 BE LoggED in +0 use +his fE4+ur3.";
$lang['loginnow'] = "l091n n0w";
$lang['unread'] = "unr34d";
$lang['all'] = "aLl";
$lang['allcaps'] = "all";
$lang['permissions'] = "peRmiss10n\$";
$lang['type'] = "tYPE";
$lang['print'] = "pRin+";
$lang['sticky'] = "s+1Cky";
$lang['polls'] = "p0ll\$";
$lang['user'] = "u5eR";
$lang['enabled'] = "en4BL3d";
$lang['disabled'] = "d1\$48l3d";
$lang['options'] = "opT1ONs";
$lang['emoticons'] = "eM0tiC0n\$";
$lang['webtag'] = "w38+@g";
$lang['makedefault'] = "m4K3 DEFAUlt";
$lang['unsetdefault'] = "un\$e+ D3pHaUlt";
$lang['rename'] = "reN4me";
$lang['pages'] = "p493S";
$lang['used'] = "us3d";
$lang['days'] = "d4Ys";
$lang['usage'] = "u549E";
$lang['show'] = "shOW";
$lang['hint'] = "hIn+";
$lang['new'] = "nEW";
$lang['referer'] = "rePhErEr";
$lang['thefollowingerrorswereencountered'] = "tEh f0Ll0Win9 ErroR\$ wER3 3nc0uNTEr3d:";

// Admin interface (admin*.php) ----------------------------------------

$lang['admintools'] = "aDmin +o0ls";
$lang['forummanagement'] = "forUm M4N49EmEnt";
$lang['accessdeniedexp'] = "j00 d0 n0t H@V3 p3rM1\$s1ON t0 u\$3 th1\$ SECt10n.";
$lang['managefolders'] = "m@n4g3 PHOlDeRS";
$lang['manageforums'] = "m4N@gE ph0RUm\$";
$lang['manageforumpermissions'] = "m4N493 phORUm PErM1\$SI0nS";
$lang['foldername'] = "f0LDEr n@m3";
$lang['move'] = "move";
$lang['closed'] = "cL0SED";
$lang['open'] = "open";
$lang['restricted'] = "rE\$tric+eD";
$lang['forumiscurrentlyclosed'] = "%s i\$ curR3n+ly Clo\$ED";
$lang['youdonothaveaccesstoforum'] = "j00 do n0t HavE 4cc3\$S +o %s";
$lang['toapplyforaccessplease'] = "to @ppLy phoR 4CC3Ss pleasE CoNT4Ct the f0rum OWn3r.";
$lang['adminforumclosedtip'] = "iF j00 w@nt t0 Ch4NG3 sOm3 \$ett1Ng\$ 0n y0UR ph0RUM Cl1CK th3 ADM1n L1nk in +3H nav19@+I0N B4r 48ov3.";
$lang['newfolder'] = "new F0LdEr";
$lang['nofoldersfound'] = "n0 Ex1ST1Ng phOLDER\$ F0und. t0 @DD 4 pHolDER CLick tHE '@Dd nEw' 8u+t0N 8ElOw.";
$lang['forumadmin'] = "f0rum @Dm1n";
$lang['adminexp_1'] = "uS3 TEH MEnu 0n tHE l3Ft +0 m@N493 th1NGS in yOUr PhOrum.";
$lang['adminexp_2'] = "<b>u53rs</b> @lLow5 j00 to s3+ 1ND1V1DU@l U\$er pErmI\$sI0n\$, inCLUD1ng 4pp01N+1Ng m0d3R4tORS 4nd g4Gg1n9 p30plE.";
$lang['adminexp_3'] = "<b>u\$Er grOuP\$</b> 4ll0WS J00 +o cRE4+3 u\$er 9R0Ups +o 4ssI9N permIssioN5 t0 a\$ M@ny or @s pheW UsEr\$ QUICklY 4ND 34\$ILy.";
$lang['adminexp_4'] = "<b>b4N c0n+R0ls</b> allOws +3h B4nniNg 4nd un-B4nning opH 1p 4DDr3S\$es, h++p rEpher3rs, UsErn4M3S, 3m4iL 4DdrEsseS 4ND N1CKN4MEs.";
$lang['adminexp_5'] = "<b>fOldErs</b> 4ll0w\$ +He CRE4T10N, m0d1F1c4+i0N AnD deL3T10n 0f f0LD3Rs.";
$lang['adminexp_6'] = "<b>r\$S feeDS</b> 4llow\$ J00 tO man4Ge rss phEEDs PhOR prop@G@+i0n 1N+0 y0Ur pHoruM.";
$lang['adminexp_7'] = "<b>pROPhil3S</b> LEt\$ j00 Cust0Mise +hE 1+eMs +H4T 4PPe4r 1n +H3 U\$ER pr0F1lE5.";
$lang['adminexp_8'] = "<b>fOruM S3Tt1N9S</b> 4lLOws J00 +o cUsToM1S3 yOUr fOrUM'\$ n@m3, 4pp3AR4Nc3 4nd MaNY 0+hER +hiNg\$.";
$lang['adminexp_9'] = "<b>sT4r+ pA93</b> l3+s j00 Custom1\$e yOur Forum'\$ \$t4rt P@G3.";
$lang['adminexp_10'] = "<b>foRUm stYle</b> alLOWs j00 To 9ENEr@+E r4nDom \$tyLE5 phOR y0Ur FoRUm m3M83rs +0 U\$e.";
$lang['adminexp_11'] = "<b>wORd Phil+3R</b> 4ll0W\$ J00 to PHIlTEr w0rd\$ J00 D0N't w4N+ To BE u53D On y0Ur ph0ruM.";
$lang['adminexp_12'] = "<b>p0Sting \$TATs</b> G3n3r4+35 4 REPor+ l1S+1N9 tHE +0P 10 p0sTeRs 1N 4 DEF1NeD pERi0d.";
$lang['adminexp_13'] = "<b>forUM Links</b> LET\$ j00 m4n49e +HE L1nKS Dropd0wn 1n +Eh n@VIg4tioN B@r.";
$lang['adminexp_14'] = "<b>v1eW l0g</b> LiS+s r3C3n+ aC+i0N5 BY +3h f0rum m0DEra+oRS.";
$lang['adminexp_15'] = "<b>m@n493 PHorums</b> LE+s j00 cr34+3 anD DEl3+E 4ND CLose 0R Re0pen f0Rums.";
$lang['adminexp_16'] = "<b>gL084l fOrum sEtt1n9\$</b> @ll0W\$ J00 t0 MoDifY \$e++1NGs whiCh 4pHpH3C+ aLl pHorums.";
$lang['adminexp_17'] = "<b>p05+ 4pprov@l quEU3</b> @llow5 j00 t0 V1Ew 4Ny p0\$ts @w4I+iN9 @ppR0V4L BY 4 m0dEr4+0r.";
$lang['adminexp_18'] = "<b>v1s1+OR lo9</b> 4ll0ws j00 +0 v1EW @n ex+3NDEd l1\$T 0PH v1\$IT0Rs iNClUd1n9 +heir HttP rEpheREr\$.";
$lang['createforumstyle'] = "cRe@+3 4 phoRuM \$+yl3";
$lang['newstylesuccessfullycreated'] = "n3W styl3 SUcCE5SPhulLy CR34+3D.";
$lang['stylealreadyexists'] = "a 5tYL3 w1+h +h4t PHil3N4m3 4LrE4DY 3xI\$ts.";
$lang['stylenofilename'] = "j00 did n0T enTEr A pHilen@mE +0 S4VE tHe s+ylE wIth.";
$lang['stylenodatasubmitted'] = "cOuLD nO+ R3Ad F0RUm stYlE DAt4.";
$lang['styleexp'] = "uS3 th1\$ P@GE +0 hELP Cre4t3 4 r4nD0MLy 93N3r@+ED 5+ylE f0R YoUr ph0RUm.";
$lang['stylecontrols'] = "coNtr0lS";
$lang['stylecolourexp'] = "cL1ck 0n A c0LOUr +0 m@KE @ N3w STYl3 sh3Et 8As3D ON THAT C0LOUr. cUrr3nt 8A53 C0lOur is pH1R\$t in l1S+.";
$lang['standardstyle'] = "st4nD4rd styl3";
$lang['rotelementstyle'] = "r0T4+ED 3L3m3nt styl3";
$lang['randstyle'] = "r4NdoM 5+yl3";
$lang['thiscolour'] = "thIs C0lOUr";
$lang['enterhexcolour'] = "or 3n+er 4 H3X C0l0ur +0 8as3 4 nEw s+yl3 \$h33+ 0n";
$lang['savestyle'] = "sAv3 +h1\$ styl3";
$lang['styledesc'] = "stYlE D3\$cr1ptiOn";
$lang['stylefilenamemayonlycontain'] = "s+Yle f1lEn4ME m4Y 0nlY C0n+@in lOw3RCasE LettEr\$ (a-z), numBER\$ (0-9) 4Nd UnD3rsCor3.";
$lang['stylepreview'] = "sTyle prEV13w";
$lang['welcome'] = "wELcom3";
$lang['messagepreview'] = "meS5@GE Pr3VI3W";
$lang['users'] = "uSEr5";
$lang['usergroups'] = "u\$3r GRouPs";
$lang['mustentergroupname'] = "j00 Must ENtEr @ 9roup n4M3";
$lang['profiles'] = "prOf1l3S";
$lang['manageforums'] = "m4n49E FoRUMs";
$lang['forumsettings'] = "foRUm se+t1N9\$";
$lang['globalforumsettings'] = "glOBal ph0rum 53T+Ings";
$lang['settingsaffectallforumswarning'] = "<b>n0tE:</b> Th3SE sET+1N9s apHF3CT 4Ll f0Rum\$. wh3rE +3H sEtT1Ng 15 duPl1c4+ED oN TEh inD1v1DU@L ForUm's se+T1NGs p493 +h4t w1ll +4KE pREc3denc3 0v3r T3h \$ET+1ng\$ j00 Ch@nG3 HeR3.";
$lang['startpage'] = "s+4rT P49E";
$lang['startpageerror'] = "yoUR \$T4r+ p@G3 cOuLD No+ 8E s4V3D LoCAllY t0 +H3 serv3R 8ecAusE pErm1\$sion W4\$ d3n13d.</p><p>t0 Ch@ngE your s+4rt p49e PleasE CLiCK thE D0WNLo@D button beL0W whiCh W1Ll pr0mp+ J00 +0 s4V3 +h3 phiLE +0 y0Ur h4rd dRiVE. j00 C@n th3N UPlo4D tHIS fIlE +o your 53rver intO +he f0Llowin9 ph0lDEr, iF NeC3S5@ry cre4TIng +hE ph0Lder \$Tructur3 1n The prOCEss.</p><p><b>%s</b></p><p>pl3453 not3 +h@t Som3 8roWSers m4Y ch4n9E +eh nAME of +H3 f1l3 upon d0wnlo4D.  whEn upl04dinG TEh f1L3 pl3Ase M4KE sur3 Th@t 1+ is n4M3d st4r+_m4in.Php 0+h3rwi\$e y0ur \$Tart p49e w1Ll 4Ppear Unchan9eD.";
$lang['failedtoopenmasterstylesheet'] = "y0Ur phoRUM styl3 could n0+ 8E s4V3d b3C@use ThE m@s+3R s+yl3 shEe+ CoUlD no+ 8E Lo4DED. +o \$@VE YOUr \$+yl3 +3h m4s+3R S+yl3 \$HEeT (mAkE_styl3.CSS) mu5+ B3 loCatED in +3H StyL3S DirEc+0RY 0f yOUR 8eeh1v3 f0Rum ins+4ll4ti0n.";
$lang['makestyleerror'] = "youR ph0Rum stYl3 C0ulD noT be S@vED l0Cally +o tH3 s3RvER 83C4u\$e PeRM1\$s10N wAS dENIED. to \$@v3 y0Ur F0rUM \$+yLE PL3@SE cLick +3H downLoad 8UttoN 8EloW wh1Ch will pRompT j00 t0 s4V3 +H3 pHIL3 TO y0Ur H4rD driV3. J00 C4n Th3N upL04d +h1\$ PhilE +0 y0uR s3rVer IN+0 %s FOlDER, 1F neCE\$S@ry cre4t1N9 th3 Fold3r s+ructUre In th3 pR0C3s\$. j00 SHouLd no+e +h4+ soM3 bROWs3RS m4Y cH4NGE teH N@m3 OpH +hE f1L3 uPoN d0WnlOAD. wH3n upL0@d1nG tHE fiL3 pL3a53 M4k3 SUr3 TH4t 1T 15 n4med Styl3.csS o+herW1\$3 TeH foRum \$tYLe W1ll 8E unus48Le.";
$lang['forumstyle'] = "fOrUM 5+yle";
$lang['wordfilter'] = "wOrD filt3r";
$lang['forumlinks'] = "fORUm linKs";
$lang['viewlog'] = "vi3W l0G";
$lang['noprofilesectionspecified'] = "nO profil3 sEC+i0N \$p3CipHI3D.";
$lang['itemname'] = "i+3m n4m3";
$lang['moveto'] = "mOv3 tO";
$lang['manageprofilesections'] = "mAn@ge prophile sEC+i0n\$";
$lang['sectionname'] = "sEc+10n NAME";
$lang['items'] = "iT3ms";
$lang['mustspecifyaprofilesectionid'] = "mU\$+ sp3CiFY 4 PRof1L3 s3C+10n 1D";
$lang['mustsepecifyaprofilesectionname'] = "mU\$+ sp3C1fy 4 pr0PHile sECt10n naME";
$lang['noprofilesectionsfound'] = "no 3xiS+1ng prophIl3 seC+10N\$ F0UNd. +0 @DD 4 pr0fil3 sEC+i0N ClICk th3 '@dD NEw' 8UttOn BEl0w.";
$lang['addnewprofilesection'] = "aDd nEw profiL3 seCt10n";
$lang['successfullyaddedprofilesection'] = "succ3SsfUlLY @Dd3d PropHil3 S3ct1on";
$lang['successfullyeditedprofilesection'] = "sUCC3ssfulLy 3d1+3D Pr0Phil3 SEct10N";
$lang['addnewprofilesection'] = "add NEw pr0FIl3 seC+i0n";
$lang['mustsepecifyaprofilesectionname'] = "mUs+ sp3CIphy @ pR0File sECT10n naME";
$lang['successfullyremovedselectedprofilesections'] = "sUCCessphUlLy R3m0V3D SeL3c+eD pr0phil3 s3CtI0nS";
$lang['failedtoremoveprofilesections'] = "f@IlED +0 rEmov3 propHilE seCtI0ns";
$lang['viewitems'] = "viEW 1T3ms";
$lang['successfullyaddednewprofileitem'] = "sUcc3SsfUlly 4DDED n3W prophIlE 1+Em";
$lang['successfullyeditedprofileitem'] = "sucCE\$SPhully ED1+ED Pr0PHil3 i+EM";
$lang['successfullyremovedselectedprofileitems'] = "sUCC3\$sfullY REmov3D s3LEC+3d pROPh1le I+EMs";
$lang['failedtoremoveprofileitems'] = "fAil3d to r3MovE pr0PHIl3 i+EMs";
$lang['noexistingprofileitemsfound'] = "tHErE 4rE n0 exi\$+1N9 prophIl3 iTEm\$ iN +h1\$ \$eC+i0N. t0 4Dd 4n itEM cL1CK TEh '@dD nEW' 8u+toN B3low.";
$lang['edititem'] = "ed1t 1+3m";
$lang['invalidprofilesectionid'] = "inV@lid pr0Phil3 S3ction 1D or s3C+10n no+ PHounD";
$lang['invalidprofileitemid'] = "inV@liD pR0phIl3 i+3M 1D oR 1Tem not f0uNd";
$lang['addnewitem'] = "aDd n3w item";
$lang['youmustenteraprofileitemname'] = "j00 mu\$T entEr @ pr0fil3 I+em nAME";
$lang['invalidprofileitemtype'] = "invALid pr0PHil3 1+em +yPE sEl3cteD";
$lang['youmustenteroptionsforselectedprofileitemtype'] = "j00 mus+ 3N+3r S0me oPt1ONs f0r s3LEC+ED ProPhIl3 itEm +yp3";
$lang['youmustentermorethanoneoptionforitem'] = "j00 MUst 3n+3r m0Re +h4n 0NE op+1On f0R Sel3C+ED pROPHIle 1+Em +Ype";
$lang['profileitemhyperlinkssupportshttpurlsonly'] = "pROf1L3 it3M hyp3RL1NKs sUpp0R+ H++p Urls 0Nly";
$lang['profileitemhyperlinkformatinvalid'] = "pr0phil3 i+3m hyPErl1Nk Form@+ iNv4L1D";
$lang['youmustincludeprofileentryinhyperlinks'] = "j00 MUS+ 1NCLuDE <i>%s</i> 1N +hE Url oF Cl1CK@8LE hYpErL1Nks";
$lang['failedtocreatenewprofileitem'] = "f41lEd to CR3atE NEW pRof1l3 1+em";
$lang['failedtoupdateprofileitem'] = "f4ILeD +o UpD@te Pr0Phile 1+Em";
$lang['startpageupdated'] = "s+@R+ p4G3 uPD4+3D. %s";
$lang['viewupdatedstartpage'] = "v13w UPd@+Ed \$t4rt p@93";
$lang['editstartpage'] = "edit STart p@G3";
$lang['nouserspecified'] = "n0 u5er \$P3cifiEd.";
$lang['manageuser'] = "maN@9E u5Er";
$lang['manageusers'] = "maNA9E U\$3rs";
$lang['userstatusforforum'] = "u\$3R statUs Phor %s";
$lang['userdetails'] = "u\$Er det4IL\$";
$lang['warning_caps'] = "w@rNINg";
$lang['userdeleteallpostswarning'] = "aR3 J00 sUr3 j00 w4n+ +0 D3L3+E 4LL 0f THe sEl3C+ED u53r'\$ pO\$ts? onC3 +eh Po\$+S @r3 dEl3TED +HEY C4nn0+ Be RE+rIEVED and WILl 8E L0s+ F0revEr.";
$lang['postssuccessfullydeleted'] = "pO\$+s wer3 suCC355fullY DELetED.";
$lang['folderaccess'] = "foLDeR @CCEss";
$lang['possiblealiases'] = "poS5I8LE 4L14s3S";
$lang['userhistory'] = "u\$3r h1\$+Ory";
$lang['nohistory'] = "n0 h1story r3c0rDs saveD";
$lang['userhistorychanges'] = "ch4n9Es";
$lang['clearuserhistory'] = "cle@R user hisTORy";
$lang['changedlogonfromto'] = "cH@n9ed l0G0N FRom %s t0 %s";
$lang['changednicknamefromto'] = "chAn9eD n1ckn4M3 From %s T0 %s";
$lang['changedemailfromto'] = "ch4n9eD 3Ma1l PHr0m %s +0 %s";
$lang['successfullycleareduserhistory'] = "sUcc3SsFully CLe4red u53r HI\$TOry";
$lang['failedtoclearuserhistory'] = "faIL3D tO Cl3@r User hIs+ory";
$lang['successfullychangedpassword'] = "succe\$SFulLy Ch@ng3d P@SsworD";
$lang['failedtochangepasswd'] = "f41led +0 Ch4ng3 p@ssw0Rd";
$lang['viewuserhistory'] = "vI3w usEr H1st0ry";
$lang['viewuseraliases'] = "v13W U\$er Al14sEs";
$lang['searchreturnednoresults'] = "sE4Rch r3+urNED no r3SuL+s";
$lang['deleteposts'] = "deLEtE pos+s";
$lang['deleteuser'] = "d3L3T3 U\$er";
$lang['alsodeleteusercontent'] = "al5o dEle+E all oph tEh c0NTEnt CRE4+ED 8Y tHis u53r";
$lang['userdeletewarning'] = "aR3 j00 sur3 J00 w4n+ +0 DEl3+3 teh sEl3C+3D UseR 4cC0un+? oncE ThE @CC0unt h4\$ B3EN DEL3TeD iT C@nn0T BE R3Tr13v3D @nD wIll 83 lo5+ f0r3v3r.";
$lang['usersuccessfullydeleted'] = "u\$3R sUCC3\$\$fulLy DEL3+3D";
$lang['failedtodeleteuser'] = "f@il3d TO d3lETE u\$er";
$lang['forgottenpassworddesc'] = "iPH thIs usEr has F0r90++3N Th31r P4\$SW0RD j00 c@N r3sE+ i+ f0R Them hEr3.";
$lang['failedtoupdateuserstatus'] = "f41L3d to updAtE Us3r \$+4+us";
$lang['failedtoupdateglobaluserpermissions'] = "f4il3d t0 uPD@+E 9L0bal UsEr PErmis\$10N\$";
$lang['failedtoupdatefolderaccesssettings'] = "f41Led t0 UpdAte f0ld3R @CC3Ss seT+1n9S";
$lang['manageusersexp'] = "tH1S lisT sHows a seL3C+i0N opH U\$ER\$ WH0 havE Log93d 0n to y0ur fOrum, \$or+3d 8y %s. to al+ER @ U53r'\$ p3RM15\$10Ns Cl1Ck tHEIr n4m3.";
$lang['userfilter'] = "usEr ph1L+3R";
$lang['onlineusers'] = "onl1N3 U\$3rs";
$lang['offlineusers'] = "oPHpHlin3 u5ers";
$lang['usersawaitingapproval'] = "uSerS 4w41+1ng 4ppr0V4l";
$lang['bannedusers'] = "bAnn3D u\$3rs";
$lang['lastlogon'] = "l4st L090N";
$lang['sessionreferer'] = "sESsion rEFER3r";
$lang['signupreferer'] = "sI9n-UP reFEr3R:";
$lang['nouseraccountsmatchingfilter'] = "no Us3r 4cCoun+\$ m@tChInG phiL+3R";
$lang['searchforusernotinlist'] = "sE4rCh F0R 4 Us3r n0T 1N Li\$T";
$lang['adminaccesslog'] = "admin 4CC355 log";
$lang['adminlogexp'] = "thI\$ list sh0W5 THE l4st 4CT10Ns s4NCTiOneD by u53r\$ wI+h 4DMiN pR1v1lEgES.";
$lang['datetime'] = "d4+3/T1ME";
$lang['unknownuser'] = "unKNown User";
$lang['unknownuseraccount'] = "uNKn0WN usER 4Ccount";
$lang['unknownfolder'] = "unKNown phOlD3R";
$lang['ip'] = "ip";
$lang['lastipaddress'] = "l4s+ Ip 4DDrEss";
$lang['hostname'] = "h05+n4m3";
$lang['unknownhostname'] = "unKNOwn h0S+n4ME";
$lang['logged'] = "l0GGEd";
$lang['notlogged'] = "noT logGed";
$lang['addwordfilter'] = "adD WorD pH1l+Er";
$lang['addnewwordfilter'] = "add n3W woRD FiL+Er";
$lang['wordfilterupdated'] = "wOrd FilT3R UpD4+ED";
$lang['wordfilterisfull'] = "j00 c@nNo+ @Dd @ny morE W0RD f1L+ers. r3M0VE s0Me UnU5ED oNE5 0R 3d1+ +eh 3Xi\$T1ng onEs phir\$+.";
$lang['filtername'] = "f1l+ER n4m3";
$lang['filtertype'] = "f1Lt3r +yPE";
$lang['filterenabled'] = "f1L+er Ena8LeD";
$lang['editwordfilter'] = "edit worD f1l+3r";
$lang['nowordfilterentriesfound'] = "n0 eX1st1ng w0rD ph1Lt3r 3NTRiE\$ F0UnD. +o @DD 4 pHILt3r ClIck TEh '@DD nEw' BU++0N BEL0W.";
$lang['mustspecifyfiltername'] = "j00 must speciFy a f1L+eR n4M3";
$lang['mustspecifymatchedtext'] = "j00 mu5t sp3cify m4tch3d TExt";
$lang['mustspecifyfilteroption'] = "j00 mU\$t Sp3CiFy @ ph1L+Er op+10n";
$lang['mustspecifyfilterid'] = "j00 mus+ SP3c1PHy a ph1L+3r iD";
$lang['invalidfilterid'] = "iNv4l1d phiL+3R iD";
$lang['failedtoupdatewordfilter'] = "f4Il3D t0 UPD4+3 worD f1Lt3R. CHECK Th4+ +HE philt3r \$T1ll exists.";
$lang['allow'] = "alL0w";
$lang['block'] = "blOCK";
$lang['normalthreadsonly'] = "n0Rm4l +HrE4D\$ oNly";
$lang['pollthreadsonly'] = "pOll +HrE4D\$ 0nLY";
$lang['both'] = "boTh +Hr34d +ypES";
$lang['existingpermissions'] = "eX1S+1ng PErm1s\$10Ns";
$lang['nousershavebeengrantedpermission'] = "n0 Exist1n9 U\$er\$ p3rM15\$10N\$ phoUnD. T0 9R4n+ P3rm1ss10N to usEr5 s34rcH f0R tHEm BEl0w.";
$lang['successfullyaddedpermissionsforselectedusers'] = "sUcc3ssFUlly aDdED P3Rmiss1Ons f0r \$elecTeD U\$3r5";
$lang['successfullyremovedpermissionsfromselectedusers'] = "sUccessfULly r3M0v3d pERmission5 pHrom 53lEc+3d u\$3rs";
$lang['failedtoaddpermissionsforuser'] = "f41l3D +0 4dD PeRm1\$SI0n\$ PhoR u\$Er '%s'";
$lang['failedtoremovepermissionsfromuser'] = "fa1led +0 r3mov3 pErMi5si0ns PHr0m u53R '%s'";
$lang['searchforuser'] = "s3@rCh phOr u53r";
$lang['browsernegotiation'] = "br0w\$3r neg0TI@teD";
$lang['largetextfield'] = "l@R9E +Ext pHi3Ld";
$lang['mediumtextfield'] = "mEdium t3xt pHI3ld";
$lang['smalltextfield'] = "smALl tEx+ fiEld";
$lang['multilinetextfield'] = "mUlt1-linE +eXT ph13lD";
$lang['radiobuttons'] = "r@D10 bUt+on5";
$lang['dropdownlist'] = "drOp d0wn lIst";
$lang['clickablehyperlink'] = "cLIck@8le hyp3rLINk";
$lang['threadcount'] = "thRE4d c0Unt";
$lang['clicktoeditfolder'] = "clICK t0 ED1+ phOlD3R";
$lang['fieldtypeexample1'] = "tO CREatE r@Dio 8UTTon\$ 0R A drop D0wN l1\$T J00 neeD +0 ENTEr E4CH InDIv1du4L v4lue 0n @ sEp4rate lIn3 in tEH 0p+i0N5 phI3LD.";
$lang['fieldtypeexample2'] = "t0 CREate cL1Ck@BLE l1NKs EntER +3h URl in +3H op+i0n\$ Ph13ld @nd UsE <i>%1\$S</i> wher3 TEH entRY PhR0M +HE u53r'5 pr0Ph1l3 sH0Uld 4ppe4R. 3X4mpl3S: <p>mY5P4c3: <i>hTtp://wWw.mysp@CE.Com/%1\$s</i><br />x80x livE: <i>h+tp://pr0F1l3.myg@merC4RD.n3T/%1\$S</i>";
$lang['editedwordfilter'] = "eD1+ed W0RD fIl+3r";
$lang['editedforumsettings'] = "eDITEd f0rum \$E++1Ng\$";
$lang['successfullyendedusersessionsforselectedusers'] = "sUCcE\$SFUlLy 3nd3d S3s\$1onS F0R \$eL3c+ED usErs";
$lang['failedtoendsessionforuser'] = "f41leD to enD sE\$S1on f0R U\$Er %s";
$lang['successfullyapprovedselectedusers'] = "sUCcEssFuLLY @ppR0V3D \$EL3c+3D UsErs";
$lang['matchedtext'] = "maTCHED text";
$lang['replacementtext'] = "r3Pl@CEm3N+ +ext";
$lang['preg'] = "pReg";
$lang['wholeword'] = "wH0l3 W0RD";
$lang['word_filter_help_1'] = "<b>aLl</b> M4+Ch3S 4941n\$+ +he Wh0le text s0 phIltER1Ng M0M tO MUm wiLl @l50 ch@nGE m0MEN+ To mUmEN+.";
$lang['word_filter_help_2'] = "<b>wH0Le woRD</b> M@+Ch3s 4G41n\$T wh0LE w0rds ONLY s0 F1l+er1N9 m0m to mum wiLl No+ chaNgE moment T0 MumEn+.";
$lang['word_filter_help_3'] = "<b>pR39</b> @llOW\$ J00 +o us3 perl regul@R 3xpr3s\$i0n\$ +0 m@tCH tEx+.";
$lang['nameanddesc'] = "n4mE and descr1p+i0n";
$lang['movethreads'] = "m0V3 ThRE4Ds";
$lang['movethreadstofolder'] = "m0V3 +hr3@Ds +0 pHolD3R";
$lang['failedtomovethreads'] = "f4IL3D t0 move +hR3ADs +O Sp3CIF1ED PhoLDEr";
$lang['resetuserpermissions'] = "rEset usER p3rmiS\$10n\$";
$lang['failedtoresetuserpermissions'] = "f41l3D t0 R3\$Et UsEr PErM1\$s1ons";
$lang['allowfoldertocontain'] = "all0w foldER tO C0n+@1n";
$lang['addnewfolder'] = "aDd N3w foldEr";
$lang['mustenterfoldername'] = "j00 mu\$T eNt3r a f0lD3r N4me";
$lang['nofolderidspecified'] = "n0 f0LD3R iD \$P3C1F13d";
$lang['invalidfolderid'] = "iNV4l1D ph0lD3r id. Ch3ck +H4+ @ ph0LdER wi+h +his Id 3Xi\$+S!";
$lang['successfullyaddednewfolder'] = "succ3\$SphUlly 4dD3d n3W pholD3R";
$lang['successfullyremovedselectedfolders'] = "sUCCe\$SFUlLY remov3D seL3C+3D F0LD3r\$";
$lang['successfullyeditedfolder'] = "suCC3ssphuLlY eDitED F0lDEr";
$lang['failedtocreatenewfolder'] = "f4IL3D t0 CR3aTE nEW f0LD3r";
$lang['failedtodeletefolder'] = "f41led +0 DElEtE F0lDEr.";
$lang['failedtoupdatefolder'] = "fa1l3D to upD@tE Ph0lder";
$lang['cannotdeletefolderwiththreads'] = "c4nN0+ d3L3t3 PHold3RS +h@t s+1ll con+@1N +hR3ADs.";
$lang['forumisnotrestricted'] = "f0Rum is n0t REs+r1CT3d";
$lang['groups'] = "gr0up\$";
$lang['nousergroups'] = "n0 U\$eR grOUpS hAVE b33n seT uP. +o 4Dd A GRoup CLicK +hE '@DD new' 8UT+oN 8eLow.";
$lang['suppliedgidisnotausergroup'] = "suppLI3d gID 1\$ N0t @ us3R gR0Up";
$lang['manageusergroups'] = "m4N4g3 U\$er 9roup5";
$lang['groupstatus'] = "gR0up st@+Us";
$lang['addusergroup'] = "aDD u53r Gr0UP";
$lang['addemptygroup'] = "add 3Mpty GR0up";
$lang['adduserstogroup'] = "aDD USerS +O 9r0uP";
$lang['addremoveusers'] = "adD/REMove US3rs";
$lang['nousersingroup'] = "theR3 aR3 no US3rs in th1\$ gR0up. @dD u\$erS +0 Th1\$ Gr0Up BY 53@RChing FoR th3M 8ELoW.";
$lang['groupaddedaddnewuser'] = "sUCc3S\$pHullY 4DD3D 9roUP. @dD u\$3RS tO tHIs 9ROUP 8Y S34RcH1Ng PhoR tHEm bEL0w.";
$lang['nousersingroupaddusers'] = "tH3RE 4R3 n0 U\$eRs 1n This gR0up. +0 adD usERs CliCk +h3 '4dD/remOVe USErs' bU++0N bel0w.";
$lang['useringroups'] = "th1S U\$eR i5 @ m3M83r 0F tEH fOll0WIng GrOUps";
$lang['usernotinanygroups'] = "tHi5 U\$3R is No+ In 4Ny uSEr Gr0UPs";
$lang['usergroupwarning'] = "nOt3: +his usEr m@y BE iNH3R1+in9 @DD1t10N4l pErM15\$10ns fRoM 4Ny u\$ER 9roUPS lIs+3d 8EloW.";
$lang['successfullyaddedgroup'] = "sUCc3\$SFUllY @DD3d Group";
$lang['successfullyeditedgroup'] = "sUCC3\$SphUllY 3Di+3D gRoup";
$lang['successfullydeletedselectedgroups'] = "sUcc3SSfully D3L3+3d S3lECt3d gr0uP\$";
$lang['failedtodeletegroupname'] = "f4il3D +0 DElE+E 9r0UP %s";
$lang['usercanaccessforumtools'] = "uS3R C@n @CC3Ss f0Rum +0ol5 And cAn CRE@+3, D3lE+E @ND 3dIT f0ruMS";
$lang['usercanmodallfoldersonallforums'] = "us3R C4n MOD3r4tE <b>aLl pHolD3rs</b> 0n <b>alL F0RuMs</b>";
$lang['usercanmodlinkssectiononallforums'] = "u5Er c4N m0D3r@+3 l1Nk5 SEC+10n on <b>aLl ph0RUMs</b>";
$lang['emailconfirmationrequired'] = "eMA1l ConphiRm@+i0N REqUIr3D";
$lang['userisbannedfromallforums'] = "u\$3R is 84nned Fr0m <b>alL F0Rums</b>";
$lang['cancelemailconfirmation'] = "c4NC3l 3m4il C0Nph1rm@+I0N aND 4Ll0W usEr +o s+@rT p0\$+1n9";
$lang['resendconfirmationemail'] = "rE\$3nd C0NPh1Rm4t1on 3M4il t0 user";
$lang['failedtosresendemailconfirmation'] = "f41led +0 re5EnD 3M4il c0NPhirM4+10n T0 User.";
$lang['donothing'] = "dO no+hin9";
$lang['usercanaccessadmintools'] = "u\$er has 4CC3\$S +0 Forum @DmIn +0oLS";
$lang['usercanaccessadmintoolsonallforums'] = "user HAs 4CC3Ss +0 4DM1n T0olS <b>oN 4lL F0rum\$</b>";
$lang['usercanmoderateallfolders'] = "u\$er C4n m0DEr4T3 4ll PholdErs";
$lang['usercanmoderatelinkssection'] = "uS3R CAn MoD3R@+e l1nKs seC+1ON";
$lang['userisbanned'] = "uSer i\$ 8@nnED";
$lang['useriswormed'] = "us3R 1\$ W0rm3d";
$lang['userispilloried'] = "uS3r 1s pill0r1ED";
$lang['usercanignoreadmin'] = "u53r c4N igN0rE aDM1nisTr4+0Rs";
$lang['groupcanaccessadmintools'] = "grOUp C@n @CCess @DM1N +o0Ls";
$lang['groupcanmoderateallfolders'] = "gRoup Can moder4t3 4lL pH0ld3r\$";
$lang['groupcanmoderatelinkssection'] = "gr0uP C4n moD3R4t3 link5 \$EC+10NS";
$lang['groupisbanned'] = "grOUp 1s B@nNED";
$lang['groupiswormed'] = "grOUp 1s woRm3D";
$lang['readposts'] = "rE4d P0\$Ts";
$lang['replytothreads'] = "r3Ply t0 +hR34ds";
$lang['createnewthreads'] = "cR34+e N3w thrEads";
$lang['editposts'] = "eDIT p0s+\$";
$lang['deleteposts'] = "d3L3+3 P0STs";
$lang['postssuccessfullydeleted'] = "p05+s SUCCe5\$Fully DEletED";
$lang['failedtodeleteusersposts'] = "fa1leD +0 DELEte U\$3r'\$ poS+S";
$lang['uploadattachments'] = "uPLoAD @t+@chMEn+s";
$lang['moderatefolder'] = "m0deR@te Ph0LDER";
$lang['postinhtml'] = "pO\$+ in html";
$lang['postasignature'] = "poS+ @ 5IGn4+urE";
$lang['editforumlinks'] = "edit F0rum Link\$";
$lang['linksaddedhereappearindropdown'] = "liNk5 @Dd3D hEr3 4pPe4r 1N @ Dr0p Down 1n teh Top rI9Ht 0F t3H fr4me sE+.";
$lang['linksaddedhereappearindropdownaddnew'] = "lInKS 4DD3D h3re 4ppE4r iN 4 Dr0p DowN iN th3 +0P ri9H+ 0f the fR4M3 set. +o 4dd 4 LInk cl1ck TH3 '@DD nEW' 8u++on BEL0W.";
$lang['failedtoremoveforumlink'] = "f@iL3d +o rEm0V3 forUm L1Nk '%s'";
$lang['failedtoaddnewforumlink'] = "f4Il3D to 4DD nEw phorUm l1nk '%s'";
$lang['failedtoupdateforumlink'] = "f41leD to upD4+3 phoruM lInk '%s'";
$lang['notoplevellinktitlespecified'] = "n0 t0p l3Vel liNk tI+l3 sp3cifiED";
$lang['youmustenteralinktitle'] = "j00 muST entEr 4 liNk titlE";
$lang['alllinkurismuststartwithaschema'] = "alL l1Nk UR1S mUst st4rt W1Th @ \$ch3M4 (1.3. h++P://, pH+p://, 1RC://)";
$lang['editlink'] = "eD1T link";
$lang['addnewforumlink'] = "add NEW f0RUM l1NK";
$lang['forumlinktitle'] = "f0Rum link +I+LE";
$lang['forumlinklocation'] = "f0rUM l1NK loc4+1on";
$lang['successfullyaddednewforumlink'] = "sUCC3ssphUlLy 4dd3d N3w fORUM LinK";
$lang['successfullyeditedforumlink'] = "sUcC3\$SfUlly 3D1+Ed f0rum L1nk";
$lang['invalidlinkidorlinknotfound'] = "inv@l1d lInk id 0r link n0T phoUnD";
$lang['successfullyremovedselectedforumlinks'] = "succE\$SfUlly rEmoVed \$el3cted LInKs";
$lang['toplinkcaption'] = "tOP l1Nk CapT10n";
$lang['allowguestaccess'] = "aLl0w 9U3ST 4cc3\$\$";
$lang['searchenginespidering'] = "s3ArCh eng1n3 5piD3RinG";
$lang['allowsearchenginespidering'] = "all0w \$34RCH EnGiNE spiDEr1Ng";
$lang['newuserregistrations'] = "new u\$3R reGistr4+i0n\$";
$lang['preventduplicateemailaddresses'] = "pRevEnT dUPl1c4+3 EMA1L 4ddREssE\$";
$lang['allownewuserregistrations'] = "allow n3w UsEr r3g1\$TR4+i0ns";
$lang['requireemailconfirmation'] = "r3quire 3M@Il C0NPHirm@+1On";
$lang['usetextcaptcha'] = "u\$3 tExt-c4ptCH@";
$lang['textcaptchadir'] = "tExT-C4PTCh4 D1R3C+0ry";
$lang['textcaptchakey'] = "t3xt-c@p+Ch@ k3Y";
$lang['textcaptchafonterror'] = "t3xt-C@P+CH@ h4S 8E3n Dis@8lED 4U+0m4t1C4LLY 83c4u\$e thEr3 are N0 +ruE +yp3 PH0N+s @v@1L48l3 foR i+ +0 U\$e. PLE4\$E UpL0@D Som3 tru3 +Yp3 Ph0n+S +o <b>%s</b> 0N y0uR SERv3r.";
$lang['textcaptchadirerror'] = "teXt-c4PTcha h4\$ 8E3n DI\$A8leD 8EC4use +hE +3Xt_C@p+Ch@ D1r3C+0RY 4ND i+'\$ \$uB-D1R3c+0r13s 4rE n0+ wri+48le 8Y Teh wEb \$3rvEr / Php proc3S\$.";
$lang['textcaptchagderror'] = "teXt-C@p+CH@ h4\$ B3en D1s@8lED 8EC@U\$e Your 53rver'5 php \$etUp d03S n0+ PR0vid3 supp0r+ F0R gD iM@ge m4nipuL@+i0n ANd / or +tF PH0n+ \$UPp0R+. B0+h @r3 r3qUireD pH0r +3Xt-c@p+Cha suPport.";
$lang['textcaptchadirblank'] = "t3XT-C4PTCH4 D1R3C+0ry I\$ blAnk!";
$lang['newuserpreferences'] = "neW us3r PReF3R3nc3s";
$lang['sendemailnotificationonreply'] = "eM@IL No+IpH1CAT10n 0n rEPlY t0 U\$er";
$lang['sendemailnotificationonpm'] = "eM@1L N0+IfIC@+i0N On Pm T0 user";
$lang['showpopuponnewpm'] = "sH0w popup wH3n R3C31V1ng n3W Pm";
$lang['setautomatichighinterestonpost'] = "sEt aut0m@+1C h1gH INteR3St oN P0\$+";
$lang['postingstats'] = "p0\$+1ng \$t4+s";
$lang['postingstatsforperiod'] = "pOST1ng \$TAts f0r p3Ri0D %s +O %s";
$lang['nopostdatarecordedforthisperiod'] = "n0 P0\$+ d4+@ reC0RD3d foR +hIs peR10D.";
$lang['totalposts'] = "tOtal P0sTS";
$lang['totalpostsforthisperiod'] = "t0+4l pos+\$ Phor Thi\$ Per1od";
$lang['mustchooseastartday'] = "musT Cho0Se 4 5+@Rt Day";
$lang['mustchooseastartmonth'] = "mU\$+ cho0\$3 a s+@rT M0n+h";
$lang['mustchooseastartyear'] = "mUsT CHoo53 a s+4r+ yE4r";
$lang['mustchooseaendday'] = "mUs+ choos3 4 3ND D4y";
$lang['mustchooseaendmonth'] = "mUs+ Ch00se @ End M0NTh";
$lang['mustchooseaendyear'] = "mUst ch0O\$E @ 3ND y34r";
$lang['startperiodisaheadofendperiod'] = "sT@rt peR10d is 4h3ad 0Ph END P3Ri0D";
$lang['bancontrols'] = "b4N coN+r0Ls";
$lang['addban'] = "aDd 8@n";
$lang['checkban'] = "cHEck 8AN";
$lang['editban'] = "eD1T B4N";
$lang['bantype'] = "b@n typE";
$lang['bandata'] = "ban DA+4";
$lang['bancomment'] = "coMM3NT";
$lang['ipban'] = "ip 8aN";
$lang['logonban'] = "l090n 8an";
$lang['nicknameban'] = "nIckn4M3 84n";
$lang['emailban'] = "ema1L b4n";
$lang['refererban'] = "ref3r3r B4n";
$lang['invalidbanid'] = "inV4L1d ban 1D";
$lang['affectsessionwarnadd'] = "tHis 8An maY @ff3c+ +he f0Ll0w1Ng 4C+iVe usEr SEss1ons";
$lang['noaffectsessionwarn'] = "thIs 8AN 4phPH3c+s N0 aC+iv3 SESsI0N\$";
$lang['mustspecifybantype'] = "j00 mu5+ \$P3c1Fy 4 8@N +yp3";
$lang['mustspecifybandata'] = "j00 mUS+ \$P3ciFy \$0mE 8@n D4ta";
$lang['successfullyremovedselectedbans'] = "sUcc3s5pHuLlY REMoveD sEL3C+ED BAns";
$lang['failedtoaddnewban'] = "f4Il3d t0 4dd N3W 8AN";
$lang['failedtoremovebans'] = "f41lEd +0 r3mov3 s0M3 0r 4lL of +3h sEl3C+ED 8@ns";
$lang['duplicatebandataentered'] = "duPLIcatE B4n D4TA 3n+3reD. plE4sE CH3Ck y0Ur wIlDC4RDs t0 53e 1PH th3Y @lrE4DY M4+CH teh D@+4 ENtEreD";
$lang['successfullyaddedban'] = "sucCessfully @ddED 84n";
$lang['successfullyupdatedban'] = "sucC355fULly UpD4+ED B4N";
$lang['noexistingbandata'] = "th3RE 1S no 3Xi\$+In9 8an D4+4. +0 4Dd 4 Ban clICk t3h '@dd nEw' 8u++oN Bel0W.";
$lang['youcanusethepercentwildcard'] = "j00 C@n UsE +he p3rc3N+ (%) WildC@RD sYm8Ol 1N @Ny oF your B4n l1S+s T0 obtA1N P4r+IAL mAtch3\$, i.e. '192.168.0.%' wOuLD B4N 4LL 1P @ddrEs\$35 1n +3h r4NGE 192.168.0.1 +hr0UGH 192.168.0.254";
$lang['cannotusewildcardonown'] = "j00 c4nn0+ 4DD % 4S 4 WiLDC4rD M4tCH on 1+'\$ 0wN!";
$lang['requirepostapproval'] = "r3qU1re po5+ 4pproV@L";
$lang['adminforumtoolsusercounterror'] = "th3re Must b3 4t LE45+ 1 User wi+h 4DM1n to0L\$ anD f0RuM +0OL5 aCCESs on @ll F0rUm\$!";
$lang['postcount'] = "p0\$+ CoUnt";
$lang['resetpostcount'] = "rE53+ POst cOun+";
$lang['failedtoresetuserpostcount'] = "f4IL3d +0 r3\$3t p0\$+ C0unT";
$lang['failedtochangeuserpostcount'] = "f@iled +0 ch@n93 u5Er p0s+ C0Unt";
$lang['postapprovalqueue'] = "p0st 4PprOV@l qU3U3";
$lang['nopostsawaitingapproval'] = "nO p0\$+S 4R3 4w@i+iNg 4Ppr0V4l";
$lang['approveselected'] = "aPprovE s3lEC+3D";
$lang['failedtoapproveuser'] = "f41l3D to 4Ppr0V3 u53r %s";
$lang['kickselected'] = "k1cK sel3c+Ed";
$lang['visitorlog'] = "v151+or l09";
$lang['clearvisitorlog'] = "cle@r vi\$itor L0g";
$lang['novisitorslogged'] = "n0 VI\$I+0rs L0G93D";
$lang['addselectedusers'] = "adD sEleCT3D U53R\$";
$lang['removeselectedusers'] = "r3mOV3 sEl3c+ed U53rs";
$lang['addnew'] = "aDd n3W";
$lang['deleteselected'] = "dEl3T3 S3l3C+ED";
$lang['forumrulesmessage'] = "<p><b>fOruM RulEs</b></p><p>\nR39istr4+i0N T0 %1\$\$ I\$ FR3e! w3 d0 1ns1\$+ +h@+ j00 @B1d3 8y ThE rUl3s 4ND p0l1C13S DE+@1LeD B3lOw. 1PH j00 4grEE +0 +EH +3Rms, PlE453 Ch3CK tEh 'i agR3E' Ch3ck80x @nd prE\$s +hE 'r391S+3R' 8u++On B3L0w. 1ph j00 w0UlD l1ke +o C@nc3L +he r391\$Trat10N, CliCk %2\$S +0 r3tUrn +0 teH foruMS indeX.</p><p>\n@lthOU9h +he 4dmin1S+R4+0RS @nd m0d3r4t0r\$ 0f %1\$\$ w1ll @tT3MP+ to K3Ep @Ll objeCti0n@8le m3\$S4G3\$ oPHF +h1s F0RUm, 1t is imp0\$s1Bl3 for us to rev1ew @ll M3Ss4935. all m3sS4gEs expr355 the V13ws 0f +he @U+h0r, @nd ne1+her +H3 owners opH %1\$\$, n0R prOj3C+ 8e3h1v3 Forum 4nd i+'\$ 4pHF1l14+eS w1ll 83 HelD r35POns18le phor t3h con+ent OPh 4ny me5s4g3.</p><p>\n8Y 4GR331ng +o THese rules, j00 W@Rr@nT +hat J00 will not PO\$+ 4ny m3s\$49es TH4t 4R3 0B\$Cen3, VUl9ar, \$Exu4llY-oRIEntAt3d, hATephul, thr3atenin9, or o+herw15e V10L4Tive OPh 4ny l4wS.</p><p>t3H 0wn3Rs 0ph %1\$5 R3s3rve th3 rI9ht to Remov3, ed1t, m0v3 0r CLoSE 4nY thr3ad phor 4Ny re4S0n.</p>";
$lang['cancellinktext'] = "hEre";
$lang['failedtoupdateforumsettings'] = "f41LED +0 UPD4+e f0RuM sET+1nG\$. PLE4sE tRy a9@in L@+3r.";
$lang['moreadminoptions'] = "moR3 @Dmin Op+i0N\$";

// Admin Log data (admin_viewlog.php) --------------------------------------------

$lang['changedstatusforuser'] = "cH4ngeD us3r stA+us foR '%s'";
$lang['changedpasswordforuser'] = "cH4n93d P4\$SW0RD f0R '%s'";
$lang['changedforumaccess'] = "cH@N9ed Ph0RUm 4Cc3s5 PErm15\$10Ns f0R '%s'";
$lang['deletedallusersposts'] = "deL3T3d @lL p0\$+s f0r '%s'";

$lang['createdusergroup'] = "cR34+3d u\$ER gRoUp '%s'";
$lang['deletedusergroup'] = "deLetED u\$ER gr0UP '%s'";
$lang['updatedusergroup'] = "uPd4+3D usEr 9R0Up '%s'";
$lang['addedusertogroup'] = "addeD u5ER '%s' +o 9R0uP '%s'";
$lang['removeduserfromgroup'] = "r3moV3 u\$Er '%s' phr0M grouP '%s'";

$lang['addedipaddresstobanlist'] = "aDdeD Ip '%s' +0 Ban L1\$+";
$lang['removedipaddressfrombanlist'] = "r3m0v3D 1P '%s' from B4N l1St";

$lang['addedlogontobanlist'] = "addeD lo9on '%s' +0 b4n l1\$t";
$lang['removedlogonfrombanlist'] = "rEM0V3D log0N '%s' phrom baN L1\$+";

$lang['addednicknametobanlist'] = "adD3d n1CKn@M3 '%s' +o 8@n lI\$+";
$lang['removednicknamefrombanlist'] = "r3mOV3D NICKn@m3 '%s' Phr0m B4N li\$+";

$lang['addedemailtobanlist'] = "adDED 3m@Il @DDRess '%s' +o 8@N Li\$t";
$lang['removedemailfrombanlist'] = "r3M0V3D Em@1l @dDrEss '%s' froM 8@n l1\$+";

$lang['addedreferertobanlist'] = "add3D refEr3r '%s' +O b4n L1\$T";
$lang['removedrefererfrombanlist'] = "reM0v3D rEpheR3R '%s' phrom 84n l1st";

$lang['editedfolder'] = "ed1t3d Ph0LDEr '%s'";
$lang['movedallthreadsfromto'] = "mOv3D @ll thRE4D\$ phrom '%s' +0 '%s'";
$lang['creatednewfolder'] = "cRE4+3d nEw f0lD3r '%s'";
$lang['deletedfolder'] = "d3L3t3D f0lDEr '%s'";

$lang['changedprofilesectiontitle'] = "cH4NGED Pr0ph1L3 sEC+10n +1+l3 Fr0M '%s' to '%s'";
$lang['addednewprofilesection'] = "add3d nEw prOPHIL3 \$ec+i0N '%s'";
$lang['deletedprofilesection'] = "d3l3+ed pr0fil3 SEct10n '%s'";

$lang['addednewprofileitem'] = "aDd3d neW pr0PH1L3 1+3M '%s' to sEctioN '%s'";
$lang['changedprofileitem'] = "chAn9ed pr0phil3 1+3m '%s'";
$lang['deletedprofileitem'] = "deL3t3D pR0phIl3 i+3m '%s'";

$lang['editedstartpage'] = "edI+ed S+@r+ pA93";
$lang['savednewstyle'] = "s4VED n3W \$+YL3 '%s'";

$lang['movedthread'] = "m0V3D +hre4D '%s' Fr0M '%s' TO '%s'";
$lang['closedthread'] = "cL0SED +HrE4d '%s'";
$lang['openedthread'] = "op3n3D tHr3AD '%s'";
$lang['renamedthread'] = "reN@m3D +hRE4d '%s' +O '%s'";

$lang['deletedthread'] = "d3l3+ED +hRE4d '%s'";
$lang['undeletedthread'] = "unDEL3t3d +hr34d '%s'";

$lang['lockedthreadtitlefolder'] = "l0ck3D thrEaD op+i0N\$ On '%s'";
$lang['unlockedthreadtitlefolder'] = "unlOCKEd +hrE4d 0Pt10n\$ 0n '%s'";

$lang['deletedpostsfrominthread'] = "deL3+3D p0Sts Fr0m '%s' IN +HrE4d '%s'";
$lang['deletedattachmentfrompost'] = "dEl3+3D @tt4chmeNT '%s' Fr0m P0s+ '%s'";

$lang['editedforumlinks'] = "ed1+3D fOrum l1NKS";
$lang['editedforumlink'] = "eDi+ed pHorUm lINk: '%s'";

$lang['addedforumlink'] = "aDd3D F0rUm l1nk: '%s'";
$lang['deletedforumlink'] = "dEl3tED phoruM l1nK: '%s'";
$lang['changedtoplinkcaption'] = "ch@n9ed +0P liNk C4ption fr0M '%s' +o '%s'";

$lang['deletedpost'] = "dELETED P0s+ '%s'";
$lang['editedpost'] = "eDit3D p0S+ '%s'";

$lang['madethreadsticky'] = "maDE tHRe4D '%s' 5+1CKy";
$lang['madethreadnonsticky'] = "m4d3 +HREaD '%s' noN-5+1Cky";

$lang['endedsessionforuser'] = "eNd3d sESsion for u\$Er '%s'";

$lang['approvedpost'] = "apPrOVeD po5T '%s'";

$lang['editedwordfilter'] = "edITeD w0rD fILTEr";

$lang['addedrssfeed'] = "add3d r\$S phE3D '%s'";
$lang['editedrssfeed'] = "ed1+eD rs5 ph3ed '%s'";
$lang['deletedrssfeed'] = "dEl3+3D r\$\$ Phe3d '%s'";

$lang['updatedban'] = "uPd@t3D B4n '%s'. CH4nG3D +Yp3 froM '%s' +0 '%s', cHangeD DAt4 PHr0M '%s' t0 '%s'.";

$lang['splitthreadatpostintonewthread'] = "sPl1+ +HrE4D '%s' 4+ pos+ %s  1nT0 n3W +HrE4D '%s'";
$lang['mergedthreadintonewthread'] = "meRged thR34ds '%s' 4nD '%s' iNt0 New Thr34D '%s'";

$lang['approveduser'] = "aPproved U53R '%s'";

$lang['forumautoupdatestats'] = "f0Rum 4UTo uPD4Te: \$Tats Upd4T3d";
$lang['forumautoprunepm'] = "fORUM 4UT0 upd@Te: Pm phoLD3Rs PrUNED";
$lang['forumautoprunesessions'] = "f0rum @Uto UpD@+3: sEs5ioN5 prUn3d";
$lang['forumautocleanthreadunread'] = "f0ruM 4u+0 uPD4+3: +hr3@D UnR34d d4+4 Cl3ANED";
$lang['forumautocleancaptcha'] = "f0rum @u+0 UpD4+E: TExt-c4PTch4 im49ES cL3@N3d";

$lang['adminlogempty'] = "aDmin L09 i5 3mp+y";

$lang['youmustspecifyanactiontypetoremove'] = "j00 mu5+ sp3CIFy An 4C+1ON +yPE t0 r3m0V3";

$lang['removeentriesrelatingtoaction'] = "reM0V3 3ntr1E\$ R3L4+in9 +o @CTioN";
$lang['removeentriesolderthandays'] = "rEm0v3 entr13s 0LDEr +h4N (D4Y\$)";

$lang['successfullyprunedadminlog'] = "sUCCes\$phUlly PrUnED 4Dm1N l09";
$lang['failedtopruneadminlog'] = "f@Il3d +0 prun3 4DMin lO9";

$lang['prune_log'] = "prUNe l0g";

// Admin Forms (admin_forums.php) ------------------------------------------------

$lang['noexistingforums'] = "nO eX1st1ng F0rUms phounD. +0 CrEAtE 4 nEw F0RUm Cl1cK +H3 '4DD n3W' 8U++on 83low.";
$lang['webtaginvalidchars'] = "wEB+49 C@N only Cont@1N Upp3Rc4\$e @-z, 0-9 4nD UndEr\$Cor3 Ch4R4c+Ers";
$lang['databasenameinvalidchars'] = "d4+48aSE n4M3 CAn 0Nly CON+41n @-z, 4-z, 0-9 @nD UnDER5cor3 CH4RaC+3Rs";
$lang['invalidforumidorforumnotfound'] = "inV4l1D ph0rUM f1d OR f0Rum no+ f0Und";
$lang['successfullyupdatedforum'] = "succ3S5FULly UPD4TED ForUM";
$lang['failedtoupdateforum'] = "f4Il3d +0 upD@t3 f0rUm: '%s'";
$lang['successfullycreatednewforum'] = "succ3sspHUllY crEa+ED n3w F0rUm";
$lang['selectedwebtagisalreadyinuse'] = "t3h \$elec+3d We8+@g Is 4lRE4Dy 1n use. pL34se Ch0o53 aNoth3R.";
$lang['selecteddatabasecontainsconflictingtables'] = "th3 seleCt3d D4TA84se Con+4INs COnphl1C+iNg +@8LEs. C0nphliCtiNg t4BLE N4mEs 4r3:";
$lang['forumdeleteconfirmation'] = "are j00 Sur3 J00 W4n+ +0 DELEtE @ll 0F +3H 53L3c+ed f0RUms?";
$lang['forumdeletewarning'] = "pL34se N0+3 thaT j00 C4nno+ r3c0V3R DElE+ED ph0RUm\$. onCe DEL3TED @ ph0RUM @nD @lL 0Ph i+'s a5\$0ciatED D4ta IS permAnEntlY r3m0v3D phRom th3 D@+@84\$3. 1F j00 d0 no+ wish +0 D3let3 +Eh s3LeC+eD phorums pLe4sE Cl1Ck C@ncel.";
$lang['successfullyremovedselectedforums'] = "sUcCE\$SpHUlly D3letED \$3l3ctED phorums";
$lang['failedtodeleteforum'] = "fail3D t0 D3Le+3D foRUm: '%s'";
$lang['addforum'] = "add f0ruM";
$lang['editforum'] = "edI+ forum";
$lang['visitforum'] = "vi\$I+ phOrUm: %s";
$lang['accesslevel'] = "acc3Ss L3vEL";
$lang['forumleader'] = "foRUM l3@DEr";
$lang['usedatabase'] = "u53 D4T48a53";
$lang['unknownmessagecount'] = "unkn0wN";
$lang['forumwebtag'] = "f0Rum w38t49";
$lang['defaultforum'] = "d3pH4ult ForUm";
$lang['forumdatabasewarning'] = "pLe4SE eNsure j00 sEl3C+ +HE COrR3C+ D@+4b4sE wh3N CRE4+ing @ N3W pHorum. onC3 cre4+3D 4 n3W f0RuM C4nn0T 83 M0VEd 83TweEn 4VaIl4blE D@T4BaSEs.";

// Admin Global User Permissions

$lang['globaluserpermissions'] = "gl0B@l u\$er permIssion5";

// Admin Forum Settings (admin_forum_settings.php) -------------------------------

$lang['mustsupplyforumwebtag'] = "j00 mu5+ supply 4 f0rum wE8T49";
$lang['mustsupplyforumname'] = "j00 Mus+ 5upPLY 4 forum n@mE";
$lang['mustsupplyforumemail'] = "j00 Mus+ 5UpplY 4 PhorUm 3m@Il @dDr3S\$";
$lang['mustchoosedefaultstyle'] = "j00 mu\$+ ch00se a D3ph@ul+ f0rUm \$tyl3";
$lang['mustchoosedefaultemoticons'] = "j00 mu5+ Choose D3faUL+ ph0rum 3mo+IcOn\$";
$lang['mustsupplyforumaccesslevel'] = "j00 mu5T 5UPply 4 ph0Rum @cC3\$s levEl";
$lang['mustsupplyforumdatabasename'] = "j00 Mus+ sUPpLy 4 PHorum D4+4B4\$e n4mE";
$lang['unknownemoticonsname'] = "unkn0wn 3Mo+iC0N\$ n4m3";
$lang['mustchoosedefaultlang'] = "j00 muS+ Choos3 a DEF4Ult ForUm l@nGUa9E";
$lang['activesessiongreaterthansession'] = "aC+IVE sE\$S1oN +ImE0UT C@Nn0+ bE GR34+eR than s3ss10N t1mE0U+";
$lang['attachmentdirnotwritable'] = "at+4CHment D1RECToRy @nD sy5tem +emp0R4ry diR3CT0rY / php.1Ni 'Uplo@D_tmp_Dir' mu\$T B3 wr1ta8lE 8Y +EH w38 s3Rv3R / php pR0C3s5!";
$lang['attachmentdirblank'] = "j00 mu\$t SUpply 4 Dir3c+ory t0 \$4v3 a++@CHmEn+s iN";
$lang['mainsettings'] = "main sE+t1ngs";
$lang['forumname'] = "f0RUm n@m3";
$lang['forumemail'] = "f0Rum 3m4il";
$lang['forumnoreplyemail'] = "nO-r3ply EmA1l";
$lang['forumdesc'] = "f0Rum d3SCr1p+I0n";
$lang['forumkeywords'] = "fOrum k3Yword5";
$lang['defaultstyle'] = "defauLT s+yLe";
$lang['defaultemoticons'] = "d3f@ult Em0TiC0N\$";
$lang['defaultlanguage'] = "dEfault L4nguA9e";
$lang['forumaccesssettings'] = "foRum 4CC3Ss 5e+t1nGs";
$lang['forumaccessstatus'] = "fOrum 4Cc3sS 5+4+us";
$lang['changepermissions'] = "cH4nge p3Rm1\$SI0ns";
$lang['changepassword'] = "ch4ngE P4s\$w0rD";
$lang['passwordprotected'] = "p45\$WorD pr0t3ct3D";
$lang['passwordprotectwarning'] = "j00 hAVE no+ 53T 4 phoruM p4SswoRD. if j00 d0 NO+ \$3t 4 P4\$sw0RD ThE p@\$\$WorD proTEC+i0N FuncT1ON4lity wIlL B3 4uTom@t1c4lly D1\$4Bl3D!";
$lang['postoptions'] = "pos+ 0p+10Ns";
$lang['allowpostoptions'] = "alL0w p0st EDi+1N9";
$lang['postedittimeout'] = "pO\$+ ED1T tIM30ut";
$lang['posteditgraceperiod'] = "po\$+ eDit gr@C3 pEr1oD";
$lang['wikiintegration'] = "w1Kiw1k1 inte9R4TIon";
$lang['enablewikiintegration'] = "en48le wik1w1k1 1NTE9r@+i0N";
$lang['enablewikiquicklinks'] = "eN48L3 WiKiwiki qU1CK liNks";
$lang['wikiintegrationuri'] = "wIkiw1ki Loc4+I0n";
$lang['maximumpostlength'] = "mAXImuM pOs+ L3N9Th";
$lang['postfrequency'] = "pO5+ fR3qU3NCy";
$lang['enablelinkssection'] = "eN48l3 L1nks \$eCt10n";
$lang['allowcreationofpolls'] = "alLOw cr34+i0N oph p0LLs";
$lang['allowguestvotesinpolls'] = "aLlow gu35+\$ t0 vO+E 1n POll\$";
$lang['unreadmessagescutoff'] = "uNREaD m3\$\$a93S cUt-oFph";
$lang['unreadcutoffseconds'] = "s3CONDs";
$lang['disableunreadmessages'] = "d1\$@8lE unR3@D ME\$s49Es";
$lang['thirtynumberdays'] = "30 D4y\$";
$lang['sixtynumberdays'] = "60 D4Ys";
$lang['ninetynumberdays'] = "90 D4y\$";
$lang['hundredeightynumberdays'] = "180 d4Ys";
$lang['onenumberyear'] = "1 ye4r";
$lang['unreadcutoffchangewarning'] = "d3PenD1Ng 0n server P3RphoRm@nCE 4Nd tEH nUmBEr 0f +Hr3aDS your Ph0Rum\$ C0n+41n, Ch4N91ng th3 uNr3@d CU+-0FpH may tak3 \$3vEr4L m1nU+3s +O COmplETE. F0r +hIs reas0N 1+ is r3ComM3NDED +h4t j00 aVo1D Ch@ng1n9 tH1\$ s3t+ing wHiLE y0Ur PhoRums 4re 8Usy.";
$lang['unreadcutoffincreasewarning'] = "incR3a5IN9 +3h Unr34d CU+-oPhF wIlL resUL+ 1N thRE4Ds 0LDER Th@N +3H CURR3NT CUT-0phph @PpE@r1n9 4S UnRE4D pHoR 4ll users.";
$lang['confirmunreadcutoff'] = "aRe j00 \$urE j00 w@n+ +0 cH@NgE +HE uNRE4d CUT-ophPh?";
$lang['otherchangeswillstillbeapplied'] = "clICK1ng 'N0' wILL oNly CaNCEl tH3 unR34D cU+-opHF Ch4NG3\$. o+h3R CH@N9E5 y0U've mADE w1ll \$+1LL 83 \$4V3D.";
$lang['searchoptions'] = "s3ArCH opt10NS";
$lang['searchfrequency'] = "s3ARCh fr3QueNcy";
$lang['sessions'] = "s3\$S10n\$";
$lang['sessioncutoffseconds'] = "seSs10n cU+ 0FPh (sEC0NDs)";
$lang['activesessioncutoffseconds'] = "aC+IvE s3ss10n cU+ oPhpH (sECONDs)";
$lang['stats'] = "s+@+S";
$lang['hide_stats'] = "h1DE st4+S";
$lang['show_stats'] = "sh0w 5+@Ts";
$lang['enablestatsdisplay'] = "eN48Le sT4T\$ DisPl4y";
$lang['personalmessages'] = "p3Rs0n4l MEs5@gEs";
$lang['enablepersonalmessages'] = "eNaBle p3Rs0Nal m3\$S@g3S";
$lang['pmusermessages'] = "pM m35549Es p3R u53r";
$lang['allowpmstohaveattachments'] = "alL0w P3rs0n4l m3\$SAgEs +0 h4V3 a+t4CHm3NTS";
$lang['autopruneuserspmfoldersevery'] = "auTO prune U\$er'5 Pm f0LD3r\$ EVEry";
$lang['userandguestoptions'] = "u\$3r AND gu3ST 0P+i0n5";
$lang['enableguestaccount'] = "en@8L3 9u3\$+ 4cCount";
$lang['listguestsinvisitorlog'] = "l1\$T gU3s+\$ in vi\$1+or l09";
$lang['allowguestaccess'] = "aLlow 9u3st 4CC3Ss";
$lang['userandguestaccesssettings'] = "u\$3R @nD gU3s+ 4cCEss s3T+ings";
$lang['allowuserstochangeusername'] = "aLl0w UsErs +0 Ch@nG3 u\$ernamE";
$lang['requireuserapproval'] = "r3QUir3 USER @pprOv4L 8Y 4Dmin";
$lang['requireforumrulesagreement'] = "r3Quir3 User T0 49Re3 +0 forum rul3s";
$lang['enableattachments'] = "eN@8LE 4+t4Chment5";
$lang['attachmentdir'] = "aT+4chM3Nt Dir";
$lang['userattachmentspace'] = "at+ACHm3nt SP4cE pER U53R";
$lang['allowembeddingofattachments'] = "alL0w embedDIng 0ph 4+T4chmenT\$";
$lang['usealtattachmentmethod'] = "use al+eRn@+iv3 a+t4CHmEnT MEthoD";
$lang['allowgueststoaccessattachments'] = "aLLOw gUestS TO 4CC3\$s @++4CHments";
$lang['forumsettingsupdated'] = "f0rUm \$et+1ng\$ \$UCce5\$FULly UpDATED";
$lang['forumstatusmessages'] = "f0RUm \$+atus m3S\$A93s";
$lang['forumclosedmessage'] = "f0Rum Closed m3Ss4g3";
$lang['forumrestrictedmessage'] = "f0rum REs+rict3D m3ssA93";
$lang['forumpasswordprotectedmessage'] = "f0Rum P@\$sw0RD pro+ECT3d m3S\$@ge";

// Admin Forum Settings Help Text (admin_forum_settings.php) ------------------------------

$lang['forum_settings_help_10'] = "<b>p0s+ 3D1+ T1M30uT</b> IS +he tiME in m1NUt3s @PH+Er Po\$+in9 Th@+ @ u5er cAn ED1+ +he1r p0s+. iPh sEt +0 0 ther3 1\$ n0 l1mi+.";
$lang['forum_settings_help_11'] = "<b>m4x1mum pos+ len9Th</b> Is +HE m@x1MUm num8Er opH Ch@r@ctErs +h4+ WilL 83 Di\$Pl4y3D in 4 P0\$T. 1F 4 p0\$T is long3R +h4N +h3 NUMbEr oph CH4R4C+ERs DEphIn3D hER3 it W1Ll 8E CUt sh0R+ @nd @ L1Nk 4DDEd +0 teH Bottom +0 4ll0w U\$3rs t0 re4d Th3 wh0L3 p0s+ on @ S3PAr4+e p@g3.";
$lang['forum_settings_help_12'] = "iph J00 D0n'+ w@nt Your UsERs +0 BE 4ble +0 CR34tE p0LL\$ j00 c4N D15@8lE +He 4b0V3 0pt10N.";
$lang['forum_settings_help_13'] = "tHE links SEcT10n oph beEH1vE Pr0V1D3s @ PL4c3 FOR youR UsErs +0 MAintA1N @ l1\$+ of \$I+ES +HEy Fr3QUENtLy V1si+ +h4t OTHEr U\$er5 m4Y ph1ND usEfUl. l1Nks C4n BE DIvid3D in+0 c4teg0R1e\$ 8Y PholDEr 4nD 4Ll0w PHor comM3nTs @nD r4Tings To bE GiV3N. iN orD3R to Mod3rate teh links S3C+ion 4 us3r mu\$T 83 R@nt3d glob@L MOD3r4+0r ST4+u\$.";
$lang['forum_settings_help_15'] = "<b>sES510n Cut 0pHf</b> 1\$ +he M4xiMUm t1m3 83f0R3 4 user'5 53Ss1On 1s D3emeD DE4d 4ND ThEY @r3 LO9ged 0U+. BY DEPh@Ul+ ThI\$ i\$ 24 Hours (86400 \$3CoNDs).";
$lang['forum_settings_help_16'] = "<b>acT1V3 \$E\$s1oN CUt OfF</b> 1S t3H maxiMUM T1M3 8ePH0R3 4 useR's s3\$Si0N 15 deEm3D in4c+1ve 4+ wHiCH po1N+ +HEY ENtEr 4n 1dle \$t4+3. iN +Hi\$ S+@te +3H Us3R R3m4In\$ lo993d 1N, bU+ +h3Y @r3 R3m0vED fr0M +3h 4CT1VE u53r\$ l1st 1n +h3 st4+\$ di\$Pl@Y. 0nce tHEY 8eComE 4C+1V3 A941N +h3Y will b3 r3-ADDED +0 +3H l1\$T. 8Y D3Ph@ult th1s s3++1ng is SEt +o 15 minU+3s (900 53c0nD\$).";
$lang['forum_settings_help_17'] = "enAbl1Ng +his opt1on 4ll0W\$ B33h1vE +0 iNcluD3 4 stats dIspL4y @T +Eh bO++0m of teh M3ss493s p@nE siM1lar to +h3 0N3 used 8y m4ny F0RuM \$0f+WaRe +itLE\$. 0nCe 3N@8l3D The Di\$PL@y oPh +3H st4ts pa9e c4n 83 to9Gl3D inD1VIdUalLy 8y 3@Ch U53r. ipH +h3Y d0n'+ w@n+ T0 seE 1+ +Hey c4n hide it fr0m view.";
$lang['forum_settings_help_18'] = "pEr\$0n@l m3Ss49eS @r3 Inv4lU@8Le @\$ 4 w4y 0Ph t4king m0RE pr1v@te m4++eRs out 0Ph v13w 0PH th3 0th3R m3M83rs. H0w3Ver If J00 DOn'+ w@N+ Y0ur USer5 +0 be 4BLE t0 S3nd e4Ch 0+h3R p3R\$0n@l mess4g3s J00 C4n D1\$4Bl3 Thi\$ 0pti0n.";
$lang['forum_settings_help_19'] = "p3rS0n4l ME\$S4g3s C4n 4l\$0 C0n+@IN 4++@CHmEn+s whiCH C@n 8E u\$3ful phor ExCH4N9ing f1LE5 B3+wEEn usER5.";
$lang['forum_settings_help_20'] = "<b>n0TE:</b> Th3 \$P@CE @ll0c@+i0N Ph0r PM 4+t@CHmEn+s i\$ +@K3n phr0M e4ch U53rs' m4in 4++4CHmENt 4Ll0ca+10n 4ND IS No+ in @DDiT10n T0.";
$lang['forum_settings_help_21'] = "<b>en4Bl3 GU3s+ aCC0uNt</b> @ll0W\$ vis1+Or\$ TO BR0W\$3 y0ur forUM 4ND re4d pOs+\$ Wi+h0UT reGis+3R1NG 4 u53r @CCOuNt. @ User acCoUnt is \$T1ll reqU1r3d 1Ph THey wi\$H to p0S+ or cH@n9E u\$3r prEfEr3NC3S.";
$lang['forum_settings_help_22'] = "<b>list gu3sts In vis1+0r Log</b> 4LL0w\$ j00 +0 SpEciPhy whEtH3r 0R nO+ Unre9I\$+3reD Us3R\$ ar3 lis+eD On t3H Vi\$1+or l09 4l0N9 \$IDE rE9i\$+3reD UsERs.";
$lang['forum_settings_help_23'] = "beEhiv3 4ll0W\$ 4+t4CHM3nT5 +0 8E UPl0AdED +0 m3\$S493\$ wH3N po\$t3D. iF J00 H@ve LImitED we8 \$P4c3 J00 may Wh1CH +O D1\$4bL3 4++4ChM3Nt\$ 8Y ClE@R1NG +HE 80X 48Ov3.";
$lang['forum_settings_help_24'] = "<b>a++@chmEn+ DIr</b> is tHE loc4+I0n bEEhiV3 sh0UlD storE i+'5 At+@CHmen+S in. th1\$ DirEC+0ry mus+ 3x1S+ 0n Y0Ur wEB Sp@cE AnD must 83 wri+4BL3 By +Eh w3b serv3R / pHp pR0C3SS otH3RwI5E UpLo4D\$ wiLl f4Il.";
$lang['forum_settings_help_25'] = "<b>a++4chmenT sp4CE pEr useR</b> 1\$ +3h M@x1mUm @m0un+ 0Ph D1\$k \$P4C3 a useR h4s F0r 4t+@ChM3N+S. onCE +h1\$ 5p@cE i\$ U53d UP +HE U\$3r c4NNo+ uplO@D Any m0Re 4T+@ChmeN+s. 8y DEPh4Ul+ +His 1s 1M8 0f sp@CE.";
$lang['forum_settings_help_26'] = "<b>aLlow 3mb3dDINg oF @t+4chMEnTs 1N m3s5@gE5 / S1gn4+UREs</b> 4llow5 us3r\$ T0 eM8ED @tt4cHmENts iN pO\$+S. 3N4BLiN9 +hi\$ 0p+10n Wh1l3 U53phUL C4n inCREaSE Your b4nDWiD+h Us49e DR@\$t1C4lly UND3r CEr+a1n c0nPHIgUr4+i0N\$ 0f Php. 1F j00 h4V3 limi+ED 8AnDw1D+h 1+ 15 REC0mmEnDED th4+ j00 D1S4Bl3 +h1\$ OP+10n.";
$lang['forum_settings_help_27'] = "<b>usE 4lt3RN4+Ive 4t+acHm3N+ m3+HOD</b> PH0rC3S 83Eh1V3 T0 uS3 an 4LT3rn@T1V3 R3Tr13v4l METHod phor 4tTaCHm3N+s. iph j00 r3c31v3 404 3rr0R M3s\$@GES Wh3n +RYiN9 T0 d0wNlO4D @TTaCHM3N+s phr0M mess4GE5 +ry EnaBLIng +h1\$ 0pT10N.";
$lang['forum_settings_help_28'] = "thiS \$ET+1ng 4Llow5 Y0ur PH0rum to 83 Sp1d3R3D 8Y 534RCH 3n91n3s l1kE go09l3, alt4V1S+4 aND y@h00. 1F j00 swi+Ch th1S opt10N 0Fph your ph0RuM wilL n0t be iNCLuDeD 1N th3Se s34rch 3n91N3S r3sults.";
$lang['forum_settings_help_29'] = "<b>alL0w nEW us3r REg1\$+r4+10n\$</b> 4Llows or DI5AllOw\$ +hE CRE4T10N 0f n3W us3r @ccOun+\$. \$3tt1N9 thE oPTion tO No COmplEtELy D1S4BLEs +h3 r391s+R@+1oN F0rm.";
$lang['forum_settings_help_30'] = "<b>en@8l3 WIk1w1K1 iNTEgr@+i0N</b> PRoviDEs wikIw0RD sUPp0R+ in Your PHoRum po5+s. 4 wIkiw0RD 1S M4DE Up 0Ph tWo oR M0RE C0nC4t3na+ED w0rd\$ wi+H UppErcasE lEttEr\$ (oF+en R3FErrED To As c4m3LC@se). If J00 wr1+3 4 w0RD th1S W@y 1+ Will 4u+OM4t1C4lly BE Ch4ng3D 1n+O a hyp3Rl1nk po1nt1n9 +0 Y0Ur cho\$EN w1k1wik1.";
$lang['forum_settings_help_31'] = "<b>en4Ble wIK1wiki qU1ck l1Nk\$</b> En48les tEh Use 0pH m\$g:1.1 anD U\$3r:log0N styl3 3x+3NDED WikIlInk\$ Which Cr34+e hYperlinKs +0 t3h sP3CiPhi3d mE\$S4g3 / Us3r pRof1L3 of tEh sp3CIFIeD Us3r.";
$lang['forum_settings_help_32'] = "<b>wIKiwIk1 loC4+1ON</b> 1s u53d +0 spEC1Fy +h3 uri 0PH y0UR wik1w1K1. WHEn En+ERiNg +3h ur1 UsE <i>%1\$\$</i> to 1nD1catE whEr3 1n t3h UR1 +he wIkiW0RD \$hOULd @PPE4R, i.3.: <i>h+Tp://en.wikIp3D14.OR9/wIk1/%1\$\$</i> W0uld l1Nk YoUr W1K1W0rds +o %s";
$lang['forum_settings_help_33'] = "<b>f0ruM aCCess sT4+Us</b> Contr0L\$ How UsEr\$ M4y @cC3s\$ yoUr phoRuM.";
$lang['forum_settings_help_34'] = "<b>op3n</b> W1Ll @llOw @ll UsErs @nd 9u3Sts 4CC3Ss +0 Y0Ur PhorUm w1+h0u+ R3s+RiC+10n.";
$lang['forum_settings_help_35'] = "<b>cloSED</b> Pr3V3NtS 4cC3Ss f0r 4ll USers, W1th +eh 3xcEp+1on 0F teh 4DMin WH0 m4y STill aCC3s5 T3H 4DmIn p@N3L.";
$lang['forum_settings_help_36'] = "<b>r3s+riCTED</b> @ll0w\$ t0 seT 4 list 0pH U\$er\$ wh0 ar3 @llOw3D 4CCeS\$ +0 Y0UR phOrUm.";
$lang['forum_settings_help_37'] = "<b>p@Ssw0rD pRotECtED</b> 4llows j00 tO sEt 4 p45\$w0RD +0 9ive 0u+ +0 UsEr5 50 theY C4N ACCESs y0ur forUM.";
$lang['forum_settings_help_38'] = "wHeN setT1N9 restr1C+ED 0r p4ssw0rd prOtEC+ED moDE j00 w1Ll nE3D +0 s@vE yoUr Ch4nG3s 83F0re J00 c4N Ch4NGE +3H Us3R 4CCEss pRiv1LE93s 0r p4sSworD.";
$lang['forum_settings_help_39'] = "<b>Search Frequency</b> defines how long a user must wait before performing another search. Searches place a high demand on the database so it is recommended that you set this to at least 30 seconds to prevent \"search spamming\"fR0m k1Ll1NG +HE \$ErV3R.";
$lang['forum_settings_help_40'] = "<b>p0St phrEquENCy</b> 1S +h3 MinimUm +Ime @ usEr must W4i+ B3F0RE th3Y CAn p0S+ a9@1n. th1s se++1Ng @lso aPhph3C+s th3 CRe4+I0n oPH p0llS. se+ t0 0 t0 Di\$4bl3 Th3 R3str1CT1on.";
$lang['forum_settings_help_41'] = "t3h 4Bove 0P+i0n5 Ch4nge +3h deF4Ul+ v4LU3s PHor The user R3g1stR@+I0n F0RM. wH3r3 4ppl1CA8le Oth3R sEt+iNg\$ W1LL u\$3 +HE PHOrUM's 0Wn d3F4Ul+ Se++1n9S.";
$lang['forum_settings_help_42'] = "<b>pr3VEnt Us3 0ph DUpLiC4+3 em4Il 4DDr3\$S3\$</b> Forc3s 83Eh1Ve +0 Ch3CK +3H usER @cC0un+s @9@1Ns+ thE Em41L 4ddR35s +eh usER 1s rEgIs+ErING Wi+h @nD Promp+\$ them +0 u\$E 4noth3R iF It is alr34Dy in Us3.";
$lang['forum_settings_help_43'] = "<b>reQUirE em4IL coNfiRM@+1on</b> When 3N4blED W1LL \$end @n 3m4il T0 e@CH NEw u\$3r wI+H @ linK +h4T C4N B3 UsED +O c0NPHIrm +HEIR Em41l 4Ddre5\$. un+il th3y c0NFIrm +H31r em4il @DDr3sS +hEy w1ll N0+ 8e @8LE +0 p0S+ uNle\$S +HEiR Us3R pErm15\$10nS 4r3 Chan9ED m4nU4LLy by 4N @Dm1N.";
$lang['forum_settings_help_44'] = "<b>use +Ex+-c4PTCh4</b> PrEsEn+\$ +eH N3w U\$3r Wi+H @ m4n9l3D iM493 wh1ch tHEy musT COPy a nUm8er pHr0M 1n+0 a TExt ph1elD 0n the r39is+r4ti0N fOrm. use This 0pt10n +0 PrEV3Nt 4U+OmAt3D s1gN-Up V1A sCr1p+\$.";
$lang['forum_settings_help_45'] = "<b>tEXT-c@ptCHA DIr3C+OrY</b> \$P3c1PhiE5 +h3 l0C4+i0n TH@+ B3EH1v3 will \$tor3 1+'s +3XT-C@ptCH4 1m@93s @nD ph0nTS In. +Hi5 d1R3ct0ry mus+ 8e wR1+a8L3 by +hE w3B \$eRV3r / phP Pr0CE5\$ @nD must 83 @CC3Ss1blE vi4 http. @FtEr J00 h4v3 En48l3d +ex+-CAp+CH@ j00 Must upl0@d 50M3 tru3 typ3 f0ntS into teh fon+S \$U8-d1r3c+0Ry 0PH y0ur m41n tEX+-C4P+Ch4 dIr3c+0ry 0tHErw1SE 8eEh1ve will SKip the TEX+-c4pTch4 durinG user rE91\$TR4+I0N.";
$lang['forum_settings_help_46'] = "<b>Text Captcha key</b> allows you to change the key used by Beehive for generating the text captcha code that appears in the image. The more unique you make the key the harder it will be for automated processes to \"guess\"tH3 c0D3.";
$lang['forum_settings_help_47'] = "<b>p0St edit gr4C3 p3R10d</b> @ll0W\$ J00 +0 DEF1N3 4 perioD 1N miNU+Es whEr3 U\$3r\$ m4y EDI+ pO5+s w1+h0Ut thE '3DI+ED bY' t3XT 4Pp34rinG 0N tHE1R p0st5. ipH SET +0 0 +H3 '3D1+3D 8Y' TeXt w1ll @lw4y\$ @PpE4R.";
$lang['forum_settings_help_48'] = "<b>uNR34D mEs5493\$ CU+-ophf</b> 5peCiF13s h0w L0n9 m3s\$@ge5 r3M4In UNre4d. THre4Ds mODIphI3D no l@+3r +h4N th3 p3Ri0D sel3c+3D WilL 4Ut0M4t1cAlly 4ppeaR @\$ re4d.";
$lang['forum_settings_help_49'] = "cHo0s1n9 <b>diS4BLe UnrE4D m3SS4g3\$</b> w1ll COmPleTely r3M0v3 Unr34d mess4G3s 5Upp0rt 4ND rEm0V3 +eh r3leV@nt 0pt10ns phR0m +H3 DI\$cus\$1on +yp3 Dr0P D0wn on t3h +hrE4D liS+.";
$lang['forum_settings_help_50'] = "<b>rEqu1rE usER ApPrOvaL 8y @dmIn</b> ALlow\$ j00 +o R3StrIC+ aCC3SS 8Y nEw UsER5 unT1L thEy H@v3 8een 4PpRov3D BY @ MoD3r4tor or aDM1N. w1+H0u+ @ppR0VAl a u53r C4Nn0t 4Cc3ss 4nY 4R34 opH the B3eh1vE F0RUm 1Nst@lL4TioN iNCLUdin9 1NdiviDU4L phoRUMs, pm in8oX 4nd my ph0rumS 53ct10n\$.";
$lang['forum_settings_help_51'] = "uS3 <b>cLosED M3sS4g3</b>, <b>r3STRic+3d M3ss49E</b> @nD <b>p4ssWORd pR0T3c+3D M3SSag3</b> +0 cus+oMis3 +Eh M3ss493 D1SPl4YED wHeN user\$ 4CCEss yoUr pH0Rum 1N +3H v4r10Us \$+4+35.";
$lang['forum_settings_help_52'] = "j00 CAn u\$e H+ml iN Y0Ur m3ss493\$. hyp3rlinKs 4nd 3M@il 4DDREssE\$ will 4l\$0 8e 4UtoM@+iC4LLY CoNv3R+ED +o l1nks. +O UsE +he DEpH4ULt B3eHiV3 F0ruM Me\$S49ES ClE@R +EH F13lDs.";
$lang['forum_settings_help_53'] = "<b>alLow Us3rs t0 ch4N93 Us3Rn4M3</b> pErmI+s 4Lr34dy rE91\$+3rED user\$ +o ch4N93 +H31r u\$3rn4m3. wH3n 3n4BlEd J00 C@n +r@Ck +H3 CH4n9eS 4 useR m4kEs +0 THE1R U\$ern@me vI@ TEh 4DM1n U53r t0Ols.";
$lang['forum_settings_help_54'] = "uS3 <b>f0RUM rULE\$</b> to 3nt3r 4n @Cc3pt4BlE UsE Pol1cY +h4t 3@ch Us3R mU5+ @gr3E +0 8ePhore r391\$t3r1N9 On y0ur Forum.";
$lang['forum_settings_help_55'] = "j00 C4N Use H+mL in yOUr PH0rUm RUl3s. hypeRl1Nks 4ND ema1l aDDR3ssEs will als0 BE 4U+0m4+iCally ConV3rTED +o linKs. +O use +hE D3F4Ult 8eeh1V3 f0RUm 4up CL34r teH f13ld.";
$lang['forum_settings_help_56'] = "usE <b>n0-rEply eM4il</b> +0 sp3CIfY 4N 3m4il adDr3SS +h@+ DO3s not 3xi\$+ Or w1ll n0t bE M0n1+0rED F0R r3PL1es. thI\$ 3m4Il 4DDREss wIll 83 Used In +h3 hE4D3r\$ pH0R 4LL eM@il5 SEN+ frOm y0Ur f0RuM iNCluDin9 8ut n0+ l1MitED +o pos+ AnD Pm n0+Iph1CA+1onS, useR 3m@IL\$ @nd p@\$Sword r3mindeR\$.";
$lang['forum_settings_help_57'] = "iT 1S r3COmmEND3D th4T j00 UsE 4n eM4IL 4ddress +h4T do35 no+ 3X1ST +0 hElp CUt D0WN On sp4M +H4T mAY Be DiRECTED @t yoUr m@in F0rUm 3M@il ADDR3ss";

// Attachments (attachments.php, get_attachment.php) ---------------------------------------

$lang['aidnotspecified'] = "a1d N0T Sp3C1phi3D.";
$lang['upload'] = "uPL0@D";
$lang['uploadnewattachment'] = "uPL0ad n3w 4++4ChmenT";
$lang['waitdotdot'] = "w4I+..";
$lang['successfullyuploaded'] = "sUCces\$fully UpL0@DED: %s";
$lang['failedtoupload'] = "f4Il3d t0 uplo4d: %s";
$lang['complete'] = "cOMPl3tE";
$lang['uploadattachment'] = "upLo4d 4 ph1l3 phor at+@CHment +o +EH mes\$49E";
$lang['enterfilenamestoupload'] = "eN+er pHIL3n4ME(\$) +0 UPl0aD";
$lang['attachmentsforthismessage'] = "a++4Chments f0R th1\$ ME5s4ge";
$lang['otherattachmentsincludingpm'] = "o+Her at+@CHm3N+s (1nCLuD1NG Pm M3ss@GEs 4nd 0+H3R Forums)";
$lang['totalsize'] = "tO+@l \$iz3";
$lang['freespace'] = "fr33 sp4Ce";
$lang['attachmentproblem'] = "tHere w4s 4 Pr0BLEm D0WNloAD1NG +hIs 4T+@chMEn+. pL34\$3 trY A9@in l@+Er.";
$lang['attachmentshavebeendisabled'] = "a++@Chm3N+5 h4V3 8EEn DIs@8LED 8Y +h3 fORum own3r.";
$lang['canonlyuploadmaximum'] = "j00 C4n only Upl0@D A m4X1mUm Oph 10 PH1l3s 4+ @ +iMe";
$lang['deleteattachments'] = "deL3t3 4t+4chMEnts";
$lang['deleteattachmentsconfirm'] = "aR3 j00 SuR3 J00 w@n+ +0 d3Le+3 tEh S3L3CtED 4+t4CHmENtS?";
$lang['deletethumbnailsconfirm'] = "ar3 j00 \$Ur3 J00 w4Nt t0 D3L3te +3H sel3c+Ed @tT4ChMEn+s thUM8nails?";

// Changing passwords (change_pw.php) ----------------------------------

$lang['passwdchanged'] = "p@Ssw0RD CH@N93d";
$lang['passedchangedexp'] = "y0uR PassW0RD H4s B3en CH4n93d.";
$lang['updatefailed'] = "uPD@+3 ph41leD";
$lang['passwdsdonotmatch'] = "p4\$SworD\$ DO no+ m@+CH.";
$lang['newandoldpasswdarethesame'] = "n3w anD 0LD p@SSW0rDs @re +3h s4mE.";
$lang['requiredinformationnotfound'] = "r3Qu1RED inF0Rm4+i0N not phounD";
$lang['forgotpasswd'] = "f0rg0+ p4SsW0rD";
$lang['resetpassword'] = "resET p4\$sw0rD";
$lang['resetpasswordto'] = "r3S3T p@\$sword t0";
$lang['invaliduseraccount'] = "inv4l1d u\$Er 4cC0UNt spEC1Fi3D. ch3ck EM4il ph0R C0Rr3c+ lINk";
$lang['invaliduserkeyprovided'] = "iNv@liD us3r k3y PROvidED. ch3ck 3M@iL F0r C0rRECT L1nk";

// Deleting messages (delete.php) --------------------------------------

$lang['nomessagespecifiedfordel'] = "nO me5\$@93 spEC1ph13d for D3LEti0n";
$lang['deletemessage'] = "d3LEtE m3\$s@G3";
$lang['postdelsuccessfully'] = "p0S+ D3L3ted \$uCc3s\$PhULly";
$lang['errordelpost'] = "eRR0r d3Leting po5T";
$lang['cannotdeletepostsinthisfolder'] = "j00 C@nnot DEl3TE pO\$tS IN +hIs phoLDeR";

// Editing things (edit.php, edit_poll.php) -----------------------------------------

$lang['nomessagespecifiedforedit'] = "no mEssa9E sp3C1FIed phoR 3Di+iN9";
$lang['cannoteditpollsinlightmode'] = "cann0+ 3d1+ poll\$ in l1Ght M0D3";
$lang['editedbyuser'] = "ed1+Ed: %s 8y %s";
$lang['editappliedtomessage'] = "eDIT 4PplI3D +o M3\$S@gE";
$lang['errorupdatingpost'] = "erR0R uPD4+inG po\$+";
$lang['editmessage'] = "eDit ME\$S4g3 %s";
$lang['editpollwarning'] = "<b>n0+E</b>: Edit1ng CERt4In @sP3CT\$ 0f 4 poLl will v0id 4ll tEh cUrR3Nt v0te5 aND allow PEopl3 +o v0+3 4g@1N.";
$lang['hardedit'] = "h@rd ED1+ op+i0n\$ (Vo+3S will 83 r3SEt):";
$lang['softedit'] = "sofT 3di+ 0p+i0N5 (vo+Es will 8E r3T4inED):";
$lang['changewhenpollcloses'] = "ch4N9e WHEn +3h p0LL clo\$es?";
$lang['nochange'] = "n0 ch4Nge";
$lang['emailresult'] = "em4il R3sUl+";
$lang['msgsent'] = "m35SA9E s3N+";
$lang['msgsentsuccessfully'] = "m3s5493 \$ENT suCC3ssfUlLy.";
$lang['mailsystemfailure'] = "m41l systeM f4iluR3. m3Ss4G3 N0+ sen+.";
$lang['nopermissiontoedit'] = "j00 4r3 n0T permI+t3D to 3d1+ ThI\$ MESs4g3.";
$lang['cannoteditpostsinthisfolder'] = "j00 C4nn0T 3Di+ po\$+S in +HIs phoLd3r";
$lang['messagewasnotfound'] = "me5s@ge %s w@s n0T foUnD";

// Email (email.php) ---------------------------------------------------

$lang['sendemailtouser'] = "s3Nd 3ma1l to %s";
$lang['nouserspecifiedforemail'] = "no User \$P3ciF13D ph0r em@1L1NG.";
$lang['entersubjectformessage'] = "en+3r 4 5UBJ3c+ F0R +hE mEss@ge";
$lang['entercontentformessage'] = "en+Er 50m3 Con+Ent pH0R +H3 M3\$S@g3";
$lang['msgsentfromby'] = "th1s m3sSA93 w45 53n+ phr0M %s 8y %s";
$lang['subject'] = "sU8J3C+";
$lang['send'] = "seND";
$lang['userhasoptedoutofemail'] = "%s h45 0PtED 0Ut 0ph 3m4iL COnt4C+";
$lang['userhasinvalidemailaddress'] = "%s H4s @N 1NV@liD ema1L @ddR3ss";

// Message nofificaiton ------------------------------------------------

$lang['msgnotification_subject'] = "m3Ssa93 notIPHiC4+ION fr0M %s";
$lang['msgnotificationemail'] = "h3llo %s,\n\n%s pO5+3d 4 m35S4gE T0 j00 on %s.\n\n+H3 SU8j3Ct i\$: %s.\n\nt0 r3AD +H4+ m3ss4G3 4nd oth3R\$ IN +HE \$4me Di\$cUSS10N, 90 +0:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nnoTe: 1PH j00 do no+ Wi\$H +0 R3c31VE Em4Il no+iPh1Cations 0ph phorum MEs\$@935 p0S+ed t0 you, g0 +o: %s CL1Ck on MY c0NTrols TH3N Em@il @nd privaCy, un\$ElECt the emAil n0+ifIC@+10N chECk8ox @nD pre5\$ submi+.";

// Thread Subscription notification ------------------------------------

$lang['subnotification_subject'] = "sub5cr1p+i0N nO+1phiC@+i0N Phr0m %s";
$lang['subnotification'] = "hELl0 %s,\n\n%s p0St3D @ M3\$54ge In 4 thRe4D J00 H@v3 \$UbSCR18eD to oN %s.\n\nTH3 5u8j3C+ 15: %s.\n\n+O r3@D th4t MES\$49e 4Nd O+hErS IN thE s4M3 diScU\$SIOn, g0 +0:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nN0tE: if J00 d0 NOT w1SH tO r3c3iv3 em@1L no+1ph1C4tIon5 oph NEw m3\$s@93\$ iN +hI\$ ThRE4d, 9o T0: %s ANd aDjust y0UR 1N+er3\$+ leVEl 4+ +hE 8O++0M 0PH +hE p49e.";

// PM notification -----------------------------------------------------

$lang['pmnotification_subject'] = "pm no+ifiC@+i0N fR0M %s";
$lang['pmnotification'] = "helL0 %s,\n\n%s Po\$+3d a pm t0 J00 0n %s.\n\ntHe su8jECT 1s: %s.\n\n+0 ReAD tHe mEss4G3 Go to:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nno+3: iph J00 D0 NO+ W1sh To ReC31V3 eMAIl n0+1F1C4tioNs of nEW Pm mess4Ge\$ Po5TEd +o you, g0 +O: %s Cl1ck my Contr0l5 thEn em41l 4ND priV4cy, uNSEleCt th3 pM N0+1phic@+10n ch3ck8Ox and PR3sS su8M1t.";

// Password change notification ----------------------------------------

$lang['passwdchangenotification'] = "p4\$Sword Ch4ngE n0TipHiCAt10n fr0M %s";
$lang['pwchangeemail'] = "hELlO %s,\n\nthIs a n0+ifiC@T10n 3M4il to inF0RM j00 +h4t yoUR passwoRD 0N %s h4\$ 8Een CHAn93d.\n\nI+ h@\$ 8eEN CH4nGED To: %s 4nD W4\$ Ch4Ng3D 8Y: %s.\n\n1pH j00 h4vE r3cEIv3D +h1\$ 3m4Il 1n 3rR0R or w3re n0+ Exp3C+ing @ Ch4NgE t0 y0ur p4\$Sw0RD plE4\$e c0n+4ct teh forUM owneR or 4 moD3RatoR 0n %s imm3D14+elY To c0rr3C+ it.";

// Email confirmation notification -------------------------------------

$lang['emailconfirmationrequiredsubject'] = "ema1l C0nFirm4t10n rEqu1R3d f0r %s";
$lang['confirmemail'] = "hELlo %s,\n\ny0U r3c3ntly Cr34+ed @ n3w U\$ER ACC0uNt 0N %s.\n83fORE j00 C@n s+@r+ po\$+1ng w3 NEED +o CoNf1rm y0Ur 3m@il 4dDress. Don'+ worrY tH1s I\$ qUi+3 3@\$Y. 4lL j00 n3ED +o D0 1S cl1ck ThE link 8ELow (or C0py @nD pAstE it iNt0 y0UR 8r0w\$3r):\n\n%s\n\n0nc3 Conf1Rm@tI0N i\$ C0mpl3t3 J00 M4y lo9In 4Nd \$+4RT p0\$T1ng 1Mmedi4+3ly.\n\nif J00 d1d No+ cre4T3 4 u53R @Cc0unT 0N %s plEase 4Cc3Pt oUR @p0l0gieS 4nD PhorW@rD +hI\$ 3M@1l +o %s 50 +H4+ +he S0urce OPh i+ m4y be inv3st1G4t3d.";
$lang['confirmchangedemail'] = "hELl0 %s,\n\nyou r3c3Ntly Ch4NG3d your 3ma1L On %s.\nB3F0re J00 c@n s+4r+ P0S+ing @g@1N w3 NE3d +0 c0NPh1Rm y0ur NEW em@1L 4DDR3\$S. D0N't w0rry this is QU1t3 345y. 4Ll J00 n3eD +o d0 I5 ClICk th3 L1nk b3L0w (OR cOpy 4nd P4stE 1+ in+0 y0UR Br0Wser):\n\n%s\n\n0NCe coNF1RM@tIOn 1s cOMPl3+e j00 m@y c0ntinu3 to US3 th3 fOrum 45 N0rmal.\n\nIF j00 were n0+ 3xp3c+1ng +h1S 3m@il phROM %s pl34se 4cC3pt Our @polo91Es 4nd phorw@rd TH1S em41l +o %s sO +h4+ +h3 s0urc3 oph I+ m4y 83 1Nv3\$T1g4+3D.";

// Forgotten password notification -------------------------------------

$lang['forgotpwemail'] = "h3LL0 %s,\n\nyoU REqUEsT3D +hi\$ 3-m4Il PhRoM %s 83c4U53 j00 h@Ve phor90++3N y0ur p@\$sw0Rd.\n\nCL1CK tEH L1Nk BEL0W (0R C0py @nD paste 1+ in+0 y0Ur 8R0w\$eR) +0 r3s3+ y0UR p4S\$WORD:\n\n%s";

// Admin New User notification -----------------------------------------

$lang['newuserregistrationsubject'] = "n3w U\$er acCount n0+1f1ca+10n f0R %s";
$lang['newuserregistrationemail'] = "Hello %s,\n\nA new user account has been created on %s.\n\nAs you are an Administrator of this forum you are required to approve this user account before it can be used by it's owner.\n\nTo approve this account please visit the Admin Users section and change the filter type to \"Users Awaiting Approval\"OR ClICk +h3 LInk 8eloW:\n\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nN0te: 0THer @DMiNIstr4tOR5 on TH1s f0rum will @lSo r3C31ve +Hi\$ N0tiFIC4+i0N 4Nd M@Y havE 4lr34dy 4CTED Up0n tH1s R3Qu3sT.";

// User Approved notification ------------------------------------------

$lang['useraccountapprovedsubject'] = "uS3r 4Ppr0v@l nOt1f1C4+i0N pHoR %s";
$lang['useraccountapprovedemail'] = "h3lL0 %s,\n\ny0ur usEr @cCoUNt 4+ %s H4s beEn 4Ppr0VEd. j00 C@n Lo91n @nD StAr+ P0s+1ng 1Mm3DI@+ly 8Y CLiCK1ng +h3 lInk 8EL0W:\n\n%s\n\n1F j00 weR3 n0T 3xpECT1NG Thi\$ 3mail phRom %s pl3@5e @Cc3p+ ouR 4p0Lo9iES @nd Ph0Rw4RD Th1s 3ma1L +o %s \$0 that +h3 \$0urCE oph 1t M4Y be inve5+19a+ed.";

// Admin Post Approval notification -----------------------------------------

$lang['newpostapprovalsubject'] = "pO5T 4PPROval n0+1phiC4+1on ph0R %s";
$lang['newpostapprovalemail'] = "h3ll0 %s,\n\n4 new p0S+ h@\$ 8e3N Cr3aTED 0N %s.\n\n4s j00 @r3 4 moDER@+0r 0n +His f0RUm j00 @r3 REQUir3d +o 4pPr0v3 +his po\$+ B3F0re it CAn 83 R34D By oThEr User\$.\n\ny0U c4n @PPr0v3 thi\$ po5+ @nD 4NY 0th3r\$ P3nd1Ng @ppr0v@l 8y viS1+1N9 tH3 @Dm1N p0S+ 4pprov4l sec+i0n 0Ph y0ur f0rum or by click1N9 +he link B3low:\n\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nNo+e: o+HEr @dm1nIsTR4t0rs 0N +h1\$ f0RUm wiLL 4l\$0 rEC31ve +H1s n0tiph1C4+1ON 4nd maY H@ve @lrE4dy @CtEd upon +h1\$ r3qu3st.";

// Forgotten password form.

$lang['passwdresetrequest'] = "yOur p4ssw0rd r3S3t rEQUEs+ From %s";
$lang['passwdresetemailsent'] = "p@s\$W0RD R353T e-m41l sen+";
$lang['passwdresetexp'] = "j00 \$H0uld sh0r+Ly rEc31V3 4n e-m41L c0n+41n1ng 1nSTRuCTi0n5 ph0r RESE+TiNg YoUr pa5\$w0Rd.";
$lang['validusernamerequired'] = "a V@L1d u\$3rn4M3 1\$ REQuIr3D";
$lang['forgottenpasswd'] = "f0r9ot p@ssW0RD";
$lang['couldnotsendpasswordreminder'] = "cOUlD n0T SEnd P@sswOrD R3MinD3r. pl3@\$e C0n+4C+ th3 f0RUm 0WN3r.";
$lang['request'] = "rEqu3S+";

// Email confirmation (confirm_email.php) ------------------------------

$lang['emailconfirmation'] = "emA1l C0NFiRm@+i0n";
$lang['emailconfirmationcomplete'] = "th4nk J00 foR conPhIrMiNg y0UR 3m@IL 4dDr3s\$. j00 m4y nOw Lo91n @nd stAr+ Po5+In9 1mmEDI4+3ly.";
$lang['emailconfirmationfailed'] = "ema1l c0nfIRM@+i0N h45 F41L3d, pLE453 TRy 494In L4+er. iF j00 3nC0unTEr thI\$ 3Rr0R mUl+1PlE +iM3s pL34se CONt4c+ +3H f0RUm oWn3r OR a MoDERATor f0R 45\$is+4NCE.";

// Links database (links*.php) -----------------------------------------

$lang['toplevel'] = "t0p l3V3l";
$lang['maynotaccessthissection'] = "j00 m@y N0t aCC3\$\$ Th1\$ \$3C+1On.";
$lang['toplevel'] = "top l3Vel";
$lang['links'] = "linkS";
$lang['viewmode'] = "v13W mode";
$lang['hierarchical'] = "h13r4rCh1C4L";
$lang['list'] = "l1\$t";
$lang['folderhidden'] = "th1s ph0LD3r iS H1ddEn";
$lang['hide'] = "hid3";
$lang['unhide'] = "uNh1de";
$lang['nosubfolders'] = "n0 su8PholD3R\$ in +his C4+390rY";
$lang['1subfolder'] = "1 SU8phoLDER in +H1s C4+390RY";
$lang['subfoldersinthiscategory'] = "sU8Ph0lD3r5 In +hi\$ c4+390ry";
$lang['linksdelexp'] = "enTr13\$ IN 4 d3l3t3D PhOlDEr will 8e m0VED +0 +Eh p4r3nT f0lder. 0NLy pHoldEr5 whiCH D0 N0+ c0NT41N 5U8PHoldErs M@y 83 del3+ED.";
$lang['listview'] = "l15t vIEw";
$lang['listviewcannotaddfolders'] = "c@nn0+ @dD PholD3r\$ iN +His vi3w. \$h0wing 20 eNtrIe\$ 4+ @ tImE.";
$lang['rating'] = "r4+1n9";
$lang['nolinksinfolder'] = "n0 l1NK\$ In +h15 phold3r.";
$lang['addlinkhere'] = "aDd LINK h3RE";
$lang['notvalidURI'] = "th@+ is n0T @ vaLiD UR1!";
$lang['mustspecifyname'] = "j00 mus+ \$p3Cify 4 N@ME!";
$lang['mustspecifyvalidfolder'] = "j00 mU5+ \$p3CiFy 4 v@liD F0LDER!";
$lang['mustspecifyfolder'] = "j00 mu\$T spEC1FY a f0LDEr!";
$lang['successfullyaddedlinkname'] = "sUcc3sSFUllY 4DDED l1nk '%s'";
$lang['failedtoaddlink'] = "f@Il3D +o @DD L1nk";
$lang['failedtoaddfolder'] = "f@1led t0 AdD f0LDEr";
$lang['addlink'] = "add 4 l1NK";
$lang['addinglinkin'] = "aDDIng L1NK in";
$lang['addressurluri'] = "adDRes\$";
$lang['addnewfolder'] = "aDd 4 neW pholdER";
$lang['addnewfolderunder'] = "addin9 nEw pholDEr uNDer";
$lang['editfolder'] = "ed1t PHold3r";
$lang['editingfolder'] = "ed1ting f0LD3R";
$lang['mustchooserating'] = "j00 mU5+ ChOo\$E @ rat1N9!";
$lang['commentadded'] = "y0UR c0mm3nt was 4DD3d.";
$lang['commentdeleted'] = "c0MmEnt w4\$ d3L3+3D.";
$lang['commentcouldnotbedeleted'] = "coMM3Nt COUld n0T 83 dEl3ted.";
$lang['musttypecomment'] = "j00 mu\$t +ype 4 C0MMEN+!";
$lang['mustprovidelinkID'] = "j00 mU\$T ProviD3 @ l1NK id!";
$lang['invalidlinkID'] = "iNv@l1D LinK Id!";
$lang['address'] = "address";
$lang['submittedby'] = "sUBM1+tEd 8y";
$lang['clicks'] = "cL1Cks";
$lang['rating'] = "r4T1ng";
$lang['vote'] = "vOte";
$lang['votes'] = "voTE\$";
$lang['notratedyet'] = "n0T r4+3D BY aNy0NE yET";
$lang['rate'] = "r4T3";
$lang['bad'] = "b4D";
$lang['good'] = "g00d";
$lang['voteexcmark'] = "v0+3!";
$lang['clearvote'] = "cl3ar v0TE";
$lang['commentby'] = "c0Mm3N+ BY %s";
$lang['addacommentabout'] = "aDd 4 c0Mm3n+ 48ou+";
$lang['modtools'] = "m0D3r4+10n TOol\$";
$lang['editname'] = "eDi+ n4M3";
$lang['editaddress'] = "edIt 4DDrE5\$";
$lang['editdescription'] = "edIt D3sCR1P+i0n";
$lang['moveto'] = "m0V3 to";
$lang['linkdetails'] = "l1Nk D3ta1ls";
$lang['addcomment'] = "adD ComMEnt";
$lang['voterecorded'] = "y0Ur voTe h4s B3En r3COrD3d";
$lang['votecleared'] = "yOUR v0t3 h@s 8EEN cleAr3d";
$lang['linknametoolong'] = "l1NK n4me +0o loNg. max1MUM i5 %s ch@R@cterS";
$lang['linkurltoolong'] = "lINK url +0o loN9. M@x1mUm 1s %s chaR4C+ER\$";
$lang['linkfoldernametoolong'] = "foLD3r N4m3 +0o l0ng. m4xImum LEn9Th Is %s ch4RaC+3rS";

// Login / logout (llogon.php, logon.php, logout.php) -----------------------------------------

$lang['loggedinsuccessfully'] = "j00 l099ED 1n \$uCC3ssfullY.";
$lang['presscontinuetoresend'] = "pRes5 C0ntinu3 +o r3SenD f0Rm D4+4 or cANc3l +0 REl04D pa93.";
$lang['usernameorpasswdnotvalid'] = "tHE u\$eRn@m3 0R p@Ssw0rD j00 supplI3D is Not v@l1d.";
$lang['rememberpasswds'] = "r3MEmB3r p45\$W0RD5";
$lang['rememberpassword'] = "r3MEm8er paSSw0rd";
$lang['enterasa'] = "en+er @5 @ %s";
$lang['donthaveanaccount'] = "d0n'+ h@v3 an 4cCoUnt? %s";
$lang['registernow'] = "r3G1S+3r n0w.";
$lang['problemsloggingon'] = "pR0BleMs l09GIng 0n?";
$lang['deletecookies'] = "dEl3+3 c00K1E\$";
$lang['cookiessuccessfullydeleted'] = "c00KiE\$ SUCCEssFULly D3L3TED";
$lang['forgottenpasswd'] = "f0r9o+tEn y0uR p45\$WoRD?";
$lang['usingaPDA'] = "uSING 4 pD4?";
$lang['lightHTMLversion'] = "l19h+ htmL Ver\$1on";
$lang['youhaveloggedout'] = "j00 havE L0993d 0U+.";
$lang['currentlyloggedinas'] = "j00 @re CurRentlY L0g9eD In 4s %s";
$lang['logonbutton'] = "lo90N";
$lang['otherbutton'] = "oTHer";
$lang['yoursessionhasexpired'] = "your \$3\$S10n h@\$ 3xp1R3D. j00 will n3ED +0 L091n @g@in +0 C0N+1nue.";

// My Forums (forums.php) ---------------------------------------------------------

$lang['myforums'] = "my phorum\$";
$lang['allavailableforums'] = "aLL @v@iL4BLE ph0rum\$";
$lang['favouriteforums'] = "f@v0uri+E f0Rums";
$lang['ignoredforums'] = "iGn0r3D f0RUMs";
$lang['ignoreforum'] = "i9N0RE f0rUM";
$lang['unignoreforum'] = "un1gnore f0Rum";
$lang['lastvisited'] = "l45t vis1+3d";
$lang['forumunreadmessages'] = "%s unreaD m3\$S@g3S";
$lang['forummessages'] = "%s me5\$4ge5";
$lang['forumunreadtome'] = "%s UNr34D &quot;+0: ME&quot;";
$lang['forumnounreadmessages'] = "n0 unR34D m3s\$a935";
$lang['removefromfavourites'] = "r3Mov3 Fr0M f4V0ur1tEs";
$lang['addtofavourites'] = "add +0 phavourI+Es";
$lang['availableforums'] = "av@il4BLE pH0RUm\$";
$lang['noforumsofselectedtype'] = "tH3rE 4re n0 pHorUm\$ OPH +3H sel3c+eD +Yp3 aVa1l@BlE. plE4\$E \$el3C+ 4 d1fPH3ren+ TYp3.";
$lang['successfullyaddedforumtofavourites'] = "sUCC3sSFUlly 4DDEd f0rum +0 fAvOuRi+3S.";
$lang['successfullyremovedforumfromfavourites'] = "succ3sSFULlY REmOvED PhoRUm pHrom PH@V0URi+3\$.";
$lang['successfullyignoredforum'] = "sucCEssfully 1gnOrED f0rum.";
$lang['successfullyunignoredforum'] = "succ3SsfUlly UN1Gn0reD F0RUm.";
$lang['failedtoupdateforuminterestlevel'] = "f4il3d +o upD4+3 F0rum intER35t lEVEL";
$lang['noforumsavailablelogin'] = "th3rE 4r3 N0 F0rums 4V41L48lE. PlE4SE lO91n +0 v1EW Y0UR pH0RUm\$.";
$lang['passwdprotectedforum'] = "p4s\$W0RD pR0+3Cted phORUM";
$lang['passwdprotectedwarning'] = "thiS f0rum Is p4SsW0RD Pr0+3C+3d. +0 941N 4CC3sS 3NT3r +he p4sSw0RD 83L0w.";

// Message composition (post.php, lpost.php) --------------------------------------

$lang['postmessage'] = "p0S+ M3Ss4G3";
$lang['selectfolder'] = "sel3C+ F0ldEr";
$lang['mustenterpostcontent'] = "j00 mu\$t eNteR \$0mE CoN+ent F0R tEh po\$+!";
$lang['messagepreview'] = "meSs49E Pr3v13W";
$lang['invalidusername'] = "inv4l1D usErn4m3!";
$lang['mustenterthreadtitle'] = "j00 must eNtER 4 tiTle F0R +3H +Hr34d!";
$lang['pleaseselectfolder'] = "ple@SE 5el3c+ @ Ph0ld3R!";
$lang['errorcreatingpost'] = "err0r crE@+1ng Po\$+! PLE@sE +Ry A9@in 1n @ Ph3w M1nu+e\$.";
$lang['createnewthread'] = "crE@te new thRE4D";
$lang['postreply'] = "pOst R3PLy";
$lang['threadtitle'] = "thR3@D +1+le";
$lang['messagehasbeendeleted'] = "meSs49e N0t FOUnD. CH3CK +H@+ it h45n't 833N DELEtED.";
$lang['messagenotfoundinselectedfolder'] = "m3sSAg3 n0T f0UND in sEL3Ct3D ph0ldEr. Ch3cK Th4+ 1T h4Sn't 8e3n m0VEd oR DELE+Ed.";
$lang['cannotpostthisthreadtypeinfolder'] = "j00 C4nn0+ p05+ +H1\$ +hR34D tYp3 1n +h4+ ph0LD3r!";
$lang['cannotpostthisthreadtype'] = "j00 caNN0+ P0st +H1\$ +hR34d type @s +H3rE 4r3 No @V4IL4BlE F0lDErS +h@T 4ll0W 1t.";
$lang['cannotcreatenewthreads'] = "j00 c4NN0t CR3@+3 neW +hr3@D\$.";
$lang['threadisclosedforposting'] = "thiS thr34d 1s CLo\$ED, j00 C4Nnot po\$+ in it!";
$lang['moderatorthreadclosed'] = "w4RNing: +hIs +Hr3@D 1S Clo\$ED PhoR P0s+Ing +0 NorM4L u\$er\$.";
$lang['usersinthread'] = "user\$ in THre4D";
$lang['correctedcode'] = "cOrr3CTED C0de";
$lang['submittedcode'] = "suBmiT+ed C0D3";
$lang['htmlinmessage'] = "htMl iN m3s5@g3";
$lang['disableemoticonsinmessage'] = "di\$@8Le Em0tiCon\$ iN m3Ss49E";
$lang['automaticallyparseurls'] = "au+om4+iCaLlY p@rsE URl\$";
$lang['automaticallycheckspelling'] = "aU+0mat1CAlly Ch3ck speLl1NG";
$lang['setthreadtohighinterest'] = "se+ +hrE4D to h1gh in+Er3st";
$lang['enabledwithautolinebreaks'] = "eN@8Led Wi+h 4ut0-LinE-8r34ks";
$lang['fixhtmlexplanation'] = "tHiS Forum usE\$ H+ml ph1LtEr1n9. Y0ur 5UBM1++ed hTmL h4S B33n m0difieD 8Y +hE PhILt3r\$ iN sOm3 W4Y.\\n\\nTO vI3W y0ur 0r1gin@l C0dE, \$EL3c+ +Eh \\'su8m1+teD CODE\\' r4DIo BUt+On.\\n+0 viEw TEH Mod1PHI3d CoD3, \$ELECT +HE \\'CoRrEC+3D C0dE\\' r4di0 Bu+t0n.";
$lang['messageoptions'] = "meSs4ge 0Ption5";
$lang['notallowedembedattachmentpost'] = "j00 4r3 not 4llOw3D +0 eMbED 4t+@Chm3ntS in yoUr P0sts.";
$lang['notallowedembedattachmentsignature'] = "j00 aRE n0+ @lL0W3d +0 emBED aTTaCHm3nTS in y0Ur \$1gn@tURE.";
$lang['reducemessagelength'] = "mEsS493 l3n9+h mUsT 83 UnD3R 65,535 ch@R4CT3r5 (CurR3NTly: %s)";
$lang['reducesiglength'] = "sI9n@+Ure LeN9+h mU\$+ 8E uND3r 65,535 Ch@r4Ct3R5 (CUrREn+ly: %s)";
$lang['cannotcreatethreadinfolder'] = "j00 c@Nnot crEatE new THr34ds iN +Hi\$ F0lder";
$lang['cannotcreatepostinfolder'] = "j00 C@nno+ ReplY +0 po\$T5 in +h1s pH0lder";
$lang['cannotattachfilesinfolder'] = "j00 cann0t p05+ 4++4chmEn+5 in +h15 folD3r. REM0ve @t+4chM3nt\$ +0 Con+1nUE.";
$lang['postfrequencytoogreat'] = "j00 C@n 0nly po\$t 0nCE 3VERY %s SECOND\$. pL34SE +ry a9@iN L4+ER.";
$lang['emailconfirmationrequiredbeforepost'] = "emA1l ConF1RmaTiOn i\$ requIr3D 8ePHOrE j00 C4n pos+. IPh J00 haVE n0t r3C31VED @ C0nfiRm@+10n 3M4Il PlE453 cl1CK +hE 8UtT0N BEL0W anD 4 nEw 0ne will 8E sENt +0 y0U. ipH y0ur em@iL 4DDR35\$ n3ED\$ chang1NG pl34\$E Do s0 BEF0re reQu35+ing @ n3w C0nF1rmaT10n EMa1L. j00 May ch4Nge Y0ur eM41l 4DDr3Ss 8Y cl1Ck my Con+rol\$ @8OV3 and th3n US3R d3+@1l5";
$lang['emailconfirmationfailedtosend'] = "cONFIrmat10n 3M4il f4ILED t0 S3ND. pLe4sE CONt4ct tEh Ph0rum owNEr t0 R3c+ify th1S.";
$lang['emailconfirmationsent'] = "coNf1RMAt10n Em4IL Has 8e3N resEn+.";
$lang['resendconfirmation'] = "r3S3Nd CoNpHiRm@+1on";
$lang['userapprovalrequiredbeforeaccess'] = "yOUR U\$er 4cc0unT nEeDS +o 8e @Ppr0vED 8y @ Ph0rum 4Dm1N BEF0RE J00 CaN 4ccE5\$ +Eh ReqU3STEd F0RUm.";

// Message display (messages.php & messages.inc.php) --------------------------------------

$lang['inreplyto'] = "iN reply +o";
$lang['showmessages'] = "show m3s\$@ges";
$lang['ratemyinterest'] = "r4+E my 1n+ER3\$+";
$lang['adjtextsize'] = "adju\$T +Ext s1z3";
$lang['smaller'] = "sm4ll3r";
$lang['larger'] = "l4RGEr";
$lang['faq'] = "faq";
$lang['docs'] = "doc\$";
$lang['support'] = "sUpp0r+";
$lang['donateexcmark'] = "don@tE!";
$lang['fontsizechanged'] = "f0n+ size CH4NGED. %s";
$lang['framesmustbereloaded'] = "fraM3\$ must BE rEL04d3D m4NU4LLY t0 SEE ch4ng3S.";
$lang['threadcouldnotbefound'] = "tHe r3qu3\$+3D +HrE4D C0UlD no+ 8E F0und or ACcE\$s w4s D3N13d.";
$lang['mustselectpolloption'] = "j00 mu\$t sel3Ct @n 0p+1on TO vO+3 f0R!";
$lang['mustvoteforallgroups'] = "j00 mu\$t v0+3 1n EV3RY gR0uP.";
$lang['keepreading'] = "k3Ep re4d1n9";
$lang['backtothreadlist'] = "back to thrE4d LISt";
$lang['postdoesnotexist'] = "tH4+ po5+ Do3\$ No+ 3x1s+ in Th1s +Hr34d!";
$lang['clicktochangevote'] = "clIck To ch4Ng3 v0T3";
$lang['youvotedforoption'] = "j00 VOTED ph0r op+10n";
$lang['youvotedforoptions'] = "j00 V0T3d pHor 0P+I0N5";
$lang['clicktovote'] = "cL1ck TO vot3";
$lang['youhavenotvoted'] = "j00 h4ve No+ v0TEd";
$lang['viewresults'] = "v1ew re\$ult5";
$lang['msgtruncated'] = "me\$S4GE +rUnC4ted";
$lang['viewfullmsg'] = "v13w fulL me5\$@g3";
$lang['ignoredmsg'] = "i9NoreD mE\$s4g3";
$lang['wormeduser'] = "woRM3D u53r";
$lang['ignoredsig'] = "i9N0R3d \$I9n@tuRE";
$lang['messagewasdeleted'] = "m3\$s@g3 %s.%s W@\$ D3Le+ed";
$lang['stopignoringthisuser'] = "st0p 1Gn0r1ng +hiS U\$3r";
$lang['renamethread'] = "r3n4ME thre4d";
$lang['movethread'] = "mOv3 tHrE4D";
$lang['torenamethisthreadyoumusteditthepoll'] = "to REN4M3 tH1s +hRe4D j00 musT EDiT +he poLl.";
$lang['closeforposting'] = "cL0sE F0r pO\$+1NG";
$lang['until'] = "unTil 00:00 utC";
$lang['approvalrequired'] = "aPpr0v4l reqU1r3d";
$lang['messageawaitingapprovalbymoderator'] = "m3Ss4gE %s.%s 1\$ 4W@i+1ng @pPr0vAL 8y 4 ModER4TOr";
$lang['postapprovedsuccessfully'] = "pOs+ 4Pprov3D sucCEssfUlLy";
$lang['postapprovalfailed'] = "p0st 4ppr0v@l phailED.";
$lang['postdoesnotrequireapproval'] = "poS+ Do3S n0+ reQuIr3 4ppRov4L";
$lang['approvepost'] = "aPprov3 po\$+";
$lang['approvedbyuser'] = "apPr0veD: %s 8y %s";
$lang['makesticky'] = "m4K3 s+iCKy";
$lang['messagecountdisplay'] = "%s 0ph %s";
$lang['linktothread'] = "peRmAnEn+ link t0 th1s +hR34d";
$lang['linktopost'] = "liNK +o p0S+";
$lang['linktothispost'] = "l1Nk +0 th15 p0ST";
$lang['imageresized'] = "tH1s iM49e h4s 83EN r3sIZ3d (Or1GiN@L S1z3 %1\$\$x%2\$s). to v1ew +h3 fulL-siz3 IM49e CLICk h3RE.";
$lang['messagedeletedbyuser'] = "m35s@9E %s.%s DEL3+ED %s 8y %s";
$lang['messagedeleted'] = "mEsS4g3 %s.%s w@5 d3l3tED";

// Moderators list (mods_list.php) -------------------------------------

$lang['cantdisplaymods'] = "c4Nn0+ Di5Pl4Y phoLDEr modEr4+0rs";
$lang['moderatorlist'] = "m0d3RaTor LI\$t:";
$lang['modsforfolder'] = "m0d3R@t0r\$ F0r PH0ldEr";
$lang['nomodsfound'] = "nO m0d3R4+0rS F0und";
$lang['forumleaders'] = "foRUm L34d3R\$:";
$lang['foldermods'] = "fOld3R m0d3R4tors:";

// Navigation strip (nav.php) ------------------------------------------

$lang['start'] = "sT4RT";
$lang['messages'] = "m3Ss4G3S";
$lang['pminbox'] = "inB0X";
$lang['startwiththreadlist'] = "s+@r+ Pa93 w1+h +Hr34D lI\$T";
$lang['pmsentitems'] = "s3nt 1+3m5";
$lang['pmoutbox'] = "ou+BoX";
$lang['pmsaveditems'] = "s4V3D 1+eMS";
$lang['pmdrafts'] = "drAF+s";
$lang['links'] = "lInks";
$lang['admin'] = "adM1n";
$lang['login'] = "l091N";
$lang['logout'] = "l0GoU+";

// PM System (pm.php, pm_write.php, pm.inc.php) ------------------------

$lang['privatemessages'] = "prIV4+E MEss49es";
$lang['recipienttiptext'] = "seP4rat3 r3CiP1eNTS 8y \$EM1-col0N 0R COmm@";
$lang['maximumtenrecipientspermessage'] = "tHErE 1s 4 lIm1+ of 10 r3C1P1EN+\$ p3r mEss4g3. PlE4\$e @m3ND Y0UR r3cipiEnT l1s+.";
$lang['mustspecifyrecipient'] = "j00 must sP3CipHY 4+ LEas+ 0ne R3c1piEn+.";
$lang['usernotfound'] = "u\$3r %s no+ f0UnD";
$lang['sendnewpm'] = "s3nd nEw Pm";
$lang['savemessage'] = "s@V3 m3sS49e";
$lang['timesent'] = "t1m3 53nt";
$lang['errorcreatingpm'] = "erRor cR3ATing pM! PlE4\$3 tRY A9@iN In @ pHEw m1nu+3s";
$lang['writepm'] = "wRI+E m3\$\$4gE";
$lang['editpm'] = "eD1T mEss4G3";
$lang['cannoteditpm'] = "c4Nn0T ED1+ +hIs Pm. 1t H4s @LRE4dy BEEN ViEw3d 8Y +eh RECIp13nt 0R +3H Mess49E do3S N0+ 3x1\$+ 0r i+ i\$ 1n@CcesSI8le 8y j00";
$lang['cannotviewpm'] = "c4nnO+ v1Ew Pm. m3Ssa93 Do3S no+ Exis+ 0R it i\$ iN4ccEss1BLE 8y j00";
$lang['pmmessagenumber'] = "m35\$A93 %s";

$lang['youhavexnewpm'] = "j00 h4v3 %d n3w messaG3s. W0ULD j00 likE +0 go +O your in80X N0w?";
$lang['youhave1newpm'] = "j00 h4ve 1 N3W m3SS@g3. w0uLD J00 l1K3 t0 90 to YoUr in80x n0W?";
$lang['youhave1newpmand1waiting'] = "j00 h@v3 1 n3W MEssa93.\n\nyoU 4Lso h@v3 1 m3SSa9E @w4i+iNg d3liVErY. to r3c31ve +hI\$ MESs@gE pl34\$E CLe4r \$0m3 sp4cE 1N Y0Ur 1N80X.\n\nw0ulD j00 l1K3 t0 90 t0 y0UR 1n8ox NOw?";
$lang['youhave1pmwaiting'] = "j00 h@VE 1 mEss49e 4Wa1T1nG D3L1very. to rEC31vE Th1\$ MeSS49e PLE453 Cl34r som3 sp@CE 1n y0ur 1nB0X.\n\nw0ulD j00 l1K3 tO 90 to Y0ur in8OX now?";
$lang['youhavexnewpmand1waiting'] = "j00 h4ve %d n3w mEss49es.\n\nyOU aL\$0 h@V3 1 messa93 4W@I+ing D3L1v3rY. +o r3cE1VE This mE\$\$@gE pL34\$e cl34r S0M3 \$P4ce 1n your iN8ox.\n\nWOulD j00 l1ke +0 go to Y0Ur In8Ox noW?";
$lang['youhavexnewpmandxwaiting'] = "j00 h@Ve %d n3w MEss4g3s.\n\nyou @Ls0 h@V3 %d m3ss4GE\$ @w41t1Ng D3LIverY. To r3CE1vE Th3SE m3\$\$49E PlE4\$E CL34r \$0m3 \$p@C3 in yoUr iN8ox.\n\nWouLD j00 liKE t0 G0 +o YoUr 1n8Ox now?";
$lang['youhave1newpmandxwaiting'] = "j00 h4V3 1 N3W mEss49E.\n\nYOu 4Lso h@v3 %d m3ss4Ges 4W@i+1nG D3liv3RY. +0 R3C31Ve +hE\$e MESs4G3s pleasE CLE4r s0ME sp4CE in y0Ur 1N8Ox.\n\nw0UlD j00 liKE +0 90 +0 Y0ur 1nB0X n0W?";
$lang['youhavexpmwaiting'] = "j00 HavE %d M3ss4g3s 4W@1+ing D3liVerY. +0 r3C31vE +hese M3ss4GEs pLE4\$3 ClE4r s0M3 Sp4c3 1n yoUR 1n8ox.\n\nWoUlD J00 lIkE +0 90 t0 Your iN8ox noW?";

$lang['youdonothaveenoughfreespace'] = "j00 D0 n0T hAVE 3NoU9H Fr3E spAC3 +o senD +h1\$ M3\$\$4G3.";
$lang['userhasoptedoutofpm'] = "%s hA5 op+3D 0U+ 0Ph rECEIVing p3r\$0n@L mESs49es";
$lang['pmfolderpruningisenabled'] = "pm folDER PRUnING Is 3N4BlED!";
$lang['pmpruneexplanation'] = "thI5 FOrum us3s Pm PhOlDEr prUNiNg. th3 ME\$\$A93s J00 h4V3 S+0red iN YoUr 1N80x @ND 5EN+ 1t3ms\\nphOlDERs @re sU8J3c+ +0 4uT0m4t1C DEl3T1on. 4ny mess@93s j00 wish +o kEep shOULD B3 MOvED +O\\nY0Ur \\'\$4v3d i+3MS\\' foLD3R so +H@t th3Y arE n0T DElE+eD.";
$lang['yourpmfoldersare'] = "yOUr pm f0lDeRs 4rE %s phulL";
$lang['currentmessage'] = "cUrr3Nt m3\$S493";
$lang['unreadmessage'] = "uNR3@d m3ss@ge";
$lang['readmessage'] = "rE@d m3SSa93";
$lang['pmshavebeendisabled'] = "pEr\$0n4L mEssag3\$ h4vE B3En DI\$4bL3D 8y +he f0RUm oWN3r.";
$lang['adduserstofriendslist'] = "adD Us3r5 to y0Ur phri3nds L1sT +0 h@v3 +H3m app3ar 1N @ Dr0p d0WN 0n t3H pm WRitE mE\$S49e P@9e.";

$lang['messagesaved'] = "mE\$s4GE s@veD";
$lang['messagewassuccessfullysavedtodraftsfolder'] = "meS5@G3 w4\$ 5ucCEssFuLly s4v3D +0 'Dr@PH+s' folD3r";
$lang['couldnotsavemessage'] = "c0UlD No+ \$@v3 mEssa9e. m@KE 5URE J00 have 3NoU9h @v4ilaBlE PhR33 sP4CE.";
$lang['pmtooltipxmessages'] = "%s MESs4935";
$lang['pmtooltip1message'] = "1 M35s4g3";

$lang['allowusertosendpm'] = "alL0w U\$er tO 5end peR\$0n4l M3ss4g3s +0 mE";
$lang['blockuserfromsendingpm'] = "bL0ck usEr pHrom seND1n9 p3rsoN4L mE\$S4ges +0 mE";
$lang['yourfoldernamefolderisempty'] = "y0UR %s pholD3R I\$ 3mpTy";
$lang['successfullydeletedselectedmessages'] = "suCCE\$SPhUlLY d3LE+Ed \$el3Ct3D m3Ss4g3\$";
$lang['successfullyarchivedselectedmessages'] = "sUcCEs5phUlly 4RCh1V3d S3lec+3d mess49es";
$lang['failedtodeleteselectedmessages'] = "f41lEd +o D3L3t3 s3LEC+3D mEs\$49Es";
$lang['failedtoarchiveselectedmessages'] = "f41led +0 4RCh1ve 53leC+3D mE5\$49eS";

// Preferences / Profile (user_*.php) ---------------------------------------------

$lang['mycontrols'] = "my CoN+rOl\$";
$lang['myforums'] = "my PHoRuMs";
$lang['menu'] = "mEnu";
$lang['userexp_1'] = "u\$3 t3h mEnu 0N +h3 L3ft +O M4n49E YoUr \$3tt1n9\$.";
$lang['userexp_2'] = "<b>u\$er det4il\$</b> 4ll0w\$ J00 +0 Ch@nGE YoUr n4ME, em41L @dDREss 4ND p@s\$w0rD.";
$lang['userexp_3'] = "<b>u5eR pr0F1L3</b> @ll0Ws j00 +0 ED1+ your Us3R pR0ph1L3.";
$lang['userexp_4'] = "<b>ch4n93 P45\$w0RD</b> 4llow\$ J00 +O chan93 yoUR PassW0rd";
$lang['userexp_5'] = "<b>em41L &amp; pr1V@cy</b> L3+S j00 Ch4Nge how j00 C4N be c0NT4C+3D 0N 4nd 0phPh tEh Forum.";
$lang['userexp_6'] = "<b>fOrum opt10n\$</b> lets j00 ch4NG3 H0w thE f0RUM looKS anD WorK\$.";
$lang['userexp_7'] = "<b>atTAChMENts</b> 4ll0Ws J00 To 3DI+/D3LEtE yOUr a++4CHMEn+\$.";
$lang['userexp_8'] = "<b>s1GN4+Ur3</b> lETS j00 edi+ y0Ur s19N4tUr3.";
$lang['userexp_9'] = "<b>r3L4ti0N5h1ps</b> L3T\$ J00 m@N4GE yOur rEl4TioN\$h1p W1+h 0Th3R useR\$ on +h3 foRUm.";
$lang['userexp_9'] = "<b>w0rd phiL+er</b> L3TS j00 ED1+ yoUr PEr5on@l W0RD phIl+er.";
$lang['userexp_10'] = "<b>tHR3AD suBSCR1ptION\$</b> 4ll0w\$ j00 +O m4N493 your thRE4D sU8SCr1p+i0Ns.";
$lang['userdetails'] = "u53r D3ta1l\$";
$lang['userprofile'] = "uSer pR0philE";
$lang['emailandprivacy'] = "eM41l &amp; priv4cy";
$lang['editsignature'] = "eD1+ si9n4TuR3";
$lang['norelationshipssetup'] = "j00 h4v3 no U\$er REL4tiONSH1p\$ SET up. adD 4 nEw User by \$E4RcHIng B3loW.";
$lang['editwordfilter'] = "eD1T woRD f1lTER";
$lang['userinformation'] = "u\$3R inf0Rm@+10N";
$lang['changepassword'] = "cH4NGE p@\$SwOrD";
$lang['currentpasswd'] = "cURR3N+ P@\$SwOrD";
$lang['newpasswd'] = "nEW p4S\$w0rD";
$lang['confirmpasswd'] = "coNf1rM P4\$sw0rd";
$lang['passwdsdonotmatch'] = "paSswoRd5 DO no+ m4+ch!";
$lang['nicknamerequired'] = "n1Ckn@me i\$ requir3d!";
$lang['emailaddressrequired'] = "em@1l 4dDR3SS i\$ r3qU1R3d!";
$lang['logonnotpermitted'] = "lO90N n0t permi++3D. ChOo5E @n0th3r!";
$lang['nicknamenotpermitted'] = "n1ckn@m3 n0t PErm1tT3d. CH0O53 4No+h3R!";
$lang['emailaddressnotpermitted'] = "eM@1L 4ddr3Ss no+ pErMi+teD. CHOo53 4No+h3R!";
$lang['emailaddressalreadyinuse'] = "eM41l aDDR3\$s @LrE@DY In usE. CH0o\$3 4n0+HER!";
$lang['relationshipsupdated'] = "rEl@Tion5h1ps UPDa+ED!";
$lang['relationshipupdatefailed'] = "r3L4ti0n\$h1p UPD4T3d ph@IL3D!";
$lang['preferencesupdated'] = "prefEr3NCES w3rE SUCC3\$\$fUlly UpD@+eD.";
$lang['userdetails'] = "user D3+a1LS";
$lang['memberno'] = "mEMB3R No.";
$lang['firstname'] = "fiRs+ n@M3";
$lang['lastname'] = "l45t naME";
$lang['dateofbirth'] = "d4T3 0PH B1R+h";
$lang['homepageURL'] = "h0MEp4g3 url";
$lang['profilepicturedimensions'] = "prOF1l3 pictUr3 (m4X 95X95Px)";
$lang['avatarpicturedimensions'] = "av4+4r piC+uR3 (m@x 15X15px)";
$lang['invalidattachmentid'] = "inv4l1d @+t4chMent. CHECK th4+ Is h@sN'+ 8e3N del3+3D.";
$lang['unsupportedimagetype'] = "uN\$upp0rt3D imA93 4++4chMenT. j00 c4N OnlY USE jP9, 91f 4nD Pn9 1M@G3 @tt@CHmEN+5 Ph0R y0UR @v4t4r 4nd profIl3 p1c+uR3.";
$lang['selectattachment'] = "s3lec+ 4++4chm3n+";
$lang['pictureURL'] = "p1c+ur3 uRL";
$lang['avatarURL'] = "av@+4r Url";
$lang['profilepictureconflict'] = "t0 u5e @N @TtachM3Nt pHoR yoUr Pr0PhIl3 p1ctuRE thE p1ctUR3 uRl F13lD mUst 83 bl4nk.";
$lang['avatarpictureconflict'] = "t0 use @n @tt4chMENt PhoR y0ur 4v4T4R p1C+UrE teH 4V@+@r url F13lD must 83 8L4nk.";
$lang['attachmenttoolargeforprofilepicture'] = "selEC+ED 4t+@CHmEn+ 1S +0O l4rgE for ProPhile p1C+UR3. M4X1muM d1m3N5I0N\$ 4r3 %s";
$lang['attachmenttoolargeforavatarpicture'] = "sELEC+ED at+@CHmEnt 1\$ +0o l4Rg3 pH0r @V@T4R PiC+uRE. M4x1MUm d1MeNs10Ns 4rE %s";
$lang['failedtoupdateuserdetails'] = "s0mE 0r 4lL oPh yOUR U\$3r 4CCOUN+ d3T4Il5 CouLd n0+ 83 upd4T3d. pL3@53 tRY AgA1N l@tER.";
$lang['failedtoupdateuserpreferences'] = "s0M3 0r 4Ll 0PH Y0ur usER PR3PhEREnC3s coULD N0T BE UpD@+3D. Ple4SE Try 4G4in latEr.";
$lang['emailaddresschanged'] = "eM4il 4DDR3Ss h@S Be3n cH4NGED";
$lang['newconfirmationemailsuccess'] = "y0Ur Em41l 4Ddress h4\$ 8een CH@nGED 4ND 4 nEw ConphiRm@T10n 3m@iL hAs 8EEn seN+. pl3ASe Ch3CK 4nd rEaD +3H Em4Il F0R pHurTh3r 1nSTrUC+i0n\$.";
$lang['newconfirmationemailfailure'] = "j00 h@v3 Ch4NgED yoUr em4il 4DDREss, BU+ W3 wEr3 un@Bl3 +o seND @ C0NfiRm@+i0n rEqUEst. plE4sE C0N+4ct ThE f0RuM oWn3R F0r 4ss1\$tANC3.";
$lang['forumoptions'] = "f0Rum opt10n\$";
$lang['notifybyemail'] = "n0T1fy by 3M@il OPh po\$Ts +O m3";
$lang['notifyofnewpm'] = "n0+IFY By popUp Of n3w pM m3ss4G3S +o ME";
$lang['notifyofnewpmemail'] = "notiphy bY 3M@il opH nEW pm m3SS49Es t0 m3";
$lang['daylightsaving'] = "aDju5+ f0R D@yLi9Ht s4Vin9";
$lang['autohighinterest'] = "aUt0M4+ICAllY m4rK Thr3@DS 1 P0\$T 1N @\$ HIgh 1N+3r35+";
$lang['convertimagestolinks'] = "aU+0M@+1C4LLy C0NVer+ 3MBeDD3d iM4G3s iN p0STs 1N+0 L1nks";
$lang['thumbnailsforimageattachments'] = "thUm8N@il\$ f0R ima93 4t+@ChmenT\$";
$lang['smallsized'] = "sM4lL s1zeD";
$lang['mediumsized'] = "mED1Um s1Z3D";
$lang['largesized'] = "l@r9E s1z3d";
$lang['globallyignoresigs'] = "gLOb4lly 19n0re User 519N4TUr35";
$lang['allowpersonalmessages'] = "aLlow o+H3r u53r\$ +0 sEnD mE p3RS0N@l m3ssa93\$";
$lang['allowemails'] = "alLow otHEr users +o sEnD m3 3m@ils vi4 MY pr0pH1l3";
$lang['timezonefromGMT'] = "t1m3 ZOn3";
$lang['postsperpage'] = "p05+s p3R p49e";
$lang['fontsize'] = "fONt s1z3";
$lang['forumstyle'] = "f0RUm 5+YL3";
$lang['forumemoticons'] = "foruM 3mo+iC0n\$";
$lang['startpage'] = "s+4R+ p4ge";
$lang['signaturecontainshtmlcode'] = "sIGN4+Ure COn+4ins h+Ml c0de";
$lang['savesignatureforuseonallforums'] = "s@v3 s1Gn4+UrE F0r UsE 0N 4LL ph0RUms";
$lang['preferredlang'] = "pReph3rr3D l@n9u493";
$lang['donotshowmyageordobtoothers'] = "dO nOt shoW My 493 0r DAtE 0PH B1r+H to O+h3rS";
$lang['showonlymyagetoothers'] = "sHOW onLy my a9e +0 0thErs";
$lang['showmyageanddobtoothers'] = "sHow bo+h my @ge 4ND D4t3 0ph bir+h +0 0+h3Rs";
$lang['showonlymydayandmonthofbirthytoothers'] = "sHOw 0nly my D4Y and monTh 0ph b1r+h tO o+hEr5";
$lang['listmeontheactiveusersdisplay'] = "li\$+ mE 0n tEh 4ct1V3 Us3r\$ displ4Y";
$lang['browseanonymously'] = "brOwse f0rUm @NOnymoUsLy";
$lang['allowfriendstoseemeasonline'] = "bROW\$e @nonymOuslY, 8u+ @llow Fr13nds +0 sE3 ME @s Onl1n3";
$lang['revealspoileronmouseover'] = "reV3al spoIlErs on M0U\$3 ov3r";
$lang['showspoilersinlightmode'] = "alWays sh0w \$P01l3R5 in l1ghT m0de (usEs l1GHter phoN+ C0loUR)";
$lang['resizeimagesandreflowpage'] = "re5IZ3 1M@gEs 4ND r3phl0W pag3 TO pr3v3nt h0R1zon+4l sCroLl1ng.";
$lang['showforumstats'] = "sH0W ph0RUm \$t4ts @t B0++0M 0F M3sS49E PaNE";
$lang['usewordfilter'] = "enabLe w0RD f1LtEr.";
$lang['forceadminwordfilter'] = "f0RCE U\$3 0Ph aDM1n w0RD ph1L+Er on 4ll User\$ (1nC. gUE\$+S)";
$lang['timezone'] = "tIm3 z0n3";
$lang['language'] = "lAn9u4ge";
$lang['emailsettings'] = "emA1L and CoNt@CT \$ETT1NGs";
$lang['forumanonymity'] = "f0Rum @nonYmI+y Sett1ngs";
$lang['birthdayanddateofbirth'] = "b1R+hd4Y @ND D@+E Oph B1RTH dI\$play";
$lang['includeadminfilter'] = "includE @dmin WorD Philter in My l1S+.";
$lang['setforallforums'] = "s3T Ph0R 4LL f0RUmS?";
$lang['containsinvalidchars'] = "%s cON+4In5 iNV4l1d CH4R4C+Ers!";
$lang['homepageurlmustincludeschema'] = "homep49E UrL MUs+ 1NCLUD3 h+TP:// sCh3M4.";
$lang['pictureurlmustincludeschema'] = "pIc+ur3 Url mU5T inCLuD3 HTtp:// sch3M@.";
$lang['avatarurlmustincludeschema'] = "av@+4R urL Must 1nclUD3 HTTp:// sCHEMa.";
$lang['postpage'] = "poS+ p49e";
$lang['nohtmltoolbar'] = "nO Html t0OlBAR";
$lang['displaysimpletoolbar'] = "diSpl4y \$1mplE html To0L8aR";
$lang['displaytinymcetoolbar'] = "d1\$pl@y wYsiwyg h+Ml Tool84r";
$lang['displayemoticonspanel'] = "dispL4y 3mO+iCons P4NeL";
$lang['displaysignature'] = "dI\$PL@y s1Gn4+ure";
$lang['disableemoticonsinpostsbydefault'] = "d1\$48le 3mo+ICoNs 1N m3SSA93S by DeF4Ul+";
$lang['automaticallyparseurlsbydefault'] = "aU+0M4+iC@Lly p4R53 urls in M3Ss49es 8Y dEF4ul+";
$lang['postinplaintextbydefault'] = "p0S+ In pl41n +3xt BY D3f4Ul+";
$lang['postinhtmlwithautolinebreaksbydefault'] = "po5+ in H+ML w1+H @UtO-l1N3-8RE4k\$ 8y D3f4ul+";
$lang['postinhtmlbydefault'] = "pO\$+ iN html BY D3FauLt";
$lang['privatemessageoptions'] = "pRIV4+3 me5\$@G3 op+10N\$";
$lang['privatemessageexportoptions'] = "pRiv@te mEssa9E 3xpor+ 0pt10ns";
$lang['savepminsentitems'] = "saVE @ cOpy opH e4ch pm I s3nD In my sEN+ I+3M\$ F0LD3R";
$lang['includepminreply'] = "include mess4ge 80dy wH3N r3Ply1ng +o pm";
$lang['autoprunemypmfoldersevery'] = "au+0 prune my pm ph0LDEr5 3v3ry:";
$lang['friendsonly'] = "frI3nD5 ONly?";
$lang['globalstyles'] = "gL08@l \$+yl3S";
$lang['forumstyles'] = "f0rum styl3S";
$lang['youmustenteryourcurrentpasswd'] = "j00 MU5+ eNter Y0ur cUrr3Nt p@ssw0RD";
$lang['youmustenteranewpasswd'] = "j00 mus+ EN+Er a NEw P@5\$w0RD";
$lang['youmustconfirmyournewpasswd'] = "j00 mUs+ conPhiRm Y0UR NEW p@ssw0rd";
$lang['profileentriesmustnotincludehtml'] = "prOFil3 3ntr1E\$ MU5+ n0T 1NClUD3 H+ML";
$lang['failedtoupdateuserprofile'] = "f4IL3d +O UPD4+3 u\$3r profiL3";

// Polls (create_poll.php, poll_results.php) ---------------------------------------------

$lang['mustprovideanswergroups'] = "j00 mu5+ proviD3 \$0m3 4N\$weR Gr0upS";
$lang['mustprovidepolltype'] = "j00 mU\$T prOviD3 4 p0ll typE";
$lang['mustprovidepollresultsdisplaytype'] = "j00 mUst proviDE rESUlts dIspl@y tyPE";
$lang['mustprovidepollvotetype'] = "j00 MU5t pROVid3 @ Poll v0t3 +YPE";
$lang['mustprovidepollguestvotetype'] = "j00 mu\$+ sPeC1FY Iph 9u3\$+s \$H0UlD B3 All0WeD +o V0tE";
$lang['mustprovidepolloptiontype'] = "j00 Mu\$+ pr0v1D3 A poLl oP+10N TYp3";
$lang['mustprovidepollchangevotetype'] = "j00 MU\$+ Pr0VId3 4 P0lL ch4ng3 V0t3 +yPE";
$lang['pollquestioncontainsinvalidhtml'] = "onE 0R MOr3 0ph Y0uR polL ques+i0N5 c0N+@1n\$ INV4LId H+ml.";
$lang['pleaseselectfolder'] = "pL345E \$eLECT 4 FOLD3R";
$lang['mustspecifyvalues1and2'] = "j00 mU\$T Sp3ciFY v@lu3S F0r 4n\$W3r5 1 4Nd 2";
$lang['tablepollmusthave2groups'] = "t4bul@r phorM@t p0Lls mu\$+ h4V3 pr3C1SElY tWo vO+INg 9ROUps";
$lang['nomultivotetabulars'] = "t4bul@R phormat p0Ll\$ C@Nn0+ B3 muL+1-v0T3";
$lang['nomultivotepublic'] = "pu8lic 8@Ll0+s C4nn0+ Be mUlTi-vO+3";
$lang['abletochangevote'] = "j00 w1Ll b3 48l3 to ch@nGe yoUr vo+3.";
$lang['abletovotemultiple'] = "j00 will 83 4BlE +0 Vo+3 multIpl3 +iMes.";
$lang['notabletochangevote'] = "j00 w1Ll n0+ 8E @8Le +0 CH4NG3 y0Ur v0te.";
$lang['pollvotesrandom'] = "n0+e: p0Ll v0tes @R3 r@ND0MlY 93n3r4t3D f0r PREv13w 0NlY.";
$lang['pollquestion'] = "poLL qU3ST10n";
$lang['possibleanswers'] = "p0SS18LE @nsw3rs";
$lang['enterpollquestionexp'] = "enT3R +he @nswEr5 Ph0R y0ur p0ll Qu35+i0n.. IF your p0ll 1s @ &quot;y3\$/nO&quot; quEst10n, s1Mply EN+3r &quot;yes&quot; PhoR 4NsweR 1 @nD &quot;no&quot; for 4n\$wEr 2.";
$lang['numberanswers'] = "nO. @nsw3r\$";
$lang['answerscontainHTML'] = "aN5W3RS c0n+4in h+ml (nOt inClUDIng \$IgnA+UrE)";
$lang['optionsdisplay'] = "an\$w3r\$ d1Spl4Y +yp3";
$lang['optionsdisplayexp'] = "h0W shouLD +eh AnSwERs bE PrESEN+3D?";
$lang['dropdown'] = "a\$ dr0P-Down l1\$+(s)";
$lang['radios'] = "a\$ 4 seRi3s 0PH raDi0 Bu++0nS";
$lang['votechanging'] = "vot3 chAnG1ng";
$lang['votechangingexp'] = "c4n @ pErs0N CH4N9E h1\$ oR h3r v0TE?";
$lang['guestvoting'] = "guE\$T votinG";
$lang['guestvotingexp'] = "cAN gu3Sts v0+3 in +h1S poLl?";
$lang['allowmultiplevotes'] = "aLL0W muLt1pl3 v0t3s";
$lang['pollresults'] = "p0lL rESUL+\$";
$lang['pollresultsexp'] = "hOw w0ULd j00 l1k3 TO D1\$PLAY t3H R3suLT5 oph Y0UR P0Ll?";
$lang['pollvotetype'] = "p0LL v0+1ng +ypE";
$lang['pollvotesexp'] = "h0w SHould Th3 polL 8E COnDUCT3D?";
$lang['pollvoteanon'] = "anOnyMoUsly";
$lang['pollvotepub'] = "pU8lic B@lLoT";
$lang['horizgraph'] = "hor1zoN+@l 9R@Ph";
$lang['vertgraph'] = "veR+1cal 9r@PH";
$lang['tablegraph'] = "t48ular Ph0rMa+";
$lang['polltypewarning'] = "<b>w4RN1N9</b>: +h15 is 4 pUBL1C 84llO+. yoUr nAme w1ll 8e visi8LE n3X+ to th3 0P+10n J00 vo+3 For.";
$lang['expiration'] = "exP1r4T10n";
$lang['showresultswhileopen'] = "dO J00 wanT +o show r3sUlt5 whIlE +3h P0lL 1S 0P3N?";
$lang['whenlikepollclose'] = "whEN woUlD j00 like youR P0Ll To 4utomat1cAlLy cL0SE?";
$lang['oneday'] = "one D@y";
$lang['threedays'] = "thRE3 d4Ys";
$lang['sevendays'] = "s3ven d4y5";
$lang['thirtydays'] = "thIR+y Day\$";
$lang['never'] = "n3v3R";
$lang['polladditionalmessage'] = "adD1+1on4l ME\$s4G3 (op+i0nal)";
$lang['polladditionalmessageexp'] = "d0 j00 w4Nt t0 1ncluD3 @n @DD1T1ON@l p0s+ afTer +H3 poLl?";
$lang['mustspecifypolltoview'] = "j00 mUst spEC1FY a polL T0 Vi3w.";
$lang['pollconfirmclose'] = "aRe j00 suR3 J00 w4Nt +o cL0\$E th3 PH0Ll0w1NG p0LL?";
$lang['endpoll'] = "eNd P0Ll";
$lang['nobodyvotedclosedpoll'] = "nO8ODy v0+3d";
$lang['votedisplayopenpoll'] = "%s 4nd %s H4vE v0+3d.";
$lang['votedisplayclosedpoll'] = "%s 4nD %s voteD.";
$lang['nousersvoted'] = "no us3Rs";
$lang['oneuservoted'] = "1 User";
$lang['xusersvoted'] = "%s u\$3rs";
$lang['noguestsvoted'] = "no gu3\$Ts";
$lang['oneguestvoted'] = "1 9uest";
$lang['xguestsvoted'] = "%s 9uE5+s";
$lang['pollhasended'] = "poLl H4\$ 3ndED";
$lang['youvotedforpolloptionsondate'] = "j00 votEd ph0R %s 0n %s";
$lang['thisisapoll'] = "thIs 1\$ 4 p0ll. cl1CK to V13w rEsUl+\$.";
$lang['editpoll'] = "eDiT POll";
$lang['results'] = "rE\$ults";
$lang['resultdetails'] = "r3Sult dE+4ils";
$lang['changevote'] = "ch@NGE v0+3";
$lang['pollshavebeendisabled'] = "p0lL\$ h4v3 8E3n d1S4BLED 8y +h3 f0RUM Own3r.";
$lang['answertext'] = "an5wEr +3X+";
$lang['answergroup'] = "anSw3R gRoUp";
$lang['previewvotingform'] = "pR3v13w VOting F0Rm";
$lang['viewbypolloption'] = "v13w By p0lL opT10n";
$lang['viewbyuser'] = "v1EW By u53r";

// Profiles (profile.php) ----------------------------------------------

$lang['editprofile'] = "ed1t pRofilE";
$lang['profileupdated'] = "pRoPHIlE UpD4TeD.";
$lang['profilesnotsetup'] = "th3 FoRuM 0wner HAs n0t se+ Up Pr0ph1lES.";
$lang['ignoreduser'] = "ign0r3d User";
$lang['lastvisit'] = "l@5+ v1\$IT";
$lang['userslocaltime'] = "u53r'S l0c@l T1M3";
$lang['userstatus'] = "sT4+u\$";
$lang['useractive'] = "oNl1ne";
$lang['userinactive'] = "iN4C+1V3 / OfpHliN3";
$lang['totaltimeinforum'] = "t0t@l t1me";
$lang['longesttimeinforum'] = "l0n9est se\$S1On";
$lang['sendemail'] = "sEnD em4Il";
$lang['sendpm'] = "seND pM";
$lang['visithomepage'] = "vi\$1+ h0M3P49e";
$lang['age'] = "a9e";
$lang['aged'] = "a93D";
$lang['birthday'] = "b1R+hD@y";
$lang['registered'] = "r391\$TER3d";
$lang['findpostsmadebyuser'] = "find po\$+s m4D3 by %s";
$lang['findpostsmadebyme'] = "f1ND p0STs m@D3 8Y m3";
$lang['profilenotavailable'] = "pr0f1l3 n0+ avA1L@8L3.";
$lang['userprofileempty'] = "th1s us3r H@\$ n0t ph1lled in +H31r pRoFile oR i+ 1S \$e+ +0 Pr1v@TE.";

// Registration (register.php) -----------------------------------------

$lang['newuserregistrationsarenotpermitted'] = "sOrry, new U\$ER r39iSTr4+i0n\$ @r3 N0t 4llowED ri9Ht noW. pl34\$e CHeCK 84ck L4+eR.";
$lang['usernameinvalidchars'] = "u\$3rn4M3 c@n onLy COn+4IN 4-Z, 0-9, _ - Ch4R4CTeR\$";
$lang['usernametooshort'] = "uSern4M3 MUs+ B3 @ minImUm oPh 2 CH4RaC+3r\$ long";
$lang['usernametoolong'] = "u\$3RNamE Mu\$T 8e 4 m4x1MuM 0f 15 ch@r4c+3r\$ LOn9";
$lang['usernamerequired'] = "a LogOn n@m3 1S ReQuIr3D";
$lang['passwdmustnotcontainHTML'] = "p4s\$woRD mUs+ no+ C0n+4In h+ml +@G\$";
$lang['passwordinvalidchars'] = "p4sSW0rd c4n 0NLY CoN+@1N 4-Z, 0-9, _ - ChaR4CTErs";
$lang['passwdtooshort'] = "pAs\$W0rd mU\$+ B3 4 miN1MUm opH 6 ch@r@C+ER\$ Lon9";
$lang['passwdrequired'] = "a P4Ssword i\$ reqUirED";
$lang['confirmationpasswdrequired'] = "a c0nf1RM@+i0N P4\$\$WOrd I\$ r3QuIrEd";
$lang['nicknamerequired'] = "a NIckN@m3 1s r3qU1reD";
$lang['emailrequired'] = "an 3M@Il @DDr3\$\$ is REqU1R3d";
$lang['passwdsdonotmatch'] = "p4SSWord5 Do no+ M4+CH";
$lang['usernamesameaspasswd'] = "u\$ErN@m3 4nD p45\$w0rD mu5+ 8e d1PHph3REn+";
$lang['usernameexists'] = "s0rry, 4 u\$Er w1+h tH4t NaME 4lrE4dy 3x1s+s";
$lang['successfullycreateduseraccount'] = "succ35\$PhulLy CR3@+3d Us3R @CCOUnt";
$lang['useraccountcreatedconfirmfailed'] = "yoUr us3r 4cCoun+ h4S 8e3N cre4T3D BUT tEh r3QU1R3D COnPhirM@+i0N Ema1L was n0T seNt. plE4\$E cOnt4C+ +3h f0RUm 0WnEr +0 r3C+1pHY +h1S. 1n +h1\$ M3@n+1M3 PLE453 cliCk T3h C0N+inUE BU+t0n t0 Lo91n IN.";
$lang['useraccountcreatedconfirmsuccess'] = "yoUr User 4CCoun+ h4\$ 8e3N cRE4+3d bU+ BEPhoRe j00 c4n \$t4Rt po5+1ng J00 mU5+ ConPH1RM y0UR Ema1L 4ddr3\$\$. pl3aSE ChECK Y0Ur EMa1l For @ link Th4+ w1LL 4lLow J00 +o C0NPhIrm y0ur AddR3ss.";
$lang['useraccountcreated'] = "yoUr User 4CC0UNT h4\$ B3En Cr3@+3D sUCcEssphUlly! Cl1ck tH3 COnT1nU3 8u+t0N bEL0w T0 l091N";
$lang['errorcreatinguserrecord'] = "erR0r cr3@+1nG User rECORD";
$lang['userregistration'] = "u\$3r R39iStr4TioN";
$lang['registrationinformationrequired'] = "r391StR4tiOn Inf0rmAT10N (r3qu1R3D)";
$lang['profileinformationoptional'] = "pRophil3 1nf0RM4T10n (opT10NAL)";
$lang['preferencesoptional'] = "pr3pherEnC35 (0p+i0n@l)";
$lang['register'] = "rEgis+er";
$lang['rememberpasswd'] = "reMEm83R p@\$SW0RD";
$lang['birthdayrequired'] = "y0ur d@+E opH Bir+H I\$ r3qUireD 0R 1s 1nv@l1D";
$lang['alwaysnotifymeofrepliestome'] = "nO+1phy on ReplY t0 m3";
$lang['notifyonnewprivatemessage'] = "no+1phy 0n N3w PriVate m3sS49E";
$lang['popuponnewprivatemessage'] = "pop UP 0n nEW priv@+E m3Ss49e";
$lang['automatichighinterestonpost'] = "au+0m@+ic H1Gh In+Er3ST 0n p05+";
$lang['confirmpassword'] = "cONPhirM p4\$sworD";
$lang['invalidemailaddressformat'] = "inV4LID 3m41l @dDr3SS pH0Rm4+";
$lang['moreoptionsavailable'] = "m0R3 PRof1l3 aNd Prefer3NcE 0P+i0n\$ 4R3 4V4ilABL3 0nCE j00 rE91stEr";
$lang['textcaptchaconfirmation'] = "c0Nphirmat10n";
$lang['textcaptchaexplain'] = "to t3h rIghT is @ tEx+-c4ptcH@ im@Ge. pLEaSE +yp3 +Eh C0dE j00 C@N s3e in +H3 im@gE In+0 ThE inpUt F13ld 8ElOw I+.";
$lang['textcaptchaimgtip'] = "th1s 1s @ C4ptCH@-p1CtUr3. 1T i\$ U53d +0 pr3vENT 4ut0M4tiC RE91\$+r4T10n";
$lang['textcaptchamissingkey'] = "a COnphirM@+i0n c0de 1\$ rEqUIreD.";
$lang['textcaptchaverificationfailed'] = "tExT-C4ptch4 v3rIFIC@+10N c0dE w@s inC0rrEct. pLE4\$3 R3-EnteR I+.";
$lang['forumrules'] = "foRUm rUlEs";
$lang['forumrulesnotification'] = "iN ord3R t0 pR0C33d, j00 musT 4gr3E wI+h tEh pHoll0w1n9 ruLEs";
$lang['forumrulescheckbox'] = "i H4V3 R3ad, @ND 4GRE3 to A8IDE 8Y +eH pH0Rum Rules.";
$lang['youmustagreetotheforumrules'] = "j00 mu5+ 49re3 +O thE F0rUm RUlES 8EPhOrE j00 CAn C0N+Inu3.";

// Recent visitors list  (visitor_log.php) -----------------------------

$lang['member'] = "m3M83r";
$lang['searchforusernotinlist'] = "se@RCh f0R 4 uS3r n0+ In l1ST";
$lang['yoursearchdidnotreturnanymatches'] = "y0uR sE4RCh D1d no+ REtUrN 4nY m4+Ch3s. Try s1MpliFying yoUr \$34rcH p4r4ME+Ers 4ND tRy a9@in.";
$lang['hiderowswithemptyornullvalues'] = "hIde roWs wi+h EMptY 0R nUll valU3s In \$3l3C+ED c0lUmn5";
$lang['showregisteredusersonly'] = "shOw regIS+3RED UsERs 0nLY (h1d3 9U3st\$)";

// Relationships (user_rel.php) ----------------------------------------

$lang['relationships'] = "rEl@t10n5hip5";
$lang['userrelationship'] = "u53r R3l4+1ONsh1p";
$lang['userrelationships'] = "u\$3r REL4+i0N\$H1PS";
$lang['failedtoremoveselectedrelationships'] = "fa1l3D TO R3mov3 \$el3C+eD R3L4+i0N\$hip";
$lang['friends'] = "fri3NDS";
$lang['ignoredcompletely'] = "ignoR3d coMpL3TElY";
$lang['relationship'] = "rEl4+10n\$h1P";
$lang['restorenickname'] = "reSt0RE user's niCKn@m3";
$lang['friend_exp'] = "user's po\$+s m@rk3d w1+h 4 &quot;fR13ND&quot; icON.";
$lang['normal_exp'] = "u\$3R'\$ p0sts 4pp3@R 4\$ n0rm4L.";
$lang['ignore_exp'] = "u\$3r'S PO5+s 4r3 h1DD3n.";
$lang['ignore_completely_exp'] = "thR34DS 4nd p05+s +o Or from Us3R w1LL @pPE4r d3LEtED.";
$lang['display'] = "di\$pl4y";
$lang['displaysig_exp'] = "user'\$ \$I9n4+UR3 i\$ D1SPl4y3D 0n +h3Ir pOst5.";
$lang['hidesig_exp'] = "u\$3R'\$ SIGn4+urE i\$ HidD3N 0n +h3Ir posts.";
$lang['cannotignoremod'] = "j00 C4nnot i9nore +h15 usER, 4s ThEy @re 4 mod3R4+Or.";
$lang['previewsignature'] = "prEv13w s1Gn4+uRE";

// Search (search.php) -------------------------------------------------

$lang['searchresults'] = "sE4RCH r35ul+s";
$lang['usernamenotfound'] = "t3H usErN@ME J00 Sp3C1pHI3d 1n t3h +0 oR from PhI3LD w@\$ N0+ ph0UNd.";
$lang['notexttosearchfor'] = "onE 0r 4ll of yoUr \$3@rch K3yw0RDS w3RE Inv4lid. \$34rCH keYw0rd\$ MU5+ B3 n0 shoRtEr +h4N %d CH4R4C+eR\$, no l0N93R th4n %d CHar4c+ERs 4nD mUsT no+ @pPE4r IN +H3 %s";
$lang['keywordscontainingerrors'] = "kEyw0rd5 ConT41N1ng 3rRORs: %s";
$lang['mysqlstopwordlist'] = "mYsql sTOPworD lI\$+";
$lang['foundzeromatches'] = "f0UnD: 0 M@tCh3S";
$lang['found'] = "fouND";
$lang['matches'] = "m4TCh3S";
$lang['prevpage'] = "pR3v10us PA93";
$lang['findmore'] = "fInd morE";
$lang['searchmessages'] = "sE4rch M35S@g3s";
$lang['searchdiscussions'] = "s34rch Di\$cUSSi0n\$";
$lang['find'] = "f1nd";
$lang['additionalcriteria'] = "addition@l cri+Er14";
$lang['searchbyuser'] = "sE@rch By u\$ER (0pT10N4L)";
$lang['folderbrackets_s'] = "f0ld3R(\$)";
$lang['postedfrom'] = "poS+eD phRom";
$lang['postedto'] = "p0\$+eD +0";
$lang['today'] = "today";
$lang['yesterday'] = "y3SteRD@y";
$lang['daybeforeyesterday'] = "d4Y BEFOrE yest3rd4Y";
$lang['weekago'] = "%s We3k 4GO";
$lang['weeksago'] = "%s Week5 A90";
$lang['monthago'] = "%s MoNth 4G0";
$lang['monthsago'] = "%s m0N+hs 490";
$lang['yearago'] = "%s ye4r @90";
$lang['beginningoftime'] = "bE9InN1Ng 0f +1m3";
$lang['now'] = "now";
$lang['lastpostdate'] = "l@5+ p0S+ DAtE";
$lang['numberofreplies'] = "nUm8ER oF repli3S";
$lang['foldername'] = "foLD3R namE";
$lang['authorname'] = "aU+hOR NAmE";
$lang['decendingorder'] = "n3w3\$t F1r\$+";
$lang['ascendingorder'] = "olDEs+ PH1rs+";
$lang['keywords'] = "keYW0rdS";
$lang['sortby'] = "s0R+ 8Y";
$lang['sortdir'] = "soR+ D1R";
$lang['sortresults'] = "s0R+ rE\$ulTS";
$lang['groupbythread'] = "gr0UP 8y +HR34D";
$lang['postsfromuser'] = "pO5t5 phR0m U\$3R";
$lang['poststouser'] = "p0STs tO U\$er";
$lang['poststoandfromuser'] = "p0\$TS tO 4nD fRom usEr";
$lang['searchfrequencyerror'] = "j00 C4n 0nlY s3ARcH onCe 3VeRY %s s3COnDs. pleasE tRy aG4In L4+3R.";
$lang['searchsuccessfullycompleted'] = "s34rCH sUcC3S\$FullY c0MPl3T3d. %s";
$lang['clickheretoviewresults'] = "clICk heRe T0 V13w resuL+s.";

// Search Popup (search_popup.php) -------------------------------------

$lang['select'] = "sELect";
$lang['searchforthread'] = "se@Rch for tHr34D";
$lang['mustspecifytypeofsearch'] = "j00 mu\$T \$PeC1Fy Typ3 0ph sEarch T0 PErFOrm";
$lang['unkownsearchtypespecified'] = "uNKnown 534rCh +YpE 5pEcifIEd";
$lang['mustentersomethingtosearchfor'] = "j00 Mus+ eN+3R 50m3Thing to \$34rch F0r";

// Start page (start_left.php) -----------------------------------------

$lang['recentthreads'] = "reC3n+ thRE4ds";
$lang['startreading'] = "s+4r+ r34d1N9";
$lang['threadoptions'] = "thr3aD 0pt10NS";
$lang['editthreadoptions'] = "ediT thRE4D opT1ons";
$lang['morevisitors'] = "mOR3 V1s1+0rs";
$lang['forthcomingbirthdays'] = "f0rTHC0MINg BirtHD4ys";

// Start page (start_main.php) -----------------------------------------

$lang['editstartpage_help'] = "j00 CaN 3DiT +h1\$ p@g3 fr0M Th3 @DM1n inT3Rf4cE";

// Thread navigation (thread_list.php) ---------------------------------

$lang['newdiscussion'] = "n3w Di\$cussiON";
$lang['createpoll'] = "cr34+e polL";
$lang['search'] = "s3ArCh";
$lang['searchagain'] = "se4rch 49@iN";
$lang['alldiscussions'] = "all D15Cu\$si0n\$";
$lang['unreaddiscussions'] = "uNR34d di5CU\$S1ons";
$lang['unreadtome'] = "uNre4D &quot;T0: mE&quot;";
$lang['todaysdiscussions'] = "t0d4y'\$ disCUss1on\$";
$lang['2daysback'] = "2 d4y5 84CK";
$lang['7daysback'] = "7 d4Y\$ b@CK";
$lang['highinterest'] = "hi9h 1n+er3st";
$lang['unreadhighinterest'] = "uNr34d h1GH 1N+3res+";
$lang['iverecentlyseen'] = "i've REC3n+ly \$eEn";
$lang['iveignored'] = "i'VE 19NOReD";
$lang['byignoredusers'] = "bY 19nor3D user\$";
$lang['ivesubscribedto'] = "i'v3 sU8\$crI83d +o";
$lang['startedbyfriend'] = "st4rteD 8y pHriEND";
$lang['unreadstartedbyfriend'] = "uNR3ad std 8y pHri3nd";
$lang['startedbyme'] = "s+4r+Ed By M3";
$lang['unreadtoday'] = "uNre4D Tod4y";
$lang['deletedthreads'] = "dEl3tEd +hre4d\$";
$lang['goexcmark'] = "g0!";
$lang['folderinterest'] = "f0ld3r in+er35t";
$lang['postnew'] = "p0St NEw";
$lang['currentthread'] = "curR3nt thR3ad";
$lang['highinterest'] = "h1Gh InTEr3st";
$lang['markasread'] = "m4Rk 4s rE@D";
$lang['next50discussions'] = "n3Xt 50 DI\$cussi0n\$";
$lang['visiblediscussions'] = "vIS18le DIsCus\$10N\$";
$lang['selectedfolder'] = "s3L3c+3D phoLDEr";
$lang['navigate'] = "n@vI94+E";
$lang['couldnotretrievefolderinformation'] = "tH3re 4r3 No f0LDer\$ @V4Il4BlE.";
$lang['nomessagesinthiscategory'] = "n0 me5\$4GEs in th1S c4+390ry. pLEase 53l3C+ @Noth3R, or %s ph0r 4lL thRE4D\$";
$lang['clickhere'] = "cl1ck HeR3";
$lang['prev50threads'] = "pRevi0Us 50 +hr34ds";
$lang['next50threads'] = "n3Xt 50 THRE4ds";
$lang['nextxthreads'] = "neXt %s +hr34ds";
$lang['threadstartedbytooltip'] = "thRe4D #%s s+4rt3D 8y %s. v13WED %s";
$lang['threadviewedonetime'] = "1 +IME";
$lang['threadviewedtimes'] = "%d times";
$lang['unreadthread'] = "unR34D +hr34d";
$lang['readthread'] = "re@D +Hr34d";
$lang['unreadmessages'] = "uNr34D m3sSA93\$";
$lang['subscribed'] = "su8SCRi8Ed";
$lang['ignorethisfolder'] = "ign0re tHi\$ PHoldEr";
$lang['stopignoringthisfolder'] = "st0P 1Gn0r1NG +h1\$ fOLDER";
$lang['stickythreads'] = "s+iCky thre4D\$";
$lang['mostunreadposts'] = "mOs+ unR3@D p0S+\$";
$lang['onenew'] = "%d NEw";
$lang['manynew'] = "%d NEW";
$lang['onenewoflength'] = "%d N3w 0f %d";
$lang['manynewoflength'] = "%d N3w 0f %d";
$lang['ignorefolderconfirm'] = "are j00 \$Ur3 J00 w4Nt +0 19Nore +h1\$ Ph0LDER?";
$lang['unignorefolderconfirm'] = "aRe j00 \$Ur3 j00 W4N+ TO \$+0p 19N0r1n9 +his F0lDEr?";
$lang['confirmmarkasread'] = "aRe j00 \$URE j00 W4n+ to m@Rk The sELEC+3d thrE4D\$ 4S r3@d?";
$lang['successfullymarkreadselectedthreads'] = "succEs5phuLlY m4RkED \$3l3C+ED thrE4d\$ as R34D";
$lang['failedtomarkselectedthreadsasread'] = "f@1LED +0 mark \$3lec+3d +hR3@Ds 4s REaD";
$lang['gotofirstpostinthread'] = "g0 t0 phirS+ p0s+ IN +Hr34D";
$lang['gotolastpostinthread'] = "g0 +0 l4\$T pO\$T IN +HR3AD";
$lang['viewmessagesinthisfolderonly'] = "v13w Mes5a9eS 1n +his FOlD3r ONly";
$lang['shownext50threads'] = "sHOW n3X+ 50 +hr34d\$";
$lang['showprev50threads'] = "sH0W pREv10US 50 +hr34D\$";
$lang['createnewdiscussioninthisfolder'] = "cR3ate nEw DiscU5\$10n 1n +H1\$ f0lD3r";
$lang['nomessages'] = "nO mesS4ges";

// HTML toolbar (htmltools.inc.php) ------------------------------------
$lang['bold'] = "boLD";
$lang['italic'] = "i+@lic";
$lang['underline'] = "und3RLin3";
$lang['strikethrough'] = "s+r1Kethr0u9h";
$lang['superscript'] = "suP3r\$CR1p+";
$lang['subscript'] = "su8SCr1P+";
$lang['leftalign'] = "lEFT-4l19n";
$lang['center'] = "c3n+ER";
$lang['rightalign'] = "riGH+-4l1gn";
$lang['numberedlist'] = "nUM83REd lIst";
$lang['list'] = "l1S+";
$lang['indenttext'] = "ind3n+ +Ext";
$lang['code'] = "cOde";
$lang['quote'] = "qU0t3";
$lang['spoiler'] = "sP01L3R";
$lang['horizontalrule'] = "hOR1zon+@l Rule";
$lang['image'] = "im49e";
$lang['hyperlink'] = "hYPErl1Nk";
$lang['noemoticons'] = "diS48lE 3M0T1c0n\$";
$lang['fontface'] = "foN+ ph@CE";
$lang['size'] = "s1ZE";
$lang['colour'] = "cOl0ur";
$lang['red'] = "rEd";
$lang['orange'] = "oR4ng3";
$lang['yellow'] = "yEll0w";
$lang['green'] = "grE3n";
$lang['blue'] = "bLu3";
$lang['indigo'] = "iNd1GO";
$lang['violet'] = "vI0lEt";
$lang['white'] = "wH1T3";
$lang['black'] = "bL@Ck";
$lang['grey'] = "greY";
$lang['pink'] = "piNK";
$lang['lightgreen'] = "lIght 9R3eN";
$lang['lightblue'] = "l1Ght 8lu3";

// Forum Stats (messages.inc.php - messages_forum_stats()) -------------

$lang['forumstats'] = "foRUm sT4+s";
$lang['usersactiveinthepasttimeperiod'] = "%s @c+1v3 1n +HE pAs+ %s. %s";

$lang['numactiveguests'] = "<b>%s</b> gu3sts";
$lang['oneactiveguest'] = "<b>1</b> 9uEst";
$lang['numactivemembers'] = "<b>%s</b> memB3rs";
$lang['oneactivemember'] = "<b>1</b> M3m83r";
$lang['numactiveanonymousmembers'] = "<b>%s</b> 4N0nYmouS Mem8ers";
$lang['oneactiveanonymousmember'] = "<b>1</b> @N0NYmous M3mB3R";

$lang['numthreadscreated'] = "<b>%s</b> +hr3aDs";
$lang['onethreadcreated'] = "<b>1</b> +HREaD";
$lang['numpostscreated'] = "<b>%s</b> po5ts";
$lang['onepostcreated'] = "<b>1</b> p0st";

$lang['younormal'] = "j00";
$lang['youinvisible'] = "j00 (iNVISi8L3)";
$lang['viewcompletelist'] = "v13w COmPlEtE l1ST";
$lang['ourmembershavemadeatotalofnumthreadsandnumposts'] = "oUr memBErs h4vE m4D3 4 t0+4l 0Ph %s 4nD %s.";
$lang['longestthreadisthreadnamewithnumposts'] = "lON9Est THre4D 1s <b>%s</b> W1+H %s.";
$lang['therehavebeenxpostsmadeinthelastsixtyminutes'] = "tHer3 h4V3 8E3n <b>%s</b> pos+s m@dE iN tH3 l@5+ 60 m1NUt3s.";
$lang['therehasbeenonepostmadeinthelastsxityminutes'] = "tH3Re h@S 83En <b>1</b> p05+ m@D3 in +He l4ST 60 M1NU+3s.";
$lang['mostpostsevermadeinasinglesixtyminuteperiodwasnumposts'] = "mo5t pOS+s 3V3r m@d3 1n A \$in9LE 60 miNU+3 p3r10D is <b>%s</b> On %s.";
$lang['wehavenumregisteredmembersandthenewestmemberismembername'] = "wE have <b>%s</b> R391\$TErED m3M83r\$ @ND th3 newesT m3mBer i\$ <b>%s</b>.";
$lang['wehavenumregisteredmember'] = "wE h@ve %s r391\$+Er3D mem83rs.";
$lang['wehaveoneregisteredmember'] = "w3 h4v3 0N3 r391S+er3d mEmBER.";
$lang['mostuserseveronlinewasnumondate'] = "moS+ usErs 3veR OnliN3 w4s <b>%s</b> 0N %s.";
$lang['statsdisplaychanged'] = "sTat\$ DispL4y CH4N93D";

// Thread Options (thread_options.php) ---------------------------------

$lang['updatessavedsuccessfully'] = "uPda+es s4V3D sUCC3ssFULly";
$lang['useroptions'] = "u\$3r 0ption\$";
$lang['markedasread'] = "m4RK3D 45 re4D";
$lang['postsoutof'] = "pOSTs 0UT of";
$lang['interest'] = "iN+ErE\$T";
$lang['closedforposting'] = "cloSED for po\$T1ng";
$lang['locktitleandfolder'] = "lOck +i+l3 4nd pHolDEr";
$lang['deletepostsinthreadbyuser'] = "d3le+3 p05+s in +hre4d 8y UsEr";
$lang['deletethread'] = "d3L3+E +hr3AD";
$lang['permenantlydelete'] = "peRm4N3ntlY D3l3t3";
$lang['movetodeleteditems'] = "mov3 T0 D3L3t3D thRE4D\$";
$lang['undeletethread'] = "uNdel3+e tHr3aD";
$lang['threaddeletedpermenantly'] = "tHread D3lEtED pERm4N3Ntly. C@nN0+ unD3lete.";
$lang['markasunread'] = "m@rk as uNrE4D";
$lang['makethreadsticky'] = "m@K3 +hrEaD st1CKy";
$lang['threareadstatusupdated'] = "thre@d rE@D \$TatUs UpD@+3D sUCCEssfUllY";
$lang['interestupdated'] = "thRE4d in+Er3ST s+A+U5 upD@+3D sUCCe\$sfUlly";
$lang['failedtoupdatethreadreadstatus'] = "fa1Led +o UPd4+e +hre4D r3@D st4TUs";
$lang['failedtoupdatethreadinterest'] = "faIlED to upd4+3 +hr34d in+Er3st";
$lang['failedtorenamethread'] = "fAil3D +0 r3N@mE thRe4d";
$lang['failedtomovethread'] = "f@Il3D +o m0ve +hr34d To sP3C1f13d f0ldER";
$lang['failedtoupdatethreadstickystatus'] = "f4Il3d +0 upD4+3 +hrE4D s+ICKy StA+us";
$lang['failedtoupdatethreadclosedstatus'] = "f4Il3d +0 UpD@T3 +hR34D ClOseD s+4tus";
$lang['failedtoupdatethreadlockstatus'] = "fAil3D +0 uPD4T3 +hr34D locK \$T4+us";
$lang['failedtodeletepostsbyuser'] = "f4iLED +0 DEL3te pOs+s By \$3leCTED usER";
$lang['failedtodeletethread'] = "f4Il3D To DEl3Te tHr34d.";
$lang['failedtoundeletethread'] = "f41lEd +0 uN-D3leTE thrE4D";

// Dictionary (dictionary.php) -----------------------------------------

$lang['dictionary'] = "dICT10n@ry";
$lang['spellcheck'] = "sp3ll ch3CK";
$lang['notindictionary'] = "n0t 1n DiCt10N@Ry";
$lang['changeto'] = "ch4n93 tO";
$lang['restartspellcheck'] = "re\$+4r+";
$lang['cancelchanges'] = "c@NceL Ch4n9ES";
$lang['initialisingdotdotdot'] = "in1t1@li\$ing...";
$lang['spellcheckcomplete'] = "sPEll ch3ck 1\$ CoMPl3t3. to r3\$+4rt sp3ll Ch3CK Cl1CK r3St4RT 8uTton BElow.";
$lang['spellcheck'] = "spell Ch3Ck";
$lang['noformobj'] = "no Ph0Rm 0BJECT sp3CIFiED Ph0r rEtUrN t3Xt";
$lang['bodytext'] = "b0dy +3Xt";
$lang['ignore'] = "i9n0rE";
$lang['ignoreall'] = "i9N0R3 4ll";
$lang['change'] = "ch@n9E";
$lang['changeall'] = "cHaN9e 4Ll";
$lang['add'] = "adD";
$lang['suggest'] = "sUGGEst";
$lang['nosuggestions'] = "(n0 \$uGGEs+10N5)";
$lang['cancel'] = "c@Ncel";
$lang['dictionarynotinstalled'] = "n0 diCt10N4ry h4S B3en ins+4Ll3D. pL3@\$3 coN+@ct thE pHorum 0WNer +0 r3m3dy +hIs.";

// Permissions keys ----------------------------------------------------

$lang['postreadingallowed'] = "pO5+ R34ding @lLow3d";
$lang['postcreationallowed'] = "pO\$t CrE4+i0n aLlowED";
$lang['threadcreationallowed'] = "thr34d cR3AT1on @Llow3D";
$lang['posteditingallowed'] = "p05+ eDIt1Ng 4llOwED";
$lang['postdeletionallowed'] = "poSt D3LEt10n all0WeD";
$lang['attachmentsallowed'] = "a++4chm3nt\$ @LloWeD";
$lang['htmlpostingallowed'] = "h+ml p0S+1N9 4LL0W3D";
$lang['signatureallowed'] = "si9n4+URe 4LLOw3D";
$lang['guestaccessallowed'] = "gu3St 4CCES5 ALLowED";
$lang['postapprovalrequired'] = "p0\$t @pPr0V@l r3QUir3d";

// RSS feeds gubbins

$lang['rssfeed'] = "rsS Feed";
$lang['every30mins'] = "eVERy 30 MInu+3S";
$lang['onceanhour'] = "onCe aN h0uR";
$lang['every6hours'] = "ev3RY 6 h0uRS";
$lang['every12hours'] = "eVery 12 H0URs";
$lang['onceaday'] = "once 4 Day";
$lang['rssfeeds'] = "r5s FE3ds";
$lang['feedname'] = "f33d n4M3";
$lang['feedfoldername'] = "fe3d f0LDeR n@M3";
$lang['feedlocation'] = "f33D l0Cat1on";
$lang['threadtitleprefix'] = "tHREaD +i+Le pReph1X";
$lang['feednameandlocation'] = "fe3d N4M3 4nD l0C4+i0N";
$lang['feedsettings'] = "fe3d seTt1ngs";
$lang['updatefrequency'] = "upd4+3 phrEqU3NCy";
$lang['rssclicktoreadarticle'] = "cl1Ck h3R3 to RE4D +His 4rT1Cle";
$lang['addnewfeed'] = "aDD n3W pheED";
$lang['editfeed'] = "eDIT Fe3D";
$lang['feeduseraccount'] = "fe3d u\$ER aCC0unt";
$lang['noexistingfeeds'] = "nO 3XI\$+1ng rss fE3D5 pHOUND. +O @DD 4 f33d Cl1ck The '4DD n3W' 8ut+ON B3low";
$lang['rssfeedhelp'] = "h3r3 J00 C@n seTuP s0M3 r\$s F33Ds pH0R @uToM4+1c propa94+i0N int0 Y0ur phOrUm. +h3 1+3ms From +hE rss phe3ds j00 aDD wilL BE CR3AtED 4S +hRE@Ds WhicH UsERs C4n REPLy to As 1ph +hEY wERE n0RM4l p0s+s. the r\$s fe3D mu\$t 83 4CCEss1BLE vi@ H++p or 1+ w1Ll Not worK.";
$lang['mustspecifyrssfeedname'] = "mUsT sp3cify rSS fe3D n4m3";
$lang['mustspecifyrssfeeduseraccount'] = "mU5T speC1fY rss phe3D u\$3r @CC0UnT";
$lang['mustspecifyrssfeedfolder'] = "mU\$+ sp3C1PHy Rss FEED ph0lder";
$lang['mustspecifyrssfeedurl'] = "mu\$+ spEC1phy r\$S f3ED Url";
$lang['mustspecifyrssfeedupdatefrequency'] = "mu\$T \$p3C1phY rs\$ Ph3eD UPdatE Fr3Qu3NCY";
$lang['unknownrssuseraccount'] = "unKN0wn RSs useR @CC0un+";
$lang['rssfeedsupportshttpurlsonly'] = "rs\$ F3ed sUppoR+s http Url5 only. seCUrE phE3Ds (h++p\$://) arE No+ 5UPpor+3D.";
$lang['rssfeedurlformatinvalid'] = "rSs PH3ed url ForMat is inv4l1d. Url mu5+ inCLUdE sCh3me (3.g. HTtp://) @nD @ h05+n4mE (E.9. Www.ho\$tn4M3.com).";
$lang['rssfeeduserauthentication'] = "r\$\$ FEeD Do3S n0+ 5Upp0rt ht+p u53R @u+H3Nt1c4T10n";
$lang['successfullyremovedselectedfeeds'] = "sUCCes\$phUlly rEMov3d \$3leC+3D F33DS";
$lang['successfullyaddedfeed'] = "suCC3s5phully @DD3d nEw fE3D";
$lang['successfullyeditedfeed'] = "succ3SsFully ED1teD ph3ED";
$lang['failedtoremovefeeds'] = "f4Il3d +0 rem0V3 S0m3 0R 4lL Of th3 \$EL3c+ED pH3ED5";
$lang['failedtoaddnewrssfeed'] = "f41lEd +0 4DD nEW r5S fEED";
$lang['failedtoupdaterssfeed'] = "f4IlED +o upD4T3 r5\$ F3ED";
$lang['rssstreamworkingcorrectly'] = "rSs \$+rE4m 4pp3@r\$ +0 BE wOrKinG C0rr3C+lY";
$lang['rssstreamnotworkingcorrectly'] = "rsS Stre4m w@s 3Mpty 0r c0uld n0T B3 phoUnD";
$lang['invalidfeedidorfeednotfound'] = "inv4L1D phE3d ID Or fE3D n0+ phounD";

// PM Export Options

$lang['pmexportastype'] = "eXPor+ 4\$ +Yp3";
$lang['pmexporthtml'] = "h+mL";
$lang['pmexportxml'] = "xml";
$lang['pmexportplaintext'] = "pl@In +3X+";
$lang['pmexportmessagesas'] = "eXP0rt mEs\$4ge\$ @\$";
$lang['pmexportonefileforallmessages'] = "one phil3 f0r 4ll M3ss49es";
$lang['pmexportonefilepermessage'] = "oN3 f1l3 p3r m3S549E";
$lang['pmexportattachments'] = "exP0Rt 4+taChMEN+5";
$lang['pmexportincludestyle'] = "iNcluD3 F0RuM \$+yl3 sh3Et";
$lang['pmexportwordfilter'] = "apply w0Rd FiL+3r +0 mesS49ES";

// Thread merge / split options

$lang['threadhasbeensplit'] = "thre4d H4S B33n \$PLI+";
$lang['threadhasbeenmerged'] = "thREAD H4S 83EN m3r93D";
$lang['mergesplitthread'] = "mEr93 / SPLi+ +hR3AD";
$lang['mergewiththreadid'] = "meR93 With THRE4d iD:";
$lang['postsinthisthreadatstart'] = "p05+S In +His +hrE4D @+ \$+4rt";
$lang['postsinthisthreadatend'] = "p05+s iN +h1\$ +hr34D at EnD";
$lang['reorderpostsintodateorder'] = "r3-orD3R poS+s INt0 d4+e orDER";
$lang['splitthreadatpost'] = "sPLi+ +hr3@d 4+ p0ST:";
$lang['selectedpostsandrepliesonly'] = "s3L3C+ed p0s+ 4ND r3pliEs 0nly";
$lang['selectedandallfollowingposts'] = "s3LECt3d @ND 4lL PhoLl0WIng Po\$Ts";

$lang['threadmovedhere'] = "h3r3";

$lang['thisthreadhasmoved'] = "<b>thR34ds m3R9ED:</b> +h1s +hrEaD H4S m0vED %s";
$lang['thisthreadwasmergedfrom'] = "<b>thR3ads mErg3d:</b> Thi5 thrEaD wAs mer9ED phRom %s";
$lang['somepostsinthisthreadhavebeenmoved'] = "<b>tHr3ad spl1+:</b> s0m3 po\$Ts iN +His +hR34d H4v3 BEEN m0veD %s";
$lang['somepostsinthisthreadweremovedfrom'] = "<b>thR34d \$pli+:</b> \$0m3 p0st\$ IN +h1s +HreaD w3Re m0V3D Phrom %s";

$lang['thisposthasbeenmoved'] = "<b>thR34d 5Pl1+:</b> Th1\$ p0s+ H@\$ 8EeN m0V3D %s";

$lang['invalidfunctionarguments'] = "iNValiD fUNCT10N arGUmEnt\$";
$lang['couldnotretrieveforumdata'] = "couLD no+ rETr13ve F0RUm DA+4";
$lang['cannotmergepolls'] = "oNE 0r morE +hR3AD\$ 1\$ @ p0lL. j00 C@nnot merGE poLL\$";
$lang['couldnotretrievethreaddatamerge'] = "c0uLD N0T retriEv3 +hRE4d D4T@ Fr0m on3 0R m0rE +hr34Ds";
$lang['couldnotretrievethreaddatasplit'] = "coulD n0+ REtrIevE ThREaD d4+4 Phrom soURCE tHRE4D";
$lang['couldnotretrievepostdatamerge'] = "could n0T re+Ri3v3 p0sT D4ta Fr0M 0n3 0R more tHrE4d5";
$lang['couldnotretrievepostdatasplit'] = "c0uld not r3tr13ve po5+ D@+4 fr0m s0URCE tHR34d";
$lang['failedtocreatenewthreadformerge'] = "f4IlED +o CrEAtE nEW +hr3@D pH0r m3Rg3";
$lang['failedtocreatenewthreadforsplit'] = "fa1leD +0 Cre4T3 n3w THre4d ph0R spl1+";

// Thread subscriptions

$lang['threadsubscriptions'] = "tHre@D sU85CRIp+ion5";
$lang['couldnotupdateinterestonthread'] = "c0ULd n0+ UpD4+3 inter3ST 0n ThreaD '%s'";
$lang['threadinterestsupdatedsuccessfully'] = "tHre4D 1nter3Sts upD4+3D suCC3ssfully";
$lang['nothreadsubscriptions'] = "j00 @R3 no+ SuBSCri8ed +o 4ny +hR34d\$.";
$lang['resetselected'] = "rESEt sEl3c+3D";
$lang['allthreadtypes'] = "alL +Hr34d tYpEs";
$lang['ignoredthreads'] = "iGnored +Hr34d5";
$lang['highinterestthreads'] = "h1GH intEr3\$T tHr3@D\$";
$lang['subscribedthreads'] = "sU85Cri8eD +HrEads";
$lang['currentinterest'] = "cuRr3Nt intEr35+";

// Browseable user profiles

$lang['youcanonlyaddthreecolumns'] = "j00 c4n oNly 4DD 3 COlUMns. t0 4DD 4 NEw COlumn CLos3 4N 3x1\$+ing 0n3";
$lang['columnalreadyadded'] = "j00 H4ve 4lr34Dy addeD +hIs c0lumn. 1Ph J00 w4N+ +0 rEm0V3 1+ cliCk Its CL053 8ut+0n";

?>
