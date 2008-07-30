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

/* $Id: x-hacker.inc.php,v 1.292 2008-07-30 22:39:24 decoyduck Exp $ */

// British English language file

// Language character set and text direction options -------------------

$lang['_isocode'] = "en-gb";
$lang['_textdir'] = "ltr";

// Months --------------------------------------------------------------

$lang['month'][1]  = "j@nU4ry";
$lang['month'][2]  = "feBRuARy";
$lang['month'][3]  = "marcH";
$lang['month'][4]  = "april";
$lang['month'][5]  = "m4y";
$lang['month'][6]  = "juN3";
$lang['month'][7]  = "july";
$lang['month'][8]  = "auGU5t";
$lang['month'][9]  = "sePtEMBEr";
$lang['month'][10] = "oc+obeR";
$lang['month'][11] = "n0V3M8ER";
$lang['month'][12] = "dEC3MB3R";

$lang['month_short'][1]  = "j@N";
$lang['month_short'][2]  = "fEB";
$lang['month_short'][3]  = "mAR";
$lang['month_short'][4]  = "aPR";
$lang['month_short'][5]  = "m4Y";
$lang['month_short'][6]  = "jUN";
$lang['month_short'][7]  = "jul";
$lang['month_short'][8]  = "aUg";
$lang['month_short'][9]  = "s3p";
$lang['month_short'][10] = "oCT";
$lang['month_short'][11] = "nOV";
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
$lang['date_periods']['month']  = "%s MoN+H";
$lang['date_periods']['week']   = "%s WE3k";
$lang['date_periods']['day']    = "%s d4y";
$lang['date_periods']['hour']   = "%s h0uR";
$lang['date_periods']['minute'] = "%s m1nuTE";
$lang['date_periods']['second'] = "%s \$3c0Nd";

// As above but plurals (2 years vs. 1 year, etc.)

$lang['date_periods_plural']['year']   = "%s Y34R5";
$lang['date_periods_plural']['month']  = "%s MoNth\$";
$lang['date_periods_plural']['week']   = "%s W33K\$";
$lang['date_periods_plural']['day']    = "%s D4y\$";
$lang['date_periods_plural']['hour']   = "%s H0urs";
$lang['date_periods_plural']['minute'] = "%s MInU+e5";
$lang['date_periods_plural']['second'] = "%s S3C0ND\$";

// Short hand periods (example: 1y, 2m, 3w, 4d, 5hr, 6min, 7sec)

$lang['date_periods_short']['year']   = "%sY";    // 1y
$lang['date_periods_short']['month']  = "%sM";    // 2m
$lang['date_periods_short']['week']   = "%sW";    // 3w
$lang['date_periods_short']['day']    = "%sd";    // 4d
$lang['date_periods_short']['hour']   = "%sHr";   // 5hr
$lang['date_periods_short']['minute'] = "%smIN";  // 6min
$lang['date_periods_short']['second'] = "%sS3c";  // 7sec

// Common words --------------------------------------------------------

$lang['percent'] = "p3RcenT";
$lang['average'] = "aVEr493";
$lang['approve'] = "apPr0VE";
$lang['banned'] = "b4NN3D";
$lang['locked'] = "lOcK3d";
$lang['add'] = "aDD";
$lang['advanced'] = "aDV4NcEd";
$lang['active'] = "act1vE";
$lang['style'] = "s+Yle";
$lang['go'] = "g0";
$lang['folder'] = "foLder";
$lang['ignoredfolder'] = "igN0r3d pHold3r";
$lang['subscribedfolder'] = "sUB5CR183D F0lD3r";
$lang['folders'] = "fOld3rS";
$lang['thread'] = "thR34d";
$lang['threads'] = "tHR34d5";
$lang['threadlist'] = "thRe4d L1St";
$lang['message'] = "meS\$@9E";
$lang['from'] = "fR0m";
$lang['to'] = "t0";
$lang['all_caps'] = "all";
$lang['of'] = "opH";
$lang['reply'] = "rEPly";
$lang['forward'] = "f0rW4Rd";
$lang['replyall'] = "rEPlY TO @Ll";
$lang['quickreply'] = "quICk r3PlY";
$lang['quickreplyall'] = "quiCk repLY t0 @ll";
$lang['pm_reply'] = "r3Ply 4\$ PM";
$lang['delete'] = "dELe+3";
$lang['deleted'] = "dEl3+3d";
$lang['edit'] = "ed1+";
$lang['privileges'] = "pR1V1L39E5";
$lang['ignore'] = "igNor3";
$lang['normal'] = "noRm4l";
$lang['interested'] = "in+3rE\$+eD";
$lang['subscribe'] = "su85Cr1b3";
$lang['apply'] = "aPplY";
$lang['download'] = "doWNL0@D";
$lang['save'] = "s4V3";
$lang['update'] = "upD@tE";
$lang['cancel'] = "c@nC3l";
$lang['continue'] = "coN+iNu3";
$lang['attachment'] = "aT+4cHm3n+";
$lang['attachments'] = "aTTaChM3NtS";
$lang['imageattachments'] = "iM4Ge a++@cHmEn+\$";
$lang['filename'] = "fIl3naMe";
$lang['dimensions'] = "diMENsi0ns";
$lang['downloadedxtimes'] = "d0wNLO4D3d: %d +IME5";
$lang['downloadedonetime'] = "d0WNl04DEd: 1 tIMe";
$lang['size'] = "size";
$lang['viewmessage'] = "v13w M35s4G3";
$lang['deletethumbnails'] = "d3LE+3 +HumbNA1l5";
$lang['logon'] = "lOg0N";
$lang['more'] = "moR3";
$lang['recentvisitors'] = "reCEnt V1\$it0rs";
$lang['username'] = "u\$erN@mE";
$lang['clear'] = "cle4r";
$lang['reset'] = "reS3+";
$lang['action'] = "aCti0N";
$lang['unknown'] = "unkn0WN";
$lang['none'] = "noN3";
$lang['preview'] = "pr3vi3w";
$lang['post'] = "pOs+";
$lang['posts'] = "pO\$+\$";
$lang['change'] = "cH@NG3";
$lang['yes'] = "y35";
$lang['no'] = "n0";
$lang['signature'] = "s19n@+UR3";
$lang['signaturepreview'] = "s1gN4+uR3 PRev1Ew";
$lang['signatureupdated'] = "s1Gn4+UR3 upD4+ED";
$lang['signatureupdatedforallforums'] = "sI9n4+uRE Upd4Ted F0R 4ll pHoruM5";
$lang['back'] = "bACK";
$lang['subject'] = "subj3c+";
$lang['close'] = "cl0\$e";
$lang['name'] = "n4me";
$lang['description'] = "de\$Cr1pTIoN";
$lang['date'] = "d@t3";
$lang['view'] = "vI3w";
$lang['enterpasswd'] = "en+ER P4s5Word";
$lang['passwd'] = "p45sWOrD";
$lang['ignored'] = "i9N0reD";
$lang['guest'] = "gU3S+";
$lang['next'] = "neXt";
$lang['prev'] = "pREv1Ou5";
$lang['others'] = "o+H3R\$";
$lang['nickname'] = "niCKn@Me";
$lang['emailaddress'] = "em4iL @dDR355";
$lang['confirm'] = "c0NfiRM";
$lang['email'] = "eM@1L";
$lang['poll'] = "p0Ll";
$lang['friend'] = "fRIEND";
$lang['success'] = "sUCc3s5";
$lang['error'] = "eRr0R";
$lang['warning'] = "w4Rn1n9";
$lang['guesterror'] = "s0RRy, J00 NE3D +o 83 l09g3d 1N +O U5e tH1\$ FE4+uR3.";
$lang['loginnow'] = "l091N N0W";
$lang['unread'] = "uNrE4D";
$lang['all'] = "alL";
$lang['allcaps'] = "alL";
$lang['permissions'] = "p3rm1s\$ions";
$lang['type'] = "tYp3";
$lang['print'] = "pR1n+";
$lang['sticky'] = "s+1cky";
$lang['polls'] = "poll5";
$lang['user'] = "us3r";
$lang['enabled'] = "en@Bl3D";
$lang['disabled'] = "d1\$@8l3d";
$lang['options'] = "op+ion\$";
$lang['emoticons'] = "emO+Ic0n\$";
$lang['webtag'] = "wEBT49";
$lang['makedefault'] = "m4ke DepH4UL+";
$lang['unsetdefault'] = "un\$3+ D3Ph@UL+";
$lang['rename'] = "rEn4M3";
$lang['pages'] = "p49ES";
$lang['used'] = "uSeD";
$lang['days'] = "d@yS";
$lang['usage'] = "uS4G3";
$lang['show'] = "sH0W";
$lang['hint'] = "h1Nt";
$lang['new'] = "n3W";
$lang['referer'] = "referER";
$lang['thefollowingerrorswereencountered'] = "th3 PHolL0WInG 3RRor\$ w3R3 3NC0Un+EREd:";

// Admin interface (admin*.php) ----------------------------------------

$lang['admintools'] = "aDM1N +O0lS";
$lang['forummanagement'] = "foruM M4N@g3m3NT";
$lang['accessdeniedexp'] = "j00 DO N0t HavE p3rM1sS10N to U\$3 THI\$ \$3Cti0n.";
$lang['managefolders'] = "m4nAGE f0lD3R\$";
$lang['manageforums'] = "m@n4GE F0rUMS";
$lang['manageforumpermissions'] = "m4n@G3 PhORuM P3Rm1s\$1ON\$";
$lang['foldername'] = "fOlDER NAMe";
$lang['move'] = "m0VE";
$lang['closed'] = "cLos3D";
$lang['open'] = "oP3N";
$lang['restricted'] = "rES+riCT3D";
$lang['forumiscurrentlyclosed'] = "%s 1S cUrR3NTlY Clo5ED";
$lang['youdonothaveaccesstoforum'] = "j00 D0 NO+ haVE AcCESs +o %s";
$lang['toapplyforaccessplease'] = "to 4PPlY PhOR aCCe\$S Pl3aSe Con+4C+ ThE %s.";
$lang['forumowner'] = "f0rUm 0WN3r";
$lang['adminforumclosedtip'] = "iF J00 w4nT +o ch4n9E 5OM3 \$e+T1n9S 0n YOUR fOruM CL1Ck Teh 4dM1N L1nk 1N +h3 N4v194tIOn b4R 480V3.";
$lang['newfolder'] = "nEw F0LDeR";
$lang['nofoldersfound'] = "nO exi5+1Ng FOLdErS Ph0uND. TO @DD 4 FOLdER CL1CK tH3 '@Dd NEw' But+0N 83l0w.";
$lang['forumadmin'] = "f0rUm 4DMIn";
$lang['adminexp_1'] = "u\$e TeH MeNU On +3H lEF+ +0 M@N4G3 +HiNGS 1n Y0UR ph0RUM.";
$lang['adminexp_2'] = "<b>u53rs</b> AlL0W\$ J00 +0 \$3+ Ind1vIDU@l u\$ER PerM1SS1Ons, 1NClUD1N9 App0INtIN9 moDER4TOrS 4ND gaGG1Ng P30PL3.";
$lang['adminexp_3'] = "<b>u\$3r Gr0uPS</b> @LL0ws J00 TO cRE4TE u\$3R GR0UP\$ To @sSIGn P3RMIss10N\$ +0 4S M4NY 0R @\$ PH3W U\$3rS QU1CKLY 4ND E4S1LY.";
$lang['adminexp_4'] = "<b>b4N C0nTroLS</b> @LL0W\$ +h3 B4NNinG 4ND UN-8@NnIN9 OF iP 4DDR35S3s, H+TP ref3RErs, USERn4m3S, 3maiL ADDreSS3\$ 4nD N1CKN4MEs.";
$lang['adminexp_5'] = "<b>f0ldER\$</b> aLL0WS +h3 CR3@TI0N, m0d1f1C4+1oN 4ND dELe+1oN OPH F0LDerS.";
$lang['adminexp_6'] = "<b>rSS Phe3D5</b> all0WS j00 +0 M4n@93 RSS ph33D\$ PhOR PR0P494+1oN INto yoUR f0rUM.";
$lang['adminexp_7'] = "<b>pR0fILE\$</b> le+S j00 Cu5t0mI\$3 The I+EMS tH4T 4PpE4R 1N tH3 US3R Pr0phIl3S.";
$lang['adminexp_8'] = "<b>fOruM S3TTinG\$</b> 4LL0W\$ J00 +O cU5+0m1s3 YOur F0RUM'\$ n4mE, @Pp34rAnCE 4ND mANY oTHer +H1nGS.";
$lang['adminexp_9'] = "<b>sT4RT P@93</b> LE+s J00 cus+Om1S3 Y0ur f0RUM's St4R+ p493.";
$lang['adminexp_10'] = "<b>f0RUm \$TYlE</b> ALL0W5 J00 +0 93NER4+3 R4NdoM \$+yLE\$ Phor YOUr F0RUM M3Mb3RS +O U\$3.";
$lang['adminexp_11'] = "<b>w0RD pHIlTER</b> 4LLOws J00 +0 PHiLTER w0rD5 J00 d0n'+ w4nT to 83 US3d 0N yoUR FORUm.";
$lang['adminexp_12'] = "<b>p0StiNG sT@t\$</b> 9EN3R@+3S @ rEPOrT LI\$TInG t3h +0P 10 PO\$+3r\$ 1N @ d3phINEd P3RI0D.";
$lang['adminexp_13'] = "<b>f0rUM Link\$</b> LE+S j00 M@N49E TEH lINK\$ DR0PdoWN In tHe N@v194+IoN BAR.";
$lang['adminexp_14'] = "<b>v1EW LOg</b> lI5+\$ r3cENt 4C+10NS 8Y +3H f0RUM M0DeR4TORS.";
$lang['adminexp_15'] = "<b>m@n493 F0RUMs</b> LE+S j00 cRE4+E 4ND D3LE+3 4nd Clo\$3 OR rE0P3N FORuMS.";
$lang['adminexp_16'] = "<b>gloB@L pH0RUm 5ETt1N9\$</b> 4LL0wS j00 +0 moDIFY SetTinG\$ Wh1cH afPhECT @LL F0rUM\$.";
$lang['adminexp_17'] = "<b>pOst 4PPr0v4L qu3UE</b> aLLOWS J00 +O v1EW 4nY po\$TS 4W4I+1NG 4PPR0V4l 8Y @ modER4T0R.";
$lang['adminexp_18'] = "<b>vIs1+0R LOg</b> @Ll0W\$ J00 +O v1EW 4N EXtENdeD lI\$T 0f Vi\$1T0R\$ InCLuD1NG tHE1R H+TP r3PH3REr\$.";
$lang['createforumstyle'] = "cr34+3 4 FOruM StYL3";
$lang['newstylesuccessfullycreated'] = "new s+yL3 SUcc3\$sPHUlLY cRE@t3D.";
$lang['stylealreadyexists'] = "a s+Yle WI+H +HA+ F1LEN4M3 AlRE4DY 3X15+S.";
$lang['stylenofilename'] = "j00 DId NO+ eN+3R @ FIl3n@Me +0 S@VE +H3 \$+YlE Wi+H.";
$lang['stylenodatasubmitted'] = "c0ulD n0+ R3AD PhORUm \$+yLE d4t4.";
$lang['styleexp'] = "us3 +H1\$ P493 +o H3Lp CReA+3 @ R4nDOMLy g3N3R@ted \$tyLE FOR y0uR F0Rum.";
$lang['stylecontrols'] = "c0NtROLS";
$lang['stylecolourexp'] = "cliCK 0n 4 C0L0UR t0 MAke A nEW \$+YLE SheE+ BASEd 0N th4T C0L0UR. Curr3NT 8A\$3 coLOUR is FirSt 1N L1\$+.";
$lang['standardstyle'] = "s+4ND@rd S+yLE";
$lang['rotelementstyle'] = "r0t4T3D EL3M3nT s+YLe";
$lang['randstyle'] = "r4ND0M STyLE";
$lang['thiscolour'] = "tH1\$ C0L0uR";
$lang['enterhexcolour'] = "oR 3N+3R @ h3x c0lOUr TO 8@SE 4 n3W \$tYLe SHe3+ 0N";
$lang['savestyle'] = "s4v3 TH1\$ S+yLE";
$lang['styledesc'] = "s+yL3 DEScR1PTi0n";
$lang['stylefilenamemayonlycontain'] = "s+yL3 F1l3N@ME M4Y ONLY C0NT@iN l0werC@SE l3t+3Rs (@-Z), NuM8eR\$ (0-9) 4Nd unDERsC0RE.";
$lang['stylepreview'] = "s+yLE prEv13w";
$lang['welcome'] = "wElCOMe";
$lang['messagepreview'] = "m35s4GE PREv1Ew";
$lang['users'] = "uSERS";
$lang['usergroups'] = "uS3R 9roUps";
$lang['mustentergroupname'] = "j00 mUST 3NTER 4 9r0uP N4Me";
$lang['profiles'] = "pr0PhiLE5";
$lang['manageforums'] = "m@n4ge f0rUM\$";
$lang['forumsettings'] = "forUM \$3T+In9S";
$lang['globalforumsettings'] = "gLo8@L FOrUM \$3+TINg\$";
$lang['settingsaffectallforumswarning'] = "<b>n0TE:</b> THES3 \$3+T1ngS 4FfEC+ 4Ll PhorUMs. wHEre TEh 5e++INg I5 duPlic4+3D 0N T3H 1nD1vIdUAL phOrum'S Se++1NGS p@93 th4+ Will +ak3 PrEcedEncE 0V3r +3H \$3+TiN9S J00 chAN9E herE.";
$lang['startpage'] = "s+arT paGe";
$lang['startpageerror'] = "yOur 5+@R+ P49e coULd NOT 83 S4V3D LOC@LLY +o THE s3rVER 8eCAUS3 P3RMi\$s1oN W4S d3NieD.</p><p>to CHanGE Your ST4R+ p49E Ple4s3 CliCK tH3 DOwNlo4d BUTtON 83lOW wHIch WiLL pr0mPT j00 +0 \$4vE tHE fiL3 +0 YouR H4RD drIvE. J00 C4N tHen UpL04D +h1s F1L3 +0 y0uR \$3RV3R IN+0 ThE F0LL0WInG FOlDER, If N3C3Ss4rY Cre4+1N9 TEh FOLder STruC+uRE in Teh PR0C3\$S.</p><p><b>%s</b></p><p>plE4S3 N0TE +H@+ soME 8r0wsERS M4Y ch4NG3 T3H n4m3 0F The fIle Up0n DOWnlO4D. whEn UPL04D1nG +H3 F1L3 PLEA\$3 maK3 Sure ThA+ i+ IS n4M3d ST@RT_MA1N.PHP 0tH3RWIS3 yOUR st@rT P49e WILL 4PPE@R UnCHAN9eD.";
$lang['uploadcssfile'] = "uPl04D C\$S STyl3 SH33+";
$lang['uploadcssfilefailed'] = "yOuR Css 5TylE SHe3+ C0ULD No+ 83 UPL0@dEd +0 +3h sERv3R 83C4USE p3RMi\$s1ON W4\$ d3NIED.</p><p>tO chANgE YOUR \$+4RT p49e CSS StyLE sH3ET pLe4s3 En\$uR3 +3H pH0LLowiNG f0ldeR\$ eX1sT ANd 4RE wRIt4blE: </p><p><b>%s</b></p>";
$lang['invalidfiletypeerror'] = "iNV@L1D PH1lE +yP3, J00 C4N ONLY uPLO4d CSs S+yLE SHEe+ PH1LES";
$lang['failedtoopenmasterstylesheet'] = "y0uR PH0RUM \$TYL3 COUld no+ 83 S4v3D 8eC4USE +hE M@stER sTyl3 SH33+ coULD N0T b3 LO4DED. T0 S4v3 YOuR stYLE THE m4sT3R STYLE \$h3e+ (M4k3_\$+YL3.C\$s) MU\$T 8E LoC@TeD IN +3H \$+Yl3\$ D1r3CT0RY OF y0Ur 8EEHIv3 PH0RUM in\$+@LL4+10N.";
$lang['makestyleerror'] = "yoUr F0rUM s+YLE C0uLD NO+ b3 S4VED LOC@LLY +0 TH3 serVer 83C4U\$3 P3rM1Ss10N W@s d3N1ED.</p><p>tO \$4V3 YOUr PH0RUm STylE Ple4s3 CL1CK +HE D0WNlO4D 8UT+0N BeLOW WhiCH W1ll PromPT J00 +O SaVE +h3 F1L3 +0 YouR H4RD dRIV3. j00 C4N +H3N Uplo4D +h1s F1LE +0 YOuR SErV3R 1NTO teh F0LLow1NG f0LD3R, IPH nEC3SS4RY cRE4+1Ng TH3 f0lDEr \$+rUC+urE IN thE ProC3\$S.</p><p><b>%s</b></p><p>pLea\$3 notE +H4t 50m3 8R0wS3r\$ m@Y CH@nGe TEH n4M3 OF +H3 FILe Up0N doWnlO@d. wH3N UpLO@Ding TEH F1LE pL34SE M4K3 sURE +H@T 1+ iS N4M3d sTYLE.CSS o+H3Rw1SE +h3 fORUM s+YLE w1lL B3 UNAV@IL@8L3.";
$lang['forumstyle'] = "foruM S+YLE";
$lang['wordfilter'] = "woRD f1l+3R";
$lang['forumlinks'] = "forUM LinKS";
$lang['viewlog'] = "vi3W LOG";
$lang['noprofilesectionspecified'] = "nO PROFilE \$3cTI0N SPec1PHIEd.";
$lang['itemname'] = "it3M Nam3";
$lang['moveto'] = "mOv3 T0";
$lang['manageprofilesections'] = "m@n@GE PR0F1l3 \$3C+1ON5";
$lang['sectionname'] = "sEc+10N n4M3";
$lang['items'] = "it3m\$";
$lang['mustspecifyaprofilesectionid'] = "mU\$+ sPECifY 4 pr0PHiL3 SeCt10N 1D";
$lang['mustsepecifyaprofilesectionname'] = "mU5t SP3C1Fy @ pROF1L3 SecT10N n@M3";
$lang['noprofilesectionsfound'] = "nO EXI\$+1n9 Pr0fIL3 \$3CTI0NS PHOuND. +0 4Dd @ Pr0pHiL3 \$3CTi0n cliCk Th3 '4dD N3W' 8Ut+0N 83LOW.";
$lang['addnewprofilesection'] = "add N3W PR0PHIl3 \$3C+1oN";
$lang['successfullyaddedprofilesection'] = "sUCCESspHuLLy 4DDEd pR0Ph1L3 \$3CTiON";
$lang['successfullyeditedprofilesection'] = "sUcCESSpHULly EdIT3D PR0PhILe S3C+10N";
$lang['addnewprofilesection'] = "aDD N3W pR0f1L3 SECtION";
$lang['mustsepecifyaprofilesectionname'] = "musT SP3cifY @ PROF1L3 \$3cTION n@M3";
$lang['successfullyremovedselectedprofilesections'] = "sUCCE\$spHUlLY reMOv3d \$3l3cT3d ProF1L3 \$3CT10NS";
$lang['failedtoremoveprofilesections'] = "fAiL3D To REM0v3 pR0F1l3 \$3CT1ONS";
$lang['viewitems'] = "vI3w 1TEM\$";
$lang['successfullyaddednewprofileitem'] = "sucC3sSFULly @dDeD NEW Pr0f1LE IteM";
$lang['successfullyeditedprofileitem'] = "succESSPhuLLy ED1+3D PRofIlE 1T3M";
$lang['successfullyremovedselectedprofileitems'] = "sUcc3S5fULly R3MOvED seL3CTeD Pr0PHIl3 1TEMs";
$lang['failedtoremoveprofileitems'] = "f41lED to rEMOV3 ProF1L3 1T3M\$";
$lang['noexistingprofileitemsfound'] = "thERE 4R3 N0 EXI\$+1n9 PROFile ItEM\$ 1n +H1S S3C+1oN. TO @DD @n 1+3M cl1CK t3h '@DD NEW' 8UT+0N 8el0w.";
$lang['edititem'] = "eD1+ 1teM";
$lang['invalidprofilesectionid'] = "inv@L1D PR0PHiL3 \$3CTI0N 1D 0R \$3CTI0N nO+ FOUnd";
$lang['invalidprofileitemid'] = "iNV4l1D ProF1L3 I+3M 1d 0R I+3m nOT pHOUND";
$lang['addnewitem'] = "add NEw I+em";
$lang['youmustenteraprofileitemname'] = "j00 Mus+ 3N+3R 4 ProF1L3 I+eM N4M3";
$lang['invalidprofileitemtype'] = "iNv4L1D PRofIl3 ItEM tyPE \$EleCTeD";
$lang['youmustenteroptionsforselectedprofileitemtype'] = "j00 MUst 3N+3R \$0mE 0PtIONS f0r 5ELec+ED PROPh1lE I+EM TYPe";
$lang['youmustentermorethanoneoptionforitem'] = "j00 MU\$t 3nT3R MOr3 THaN OnE OP+10n PH0r s3LeC+3D ProFIle 1+3M tyPE";
$lang['profileitemhyperlinkssupportshttpurlsonly'] = "pr0phIL3 1T3m HyPERL1NK\$ SUPp0rT HTTp uRls 0NLy";
$lang['profileitemhyperlinkformatinvalid'] = "prOFiLE 1+3M hYPErl1NK FORM4T 1nV4Lid";
$lang['youmustincludeprofileentryinhyperlinks'] = "j00 muST 1nClUDE <i>%s</i> IN +3H uRL 0f Cl1CK48LE HYpERl1nKS";
$lang['failedtocreatenewprofileitem'] = "f4il3D +0 cr3@TE n3W PrOFIl3 I+3M";
$lang['failedtoupdateprofileitem'] = "f@1Led To UPdaTE pROF1L3 1+3m";
$lang['startpageupdated'] = "sT@R+ p49E UPd4+ED. %s";
$lang['cssfileuploaded'] = "css \$tYLE ShEE+ uplO4DED. %s";
$lang['viewupdatedstartpage'] = "vIEW uPD@T3D st@R+ p@93";
$lang['editstartpage'] = "ed1+ \$t@RT p49e";
$lang['nouserspecified'] = "n0 U\$3R \$Pec1F1ED.";
$lang['manageuser'] = "m@n49e USEr";
$lang['manageusers'] = "m4n493 U\$3RS";
$lang['userstatusforforum'] = "u\$3r \$+4+US F0R %s";
$lang['userdetails'] = "u\$3R D3t41l\$";
$lang['edituserdetails'] = "ed1t USEr D3t@IL\$";
$lang['warning_caps'] = "w@rNIN9";
$lang['userdeleteallpostswarning'] = "aR3 J00 \$URE J00 w4NT to DELE+3 4LL OF +h3 \$3l3c+ED uS3r'5 P0\$TS? 0nce +H3 P0\$TS @RE d3LET3D +H3Y c@NN0T 83 R3+RI3VED 4ND W1ll 8E LO\$+ pH0REV3R.";
$lang['postssuccessfullydeleted'] = "pOSTs W3RE \$UCC3SSPHuLLy DEL3+3d.";
$lang['folderaccess'] = "fOLD3R @CceS\$";
$lang['possiblealiases'] = "pOSs18l3 4L14\$3s";
$lang['ipaddressmatches'] = "iP 4DDre\$5 m4tch3\$";
$lang['emailaddressmatches'] = "eM41l ADdr3sS MaTCH3S";
$lang['passwdmatches'] = "p4S\$WORD Ma+CH3s";
$lang['httpreferermatches'] = "h++P R3FEREr M@TCH3S";
$lang['userhistory'] = "us3R HI\$torY";
$lang['nohistory'] = "no HIstORy REcoRDS s4V3D";
$lang['userhistorychanges'] = "ch4nGE\$";
$lang['clearuserhistory'] = "cl3ar U\$3R H1\$TORY";
$lang['changedlogonfromto'] = "cH@n9eD LOG0N PHROM %s +O %s";
$lang['changednicknamefromto'] = "cH4NgeD nicKN4mE pHR0M %s +0 %s";
$lang['changedemailfromto'] = "cH4NGED em@IL pHROm %s +o %s";
$lang['successfullycleareduserhistory'] = "sUcC3S5PHulLY cLEAreD uSER Hist0Ry";
$lang['failedtoclearuserhistory'] = "f4iL3D +O CLE4R Us3r H1\$+0RY";
$lang['successfullychangedpassword'] = "sUCcessFULlY cH@NgED P@s5w0Rd";
$lang['failedtochangepasswd'] = "f4iLED +0 CHaNGE PASSw0rD";
$lang['approveuser'] = "appROV3 USEr";
$lang['viewuserhistory'] = "view USEr HI\$+ORY";
$lang['viewuseraliases'] = "vIeW USER 4l14s3\$";
$lang['searchreturnednoresults'] = "sE4RCH r3tURN3D NO r3\$uLts";
$lang['deleteposts'] = "dElE+3 PO\$+s";
$lang['deleteuser'] = "dEl3+3 U5ER";
$lang['alsodeleteusercontent'] = "aLso D3L3TE @ll 0F The C0N+En+ CrEa+eD BY THIs U\$3r";
$lang['userdeletewarning'] = "ar3 J00 SURe J00 W@NT to d3LETe ThE \$3L3C+3D u\$3R @ccOUnT? oNce TEh @CcoUnt H4S be3N DeL3+3D It CaNN0+ bE r3TR1EV3D 4ND W1LL 83 L0\$+ foR3VER.";
$lang['usersuccessfullydeleted'] = "u\$ER SUcC3sSPHULLy D3L3T3d";
$lang['failedtodeleteuser'] = "f41L3d +o d3l3TE US3R";
$lang['forgottenpassworddesc'] = "iF +His U\$3r h@S ph0R9o+T3N +H31R p4sSWORd J00 C4N r3s3+ It PH0R +H3M hER3.";
$lang['failedtoupdateuserstatus'] = "f@Iled +0 uPd4t3 uS3R ST@TUS";
$lang['failedtoupdateglobaluserpermissions'] = "f4iLED +O upD4T3 GloB4L U\$3R peRMi\$S10NS";
$lang['failedtoupdatefolderaccesssettings'] = "f41LED +0 UPd4+3 f0LDer @cCE\$S \$3tTInG\$";
$lang['manageusersexp'] = "th1s L1\$T \$h0W\$ 4 5ELeCT10N 0F U53R\$ Wh0 H4Ve LO99Ed ON tO y0UR pHORum, s0rT3D bY %s. +o 4L+3R a US3R's P3RmiSSion\$ CLicK +He1r n4m3.";
$lang['userfilter'] = "us3R PhiltEr";
$lang['onlineusers'] = "oNLIN3 US3R\$";
$lang['offlineusers'] = "offL1NE uS3RS";
$lang['usersawaitingapproval'] = "u\$Er\$ AWaI+InG 4PPR0VAl";
$lang['bannedusers'] = "b@nn3D USERS";
$lang['lastlogon'] = "l@S+ L0G0N";
$lang['sessionreferer'] = "s3SS1On R3PH3R3r";
$lang['signupreferer'] = "sI9n-UP R3PH3ReR:";
$lang['nouseraccountsmatchingfilter'] = "n0 u5ER 4ccoUn+5 M@tcH1N9 Ph1lTEr";
$lang['searchforusernotinlist'] = "sE4RCh for 4 u\$3r n0+ IN L1St";
$lang['adminaccesslog'] = "adm1N @CcE\$\$ lO9";
$lang['adminlogexp'] = "th1S LI\$+ Sh0W\$ THe L4\$+ 4CTioN\$ \$4NC+10NEd 8Y us3rS wi+h ADMIN pRivIL3Ges.";
$lang['datetime'] = "d4+3/TImE";
$lang['unknownuser'] = "uNkN0WN u5eR";
$lang['unknownuseraccount'] = "unkNOWn u\$3R @Cc0UnT";
$lang['unknownfolder'] = "uNkNOWn PH0Ld3r";
$lang['ip'] = "ip";
$lang['lastipaddress'] = "l4ST ip ADdRE\$s";
$lang['hostname'] = "h0\$+N4M3";
$lang['unknownhostname'] = "uNkN0WN h05+NaME";
$lang['logged'] = "lO9GEd";
$lang['notlogged'] = "not L0GG3D";
$lang['addwordfilter'] = "add WOrD FiLTER";
$lang['addnewwordfilter'] = "aDD N3W W0rD PH1LT3R";
$lang['wordfilterupdated'] = "w0rD FIlTER UPD@T3D";
$lang['wordfilterisfull'] = "j00 C4NN0T @DD @ny M0R3 woRd PHiLT3RS. REm0v3 SOMe UNusED 0N3S 0R EDi+ +h3 EX1\$T1Ng oN3\$ f1Rs+.";
$lang['filtername'] = "fIlTER N@mE";
$lang['filtertype'] = "f1l+3R +YPE";
$lang['filterenabled'] = "f1l+ER 3n4BLEd";
$lang['editwordfilter'] = "eDIT worD FIl+3r";
$lang['nowordfilterentriesfound'] = "nO Ex1\$TInG w0RD fILT3r 3N+RIe\$ FOund. +0 4DD @ F1lT3R CLiCK +H3 'Add N3W' 8U++0n 83LOW.";
$lang['mustspecifyfiltername'] = "j00 MU\$t Sp3CIpHY @ PH1L+ER N@M3";
$lang['mustspecifymatchedtext'] = "j00 MUS+ SpEC1pHY M4+Ch3d T3x+";
$lang['mustspecifyfilteroption'] = "j00 mUSt SpEC1PHY 4 ph1lTEr 0p+10N";
$lang['mustspecifyfilterid'] = "j00 mus+ \$p3C1pHY @ Filt3r iD";
$lang['invalidfilterid'] = "iNV4lid F1L+3r ID";
$lang['failedtoupdatewordfilter'] = "f41l3D +0 uPD4TE wORD fil+eR. CH3CK th@+ +HE f1lt3R 5+ILl EX1\$ts.";
$lang['allow'] = "aLl0W";
$lang['block'] = "bl0cK";
$lang['normalthreadsonly'] = "norMAl +HRe4DS 0Nly";
$lang['pollthreadsonly'] = "p0LL +hRE@d\$ ONly";
$lang['both'] = "bo+h thREaD +yPe\$";
$lang['existingpermissions'] = "exis+in9 p3Rmi\$Si0Ns";
$lang['nousershavebeengrantedpermission'] = "nO 3x1\$+In9 US3r\$ peRM1sSION5 PhoUnd. TO 9r4N+ permISSION tO u\$er5 \$E4RCh FOr +HEM 83l0W.";
$lang['successfullyaddedpermissionsforselectedusers'] = "suCC3\$5PHULLy 4dd3D p3rMis\$I0NS phOR \$3leCTeD USerS";
$lang['successfullyremovedpermissionsfromselectedusers'] = "suCCeSSphULLy r3M0VEd P3rmISsion5 PHr0M S3LEctED USER5";
$lang['failedtoaddpermissionsforuser'] = "fA1l3d +0 Add Permi5sI0NS f0R USer '%s'";
$lang['failedtoremovepermissionsfromuser'] = "f41l3D +O rEmoVE peRmiSSioN\$ PHR0M U\$eR '%s'";
$lang['searchforuser'] = "s3aRCh phOR UsEr";
$lang['browsernegotiation'] = "brOWS3R N39O+1@T3D";
$lang['textfield'] = "tEx+ FiELD";
$lang['multilinetextfield'] = "mult1-L1n3 +3xT Ph1ELD";
$lang['radiobuttons'] = "r4d1o 8u++on\$";
$lang['dropdownlist'] = "droP D0WN LIS+";
$lang['clickablehyperlink'] = "cl1CK4Ble HypErLINk";
$lang['threadcount'] = "thrE@d cOUnT";
$lang['clicktoeditfolder'] = "clIck +o 3D1T FOlD3R";
$lang['fieldtypeexample1'] = "tO Cre@T3 r@D10 Butt0NS 0r A dR0p d0WN L1\$+ j00 N3ED +0 ENt3r 3ACH INd1vIDu4l ValU3 0N A SEP@rA+E l1nE IN +H3 OPT1oN\$ PHi3Ld.";
$lang['fieldtypeexample2'] = "t0 CR34+3 ClICK4BLe L1Nk\$ En+3R +H3 URl 1N +3h oPtI0Ns Ph13LD @ND U\$E <i>%1\$5</i> WHERe +H3 EnTRy phR0M tH3 U\$eR'S pR0FIL3 sh0ULD 4pP34R. 3x4MPl3s: <p>my\$P4C3: <i>htTP://WWW.mysp4cE.com/%1\$S</i><br />xb0X L1VE: <i>hT+P://prOPHiLE.my94M3RC4RD.nE+/%1\$\$</i>";
$lang['editedwordfilter'] = "eDI+3D W0RD fIl+ER";
$lang['editedforumsettings'] = "edi+3d F0RUm 5E++1NGS";
$lang['successfullyendedusersessionsforselectedusers'] = "sucC3SsFUlLY eNDED SE\$S10NS F0R \$3l3C+3D usER\$";
$lang['failedtoendsessionforuser'] = "f41LEd TO 3ND 53\$S1On ph0R Us3R %s";
$lang['successfullyapproveduser'] = "sUcc3SSFUllY 4PproV3D U\$3R";
$lang['successfullyapprovedselectedusers'] = "sucC3SSFUlLY 4PPr0vED \$3L3C+Ed uS3R\$";
$lang['matchedtext'] = "m4tCHed +eX+";
$lang['replacementtext'] = "repLAc3m3Nt +3xT";
$lang['preg'] = "pR3G";
$lang['wholeword'] = "whoLE wOrd";
$lang['word_filter_help_1'] = "<b>aLL</b> M4+CHes 494iN\$+ +3h wh0l3 +3X+ \$0 phILteR1NG m0m +0 MUm wIll 4l\$O CH4n93 M0MENt +0 MUm3n+.";
$lang['word_filter_help_2'] = "<b>wh0L3 W0Rd</b> M4+CHe5 4941NSt WHOl3 WORD\$ 0Nly S0 pHIl+ErING mOM tO MuM wiLL N0+ CH@n93 M0MenT To MUm3nt.";
$lang['word_filter_help_3'] = "<b>pR3g</b> 4lLOw\$ J00 +0 U\$3 P3RL R39UL4R exPR3SS1oN\$ +0 m@+ch TEX+.";
$lang['nameanddesc'] = "nam3 4ND dESCRiPT10n";
$lang['movethreads'] = "m0v3 THR3@d\$";
$lang['movethreadstofolder'] = "m0ve THR34DS +o PholDeR";
$lang['failedtomovethreads'] = "f41LEd TO m0VE +HR34D\$ T0 spECiPHIeD F0LD3r";
$lang['resetuserpermissions'] = "resE+ US3r PerMissI0N\$";
$lang['failedtoresetuserpermissions'] = "f4IL3d +0 REseT u\$ER P3RM1SS1oN5";
$lang['allowfoldertocontain'] = "aLLOW f0LD3R to CONt@IN";
$lang['addnewfolder'] = "aDd N3w F0lDER";
$lang['mustenterfoldername'] = "j00 mUS+ enT3R @ F0Ld3R n4ME";
$lang['nofolderidspecified'] = "n0 f0LDEr 1D SpEC1F1ED";
$lang['invalidfolderid'] = "inv@L1D F0LD3R 1D. chEcK +h@T 4 PH0LD3R WiTH +H1S ID EXI\$Ts!";
$lang['successfullyaddednewfolder'] = "sucC3SSFUllY @dDEd NEw F0LD3R";
$lang['successfullyremovedselectedfolders'] = "sUCCEssFULLy REMOvEd S3L3cT3D F0LD3R\$";
$lang['successfullyeditedfolder'] = "sucCE\$SPHulLy ED1TEd ph0lD3R";
$lang['failedtocreatenewfolder'] = "f41LED +0 CR3A+e NeW F0LD3R";
$lang['failedtodeletefolder'] = "f@1lED TO dELETe F0LD3r.";
$lang['failedtoupdatefolder'] = "f41Led +0 UPd4T3 F0LD3R";
$lang['cannotdeletefolderwiththreads'] = "c4nNOT d3LEte PH0lD3R\$ TH4T s+1LL C0NT@1n +hrE4D5.";
$lang['forumisnotrestricted'] = "f0rUM 1S Not Re\$TR1c+3D";
$lang['groups'] = "gr0Ups";
$lang['nousergroups'] = "nO u\$eR Gr0uPs H4V3 833N S3t UP. TO 4dD 4 GrouP cLIck +h3 'ADd NEW' BU++0n 83LOW.";
$lang['suppliedgidisnotausergroup'] = "sUPPL13D 91d I\$ nOT 4 US3R 9Roup";
$lang['manageusergroups'] = "m4Nag3 uS3R gROUP\$";
$lang['groupstatus'] = "group 5T@tus";
$lang['addusergroup'] = "add US3R 9ROUp";
$lang['addemptygroup'] = "add EMpTY gRouP";
$lang['adduserstogroup'] = "add U\$3RS +O GROup";
$lang['addremoveusers'] = "aDd/REmoVE uS3RS";
$lang['nousersingroup'] = "tHER3 4RE nO us3RS iN +H1S 9rOUp. ADd US3RS to tHIS 9R0UP 8y S34rChING f0R ThEM 8EloW.";
$lang['groupaddedaddnewuser'] = "sUCC3sSFulLY 4ddED gROUp. @dD U\$3RS +o thi\$ gRoup 8Y s34RCH1NG F0R +heM bEL0W.";
$lang['nousersingroupaddusers'] = "tH3rE 4RE n0 USErs 1N tHI5 GR0UP. +O @Dd US3RS cl1CK +h3 '4Dd/rEMOVe U\$3R\$' 8UT+0n 8EL0w.";
$lang['useringroups'] = "th1\$ U\$3R i\$ @ MEmB3R OpH t3H Ph0LL0wiNG gR0UPs";
$lang['usernotinanygroups'] = "thIs U5ER I5 Not 1N @nY USEr 9ROUP5";
$lang['usergroupwarning'] = "no+e: +hI\$ U53R MaY BE iNhERItIN9 4dDi+10n4l p3rMi\$S1oN\$ FROM 4NY u\$3R 9ROUp\$ liSTEd 8EL0W.";
$lang['successfullyaddedgroup'] = "succ35sPHuLLY 4DDEd Gr0up";
$lang['successfullyeditedgroup'] = "succ3SSFUllY 3D1T3D Gr0uP";
$lang['successfullydeletedselectedgroups'] = "suCC3sSFULly dELEtED S3lECTeD 9R0UP5";
$lang['failedtodeletegroupname'] = "f@1l3D TO DEL3+E gR0uP %s";
$lang['usercanaccessforumtools'] = "u\$ER c4N @Cc3\$S FoRUm TOOLs and c4n cRE4T3, d3lEtE 4ND eD1T PhoRuMS";
$lang['usercanmodallfoldersonallforums'] = "u53r C4N MoDEr@T3 <b>aLL pHOLd3r5</b> ON <b>aLL Ph0RuM\$</b>";
$lang['usercanmodlinkssectiononallforums'] = "u\$eR CaN m0Der4+e L1NKs S3CTi0n On <b>aLL pHORum\$</b>";
$lang['emailconfirmationrequired'] = "eM@IL CONFirM4+10N r3QUIReD";
$lang['userisbannedfromallforums'] = "u\$Er 1s B4NnED fr0M <b>all FOrUMS</b>";
$lang['cancelemailconfirmation'] = "c4NCeL 3MAIl ConF1RM@t10N @ND 4lLOw US3R T0 sT@r+ PO\$tInG";
$lang['resendconfirmationemail'] = "r3sENd COnPH1rM4T1ON eM4IL tO u\$3R";
$lang['failedtosresendemailconfirmation'] = "f@1LED +O R3\$3ND 3MAIL C0NPHiRM@Ti0n T0 US3r.";
$lang['donothing'] = "d0 N0+HIng";
$lang['usercanaccessadmintools'] = "us3R h@S @CC3SS T0 PhORuM 4DM1N +o0lS";
$lang['usercanaccessadmintoolsonallforums'] = "u53r h@s acc3\$S +0 4dM1N TOOls <b>oN 4lL f0RumS</b>";
$lang['usercanmoderateallfolders'] = "u5eR CaN M0D3RAt3 4Ll PHOld3R\$";
$lang['usercanmoderatelinkssection'] = "u\$er C4N MOD3R4T3 liNk5 \$3C+I0N";
$lang['userisbanned'] = "uS3r IS 8ANneD";
$lang['useriswormed'] = "u53r I\$ woRm3D";
$lang['userispilloried'] = "usER 1\$ PIlL0R13D";
$lang['usercanignoreadmin'] = "u\$ER c4n 1GN0R3 4DM1NI\$+R4+Ors";
$lang['groupcanaccessadmintools'] = "gR0uP c@N 4CC3SS 4DmIN to0LS";
$lang['groupcanmoderateallfolders'] = "gr0Up C4N M0d3r4+3 4LL fOLd3r\$";
$lang['groupcanmoderatelinkssection'] = "groUP c@N moDeR4T3 LINkS \$3CT10NS";
$lang['groupisbanned'] = "gR0UP 1S BaNNeD";
$lang['groupiswormed'] = "gR0uP 1\$ w0rM3D";
$lang['readposts'] = "r34d P0\$+s";
$lang['replytothreads'] = "r3PLY +o +HRE4Ds";
$lang['createnewthreads'] = "cR34te NEW +HreAds";
$lang['editposts'] = "ed1+ po\$+s";
$lang['deleteposts'] = "d3lET3 P0\$+s";
$lang['postssuccessfullydeleted'] = "p0STS \$uCC3SSphULLy D3L3+Ed";
$lang['failedtodeleteusersposts'] = "f41L3D +0 DeLEte US3R'\$ P0S+s";
$lang['uploadattachments'] = "upL04d 4Tt@CHM3ntS";
$lang['moderatefolder'] = "mODEr4te FOld3R";
$lang['postinhtml'] = "p0\$+ In HtmL";
$lang['postasignature'] = "pOs+ A S19N4+UR3";
$lang['editforumlinks'] = "ed1+ Ph0rUm L1NKS";
$lang['linksaddedhereappearindropdown'] = "l1NKS @DDEd hEr3 4PP3@r IN 4 DR0P D0WN 1n TeH ToP R19H+ oF thE PhR4M3 S3+.";
$lang['linksaddedhereappearindropdownaddnew'] = "l1nK\$ 4DDed H3Re APpe@r 1N 4 DRop d0wN 1N thE T0P r19HT Of tH3 Fr4mE \$E+. T0 4DD A L1Nk CL1CK +H3 '@dD n3w' 8U+tON 8EL0W.";
$lang['failedtoremoveforumlink'] = "f4iL3D +O Rem0VE FORum liNK '%s'";
$lang['failedtoaddnewforumlink'] = "f41LEd +0 4DD n3W phoRUm L1NK '%s'";
$lang['failedtoupdateforumlink'] = "f41L3d +o UPD@te f0RUM L1NK '%s'";
$lang['notoplevellinktitlespecified'] = "no +op L3VEL LInK TITL3 SP3CIf13d";
$lang['youmustenteralinktitle'] = "j00 mus+ eN+3R @ LInK +1Tl3";
$lang['alllinkurismuststartwithaschema'] = "aLL l1nK URIs MUS+ \$+@RT WI+H a SCH3m4 (I.3. H+TP://, pH+p://, 1RC://)";
$lang['editlink'] = "eD1T LiNK";
$lang['addnewforumlink'] = "add N3W F0ruM LInK";
$lang['forumlinktitle'] = "f0ruM l1NK +1TL3";
$lang['forumlinklocation'] = "foruM LInK LOc@T1ON";
$lang['successfullyaddednewforumlink'] = "sUcCESSpHULly adD3D nEW pH0RUm L1NK";
$lang['successfullyeditedforumlink'] = "sucC35sPHulLY 3D1+ED f0rUM l1nK";
$lang['invalidlinkidorlinknotfound'] = "inv4l1d LiNK id oR LINk NOt F0uNd";
$lang['successfullyremovedselectedforumlinks'] = "sucCE5\$PHuLLY R3m0VEd S3L3C+3D L1NKS";
$lang['toplinkcaption'] = "t0P L1NK C4PTiON";
$lang['allowguestaccess'] = "allow GuesT ACc3sS";
$lang['searchenginespidering'] = "se@RCH 3N9INe \$pIDEr1n9";
$lang['allowsearchenginespidering'] = "aLL0W s3@RCh 3NGiNE \$p1dERiNG";
$lang['sitemapenabled'] = "en4BLE sIt3MAP";
$lang['sitemapupdatefrequency'] = "sitEM4P uPD4T3 FREqUENcY";
$lang['sitemappathnotwritable'] = "s1T3M@p D1REc+0rY MUS+ BE wRI+48L3 bY Teh W38 S3RVer / pHP PR0C3sS!";
$lang['newuserregistrations'] = "n3W U53R RE9I\$Tr4T10NS";
$lang['preventduplicateemailaddresses'] = "prEv3N+ DUPl1c4t3 3M41L @DDr3ssES";
$lang['allownewuserregistrations'] = "alLOW N3W USEr RegI\$tR4T1oN5";
$lang['requireemailconfirmation'] = "requIRE 3m@1L COnf1RM4TI0N";
$lang['usetextcaptcha'] = "us3 +3xT-caPtCH@";
$lang['textcaptchafonterror'] = "t3xt-C4p+Ch4 hAs 8EEN d1sA8l3D 4u+0M4t1C@LLY b3C@USE TheRE @RE No +ruE Type PH0N+\$ AV41L@8L3 PH0R I+ +O use. PLe4se UPLoAD \$0me +rU3 +YP3 PH0N+\$ T0 <b>tex+_C4PTCh4/fON+\$</b> on y0ur \$3RVER.";
$lang['textcaptchadirerror'] = "t3x+-c@PtCHA H4\$ b3eN dI54BLEd BEc@US3 T3h +3XT_c@PTcH@ DIreCTorY 4nD sU8-D1R3CT0Ri3s @Re N0T wRiT4BLe 8Y thE w3B \$3rV3R / PhP pROC3SS.";
$lang['textcaptchagderror'] = "tEx+-c4p+ch4 H4S b33n d1S@8l3D 83C4U\$3 y0uR S3RVer'S phP \$e+Up DO3S n0t prOVIdE SuPP0R+ FOr GD iM49e m4N1PUL4T1ON 4nD / OR ++ph PHoN+ \$UPP0R+. BO+H aR3 R3QUir3D F0R +EXT-c4P+cHA suPp0rT.";
$lang['newuserpreferences'] = "neW u\$3R PREPhER3NCES";
$lang['sendemailnotificationonreply'] = "em@Il N0T1PH1c4+1oN On R3PLY +O usER";
$lang['sendemailnotificationonpm'] = "eMa1l NOt1pHIc@TI0N 0n PM +0 usER";
$lang['showpopuponnewpm'] = "sH0w poPuP wh3n RECeIVinG nEW PM";
$lang['setautomatichighinterestonpost'] = "s3t @UtOm4T1c H1gH In+3RE\$T 0N p0sT";
$lang['postingstats'] = "pOs+ING sT@t\$";
$lang['postingstatsforperiod'] = "p0\$+1nG \$+@ts pH0R pEr10d %s To %s";
$lang['nopostdatarecordedforthisperiod'] = "nO P0ST D@TA R3COrD3D pH0R thI\$ P3Ri0d.";
$lang['totalposts'] = "t0+@l PO\$+S";
$lang['totalpostsforthisperiod'] = "t0t4L P0sT\$ F0R ThiS PeriOD";
$lang['mustchooseastartday'] = "mus+ CH00sE a ST@R+ D@Y";
$lang['mustchooseastartmonth'] = "mus+ CH00sE 4 S+4R+ M0Nth";
$lang['mustchooseastartyear'] = "mUsT cho0S3 4 \$+@r+ Y3Ar";
$lang['mustchooseaendday'] = "musT CH0o\$e 4 3ND d4y";
$lang['mustchooseaendmonth'] = "mU\$+ cH0O\$e 4 3ND MON+H";
$lang['mustchooseaendyear'] = "mU5t cHO0\$3 A end Y34R";
$lang['startperiodisaheadofendperiod'] = "sT@RT PEr10D 15 4HE4D 0f eND peRioD";
$lang['bancontrols'] = "b4n CON+ROLS";
$lang['addban'] = "add B4N";
$lang['checkban'] = "cHEck 8AN";
$lang['editban'] = "eD1+ B4N";
$lang['bantype'] = "b@N +YP3";
$lang['bandata'] = "bAN d@+4";
$lang['bancomment'] = "c0mM3N+";
$lang['ipban'] = "ip B4N";
$lang['logonban'] = "lO90N B4N";
$lang['nicknameban'] = "n1CKN@M3 B@N";
$lang['emailban'] = "emaIL B4N";
$lang['refererban'] = "r3f3r3R 84N";
$lang['invalidbanid'] = "iNv4LID B4N iD";
$lang['affectsessionwarnadd'] = "tHIS baN m4Y @FFEct +3h f0LL0WiN9 4C+1Ve US3R sES\$1oN\$";
$lang['noaffectsessionwarn'] = "tHi\$ 84N @PHfEC+\$ N0 @c+1V3 S3SS10NS";
$lang['mustspecifybantype'] = "j00 MUst SPec1PHY @ 8aN TyP3";
$lang['mustspecifybandata'] = "j00 MU\$+ SPeCIPhY \$0mE b4N dA+a";
$lang['successfullyremovedselectedbans'] = "sucC35sPHULlY ReMOV3D \$3L3C+3D 8@n\$";
$lang['failedtoaddnewban'] = "f4iLeD +0 4dD N3w B4N";
$lang['failedtoremovebans'] = "f@iLEd +O R3moVE sOmE 0R 4lL Of T3h \$3LEctED 8an\$";
$lang['duplicatebandataentered'] = "duPL1cA+3 8@N d@T4 EN+3RED. PL34S3 CH3CK YOUR wILDCArd\$ +O s3e IF tHEY 4lR34DY M4+CH +Eh DA+a EN+3REd";
$lang['successfullyaddedban'] = "sucCE\$SPHULlY 4DDeD 84N";
$lang['successfullyupdatedban'] = "sucCESSPhULlY upDatEd B4N";
$lang['noexistingbandata'] = "theR3 1S N0 EX1S+1Ng 84N d@+4. +o 4DD @ 8AN CLIcK +h3 '@dD n3W' buTt0N B3LOW.";
$lang['youcanusethepercentwildcard'] = "j00 C4N US3 tH3 PeRC3n+ (%) W1LdC@Rd SYmB0l 1N aNy 0F yoUr 84N l1sTS +0 oB+41N part14L m@TcH3s, 1.E. '192.168.0.%' WOuLD baN 4Ll Ip AdDREs\$eS IN t3h R@N93 192.168.0.1 ThR0U9H 192.168.0.254";
$lang['cannotusewildcardonown'] = "j00 c4NN0+ @Dd % 4s 4 W1LDC@RD maTCh ON 1+S 0Wn!";
$lang['requirepostapproval'] = "reqUIr3 PO\$+ APpROV4L";
$lang['adminforumtoolsusercounterror'] = "tHeR3 Mu\$+ be 4+ L3@S+ 1 U\$3r WI+H 4DM1N +00ls aND F0rUM TOOls 4CC3S\$ 0N @LL pHorUMS!";
$lang['postcount'] = "po5T COUnT";
$lang['resetpostcount'] = "r3SE+ PO\$+ couNT";
$lang['failedtoresetuserpostcount'] = "f41L3D tO RE\$3+ PosT c0uN+";
$lang['failedtochangeuserpostcount'] = "f@1L3D +O Ch4n9E US3r P0ST coUNt";
$lang['postapprovalqueue'] = "p0ST 4pPR0VAL QU3UE";
$lang['nopostsawaitingapproval'] = "nO pOS+S 4rE 4W41+1Ng 4PpR0V@l";
$lang['approveselected'] = "aPpR0V3 \$3L3CT3D";
$lang['failedtoapproveuser'] = "f4iLED tO 4PPR0VE uS3R %s";
$lang['kickselected'] = "kicK S3LECt3D";
$lang['visitorlog'] = "v1si+OR LOG";
$lang['novisitorslogged'] = "n0 VISi+ORS L099eD";
$lang['addselectedusers'] = "aDd \$3L3C+3D U\$3R\$";
$lang['removeselectedusers'] = "r3m0vE \$3l3C+eD US3RS";
$lang['addnew'] = "add NEw";
$lang['deleteselected'] = "d3l3TE s3leCt3D";
$lang['forumrulesmessage'] = "<p><b>f0RUM rulES</b></p><p>\nr391sTR4T1oN +0 %1\$\$ Is Fr33! We D0 Insi\$T +h@+ J00 4B1DE 8y +hE RuLE\$ ANd POLiC1e\$ d3t@iL3D bELOw. 1Ph J00 @9Ree TO THE TErMS, pl34S3 Ch3cK t3H 'i 49R3E' cH3CK8Ox 4nD PResS +hE 'REG1ST3R' BUT+0N 8el0W. IF J00 W0Uld L1KE TO CaNCeL t3h R39IS+R4t1oN, Cl1Ck %2\$s +0 R3+urN tO tHE ph0RUMS iNdEx.</p><p>\n4l+H0U9h TEh ADM1NI\$tR4TORS @Nd M0D3R4+ORS 0f %1\$S W1LL @TteMPT T0 KEEp aLl 08JEC+1oN4BLE mESS4G3\$ OFF +H1\$ f0RUM, 1+ IS imPosS1BLE FOR US To Rev1eW 4Ll mESSAg3s. 4lL M3s5@G35 EXPR3\$s T3H VIeW\$ of TEH 4uTH0r, 4nd NE1THER +HE OwN3R\$ 0f %1\$S, N0r PrOj3ct 83ehIVE FORUM 4nd 1+'\$ 4FPH1lI@t3s w1lL B3 H3LD R3spons1bLE pHOR TEH C0N+ENT 0pH @Ny Me5S493.</p><p>\n8y 4GRE3iNG T0 tH3\$e ruL3s, j00 w4rr4nT TH4t J00 w1ll NO+ PoST @NY M3ss@Ges +H@+ ARE 0B\$Cene, VUL94r, \$3xu@LLY-OrI3nT@TED, H@TEPhuL, THRE4teN1N9, OR 0+HErW1se V1ola+1ve 0f 4nY l4w\$.</p><p>teh 0wn3r\$ 0F %1\$S rE\$3rve +H3 ri9H+ +o r3movE, 3d1t, M0VE OR CL0\$E @ny +Hr34d for 4Ny R3asoN.</p>";
$lang['cancellinktext'] = "here";
$lang['failedtoupdateforumsettings'] = "f41LED +O UPD4+3 F0RUM \$3tT1N9s. PLE4sE +RY agAin La+3r.";
$lang['moreadminoptions'] = "mOrE ADm1n OPTI0ns";

// Admin Log data (admin_viewlog.php) --------------------------------------------

$lang['changedstatusforuser'] = "ch4N93D USER s+@+U\$ PhoR '%s'";
$lang['changedpasswordforuser'] = "ch4N9ED p4\$swORD phOR '%s'";
$lang['changedforumaccess'] = "ch4n9ED F0RUM 4CCESS p3rMISS1oNS f0R '%s'";
$lang['deletedallusersposts'] = "d3L3+ED @LL p05+s PhoR '%s'";

$lang['createdusergroup'] = "cREA+ED USER 9ROUP '%s'";
$lang['deletedusergroup'] = "del3+3d USer Gr0UP '%s'";
$lang['updatedusergroup'] = "upd4T3D U5eR 9ROUp '%s'";
$lang['addedusertogroup'] = "add3d USeR '%s' +O 9ROup '%s'";
$lang['removeduserfromgroup'] = "remOV3 US3R '%s' Fr0m 9ROUP '%s'";

$lang['addedipaddresstobanlist'] = "aDDEd iP '%s' T0 84N L1ST";
$lang['removedipaddressfrombanlist'] = "rEM0VEd IP '%s' FR0M 84n L1\$+";

$lang['addedlogontobanlist'] = "aDd3d LOG0N '%s' +0 B4N L1ST";
$lang['removedlogonfrombanlist'] = "rem0VED LOG0N '%s' FR0M 8@n L1\$+";

$lang['addednicknametobanlist'] = "aDD3d NICKN4ME '%s' +0 B@n l1\$T";
$lang['removednicknamefrombanlist'] = "rEm0vEd N1cKN4m3 '%s' PHR0M 8an L1\$+";

$lang['addedemailtobanlist'] = "aDDEd Em41L 4DDRes\$ '%s' to 84n LI\$+";
$lang['removedemailfrombanlist'] = "remoVED 3M41l 4DDR3\$S '%s' pHR0M BaN L1\$T";

$lang['addedreferertobanlist'] = "aDd3d REFER3r '%s' +0 8@N LI\$T";
$lang['removedrefererfrombanlist'] = "rem0VED r3FEREr '%s' FroM 8An L1sT";

$lang['editedfolder'] = "ed1TeD ph0ld3r '%s'";
$lang['movedallthreadsfromto'] = "mOV3d @lL THRe4dS PhR0m '%s' TO '%s'";
$lang['creatednewfolder'] = "cR34TeD NEw pHOLD3r '%s'";
$lang['deletedfolder'] = "d3l3tED pH0lD3R '%s'";

$lang['changedprofilesectiontitle'] = "ch@Ng3d Pr0fIL3 \$3CTIoN Ti+lE PhR0M '%s' +o '%s'";
$lang['addednewprofilesection'] = "added N3W pROPHILe 5EC+10N '%s'";
$lang['deletedprofilesection'] = "d3lE+3D Pr0f1l3 5EC+i0n '%s'";

$lang['addednewprofileitem'] = "addED New PROf1lE I+3m '%s' +O s3C+1ON '%s'";
$lang['changedprofileitem'] = "ch4NGED pROF1l3 1+3M '%s'";
$lang['deletedprofileitem'] = "dEl3t3D Pr0f1L3 I+3M '%s'";

$lang['editedstartpage'] = "edi+3D \$t@rT p493";
$lang['savednewstyle'] = "s4v3D N3W S+yl3 '%s'";

$lang['movedthread'] = "movED thr3AD '%s' PhROm '%s' +0 '%s'";
$lang['closedthread'] = "cLo53d +hrE4D '%s'";
$lang['openedthread'] = "op3NED +Hr3@d '%s'";
$lang['renamedthread'] = "r3n4MED thR3@D '%s' +0 '%s'";

$lang['deletedthread'] = "dELE+3D +HR3@d '%s'";
$lang['undeletedthread'] = "uNDELETED +hRE4D '%s'";

$lang['lockedthreadtitlefolder'] = "l0CK3d +HREAD 0PTi0nS On '%s'";
$lang['unlockedthreadtitlefolder'] = "unl0CKED +HREAd 0p+10Ns ON '%s'";

$lang['deletedpostsfrominthread'] = "d3L3ted Pos+S phrOM '%s' In +HrE4D '%s'";
$lang['deletedattachmentfrompost'] = "d3lETED @T+4CHMEn+ '%s' PHrom POSt '%s'";

$lang['editedforumlinks'] = "edi+ED forUM L1nkS";
$lang['editedforumlink'] = "ed1tED PHORUm LInK: '%s'";

$lang['addedforumlink'] = "aDDEd PHORUm lINK: '%s'";
$lang['deletedforumlink'] = "del3tED f0rUm L1NK: '%s'";
$lang['changedtoplinkcaption'] = "ch4NGED ToP LiNK C4P+10N pHROm '%s' +O '%s'";

$lang['deletedpost'] = "dEleTED P0\$+ '%s'";
$lang['editedpost'] = "eD1teD P0st '%s'";

$lang['madethreadsticky'] = "m4D3 +HREad '%s' STICKy";
$lang['madethreadnonsticky'] = "m4dE +HrEAD '%s' NON-\$tICKY";

$lang['endedsessionforuser'] = "enDED \$3ssIon f0R UsER '%s'";

$lang['approvedpost'] = "appr0ved POs+ '%s'";

$lang['editedwordfilter'] = "eDITED WORD fiL+3R";

$lang['addedrssfeed'] = "addED r\$S F33D '%s'";
$lang['editedrssfeed'] = "eD1teD rSS pHEEd '%s'";
$lang['deletedrssfeed'] = "del3+3D R\$S PH3Ed '%s'";

$lang['updatedban'] = "uPD4+3d B4N '%s'. CH@nGEd TYPE FROm '%s' +0 '%s', cHaNGed D4T@ PHROM '%s' t0 '%s'.";

$lang['splitthreadatpostintonewthread'] = "spl1T +hRE4D '%s' 4+ PO\$+ %s  iN+0 N3W +HrEAD '%s'";
$lang['mergedthreadintonewthread'] = "m3R9eD +HRe4dS '%s' aND '%s' iNTO n3w +HRe4d '%s'";

$lang['ipaddressbanhit'] = "us3R '%s' 1s 8@NneD. ip @DdR3Ss '%s' M4TCh3d 8@n D4T@ '%s'";
$lang['logonbanhit'] = "u53r '%s' i\$ B4NN3d. LO90n '%s' M4TCh3d B4N dA+4 '%s'";
$lang['nicknamebanhit'] = "uS3r '%s' 1\$ b4NN3D. n1cKN4M3 '%s' M@Tched BaN D@+4 '%s'";
$lang['emailbanhit'] = "u\$3R '%s' 1s b4NN3d. eM41L 4DDRess '%s' MA+CheD B4n dA+A '%s'";
$lang['refererbanhit'] = "u\$eR '%s' IS 8aNN3D. H++p R3FER3R '%s' m4+cHED B4N D4T@ '%s'";

$lang['modifiedpermsforuser'] = "moDipH13D PeRMS PHOR u\$3r '%s'";
$lang['modifiedfolderpermsforuser'] = "m0diFI3d f0LD3R P3Rm\$ F0R U53R '%s'";

$lang['userpermfoldermoderate'] = "f0LDEr M0D3R4+0R";

$lang['adminlogempty'] = "aDm1n l0G is 3mP+Y";

$lang['youmustspecifyanactiontypetoremove'] = "j00 MUST SpECIFY @n ACT10n tYPE tO R3m0VE";

$lang['alllogentries'] = "alL l0G 3NTR13S";
$lang['userstatuschanges'] = "u5ER s+@tUS Ch4n93s";
$lang['forumaccesschanges'] = "fOrUm ACc3s5 Ch4N9E5";
$lang['usermasspostdeletion'] = "u53R m4sS PO5t Del3T10N";
$lang['ipaddressbanadditions'] = "ip 4dDrE\$S 8aN 4dD1TI0NS";
$lang['ipaddressbandeletions'] = "ip @DdR3\$S 8an DEle+1ON\$";
$lang['threadtitleedits'] = "tHr3@D t1tL3 3D1+S";
$lang['massthreadmoves'] = "m4ss +HReaD m0V3S";
$lang['foldercreations'] = "folD3R CR3@T1oNS";
$lang['folderdeletions'] = "fOlD3R d3lE+1On\$";
$lang['profilesectionchanges'] = "pR0phIL3 \$Ec+1oN chAngES";
$lang['profilesectionadditions'] = "pRoPHIlE S3C+1ON 4Dd1+1oNS";
$lang['profilesectiondeletions'] = "pRof1LE s3C+1oN deL3+10ns";
$lang['profileitemchanges'] = "pr0PHilE 1TEm cH4N93S";
$lang['profileitemadditions'] = "pR0fiLE i+3M 4DD1+10Ns";
$lang['profileitemdeletions'] = "pRopHIL3 1+3M delE+ioN\$";
$lang['startpagechanges'] = "st@RT p49e CH4NG3S";
$lang['forumstylecreations'] = "f0rUM STylE cRE@TIon\$";
$lang['threadmoves'] = "tHR3aD M0vE\$";
$lang['threadclosures'] = "thrE@d CloSUr3s";
$lang['threadopenings'] = "tHRe4D OP3N1n9S";
$lang['threadrenames'] = "tHRE4d REN@M3s";
$lang['postdeletions'] = "pOsT DEl3tI0N\$";
$lang['postedits'] = "post 3D1+S";
$lang['wordfilteredits'] = "w0Rd Ph1l+3R 3D1+s";
$lang['threadstickycreations'] = "thrE@D STiCKY crE4+10NS";
$lang['threadstickydeletions'] = "tHRE@d ST1CKy D3L3+1oN\$";
$lang['usersessiondeletions'] = "uS3r S3sS1oN D3Le+10n\$";
$lang['forumsettingsedits'] = "f0RUM 5E+TINg5 eD1+S";
$lang['threadlocks'] = "tHr34d L0CKS";
$lang['threadunlocks'] = "tHRE4d UNLOCk\$";
$lang['usermasspostdeletionsinathread'] = "useR M4ss pO5t D3L3+10N\$ IN 4 +hr3AD";
$lang['threaddeletions'] = "thr3AD d3l3T10NS";
$lang['attachmentdeletions'] = "a+t4cHMEnt D3L3TI0n\$";
$lang['forumlinkedits'] = "foruM L1NK eD1t\$";
$lang['postapprovals'] = "pOsT @PProvAl\$";
$lang['usergroupcreations'] = "u53R GR0UP crE4T10NS";
$lang['usergroupdeletions'] = "u\$ER 9r0up DELe+1oN5";
$lang['usergroupuseraddition'] = "u\$3r 9ROUP USER 4dd1+ION";
$lang['usergroupuserremoval'] = "us3r GROUP US3R REmoV@L";
$lang['userpasswordchange'] = "user P@SSW0RD CH@N9E";
$lang['usergroupchanges'] = "u\$er 9R0UP cH4NGes";
$lang['ipaddressbanadditions'] = "iP @dDR3\$\$ b4n 4DDI+10NS";
$lang['ipaddressbandeletions'] = "ip 4dDrEs5 B4N D3lE+1ONS";
$lang['logonbanadditions'] = "lo9on B4n aDDItioN\$";
$lang['logonbandeletions'] = "l090N b4n dELE+10NS";
$lang['nicknamebanadditions'] = "n1CKn@ME 8@N 4DD1+1oNS";
$lang['nicknamebanadditions'] = "n1cKN@me B4N @ddITI0ns";
$lang['e-mailbanadditions'] = "e-M4iL B@N 4DD1tIONS";
$lang['e-mailbandeletions'] = "e-m4IL 8@N D3L3+1ONS";
$lang['rssfeedadditions'] = "rSs PHE3D ADD1ti0N5";
$lang['rssfeedchanges'] = "r\$5 PHE3D CH4N93s";
$lang['threadundeletions'] = "tHrE@D uND3LE+10n5";
$lang['httprefererbanadditions'] = "hT+P R3PH3R3r b@N @DDI+1On\$";
$lang['httprefererbandeletions'] = "httP refER3r B4n DeLE+10Ns";
$lang['rssfeeddeletions'] = "rss PH3ED dEL3+I0NS";
$lang['banchanges'] = "b4N CHanGE\$";
$lang['threadsplits'] = "thr34d Spl1T\$";
$lang['threadmerges'] = "thRE4D M3R93\$";
$lang['forumlinkadditions'] = "fOrum LINk AdDITI0N\$";
$lang['forumlinkdeletions'] = "f0RUm L1NK d3le+1OnS";
$lang['forumlinktopcaptionchanges'] = "foruM L1Nk +0P C4PTI0N cH4nGe5";
$lang['folderedits'] = "f0ldeR 3Di+s";
$lang['userdeletions'] = "useR DelETI0NS";
$lang['userdatadeletions'] = "u\$eR d4T@ DELe+10NS";
$lang['usergroupchanges'] = "u\$er 9R0Up cH4nGE\$";
$lang['ipaddressbancheckresults'] = "iP 4dDRe\$s BAN Ch3cK r3\$ultS";
$lang['logonbancheckresults'] = "l0G0n 8@N cH3cK R3sULTS";
$lang['nicknamebancheckresults'] = "n1cKN@ME B4N Ch3CK R3\$uLT5";
$lang['emailbancheckresults'] = "em4il b@N CHEck R3SUlTs";
$lang['httprefererbancheckresults'] = "http REFEreR B4N Ch3cK R3sUL+s";

$lang['removeentriesrelatingtoaction'] = "r3M0VE EN+rI3s R3l4T1NG to 4C+10N";
$lang['removeentriesolderthandays'] = "rEM0VE EN+R1ES 0ld3R +H4N (DAY\$)";

$lang['successfullyprunedadminlog'] = "sucC3s5PHULlY PRUned 4dM1N L0G";
$lang['failedtopruneadminlog'] = "f4ILed +0 Prun3 4DmiN lo9";

$lang['successfullyprunedvisitorlog'] = "succE5sFULly prUN3D v1s1TOr LOG";
$lang['failedtoprunevisitorlog'] = "f@1lED +o pRUN3 Vi\$ITOR L0G";

$lang['prunelog'] = "pRUNE log";

// Admin Forms (admin_forums.php) ------------------------------------------------

$lang['noexistingforums'] = "no EXIST1N9 F0RUMS Ph0uND. +o CR3a+3 4 N3w F0RUM CL1cK teH 'ADD n3W' 8U+TON 8EL0W.";
$lang['webtaginvalidchars'] = "weB+@9 C@N Only CoN+AIN uPPERCase A-Z, 0-9 @ND UNDEr5COr3 CH@r@C+3R\$";
$lang['databasenameinvalidchars'] = "d4T@8@5E N4ME C@N ONLy C0nT41N @-Z, @-z, 0-9 AND Und3R\$c0r3 CH4R@cTERS";
$lang['invalidforumidorforumnotfound'] = "inv4L1d f0RUm F1d OR pHORUM N0T FOUND";
$lang['successfullyupdatedforum'] = "sucC3\$SFULlY UPd4t3D PhoRUM";
$lang['failedtoupdateforum'] = "f@1LED T0 UPD4Te F0RUm: '%s'";
$lang['successfullycreatednewforum'] = "sUcCE\$SPHulLY cReA+3d N3W F0RUm";
$lang['selectedwebtagisalreadyinuse'] = "tH3 SELEc+eD WEb+aG I\$ 4LRe4Dy 1N USE. pL3ASE ch0O\$3 @n0tHeR.";
$lang['selecteddatabasecontainsconflictingtables'] = "tHe \$eLEC+3d DA+aB4sE c0n+41NS COnfLiC+1N9 T4BLES. C0NFLIc+IN9 T4BLE n4M3\$ 4RE:";
$lang['forumdeleteconfirmation'] = "aR3 J00 SUr3 J00 W4nT +o d3LETE 4LL 0f tHE 5ELEctEd PHOrUMS?";
$lang['forumdeletewarning'] = "pLE@\$E noTE tH4T j00 C4NNOT rEc0VER d3l3+3D PH0RUm\$. 0NCE deL3T3D 4 f0RUM 4nD 4lL of TEh @\$S0C14+3D D@T4 1S P3rm4n3N+Ly R3M0VEd fR0M Th3 Da+484S3. 1F J00 D0 NO+ WisH to D3lE+3 Teh \$3LEC+ed F0RUM\$ PL3A\$E cLICk C4NCEl.";
$lang['successfullyremovedselectedforums'] = "suCC3SSFULLY d3lE+3D \$3lECteD phORUMS";
$lang['failedtodeleteforum'] = "f41L3D TO DEl3+3d PHORUM: '%s'";
$lang['addforum'] = "aDd F0RUm";
$lang['editforum'] = "eD1t PHORUm";
$lang['visitforum'] = "viSI+ FORum: %s";
$lang['accesslevel'] = "acCE\$S LeV3l";
$lang['forumleader'] = "f0rUM L34d3R";
$lang['usedatabase'] = "us3 DA+AbA\$3";
$lang['unknownmessagecount'] = "unKN0wN";
$lang['forumwebtag'] = "forUM WEb+4g";
$lang['defaultforum'] = "d3f4uL+ F0ruM";
$lang['forumdatabasewarning'] = "pLE4sE 3N\$uRE J00 \$3LEc+ +3H CORreC+ d4T4BA53 WHeN crE4tING 4 N3W F0RUM. 0NCe CR3A+3d 4 New F0RUM C@nn0T 83 M0VEd 83TwE3n 4vaiL4BLe D4T4B4S3S.";

// Admin Global User Permissions

$lang['globaluserpermissions'] = "gLoB@L u\$3R P3RMi\$SI0NS";

// Admin Forum Settings (admin_forum_settings.php) -------------------------------

$lang['mustsupplyforumwebtag'] = "j00 MUST sUPPly A F0Rum wEB+a9";
$lang['mustsupplyforumname'] = "j00 MUS+ sUPply @ Ph0RUM N4M3";
$lang['mustsupplyforumemail'] = "j00 muST Supply 4 pH0rUM em@iL 4DDRe5s";
$lang['mustchoosedefaultstyle'] = "j00 MuS+ cH00S3 @ DEPH4ulT Ph0rum STYLe";
$lang['mustchoosedefaultemoticons'] = "j00 mU5+ ch00se D3ph4Ul+ forum 3MoTiCons";
$lang['mustsupplyforumaccesslevel'] = "j00 muSt 5UPPly a FORUM @CCES5 LEVEl";
$lang['mustsupplyforumdatabasename'] = "j00 mUST supPlY 4 PHORUm DA+@8aSE N4ME";
$lang['unknownemoticonsname'] = "uNkNoWn EMO+1cON\$ N4M3";
$lang['mustchoosedefaultlang'] = "j00 MU\$+ ch0oS3 4 D3pH@UL+ fORUM l@nGU493";
$lang['activesessiongreaterthansession'] = "aC+iV3 S3\$S1oN TImE0UT C4NNO+ 83 GrE4T3R +H4N S3ss1oN +Im30uT";
$lang['attachmentdirnotwritable'] = "a+TACHm3N+ D1R3c+0RY And \$YS+3M +EMp0r@RY Dir3c+0RY / PHp.IN1 'UPlo4d_+mP_DIr' MUST b3 WRiTAbLE By +HE weB SErVER / PHP pR0C3ss!";
$lang['attachmentdirblank'] = "j00 MU\$+ sUPpLY 4 DIREctoRY +0 s@VE @++4cHM3N+S In";
$lang['mainsettings'] = "m41n S3+TIng\$";
$lang['forumname'] = "f0rUM N4ME";
$lang['forumemail'] = "fORUm eMaiL";
$lang['forumnoreplyemail'] = "n0-REPly em41l";
$lang['forumdesc'] = "f0rUM DE\$CRiPT10N";
$lang['forumkeywords'] = "f0rUM K3yW0RD\$";
$lang['defaultstyle'] = "dEf4uL+ \$tyL3";
$lang['defaultemoticons'] = "dePhAul+ Emo+1CON\$";
$lang['defaultlanguage'] = "dePHAUlT L4N9u49E";
$lang['forumaccesssettings'] = "foRUM 4cCESS \$3+TiNG5";
$lang['forumaccessstatus'] = "foruM 4CC3\$S ST4Tus";
$lang['changepermissions'] = "chaNGE p3RMIS\$1on\$";
$lang['changepassword'] = "ch4n93 P4\$SW0RD";
$lang['passwordprotected'] = "p45Sw0rd PROtecT3D";
$lang['passwordprotectwarning'] = "j00 H4V3 N0T S3T 4 Ph0ruM p@5\$woRD. IPh J00 DO NO+ s3T @ p4SSW0RD +H3 PAssWORD PROteC+1ON PHunc+10N4L1+Y WILL 83 4U+OM4TIc@LLy D1\$4BL3D!";
$lang['postoptions'] = "p0ST op+1ONS";
$lang['allowpostoptions'] = "aLloW P0\$T 3DIT1N9";
$lang['postedittimeout'] = "p05+ EdiT +1MEOUt";
$lang['posteditgraceperiod'] = "p0St 3DI+ GR4CE P3Ri0D";
$lang['wikiintegration'] = "w1KIWiKI 1N+39RA+1oN";
$lang['enablewikiintegration'] = "enaBLe Wik1WIK1 inTEGr4T10N";
$lang['enablewikiquicklinks'] = "eN48l3 WIkiW1KI quICk L1NK\$";
$lang['wikiintegrationuri'] = "w1KIWIki LOca+10n";
$lang['maximumpostlength'] = "m@x1Mum p0sT l3nG+H";
$lang['postfrequency'] = "posT FR3QU3NCY";
$lang['enablelinkssection'] = "enaBLe L1NKS \$3cTi0n";
$lang['allowcreationofpolls'] = "aLL0W Cr3@Ti0n OF p0LL\$";
$lang['allowguestvotesinpolls'] = "all0W 9UES+s +O VoTE 1N poLLS";
$lang['unreadmessagescutoff'] = "uNrE4D m3sS4gES cu+-0fPh";
$lang['disableunreadmessages'] = "d15@8l3 UNreAD m3s54Ge5";
$lang['thirtynumberdays'] = "30 d@ys";
$lang['sixtynumberdays'] = "60 D4Ys";
$lang['ninetynumberdays'] = "90 D@ys";
$lang['hundredeightynumberdays'] = "180 DAYS";
$lang['onenumberyear'] = "1 Y3@R";
$lang['unreadcutoffchangewarning'] = "d3p3NDINg ON sERvER p3rFORM@nC3 @nd tEH nUM83R 0F +hR3AD5 Y0UR f0RUm\$ conT41N, ch4NGInG THe UNrEAD cuT-oFPh M@Y +4K3 5EV3R4L mINUte\$ +0 C0mPleT3. F0R +hiS REas0n 1+ I\$ R3C0mMEnD3D TH4+ J00 @voID CH@NGINg +H1\$ \$3+T1N9 WhIL3 YoUR foRUMs AR3 8USY.";
$lang['unreadcutoffincreasewarning'] = "incREASIn9 TEH UNREad CU+-0fF W1LL reSULT 1n ThR34d\$ 0lDer Th4n +EH CURr3NT cuT-0FPH 4PPe4rIN9 @S uNr3@D pHOR 4LL us3RS.";
$lang['confirmunreadcutoff'] = "ar3 j00 SUR3 j00 w4NT +O cH4N9E thE UnREAd cu+-0FF?";
$lang['otherchangeswillstillbeapplied'] = "clIck1N9 'N0' W1LL 0NLy C4nCeL Th3 UNRead cUT-0FF cH4NGE\$. OTh3r Ch@Ng3s YOU'V3 M4D3 WIlL \$T1ll BE s4VED.";
$lang['searchoptions'] = "searCH Opt10N\$";
$lang['searchfrequency'] = "s34RCh PHr3QUEncY";
$lang['sessions'] = "s3\$S1oN\$";
$lang['sessioncutoffseconds'] = "se\$S1on cu+ OFf (S3CONds)";
$lang['activesessioncutoffseconds'] = "ac+IVE S3ssiOn CuT Off (S3Cond\$)";
$lang['stats'] = "sTA+\$";
$lang['hide_stats'] = "h1de \$T4Ts";
$lang['show_stats'] = "sh0W S+a+S";
$lang['enablestatsdisplay'] = "eN4BLe ST@tS d1\$PL@y";
$lang['personalmessages'] = "pEr50N4L M3sS4Ges";
$lang['enablepersonalmessages'] = "eN48l3 P3R50N4l M3SSAGe\$";
$lang['pmusermessages'] = "pm M3ss@9es PEr U\$3R";
$lang['allowpmstohaveattachments'] = "all0W peR\$0n@l M35SAge\$ +0 h@Ve @tT4CHmeN+s";
$lang['autopruneuserspmfoldersevery'] = "aU+o PRun3 U\$3R'5 pm pHolDER\$ EverY";
$lang['userandguestoptions'] = "uSER 4nD Gu3s+ 0Pt10NS";
$lang['enableguestaccount'] = "eN@BL3 Gu3s+ 4CC0UN+";
$lang['listguestsinvisitorlog'] = "l1ST 9Ue\$+s IN VI\$iTOR LOg";
$lang['allowguestaccess'] = "alL0W guE5T @CCe\$5";
$lang['userandguestaccesssettings'] = "u\$3R @ND GU3s+ ACcESS \$3t+1NGS";
$lang['allowuserstochangeusername'] = "aLloW U\$3RS +0 CHANge US3Rn4m3";
$lang['requireuserapproval'] = "r3Qu1R3 U\$3R @PprOV4L 8Y AdmIN";
$lang['requireforumrulesagreement'] = "r3qu1R3 U\$3R to @gR3E +0 F0RuM ruLE\$";
$lang['sendnewuseremailnotifications'] = "s3ND n0Tif1C@T10N +o 9LOb4l f0RUM oWNeR";
$lang['enableattachments'] = "eNa8L3 @TtAChM3N+s";
$lang['attachmentdir'] = "a++@CHM3NT D1R";
$lang['userattachmentspace'] = "at+@chM3Nt SP4CE p3r useR";
$lang['allowembeddingofattachments'] = "aLL0W 3mB3DDin9 0F @tTAcHMEn+S";
$lang['usealtattachmentmethod'] = "uS3 4l+ERn4+1VE 4+TacHMeN+ M3+H0D";
$lang['allowgueststoaccessattachments'] = "aLLOW 9U3sTS +0 4Cc3sS 4+TAcHMeNTS";
$lang['forumsettingsupdated'] = "foRUM s3+T1NG\$ \$UCc3\$sphULlY UpD@teD";
$lang['forumstatusmessages'] = "f0Rum St4tUS m3s\$@Ges";
$lang['forumclosedmessage'] = "f0rUM CLOSEd ME\$s4g3";
$lang['forumrestrictedmessage'] = "f0rUM r3STr1c+3D Me5s49E";
$lang['forumpasswordprotectedmessage'] = "f0rUM paSSw0rD pr0TEcT3D m3\$S@ge";

// Admin Forum Settings Help Text (admin_forum_settings.php) ------------------------------

$lang['forum_settings_help_10'] = "<b>pOst EdiT +im3ouT</b> i\$ +h3 +1Me In MinUT35 @ph+ER pOST1NG TH4+ 4 U\$3r C@N Ed1t Th3ir poSt. IF \$e+ +0 0 THER3 I\$ N0 Lim1T.";
$lang['forum_settings_help_11'] = "<b>mAX1mUM POst LENgtH</b> 1S THE M4XIMUM NUMbeR 0F ch@R4c+3R\$ Th4t W1LL 83 D1\$PL4yeD 1n 4 POST. 1F 4 PO5+ iS loNGER +H@n +H3 NUMBer OPH cH@r@C+ER\$ dEPHinED heRe I+ W1lL 8e CUT \$HoRT @ND @ l1nK 4DDED TO THE 80++OM +O @lL0W USERS +0 R3AD +he WHOl3 Po\$+ 0N @ S3p4r4TE P493.";
$lang['forum_settings_help_12'] = "if J00 DOn'T w@N+ YOUR US3RS To 83 48l3 +O CR3@te pOLL\$ J00 C@n dIS48L3 THe 4B0V3 0P+10N.";
$lang['forum_settings_help_13'] = "t3H L1NKS \$EC+1ON of 8EEH1ve Pr0V1D3s A pL@CE pHOr YOuR USer\$ +o M@1n+@1N @ LI\$+ 0PH 5I+es +Hey pHR3Qu3nTly V1S1+ +h@+ 0+H3R us3R\$ M4Y fIND U53FUL. L1NKs C@n 8e d1V1D3D 1n+O catEgoRi3s by PhoLd3r 4Nd 4LLOW f0R COMMeNT\$ 4ND R@tiNGS +O 83 91V3N. iN ORD3R TO M0D3r@Te +H3 LInK\$ \$3CTI0n @ Us3R MUST B3 R@nT3d 9L0B4L mODERAT0r 5t4+U\$.";
$lang['forum_settings_help_15'] = "<b>se5s10n CU+ 0FF</b> I\$ +H3 M4xiMUM tiM3 B3F0r3 4 US3R'S \$3\$SION 1\$ DE3M3D D34d 4ND THEY @r3 LoGgeD 0ut. By DEF4uL+ THI5 iS 24 HoUR\$ (86400 S3coND\$).";
$lang['forum_settings_help_16'] = "<b>act1vE \$3\$SiON Cu+ 0FF</b> is +He M4xIMUm TiM3 BEF0R3 A uSeR'S SESSioN IS D33MED 1N4C+1VE @+ Wh1cH POInT +HEy 3N+3R an IDl3 \$+4t3. In THis S+@t3 +H3 US3R R3M41n\$ loGGed 1N, bu+ Th3y Are R3m0v3D FR0m THe 4c+1V3 U53r5 L1s+ In +3H \$+4TS Di\$PL@y. OnC3 +H3y B3COm3 4C+1Ve 49AiN TheY w1lL 83 r3-4DD3D T0 +3H LisT. BY dePH@ULT THI5 \$3+TInG iS s3+ +o 15 MiNUTes (900 s3C0NDS).";
$lang['forum_settings_help_17'] = "eN@BL1n9 THi\$ 0P+i0n 4LL0W\$ 8eeH1VE To iNCLUdE @ St@t\$ D1sPL4Y @+ +3H boTtoM OF Teh ME\$\$@93\$ p4n3 \$iM1L4r To Th3 0nE usED 8y M@ny F0RUM SOF+waR3 +1+LE\$. oncE 3NABLEd +H3 Di\$PL@y 0f THe S+@T\$ P@GE c@n BE +0G9Led INdiv1DU@lLY BY 3@Ch US3R. IPH TH3Y don'T W@nT to S3E I+ +H3Y cAN hID3 1+ Fr0M vi3W.";
$lang['forum_settings_help_18'] = "perSONAl M3S\$@93s @r3 Inv4LU@8l3 A\$ 4 W4y OF T4K1N9 m0R3 PriVA+e M4++3R\$ 0u+ 0F V1ew OF tHe 0+H3R mEMbeR\$. HoWEVeR ipH j00 D0N't w@n+ y0uR u\$3r\$ +0 83 4BLE TO s3ND 34Ch OTHeR PeRsON4L mE\$S49ES J00 C4N Di5ablE ThIS 0PTi0N.";
$lang['forum_settings_help_19'] = "p3rSONaL m3Ss4GE5 c4n 4L\$0 C0NT@in 4+t4cHm3NTS WHIcH C4N 83 U\$3Ful F0R 3xch4N91Ng fil3\$ B3+W3EN US3R\$.";
$lang['forum_settings_help_20'] = "<b>note:</b> thE Sp4C3 4LLOC4t10N Ph0r pm 4TT@chm3N+S I\$ T4k3N frOM 34CH USERS' M41N @t+ACHm3n+ 4LLoc4TI0N @Nd 1s NO+ In 4DD1+1ON TO.";
$lang['forum_settings_help_21'] = "<b>en48l3 9UE5+ 4CcOUN+</b> 4LL0w\$ V1S1+0rS +0 8ROW53 Y0ur F0rUM @nd R34d POS+S WI+h0U+ rEGIS+3RIN9 4 US3r 4CCOunT. 4 u\$3R 4cC0UNT 1S s+1LL R3QU1RED iph +H3Y w1sH TO poS+ 0R ch@Nge USER pR3f3rEnC3s.";
$lang['forum_settings_help_22'] = "<b>l15+ Gu3sTS In VIsiToR l0g</b> 4LloW\$ J00 +O SPeC1PHy Wh3+HER oR n0+ uNR3GI\$T3r3d US3Rs 4R3 LisT3D ON t3H VISi+OR l0G 4LonG\$1DE R3gI\$+3RED us3RS.";
$lang['forum_settings_help_23'] = "beeHiV3 @LL0WS 4+T4CHMEn+S +O 8e UPl04d3d t0 MESS493\$ WheN P0\$ted. iPh J00 H4VE L1MI+ED wEB SP@C3 J00 M4Y WhicH To Dis@BL3 4TT4CHMEn+S By CLE4RIN9 T3H 80x 4BOVE.";
$lang['forum_settings_help_24'] = "<b>a++@CHM3NT d1R</b> i5 tEH Loc@ti0N 8eEH1VE \$hOuLD ST0R3 A++@ChM3NTs 1n. +h1\$ d1rEC+oRY muST 3XIst On Y0UR WEB \$paC3 4ND MusT 8e Wri+48lE bY TeH wEB \$3RVeR / pHP ProC3ss 0+H3rWi\$3 UploAd\$ W1Ll PHaIL.";
$lang['forum_settings_help_25'] = "<b>a++ACHM3N+ sP4CE p3R USER</b> i\$ +H3 M4X1MUM 4MOUNT oPH D1sK SP4CE 4 Us3r H@S pHor A++@cHM3n+S. ONc3 THI\$ \$p4C3 1s US3d UP T3h U\$3R C4Nnot UPL04d 4NY Mor3 4tT4CHMEN+S. 8Y D3ph4ULT TH1\$ I\$ 1m8 0f \$P4c3.";
$lang['forum_settings_help_26'] = "<b>aLl0w EMbEDD1NG OF 4+T4chM3N+s 1N Me\$S@93s / SiGN4tUR3\$</b> @LLOWS uS3RS tO 3m8eD A++@CHm3N+S In P0sT\$. 3N@8L1N9 +H1s 0PT10N Whil3 USEFUl C@n 1NCRe@SE Y0uR B4NDwID+H uS@gE DRas+1C@LlY UNder CerT41n C0nf19uR4T10ns 0f PHP. IpH J00 HAV3 L1mi+Ed 8@Ndw1d+H i+ I\$ r3C0mM3nD3D +H@T J00 D1\$4BL3 +h1S 0pt1on.";
$lang['forum_settings_help_27'] = "<b>u53 @LTeRN@tIv3 4T+4CHMeNT m3+h0D</b> foRCE\$ BE3H1V3 To US3 4N aLT3RNA+iV3 REtr1EV4L m3tHOD F0R 4+t@CHm3n+S. 1ph J00 R3C31V3 404 ErR0R m35sAGES wH3N +RY1Ng T0 DownL04D 4Tt4cHM3N+s FROM m3sS@Ge\$ +RY 3N48l1N9 +H1S 0p+10N.";
$lang['forum_settings_help_28'] = "tHES3 S3T+1NG\$ 4LLOw\$ yOUR f0RUM +O 83 \$pIDered 8Y SE@RCh EN9INe\$ LiKE GOOGl3, @lT@Vi\$+@ @Nd Y4HOO. If J00 SW1+cH THi\$ 0PTi0n 0fPh YOUr F0RUm WIlL nO+ 83 INcLUDed iN Th3s3 s34Rch enGIneS R3sUL+s.";
$lang['forum_settings_help_29'] = "<b>aLL0w NEW U\$3r RE9ISTR4+ION\$</b> 4LL0WS 0R D1s4LLOWs T3H CrEA+10N 0F NEW uSEr 4ccoUNTS. s3+TInG ThE OP+10N to N0 COmPL3T3Ly dISA8L3\$ t3H R391S+R4t10N PH0RM.";
$lang['forum_settings_help_30'] = "<b>en@blE WiKIW1kI 1n+3GR@+I0N</b> PR0VIDe\$ WiKIW0Rd SUPp0R+ 1N y0uR PhoRUm PO\$T5. 4 w1K1w0RD 1s M4dE Up OF +W0 OR MOR3 C0NC@teN4T3D W0RDS W1+H UPp3rC@s3 LETt3r\$ (oF+3n R3F3RR3D +O @s cAMElc4s3). if J00 WRi+E 4 W0RD +h1s W4Y It W1LL autoM4+1C4lLY BE Ch@NGED iN+0 @ hYP3RLINk P0IN+1nG to Y0UR ch0\$3N W1K1W1KI.";
$lang['forum_settings_help_31'] = "<b>eNaBL3 WIk1WIKI QUIck L1NKS</b> 3N48lES +h3 U\$3 0F MSg:1.1 @Nd US3R:LOgon \$TYLe EX+3ND3D WIk1LInK\$ WH1Ch CRE4+3 Hyp3RlinKS +o +3H SP3CIF1ED m3s5493 / U\$3R ProPHiL3 0F +HE \$PEcif1ED US3R.";
$lang['forum_settings_help_32'] = "<b>wIkIWIkI LOc4+10n</b> I5 USED TO spECiphY TEh uRI 0f Y0UR W1kiW1KI. WH3N 3Nt3rIN9 thE UrI US3 <i>%1\$S</i> to IND1C4TE wh3RE in THE Uri +H3 w1k1WORd shouLD 4pp34r, 1.3.: <i>h++P://3n.WIKIp3di@.0r9/WIKi/%1\$S</i> woULd lINK y0ur W1kIW0rds +0 %s";
$lang['forum_settings_help_33'] = "<b>f0ruM 4CCess ST4Tus</b> CONTROls H0W US3R\$ M4Y 4CC3Ss YOUR ph0RUM.";
$lang['forum_settings_help_34'] = "<b>opEN</b> w1LL 4LLOW @LL USERS 4nD 9UES+s ACCess +0 Y0UR Ph0rUM WIth0UT RE\$tr1CTI0N.";
$lang['forum_settings_help_35'] = "<b>clos3d</b> PR3V3NT\$ 4CC3SS PHOr 4lL USErs, Wi+H +H3 3xC3PTION oF +H3 4dM1N Who M@y \$+1LL aCC3SS thE 4DMiN p4N3L.";
$lang['forum_settings_help_36'] = "<b>r3S+Ric+3D</b> 4LL0WS T0 \$3+ A l1\$+ 0F U\$3R\$ wh0 AR3 all0Wed 4CC3SS T0 YOUR F0RUm.";
$lang['forum_settings_help_37'] = "<b>p@5sWORD PRO+3cTED</b> 4LLOWS J00 +O S3+ a P4SsWORD tO 91VE 0ut +O u\$3RS SO tH3Y C4n @CC35s y0uR F0RUM.";
$lang['forum_settings_help_38'] = "wh3n SE++1nG rESTR1C+3D 0R P4SSW0RD PRO+3CT3D M0D3 J00 wiLL NEED +0 S4v3 Y0UR CH4NG3s B3F0r3 J00 C@N Ch@NGE Th3 Us3r @CCESs PRivIL39ES 0R p@s\$WORD.";
$lang['forum_settings_help_39'] = "<b>Search Frequency</b> defines how long a user must wait before performing another search. Searches place a high demand on the database so it is recommended that you set this to at least 30 seconds to prevent \"search spamming\"fR0M K1Llin9 +H3 sErV3R.";
$lang['forum_settings_help_40'] = "<b>poST pHr3qU3NcY</b> IS tHE MInimUM +1Me 4 U5ER mUS+ W41+ 83F0r3 +h3y Can PO\$+ 49@1N. +hi5 5eT+1n9 4LS0 4phFEC+s +HE Crea+I0N OF POllS. S3t To 0 +0 D1S48L3 Th3 rEstRiCTIoN.";
$lang['forum_settings_help_41'] = "tHe 4bOV3 oPti0N\$ ch@NGe +EH dEFAUL+ VALU3s Ph0R +h3 uSEr RE9IS+ra+1ON foRM. wheR3 4PPl1C@8Le oThER S3++1N9s w1LL U\$3 +h3 phORum'\$ 0wN dEPH4Ult s3TtiNG5.";
$lang['forum_settings_help_42'] = "<b>prEvEnt U\$e 0f Dupl1C@tE 3M@iL 4DDrE\$\$e\$</b> PH0RceS b33hiVe T0 Ch3CK +h3 USEr @Cc0uN+s 494IN\$+ +h3 emAil 4Ddre5\$ tHe UseR 1\$ RE91\$+3RInG wi+h 4ND PROmP+S +Hem T0 u\$3 4No+h3r 1F It 15 4Lr34dY 1N u\$E.";
$lang['forum_settings_help_43'] = "<b>rEqU1RE Em4IL COnF1Rm@Ti0N</b> whEN eNABleD WIlL \$3ND 4N 3M41L to 3ACH n3w USeR WiTH @ L1nK +H@T caN 83 US3D To C0Nf1Rm +hEIR 3MAiL AdDrE\$s. uNTiL thEY cONf1rM +HEiR 3M41L 4ddr3sS +H3y W1LL NO+ B3 4BLe +0 PO\$t UNLes5 THEIr U\$3R PERMI\$s1ONs 4RE CH@n93D M4nu4LLY By @N @DMin.";
$lang['forum_settings_help_44'] = "<b>uSE t3x+-C4P+ch4</b> PREseNTS +H3 NEw UsER wIth 4 M4NGL3D 1MAGe WhICH tHEy MU\$+ COpY 4 NumBer FR0M IN+0 4 +3x+ ph13LD oN teH REg1\$+RatI0N phoRM. USE THI\$ 0p+10n +0 Pr3vEnt 4UT0M4+3D s19N-UP v1@ SCr1P+S.";
$lang['forum_settings_help_47'] = "<b>p0\$T 3D1+ Gr4cE pERI0D</b> 4LL0W\$ j00 TO DEFInE 4 p3RI0D In MINuT3s wHERe USeR\$ M4Y EdIT P0STS wI+hOU+ tEH 'eD1+3D 8y' +3xT aPP3Ar1NG On +H31R pOSTS. iF S3+ +0 0 +3H '3D1TEd BY' +3x+ WilL 4LW4y\$ 4pPE4R.";
$lang['forum_settings_help_48'] = "<b>unr3@d m3ss49eS Cu+-0PHpH</b> \$pECIPhIE\$ H0W lONg ME\$s@9ES r3m41N UnR34d. tHReAD\$ M0D1f13D N0 l4+ER tH@N T3H pERI0D S3L3CTED w1ll @u+OMa+IC4LLy @Pp3@R @\$ R3Ad.";
$lang['forum_settings_help_49'] = "ch0OS1N9 <b>d1S48lE UNre@d ME\$S@9E5</b> W1LL coMPLE+3Ly R3M0V3 Unr3AD mE\$s@g3S \$uPP0R+ @nd REM0v3 tHe ReL3VAn+ 0P+10NS PhR0M +eH D1scusS1ON +Yp3 DR0P DOwn 0N t3H +HreAD l1\$+.";
$lang['forum_settings_help_50'] = "<b>requIRE U5ER 4PpR0V4L 8y 4DM1N</b> 4LLOw5 J00 T0 Re\$+R1CT 4CCess BY nEW us3R\$ uNTiL theY h4V3 8EEN 4PPR0veD 8Y @ MODER@TOR OR 4dmiN. wI+hOuT 4PPR0VAl A US3R C4NnoT @cCES5 4NY 4re4 OF Teh 83EH1ve F0RUM in\$T@ll4TI0n 1NCLUdIN9 INd1vIDU@l PhoRUMS, PM in80x 4ND My F0RUM\$ S3CTI0n\$.";
$lang['forum_settings_help_51'] = "u\$e <b>cl0S3D MESSAg3</b>, <b>rE5+RIcT3D meSS49E</b> 4nD <b>paSsW0RD PROteCT3D m3\$Sag3</b> TO cu\$+omI\$3 ThE Me5s49e D1sPLAy3d WHen US3r\$ 4CC3SS YouR f0RUM 1N +3h v@R1OUS s+@TE\$.";
$lang['forum_settings_help_52'] = "j00 C4N U\$E h+ML 1N Y0UR MES5493\$. HYpeRL1Nks 4Nd 3m4IL ADDr3ss35 WIlL 4L\$0 B3 @uTOm4+1C@lly ConVErT3D +0 lINk5. +0 USE +EH dEF4ULt B33HiVE pH0RUm M3\$s49E\$ CL3aR +H3 Ph1eLDS.";
$lang['forum_settings_help_53'] = "<b>alL0w U53R\$ +o cHANg3 uS3RNaME</b> pERMi+S 4lR34DY Re91sT3RED us3R\$ +0 CHanG3 THEir U\$3rn4m3. WhEN en4Bl3D J00 caN TRACK +H3 CH4NGeS @ us3r MakE\$ +O +h31R USeRn4ME Vi4 tHE 4DMIn U53R toOLS.";
$lang['forum_settings_help_54'] = "uSE <b>f0Rum RUl3S</b> +0 eN+3R @n @CcepT48L3 U\$3 POL1cy +H4+ e4cH U5eR MUST 49RE3 To 83F0R3 R391sTER1n9 ON YouR foRum.";
$lang['forum_settings_help_55'] = "j00 c@N us3 H+Ml IN y0uR phORUm rULEs. hYPErL1NK\$ 4ND 3m4IL aDDrE\$S3\$ W1LL @ls0 83 4u+0M4+1c4LLy C0NVERTeD t0 LinK5. +O U5e THe DEPh@UL+ B3EH1V3 F0RUM 4up CLEAR +HE PHieLD.";
$lang['forum_settings_help_56'] = "u53 <b>nO-REPlY EM4IL</b> +O SPecIFY @N eM@Il 4DDr3s5 +H4+ D03S N0T 3x1\$t 0R wiLL NoT 83 MONI+0R3d F0R R3PL1E\$. THi\$ em41L 4DDR3Ss wiLl 83 USEd IN +hE He4D3r\$ PHOr ALL EM41LS S3N+ pHR0M Y0ur PHORum INCLUd1ng bu+ n0+ LIm1t3D +o P0\$+ 4nD PM NO+IPhIC4tI0N5, U\$3r 3M41l\$ 4nd P4sSwORD R3M1NDEr\$.";
$lang['forum_settings_help_57'] = "it iS R3C0MMenDEd tH4T J00 US3 4N 3M@il @Ddr3sS TH4T doE\$ NOt EXIST To H3LP CuT d0WN on SP4m TH4T M4Y 83 DIR3CTED 4+ y0uR m41N FORuM EM@1l @Ddr3sS";
$lang['forum_settings_help_58'] = "in 4Ddi+1ON +0 S1mPl3 sP1d3RINg, 83EH1VE c@N 4L\$O GEnER4t3 4 \$1+3MAP phOR Th3 foRUM +O MAke It E4s1eR PhoR S34RCH 3nG1NES TO PHIND @nd 1NDEx TH3 m3sS4gES poSTED 8Y YOUR US3Rs.";
$lang['forum_settings_help_59'] = "si+3M@PS @R3 4UTom4T1c4LLy S@ved +0 THe SIT3M@p5 \$UB-dIrECtoRY 0ph Y0UR 83EH1V3 F0RUM iNST@LL4TI0N. IF +H1S D1RECtORy DO3SN'+ EX1\$t j00 MU\$t CRe4t3 i+ @ND EnsURE THA+ I+ IS wr1+@8LE by T3H SeRVEr / PHP pR0C3S\$. +0 @lLOW \$34RCH ENG1N3\$ +O PhiND yoUr \$1TEm4p J00 Mu\$+ AdD +h3 URL tO Y0UR R08O+S.+xT.";
$lang['forum_settings_help_60'] = "d3P3nDINg 0N S3RVeR PErpHOrM4NC3 4ND tHE NUM83R 0F ph0RUMS aND +Hr34dS yoUR be3h1V3 1N5+@Ll4+10N COnt41NS, geNER4TINg 4 \$1+3MAP m4y +Ake S3vER4L mINU+3S to C0MPl3tE. 1F p3rPH0Rm@NC3 OF Y0uR \$3RV3R 1s 4DV3RS3LY 4FPHec+3D i+ IS reC0MM3nd J00 DISA8L3 93NERA+1ON 0f +3H S1+EM@P.";
$lang['forum_settings_help_61'] = "<b>s3nd Em4iL N0TIPh1C4+1oN +0 GlobAL ADm1n</b> WH3N eN4BLeD W1Ll \$3ND 4N Em@Il +0 tH3 GloBAL Ph0rUm OWN3RS WH3N 4 n3W u\$ER @CCOun+ i5 CR34T3D.";

// Attachments (attachments.php, get_attachment.php) ---------------------------------------

$lang['aidnotspecified'] = "a1d N0t SPeCIFiED.";
$lang['upload'] = "uplO@D";
$lang['uploadnewattachment'] = "upl0@d NEw @T+AchMen+";
$lang['waitdotdot'] = "w4i+..";
$lang['successfullyuploaded'] = "sUCCeSSPhullY uPL04D3D: %s";
$lang['failedtoupload'] = "f4iL3D +0 UplO4D: %s. CHeCK pHR3E 4tT@cHM3N+ \$P4CE!";
$lang['complete'] = "c0MPLe+3";
$lang['uploadattachment'] = "uPlO4D 4 F1L3 F0R 4++@cHM3N+ T0 +h3 MESS4G3";
$lang['enterfilenamestoupload'] = "en+3R pHILEn4m3(S) +0 UPlOAd";
$lang['attachmentsforthismessage'] = "a+t@cHM3N+S f0R +hIS m3sSAG3";
$lang['otherattachmentsincludingpm'] = "oTHEr 4+T4CHM3N+S (INclUDINg Pm M3sS493\$ 4nD 0+h3r PH0RUms)";
$lang['totalsize'] = "t0+@L S1Z3";
$lang['freespace'] = "fRee Sp4c3";
$lang['attachmentproblem'] = "tH3R3 W4S 4 Pr0BL3M DOwNLO4D1N9 ThiS A+T@chmeN+. PL3@Se TrY @9@IN La+3R.";
$lang['attachmentshavebeendisabled'] = "aT+AChMEn+S H4V3 beEn D1\$ABleD 8Y th3 PHOruM oWN3R.";
$lang['canonlyuploadmaximum'] = "j00 C4N 0NLy UPL04D @ MAX1muM 0F 10 PhIL3S 4T 4 t1M3";
$lang['deleteattachments'] = "d3le+3 4TT@cHMEn+S";
$lang['deleteattachmentsconfirm'] = "aR3 J00 SUR3 J00 WAN+ +O d3lET3 +H3 \$3L3cT3d 4tT4CHmenT\$?";
$lang['deletethumbnailsconfirm'] = "arE J00 SURE j00 WaNT +O D3l3+3 +3H s3lECteD 4+T@chM3N+S +HUm8N41L\$?";

// Changing passwords (change_pw.php) ----------------------------------

$lang['passwdchanged'] = "p4\$SwoRD CH4N9eD";
$lang['passedchangedexp'] = "yoUr pASSW0RD h@S 8E3N Chang3D.";
$lang['updatefailed'] = "upD@Te f41l3D";
$lang['passwdsdonotmatch'] = "p@SSwoRDS D0 NO+ M4TcH.";
$lang['newandoldpasswdarethesame'] = "n3w 4nD 0LD P@SSwoRDS aR3 +H3 \$@m3.";
$lang['requiredinformationnotfound'] = "reqUIREd InPH0Rm4t10N not PhOUNd";
$lang['forgotpasswd'] = "fOr90+ p@SSWOrD";
$lang['resetpassword'] = "reSET P4sSWoRD";
$lang['resetpasswordto'] = "r35e+ p@SSWORD TO";
$lang['invaliduseraccount'] = "inv4L1D us3R 4cCOun+ \$PECifIED. cH3CK 3m@1L Ph0r c0RREc+ l1nK";
$lang['invaliduserkeyprovided'] = "iNv4L1D US3R KEy PRoVId3D. ch3CK 3M41L FOr C0RR3CT linK";

// Deleting messages (delete.php) --------------------------------------

$lang['nomessagespecifiedfordel'] = "n0 mESS4G3 \$pEciFieD f0r dEL3T1ON";
$lang['deletemessage'] = "d3leTE MESS@93";
$lang['successfullydeletedpost'] = "sucCESSPhULLy DEL3+3D PO\$+ %s";
$lang['errordelpost'] = "erR0r D3LE+1NG p0St";
$lang['cannotdeletepostsinthisfolder'] = "j00 C4NNO+ d3lE+E p0\$+s IN THi\$ F0LD3R";

// Editing things (edit.php, edit_poll.php) -----------------------------------------

$lang['nomessagespecifiedforedit'] = "n0 M3\$SAge SpECiF1ED pHOR ed1+1N9";
$lang['cannoteditpollsinlightmode'] = "c@NNO+ ED1+ PolL5 1N LiGH+ m0de";
$lang['editedbyuser'] = "ed1+3D: %s BY %s";
$lang['successfullyeditedpost'] = "sUcCE\$sphULLY eDi+3d P0\$t %s";
$lang['errorupdatingpost'] = "erroR uPD4T1NG P0\$+";
$lang['editmessage'] = "eD1+ Me5s4GE %s";
$lang['editpollwarning'] = "<b>nOT3</b>: 3d1T1NG cERt41n 4sP3C+5 0PH 4 POLL WIlL vOID 4ll +h3 CurreNT VO+3S ANd @Ll0W Pe0pLE +0 VO+e @GAiN.";
$lang['hardedit'] = "h@RD Ed1T Op+1ONS (VOTe\$ wILL BE R3\$3T):";
$lang['softedit'] = "sOF+ eD1+ Op+1ON\$ (VOTe5 WIlL B3 rE+41NED):";
$lang['changewhenpollcloses'] = "cH4NgE WheN t3H poLL cL0S3\$?";
$lang['nochange'] = "n0 CHAn93";
$lang['emailresult'] = "eM41l rE\$ULT";
$lang['msgsent'] = "m3sS@ge S3NT";
$lang['msgsentsuccessfully'] = "mEss@93 \$3N+ \$UCC3SSFuLLy.";
$lang['mailsystemfailure'] = "m41l SY\$+3M pH4IlURE. M3SS493 NO+ 5enT.";
$lang['nopermissiontoedit'] = "j00 4Re N0T p3RMI++eD TO 3DI+ THIs M3S\$4GE.";
$lang['cannoteditpostsinthisfolder'] = "j00 C@NN0T 3D1T p0sTS 1n THIs PH0LdeR";
$lang['messagewasnotfound'] = "mE5s@93 %s W4S not F0UND";

// Email (email.php) ---------------------------------------------------

$lang['sendemailtouser'] = "s3nD 3M41L +0 %s";
$lang['nouserspecifiedforemail'] = "n0 uSEr spec1FIED f0R EM41LInG.";
$lang['entersubjectformessage'] = "eNtEr a SUBJeC+ fOr +3H m3\$s4g3";
$lang['entercontentformessage'] = "eN+3R S0M3 c0n+3NT f0r +H3 M3sS@GE";
$lang['msgsentfromby'] = "tHIs mesSAgE W4S SEnT FR0m %s 8Y %s";
$lang['subject'] = "sUbJEC+";
$lang['send'] = "sEND";
$lang['userhasoptedoutofemail'] = "%s h@S Opt3D 0UT of 3MA1l CON+aCT";
$lang['userhasinvalidemailaddress'] = "%s H4S 4n INV4Lid EM41l adDR3\$s";

// Message nofificaiton ------------------------------------------------

$lang['msgnotification_subject'] = "mE\$S4G3 no+1F1c4ti0N FRoM %s";
$lang['msgnotificationemail'] = "hELl0 %s,\n\n%s P0sTED A MES5@9e +O j00 oN %s.\n\n+HE \$U8j3cT 1S: %s.\n\n+O R3AD Th@T M3SsAG3 4ND OTheRS 1N TH3 sAMe D1\$CU\$SI0N, 9o +O:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nNOT3: If J00 DO NOt WI\$h +0 r3cE1VE Em41l n0+IFIc@+iONS of FORUm M3SS49eS PO\$teD T0 YOu, 90 T0: %s CL1CK ON My C0N+R0LS +hEN eM@1L @nd Priv4CY, uNSEleC+ +3H Em@1l NO+1F1C4+10N ChECK80x @ND pr3\$5 SUBmi+.";

// Thread Subscription notification ------------------------------------

$lang['threadsubnotification_subject'] = "sU85cr1PTI0n no+1fIC4+I0n PhrOM %s";
$lang['threadsubnotification'] = "h3lL0 %s,\n\n%s P0s+ED @ m3ssAg3 IN 4 +HRE4D J00 @r3 \$UBSCri83D To ON %s.\n\nthe \$ubjeCT 1\$: %s.\n\n+o RE4d +H4T M3ss@93 4ND OtH3RS In TEH \$am3 DI\$cU\$S1oN, 90 TO:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nNo+3: If J00 D0 nOT w1sH +0 ReCE1VE EM@1L n0T1PHIc@TI0Ns 0ph N3W m3\$SA93\$ 1N tHI\$ tHR34D, 90 to: %s @ND 4DJUSt Y0UR iN+3RES+ Lev3L @t TEH b0T+0M of +HE p493.";

// Folder Subscription notification ------------------------------------

$lang['foldersubnotification_subject'] = "sUbSCrIPT10N no+1F1C@tioN fROM %s";
$lang['foldersubnotification'] = "hELLO %s,\n\n%s PO\$T3d A mESS@9e In 4 FoLDer j00 @R3 5U8sCRIBED +0 0N %s.\n\nTh3 \$UBJEct i\$: %s.\n\ntO r34d +H@T me5s493 4nD 0THER\$ IN +H3 \$Am3 Di\$CU\$S10N, 90 +o:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nN0+3: 1PH J00 DO n0+ wI\$H t0 Rec3IV3 Em@1L n0tIF1C4T10NS OF nEW M3Ss493\$ 1n thiS +HReAD, 9o +O: %s @nd 4DJUST Y0UR int3REST leV3L 8Y clICKIng 0N TeH F0LDer'S 1CON @T +H3 TOP oPH p@GE.";

// PM notification -----------------------------------------------------

$lang['pmnotification_subject'] = "pM NO+1F1C@+ION PHroM %s";
$lang['pmnotification'] = "hElLo %s,\n\n%s POS+3D 4 PM +0 J00 ON %s.\n\n+h3 \$uBJeCT I\$: %s.\n\nt0 re@D +H3 MESSAge Go To:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nnoTe: IPh J00 D0 N0+ w1\$H +0 R3CE1Ve eMA1L n0+1f1c@+10N\$ 0Ph NEw PM M3ss@ge5 P0sTED +0 Y0U, Go T0: %s CL1CK My C0N+R0LS +H3N 3M@1l 4ND pr1V@Cy, uNs3LEC+ TH3 PM nO+1PHic4+10N CheCK8OX @nD prE\$s SU8M1T.";

// Password change notification ----------------------------------------

$lang['passwdchangenotification'] = "p@ssWOrd CHaNG3 N0TIfICA+1oN Fr0M %s";
$lang['pwchangeemail'] = "heLL0 %s,\n\ntHI\$ 4 NO+1FIC4TION 3M@Il +O 1NF0RM J00 +h@T Y0UR p4\$sw0rD 0N %s H@S b33N Ch4n9ED.\n\n1t H4S B33n CH4N93D T0: %s AnD W4s ChANGed BY: %s.\n\n1PH j00 HAVe REce1v3D THI\$ EM@1l 1N eRR0r 0R W3R3 NOt 3xP3C+1NG 4 Ch4NGE +O YOUr P4\$SwoRD PLE4SE C0N+@c+ T3H PhoRUM 0WNER oR a M0Der4tOR 0n %s IMMed1A+3Ly +0 CorREC+ 1+.";

// Email confirmation notification -------------------------------------

$lang['emailconfirmationrequiredsubject'] = "em@1l C0NFiRMA+1ON R3QUirED PHoR %s";
$lang['confirmemail'] = "hEllO %s,\n\nyOU rECEn+LY CR3At3d A NEW u53r aCC0UN+ 0n %s.\n\nB3fORE j00 C4N stAr+ posTInG wE NeeD +O C0NF1Rm Y0UR eM41L @DdR35S. D0N'T WoRRy THis 15 QU1+3 e45y. AlL j00 N33D +o D0 I\$ cl1cK +he L1NK b3LOW (0R c0pY and P4sT3 1T 1n+0 Y0Ur BR0W\$3R):\n\n%s\n\n0NC3 CONFIRma+10N 1S c0mpLET3 J00 M4Y L0GIN 4ND \$t@R+ p0\$+1N9 IMm3di4+3lY.\n\n1F J00 D1d N0T CREA+E 4 Us3R 4ccOUN+ 0n %s plEA\$3 ACc3p+ 0UR ApoloGIES 4nd FORw4rD THi\$ 3MA1L +0 %s s0 TH4+ +3H \$0urCE 0F 1+ M4Y BE INV3\$tiG4t3d.";
$lang['confirmchangedemail'] = "helLO %s,\n\nyOU reCEn+LY CHAn9ED yOUR eM41L ON %s.\n\n83PHOre J00 Can S+@R+ p0S+INg 4941N we nEED +0 C0nF1RM y0UR N3W 3Ma1l 4DDRE\$s. DOn'+ w0rRY tH1\$ 1\$ QU1+3 E@Sy. @ll J00 neED T0 D0 i\$ cL1CK ThE L1Nk 83lOW (OR c0py 4ND p@ST3 It 1NT0 y0uR 8R0w5eR):\n\n%s\n\nONCE COnPHIRM@ti0N 1s coMPl3+E j00 M@Y con+Inue +0 U5E +h3 F0RUm 45 NOrm4L.\n\nIF j00 Were noT 3XP3CTIn9 TH1S 3M@1L FrOM %s PL3A53 4CC3P+ 0UR 4P0L0G13s 4nd Ph0RW@Rd +His 3MAiL to %s SO tH@T T3H SOUrCE Of I+ m4Y 8E iNV3sT1G4TED.";

// Forgotten password notification -------------------------------------

$lang['forgotpwemail'] = "h3lL0 %s,\n\nyou REqu3STED +hiS 3-M41L FR0m %s BEcaUS3 J00 H@v3 PhoRG0TTen y0uR p4ssWORd.\n\nCl1ck the L1NK 83lOW (oR C0Py @ND p@STe 1+ 1N+0 Y0Ur BR0WS3R) TO R3S3+ YOUr P4sSWORd:\n\n%s";

// Admin New User Approval notification -----------------------------------------

$lang['newuserapprovalsubject'] = "nEw U53R 4PpR0V4L NoTIFICa+1oN pH0R %s";
$lang['newuserapprovalemail'] = "Hello %s,\n\nA new user account has been created on %s.\n\nAs you are an Administrator of this forum you are required to approve this user account before it can be used by it's owner.\n\nTo approve this account please visit the Admin Users section and change the filter type to \"Users Awaiting Approval\"or CLiCK +H3 liNK 83l0W:\n\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nnO+3: 0+H3R @DMIn1s+RAt0RS 0N tHI5 PHOruM w1LL @lS0 R3C3iv3 TH1S N0TIpH1C@Ti0N @Nd M@y H@v3 4LRE4DY 4C+3D UP0n +Hi\$ rEQU3\$+.";

// Admin New User notification -----------------------------------------

$lang['newuserregistrationsubject'] = "n3W User 4CCOun+ N0+1f1c@Ti0N pHOR %s";
$lang['newuserregistrationemail'] = "h3ll0 %s,\n\n4 NEw U\$3R @CcouNT h@S b33n cr34TED On %s.\n\nto VIEW +H1s U5eR @Cc0unT PLE4s3 vIS1T THE 4dm1N u\$3rs SeC+1oN 4nD CLicK oN +EH N3W U\$3R 0R CL1Ck +H3 LINK b3l0w:\n\n%s";

// User Approved notification ------------------------------------------

$lang['useraccountapprovedsubject'] = "u\$ER aPPROVaL N0TIF1C4t10N ph0r %s";
$lang['useraccountapprovedemail'] = "h3lL0 %s,\n\ny0uR us3r @CC0UNt A+ %s H4\$ B33n 4PPr0vEd. J00 C4N L0G1N 4ND 5+@R+ Pos+1N9 IMmED1@+3LY BY click1NG +H3 l1nK 83LOW:\n\n%s\n\n1PH j00 WerE N0t EXPec+1N9 THi5 3MaIL PhrOM %s PL34S3 4cCEp+ 0uR 4P0LO91ES AnD F0RW@rD +h1\$ 3MAIL tO %s \$O +H4t +He \$0uRC3 Of 1+ M@y 8E INveS+IG4+3D.";

// Admin Post Approval notification -----------------------------------------

$lang['newpostapprovalsubject'] = "pos+ 4PPR0V4L N0+If1c4+10N F0R %s";
$lang['newpostapprovalemail'] = "heLLO %s,\n\n4 N3W Po5+ Has B3EN CR3@T3D 0n %s.\n\n4s J00 @R3 4 M0D3R@+0R 0N +H1\$ PHORum J00 Are R3QUIr3d TO 4ppR0VE +HIS P0\$+ 8eF0R3 I+ c@N be RE4D 8Y OtheR US3r\$.\n\nyOu Can APprOV3 THis PO\$+ 4ND anY oTh3r\$ PEnd1N9 4PPr0V4L bY Vi\$I+1N9 +H3 4DM1N p05+ 4pProVal S3CtioN oPH Y0UR pH0RUM OR BY CL1CK1N9 +h3 L1NK B3LOW:\n\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nNO+e: O+H3R 4dMINIS+r4T0rS 0N Thi\$ PHorum W1Ll AL\$o R3C31V3 TH1s N0T1fICA+10N @nd MAy H4VE 4lR34dY @c+3d UPON +H1\$ R3QUEST.";

// Forgotten password form.

$lang['passwdresetrequest'] = "yOur P@5sWORD R3SET reQUE\$T Phr0M %s";
$lang['passwdresetemailsent'] = "p4s\$W0RD r3\$3+ e-M@iL SenT";
$lang['passwdresetexp'] = "j00 \$hoULD sH0R+lY r3ce1vE 4n e-M41L coNTaIn1NG 1nstRUcT10n\$ PHOr Re\$3+TInG y0uR P4\$sWOrD.";
$lang['validusernamerequired'] = "a VALid U\$ErnAme 1S R3qUIr3d";
$lang['forgottenpasswd'] = "forG0+ p@SSWOrd";
$lang['couldnotsendpasswordreminder'] = "c0uLD n0+ S3Nd Pa\$5WORd r3m1NDeR. pL34s3 CON+4CT t3h foRUM 0wner.";
$lang['request'] = "rEqu3st";

// Email confirmation (confirm_email.php) ------------------------------

$lang['emailconfirmation'] = "em41L ConfIRm4+1on";
$lang['emailconfirmationcomplete'] = "th4nK j00 ph0r COnpH1RM1nG y0uR 3M41L 4DDResS. J00 MaY NOw LO9In 4ND sT4R+ P0\$tiNG 1MmeDi4t3LY.";
$lang['emailconfirmationfailed'] = "em41L C0NF1RM4+ION H4S PH@IL3D, PLEasE +rY agAiN L@+ER. 1pH J00 ENCOuN+3r Thi5 erRor MUL+1Ple +1ME\$ Ple453 CONt4c+ tH3 PH0ruM OwnER OR A m0DER4+0R PH0R 4sS1\$+@Nc3.";

// Links database (links*.php) -----------------------------------------

$lang['toplevel'] = "top L3VEL";
$lang['maynotaccessthissection'] = "j00 m4y Not @cc3SS +H1\$ \$3CTi0n.";
$lang['toplevel'] = "toP L3V3L";
$lang['links'] = "l1nKS";
$lang['externallink'] = "eX+3Rn4l L1NK";
$lang['viewmode'] = "v13W mode";
$lang['hierarchical'] = "hI3R4RcHIc4L";
$lang['list'] = "l1ST";
$lang['folderhidden'] = "th1s FOLD3r IS H1DD3N";
$lang['hide'] = "hiDE";
$lang['unhide'] = "unh1DE";
$lang['nosubfolders'] = "nO sU8PHOLDER\$ IN THI5 C4t3g0RY";
$lang['1subfolder'] = "1 5uBPHOld3R 1N THiS C@TEG0RY";
$lang['subfoldersinthiscategory'] = "subF0LD3rS 1N th1s C4+3G0RY";
$lang['linksdelexp'] = "eN+R13\$ 1n @ D3lE+3D F0LdER W1ll 83 M0VEd TO TeH P@rEn+ PHolD3R. oNly FOLdeRS WHiCH d0 N0T c0NT41N \$UBpHOLderS M4Y 8e D3LE+3D.";
$lang['listview'] = "l15+ V13W";
$lang['listviewcannotaddfolders'] = "c@NN0T 4DD PH0LD3rs IN tHI\$ VIeW. shOWiNG 20 3N+R13s 4T @ +ImE.";
$lang['rating'] = "r@+in9";
$lang['nolinksinfolder'] = "n0 lInks 1N tH1s F0LDer.";
$lang['addlinkhere'] = "add L1NK H3R3";
$lang['notvalidURI'] = "th4+ 1\$ n0+ 4 V4liD uR1!";
$lang['mustspecifyname'] = "j00 mU\$+ SPEc1pHY @ N@ME!";
$lang['mustspecifyvalidfolder'] = "j00 MUST SP3c1pHY @ v4LId F0LD3R!";
$lang['mustspecifyfolder'] = "j00 mUS+ SpecIFY 4 folDER!";
$lang['successfullyaddedlinkname'] = "succ3SSPHULLY 4dd3D LINk '%s'";
$lang['failedtoaddlink'] = "f4Il3D +0 @dD lINk";
$lang['failedtoaddfolder'] = "f@1lED TO @DD f0lD3R";
$lang['addlink'] = "aDd A L1Nk";
$lang['addinglinkin'] = "addING L1NK iN";
$lang['addressurluri'] = "aDdrE\$S";
$lang['addnewfolder'] = "add 4 nEW F0ld3R";
$lang['addnewfolderunder'] = "aDd1n9 NEw F0LD3R UNdeR";
$lang['editfolder'] = "eDi+ pHOLd3R";
$lang['editingfolder'] = "ed1+1NG F0LD3R";
$lang['mustchooserating'] = "j00 MUST CHOOs3 4 r@+INg!";
$lang['commentadded'] = "yOUR ComMen+ W@\$ 4dDED.";
$lang['commentdeleted'] = "cOMMEN+ WAS d3L3+Ed.";
$lang['commentcouldnotbedeleted'] = "commEN+ c0uLd N0+ BE dELE+3D.";
$lang['musttypecomment'] = "j00 Mu\$t +Ype 4 COMm3nT!";
$lang['mustprovidelinkID'] = "j00 MU\$T pROV1D3 4 LInK ID!";
$lang['invalidlinkID'] = "iNV4LId l1NK 1D!";
$lang['address'] = "aDdr3\$s";
$lang['submittedby'] = "su8M1tTED By";
$lang['clicks'] = "clICk\$";
$lang['rating'] = "r4+in9";
$lang['vote'] = "v0+e";
$lang['votes'] = "vot3\$";
$lang['notratedyet'] = "n0t R4TEd BY @NY0NE Y3+";
$lang['rate'] = "r4+3";
$lang['bad'] = "b@d";
$lang['good'] = "go0D";
$lang['voteexcmark'] = "vO+3!";
$lang['clearvote'] = "cl3@R VOt3";
$lang['commentby'] = "commEN+ BY %s";
$lang['addacommentabout'] = "add @ C0MMen+ A8oUT";
$lang['modtools'] = "m0D3R4+10N t00lS";
$lang['editname'] = "eDI+ n4m3";
$lang['editaddress'] = "ed1+ 4DDr3ss";
$lang['editdescription'] = "ediT d3SCR1p+I0N";
$lang['moveto'] = "m0V3 T0";
$lang['linkdetails'] = "link De+@1L\$";
$lang['addcomment'] = "add C0Mm3N+";
$lang['voterecorded'] = "your V0TE h4s Be3n RECorD3D";
$lang['votecleared'] = "y0UR V0+3 Ha\$ B33N Cle4R3D";
$lang['linknametoolong'] = "lInK n4m3 T0O l0nG. M@xIMum IS %s Ch4r4C+3R\$";
$lang['linkurltoolong'] = "liNK url +oO l0nG. M@XimUM is %s ch4R4c+3RS";
$lang['linkfoldernametoolong'] = "fOLD3r N4M3 T00 L0N9. mAX1MUM l3N9TH 1\$ %s CHAR4C+3rs";

// Login / logout (llogon.php, logon.php, logout.php) -----------------------------------------

$lang['loggedinsuccessfully'] = "j00 LOg93d 1n \$uCc3\$sPHUlLY.";
$lang['presscontinuetoresend'] = "pr3ss coN+1NUE +0 R3s3nD FORm D4T4 OR CanCEL to R3L0@D Pag3.";
$lang['usernameorpasswdnotvalid'] = "tHE USERN4M3 0R P4SsWORD j00 SuPPlIEd I\$ NO+ v4LiD.";
$lang['rememberpasswds'] = "r3mEMBeR Pa\$swoRds";
$lang['rememberpassword'] = "r3meMB3R p4ssWoRD";
$lang['enterasa'] = "ent3R 4s a %s";
$lang['donthaveanaccount'] = "d0n'+ h@V3 @n ACCOuN+? %s";
$lang['registernow'] = "r3G1sT3r n0w";
$lang['problemsloggingon'] = "pR08LEMS l0g91NG oN?";
$lang['deletecookies'] = "d3l3+3 C00KIE5";
$lang['cookiessuccessfullydeleted'] = "c0okIE\$ SUCcESSPHuLLY DELe+3d";
$lang['forgottenpasswd'] = "fOr90tTen yoUR p@\$Sw0rD?";
$lang['usingaPDA'] = "us1nG 4 Pd4?";
$lang['lightHTMLversion'] = "lIGHT HTMl VERS10N";
$lang['youhaveloggedout'] = "j00 H@vE LOg93D 0Ut.";
$lang['currentlyloggedinas'] = "j00 4R3 CuRR3NTlY Lo993D IN 4s %s";
$lang['logonbutton'] = "lo90N";
$lang['otherdotdotdot'] = "oth3r...";
$lang['yoursessionhasexpired'] = "youR S3sS10n h4s exP1Red. J00 WilL nEED +o L091N 4941N T0 C0N+1NUE.";

// My Forums (forums.php) ---------------------------------------------------------

$lang['myforums'] = "my f0RUM\$";
$lang['allavailableforums'] = "alL 4V41L@8L3 F0RUMS";
$lang['favouriteforums'] = "f4voURi+3 F0RUms";
$lang['ignoredforums'] = "ign0R3D F0RUms";
$lang['ignoreforum'] = "iGn0R3 F0RUM";
$lang['unignoreforum'] = "uNI9N0r3 F0Rum";
$lang['lastvisited'] = "lAsT V151TED";
$lang['forumunreadmessages'] = "%s uNR3@D m3ss@GES";
$lang['forummessages'] = "%s m3ssAgES";
$lang['forumunreadtome'] = "%s UNre4D &quot;t0: m3&quot;";
$lang['forumnounreadmessages'] = "nO UnREaD Me\$s@gES";
$lang['removefromfavourites'] = "r3moV3 PHR0m Ph@VOuR1+3S";
$lang['addtofavourites'] = "add +O Ph@VOUr1TE\$";
$lang['availableforums'] = "av@1LAblE f0RUm\$";
$lang['noforumsofselectedtype'] = "tHERE 4rE no pHORums OF THE \$3LEc+ED +YPE 4v@1L48LE. PL3@\$3 \$3LECt 4 D1fFERenT +YPE.";
$lang['successfullyaddedforumtofavourites'] = "sUCC3sSPHuLLY 4dD3D f0rUM TO faVOUr1+Es.";
$lang['successfullyremovedforumfromfavourites'] = "succE\$sPhUllY rEM0vEd F0rUm PhroM PhAv0ur1+es.";
$lang['successfullyignoredforum'] = "sUCCES5fULly igN0RED FORum.";
$lang['successfullyunignoredforum'] = "succ3\$sPHULly UN19N0r3d ph0Rum.";
$lang['failedtoupdateforuminterestlevel'] = "fA1Led t0 UPD4+3 f0rUm 1N+3ReSt leVEL";
$lang['noforumsavailablelogin'] = "there 4RE N0 phORumS 4V@iL4BL3. PL34S3 LOG1N To ViEW y0ur Ph0rUM\$.";
$lang['passwdprotectedforum'] = "p4ssWORd PRo+3CT3D f0RUm";
$lang['passwdprotectedwarning'] = "this F0RUm IS p4sSW0RD pro+EC+eD. TO 941N 4CC3SS 3Nter +H3 P@SSWOrd 83LOW.";

// Message composition (post.php, lpost.php) --------------------------------------

$lang['postmessage'] = "poST MESS493";
$lang['selectfolder'] = "s3L3C+ F0LD3r";
$lang['mustenterpostcontent'] = "j00 mU5+ En+ER s0ME cONTeN+ FoR ThE P0\$T!";
$lang['messagepreview'] = "mE\$S@93 PREv1Ew";
$lang['invalidusername'] = "invaLId uS3RN4M3!";
$lang['mustenterthreadtitle'] = "j00 mUST 3n+3R 4 t1tL3 PhoR +EH +HR34d!";
$lang['pleaseselectfolder'] = "ple45E \$3LEc+ 4 fOLDEr!";
$lang['errorcreatingpost'] = "eRroR cR3A+1NG POST! PLEASe +rY aGAIN iN 4 FEW M1NU+es.";
$lang['createnewthread'] = "cr3@TE nEW Thr3AD";
$lang['postreply'] = "po\$+ R3PLy";
$lang['threadtitle'] = "thrE4D ti+LE";
$lang['foldertitle'] = "folD3R Ti+Le";
$lang['messagehasbeendeleted'] = "me\$s4gE N0T F0UNd. ch3CK thAt I+ HAsn'+ 83en D3LETed.";
$lang['messagenotfoundinselectedfolder'] = "me\$s@Ge N0T pHOUND 1n SELEc+Ed F0LD3R. cH3CK ThA+ i+ h4sN'+ 8eeN MOveD 0r DEl3TEd.";
$lang['cannotpostthisthreadtypeinfolder'] = "j00 C@Nno+ POSt +H1\$ +HReAD +yPE IN tH4T ph0LD3R!";
$lang['cannotpostthisthreadtype'] = "j00 C@nNOT p0\$t +hi\$ +HREad TypE 4s +H3RE 4Re N0 @v41l@BL3 PHOLDER\$ THAT 4lL0W It.";
$lang['cannotcreatenewthreads'] = "j00 C@NNO+ CREa+3 N3W +hREAds.";
$lang['threadisclosedforposting'] = "thiS +Hr3aD I\$ Cl0\$3D, J00 C@Nn0+ po\$T 1n 1+!";
$lang['moderatorthreadclosed'] = "w@RN1N9: ThI5 THR3@D 1S CLoseD f0R PosTIng +0 NORmAL U5eRS.";
$lang['usersinthread'] = "uS3r\$ 1N tHR3@D";
$lang['correctedcode'] = "cORRec+3D C0D3";
$lang['submittedcode'] = "subMI++3D CodE";
$lang['htmlinmessage'] = "h+ml In M3\$S@GE";
$lang['disableemoticonsinmessage'] = "dIs@8LE eM0TIcoN\$ 1n me5S493";
$lang['automaticallyparseurls'] = "au+0mA+1c@LlY p@RS3 Url\$";
$lang['automaticallycheckspelling'] = "aU+0M4+1C4LLY CH3CK \$peLL1N9";
$lang['setthreadtohighinterest'] = "set +hRe@D TO hIgh 1NT3R35+";
$lang['enabledwithautolinebreaks'] = "en48L3D wITH 4uT0-LInE-8R3AKs";
$lang['fixhtmlexplanation'] = "this F0rUM U\$35 H+mL FIlT3R1NG. YOUR \$UBM1T+Ed H+ML h4\$ B33N m0dIFI3d 8y Teh pHIlT3RS In SOM3 W4Y.\\n\\nT0 v1EW Your ORiGINal coDe, S3LEC+ TEH \\'SUBm1++3D C0DE\\' R4DIO 8uTTOn.\\nTO V1eW +hE moD1Fied C0DE, S3LEC+ +h3 \\'c0RrEC+Ed C0dE\\' R4D10 8U+toN.";
$lang['messageoptions'] = "mes\$@GE oPTi0NS";
$lang['notallowedembedattachmentpost'] = "j00 4R3 N0+ ALL0WED +O 3MB3D AT+aCHMEn+s 1N YouR po\$Ts.";
$lang['notallowedembedattachmentsignature'] = "j00 @RE N0T @LL0WEd TO eM8eD @T+AChMEN+S iN Y0UR SiGNa+UR3.";
$lang['reducemessagelength'] = "m3SSAG3 l3nG+H musT B3 unDER 65,535 CH4r@CTEr\$ (CurR3NTLY: %s)";
$lang['reducesiglength'] = "s1gNA+UR3 L3N9+H MUST b3 UNDeR 65,535 Ch4r4C+3RS (CUrrENtLY: %s)";
$lang['cannotcreatethreadinfolder'] = "j00 C4NNO+ CRE4TE n3W +hREADS IN +H1\$ F0LD3R";
$lang['cannotcreatepostinfolder'] = "j00 C@nno+ r3PLY +0 P0s+S 1N tHI\$ PHOLDeR";
$lang['cannotattachfilesinfolder'] = "j00 C4NNO+ PO\$+ A+t@ChMEn+S In +His F0Ld3R. r3MOVE 4++4CHM3N+S +0 c0n+1NUE.";
$lang['postfrequencytoogreat'] = "j00 CAn 0nLY PO\$+ oNC3 Ev3rY %s S3C0ND\$. pLE4SE +rY 49AIN l4+3R.";
$lang['emailconfirmationrequiredbeforepost'] = "em4iL C0NF1RM4TIon i5 REqu1RED 8ePH0RE j00 C4N pO5+. IPH J00 H@vE n0t RECe1vED 4 ConPhiRM@tI0N eMA1L Pl34s3 Cl1cK +H3 8UT+0n 83LOW 4ND A NEW 0Ne W1LL bE SEn+ +O y0u. IPH YouR 3m41L AdDR3sS neEDS CH@nGINg PLe@5e D0 S0 83PHOR3 R3QU3S+iNG @ N3W cONFIrm4+10N 3M@iL. J00 M4Y CH@N93 Y0uR 3mAiL 4DDR3sS BY CLiCK My C0N+ROLS @8OV3 4Nd +HEn us3R De+4ILS";
$lang['emailconfirmationfailedtosend'] = "c0npHIrM4T10N 3M@1l F41LEd tO \$3ND. PL3@5E CoN+@c+ +h3 f0RUM 0WNEr To r3C+1FY tHis.";
$lang['emailconfirmationsent'] = "conF1rM4TI0N 3m@1L h@\$ bE3N r3s3n+.";
$lang['resendconfirmation'] = "rEs3nD coNPHiRM@ti0N";
$lang['userapprovalrequiredbeforeaccess'] = "youR U\$3R @cc0UNT nEEDS T0 8E APPR0VED By @ FOruM @DmiN 8EPHORe J00 C4N @cc3\$S +H3 R3qUES+3D F0RuM.";
$lang['reviewthread'] = "rEV1eW +hr34D";
$lang['reviewthreadinnewwindow'] = "rEv1ew ENtIr3 +Hr34D 1N nEW W1ND0W";

// Message display (messages.php & messages.inc.php) --------------------------------------

$lang['inreplyto'] = "in REPLy +O";
$lang['showmessages'] = "sH0W M3\$SAGE\$";
$lang['ratemyinterest'] = "r4t3 MY 1n+3RE\$+";
$lang['adjtextsize'] = "aDJUST t3x+ \$iz3";
$lang['smaller'] = "sm4lLEr";
$lang['larger'] = "l4rg3R";
$lang['faq'] = "f4Q";
$lang['docs'] = "dOc5";
$lang['support'] = "supPORT";
$lang['donateexcmark'] = "don4+E!";
$lang['fontsizechanged'] = "fonT SIZ3 ch4ngED. %s";
$lang['framesmustbereloaded'] = "fR4M3\$ MUsT b3 REL0@D3D m4nU@lly T0 S3E Ch@N9e\$.";
$lang['threadcouldnotbefound'] = "t3h r3QUeS+eD +HR3AD coUld nO+ b3 f0uND oR @cCEsS W@5 DEn1ed.";
$lang['mustselectpolloption'] = "j00 MU\$t s3Lec+ 4N 0P+I0n To vO+E PHor!";
$lang['mustvoteforallgroups'] = "j00 MUsT v0te 1n EVerY gROuP.";
$lang['keepreading'] = "k3eP r34D1NG";
$lang['backtothreadlist'] = "b@Ck +o THR34d Li5+";
$lang['postdoesnotexist'] = "tH4T p05+ D0ES NO+ 3X1s+ IN +HIs +Hr34D!";
$lang['clicktochangevote'] = "clicK T0 CH@NGE V0tE";
$lang['youvotedforoption'] = "j00 V0+ED For 0P+10N";
$lang['youvotedforoptions'] = "j00 V0+3D FOR OPTi0NS";
$lang['clicktovote'] = "cL1cK +0 V0T3";
$lang['youhavenotvoted'] = "j00 H@VE Not VOT3D";
$lang['viewresults'] = "vi3W RESULT\$";
$lang['msgtruncated'] = "mesS49e +RUNC@TED";
$lang['viewfullmsg'] = "vIeW FULL mE\$5493";
$lang['ignoredmsg'] = "i9NoRED m3\$sAGE";
$lang['wormeduser'] = "w0rm3d U53r";
$lang['ignoredsig'] = "ign0r3D S1gN@+URe";
$lang['messagewasdeleted'] = "me\$s@GE %s.%s was D3lE+3d";
$lang['stopignoringthisuser'] = "s+OP 19N0r1n9 TH1s Us3R";
$lang['renamethread'] = "r3nAM3 THr3@D";
$lang['movethread'] = "m0vE THR3@D";
$lang['torenamethisthreadyoumusteditthepoll'] = "t0 RenAmE +h1s THre4D J00 Mus+ Ed1+ T3H poLl.";
$lang['closeforposting'] = "cLo5e PhoR PO5t1N9";
$lang['until'] = "untIl 00:00 UTC";
$lang['approvalrequired'] = "apPR0V4L R3QU1R3D";
$lang['messageawaitingapprovalbymoderator'] = "me\$s@GE %s.%s 1\$ @w4i+1NG 4PPR0V4l 8Y 4 MODER@toR";
$lang['successfullyapprovedpost'] = "sucC3\$5PHUlLY 4pPR0V3D P0\$t %s";
$lang['postapprovalfailed'] = "pOST AppR0V4L PHaiL3D.";
$lang['postdoesnotrequireapproval'] = "poS+ d0e\$ NO+ R3QUIRe @PPR0V4L";
$lang['approvepost'] = "aPpROVE po\$t";
$lang['approvedbyuser'] = "aPPR0VED: %s 8Y %s";
$lang['makesticky'] = "m4K3 \$tiCKy";
$lang['messagecountdisplay'] = "%s 0pH %s";
$lang['linktothread'] = "perM@NEN+ lINK To +hI\$ +HReAD";
$lang['linktopost'] = "l1nK TO P0\$+";
$lang['linktothispost'] = "link TO thI\$ PO\$T";
$lang['imageresized'] = "tHis 1M4GE hAs b3eN Res1zEd (0R19INAL siZ3 %1\$5X%2\$s). to ViEW The fULL-s1z3 1MAGE cl1CK hERE.";
$lang['messagedeletedbyuser'] = "meSs493 %s.%s D3lE+3D %s BY %s";
$lang['messagedeleted'] = "me\$S493 %s.%s wAS D3l3TED";
$lang['viewinframeset'] = "vIeW IN fR4M3s3+";
$lang['pressctrlentertoquicklysubmityourpost'] = "prE5s C+Rl+EN+3R TO Qu1cKLy SUBm1+ YOUr PO\$T";

// Moderators list (mods_list.php) -------------------------------------

$lang['cantdisplaymods'] = "c4NN0+ D1\$pL@Y phOLDER MOdeR4T0R5";
$lang['moderatorlist'] = "mOd3r@toR LIST:";
$lang['modsforfolder'] = "mOd3r4T0rS phOR PHOLdeR";
$lang['nomodsfound'] = "n0 m0DER@+0R5 PH0UND";
$lang['forumleaders'] = "f0rUM L34D3R\$:";
$lang['foldermods'] = "f0ld3R MODeR4T0R\$:";

// Navigation strip (nav.php) ------------------------------------------

$lang['start'] = "starT";
$lang['messages'] = "mESS493s";
$lang['pminbox'] = "iN8ox";
$lang['startwiththreadlist'] = "s+4RT P493 WITH +hRe@D L1s+";
$lang['pmsentitems'] = "sen+ 1+EM5";
$lang['pmoutbox'] = "oUTBOX";
$lang['pmsaveditems'] = "s@VED 1teMS";
$lang['pmdrafts'] = "dR4F+S";
$lang['links'] = "lInK\$";
$lang['admin'] = "aDMIN";
$lang['login'] = "lOgIN";
$lang['logout'] = "l090uT";

// PM System (pm.php, pm_write.php, pm.inc.php) ------------------------

$lang['privatemessages'] = "pRiVA+3 MESS49ES";
$lang['recipienttiptext'] = "sep4rAT3 R3C1p13n+s By \$3M1-C0LoN OR C0mm4";
$lang['maximumtenrecipientspermessage'] = "tH3rE I\$ A l1mIT 0Ph 10 R3cIpiEN+S PER ME5s@93. ple4s3 @MEnd Y0UR r3ciPIen+ LI\$T.";
$lang['mustspecifyrecipient'] = "j00 MU\$+ sp3CIfY 4t LE4sT ON3 R3cIP13N+.";
$lang['usernotfound'] = "uSer %s NO+ PhoUND";
$lang['sendnewpm'] = "s3ND n3w PM";
$lang['savemessage'] = "s@v3 M3\$S4GE";
$lang['nosubject'] = "no \$U8jEC+";
$lang['norecipients'] = "n0 REcIpiENTS";
$lang['timesent'] = "tim3 S3n+";
$lang['notsent'] = "no+ s3nT";
$lang['errorcreatingpm'] = "err0r cr3A+1NG Pm! PLeaSe +RY AGa1n 1N 4 Ph3w M1NUTes";
$lang['writepm'] = "wRi+E M3\$S493";
$lang['editpm'] = "eD1+ m3ss@93";
$lang['cannoteditpm'] = "c@nN0T 3D1+ +H1\$ pm. 1T H4\$ @Lr3@DY b3EN vIeWED BY TH3 R3cIPiEN+ 0r +H3 ME\$s@93 D0ES NO+ ex1\$t 0r I+ Is IN4CCEssi8LE bY J00";
$lang['cannotviewpm'] = "c4nn0T vIeW PM. M3SS4GE d0eS No+ ex1\$T 0r I+ 1S 1N4CC3SS18L3 8Y j00";
$lang['pmmessagenumber'] = "m3\$S@93 %s";

$lang['youhavexnewpm'] = "j00 h4VE %d NEW mEsSAGE\$. WOULD J00 LIke TO go +O YOUr INBOX N0W?";
$lang['youhave1newpm'] = "j00 H4VE 1 N3W M3\$S@93. WOULd J00 L1KE +0 GO +0 Y0uR iNB0x N0W?";
$lang['youhave1newpmand1waiting'] = "j00 h@VE 1 neW MESS493.\n\ny0U @lSO H4v3 1 M3SS@93 4W@i+Ing DEliv3RY. t0 RECE1Ve +H1\$ m3\$saGE pLEA\$3 CL34r S0mE \$p4cE In YOUR inBOx.\n\nw0ulD J00 L1kE T0 90 to YOUR in80X NOw?";
$lang['youhave1pmwaiting'] = "j00 H4VE 1 m3sS@93 4w@I+1NG D3lIV3rY. TO R3cE1Ve +HIs M3sSA93 pLE@\$E CLe4r S0M3 sp4cE iN Y0Ur INBOx.\n\nW0ulD J00 l1KE +O 90 tO YOuR 1n8oX NOW?";
$lang['youhavexnewpmand1waiting'] = "j00 H4VE %d N3W mEsS49es.\n\nYOU Al50 H4V3 1 M3SSagE 4W@ItING D3L1V3RY. t0 R3C31V3 ThI\$ M3S\$4GE PLeA\$3 Cl34R \$0ME sPace iN y0UR 1n80X.\n\nw0uLd j00 L1K3 +0 90 TO YOUr 1NB0x N0W?";
$lang['youhavexnewpmandxwaiting'] = "j00 h4V3 %d neW M3\$5493\$.\n\nY0u 4LSO H@ve %d MESS493s 4WA1TIng DElIV3RY. TO r3CEIV3 TheS3 MESSAG3 PL3A\$3 CLeaR sOME \$p4c3 IN yoUR InBox.\n\nW0ULD J00 liK3 T0 go TO y0ur INbox N0W?";
$lang['youhave1newpmandxwaiting'] = "j00 h4v3 1 N3W M3\$s@9E.\n\nYOU ALS0 H4V3 %d M3\$SA9es 4W@i+1n9 DELivERY. to R3CEIv3 +H3S3 M3\$5493S Pl34SE CLE@r \$OMe \$p4C3 1N Y0uR Inb0x.\n\nw0uLD J00 L1k3 +O 90 TO y0uR 1nb0x N0W?";
$lang['youhavexpmwaiting'] = "j00 h@vE %d mESS4gES 4W41tIN9 DELIVery. TO r3ceIV3 tHES3 mESS493\$ PL3453 CLEAR s0m3 sP4c3 iN YouR IN80x.\n\nWOULD J00 L1KE +0 90 +0 Y0ur IN80x N0w?";

$lang['youdonothaveenoughfreespace'] = "j00 DO n0+ HaVE En0u9H PhREE \$P4C3 T0 S3ND +HiS Me\$S@GE.";
$lang['userhasoptedoutofpm'] = "%s H@5 OP+eD 0UT OpH ReCEiv1n9 PeR\$0N4L me\$S@gE5";
$lang['pmfolderpruningisenabled'] = "pM fOLD3R PRun1nG I\$ 3N48lED!";
$lang['pmpruneexplanation'] = "tHis PHORUM u\$3\$ PM F0lDER PRUN1NG. t3h M3ss493s J00 H@VE ST0r3d IN YOUR inb0X 4nd 5eNT ITEM\$\\nF0ldER\$ ARE \$UBJ3ct TO @U+OMA+1c D3LE+I0N. 4nY M3SsAG3s J00 W1\$h +0 KEEP shoUlD 83 M0v3d T0\\nyOUR \\'S4V3d I+3Ms\\' PHOLdeR S0 TH4T +H3y 4Re N0+ DELETed.";
$lang['yourpmfoldersare'] = "y0UR pM pH0LD3R5 4R3 %s PHULl";
$lang['currentmessage'] = "cURREn+ mE\$549E";
$lang['unreadmessage'] = "uNRE4D mE5S493";
$lang['readmessage'] = "rE4D m3sS493";
$lang['pmshavebeendisabled'] = "p3rsON4L Me5s4gE\$ H@v3 BE3N dis48LED bY T3H pHorUm 0WNer.";
$lang['adduserstofriendslist'] = "add US3RS +o Y0UR PHRIenDS LIST +0 H4V3 +h3m 4Pp34R IN 4 DROP DOwn On THe PM wRI+3 m3ss49E P49E.";

$lang['messagewassuccessfullysavedtodraftsfolder'] = "mE\$S@93 WA\$ SucCES5PhuLLY \$@v3d +0 'dr@Ph+s' f0LDeR";
$lang['couldnotsavemessage'] = "couLD n0+ SavE M3\$sAgE. M@kE sUr3 J00 H4V3 EnoU9H 4V4IL4BLE FR33 SP@ce.";
$lang['pmtooltipxmessages'] = "%s Mess@9ES";
$lang['pmtooltip1message'] = "1 me\$saG3";

$lang['allowusertosendpm'] = "aLL0W US3R t0 s3ND pER\$0N4L m3ss4GES +0 me";
$lang['blockuserfromsendingpm'] = "bLOck U\$3r PhroM s3NDIN9 p3RS0N4L mESS49ES to Me";
$lang['yourfoldernamefolderisempty'] = "y0ur %s FOlD3R i5 EMP+Y";
$lang['successfullydeletedselectedmessages'] = "sucC3S5FuLLy D3LE+3D s3L3C+3D MesS49ES";
$lang['successfullyarchivedselectedmessages'] = "sUCC3sSFULLy @rChIVED s3L3CT3D M3\$saGES";
$lang['failedtodeleteselectedmessages'] = "f41l3D +O dELe+E sEL3C+ed Me\$S@Ges";
$lang['failedtoarchiveselectedmessages'] = "f4iLeD +0 @RcH1VE \$3LEC+eD Me\$549ES";

// Preferences / Profile (user_*.php) ---------------------------------------------

$lang['mycontrols'] = "mY C0N+R0LS";
$lang['myforums'] = "my Ph0Rum\$";
$lang['menu'] = "menU";
$lang['userexp_1'] = "use +H3 MeNU 0N THe lEPH+ TO M4N@ge y0uR \$et+1N9s.";
$lang['userexp_2'] = "<b>u53R DE+@ILS</b> 4lLOWs j00 T0 cHaNGe YOUr N4M3, 3mAIl 4DDReSS @ND p4\$sW0Rd.";
$lang['userexp_3'] = "<b>u\$3R proFILE</b> 4LLOW\$ J00 +O 3d1T Y0Ur U\$ER PrOFILE.";
$lang['userexp_4'] = "<b>ch4NgE P4sSW0RD</b> 4lLOWS j00 TO ch4NGe YOUR P@SSwoRD";
$lang['userexp_5'] = "<b>em41L &amp; pr1VAcy</b> L3+s j00 CH4n93 HOW j00 C4N 83 CONT4C+ed On @Nd OFF T3H ph0RUm.";
$lang['userexp_6'] = "<b>fOrUM OPTioNS</b> l3T\$ J00 CH4NGE h0W +3H f0rUM loOK\$ @ND w0rKS.";
$lang['userexp_7'] = "<b>aTt4cHmeN+s</b> 4LLow\$ J00 TO ED1+/dEL3+3 yoUR 4TT4CHMeNTS.";
$lang['userexp_8'] = "<b>s1Gn@+uR3</b> l3+S J00 3D1T y0uR \$19n4TURe.";
$lang['userexp_9'] = "<b>rEL@tI0NSHiPS</b> LE+s J00 M@N49E Y0UR R3L4+IOnSH1P wI+H 0+H3R US3RS On ThE F0RUm.";
$lang['userexp_9'] = "<b>wOrD phILt3r</b> L3TS j00 EDIT Y0uR p3rS0N4L woRD pH1LTER.";
$lang['userexp_10'] = "<b>tHrEAd \$UB\$CR1P+1ON\$</b> @Ll0wS J00 +0 M4N@93 YOUr +Hr3ad \$U8\$crIPTi0n\$.";
$lang['userdetails'] = "u\$eR dE+4ILS";
$lang['userprofile'] = "u\$3r pr0fILe";
$lang['emailandprivacy'] = "eM@iL &amp; prIV4CY";
$lang['editsignature'] = "eD1T s19n4Ture";
$lang['norelationshipssetup'] = "j00 H4VE n0 USEr REl4T10NShIP\$ set UP. 4dD @ NEw Us3R bY S3ARcHIng 8EL0W.";
$lang['editwordfilter'] = "eDI+ w0rd FIl+3R";
$lang['userinformation'] = "u\$3R InPHOrm@+10N";
$lang['changepassword'] = "ch4N93 p@5\$woRD";
$lang['currentpasswd'] = "cUrR3N+ PA\$sWoRD";
$lang['newpasswd'] = "nEw p@\$SWORd";
$lang['confirmpasswd'] = "coNPH1RM p4SsWORD";
$lang['passwdsdonotmatch'] = "p4ssWORd\$ DO NOT M@TCH!";
$lang['nicknamerequired'] = "nicKN4m3 IS R3QuIRED!";
$lang['emailaddressrequired'] = "eMAIL AddRe5S 1\$ r3qUIreD!";
$lang['logonnotpermitted'] = "l090n no+ p3rm1T+3D. ch0OsE 4NOTHeR!";
$lang['nicknamenotpermitted'] = "nIcKN@m3 N0+ pErm1++3D. cHO0s3 4N0+H3R!";
$lang['emailaddressnotpermitted'] = "em4IL 4dDr3\$s No+ p3RMI++3D. CHo0se 4N0THEr!";
$lang['emailaddressalreadyinuse'] = "eM4IL @dDR3SS 4LR34dy 1n U\$E. chO0\$e 4No+H3R!";
$lang['relationshipsupdated'] = "reL4+1oNSH1P\$ Upd4TeD!";
$lang['relationshipupdatefailed'] = "rEl4TI0N5hip UPD4t3d faIL3D!";
$lang['preferencesupdated'] = "pR3f3r3nC3\$ w3Re 5UCceSsPHully uPd4TED.";
$lang['userdetails'] = "uSer DE+@1L\$";
$lang['memberno'] = "m3m8er NO.";
$lang['firstname'] = "f1r\$+ N4ME";
$lang['lastname'] = "lA5+ namE";
$lang['dateofbirth'] = "d4tE 0F b1RTh";
$lang['homepageURL'] = "hOmEP49E uRl";
$lang['profilepicturedimensions'] = "pROPHiLE P1CTUr3 (M4X 95x95pX)";
$lang['avatarpicturedimensions'] = "aV4+4R P1CtuR3 (M@x 15X15Px)";
$lang['invalidattachmentid'] = "iNv@LID 4T+@cHM3NT. ChECK +H4t I5 HasN't 8e3N d3LEtED.";
$lang['unsupportedimagetype'] = "unsUPpORt3D im4Ge @++4chMen+. J00 c4N oNLY us3 JP9, GIF And Pn9 1m@GE 4+T4CHMEN+s F0R yoUR 4V4+4r 4nD PRof1l3 pICTUre.";
$lang['selectattachment'] = "sEl3c+ 4t+4CHMent";
$lang['pictureURL'] = "pIC+ure UrL";
$lang['avatarURL'] = "av4+@r UrL";
$lang['profilepictureconflict'] = "t0 U5E aN 4+T@CHMeN+ FOR yoUR pr0fIL3 pICTUr3 +H3 P1ctUR3 Url FIelD mU\$+ b3 Bl4nK.";
$lang['avatarpictureconflict'] = "to u\$3 4N 4t+4CHM3Nt PHoR YoUR 4V@T4R p1cTUR3 +3H 4V@t4R UrL phIElD MusT 83 8L4NK.";
$lang['attachmenttoolargeforprofilepicture'] = "sel3C+3D 4Tt4CHM3N+ IS +00 LAr93 PHOr ProF1L3 PIc+URe. M4x1MUM DImeNS10nS Ar3 %s";
$lang['attachmenttoolargeforavatarpicture'] = "s3l3c+3D 4T+4CHm3NT 1\$ +oo lAR93 foR @V4T4R P1C+uR3. m4xIMUM DIM3N\$10N\$ 4R3 %s";
$lang['failedtoupdateuserdetails'] = "s0ME 0R 4LL OF YouR US3r @cC0UN+ Det4IL\$ c0uLd N0T 83 UpdA+eD. PL3ASE TRY aGaIN LA+3r.";
$lang['failedtoupdateuserpreferences'] = "s0m3 0r 4Ll Of Y0ur US3R PREPH3RENCEs C0uLD NO+ b3 UPDA+3d. PleASE +RY @G4IN l@tER.";
$lang['emailaddresschanged'] = "eM4iL 4ddr3ss H4\$ B3En CH@N93d";
$lang['newconfirmationemailsuccess'] = "y0UR 3M41L 4DDrEsS h4s 83EN CH4N93D AnD @ nEW coNF1RMA+10N EM41l H4\$ be3N SEnT. pLEa\$3 CH3CK 4ND R3AD +H3 EM41L pH0r FUrTHer 1N\$TruCtiON\$.";
$lang['newconfirmationemailfailure'] = "j00 h@V3 CH4n9ED yoUR 3MAiL ADDR3ss, 8uT w3 WErE UN@blE +O S3ND 4 C0NPh1rM4T10N R3qUES+. PL34s3 CON+@C+ +H3 f0RUM 0wnER PHOR 4\$S1\$+4NCE.";
$lang['forumoptions'] = "f0rUM OpT10N\$";
$lang['notifybyemail'] = "n0TIPhy By 3M4IL 0f Po\$+S +o m3";
$lang['notifyofnewpm'] = "n0tIPHY by p0PUP OF n3W pM me\$5A9ES TO me";
$lang['notifyofnewpmemail'] = "n0TIFY 8y EMAIl 0F New pm mes\$@GES +O m3";
$lang['daylightsaving'] = "aDjUST pHOr D4YLigH+ s4V1N9";
$lang['autohighinterest'] = "autoMA+1C@lLY m@Rk +Hr34D\$ I p0\$t 1n @S hiGH iN+Ere\$t";
$lang['convertimagestolinks'] = "aUT0M@T1c@Lly C0Nver+ Em8EDd3d 1M49eS In Po\$+S 1N+0 l1NKS";
$lang['thumbnailsforimageattachments'] = "thuM8n41LS PHor 1M493 4TT@cHm3N+s";
$lang['smallsized'] = "sm@lL 5IzeD";
$lang['mediumsized'] = "m3dIUM SIZ3D";
$lang['largesized'] = "l4rG3 S1Z3D";
$lang['globallyignoresigs'] = "glo8ALLy 19N0RE us3R s1gN@tURES";
$lang['allowpersonalmessages'] = "aLl0W OThER u\$3r\$ +0 SENd ME p3RSON4L M3sSAG3s";
$lang['allowemails'] = "aLL0W 0+H3R usER\$ TO S3ND M3 EM41L\$ vI4 My PROFilE";
$lang['timezonefromGMT'] = "tIM3 Z0NE";
$lang['postsperpage'] = "pOSts PEr P49E";
$lang['fontsize'] = "f0nT S1Z3";
$lang['forumstyle'] = "foruM \$tYlE";
$lang['forumemoticons'] = "f0rUM EM0+1COn\$";
$lang['startpage'] = "sT4r+ P493";
$lang['signaturecontainshtmlcode'] = "si9N@+Ur3 C0NT@1Ns H+ML coDE";
$lang['savesignatureforuseonallforums'] = "s4vE 5I9N4+URe FOR u\$3 ON 4ll foRUms";
$lang['preferredlang'] = "pR3f3rRed L4N9U49e";
$lang['donotshowmyageordobtoothers'] = "dO NO+ SHOw MY 49e 0R d4t3 0F 8IR+H +0 O+h3RS";
$lang['showonlymyagetoothers'] = "sh0W ONlY my agE +0 0+H3R\$";
$lang['showmyageanddobtoothers'] = "sh0w 8OTH MY @93 4nD d@T3 OPH 81RTH tO OtHEr\$";
$lang['showonlymydayandmonthofbirthytoothers'] = "sHoW 0nLY MY d@Y 4ND m0n+h 0F B1r+H TO O+h3RS";
$lang['listmeontheactiveusersdisplay'] = "lI5T M3 0n +H3 AC+1Ve us3RS d1\$PL@Y";
$lang['browseanonymously'] = "bR0WS3 PH0RUM 4NONYmOUSlY";
$lang['allowfriendstoseemeasonline'] = "bR0W5E @N0NYMOuslY, BUT @LloW FR13NDS TO S33 M3 @\$ 0NL1Ne";
$lang['revealspoileronmouseover'] = "r3v34L sP0ILerS 0N mOU5E OV3r";
$lang['showspoilersinlightmode'] = "alwAY\$ SH0W sp01L3RS iN L19H+ M0D3 (u\$Es l1GHT3R Ph0N+ COLOUR)";
$lang['resizeimagesandreflowpage'] = "rE\$1ZE IM49ES 4ND REfL0W p49e +0 PreV3N+ H0R1Z0Nt4l SCrOLl1n9.";
$lang['showforumstats'] = "sh0W PHORum S+@T\$ 4+ boT+0m oF M3\$sAG3 P4n3";
$lang['usewordfilter'] = "en@BLE WORD PHilTEr.";
$lang['forceadminwordfilter'] = "fOrCE us3 OF aDMin w0RD f1LT3R on 4LL u5ERS (Inc. GueSTS)";
$lang['timezone'] = "tIM3 Z0NE";
$lang['language'] = "l@nGU@93";
$lang['emailsettings'] = "eM4iL @ND C0N+AcT S3T+1N9s";
$lang['forumanonymity'] = "fOrUM ANOnyM1+Y \$3+TIn9s";
$lang['birthdayanddateofbirth'] = "b1r+HD4y 4ND D4t3 0f BiRTH d1spL4Y";
$lang['includeadminfilter'] = "inclUDE @dm1N W0rd PhIL+3R 1N MY LI5+.";
$lang['setforallforums'] = "s3+ PHor @lL phoRums?";
$lang['containsinvalidchars'] = "%s C0N+A1NS iNV4LId CH4R4CteRS!";
$lang['homepageurlmustincludeschema'] = "h0Mep4GE uRL MUST 1nCLUd3 hT+P:// sCHeMA.";
$lang['pictureurlmustincludeschema'] = "p1ctUR3 URl MUS+ iNCluDE hTTp:// sCHEmA.";
$lang['avatarurlmustincludeschema'] = "av4T@R Url MUS+ 1nClUD3 H++P:// \$CHEm4.";
$lang['postpage'] = "p0sT P493";
$lang['nohtmltoolbar'] = "n0 H+ML t0oL8@R";
$lang['displaysimpletoolbar'] = "di5pl4Y S1mpL3 H+mL +oOLbAR";
$lang['displaytinymcetoolbar'] = "d1spl4Y WY\$IWy9 HTml +OOL8@R";
$lang['displayemoticonspanel'] = "d1SPl@Y em0TiC0NS p@NEl";
$lang['displaysignature'] = "d1SplAy S1GN@+uRe";
$lang['disableemoticonsinpostsbydefault'] = "dis@8l3 Em0+1CON\$ 1N MESS4gES 8Y d3PH@UL+";
$lang['automaticallyparseurlsbydefault'] = "aUT0M4TIC@LLy P4R\$3 URls In Me\$s493\$ BY deF4ulT";
$lang['postinplaintextbydefault'] = "pos+ In PL41N +3xt by D3PH4ULT";
$lang['postinhtmlwithautolinebreaksbydefault'] = "p0\$T 1N H+ML wI+H 4utO-L1nE-BR3@KS 8Y Def4uL+";
$lang['postinhtmlbydefault'] = "p0sT 1N h+Ml BY def4uLT";
$lang['postdefaultquick'] = "u5e QU1CK rEplY 8Y defAulT. (fULL rEplY 1N MEnU)";
$lang['privatemessageoptions'] = "pR1v4TE mEss493 OP+1ONS";
$lang['privatemessageexportoptions'] = "prIV4+3 Me\$s@9e EXp0rT 0pTiON\$";
$lang['savepminsentitems'] = "s@VE 4 coPy 0f E4CH pM I \$3ND iN MY s3nT 1+3m\$ PhoLd3r";
$lang['includepminreply'] = "inclUd3 meSS493 B0DY Wh3n REplYIng TO pm";
$lang['autoprunemypmfoldersevery'] = "aUtO prUNe mY Pm Ph0LD3R\$ Ev3rY:";
$lang['friendsonly'] = "fri3ND\$ 0NlY?";
$lang['globalstyles'] = "glo8aL s+YLes";
$lang['forumstyles'] = "f0ruM 5+Yl3s";
$lang['youmustenteryourcurrentpasswd'] = "j00 mu\$t 3NT3R yOUR cuRr3nT p@5sWOrd";
$lang['youmustenteranewpasswd'] = "j00 MUSt ENt3R 4 N3w P@ssW0Rd";
$lang['youmustconfirmyournewpasswd'] = "j00 Mu\$+ C0Nf1rM YouR NeW P@SswORd";
$lang['profileentriesmustnotincludehtml'] = "pR0PhiLE 3NTr13s Mu\$+ N0T 1NClUDE HTML";
$lang['failedtoupdateuserprofile'] = "f41LEd TO uPD4t3 US3R pROFIlE";

// Polls (create_poll.php, poll_results.php) ---------------------------------------------

$lang['mustprovideanswergroups'] = "j00 MU\$T PROvIDE sOMe 4NSW3R 9R0uPs";
$lang['mustprovidepolltype'] = "j00 MU\$t PROVId3 4 POLl +YpE";
$lang['mustprovidepollresultsdisplaytype'] = "j00 mUS+ pR0V1dE rESULtS D1\$pl@Y +YP3";
$lang['mustprovidepollvotetype'] = "j00 mUS+ PR0V1DE 4 POll V0+3 tYPe";
$lang['mustprovidepollguestvotetype'] = "j00 mUS+ SPECIPHY IPh GUESTS \$HOULD B3 4LL0wED +o vo+E";
$lang['mustprovidepolloptiontype'] = "j00 MU\$+ pR0VId3 4 POLl OPtioN tYP3";
$lang['mustprovidepollchangevotetype'] = "j00 MU5+ pr0VId3 @ p0lL ch@nG3 V0TE TYpe";
$lang['pollquestioncontainsinvalidhtml'] = "oN3 Or MOrE oF yoUr POlL qU3STIoN\$ coN+4IN\$ 1NV4LiD htMl.";
$lang['pleaseselectfolder'] = "pLe@\$e \$3lEC+ 4 PHOLd3r";
$lang['mustspecifyvalues1and2'] = "j00 MUSt SP3CIPhY v4lUES pH0R 4N\$w3R\$ 1 4ND 2";
$lang['tablepollmusthave2groups'] = "t48ul4R PH0rm4T PollS MUS+ HAv3 PReCI\$3Ly +w0 VO+1Ng GroUPS";
$lang['nomultivotetabulars'] = "t@8UL4R FORM@T P0LLS C4NNO+ b3 MULtI-votE";
$lang['nomultivotepublic'] = "pubL1c BaLLOT\$ C@Nn0+ bE mUL+1-VO+e";
$lang['abletochangevote'] = "j00 W1LL b3 4BL3 to Ch@NgE y0uR V0T3.";
$lang['abletovotemultiple'] = "j00 WILL B3 48L3 T0 V0+3 MUl+1pLE tIME\$.";
$lang['notabletochangevote'] = "j00 WilL NO+ be 48L3 +o ChANgE Your VOTe.";
$lang['pollvotesrandom'] = "n0tE: p0Ll V0+3S 4R3 RAnDOMlY 9eN3R4T3D f0R pR3V1EW 0nLy.";
$lang['pollquestion'] = "polL Ques+10N";
$lang['possibleanswers'] = "possIBl3 4n\$WeR\$";
$lang['enterpollquestionexp'] = "entER +3H 4N\$w3R\$ PH0R yOUR pOLl QUE5+1on.. If Y0uR poLL 1s 4 &quot;y3s/N0&quot; QU3\$TioN, s1MPlY 3Nt3r &quot;YeS&quot; Ph0r 4NSW3r 1 4ND &quot;N0&quot; pHoR 4n\$W3r 2.";
$lang['numberanswers'] = "n0. 4NSw3R5";
$lang['answerscontainHTML'] = "aN5wER\$ con+aIN H+ml (NOT 1nCLUd1n9 \$1Gn@Tur3)";
$lang['optionsdisplay'] = "ansWERS D1sPl@y +YPe";
$lang['optionsdisplayexp'] = "h0w shoULD tHE 4NSw3R\$ B3 PR3sENtED?";
$lang['dropdown'] = "a\$ droP-dOWN liST(\$)";
$lang['radios'] = "a5 4 SERIeS 0f R4DIo 8u+T0N\$";
$lang['votechanging'] = "vO+3 CHAn9ING";
$lang['votechangingexp'] = "c@N @ PERson Ch4n93 HIS 0R H3R vO+E?";
$lang['guestvoting'] = "gUEsT vo+1NG";
$lang['guestvotingexp'] = "c@N 9u3Sts VO+3 1N +h1\$ p0LL?";
$lang['allowmultiplevotes'] = "all0W mult1pL3 v0t3\$";
$lang['pollresults'] = "p0LL rESult\$";
$lang['pollresultsexp'] = "h0W wouLD j00 LIk3 TO DI\$Pl@Y +3H R3SULt\$ 0F YOuR POlL?";
$lang['pollvotetype'] = "p0ll vo+in9 TyPE";
$lang['pollvotesexp'] = "how SHOuLD tH3 P0LL BE c0nDUc+3D?";
$lang['pollvoteanon'] = "anoNYM0USLy";
$lang['pollvotepub'] = "pU8L1C 8@LlO+";
$lang['horizgraph'] = "hoR1ZONT@l GR4ph";
$lang['vertgraph'] = "v3rTIC4l GR@Ph";
$lang['tablegraph'] = "t4buL4R f0Rm@T";
$lang['polltypewarning'] = "<b>w4rN1NG</b>: +h1s 1s 4 pU8L1C 8@LLO+. YOUR N@me WIlL 8e VISi8l3 nEXT +O Th3 OPTI0N J00 VOte PHOR.";
$lang['expiration'] = "eXp1R@+1on";
$lang['showresultswhileopen'] = "d0 j00 W@nT TO sHOW R3\$ult\$ WHilE tHE p0LL i\$ OP3N?";
$lang['whenlikepollclose'] = "wh3n WOuLD J00 liKE y0uR p0LL TO @u+OM4T1C4LLy Cl0sE?";
$lang['oneday'] = "oNe D4Y";
$lang['threedays'] = "tHr3e D@ys";
$lang['sevendays'] = "seVEN d@yS";
$lang['thirtydays'] = "thiR+y D@yS";
$lang['never'] = "n3VER";
$lang['polladditionalmessage'] = "adDITI0N@L M3SsA9e (0p+10N4l)";
$lang['polladditionalmessageexp'] = "do j00 W4NT +0 INCLUD3 4n @DDi+1on@L pO\$t @FTER THE P0LL?";
$lang['mustspecifypolltoview'] = "j00 mU\$+ Spec1FY 4 POLl TO V1EW.";
$lang['pollconfirmclose'] = "ar3 J00 sURe J00 w4nT to Clo\$3 ThE FOLl0wIN9 p0ll?";
$lang['endpoll'] = "end POLl";
$lang['nobodyvotedclosedpoll'] = "n0BODY voTEd";
$lang['votedisplayopenpoll'] = "%s 4ND %s H4VE V0+ED.";
$lang['votedisplayclosedpoll'] = "%s 4nD %s v0TED.";
$lang['nousersvoted'] = "no US3RS";
$lang['oneuservoted'] = "1 uS3r";
$lang['xusersvoted'] = "%s u\$ER\$";
$lang['noguestsvoted'] = "n0 GUE\$tS";
$lang['oneguestvoted'] = "1 9uE\$t";
$lang['xguestsvoted'] = "%s gu3\$T5";
$lang['pollhasended'] = "p0lL H4S 3Nd3d";
$lang['youvotedforpolloptionsondate'] = "j00 V0TED f0R %s 0n %s";
$lang['thisisapoll'] = "th1S 1\$ 4 pOLl. cLIck +0 vIEW R3sUL+s.";
$lang['editpoll'] = "edi+ poLL";
$lang['results'] = "r3\$UL+s";
$lang['resultdetails'] = "rE5uLT de+A1LS";
$lang['changevote'] = "cH4NGe v0TE";
$lang['pollshavebeendisabled'] = "polLS HaVE 8EEN DI5@BleD BY +H3 pHORUM 0wNEr.";
$lang['answertext'] = "aNSW3R TexT";
$lang['answergroup'] = "answ3R 9roUP";
$lang['previewvotingform'] = "pR3V1EW vO+iN9 Ph0RM";
$lang['viewbypolloption'] = "vI3w 8Y P0Ll OPt10N";
$lang['viewbyuser'] = "v13w 8Y uSEr";

// Profiles (profile.php) ----------------------------------------------

$lang['editprofile'] = "ed1+ pR0F1L3";
$lang['profileupdated'] = "pr0FILe UPdAT3D.";
$lang['profilesnotsetup'] = "th3 FORuM OWnER h@5 N0+ SET up PROFil3S.";
$lang['ignoreduser'] = "i9nOREd US3R";
$lang['lastvisit'] = "l4\$+ VI\$1+";
$lang['userslocaltime'] = "u\$3r'5 L0C4L tIM3";
$lang['userstatus'] = "s+4TUS";
$lang['useractive'] = "oNL1NE";
$lang['userinactive'] = "in@CTiVE / 0pHFlINE";
$lang['totaltimeinforum'] = "tOt4L tiME";
$lang['longesttimeinforum'] = "lon9E\$T S3\$s10N";
$lang['sendemail'] = "send EM4IL";
$lang['sendpm'] = "s3Nd PM";
$lang['visithomepage'] = "vIsI+ h0M3P493";
$lang['age'] = "ag3";
$lang['aged'] = "ag3d";
$lang['birthday'] = "b1r+HDAy";
$lang['registered'] = "r3GIS+3RED";
$lang['findpostsmadebyuser'] = "f1nD POs+\$ m4d3 BY %s";
$lang['findpostsmadebyme'] = "fINd P0\$Ts M@dE 8y Me";
$lang['findthreadsstartedbyuser'] = "fIND +hR3Ad\$ sT@R+3D bY %s";
$lang['findthreadsstartedbyme'] = "f1nD Thr34dS S+ArT3D 8Y m3";
$lang['profilenotavailable'] = "pRoPHiLE no+ aV4IL@8lE.";
$lang['userprofileempty'] = "this U\$3R H4S N0T pHILLed 1N TH3IR Prof1LE 0r 1T I\$ \$3+ +0 PR1v@+3.";

// Registration (register.php) -----------------------------------------

$lang['newuserregistrationsarenotpermitted'] = "sorRY, N3W U5eR R39i\$+r4tI0NS @rE NOt @Ll0weD r1GHt N0W. pl3@s3 CHecK 8@CK l4t3R.";
$lang['usernameinvalidchars'] = "uS3rN@m3 C@n ONlY con+41N 4-Z, 0-9, _ - CH4R4C+3RS";
$lang['usernametooshort'] = "uSERN4m3 MUS+ B3 @ M1N1MUM 0F 2 CH4R4C+Ers LONg";
$lang['usernametoolong'] = "u53RN4M3 MUS+ 8E 4 M@xImuM OF 15 ChaR4CTeR\$ LOnG";
$lang['usernamerequired'] = "a loG0n N@M3 1s R3QU1RED";
$lang['passwdmustnotcontainHTML'] = "p@5swORD Mu\$+ NOT C0N+AIN H+Ml +ag\$";
$lang['passwordinvalidchars'] = "p4SsWORD C@n ONlY coN+@1n 4-Z, 0-9, _ - ChARAc+3R5";
$lang['passwdtooshort'] = "p@5sWOrD Mu\$t 83 @ mInIMuM Of 6 Ch4r4C+3RS l0NG";
$lang['passwdrequired'] = "a p4SSW0RD iS RequIr3d";
$lang['confirmationpasswdrequired'] = "a C0NF1Rm4+i0N P@ssW0RD iS R3QU1RED";
$lang['nicknamerequired'] = "a nICKN@M3 1\$ REQu1r3D";
$lang['emailrequired'] = "an EmaIL 4dDr3sS I\$ REQu1R3D";
$lang['passwdsdonotmatch'] = "p@5\$WorDS d0 NOt M4+Ch";
$lang['usernamesameaspasswd'] = "u53rNAm3 4ND P4SSWOrd MUSt 8E DifPH3REn+";
$lang['usernameexists'] = "sorrY, 4 U53R wITh +h4t N4ME 4lRE4DY Ex1\$TS";
$lang['successfullycreateduseraccount'] = "sUCc3sSFULly CR34T3D u\$3r @CcoUN+";
$lang['useraccountcreatedconfirmfailed'] = "yOur USER 4CcouNT H@\$ b3EN Cr3a+ED BU+ +H3 REQUIr3d C0NF1RM4T1oN 3MAiL w4\$ NO+ \$3Nt. PL3ase C0N+4C+ +3h f0RUM OwnER +o R3CTIpHY THi\$. In +h1s ME4NTIme PLEASE cLICk +He CONT1Nue BU++0n to L0GIn.";
$lang['useraccountcreatedconfirmsuccess'] = "y0ur US3R 4CCOUNT h4S be3N Cr3@TED 8UT 8ePH0r3 J00 C4N ST4RT poSTING j00 MU\$T C0NF1RM Y0uR EM41l @DDR3\$5. PLE@SE CHecK y0UR Em@1L Ph0r 4 LINk TH@T WilL ALL0w J00 +0 C0nFIRM YOUR aDDRE\$S.";
$lang['useraccountcreated'] = "yOUR U\$3r 4cC0UNt H@s B3eN Cre@+ED \$ucC3S5PHuLLY! cl1CK tHE coNTiNUE BUTt0N 8eL0W T0 l091N";
$lang['errorcreatinguserrecord'] = "eRR0R CRE4T1NG u\$ER r3cORD";
$lang['userregistration'] = "uS3R reg1\$+RA+10N";
$lang['registrationinformationrequired'] = "r3G1STR4+1ON InPHORM4t10N (reqU1RED)";
$lang['profileinformationoptional'] = "pr0FIL3 1NF0RMa+1ON (opTI0NAL)";
$lang['preferencesoptional'] = "pR3FEREncEs (OP+10N4L)";
$lang['register'] = "rEGI5+3R";
$lang['rememberpasswd'] = "r3m3m83R P4s\$w0Rd";
$lang['birthdayrequired'] = "d4+3 0f 81RTh 1s REQUiR3d 0R 1\$ INV@lID";
$lang['alwaysnotifymeofrepliestome'] = "n0tiPHy ON r3PLY +o ME";
$lang['notifyonnewprivatemessage'] = "n0TIFY oN N3W Pr1V4+3 ME\$s@GE";
$lang['popuponnewprivatemessage'] = "pop Up ON new PrIV@te M3sS@ge";
$lang['automatichighinterestonpost'] = "aUtOM4tiC hI9H 1NteR3ST on P0\$+";
$lang['confirmpassword'] = "cOnFIRM paSsW0RD";
$lang['invalidemailaddressformat'] = "iNV4L1D EM@1L @ddRESS F0rm4t";
$lang['moreoptionsavailable'] = "mOr3 proF1LE 4ND pREPh3r3NC3 0P+1ONS @R3 4V41l@8L3 ONCE j00 R391STER";
$lang['textcaptchaconfirmation'] = "c0nfIRM4TI0N";
$lang['textcaptchaexplain'] = "to +3H Ri9h+ IS A +exT-C4PTCh@ 1M493. PleASE +YP3 +HE CODe J00 C@N \$3e IN +3H 1m493 IN+0 tEH InpU+ F1eLD BEL0w IT.";
$lang['textcaptchaimgtip'] = "tH1s IS A CAPtcH4-P1CTUR3. 1+ 1s US3d +0 PreV3N+ 4U+OMA+1C reGISTR4TI0N";
$lang['textcaptchamissingkey'] = "a coNFirMA+1on COD3 1\$ ReqU1R3D.";
$lang['textcaptchaverificationfailed'] = "teXt-C4P+CH4 v3R1PHic@+iON C0D3 w@S 1NCoRR3CT. PL3ase RE-eN+3R iT.";
$lang['forumrules'] = "f0rUM ruLES";
$lang['forumrulesnotification'] = "in oRDEr T0 Pr0c3eD, j00 Mus+ agREE w1tH THE foLLOWiNG rulES";
$lang['forumrulescheckbox'] = "i h@V3 RE4D, AnD @9r33 T0 481DE 8y +He F0RUM rULe5.";
$lang['youmustagreetotheforumrules'] = "j00 MusT A9REE +0 teH FORUM rUl3s BEpHORe J00 C@N C0n+1NU3.";

// Recent visitors list  (visitor_log.php) -----------------------------

$lang['member'] = "m3MB3R";
$lang['searchforusernotinlist'] = "sE4RCH f0r 4 USER nO+ 1n Li\$T";
$lang['yoursearchdidnotreturnanymatches'] = "y0uR \$EARCh DID NoT r3tURN 4nY m4+cH3s. try SIMpl1PHY1NG Y0uR S3ARCH p4R@m3+3R\$ 4ND Try 4941N.";
$lang['hiderowswithemptyornullvalues'] = "h1dE Row\$ w1+H emPty 0R NULl VAluES 1n \$3lECTED cOLUMN\$";
$lang['showregisteredusersonly'] = "sH0w R391sTERED u\$ER\$ OnlY (h1de GUes+S)";

// Relationships (user_rel.php) ----------------------------------------

$lang['relationships'] = "r3l4TI0NSH1PS";
$lang['userrelationship'] = "us3r R3L4t1oNSH1P";
$lang['userrelationships'] = "uS3R REl4ti0NSHipS";
$lang['failedtoremoveselectedrelationships'] = "f41Led +0 r3m0VE SelecTED r3l4TIONsh1p";
$lang['friends'] = "fr1endS";
$lang['ignoredcompletely'] = "iGn0RED coMPLeteLY";
$lang['relationship'] = "r3l4tI0NSh1p";
$lang['restorenickname'] = "re\$toRE US3r'5 N1CKN4ME";
$lang['friend_exp'] = "us3R'S p05+S M@rKEd W1+H 4 &quot;FRIEND&quot; iCON.";
$lang['normal_exp'] = "uS3r'S P0sT\$ 4ppEAR 4\$ N0RM@l.";
$lang['ignore_exp'] = "u53r'\$ p0st\$ 4RE H1dDEN.";
$lang['ignore_completely_exp'] = "thr3aD\$ 4ND P0Sts TO Or fR0M US3R WILl @PPEAr D3L3+ED.";
$lang['display'] = "di\$PL@Y";
$lang['displaysig_exp'] = "u\$3R'S Si9n@tUr3 I\$ DISpl@y3D 0N thEiR Po\$TS.";
$lang['hidesig_exp'] = "useR'S S1GN4TURE iS H1DDEN on +h3IR P0\$+S.";
$lang['cannotignoremod'] = "j00 C4NN0T IGnoR3 TH1\$ US3R, 4s TH3y @RE 4 M0DER4TOR.";
$lang['previewsignature'] = "pR3V1EW \$1Gn4tUR3";

// Search (search.php) -------------------------------------------------

$lang['searchresults'] = "se4rCh RE\$Ul+S";
$lang['usernamenotfound'] = "tH3 U\$eRNAm3 J00 5PEc1PHieD In Th3 +0 Or Fr0m PHiELD W@S N0+ F0UND.";
$lang['notexttosearchfor'] = "one oR AlL 0F YOur SE4RCh K3YwoRDs w3r3 INv@L1D. s34RCh K3YwoRDs MUST 83 n0 SHOrT3r +H4N %d CH4RAc+3r5, n0 LOn93R +hAn %d cH@RAcTER\$ 4ND muST nO+ @PPEaR 1N +Eh %s";
$lang['keywordscontainingerrors'] = "keyWORds CONT41n1N9 ERr0r5: %s";
$lang['mysqlstopwordlist'] = "mYsQL S+oPWORD lIS+";
$lang['foundzeromatches'] = "f0UND: 0 M4TCH3s";
$lang['found'] = "f0unD";
$lang['matches'] = "m4+cH3s";
$lang['prevpage'] = "pR3VI0US P493";
$lang['findmore'] = "f1nd moR3";
$lang['searchmessages'] = "se@RCH MESSA9E\$";
$lang['searchdiscussions'] = "s34RcH D1\$CUss1oNS";
$lang['find'] = "finD";
$lang['additionalcriteria'] = "aDd1+1ONAl CrI+3Ri4";
$lang['searchbyuser'] = "sE4RCH BY u\$3R (0PtI0N4L)";
$lang['folderbrackets_s'] = "f0lDER(S)";
$lang['postedfrom'] = "p0ST3D PhROM";
$lang['postedto'] = "postED T0";
$lang['today'] = "t0DAy";
$lang['yesterday'] = "yESt3RD@y";
$lang['daybeforeyesterday'] = "d@y 8efOR3 Y35teRD@Y";
$lang['weekago'] = "%s WE3K @90";
$lang['weeksago'] = "%s WE3kS AG0";
$lang['monthago'] = "%s m0n+H agO";
$lang['monthsago'] = "%s moNTHS AGO";
$lang['yearago'] = "%s yE4R 49o";
$lang['beginningoftime'] = "bEgINn1N9 OPH +Im3";
$lang['now'] = "nOW";
$lang['lastpostdate'] = "l@\$T P0\$t D4t3";
$lang['numberofreplies'] = "num83r OF R3pliES";
$lang['foldername'] = "fOlDEr n@M3";
$lang['authorname'] = "au+HOR n4ME";
$lang['decendingorder'] = "n3wEST pHIrsT";
$lang['ascendingorder'] = "oLDeS+ F1rst";
$lang['keywords'] = "k3yW0RDS";
$lang['sortby'] = "sort By";
$lang['sortdir'] = "s0r+ d1r";
$lang['sortresults'] = "sOr+ resULtS";
$lang['groupbythread'] = "gROUP 8y +HREaD";
$lang['postsfromuser'] = "posTS PHroM us3r";
$lang['threadsstartedbyuser'] = "thR3ads \$t@Rt3d 8Y U\$3R";
$lang['searchfrequencyerror'] = "j00 c4N ONLy \$E4RCH onCE 3v3rY %s \$ec0NDS. PL3@S3 +ry agAiN lA+3R.";
$lang['searchsuccessfullycompleted'] = "s3@RCH SuCC3\$SpHULly c0MPL3+ED. %s";
$lang['clickheretoviewresults'] = "cliCK H3R3 +O V1EW ResUl+S.";

// Search Popup (search_popup.php) -------------------------------------

$lang['select'] = "s3l3c+";
$lang['searchforthread'] = "s34RCh PHOr +Hr34d";
$lang['mustspecifytypeofsearch'] = "j00 MU5T spECIfY tYPe OF \$eARCh +O pERF0RM";
$lang['unkownsearchtypespecified'] = "unkn0WN S34RCh +yp3 SP3cIF1ED";
$lang['mustentersomethingtosearchfor'] = "j00 mUSt 3nT3R SOMEth1N9 To \$34RCH PH0R";

// Start page (start_left.php) -----------------------------------------

$lang['recentthreads'] = "r3C3n+ +HR34d\$";
$lang['startreading'] = "sT@R+ rEAdIN9";
$lang['threadoptions'] = "thREAD 0p+10N\$";
$lang['editthreadoptions'] = "edi+ +HR3ad 0P+1ON\$";
$lang['morevisitors'] = "m0re vIS1+0RS";
$lang['forthcomingbirthdays'] = "fOR+hc0MINg 81RThD4YS";

// Start page (start_main.php) -----------------------------------------

$lang['editstartpage_help'] = "j00 c@N ed1+ THI5 p493 Phr0M +H3 4DM1N 1N+3RF4C3";

// Thread navigation (thread_list.php) ---------------------------------

$lang['newdiscussion'] = "nEw d1\$CUSSI0N";
$lang['createpoll'] = "cr3a+3 P0LL";
$lang['search'] = "se4RCh";
$lang['searchagain'] = "s34rCH 4G41n";
$lang['alldiscussions'] = "all DI\$CUSSION\$";
$lang['unreaddiscussions'] = "unREAD d15CUSS10N\$";
$lang['unreadtome'] = "unr3@D &quot;+o: ME&quot;";
$lang['todaysdiscussions'] = "t0d@Y'5 DisCU\$S10NS";
$lang['2daysback'] = "2 dAyS 8ACk";
$lang['7daysback'] = "7 dAYS B@Ck";
$lang['highinterest'] = "hI9H 1N+ErES+";
$lang['unreadhighinterest'] = "uNR3@D hi9h iN+3R3s+";
$lang['iverecentlyseen'] = "i'vE R3cEN+lY SE3N";
$lang['iveignored'] = "i'v3 19N0R3D";
$lang['byignoredusers'] = "bY 19NoR3D USeRs";
$lang['ivesubscribedto'] = "i'vE suBSCr183D +o";
$lang['startedbyfriend'] = "st4RTEd 8Y fRIEnd";
$lang['unreadstartedbyfriend'] = "unrE@D 5+D 8y fRIEnD";
$lang['startedbyme'] = "st@r+3d BY m3";
$lang['unreadtoday'] = "uNR3aD +oD4Y";
$lang['deletedthreads'] = "dElE+3D +hReaD\$";
$lang['goexcmark'] = "g0!";
$lang['folderinterest'] = "fold3R 1N+3rES+";
$lang['postnew'] = "p0st New";
$lang['currentthread'] = "cuRR3N+ THr3AD";
$lang['highinterest'] = "hi9H iN+3Res+";
$lang['markasread'] = "m4rk A\$ re4d";
$lang['next50discussions'] = "n3XT 50 dISCU5Si0n\$";
$lang['visiblediscussions'] = "v15iBLE d1sCU5S1oN\$";
$lang['selectedfolder'] = "s3LECTeD f0LDEr";
$lang['navigate'] = "n4v1GAte";
$lang['couldnotretrievefolderinformation'] = "theRE 4Re N0 PHolDERS @V41L48L3.";
$lang['nomessagesinthiscategory'] = "n0 M3\$S@ges 1N +h1s c4t3g0RY. pL34S3 \$3LECt AN0THEr, Or %s Ph0r 4LL +HR34DS";
$lang['clickhere'] = "cl1CK h3r3";
$lang['prev50threads'] = "pR3VI0US 50 +HRE4ds";
$lang['next50threads'] = "n3x+ 50 +hREAD\$";
$lang['nextxthreads'] = "n3X+ %s +Hr3ADS";
$lang['threadstartedbytooltip'] = "tHr3@D #%s ST@R+3D 8Y %s. v1eWED %s";
$lang['threadviewedonetime'] = "1 +1mE";
$lang['threadviewedtimes'] = "%d +IM3S";
$lang['unreadthread'] = "unrE4D ThRE4D";
$lang['readthread'] = "r34d +hR34D";
$lang['unreadmessages'] = "uNrE4D M3ss@9ES";
$lang['subscribed'] = "su85cR1B3D";
$lang['stickythreads'] = "s+1CKY +HR34DS";
$lang['mostunreadposts'] = "m0\$+ unrEaD PO\$ts";
$lang['onenew'] = "%d N3W";
$lang['manynew'] = "%d NEw";
$lang['onenewoflength'] = "%d n3W 0PH %d";
$lang['manynewoflength'] = "%d N3W 0F %d";
$lang['confirmmarkasread'] = "aR3 J00 5UR3 J00 WAn+ +0 M4rk tHE S3LEc+3D tHR3Ad\$ a\$ re4D?";
$lang['successfullymarkreadselectedthreads'] = "sucC3\$SfuLly M4RkeD SEleCT3D THrE4DS 4S ReAD";
$lang['failedtomarkselectedthreadsasread'] = "f@1L3D +o m4Rk S3l3CTEd +HR3@ds @s reaD";
$lang['gotofirstpostinthread'] = "gO T0 ph1RST Po\$+ 1N +HRE@D";
$lang['gotolastpostinthread'] = "g0 +o l4sT P05T 1n +Hr3AD";
$lang['viewmessagesinthisfolderonly'] = "v13w MESS@GES iN +H1s Ph0LDEr ONlY";
$lang['shownext50threads'] = "sH0w neX+ 50 Thr3@DS";
$lang['showprev50threads'] = "sH0w Pr3V10Us 50 +HreAD\$";
$lang['createnewdiscussioninthisfolder'] = "cr3A+e N3w DisCUS\$1oN in +HIs F0LD3R";
$lang['nomessages'] = "n0 M3SSAGes";

// HTML toolbar (htmltools.inc.php) ------------------------------------
$lang['bold'] = "bOLd";
$lang['italic'] = "iT@LiC";
$lang['underline'] = "uNdeRLInE";
$lang['strikethrough'] = "s+r1K3+Hr0U9H";
$lang['superscript'] = "supERSCriPt";
$lang['subscript'] = "sUbsCRiP+";
$lang['leftalign'] = "lepHT-4L1GN";
$lang['center'] = "c3N+3r";
$lang['rightalign'] = "r19h+-4l1gN";
$lang['numberedlist'] = "nUm83REd LI\$t";
$lang['list'] = "l1St";
$lang['indenttext'] = "indenT +3xT";
$lang['code'] = "coDE";
$lang['quote'] = "qUoT3";
$lang['unquote'] = "unQu0+3";
$lang['spoiler'] = "sp0ILER";
$lang['horizontalrule'] = "hOr1ZONt@L Rul3";
$lang['image'] = "imaGE";
$lang['hyperlink'] = "hYpERLInK";
$lang['noemoticons'] = "di548LE emOtICON5";
$lang['fontface'] = "fon+ F4CE";
$lang['size'] = "s1zE";
$lang['colour'] = "c0l0uR";
$lang['red'] = "rEd";
$lang['orange'] = "or4NGe";
$lang['yellow'] = "y3Ll0w";
$lang['green'] = "gReeN";
$lang['blue'] = "bLUE";
$lang['indigo'] = "indIG0";
$lang['violet'] = "vioLET";
$lang['white'] = "wh1+3";
$lang['black'] = "bl@CK";
$lang['grey'] = "gReY";
$lang['pink'] = "pINK";
$lang['lightgreen'] = "ligH+ grE3N";
$lang['lightblue'] = "l1gh+ BLUE";

// Forum Stats --------------------------------

$lang['forumstats'] = "forUM s+4T\$";
$lang['userstats'] = "us3R st@T\$";

$lang['usersactiveinthepasttimeperiod'] = "%s @C+1VE In THE p4\$+ %s. %s";

$lang['numactiveguests'] = "<b>%s</b> 9UESTS";
$lang['oneactiveguest'] = "<b>1</b> gU3sT";
$lang['numactivemembers'] = "<b>%s</b> MEM8eRS";
$lang['oneactivemember'] = "<b>1</b> m3m8ER";
$lang['numactiveanonymousmembers'] = "<b>%s</b> 4NONYm0uS mEMbeR\$";
$lang['oneactiveanonymousmember'] = "<b>1</b> 4noNYMOuS m3M8eR";

$lang['numthreadscreated'] = "<b>%s</b> +HrE4Ds";
$lang['onethreadcreated'] = "<b>1</b> +hR34d";
$lang['numpostscreated'] = "<b>%s</b> P05+S";
$lang['onepostcreated'] = "<b>1</b> p0ST";

$lang['younormal'] = "j00";
$lang['youinvisible'] = "j00 (1NviSI8LE)";
$lang['viewcompletelist'] = "vi3W coMPL3+3 lI\$+";
$lang['ourmembershavemadeatotalofnumthreadsandnumposts'] = "our M3M8ER\$ h4Ve M@de 4 +Ot@l 0f %s ANd %s.";
$lang['longestthreadisthreadnamewithnumposts'] = "l0NGesT +hREaD I5 <b>%s</b> w1Th %s.";
$lang['therehavebeenxpostsmadeinthelastsixtyminutes'] = "th3rE H4v3 B3EN <b>%s</b> P0sT\$ MADe 1n TEh LA5T 60 m1NUT3S.";
$lang['therehasbeenonepostmadeinthelastsxityminutes'] = "thEre H4S 83En <b>1</b> pO\$t M4DE In T3H l4st 60 miNUTeS.";
$lang['mostpostsevermadeinasinglesixtyminuteperiodwasnumposts'] = "m0St P05+S 3VEr M4DE iN a s1n9L3 60 MinUTE pEr1oD I\$ <b>%s</b> on %s.";
$lang['wehavenumregisteredmembersandthenewestmemberismembername'] = "we h4Ve <b>%s</b> REGI5+3REd MembER\$ 4ND ThE N3W3s+ mEMb3R 15 <b>%s</b>.";
$lang['wehavenumregisteredmember'] = "w3 H4V3 %s rEG1sTEr3d mEM8ER\$.";
$lang['wehaveoneregisteredmember'] = "wE H4vE oN3 R39I\$tERED MEM83R.";
$lang['mostuserseveronlinewasnumondate'] = "mO5+ US3RS eV3R 0NL1NE wA\$ <b>%s</b> oN %s.";
$lang['statsdisplaychanged'] = "st4ts D1SPl4y cH@nGED";

$lang['viewtop20'] = "vIeW +0P 20";

$lang['folderstats'] = "f0lD3R ST@TS";
$lang['threadstats'] = "thr3@D sT4+S";
$lang['poststats'] = "p0\$T S+@T\$";
$lang['pollstats'] = "p0LL \$t@TS";
$lang['attachmentsstats'] = "a++4CHM3NTS s+A+S";
$lang['userpreferencesstats'] = "uS3R Pr3PH3REnCE5 ST4TS";
$lang['visitorstats'] = "vIs1tOR s+A+S";
$lang['sessionstats'] = "sE\$sI0N St@+S";
$lang['profilestats'] = "pRoFILE S+A+S";
$lang['signaturestats'] = "sigN4TUre \$t4T\$";
$lang['ageandbirthdaystats'] = "a93 4ND b1rTHd4y 5+@TS";
$lang['relationshipstats'] = "relA+10N\$h1P ST@+s";
$lang['wordfilterstats'] = "w0RD f1L+3R \$+@+S";

$lang['numberoffolders'] = "numbER OF F0LDErs";
$lang['folderwithmostthreads'] = "folDER wI+h M0ST tHR34DS";
$lang['folderwithmostposts'] = "fOlDER WI+h M0\$+ P0\$Ts";
$lang['totalnumberofthreads'] = "to+4L NumBER 0f +Hre4DS";
$lang['longestthread'] = "lonGES+ +HREad";
$lang['mostreadthread'] = "most R34d +hR34d";
$lang['threadviews'] = "vIeWS";
$lang['averagethreadcountperfolder'] = "av3r4gE +hRE4D coUN+ P3R PHOldER";
$lang['totalnumberofthreadsubscriptions'] = "tOt4L NUmb3R OF thR3AD \$ubSCRIp+I0NS";
$lang['mostpopularthreadbysubscription'] = "mO5T p0PUL@R THre4D By \$ubSCr1PTiON";
$lang['totalnumberofposts'] = "t0+4L NUm8Er 0PH p05+S";
$lang['numberofpostsmadeinlastsixtyminutes'] = "nUmB3R OF pO\$+S M4D3 In L@st 60 M1nU+3s";
$lang['mostpostsmadeinasinglesixtyminuteperiod'] = "mOst P0s+S M4DE iN ONE 60 MInuTE p3ri0D";
$lang['averagepostsperuser'] = "aV3RAg3 P0\$TS p3r US3R";
$lang['topposter'] = "tOp P0s+3R";
$lang['totalnumberofpolls'] = "t0T4l NUM8ER OF P0lLS";
$lang['totalnumberofpolloptions'] = "t0T@l NUmBEr OF poLl oPTioN\$";
$lang['averagevotesperpoll'] = "av3R9E V0t3S pEr POLl";
$lang['totalnumberofpollvotes'] = "tot4L NuM83R 0f POlL V0+3\$";
$lang['totalnumberofattachments'] = "tOT4L num83R 0PH 4tT@chMen+5";
$lang['averagenumberofattachmentsperpost'] = "aver4Ge @t+AcHm3N+ cOUn+ PEr p0\$+";
$lang['mostdownloadedattachment'] = "moS+ D0WnLOAD3d 4++4ChM3nT";
$lang['mostusedforumstyle'] = "m0st u53d f0rum StyLe";
$lang['mostusedlanguuagefile'] = "m05T u\$Ed l@N9U@93 PhIlE";
$lang['mostusedtimezone'] = "mO\$+ US3D T1MEzoNE";
$lang['mostusedemoticonpack'] = "most U\$3D eM0TIcoN pACK";

$lang['numberofusers'] = "nUm83r 0pH uS3Rs";
$lang['newestuser'] = "nEW3sT usER";
$lang['numberofcontributingusers'] = "nUMb3r OF coN+R18U+iN9 US3R\$";
$lang['numberofnoncontributingusers'] = "numBER oF n0N-c0nTR18UTiN9 u\$3rS";
$lang['subscribers'] = "suBSCRiBERS";

$lang['numberofvisitorstoday'] = "nUmB3R 0PH vIS1T0RS +OD4Y";
$lang['numberofvisitorsthisweek'] = "num8eR 0F V1sI+Ors +hi\$ WE3k (P3RI0D: %s +O %s)";
$lang['numberofvisitorsthismonth'] = "num83r OF vIS1+ORS +HI\$ M0N+h";
$lang['numberofvisitorsthisyear'] = "nuM83R 0F vIS1T0RS THis Ye4R";

$lang['totalnumberofactiveusers'] = "t0t4L Num83R OF 4c+1V3 US3R\$";
$lang['numberofactiveregisteredusers'] = "nUm8eR oF 4C+1VE R3GI\$Ter3d U\$3R5";
$lang['numberofactiveguests'] = "nUMB3r 0F @cTIvE 9uES+S";
$lang['mostuserseveronline'] = "m0\$+ uSERS 3V3R 0NLIn3";
$lang['mostactiveuser'] = "mO\$T aC+1vE u53R";
$lang['numberofuserswithprofile'] = "nUMbeR 0Ph U5ERS wITh ProFIL3";
$lang['numberofuserswithoutprofile'] = "nuMBER OF uS3R\$ w1tH0U+ pR0F1L3";
$lang['numberofuserswithsignature'] = "num83R OF uS3r\$ W1Th S19N4TUre";
$lang['numberofuserswithoutsignature'] = "num83R OF U\$3RS W1Th0UT siGnA+UrE";
$lang['averageage'] = "aVER49E 49e";
$lang['mostpopularbirthday'] = "mo5+ p0pUL@r B1R+hd4Y";
$lang['nobirthdaydataavailable'] = "n0 81rThD4Y d4T4 @v@1l@Ble";
$lang['numberofusersusingwordfilter'] = "nUm83R Of US3R\$ U5IN9 W0RD PhILT3R";
$lang['numberofuserreleationships'] = "num8eR OF U\$Er REL3A+10N5H1P5";
$lang['averageage'] = "av3R4Ge AG3";
$lang['averagerelationshipsperuser'] = "aveR@93 R3L4tI0N\$HIPS PeR U\$ER";

$lang['numberofusersnotusingwordfilter'] = "nUmB3R 0PH U53R5 N0T uS1NG W0RD pH1l+3R";
$lang['averagewordfilterentriesperuser'] = "aV3RAG3 W0RD PH1L+3r eN+r13\$ PeR U5ER";

$lang['mostuserseveronlinedetail'] = "%s On %s";

// Thread Options (thread_options.php) ---------------------------------

$lang['updatessavedsuccessfully'] = "uPD4TES S@vED \$uCceS\$FULlY";
$lang['useroptions'] = "u\$ER opTi0N\$";
$lang['markedasread'] = "m@rK3d 4S r3aD";
$lang['postsoutof'] = "p05+S 0UT opH";
$lang['interest'] = "iNTEr3sT";
$lang['closedforposting'] = "cl05ED f0r POS+1N9";
$lang['locktitleandfolder'] = "l0cK tI+LE @Nd FoLDeR";
$lang['deletepostsinthreadbyuser'] = "d3l3tE posTS 1N +HR34D by useR";
$lang['deletethread'] = "delETE +HR3AD";
$lang['permenantlydelete'] = "p3rm@N3NTlY D3L3+E";
$lang['movetodeleteditems'] = "movE TO DEletED +hRe4dS";
$lang['undeletethread'] = "uNd3LE+e +hRe4d";
$lang['markasunread'] = "m4rK 4S UnRE4D";
$lang['makethreadsticky'] = "m4KE +hRE4D S+1CKy";
$lang['threareadstatusupdated'] = "thr3@D rE4D ST@+US Upd4T3D SUcCe5sFULly";
$lang['interestupdated'] = "thrE4D InT3RE\$T S+@+US UpD@+3D \$uCC3\$SpHUlLY";
$lang['failedtoupdatethreadreadstatus'] = "f41LED +O UPD4+3 tHrEAd R3@D \$+4+U\$";
$lang['failedtoupdatethreadinterest'] = "f4ilED +o UPD4tE THr34d INTEr3ST";
$lang['failedtorenamethread'] = "f@1L3D +o R3N@ME ThR3AD";
$lang['failedtomovethread'] = "f41LEd TO mOVe +HR34D +O 5pECifi3D f0LD3R";
$lang['failedtoupdatethreadstickystatus'] = "f@1LED +0 UPd4+3 THrE4d \$T1Cky S+A+US";
$lang['failedtoupdatethreadclosedstatus'] = "f4iL3D +o UPDA+E +HRe4D Cl0\$3D ST@TUS";
$lang['failedtoupdatethreadlockstatus'] = "f4ilED +0 uPdATE +hRE4D L0CK s+@Tus";
$lang['failedtodeletepostsbyuser'] = "f@1LEd T0 D3Le+3 P0\$ts 8y s3LECteD USER";
$lang['failedtodeletethread'] = "f4IL3D +0 D3l3tE +hr34D.";
$lang['failedtoundeletethread'] = "f41leD +o Un-D3LE+3 ThR3@D";

// Folder Options (folder_options.php) ---------------------------------

$lang['folderoptions'] = "f0lD3R 0P+1onS";
$lang['foldercouldnotbefound'] = "teh ReQUESt3D FOlDER couLd N0+ be pHOUNd Or 4CC35\$ WA\$ D3N1ED.";
$lang['failedtoupdatefolderinterest'] = "f41lED to upD4T3 F0LDeR 1N+erEST";

// Dictionary (dictionary.php) -----------------------------------------

$lang['dictionary'] = "dic+10n4RY";
$lang['spellcheck'] = "sp3LL cHECk";
$lang['notindictionary'] = "not 1N D1c+10N4Ry";
$lang['changeto'] = "chaN9E +o";
$lang['restartspellcheck'] = "re\$T4RT";
$lang['cancelchanges'] = "c4nCEL chAn9e\$";
$lang['initialisingdotdotdot'] = "ini+14LISin9...";
$lang['spellcheckcomplete'] = "sP3lL cHeck 1\$ C0MPLe+3. +O reST@R+ SpELL CH3CK clICk RE\$t@RT 8u++0N b3LOW.";
$lang['spellcheck'] = "spelL CHecK";
$lang['noformobj'] = "n0 F0RM 08JEc+ 5PECIFiED PH0R re+Urn +EXt";
$lang['bodytext'] = "bOdY +EX+";
$lang['ignore'] = "i9n0RE";
$lang['ignoreall'] = "iGNOR3 AlL";
$lang['change'] = "ch@N9E";
$lang['changeall'] = "chaNGe 4Ll";
$lang['add'] = "aDd";
$lang['suggest'] = "sugG35+";
$lang['nosuggestions'] = "(no sUggE\$tI0NS)";
$lang['cancel'] = "c4NceL";
$lang['dictionarynotinstalled'] = "n0 D1CT10N@RY h4s BEen 1N\$T@LLeD. pLE@sE C0N+4C+ +eh FOrUM OwNEr TO r3MEDY THis.";

// Permissions keys ----------------------------------------------------

$lang['postreadingallowed'] = "p05+ RE4DIN9 @LloWED";
$lang['postcreationallowed'] = "pO\$+ cr3aT10N @LL0WED";
$lang['threadcreationallowed'] = "tHR3@D Cr3@TI0N @LLOW3d";
$lang['posteditingallowed'] = "po5+ 3D1+1nG 4lLOWEd";
$lang['postdeletionallowed'] = "pO\$T DEl3tiON 4lL0WED";
$lang['attachmentsallowed'] = "a++4CHM3n+S 4LloWED";
$lang['htmlpostingallowed'] = "h+ml po\$+1N9 4LLOweD";
$lang['signatureallowed'] = "sI9n4+Ure 4LL0WEd";
$lang['guestaccessallowed'] = "gu35+ AcceSS 4LLOweD";
$lang['postapprovalrequired'] = "pOST 4Ppr0V4l R3QUIreD";

// RSS feeds gubbins

$lang['rssfeed'] = "r\$s PHE3D";
$lang['every30mins'] = "eVERY 30 MInu+3s";
$lang['onceanhour'] = "oNC3 An H0UR";
$lang['every6hours'] = "eVeRY 6 HOUr\$";
$lang['every12hours'] = "eV3rY 12 Hour\$";
$lang['onceaday'] = "onc3 4 D4Y";
$lang['onceaweek'] = "oNC3 4 WE3K";
$lang['rssfeeds'] = "rsS feEDS";
$lang['feedname'] = "f3ed n4M3";
$lang['feedfoldername'] = "fEED f0LD3R n4m3";
$lang['feedlocation'] = "f3eD L0c4t10N";
$lang['threadtitleprefix'] = "tHrEAd +1TL3 pR3F1X";
$lang['feednameandlocation'] = "f3ed n4mE @nD LoC4+1ON";
$lang['feedsettings'] = "feed S3+TiN9S";
$lang['updatefrequency'] = "upd@TE PHR3QUEnCY";
$lang['rssclicktoreadarticle'] = "clicK hER3 +O r3AD thI\$ 4rTicLE";
$lang['addnewfeed'] = "add N3W F3ED";
$lang['editfeed'] = "ed1T FE3D";
$lang['feeduseraccount'] = "f3ED uS3R aCC0UN+";
$lang['noexistingfeeds'] = "nO 3XI5+INg rss PH3Ed\$ phOUND. +0 4DD 4 Ph33d Cl1cK thE '@Dd n3W' 8UtTON B3l0w";
$lang['rssfeedhelp'] = "her3 j00 C@n \$e+UP some rSs f3Eds FOR 4U+0M4t1C pR0P@94Ti0N iNT0 yOUR pH0RUM. TH3 i+3M5 Fr0m +EH R\$\$ PhEEDs J00 4DD w1ll B3 CrEA+3D 4s +hR3AD\$ Wh1cH U\$3RS c4n r3pLy TO 4S 1pH thEY wEr3 N0Rm4l p05T\$. The RSS f3ED mUST 83 4CC3s\$i8L3 Vi@ H++P or 1T w1lL n0+ w0RK.";
$lang['mustspecifyrssfeedname'] = "mu\$+ \$PECiPHy R5\$ F33D N4M3";
$lang['mustspecifyrssfeeduseraccount'] = "mUs+ SPeCIPhY rsS pheED u53r acC0UNT";
$lang['mustspecifyrssfeedfolder'] = "mus+ \$p3CIFy RSS f3ED f0LD3R";
$lang['mustspecifyrssfeedurl'] = "mUs+ Sp3CIpHy R\$S FE3D uRl";
$lang['mustspecifyrssfeedupdatefrequency'] = "mUs+ SPecIFY rSS PH33D uPD@tE phREqUENcY";
$lang['unknownrssuseraccount'] = "uNKNOwN rsS usER 4cCOuN+";
$lang['rssfeedsupportshttpurlsonly'] = "r\$s FE3D 5UPp0rT\$ H+TP UrLS 0NLY. S3CUR3 fe3d\$ (HTTps://) @r3 N0T sUPPoR+3D.";
$lang['rssfeedurlformatinvalid'] = "r\$s F33D Url PHOrM@t 1\$ 1NV4LId. Url MU\$+ 1nCLudE sCH3m3 (3.G. HTtP://) 4ND 4 HO\$+N4M3 (3.g. Www.hoSTn@ME.coM).";
$lang['rssfeeduserauthentication'] = "rS\$ F33D D0e\$ n0T SupPOrT hTTp US3R @u+H3NtiC@t10n";
$lang['successfullyremovedselectedfeeds'] = "sUCC3SsPhuLLy R3MOv3d \$3LeC+3D FE3D5";
$lang['successfullyaddedfeed'] = "sucC3\$SPhulLy 4DDeD NeW Phe3D";
$lang['successfullyeditedfeed'] = "sUcCeS5fuLLY ED1teD FE3d";
$lang['failedtoremovefeeds'] = "f@1LEd +O REM0Ve sOme oR @ll Of +eH SeL3C+3D F33D5";
$lang['failedtoaddnewrssfeed'] = "f4iLED +o 4DD n3w RSS PH33D";
$lang['failedtoupdaterssfeed'] = "f41LED tO Upd4T3 RSs F33D";
$lang['rssstreamworkingcorrectly'] = "rss \$TR34m ApPEaR\$ +0 83 WOrK1N9 coRr3C+Ly";
$lang['rssstreamnotworkingcorrectly'] = "r5S S+rEam was eMp+Y or COulD NO+ bE Ph0uNd";
$lang['invalidfeedidorfeednotfound'] = "inV4lID F33d 1d OR FEED NO+ phoUND";

// PM Export Options

$lang['pmexportastype'] = "exp0rT @\$ +yPE";
$lang['pmexporthtml'] = "html";
$lang['pmexportxml'] = "xML";
$lang['pmexportplaintext'] = "pl41N +3xt";
$lang['pmexportmessagesas'] = "exp0RT m3SS493s 4S";
$lang['pmexportonefileforallmessages'] = "oN3 FILE F0r aLL MESSAg3s";
$lang['pmexportonefilepermessage'] = "one F1L3 pER M3\$S@93";
$lang['pmexportattachments'] = "expoRT A++AchMEN+S";
$lang['pmexportincludestyle'] = "iNCLUD3 fOrUM STYLE \$HE3t";
$lang['pmexportwordfilter'] = "apPlY WoRD FiLT3R T0 MesSAGEs";

// Thread merge / split options

$lang['threadhasbeensplit'] = "tHR34d H4\$ B3EN SplI+";
$lang['threadhasbeenmerged'] = "tHrE@d Ha\$ BEeN M3RGEd";
$lang['mergesplitthread'] = "mer9e / sPLIt ThRE4d";
$lang['mergewiththreadid'] = "mER93 WiTH +hREAd ID:";
$lang['postsinthisthreadatstart'] = "postS 1N +h1\$ +HRead 4+ \$+4rT";
$lang['postsinthisthreadatend'] = "p0STS 1N tHIS THr3@d @T 3ND";
$lang['reorderpostsintodateorder'] = "r3-oRDER p0sT\$ 1N+0 d4+3 ORDeR";
$lang['splitthreadatpost'] = "spl1t ThR34D 4T p0\$+:";
$lang['selectedpostsandrepliesonly'] = "s3l3c+3D poST AND REpl1E\$ 0NlY";
$lang['selectedandallfollowingposts'] = "sel3C+3D 4ND @LL PhOLl0WInG p0\$ts";

$lang['threadmovedhere'] = "h3r3";

$lang['thisthreadhasmoved'] = "<b>thR3@DS MER93d:</b> ThIS ThR3AD h4s MOVed %s";
$lang['thisthreadwasmergedfrom'] = "<b>tHr34D\$ m3RGEd:</b> Th1s +HR3ad w4\$ M3R93D PhROm %s";
$lang['somepostsinthisthreadhavebeenmoved'] = "<b>thre@D \$PliT:</b> \$0ME pO\$T\$ IN +H1\$ THr3ad H4Ve BEEn M0VED %s";
$lang['somepostsinthisthreadweremovedfrom'] = "<b>tHrE@D sPli+:</b> soM3 PO\$TS 1N THI\$ +hRE4d W3RE m0VEd FR0M %s";

$lang['thisposthasbeenmoved'] = "<b>thrE@D sPLIt:</b> +His p0\$+ h@S Be3n M0VED %s";

$lang['invalidfunctionarguments'] = "inv4liD FUNc+1oN @RgumENts";
$lang['couldnotretrieveforumdata'] = "couLD no+ ReTRi3v3 f0RUM daT4";
$lang['cannotmergepolls'] = "oN3 OR moR3 tHRE4D\$ IS 4 PolL. J00 C@nNO+ mERge poLl\$";
$lang['couldnotretrievethreaddatamerge'] = "couLD No+ R3TrIEVe +HrE4d D4T@ pHROM OnE 0R M0R3 +hR34DS";
$lang['couldnotretrievethreaddatasplit'] = "c0ulD n0T RE+riEv3 ThRE4D D@T4 PhROM \$0uRCE tHr3aD";
$lang['couldnotretrievepostdatamerge'] = "c0ulD noT r3TR1EV3 P0\$+ D4+4 PhR0M ONe 0r M0R3 +HReaD\$";
$lang['couldnotretrievepostdatasplit'] = "cOULD n0+ rE+rI3VE pO\$+ D4+@ PHRom SOUrcE THreAD";
$lang['failedtocreatenewthreadformerge'] = "f41l3D To CrE4T3 n3w +HrE4D PhoR m3RGE";
$lang['failedtocreatenewthreadforsplit'] = "f41LED +o CRE4T3 N3W +HreAd PHor \$pL1T";

// Thread subscriptions

$lang['threadsubscriptions'] = "tHR3@D \$uBSCRip+1ON\$";
$lang['couldnotupdateinterestonthread'] = "couLd nOT UPDAt3 In+3RES+ 0N +hRE4D '%s'";
$lang['threadinterestsupdatedsuccessfully'] = "tHr3@D InT3RE\$TS uPD4tED sUCCesSFUlLY";
$lang['nothreadsubscriptions'] = "j00 4rE N0T sUb\$CRIbED tO 4nY +hREAd\$.";
$lang['nothreadsignored'] = "j00 4R3 N0T IgN0R1NG 4NY THrEAD\$.";
$lang['nothreadsonhighinterest'] = "j00 H@VE n0 H1GH IN+ER3s+ +Hr34D\$.";
$lang['resetselected'] = "rES3+ SEl3cTEd";
$lang['ignoredthreads'] = "ign0r3D +hREaDS";
$lang['highinterestthreads'] = "h19h 1N+3r3sT THr34DS";
$lang['subscribedthreads'] = "su8\$cr1BEd +Hr34DS";
$lang['currentinterest'] = "currEN+ INT3REST";

// Folder subscriptions

$lang['foldersubscriptions'] = "fOlD3R SUbsCRIPti0NS";
$lang['couldnotupdateinterestonfolder'] = "couLD NOt UPd4+E 1N+erESt 0N PhOLDer '%s'";
$lang['folderinterestsupdatedsuccessfully'] = "f0lD3R 1N+3r3sTS UPd@TED \$uCce\$SPhuLLY";
$lang['nofoldersubscriptions'] = "j00 4r3 N0T \$uBScr1b3D +O @nY Ph0lD3RS.";
$lang['nofoldersignored'] = "j00 @Re NOt 19N0RIng 4NY fold3RS.";
$lang['resetselected'] = "re53+ \$3LECt3d";
$lang['ignoredfolders'] = "i9noRED foLD3R\$";
$lang['subscribedfolders'] = "sU8sCr183d FOlDERs";

// Browseable user profiles

$lang['youcanonlyaddthreecolumns'] = "j00 C@n ONlY @dD 3 C0LUMns. +o 4DD 4 New COLUmN Cl05e An eX1\$TInG ONe";
$lang['columnalreadyadded'] = "j00 H4VE 4lr3@DY aDdED +H1\$ COLuMN. 1pH J00 WAnT +0 R3M0VE i+ Cl1cK 1+S CloS3 BU+TON";

?>