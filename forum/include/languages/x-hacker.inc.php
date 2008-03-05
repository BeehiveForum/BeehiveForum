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

/* $Id: x-hacker.inc.php,v 1.271 2008-03-05 13:55:40 decoyduck Exp $ */

// British English language file

// Language character set and text direction options -------------------

$lang['_isocode'] = "en";
$lang['_textdir'] = "ltr";

// Months --------------------------------------------------------------

$lang['month'][1]  = "j4nu@rY";
$lang['month'][2]  = "fE8rU@RY";
$lang['month'][3]  = "m4rCH";
$lang['month'][4]  = "apR1l";
$lang['month'][5]  = "m4Y";
$lang['month'][6]  = "jUN3";
$lang['month'][7]  = "jUly";
$lang['month'][8]  = "augU\$T";
$lang['month'][9]  = "s3ptEM83r";
$lang['month'][10] = "oct0BEr";
$lang['month'][11] = "n0V3m8eR";
$lang['month'][12] = "d3cEM83R";

$lang['month_short'][1]  = "j@n";
$lang['month_short'][2]  = "fe8";
$lang['month_short'][3]  = "m4R";
$lang['month_short'][4]  = "aPr";
$lang['month_short'][5]  = "m@y";
$lang['month_short'][6]  = "jUn";
$lang['month_short'][7]  = "jUl";
$lang['month_short'][8]  = "aUG";
$lang['month_short'][9]  = "s3p";
$lang['month_short'][10] = "oct";
$lang['month_short'][11] = "nov";
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

$lang['date_periods']['year']   = "%s yE4r";
$lang['date_periods']['month']  = "%s moNTH";
$lang['date_periods']['week']   = "%s w33k";
$lang['date_periods']['day']    = "%s d@Y";
$lang['date_periods']['hour']   = "%s hoUr";
$lang['date_periods']['minute'] = "%s minUTe";
$lang['date_periods']['second'] = "%s \$3c0nD";

// As above but plurals (2 years vs. 1 year, etc.)

$lang['date_periods_plural']['year']   = "%s yE4r\$";
$lang['date_periods_plural']['month']  = "%s M0n+HS";
$lang['date_periods_plural']['week']   = "%s wE3KS";
$lang['date_periods_plural']['day']    = "%s d@yS";
$lang['date_periods_plural']['hour']   = "%s H0Ur5";
$lang['date_periods_plural']['minute'] = "%s M1nUT3\$";
$lang['date_periods_plural']['second'] = "%s \$eCONDS";

// Short hand periods (example: 1y, 2m, 3w, 4d, 5hr, 6min, 7sec)

$lang['date_periods_short']['year']   = "%sY";    // 1y
$lang['date_periods_short']['month']  = "%sM";    // 2m
$lang['date_periods_short']['week']   = "%sw";    // 3w
$lang['date_periods_short']['day']    = "%sd";    // 4d
$lang['date_periods_short']['hour']   = "%shr";   // 5hr
$lang['date_periods_short']['minute'] = "%sMiN";  // 6min
$lang['date_periods_short']['second'] = "%s\$eC";  // 7sec

// Common words --------------------------------------------------------

$lang['percent'] = "p3rC3NT";
$lang['average'] = "aV3r49E";
$lang['approve'] = "aPPROv3";
$lang['banned'] = "b4nN3d";
$lang['locked'] = "locK3d";
$lang['add'] = "aDD";
$lang['advanced'] = "adV@Nc3d";
$lang['active'] = "aC+IVE";
$lang['style'] = "styl3";
$lang['go'] = "go";
$lang['folder'] = "f0ld3R";
$lang['ignoredfolder'] = "igN0rED FOLDER";
$lang['folders'] = "f0lDers";
$lang['thread'] = "thRE4D";
$lang['threads'] = "thR3@dS";
$lang['threadlist'] = "tHR3AD L1\$+";
$lang['message'] = "mess493";
$lang['from'] = "froM";
$lang['to'] = "t0";
$lang['all_caps'] = "aLL";
$lang['of'] = "opH";
$lang['reply'] = "r3PlY";
$lang['forward'] = "f0RWARd";
$lang['replyall'] = "r3PLY T0 4LL";
$lang['pm_reply'] = "r3PLY @5 Pm";
$lang['delete'] = "d3LE+3";
$lang['deleted'] = "d3Let3D";
$lang['edit'] = "eDi+";
$lang['privileges'] = "pRIVILEG35";
$lang['ignore'] = "iGn0r3";
$lang['normal'] = "norMAl";
$lang['interested'] = "in+ereStED";
$lang['subscribe'] = "sUBscr1B3";
$lang['apply'] = "aPPLY";
$lang['download'] = "dOwNLo4d";
$lang['save'] = "s4v3";
$lang['update'] = "upd@+3";
$lang['cancel'] = "c@NCEl";
$lang['continue'] = "coN+INue";
$lang['attachment'] = "a+t4CHm3nT";
$lang['attachments'] = "a+t4CHMEntS";
$lang['imageattachments'] = "im49E 4T+4cHMEn+S";
$lang['filename'] = "fIL3N@M3";
$lang['dimensions'] = "diMENS10Ns";
$lang['downloadedxtimes'] = "dOwNL0@d3d: %d +1me\$";
$lang['downloadedonetime'] = "dOWNL04D3d: 1 +1m3";
$lang['size'] = "s1ZE";
$lang['viewmessage'] = "vi3W M3ss@G3";
$lang['deletethumbnails'] = "d3l3+e thuMBN@1L\$";
$lang['logon'] = "l0GON";
$lang['more'] = "m0r3";
$lang['recentvisitors'] = "r3CEN+ VIS1T0Rs";
$lang['username'] = "useRN@ME";
$lang['clear'] = "cl3@R";
$lang['action'] = "aC+1on";
$lang['unknown'] = "unKN0WN";
$lang['none'] = "nON3";
$lang['preview'] = "previ3w";
$lang['post'] = "pOST";
$lang['posts'] = "post\$";
$lang['change'] = "ch4n93";
$lang['yes'] = "y3\$";
$lang['no'] = "n0";
$lang['signature'] = "s19N@TURE";
$lang['signaturepreview'] = "sIgN4TUrE pREviEw";
$lang['signatureupdated'] = "s1GN4TUre UPDa+3D";
$lang['signatureupdatedforallforums'] = "sI9n@+URe upD4+ED foR aLL Ph0RUms";
$lang['back'] = "b4CK";
$lang['subject'] = "sU8jEct";
$lang['close'] = "cL0s3";
$lang['name'] = "n4m3";
$lang['description'] = "dE\$cRiPT1oN";
$lang['date'] = "d4+3";
$lang['view'] = "v13w";
$lang['enterpasswd'] = "eN+eR P4\$Sw0RD";
$lang['passwd'] = "p4\$swORd";
$lang['ignored'] = "iGnorEd";
$lang['guest'] = "gue\$+";
$lang['next'] = "n3x+";
$lang['prev'] = "preV10U\$";
$lang['others'] = "otH3RS";
$lang['nickname'] = "n1CKn4m3";
$lang['emailaddress'] = "em41l @DDR3SS";
$lang['confirm'] = "cONPH1RM";
$lang['email'] = "eM@iL";
$lang['poll'] = "p0Ll";
$lang['friend'] = "fR13ND";
$lang['success'] = "sUCCEss";
$lang['error'] = "error";
$lang['warning'] = "w@RN1nG";
$lang['guesterror'] = "sORRY, j00 N33d +O BE LOG9Ed 1N +0 Use THIS FE4tUr3.";
$lang['loginnow'] = "lo9iN NoW";
$lang['unread'] = "unre4D";
$lang['all'] = "all";
$lang['allcaps'] = "aLl";
$lang['permissions'] = "p3RM1sSION\$";
$lang['type'] = "tYP3";
$lang['print'] = "pr1n+";
$lang['sticky'] = "sT1CKY";
$lang['polls'] = "p0ll5";
$lang['user'] = "u5eR";
$lang['enabled'] = "eNaBLeD";
$lang['disabled'] = "d1S48LEd";
$lang['options'] = "oP+IoN\$";
$lang['emoticons'] = "eM0+1COnS";
$lang['webtag'] = "w3b+49";
$lang['makedefault'] = "m4k3 D3f4Ult";
$lang['unsetdefault'] = "uN\$3t D3PH4Ult";
$lang['rename'] = "r3N4ME";
$lang['pages'] = "p49eS";
$lang['used'] = "uSED";
$lang['days'] = "dAy\$";
$lang['usage'] = "uS4g3";
$lang['show'] = "sH0w";
$lang['hint'] = "hIN+";
$lang['new'] = "n3W";
$lang['referer'] = "r3PH3R3R";
$lang['thefollowingerrorswereencountered'] = "the pHOll0wIN9 erROrs W3RE EnC0un+3rED:";

// Admin interface (admin*.php) ----------------------------------------

$lang['admintools'] = "adMIN to0LS";
$lang['forummanagement'] = "fOruM mAN@GEmeN+";
$lang['accessdeniedexp'] = "j00 DO NOT h4V3 P3RM1sSI0N to U\$E +hiS SEC+I0N.";
$lang['managefolders'] = "m4n@93 PH0ld3r\$";
$lang['manageforums'] = "m4n@GE PHORUMS";
$lang['manageforumpermissions'] = "m4n4g3 F0Rum PerMi\$SI0NS";
$lang['foldername'] = "f0lD3R n@Me";
$lang['move'] = "mov3";
$lang['closed'] = "cl0s3D";
$lang['open'] = "oP3N";
$lang['restricted'] = "rE\$TR1CTEd";
$lang['forumiscurrentlyclosed'] = "%s 15 CUrR3NtlY CLosEd";
$lang['youdonothaveaccesstoforum'] = "j00 D0 N0T H4V3 ACcESs +O %s";
$lang['toapplyforaccessplease'] = "tO ApPLy F0R 4CcE55 Ple4s3 c0nT@cT +h3 F0Rum 0Wn3r.";
$lang['adminforumclosedtip'] = "iF J00 W4N+ +O cH4N9E 5OMe \$3T+1N9S 0N yOUr F0RUm CLIck tH3 4Dm1n LInK iN t3H n4V194TI0N B4R 480vE.";
$lang['newfolder'] = "new PhoLD3R";
$lang['nofoldersfound'] = "n0 eX1sTIN9 PH0lDER5 FOUND. TO @DD A F0LD3r CL1CK T3h '4Dd NEW' bU++0n 8eL0W.";
$lang['forumadmin'] = "fORUM 4dm1n";
$lang['adminexp_1'] = "u53 +H3 meNU 0N +HE l3fT +0 mAN49E tHInG5 1N yoUr F0Rum.";
$lang['adminexp_2'] = "<b>usERS</b> @LLOwS j00 +0 \$3T 1nDiv1DU4L us3R P3RmI\$s1oNS, INcLUdiNg 4PP0in+InG m0DEr@TORs 4Nd 94G9InG p3OpL3.";
$lang['adminexp_3'] = "<b>user 9ROuPS</b> 4ll0W\$ J00 +0 CRea+e U\$eR 9ROUPS +0 @Ss1GN p3RM1s\$ion\$ +o 4S M4ny OR A\$ feW US3rs QUIcKLy 4nD 34sIlY.";
$lang['adminexp_4'] = "<b>b@n cONTr0L\$</b> ALl0W\$ +EH 8@Nn1N9 AnD UN-8@nN1Ng 0F iP 4DdREs\$3S, hTTP RePH3R3r5, U5ERNAMes, EM41l @ddRESS3s 4ND NicKN4MES.";
$lang['adminexp_5'] = "<b>folDER\$</b> 4lLOW5 THe CRE4TIon, mOdiFIc@T10N @nd DELe+1oN OF F0LDer\$.";
$lang['adminexp_6'] = "<b>r\$s Ph33D\$</b> 4llowS J00 +O m4N49E rs\$ fEed\$ f0r Pr0P494+I0N 1ntO Y0uR FORUm.";
$lang['adminexp_7'] = "<b>prof1LES</b> l3t5 J00 Cu\$t0MISe tEH 1tEMs ThA+ 4pPe4r IN th3 US3r PROfiLE\$.";
$lang['adminexp_8'] = "<b>fORuM \$eTt1N9\$</b> 4llOW\$ J00 +0 cU5tomi\$3 Y0Ur Ph0RUm'S n4M3, 4pP3@r4Nc3 4ND M4NY o+Her TH1ng\$.";
$lang['adminexp_9'] = "<b>s+4R+ p49E</b> L3TS j00 CuST0Mi\$E yOUr F0RuM's S+4rT p49E.";
$lang['adminexp_10'] = "<b>fOrUM sTYl3</b> ALl0W5 J00 +0 93N3Ra+3 R@Nd0m StyLes F0R yoUR pHORUm MEm83r\$ T0 U\$3.";
$lang['adminexp_11'] = "<b>w0Rd FIlt3R</b> 4LLOwS J00 +o PHilTEr WORd\$ J00 doN'+ WAn+ +O 8E u\$3D 0N y0uR PH0RUM.";
$lang['adminexp_12'] = "<b>p0s+1Ng ST4T\$</b> geN3RA+e\$ a RepORt L15+1N9 THe TOP 10 PosT3RS 1n @ D3FiN3D p3RI0d.";
$lang['adminexp_13'] = "<b>f0RUM l1Nks</b> le+5 J00 m@N@GE t3h L1NkS dr0PdowN 1n +h3 n4VigATIon 8@R.";
$lang['adminexp_14'] = "<b>v13W loG</b> lIS+s ReC3NT 4c+1ONS 8Y tHe F0RUm MOdER@+oRS.";
$lang['adminexp_15'] = "<b>m@n49E f0RUmS</b> L3+S J00 cr34+3 And DeL3+3 4ND CL0S3 OR r30P3N f0RUM\$.";
$lang['adminexp_16'] = "<b>gL0b4L PH0RUM \$3++1N9s</b> ALL0W\$ J00 TO moDIFY SE+t1N9s WHICH AFPH3C+ @Ll F0RUMS.";
$lang['adminexp_17'] = "<b>p0S+ 4PPr0v4L QuEUE</b> ALl0Ws J00 +0 VieW 4NY po\$+s 4W41+In9 4PProV4L 8y 4 M0D3R4TOR.";
$lang['adminexp_18'] = "<b>v1\$iTOR Lo9</b> 4lLOws J00 TO V1EW 4n 3xT3ND3D l15T 0PH v1\$1+0rS 1ncluD1NG th3IR hTTp reF3R3R\$.";
$lang['createforumstyle'] = "cre4TE @ Ph0RUm \$tYl3";
$lang['newstylesuccessfullycreated'] = "n3w sTYlE \$UCcEs\$PHuLLy CR3@+3D.";
$lang['stylealreadyexists'] = "a 5+YlE w1+H +H@+ F1L3NaME 4lREaDY EXi\$Ts.";
$lang['stylenofilename'] = "j00 DId N0T 3N+eR @ Ph1lEN@m3 +0 S@V3 +3H S+yL3 WiTH.";
$lang['stylenodatasubmitted'] = "c0uLD NO+ R3@D PH0RuM sTYL3 D4T4.";
$lang['styleexp'] = "us3 +H1\$ p@GE tO H3LP cR34+3 @ R@ND0MLY G3NER4+3D stylE F0R YOUr F0RUM.";
$lang['stylecontrols'] = "c0ntr0LS";
$lang['stylecolourexp'] = "cLiCk ON 4 CoL0ur To M@Ke 4 N3W 5+yL3 \$h3E+ 8@S3D oN tH@T C0LOur. CurR3N+ 8@s3 coLOuR IS F1RS+ IN l1\$+.";
$lang['standardstyle'] = "sT4NDARD \$TYLe";
$lang['rotelementstyle'] = "r0T4+Ed EL3MeNT \$TYl3";
$lang['randstyle'] = "r@ND0m STyLE";
$lang['thiscolour'] = "thi\$ C0l0uR";
$lang['enterhexcolour'] = "or ENT3R @ H3x C0LOUr TO 84S3 4 N3W \$tyL3 5He3t 0n";
$lang['savestyle'] = "s@VE THis \$tYL3";
$lang['styledesc'] = "s+yL3 DesCRiPTi0n";
$lang['stylefilenamemayonlycontain'] = "s+yL3 F1L3N@mE M4Y 0NLY cOnT@IN l0wERC@s3 LETT3r5 (4-Z), nUM8Er\$ (0-9) AND unDERSc0R3.";
$lang['stylepreview'] = "sTYl3 PR3vIEw";
$lang['welcome'] = "welC0m3";
$lang['messagepreview'] = "m3ss@93 PR3VI3W";
$lang['users'] = "u53RS";
$lang['usergroups'] = "u\$3R GroUpS";
$lang['mustentergroupname'] = "j00 MUS+ 3N+3r 4 GR0uP n4m3";
$lang['profiles'] = "pr0PHil3S";
$lang['manageforums'] = "m4N@9E Ph0RUMS";
$lang['forumsettings'] = "f0RuM SE++inG\$";
$lang['globalforumsettings'] = "gloBaL f0rUM \$3++1N9\$";
$lang['settingsaffectallforumswarning'] = "<b>n0+3:</b> THe\$3 S3+T1nG\$ 4PHphEcT @LL f0RumS. WHerE tEh \$3T+1NG 1s duPLiC4+3D 0N TEh Ind1V1Du@L PHoRUM'\$ Se+tIn9s PAG3 TH4+ W1LL +4kE PreCEdeNC3 oV3R THe SET+1NGs J00 Ch4n9e Here.";
$lang['startpage'] = "sT@RT p@93";
$lang['startpageerror'] = "yoUr s+Art p49e COULD nOt 83 S4V3D L0C4LLY +O TEh sERV3R 83c@USE p3RM1\$5i0N W@s d3niEd.</p><p>tO ChaNg3 YoUR \$T@R+ p493 PleA\$3 CliCK +3h d0wnLO4d 8u++0n BELow WH1CH WILL PR0mPT j00 +0 S@VE +H3 F1LE T0 YOUR H4rD dr1vE. j00 CAN +HeN UPL0@d +H15 F1L3 +0 YoUR S3RVER 1NtO tH3 phoLl0WIn9 F0LD3r, 1f NECES5@Ry CRE4+1Ng +EH f0lD3R STRUctUR3 IN +3h PROC3sS.</p><p><b>%s</b></p><p>pLE@s3 n0+3 thAt SOmE br0W\$ErS M4Y cH@NgE Th3 n@M3 OF tEH FIl3 UpoN doWNLO@d. WhEN UPLO@DIN9 +h3 PHIl3 Pl3@SE M4K3 SUrE tHAt 1+ 1S naMeD sT@RT_M41n.PHP OtHErw1\$3 YOuR \$T4r+ p4g3 W1LL @PP3@R Unch4N9eD.";
$lang['failedtoopenmasterstylesheet'] = "y0uR foRum S+YL3 coULd N0+ bE s@vED beC4USE TEh M4S+3R \$+YLe 5H3ET COulD n0+ 83 lO4DeD. +O s4V3 YouR \$+yl3 +3H m4sT3R S+yL3 SH3E+ (m4K3_\$+YlE.Css) MUST b3 L0C4+3D in +3H s+yl3\$ DIR3Ct0RY 0f YOuR 833HiV3 f0RUM 1N\$t@Ll4+10n.";
$lang['makestyleerror'] = "your pH0rUM STyl3 COULD noT 83 S@v3D l0C4LLy TO +H3 S3RvER beC4US3 P3RM1Ss1ON W4s D3N1ED.</p><p>t0 5Ave yoUR f0rUm S+yLE plE4s3 Cl1ck +He d0WNlO4d 8u+tON 8ELoW WH1CH W1LL Pr0mPT J00 tO SAV3 +EH F1lE t0 Y0UR H4RD DriV3. J00 C4N +H3n UPlo4D THI\$ PHIL3 TO YoUR 5ERVER iN+O TH3 FOlLOWinG FolDER, IPH n3cE\$S@RY cRE4+1NG THe F0LD3R 5+RUcTUrE 1N THe PR0C3\$s.</p><p><b>%s</b></p><p>pl3@SE Note TH@T SoME 8r0w\$ER\$ MaY CH4n9E TEH N4m3 0f +3h phiLE UP0n doWNl04d. WhEN UPlo4D1NG +h3 F1L3 PLeA\$3 M4KE \$uRE +h4t I+ 1S NAM3d \$+Yl3.C\$5 0+h3rW1s3 +HE ForUm \$+YLe wILL B3 uN@V@1LABL3.";
$lang['forumstyle'] = "fORUm \$+yLe";
$lang['wordfilter'] = "w0RD pHiL+3R";
$lang['forumlinks'] = "fOrum l1NK\$";
$lang['viewlog'] = "v13w lOG";
$lang['noprofilesectionspecified'] = "nO PROF1L3 S3CT10N SpECIf13d.";
$lang['itemname'] = "iT3M N4M3";
$lang['moveto'] = "mOV3 +0";
$lang['manageprofilesections'] = "m4n49E pR0FIl3 \$EC+I0NS";
$lang['sectionname'] = "sec+I0N N@ME";
$lang['items'] = "it3Ms";
$lang['mustspecifyaprofilesectionid'] = "mu\$T \$PEcIFy @ PROfiLe S3CtIOn Id";
$lang['mustsepecifyaprofilesectionname'] = "mU5+ Sp3c1PHY @ ProF1L3 5ECTIOn n4Me";
$lang['noprofilesectionsfound'] = "no 3X1\$+IN9 proPhiLE S3CTIOn5 PhoUND. +O @Dd 4 Pr0fILE \$3C+10n ClICK tHE 'aDD N3W' bU++0N 83l0w.";
$lang['addnewprofilesection'] = "aDd N3W PROfILe \$3C+1oN";
$lang['successfullyaddedprofilesection'] = "sucCe5sFulLy 4DD3D pR0fIL3 \$3CTIon";
$lang['successfullyeditedprofilesection'] = "sUCC3\$SphUlLy Ed1t3D Pr0FiL3 SeCTioN";
$lang['addnewprofilesection'] = "aDd NeW PR0FIL3 \$Ec+10n";
$lang['mustsepecifyaprofilesectionname'] = "must SPeC1FY @ pROfIL3 S3CtION n@mE";
$lang['successfullyremovedselectedprofilesections'] = "sUcCEssPHuLLy r3M0VeD S3l3c+Ed pR0PhiL3 sEcTi0n\$";
$lang['failedtoremoveprofilesections'] = "fAIl3D +O rEM0ve PrOpHIl3 \$3Ct10nS";
$lang['viewitems'] = "vIEw 1TEmS";
$lang['successfullyaddednewprofileitem'] = "suCC3\$\$pHUlly 4dD3d N3W PrOfil3 1tEm";
$lang['successfullyeditedprofileitem'] = "sUcCE5sFUllY ED1+3D Pr0fIL3 1TEM";
$lang['successfullyremovedselectedprofileitems'] = "sucCESSphuLly r3mOVed \$3LeCTeD Pr0f1LE It3ms";
$lang['failedtoremoveprofileitems'] = "f@1L3D t0 R3MOV3 pr0PH1L3 ITEMS";
$lang['noexistingprofileitemsfound'] = "th3RE 4r3 N0 3x1sTIN9 pR0F1L3 I+3MS iN th1\$ \$ECTI0N. T0 4DD 4n ITEM CLicK +H3 'add n3w' 8u+TON BEl0w.";
$lang['edititem'] = "edi+ i+em";
$lang['invalidprofilesectionid'] = "inv@LID pR0PH1LE \$EC+1oN ID 0r 5eC+1ON N0T pHOUNd";
$lang['invalidprofileitemid'] = "inVALid pR0PHiLe I+eM 1D 0R ITeM n0T PhoUnD";
$lang['addnewitem'] = "add N3W i+3M";
$lang['youmustenteraprofileitemname'] = "j00 Mu\$+ eN+3R @ PrOPhIL3 1t3M n4Me";
$lang['invalidprofileitemtype'] = "inV4LId pR0PH1L3 1T3M +Yp3 sELEcTEd";
$lang['youmustenteroptionsforselectedprofileitemtype'] = "j00 MU\$+ enT3R S0mE oPTions F0R S3LECtED Pr0f1L3 I+3M TyPE";
$lang['youmustentermorethanoneoptionforitem'] = "j00 Mu\$t 3NT3R moR3 Th4N 0NE 0p+1oN Ph0R s3L3C+ed Pr0PH1Le I+em tYPE";
$lang['profileitemhyperlinkssupportshttpurlsonly'] = "pR0PHiL3 i+Em HYp3RlINks \$UPP0r+ H++p URl\$ 0nLY";
$lang['profileitemhyperlinkformatinvalid'] = "pr0f1le 1TEm HYPerL1NK f0rM4T 1NVALid";
$lang['youmustincludeprofileentryinhyperlinks'] = "j00 Mus+ 1NClud3 <i>%s</i> 1n THE UrL OF cliCK48LE hyP3RLInk\$";
$lang['failedtocreatenewprofileitem'] = "fa1L3D to CR3@t3 nEW pR0Ph1lE ITem";
$lang['failedtoupdateprofileitem'] = "fail3D +0 uPd4T3 pR0FilE 1TeM";
$lang['startpageupdated'] = "s+4RT p4g3 UpD4+Ed. %s";
$lang['viewupdatedstartpage'] = "v1eW UpDA+Ed \$+@R+ P4G3";
$lang['editstartpage'] = "edi+ st4RT P4Ge";
$lang['nouserspecified'] = "no U\$eR sP3C1pHIED.";
$lang['manageuser'] = "m4n493 U\$3r";
$lang['manageusers'] = "m4n49E uS3RS";
$lang['userstatusforforum'] = "u\$ER S+@+uS f0R %s";
$lang['userdetails'] = "uS3r DeT4Il\$";
$lang['warning_caps'] = "warNINg";
$lang['userdeleteallpostswarning'] = "ar3 J00 sURe J00 w4N+ To dEl3+3 4LL oF THe S3LeC+3D USEr'S p0\$+S? 0nc3 Th3 Pos+s @R3 d3lE+3D ThEy CAnN0T 8E r3+RiEV3D aND wIlL bE LosT PH0R3v3r.";
$lang['postssuccessfullydeleted'] = "pOstS wERE sUCC3S\$FUlLY D3Le+3D.";
$lang['folderaccess'] = "f0lD3R 4CcES\$";
$lang['possiblealiases'] = "poSS18L3 4li4se\$";
$lang['userhistory'] = "u\$3R hI5TOrY";
$lang['nohistory'] = "n0 Hi\$toRy ReC0Rd\$ \$@V3D";
$lang['userhistorychanges'] = "cHaN9ES";
$lang['clearuserhistory'] = "cl34R U\$ER h15+0RY";
$lang['changedlogonfromto'] = "ch@NGEd logon PHroM %s tO %s";
$lang['changednicknamefromto'] = "chANGEd NIcKn4m3 pHR0M %s t0 %s";
$lang['changedemailfromto'] = "ch4NgeD eM41L fROm %s tO %s";
$lang['successfullycleareduserhistory'] = "sUcC35\$pHULLy CL34R3D USer hiST0RY";
$lang['failedtoclearuserhistory'] = "f@1lED +0 CLE4r UseR H1sToRY";
$lang['successfullychangedpassword'] = "sUCce\$spHuLLy Ch@Ng3d P@\$sW0RD";
$lang['failedtochangepasswd'] = "f41L3D tO cH@nGE P4S\$w0RD";
$lang['viewuserhistory'] = "v1EW U\$3r H1STorY";
$lang['viewuseraliases'] = "v13W U\$3r @L14SES";
$lang['searchreturnednoresults'] = "s34RCh R3+URnED N0 R3SULT\$";
$lang['deleteposts'] = "dEL3+3 po\$+S";
$lang['deleteuser'] = "dEL3T3 us3R";
$lang['alsodeleteusercontent'] = "als0 DELeTE @LL 0F TEh c0NTEN+ CR34+3D 8Y tHIS u\$3R";
$lang['userdeletewarning'] = "aR3 J00 sur3 J00 W@nT +O d3lE+3 tEh \$ElECt3D u5ER @CCoUN+? OnC3 tHE @CCOun+ Ha\$ bE3N dELE+Ed It CaNn0T 83 r3+RieV3D 4Nd WiLl be LOsT PhoREV3r.";
$lang['usersuccessfullydeleted'] = "u53R sUcC3sSpHUlLY dEL3TeD";
$lang['failedtodeleteuser'] = "f41LED +O DelETE US3r";
$lang['forgottenpassworddesc'] = "if TH1s us3R Has FOr90+tEN th31R p@\$SW0RD j00 C4n r3s3T 1+ Ph0r THem HERe.";
$lang['failedtoupdateuserstatus'] = "f41LED to UPD@T3 U\$3R S+AtuS";
$lang['failedtoupdateglobaluserpermissions'] = "fAiLed T0 UPD4+3 9L0B@L u\$3R p3rMi\$S1oN\$";
$lang['failedtoupdatefolderaccesssettings'] = "f4iL3D +O Upd4T3 F0LdER 4cCESs \$3++IN9s";
$lang['manageusersexp'] = "th1\$ l1s+ 5H0WS A s3L3CT10N 0F usER\$ WHO H4vE LOggED On T0 YOuR F0RUM, \$OR+3d 8Y %s. T0 @ltER @ US3R'S pERm1s51ons Cl1cK tH31R N4M3.";
$lang['userfilter'] = "u53r PHil+3r";
$lang['onlineusers'] = "oNL1NE uSeR\$";
$lang['offlineusers'] = "offlIN3 u\$er5";
$lang['usersawaitingapproval'] = "uSERS 4W@1t1N9 4PpROV4L";
$lang['bannedusers'] = "b@Nn3d US3R\$";
$lang['lastlogon'] = "l4s+ lOGoN";
$lang['sessionreferer'] = "s3ss1ON REpH3ReR";
$lang['signupreferer'] = "s19N-Up r3FErER:";
$lang['nouseraccountsmatchingfilter'] = "n0 USEr 4cc0uNTS M4+CHiNG pHILt3r";
$lang['searchforusernotinlist'] = "sE4rCH PH0R @ USER NO+ in l1\$T";
$lang['adminaccesslog'] = "aDmIN 4CCesS l09";
$lang['adminlogexp'] = "this LI5+ SH0wS +h3 L4S+ ActIoN5 \$@NC+10NEd BY us3R5 W1+H AdM1N pRIv1lEGes.";
$lang['datetime'] = "dAt3/+1me";
$lang['unknownuser'] = "uNkNOWN uSeR";
$lang['unknownuseraccount'] = "uNKN0wN u\$3R 4CcOUN+";
$lang['unknownfolder'] = "unkN0Wn PhOLdeR";
$lang['ip'] = "iP";
$lang['lastipaddress'] = "l@\$+ Ip 4DDRESS";
$lang['hostname'] = "hOs+NaME";
$lang['unknownhostname'] = "uNkNOwN H0s+n4Me";
$lang['logged'] = "l09gEd";
$lang['notlogged'] = "n0t L0G93D";
$lang['addwordfilter'] = "aDD w0RD F1LtER";
$lang['addnewwordfilter'] = "adD n3W woRD pH1LT3r";
$lang['wordfilterupdated'] = "worD f1LTEr updA+3D";
$lang['wordfilterisfull'] = "j00 C4nNO+ adD aNY m0r3 W0RD ph1L+3Rs. ReMOV3 SOmE Unus3D oNES OR ED1+ tHe EXisT1ng OnES f1rSt.";
$lang['filtername'] = "f1LTEr N4Me";
$lang['filtertype'] = "f1lT3R +YP3";
$lang['filterenabled'] = "fIL+3R 3n4BLeD";
$lang['editwordfilter'] = "eD1+ W0Rd PH1L+3R";
$lang['nowordfilterentriesfound'] = "no 3xI\$tiNG w0rD PHilTER 3N+R13s PHOUnD. +O @dD 4 Ph1l+3R CLiCK +eh '4dD nEW' 8U+TOn b3LOW.";
$lang['mustspecifyfiltername'] = "j00 MusT sp3CIFy 4 PHILteR n4mE";
$lang['mustspecifymatchedtext'] = "j00 MU\$t sPeCIfY M4+ChED +Ext";
$lang['mustspecifyfilteroption'] = "j00 MUS+ \$p3C1FY @ PhIL+3R 0PtION";
$lang['mustspecifyfilterid'] = "j00 mU5+ 5P3CIFy A PHiLT3r 1D";
$lang['invalidfilterid'] = "iNV4lID phiLt3r 1D";
$lang['failedtoupdatewordfilter'] = "f@1LEd to UpDa+E w0Rd FiLT3R. Ch3CK Th4+ +Eh FILTEr S+1LL 3X1\$TS.";
$lang['allow'] = "aLlOW";
$lang['block'] = "bloCK";
$lang['normalthreadsonly'] = "n0RM@L +HRE4dS 0NLY";
$lang['pollthreadsonly'] = "p0lL +hR34DS 0nlY";
$lang['both'] = "bo+H +Hr34D +Yp35";
$lang['existingpermissions'] = "eXISt1N9 p3Rm1SS1Ons";
$lang['nousershavebeengrantedpermission'] = "nO EX1\$tING uS3rs PERm1ssI0N\$ f0UND. +O 9r4nT peRM1sS10N to US3RS S3@RCh PHOR +h3m 83L0W.";
$lang['successfullyaddedpermissionsforselectedusers'] = "sUCC3SsfULlY 4Dd3D p3rMI\$51on\$ F0R \$3LectED U5eRs";
$lang['successfullyremovedpermissionsfromselectedusers'] = "suCCE\$SphUlLY R3M0veD P3rM1\$sI0NS pHr0M \$3LeC+Ed usEr\$";
$lang['failedtoaddpermissionsforuser'] = "f41LED tO @DD PERm1\$s1oNS phOr US3R '%s'";
$lang['failedtoremovepermissionsfromuser'] = "f4il3D +0 r3M0Ve P3RM1\$s1On\$ fROM U\$3R '%s'";
$lang['searchforuser'] = "sE4rCH PHOR U\$3R";
$lang['browsernegotiation'] = "br0wsEr N39o+Ia+3D";
$lang['largetextfield'] = "l@RGE +3xT F1ElD";
$lang['mediumtextfield'] = "m3dIUm +3XT pH1ELd";
$lang['smalltextfield'] = "sM4lL +3xT ph1ELd";
$lang['multilinetextfield'] = "mUlT1-l1NE +EX+ f1ELd";
$lang['radiobuttons'] = "r4DI0 8U++0N\$";
$lang['dropdownlist'] = "dROP DOWn LI\$+";
$lang['clickablehyperlink'] = "cl1CKablE hYP3Rl1NK";
$lang['threadcount'] = "tHr3@D COunT";
$lang['clicktoeditfolder'] = "cliCk +o 3D1+ pH0LDeR";
$lang['fieldtypeexample1'] = "t0 CR3@te R@DIO 8UTTOns 0R @ DR0P DOWn L1s+ j00 N33D to 3N+3R 3@CH 1nDIV1DU4L v4LUe 0N 4 s3P4R4+3 LInE IN +3H OptI0NS f1ElD.";
$lang['fieldtypeexample2'] = "t0 cReA+3 cLICK4bLE L1Nks eNT3R TeH URl IN THe 0PTi0NS FieLD 4ND u53 <i>%1\$S</i> wheRe TH3 eN+RY FRom +hE us3R's PR0Ph1LE shoULd 4PP3Ar. 3x4MPl3s: <p>mYSp4c3: <i>h++p://wWw.MySP@c3.C0M/%1\$\$</i><br />xBOX L1V3: <i>hTtP://PrOFIl3.MyG@MeRC@Rd.N3T/%1\$\$</i>";
$lang['editedwordfilter'] = "eDiTEd W0RD F1LteR";
$lang['editedforumsettings'] = "eD1+3D pHORUm SETtInGS";
$lang['successfullyendedusersessionsforselectedusers'] = "sucCESsPHUlLy 3ND3D s35s1ON\$ F0R 5ELEc+3D usERS";
$lang['failedtoendsessionforuser'] = "f@iLeD tO 3ND s3\$SI0N pHOr uS3r %s";
$lang['successfullyapprovedselectedusers'] = "sUCcES\$pHULlY 4PPR0V3D \$ELeCTed U\$3RS";
$lang['matchedtext'] = "m@+ChED +3xT";
$lang['replacementtext'] = "r3PL@C3men+ +EX+";
$lang['preg'] = "pre9";
$lang['wholeword'] = "whoL3 worD";
$lang['word_filter_help_1'] = "<b>aLl</b> M@tCH3S 4941nST +3H wh0lE +EX+ \$o PH1LTErINg m0M TO mUM wILL @LS0 Ch@N9E m0M3N+ +0 MUMeN+.";
$lang['word_filter_help_2'] = "<b>wh0lE W0Rd</b> M4+CH3s 494INS+ WhoL3 WORd5 ONLy SO FILtERiN9 M0M +0 mUM W1Ll No+ cH4NGe MOM3NT +O MUMeNT.";
$lang['word_filter_help_3'] = "<b>pR3g</b> aLl0W\$ J00 T0 US3 pERl R3GulAr 3XPrE\$SI0ns +0 MAtCH +ExT.";
$lang['nameanddesc'] = "n@mE @ND dE\$cR1P+1ON";
$lang['movethreads'] = "m0v3 ThREaD\$";
$lang['movethreadstofolder'] = "moVE +hrE4DS +o PHOlD3R";
$lang['failedtomovethreads'] = "f@1lEd To MOVe ThR34D5 +0 SP3C1F13D f0lDEr";
$lang['resetuserpermissions'] = "r3\$3+ u\$Er PERm1s51ONS";
$lang['failedtoresetuserpermissions'] = "f@1lEd TO RESEt USeR peRM1\$s1ONS";
$lang['allowfoldertocontain'] = "aLLOw F0Ld3R +0 c0NT@1n";
$lang['addnewfolder'] = "aDD n3w PH0LdeR";
$lang['mustenterfoldername'] = "j00 MU\$t EN+3R A FOlD3r n4M3";
$lang['nofolderidspecified'] = "n0 PhoLdER id SP3c1F13D";
$lang['invalidfolderid'] = "invAL1D f0LDEr 1d. CH3CK +H4T A Ph0ld3R WIth +H1\$ 1D 3x1\$+S!";
$lang['successfullyaddednewfolder'] = "sucC3SSfulLy @DdED nEW foLD3R";
$lang['successfullyremovedselectedfolders'] = "sucCE\$sPHullY r3MOV3D \$3l3C+3D PH0LDERs";
$lang['successfullyeditedfolder'] = "sUcC3sSFUlly EDI+ED foLD3R";
$lang['failedtocreatenewfolder'] = "f@iL3D +0 CREa+E nEW FOlDER";
$lang['failedtodeletefolder'] = "f4il3D +0 D3Le+E FOld3R.";
$lang['failedtoupdatefolder'] = "f41lED t0 UPd4+3 Ph0lD3R";
$lang['cannotdeletefolderwiththreads'] = "cAnNOT dEL3+E f0LDErs +h@T S+1Ll Con+41N +hRe4D\$.";
$lang['forumisnotrestricted'] = "fOrUM 1S NOt RES+R1CTEd";
$lang['groups'] = "gr0uPS";
$lang['nousergroups'] = "n0 US3R gR0uPS H4Ve 833N \$3+ UP. TO @dD 4 gROUp Cl1Ck TeH '4DD nEW' 8U+TOn 83L0W.";
$lang['suppliedgidisnotausergroup'] = "sUppL1ED 91D i\$ no+ 4 UsER 9ROuP";
$lang['manageusergroups'] = "m4N@9e U53R gr0uPS";
$lang['groupstatus'] = "gR0UP ST@Tus";
$lang['addusergroup'] = "aDd U\$er 9R0UP";
$lang['addemptygroup'] = "add 3MP+y 9ROUP";
$lang['adduserstogroup'] = "add U\$eR\$ TO 9r0up";
$lang['addremoveusers'] = "adD/ReMOV3 us3RS";
$lang['nousersingroup'] = "thER3 Ar3 NO USeRS 1N th15 Gr0uP. 4DD u\$Er\$ TO +Hi\$ GROuP 8Y S34RcH1NG FoR +h3m BeLOW.";
$lang['groupaddedaddnewuser'] = "sucCe\$5PHuLlY @Dd3D 9R0Up. @dD Us3R\$ +0 +HI\$ groUp 8Y S34RcHINg f0R THeM 8El0W.";
$lang['nousersingroupaddusers'] = "tHeR3 4RE n0 US3RS 1N TH1S gROUp. +O aDd USerS Cl1cK +3H '@Dd/REmoVE usEr\$' 8utTON 83LOw.";
$lang['useringroups'] = "this USeR 1\$ A M3M8eR OF t3H f0lLOWIng 9ROuP5";
$lang['usernotinanygroups'] = "th1S uSER 1\$ N0+ IN 4nY U\$3r 9r0UP\$";
$lang['usergroupwarning'] = "n0+e: Thi\$ u\$ER M4y Be inH3rI+1N9 4dD1+10N@l peRmi\$\$I0N\$ FrOM 4NY uSER 9rouP5 L1S+3D B3L0w.";
$lang['successfullyaddedgroup'] = "sUcCesSFUllY 4ddED 9roUp";
$lang['successfullyeditedgroup'] = "sUccESsPHUllY Edi+eD grOUP";
$lang['successfullydeletedselectedgroups'] = "suCcESsPHuLLY D3Le+ED SEleCT3D GRoUP\$";
$lang['failedtodeletegroupname'] = "f@IL3d +0 DEl3+e GrOUP %s";
$lang['usercanaccessforumtools'] = "u5er CAN 4cCESS fORUM TO0L\$ 4Nd C@n CR34t3, deLe+e 4nd eDI+ F0RUm5";
$lang['usercanmodallfoldersonallforums'] = "us3R c4n ModERa+E <b>aLL fOLDer\$</b> oN <b>aLl F0RUM\$</b>";
$lang['usercanmodlinkssectiononallforums'] = "uSER c@N mODEra+3 l1NK\$ \$ecT10N oN <b>aLL F0RUM\$</b>";
$lang['emailconfirmationrequired'] = "eM@il cONpH1rM4T1ON r3Qu1R3D";
$lang['userisbannedfromallforums'] = "u\$ER 1s B4NN3D PhROM <b>aLL f0RUm5</b>";
$lang['cancelemailconfirmation'] = "c@nC3L 3M41L c0NPhIRm@+10N 4ND 4Ll0W u\$3R T0 \$t@R+ POST1n9";
$lang['resendconfirmationemail'] = "r3\$ENd C0nF1rMATIon EM41L T0 u5eR";
$lang['failedtosresendemailconfirmation'] = "f@1lED +O ResEnd 3MAIL c0nF1RM4+1On To US3R.";
$lang['donothing'] = "d0 N0THinG";
$lang['usercanaccessadmintools'] = "u\$ER HAS @CCeSS to PH0RUm 4DmIN +0ol\$";
$lang['usercanaccessadmintoolsonallforums'] = "us3R H4S 4Cc3sS +O @DMIn TOOLS <b>oN ALl Ph0rUM5</b>";
$lang['usercanmoderateallfolders'] = "us3R Can M0D3r4T3 4ll F0LD3rs";
$lang['usercanmoderatelinkssection'] = "u\$eR CAn M0DER4+E LinK\$ \$3c+1ON";
$lang['userisbanned'] = "u53R 1s B4NN3D";
$lang['useriswormed'] = "uSeR 1\$ WOrmED";
$lang['userispilloried'] = "u\$3R i5 P1LL0R1ED";
$lang['usercanignoreadmin'] = "u\$eR CAn 1GN0Re AdMInI\$Tr@T0R\$";
$lang['groupcanaccessadmintools'] = "grOUP cAN 4CC3sS 4DM1n +00LS";
$lang['groupcanmoderateallfolders'] = "groUP c@N mOD3RAtE @lL ph0LDER\$";
$lang['groupcanmoderatelinkssection'] = "gRoUP C@N mOd3r4+3 liNkS SEctiONS";
$lang['groupisbanned'] = "gr0Up 1S 84Nn3D";
$lang['groupiswormed'] = "gR0up 1S W0RM3D";
$lang['readposts'] = "rE4d POS+s";
$lang['replytothreads'] = "r3PLy TO +HrE4DS";
$lang['createnewthreads'] = "cr34t3 NEw +Hr34DS";
$lang['editposts'] = "eDi+ PO\$+S";
$lang['deleteposts'] = "d3l3tE P0\$+s";
$lang['postssuccessfullydeleted'] = "p0stS \$UccE\$SFUlLY DelE+ED";
$lang['failedtodeleteusersposts'] = "faIlED t0 D3LET3 USEr'S PO\$TS";
$lang['uploadattachments'] = "uplo@D 4tT4CHm3N+s";
$lang['moderatefolder'] = "modEraTE Ph0lDER";
$lang['postinhtml'] = "p0ST In H+ML";
$lang['postasignature'] = "p0st 4 \$1gn@TURe";
$lang['editforumlinks'] = "edI+ FORuM lInKS";
$lang['linksaddedhereappearindropdown'] = "l1nkS @DdeD heRe @PPear 1N @ DR0P DOWn IN T3h +Op RiGH+ 0f +EH fRAMe \$3+.";
$lang['linksaddedhereappearindropdownaddnew'] = "l1nKS 4Dd3D h3R3 4Pp34R 1N @ DR0P d0WN IN TH3 +0P R19Ht OF th3 Fr4ME s3+. T0 4Dd 4 l1nk ClICK +H3 '@DD n3W' BU++ON b3lOW.";
$lang['failedtoremoveforumlink'] = "f4iL3D +0 R3M0V3 FoRUM l1NK '%s'";
$lang['failedtoaddnewforumlink'] = "f4iLEd TO @dD N3w FOrUM L1NK '%s'";
$lang['failedtoupdateforumlink'] = "faIL3D +0 Upd4T3 F0RUM L1NK '%s'";
$lang['notoplevellinktitlespecified'] = "n0 +OP L3VEL LINK +1Tl3 \$PECiF1ED";
$lang['youmustenteralinktitle'] = "j00 MUST ENt3R 4 L1Nk TI+lE";
$lang['alllinkurismuststartwithaschema'] = "aLL LinK ur1\$ mU\$+ ST4r+ WItH 4 \$CH3M4 (i.3. Ht+P://, ph+p://, irC://)";
$lang['editlink'] = "eDI+ linK";
$lang['addnewforumlink'] = "add n3W fOruM L1nK";
$lang['forumlinktitle'] = "f0RUM L1Nk T1+le";
$lang['forumlinklocation'] = "f0rUM LInk l0Ca+I0N";
$lang['successfullyaddednewforumlink'] = "sUCC3SSPHUllY @DdED n3W F0RuM L1NK";
$lang['successfullyeditedforumlink'] = "sUcc3SSFuLLY ED1T3D PH0Rum L1nk";
$lang['invalidlinkidorlinknotfound'] = "iNv4L1D l1nK 1D Or liNk N0t PhoUnD";
$lang['successfullyremovedselectedforumlinks'] = "sUCCe\$sFuLLy REM0v3D \$3L3CTED lInKS";
$lang['toplinkcaption'] = "t0P l1NK CApt10N";
$lang['allowguestaccess'] = "alLOW GuesT 4cC3\$S";
$lang['searchenginespidering'] = "s34RcH 3N91N3 SpiDeRIN9";
$lang['allowsearchenginespidering'] = "all0W s34RCh 3N91N3 SPIDeRINg";
$lang['sitemapenabled'] = "eNABLe \$1+3MAP";
$lang['sitemapupdatefrequency'] = "s1TEM4P uPD4TE fR3QU3NcY";
$lang['sitemaplocation'] = "s1t3M@p L0C4T10N";
$lang['sitemappathnotwritable'] = "s1t3m@P P@th MU\$t B3 Wri+4BLE 8Y teH WE8 sERV3R / PhP pR0C3S5!";
$lang['newuserregistrations'] = "nEw US3R re9ISTRA+10nS";
$lang['preventduplicateemailaddresses'] = "preVENT duPL1C@te 3M41L 4dDR3s\$3s";
$lang['allownewuserregistrations'] = "aLL0W n3w USer rEgI\$TR@t1oNS";
$lang['requireemailconfirmation'] = "r3qu1r3 3M41L cONPhiRm@TiON";
$lang['usetextcaptcha'] = "u53 t3x+-C4ptcHA";
$lang['textcaptchadir'] = "t3x+-c4p+CH@ DIr3C+0Ry";
$lang['textcaptchakey'] = "tex+-c@P+Ch4 Key";
$lang['textcaptchafonterror'] = "t3X+-C4ptCh@ HAS b33N d1s4BL3D @u+0MATicaLLY 8eC4US3 THEr3 4r3 NO tRUE tyPE Ph0N+S 4V@Il4BLe pHOR I+ +o US3. pL3ASE UPLO4D sOM3 +RUe TyPE f0NTs To <b>%s</b> 0N y0UR s3rV3R.";
$lang['textcaptchadirerror'] = "texT-c4p+cH4 H4\$ bE3N dIS48LeD 8ec4USE THe T3X+_C@p+ChA D1R3C+0RY @Nd I+'\$ \$U8-DiR3C+oRI3S 4r3 n0+ wR1+48L3 8Y TeH WeB S3RV3r / pHP PROc3s5.";
$lang['textcaptchagderror'] = "tEX+-C4P+Ch4 H@5 B3EN D1S@8L3D 83C4U\$3 YOUR \$3RVEr'S Php \$3+UP doES Not ProViDE \$UPPOr+ FOr Gd iM4Ge M4N1Pul@TION @ND / Or Ttf PH0Nt SUPp0r+. 80TH @rE R3QUirED PhoR +3XT-c4P+ch4 SUpPOrt.";
$lang['textcaptchadirblank'] = "text-C4ptch4 d1R3C+0rY 1S 8L4nK!";
$lang['newuserpreferences'] = "nEw u\$3R pR3f3RenCES";
$lang['sendemailnotificationonreply'] = "emAIl nOt1FIcATion 0n R3Ply +o u\$3r";
$lang['sendemailnotificationonpm'] = "eM41l No+IphIc4Ti0N 0N PM tO u\$3r";
$lang['showpopuponnewpm'] = "sHoW pOpup WH3n r3C31V1NG NEw Pm";
$lang['setautomatichighinterestonpost'] = "seT 4U+0M4+iC h1Gh IN+3r3St on POST";
$lang['postingstats'] = "p0\$+1NG S+@+\$";
$lang['postingstatsforperiod'] = "pOsTInG ST@T\$ FOR p3r1oD %s TO %s";
$lang['nopostdatarecordedforthisperiod'] = "n0 P0\$+ Dat4 r3COrD3d F0R tHIS p3rI0D.";
$lang['totalposts'] = "tot@L Pos+s";
$lang['totalpostsforthisperiod'] = "tOt@l pOSTS F0R THIS pER1oD";
$lang['mustchooseastartday'] = "mu5+ CH00S3 4 ST4R+ d4Y";
$lang['mustchooseastartmonth'] = "mu\$t CHOOSE 4 5+4R+ M0n+H";
$lang['mustchooseastartyear'] = "mu\$+ ChO0S3 4 \$+@R+ y3@R";
$lang['mustchooseaendday'] = "muST CH0OSe @ EnD D4Y";
$lang['mustchooseaendmonth'] = "mu5t ChOOSe @ eND M0nTH";
$lang['mustchooseaendyear'] = "mU\$+ CHOO\$e @ END yEAr";
$lang['startperiodisaheadofendperiod'] = "sT4rT PErioD 1\$ @heAD OF enD P3r1OD";
$lang['bancontrols'] = "b4n coNtR0LS";
$lang['addban'] = "aDD b4n";
$lang['checkban'] = "cHeCK 84N";
$lang['editban'] = "ed1+ b@n";
$lang['bantype'] = "b4n +YPe";
$lang['bandata'] = "b@N D@t4";
$lang['bancomment'] = "cOMM3N+";
$lang['ipban'] = "ip B4N";
$lang['logonban'] = "log0N 8AN";
$lang['nicknameban'] = "niCKN4M3 BAn";
$lang['emailban'] = "eM4IL ban";
$lang['refererban'] = "rEPHERER b@N";
$lang['invalidbanid'] = "inV4LID B4n 1d";
$lang['affectsessionwarnadd'] = "thi\$ B4N M@Y @pHfECT T3h PholL0W1NG @C+1VE USER \$3\$\$1oNS";
$lang['noaffectsessionwarn'] = "tH1s B4N AfPHeCTS n0 @Ct1VE \$3\$S1oNs";
$lang['mustspecifybantype'] = "j00 MUs+ \$PEc1PhY @ b4n +yPE";
$lang['mustspecifybandata'] = "j00 Mu\$+ \$peCIfY soM3 8@N D4+a";
$lang['successfullyremovedselectedbans'] = "suCcesSFulLy R3m0VED \$3L3C+eD 8@Ns";
$lang['failedtoaddnewban'] = "f@IL3D +0 4DD NEw 8An";
$lang['failedtoremovebans'] = "fA1L3D to rEm0Ve S0Me Or 4LL 0F +3H seLeCt3D 8An\$";
$lang['duplicatebandataentered'] = "dUPL1C@T3 B@n d4+@ 3n+eREd. pl34S3 CH3cK Y0UR W1lDcaRDS +0 s3E IF Th3y @LRe4dY MA+ch T3H d4+a 3n+3R3d";
$lang['successfullyaddedban'] = "sUCCE\$\$PhULly @ddeD b@N";
$lang['successfullyupdatedban'] = "sUCC35sFUllY UPD4T3D BAn";
$lang['noexistingbandata'] = "tHer3 1\$ N0 3X1\$+1Ng 8@N d4+@. to 4DD 4 8An Cl1Ck +H3 '@dD nEW' 8uT+ON 8El0w.";
$lang['youcanusethepercentwildcard'] = "j00 C@N us3 TEH p3rC3n+ (%) WiLDC4RD \$ym80l In 4NY 0F Y0uR 8AN li\$ts +0 O8t4iN P@R+14L mA+CHE\$, 1.3. '192.168.0.%' W0ULD b4n 4LL Ip aDDr3\$sE\$ 1n +Eh R4NGE 192.168.0.1 THR0uGh 192.168.0.254";
$lang['cannotusewildcardonown'] = "j00 CaNNOt @dD % 4\$ 4 wiLdC4RD M@TcH 0N 1T's Own!";
$lang['requirepostapproval'] = "rEqU1R3 POST 4PPR0V@l";
$lang['adminforumtoolsusercounterror'] = "tHeRE Mus+ bE 4+ LEAst 1 u\$3R w1tH 4Dm1n t0oLS 4nd F0RUM TooLS @CCes5 ON @ll pHORUm5!";
$lang['postcount'] = "p0S+ COUNT";
$lang['resetpostcount'] = "re\$3+ pOS+ C0UN+";
$lang['failedtoresetuserpostcount'] = "f@1LEd +O re\$ET PO\$+ COuNT";
$lang['failedtochangeuserpostcount'] = "fAIL3D +0 CHaN9E USEr PO\$+ coUN+";
$lang['postapprovalqueue'] = "post 4PPR0v@l Qu3u3";
$lang['nopostsawaitingapproval'] = "no pOS+S 4rE 4W41+1nG 4PpROv4L";
$lang['approveselected'] = "apPROV3 s3lEC+Ed";
$lang['failedtoapproveuser'] = "fAiL3D +0 aPPRoVE US3R %s";
$lang['kickselected'] = "kiCk s3LEc+ED";
$lang['visitorlog'] = "vi\$I+0R l09";
$lang['clearvisitorlog'] = "cle4R vISItOR LO9";
$lang['novisitorslogged'] = "nO V1sI+orS L0GgeD";
$lang['addselectedusers'] = "add SelECt3D u5eRS";
$lang['removeselectedusers'] = "rem0V3 \$ELeCtED u53RS";
$lang['addnew'] = "add N3W";
$lang['deleteselected'] = "deleT3 S3l3c+Ed";
$lang['forumrulesmessage'] = "<p><b>foRUM RuL35</b></p><p>\nrE915Tr4+10N +0 %1\$\$ I\$ Fr3e! W3 d0 In\$15T tH4+ J00 4B1De 8y tHE RUl3s @nD POl1cIe\$ deT4IL3D B3L0W. 1PH J00 @GR3E +0 +HE +ERM\$, pLE4S3 CH3CK TH3 '1 @9rEE' CHeCkb0x @nd Pr3\$S tHE 'R39I\$+ER' BuTt0N B3l0w. IF j00 w0ULD liKE +0 cANceL t3H r39Is+RA+1on, CLiCK %2\$S +o R3+uRN to t3H PhORumS InDEx.</p><p>\nALTh0U9H +3H 4dm1n1STR4+oRS 4nd MOdeR@+0RS 0PH %1\$S W1LL @t+emP+ t0 kE3P 4LL OBj3C+1ON48L3 M3SS4geS OFPH +h1\$ pHORUM, I+ 1\$ 1mPO\$SIBle PhoR us +0 Rev13W 4LL M3ss49E\$. 4LL M3SS49eS EXPr3\$5 +h3 V1ew\$ 0pH +H3 4u+H0R, AND N3I+H3R THE oWNER\$ 0PH %1\$\$, N0R PROJECT B33H1VE PH0rUM 4nD 1+'\$ aFPH1LI4tE\$ W1Ll Be HELD RESP0Ns1bL3 PH0R +h3 COn+ENt OPH 4NY M3Ss@93.</p><p>\n8y 49R33iNg t0 +H3S3 RULES, J00 WARr@N+ +h@T j00 W1lL not P0\$+ 4NY m3ss4GeS +H@T 4re 08scEN3, VUL94R, \$3xU4LLY-0RIEN+4+3D, H4T3PHUL, tHR3A+3NIN9, 0R OTHERw1S3 V1oL4tIVE 0f 4NY L@ws.</p><p>tH3 0WNeR\$ 0f %1\$\$ R35ERVE +h3 R19H+ +0 R3M0ve, 3D1+, M0V3 0R CL053 ANY THRE4d PHOR @NY RE@S0N.</p>";
$lang['cancellinktext'] = "h3r3";
$lang['failedtoupdateforumsettings'] = "f4Il3d +O uPD4Te ForUM \$3++1nGS. pL34SE +Ry ag41N l@TeR.";
$lang['moreadminoptions'] = "m0RE 4DM1N optIon\$";

// Admin Log data (admin_viewlog.php) --------------------------------------------

$lang['changedstatusforuser'] = "ch@Nged US3R sT@+US fOR '%s'";
$lang['changedpasswordforuser'] = "cH@nGEd P@ssWoRD F0R '%s'";
$lang['changedforumaccess'] = "ch4N9ed F0RUM 4CC3ss PErMISsi0NS foR '%s'";
$lang['deletedallusersposts'] = "d3l3t3d ALl p0\$+s PH0R '%s'";

$lang['createdusergroup'] = "cR34+3d U\$3r GROUP '%s'";
$lang['deletedusergroup'] = "d3l3+3d U5ER 9roUP '%s'";
$lang['updatedusergroup'] = "upD@Ted U\$3R 9R0up '%s'";
$lang['addedusertogroup'] = "addEd USEr '%s' TO 9RouP '%s'";
$lang['removeduserfromgroup'] = "r3m0V3 us3R '%s' PHr0M 9Roup '%s'";

$lang['addedipaddresstobanlist'] = "add3D 1P '%s' +0 84N l1\$t";
$lang['removedipaddressfrombanlist'] = "r3MOveD 1P '%s' fROM BAn l15+";

$lang['addedlogontobanlist'] = "aDDed LOG0N '%s' T0 b4n l1\$T";
$lang['removedlogonfrombanlist'] = "rEM0VEd l090N '%s' PHr0M B@n LiS+";

$lang['addednicknametobanlist'] = "aDDed N1CkN@ME '%s' TO 84N List";
$lang['removednicknamefrombanlist'] = "r3m0vED N1CKN4M3 '%s' Phr0M B4N li\$T";

$lang['addedemailtobanlist'] = "addED 3M4IL 4DdRESS '%s' +0 8aN L15+";
$lang['removedemailfrombanlist'] = "r3mOV3D 3m@1L @DdRESS '%s' PHR0M 8AN L1\$+";

$lang['addedreferertobanlist'] = "adDED R3F3R3R '%s' +O 84N LISt";
$lang['removedrefererfrombanlist'] = "rEM0v3d R3FEr3r '%s' fROm B4N l1S+";

$lang['editedfolder'] = "eD1+ED foLD3R '%s'";
$lang['movedallthreadsfromto'] = "movED 4ll +hRe4d\$ frOM '%s' +o '%s'";
$lang['creatednewfolder'] = "cR3@+3D nEW PHOlDEr '%s'";
$lang['deletedfolder'] = "dELE+Ed Ph0LD3R '%s'";

$lang['changedprofilesectiontitle'] = "cH@N93D ProPHil3 \$3CT10N +1+lE pHrOM '%s' +o '%s'";
$lang['addednewprofilesection'] = "aDDED N3w PR0PHiLE S3C+1on '%s'";
$lang['deletedprofilesection'] = "delE+3D pR0f1LE \$3CTI0N '%s'";

$lang['addednewprofileitem'] = "adDED n3w PRoF1L3 I+3M '%s' tO SEc+10N '%s'";
$lang['changedprofileitem'] = "cH4N9Ed PrOFiL3 i+EM '%s'";
$lang['deletedprofileitem'] = "d3leT3D pROf1L3 1+eM '%s'";

$lang['editedstartpage'] = "eDI+3D s+Ar+ P4G3";
$lang['savednewstyle'] = "s@vED NeW s+YL3 '%s'";

$lang['movedthread'] = "m0V3D THr34D '%s' fRoM '%s' t0 '%s'";
$lang['closedthread'] = "cLoSEd ThREAd '%s'";
$lang['openedthread'] = "opeNEd tHr34D '%s'";
$lang['renamedthread'] = "reNAMEd +hR3@D '%s' +0 '%s'";

$lang['deletedthread'] = "dElET3d THR3@d '%s'";
$lang['undeletedthread'] = "uNDELe+Ed Thr34D '%s'";

$lang['lockedthreadtitlefolder'] = "lOCKEd +HrE4D 0PTioNs 0N '%s'";
$lang['unlockedthreadtitlefolder'] = "uNL0cK3D THr3aD OPt1oN\$ oN '%s'";

$lang['deletedpostsfrominthread'] = "deL3+3D P0\$+S phROm '%s' IN tHr3@D '%s'";
$lang['deletedattachmentfrompost'] = "d3lETED 4tT4cHMeN+ '%s' FRom P05+ '%s'";

$lang['editedforumlinks'] = "eDi+ED Ph0RUm L1NK5";
$lang['editedforumlink'] = "ed1TeD F0Rum L1Nk: '%s'";

$lang['addedforumlink'] = "adDED F0RUm lINK: '%s'";
$lang['deletedforumlink'] = "d3LE+3d F0RUm lInK: '%s'";
$lang['changedtoplinkcaption'] = "chaNGED T0P liNK c4PtI0N PhRoM '%s' T0 '%s'";

$lang['deletedpost'] = "d3LE+3d Po\$t '%s'";
$lang['editedpost'] = "ed1+ed po\$T '%s'";

$lang['madethreadsticky'] = "m4De +Hr34D '%s' St1ckY";
$lang['madethreadnonsticky'] = "m@D3 tHR3@D '%s' N0N-S+1CKy";

$lang['endedsessionforuser'] = "eNDED S3SSI0N pH0R uSER '%s'";

$lang['approvedpost'] = "apPR0V3D P0S+ '%s'";

$lang['editedwordfilter'] = "ed1tED w0Rd F1L+3r";

$lang['addedrssfeed'] = "addED r\$s F3Ed '%s'";
$lang['editedrssfeed'] = "eD1T3d rsS PHe3d '%s'";
$lang['deletedrssfeed'] = "dEl3t3D Rs\$ FeeD '%s'";

$lang['updatedban'] = "uPd@+3D b@N '%s'. CH@nGED +YpE FRom '%s' T0 '%s', ChAN9Ed dA+a PhR0M '%s' +0 '%s'.";

$lang['splitthreadatpostintonewthread'] = "splIT thR34d '%s' A+ po\$+ %s  In+0 NEW +HREad '%s'";
$lang['mergedthreadintonewthread'] = "mer9ed THR3@DS '%s' 4ND '%s' 1Nt0 NEw +hR3Ad '%s'";

$lang['approveduser'] = "aPPROv3d Us3r '%s'";

$lang['forumautoupdatestats'] = "f0rUm AUto UPd4T3: s+@TS UpD4t3d";
$lang['forumautoprunepm'] = "f0RUM aU+O uPD4Te: PM PhOLd3RS prUn3d";
$lang['forumautoprunesessions'] = "fORUm 4U+0 upD4+3: se\$51oNS pRuNEd";
$lang['forumautocleanthreadunread'] = "f0ruM AUTo UpD4TE: +Hre4D UNr34D D4+4 cLe4n3D";
$lang['forumautocleancaptcha'] = "fORUM auTO uPD4+3: +EXT-C4PTCh@ 1M4GE5 CL34NED";
$lang['forumautositemapupdated'] = "forUm 4uTO Upd@Te: s1+3M@p UpD@tED";

$lang['ipaddressbanhit'] = "user '%s' i5 8ANnED. Ip 4DDres\$ '%s' m4+chED 8an DaT4 '%s'";
$lang['logonbanhit'] = "u53r '%s' 15 B4NNed. L090N '%s' mATcH3D b4N da+4 '%s'";
$lang['nicknamebanhit'] = "useR '%s' 1S B4nN3D. n1CKN4Me '%s' M4+ChED b4N d4+4 '%s'";
$lang['emailbanhit'] = "u\$ER '%s' I5 b4nN3D. 3m@1L 4DdrESs '%s' M4TcH3D 84N dAT4 '%s'";
$lang['refererbanhit'] = "u5eR '%s' I\$ B4NN3d. h+TP r3f3R3R '%s' M4TCh3D b4n D4t4 '%s'";

$lang['userpermenabled'] = "cH4N93D PErmS f0r UsER '%s'. En4blED: %s";
$lang['userpermdisabled'] = "chaNGEd pErms PH0R U5er '%s'. di5A8LED: %s";

$lang['userpermbanned'] = "b@nnED";
$lang['userpermwormed'] = "wORMEd";
$lang['userpermfoldermoderate'] = "f0LD3r MODEr4+Or";
$lang['userpermadmintools'] = "aDm1N tO0l5";
$lang['userpermforumtools'] = "fOrum +O0LS";
$lang['userpermlinksmod'] = "l1nK5 M0dER4Tor";
$lang['userpermignoreadmin'] = "i9n0R3 4DmIN";
$lang['userpermpilloried'] = "p1lLOr1Ed";

$lang['adminlogempty'] = "adMin lO9 1\$ emPtY";

$lang['youmustspecifyanactiontypetoremove'] = "j00 MUS+ sPECIphy 4N 4C+I0n Typ3 +0 REMOv3";

$lang['alllogentries'] = "aLl L09 3N+R1Es";
$lang['userstatuschanges'] = "useR s+4Tu\$ CH4n93S";
$lang['forumaccesschanges'] = "f0Rum 4CC355 CH@n9Es";
$lang['usermasspostdeletion'] = "uS3R m4\$5 PO\$+ DEl3tIOn";
$lang['ipaddressbanadditions'] = "iP 4ddr3\$5 84n 4Dd1+i0n\$";
$lang['ipaddressbandeletions'] = "ip 4ddRE\$5 84n D3l3+10N5";
$lang['threadtitleedits'] = "thr34D +1tle eD1ts";
$lang['massthreadmoves'] = "m4SS tHRe@d m0V3\$";
$lang['foldercreations'] = "f0lDer cR34T1on5";
$lang['folderdeletions'] = "foLDer DeLe+1oNs";
$lang['profilesectionchanges'] = "prOPh1Le 5EcTI0N CH@nG3\$";
$lang['profilesectionadditions'] = "prOphiLE sEcTI0N 4DD1+1Ons";
$lang['profilesectiondeletions'] = "pR0F1le Sec+10N d3L3+10n\$";
$lang['profileitemchanges'] = "pRof1lE iT3M ch@Ng3s";
$lang['profileitemadditions'] = "pr0f1l3 I+Em 4dD1+10nS";
$lang['profileitemdeletions'] = "pRopHiL3 1tem deLE+10NS";
$lang['startpagechanges'] = "st4R+ p49E ch4N935";
$lang['forumstylecreations'] = "f0rUM sTYL3 CRE4+10N\$";
$lang['threadmoves'] = "thr3@D M0VEs";
$lang['threadclosures'] = "thre@D ClosUR3S";
$lang['threadopenings'] = "thre4D OP3NiNG\$";
$lang['threadrenames'] = "thrE@D rEN4m3\$";
$lang['postdeletions'] = "po\$T d3L3T1oN\$";
$lang['postedits'] = "p0\$T 3DI+\$";
$lang['wordfilteredits'] = "w0rD FIlT3R 3dI+s";
$lang['threadstickycreations'] = "thrE4D STIckY CRE4+10n\$";
$lang['threadstickydeletions'] = "thr3@D sT1CKY DEL3TIoN\$";
$lang['usersessiondeletions'] = "us3r S3SsioN D3L3+1ON\$";
$lang['forumsettingsedits'] = "f0RUM \$3++1nGS 3DI+S";
$lang['threadlocks'] = "thr3@D LOcKs";
$lang['threadunlocks'] = "tHR3@D uNLOcKS";
$lang['usermasspostdeletionsinathread'] = "usER M4SS PO\$+ DEle+1oN\$ IN @ THR34D";
$lang['threaddeletions'] = "thrE4D DeLE+10N\$";
$lang['attachmentdeletions'] = "aTt4cHM3NT d3lE+10Ns";
$lang['forumlinkedits'] = "fOrUM L1NK eD1+s";
$lang['postapprovals'] = "pOS+ 4pPR0V@Ls";
$lang['usergroupcreations'] = "us3R 9R0UP CR34tI0nS";
$lang['usergroupdeletions'] = "u\$eR 9RoUP dEL3T1ON\$";
$lang['usergroupuseraddition'] = "u53R 9r0uP UsER 4Ddi+I0N";
$lang['usergroupuserremoval'] = "uS3r GR0UP us3R REm0v4L";
$lang['userpasswordchange'] = "us3r P4S5W0RD chAN9E";
$lang['usergroupchanges'] = "u\$eR 9R0UP cH4NgeS";
$lang['ipaddressbanadditions'] = "iP 4DDr3\$S B4n 4DD1+i0n\$";
$lang['ipaddressbandeletions'] = "iP ADdRE5s b@N D3LEtI0N5";
$lang['logonbanadditions'] = "log0N 84N ADDi+i0ns";
$lang['logonbandeletions'] = "l090n 8AN d3LE+1oNS";
$lang['nicknamebanadditions'] = "nicKn@m3 8@N ADdi+I0Ns";
$lang['nicknamebanadditions'] = "nIcKn4m3 84N aDDitI0NS";
$lang['e-mailbanadditions'] = "e-M41l B4N 4DD1+ION\$";
$lang['e-mailbandeletions'] = "e-m41l 84N DeLE+I0Ns";
$lang['rssfeedadditions'] = "rsS pHEeD 4DDI+10nS";
$lang['rssfeedchanges'] = "rs\$ PHe3D ch4N9E\$";
$lang['threadundeletions'] = "tHR3AD uND3LetION\$";
$lang['httprefererbanadditions'] = "ht+P rEPh3R3R 8@N 4dDItI0NS";
$lang['httprefererbandeletions'] = "hT+P REf3r3R 84n DEL3T1oN\$";
$lang['rssfeeddeletions'] = "rSs PH33D D3L3+10nS";
$lang['banchanges'] = "b4n Ch4ngE5";
$lang['threadsplits'] = "thr3AD SpL1+S";
$lang['threadmerges'] = "thr34D MEr9E5";
$lang['userapprovals'] = "uS3R 4PPr0V4LS";
$lang['forumlinkadditions'] = "f0rUM LInK @dDItI0N5";
$lang['forumlinkdeletions'] = "foruM l1nK d3LE+1oN\$";
$lang['forumlinktopcaptionchanges'] = "f0Rum L1NK +OP C4PTi0n chaN9ES";
$lang['folderedits'] = "f0ld3r 3D1T\$";
$lang['userdeletions'] = "uSEr D3LE+1on\$";
$lang['userdatadeletions'] = "us3r da+A deLE+1oN\$";
$lang['forumstatsautoupdates'] = "f0ruM 5T4+S 4uTo UpD4+3S";
$lang['forumautopmpruning'] = "f0RUM @U+O Pm PRuN1Ng";
$lang['forumautosessionpruning'] = "fORUM 4u+0 Se\$S1oN PruN1N9";
$lang['forumautothreadunreaddataupdates'] = "f0rUM 4UTO ThR34D unREAd D@t4 UpD4Te\$";
$lang['forumautotextcaptchaclean-ups'] = "fOrUM @U+O +3xt C4PTch@ Cl34N-Ups";
$lang['usergroupchanges'] = "u5ER gROUp CH4N9E\$";
$lang['ipaddressbancheckresults'] = "iP @dDRe\$S b4N cHEcK R3\$ULTs";
$lang['logonbancheckresults'] = "loG0N 84N CHEcK Re\$ULt5";
$lang['nicknamebancheckresults'] = "n1CKn4m3 B4N CHECk R3SULts";
$lang['emailbancheckresults'] = "eM41L b4n ChEcK reSUl+5";
$lang['httprefererbancheckresults'] = "h+Tp R3PH3Rer BaN cHECK r3\$uLTS";

$lang['removeentriesrelatingtoaction'] = "r3mOVE 3N+rIE\$ r3L4+in9 +O acT10N";
$lang['removeentriesolderthandays'] = "rem0v3 3NtrIEs 0Ld3R tH4N (D@YS)";

$lang['successfullyprunedadminlog'] = "suCc3SSPHulLy PrUNEd 4Dm1N loG";
$lang['failedtopruneadminlog'] = "f4IL3D +0 PRUne 4DM1N l0G";

$lang['prune_log'] = "pruN3 LOG";

// Admin Forms (admin_forums.php) ------------------------------------------------

$lang['noexistingforums'] = "n0 3XISTIN9 phoRUMS PH0UND. +O CR3@T3 4 N3w f0rUm CL1CK +HE 'adD N3W' BU++0N 83LOW.";
$lang['webtaginvalidchars'] = "we8t@9 CAn ONly C0N+41N uPPeRC4SE 4-z, 0-9 AnD UndEr5COr3 Ch4rAcTEr5";
$lang['databasenameinvalidchars'] = "d@t48@s3 N@ME c@N ONly CONT@iN 4-Z, 4-Z, 0-9 @nD UNDER\$C0rE ch4R4C+3r\$";
$lang['invalidforumidorforumnotfound'] = "inv4liD F0RUM F1d OR FORum Not PH0UNd";
$lang['successfullyupdatedforum'] = "sUcc3\$spHULly UPda+3d FOruM";
$lang['failedtoupdateforum'] = "f41LED +O upd@TE f0RUM: '%s'";
$lang['successfullycreatednewforum'] = "suCc3sSFULly Cr3aTed n3W forUM";
$lang['selectedwebtagisalreadyinuse'] = "t3H \$3l3cTED W3b+@g I\$ ALRE@dY 1N Us3. Ple4S3 ChoOSe 4NoThER.";
$lang['selecteddatabasecontainsconflictingtables'] = "the \$3L3CTeD d4+Ab4\$3 c0NT4iN\$ cONfl1C+1n9 +48L3s. cONFLiCtIN9 T4Ble N@MEs @r3:";
$lang['forumdeleteconfirmation'] = "arE J00 sur3 J00 WAnT +O DELEt3 @Ll 0F +3H S3Lec+3D foRumS?";
$lang['forumdeletewarning'] = "pl34sE nO+e TH4+ J00 c4NNOT R3COvER d3LE+eD pHOrUM\$. OnC3 D3L3TeD a PH0Rum 4ND ALl OpH 1T's A\$sOC14T3D d@+4 IS PerMaNEnTLY REmOV3D fROM T3h D4+A8A\$e. 1f J00 d0 N0T w1sH +0 d3LeTE T3H S3L3C+ed FOrumS Ple@5E ClICk C@nC3L.";
$lang['successfullyremovedselectedforums'] = "sUCc3sSFulLy D3L3+3D s3L3Ct3D pH0rum\$";
$lang['failedtodeleteforum'] = "f@1lEd +0 D3L3+ED f0rUM: '%s'";
$lang['addforum'] = "add F0RUM";
$lang['editforum'] = "ed1+ F0RuM";
$lang['visitforum'] = "v1siT PHORum: %s";
$lang['accesslevel'] = "aCCESS L3veL";
$lang['forumleader'] = "f0RUM L34DER";
$lang['usedatabase'] = "us3 DAt4b@S3";
$lang['unknownmessagecount'] = "uNKn0WN";
$lang['forumwebtag'] = "f0rUM We8+@9";
$lang['defaultforum'] = "d3F4uL+ FORuM";
$lang['forumdatabasewarning'] = "ple453 3NSUr3 J00 Sel3C+ +hE C0rRECT da+4B4S3 Wh3n crE4+1NG @ n3w F0RuM. 0nC3 crE4t3D 4 n3W F0Rum cANn0T be MOvED 83TW33N 4V41L48LE D4T484S3\$.";

// Admin Global User Permissions

$lang['globaluserpermissions'] = "gl0b@L US3R peRm1sS10n\$";

// Admin Forum Settings (admin_forum_settings.php) -------------------------------

$lang['mustsupplyforumwebtag'] = "j00 mU\$T sUPpLY A F0rUM W38T@g";
$lang['mustsupplyforumname'] = "j00 mUS+ SUppLY 4 pH0RUm NaME";
$lang['mustsupplyforumemail'] = "j00 Mu\$+ SuPPlY @ PhORuM em4IL AdDR3SS";
$lang['mustchoosedefaultstyle'] = "j00 MUs+ Ch0O\$3 4 DEfauLT pHOruM S+ylE";
$lang['mustchoosedefaultemoticons'] = "j00 muST cH0O\$3 D3FAULt F0RUM 3M0TIc0nS";
$lang['mustsupplyforumaccesslevel'] = "j00 MU5+ sUpPLy 4 f0RUm 4Cc3sS l3VEl";
$lang['mustsupplyforumdatabasename'] = "j00 MUS+ SUPply @ fORUM DAT4b4s3 n4mE";
$lang['unknownemoticonsname'] = "uNKN0WN 3mO+1CONs N4me";
$lang['mustchoosedefaultlang'] = "j00 MUSt cH0O53 4 D3pH4uL+ F0ruM L@NguAG3";
$lang['activesessiongreaterthansession'] = "activE S3sSI0N TimE0uT C4NNO+ Be GRe4t3R +h@N S3sS1ON TiME0uT";
$lang['attachmentdirnotwritable'] = "at+4CHM3Nt D1R3cTORy 4ND \$Y\$+3M T3MpoR4RY dIr3C+0RY / PhP.1Ni 'UPl04D_tmP_dIr' MUSt BE wR1T4BL3 By T3H wEb \$3RV3R / pHP pr0C3s\$!";
$lang['attachmentdirblank'] = "j00 MU\$T 5uPplY A DIreC+oRY +o S@V3 A+T@chM3N+s 1N";
$lang['mainsettings'] = "m41N sE++1N9s";
$lang['forumname'] = "f0RUm N4ME";
$lang['forumemail'] = "fOrUM 3M@IL";
$lang['forumnoreplyemail'] = "n0-REPLY 3m41l";
$lang['forumdesc'] = "f0RUm DESCr1pT10N";
$lang['forumkeywords'] = "f0RUM kEyW0Rds";
$lang['defaultstyle'] = "d3fAUL+ StyL3";
$lang['defaultemoticons'] = "d3pH4UL+ 3MOTICON\$";
$lang['defaultlanguage'] = "d3ph4uLT LAN9u49e";
$lang['forumaccesssettings'] = "f0RUM 4cCE5S s3TTIN9S";
$lang['forumaccessstatus'] = "f0ruM 4Cc3\$S \$+4+US";
$lang['changepermissions'] = "cH4N9E PERM1\$S1oNs";
$lang['changepassword'] = "ch4Nge p4\$SW0rD";
$lang['passwordprotected'] = "p4SSW0RD Pr0tEC+3D";
$lang['passwordprotectwarning'] = "j00 h@Ve N0+ seT @ Ph0rUm P4\$\$WORD. IF J00 d0 N0T sET 4 PA\$SW0Rd +HE P4\$sWORd PR0+ECTi0n FuNCt10n@L1Ty W1Ll Be 4U+0M@T1C4LLY DI\$48L3D!";
$lang['postoptions'] = "p0sT OPTi0n5";
$lang['allowpostoptions'] = "all0w P05T 3d1TInG";
$lang['postedittimeout'] = "posT 3DI+ TimEOUT";
$lang['posteditgraceperiod'] = "p0S+ eD1T 9R4CE PEri0D";
$lang['wikiintegration'] = "wik1W1KI in+39R4+10N";
$lang['enablewikiintegration'] = "eN4BL3 wIKiWIkI 1n+EGr@tiON";
$lang['enablewikiquicklinks'] = "en48le WIKiw1KI QUicK liNK\$";
$lang['wikiintegrationuri'] = "w1kIWIK1 L0CAt10N";
$lang['maximumpostlength'] = "m@xiMuM p0\$T lENgTH";
$lang['postfrequency'] = "pOS+ pHREQuENcY";
$lang['enablelinkssection'] = "en4bLE l1NKS s3c+10N";
$lang['allowcreationofpolls'] = "all0w cREA+10n OF POLlS";
$lang['allowguestvotesinpolls'] = "aLl0W guES+S +O voTE IN P0LLS";
$lang['unreadmessagescutoff'] = "uNREad MesS493s cUT-oFf";
$lang['disableunreadmessages'] = "d1SAbl3 UNr34D ME\$5@gES";
$lang['thirtynumberdays'] = "30 D@YS";
$lang['sixtynumberdays'] = "60 d4Y\$";
$lang['ninetynumberdays'] = "90 D4Y\$";
$lang['hundredeightynumberdays'] = "180 d@Y\$";
$lang['onenumberyear'] = "1 Y34R";
$lang['unreadcutoffchangewarning'] = "dep3NDIng On \$3RVEr P3RpHORm@nc3 4Nd +h3 nUM8ER oF +HrE4DS yOUR f0rUMs CoNT41N, CH@nGiNg +H3 UnRE4D cuT-0fPh M@y TaKE \$3VER@l M1Nute\$ +0 C0MPl3+3. ph0R +H1s r34sON iT 1\$ REcoMMEnD3d +H@t J00 @v0iD chAn91NG +h1\$ \$3++iNg Wh1L3 YoUR PHOruM5 4Re 8U\$Y.";
$lang['unreadcutoffincreasewarning'] = "incRE4\$1NG tHE uNrE4d CuT-0PHpH W1ll R3SUl+ In ThREAd\$ OLd3R Th@N tEH cURReN+ cu+-0FF @PPE4RInG 4\$ UNRE4D FOr 4LL U5ERS.";
$lang['confirmunreadcutoff'] = "are j00 \$uR3 J00 w@Nt To Ch4NG3 tHE uNRe4D cU+-0Phf?";
$lang['otherchangeswillstillbeapplied'] = "clICkiNG 'no' w1LL ONlY caNc3L tH3 UnrEAD cUT-0FF cHaNge\$. OTh3r CH4nge5 YOU'VE m@D3 wILl S+1Ll 8E \$4veD.";
$lang['searchoptions'] = "s34RCH 0pt1ON\$";
$lang['searchfrequency'] = "se@RcH PHr3qUENcy";
$lang['sessions'] = "sE\$S10nS";
$lang['sessioncutoffseconds'] = "s3sS10n cuT 0FF (\$3CoND\$)";
$lang['activesessioncutoffseconds'] = "act1vE \$3\$SION cuT OFPh (SECOND\$)";
$lang['stats'] = "sT4t\$";
$lang['hide_stats'] = "h1d3 s+4Ts";
$lang['show_stats'] = "sh0W \$+4+S";
$lang['enablestatsdisplay'] = "en48L3 5T4+S DIsPLAY";
$lang['personalmessages'] = "pERS0N4L mES\$@GES";
$lang['enablepersonalmessages'] = "en@8l3 pER\$OnaL M3Ss@9ES";
$lang['pmusermessages'] = "pM MESS493\$ per U\$3R";
$lang['allowpmstohaveattachments'] = "aLL0W peR5oN4L M3ssAGes +0 H4V3 4T+4CHm3nTS";
$lang['autopruneuserspmfoldersevery'] = "au+O PrUN3 UseR's PM PHOlDErs ev3RY";
$lang['userandguestoptions'] = "uS3R @ND 9u3S+ OPt1oNs";
$lang['enableguestaccount'] = "en4Bl3 9UesT @cC0UNt";
$lang['listguestsinvisitorlog'] = "lIs+ gU3s+s IN visitOR LO9";
$lang['allowguestaccess'] = "aLl0W gUE5T 4cC3SS";
$lang['userandguestaccesssettings'] = "uS3R 4ND GUE\$t 4Cc3\$5 \$3TTIN9s";
$lang['allowuserstochangeusername'] = "aLL0W u\$3RS +0 Ch@N9E USeRn4M3";
$lang['requireuserapproval'] = "r3QU1R3 u5eR 4ppr0V4L BY 4dm1N";
$lang['requireforumrulesagreement'] = "rEqUIR3 UsER TO A9REE tO f0RUm RULes";
$lang['enableattachments'] = "enaBLE 4tT4CHM3N+S";
$lang['attachmentdir'] = "atT@cHMeN+ Dir";
$lang['userattachmentspace'] = "at+@CHmEn+ Sp@C3 PeR USEr";
$lang['allowembeddingofattachments'] = "aLLOw Em8EDdINg Of @+T4Chm3NTs";
$lang['usealtattachmentmethod'] = "u\$e @l+3RN4T1V3 @tT4CHM3N+ Me+H0D";
$lang['allowgueststoaccessattachments'] = "aLL0W 9U3\$ts t0 4cC3\$\$ 4++@CHm3nTS";
$lang['forumsettingsupdated'] = "f0rUM SeTTiN9s \$uCcE55FUlLY uPDA+eD";
$lang['forumstatusmessages'] = "f0Rum \$t@TUS MESS4g3\$";
$lang['forumclosedmessage'] = "fORUm clo\$eD ME\$S493";
$lang['forumrestrictedmessage'] = "f0rum Re5+RICt3d mE55493";
$lang['forumpasswordprotectedmessage'] = "f0RUM p4s5W0RD PR0+3ct3D MESs@9E";

// Admin Forum Settings Help Text (admin_forum_settings.php) ------------------------------

$lang['forum_settings_help_10'] = "<b>po5+ 3D1t +1ME0UT</b> i5 The +1ME iN mINUt3S 4FTEr P0STIN9 th4T A uS3R c4n Ed1t ThE1R PO\$+. 1PH S3+ +O 0 TheRE i5 N0 LImi+.";
$lang['forum_settings_help_11'] = "<b>m4X1MUM POSt LeNG+h</b> I\$ Th3 M4X1MuM nuMbER 0F CH4R4Ct3R\$ +H@t wiLL B3 D1\$pL@Y3d In 4 poS+. 1PH @ pO\$T i\$ LoN93R +H4N tHE nUM8eR 0PH CH@r4c+eR\$ dEpH1NeD H3RE 1+ WiLL 83 CU+ \$h0R+ 4ND A LiNK 4dD3D +0 +H3 bo+TOm +O 4lLOw USeRS +0 ReaD TH3 Wh0Le PO\$+ ON 4 S3P@R4+E p@gE.";
$lang['forum_settings_help_12'] = "iF J00 DOn'T w4N+ YOUr U53RS +0 83 4BL3 to cRE4T3 pOLl5 J00 CAN dI\$48L3 +hE 4B0VE 0P+10N.";
$lang['forum_settings_help_13'] = "t3H L1Nks 5ECtI0N oph B3EH1v3 Pr0V1D3S 4 pL4C3 Ph0R YouR usERs +o MAInt41n @ lI5t OF s1TES +H3Y Phr3QUENtlY vISi+ +H@t O+h3r USER\$ M@y FINd U53PhUL. l1nKS C4N bE dIV1DED iN+0 CA+3G0RIeS bY PHOLdeR 4ND 4LLow pH0R COMm3NTS @Nd R4TinGS TO 83 gIv3N. 1n 0rd3R To M0DER@TE tHE l1NKS \$3cTiOn @ U\$eR MUst bE r4n+Ed gL08@l MOdER@TOR s+ATuS.";
$lang['forum_settings_help_15'] = "<b>s3SSion Cut 0FF</b> IS +3H MAXIMum +1M3 BEPH0R3 4 US3R'S S3s\$1ON I\$ dEEMEd D3@D @nD +hEY ARe LO99ED 0u+. 8y DEph4ULT THI\$ 1s 24 HouRS (86400 SECONds).";
$lang['forum_settings_help_16'] = "<b>acT1v3 S35SIOn CU+ 0phf</b> 1s +EH M4x1mUM T1ME BEPh0r3 4 Us3r'S s3\$S1oN 1\$ De3mED 1NaCT1VE 4+ wHICH p0INT +HeY en+3R @N IdL3 \$+@+3. 1N thIS s+@t3 +3H U5ER rEM41N\$ L0G9ED 1N, 8U+ +h3Y @r3 R3MOVeD PHr0m +hE 4C+1v3 Us3R\$ lISt 1N +HE st4+S Di\$PL@Y. 0nCE +H3Y B3C0M3 4CT1ve 4GAiN +HEy W1Ll 8E r3-@DdeD +0 T3H lIS+. bY d3PH@UL+ +h1\$ \$3+t1N9 i\$ Se+ +o 15 M1NuT3S (900 \$3COndS).";
$lang['forum_settings_help_17'] = "en48LInG +hiS 0P+10N @LL0ws b33HiV3 t0 1NCLuDE @ \$T4TS D1\$plAy a+ +H3 8oTTOm OF THe M3SSA93S P@N3 SImIl@R +O tH3 onE USed By ManY PHoruM S0PH+W4RE TitL3\$. ONc3 3N4BLED +he DI\$PL4Y Of TH3 S+4+S p@g3 C4N b3 TOGGLeD 1nD1V1dU4LLY 8y e4cH us3r. 1F +h3y D0N'T w@N+ +0 S3E I+ +HEY C4N HId3 i+ FR0m VIEW.";
$lang['forum_settings_help_18'] = "pEr\$OnAL M3SS@9eS 4RE INValUaBlE 4s @ W4Y 0ph T@KiN9 m0r3 pR1V@t3 mATT3r\$ 0U+ 0F vIEw Of tHE OthER M3M8eR\$. HOWEV3R 1pH j00 DON'+ WAnt y0ur USER5 TO be 48L3 +0 S3ND E4cH O+H3r PeR\$ON4L M3sS49E\$ J00 C4n d1sA8Le +His 0PTi0N.";
$lang['forum_settings_help_19'] = "per\$0N4L MesS4G3s CaN aL\$0 CoN+41N @t+4CHm3NTS wH1CH C4n 83 USePHuL Ph0r 3XCh@NgIN9 pHil3S BETWeEN us3Rs.";
$lang['forum_settings_help_20'] = "<b>nOtE:</b> tH3 Sp@cE alL0C@+I0n fOR pM @+t4CHM3nTS 1\$ +@K3N PhR0M e4Ch Us3R\$' m41N a+T@cHMENT @LLOC4+10N 4ND is NO+ In 4dD1+1oN to.";
$lang['forum_settings_help_21'] = "<b>enAbl3 9UE5+ 4Cc0uN+</b> 4ll0W\$ V1\$1TORs +O 8ROwsE yOUr Ph0RUM ANd ReAD P0\$+S WIThoUT RE9IsT3R1N9 4 Us3r 4CC0Un+. 4 usER @Cc0UN+ 1\$ sTilL r3QUiREd if tHEY w1SH +0 poST 0R CH@N93 Us3r pR3PH3R3NC35.";
$lang['forum_settings_help_22'] = "<b>l1\$+ 9UEs+\$ 1N Vi\$1t0R Lo9</b> 4lLOws J00 +O SPeciFY whE+H3r 0R N0T uNRegIST3r3d US3RS aR3 Li\$+3D 0N t3H vI\$i+oR L09 4L0NG \$1D3 R39IS+3RED US3R\$.";
$lang['forum_settings_help_23'] = "b33hiv3 4LLOWs 4T+acHm3NTS +O 83 UPL04d3D +O mESS49ES WH3N PO5+3D. IF j00 H4vE L1M1T3D W38 SP4CE j00 M4Y WhiCH +0 d1\$@8l3 4TT@ChM3N+S BY CLE4RIN9 TH3 B0X 480vE.";
$lang['forum_settings_help_24'] = "<b>at+@chmEnT D1r</b> is +eh LOC4T10n 8EEH1v3 \$h0uLD \$+OR3 1+'5 4+tAChMeN+S 1n. tHi\$ D1R3ct0RY MusT 3x1ST 0n YOuR WE8 sP4C3 4nD MUsT B3 WR1+A8L3 BY T3H W3B \$ERV3R / PHP Proc3\$S 0+H3RWISE uPLO4d\$ w1LL F41l.";
$lang['forum_settings_help_25'] = "<b>aT+@chm3N+ Sp@C3 p3R usEr</b> 1\$ +3H m4x1MuM @moUnt OF DIsk SP4CE A UseR H4S phoR AtT4CHMen+s. 0NC3 +his SP4CE I\$ u\$ED up TeH UseR c4NNO+ UPlo@d @Ny M0Re 4++@CHm3N+s. 8y DEF4uLT +H1\$ IS 1Mb 0PH Sp4c3.";
$lang['forum_settings_help_26'] = "<b>aLLOW EM83DDinG 0f 4T+AChmENT\$ 1n ME\$s@93S / S1GN@tuRES</b> @lL0WS U\$3r\$ +0 3m8ED 4tT4cHM3Nts 1N P05TS. 3Na8L1NG tHiS Op+i0n WH1L3 U\$EPhuL cAn 1Ncr34SE y0uR BANdW1Dth U\$@9E dR4\$t1C4LLy uNd3R cErt4In COnPhiGuRA+I0NS 0pH pHP. if J00 h4VE LiMItED 8aNDWiD+h I+ I\$ REcoMmENdED th4+ j00 D1\$48L3 +h1\$ 0P+10N.";
$lang['forum_settings_help_27'] = "<b>u\$3 4l+ERn@tIVE A++@CHm3Nt METHOd</b> phORC3S BE3H1vE +O US3 @n 4LTERN@tIve R3+RIEv4L mE+H0D F0R 4+T@ChM3nTS. if j00 R3c31V3 404 ERR0R ME\$Sa93s When +rY1Ng T0 d0wNL0@D @+t4cHmENTS FrOM m3SSAg3s tRy EnaBL1NG +H1\$ 0PT10N.";
$lang['forum_settings_help_28'] = "th3s3 53TTINg5 4lLoW\$ YoUR FOrUM +O 8E \$pIDEr3d By SEaRCh EN9InES l1K3 g00GLe, @L+4V1\$+@ AnD y4HOO. 1PH J00 sW1TcH +h1s 0PtI0N 0FPh Y0UR F0RUm WiLL No+ bE 1NcLUD3D IN th3S3 SE4rCH EN9INes RE\$UltS.";
$lang['forum_settings_help_29'] = "<b>alL0W n3w u53R r39IS+R4T1on\$</b> @ll0wS 0R Dis4LLOws +H3 CRE4Ti0n 0PH n3W useR 4Cc0uNt\$. s3++In9 TH3 0PtI0N +0 NO CompLET3lY Di\$@BL3S +h3 R3g1STR4+ION fORM.";
$lang['forum_settings_help_30'] = "<b>eN4BL3 W1kiwIk1 IN+e9R@+1On</b> PROvIDeS wiK1WOrD sUPp0RT 1n YoUR FORum p0\$+S. 4 w1KIw0RD 1s M@D3 UP oF Tw0 0R MOr3 cONC4T3N@+3D wORDS w1+H uPPErCa\$3 L3Tt3R\$ (OF+3N R3pHErR3D t0 4\$ C4M3lC@sE). If j00 WR1+3 4 WORD +H1\$ WAy 1+ W1LL 4u+OM@tIC@lLY b3 Ch4NgeD in+0 A Hyp3RL1nK POIN+1NG T0 youR CHo\$3n W1K1WIK1.";
$lang['forum_settings_help_31'] = "<b>eNabLE WIkIW1Ki QUiCK l1Nk5</b> 3n@8LE\$ +3H USE 0f Ms9:1.1 4nD US3R:L090N s+YL3 ExT3nDED WIk1L1NKS WHICH CRe4TE hyP3RL1NKS T0 TEH \$PEciF1eD Mess@gE / U\$3R PRoPHIL3 oF +H3 SPEciF13D U\$3R.";
$lang['forum_settings_help_32'] = "<b>w1KIwiKI l0CA+10N</b> i5 us3D T0 \$peCifY TH3 UrI 0f yOuR wIKiwIkI. wH3N ENt3RIN9 the Ur1 US3 <i>%1\$\$</i> t0 iNdIC4Te WH3Re iN +h3 URi +h3 WIkIw0RD sHOUlD @Pp3AR, i.E.: <i>h+Tp://EN.w1KipEDI4.0r9/WIk1/%1\$S</i> WOULd L1Nk YOUR w1K1WOrds +O %s";
$lang['forum_settings_help_33'] = "<b>fOrUM AccEsS st4+u\$</b> C0NTrOls HOW usERs M@Y acCESS Y0UR F0RUm.";
$lang['forum_settings_help_34'] = "<b>op3n</b> w1lL 4Ll0w 4Ll US3RS aNd 9UEs+5 @cCEss T0 yoUr Ph0RUm Wi+H0U+ r3STR1ct10N.";
$lang['forum_settings_help_35'] = "<b>clOs3D</b> PR3VEN+S @cCes\$ pH0R aLl US3Rs, Wi+h T3H EXCePTiON OF The @dmIN WhO m4Y sTILL 4cCesS +H3 4DMiN P@neL.";
$lang['forum_settings_help_36'] = "<b>re\$+R1CT3d</b> 4LL0ws T0 \$Et @ Li\$T 0pH UsEr\$ wH0 4r3 4lLOWed 4cCE55 TO y0ur Ph0rUM.";
$lang['forum_settings_help_37'] = "<b>p4S5W0RD PRoT3CtED</b> 4LL0Ws J00 +O S3+ 4 PASSWOrD +o 9IVe OUT TO U\$eRS 50 +HEY c4n 4CCeSS Y0uR PHORuM.";
$lang['forum_settings_help_38'] = "wHEn \$3++1NG rES+rIcT3D 0r p@sswORd PRO+3ctEd M0DE j00 W1LL N3ED +o \$@V3 Y0UR Ch4ngEs 8ePhORe J00 c4N chAnG3 tEH u\$Er @Cc3sS PR1vILe93\$ or p@SSw0Rd.";
$lang['forum_settings_help_39'] = "<b>Search Frequency</b> defines how long a user must wait before performing another search. Searches place a high demand on the database so it is recommended that you set this to at least 30 seconds to prevent \"search spamming\"fRom K1LLIng TeH SERv3r.";
$lang['forum_settings_help_40'] = "<b>p0S+ phR3QU3NCy</b> 1S TeH MiN1MUm T1m3 4 U\$eR mU5+ W41+ 8ephOR3 THeY c4N Po5t @9AIn. +HIs \$3++1n9 @l\$0 4pHPH3CTS +HE Cre4T10N 0F Poll5. S3t tO 0 to Di\$48L3 +He Re\$TR1C+1oN.";
$lang['forum_settings_help_41'] = "t3H a8ov3 0P+1ON\$ CH@NG3 +H3 DEF4uL+ V@luE5 FOR thE u\$eR R39iSTRa+10n fORM. WHEre 4PPLiC@8L3 0THER \$3+Tin9s W1Ll us3 +H3 PHORUm'5 OWN DEFAult 5E+Tin9s.";
$lang['forum_settings_help_42'] = "<b>pREV3N+ U\$e 0ph DUPL1c@Te EM@iL @DDRE\$sEs</b> F0Rc3s 833H1V3 TO ch3CK +3H uS3R 4CCOUN+\$ 4G@INS+ +eH EMAIl 4DDR3sS teh USer 1s RegiSTer1N9 W1+h @ND pR0MP+S +H3m +0 USe @No+H3R 1PH It I\$ ALREaDy 1n u5e.";
$lang['forum_settings_help_43'] = "<b>r3QU1RE 3M@Il CoNPhIRM4+1oN</b> wheN 3N@8LED w1LL 5END aN 3MAIl To 3@Ch N3W U\$Er WITH 4 LINK thA+ C4n b3 U\$3d +O C0NF1RM th31R 3m41L 4DdRe5s. UN+1L +H3Y coNf1rm +H3Ir 3M41L aDDREss +h3Y wilL NOT 83 4BLE +0 P0\$+ uNL3s\$ +h3IR U\$3R PERM1S\$1ons 4R3 cH4N9ED maNU4Lly 8Y 4n 4DM1n.";
$lang['forum_settings_help_44'] = "<b>uS3 T3XT-cAPtCH@</b> PREseN+s +EH neW us3R W1+h 4 M4N9LEd IM@9e WHICh They MusT c0py 4 NUMb3r FR0M 1N+0 4 +3x+ PHIElD ON THE ReG1sTR4TI0N FORm. USE Th1\$ 0ptIon +O pREVenT @UTom4TED \$I9N-UP V14 sCriPTs.";
$lang['forum_settings_help_45'] = "<b>t3XT-CAp+CH@ DirECtoRY</b> \$P3CIFIES +H3 L0C4+1oN THAT 83eH1VE wILl \$T0R3 1t'5 Tex+-CaP+CHa Im@gE\$ 4Nd PHON+s 1N. +hiS D1REcTOry Mu\$T 8e Wr1+aBl3 8Y +HE W38 SerV3R / PhP PrOCE\$s 4Nd Must B3 4CC3S\$1Bl3 V1@ HttP. Af+3R J00 H4VE 3N48Led Tex+-c@ptCH@ J00 MUS+ UPlo4d \$oMe +RUE typE ph0NTS In+o the f0N+S SUb-DIreC+ORy 0F y0uR M@in +3x+-C@PTch4 DIREctORY 0+HErWIS3 B33H1V3 W1LL \$K1p +he +3xT-c4P+CH@ DUr1NG usER r39ISTR@+1ON.";
$lang['forum_settings_help_46'] = "<b>Text Captcha key</b> allows you to change the key used by Beehive for generating the text captcha code that appears in the image. The more unique you make the key the harder it will be for automated processes to \"guess\"tHe coDE.";
$lang['forum_settings_help_47'] = "<b>p0\$+ Ed1T 9R4c3 PERIOD</b> 4LLOWS j00 TO DePHIn3 a p3rI0D In Minu+3s wHERE us3RS m4Y Ed1+ pO\$+s Wi+H0UT +3H '3DI+ed By' +EXT @PP3@RiN9 0N +H31R POST\$. If S3+ TO 0 tH3 'EDI+3D 8Y' t3XT WilL 4Lw4Y\$ 4Pp34R.";
$lang['forum_settings_help_48'] = "<b>uNRE4d m3\$s49E\$ CU+-0PHPh</b> \$P3C1PH1E\$ H0w L0n9 ME\$S49E\$ REM41N UNre4D. THR3@DS M0dIFieD N0 LA+ER th4n +HE p3rI0D Sel3C+3D WIlL auTOM4+1calLY APPE4r 4\$ R34d.";
$lang['forum_settings_help_49'] = "chO051NG <b>d1S@bl3 uNRe4D MESS@GeS</b> w1Ll CoMPLe+3LY reMOvE UNre4D M3\$\$@9es \$Upp0Rt 4ND REMOvE The R3L3V@nT 0PT1oNS PHrom tH3 DI\$CUSS10n +Yp3 dROP d0Wn 0N t3H tHReAD L1ST.";
$lang['forum_settings_help_50'] = "<b>rEQUIR3 US3R 4PPR0V@L BY adMIN</b> @LL0WS j00 +0 RE5TRicT ACcE\$s 8y NeW uSErs UNtIl +hEY H4V3 B3EN 4PPr0V3D 8y @ M0d3R4T0r 0R 4dm1n. WI+h0UT ApPROv4l @ u\$3R CAnnO+ 4CC3s5 4NY ar3@ OF +3H B3EHIv3 pHORUM 1ns+4LL@+10N iNcLUD1N9 1ND1V1DU4L pHORuMS, PM INbOx 4Nd MY foRUmS \$ec+1oNS.";
$lang['forum_settings_help_51'] = "u5e <b>cLOSeD m3\$S4G3</b>, <b>r3s+RiC+eD M3\$\$@GE</b> 4Nd <b>pa\$SW0Rd PrO+3CteD MeS\$4Ge</b> +O cUStOM1\$3 +3h me\$sAGe DI\$pl@y3d WH3N US3R\$ @CceS5 YOUr FORUM 1n Th3 vaRIOUs \$t@+35.";
$lang['forum_settings_help_52'] = "j00 C@N us3 H+ml IN YOUR MESS@gES. hYp3RlINk5 4ND eMAil 4DDrEs\$ES W1LL @LS0 83 4UToM@tiC4LLy COnVEr+3D to LiNKS. +0 u5E tEH D3PH@ulT B3eH1V3 F0rum m3ss@G3\$ CLE4r THE F1ELds.";
$lang['forum_settings_help_53'] = "<b>aLL0W UsERS +0 CH4N93 US3rn4M3</b> peRM1T\$ 4LR3ADY RE9IS+3RED uS3R\$ t0 Ch4N9e +H3iR u5eRn4M3. WHEN 3N@8LEd J00 cAN +r4Ck +3H cHAn9E\$ @ us3R m@KE\$ TO THe1r USERn@M3 V1A +eh 4DMin U\$3R +o0LS.";
$lang['forum_settings_help_54'] = "u\$3 <b>f0RUm Rul3\$</b> TO En+Er 4N 4CC3p+AbL3 u\$3 Pol1Cy +ha+ e4cH uS3R Mu\$+ 4Gr33 +O B3Phor3 R3G1\$+ERiNG 0N y0UR Ph0RUM.";
$lang['forum_settings_help_55'] = "j00 c4N U\$E HtmL In Y0UR F0ruM RUlE\$. HYPeRLINK\$ AND 3M4IL ADDRES\$3s WILl @lsO b3 4U+0M4tIc@lLy C0NV3R+eD +O l1NK\$. +O us3 Th3 DePH@uLT 833H1V3 f0RUm @UP CL34R +3H f1Eld.";
$lang['forum_settings_help_56'] = "uS3 <b>n0-rEPLY EM41l</b> +O sP3C1FY 4N EMAIl aDDrE\$S +H@t DOes N0T 3X15T oR WILl N0+ 83 m0NI+0RED pHOr RePL135. +HI\$ em@1l @DdRES5 wILL 83 US3d 1N THE He4D3RS fOR @ll eM4ils 5eN+ PHr0M Y0uR f0RUM 1nCLUDin9 8U+ noT Lim1+ED +O p0st 4ND pm NOT1FiC4T1oN\$, uSEr 3m@iLS AND p4SSW0rd REmINDer\$.";
$lang['forum_settings_help_57'] = "i+ Is REC0mM3Nd3D tHAt J00 uSE An 3M@il 4DdRESs thA+ Do3s N0T 3XISt TO H3Lp cu+ d0WN ON SP@m +h4+ M@Y B3 DiR3CtED 4+ Y0Ur M41N pHORuM Em4IL @DDr3sS";
$lang['forum_settings_help_58'] = "iN 4dD1Tion TO s1MPl3 \$piD3RiNg, be3HIV3 caN 4Ls0 9EnER4t3 4 SiT3M@p FoR +3H f0RUM t0 M@K3 i+ 3A\$13R F0R \$34RCH en9INe\$ +0 PhiND @nD 1ND3x +3H m3S\$4GE\$ P0s+3d BY YOUR uSERs.";
$lang['forum_settings_help_59'] = "dEpenD1n9 oN \$3RV3r pERfORmANce @ND THE NUM8ER OF PH0rUM\$ 4ND +HRE4DS YoUR B3Ehiv3 INs+ALL4+10N con+41ns, GEn3R4T1n9 A 51teM@P May +4K3 \$3v3R4L M1nu+3\$ TO COMpL3t3. FOR TH1\$ R3A\$on 1+ 1s REC0mm3nDeD +H4+ j00 TRy T0 4VOid H4VIn9 thE SitEMAp GENEr4T10N T@K3 Pl@C3 whILe Y0UR pHoRUms 4RE BUSY.";

// Attachments (attachments.php, get_attachment.php) ---------------------------------------

$lang['aidnotspecified'] = "aId N0+ 5PEc1F1Ed.";
$lang['upload'] = "upL04D";
$lang['uploadnewattachment'] = "uPL0@D neW 4++4CHm3n+";
$lang['waitdotdot'] = "w4I+..";
$lang['successfullyuploaded'] = "sucC3sSFULly UPlo4D3D: %s";
$lang['failedtoupload'] = "f4iLEd +0 uPL04D: %s";
$lang['complete'] = "c0mPL3t3";
$lang['uploadattachment'] = "uPLo4D 4 PHiLE f0r A+t@CHM3NT +o +H3 mESs49e";
$lang['enterfilenamestoupload'] = "eNT3r FilEN4ME(\$) +0 UPl04D";
$lang['attachmentsforthismessage'] = "at+@CHM3NTS Ph0r tHI\$ M3\$SAg3";
$lang['otherattachmentsincludingpm'] = "o+h3R 4TT4CHM3NT\$ (1nCluDIN9 PM MESS@9eS 4ND 0+H3R F0RUMS)";
$lang['totalsize'] = "tOT@l S1Z3";
$lang['freespace'] = "fr3e SP4CE";
$lang['attachmentproblem'] = "th3rE W45 4 ProbLEm D0WNl0@D1Ng +hiS @++@cHMeNT. pl3A\$3 TrY 4941n l4+3R.";
$lang['attachmentshavebeendisabled'] = "a++@CHmENt\$ h@VE 83EN dIS@bl3d By ThE fOrUM OWN3R.";
$lang['canonlyuploadmaximum'] = "j00 cAn oNLY upLO@d a MaX1muM oF 10 ph1LE\$ @t a TImE";
$lang['deleteattachments'] = "dEle+E 4tT4chM3nTs";
$lang['deleteattachmentsconfirm'] = "are j00 sUr3 J00 W4Nt +0 DElet3 +h3 \$3Lec+3D aT+4ChM3N+5?";
$lang['deletethumbnailsconfirm'] = "aR3 j00 sUR3 j00 wAnT +0 DELE+E +Eh SEleCT3d 4tt4ChmEn+s ThuM8N4ILS?";

// Changing passwords (change_pw.php) ----------------------------------

$lang['passwdchanged'] = "p4\$sw0RD ch4n93D";
$lang['passedchangedexp'] = "yOuR Pa\$\$w0rd HA\$ B3eN CH4N9ED.";
$lang['updatefailed'] = "uPD4t3 PH@1LeD";
$lang['passwdsdonotmatch'] = "p4sSW0RdS d0 NOt m4Tch.";
$lang['newandoldpasswdarethesame'] = "n3w 4Nd OLd P4SSwORdS 4rE TEh S@m3.";
$lang['requiredinformationnotfound'] = "rEQu1r3d 1NF0RM@T1ON NOT phOuND";
$lang['forgotpasswd'] = "fOrGot P4SSwORd";
$lang['resetpassword'] = "reS3t p4\$SW0rd";
$lang['resetpasswordto'] = "r3s3+ Pas5WORd T0";
$lang['invaliduseraccount'] = "iNv@L1D usEr 4Cc0UNt SPeC1F13D. ChECk 3M4Il F0R C0rrec+ L1nK";
$lang['invaliduserkeyprovided'] = "iNV@L1d user K3Y PR0V1DED. CH3cK 3m41L For coRR3CT lINk";

// Deleting messages (delete.php) --------------------------------------

$lang['nomessagespecifiedfordel'] = "nO MESS4Ge SPecIfiEd PHoR dEle+10N";
$lang['deletemessage'] = "dEL3+3 Me5SaG3";
$lang['postdelsuccessfully'] = "pO5+ deL3teD suCc3\$SFuLLY";
$lang['errordelpost'] = "errOR d3lE+1NG pOST";
$lang['cannotdeletepostsinthisfolder'] = "j00 C@nN0+ D3LE+3 pos+S In +h1s pHOldER";

// Editing things (edit.php, edit_poll.php) -----------------------------------------

$lang['nomessagespecifiedforedit'] = "nO m3\$S@9E \$pec1FIeD f0r EDI+InG";
$lang['cannoteditpollsinlightmode'] = "c4nNO+ 3D1+ poLLS iN l19hT moDe";
$lang['editedbyuser'] = "eDi+3D: %s BY %s";
$lang['editappliedtomessage'] = "edI+ aPplIeD t0 meS\$@9E";
$lang['errorupdatingpost'] = "eRROR updATiNg P05+";
$lang['editmessage'] = "ed1t MES549E %s";
$lang['editpollwarning'] = "<b>n0+3</b>: EdI+1Ng C3R+41N @sP3C+s 0Ph 4 PoLL WilL V01D 4Ll tHE CuRr3n+ VOte\$ 4ND @LLOw p30PL3 +0 V0+e 4941N.";
$lang['hardedit'] = "h4rD ed1t oP+1oNS (VO+3S w1LL bE rEs3+):";
$lang['softedit'] = "s0phT EdiT 0PTionS (vO+3S W1ll 8E R3T@INEd):";
$lang['changewhenpollcloses'] = "ch4Ng3 WH3n +3H POLL cL0S3S?";
$lang['nochange'] = "nO CH4N9E";
$lang['emailresult'] = "em@1L r3sULt";
$lang['msgsent'] = "me\$S@93 \$3N+";
$lang['msgsentsuccessfully'] = "m3S\$@g3 S3N+ sUccES\$PhuLLY.";
$lang['mailsystemfailure'] = "m4iL SY\$+3M Ph41LUR3. meS\$@9E n0+ 5EN+.";
$lang['nopermissiontoedit'] = "j00 4r3 no+ PErm1T+3D t0 3D1T +HiS m3\$S49E.";
$lang['cannoteditpostsinthisfolder'] = "j00 C4Nn0+ 3D1+ P0\$TS 1N +H1S folD3R";
$lang['messagewasnotfound'] = "meS5493 %s W@S NO+ f0uND";

// Email (email.php) ---------------------------------------------------

$lang['sendemailtouser'] = "seND 3M@iL +o %s";
$lang['nouserspecifiedforemail'] = "n0 uS3R SPec1PHIEd phOR EMA1LInG.";
$lang['entersubjectformessage'] = "eN+3R 4 SUbJECt PHOR +3H ME5S493";
$lang['entercontentformessage'] = "eN+3R s0ME C0N+3N+ pH0R TH3 Me\$s49E";
$lang['msgsentfromby'] = "th1\$ M3SS@93 w4\$ \$3N+ FRom %s 8Y %s";
$lang['subject'] = "subJ3CT";
$lang['send'] = "s3nD";
$lang['userhasoptedoutofemail'] = "%s ha\$ 0p+3D 0UT 0F EM4IL c0NtACT";
$lang['userhasinvalidemailaddress'] = "%s H@S @n 1NV4LiD 3M@IL 4ddR3SS";

// Message nofificaiton ------------------------------------------------

$lang['msgnotification_subject'] = "m3SS@G3 N0+1pHIC@ti0N FR0M %s";
$lang['msgnotificationemail'] = "h3lL0 %s,\n\n%s P0\$T3D 4 m3SS49E +0 J00 On %s.\n\n+h3 SUbJecT Is: %s.\n\n+0 RE4D +H4+ ME5s@g3 4nD 0+HErS in +H3 SAme DiscuSS1ON, 90 T0:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nnO+3: IpH J00 DO n0+ w1sH +0 R3C31VE 3M@il N0+If1cA+I0N5 OF PH0RUm M3SS@gE\$ PO\$+3D +0 y0U, g0 TO: %s Cl1cK On My coN+R0LS +h3n 3M4iL 4nd pR1v@CY, UN\$3l3Ct TEH em41L NO+IfiC4+iON Ch3CKBOX aND prEs5 \$u8m1T.";

// Thread Subscription notification ------------------------------------

$lang['subnotification_subject'] = "sub\$cRIPtI0N N0tIFIC4T10n FRoM %s";
$lang['subnotification'] = "hellO %s,\n\n%s Pos+3D @ M3ss49e In 4 THrE4D j00 h4V3 \$uBSCr1b3D +0 0N %s.\n\ntHE \$U8JEc+ i5: %s.\n\ntO Re4d tH4T M3S5AGE 4ND 0+HER5 IN t3H S4M3 DI\$Cuss10N, G0 +O:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nno+3: If J00 do NOT w1\$h +0 r3cE1VE eMAIL nOTIFic4+1ONS 0Ph N3W mESS@GEs IN +Hi\$ THr3@D, G0 t0: %s 4Nd @DjU\$t Y0Ur 1N+3R3\$T l3vEl 4T +HE b0T+om OF THe p4G3.";

// PM notification -----------------------------------------------------

$lang['pmnotification_subject'] = "pm no+1Ph1C@+1ON FrOM %s";
$lang['pmnotification'] = "heLl0 %s,\n\n%s P0sted A pM +O j00 ON %s.\n\n+H3 SU8JecT 1S: %s.\n\nT0 Re4D TEH m3ss@93 GO to:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nNO+3: Iph J00 D0 NO+ W1\$H +O rEcE1vE eM@1l noTIFiCAti0NS 0F New pm Mes\$@Ges P0s+3D +o Y0u, 90 TO: %s clICK MY CON+ROLS +H3n EM@IL 4Nd PRIV4cy, UN\$ELEC+ +H3 PM NO+1f1c4+10N CHECK80x @ND PreSS 5u8M1+.";

// Password change notification ----------------------------------------

$lang['passwdchangenotification'] = "pa\$Sw0RD cH4Ng3 no+1PHIc@+10N phR0M %s";
$lang['pwchangeemail'] = "h3llO %s,\n\ntHI\$ A N0+1PHic@T10N 3M@Il +0 INf0RM j00 tHA+ Y0uR P@\$SW0RD 0N %s HAS Be3N cHan9eD.\n\nIT has 8EEN ch4NG3D t0: %s 4Nd W@\$ CH4NGEd 8y: %s.\n\n1f J00 hav3 RECE1vED ThI5 EM@1l IN erROR 0R W3re N0T 3XPEC+1N9 4 CH4Ng3 +0 Y0UR P45\$WORd PL3@\$3 C0Nt4CT +eH FoRUm 0Wn3R Or @ MoDER4t0r 0N %s 1MM3dI4TEly +O C0rr3C+ 1t.";

// Email confirmation notification -------------------------------------

$lang['emailconfirmationrequiredsubject'] = "em41L COnPH1Rm4+10N r3qUiR3D F0R %s";
$lang['confirmemail'] = "h3lL0 %s,\n\nyoU R3CEn+Ly CREa+ed 4 nEW uSEr Acc0uNT 0N %s.\nb3pHORE j00 C4N 5+4r+ Po\$+1n9 w3 nEeD To C0NFiRM yOUr Em41L 4dDRE5S. d0N'T W0RRy TH1\$ I5 qU1T3 34sy. ALl j00 N33D to D0 1s cL1Ck +3h l1nk 8eLow (OR COpY 4ND p@St3 1+ 1NTo YouR 8roW\$3R):\n\n%s\n\n0Nc3 C0NF1Rm@TIOn 15 c0mPLe+3 j00 M@Y LogIN 4nD 5t@rT P0\$+1nG Imm3DI4TELy.\n\nIF J00 DID NO+ CrE4t3 4 US3R 4cCouN+ 0n %s pL3@S3 4CCeP+ 0UR @P0LOGie5 4ND f0RW@rD +H1s EM41L +O %s s0 TH@+ tHE \$0uRCe OF i+ M4Y 83 inVESTIga+3d.";
$lang['confirmchangedemail'] = "hELl0 %s,\n\nY0U r3CENtLy CH4N9Ed YouR eM4Il 0N %s.\nb3F0rE J00 CaN sT@rT p0\$+ing 4941N WE n3ED +0 CONfIRM y0uR nEW 3M41l 4DDr3SS. dOn't WORry tHIS I\$ QU1TE 3@Sy. @Ll J00 NeED +0 Do IS cl1CK +HE L1Nk 8ELOw (Or c0Py 4nD Pas+3 1+ 1n+o Y0UR BR0WS3R):\n\n%s\n\n0Nc3 C0npH1RM4TI0N iS CoMPle+3 J00 m4Y c0n+1NU3 +o US3 +3h FOrUm @\$ N0RM4L.\n\n1PH j00 WeR3 NOt 3XP3CTIn9 ThI\$ EMaIL pHRom %s pLeA\$3 4CC3P+ OUR 4POLOGie\$ aNd PhORW4RD +H15 EMaIL TO %s \$O Th4+ +H3 \$0URCE of I+ May 8e 1NV3sTI9@T3D.";

// Forgotten password notification -------------------------------------

$lang['forgotpwemail'] = "h3lLO %s,\n\nYOU reqUE\$+3D +H1s E-m@Il Phr0m %s bEC4U\$3 J00 H4VE f0RG0++3N YOur pa\$5WORD.\n\nClICK tEH l1NK 83Low (OR coPY 4nd P4S+3 1+ iN+O yoUR bR0wSEr) +0 R3S3t y0uR p4SsWOrd:\n\n%s";

// Admin New User notification -----------------------------------------

$lang['newuserregistrationsubject'] = "n3w U5ER @Ccoun+ N0T1PHIc@T10N pH0R %s";
$lang['newuserregistrationemail'] = "Hello %s,\n\nA new user account has been created on %s.\n\nAs you are an Administrator of this forum you are required to approve this user account before it can be used by it's owner.\n\nTo approve this account please visit the Admin Users section and change the filter type to \"Users Awaiting Approval\"0r CL1CK The LinK b3LOW:\n\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nN0+3: O+h3R 4DMInI\$tr4+OR\$ 0N +h1\$ PHOruM WiLL ALsO r3c3IV3 TH1s NOTIphIc4tION 4ND MAY H4v3 ALr3@dY 4c+3d UPOn THis REQU3sT.";

// User Approved notification ------------------------------------------

$lang['useraccountapprovedsubject'] = "uS3r @pPR0V4L no+1f1C@+1oN F0R %s";
$lang['useraccountapprovedemail'] = "h3LL0 %s,\n\nyOuR usER 4cC0UNt @t %s H@s b33N @ppR0vED. J00 caN l09In 4ND \$+ArT pOS+1NG IMM3d14+Ly bY CL1CkING thE l1NK 83LOw:\n\n%s\n\n1pH J00 w3r3 N0+ EXp3C+IN9 +hIs 3M@il pHR0M %s Pl34S3 4CC3Pt OuR 4POlogi3\$ @ND F0rw@rD ThI\$ Em@1L t0 %s S0 th4+ +HE \$0URce oF it M4Y Be INv3s+i94t3D.";

// Admin Post Approval notification -----------------------------------------

$lang['newpostapprovalsubject'] = "pOS+ 4pPR0V4l no+1PhIC4+10N PH0R %s";
$lang['newpostapprovalemail'] = "heLlo %s,\n\n4 N3W Po5+ h4S bEEn CR34+3D 0n %s.\n\n@s J00 Ar3 4 modER4+Or 0N th1s FORuM j00 Ar3 ReQU1R3D T0 4PprOVE +H1\$ PO5T bEPhORe 1+ c4N Be R34D By OThER u\$3R\$.\n\nyOU c4N 4PpROve +HIS po\$t 4ND 4NY O+h3RS pENd1ng 4PPr0V@L 8Y v1s1T1N9 th3 4DMiN p0\$T @PpROVaL seCt10N oF yoUR phoRum OR by CliCk1Ng TEH l1Nk 83L0W:\n\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nNOt3: 0Th3r 4DM1n1stRa+orS 0N +H1S F0RUm W1LL ALSO rec31VE +H1S No+1phIC@TI0N 4Nd mAy haVE 4LrE4dY 4C+3D UP0n thi5 reqUe\$+.";

// Forgotten password form.

$lang['passwdresetrequest'] = "your P4SSW0RD RE5eT r3ques+ FROm %s";
$lang['passwdresetemailsent'] = "p4\$sW0rd Re\$et 3-m@il \$3Nt";
$lang['passwdresetexp'] = "j00 5HOulD sh0R+Ly Rece1Ve 4N 3-m4IL coN+4in1NG iN\$+RUc+1OnS PH0r R3Se++1N9 Y0ur PaSsw0rD.";
$lang['validusernamerequired'] = "a v4L1D Usern@M3 Is R3qU1rED";
$lang['forgottenpasswd'] = "f0R90t p4ssW0RD";
$lang['couldnotsendpasswordreminder'] = "cOuld N0T \$3nd paSSwoRD r3M1nDer. pL34sE cON+acT Th3 ForuM owN3r.";
$lang['request'] = "r3qU3\$t";

// Email confirmation (confirm_email.php) ------------------------------

$lang['emailconfirmation'] = "eM4Il cOnphIrM4+I0N";
$lang['emailconfirmationcomplete'] = "tH4Nk j00 f0R coNFiRM1NG yOur 3Mail 4DDre55. J00 m4y nOw L0GIN 4nd ST4RT P0\$TIN9 Imm3D14T3LY.";
$lang['emailconfirmationfailed'] = "eM@IL cONpH1RM@Ti0N H@s F41LED, PLeaSE +Ry A9@IN l4+3R. IPh J00 EnCOUn+3R tHI5 ERroR mUL+1plE +iM3S Pl3a\$3 CONt4C+ The PH0ruM 0Wn3R 0R 4 m0d3r4+Or F0R 4SS1S+4NC3.";

// Links database (links*.php) -----------------------------------------

$lang['toplevel'] = "tOP L3V3l";
$lang['maynotaccessthissection'] = "j00 MaY nO+ 4cC3SS ThI\$ SEC+10n.";
$lang['toplevel'] = "top LEV3l";
$lang['links'] = "l1NKs";
$lang['viewmode'] = "vIEW M0DE";
$lang['hierarchical'] = "hi3r4RChIC@l";
$lang['list'] = "lIST";
$lang['folderhidden'] = "this F0LD3r I\$ H1Dd3n";
$lang['hide'] = "h1D3";
$lang['unhide'] = "uNHIdE";
$lang['nosubfolders'] = "n0 sUbPH0Ld3r5 In tH1\$ C@TEg0Ry";
$lang['1subfolder'] = "1 \$ubFOlDEr 1N thI\$ C4+3g0rY";
$lang['subfoldersinthiscategory'] = "su8foLDErs 1N +H1\$ c@TE90ry";
$lang['linksdelexp'] = "eN+R13s IN 4 D3L3+3D PHOLdeR W1LL 8e M0V3d +0 Teh P4R3N+ PHoLDeR. 0NLY PH0Ld3RS WH1Ch D0 no+ c0N+41N sU8FOlD3R\$ m@Y 83 dELetED.";
$lang['listview'] = "lis+ VIEW";
$lang['listviewcannotaddfolders'] = "c4nNO+ 4Dd PH0lD3R\$ 1n ThIS V1EW. \$HoWIn9 20 3Ntr13\$ 4T 4 +1ME.";
$lang['rating'] = "r4+1nG";
$lang['nolinksinfolder'] = "n0 L1NKS iN tH1s F0ld3r.";
$lang['addlinkhere'] = "add LiNK h3r3";
$lang['notvalidURI'] = "th4T 1S No+ 4 v4L1d uRI!";
$lang['mustspecifyname'] = "j00 Mu\$t 5P3CIPhy @ n@M3!";
$lang['mustspecifyvalidfolder'] = "j00 MUS+ SPeC1PHy 4 V4liD FOLd3R!";
$lang['mustspecifyfolder'] = "j00 MusT SPEc1fy 4 PhoLd3R!";
$lang['successfullyaddedlinkname'] = "sucC3\$sFULLy 4DD3D lINK '%s'";
$lang['failedtoaddlink'] = "f@1lED TO 4Dd L1NK";
$lang['failedtoaddfolder'] = "f@1LED to @DD F0LD3R";
$lang['addlink'] = "aDd @ lINK";
$lang['addinglinkin'] = "addIN9 l1NK In";
$lang['addressurluri'] = "addRe5s";
$lang['addnewfolder'] = "add 4 NEw PhOLdER";
$lang['addnewfolderunder'] = "addING NEw Ph0LD3R und3R";
$lang['editfolder'] = "ed1+ PH0Ld3r";
$lang['editingfolder'] = "eDITIn9 F0LDer";
$lang['mustchooserating'] = "j00 MUST cHO0s3 A r@TInG!";
$lang['commentadded'] = "youR COmm3N+ wA5 4Dded.";
$lang['commentdeleted'] = "cOMMEn+ W4S D3l3+3D.";
$lang['commentcouldnotbedeleted'] = "c0mm3nT C0uld NO+ b3 DELet3D.";
$lang['musttypecomment'] = "j00 MU\$t +yP3 4 ComMENT!";
$lang['mustprovidelinkID'] = "j00 MuS+ PR0ViDE @ L1NK 1D!";
$lang['invalidlinkID'] = "iNv4l1D L1Nk 1D!";
$lang['address'] = "aDDR3\$S";
$lang['submittedby'] = "suBMi++3D by";
$lang['clicks'] = "cLIck\$";
$lang['rating'] = "r4TInG";
$lang['vote'] = "v0t3";
$lang['votes'] = "vo+3s";
$lang['notratedyet'] = "n0+ R4+3D 8Y 4NYOnE YET";
$lang['rate'] = "ratE";
$lang['bad'] = "b4d";
$lang['good'] = "g00D";
$lang['voteexcmark'] = "v0te!";
$lang['clearvote'] = "cle@r vo+3";
$lang['commentby'] = "c0mm3NT by %s";
$lang['addacommentabout'] = "aDD A c0MM3N+ @Bout";
$lang['modtools'] = "m0Der@+10n T00lS";
$lang['editname'] = "ediT n4mE";
$lang['editaddress'] = "edi+ 4DDr3s5";
$lang['editdescription'] = "eDI+ d35CR1PTi0n";
$lang['moveto'] = "mOVE +O";
$lang['linkdetails'] = "lINK d3+41lS";
$lang['addcomment'] = "add C0mMenT";
$lang['voterecorded'] = "yOUR VO+3 haS 8EEn R3CORD3D";
$lang['votecleared'] = "yOUr V0+3 H@S beEN cL34R3D";
$lang['linknametoolong'] = "l1Nk N4m3 +0O L0nG. M4x1MUM 1S %s CHar4c+3rS";
$lang['linkurltoolong'] = "l1nk UrL +O0 L0Ng. M4XImUM 15 %s CH4R4C+3R\$";
$lang['linkfoldernametoolong'] = "f0ld3R n4ME tO0 l0Ng. m4X1MUm L3NgTh 1\$ %s Ch4r4Ct3RS";

// Login / logout (llogon.php, logon.php, logout.php) -----------------------------------------

$lang['loggedinsuccessfully'] = "j00 L0G93D IN 5uCC3s\$FUllY.";
$lang['presscontinuetoresend'] = "pR3\$s C0nT1NuE +o R3\$3ND phORm D@T4 Or C@NCeL +0 R3LO4d P@Ge.";
$lang['usernameorpasswdnotvalid'] = "th3 USERN4ME OR p4SSWORd j00 \$UPPlieD is NO+ V@L1D.";
$lang['rememberpasswds'] = "r3m3mB3R p@5SWORD\$";
$lang['rememberpassword'] = "rEMEm8ER PASSw0RD";
$lang['enterasa'] = "eNtER 4s 4 %s";
$lang['donthaveanaccount'] = "don'+ H4VE 4n 4CCOuN+? %s";
$lang['registernow'] = "r391\$teR n0W";
$lang['problemsloggingon'] = "pRo8LEMs Lo99ING oN?";
$lang['deletecookies'] = "d3L3+3 COOK1ES";
$lang['cookiessuccessfullydeleted'] = "cO0k1E\$ 5UCcES\$phULlY dEL3T3D";
$lang['forgottenpasswd'] = "fOR9ot+3N Y0uR PA\$swoRD?";
$lang['usingaPDA'] = "us1N9 A PDA?";
$lang['lightHTMLversion'] = "ligHT hTML VerS1ON";
$lang['youhaveloggedout'] = "j00 H4Ve L099ED 0U+.";
$lang['currentlyloggedinas'] = "j00 4RE CURR3NTly L09GED 1N 4S %s";
$lang['logonbutton'] = "logON";
$lang['anotheruser'] = "aNo+hEr UsER";
$lang['yoursessionhasexpired'] = "yoUr s35S1oN h@5 EXpiRED. J00 WIlL N33D to L09IN 494IN +O c0Nt1nU3.";

// My Forums (forums.php) ---------------------------------------------------------

$lang['myforums'] = "mY pH0RUms";
$lang['allavailableforums'] = "aLL @v@Il@8L3 pH0RuM\$";
$lang['favouriteforums'] = "f4vOUR1+3 f0rUMS";
$lang['ignoredforums'] = "i9n0R3d pHORuMS";
$lang['ignoreforum'] = "i9noRE F0RUM";
$lang['unignoreforum'] = "uni9n0RE PhoRum";
$lang['lastvisited'] = "lASt V1\$1t3D";
$lang['forumunreadmessages'] = "%s uNRe4d m35\$@9E5";
$lang['forummessages'] = "%s Me\$SAgES";
$lang['forumunreadtome'] = "%s UNr3ad &quot;to: ME&quot;";
$lang['forumnounreadmessages'] = "no UNr3@D ME\$s49es";
$lang['removefromfavourites'] = "r3m0V3 PhR0m PH@v0uR1+3\$";
$lang['addtofavourites'] = "aDd TO F4VOURI+3\$";
$lang['availableforums'] = "aVail48LE PHOruM\$";
$lang['noforumsofselectedtype'] = "tH3r3 4R3 n0 FOruMS 0PH TH3 sELECtEd TypE aV41L@8LE. Pl3@s3 S3LecT @ D1FPh3R3NT Typ3.";
$lang['successfullyaddedforumtofavourites'] = "sUCC3\$sPHullY @dDEd PHoRUm +0 Ph@vOUr1TE\$.";
$lang['successfullyremovedforumfromfavourites'] = "sucCESSphULLy R3MOVEd Ph0RUm FROm F4V0Ur1tES.";
$lang['successfullyignoredforum'] = "sUCCEssPhuLLy ignoREd F0rUM.";
$lang['successfullyunignoredforum'] = "sUcC3\$SPhuLLY UNIgN0RED ph0RUM.";
$lang['failedtoupdateforuminterestlevel'] = "f41L3D tO upD4+3 f0RUm In+3R3s+ l3vEL";
$lang['noforumsavailablelogin'] = "tHeRe @r3 N0 pH0rUM\$ AV41l@8LE. PlE4S3 l0Gin TO v1ew YOUr PH0RUm\$.";
$lang['passwdprotectedforum'] = "p@S\$wORd PRO+3C+3D PH0RuM";
$lang['passwdprotectedwarning'] = "tHI\$ pHORuM 15 P@SSWORD PR0TEC+3D. T0 941N 4ccesS ENteR TEh P@SSworD 83L0W.";

// Message composition (post.php, lpost.php) --------------------------------------

$lang['postmessage'] = "p0S+ m3s549e";
$lang['selectfolder'] = "s3L3c+ phOLDEr";
$lang['mustenterpostcontent'] = "j00 mUSt 3N+3R \$0M3 c0n+3NT PH0R TH3 p0\$T!";
$lang['messagepreview'] = "mEs5a9e PREV13w";
$lang['invalidusername'] = "iNValiD usERN4ME!";
$lang['mustenterthreadtitle'] = "j00 mU\$T 3NtER 4 +1+Le PHOR tH3 +hRE4D!";
$lang['pleaseselectfolder'] = "pL3453 \$ELeCT A Ph0lDEr!";
$lang['errorcreatingpost'] = "erR0r Cr3a+1Ng P0s+! PLEa\$3 tRY AGAin In 4 Few M1NU+es.";
$lang['createnewthread'] = "cre@+E new +hR34d";
$lang['postreply'] = "p0ST R3pLY";
$lang['threadtitle'] = "tHrEaD +1+lE";
$lang['messagehasbeendeleted'] = "m35s@93 NOt PhOUNd. checK tH4T 1+ H4SN'+ 833n DELetED.";
$lang['messagenotfoundinselectedfolder'] = "mE\$s@GE NO+ F0uNd In \$3L3C+ed PHolDEr. Ch3CK +H4T 1+ h4SN'+ b3EN mOV3d OR d3LE+3d.";
$lang['cannotpostthisthreadtypeinfolder'] = "j00 C4NNOT P0S+ +hI\$ +hRE4d +YPE 1N +H4+ PH0LD3R!";
$lang['cannotpostthisthreadtype'] = "j00 C4NNot PO\$+ +H1s +hRe4d +YPe 4s +h3R3 ArE NO 4V41L48L3 PH0lD3RS TH4+ ALlOW i+.";
$lang['cannotcreatenewthreads'] = "j00 c@NNo+ CR34TE NEW +Hr3@ds.";
$lang['threadisclosedforposting'] = "tH1\$ +hRE4d 1\$ CL0S3D, J00 caNNo+ pO\$T 1N I+!";
$lang['moderatorthreadclosed'] = "w4RnIn9: th1s +hRE4D 1\$ ClOSeD pHOR PO\$+1NG T0 n0rm@L usErs.";
$lang['usersinthread'] = "us3RS 1N +hRe4D";
$lang['correctedcode'] = "c0rREct3D C0dE";
$lang['submittedcode'] = "sUbMI+tEd COD3";
$lang['htmlinmessage'] = "hTML IN m3S\$@GE";
$lang['disableemoticonsinmessage'] = "di54BLE em0tiCON\$ 1N M3s549e";
$lang['automaticallyparseurls'] = "autoM@tICalLy P4RSE urL\$";
$lang['automaticallycheckspelling'] = "aut0m4+IC@llY ch3CK SpELl1nG";
$lang['setthreadtohighinterest'] = "s3T +hR3aD TO HIgH 1N+3R3ST";
$lang['enabledwithautolinebreaks'] = "eN48LeD w1+H 4U+0-l1NE-8R34kS";
$lang['fixhtmlexplanation'] = "tH1s FoRuM US3\$ hTML FIl+3RInG. yOUR sUbM1+T3D H+Ml Ha\$ 833N MOd1f13D By TH3 F1LTER\$ in \$omE waY.\\n\\n+0 V13W Y0UR orIGiN4L c0dE, 5ELEc+ +eH \\'su8M1+tED COD3\\' R4DI0 but+ON.\\n+0 V13W tH3 M0d1f1eD c0D3, S3lECT TEH \\'CORR3C+3d c0dE\\' R@dI0 8U+toN.";
$lang['messageoptions'] = "m3\$54G3 0PTION\$";
$lang['notallowedembedattachmentpost'] = "j00 4RE n0T 4LL0weD +0 3M8ED a+T@chm3N+S 1N Y0UR POST\$.";
$lang['notallowedembedattachmentsignature'] = "j00 4r3 NOT alL0WED T0 3MBED a++4CHM3nTS 1n YoUR 5IGnaTUre.";
$lang['reducemessagelength'] = "mE\$S493 l3NgTH MusT B3 UnDEr 65,535 ch4R4C+3RS (CuRR3N+LY: %s)";
$lang['reducesiglength'] = "s1GN4tUre LEN9+h MusT 8e UND3r 65,535 CH@R@C+3RS (curr3NTLy: %s)";
$lang['cannotcreatethreadinfolder'] = "j00 c@NnoT Cr34Te NEw THr3adS 1N +h1\$ pHoLdeR";
$lang['cannotcreatepostinfolder'] = "j00 c@nNoT rEPlY +o P0STS 1n THi\$ phoLd3r";
$lang['cannotattachfilesinfolder'] = "j00 C4NNot P0\$+ AT+4cHM3NT\$ IN tH1\$ f0LDER. ReMOVE 4++4CHmEN+s tO coNTINuE.";
$lang['postfrequencytoogreat'] = "j00 C4N OnlY pOSt ONce Ev3ry %s \$3CONDS. pLE4s3 TrY 4941N l4+3R.";
$lang['emailconfirmationrequiredbeforepost'] = "email CONPHirM4+10N is ReQU1RED BEF0RE J00 c@N p0\$t. If J00 H4VE N0T R3C31vED 4 conPHirM@+10n 3M41L PL3A\$e Cl1cK ThE 8u++ON 8eL0w @Nd A neW 0NE W1LL 83 \$eNT T0 Y0u. IpH YOUR 3m@IL 4dDrEsS NE3D\$ ch4n9IN9 PLE4S3 D0 S0 8EFOR3 ReQuESTIn9 4 New c0NPhIrm4+1ON em@iL. J00 M4Y CH@ngE YOuR EM4Il 4DDrES5 By CL1Ck MY c0NTroLs A8oV3 AnD +h3N usER D3t4ilS";
$lang['emailconfirmationfailedtosend'] = "conF1RM4+10N eM41L pH@IL3D +0 s3ND. Pl34sE c0N+acT THe F0RuM 0WNer TO R3CT1PHY Thi\$.";
$lang['emailconfirmationsent'] = "c0nFIrM4TioN eM41L H@\$ B33N r353N+.";
$lang['resendconfirmation'] = "rES3ND c0nPH1RM4Ti0N";
$lang['userapprovalrequiredbeforeaccess'] = "yOuR u\$3r aCC0UN+ ne3DS +0 B3 4PPR0VED by 4 F0RUM 4Dm1N B3f0R3 J00 C@N acc3\$S +h3 ReQUes+3D PH0rUM.";

// Message display (messages.php & messages.inc.php) --------------------------------------

$lang['inreplyto'] = "iN R3PLy TO";
$lang['showmessages'] = "sHoW M3Ss493s";
$lang['ratemyinterest'] = "r@+3 My 1NT3REs+";
$lang['adjtextsize'] = "aDJU\$+ +3xt siZE";
$lang['smaller'] = "sm@LL3r";
$lang['larger'] = "largER";
$lang['faq'] = "fAQ";
$lang['docs'] = "d0C5";
$lang['support'] = "sUPp0r+";
$lang['donateexcmark'] = "d0n@TE!";
$lang['fontsizechanged'] = "f0N+ s1zE ch4N9eD. %s";
$lang['framesmustbereloaded'] = "fR4MEs MU5+ Be r3l04D3D M4NU@lLY +0 S3E cH4N93S.";
$lang['threadcouldnotbefound'] = "the REQUe\$T3d Thr34d COULd NO+ Be PH0unD 0R AcCE\$S W45 D3NI3D.";
$lang['mustselectpolloption'] = "j00 Mu\$+ S3L3CT 4N 0P+10N +O vOTE foR!";
$lang['mustvoteforallgroups'] = "j00 mU\$+ V0+3 IN EVERY 9r0UP.";
$lang['keepreading'] = "k33p Re4Din9";
$lang['backtothreadlist'] = "b@cK +0 thR3AD lI\$+";
$lang['postdoesnotexist'] = "tH4+ p0sT d0E5 n0T 3X1\$T 1n tHiS THreAD!";
$lang['clicktochangevote'] = "cL1ck +0 Ch@Nge V0Te";
$lang['youvotedforoption'] = "j00 V0Ted F0R oPTi0N";
$lang['youvotedforoptions'] = "j00 voT3D f0r oPTIonS";
$lang['clicktovote'] = "cLICk To VOtE";
$lang['youhavenotvoted'] = "j00 h4v3 NoT voT3D";
$lang['viewresults'] = "v1eW RESulTS";
$lang['msgtruncated'] = "m3ss@gE TRUNCATed";
$lang['viewfullmsg'] = "vi3w PHUlL M3SSAGE";
$lang['ignoredmsg'] = "i9n0REd M3SS@G3";
$lang['wormeduser'] = "w0rMED us3R";
$lang['ignoredsig'] = "i9NOr3D S1GN@+UrE";
$lang['messagewasdeleted'] = "m35\$Age %s.%s W4S deL3TEd";
$lang['stopignoringthisuser'] = "s+Op IGN0rIn9 Th1\$ US3R";
$lang['renamethread'] = "r3n4ME THre4D";
$lang['movethread'] = "m0vE tHR34D";
$lang['torenamethisthreadyoumusteditthepoll'] = "t0 RenAMe +h1\$ Thr3ad J00 MU\$t EDIt Th3 P0Ll.";
$lang['closeforposting'] = "cl0S3 FOR poSTInG";
$lang['until'] = "untIL 00:00 U+c";
$lang['approvalrequired'] = "aPPROV4L reQU1RED";
$lang['messageawaitingapprovalbymoderator'] = "me5s4G3 %s.%s 1s @w41T1N9 APpR0vAl by 4 M0d3r4TOR";
$lang['postapprovedsuccessfully'] = "poST @PPRoved \$UCc3\$spHULlY";
$lang['postapprovalfailed'] = "p0st @pPR0v@L PH41L3D.";
$lang['postdoesnotrequireapproval'] = "p0S+ DOES N0+ R3QU1RE 4pPROV4L";
$lang['approvepost'] = "aPpR0V3 POS+";
$lang['approvedbyuser'] = "appROV3D: %s BY %s";
$lang['makesticky'] = "m4K3 \$TICKy";
$lang['messagecountdisplay'] = "%s OF %s";
$lang['linktothread'] = "p3rMAn3n+ LInK to +h1\$ +HR34D";
$lang['linktopost'] = "link +0 po\$t";
$lang['linktothispost'] = "linK to +h1\$ POS+";
$lang['imageresized'] = "tH1\$ 1M4GE h4s 8EEN R3sizEd (0R19In4l S1Z3 %1\$sx%2\$S). +O V13W +EH FUll-S1ZE IM493 Cl1cK H3RE.";
$lang['messagedeletedbyuser'] = "m3Ss@93 %s.%s d3LE+Ed %s 8Y %s";
$lang['messagedeleted'] = "m3ss4G3 %s.%s w4s d3lE+3D";

// Moderators list (mods_list.php) -------------------------------------

$lang['cantdisplaymods'] = "c4NNO+ dISPL4Y F0Ld3R moD3R4TOrS";
$lang['moderatorlist'] = "m0d3R4+Or Li\$+:";
$lang['modsforfolder'] = "mOdERAt0RS F0r F0lDER";
$lang['nomodsfound'] = "no M0D3RA+0RS Ph0UNd";
$lang['forumleaders'] = "forUM L3@D3RS:";
$lang['foldermods'] = "fOLDEr M0Der4+0RS:";

// Navigation strip (nav.php) ------------------------------------------

$lang['start'] = "s+4r+";
$lang['messages'] = "m3ss49ES";
$lang['pminbox'] = "iNb0x";
$lang['startwiththreadlist'] = "st@Rt P49E wI+H +Hre4D LIS+";
$lang['pmsentitems'] = "s3N+ i+Ems";
$lang['pmoutbox'] = "ouTb0x";
$lang['pmsaveditems'] = "sAV3D 1T3MS";
$lang['pmdrafts'] = "dR@F+S";
$lang['links'] = "lINkS";
$lang['admin'] = "aDM1N";
$lang['login'] = "lO91n";
$lang['logout'] = "lO9ouT";

// PM System (pm.php, pm_write.php, pm.inc.php) ------------------------

$lang['privatemessages'] = "pRIV4TE M3\$S@9ES";
$lang['recipienttiptext'] = "s3p4R4+3 REcIPIEntS 8y \$3M1-c0lOn OR cOMm4";
$lang['maximumtenrecipientspermessage'] = "theRE IS @ LIMi+ 0PH 10 REC1p1eN+S p3r M3\$SAG3. Plea\$3 4MEND Y0uR reC1PI3N+ L15+.";
$lang['mustspecifyrecipient'] = "j00 Mus+ SP3CifY 4+ lE4\$+ 0NE R3CipIENt.";
$lang['usernotfound'] = "usER %s n0+ PHOUnd";
$lang['sendnewpm'] = "send NEW PM";
$lang['savemessage'] = "s@vE meSs@Ge";
$lang['timesent'] = "tim3 SENT";
$lang['errorcreatingpm'] = "err0R Cr34tIn9 pM! PlE@S3 TRY 4g41N IN 4 FEw MinUt3s";
$lang['writepm'] = "wRi+E meSs4GE";
$lang['editpm'] = "eDiT m3SS49E";
$lang['cannoteditpm'] = "c@Nno+ Edi+ +H1S PM. I+ h4s aLr34DY 83EN viEW3D By TeH R3C1P13NT 0r t3H me\$S@9e DoeS N0+ EX1S+ 0R 1+ 1s 1N@CC3s\$1BLE By J00";
$lang['cannotviewpm'] = "c@nN0+ V13w Pm. Mess4g3 DOES noT 3xIs+ 0R 1+ IS 1N4CCess1bLE 8Y J00";
$lang['pmmessagenumber'] = "mE\$SAge %s";

$lang['youhavexnewpm'] = "j00 h4V3 %d N3w M3\$S49E\$. w0uLD J00 l1kE +O go TO YOUr INBOx n0W?";
$lang['youhave1newpm'] = "j00 HAvE 1 N3W M3s5@GE. W0ULD J00 LIkE +o 90 TO YOUR 1NB0X N0W?";
$lang['youhave1newpmand1waiting'] = "j00 h4VE 1 NEW m3\$saG3.\n\nY0U 4lS0 H@v3 1 M3\$SAg3 @W41tING deLiV3RY. +o R3C31Ve THi\$ m3\$s493 Pl3@SE cL34R \$oM3 5P@c3 In YOur INb0x.\n\nWOUlD j00 LikE +0 90 To Y0UR INb0x Now?";
$lang['youhave1pmwaiting'] = "j00 Have 1 M3S\$49e @w4I+1NG d3L1VERY. T0 R3CE1V3 +hI\$ M3ssAGE pl3@\$3 cL34R S0M3 sp4CE 1N y0uR IN80x.\n\nw0ULD J00 likE To G0 T0 y0uR In80X n0w?";
$lang['youhavexnewpmand1waiting'] = "j00 HAV3 %d nEW MESS493S.\n\nyOU 4LS0 H@v3 1 M3\$S@Ge 4W@i+1N9 dEL1V3RY. +0 r3c3IV3 +h1\$ m3sS@ge PlEASe CL34R \$ome \$P@C3 IN youR INboX.\n\nWOUlD J00 LIk3 +0 9o T0 y0ur IN80X N0W?";
$lang['youhavexnewpmandxwaiting'] = "j00 HAve %d n3W M3sS4GES.\n\nY0u AL\$0 h4v3 %d m3SSA9ES 4WAI+iN9 DElIVerY. +O R3Ce1VE +H3\$3 m3sSAGE pLe4s3 cL34R sOM3 Sp4cE In YOuR 1N8OX.\n\nWOULd j00 L1K3 +o Go +0 Y0UR 1NBoX N0W?";
$lang['youhave1newpmandxwaiting'] = "j00 h@V3 1 NEW meSS49E.\n\nyou @LSO H4Ve %d mESS4GeS 4W4I+1NG DEliVeRY. T0 r3cE1VE +H3S3 MessAGeS pLE@\$e cL3@R sOME SP@C3 In YouR 1N80x.\n\nw0UlD J00 l1Ke +o 90 +0 YOUr 1N8OX n0W?";
$lang['youhavexpmwaiting'] = "j00 H4Ve %d M3SSAgE\$ 4w@IT1Ng DelIV3Ry. tO r3CE1v3 Th3s3 M3\$S493S pL3@Se CLE@R \$OME 5P4C3 iN Y0UR INB0X.\n\nWOulD J00 liKE TO G0 t0 Y0UR 1Nb0x n0W?";

$lang['youdonothaveenoughfreespace'] = "j00 D0 nO+ H4v3 3NOU9H pHREE \$p4CE To S3ND tH1\$ ME\$s49E.";
$lang['userhasoptedoutofpm'] = "%s h4\$ 0PteD OUt OF rEC3IV1N9 P3r\$0N4L MessA9E5";
$lang['pmfolderpruningisenabled'] = "pM fold3R Prun1N9 15 ENAbL3d!";
$lang['pmpruneexplanation'] = "th1s FORUM u5Es Pm PHOLdER prun1n9. +eH ME\$S49Es J00 HAvE 5+0R3d 1N YOUR 1n80x 4nD SeN+ i+3MS\\nPh0lD3RS 4Re \$uBJec+ +o 4U+oMA+IC D3le+10N. @NY m3S549ES j00 W1sH +O K33P \$HOulD b3 M0V3d +0\\nYouR \\'S4v3d 1TEMS\\' F0LD3R S0 +H4+ +heY @R3 no+ DEl3+3d.";
$lang['yourpmfoldersare'] = "y0ur PM f0ldERs 4RE %s pHuLL";
$lang['currentmessage'] = "curREN+ m3ss49E";
$lang['unreadmessage'] = "uNRE4D MESsagE";
$lang['readmessage'] = "rE@D MESS@93";
$lang['pmshavebeendisabled'] = "p3rsON4L mE\$\$493\$ H@v3 B33N D1s4BleD bY ThE PHORuM OwNER.";
$lang['adduserstofriendslist'] = "add u53R\$ +o YOuR frI3ND\$ liS+ +O h@Ve +h3m @Pp34R In @ DroP doWN ON +h3 PM Wri+3 M3ss4G3 P49e.";

$lang['messagesaved'] = "m3\$5A9E \$4V3D";
$lang['messagewassuccessfullysavedtodraftsfolder'] = "me\$S4GE w4S sUcCE55FUllY S4v3d +0 'Dr4PHtS' f0lD3R";
$lang['couldnotsavemessage'] = "cOuLD nO+ S@v3 mE\$S4GE. m@KE SUre J00 H4V3 3N0u9H 4v41L@bLE PhR3E \$p@C3.";
$lang['pmtooltipxmessages'] = "%s MEsS@GE\$";
$lang['pmtooltip1message'] = "1 mESS4Ge";

$lang['allowusertosendpm'] = "alL0W u\$3R +o 5ENd p3R50N4L m3s549e\$ +0 m3";
$lang['blockuserfromsendingpm'] = "bl0cK uSER FR0m S3ndIN9 P3r\$0N4L M3554G3\$ +0 M3";
$lang['yourfoldernamefolderisempty'] = "y0uR %s pHOLdER I\$ eMpTY";
$lang['successfullydeletedselectedmessages'] = "sUCC3SSFulLy DElE+3D \$EL3CtEd ME5s49E\$";
$lang['successfullyarchivedselectedmessages'] = "sUCCE\$5PhuLLy 4RCH1VEd S3LEC+3d M35s@G3s";
$lang['failedtodeleteselectedmessages'] = "f41led TO dEL3+3 \$3LEct3D M3SS493\$";
$lang['failedtoarchiveselectedmessages'] = "f4IL3D +0 4RCh1Ve S3LEc+Ed MeS\$49ES";

// Preferences / Profile (user_*.php) ---------------------------------------------

$lang['mycontrols'] = "mY CONtROLS";
$lang['myforums'] = "mY PH0RuMS";
$lang['menu'] = "m3nU";
$lang['userexp_1'] = "u5E +3H M3Nu on TH3 l3PHT +o M@n@GE YouR \$3+T1NGS.";
$lang['userexp_2'] = "<b>uSER DE+41Ls</b> 4lL0W\$ J00 to ch4N9e y0uR N4ME, 3m41L @dDR3\$s aND p@5sW0RD.";
$lang['userexp_3'] = "<b>uSer ProFILE</b> @Ll0wS J00 +0 3D1+ y0uR uS3R PR0FIl3.";
$lang['userexp_4'] = "<b>chaN93 PA\$\$w0RD</b> @LL0WS J00 +0 ChAN93 Y0UR P@SSWOrD";
$lang['userexp_5'] = "<b>em@IL &amp; Pr1V4CY</b> lE+s J00 ch4nGE h0W j00 c@N b3 C0n+4C+Ed 0N @Nd 0FPh +Eh pHORuM.";
$lang['userexp_6'] = "<b>fORUm OPtI0nS</b> L3+s J00 CHAn9E hOW TEH PHoRUM LO0KS 4ND woRks.";
$lang['userexp_7'] = "<b>aT+4cHM3N+\$</b> 4LLoWS j00 TO 3Dit/deLe+3 YOUr 4tt@CHmEN+s.";
$lang['userexp_8'] = "<b>sI9NA+Ur3</b> L3+\$ j00 3Di+ y0uR s19n4tURe.";
$lang['userexp_9'] = "<b>r3L4+10NSHiP\$</b> leTS J00 mANagE y0UR R3L4TI0n\$hIP w1+H 0+H3R us3R5 0N T3H PHOruM.";
$lang['userexp_9'] = "<b>w0rD PhIL+3R</b> LETS J00 Ed1+ Y0UR p3RS0N4L WORD pHIlTeR.";
$lang['userexp_10'] = "<b>tHr3AD \$uBScR1PtI0NS</b> 4LL0ws j00 T0 M@N@Ge YOuR tHR3@d SU8\$cRIpT10NS.";
$lang['userdetails'] = "uS3R dET4Ils";
$lang['userprofile'] = "u\$ER PRofIL3";
$lang['emailandprivacy'] = "eMAIL &amp; PriV4CY";
$lang['editsignature'] = "edIT SI9N4TuR3";
$lang['norelationshipssetup'] = "j00 H4Ve no us3R reL4+10N\$h1pS S3+ Up. 4Dd 4 N3W uS3R BY S34RcHING BEL0W.";
$lang['editwordfilter'] = "ediT W0Rd phil+3R";
$lang['userinformation'] = "uSer 1NPH0RM4T10N";
$lang['changepassword'] = "cH@N93 P@\$SWORd";
$lang['currentpasswd'] = "cURRen+ p4SSWORD";
$lang['newpasswd'] = "nEw P4\$\$wOrd";
$lang['confirmpasswd'] = "c0nPHiRM P4SSw0RD";
$lang['passwdsdonotmatch'] = "p@SSwORDs D0 N0T m4TCh!";
$lang['nicknamerequired'] = "n1cKN4M3 IS r3QUIRED!";
$lang['emailaddressrequired'] = "eMA1L AdDR3\$S 1s ReqU1R3D!";
$lang['logonnotpermitted'] = "l09ON NO+ peRMiTt3D. Choos3 4N0THeR!";
$lang['nicknamenotpermitted'] = "n1ckN@mE NO+ p3RM1+TeD. ChOOSE 4n0THeR!";
$lang['emailaddressnotpermitted'] = "eMAIl 4DDRES5 nO+ P3RmIt+ED. CHooS3 4N0THER!";
$lang['emailaddressalreadyinuse'] = "eMaiL 4DdrESS @Lr34DY IN US3. cHO0\$3 4NO+Her!";
$lang['relationshipsupdated'] = "rElA+ioNSHiPS UPD4TeD!";
$lang['relationshipupdatefailed'] = "r3l4tI0N5h1P upD@Ted Ph@Iled!";
$lang['preferencesupdated'] = "pR3fer3NCeS were SuCCESSPhuLLY UPd@tED.";
$lang['userdetails'] = "u53R de+@1L\$";
$lang['memberno'] = "memBEr No.";
$lang['firstname'] = "f1rs+ NAmE";
$lang['lastname'] = "l4\$+ n4mE";
$lang['dateofbirth'] = "d@+3 0Ph 81R+h";
$lang['homepageURL'] = "h0mEpAGe URl";
$lang['profilepicturedimensions'] = "proF1LE pIC+uRE (M@x 95X95PX)";
$lang['avatarpicturedimensions'] = "av4+@R pIcTUr3 (maX 15X15PX)";
$lang['invalidattachmentid'] = "iNV4Lid 4Tt4CHmEn+. cH3Ck +H4T 1\$ H4SN'+ bE3N dEL3+3D.";
$lang['unsupportedimagetype'] = "uN\$upPORTed 1M@93 4TTAcHMEN+. J00 C@N ONLy uS3 jPG, GIF AND Pn9 1m49e 4+T@ChM3N+s f0R YOur aV4+AR 4ND pR0f1L3 P1CTurE.";
$lang['selectattachment'] = "s3l3C+ A+t@CHmeN+";
$lang['pictureURL'] = "p1c+UR3 URl";
$lang['avatarURL'] = "av4t4R URl";
$lang['profilepictureconflict'] = "to USE 4n aT+4ChMEn+ PhOR Y0ur PR0fIle P1CTuRE +HE p1c+Ur3 URl PH13LD mUSt B3 8L4NK.";
$lang['avatarpictureconflict'] = "to U\$E @N 4+t@ChM3Nt f0R Y0ur aVAt4R piCtURe T3H 4v@t4R UrL Fi3LD MUs+ B3 bl4NK.";
$lang['attachmenttoolargeforprofilepicture'] = "s3lEC+Ed 4tt4CHmEN+ 1S +0o L4RG3 PhoR PrOF1LE P1C+uRE. M4XIMuM D1meNs10nS 4Re %s";
$lang['attachmenttoolargeforavatarpicture'] = "seL3C+3d 4++4chMeNt is T00 l4rge F0R 4vA+aR piC+uRe. m@X1MUM dimEN\$10Ns 4rE %s";
$lang['failedtoupdateuserdetails'] = "som3 OR 4LL 0F yOuR Us3R @Cc0uN+ D3+41LS C0ULD n0T 83 UpdA+3D. PLEasE trY 4941N L@t3r.";
$lang['failedtoupdateuserpreferences'] = "sOm3 0r ALl OF y0uR u5er Pr3FER3NCEs couLD NO+ b3 uPD@TEd. pLeA\$E Try 49@1n l4+Er.";
$lang['emailaddresschanged'] = "eM4iL @ddRESS H4s BE3N ChAN9ED";
$lang['newconfirmationemailsuccess'] = "yoUR 3M41L @DDR3SS h4s b3eN cH4N9ED 4Nd @ n3W cONFiRmaT10N 3mAIl hAS 8EEn S3N+. PL34\$3 chECk 4Nd R3@D Th3 EM@1L ph0R fUR+h3R 1ns+RUCti0Ns.";
$lang['newconfirmationemailfailure'] = "j00 H@VE ch@ngED YOur eM41L 4DDRESS, BUt W3 WER3 Un48L3 +O SEND 4 c0nPHIrM4+10n REQU3\$T. Ple4S3 C0N+@C+ +He PH0RUM oWN3R Ph0r @SSIsT@nC3.";
$lang['forumoptions'] = "f0rUM OPTIOns";
$lang['notifybyemail'] = "noTifY BY EM@1l OPh POS+S tO ME";
$lang['notifyofnewpm'] = "n0+IPhy bY poPUp 0PH NEW Pm MesSAGes +0 me";
$lang['notifyofnewpmemail'] = "n0tiPhY By EM4IL oF nEW PM m3s\$49ES +0 M3";
$lang['daylightsaving'] = "aDjU\$t pHOR DAyl19H+ \$@vInG";
$lang['autohighinterest'] = "aU+0M4+1C4Lly m@RK THr34DS 1 p0St In 4s H19H 1N+3r3sT";
$lang['convertimagestolinks'] = "au+om@TIC@lLY c0NveRT 3M8EDD3D IM4G3s 1n POSTS 1NTO L1NKS";
$lang['thumbnailsforimageattachments'] = "thumbna1ls PH0R 1m4G3 @t+AcHM3N+s";
$lang['smallsized'] = "sM4Ll S1ZEd";
$lang['mediumsized'] = "mEDIuM \$1Z3D";
$lang['largesized'] = "laRGE \$IzED";
$lang['globallyignoresigs'] = "glo84Lly igN0Re US3R S1GnA+UR3S";
$lang['allowpersonalmessages'] = "aLl0W O+HER useRS To \$END M3 P3RSoN@l M3\$S@93s";
$lang['allowemails'] = "aLLOw O+h3R US3rS +o SENd ME eMAIL\$ v14 My Pr0pH1lE";
$lang['timezonefromGMT'] = "t1M3 z0N3";
$lang['postsperpage'] = "p0\$TS p3R P@gE";
$lang['fontsize'] = "fONT \$1Ze";
$lang['forumstyle'] = "foruM STyLE";
$lang['forumemoticons'] = "f0RUM EmOT1CON5";
$lang['startpage'] = "st4rt P49E";
$lang['signaturecontainshtmlcode'] = "si9N@TuRE CON+@IN\$ H+mL coDE";
$lang['savesignatureforuseonallforums'] = "sAv3 \$1gN4TUR3 PH0R UsE 0n 4LL PH0RUMS";
$lang['preferredlang'] = "pREFERreD L@nGU493";
$lang['donotshowmyageordobtoothers'] = "d0 n0T Sh0W MY 4G3 0R D4T3 OF B1R+h +O oTH3R\$";
$lang['showonlymyagetoothers'] = "sHoW ONly MY 49e +0 0tH3r\$";
$lang['showmyageanddobtoothers'] = "sHOw BoTH My 4gE and D@+3 0ph 8iRTH +0 O+heRS";
$lang['showonlymydayandmonthofbirthytoothers'] = "show oNly mY d4y 4ND m0ntH of bIR+H to 0+HEr5";
$lang['listmeontheactiveusersdisplay'] = "li5t M3 On TEh AcTiv3 USEr\$ D1spL4y";
$lang['browseanonymously'] = "broW\$E FORUM 4NOnYM0uSLY";
$lang['allowfriendstoseemeasonline'] = "bR0W\$3 4N0NYM0UsLY, but @llOW fRiENDS +0 S3E Me 4s 0NLIn3";
$lang['revealspoileronmouseover'] = "r3vE4L 5pOIL3R\$ 0N M0USe 0Ver";
$lang['showspoilersinlightmode'] = "alwAYS sH0W SP0IL3RS iN l19HT m0D3 (U5E5 L1Gh+3R Ph0N+ C0LOUr)";
$lang['resizeimagesandreflowpage'] = "rESIz3 1MAg3\$ AnD rePhlOW P493 t0 PREV3nT hoRiZoN+@L SCR0LliNG.";
$lang['showforumstats'] = "shOw PH0RUM \$T@ts @t 8o++om Of MESS4GE p4n3";
$lang['usewordfilter'] = "eN48Le WORD FilTER.";
$lang['forceadminwordfilter'] = "f0rCE Use 0F 4DM1N w0Rd Ph1L+3R 0n 4LL USErS (INc. GU3S+S)";
$lang['timezone'] = "tIm3 Z0NE";
$lang['language'] = "l4n9U@93";
$lang['emailsettings'] = "em@il 4ND COn+ACT S3T+1n9s";
$lang['forumanonymity'] = "f0rUM @N0NYmIty Se++1nG\$";
$lang['birthdayanddateofbirth'] = "biR+hD4Y aND D@TE 0PH 81RTH Di5PL@y";
$lang['includeadminfilter'] = "inCLUd3 4Dm1n WOrD fILtER 1n My L15+.";
$lang['setforallforums'] = "set pH0R 4Ll Ph0rUMS?";
$lang['containsinvalidchars'] = "%s cON+@1NS InV4LID cH4RACtER\$!";
$lang['homepageurlmustincludeschema'] = "hOm3P493 URL MUS+ 1NcLUDE h++P:// ScH3M4.";
$lang['pictureurlmustincludeschema'] = "pic+UR3 url MUs+ InCLUDe H++P:// sCh3M4.";
$lang['avatarurlmustincludeschema'] = "av@t4r URl MUSt iNCluD3 HTTp:// sCH3MA.";
$lang['postpage'] = "p05+ P49e";
$lang['nohtmltoolbar'] = "n0 h+ML +O0l84R";
$lang['displaysimpletoolbar'] = "d1\$PL4y \$1MPle HTmL TOOlB4R";
$lang['displaytinymcetoolbar'] = "d1SPL4Y WY\$iwY9 H+ML +o0l84r";
$lang['displayemoticonspanel'] = "d1sPL4Y eM0T1c0ns P4Nel";
$lang['displaysignature'] = "diSPl4Y S1Gn4+UrE";
$lang['disableemoticonsinpostsbydefault'] = "d1\$4BL3 emO+1COn\$ In MES\$@9eS 8Y dEF4UL+";
$lang['automaticallyparseurlsbydefault'] = "aut0M4TIc@LLy P4R\$3 URls In Me\$s49E\$ BY deFAULt";
$lang['postinplaintextbydefault'] = "p05t 1N PL41N TeXt 8Y deFAUL+";
$lang['postinhtmlwithautolinebreaksbydefault'] = "pOS+ 1n H+Ml Wi+H 4UTo-l1nE-BR3@KS 8Y D3PH4UL+";
$lang['postinhtmlbydefault'] = "posT 1N hTmL 8Y d3F4ULT";
$lang['privatemessageoptions'] = "priV4tE m3SS@GE 0p+I0N\$";
$lang['privatemessageexportoptions'] = "pRiva+3 MESSag3 3XPor+ OPtI0N5";
$lang['savepminsentitems'] = "s4V3 4 c0Py OF E4CH pM 1 s3ND IN my \$3nT 1TEM5 FoLD3R";
$lang['includepminreply'] = "iNcLUDe M3\$549E b0DY wHEn R3Ply1Ng to Pm";
$lang['autoprunemypmfoldersevery'] = "aut0 PRuN3 My PM f0lD3rS 3VERY:";
$lang['friendsonly'] = "fri3ND\$ ONLy?";
$lang['globalstyles'] = "gL084L S+yl3S";
$lang['forumstyles'] = "forUm S+yl35";
$lang['youmustenteryourcurrentpasswd'] = "j00 MU5+ 3NTEr YOUr CurREn+ p@5\$W0RD";
$lang['youmustenteranewpasswd'] = "j00 MU\$t 3N+er a NeW Pa\$sw0RD";
$lang['youmustconfirmyournewpasswd'] = "j00 MU\$+ COnpHiRm YouR N3W P@ssWoRd";
$lang['profileentriesmustnotincludehtml'] = "proPHIle 3NTr13S mU\$+ NO+ INcLUd3 h+Ml";
$lang['failedtoupdateuserprofile'] = "f@1l3d TO UPd@+E US3R pROF1LE";

// Polls (create_poll.php, poll_results.php) ---------------------------------------------

$lang['mustprovideanswergroups'] = "j00 muST pROv1DE \$0ME @NSwER 9R0uPS";
$lang['mustprovidepolltype'] = "j00 Mus+ PR0V1DE 4 p0lL TYp3";
$lang['mustprovidepollresultsdisplaytype'] = "j00 Mus+ PROVide R3SUlt5 dI\$Pl4y tYPE";
$lang['mustprovidepollvotetype'] = "j00 Must pROV1D3 4 PolL VO+e TYP3";
$lang['mustprovidepollguestvotetype'] = "j00 MU\$+ sP3cify 1ph 9uE\$TS shOULD B3 4LLOW3d +0 Vo+3";
$lang['mustprovidepolloptiontype'] = "j00 MU5+ pR0V1De 4 poLL 0PTioN +Yp3";
$lang['mustprovidepollchangevotetype'] = "j00 mU\$T PR0v1DE 4 poLl CH@NGe v0TE tYpE";
$lang['pollquestioncontainsinvalidhtml'] = "oN3 OR mOR3 0F yoUr P0LL QUES+10N\$ C0Nt41N\$ 1nVaL1D h+Ml.";
$lang['pleaseselectfolder'] = "ple4sE \$3lECt 4 FOldER";
$lang['mustspecifyvalues1and2'] = "j00 MusT 5PECifY v4lUE\$ PhoR 4NSw3R\$ 1 4ND 2";
$lang['tablepollmusthave2groups'] = "ta8ul4R PHORM4T POLLS muS+ H@VE PREcis3LY TW0 VO+1n9 GROUps";
$lang['nomultivotetabulars'] = "t@8ULar PhORm4+ poLLS c4nN0T 83 muLT1-v0TE";
$lang['nomultivotepublic'] = "pU8L1C 84Ll0+S C@nN0T 83 MulTi-V0TE";
$lang['abletochangevote'] = "j00 Will B3 48L3 T0 Ch@N9E yoUr VO+3.";
$lang['abletovotemultiple'] = "j00 wILL 83 ABlE +O voTe MUL+IPLe +1M3\$.";
$lang['notabletochangevote'] = "j00 WIlL nO+ b3 ABl3 TO CH4NGe yOuR voTe.";
$lang['pollvotesrandom'] = "no+3: POLl V0+3\$ 4RE r@NdoMly GEN3R4+ED PHOR pR3V1EW 0NLy.";
$lang['pollquestion'] = "p0lL qu3sT10N";
$lang['possibleanswers'] = "possi8l3 4N5WEr\$";
$lang['enterpollquestionexp'] = "eN+3R tH3 4NSwERS fOR YOUR POll quE\$+10n.. IPH YOUR p0LL I\$ 4 &quot;YES/n0&quot; QU3S+10n, \$1MPly 3N+3R &quot;Y3\$&quot; Ph0r 4N\$w3R 1 4Nd &quot;no&quot; pHOR 4NSW3R 2.";
$lang['numberanswers'] = "nO. 4NSw3R\$";
$lang['answerscontainHTML'] = "an\$W3rS CON+41N HtMl (N0T InCLUDinG SIgn4+URE)";
$lang['optionsdisplay'] = "an5w3rs D1sPL@y +YpE";
$lang['optionsdisplayexp'] = "h0W sHOuLD +Eh 4NSw3RS 83 pR3sEN+ED?";
$lang['dropdown'] = "aS DROp-D0Wn lISt(S)";
$lang['radios'] = "aS 4 53rI3s OpH r4Di0 buT+0N5";
$lang['votechanging'] = "vOt3 cH4NGinG";
$lang['votechangingexp'] = "c@n A P3r\$on CH4N93 H1\$ 0r hEr V0+3?";
$lang['guestvoting'] = "gUE5+ VoTIN9";
$lang['guestvotingexp'] = "c@N 9u35+s V0+e IN TH1S p0Ll?";
$lang['allowmultiplevotes'] = "aLLOW MuLT1pL3 Vote5";
$lang['pollresults'] = "p0LL R3SUL+s";
$lang['pollresultsexp'] = "how wOULD j00 L1ke T0 D1\$Pl@Y +3H RE\$ULts 0F YOUr poLl?";
$lang['pollvotetype'] = "p0ll VoTInG +YP3";
$lang['pollvotesexp'] = "h0W sHOULd TEh pOLL 83 CONDUctED?";
$lang['pollvoteanon'] = "an0nyM0uSLY";
$lang['pollvotepub'] = "puBL1C b4lL0T";
$lang['horizgraph'] = "horIZOn+@l gr4PH";
$lang['vertgraph'] = "vERTic@L GR@pH";
$lang['tablegraph'] = "t@bUl@R pH0Rm@T";
$lang['polltypewarning'] = "<b>w4RN1NG</b>: THIS I\$ A PUbL1C bALL0T. yoUR N4ME wiLL bE V1SIBl3 n3XT +0 +h3 OPtI0N J00 Vo+e f0r.";
$lang['expiration'] = "eXpiR4T1oN";
$lang['showresultswhileopen'] = "dO J00 W4NT to SHOW RESUL+S Wh1lE ThE POLL i\$ 0PEn?";
$lang['whenlikepollclose'] = "wheN woULd J00 LiKE YOUr POlL +O @UTOM4+1C4LLY CLo5e?";
$lang['oneday'] = "oN3 D4Y";
$lang['threedays'] = "thr33 D4ys";
$lang['sevendays'] = "sEven D@Ys";
$lang['thirtydays'] = "tH1r+Y D4Y\$";
$lang['never'] = "nEVER";
$lang['polladditionalmessage'] = "aDd1T10N4L meSS@GE (OptI0N4L)";
$lang['polladditionalmessageexp'] = "dO J00 W4Nt +0 1NclUdE 4N @DD1TiON@L PO\$t @Fter TH3 POlL?";
$lang['mustspecifypolltoview'] = "j00 MuS+ 5PEciFY 4 pOLL t0 VIEW.";
$lang['pollconfirmclose'] = "aRE j00 \$UR3 J00 W@n+ T0 clOS3 +3H Ph0lLOW1N9 POLl?";
$lang['endpoll'] = "end P0LL";
$lang['nobodyvotedclosedpoll'] = "no8ody V0+3D";
$lang['votedisplayopenpoll'] = "%s 4ND %s h@Ve Vo+3d.";
$lang['votedisplayclosedpoll'] = "%s anD %s V0+3D.";
$lang['nousersvoted'] = "n0 U\$3R\$";
$lang['oneuservoted'] = "1 u\$3R";
$lang['xusersvoted'] = "%s u53R\$";
$lang['noguestsvoted'] = "n0 gUES+S";
$lang['oneguestvoted'] = "1 GU3\$T";
$lang['xguestsvoted'] = "%s GU3\$TS";
$lang['pollhasended'] = "pOLl H@\$ 3NDed";
$lang['youvotedforpolloptionsondate'] = "j00 vO+3D ph0r %s ON %s";
$lang['thisisapoll'] = "tHis is @ polL. CLIck to VI3w RESUlTS.";
$lang['editpoll'] = "eDi+ pOLL";
$lang['results'] = "r3\$uL+\$";
$lang['resultdetails'] = "r3suL+ dET@iLS";
$lang['changevote'] = "ch4nG3 vOT3";
$lang['pollshavebeendisabled'] = "poLLs H@V3 8E3N D1\$A8l3D BY TEH F0rUM OWNer.";
$lang['answertext'] = "answER t3x+";
$lang['answergroup'] = "aNSWER 9rOUP";
$lang['previewvotingform'] = "pReVIEw VO+1n9 F0RM";
$lang['viewbypolloption'] = "vi3W 8y P0LL OP+10N";
$lang['viewbyuser'] = "v1eW BY u\$3R";

// Profiles (profile.php) ----------------------------------------------

$lang['editprofile'] = "edi+ ProF1L3";
$lang['profileupdated'] = "pR0fILE upD4+3d.";
$lang['profilesnotsetup'] = "t3H F0rUM OWN3R haS N0t \$3+ up pROF1l3s.";
$lang['ignoreduser'] = "i9nOR3d USer";
$lang['lastvisit'] = "l4\$T v1\$1T";
$lang['userslocaltime'] = "u\$eR'\$ l0cAl +1m3";
$lang['userstatus'] = "s+4+u\$";
$lang['useractive'] = "onlIN3";
$lang['userinactive'] = "in@CT1V3 / OPhPHL1NE";
$lang['totaltimeinforum'] = "t0+@L +im3";
$lang['longesttimeinforum'] = "l0n93sT S3SS10N";
$lang['sendemail'] = "s3Nd EM41L";
$lang['sendpm'] = "s3nD PM";
$lang['visithomepage'] = "v1SIt HomEP@Ge";
$lang['age'] = "agE";
$lang['aged'] = "aGeD";
$lang['birthday'] = "b1r+hd@Y";
$lang['registered'] = "r3g1ST3R3D";
$lang['findpostsmadebyuser'] = "fIND pOSTs m4D3 8Y %s";
$lang['findpostsmadebyme'] = "fIND p0\$TS m4DE by m3";
$lang['profilenotavailable'] = "pR0fIl3 N0+ 4V@1L4BLE.";
$lang['userprofileempty'] = "thIS U\$3r HAS nO+ F1LL3D in +H31R ProF1L3 0R IT 1s SE+ +o pRIvA+e.";

// Registration (register.php) -----------------------------------------

$lang['newuserregistrationsarenotpermitted'] = "sORRY, N3w uS3r RegI\$+rA+1ON\$ @R3 noT alL0WED R1ght NOw. pLE@Se Ch3cK BAck L4+3R.";
$lang['usernameinvalidchars'] = "u53rnaMe c@N ONlY C0nT4IN 4-Z, 0-9, _ - CH4R4c+Ers";
$lang['usernametooshort'] = "u53Rn@Me MU\$+ 8e 4 M1NIMuM 0F 2 Ch@RACT3RS loNG";
$lang['usernametoolong'] = "u\$3rN4ME MU\$+ BE @ M4xIMUM oPH 15 CH@r4C+3rs l0n9";
$lang['usernamerequired'] = "a LO90N N@ME 15 R3quiR3D";
$lang['passwdmustnotcontainHTML'] = "p4\$SW0RD mu5T no+ C0Nt41N HTML t@g\$";
$lang['passwordinvalidchars'] = "p@\$sWOrD cAN ONlY C0NT41N 4-Z, 0-9, _ - Char4CTEr\$";
$lang['passwdtooshort'] = "p@ssW0rD MU\$T 8e 4 M1N1MUM 0PH 6 CH4R4c+Er\$ LOng";
$lang['passwdrequired'] = "a PaS\$WORD 1S R3QU1rED";
$lang['confirmationpasswdrequired'] = "a c0NF1Rm4+1ON p@SSWOrd 1S R3qu1REd";
$lang['nicknamerequired'] = "a NIcKN4Me I5 r3qU1R3d";
$lang['emailrequired'] = "an EM41L @dDR3S5 iS r3QUiR3D";
$lang['passwdsdonotmatch'] = "p@SSW0Rds do N0T m@Tch";
$lang['usernamesameaspasswd'] = "uS3rN4m3 4ND P4sSw0rD muST 83 d1PhFErEN+";
$lang['usernameexists'] = "sORry, 4 u\$3R w1+H +H@t N4M3 4LR34dy ExI\$+S";
$lang['successfullycreateduseraccount'] = "successPHULLY cr34T3d U\$3r ACC0UNT";
$lang['useraccountcreatedconfirmfailed'] = "yoUR us3R ACc0UN+ HaS b3eN crE4+ED 8ut +EH R3QU1RED CONphIRM@Ti0n 3MAiL WAS NO+ \$3nt. Pl34sE C0nt4C+ +hE PhoRUm oWneR +o R3CtIFy Thi5. 1N +H1\$ mE4N+1M3 pLEa\$3 ClICk +He c0N+1NuE 8U+tON T0 lOGIn IN.";
$lang['useraccountcreatedconfirmsuccess'] = "yOUR uS3R @cC0UNT h@5 BeeN CReA+eD bUT 8EphOR3 j00 cAN STarT P0\$TiN9 j00 Mu\$+ C0nphIRM yOUr Em4iL AdDR3\$S. Pl34S3 chECk y0UR EM4iL ph0R @ l1NK TH4+ W1Ll 4LLOW j00 +o C0NPhIRm YOuR 4dDRE\$s.";
$lang['useraccountcreated'] = "y0Ur USer @CcoUNT H@5 8E3N Cr34+3D \$UcCESspHUlLy! ClICk T3H COn+1NU3 Bu++0n 83lOW To L091N";
$lang['errorcreatinguserrecord'] = "err0r CR3@+INg UseR REC0RD";
$lang['userregistration'] = "u53R reGis+Ra+10N";
$lang['registrationinformationrequired'] = "r3G1STR@ti0N InpH0RM4+ION (R3QU1rED)";
$lang['profileinformationoptional'] = "pr0phIle InpH0RM4+1oN (oPTI0N4L)";
$lang['preferencesoptional'] = "prePHERenc3S (Op+10N4L)";
$lang['register'] = "rEG1\$tER";
$lang['rememberpasswd'] = "rem3mB3R p4\$swORD";
$lang['birthdayrequired'] = "your D4Te 0Ph B1R+H 1\$ ReqU1REd OR I5 INV@LID";
$lang['alwaysnotifymeofrepliestome'] = "nO+1Phy 0N R3Ply T0 m3";
$lang['notifyonnewprivatemessage'] = "nO+1Phy 0N NEw Pr1V4+3 M3\$s49e";
$lang['popuponnewprivatemessage'] = "p0P UP 0N N3W pR1VA+3 Me\$S@9E";
$lang['automatichighinterestonpost'] = "aU+0m@TIC h1gH 1nt3R3\$T ON PoST";
$lang['confirmpassword'] = "cONFIrM P455w0RD";
$lang['invalidemailaddressformat'] = "inv@l1D 3M@1L aDDr3\$S pH0Rm@t";
$lang['moreoptionsavailable'] = "m0r3 PROF1L3 4ND Pr3pHER3ncE 0PtI0NS @Re AV41L@BLE 0nC3 j00 R39IS+3R";
$lang['textcaptchaconfirmation'] = "cONF1Rm4T1ON";
$lang['textcaptchaexplain'] = "t0 +H3 RIGHT 15 4 +3XT-cAPtCH@ 1M49e. PL3453 TYPE +3h CODe j00 CAN \$33 1N thE im@GE 1n+O The 1NPu+ PHieLD b3L0W 1+.";
$lang['textcaptchaimgtip'] = "tH1S 1s 4 C4PTCh4-p1C+URe. I+ 1S Us3D TO PR3V3NT Au+Om@t1C re91s+RA+10n";
$lang['textcaptchamissingkey'] = "a coNPH1rM@tiON c0dE 1\$ R3QU1rED.";
$lang['textcaptchaverificationfailed'] = "t3x+-CAPtCH@ V3r1f1C@+10N COD3 WA\$ 1NcorREC+. PLeASE RE-EN+3r 1+.";
$lang['forumrules'] = "f0rUM ruLes";
$lang['forumrulesnotification'] = "iN 0rDer to Pr0CE3D, J00 Mu\$+ 49reE WITh TH3 foLloW1Ng RulES";
$lang['forumrulescheckbox'] = "i H@Ve Re@D, 4nD 4gR3E +O 4B1D3 by TH3 Ph0rUM rULeS.";
$lang['youmustagreetotheforumrules'] = "j00 MuST a9Ree t0 +H3 phoRUM rUL3S BEphor3 J00 C4n C0NTINu3.";

// Recent visitors list  (visitor_log.php) -----------------------------

$lang['member'] = "mem8er";
$lang['searchforusernotinlist'] = "sE4rCH pH0R A us3R nO+ IN L1S+";
$lang['yoursearchdidnotreturnanymatches'] = "y0uR \$3@rCh d1d No+ r3+UrN 4nY mA+CH3\$. TrY siMpL1FY1N9 Y0UR \$34RCh P4r4ME+3RS 4ND +RY @g@In.";
$lang['hiderowswithemptyornullvalues'] = "hiDe r0WS Wi+H 3mp+Y OR nuLl V@lue5 In \$ElEc+3d coLUMNS";
$lang['showregisteredusersonly'] = "sh0w r3GI\$tERed US3RS 0NLY (h1D3 GueSTS)";

// Relationships (user_rel.php) ----------------------------------------

$lang['relationships'] = "rEL@tI0NShIPS";
$lang['userrelationship'] = "us3R REl@TIon\$h1p";
$lang['userrelationships'] = "usER R3L4t1oN\$h1P\$";
$lang['failedtoremoveselectedrelationships'] = "f41LED +O r3m0V3 \$3L3C+3D R3L4T10NSH1P";
$lang['friends'] = "fr13nD\$";
$lang['ignoredcompletely'] = "iGn0r3D C0MPLEteLy";
$lang['relationship'] = "r3l4tI0n5H1P";
$lang['restorenickname'] = "r3\$t0RE US3r'\$ n1ckN4ME";
$lang['friend_exp'] = "uS3R'5 POS+S M@Rked WITh A &quot;PHriEND&quot; 1C0n.";
$lang['normal_exp'] = "user'S P05+S @PpeAR @\$ N0rM4L.";
$lang['ignore_exp'] = "u\$er's P05+S 4R3 HiDD3N.";
$lang['ignore_completely_exp'] = "thr34ds @ND Po\$ts TO 0r PHR0M U\$er WIlL 4PP3AR delE+3D.";
$lang['display'] = "dISpl4Y";
$lang['displaysig_exp'] = "user'S 5iGN4+ur3 IS disPL@Y3D On +h31R P0\$T\$.";
$lang['hidesig_exp'] = "u\$3r's sIGN@+UR3 1\$ h1dDen ON +h31R PO\$TS.";
$lang['cannotignoremod'] = "j00 C@NN0+ 1gN0Re TH1\$ UsEr, 4s +H3Y 4RE 4 MOD3R4+OR.";
$lang['previewsignature'] = "pREView s19N4tURE";

// Search (search.php) -------------------------------------------------

$lang['searchresults'] = "se4rCH ResUL+5";
$lang['usernamenotfound'] = "tHE U\$erN4M3 j00 SPeC1f1ED 1n TH3 +O 0r FROm F13LD w@S No+ F0UND.";
$lang['notexttosearchfor'] = "onE Or @Ll 0PH YOuR \$34RcH kEYw0rD\$ WerE INv@L1D. SE4rCH k3YW0Rds muST 8e N0 \$H0R+er TH@N %d CH@R4C+eR\$, n0 LOnG3R +H@n %d cH@R4CtER\$ 4Nd MUS+ N0+ @pp3AR 1n TeH %s";
$lang['keywordscontainingerrors'] = "k3yw0RDS con+@InING eRroRS: %s";
$lang['mysqlstopwordlist'] = "my5qL \$+OPW0rD l1sT";
$lang['foundzeromatches'] = "foUND: 0 Ma+Ch3s";
$lang['found'] = "f0unD";
$lang['matches'] = "m@TCH3s";
$lang['prevpage'] = "pR3vI0US P@gE";
$lang['findmore'] = "fIND Mor3";
$lang['searchmessages'] = "s34RcH MESS4G3s";
$lang['searchdiscussions'] = "s34rCH d1sCu\$s1ON\$";
$lang['find'] = "find";
$lang['additionalcriteria'] = "addI+10n4l CrI+3RI4";
$lang['searchbyuser'] = "seARCH bY us3r (0P+1on4L)";
$lang['folderbrackets_s'] = "f0lD3R(S)";
$lang['postedfrom'] = "poS+Ed PhrOm";
$lang['postedto'] = "p0st3D tO";
$lang['today'] = "t0d@Y";
$lang['yesterday'] = "y3\$TERD4Y";
$lang['daybeforeyesterday'] = "d4y 83PHORe YeSTERd4y";
$lang['weekago'] = "%s w33K 4GO";
$lang['weeksago'] = "%s WE3K\$ 490";
$lang['monthago'] = "%s m0NTH 490";
$lang['monthsago'] = "%s moNThS 490";
$lang['yearago'] = "%s Ye4R 49o";
$lang['beginningoftime'] = "bE91nNINg 0f TIM3";
$lang['now'] = "nOW";
$lang['lastpostdate'] = "l@5+ P0\$+ d4Te";
$lang['numberofreplies'] = "numB3R oPh REpL13s";
$lang['foldername'] = "f0lD3R N4M3";
$lang['authorname'] = "au+H0R n4m3";
$lang['decendingorder'] = "n3wE5T Ph1R\$T";
$lang['ascendingorder'] = "oLDE\$t phIR\$T";
$lang['keywords'] = "kEYW0RDs";
$lang['sortby'] = "s0r+ By";
$lang['sortdir'] = "s0r+ D1r";
$lang['sortresults'] = "s0rT reSULTS";
$lang['groupbythread'] = "gRoUP by +hRE4d";
$lang['postsfromuser'] = "p0STS From U\$3R";
$lang['poststouser'] = "pO5+S TO u\$er";
$lang['poststoandfromuser'] = "p0sT\$ T0 anD PhR0M uS3R";
$lang['searchfrequencyerror'] = "j00 cAN only \$E4Rch 0nc3 3VErY %s S3C0Nd5. Plea\$e +Ry 4GaIN L4+Er.";
$lang['searchsuccessfullycompleted'] = "sE4rCH 5UcC3\$5pHuLLy COmpLe+ED. %s";
$lang['clickheretoviewresults'] = "clicK hEr3 TO vI3W RE5ULTs.";

// Search Popup (search_popup.php) -------------------------------------

$lang['select'] = "s3l3CT";
$lang['searchforthread'] = "se@rcH f0R +Hr3@d";
$lang['mustspecifytypeofsearch'] = "j00 muSt SPecifY tyPE OF Se4Rch t0 peRPh0Rm";
$lang['unkownsearchtypespecified'] = "uNKnoWN \$3@rch +ypE Sp3CIPHI3d";
$lang['mustentersomethingtosearchfor'] = "j00 MUs+ 3nT3r \$0MetH1N9 To Se@rcH Ph0R";

// Start page (start_left.php) -----------------------------------------

$lang['recentthreads'] = "r3Cen+ THreadS";
$lang['startreading'] = "s+@RT rE4D1N9";
$lang['threadoptions'] = "thRE4D 0Pt1ONS";
$lang['editthreadoptions'] = "eD1T thR34D OPT10Ns";
$lang['morevisitors'] = "m0re Visi+0rS";
$lang['forthcomingbirthdays'] = "f0RTHc0m1n9 BIR+HdaY\$";

// Start page (start_main.php) -----------------------------------------

$lang['editstartpage_help'] = "j00 cAn ED1T TH1S pAGE FROM TEh @dMiN IN+ERf4cE";

// Thread navigation (thread_list.php) ---------------------------------

$lang['newdiscussion'] = "n3w D1SCUSS10N";
$lang['createpoll'] = "crE4T3 p0ll";
$lang['search'] = "s3@rcH";
$lang['searchagain'] = "s34rCH AG41N";
$lang['alldiscussions'] = "all d1\$CU\$s10Ns";
$lang['unreaddiscussions'] = "uNrE4D D1sCU\$S1oNS";
$lang['unreadtome'] = "unr34d &quot;tO: m3&quot;";
$lang['todaysdiscussions'] = "t0d@y'\$ d1ScuS\$iON\$";
$lang['2daysback'] = "2 dAYS b@Ck";
$lang['7daysback'] = "7 D4Y\$ 84CK";
$lang['highinterest'] = "higH 1N+3Res+";
$lang['unreadhighinterest'] = "uNR34D H1Gh 1NT3RE\$T";
$lang['iverecentlyseen'] = "i'Ve r3C3NTly SEEN";
$lang['iveignored'] = "i'vE 1gNOr3d";
$lang['byignoredusers'] = "by 19NOrED Us3R\$";
$lang['ivesubscribedto'] = "i'vE SUb\$criB3d +0";
$lang['startedbyfriend'] = "s+4R+3d bY FRiEND";
$lang['unreadstartedbyfriend'] = "uNR3@D S+D BY fRienD";
$lang['startedbyme'] = "s+4RTeD By M3";
$lang['unreadtoday'] = "uNre@D +0d4Y";
$lang['deletedthreads'] = "d3l3+3D +hr3ADS";
$lang['goexcmark'] = "go!";
$lang['folderinterest'] = "f0LD3r IN+3r3ST";
$lang['postnew'] = "p0\$T nEW";
$lang['currentthread'] = "cUrR3NT THRE@d";
$lang['highinterest'] = "hI9H 1n+3rEST";
$lang['markasread'] = "m4RK A\$ rE4d";
$lang['next50discussions'] = "n3xt 50 D1sCu5s1ons";
$lang['visiblediscussions'] = "vi\$IblE D1sCU\$S1oNS";
$lang['selectedfolder'] = "s3L3C+3D FOlD3R";
$lang['navigate'] = "n4V1G4T3";
$lang['couldnotretrievefolderinformation'] = "therE 4RE N0 PHOlD3R\$ 4V41L4BLe.";
$lang['nomessagesinthiscategory'] = "nO Mes\$4GE\$ 1N thi\$ C@TEG0RY. pl34S3 \$3L3C+ 4n0+H3R, 0R %s pHOR 4lL tHr3@D\$";
$lang['clickhere'] = "cL1cK h3rE";
$lang['prev50threads'] = "pREvIOU5 50 tHR34d\$";
$lang['next50threads'] = "nEXT 50 +hR34dS";
$lang['nextxthreads'] = "neX+ %s tHrE@d\$";
$lang['threadstartedbytooltip'] = "tHR3@D #%s \$+@RT3D by %s. V1eWEd %s";
$lang['threadviewedonetime'] = "1 TIme";
$lang['threadviewedtimes'] = "%d +IM3\$";
$lang['unreadthread'] = "uNR34D +HR3AD";
$lang['readthread'] = "r34D +hre4d";
$lang['unreadmessages'] = "uNr3@D meS5@93\$";
$lang['subscribed'] = "suB\$cRIB3D";
$lang['ignorethisfolder'] = "iGn0RE th1s pH0LDEr";
$lang['stopignoringthisfolder'] = "st0p IGN0riN9 +hiS Ph0lDer";
$lang['stickythreads'] = "s+iCKy THr3aDS";
$lang['mostunreadposts'] = "mosT uNR3@D P0STS";
$lang['onenew'] = "%d n3W";
$lang['manynew'] = "%d n3w";
$lang['onenewoflength'] = "%d n3W OF %d";
$lang['manynewoflength'] = "%d n3W 0F %d";
$lang['ignorefolderconfirm'] = "are J00 5UR3 J00 W4NT +O i9NORe THI\$ PhoLdER?";
$lang['unignorefolderconfirm'] = "aR3 J00 SURe J00 w4n+ +O S+0p 1GnORiNG +hI\$ fOlDEr?";
$lang['confirmmarkasread'] = "are J00 SUr3 J00 W@Nt To m@RK +3h \$3LeC+3d THre4d\$ AS rEAD?";
$lang['successfullymarkreadselectedthreads'] = "sUcc3sSPHulLy M@RKEd 5ELeC+Ed +hR34DS @S rEAD";
$lang['failedtomarkselectedthreadsasread'] = "f4IL3d +0 M4RK 53L3c+3D +HR3@D\$ 4\$ Re4D";
$lang['gotofirstpostinthread'] = "g0 +O pHiR\$+ POS+ 1N +HrE4D";
$lang['gotolastpostinthread'] = "gO +o l@5+ P0\$T 1n THr34D";
$lang['viewmessagesinthisfolderonly'] = "vi3w M3\$s@Ge\$ 1N tHi\$ Ph0LDeR 0NLy";
$lang['shownext50threads'] = "shoW NEx+ 50 thR34DS";
$lang['showprev50threads'] = "sh0w PrEV1oU\$ 50 +HrE4dS";
$lang['createnewdiscussioninthisfolder'] = "cRe4TE NeW DI\$Cu\$S1On IN THIS pH0LD3r";
$lang['nomessages'] = "n0 M35s49ES";

// HTML toolbar (htmltools.inc.php) ------------------------------------
$lang['bold'] = "bOlD";
$lang['italic'] = "i+4lIc";
$lang['underline'] = "uNDerl1nE";
$lang['strikethrough'] = "sTRIK3THr0u9H";
$lang['superscript'] = "sUPERSCR1pt";
$lang['subscript'] = "sUBsCR1Pt";
$lang['leftalign'] = "l3phT-@L1GN";
$lang['center'] = "centER";
$lang['rightalign'] = "riGH+-4lI9N";
$lang['numberedlist'] = "nUMBeR3D L1sT";
$lang['list'] = "l1sT";
$lang['indenttext'] = "iNDEN+ TEX+";
$lang['code'] = "cod3";
$lang['quote'] = "qUOt3";
$lang['spoiler'] = "sPo1LEr";
$lang['horizontalrule'] = "h0r1Z0Nt4L rUl3";
$lang['image'] = "iM49E";
$lang['hyperlink'] = "hyp3rL1NK";
$lang['noemoticons'] = "d1\$@8LE 3MO+1CONS";
$lang['fontface'] = "fOn+ FAc3";
$lang['size'] = "s1Z3";
$lang['colour'] = "c0L0uR";
$lang['red'] = "r3d";
$lang['orange'] = "or4nGE";
$lang['yellow'] = "yelL0w";
$lang['green'] = "grEEn";
$lang['blue'] = "blu3";
$lang['indigo'] = "iNDiG0";
$lang['violet'] = "v10lE+";
$lang['white'] = "wHI+3";
$lang['black'] = "bl@CK";
$lang['grey'] = "greY";
$lang['pink'] = "pINK";
$lang['lightgreen'] = "l19hT 9REen";
$lang['lightblue'] = "lIGHt 8LU3";

// Forum Stats (messages.inc.php - messages_forum_stats()) -------------

$lang['forumstats'] = "foruM \$T@+s";
$lang['usersactiveinthepasttimeperiod'] = "%s 4CTiVE iN +He P4\$T %s. %s";

$lang['numactiveguests'] = "<b>%s</b> 9uES+S";
$lang['oneactiveguest'] = "<b>1</b> Gu35t";
$lang['numactivemembers'] = "<b>%s</b> m3M83R\$";
$lang['oneactivemember'] = "<b>1</b> MEM83R";
$lang['numactiveanonymousmembers'] = "<b>%s</b> 4n0NYMouS MEmB3rs";
$lang['oneactiveanonymousmember'] = "<b>1</b> @nonyMOU\$ M3M8ER";

$lang['numthreadscreated'] = "<b>%s</b> +HR3ads";
$lang['onethreadcreated'] = "<b>1</b> +hREaD";
$lang['numpostscreated'] = "<b>%s</b> p0STS";
$lang['onepostcreated'] = "<b>1</b> P0St";

$lang['younormal'] = "j00";
$lang['youinvisible'] = "j00 (1NVisi8L3)";
$lang['viewcompletelist'] = "vI3w c0MPle+3 lIS+";
$lang['ourmembershavemadeatotalofnumthreadsandnumposts'] = "our m3Mb3RS H4v3 M@dE 4 +0T4L 0F %s 4nd %s.";
$lang['longestthreadisthreadnamewithnumposts'] = "l0NG3sT +hR3ad 1s <b>%s</b> wi+H %s.";
$lang['therehavebeenxpostsmadeinthelastsixtyminutes'] = "thERE haV3 B3EN <b>%s</b> POS+S M4D3 IN +3H L@5t 60 mInUTES.";
$lang['therehasbeenonepostmadeinthelastsxityminutes'] = "theRE H@s b33N <b>1</b> p0\$T M4de In +3H l@St 60 m1nU+35.";
$lang['mostpostsevermadeinasinglesixtyminuteperiodwasnumposts'] = "m0\$t P0S+S 3V3R m@D3 1n 4 S1N9L3 60 m1nUT3 P3rI0D I\$ <b>%s</b> oN %s.";
$lang['wehavenumregisteredmembersandthenewestmemberismembername'] = "w3 H4V3 <b>%s</b> rE9IS+3rED M3MB3R\$ 4nD tEH N3we\$T m3M83R IS <b>%s</b>.";
$lang['wehavenumregisteredmember'] = "w3 HAvE %s R3GisTEr3d MeMBer\$.";
$lang['wehaveoneregisteredmember'] = "w3 H4VE ON3 Re91s+3REd MEm83R.";
$lang['mostuserseveronlinewasnumondate'] = "mo\$+ u\$3RS 3VEr OnLIne w4s <b>%s</b> 0n %s.";
$lang['statsdisplaychanged'] = "s+4tS dI5pL@y cH4NgED";

// Thread Options (thread_options.php) ---------------------------------

$lang['updatessavedsuccessfully'] = "upd4T3s 54V3D SuCC3SSPhULlY";
$lang['useroptions'] = "useR OPt10nS";
$lang['markedasread'] = "mark3D @\$ R34d";
$lang['postsoutof'] = "p0s+S 0UT 0F";
$lang['interest'] = "iN+3RES+";
$lang['closedforposting'] = "clos3D F0r POsTInG";
$lang['locktitleandfolder'] = "lOCK ti+lE 4nD PHOLD3r";
$lang['deletepostsinthreadbyuser'] = "d3l3t3 P0S+S 1N +hr3aD 8Y us3R";
$lang['deletethread'] = "d3l3tE THRe4d";
$lang['permenantlydelete'] = "p3RM4N3N+Ly D3L3tE";
$lang['movetodeleteditems'] = "m0VE +o D3LE+ed THRE4D5";
$lang['undeletethread'] = "uNd3lETE thrE4D";
$lang['threaddeletedpermenantly'] = "thrE4d dele+3D PERM@N3ntLY. c@NNOT uNdeLE+3.";
$lang['markasunread'] = "m@RK 4S UNr34D";
$lang['makethreadsticky'] = "m4k3 +Hre4D \$T1CKY";
$lang['threareadstatusupdated'] = "thre4d R3@D \$t@+U\$ UPd4+3D Succ3SSPhULLY";
$lang['interestupdated'] = "thr34D 1NtEREs+ st@+u\$ uPD@tEd \$UCcESSfuLlY";
$lang['failedtoupdatethreadreadstatus'] = "faILED +O UpD@t3 thR3@D R34D \$t4+US";
$lang['failedtoupdatethreadinterest'] = "f41l3D +o UPdA+E +hrEAd InT3RES+";
$lang['failedtorenamethread'] = "f41LeD +O ReN4M3 ThR3@d";
$lang['failedtomovethread'] = "f4iLEd To m0v3 ThrE4d +0 sPeCIF13d PHOLdER";
$lang['failedtoupdatethreadstickystatus'] = "f41L3D T0 upDA+3 Thr3aD sTICky ST4+US";
$lang['failedtoupdatethreadclosedstatus'] = "f41l3D to uPD4+3 tHR3@D Cl0\$3D \$t4+US";
$lang['failedtoupdatethreadlockstatus'] = "f41lEd +0 Upd4+3 tHR3@d L0Ck s+@Tus";
$lang['failedtodeletepostsbyuser'] = "f4iL3D T0 D3LE+e PO\$T\$ BY \$eL3CT3D U\$3R";
$lang['failedtodeletethread'] = "f@1L3D +0 d3l3+E +hRe4D.";
$lang['failedtoundeletethread'] = "f@iLEd +0 Un-DEle+3 +Hre4d";

// Dictionary (dictionary.php) -----------------------------------------

$lang['dictionary'] = "dicTI0N4RY";
$lang['spellcheck'] = "sPELl CHEcK";
$lang['notindictionary'] = "n0+ 1N DIctI0N@rY";
$lang['changeto'] = "ch@N9e to";
$lang['restartspellcheck'] = "r3sT4R+";
$lang['cancelchanges'] = "c4nC3L cH4NGes";
$lang['initialisingdotdotdot'] = "in1+14L1\$INg...";
$lang['spellcheckcomplete'] = "speLL cHECK i5 COMPl3te. +0 REST4R+ SP3LL cH3CK cliCK R3s+ArT 8u++ON 83LOW.";
$lang['spellcheck'] = "sp3LL CHEck";
$lang['noformobj'] = "no PhorM ObJ3C+ SP3C1PH13D Ph0r r3TUrN +3XT";
$lang['bodytext'] = "b0dY +3xT";
$lang['ignore'] = "i9N0R3";
$lang['ignoreall'] = "ign0r3 @Ll";
$lang['change'] = "cH4n93";
$lang['changeall'] = "cH@Ng3 4LL";
$lang['add'] = "aDD";
$lang['suggest'] = "sU993ST";
$lang['nosuggestions'] = "(NO SUG9E\$+10NS)";
$lang['cancel'] = "cancEL";
$lang['dictionarynotinstalled'] = "no dic+IONaRY h4\$ bEEN IN5+@LLED. PL3@se CON+ACt ThE f0RUm 0WN3R TO REm3DY ThI\$.";

// Permissions keys ----------------------------------------------------

$lang['postreadingallowed'] = "p0sT R34dIN9 4LLOWEd";
$lang['postcreationallowed'] = "p0ST cR3@TI0N @LL0Wed";
$lang['threadcreationallowed'] = "thr34D CR3A+1oN @LL0WED";
$lang['posteditingallowed'] = "pO5+ 3dIT1n9 4LLOW3D";
$lang['postdeletionallowed'] = "pO\$+ d3lE+10n 4lL0W3D";
$lang['attachmentsallowed'] = "aTT@ChmEN+s 4LLOw3D";
$lang['htmlpostingallowed'] = "h+ML postIn9 4LL0w3d";
$lang['signatureallowed'] = "s1gnA+Ur3 4LLOw3d";
$lang['guestaccessallowed'] = "gueST 4CCE\$S @lL0WED";
$lang['postapprovalrequired'] = "p05+ 4PPr0v4L REQU1R3D";

// RSS feeds gubbins

$lang['rssfeed'] = "r5S F33D";
$lang['every30mins'] = "ev3ry 30 M1NuTe\$";
$lang['onceanhour'] = "onC3 An H0UR";
$lang['every6hours'] = "eVeRY 6 H0UR\$";
$lang['every12hours'] = "ev3rY 12 hoURS";
$lang['onceaday'] = "oNcE @ D4Y";
$lang['onceaweek'] = "onC3 4 WEek";
$lang['rssfeeds'] = "rsS PheeD\$";
$lang['feedname'] = "fE3D naME";
$lang['feedfoldername'] = "f3ed pHOLdER n@mE";
$lang['feedlocation'] = "f33D LOc4+1ON";
$lang['threadtitleprefix'] = "thr3AD +1TL3 Pr3PHiX";
$lang['feednameandlocation'] = "fE3D naMe @ND lOC4+10n";
$lang['feedsettings'] = "f3ED S3T+iN95";
$lang['updatefrequency'] = "upD4+3 Fr3QUeNCy";
$lang['rssclicktoreadarticle'] = "cLIcK hEre +0 read +H1S 4R+1cLE";
$lang['addnewfeed'] = "aDD N3W f33d";
$lang['editfeed'] = "eDI+ F3ED";
$lang['feeduseraccount'] = "fEEd uS3R Acc0uNT";
$lang['noexistingfeeds'] = "nO 3xIstINg rsS FE3DS F0UND. +0 @Dd 4 Fe3D cLIck tHe '4DD NEw' BU++on 83l0W";
$lang['rssfeedhelp'] = "h3re J00 c4n S3+UP sOME rsS FeeDS fOr AUtoMaTIc PROpag4TIOn 1NTO y0UR f0ruM. TH3 1+3M\$ PHr0M +he RS\$ PH33d\$ J00 adD W1LL 83 CR34+3d 4\$ +hREads WH1cH U5eRS C4N r3pLY To @\$ if +H3Y WEre N0RM@L Po\$+S. THE R55 FEED Must B3 4CCE\$SIble V14 H++P OR 1+ will N0+ worK.";
$lang['mustspecifyrssfeedname'] = "muSt sP3c1fY R\$S F3eD N@M3";
$lang['mustspecifyrssfeeduseraccount'] = "mU\$+ sPEcIPhY rSS ph33D us3R @cc0UNT";
$lang['mustspecifyrssfeedfolder'] = "musT spEcIFy r\$S f3ED phoLD3R";
$lang['mustspecifyrssfeedurl'] = "mUST \$PEC1FY r\$S PhE3D UrL";
$lang['mustspecifyrssfeedupdatefrequency'] = "mU\$T SP3cIpHY R\$5 FE3D Upd4+3 frequeNCy";
$lang['unknownrssuseraccount'] = "unKN0wn RSS us3R @cC0uNt";
$lang['rssfeedsupportshttpurlsonly'] = "r5s F33D SUPPOr+s h+TP URLS 0nLY. \$3CURE pHEEDS (H++ps://) 4RE n0+ SUPP0RTEd.";
$lang['rssfeedurlformatinvalid'] = "r5\$ f3eD URl F0RM4+ 1S iNVAliD. URL MUS+ 1NClUD3 \$CH3m3 (E.G. hTTp://) @ND 4 H0\$+N4m3 (3.9. www.HO\$Tn@ME.C0M).";
$lang['rssfeeduserauthentication'] = "rS\$ pH3ED DOES N0t SUPpoR+ HT+p USEr 4u+H3N+Ic@+10N";
$lang['successfullyremovedselectedfeeds'] = "sucCE\$spHULlY rEm0V3D 5ELeCTeD Ph3eDS";
$lang['successfullyaddedfeed'] = "sucCE\$spHullY adDed N3W fE3D";
$lang['successfullyeditedfeed'] = "sucCe5sFUlLy 3D1TEd FEeD";
$lang['failedtoremovefeeds'] = "f4il3D TO r3M0VE 5oME 0R 4lL OF +h3 S3L3CTED PH33dS";
$lang['failedtoaddnewrssfeed'] = "f41L3D +O 4DD n3W Rss fE3D";
$lang['failedtoupdaterssfeed'] = "f4iLED +0 UPdAt3 RSs F33D";
$lang['rssstreamworkingcorrectly'] = "rss S+re4M aPpEAr\$ +0 83 w0Rk1NG cOrReCTLy";
$lang['rssstreamnotworkingcorrectly'] = "r5s STR3@M w@\$ EMpTY 0r COulD n0+ 83 F0uNd";
$lang['invalidfeedidorfeednotfound'] = "iNv4L1d pH33D 1D 0R PH3ED N0T f0uND";

// PM Export Options

$lang['pmexportastype'] = "eXp0rT 4\$ +Yp3";
$lang['pmexporthtml'] = "hTML";
$lang['pmexportxml'] = "xml";
$lang['pmexportplaintext'] = "pl41N +3X+";
$lang['pmexportmessagesas'] = "expoR+ mESS493\$ 4s";
$lang['pmexportonefileforallmessages'] = "oN3 PH1LE fOR 4LL mesS49E\$";
$lang['pmexportonefilepermessage'] = "one Ph1l3 PER M3\$549E";
$lang['pmexportattachments'] = "exP0RT 4+T4cHM3n+S";
$lang['pmexportincludestyle'] = "inclUD3 FOrUM 5+ylE \$H3E+";
$lang['pmexportwordfilter'] = "aPPLy WOrD PhILT3r +0 MesS49E\$";

// Thread merge / split options

$lang['threadhasbeensplit'] = "thrE4d H@S 8E3N 5Pli+";
$lang['threadhasbeenmerged'] = "thRe4d H4S 8E3N M3RGEd";
$lang['mergesplitthread'] = "m3R9e / sPL1T +Hr3@D";
$lang['mergewiththreadid'] = "m3rG3 Wi+h THr34D ID:";
$lang['postsinthisthreadatstart'] = "pOS+S iN +H1S +hR34D 4t \$+@Rt";
$lang['postsinthisthreadatend'] = "p0st\$ In +h1\$ +hRe4D 4+ 3ND";
$lang['reorderpostsintodateorder'] = "r3-oRd3R P0\$+s 1N+0 D4TE oRDeR";
$lang['splitthreadatpost'] = "sPl1T +hR3@D At Po\$T:";
$lang['selectedpostsandrepliesonly'] = "seL3CTED p0\$T 4ND REPl13s 0NlY";
$lang['selectedandallfollowingposts'] = "s3LEC+3D 4Nd 4LL pH0LL0W1NG PO\$+\$";

$lang['threadmovedhere'] = "hER3";

$lang['thisthreadhasmoved'] = "<b>thR3@DS MErgeD:</b> +hI\$ +HREad H@5 m0V3D %s";
$lang['thisthreadwasmergedfrom'] = "<b>thRE@DS MER9ED:</b> THI\$ tHR3@d Was M3RGED PHROM %s";
$lang['somepostsinthisthreadhavebeenmoved'] = "<b>tHRe@D \$PLI+:</b> \$OMe POSts in tHiS +HR3aD H4VE 8E3N m0v3D %s";
$lang['somepostsinthisthreadweremovedfrom'] = "<b>tHre@D \$PLI+:</b> \$0M3 po\$t5 iN THi\$ tHR3@d W3RE M0VEd PhROM %s";

$lang['thisposthasbeenmoved'] = "<b>thREAd \$pLI+:</b> +HI\$ P0sT H4S BEEN m0VEd %s";

$lang['invalidfunctionarguments'] = "iNV4L1d PhuNCtION @rGUmEN+s";
$lang['couldnotretrieveforumdata'] = "c0ULD NOT r3tRIev3 PH0RUM D4+@";
$lang['cannotmergepolls'] = "on3 OR mORE THR34DS Is 4 POLL. j00 C@NNO+ MERge p0LL\$";
$lang['couldnotretrievethreaddatamerge'] = "c0ULd No+ r3TR1EV3 THr34D D4Ta Fr0m On3 OR MORE +Hr34dS";
$lang['couldnotretrievethreaddatasplit'] = "cOULd nOT Re+ri3V3 +HR34D da+A PHrOM \$oURcE +HR34D";
$lang['couldnotretrievepostdatamerge'] = "c0uld n0T r3+RieVe POST d4t4 FROM oNE 0r MORe +hr3@D\$";
$lang['couldnotretrievepostdatasplit'] = "cOuLD NOT R3TriEVe P0ST D4+A PHroM sOURCE tHR3@D";
$lang['failedtocreatenewthreadformerge'] = "f4IleD TO CrEAT3 N3W thRE4D Ph0r M3RG3";
$lang['failedtocreatenewthreadforsplit'] = "f@iL3d TO CRea+E N3w +hRE4D FOr \$Pli+";

// Thread subscriptions

$lang['threadsubscriptions'] = "thre4d SU8sCRipTI0NS";
$lang['couldnotupdateinterestonthread'] = "could N0T uPDa+3 In+3R3ST 0N +HRe4D '%s'";
$lang['threadinterestsupdatedsuccessfully'] = "thrE4D 1N+3Re5+S UpD@t3D SUcc3\$5PHuLLY";
$lang['nothreadsubscriptions'] = "j00 4RE n0T sU8SCr18ED +0 @NY +HR34DS.";
$lang['resetselected'] = "rES3+ SEl3C+Ed";
$lang['allthreadtypes'] = "aLL +hR3@D +yPE5";
$lang['ignoredthreads'] = "iGN0ReD Thr34D5";
$lang['highinterestthreads'] = "h19H 1n+3REST tHREADS";
$lang['subscribedthreads'] = "sU8sCR1B3D THRE4Ds";
$lang['currentinterest'] = "curR3N+ 1NTeR35T";

// Browseable user profiles

$lang['youcanonlyaddthreecolumns'] = "j00 C4N 0nLY 4DD 3 C0LUMns. To 4DD 4 N3W cOLUmN Cl0\$e 4N 3XIStING oN3";
$lang['columnalreadyadded'] = "j00 HaVE 4LR34dy 4DDeD +H1\$ C0LUmn. 1Ph J00 w@N+ TO rEMoVE IT cLiCK It\$ cl0s3 BU+TON";

?>
