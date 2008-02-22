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

/* $Id: x-hacker.inc.php,v 1.269 2008-02-22 20:56:30 decoyduck Exp $ */

// British English language file

// Language character set and text direction options -------------------

$lang['_isocode'] = "en";
$lang['_textdir'] = "ltr";

// Months --------------------------------------------------------------

$lang['month'][1]  = "janU4Ry";
$lang['month'][2]  = "fe8Ru@Ry";
$lang['month'][3]  = "m4RCh";
$lang['month'][4]  = "apR1L";
$lang['month'][5]  = "m4y";
$lang['month'][6]  = "jun3";
$lang['month'][7]  = "jUlY";
$lang['month'][8]  = "au9u\$+";
$lang['month'][9]  = "s3p+3M83r";
$lang['month'][10] = "oCT083R";
$lang['month'][11] = "noVeM83r";
$lang['month'][12] = "dECeMBER";

$lang['month_short'][1]  = "jaN";
$lang['month_short'][2]  = "f38";
$lang['month_short'][3]  = "mar";
$lang['month_short'][4]  = "aPr";
$lang['month_short'][5]  = "m4Y";
$lang['month_short'][6]  = "jUN";
$lang['month_short'][7]  = "jul";
$lang['month_short'][8]  = "aU9";
$lang['month_short'][9]  = "s3P";
$lang['month_short'][10] = "oC+";
$lang['month_short'][11] = "nOV";
$lang['month_short'][12] = "deC";

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

$lang['date_periods']['year']   = "%s yE@R";
$lang['date_periods']['month']  = "%s M0Nth";
$lang['date_periods']['week']   = "%s WEek";
$lang['date_periods']['day']    = "%s DaY";
$lang['date_periods']['hour']   = "%s HoUR";
$lang['date_periods']['minute'] = "%s MiNu+e";
$lang['date_periods']['second'] = "%s s3CoNd";

// As above but plurals (2 years vs. 1 year, etc.)

$lang['date_periods_plural']['year']   = "%s Y34rs";
$lang['date_periods_plural']['month']  = "%s MONTh\$";
$lang['date_periods_plural']['week']   = "%s weEk\$";
$lang['date_periods_plural']['day']    = "%s D@y\$";
$lang['date_periods_plural']['hour']   = "%s HOuR\$";
$lang['date_periods_plural']['minute'] = "%s mInuTeS";
$lang['date_periods_plural']['second'] = "%s sEc0Nds";

// Short hand periods (example: 1y, 2m, 3w, 4d, 5hr, 6min, 7sec)

$lang['date_periods_short']['year']   = "%sy";    // 1y
$lang['date_periods_short']['month']  = "%sM";    // 2m
$lang['date_periods_short']['week']   = "%sw";    // 3w
$lang['date_periods_short']['day']    = "%sd";    // 4d
$lang['date_periods_short']['hour']   = "%shR";   // 5hr
$lang['date_periods_short']['minute'] = "%sm1N";  // 6min
$lang['date_periods_short']['second'] = "%ss3c";  // 7sec

// Common words --------------------------------------------------------

$lang['percent'] = "perC3N+";
$lang['average'] = "aveR4gE";
$lang['approve'] = "aPPrOVe";
$lang['banned'] = "b4NN3d";
$lang['locked'] = "l0cK3D";
$lang['add'] = "aDd";
$lang['advanced'] = "advAnC3D";
$lang['active'] = "actIve";
$lang['style'] = "sTYl3";
$lang['go'] = "gO";
$lang['folder'] = "f0LDeR";
$lang['ignoredfolder'] = "i9N0r3D pHOLd3R";
$lang['folders'] = "fold3R\$";
$lang['thread'] = "thRe4D";
$lang['threads'] = "thR34DS";
$lang['threadlist'] = "thr34D l1ST";
$lang['message'] = "m3ssa9E";
$lang['from'] = "frOM";
$lang['to'] = "to";
$lang['all_caps'] = "aLl";
$lang['of'] = "oph";
$lang['reply'] = "r3PlY";
$lang['forward'] = "fORWArd";
$lang['replyall'] = "repLy +0 aLl";
$lang['pm_reply'] = "r3PLY 45 pM";
$lang['delete'] = "d3lE+e";
$lang['deleted'] = "dELETeD";
$lang['edit'] = "edi+";
$lang['privileges'] = "priv1L3g3\$";
$lang['ignore'] = "i9N0R3";
$lang['normal'] = "n0RM4l";
$lang['interested'] = "iN+3r35+eD";
$lang['subscribe'] = "su8ScR183";
$lang['apply'] = "aPPLy";
$lang['download'] = "dOWnlOAd";
$lang['save'] = "s4vE";
$lang['update'] = "uPd4+e";
$lang['cancel'] = "cAnceL";
$lang['continue'] = "conTinU3";
$lang['attachment'] = "at+4Chm3N+";
$lang['attachments'] = "a++@ChMeNts";
$lang['imageattachments'] = "iM493 4++4CHM3nTS";
$lang['filename'] = "fIL3n4Me";
$lang['dimensions'] = "d1M3NS1onS";
$lang['downloadedxtimes'] = "doWnl04d3D: %d +1m3\$";
$lang['downloadedonetime'] = "doWnLo@D3D: 1 T1m3";
$lang['size'] = "sIZe";
$lang['viewmessage'] = "vi3W m35\$@g3";
$lang['deletethumbnails'] = "d3LET3 ThUm8N4Ils";
$lang['logon'] = "lOG0N";
$lang['more'] = "m0r3";
$lang['recentvisitors'] = "r3cent v1s1torS";
$lang['username'] = "u\$3Rn@m3";
$lang['clear'] = "clE@r";
$lang['action'] = "acTIoN";
$lang['unknown'] = "uNKN0wn";
$lang['none'] = "nON3";
$lang['preview'] = "pR3V1eW";
$lang['post'] = "p0St";
$lang['posts'] = "p0sTs";
$lang['change'] = "ch4nGe";
$lang['yes'] = "yes";
$lang['no'] = "no";
$lang['signature'] = "sIGn@tUre";
$lang['signaturepreview'] = "s1gn4+Ur3 pReVI3W";
$lang['signatureupdated'] = "si9N4Tur3 upD4Ted";
$lang['signatureupdatedforallforums'] = "s1gn4+UR3 uPd4+Ed PhOr 4lL F0RuMs";
$lang['back'] = "b4Ck";
$lang['subject'] = "subJ3cT";
$lang['close'] = "cLOSe";
$lang['name'] = "n@ME";
$lang['description'] = "d3sCRip+1on";
$lang['date'] = "d4T3";
$lang['view'] = "v1EW";
$lang['enterpasswd'] = "eNTeR PaS\$wORd";
$lang['passwd'] = "p@\$5w0Rd";
$lang['ignored'] = "ignORed";
$lang['guest'] = "gUES+";
$lang['next'] = "n3x+";
$lang['prev'] = "pR3V10U5";
$lang['others'] = "o+h3R\$";
$lang['nickname'] = "n1CkN@M3";
$lang['emailaddress'] = "em41L ADdR355";
$lang['confirm'] = "conPH1rM";
$lang['email'] = "em41L";
$lang['poll'] = "poLl";
$lang['friend'] = "fR1End";
$lang['success'] = "suCcEs\$";
$lang['error'] = "erROr";
$lang['warning'] = "w4RnIng";
$lang['guesterror'] = "s0Rry, j00 nEEd t0 8e l09Ged 1N To uS3 +hIs pH34tuRe.";
$lang['loginnow'] = "l09IN n0w";
$lang['unread'] = "uNRE4d";
$lang['all'] = "aLl";
$lang['allcaps'] = "aLL";
$lang['permissions'] = "p3rMi\$5I0nS";
$lang['type'] = "typ3";
$lang['print'] = "pR1Nt";
$lang['sticky'] = "s+IcKy";
$lang['polls'] = "p0Lls";
$lang['user'] = "uS3R";
$lang['enabled'] = "en4blEd";
$lang['disabled'] = "d1s4Bl3D";
$lang['options'] = "oP+iONS";
$lang['emoticons'] = "emOTiC0Ns";
$lang['webtag'] = "w38+aG";
$lang['makedefault'] = "mak3 d3Ph4uL+";
$lang['unsetdefault'] = "uNsE+ d3Ph4uLT";
$lang['rename'] = "rEN4m3";
$lang['pages'] = "p@9E\$";
$lang['used'] = "us3D";
$lang['days'] = "d@Y\$";
$lang['usage'] = "u5@93";
$lang['show'] = "sHOW";
$lang['hint'] = "h1N+";
$lang['new'] = "nEW";
$lang['referer'] = "r3PHeR3R";
$lang['thefollowingerrorswereencountered'] = "th3 pHolLOW1Ng 3rROrS W3re 3nC0Unt3r3d:";

// Admin interface (admin*.php) ----------------------------------------

$lang['admintools'] = "admIN +0OL\$";
$lang['forummanagement'] = "fORum mAn@93mENt";
$lang['accessdeniedexp'] = "j00 Do n0T H4ve Perm1SSI0N +0 U\$3 th1\$ S3C+10N.";
$lang['managefolders'] = "m4N4G3 f0LDeRS";
$lang['manageforums'] = "m4N4Ge PhoRUM\$";
$lang['manageforumpermissions'] = "m4N493 f0Rum P3Rm1\$\$I0n5";
$lang['foldername'] = "foLder n@m3";
$lang['move'] = "mOvE";
$lang['closed'] = "cl0\$3d";
$lang['open'] = "open";
$lang['restricted'] = "rES+RIcTed";
$lang['forumiscurrentlyclosed'] = "%s 15 CuRr3NtLy CL0s3d";
$lang['youdonothaveaccesstoforum'] = "j00 d0 n0T h4V3 4Cce\$5 TO %s";
$lang['toapplyforaccessplease'] = "to 4PpLy F0R 4cC3S5 Pl345E C0N+4cT +hE phORuM 0Wn3R.";
$lang['adminforumclosedtip'] = "iF j00 w@nt +0 ch@n9e \$0Me Se++In9\$ 0N yoUR F0RuM cLiCk t3h @dmiN L1nK 1N The n@vIg4tI0n b4r 4B0v3.";
$lang['newfolder'] = "nEW PhOlD3r";
$lang['nofoldersfound'] = "n0 3X1s+1n9 f0LdErS PhoUNd. +0 4dD 4 fOlDeR cl1cK Th3 '4dD nEw' Bu++0n bEloW.";
$lang['forumadmin'] = "foRUm 4DmIN";
$lang['adminexp_1'] = "use Th3 mEnU 0n +HE L3ph+ +0 M@N49e TH1Ng\$ iN Y0uR Ph0RuM.";
$lang['adminexp_2'] = "<b>u\$3R\$</b> 4Ll0WS J00 to sE+ 1nD1v1Du4l U\$3r p3rm1S510n\$, 1NcLuD1n9 4pP0In+InG m0DeR@TOr5 @nD 9@9GiNg pEoplE.";
$lang['adminexp_3'] = "<b>u\$3R 9R0ups</b> 4lL0WS j00 +o cR34+E User GrOuP\$ t0 aS\$1Gn p3rmi\$\$I0N5 tO 4\$ M@nY Or 4\$ Ph3w U5eR5 quIcklY 4ND E4\$1Ly.";
$lang['adminexp_4'] = "<b>b4n C0nTR0L\$</b> 4Ll0Ws tH3 b@nnINg 4nD uN-84nN1ng 0F 1P @dDRe\$5Es, H++P rEpH3r3R\$, U\$eRN@M3S, 3m41L 4ddRe\$5ES 4Nd nIcKN4MEs.";
$lang['adminexp_5'] = "<b>fOLder\$</b> @Ll0wS tH3 crE4+1oN, MODiFicat10N 4ND Del3+I0N 0F foLd3R\$.";
$lang['adminexp_6'] = "<b>rSS FEedS</b> 4LLow\$ J00 tO M@n4gE r5S Ph3Ed\$ fOR PR0P4G4+iOn 1n+0 yOUr pHoRuM.";
$lang['adminexp_7'] = "<b>pr0Ph1l35</b> l3Ts j00 cU\$+0M1Se T3h 1tEm5 THaT 4pP34r iN ThE U\$3R pR0Ph1LeS.";
$lang['adminexp_8'] = "<b>forUm 53++1n9\$</b> @lL0ws j00 To cUs+0m1Se y0Ur PhOrUm'\$ N4M3, 4ppe4r4nCe 4nD m4Ny 0TH3r Th1nGs.";
$lang['adminexp_9'] = "<b>s+@Rt p4ge</b> LE+S j00 CuS+0MisE Y0uR PhOrUm'S St4Rt p4g3.";
$lang['adminexp_10'] = "<b>f0rUM \$+yL3</b> @LlOws J00 +O 9En3R@te r@NdOm s+yLe\$ FoR yOur PhoRuM MEm83Rs t0 uS3.";
$lang['adminexp_11'] = "<b>worD ph1L+3r</b> ALl0w\$ j00 To Ph1L+3R wOrDs J00 d0N'+ w@nt +0 b3 useD 0N Y0uR F0rUm.";
$lang['adminexp_12'] = "<b>pOSt1Ng s+4ts</b> 9EnEr@t3\$ @ RepOr+ LiS+1N9 th3 Top 10 PO\$+Ers in 4 DeFiNeD Per1OD.";
$lang['adminexp_13'] = "<b>f0RUm LInK\$</b> lEtS J00 man4Ge +He L1Nk5 dr0PdOWN 1n tEh n4vIG@+10n b4R.";
$lang['adminexp_14'] = "<b>v1EW L0g</b> l1\$+5 reCent 4C+I0nS 8Y +h3 pHoRum m0d3R@+0RS.";
$lang['adminexp_15'] = "<b>m4n49E phorUM\$</b> l3TS j00 crE4+3 4nd D3L3+E @nD cL0Se OR R30pEn Ph0RuM\$.";
$lang['adminexp_16'] = "<b>gL0B4l PHorUm SetT1ngS</b> 4lL0W5 j00 To m0d1FY \$e++ingS WH1cH @ff3c+ 4Ll FoRuM\$.";
$lang['adminexp_17'] = "<b>p0S+ @pPrOv4L Qu3U3</b> 4Ll0WS j00 to v13W @NY p0S+5 @W@1+InG 4PpR0v4l 8y a m0D3r4tOr.";
$lang['adminexp_18'] = "<b>v1SItOr lO9</b> @Ll0W5 J00 +o VI3w aN 3x+eNd3D Li\$+ oF vI\$I+OrS inCludIn9 thE1r hTtP ReF3reR5.";
$lang['createforumstyle'] = "crEAte 4 fOrum s+yLe";
$lang['newstylesuccessfullycreated'] = "new \$+Yl3 sUcC3s5PhUlLY cRE4+eD.";
$lang['stylealreadyexists'] = "a sTYle w1th +h4T pH1L3n@m3 @LR3aDy ex1\$+\$.";
$lang['stylenofilename'] = "j00 d1D NOt EnT3r 4 FIl3n4M3 To 54ve t3h S+YlE W1+h.";
$lang['stylenodatasubmitted'] = "cOUlD n0+ r34D FOrUm \$TylE d@t@.";
$lang['styleexp'] = "uS3 +hIS p49E To h3Lp CRe4+E @ r4NdOMly Gen3r@t3D 5+yLe fOr yOUR Ph0ruM.";
$lang['stylecontrols'] = "c0NTr0Ls";
$lang['stylecolourexp'] = "cl1CK 0n a cOl0Ur tO m4Ke 4 NEW s+Yl3 She3t 84Sed On Th4+ c0LoUr. cuRr3Nt B4\$3 C0L0uR 1S FIr5+ iN l1ST.";
$lang['standardstyle'] = "sT4Nd4Rd \$+yLe";
$lang['rotelementstyle'] = "ro+@+3D El3m3Nt stYle";
$lang['randstyle'] = "r4nD0m \$+Yl3";
$lang['thiscolour'] = "tH15 C0L0Ur";
$lang['enterhexcolour'] = "or 3nTeR 4 H3x cOl0Ur T0 b4Se 4 neW \$+yl3 sH33+ 0N";
$lang['savestyle'] = "s4V3 +hI5 S+yL3";
$lang['styledesc'] = "s+yle DeSCr1pT10n";
$lang['stylefilenamemayonlycontain'] = "stylE pHil3N4mE m4Y 0nLY c0NtAiN LoW3rC4s3 l3tT3R5 (4-z), NuM8eRs (0-9) 4ND uNd3rScor3.";
$lang['stylepreview'] = "stYl3 pR3vIeW";
$lang['welcome'] = "w3LcomE";
$lang['messagepreview'] = "mes54gE PrEvI3w";
$lang['users'] = "u5ers";
$lang['usergroups'] = "useR 9RoUPs";
$lang['mustentergroupname'] = "j00 MuSt enT3R 4 Gr0Up n@M3";
$lang['profiles'] = "pR0phil3S";
$lang['manageforums'] = "m4N4Ge PHoRuM\$";
$lang['forumsettings'] = "fORuM S3tt1n9\$";
$lang['globalforumsettings'] = "gL0B4l PhOrUm \$e++INg5";
$lang['settingsaffectallforumswarning'] = "<b>no+E:</b> Th3\$E SE++In95 @fPh3CT 4ll forUmS. wHeR3 THe sE+T1Ng 1S duPl1C4+ed 0n +Eh 1nD1vIdU4l pH0rUm's \$E+TiN9\$ P4gE Th4T W1ll +@ke Pr3cED3nce Ov3r +He sEtt1N9\$ j00 Ch4NGe H3r3.";
$lang['startpage'] = "s+4rT P4gE";
$lang['startpageerror'] = "your S+4RT p@gE C0uLD n0T Be s4VeD LOc@lly +o tHe \$ERV3r 83C4u\$e pErM1\$51On w4S D3n13D.</p><p>tO ch4n9E yOur St4R+ P4ge pL34Se cLick Th3 DOwNl0@d BUtT0n BEL0W WhiCH w1Ll PROmpT J00 To s@v3 TH3 Ph1Le to yOUr h@rD dr1v3. J00 C4N +H3N Upl0@d +h1S PhIl3 +0 y0Ur sErV3r 1Nt0 +Eh PholL0wIn9 PH0Ld3R, If n3C3\$\$4rY CrE4+1Ng tH3 PhOLD3R 5+ruC+Ure In +hE Pr0CeSs.</p><p><b>%s</b></p><p>pLe4\$3 n0t3 +h4+ s0m3 8rOWsErS M@y cH4NGe tH3 n@m3 Of ThE FIl3 Upon DOwNLO@D. wH3n uPl04dIn9 th3 Fil3 pl34\$3 M4k3 SuR3 tH4+ iT 1S N4MEd \$+@rT_m4IN.pHP 0+H3rwI\$3 Y0Ur \$+4R+ p4GE wILl 4PPe@r UnCH4NgED.";
$lang['failedtoopenmasterstylesheet'] = "yOUr F0rUm 5+Yl3 Could n0t 83 s@V3d 83cAuSe t3h m4\$+eR \$+YlE sH3e+ c0UlD N0T bE loAdEd. +o s4Ve y0ur \$+yLE tHe ma5TEr \$tylE \$hE3T (m4Ke_5+Yle.C\$S) MuS+ bE LoC4+Ed 1n +Eh 5+YlE\$ diREcToRy 0Ph Y0Ur 833HiVe pHorum 1nS+@Ll4T10n.";
$lang['makestyleerror'] = "yOUR FOrUm STyle c0UlD n0T B3 sAv3D LoC4llY To tHe sErV3r bEc4UsE PeRmIsSiON w4\$ dENieD.</p><p>tO 54vE Y0Ur PHoRuM 5+YlE Pl34Se cLicK +h3 dOwnLO4d buttOn 8EloW whIcH WiLl PR0Mp+ J00 To s@v3 t3H Ph1l3 tO YOur h@rd Dr1v3. j00 CaN +h3N Upl0Ad +hIS pH1L3 To yoUr SerV3R Into +eH phOLlOwin9 f0LD3r, iF nEC3\$54rY CrE4+InG ThE PhOLdeR sTructUr3 In +hE pr0CeS\$.</p><p><b>%s</b></p><p>pLe4\$e nO+3 +h4+ S0m3 8rowSeR\$ m@y ch4n93 t3h n@mE 0F Th3 ph1l3 up0N D0Wnl04D. wh3N UpL04d1Ng thE F1lE Pl3@\$E m4KE suR3 th4+ 1t IS n4M3D \$+yLE.c\$5 0+HErWi5E +H3 forUM 5+YLE W1ll 83 UnAV4iL@bL3.";
$lang['forumstyle'] = "f0rUM s+yLe";
$lang['wordfilter'] = "wORd PhiL+Er";
$lang['forumlinks'] = "f0rUm lInKS";
$lang['viewlog'] = "v13W L09";
$lang['noprofilesectionspecified'] = "nO pRoPh1L3 s3C+1On \$PeC1FiEd.";
$lang['itemname'] = "i+3M N4ME";
$lang['moveto'] = "moVe To";
$lang['manageprofilesections'] = "mAN4gE PrOpH1l3 \$eCt1Ons";
$lang['sectionname'] = "sECt1ON N4ME";
$lang['items'] = "iTEm\$";
$lang['mustspecifyaprofilesectionid'] = "mU5+ \$p3CiPhY 4 PrOfIl3 seCt10N 1d";
$lang['mustsepecifyaprofilesectionname'] = "mus+ 5PeC1phY @ Pr0PH1L3 \$EC+10N n4Me";
$lang['noprofilesectionsfound'] = "nO 3X1s+1N9 pR0fIl3 sEct1Ons PhOuNd. +0 4dD 4 pr0Ph1L3 SEc+1oN ClIcK Th3 '4Dd N3W' buTT0n beLOw.";
$lang['addnewprofilesection'] = "adD n3w pRoF1l3 Sec+10n";
$lang['successfullyaddedprofilesection'] = "sUCcEs5Fully 4dD3d pR0pH1L3 seCt10n";
$lang['successfullyeditedprofilesection'] = "sUCce\$\$fUlLy eD1+ed Pr0FIl3 SeCt1On";
$lang['addnewprofilesection'] = "add n3w pRoPh1L3 \$3C+1On";
$lang['mustsepecifyaprofilesectionname'] = "mUSt \$P3CIFy 4 Prof1l3 SEct1On n4mE";
$lang['successfullyremovedselectedprofilesections'] = "sUCc3S\$fuLLy REm0v3D sel3C+ED Proph1L3 \$ect10nS";
$lang['failedtoremoveprofilesections'] = "f4il3d +O reMoV3 PrOf1L3 SeC+10Ns";
$lang['viewitems'] = "vI3W 1+eMs";
$lang['successfullyaddednewprofileitem'] = "suCcES\$PhUlLy 4DDeD new proFIlE It3M";
$lang['successfullyeditedprofileitem'] = "sucCEsSfulLY eD1+Ed proFilE it3M";
$lang['successfullyremovedselectedprofileitems'] = "succE5\$fUlly r3mOvED 5eL3C+3D Pr0FiLe it3ms";
$lang['failedtoremoveprofileitems'] = "f@il3D To remOVe profIl3 1t3M\$";
$lang['noexistingprofileitemsfound'] = "th3R3 @R3 n0 eX1S+InG pr0FilE it3M\$ in Th15 secT10n. +0 AdD 4n 1t3M ClIcK Th3 '4Dd n3W' bU++0n BeL0W.";
$lang['edititem'] = "eDI+ item";
$lang['invalidprofilesectionid'] = "iNVaLiD pR0pH1lE SeCt10N Id 0r SecT10N nO+ fOuNd";
$lang['invalidprofileitemid'] = "iNv4l1d prOpHilE It3m 1d 0r 1+Em NOt PH0Und";
$lang['addnewitem'] = "aDD NeW 1t3m";
$lang['youmustenteraprofileitemname'] = "j00 mUs+ 3nT3r 4 pR0pH1lE 1+3m n@mE";
$lang['invalidprofileitemtype'] = "inv@LiD PrOfIlE It3m tYp3 sEl3cT3d";
$lang['youmustenteroptionsforselectedprofileitemtype'] = "j00 Mu5t 3nT3r \$OMe OP+1OnS Phor \$El3Ct3d pRoph1L3 1+Em +Yp3";
$lang['youmustentermorethanoneoptionforitem'] = "j00 mUs+ enTeR moR3 TH4N On3 oP+1On phor \$el3c+Ed prOF1l3 1+em Typ3";
$lang['profileitemhyperlinkssupportshttpurlsonly'] = "pROpHil3 1T3m hYp3rl1nK5 \$uPp0Rt h++P url\$ ONly";
$lang['profileitemhyperlinkformatinvalid'] = "pR0f1lE i+3m HYpErL1nk phORm4+ 1nV4l1d";
$lang['youmustincludeprofileentryinhyperlinks'] = "j00 mUS+ 1nClUd3 <i>%s</i> iN thE url of CliCK4BL3 hYPerLInkS";
$lang['failedtocreatenewprofileitem'] = "f4Il3D +0 cr34+E N3W pRoPh1l3 1t3M";
$lang['failedtoupdateprofileitem'] = "f@1LeD T0 uPd@+3 pr0pHiLE 1+Em";
$lang['startpageupdated'] = "st@r+ P@93 upD4t3D. %s";
$lang['viewupdatedstartpage'] = "vieW UpD4tEd 5+4rt p@9e";
$lang['editstartpage'] = "eDit St@r+ P4gE";
$lang['nouserspecified'] = "nO uSeR 5Pec1Fi3D.";
$lang['manageuser'] = "m4N@93 uSEr";
$lang['manageusers'] = "m@N4Ge U\$ers";
$lang['userstatusforforum'] = "u5eR st4Tu\$ f0R %s";
$lang['userdetails'] = "u\$er dEt@1lS";
$lang['warning_caps'] = "w4RN1n9";
$lang['userdeleteallpostswarning'] = "ar3 j00 sUR3 j00 WAnT +0 D3L3+3 4Ll 0pH TeH 5EL3Ct3d u\$Er'S p05+5? 0NcE +he P0s+\$ @Re DeLeT3d tH3y c@nN0T bE re+Ri3vED @nD wIlL bE l0\$T pHoR3v3r.";
$lang['postssuccessfullydeleted'] = "pO\$+5 W3rE 5UcCeS5fUlLy d3L3TeD.";
$lang['folderaccess'] = "f0LdER 4cC35S";
$lang['possiblealiases'] = "p0\$S18L3 4lI@ses";
$lang['userhistory'] = "u\$ER H1S+OrY";
$lang['nohistory'] = "n0 H1s+0rY R3cOrD\$ \$@VEd";
$lang['userhistorychanges'] = "ch4NgES";
$lang['clearuserhistory'] = "cl3AR Us3r hIs+0Ry";
$lang['changedlogonfromto'] = "cH4N9Ed L0goN pHRoM %s t0 %s";
$lang['changednicknamefromto'] = "cH4N93D NiCkn@Me PhroM %s To %s";
$lang['changedemailfromto'] = "cH@N9Ed 3m@iL FRom %s +0 %s";
$lang['successfullycleareduserhistory'] = "sucCe\$5FuLly cL3@ReD U5er H1sTOry";
$lang['failedtoclearuserhistory'] = "f41L3D to cL34r uS3r hIsTOry";
$lang['successfullychangedpassword'] = "suCCEs\$pHully cH4N93D p4S5w0Rd";
$lang['failedtochangepasswd'] = "f4Il3D +0 Chang3 p4SSw0rd";
$lang['viewuserhistory'] = "vI3W User hIs+0rY";
$lang['viewuseraliases'] = "v1eW uSEr @L1@Se\$";
$lang['searchreturnednoresults'] = "s34rCh R3+uRned N0 rE\$Ul+S";
$lang['deleteposts'] = "dELe+e P0S+\$";
$lang['deleteuser'] = "dELe+3 U5eR";
$lang['alsodeleteusercontent'] = "aLSO dEl3Te @Ll 0Ph tHe C0Nt3NT cR34tEd BY +his USEr";
$lang['userdeletewarning'] = "ar3 j00 SuR3 j00 W4n+ +o d3l3TE T3h SeL3c+ed U\$Er 4ccOun+? 0NcE T3H @ccoUn+ HAs 833n D3L3TEd 1+ C@Nn0T 83 rE+Riev3d 4nD wIll 8E l0\$T F0r3VeR.";
$lang['usersuccessfullydeleted'] = "uSEr SuCCe\$\$fuLlY D3l3+3D";
$lang['failedtodeleteuser'] = "f4IL3D tO D3le+e uSeR";
$lang['forgottenpassworddesc'] = "iF th1S UsEr h4S F0RGOTt3N +hEir P4s5w0Rd J00 c@n ReSeT 1T F0r th3m Her3.";
$lang['failedtoupdateuserstatus'] = "f@il3d tO UPd4+E usEr \$T@tU5";
$lang['failedtoupdateglobaluserpermissions'] = "f@IleD T0 UPdaTe 9l0bAL uSEr p3Rm1SSiOn5";
$lang['failedtoupdatefolderaccesssettings'] = "f41L3d To uPdaTe pH0ld3r AccE\$\$ 5EttIn9\$";
$lang['manageusersexp'] = "th1s li\$t Sh0w5 @ sEL3ct10n OpH U5er\$ Who H@V3 L09GEd 0N to y0Ur PHOrum, \$0r+Ed 8Y %s. +0 4lt3r 4 UsEr's perm1\$\$I0n5 ClIcK th31R N@m3.";
$lang['userfilter'] = "u\$3R pHIl+3r";
$lang['onlineusers'] = "onL1NE u\$ERs";
$lang['offlineusers'] = "oFPhLin3 uSErS";
$lang['usersawaitingapproval'] = "u5ER\$ @w41+1n9 aPpROv4L";
$lang['bannedusers'] = "b4nNeD UsERs";
$lang['lastlogon'] = "l4S+ l090n";
$lang['sessionreferer'] = "s3s5IOn rEfEr3R";
$lang['signupreferer'] = "sIgn-up ref3r3R:";
$lang['nouseraccountsmatchingfilter'] = "no usEr 4Cc0uNts m@+CHin9 pHilt3r";
$lang['searchforusernotinlist'] = "s34rch phOR @ U\$eR N0+ iN liSt";
$lang['adminaccesslog'] = "aDM1n @Cc3\$5 lO9";
$lang['adminlogexp'] = "tHIs l1\$T Sh0W5 t3H L4\$+ @c+1OnS s4nCt1On3D 8Y Us3rs w1Th 4dm1n Pr1V1l3g3S.";
$lang['datetime'] = "dA+e/+1M3";
$lang['unknownuser'] = "unkN0wN UsER";
$lang['unknownuseraccount'] = "uNKNoWn u\$Er 4cC0uNt";
$lang['unknownfolder'] = "uNKN0wn phOLDeR";
$lang['ip'] = "ip";
$lang['lastipaddress'] = "l4s+ ip 4DDr3\$\$";
$lang['hostname'] = "h0\$+n4me";
$lang['unknownhostname'] = "unKn0wn h0S+n@ME";
$lang['logged'] = "lo99ED";
$lang['notlogged'] = "no+ l099ed";
$lang['addwordfilter'] = "adD WOrD FiL+Er";
$lang['addnewwordfilter'] = "adD n3W w0Rd fIl+3r";
$lang['wordfilterupdated'] = "wORd fiL+Er uPDAtEd";
$lang['wordfilterisfull'] = "j00 c@nNoT @dD 4NY m0r3 wOrD FIL+3RS. REm0vE \$0m3 unuS3d On35 Or eD1t +3h 3xis+1N9 0N3\$ fIr\$+.";
$lang['filtername'] = "f1L+3R N4mE";
$lang['filtertype'] = "fiL+er +ypE";
$lang['filterenabled'] = "fIl+eR 3N@8l3D";
$lang['editwordfilter'] = "ed1t w0RD FiLtEr";
$lang['nowordfilterentriesfound'] = "nO 3Xi\$+1nG woRd f1Lt3r eN+R1E\$ FouND. +0 4DD @ ph1lT3R clIcK +H3 'aDD new' bU++0N BeLOw.";
$lang['mustspecifyfiltername'] = "j00 MuST Spec1Fy 4 fiL+3R N4M3";
$lang['mustspecifymatchedtext'] = "j00 Mu\$t \$P3c1Fy m4+Ch3D T3XT";
$lang['mustspecifyfilteroption'] = "j00 muS+ SPeC1Fy 4 PhIL+eR 0P+10n";
$lang['mustspecifyfilterid'] = "j00 mUS+ sp3C1fY 4 pHiL+Er 1d";
$lang['invalidfilterid'] = "iNv4L1d pH1Lt3R 1D";
$lang['failedtoupdatewordfilter'] = "fail3D tO UpD4+E WOrd FiL+er. cHEcK +h4T +3H PhIltER 5+ilL 3X1S+\$.";
$lang['allow'] = "aLL0w";
$lang['block'] = "bL0Ck";
$lang['normalthreadsonly'] = "n0RM4l +hr3@Ds 0nly";
$lang['pollthreadsonly'] = "pOlL tHrE4D\$ Only";
$lang['both'] = "bo+H thR34D +yP3S";
$lang['existingpermissions'] = "eXI\$+iNg peRM1s\$i0nS";
$lang['nousershavebeengrantedpermission'] = "n0 EX1s+1n9 u5ERs p3Rm1\$\$10nS pHoUnD. t0 9r4nT peRm1S5i0N To uSers s3@RCH Ph0R tH3M BeL0w.";
$lang['successfullyaddedpermissionsforselectedusers'] = "sUCcES5fUlLy 4ddED pErM1s\$1ON5 pHor \$El3Ct3D Us3Rs";
$lang['successfullyremovedpermissionsfromselectedusers'] = "sUcCE\$5Fully r3MOv3D perm1S5I0NS PHR0M s3L3ctEd u53rS";
$lang['failedtoaddpermissionsforuser'] = "f41L3D +O 4Dd p3rm1S\$10ns phOR Us3R '%s'";
$lang['failedtoremovepermissionsfromuser'] = "f4IlED +0 remoV3 pERmissi0Ns fRom u\$ER '%s'";
$lang['searchforuser'] = "s34RCh phoR u\$Er";
$lang['browsernegotiation'] = "bRow\$eR nE90+I@+eD";
$lang['largetextfield'] = "lArgE +3X+ pHiEld";
$lang['mediumtextfield'] = "med1um +Ex+ F1eld";
$lang['smalltextfield'] = "sm@ll +Ex+ PH13lD";
$lang['multilinetextfield'] = "mULt1-Line +EX+ ph13Ld";
$lang['radiobuttons'] = "r4DiO bU+T0n\$";
$lang['dropdownlist'] = "dr0P d0wn liST";
$lang['clickablehyperlink'] = "clIck4Bl3 HypErL1Nk";
$lang['threadcount'] = "tHre4D cOUnT";
$lang['clicktoeditfolder'] = "cLIcK +0 eD1T pHoLD3r";
$lang['fieldtypeexample1'] = "tO cRE4+E r4D10 8UtToNS 0r @ dRoP DoWn LIsT J00 N33D To EN+Er eACh 1NDiV1DuaL v4Lu3 oN 4 sEp@r4+e l1Ne in +He 0Pt1oNs PH1ElD.";
$lang['fieldtypeexample2'] = "t0 Cre4+e cLiCk4bl3 l1nKs 3n+3R t3h UrL in +hE Op+I0Ns ph13Ld 4nD U5E <i>%1\$s</i> Wh3R3 t3H 3ntRy phr0M +EH UsEr'S pROPhIlE \$hoUld @Pp34R. eX@mpL35: <p>mYSpaC3: <i>hTtp://Www.mY\$p@c3.cOm/%1\$5</i><br />x80X LiV3: <i>hTtP://Pr0PhIl3.MyG4MerC4rd.NeT/%1\$S</i>";
$lang['editedwordfilter'] = "eD1T3d wOrD pHIltER";
$lang['editedforumsettings'] = "eDiT3d phorUm Se+TiN9s";
$lang['successfullyendedusersessionsforselectedusers'] = "sUCCeS\$PhUlLy 3ND3d Ses51On\$ PH0R \$eL3ct3D u5ErS";
$lang['failedtoendsessionforuser'] = "f@IlEd tO enD s3S510N PhOr uSeR %s";
$lang['successfullyapprovedselectedusers'] = "sucCes5FuLlY 4Pprov3d SeL3cTed UsER5";
$lang['matchedtext'] = "mA+Ch3D t3Xt";
$lang['replacementtext'] = "rEPl4CEM3n+ t3X+";
$lang['preg'] = "pr3g";
$lang['wholeword'] = "whOL3 wORd";
$lang['word_filter_help_1'] = "<b>all</b> m@tchE\$ 4g4iNsT +h3 Wh0Le T3Xt s0 fIlt3R1n9 mOm +0 MUm wiLl aLs0 CH4NgE M0m3nT +0 MuMeN+.";
$lang['word_filter_help_2'] = "<b>wHOL3 wORd</b> M@+cHeS Ag4iNS+ wh0L3 W0rD\$ ONlY So Ph1l+er1n9 MOm tO mUm wilL NoT cH@N9E m0m3Nt +0 MuM3n+.";
$lang['word_filter_help_3'] = "<b>pR3g</b> @lL0Ws j00 tO Us3 p3rL reGuL4R 3XpR3s51On5 TO m4+ch +3Xt.";
$lang['nameanddesc'] = "nAMe @nd De\$Cr1PT1ON";
$lang['movethreads'] = "m0V3 +hre4D\$";
$lang['movethreadstofolder'] = "moV3 tHRe4Ds +0 f0lDeR";
$lang['failedtomovethreads'] = "f4ILEd To m0V3 ThR3ads t0 Sp3c1FI3d fOlDEr";
$lang['resetuserpermissions'] = "r3s3+ USeR P3rMiS\$1ONs";
$lang['failedtoresetuserpermissions'] = "f4il3D To ReS3t u\$ER P3rm1\$\$i0N5";
$lang['allowfoldertocontain'] = "alLOw fOLd3r +0 cOnT@1n";
$lang['addnewfolder'] = "aDD n3w fOLd3R";
$lang['mustenterfoldername'] = "j00 MuS+ eNt3R 4 FolDEr n4Me";
$lang['nofolderidspecified'] = "n0 PHOlDeR 1d Sp3c1Fi3D";
$lang['invalidfolderid'] = "iNV4liD f0Lder id. ch3cK +h4t @ fOld3R wITH Th1S iD EX1s+s!";
$lang['successfullyaddednewfolder'] = "suCcES5FuLly aDd3D neW Ph0ldeR";
$lang['successfullyremovedselectedfolders'] = "succEs5FuLlY r3M0v3D sel3Ct3D F0ldeRs";
$lang['successfullyeditedfolder'] = "succEs5fully EDi+eD F0LDer";
$lang['failedtocreatenewfolder'] = "f41L3d To cRe4+E NeW PhOlDeR";
$lang['failedtodeletefolder'] = "f@iLeD +0 DelET3 f0LdEr.";
$lang['failedtoupdatefolder'] = "f@IlED T0 upd4+E fOlDer";
$lang['cannotdeletefolderwiththreads'] = "c@Nn0T DeL3tE PH0LdErS TH4t \$+iLL c0N+41n tHre4DS.";
$lang['forumisnotrestricted'] = "f0RuM IS n0+ rE\$TriCT3D";
$lang['groups'] = "gR0UpS";
$lang['nousergroups'] = "n0 USEr 9rOUpS H4ve bEeN 53T Up. To 4Dd @ 9r0Up cLiCk T3H '4Dd NEw' 8UtToN BeLoW.";
$lang['suppliedgidisnotausergroup'] = "sUpPlI3d 9id 1S NoT A Us3R 9rOuP";
$lang['manageusergroups'] = "mAN4G3 USer 9rOup5";
$lang['groupstatus'] = "gr0uP \$T4+u\$";
$lang['addusergroup'] = "add uSeR 9roUp";
$lang['addemptygroup'] = "add EmPtY GR0uP";
$lang['adduserstogroup'] = "aDD uSErS to gROuP";
$lang['addremoveusers'] = "aDD/r3M0vE UsER5";
$lang['nousersingroup'] = "tHEr3 @Re nO Us3Rs in +hiS 9rOUp. 4Dd uS3rs tO +Hi\$ 9r0Up 8Y S34RcH1N9 FoR tH3m 8El0W.";
$lang['groupaddedaddnewuser'] = "suCc3\$5FuLlY 4Dd3D Gr0Up. @dD u\$ERs tO +His 9RoUp bY Se@RChIN9 pHoR th3M 83lOW.";
$lang['nousersingroupaddusers'] = "tH3re 4R3 nO U\$3rS iN Th1\$ GroUP. TO 4Dd uSeRs Cl1cK +he '4dD/Rem0V3 u\$3rS' bUtT0N bElow.";
$lang['useringroups'] = "tH1\$ USer i\$ @ MeMber 0Ph +He pH0Ll0W1n9 9RoupS";
$lang['usernotinanygroups'] = "thIS U5eR 1S NOT In @Ny u\$eR 9roUp5";
$lang['usergroupwarning'] = "nO+e: +HI\$ uS3R M4y B3 INH3RiTin9 4dD1t10n4L p3RmIS5IoNs fR0m 4ny U\$eR GrOUps L1sTeD 8ELoW.";
$lang['successfullyaddedgroup'] = "sUcCe\$\$FuLlY 4Dd3d 9r0Up";
$lang['successfullyeditedgroup'] = "sucCESsFully ediT3D 9r0Up";
$lang['successfullydeletedselectedgroups'] = "sUcC3S\$PhULly dEl3Ted SEl3cT3d gR0uPS";
$lang['failedtodeletegroupname'] = "f@1Led +0 D3LE+E 9ROup %s";
$lang['usercanaccessforumtools'] = "u\$Er c@n 4cC3ss pH0rUm t00lS @nd cAn cR34t3, d3L3t3 ANd 3Dit F0rUm5";
$lang['usercanmodallfoldersonallforums'] = "uSEr c4n mODeRAtE <b>aLL FoLD3rS</b> oN <b>aLl pH0rUM\$</b>";
$lang['usercanmodlinkssectiononallforums'] = "u\$eR C4n mOd3r4+E l1NkS SeCT1On 0n <b>aLl PhoRum\$</b>";
$lang['emailconfirmationrequired'] = "eMaIl conFiRm4+IOn r3Qu1R3D";
$lang['userisbannedfromallforums'] = "u5er 1S 84NnEd phr0M <b>aLL Ph0RuM\$</b>";
$lang['cancelemailconfirmation'] = "c@Nc3L 3M41L cOnFIrmATi0N 4Nd 4Ll0W UsER +0 s+4R+ pOs+1N9";
$lang['resendconfirmationemail'] = "rES3Nd cOnPh1rM@t1On 3M41l tO u5Er";
$lang['failedtosresendemailconfirmation'] = "f41LED To ResEnD 3M@1L C0NphIrM4+IOn T0 U\$Er.";
$lang['donothing'] = "dO NoTh1N9";
$lang['usercanaccessadmintools'] = "u5er h4\$ 4CcEs\$ +0 FORuM @DmIN t0OlS";
$lang['usercanaccessadmintoolsonallforums'] = "u\$3r h@s acC3s5 TO 4DM1n +0oL5 <b>on @Ll f0RUms</b>";
$lang['usercanmoderateallfolders'] = "user c4n M0D3rate 4LL pH0ld3rS";
$lang['usercanmoderatelinkssection'] = "uS3R C4N M0d3R@T3 l1Nks 5Ect10n";
$lang['userisbanned'] = "u\$3R 1S B4nNeD";
$lang['useriswormed'] = "u53R 1S woRmeD";
$lang['userispilloried'] = "usER is piLl0r13D";
$lang['usercanignoreadmin'] = "uSER c4N 1GnoR3 @dM1n1\$+r4+0Rs";
$lang['groupcanaccessadmintools'] = "grouP c@n 4Cc3S\$ @Dm1N +oOl\$";
$lang['groupcanmoderateallfolders'] = "gr0UP c4N M0d3r@T3 @Ll ph0Lders";
$lang['groupcanmoderatelinkssection'] = "grOUp can mOd3r@+3 l1nKs SeC+10ns";
$lang['groupisbanned'] = "gr0uP i\$ 84nN3d";
$lang['groupiswormed'] = "gR0up i\$ WOrmED";
$lang['readposts'] = "rE@d pOs+\$";
$lang['replytothreads'] = "replY +O ThRe4D5";
$lang['createnewthreads'] = "cR3AtE n3W +Hr3@DS";
$lang['editposts'] = "ed1+ PoS+\$";
$lang['deleteposts'] = "deLEt3 P0s+\$";
$lang['postssuccessfullydeleted'] = "p0\$+5 sUccE\$\$Fully d3l3+ED";
$lang['failedtodeleteusersposts'] = "f@1LeD +o dEl3+e U\$Er'\$ poSt\$";
$lang['uploadattachments'] = "upLO4D 4+t4Chm3N+\$";
$lang['moderatefolder'] = "m0dErAT3 pholDeR";
$lang['postinhtml'] = "p0\$+ 1n h+mL";
$lang['postasignature'] = "p0S+ @ 5IGn@Ture";
$lang['editforumlinks'] = "ediT pH0RuM LinKS";
$lang['linksaddedhereappearindropdown'] = "liNK\$ @dD3D HeRe @Pp34r In @ Dr0p d0wn 1N The ToP rIgHt 0pH T3h phr4me 5E+.";
$lang['linksaddedhereappearindropdownaddnew'] = "l1nK\$ 4Dded Her3 4PpE4R 1N 4 Dr0P dOWn 1N Th3 t0P r1GhT 0PH +hE fR4M3 sE+. To @DD 4 l1Nk cL1cK +hE '4Dd n3W' bu++0N belOW.";
$lang['failedtoremoveforumlink'] = "f41Led +0 r3M0V3 Ph0RUm lInK '%s'";
$lang['failedtoaddnewforumlink'] = "fAIl3d To adD NeW fOrum linK '%s'";
$lang['failedtoupdateforumlink'] = "f@ILeD to upD@+e PhOrUm l1NK '%s'";
$lang['notoplevellinktitlespecified'] = "no Top l3V3L lInk +1TlE Sp3ciPhI3D";
$lang['youmustenteralinktitle'] = "j00 mU\$T enT3r a LiNk t1TlE";
$lang['alllinkurismuststartwithaschema'] = "alL LINk URi\$ mu5+ s+4rT wI+H @ scH3M4 (1.e. H++P://, pHtP://, iRC://)";
$lang['editlink'] = "ed1t LInk";
$lang['addnewforumlink'] = "adD N3w F0RuM LInk";
$lang['forumlinktitle'] = "f0RUm l1nK +1tlE";
$lang['forumlinklocation'] = "f0RuM L1nK L0c4+iOn";
$lang['successfullyaddednewforumlink'] = "suCc3S5FuLLy 4dD3d NEw PHORUM LInk";
$lang['successfullyeditedforumlink'] = "succ3sSfUlLY 3d1T3D F0RUm liNk";
$lang['invalidlinkidorlinknotfound'] = "inV4lid lInk 1d OR Link noT ph0UnD";
$lang['successfullyremovedselectedforumlinks'] = "sUCc3S\$phully r3MoVeD 5eLeC+3D LiNkS";
$lang['toplinkcaption'] = "toP LiNk c4Pt1ON";
$lang['allowguestaccess'] = "aLLoW Gu3S+ 4cCEs5";
$lang['searchenginespidering'] = "sE4RcH 3NgiNE Sp1d3RiN9";
$lang['allowsearchenginespidering'] = "allOw sE4rcH 3ngIn3 sPID3RIn9";
$lang['newuserregistrations'] = "n3w U\$3R reGistR@+iOn\$";
$lang['preventduplicateemailaddresses'] = "pr3V3N+ dupliCaTe 3M41l 4dDr3\$\$3s";
$lang['allownewuserregistrations'] = "alLoW New UsEr r3gI\$+r@t1ONs";
$lang['requireemailconfirmation'] = "rEQu1r3 eM@1L cONpH1Rm4+i0n";
$lang['usetextcaptcha'] = "us3 teX+-CaPtCh@";
$lang['textcaptchadir'] = "t3XT-C4PtcH4 Dir3CTorY";
$lang['textcaptchakey'] = "t3xT-c4p+Ch4 kEy";
$lang['textcaptchafonterror'] = "texT-c4PtCh4 h@S be3N d1S4BlED 4utOm@+1C4Lly 83c4Use tH3Re 4R3 N0 +RU3 TYp3 phon+s 4VaIL@8L3 F0r 1t +0 US3. Ple4S3 upL0@d SOm3 tRu3 tyP3 phOntS +0 <b>%s</b> On YoUr SeRv3R.";
$lang['textcaptchadirerror'] = "t3Xt-C4PTcH4 h4S Be3N DiS@8L3d 8eC@u\$3 +He +3Xt_c4pTCh4 d1R3cT0RY @nd IT'\$ sU8-DiR3c+0Rie\$ 4Re not Wr1T48l3 8Y t3h wEb S3RveR / PhP PrOcE\$\$.";
$lang['textcaptchagderror'] = "t3xT-C4pTCh4 h4S Be3N Di548Led bEc4USe y0Ur \$ERv3R'S PhP SEtUP dO3\$ NOt Pr0V1d3 sUPpOr+ Ph0R 9d Im493 m4n1pUl4+I0N 4Nd / oR ++F fOn+ sUpP0rT. 80+h 4rE R3qU1r3D FOr +ext-c4PtCh4 sUpPoRT.";
$lang['textcaptchadirblank'] = "teXT-c4PtCh4 d1R3cT0ry 1s bL@Nk!";
$lang['newuserpreferences'] = "n3w Us3r PrEfEr3NcE\$";
$lang['sendemailnotificationonreply'] = "em4IL N0T1fIC@t1On oN r3PlY To u\$Er";
$lang['sendemailnotificationonpm'] = "eM@1L N0T1f1C@t1On 0n pM +0 uSeR";
$lang['showpopuponnewpm'] = "sh0W P0PUp whEn rec3iVInG NeW pm";
$lang['setautomatichighinterestonpost'] = "s3+ 4U+0MaTic hI9h 1NtER3\$t 0N PoSt";
$lang['postingstats'] = "p05+In9 S+At\$";
$lang['postingstatsforperiod'] = "p0\$+1NG S+4TS F0R peR1Od %s +o %s";
$lang['nopostdatarecordedforthisperiod'] = "n0 PoSt D4t@ R3cOrd3d fOr ThiS pER10d.";
$lang['totalposts'] = "to+@l P0STS";
$lang['totalpostsforthisperiod'] = "t0+aL P0\$+\$ fOr +hiS pER10d";
$lang['mustchooseastartday'] = "mU\$T cHOos3 @ S+4Rt d4Y";
$lang['mustchooseastartmonth'] = "mUS+ cHOoSe a 5+4rT mOn+H";
$lang['mustchooseastartyear'] = "mUS+ cho0\$E A s+@rT Y3@R";
$lang['mustchooseaendday'] = "musT CH0o\$e a eND d4Y";
$lang['mustchooseaendmonth'] = "mu\$t ChOOsE A 3nD m0N+h";
$lang['mustchooseaendyear'] = "mU\$t cHoosE a 3nD y34r";
$lang['startperiodisaheadofendperiod'] = "s+@rT P3rIoD I5 @h34D oPH 3nD p3RI0d";
$lang['bancontrols'] = "b4n cONtr0Ls";
$lang['addban'] = "aDd b4N";
$lang['checkban'] = "ch3CK 84n";
$lang['editban'] = "edI+ 84n";
$lang['bantype'] = "b4n +Yp3";
$lang['bandata'] = "b4n D@+@";
$lang['bancomment'] = "c0mmEn+";
$lang['ipban'] = "iP bAn";
$lang['logonban'] = "l09oN B@N";
$lang['nicknameban'] = "nIckn4M3 8@n";
$lang['emailban'] = "emAiL b4n";
$lang['refererban'] = "rEf3R3r 8An";
$lang['invalidbanid'] = "iNv4LID b4n 1d";
$lang['affectsessionwarnadd'] = "tH1\$ b4n m4Y 4PhPH3c+ +He PhoLLOw1nG @CTIvE USeR \$E\$5Ion\$";
$lang['noaffectsessionwarn'] = "thIs Ban @PHfeCt\$ N0 @C+iv3 seS\$1onS";
$lang['mustspecifybantype'] = "j00 mU\$+ SP3C1phY @ b4N tyPe";
$lang['mustspecifybandata'] = "j00 mUs+ \$pECIpHy 5Ome 84N D@+4";
$lang['successfullyremovedselectedbans'] = "sUcceS\$phULLy rEM0V3d \$El3CteD 84n5";
$lang['failedtoaddnewban'] = "f4IL3d tO 4DD nEw bAN";
$lang['failedtoremovebans'] = "f41Led +O rEM0vE 5OMe OR AlL OF tEH \$el3Ct3d B4N5";
$lang['duplicatebandataentered'] = "dUPl1C4te 84N D@tA en+ER3d. PlE@\$e ChECk YOur WIldC@RdS tO 5ee 1f +heY @lRE4dy m@+Ch +h3 D4+4 3NtEred";
$lang['successfullyaddedban'] = "sucC355PhUlly aDdED 84N";
$lang['successfullyupdatedban'] = "suCC355PhulLY upd4T3d 84n";
$lang['noexistingbandata'] = "th3RE is no 3Xi\$t1N9 B4n d@T@. To 4dd @ B4n CLicK thE '4dD N3w' buT+0N bElOw.";
$lang['youcanusethepercentwildcard'] = "j00 can UsE +eH P3Rc3N+ (%) W1LdC@rD SyMb0l iN 4ny 0PH YoUr 84N lIS+5 T0 08+4iN p@R+I4l m@tcheS, I.E. '192.168.0.%' w0Uld 84n 4lL iP 4DdR3s5ES 1N tEh r4NgE 192.168.0.1 +hroUgH 192.168.0.254";
$lang['cannotusewildcardonown'] = "j00 CaNnOt 4Dd % 4s 4 W1Ldc4rD M@TcH On 1t'5 oWn!";
$lang['requirepostapproval'] = "r3qUiR3 PoS+ 4ppR0V4L";
$lang['adminforumtoolsusercounterror'] = "th3Re Mu\$+ B3 @T l345+ 1 uSeR Wi+h 4dMin +0OlS @Nd f0rUm +00lS 4Cc3S\$ 0n @Ll phORums!";
$lang['postcount'] = "p0\$t cOuN+";
$lang['resetpostcount'] = "rese+ P0\$+ c0uN+";
$lang['failedtoresetuserpostcount'] = "f@Il3d +0 rEse+ p0S+ CoUn+";
$lang['failedtochangeuserpostcount'] = "f41LEd +0 ch4N9E Us3R Po\$+ C0uNt";
$lang['postapprovalqueue'] = "p0s+ @pProv4l QuEu3";
$lang['nopostsawaitingapproval'] = "n0 pO\$TS 4R3 @W41t1NG 4PPROvAl";
$lang['approveselected'] = "apPrOvE 53lECt3d";
$lang['failedtoapproveuser'] = "fail3D To @ppr0V3 U\$Er %s";
$lang['kickselected'] = "kICK \$eLeC+3D";
$lang['visitorlog'] = "vISi+0R l09";
$lang['clearvisitorlog'] = "cL34r v1S1toR lO9";
$lang['novisitorslogged'] = "n0 vIs1T0rS L0993d";
$lang['addselectedusers'] = "aDd SeLeCtEd u\$eRS";
$lang['removeselectedusers'] = "r3MOv3 s3l3cTeD u\$3r\$";
$lang['addnew'] = "add n3w";
$lang['deleteselected'] = "d3LE+e Sel3cT3d";
$lang['forumrulesmessage'] = "<p><b>foRUM ruLE\$</b></p><p>\nrE9is+r4+ION +0 %1\$\$ i\$ PhR3E! wE d0 IN\$i\$+ ThaT j00 a81D3 8Y +Eh rUL3\$ @nD POl1C135 De+41l3D BElow. IpH J00 @9r33 t0 ThE t3RMs, PL34\$e cHeCK +eh '1 4gr3E' CH3cKbOx 4Nd pREs5 th3 'R391s+Er' Bu++0N 8eLOW. iF J00 w0UlD l1k3 +0 c4NceL The R3g1\$+R4+10N, CL1cK %2\$S t0 Re+uRN +0 +EH PhoRuM\$ InDex.</p><p>\n@L+HOu9H th3 4dMin1S+R4+0R5 4Nd mOd3R@tOr\$ 0ph %1\$5 wILl 4tTemp+ TO k3Ep @Ll O8J3c+10na8L3 mE\$\$4GeS 0PhPH +H1\$ FORuM, 1t 1\$ Imp0\$\$1Bl3 pH0R Us to rEVi3W 4Ll m3S54ge\$. 4LL m35549E\$ 3xPr35s THE v1eWS oPh thE @UTHOr, 4Nd N31Th3r T3h 0Wn3R\$ 0f %1\$s, NOr PR0j3cT 8Eeh1VE fORUM @ND 1T'\$ 4PhphiL14+ES w1ll B3 h3LD r3\$PONSI8L3 PhoR t3h c0nT3N+ 0f @NY m35S@9E.</p><p>\n8y 4Gre3IN9 +0 +h3\$3 RULe5, J00 w@Rr4nT +H4T j00 WIll noT p0\$+ 4NY M3\$54935 +h4+ 4R3 0B5CeNE, vULG4R, \$3xU4LLY-0RIENt4T3D, H4+3PHul, +HR3@T3N1NG, OR 0tHERwIS3 V1OL@T1Ve 0Ph 4NY l@WS.</p><p>th3 0WN3R\$ 0PH %1\$\$ r3sERV3 T3H rIGht to r3moVE, 3DI+, MOv3 0R Cl0\$E 4NY Thr34D Ph0R 4NY Re4\$0N.</p>";
$lang['cancellinktext'] = "hER3";
$lang['failedtoupdateforumsettings'] = "f@Il3D +0 Upd4+3 pHoruM \$e++1Ng\$. pl34Se Try 4g4In LaTeR.";
$lang['moreadminoptions'] = "m0r3 4DmIn oP+I0n5";

// Admin Log data (admin_viewlog.php) --------------------------------------------

$lang['changedstatusforuser'] = "cH4N9eD U5er S+4+u\$ FOr '%s'";
$lang['changedpasswordforuser'] = "chAN9Ed p4\$5W0rd foR '%s'";
$lang['changedforumaccess'] = "ch4NGed Ph0RUM @Cce\$S p3Rm1\$5I0nS FOr '%s'";
$lang['deletedallusersposts'] = "dEL3+eD @LL Po\$+5 f0R '%s'";

$lang['createdusergroup'] = "cr34T3d u5Er 9ROUp '%s'";
$lang['deletedusergroup'] = "d3L3+ed usEr GR0uP '%s'";
$lang['updatedusergroup'] = "upDa+Ed uSEr gRoUP '%s'";
$lang['addedusertogroup'] = "aDDEd u\$eR '%s' tO 9rouP '%s'";
$lang['removeduserfromgroup'] = "r3MOV3 uSEr '%s' phR0m 9r0Up '%s'";

$lang['addedipaddresstobanlist'] = "aDD3d 1p '%s' tO B4n L1St";
$lang['removedipaddressfrombanlist'] = "r3MoVEd 1P '%s' PhR0M b4n L1\$t";

$lang['addedlogontobanlist'] = "adDeD L09On '%s' +0 84n L1s+";
$lang['removedlogonfrombanlist'] = "rEMoV3d LogoN '%s' frOm 84N L1\$+";

$lang['addednicknametobanlist'] = "addeD N1CknAME '%s' +0 84n L1\$+";
$lang['removednicknamefrombanlist'] = "reMOvEd nIcKn4m3 '%s' frOM B4N l1st";

$lang['addedemailtobanlist'] = "aDD3d 3m4iL 4dDrES5 '%s' +0 baN liST";
$lang['removedemailfrombanlist'] = "reMOv3D em@Il @DdRE\$\$ '%s' phR0m b4N Li\$+";

$lang['addedreferertobanlist'] = "adDEd Ref3R3r '%s' +0 b4n L1\$+";
$lang['removedrefererfrombanlist'] = "rEM0VeD reFeR3R '%s' pHr0M B4N l1St";

$lang['editedfolder'] = "eD1+eD F0LDeR '%s'";
$lang['movedallthreadsfromto'] = "mov3D @Ll Thre@ds phROm '%s' TO '%s'";
$lang['creatednewfolder'] = "cre@TeD neW PHoLdeR '%s'";
$lang['deletedfolder'] = "deLe+eD FOld3R '%s'";

$lang['changedprofilesectiontitle'] = "ch4ngEd pRoFiLe \$EctIoN +iTl3 PhRom '%s' t0 '%s'";
$lang['addednewprofilesection'] = "add3D N3w pR0pH1l3 \$3c+10n '%s'";
$lang['deletedprofilesection'] = "d3L3+ed pROfiL3 S3C+I0n '%s'";

$lang['addednewprofileitem'] = "aDd3D n3W PrOFil3 1+eM '%s' +0 5EcTiOn '%s'";
$lang['changedprofileitem'] = "cH4Nged Pr0PhiL3 1t3m '%s'";
$lang['deletedprofileitem'] = "dEL3tEd pr0PhIl3 I+Em '%s'";

$lang['editedstartpage'] = "eDI+eD S+4Rt P4Ge";
$lang['savednewstyle'] = "saV3D NeW s+yl3 '%s'";

$lang['movedthread'] = "m0VEd thre4d '%s' FRoM '%s' t0 '%s'";
$lang['closedthread'] = "clOSEd thre4D '%s'";
$lang['openedthread'] = "open3D thReAd '%s'";
$lang['renamedthread'] = "renamEd +HRe4D '%s' +0 '%s'";

$lang['deletedthread'] = "d3l3t3d +hRe4D '%s'";
$lang['undeletedthread'] = "uND3lE+ed +hr34d '%s'";

$lang['lockedthreadtitlefolder'] = "l0Ck3d ThRe@D Op+IOnS on '%s'";
$lang['unlockedthreadtitlefolder'] = "unLOckeD ThR3@D 0pt10Ns On '%s'";

$lang['deletedpostsfrominthread'] = "d3L3tEd pOsTS Phr0M '%s' 1n ThrE4D '%s'";
$lang['deletedattachmentfrompost'] = "d3LeT3d @++4ChM3n+ '%s' fRoM pO\$+ '%s'";

$lang['editedforumlinks'] = "eD1+3d pHoruM L1nKs";
$lang['editedforumlink'] = "eD1t3D FoRUm LInK: '%s'";

$lang['addedforumlink'] = "addED PhOrum l1Nk: '%s'";
$lang['deletedforumlink'] = "d3l3+ed PhORum L1NK: '%s'";
$lang['changedtoplinkcaption'] = "ch4N9Ed TOp l1Nk c4Pt10n pHr0M '%s' +0 '%s'";

$lang['deletedpost'] = "dEL3+3d poS+ '%s'";
$lang['editedpost'] = "eD1+ed P0sT '%s'";

$lang['madethreadsticky'] = "m4De +HrE@D '%s' \$+1cky";
$lang['madethreadnonsticky'] = "m4dE +HRe4d '%s' n0N-S+IcKy";

$lang['endedsessionforuser'] = "eND3D s3SSioN f0R u5eR '%s'";

$lang['approvedpost'] = "apprOV3d p0S+ '%s'";

$lang['editedwordfilter'] = "ed1+Ed WoRd FiL+3r";

$lang['addedrssfeed'] = "adDeD r\$5 f3ED '%s'";
$lang['editedrssfeed'] = "ed1T3d R\$5 Fe3d '%s'";
$lang['deletedrssfeed'] = "dELe+3d rS5 feed '%s'";

$lang['updatedban'] = "uPd@t3D 8@n '%s'. cH4nGeD +yPe PhroM '%s' +0 '%s', cH@N9eD DAT4 Phr0M '%s' To '%s'.";

$lang['splitthreadatpostintonewthread'] = "split +hRe4D '%s' 4+ pOS+ %s  iNt0 NEw thRE@D '%s'";
$lang['mergedthreadintonewthread'] = "m3RGeD +hr34D\$ '%s' 4Nd '%s' int0 nEw ThrE4d '%s'";

$lang['approveduser'] = "aPpRovED UsEr '%s'";

$lang['forumautoupdatestats'] = "fORUm 4U+O UpD@te: 5T@Ts upd4+ed";
$lang['forumautoprunepm'] = "f0RUM AUt0 uPdaTE: pM PhOldeRs PrUnEd";
$lang['forumautoprunesessions'] = "foRUm @U+0 Upd4T3: SeS5i0n5 PrUN3d";
$lang['forumautocleanthreadunread'] = "f0RuM 4uTO UPdA+3: thRE4d uNRe4d d4+a ClE@NeD";
$lang['forumautocleancaptcha'] = "forUM 4UtO upd4+3: teX+-c4p+cH@ 1m@9e\$ cL3An3D";

$lang['ipaddressbanhit'] = "uS3R '%s' i\$ B4nn3D. ip 4Ddr3SS '%s' m@TchED b4N d@T@ '%s'";
$lang['logonbanhit'] = "useR '%s' 1S B4Nned. l0g0n '%s' m4+cH3d 84N d@t@ '%s'";
$lang['nicknamebanhit'] = "user '%s' I\$ 8@nnED. nickN@Me '%s' m4+cH3d 84n d@+4 '%s'";
$lang['emailbanhit'] = "u5Er '%s' iS 84Nn3D. eM4il 4ddrEss '%s' m4+chEd b4N D4t4 '%s'";
$lang['refererbanhit'] = "u53r '%s' 1\$ B4NN3D. h++P ref3ReR '%s' M@+cHeD 84N dat@ '%s'";

$lang['userpermenabled'] = "eNabL3d PERMs FoR USER '%s': %s";
$lang['userpermdisabled'] = "dI5AbleD P3RmS F0r uSeR '%s': %s";

$lang['userpermbanned'] = "b@NN3D";
$lang['userpermwormed'] = "worM3D";
$lang['userpermfoldermoderate'] = "f0ldER M0D3r4+0R";
$lang['userpermadmintools'] = "aDM1n tooL5";
$lang['userpermforumtools'] = "f0Rum To0LS";
$lang['userpermlinksmod'] = "l1nk\$ mOD3ra+0r";
$lang['userpermignoreadmin'] = "i9NOR3 @Dm1N";
$lang['userpermpilloried'] = "p1lLoR13d";

$lang['adminlogempty'] = "aDmIn lOg 1s EmPTY";

$lang['youmustspecifyanactiontypetoremove'] = "j00 Mu\$t 5Pec1Fy 4n 4cT1On Typ3 To R3mOV3";

$lang['alllogentries'] = "aLL L0g 3nTr13\$";
$lang['userstatuschanges'] = "us3R \$t4+u\$ Ch@N9e\$";
$lang['forumaccesschanges'] = "forUm 4cC3ss ch@ng3S";
$lang['usermasspostdeletion'] = "usER m4s5 PoS+ d3lE+IOn";
$lang['ipaddressbanadditions'] = "ip 4DdReSS 8@n @dDi+1oN5";
$lang['ipaddressbandeletions'] = "ip @dDrEs5 8@n Del3+10n\$";
$lang['threadtitleedits'] = "tHRe4D +1TlE 3D1+s";
$lang['massthreadmoves'] = "m4s\$ +hr3@D m0V3\$";
$lang['foldercreations'] = "f0LDeR cRe4+1OnS";
$lang['folderdeletions'] = "fold3R d3lE+1Ons";
$lang['profilesectionchanges'] = "pR0Ph1L3 s3C+i0N ChAn9E\$";
$lang['profilesectionadditions'] = "pr0fIl3 \$Ect1ON @DDi+i0n5";
$lang['profilesectiondeletions'] = "pROF1lE s3C+1On d3L3t1Ons";
$lang['profileitemchanges'] = "pr0Ph1L3 1+Em ChaNGeS";
$lang['profileitemadditions'] = "proPH1l3 1+Em @dd1t1OnS";
$lang['profileitemdeletions'] = "pr0pH1LE It3m d3L3+I0n\$";
$lang['startpagechanges'] = "sT4rt P4g3 cH@Ng35";
$lang['forumstylecreations'] = "f0RUM S+yL3 CrE@t1OnS";
$lang['threadmoves'] = "tHR34d mOV3\$";
$lang['threadclosures'] = "tHR34d CloSuR3s";
$lang['threadopenings'] = "thre4d oPeN1N9\$";
$lang['threadrenames'] = "thr34D ReN@m3S";
$lang['postdeletions'] = "post D3l3+1onS";
$lang['postedits'] = "p0\$t 3Di+\$";
$lang['wordfilteredits'] = "w0RD pH1Lt3R 3d1+\$";
$lang['threadstickycreations'] = "thRead \$+1Cky cre4+1On5";
$lang['threadstickydeletions'] = "thr34D \$+ICkY D3l3+10NS";
$lang['usersessiondeletions'] = "u\$3r SeS\$1On dEL3+iOns";
$lang['forumsettingsedits'] = "f0Rum \$3TtiN9s eDiTs";
$lang['threadlocks'] = "thr34D LocK\$";
$lang['threadunlocks'] = "thRE4d uNl0CK\$";
$lang['usermasspostdeletionsinathread'] = "uSEr m4SS P0\$T D3l3+10n\$ In @ +HrE4d";
$lang['threaddeletions'] = "tHre@d d3L3+IoN\$";
$lang['attachmentdeletions'] = "a+T4chm3nt deL3TiOnS";
$lang['forumlinkedits'] = "fOrUm l1Nk 3dItS";
$lang['postapprovals'] = "pOS+ 4pPRoV@ls";
$lang['usergroupcreations'] = "u5eR 9r0UP CrE@tIoNS";
$lang['usergroupdeletions'] = "u5Er 9rOup DeL3T10Ns";
$lang['usergroupuseraddition'] = "u\$3R 9ROuP U5Er @dD1t10n";
$lang['usergroupuserremoval'] = "u\$3R 9RoUp UseR r3m0v4L";
$lang['userpasswordchange'] = "u\$Er P4s\$wORd cH@N93";
$lang['usergroupchanges'] = "u\$3R GrOUp Ch4NgE\$";
$lang['ipaddressbanadditions'] = "iP @ddRe\$\$ b4n @Dd1T1On\$";
$lang['ipaddressbandeletions'] = "iP 4DdR3\$5 84n d3Le+IoN\$";
$lang['logonbanadditions'] = "l0G0N B4n @Dd1T10N5";
$lang['logonbandeletions'] = "l0g0N 84N deL3+1OnS";
$lang['nicknamebanadditions'] = "niCkN@mE 84n aDd1+iONS";
$lang['nicknamebanadditions'] = "n1CKn4M3 84n @dDIT1oNs";
$lang['e-mailbanadditions'] = "e-M41l 84n 4Dd1+iONs";
$lang['e-mailbandeletions'] = "e-maiL B4n d3L3+I0ns";
$lang['rssfeedadditions'] = "r5s fEeD @dDiT10n5";
$lang['rssfeedchanges'] = "rSS f33d cH4N9E\$";
$lang['threadundeletions'] = "thr34d UnDel3+i0Ns";
$lang['httprefererbanadditions'] = "h++p rEfEr3R 84n 4dDit1OnS";
$lang['httprefererbandeletions'] = "h+Tp r3pH3R3R B@N DeL3+iOn\$";
$lang['rssfeeddeletions'] = "rSS pHE3d d3L3+10nS";
$lang['banchanges'] = "b4N cH@N93s";
$lang['threadsplits'] = "thRe4D sPlit5";
$lang['threadmerges'] = "thR3AD meRgEs";
$lang['userapprovals'] = "u\$3r @PPROv4ls";
$lang['forumlinkadditions'] = "f0Rum LiNk 4DdItIOnS";
$lang['forumlinkdeletions'] = "fORUm l1nK D3L3TionS";
$lang['forumlinktopcaptionchanges'] = "foRuM l1nK +0p c@pt1On ch@n93S";
$lang['folderedits'] = "foLd3R 3DiTs";
$lang['userdeletions'] = "u53r d3L3+1OnS";
$lang['userdatadeletions'] = "u5Er d4+4 d3lEtIoNs";
$lang['forumstatsautoupdates'] = "f0ruM \$+4+S 4UtO UpD@T3s";
$lang['forumautopmpruning'] = "fORuM 4U+O Pm pRuNin9";
$lang['forumautosessionpruning'] = "f0RUm 4U+0 sE\$5i0N PrUn1n9";
$lang['forumautothreadunreaddataupdates'] = "fORUm 4Uto +hR3aD UnR34D daT@ uPd@+E5";
$lang['forumautotextcaptchaclean-ups'] = "forUM 4U+0 +eXt C4pTCH4 cLE4n-uPs";
$lang['usergroupchanges'] = "uS3R 9RoUp cH4nGe\$";
$lang['ipaddressbancheckresults'] = "iP 4ddR3\$5 84N ChEck resUltS";
$lang['logonbancheckresults'] = "log0N b4N CheCk rE\$UlT5";
$lang['nicknamebancheckresults'] = "n1Ckn4mE 8@N cH3ck rESuLt5";
$lang['emailbancheckresults'] = "ema1L b4N ChEcK ReSUltS";
$lang['httprefererbancheckresults'] = "h++p ReF3r3R BaN CHeCK r3suLtS";

$lang['removeentriesrelatingtoaction'] = "r3moV3 eN+R13\$ r3L@+iNg TO @cT10n";
$lang['removeentriesolderthandays'] = "r3MOv3 3N+R1eS 0Ld3R Th@N (d4ys)";

$lang['successfullyprunedadminlog'] = "sUCc3S5fuLLy PrUnEd @dm1n lO9";
$lang['failedtopruneadminlog'] = "f@1LEd +O PrUn3 @Dm1n l09";

$lang['prune_log'] = "prUN3 lo9";

// Admin Forms (admin_forums.php) ------------------------------------------------

$lang['noexistingforums'] = "n0 eX1S+1N9 F0rUm5 f0UnD. +0 crE4+E 4 NeW PhorUm ClIcK Th3 'Add new' BuTtOn 8eLow.";
$lang['webtaginvalidchars'] = "weB+4g can 0nLY c0Nt@1n UpPeRc4\$e A-z, 0-9 And unD3r\$c0Re cH4R@c+3Rs";
$lang['databasenameinvalidchars'] = "d@T484Se N4Me C@N 0nLY cON+4in @-z, A-z, 0-9 4nD uNd3rscOr3 cH@R@c+ErS";
$lang['invalidforumidorforumnotfound'] = "iNVaL1D phoRum Fid 0r fOrUM nOT F0Und";
$lang['successfullyupdatedforum'] = "sUCC3S5fUlLY UpD4+ED FoRum";
$lang['failedtoupdateforum'] = "f@iLed t0 uPd@t3 f0rUm: '%s'";
$lang['successfullycreatednewforum'] = "suCc3s5FuLlY cRe4+eD N3w PHorUm";
$lang['selectedwebtagisalreadyinuse'] = "t3H S3l3c+3D wEB+@G 1S @lRE4dY In u\$e. Pl34\$3 ChOoSe @NoTh3r.";
$lang['selecteddatabasecontainsconflictingtables'] = "teH sEl3c+3d d@t@84\$e c0nta1N\$ c0NpHl1c+InG T4bLEs. c0nPhLict1N9 tAbLe n4mE\$ 4r3:";
$lang['forumdeleteconfirmation'] = "are j00 SUr3 j00 W4NT +0 D3L3t3 4ll 0pH +h3 SEl3C+ed FoRuM5?";
$lang['forumdeletewarning'] = "pLEa\$3 n0+E Th4+ j00 C4nN0+ rEc0V3r dEL3+3D f0RUm\$. OnCe dEl3+ED @ phORum @nD 4Ll 0ph i+'s 45\$0cI4+ED D4tA 1S peRM4neN+Ly rEmOV3D fRoM +3h d4+4b4\$e. 1f J00 d0 n0T Wi\$H TO dEL3+e tH3 \$EL3cT3d PhoRuM\$ pLe4\$e cL1Ck C4Nc3L.";
$lang['successfullyremovedselectedforums'] = "sUCc355FuLly del3t3d \$El3C+3D f0RuM\$";
$lang['failedtodeleteforum'] = "fAIL3d tO DeLeT3D f0rum: '%s'";
$lang['addforum'] = "add forUm";
$lang['editforum'] = "eDIt Ph0Rum";
$lang['visitforum'] = "v1s1T PhOrUm: %s";
$lang['accesslevel'] = "aCC3sS l3vEl";
$lang['forumleader'] = "f0RUm L34DeR";
$lang['usedatabase'] = "usE D4T@84\$e";
$lang['unknownmessagecount'] = "uNKnOwN";
$lang['forumwebtag'] = "f0RUM WE8+4G";
$lang['defaultforum'] = "dEPhauL+ fOrUM";
$lang['forumdatabasewarning'] = "ple4Se 3nSUr3 j00 seLeCt +HE C0rreCT dAt4B4s3 wh3N Cr34t1Ng 4 New PhoRuM. 0Nc3 cRE4T3D a n3W PhOrUm c4NnOt BE M0v3D 8E+W33n 4V4iLA8le D4+4b4Se\$.";

// Admin Global User Permissions

$lang['globaluserpermissions'] = "gL08@l uSeR P3rM1ssIoNs";

// Admin Forum Settings (admin_forum_settings.php) -------------------------------

$lang['mustsupplyforumwebtag'] = "j00 Must 5UPpLy 4 pHoRUm W3Bt4g";
$lang['mustsupplyforumname'] = "j00 Mu\$+ suPpLy 4 PhOrum n4mE";
$lang['mustsupplyforumemail'] = "j00 MuSt \$UpPlY A PhorUm 3M4il 4DdR3\$\$";
$lang['mustchoosedefaultstyle'] = "j00 mUS+ cHooSe 4 D3Ph4Ult pH0rUm S+Yl3";
$lang['mustchoosedefaultemoticons'] = "j00 mu\$T cHoO5e d3Ph@ULT phOrUm 3M0+1c0ns";
$lang['mustsupplyforumaccesslevel'] = "j00 muS+ \$UpPlY 4 pHOrUm @Cc3\$\$ l3Vel";
$lang['mustsupplyforumdatabasename'] = "j00 mUs+ SUPpLy 4 Ph0Rum d4+4B4\$E n@M3";
$lang['unknownemoticonsname'] = "uNKn0wN em0t1C0nS N@m3";
$lang['mustchoosedefaultlang'] = "j00 MUsT chOo5E 4 D3f@Ul+ ForuM L4nGu@93";
$lang['activesessiongreaterthansession'] = "acTIvE se\$5iOn +1m30U+ c@nnoT BE GrE4t3R +H@N \$e\$5i0N +1m30U+";
$lang['attachmentdirnotwritable'] = "a+T4cHmEN+ D1r3CtoRY 4Nd sYs+3M +eMPoR4Ry dir3c+0rY / php.1n1 'UpL0ad_+Mp_Dir' mu5+ 8E WrI+48le 8y The W38 s3RvEr / phP Pr0c3S\$!";
$lang['attachmentdirblank'] = "j00 muST suPpLy 4 DIr3c+0ry To \$@v3 @++4cHM3ntS in";
$lang['mainsettings'] = "m41N Se+T1n9\$";
$lang['forumname'] = "fOruM nam3";
$lang['forumemail'] = "f0RuM 3Ma1L";
$lang['forumnoreplyemail'] = "no-r3pLy 3M@1l";
$lang['forumdesc'] = "foRUm de\$Cr1P+1on";
$lang['forumkeywords'] = "foRum KEyw0RdS";
$lang['defaultstyle'] = "dEF@ul+ S+yL3";
$lang['defaultemoticons'] = "dEpH4ul+ 3m0T1cOn5";
$lang['defaultlanguage'] = "dePh@ul+ lan9U49e";
$lang['forumaccesssettings'] = "f0ruM 4cC3S\$ \$e++1N95";
$lang['forumaccessstatus'] = "fORuM 4ccE\$5 \$+4+Us";
$lang['changepermissions'] = "cHAn93 PERMiS\$10N\$";
$lang['changepassword'] = "cH4nGe p4S\$WOrD";
$lang['passwordprotected'] = "p4sSw0Rd Pr0+Ect3D";
$lang['passwordprotectwarning'] = "j00 H4v3 noT 5E+ 4 PH0rUm p4S5w0Rd. 1ph j00 D0 n0t \$3T 4 P@s\$W0rD Th3 P4S5w0RD PrOT3cT1On fUnCT10NaLi+y WiLl bE @u+0mAt1c4LlY DiS@8L3D!";
$lang['postoptions'] = "poS+ 0p+1oNs";
$lang['allowpostoptions'] = "allow Po\$+ EdiT1n9";
$lang['postedittimeout'] = "p0\$T Edi+ tIM3ou+";
$lang['posteditgraceperiod'] = "pOS+ EDit 9racE PEri0D";
$lang['wikiintegration'] = "wIKiwIki 1NT3gr4T1oN";
$lang['enablewikiintegration'] = "eN4bL3 w1KIwIk1 1nTE9r4+10n";
$lang['enablewikiquicklinks'] = "en@8lE W1KiW1kI QuIcK liNks";
$lang['wikiintegrationuri'] = "w1K1w1Ki l0C4+10n";
$lang['maximumpostlength'] = "m@x1Mum POS+ L3NgTh";
$lang['postfrequency'] = "posT pHReqU3ncY";
$lang['enablelinkssection'] = "eN4Bl3 LInK5 \$eCt1On";
$lang['allowcreationofpolls'] = "allOW Cr34+1On 0F p0Ll5";
$lang['allowguestvotesinpolls'] = "all0W gU3\$+s +0 vOT3 1n p0Ll\$";
$lang['unreadmessagescutoff'] = "unR3@D me\$54935 cU+-oPHf";
$lang['disableunreadmessages'] = "d1S48L3 UnreAd ME5\$AGe\$";
$lang['thirtynumberdays'] = "30 d@ys";
$lang['sixtynumberdays'] = "60 d@yS";
$lang['ninetynumberdays'] = "90 dAyS";
$lang['hundredeightynumberdays'] = "180 d4Ys";
$lang['onenumberyear'] = "1 Ye@r";
$lang['unreadcutoffchangewarning'] = "dePeNd1Ng oN SeRv3r PerPHoRm4NcE @Nd tH3 NuMbEr 0F +hR34D\$ yOuR PhOrumS C0nTain, Ch@N91ng th3 UnRE@d Cu+-0ff MaY t4K3 S3v3R@L MiNuT3\$ +0 coMPle+E. PhOr +HI\$ re4\$on It 1S r3CoMm3ND3D th@+ j00 4vo1d Ch4N9in9 +HiS se++InG WHil3 y0Ur pHoRuM\$ @R3 bU\$Y.";
$lang['unreadcutoffincreasewarning'] = "iNCr34SIng +3H unr34D Cu+-0PhPH wIlL R3\$uL+ IN +hR34D\$ old3r Th@N the cUrR3n+ CuT-0phph aPpe4RIn9 @s uNre4d fOr 4Ll User5.";
$lang['confirmunreadcutoff'] = "ar3 J00 Sur3 j00 W4n+ +0 ChAn9e +eH UnRe@d cU+-0pHpH?";
$lang['otherchangeswillstillbeapplied'] = "cliCk1ng 'N0' WilL oNlY c4Nc3l +He UnrE4D cUt-0Ff cH@N935. 0TH3R Ch@ngeS yOU'vE mAD3 w1Ll \$+iLl be S4v3D.";
$lang['searchoptions'] = "se@rCH 0p+1On5";
$lang['searchfrequency'] = "sE4RcH Fr3QuENcY";
$lang['sessions'] = "s3s51OnS";
$lang['sessioncutoffseconds'] = "sesS10n cUt 0phph (S3c0NdS)";
$lang['activesessioncutoffseconds'] = "aC+iVe se551On Cu+ Off (5eC0Nds)";
$lang['stats'] = "s+@tS";
$lang['hide_stats'] = "h1dE \$+4+\$";
$lang['show_stats'] = "shoW S+4+\$";
$lang['enablestatsdisplay'] = "en@BlE S+@+S D1\$PL@y";
$lang['personalmessages'] = "p3RS0n@L mEs54gE\$";
$lang['enablepersonalmessages'] = "en4Bl3 pEr\$0n4l M3S54Ge\$";
$lang['pmusermessages'] = "pM m35\$@9E\$ P3r u5ER";
$lang['allowpmstohaveattachments'] = "allOw P3R\$0n@L m35\$49eS +0 h4vE @tT4cHM3N+\$";
$lang['autopruneuserspmfoldersevery'] = "auT0 PrUn3 u\$Er's pm pHoLD3r\$ EvErY";
$lang['userandguestoptions'] = "us3r 4ND Gu3\$t 0p+10nS";
$lang['enableguestaccount'] = "enAbl3 9U35T @cC0uN+";
$lang['listguestsinvisitorlog'] = "li5t gu3StS IN V1s1ToR Lo9";
$lang['allowguestaccess'] = "aLL0w gUe\$t 4cc3SS";
$lang['userandguestaccesssettings'] = "us3R @nD 9U3S+ 4Cc3S5 sE++1n9\$";
$lang['allowuserstochangeusername'] = "alL0W uSer\$ tO CH@n9E U5Ern4M3";
$lang['requireuserapproval'] = "rEQu1R3 U5Er ApPrOv4L bY @dM1n";
$lang['requireforumrulesagreement'] = "rEQuIr3 US3r TO 4Gr33 +o f0rum rULE\$";
$lang['enableattachments'] = "en4Bl3 @+t@ChM3nts";
$lang['attachmentdir'] = "aT+4chM3n+ D1R";
$lang['userattachmentspace'] = "a++4chMenT Sp@c3 pEr u\$eR";
$lang['allowembeddingofattachments'] = "alLoW EM83dD1n9 of @t+4ChMen+\$";
$lang['usealtattachmentmethod'] = "uS3 4l+3RN@t1v3 4Tt4CHm3n+ M3+HoD";
$lang['allowgueststoaccessattachments'] = "allOw 9u35+5 +O 4CcEsS a++4CHmEN+\$";
$lang['forumsettingsupdated'] = "f0RUm sE++ingS \$uCC3S\$fullY upD4t3D";
$lang['forumstatusmessages'] = "fORUM \$+4+u\$ M35s4G35";
$lang['forumclosedmessage'] = "foRUm ClO\$ED m3\$s4ge";
$lang['forumrestrictedmessage'] = "fOrUm r3StR1c+Ed mEs54g3";
$lang['forumpasswordprotectedmessage'] = "fORuM P4\$5w0RD Pr0T3cteD meSS4Ge";

// Admin Forum Settings Help Text (admin_forum_settings.php) ------------------------------

$lang['forum_settings_help_10'] = "<b>p0sT 3D1+ tIm3Out</b> 15 Th3 +1ME In mInU+eS @Ph+3r po\$+InG Th4t @ u5Er c4N 3di+ tH3iR P0s+. 1F SE+ to 0 tH3Re I\$ n0 liMi+.";
$lang['forum_settings_help_11'] = "<b>m4XimUM p0S+ LeN9Th</b> 15 Th3 M4X1muM NuM83R 0pH Ch@R@c+3rS Th4+ wIll 8E DiSpL4y3d iN @ pOs+. 1f @ poS+ iS lOn9Er +h4n tH3 numb3R Oph CHar@c+eR\$ DEfiN3d h3R3 iT W1lL Be CUt Sh0Rt @Nd @ liNk 4dDeD tO +3h b0tT0m +0 AlLoW U5Ers to Re4D +H3 wh0le PoS+ On @ 5Ep@RAt3 p@ge.";
$lang['forum_settings_help_12'] = "iPH j00 dOn't W4n+ y0ur u\$3RS tO Be @8Le +0 cR34+E P0lL\$ J00 c@n dI\$4Bl3 th3 48OV3 0p+1On.";
$lang['forum_settings_help_13'] = "tHe l1nkS 5ECt1On 0Ph 8Eeh1Ve pR0V1d35 @ pL@c3 ph0R Y0uR u5ErS T0 M4iN+41N @ LiS+ 0PH SiT3S +H3Y Fr3Qu3n+lY VI\$1+ +H4+ 0Th3r Us3RS m@Y fInD USEFul. LiNkS c4n 83 d1VIdEd iNtO c4+eGor135 8y PhOlDeR 4Nd 4Ll0W pHOr cOMm3NtS @Nd r4+1n9\$ TO bE 91V3n. 1N oRd3R +0 moD3R4t3 +He l1NkS sEc+i0n 4 uSEr mU\$+ 8E r4n+3D 9lo84L M0D3r4+0r s+4TuS.";
$lang['forum_settings_help_15'] = "<b>s3s5IoN cU+ 0fph</b> 1S ThE M4XiMuM tim3 8EF0Re @ usEr'S Se\$\$Ion 1S DE3M3d D34D 4Nd th3Y ArE Lo99ed Ou+. bY d3F@ul+ tH1S iS 24 h0UrS (86400 5eCOnD5).";
$lang['forum_settings_help_16'] = "<b>actIVE 53S5IOn CUt 0phPh</b> i\$ +eH m@X1muM +im3 83phORe 4 u5ER'\$ Ses5IoN 1S DeEM3d 1NaC+1v3 at wh1Ch P01nT +hEY eN+Er 4N 1dLe \$+@+E. in ThI\$ s+4+E +hE U\$3r r3m4InS l09geD 1N, BU+ +hEY 4R3 r3MOveD pHr0M +hE @c+iV3 u5ErS LI5T 1N +eH S+@+S d1\$pL4y. 0NcE Th3Y 83CoM3 @C+1VE 4g41N TH3y wIlL 8E R3-@ddeD T0 tEh lIsT. By d3F4Ul+ tH1\$ sEtT1n9 15 s3T T0 15 M1nU+3\$ (900 5eC0nDs).";
$lang['forum_settings_help_17'] = "enABL1ng th1S 0P+10n 4lL0Ws 8eEh1V3 tO 1nClUde @ 5+4tS disPl@y @+ +He 80T+0m of t3H me\$54G35 P4n3 \$iM1l4R to +3h on3 u5Ed 8y m4NY fORuM SoPh+w@rE T1+Le\$. 0NC3 Ena8LeD Th3 dIsPlAY 0Ph +Eh s+4+S P4Ge c@n Be +099l3d 1nDiV1Du@lly 8Y 34cH u\$er. Iph +h3y d0N'+ W@Nt +0 S3E 1T thEy c4N H1De 1T phr0M vi3W.";
$lang['forum_settings_help_18'] = "pERS0nAL meSs4G3\$ @rE Invalu4Bl3 A5 @ W4y 0pH T4kIn9 m0r3 pRIv@T3 M4++eRs Ou+ OF Vi3w OpH +eH 0+h3r m3M83r\$. HOW3v3r 1F J00 d0N'+ W@nT YOUr U\$Er\$ To BE 4BLE +0 \$3nD 34cH 0+hER p3RS0nal m3\$549e\$ J00 cAN D1s4Bl3 +h1s op+10n.";
$lang['forum_settings_help_19'] = "p3R\$0N4l mEsSaGeS c@n 4ls0 CoNt41n 4++AcHm3N+5 wh1Ch C4N 8E u5efUl PhOr ExcH4nG1n9 PH1Le\$ B3+WEen UsErS.";
$lang['forum_settings_help_20'] = "<b>no+E:</b> Th3 sP4Ce aLlOc@ti0N F0R pM A++4Chm3nts 1\$ tAKEN pHrOm 34Ch UseR5' M4iN A++4cHmEn+ 4lloC@+1On AND Is n0+ In @DdiTion +O.";
$lang['forum_settings_help_21'] = "<b>en4bl3 9UEsT 4cCoUN+</b> 4Ll0wS v1S1t0Rs T0 8RoW5e Y0ur pH0RuM @nD r34D P0S+\$ w1ThOU+ R391S+3R1n9 @ u\$Er 4cc0Un+. 4 U5Er 4cC0uN+ is st1ll ReQuIr3D 1Ph +heY w1SH T0 p05+ Or Ch4N9e u\$3R pR3pH3rEnc3S.";
$lang['forum_settings_help_22'] = "<b>lIS+ Gu3\$T5 In Vi\$i+oR Lo9</b> @LLowS j00 tO \$PeC1pHy wHetH3R 0r nOT uNReg1\$+er3D u\$3rS 4rE Li\$+Ed 0N +eh v1si+Or Lo9 @l0N9 S1dE r3gI\$+eR3D u\$ERS.";
$lang['forum_settings_help_23'] = "b33HiV3 4lLOw\$ a++4ChM3N+\$ To bE UpLo@d3D +0 Me\$54g35 wH3n p0S+ED. 1Ph j00 H@Ve L1m1+Ed We8 \$P4c3 J00 m@Y wH1cH TO D1s4Bl3 4++4cHm3NtS 8Y cl34rIN9 +3H B0X 4b0V3.";
$lang['forum_settings_help_24'] = "<b>aT+4Chm3n+ D1r</b> i\$ +eH l0c4T10N be3hiv3 \$hOuLd 5+0Re iT'S 4t+@ChM3n+\$ In. th15 DirEcT0rY MuSt eXiST 0N YoUR wE8 \$p@cE @nD MU5+ 8E wr1+@8lE 8Y +eh w38 53Rv3R / pHp proc3\$\$ o+h3rwi\$E UPL04Ds w1ll F@1L.";
$lang['forum_settings_help_25'] = "<b>aTT4chM3nT \$P4ce p3R US3r</b> 1s +Eh M4X1mUM 4Moun+ oF dIsK \$P4Ce 4 u\$eR h4S Ph0R 4Tt@chMEnTs. oNce +hi\$ \$P@CE 1S u5Ed Up +he Us3R C@Nn0t uPl0aD @nY m0r3 4++4cHMenT\$. By dEF4UL+ ThIS iS 1Mb oPH 5p@cE.";
$lang['forum_settings_help_26'] = "<b>all0W EMbeddiNg OF @t+4CHmeNTs IN M3SS@935 / \$ign4+UR35</b> @LLOWs U5erS TO 3m8Ed aT+4cHm3NTS IN PoS+s. 3n48l1nG +Hi\$ 0pTiON wHIle U5EFul C4N 1ncrE4S3 YOUR B@ndw1d+h U54gE dR4sTic4lLY UNd3R Cer+41n COnPHI9uR@TiON\$ of php. If J00 h@v3 L1Mi+3D b@NDwIDth 1T iS rEC0mM3nd3D +h4+ j00 d1S48Le ThIS 0Pt10N.";
$lang['forum_settings_help_27'] = "<b>us3 alt3rN@T1Ve 4++@cHmEN+ m3+h0D</b> f0rc35 8eEhivE TO UsE An @l+eRn4+Ive rEtRi3VaL Me+Hod Ph0R 4++acHm3N+\$. 1pH j00 r3c3IvE 404 3RR0r m3S54gES When TrYiNG T0 d0WNLO4d Att@cHmEnTS FrOM mE\$54GeS +Ry eN@blin9 tH1\$ 0P+I0n.";
$lang['forum_settings_help_28'] = "thiS s3++1nG 4lLow5 y0Ur phOrUM +0 bE spid3rED By 5e@rcH 3nGin3S liK3 GoOgLe, @lT4vis+@ @Nd Y4h0O. iPh J00 \$wItcH th1S oP+1On 0PhpH yOuR PhOrUm wIlL No+ 83 incLUdEd 1n tHe\$e Se4Rch 3NG1N3\$ rESULt\$.";
$lang['forum_settings_help_29'] = "<b>aLL0W N3w U5eR r39iS+r@T1OnS</b> @LlOwS oR d1s4Ll0ws +eh cRE4t10N 0ph NeW U5eR @cc0Un+5. \$E++InG +hE Op+1On +0 n0 CompLeTEly D1s4BleS th3 rEgI\$+r@T1On Ph0rM.";
$lang['forum_settings_help_30'] = "<b>eN4BlE W1k1WiKI iNT3Gr@+i0N</b> Pr0V1d3\$ W1k1woRd sUPp0r+ iN YoUr fOrUm p0S+\$. 4 wIK1Word iS maDE uP 0ph tWo 0r mOr3 cOnc@T3N@T3d w0RdS Wi+h uPP3rC4\$E L3tT3rS (0f+eN ReFeRred t0 4\$ c4mElC4\$E). if j00 wr1Te 4 w0rd +HiS W@y It W1lL @UToM@T1cALlY BE CH4N93D IntO @ HYp3Rl1Nk POiNT1n9 tO YOuR Ch05EN w1kiw1K1.";
$lang['forum_settings_help_31'] = "<b>eNA8LE W1K1w1ki QuiCk l1NkS</b> EN48L3\$ +EH u5E OpH m5g:1.1 4nd U\$eR:loGOn \$+yl3 eXt3ND3D W1k1L1NKs wHIch CrE4+E HyP3Rl1NkS TO +Eh sPeC1Fi3D M3\$\$493 / US3R PROfil3 0pH th3 sP3CiPhi3D U5er.";
$lang['forum_settings_help_32'] = "<b>w1kIwik1 LoC@t1oN</b> IS U5eD T0 5pEC1fY +eh ur1 OPh YoUr wik1w1K1. when 3n+eRiN9 +He uRi u5e <i>%1\$s</i> to 1Nd1CAt3 wh3R3 in +eh ur1 +h3 wIk1woRd sHOUld @pPe@R, 1.3.: <i>h+TP://3n.WIk1P3Di@.oRg/w1kI/%1\$S</i> WOuLD l1Nk yoUr w1k1worDs +0 %s";
$lang['forum_settings_help_33'] = "<b>f0rUm 4cc3S5 s+4+U\$</b> c0NtRoLs how uSerS m@y 4CCe\$\$ y0Ur ph0RuM.";
$lang['forum_settings_help_34'] = "<b>opEN</b> w1ll 4lLOw 4Ll uS3R5 @nD Gu35+s 4Cce\$\$ +0 y0Ur phOrUm w1+h0Ut r3\$+ricT1oN.";
$lang['forum_settings_help_35'] = "<b>clo\$3D</b> Pr3VeN+\$ @cc35\$ fOr alL USerS, WitH +hE 3Xc3p+1On 0ph +He @Dm1N Wh0 M4Y s+Ill @Cc35\$ t3H @dMiN p4N3l.";
$lang['forum_settings_help_36'] = "<b>r3s+rIC+3D</b> @lLOws t0 sET @ L1st 0ph U\$Er5 wh0 ArE @Ll0wEd 4CceS5 to youR PHorUm.";
$lang['forum_settings_help_37'] = "<b>pA\$Sw0Rd pR0t3c+3D</b> 4Ll0w\$ J00 tO \$E+ @ pasSwORD +0 91vE out +0 UsErS s0 th3Y c4N @CC355 Y0uR Ph0rUm.";
$lang['forum_settings_help_38'] = "wHEN 5E++1N9 re\$+R1ct3d 0r p@5\$W0rd PrOt3CtEd mOd3 j00 W1Ll N3ed +0 S4v3 Y0uR Ch4N9e\$ 83pHore J00 C@N cH4n93 tHe uSEr 4Cc3S\$ pRiViL3gE5 oR p@S\$w0Rd.";
$lang['forum_settings_help_39'] = "<b>Search Frequency</b> defines how long a user must wait before performing another search. Searches place a high demand on the database so it is recommended that you set this to at least 30 seconds to prevent \"search spamming\"from KIlLiN9 +he S3rV3R.";
$lang['forum_settings_help_40'] = "<b>p0s+ fReQuENcy</b> 1\$ Th3 M1nimUm +1M3 A U5er Mu\$+ w4It bEFoR3 +hey c@n p05+ 494In. +hI\$ sE++Ing aLs0 @FPH3C+S th3 cRe4+i0n Oph p0LlS. S3+ TO 0 t0 d1Sa8LE tEH rEs+rict1On.";
$lang['forum_settings_help_41'] = "teH 48oV3 0P+i0N\$ cHaNg3 the dEPh@ULt v4lu3S F0r tH3 U\$3R R391\$+r@t1ON PhOrM. wHeR3 4ppl1C@8L3 Oth3R 53++1n9\$ WilL u\$3 +H3 PhoRUM'5 owN deF4Ul+ S3tT1n9\$.";
$lang['forum_settings_help_42'] = "<b>pr3V3nT u5E opH dUPLiC@t3 3mAil 4Ddr3S5e\$</b> PHorcE\$ 83eH1v3 +0 Ch3Ck +Eh uSEr 4CcoUN+\$ @94iN5+ +He Em4Il 4ddR3\$\$ th3 uSEr i\$ r39I\$+er1Ng w1+H 4nD PrOmP+5 tHem t0 U\$e 4nOtH3R iF 1+ 1S 4lRE4dy iN US3.";
$lang['forum_settings_help_43'] = "<b>rEQUiRE 3M4il ConfiRm4TiOn</b> whEn 3n48Led w1ll SENd AN em4il +0 E4ch neW u\$Er Wi+h a L1nk Th@t C4n b3 USeD TO CoNfirm +HE1r EM@iL @dDrE\$s. uN+iL +hEy c0Nf1Rm tH31r EM4IL @ddR3S5 thEY w1LL n0T Be 48Le T0 PO\$+ unlEsS thEIr us3r p3RmIS510nS @r3 ch@N93D ManU4llY BY An 4dM1n.";
$lang['forum_settings_help_44'] = "<b>us3 tExt-C@ptcH@</b> Pr3SeNtS Th3 n3W US3r w1Th 4 m4N9L3D IM@g3 WhiCh +hey mU5+ cOpY @ nUm8Er PhrOm 1nT0 A +eXt f1ElD 0n +eh rEgI\$+r@tiOn f0Rm. U\$E +hI\$ Op+10n t0 pR3vent 4u+Om@+3d S19n-uP V14 ScR1p+5.";
$lang['forum_settings_help_45'] = "<b>t3X+-cap+cH4 d1ReC+ORy</b> \$P3CIFi3s +hE L0C4+ion +H4+ 83eHiV3 WiLl s+0rE It'\$ TeXt-c@P+CH@ 1m@93\$ @nD f0n+s 1n. Th1S DiR3c+0rY mu\$+ 83 WriT@8L3 8y +3h We8 \$eRv3R / Php pRoC3\$\$ @Nd mU\$+ B3 4cC3Ss18L3 v1@ hTtp. 4F+Er j00 H4v3 eNaBl3D T3x+-c4PtCh4 J00 Mus+ uPl04D s0M3 tru3 TYpE phoN+5 inTO +3h f0Nt5 sUb-D1ReC+oRy OPh Your m41N t3Xt-c4PtCh4 d1r3CT0ry OthErWiSe 8EeH1Ve w1lL sKiP +he t3X+-C4p+ch4 dUr1N9 u53r r3GiStR4+iOn.";
$lang['forum_settings_help_46'] = "<b>Text Captcha key</b> allows you to change the key used by Beehive for generating the text captcha code that appears in the image. The more unique you make the key the harder it will be for automated processes to \"guess\"t3h C0dE.";
$lang['forum_settings_help_47'] = "<b>p0\$T eDit 9R4Ce PeRI0D</b> ALlOw\$ J00 To D3pH1n3 @ pErIoD in m1Nu+e\$ Wh3R3 uSERs M@Y Ed1T poST5 wItH0uT t3h 'EDi+3D 8Y' +EX+ 4Ppe4R1Ng On ThEiR Po\$+S. 1f Se+ To 0 +He '3Di+eD BY' +Ex+ Will 4lW4ys @pP34R.";
$lang['forum_settings_help_48'] = "<b>uNRe4D M3\$\$4geS cu+-0PHPh</b> sP3C1fi35 HoW l0n9 M3\$\$4gE\$ r3M@1n Unr34d. +hR34Ds m0D1ph13D nO L@+Er +h4n th3 Per1Od Sel3C+ed W1Ll 4Ut0M4TIc@LlY 4pP3@r 45 RE@d.";
$lang['forum_settings_help_49'] = "cHoo\$iNg <b>d1s4BlE UNr34d meS54Ge\$</b> WIll c0MpLE+eLy ReM0V3 uNr34D M3\$\$A9E\$ \$UPp0Rt @ND R3MOve th3 r3lEV4nt 0P+I0n5 Fr0M +eH D1\$CU551On +Yp3 Dr0p dOwN 0N +hE Thr34D Li\$+.";
$lang['forum_settings_help_50'] = "<b>rEQUiRE U\$3r 4ppr0V@L 8Y 4Dm1n</b> 4lLOw\$ J00 tO r35+RiC+ 4CCe\$\$ By nEw U\$ErS UN+iL Th3y h4V3 Be3n @PpR0v3D 8Y 4 mOD3R@T0r oR 4dmIn. WitH0U+ 4PprOV4l @ u\$ER c4nN0+ 4cCe5S 4Ny 4r34 0ph ThE 833hiV3 PhOrUm 1nS+@LL4+iOn 1nClud1nG 1Nd1vidU4l F0RUmS, Pm 1n80X 4nD My fOrumS 5EcTiOns.";
$lang['forum_settings_help_51'] = "u\$3 <b>cL0S3d mE\$\$4G3</b>, <b>re\$+riC+3d me\$\$4g3</b> 4Nd <b>p455WoRD pR0+ect3D MeSs49E</b> +O CustoM1Se th3 m3\$\$4gE D1SplaY3D When uS3rS 4CCe\$5 Y0uR ph0RuM 1n tEh v4r10U5 s+4+35.";
$lang['forum_settings_help_52'] = "j00 c4N Us3 h+ml 1n y0UR mE\$\$aG35. HyPerL1nK5 4Nd em41l aDdRe\$\$Es wIll 4L\$0 83 4UtOm4+Ic4lly coNv3R+Ed +0 LiNkS. +0 uSe t3h d3Ph@uLt 83EhiVe fOrUm m3S\$4gEs clE4r ThE Ph13ldS.";
$lang['forum_settings_help_53'] = "<b>alL0W USeRs to cH4nGe U5eRnAmE</b> p3rmIt5 4lRe4Dy rEgIs+3r3D U\$ErS to Ch4N9E tH3iR Us3Rn@m3. wH3n 3N4Bl3d j00 CaN +r4Ck +Eh ch4NgEs A uSEr m4k35 to +heir U\$eRn@mE v14 +3H 4dM1N uS3r tOoLs.";
$lang['forum_settings_help_54'] = "u5e <b>fOrUm rUl3\$</b> TO En+eR 4N @CC3pt@8Le uSe p0licY +h@t e4Ch u\$Er mUS+ 49r3E to BefOr3 rEg1\$+Er1nG On yOUR PH0RuM.";
$lang['forum_settings_help_55'] = "j00 C@N U\$3 hTmL 1n yOuR PhOrUm rUle\$. hyPErlInKs @Nd 3m41L 4dDR3S\$3\$ wIll 4lS0 BE 4UtOm4+1c@lLy conv3rt3d tO liNks. T0 U\$E t3h D3f4uL+ 833h1v3 phOruM 4Up ClE4r +hE phI3ld.";
$lang['forum_settings_help_56'] = "u5E <b>nO-rePLy Em4iL</b> TO 5P3cifY 4N 3m41l @DDreSS That D035 NoT Ex1S+ Or wIll nOt BE moN1T0r3D phOr R3Pl13\$. +hIS Em@1L 4DdR3S5 w1Ll 83 U\$ed 1N +hE he4DeR5 fOr 4lL em@1ls SeN+ fRoM Y0uR PhOruM 1nCludIng 8Ut NOt l1MiTed +o p0S+ @Nd Pm N0+Ific@+1ONs, U53R Em4iLS @Nd p@\$5WOrD ReMiNd3RS.";
$lang['forum_settings_help_57'] = "i+ is r3c0mM3nDeD +h4+ j00 u\$e 4n EM41l @DDr3S5 thAt D03\$ nOT Ex15+ To hElP cut d0WN 0N \$p@M +h@T m4y 83 d1rEcT3d 4+ y0uR M4iN Ph0Rum 3m4iL 4Ddr3S5";

// Attachments (attachments.php, get_attachment.php) ---------------------------------------

$lang['aidnotspecified'] = "a1d no+ sp3c1Fi3D.";
$lang['upload'] = "uPLo4D";
$lang['uploadnewattachment'] = "uplo4D n3w 4tTAChm3Nt";
$lang['waitdotdot'] = "waI+..";
$lang['successfullyuploaded'] = "suCcE\$5FuLlY UpL04DeD: %s";
$lang['failedtoupload'] = "f@1L3D tO UplO4D: %s";
$lang['complete'] = "cOMpl3+e";
$lang['uploadattachment'] = "uPLo@d 4 Ph1lE ph0r aTt@chMEn+ tO +3h m3S54g3";
$lang['enterfilenamestoupload'] = "enT3R pHiL3N4ME(\$) +0 UPL0Ad";
$lang['attachmentsforthismessage'] = "a++4chm3nTS FoR +h1\$ m3SsagE";
$lang['otherattachmentsincludingpm'] = "o+Her @+T@chm3NtS (1nClUd1n9 Pm M3s54935 4ND 0THEr f0RuMs)";
$lang['totalsize'] = "t0+@L S1ZE";
$lang['freespace'] = "fR3E \$p4cE";
$lang['attachmentproblem'] = "thERe w4\$ 4 pRO8l3m d0Wnlo4d1Ng TH1s @t+achm3n+. pLE@sE trY 4G41N L4t3R.";
$lang['attachmentshavebeendisabled'] = "aTt4ChMeNts h@v3 8eEn Di\$48l3D by +eH PhORuM 0WN3r.";
$lang['canonlyuploadmaximum'] = "j00 c4N 0Nly uPLo@D 4 m@x1MuM oF 10 fIl3s 4+ @ +im3";
$lang['deleteattachments'] = "deLEtE 4+t4Chm3NtS";
$lang['deleteattachmentsconfirm'] = "arE j00 \$Ur3 J00 w4n+ tO DeL3tE t3H SeL3C+3d att@cHm3nTS?";
$lang['deletethumbnailsconfirm'] = "arE j00 sUrE J00 WaNt +0 DeL3tE ThE \$eLec+eD @t+@Chm3NtS ThUm8N4IL5?";

// Changing passwords (change_pw.php) ----------------------------------

$lang['passwdchanged'] = "p@s\$wOrD Ch@N93d";
$lang['passedchangedexp'] = "y0Ur P@S\$W0Rd h@s 8eEn ch@n9Ed.";
$lang['updatefailed'] = "uPD@te pH41lEd";
$lang['passwdsdonotmatch'] = "p@\$\$W0rD5 Do noT M4+Ch.";
$lang['newandoldpasswdarethesame'] = "n3W 4nd oLD p4\$\$w0RD\$ @rE teH \$4M3.";
$lang['requiredinformationnotfound'] = "rEQu1R3d 1NF0Rm4+iON n0+ f0UNd";
$lang['forgotpasswd'] = "fOR90T p@\$Sw0Rd";
$lang['resetpassword'] = "r3SEt P4s5word";
$lang['resetpasswordto'] = "r35ET p@\$Sw0Rd TO";
$lang['invaliduseraccount'] = "inV@liD u5eR 4Cc0uN+ Sp3ciPhi3D. CheCk 3m4Il fOR COrrEcT L1NK";
$lang['invaliduserkeyprovided'] = "iNV@l1D US3r kEy PR0V1DEd. cH3cK em@1L F0r c0RrEC+ l1Nk";

// Deleting messages (delete.php) --------------------------------------

$lang['nomessagespecifiedfordel'] = "n0 M3s54g3 SPeC1FIeD For DeL3t10n";
$lang['deletemessage'] = "d3le+E MeSs4g3";
$lang['postdelsuccessfully'] = "p0\$+ Del3t3D SuCc35sFuLLy";
$lang['errordelpost'] = "erR0R dEL3T1N9 P05+";
$lang['cannotdeletepostsinthisfolder'] = "j00 cAnNoT dEl3+3 p0S+S 1N +h1\$ PhOLD3r";

// Editing things (edit.php, edit_poll.php) -----------------------------------------

$lang['nomessagespecifiedforedit'] = "n0 MeSS@9e Sp3c1fiED pH0r eDit1n9";
$lang['cannoteditpollsinlightmode'] = "c4NNOt EDit poLls In LiGh+ Mod3";
$lang['editedbyuser'] = "eD1+3d: %s bY %s";
$lang['editappliedtomessage'] = "eDIT 4ppLi3D TO mEs\$4gE";
$lang['errorupdatingpost'] = "eRr0R UpD@T1N9 p0st";
$lang['editmessage'] = "ed1T M3S\$4Ge %s";
$lang['editpollwarning'] = "<b>no+3</b>: 3di+in9 cERt@1N @sP3cT5 OF a PoLl w1LL v01D all t3h CurR3nT v0+Es 4nd @lLoW P30PLE +0 v0+3 4g41n.";
$lang['hardedit'] = "h4Rd 3dIT 0pTi0n5 (V0t3S W1ll 83 Re\$e+):";
$lang['softedit'] = "soPhT 3Dit 0P+i0N\$ (VoT3S will Be rEt@1Ned):";
$lang['changewhenpollcloses'] = "ch@N9e wH3n +EH P0LL cLoseS?";
$lang['nochange'] = "nO cH4Ng3";
$lang['emailresult'] = "eM41L R3\$uL+";
$lang['msgsent'] = "m3s54GE SEnT";
$lang['msgsentsuccessfully'] = "meS54Ge SEnT \$uCce\$\$FULly.";
$lang['mailsystemfailure'] = "m@il \$Y\$T3m pH@1luR3. Me\$\$4gE NoT \$3nT.";
$lang['nopermissiontoedit'] = "j00 @rE N0t pErM1++eD To edIT THI\$ M3S54gE.";
$lang['cannoteditpostsinthisfolder'] = "j00 c@nnoT EdIt p05Ts iN th1S pHoLd3R";
$lang['messagewasnotfound'] = "m355@g3 %s W4\$ not f0UnD";

// Email (email.php) ---------------------------------------------------

$lang['sendemailtouser'] = "send 3m4Il +0 %s";
$lang['nouserspecifiedforemail'] = "n0 USeR \$pEc1fi3D ph0r eM4iL1n9.";
$lang['entersubjectformessage'] = "ent3r a sUbJeCt fOr +he mE\$\$4Ge";
$lang['entercontentformessage'] = "eNt3r soM3 c0N+Ent pH0r +Eh mEsS4ge";
$lang['msgsentfromby'] = "tH1S ME\$54g3 w@S sEn+ Phr0M %s By %s";
$lang['subject'] = "su8J3CT";
$lang['send'] = "s3Nd";
$lang['userhasoptedoutofemail'] = "%s h45 opTEd ou+ Of 3M@1L C0nt@c+";
$lang['userhasinvalidemailaddress'] = "%s H45 @N iNv@l1D em4il 4ddr35\$";

// Message nofificaiton ------------------------------------------------

$lang['msgnotification_subject'] = "m35\$4GE N0t1PHIcAt1On fRoM %s";
$lang['msgnotificationemail'] = "h3ll0 %s,\n\n%s p0StEd 4 M3S54gE t0 j00 0n %s.\n\nth3 sUbJ3ct i\$: %s.\n\nto r34d Th@+ meSs@gE 4ND OtH3rs in +hE S4m3 dI\$Cu5\$10n, go t0:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nNOT3: 1F j00 Do n0T wi\$H t0 REc3IV3 Em@iL NoT1FiC4+1OnS Oph phOrUm M3S54Ge\$ p0s+Ed tO YoU, 90 tO: %s Cl1Ck oN My COntR0l\$ THeN Em4il 4ND PrIv@cY, un\$3lECt tH3 em4il N0T1fIcAT10N Ch3Ck80X 4ND Pre\$5 SU8m1T.";

// Thread Subscription notification ------------------------------------

$lang['subnotification_subject'] = "suBScR1PT10n NotIpH1c4+i0N From %s";
$lang['subnotification'] = "heLLO %s,\n\n%s P0\$TED 4 Mes54G3 In 4 +hre@d J00 h@V3 sUb\$cr1BEd T0 0n %s.\n\n+H3 su8JEct i\$: %s.\n\n+0 rE4d +h4+ m3S54ge AnD OThEr\$ 1n +3h S4Me d1SCuS\$1on, 9o T0:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nn0+e: 1Ph j00 D0 not wiSh to rEc31ve eM@iL NO+IFiC4+I0NS 0f N3w M3S54ge\$ iN +HiS THR34d, 9o +0: %s 4nD @dJUs+ YOur 1Nt3r3\$+ lEv3L @t +3h 8O+TOm 0f +eh P@G3.";

// PM notification -----------------------------------------------------

$lang['pmnotification_subject'] = "pM no+1fic4T1oN pHR0m %s";
$lang['pmnotification'] = "h3LlO %s,\n\n%s Po5+3D 4 PM t0 J00 0n %s.\n\n+he SU8Jec+ 1s: %s.\n\nTO r34d +H3 m3\$54G3 9o tO:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nnO+3: 1f j00 Do No+ W1SH t0 receiV3 3M4il NOt1FIc4T1ON\$ OPH N3w pM m3sS4ges Po5ted +0 Y0U, 9O +0: %s cLICk MY c0N+R0lS +hen EM41l 4nd Pr1v4Cy, uN\$3L3c+ THE Pm N0T1fIc4+1On cHeCk80X and pr3S5 SU8M1+.";

// Password change notification ----------------------------------------

$lang['passwdchangenotification'] = "p@\$5W0rd Ch@ngE noT1ficAt1On PHr0m %s";
$lang['pwchangeemail'] = "h3llO %s,\n\n+His 4 noT1f1C4+i0n em4Il +0 inForm J00 TH4+ yOUR P45\$wOrD 0N %s h45 833N cH4Ng3D.\n\nIt H4S 8E3n CH4NgEd T0: %s 4nD W@S Ch@n93D bY: %s.\n\n1f J00 H4ve rEC3Iv3D ThIs 3M@iL in ErROr OR wEre noT eXP3c+inG 4 ch4Nge to yoUR P4\$5w0Rd PlE45E COn+4Ct +h3 fOrUM oWn3R 0r @ m0DeR4tOr oN %s ImM3DI@+3lY tO coRrect i+.";

// Email confirmation notification -------------------------------------

$lang['emailconfirmationrequiredsubject'] = "eM@1l coNpH1rM@tI0N reQU1r3d for %s";
$lang['confirmemail'] = "h3LL0 %s,\n\ny0U r3c3n+Ly Cr34t3d 4 n3w usER 4Cc0Un+ On %s.\n83pH0Re J00 c4N \$tAR+ pOsT1Ng W3 nEeD tO cOnfirM YoUR 3m41l 4DdR3s5. D0n'+ w0Rry tH1s 15 QuIt3 e4SY. @ll j00 nEed tO DO I\$ cLick t3H l1Nk BEloW (Or coPy AnD P4St3 1T in+0 Y0uR 8R0WsER):\n\n%s\n\n0Nce C0npH1Rm4+i0n iS coMPl3+e j00 m@Y lo9in @nD sT4r+ P0S+1NG iMm3Di@t3lY.\n\nIf j00 did nOT cR34+e 4 USEr @cC0uNt 0n %s pLe@sE 4CCep+ OUr 4P0l09I35 4nD pHoRw4Rd +hI\$ eM@Il +O %s S0 +hAT +HE \$0uRcE 0PH it M4y 8e iNvE\$+i94+3D.";
$lang['confirmchangedemail'] = "hElL0 %s,\n\nY0u rECEnTlY ChaNg3D Y0Ur 3M4il 0N %s.\n8eF0Re j00 c4n s+@r+ pOs+1n9 49AiN W3 neEd +0 C0nPh1rm y0Ur NeW 3M@1l 4DDr3S5. d0N'+ wOrRy tH1\$ I5 QuI+E 34\$Y. 4lL j00 n3ED +0 D0 1S Cl1Ck tH3 LInk bELow (oR copY @nD P@S+E It iN+0 Y0Ur 8rowSEr):\n\n%s\n\noNcE c0nPh1Rm4+10n Is cOmPl3+e j00 MaY conT1Nue t0 use +He fOrUm 45 NoRM4l.\n\n1F j00 Were N0T eXPecT1ng tHi\$ 3m4Il frOm %s pLe4Se 4cc3P+ 0uR @pOlO9Ie\$ @Nd f0rW4rd +hiS Em4Il +0 %s S0 +h4T Th3 SOuRce OpH It m@Y 8E 1NvE\$+IG@t3D.";

// Forgotten password notification -------------------------------------

$lang['forgotpwemail'] = "h3ll0 %s,\n\nY0u r3Qu3S+3d +hIs e-M@1l pHr0m %s 83c@u5e j00 H4vE PhOR9oTT3n YoUR p45\$W0Rd.\n\nClIcK +3h l1nk belOw (oR C0Py 4Nd P@s+E It In+O y0uR bROw5Er) tO r3\$e+ y0uR P4\$5Word:\n\n%s";

// Admin New User notification -----------------------------------------

$lang['newuserregistrationsubject'] = "neW Us3R 4CC0unT NoT1fICat10n F0r %s";
$lang['newuserregistrationemail'] = "Hello %s,\n\nA new user account has been created on %s.\n\nAs you are an Administrator of this forum you are required to approve this user account before it can be used by it's owner.\n\nTo approve this account please visit the Admin Users section and change the filter type to \"Users Awaiting Approval\"0R CLicK +he lInK 8ElOw:\n\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nnoT3: 0+HeR @dM1nIs+R4torS 0N thI\$ fOrum wiLL @L50 rec3Iv3 tH1S noT1fICat1On aNd m4Y H@V3 AlR34dY 4C+ed uPOn TH1s R3Que\$t.";

// User Approved notification ------------------------------------------

$lang['useraccountapprovedsubject'] = "uSER 4PPr0V4l N0+1Ph1c@tIoN Ph0R %s";
$lang['useraccountapprovedemail'] = "hEllO %s,\n\nY0uR US3r aCc0Unt 4+ %s h4S b33n @PPrOvEd. J00 C4n lo9in 4Nd St@R+ POST1N9 1mm3Di4TLy 8Y cL1ck1nG +3h LiNk bElOw:\n\n%s\n\n1pH J00 wer3 Not 3Xp3CtIn9 +h1\$ Em4Il FroM %s pL34\$3 4Cc3p+ our @pOL09ie\$ @nD pHorw4rD Th1\$ Em@1l +0 %s s0 +h4+ TeH 50Urc3 oPH 1T M4y 8E 1Nv3\$+194+Ed.";

// Admin Post Approval notification -----------------------------------------

$lang['newpostapprovalsubject'] = "pOS+ 4PpR0V4l N0+1pHIC4+10n pHor %s";
$lang['newpostapprovalemail'] = "hellO %s,\n\n@ N3W pO\$+ h@5 83En cR34tEd 0N %s.\n\n4\$ J00 4r3 4 mOD3r@T0r oN thI5 Ph0RuM j00 @r3 ReqU1r3d t0 4pPR0v3 +HI\$ p0St 8Ef0rE iT c@n b3 re4D 8Y Other u\$eR5.\n\nYoU c4N aPpRoVE +his pO\$+ @nD 4Ny 0tH3rS p3NdiN9 @PPr0v4l 8Y V1Si+iNg +hE AdMiN po\$+ 4pPRoV4l s3C+i0N Of y0UR pHoRuM or bY cl1Ck1N9 T3h LiNk 8elOw:\n\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nNotE: oTh3R AdMiN1\$Tr4+0Rs oN +Hi\$ FoRUm Will 4lS0 ReC31vE +HiS nOtIFiC4+10N @nD m@y h@vE 4LReAdy @c+ed uP0N +h1\$ REQu3S+.";

// Forgotten password form.

$lang['passwdresetrequest'] = "y0ur p455WoRd R3s3t r3QUeS+ fr0M %s";
$lang['passwdresetemailsent'] = "p4s\$W0rD R3SeT 3-m41L \$EnT";
$lang['passwdresetexp'] = "j00 \$houLd ShOr+ly reC3iV3 4N 3-m41L CoN+41n1n9 iN5trucT10nS ph0R R3S3tt1Ng y0Ur P@\$\$w0Rd.";
$lang['validusernamerequired'] = "a V4l1D U\$3Rn@M3 i\$ ReQU1r3D";
$lang['forgottenpasswd'] = "f0rgOt p4sswOrD";
$lang['couldnotsendpasswordreminder'] = "c0uLD n0T sENd p@s\$W0Rd R3m1Nd3R. plE4\$e c0NT4C+ t3H Ph0RUm OwNeR.";
$lang['request'] = "reQU3S+";

// Email confirmation (confirm_email.php) ------------------------------

$lang['emailconfirmation'] = "eM4IL cOnfirm4+I0n";
$lang['emailconfirmationcomplete'] = "tH@Nk J00 PhoR c0nPhirMiNg Y0UR 3M41l 4DDr3\$\$. J00 m4y n0w LoGin 4nd St4Rt pos+iN9 Imm3D14+eLy.";
$lang['emailconfirmationfailed'] = "eMAil ConPHirm4+1On H4\$ f@iLeD, pLE4\$e trY 4G41n l4+er. Iph j00 3nC0Un+er tHi\$ 3Rr0r mUl+iPlE +1m3\$ pLe@Se C0nT@c+ TH3 pH0rUm 0wN3r 0r @ m0D3r4+0r PhoR 4\$\$1S+4Nc3.";

// Links database (links*.php) -----------------------------------------

$lang['toplevel'] = "t0P LEvEl";
$lang['maynotaccessthissection'] = "j00 m4Y nO+ 4cC3S5 Th1S \$eCT1on.";
$lang['toplevel'] = "t0P lEVel";
$lang['links'] = "l1nK\$";
$lang['viewmode'] = "v13W mOD3";
$lang['hierarchical'] = "hi3R@rcHiC4L";
$lang['list'] = "l1s+";
$lang['folderhidden'] = "tH15 pH0ld3R 1S hiDd3N";
$lang['hide'] = "h1D3";
$lang['unhide'] = "uNhIde";
$lang['nosubfolders'] = "nO sU8Ph0lDeRS 1n +h1S c4+eG0rY";
$lang['1subfolder'] = "1 \$u8Ph0LDEr iN Th1S c4+eG0rY";
$lang['subfoldersinthiscategory'] = "su8fOLdeRs iN Th1s cAt3gOry";
$lang['linksdelexp'] = "en+R13S iN 4 Del3t3D phOLdeR W1Ll 8E m0v3d t0 +hE P4r3nT Ph0lDEr. 0NlY pHoLd3Rs wH1cH D0 NoT CoN+4In sU8F0lDeR\$ m@y 8e d3L3+eD.";
$lang['listview'] = "l15+ vI3W";
$lang['listviewcannotaddfolders'] = "c@nn0T 4Dd FolD3rs 1n tH1S v1ew. sHOWiN9 20 3N+rI3\$ 4+ @ +1M3.";
$lang['rating'] = "r4T1ng";
$lang['nolinksinfolder'] = "n0 LInk5 iN tH1s ph0LdEr.";
$lang['addlinkhere'] = "adD l1Nk HeR3";
$lang['notvalidURI'] = "th@+ 1S No+ 4 V@LiD UrI!";
$lang['mustspecifyname'] = "j00 mUs+ Sp3C1pHy 4 n@mE!";
$lang['mustspecifyvalidfolder'] = "j00 mUs+ \$pEc1Fy 4 vaLID phOLdeR!";
$lang['mustspecifyfolder'] = "j00 mUS+ SpeC1fy @ PhOlDEr!";
$lang['successfullyaddedlinkname'] = "sUcCEs\$phUlLy 4ddEd l1nK '%s'";
$lang['failedtoaddlink'] = "faIl3D TO 4Dd lInK";
$lang['failedtoaddfolder'] = "f@Il3D To 4dD PhOlDEr";
$lang['addlink'] = "aDD 4 L1nK";
$lang['addinglinkin'] = "aDDiN9 L1nk In";
$lang['addressurluri'] = "aDdReS\$";
$lang['addnewfolder'] = "adD @ new F0ldEr";
$lang['addnewfolderunder'] = "aDD1ng N3w PH0lD3R uND3r";
$lang['editfolder'] = "eDIt PHoLder";
$lang['editingfolder'] = "eD1+1n9 F0LdeR";
$lang['mustchooserating'] = "j00 muS+ Ch0Os3 4 r@+inG!";
$lang['commentadded'] = "your C0Mm3n+ W@S ADdeD.";
$lang['commentdeleted'] = "coMmEN+ W45 d3Let3D.";
$lang['commentcouldnotbedeleted'] = "cOMMent CoUlD no+ be d3L3+eD.";
$lang['musttypecomment'] = "j00 mU\$+ TyPe @ C0mmEnT!";
$lang['mustprovidelinkID'] = "j00 muS+ PROViD3 4 l1Nk 1D!";
$lang['invalidlinkID'] = "iNV4lId lInK Id!";
$lang['address'] = "addRE\$5";
$lang['submittedby'] = "sU8M1++3d bY";
$lang['clicks'] = "clIcKs";
$lang['rating'] = "r@+iNG";
$lang['vote'] = "v0+E";
$lang['votes'] = "v0+e\$";
$lang['notratedyet'] = "n0+ R4+Ed 8y 4nYoN3 ye+";
$lang['rate'] = "r@te";
$lang['bad'] = "b4D";
$lang['good'] = "gOOD";
$lang['voteexcmark'] = "v0t3!";
$lang['clearvote'] = "cl3@r VoT3";
$lang['commentby'] = "c0mM3nT BY %s";
$lang['addacommentabout'] = "add 4 C0mmenT 4B0uT";
$lang['modtools'] = "moD3r@t10N +O0L\$";
$lang['editname'] = "ed1+ N@mE";
$lang['editaddress'] = "edI+ @DdRe\$\$";
$lang['editdescription'] = "eDIt d3\$Cr1PTi0n";
$lang['moveto'] = "m0ve +0";
$lang['linkdetails'] = "liNk D3+41lS";
$lang['addcomment'] = "adD C0Mm3Nt";
$lang['voterecorded'] = "y0ur v0+3 H@S 8eeN rEcOrDeD";
$lang['votecleared'] = "y0Ur v0t3 H45 8Een cL34R3D";
$lang['linknametoolong'] = "l1Nk n@m3 T00 lON9. m4XiMuM Is %s cH@R@c+3r5";
$lang['linkurltoolong'] = "linK Url +0o Lon9. m4XimUM iS %s ChAr4C+eR5";
$lang['linkfoldernametoolong'] = "f0LdEr n4mE t0O L0n9. m4XiMuM leNGtH i\$ %s Ch4R4cT3Rs";

// Login / logout (llogon.php, logon.php, logout.php) -----------------------------------------

$lang['loggedinsuccessfully'] = "j00 lOg93D 1N 5UccES5FuLLy.";
$lang['presscontinuetoresend'] = "pR3SS C0ntiNue To R35eNd f0Rm D@+4 OR C4NC3L +0 R3lO@d p@g3.";
$lang['usernameorpasswdnotvalid'] = "tH3 usErN4mE Or P4\$5w0Rd j00 sUPPlI3d 1\$ NoT v4l1D.";
$lang['rememberpasswds'] = "reMEmbEr p@5\$w0RdS";
$lang['rememberpassword'] = "rem3Mb3R P4SSW0rd";
$lang['enterasa'] = "eN+ER 4S 4 %s";
$lang['donthaveanaccount'] = "dON'+ H4Ve @N 4Cc0UN+? %s";
$lang['registernow'] = "r391S+Er N0w.";
$lang['problemsloggingon'] = "prObL3m5 L0G9In9 oN?";
$lang['deletecookies'] = "d3L3+E C0Ok1Es";
$lang['cookiessuccessfullydeleted'] = "c00K1Es sUcCe\$5FulLy d3L3+Ed";
$lang['forgottenpasswd'] = "fORgOtt3n YOur p45\$W0rD?";
$lang['usingaPDA'] = "u51ng @ pD@?";
$lang['lightHTMLversion'] = "l19H+ hTmL v3RsI0n";
$lang['youhaveloggedout'] = "j00 h4Ve lOgGeD 0Ut.";
$lang['currentlyloggedinas'] = "j00 4r3 CurREn+lY l099Ed 1n 4\$ %s";
$lang['logonbutton'] = "l0goN";
$lang['otherbutton'] = "oTH3r";
$lang['yoursessionhasexpired'] = "y0UR S3S5I0N H@5 eXp1r3D. J00 wiLl nEeD +0 Lo91N 4g@1n +0 CoNt1nU3.";

// My Forums (forums.php) ---------------------------------------------------------

$lang['myforums'] = "mY Forum\$";
$lang['allavailableforums'] = "aLL 4v@il48l3 FOrUmS";
$lang['favouriteforums'] = "f@V0UrIt3 ForuMs";
$lang['ignoredforums'] = "i9n0Red PhOrum\$";
$lang['ignoreforum'] = "igNORe fORuM";
$lang['unignoreforum'] = "uN1gNor3 phORum";
$lang['lastvisited'] = "lA\$+ v1\$i+ed";
$lang['forumunreadmessages'] = "%s UnrE4D m3\$\$4Ge\$";
$lang['forummessages'] = "%s M35\$4Ges";
$lang['forumunreadtome'] = "%s unR3@D &quot;To: m3&quot;";
$lang['forumnounreadmessages'] = "n0 uNRE4D M3\$5@G3S";
$lang['removefromfavourites'] = "r3moV3 Phr0M Ph@V0uRiT3\$";
$lang['addtofavourites'] = "add To ph4V0Ur1+E\$";
$lang['availableforums'] = "aV@1l@8l3 fOrUM\$";
$lang['noforumsofselectedtype'] = "tH3re are No PhOrumS Of +He Sel3Ct3D +YP3 4V4iL@8L3. pLE4\$3 SEl3Ct 4 d1FfER3nT +yp3.";
$lang['successfullyaddedforumtofavourites'] = "suCCes5FulLy 4Dd3D foRum tO pH@Vourit3\$.";
$lang['successfullyremovedforumfromfavourites'] = "sUCc3S5fUlLY r3MoV3d pHORuM FRoM F4voUriT3\$.";
$lang['successfullyignoredforum'] = "sUcc3\$sPhUlLY 19n0ReD Ph0RuM.";
$lang['successfullyunignoredforum'] = "succEs\$pHUlLy Un19nOR3D PhoRuM.";
$lang['failedtoupdateforuminterestlevel'] = "faILeD to UpD@+e FOrUm 1nt3R35+ LeVel";
$lang['noforumsavailablelogin'] = "thER3 4r3 nO Ph0RuMs @v@IL@8L3. pL34\$e l09in +0 v1EW y0UR PhORuMs.";
$lang['passwdprotectedforum'] = "p4ssW0rD PrO+ECteD Ph0rUM";
$lang['passwdprotectedwarning'] = "tH15 pHORuM 1S P@S\$w0Rd ProtEc+3D. +0 94in 4Cc3\$\$ Ent3R +3H P4\$5W0rD beL0w.";

// Message composition (post.php, lpost.php) --------------------------------------

$lang['postmessage'] = "p05+ M3S54Ge";
$lang['selectfolder'] = "sEL3ct folder";
$lang['mustenterpostcontent'] = "j00 mU\$t Ent3R 50Me c0nT3Nt PHOR tH3 p05T!";
$lang['messagepreview'] = "m3s\$4GE pR3VI3W";
$lang['invalidusername'] = "inV@l1D UsErNaMe!";
$lang['mustenterthreadtitle'] = "j00 mU\$T Ent3r 4 +iTle fOr tH3 +hRe4D!";
$lang['pleaseselectfolder'] = "plE@SE SeL3C+ A pH0Ld3R!";
$lang['errorcreatingpost'] = "erR0R CReaTIng p0S+! Ple4Se +Ry 4g4In iN @ PhEW m1Nu+E\$.";
$lang['createnewthread'] = "cRE@T3 nEw +hr34D";
$lang['postreply'] = "pO5+ r3Ply";
$lang['threadtitle'] = "tHRE@d +1TlE";
$lang['messagehasbeendeleted'] = "me\$\$493 N0+ FouND. ChEcK +h@t iT H4sn'T BE3n D3L3t3D.";
$lang['messagenotfoundinselectedfolder'] = "mES\$4gE n0T F0uNd 1N 5El3CT3d Ph0lDer. CH3cK +h4t i+ haSN'T beEn M0v3d 0r dElE+Ed.";
$lang['cannotpostthisthreadtypeinfolder'] = "j00 C@Nnot p0\$+ tH1s +hre4D tyP3 In +H4t PH0ld3r!";
$lang['cannotpostthisthreadtype'] = "j00 CannOT P0\$+ th1S tHRe4d +yPE @s tHeR3 @r3 n0 4v41L4bLE pHOlDeRs tH4+ @LlOw 1t.";
$lang['cannotcreatenewthreads'] = "j00 cANnoT Cr34+e nEw THrE4d\$.";
$lang['threadisclosedforposting'] = "th1\$ Thre4d 1S Cl05Ed, j00 c@nn0T Po\$+ iN i+!";
$lang['moderatorthreadclosed'] = "warn1n9: tHiS +HrE4D 1s clO\$ED PhOr P0s+iN9 TO n0RM@l USerS.";
$lang['usersinthread'] = "usERs iN +hre4D";
$lang['correctedcode'] = "corR3CT3D C0D3";
$lang['submittedcode'] = "suBmi++eD COd3";
$lang['htmlinmessage'] = "h+ML In m3\$5@G3";
$lang['disableemoticonsinmessage'] = "dis4BL3 3M0tIC0Ns 1N m3S5493";
$lang['automaticallyparseurls'] = "aut0M@+1C4lLy p4r\$e uRlS";
$lang['automaticallycheckspelling'] = "aUt0M@+1c4lly ChEck \$PelL1N9";
$lang['setthreadtohighinterest'] = "s3+ +hr34D T0 H19H In+3rESt";
$lang['enabledwithautolinebreaks'] = "eN@8l3D WiTh 4uT0-LiN3-8r34K\$";
$lang['fixhtmlexplanation'] = "tHIs PhORuM UseS HTMl fIl+Er1NG. Y0uR 5U8Mit+3d hTmL H4\$ 8eEn m0d1ph13d 8y +Eh ph1l+3Rs 1n 5omE W4y.\\n\\nTO vIeW Your ORigIN@l c0d3, s3L3Ct +H3 \\'5U8mI++eD C0dE\\' r@D1O 8U+toN.\\nTo vIeW +h3 mOd1FI3d cOD3, Sel3C+ +eH \\'cOrReC+3D COd3\\' r4D10 BuTtOn.";
$lang['messageoptions'] = "m3s\$49e 0p+1ONs";
$lang['notallowedembedattachmentpost'] = "j00 4r3 nOt 4Ll0w3D To eM8eD Att@chmeNt5 1N Y0Ur poS+\$.";
$lang['notallowedembedattachmentsignature'] = "j00 @r3 n0+ 4ll0W3D t0 embEd 4++4cHm3Nt5 IN Your s19Natur3.";
$lang['reducemessagelength'] = "mEs54gE lEng+h Mu\$+ B3 Und3R 65,535 Ch4R4C+eRs (CuRR3N+LY: %s)";
$lang['reducesiglength'] = "s19n4TuRE Leng+H MuS+ 83 UNDEr 65,535 ch4R@c+3RS (cUrreNtly: %s)";
$lang['cannotcreatethreadinfolder'] = "j00 c4nn0+ cR34t3 n3w Thr34D5 1N +HiS PH0LdEr";
$lang['cannotcreatepostinfolder'] = "j00 C@Nn0T RePlY +o pO\$+5 In +HiS F0lD3r";
$lang['cannotattachfilesinfolder'] = "j00 C4NnOt PO\$+ 4Tt4ChMeNTs 1n Th1s foLder. r3M0vE 4tT@chm3N+\$ To conT1nU3.";
$lang['postfrequencytoogreat'] = "j00 cAN OnLy PoSt 0NcE 3V3rY %s \$3c0nd\$. Pl345e tRy 494iN L4+Er.";
$lang['emailconfirmationrequiredbeforepost'] = "eM41L CoNPhIrMA+i0N iS r3Qu1R3d 8eFOR3 J00 c@N p05+. iF J00 H4ve N0T r3Ceiv3D @ c0nFiRm4t10N Em4il PlE4Se Cl1Ck +Eh BUtTOn b3L0w 4Nd 4 N3w On3 W1Ll 8e sENt +0 Y0U. 1F Y0Ur 3M@1L 4ddresS n3ed\$ Ch4NgiN9 Pl34se Do \$O BeFoRe rEqU3St1Ng 4 n3W c0NpH1Rm@+1On 3m@IL. j00 mAy CH@n9E y0uR 3M4iL 4DdR3\$\$ bY Cl1Ck mY c0ntR0L5 @8ovE @nd Th3n u\$eR d3+4Ils";
$lang['emailconfirmationfailedtosend'] = "conph1rM4+I0n eM4il pH4iLeD To sEnd. pl34\$E C0nTaC+ Th3 ForUm OwNeR To r3C+ify +HiS.";
$lang['emailconfirmationsent'] = "conFiRmatI0n 3M4iL h4s 8EeN Re\$eN+.";
$lang['resendconfirmation'] = "r3s3Nd c0nPhIRM4+Ion";
$lang['userapprovalrequiredbeforeaccess'] = "y0ur uSeR 4cC0uN+ nE3d5 T0 Be @Pprov3D bY 4 fOrum ADm1n bEf0Re j00 C4n @Cc3\$s +he rEqU3St3D Ph0RuM.";

// Message display (messages.php & messages.inc.php) --------------------------------------

$lang['inreplyto'] = "in RePlY +0";
$lang['showmessages'] = "sHow mEsS4ge\$";
$lang['ratemyinterest'] = "r4t3 mY 1NT3rest";
$lang['adjtextsize'] = "aDJuS+ t3X+ 51z3";
$lang['smaller'] = "smaLlEr";
$lang['larger'] = "l@r93r";
$lang['faq'] = "f4q";
$lang['docs'] = "d0C5";
$lang['support'] = "sUPpOr+";
$lang['donateexcmark'] = "dONate!";
$lang['fontsizechanged'] = "fon+ 5iz3 cH4NgEd. %s";
$lang['framesmustbereloaded'] = "fR4Me\$ Mu5+ 83 ReLO@D3d m@nu4LlY +0 5Ee Ch4ng3\$.";
$lang['threadcouldnotbefound'] = "th3 R3qU3\$+ed thrE@D cOUlD n0T 83 phOUnD Or 4cce\$\$ W@S D3nIed.";
$lang['mustselectpolloption'] = "j00 mUs+ selEC+ 4N 0P+IoN +0 VOte pHor!";
$lang['mustvoteforallgroups'] = "j00 mU\$T vOT3 In evErY 9rOUp.";
$lang['keepreading'] = "k33P R34DiNg";
$lang['backtothreadlist'] = "b@Ck +0 tHr3Ad L1\$+";
$lang['postdoesnotexist'] = "th4+ p0\$+ dOeS noT eXiS+ 1n thi\$ +HrE4d!";
$lang['clicktochangevote'] = "cLICk +0 CH4ngE V0t3";
$lang['youvotedforoption'] = "j00 V0t3d pHOr OP+i0N";
$lang['youvotedforoptions'] = "j00 VO+Ed foR 0P+iONs";
$lang['clicktovote'] = "cLIcK +0 v0t3";
$lang['youhavenotvoted'] = "j00 h4V3 NoT v0T3D";
$lang['viewresults'] = "vI3W REsUlT5";
$lang['msgtruncated'] = "m3S\$4gE TrUnC4+Ed";
$lang['viewfullmsg'] = "v1ew FulL MEs54gE";
$lang['ignoredmsg'] = "i9N0rEd m3\$5@G3";
$lang['wormeduser'] = "w0rM3D us3R";
$lang['ignoredsig'] = "ignOred 519n4tURE";
$lang['messagewasdeleted'] = "m3S\$4GE %s.%s W@S DeL3+ed";
$lang['stopignoringthisuser'] = "s+0P i9NoR1n9 THi5 useR";
$lang['renamethread'] = "reN4mE ThrE@d";
$lang['movethread'] = "moVe tHr34D";
$lang['torenamethisthreadyoumusteditthepoll'] = "t0 r3n4mE +H1S Thre4D j00 mUS+ edI+ Th3 P0Ll.";
$lang['closeforposting'] = "cloSe for pOs+iNg";
$lang['until'] = "unTIl 00:00 U+c";
$lang['approvalrequired'] = "appr0V4l ReQuIrEd";
$lang['messageawaitingapprovalbymoderator'] = "mes\$493 %s.%s 1\$ 4wAiTin9 4pPr0V4l by @ m0DeR@ToR";
$lang['postapprovedsuccessfully'] = "p0ST 4pPRov3D SUCc3\$\$pHUllY";
$lang['postapprovalfailed'] = "p05+ @pProV4L PhA1L3d.";
$lang['postdoesnotrequireapproval'] = "pos+ Do3\$ N0t R3qUir3 aPProv@l";
$lang['approvepost'] = "aPPR0Ve p05+";
$lang['approvedbyuser'] = "apPR0ved: %s By %s";
$lang['makesticky'] = "m@Ke s+1cKy";
$lang['messagecountdisplay'] = "%s 0F %s";
$lang['linktothread'] = "pErm4N3Nt l1NK +0 +hIs +Hr34D";
$lang['linktopost'] = "liNk +0 POs+";
$lang['linktothispost'] = "link +0 thI\$ p0\$+";
$lang['imageresized'] = "thI\$ 1m4gE h4\$ 833n rE\$Iz3D (0r19iNaL \$izE %1\$\$x%2\$5). tO viEw +He pHuLl-\$IZ3 ImA9e CliCk h3Re.";
$lang['messagedeletedbyuser'] = "mes\$4gE %s.%s d3L3t3D %s by %s";
$lang['messagedeleted'] = "mes54gE %s.%s W4\$ D3Let3D";

// Moderators list (mods_list.php) -------------------------------------

$lang['cantdisplaymods'] = "c4NNot Displ@y f0LdEr mOD3r4tORs";
$lang['moderatorlist'] = "m0DER@+0R l1S+:";
$lang['modsforfolder'] = "m0D3R4t0R5 F0r Fold3r";
$lang['nomodsfound'] = "n0 m0d3raTOrS pHOund";
$lang['forumleaders'] = "f0RUm lE@D3rS:";
$lang['foldermods'] = "f0LDeR MoDer4ToR5:";

// Navigation strip (nav.php) ------------------------------------------

$lang['start'] = "s+4Rt";
$lang['messages'] = "m3S549Es";
$lang['pminbox'] = "iN80X";
$lang['startwiththreadlist'] = "s+@r+ P@9E w1Th +Hr34d l1s+";
$lang['pmsentitems'] = "seNT 1+eM\$";
$lang['pmoutbox'] = "oU+B0x";
$lang['pmsaveditems'] = "s@vED 1t3Ms";
$lang['pmdrafts'] = "dr4FtS";
$lang['links'] = "l1NkS";
$lang['admin'] = "admIn";
$lang['login'] = "l0giN";
$lang['logout'] = "loG0u+";

// PM System (pm.php, pm_write.php, pm.inc.php) ------------------------

$lang['privatemessages'] = "pRIvAt3 Me\$\$4gES";
$lang['recipienttiptext'] = "seP4R@t3 rEcIp13NtS bY \$Emi-CoLoN 0R c0Mm4";
$lang['maximumtenrecipientspermessage'] = "tHErE 1S @ LIm1t 0f 10 R3C1p13N+\$ pEr mE\$\$4gE. plE4\$e Amend YoUr R3CiP13N+ LI\$+.";
$lang['mustspecifyrecipient'] = "j00 mUst \$PEc1Phy 4t lE@S+ On3 rEcIpieN+.";
$lang['usernotfound'] = "u\$3R %s N0T f0uNd";
$lang['sendnewpm'] = "s3Nd New pM";
$lang['savemessage'] = "s@v3 m3SS4ge";
$lang['timesent'] = "t1Me sEnT";
$lang['errorcreatingpm'] = "eRR0R Cr3aT1nG Pm! Pl34s3 +rY 494iN 1N 4 fEw m1nu+e\$";
$lang['writepm'] = "wRi+3 m3SS4gE";
$lang['editpm'] = "eD1T MeSS4gE";
$lang['cannoteditpm'] = "c@Nn0t 3dIT +his Pm. I+ HAS @lRE4dY BEen v13wEd 8Y teH R3cIp1ent 0r +he m35\$4GE d035 NOt EX1s+ Or 1T iS 1n@cc3\$5Ible 8y J00";
$lang['cannotviewpm'] = "c4NnoT ViEW pM. mes\$4Ge D03s n0T EXI\$+ Or iT I\$ in4Cc3\$sI8lE By j00";
$lang['pmmessagenumber'] = "m3\$5@gE %s";

$lang['youhavexnewpm'] = "j00 h4Ve %d N3w m3\$\$4ge\$. WoULd j00 liK3 t0 g0 T0 YouR in8Ox n0w?";
$lang['youhave1newpm'] = "j00 h@v3 1 n3W mE\$5493. W0ULd j00 LiKe +0 gO T0 YoUR 1n80X N0W?";
$lang['youhave1newpmand1waiting'] = "j00 h4vE 1 nEw m3\$54g3.\n\ny0U @l50 h@v3 1 m3\$\$4G3 @w@iT1N9 d3Liv3Ry. +0 rEC31v3 +hI5 m35\$4Ge pL34\$e cL34r 50m3 Sp@Ce IN yOur In8Ox.\n\nW0uLD j00 l1Ke tO G0 +0 Y0Ur In80X NOw?";
$lang['youhave1pmwaiting'] = "j00 HaVe 1 m3Ss4GE aW@1T1N9 D3liv3Ry. +0 r3c31v3 +Hi\$ M3\$\$493 PL3a53 clE@R S0m3 sP@c3 1n yOUr in80X.\n\nw0UlD J00 L1k3 tO 9o +0 yOur 1N80X NoW?";
$lang['youhavexnewpmand1waiting'] = "j00 haVe %d NeW M3\$\$4gES.\n\ny0U 4LsO H@V3 1 Me\$\$493 4w4i+inG DelIv3RY. +0 r3C3iv3 tH1S M3Ss@9e pL34S3 CL34r SoME Sp4Ce 1n y0UR iNb0X.\n\nWoULD J00 lik3 T0 9O +0 Y0uR 1n80X n0w?";
$lang['youhavexnewpmandxwaiting'] = "j00 h@ve %d NeW M3\$\$4gEs.\n\nyOu 4l50 h4vE %d M3\$54g3S @W@It1N9 D3lIV3RY. +0 r3C31V3 +h3s3 m3S54GE pl34SE Cl3Ar s0m3 SP4Ce 1n YoUr iN8Ox.\n\nWoUlD J00 L1K3 +0 g0 +0 YOuR 1n8OX n0w?";
$lang['youhave1newpmandxwaiting'] = "j00 h@Ve 1 neW m3\$\$4gE.\n\nY0u @l50 h@v3 %d MeS\$4G35 Aw@1t1NG d3lIVEry. +0 REC3iV3 thEs3 M3s\$4GeS pLe4\$3 Cle4R \$0me SP@C3 1N YOuR 1n80X.\n\nWOuLd j00 liK3 T0 90 tO yoUr In8OX N0w?";
$lang['youhavexpmwaiting'] = "j00 h@Ve %d M3\$\$4GE\$ @W41+1n9 dEL1V3RY. +0 R3cEive ThE\$E M3S549eS PLe4\$e Cl3@R 50m3 sPAcE 1N Y0Ur iN8Ox.\n\nw0ULd J00 LikE +o 90 t0 YoUR InBox N0W?";

$lang['youdonothaveenoughfreespace'] = "j00 D0 N0T H@v3 3n0ugH PhRee sp@c3 +0 \$3Nd +H1s M3s54GE.";
$lang['userhasoptedoutofpm'] = "%s HA\$ op+eD Ou+ oF ReC31ViN9 p3R50N4L m3\$\$4GeS";
$lang['pmfolderpruningisenabled'] = "pm PHoLD3R prUnIng 1S eN4bL3d!";
$lang['pmpruneexplanation'] = "tHI\$ pHoRuM U\$3S pm F0ld3R PruNiN9. +HE m3S54gES J00 have St0r3D 1N YoUR 1N80X 4Nd \$3n+ ItemS\\npHOldEr5 ar3 sU8j3Ct +o @u+OM4t1c Del3tIoN. @NY m3S549e\$ j00 W1\$h tO Ke3p 5H0ulD Be M0v3d +O\\nYOuR \\'54VeD 1t3m\$\\' pH0lDeR 50 tH@T +hey @r3 N0t DEl3T3d.";
$lang['yourpmfoldersare'] = "y0Ur Pm F0ldeRs @re %s FuLl";
$lang['currentmessage'] = "currENT M3\$54g3";
$lang['unreadmessage'] = "unR34d M3\$\$493";
$lang['readmessage'] = "rE4D M35s4Ge";
$lang['pmshavebeendisabled'] = "pER\$0n@l me5saG3\$ h@v3 8eEn D1s4bLed BY +hE pHoruM OWnEr.";
$lang['adduserstofriendslist'] = "aDD u\$3rS tO youR PhRiEnD\$ l1\$+ T0 h4vE +heM @pP34r in a dRoP DoWn oN +3H pM wrIt3 M3\$S4G3 PaG3.";

$lang['messagesaved'] = "meS54gE s4v3D";
$lang['messagewassuccessfullysavedtodraftsfolder'] = "m3s54G3 w@S \$uccE\$\$fUlLy \$4VEd T0 'dR@pH+s' FoLd3R";
$lang['couldnotsavemessage'] = "c0uld noT S4ve mE5\$49e. m4KE Sur3 J00 hAV3 ENoUgH 4V@1l@8L3 fr3e sp@c3.";
$lang['pmtooltipxmessages'] = "%s MESSa9e\$";
$lang['pmtooltip1message'] = "1 M35\$493";

$lang['allowusertosendpm'] = "alL0W UsEr +0 S3Nd PErS0n4l mE\$5@g35 tO Me";
$lang['blockuserfromsendingpm'] = "bL0CK U\$Er FRoM \$eNdIn9 p3R50N4l M3S\$4Ges To mE";
$lang['yourfoldernamefolderisempty'] = "y0Ur %s PH0ld3r 1S eMPTy";
$lang['successfullydeletedselectedmessages'] = "sucC3SspHUllY D3L3t3D \$el3cT3D mEs54g3S";
$lang['successfullyarchivedselectedmessages'] = "suCcES5phULlY Archiv3D SEl3CT3D M3Ss4G35";
$lang['failedtodeleteselectedmessages'] = "f41L3D +0 dEl3+E 53l3c+Ed M3\$\$4GE\$";
$lang['failedtoarchiveselectedmessages'] = "f4il3D +0 4rCHiv3 \$ElEct3D Me\$\$4G3S";

// Preferences / Profile (user_*.php) ---------------------------------------------

$lang['mycontrols'] = "my cOntr0l\$";
$lang['myforums'] = "my F0RUmS";
$lang['menu'] = "menu";
$lang['userexp_1'] = "us3 +hE M3nU On +he LeF+ T0 m4N49E Y0uR 5e++in95.";
$lang['userexp_2'] = "<b>us3r d3T@1LS</b> 4Ll0W\$ j00 TO CH4N9E y0UR N4m3, 3m@iL @ddrE\$\$ 4Nd p4\$\$W0rD.";
$lang['userexp_3'] = "<b>u\$3R ProFIL3</b> @LlOwS J00 tO EdiT yoUR U5Er pr0F1Le.";
$lang['userexp_4'] = "<b>ch4nGe P@S5w0Rd</b> 4lL0wS J00 +o cH4nGE y0Ur p@5sWord";
$lang['userexp_5'] = "<b>em@1L &amp; pR1v4cy</b> lE+\$ j00 cH@NGe h0W J00 C@N Be coNt@c+eD oN 4nd 0fF ThE Ph0RuM.";
$lang['userexp_6'] = "<b>f0rum 0PtI0nS</b> LeTS j00 cH4N9e hOw +he PhOrUm l00k\$ @nD W0RKS.";
$lang['userexp_7'] = "<b>a+T@cHmEnT5</b> 4Ll0Ws j00 +0 EdI+/d3L3+3 yoUr 4Tt4cHMenTs.";
$lang['userexp_8'] = "<b>sign4+Ur3</b> L3tS j00 EdIT yOUr 5ign4turE.";
$lang['userexp_9'] = "<b>reL4+10nSh1pS</b> letS j00 m4N49E Y0Ur R3l@t1OnShip WiTh o+h3r u\$3Rs 0n Th3 fOrum.";
$lang['userexp_9'] = "<b>w0Rd fILT3R</b> Le+\$ j00 edI+ YOur peR\$on4l woRD fIlt3R.";
$lang['userexp_10'] = "<b>tHr34D su85Cr1p+i0n5</b> 4LlowS J00 +0 m4nAGe Y0ur +hRE4d sU8ScRiP+1ONs.";
$lang['userdetails'] = "uSEr D3TaIls";
$lang['userprofile'] = "uSEr PrOf1L3";
$lang['emailandprivacy'] = "em41L &amp; PrIv4Cy";
$lang['editsignature'] = "eD1T sIgn@+Ur3";
$lang['norelationshipssetup'] = "j00 h4vE nO UseR R3l4+10NsHiPs SE+ UP. 4dd A N3w u\$ER By se4rCHin9 8elOw.";
$lang['editwordfilter'] = "eDI+ wORD FiL+eR";
$lang['userinformation'] = "u5Er 1nPhOrM4+10N";
$lang['changepassword'] = "cH@N93 P@ssW0rD";
$lang['currentpasswd'] = "cuRR3n+ p@s\$W0rd";
$lang['newpasswd'] = "n3W P4\$\$W0rD";
$lang['confirmpasswd'] = "coNFiRM p@s\$w0rD";
$lang['passwdsdonotmatch'] = "p@SSwOrD5 do N0T m4TCh!";
$lang['nicknamerequired'] = "n1CKn4M3 1\$ rEqU1r3D!";
$lang['emailaddressrequired'] = "eM@iL @dDRe55 IS R3qU1r3D!";
$lang['logonnotpermitted'] = "loGOn N0t permi+T3d. cHOOse 4NoTHEr!";
$lang['nicknamenotpermitted'] = "n1CKN4ME N0+ pErMitt3d. Ch00S3 4N0+H3R!";
$lang['emailaddressnotpermitted'] = "eM41L 4DDr3SS Not p3Rm1+teD. Ch0OSE @nO+H3r!";
$lang['emailaddressalreadyinuse'] = "em@il 4dDR3\$\$ 4lRE4dY 1n uSe. ChO0S3 4No+H3r!";
$lang['relationshipsupdated'] = "rEL4tioNsHIp5 Upd4t3D!";
$lang['relationshipupdatefailed'] = "r3L@+1onShiP Upd4+ed f4Il3D!";
$lang['preferencesupdated'] = "prEpH3r3nCe\$ W3r3 Succes\$fuLlY Upd4TEd.";
$lang['userdetails'] = "u\$3R D3+41lS";
$lang['memberno'] = "mEM8er N0.";
$lang['firstname'] = "f1r\$+ N4mE";
$lang['lastname'] = "l45+ n@M3";
$lang['dateofbirth'] = "d4T3 0Ph b1Rth";
$lang['homepageURL'] = "h0M3P4ge UrL";
$lang['profilepicturedimensions'] = "pROPh1l3 P1CtUrE (m4x 95X95pX)";
$lang['avatarpicturedimensions'] = "av@T4r PIc+Ure (M@X 15X15pX)";
$lang['invalidattachmentid'] = "invaL1D atT@ChMeNT. ch3Ck +H4+ 1\$ h4\$n't Be3N dEl3+3d.";
$lang['unsupportedimagetype'] = "uN\$uPp0RtED 1M49E @Tt@ChM3n+. j00 C4n oNLy u5E jP9, gIpH 4Nd PnG 1m@g3 @+T@CHm3n+\$ f0R y0Ur @va+4R 4Nd Pr0PhIl3 pictUrE.";
$lang['selectattachment'] = "sElEc+ Att@cHm3Nt";
$lang['pictureURL'] = "pIC+UR3 UrL";
$lang['avatarURL'] = "aV4T4r URl";
$lang['profilepictureconflict'] = "tO uS3 An @tT4ChmeN+ pHoR yoUR Pr0ph1L3 p1c+ure +HE p1C+ur3 uRl fIEld mu\$T Be bL4nK.";
$lang['avatarpictureconflict'] = "t0 uSE @n 4++@cHm3Nt pH0r yOuR 4v@T4r P1C+uR3 the 4v4T@R UrL FiEld mU5t 83 8l4NK.";
$lang['attachmenttoolargeforprofilepicture'] = "seL3Ct3d aTt@chmenT 1S to0 l4r9E PHor pRoPh1L3 p1C+uR3. m4XiMuM DiMeN\$ionS @r3 %s";
$lang['attachmenttoolargeforavatarpicture'] = "s3LeC+ED aTt@cHmEn+ iS +00 l4R9e phor 4V4+4r p1ctuRE. M4X1MuM dImEnSI0Ns @re %s";
$lang['failedtoupdateuserdetails'] = "soM3 oR 4ll 0F Y0uR U\$3r 4Cc0Un+ dEt@1lS Could n0+ Be uPd4t3d. PlE453 try @94iN L4+Er.";
$lang['failedtoupdateuserpreferences'] = "s0me oR 4Ll OpH Y0UR U5Er Pr3FeR3NC3\$ c0Uld N0T Be uPd4TeD. plE@sE Try 4g4iN l4+eR.";
$lang['emailaddresschanged'] = "em@Il 4DdREs5 H@\$ bEeN Ch4nGED";
$lang['newconfirmationemailsuccess'] = "yOUr Em4il 4DdrE\$\$ h@S be3N Ch4ngeD 4ND @ nEw c0Nph1Rm4+I0n EmAil h@S 8EeN \$3NT. Pl34Se CHeCk 4nd re4d tHE 3m4Il pH0R fUr+HeR 1NS+rUC+IoNs.";
$lang['newconfirmationemailfailure'] = "j00 H4v3 Ch4NgeD Y0uR em4Il 4dDr3\$5, 8u+ wE W3re Un4ble tO 5EnD @ c0Nph1Rm@TiOn rEqU3\$T. pLe4\$3 c0NT@c+ +hE pH0Rum own3r Ph0r @SSi\$TaNcE.";
$lang['forumoptions'] = "fORuM Op+10n5";
$lang['notifybyemail'] = "n0+1phy bY Em4il 0Ph pOsTs +0 ME";
$lang['notifyofnewpm'] = "n0T1Fy bY popUp 0Ph N3W Pm me5\$493\$ +o M3";
$lang['notifyofnewpmemail'] = "n0+1pHy by 3mail 0pH N3w pm mEss4g35 tO mE";
$lang['daylightsaving'] = "adjU\$+ F0R d4Yl1GhT S4v1Ng";
$lang['autohighinterest'] = "aU+0M4TiC4lLY M@Rk tHrE4D\$ i p05+ IN 45 H1gH 1ntER35+";
$lang['convertimagestolinks'] = "au+0M@+ic4LlY conV3r+ Em8eddED 1m@935 1n P0s+5 iNtO LinK5";
$lang['thumbnailsforimageattachments'] = "thum8n4IlS PHoR Im4gE att@ChMeNts";
$lang['smallsized'] = "sM4Ll s1zed";
$lang['mediumsized'] = "mED1UM \$iz3d";
$lang['largesized'] = "l4R9E s1ZeD";
$lang['globallyignoresigs'] = "glob@lLy IGNOr3 uS3r 519natUr3S";
$lang['allowpersonalmessages'] = "aLl0W OtH3r uSeR\$ +0 SEnd ME pErS0n@l m3S5@G3S";
$lang['allowemails'] = "alL0W O+hEr uSers to SeNd mE Em@1lS V14 MY pROfIl3";
$lang['timezonefromGMT'] = "tiMe ZoN3";
$lang['postsperpage'] = "pO\$+s pEr p49E";
$lang['fontsize'] = "f0Nt Siz3";
$lang['forumstyle'] = "foRuM STyL3";
$lang['forumemoticons'] = "foRuM 3mOT1COns";
$lang['startpage'] = "s+@Rt pA9E";
$lang['signaturecontainshtmlcode'] = "s1GN4+ure cONt41nS html C0d3";
$lang['savesignatureforuseonallforums'] = "sAVe sIGnatUr3 FOr uSe 0N 4Ll PhOrUm\$";
$lang['preferredlang'] = "pRefERr3D L@NgU@9E";
$lang['donotshowmyageordobtoothers'] = "d0 N0+ ShOw mY 493 oR d4T3 OF 8iR+H T0 0+herS";
$lang['showonlymyagetoothers'] = "sH0W onlY My 49E T0 0tH3rS";
$lang['showmyageanddobtoothers'] = "sh0w bOtH My 493 aND d4+e 0pH BIrtH TO 0ThErS";
$lang['showonlymydayandmonthofbirthytoothers'] = "sHOW OnLy mY DaY 4Nd M0Nth 0ph BiR+H To 0Th3R\$";
$lang['listmeontheactiveusersdisplay'] = "l1\$t m3 On +HE aC+1v3 U5eRS diSpL4y";
$lang['browseanonymously'] = "br0w5E fOrUm ANOnymoUsly";
$lang['allowfriendstoseemeasonline'] = "broWSe 4nonYmOUsLy, 8Ut 4Ll0w FrI3Nd\$ To 5EE ME As 0nliN3";
$lang['revealspoileronmouseover'] = "r3VE4l sPOiL3rs oN M0UsE 0v3R";
$lang['showspoilersinlightmode'] = "alwaYs ShoW sPoIL3rS iN LiGht M0D3 (u\$3\$ L1Ght3R ph0N+ CoL0Ur)";
$lang['resizeimagesandreflowpage'] = "r3\$1Ze Im49E\$ @Nd r3pHLoW P4ge TO PR3VeNt hOr1ZOnTal ScrolLiN9.";
$lang['showforumstats'] = "sHoW F0Rum S+4+\$ 4+ 80++0M 0F Me\$\$4GE p@ne";
$lang['usewordfilter'] = "en48L3 Word FiL+3R.";
$lang['forceadminwordfilter'] = "fOrC3 u\$3 oF @DM1n W0rD fILt3R 0n 4Ll U5ErS (1Nc. GUeS+5)";
$lang['timezone'] = "tIm3 zOn3";
$lang['language'] = "l@NgUaGe";
$lang['emailsettings'] = "em4iL @nD c0nt@c+ SEtT1nGs";
$lang['forumanonymity'] = "fOrUM 4nonyM1tY S3tT1NGs";
$lang['birthdayanddateofbirth'] = "bIrthD4y 4Nd d4+3 0F BIR+h di\$pLAy";
$lang['includeadminfilter'] = "incLuDe @dmin w0rD PH1l+er 1N my L1St.";
$lang['setforallforums'] = "s3+ f0R @ll forumS?";
$lang['containsinvalidchars'] = "%s CONtaInS 1NV@L1D cH@r4ctEr5!";
$lang['homepageurlmustincludeschema'] = "h0MEp4Ge uRl muS+ 1NCLuD3 h+TP:// sCh3M4.";
$lang['pictureurlmustincludeschema'] = "piC+URe URl muS+ 1NcLuDe htTp:// sCHem@.";
$lang['avatarurlmustincludeschema'] = "aV@+4R UrL mU\$t iNcLud3 H++P:// \$ChEmA.";
$lang['postpage'] = "po5+ P@9e";
$lang['nohtmltoolbar'] = "n0 HTml t0olb4R";
$lang['displaysimpletoolbar'] = "dispLaY S1MPLe H+ml +00Lb4r";
$lang['displaytinymcetoolbar'] = "dI5PlAy Wy5Iwy9 htML t0OlB@r";
$lang['displayemoticonspanel'] = "dISpLay Em0+iCoNS p4NeL";
$lang['displaysignature'] = "di5Pl4Y S19N4+uR3";
$lang['disableemoticonsinpostsbydefault'] = "d154BlE Em0T1cOnS In m3\$\$@gEs 8y d3F4Ul+";
$lang['automaticallyparseurlsbydefault'] = "au+OM@T1cAllY P4r\$e URL5 In mE\$\$4geS 8y D3PH4uLt";
$lang['postinplaintextbydefault'] = "p0S+ in pL41n t3X+ 8Y DephaUl+";
$lang['postinhtmlwithautolinebreaksbydefault'] = "p05T in h+ml wIth 4uTo-lIn3-8Re@kS 8y D3f@Ult";
$lang['postinhtmlbydefault'] = "p05+ in h+mL 8Y DeF4Ul+";
$lang['privatemessageoptions'] = "priV4+3 Me\$\$4g3 0PtIoNS";
$lang['privatemessageexportoptions'] = "pRiv4+e m355@G3 3XP0rt 0P+I0nS";
$lang['savepminsentitems'] = "s@v3 a c0Py 0f e4Ch pM i 5eNd 1n My SeNt I+Em5 phoLDeR";
$lang['includepminreply'] = "iNClUD3 mEsS4g3 80dY WhEN repLyIn9 +0 pm";
$lang['autoprunemypmfoldersevery'] = "aU+O prUnE My pM FoLd3Rs 3VeRy:";
$lang['friendsonly'] = "fR1END\$ ONLY?";
$lang['globalstyles'] = "gl084L STyL3s";
$lang['forumstyles'] = "fORum StYlEs";
$lang['youmustenteryourcurrentpasswd'] = "j00 mUSt 3nt3R yoUr CuRrent p4\$5WOrD";
$lang['youmustenteranewpasswd'] = "j00 MU\$+ eN+er a N3w P4\$\$W0rD";
$lang['youmustconfirmyournewpasswd'] = "j00 mUSt conPh1RM Y0UR n3W P4s5W0rD";
$lang['profileentriesmustnotincludehtml'] = "pR0FiL3 eNtR135 MuSt not 1NclUde h+mL";
$lang['failedtoupdateuserprofile'] = "f4iL3D T0 UpDat3 U\$3R pr0phiLe";

// Polls (create_poll.php, poll_results.php) ---------------------------------------------

$lang['mustprovideanswergroups'] = "j00 mu\$t Pr0v1DE SoM3 4NSweR grOuP5";
$lang['mustprovidepolltype'] = "j00 MU\$+ pR0vIdE @ PoLL +Yp3";
$lang['mustprovidepollresultsdisplaytype'] = "j00 mus+ pr0v1D3 Re\$uLtS d1\$Play tYp3";
$lang['mustprovidepollvotetype'] = "j00 mU\$+ pR0v1D3 4 POll V0tE tyP3";
$lang['mustprovidepollguestvotetype'] = "j00 mUs+ \$p3CIfy if Gu35+\$ sh0Uld bE @LlOW3d +0 v0T3";
$lang['mustprovidepolloptiontype'] = "j00 MU\$T PRoViD3 @ P0lL 0P+1On +Yp3";
$lang['mustprovidepollchangevotetype'] = "j00 MU\$+ Pr0v1de 4 P0Ll Ch@n93 VO+E typ3";
$lang['pollquestioncontainsinvalidhtml'] = "oNE OR M0rE OPH yoUR p0LL QuEs+1On5 c0n+4In\$ iNv4lID H+ML.";
$lang['pleaseselectfolder'] = "pLE@sE sel3Ct 4 PHOlDeR";
$lang['mustspecifyvalues1and2'] = "j00 mUS+ \$pec1Fy V4Lu3\$ FOR 4NsWerS 1 4Nd 2";
$lang['tablepollmusthave2groups'] = "t4BuL4r pHoRM4+ P0lLs mUS+ HaV3 pR3cIs3LY +w0 v0t1N9 9R0uP\$";
$lang['nomultivotetabulars'] = "t48UlAR ph0RmaT pOll\$ C4Nn0+ b3 mUl+i-v0T3";
$lang['nomultivotepublic'] = "pU8LiC B4lLOT5 C4NnOt bE mUlT1-vOtE";
$lang['abletochangevote'] = "j00 wilL Be @8L3 TO Ch@N9e y0Ur V0+3.";
$lang['abletovotemultiple'] = "j00 WiLl 8e 48lE TO v0Te mUltiPlE t1M3S.";
$lang['notabletochangevote'] = "j00 wIlL NO+ Be 48l3 +0 cH4nGe Y0UR v0+e.";
$lang['pollvotesrandom'] = "nOT3: P0lL VO+3S @R3 R4nDOmLy 9eN3r@tED fOr pR3V13w ONlY.";
$lang['pollquestion'] = "p0ll Qu3s+iON";
$lang['possibleanswers'] = "po55i8L3 4nSWErs";
$lang['enterpollquestionexp'] = "enTeR +hE @nSw3RS fOR yOUR P0Ll qU35+ioN.. If yOuR p0lL 1S @ &quot;Y35/nO&quot; qUe\$+IoN, \$1MpLY EntEr &quot;Y3S&quot; FOr 4N\$WEr 1 4Nd &quot;NO&quot; PH0R 4nswEr 2.";
$lang['numberanswers'] = "n0. @NsWerS";
$lang['answerscontainHTML'] = "ansWErs CoNt41n H+Ml (N0T inclUD1nG Sign4+UR3)";
$lang['optionsdisplay'] = "aNSwErS D1SpL@y tyPE";
$lang['optionsdisplayexp'] = "hoW 5HOuLd th3 @NSwEr5 8E Pr35EnT3d?";
$lang['dropdown'] = "a\$ dR0p-DoWN l1\$+(\$)";
$lang['radios'] = "a5 4 SEr1ES 0pH R@DiO 8uTtOnS";
$lang['votechanging'] = "v0T3 cH@N9iNg";
$lang['votechangingexp'] = "c4N @ PeR50N CHan9E HiS 0R h3R v0TE?";
$lang['guestvoting'] = "gUEs+ VoT1n9";
$lang['guestvotingexp'] = "c4N gU3\$+5 VOt3 1n tH1s pOlL?";
$lang['allowmultiplevotes'] = "all0W mUlTIPl3 V0t35";
$lang['pollresults'] = "pOLl R3SUlTs";
$lang['pollresultsexp'] = "how W0Uld J00 LiK3 to diSPl@Y tH3 R3SuLt5 oF Y0uR POll?";
$lang['pollvotetype'] = "p0lL V0t1N9 +Yp3";
$lang['pollvotesexp'] = "hoW \$H0uLd +hE p0lL 83 CoNDucTed?";
$lang['pollvoteanon'] = "an0nYmOuSlY";
$lang['pollvotepub'] = "pU8L1c 84lL0t";
$lang['horizgraph'] = "h0RIzOnt@L Gr@pH";
$lang['vertgraph'] = "ver+1C4l 9r@Ph";
$lang['tablegraph'] = "t4BuL4r pH0rm4+";
$lang['polltypewarning'] = "<b>w4Rn1Ng</b>: +HiS 1s @ Pu8l1C B4ll0T. YOur nAm3 Will b3 viS18l3 n3X+ tO +eH Op+1oN j00 V0TE F0r.";
$lang['expiration'] = "exP1r@tioN";
$lang['showresultswhileopen'] = "dO j00 w4nT t0 5h0W R3\$uL+5 wH1lE t3H pOLL 1S 0PeN?";
$lang['whenlikepollclose'] = "wh3n WoULD j00 liK3 YoUR P0Ll +0 4UToM4+1C4lLy clo5E?";
$lang['oneday'] = "one D@y";
$lang['threedays'] = "thReE d@y\$";
$lang['sevendays'] = "s3Ven d4yS";
$lang['thirtydays'] = "thir+Y d4Y\$";
$lang['never'] = "n3v3R";
$lang['polladditionalmessage'] = "aDd1+10N4l m3\$\$49e (Op+1On4L)";
$lang['polladditionalmessageexp'] = "do j00 w4N+ tO 1NcluDe 4N 4dDitiOn@l p0S+ @PhT3r tHe p0Ll?";
$lang['mustspecifypolltoview'] = "j00 Mu5T 5pEc1Fy @ P0lL +0 vIeW.";
$lang['pollconfirmclose'] = "arE j00 sUr3 J00 w@N+ tO cLO5e +eh Ph0LloW1Ng pOlL?";
$lang['endpoll'] = "eND P0Ll";
$lang['nobodyvotedclosedpoll'] = "no8OdY Vo+3d";
$lang['votedisplayopenpoll'] = "%s @nd %s H4VE VoTeD.";
$lang['votedisplayclosedpoll'] = "%s 4Nd %s v0+3D.";
$lang['nousersvoted'] = "n0 User5";
$lang['oneuservoted'] = "1 us3R";
$lang['xusersvoted'] = "%s US3rS";
$lang['noguestsvoted'] = "nO 9U35+\$";
$lang['oneguestvoted'] = "1 9U35+";
$lang['xguestsvoted'] = "%s Gu35tS";
$lang['pollhasended'] = "poll h45 ENd3d";
$lang['youvotedforpolloptionsondate'] = "j00 vo+ed F0r %s On %s";
$lang['thisisapoll'] = "tH1S 1s 4 p0LL. cLiCk t0 v13w rE\$UlT5.";
$lang['editpoll'] = "edI+ p0Ll";
$lang['results'] = "resuLt5";
$lang['resultdetails'] = "resuLT d3+4ilS";
$lang['changevote'] = "ch4nGe V0+3";
$lang['pollshavebeendisabled'] = "pOLls h4VE 8E3N DiS4bL3D 8y tHe PHorUM 0wnEr.";
$lang['answertext'] = "aN\$w3R T3x+";
$lang['answergroup'] = "aNSwEr gr0Up";
$lang['previewvotingform'] = "pr3vIEw V0+iNg pHOrM";
$lang['viewbypolloption'] = "viEW 8Y POll oP+10N";
$lang['viewbyuser'] = "vi3W 8Y US3r";

// Profiles (profile.php) ----------------------------------------------

$lang['editprofile'] = "edIt pRofiLe";
$lang['profileupdated'] = "pR0F1l3 uPd4t3D.";
$lang['profilesnotsetup'] = "tHE pHoruM OwNeR H4\$ nOt \$E+ uP pR0pH1lE\$.";
$lang['ignoreduser'] = "igNOr3D U5eR";
$lang['lastvisit'] = "l4\$+ v1\$1T";
$lang['userslocaltime'] = "uS3r'S L0c4L +1m3";
$lang['userstatus'] = "s+@tuS";
$lang['useractive'] = "onL1N3";
$lang['userinactive'] = "iN4CtiV3 / OpHfL1n3";
$lang['totaltimeinforum'] = "to+4L +1mE";
$lang['longesttimeinforum'] = "l0n9E\$+ se\$5i0n";
$lang['sendemail'] = "seNd 3M@1L";
$lang['sendpm'] = "sENd pm";
$lang['visithomepage'] = "visiT HOMep4Ge";
$lang['age'] = "a93";
$lang['aged'] = "ag3D";
$lang['birthday'] = "b1RThD@Y";
$lang['registered'] = "r3G1S+Er3D";
$lang['findpostsmadebyuser'] = "f1Nd PoSt5 maDe 8Y %s";
$lang['findpostsmadebyme'] = "f1nD PoST\$ m@D3 8Y mE";
$lang['profilenotavailable'] = "pROpH1l3 NoT 4V4iL4bL3.";
$lang['userprofileempty'] = "thIs uSEr h45 noT PhIlL3d 1N +hEiR PR0phiL3 0R iT IS 5E+ +0 Pr1v@t3.";

// Registration (register.php) -----------------------------------------

$lang['newuserregistrationsarenotpermitted'] = "soRRY, nEw u5Er rEG1\$+R@TI0nS @re not 4Ll0w3d r19Ht nOw. Pl34s3 ChEcK BACk L@T3r.";
$lang['usernameinvalidchars'] = "u53Rn@m3 C@n OnLy c0NT@1N @-Z, 0-9, _ - cH@R4c+eRS";
$lang['usernametooshort'] = "uS3Rn@mE Must 83 4 M1n1MuM 0pH 2 char@c+eRs l0n9";
$lang['usernametoolong'] = "u53rn@m3 Mu\$+ 83 @ m4xiMuM 0f 15 cHAr@cTeR5 lOn9";
$lang['usernamerequired'] = "a L0goN n4mE 1S REqu1r3D";
$lang['passwdmustnotcontainHTML'] = "pA\$5W0rD MuS+ NoT Con+41n hTmL T@9S";
$lang['passwordinvalidchars'] = "p4\$\$W0Rd c4N 0NlY C0nT@1N @-Z, 0-9, _ - cH4r@CT3rS";
$lang['passwdtooshort'] = "p4\$5wOrd MuS+ 8E @ m1n1MuM OF 6 Ch4r@C+eR5 lOn9";
$lang['passwdrequired'] = "a P4ssWOrD iS R3QU1R3d";
$lang['confirmationpasswdrequired'] = "a c0NPh1Rm4tIoN p@S5w0RD 1S R3qU1r3D";
$lang['nicknamerequired'] = "a n1cKNamE 1\$ R3qu1r3d";
$lang['emailrequired'] = "an Em4iL 4dDr3S5 I\$ r3quiR3d";
$lang['passwdsdonotmatch'] = "p@\$5W0RdS D0 N0t m4TcH";
$lang['usernamesameaspasswd'] = "u\$ErN@M3 @nd p@5\$W0rD Mu\$+ 8e D1FpH3rEn+";
$lang['usernameexists'] = "s0rrY, a U5Er wI+H +H4+ namE @lR34dY exi\$+\$";
$lang['successfullycreateduseraccount'] = "suCc35\$phUlLy cR34T3d u\$eR acCoUn+";
$lang['useraccountcreatedconfirmfailed'] = "your uSeR 4CC0Un+ H4S bEeN cr34T3d 8u+ Th3 r3qUiR3d CoNpH1Rm4+1On eM4IL w4S No+ 5EnT. pLeAs3 c0N+AC+ +Eh ph0RuM OWneR +0 R3C+iFy +Hi\$. IN tHi\$ M34n+IMe Pl3@se cLIcK ThE c0Nt1nUE 8UtToN +0 LoG1n 1n.";
$lang['useraccountcreatedconfirmsuccess'] = "y0Ur Us3R 4ccOun+ H@S 8eEn cr34TeD 8Ut beFor3 J00 c4n S+4R+ pos+inG J00 Mus+ C0NPhiRM y0Ur 3m41l 4dDrEs5. Pl34\$E CHeck yOuR Em@1l F0r A l1NK tH@+ WiLl @LlOw j00 +0 COnPh1rm Your 4DDrEs\$.";
$lang['useraccountcreated'] = "y0ur useR AcC0unT H45 8eEN cr34t3D \$uCc3\$\$FuLly! Cl1Ck +3H C0nTiNu3 8u++0N bELow +o loGin";
$lang['errorcreatinguserrecord'] = "erroR cr34t1NG u\$eR R3cOrD";
$lang['userregistration'] = "u\$Er RegIS+r4t10n";
$lang['registrationinformationrequired'] = "r39I\$+R@T1oN 1NpH0rM4+IOn (R3QuIr3D)";
$lang['profileinformationoptional'] = "pROfIl3 InFoRM4+i0n (0pT10n@l)";
$lang['preferencesoptional'] = "pReFer3nC35 (0p+10n4L)";
$lang['register'] = "rE91\$+Er";
$lang['rememberpasswd'] = "r3MEm83r p@s\$w0Rd";
$lang['birthdayrequired'] = "yOuR d4tE 0F b1RTh Is r3QU1R3d oR Is 1nVal1D";
$lang['alwaysnotifymeofrepliestome'] = "nO+IfY 0N R3PLy +0 Me";
$lang['notifyonnewprivatemessage'] = "n0+IfY 0N nEW Pr1v@tE M3S54g3";
$lang['popuponnewprivatemessage'] = "pOP Up 0n nEw pRiv@+e m3\$54gE";
$lang['automatichighinterestonpost'] = "au+Om@t1C Hi9h 1nT3r3\$+ ON pOs+";
$lang['confirmpassword'] = "cONfIrM P@S\$WOrd";
$lang['invalidemailaddressformat'] = "inV4lId 3m4iL AdDrE\$5 f0rM4+";
$lang['moreoptionsavailable'] = "moRe pRoPh1le @nD PrEfer3Nc3 0pt1onS 4RE 4V@1la8l3 ONcE j00 r39i\$+er";
$lang['textcaptchaconfirmation'] = "c0NfIRm4+1on";
$lang['textcaptchaexplain'] = "t0 +3h r1Gh+ 1S 4 +eXt-c4pTch@ 1m@93. PL34\$E TyP3 t3H C0dE J00 C@n 5e3 In +hE 1m49e 1nTo +h3 inpUt Ph1ElD BeL0w i+.";
$lang['textcaptchaimgtip'] = "tH1s iS 4 c4pTch4-PiCtuR3. 1+ is U\$Ed +0 pr3V3nT @uTOm@+1c R39i\$+R@t1ON";
$lang['textcaptchamissingkey'] = "a COnpH1rm4+i0n cOdE i5 rEqu1R3d.";
$lang['textcaptchaverificationfailed'] = "texT-C@PtcH4 v3R1fiC4+I0n C0d3 W@5 INc0RR3c+. Pl345e Re-EnTER 1T.";
$lang['forumrules'] = "forUm rUl3S";
$lang['forumrulesnotification'] = "iN 0RdEr +0 pR0C3eD, j00 mUS+ 49R3E WI+H +HE F0Ll0w1NG rUl3\$";
$lang['forumrulescheckbox'] = "i h@ve r34d, 4nd @9r3E T0 4BID3 8y +he fOrum RulEs.";
$lang['youmustagreetotheforumrules'] = "j00 musT @GrE3 +0 tHE PHoruM rUL3s B3F0rE j00 C@N C0n+1NUE.";

// Recent visitors list  (visitor_log.php) -----------------------------

$lang['member'] = "meMBEr";
$lang['searchforusernotinlist'] = "sE4RcH PhoR @ U53r NoT 1n L1\$t";
$lang['yoursearchdidnotreturnanymatches'] = "yOur \$34rCh did N0t R3+uRn 4nY M@TChe\$. +rY 5Impl1phYiNg Y0UR se@RCH p4R@M3t3R\$ @nd +Ry 4G41N.";
$lang['hiderowswithemptyornullvalues'] = "hID3 r0wS W1Th emp+y Or NULl V4Lu35 1N selEct3D CoLUMNs";
$lang['showregisteredusersonly'] = "sH0W R39iSTeReD US3r5 OnlY (Hid3 9u3STS)";

// Relationships (user_rel.php) ----------------------------------------

$lang['relationships'] = "reL4+1ONsH1P\$";
$lang['userrelationship'] = "u53R r3L4tionSH1P";
$lang['userrelationships'] = "u\$3r R3latIOnSHIPs";
$lang['failedtoremoveselectedrelationships'] = "f41L3d +0 r3m0v3 53l3C+ED r3l4+IoNSh1P";
$lang['friends'] = "fR1EnDS";
$lang['ignoredcompletely'] = "i9NOREd C0Mpl3+elY";
$lang['relationship'] = "r3l4tIoN5h1p";
$lang['restorenickname'] = "rEs+0rE U\$3R'S Nickn4me";
$lang['friend_exp'] = "u\$3R'S pOsTs m@rked w1Th 4 &quot;pHri3Nd&quot; Ic0N.";
$lang['normal_exp'] = "us3r'5 p0S+5 @PP34r 4S n0Rm4L.";
$lang['ignore_exp'] = "uSEr'\$ P0s+5 @rE H1Dd3n.";
$lang['ignore_completely_exp'] = "thRe4DS @ND PoS+\$ +0 oR From u\$Er wiLl @Pp34R D3L3+eD.";
$lang['display'] = "d1sPl4y";
$lang['displaysig_exp'] = "u5eR'S s19n4TUR3 is di\$Pl4Yed 0N +HEir PoS+\$.";
$lang['hidesig_exp'] = "uSEr'S 51gn@+Ur3 1\$ hidDeN On +H31r P0S+5.";
$lang['cannotignoremod'] = "j00 caNnOt 1gNoRe thi\$ u\$3r, 4s +HeY 4r3 4 mOd3R4+0r.";
$lang['previewsignature'] = "prEV13w \$19n4+uR3";

// Search (search.php) -------------------------------------------------

$lang['searchresults'] = "se4RcH REsUlT\$";
$lang['usernamenotfound'] = "t3h usErNAmE J00 sPec1PhI3d 1n T3H +0 oR FrOM pH13Ld w4S NOt Ph0UnD.";
$lang['notexttosearchfor'] = "on3 OR 4Ll Of y0Ur 5E@rCh k3yw0rDs w3Re inV@Lid. s34rCh k3yW0rDs mU\$T 83 no 5h0R+eR +h4N %d Ch@r@c+erS, nO L0N93R th4n %d ch4r4Ct3RS @nd mU\$T N0T 4Pp34R In Th3 %s";
$lang['keywordscontainingerrors'] = "k3yWoRD\$ COn+a1nIn9 3RrOr\$: %s";
$lang['mysqlstopwordlist'] = "mYSQl St0PwOrD lIS+";
$lang['foundzeromatches'] = "f0UNd: 0 m@+CHes";
$lang['found'] = "foUnD";
$lang['matches'] = "m4+Ch3\$";
$lang['prevpage'] = "prEv10U5 P4gE";
$lang['findmore'] = "fiNd m0Re";
$lang['searchmessages'] = "s3@rch m3\$\$4Ge\$";
$lang['searchdiscussions'] = "sE@Rch Di\$cU\$5IonS";
$lang['find'] = "fiNd";
$lang['additionalcriteria'] = "adDIt10NAl CritEr14";
$lang['searchbyuser'] = "se4RcH 8Y U\$3r (0P+10n@l)";
$lang['folderbrackets_s'] = "fOLdEr(\$)";
$lang['postedfrom'] = "pOS+Ed PHrOM";
$lang['postedto'] = "po5+Ed T0";
$lang['today'] = "t0D@Y";
$lang['yesterday'] = "yES+erd@y";
$lang['daybeforeyesterday'] = "d4Y beForE yE\$+ErD4Y";
$lang['weekago'] = "%s WEek 490";
$lang['weeksago'] = "%s weEkS 490";
$lang['monthago'] = "%s M0nth 4G0";
$lang['monthsago'] = "%s M0n+H\$ @9O";
$lang['yearago'] = "%s Ye@r 49O";
$lang['beginningoftime'] = "be9inNiN9 0f t1m3";
$lang['now'] = "n0W";
$lang['lastpostdate'] = "l@sT P0sT d@+3";
$lang['numberofreplies'] = "nUmB3R 0Ph r3Pl135";
$lang['foldername'] = "foLdEr n@M3";
$lang['authorname'] = "auth0R N4mE";
$lang['decendingorder'] = "neW3S+ fIr5+";
$lang['ascendingorder'] = "olde\$+ fiR\$+";
$lang['keywords'] = "kEYw0Rd\$";
$lang['sortby'] = "s0rT bY";
$lang['sortdir'] = "sORt D1R";
$lang['sortresults'] = "soRt R3\$UlT5";
$lang['groupbythread'] = "gRouP By +Hr34D";
$lang['postsfromuser'] = "p0\$+5 pHr0M u\$ER";
$lang['poststouser'] = "pos+5 tO us3R";
$lang['poststoandfromuser'] = "p0S+\$ tO AnD Fr0M U\$Er";
$lang['searchfrequencyerror'] = "j00 C4n ONlY \$34rCh oNcE 3VerY %s \$3C0nDs. Pl34S3 +ry 4g@IN L4+Er.";
$lang['searchsuccessfullycompleted'] = "s34RcH \$uCc35\$fUlly c0mPlE+ed. %s";
$lang['clickheretoviewresults'] = "cl1Ck HeRe tO VIew R3\$ult5.";

// Search Popup (search_popup.php) -------------------------------------

$lang['select'] = "sELeCt";
$lang['searchforthread'] = "s3@rch fOR tHRe4d";
$lang['mustspecifytypeofsearch'] = "j00 mus+ 5P3C1fy +YPe OF Se@rch tO p3RphorM";
$lang['unkownsearchtypespecified'] = "uNKnOWn Se@rch +yPe \$P3c1phiEd";
$lang['mustentersomethingtosearchfor'] = "j00 mU\$T EnTEr \$oMeth1N9 TO 5e4rch pHoR";

// Start page (start_left.php) -----------------------------------------

$lang['recentthreads'] = "r3c3N+ ThRe4DS";
$lang['startreading'] = "s+@r+ r34dIN9";
$lang['threadoptions'] = "thrE4d oP+i0n\$";
$lang['editthreadoptions'] = "eDIt +Hr34d op+ioNs";
$lang['morevisitors'] = "m0R3 ViSi+0R\$";
$lang['forthcomingbirthdays'] = "fORtHc0M1NG b1r+hd4Ys";

// Start page (start_main.php) -----------------------------------------

$lang['editstartpage_help'] = "j00 c@N Ed1+ Th1\$ P4Ge Phr0M +Eh 4DM1N iNt3RpH@Ce";

// Thread navigation (thread_list.php) ---------------------------------

$lang['newdiscussion'] = "new dI\$Cu5\$1oN";
$lang['createpoll'] = "cRE4t3 poll";
$lang['search'] = "s3@RcH";
$lang['searchagain'] = "s3@rCH 494in";
$lang['alldiscussions'] = "all DIsCu5\$1On5";
$lang['unreaddiscussions'] = "unrE@d DIsCuS\$1OnS";
$lang['unreadtome'] = "uNrE4d &quot;tO: m3&quot;";
$lang['todaysdiscussions'] = "t0D4Y'\$ dIsCUsS1On5";
$lang['2daysback'] = "2 d4YS 84cK";
$lang['7daysback'] = "7 D4yS b4Ck";
$lang['highinterest'] = "hi9h iN+ER3s+";
$lang['unreadhighinterest'] = "uNR34D h1gH 1Nt3rESt";
$lang['iverecentlyseen'] = "i'V3 R3c3N+Ly SeeN";
$lang['iveignored'] = "i'Ve I9NoR3d";
$lang['byignoredusers'] = "bY 19NoR3d uSeRS";
$lang['ivesubscribedto'] = "i'Ve SuB5cribed to";
$lang['startedbyfriend'] = "sT4Rt3D 8y PhrIEnd";
$lang['unreadstartedbyfriend'] = "uNR34d sTD bY phRiEND";
$lang['startedbyme'] = "s+@R+3D By m3";
$lang['unreadtoday'] = "unR34D +0DaY";
$lang['deletedthreads'] = "d3Le+ed ThRe@dS";
$lang['goexcmark'] = "gO!";
$lang['folderinterest'] = "fOLdEr InT3r3\$t";
$lang['postnew'] = "p0\$t NeW";
$lang['currentthread'] = "cURr3N+ +Hr34d";
$lang['highinterest'] = "hiGH 1n+3r35+";
$lang['markasread'] = "m@rK @S rE4d";
$lang['next50discussions'] = "nEX+ 50 di5CuS\$10Ns";
$lang['visiblediscussions'] = "vI\$1Bl3 D1ScUs\$10nS";
$lang['selectedfolder'] = "s3LecT3d pHolDer";
$lang['navigate'] = "n4V194+E";
$lang['couldnotretrievefolderinformation'] = "tH3R3 @Re N0 PhOld3Rs @V@1l4Bl3.";
$lang['nomessagesinthiscategory'] = "n0 M3S\$49E\$ iN +hI\$ C4+eG0Ry. plE4Se sEl3Ct 4N0tHER, OR %s F0r 4ll +hRE4d\$";
$lang['clickhere'] = "cliCk h3R3";
$lang['prev50threads'] = "pRevIoUs 50 +hR3aDS";
$lang['next50threads'] = "n3X+ 50 +HrE4d\$";
$lang['nextxthreads'] = "n3Xt %s tHr3Ads";
$lang['threadstartedbytooltip'] = "thRE4d #%s St@r+3d bY %s. Vi3WeD %s";
$lang['threadviewedonetime'] = "1 TimE";
$lang['threadviewedtimes'] = "%d T1m3S";
$lang['unreadthread'] = "uNRe4D +hrE4D";
$lang['readthread'] = "r34D +Hre4D";
$lang['unreadmessages'] = "uNR34d Me\$s49Es";
$lang['subscribed'] = "sU8ScR183d";
$lang['ignorethisfolder'] = "i9nORe TH1s FOldeR";
$lang['stopignoringthisfolder'] = "sT0P IgNOr1n9 +HiS PhOlDeR";
$lang['stickythreads'] = "s+1cky ThrE4D\$";
$lang['mostunreadposts'] = "mO5+ UnRe@D poS+\$";
$lang['onenew'] = "%d n3w";
$lang['manynew'] = "%d NeW";
$lang['onenewoflength'] = "%d new oph %d";
$lang['manynewoflength'] = "%d n3W OPh %d";
$lang['ignorefolderconfirm'] = "aRE J00 sUre J00 want +0 igNOr3 tH1s fold3r?";
$lang['unignorefolderconfirm'] = "aR3 j00 SUrE J00 W4n+ TO stOp iGnoR1ng th1\$ PhoLdeR?";
$lang['confirmmarkasread'] = "aRE j00 \$Ur3 J00 w4N+ TO M4Rk +eh 5eL3Ct3d +hRe4ds @s Re4D?";
$lang['successfullymarkreadselectedthreads'] = "sUCCeS5FuLlY MaRk3D Sel3Ct3D thrEads 45 R3@d";
$lang['failedtomarkselectedthreadsasread'] = "f@1L3D T0 maRK 5El3C+3d tHrE4d\$ @s R34D";
$lang['gotofirstpostinthread'] = "gO +O F1R\$+ P0S+ 1N ThR34d";
$lang['gotolastpostinthread'] = "gO +0 L4\$+ PoS+ iN +hR34d";
$lang['viewmessagesinthisfolderonly'] = "vIEw m3\$\$493\$ IN +hi\$ FOlD3r onLy";
$lang['shownext50threads'] = "shOW NEX+ 50 +hR34Ds";
$lang['showprev50threads'] = "sH0w previ0U\$ 50 ThRE4D\$";
$lang['createnewdiscussioninthisfolder'] = "cREaT3 N3w discU5\$10n iN +H1S FOlDer";
$lang['nomessages'] = "nO m35\$@935";

// HTML toolbar (htmltools.inc.php) ------------------------------------
$lang['bold'] = "bOLd";
$lang['italic'] = "i+@LiC";
$lang['underline'] = "unD3rL1n3";
$lang['strikethrough'] = "sTRiK3+hR0u9H";
$lang['superscript'] = "suP3R5Cr1p+";
$lang['subscript'] = "su8ScRiPt";
$lang['leftalign'] = "lePH+-@ligN";
$lang['center'] = "c3nT3r";
$lang['rightalign'] = "r19Ht-4l1Gn";
$lang['numberedlist'] = "nUMB3r3D LiSt";
$lang['list'] = "lI\$+";
$lang['indenttext'] = "iNDeNT +EX+";
$lang['code'] = "cOd3";
$lang['quote'] = "qUOtE";
$lang['spoiler'] = "sP01LeR";
$lang['horizontalrule'] = "hOrIZ0Ntal rUle";
$lang['image'] = "iM@93";
$lang['hyperlink'] = "hypErl1Nk";
$lang['noemoticons'] = "d1s4bL3 EM0t1CoNs";
$lang['fontface'] = "fON+ pH4c3";
$lang['size'] = "s1zE";
$lang['colour'] = "cOlOUr";
$lang['red'] = "red";
$lang['orange'] = "orAngE";
$lang['yellow'] = "y3Ll0W";
$lang['green'] = "gr33N";
$lang['blue'] = "blUE";
$lang['indigo'] = "indIg0";
$lang['violet'] = "v1oL3t";
$lang['white'] = "wH1T3";
$lang['black'] = "bl4cK";
$lang['grey'] = "gr3Y";
$lang['pink'] = "p1nK";
$lang['lightgreen'] = "lI9H+ 9reeN";
$lang['lightblue'] = "lI9HT 8LuE";

// Forum Stats (messages.inc.php - messages_forum_stats()) -------------

$lang['forumstats'] = "fORUm \$+4+5";
$lang['usersactiveinthepasttimeperiod'] = "%s 4C+1v3 In tH3 P4st %s. %s";

$lang['numactiveguests'] = "<b>%s</b> GUe5+5";
$lang['oneactiveguest'] = "<b>1</b> 9u3S+";
$lang['numactivemembers'] = "<b>%s</b> MeMbEr5";
$lang['oneactivemember'] = "<b>1</b> mEMbeR";
$lang['numactiveanonymousmembers'] = "<b>%s</b> 4N0NyMOuS M3M83Rs";
$lang['oneactiveanonymousmember'] = "<b>1</b> @NoNyMOu5 M3M8eR";

$lang['numthreadscreated'] = "<b>%s</b> Thr34D\$";
$lang['onethreadcreated'] = "<b>1</b> +Hr3@D";
$lang['numpostscreated'] = "<b>%s</b> P0\$+\$";
$lang['onepostcreated'] = "<b>1</b> P0S+";

$lang['younormal'] = "j00";
$lang['youinvisible'] = "j00 (inviSi8L3)";
$lang['viewcompletelist'] = "v13W C0Mpl3Te lIs+";
$lang['ourmembershavemadeatotalofnumthreadsandnumposts'] = "our meM83rS H@Ve m@D3 @ tOt@l Of %s AnD %s.";
$lang['longestthreadisthreadnamewithnumposts'] = "lON935+ Thr34d 1\$ <b>%s</b> WitH %s.";
$lang['therehavebeenxpostsmadeinthelastsixtyminutes'] = "th3RE h4V3 bEeN <b>%s</b> p0\$+\$ M4dE 1N +HE l@S+ 60 m1NU+ES.";
$lang['therehasbeenonepostmadeinthelastsxityminutes'] = "thER3 h4S BE3N <b>1</b> P05+ M@d3 1N +HE L4St 60 mInUt3S.";
$lang['mostpostsevermadeinasinglesixtyminuteperiodwasnumposts'] = "m0S+ pOS+\$ EV3r m4D3 IN 4 \$iNgLe 60 minUt3 peRiOd i\$ <b>%s</b> 0N %s.";
$lang['wehavenumregisteredmembersandthenewestmemberismembername'] = "w3 H4Ve <b>%s</b> R3gI\$+Er3D m3m83rs @nD +hE n3w35+ M3mBeR 1s <b>%s</b>.";
$lang['wehavenumregisteredmember'] = "wE h4vE %s rEgiS+er3D MeM8ers.";
$lang['wehaveoneregisteredmember'] = "w3 H4vE 0nE r391St3R3d MEm8Er.";
$lang['mostuserseveronlinewasnumondate'] = "m0S+ USerS 3veR 0nLiN3 WaS <b>%s</b> 0n %s.";
$lang['statsdisplaychanged'] = "s+@+S dIsPl4Y Ch4n9ED";

// Thread Options (thread_options.php) ---------------------------------

$lang['updatessavedsuccessfully'] = "updAt3\$ \$4vEd \$UcCEs\$fUlLy";
$lang['useroptions'] = "u\$eR 0P+1OnS";
$lang['markedasread'] = "m4RkEd 4\$ rE4d";
$lang['postsoutof'] = "pOSt5 0uT OpH";
$lang['interest'] = "inT3R3\$+";
$lang['closedforposting'] = "cl0\$3d Ph0R p0\$+INg";
$lang['locktitleandfolder'] = "l0Ck T1tlE @nD FOldER";
$lang['deletepostsinthreadbyuser'] = "d3LE+e P0\$+5 iN +hr34d 8Y UsEr";
$lang['deletethread'] = "d3LE+E Thre4d";
$lang['permenantlydelete'] = "pERM4neNtLy dEL3+E";
$lang['movetodeleteditems'] = "moV3 +0 D3l3+ED thRe4DS";
$lang['undeletethread'] = "unDEL3t3 thr34d";
$lang['threaddeletedpermenantly'] = "thRE4d d3l3+eD peRmAN3n+lY. C@Nn0+ UNdEL3t3.";
$lang['markasunread'] = "mARk @S UnR34d";
$lang['makethreadsticky'] = "m@KE +hRE@d 5TiCkY";
$lang['threareadstatusupdated'] = "thR34d R3@d 5+4+Us uPd4t3D SUcc35\$FuLlY";
$lang['interestupdated'] = "thR3@d 1N+ER35+ \$+4+Us Upd4T3D \$ucC35SFuLly";
$lang['failedtoupdatethreadreadstatus'] = "f@1L3D tO UpD4+3 THRe4D Re4D St4tUS";
$lang['failedtoupdatethreadinterest'] = "f@IL3d tO upD4+e thRe4D 1Nt3ReS+";
$lang['failedtorenamethread'] = "f4IlEd +0 R3N4me tHr34D";
$lang['failedtomovethread'] = "f41LEd +O M0Ve tHrE4D t0 Sp3C1Fi3d FoLdEr";
$lang['failedtoupdatethreadstickystatus'] = "f@iL3d +0 uPD4+E thrE4d S+iCKy S+4TUs";
$lang['failedtoupdatethreadclosedstatus'] = "f4il3D +0 UPd4T3 tHRe4d cL0\$Ed sT4tUs";
$lang['failedtoupdatethreadlockstatus'] = "f41Led t0 uPd4+3 tHrE4D L0cK \$t4tU5";
$lang['failedtodeletepostsbyuser'] = "f@1Led +0 deL3t3 P0s+\$ 8Y SeL3ct3D U\$Er";
$lang['failedtodeletethread'] = "f41L3d t0 d3L3+E ThRe@d.";
$lang['failedtoundeletethread'] = "f@Il3D tO Un-D3l3TE +Hre@d";

// Dictionary (dictionary.php) -----------------------------------------

$lang['dictionary'] = "diC+1On4Ry";
$lang['spellcheck'] = "sPelL ChEcK";
$lang['notindictionary'] = "n0+ IN D1Ct1OnAry";
$lang['changeto'] = "ch4N9E +0";
$lang['restartspellcheck'] = "rE\$+4Rt";
$lang['cancelchanges'] = "cANCel Ch@n93S";
$lang['initialisingdotdotdot'] = "iNiTi@li\$ing...";
$lang['spellcheckcomplete'] = "spELl cH3cK 1s CoMpL3+E. +0 Rest4rT 5p3lL CH3ck Cl1Ck r3S+4Rt bUttoN BeLOw.";
$lang['spellcheck'] = "spELL check";
$lang['noformobj'] = "n0 F0Rm o8Jec+ Sp3c1Ph1eD phOr R3TUrn +3Xt";
$lang['bodytext'] = "boDY T3X+";
$lang['ignore'] = "iGNOrE";
$lang['ignoreall'] = "iGNoRe @ll";
$lang['change'] = "chAnG3";
$lang['changeall'] = "ch@nGe @Ll";
$lang['add'] = "aDD";
$lang['suggest'] = "su9gEs+";
$lang['nosuggestions'] = "(nO 5ugG3s+I0N5)";
$lang['cancel'] = "cAnC3l";
$lang['dictionarynotinstalled'] = "n0 dIcTion@rY H4\$ 833n 1NStaLl3D. pl34\$e C0nT4Ct tHe pH0RuM oWnEr tO ReM3Dy +h1\$.";

// Permissions keys ----------------------------------------------------

$lang['postreadingallowed'] = "p05+ r34DInG 4LloWEd";
$lang['postcreationallowed'] = "pOs+ CrE4t10n @llOW3d";
$lang['threadcreationallowed'] = "thR34D cRE4t10n 4LL0WeD";
$lang['posteditingallowed'] = "p0\$T ed1+1N9 AlL0w3d";
$lang['postdeletionallowed'] = "p0\$+ dElEtIoN @lloW3d";
$lang['attachmentsallowed'] = "a+T4ChmeNTS @lL0WEd";
$lang['htmlpostingallowed'] = "hTMl pOS+iN9 @LlOw3d";
$lang['signatureallowed'] = "sIGN4+Ur3 aLlOwED";
$lang['guestaccessallowed'] = "gU3S+ 4cc3Ss aLl0w3d";
$lang['postapprovalrequired'] = "p0\$T 4PPrOv@l rEqUIr3D";

// RSS feeds gubbins

$lang['rssfeed'] = "r55 pHe3d";
$lang['every30mins'] = "everY 30 m1nU+3\$";
$lang['onceanhour'] = "oNC3 @n h0uR";
$lang['every6hours'] = "ev3ry 6 h0URs";
$lang['every12hours'] = "eVERy 12 HoURS";
$lang['onceaday'] = "oNcE 4 d@y";
$lang['rssfeeds'] = "r\$S fE3dS";
$lang['feedname'] = "f33D N@m3";
$lang['feedfoldername'] = "fE3D pHoLdER N4M3";
$lang['feedlocation'] = "fEeD L0C@t1On";
$lang['threadtitleprefix'] = "tHReaD +iTlE preFiX";
$lang['feednameandlocation'] = "fe3D Nam3 4nD LoCAt1oN";
$lang['feedsettings'] = "f33D s3TtiN9s";
$lang['updatefrequency'] = "uPD@T3 FR3qU3ncY";
$lang['rssclicktoreadarticle'] = "cl1Ck h3Re to Re4D tHiS 4R+IcL3";
$lang['addnewfeed'] = "aDD N3W ph33d";
$lang['editfeed'] = "edIt FeeD";
$lang['feeduseraccount'] = "fE3D u5Er 4cc0un+";
$lang['noexistingfeeds'] = "no 3X1S+iNg rSs pH3eDS FoUnD. t0 4Dd @ pH3eD Cl1cK +3H '@dd n3W' 8UTtoN 83LoW";
$lang['rssfeedhelp'] = "h3r3 j00 c@N s3+Up S0me R5\$ FeeDs f0R @u+0mAT1C PropaG@t1On iN+0 YOur PhoRuM. +He iT3M\$ FROm +Eh r5\$ FeeDS J00 @dD wilL 8E Cr34+Ed aS +Hr34Ds wh1cH uSerS c4n reply T0 45 iF +heY WEr3 N0rm4l PoSt5. +hE RSs FeEd mUS+ 8E @cc3\$5iBl3 vi4 hT+P Or iT will NoT W0rk.";
$lang['mustspecifyrssfeedname'] = "mUST 5Pec1fY Rs5 PH3ed n4Me";
$lang['mustspecifyrssfeeduseraccount'] = "mUS+ \$PeCiFy rSs f3Ed u\$3r 4cC0uNt";
$lang['mustspecifyrssfeedfolder'] = "musT 5PeC1phy RS\$ fEED PH0ldEr";
$lang['mustspecifyrssfeedurl'] = "mUS+ SPeC1fY RSs fEed UrL";
$lang['mustspecifyrssfeedupdatefrequency'] = "mUst 5pec1Fy r\$\$ fEed uPdAT3 PhR3qU3ncY";
$lang['unknownrssuseraccount'] = "uNKn0Wn rS5 uSeR 4cC0Un+";
$lang['rssfeedsupportshttpurlsonly'] = "r55 FE3d \$UpPoR+\$ h+tp uRLS oNly. s3Cur3 FeEd5 (H+Tp\$://) 4R3 NoT \$uPpOrT3d.";
$lang['rssfeedurlformatinvalid'] = "r\$s f33D URL PhOrM4+ IS Inv@lId. Url mUs+ inClUd3 sChem3 (E.g. hTtP://) @nD 4 HO5+n4m3 (3.9. WwW.H0s+n4m3.c0m).";
$lang['rssfeeduserauthentication'] = "r5\$ ph33D DO3\$ NO+ \$UpP0RT H++p uSEr 4Uth3nT1cAtiOn";
$lang['successfullyremovedselectedfeeds'] = "suCc3S5fUlLy r3M0vEd sElecT3D pHe3d5";
$lang['successfullyaddedfeed'] = "sUCc3s5FuLlY Add3d NeW Ph3Ed";
$lang['successfullyeditedfeed'] = "sUcCeS\$PhULly 3D1+Ed ph3Ed";
$lang['failedtoremovefeeds'] = "f@1L3d to rEMoV3 S0Me oR 4Ll 0F Th3 \$EL3Ct3D Ph33ds";
$lang['failedtoaddnewrssfeed'] = "f4il3d +0 4Dd N3W R\$5 phEEd";
$lang['failedtoupdaterssfeed'] = "faIl3d TO UpD4+E r\$5 ph33D";
$lang['rssstreamworkingcorrectly'] = "r5S \$+rE4m @PPE@rS tO Be WORk1N9 CorRectLy";
$lang['rssstreamnotworkingcorrectly'] = "r55 \$+r3@m w4S 3mPtY 0R CoUlD nOt 8e fOUnd";
$lang['invalidfeedidorfeednotfound'] = "iNv@l1D Ph33d iD 0r pH3eD N0t f0UnD";

// PM Export Options

$lang['pmexportastype'] = "exPOrT 4\$ +YpE";
$lang['pmexporthtml'] = "htML";
$lang['pmexportxml'] = "xMl";
$lang['pmexportplaintext'] = "pL41N T3X+";
$lang['pmexportmessagesas'] = "eXP0r+ Me\$\$4GeS 4\$";
$lang['pmexportonefileforallmessages'] = "oN3 PHiLe FOr 4Ll M3\$\$a9E5";
$lang['pmexportonefilepermessage'] = "on3 pH1L3 p3R mES549E";
$lang['pmexportattachments'] = "eXP0R+ 4tT@ChM3N+\$";
$lang['pmexportincludestyle'] = "incLud3 PhOrUm s+yLe Sh3e+";
$lang['pmexportwordfilter'] = "aPPlY W0rd fIlTeR +0 mES54G35";

// Thread merge / split options

$lang['threadhasbeensplit'] = "tHR34d H@5 8EeN sPli+";
$lang['threadhasbeenmerged'] = "tHr34d h@s 833n M3r9Ed";
$lang['mergesplitthread'] = "m3RgE / 5Pli+ Thre@d";
$lang['mergewiththreadid'] = "m3RgE W1tH +hrE@d Id:";
$lang['postsinthisthreadatstart'] = "pO5+5 1N +h1S ThR34d 4+ 5+4Rt";
$lang['postsinthisthreadatend'] = "p0\$+5 in THi\$ +hr34D @+ enD";
$lang['reorderpostsintodateorder'] = "re-0rdEr pOs+\$ InTo d4T3 OrD3r";
$lang['splitthreadatpost'] = "sPL1+ tHrE4D @+ P0\$+:";
$lang['selectedpostsandrepliesonly'] = "sEl3C+3d p05+ 4nd R3Pl135 ONly";
$lang['selectedandallfollowingposts'] = "s3l3ct3d ANd 4lL fOLl0W1Ng P0S+5";

$lang['threadmovedhere'] = "h3RE";

$lang['thisthreadhasmoved'] = "<b>thR34D5 m3R9ed:</b> +h1S thre4d h4\$ m0VeD %s";
$lang['thisthreadwasmergedfrom'] = "<b>thRE4d5 MErgEd:</b> +hI\$ +Hr34D W4\$ meR93d phrOm %s";
$lang['somepostsinthisthreadhavebeenmoved'] = "<b>tHR3@D \$pL1t:</b> \$Om3 p0S+S 1n th1s +hr3@D H4Ve BeEn MOved %s";
$lang['somepostsinthisthreadweremovedfrom'] = "<b>tHRE4d sPlIt:</b> S0m3 PoS+5 iN +His tHr3@d wer3 MoV3D pHr0M %s";

$lang['thisposthasbeenmoved'] = "<b>tHr3Ad SplI+:</b> +hIS pOs+ haS 833N Mov3d %s";

$lang['invalidfunctionarguments'] = "iNv@l1D pHuNctiOn 4RgUm3Nts";
$lang['couldnotretrieveforumdata'] = "c0Uld Not Re+R1evE PhOrUm d4T@";
$lang['cannotmergepolls'] = "oNE OR MoR3 tHRe4dS I\$ @ pOLL. j00 C4Nn0T Mer9E PoLLs";
$lang['couldnotretrievethreaddatamerge'] = "coulD N0+ rE+r1EvE +hre4D D4Ta PHr0m On3 0R mOrE Thr34d\$";
$lang['couldnotretrievethreaddatasplit'] = "coulD n0+ r3+r1Eve tHrE4D D@+4 PHr0M 50UrC3 THr34d";
$lang['couldnotretrievepostdatamerge'] = "c0uLd nOt r3+R1Ev3 p0S+ d4+4 pHr0M 0N3 Or mOrE +hRe4D\$";
$lang['couldnotretrievepostdatasplit'] = "c0ULd n0t R3+r1eV3 p0ST D@+@ FrOM SoUrc3 thRE4d";
$lang['failedtocreatenewthreadformerge'] = "f4IL3d To cr34T3 n3w tHrE@d PHor MeR93";
$lang['failedtocreatenewthreadforsplit'] = "f@Il3D To cR3@T3 n3w +hr34D f0r SPL1t";

// Thread subscriptions

$lang['threadsubscriptions'] = "tHRE4d sU85cr1p+iONs";
$lang['couldnotupdateinterestonthread'] = "coulD n0T upD4+e IntER3s+ 0n +HrE4d '%s'";
$lang['threadinterestsupdatedsuccessfully'] = "thrE4D 1Nt3Re\$+5 uPd@t3D 5ucC35\$FuLly";
$lang['nothreadsubscriptions'] = "j00 4r3 n0+ \$u85Cr18ED +0 4Ny THrE4ds.";
$lang['resetselected'] = "rESe+ sEl3C+Ed";
$lang['allthreadtypes'] = "alL tHr3Ad TyP3\$";
$lang['ignoredthreads'] = "igNOr3D tHrE@D5";
$lang['highinterestthreads'] = "hi9H InTeReS+ +Hr34D\$";
$lang['subscribedthreads'] = "su8sCr18eD thre4D\$";
$lang['currentinterest'] = "cURreN+ iNt3r3\$t";

// Browseable user profiles

$lang['youcanonlyaddthreecolumns'] = "j00 c@N 0Nly 4dD 3 COlUmNs. +0 @DD 4 N3w c0lUMn CL0se @N 3X1\$+1n9 0N3";
$lang['columnalreadyadded'] = "j00 h4vE 4lr34dy @dDeD ThIs colUmN. 1F j00 w4N+ tO ReMoVe 1T CLiCk 1TS ClOSe 8UttON";

?>
