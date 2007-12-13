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

/* $Id: x-hacker.inc.php,v 1.264 2007-12-13 20:14:51 decoyduck Exp $ */

// British English language file

// Language character set and text direction options -------------------

$lang['_isocode'] = "en";
$lang['_textdir'] = "ltr";

// Months --------------------------------------------------------------

$lang['month'][1]  = "j4nU@Ry";
$lang['month'][2]  = "fe8rU@rY";
$lang['month'][3]  = "m4rCH";
$lang['month'][4]  = "aPril";
$lang['month'][5]  = "m4Y";
$lang['month'][6]  = "jUn3";
$lang['month'][7]  = "jULy";
$lang['month'][8]  = "au9Ust";
$lang['month'][9]  = "s3PTeMBER";
$lang['month'][10] = "ocTO8er";
$lang['month'][11] = "nOVEM83r";
$lang['month'][12] = "d3cem83r";

$lang['month_short'][1]  = "j@N";
$lang['month_short'][2]  = "f3B";
$lang['month_short'][3]  = "mar";
$lang['month_short'][4]  = "apR";
$lang['month_short'][5]  = "m4Y";
$lang['month_short'][6]  = "jun";
$lang['month_short'][7]  = "jUL";
$lang['month_short'][8]  = "aUG";
$lang['month_short'][9]  = "s3p";
$lang['month_short'][10] = "oCt";
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

$lang['date_periods']['year']   = "%s ye4R";
$lang['date_periods']['month']  = "%s MoN+h";
$lang['date_periods']['week']   = "%s weEk";
$lang['date_periods']['day']    = "%s D@y";
$lang['date_periods']['hour']   = "%s h0ur";
$lang['date_periods']['minute'] = "%s M1nutE";
$lang['date_periods']['second'] = "%s 5eConD";

// As above but plurals (2 years vs. 1 year, etc.)

$lang['date_periods_plural']['year']   = "%s y3@rs";
$lang['date_periods_plural']['month']  = "%s Mon+h\$";
$lang['date_periods_plural']['week']   = "%s w33ks";
$lang['date_periods_plural']['day']    = "%s d@y\$";
$lang['date_periods_plural']['hour']   = "%s hours";
$lang['date_periods_plural']['minute'] = "%s m1Nu+es";
$lang['date_periods_plural']['second'] = "%s \$3C0NDs";

// Short hand periods (example: 1y, 2m, 3w, 4d, 5hr, 6min, 7sec)

$lang['date_periods_short']['year']   = "%sY";    // 1y
$lang['date_periods_short']['month']  = "%sM";    // 2m
$lang['date_periods_short']['week']   = "%sw";    // 3w
$lang['date_periods_short']['day']    = "%sD";    // 4d
$lang['date_periods_short']['hour']   = "%shr";   // 5hr
$lang['date_periods_short']['minute'] = "%sM1N";  // 6min
$lang['date_periods_short']['second'] = "%sSec";  // 7sec

// Common words --------------------------------------------------------

$lang['percent'] = "pErC3nT";
$lang['average'] = "aV3r4gE";
$lang['approve'] = "aPPr0Ve";
$lang['banned'] = "b4NnED";
$lang['locked'] = "l0ck3D";
$lang['add'] = "aDd";
$lang['advanced'] = "aDv@ncED";
$lang['active'] = "ac+1VE";
$lang['style'] = "style";
$lang['go'] = "go";
$lang['folder'] = "fOld3R";
$lang['ignoredfolder'] = "ign0r3D F0LdeR";
$lang['folders'] = "fOldEr\$";
$lang['thread'] = "tHr3aD";
$lang['threads'] = "thre4D\$";
$lang['threadlist'] = "tHr3@D l1\$+";
$lang['message'] = "me\$s49E";
$lang['messagenumber'] = "m3\$S4g3 num8er";
$lang['from'] = "frOM";
$lang['to'] = "t0";
$lang['all_caps'] = "aLL";
$lang['of'] = "opH";
$lang['reply'] = "r3Ply";
$lang['forward'] = "fORW4RD";
$lang['replyall'] = "r3plY +0 4ll";
$lang['pm_reply'] = "r3PLy @s pM";
$lang['delete'] = "d3le+E";
$lang['deleted'] = "dEl3+Ed";
$lang['edit'] = "ediT";
$lang['privileges'] = "pR1vIlE93S";
$lang['ignore'] = "iGnore";
$lang['normal'] = "n0RM@l";
$lang['interested'] = "inter3s+ED";
$lang['subscribe'] = "sUbsCr183";
$lang['apply'] = "aPpLY";
$lang['download'] = "doWNl0@d";
$lang['save'] = "sAve";
$lang['update'] = "upd@+e";
$lang['cancel'] = "c@Ncel";
$lang['continue'] = "cOnt1nue";
$lang['attachment'] = "a++4ChMENt";
$lang['attachments'] = "a+t4ChmEN+s";
$lang['imageattachments'] = "iM4g3 a+t4ChmENTs";
$lang['filename'] = "f1l3N4ME";
$lang['dimensions'] = "d1M3N\$I0NS";
$lang['downloadedxtimes'] = "d0Wnl04d3d: %d t1M3s";
$lang['downloadedonetime'] = "d0WNloadeD: 1 t1M3";
$lang['size'] = "s1Ze";
$lang['viewmessage'] = "viEW Me\$s493";
$lang['deletethumbnails'] = "deleTE tHUm8N4ils";
$lang['logon'] = "l090N";
$lang['more'] = "m0r3";
$lang['recentvisitors'] = "rec3N+ vIsI+0Rs";
$lang['username'] = "userN4me";
$lang['clear'] = "cLE@r";
$lang['action'] = "actI0n";
$lang['unknown'] = "unknOWN";
$lang['none'] = "noN3";
$lang['preview'] = "pr3V1EW";
$lang['post'] = "p0S+";
$lang['posts'] = "p0Sts";
$lang['change'] = "ch4n9E";
$lang['yes'] = "y3\$";
$lang['no'] = "no";
$lang['signature'] = "s19Na+urE";
$lang['signaturepreview'] = "s19n4+urE PREV13W";
$lang['signatureupdated'] = "sI9NAture UpD4+3d";
$lang['signatureupdatedforallforums'] = "s1GNatUr3 uPd4+3d ph0r @lL foRuM5";
$lang['back'] = "b4ck";
$lang['subject'] = "su8jeCt";
$lang['close'] = "cL0se";
$lang['name'] = "n4m3";
$lang['description'] = "d3sCriPt10n";
$lang['date'] = "d@TE";
$lang['view'] = "v13W";
$lang['enterpasswd'] = "eNT3r P4ssw0RD";
$lang['passwd'] = "p4Ssw0rD";
$lang['ignored'] = "i9n0RED";
$lang['guest'] = "guEST";
$lang['next'] = "n3xt";
$lang['prev'] = "prEVi0US";
$lang['others'] = "o+H3RS";
$lang['nickname'] = "n1ckn4M3";
$lang['emailaddress'] = "eMa1L aDDrE5\$";
$lang['confirm'] = "coNF1rm";
$lang['email'] = "em@1l";
$lang['poll'] = "polL";
$lang['friend'] = "frI3nd";
$lang['success'] = "sUcCEss";
$lang['error'] = "error";
$lang['warning'] = "w@rn1N9";
$lang['guesterror'] = "soRry, j00 nE3d +o 8e L09g3D iN +o uSE +hi\$ f34+UrE.";
$lang['loginnow'] = "lO91n NoW";
$lang['unread'] = "uNR3@D";
$lang['all'] = "all";
$lang['allcaps'] = "alL";
$lang['permissions'] = "perMIssi0N\$";
$lang['type'] = "tyP3";
$lang['print'] = "prIN+";
$lang['sticky'] = "s+ICkY";
$lang['polls'] = "p0LL5";
$lang['user'] = "us3r";
$lang['enabled'] = "en4BlED";
$lang['disabled'] = "d1S4BLED";
$lang['options'] = "oP+10N5";
$lang['emoticons'] = "em0+iCon\$";
$lang['webtag'] = "w38ta9";
$lang['makedefault'] = "m4k3 D3Ph4ul+";
$lang['unsetdefault'] = "uNSET D3PH@uLt";
$lang['rename'] = "rEN@m3";
$lang['pages'] = "p4935";
$lang['used'] = "u53d";
$lang['days'] = "daYs";
$lang['usage'] = "u54g3";
$lang['show'] = "show";
$lang['hint'] = "hint";
$lang['new'] = "n3W";
$lang['referer'] = "reFeR3R";
$lang['thefollowingerrorswereencountered'] = "th3 Ph0lL0W1ng 3Rr0rS W3re 3NC0unteR3D:";

// Admin interface (admin*.php) ----------------------------------------

$lang['admintools'] = "adM1N tOols";
$lang['forummanagement'] = "f0rUM m@n49EMen+";
$lang['accessdeniedexp'] = "j00 DO n0+ h4v3 P3RM1\$\$10n t0 us3 Th1\$ \$3c+i0N.";
$lang['managefolders'] = "m4N4g3 FoldERs";
$lang['manageforums'] = "m@n4g3 f0Rum5";
$lang['manageforumpermissions'] = "m@n4ge PhoruM p3rmI\$S10Ns";
$lang['foldername'] = "f0LDer n4m3";
$lang['move'] = "m0v3";
$lang['closed'] = "clOSEd";
$lang['open'] = "op3n";
$lang['restricted'] = "rE\$TrICT3D";
$lang['forumiscurrentlyclosed'] = "%s 1s CUrRen+lY CLOsEd";
$lang['youdonothaveaccesstoforum'] = "j00 D0 Not haVE @CC3ss T0 %s";
$lang['toapplyforaccessplease'] = "t0 4pply ph0R 4CC3\$\$ pLE4sE C0n+@cT +HE ForuM 0wnER.";
$lang['adminforumclosedtip'] = "iF j00 w4n+ +O CH4NgE 5om3 sE++1ng\$ on youR F0RUm CLiCk +EH @DMIn l1NK 1n TH3 n@v194TioN B4r A8OV3.";
$lang['newfolder'] = "nEw f0LD3r";
$lang['nofoldersfound'] = "n0 ex15TInG F0LDEr\$ pHounD. +0 4Dd 4 pHolDER CLICK +hE 'aDD N3W' 8u++oN B3l0W.";
$lang['forumadmin'] = "fORUM @DMin";
$lang['adminexp_1'] = "u53 +h3 menU On tHe l3ft +o m4n493 +HInGs in Your PhoRuM.";
$lang['adminexp_2'] = "<b>uS3r\$</b> 4llow\$ j00 +o S3+ indiV1du4L U53r P3rMIssiOns, 1nCLUD1n9 4PPo1N+1N9 m0dEr@+0rs 4Nd G@gGinG p30ple.";
$lang['adminexp_3'] = "<b>u5ER groUp\$</b> 4llOwS j00 t0 CrE@+3 U\$er grOuPS +o @S\$19N p3RmIssi0N5 to 4S m@ny 0r @\$ pH3W U\$ErS quiCKlY @Nd E4S1ly.";
$lang['adminexp_4'] = "<b>bAn c0N+R0L5</b> 4llOw\$ +3h B4nNin9 4nD uN-b4Nn1ng 0f ip 4dDr3\$5E\$, HT+p rEFeR3r5, USERn4m3S, 3M4iL 4ddr3SsES @ND n1CknAme5.";
$lang['adminexp_5'] = "<b>foLD3R\$</b> 4lLOwS TH3 CrE4T10N, M0d1PH1CA+10N 4Nd dEl3+10N Oph PhOLd3Rs.";
$lang['adminexp_6'] = "<b>rsS F3EDs</b> 4lLow\$ j00 +0 m@N@g3 R\$5 f3eds phOR pr0P49At1ON IN+0 y0UR Ph0RUm.";
$lang['adminexp_7'] = "<b>pROpH1les</b> L3ts J00 CUS+oM1\$e t3H 1t3ms that @ppEAR 1n Th3 U53R pR0Ph1L3s.";
$lang['adminexp_8'] = "<b>f0ruM S3ttiNgS</b> @llows J00 +0 CUST0MiSE YoUR Ph0rum's N@m3, @pPEaRaNC3 @Nd m4ny oth3r tH1N9\$.";
$lang['adminexp_9'] = "<b>s+@R+ P4G3</b> l3ts j00 CU\$+0mIsE YOUr ph0rUm's \$+4rt P493.";
$lang['adminexp_10'] = "<b>fOrum stYl3</b> @lLow5 j00 tO 93n3r4+e r@nDOM StYl3s pHoR y0uR FoRUM m3m8ER\$ +0 USE.";
$lang['adminexp_11'] = "<b>wOrD F1Lt3r</b> 4LL0w\$ J00 +O pHIlTER WOrds J00 D0n't w@N+ +o 8e Us3D 0n y0ur PhoRUM.";
$lang['adminexp_12'] = "<b>pOST1nG \$+ats</b> 93n3R@+E\$ @ r3p0R+ l1\$+1ng thE +0p 10 pO\$+3rs iN 4 D3FInEd PErI0d.";
$lang['adminexp_13'] = "<b>f0RUm l1NKS</b> L3+\$ J00 m4n4g3 +Eh LinK\$ dropD0wn 1n TH3 n@viG4tion b4r.";
$lang['adminexp_14'] = "<b>vI3W lOg</b> lIsts reC3nt 4C+1On5 by +3H f0rum m0DER@+ors.";
$lang['adminexp_15'] = "<b>m4N@gE foRUMs</b> LETs j00 crEa+3 AnD DELE+3 4nD CL053 0r REOpEN f0ruM5.";
$lang['adminexp_16'] = "<b>gl084L pH0RUM \$3tt1NG5</b> AlloWs j00 +o moDIPhY s3T+iN9s Wh1ch 4PHpheC+ 4LL phOrUMs.";
$lang['adminexp_17'] = "<b>p0st 4ppR0V4l qUeu3</b> @lL0W\$ j00 +0 VIEW 4Ny p0S+5 4W41+1Ng @pPrOv@l 8Y 4 mOdEr@+0r.";
$lang['adminexp_18'] = "<b>vIS1T0r lOg</b> allow\$ J00 to vIEw 4N 3XTENDED L1\$+ of V1Sit0rs iNCLUdiN9 +HEIr h+tP R3PhER3Rs.";
$lang['createforumstyle'] = "cr34tE 4 ForUm 5+ylE";
$lang['newstylesuccessfullycreated'] = "n3W stYL3 \$UcCEssfuLlY CRE4+3D.";
$lang['stylealreadyexists'] = "a stYL3 w1+H th@+ pHiLEN4m3 alR3@Dy Ex15+s.";
$lang['stylenofilename'] = "j00 D1D nO+ 3nter a phIl3name To sAv3 tHe \$TYLe W1+H.";
$lang['stylenodatasubmitted'] = "coUlD No+ rE4D forUM sTYl3 d@+@.";
$lang['styleexp'] = "u5e +h1\$ pa9e T0 h3LP Cr34+3 4 r@ND0mly 9En3R4+3d 5+yLE f0r yoUr pHoruM.";
$lang['stylecontrols'] = "contr0ls";
$lang['stylecolourexp'] = "clICK on @ C0lour tO m4K3 4 N3w S+YLE 5h3E+ 8aseD On th4+ C0l0UR. cUrREN+ B4se CoL0Ur I5 PhIRsT In l1\$t.";
$lang['standardstyle'] = "s+@nD@Rd styL3";
$lang['rotelementstyle'] = "rOT4T3D 3L3m3Nt \$TYL3";
$lang['randstyle'] = "r4NDoM StYlE";
$lang['thiscolour'] = "th1S C0L0ur";
$lang['enterhexcolour'] = "oR ENtER @ HEx c0L0ur +o 84\$3 4 NEW \$tyL3 \$h33+ 0N";
$lang['savestyle'] = "s4v3 Th1S \$+YLE";
$lang['styledesc'] = "s+YL3 desCR1Pt1ON";
$lang['stylefilenamemayonlycontain'] = "s+yle f1LEn4M3 m@y OnLy C0nta1N L0w3RC4\$E lETTER\$ (4-Z), NUm8er\$ (0-9) 4ND UND3RsC0re.";
$lang['stylepreview'] = "sTYLE pREV13w";
$lang['welcome'] = "w3lc0M3";
$lang['messagepreview'] = "meSs4G3 pr3V13W";
$lang['users'] = "u\$ERS";
$lang['usergroups'] = "u\$3r 9r0UP\$";
$lang['mustentergroupname'] = "j00 mUsT EN+er 4 9r0Up n@M3";
$lang['profiles'] = "pr0ph1LEs";
$lang['manageforums'] = "m@N49E f0RumS";
$lang['forumsettings'] = "fORUm s3+TIng5";
$lang['globalforumsettings'] = "gl08@L F0rum 53t+1N9\$";
$lang['settingsaffectallforumswarning'] = "<b>nO+e:</b> +H353 \$E++1ng\$ 4FFECT 4ll ph0ruM\$. WHERE TH3 sE+TiNG Is dUPl1CaTED oN +3H InD1v1DU4l F0RUm's s3tt1Ngs p49E +h4t W1Ll +4k3 pREC3D3NC3 0VER +H3 s3+tiN9S J00 ChANge h3RE.";
$lang['startpage'] = "sTar+ p4g3";
$lang['startpageerror'] = "y0Ur st4R+ p49E COUlD NOT B3 s4V3D LoC4lLy to TEH SErvER 8Ecau\$E Permi5Si0n W4\$ D3N13D.</p><p>t0 CH@nG3 y0Ur s+4rt p@GE Pl3@\$3 cl1cK +hE DowNlO@D 8ut+ON BELoW WhICH wiLl prOmPt j00 To s4VE tH3 FIl3 +0 y0uR HaRD Dr1v3. j00 c4n tHEN upL04D tH1\$ fILE T0 youR \$Erv3r 1Nt0 TH3 ph0ll0winG F0lder, 1f nEC3ss4Ry Cr34+1n9 +h3 pholD3R s+rUC+Ur3 In +eH pr0CE\$S.</p><p><b>%s</b></p><p>pl34SE n0+3 +haT some 8row\$Ers m4Y Ch4nge +Eh n4me of t3h f1l3 Upon D0wnl04d.  wh3n upL0aD1n9 +3h f1l3 pLEase m@ke surE th4+ i+ is N4m3D s+@R+_m@IN.php othErw15e Your 5+4rt p@93 w1ll @pp3Ar unCh4NgeD.";
$lang['failedtoopenmasterstylesheet'] = "y0ur F0rum s+Yl3 coulD nO+ 8E \$4v3D 8eC@UsE +eh m@stER s+yl3 SheET COuLD noT BE LO4d3D. To 5@v3 y0Ur 5+yl3 +3H M45+Er styL3 sheet (M@KE_5+YL3.css) mUsT B3 loc4+eD 1N +H3 styL3s D1REC+0ry oPh Your 83eh1V3 forum in5tALL@+I0N.";
$lang['makestyleerror'] = "y0Ur ph0rum \$TYl3 coUlD No+ BE \$4v3D l0C4llY t0 +EH s3rvEr B3C4USE P3RmI\$sI0n w4\$ dEN1ED. t0 S4VE yoUR F0RUm \$+yL3 ple@53 cLiCK tH3 downlOaD 8U+t0n BElow WhICH Will prOmPt j00 to s4v3 +Eh pHiL3 +0 yoUr h@rD DRIv3. J00 C4N Th3N UPlo4d tHis f1L3 +o yOuR s3rver In+O %s FoldEr, 1f N3c3sS4RY crE4+in9 +he f0lDEr s+RUC+UR3 1n +hE prOCEsS. j00 shOULd n0+3 th4t sOM3 bR0w\$er\$ m@y Ch4ngE +h3 n@mE 0ph ThE Ph1L3 uPon d0wnl0@D. wH3n UPLo4Ding +h3 F1l3 pl34S3 M4K3 sur3 +h@+ i+ 15 n4Med STYle.CSs 0+herwiS3 teh forum \$tyl3 w1ll 83 UNu5@8le.";
$lang['forumstyle'] = "f0RUm styl3";
$lang['wordfilter'] = "wORD fIl+er";
$lang['forumlinks'] = "f0RUm l1nks";
$lang['viewlog'] = "v13w l0g";
$lang['noprofilesectionspecified'] = "no PrOph1le SEC+10N sP3CIF1eD.";
$lang['itemname'] = "i+3M n4M3";
$lang['moveto'] = "m0Ve t0";
$lang['manageprofilesections'] = "m@n49E pR0phiLE SEC+10ns";
$lang['sectionname'] = "section N@ME";
$lang['items'] = "i+eMS";
$lang['mustspecifyaprofilesectionid'] = "muSt spEC1fy @ ProFIl3 SECT1on 1D";
$lang['mustsepecifyaprofilesectionname'] = "mU\$+ sp3CIpHy @ pRoFiL3 sECT10N NAME";
$lang['noprofilesectionsfound'] = "nO ex1st1ng pR0phIl3 \$ect10n\$ foUnD. +o ADD 4 propHiL3 \$3C+i0N CL1ck thE '@Dd NEW' bU++0N 83l0w.";
$lang['addnewprofilesection'] = "aDd NEw proph1l3 sec+I0n";
$lang['successfullyaddedprofilesection'] = "sUCCE\$sfULLy @DD3d Proph1le 5EC+1on";
$lang['successfullyeditedprofilesection'] = "sUcc3s5phUlLy EDiteD pR0philE sECT10n";
$lang['addnewprofilesection'] = "aDd new pRoPhIl3 \$ECT10n";
$lang['mustsepecifyaprofilesectionname'] = "mu5T spEC1fy 4 pr0phil3 \$eCt10n nAm3";
$lang['successfullyremovedselectedprofilesections'] = "sucC3ssFuLLy Rem0v3D \$el3c+3d profilE SEC+10ns";
$lang['failedtoremoveprofilesections'] = "f@1LED +0 R3move ProPhIle sECT10n\$";
$lang['viewitems'] = "viEW 1+Em5";
$lang['successfullyaddednewprofileitem'] = "sUcC3SsfuLly 4DDEd n3W pr0FILE I+EM";
$lang['successfullyeditedprofileitem'] = "sUccEssFULlY 3ditED pR0ph1l3 1+3m";
$lang['successfullyremovedselectedprofileitems'] = "sUCC3ssFULLy rEMOv3D \$3l3C+3d Pr0phIle 1+3Ms";
$lang['failedtoremoveprofileitems'] = "f41leD +o REm0v3 Pr0PHil3 1t3Ms";
$lang['noexistingprofileitemsfound'] = "thERE 4R3 N0 3xisting pR0PhIlE 1+3ms iN +hi\$ \$Ec+1on. To 4Dd 4n 1+eM clICK TEH '@dD NEW' BuT+oN B3l0W.";
$lang['edititem'] = "edi+ i+EM";
$lang['invalidprofilesectionid'] = "inv@l1D pR0PHiL3 s3C+I0N 1d or \$eCt10n N0t pHoUNd";
$lang['invalidprofileitemid'] = "iNv4l1D Pr0f1l3 iTEM 1d or 1t3m N0T F0UND";
$lang['addnewitem'] = "add n3w iTEm";
$lang['youmustenteraprofileitemname'] = "j00 mU5+ 3nTer @ PR0phil3 i+3m naME";
$lang['invalidprofileitemtype'] = "iNV4l1d pr0ph1l3 1t3m +Yp3 \$3LecTED";
$lang['youmustenteroptionsforselectedprofileitemtype'] = "j00 mU5+ 3ntER sOme oP+IoN\$ F0R s3L3C+ED Pr0ph1L3 1+3m +yp3";
$lang['youmustentermorethanoneoptionforitem'] = "j00 mUst entEr m0RE +h4n ON3 op+i0N pH0R s3leC+3d Pr0FIL3 iTEm +ype";
$lang['profileitemhyperlinkssupportshttpurlsonly'] = "pr0f1l3 iTEM HyPERLink\$ supp0r+ H+Tp UrL\$ onlY";
$lang['profileitemhyperlinkformatinvalid'] = "pROphiL3 I+3M HyPErL1NK F0Rm4+ iNv@l1d";
$lang['youmustincludeprofileentryinhyperlinks'] = "j00 MUs+ IncLUD3 <i>%s</i> IN +3h URL 0f cl1CK@ble HyPERl1nks";
$lang['failedtocreatenewprofileitem'] = "f@1leD +0 CR34+E nEW pr0PH1l3 1+3M";
$lang['failedtoupdateprofileitem'] = "f41leD +o upD4+3 propHiL3 i+3m";
$lang['startpageupdated'] = "s+@r+ P@9e uPD4+ED. %s";
$lang['viewupdatedstartpage'] = "v13w upD@+ED s+@R+ PA93";
$lang['editstartpage'] = "eD1+ sT4Rt P@gE";
$lang['nouserspecified'] = "no us3R sp3ciF13D.";
$lang['manageuser'] = "m4N4g3 Us3R";
$lang['manageusers'] = "m4n@ge usERs";
$lang['userstatusforforum'] = "user 5+@tu\$ f0r %s";
$lang['userdetails'] = "u\$3r dET41l\$";
$lang['warning_caps'] = "w@rn1N9";
$lang['userdeleteallpostswarning'] = "aRE j00 \$ure j00 wAnT T0 DELE+E @LL 0pH TEH \$eL3CT3d UseR'5 PO5+s? oNCE th3 p0STs @RE DEL3t3d +h3y c4nN0T 83 r3+ri3VED @nD W1LL 83 l05+ pHor3VER.";
$lang['postssuccessfullydeleted'] = "p0Sts w3Re sUccEssFUlLy D3L3+eD.";
$lang['folderaccess'] = "f0LD3R 4CC3sS";
$lang['possiblealiases'] = "pOs5i8le @li@s3s";
$lang['userhistory'] = "us3r hisTORy";
$lang['nohistory'] = "n0 hi\$T0ry r3COrDS s4VED";
$lang['userhistorychanges'] = "cH4nG3s";
$lang['clearuserhistory'] = "cL34R usER H1\$TORY";
$lang['changedlogonfromto'] = "ch4n9ED lo90n phrom %s +0 %s";
$lang['changednicknamefromto'] = "ch4n93D N1cKN4m3 fr0m %s To %s";
$lang['changedemailfromto'] = "cH@ngeD 3M@Il pHr0m %s +0 %s";
$lang['successfullycleareduserhistory'] = "sUCCE\$sfully CL34reD U53r Hi\$tory";
$lang['failedtoclearuserhistory'] = "f41l3D to ClE4R U\$3r hiS+0Ry";
$lang['successfullychangedpassword'] = "sucCE5sfUlLy CH4ng3d p@\$SW0rd";
$lang['failedtochangepasswd'] = "fA1lED +0 Ch@nGe passW0RD";
$lang['viewuserhistory'] = "v13w u\$eR H1s+0Ry";
$lang['viewuseraliases'] = "vi3w UsEr 4l14S3S";
$lang['searchreturnednoresults'] = "s34Rch R3TUrN3d n0 r3\$ul+S";
$lang['deleteposts'] = "d3L3+3 pos+5";
$lang['deleteuser'] = "deL3t3 User";
$lang['alsodeleteusercontent'] = "alS0 deL3+3 4ll OpH +h3 Con+3NT CRE4+3D 8y +h1\$ UsER";
$lang['userdeletewarning'] = "aRe j00 \$uRE j00 wan+ To dELETE +hE sel3CTED USER aCC0unt? 0NCE +H3 4cCoUNt h4S BE3n D3l3TeD i+ CANnoT BE RETr13vED 4nd will B3 l05+ F0ReVEr.";
$lang['usersuccessfullydeleted'] = "us3r \$UCcE5\$fUlly DEL3t3D";
$lang['failedtodeleteuser'] = "f4IL3d +0 DElE+E UsER";
$lang['forgottenpassworddesc'] = "iPH +hI\$ user h@\$ F0Rg0TT3N +hEIr p4\$sw0rD j00 C4n rEset It ph0r +heM h3r3.";
$lang['manageusersexp'] = "th1S lI\$t sh0w\$ 4 53l3c+I0N oPh us3rs wh0 have l0G9ed 0n t0 y0UR PHorum, \$0rTED By %s. +o 4L+ER a U\$3r'5 p3RmISsion5 cliCk thE1R n4m3.";
$lang['userfilter'] = "user pH1Lt3R";
$lang['onlineusers'] = "oNl1NE USER5";
$lang['offlineusers'] = "ophphlin3 U53R\$";
$lang['usersawaitingapproval'] = "u\$3Rs 4WA1+inG 4ppR0V4l";
$lang['bannedusers'] = "b@NN3d us3rs";
$lang['lastlogon'] = "l4S+ log0n";
$lang['sessionreferer'] = "s3ssi0n REfER3r";
$lang['signupreferer'] = "sI9n-Up RefER3r:";
$lang['nouseraccountsmatchingfilter'] = "nO u\$ER 4cc0unts m4+ch1NG PhIl+ER";
$lang['searchforusernotinlist'] = "se4rCh phOr A U\$3r n0T 1n l1\$T";
$lang['adminaccesslog'] = "aDMIN @CCE\$\$ LOg";
$lang['adminlogexp'] = "tHis List sh0W\$ +H3 l@\$+ 4C+10Ns 54nCT10n3D by User\$ with @DMiN Pr1vil3ges.";
$lang['datetime'] = "d@T3/+1m3";
$lang['unknownuser'] = "uNknowN US3R";
$lang['unknownuseraccount'] = "uNkn0wn usER 4Cc0Unt";
$lang['unknownfolder'] = "uNknOwn phOlDER";
$lang['ip'] = "ip";
$lang['lastipaddress'] = "l4s+ Ip 4DDRESs";
$lang['logged'] = "l0G9eD";
$lang['notlogged'] = "not l09geD";
$lang['addwordfilter'] = "aDd w0RD fIL+3r";
$lang['addnewwordfilter'] = "aDD n3W woRD fil+Er";
$lang['wordfilterupdated'] = "wORD F1L+3r upd4TED";
$lang['filtername'] = "fiLT3R N4ME";
$lang['filtertype'] = "f1L+3R TyPe";
$lang['filterenabled'] = "f1lt3r 3NABL3d";
$lang['editwordfilter'] = "edIT word fIl+3R";
$lang['nowordfilterentriesfound'] = "n0 3xis+1N9 wORD F1lTER 3n+R13\$ ph0unD. to aDD @ pHilt3r CLiCK tEH '4dD new' 8U++0n beL0W.";
$lang['mustspecifyfiltername'] = "j00 mu5+ \$p3CIFy @ fIltER naM3";
$lang['mustspecifymatchedtext'] = "j00 mU\$+ sp3cIFY M4+Ch3d +3X+";
$lang['mustspecifyfilteroption'] = "j00 mUst sp3CiFY a pH1L+3r 0P+10N";
$lang['mustspecifyfilterid'] = "j00 mUst sPECiPhY 4 pHilt3r id";
$lang['invalidfilterid'] = "iNV4L1D fil+ER 1D";
$lang['failedtoupdatewordfilter'] = "f4IlEd t0 uPdate w0RD FiL+3R. CHEck tH4+ +3H Ph1L+ER s+1Ll ex15+s.";
$lang['allow'] = "alloW";
$lang['block'] = "bLOck";
$lang['normalthreadsonly'] = "noRM4l thre4d5 OnlY";
$lang['pollthreadsonly'] = "poLl +hR34d\$ 0Nly";
$lang['both'] = "bOTH +HR34d tYp3s";
$lang['existingpermissions'] = "exist1ng p3rmISS1on5";
$lang['nousershavebeengrantedpermission'] = "n0 Exi\$+1ng U5Er5 pErmiss1ON5 pHOUND. +O 9R4N+ pERmIs5I0N +O USER5 534RCH F0R +h3m 83low.";
$lang['successfullyaddedpermissionsforselectedusers'] = "sUCCESsfUlLy @DdED p3Rmissi0n\$ pH0R S3L3C+3d U\$3rs";
$lang['successfullyremovedpermissionsfromselectedusers'] = "sUcCE\$sphully remOVED P3RmI\$S10n5 pHrom s3LECT3d UsERs";
$lang['failedtoaddpermissionsforuser'] = "f@1leD +o adD pERm1\$si0ns PHor U53R '%s'";
$lang['failedtoremovepermissionsfromuser'] = "f4ILeD t0 R3moV3 p3Rmissi0N5 fr0M UseR '%s'";
$lang['searchforuser'] = "s3@rch pHor U53r";
$lang['browsernegotiation'] = "bR0WSEr n390tI@+ED";
$lang['largetextfield'] = "l@R9e +Ext f1ELD";
$lang['mediumtextfield'] = "meD1uM T3xt f1ELD";
$lang['smalltextfield'] = "sm@ll tExt F13lD";
$lang['multilinetextfield'] = "muLti-lIn3 +ExT FiElD";
$lang['radiobuttons'] = "rad10 bUTton5";
$lang['dropdownlist'] = "dROP down L1\$t";
$lang['clickablehyperlink'] = "clICK@ble hYpERLiNk";
$lang['threadcount'] = "tHR34D C0unt";
$lang['clicktoeditfolder'] = "click +0 EDI+ FoLD3r";
$lang['fieldtypeexample1'] = "t0 CrE4t3 r4DI0 bu++0n5 oR a DroP DOWn lIs+ J00 nEED +o 3NtER 34CH inDiViDu4l VAlu3 ON @ \$3p4R4+3 Lin3 1n +HE 0P+10n\$ PhI3LD.";
$lang['fieldtypeexample2'] = "t0 Cr3@+e CLicKable L1nk\$ 3NteR +3H UrL iN +3h 0PT10n\$ ph13LD @nD Us3 <i>%1\$s</i> WHeR3 THE 3ntry PhRom tEH U\$3r'5 Pr0fil3 sH0uLd aPp3ar. EX@mpl35: <p>mYsp4cE: <i>h+tP://www.mY5paC3.C0m/%1\$S</i><br />x80x LIV3: <i>h++P://pR0PH1le.mYG@M3RC@RD.n3+/%1\$s</i>";
$lang['editedwordfilter'] = "ed1ted woRD F1lteR";
$lang['editedforumsettings'] = "edI+3d f0RuM sE++ings";
$lang['successfullyendedusersessionsforselectedusers'] = "succE5sfULLY 3Nded \$e55i0N\$ f0r S3l3C+3D USER\$";
$lang['failedtoendsessionforuser'] = "f@1leD +0 end sE\$SIOn f0r u\$er %s";
$lang['successfullyapprovedselectedusers'] = "succ3SsFULly 4PPr0v3D 53l3C+ED Us3R5";
$lang['matchedtext'] = "mAtChED +3X+";
$lang['replacementtext'] = "r3Pl@C3M3nt TExt";
$lang['preg'] = "pRe9";
$lang['wholeword'] = "whOlE WorD";
$lang['word_filter_help_1'] = "<b>aLL</b> matchEs @g4INSt +hE wh0LE +Ext s0 F1L+ErInG M0M t0 mum w1ll al50 ch4n9e m0m3Nt +0 mUMENt.";
$lang['word_filter_help_2'] = "<b>whOl3 W0RD</b> MatCHes 49@ins+ Wh0le w0rD\$ 0Nly sO Ph1l+3RiNg mom To mUM WIll n0+ CH@Ng3 M0m3nt +o mUMEn+.";
$lang['word_filter_help_3'] = "<b>pR3g</b> ALlow\$ j00 +o U\$3 p3rl rEGuL4R Expr3ss1on\$ +0 m4+Ch +Ex+.";
$lang['nameanddesc'] = "nam3 4ND D3SCR1p+i0n";
$lang['movethreads'] = "m0V3 +hr34D5";
$lang['movethreadstofolder'] = "m0v3 thR3@Ds to f0ldER";
$lang['failedtomovethreads'] = "f4ILEd +o moV3 +HrE4ds t0 SPEC1f13d f0ld3R";
$lang['resetuserpermissions'] = "r3SeT U\$er pERM1\$s10N\$";
$lang['failedtoresetuserpermissions'] = "f41L3d T0 rE\$eT USEr pERMi\$SIOns";
$lang['allowfoldertocontain'] = "alL0w phOlDER +0 COn+4IN";
$lang['addnewfolder'] = "adD n3W F0ldeR";
$lang['mustenterfoldername'] = "j00 mu5T 3nt3R 4 f0LDER naME";
$lang['nofolderidspecified'] = "n0 F0LDER iD \$p3CIPhI3d";
$lang['invalidfolderid'] = "iNvalid phoLD3r iD. CH3Ck +h4T 4 phoLDer wI+H +H1\$ ID Ex1\$+s!";
$lang['successfullyaddednewfolder'] = "succ3S\$FUlLY 4DD3d NEW PhOldEr";
$lang['successfullyremovedselectedfolders'] = "suCC35\$FULlY REMovED \$eL3C+ED PH0LD3rs";
$lang['successfullyeditedfolder'] = "succ3\$sfuLly 3D1tED F0lDer";
$lang['failedtocreatenewfolder'] = "f4Il3D +0 cr34+3 NEW f0ldER";
$lang['failedtodeletefolder'] = "fa1led +0 DEl3t3 pHoldER.";
$lang['failedtoupdatefolder'] = "f4il3D +o UPD@tE ph0LD3r";
$lang['cannotdeletefolderwiththreads'] = "cANNOt DEl3t3 pH0LDER\$ +H@t \$t1lL CON+41n +Hr3ad\$.";
$lang['forumisnotrestricted'] = "fORUm is n0+ r3S+rICTED";
$lang['groups'] = "gr0uPs";
$lang['nousergroups'] = "n0 Us3R gR0Up\$ H@V3 8E3N 5ET UP. tO aDD @ 9r0Up CLICK TEh '@DD NEW' BUtToN 83low.";
$lang['suppliedgidisnotausergroup'] = "sUppl13d 9ID i\$ nO+ @ UsEr 9RouP";
$lang['manageusergroups'] = "m4n49E u5ER 9ROups";
$lang['groupstatus'] = "gR0up 5+@tu\$";
$lang['addusergroup'] = "aDd usEr grOUp";
$lang['addemptygroup'] = "add 3mptY 9R0Up";
$lang['adduserstogroup'] = "add Us3Rs +0 9rOuP";
$lang['addremoveusers'] = "add/r3moV3 UsERs";
$lang['nousersingroup'] = "tH3R3 4rE n0 UsEr\$ iN +Hi\$ gRoup. aDD USErs +o +HiS 9R0Up BY \$e@RCH1ng F0R +h3M Below.";
$lang['groupaddedaddnewuser'] = "sUcc3ssfUlLy @dDEd 9roUP. 4dd Us3rs +0 +H1\$ Group 8Y sEARch1n9 f0r +hEM B3low.";
$lang['nousersingroupaddusers'] = "tH3re 4R3 n0 US3rs in +His GrouP. T0 4DD UseRs CL1CK tHE '@dD/R3Mov3 u\$3rs' BU+t0N BELOW.";
$lang['useringroups'] = "thIs u53r 1S @ m3mBEr of tHE pH0Ll0W1N9 grouP\$";
$lang['usernotinanygroups'] = "thI\$ u53r is n0t 1n 4Ny Us3r 9rouP\$";
$lang['usergroupwarning'] = "n0+3: +h1\$ usER m@y bE INhEr1+1Ng @DD1+1On@l P3RmIssIon5 phr0M aNy UsER gRoup5 l1STED 8elOw.";
$lang['successfullyaddedgroup'] = "sUcC35\$fUllY @DdED 9r0Up";
$lang['successfullyeditedgroup'] = "sucCEssFULlY 3d1+3D Gr0up";
$lang['successfullydeletedselectedgroups'] = "sUCCe\$SFULLy DelE+eD 5EL3C+3d groUps";
$lang['failedtodeletegroupname'] = "f@1L3d T0 D3L3te 9ROUp %s";
$lang['usercanaccessforumtools'] = "u\$3r can 4cCE5\$ F0rum TooL\$ 4nd C4n CRE4+3, d3L3te 4nD Ed1+ PHorUMs";
$lang['usercanmodallfoldersonallforums'] = "u5ER C4n MoD3r4tE <b>aLl pH0LDERS</b> 0n <b>aLl F0RUMs</b>";
$lang['usercanmodlinkssectiononallforums'] = "u5Er CaN moD3R4te l1Nks \$eCT10n on <b>all F0rums</b>";
$lang['emailconfirmationrequired'] = "eM@iL C0nph1RM4t1ON REQU1r3D";
$lang['userisbannedfromallforums'] = "uSer iS 8ann3D from <b>aLL f0RUms</b>";
$lang['cancelemailconfirmation'] = "c4NCEl 3M@IL coNf1RMAT10n 4nD @Ll0w uSEr +0 sT4rt p0\$+iNg";
$lang['resendconfirmationemail'] = "reS3nD C0nf1rma+10n Em4Il To U\$3r";
$lang['donothing'] = "d0 n0THinG";
$lang['usercanaccessadmintools'] = "u\$3r h@s 4CCESs +0 phorUm 4dm1N +ools";
$lang['usercanaccessadmintoolsonallforums'] = "user H@\$ 4cC3SS T0 4dm1N t0OLS <b>oN @ll pHoRuMS</b>";
$lang['usercanmoderateallfolders'] = "user c4n moD3R4+3 4ll PH0ld3R\$";
$lang['usercanmoderatelinkssection'] = "uSer CAn ModeR4+3 LiNks \$eCt10n";
$lang['userisbanned'] = "u\$Er Is 8@NN3d";
$lang['useriswormed'] = "u5Er i\$ w0RmED";
$lang['userispilloried'] = "uSer i5 P1llor13d";
$lang['usercanignoreadmin'] = "u5er c@n 19noRe @DMiN1s+r@t0rs";
$lang['groupcanaccessadmintools'] = "grouP C4n @cC3\$s @DMin +0Ols";
$lang['groupcanmoderateallfolders'] = "gr0Up C@n m0DER4+3 4Ll pH0LD3rs";
$lang['groupcanmoderatelinkssection'] = "gROUP C4N m0DER4+3 lInK\$ 5ECT10n\$";
$lang['groupisbanned'] = "grOUP 1s 84nneD";
$lang['groupiswormed'] = "gr0up 1s W0rmED";
$lang['readposts'] = "re@d po\$+S";
$lang['replytothreads'] = "r3PLY +0 tHr3@d\$";
$lang['createnewthreads'] = "cr34+3 new thRE4DS";
$lang['editposts'] = "ed1t pos+s";
$lang['deleteposts'] = "dEl3tE pOs+s";
$lang['postssuccessfullydeleted'] = "p0S+s suCC3s\$fUlLy dELe+ED";
$lang['failedtodeleteusersposts'] = "f4iL3D t0 D3letE U\$3R's po5ts";
$lang['uploadattachments'] = "uPl0aD @+t4chmeNt\$";
$lang['moderatefolder'] = "moder4T3 F0ld3R";
$lang['postinhtml'] = "p0st 1N h+Ml";
$lang['postasignature'] = "poS+ @ s1GN4+uRE";
$lang['editforumlinks'] = "eDit f0RuM LinK\$";
$lang['linksaddedhereappearindropdown'] = "liNKs 4dD3D h3r3 4pp3ar 1n 4 DR0p d0wn in +3H Top Righ+ 0ph th3 phR4m3 \$e+.";
$lang['linksaddedhereappearindropdownaddnew'] = "liNKs @DD3d h3RE @ppE4R 1N @ DR0p D0wn 1n th3 +0p R19h+ 0F +EH PhR4M3 \$et. +0 4Dd @ l1Nk cLick the '@Dd neW' BUTt0n BEL0w.";
$lang['failedtoremoveforumlink'] = "f4Il3d to reM0v3 ph0rum LInK '%s'";
$lang['failedtoaddnewforumlink'] = "f@il3D +0 4dD NEW f0rum l1nk '%s'";
$lang['failedtoupdateforumlink'] = "f@il3D +0 upD4+3 f0RuM L1NK '%s'";
$lang['notoplevellinktitlespecified'] = "n0 +0P l3v3l l1nk +1tlE sp3ciFI3D";
$lang['youmustenteralinktitle'] = "j00 mU5+ EN+Er 4 l1nk TiTl3";
$lang['alllinkurismuststartwithaschema'] = "aLl liNk ur1\$ mus+ st4r+ w1+h 4 sChem@ (i.3. h++p://, F+P://, irC://)";
$lang['editlink'] = "eDi+ l1nK";
$lang['addnewforumlink'] = "add n3w ForUM l1nK";
$lang['forumlinktitle'] = "fORUM l1nk +i+L3";
$lang['forumlinklocation'] = "f0rum lInK l0c4+I0n";
$lang['successfullyaddednewforumlink'] = "suCC3sspHUlly 4dD3d NeW pHorUM l1nK";
$lang['successfullyeditedforumlink'] = "sucCeS\$FULly 3di+ED F0RUm LInk";
$lang['invalidlinkidorlinknotfound'] = "inv@lID lInK iD Or l1nk n0+ pHounD";
$lang['successfullyremovedselectedforumlinks'] = "sUCC3ssfULLy rEM0V3d s3Lec+3D L1NkS";
$lang['toplinkcaption'] = "t0p l1Nk C@pTioN";
$lang['allowguestaccess'] = "all0w gU3ST 4cC3Ss";
$lang['searchenginespidering'] = "sE4rCh 3N9ine spID3r1n9";
$lang['allowsearchenginespidering'] = "aLl0w s34rCH EnGiNe sP1D3riNG";
$lang['newuserregistrations'] = "n3w U\$3R rEg1Str4tions";
$lang['preventduplicateemailaddresses'] = "pR3v3nT DUpL1ca+E 3M@IL 4dDre\$se5";
$lang['allownewuserregistrations'] = "aLl0w NEw U53R R3GIs+r@t1ON5";
$lang['requireemailconfirmation'] = "r3Quir3 Em41l ConPhIRm@+10n";
$lang['usetextcaptcha'] = "u5e +3x+-CAP+CH@";
$lang['textcaptchadir'] = "tEx+-C4PTCH@ DirEC+0ry";
$lang['textcaptchakey'] = "t3X+-C4PTCH@ K3Y";
$lang['textcaptchafonterror'] = "t3X+-cAptCH@ has b3En DI\$4Bl3d 4uT0M@+IC4lLy 8Ec4u\$e +h3re 4R3 n0 +ru3 TYp3 f0N+\$ @v@il4BL3 f0R i+ T0 U53. PlE453 Upl04D s0m3 +Rue TyP3 F0N+\$ +o <b>%s</b> 0n Y0ur \$erVEr.";
$lang['textcaptchadirerror'] = "t3xt-captch@ hAs b33N D15@8lED 8eCaU\$E Th3 +3xT_C@PtcH4 d1reC+0rY @nD 1+'\$ \$ub-dir3cT0RiE\$ 4rE n0t wrI+4bL3 8Y +he w38 Serv3R / pHp pRocESs.";
$lang['textcaptchagderror'] = "t3xt-C4p+ChA h4\$ BEen d1\$@8leD BEC@U53 YouR \$ErV3R'\$ php 53tup Do3S n0+ providE sUpP0RT F0r gd 1M@GE m4n1PUl4+I0n 4nd / Or ttph F0Nt sUpP0R+. b0+H 4RE reQUiR3d f0R +3x+-C@P+Cha sUpPort.";
$lang['textcaptchadirblank'] = "teX+-C4p+ch4 dIr3CTOrY 1\$ 8l4Nk!";
$lang['newuserpreferences'] = "nEw u\$eR prEFER3nc3s";
$lang['sendemailnotificationonreply'] = "em4il No+IfiC@+i0N oN REPlY +0 u\$er";
$lang['sendemailnotificationonpm'] = "em@1l no+ifiC4+I0n ON Pm t0 Us3r";
$lang['showpopuponnewpm'] = "sH0w PopUp WheN R3C3ivIN9 n3w pM";
$lang['setautomatichighinterestonpost'] = "s3+ 4UTOM@+1C HIgH 1NTER3St 0n P0\$+";
$lang['postingstats'] = "pOst1ng s+@+S";
$lang['postingstatsforperiod'] = "p0Stin9 st4+5 f0r PErI0D %s +0 %s";
$lang['nopostdatarecordedforthisperiod'] = "n0 pOsT D4+@ RecOrDEd f0R th1\$ p3rIOD.";
$lang['totalposts'] = "t0TAl po\$+s";
$lang['totalpostsforthisperiod'] = "t0t@l p0\$ts F0r +h1S pERi0D";
$lang['mustchooseastartday'] = "mUST Ch00S3 4 staR+ d@y";
$lang['mustchooseastartmonth'] = "must CH0osE 4 st4RT mon+H";
$lang['mustchooseastartyear'] = "mu5+ chO0SE 4 ST4rt ye@R";
$lang['mustchooseaendday'] = "mU5t CHoo5e @ end D4y";
$lang['mustchooseaendmonth'] = "mUS+ CHOOs3 4 end moN+H";
$lang['mustchooseaendyear'] = "muSt CH0Os3 4 EnD yE4R";
$lang['startperiodisaheadofendperiod'] = "s+4r+ p3r1oD 1s @HE4d 0PH 3nd p3ri0D";
$lang['bancontrols'] = "b@n contR0Ls";
$lang['addban'] = "aDd 84n";
$lang['checkban'] = "cHECk B4n";
$lang['editban'] = "eDIT 8@N";
$lang['bantype'] = "b4N +yp3";
$lang['bandata'] = "b@n d@+@";
$lang['bancomment'] = "cOMm3Nt";
$lang['ipban'] = "iP 8an";
$lang['logonban'] = "l0G0N 84N";
$lang['nicknameban'] = "nickn@M3 84N";
$lang['emailban'] = "eM4Il 8AN";
$lang['refererban'] = "r3PHEr3R 84n";
$lang['invalidbanid'] = "iNv4lID 84n ID";
$lang['affectsessionwarnadd'] = "thI5 b4N m4y @FFeCT TEh F0Ll0win9 @cTiV3 U\$3r \$ess10ns";
$lang['noaffectsessionwarn'] = "tHI\$ 8An 4phf3c+\$ n0 AC+iv3 S3\$SIoNs";
$lang['mustspecifybantype'] = "j00 MUs+ \$p3CiFy 4 8an +yP3";
$lang['mustspecifybandata'] = "j00 MUSt speCIPHy Som3 8An D4T4";
$lang['successfullyremovedselectedbans'] = "sucCE\$\$phULlY r3moveD sEL3C+ED 8@N\$";
$lang['failedtoaddnewban'] = "f4IL3D +0 4DD NEW 84n";
$lang['failedtoremovebans'] = "fA1l3D T0 reM0v3 s0M3 0r 4LL oph +h3 s3L3C+3d 8ANs";
$lang['duplicatebandataentered'] = "dupL1C4+3 b4n d4+@ 3nter3D. ple4\$3 cheCk yOuR wilDC@RDS to se3 1ph +h3y @lrE4DY m4+Ch TEh d@t@ Ent3RED";
$lang['successfullyaddedban'] = "succ35\$pHulLy 4DdED 84n";
$lang['successfullyupdatedban'] = "sUCCE\$sfUlly uPD@+3D 8aN";
$lang['noexistingbandata'] = "tH3R3 i5 no 3X1\$+1n9 84N d4+a. T0 @Dd 4 B4n CL1CK +he '4dd n3W' BuTt0n 8el0W.";
$lang['youcanusethepercentwildcard'] = "j00 c4n US3 teH pERC3NT (%) wilDc@rd sYmBol iN @Ny 0F YouR B4n lIs+s +0 0BT4in P@r+I@l m@+ChEs, i.e. '192.168.0.%' w0ULD B4n 4ll ip @dDrE5SE\$ in +3H R@n9e 192.168.0.1 +hr0UGh 192.168.0.254";
$lang['cannotusewildcardonown'] = "j00 C4nN0+ 4DD % 4S 4 w1lDC@RD m@tch On 1t'5 owN!";
$lang['requirepostapproval'] = "r3qUir3 P0st 4pPROV4l";
$lang['adminforumtoolsusercounterror'] = "there mU\$t b3 @+ l345+ 1 USEr w1+h @DMin tooLs 4ND f0ruM +00ls 4ccESs on @ll ph0RUm\$!";
$lang['postcount'] = "p05+ c0UNT";
$lang['resetpostcount'] = "r3s3t p0\$+ C0unt";
$lang['failedtoresetuserpostcount'] = "f@il3d to REs3T P05+ CoUnT";
$lang['failedtochangeuserpostcount'] = "f4IL3d +0 CH4n93 U\$er P05+ C0UNt";
$lang['postapprovalqueue'] = "p0S+ 4PproVal QUEU3";
$lang['nopostsawaitingapproval'] = "n0 po\$ts 4rE 4wA1+ing 4pprOv@l";
$lang['approveselected'] = "appR0v3 \$El3c+3D";
$lang['failedtoapproveuser'] = "f4IleD +0 4pPr0V3 user %s";
$lang['kickselected'] = "k1ck seL3CT3d";
$lang['visitorlog'] = "v15I+or l09";
$lang['clearvisitorlog'] = "cl34r v1\$it0R L0G";
$lang['novisitorslogged'] = "n0 V1\$i+Ors log93D";
$lang['addselectedusers'] = "add \$elEctED USErs";
$lang['removeselectedusers'] = "r3m0V3 \$el3c+3D userS";
$lang['addnew'] = "aDd N3W";
$lang['deleteselected'] = "d3L3+E \$el3C+3D";
$lang['forumrulesmessage'] = "<p><b>f0rUm rUl3s</b></p><p>\nR39istr4T10N To %1\$\$ is fr33! we D0 1N\$iS+ +H4+ J00 4B1de 8y TEH rUl3S @nD pOl1C13s D3t4IlED 8EL0w. IF J00 4gr3e t0 +3H +3RMS, pLE453 cH3Ck +h3 'i @Gr3e' CheCKB0X @nd pr3SS tEh 're91\$+ER' 8U+TOn bEloW. iPh j00 w0UlD like T0 C@nC3l tHe r3G1s+r4+10n, cLICk %2\$s TO rEtuRn +0 t3h f0RUms 1NDex.</p><p>\n@l+h0U9h +eH ADm1Nistr4+0rs AND m0dErAToRS 0f %1\$5 WIlL ATt3MpT t0 k3Ep 4Ll O8jEC+i0N48Le M3S\$49E5 OpHf +H15 F0rUM, It 1S ImP0SS1BlE phor U5 +O R3Vi3W 4lL mE5\$4GES. @LL mEss4g3s ExprESS th3 V13W5 oF +h3 4Uthor, 4nd N31+hEr +hE 0wn3rS 0PH %1\$S, noR proj3C+ 8E3H1VE F0Rum 4Nd i+'\$ 4PHfIli4+3s w1lL be hEld r3Sp0N\$I8l3 F0r t3H ConteNT oPh 4Ny meSS493.</p><p>\n8Y 4GR3E1nG +0 +hEs3 rUl3s, J00 W4Rr4nT +H@+ j00 WiLl N0+ p05+ 4NY M3SSa93\$ +H4+ @Re o8sC3n3, vUl94r, SExU4LLY-orien+ated, h4+3pHUL, +hr34+en1Ng, 0r 0THErw1\$3 v10laTIV3 opH @ny l4Ws.</p><p>tEH OWn3rS oph %1\$S re\$3rV3 teh ri9ht t0 r3mov3, ed1+, m0v3 0R cl0se any Thr34d ph0r 4Ny rE@son.</p>";
$lang['cancellinktext'] = "h3re";
$lang['failedtoupdateforumsettings'] = "f4IL3d +o UpD4+3 FoRuM seTt1Ng5. pLEA53 tRy 4G@iN lATer.";
$lang['moreadminoptions'] = "moRE 4Dm1N Op+I0N5";

// Admin Log data (admin_viewlog.php) --------------------------------------------

$lang['changedstatusforuser'] = "ch4n93d u\$3R \$t4+Us f0R '%s'";
$lang['changedpasswordforuser'] = "ch@N9ED P@5\$w0rD F0R '%s'";
$lang['changedforumaccess'] = "chang3D fOrUM aCC3S\$ PERmI\$SI0n5 pHor '%s'";
$lang['deletedallusersposts'] = "del3t3D @lL po\$+s f0r '%s'";

$lang['createdusergroup'] = "creatED US3R gR0UP '%s'";
$lang['deletedusergroup'] = "d3L3+3D USER 9r0up '%s'";
$lang['updatedusergroup'] = "uPd4+ED U\$eR 9ROUp '%s'";
$lang['addedusertogroup'] = "aDDeD UsEr '%s' To Gr0up '%s'";
$lang['removeduserfromgroup'] = "r3Mov3 USeR '%s' from 9roUP '%s'";

$lang['addedipaddresstobanlist'] = "add3D 1p '%s' tO 84n li\$+";
$lang['removedipaddressfrombanlist'] = "rEM0V3d iP '%s' PHrom B4N L1\$+";

$lang['addedlogontobanlist'] = "aDd3D l0gon '%s' TO B4n l1\$+";
$lang['removedlogonfrombanlist'] = "rEm0v3d logOn '%s' Phrom b4N Lis+";

$lang['addednicknametobanlist'] = "add3d NiCkNaMe '%s' +0 8an li\$t";
$lang['removednicknamefrombanlist'] = "r3mov3D n1ckN4ME '%s' Phr0M 8@n L1\$t";

$lang['addedemailtobanlist'] = "added 3MA1l 4ddREs\$ '%s' +o B4n l1\$t";
$lang['removedemailfrombanlist'] = "r3m0v3D 3m@iL 4dDrE5\$ '%s' fr0m 84n Li\$+";

$lang['addedreferertobanlist'] = "addeD R3ph3reR '%s' +o 84n lI\$+";
$lang['removedrefererfrombanlist'] = "r3M0v3D rEPheREr '%s' PHRoM BAn lI\$+";

$lang['editedfolder'] = "eD1tED fOlD3r '%s'";
$lang['movedallthreadsfromto'] = "m0vED All Thr3@d\$ PhR0m '%s' t0 '%s'";
$lang['creatednewfolder'] = "cr3@T3d n3W Ph0lDEr '%s'";
$lang['deletedfolder'] = "d3L3+3d F0LDEr '%s'";

$lang['changedprofilesectiontitle'] = "cH4ngED prof1l3 sECT10n t1+L3 fR0M '%s' +o '%s'";
$lang['addednewprofilesection'] = "added NEw PrOF1L3 sECT10N '%s'";
$lang['deletedprofilesection'] = "dEL3t3d Prof1l3 5ECtion '%s'";

$lang['addednewprofileitem'] = "aDdeD NEw pR0Phil3 1t3m '%s' +0 sECTIoN '%s'";
$lang['changedprofileitem'] = "ch4nG3D prophIl3 i+Em '%s'";
$lang['deletedprofileitem'] = "deL3+3D pR0Ph1l3 iTEm '%s'";

$lang['editedstartpage'] = "ed1+3D st4Rt P@GE";
$lang['savednewstyle'] = "saV3D nEw \$+YL3 '%s'";

$lang['movedthread'] = "m0V3d +hr34d '%s' fr0M '%s' +0 '%s'";
$lang['closedthread'] = "cLO53D +hr3@D '%s'";
$lang['openedthread'] = "opENED +hr34D '%s'";
$lang['renamedthread'] = "ren@m3D tHre4d '%s' +0 '%s'";

$lang['deletedthread'] = "dELe+3D Thr34d '%s'";
$lang['undeletedthread'] = "uNd3LEted +hR3Ad '%s'";

$lang['lockedthreadtitlefolder'] = "l0ck3D +Hr3@D 0PT10n5 on '%s'";
$lang['unlockedthreadtitlefolder'] = "uNLoCKED +hre4D oPt10n\$ oN '%s'";

$lang['deletedpostsfrominthread'] = "deLEt3d Po\$+s phr0m '%s' 1N +hR34D '%s'";
$lang['deletedattachmentfrompost'] = "dEl3tED @+t@CHM3N+ '%s' fr0M Po\$+ '%s'";

$lang['editedforumlinks'] = "edi+eD phorUm l1nks";
$lang['editedforumlink'] = "ed1+eD f0RUM l1nk: '%s'";

$lang['addedforumlink'] = "aDdeD F0RuM l1nk: '%s'";
$lang['deletedforumlink'] = "d3L3+3D Ph0rUm l1nk: '%s'";
$lang['changedtoplinkcaption'] = "cH4NGED +op lInK CAp+i0n pHROm '%s' To '%s'";

$lang['deletedpost'] = "d3L3TED P0\$+ '%s'";
$lang['editedpost'] = "ed1teD Po\$+ '%s'";

$lang['madethreadsticky'] = "m4d3 thRE4D '%s' sT1CKY";
$lang['madethreadnonsticky'] = "m4D3 Thr3@d '%s' noN-s+icKy";

$lang['endedsessionforuser'] = "enD3d 5Es\$ION f0r U\$eR '%s'";

$lang['approvedpost'] = "aPPR0v3D posT '%s'";

$lang['editedwordfilter'] = "eD1+ED wOrD F1L+3r";

$lang['addedrssfeed'] = "aDdeD r5\$ PHE3d '%s'";
$lang['editedrssfeed'] = "edited R5\$ Fe3D '%s'";
$lang['deletedrssfeed'] = "d3LE+ED r\$S F3eD '%s'";

$lang['updatedban'] = "uPD@teD BAN '%s'. CHAnGED +ypE FRoM '%s' +O '%s', cHaNgeD D@t@ FrOm '%s' tO '%s'.";

$lang['splitthreadatpostintonewthread'] = "sPLi+ +hr34d '%s' @+ p05+ %s  1N+0 new +Hr34D '%s'";
$lang['mergedthreadintonewthread'] = "mer9ED +hr34D\$ '%s' 4ND '%s' 1Nt0 n3W +hr3AD '%s'";

$lang['approveduser'] = "aPpr0v3d UsEr '%s'";

$lang['forumautoupdatestats'] = "fORum @U+0 UpDA+E: s+@+s UPD@+3D";
$lang['forumautoprunepm'] = "f0rUm @uT0 UPd4+3: pm PhoLDErs prUN3D";
$lang['forumautoprunesessions'] = "f0Rum aUt0 UPDATE: 53ss1On\$ prun3D";
$lang['forumautocleanthreadunread'] = "foRUM 4U+0 upDa+E: ThRe4d UnR34d D@t@ CL34n3d";
$lang['forumautocleancaptcha'] = "forum Aut0 uPd@+3: +3xT-C@ptch4 1M49ES Cl34NED";

$lang['adminlogempty'] = "admin lO9 1\$ 3mp+y";

$lang['youmustspecifyanactiontypetoremove'] = "j00 mus+ 5P3cipHy 4n 4C+10n tyP3 To R3M0Ve";

$lang['removeentriesrelatingtoaction'] = "reM0v3 3ntRIEs R3L@+iNg T0 aC+ION";
$lang['removeentriesolderthandays'] = "rEm0v3 3ntR13s 0LDER tHAn (D@ys)";

$lang['successfullyprunedadminlog'] = "sUCC35\$fuLly prUN3D aDM1N Log";
$lang['failedtopruneadminlog'] = "f4il3D +0 prUNE 4dm1N lo9";

$lang['prune_log'] = "prune lo9";

// Admin Forms (admin_forums.php) ------------------------------------------------

$lang['noexistingforums'] = "no 3xi\$t1Ng pH0RuM\$ Ph0unD. +0 CRE@+3 4 nEw f0ruM cLiCK thE '4DD nEw' BU+T0n BEL0w.";
$lang['webtaginvalidchars'] = "w38+49 c4N onLY CoNt41N uPPErCAsE @-z, 0-9 @nD UnDEr\$coRE cHaR4C+ER\$";
$lang['databasenameinvalidchars'] = "daT@84\$3 n4M3 C4n onLY C0nt4In @-z, 4-z, 0-9 AND UND3r\$corE CHAr4C+ERs";
$lang['invalidforumidorforumnotfound'] = "inv4l1D f0rum ph1D oR pHorUM n0t F0unD";
$lang['successfullyupdatedforum'] = "suCc3\$SFUlLy UpD@tED PhorUm";
$lang['failedtoupdateforum'] = "f@iL3d +0 upD4+3 F0RUM: '%s'";
$lang['successfullycreatednewforum'] = "succE\$SpHUllY CRE4+3d NEw f0RUM";
$lang['selectedwebtagisalreadyinuse'] = "teH selEC+3D w3bTa9 is @LrE4DY 1N UsE. Pl3453 CHoO\$3 4N0THER.";
$lang['selecteddatabasecontainsconflictingtables'] = "th3 \$EL3c+3D d@t4b@\$3 COn+4Ins C0nphlIc+INg +4bl35. COnflICT1nG +4blE n@m3S 4re:";
$lang['forumdeleteconfirmation'] = "arE J00 \$ure J00 W4N+ t0 d3LeTe @lL oF +h3 Sel3CT3D FORUms?";
$lang['forumdeletewarning'] = "pL34\$3 not3 th@+ j00 C@nno+ r3COv3R DELe+Ed PHoRumS. ONCe d3let3D @ ph0Rum @nD @Ll OPh 1+'s @Ss0Ci4+3d D4Ta Is P3Rm4n3N+ly RemOVED fR0M +He D4tA84SE. 1F j00 D0 Not Wish tO d3LeTE tHE s3LEc+eD ph0RuM\$ plE45e cliCK C@nCeL.";
$lang['successfullyremovedselectedforums'] = "sUcC3\$SFUlly DeLE+3D s3LEctEd F0RUm5";
$lang['failedtodeleteforum'] = "f4Il3d T0 DELE+ED phorUM: '%s'";
$lang['addforum'] = "add pHoruM";
$lang['editforum'] = "eDi+ F0RUM";
$lang['visitforum'] = "v15i+ f0ruM: %s";
$lang['accesslevel'] = "aCcEss l3vel";
$lang['forumleader'] = "f0RUm l34D3r";
$lang['usedatabase'] = "use d@t4b4\$e";
$lang['unknownmessagecount'] = "unKN0wn";
$lang['forumwebtag'] = "foruM W3b+49";
$lang['defaultforum'] = "d3f4uLt phorUm";
$lang['forumdatabasewarning'] = "pLe4s3 En5uRE J00 S3leC+ TH3 corrEC+ D@+@BaSE Wh3N CRE4tin9 @ N3w f0ruM. OncE CRE4t3D 4 neW phoRuM C@nn0t 8e M0V3d B3tweEn @V@Il@8LE D@+@84\$e\$.";

// Admin Global User Permissions

$lang['globaluserpermissions'] = "gL084L U53R P3RmI\$5ioN\$";

// Admin Forum Settings (admin_forum_settings.php) -------------------------------

$lang['mustsupplyforumwebtag'] = "j00 mus+ \$upplY 4 f0RUm W38+@9";
$lang['mustsupplyforumname'] = "j00 MUst suPpLY 4 foRUm n4me";
$lang['mustsupplyforumemail'] = "j00 must sUpPlY a ph0rUm 3M4Il aDdr3SS";
$lang['mustchoosedefaultstyle'] = "j00 muST Cho0SE @ D3faUl+ Ph0rUM 5+ylE";
$lang['mustchoosedefaultemoticons'] = "j00 mUSt cH00\$3 d3PH@uLt F0RUM 3MOtiC0ns";
$lang['mustsupplyforumaccesslevel'] = "j00 must suppLy a F0RUm @Cc3ss l3vEl";
$lang['mustsupplyforumdatabasename'] = "j00 mUst supPlY 4 pHoRuM DAt4b@\$3 n4m3";
$lang['unknownemoticonsname'] = "uNknown 3mOT1con5 N4me";
$lang['mustchoosedefaultlang'] = "j00 must CHoo\$3 a d3F4ul+ f0rum L4NGU@g3";
$lang['activesessiongreaterthansession'] = "aC+1VE sE\$s1on +iM3OUT CANn0+ b3 GR34tER +H4N s3sS1on tIm3ou+";
$lang['attachmentdirnotwritable'] = "aT+4chMEnT d1r3C+ory 4ND sy\$Tem +3mPORArY D1reC+0ry / pHP.InI 'uPl0@D_tMp_DiR' mU\$t B3 wr1+@BLE 8Y +HE w3b s3RVer / pHP pR0C3S\$!";
$lang['attachmentdirblank'] = "j00 must suppLy 4 DIREC+0RY t0 S@Ve @+t4chMEn+s in";
$lang['mainsettings'] = "m@1n s3++ings";
$lang['forumname'] = "f0rUm n@mE";
$lang['forumemail'] = "f0rum Em4IL";
$lang['forumnoreplyemail'] = "no-r3ply EM4Il";
$lang['forumdesc'] = "f0Rum d3SCR1ptION";
$lang['forumkeywords'] = "f0RUM kEyW0rDs";
$lang['defaultstyle'] = "d3Ph4ulT s+yLE";
$lang['defaultemoticons'] = "d3F4ult 3mo+ICon\$";
$lang['defaultlanguage'] = "d3f4ult l4n9U4GE";
$lang['forumaccesssettings'] = "f0rum 4cCEss \$eT+1ng\$";
$lang['forumaccessstatus'] = "foRUm @CC3ss st4+U\$";
$lang['changepermissions'] = "ch4n9E P3Rm1\$\$1On\$";
$lang['changepassword'] = "cHan93 p45\$W0RD";
$lang['passwordprotected'] = "p@s\$WOrD pR0+3c+3D";
$lang['passwordprotectwarning'] = "j00 H@VE n0t se+ 4 F0RUM pA5SWorD. iF J00 Do n0T sE+ @ paSsw0rD tEH Passw0RD pRotEC+1ON PhUnC+i0NaLi+y W1LL 83 @U+0m@+IC4lly D1S4blED!";
$lang['postoptions'] = "pOs+ 0p+10n\$";
$lang['allowpostoptions'] = "allow po\$+ 3DITiNg";
$lang['postedittimeout'] = "p0ST ED1+ t1me0u+";
$lang['posteditgraceperiod'] = "p0\$t ed1+ gRaC3 pErIod";
$lang['wikiintegration'] = "wikiwiK1 1NTegr4T10n";
$lang['enablewikiintegration'] = "eN48LE WiKiwik1 1ntEGr@+i0N";
$lang['enablewikiquicklinks'] = "eNA8LE W1KIwikI QU1CK LinKs";
$lang['wikiintegrationuri'] = "wIk1wIk1 loC4+10n";
$lang['maximumpostlength'] = "m4XImUm post l3Ng+h";
$lang['postfrequency'] = "poST phrEQU3nCy";
$lang['enablelinkssection'] = "ena8l3 l1nKS sECT1On";
$lang['allowcreationofpolls'] = "aLL0w crEa+10n 0PH poLl\$";
$lang['allowguestvotesinpolls'] = "aLL0w gU3sTs T0 V0+3 1N p0llS";
$lang['unreadmessagescutoff'] = "uNre4D m3S\$ages CU+-opHF";
$lang['unreadcutoffseconds'] = "sEc0ND5";
$lang['disableunreadmessages'] = "dI\$4BlE UnrE4D m3sS493s";
$lang['thirtynumberdays'] = "30 D4y\$";
$lang['sixtynumberdays'] = "60 D@yS";
$lang['ninetynumberdays'] = "90 DaY\$";
$lang['hundredeightynumberdays'] = "180 daY5";
$lang['onenumberyear'] = "1 ye4R";
$lang['searchoptions'] = "s3arch optiOn5";
$lang['searchfrequency'] = "s3ArCH fr3QU3ncy";
$lang['sessions'] = "s3\$Si0N\$";
$lang['sessioncutoffseconds'] = "sE\$\$10N CUT 0PhPh (sECOnD\$)";
$lang['activesessioncutoffseconds'] = "acT1v3 SE\$si0N CU+ OphPh (sECOnDS)";
$lang['stats'] = "s+4t\$";
$lang['hide_stats'] = "h1D3 \$TAts";
$lang['show_stats'] = "shOW \$+4T\$";
$lang['enablestatsdisplay'] = "eN@8LE st4+\$ displ4y";
$lang['personalmessages'] = "peR\$0n@l m3SsA93s";
$lang['enablepersonalmessages'] = "eN4Bl3 p3RS0n4L M3ssa93s";
$lang['pmusermessages'] = "pm m3ss4gEs p3r useR";
$lang['allowpmstohaveattachments'] = "aLl0w PErs0nal m3SS49es +0 havE 4tt4CHMENT5";
$lang['autopruneuserspmfoldersevery'] = "au+o PRUN3 u53r'\$ pM PHolD3rs 3vERy";
$lang['userandguestoptions'] = "u5er @nD 9u3st op+1ONs";
$lang['enableguestaccount'] = "eN@8le gU3st 4cCounT";
$lang['listguestsinvisitorlog'] = "l1\$T Gu3StS iN v1\$1TOR l0g";
$lang['allowguestaccess'] = "aLl0w gU3ST 4cCE\$s";
$lang['userandguestaccesssettings'] = "u\$Er @nD GUe5+ @CcEss \$ET+1NGS";
$lang['allowuserstochangeusername'] = "aLl0w U\$eR\$ +0 Ch4NGE U\$3rn4m3";
$lang['requireuserapproval'] = "rEQU1RE usEr @PpR0VaL BY 4dmin";
$lang['requireforumrulesagreement'] = "requ1R3 u53r +0 49RE3 +O F0rum rULE\$";
$lang['enableattachments'] = "en4bLE @++@CHM3nts";
$lang['attachmentdir'] = "a++AChMeNt DIr";
$lang['userattachmentspace'] = "at+@CHm3Nt sP4C3 p3R usER";
$lang['allowembeddingofattachments'] = "aLL0W 3MbEDDINg oph @++@CHm3nts";
$lang['usealtattachmentmethod'] = "uSe 4LTErn4+iv3 at+@ChmEnT ME+h0d";
$lang['allowgueststoaccessattachments'] = "aLloW 9U3S+S +o aCc3ss 4t+@CHM3N+s";
$lang['forumsettingsupdated'] = "fOrum s3+t1N95 5uCCEssfullY UpD4ted";
$lang['forumstatusmessages'] = "fOrum \$TA+Us m3Ss49ES";
$lang['forumclosedmessage'] = "fOrum CLO\$ED mESs4G3";
$lang['forumrestrictedmessage'] = "f0rum r3\$+riCTeD M3SS49e";
$lang['forumpasswordprotectedmessage'] = "foRuM P4s\$w0RD PR0+3c+ED MEss4GE";

// Admin Forum Settings Help Text (admin_forum_settings.php) ------------------------------

$lang['forum_settings_help_10'] = "<b>p0s+ EDi+ +imeOu+</b> IS tHE TIme In mINUTEs 4PH+3r po\$+1nG TH@+ a U\$3r C4n eD1+ +H31r pOst. If \$3T to 0 +hErE 1S n0 lIMi+.";
$lang['forum_settings_help_11'] = "<b>m@XiMUm Po\$+ L3NGtH</b> Is +Eh M4xiMuM NuM8ER Of ch4raC+3Rs ThAt w1ll bE D1spl4y3D in @ pOs+. if @ po\$+ i\$ LOn9er tH@n +H3 NUmb3r OpH cH4R4CtEr\$ DepH1NEd h3RE 1T W1LL 8e CU+ sH0rt 4nd 4 l1nK @DD3d to +H3 8o++0M t0 4Ll0w u\$er\$ +0 rE4D +3h whOle p0S+ ON a sEP@r@tE P@ge.";
$lang['forum_settings_help_12'] = "if j00 d0N'+ W4N+ your Us3rs T0 BE 4bl3 to CRE4TE PoLls j00 c4n D1\$4BL3 tEh 4B0v3 0pt10n.";
$lang['forum_settings_help_13'] = "tH3 liNkS \$eCt10N 0ph bEEH1v3 PR0V1d3s @ Pl4ce f0r y0ur usER\$ +0 Ma1n+@In @ li\$+ oF 51tes +h3y phr3qu3NTly Vi\$I+ +h@+ 0ThER UsEr\$ m4y phinD us3fUl. lInks C4n BE dIvID3d In+o c4te90riEs 8y f0LD3r @nd @lLoW For c0MM3nt\$ And r@+iNgs +0 83 giVEn. 1n 0rDEr t0 moder4T3 thE link\$ SECtion @ U\$3r mU\$+ 8E r@ntED Glo8Al m0DEr4+or 5+4TUS.";
$lang['forum_settings_help_15'] = "<b>s3\$si0N CU+ oFpH</b> Is tH3 m4xiMuM T1M3 8ePhoRE A usEr'5 53SS10n 1S d3emED DE4d anD +H3Y 4RE lO9GED oUT. BY DeF@ULt +H1\$ i\$ 24 HOUr5 (86400 sEC0nds).";
$lang['forum_settings_help_16'] = "<b>acTive sEssI0n CU+ 0FPh</b> 1S tHE M@XImUM tim3 BEF0RE a Us3R'\$ SE\$S1on i\$ d3EMED In@Ct1ve @+ WHich p01nt +hEY En+3R 4n iDlE St4+3. In th1S 5+@+3 Teh UsER REM4Ins lOggeD 1N, BU+ +HEy @r3 r3M0veD phRom th3 4CTiVE u53R\$ L1ST In +he \$+4t\$ di5PL4y. ONCe th3Y 8eC0M3 4Ct1V3 A9@1N +hEy will 83 r3-addED +0 th3 Li\$T. 8Y d3pH@Ul+ tHIS \$EttiNG is se+ +0 15 minu+3\$ (900 seC0Nds).";
$lang['forum_settings_help_17'] = "eN@8l1Ng +His 0P+10n 4lLoWs BEEh1v3 T0 incLUDE 4 st4+5 dI\$pl4Y 4T +H3 8o++0m oph TEh MEs54g3s p4N3 s1Mil@r +O +h3 0n3 UsED by M4ny f0RUM \$of+W4RE +1+l3s. oncE EN4bLED +h3 D1\$Pl4y oF tH3 \$tats pA93 C4N B3 TO99LEd INdIvIDUaLlY bY 3ACH UsEr. iF +hey D0n't wan+ +0 SEE it they Can h1D3 it fRom viEW.";
$lang['forum_settings_help_18'] = "p3R50N4L mESs4G3s 4RE Inv@LU48lE @\$ 4 w4y 0ph t4KInG M0RE Pr1v@+E M4TTER\$ 0u+ 0f vi3W 0PH tHE 0TH3r mEm83rs. how3vEr 1F J00 D0n't w4nt y0UR UsER5 To BE @8lE +0 seND E4ch 0th3r PER50N4L M3S\$@g3s j00 C@N D1s4BL3 Th1S 0pt10N.";
$lang['forum_settings_help_19'] = "pER\$0n4L m3Ssa93s CAN 4LS0 con+@IN @T+4chmENTs Wh1ch CAN 8E UsEPhUl FoR 3xCh4N9ing phiL3S 8etwE3N u5er\$.";
$lang['forum_settings_help_20'] = "<b>n0t3:</b> tEh sp4CE @LloC4tion pHor pM @++4CHmENtS Is +@keN pHr0m 34Ch USer\$' Ma1n @++4chm3n+ @lloc@+1on 4nd i5 n0t 1N 4dDI+1On +O.";
$lang['forum_settings_help_21'] = "<b>en48lE GU3\$t 4ccOUnT</b> @LlOw5 vIsi+0RS T0 BR0w53 yoUR pH0RUM AND r34D P05+S Wi+H0U+ R3gis+ER1ng @ UsER aCC0uNt. @ User ACc0UNt 1\$ \$+1ll R3quIR3d iph tHEY wi\$h +0 p0St or CH4ng3 U\$er pR3PHER3nCe5.";
$lang['forum_settings_help_22'] = "<b>l1S+ 9u3sTs 1n VI\$IT0r l0G</b> @lloW5 j00 to sp3CIpHy WH3+Her oR N0T UnR3giS+ERED U\$3r\$ 4rE L1S+ED On tEH VIsiT0r L0G 4lOn9 5ID3 r3g15+Er3d usERs.";
$lang['forum_settings_help_23'] = "bEEhiv3 4llows 4+t4CHM3Nts +0 8e uPl0@D3D to Mess49e\$ wH3n pos+3d. iPh j00 H4v3 liM1+ED w38 sp@CE j00 M4Y Wh1ch +0 D1\$4Bl3 4++4chm3Nt\$ By ClE4r1Ng Th3 box AB0v3.";
$lang['forum_settings_help_24'] = "<b>at+4chm3Nt DIr</b> Is ThE lOC4tion 833hIv3 Sh0ulD 5+0rE i+'s At+@ChmenTs In. +hi5 d1r3CtoRy mU5+ 3xi\$+ on y0UR wE8 Sp4CE @Nd mUs+ B3 wr1T48l3 8y +3h wEB \$erv3R / phP PrOC3SS 0tH3RWi\$3 Uplo@D\$ WILl ph@Il.";
$lang['forum_settings_help_25'] = "<b>aTtaChm3nt SP@c3 PER UsEr</b> is +EH m@xImUM @m0unt 0ph D1SK 5P4c3 @ UsER H@\$ Ph0r @++4chMenTs. oNCE +his \$p@cE 1\$ Us3d Up th3 usER c4nn0T UplO4d aNy m0re 4T+@cHmENts. BY d3pH4Ult thIs Is 1m8 0f 5p4c3.";
$lang['forum_settings_help_26'] = "<b>aLLow eM83dDIn9 0F ATt4ChMEntS in M3Ss4G3s / S1gn4tuR3s</b> 4ll0W\$ Us3RS TO 3M8ed @+T@Chm3NTs IN po\$+s. 3n48liNg THis oPt1ON WHil3 U53PhUL C4n InCRE4s3 yOUr B4NdWIdTh us49E dR@s+iCaLlY uNDEr CER+aIn conFIgUr@TioNs oF Php. 1ph j00 h@Ve L1mI+ED 8@NDWID+h IT Is reCoMM3nD3D +H@t j00 d1SA8L3 th1S 0p+Ion.";
$lang['forum_settings_help_27'] = "<b>u\$E 4l+3Rn4TIV3 4++4cHMeNT MethOd</b> PHoRc3S 8e3hiVE +0 u\$e 4N @ltErN4TiVE ReTRI3V4L MEtH0D PHoR 4+T@CHm3Nts. 1F j00 reCeIV3 404 eRROr M3ss@93S WheN +RY1nG +0 d0WNLo@D 4t+4CHM3n+\$ PhR0M mE\$54gE5 +RY En48lING +HI5 Opt10n.";
$lang['forum_settings_help_28'] = "th1S s3Tt1nG 4lloWs youR PH0RUm +0 Be \$PID3r3D 8Y s34RCH 3NG1N3S L1k3 G0o9l3, @l+@Vi\$+4 4ND y4hO0. iph J00 \$w1+CH ThIs 0p+I0n ophPh yOUr pH0RUm w1LL NoT 83 InCLUDED in tH3S3 s3@RCh 3ng1Ne\$ rE5ul+s.";
$lang['forum_settings_help_29'] = "<b>all0W n3w us3r R39Is+r4T1ons</b> ALlOw\$ 0r Di\$@llow\$ th3 CR3@+i0N of NEW Us3r 4CcouNtS. se+t1ng +H3 0p+1On To n0 c0MPl3teLy DI54BL3s +EH rE9is+r4T10N f0rm.";
$lang['forum_settings_help_30'] = "<b>enA8lE w1kiwIkI 1N+eGR@Tion</b> PR0VID3S w1K1w0RD sUpp0RT 1n YOUR f0RUM P0\$+s. @ wiKiworD iS m@d3 up 0f two 0R m0re conC4+3n4+3d woRDs with uPpErC4\$E l3TTEr\$ (OpH+3N R3FErred +o 4s C4melC4\$3). 1F J00 wri+3 4 woRD tHis w@y 1+ w1ll aU+om4+1C@lly BE cHaN9ed 1N+o 4 hyp3rLInk Po1nt1Ng t0 y0ur Cho\$3n w1k1WIK1.";
$lang['forum_settings_help_31'] = "<b>enABLE wIkiwiK1 QU1ck l1nks</b> 3n4BLEs +EH Use 0f Msg:1.1 @nD U5Er:log0N sTyL3 3x+3ND3d W1K1L1NKs wh1ch CREA+3 Hyp3rlinks tO +hE sp3CIFied mEss49E / UsER pRophiL3 0ph TEH \$P3CiPhi3d UsER.";
$lang['forum_settings_help_32'] = "<b>w1kiw1ki loc4tion</b> 1s used +0 sPeCIPHy +HE ur1 OPH y0ur wIkIWiki. WhEN 3NTERiNg +h3 uR1 Us3 <i>%1\$\$</i> To 1nDICA+E Wh3rE iN +hE ur1 t3h wIkIw0rD 5H0ULD 4pp3@R, 1.3.: <i>h++p://En.wIkiP3D1@.Or9/wiki/%1\$S</i> WoulD Link y0UR wiKiwoRDs +0 %s";
$lang['forum_settings_help_33'] = "<b>fOrum @CC3ss st4Tus</b> c0N+r0LS hOw useR5 M4y @cCE5S yoUR pH0RUM.";
$lang['forum_settings_help_34'] = "<b>oPeN</b> will @Ll0W 4lL U53r\$ 4nd Gu3sTs 4CCess +0 y0UR PHorum Wi+h0ut r3s+RIct10n.";
$lang['forum_settings_help_35'] = "<b>cLO\$eD</b> Pr3V3nts 4CCEss pH0R 4Ll user\$, w1+h tH3 ExC3P+1ON opH +3H @DMIn Wh0 may 5+1ll 4CC3\$\$ +h3 4DM1n P@N3l.";
$lang['forum_settings_help_36'] = "<b>rE5Tric+3d</b> ALlows +0 SE+ A List of U53rs wH0 @rE @ll0W3D aCCESs T0 y0Ur phOrUm.";
$lang['forum_settings_help_37'] = "<b>p@5SW0rd Pro+3c+3D</b> @Llows j00 t0 Set 4 P4\$sw0RD +0 g1VE ouT t0 usErs S0 +H3Y C4n acCEss y0UR ForUM.";
$lang['forum_settings_help_38'] = "when s3+t1NG rE5+RICT3d oR P@ssw0RD PRotec+3D m0de j00 W1ll n3eD To \$@v3 yOUR Ch4ngE\$ b3f0RE J00 CAn CH@Ng3 t3H USEr @CC3ss pr1ViL3ges 0R P4SswoRD.";
$lang['forum_settings_help_39'] = "<b>Search Frequency</b> defines how long a user must wait before performing another search. Searches place a high demand on the database so it is recommended that you set this to at least 30 seconds to prevent \"search spamming\"fRom kill1Ng +hE \$3rv3r.";
$lang['forum_settings_help_40'] = "<b>p0st PHReQUENcy</b> I\$ TH3 mIn1MUm T1M3 4 u\$ER mU\$+ W41+ 8EFoR3 tHEY C4n p0sT 4g41n. Th1\$ \$E++1n9 4ls0 4phphECTs +3H CRE4+i0n 0PH p0lL\$. sET +0 0 to D1\$@8lE +H3 r3STrICT1ON.";
$lang['forum_settings_help_41'] = "tH3 @boV3 0p+1oNs ch4NGe +hE DEPH4UL+ v4lu35 PhOr the U\$3r r3gistr4t1On F0RM. wH3re @pPliC@ble 0THeR \$3++InG\$ WILL U\$3 teh f0rum'\$ oWn D3F4ul+ s3Tt1N9\$.";
$lang['forum_settings_help_42'] = "<b>pReven+ u5E 0ph DUpLic@+E 3m41l aDDR3ss3S</b> Ph0RC3s B3ehIV3 +o CH3ck tEH U\$3r @CCoUNTs 494in\$+ +h3 eM41l ADDrE5\$ +3h U\$er 1\$ RE9is+erInG W1Th @ND Pr0mPTS thEM To U\$E @nO+hER 1F 1+ Is 4lr34dy In UsE.";
$lang['forum_settings_help_43'] = "<b>rEqu1r3 EM4il C0NPh1rm@+I0n</b> WhEn 3N4bleD w1ll senD 4n 3M4IL +o E@Ch nEW useR w1+h A link Th@+ c4n BE UsED To ConphIrM tHEir 3m4Il @Ddress. UNT1L ThEY c0nph1rm Th31r Em4il 4Ddr3ss +hEY w1LL N0T B3 4BLE +o p0\$+ UnlESs +h31R u53R perMIssi0n\$ @RE CH4n9Ed m4NU4lly 8y @n @Dmin.";
$lang['forum_settings_help_44'] = "<b>usE tExt-Cap+CH@</b> PR3\$En+5 +h3 nEw us3R Wi+H @ M4NGl3D IM493 WHICH TH3Y mUS+ C0py 4 number Fr0m 1Nt0 @ t3xT FieLD on +h3 r39istr4t1ON f0Rm. use +His 0Pt1oN +0 pr3veNt 4U+0M4t3D \$IGn-up Vi@ 5crip+s.";
$lang['forum_settings_help_45'] = "<b>t3X+-C4p+chA DIr3CtOry</b> \$P3CiPh1ES +3h l0c4T10N Th4+ bEEH1vE W1LL s+0re 1T's TExT-CApTChA IM49e\$ 4nD F0N+s iN. +h15 D1REC+0ry must B3 wR1+4blE BY +H3 WE8 seRV3R / pHp PR0cE\$S @nD MUs+ 8E @CCESsi8LE vi@ h++P. 4PhT3r j00 H@V3 3Na8leD +3x+-C@p+cH4 j00 must uplo@D S0m3 +ru3 +yp3 font\$ In+0 +EH phonTs suB-Dir3C+0rY 0f YOur m@1n +3x+-C4ptCh@ Dir3C+0Ry O+hErwis3 8E3H1V3 W1ll SkIP +3h TexT-C@ptch4 DuriNG u53R r39Is+R4Ti0n.";
$lang['forum_settings_help_46'] = "<b>Text Captcha key</b> allows you to change the key used by Beehive for generating the text captcha code that appears in the image. The more unique you make the key the harder it will be for automated processes to \"guess\"tEh C0d3.";
$lang['forum_settings_help_47'] = "<b>pO5t 3DI+ 9r@c3 p3rioD</b> 4ll0Ws J00 t0 deF1n3 4 peri0d iN minUT3\$ wHEr3 u53r\$ M@y 3di+ Po\$+S w1+H0ut tEH '3D1+3d 8Y' tEx+ aPpE4r1nG on th31R pOs+5. 1ph se+ +0 0 +HE 'Ed1+3D BY' TExt w1LL 4lw4YS 4PpE4R.";
$lang['forum_settings_help_48'] = "<b>unr3@d m3SS49Es cUt-0fPh</b> \$P3ciF1E5 how L0Ng MESs49Es rEM4in unRE4d. +HreaDS m0d1phi3D N0 l@+er Th4n TEh P3R1od sEL3C+3d wIlL 4U+0m4+iC@LlY app34r 4S r34D.";
$lang['forum_settings_help_49'] = "cHOo5iN9 <b>di\$4Ble UnREad m3s\$493S</b> WilL COMpL3+ElY reM0V3 unr3@D M3SS@ge\$ suPp0r+ @nD REmOvE +eh rEL3V4n+ 0p+1on\$ FRom +3h d1SCU\$S1on +ypE DroP d0wN 0n teh ThrE4d lIST.";
$lang['forum_settings_help_50'] = "<b>reQuiR3 U\$3r @PpR0VaL 8Y @DMIn</b> 4LL0w\$ j00 T0 r35+R1C+ aCCESs 8y n3W US3Rs Un+1L theY h@v3 8EEN @ppr0v3D 8y @ mODER4Tor 0R 4DM1N. W1+h0U+ @ppr0v@l 4 UsEr C@nn0t 4cCESs @ny @rEA oF Teh 833hiv3 Ph0rUm 1ns+4ll@+1oN IncLUD1N9 1nD1V1DU@L f0rum\$, pm 1n80x @nd my phorUmS \$3ct1ons.";
$lang['forum_settings_help_51'] = "u53 <b>cl0seD ME5S4g3</b>, <b>r3s+RicteD m3SS49E</b> 4nD <b>p4ssw0RD PRo+3c+ed m3SS@GE</b> T0 cUsT0MIs3 +H3 mesS493 d1splaY3d whEN US3Rs 4cC3ss youR PhOrum in +H3 V4ri0US \$+4TE5.";
$lang['forum_settings_help_52'] = "j00 C4N UsE hTml in yoUR mEss4G3S. hyPErlInks 4ND Em4IL 4dDrEss3\$ will @l\$0 B3 4UTomAT1CALLY CONverT3d +o l1nks. +0 U\$e teH DEF4ul+ b3eH1ve pHoRUM m3\$\$@gEs CLe4r +EH FiELD\$.";
$lang['forum_settings_help_53'] = "<b>aLL0w Us3RS +o CH4n93 UsErN@M3</b> P3rmi+s @LrE4DY REgistEr3D UsER\$ +0 ChAn9E +H31r u\$eRN4me. wH3N En@bleD J00 CaN +r@Ck +H3 CH4n9E\$ 4 u\$er mak3S To thEIr us3rn4m3 vI4 ThE @dmIn Us3R T0Ols.";
$lang['forum_settings_help_54'] = "uSE <b>f0rum rUl3s</b> +0 ENtER aN 4cC3p+4blE UsE pol1Cy +H4+ E4ch u\$3R mUsT 49r3e t0 BEF0rE RE91\$+erinG On Y0UR PhoRUm.";
$lang['forum_settings_help_55'] = "j00 C4N U\$e h+ml 1n y0Ur PhOrUM ruL3S. hYp3rLINK5 @ND 3M4il 4dDRE5ses wILl @lSo 8E @U+oM@T1C4lLy CONv3R+ED To lInKs. to u\$3 +hE D3f4UlT 8eeh1v3 PhorUM 4up Cl34R +hE Phi3Ld.";
$lang['forum_settings_help_56'] = "uSe <b>n0-REPLy EM4il</b> T0 sp3CIPHy 4N 3M41L ADDr3sS Th@+ DO3S n0t Ex1s+ Or wilL No+ b3 M0n1+0rED phor R3Pl1e\$. th1S 3M41l 4DDRE55 W1ll 8e us3D iN tHE hE4DErs f0r 4Ll em4ils sEn+ fr0m Y0Ur ForUM 1NCLUD1ng 8Ut n0t l1M1+ED To p05+ 4nd pm no+ipH1C4t10ns, u\$ER emailS @nd p4Ssw0rD r3minder5.";
$lang['forum_settings_help_57'] = "i+ I\$ r3ComMENDeD +haT J00 U53 4n em41l aDDR3sS tH@+ DO3S nO+ 3x1\$+ +0 helP CUT D0wn ON sp@M +h4T M4y 8e DIR3ct3D @+ YoUR m4in ph0RUM EM4il 4dDr3sS";

// Attachments (attachments.php, get_attachment.php) ---------------------------------------

$lang['aidnotspecified'] = "a1d n0T SpeC1fiED.";
$lang['upload'] = "uPL04D";
$lang['uploadnewattachment'] = "upl04D new @++4chmEnT";
$lang['waitdotdot'] = "w4i+..";
$lang['successfullyuploaded'] = "sUCc3SsfULLy uPl0@D3D: %s";
$lang['failedtoupload'] = "faIl3D +0 upL0@d: %s";
$lang['complete'] = "cOmpl3TE";
$lang['uploadattachment'] = "upL04d 4 pHiL3 F0R @tT4chment +0 tEH M3Ss49E";
$lang['enterfilenamestoupload'] = "en+Er F1LEn4m3(s) +0 UPl0ad";
$lang['attachmentsforthismessage'] = "a+T@ChMENts f0R th1\$ m3Ss493";
$lang['otherattachmentsincludingpm'] = "o+HEr at+@CHMEntS (inCLUDiNg pm m3sS4g3s 4ND 0TH3r f0RUM5)";
$lang['totalsize'] = "toT4l s1Z3";
$lang['freespace'] = "fr33 sp4cE";
$lang['attachmentproblem'] = "tHer3 wAs 4 PROBL3m Downl0@DiNG Thi\$ @++4chm3n+. PL3ASE TRy @G@1N l4tEr.";
$lang['attachmentshavebeendisabled'] = "aT+aChm3N+\$ h4v3 B3en DI\$4BL3D BY t3h ph0RUm own3r.";
$lang['canonlyuploadmaximum'] = "j00 c4n ONLy UpL0aD 4 MAx1mUM oph 10 ph1LES 4+ 4 t1m3";
$lang['deleteattachments'] = "dElete 4T+@CHM3N+s";
$lang['deleteattachmentsconfirm'] = "aRe j00 5UrE J00 wAnt t0 Del3TE +h3 s3lEC+3d @++4ChMentS?";
$lang['deletethumbnailsconfirm'] = "are j00 \$URE J00 w4N+ +0 dEl3te TEH \$3l3c+3D 4++@chm3N+s +hUmBN4il5?";

// Changing passwords (change_pw.php) ----------------------------------

$lang['passwdchanged'] = "p@s\$Word CH4NgED";
$lang['passedchangedexp'] = "yoUr p4\$SW0RD H4\$ 833N CH@Ng3d.";
$lang['updatefailed'] = "upd4Te f4Il3D";
$lang['passwdsdonotmatch'] = "p45\$w0rDs Do no+ m@+CH.";
$lang['newandoldpasswdarethesame'] = "n3W 4nD 0LD p4SSW0rdS AR3 +H3 s4m3.";
$lang['requiredinformationnotfound'] = "reQuir3d 1npHoRm4+10n n0+ phoUnD";
$lang['forgotpasswd'] = "f0R90+ passw0RD";
$lang['resetpassword'] = "r3\$3t p45\$W0rD";
$lang['resetpasswordto'] = "r3sEt p@\$sW0RD T0";
$lang['invaliduseraccount'] = "iNV4L1D usER 4CcOUn+ SPEC1fieD. CH3CK 3m41l phOr CorR3C+ L1nk";
$lang['invaliduserkeyprovided'] = "iNv4l1D user k3y ProviD3D. CHEck 3M41L pHoR cORrECT L1Nk";

// Deleting messages (delete.php) --------------------------------------

$lang['nomessagespecifiedfordel'] = "n0 M3SS@ge \$p3CIPHi3d f0r D3L3tioN";
$lang['deletemessage'] = "deLEtE mE\$S49E";
$lang['postdelsuccessfully'] = "p0st dElE+ED sUCC3sSFUlLY";
$lang['errordelpost'] = "erR0r DEleT1NG p0\$+";
$lang['cannotdeletepostsinthisfolder'] = "j00 C4Nn0+ D3lEtE p05+s in tH1S PhoLDER";

// Editing things (edit.php, edit_poll.php) -----------------------------------------

$lang['nomessagespecifiedforedit'] = "n0 MeSs49e 5P3ciph1ED For 3D1+iNg";
$lang['cannoteditpollsinlightmode'] = "c4nnot Ed1+ P0LLs 1N L19ht M0DE";
$lang['editedbyuser'] = "eD1+eD: %s BY %s";
$lang['editappliedtomessage'] = "eDi+ @PpliED t0 m3ssaG3";
$lang['errorupdatingpost'] = "eRRor upD4+ing pO\$+";
$lang['editmessage'] = "eD1+ mE\$S493 %s";
$lang['editpollwarning'] = "<b>n0+e</b>: eD1+INg Cer+@in 4sp3C+s 0PH 4 p0Ll will V01d 4LL teh CUrREnt v0tes 4nd 4lL0w pE0PLE t0 VO+E @g41n.";
$lang['hardedit'] = "h4rd EDIt 0Pt1ON\$ (vO+E\$ WIll 83 r3sET):";
$lang['softedit'] = "s0FT Edit 0Pt10N5 (v0+3s w1LL 8e r3T41NED):";
$lang['changewhenpollcloses'] = "ch@nGE WhEN teh p0ll Clo\$e\$?";
$lang['nochange'] = "no CH4N93";
$lang['emailresult'] = "eM@iL re\$uLt";
$lang['msgsent'] = "m3S\$49E \$en+";
$lang['msgsentsuccessfully'] = "mESs4g3 s3NT \$ucC3ssfuLly.";
$lang['mailsystemfailure'] = "m41l \$ystem F41luRE. mESsa93 not s3N+.";
$lang['nopermissiontoedit'] = "j00 @R3 no+ P3RmI++3d t0 eD1+ +hiS MEss49E.";
$lang['cannoteditpostsinthisfolder'] = "j00 C4nn0T 3Di+ p05+s In +hIs pholDER";
$lang['messagewasnotfound'] = "m3Ss4g3 %s W4s n0T phoUND";

// Email (email.php) ---------------------------------------------------

$lang['sendemailtouser'] = "s3ND 3m4IL to %s";
$lang['nouserspecifiedforemail'] = "n0 us3R \$P3cIf1ED F0R 3ma1l1N9.";
$lang['entersubjectformessage'] = "enter 4 SuBJECT f0r th3 M3ss493";
$lang['entercontentformessage'] = "en+Er Some CON+3nt foR +h3 mess4G3";
$lang['msgsentfromby'] = "tHis m3\$\$@GE w4S sEN+ phRoM %s bY %s";
$lang['subject'] = "sUBJ3C+";
$lang['send'] = "s3nd";
$lang['userhasoptedoutofemail'] = "%s h@\$ 0PtED out 0PH em41l C0Ntac+";
$lang['userhasinvalidemailaddress'] = "%s has 4N 1nv4LId 3ma1L 4dDRESs";

// Message nofificaiton ------------------------------------------------

$lang['msgnotification_subject'] = "m3SS493 noTiFiC4tI0n fR0M %s";
$lang['msgnotificationemail'] = "hEll0 %s,\n\n%s P0\$+ed @ m3SS49e +0 J00 on %s.\n\n+H3 suBjEc+ 1s: %s.\n\nT0 r34d tha+ M3Ss49E @nD 0+H3rs iN +3H 54m3 d1ScUs\$1on, 90 +o:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nNo+3: IPh j00 do nO+ w1sh +0 R3C31V3 3m41L no+1phiC4T10ns of Ph0rUm m3ss4g3s p0\$+ED +0 y0u, 90 +0: %s cl1ck oN my contR0ls +hen Ema1l 4ND pr1V@cy, un53l3C+ +eh 3m@il N0t1f1Ca+10n ch3CKb0X @Nd pRESs \$UBmiT.";

// Thread Subscription notification ------------------------------------

$lang['subnotification_subject'] = "sUBscrIpT10N N0+IPhIcaT10n fr0M %s";
$lang['subnotification'] = "heLL0 %s,\n\n%s p05+3D 4 m35\$A93 iN @ +HR34d J00 havE \$ubsCR18eD +0 0n %s.\n\nth3 \$ubjECT 1\$: %s.\n\n+0 R34d tH4+ M3ss49E @nD oTh3r\$ in tEh s4M3 DI\$cUs\$I0n, g0 t0:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nn0te: if j00 d0 not wi\$H t0 Rec31vE 3m4il no+1PHIc@+I0N\$ 0f n3W mess4G3s 1N This +Hr34d, go tO: %s @ND @dJust Y0ur 1N+3REst l3Vel @t tEh 80Ttom of th3 P@93.";

// PM notification -----------------------------------------------------

$lang['pmnotification_subject'] = "pM n0TipHiC4tioN from %s";
$lang['pmnotification'] = "h3Llo %s,\n\n%s postED 4 pm t0 j00 0n %s.\n\n+H3 sU8JeC+ 1s: %s.\n\n+O r34D THe me\$s@ge 90 +o:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nNO+E: 1PH J00 Do N0+ wI\$h TO reC31v3 3MA1l n0T1f1C@t1ON5 Oph N3W PM MEsS@gEs pOst3D t0 Y0U, 90 To: %s CLiCk my con+rOL\$ +H3n ema1L 4ND prIV4Cy, UN\$EL3c+ +He pm no+iFiC4t10n chECk8ox anD pr3ss subM1t.";

// Password change notification ----------------------------------------

$lang['passwdchangenotification'] = "p4\$sw0rD Ch@n9e n0+IPHiC4+i0N phRoM %s";
$lang['pwchangeemail'] = "hEllo %s,\n\n+h1\$ 4 n0T1f1c4TiOn Em41l t0 iNForm j00 +H4T Y0ur P4S\$w0RD 0N %s H@\$ 8EEn CH4n9ED.\n\n1+ H4s 8EEN Ch4n9ED +o: %s @nD W4S CHAnG3d 8y: %s.\n\nIF j00 h@VE rECEIVED +HIs 3M@IL IN ErR0R 0r wEr3 n0T ExP3C+INg 4 Ch4nge +0 your p@\$\$worD pLE453 C0NT4ct the Ph0Rum oWn3r or 4 M0D3R4+or 0N %s 1mmedi4+Ely t0 c0Rr3C+ It.";

// Email confirmation notification -------------------------------------

$lang['emailconfirmationrequired'] = "em@il c0nfirm@+1on r3QUir3d PH0r %s";
$lang['confirmemail'] = "hELL0 %s,\n\nyou reCENTlY CR3@+3D 4 nEW U53R @CCOunT 0N %s.\nb3FOr3 j00 c4n staR+ P0\$t1N9 wE N3ED To C0nphirM yoUR em41l @DdR3ss. doN't w0rry +hIs i\$ Qu1+3 3@\$Y. @Ll j00 N33d to D0 1s Cl1cK +h3 l1nK 8el0W (0r c0PY 4ND p4\$+3 1T 1nt0 y0ur 8R0W\$eR):\n\n%s\n\n0nCe conphirM@t1On i\$ ComplETe j00 may l091n @nD \$+4rt P0\$+1n9 1mmEDIa+Ely.\n\n1f j00 d1d no+ Cr3a+E 4 Us3R @cC0UNt 0N %s Pl34\$e @CCept 0Ur 4POl0giEs @nd phoRw4rd +h1s Em4il to %s so thAT th3 s0UrCE oph 1t m4y BE 1nvEsti94+eD.";
$lang['confirmchangedemail'] = "h3llo %s,\n\nYOu R3CenTlY CH@Ng3D YoUR em4il on %s.\n83f0re j00 C4N 5+4R+ po5+INg @g@1n w3 N3ed To CONfirm y0ur nEw eM41l @DDr3SS. DoN'T w0RRY +H1s I\$ QUi+E 3ASy. 4LL j00 neED +o D0 i\$ cliCK tHE L1Nk B3l0w (or CoPy 4nD P@s+3 1t iN+0 y0UR 8R0w\$er):\n\n%s\n\n0nc3 Conf1rm@+ioN 1\$ C0mPLEte j00 m4y c0N+inu3 To us3 teh f0rum @s N0rm4l.\n\n1Ph j00 were n0t exPECTinG this eM4il pHROm %s ple@\$e @cc3P+ 0UR @polO913S 4nD phorW@RD th1s Em4il +o %s s0 th@+ +eh s0urc3 0ph 1+ m4y 83 inv3sT1g4+ed.";


// Forgotten password notification -------------------------------------

$lang['forgotpwemail'] = "heLl0 %s,\n\nyoU R3qU3stED +H1\$ 3-m@Il phrom %s 8EC4us3 j00 h4v3 Ph0rg0++En yOUr passwOrD.\n\nCl1ck tEH l1NK 8el0W (0R COPy 4ND P4ste i+ iNt0 yoUr BR0w\$3r) t0 rEsE+ y0ur p4\$SW0rd:\n\n%s";

// Forgotten password form.

$lang['passwdresetrequest'] = "y0UR PassW0rd R353+ R3qu3St FrOm %s";
$lang['passwdresetemailsent'] = "p4\$SW0rd r3SET E-M@iL sent";
$lang['passwdresetexp'] = "j00 \$H0uld sH0RTlY RECEIve @N E-M41l C0nt4INiNg in\$trUc+1on\$ F0r r3SETT1NG YoUr p4\$sw0rD.";
$lang['validusernamerequired'] = "a v4L1d usERn4m3 15 ReQUiR3D";
$lang['forgottenpasswd'] = "f0rg0T p4\$Sw0rd";
$lang['couldnotsendpasswordreminder'] = "c0ULD not s3nD PAssw0rD rEm1ND3r. Pl34s3 C0n+@CT +hE f0ruM owneR.";
$lang['request'] = "r3queSt";

// Email confirmation (confirm_email.php) ------------------------------

$lang['emailconfirmation'] = "eM4il ConFirm@+1On";
$lang['emailconfirmationcomplete'] = "tH4nk j00 f0R cOnPhIrM1NG y0ur 3M41l 4DDrES\$. J00 m@Y Now l09iN anD st4RT p05+iNg iMm3d14teLY.";
$lang['emailconfirmationfailed'] = "eM@1L CONpHirm4+10N H4s F4Il3d, PlEase +rY 494IN LatEr. 1F j00 enC0unTER thi\$ 3rRor MUlt1PLE +1M3s plE453 con+4C+ +HE PhOrum oWN3r 0R 4 m0DER@+Or f0r @\$Sis+4NCE.";

// Links database (links*.php) -----------------------------------------

$lang['toplevel'] = "t0p lEv3l";
$lang['maynotaccessthissection'] = "j00 m4y n0+ @CC3\$S +h15 53C+1On.";
$lang['toplevel'] = "tOP l3v3L";
$lang['links'] = "lInks";
$lang['viewmode'] = "vIew m0d3";
$lang['hierarchical'] = "h13r4RCH1C@L";
$lang['list'] = "l1St";
$lang['folderhidden'] = "tHIS F0LDEr 1s HIdD3n";
$lang['hide'] = "h1d3";
$lang['unhide'] = "unh1dE";
$lang['nosubfolders'] = "no \$uBph0LD3rs in +hIs C4+39orY";
$lang['1subfolder'] = "1 SU8pholDEr 1n +hIs C4+egoRy";
$lang['subfoldersinthiscategory'] = "su8f0LD3r\$ IN +Hi5 C4+390ry";
$lang['linksdelexp'] = "enTr1Es In 4 Del3TeD phoLDER wIll 8e M0V3d +0 +Eh p@r3nt f0LDEr. 0NLY Ph0LDER\$ wh1ch DO No+ c0n+@1N \$u8pH0LDER5 m4Y BE Del3TEd.";
$lang['listview'] = "li\$+ vi3W";
$lang['listviewcannotaddfolders'] = "c@NN0+ 4dD pholDER\$ in +h1\$ V1ew. shOwInG 20 EnTr13s 4+ a +1m3.";
$lang['rating'] = "r@+1N9";
$lang['nolinksinfolder'] = "n0 lInK5 in +HIs Ph0ldeR.";
$lang['addlinkhere'] = "aDD liNk hER3";
$lang['notvalidURI'] = "th@t I\$ n0t @ v@Lid UR1!";
$lang['mustspecifyname'] = "j00 musT sp3CIFY a N@m3!";
$lang['mustspecifyvalidfolder'] = "j00 musT sp3ciphy 4 v@liD F0LDER!";
$lang['mustspecifyfolder'] = "j00 MUst sp3CIFy A F0LDER!";
$lang['successfullyaddedlinkname'] = "sUcc3SSFuLLy ADD3D l1nK '%s'";
$lang['failedtoaddlink'] = "f4Il3d +0 4dd l1NK";
$lang['failedtoaddfolder'] = "f4IL3D +0 ADD PhOlDER";
$lang['addlink'] = "add 4 L1nk";
$lang['addinglinkin'] = "aDdinG LInK in";
$lang['addressurluri'] = "addr3\$S";
$lang['addnewfolder'] = "aDd 4 N3w phoLDER";
$lang['addnewfolderunder'] = "aDding n3W pH0LDER UND3r";
$lang['editfolder'] = "eDi+ pHoLDeR";
$lang['editingfolder'] = "eD1+INg PH0LD3r";
$lang['mustchooserating'] = "j00 mUsT cHo0se 4 r4tinG!";
$lang['commentadded'] = "yOur COmmeN+ w4S 4DDED.";
$lang['commentdeleted'] = "c0mMent w45 D3leTED.";
$lang['commentcouldnotbedeleted'] = "c0mm3nT cOuLD no+ 8E D3L3t3D.";
$lang['musttypecomment'] = "j00 Mus+ +YP3 a C0mMen+!";
$lang['mustprovidelinkID'] = "j00 mU\$t PROv1d3 a lINk 1d!";
$lang['invalidlinkID'] = "inV4L1D l1Nk 1D!";
$lang['address'] = "adDREss";
$lang['submittedby'] = "subm1+tED 8y";
$lang['clicks'] = "cl1cks";
$lang['rating'] = "r4+ING";
$lang['vote'] = "v0+e";
$lang['votes'] = "v0TeS";
$lang['notratedyet'] = "noT R@+ED 8Y @nYon3 Y3+";
$lang['rate'] = "r@t3";
$lang['bad'] = "bAD";
$lang['good'] = "g0Od";
$lang['voteexcmark'] = "v0+e!";
$lang['clearvote'] = "cl3@r v0te";
$lang['commentby'] = "c0Mm3nt 8Y %s";
$lang['addacommentabout'] = "aDd @ COmmEn+ 48oUt";
$lang['modtools'] = "mOder4+10N +o0lS";
$lang['editname'] = "ed1t n4m3";
$lang['editaddress'] = "eDit @dDr35\$";
$lang['editdescription'] = "edIT DEsCR1PTIon";
$lang['moveto'] = "moV3 +0";
$lang['linkdetails'] = "l1nk DETa1lS";
$lang['addcomment'] = "add coMmEN+";
$lang['voterecorded'] = "y0Ur v0+E h4\$ 8EEn rECORdED";
$lang['votecleared'] = "yoUR Vo+3 H45 bEEN CLE4rEd";
$lang['linknametoolong'] = "liNk N@M3 tOo long. m4ximUM 1S %s Ch4rAc+3R\$";
$lang['linkurltoolong'] = "link urL Too l0N9. m4x1mUm 1\$ %s CH4r4cter\$";
$lang['linkfoldernametoolong'] = "fold3r n4M3 too lon9. M@ximUm LEN9+h 1\$ %s ch4R4ctER5";

// Login / logout (llogon.php, logon.php, logout.php) -----------------------------------------

$lang['loggedinsuccessfully'] = "j00 L0GgED iN \$UCcessfullY.";
$lang['presscontinuetoresend'] = "pR3ss coN+iNU3 t0 rEsENd f0rm D4+a 0r C4Nc3l tO r3Lo@D p4g3.";
$lang['usernameorpasswdnotvalid'] = "thE U5ErN@mE Or p4SSWoRD j00 suPPlI3D iS nO+ v4l1D.";
$lang['rememberpasswds'] = "reMEmbeR P@ssW0RDs";
$lang['rememberpassword'] = "r3MEM83r P45\$W0rD";
$lang['enterasa'] = "enT3R @s a %s";
$lang['donthaveanaccount'] = "doN'+ h4Ve 4N 4ccoun+? %s";
$lang['registernow'] = "r39isTEr nOw.";
$lang['problemsloggingon'] = "prOBLem5 LOg9INg on?";
$lang['deletecookies'] = "d3LETE cookI3s";
$lang['cookiessuccessfullydeleted'] = "c00k13s sUCcEssFUllY D3leteD";
$lang['forgottenpasswd'] = "f0rG0t+en your p@s\$WorD?";
$lang['usingaPDA'] = "u5ING 4 pd4?";
$lang['lightHTMLversion'] = "l19ht h+Ml ver\$ion";
$lang['youhaveloggedout'] = "j00 havE l0993D 0U+.";
$lang['currentlyloggedinas'] = "j00 @RE cUrREn+lY l0g93d in A5 %s";
$lang['logonbutton'] = "lO9on";
$lang['otherbutton'] = "otHER";
$lang['yoursessionhasexpired'] = "your 53ss1oN h4s 3xP1R3D. J00 wIlL NEED t0 l091n 4G4in +o C0n+inuE.";

// My Forums (forums.php) ---------------------------------------------------------

$lang['myforums'] = "my PH0rum\$";
$lang['allavailableforums'] = "aLl @V4Il4blE f0RUMs";
$lang['favouriteforums'] = "f4V0uritE Ph0rum\$";
$lang['ignoredforums'] = "iGn0RED f0ruMs";
$lang['ignoreforum'] = "i9N0RE foRUm";
$lang['unignoreforum'] = "unIGn0RE F0RUM";
$lang['lastvisited'] = "l@\$T V1\$I+ED";
$lang['forumunreadmessages'] = "%s unread m3Ssa93s";
$lang['forummessages'] = "%s mes\$@Ge5";
$lang['forumunreadtome'] = "%s UNRe@D &quot;To: m3&quot;";
$lang['forumnounreadmessages'] = "n0 uNR3ad MEss49es";
$lang['removefromfavourites'] = "r3m0V3 FroM Ph4VoUR1+3S";
$lang['addtofavourites'] = "aDD +o PH@v0uri+3S";
$lang['availableforums'] = "avaILABle pH0RUm\$";
$lang['noforumsofselectedtype'] = "tHer3 aR3 NO pHorUM\$ 0F The \$eL3CT3d +ypE @V@Il@Ble. pLE4SE sEl3Ct 4 d1FF3renT +Yp3.";
$lang['successfullyaddedforumtofavourites'] = "sUCC3s\$phully 4DD3D PhorUM T0 pH@VoUr1+3S.";
$lang['successfullyremovedforumfromfavourites'] = "sucC3\$sfullY R3MoVED F0RUm pHRom pH@VoURites.";
$lang['successfullyignoredforum'] = "sucCE\$SFULlY 1gn0RED f0rum.";
$lang['successfullyunignoredforum'] = "sucC3s\$fully Un1Gn0reD ph0rum.";
$lang['failedtoupdateforuminterestlevel'] = "f@1LEd +0 upd4+3 Ph0ruM iNteRE\$T LEv3l";
$lang['noforumsavailablelogin'] = "therE 4RE nO PhoRums 4V4il@8le. PL34s3 lo9in t0 v13w Y0uR PHOrUm\$.";
$lang['passwdprotectedforum'] = "p@SSwOrD Pro+3c+3d F0RUm";
$lang['passwdprotectedwarning'] = "tH1\$ F0rum I\$ passw0RD PrOtEC+3D. To 941n @cC3ss 3nt3r +h3 P4sswoRD 8el0w.";

// Message composition (post.php, lpost.php) --------------------------------------

$lang['postmessage'] = "post mEss493";
$lang['selectfolder'] = "s3L3C+ pholDEr";
$lang['mustenterpostcontent'] = "j00 MusT ENTEr \$0m3 C0n+3NT foR +h3 p0ST!";
$lang['messagepreview'] = "mE\$\$49e preV13w";
$lang['invalidusername'] = "inV4l1D uSErN4mE!";
$lang['mustenterthreadtitle'] = "j00 must eNtER a t1tl3 pHor tH3 ThRE4D!";
$lang['pleaseselectfolder'] = "ple4se sel3CT a f0lDER!";
$lang['errorcreatingpost'] = "erR0r cr3AT1n9 pO\$+! pL3ASe +Ry a94in In @ ph3w MInu+3S.";
$lang['createnewthread'] = "cRe4+3 nEw +hR3AD";
$lang['postreply'] = "p0St r3ply";
$lang['threadtitle'] = "tHre4D +1+le";
$lang['messagehasbeendeleted'] = "m3s\$4ge NO+ fOuND. CHeCK +H4T 1+ H@\$n'+ 8e3N DElE+Ed.";
$lang['messagenotfoundinselectedfolder'] = "mESS49e n0t f0UND 1n 53LEc+3d F0LD3R. Ch3ck th@+ i+ H@\$n'+ B3eN mOveD or D3leteD.";
$lang['cannotpostthisthreadtypeinfolder'] = "j00 c@Nn0T pOst th1\$ +Hr3ad +YpE 1n that PhoLDer!";
$lang['cannotpostthisthreadtype'] = "j00 Cann0+ p0s+ +His +HR34D typ3 4\$ +hER3 4r3 No aV41l@BLE FoldErs +h4t 4LLow i+.";
$lang['cannotcreatenewthreads'] = "j00 Canno+ CRE4te nEw +hR34d\$.";
$lang['threadisclosedforposting'] = "thi5 thREAD I\$ CL0seD, J00 CAnn0+ p0s+ 1N i+!";
$lang['moderatorthreadclosed'] = "w@RN1N9: th15 Thr34D 1\$ clOsED PHor p0S+1n9 tO normAl uSEr5.";
$lang['usersinthread'] = "u53r\$ IN +Hr34d";
$lang['correctedcode'] = "coRR3c+eD C0d3";
$lang['submittedcode'] = "sUBm1+teD c0DE";
$lang['htmlinmessage'] = "html 1N mEs\$49E";
$lang['disableemoticonsinmessage'] = "di\$4blE 3MoT1COn\$ IN m3ss493";
$lang['automaticallyparseurls'] = "au+OM4+iC4lly p@RSE UrLs";
$lang['automaticallycheckspelling'] = "au+om4t1CALLy CHECK spELl1ng";
$lang['setthreadtohighinterest'] = "sEt thrE4d +O h19H intEr3ST";
$lang['enabledwithautolinebreaks'] = "eN@8L3D Wi+H 4uT0-L1ne-8rE4k\$";
$lang['fixhtmlexplanation'] = "tH1s pH0RUM Us3S h+ml Ph1l+3R1Ng. y0ur \$UBMI++3d h+ml h@\$ B3EN m0d1Ph1eD 8Y Th3 fiL+3r\$ in som3 w4y.\\n\\nT0 v1Ew y0ur 0RIGin4l COD3, sel3ct +H3 \\'\$uBm1t+ED c0dE\\' R@D10 BUTtOn.\\n+0 v13W the M0D1phi3D CODE, sEl3ct +hE \\'C0rr3C+3d CODE\\' r4DiO 8u++0N.";
$lang['messageoptions'] = "me\$S493 opt10ns";
$lang['notallowedembedattachmentpost'] = "j00 @re nO+ @lLow3d +0 3m8ED 4tT4chMEN+s iN y0ur P0sT\$.";
$lang['notallowedembedattachmentsignature'] = "j00 4R3 n0T 4LL0w3D +o 3M8ED 4tT4Chm3NT\$ 1n yoUr \$19N4TURE.";
$lang['reducemessagelength'] = "m3\$s4G3 l3N9TH MUST bE UNDER 65,535 Ch4r@c+3Rs (CURrENTly: %s)";
$lang['reducesiglength'] = "s1Gn4+UrE l3n9TH Mu5+ 83 UNd3r 65,535 chAr@CT3R\$ (cuRr3N+lY: %s)";
$lang['cannotcreatethreadinfolder'] = "j00 C4nNOt cReAt3 nEW +hRE4DS 1N +HiS pHolDEr";
$lang['cannotcreatepostinfolder'] = "j00 c4NNo+ rEPly +O p0STs in tH1\$ f0LDER";
$lang['cannotattachfilesinfolder'] = "j00 C4NnoT POS+ @+tACHMENtS in +hi\$ f0LDeR. R3Mov3 4T+@CHM3NTs +0 CoN+1nuE.";
$lang['postfrequencytoogreat'] = "j00 C4N 0nlY Po5+ 0NC3 evErY %s seC0nD\$. Pl34sE +ry 494in la+ER.";
$lang['emailconfirmationrequiredbeforepost'] = "eMA1l Conphirm4TioN i\$ rEQUIrED 8ef0re j00 C4n POST. iph j00 hAvE N0+ r3C31V3d 4 COnphirm4+10N 3M4IL pLEase CL1CK +h3 8uTton 83low @nD a n3W 0N3 wiLL 8e sent +0 y0U. IpH Y0ur em4iL 4dDrEss n3eDs CH4NGiNg Pl34se Do sO 8ephoRE rEQUEs+1N9 4 NEw Conphirm4+10n em4il. j00 M4Y Ch4nge youR 3m41L @Ddr35\$ BY cl1CK my C0N+r0LS @8oV3 And +hen u53r dE+a1L\$";
$lang['emailconfirmationfailedtosend'] = "c0NPHirm4+10N 3M@il pHa1l3D t0 senD. Pl34\$3 COn+@Ct +h3 fOrum 0WNeR To rECT1PhY tHi\$.";
$lang['emailconfirmationsent'] = "conf1rM@+I0n 3M4il h4\$ B33n rE\$en+.";
$lang['resendconfirmation'] = "r3\$end cONpHirMAt10N";
$lang['userapprovalrequiredbeforeaccess'] = "y0ur u\$er @CcouNt nEEDS +0 83 4ppr0VED 8Y @ Ph0rUm @DMin 8eF0RE j00 c4n aCCESS +EH r3qu35+3d phorUm.";

// Message display (messages.php & messages.inc.php) --------------------------------------

$lang['inreplyto'] = "iN REPly tO";
$lang['showmessages'] = "sH0W mEss4g3s";
$lang['ratemyinterest'] = "r4+3 MY in+3REst";
$lang['adjtextsize'] = "aDjust +ex+ 5IZe";
$lang['smaller'] = "sMall3R";
$lang['larger'] = "l4r93r";
$lang['faq'] = "faq";
$lang['docs'] = "d0c\$";
$lang['support'] = "sUppor+";
$lang['donateexcmark'] = "d0n4+3!";
$lang['fontsizechanged'] = "f0N+ s1Z3 ch4NGED. %s";
$lang['framesmustbereloaded'] = "fr4m3s mu\$+ 83 r3Lo4D3d m4Nu4lLY To 53e ChANGEs.";
$lang['threadcouldnotbefound'] = "th3 rEqU3stED +hR34d COUlD No+ BE F0und oR 4Cc3ss w4\$ D3n13D.";
$lang['mustselectpolloption'] = "j00 mUs+ \$EL3ct 4N opt10N t0 VO+E For!";
$lang['mustvoteforallgroups'] = "j00 Mu\$T v0+3 in EvERy gROup.";
$lang['keepreading'] = "k3ep rE4DinG";
$lang['backtothreadlist'] = "b4ck +0 ThrE4d lI\$t";
$lang['postdoesnotexist'] = "th4+ p0s+ D0es N0t 3x1\$+ IN +hIs +hrE4d!";
$lang['clicktochangevote'] = "clicK +o ch4n93 v0TE";
$lang['youvotedforoption'] = "j00 vO+eD pHOr 0PTIOn";
$lang['youvotedforoptions'] = "j00 V0+3D F0R 0pt10n5";
$lang['clicktovote'] = "cLIcK tO V0+3";
$lang['youhavenotvoted'] = "j00 h@V3 no+ v0teD";
$lang['viewresults'] = "vIEW reSuLtS";
$lang['msgtruncated'] = "mE\$S4g3 trunC4t3D";
$lang['viewfullmsg'] = "viEW FUll m3ssag3";
$lang['ignoredmsg'] = "ign0REd M3SS49E";
$lang['wormeduser'] = "w0rmeD Us3R";
$lang['ignoredsig'] = "igN0RED 51gN@+urE";
$lang['messagewasdeleted'] = "m3SSA93 %s.%s w45 D3LE+ED";
$lang['stopignoringthisuser'] = "sT0p 19n0R1NG TH1s UsEr";
$lang['renamethread'] = "r3n4M3 +Hr34D";
$lang['movethread'] = "mOv3 tHrE4d";
$lang['torenamethisthreadyoumusteditthepoll'] = "t0 r3n4M3 +Hi5 THr3aD J00 mU5+ 3DI+ +he PoLL.";
$lang['closeforposting'] = "clos3 pH0r Po\$+ING";
$lang['until'] = "uN+1L 00:00 u+c";
$lang['approvalrequired'] = "apPrOvaL rEqUir3d";
$lang['messageawaitingapprovalbymoderator'] = "mEsS493 %s.%s i\$ 4wa1+Ing @Ppr0val by 4 m0dER4Tor";
$lang['postapprovedsuccessfully'] = "po5+ 4PPRov3D 5ucce5sFUlLy";
$lang['postapprovalfailed'] = "p05+ 4pprOv@l F4Il3d.";
$lang['postdoesnotrequireapproval'] = "pOs+ dO3s n0T R3QUir3 4PProv@l";
$lang['approvepost'] = "aPpRove pOs+ phor DIspl4y";
$lang['approvedbyuser'] = "apPr0vED: %s BY %s";
$lang['makesticky'] = "m4K3 s+1CKy";
$lang['messagecountdisplay'] = "%s 0f %s";
$lang['linktothread'] = "p3RM4n3nt l1Nk to thiS THrE4d";
$lang['linktopost'] = "liNK +O po\$+";
$lang['linktothispost'] = "l1Nk T0 +hIs Post";
$lang['imageresized'] = "tHis IM4ge H4S 8een rE\$iZ3D (ori9in4L siZ3 %1\$5X%2\$s). tO v13W tHe PHUlL-siZe 1m@GE CLIck HER3.";
$lang['messagedeletedbyuser'] = "m3Ss49E %s.%s deL3TED %s BY %s";
$lang['messagedeleted'] = "meSs4g3 %s.%s W@\$ del3teD";

// Moderators list (mods_list.php) -------------------------------------

$lang['cantdisplaymods'] = "c@Nn0t D1\$PL4y f0LDER mOdEr4tors";
$lang['moderatorlist'] = "m0DEr@t0R list:";
$lang['modsforfolder'] = "m0der4toRs F0R F0lDEr";
$lang['nomodsfound'] = "n0 moDER@+0Rs F0UND";
$lang['forumleaders'] = "fORUM lEAdeR\$:";
$lang['foldermods'] = "fOLD3r m0DER@T0rs:";

// Navigation strip (nav.php) ------------------------------------------

$lang['start'] = "s+4rt";
$lang['messages'] = "mE\$s4G3S";
$lang['pminbox'] = "inBoX";
$lang['startwiththreadlist'] = "s+@R+ p4G3 w1+h +hr34D l1\$+";
$lang['pmsentitems'] = "s3NT 1+EMs";
$lang['pmoutbox'] = "oUt80x";
$lang['pmsaveditems'] = "s@V3D i+3M\$";
$lang['pmdrafts'] = "dR@ft\$";
$lang['links'] = "lINk\$";
$lang['admin'] = "aDm1n";
$lang['login'] = "l0G1n";
$lang['logout'] = "l090ut";

// PM System (pm.php, pm_write.php, pm.inc.php) ------------------------

$lang['privatemessages'] = "priv@+e m3ss4GE\$";
$lang['recipienttiptext'] = "seP@r@tE RECIP13nt\$ by s3m1-COlon or C0mm@";
$lang['maximumtenrecipientspermessage'] = "th3Re 1S @ l1M1+ oph 10 r3CIP13nt\$ PER m3SS4g3. pL34se @m3nd yOur r3c1P1en+ lIst.";
$lang['mustspecifyrecipient'] = "j00 mus+ 5P3Cify 4+ l34\$+ ONe rECIPi3nt.";
$lang['usernotfound'] = "uSer %s NOT pHoUND";
$lang['sendnewpm'] = "sEnD N3W Pm";
$lang['savemessage'] = "s@V3 MEss49E";
$lang['timesent'] = "t1M3 s3N+";
$lang['errorcreatingpm'] = "err0R cr3@+inG pM! pl3ASe +rY 4G41N In a fEW M1NU+3s";
$lang['writepm'] = "wr1tE Mess493";
$lang['editpm'] = "ed1T MEss49E";
$lang['cannoteditpm'] = "cANNot 3DI+ +H1S pm. IT H@s @lrE4Dy 8eEn ViEW3D 8y +hE r3CIp13nt oR +eH M3S\$49E Do3S N0t Ex1S+ 0R 1+ is In4Cce\$SI8LE 8Y J00";
$lang['cannotviewpm'] = "caNNo+ vi3W pm. ME5S4G3 d03S N0T 3XIs+ 0R I+ is iN4CcESS1blE by j00";
$lang['pmmessagenumber'] = "m3sS4g3 %s";

$lang['youhavexnewpm'] = "j00 H4vE %d n3W m3SS49Es. W0ulD j00 LiKe T0 gO to Y0uR 1n8Ox NOw?";
$lang['youhave1newpm'] = "j00 h4V3 1 New mEsS@g3. w0ulD j00 L1k3 +o G0 T0 y0Ur InbOX Now?";
$lang['youhave1newpmand1waiting'] = "j00 h@Ve 1 n3W ME\$54g3.\n\nYoU 4l\$0 H@v3 1 mess@g3 aW4i+inG d3liv3ry. t0 r3CEIvE tHis Mess@gE pl3@5E cl34R \$0me sPaC3 1n y0Ur 1NB0X.\n\nWOuld J00 lIkE +o G0 +0 y0UR iN80x n0W?";
$lang['youhave1pmwaiting'] = "j00 H4v3 1 m3ss4g3 4wa1TINg DEL1very. +0 r3c3ivE +Hi\$ m3ss49e pl3as3 CL34R s0m3 \$p4C3 1n y0Ur iN8OX.\n\nWoULD j00 LIk3 +O 90 +o y0UR 1N80x now?";
$lang['youhavexnewpmand1waiting'] = "j00 h@V3 %d n3w ME\$s49Es.\n\nY0u @lso h4ve 1 MESs4g3 @w4i+ING D3livERy. +o rEC31v3 +h1\$ m3SSAg3 Pl3AsE CL3Ar \$0m3 \$p4C3 1N Y0ur inBOx.\n\nWOUlD J00 L1K3 +0 g0 to YOUR 1n80x n0w?";
$lang['youhavexnewpmandxwaiting'] = "j00 h4v3 %d nEW mEss4g3s.\n\nyoU 4ls0 HAVE %d M3SSaG3S 4W@i+1n9 D3l1V3Ry. +0 rEce1V3 +h3S3 mEss49E plE4\$E Cl3Ar s0m3 spaC3 in y0UR iNBOx.\n\nwoUlD J00 l1kE +0 90 +o yOUr in80X N0W?";
$lang['youhave1newpmandxwaiting'] = "j00 h@VE 1 n3W M3SS4g3.\n\nYOU @lSo hAVe %d MEss493s 4w@1T1n9 D3livERy. To r3c3ive tH3\$3 m3SSA93S PleaS3 CLE4r \$0M3 \$paC3 1N Y0UR 1N8ox.\n\nW0uld j00 L1k3 +0 90 tO yoUr In80x n0w?";
$lang['youhavexpmwaiting'] = "j00 h@v3 %d m3SS49Es 4w41t1NG d3liV3Ry. +0 r3c31v3 +H3SE ME\$S@GE\$ plE4\$3 CLE4R \$0m3 SPAC3 iN YoUr in80X.\n\nwoULD j00 L1ke tO 90 +o y0UR 1n8ox nOw?";

$lang['youdonothaveenoughfreespace'] = "j00 D0 no+ h@V3 eN0UGh Fre3 SP4c3 +O sEND THI\$ M3ss4g3.";
$lang['userhasoptedoutofpm'] = "%s h@S 0PTED 0u+ 0Ph rECe1ving p3r\$0n4l mess4G3S";
$lang['pmfolderpruningisenabled'] = "pm ph0LDER PRUnINg i\$ 3Na8leD!";
$lang['pmpruneexplanation'] = "thIS f0rUm U\$3s Pm pHolDER pRUNiNg. THE m35\$49E\$ j00 h4v3 \$+0rED 1n y0ur inB0X AnD \$eN+ 1t3mS\\nPHOlDERS aR3 sUBJ3ct +o 4UtOm4+Ic Del3T1on. any m3ss49Es J00 w15h TO kEEP \$h0uLD BE MoV3D +O\\nYoUr \\'\$4VED 1+emS\\' pholDER 50 +h4t +h3y 4r3 N0T D3letED.";
$lang['yourpmfoldersare'] = "yOur pm pholDErs Ar3 %s phulL";
$lang['currentmessage'] = "cUrren+ mE\$S4g3";
$lang['unreadmessage'] = "uNrEad m3SSa93";
$lang['readmessage'] = "re4D mE5s493";
$lang['pmshavebeendisabled'] = "p3RsoN4L MEss49e5 h4V3 8e3N d1s4BLeD BY +H3 pHorUM own3R.";
$lang['adduserstofriendslist'] = "aDd u\$eRS to Y0UR FRi3nDs Li\$+ +o h4v3 +hem 4PP3ar 1N @ DR0P D0wn 0n th3 pM wr1+3 mEss@Ge Pa93.";

$lang['messagesaved'] = "m3Ss493 s4V3d";
$lang['messagewassuccessfullysavedtodraftsfolder'] = "m35s4g3 was \$ucC35\$PHully s4V3d t0 'Dr@ph+S' f0LD3r";
$lang['couldnotsavemessage'] = "coulD No+ \$4v3 mess4G3. m4K3 \$UR3 J00 h4VE 3NOu9h 4V@il@Ble FrEE \$p4C3.";
$lang['pmtooltipxmessages'] = "%s mess4G3S";
$lang['pmtooltip1message'] = "1 M3\$S@ge";

$lang['allowusertosendpm'] = "allow U\$ER To sEND P3R\$0n@l mEss4G3s +0 mE";
$lang['blockuserfromsendingpm'] = "bL0ck U\$3r pHrOm sendING p3R\$0n4L m3Ss@gEs +0 mE";
$lang['yourfoldernamefolderisempty'] = "your %s folDEr i5 3mpty";
$lang['successfullydeletedselectedmessages'] = "sucCe\$SFUlly DEL3TeD 53lEC+3D M3S\$49es";
$lang['successfullyarchivedselectedmessages'] = "succ3SsfULlY 4rCh1v3d \$el3C+3D M3Ss4g3s";
$lang['failedtodeleteselectedmessages'] = "f41LEd tO DEL3T3 \$EL3c+3d M3ss4g3s";
$lang['failedtoarchiveselectedmessages'] = "f41leD +O arCh1ve \$3lEC+3d m3Ssa93S";

// Preferences / Profile (user_*.php) ---------------------------------------------

$lang['mycontrols'] = "mY Con+rOlS";
$lang['myforums'] = "mY PH0RuMs";
$lang['menu'] = "meNU";
$lang['userexp_1'] = "u\$3 tHe menU on tHe l3PHT tO m4n@gE youR s3+tingS.";
$lang['userexp_2'] = "<b>uSeR D3ta1l\$</b> 4ll0W\$ J00 t0 CH4N9E y0ur nAm3, 3MAIL adDR3Ss @nD PAssw0rd.";
$lang['userexp_3'] = "<b>uS3R profiL3</b> @LL0W\$ j00 to 3DI+ YoUr usEr pr0phil3.";
$lang['userexp_4'] = "<b>cHan93 p45\$w0RD</b> 4llow\$ j00 +o CH4N9e yoUr p4S\$w0rd";
$lang['userexp_5'] = "<b>eM@1L &amp; pRiV4Cy</b> LEt\$ j00 CH4NgE h0w j00 C@n B3 conT4CTED 0n 4ND OfPh +h3 F0rum.";
$lang['userexp_6'] = "<b>f0Rum 0P+i0N5</b> l3ts j00 Ch@n93 How thE ForUM l0OK\$ @nD woRKs.";
$lang['userexp_7'] = "<b>a++@ChmENt5</b> 4ll0W\$ j00 T0 eD1+/D3LE+E yOUr a+t4cHM3n+s.";
$lang['userexp_8'] = "<b>sI9n@+ure</b> le+S J00 EDI+ YoUr \$19N4+uRE.";
$lang['userexp_9'] = "<b>rELAt10n5HiP\$</b> lets j00 M@n49E YoUR Rel4t10nsh1P W1+h 0+h3r useR\$ 0N +h3 phOrUm.";
$lang['userexp_9'] = "<b>w0RD fiL+eR</b> LEt\$ j00 3D1+ Y0ur pErsoN@l woRD PhIl+3R.";
$lang['userexp_10'] = "<b>thRE4D suBSCR1Pt10n\$</b> 4LL0W\$ j00 T0 MaN49e your ThRE4D suBSCr1pTi0N\$.";
$lang['userdetails'] = "uSer D3T@Ils";
$lang['userprofile'] = "usER pR0PhIL3";
$lang['emailandprivacy'] = "eM41l &amp; pr1V@CY";
$lang['editsignature'] = "edI+ \$i9n4+uRE";
$lang['norelationshipssetup'] = "j00 h4v3 no U53r rEL4+I0Nsh1p5 53T UP. 4dd @ n3w u\$3r BY \$e4RCHIn9 8ELOW.";
$lang['editwordfilter'] = "eD1+ W0rD PhiL+3R";
$lang['userinformation'] = "u\$Er InF0RM@+iOn";
$lang['changepassword'] = "chAnGE p4sSW0rd";
$lang['currentpasswd'] = "cUrr3N+ pa5\$w0Rd";
$lang['newpasswd'] = "nEW pa5\$W0rd";
$lang['confirmpasswd'] = "c0NPhiRM P4ssw0rD";
$lang['passwdsdonotmatch'] = "p4\$Sw0rD5 DO no+ m4tCh!";
$lang['nicknamerequired'] = "n1ckn@m3 1s REQu1rED!";
$lang['emailaddressrequired'] = "eM4Il 4DdrEs\$ is rEQUIr3d!";
$lang['logonnotpermitted'] = "l0Gon No+ PERm1++3d. Ch00SE @n0+h3R!";
$lang['nicknamenotpermitted'] = "nIcknAmE n0T P3rm1++3d. CHOo53 4NOtH3R!";
$lang['emailaddressnotpermitted'] = "em@il @DDr3ss N0t pErmi++3D. CHoo\$3 ANoth3r!";
$lang['emailaddressalreadyinuse'] = "eM41l @DDRE\$S 4lr34dy 1N Use. Ch0O53 4nO+H3R!";
$lang['relationshipsupdated'] = "relat10n\$HIP\$ UPD4tED!";
$lang['relationshipupdatefailed'] = "rElationsH1p UpD4+3d f4IlED!";
$lang['preferencesupdated'] = "pr3ph3RENCES wer3 SuCC3ssfUlLy uPD4teD.";
$lang['userdetails'] = "uSer D3+4ilS";
$lang['memberno'] = "m3m8Er N0.";
$lang['firstname'] = "f1rST NamE";
$lang['lastname'] = "l@S+ n@m3";
$lang['dateofbirth'] = "dat3 0pH BIR+H";
$lang['homepageURL'] = "h0mep@Ge uRl";
$lang['profilepicturedimensions'] = "prOPH1le p1CTUr3 (m4x 95X95px)";
$lang['avatarpicturedimensions'] = "av4taR p1CTur3 (m@x 15X15PX)";
$lang['invalidattachmentid'] = "inV@liD @++4chmeN+. cHECK th4+ I\$ H4sn't 83En D3l3ted.";
$lang['unsupportedimagetype'] = "uNSUPporTED im49e @++4CHMENt. J00 C4n oNly U\$3 jP9, 91ph aND Pn9 1m4G3 4++4chm3nts For yOUR @v@+4R @nD Pr0phIL3 P1CTUR3.";
$lang['selectattachment'] = "s3L3c+ @++4chMEnT";
$lang['pictureURL'] = "piC+uRE url";
$lang['avatarURL'] = "av4+4R Url";
$lang['profilepictureconflict'] = "to use @n 4tt4Chm3nt F0R YoUR pRophilE PictURE tHE Pic+UrE URl fi3LD MUs+ BE 8l4nK.";
$lang['avatarpictureconflict'] = "tO u53 4n 4+t4cHmENt for y0ur @V4T4R P1C+URE tEH 4VAt4R UrL pHi3lD mus+ b3 BL4Nk.";
$lang['attachmenttoolargeforprofilepicture'] = "s3L3ctED @Tt4CHMENT 1\$ T00 l4R9e ph0r prophil3 p1C+urE. m4x1muM D1m3N510N\$ 4r3 %s";
$lang['attachmenttoolargeforavatarpicture'] = "s3l3C+Ed aTtaCHmen+ 15 too l4Rg3 phOr 4vat4r P1c+ure. m@ximum D1m3n510N\$ 4r3 %s";
$lang['failedtoupdateuserdetails'] = "som3 0R 4LL 0f yOUr UsER ACCOUn+ D3t4Il5 C0ULd N0+ BE UPDATED. Pl34\$e TRy 49@iN latER.";
$lang['failedtoupdateuserpreferences'] = "s0M3 Or alL of yoUr usEr pR3FER3NC3S COULD NoT 83 UpD4ted. Pl3453 try aG41n l4+3r.";
$lang['emailaddresschanged'] = "eM@1l ADdr3ss h4S 833n Ch4NGeD";
$lang['newconfirmationemailsuccess'] = "youR EmAil 4DDR3SS h@\$ 8EEn CH@N9ed 4ND 4 neW C0nphirm4tion 3M4Il has 8EEN \$en+. pL3Ase CHECk aND rE4d +eh 3ma1l foR fURtheR 1NstRuC+10n5.";
$lang['newconfirmationemailfailure'] = "j00 h4v3 cHaN93d y0UR EM@1l 4DDREss, BU+ WE wEr3 UN48Le +0 SEnD 4 ConPh1rmat10n r3QUE\$t. Pl3a53 C0n+@Ct +HE F0rum oWn3r phoR 4\$s15+4NCE.";
$lang['forumoptions'] = "foRUM opt10N\$";
$lang['notifybyemail'] = "n0T1fy By 3m@il 0Ph pOsts +0 m3";
$lang['notifyofnewpm'] = "n0+1fy By poPUp 0Ph new Pm M3ss493s to ME";
$lang['notifyofnewpmemail'] = "n0Tify 8Y EM@1L 0ph N3W pM M35s49e\$ +0 M3";
$lang['daylightsaving'] = "aDju5+ ph0r D@yL1gH+ 54v1n9";
$lang['autohighinterest'] = "aU+OM4tIC4lly m@rK +hrEaDs i P0S+ IN @\$ h1GH iN+ER3sT";
$lang['convertimagestolinks'] = "aut0m4T1c4llY C0nv3r+ 3M8eDDEd 1M493\$ in P05+\$ iN+o L1NK5";
$lang['thumbnailsforimageattachments'] = "tHUmbna1L\$ f0R IM@G3 A+T4CHMENtS";
$lang['smallsized'] = "sm4ll \$1z3d";
$lang['mediumsized'] = "mEd1um \$IZ3d";
$lang['largesized'] = "l4rGE siZ3d";
$lang['globallyignoresigs'] = "glOBAlLy I9n0rE useR \$ign4+Ures";
$lang['allowpersonalmessages'] = "alL0W 0+HER US3Rs T0 sEND M3 p3R\$0n@l mESs49es";
$lang['allowemails'] = "aLL0W 0+h3r u53rs t0 senD m3 emA1Ls v1@ my pRoPhIle";
$lang['timezonefromGMT'] = "t1ME ZOn3";
$lang['postsperpage'] = "poS+\$ p3r P4g3";
$lang['fontsize'] = "fOnt s1Z3";
$lang['forumstyle'] = "f0rum sTyl3";
$lang['forumemoticons'] = "f0rum 3mo+iC0n\$";
$lang['startpage'] = "st@R+ p@g3";
$lang['signaturecontainshtmlcode'] = "sIgn4+Ur3 CON+4In5 h+Ml COD3";
$lang['savesignatureforuseonallforums'] = "s4v3 si9N4+URE F0r U\$E On aLL F0rums";
$lang['preferredlang'] = "pr3feRr3D l4NGu49E";
$lang['donotshowmyageordobtoothers'] = "d0 no+ \$H0w my 493 0r D4te oPh BIR+h +0 oth3r\$";
$lang['showonlymyagetoothers'] = "sH0W 0Nly mY aG3 to oTh3r\$";
$lang['showmyageanddobtoothers'] = "shOw B0+h My 4ge @nD d4+3 0F BIrTH TO 0+hErs";
$lang['showonlymydayandmonthofbirthytoothers'] = "shOw 0nlY MY DAy aND m0n+h opH B1r+h To o+h3rs";
$lang['listmeontheactiveusersdisplay'] = "liST ME 0N tHe 4ct1V3 u\$3rs DIspL4y";
$lang['browseanonymously'] = "bR0w53 F0rum @n0nYMOUslY";
$lang['allowfriendstoseemeasonline'] = "bROWse 4n0nyM0Usly, 8U+ 4ll0W PhR13nDs +0 sEE m3 4\$ 0nlinE";
$lang['revealspoileronmouseover'] = "rev34L sp0Il3RS on M0UsE OvER";
$lang['showspoilersinlightmode'] = "alw4ys 5H0W SP01Lers iN l1gHT M0de (UsEs L1GHtEr foNT C0L0ur)";
$lang['resizeimagesandreflowpage'] = "r3siz3 im@ge\$ @nd R3FL0W p@GE +0 PR3vEn+ h0r1zont4L scr0LL1ng.";
$lang['showforumstats'] = "shOW Ph0rum S+@ts @T 8Ot+om 0f mEsS@ge PANE";
$lang['usewordfilter'] = "en48le word F1l+3R.";
$lang['forceadminwordfilter'] = "foRCE U\$E 0ph 4DmIn Word Ph1L+3R 0n 4Ll u\$3r\$ (1NC. gU3Sts)";
$lang['timezone'] = "time Z0nE";
$lang['language'] = "l4n9U@93";
$lang['emailsettings'] = "em4il @nD C0N+4c+ \$e++1Ng\$";
$lang['forumanonymity'] = "f0RUm An0NYmITY sEtTinG\$";
$lang['birthdayanddateofbirth'] = "biR+hd@y 4ND D4+3 of 81R+h d1\$PL@y";
$lang['includeadminfilter'] = "incLuD3 4dM1N word F1lTer in MY LI\$+.";
$lang['setforallforums'] = "s3T f0R 4LL PHorUms?";
$lang['containsinvalidchars'] = "%s COntA1ns InVAlID CH@r@CTeRS!";
$lang['homepageurlmustincludeschema'] = "h0mEP4gE uRL mu\$+ IncLUD3 h+tp:// scHeM@.";
$lang['pictureurlmustincludeschema'] = "piCtuRE Url mUst 1NCluD3 h+tp:// scH3M4.";
$lang['avatarurlmustincludeschema'] = "av4t@r UrL mu5+ 1nCLudE Ht+P:// \$chEMa.";
$lang['postpage'] = "po\$+ pa9E";
$lang['nohtmltoolbar'] = "nO H+ML TOolB4R";
$lang['displaysimpletoolbar'] = "d1SPL4Y s1mple H+ML +0ol84r";
$lang['displaytinymcetoolbar'] = "d1Spl@y Wys1WYg HTml +o0LBAr";
$lang['displayemoticonspanel'] = "d1\$PlaY 3mo+1c0n\$ p@N3L";
$lang['displaysignature'] = "d1Spl4Y \$19n4+uRE";
$lang['disableemoticonsinpostsbydefault'] = "dISabLe EmO+1C0ns 1n M3ss@93s 8y D3f4ulT";
$lang['automaticallyparseurlsbydefault'] = "autOM4t1C@lLy P4r\$e urL5 IN mEss@93s BY d3F4uLT";
$lang['postinplaintextbydefault'] = "poS+ In pl41N +Ex+ bY DEF@uLt";
$lang['postinhtmlwithautolinebreaksbydefault'] = "p0s+ iN h+ml W1+h @UT0-l1Ne-8r34K5 BY Def4Ul+";
$lang['postinhtmlbydefault'] = "p0\$t in HtMl 8Y D3f@uL+";
$lang['privatemessageoptions'] = "pR1vaTE Mess49E 0pTI0ns";
$lang['privatemessageexportoptions'] = "pR1v@tE m3SS4G3 exp0r+ OpT10n5";
$lang['savepminsentitems'] = "s4v3 a C0py oph E4CH pm 1 \$3nd 1n My \$EN+ itEMs pHoldEr";
$lang['includepminreply'] = "iNClUD3 mES5@93 8ODY wH3n r3plY1Ng to pM";
$lang['autoprunemypmfoldersevery'] = "au+0 prUn3 mY Pm F0LDERS 3v3ry:";
$lang['friendsonly'] = "fR1enDs oNly?";
$lang['globalstyles'] = "gLo8@l styl3S";
$lang['forumstyles'] = "foRUM 5tyle\$";
$lang['youmustenteryourcurrentpasswd'] = "j00 mu\$t 3N+3r your CURRENt p@ssw0RD";
$lang['youmustenteranewpasswd'] = "j00 mu5T 3NTEr 4 NEw p@\$SWoRD";
$lang['youmustconfirmyournewpasswd'] = "j00 mU\$t CONfirM y0ur N3W p4SSWorD";
$lang['profileentriesmustnotincludehtml'] = "pRofil3 ENTr13S MuSt N0+ 1NcluDE H+mL";
$lang['failedtoupdateuserprofile'] = "f41lED +0 UPD@+3 u\$3r pR0PH1L3";

// Polls (create_poll.php, poll_results.php) ---------------------------------------------

$lang['mustprovideanswergroups'] = "j00 MUS+ pr0VId3 \$0m3 4n5wER 9rouPs";
$lang['mustprovidepolltype'] = "j00 mu\$+ PRoviD3 4 p0LL +yPE";
$lang['mustprovidepollresultsdisplaytype'] = "j00 must pRoViD3 resUl+s DispL4Y +ypE";
$lang['mustprovidepollvotetype'] = "j00 muS+ PrOv1d3 4 p0LL vO+E +Yp3";
$lang['mustprovidepollguestvotetype'] = "j00 mU\$t SP3cifY Iph 9U3STs sh0ULD 8E @LlOw3D t0 v0T3";
$lang['mustprovidepolloptiontype'] = "j00 mUsT pRoviDE 4 poll 0PtiOn typ3";
$lang['mustprovidepollchangevotetype'] = "j00 MUst proviD3 @ poLl cH@nge V0TE +Yp3";
$lang['pollquestioncontainsinvalidhtml'] = "on3 oR m0R3 OF YoUR P0Ll qU3s+1oN\$ C0n+41ns inv@LiD Html.";
$lang['pleaseselectfolder'] = "pL3aS3 \$EL3c+ A F0LDER";
$lang['mustspecifyvalues1and2'] = "j00 mu\$T sp3ciPhY vAluEs F0R 4N\$WER\$ 1 4nd 2";
$lang['tablepollmusthave2groups'] = "t@BUL4R F0Rm@+ p0lls MUSt h4V3 pr3C1\$ELy +W0 vo+iNg 9RoUps";
$lang['nomultivotetabulars'] = "t@BuL4r f0Rm@+ pOlls C@Nn0T 8e mUlTi-voT3";
$lang['nomultivotepublic'] = "pUbl1C BALlot5 C@nN0+ BE MUlt1-VOTE";
$lang['abletochangevote'] = "j00 WILl 83 4BLE +o chAn9E yoUr v0T3.";
$lang['abletovotemultiple'] = "j00 will bE 4ble +0 Vo+3 MUlT1PlE +1M3S.";
$lang['notabletochangevote'] = "j00 WIll n0+ 8e @8le +0 cH@Ng3 y0UR v0+3.";
$lang['pollvotesrandom'] = "n0+E: poLl v0tes 4RE r@ND0mly g3NER4T3D F0r prEv1EW 0nly.";
$lang['pollquestion'] = "poll quEs+10n";
$lang['possibleanswers'] = "p0\$5i8Le 4N\$w3Rs";
$lang['enterpollquestionexp'] = "ent3r +3h 4nswER\$ PHOr Y0UR p0lL qUES+i0N.. iF Your pOlL iS @ &quot;yES/No&quot; qu3ST10n, sImplY 3N+3r &quot;yES&quot; Ph0r 4n\$w3r 1 @ND &quot;no&quot; ph0R @nswEr 2.";
$lang['numberanswers'] = "nO. @NswEr\$";
$lang['answerscontainHTML'] = "anSW3R\$ C0Nt@1N hTmL (n0t 1NCluDIN9 \$i9N@+URE)";
$lang['optionsdisplay'] = "aN5wEr\$ d1spLAY +YpE";
$lang['optionsdisplayexp'] = "hoW shoULD +h3 aNSwER\$ 83 PREs3ntED?";
$lang['dropdown'] = "aS DroP-D0wN L1\$T(\$)";
$lang['radios'] = "aS 4 seRi3S 0ph rAdi0 bu+t0n\$";
$lang['votechanging'] = "vO+E CH4N91ng";
$lang['votechangingexp'] = "c4N a pEr\$0n CH@ng3 H1s or HEr vOt3?";
$lang['guestvoting'] = "gUE\$T v0TIN9";
$lang['guestvotingexp'] = "c4n 9u3sts v0t3 in +h1\$ poLl?";
$lang['allowmultiplevotes'] = "aLLOw MUl+1pl3 V0Te5";
$lang['pollresults'] = "poLl r3SUl+5";
$lang['pollresultsexp'] = "h0W w0uld j00 lIk3 to d1\$PL4y tH3 r3SUL+\$ 0Ph Y0UR p0Ll?";
$lang['pollvotetype'] = "pOLL v0TInG TyPE";
$lang['pollvotesexp'] = "h0w SHOUld t3H pOlL b3 COndUCTED?";
$lang['pollvoteanon'] = "aN0nyMoUsly";
$lang['pollvotepub'] = "pu8lic B4ll0+";
$lang['horizgraph'] = "h0RIz0nt4L 9r4PH";
$lang['vertgraph'] = "veRtIC4L gR@Ph";
$lang['tablegraph'] = "t4BUl@R PHorM@+";
$lang['polltypewarning'] = "<b>w4rninG</b>: +h1s iS @ pU8L1c B@Ll0+. Y0UR nAmE w1Ll be visi8LE N3X+ +0 +3h 0PT10N j00 vo+3 f0R.";
$lang['expiration'] = "exP1R@t10n";
$lang['showresultswhileopen'] = "dO j00 waNt tO show r3\$uL+\$ wh1l3 TEH p0ll 1S 0PEN?";
$lang['whenlikepollclose'] = "wh3n woulD J00 lik3 y0ur p0LL +0 aU+0m4T1cally CLos3?";
$lang['oneday'] = "oNe D4y";
$lang['threedays'] = "thr33 D4YS";
$lang['sevendays'] = "s3V3N D@ys";
$lang['thirtydays'] = "thIRTy Day\$";
$lang['never'] = "n3ver";
$lang['polladditionalmessage'] = "addi+Ion4L mEs\$49e (option@l)";
$lang['polladditionalmessageexp'] = "d0 j00 W4n+ to 1nCLUDE @n AdDIt1On4L poST 4Ph+3R +3h p0ll?";
$lang['mustspecifypolltoview'] = "j00 mu5+ speCiPhY 4 P0LL +0 V13w.";
$lang['pollconfirmclose'] = "aR3 j00 sUr3 J00 w@nT T0 CLose +h3 phoLLowin9 p0ll?";
$lang['endpoll'] = "eND poLl";
$lang['nobodyvotedclosedpoll'] = "n08ody v0t3d";
$lang['votedisplayopenpoll'] = "%s 4nD %s h4v3 V0+3d.";
$lang['votedisplayclosedpoll'] = "%s @nd %s vOteD.";
$lang['nousersvoted'] = "nO u\$ers";
$lang['oneuservoted'] = "1 uSER";
$lang['xusersvoted'] = "%s U5Er\$";
$lang['noguestsvoted'] = "no gu3\$+S";
$lang['oneguestvoted'] = "1 gu3st";
$lang['xguestsvoted'] = "%s 9uE5+s";
$lang['pollhasended'] = "pOll h4\$ 3NDED";
$lang['youvotedforpolloptionsondate'] = "j00 vo+3D pHor %s 0N %s";
$lang['thisisapoll'] = "tHis is @ pOll. CL1ck to v13w RE\$ult5.";
$lang['editpoll'] = "eDI+ poll";
$lang['results'] = "rE\$ult5";
$lang['resultdetails'] = "r3\$ult DET41LS";
$lang['changevote'] = "ch4nge v0TE";
$lang['pollshavebeendisabled'] = "pOll5 h@VE BeEN DI\$4BlED By +h3 F0ruM OWn3r.";
$lang['answertext'] = "answ3R +3xT";
$lang['answergroup'] = "aNSW3r 9RoUp";
$lang['previewvotingform'] = "pr3v13w v0tINg f0Rm";
$lang['viewbypolloption'] = "v1Ew 8Y poLl 0PT1on";
$lang['viewbyuser'] = "v13w bY UsER";

// Profiles (profile.php) ----------------------------------------------

$lang['editprofile'] = "edIT profiL3";
$lang['profileupdated'] = "pR0filE UpD4+3d.";
$lang['profilesnotsetup'] = "the F0rum 0WNer h4S n0t se+ Up prOFil3s.";
$lang['ignoreduser'] = "i9N0RED u\$er";
$lang['lastvisit'] = "l@S+ vIs1+";
$lang['userslocaltime'] = "us3r's lOc4l T1m3";
$lang['userstatus'] = "s+@+U5";
$lang['useractive'] = "oNlinE";
$lang['userinactive'] = "in4C+ive / opHPhl1NE";
$lang['totaltimeinforum'] = "t0T@l t1m3";
$lang['longesttimeinforum'] = "lOng3st s3s\$ion";
$lang['sendemail'] = "seND 3Ma1l";
$lang['sendpm'] = "sEnD pm";
$lang['visithomepage'] = "viSI+ h0M3p49e";
$lang['age'] = "a9E";
$lang['aged'] = "a93D";
$lang['birthday'] = "bIR+HD@y";
$lang['registered'] = "regiS+3red";
$lang['findpostsmadebyuser'] = "fInd p0\$+S m@D3 8y %s";
$lang['findpostsmadebyme'] = "f1nd p0s+s m@De by m3";
$lang['profilenotavailable'] = "pR0f1L3 n0t ava1L@bLE.";
$lang['userprofileempty'] = "thIs U53r H@s N0+ phIllED In +H31r pR0PHiL3 or i+ i\$ 5e+ t0 Priv@+E.";

// Registration (register.php) -----------------------------------------

$lang['newuserregistrationsarenotpermitted'] = "s0RRY, n3W UseR R3915+r4TiON\$ 4RE N0+ 4Ll0WEd r1GhT N0W. Pl34SE CHEck 84Ck l@+Er.";
$lang['usernameinvalidchars'] = "u\$3RNamE CAn 0NLY COn+@IN 4-Z, 0-9, _ - Ch4r@CtEr\$";
$lang['usernametooshort'] = "uSeRn4M3 mU\$+ 8e @ mIn1MUM 0PH 2 cH@r4cTER\$ LoN9";
$lang['usernametoolong'] = "u5ern4M3 mU\$t B3 a M@ximUM oF 15 Ch@r@c+eR\$ lon9";
$lang['usernamerequired'] = "a LOg0N N4me 1S REqUIr3d";
$lang['passwdmustnotcontainHTML'] = "p4\$swoRD Mu5+ N0t con+41n h+Ml +49s";
$lang['passwordinvalidchars'] = "p4\$\$worD C4n onLY C0nt41n 4-Z, 0-9, _ - Ch4R4cter\$";
$lang['passwdtooshort'] = "p4\$\$WOrD mUs+ 8E 4 m1NIMuM OpH 6 CH@R@CTEr\$ LOn9";
$lang['passwdrequired'] = "a P4\$sw0rd is rEQuir3d";
$lang['confirmationpasswdrequired'] = "a conphirm@+i0N p45\$WOrD 1\$ REQU1R3d";
$lang['nicknamerequired'] = "a niCkN@m3 is reQUiR3d";
$lang['emailrequired'] = "aN 3m41l 4DDrESs i5 rEquir3d";
$lang['passwdsdonotmatch'] = "p4\$\$WorDs D0 n0+ M@+cH";
$lang['usernamesameaspasswd'] = "useRN4ME @ND PASSw0RD mUsT B3 D1Phf3rEnt";
$lang['usernameexists'] = "s0rry, 4 u\$eR wi+h Th4+ n@m3 4LRE4dy Ex1\$ts";
$lang['successfullycreateduseraccount'] = "sUcC3ssfUlLy CRe@+3d U\$3r @Cc0unt";
$lang['useraccountcreatedconfirmfailed'] = "y0ur u\$eR @CCOUNt h4\$ 8e3n CREATED but +HE ReqUiR3d C0nfirMAt1on 3mail w@5 n0+ \$en+. PlE4se COnT4c+ +HE pH0rUm owN3R TO R3C+iFY tH1S. 1N +hIs M34n+iM3 Pl34\$3 CL1CK Th3 Con+1NUE bUtToN to LoGiN 1N.";
$lang['useraccountcreatedconfirmsuccess'] = "yoUR u\$er @CCOUNt h4\$ bE3n cR3A+ED BU+ b3f0re j00 C4N sT4RT P0st1ng J00 mUs+ coNF1RM y0ur EM4Il 4Ddr3Ss. pl34\$3 ch3ck Y0UR Em41l phOr @ l1NK +h4t WIll 4LLOw j00 to CONfIrM your @DDREss.";
$lang['useraccountcreated'] = "youR U\$3r 4CcouNT h4\$ b3en Cr34+ed 5uCc3ssPhuLlY! CLICK ThE CONT1nu3 8U+t0n bEL0w tO l0GIN";
$lang['errorcreatinguserrecord'] = "errOr cr34+1N9 UsER reCoRD";
$lang['userregistration'] = "u5eR RE915+r4t10n";
$lang['registrationinformationrequired'] = "rEg1s+r@tiOn inf0RM@+i0n (R3qu1red)";
$lang['profileinformationoptional'] = "pR0pHIl3 iNf0RmaT10n (0Pt10NAl)";
$lang['preferencesoptional'] = "pR3pher3NC3S (optioN4L)";
$lang['register'] = "r391STER";
$lang['rememberpasswd'] = "r3MemBER Pa5\$W0rD";
$lang['birthdayrequired'] = "yOur D@+E 0F 81r+h I5 r3QU1r3D 0R is inV@liD";
$lang['alwaysnotifymeofrepliestome'] = "nOT1fy 0N REPLy +0 mE";
$lang['notifyonnewprivatemessage'] = "no+Ify 0N nEW Pr1V@tE m3SS49e";
$lang['popuponnewprivatemessage'] = "pOp UP 0N N3W pr1V4TE MEss@GE";
$lang['automatichighinterestonpost'] = "aU+0mat1C H1GH IN+ER3ST 0N p05+";
$lang['confirmpassword'] = "cONPhiRm p4S\$w0RD";
$lang['invalidemailaddressformat'] = "inV4l1D EMa1L 4ddr3\$\$ phorm4T";
$lang['moreoptionsavailable'] = "m0re propHiL3 @ND pr3ph3R3NC3 0pT10ns 4Re @v41l@BLE 0NCe j00 Reg1\$+3r";
$lang['textcaptchaconfirmation'] = "c0Nphirm@tI0N";
$lang['textcaptchaexplain'] = "t0 +h3 r19H+ i\$ 4 tExT-CapTCH@ 1MA93. pLE4\$3 tyP3 +hE C0de j00 c4n \$3E iN +H3 im49E in+0 +He inpUt f1eld 8eL0W 1+.";
$lang['textcaptchaimgtip'] = "tHis i5 4 C4ptCh@-p1cTUr3. i+ 1S U\$3D +0 pr3vent 4ut0m@t1C rEgIs+r4+10N";
$lang['textcaptchamissingkey'] = "a cOnF1Rm@+1ON C0dE I5 rEQUireD.";
$lang['textcaptchaverificationfailed'] = "t3XT-C@P+CHA vEr1f1CA+1On C0de W4\$ inC0rreCt. PlE4SE rE-3nTER i+.";
$lang['forumrules'] = "fOrUm RUl3S";
$lang['forumrulesnotification'] = "iN orDEr +0 ProCEED, j00 mUs+ 49RE3 WI+h Th3 f0ll0W1N9 ruLEs";
$lang['forumrulescheckbox'] = "i H4v3 r3@D, 4ND 4Gr3e +0 4biDE 8Y +EH f0RUm RUl3S.";
$lang['youmustagreetotheforumrules'] = "j00 mU\$+ 49R3e t0 tHE f0ruM ruL3S 83f0rE j00 CAn cOn+InUE.";

// Recent visitors list  (visitor_log.php) -----------------------------

$lang['member'] = "m3mbeR";
$lang['searchforusernotinlist'] = "s3ArCH PhoR A useR no+ In l1sT";
$lang['yoursearchdidnotreturnanymatches'] = "y0ur sE4RCh D1D n0t R3+UrN 4Ny M4+CH3s. trY \$IMPl1fy1NG y0uR sE4rCh P4RAm3t3R5 @nD TrY @g@IN.";
$lang['hiderowswithemptyornullvalues'] = "hID3 r0WS wItH 3MPtY Or nULl v@lUEs 1n 53l3C+Ed COLUmNs";
$lang['showregisteredusersonly'] = "shoW Reg15+Er3d us3r\$ 0nLy (h1d3 9u3STS)";

// Relationships (user_rel.php) ----------------------------------------

$lang['relationships'] = "r3L4t1onsh1ps";
$lang['userrelationship'] = "uSer r3l@+1oN\$h1p";
$lang['userrelationships'] = "u\$Er R3l4+i0nshiP\$";
$lang['failedtoremoveselectedrelationships'] = "f@1l3D T0 R3mov3 53leC+3d rEL4tioN\$hIp";
$lang['friends'] = "fR13nDs";
$lang['ignoredcompletely'] = "i9n0rEd COmPl3+3Ly";
$lang['relationship'] = "rEl4+1ONsHiP";
$lang['restorenickname'] = "re\$+ORE UsEr's n1cknaM3";
$lang['friend_exp'] = "u5Er'5 pO\$+S m@rK3D W1+h 4 &quot;phr1end&quot; 1COn.";
$lang['normal_exp'] = "uS3r'\$ Pos+s 4PPE4R @s nOrmal.";
$lang['ignore_exp'] = "u\$3R's Po\$+s @r3 h1dDEN.";
$lang['ignore_completely_exp'] = "thre@d5 @nD PostS T0 or Phr0m USER W1LL @ppe4R DEL3+eD.";
$lang['display'] = "dI5pl4Y";
$lang['displaysig_exp'] = "u5ER's SI9n@+uRE Is D1SPL4Y3D 0n tHE1R Pos+5.";
$lang['hidesig_exp'] = "us3r'\$ Sign4+URE I\$ hidD3n 0n tHE1r p0S+5.";
$lang['cannotignoremod'] = "j00 CAnnO+ ign0RE +HiS UsER, 4S +h3Y @R3 @ MoD3r@+0R.";
$lang['previewsignature'] = "pR3V13W \$19N4turE";

// Search (search.php) -------------------------------------------------

$lang['searchresults'] = "sE@rCH r3sUL+\$";
$lang['usernamenotfound'] = "tEh U53RN4m3 j00 sp3c1Ph13D iN +EH +o 0r froM ph1Eld wAs n0t foUnD.";
$lang['notexttosearchfor'] = "on3 0R 4ll opH Y0ur \$34Rch KEYWorDS W3re Inv4liD. SE4rch kEYW0rDS must b3 No \$H0rteR Th4n %d CHAr4c+ers, n0 lOngeR tH@N %d Ch4raC+3rs @ND MUS+ N0+ ApP34r 1N thE %s";
$lang['keywordscontainingerrors'] = "k3yw0rD5 C0N+@iN1N9 erR0Rs: %s";
$lang['mysqlstopwordlist'] = "my5ql \$topw0rD List";
$lang['foundzeromatches'] = "f0und: 0 m4+CHes";
$lang['found'] = "founD";
$lang['matches'] = "mAtCh3\$";
$lang['prevpage'] = "pr3v10us P@GE";
$lang['findmore'] = "f1nD more";
$lang['searchmessages'] = "s3ArCH mEss493s";
$lang['searchdiscussions'] = "sE4rch D1sCUSs1Ons";
$lang['find'] = "fInd";
$lang['additionalcriteria'] = "adD1+i0N@l cR1+eriA";
$lang['searchbyuser'] = "s3arCH BY usER (0Pt10n4l)";
$lang['folderbrackets_s'] = "foLDER(\$)";
$lang['postedfrom'] = "pos+3d phr0m";
$lang['postedto'] = "poS+3D +0";
$lang['today'] = "t0dAy";
$lang['yesterday'] = "y3\$+erD@Y";
$lang['daybeforeyesterday'] = "d4Y 83f0RE yE5+erD4y";
$lang['weekago'] = "%s w3eK A9o";
$lang['weeksago'] = "%s WEEKs 490";
$lang['monthago'] = "%s MOn+H 490";
$lang['monthsago'] = "%s MON+hs @g0";
$lang['yearago'] = "%s yeaR @g0";
$lang['beginningoftime'] = "bE91nning oF +1M3";
$lang['now'] = "n0w";
$lang['lastpostdate'] = "l@s+ Po5+ D@Te";
$lang['numberofreplies'] = "nUm83r of Repli3S";
$lang['foldername'] = "f0ld3R n4ME";
$lang['authorname'] = "au+h0R N4M3";
$lang['decendingorder'] = "n3W3\$+ pHiRs+";
$lang['ascendingorder'] = "old35T FiRst";
$lang['keywords'] = "k3ywords";
$lang['sortby'] = "s0r+ 8y";
$lang['sortdir'] = "s0R+ DiR";
$lang['sortresults'] = "sor+ r3sul+\$";
$lang['groupbythread'] = "gRoup 8Y tHre4d";
$lang['postsfromuser'] = "po5+s pHr0M u\$3r";
$lang['poststouser'] = "poSts +o UsEr";
$lang['poststoandfromuser'] = "pO5ts +0 anD From U53r";
$lang['searchfrequencyerror'] = "j00 C4N onLy se4rch oNCE 3v3rY %s \$eCOnD\$. pLE453 try @G4IN L4+ER.";
$lang['searchsuccessfullycompleted'] = "s3ArCh sucCESsFUlly C0MPLe+3d. %s";
$lang['clickheretoviewresults'] = "cL1ck h3r3 +O v13W r3sULT\$.";

// Search Popup (search_popup.php) -------------------------------------

$lang['select'] = "s3L3C+";
$lang['searchforthread'] = "sEarcH phoR ThReAd";
$lang['mustspecifytypeofsearch'] = "j00 mu\$T spECIPHy typ3 Of 534rCh +o p3Rf0RM";
$lang['unkownsearchtypespecified'] = "unKnowN sEArcH +ypE sP3C1Ph1eD";
$lang['mustentersomethingtosearchfor'] = "j00 MU5+ 3nT3R soM3tH1NG tO sE4rch PhOr";

// Start page (start_left.php) -----------------------------------------

$lang['recentthreads'] = "r3C3Nt tHre4dS";
$lang['startreading'] = "st4rt re4D1ng";
$lang['threadoptions'] = "thr3aD 0PT10ns";
$lang['editthreadoptions'] = "edi+ +hR3@D 0p+i0N\$";
$lang['morevisitors'] = "m0R3 V15I+0r5";
$lang['forthcomingbirthdays'] = "f0RThcoM1NG B1r+hD@y\$";

// Start page (start_main.php) -----------------------------------------

$lang['editstartpage_help'] = "j00 C4n ed1+ +hIs P@gE pHrOm +h3 4DM1n iN+ErPh@CE";

// Thread navigation (thread_list.php) ---------------------------------

$lang['newdiscussion'] = "neW DiSCUssioN";
$lang['createpoll'] = "cR3@+e poLl";
$lang['search'] = "se4rCh";
$lang['searchagain'] = "sE4rCh 4G4IN";
$lang['alldiscussions'] = "aLl d1SCuss10Ns";
$lang['unreaddiscussions'] = "unR34d D1sCu5\$10Ns";
$lang['unreadtome'] = "unR3AD &quot;+O: Me&quot;";
$lang['todaysdiscussions'] = "tod4y's D1ScUSS1ons";
$lang['2daysback'] = "2 d@y\$ 84ck";
$lang['7daysback'] = "7 D4ys 84ck";
$lang['highinterest'] = "h19H 1nteR3st";
$lang['unreadhighinterest'] = "uNrE4D h1GH iNtER3s+";
$lang['iverecentlyseen'] = "i'V3 r3C3ntLY seEN";
$lang['iveignored'] = "i'V3 1gnoRED";
$lang['byignoredusers'] = "bY 1GN0red Users";
$lang['ivesubscribedto'] = "i'V3 SU8sCR18ED +0";
$lang['startedbyfriend'] = "s+4r+eD BY pHri3Nd";
$lang['unreadstartedbyfriend'] = "uNrE4D sTD 8y fRi3nd";
$lang['startedbyme'] = "s+@r+3d By M3";
$lang['unreadtoday'] = "uNre@D T0D@Y";
$lang['deletedthreads'] = "del3TEd +hR34d5";
$lang['goexcmark'] = "go!";
$lang['folderinterest'] = "fOLder 1nter3S+";
$lang['postnew'] = "p0\$t nEw";
$lang['currentthread'] = "currEnt +hr34D";
$lang['highinterest'] = "hI9h IntEr3s+";
$lang['markasread'] = "m4rk 4\$ rEaD";
$lang['next50discussions'] = "n3xt 50 DI\$cussionS";
$lang['visiblediscussions'] = "vIS1bL3 DisCU5\$i0ns";
$lang['selectedfolder'] = "s3L3C+3d F0Lder";
$lang['navigate'] = "n4v1g4te";
$lang['couldnotretrievefolderinformation'] = "th3RE 4RE N0 PHOlDEr\$ @v41L@8LE.";
$lang['nomessagesinthiscategory'] = "no mEss49ES 1n +h15 C4te9Ory. PlE4\$E \$3lECT 4No+HEr, 0R %s f0R @Ll thr34Ds";
$lang['clickhere'] = "cL1Ck h3R3";
$lang['prev50threads'] = "pR3v10us 50 +hreaD\$";
$lang['next50threads'] = "nExT 50 +HR34d\$";
$lang['nextxthreads'] = "n3xt %s +hRE4DS";
$lang['threadstartedbytooltip'] = "thR34d #%s s+4RT3d BY %s. viewED %s";
$lang['threadviewedonetime'] = "1 tim3";
$lang['threadviewedtimes'] = "%d +1me\$";
$lang['unreadthread'] = "unRE@D tHrE4d";
$lang['readthread'] = "r3@D +hr34D";
$lang['unreadmessages'] = "uNr3aD m3ss4G3s";
$lang['subscribed'] = "sU85CRi83D";
$lang['ignorethisfolder'] = "iGN0re tHiS Fold3r";
$lang['stopignoringthisfolder'] = "s+op i9N0r1N9 thi5 pHOlD3r";
$lang['stickythreads'] = "sTiCkY THrE4D\$";
$lang['mostunreadposts'] = "m0S+ UnRE4D p05+s";
$lang['onenew'] = "%d nEw";
$lang['manynew'] = "%d new";
$lang['onenewoflength'] = "%d nEW oF %d";
$lang['manynewoflength'] = "%d N3W oph %d";
$lang['ignorefolderconfirm'] = "ar3 J00 sUrE J00 w4Nt +0 ignor3 tHiS Ph0ld3R?";
$lang['unignorefolderconfirm'] = "aRe J00 sur3 j00 w@n+ +o \$+0P I9n0R1nG Th1S PhOlD3r?";
$lang['confirmmarkasread'] = "aRE j00 \$URE j00 Want t0 mArK +HE 5EL3cTED +hr34ds @s R34d?";
$lang['successfullymarkreadselectedthreads'] = "succe\$SfullY m@rk3d \$el3c+3D +HrEADs 4S R34D";
$lang['failedtomarkselectedthreadsasread'] = "f@1LEd +0 MARk \$3lEC+3d +hr34Ds @\$ R34D";
$lang['gotofirstpostinthread'] = "gO +o fIr\$t p0St 1N ThRe4D";
$lang['gotolastpostinthread'] = "gO tO l4\$+ pO\$T In +HRE4D";
$lang['viewmessagesinthisfolderonly'] = "v13W me\$\$493s 1N tHi\$ pholDER only";
$lang['shownext50threads'] = "sH0W N3xt 50 +hr3ADS";
$lang['showprev50threads'] = "sH0w pR3VioU\$ 50 +hRE4DS";
$lang['createnewdiscussioninthisfolder'] = "cR3@tE nEW Di\$cUssi0n IN tH1\$ f0lDEr";
$lang['nomessages'] = "n0 M3s5@G3s";

// HTML toolbar (htmltools.inc.php) ------------------------------------
$lang['bold'] = "b0Ld";
$lang['italic'] = "i+aliC";
$lang['underline'] = "uNdeRl1NE";
$lang['strikethrough'] = "stRIkE+HroUGh";
$lang['superscript'] = "sUpeRscr1P+";
$lang['subscript'] = "subscr1P+";
$lang['leftalign'] = "l3ft-4l1Gn";
$lang['center'] = "cEn+Er";
$lang['rightalign'] = "r19ht-4l1gN";
$lang['numberedlist'] = "nuM8eRED l15+";
$lang['list'] = "l15+";
$lang['indenttext'] = "iNDenT TExt";
$lang['code'] = "c0de";
$lang['quote'] = "quOt3";
$lang['spoiler'] = "sp0IL3R";
$lang['horizontalrule'] = "hOr1z0N+@l RuLE";
$lang['image'] = "iM@G3";
$lang['hyperlink'] = "hyPErlInk";
$lang['noemoticons'] = "dI\$@8LE 3Mo+iCOn5";
$lang['fontface'] = "f0n+ F4c3";
$lang['size'] = "s1Z3";
$lang['colour'] = "c0L0ur";
$lang['red'] = "r3D";
$lang['orange'] = "oranGE";
$lang['yellow'] = "y3LL0W";
$lang['green'] = "gR3en";
$lang['blue'] = "blUE";
$lang['indigo'] = "inDig0";
$lang['violet'] = "v1oleT";
$lang['white'] = "wH1+E";
$lang['black'] = "bl4Ck";
$lang['grey'] = "gR3y";
$lang['pink'] = "piNk";
$lang['lightgreen'] = "l19ht 9R3EN";
$lang['lightblue'] = "l19Ht 8LUE";

// Forum Stats (messages.inc.php - messages_forum_stats()) -------------

$lang['forumstats'] = "foRUM s+4T\$";
$lang['usersactiveinthepasttimeperiod'] = "%s 4CT1ve in +h3 p@\$T %s. %s";

$lang['numactiveguests'] = "<b>%s</b> Gu3St\$";
$lang['oneactiveguest'] = "<b>1</b> gu3\$+";
$lang['numactivemembers'] = "<b>%s</b> m3mBer\$";
$lang['oneactivemember'] = "<b>1</b> M3MB3R";
$lang['numactiveanonymousmembers'] = "<b>%s</b> 4nonym0u\$ M3mbER5";
$lang['oneactiveanonymousmember'] = "<b>1</b> 4NonYmous M3MBER";

$lang['numthreadscreated'] = "<b>%s</b> ThrE4D\$";
$lang['onethreadcreated'] = "<b>1</b> thr34D";
$lang['numpostscreated'] = "<b>%s</b> po5Ts";
$lang['onepostcreated'] = "<b>1</b> Po\$T";

$lang['younormal'] = "j00";
$lang['youinvisible'] = "j00 (1nv1\$18L3)";
$lang['viewcompletelist'] = "v1ew c0MPlE+3 li\$t";
$lang['ourmembershavemadeatotalofnumthreadsandnumposts'] = "ouR mEmBErs h4VE m@D3 4 +o+@l of %s 4nd %s.";
$lang['longestthreadisthreadnamewithnumposts'] = "l0N9es+ +hR3AD I\$ <b>%s</b> Wi+H %s.";
$lang['therehavebeenxpostsmadeinthelastsixtyminutes'] = "th3rE h4v3 833n <b>%s</b> p05+5 M@DE 1n +HE l@\$+ 60 miNU+3S.";
$lang['therehasbeenonepostmadeinthelastsxityminutes'] = "tH3r3 has 8EEN <b>1</b> Po\$+ m@D3 in +EH Last 60 minUtES.";
$lang['mostpostsevermadeinasinglesixtyminuteperiodwasnumposts'] = "m05+ pO\$+S 3VEr M@d3 IN @ siNgL3 60 minuTE P3R1OD 1\$ <b>%s</b> On %s.";
$lang['wehavenumregisteredmembersandthenewestmemberismembername'] = "we havE <b>%s</b> R39isTER3D M3m83R\$ @ND +3H NEwEsT M3MB3r is <b>%s</b>.";
$lang['wehavenumregisteredmember'] = "w3 H4V3 %s RE91\$+eR3D MEm8ers.";
$lang['wehaveoneregisteredmember'] = "w3 h4V3 0n3 R39i\$+ER3d mEM8Er.";
$lang['mostuserseveronlinewasnumondate'] = "m0St us3Rs 3vEr oNline w@S <b>%s</b> ON %s.";
$lang['statsdisplaychanged'] = "st4+s d1SPl4Y CH4N9ED";

// Thread Options (thread_options.php) ---------------------------------

$lang['updatessavedsuccessfully'] = "updatEs 5@VED \$ucCEssFUlly";
$lang['useroptions'] = "useR oP+i0n\$";
$lang['markedasread'] = "m4rk3D 4s r34d";
$lang['postsoutof'] = "p0ST5 OUT 0ph";
$lang['interest'] = "iN+3rEs+";
$lang['closedforposting'] = "cl0sED f0R Po\$t1n9";
$lang['locktitleandfolder'] = "loCK tiTlE @ND ph0lder";
$lang['deletepostsinthreadbyuser'] = "deLET3 p0STS in +hR34D BY USEr";
$lang['deletethread'] = "d3LETE +Hr3AD";
$lang['permenantlydelete'] = "p3RM4n3n+ly d3letE";
$lang['movetodeleteditems'] = "m0v3 t0 del3T3d thRE4D5";
$lang['undeletethread'] = "uNdel3t3 +Hr3ad";
$lang['threaddeletedpermenantly'] = "tHre@d DEL3+3d pErm4n3NtlY. C@nn0T UnD3l3TE.";
$lang['markasunread'] = "m4RK 4S UnRE4d";
$lang['makethreadsticky'] = "m@K3 thrE4d 5+1CKY";
$lang['threareadstatusupdated'] = "tHre@d r3@D st4+US upD4+3d sUCCEssFULlY";
$lang['interestupdated'] = "thREaD in+ER3St sT4+Us UpD4tED suCCESsfULly";
$lang['failedtoupdatethreadreadstatus'] = "fa1L3D +0 upDA+E +Hr34D re4d 5+4tus";
$lang['failedtoupdatethreadinterest'] = "f41l3D +0 UpD4+e +hR34d 1n+3Rest";
$lang['failedtorenamethread'] = "f@1lEd +0 r3N@m3 +hR34d";
$lang['failedtomovethread'] = "f4il3D to m0V3 +hr3AD +0 sp3CiFiED pHoldER";
$lang['failedtoupdatethreadstickystatus'] = "f4il3D +0 upD4+3 THRE4d s+1cKy \$+4tus";
$lang['failedtoupdatethreadclosedstatus'] = "f4il3D +0 upDAte +hR34d CL0S3d S+4TUS";
$lang['failedtoupdatethreadlockstatus'] = "f4il3D +0 UpD4te ThRE4D LOCK StA+u5";
$lang['failedtodeletepostsbyuser'] = "f41LED t0 deLE+3 P0sTs 8Y S3L3c+ED Us3R";
$lang['failedtodeletethread'] = "f@IL3D t0 DEL3T3 +hr34d.";
$lang['failedtoundeletethread'] = "f@ilED +o uN-DELE+E +hR34d";

// Dictionary (dictionary.php) -----------------------------------------

$lang['dictionary'] = "d1C+1oN4Ry";
$lang['spellcheck'] = "sp3ll ch3ck";
$lang['notindictionary'] = "n0t 1n D1C+1ON4ry";
$lang['changeto'] = "ch@n9E +0";
$lang['restartspellcheck'] = "r3star+";
$lang['cancelchanges'] = "c@NC3l CH@n93s";
$lang['initialisingdotdotdot'] = "iNiTI4l1s1ng...";
$lang['spellcheckcomplete'] = "sp3ll ch3ck i\$ compLe+E. to reS+4r+ 5PEll Ch3ck CL1CK r3s+@rt BU++on BEL0w.";
$lang['spellcheck'] = "sP3ll CH3ck";
$lang['noformobj'] = "no Ph0rm oBj3c+ \$P3cIphI3D Ph0R RE+Urn T3XT";
$lang['bodytext'] = "b0dy +Ext";
$lang['ignore'] = "i9n0RE";
$lang['ignoreall'] = "ignore 4LL";
$lang['change'] = "ch4ng3";
$lang['changeall'] = "cH4N9E 4lL";
$lang['add'] = "add";
$lang['suggest'] = "sU993s+";
$lang['nosuggestions'] = "(No \$u9gesT1ons)";
$lang['cancel'] = "c4nCel";
$lang['dictionarynotinstalled'] = "n0 d1CT10N4RY h4\$ 8eEn iNstall3D. pL3@53 CoN+4c+ +3H foRum 0wnER tO rEmEdy +his.";

// Permissions keys ----------------------------------------------------

$lang['postreadingallowed'] = "pO5+ r3adin9 @llowED";
$lang['postcreationallowed'] = "p0\$t CRE4+10n allow3d";
$lang['threadcreationallowed'] = "thRe4D Cr34+10n 4LL0w3D";
$lang['posteditingallowed'] = "pO5T 3DI+InG @ll0W3d";
$lang['postdeletionallowed'] = "pO5+ DEl3+10n 4ll0w3D";
$lang['attachmentsallowed'] = "aTt4CHmENt5 alLoW3D";
$lang['htmlpostingallowed'] = "hTML Po\$+1ng @lloW3D";
$lang['signatureallowed'] = "sI9n4tur3 4ll0W3d";
$lang['guestaccessallowed'] = "gUe5T 4CC3ss @lloWED";
$lang['postapprovalrequired'] = "pOs+ 4pproVAL r3QUIr3d";

// RSS feeds gubbins

$lang['rssfeed'] = "r\$\$ f33d";
$lang['every30mins'] = "eV3RY 30 M1NU+3\$";
$lang['onceanhour'] = "onc3 4n hoUR";
$lang['every6hours'] = "evERy 6 H0urs";
$lang['every12hours'] = "eV3rY 12 hours";
$lang['onceaday'] = "once @ D@Y";
$lang['rssfeeds'] = "r5s F3EDs";
$lang['feedname'] = "fE3D n4M3";
$lang['feedfoldername'] = "fe3d pholDER N4m3";
$lang['feedlocation'] = "f33D loC4+i0n";
$lang['threadtitleprefix'] = "tHr3aD +1+l3 pREFIx";
$lang['feednameandlocation'] = "f33D N4m3 4nD l0c@t10n";
$lang['feedsettings'] = "fe3d sEt+1Ng\$";
$lang['updatefrequency'] = "uPd4tE FREQUENCY";
$lang['rssclicktoreadarticle'] = "clICK hEr3 t0 rE4d +his ArT1CL3";
$lang['addnewfeed'] = "add nEw pH3ED";
$lang['editfeed'] = "ed1t F33D";
$lang['feeduseraccount'] = "f33d u\$3r @Cc0uNt";
$lang['noexistingfeeds'] = "n0 exI5+1N9 Rss f3EDS F0UND. +0 aDD @ ph3ED CLICK +Eh 'aDD n3w' 8U++0N 83l0w";
$lang['rssfeedhelp'] = "heR3 J00 C4n s3+UP s0m3 RsS F3EDs f0r 4u+0m@+iC pRoPa9@+1oN 1N+0 yoUR F0RUm. +H3 IteMs PHrOM +3H R\$\$ phE3dS j00 @DD w1ll BE CRE4+eD @\$ +hr3@D5 whiCH U\$3rs C4n R3ply T0 4S IPh +H3Y WEr3 n0rm4L P05+s. th3 RSS fEED MUSt 8e 4CC3sSi8le vi@ h++p oR 1+ W1LL N0t WorK.";
$lang['mustspecifyrssfeedname'] = "must SP3C1pHy r\$S PHE3d n4me";
$lang['mustspecifyrssfeeduseraccount'] = "muST SP3cipHy rsS f3ED u\$3r @CCoUnt";
$lang['mustspecifyrssfeedfolder'] = "muST spECIphy r\$s f3ED Ph0ld3R";
$lang['mustspecifyrssfeedurl'] = "mU5t spEciPhY Rss ph3ed Url";
$lang['mustspecifyrssfeedupdatefrequency'] = "mU5T spEC1FY rss f3ED Upd4+e fr3QU3nCy";
$lang['unknownrssuseraccount'] = "uNKNoWn rss U\$3r @CC0uN+";
$lang['rssfeedsupportshttpurlsonly'] = "r5S FeED \$upp0r+5 h++p URls 0nLY. 5eCUR3 PhE3ds (H++p\$://) Ar3 not supP0R+3d.";
$lang['rssfeedurlformatinvalid'] = "r5s phEeD UrL F0RM@+ i\$ InV@LiD. URl mUst inCLUD3 5CHEmE (3.G. hT+p://) 4nd 4 h05+N4ME (E.9. WwW.hostn4M3.com).";
$lang['rssfeeduserauthentication'] = "rSs f3ED d0es n0+ 5upp0r+ h+tp USEr 4UTH3N+1caT1On";
$lang['successfullyremovedselectedfeeds'] = "suCCe\$\$fUlly r3MovED s3lEC+3D F3edS";
$lang['successfullyaddedfeed'] = "sUcCEs\$fully 4DD3D New Ph3Ed";
$lang['successfullyeditedfeed'] = "sUcC3ssfULly 3d1+3D F3eD";
$lang['failedtoremovefeeds'] = "f@1leD +0 rEm0v3 soM3 or @lL 0ph the sEL3C+3D FE3ds";
$lang['failedtoaddnewrssfeed'] = "f41leD to 4DD NEw r\$\$ F33d";
$lang['failedtoupdaterssfeed'] = "f41l3D t0 UpD@+E rs5 PhEeD";
$lang['rssstreamworkingcorrectly'] = "r\$\$ str34M 4ppe4Rs +0 BE w0rk1Ng C0RREC+lY";
$lang['rssstreamnotworkingcorrectly'] = "rSS \$TR3@M w4s EMP+y or CoUlD nOt B3 phounD";
$lang['invalidfeedidorfeednotfound'] = "inv4liD ph3eD ID oR fEED No+ pH0UnD";

// PM Export Options

$lang['pmexportastype'] = "eXp0Rt 4s TyPe";
$lang['pmexporthtml'] = "h+ML";
$lang['pmexportxml'] = "xmL";
$lang['pmexportplaintext'] = "pLa1n TExt";
$lang['pmexportmessagesas'] = "exPoR+ M3ss49es 4S";
$lang['pmexportonefileforallmessages'] = "oNe phIlE f0r 4lL meSS@gE\$";
$lang['pmexportonefilepermessage'] = "on3 philE p3r M3Ss@G3";
$lang['pmexportattachments'] = "expORT @t+@CHM3Nts";
$lang['pmexportincludestyle'] = "incLUD3 ph0RUm s+YlE Sh3e+";
$lang['pmexportwordfilter'] = "aPPLy worD fIlteR +0 mEss49es";

// Thread merge / split options

$lang['threadhasbeensplit'] = "threAd h4\$ b3En \$PL1+";
$lang['threadhasbeenmerged'] = "tHr34D H@5 B3EN M3RGED";
$lang['mergesplitthread'] = "mERg3 / spl1+ +HR34D";
$lang['mergewiththreadid'] = "m3rgE W1+h +hR3AD 1D:";
$lang['postsinthisthreadatstart'] = "p0\$T5 in +His tHrE4d @t \$+4rt";
$lang['postsinthisthreadatend'] = "pOs+\$ In +h1\$ +Hr3@D a+ eND";
$lang['reorderpostsintodateorder'] = "r3-0rdER po5+5 iN+o d4+3 0rd3R";
$lang['splitthreadatpost'] = "sPl1t +hr34D aT P0\$T:";
$lang['selectedpostsandrepliesonly'] = "s3l3Cted p0ST @nD rEPl1es onLy";
$lang['selectedandallfollowingposts'] = "sEleC+ED 4ND 4Ll ph0ll0W1Ng Pos+s";

$lang['threadmovedhere'] = "her3";

$lang['thisthreadhasmoved'] = "<b>thR3@d\$ mEr93d:</b> +h1\$ +Hr3@D H4S M0VED %s";
$lang['thisthreadwasmergedfrom'] = "<b>tHre4d\$ m3Rg3D:</b> Th1s +hr3Ad w@s m3RGed phrom %s";
$lang['somepostsinthisthreadhavebeenmoved'] = "<b>tHr34d \$PLIT:</b> \$0ME pOST\$ IN th1\$ +hRE4d h4v3 be3N m0v3D %s";
$lang['somepostsinthisthreadweremovedfrom'] = "<b>thR34d spL1T:</b> S0m3 p0St5 1n +H1s +Hr34D WErE MOV3d fR0M %s";

$lang['thisposthasbeenmoved'] = "<b>thR3@d 5pl1+:</b> tH1\$ PO5+ h4\$ BEEN m0V3d %s";

$lang['invalidfunctionarguments'] = "inv@L1D fUnC+1ON @R9UM3NTs";
$lang['couldnotretrieveforumdata'] = "coulD n0T RETr13vE F0RUM D@+4";
$lang['cannotmergepolls'] = "oN3 0r moRe thR3@d\$ 1s @ poLl. j00 C4NnoT MergE pOlL\$";
$lang['couldnotretrievethreaddatamerge'] = "c0uld n0T rETr13vE +hR34D DAt4 PHROm 0N3 0R M0RE ThR34d5";
$lang['couldnotretrievethreaddatasplit'] = "cOULD n0t rETrI3VE +Hr3ad d4+4 Fr0m s0UrCE +Hr34D";
$lang['couldnotretrievepostdatamerge'] = "coULD no+ RETr1eVE Post D@t4 phrom onE oR m0RE ThrE4DS";
$lang['couldnotretrievepostdatasplit'] = "c0uld no+ RETrIev3 PO\$+ DAT4 pHrOm s0URC3 ThR34D";
$lang['failedtocreatenewthreadformerge'] = "f@1leD +0 cr34T3 n3w thr3@D PhOr MERgE";
$lang['failedtocreatenewthreadforsplit'] = "f4IL3D +0 crEA+E n3w thr3@D F0R spL1T";

// Thread subscriptions

$lang['threadsubscriptions'] = "tHre4D Su8scriPt10ns";
$lang['couldnotupdateinterestonthread'] = "cOuld n0T upD4+E 1nter3st 0N tHR34d '%s'";
$lang['threadinterestsupdatedsuccessfully'] = "tHR34d iN+3rests UPD4+3D sUCCEssFUlLy";
$lang['nothreadsubscriptions'] = "j00 @rE N0+ \$uB5CRi8ed +O 4NY tHrE4ds.";
$lang['resetselected'] = "reSEt s3LEc+ED";
$lang['allthreadtypes'] = "alL +Hr3AD +Ype5";
$lang['ignoredthreads'] = "igN0REd +hr3ADS";
$lang['highinterestthreads'] = "h19H Inter3sT THr34D\$";
$lang['subscribedthreads'] = "sUBsCriBED +hRE@d5";
$lang['currentinterest'] = "cUrr3nt 1n+er3S+";

// Browseable user profiles

$lang['youcanonlyaddthreecolumns'] = "j00 C@N 0NLy @DD 3 c0LUMN\$. to 4DD 4 N3w c0lumN CL0se 4N 3XIS+1Ng oN3";
$lang['columnalreadyadded'] = "j00 h@Ve @LRE4DY 4dDED +His C0lUMn. 1f J00 w4n+ to rEMOv3 It CL1ck i+\$ cl0sE 8utTON";

?>
