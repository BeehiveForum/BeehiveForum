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

/* $Id: x-hacker.inc.php,v 1.305 2009-06-21 14:25:55 decoyduck Exp $ */

// British English language file

// Language character set and text direction options -------------------

$lang['_isocode'] = "en-gb";
$lang['_textdir'] = "ltr";

// Months --------------------------------------------------------------

$lang['month'][1]  = "j4nU4ry";
$lang['month'][2]  = "fEBRU4Ry";
$lang['month'][3]  = "m4RcH";
$lang['month'][4]  = "apRIl";
$lang['month'][5]  = "m@Y";
$lang['month'][6]  = "junE";
$lang['month'][7]  = "jUlY";
$lang['month'][8]  = "aU9us+";
$lang['month'][9]  = "seP+3m83R";
$lang['month'][10] = "oC+O8ER";
$lang['month'][11] = "nOVem83r";
$lang['month'][12] = "dECEm8eR";

$lang['month_short'][1]  = "j4n";
$lang['month_short'][2]  = "f38";
$lang['month_short'][3]  = "m4R";
$lang['month_short'][4]  = "aPr";
$lang['month_short'][5]  = "m4Y";
$lang['month_short'][6]  = "jun";
$lang['month_short'][7]  = "juL";
$lang['month_short'][8]  = "aUg";
$lang['month_short'][9]  = "s3p";
$lang['month_short'][10] = "oC+";
$lang['month_short'][11] = "n0v";
$lang['month_short'][12] = "d3c";

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

$lang['date_periods']['year']   = "%s yE4R";
$lang['date_periods']['month']  = "%s M0n+h";
$lang['date_periods']['week']   = "%s w3ek";
$lang['date_periods']['day']    = "%s D4y";
$lang['date_periods']['hour']   = "%s H0ur";
$lang['date_periods']['minute'] = "%s miNU+3";
$lang['date_periods']['second'] = "%s 53C0ND";

// As above but plurals (2 years vs. 1 year, etc.)

$lang['date_periods_plural']['year']   = "%s Y3@Rs";
$lang['date_periods_plural']['month']  = "%s moN+h\$";
$lang['date_periods_plural']['week']   = "%s weeks";
$lang['date_periods_plural']['day']    = "%s D@Y\$";
$lang['date_periods_plural']['hour']   = "%s h0uR\$";
$lang['date_periods_plural']['minute'] = "%s MINU+35";
$lang['date_periods_plural']['second'] = "%s s3C0nD5";

// Short hand periods (example: 1y, 2m, 3w, 4d, 5hr, 6min, 7sec)

$lang['date_periods_short']['year']   = "%sy";    // 1y
$lang['date_periods_short']['month']  = "%sm";    // 2m
$lang['date_periods_short']['week']   = "%sW";    // 3w
$lang['date_periods_short']['day']    = "%sD";    // 4d
$lang['date_periods_short']['hour']   = "%sHr";   // 5hr
$lang['date_periods_short']['minute'] = "%sMIN";  // 6min
$lang['date_periods_short']['second'] = "%sseC";  // 7sec

// Common words --------------------------------------------------------

$lang['percent'] = "p3rC3Nt";
$lang['average'] = "aV3R493";
$lang['approve'] = "apPr0V3";
$lang['banned'] = "b@nNeD";
$lang['locked'] = "lOCKeD";
$lang['add'] = "aDd";
$lang['advanced'] = "aDV4nC3D";
$lang['active'] = "actiVE";
$lang['style'] = "s+yLE";
$lang['go'] = "g0";
$lang['folder'] = "f0Ld3R";
$lang['ignoredfolder'] = "i9nOReD FolD3R";
$lang['subscribedfolder'] = "su85CR183D Ph0lD3R";
$lang['folders'] = "fOLD3R5";
$lang['thread'] = "thR3@d";
$lang['threads'] = "tHRE@D\$";
$lang['threadlist'] = "thR3@d L1\$+";
$lang['message'] = "m3Ss4G3";
$lang['from'] = "fR0M";
$lang['to'] = "t0";
$lang['all_caps'] = "all";
$lang['of'] = "oPh";
$lang['reply'] = "r3Ply";
$lang['forward'] = "fORW4rD";
$lang['replyall'] = "rEPLY To @LL";
$lang['quickreply'] = "qu1ck rEPLY";
$lang['quickreplyall'] = "qUICK rEpLY t0 4Ll";
$lang['pm_reply'] = "rePLY 45 PM";
$lang['delete'] = "d3Le+3";
$lang['deleted'] = "d3L3T3D";
$lang['edit'] = "edi+";
$lang['export'] = "eXp0rt";
$lang['privileges'] = "pr1V1L3gES";
$lang['ignore'] = "iGN0rE";
$lang['normal'] = "norm@L";
$lang['interested'] = "iN+3re\$+3d";
$lang['subscribe'] = "sU8sCR183";
$lang['apply'] = "aPpLY";
$lang['enable'] = "en48L3";
$lang['download'] = "d0Wnl04d";
$lang['save'] = "saV3";
$lang['update'] = "uPda+3";
$lang['cancel'] = "c4nc3l";
$lang['continue'] = "cON+1nUe";
$lang['attachment'] = "aT+@cHMEnT";
$lang['attachments'] = "aTtacHM3nT5";
$lang['imageattachments'] = "im49e 4T+4CHM3N+\$";
$lang['filename'] = "fIL3n4mE";
$lang['dimensions'] = "dIm3nSION\$";
$lang['downloadedxtimes'] = "d0Wnl04DeD: %d +1m35";
$lang['downloadedonetime'] = "d0wnloADeD: 1 +1M3";
$lang['size'] = "s1ze";
$lang['viewmessage'] = "v1ew Me\$\$4G3";
$lang['deletethumbnails'] = "deLe+3 +HUm8naILS";
$lang['logon'] = "lOgOn";
$lang['more'] = "m0Re";
$lang['recentvisitors'] = "reCenT V1\$iT0R5";
$lang['username'] = "us3rnaM3";
$lang['clear'] = "cLE@R";
$lang['reset'] = "rE53T";
$lang['action'] = "aC+ION";
$lang['unknown'] = "uNKN0WN";
$lang['none'] = "n0N3";
$lang['preview'] = "prev13W";
$lang['post'] = "p05+";
$lang['posts'] = "p0St\$";
$lang['change'] = "ch4N9e";
$lang['yes'] = "yes";
$lang['no'] = "n0";
$lang['signature'] = "s1Gn4tUre";
$lang['signaturepreview'] = "sIGN4+UR3 PR3ViEW";
$lang['signatureupdated'] = "si9n4+URe uPD4+eD";
$lang['signatureupdatedforallforums'] = "sI9N4Tur3 UpD4TED PH0R @lL ph0RUm5";
$lang['back'] = "b4cK";
$lang['subject'] = "sU8jEct";
$lang['close'] = "cLoS3";
$lang['name'] = "n4mE";
$lang['description'] = "de5cr1pT1ON";
$lang['date'] = "d4+3";
$lang['view'] = "vI3w";
$lang['enterpasswd'] = "eNTEr Passw0rD";
$lang['passwd'] = "pAS\$wORd";
$lang['ignored'] = "ignOREd";
$lang['guest'] = "gues+";
$lang['next'] = "nEXt";
$lang['prev'] = "preV10uS";
$lang['others'] = "othERS";
$lang['nickname'] = "niCKN4me";
$lang['emailaddress'] = "eM41l 4Ddr3\$s";
$lang['confirm'] = "c0nPHIrm";
$lang['email'] = "eM41L";
$lang['poll'] = "p0ll";
$lang['friend'] = "fRIEnD";
$lang['success'] = "sUcCeSS";
$lang['error'] = "erRor";
$lang['warning'] = "waRn1n9";
$lang['guesterror'] = "sOrRY, j00 N3ED +O 83 l099ED IN TO uS3 THI\$ f34tur3.";
$lang['loginnow'] = "lOGIN noW";
$lang['unread'] = "uNr3@D";
$lang['all'] = "all";
$lang['allcaps'] = "alL";
$lang['permissions'] = "pErmIS51on5";
$lang['type'] = "tYP3";
$lang['print'] = "pRIN+";
$lang['sticky'] = "st1Cky";
$lang['polls'] = "p0lLS";
$lang['user'] = "uS3r";
$lang['enabled'] = "en@8lEd";
$lang['disabled'] = "d1\$@BL3D";
$lang['options'] = "op+1oNS";
$lang['emoticons'] = "eM0T1cON\$";
$lang['webtag'] = "w38+4g";
$lang['makedefault'] = "m@k3 d3ph4ULT";
$lang['unsetdefault'] = "unS3t DeF@ulT";
$lang['rename'] = "r3N@mE";
$lang['pages'] = "p49e\$";
$lang['used'] = "uS3d";
$lang['days'] = "d4yS";
$lang['usage'] = "us@93";
$lang['show'] = "sh0W";
$lang['hint'] = "h1NT";
$lang['new'] = "n3W";
$lang['referer'] = "rEpHER3R";
$lang['thefollowingerrorswereencountered'] = "tHE PhOlloW1ng ERR0RS W3R3 ENCOUnT3REd:";

// Admin interface (admin*.php) ----------------------------------------

$lang['admintools'] = "adM1n +ool\$";
$lang['forummanagement'] = "fORUM m4N493m3n+";
$lang['accessdeniedexp'] = "j00 DO N0T H4Ve peRm1s\$1on +0 US3 +H1S SeCTION.";
$lang['managefolder'] = "man49E pH0Ld3r";
$lang['managefolders'] = "m4N@9e Ph0Ld3r5";
$lang['manageforums'] = "m4N49e PH0RUM\$";
$lang['manageforumpermissions'] = "m@N@9E PH0rUM p3rMi5\$10n5";
$lang['foldername'] = "f0lDEr NAM3";
$lang['move'] = "m0vE";
$lang['closed'] = "cL0S3D";
$lang['open'] = "oPEN";
$lang['restricted'] = "r3\$+RICTEd";
$lang['forumiscurrentlyclosed'] = "%s 1\$ cURR3N+Ly ClOSeD";
$lang['youdonothaveaccesstoforum'] = "j00 D0 N0+ have 4CC35\$ +0 %s. %s";
$lang['toapplyforaccessplease'] = "t0 4pPly FOR @cCe\$\$ pL34S3 CoN+@C+ thE %s.";
$lang['forumowner'] = "f0RuM 0WN3r";
$lang['adminforumclosedtip'] = "iF J00 w@n+ T0 cH4n93 \$0M3 53++inG\$ 0N Y0UR pH0rUm ClIck tHE 4dmIn L1nk IN +eH naV1GA+10n B@R @B0v3.";
$lang['newfolder'] = "new FOLD3R";
$lang['nofoldersfound'] = "no ex1sTIng ph0LD3rs ph0uND. T0 AdD 4 F0LdER CL1Ck Th3 '4DD nEW' but+On 8ElOw.";
$lang['forumadmin'] = "f0rUM 4dmIN";
$lang['adminexp_1'] = "uS3 +H3 M3Nu ON tEH l3PH+ +0 M@n4g3 ThiNgs in y0UR PH0Rum.";
$lang['adminexp_2'] = "<b>useR\$</b> 4lLowS J00 To se+ 1nDiVIDUAl U\$3r P3RMI5\$10N\$, inClUd1nG 4PPo1nTInG M0D3RAToRS 4nD g@9g1N9 PE0PLe.";
$lang['adminexp_3'] = "<b>u53R gRoUp5</b> AlLOWs J00 +o CrE4Te uS3R 9rOupS +o 4SS1gn peRM1\$s10n\$ t0 4S M@NY 0r @5 f3w us3R\$ QUickLY 4ND E@siLY.";
$lang['adminexp_4'] = "<b>baN CONTrOLS</b> 4llOW\$ +3H b4nN1N9 ANd Un-8aNniN9 OF 1p 4DDREsSes, httP r3F3REr\$, Us3RN4Me\$, 3M4IL @DdresseS 4nD nIcKN@mE\$.";
$lang['adminexp_5'] = "<b>f0lD3R5</b> All0W5 T3H Cr34+1On, M0D1f1C4+10n @nD dELe+I0n 0f PH0Ld3r\$.";
$lang['adminexp_6'] = "<b>r5\$ PHE3d\$</b> 4LLoWS j00 T0 M@n@9E RS\$ fE3DS fOR PrOp4g4tion INto YOuR f0rUm.";
$lang['adminexp_7'] = "<b>pr0f1l35</b> le+\$ j00 cU5+OmisE tH3 I+eMS +h4+ @PP34R In TEH u53r pr0ph1lE\$.";
$lang['adminexp_8'] = "<b>f0Rum \$3T+inG\$</b> aLl0w5 J00 +o CuSt0m153 y0UR ph0rUm'\$ N@m3, @PP34rANc3 4nD M4nY oth3r THInG\$.";
$lang['adminexp_9'] = "<b>s+4RT p493</b> lE+s J00 CuST0m1sE y0uR FORum'5 5+4rt P49E.";
$lang['adminexp_10'] = "<b>f0RUM 5+yL3</b> 4LLow5 J00 +o G3n3rA+3 R4NDOM stylES fOr Y0UR fORuM m3mB3R\$ +0 u53.";
$lang['adminexp_11'] = "<b>w0rD fiLT3R</b> 4LL0W\$ J00 +O f1L+3r W0Rds j00 D0N'+ W@NT T0 83 u5eD on Y0ur f0Rum.";
$lang['adminexp_12'] = "<b>p0st1N9 \$TAT\$</b> g3nEr4+e5 4 r3p0r+ LiST1N9 TH3 +op 10 po\$+eRS 1n 4 DePH1nED P3R1Od.";
$lang['adminexp_13'] = "<b>f0rUM l1nK5</b> lE+s J00 mAN49e Th3 L1NKs dR0PDowN 1N +3H N4v194T1oN bar.";
$lang['adminexp_14'] = "<b>vIEW L09</b> lists rEcEnt @C+10N\$ 8y +3H Ph0ruM M0D3R4T0R\$.";
$lang['adminexp_15'] = "<b>m4N4g3 PHORuM\$</b> l3+s J00 cRE4t3 4ND DEl3tE @nD CL0sE 0r R30pEN fORuMS.";
$lang['adminexp_16'] = "<b>gl084l FOrUM \$3t+INGS</b> 4llOW\$ j00 t0 M0DIPhy S3T+1NGS wH1Ch 4FphEc+ 4LL f0ruMs.";
$lang['adminexp_17'] = "<b>post @PPROvAL qu3U3</b> @lloWs j00 T0 V1EW 4ny p0ST\$ 4W41t1N9 @pProV@L BY 4 MOd3ratOR.";
$lang['adminexp_18'] = "<b>v151+oR L09</b> 4LLOWS j00 T0 V1EW 4n Ex+EnDEd L1sT OpH vi\$I+ors INCLUdIN9 +hEIr H+TP R3PhEReRs.";
$lang['createforumstyle'] = "cr3@Te 4 FoRUM \$+Yle";
$lang['newstylesuccessfullycreated'] = "n3w STyLE sUcCeS5PHuLLY CRE4+3D.";
$lang['stylealreadyexists'] = "a 5+yL3 w1TH TH4t ph1LEn4m3 @lr3ADy 3x1\$T5.";
$lang['stylenofilename'] = "j00 D1d N0T eN+ER 4 FiLeN@Me t0 \$4vE TEh S+YL3 wiTH.";
$lang['stylenodatasubmitted'] = "cOULd NOt R34D pHORUm \$+yLE D4T4.";
$lang['stylecontrols'] = "cOn+R0L5";
$lang['stylecolourexp'] = "cLICK 0n @ col0uR to M@KE A n3w \$+Yl3 5HeE+ 8@53D oN tH4+ C0L0ur. cURR3N+ 8@Se c0lOur 1s PHiRST iN li5+.";
$lang['standardstyle'] = "s+4Nd4rD \$tYl3";
$lang['rotelementstyle'] = "rO+A+eD 3lEm3nt \$tyL3";
$lang['randstyle'] = "r@nD0M 5tYL3";
$lang['thiscolour'] = "thi\$ COl0uR";
$lang['enterhexcolour'] = "oR 3nT3R @ hEx c0l0Ur to 8@S3 @ n3W s+YL3 SHeET On";
$lang['savestyle'] = "s4VE tHI5 STYl3";
$lang['styledesc'] = "sTyL3 d3sCRiPT1ON";
$lang['stylefilenamemayonlycontain'] = "s+Yl3 PH1LEnAMe M4Y 0NLY C0N+@1n LowErc4Se LeT+er\$ (4-z), nUMB3R5 (0-9) 4ND UNd3R5C0r3.";
$lang['stylepreview'] = "styLE pReV13w";
$lang['welcome'] = "wELC0ME";
$lang['messagepreview'] = "m3sS@93 PrEVi3w";
$lang['users'] = "usEr5";
$lang['usergroups'] = "us3r GR0Up5";
$lang['mustentergroupname'] = "j00 mUs+ enT3R A GRoUP nAM3";
$lang['profiles'] = "pRof1lES";
$lang['manageforums'] = "m4na9E ph0RUM5";
$lang['forumsettings'] = "fOrum Se++1N95";
$lang['globalforumsettings'] = "glob4L pH0Rum S3TTiN9s";
$lang['settingsaffectallforumswarning'] = "<b>n0te:</b> +h35e s3t+inG\$ 4fPh3c+ 4ll pH0RumS. WhER3 +3h s3t+in9 15 DUpLic@TeD 0n TH3 inDiVIdu4l F0RUm'\$ 53tT1Ngs PA9E TH@+ wiLL +@kE pr3CEdencE 0Ver t3H 53++INg\$ J00 Ch4n9E h3rE.";
$lang['startpage'] = "s+4RT P4g3";
$lang['startpageerror'] = "y0ur S+@RT P4gE COuLD NO+ bE s4V3D loCaLLY +O +hE sERveR BeCAu53 P3RMIs5i0n W4\$ d3NI3D.</p><p>t0 CH4N93 Y0UR st@rt paG3 ple@SE CLIcK +HE D0WNl0@D bUt+On 83l0w whiCH WIll PRoMP+ J00 T0 5@Ve TH3 F1L3 +O YoUR H4Rd Dr1v3. J00 c4N +HEn UpLoaD +H1s PHIl3 TO YouR 5ErveR INTO +HE foLLOW1n9 foLD3r, 1pH N3C3s\$4RY Cr34TiNg T3h PH0LD3r \$+rUctUR3 1N th3 PROcEsS.</p><p><b>%s</b></p><p>pl34\$3 N0+E +H4T 5oM3 bROWS3rS M@Y ch4n9e +eh N4ME 0F +HE pH1L3 uP0n D0WNLO4D. WheN upL0@D1n9 THE Fil3 Pl3453 M@K3 5uRE THa+ I+ i\$ N4mEd sT4R+_M4iN.Php OTH3rWIS3 Y0ur 5T4rt p4g3 WILL @pP3@R UNcH@NG3D.";
$lang['uploadcssfile'] = "uPL0@D C5s 5+YL3 \$HEeT";
$lang['uploadcssfilefailed'] = "yOUR Css \$tyl3 sH3E+ COuLd not bE uPL04dEd +o +hE \$eRV3R 83C4Us3 p3RMisSi0n W4s d3NI3D.</p><p>t0 ChaNgE Y0UR 5+ar+ p4g3 Css S+YL3 SHE3T PlE4sE EnsUR3 +3h fOLLOwINg F0LdERS eX1St 4Nd 4r3 WR1+48lE: </p><p><b>%s</b></p>";
$lang['invalidfiletypeerror'] = "inv4L1D fiLe TypE, J00 c4n ONLy UpLo4D CsS \$tyl3 \$He3t ph1le5";
$lang['failedtoopenmasterstylesheet'] = "y0UR ForUM \$+Yl3 COULD NOT b3 sav3d B3C@U\$3 ThE m45+3R StYLe Sh3e+ COuLD N0T b3 Lo4d3d. TO 54Ve Y0ur \$+yl3 T3h m4STER s+Yl3 5h3eT (M4KE_STylE.C\$s) Mu\$+ 8E loC4+3D iN +he STyL35 diRectOrY 0pH y0uR BeEh1vE PhoRuM 1N\$T4LL4+10n.";
$lang['makestyleerror'] = "y0uR PHOrUM \$tYl3 C0ULd n0t 8e \$@v3d LOc4LLY +0 +eh 53RVeR 83CAU5E pErm1sSi0N w@5 D3niED.</p><p>t0 5@vE YOuR FoRUm \$TYLe PlE@S3 cLIcK t3h D0WnlO4D BU+t0n 8EloW wHiCH wIll Pr0mp+ j00 t0 \$AVe tEH ph1l3 +o YoUR h@rD Dr1VE. j00 CaN +h3N UplO4D +His f1l3 +o Y0uR S3RV3r INt0 t3h FOLLow1n9 folDer, If n3c3SS4RY crE4T1N9 T3H F0LD3r S+RUcTURE 1n +He PROcESS.</p><p><b>%s</b></p><p>pLE453 N0t3 THA+ SOm3 8r0wsers M4y ch@N9e +Eh N4ME of +hE Ph1LE Up0N doWNLO4D. When uPL04d1n9 +HE f1l3 PL34\$3 mAK3 5uR3 tH@+ 1+ 1\$ N4MeD 5+YlE.C\$\$ Oth3RWi\$3 TEh F0RUM sTylE w1ll 83 Un@V4iL4BL3.";
$lang['forumstyle'] = "forUM Style";
$lang['wordfilter'] = "w0Rd ph1LtER";
$lang['forumlinks'] = "f0rum L1nk5";
$lang['viewlog'] = "v13W LOG";
$lang['noprofilesectionspecified'] = "n0 PROFiLE sEct1on SpEC1FI3D.";
$lang['itemname'] = "it3M n@m3";
$lang['moveto'] = "movE to";
$lang['manageprofilesections'] = "m@n@Ge pR0FILE S3C+i0ns";
$lang['sectionname'] = "s3c+IOn N4Me";
$lang['items'] = "i+em\$";
$lang['mustspecifyaprofilesectionid'] = "mus+ 5PEc1fy 4 ProF1L3 \$3C+10N Id";
$lang['mustsepecifyaprofilesectionname'] = "mU\$t \$P3CIPhy @ ProFiLE 53C+10n n4me";
$lang['noprofilesectionsfound'] = "nO Exist1N9 pr0FiLe SeC+iON\$ ph0unD. +o 4Dd 4 Pr0fiL3 5Ec+10n cL1CK +eH 'aDd nEw' BU++On BeL0W.";
$lang['addnewprofilesection'] = "aDD n3w Pr0ph1lE \$3C+10N";
$lang['successfullyaddedprofilesection'] = "sucC35\$phuLLy ADD3D Pr0pHILe SecTioN";
$lang['successfullyeditedprofilesection'] = "suCc3SSfULLY Ed1tEd PR0FIL3 53C+10N";
$lang['addnewprofilesection'] = "aDD NeW pr0PH1LE sECTIoN";
$lang['mustsepecifyaprofilesectionname'] = "mUS+ SpEc1fY 4 PROpH1LE 5eCTIoN n4mE";
$lang['successfullyremovedselectedprofilesections'] = "suCCES\$PHulLy ReM0V3D \$3lEC+3d ProPHil3 S3C+10NS";
$lang['failedtoremoveprofilesections'] = "f@1L3D +0 r3move PR0FILE 53ct10n\$";
$lang['viewitems'] = "vIEW I+3M5";
$lang['successfullyaddednewprofileitem'] = "sUCces\$phulLy 4DD3D nEW pR0PH1LE 1t3M";
$lang['successfullyeditedprofileitem'] = "suCCE\$\$PhULLy 3DITeD pROPh1l3 1+Em";
$lang['successfullyremovedselectedprofileitems'] = "suCcE5\$phuLLy R3mOv3D 53lEc+3D PRoPh1lE 1t3MS";
$lang['failedtoremoveprofileitems'] = "fail3D T0 R3m0v3 PROfILe 1+Ems";
$lang['noexistingprofileitemsfound'] = "theRE 4Re N0 ex1sTINg PRopHil3 I+3M\$ 1N +h1s S3CtiON. To 4DD 4N iTeM CL1Ck ThE '@Dd N3W' 8uT+0n 83Low.";
$lang['edititem'] = "eD1+ 1+EM";
$lang['invalidprofilesectionid'] = "inValId PROPh1Le S3C+1oN Id 0r S3CtiON NoT phOund";
$lang['invalidprofileitemid'] = "iNvAL1d pRoFIle 1+3M Id Or IT3M N0+ f0uNd";
$lang['addnewitem'] = "aDD n3w iTeM";
$lang['youmustenteraprofileitemname'] = "j00 Mu\$+ 3n+3R 4 PROfILe It3m n4m3";
$lang['invalidprofileitemtype'] = "inv4lId pR0pH1le 1T3M +yP3 53l3C+3d";
$lang['youmustenteroptionsforselectedprofileitemtype'] = "j00 MU\$+ En+Er \$ome OP+I0nS PH0R \$3l3cT3D pr0FilE 1+3m +yp3";
$lang['youmustentermorethanoneoptionforitem'] = "j00 Mu\$t 3N+er M0RE TH@N oN3 0p+iON pH0R \$3l3C+3D ProPh1Le iTEm +YpE";
$lang['profileitemhyperlinkssupportshttpurlsonly'] = "propH1L3 IT3M HYP3rLInk\$ SupPoRt H+Tp Url5 0Nly";
$lang['profileitemhyperlinkformatinvalid'] = "pROFIlE 1t3m hYp3rl1NK phOrm4T inV@Lid";
$lang['youmustincludeprofileentryinhyperlinks'] = "j00 Mus+ 1NcluD3 <i>%s</i> 1n Th3 URL oF CLiCK48LE hYP3RL1NKS";
$lang['failedtocreatenewprofileitem'] = "f@1led +0 cR34+E nEW pRopH1le 1+3M";
$lang['failedtoupdateprofileitem'] = "f4iL3D +O UpD4+3 PR0PHIl3 1teM";
$lang['startpageupdated'] = "s+4rt pa9E uPD4teD. %s";
$lang['cssfileuploaded'] = "c5S 5+YL3 SHe3t upL04dEd. %s";
$lang['viewupdatedstartpage'] = "v1eW UpDAT3D \$+4RT p49E";
$lang['editstartpage'] = "ed1+ \$+4rt p@93";
$lang['nouserspecified'] = "n0 us3r \$PECIf1eD.";
$lang['manageuser'] = "m@NaG3 usER";
$lang['manageusers'] = "m4n4g3 USerS";
$lang['userstatusforforum'] = "us3R \$T4tU\$ PH0R %s";
$lang['userdetails'] = "u53r de+4il\$";
$lang['edituserdetails'] = "eD1T U5er D3TaiLS";
$lang['warning_caps'] = "w4rN1n9";
$lang['userdeleteallpostswarning'] = "aRe j00 \$ur3 J00 w@nT T0 D3L3T3 4ll Of TEh S3L3Ct3d U5Er's pO5+5? 0Nc3 +3H P0\$+5 4rE Del3tED +hEY C@nnOt b3 R3TrIEvED 4nd W1lL B3 Lo5+ Ph0r3vEr.";
$lang['folderaccess'] = "fOLD3r acCEs5";
$lang['possiblealiases'] = "p0\$SI8l3 @li@s35";
$lang['ipaddressmatches'] = "ip 4DDrE\$5 Ma+CHE\$";
$lang['emailaddressmatches'] = "eM4IL AdDrE55 M4+CH35";
$lang['passwdmatches'] = "pa5SW0Rd m4+cHES";
$lang['httpreferermatches'] = "hT+p r3f3rER M@TcheS";
$lang['userhistory'] = "uSer H15+ORY";
$lang['nohistory'] = "n0 h1sTORy ReC0RD5 S4VeD";
$lang['userhistorychanges'] = "ch@NG3\$";
$lang['clearuserhistory'] = "cL34r u5er His+ORy";
$lang['changedlogonfromto'] = "ch@N93d LogoN pHr0M %s t0 %s";
$lang['changednicknamefromto'] = "cH4ng3D N1CKn4mE PHr0M %s +o %s";
$lang['changedemailfromto'] = "cH4N9ED 3MAil froM %s +O %s";
$lang['successfullycleareduserhistory'] = "suCC3s\$pHUlly CLe@RED Us3R h1s+ORY";
$lang['failedtoclearuserhistory'] = "f41LED +O cLE4R u53R h1\$+Ory";
$lang['successfullychangedpassword'] = "sUCcESSpHUllY CH4n93D PasSWOrD";
$lang['failedtochangepasswd'] = "f@ileD T0 cH4n93 P@s\$w0rd";
$lang['approveuser'] = "aPpROvE u53R";
$lang['viewuserhistory'] = "vIEW US3R H1\$+oRy";
$lang['viewuseraliases'] = "v13W usEr 4lI@sE\$";
$lang['searchreturnednoresults'] = "s34rCH r3TURnED N0 r35Ul+\$";
$lang['deleteposts'] = "d3l3tE Po\$+\$";
$lang['deleteuser'] = "delE+e U53r";
$lang['alsodeleteusercontent'] = "al\$0 D3l3+E 4ll Oph +hE COn+ENt cR34+3D 8Y +h1S us3R";
$lang['userdeletewarning'] = "are J00 SUrE J00 W@n+ +O DEL3T3 +3h SeL3CTeD U53r 4cC0UN+? 0nce +h3 AcCOuNT h4s b3en D3l3t3D 1t CAnn0t 83 R3TR1EVeD aND WiLl 8E L0ST F0ReV3R.";
$lang['usersuccessfullydeleted'] = "u\$ER sUcc35\$phUlLy d3lE+Ed";
$lang['failedtodeleteuser'] = "f41l3d T0 d3l3tE u\$3r";
$lang['forgottenpassworddesc'] = "iF +his u\$eR H@s FOrGOt+3N +HE1r PAssWORd j00 c@N r3s3T 1+ ph0R +H3M H3R3.";
$lang['failedtoupdateuserstatus'] = "f@Il3d +o UpD@+e Us3R 5+4+US";
$lang['failedtoupdateglobaluserpermissions'] = "f4ILEd +o UPd@Te Glo8@L U5Er P3rmI5SIOns";
$lang['failedtoupdatefolderaccesssettings'] = "fAiLEd +O uPd4+E pHOlDEr @cCE\$s se+T1nGS";
$lang['manageusersexp'] = "th1\$ li5+ Sh0w\$ 4 \$3LEC+10N OpH uS3R5 Who h4ve L09g3d 0n +0 y0uR fORUM, sor+3d bY %s. tO 4lt3r 4 US3R'\$ P3rm1s510Ns Cl1ck +HE1r N@M3.";
$lang['userfilter'] = "u\$eR filT3R";
$lang['withselected'] = "wi+h \$3lECt3D";
$lang['onlineusers'] = "oNL1NE us3Rs";
$lang['offlineusers'] = "oFfl1nE User\$";
$lang['usersawaitingapproval'] = "user\$ @W@1TInG 4ppr0V4L";
$lang['bannedusers'] = "b@nN3D U\$ers";
$lang['lastlogon'] = "l4sT Lo9on";
$lang['sessionreferer'] = "s3SsI0N RepH3ReR";
$lang['signupreferer'] = "sI9N-uP Reph3rer:";
$lang['nouseraccountsmatchingfilter'] = "n0 U\$3R acCOuNt5 M4tching ph1lT3r";
$lang['searchforusernotinlist'] = "se@RCH fOr 4 uSEr n0t 1n lIS+";
$lang['adminaccesslog'] = "aDMIN @Cc3\$\$ lo9";
$lang['adminlogexp'] = "tH1s lIst shOws t3h L4sT @C+Ion\$ S4nctioN3D BY U\$3RS w1+H @DM1N pRiVIlEGe\$.";
$lang['datetime'] = "d4t3/TimE";
$lang['unknownuser'] = "uNkNOwn UsER";
$lang['unknownuseraccount'] = "unkN0wN uS3r 4CcoUnt";
$lang['unknownfolder'] = "uNkn0WN f0lDEr";
$lang['ip'] = "ip";
$lang['lastipaddress'] = "l@5+ IP 4ddrE\$\$";
$lang['logged'] = "l0gg3d";
$lang['notlogged'] = "n0+ L09g3d";
$lang['addwordfilter'] = "aDD W0rD filT3R";
$lang['addnewwordfilter'] = "aDD NeW WOrD Fil+er";
$lang['wordfilterupdated'] = "w0Rd Ph1l+3R UpD4TEd";
$lang['wordfilterisfull'] = "j00 C@Nnot aDd 4nY mOr3 wOrD fIL+3RS. R3m0v3 SOM3 uNUs3D ON3S 0r 3dIt +3H eX1S+In9 0n3S fIR5+.";
$lang['filtername'] = "fIlTer N4M3";
$lang['filtertype'] = "fil+3r +yP3";
$lang['filterenabled'] = "f1l+ER EN@bLeD";
$lang['editwordfilter'] = "ediT WorD fILT3R";
$lang['nowordfilterentriesfound'] = "n0 3xISTINg WorD ph1l+3R En+R13s foUnD. T0 4DD a Ph1l+Er cl1Ck +He '4Dd NeW' BUt+oN B3l0w.";
$lang['mustspecifyfiltername'] = "j00 mU\$t SPeC1PHY a ph1L+er naMe";
$lang['mustspecifymatchedtext'] = "j00 MU5+ SpECiPhy M4+Ch3d T3XT";
$lang['mustspecifyfilteroption'] = "j00 Mus+ Sp3c1FY 4 PH1LT3R opTioN";
$lang['mustspecifyfilterid'] = "j00 Mus+ sp3CIphY @ fiL+3r ID";
$lang['invalidfilterid'] = "iNv4l1D fiLt3r Id";
$lang['failedtoupdatewordfilter'] = "f@iLED +0 UpDa+3 w0RD PHIlt3r. CHeCK +H4t th3 F1LTeR St1ll 3xISt\$.";
$lang['allow'] = "allow";
$lang['block'] = "bLoCK";
$lang['normalthreadsonly'] = "nOrM4L ThrE@D5 0Nly";
$lang['pollthreadsonly'] = "polL +HR34dS OnlY";
$lang['both'] = "b0+h +hr34d +YpE\$";
$lang['existingpermissions'] = "exiS+1N9 pErmISS1ons";
$lang['nousershavebeengrantedpermission'] = "nO 3XIST1N9 U53r\$ PERmiSS10nS pH0UnD. T0 GR@n+ p3Rmis510n +O us3rS \$EaRcH pH0R +hEm 83l0W.";
$lang['successfullyaddedpermissionsforselectedusers'] = "sUCcES\$PHulLy 4Dd3d PeRM1\$\$10NS f0R 53l3Ct3D u53R\$";
$lang['successfullyremovedpermissionsfromselectedusers'] = "suCc3ssFulLY r3m0ved p3RM1sS1ONS Phr0m \$EL3C+ED U\$3r\$";
$lang['failedtoaddpermissionsforuser'] = "f@iL3d +0 4dD PErmI\$\$10ns PHOr US3R '%s'";
$lang['failedtoremovepermissionsfromuser'] = "f4iLeD +o R3m0VE p3rm1sSi0n\$ FR0m US3R '%s'";
$lang['searchforuser'] = "s34rCH PhoR u53r";
$lang['browsernegotiation'] = "bR0WS3R n3GO+1a+3D";
$lang['textfield'] = "teXt Ph1ELd";
$lang['multilinetextfield'] = "mUl+1-L1N3 +3xT ph13ld";
$lang['radiobuttons'] = "raD1o 8u++On\$";
$lang['dropdownlist'] = "dR0p DOwN l1ST";
$lang['clickablehyperlink'] = "click48lE hyPerL1nK";
$lang['threadcount'] = "tHREaD C0UN+";
$lang['clicktoeditfolder'] = "click +0 3D1T FoLDeR";
$lang['fieldtypeexample1'] = "t0 crE@+E R4D1o 8UT+0N\$ 0r 4 dr0P dOWN lIsT j00 NEed TO eNT3R e4CH 1nDIviDu@L v4lU3 0N A sEp@rA+3 L1N3 iN +3h op+10N\$ PH1ELD.";
$lang['fieldtypeexample2'] = "t0 CRE@t3 CL1Ckabl3 lINKs ENT3r +h3 Url 1n +HE OP+10N5 fiElD @nd UsE <i>%1\$s</i> wH3RE +He EN+RY From th3 Us3R'\$ PROPhIlE sHouLd AppE@R. 3X4MPlE\$: <p>mysP4Ce: <i>hT+p://WWW.MYSPacE.cOM/%1\$S</i><br />xB0X L1V3: <i>ht+P://PR0FIl3.mYg4mERc4rD.N3T/%1\$S</i></p>";
$lang['editedwordfilter'] = "ed1TeD WOrD ph1l+er";
$lang['editedforumsettings'] = "ed1+3D ph0RUm \$et+1N9s";
$lang['successfullyendedusersessionsforselectedusers'] = "suCCe5\$pHUlLY EnDEd S3\$\$10N\$ PhoR SeL3CtED U53rs";
$lang['failedtoendsessionforuser'] = "fAil3d TO 3ND S3sS10n f0r U\$3r %s";
$lang['successfullyapproveduser'] = "suCcES\$FuLlY 4ppR0V3D Us3r";
$lang['successfullyapprovedselectedusers'] = "suCcE\$\$fUllY 4PPR0VEd \$3LeC+3d U\$3R\$";
$lang['matchedtext'] = "m4tCHeD +Ex+";
$lang['replacementtext'] = "rEPLAcEM3NT TeXT";
$lang['preg'] = "pREg";
$lang['wholeword'] = "wh0lE w0RD";
$lang['word_filter_help_1'] = "<b>all</b> m@TcHE\$ 4G4INST +hE wholE tEXT \$o FIlt3r1n9 MOM To MUM w1Ll alSO Ch4N93 m0m3N+ t0 MUMen+.";
$lang['word_filter_help_2'] = "<b>wh0L3 WORd</b> m4+cHE\$ 4941n\$+ WHoL3 WorD5 OnlY \$o PH1LtER1n9 m0m +o mUm W1LL nOT CH@nG3 mOm3nT t0 MumEnT.";
$lang['word_filter_help_3'] = "<b>preg</b> @LL0w5 J00 +o USe PeRL r39uL4r 3XPrE\$\$IONs +o M4+cH tEXt.";
$lang['nameanddesc'] = "n@mE 4Nd D3Scr1pTioN";
$lang['movethreads'] = "moVE +HR3@Ds";
$lang['movethreadstofolder'] = "m0vE ThRE@DS +0 PhOLD3r";
$lang['failedtomovethreads'] = "f41LeD t0 MOV3 +hr3@Ds +O 5PeCIpHI3D pholDeR";
$lang['resetuserpermissions'] = "rES3t u5er PerMiss1oNS";
$lang['failedtoresetuserpermissions'] = "f4iLeD +o R3se+ USeR PeRMI\$\$iON5";
$lang['allowfoldertocontain'] = "alL0w pHOLdER +0 C0N+@1N";
$lang['addnewfolder'] = "add NEw Ph0lD3r";
$lang['mustenterfoldername'] = "j00 MUS+ 3NT3R @ fold3r n4ME";
$lang['nofolderidspecified'] = "n0 phoLD3R 1D \$PeC1PH13D";
$lang['invalidfolderid'] = "iNv4liD FoldEr 1D. CH3CK tH@T a PH0Ld3r witH thIS 1d exISt\$!";
$lang['folderdisplayorderthreadsbyfolderview'] = "folDeR ORder 0nly 4pPL13\$ WH3N u\$3R h4s EN@8L3d '\$or+ tHrE@D L1\$+ 8Y pHoLderS' iN foRum Op+10n\$.";
$lang['successfullyaddednewfolder'] = "sUCCe\$\$pHULlY 4Dd3d n3w PhoLDER";
$lang['successfullyremovedselectedfolders'] = "suCc3S5pHULlY r3m0vEd \$3leC+3D PH0LdERs";
$lang['successfullyeditedfolder'] = "sucCeS\$PhUllY ED1+3D pHolDER";
$lang['failedtocreatenewfolder'] = "f41L3D +o CR34tE nEW FOLd3R";
$lang['failedtodeletefolder'] = "f4ILeD +o DEL3tE f0LDeR.";
$lang['failedtoupdatefolder'] = "f41L3D +0 UpD4Te FOLdER";
$lang['cannotdeletefolderwiththreads'] = "c4NN0+ d3l3+E PH0LdERs +h4T \$+1LL C0n+41n tHrE4D\$.";
$lang['forumisnotsettorestrictedmode'] = "f0RUm IS noT \$3T +o R35rICt3D M0De. do j00 WANt +o En4bLE I+ nOW?";
$lang['forumisnotsettopasswordprotectedmode'] = "fOrUM 1\$ n0+ \$E+ t0 P4\$sW0rD pRotEc+3d m0D3. d0 j00 w4nT t0 3n4BLE 1+ NOW?";
$lang['groups'] = "gr0ups";
$lang['nousergroups'] = "n0 u53r 9roUps H@v3 83eN sE+ Up. T0 @dd 4 GR0uP clICk TH3 '4Dd neW' BUTt0N b3l0W.";
$lang['suppliedgidisnotausergroup'] = "sUPpLIeD 9id 1\$ N0t a u\$3r GR0UP";
$lang['manageusergroups'] = "mAN49e U53r 9R0upS";
$lang['groupstatus'] = "grOup \$+4tu\$";
$lang['addusergroup'] = "aDd U\$3R 9rOup";
$lang['addemptygroup'] = "adD EmpTy 9R0UP";
$lang['adduserstogroup'] = "adD us3rs +o GR0up";
$lang['addremoveusers'] = "adD/R3M0V3 US3R\$";
$lang['nousersingroup'] = "th3R3 4r3 No U\$eRs 1n THi5 grOUP. @dD u\$3R\$ T0 Thi\$ GRoUP BY s3@RcH1NG ph0r +hEm 83lOW.";
$lang['groupaddedaddnewuser'] = "succES\$fUlly 4DDeD gR0UP. adD US3R\$ T0 THi5 9r0up bY 5e4rCHinG phOR tHEm 8EL0w.";
$lang['nousersingroupaddusers'] = "th3rE @R3 N0 u\$3rS in th1s 9r0UP. +o 4DD U\$3r\$ cLICk thE '4dd/R3m0ve UsERS' 8U++0N B3l0w.";
$lang['useringroups'] = "th1S us3R is 4 M3M8Er 0F TH3 fOLLOw1nG 9r0upS";
$lang['usernotinanygroups'] = "tH1\$ U5Er 15 Not in @nY u\$er 9rOUps";
$lang['usergroupwarning'] = "no+E: Th15 u\$3R m4y B3 INhER1+1N9 Addition@L pERM1SSI0N5 FR0M 4NY uSER GR0Up\$ l1\$teD b3l0W.";
$lang['successfullyaddedgroup'] = "sUcC3ssphULly 4DdED GR0up";
$lang['successfullyeditedgroup'] = "sUCCEs\$FULlY 3D1TeD 9r0up";
$lang['successfullydeletedselectedgroups'] = "succEs\$phUlLY D3lET3D S3LeCT3D 9roUp5";
$lang['failedtodeletegroupname'] = "f41LEd +0 DeL3t3 GROUP %s";
$lang['usercanaccessforumtools'] = "u\$Er C@N ACce\$\$ forUm +o0l5 4nD c@n cre4+e, D3LET3 4ND Ed1+ foRUm5";
$lang['usercanmodallfoldersonallforums'] = "u53R c4n M0D3r4TE <b>all phOlDEr5</b> 0n <b>all f0rUMS</b>";
$lang['usercanmodlinkssectiononallforums'] = "us3r c4n MOd3r@+e L1NK5 5Ec+10n On <b>alL PhORuMS</b>";
$lang['emailconfirmationrequired'] = "em4IL C0NFIrm@t1ON r3QU1reD";
$lang['userisbannedfromallforums'] = "uS3r is bANNeD FR0M <b>aLL ph0ruMS</b>";
$lang['cancelemailconfirmation'] = "c4NcEL 3m4IL C0NFIrMA+10N 4ND @Llow Us3r +o \$+4rt p0S+1N9";
$lang['resendconfirmationemail'] = "rE\$ENd C0NfiRm4t1ON 3M41l T0 UsER";
$lang['failedtosresendemailconfirmation'] = "f41lEd +0 r3\$3nD eM41l CONfiRm@TioN To U5ER.";
$lang['donothing'] = "do nOTHin9";
$lang['usercanaccessadmintools'] = "u\$eR Has 4Cc35s +0 FoRUM @Dm1N T0OL\$";
$lang['usercanaccessadmintoolsonallforums'] = "uS3R h4\$ 4CcE\$S to 4dmIN T00LS <b>on 4LL pHorUM5</b>";
$lang['usercanmoderateallfolders'] = "u\$3r c4n MOd3r@tE 4LL f0lDERS";
$lang['usercanmoderatelinkssection'] = "u5eR c@N Mod3ra+3 l1nks s3C+1oN";
$lang['userisbanned'] = "u53R i5 8ANNeD";
$lang['useriswormed'] = "u53r IS WoRM3D";
$lang['userispilloried'] = "u53R IS pIllor13D";
$lang['usercanignoreadmin'] = "u\$eR C@n i9N0RE 4dmIN1\$+R4T0R5";
$lang['groupcanaccessadmintools'] = "gRoUP C@N 4cceSs 4Dm1n T00Ls";
$lang['groupcanmoderateallfolders'] = "gROUP C4n m0dEr4t3 4ll F0lDERS";
$lang['groupcanmoderatelinkssection'] = "gROuP C4n M0D3r4tE lInk\$ 53CT1ON5";
$lang['groupisbanned'] = "gr0UP 15 84nnED";
$lang['groupiswormed'] = "gr0Up I\$ W0rM3D";
$lang['readposts'] = "r34D po5+5";
$lang['replytothreads'] = "rEPLy tO tHR3@D\$";
$lang['createnewthreads'] = "cR34+E NEW +hR3@d\$";
$lang['editposts'] = "edI+ P0sT5";
$lang['deleteposts'] = "dEL3T3 p05+5";
$lang['postssuccessfullydeleted'] = "po5+\$ suCc3\$\$phuLLY DEl3t3d";
$lang['failedtodeleteusersposts'] = "f41Led T0 dEl3t3 us3r'S P0sT\$";
$lang['uploadattachments'] = "upl0@d A+T4ChMEnTs";
$lang['moderatefolder'] = "modEr@Te PhoLdER";
$lang['postinhtml'] = "p0S+ 1n HTMl";
$lang['postasignature'] = "p0S+ 4 \$1gN4TUre";
$lang['editforumlinks'] = "eD1t pH0RUM lInks";
$lang['linksaddedhereappearindropdown'] = "lInks 4ddEd H3Re 4pP34r in @ DR0P d0wN 1n ThE T0P riGh+ of +h3 FR4Me 5ET.";
$lang['linksaddedhereappearindropdownaddnew'] = "l1NKS ADd3d HeRE 4pp34r in @ DRop d0wn 1n +h3 +OP r19h+ oF +H3 Fr4mE 53T. +o @dd a LiNk clICk TeH '4dD n3w' bUt+ON 8EloW.";
$lang['failedtoremoveforumlink'] = "f@1leD t0 r3moVe Ph0RUm L1Nk '%s'";
$lang['failedtoaddnewforumlink'] = "faiL3d +o 4DD n3w ph0RUm l1nK '%s'";
$lang['failedtoupdateforumlink'] = "f@1Led t0 UpDA+3 ForUm LinK '%s'";
$lang['notoplevellinktitlespecified'] = "n0 T0P LeV3L L1NK +ITL3 5pEC1PH13d";
$lang['youmustenteralinktitle'] = "j00 Mu\$t EN+3R @ L1nK +1tL3";
$lang['alllinkurismuststartwithaschema'] = "alL lINk urIS mU5+ 5T4R+ wI+H A 5ChEm@ (1.3. HT+P://, F+p://, 1rc://)";
$lang['editlink'] = "eDiT L1NK";
$lang['addnewforumlink'] = "add N3W FoRUm L1NK";
$lang['forumlinktitle'] = "fOrUM l1nk +1+Le";
$lang['forumlinklocation'] = "f0Rum l1nk l0c@Tion";
$lang['successfullyaddednewforumlink'] = "sucCES\$FulLY 4dD3D n3W fOruM L1NK";
$lang['successfullyeditedforumlink'] = "sUCC3\$sfuLLY eD1+eD pH0RUM l1NK";
$lang['invalidlinkidorlinknotfound'] = "iNv4lId L1NK iD OR LInk N0t f0uND";
$lang['successfullyremovedselectedforumlinks'] = "suCCesspHULLY removED \$3lEct3D L1NK5";
$lang['toplinkcaption'] = "toP LinK CAP+ion";
$lang['allowguestaccess'] = "aLl0w GUes+ 4cc3sS";
$lang['searchenginespidering'] = "s34rcH 3n9iN3 \$PID3RING";
$lang['allowsearchenginespidering'] = "aLlOw \$E4RCH 3ngIne \$piDeRIn9";
$lang['sitemapenabled'] = "eN@8le \$it3m4p";
$lang['sitemapupdatefrequency'] = "sI+3m@p UpD@+e PhrEQUENcy";
$lang['sitemappathnotwritable'] = "s1+emAP D1REC+ORy mUS+ B3 wr1+@8Le 8Y THE w38 \$3RVeR / PhP pr0c3Ss!";
$lang['newuserregistrations'] = "new u\$3R R3GISTr4tiOnS";
$lang['preventduplicateemailaddresses'] = "pREV3Nt duPLica+e 3m41l 4DDRESs3\$";
$lang['allownewuserregistrations'] = "aLL0w NeW uSeR rEgI5tRA+i0n5";
$lang['requireemailconfirmation'] = "r3qUIr3 Em@1L Conf1rm4tIOn";
$lang['usetextcaptcha'] = "use T3x+-c@pTCH@";
$lang['textcaptchafonterror'] = "tex+-c4p+Ch@ h@5 b3eN D1s@bLEd 4U+0m4tIc4llY B3C@uS3 tHer3 4rE N0 trU3 TyPe PHON+s 4vaIL4BLE F0r 1+ T0 Use. pLe@S3 Upl04d \$0Me TrUE tYpe FOn+S T0 <b>teX+_C4PTcHA/pHON+5</b> 0N YOuR \$3RV3r.";
$lang['textcaptchadirerror'] = "tEX+-C4p+cH@ ha\$ b3EN D154Bl3d 8eC4UsE +H3 +3X+_C@pTChA dIReC+ORy 4ND 5U8-d1REcT0rie\$ 4Re N0t wR1t4BLE By +hE wEb \$ERVER / PhP prOc3s\$.";
$lang['textcaptchagderror'] = "tExT-c4pTcHA h4s 8Een dI54BLED B3C4u\$3 YOuR \$3RV3R's php \$3+UP d0E5 N0+ PrOVId3 5UPpoR+ FOr Gd 1M4GE M4N1pUl4t1on @Nd / OR +tPh FOn+ SuPP0r+. 8o+h 4RE R3QU1r3d foR tExT-c4p+CH@ sUpPOR+.";
$lang['newuserpreferences'] = "n3w U53r pr3PHeREnC3S";
$lang['sendemailnotificationonreply'] = "eM41l NOTiF1C4t1oN 0N R3pLy +o Us3R";
$lang['sendemailnotificationonpm'] = "eM4IL n0+1fIc@TiON oN pm +0 Us3r";
$lang['showpopuponnewpm'] = "show PopUp WHeN ReCeIV1n9 n3w pM";
$lang['setautomatichighinterestonpost'] = "s3+ 4uT0ma+1C HI9h 1N+eR35+ 0N posT";
$lang['postingstats'] = "poStiN9 \$+4+S";
$lang['postingstatsforperiod'] = "poStING \$tA+S pHor P3R10D %s +O %s";
$lang['nopostdatarecordedforthisperiod'] = "n0 POSt D4+4 REc0rd3d F0R TH1S PeR10d.";
$lang['totalposts'] = "t0+@l po5T5";
$lang['totalpostsforthisperiod'] = "t0+Al POST\$ PH0R +h1\$ PerI0D";
$lang['mustchooseastartday'] = "mU5+ CHo0sE @ \$+4rt DAy";
$lang['mustchooseastartmonth'] = "mU5t ch0o5e 4 STARt M0n+H";
$lang['mustchooseastartyear'] = "mU5+ ch0o5E @ 5+4r+ yE4r";
$lang['mustchooseaendday'] = "mu5+ CHoo\$3 A 3ND D4Y";
$lang['mustchooseaendmonth'] = "mU\$+ ch00S3 @ eNd M0nth";
$lang['mustchooseaendyear'] = "mu5+ Ch0o53 @ eND yEAR";
$lang['startperiodisaheadofendperiod'] = "staR+ p3r1oD 1\$ 4h3aD 0F 3ND PEri0D";
$lang['bancontrols'] = "b4n c0n+RolS";
$lang['addban'] = "aDD B4n";
$lang['checkban'] = "cheCk 8AN";
$lang['editban'] = "eD1+ 8AN";
$lang['bantype'] = "b@N TYP3";
$lang['bandata'] = "b@n d4t@";
$lang['banexpires'] = "b4N 3xP1R35";
$lang['bancomment'] = "comM3nT";
$lang['optionalbrackets'] = "(0PT10N@l)";
$lang['ipban'] = "iP 84N";
$lang['logonban'] = "l0G0n 84n";
$lang['nicknameban'] = "niCKN4Me 8@N";
$lang['emailban'] = "eM4il b@N";
$lang['refererban'] = "r3FErER 8@n";
$lang['invalidbanid'] = "inv@LiD bAN 1D";
$lang['affectsessionwarnadd'] = "th1\$ bAN MAy 4pHPH3Ct teH folLowING 4ctIvE us3R 53ss10Ns";
$lang['noaffectsessionwarn'] = "thiS 8@n AphPHECtS n0 4c+1V3 \$35S10nS";
$lang['mustspecifybantype'] = "j00 MuS+ 5PeC1PHy A BAn +ypE";
$lang['mustspecifybandata'] = "j00 MusT SPec1FY s0M3 8aN dAT4";
$lang['expirydateisinvalid'] = "eXpIRy D4+3 I5 1NV4LID";
$lang['successfullyremovedselectedbans'] = "suCcES\$FULlY R3M0vED \$3l3C+3D 8@ns";
$lang['failedtoaddnewban'] = "f@1L3D +O 4Dd N3W 8@N";
$lang['failedtoremovebans'] = "f41l3D T0 r3MoVe 5oM3 0R @lL 0f tH3 s3LeCT3D B@n5";
$lang['duplicatebandataentered'] = "dupLIc4+E b4N da+@ EnTER3D. PL34\$3 cHECK y0uR w1LdC4rD\$ tO 53E 1pH tHeY 4Lr34Dy M4TcH +eH d@+@ EnT3r3D";
$lang['successfullyaddedban'] = "sUccEssphuLLY 4Dd3D 8@N";
$lang['successfullyupdatedban'] = "sUCc3sSFully uPD4T3D BAN";
$lang['noexistingbandata'] = "tH3rE iS no 3XIstIng 8@N d@T@. +O aDd @ 8@N cLIck t3h '4dD N3W' 8U++oN 8elow.";
$lang['youcanusethepercentwildcard'] = "j00 c4n u\$3 th3 P3RCeNT (%) WilDc4RD \$yM8OL in @Ny oPh YOUr 84n lisTs +o 0B+4IN pARt1@l M4Tch3s, I.E. '192.168.0.%' wOUlD 84N alL ip @dDRes53S in THe R4NG3 192.168.0.1 THroUGh 192.168.0.254";
$lang['selecteddateisinthepast'] = "s3LECT3D D4+E 1\$ 1n +3h p4\$T";
$lang['cannotusewildcardonown'] = "j00 cANnoT @Dd % 4S 4 wiLdC4Rd M@tch 0n It5 0wn!";
$lang['requirepostapproval'] = "reQU1r3 P05t 4pPr0v@L";
$lang['adminforumtoolsusercounterror'] = "therE Mu\$t bE 4+ l34\$+ 1 USER WItH 4Dmin t00lS aND pH0rUM +00ls @ccE\$s 0N alL PHoRUms!";
$lang['postcount'] = "pO5+ cOUN+";
$lang['changepostcount'] = "ch4NgE P0S+ cOUnt";
$lang['resetpostcount'] = "r3s3t POS+ cOUN+";
$lang['successfullyresetpostcount'] = "sUCcEssfUllY R3s3t poST c0uN+";
$lang['successfullyupdatedpostcount'] = "suCces\$phULly UpD@tEd po5t c0uN+";
$lang['failedtoresetuserpostcount'] = "f4ilEd +0 r3SE+ POST C0UN+";
$lang['failedtochangeuserpostcount'] = "f@1l3D +o cH4N9E US3R P0sT C0UNT";
$lang['postapprovalqueue'] = "p0\$+ 4pPR0V@l qUEuE";
$lang['nopostsawaitingapproval'] = "n0 Po5+\$ 4RE 4w41tinG 4PPROVal";
$lang['failedtoapproveuser'] = "f4iL3D t0 4ppr0v3 U\$3R %s";
$lang['endsession'] = "eND \$E\$\$1On (KIcK)";
$lang['visitorlog'] = "vI\$I+OR l09";
$lang['novisitorslogged'] = "n0 v1s1T0rs lO99ED";
$lang['addselectedusers'] = "adD \$EL3C+eD uS3RS";
$lang['removeselectedusers'] = "r3M0V3 53lEc+3D US3rS";
$lang['addnew'] = "adD n3W";
$lang['deleteselected'] = "d3L3tE sELeCT3D";
$lang['forumrulesmessage'] = "<p><b>fORUM RUlE\$</b></p><p>\nR391S+R4T10n t0 %1\$\$ 1\$ phrE3! WE DO IN5ist +hA+ j00 @BID3 8Y +hE rULes 4nd P0L1CIe\$ dE+4iL3D 8ELow. 1PH J00 @9R3E TO +HE T3rMS, pLe@5E cH3Ck Th3 'i Agr33' cHEcK8OX anD PR3\$5 t3H 'r3G1\$+Er' bU++0n 8eLOw. IF J00 W0ULd L1KE t0 C@nC3L +3h r3gIs+r@+1on, CliCK %2\$s t0 R3+URN to +3h phORUM\$ 1nDEX.</p><p>\n@lTHOU9h teh 4dMiN1stR@+OR5 @ND MOd3r4TOr\$ oF %1\$5 w1lL @tTEMPT +O ke3p ALL ObJ3c+IOn4BL3 M3s\$@9e\$ oPHF +h1S PHoruM, I+ IS IMp0ssI8l3 ph0R uS t0 rEVIew 4Ll MESS@Ges. 4Ll Me5\$4G3s EXPreS\$ +3H v13Ws OF +HE aUTH0r, 4nd n3i+HER +hE OWN3R5 of %1\$S, N0R PR0jEct 8eEH1ve pH0rUM @ND 1T'\$ @PHPH1L14T3s W1ll 83 H3lD r35p0n\$IbL3 f0r +H3 CONT3NT 0Ph 4Ny ME5S@9e.</p><p>\nbY @GRe3IN9 To thE53 rUl3\$, j00 WARR4nT TH@T J00 WILl NoT pOST ANY m3Ss@93S +H4t 4rE Obscen3, VUL94R, SexU4llY-0r13NT4+ED, hA+3ful, +HRe4T3nIN9, Or 0+HerWIS3 VioLa+IVe 0f AnY L@ws.</p><p>tH3 0wnERS OPH %1\$S R3sERVE tH3 r19ht +O R3MoVE, Ed1+, MoVE or Cl0S3 4Ny +HR34D f0R @NY R3@S0n.</p>";
$lang['cancellinktext'] = "hErE";
$lang['failedtoupdateforumsettings'] = "f@il3d +O UPd4TE f0ruM s3t+INg5. PlEAS3 +rY 4g41n Lat3R.";
$lang['moreadminoptions'] = "moRE @DMIn oP+1ON\$";

// Admin Log data (admin_viewlog.php) --------------------------------------------

$lang['changedstatusforuser'] = "cH4NG3D uSER \$+@Tu\$ For '%s'";
$lang['changedpasswordforuser'] = "cHaN9ED P4s\$W0Rd PHOr '%s'";
$lang['changedforumaccess'] = "cH4n9ED FOrUM @cCE\$\$ pERm1ssIon\$ PHor '%s'";
$lang['deletedallusersposts'] = "delE+3D @ll posts foR '%s'";

$lang['createdusergroup'] = "cr34tED USeR 9ROup '%s'";
$lang['deletedusergroup'] = "d3L3t3D UsER groUp '%s'";
$lang['updatedusergroup'] = "upD4+3D uS3R 9ROup '%s'";
$lang['addedusertogroup'] = "aDDED Us3r '%s' +0 9ROup '%s'";
$lang['removeduserfromgroup'] = "rEMOVe UsER '%s' FR0M 9R0UP '%s'";

$lang['addedipaddresstobanlist'] = "aDDeD iP '%s' t0 8aN LisT";
$lang['removedipaddressfrombanlist'] = "rem0veD 1P '%s' phROM B@N lIST";

$lang['addedlogontobanlist'] = "aDDEd l0gON '%s' to 8AN liST";
$lang['removedlogonfrombanlist'] = "reM0VeD lOGOn '%s' phR0m BAn lI\$t";

$lang['addednicknametobanlist'] = "aDDeD NICKN4M3 '%s' +0 8@N L1\$+";
$lang['removednicknamefrombanlist'] = "rEmOV3D n1cKN4m3 '%s' fROm 84n LI\$+";

$lang['addedemailtobanlist'] = "adDEd 3m4IL @DDr3sS '%s' +o 84n lI5+";
$lang['removedemailfrombanlist'] = "remOV3D eM@iL @DDr3sS '%s' FroM ban L1\$+";

$lang['addedreferertobanlist'] = "add3D R3Fer3R '%s' t0 84n LISt";
$lang['removedrefererfrombanlist'] = "r3M0v3d R3fEr3r '%s' PHr0m 84n LiSt";

$lang['editedfolder'] = "ed1+3d pHoLDER '%s'";
$lang['movedallthreadsfromto'] = "mOv3d @Ll +hr34dS Fr0m '%s' +O '%s'";
$lang['creatednewfolder'] = "crE4+3D n3W foLdER '%s'";
$lang['deletedfolder'] = "d3LETeD fOLDER '%s'";

$lang['changedprofilesectiontitle'] = "cH4n93D pR0FILE SeC+ioN +1tL3 FR0M '%s' T0 '%s'";
$lang['addednewprofilesection'] = "aDd3D N3w PROpH1lE \$ectIOn '%s'";
$lang['deletedprofilesection'] = "delE+3D PR0FILe SeC+10N '%s'";

$lang['addednewprofileitem'] = "aDDEd N3w PR0FilE 1+3m '%s' +0 s3c+10n '%s'";
$lang['changedprofileitem'] = "cH4nG3D prOf1Le 1+3M '%s'";
$lang['deletedprofileitem'] = "d3lETED PROpHIlE itEm '%s'";

$lang['editedstartpage'] = "edI+ed 5t4rt P49E";
$lang['savednewstyle'] = "s4v3D New \$+yL3 '%s'";

$lang['movedthread'] = "m0VEd tHrEad '%s' PHr0M '%s' T0 '%s'";
$lang['closedthread'] = "cl053D +HRE4d '%s'";
$lang['openedthread'] = "op3n3d +Hr3@D '%s'";
$lang['renamedthread'] = "r3nAM3d THrE@d '%s' +0 '%s'";

$lang['deletedthread'] = "d3l3+3D tHRe@D '%s'";
$lang['undeletedthread'] = "uND3lEtED +Hr3@D '%s'";

$lang['lockedthreadtitlefolder'] = "lock3D +hrEaD 0P+10N\$ 0n '%s'";
$lang['unlockedthreadtitlefolder'] = "unl0CK3D ThR3aD 0p+1ON\$ 0N '%s'";

$lang['deletedpostsfrominthread'] = "d3lETed PO5+S fROM '%s' 1N ThREaD '%s'";
$lang['deletedattachmentfrompost'] = "d3l3t3D @t+@cHMeNT '%s' PHr0M pO5t '%s'";

$lang['editedforumlinks'] = "eDI+3D PHORUm L1NKS";
$lang['editedforumlink'] = "eD1+3D PHorUM LiNK: '%s'";

$lang['addedforumlink'] = "aDDED phORUm L1NK: '%s'";
$lang['deletedforumlink'] = "d3lE+3D PH0Rum link: '%s'";
$lang['changedtoplinkcaption'] = "cH@N9Ed TOP L1nK C4pTIOn PHR0M '%s' +0 '%s'";

$lang['deletedpost'] = "d3leTEd P0st '%s'";
$lang['editedpost'] = "eDi+Ed pOS+ '%s'";

$lang['madethreadsticky'] = "m@D3 THRe@d '%s' s+1ckY";
$lang['madethreadnonsticky'] = "m@DE THr34D '%s' NoN-\$T1CKY";

$lang['endedsessionforuser'] = "eNd3d \$35SIon PH0R usEr '%s'";

$lang['approvedpost'] = "aPpROved PO5+ '%s'";

$lang['editedwordfilter'] = "eD1TEd WOrD phIL+ER";

$lang['addedrssfeed'] = "aDDeD Rss phE3D '%s'";
$lang['editedrssfeed'] = "edItEd R\$S ph3ED '%s'";
$lang['deletedrssfeed'] = "d3L3T3D rs5 PH33D '%s'";

$lang['updatedban'] = "uPd4+eD 84N '%s'. cH@nG3D Typ3 PHR0M '%s' T0 '%s', ch4ng3d DA+@ PHr0M '%s' +o '%s'.";

$lang['splitthreadatpostintonewthread'] = "sPLIt +hrE@D '%s' @+ Po5+ %s  1n+0 NEw THR34D '%s'";
$lang['mergedthreadintonewthread'] = "mEr9ED tHReAds '%s' anD '%s' INt0 n3w +Hr34d '%s'";

$lang['ipaddressbanhit'] = "uS3r '%s' 15 8aNN3D. 1P 4DdR3Ss '%s' M4+cH3D b@N d4T4 '%s'";
$lang['logonbanhit'] = "u5ER '%s' 1\$ b@nn3D. lo9oN '%s' M4+chEd 8@N DA+@ '%s'";
$lang['nicknamebanhit'] = "uS3R '%s' 15 84nN3D. niCKN4m3 '%s' M@tCh3d 84N d4ta '%s'";
$lang['emailbanhit'] = "usER '%s' 1S 84nn3d. EM41L 4DdR3\$5 '%s' m4TcHEd b@n D4+4 '%s'";
$lang['refererbanhit'] = "uS3R '%s' Is B@NN3D. h+TP REF3R3r '%s' M4TCh3d B@N D4t4 '%s'";

$lang['modifiedpermsforuser'] = "m0D1Ph13d P3RMS FOR u5er '%s'";
$lang['modifiedfolderpermsforuser'] = "mod1pH1Ed folD3r p3RmS For usEr '%s'";

$lang['userpermfoldermoderate'] = "f0LDER m0dEr@t0R";

$lang['adminlogempty'] = "adM1n log 1\$ 3mptY";

$lang['youmustspecifyanactiontypetoremove'] = "j00 mUst \$PeC1FY @N aCtioN +YP3 tO Remov3";

$lang['alllogentries'] = "aLL L0G 3ntr1ES";
$lang['userstatuschanges'] = "usER 5+4TU\$ CH4n9ES";
$lang['forumaccesschanges'] = "forUM 4Cc35\$ CH4N9E5";
$lang['usermasspostdeletion'] = "u\$Er MA\$\$ PO\$t DeLe+Ion";
$lang['ipaddressbanadditions'] = "ip ADdR3S\$ B@N @DD1+10N\$";
$lang['ipaddressbandeletions'] = "ip @DdR3Ss B@N D3L3tIONs";
$lang['threadtitleedits'] = "tHR3@D +1tlE 3diT5";
$lang['massthreadmoves'] = "m45\$ THRE@d m0veS";
$lang['foldercreations'] = "f0lDer cREa+I0N5";
$lang['folderdeletions'] = "f0lD3R D3l3T1oNS";
$lang['profilesectionchanges'] = "pR0fiLe S3ct1oN cH@N93s";
$lang['profilesectionadditions'] = "prOPHiLE 53C+10N @dd1+10n\$";
$lang['profilesectiondeletions'] = "pr0FIL3 S3CT1on d3lE+ioN\$";
$lang['profileitemchanges'] = "pr0fiLe IT3M cH4N9ES";
$lang['profileitemadditions'] = "pROF1L3 1+3m @ddiTION\$";
$lang['profileitemdeletions'] = "pROFIl3 1+3m D3l3t1ons";
$lang['startpagechanges'] = "sT4rt p49E ch4n93S";
$lang['forumstylecreations'] = "fORUm \$+YL3 crE@t10N\$";
$lang['threadmoves'] = "thrE@d M0VE\$";
$lang['threadclosures'] = "thrE@d clOSUrES";
$lang['threadopenings'] = "thRe4d 0P3NiN95";
$lang['threadrenames'] = "thr3@d R3NAm35";
$lang['postdeletions'] = "poS+ dEle+10ns";
$lang['postedits'] = "p0St 3DIT5";
$lang['wordfilteredits'] = "wOrD ph1LTEr Edits";
$lang['threadstickycreations'] = "thr34D \$+1cKY cr3A+10N\$";
$lang['threadstickydeletions'] = "tHR3@D \$+IckY D3LE+10nS";
$lang['usersessiondeletions'] = "u53r SE5\$10n DELe+10ns";
$lang['forumsettingsedits'] = "forUM \$3ttiN9\$ Ed1+s";
$lang['threadlocks'] = "thR34d loCk\$";
$lang['threadunlocks'] = "tHR3@D uNLoCK\$";
$lang['usermasspostdeletionsinathread'] = "u\$Er M@\$s p0ST D3L3TION5 1n 4 THrE@d";
$lang['threaddeletions'] = "thR3@d DeLE+iOns";
$lang['attachmentdeletions'] = "a+Tachm3NT d3lE+10nS";
$lang['forumlinkedits'] = "forUm lInK 3d1+S";
$lang['postapprovals'] = "po\$t 4pPROv4Ls";
$lang['usergroupcreations'] = "uSER GR0UP cr3A+10Ns";
$lang['usergroupdeletions'] = "uSer GRoUP DEl3t1Ons";
$lang['usergroupuseraddition'] = "u53R GROuP u\$3R @Dd1+10n";
$lang['usergroupuserremoval'] = "uS3R 9R0UP u\$3R rEM0v4l";
$lang['userpasswordchange'] = "u\$ER Pa\$sW0RD cH4N93";
$lang['usergroupchanges'] = "u53R 9r0uP CH4N93s";
$lang['ipaddressbanadditions'] = "iP AdDReSs B@n @DD1+IOn5";
$lang['ipaddressbandeletions'] = "iP AdDRe\$\$ 8AN d3lET1ons";
$lang['logonbanadditions'] = "l0Gon baN 4dDItiON\$";
$lang['logonbandeletions'] = "loGon 8@n D3l3tiONS";
$lang['nicknamebanadditions'] = "nICkNAM3 84n aDdI+1ON5";
$lang['nicknamebanadditions'] = "nICknAM3 8@n @Dd1+Ion\$";
$lang['e-mailbanadditions'] = "e-m4il b4n @dd1+IONS";
$lang['e-mailbandeletions'] = "e-m41L 8@n D3lEt1on\$";
$lang['rssfeedadditions'] = "rs5 f33D 4dDITioN\$";
$lang['rssfeedchanges'] = "rSS Fe3D cH4NG3s";
$lang['threadundeletions'] = "thReAD uND3L3+10nS";
$lang['httprefererbanadditions'] = "hT+P R3PheReR b@N aDDitIonS";
$lang['httprefererbandeletions'] = "hT+P R3pHeR3r 8@n D3lEt1ONs";
$lang['rssfeeddeletions'] = "r5\$ ph33D DElE+10n\$";
$lang['banchanges'] = "b4n Ch4n93\$";
$lang['threadsplits'] = "tHr3@D \$pLI+s";
$lang['threadmerges'] = "tHr3@d MErGe\$";
$lang['forumlinkadditions'] = "f0rUM l1nk 4DdI+i0ns";
$lang['forumlinkdeletions'] = "fORUm LinK dElET1oNS";
$lang['forumlinktopcaptionchanges'] = "f0rUM l1nK +0p C@p+ION ch@ng3s";
$lang['userdeletions'] = "u\$eR d3le+10NS";
$lang['userdatadeletions'] = "uSER DA+@ D3l3+I0nS";
$lang['usergroupchanges'] = "useR gROup cH4nGes";
$lang['ipaddressbancheckresults'] = "ip 4dDRe5s 8@N cH3CK rEsUlt5";
$lang['logonbancheckresults'] = "lOgON baN CH3CK r35ulT\$";
$lang['nicknamebancheckresults'] = "niCKN@mE 8@n cHEcK r3SUL+S";
$lang['emailbancheckresults'] = "eM@1l 8@N chEck rESul+5";
$lang['httprefererbancheckresults'] = "hT+P r3pHeR3r bAN CHECK resuLT5";

$lang['removeentriesrelatingtoaction'] = "r3M0v3 enTRiE\$ r3l4t1NG +0 4CT1ON";
$lang['removeentriesolderthandays'] = "r3moVe 3N+R13s OLdER tHaN (D4Y5)";

$lang['successfullyprunedadminlog'] = "suCC3SsPhULly prUN3d @Dm1N L0G";
$lang['failedtopruneadminlog'] = "f4IlEd +o prUn3 @DMin l09";

$lang['successfullyprunedvisitorlog'] = "sUCcE\$\$pHulLY pRUNeD vi5iT0R L0G";
$lang['failedtoprunevisitorlog'] = "f@iLeD to PruN3 V1sIT0r loG";

$lang['prunelog'] = "prUN3 l09";

// Admin Forms (admin_forums.php) ------------------------------------------------

$lang['noexistingforums'] = "n0 3X1\$+1Ng F0RUMs FoUNd. +o cR34+E @ N3W fORuM cL1CK tHE '4Dd nEW' 8ut+ON 8ELOw.";
$lang['webtaginvalidchars'] = "w38+@9 CAn ONLy coN+41N uPpErC@S3 A-z, 0-9 @nD uNdEr5c0rE ch4r4CT3R5";
$lang['invalidforumidorforumnotfound'] = "inv4l1D PHorUm FiD oR forUm N0+ fouND";
$lang['successfullyupdatedforum'] = "suCC3s\$pHUlLY upD4+3D PhorUM";
$lang['failedtoupdateforum'] = "faIL3D T0 UpD@T3 F0rum: '%s'";
$lang['successfullycreatednewforum'] = "suCC3sSFUlLY CRe@TeD new fOrUM";
$lang['selectedwebtagisalreadyinuse'] = "t3h S3LeC+3D w3b+4g 1s ALr34Dy 1N u\$e. pl3453 ch0o53 @N0THEr.";
$lang['selecteddatabasecontainsconflictingtables'] = "tHE \$eL3C+ED D4+4B453 C0nT@1NS COnfL1CT1Ng +4Bl35. C0NFlIct1n9 t4BlE N4mEs ArE:";
$lang['forumdeleteconfirmation'] = "aR3 j00 SUr3 j00 W@n+ +O dEL3T3 AlL OF TH3 \$3L3Ct3D ph0rUms?";
$lang['forumdeletewarning'] = "pLe4\$3 N0+3 thAt J00 C4Nnot REc0VEr DeLe+3D f0ruMs. onCe d3l3TEd @ fORUM @ND @LL of +H3 As\$oCi4tED D@+4 1s peRM@nENtLY rEm0veD pHR0M TH3 d4T4b@sE. 1PH j00 d0 NOt W1sH t0 dEL3TE THe 5EL3C+ED PHOrUMS pL34s3 cLIck C@nCEL.";
$lang['successfullyremovedselectedforums'] = "suCCeSsphUllY d3leT3D \$3lEC+3d ph0rUM5";
$lang['failedtodeleteforum'] = "f@1L3D T0 d3L3tED fORUM: '%s'";
$lang['addforum'] = "adD forUm";
$lang['editforum'] = "edI+ f0RuM";
$lang['visitforum'] = "v1SIt PHOrUM: %s";
$lang['accesslevel'] = "aCcESS l3vEL";
$lang['forumleader'] = "f0rUM l34d3r";
$lang['usedatabase'] = "use d4t4b@SE";
$lang['unknownmessagecount'] = "uNknown";
$lang['forumwebtag'] = "foRum wEBT@9";
$lang['defaultforum'] = "d3Ph4ulT pHORUm";
$lang['forumdatabasewarning'] = "pL34SE 3n\$uR3 J00 S3L3C+ TH3 C0RrEC+ D4t4B@sE WH3N CR34+1N9 4 NeW phoRUm. oNce CR34T3d @ N3w phORum c4nNOT be M0v3D 8E+wE3N @v41l4bL3 D4+@b@Se\$.";

// Admin Global User Permissions

$lang['globaluserpermissions'] = "gL08Al Us3r pERmIS\$IOn\$";

// Admin Forum Settings (admin_forum_settings.php) -------------------------------

$lang['mustsupplyforumwebtag'] = "j00 Mus+ SuPPLY 4 f0RUM WE8+49";
$lang['mustsupplyforumname'] = "j00 Mu5+ sUPPLY 4 FORUM NAmE";
$lang['mustsupplyforumemail'] = "j00 MUST \$uPplY A PH0rUM 3M41l 4DDr3S\$";
$lang['mustchoosedefaultstyle'] = "j00 mU5+ cH0O53 @ D3ph4uLt ForUm S+yL3";
$lang['mustchoosedefaultemoticons'] = "j00 MusT CHO0S3 dEPH4UL+ F0Rum 3MotIC0N\$";
$lang['mustsupplyforumaccesslevel'] = "j00 muST sUPplY 4 f0RUm ACC3\$\$ l3vEl";
$lang['mustsupplyforumdatabasename'] = "j00 MU\$+ sUpPly 4 ph0rUm D4+@b4\$3 n@M3";
$lang['unknownemoticonsname'] = "unkNOwn EmoT1CON\$ nAm3";
$lang['mustchoosedefaultlang'] = "j00 MusT cH0oSe 4 d3F@ul+ f0RUM L4N9U@93";
$lang['activesessiongreaterthansession'] = "aCTIvE \$35s10n T1M30U+ C@nNOt 8E 9R34t3r Th4n s35\$1oN +imEoU+";
$lang['attachmentdirnotwritable'] = "a++@Chm3n+ dIReC+Ory 4Nd 5ySt3M +EMPOr@rY dIREC+0rY / pHP.IN1 'UpLO4d_+mp_Dir' MUst 8e wRIT48lE by T3h wEb s3rv3r / Php PROc3\$\$!";
$lang['attachmentdirblank'] = "j00 MUsT \$UPPly a Dir3CTORY TO S4VE 4TtaChMEntS 1N";
$lang['mainsettings'] = "mAIN 5e++1N95";
$lang['forumname'] = "foruM NAm3";
$lang['forumemail'] = "forUM em4IL";
$lang['forumnoreplyemail'] = "n0-R3ply eM@1l";
$lang['forumdesc'] = "f0Rum D35CRipT10n";
$lang['forumkeywords'] = "f0rUm k3ywoRds";
$lang['forumcontentrating'] = "forUM cON+3nt r4TInG";
$lang['defaultstyle'] = "d3fAULt sTYl3";
$lang['defaultemoticons'] = "d3F@ul+ eMO+iC0N\$";
$lang['defaultlanguage'] = "d3ph4ul+ l4ngU49E";
$lang['forumaccesssettings'] = "f0RuM @cCeS\$ Se+tiN9\$";
$lang['forumaccessstatus'] = "forum AcCe\$s 5+4+US";
$lang['changepermissions'] = "cH4nGE pERMi5\$10NS";
$lang['changepassword'] = "ch@NGE P45\$w0rD";
$lang['passwordprotected'] = "p@5\$WORd PROteC+3d";
$lang['passwordprotectwarning'] = "j00 H4Ve NO+ Se+ 4 foruM p4\$SW0Rd. IpH J00 d0 No+ 53T 4 p45sW0Rd +h3 P4S\$woRd Pr0tEc+Ion phUnc+10n@L1+y WIlL b3 @Ut0mA+1C4LLY DIs4bL3D!";
$lang['postoptions'] = "pos+ OP+IOn\$";
$lang['allowpostoptions'] = "all0w POsT 3D1TIng";
$lang['postedittimeout'] = "p0\$+ 3DIT +IMeou+";
$lang['posteditgraceperiod'] = "pOSt 3D1+ 9R4Ce P3RIoD";
$lang['wikiintegration'] = "w1K1W1K1 IN+39r@tiOn";
$lang['enablewikiintegration'] = "eN@BLE w1k1wIKi 1ntE9RA+1ON";
$lang['enablewikiquicklinks'] = "en4BL3 WIK1W1k1 QU1Ck LinK\$";
$lang['wikiintegrationuri'] = "w1K1WikI L0C@t1on";
$lang['maximumpostlength'] = "m@xImuM p0ST LEn9th";
$lang['postfrequency'] = "p0St FrEQu3Ncy";
$lang['enablelinkssection'] = "eN4BL3 link5 \$3c+i0n";
$lang['allowcreationofpolls'] = "all0W cr34+ion 0f poLl\$";
$lang['allowguestvotesinpolls'] = "all0w 9Ue\$ts tO V0T3 1n POlLS";
$lang['unreadmessagescutoff'] = "uNRe@D M3s\$49e5 CU+-0FPH";
$lang['disableunreadmessages'] = "dI\$48LE UNrE@d mESs493s";
$lang['thirtynumberdays'] = "30 d@Y5";
$lang['sixtynumberdays'] = "60 D4YS";
$lang['ninetynumberdays'] = "90 D4yS";
$lang['hundredeightynumberdays'] = "180 D4y5";
$lang['onenumberyear'] = "1 ye4r";
$lang['unreadcutoffchangewarning'] = "d3p3nD1N9 ON \$3rV3r PERphOrm@nCE 4nd TH3 NUm8eR 0Ph +hr3@D\$ Y0UR ph0rUm5 coN+4IN, Ch@NgiNG tEh UnR34D cU+-0PHPh M4Y t@kE 53V3R4L M1NutEs To CoMPLe+3. PHor +h1S r3a5on 1+ 1S R3C0MmENdEd +h4T j00 4v01D cH4NGING tHis 53t+1N9 WH1Le YoUR FORum5 @R3 8U5y.";
$lang['unreadcutoffincreasewarning'] = "iNcr34\$iN9 +eH UnRE4D CU+-OFpH WIlL m@ke ThrE@DS m4rk3D 4s m0D1FiED siNc3 4nd ThrE@d\$ OLdEr +H4N +EH prEv1OUS CUt-0FPh 4pPEaR @S UNRe4D +o @ll US3R5";
$lang['confirmunreadcutoff'] = "aRe j00 SURE J00 W4NT +0 CH4N9E tHE UNrEAd cU+-OPhpH?";
$lang['otherchangeswillstillbeapplied'] = "cL1cK1NG 'NO' wILL 0NLy C@Nc3l +h3 unRe@D cuT-0fpH chAn93S. 0+HeR ch4nge\$ Y0U'vE M4De WilL s+1ll Be 54v3D.";
$lang['searchoptions'] = "se@Rch Op+ion5";
$lang['searchfrequency'] = "se4rCh Fr3qu3Ncy";
$lang['sessions'] = "s3S5ION\$";
$lang['sessioncutoffseconds'] = "s3ss10n Cut OPhf (s3C0Nd5)";
$lang['activesessioncutoffseconds'] = "acT1V3 S3SS10N cUT oPHf (S3c0Nd5)";
$lang['stats'] = "st4+\$";
$lang['hide_stats'] = "hID3 sT4+s";
$lang['show_stats'] = "sHOw \$T4T5";
$lang['enablestatsdisplay'] = "eN48lE StA+S dISPl@Y";
$lang['personalmessages'] = "p3RSON@l M3s\$@93S";
$lang['enablepersonalmessages'] = "eN4bLE PER\$on@l MeSS@9e5";
$lang['pmusermessages'] = "pm M3\$\$4gEs PEr US3R";
$lang['allowpmstohaveattachments'] = "alL0w P3RSON4L m3s5@93S T0 H@v3 A+t@chM3Nt5";
$lang['autopruneuserspmfoldersevery'] = "au+0 PRuN3 US3R'\$ pm pH0LdErs EvERY";
$lang['userandguestoptions'] = "u\$er 4Nd 9UEs+ OP+10N\$";
$lang['enableguestaccount'] = "en48Le GuESt @ccoUNt";
$lang['listguestsinvisitorlog'] = "l1\$t gu35+s 1N V1S1TOR lO9";
$lang['allowguestaccess'] = "aLL0W gU3\$+ @cCe\$\$";
$lang['userandguestaccesssettings'] = "uS3r 4nD GU3S+ 4Cc3s\$ 53ttIngs";
$lang['allowuserstochangeusername'] = "allOW u5ER\$ T0 Ch@n93 U\$3RN4Me";
$lang['requireuserapproval'] = "reQUIRe US3R 4PProV@l bY 4DMIN";
$lang['requireforumrulesagreement'] = "rEqUiRe U\$3r +o agRe3 +O FOrUM rUL35";
$lang['sendnewuseremailnotifications'] = "s3ND NoTIphIc@TI0N T0 Gl08@L fORuM OwNEr";
$lang['enableattachments'] = "enA8LE @T+4Chm3nT\$";
$lang['attachmentdir'] = "a+T@ChmEnT d1r";
$lang['userattachmentspace'] = "a+tAcHM3n+ sPaC3 PeR uS3R";
$lang['userattachmentspaceperpost'] = "att4CHMent \$p4C3 p3R POSt";
$lang['allowembeddingofattachments'] = "aLL0w EmB3dd1n9 0F 4T+4cHM3NT\$";
$lang['usealtattachmentmethod'] = "uS3 4L+3RnAtiVe 4+T@CHmEN+ mEtH0D";
$lang['allowgueststoaccessattachments'] = "alLoW 9U3S+5 T0 aCc3\$\$ 4+TaCHM3N+5";
$lang['forumsettingsupdated'] = "f0RUm \$3t+iNg5 SuCc35\$pHUllY UPda+Ed";
$lang['forumstatusmessages'] = "f0rUM 5+4tUs m3sS49ES";
$lang['forumclosedmessage'] = "foRuM cLO53D Me\$s493";
$lang['forumrestrictedmessage'] = "f0rUm rE\$+RiCT3D mE\$54g3";
$lang['forumpasswordprotectedmessage'] = "f0RUM p4\$\$w0rD PROT3c+3D M3sS@93";
$lang['googleanalytics'] = "goO9Le 4N4Lyt1Cs";
$lang['enablegoogleanalytics'] = "eN@bl3 go09l3 4n4lYt1c\$";
$lang['allowforumgoogleanalytics'] = "allOw gOO9Le 4N@ly+IcS 0n 34CH PH0RuM";
$lang['googleanalyticsaccountid'] = "gOO9LE 4N4LY+1C5 4CcouNT Id";

$lang['googleadsense'] = "g00gl3 4dSeN5e";
$lang['adsensepublisherid'] = "aD\$3N53 pU8L1SHEr 1D";
$lang['adsensemediumadid'] = "m3diUm S1Z3D (468X60) 4D 5L0+ Id";
$lang['adsensesmalladid'] = "sM4lL S1ZeD (234X60) 4D \$L0+ 1D";
$lang['adsenseallusers'] = "alL U\$3R\$";
$lang['adsenseguestsonly'] = "gu3St\$ ONLy";
$lang['adsensenoone'] = "no-ONe (d1S4BLeD)";
$lang['adsensedisplayadsforusers'] = "dIsPLAY 4DsEN5E @D\$ PH0r";
$lang['adsensedisplayadsonpages'] = "d1SPL4Y @d5Ens3 @Ds 0N";
$lang['adsenseallpages'] = "t0p 0ph EVeRY pAg3";
$lang['adsensetopofmessages'] = "tOp of ME\$S49eS";
$lang['adsenseafterfirstmessage'] = "af+3r 1\$+ M3s549E";
$lang['adsenseafterthirdmessage'] = "afTER 3rD m3SS49e";
$lang['adsenseafterfifthmessage'] = "aph+er 5tH ME\$s493";
$lang['adsenseaftertenthmessage'] = "afT3r 10+H m35s493";
$lang['adsenseafterrandommessage'] = "aF+3R @ R@nDOm Me\$s@93";
$lang['registertoremoveadverts'] = "reGiSTer to rEMov3 THeSE @DverT\$.";

// Admin Forum Settings Help Text (admin_forum_settings.php) ------------------------------

$lang['forum_settings_help_10'] = "<b>p05+ 3di+ tIMeoU+</b> IS t3h +1m3 IN MiNuT3s AFtER Po5t1n9 +h@+ 4 uS3R c4n eDIt TH31r PosT. iF 53+ +O 0 TH3Re 1\$ n0 l1mi+.";
$lang['forum_settings_help_11'] = "<b>m4XiMUm pOs+ l3n9tH</b> I\$ TH3 M@x1mUM NuMb3r 0F cH4RAcT3r\$ +H@T w1lL 8E DI\$pL@YED iN 4 p0sT. 1ph A P0sT 1\$ L0NGer th@n Th3 nUM8Er Of ch4r4CtERS D3pH1NeD hEre It w1lL B3 Cut sh0R+ 4nD @ LInk 4Dd3D t0 tEh b0t+om +o @LlOw UsERS t0 R34D tH3 WH0Le Po5+ ON @ SEP@r4TE p49e.";
$lang['forum_settings_help_12'] = "iF J00 d0n'+ W4n+ YOUR USer5 +0 bE 4BlE +O CRe4te POllS j00 C@n DiS48l3 +EH 4B0V3 0p+10n.";
$lang['forum_settings_help_13'] = "th3 lINk5 sEc+1ON oF b33h1V3 Prov1D35 4 pL4C3 fOr Y0UR u53RS +O ma1n+4iN @ l1ST oPH \$1T3S Th3Y pHR3qu3ntLY v1sI+ +h4T 0+hEr UsERS m4y PhiND US3Ful. lInks C4n b3 d1v1D3D 1Nto C4+39oR13s by f0lD3r 4Nd @LloW PhOR C0MM3N+\$ 4nd R@T1N9\$ +0 b3 9iven. 1n ORdER tO M0d3r4+3 +3H LInK\$ 53c+ion A u53R MusT 8e r@n+ED 9LobAl M0d3r4T0R S+@tU\$.";
$lang['forum_settings_help_15'] = "<b>s3sS1On Cut oFPH</b> i5 TH3 M4X1MUM T1ME b3FOr3 4 Us3r's 53\$s10n i5 D3EMeD dE@D 4nd Th3y ARe L09g3D oUT. bY DePH@UlT +hI\$ 1\$ 24 hoUrs (86400 53ConDs).";
$lang['forum_settings_help_16'] = "<b>actiVE s35Si0N cU+ 0PHF</b> 1s thE mAX1MUM T1mE B3F0R3 4 US3R's sE\$s1on i5 D33M3D 1N4C+iv3 4t whIcH P01n+ +hEY 3n+3r 4n 1dL3 st4+e. 1N TH1\$ STatE t3h u53R r3m41ns LO9G3D iN, 8U+ Th3y 4R3 REmOV3D PhR0m +H3 4C+1V3 USerS List in tH3 S+4+5 DisPl@Y. onCE THey 83C0mE 4CT1v3 @G4in +H3y w1lL 83 r3-4dDED t0 +h3 L15+. 8y D3FAULT THIS 53t+1N9 1\$ \$3+ +O 15 m1nUT3s (900 sEc0NDs).";
$lang['forum_settings_help_17'] = "en4Bl1N9 TH1\$ 0PT1ON @lLOWS 8e3h1vE to 1ncluD3 @ sT@Ts D1SPl4y @t +HE boT+oM opH +eH m3SSA9E\$ p4nE 51mIL4R t0 the ON3 u\$eD 8Y m@ny ph0rUM 5Of+W4R3 TI+L3s. oncE 3n48L3D +He diSpl@Y 0F +h3 ST4+\$ PAg3 c4n 8E +099LeD 1ndIv1du4lLy 8y e@Ch U\$3r. if They d0n'+ W4Nt to sE3 1T TH3y c@n hidE 1+ PHR0m V13w.";
$lang['forum_settings_help_18'] = "pEr\$0N@L mE\$\$4Ge\$ 4rE 1nV4LU4BL3 @\$ 4 w@Y 0F tAK1n9 morE pR1V4TE m4t+3R\$ oUT of VI3W Oph +Eh 0thER M3M8ERS. HOWEvER iPH J00 D0N'+ w4nT Y0UR u\$3R5 +0 bE 48lE T0 \$3nD E@Ch Oth3r PerS0N@l M35\$49eS j00 C4n d15@bl3 +h1\$ OP+IOn.";
$lang['forum_settings_help_19'] = "p3Rson4l mE\$\$4g35 c@N aLSo C0Nta1n 4TT@chMEN+\$ WhiCh c4n 8E u53fUl Ph0R 3XcH@ng1NG pH1LEs bETWe3n U53r\$.";
$lang['forum_settings_help_20'] = "<b>n0+3:</b> tH3 sp@c3 aLl0c4tIOn PhoR Pm 4T+@cHMeNT\$ 1\$ tak3n pHrOm E@CH us3rS' mAIn 4TT@CHmEnt 4ll0c4+10N 4Nd 1\$ NO+ IN 4DD1+1On +0.";
$lang['forum_settings_help_21'] = "<b>en@8LE 9U3ST @CcouNt</b> 4lL0WS v1\$iT0RS T0 8R0WS3 Y0UR fORuM 4nd R34D Po5t\$ WI+HOut R3G1\$tEr1n9 4 Us3r acCOuNT. @ US3R 4cCOuN+ i5 \$tILL ReQUirEd ipH +HeY wi5H +0 P0s+ 0R CH@N93 US3R Pr3fER3nc35.";
$lang['forum_settings_help_22'] = "<b>lIsT GuE\$+\$ 1n v1S1TOR l09</b> @lL0WS j00 T0 SPeCiPHy wH3+HeR Or N0t Unr391\$tErED US3rS 4RE l15tED ON +H3 V1\$1t0r L09 4LONG\$Id3 r3gIs+3r3D u53R5.";
$lang['forum_settings_help_23'] = "b33HIve 4lLOws 4tT4Chm3n+\$ T0 83 upl0@D3D +O M3SS49e\$ WH3N P0\$+Ed. iF j00 h@VE l1m1+ED W38 \$p4C3 J00 M@Y wH1Ch TO d1\$4Bl3 4t+4cHM3n+\$ bY CLe@R1N9 +hE B0X 48oV3.";
$lang['forum_settings_help_24'] = "<b>at+@ChMENt DiR</b> 1S +3h L0C@t1oN B3EH1Ve \$h0ULd \$+ORe 4+T4CHM3Nt\$ 1N. +H1s dirEC+ORY mUst 3x1s+ 0N y0Ur Web Sp4c3 4nD mU5+ 8E WrI+4Bl3 BY +H3 W3B s3RveR / PHp ProcE\$\$ Otherw1S3 UpL04DS w1ll f@1l.";
$lang['forum_settings_help_25'] = "<b>at+4chMeN+ 5p4cE Per u5er</b> iS TH3 M4x1MUM 4m0uN+ 0PH D1\$K sp4Ce 4 U\$3R h45 PH0R @T+4chmEnTS. Onc3 +h1\$ SP@C3 1\$ U\$eD uP tH3 U5eR C4nN0+ uPl04D ANy MOr3 4tt4cHMEnT5. 8Y dEf4uL+ tH15 IS 1M8 0pH \$p4CE.";
$lang['forum_settings_help_26'] = "<b>all0W eMB3DD1N9 Oph a++4chMenTs 1N m35\$49es / s1gn4tURE\$</b> 4Ll0w5 u\$3RS T0 EmB3D 4+t4chM3nTS 1N P0ST5. 3N48l1NG +h1\$ 0PTIOn whiL3 u\$3FUl C4N INcRE4s3 your bANdWID+H u54Ge Drast1C4LLY UNd3r CeRT4IN cONFI9UR@+1ONS oF Php. IPh J00 H4VE liM1+eD 8aNdwId+H I+ is R3Comm3Nd3d TH4T J00 d1s4Ble +H15 0pt1On.";
$lang['forum_settings_help_27'] = "<b>u53 4lT3RNA+1v3 A+t4chM3N+ mETHOd</b> FoRce5 83EH1V3 +0 u53 @n ALTeRN@+1vE RE+r13VaL m3THOd f0r @tT4CHM3N+\$. IpH j00 ReC3iVe 404 ERr0R Me\$\$@93s WH3N TryinG t0 DowNl04D @tt4cHmEn+S PhR0m Mes\$49e\$ TRY eN4bl1N9 +H1\$ oPTion.";
$lang['forum_settings_help_28'] = "tH3s3 \$3t+1ngS 4LLOw\$ YOUr ForUm +0 b3 5pIdER3D 8y \$34rCH 3n9inE\$ Lik3 9o09L3, @l+@v1S+4 4nd Y@hO0. if j00 5WI+ch thIs opT10N oFpH y0ur fORUm W1LL n0+ b3 1NClUDeD iN ThESe S34RCH ENgIN3S R3\$ul+\$.";
$lang['forum_settings_help_29'] = "<b>all0w nEw USER R3gi5+R4tioNS</b> 4LL0w5 OR D1\$@LLowS +H3 CrE4t1oN 0F nEW usEr 4Cc0UNts. 53T+In9 th3 0p+10N To NO C0mPl3tELy Di54BL35 TH3 ReG15+r4tION PHorM.";
$lang['forum_settings_help_30'] = "<b>en@blE wIkiWIK1 1NTegr4+1ON</b> pR0VIdE5 WiKIW0RD 5UppOr+ 1n yOUr F0RuM po5+S. 4 W1kIw0rD 15 M@De uP 0F tWO 0R mORE CoNc4+EN4T3D w0rd\$ W1tH UppERc@S3 L3T+eR\$ (OPH+3n r3F3RR3D t0 A\$ c4m3lc4\$e). 1pH J00 Wr1+3 @ W0rD +H1\$ W@y 1+ wiLl @uT0MA+1C@LLy 83 Ch4N9ED 1nto @ HYP3RLInk POintin9 +O Y0Ur ch0s3N wIK1wIK1.";
$lang['forum_settings_help_31'] = "<b>en4ble WIK1w1k1 QuICk lINk\$</b> 3n@BL35 t3h uSE oph m59:1.1 aNd Us3r:L090n S+yLe 3xT3NDEd w1k1links Wh1cH CRe@te HyperLINkS t0 +He \$P3CIf13D M35S@9e / UsER pR0file 0PH +eh sPEc1f13D U5ER.";
$lang['forum_settings_help_32'] = "<b>wikiWIK1 LOcA+IOn</b> is U\$3D +o spEc1pHy +eH uR1 Of YOuR wiKiWiki. whEn 3nT3R1N9 TH3 ur1 Us3 <i>%1\$S</i> t0 1nDIc4T3 whER3 In +3H UrI +eH w1K1wORd SHOuLd 4PP34r, 1.3.: <i>hTtp://3N.W1K1P3D1a.oRG/wIKI/%1\$\$</i> WOulD l1nK Y0Ur WIkiW0Rds TO %s";
$lang['forum_settings_help_33'] = "<b>f0rUM 4Cc3ss 5t4tUS</b> C0N+roLS H0W u5eR\$ M@Y @CcE\$\$ Y0ur FORuM.";
$lang['forum_settings_help_34'] = "<b>oP3N</b> WiLl 4lloW aLl U5Er\$ 4nd 9ue\$+S 4CcESS +o YOuR ForUm Wi+HOut Re\$TR1CT1ON.";
$lang['forum_settings_help_35'] = "<b>cl0\$3d</b> PR3Ven+\$ 4cc3S\$ foR 4Ll Us3rs, w1TH +H3 eXc3PTi0N 0Ph +eH 4DmiN wH0 M4y S+1Ll Acc35\$ +3h @DM1N p4nEL.";
$lang['forum_settings_help_36'] = "<b>r3stR1CteD</b> 4lLowS +o 5E+ 4 l1sT 0F U5ers Who 4R3 4lLOWeD @cc3SS T0 yoUR F0rUm.";
$lang['forum_settings_help_37'] = "<b>p@5\$woRd PRotEC+3D</b> 4LLowS j00 T0 S3t a P4Ssw0rD To 9iVE 0u+ t0 u5eR\$ 5O +hEy C4N 4CceSS y0UR f0RUM.";
$lang['forum_settings_help_38'] = "wh3N sE+TIn9 re\$+R1CT3D oR P45\$w0rD PROTec+3D M0D3 j00 w1ll N33D +O \$@Ve Y0UR CH4Ng3\$ b3fore J00 C4N cH4n93 THe U53r 4Cc355 PR1V1L39ES 0R p45SW0RD.";
$lang['forum_settings_help_39'] = "<b>Search Frequency</b> defines how long a user must wait before performing another search. Searches place a high demand on the database so it is recommended that you set this to at least 30 seconds to prevent \"search spamming\"fR0m KILlIN9 +3H \$3RVEr.";
$lang['forum_settings_help_40'] = "<b>po\$+ FreQU3ncY</b> 15 th3 m1nIMuM T1M3 A u53r mU\$t w4It 8Efore tH3y C@N p0s+ 4941n. +h1\$ sE++in9 also @PHf3C+\$ tH3 cR34t1On 0f Polls. s3t +O 0 T0 diS4BL3 +hE r35+r1ctION.";
$lang['forum_settings_help_41'] = "t3H 4BOvE op+Ion\$ CH4N93 Th3 dEPH4UL+ ValU3s F0R +H3 U53r rEGi5+R4Tion phORm. wh3RE 4ppLiCA8LE otheR s3t+inG5 w1LL U53 T3H F0Rum'5 0wn D3ph4ul+ Se+TIn9\$.";
$lang['forum_settings_help_42'] = "<b>pr3V3n+ us3 0ph DUpLIC4t3 3m41L 4Ddres5E\$</b> fORC35 Be3h1ve +0 ChECk Teh us3r 4CC0Un+\$ 49@IN5T +hE EM4il AdDrESS tEH us3r 15 R3GISt3r1n9 w1tH @ND PR0MP+S tHEm +0 u53 4n0thEr 1F 1+ is aLR34DY 1n U\$3.";
$lang['forum_settings_help_43'] = "<b>rEQU1rE 3M4iL CONf1RM4+10n</b> whEN EN48lEd W1LL 53nD 4N eM4il tO e4cH N3W u5Er WI+H 4 l1nK +H4T c4n 83 U\$3D +o ConPH1RM ThEir eM4il adDRe\$s. UN+IL ThEY C0NFIRm tHeiR EM41l @dDrEs\$ +h3Y W1LL not b3 4BLe +0 PO5+ UnlE5\$ THe1R u53r p3rm1s5iON\$ 4RE Ch4nG3D M@Nu4LlY by @N 4dmIN.";
$lang['forum_settings_help_44'] = "<b>uS3 +EX+-C@p+Ch@</b> pre\$EnTS +EH n3W u5er wi+h 4 mAN9L3D IMa9e WhiCh TH3Y Mu\$t c0py @ nUm8ER FR0m 1N+o 4 +3x+ Fi3lD 0N +hE r3gi\$tra+10N Ph0RM. U\$3 +H1\$ 0PTIon +0 PrEVeNT AuT0M@+3D \$i9n-up vi@ sCrIPTs.";
$lang['forum_settings_help_47'] = "<b>p0S+ eDI+ gr4cE pErIoD</b> 4llOWS j00 +0 DePH1ne 4 p3RIOd 1N M1NutE\$ WH3RE useRs m4Y 3Dit POsT\$ w1tHOUt thE 'ED1+3D 8Y' +3x+ 4PP34rIn9 on +HEiR p0ST5. Iph s3T +o 0 Teh 'ed1tEd 8Y' +EX+ WIll 4lw@Y5 4pPE4r.";
$lang['forum_settings_help_48'] = "<b>uNrE4D M3S54gE\$ cUt-0Phf</b> sp3C1pH13s H0W l0n9 Me\$\$493s rEM41n UNRe4d. +Hr34Ds M0DipH13D n0 lA+3R +h@N +H3 p3r1oD 53L3C+eD wIll 4ut0ma+1C4LLY 4Pp3@R @s rE4D.";
$lang['forum_settings_help_49'] = "chooSINg <b>dI\$48lE unre4d Me\$\$493s</b> W1LL c0mpL3TELY r3moVe Unr34d m3sS49E\$ sUPP0RT anD REmOve +EH r3LEv@N+ op+10n\$ PHroM +hE d1sCu5SIon TyPE DROp D0Wn ON +H3 +HR34D Li\$+.";
$lang['forum_settings_help_50'] = "<b>r3qu1R3 Us3R 4PprOV4L bY @Dm1n</b> @LLOWs J00 t0 r3STrIct aCc355 bY n3W u53rs Un+Il ThEY hAV3 8EeN apPrOV3D 8y 4 M0D3R4t0r OR aDmIN. wIThOu+ 4pPR0V4l 4 us3r c4nnOt ACC355 4NY @R3@ 0PH +hE 83EHiv3 PHORUm In\$+4Ll@+1oN iNcLUding 1ndIVIdU@l Ph0RUm\$, PM iNbox 4ND MY pHORum5 sECT10NS.";
$lang['forum_settings_help_51'] = "use <b>cL0\$3d ME\$\$@93</b>, <b>rE\$+R1Ct3d M3\$\$4gE</b> 4ND <b>p4SSw0rD ProT3C+3d M3Ss4G3</b> to cU\$+0MIS3 +3H mE\$\$@93 d15pL@Yed Wh3n U53R\$ @cCe\$\$ Y0ur F0Rum IN tEH V@RIoU5 5T4T3S.";
$lang['forum_settings_help_52'] = "j00 C4N U\$e HtmL In YOur m35\$@93s. hypErLINK\$ 4nD eM41l @ddrE\$\$E\$ wIll 4L5O 83 @Utom4tIc@llY cONV3r+3D T0 L1NK5. To UsE TH3 DEpH@Ult bE3HIVe foRUM m35\$493s cLe@R +3H PhiElD5.";
$lang['forum_settings_help_53'] = "<b>aLl0w u\$eRS t0 CH@nG3 uS3rn4Me</b> p3rmIT\$ 4LR34dY rE91sTErED USErS +O CH4NG3 +hEir U53Rn4me. whEn En4bL3D j00 c4N +R4Ck +eH cH4NG35 4 US3R M@k3s +0 Th31R Us3rn4m3 v1@ T3h @DMin u5eR t0ol\$.";
$lang['forum_settings_help_54'] = "use <b>foRUm RUl3S</b> +O enTEr @n Acc3PT4BlE u53 Pol1CY tH@+ E4ch usER MuST @9R3E To 8EPH0Re rEG1s+3RINg On y0ur F0ruM.";
$lang['forum_settings_help_55'] = "j00 cAN Us3 H+ML IN yoUr PH0RUm ruL3\$. hyP3rL1NKS 4nD 3m41l 4DdrE\$S35 WIll 4L5O 83 AU+0mA+1C4LLY COnVERt3d +O l1nK5. +O Us3 +hE D3F4ULt 8E3h1vE PH0rum 4UP cL34R +eh pH13lD.";
$lang['forum_settings_help_56'] = "u5e <b>n0-RePLY eM4IL</b> +o SPeciPHy @N 3M4IL aDdresS +h@t D0E5 n0+ EXIsT OR W1LL nOt B3 M0niT0r3D pH0r r3PlIeS. tH1\$ 3M4IL @DDrE\$s WiLL B3 U\$3d 1N Th3 H3@Der5 ph0R @Ll 3M@il\$ seNT FROM Y0uR f0RUm INcLUD1n9 BU+ N0T l1miT3D T0 POST ANd Pm n0+1phic@TioN\$, U53r 3m4iL\$ @nD P4\$\$woRD REm1Nd3R\$.";
$lang['forum_settings_help_57'] = "it Is R3C0mMend3d +Ha+ j00 us3 aN EM41l 4DdREs\$ tH4+ dOE\$ n0+ ExiSt +o h3lp cUT d0WN on sp4M +h@+ m@Y Be Dir3C+3D 4T YoUR mAin phOruM 3M4il @dDREs5";
$lang['forum_settings_help_58'] = "iN @dD1+ION T0 \$iMPlE \$P1DerIng, 83EH1Ve c4n ALso gEN3R@Te 4 Si+3M4P PH0R tHE pHorUM +o m4kE 1t 3ASIeR f0r S34rCh EnG1N35 tO PH1Nd @nD 1Nd3x +hE ME\$S49ES P0sTEd bY Y0Ur Us3r5.";
$lang['forum_settings_help_59'] = "s1tEmAps 4R3 4uT0M4TIc4lLy s@VeD +o +3h s1+3M@p\$ SUb-d1R3CTOrY OPh YoUR 8E3HIVE F0Rum in5+4LLA+iON. 1PH Th1\$ DIrEct0Ry DoESN'T 3X1sT j00 Must cr34TE 1+ 4nD eNsuR3 Th4+ IT iS Wr1t@bLE BY +He 53rV3R / PHp PR0c35\$. +0 ALl0W \$34RCh 3NgiN3s +O FINd y0uR si+Em@P J00 MU\$+ 4DD Th3 Url +0 your R080t5.Tx+.";
$lang['forum_settings_help_60'] = "d3p3nD1n9 0n 53rV3R PeRF0RM4NC3 ANd +eH Num8ER oF F0Rum5 @nD THRe@Ds YoUR 83EHIv3 IN5t4ll@+1oN C0n+@1NS, gEN3r@t1n9 4 s1+3mAP m@Y +@k3 S3veR4L MinUtE\$ TO COmpLe+E. 1ph P3RForM@nCe Of Y0UR s3rV3R 1\$ 4DV3R\$3lY 4pHf3cTEd 1T 1s ReComM3Nd J00 D1sa8l3 gEnER4t1oN 0pH +3H \$i+em@p.";
$lang['forum_settings_help_61'] = "<b>s3ND Em4iL NotIfiCaT1oN +o glO84L aDMiN</b> wH3n 3n@blED W1LL \$3Nd an Em41l T0 +He Glo8@l PHorUm 0WN3RS wH3N @ NEw Us3r @ccoUNt I5 cr34t3d.";
$lang['forum_settings_help_61'] = "eNT3r YOuR <b>goO9l3 @N4LY+IC\$ 4cCOunt Id</b> hER3 +O EN4BlE gO0Gl3 @N@Ly+Ic TR@ck1N9 Oph YOuR F0Rum. gO09L3 4N4lY+1Cs WiLL TrAck vI\$1+oR\$ to YOuR 51+3 aNd R3C0rd H0w lONG +h3y \$+4Y 4Nd Wh1cH p4g35 th3Y viSIT. By VI51tING +H3 G0OGlE 4N@LY+1cs 5ITe Y0Ur c4n SE3 4N 0V3rVI3w opH h0W YOur phoRUM 1s uSED.";
$lang['forum_settings_help_62'] = "If you do not have a Google Analytics Account you will need to sign up for one by clicking <a href=\"https://www.google.com/analytics/\" target=\"_blank\">here</@ >.";
$lang['forum_settings_help_63'] = "If you do not have a Google AdSense Account you will need to sign up for one by clicking <a href=\"https://www.google.com/adsense/\" target=\"_blank\">here</@ >.";
$lang['forum_settings_help_64'] = "iF J00 WISh +o EN4bl3 0r di\$@bLE 9009l3 aDs3n5e @d\$ 0n @ P4RT1cUl4r ph0RUm J00 c4n d0 S0 BY v1SI+1N9 ThA+ f0rUM'\$ FORUm s3T+1N95 p49E.";
$lang['forum_settings_help_65'] = "t0 chAN9E G0oGL3 4dS3N5E ACCOuN+ D3t4iLS and OTH3R \$et+1N9S PL3@S3 5EE 9LO8@L Forum S3T+InG\$";
$lang['forum_settings_help_66'] = "your B3EH1Ve PHORUm suPPor+\$ H0wING 2 diFPH3RenT sizE\$ oPH <b>g00gle 4D\$3N\$3</b> @dv3rt5. en+3R +3H \$lOt id\$ 0ph +h3 REL3V4N+ 51zED 4D\$ 1n+O the 80XE\$ 48ovE 4nd b33Hiv3 WiLL Au+0ma+1c@lLy Ch0o\$e +H3 C0RR3c+ 4d phOr e@ch p493.";

// Attachments (attachments.php, get_attachment.php) ---------------------------------------

$lang['aidnotspecified'] = "a1D NO+ sp3ciPh13D.";
$lang['upload'] = "uPL0@D";
$lang['uploadnewattachment'] = "uPLo4D n3W @T+@cHMen+";
$lang['waitdotdot'] = "w41+..";
$lang['successfullyuploaded'] = "sucCESSfULLY uPlo4DEd: %s";
$lang['failedtoupload'] = "f4iLeD TO UPLo4d: %s. cH3Ck PHre3 4+tacHM3N+ SP4C3!";
$lang['complete'] = "compLeTE";
$lang['uploadattachment'] = "uPLO4D 4 PHILe FoR 4tT4CHMent +o THe Me\$SAG3";
$lang['enterfilenamestoupload'] = "eN+3r ph1l3nam3(5) +o Upl04d";
$lang['attachmentsforthismessage'] = "att4cHMeN+5 PhoR thi\$ m3s5@93";
$lang['otherattachmentsincludingpm'] = "o+her 4tTaCHm3NT5 (incLUd1n9 Pm M35s4gE\$ 4ND OThER fOruMS)";
$lang['totalsize'] = "t0TaL 51z3";
$lang['freespace'] = "fR33 Sp4C3";
$lang['attachmentproblem'] = "tH3rE w4s A PR0BlEM D0wnLOAd1n9 THI\$ 4t+4ChMENt. PL34SE +ry 4g41N la+3r.";
$lang['attachmentshavebeendisabled'] = "aTTAcHM3nT\$ H@V3 83eN D154BLeD 8Y T3H ph0RuM 0WNeR.";
$lang['canonlyuploadmaximum'] = "j00 C4N 0NLy UplO4D a max1mUm Of 10 pH1le\$ 4+ 4 +1Me";
$lang['deleteattachments'] = "d3l3tE 4+T4CHm3nTs";
$lang['deleteattachmentsconfirm'] = "arE J00 \$UR3 J00 W4N+ TO DeLE+3 +h3 s3l3C+eD 4t+@cHMeNT\$?";
$lang['deletethumbnailsconfirm'] = "are j00 SuRE j00 W4N+ +O DeL3+e thE \$eLECTEd @tTAcHMEnTS +hUMbN41l\$?";
$lang['failedtodeleteallselectedattachments'] = "fAil3d To DeL3T3 4Ll Oph +EH 53L3C+ED 4T+@chmENT\$";
$lang['failedtodeleteallselectedattachmentthumbnails'] = "f41LEd +0 dEl3+e 4lL 0f Th3 s3l3C+eD 4t+@cHMenT tHUm8n@IL\$";

// Changing passwords (change_pw.php) ----------------------------------

$lang['passwdchanged'] = "p@s5woRd chAn93D";
$lang['passedchangedexp'] = "y0uR P45sW0Rd H4S 83eN cHAN9Ed.";
$lang['updatefailed'] = "uPD4+E pH4ILeD";
$lang['passwdsdonotmatch'] = "p@SSW0Rds d0 NOT M4+ch.";
$lang['newandoldpasswdarethesame'] = "nEW 4ND 0Ld p@s\$w0Rd\$ 4re t3h \$@mE.";
$lang['requiredinformationnotfound'] = "reqU1rEd 1nPhorm4+1oN NOT PHOund";
$lang['forgotpasswd'] = "foR90T P4S\$w0rD";
$lang['resetpassword'] = "r3\$3T p@s5woRD";
$lang['resetpasswordto'] = "re\$3T p@SSWorD +o";
$lang['invaliduseraccount'] = "invALId U53r 4CcOUNT spECIFi3d. cHEcK eM41l PHor c0rR3C+ liNk";
$lang['invaliduserkeyprovided'] = "iNv@LiD uSEr k3y Pr0viD3D. CH3Ck Em41l f0r C0RReCT L1nK";

// Deleting messages (delete.php) --------------------------------------

$lang['nomessagespecifiedfordel'] = "n0 mE\$S4g3 SpECiFI3d fOR dElE+10N";
$lang['deletemessage'] = "dELE+3 M3sS@93";
$lang['successfullydeletedpost'] = "suCce5\$pHulLY delE+3d P0\$T %s";
$lang['errordelpost'] = "eRR0r dELe+1nG P0sT";
$lang['cannotdeletepostsinthisfolder'] = "j00 caNNo+ d3lE+3 P0\$+5 1N Thi5 Ph0Ld3r";

// Editing things (edit.php, edit_poll.php) -----------------------------------------

$lang['nomessagespecifiedforedit'] = "n0 M3sS4GE spEc1ph13D pH0r eD1t1n9";
$lang['cannoteditpollsinlightmode'] = "cAnN0+ eDI+ pOll\$ 1n L1gH+ m0De";
$lang['editedbyuser'] = "edItEd: %s 8y %s";
$lang['successfullyeditedpost'] = "sUCC3S\$pHulLy 3DI+Ed P0\$t %s";
$lang['errorupdatingpost'] = "eRR0r UpD4t1nG P0\$t";
$lang['editmessage'] = "eD1+ Me\$s@93 %s";
$lang['editpollwarning'] = "<b>n0+3</b>: 3D1+1N9 CeR+4In @SPeC+\$ OF 4 P0lL wIll V01D 4LL +HE CUrREn+ v0TEs 4nd 4lLow P30pl3 t0 Vot3 49ain.";
$lang['hardedit'] = "h4rD eD1+ 0PT1ON\$ (VotEs wiLl b3 R353T):";
$lang['softedit'] = "s0pH+ eD1T 0p+10n5 (v0+35 WILl B3 r3T4inEd):";
$lang['changewhenpollcloses'] = "cH4nG3 WHen thE pOLL CL0sEs?";
$lang['nochange'] = "n0 CH@n93";
$lang['emailresult'] = "eM41L R3SUL+";
$lang['msgsent'] = "mES5ag3 SENt";
$lang['msgsentsuccessfully'] = "mE\$\$49e \$3nT sUcC35\$pHulLY.";
$lang['mailsystemfailure'] = "mAiL 5YSt3M ph4ILurE. m3s5@93 n0T \$3N+.";
$lang['nopermissiontoedit'] = "j00 @R3 N0+ pErmI+tED +o eD1+ +h1s Mes\$@9E.";
$lang['cannoteditpostsinthisfolder'] = "j00 c4nNOT Ed1+ P0ST5 1N +h1s PH0Ld3r";
$lang['messagewasnotfound'] = "m3s\$4Ge %s W4S NOT PHouNd";

// Email (email.php) ---------------------------------------------------

$lang['sendemailtouser'] = "seND em@1L +o %s";
$lang['nouserspecifiedforemail'] = "n0 US3R \$PEcIFiED foR EM4ILIN9.";
$lang['entersubjectformessage'] = "eNT3r @ su8jEcT pHor TH3 M3s\$A9E";
$lang['entercontentformessage'] = "entER 5OME C0NTEnt phoR +H3 M3s\$493";
$lang['msgsentfromby'] = "thIs MeS54g3 W45 SeN+ FROm %s 8Y %s";
$lang['subject'] = "sU8j3C+";
$lang['send'] = "s3nD";
$lang['userhasoptedoutofemail'] = "%s h@s 0pTeD ou+ 0PH Em4il C0NT@c+";
$lang['userhasinvalidemailaddress'] = "%s H4\$ 4n inValId 3M4IL @DDRe\$s";

// Message nofificaiton ------------------------------------------------

$lang['msgnotification_subject'] = "mESS49e N0+1pH1C4T1oN PHr0m %s";
$lang['msgnotificationemail'] = "h3Llo %s,\n\n%s POST3D @ m35s@9E T0 J00 0N %s.\n\nth3 SuBJ3C+ is: %s.\n\nt0 Re4D +h4t M35s@93 4nD 0thEr5 iN T3H \$@M3 d1ScUS\$ION, G0 +O:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nnOT3: IPH J00 D0 NO+ W1sH +o ReC3iV3 3m4IL N0T1PhIc4+10NS 0pH PhoRUm Me\$\$4G3s P0S+3D +O Y0u, 9o +0: %s cL1cK 0n My c0n+roL\$ Then 3m4IL 4ND PR1V@Cy, UNSElEC+ th3 Em@1L nOtiPH1c@TIOn cheCK8ox 4nd PR3ss SU8Mi+.";

// Thread Subscription notification ------------------------------------

$lang['threadsubnotification_subject'] = "sUB\$CRipTIOn NotIph1C4+10N PhR0m %s";
$lang['threadsubnotification'] = "h3ll0 %s,\n\n%s POStED @ mESS4G3 In 4 +Hr3@d J00 4r3 \$u8\$CRIb3D t0 0n %s.\n\nth3 5u8JEct i5: %s.\n\n+o R34D +hA+ M3sS493 4ND 0TH3RS 1N tEh \$@m3 dI5Cu\$si0n, Go To:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nn0tE: iPh j00 DO No+ wI\$h T0 R3C3ivE 3m41L nOTiPH1C4tIon\$ oph n3w M3ss4g3s 1N +hI5 tHR34d, GO T0: %s 4ND @DJUsT YOUr iNTerE5t l3vEL @t +He 80t+0M 0pH TH3 PaGe.";

// Folder Subscription notification ------------------------------------

$lang['foldersubnotification_subject'] = "su8\$cRIp+I0n N0tIPHiC4T1oN fR0M %s";
$lang['foldersubnotification'] = "h3LL0 %s,\n\n%s p0\$+Ed 4 M3SS49e 1N 4 PH0Ld3r J00 4rE \$U8sCrIb3d T0 0N %s.\n\n+h3 5u8jEC+ 1S: %s.\n\nt0 R34D +h4T mE\$S49e 4Nd 0+HeR5 1N +hE 54m3 Di5cU\$S10n, go t0:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nnoT3: Iph J00 Do N0t WISH t0 R3c31v3 eMAil NotIF1C@T1oN5 oPH N3w M3sS@9eS IN thiS THr34d, gO T0: %s @nD @dJUST yOUr inT3re\$+ LEv3L 8y Cl1ck1NG On +EH FolD3R's Ic0N 4t +3h +0p 0f P493.";

// PM notification -----------------------------------------------------

$lang['pmnotification_subject'] = "pM NOTiPH1C4+10n phR0m %s";
$lang['pmnotification'] = "h3lL0 %s,\n\n%s pOSt3D A pM tO j00 0n %s.\n\ntH3 \$ubJEcT is: %s.\n\nT0 R34D +h3 M3s\$49e 90 +O:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nn0+3: 1f j00 do noT W1sh tO r3c31vE 3M@Il N0+1F1c@t1OnS of N3W Pm M3SS493\$ p0\$+3d +0 YOU, GO +o: %s CliCK my C0n+r0LS tH3n eM41L @nd Priv4cY, UNS3lEct TEh pM NOT1Ph1CA+ion CHeCK8ox 4nD PRE\$\$ \$u8mi+.";

// Password change notification ----------------------------------------

$lang['passwdchangenotification'] = "pa\$5WORd ChaNGe N0TIFiC4tIon phR0m %s";
$lang['pwchangeemail'] = "h3lLo %s,\n\ntH1S A NotIPH1C4+10n 3M@Il +O inPH0RM j00 TH@+ y0ur P4\$\$w0RD oN %s H4s b3EN Ch4n9ED.\n\n1+ ha\$ b33N ch@Ng3d +O: %s 4nD w4\$ cH4N9eD 8Y: %s.\n\n1F J00 HAVe R3c31v3D tHIS eM4iL iN 3RR0R 0r weRE n0t 3xpEcTiN9 4 cH@N93 T0 YOuR p4\$\$w0rD pLe4\$e CONT@cT +3h FORum oWNEr oR 4 M0D3r4+oR 0n %s ImMEd14TeLy +O C0RR3CT IT.";

// Email confirmation notification -------------------------------------

$lang['emailconfirmationrequiredsubject'] = "eM@IL Conf1RM4+10n Requ1reD PH0R %s";
$lang['confirmemail'] = "h3LLO %s,\n\nyOu Rec3ntLy crE@TEd @ N3w uSER 4ccoUnt on %s.\n\nB3forE J00 C@N \$+4r+ P0S+1N9 W3 N33D +o conFiRm Y0Ur Em41L 4DdReS\$. D0N'+ w0rRy +h1s 15 QUi+E 34SY. @ll j00 N33D T0 dO 1s cl1CK +H3 LInk 8EloW (or C0pY 4ND P4\$te 1+ 1N+O yOur bROw\$3R):\n\n%s\n\n0NC3 conPH1rM4+10N iS cOmPL3tE j00 M4y L0gIN @nD 5t4r+ P0sT1n9 imMEDi@tely.\n\niPH J00 D1d N0t CreA+E @ USer 4CcouN+ ON %s PLe@S3 @cC3pT OUR @p0l091e5 4nD FORward +H1\$ 3M41l +o %s \$O th@T THe s0URce OPH i+ M4y bE INv3s+1Ga+3d.";
$lang['confirmchangedemail'] = "hELL0 %s,\n\nyOu ReCenTly cH4n93D YoUR 3M41L ON %s.\n\nB3PH0rE J00 C4n s+Ar+ p05+1n9 ag@1n w3 n3ED tO cOnfIRM y0UR nEW Em41l 4DdR3\$s. DON't w0RRY Th1\$ 15 qU1T3 34\$y. @LL j00 N3ED to dO is cL1CK +HE l1nk 8EL0w (or COpy 4ND P@ST3 1t INT0 YOUr BroW\$3r):\n\n%s\n\n0Nc3 C0NFIRm@+10n I\$ C0MpL3TE J00 mAY cONT1NUE +O u\$e +H3 F0rUM 4\$ N0rM4l.\n\n1f j00 w3rE NOT 3xPECt1NG THIS 3m4iL FRom %s PL34S3 @cCEPT ouR @POLogiES @Nd PHORW@Rd +H15 Em@il +O %s sO +H@T THe S0UrC3 oF IT MAy 8E INV3s+I9ATed.";

// Forgotten password notification -------------------------------------

$lang['forgotpwemail'] = "hELL0 %s,\n\nyOU R3qU3\$TED +HIs e-M@1L FRoM %s 83C@U5E j00 h4vE F0R90t+eN YOUR P4SSw0Rd.\n\ncL1CK +He lInk 8ELOW (Or c0py 4nD p45+E iT In+O Y0Ur 8rOw\$Er) +O rEsE+ y0uR p@\$\$w0RD:\n\n%s";

// Admin New User Approval notification -----------------------------------------

$lang['newuserapprovalsubject'] = "n3w U5ER 4PPROv4l N0tIPh1c4t1oN Ph0r %s";
$lang['newuserapprovalemail'] = "Hello %s,\n\nA new user account has been created on %s.\n\nAs you are an Administrator of this forum you are required to approve this user account before it can be used by it's owner.\n\nTo approve this account please visit the Admin Users section and change the filter type to \"Users Awaiting Approval\"oR cL1CK tH3 Link 8el0W:\n\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nn0t3: OTh3R @dMIni5+r4t0Rs ON +H1s f0rUm wiLl 4L5o r3c31v3 Th1\$ N0TIPh1cA+10N @Nd M@y h4ve 4lrE4DY 4c+3d uPON +HIS rEQu3S+.";

// Admin New User notification -----------------------------------------

$lang['newuserregistrationsubject'] = "n3W U53r 4Cc0uNT N0TipH1C4t1ON foR %s";
$lang['newuserregistrationemail'] = "h3lL0 %s,\n\n@ N3W USeR 4Cc0un+ H@s 83EN crE@tEd On %s.\n\nto v1Ew thI5 U\$3r @CC0UN+ pLeas3 VI51+ t3H @DMin u5erS 53CT1ON AND Cl1Ck ON T3h neW us3r or cl1CK +HE lINK 83l0w:\n\n%s";

// User Approved notification ------------------------------------------

$lang['useraccountapprovedsubject'] = "us3R 4PPRov4l not1ph1cA+Ion PH0R %s";
$lang['useraccountapprovedemail'] = "heLLO %s,\n\ny0UR usEr 4CcounT @+ %s h@S 83EN 4PPROv3d. J00 C4N L09iN ANd St4R+ P05+1NG ImM3D14+ELy by CL1CKiNG Th3 lINK 83low:\n\n%s\n\niF J00 W3R3 N0t 3Xp3C+INg Thi5 EM41l fROM %s PL34\$e @cc3PT ouR 4p0l09i3\$ 4nD f0RW4RD tH1S 3m41l T0 %s S0 +H4T +hE SoURce 0ph 1+ M4y 83 INVE5+1g@TEd.";

// Admin Post Approval notification -----------------------------------------

$lang['newpostapprovalsubject'] = "poS+ 4pPR0v4L NOTIfICa+ion phOR %s";
$lang['newpostapprovalemail'] = "hElLO %s,\n\n4 NEW po5+ h@S 83EN CrE@tEd ON %s.\n\n4\$ J00 ARe @ MOd3R@TOR ON Th15 f0RUM j00 4r3 rEqU1rEd +o APPRoVE tH1S P05+ 83F0RE iT C4N b3 Re4D 8y otHer us3Rs.\n\nyOu c@n apProVe Th1S P0\$T and 4nY 0TH3R\$ Pendin9 apPR0V@L 8Y V151+iNG teH 4dm1n P0St @pPROV4l \$3CTION 0F YoUR PH0Rum OR by ClIcK1Ng +eH LINK 83lOw:\n\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nnoTE: O+Her 4Dm1NI5+r4+Or5 On +HIS PHORum will @LSO R3C31Ve +H15 N0T1PHIc@+ION @nd m@Y h4v3 4Lre4DY @c+Ed UPON th15 ReqUES+.";

// Forgotten password form.

$lang['passwdresetrequest'] = "y0uR p@SSW0Rd R3sE+ R3Qu3ST fR0M %s";
$lang['passwdresetemailsent'] = "p45\$W0rD r353+ e-MAil SenT";
$lang['passwdresetexp'] = "j00 5hoUlD shOr+LY rECeiVe 4N 3-MaiL COn+4IN1n9 1nSTrUC+iOns PH0R r3SE++1n9 YOur P4s\$WoRd.";
$lang['validusernamerequired'] = "a V4LID u5erN4me 1\$ reQU1r3D";
$lang['forgottenpasswd'] = "f0rGOt p@ssWORd";
$lang['couldnotsendpasswordreminder'] = "couLD nOT \$3nD p@S\$W0RD r3m1nd3r. pl34\$3 COn+4c+ tHe FORuM OwNEr.";
$lang['request'] = "rEQuE\$+";

// Email confirmation (confirm_email.php) ------------------------------

$lang['emailconfirmation'] = "em@1l cONPh1RM4+10n";
$lang['emailconfirmationcomplete'] = "tH4nK J00 PH0R cONph1RMIn9 YOUR Em41L 4DDrESS. j00 M4Y NOW Lo9iN AnD ST4R+ p05+1n9 imMeDI4TelY.";
$lang['emailconfirmationfailed'] = "em4il C0NFIRM@t1oN H4S PhaIlED, pLe4s3 +ry ag@1n l@t3r. 1PH J00 ENc0untEr +H1\$ ERROr MuLTIPl3 TimEs PL34sE C0n+@C+ T3h forUm Own3R or @ MOd3r@T0R foR 4\$s1\$t4nCE.";

// Links database (links*.php) -----------------------------------------

$lang['toplevel'] = "toP lEVEl";
$lang['maynotaccessthissection'] = "j00 m4Y NOt 4CC3SS th1s \$3C+10n.";
$lang['toplevel'] = "t0p LEvEl";
$lang['links'] = "linK\$";
$lang['externallink'] = "eX+3rN@l l1NK";
$lang['viewmode'] = "vIew m0d3";
$lang['hierarchical'] = "hIEr4rCHic@L";
$lang['list'] = "lI5T";
$lang['folderhidden'] = "tHIS FOlD3R IS H1DD3N";
$lang['hide'] = "hid3";
$lang['unhide'] = "unHiDe";
$lang['nosubfolders'] = "n0 su8fOLDEr\$ 1n +HI5 ca+egORY";
$lang['1subfolder'] = "1 \$uBf0LD3R 1N Th15 C@tE90RY";
$lang['subfoldersinthiscategory'] = "sUBPHoLDeRS 1N THis c4tE90rY";
$lang['linksdelexp'] = "eN+rIE\$ in @ D3LE+Ed PH0Ld3r W1Ll B3 m0vED t0 +He P4reN+ f0lD3R. oNLY fOLdERs Wh1ch dO n0+ C0n+@1N 5ubPHOlDEr5 m4Y bE D3LeTEd.";
$lang['listview'] = "lisT V13w";
$lang['listviewcannotaddfolders'] = "c@nnot AdD FOlD3R\$ IN +His VI3W. shOWiNG 20 3N+R13s 4T A +1mE.";
$lang['rating'] = "r@+1nG";
$lang['nolinksinfolder'] = "nO L1NK5 in THiS FolD3r.";
$lang['addlinkhere'] = "add l1nk HEr3";
$lang['notvalidURI'] = "tH@t i\$ N0t a vaL1d urI!";
$lang['mustspecifyname'] = "j00 MUST SP3CipHy @ n@mE!";
$lang['mustspecifyvalidfolder'] = "j00 mU\$+ SPeC1PHy @ v@l1d phoLD3R!";
$lang['mustspecifyfolder'] = "j00 MUs+ \$PEc1fY @ f0LDeR!";
$lang['successfullyaddedlinkname'] = "succ35\$pHUlLY aDD3D L1NK '%s'";
$lang['failedtoaddlink'] = "f41Led T0 ADD L1NK";
$lang['failedtoaddfolder'] = "f4IL3D T0 4Dd FOlD3R";
$lang['addlink'] = "aDD A l1nk";
$lang['addinglinkin'] = "adDiNg L1NK 1N";
$lang['addressurluri'] = "aDDRE\$\$";
$lang['addnewfolder'] = "aDd A NEw FOlD3r";
$lang['addnewfolderunder'] = "aDd1ng NeW PhoLdER uNDeR";
$lang['editfolder'] = "eDI+ f0Ld3r";
$lang['editingfolder'] = "ed1+1ng ph0LdER";
$lang['mustchooserating'] = "j00 mu\$+ cHo0\$e @ r@T1N9!";
$lang['commentadded'] = "yOUR cOMmENT W@5 4dD3D.";
$lang['commentdeleted'] = "cOMMeNT W4\$ D3LEt3d.";
$lang['commentcouldnotbedeleted'] = "c0mm3N+ COuLd NOt B3 dEle+Ed.";
$lang['musttypecomment'] = "j00 Mu\$+ +yPe 4 COmm3n+!";
$lang['mustprovidelinkID'] = "j00 Mu\$+ PRov1DE @ L1NK 1D!";
$lang['invalidlinkID'] = "iNV4lId L1NK ID!";
$lang['address'] = "adDR3s\$";
$lang['submittedby'] = "suBM1T+3D BY";
$lang['clicks'] = "cl1ck\$";
$lang['rating'] = "rA+in9";
$lang['vote'] = "vo+3";
$lang['votes'] = "voTES";
$lang['notratedyet'] = "nO+ R4T3D 8Y @NY0Ne y3+";
$lang['rate'] = "r4T3";
$lang['bad'] = "b@d";
$lang['good'] = "g0oD";
$lang['voteexcmark'] = "vo+E!";
$lang['clearvote'] = "cleaR vOte";
$lang['commentby'] = "c0mmENt By %s";
$lang['addacommentabout'] = "adD 4 coMM3N+ 4b0u+";
$lang['modtools'] = "m0deR4+10n +0OlS";
$lang['editname'] = "edi+ naMe";
$lang['editaddress'] = "eDiT 4DdR3\$s";
$lang['editdescription'] = "eD1+ D3sCRIP+10n";
$lang['moveto'] = "movE +O";
$lang['linkdetails'] = "link D3T41L5";
$lang['addcomment'] = "aDD cOmm3NT";
$lang['voterecorded'] = "y0uR vot3 h@S 83eN rECORdEd";
$lang['votecleared'] = "yOuR v0tE H@s 833n cl34reD";
$lang['linknametoolong'] = "lINk NAm3 +o0 L0NG. M@XIMuM 1\$ %s Ch4R@C+3rS";
$lang['linkurltoolong'] = "l1nK Url t0O loNg. M@x1Mum 1\$ %s cH@R4Ct3rs";
$lang['linkfoldernametoolong'] = "f0LD3R NaM3 +OO LOn9. m4XImUM L3N9+H I\$ %s ch@R4C+erS";

// Login / logout (llogon.php, logon.php, logout.php) -----------------------------------------

$lang['loggedinsuccessfully'] = "j00 L09GeD In 5UCc3\$sPHuLLy.";
$lang['presscontinuetoresend'] = "pRE\$\$ c0ntINu3 To R3SENd Phorm D4+@ OR CAnC3l +O R3L04d p49E.";
$lang['usernameorpasswdnotvalid'] = "tHE us3rn@mE OR P@\$SWorD j00 5uppL1Ed iS N0T v@l1d.";
$lang['youhavesuccessfullyloggedout'] = "j00 H4V3 suCCeS5phUlly L09gED 0u+.";
$lang['rememberpasswds'] = "r3M3m83r p4\$sW0rdS";
$lang['rememberpassword'] = "r3M3m83r P4\$sW0RD";
$lang['logmeinautomatically'] = "l0g Me 1N @utOM4T1C4lLy";
$lang['enterasa'] = "en+ER @s 4 %s";
$lang['donthaveanaccount'] = "doN't h@Ve 4n AccoUN+? %s";
$lang['registernow'] = "r391\$+3r Now";
$lang['problemsloggingon'] = "pR08L3M\$ l09GINg 0N?";
$lang['deletecookies'] = "delE+3 co0k13S";
$lang['cookiessuccessfullydeleted'] = "cO0K13s 5UcCeS\$fUlLy D3L3TEd";
$lang['forgottenpasswd'] = "f0R90TT3N yoUr P@Ssw0RD?";
$lang['usingaPDA'] = "u\$1n9 4 Pd4?";
$lang['lightHTMLversion'] = "lIGH+ HtmL v3r\$iON";
$lang['logonbutton'] = "l090N";
$lang['otherdotdotdot'] = "otHER...";
$lang['yoursessionhasexpired'] = "yoUR \$3SS10N h4\$ exPIRED. J00 W1LL n33D +0 L09IN Ag@1N +0 c0nTiNU3.";

// My Forums (forums.php) ---------------------------------------------------------

$lang['myforums'] = "my fORUmS";
$lang['allavailableforums'] = "aLl @V@IlA8lE fORUmS";
$lang['favouriteforums'] = "f4voURIt3 FoRuM5";
$lang['ignoredforums'] = "i9n0r3D PHorUms";
$lang['ignoreforum'] = "i9nORe PH0Rum";
$lang['unignoreforum'] = "unI9n0RE f0rUm";
$lang['lastvisited'] = "la\$+ v1\$1t3d";
$lang['forumunreadmessages'] = "%s UnR3@d MesS@9eS";
$lang['forummessages'] = "%s MES\$A9E\$";
$lang['forumunreadtome'] = "%s unr3ad &quot;t0: ME&quot;";
$lang['forumnounreadmessages'] = "nO UNR34d m3\$\$a9e\$";
$lang['removefromfavourites'] = "r3m0v3 FroM PH4V0UR1+3s";
$lang['addtofavourites'] = "aDd +0 FAv0urITeS";
$lang['availableforums'] = "av@1l4Bl3 F0RumS";
$lang['noforumsofselectedtype'] = "tH3re 4rE No ForUm5 0ph +Eh 5EL3C+ED tYp3 av@1l@8lE. pL34SE sEL3Ct A diPhpHerEnT +YPE.";
$lang['successfullyaddedforumtofavourites'] = "sUCcessFuLLY @Dd3D ph0RUM tO FaV0uRITE\$.";
$lang['successfullyremovedforumfromfavourites'] = "sUcC35\$pHULlY rEmov3d Ph0ruM PhROM ph4V0URIT3s.";
$lang['successfullyignoredforum'] = "suCC3sSFUlLY 19N0r3d PH0RUm.";
$lang['successfullyunignoredforum'] = "sucCes\$pHUlLY uN19n0r3d PH0rUm.";
$lang['failedtoupdateforuminterestlevel'] = "f4iL3D t0 upd4tE F0Rum inT3Re\$t lEv3l";
$lang['noforumsavailablelogin'] = "tH3rE 4rE N0 PHORUm\$ 4v41L@bLE. Pl3453 lo9IN +o VieW yoUr FOruM5.";
$lang['passwdprotectedforum'] = "p4\$\$W0rD PRot3CT3D PHOrUM";
$lang['passwdprotectedwarning'] = "tH1\$ pH0Rum i\$ P@s5w0RD pROtEC+3d. T0 94iN 4CcES\$ enT3R +hE P4SSw0rD belOW.";

// Message composition (post.php, lpost.php) --------------------------------------

$lang['postmessage'] = "p0\$+ ME5S@93";
$lang['selectfolder'] = "sEl3cT FoLDer";
$lang['mustenterpostcontent'] = "j00 mu\$+ En+3r \$om3 coN+3Nt phoR +h3 PO5t!";
$lang['messagepreview'] = "m3\$s@9E Pr3v13W";
$lang['invalidusername'] = "invALId U\$erN4m3!";
$lang['mustenterthreadtitle'] = "j00 mu5+ eNt3R @ +1+Le PHOr THe THr34D!";
$lang['pleaseselectfolder'] = "pL34\$3 5EL3C+ 4 Fold3r!";
$lang['errorcreatingpost'] = "eRr0r cR34+1nG POsT! pL34s3 TRy Ag41n IN @ f3w M1nU+3S.";
$lang['createnewthread'] = "cre4+3 N3w +hr34D";
$lang['postreply'] = "p05T R3PLY";
$lang['threadtitle'] = "tHrEAd t1+Le";
$lang['foldertitle'] = "f0lD3r TItl3";
$lang['messagehasbeendeleted'] = "meS\$493 N0T PHoUNd. cHEcK +h@t i+ hA\$n'+ b3En DEl3tEd.";
$lang['messagenotfoundinselectedfolder'] = "mESS4gE nOT pHOunD iN \$EL3C+3D f0LdEr. cHEcK Th@T It H4sN'+ b33N MOveD 0r D3letEd.";
$lang['cannotpostthisthreadtypeinfolder'] = "j00 C@Nn0t pO5+ +h15 THrE@d Typ3 IN tH4T f0lDeR!";
$lang['cannotpostthisthreadtype'] = "j00 C4NN0T p0\$+ +H1\$ ThrE4D +ypE a\$ THeR3 Ar3 No @V@iL4BlE phOlDEr5 Th4+ aLLow it.";
$lang['cannotcreatenewthreads'] = "j00 c4Nn0t CR3a+3 n3W ThR34D\$.";
$lang['threadisclosedforposting'] = "thI\$ Thr3@D 15 cl0s3D, J00 cANNOT POST IN 1T!";
$lang['moderatorthreadclosed'] = "w4rNINg: +hiS thre4D i\$ Cl0S3D Ph0r PO5+1n9 To N0RMAl UsERS.";
$lang['usersinthread'] = "uSer5 iN +hr3@D";
$lang['correctedcode'] = "c0rrEcTED C0D3";
$lang['submittedcode'] = "su8M1++3D coDe";
$lang['htmlinmessage'] = "htMl 1N M3Ssa9e";
$lang['disableemoticonsinmessage'] = "di5@BLe 3m0+1C0ns 1N M3SS@G3";
$lang['automaticallyparseurls'] = "aU+0M4+Ic@LLY P4RSe Url\$";
$lang['automaticallycheckspelling'] = "autOMA+1C@LLY CHeCk \$peLL1n9";
$lang['setthreadtohighinterest'] = "s3T +hr34d tO high 1ntErE\$T";
$lang['enabledwithautolinebreaks'] = "ena8lEd W1th @Ut0-LIN3-BrE@ks";
$lang['fixhtmlexplanation'] = "tHI\$ FOrUM US35 HTML pHiLt3R1NG. y0ur 5u8mi+TED HtmL h4s b33n MOdIPHi3d 8Y th3 FilT3rS iN sOM3 waY.\\n\\nto viEw Y0uR 0r1giN@l c0de, S3LeCT +3H \\'5U8M1+T3D C0d3\\' r4DIo bUT+0N.\\n+O vIew +3H M0DipH1Ed codE, 53l3C+ +H3 \\'C0rr3C+3D c0d3\\' rAD1o 8UTt0N.";
$lang['messageoptions'] = "m35\$49E oP+10Ns";
$lang['notallowedembedattachmentpost'] = "j00 @R3 NOT alL0w3D +o 3M83D @T+4CHMEn+s 1N yoUR pO\$T\$.";
$lang['notallowedembedattachmentsignature'] = "j00 @R3 N0+ 4lL0w3d t0 EM83D 4+T4CHmENT\$ 1N YoUr s1Gn4turE.";
$lang['reducemessagelength'] = "m3\$\$a9e L3N9+H MUsT b3 UNd3r 65,535 ch4R@c+3RS (CUrrEn+ly: %s)";
$lang['reducesiglength'] = "s19N@+ur3 L3nG+H Mu\$t bE uNd3r 65,535 ch@R4C+eRs (cUrrEntLy: %s)";
$lang['cannotcreatethreadinfolder'] = "j00 C4NNOt Cr34tE n3W ThrE@D\$ 1N Thi5 fOld3r";
$lang['cannotcreatepostinfolder'] = "j00 c4NNot RePLY +o pos+S 1N THis fOlD3R";
$lang['cannotattachfilesinfolder'] = "j00 caNn0T pO5t @++4ChmEnTs in +h1\$ F0Ld3r. r3m0v3 4TT@CHM3N+\$ +O c0N+InU3.";
$lang['postfrequencytoogreat'] = "j00 CAN oNly POS+ 0nCE EV3Ry %s 5eCONd5. PLeA\$3 +RY 4941n lA+3r.";
$lang['emailconfirmationrequiredbeforepost'] = "em41l CONfiRm@T1ON 1S ReQU1reD 83F0R3 J00 C@n PoST. 1F j00 H4VE n0t RecE1VEd A c0NF1rM4ti0n 3M41l PlE4sE CL1CK +h3 bUT+on b3l0w anD A nEw 0n3 WiLL b3 sEnT +o yoU. IF yOuR em4IL 4dDRES\$ NeEd5 Ch4ng1N9 PLe@Se D0 S0 8EFOR3 R3qU35+1N9 @ NEw COnpH1Rm4T1ON EM@1l. J00 m4y Ch4Nge y0uR 3mA1l @DdRE\$\$ bY Cl1ck MY cON+rOLs 48ove 4nD +H3n U53r D3T41l\$";
$lang['emailconfirmationfailedtosend'] = "c0NF1rM4T10N EM@1l F@1L3d T0 5eNd. pL34S3 C0NT@C+ +3h phoRuM 0wn3r t0 R3C+1fY THiS.";
$lang['emailconfirmationsent'] = "c0nF1RM4TIOn 3m@1L h@5 b3En R3sEn+.";
$lang['resendconfirmation'] = "rEseND C0NPH1Rm4tiON";
$lang['userapprovalrequiredbeforeaccess'] = "y0ur U53r @ccoUN+ N33DS T0 83 @ppR0v3D bY @ F0RUM 4Dm1n B3F0RE j00 C4N @cCe\$s T3h REqU35+Ed foRuM.";
$lang['reviewthread'] = "rEvi3W tHRe4d";
$lang['reviewthreadinnewwindow'] = "r3vIew eNtiRE tHReaD IN NEw WInD0W";

// Message display (messages.php & messages.inc.php) --------------------------------------

$lang['inreplyto'] = "iN rEPly +0";
$lang['showmessages'] = "sh0w M3sS4G3\$";
$lang['ratemyinterest'] = "r4T3 my INT3R3sT";
$lang['adjtextsize'] = "adjus+ tEX+ 5IZ3";
$lang['smaller'] = "sm4llER";
$lang['larger'] = "laR9Er";
$lang['faq'] = "f@Q";
$lang['docs'] = "d0Cs";
$lang['support'] = "suPp0rt";
$lang['donateexcmark'] = "d0n4te!";
$lang['fontsizechanged'] = "font SIZ3 cH4ngED. %s";
$lang['framesmustbereloaded'] = "fR4mES mU\$+ bE rEl04dED m@nU@lLY to \$33 cH@Ng3s.";
$lang['threadcouldnotbefound'] = "th3 R3QuEStED +HR34D cOUlD n0+ be FoUNd 0r Acc3S\$ w@S d3ni3D.";
$lang['mustselectpolloption'] = "j00 MUSt \$3l3C+ 4N op+10N +o Vot3 phOr!";
$lang['mustvoteforallgroups'] = "j00 MUS+ Vo+3 1N eV3RY GROuP.";
$lang['keepreading'] = "k33P R3AdING";
$lang['backtothreadlist'] = "b4CK +O ThRE4D L1s+";
$lang['postdoesnotexist'] = "th@+ POST D03s NO+ ex15t In +HIs +hR34D!";
$lang['clicktochangevote'] = "cLiCk TO cH4N93 V0T3";
$lang['youvotedforoption'] = "j00 V0tED Phor Op+10n";
$lang['youvotedforoptions'] = "j00 Vo+Ed pH0R 0pTioN\$";
$lang['clicktovote'] = "cl1cK +o VOT3";
$lang['youhavenotvoted'] = "j00 H@ve no+ V0+ed";
$lang['viewresults'] = "v13w rE5UL+5";
$lang['msgtruncated'] = "m3ss4g3 +RunCa+3d";
$lang['viewfullmsg'] = "vieW FuLL MEs\$49e";
$lang['ignoredmsg'] = "ignoReD m35\$49E";
$lang['wormeduser'] = "w0RM3D U5ER";
$lang['ignoredsig'] = "iGN0REd SI9N@tURe";
$lang['messagewasdeleted'] = "m35\$4gE %s.%s W4\$ d3l3T3D";
$lang['stopignoringthisuser'] = "s+op i9n0RINg Th1S uS3R";
$lang['renamethread'] = "rEN@mE tHREaD";
$lang['movethread'] = "m0vE thRE4D";
$lang['torenamethisthreadyoumusteditthepoll'] = "t0 rEnAMe Th1\$ thre4d J00 mUSt 3DI+ +H3 poll.";
$lang['closeforposting'] = "cl053 PHor poStiN9";
$lang['until'] = "uN+1l 00:00 UtC";
$lang['approvalrequired'] = "appr0V@l r3qUir3D";
$lang['messageawaitingapprovalbymoderator'] = "m35\$4gE %s.%s I5 4W41+1n9 APPrOVaL 8Y @ M0d3R@t0r";
$lang['successfullyapprovedpost'] = "sUCc35\$PHuLly @Pprov3d PO\$+ %s";
$lang['postapprovalfailed'] = "p0S+ 4Ppr0V@L ph41l3D.";
$lang['postdoesnotrequireapproval'] = "p0\$+ d0eS n0t rEqU1r3 AppR0v@L";
$lang['approvepost'] = "aPpROV3 PO5+";
$lang['approvedbyuser'] = "apPROV3D: %s 8Y %s";
$lang['makesticky'] = "m@KE 5+iCky";
$lang['messagecountdisplay'] = "%s 0F %s";
$lang['linktothread'] = "perM4n3n+ LiNk t0 +H1S +HR34D";
$lang['linktopost'] = "l1nk +o posT";
$lang['linktothispost'] = "l1nk t0 +HIS POS+";
$lang['imageresized'] = "this 1m4ge HA\$ 83EN rESIZ3D (oR19iN4l \$1z3 %1\$Sx%2\$5). +0 VI3W TeH fUlL-s1zE IM49e cLIcK h3R3.";
$lang['messagedeletedbyuser'] = "mES\$49e %s.%s DEl3T3D %s By %s";
$lang['messagedeleted'] = "m3ss49E %s.%s W4\$ D3l3tEd";
$lang['viewinframeset'] = "vIeW 1n Fr@ME\$e+";
$lang['pressctrlentertoquicklysubmityourpost'] = "pR3s\$ CTrL+eNTeR T0 qu1CKly 5U8m1t yOur P05t";
$lang['invalidmsgidornomessageidspecified'] = "invAL1D m3s54gE 1D 0r n0 Me\$\$49E ID 5P3C1fIEd.";

// Moderators list (mods_list.php) -------------------------------------

$lang['cantdisplaymods'] = "c@nN0t D1spl@Y FOlDer MoDer4t0R\$";
$lang['moderatorlist'] = "m0D3R4T0R L1\$+:";
$lang['modsforfolder'] = "moDEr4toR\$ f0R Ph0lDER";
$lang['nomodsfound'] = "n0 moDEr4T0RS founD";
$lang['forumleaders'] = "forUM leaDeR5:";
$lang['foldermods'] = "foLDER MOd3r@+0RS:";

// Navigation strip (nav.php) ------------------------------------------

$lang['start'] = "sT@RT";
$lang['messages'] = "meS\$49e\$";
$lang['pminbox'] = "iNB0x";
$lang['startwiththreadlist'] = "s+4r+ p493 Wi+H thr3ad l1\$+";
$lang['pmsentitems'] = "sEN+ 1tEmS";
$lang['pmoutbox'] = "oU+b0X";
$lang['pmsaveditems'] = "s4VeD I+3M\$";
$lang['pmdrafts'] = "dr4PH+S";
$lang['links'] = "liNkS";
$lang['admin'] = "aDm1n";
$lang['login'] = "l0g1n";
$lang['logout'] = "l090U+";

// PM System (pm.php, pm_write.php, pm.inc.php) ------------------------

$lang['privatemessages'] = "pr1V@+3 m3ss@93s";
$lang['recipienttiptext'] = "s3p4raT3 r3ciP13nts 8Y SeMI-COL0N or coMM4";
$lang['maximumtenrecipientspermessage'] = "tH3R3 I\$ 4 LIm1t 0F 10 R3C1P13Nts pEr MESS49E. Pl34sE @MeND y0UR r3c1p13n+ li5+.";
$lang['mustspecifyrecipient'] = "j00 MusT sP3CifY 4t LE@S+ oNe r3CIp13N+.";
$lang['usernotfound'] = "us3r %s N0+ FoUnD";
$lang['sendnewpm'] = "senD NEw PM";
$lang['saveselectedmessages'] = "s4vE \$3l3C+3D m3ss49e\$";
$lang['deleteselectedmessages'] = "d3lE+e s3LeCT3D Me\$s@93s";
$lang['exportselectedmessages'] = "eXP0RT \$eL3C+eD m3ss493s";
$lang['nosubject'] = "nO SUbjeCT";
$lang['norecipients'] = "nO ReC1PI3nts";
$lang['timesent'] = "tImE 53N+";
$lang['notsent'] = "nO+ S3N+";
$lang['errorcreatingpm'] = "eRR0R Cr34+1N9 Pm! pl3453 +Ry 4941n IN 4 F3W m1nU+e5";
$lang['writepm'] = "wRIT3 M3\$s4GE";
$lang['editpm'] = "eD1+ m3\$s4GE";
$lang['cannoteditpm'] = "c@NNOT 3DIt +his pM. 1T H4S AlRE@dY b3EN vI3weD bY +h3 REc1PiENT 0R +H3 m3S\$49E D03s n0t 3x15+ OR 1+ 1S in4CcE\$\$iBLe by j00";
$lang['cannotviewpm'] = "c4nnO+ vI3W Pm. M3SS@9e D03s N0T 3xI\$T 0r It 15 1n4CcE\$\$18l3 8Y J00";
$lang['pmmessagenumber'] = "m3S549e %s";

$lang['youhavexnewpm'] = "j00 H4VE %d N3w mE\$\$4Ges. W0ULd J00 l1K3 +o GO +0 y0ur 1N8OX N0W?";
$lang['youhave1newpm'] = "j00 H4Ve 1 New M35s49E. WouLD j00 LIk3 t0 Go to YoUr 1Nb0x N0W?";
$lang['youhave1newpmand1waiting'] = "j00 h@vE 1 NEW M3sS4G3.\n\nyOU aL5o h@Ve 1 mE\$s@93 aw@1+1n9 D3L1VERy. t0 R3C31vE +Hi\$ M3sS49E pL34s3 clE4r \$0M3 \$p4Ce 1n Y0UR 1N8Ox.\n\nwOULD J00 L1K3 T0 GO t0 Y0uR iN8OX nOW?";
$lang['youhave1pmwaiting'] = "j00 h4VE 1 mE\$\$4Ge @w@I+1N9 dEL1V3RY. +O rEc31VE +hI5 ME\$S49E Pl34SE CL3@R Som3 SP@Ce in y0ur 1nbOX.\n\nW0ULd J00 LikE +O go t0 yOur 1N80x NOw?";
$lang['youhavexnewpmand1waiting'] = "j00 H@V3 %d neW mE\$\$49E\$.\n\nY0U 4LSO h4v3 1 M3S\$49e 4w4i+InG D3LiVeRY. T0 R3C31ve +h1s M3SS49e pl34s3 cL34r \$OM3 5p4C3 1n yoUr 1Nb0x.\n\nw0uLd j00 l1K3 t0 GO t0 YOuR 1NB0x NoW?";
$lang['youhavexnewpmandxwaiting'] = "j00 H4vE %d N3W M35\$49E\$.\n\nyOu 4L\$o HaVE %d M3sS@9ES 4wait1n9 DeL1V3RY. +o ReC3IV3 +HEs3 Me55@9E Pl34S3 cLE@r 5OME sP4c3 1n Y0Ur 1nB0X.\n\nwould J00 LikE t0 90 +O y0UR iNBox n0W?";
$lang['youhave1newpmandxwaiting'] = "j00 H4vE 1 N3w mEssa9E.\n\nY0U 4l\$o H4Ve %d mES5A9E\$ @W41+1N9 DeLIV3Ry. TO R3C3IV3 Th3se mES5@93S pL34sE cL34r \$0M3 SP@cE IN yoUR In8ox.\n\nwoulD J00 LIke T0 go +O yOUr 1nb0x N0W?";
$lang['youhavexpmwaiting'] = "j00 Hav3 %d M3sS@9ES 4w41+1n9 DElIv3ry. +o R3C31vE TH35E mE\$S49e\$ PL34sE CL3Ar 5oMe 5P4C3 1N YouR iNbOX.\n\nwould J00 L1K3 T0 GO +0 y0uR iN8oX n0w?";

$lang['youdonothaveenoughfreespace'] = "j00 D0 N0T H4Ve 3nOUGH FrE3 5P4C3 TO S3nD +H1\$ M3sS493.";
$lang['userhasoptedoutofpm'] = "%s h4\$ 0pt3d OU+ oF ReCe1v1n9 P3RS0N4l m35\$493S";
$lang['pmfolderpruningisenabled'] = "pm phOLd3r PruNiN9 IS 3Na8LeD!";
$lang['pmpruneexplanation'] = "th1\$ f0rUM US3\$ PM pHolDeR prUN1N9. TeH M35\$4Ge\$ J00 H4Ve ST0ReD iN yoUr In8OX aNd \$ent 1t3mS\\npH0ld3Rs 4re SU8JeC+ t0 AutOM4T1C dEL3TI0N. anY mEs\$493s J00 W15h +o Ke3p 5HoUlD bE moVeD t0\\nyoUr \\'54VEd 1TEMs\\' folD3r S0 Th4T tHEy @rE N0T DELEt3d.";
$lang['yourpmfoldersare'] = "y0uR Pm F0ld3r\$ 4rE %s pHulL";
$lang['currentmessage'] = "cUrR3NT Me\$\$4Ge";
$lang['unreadmessage'] = "unrE4d M3sS493";
$lang['readmessage'] = "r3@D ME5s@93";
$lang['pmshavebeendisabled'] = "peR5on4l Me\$s@93s H@vE B3EN di\$4bLEd bY th3 foRuM OWN3R.";
$lang['adduserstofriendslist'] = "add U\$3RS +O YOuR Fr13Nd\$ L1ST +o h4v3 +HeM 4pPeaR 1N 4 drOp DoWn oN +EH Pm wr1+E mE5S49e P49E.";

$lang['messagewassuccessfullysavedtodraftsfolder'] = "me\$\$49e w45 SUCCesSPhULly S4VEd +0 'Dr4phTS' F0LDeR";
$lang['couldnotsavemessage'] = "c0uLd N0t 54ve mEssAgE. M4K3 5ur3 J00 h@vE enOuGh @V41l@8l3 PHR33 SP@c3.";
$lang['pmtooltipxmessages'] = "%s m3s\$49ES";
$lang['pmtooltip1message'] = "1 m3Ss49E";

$lang['allowusertosendpm'] = "alLow usEr +O SEND PEr5oNAl MEs5@GEs To M3";
$lang['blockuserfromsendingpm'] = "bl0cK U\$3R fR0M S3NdiNg PeRsON4L ME554G35 T0 M3";
$lang['yourfoldernamefolderisempty'] = "y0uR %s PH0ld3r 15 3mptY";
$lang['successfullydeletedselectedmessages'] = "suCcESSfULLy d3le+ED 53leC+3D M3S\$@gE\$";
$lang['successfullyarchivedselectedmessages'] = "sUCc3\$sFULlY @RcH1V3D sEl3ct3d mE55@93S";
$lang['failedtodeleteselectedmessages'] = "f41L3D tO DELe+3 S3LEc+ed M3SS4geS";
$lang['failedtoarchiveselectedmessages'] = "f41l3d +0 4RCH1Ve \$EL3C+3d M3\$s@G3S";
$lang['deletemessagesconfirmation'] = "aRe j00 sur3 J00 w4n+ to d3lETe @ll 0F Th3 \$3L3CT3D mEsS4GEs?";
$lang['youmustselectsomemessages'] = "j00 mu5+ Sel3CT 5OM3 MEsS493S To PR0C3sS";
$lang['successfullyrenamedfolder'] = "sUCcEs\$pHulLy ReN4MEd pHoLDeR";

// Preferences / Profile (user_*.php) ---------------------------------------------

$lang['mycontrols'] = "my c0ntrolS";
$lang['myforums'] = "my fORuMs";
$lang['menu'] = "m3nU";
$lang['userexp_1'] = "u\$e Teh MeNU oN +3h LeF+ +0 M4N49E y0UR 53t+INg5.";
$lang['userexp_2'] = "<b>uS3R d3t@IL\$</b> @ll0w\$ j00 TO cH4nGe YOUr N@m3, Em41L @ddre\$\$ 4nD p4Ssword.";
$lang['userexp_3'] = "<b>us3R PR0PH1L3</b> 4ll0w5 j00 T0 eDI+ yOUR u\$3r Pr0ph1L3.";
$lang['userexp_4'] = "<b>cH@N9E P4sSW0rd</b> aLl0w5 J00 +0 Ch4nG3 YouR P45\$W0RD";
$lang['userexp_5'] = "<b>emaIL &amp; PR1V@CY</b> Le+\$ J00 cH@n93 How j00 c@N bE coN+4C+3d ON @nd 0PHF TH3 f0rUM.";
$lang['userexp_6'] = "<b>fORUM 0ptION\$</b> L3T\$ J00 cH@N9E h0w +hE FORum loOK\$ 4Nd w0RK5.";
$lang['userexp_7'] = "<b>a+tAChMEnT5</b> @lloWs J00 TO 3DIt/DeLE+E yoUR 4+T@chM3NTS.";
$lang['userexp_8'] = "<b>sIgN4+UR3</b> lE+\$ J00 EDi+ Y0UR 51GN4TUr3.";
$lang['userexp_9'] = "<b>r3L@t1ON5hIP\$</b> lE+s J00 M4n493 y0UR R3l4TI0NSHiP W1+H 0+h3r Us3r5 0n +hE PH0Rum.";
$lang['userexp_9'] = "<b>wORD pH1lTeR</b> lE+S j00 3D1t yOUR p3R5ON@l W0Rd Ph1lt3R.";
$lang['userexp_10'] = "<b>tHr34d \$Ub\$cRip+ioN\$</b> alLow\$ j00 +O m@n49E Y0Ur THR3Ad SuB\$crIPTiON\$.";
$lang['userdetails'] = "u\$ER de+41LS";
$lang['userprofile'] = "u\$er ProPH1L3";
$lang['emailandprivacy'] = "eM@Il &amp; pR1V4CY";
$lang['editsignature'] = "ed1+ s1gn4tURe";
$lang['norelationshipssetup'] = "j00 H4V3 NO uS3r Rel4T10n\$h1p5 53t Up. 4Dd 4 N3w u53R bY sE@rch1n9 8eLow.";
$lang['editwordfilter'] = "eDi+ WorD FILT3r";
$lang['userinformation'] = "u\$eR 1NPh0rm4+Ion";
$lang['changepassword'] = "ch4NG3 P@s\$w0Rd";
$lang['currentpasswd'] = "cuRR3n+ p4s5WORd";
$lang['newpasswd'] = "n3W pa\$\$wORd";
$lang['confirmpasswd'] = "cONPh1Rm p4\$\$w0rD";
$lang['currentpasswdrequired'] = "curREn+ p4S\$WORd 1s rEqu1rEd";
$lang['newpasswdrequired'] = "nEW p@ssw0RD i\$ ReqUiREd";
$lang['confirmpasswordrequired'] = "c0npH1RM P@ssW0Rd 1s rEqUiRED";
$lang['currentpasswddoesnotmatch'] = "cURR3N+ pA\$\$W0RD dO35 n0t M4tCh S@V3d P4\$\$w0RD";
$lang['nicknamerequired'] = "n1Ckn@m3 1\$ R3QuiReD!";
$lang['emailaddressrequired'] = "em@il @DDre\$s Is rEQuiRed!";
$lang['logonnotpermitted'] = "l090n n0+ P3RM1t+eD. CH00\$e 4notHeR!";
$lang['nicknamenotpermitted'] = "n1ckn4Me n0T P3RM1+TeD. ChoO5E @N0TH3r!";
$lang['emailaddressnotpermitted'] = "ema1l aDdR35S n0+ PerMi+TED. ChO0S3 @NotHeR!";
$lang['emailaddressalreadyinuse'] = "eM4iL @DDrE\$5 4lR34DY 1n U\$e. cHOOs3 4N0TH3R!";
$lang['relationshipsupdated'] = "r3L@+10N\$HIp5 uPD@+ED!";
$lang['relationshipupdatefailed'] = "r3LA+Ion\$HIP UPd4+3d Ph@iLeD!";
$lang['preferencesupdated'] = "prepHeR3nCES wERe sUCC3sSPhULLy UpD4tED.";
$lang['userdetails'] = "usER d3t@1l\$";
$lang['memberno'] = "m3m8er N0.";
$lang['firstname'] = "f1r5+ N4M3";
$lang['lastname'] = "l@\$+ NamE";
$lang['dateofbirth'] = "d4+E 0F biRth";
$lang['homepageURL'] = "hOm3P@9E UrL";
$lang['profilepicturedimensions'] = "pr0F1LE p1ctUrE (maX 95x95PX)";
$lang['avatarpicturedimensions'] = "aV@+@r P1CtURe (m@x 15x15px)";
$lang['invalidattachmentid'] = "inV4l1D 4t+@cHM3nt. Ch3cK +h4+ IS H4sN't 83EN dEL3TeD.";
$lang['unsupportedimagetype'] = "uN\$uPPOrt3d 1m4g3 @TTaCHmEN+. j00 cAN oNLY u\$3 jp9, 91pH AnD PNG 1M49E @T+@cHMent\$ For YoUR 4v@T4R @Nd PR0PhiLe P1CtUrE.";
$lang['selectattachment'] = "selEc+ 4++4cHmEnT";
$lang['pictureURL'] = "p1C+Ur3 UrL";
$lang['avatarURL'] = "av@+4r Url";
$lang['profilepictureconflict'] = "t0 use @N a+T4Chm3n+ F0r y0ur ProPh1LE PIc+Ur3 tHe P1CtuRE URl FiELd MU\$+ 8E 8L4NK.";
$lang['avatarpictureconflict'] = "t0 U53 4N a++@CHMeNT PhOR Y0Ur @v4t4R p1cTUr3 +He 4V4+4R Url ph1ELD mU\$+ B3 8L4nK.";
$lang['attachmenttoolargeforprofilepicture'] = "sel3C+3D 4+T4CHmENt 15 +Oo L@rg3 FOR PR0FILe PIc+urE. M4x1mUm D1MenS10NS 4RE %s";
$lang['attachmenttoolargeforavatarpicture'] = "sELeCT3d @+T4ChmEnT 1S +0O L@rGe foR 4V4tAR p1ctURe. MaxImuM DImENS1ON\$ 4RE %s";
$lang['failedtoupdateuserdetails'] = "sOmE Or @LL 0f Y0ur U\$3r @cCoUN+ detAILs C0ULD nOT bE UpDA+3d. pl34\$e +Ry 4g4In l@TeR.";
$lang['failedtoupdateuserpreferences'] = "sOME oR 4LL opH youR usER PR3PHeRenC3s COUlD n0T 8E UpD4TeD. pLEa\$3 +rY 4941N L@TEr.";
$lang['emailaddresschanged'] = "em4IL AdDr3\$S h@S B33n chaN93D";
$lang['newconfirmationemailsuccess'] = "y0Ur 3M41l 4DDrE\$s Ha\$ B3En CHaNGeD @ND 4 n3w c0nFirMA+1ON 3M41L H4s 83EN 53n+. pL3a\$3 cHEcK 4nD R3@D TH3 eM41l FOr pHuR+hER InSTRUct1ONS.";
$lang['newconfirmationemailfailure'] = "j00 H4V3 CH@nG3D y0UR 3MA1l 4DDrE\$\$, 8UT wE Were Una8l3 T0 \$END A coNfiRM@tION r3qU35T. Pl34\$E c0nT4C+ +3h phoRum 0wNeR for a\$\$1S+4NC3.";
$lang['forumoptions'] = "foRUM Op+I0nS";
$lang['notifybyemail'] = "n0tiphY bY em@1l oPh p0sT\$ t0 mE";
$lang['notifyofnewpm'] = "notiphY bY P0PUp OPH N3W pm Me\$\$493s T0 Me";
$lang['notifyofnewpmemail'] = "n0+IphY 8y 3M41l Of NEW pm M3sS49ES T0 m3";
$lang['daylightsaving'] = "adJuST phOR D4YLI9h+ 54vINg";
$lang['autohighinterest'] = "auTOM@+1C4lLy M@rK tHRe@D\$ 1 PO\$+ 1N 4S HI9H 1N+er35+";
$lang['sortthreadlistbyfolders'] = "s0r+ THR3@D L1St 8Y PH0lDeR\$";
$lang['convertimagestolinks'] = "au+0M4T1C4lLy CoNVer+ eM83DdED 1m@93s In P0ST\$ in+O LInKS";
$lang['thumbnailsforimageattachments'] = "thum8n@1L\$ f0R im4GE 4t+@cHMEnT\$";
$lang['smallsized'] = "smaLL s1ZeD";
$lang['mediumsized'] = "m3d1UM siZED";
$lang['largesized'] = "l4r93 \$izeD";
$lang['globallyignoresigs'] = "gLo84lLY IgN0rE U5ER s1Gna+URes";
$lang['allowpersonalmessages'] = "allOW OTh3r U\$3r5 T0 5ENd ME pEr5onAL m3Ss4GE\$";
$lang['allowemails'] = "all0w OTH3R Us3r5 T0 S3ND M3 Em41ls VI@ mY PR0PH1lE";
$lang['timezonefromGMT'] = "t1mE z0n3";
$lang['postsperpage'] = "pOs+5 PeR P@9e";
$lang['fontsize'] = "f0n+ S1zE";
$lang['forumstyle'] = "f0rUm 5+YL3";
$lang['forumemoticons'] = "fORum 3M0+ICoN\$";
$lang['startpage'] = "sT4RT p4G3";
$lang['signaturecontainshtmlcode'] = "sigN4+UR3 coNT@1NS HTmL coD3";
$lang['savesignatureforuseonallforums'] = "s@v3 5I9N4+UR3 foR U53 0N @ll ph0RUms";
$lang['preferredlang'] = "pr3F3RR3D L4N9U@9E";
$lang['donotshowmyageordobtoothers'] = "do n0+ \$HOw My a9e or d4t3 0pH 81R+h +o otHErS";
$lang['showonlymyagetoothers'] = "shOw 0NLY My aGe +O oTH3r5";
$lang['showmyageanddobtoothers'] = "sh0w 8OTH mY 49E 4Nd da+3 OPh 8IR+h +o 0+H3RS";
$lang['showonlymydayandmonthofbirthytoothers'] = "shOW onLY my dAY 4Nd MONtH 0F 81r+H +o 0TH3rS";
$lang['listmeontheactiveusersdisplay'] = "lis+ M3 0N +Eh 4cTiv3 U\$ers DISPL4Y";
$lang['browseanonymously'] = "br0w53 f0RUm AN0NYMoUSly";
$lang['allowfriendstoseemeasonline'] = "bR0WS3 @n0nyMOusLy, bU+ 4ll0W phRIeNd\$ +O sEE m3 4s ONL1N3";
$lang['revealspoileronmouseover'] = "revE4l SP01l3r5 ON m0u\$3 0V3r";
$lang['showspoilersinlightmode'] = "alw4y5 Sh0w \$p01l3Rs 1n LI9H+ moD3 (UsE\$ li9H+er F0N+ COLouR)";
$lang['resizeimagesandreflowpage'] = "r35IZE 1m49E\$ 4nD r3pHl0W P4Ge to PRevEnt hoRIZ0Nt@L \$CrollInG.";
$lang['showforumstats'] = "sHOW f0RuM \$T4T\$ @t 8oT+om oF ME\$\$49E p4Ne";
$lang['usewordfilter'] = "en4BLe WOrD fil+3R.";
$lang['forceadminwordfilter'] = "f0rCe UsE opH @dMIN wORD F1l+er 0n 4lL u\$eRS (1Nc. guE\$t5)";
$lang['timezone'] = "t1m3 zON3";
$lang['language'] = "l4NgU4GE";
$lang['emailsettings'] = "eM41l @Nd cON+4C+ \$e+t1ngs";
$lang['forumanonymity'] = "fORUm 4nONymI+y \$3T+1n9s";
$lang['birthdayanddateofbirth'] = "b1rTHd4y ANd D@TE 0pH 81r+h d1\$pL4Y";
$lang['includeadminfilter'] = "inclUD3 4dM1N w0RD FIL+eR 1n mY liST.";
$lang['setforallforums'] = "s3t FOR @LL pHorUm\$?";
$lang['containsinvalidchars'] = "%s cON+41n\$ 1nV4LId Ch@R4C+3R5!";
$lang['homepageurlmustincludeschema'] = "homep@9E UrL Mu5+ InCLuDe H++p:// \$CH3M4.";
$lang['pictureurlmustincludeschema'] = "p1C+uRE uRL mU5+ 1nClUDE H+tp:// 5cH3m@.";
$lang['avatarurlmustincludeschema'] = "aV@t@r UrL mU\$t iNcLUdE hT+p:// sCh3m4.";
$lang['postpage'] = "p0s+ p@Ge";
$lang['nohtmltoolbar'] = "n0 H+Ml +00l8@R";
$lang['displaysimpletoolbar'] = "diSPL4Y S1MPLe HtmL +o0L8@R";
$lang['displaytinymcetoolbar'] = "d1\$pl4y wY51wYg HTML +O0L84R";
$lang['displayemoticonspanel'] = "d1Spl4Y 3m0tiC0N\$ pAn3l";
$lang['displaysignature'] = "disPL4y si9n@+uRe";
$lang['disableemoticonsinpostsbydefault'] = "di548l3 eM0TIc0n\$ 1N M35\$49ES BY dEF4Ul+";
$lang['automaticallyparseurlsbydefault'] = "aU+OM4+1C4Lly P@r5E Url\$ IN m35S4gE\$ BY Def4ult";
$lang['postinplaintextbydefault'] = "posT 1N PLAiN t3xT 8Y dEPH4ul+";
$lang['postinhtmlwithautolinebreaksbydefault'] = "p0\$T 1n htmL wi+h 4u+0-L1n3-8rE@kS 8Y depH4uL+";
$lang['postinhtmlbydefault'] = "p0\$t 1N H+mL by d3f4ulT";
$lang['postdefaultquick'] = "uS3 QuicK R3PLY 8y DePH4uL+. (PhuLl R3PLY IN mENu)";
$lang['privatemessageoptions'] = "pr1v@+3 m35\$49e OP+iON\$";
$lang['privatemessageexportoptions'] = "priv4tE mEs\$493 EXpoR+ 0P+10NS";
$lang['savepminsentitems'] = "s4VE 4 coPY oF E@CH pM i Send IN mY S3NT 1+3M\$ Ph0ldER";
$lang['includepminreply'] = "inClUde Me\$\$49E 8Ody WhEN r3plY1N9 +O pm";
$lang['autoprunemypmfoldersevery'] = "au+o PrUne my PM F0LdER5 evErY:";
$lang['friendsonly'] = "fRIenD\$ oNLY?";
$lang['globalstyles'] = "gLO8@L s+YL35";
$lang['forumstyles'] = "f0rUm 5+YL3S";
$lang['youmustenteryourcurrentpasswd'] = "j00 MUs+ 3nT3R Y0Ur CuRR3nt PasSWORD";
$lang['youmustenteranewpasswd'] = "j00 mu\$+ ENTeR @ nEw P@SswORd";
$lang['youmustconfirmyournewpasswd'] = "j00 Mus+ c0nF1rM yOuR nEW P4\$\$w0Rd";
$lang['profileentriesmustnotincludehtml'] = "pR0ph1Le 3NTRIE\$ MUST nOt InCLuDE h+Ml";
$lang['failedtoupdateuserprofile'] = "faIlED +0 uPdA+3 u5ER pr0fILe";

// Polls (create_poll.php, poll_results.php) ---------------------------------------------

$lang['mustprovideanswergroups'] = "j00 mUSt pr0viD3 SOMe 4n5w3r 9ROup\$";
$lang['mustprovidepolltype'] = "j00 MUs+ PROviD3 4 p0ll tYPe";
$lang['mustprovidepollresultsdisplaytype'] = "j00 mu5+ prOVID3 REsUL+\$ Displ@Y +yP3";
$lang['mustprovidepollvotetype'] = "j00 MUST PR0v1De @ poLL vO+3 +YpE";
$lang['mustprovidepollguestvotetype'] = "j00 MUst SP3CipHY iF 9U35+s SHoUld b3 4lLOWeD T0 V0+3";
$lang['mustprovidepolloptiontype'] = "j00 MU5+ PR0vID3 A poll 0Pt1oN +YPe";
$lang['mustprovidepollchangevotetype'] = "j00 mU\$T proviDE @ POLL cH4Ng3 vot3 typ3";
$lang['pollquestioncontainsinvalidhtml'] = "oN3 oR MOR3 OF yOur P0LL QU3St10N\$ C0N+@1N5 INVALId h+mL.";
$lang['pleaseselectfolder'] = "pl34\$3 S3lec+ 4 PHOLD3R";
$lang['mustspecifyvalues1and2'] = "j00 mus+ 5p3CifY v@lU3S FOR 4N\$W3R5 1 4nd 2";
$lang['tablepollmusthave2groups'] = "t4bUl4r foRm@+ P0LLS MU5T h4vE PrEciS3ly Tw0 VOTIn9 gr0upS";
$lang['nomultivotetabulars'] = "t4bUl@R F0RM@+ P0LLS c4Nno+ b3 MuL+I-VOTe";
$lang['nomultivotepublic'] = "pUbL1C b4LLO+s C@Nn0t 83 mul+I-VO+E";
$lang['abletochangevote'] = "j00 W1Ll 8E @Bl3 +o Ch4n9E Y0Ur V0t3.";
$lang['abletovotemultiple'] = "j00 WILl B3 48le +0 VOTe mUL+IPle tiM3\$.";
$lang['notabletochangevote'] = "j00 W1ll nOt Be A8LE +0 ch4N93 y0Ur v0+E.";
$lang['pollvotesrandom'] = "not3: pOlL V0T35 aRe RaNDOMly 93NEra+3d Ph0r pr3vI3W oNLY.";
$lang['pollquestion'] = "poLl QuE\$+I0N";
$lang['possibleanswers'] = "pOsS1BL3 4nsw3R\$";
$lang['enterpollquestionexp'] = "en+3r +3H 4n\$WERS f0r y0uR poll QUE5+10n.. if yoUr P0LL i\$ 4 &quot;Y3S/N0&quot; qu3sTION, S1MPLy En+Er &quot;Y35&quot; fOR @N5w3R 1 4ND &quot;N0&quot; PHOr An\$WeR 2.";
$lang['numberanswers'] = "n0. @nswEr\$";
$lang['answerscontainHTML'] = "aN\$w3r\$ C0NT@In H+Ml (n0+ inClUD1N9 \$I9naTur3)";
$lang['optionsdisplay'] = "aN5WEr\$ Di5pL@y tYp3";
$lang['optionsdisplayexp'] = "h0w SH0ulD +h3 4NSW3R\$ B3 PrE\$3nT3D?";
$lang['dropdown'] = "aS Dr0P-D0WN l15+(s)";
$lang['radios'] = "a\$ a s3rIE\$ OF r4diO bU++on\$";
$lang['votechanging'] = "vOT3 Ch4n91nG";
$lang['votechangingexp'] = "c4N 4 PeRS0N Ch@Ng3 His 0r HeR V0T3?";
$lang['guestvoting'] = "gu3ST V0+INg";
$lang['guestvotingexp'] = "cAn 9U3STS v0tE 1n th1\$ Poll?";
$lang['allowmultiplevotes'] = "alloW mULTipL3 VOtES";
$lang['pollresults'] = "poLl Re\$uL+\$";
$lang['pollresultsexp'] = "hOW W0ULd J00 L1KE +0 di\$PL@y +3H r3SUl+\$ 0f YoUr p0lL?";
$lang['pollvotetype'] = "poLl v0ting TypE";
$lang['pollvotesexp'] = "h0w \$h0UlD th3 PolL B3 C0ndUct3D?";
$lang['pollvoteanon'] = "an0NYM0U5LY";
$lang['pollvotepub'] = "pU8L1C b@ll0t";
$lang['horizgraph'] = "h0rIzon+4L GR4PH";
$lang['vertgraph'] = "v3rt1c4l GR4PH";
$lang['tablegraph'] = "t4BUl4R fOrm4T";
$lang['polltypewarning'] = "<b>w4RN1NG</b>: +h1S 1S @ pUBLIc balL0t. yOUr N@m3 WILL bE viS18LE n3XT +O thE oP+10n j00 v0T3 FOr.";
$lang['expiration'] = "exp1r@+1On";
$lang['showresultswhileopen'] = "dO j00 w4nT T0 5HOW r3SUL+s whIl3 +H3 poLL Is Op3N?";
$lang['whenlikepollclose'] = "wHEN w0ULd J00 L1ke Y0ur P0lL tO 4ut0M@+1c4lly Cl053?";
$lang['oneday'] = "one daY";
$lang['threedays'] = "thReE d@YS";
$lang['sevendays'] = "seVeN dAyS";
$lang['thirtydays'] = "tH1rtY D@YS";
$lang['never'] = "n3V3R";
$lang['polladditionalmessage'] = "aDdI+10n@L M3\$\$4G3 (0p+10n@L)";
$lang['polladditionalmessageexp'] = "do J00 W4N+ +0 1NclUdE 4n ADdITI0N4L P05+ 4FT3r the p0ll?";
$lang['mustspecifypolltoview'] = "j00 MusT SPeC1pHY a POLl +0 v1EW.";
$lang['pollconfirmclose'] = "are j00 SUrE J00 w4nT TO cl0\$e +Eh f0LLowINg P0LL?";
$lang['endpoll'] = "eNd p0ll";
$lang['nobodyvotedclosedpoll'] = "nOBoDY voTeD";
$lang['votedisplayopenpoll'] = "%s @ND %s H4VE v0T3d.";
$lang['votedisplayclosedpoll'] = "%s 4Nd %s V0+3d.";
$lang['nousersvoted'] = "n0 USeRS";
$lang['oneuservoted'] = "1 U53R";
$lang['xusersvoted'] = "%s uS3r\$";
$lang['noguestsvoted'] = "n0 gUE\$+\$";
$lang['oneguestvoted'] = "1 9u35+";
$lang['xguestsvoted'] = "%s 9UEs+s";
$lang['pollhasended'] = "p0LL H@s EnDeD";
$lang['youvotedforpolloptionsondate'] = "j00 VOTeD fOR %s on %s";
$lang['thisisapoll'] = "tH1S 1s A P0Ll. Click TO VIeW ResUl+\$.";
$lang['editpoll'] = "ed1+ p0ll";
$lang['results'] = "r3suLt5";
$lang['resultdetails'] = "r35Ul+ dET41L\$";
$lang['changevote'] = "ch@N9E V0+E";
$lang['pollshavebeendisabled'] = "polLs h4v3 8EEn D1SA8lEd 8Y tEH f0rUM 0WN3R.";
$lang['answertext'] = "answ3r +3X+";
$lang['answergroup'] = "aNsWEr GROuP";
$lang['previewvotingform'] = "pr3Vi3w v0TiNg Ph0rm";
$lang['viewbypolloption'] = "vIEw By P0lL 0Ption";
$lang['viewbyuser'] = "v13W 8Y U53r";

// Profiles (profile.php) ----------------------------------------------

$lang['editprofile'] = "eDI+ pr0pHIL3";
$lang['profileupdated'] = "pr0Ph1L3 UPD4tED.";
$lang['profilesnotsetup'] = "t3H ph0RUM 0WN3R Ha\$ N0+ S3+ Up PR0FIlE\$.";
$lang['ignoreduser'] = "ignoR3D U53R";
$lang['lastvisit'] = "lA\$+ Vis1+";
$lang['userslocaltime'] = "user's L0C4L +1m3";
$lang['userstatus'] = "s+4tU\$";
$lang['useractive'] = "onlINe";
$lang['userinactive'] = "in@c+1V3 / opHflIn3";
$lang['totaltimeinforum'] = "t0+@l +iMe";
$lang['longesttimeinforum'] = "l0nG35+ 535\$1ON";
$lang['sendemail'] = "sEND EM@1L";
$lang['sendpm'] = "s3ND pM";
$lang['visithomepage'] = "v1s1+ H0M3P493";
$lang['age'] = "age";
$lang['aged'] = "a9eD";
$lang['birthday'] = "b1r+Hd4Y";
$lang['registered'] = "r3G15+Er3D";
$lang['findpostsmadebyuser'] = "f1ND p0st5 MAd3 8y %s";
$lang['findpostsmadebyme'] = "f1nd P0sTS m4dE 8Y M3";
$lang['findthreadsstartedbyuser'] = "fiND THr34Ds 5+@R+3D BY %s";
$lang['findthreadsstartedbyme'] = "f1nD thReaDs 5T4RtED 8y Me";
$lang['profilenotavailable'] = "pRoPHilE n0+ @v41l@BlE.";
$lang['userprofileempty'] = "thiS UsEr hA\$ N0t pH1lLeD in th3iR pROPH1LE oR iT is sE+ T0 pr1V4+E.";

// Registration (register.php) -----------------------------------------

$lang['newuserregistrationsarenotpermitted'] = "sORRy, n3W US3R rEGi5+r@T1ONs 4RE n0T @lLOW3D r19H+ n0w. PLe4Se ch3Ck 84CK L4Ter.";
$lang['usernametooshort'] = "u\$erN4ME mU\$+ B3 4 MINiMUm 0F 2 cH4R4CT3r5 L0NG";
$lang['usernametoolong'] = "useRNAm3 Mu5+ 8E @ M4x1mUm 0pH 15 cH4R4C+eR5 l0nG";
$lang['usernamerequired'] = "a L09oN N4Me 15 rEquIReD";
$lang['passwdmustnotcontainHTML'] = "p4SSW0Rd musT no+ C0n+@iN H+Ml +@9\$";
$lang['passwdtooshort'] = "p45\$W0rd Mu\$+ 83 A mINImUM 0f 6 ChaR4C+3rs LonG";
$lang['passwdrequired'] = "a P4s\$wORd Is R3QuireD";
$lang['confirmationpasswdrequired'] = "a c0NPh1rm4tIOn P4\$sW0rD 1s ReqU1R3D";
$lang['nicknamerequired'] = "a n1CKN@mE 1\$ rEQU1ReD";
$lang['emailrequired'] = "aN Em4IL ADdRE\$\$ 1\$ REqUIrED";
$lang['passwdsdonotmatch'] = "p@S5W0RDS d0 n0+ m4tcH";
$lang['usernamesameaspasswd'] = "u5eRN4mE 4ND p@ssw0Rd MusT 8E d1PHPHEREnT";
$lang['usernameexists'] = "sOrRY, 4 U5ER WiTH Th@T N@ME 4lr34Dy Exi5+\$";
$lang['successfullycreateduseraccount'] = "sucCe\$\$pHUlly Cr34TEd U53r @cC0UN+";
$lang['useraccountcreatedconfirmfailed'] = "y0Ur U53r @CCOUNT HA\$ b3eN CRe@T3D 8u+ T3H R3QuiR3D COnF1rM4t1oN 3MAIL W4s noT sEnt. Pl34s3 c0nt4CT tEH fOrUm oWnER T0 ReCt1phY +h1s. In THIs me4N+1Me pLe4\$3 clIcK Teh COn+1NUE buT+on t0 l0gIn.";
$lang['useraccountcreatedconfirmsuccess'] = "y0uR Us3R 4CcOUnt H@s 8EEn cR34teD 8U+ 8ePhoR3 J00 C@n \$+4RT po\$+1N9 j00 mu\$+ coNph1RM YoUR EM41L 4ddRESs. PlE@53 ch3CK y0UR EM41L f0r 4 LInk +H@t W1ll 4LL0W J00 to cONPh1rM YOuR 4DdRE\$s.";
$lang['useraccountcreated'] = "y0uR u53r 4CcOUNt H@s 8E3n CReA+3D SUCc35\$pHULlY! CLiCK TeH cOn+1NUe bUT+oN B3lOw t0 LO9iN";
$lang['errorcreatinguserrecord'] = "error CRe4+1n9 uSER REc0rD";
$lang['userregistration'] = "u53r R391\$TR4TION";
$lang['registrationinformationrequired'] = "r3GisTr@T1oN iNFOrmA+10N (r3QU1R3D)";
$lang['profileinformationoptional'] = "prOph1le 1NPhorM@+1oN (OPtiON@l)";
$lang['preferencesoptional'] = "pREPhEreNCe\$ (0p+1ON4L)";
$lang['register'] = "r3giS+er";
$lang['rememberpasswd'] = "r3MEm8eR pasSwoRd";
$lang['birthdayrequired'] = "d@T3 0ph 8Ir+h i\$ r3QuIRed 0r Is inv@L1D";
$lang['alwaysnotifymeofrepliestome'] = "n0+1pHY on RePLY To M3";
$lang['notifyonnewprivatemessage'] = "nOt1phy 0n N3W PRiV@T3 m3s5@Ge";
$lang['popuponnewprivatemessage'] = "p0p Up On n3w PRiV4tE M3ss4g3";
$lang['automatichighinterestonpost'] = "aU+0m4t1C H1GH 1n+3R3s+ 0N p0\$+";
$lang['confirmpassword'] = "c0nFIRm P4s\$w0Rd";
$lang['invalidemailaddressformat'] = "iNv4l1D eM41l 4dDR3s\$ fORm@T";
$lang['moreoptionsavailable'] = "m0R3 PROPh1L3 AND PRepHEr3nCE oP+IoN\$ 4rE 4v41La8L3 0NC3 J00 r39isTer";
$lang['textcaptchaconfirmation'] = "cONPH1RM4+1oN";
$lang['textcaptchaexplain'] = "t0 PR3V3NT @uT0m4t3d re91s+R4t1oNS +his Ph0Rum R3QUir35 j00 EN+er 4 conpH1rM4+1ON coDe. THe c0D3 1s dISPL@yEd 1n tHe IM49E j00 TO tHe R1GH+. if j00 4Re V1\$u4LLY 1mp41r3d or C4NNOt OTH3rWIS3 ReAd +eh cOD3 Pl34SE c0N+4CT +hE %s.";
$lang['textcaptchaimgtip'] = "thIs I\$ 4 C@ptcH@-p1c+Ur3. It I5 U5Ed T0 PR3veNt 4Ut0ma+IC R3G15+r4tION";
$lang['textcaptchamissingkey'] = "a C0nPhiRm@+1on coD3 IS rEqUIReD.";
$lang['textcaptchaverificationfailed'] = "t3x+-C@PTcHA v3r1F1C4+10N cOd3 Wa\$ 1NC0RR3CT. PL34S3 r3-En+3r 1+.";
$lang['forumrules'] = "f0rUM rUle5";
$lang['forumrulesnotification'] = "in Ord3r +o PR0C33D, j00 mU5+ 49reE wI+H +hE ph0lLOW1ng Rul3s";
$lang['forumrulescheckbox'] = "i HAV3 re4D, 4nD 49rE3 +O A81de By TeH f0RuM RuL3S.";
$lang['youmustagreetotheforumrules'] = "j00 MusT @9R33 +0 +3h PH0RuM ruLes b3fOrE J00 C@n C0N+InU3.";

// Recent visitors list  (visitor_log.php) -----------------------------

$lang['member'] = "m3Mb3r";
$lang['searchforusernotinlist'] = "sE4RCH FOR @ UsER n0t IN l15T";
$lang['yoursearchdidnotreturnanymatches'] = "y0UR \$34Rch D1d Not rE+UrN 4NY mA+cH3s. +Ry \$1mpL1phyING y0UR 53aRcH p4RAm3t3r5 4nD TRY 4g4iN.";
$lang['hiderowswithemptyornullvalues'] = "h1dE R0w\$ W1+h 3MP+y 0r nULl V4Lu3S 1N 5EL3C+Ed cOLuMNS";
$lang['showregisteredusersonly'] = "sHoW RegI5+er3D U5Ers ONlY (hIdE 9U3\$+\$)";

// Relationships (user_rel.php) ----------------------------------------

$lang['relationships'] = "r3L@T1ON5hIPS";
$lang['userrelationship'] = "uS3R r3L4t1onsh1P";
$lang['userrelationships'] = "u\$ER r3L4TIon\$h1PS";
$lang['failedtoremoveselectedrelationships'] = "f4ILeD t0 R3MOVe \$el3c+3D rEl4tION\$hiP";
$lang['friends'] = "fRIEnD\$";
$lang['ignoredcompletely'] = "i9NoR3D comPl3TELY";
$lang['relationship'] = "r3l@tiOnSh1P";
$lang['restorenickname'] = "r35+oR3 U\$3r'\$ NiCKn@Me";
$lang['friend_exp'] = "u53R'5 PO5+S MaRK3D w1TH @ &quot;FR1EnD&quot; IC0N.";
$lang['normal_exp'] = "u\$eR's p0sT\$ 4PPeAR 4s nOrM4l.";
$lang['ignore_exp'] = "u5eR'\$ p05+s 4re H1Dd3n.";
$lang['ignore_completely_exp'] = "thrE@D5 4Nd P05+5 T0 0R pHr0m UsER wiLl APPe@R Del3t3D.";
$lang['display'] = "d1spL4y";
$lang['displaysig_exp'] = "u53R'\$ SI9n@tuRe 1s d1\$pL4Y3D 0N +HEiR po5T5.";
$lang['hidesig_exp'] = "us3R'S \$1gn4Tur3 I5 HIddEn oN tH3iR pOs+S.";
$lang['youcannotchangeuserrelationshipforownaccount'] = "j00 c4nn0t CHaNGe UsEr rel@+1On5HIp FOR y0UR owN u\$er 4CcoUnT";
$lang['cannotignoremod'] = "j00 c@NnoT i9NORe ThiS U\$3R, @S th3Y 4rE 4 mOd3R4t0r.";
$lang['previewsignature'] = "pREV13W \$i9n4+Ur3";

// Search (search.php) -------------------------------------------------

$lang['searchresults'] = "sE4rch Re\$uL+\$";
$lang['usernamenotfound'] = "tEh u53rn@Me J00 SpeC1PH13D 1N th3 T0 0R PhROM F13LD W4s N0+ phOuND.";
$lang['notexttosearchfor'] = "oNE OR 4LL of Y0UR 534rCh K3ywoRD\$ wErE 1NV4lId. S34rcH K3YW0RD\$ mU5+ 83 no 5h0RT3r THan %d CH4R4Ct3RS, N0 longER thAn %d cHar4CT3R5 4ND mU\$t Not @pP34r 1n tEh %s";
$lang['keywordscontainingerrors'] = "k3yWorD\$ c0n+4In1n9 3rR0R\$: %s";
$lang['mysqlstopwordlist'] = "mYsQL stOPW0Rd L1st";
$lang['foundzeromatches'] = "fOUND: 0 M4+che\$";
$lang['found'] = "fOunD";
$lang['matches'] = "m@+Ch3\$";
$lang['prevpage'] = "pR3VIOus p@9E";
$lang['findmore'] = "f1nD M0Re";
$lang['searchmessages'] = "s34Rch m3sS49e\$";
$lang['searchdiscussions'] = "s3@RCH D1sCU5\$10nS";
$lang['find'] = "f1nD";
$lang['additionalcriteria'] = "adD1+10n@L cR1+3RI4";
$lang['searchbyuser'] = "sE4rCH BY u\$Er (0P+Ion4L)";
$lang['folderbrackets_s'] = "f0LDer(5)";
$lang['postedfrom'] = "p05+eD phrOm";
$lang['postedto'] = "po\$+3d t0";
$lang['today'] = "tod@Y";
$lang['yesterday'] = "y3s+ErD@Y";
$lang['daybeforeyesterday'] = "d4Y 83f0Re yEstErD4Y";
$lang['weekago'] = "%s wE3K @Go";
$lang['weeksago'] = "%s w33K\$ @90";
$lang['monthago'] = "%s m0n+h agO";
$lang['monthsago'] = "%s m0n+Hs @9o";
$lang['yearago'] = "%s ye4R ago";
$lang['beginningoftime'] = "bE9InN1nG 0PH +1ME";
$lang['now'] = "nOW";
$lang['lastpostdate'] = "l45+ P05t d4tE";
$lang['numberofreplies'] = "nUm83r OF rEPl13S";
$lang['foldername'] = "f0ldEr naM3";
$lang['authorname'] = "au+Hor N4Me";
$lang['relevancy'] = "r3lev@ncy";
$lang['decendingorder'] = "neW35+ Fir5+";
$lang['ascendingorder'] = "oldest f1Rs+";
$lang['keywords'] = "keyw0rds";
$lang['sortby'] = "s0Rt 8y";
$lang['sortdir'] = "soR+ diR";
$lang['sortresults'] = "s0R+ r3sul+\$";
$lang['groupbythread'] = "groUP 8y THrEAd";
$lang['postsfromuser'] = "p05+5 Phr0M u5er";
$lang['threadsstartedbyuser'] = "thrE@Ds S+4rTeD 8y us3r";
$lang['searchfrequencyerror'] = "j00 C4N OnLY sE@rCH 0nCE 3vERY %s SeC0NdS. pLE@\$E trY aG@1n L@tER.";
$lang['searchsuccessfullycompleted'] = "s3aRch SuCc3sSPhULLY COMpL3T3D. %s";
$lang['clickheretoviewresults'] = "cLiCk h3re To vI3w r3SUL+s.";

// Search Popup (search_popup.php) -------------------------------------

$lang['select'] = "s3L3c+";
$lang['currentselection'] = "cURR3N+ 53LEcT1oN";
$lang['addtoselection'] = "adD T0 53lEc+10n";
$lang['searchforthread'] = "se4rCH foR +hR3@d";
$lang['mustspecifytypeofsearch'] = "j00 mu5+ sp3C1FY tYPe Of S34rCH +O p3rFOrm";
$lang['unkownsearchtypespecified'] = "uNKnOwn sE4RCh +Yp3 5pECiF13d";
$lang['maximumselectionoftenlimitreached'] = "m@x1muM sEl3cT1oN lIMIt OF 10 H@\$ B33n R34CH3D";

// Start page (start_left.php) -----------------------------------------

$lang['recentthreads'] = "rEC3NT thRe4ds";
$lang['startreading'] = "sT4rT R34DIN9";
$lang['threadoptions'] = "tHr3@d op+ION\$";
$lang['editthreadoptions'] = "eDI+ +HReaD OP+IOn\$";
$lang['morevisitors'] = "m0rE v1s1t0r5";
$lang['forthcomingbirthdays'] = "fortHcoM1N9 8iR+Hd@Y5";

// Start page (start_main.php) -----------------------------------------

$lang['editstartpage_help'] = "j00 C4n eD1+ thIS Pa9E phR0M +eH aDMin Int3rF4Ce";

// Thread navigation (thread_list.php) ---------------------------------

$lang['newdiscussion'] = "nEW DI\$CuSs1oN";
$lang['createpoll'] = "cR3@Te POLL";
$lang['search'] = "sE@RCH";
$lang['searchagain'] = "se4RCH @94in";
$lang['alldiscussions'] = "aLl discU\$\$10Ns";
$lang['unreaddiscussions'] = "uNR34D d1sCusSI0nS";
$lang['unreadtome'] = "unrE@D &quot;TO: m3&quot;";
$lang['todaysdiscussions'] = "tODAy'5 d1\$cusSI0ns";
$lang['2daysback'] = "2 d4ys b@ck";
$lang['7daysback'] = "7 d@YS b@CK";
$lang['highinterest'] = "h1gH 1NTEr3St";
$lang['unreadhighinterest'] = "unr3aD H19h 1n+3r3s+";
$lang['iverecentlyseen'] = "i'V3 R3C3nTLY SeEN";
$lang['iveignored'] = "i'vE i9N0rEd";
$lang['byignoredusers'] = "bY 1gN0r3d u5eR\$";
$lang['ivesubscribedto'] = "i'Ve \$UB\$CRIb3d T0";
$lang['startedbyfriend'] = "s+4rTEd 8Y Fr13Nd";
$lang['unreadstartedbyfriend'] = "uNrE@D 5+d 8y fr13nd";
$lang['startedbyme'] = "s+@rt3d by Me";
$lang['unreadtoday'] = "uNr34D +0D@Y";
$lang['deletedthreads'] = "delETeD tHR3@Ds";
$lang['goexcmark'] = "g0!";
$lang['folderinterest'] = "f0lDEr INT3resT";
$lang['postnew'] = "p05+ NeW";
$lang['currentthread'] = "cuRrenT +hREAd";
$lang['highinterest'] = "h19h in+ERE5+";
$lang['markasread'] = "m4RK A\$ R3@D";
$lang['next50discussions'] = "n3xt 50 D1sCU\$\$iON\$";
$lang['visiblediscussions'] = "v1\$i8l3 dIsCuS\$IoN\$";
$lang['selectedfolder'] = "sEL3c+3D Ph0Ld3r";
$lang['navigate'] = "n@vi94+3";
$lang['couldnotretrievefolderinformation'] = "tH3r3 ARe NO PH0lderS AV41la8Le.";
$lang['nomessagesinthiscategory'] = "nO M3\$s@93S 1N THIs C4+EGORy. PLe@53 \$3L3c+ 4nO+h3r, oR %s f0R aLL ThR34dS";
$lang['clickhere'] = "cLIck h3rE";
$lang['prev50threads'] = "prev10u\$ 50 +HRe@DS";
$lang['next50threads'] = "neXt 50 +hRE4D5";
$lang['nextxthreads'] = "next %s ThrE@D5";
$lang['threadstartedbytooltip'] = "thr34d #%s St4r+3D bY %s. ViEWeD %s";
$lang['threadviewedonetime'] = "1 +im3";
$lang['threadviewedtimes'] = "%d +1m3s";
$lang['readthread'] = "r34D thR3@d";
$lang['unreadmessages'] = "uNR34d m3SS49e\$";
$lang['subscribed'] = "su8scR183D";
$lang['stickythreads'] = "sTICkY +hre@D\$";
$lang['mostunreadposts'] = "mO\$+ uNR34D P0\$+5";
$lang['onenew'] = "%d n3w";
$lang['manynew'] = "%d n3w";
$lang['onenewoflength'] = "%d n3w 0F %d";
$lang['manynewoflength'] = "%d NEW 0ph %d";
$lang['confirmmarkasread'] = "aRE J00 \$URe J00 WAnT +o M@RK t3h 5El3c+3D tHRE4Ds @s Re4d?";
$lang['successfullymarkreadselectedthreads'] = "suCC3SSFuLLy M@rK3D sELeC+3D +Hr3aDS AS REaD";
$lang['failedtomarkselectedthreadsasread'] = "f41l3D T0 MARk \$3l3C+3D ThrE4Ds @\$ R34D";
$lang['gotofirstpostinthread'] = "gO +O fiRST POST 1n thr34d";
$lang['gotolastpostinthread'] = "go To L4\$t PO5+ 1N thRe@D";
$lang['viewmessagesinthisfolderonly'] = "v1EW mE\$S49es 1n thI5 F0LdeR OnLY";
$lang['shownext50threads'] = "sHOW n3xt 50 +hR34D5";
$lang['showprev50threads'] = "sHOW prEV10US 50 ThrEaDS";
$lang['createnewdiscussioninthisfolder'] = "cRE4+3 NEw di\$CU5\$10n In +Hi\$ F0lDer";
$lang['nomessages'] = "nO M3SS4g35";

// HTML toolbar (htmltools.inc.php) ------------------------------------
$lang['bold'] = "b0ld";
$lang['italic'] = "iTAL1C";
$lang['underline'] = "unD3rl1N3";
$lang['strikethrough'] = "s+r1ketHR0UGH";
$lang['superscript'] = "sUp3rSCr1p+";
$lang['subscript'] = "suB5CR1pt";
$lang['leftalign'] = "lEf+-4l1gN";
$lang['center'] = "c3NtER";
$lang['rightalign'] = "rI9h+-4L1GN";
$lang['numberedlist'] = "num83R3D l1\$+";
$lang['list'] = "lI5+";
$lang['indenttext'] = "ind3n+ TeXT";
$lang['code'] = "c0D3";
$lang['quote'] = "qUO+E";
$lang['unquote'] = "unqU0+E";
$lang['spoiler'] = "sPo1l3R";
$lang['horizontalrule'] = "h0r1zON+@l RuL3";
$lang['image'] = "im@9e";
$lang['hyperlink'] = "hYpErL1Nk";
$lang['noemoticons'] = "dI548Le 3m0tiC0N\$";
$lang['fontface'] = "f0Nt pH4c3";
$lang['size'] = "sIzE";
$lang['colour'] = "cOLOUR";
$lang['red'] = "r3d";
$lang['orange'] = "or4N9e";
$lang['yellow'] = "yELL0W";
$lang['green'] = "gR33n";
$lang['blue'] = "bLUe";
$lang['indigo'] = "iNDIgo";
$lang['violet'] = "vioL3+";
$lang['white'] = "wH1+3";
$lang['black'] = "bL4ck";
$lang['grey'] = "gRey";
$lang['pink'] = "p1nK";
$lang['lightgreen'] = "lI9H+ 9r33N";
$lang['lightblue'] = "l19h+ blUe";

// Forum Stats --------------------------------

$lang['forumstats'] = "f0Rum 5T4T5";
$lang['userstats'] = "u\$er ST4t\$";

$lang['usersactiveinthepasttimeperiod'] = "%s ac+1v3 IN +HE p4\$t %s.";

$lang['numactiveguests'] = "<b>%s</b> 9uE\$+s";
$lang['oneactiveguest'] = "<b>1</b> Gu3S+";
$lang['numactivemembers'] = "<b>%s</b> MEM8Er\$";
$lang['oneactivemember'] = "<b>1</b> Mem8ER";
$lang['numactiveanonymousmembers'] = "<b>%s</b> 4nONYm0u\$ MEMb3Rs";
$lang['oneactiveanonymousmember'] = "<b>1</b> 4nOnymOu\$ m3M83r";

$lang['numthreadscreated'] = "<b>%s</b> +HR34d5";
$lang['onethreadcreated'] = "<b>1</b> +Hr3ad";
$lang['numpostscreated'] = "<b>%s</b> p0\$+s";
$lang['onepostcreated'] = "<b>1</b> P0\$+";

$lang['younormal'] = "j00";
$lang['youinvisible'] = "j00 (INViSI8Le)";
$lang['viewcompletelist'] = "viEw cOMPLe+3 Li5+";
$lang['ourmembershavemadeatotalofnumthreadsandnumposts'] = "our M3m83R\$ H4VE m@D3 4 +Ot4l OPh %s 4Nd %s.";
$lang['longestthreadisthreadnamewithnumposts'] = "lonG3st +HRe4d Is <b>%s</b> wITH %s.";
$lang['therehavebeenxpostsmadeinthelastsixtyminutes'] = "tHER3 H4v3 b3eN <b>%s</b> p05+S M@D3 1N +h3 L4ST 60 m1nU+E5.";
$lang['therehasbeenonepostmadeinthelastsixtyminutes'] = "thEr3 H@s b3eN <b>1</b> p0ST M@D3 1N tHE l4\$+ 60 MinU+35.";
$lang['mostpostsevermadeinasinglesixtyminuteperiodwasnumposts'] = "mosT po5+5 EvER m@d3 in @ 51N9L3 60 miNutE P3r1OD 1\$ <b>%s</b> 0n %s.";
$lang['wehavenumregisteredmembersandthenewestmemberismembername'] = "wE H4vE <b>%s</b> R391S+3reD mEMb3r5 4nD T3H nEWeST mEMB3r IS <b>%s</b>.";
$lang['wehavenumregisteredmember'] = "w3 H@ve %s REg15tErED M3M8eRS.";
$lang['wehaveoneregisteredmember'] = "we HAVe ON3 R39IstER3D M3m83r.";
$lang['mostuserseveronlinewasnumondate'] = "mO\$t u53r\$ eVer ONL1NE w4S <b>%s</b> 0n %s.";
$lang['statsdisplaychanged'] = "s+a+5 D1\$pLAy ch4n93d";

$lang['viewtop20'] = "v1eW T0P 20";

$lang['folderstats'] = "f0LDEr 5+4TS";
$lang['threadstats'] = "thREAd 5+4Ts";
$lang['poststats'] = "pos+ 5+@+S";
$lang['pollstats'] = "pOLL \$+@TS";
$lang['attachmentsstats'] = "a+taChmEn+\$ ST4t5";
$lang['userpreferencesstats'] = "u53r Pr3Fer3ncE\$ 5tAt5";
$lang['visitorstats'] = "v1sIT0r S+4TS";
$lang['sessionstats'] = "seSs10N \$t4TS";
$lang['profilestats'] = "pr0FiL3 \$+4t5";
$lang['signaturestats'] = "si9N@TUR3 \$+4TS";
$lang['ageandbirthdaystats'] = "aGe @nD b1R+hDAY \$+@t5";
$lang['relationshipstats'] = "r3l4tIONSHiP \$tA+\$";
$lang['wordfilterstats'] = "wOrD f1l+er s+4+s";

$lang['numberoffolders'] = "numB3R OPH FOlD3r\$";
$lang['folderwithmostthreads'] = "f0Lder WITh M05+ +HRe4dS";
$lang['folderwithmostposts'] = "f0lDER wiTh MO\$+ P05+S";
$lang['totalnumberofthreads'] = "tot@L NuM83R Of tHr3adS";
$lang['longestthread'] = "lOnge\$+ Thre@D";
$lang['mostreadthread'] = "most r34D +HR34D";
$lang['threadviews'] = "v1eW\$";
$lang['averagethreadcountperfolder'] = "aVER@93 +hR34D c0un+ p3r FolDeR";
$lang['totalnumberofthreadsubscriptions'] = "t0Tal nuM83r of tHR3ad 5U8\$CRIp+Ion\$";
$lang['mostpopularthreadbysubscription'] = "mo\$+ P0pUl4r +hr3@D BY 5U8SCRipT10N";
$lang['totalnumberofposts'] = "t0+4L NUMb3R OF POSTS";
$lang['numberofpostsmadeinlastsixtyminutes'] = "nuMbER 0Ph p05+S m4dE 1N L@s+ 60 miNU+3S";
$lang['mostpostsmadeinasinglesixtyminuteperiod'] = "m0\$t P0S+S M@D3 1N 0NE 60 M1nu+E perIod";
$lang['averagepostsperuser'] = "av3r49e P0s+S p3r U\$3R";
$lang['topposter'] = "t0p PO5TER";
$lang['totalnumberofpolls'] = "tO+@l numbER OpH POlLS";
$lang['totalnumberofpolloptions'] = "t0+@l Numb3r OPH POll Op+Ion\$";
$lang['averagevotesperpoll'] = "aVER9E V0+35 Per poll";
$lang['totalnumberofpollvotes'] = "t0+AL NUM83R OF POLL Vo+3s";
$lang['totalnumberofattachments'] = "t0tAL NUM83r OF 4++4chMenT\$";
$lang['averagenumberofattachmentsperpost'] = "av3r49e 4+t4CHMeNT c0UNt P3r p0sT";
$lang['mostdownloadedattachment'] = "m0\$t d0wnLO4d3d A+t4CHMeNt";
$lang['mostusedforumstyle'] = "m0s+ usEd FOrUM \$+yL3";
$lang['mostusedlanguuagefile'] = "mO5+ u\$3d L4NGU49E F1l3";
$lang['mostusedtimezone'] = "m0st U53D Tim3zOn3";
$lang['mostusedemoticonpack'] = "m0st USeD eMO+ic0N p4ck";

$lang['numberofusers'] = "num83R 0PH U53rs";
$lang['newestuser'] = "n3w3sT u5er";
$lang['numberofcontributingusers'] = "nUmb3r 0PH cON+R1Bu+1n9 USeRS";
$lang['numberofnoncontributingusers'] = "num83R 0f noN-C0nTr18UtiN9 u\$3R5";
$lang['subscribers'] = "suBScrIb3rS";

$lang['numberofvisitorstoday'] = "nUmbEr Of V1\$I+0RS toD@y";
$lang['numberofvisitorsthisweek'] = "nuMB3R 0F V1sI+ORS +hIS w33k";
$lang['numberofvisitorsthismonth'] = "numBEr OPH v1s1+or\$ tHis m0n+H";
$lang['numberofvisitorsthisyear'] = "num83R Oph vI5IT0RS +his Ye4r";

$lang['totalnumberofactiveusers'] = "to+@L NuMBER opH @CTiVE U53RS";
$lang['numberofactiveregisteredusers'] = "nUmBEr 0pH @ctiVe Re9I\$+3REd usERS";
$lang['numberofactiveguests'] = "nUmB3R oF @c+iVE 9u3S+5";
$lang['mostuserseveronline'] = "moS+ Us3r5 eVER 0nlIn3";
$lang['mostactiveuser'] = "mO\$+ 4ctiVe UsER";
$lang['numberofuserswithprofile'] = "num83R Of U5ERS w1TH pR0pH1L3";
$lang['numberofuserswithoutprofile'] = "nUM83R 0f u53r\$ W1+H0UT pR0pH1Le";
$lang['numberofuserswithsignature'] = "numbEr oPh U\$3rS W1+h SI9N@tuRe";
$lang['numberofuserswithoutsignature'] = "nuMbeR Oph usErS wi+h0u+ S1Gn4tUr3";
$lang['averageage'] = "aV3r493 4g3";
$lang['mostpopularbirthday'] = "mo\$+ p0PUl4R 8irthD4Y";
$lang['nobirthdaydataavailable'] = "nO bIRThDAy D@Ta 4V4ILA8le";
$lang['numberofusersusingwordfilter'] = "nUMb3R 0F U53rS U5in9 W0RD phILT3R";
$lang['numberofuserreleationships'] = "numbEr 0ph u\$eR rElE@tiONSh1p\$";
$lang['averageage'] = "av3r49e 4gE";
$lang['averagerelationshipsperuser'] = "av3R49E ReL4+10N\$h1p5 PeR uS3R";

$lang['numberofusersnotusingwordfilter'] = "nUmBeR 0ph UsERS nOT uS1NG w0rd F1L+3R";
$lang['averagewordfilterentriesperuser'] = "aV3RAG3 worD phIltEr 3NTr13s P3R U53r";

$lang['mostuserseveronlinedetail'] = "%s On %s";

// Thread Options (thread_options.php) ---------------------------------

$lang['updatessavedsuccessfully'] = "uPda+35 5@VEd \$Ucc3SSPHuLlY";
$lang['useroptions'] = "u53r 0P+10Ns";
$lang['markedasread'] = "m4RK3D @s rE4D";
$lang['postsoutof'] = "pOstS Ou+ 0PH";
$lang['interest'] = "iNTere5T";
$lang['closedforposting'] = "cLO\$3d PHor p0\$tIN9";
$lang['locktitleandfolder'] = "lOck TitL3 @nD PH0LdER";
$lang['deletepostsinthreadbyuser'] = "d3lE+3 PosTS iN thR34d By u\$er";
$lang['deletethread'] = "delE+3 +hrE@d";
$lang['permenantlydelete'] = "pERm4nEntLy DeL3T3";
$lang['movetodeleteditems'] = "m0v3 T0 dEL3t3D THrE@dS";
$lang['undeletethread'] = "uND3lE+3 +hrE@D";
$lang['markasunread'] = "m4Rk @S UnREAD";
$lang['makethreadsticky'] = "m4kE tHReAD 5tiCky";
$lang['threareadstatusupdated'] = "tHR3@D r3AD 5TA+U5 upD@tEd SuCcE\$\$FUlLy";
$lang['interestupdated'] = "tHr34d In+ErESt \$+@Tu5 UpD4tEd SUcC3S\$FULlY";
$lang['threadwassuccessfullydeleted'] = "tHrE@D w@S 5UcCe\$sphULLy DEle+3D";
$lang['threadwassuccessfullyundeleted'] = "thr34D W4\$ sUCc35SPHuLLy UnD3LE+ED";
$lang['failedtoupdatethreadreadstatus'] = "fa1led T0 UPd@TE thr34D ReAD 5+@+us";
$lang['failedtoupdatethreadinterest'] = "f@1L3d +0 upD@tE ThRead In+3RE\$+";
$lang['failedtorenamethread'] = "f41l3D T0 R3N4mE tHReaD";
$lang['failedtomovethread'] = "f4iLEd +O MOV3 THrEAd +o 5PEc1pHi3d ph0Ld3r";
$lang['failedtoupdatethreadstickystatus'] = "f@1l3D +o UpD@tE thRe@D \$tiCkY 5+4TU\$";
$lang['failedtoupdatethreadclosedstatus'] = "f41lEd to UpDA+E +HReAD CLO\$3D sTAtU\$";
$lang['failedtoupdatethreadlockstatus'] = "f4iLED T0 upD4+e +hr34d lOCk ST4tU\$";
$lang['failedtodeletepostsbyuser'] = "f4iLEd TO dEl3Te p0ST5 8Y 53L3C+3d U\$3r";
$lang['failedtodeletethread'] = "f@IL3d +o dELe+3 +HRE@D.";
$lang['failedtoundeletethread'] = "f4il3d +0 uN-DEl3Te thRe4d";

// Folder Options (folder_options.php) ---------------------------------

$lang['folderoptions'] = "fOLDeR Opt1oNS";
$lang['foldercouldnotbefound'] = "thE r3Qu3S+ED pHOLd3r c0uLd Not b3 f0unD 0r @CC3s\$ W@s D3Ni3d.";
$lang['failedtoupdatefolderinterest'] = "faiL3D +0 UpD4TE PH0ldER 1N+eR3\$+";

// Dictionary (dictionary.php) -----------------------------------------

$lang['dictionary'] = "diC+Ion4RY";
$lang['spellcheck'] = "sPELL CH3Ck";
$lang['notindictionary'] = "n0+ in d1cT1oN@Ry";
$lang['changeto'] = "ch@NGe to";
$lang['restartspellcheck'] = "r35+4rT";
$lang['cancelchanges'] = "c4nc3l ch4n9e\$";
$lang['initialisingdotdotdot'] = "iN1+14LISINg...";
$lang['spellcheckcomplete'] = "sPELL CH3Ck 15 coMPL3T3. TO RE\$+4RT \$pEll cH3ck cL1Ck RE\$+@R+ But+on bEL0W.";
$lang['spellcheck'] = "sP3LL cH3CK";
$lang['noformobj'] = "n0 PHOrM 08J3C+ \$pEC1F1Ed Ph0r R3+urN t3x+";
$lang['ignore'] = "iGN0re";
$lang['ignoreall'] = "i9nOr3 4Ll";
$lang['change'] = "ch4N93";
$lang['changeall'] = "cH4Ng3 4LL";
$lang['add'] = "adD";
$lang['suggest'] = "suGgeSt";
$lang['nosuggestions'] = "(NO \$UG93s+10n\$)";
$lang['cancel'] = "c4NCeL";
$lang['dictionarynotinstalled'] = "no DICt10n@Ry Has beEN inSTalleD. PL34sE C0n+4Ct T3h phorUM 0wNer TO R3m3DY tH1s.";

// Permissions keys ----------------------------------------------------

$lang['postreadingallowed'] = "p0\$+ R3@D1n9 @LLoWEd";
$lang['postcreationallowed'] = "p0\$+ Cr34TioN 4LL0W3D";
$lang['threadcreationallowed'] = "tHrE@d cR34tiOn AlL0w3d";
$lang['posteditingallowed'] = "poS+ eD1+1N9 4LLowEd";
$lang['postdeletionallowed'] = "pO\$t D3l3+1oN @llOwED";
$lang['attachmentsallowed'] = "uPL04D1NG 4+t4chMeN+s 4Ll0weD";
$lang['htmlpostingallowed'] = "htML poSTInG @lL0w3D";
$lang['usersignatureallowed'] = "u\$Er 519nA+ur3 ALL0WED";
$lang['guestaccessallowed'] = "gu3sT @ccE\$\$ 4llOWeD";
$lang['postapprovalrequired'] = "pO\$+ 4pPr0v4l ReqU1reD";

// RSS feeds gubbins

$lang['rssfeed'] = "r\$5 PHeEd";
$lang['every30mins'] = "ev3RY 30 MINuT3s";
$lang['onceanhour'] = "oNCE @N HoUR";
$lang['every6hours'] = "eVeRY 6 H0uRS";
$lang['every12hours'] = "eveRY 12 HoUR\$";
$lang['onceaday'] = "onCE @ D@y";
$lang['onceaweek'] = "oNC3 A wE3k";
$lang['rssfeeds'] = "r5\$ Fe3ds";
$lang['feedname'] = "f33d n4Me";
$lang['feedfoldername'] = "f33D FOlDEr Nam3";
$lang['feedlocation'] = "fEEd L0C@T1ON";
$lang['threadtitleprefix'] = "tHre4d +1TL3 PREFIx";
$lang['feednameandlocation'] = "fe3D n@Me 4ND L0C@t1on";
$lang['feedsettings'] = "f3Ed \$3T+1N9S";
$lang['updatefrequency'] = "upD4+e fREqUEnCY";
$lang['rssclicktoreadarticle'] = "cl1CK H3R3 TO R34D th15 4r+IcLE";
$lang['addnewfeed'] = "aDD n3w PH3Ed";
$lang['editfeed'] = "edi+ Phe3D";
$lang['feeduseraccount'] = "f33d usEr 4CCOUNT";
$lang['noexistingfeeds'] = "no 3xist1N9 r5\$ FE3Ds F0UNd. +0 @dD @ pHe3D CLIck tH3 '4Dd NEW' buttOn 83L0w";
$lang['rssfeedhelp'] = "h3r3 J00 can S3TUp 5oM3 R\$\$ FE3D5 PHor 4UT0MAtiC pR0P49@+I0N IN+o YoUR pHOrum. the 1+3mS Fr0m T3H r\$S F3EDS j00 4Dd WILL b3 CRea+3D 45 thR34DS wHIcH usErs cAN r3PlY +O 4S 1PH th3Y w3r3 NoRMAl Po\$+5. thE Rs5 phEeD MUsT B3 4cCeS\$18lE vi@ H++p oR It WiLL noT work.";
$lang['mustspecifyrssfeedname'] = "mu5+ 5P3CIphY R\$S Fe3D n@mE";
$lang['mustspecifyrssfeeduseraccount'] = "mu\$t SPeciFY rS\$ F3ED U\$3r 4CcoUnt";
$lang['mustspecifyrssfeedfolder'] = "mUs+ spEcIfy rs\$ PHE3D F0LdER";
$lang['mustspecifyrssfeedurl'] = "mUS+ SpEcIphY R\$s f3Ed UrL";
$lang['mustspecifyrssfeedupdatefrequency'] = "mus+ SP3CiPHy Rss F3Ed UpDA+3 PHrEQu3nCy";
$lang['unknownrssuseraccount'] = "unkN0WN Rs5 U5Er 4cCOUnT";
$lang['rssfeedsupportshttpurlsonly'] = "r\$s PhE3D 5UPpoRt\$ H++P URls 0NLy. S3CUrE pHEeD5 (Ht+P5://) 4RE n0t SupPorTeD.";
$lang['rssfeedurlformatinvalid'] = "r5\$ pHe3d URl F0RMA+ 1s 1nv4l1d. urL MU\$+ INCLUdE \$CH3mE (3.9. h++P://) 4nD 4 H0S+nam3 (e.9. WWw.h0s+nAM3.c0m).";
$lang['rssfeeduserauthentication'] = "r\$s F3Ed D035 noT 5uPp0R+ HT+p u\$eR 4uTHEnT1CA+10N";
$lang['successfullyremovedselectedfeeds'] = "suCcE\$SpHuLLy R3m0V3D \$3L3c+3D PhE3D\$";
$lang['successfullyaddedfeed'] = "sUCcESSpHUllY 4DDEd N3w pHE3D";
$lang['successfullyeditedfeed'] = "suCcESSPHUllY eD1+3D PhE3D";
$lang['failedtoremovefeeds'] = "f4iL3D t0 REM0VE 5OME 0r @ll OF tH3 \$3l3c+3D PhE3D\$";
$lang['failedtoaddnewrssfeed'] = "f4ilED +o Add nEW Rss F3Ed";
$lang['failedtoupdaterssfeed'] = "f@1lEd To UpD4+E R5\$ PhEEd";
$lang['rssstreamworkingcorrectly'] = "rs\$ stR34M 4PPe@Rs +O B3 WORk1n9 COrrEc+LY";
$lang['rssstreamnotworkingcorrectly'] = "rss \$TR3@M w4S 3MptY 0R c0uLd Not bE pH0UNd";
$lang['invalidfeedidorfeednotfound'] = "inv4L1D f3Ed Id or PH3Ed NOT pH0unD";

// PM Export Options

$lang['pmexportastype'] = "eXPor+ 4\$ +YPE";
$lang['pmexporthtml'] = "htmL";
$lang['pmexportxml'] = "xMl";
$lang['pmexportplaintext'] = "pl41N teXt";
$lang['pmexportmessagesas'] = "exp0R+ MeS\$493s 4s";
$lang['pmexportonefileforallmessages'] = "oNE FiLE PhoR 4LL M3\$\$4Ge\$";
$lang['pmexportonefilepermessage'] = "oN3 FIlE pER m3s54gE";
$lang['pmexportattachments'] = "exp0rt @TTaCHMeNTS";
$lang['pmexportincludestyle'] = "iNcLUde pH0Rum STylE Sh3E+";
$lang['pmexportwordfilter'] = "aPPLy W0Rd FiL+3r +o mE\$\$@93S";
$lang['failedtoexportmessages'] = "f41L3d T0 exP0r+ MesS493\$";

// Thread merge / split options

$lang['threadhasbeensplit'] = "thR3Ad H4S b3eN spl1+";
$lang['threadhasbeenmerged'] = "tHr34d h@s 83En M3rG3D";
$lang['mergesplitthread'] = "m3Rg3 / sPLIt +hrE4D";
$lang['mergewiththreadid'] = "m3RGe W1Th +Hr34d Id:";
$lang['postsinthisthreadatstart'] = "po\$+5 1N +Hi5 +HrEad a+ ST@R+";
$lang['postsinthisthreadatend'] = "poSt\$ iN +H1s +hr34d @T 3nD";
$lang['reorderpostsintodateorder'] = "r3-0RDeR P0STS 1NT0 d4t3 0rD3r";
$lang['splitthreadatpost'] = "sPLIT tHR34D 4+ PO5T:";
$lang['selectedpostsandrepliesonly'] = "sELEcT3D Po5T @nD R3PLiE\$ 0NLY";
$lang['selectedandallfollowingposts'] = "selEcT3D @Nd 4LL ph0lL0WIN9 PO5+S";

$lang['threadmovedhere'] = "h3R3";

$lang['thisthreadhasmoved'] = "<b>thr3@D5 M3RG3D:</b> +h15 +HR3@d h4s M0V3D %s";
$lang['thisthreadwasmergedfrom'] = "<b>thr3@Ds M3R9Ed:</b> tH1\$ tHrE@D W4s MeRG3D pHR0M %s";
$lang['somepostsinthisthreadhavebeenmoved'] = "<b>thr34d \$PLI+:</b> soME p0sTS in +hI\$ ThRE@d H4Ve 83EN M0V3d %s";
$lang['somepostsinthisthreadweremovedfrom'] = "<b>thrE@D SpliT:</b> som3 Pos+S 1N +H1s thRe@D wERE M0V3D pHroM %s";

$lang['thisposthasbeenmoved'] = "<b>tHr34d \$PLI+:</b> tH1S Po5+ H@s b3en M0vEd %s";

$lang['invalidfunctionarguments'] = "iNV4L1D fUncTIOn @RGuMEnt\$";
$lang['couldnotretrieveforumdata'] = "couLD not RE+R13v3 fOruM D4T4";
$lang['cannotmergepolls'] = "onE Or Mor3 tHrEAdS I5 @ PoLL. j00 c4NNoT mERg3 poll\$";
$lang['couldnotretrievethreaddatamerge'] = "couLd N0+ rE+R13vE tHR3@d D@+4 fRoM oN3 or mor3 +HR34D5";
$lang['couldnotretrievethreaddatasplit'] = "c0uLD nO+ rETrI3v3 THrEAd D4T4 fr0M S0URcE +HRe@D";
$lang['couldnotretrievepostdatamerge'] = "c0UlD noT rETri3v3 PO5+ d4+4 pHROm 0N3 0R M0Re THReADs";
$lang['couldnotretrievepostdatasplit'] = "c0uLD n0+ REtr1EVe P0ST d4ta phR0m SOURC3 +HrE@d";
$lang['failedtocreatenewthreadformerge'] = "fAIL3D To cr34+E nEw THRe4d foR mEr9e";
$lang['failedtocreatenewthreadforsplit'] = "faIlED +o cR3@T3 N3w +Hr3@d f0R \$plI+";
$lang['nopermissiontomergethreads'] = "j00 4r3 NOt pErM1+TeD +0 m3r9E t3H \$elEc+3D +hr34d5";

// Thread subscriptions

$lang['threadsubscriptions'] = "tHre@D \$u8sCRipTioN\$";
$lang['couldnotupdateinterestonthread'] = "c0uld not uPd4+3 inTEr35+ On ThREaD '%s'";
$lang['threadinterestsupdatedsuccessfully'] = "thRe@D 1nTErE\$t5 UpD@tED SUccESSfULly";
$lang['nothreadsubscriptions'] = "j00 arE NoT Su8SCr18eD +0 anY tHrE@dS.";
$lang['nothreadsignored'] = "j00 @rE n0t 19NorIN9 4NY +Hr34d5.";
$lang['nothreadsonhighinterest'] = "j00 H4V3 No h1gh INt3r3ST +Hr34Ds.";
$lang['resetselected'] = "r3\$3t \$3lEc+3D";
$lang['ignoredthreads'] = "ign0R3D +hR34DS";
$lang['highinterestthreads'] = "h19h iN+3Re\$t +Hr3@D\$";
$lang['subscribedthreads'] = "sUBScRI83D THr34DS";
$lang['currentinterest'] = "cUrrEn+ INt3re5T";

// Folder subscriptions

$lang['foldersubscriptions'] = "fOldEr 5UBsCRiP+1oNS";
$lang['couldnotupdateinterestonfolder'] = "c0UlD noT uPd4t3 1n+ERE\$+ 0N foLdER '%s'";
$lang['folderinterestsupdatedsuccessfully'] = "foLd3r 1NT3R3s+5 UPD4TEd SuCc3sSFuLLY";
$lang['nofoldersubscriptions'] = "j00 4Re n0t sUBsCR1B3D +O @nY foldER5.";
$lang['nofoldersignored'] = "j00 4RE N0+ I9NOR1N9 4nY FOldERS.";
$lang['resetselected'] = "re53T \$3lEc+3D";
$lang['ignoredfolders'] = "iGnOR3D pHOLdEr5";
$lang['subscribedfolders'] = "sUBSCR1BEd F0LdERS";

// Browseable user profiles

$lang['youcanonlyaddthreecolumns'] = "j00 caN OnlY 4Dd 3 C0LuMns. +0 AdD 4 n3W coLuMN CL0s3 @n 3x1s+inG 0nE";
$lang['columnalreadyadded'] = "j00 H@Ve 4LRE@DY 4DdEd +H1S ColUmn. iF J00 W4nT +o R3m0V3 I+ CL1Ck 1t\$ Cl0\$3 8U++oN";

?>