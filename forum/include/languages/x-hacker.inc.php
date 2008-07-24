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

/* $Id: x-hacker.inc.php,v 1.287 2008-07-24 12:43:24 decoyduck Exp $ */

// British English language file

// Language character set and text direction options -------------------

$lang['_isocode'] = "en-gb";
$lang['_textdir'] = "ltr";

// Months --------------------------------------------------------------

$lang['month'][1]  = "j4NU4Ry";
$lang['month'][2]  = "f3Bru@RY";
$lang['month'][3]  = "m4RCh";
$lang['month'][4]  = "apRiL";
$lang['month'][5]  = "m4Y";
$lang['month'][6]  = "jUN3";
$lang['month'][7]  = "julY";
$lang['month'][8]  = "aU9uS+";
$lang['month'][9]  = "sEPT3M83r";
$lang['month'][10] = "oct083r";
$lang['month'][11] = "nOv3m83R";
$lang['month'][12] = "dec3mB3r";

$lang['month_short'][1]  = "j@n";
$lang['month_short'][2]  = "fEb";
$lang['month_short'][3]  = "m4r";
$lang['month_short'][4]  = "aPr";
$lang['month_short'][5]  = "m@y";
$lang['month_short'][6]  = "jun";
$lang['month_short'][7]  = "jul";
$lang['month_short'][8]  = "au9";
$lang['month_short'][9]  = "sep";
$lang['month_short'][10] = "oCT";
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

$lang['date_periods']['year']   = "%s Ye4R";
$lang['date_periods']['month']  = "%s mONth";
$lang['date_periods']['week']   = "%s w33K";
$lang['date_periods']['day']    = "%s d4y";
$lang['date_periods']['hour']   = "%s H0UR";
$lang['date_periods']['minute'] = "%s m1NU+3";
$lang['date_periods']['second'] = "%s s3C0nD";

// As above but plurals (2 years vs. 1 year, etc.)

$lang['date_periods_plural']['year']   = "%s y34RS";
$lang['date_periods_plural']['month']  = "%s moN+HS";
$lang['date_periods_plural']['week']   = "%s W3eK\$";
$lang['date_periods_plural']['day']    = "%s D4yS";
$lang['date_periods_plural']['hour']   = "%s h0URS";
$lang['date_periods_plural']['minute'] = "%s M1Nu+eS";
$lang['date_periods_plural']['second'] = "%s sECONDS";

// Short hand periods (example: 1y, 2m, 3w, 4d, 5hr, 6min, 7sec)

$lang['date_periods_short']['year']   = "%sY";    // 1y
$lang['date_periods_short']['month']  = "%sm";    // 2m
$lang['date_periods_short']['week']   = "%sw";    // 3w
$lang['date_periods_short']['day']    = "%sd";    // 4d
$lang['date_periods_short']['hour']   = "%sHr";   // 5hr
$lang['date_periods_short']['minute'] = "%sM1N";  // 6min
$lang['date_periods_short']['second'] = "%sS3C";  // 7sec

// Common words --------------------------------------------------------

$lang['percent'] = "p3RC3NT";
$lang['average'] = "aVERAg3";
$lang['approve'] = "aPpR0V3";
$lang['banned'] = "b4nn3d";
$lang['locked'] = "lOCkED";
$lang['add'] = "aDd";
$lang['advanced'] = "adv@NC3D";
$lang['active'] = "ac+1vE";
$lang['style'] = "s+yL3";
$lang['go'] = "go";
$lang['folder'] = "fOld3r";
$lang['ignoredfolder'] = "ign0r3d FOld3R";
$lang['subscribedfolder'] = "sub5CR1BED F0LD3R";
$lang['folders'] = "f0ldER\$";
$lang['thread'] = "thre4D";
$lang['threads'] = "tHR3ADS";
$lang['threadlist'] = "tHrE4D Lis+";
$lang['message'] = "mE\$s49E";
$lang['from'] = "frOm";
$lang['to'] = "to";
$lang['all_caps'] = "aLL";
$lang['of'] = "oF";
$lang['reply'] = "rEplY";
$lang['forward'] = "forWARd";
$lang['replyall'] = "repLY +O @Ll";
$lang['quickreply'] = "qUICk rEPlY";
$lang['quickreplyall'] = "quiCK ReplY tO @ll";
$lang['pm_reply'] = "rEpLY 4\$ pm";
$lang['delete'] = "d3L3T3";
$lang['deleted'] = "d3l3+3d";
$lang['edit'] = "eD1+";
$lang['privileges'] = "pRiVil39e\$";
$lang['ignore'] = "i9n0R3";
$lang['normal'] = "n0rM@l";
$lang['interested'] = "iNteREsTED";
$lang['subscribe'] = "sUbscRIB3";
$lang['apply'] = "aPpLY";
$lang['download'] = "downL0@D";
$lang['save'] = "s4ve";
$lang['update'] = "uPd4+E";
$lang['cancel'] = "c4nC3l";
$lang['continue'] = "c0n+1nUE";
$lang['attachment'] = "att4cHM3NT";
$lang['attachments'] = "a++@CHMenTS";
$lang['imageattachments'] = "iM4GE 4TT4CHmENT\$";
$lang['filename'] = "fILENAM3";
$lang['dimensions'] = "dIMEn\$1ons";
$lang['downloadedxtimes'] = "downL04DED: %d +1M3\$";
$lang['downloadedonetime'] = "d0wnL04deD: 1 +1M3";
$lang['size'] = "siz3";
$lang['viewmessage'] = "v13w m3sS493";
$lang['deletethumbnails'] = "dEl3+3 THUM8NAIl\$";
$lang['logon'] = "lO90N";
$lang['more'] = "mOrE";
$lang['recentvisitors'] = "r3C3n+ V1\$1+0RS";
$lang['username'] = "u53rNam3";
$lang['clear'] = "cLe4r";
$lang['reset'] = "re5E+";
$lang['action'] = "aC+1oN";
$lang['unknown'] = "uNkNOWn";
$lang['none'] = "nONE";
$lang['preview'] = "prev1eW";
$lang['post'] = "pO\$+";
$lang['posts'] = "p0s+S";
$lang['change'] = "cH4NGE";
$lang['yes'] = "y35";
$lang['no'] = "n0";
$lang['signature'] = "sIGN4tUrE";
$lang['signaturepreview'] = "s1gn4tuRE prEV13W";
$lang['signatureupdated'] = "si9N4+URe UPd4tEd";
$lang['signatureupdatedforallforums'] = "s1gn@TUr3 UPD4T3D PhoR All PH0RuMS";
$lang['back'] = "b4cK";
$lang['subject'] = "sU8JEC+";
$lang['close'] = "cLO5E";
$lang['name'] = "n4m3";
$lang['description'] = "dE\$cR1PTi0n";
$lang['date'] = "datE";
$lang['view'] = "v13W";
$lang['enterpasswd'] = "eNT3R PassWORd";
$lang['passwd'] = "p4\$\$W0rd";
$lang['ignored'] = "i9NORED";
$lang['guest'] = "guEs+";
$lang['next'] = "nEX+";
$lang['prev'] = "pr3VIOU\$";
$lang['others'] = "o+H3R\$";
$lang['nickname'] = "n1CkN@me";
$lang['emailaddress'] = "eMAIL @ddR3\$\$";
$lang['confirm'] = "cOnPH1rm";
$lang['email'] = "em41L";
$lang['poll'] = "p0ll";
$lang['friend'] = "fRiEnd";
$lang['success'] = "suCC3\$\$";
$lang['error'] = "eRR0R";
$lang['warning'] = "w@RN1ng";
$lang['guesterror'] = "s0RRY, J00 NeeD t0 B3 L0G9Ed In T0 US3 ThI\$ FE4TUrE.";
$lang['loginnow'] = "lO9iN n0W";
$lang['unread'] = "uNR3@D";
$lang['all'] = "alL";
$lang['allcaps'] = "aLl";
$lang['permissions'] = "p3rmisSION\$";
$lang['type'] = "typE";
$lang['print'] = "pr1nT";
$lang['sticky'] = "s+1CKY";
$lang['polls'] = "p0LL\$";
$lang['user'] = "u\$ER";
$lang['enabled'] = "eN48LED";
$lang['disabled'] = "d1S4BLed";
$lang['options'] = "oP+1oNS";
$lang['emoticons'] = "emoTiC0NS";
$lang['webtag'] = "w3b+@9";
$lang['makedefault'] = "m@kE d3pH4ULT";
$lang['unsetdefault'] = "un\$3T d3ph4ULT";
$lang['rename'] = "ren@M3";
$lang['pages'] = "p49ES";
$lang['used'] = "u\$3d";
$lang['days'] = "d4YS";
$lang['usage'] = "u\$49e";
$lang['show'] = "sh0w";
$lang['hint'] = "hIn+";
$lang['new'] = "n3W";
$lang['referer'] = "r3PHERer";
$lang['thefollowingerrorswereencountered'] = "t3h F0LL0WInG ErR0RS WEre EnCOUntEr3d:";

// Admin interface (admin*.php) ----------------------------------------

$lang['admintools'] = "aDm1N +0Ols";
$lang['forummanagement'] = "f0RUM m4NAG3MEn+";
$lang['accessdeniedexp'] = "j00 DO nO+ h4v3 P3Rm1\$S10N t0 USe Thi\$ S3CT10N.";
$lang['managefolders'] = "m4NA93 F0LDERS";
$lang['manageforums'] = "m4N@gE foRUms";
$lang['manageforumpermissions'] = "m4naGe pHOrUM peRM1\$sioN\$";
$lang['foldername'] = "fOlD3R n@m3";
$lang['move'] = "mOv3";
$lang['closed'] = "cLo\$3d";
$lang['open'] = "op3N";
$lang['restricted'] = "rE\$tr1CT3D";
$lang['forumiscurrentlyclosed'] = "%s IS CurR3NTly clO\$3d";
$lang['youdonothaveaccesstoforum'] = "j00 do N0T H4v3 @cCESS tO %s";
$lang['toapplyforaccessplease'] = "t0 4pPlY pHOR ACc3sS pLE@S3 COn+@ct T3H %s.";
$lang['forumowner'] = "fOrUM owNEr";
$lang['adminforumclosedtip'] = "iph j00 w@NT tO Ch4n93 \$om3 \$3T+1ngs ON y0uR f0rUM CLicK tHe @dMIN l1NK iN ThE N4V1G4+10N 8aR AB0VE.";
$lang['newfolder'] = "n3W PhoLD3R";
$lang['nofoldersfound'] = "n0 EX1sT1NG f0lD3R\$ pH0UNd. +0 4Dd A pHOLdeR cLIcK +H3 '@dD N3W' BUT+0n 83lOw.";
$lang['forumadmin'] = "f0rUM @dM1N";
$lang['adminexp_1'] = "uSe tEH M3NU ON +H3 lEPHt TO m@n493 Th1nG\$ IN YOUR f0RUM.";
$lang['adminexp_2'] = "<b>u\$eR\$</b> @lL0Ws j00 +O s3T InD1V1DU4L us3R pERmI\$S10N\$, 1NCluDIn9 4PPOIN+1Ng MOdER4+Ors aND G49g1NG p30PL3.";
$lang['adminexp_3'] = "<b>uS3R 9rOUPs</b> 4LLOWs J00 TO cRe4t3 US3R gROUP\$ +O aS\$Ign pERM15s10N\$ +O @s mANy oR a\$ Ph3w U\$3rS qUIcKLy ANd E4s1LY.";
$lang['adminexp_4'] = "<b>b4n C0N+R0LS</b> 4lLOws tHE b4NNIn9 4Nd UN-B4NNiNG of 1P @DDR3s5es, H+tP r3f3RERs, U5ErN4M3\$, EM@1l @DdR35\$ES aND n1cKN4m3\$.";
$lang['adminexp_5'] = "<b>f0lDERS</b> @Ll0wS TeH cr34+1oN, M0dIPh1cATiON 4Nd DEl3+10N OpH F0LDerS.";
$lang['adminexp_6'] = "<b>rs\$ FE3DS</b> 4lL0WS J00 +0 M4n4g3 RS\$ PhE3D5 F0R ProP494TI0N IN+0 Y0UR F0RUM.";
$lang['adminexp_7'] = "<b>pRoF1l3\$</b> Lets J00 cU\$toMI\$E +hE 1T3m5 +H4+ aPP3AR 1n teH uSER pROf1lE\$.";
$lang['adminexp_8'] = "<b>fOrUM seTTin9\$</b> 4lLOWS j00 TO CU\$+om1S3 Y0UR f0RUm'5 N4M3, 4PP3@r4ncE 4ND m@NY o+h3R Th1NG\$.";
$lang['adminexp_9'] = "<b>sT4rT P49E</b> L3+S j00 CU\$tOM153 Y0UR pH0RUM'S s+@R+ P4GE.";
$lang['adminexp_10'] = "<b>f0RUm \$TyL3</b> 4lL0wS J00 TO 93n3rATe R4NDOM \$+ylEs pHOR Y0UR pHORum meMBeR\$ tO U\$3.";
$lang['adminexp_11'] = "<b>wOrd pH1Lt3R</b> 4lL0WS J00 T0 PHiL+3R w0rDS j00 D0N't WAN+ T0 8E Us3d oN yOUR pH0RUm.";
$lang['adminexp_12'] = "<b>postINg \$T@T\$</b> 93N3R4+3\$ @ r3pORt L1\$tIN9 Th3 +Op 10 p0\$ters 1N 4 D3PH1NED P3RI0D.";
$lang['adminexp_13'] = "<b>f0ruM LInKs</b> l3+s j00 MANag3 +3H L1NKS DR0PDOwN iN +h3 N4VIg4tI0N 8AR.";
$lang['adminexp_14'] = "<b>vi3w L0G</b> li\$+S R3C3NT @C+i0nS 8Y TH3 F0Rum moDeRA+ors.";
$lang['adminexp_15'] = "<b>m@N4G3 F0RUMs</b> LEt\$ J00 CrE@t3 AnD d3l3+3 4Nd CL05E OR Re0pEn F0RUms.";
$lang['adminexp_16'] = "<b>gl0b@L Ph0RUM 5eTTInGS</b> ALl0WS J00 To MOd1fY S3+tiN9\$ wH1CH @PhpHeC+ 4Ll PH0rUMs.";
$lang['adminexp_17'] = "<b>po\$+ ApPR0V4L qUEu3</b> 4lL0W\$ J00 TO v1EW @NY POST\$ 4W41+1NG aPProV@L BY 4 MOdeR4TOR.";
$lang['adminexp_18'] = "<b>vIs1+OR loG</b> aLL0WS j00 T0 vIew An EX+3NDed L1S+ 0f V1\$1+0RS 1NClUDIng +h31R hTTp R3PHer3R\$.";
$lang['createforumstyle'] = "cr34T3 4 Ph0RUm S+Yl3";
$lang['newstylesuccessfullycreated'] = "new 5+YLe \$UCC3\$\$PhULLy cRe4+3D.";
$lang['stylealreadyexists'] = "a 5tYL3 Wi+H TH@t f1L3N4ME 4LRE4DY 3xi\$ts.";
$lang['stylenofilename'] = "j00 Did noT 3Nt3r 4 Ph1lEn4M3 +0 54VE TH3 S+yL3 W1+H.";
$lang['stylenodatasubmitted'] = "coulD n0+ r3@D FORum StylE DA+A.";
$lang['styleexp'] = "uSe THi\$ p4GE tO HElP cr34+3 4 r4ND0MLy GEn3r4t3D 5+yLe pH0R y0Ur FORUm.";
$lang['stylecontrols'] = "con+R0LS";
$lang['stylecolourexp'] = "cL1Ck 0n a C0LOur t0 m4k3 @ N3w sTylE \$H3eT 8As3D 0n th4+ coLOuR. cURr3nT 8A\$e C0lOUr Is Fir\$t In lIS+.";
$lang['standardstyle'] = "st@Nd4RD S+yLe";
$lang['rotelementstyle'] = "r0t4+3D eL3men+ 5+yLE";
$lang['randstyle'] = "r4Nd0m \$+YLe";
$lang['thiscolour'] = "tHiS coLoUR";
$lang['enterhexcolour'] = "or 3N+3R 4 H3x colOUr t0 84sE 4 nEw 5+YLe sHEE+ 0N";
$lang['savestyle'] = "s@v3 +His STyl3";
$lang['styledesc'] = "styL3 D3SCRiP+10N";
$lang['stylefilenamemayonlycontain'] = "s+yL3 F1l3N@ME M4Y 0NLY C0N+@1n loW3RC@\$3 LEt+eR\$ (4-Z), NUM83r\$ (0-9) 4ND UNd3RScoR3.";
$lang['stylepreview'] = "s+yL3 PR3V1EW";
$lang['welcome'] = "w3lC0mE";
$lang['messagepreview'] = "m3\$s@Ge PRev1ew";
$lang['users'] = "u53RS";
$lang['usergroups'] = "useR 9R0UP\$";
$lang['mustentergroupname'] = "j00 MUST 3nTEr A Gr0UP nAMe";
$lang['profiles'] = "pROPhiL3S";
$lang['manageforums'] = "m@n@Ge PH0rumS";
$lang['forumsettings'] = "f0rUM \$3tTINg\$";
$lang['globalforumsettings'] = "gl08al ph0RUm SE+TINg\$";
$lang['settingsaffectallforumswarning'] = "<b>n0+3:</b> +he53 \$3ttINgs @pHF3C+ 4Ll PHorUM\$. whEre +3H \$3+tIN9 is duPL1c4t3D On +he InD1VIdUAL PH0Rum'\$ \$3+T1N9S p@93 +hAT w1LL +AK3 pR3CeDEnC3 0VEr T3H sE+TiNG5 j00 cH4N93 HeRE.";
$lang['startpage'] = "s+4rt P@gE";
$lang['startpageerror'] = "yOUr \$+4r+ P493 C0ULD NO+ B3 \$@veD LOC@LLy to tEH \$3RV3r 83CAU\$3 p3rM1sS1oN wA\$ d3n1ED.</p><p>t0 CHANge YOur 5+@rT p4GE pL34S3 CL1CK +3H D0WNL0Ad 8UT+0N 83l0W WHIcH WilL pROmpT J00 +0 S4V3 TEh PH1LE +0 YOUR h4rd dr1VE. j00 C4N +hEN UPL04D th1s FIl3 +0 yoUR S3RveR inTO THE pHoLL0WIn9 FOlD3r, 1f NECe\$S4rY CR3A+1NG +3h foLD3R \$+RuCTUR3 In T3H PrOCESS.</p><p><b>%s</b></p><p>pLE@\$3 N0+3 THat S0ME br0WS3R5 M4Y cH4nGe +h3 NAmE 0PH +H3 FIL3 UPon D0WNloAd. Wh3n UPL0AD1NG +H3 F1l3 Pl34\$3 MAKE \$Ure +h@+ i+ 1\$ N4m3d \$T4r+_M41n.PHP 0tH3rw1sE Y0uR sT4r+ P49e W1lL @PP3@R UNCH4ng3d.";
$lang['uploadcssfile'] = "upl04D C\$s S+YL3 sH33t";
$lang['uploadcssfilefailed'] = "yOuR c\$s StYLE sH33+ coULd nOT 83 upLOADed TO TH3 S3RVer 83C4U\$3 P3RM1\$S1oN wA\$ d3NIEd.</p><p>to Ch@NGE yOUr ST4R+ p4G3 Css STYle \$hE3T pl345E 3N\$URE +H3 FOLL0W1n9 FOld3R\$ 3xiS+ 4Nd @Re Wr1+AblE: </p><p><b>%s</b></p>";
$lang['invalidfiletypeerror'] = "iNVal1d PhILe +Yp3, J00 C4N OnLy UPloAd CSS \$TYl3 \$H33+ pHIlES";
$lang['failedtoopenmasterstylesheet'] = "y0ur Ph0rUM 5TYLE COULD NO+ be \$@vED BEC4Us3 +H3 m4ST3R S+yl3 SH3ET c0ulD noT 8E L04D3D. t0 S@V3 YOUR StYlE TH3 M4s+3R StylE \$H33+ (M4k3_STYLe.CSS) mUS+ B3 lOC4tED In +He \$+Yl3S DIR3c+0Ry 0f Y0UR b3EHIV3 f0RUm 1Ns+@Ll4t1oN.";
$lang['makestyleerror'] = "yOur PHORUM \$+YlE COULD n0T b3 \$@VEd L0C4LLY T0 +HE 53RVEr 83c4uS3 P3rm1sSION W4s DENIEd.</p><p>t0 s4VE yoUR FORUM STYle pl3AsE cL1ck T3H doWNL04d 8u+TON 8ELOW wh1CH Will PR0Mpt J00 To \$@V3 +H3 F1L3 +O Y0uR h@RD dr1VE. j00 C4N TheN UPLO@D tHi\$ PH1l3 T0 Y0UR S3RV3R INTO th3 F0lL0W1NG F0LD3R, IF NECE\$S4RY cr3@+1NG tHE Ph0LdeR S+rUCTURE IN The Pr0cEss.</p><p><b>%s</b></p><p>plE@s3 NOTe +H4T S0M3 BR0Ws3Rs M@y Ch4n9e +HE n@ME 0ph TEH File UPON d0wNLOAd. WHEn UPLO@DIN9 teH PH1LE PL3A\$3 MAk3 \$URe +H4T 1T i\$ n4m3d s+YLe.Css o+HERWIs3 +h3 pHOrum \$tyl3 W1lL 83 UN4V41L48l3.";
$lang['forumstyle'] = "foRUM 5+Yle";
$lang['wordfilter'] = "wORD PH1L+3R";
$lang['forumlinks'] = "f0rUM l1nKS";
$lang['viewlog'] = "v13W LOg";
$lang['noprofilesectionspecified'] = "n0 PROpH1LE sEcTION \$PecIPhI3D.";
$lang['itemname'] = "it3M n@ME";
$lang['moveto'] = "mOvE +0";
$lang['manageprofilesections'] = "m@n493 PR0F1LE \$3c+10Ns";
$lang['sectionname'] = "s3cTI0N n@Me";
$lang['items'] = "iT3MS";
$lang['mustspecifyaprofilesectionid'] = "muST sPEciFY 4 prOPH1le S3C+10N 1D";
$lang['mustsepecifyaprofilesectionname'] = "mu\$+ \$p3ciPHy 4 pROF1L3 \$eCT1ON n@Me";
$lang['noprofilesectionsfound'] = "no Ex1s+1N9 PR0PH1LE \$ecT10n\$ ph0UND. t0 ADD @ PR0F1L3 \$3C+10n clICk T3H 'Add NEw' bu+tON BEloW.";
$lang['addnewprofilesection'] = "aDd NeW ProFIl3 s3CTIon";
$lang['successfullyaddedprofilesection'] = "sUcC3sSPHUlLY ADDeD Pr0fiL3 S3C+1oN";
$lang['successfullyeditedprofilesection'] = "sucCESSFULLY ed1+3D Pr0f1L3 s3CTi0n";
$lang['addnewprofilesection'] = "aDD New pR0FILe S3CTi0n";
$lang['mustsepecifyaprofilesectionname'] = "mUs+ \$pECIPhY 4 PrOPhILE \$3CTI0N n@Me";
$lang['successfullyremovedselectedprofilesections'] = "sucC35SFULlY remOveD s3L3CTed Prof1L3 \$3C+1ON\$";
$lang['failedtoremoveprofilesections'] = "f@1lED +0 R3MOVE pR0F1L3 \$eCTi0n\$";
$lang['viewitems'] = "vI3w 1+3MS";
$lang['successfullyaddednewprofileitem'] = "sucCE\$spHUlly aDdeD new pROFIl3 1teM";
$lang['successfullyeditedprofileitem'] = "sUcC3sSPHUllY ed1+ED pR0PHiLE iTEM";
$lang['successfullyremovedselectedprofileitems'] = "sucCES\$PHUlLY r3MOV3D \$3L3C+3D pROF1LE 1tEms";
$lang['failedtoremoveprofileitems'] = "f@iLED to ReMOVE PR0PHilE I+EM\$";
$lang['noexistingprofileitemsfound'] = "tH3RE @r3 N0 3X1sTin9 Pr0FIL3 i+ems 1N +hI5 SecTI0N. T0 Add 4N 1+3M CL1CK tHE '@dD nEW' BU++0N BEl0w.";
$lang['edititem'] = "eD1t 1+3M";
$lang['invalidprofilesectionid'] = "inv4l1D Pr0pHiL3 SEc+1oN iD 0R SecT10N no+ F0Und";
$lang['invalidprofileitemid'] = "inv@L1D Pr0f1LE 1+3M 1D Or IT3M no+ foUND";
$lang['addnewitem'] = "aDd n3w 1+3M";
$lang['youmustenteraprofileitemname'] = "j00 MUST 3nt3R @ PRophIL3 I+3M n@M3";
$lang['invalidprofileitemtype'] = "inv4lID PROF1L3 1+EM +YPe S3l3CTEd";
$lang['youmustenteroptionsforselectedprofileitemtype'] = "j00 MU\$T 3NteR s0m3 op+I0N\$ PHOR S3lEc+3D ProfIle iTEM +yPe";
$lang['youmustentermorethanoneoptionforitem'] = "j00 mU\$+ 3NT3R mOR3 Th4N ON3 0P+1ON PH0R \$ELEc+3d pR0F1LE 1Tem +yPE";
$lang['profileitemhyperlinkssupportshttpurlsonly'] = "pRopH1L3 1TEM hYp3rL1NKs SUpp0RT ht+p URLS oNly";
$lang['profileitemhyperlinkformatinvalid'] = "pRoPH1L3 1TEm HYp3rLINk F0RM4+ 1nv4l1D";
$lang['youmustincludeprofileentryinhyperlinks'] = "j00 MusT 1nCluD3 <i>%s</i> iN Th3 URl of CliCkA8l3 HyPERl1nKS";
$lang['failedtocreatenewprofileitem'] = "f4iLED +O cREa+3 NEw PROFiL3 1TEm";
$lang['failedtoupdateprofileitem'] = "f@1lED +O UPd4tE Pr0PHIlE Item";
$lang['startpageupdated'] = "s+4R+ P@9E UpD4+3D. %s";
$lang['cssfileuploaded'] = "c5s sTYl3 sHE3T UPlO4d3D. %s";
$lang['viewupdatedstartpage'] = "v13W UPdaT3D S+aRT paGE";
$lang['editstartpage'] = "eDi+ \$T@r+ P493";
$lang['nouserspecified'] = "n0 uS3r speC1F1ED.";
$lang['manageuser'] = "m@n@Ge US3R";
$lang['manageusers'] = "m@N@ge US3RS";
$lang['userstatusforforum'] = "useR \$t@TUS ph0R %s";
$lang['userdetails'] = "u\$3r D3T@ilS";
$lang['edituserdetails'] = "edi+ U5ER D3+AiL\$";
$lang['warning_caps'] = "w4rnIn9";
$lang['userdeleteallpostswarning'] = "ar3 j00 5UR3 J00 W4N+ +O DELe+3 4LL oPH +He \$3LecTED u\$3R'\$ pO\$tS? 0NC3 +hE po5+5 4R3 D3lE+3d +hEY CANnot 8E r3+R13V3D 4ND W1lL BE LoS+ pH0R3V3r.";
$lang['postssuccessfullydeleted'] = "pOs+S W3re sUCc3ssFUlLY D3LETeD.";
$lang['folderaccess'] = "fOLD3R 4CCeSs";
$lang['possiblealiases'] = "pO\$S1BLE @Li4\$3S";
$lang['ipaddressmatches'] = "iP @DDRes\$ m4tcHE\$";
$lang['emailaddressmatches'] = "eM4iL 4dDREss m4+Ch3s";
$lang['passwdmatches'] = "p4SSW0RD M4TCh3s";
$lang['httpreferermatches'] = "h++P r3ph3RER M4+CH3S";
$lang['userhistory'] = "u53R hISt0RY";
$lang['nohistory'] = "n0 h1s+ORY R3C0RDS S@VED";
$lang['userhistorychanges'] = "ch4NGES";
$lang['clearuserhistory'] = "cL3AR USEr H1ST0rY";
$lang['changedlogonfromto'] = "cH@NgED l09oN Fr0m %s +0 %s";
$lang['changednicknamefromto'] = "cH@NGeD n1cKN4Me phR0M %s +0 %s";
$lang['changedemailfromto'] = "cH4nG3D EM41L PhrOM %s +0 %s";
$lang['successfullycleareduserhistory'] = "suCC3SSFULLY cle4r3D u\$3R HIStoRY";
$lang['failedtoclearuserhistory'] = "f4iLeD +0 CLEaR us3R h1sTOry";
$lang['successfullychangedpassword'] = "sUCCe\$SPHulLy CH4N9ED pA\$SWOrD";
$lang['failedtochangepasswd'] = "f41l3D +O CH4N93 paSSw0RD";
$lang['approveuser'] = "aPPROvE USer";
$lang['viewuserhistory'] = "vieW U\$3R H1ST0RY";
$lang['viewuseraliases'] = "vI3W UseR 4l14s3s";
$lang['searchreturnednoresults'] = "s3aRCH Re+URneD NO Re\$UL+s";
$lang['deleteposts'] = "del3T3 p0st\$";
$lang['deleteuser'] = "delE+3 U\$3R";
$lang['alsodeleteusercontent'] = "al5o DElE+e AlL 0F +eH c0n+EN+ Cr3@tED bY Th1s U\$3R";
$lang['userdeletewarning'] = "ar3 J00 \$URE J00 W4nt To DELeT3 T3H S3LEc+3d u\$3R 4CCOunT? 0NC3 +h3 @Cc0UN+ H4s 833N D3Le+3d 1+ C4NN0+ 83 R3+R1EV3D 4ND wiLL b3 LO\$+ F0Rev3r.";
$lang['usersuccessfullydeleted'] = "us3R SucC3sSPhULLY DeL3TED";
$lang['failedtodeleteuser'] = "f@ilEd +0 Dele+3 US3r";
$lang['forgottenpassworddesc'] = "iPH th1s U\$3R H4s Ph0r9oTTEN TH31r P4\$sw0rD J00 C4N R3\$3+ IT FOr +HeM HERe.";
$lang['failedtoupdateuserstatus'] = "f@1lED +o UpD4+3 U5ER st@Tus";
$lang['failedtoupdateglobaluserpermissions'] = "f@1LEd +0 upDA+3 gLOb4l us3R P3RmI5s1on\$";
$lang['failedtoupdatefolderaccesssettings'] = "f41L3D +o UPDA+3 F0LD3R @CC3\$s \$3+T1NgS";
$lang['manageusersexp'] = "this L1\$T ShoW\$ 4 S3LECtI0N OF uS3R\$ WH0 H4V3 LOgG3D 0n +0 YOUr FOruM, \$0RTEd BY %s. To @Lt3r 4 U5ER'S perMI\$SION5 cl1cK tH3IR n@Me.";
$lang['userfilter'] = "u\$eR phIL+3r";
$lang['onlineusers'] = "oNLIne US3RS";
$lang['offlineusers'] = "ophFL1nE us3R\$";
$lang['usersawaitingapproval'] = "uSER\$ 4W41+1NG @Ppr0V4L";
$lang['bannedusers'] = "b@NNeD U\$3R\$";
$lang['lastlogon'] = "l4ST L0G0N";
$lang['sessionreferer'] = "sEsS10N ReF3RER";
$lang['signupreferer'] = "sign-up r3f3RER:";
$lang['nouseraccountsmatchingfilter'] = "nO U\$3R 4CcoUnts m4TCh1N9 PhILteR";
$lang['searchforusernotinlist'] = "se4rch f0R 4 U\$3R nO+ IN lisT";
$lang['adminaccesslog'] = "adm1n 4CCE5s l09";
$lang['adminlogexp'] = "tHis l1s+ \$hOWS +eh L@\$+ 4c+ioN\$ sANcTI0N3d BY uSERs w1+H @dM1n PRiVIL39E\$.";
$lang['datetime'] = "d@+E/tiMe";
$lang['unknownuser'] = "unknoWN UseR";
$lang['unknownuseraccount'] = "unkN0WN u5Er @CcoUnt";
$lang['unknownfolder'] = "uNKNown f0Ld3r";
$lang['ip'] = "ip";
$lang['lastipaddress'] = "l45t 1p 4dDRE\$S";
$lang['hostname'] = "h0S+N4Me";
$lang['unknownhostname'] = "uNKNOwn h0\$tN@M3";
$lang['logged'] = "l09g3D";
$lang['notlogged'] = "n0+ l0g93d";
$lang['addwordfilter'] = "add w0RD ph1l+eR";
$lang['addnewwordfilter'] = "add N3W W0RD f1lTER";
$lang['wordfilterupdated'] = "w0RD phIL+3r upd@TEd";
$lang['wordfilterisfull'] = "j00 C4nNO+ ADD 4ny M0RE wORd F1lteRS. R3MOvE \$om3 UNu\$3d 0n3\$ OR EDI+ +HE eXIsTIn9 0ne\$ PH1RSt.";
$lang['filtername'] = "f1lT3r n4M3";
$lang['filtertype'] = "f1l+3R typ3";
$lang['filterenabled'] = "fILt3R EN4BLEd";
$lang['editwordfilter'] = "eD1+ WORD f1lter";
$lang['nowordfilterentriesfound'] = "n0 EX1sTINg woRd PH1l+ER 3NTr1e\$ FOuND. TO @DD 4 f1L+Er Cl1CK +H3 '4DD nEw' 8UT+0n B3L0W.";
$lang['mustspecifyfiltername'] = "j00 MU5+ SpEC1PHy 4 Ph1LTEr N@m3";
$lang['mustspecifymatchedtext'] = "j00 MUs+ speCiFY M@TCHeD +3xT";
$lang['mustspecifyfilteroption'] = "j00 MUSt 5P3CIFy 4 F1L+3R 0PtION";
$lang['mustspecifyfilterid'] = "j00 MUST Sp3CIFy @ pH1L+3R 1d";
$lang['invalidfilterid'] = "inV4LId FIlTEr 1D";
$lang['failedtoupdatewordfilter'] = "f4iLEd +0 UpDA+3 WORd FIlT3R. CH3CK +H4T THe FilTER STiLL exI\$+S.";
$lang['allow'] = "aLl0w";
$lang['block'] = "bLocK";
$lang['normalthreadsonly'] = "norM@l +Hr3ADS 0nLy";
$lang['pollthreadsonly'] = "pOLL THr34D\$ 0Nly";
$lang['both'] = "botH +hrE4D TyPE\$";
$lang['existingpermissions'] = "exis+1N9 P3RMI\$S1oN\$";
$lang['nousershavebeengrantedpermission'] = "n0 EXi\$+1Ng US3RS P3RM1\$s10N\$ pHouNd. To gR4NT pERmI\$S10N to US3RS sE4RCh PH0R +H3M b3lOW.";
$lang['successfullyaddedpermissionsforselectedusers'] = "sUcC3\$\$pHULlY ADd3d PerMiSs1oNS f0r \$3LecT3D US3RS";
$lang['successfullyremovedpermissionsfromselectedusers'] = "sUCCE5SpHULlY r3MOV3D p3RMi\$\$i0n\$ PHROM \$3LecTEd U\$3R\$";
$lang['failedtoaddpermissionsforuser'] = "f@1l3D TO @dD P3RM1\$S10N\$ f0R U\$3R '%s'";
$lang['failedtoremovepermissionsfromuser'] = "f4ilED +0 R3MOVE PErm1sSI0NS FroM us3r '%s'";
$lang['searchforuser'] = "se4rcH F0R u5ER";
$lang['browsernegotiation'] = "bRoW\$3R ne90TI4T3D";
$lang['textfield'] = "tExT ph1ELD";
$lang['multilinetextfield'] = "multI-l1n3 +EX+ pHIeLD";
$lang['radiobuttons'] = "r4d10 BU+TONS";
$lang['dropdownlist'] = "dr0P DowN LI\$T";
$lang['clickablehyperlink'] = "cLICKaBLE HYp3rL1NK";
$lang['threadcount'] = "thR3@D coUN+";
$lang['clicktoeditfolder'] = "cl1CK T0 EDi+ f0lDER";
$lang['fieldtypeexample1'] = "to CR3@+3 r4d10 8U+TOns OR a DroP DOWn l1\$T J00 N33d +0 En+3R 34Ch INDiV1DU4L V4Lue ON 4 \$3PAR4T3 LIn3 IN +H3 0P+10N\$ PHIeLD.";
$lang['fieldtypeexample2'] = "to CRE4TE CLICk@8l3 LINKS EN+Er TEh URl 1N Teh 0p+10NS PHIEld @ND us3 <i>%1\$s</i> WH3RE +3h EN+RY PHrom +H3 US3R'S pROf1L3 \$hoULD apPEAR. EX4MPlE\$: <p>mY\$p4c3: <i>ht+P://wWW.mYSP@c3.COm/%1\$S</i><br />xBOX LivE: <i>h+tP://pR0f1L3.MyG@merC@rD.NEt/%1\$S</i>";
$lang['editedwordfilter'] = "eD1+3d W0RD F1L+3R";
$lang['editedforumsettings'] = "eD1+3D foRUM \$3+TIn9s";
$lang['successfullyendedusersessionsforselectedusers'] = "suCC3\$SPHulLY ENd3D \$ESS10N\$ F0R S3L3C+3d US3R\$";
$lang['failedtoendsessionforuser'] = "f41l3D +O 3nD \$3SsI0N fOR usEr %s";
$lang['successfullyapproveduser'] = "sUcC3\$SFULlY @pPR0V3D US3R";
$lang['successfullyapprovedselectedusers'] = "sUcC3\$\$fuLLY 4PPr0v3D \$3lEctEd U\$3R5";
$lang['matchedtext'] = "m4+CH3D +3xT";
$lang['replacementtext'] = "r3pL4CEMeNT T3xT";
$lang['preg'] = "pRe9";
$lang['wholeword'] = "wHOLE W0RD";
$lang['word_filter_help_1'] = "<b>alL</b> MaTChEs @gaiN5T THe WH0LE T3xT SO f1l+3R1N9 MOM +o MuM WIll AlsO ch@NgE MOM3NT t0 MUMeN+.";
$lang['word_filter_help_2'] = "<b>wh0L3 W0RD</b> m4tCH3s 494IN5T wHOL3 W0RDs 0NLY 50 PHiLTEr1n9 M0M to muM W1ll N0t CHaN9e moMEn+ +O MUm3NT.";
$lang['word_filter_help_3'] = "<b>pReG</b> ALlow\$ J00 TO Us3 P3RL rE9uL4R 3xPR3\$S1oNS +O M@TCH tEX+.";
$lang['nameanddesc'] = "n4m3 @nD DE\$cR1P+1ON";
$lang['movethreads'] = "movE THre4d\$";
$lang['movethreadstofolder'] = "mOv3 +HREadS +0 ph0LD3R";
$lang['failedtomovethreads'] = "f41L3d +O mOVE +hrE4d\$ +0 SP3cIF1ED f0LDer";
$lang['resetuserpermissions'] = "r3S3+ US3R pERmI\$S10N\$";
$lang['failedtoresetuserpermissions'] = "f@ILed +O R3\$3+ u\$3r peRM1sSI0NS";
$lang['allowfoldertocontain'] = "alloW PHOLDER T0 C0NT41N";
$lang['addnewfolder'] = "add N3W PH0lD3R";
$lang['mustenterfoldername'] = "j00 mu5+ ENTer @ Ph0ldEr N@mE";
$lang['nofolderidspecified'] = "n0 pH0LD3R id 5PEC1PhIEd";
$lang['invalidfolderid'] = "iNVALId PH0LDeR 1D. cHECk +H4T 4 Ph0lD3R WiTH tHI\$ ID 3x1\$+\$!";
$lang['successfullyaddednewfolder'] = "sUccE5SPHulLY ADdeD N3W f0lD3R";
$lang['successfullyremovedselectedfolders'] = "sUCC3sSPHULLy R3MOv3D SEl3c+3D FOlD3R\$";
$lang['successfullyeditedfolder'] = "sucCEssFULlY 3DI+3D F0Ld3r";
$lang['failedtocreatenewfolder'] = "f41lED +0 CRE4T3 NeW PhoLdeR";
$lang['failedtodeletefolder'] = "f4ILed T0 D3le+3 F0ld3r.";
$lang['failedtoupdatefolder'] = "f41l3d TO uPD4tE F0LDer";
$lang['cannotdeletefolderwiththreads'] = "c@NNO+ d3LE+3 foLD3R\$ +H@T StilL CON+@1N thR3@ds.";
$lang['forumisnotrestricted'] = "f0ruM i\$ noT reSTr1cTeD";
$lang['groups'] = "gr0uPs";
$lang['nousergroups'] = "n0 USEr 9R0UPS H4V3 8EEN \$3+ UP. TO 4Dd @ gROUp Cl1cK Th3 '4DD nEW' BU++0N 83L0W.";
$lang['suppliedgidisnotausergroup'] = "supPliEd 9ID 15 N0+ 4 U\$3R GrOUP";
$lang['manageusergroups'] = "m4N@93 USEr 9R0UP\$";
$lang['groupstatus'] = "gROUP St4+U\$";
$lang['addusergroup'] = "add U\$3r 9R0UP";
$lang['addemptygroup'] = "add 3MP+y 9R0UP";
$lang['adduserstogroup'] = "aDd USEr\$ +0 9R0uP";
$lang['addremoveusers'] = "adD/REm0ve US3RS";
$lang['nousersingroup'] = "tHERE 4r3 N0 US3R5 IN THI5 9r0UP. 4DD USEr\$ TO +hI\$ 9RoUP bY S3aRCh1n9 PH0R +hEM BEL0W.";
$lang['groupaddedaddnewuser'] = "succE\$SphuLLy AdDEd groUp. 4DD uS3RS to THiS 9R0UP 8Y \$34RChiN9 Ph0R +h3M B3low.";
$lang['nousersingroupaddusers'] = "tHEre @r3 n0 U\$3R5 In ThI\$ 9ROup. +0 4DD US3R\$ CL1Ck T3H '4DD/reMOVe USEr\$' bu++oN 8EL0W.";
$lang['useringroups'] = "tH1s U\$3R 1\$ 4 M3MbER oF +hE F0LL0wiNg GroUP\$";
$lang['usernotinanygroups'] = "th1\$ U\$3R 1S N0+ IN 4nY us3R gROUps";
$lang['usergroupwarning'] = "nOtE: THIs US3R M4Y B3 InH3rI+1nG ADd1+10N4L PerM1\$S10N5 FR0M 4nY U\$er 9r0uPS LI\$TEd 8elOW.";
$lang['successfullyaddedgroup'] = "sUCc3SSFulLy 4dD3D GR0up";
$lang['successfullyeditedgroup'] = "sucC3\$sPhULLy Ed1teD GR0UP";
$lang['successfullydeletedselectedgroups'] = "sucCESSFULlY D3L3+3D S3Lec+3D 9Roup5";
$lang['failedtodeletegroupname'] = "f41LED +O d3lE+3 groUp %s";
$lang['usercanaccessforumtools'] = "uS3r C4N 4CCEss F0RUM +00LS aND c4N CR3at3, DELe+3 ANd ED1+ foRUms";
$lang['usercanmodallfoldersonallforums'] = "uS3R CaN MoDEr@+E <b>alL f0lD3RS</b> 0N <b>aLL ph0RUMS</b>";
$lang['usercanmodlinkssectiononallforums'] = "u\$3r CAN MOD3r@+E LinK\$ \$3C+1oN oN <b>alL PHorUM\$</b>";
$lang['emailconfirmationrequired'] = "emAil C0NPH1RM4+1ON reqU1RED";
$lang['userisbannedfromallforums'] = "u\$3r iS B4Nn3d PhR0M <b>aLL f0rUMS</b>";
$lang['cancelemailconfirmation'] = "c@nC3L 3M41L c0nF1RM4+10N @ND 4LloW US3R to S+AR+ P05+1N9";
$lang['resendconfirmationemail'] = "reS3nD C0NF1RM4T1ON em41L to USer";
$lang['failedtosresendemailconfirmation'] = "f41LED +o Res3Nd em@1L ConPhiRm4+10N +0 us3r.";
$lang['donothing'] = "d0 NOthIN9";
$lang['usercanaccessadmintools'] = "u\$ER H4\$ @cCESS To F0RUM ADM1N tO0LS";
$lang['usercanaccessadmintoolsonallforums'] = "u\$eR H4S @cCESS +o 4DMIn +0OL\$ <b>oN 4LL PHOrUMS</b>";
$lang['usercanmoderateallfolders'] = "u\$eR C@N mOd3r4+3 4LL PH0LD3R\$";
$lang['usercanmoderatelinkssection'] = "u\$er C4N m0d3R4TE l1NKS 5eCtI0N";
$lang['userisbanned'] = "us3R i5 B4NNeD";
$lang['useriswormed'] = "uSeR I\$ W0RM3D";
$lang['userispilloried'] = "uS3r 1S P1ll0r1ED";
$lang['usercanignoreadmin'] = "u\$ER CAN iGN0R3 4DMInIs+RatOR5";
$lang['groupcanaccessadmintools'] = "gR0uP C4N @CC35S 4DMIn TOOL\$";
$lang['groupcanmoderateallfolders'] = "gR0uP c4N m0dER@+E all F0LD3R\$";
$lang['groupcanmoderatelinkssection'] = "gR0UP c4n m0dER4T3 L1NkS S3CTi0N\$";
$lang['groupisbanned'] = "gROup 1S B4NNeD";
$lang['groupiswormed'] = "groUP 1\$ WORm3d";
$lang['readposts'] = "r3@D posTS";
$lang['replytothreads'] = "repLY +0 +HrEAd5";
$lang['createnewthreads'] = "cr3aT3 N3W +HREaDS";
$lang['editposts'] = "edi+ P0sT\$";
$lang['deleteposts'] = "dEL3TE p0\$TS";
$lang['postssuccessfullydeleted'] = "p0st\$ \$ucC3\$SpHULLy D3L3+3D";
$lang['failedtodeleteusersposts'] = "f@1lED to D3L3+3 U\$3R's P0\$+\$";
$lang['uploadattachments'] = "uPLO@d 4++@chM3NTS";
$lang['moderatefolder'] = "m0dER4+3 F0LDeR";
$lang['postinhtml'] = "p0s+ in H+ML";
$lang['postasignature'] = "p0ST A \$1gn4TURe";
$lang['editforumlinks'] = "eDIT F0RUM lINKS";
$lang['linksaddedhereappearindropdown'] = "l1nk\$ 4DD3D hER3 4PpE4R In A dROP d0wN in ThE +OP RIgH+ 0f +Eh FRam3 5ET.";
$lang['linksaddedhereappearindropdownaddnew'] = "lInKS @DDEd H3R3 4ppEAr 1N @ DroP D0wn IN t3h t0p rIGHT 0PH tHE fR4M3 SeT. +o @dD 4 L1NK cL1CK +H3 '4DD n3W' 8u+Ton 83LOw.";
$lang['failedtoremoveforumlink'] = "fa1Led T0 Rem0VE F0ruM LiNK '%s'";
$lang['failedtoaddnewforumlink'] = "f41lED t0 4DD NEw FORum LInk '%s'";
$lang['failedtoupdateforumlink'] = "f41leD t0 Upd4+3 PhORum LinK '%s'";
$lang['notoplevellinktitlespecified'] = "n0 +0P leVEL L1NK T1TLe \$P3C1PHieD";
$lang['youmustenteralinktitle'] = "j00 MUST 3n+3R @ lINK +1+L3";
$lang['alllinkurismuststartwithaschema'] = "aLl L1NK URI\$ MUS+ s+4R+ WItH 4 SCh3m@ (1.3. H++P://, fTP://, 1RC://)";
$lang['editlink'] = "ed1T l1nK";
$lang['addnewforumlink'] = "aDD N3W pHORUm LiNK";
$lang['forumlinktitle'] = "fORUM lINK t1+LE";
$lang['forumlinklocation'] = "f0RUm L1NK L0C4T1ON";
$lang['successfullyaddednewforumlink'] = "sUcCe5spHuLLY 4DD3D NeW PHorUM L1nK";
$lang['successfullyeditedforumlink'] = "suCCE\$SPHULlY ed1+Ed pHOruM lINK";
$lang['invalidlinkidorlinknotfound'] = "iNv@LId L1NK iD 0R lINk N0T phoUND";
$lang['successfullyremovedselectedforumlinks'] = "sucC3sSFUlLY rEMOveD SEL3C+3D l1nKs";
$lang['toplinkcaption'] = "toP L1nK C4P+1oN";
$lang['allowguestaccess'] = "allOw 9UE\$t @CcESS";
$lang['searchenginespidering'] = "s3aRcH 3n91NE \$piD3R1N9";
$lang['allowsearchenginespidering'] = "all0W S34RCh ENgINE \$PIdERinG";
$lang['sitemapenabled'] = "eN@BL3 S1+EM@P";
$lang['sitemapupdatefrequency'] = "sitEMAp Upd4T3 Phr3QUEnCY";
$lang['sitemappathnotwritable'] = "s1tEM4P dIREctoRy MU\$t b3 WRI+48L3 8Y ThE W3B \$3RVEr / pHP PR0C3Ss!";
$lang['newuserregistrations'] = "n3W us3r Re9i\$tr4TI0Ns";
$lang['preventduplicateemailaddresses'] = "preVEnt DUpL1C4TE 3M4Il 4DDR3SS3\$";
$lang['allownewuserregistrations'] = "aLlow NEw U\$3R rEG1\$+R4+10N\$";
$lang['requireemailconfirmation'] = "r3QU1RE em41L c0nfIRm4+10N";
$lang['usetextcaptcha'] = "uS3 text-C4P+chA";
$lang['textcaptchafonterror'] = "t3xT-C@ptcH@ HAS be3N D1S4BLEd Aut0m4+Ic@LLy 83C4U\$3 THerE 4RE NO trU3 TYpE F0N+S 4V@IL@bLE for i+ t0 U\$3. Pl34s3 UPl04d \$0m3 +RUe TyP3 f0N+S t0 <b>tEXT_c4p+Ch@/f0nTS</b> 0n y0uR s3rVEr.";
$lang['textcaptchadirerror'] = "tex+-C@PTCh@ h4s 8E3N d1\$48L3D beC4USE +h3 TEXt_C4PTcH4 D1R3C+OrY 4ND sub-DIrEC+oR1E\$ 4R3 N0T wR1T48LE bY ThE Web \$3RV3r / pHP pR0C3sS.";
$lang['textcaptchagderror'] = "tEX+-c@pTch4 H@\$ 83EN dis@bL3D 83c4uS3 YOUr s3RVEr'S phP s3+UP d03s NOt PROVid3 SUPP0rt phoR 9d 1MAg3 M4N1PUL4TI0N 4nd / 0R T+PH fON+ suPpoRT. BoTH @R3 ReqUiR3D F0R +ex+-cAPTch@ 5UPp0rT.";
$lang['newuserpreferences'] = "new US3R PR3f3R3NC3S";
$lang['sendemailnotificationonreply'] = "eM@Il NO+1f1C@T1ON on r3PLY TO usER";
$lang['sendemailnotificationonpm'] = "em41L NOtiF1C@+10n 0N PM +O U5ER";
$lang['showpopuponnewpm'] = "sH0W P0PUP wHEN r3c3IV1Ng N3W pM";
$lang['setautomatichighinterestonpost'] = "s3+ 4u+0M4+1C hIGH InT3RESt On P0\$+";
$lang['postingstats'] = "p0StiNg \$+4+S";
$lang['postingstatsforperiod'] = "po5tIN9 sT4+\$ f0R PER1OD %s +0 %s";
$lang['nopostdatarecordedforthisperiod'] = "no p05+ D4t4 R3C0RDEd FOr +Hi\$ PeRI0D.";
$lang['totalposts'] = "tO+@L po5TS";
$lang['totalpostsforthisperiod'] = "t0T4L po5+\$ f0r +hI\$ P3R1oD";
$lang['mustchooseastartday'] = "mUsT CHOOS3 4 S+4R+ D4Y";
$lang['mustchooseastartmonth'] = "musT CH00SE 4 ST@rT MON+h";
$lang['mustchooseastartyear'] = "mUst CH0OSE a \$T@rT YE4R";
$lang['mustchooseaendday'] = "must CHO0sE @ 3ND d4y";
$lang['mustchooseaendmonth'] = "muS+ CH0O\$3 4 EnD m0Nth";
$lang['mustchooseaendyear'] = "muS+ CHOosE 4 END YEAR";
$lang['startperiodisaheadofendperiod'] = "s+4r+ Per10D i\$ 4H3@D 0f 3ND pER10D";
$lang['bancontrols'] = "b@n C0N+r0L5";
$lang['addban'] = "aDd 8AN";
$lang['checkban'] = "checK b@N";
$lang['editban'] = "eD1T 8an";
$lang['bantype'] = "b4N +Ype";
$lang['bandata'] = "b@N D4T@";
$lang['bancomment'] = "coMM3NT";
$lang['ipban'] = "iP 8An";
$lang['logonban'] = "lO90n 84N";
$lang['nicknameban'] = "nicKN@m3 8AN";
$lang['emailban'] = "eMaIL bAN";
$lang['refererban'] = "r3ph3RER 8AN";
$lang['invalidbanid'] = "inV@L1D B4N 1D";
$lang['affectsessionwarnadd'] = "this B4n M4Y @fPH3CT +HE F0lL0W1Ng 4c+1VE usER \$ESsI0ns";
$lang['noaffectsessionwarn'] = "tH1\$ 8AN 4fPHecT\$ no @C+IVe SES510N\$";
$lang['mustspecifybantype'] = "j00 MUST \$PeciFY 4 b4n tyPE";
$lang['mustspecifybandata'] = "j00 MUS+ SP3CIPHY \$0M3 B4N D4T@";
$lang['successfullyremovedselectedbans'] = "sUCC3SSFULly REmoV3D \$3lEC+3d B4n\$";
$lang['failedtoaddnewban'] = "fa1lED T0 @Dd NEw B@n";
$lang['failedtoremovebans'] = "f41LEd +O R3MOve \$Om3 OR 4LL 0F +EH s3lEC+3d b4N\$";
$lang['duplicatebandataentered'] = "duPl1C4+E b4n D4+@ ENT3red. PL34\$e CHeCK y0UR wILdC4RDS +0 SEe 1F +H3Y alR34DY m4TCh +He D4+@ 3n+3R3D";
$lang['successfullyaddedban'] = "sUCC3sSPHuLLY ADD3D baN";
$lang['successfullyupdatedban'] = "sUCC35sPHulLy uPD4+3D BAn";
$lang['noexistingbandata'] = "theR3 1s N0 3X1sTinG 84n D4TA. TO @DD @ 8AN cl1CK +3H 'aDD nEW' 8u+TON BEL0W.";
$lang['youcanusethepercentwildcard'] = "j00 C4n uS3 +h3 PeRC3N+ (%) W1LDcARd \$YM8ol 1N @Ny OF YouR b4N l1\$+S tO ObT41N p@Rt14L m4TCh3s, 1.e. '192.168.0.%' WouLd B4N @LL 1p aDdRESs3\$ 1N +H3 R@NG3 192.168.0.1 +HrOU9H 192.168.0.254";
$lang['cannotusewildcardonown'] = "j00 C4NNo+ 4DD % 4S 4 w1LDc@RD MA+ch 0N 1+s 0WN!";
$lang['requirepostapproval'] = "reqU1R3 P05+ AppR0V4l";
$lang['adminforumtoolsusercounterror'] = "th3Re MU5+ b3 4T lEA\$t 1 u\$3r WI+H @DMIn TO0L5 4ND PH0RUm +00LS 4CCe\$s On @LL Ph0RUMS!";
$lang['postcount'] = "poST C0UNT";
$lang['resetpostcount'] = "re\$3+ P0sT c0uN+";
$lang['failedtoresetuserpostcount'] = "f@1LED +0 r3\$3+ pO\$T c0uNT";
$lang['failedtochangeuserpostcount'] = "f@1lED +o Ch4NgE Us3R POS+ cOUN+";
$lang['postapprovalqueue'] = "poS+ aPProv@l QUeUE";
$lang['nopostsawaitingapproval'] = "n0 P0\$+5 4R3 4W@i+In9 @PProvAL";
$lang['approveselected'] = "apPROVe \$3LEc+3D";
$lang['failedtoapproveuser'] = "f41L3D +0 4pPROVe US3R %s";
$lang['kickselected'] = "k1cK S3LEcT3D";
$lang['visitorlog'] = "vI\$i+OR lo9";
$lang['novisitorslogged'] = "nO Vi\$1t0RS loG93D";
$lang['addselectedusers'] = "add \$3L3cT3D U\$eR\$";
$lang['removeselectedusers'] = "rem0vE \$3L3CT3D u\$3R\$";
$lang['addnew'] = "aDd N3W";
$lang['deleteselected'] = "del3t3 SEl3c+3D";
$lang['forumrulesmessage'] = "<p><b>forUM rulE\$</b></p><p>\nRE9i\$+r4+1ON +o %1\$S is PhR33! wE D0 1NS1S+ +h4T J00 48ID3 BY tEh RUL3s 4ND p0l1CIe\$ D3T41lEd b3loW. IF J00 49REE +0 TEh T3RMS, Pl3a\$3 CH3CK +EH 'I 4GREE' CH3CK8oX 4nD PreSS +3H 'RE9I\$T3R' bU+TON b3loW. 1PH j00 WOUld LikE +0 CAncEL thE r39i\$tr@TIon, cLIck %2\$s +O r3+URN +0 THe F0RUMS 1NDEx.</p><p>\n4lTH0U9H ThE @Dm1n1sTR4T0R\$ 4Nd M0dER4+OR\$ 0PH %1\$5 W1LL A+tEMPt TO KE3P @LL 08j3C+1oN48LE me\$S4GES 0FPH +H1S PHoruM, 1T i\$ iMP0sSiBL3 PH0R US +o R3V1eW 4LL MesS@93s. @ll M3ss@GEs 3Xpr3\$\$ tH3 V13ws 0ph T3h 4utHoR, 4nd nE1th3r TEH 0wNER5 opH %1\$s, NoR PROJ3c+ 833HIV3 fOrUM AND IT'\$ @fPHIlIAtEs WILL 8e hELd REspON51bl3 foR +HE CONTEN+ oPH 4Ny M3Ss49e.</p><p>\n8y A9RE31N9 +o tHEsE rULES, J00 W4rRAnT tHA+ J00 W1LL N0t PoS+ @NY MEss493\$ +h4T 4r3 0B5CEne, VUlg4R, sexU@LLY-oRiEn+4tED, H4t3phuL, +HRe4+3n1n9, 0r o+h3rWI\$3 v10L4TIV3 0f @nY L4wS.</p><p>tEH owNeRs 0f %1\$s r3s3RV3 +HE ri9H+ +o REM0ve, 3d1t, MoV3 0R CL0S3 4nY THr34d F0r 4NY rEasOn.</p>";
$lang['cancellinktext'] = "h3R3";
$lang['failedtoupdateforumsettings'] = "f41LED +0 UPd4tE F0RUM \$3+TInGS. plEASe +RY 4g@In L4+3R.";
$lang['moreadminoptions'] = "m0r3 4DM1N 0P+10ns";

// Admin Log data (admin_viewlog.php) --------------------------------------------

$lang['changedstatusforuser'] = "cH4N9ED uS3R ST@tuS PhOR '%s'";
$lang['changedpasswordforuser'] = "cHANG3D P4SSworD PHOr '%s'";
$lang['changedforumaccess'] = "ch@N93d f0rUM 4CC3sS P3RmISS10NS FoR '%s'";
$lang['deletedallusersposts'] = "del3+3D AlL p0\$TS PhOR '%s'";

$lang['createdusergroup'] = "cRe4TED uS3R 9ROuP '%s'";
$lang['deletedusergroup'] = "dEleT3d USEr GRouP '%s'";
$lang['updatedusergroup'] = "uPD@+3d UsEr 9R0uP '%s'";
$lang['addedusertogroup'] = "aDDED Us3r '%s' +O 9r0UP '%s'";
$lang['removeduserfromgroup'] = "rEm0vE USEr '%s' FroM gROUp '%s'";

$lang['addedipaddresstobanlist'] = "add3D 1P '%s' to b4n LI\$+";
$lang['removedipaddressfrombanlist'] = "rEm0VED IP '%s' pHROm 8AN L1s+";

$lang['addedlogontobanlist'] = "addeD Lo9on '%s' +o 8AN l1\$+";
$lang['removedlogonfrombanlist'] = "r3m0VED L0G0N '%s' PHroM 84N L1\$+";

$lang['addednicknametobanlist'] = "addED NICkn4M3 '%s' TO 8AN L1\$+";
$lang['removednicknamefrombanlist'] = "r3M0VEd NIckN4M3 '%s' pHR0M b4N L1S+";

$lang['addedemailtobanlist'] = "aDdED eMAIl 4DDR3SS '%s' TO 8aN L1\$T";
$lang['removedemailfrombanlist'] = "r3MOveD eM41L 4ddR3SS '%s' PHR0m B4N LI\$t";

$lang['addedreferertobanlist'] = "aDdED r3f3RER '%s' To BAn l1\$+";
$lang['removedrefererfrombanlist'] = "r3M0VED r3pH3R3R '%s' FR0M 84N l1s+";

$lang['editedfolder'] = "eDi+3D Ph0lD3R '%s'";
$lang['movedallthreadsfromto'] = "mOvED 4lL +hREAd\$ phR0M '%s' tO '%s'";
$lang['creatednewfolder'] = "crE4+3d N3W Ph0lD3R '%s'";
$lang['deletedfolder'] = "d3L3TED Ph0LD3R '%s'";

$lang['changedprofilesectiontitle'] = "cH4NGEd pROF1L3 \$3C+IoN T1+le FROM '%s' to '%s'";
$lang['addednewprofilesection'] = "aDd3D N3W PR0FIL3 S3CTI0N '%s'";
$lang['deletedprofilesection'] = "delE+3d Pr0f1L3 \$3CTI0N '%s'";

$lang['addednewprofileitem'] = "aDd3D New PR0FIl3 1TEM '%s' +O SecTi0n '%s'";
$lang['changedprofileitem'] = "cH4ng3d PrOFIL3 1TEm '%s'";
$lang['deletedprofileitem'] = "dEl3+3D Pr0f1LE 1+3M '%s'";

$lang['editedstartpage'] = "eDiT3D 5+@r+ p4g3";
$lang['savednewstyle'] = "s4V3D N3W \$+YL3 '%s'";

$lang['movedthread'] = "moVed +hRE4D '%s' FR0M '%s' +o '%s'";
$lang['closedthread'] = "cL0s3D +hrEAD '%s'";
$lang['openedthread'] = "oPEn3d +HREad '%s'";
$lang['renamedthread'] = "r3n4mED tHR3@d '%s' +O '%s'";

$lang['deletedthread'] = "dEL3+3d +hrEad '%s'";
$lang['undeletedthread'] = "uNd3LE+3D ThR3AD '%s'";

$lang['lockedthreadtitlefolder'] = "l0CK3d +HrE@D 0pTI0n\$ 0N '%s'";
$lang['unlockedthreadtitlefolder'] = "uNloCkeD THr34d OP+10N\$ 0N '%s'";

$lang['deletedpostsfrominthread'] = "d3L3+3D po\$T5 FroM '%s' 1N tHR3AD '%s'";
$lang['deletedattachmentfrompost'] = "d3lE+3D 4+T@CHM3n+ '%s' phROm p0\$T '%s'";

$lang['editedforumlinks'] = "ed1+3D F0RUM l1NKs";
$lang['editedforumlink'] = "ed1+ED pHORUm LINK: '%s'";

$lang['addedforumlink'] = "adD3d FORUm L1NK: '%s'";
$lang['deletedforumlink'] = "dEL3T3D pHORUm L1NK: '%s'";
$lang['changedtoplinkcaption'] = "cH4n9ED +0p Link cAP+1oN fRom '%s' +o '%s'";

$lang['deletedpost'] = "d3le+3D PO\$+ '%s'";
$lang['editedpost'] = "ed1+3D pOS+ '%s'";

$lang['madethreadsticky'] = "m4De +HrE4D '%s' \$T1Cky";
$lang['madethreadnonsticky'] = "m4De THr3@D '%s' Non-S+ICkY";

$lang['endedsessionforuser'] = "eND3d SE\$\$1oN f0r UsER '%s'";

$lang['approvedpost'] = "appROVEd P0\$+ '%s'";

$lang['editedwordfilter'] = "eD1TED w0rD PhiL+3R";

$lang['addedrssfeed'] = "aDd3d RSs Ph33d '%s'";
$lang['editedrssfeed'] = "eDi+eD RSS PHEed '%s'";
$lang['deletedrssfeed'] = "dEL3T3d RSS F33d '%s'";

$lang['updatedban'] = "upd4TED BAn '%s'. ch@NgeD +Yp3 FR0M '%s' TO '%s', CH4N9ED D4T@ PHR0M '%s' +O '%s'.";

$lang['splitthreadatpostintonewthread'] = "sPl1t Thr3@D '%s' a+ PO\$+ %s  1N+0 NeW +hRE4D '%s'";
$lang['mergedthreadintonewthread'] = "m3R93D +hr3@D\$ '%s' @nd '%s' 1NT0 NEW tHR3@D '%s'";

$lang['ipaddressbanhit'] = "u5eR '%s' 1S B4NNeD. iP 4DDrEsS '%s' m@+CheD b@N D@+4 '%s'";
$lang['logonbanhit'] = "u53R '%s' 1s B4NN3D. l0G0N '%s' M4+Ch3d B4N DA+a '%s'";
$lang['nicknamebanhit'] = "us3R '%s' I5 8aNNEd. nICKn4ME '%s' m@TCH3D baN D4t4 '%s'";
$lang['emailbanhit'] = "u53R '%s' is b4nn3D. Em41L 4DDR3SS '%s' M4+Ch3d 8@N d4+4 '%s'";
$lang['refererbanhit'] = "u53r '%s' IS b@NN3D. HTTp Ref3REr '%s' M4+chEd B4N Da+4 '%s'";

$lang['modifiedpermsforuser'] = "mOD1fIEd PErms F0R u\$3R '%s'";
$lang['modifiedfolderpermsforuser'] = "mod1fI3D F0Lder PErM5 FOR uSER '%s'";

$lang['userpermfoldermoderate'] = "folD3r M0Der@T0R";

$lang['adminlogempty'] = "aDmIN L0G 1S EmPTY";

$lang['youmustspecifyanactiontypetoremove'] = "j00 MUST \$PECIFY 4N 4C+10n TYPe +0 REMOVE";

$lang['alllogentries'] = "aLl LO9 enTR1ES";
$lang['userstatuschanges'] = "uSER st4+U\$ cH4NGes";
$lang['forumaccesschanges'] = "fOrUM aCC3ss ch@nG3\$";
$lang['usermasspostdeletion'] = "uSER maS5 P0\$T D3l3+10N";
$lang['ipaddressbanadditions'] = "ip 4dDR3\$S B4N 4DD1TI0NS";
$lang['ipaddressbandeletions'] = "iP 4dDR3sS 8@N D3Le+1ON5";
$lang['threadtitleedits'] = "tHr3AD +1+LE ED1+S";
$lang['massthreadmoves'] = "m4\$S +HR34d MOve5";
$lang['foldercreations'] = "f0lD3r crE@tI0nS";
$lang['folderdeletions'] = "f0LD3r d3l3+1oN\$";
$lang['profilesectionchanges'] = "pR0FIl3 s3CTIon Ch@NgES";
$lang['profilesectionadditions'] = "pr0f1LE S3C+10N @Dd1tiON\$";
$lang['profilesectiondeletions'] = "profil3 S3CTI0n dEL3+1onS";
$lang['profileitemchanges'] = "pr0f1le I+3m CH4N9E\$";
$lang['profileitemadditions'] = "pRoF1LE i+eM 4dDITI0N\$";
$lang['profileitemdeletions'] = "pRoPhIL3 I+3m D3Le+1oNS";
$lang['startpagechanges'] = "sT4rT p49E Ch@N935";
$lang['forumstylecreations'] = "f0rUM S+yL3 crEA+1ON\$";
$lang['threadmoves'] = "thr34D MOV35";
$lang['threadclosures'] = "tHre@D cL0sURES";
$lang['threadopenings'] = "thre4d OPenIN9S";
$lang['threadrenames'] = "thREAd R3N@m3s";
$lang['postdeletions'] = "p0st D3Le+1oNS";
$lang['postedits'] = "pos+ Ed1+s";
$lang['wordfilteredits'] = "w0rD FILtER 3d1+\$";
$lang['threadstickycreations'] = "thr34d S+1cKy Cr34t10NS";
$lang['threadstickydeletions'] = "tHrEaD \$tICKY DelE+10nS";
$lang['usersessiondeletions'] = "u\$eR \$3\$sION DELE+10N\$";
$lang['forumsettingsedits'] = "fOrUM \$3++1NGs ED1T\$";
$lang['threadlocks'] = "tHR3@D l0cKS";
$lang['threadunlocks'] = "tHREAd UNLOcKS";
$lang['usermasspostdeletionsinathread'] = "u\$3R m4sS PO5+ DeL3T1oNS in @ THR3AD";
$lang['threaddeletions'] = "thrE4D d3lE+10N\$";
$lang['attachmentdeletions'] = "at+4CHmen+ DElE+1oN\$";
$lang['forumlinkedits'] = "f0rUM linK ED1T\$";
$lang['postapprovals'] = "post @pPROv4L\$";
$lang['usergroupcreations'] = "us3R GroUP CR34TIoN\$";
$lang['usergroupdeletions'] = "u\$ER 9r0up D3L3+1ON\$";
$lang['usergroupuseraddition'] = "u\$er 9RoUP uS3r @DDi+1oN";
$lang['usergroupuserremoval'] = "u\$ER 9roUP Us3r R3MOv4L";
$lang['userpasswordchange'] = "us3R P4\$sW0RD CH4NGE";
$lang['usergroupchanges'] = "uS3r 9rOUP cH4N9E\$";
$lang['ipaddressbanadditions'] = "iP 4DDrESS 8AN 4dD1+1ONS";
$lang['ipaddressbandeletions'] = "ip 4dDRE\$s B4N d3l3TION\$";
$lang['logonbanadditions'] = "l0gon 8@N @DDI+1on\$";
$lang['logonbandeletions'] = "l090N B4N d3L3TIOn\$";
$lang['nicknamebanadditions'] = "nicKn@Me 8@N 4DD1T10NS";
$lang['nicknamebanadditions'] = "nicKN@ME b4n AddI+10NS";
$lang['e-mailbanadditions'] = "e-mAIL 8@N aDD1TIOns";
$lang['e-mailbandeletions'] = "e-mA1L B4N deL3+I0NS";
$lang['rssfeedadditions'] = "r\$S ph33d 4DDI+ION\$";
$lang['rssfeedchanges'] = "rSs pheED chAng3S";
$lang['threadundeletions'] = "tHRe@d UND3LE+1Ons";
$lang['httprefererbanadditions'] = "h++P R3f3rER 84N aDD1TI0N5";
$lang['httprefererbandeletions'] = "ht+P RephErER 8aN DElETI0N5";
$lang['rssfeeddeletions'] = "rSS f3eD deLE+IONS";
$lang['banchanges'] = "b@n CH4N93\$";
$lang['threadsplits'] = "tHr34D Spl1+S";
$lang['threadmerges'] = "thRE@D m3r93\$";
$lang['forumlinkadditions'] = "f0rUM L1Nk 4dDI+10NS";
$lang['forumlinkdeletions'] = "fORUM l1NK d3l3T1oN5";
$lang['forumlinktopcaptionchanges'] = "fORUm L1NK +0p C@pTI0N cHaNGEs";
$lang['folderedits'] = "fOLD3R 3d1+s";
$lang['userdeletions'] = "u53R D3l3+1ON\$";
$lang['userdatadeletions'] = "u53R D4+4 D3LE+iON\$";
$lang['usergroupchanges'] = "u53R 9ROUP Ch4N9ES";
$lang['ipaddressbancheckresults'] = "ip 4DDR3sS B4N ChECk RESUl+S";
$lang['logonbancheckresults'] = "lO90n B4N cH3CK r3sULts";
$lang['nicknamebancheckresults'] = "n1CKN@mE 8@N ch3cK rESul+s";
$lang['emailbancheckresults'] = "em4Il 84N CHeCK R3SULTs";
$lang['httprefererbancheckresults'] = "hTTP R3PHER3R 84n chECk RE\$UL+s";

$lang['removeentriesrelatingtoaction'] = "r3MOVE eNTR1eS R3lA+1NG tO 4CTi0n";
$lang['removeentriesolderthandays'] = "rEm0V3 ENtR13S OLd3r +H@N (DAys)";

$lang['successfullyprunedadminlog'] = "sucC3\$sPHULlY PrUn3d 4dMIn lOG";
$lang['failedtopruneadminlog'] = "f4il3D +0 pRUN3 @DmIN lo9";

$lang['successfullyprunedvisitorlog'] = "sUcC3\$5fULlY PrUN3D vi\$1+OR LOG";
$lang['failedtoprunevisitorlog'] = "f41L3D +o PruNE VI\$1T0R Lo9";

$lang['prunelog'] = "pRUNE log";

// Admin Forms (admin_forums.php) ------------------------------------------------

$lang['noexistingforums'] = "no 3xI\$+1N9 ph0RUM\$ PhoUND. +0 crE4T3 @ N3W f0RUM CL1CK +3H '@dD NeW' bU++On 8EL0W.";
$lang['webtaginvalidchars'] = "wE8t49 C@N ONlY COn+@1N upPerCA\$3 4-Z, 0-9 ANd UNdER\$Cor3 CH@R@c+3R\$";
$lang['databasenameinvalidchars'] = "d4+AB@se N4mE C@N OnLY c0n+41N 4-z, 4-Z, 0-9 ANd uNd3RsCOR3 CH4R4C+3RS";
$lang['invalidforumidorforumnotfound'] = "inV@lID PhoRUm pHID or FORuM N0T PH0UND";
$lang['successfullyupdatedforum'] = "sUcCE\$spHulLY UPD@T3D PhoRUm";
$lang['failedtoupdateforum'] = "f4iL3D +0 Upd4TE fORuM: '%s'";
$lang['successfullycreatednewforum'] = "succ3SsPHulLY CR34T3d neW f0rUM";
$lang['selectedwebtagisalreadyinuse'] = "th3 S3L3c+ED weB+ag i\$ 4LRE4Dy IN US3. pLE4sE ch00\$3 4N0+Her.";
$lang['selecteddatabasecontainsconflictingtables'] = "teh \$3L3CTEd D4+@8A\$E C0N+@IN\$ COnpHlIC+1N9 T4BLE5. c0NFL1C+1N9 T@8lE NaMES @RE:";
$lang['forumdeleteconfirmation'] = "aRe J00 SUre j00 W@N+ +O deLE+3 4Ll 0f Teh \$eLEcT3D ph0RUM\$?";
$lang['forumdeletewarning'] = "pL34s3 No+3 +H@+ J00 CanNOT rEc0VEr D3LE+3d phORuMs. 0Nc3 D3l3+3d @ ph0RUM 4ND @lL of +H3 4ssoc1A+Ed D4+@ 1s pERM4nen+ly REM0VEd fROm Th3 D@T48A\$3. 1pH J00 do N0T W1\$h +O dELE+e +he s3L3C+3D ph0RUM\$ Ple@S3 CL1ck C@nC3l.";
$lang['successfullyremovedselectedforums'] = "sucC3\$5FULLy d3leTED 53leCt3D phOrUMS";
$lang['failedtodeleteforum'] = "f@iL3D +O d3LE+3d F0RUM: '%s'";
$lang['addforum'] = "aDd PH0RUm";
$lang['editforum'] = "ed1+ f0RUM";
$lang['visitforum'] = "vi5I+ F0rum: %s";
$lang['accesslevel'] = "acCesS leV3L";
$lang['forumleader'] = "fOrUM L3ad3r";
$lang['usedatabase'] = "uS3 D@t4B4S3";
$lang['unknownmessagecount'] = "uNkNOwn";
$lang['forumwebtag'] = "forUM w38T@G";
$lang['defaultforum'] = "dEpH4uLt PhoRUM";
$lang['forumdatabasewarning'] = "ple@\$3 3NSUr3 J00 S3LEc+ THE cORRec+ D4+@8@S3 WH3N cR34TIN9 @ NEW FORum. 0NC3 Cr3@TED @ neW F0rum c4nN0T 83 M0VEd BE+W33N 4v@Il4bLE d4t@84\$3\$.";

// Admin Global User Permissions

$lang['globaluserpermissions'] = "glo84l U\$3R PERMi\$s10N\$";

// Admin Forum Settings (admin_forum_settings.php) -------------------------------

$lang['mustsupplyforumwebtag'] = "j00 MU5T sUPPlY A foRUm W38+4g";
$lang['mustsupplyforumname'] = "j00 MUSt SUPPlY @ PHorUM n@M3";
$lang['mustsupplyforumemail'] = "j00 MUSt sUPplY 4 Ph0rUM em41L 4DDRes5";
$lang['mustchoosedefaultstyle'] = "j00 MU\$t CH0o\$E A d3PH@uL+ PHORUM \$tYL3";
$lang['mustchoosedefaultemoticons'] = "j00 MUSt CH0OSE d3pH4ULt Ph0ruM 3M0+1CON\$";
$lang['mustsupplyforumaccesslevel'] = "j00 MU\$T SUPpLY 4 pHORuM 4Cc35s L3V3L";
$lang['mustsupplyforumdatabasename'] = "j00 MUSt SuPPLY a PHOruM d4T4BA\$3 NAM3";
$lang['unknownemoticonsname'] = "uNkN0WN eM0+1C0NS n@M3";
$lang['mustchoosedefaultlang'] = "j00 Mu5t chO0\$E 4 depH@uL+ fORUm L4NGU@GE";
$lang['activesessiongreaterthansession'] = "ac+IV3 \$3\$s10n t1m30u+ c4NNO+ BE gR3@T3R +h4N S3SS1on +1ME0ut";
$lang['attachmentdirnotwritable'] = "a+t4CHm3n+ D1reC+OrY @ND sYS+3M +3MP0R4RY D1RECtORY / phP.1nI 'UPloAD_tMP_d1r' mUS+ B3 Wri+A8LE BY TeH WeB \$3RVer / PHP pROC3ss!";
$lang['attachmentdirblank'] = "j00 MusT suPPly @ d1rECtoRy +O s@V3 4+t4cHm3n+S 1N";
$lang['mainsettings'] = "m41N s3++1N9S";
$lang['forumname'] = "f0rUM n@ME";
$lang['forumemail'] = "f0RUM eMAil";
$lang['forumnoreplyemail'] = "n0-R3pLY 3M@1L";
$lang['forumdesc'] = "f0ruM D3sCrIPtiON";
$lang['forumkeywords'] = "f0ruM K3yW0rdS";
$lang['defaultstyle'] = "d3fAULT sTyLE";
$lang['defaultemoticons'] = "d3phAULT eM0+1COn\$";
$lang['defaultlanguage'] = "defAULT lAn9U493";
$lang['forumaccesssettings'] = "f0ruM 4cCess \$ETTin9S";
$lang['forumaccessstatus'] = "fORUM 4Cc3\$5 S+4+us";
$lang['changepermissions'] = "ch4n93 P3RmiSS10N\$";
$lang['changepassword'] = "ch@NgE P@S5WORd";
$lang['passwordprotected'] = "p45sw0RD Pro+EcTED";
$lang['passwordprotectwarning'] = "j00 h4v3 NO+ S3+ 4 PhORUm P@\$sW0RD. IpH j00 D0 NO+ 5E+ a P4SsWoRd THe P4\$SW0RD PR0T3C+1oN FuNCtIONAl1+Y wILl BE 4U+oM@tIC4LLy Di\$@blED!";
$lang['postoptions'] = "pOs+ Opt1on5";
$lang['allowpostoptions'] = "aLL0W POST 3dI+1N9";
$lang['postedittimeout'] = "pOsT 3di+ tiM30uT";
$lang['posteditgraceperiod'] = "p05t 3D1+ GR4CE p3rIOD";
$lang['wikiintegration'] = "wik1WIK1 1N+3GR4T1On";
$lang['enablewikiintegration'] = "en@BlE W1KIW1KI IN+39r4+10n";
$lang['enablewikiquicklinks'] = "enaBLE WIK1W1Ki Qu1cK l1NK\$";
$lang['wikiintegrationuri'] = "wikIW1KI lOC4T10N";
$lang['maximumpostlength'] = "m@X1Mum PO\$T leN9+H";
$lang['postfrequency'] = "pO\$T PHR3Qu3NCY";
$lang['enablelinkssection'] = "eNaBLE L1NK\$ s3CTI0n";
$lang['allowcreationofpolls'] = "aLLoW cR3@tI0N 0F polLS";
$lang['allowguestvotesinpolls'] = "alloW 9uEST5 T0 VO+3 In P0LLS";
$lang['unreadmessagescutoff'] = "unrE@D M3SSA9eS CU+-0pHPH";
$lang['disableunreadmessages'] = "d1S4BL3 UNRe4d M3sSAGes";
$lang['thirtynumberdays'] = "30 D@YS";
$lang['sixtynumberdays'] = "60 D@ys";
$lang['ninetynumberdays'] = "90 D@YS";
$lang['hundredeightynumberdays'] = "180 d4YS";
$lang['onenumberyear'] = "1 ye@R";
$lang['unreadcutoffchangewarning'] = "d3pEND1nG 0n \$3Rv3r PERfoRM@ncE 4ND +He NUm83R 0PH +hrE4d\$ y0uR F0RUMS c0nT@iN, cH@nGin9 THE uNR3@D Cut-oFPH m@Y +@kE \$3v3R4L MiNU+3\$ +O coMPL3+3. pH0R +hi\$ REaS0N It 1s R3C0MM3ND3d TH@T j00 AV0Id CH@ngIN9 THis \$ETTinG WH1LE y0UR FOrumS AR3 8U\$y.";
$lang['unreadcutoffincreasewarning'] = "incr34SIN9 +3H uNR34D cUT-oFF wiLL R3sULt 1N +hR34DS 0LD3R Th4n +h3 CUrr3NT CUT-opHf 4PP34R1N9 aS UnR34D Ph0R @LL uSErS.";
$lang['confirmunreadcutoff'] = "aRE j00 \$ur3 J00 W@n+ +O cH4NGE +H3 UNrE@D CU+-0FF?";
$lang['otherchangeswillstillbeapplied'] = "cLIck1nG 'No' W1LL onLy CAncEL Teh UNre@D cu+-0PHPH Ch@NgeS. O+H3R CH4Nges Y0U'V3 M@de WIll S+1ll B3 \$@VED.";
$lang['searchoptions'] = "s3aRCh 0PTioN\$";
$lang['searchfrequency'] = "searCH phR3QUENcy";
$lang['sessions'] = "sess10N\$";
$lang['sessioncutoffseconds'] = "sEsSI0N cu+ oFF (S3CONDS)";
$lang['activesessioncutoffseconds'] = "aCt1VE \$3\$s1oN cu+ oPHph (\$3CONds)";
$lang['stats'] = "s+a+S";
$lang['hide_stats'] = "hiD3 S+a+S";
$lang['show_stats'] = "shOW S+4+S";
$lang['enablestatsdisplay'] = "en@BL3 \$t4+S d1spL4Y";
$lang['personalmessages'] = "p3r5oN4L mESS@ge\$";
$lang['enablepersonalmessages'] = "eN@8L3 PerS0N4L m3sSA9ES";
$lang['pmusermessages'] = "pM M3\$SAGe5 PEr U\$3r";
$lang['allowpmstohaveattachments'] = "all0w PeRSON4L meSS493s +o H4V3 4+T@cHMEn+S";
$lang['autopruneuserspmfoldersevery'] = "au+o PRUn3 U\$3R'\$ Pm PHOlD3r\$ eV3RY";
$lang['userandguestoptions'] = "u\$3R aND gUE\$T oP+10NS";
$lang['enableguestaccount'] = "enaBlE GUe\$+ aCC0Un+";
$lang['listguestsinvisitorlog'] = "lIsT 9uesTs 1N Vi51+0R lOg";
$lang['allowguestaccess'] = "aLlOW GU3s+ 4CCe\$\$";
$lang['userandguestaccesssettings'] = "u\$3R 4nD guE5+ 4cc3sS 53Ttin9s";
$lang['allowuserstochangeusername'] = "aLlOW u\$3r5 +0 ch@NGe Us3Rn4M3";
$lang['requireuserapproval'] = "r3qu1RE uS3r 4PPR0V4l 8Y 4dmIn";
$lang['requireforumrulesagreement'] = "r3QU1Re u\$ER +O 49R3E TO pHoRUM RULes";
$lang['sendnewuseremailnotifications'] = "senD No+1pHic@ti0n +o 9l084l PHOrum 0WnER";
$lang['enableattachments'] = "eN48le 4+t@chMentS";
$lang['attachmentdir'] = "a+t@chMENT d1r";
$lang['userattachmentspace'] = "a++4CHM3Nt 5P@C3 P3R USEr";
$lang['allowembeddingofattachments'] = "aLl0w 3M8EDD1ng 0PH 4+T@CHm3n+S";
$lang['usealtattachmentmethod'] = "u\$e 4L+3RN4+1Ve 4TT@cHM3Nt m3+HOd";
$lang['allowgueststoaccessattachments'] = "all0w 9uEs+S +O @cCESS a++@Chm3NTS";
$lang['forumsettingsupdated'] = "f0ruM 5E+t1nG5 \$ucC3SSFUllY upD4T3d";
$lang['forumstatusmessages'] = "f0rUM 5+a+US M3SS49ES";
$lang['forumclosedmessage'] = "f0rUM ClO\$3D me\$S@9E";
$lang['forumrestrictedmessage'] = "forUM R3STr1ctEd ME\$s@G3";
$lang['forumpasswordprotectedmessage'] = "forUM p4\$sW0RD pRo+EC+eD mE\$\$4g3";

// Admin Forum Settings Help Text (admin_forum_settings.php) ------------------------------

$lang['forum_settings_help_10'] = "<b>pO5t 3D1T TIme0U+</b> I\$ THe +ImE 1N m1nU+ES 4PHTer p0sT1N9 TH4T 4 U53r C4N 3D1+ thE1R P0ST. iPH s3+ +O 0 +hER3 IS n0 LImi+.";
$lang['forum_settings_help_11'] = "<b>m@X1MUM PosT l3N9TH</b> iS +HE M4xIMum nUM83R 0f Ch@R@cTERS TH@T W1ll B3 DisPl@Y3D IN 4 po\$t. 1Ph 4 P0S+ i\$ LONgeR tH@N The nUMbeR of cHAr4c+3R\$ DePHiNED hERe I+ WilL 83 CuT Sh0r+ 4Nd 4 L1nk 4DD3D +O +3H B0++OM +O @LLOw US3R\$ T0 R34D tHE WH0L3 P0ST oN @ sEP4r4t3 P49E.";
$lang['forum_settings_help_12'] = "if j00 D0N'+ W4N+ yOUR uS3R\$ +0 83 48LE +0 CRea+3 p0lL5 j00 C@N dISA8L3 THe @B0VE 0pTION.";
$lang['forum_settings_help_13'] = "t3h L1Nk\$ 53CTI0N 0PH B3EH1V3 pR0VIdE\$ 4 pl4CE f0R yoUr USErs TO m@IN+a1n 4 LisT of \$1+es +hEY PHr3qUENTlY v1s1T +H4+ 0TheR uSErs M4Y f1ND u\$3fUL. L1NK\$ c@N BE d1vIdeD 1NT0 c4TE90r1eS by F0Lder @ND 4lLOw PHOR c0mMENts 4ND r4TIn9s +0 8E 91VEn. in ORDer tO MOdER4+3 TEh LInkS S3C+1oN @ us3r mUst 8E R4Nt3d 9LOB4l MODEr@T0R \$T4+US.";
$lang['forum_settings_help_15'] = "<b>se\$S10n cUT OFF</b> iS ThE max1MUM +1mE BEPhoR3 4 U\$3r'S 5eSS10N is De3m3D d3@d 4ND theY @r3 LOG93D OU+. 8Y D3fAUL+ tHI5 i5 24 H0UR\$ (86400 \$eC0nDS).";
$lang['forum_settings_help_16'] = "<b>ac+IVe \$E\$s10N CU+ 0Ff</b> Is +H3 M4xiMUM TIm3 BEPHorE 4 U\$3r'5 \$essi0N 1s DE3MeD 1NACtiVE 4+ WHicH P0INT +H3Y 3NT3R 4n 1DLE \$+@t3. IN th1\$ St4te TH3 U\$3R reM@1NS l099ED in, 8u+ th3y 4rE R3MOVED PHrom ThE @ctIVE USer\$ Lis+ In +he ST4TS d1\$PL4Y. oNC3 +h3Y 83COM3 ACtiVe 4941N +h3y WILl 8e R3-@dDEd T0 THE L1St. BY D3f4UL+ +H1S \$3+TIng i\$ S3+ +o 15 M1NU+e5 (900 s3C0nD\$).";
$lang['forum_settings_help_17'] = "en48Lin9 +H1\$ 0P+10N @Ll0WS BeeH1V3 T0 InCLuD3 4 St4+S dISPl4y 4+ +hE b0++0M 0pH THE meSs49E5 P4N3 S1MIl4r t0 +he ON3 usEd 8Y M4NY FORUm SOF+w@R3 Ti+lES. onCE eN48LED TEh d1spL@y 0f tEH St4+S p49E c4n BE T099L3D 1ND1VIdU@llY 8Y 3@Ch U\$3r. 1f +h3y d0N'+ want +0 S33 I+ TH3Y c4N h1d3 I+ FROm V1EW.";
$lang['forum_settings_help_18'] = "pER50NAl M3sS493\$ ar3 1nV4LU@BL3 A5 4 W@Y 0F t@KIn9 MOr3 PR1V4T3 MA+T3R\$ 0UT OF VIew 0F +h3 OTh3r meMbeR\$. H0W3V3R 1F J00 don't WaN+ yoUR U\$3RS +o 83 4BLE +O S3ND 34CH 0+H3R pER\$ON4L me\$54g3S j00 C4N dI548LE th1S 0P+i0n.";
$lang['forum_settings_help_19'] = "p3r5on4L Mes\$@GE\$ C4N 4LS0 c0NT41N 4Tt@CHmEN+s WH1ch CaN 83 US3FUL FoR 3xCH4n9in9 FIl3s 8E+wEEN uSER5.";
$lang['forum_settings_help_20'] = "<b>nOT3:</b> +h3 \$P@C3 4LL0CA+10N F0R Pm 4+TAcHM3N+s iS +4K3N PHRom E4CH usER\$' M4in a+T@cHM3nT 4Ll0C@Ti0N @nd 1\$ N0+ iN 4DD1TIoN To.";
$lang['forum_settings_help_21'] = "<b>en@8l3 GU3St @cCOUN+</b> 4lLOws V1\$itOR\$ +0 8R0w\$3 yoUR f0RUM 4nD Re4d P05+S w1+HOU+ R3G1STErIn9 4 us3R 4CC0UN+. 4 U5ER @CC0UNt 1\$ ST1LL R3QUiREd IF +h3Y wI5H +o P0\$T 0R cHANGe U\$3R PR3f3REnc3S.";
$lang['forum_settings_help_22'] = "<b>li\$+ 9U3sT5 IN VI\$1T0R Log</b> 4LL0WS j00 +o \$PEcIFY Wh3+H3R 0R noT UnrE9ISteR3D u\$3R\$ 4RE lI\$t3d 0N +hE V1\$1T0R L09 @loNG51DE R3GISt3r3D U\$3RS.";
$lang['forum_settings_help_23'] = "be3H1VE 4lLOw5 4TT@cHmenTs T0 8E UPlo4DED +o m35s493\$ Wh3n P0\$+3d. IpH j00 H@V3 liMI+3d W38 SPac3 J00 M@Y WhiCH +0 DI\$@8LE 4+t4cHM3NT\$ BY CLE4RIn9 ThE B0x 480VE.";
$lang['forum_settings_help_24'] = "<b>a++@ChMENT d1R</b> 1S +h3 LOc@Ti0n 8E3H1V3 SHOulD St0r3 4TT@CHMeN+s 1N. tHIS DIR3C+oRY mU\$+ exI\$+ 0N yOUR W38 \$p4CE And Mu\$+ bE WrI+48LE bY +h3 W3B S3Rv3R / pHP ProC3\$S 0ThERWis3 Upl04DS w1lL Fa1l.";
$lang['forum_settings_help_25'] = "<b>a++@CHM3NT SpAc3 PEr u\$3R</b> 1\$ +h3 M@x1MUm 4MOUN+ 0pH d1sk SP@CE 4 U\$3r H@S F0R 4TT4CHm3nTS. ONCe +h1s sP4C3 Is u\$3D Up +He US3R CaNN0+ UpL04D @nY Mor3 A+t@ChmEnTS. bY D3FAULt This i\$ 1MB 0f \$P4C3.";
$lang['forum_settings_help_26'] = "<b>all0w EMb3DDIn9 Of A++@CHMEn+S In Me\$s@93S / s19N@TUR3s</b> ALLOw\$ useR\$ +O 3M8ED 4tT4CHm3nT\$ IN p0s+S. en@8LiN9 thI\$ oP+10N WH1LE uS3FUL cAn INcr3aSE Your 8@NDw1dTH US@Ge DR@s+1C@LlY UNd3r c3rT41N coNpHigUR4T10N\$ 0ph php. 1ph J00 H@Ve L1MI+eD 8ANDW1D+H 1T 1s R3COmm3NDeD +H@T J00 D1s48L3 +h1s 0P+i0n.";
$lang['forum_settings_help_27'] = "<b>u\$E AltErn@+IV3 4+T4CHmeNT m3+HOd</b> F0RC35 B33HIVe +O usE 4N Alt3RN4TIve R3+R1eVal M3+H0D phOR A+T@chM3NTS. IF j00 R3CEIv3 404 3RRor m3\$S@93s WHen +ry1NG to D0WNLO@d @t+ACHmENts FR0M M3SS4GE\$ +rY 3NAbL1N9 THi\$ 0P+10N.";
$lang['forum_settings_help_28'] = "theS3 \$ET+iNgs alL0W5 YOuR PhorUM +0 83 \$pIDerED 8y sE4Rch 3N91NES l1kE g0ogLE, 4l+4V1ST4 AnD Y@HO0. IPh J00 SWiTCH TH1\$ OPT10n oFPh YOUR F0rUM W1LL noT 8e 1NCluDEd iN ThESE \$3ARch 3N9IN3\$ RESUL+s.";
$lang['forum_settings_help_29'] = "<b>aLL0W NEW Us3r RE91sTRA+10n\$</b> 4LlOWS 0R Dis4llOW\$ +3H cRE@t10n OF neW u\$3R aCCOUn+S. seT+1nG +3H 0PtioN tO nO C0MPl3t3LY DI\$@Bl3s T3H rEG1\$Tr4t1ON f0RM.";
$lang['forum_settings_help_30'] = "<b>eN48lE w1K1W1KI iN+3Gr4+10N</b> proV1D3S W1KIWoRD \$upP0RT 1n yoUr fORUM pOSTS. 4 W1KIw0rD 1\$ MAdE UP 0pH tW0 0R m0RE ConC@+3n4t3D w0rDS w1+H UpPErc4SE Le++3R\$ (Oft3N R3Ph3rr3D +o A\$ C4mELc@\$3). if J00 Wri+E 4 w0RD +hi\$ w@Y i+ W1LL 4u+0M4+1C4lLY Be Ch4n9eD 1N+0 @ hYperL1NK p01N+1N9 TO yoUR chOs3N wIK1W1KI.";
$lang['forum_settings_help_31'] = "<b>eN@bLE w1k1WIk1 QUiCK liNKS</b> eNABlE5 TeH US3 0PH M\$9:1.1 AnD U\$3R:l0goN \$TylE 3X+3Nd3d W1K1l1nk5 WH1ch cRE4T3 HyP3RL1NKS +0 +hE Sp3c1PHIeD M3SS@G3 / u5eR PR0F1L3 OPH THe \$PeCIF13D U5ER.";
$lang['forum_settings_help_32'] = "<b>w1K1WIk1 L0C@+i0N</b> IS U5ED +O \$p3C1phY +he Ur1 OF YOUR W1K1W1KI. Wh3n EN+3RIn9 tEH Uri US3 <i>%1\$\$</i> T0 INdICa+3 WH3RE iN +eh Ur1 tHE WIkiw0RD sH0ULD ApP34R, 1.3.: <i>hT+P://EN.wIk1PEDi4.0R9/Wik1/%1\$s</i> W0uLD lINk YOuR W1KIW0RDS TO %s";
$lang['forum_settings_help_33'] = "<b>foruM @cCESS s+@+uS</b> C0N+r0lS hOW us3rS MAy ACc3ss yoUr PH0Rum.";
$lang['forum_settings_help_34'] = "<b>oPEN</b> WIll @ll0W @LL us3RS @nD GueSTS 4Cc3ss +O YOUr F0RUM WI+HOUT R3STR1CTi0N.";
$lang['forum_settings_help_35'] = "<b>closED</b> prEVen+s aCc3SS foR 4lL u5Ers, W1+H +H3 eXC3PtI0N Of +H3 adM1N whO m4Y stILl @cCE\$5 th3 @DM1N p4NeL.";
$lang['forum_settings_help_36'] = "<b>resTricT3D</b> 4lL0w\$ +o s3T 4 L1sT oF u\$ERS wHO @RE 4LloW3D @cc3sS +o Y0UR Ph0rum.";
$lang['forum_settings_help_37'] = "<b>p@\$swORD Pro+ECted</b> ALl0Ws J00 +0 5E+ 4 P4sSwoRD t0 G1v3 0U+ +O u\$Er5 so th3Y c4n 4CCES\$ y0Ur f0RUm.";
$lang['forum_settings_help_38'] = "wheN 53Tt1Ng R3\$+R1CTed OR p@SSWOrd Pro+ecT3D m0dE j00 wILl NEed +O 54V3 YouR cH4NgeS b3F0RE j00 C4n CH4n9e t3H US3r @cC355 pR1v1Leg3\$ 0R P@Ssw0RD.";
$lang['forum_settings_help_39'] = "<b>Search Frequency</b> defines how long a user must wait before performing another search. Searches place a high demand on the database so it is recommended that you set this to at least 30 seconds to prevent \"search spamming\"frOM kILL1n9 T3H sErv3R.";
$lang['forum_settings_help_40'] = "<b>p05+ Fr3qU3NCY</b> 1s THe M1NiMuM TiME 4 U\$3R Mu\$T w@1+ B3f0r3 +H3Y c@N P0s+ 494In. THi\$ 5E+TIn9 4L\$0 @pHPheC+S thE CR34T10N OF poLls. s3+ +0 0 TO di\$@8lE tHE R3S+RIcTI0N.";
$lang['forum_settings_help_41'] = "teh @b0v3 0p+1oN\$ CH4NGE +3H DepH@UL+ v@Lu3s FOR TEH US3R Re91\$TR4TI0N PH0RM. WH3RE 4PPL1c4blE 0Th3R S3TTInGS wILl U\$3 +3H ForUM'S OWN d3PH@uL+ s3+TIn9\$.";
$lang['forum_settings_help_42'] = "<b>pR3VENt u\$3 oPH DUPL1C@tE Em41l @DDR3ss3S</b> FORCe\$ beEHiVE to chECK +He US3R @CC0UNt\$ @941NS+ +3H eMAiL 4DDre5s The US3R 1s R3G1S+3RInG w1+H 4Nd PRomPt\$ +h3m +0 US3 4N0+Her iF I+ I\$ @LReaDY 1n uSE.";
$lang['forum_settings_help_43'] = "<b>requIRE em4IL cONFiRM4T10N</b> whEN 3N4BL3D wILl \$3ND aN 3M@1L tO e4cH N3W us3R w1+H 4 LiNK +h@T CaN bE u\$3d T0 CoNF1RM +H31R EM@il @DDr3sS. un+1L +HEy C0NFiRM +H31R 3maIL ADDR3SS THeY WIlL N0T 83 48L3 +O P0\$+ UnL3Ss +H3IR usER P3RMi\$\$1ONS 4RE cH4N9ED m4NU@LLY bY @n ADm1N.";
$lang['forum_settings_help_44'] = "<b>usE Tex+-caP+cH@</b> Pr3sEN+s TH3 New U5ER w1+h @ MAN9L3D 1M@Ge WhICH THeY Mu\$T C0py @ NUM83R pHROM iNTO 4 +3X+ Ph1eLD ON TEH R3g1\$+RA+10N F0RM. U\$3 +His 0Pt1on +0 pr3VENT @UTOm4T3d S1GN-up V1@ Scr1P+S.";
$lang['forum_settings_help_47'] = "<b>p0\$+ ED1+ gR4CE p3RIOd</b> 4lLOWS J00 +O DefIne a pERi0d 1N m1nUT3s WherE US3rs M@Y Ed1+ PosT\$ w1+HOu+ +eH 'ED1T3D bY' T3xT 4Ppe4RIn9 ON +H31R p0s+S. IF \$3+ +0 0 Teh '3DitED bY' +3xT wILl @LW@YS aPP34R.";
$lang['forum_settings_help_48'] = "<b>uNRE4d meSSagES cU+-OFF</b> 5peCIFIes H0W l0nG mE5\$@ges r3m4iN unREaD. +HReAD\$ MOd1f1eD NO l4+3R +h@N TH3 p3RI0D S3LEC+3D W1LL 4u+OM4+1C4LLy 4PP34R @S R34D.";
$lang['forum_settings_help_49'] = "chOO\$inG <b>d1S48LE UnR3AD mESS4g3s</b> W1LL cOMPl3+3LY Rem0VE UNr34d M3ss@9eS \$upPOR+ AND reM0VE +H3 RElEV4NT Op+10NS PhROM +h3 D1\$CUSs10N +yP3 Dr0p D0WN oN thE +hRE4D Li5t.";
$lang['forum_settings_help_50'] = "<b>r3quiRE uS3R @PProv4L By @dMIN</b> 4LloW\$ J00 TO rES+rICt 4CC3Ss BY nEw US3R\$ uNT1L tHEY H4V3 8E3N 4PprOVeD 8Y 4 M0DEr@+Or 0R 4DM1N. W1+hoU+ 4PPr0V4L 4 U\$3R C4nN0T 4CceSS aNY @r34 0f ThE B3EH1V3 PhoRUm IN\$t@Ll4+10N inclUDin9 INDiv1Du@l FORUms, pM inBOX anD MY pHORUms \$3CTI0NS.";
$lang['forum_settings_help_51'] = "us3 <b>cL0sED m3\$S@9E</b>, <b>r3sTR1c+3d M3\$549E</b> 4ND <b>p4SSWOrd pRO+Ec+3d M3Ss@93</b> +0 CusTOmisE TH3 M3SS4GE dI5PL@Y3D WHeN u\$ER\$ 4CC3sS Y0Ur PH0RuM iN +eh V4R10US 5+4+3\$.";
$lang['forum_settings_help_52'] = "j00 c4n USE h+Ml In y0UR mE5s4GE\$. HYp3rL1NK\$ @nd 3MAil 4DDr3ssES W1LL 4L5O B3 4u+Om4+1C4LLy CONV3rtED to LinK\$. +0 USE +HE D3PH4ULt B33h1Ve FORUM mESS4G3S Cl34r ThE F1ELDS.";
$lang['forum_settings_help_53'] = "<b>all0w U\$Er\$ TO ch4nGE u5erN4ME</b> PERm1+S 4LRe4dy R39I\$+3R3D USERS +O Ch4n93 +h31r usERN4M3. wHEN ENAbL3d J00 c4n +rACK t3H CH4N9ES 4 U\$3r m4k3s +0 +hE1r USERn4ME vi4 T3H aDm1N US3R +OOLS.";
$lang['forum_settings_help_54'] = "us3 <b>f0RUM rUle\$</b> T0 3NT3R 4N 4Cc3P+@8LE uSE pOLIcY Th4t 34CH us3r MusT aGR33 T0 B3FOR3 rE915+3RIn9 ON y0uR pHORUM.";
$lang['forum_settings_help_55'] = "j00 CAn U\$3 h+ml 1N YouR FORUm RULEs. hyPErL1NKS 4nD 3M@1l @DdR3sS3s wILL @LSO 83 4U+0M4tIC@lLY coNVer+3D to L1NKS. +O u\$3 +h3 DEFAul+ B3Eh1v3 FORuM aup Cl34r +hE F1ELD.";
$lang['forum_settings_help_56'] = "use <b>nO-R3PLy EM@il</b> TO sp3c1fY @N 3mAIL ADdrE\$S +H@t dO3s N0t 3x1\$+ 0r W1LL NO+ 83 M0N1+oR3d F0r r3pL13\$. thIs 3mAIL AddRes5 W1LL 83 US3d IN TEH HE@D3r\$ pH0r 4lL EM41LS SENT PHR0M YouR F0rUM 1NCLud1NG 8u+ NO+ L1MI+3D To PO5+ AnD PM noTIfiC4TIOn\$, us3R 3MAil\$ 4nd P4SSWORd rEMiND3RS.";
$lang['forum_settings_help_57'] = "i+ I\$ ReCOMM3NDEd ThAT J00 US3 4N em41L adDR3\$\$ ThA+ D03S NOT 3x1sT TO heLP CUt D0Wn ON sp@M +H@T m@y bE DIr3c+eD a+ y0uR m41N F0RUm Em@IL 4dDRES\$";
$lang['forum_settings_help_58'] = "in @DDi+10N To sImPL3 5PId3rInG, 83eH1VE cAN 4Ls0 9EN3R4+3 4 S1+3MAp Ph0r ThE F0RUm t0 M@k3 1T 3@S1ER F0R 5E4RCH ENgIN3S TO PHiND 4Nd 1NDex +h3 mES54Ges P0\$t3d 8Y youR uS3r\$.";
$lang['forum_settings_help_59'] = "s1tEMAp5 4re 4u+Om@+IC4llY 5@v3d +O th3 \$iT3M@ps \$uB-DiR3C+0Ry OPH YOuR bEEH1VE f0RUm 1N\$+4LL4+10N. 1F +h1s D1R3c+0rY D035n'T ex1\$+ J00 Mus+ cR34T3 I+ 4ND 3nSUr3 Th4+ I+ I\$ WRiT4BLe BY +3H \$3RVEr / pHP PROc3sS. +0 4LLOw S3ARcH En9INEs +O pHInD yoUr sI+eMAP J00 Mus+ aDD tH3 UrL to YOur RObo+S.+xT.";
$lang['forum_settings_help_60'] = "dEpENd1n9 0n \$3rVER pERF0RM@NCE @ND +H3 NUm8Er 0f F0RUMS 4nD thR3@D\$ YOUr bEEH1v3 iNSt4ll@+10n coNTa1nS, 93NER4TIn9 4 \$1+3MAP m4Y +4Ke s3v3R4L m1nU+3\$ +0 COmpl3+3. 1PH pERF0RM@nC3 0F Your \$3RVEr I5 4DVErs3LY Aff3cTEd I+ Is RecoMM3ND J00 D1SABle GeNERA+1ON 0F the \$1+3m@p.";
$lang['forum_settings_help_61'] = "<b>s3ND 3m4IL N0TIFIc4+10N TO GL08@L 4DMiN</b> wH3N EnaBL3D wILL \$3ND @n 3M@1L to T3H Gl08aL PH0rum 0WNER\$ wh3N @ n3w U5eR @CCOUN+ 1\$ CR3A+3D.";

// Attachments (attachments.php, get_attachment.php) ---------------------------------------

$lang['aidnotspecified'] = "a1D NO+ SP3CIpH1eD.";
$lang['upload'] = "uplO@D";
$lang['uploadnewattachment'] = "upl0@D nEW @T+AChMEN+";
$lang['waitdotdot'] = "w4i+..";
$lang['successfullyuploaded'] = "sUcCES\$phULlY UpLO@DEd: %s";
$lang['failedtoupload'] = "f4il3D T0 UPL04D: %s. CH3cK FR3E 4tT4cHm3n+ \$p4cE!";
$lang['complete'] = "cOmPLetE";
$lang['uploadattachment'] = "uplOAd 4 PH1LE f0R 4TT4CHm3n+ +0 +h3 M3\$s@Ge";
$lang['enterfilenamestoupload'] = "enTeR PHiL3N@me(5) t0 uPLO4d";
$lang['attachmentsforthismessage'] = "a+T4CHm3nTS PhoR +H1S M3\$s@93";
$lang['otherattachmentsincludingpm'] = "oth3r @++4CHm3nTS (inCluDInG PM M3sSaGe\$ @Nd OThER PhorUMS)";
$lang['totalsize'] = "tot4l S1ZE";
$lang['freespace'] = "fr3E \$P4C3";
$lang['attachmentproblem'] = "tH3RE W4s 4 Pro8L3M D0wnL04D1NG +H1\$ 4TT4Chm3N+. pl3@S3 +ry AGaIN lA+eR.";
$lang['attachmentshavebeendisabled'] = "aTt@Chm3nts H4V3 833N d154BLEd 8Y +hE F0RUm OwN3R.";
$lang['canonlyuploadmaximum'] = "j00 C4N OnlY UPLO4d 4 MAX1MUm 0f 10 FilES @T 4 tIMe";
$lang['deleteattachments'] = "del3+3 4T+aCHM3N+s";
$lang['deleteattachmentsconfirm'] = "aR3 J00 5uR3 J00 WAn+ +O D3lE+3 +Eh 53L3C+3D 4t+aChM3NTS?";
$lang['deletethumbnailsconfirm'] = "are J00 SURe J00 W4NT +0 DELE+E +3h s3lEC+3d 4T+AchM3N+S tHUM8N@1L\$?";

// Changing passwords (change_pw.php) ----------------------------------

$lang['passwdchanged'] = "p@ssWoRd Ch@Nged";
$lang['passedchangedexp'] = "y0uR P4\$Sw0RD h@\$ beEN cH@NGED.";
$lang['updatefailed'] = "upd4t3 Ph41L3D";
$lang['passwdsdonotmatch'] = "p4S5WorDS Do NO+ M4+Ch.";
$lang['newandoldpasswdarethesame'] = "n3W 4nD 0LD P4s5W0RDS @re +3H \$@M3.";
$lang['requiredinformationnotfound'] = "rEQU1REd 1NF0Rm4tI0n NO+ FOUNd";
$lang['forgotpasswd'] = "for90T p4ssWORd";
$lang['resetpassword'] = "r3\$eT p@SSWorD";
$lang['resetpasswordto'] = "r3sET p45sW0RD +O";
$lang['invaliduseraccount'] = "iNVAl1d U\$eR @ccoUN+ \$PecIF1ED. CHEck 3mA1l PHOR cORr3cT LinK";
$lang['invaliduserkeyprovided'] = "inv@LID USER kEY PROViD3D. Ch3cK EM41l F0R C0rreCT l1NK";

// Deleting messages (delete.php) --------------------------------------

$lang['nomessagespecifiedfordel'] = "nO m35s49e \$PeC1f1ED PH0R dELETi0n";
$lang['deletemessage'] = "d3l3tE m3sSAge";
$lang['successfullydeletedpost'] = "sUCC3sSFULlY D3LE+3D POST %s";
$lang['errordelpost'] = "eRr0R d3lE+iNG pOST";
$lang['cannotdeletepostsinthisfolder'] = "j00 CAnNOT d3L3+3 P0\$TS 1N tHIS F0LD3R";

// Editing things (edit.php, edit_poll.php) -----------------------------------------

$lang['nomessagespecifiedforedit'] = "n0 M3\$S@93 5PEc1PH1ED pH0R edI+1N9";
$lang['cannoteditpollsinlightmode'] = "c4nnO+ EdI+ polLS 1N lIgH+ m0D3";
$lang['editedbyuser'] = "eDI+3D: %s 8y %s";
$lang['successfullyeditedpost'] = "sUcC3\$sFUlLY 3DITeD p0\$+ %s";
$lang['errorupdatingpost'] = "eRROR upD4+1N9 p0\$+";
$lang['editmessage'] = "eDi+ mEsS@93 %s";
$lang['editpollwarning'] = "<b>nO+3</b>: ED1+1Ng C3R+a1n @\$pEC+S 0f 4 P0LL w1lL v0ID 4LL The cuRR3N+ VOtEs 4ND @ll0w P30pL3 +O VO+3 49@1n.";
$lang['hardedit'] = "h4rd eD1+ 0p+10N\$ (VO+ES wiLL 8E re\$3+):";
$lang['softedit'] = "s0phT 3DI+ 0P+10n\$ (VO+eS WiLL b3 R3T@1n3d):";
$lang['changewhenpollcloses'] = "ch4Nge Wh3n +H3 P0Ll ClosEs?";
$lang['nochange'] = "n0 chAN9e";
$lang['emailresult'] = "eM4iL reSUl+";
$lang['msgsent'] = "m3SS@93 5ENT";
$lang['msgsentsuccessfully'] = "m3ssaGE \$3N+ sUCCEsspHULLy.";
$lang['mailsystemfailure'] = "m41l \$YS+em pH@iLUrE. ME5S4gE n0T \$3n+.";
$lang['nopermissiontoedit'] = "j00 4RE N0T PeRMiTTED +0 3D1t Th1\$ M3\$54G3.";
$lang['cannoteditpostsinthisfolder'] = "j00 C@NN0+ 3D1+ P0ST\$ 1n tHI5 F0LdeR";
$lang['messagewasnotfound'] = "m3\$S@9E %s Was N0T pHOUnD";

// Email (email.php) ---------------------------------------------------

$lang['sendemailtouser'] = "sEnD eM41L +0 %s";
$lang['nouserspecifiedforemail'] = "n0 u5eR \$pEC1PHiED PH0R 3M@1LIn9.";
$lang['entersubjectformessage'] = "eNTer @ SuBJeC+ foR teh MEss@9E";
$lang['entercontentformessage'] = "eN+ER \$OME C0N+3NT PHOr +3H m3ss493";
$lang['msgsentfromby'] = "tHI5 MesS493 W4S s3n+ PHrOM %s by %s";
$lang['subject'] = "su8jECt";
$lang['send'] = "senD";
$lang['userhasoptedoutofemail'] = "%s h4s oP+eD 0Ut of Em@1L Con+aC+";
$lang['userhasinvalidemailaddress'] = "%s h4s @n 1nV4L1D eM41L aDdRESS";

// Message nofificaiton ------------------------------------------------

$lang['msgnotification_subject'] = "mE5s4GE n0t1PHiC@+1ON FR0M %s";
$lang['msgnotificationemail'] = "h3lL0 %s,\n\n%s poST3d A MES5493 T0 j00 ON %s.\n\nThe \$u8jEC+ 1\$: %s.\n\nt0 rE4D th@t MESs@93 4nD oTHEr\$ 1N +h3 S@M3 DI\$CU\$s1ON, 90 +0:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nno+3: 1PH j00 d0 NO+ w1\$H to R3CEive EM@1L N0TIf1C@+IONS OF F0rUM m3\$s@GES PO\$T3D to Y0U, G0 T0: %s CL1CK ON MY coNTROL\$ +heN EMAIl 4nD prIV4Cy, UN53LEc+ +H3 3M4IL no+1F1c4TI0N chECKb0X 4ND PRess sUBMI+.";

// Thread Subscription notification ------------------------------------

$lang['threadsubnotification_subject'] = "sub\$CR1pTi0N no+1F1C@Ti0n FRom %s";
$lang['threadsubnotification'] = "h3LL0 %s,\n\n%s P0sT3D 4 M3SSAgE 1N 4 THRE4D j00 @R3 \$uBSCrIbeD +o 0N %s.\n\n+H3 suBJ3C+ 1s: %s.\n\nTO R3aD +H@t M3SS@9e 4nD O+h3RS 1N +h3 SAMe D1\$cu5s1oN, 90 TO:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nnO+E: IpH j00 D0 No+ W1SH to r3CEIV3 EM41L noTIpHIc@T10N\$ 0F New MesS@9eS iN +h1s +Hr34d, go TO: %s and aDJU\$+ Y0UR 1n+ERES+ lEV3L @t T3H 80+toM OF +H3 p@GE.";

// Folder Subscription notification ------------------------------------

$lang['foldersubnotification_subject'] = "sU8SCR1PTI0N n0+1f1C@TIoN PHROM %s";
$lang['foldersubnotification'] = "hElLO %s,\n\n%s PO5+3d 4 m3ss@93 In 4 PhOLdER J00 @r3 \$UBsCR1BEd +o 0N %s.\n\n+He \$ubJEC+ I5: %s.\n\n+o rE4D th@t M3SS@gE 4ND 0Th3R\$ 1n +h3 S4ME dI\$cu\$SioN, gO +O:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nNOtE: 1pH J00 Do N0T wI\$H +O rECE1vE Em@1L N0tiFiC4+10N\$ 0PH n3w Me5s@9ES 1N tHi\$ +hR34D, gO +0: %s @Nd 4dJu5+ Y0UR 1n+3R3sT lEV3L 8Y cLIcK1NG oN +Eh F0LDEr'S Ic0n @t +3H +0p 0F P@GE.";

// PM notification -----------------------------------------------------

$lang['pmnotification_subject'] = "pM NOTif1C@TI0N pHROm %s";
$lang['pmnotification'] = "hEllO %s,\n\n%s P0s+3d @ pM TO j00 0N %s.\n\ntH3 SUbJ3c+ 1s: %s.\n\n+o R3AD THE meSS@GE GO +o:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nn0+3: 1Ph J00 D0 NO+ w1\$h to receiv3 EM@1l n0t1fIca+10NS Of N3W PM me\$S4G3\$ p0\$tED t0 Y0U, G0 T0: %s CLiCK MY c0nTR0L\$ +H3N 3M4IL AND PRIv4cY, UNSeLeCT +H3 Pm N0+If1c4T10N chECKB0x 4ND Pr3ss SUbmIt.";

// Password change notification ----------------------------------------

$lang['passwdchangenotification'] = "p4SSWOrD ch@Nge N0TifIC4+1On PHr0m %s";
$lang['pwchangeemail'] = "hElLO %s,\n\n+H1\$ @ N0TIFic4TIOn 3M@il +0 InpH0RM j00 +H@t y0ur PASSWOrd 0N %s HA\$ 8E3n CH4N9Ed.\n\nI+ H4\$ 8EEN ch4n9ED TO: %s @nd WA\$ CH4N93d By: %s.\n\n1F J00 h4V3 R3CE1V3D +h1\$ 3mAIl 1N ErrOR 0R w3r3 NOT 3xp3C+1N9 @ ch4N9E +0 y0UR P@S5WORD PL34SE C0NT@c+ ThE PhoRUM 0wN3R 0R @ m0dER4TOR 0n %s IMmeDIA+3lY +o CORreC+ 1+.";

// Email confirmation notification -------------------------------------

$lang['emailconfirmationrequiredsubject'] = "eM41l C0NPh1RM@tI0N r3qUIrED pH0R %s";
$lang['confirmemail'] = "h3lLo %s,\n\nyou R3CenTlY CR3@tEd A nEW usER AcCOUNT oN %s.\n\nbEFORe J00 CAN \$T@rT po\$+1N9 WE n3eD +0 C0NFIrM y0uR 3MaIL aDDResS. d0n'T wORRY +Hi\$ 1S Qu1+3 3@\$y. @ll J00 NeeD +o do I\$ CLICK +EH lINk 8EL0W (oR C0Py AND p4sT3 1T iN+O Y0UR BR0WS3R):\n\n%s\n\nONcE C0NPh1RM4+10N is C0MPLetE j00 MaY LOgIN 4ND \$T@rt p0\$+1N9 1MM3dI@t3LY.\n\niPH j00 DID no+ cr34+3 4 USEr 4CCOUnT ON %s pL3A\$3 Acc3P+ 0UR APOLOgieS 4ND fORW4rd +Hi\$ EMA1L to %s \$0 +H4T thE SOurCe 0f It M@y BE 1nV3sTIG4TED.";
$lang['confirmchangedemail'] = "h3LL0 %s,\n\nY0U Rec3N+lY ch4NGEd Y0UR 3M41L 0N %s.\n\nB3FoR3 J00 C4n \$+4RT p0sTIng 494IN we neED +0 C0NF1RM yoUr NEw 3M41L 4Ddr3sS. doN'+ W0Rry +h1\$ is qU1+3 3@SY. @ll J00 Need TO D0 1\$ Cl1cK +H3 LInK 83LOw (OR C0pY anD p4\$+3 I+ iNtO YOUR 8R0W\$3R):\n\n%s\n\n0NC3 CONFIrM4+1oN I\$ coMPL3t3 J00 M4Y COn+InuE tO US3 +H3 PH0RUm 4s N0RM4l.\n\n1F J00 W3R3 NOT 3XpeC+1Ng +H1S 3M4IL fROM %s PL3A\$3 4cC3P+ 0ur 4P0LOgiES 4ND pHORWaRD thI\$ EMAil TO %s \$O ThaT T3H s0urC3 0F I+ m4y 83 Inv3S+I94+3d.";

// Forgotten password notification -------------------------------------

$lang['forgotpwemail'] = "helLO %s,\n\nyOU REQu3s+3D +h1\$ 3-M@1l FRom %s BEc4u\$3 J00 H4V3 F0R90++3n YOUr P45SW0Rd.\n\nCl1cK thE L1Nk 83loW (OR cOPY 4nD P4stE 1+ in+0 y0uR bROW\$eR) +O ResE+ YOur P4ssWORd:\n\n%s";

// Admin New User Approval notification -----------------------------------------

$lang['newuserapprovalsubject'] = "n3W U\$3R 4PPr0V4l N0TIf1c4TION f0R %s";
$lang['newuserapprovalemail'] = "Hello %s,\n\nA new user account has been created on %s.\n\nAs you are an Administrator of this forum you are required to approve this user account before it can be used by it's owner.\n\nTo approve this account please visit the Admin Users section and change the filter type to \"Users Awaiting Approval\"or clICK +H3 LINk 8EL0W:\n\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nN0TE: 0+HeR 4DmiN1STr@T0RS 0n +Hi5 F0RUm W1Ll @lsO REcEIVe TH15 n0+IPhIc@+ion 4Nd mAy HavE 4Lr3@dY aCTeD Up0n +hi\$ R3QU3sT.";

// Admin New User notification -----------------------------------------

$lang['newuserregistrationsubject'] = "nEW USER @ccOuN+ n0TIF1CA+10n F0R %s";
$lang['newuserregistrationemail'] = "h3LL0 %s,\n\n4 N3W Us3r @Cc0uN+ H4s be3N cR3A+Ed 0N %s.\n\nTO VIEw +HiS US3R @CCOUn+ PL34SE V1SIT t3H @dmIN US3RS S3CTi0N AnD Cl1cK 0n +3H n3w Us3R OR CL1CK T3H LiNK 83lOW:\n\n%s";

// User Approved notification ------------------------------------------

$lang['useraccountapprovedsubject'] = "user ApPROVaL n0tIFIc4T1ON F0R %s";
$lang['useraccountapprovedemail'] = "h3lL0 %s,\n\ny0uR uSER 4CCOun+ @t %s H4S b3en 4PPr0vED. j00 C4N l09iN 4Nd S+aRT p0\$+1N9 1MM3DIA+ELY BY CL1CK1NG tHe L1NK 83LOw:\n\n%s\n\n1PH j00 WER3 N0T 3xPEC+1NG THi\$ eM@1L pHROM %s PlE4s3 4CC3PT oUR 4POL09IE5 4ND FOrW4Rd THi5 EM41L +0 %s \$0 TH4+ tH3 S0uRCe OF i+ M4Y 83 InV3\$T194TED.";

// Admin Post Approval notification -----------------------------------------

$lang['newpostapprovalsubject'] = "pOst @pPROv4l n0+1FICaTion F0R %s";
$lang['newpostapprovalemail'] = "h3lL0 %s,\n\n4 n3w pO\$T h4s B3EN cR3A+Ed 0N %s.\n\n4s J00 @r3 4 MOdera+or 0N tHI\$ F0rUm J00 4RE R3QUIrED tO AppR0VE tHi\$ PO\$+ b3f0R3 It C@N 83 re@d by OTh3r US3Rs.\n\ny0u c4n 4PPRov3 +h1\$ pO\$+ 4Nd ANY O+HER\$ P3ND1NG @PpR0V@l 8Y VisI+IN9 Th3 4DM1N pO\$+ APpR0v4l S3CTi0n 0F YouR f0RUm 0R by CLiCK1N9 Teh lINk 83LOw:\n\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nN0T3: O+H3R 4DMiNISTr4+OR\$ 0n THi\$ fOrUM W1lL 4L\$0 REcE1VE THI\$ N0tif1C4+1oN 4Nd M4Y H@VE ALr34DY aC+3D UPOn +H1\$ REQUeST.";

// Forgotten password form.

$lang['passwdresetrequest'] = "y0uR p4\$SWORd Re\$3T R3qu3s+ pHROM %s";
$lang['passwdresetemailsent'] = "p4\$swORD RESE+ e-m4il s3NT";
$lang['passwdresetexp'] = "j00 5h0ulD \$hOR+ly REcEIV3 4N 3-m41l C0NT41NIN9 INS+RUC+10n\$ pH0R re\$3+TIng y0uR PassW0RD.";
$lang['validusernamerequired'] = "a vALid US3Rn4m3 IS r3QU1rEd";
$lang['forgottenpasswd'] = "f0RGOT P4SSWOrd";
$lang['couldnotsendpasswordreminder'] = "c0uLd NOT s3nD p@Ssw0rD rEM1NdeR. PLEasE c0nT@C+ +eH PhORUM oWnER.";
$lang['request'] = "r3qu3S+";

// Email confirmation (confirm_email.php) ------------------------------

$lang['emailconfirmation'] = "eM@IL C0NF1Rm4+iON";
$lang['emailconfirmationcomplete'] = "tHANk J00 F0r coNFIrminG Y0uR Em41L aDDR3sS. J00 M4Y noW l0giN @ND 5+@rT POStING imMEd14+ELY.";
$lang['emailconfirmationfailed'] = "eM4iL C0NpHIrm4+10N h4\$ Ph@1LED, PLe4s3 TRy 494iN l4+3r. IPh J00 3NCOun+er thIS 3rroR MuLT1PL3 TIme5 pl34s3 CoNt4C+ +h3 F0RUm 0wNeR 0R a M0D3R4TOR f0R a\$SI5+4NCe.";

// Links database (links*.php) -----------------------------------------

$lang['toplevel'] = "t0p L3V3L";
$lang['maynotaccessthissection'] = "j00 May NO+ @ccE\$s +hIS S3C+10n.";
$lang['toplevel'] = "t0p L3VEL";
$lang['links'] = "l1nkS";
$lang['externallink'] = "ex+3RN@l LiNK";
$lang['viewmode'] = "v13W m0DE";
$lang['hierarchical'] = "hI3R4RChIC4L";
$lang['list'] = "l1ST";
$lang['folderhidden'] = "th1s F0Ld3r 1s H1DdeN";
$lang['hide'] = "h1dE";
$lang['unhide'] = "unhIDE";
$lang['nosubfolders'] = "n0 SUBF0LDerS iN thi\$ c4+E90RY";
$lang['1subfolder'] = "1 \$u8fOLDEr 1N tHI\$ CA+3g0Ry";
$lang['subfoldersinthiscategory'] = "sU8fOLD3RS 1n th1\$ C@+E90Ry";
$lang['linksdelexp'] = "entR13\$ 1N 4 D3L3+3D F0lD3R w1lL B3 M0v3D T0 tHE P4REnT F0LD3R. ONlY F0LDeRS wH1cH DO no+ coNT41N su8FOLD3r\$ m4y 83 DelE+3D.";
$lang['listview'] = "l15+ VIEw";
$lang['listviewcannotaddfolders'] = "c4nn0+ 4Dd F0LDErS 1N tHI\$ vIEw. sH0W1N9 20 3N+RieS 4+ a TiMe.";
$lang['rating'] = "r4+1n9";
$lang['nolinksinfolder'] = "n0 L1NKS iN +h1s phOLDeR.";
$lang['addlinkhere'] = "aDD l1nk h3r3";
$lang['notvalidURI'] = "th@T 1\$ N0+ @ V4LId URi!";
$lang['mustspecifyname'] = "j00 MU\$t SPeCIfy a N4ME!";
$lang['mustspecifyvalidfolder'] = "j00 MUS+ sPEc1fY A V4LId FOLd3r!";
$lang['mustspecifyfolder'] = "j00 Mu5T sPeC1fY @ PhoLd3r!";
$lang['successfullyaddedlinkname'] = "suCceSSFUlLY @DDed l1nk '%s'";
$lang['failedtoaddlink'] = "f4il3D +0 adD LiNK";
$lang['failedtoaddfolder'] = "f4IL3D +0 @DD pH0LDeR";
$lang['addlink'] = "add A l1nK";
$lang['addinglinkin'] = "aDD1N9 L1NK 1N";
$lang['addressurluri'] = "aDDr3\$S";
$lang['addnewfolder'] = "aDd @ N3w FOld3R";
$lang['addnewfolderunder'] = "addinG NEw F0LDEr UND3R";
$lang['editfolder'] = "eD1t PHOLder";
$lang['editingfolder'] = "eDIT1N9 F0LDeR";
$lang['mustchooserating'] = "j00 MU\$t CH0O\$3 4 R4+1N9!";
$lang['commentadded'] = "youR COmM3N+ w@S 4DDED.";
$lang['commentdeleted'] = "comm3NT wAS d3lE+3D.";
$lang['commentcouldnotbedeleted'] = "c0MM3nt COUld Not 8E D3L3TEd.";
$lang['musttypecomment'] = "j00 MUST TYPE @ C0MMEN+!";
$lang['mustprovidelinkID'] = "j00 MUST pR0vIDE @ L1NK 1D!";
$lang['invalidlinkID'] = "iNVAL1D lINk ID!";
$lang['address'] = "aDdRES5";
$lang['submittedby'] = "subMI+t3d 8Y";
$lang['clicks'] = "cL1ckS";
$lang['rating'] = "r@+1n9";
$lang['vote'] = "vo+3";
$lang['votes'] = "v0+3s";
$lang['notratedyet'] = "n0t Ra+ED by @NY0N3 YeT";
$lang['rate'] = "r@+3";
$lang['bad'] = "b4D";
$lang['good'] = "g0od";
$lang['voteexcmark'] = "v0+3!";
$lang['clearvote'] = "cLE4R VOTe";
$lang['commentby'] = "c0mMEN+ BY %s";
$lang['addacommentabout'] = "add 4 ComMEn+ A8OU+";
$lang['modtools'] = "m0DERatI0N +oOLs";
$lang['editname'] = "ed1t N4M3";
$lang['editaddress'] = "eD1t 4DDRe5s";
$lang['editdescription'] = "ed1+ d3SCr1pT10N";
$lang['moveto'] = "m0V3 T0";
$lang['linkdetails'] = "lINk D3T@iLS";
$lang['addcomment'] = "aDd COMM3N+";
$lang['voterecorded'] = "youR V0+3 H4s 8E3N r3c0RD3d";
$lang['votecleared'] = "yOUR V0te H4\$ b3En Cl34reD";
$lang['linknametoolong'] = "l1nK n@M3 +OO L0NG. M@XimuM i\$ %s Ch4r@cteRs";
$lang['linkurltoolong'] = "lINK Url +00 LOng. m@XIMuM 1S %s CHaR4CT3RS";
$lang['linkfoldernametoolong'] = "f0ldER N@Me TO0 L0n9. M@XImUM Len9+H i\$ %s CH4RAcT3R\$";

// Login / logout (llogon.php, logon.php, logout.php) -----------------------------------------

$lang['loggedinsuccessfully'] = "j00 L09gED in \$ucC3\$SPhuLLY.";
$lang['presscontinuetoresend'] = "prEs\$ CoN+1Nu3 +0 RES3ND FOrm D@t4 0R C4NceL TO r3l0@D p49e.";
$lang['usernameorpasswdnotvalid'] = "thE U\$3rN4ME or P4\$Sw0rD j00 SUPpL1ed IS n0T v@LId.";
$lang['rememberpasswds'] = "r3M3Mb3r P4ssWOrD\$";
$lang['rememberpassword'] = "r3meM83r P4SSWORd";
$lang['enterasa'] = "eN+3R @\$ 4 %s";
$lang['donthaveanaccount'] = "d0n'+ H@v3 4N acC0unT? %s";
$lang['registernow'] = "rEg15+3R Now";
$lang['problemsloggingon'] = "pR0BLEM\$ L0GGIn9 ON?";
$lang['deletecookies'] = "d3l3T3 C0oKIE\$";
$lang['cookiessuccessfullydeleted'] = "c0okI3S SuccES\$pHUlly D3LET3D";
$lang['forgottenpasswd'] = "f0r9O++3N yOUR pa\$swORD?";
$lang['usingaPDA'] = "u\$1N9 4 PdA?";
$lang['lightHTMLversion'] = "lI9h+ HTMl VEr5ION";
$lang['youhaveloggedout'] = "j00 H4V3 LOgGED 0uT.";
$lang['currentlyloggedinas'] = "j00 4RE cuRReNTly L0G9ED 1N 4S %s";
$lang['logonbutton'] = "l09oN";
$lang['otherdotdotdot'] = "o+h3R...";
$lang['yoursessionhasexpired'] = "yOuR S3SS1ON H@5 EXP1r3d. j00 WiLL nEED to L0Gin 4GAiN +0 c0n+1NU3.";

// My Forums (forums.php) ---------------------------------------------------------

$lang['myforums'] = "my FORUMS";
$lang['allavailableforums'] = "aLL @v@1LAble Ph0RUM\$";
$lang['favouriteforums'] = "f4vouRI+3 pH0RUms";
$lang['ignoredforums'] = "ignORED F0rUM\$";
$lang['ignoreforum'] = "i9NOR3 PhoRUm";
$lang['unignoreforum'] = "uN1GN0R3 F0RUm";
$lang['lastvisited'] = "l@ST v1\$ITeD";
$lang['forumunreadmessages'] = "%s uNRE@d M3Ss@9eS";
$lang['forummessages'] = "%s M355AGe5";
$lang['forumunreadtome'] = "%s UNre@D &quot;t0: m3&quot;";
$lang['forumnounreadmessages'] = "nO UNR34D M3S\$@g35";
$lang['removefromfavourites'] = "r3m0Ve From PH4VoUr1+Es";
$lang['addtofavourites'] = "adD +O F@vOurIT3\$";
$lang['availableforums'] = "aV41l@8l3 FOrumS";
$lang['noforumsofselectedtype'] = "tHER3 4RE nO F0RUms OF +H3 S3LEC+eD +yP3 4V4IL@BL3. pLe4\$3 SEL3Ct 4 D1PHpH3REn+ +yPE.";
$lang['successfullyaddedforumtofavourites'] = "suCC35\$FULLY 4DD3D phORUm T0 PH@V0URI+3s.";
$lang['successfullyremovedforumfromfavourites'] = "sucCESSPhuLlY R3MOVed PH0rUm FR0M F4VOur1tE\$.";
$lang['successfullyignoredforum'] = "succ3ssFulLy 19N0R3D ph0RUM.";
$lang['successfullyunignoredforum'] = "sucCES\$pHULlY uNIGnoR3D phOrUm.";
$lang['failedtoupdateforuminterestlevel'] = "f41LEd TO uPD4tE pHORuM IntER3ST l3V3L";
$lang['noforumsavailablelogin'] = "tH3r3 @re NO pHorUM\$ 4v41L@8l3. Pl3@5E LOGIN +0 VIEw Y0uR FORumS.";
$lang['passwdprotectedforum'] = "p4ssWOrD Pr0t3C+3d f0RUm";
$lang['passwdprotectedwarning'] = "thiS F0RuM is p@sSworD ProT3CTEd. tO 941N @cc3\$s EN+3r +H3 P@5SWORd BeLOW.";

// Message composition (post.php, lpost.php) --------------------------------------

$lang['postmessage'] = "poST m3sS493";
$lang['selectfolder'] = "s3l3cT PH0Ld3r";
$lang['mustenterpostcontent'] = "j00 muST 3nT3R 50M3 COntEN+ F0R +3H PO\$+!";
$lang['messagepreview'] = "mE\$S@9E pR3VIeW";
$lang['invalidusername'] = "iNV@L1d US3RN4m3!";
$lang['mustenterthreadtitle'] = "j00 MUSt EN+eR 4 tI+Le PhoR +EH +Hre4D!";
$lang['pleaseselectfolder'] = "pl3@\$E \$3leC+ 4 F0LD3R!";
$lang['errorcreatingpost'] = "erROr CR3@tINg PO\$+! PlE4s3 TrY 4G41n iN 4 F3W mInuT3S.";
$lang['createnewthread'] = "cRE4+3 N3W +Hr3AD";
$lang['postreply'] = "p0\$+ R3PLY";
$lang['threadtitle'] = "thR3@D +1+LE";
$lang['foldertitle'] = "fOldeR +1Tle";
$lang['messagehasbeendeleted'] = "me\$s@93 NOT pHOUNd. chEck TH4t 1+ h4sN't B3EN d3l3T3d.";
$lang['messagenotfoundinselectedfolder'] = "m3ss49e n0+ FOUnD 1N s3L3C+3D pH0LDEr. Ch3cK tH4+ 1T h@5N'T 83EN mOV3D Or DELe+3d.";
$lang['cannotpostthisthreadtypeinfolder'] = "j00 c4NNO+ pO5+ +h15 THr34d TyPE iN +h4t PHold3R!";
$lang['cannotpostthisthreadtype'] = "j00 caNNO+ P0\$t +h1\$ +hREad tYPe 4s +HeRE 4R3 No @v4IL@bL3 F0ld3R\$ +H4T AlL0W it.";
$lang['cannotcreatenewthreads'] = "j00 C@Nno+ Cr34+3 New +HrEAd\$.";
$lang['threadisclosedforposting'] = "th1\$ +HReAD I\$ CL0SeD, J00 C4NNOt P05T 1n I+!";
$lang['moderatorthreadclosed'] = "w4RN1N9: +H1S +HR34D 1S Cl0\$3D For PoS+In9 T0 NOrM4L us3RS.";
$lang['usersinthread'] = "us3RS iN thR34D";
$lang['correctedcode'] = "c0RrecTEd C0DE";
$lang['submittedcode'] = "sUBMItTED cOD3";
$lang['htmlinmessage'] = "h+mL In M35s@9E";
$lang['disableemoticonsinmessage'] = "di\$4BLe EMOt1c0NS 1n M3SS49E";
$lang['automaticallyparseurls'] = "autOM4+1c4LLY PaRS3 URls";
$lang['automaticallycheckspelling'] = "aU+OMA+1c@llY ChECK sPell1n9";
$lang['setthreadtohighinterest'] = "s3+ THr3@D tO HiGH IN+3R3s+";
$lang['enabledwithautolinebreaks'] = "eN48LEd wI+H 4U+0-LiN3-8RE4K\$";
$lang['fixhtmlexplanation'] = "tHIs FORuM US3s H+ml f1l+3R1ng. y0uR Su8m1T+ED HTmL H@\$ 8eEn M0D1fIed 8Y tEH PhIL+3r\$ 1n \$0ME w4Y.\\n\\nTO vIEw YOUR Or1g1N4L c0de, s3l3c+ +H3 \\'SUbm1TT3D c0d3\\' R4d10 8U+T0N.\\n+O v1eW +h3 M0DIF1ED COdE, seLEc+ the \\'cORr3c+3D coD3\\' R4D1O 8U+tON.";
$lang['messageoptions'] = "me\$s@93 OPti0n\$";
$lang['notallowedembedattachmentpost'] = "j00 4rE N0T 4lLOWed TO 3m8eD @TT4cHmEN+s IN y0UR po\$+s.";
$lang['notallowedembedattachmentsignature'] = "j00 ArE N0+ 4lLOW3d t0 3MBed 4TT4CHMEn+S IN Y0UR s1GNA+uR3.";
$lang['reducemessagelength'] = "m3SS493 leN9TH muST 8E Und3r 65,535 CH4r4c+3RS (cURr3n+LY: %s)";
$lang['reducesiglength'] = "sI9N@TurE L3n9TH MU5+ b3 UNd3r 65,535 Ch@R@CTer\$ (CUrr3nTlY: %s)";
$lang['cannotcreatethreadinfolder'] = "j00 c@Nn0T cR3A+e NEW THr3@D\$ in +H1s pHoLDer";
$lang['cannotcreatepostinfolder'] = "j00 C4nn0T rePly +O p0sTS 1N +h1\$ F0LD3R";
$lang['cannotattachfilesinfolder'] = "j00 c4NNO+ pOST @T+ACHmen+S IN +h1s PH0LD3R. REM0VE 4++4CHMeNTS to c0N+1NUE.";
$lang['postfrequencytoogreat'] = "j00 C@n oNLY P0ST 0NC3 Ev3Ry %s SEc0nDS. pL34SE +RY 4941n L4TEr.";
$lang['emailconfirmationrequiredbeforepost'] = "eMA1L C0Nf1RmA+Ion Is ReqUIr3d B3F0r3 J00 C@n PO5+. 1pH J00 H@ve no+ R3CEIv3d a CONFiRM4+10N EM@1l Pl34s3 Cl1cK THe BUtT0n 83LOW aND 4 N3W 0N3 W1ll 8E Sen+ +o YOU. IF yoUR EM4IL 4DDR3sS NeeD5 CH@NGin9 PLE@\$E d0 SO 83F0RE R3QU3S+1n9 4 NEW conFIRm4t10N 3M@il. j00 M@y CH4N9E yoUR 3m41L 4DDr3SS 8Y cL1CK my CONtrOLS AB0vE @nD thEN usER d3+@1L\$";
$lang['emailconfirmationfailedtosend'] = "cONPhiRM4+10n 3m41L ph@Il3d +0 S3ND. PLE4s3 C0N+4c+ +HE PH0RUM 0wNer +0 r3cTIfY Th1\$.";
$lang['emailconfirmationsent'] = "cONFIrm@TI0N 3MaiL h4\$ 8EeN REseNT.";
$lang['resendconfirmation'] = "re53nD coNPHirM@TI0N";
$lang['userapprovalrequiredbeforeaccess'] = "y0UR U5Er @cC0uNT NE3DS +0 83 @PPrOveD 8y @ foRUm AdMIn 83PhoR3 J00 c@N 4CC3\$S tEh R3QU3S+3d f0rUM.";
$lang['reviewthread'] = "r3V1eW +Hr34D";
$lang['reviewthreadinnewwindow'] = "rev13W 3ntIr3 +Hre4d 1n neW W1NDoW";

// Message display (messages.php & messages.inc.php) --------------------------------------

$lang['inreplyto'] = "iN REplY +O";
$lang['showmessages'] = "sH0w M3SSA9ES";
$lang['ratemyinterest'] = "r@Te my in+eR3st";
$lang['adjtextsize'] = "adjUS+ tex+ s1zE";
$lang['smaller'] = "sM4LlER";
$lang['larger'] = "l4RGer";
$lang['faq'] = "f4Q";
$lang['docs'] = "d0cs";
$lang['support'] = "suPP0rT";
$lang['donateexcmark'] = "doN@TE!";
$lang['fontsizechanged'] = "f0NT SIZE CH@n93D. %s";
$lang['framesmustbereloaded'] = "fR4m3\$ MU5+ B3 R3Lo4dED M@Nu4LLY +O s33 CH4n93s.";
$lang['threadcouldnotbefound'] = "tHE R3QUest3D +hrE4D C0uld no+ BE f0UND or 4CceSS W@S D3N1ED.";
$lang['mustselectpolloption'] = "j00 MusT S3L3C+ 4N OpT1oN +o V0+3 F0R!";
$lang['mustvoteforallgroups'] = "j00 MUS+ VOtE 1n ev3RY 9R0UP.";
$lang['keepreading'] = "k3EP R3AD1NG";
$lang['backtothreadlist'] = "b@cK +o THr34D lIST";
$lang['postdoesnotexist'] = "th4T poS+ DO3\$ No+ ex1\$T 1n THi\$ +hREAD!";
$lang['clicktochangevote'] = "cLiCK +O Ch@NGe V0TE";
$lang['youvotedforoption'] = "j00 VOT3d PHoR 0PT10n";
$lang['youvotedforoptions'] = "j00 V0T3d PHOR 0PTi0NS";
$lang['clicktovote'] = "cLiCK +o V0+3";
$lang['youhavenotvoted'] = "j00 HAv3 NO+ v0tED";
$lang['viewresults'] = "vi3w Re\$Ul+s";
$lang['msgtruncated'] = "m3\$s@93 TRuNC@t3D";
$lang['viewfullmsg'] = "v1EW PHull m35s@GE";
$lang['ignoredmsg'] = "ign0rED M3sS4GE";
$lang['wormeduser'] = "worm3d US3R";
$lang['ignoredsig'] = "i9NOR3d SI9NA+ur3";
$lang['messagewasdeleted'] = "m3Ss4ge %s.%s w4s DELE+3D";
$lang['stopignoringthisuser'] = "st0p 1GN0RIN9 tHi5 US3R";
$lang['renamethread'] = "r3N4M3 +hR34D";
$lang['movethread'] = "mOve thRE4d";
$lang['torenamethisthreadyoumusteditthepoll'] = "t0 r3N4ME +hIS tHR34d J00 Mus+ EDi+ tHE p0LL.";
$lang['closeforposting'] = "clos3 F0R P0\$t1nG";
$lang['until'] = "uNtIL 00:00 uTC";
$lang['approvalrequired'] = "aPpRoV@L r3QUIreD";
$lang['messageawaitingapprovalbymoderator'] = "m3S5493 %s.%s I\$ AWA1tinG 4PPR0VAl BY 4 M0DEr4+OR";
$lang['successfullyapprovedpost'] = "sucCES\$PHUllY @PProVED P0\$t %s";
$lang['postapprovalfailed'] = "poST 4PPr0V4L PhaIl3d.";
$lang['postdoesnotrequireapproval'] = "pOst DoeS n0T ReqUIrE 4PPrOVaL";
$lang['approvepost'] = "aPPR0V3 P0\$T";
$lang['approvedbyuser'] = "appr0V3d: %s BY %s";
$lang['makesticky'] = "m4k3 STIckY";
$lang['messagecountdisplay'] = "%s OF %s";
$lang['linktothread'] = "p3RM@neN+ l1nK +O tH1s +hRE4D";
$lang['linktopost'] = "l1nk TO pOST";
$lang['linktothispost'] = "l1NK To tHi\$ Po\$+";
$lang['imageresized'] = "tH1s 1m49e H4S BeeN rESIZ3D (ORiGIN4L S1ze %1\$SX%2\$S). +0 VI3W +3H FUll-5IZ3 1M49E clIck H3RE.";
$lang['messagedeletedbyuser'] = "mesS@93 %s.%s DeLE+3D %s BY %s";
$lang['messagedeleted'] = "m3SsaGE %s.%s W@S DeLETeD";
$lang['viewinframeset'] = "v1EW 1N FR@ME\$3+";
$lang['pressctrlentertoquicklysubmityourpost'] = "presS C+rl+eNT3R +O Qu1CKLy SUbM1+ yoUr PO\$t";

// Moderators list (mods_list.php) -------------------------------------

$lang['cantdisplaymods'] = "c4nN0t D1\$Pl4y FOLder MOd3r4TORS";
$lang['moderatorlist'] = "m0dER@+0R lisT:";
$lang['modsforfolder'] = "mod3rA+0RS ph0R pH0LD3R";
$lang['nomodsfound'] = "no MODeR@t0rS PH0unD";
$lang['forumleaders'] = "f0rUM L3@DeRS:";
$lang['foldermods'] = "fOlDEr M0dEr4+0r5:";

// Navigation strip (nav.php) ------------------------------------------

$lang['start'] = "s+4R+";
$lang['messages'] = "mE\$S493\$";
$lang['pminbox'] = "in80x";
$lang['startwiththreadlist'] = "sT@R+ pagE W1TH +HRE@D L1\$t";
$lang['pmsentitems'] = "senT 1+Ems";
$lang['pmoutbox'] = "oU+box";
$lang['pmsaveditems'] = "s@v3d I+eMS";
$lang['pmdrafts'] = "dR4PHt\$";
$lang['links'] = "lINK\$";
$lang['admin'] = "adm1n";
$lang['login'] = "lO9IN";
$lang['logout'] = "l09ou+";

// PM System (pm.php, pm_write.php, pm.inc.php) ------------------------

$lang['privatemessages'] = "pR1v@TE MESs49es";
$lang['recipienttiptext'] = "s3p@R@t3 R3CiPiEN+s by 5EM1-c0lON oR c0MM4";
$lang['maximumtenrecipientspermessage'] = "tH3rE I\$ 4 LimIT oF 10 R3Cip1ENTs P3R mESSAG3. PLE4S3 4M3ND youR r3cIpIEN+ Li\$T.";
$lang['mustspecifyrecipient'] = "j00 mU\$+ \$P3C1PHY 4t LEa\$t ON3 recIPieN+.";
$lang['usernotfound'] = "u\$er %s nO+ FOUnD";
$lang['sendnewpm'] = "s3nd n3w Pm";
$lang['savemessage'] = "s4v3 ME\$sAGE";
$lang['nosubject'] = "nO SubJECT";
$lang['norecipients'] = "n0 REC1P1ENt\$";
$lang['timesent'] = "tImE SENt";
$lang['notsent'] = "n0T s3N+";
$lang['errorcreatingpm'] = "err0R CrEA+1NG pm! PleASE trY AGain 1n 4 F3W m1nU+3\$";
$lang['writepm'] = "wr1Te M3ss4ge";
$lang['editpm'] = "ed1+ M3\$S@G3";
$lang['cannoteditpm'] = "c4NNO+ ed1T ThI\$ pm. 1t H@5 @lRE4DY BE3N VieW3d 8Y tHE reCip1en+ 0R +H3 M3S5493 D0Es nO+ EX1\$t 0R I+ i\$ 1nACce\$S1bLE 8Y J00";
$lang['cannotviewpm'] = "c4nn0+ v1EW PM. M3SS@9E d03s n0T 3xISt Or i+ IS In4CC3ssI8L3 8y j00";
$lang['pmmessagenumber'] = "mESSage %s";

$lang['youhavexnewpm'] = "j00 h4VE %d NeW ME\$s4G3s. W0ULd J00 L1Ke +0 90 +o y0UR iNB0x NOW?";
$lang['youhave1newpm'] = "j00 HAve 1 N3W m3\$S@gE. woULd J00 L1K3 +0 9O +0 Your 1NB0X N0W?";
$lang['youhave1newpmand1waiting'] = "j00 H@v3 1 N3W MESSAgE.\n\nyOU aL\$0 h4v3 1 Me5s493 4W@I+1NG deLiVERy. +0 r3ceIVE th1s ME\$sAg3 Ple4S3 CLE@R Some SP4C3 IN yOUR 1n80X.\n\nW0ULD j00 L1k3 TO 90 TO Y0UR 1N80x N0W?";
$lang['youhave1pmwaiting'] = "j00 HAvE 1 MESSAg3 4W@iTINg dELiVERy. To REce1VE Th1s M3SS@ge PLeASE clE4r \$OM3 \$P4CE In Y0UR inB0X.\n\nW0ULd j00 L1K3 T0 90 T0 Y0UR 1n80x N0W?";
$lang['youhavexnewpmand1waiting'] = "j00 h4vE %d NEW M3sS49ES.\n\nYOU 4ls0 H4v3 1 Me5s@G3 @W41+1NG DELiVErY. +o REcEIv3 Thi5 M3\$sAGE PLea\$E Cle4R \$0M3 Sp@C3 in YOur 1NB0X.\n\nWOulD j00 lIKE t0 90 T0 y0uR In80x NoW?";
$lang['youhavexnewpmandxwaiting'] = "j00 H4VE %d new mESS4Ges.\n\nYoU aLS0 H4V3 %d M3\$S4G3S 4W@IT1N9 DelIveRY. T0 reCe1V3 tHesE MES5@9E PLE4SE CLE4R S0ME \$P4cE IN Y0uR In80x.\n\nwoULD j00 L1KE t0 90 TO y0uR 1N8OX N0W?";
$lang['youhave1newpmandxwaiting'] = "j00 H@ve 1 NEw m3Ss49E.\n\nyoU 4lS0 H4V3 %d me\$s@GES @W4I+1nG DELivERy. TO rECe1v3 THEs3 m3\$sAGES pLE4s3 CL3@r \$0M3 sp@CE in yoUR inB0x.\n\nWOULd J00 LIke +O 9o +0 Y0UR iNb0X noW?";
$lang['youhavexpmwaiting'] = "j00 HAVE %d ME\$S@GE\$ 4W41+1N9 D3L1v3RY. +O r3c31v3 +H3Se M3ss@GEs Pl34s3 cLE4r SoM3 sp@CE 1N Y0uR IN8Ox.\n\nW0ULD J00 L1KE +0 90 +0 Y0UR InB0x N0w?";

$lang['youdonothaveenoughfreespace'] = "j00 DO N0+ h@V3 en0U9H PhREE \$P4Ce tO S3nd +h1\$ m3\$\$@gE.";
$lang['userhasoptedoutofpm'] = "%s h@\$ OPteD 0U+ 0F r3Ce1VINg PEr\$ON4L m3ss@ges";
$lang['pmfolderpruningisenabled'] = "pm PHOLd3r pRUNiNG i\$ 3nABleD!";
$lang['pmpruneexplanation'] = "tHis PhORUm US3s pM phOLD3r pRuNINg. th3 MES\$@9es J00 h4v3 sTOr3d 1N youR InB0x @nD s3n+ i+EMS\\nF0lDERS 4R3 SU8JEct To @U+oM@+iC d3L3+1ON. 4nY mESS@93S j00 W1SH to k33P SHouLd Be mOVEd +0\\nYOUr \\'54Ved ItEM\$\\' f0LDEr sO ThA+ +H3Y @R3 N0T d3lE+3D.";
$lang['yourpmfoldersare'] = "y0ur pm FOld3R\$ 4R3 %s FuLL";
$lang['currentmessage'] = "cURRenT M3SS@9E";
$lang['unreadmessage'] = "uNRE4D M3\$s@G3";
$lang['readmessage'] = "rE@d M3sS@93";
$lang['pmshavebeendisabled'] = "p3RS0N@L M3\$SAGe\$ h4V3 B3EN dIS4BLed BY T3H F0Rum OWnER.";
$lang['adduserstofriendslist'] = "adD U53RS TO Y0Ur PHr1ENdS L1ST +O h4V3 +h3M 4PP3@R 1N A dr0P D0wn ON tHE pM Wr1+3 Me\$S49E p49E.";

$lang['messagewassuccessfullysavedtodraftsfolder'] = "me\$S@g3 W4s SucC3\$5PHuLLY S@Ved +0 'dR4Ph+S' pH0LDEr";
$lang['couldnotsavemessage'] = "c0uLD noT 5AvE MesS49E. m@Ke sURE J00 H4V3 3n0UGH @V41L@bLE pHRE3 5P4C3.";
$lang['pmtooltipxmessages'] = "%s mESS493S";
$lang['pmtooltip1message'] = "1 m3sS49E";

$lang['allowusertosendpm'] = "aLl0W U\$3r T0 S3ND PErsOnaL mESSaGE\$ +0 Me";
$lang['blockuserfromsendingpm'] = "bl0CK US3R pHROM S3ND1N9 p3rs0N4L m3sS49Es +0 m3";
$lang['yourfoldernamefolderisempty'] = "y0UR %s Ph0lD3R i\$ EmpTY";
$lang['successfullydeletedselectedmessages'] = "sucC3sSPHUlLY D3LET3D sELEcTED mESS493\$";
$lang['successfullyarchivedselectedmessages'] = "sUcCE5\$phULLy 4RCHivEd S3LECtED m3ssAGes";
$lang['failedtodeleteselectedmessages'] = "f@1lED to DeL3+3 S3L3CTeD meSS@93s";
$lang['failedtoarchiveselectedmessages'] = "f41l3d T0 arch1V3 5ELeCT3D Me5s493\$";

// Preferences / Profile (user_*.php) ---------------------------------------------

$lang['mycontrols'] = "my CON+r0l\$";
$lang['myforums'] = "my fORUMs";
$lang['menu'] = "menU";
$lang['userexp_1'] = "uSe teH M3nu 0n T3H leF+ t0 M4N@9e YOUr \$3T+1N9S.";
$lang['userexp_2'] = "<b>us3R DeT@Ils</b> alLow\$ J00 t0 cH4N9e yOUr N@M3, 3M4IL ADDrE\$s 4ND p4\$5WORd.";
$lang['userexp_3'] = "<b>u5eR pR0PHiL3</b> 4lLow\$ j00 +O 3D1T Y0Ur USer pROFIl3.";
$lang['userexp_4'] = "<b>cH4n9e p4\$sWORD</b> 4Ll0w\$ J00 t0 CH4n93 Y0UR p@\$\$WORd";
$lang['userexp_5'] = "<b>eM41l &amp; PrIV4CY</b> l3TS J00 ChaNg3 H0W j00 C4N be CoN+4C+3d 0N 4Nd 0FF Teh FORuM.";
$lang['userexp_6'] = "<b>fORUM opTioN\$</b> l3+\$ j00 CHaNGE h0W t3h f0rUM LOOks @Nd WoRKS.";
$lang['userexp_7'] = "<b>a++@Chm3N+S</b> ALl0w5 J00 +0 3d1+/DELetE Y0ur 4++@CHMeNTS.";
$lang['userexp_8'] = "<b>s19n@Tur3</b> L3TS J00 3D1+ y0uR \$1gN4TURe.";
$lang['userexp_9'] = "<b>relA+1onSH1PS</b> LetS J00 M@n4gE yoUR r3l@TioN\$h1p w1+H 0+h3r us3RS 0N THe PhoRUM.";
$lang['userexp_9'] = "<b>wORD Ph1l+3R</b> l3tS J00 3DI+ y0UR p3rSON4L woRD pHIlT3R.";
$lang['userexp_10'] = "<b>thr34d \$uBSCR1p+10NS</b> 4lLOWS j00 TO m4n49E y0ur +HRE4D \$UBScrIPT1Ons.";
$lang['userdetails'] = "uSER D3+@1L\$";
$lang['userprofile'] = "user PROfIL3";
$lang['emailandprivacy'] = "em41L &amp; Pr1V@cy";
$lang['editsignature'] = "eDi+ \$19n4TURE";
$lang['norelationshipssetup'] = "j00 H@v3 N0 U\$3R r3l4+1oNSHiPS 5E+ UP. @DD 4 nEW us3R By S34RChiNG 8eL0W.";
$lang['editwordfilter'] = "ed1T w0rD PHiLTEr";
$lang['userinformation'] = "u53r 1NPh0rM4+10n";
$lang['changepassword'] = "cH4N93 passWORD";
$lang['currentpasswd'] = "curRENt PA\$sWORd";
$lang['newpasswd'] = "n3w P@SSWOrd";
$lang['confirmpasswd'] = "coNF1RM p4ssWOrD";
$lang['passwdsdonotmatch'] = "p@SswORD\$ do n0t M4+ch!";
$lang['nicknamerequired'] = "n1Ckn@Me IS rEquIr3d!";
$lang['emailaddressrequired'] = "ema1L 4DDre\$\$ 1s REQUir3D!";
$lang['logonnotpermitted'] = "lO9On NO+ p3RMI+t3D. cHO0Se 4N0+h3R!";
$lang['nicknamenotpermitted'] = "n1CKN4me NOT p3Rmi++3D. Cho05E 4No+H3R!";
$lang['emailaddressnotpermitted'] = "eM@iL adDRe5S noT PerMIt+Ed. cH0OsE 4NOTher!";
$lang['emailaddressalreadyinuse'] = "eM@il @ddr35s 4lRe4Dy iN USE. CH00\$E 4NOtHER!";
$lang['relationshipsupdated'] = "rel4+10NSH1P5 uPd4+3d!";
$lang['relationshipupdatefailed'] = "rELa+i0NShiP UPd4t3D f@Il3D!";
$lang['preferencesupdated'] = "pR3FEReNC35 WEre succ3SsFUlly Upd@+ed.";
$lang['userdetails'] = "user D3T41L\$";
$lang['memberno'] = "m3mb3r n0.";
$lang['firstname'] = "fIr\$t N@m3";
$lang['lastname'] = "lA5t N4M3";
$lang['dateofbirth'] = "d4t3 Of B1RTh";
$lang['homepageURL'] = "h0M3P@9E urL";
$lang['profilepicturedimensions'] = "pR0phiL3 PIctURE (M@x 95X95PX)";
$lang['avatarpicturedimensions'] = "aV4+4R p1C+URE (M4X 15X15PX)";
$lang['invalidattachmentid'] = "invaL1D 4+TacHM3N+. CHecK Th@+ I\$ HasN'+ b33N D3le+ED.";
$lang['unsupportedimagetype'] = "unSupPORtED IM49E 4Tt@CHmEN+. J00 CAn ONly U5E jpG, 9IF 4ND pn9 Im@9e 4+T4CHm3n+S F0R yoUR 4v@t@R 4ND prOF1L3 p1ctUR3.";
$lang['selectattachment'] = "sEleCt 4++@cHMEn+";
$lang['pictureURL'] = "p1cTUR3 URL";
$lang['avatarURL'] = "aV@t4R Url";
$lang['profilepictureconflict'] = "t0 Us3 4N 4+T@CHM3NT PH0R Y0Ur PR0F1Le PICTURE +3h P1cTUR3 uRL PhielD MUst 8E BL4nK.";
$lang['avatarpictureconflict'] = "to uSE 4N 4TT@cHM3N+ fOR yOUR 4V@+4r PiCTUre +H3 4V4T4R URL FI3LD mUST B3 BL4nK.";
$lang['attachmenttoolargeforprofilepicture'] = "selECTed 4+T4CHM3n+ 1\$ +0O LAr93 Ph0R Pr0fIle P1CturE. M4X1MUM d1MENs10ns AR3 %s";
$lang['attachmenttoolargeforavatarpicture'] = "sEL3C+3d 4T+4chMENt 1\$ +O0 L@Rge F0r 4V4+@r PIC+urE. m4x1mUM DimEN\$ioNs 4RE %s";
$lang['failedtoupdateuserdetails'] = "s0M3 0R 4LL 0F y0ur U5ER aCCOUnt D3+41lS COUld noT 8e UPdA+3D. Pl3@S3 +Ry 49@IN l4tER.";
$lang['failedtoupdateuserpreferences'] = "s0me 0R 4LL 0f Y0UR us3R pREPh3rENceS c0uLD Not 83 UPd4T3d. pLE@s3 +Ry @9AIN L@teR.";
$lang['emailaddresschanged'] = "em41l @DDR3sS h@S 8E3N ch@nGED";
$lang['newconfirmationemailsuccess'] = "y0UR EM@1L 4dDre\$S h4S 8EEN cH4N9ED 4ND @ N3W ConF1RM@+iON eM@IL H4\$ BEeN \$3N+. PL3@5E ch3CK 4Nd REaD teH em41L PHOR fURtHEr 1NS+rUC+10N\$.";
$lang['newconfirmationemailfailure'] = "j00 H4v3 Ch4N9ED yoUR 3M@1l @dDREss, bu+ W3 WER3 UN@8lE to S3ND 4 CONf1rM4T10N rEQUes+. pLe4\$3 C0N+4c+ +3H pH0RUm OWneR PH0R @\$s1s+4NC3.";
$lang['forumoptions'] = "f0ruM Op+1ON5";
$lang['notifybyemail'] = "notiPHY 8y 3M@iL 0F PoStS TO ME";
$lang['notifyofnewpm'] = "no+IFY 8Y P0PUP 0f New pM M3SS493s T0 ME";
$lang['notifyofnewpmemail'] = "noT1pHY by 3M@iL 0F New PM mES5@9Es +0 Me";
$lang['daylightsaving'] = "aDjUST PHOR d4YL19H+ \$@V1N9";
$lang['autohighinterest'] = "aU+OM@TIc@LLy M4RK +HR34DS 1 p0st 1n 4S H1gh In+3R3sT";
$lang['convertimagestolinks'] = "aU+oM@Tic4LLY CONVER+ 3Mb3DDed 1M4G3\$ IN POSTS 1n+0 l1NK\$";
$lang['thumbnailsforimageattachments'] = "tHUM8NA1LS pH0R 1M49E 4++@Chm3NT\$";
$lang['smallsized'] = "sM4LL \$1Z3D";
$lang['mediumsized'] = "mEdiUM \$1z3D";
$lang['largesized'] = "l@RG3 51Z3D";
$lang['globallyignoresigs'] = "gLob4LLy IGn0r3 US3R s1GN4+ure\$";
$lang['allowpersonalmessages'] = "aLL0W 0THEr USER\$ +0 5ENd mE p3RSOn@l m3\$saGES";
$lang['allowemails'] = "all0w O+h3R U\$ER\$ TO S3ND m3 3MAiL\$ V14 my Pr0pHilE";
$lang['timezonefromGMT'] = "t1M3 Z0N3";
$lang['postsperpage'] = "pO\$+\$ P3R P@93";
$lang['fontsize'] = "fon+ SIz3";
$lang['forumstyle'] = "f0rUM \$TYle";
$lang['forumemoticons'] = "f0ruM 3Mo+IcoNS";
$lang['startpage'] = "sT4r+ P493";
$lang['signaturecontainshtmlcode'] = "s1Gn@+UR3 coN+41NS h+ML C0dE";
$lang['savesignatureforuseonallforums'] = "s@ve S19N4TURe F0R U5E 0N @LL pH0RUM\$";
$lang['preferredlang'] = "prePH3RRed l4nGu@GE";
$lang['donotshowmyageordobtoothers'] = "dO N0+ \$H0W my 49E 0R d4+3 OF 8iR+h TO o+H3Rs";
$lang['showonlymyagetoothers'] = "show ONLy MY 49E T0 oTH3R\$";
$lang['showmyageanddobtoothers'] = "sh0w b0tH MY 493 4ND d@+3 0PH 81rth To 0tHEr\$";
$lang['showonlymydayandmonthofbirthytoothers'] = "sHoW 0NLy My D4Y 4ND MON+h oF B1R+H +o oTHErs";
$lang['listmeontheactiveusersdisplay'] = "l15+ ME 0N +H3 4c+1V3 USER\$ D1SPL4y";
$lang['browseanonymously'] = "bR0WS3 Ph0rUM 4NONymoUSLY";
$lang['allowfriendstoseemeasonline'] = "bRoWSE @NOnyMOUSlY, But @lL0W pHR1ENd\$ +0 S3e ME @S oNl1NE";
$lang['revealspoileronmouseover'] = "rEveAL sp0ILERS 0n M0uSE OV3R";
$lang['showspoilersinlightmode'] = "aLw@ys SH0W \$POIl3R\$ iN L19HT m0DE (uSES l1GH+3R pHOn+ COl0UR)";
$lang['resizeimagesandreflowpage'] = "r3\$1z3 IMaG3s @nD R3PHl0W P4GE +0 prEveNT h0RIz0NT4L \$crolLiN9.";
$lang['showforumstats'] = "shOw f0RUM \$T4+S 4+ 80tTOM of MESS49E P@N3";
$lang['usewordfilter'] = "eN@8L3 W0rD F1LTer.";
$lang['forceadminwordfilter'] = "f0rc3 US3 OF 4DMIn WORd PhIL+3r On @LL US3RS (INc. gue\$+S)";
$lang['timezone'] = "tIM3 Z0N3";
$lang['language'] = "l4n9U49e";
$lang['emailsettings'] = "emAIL @Nd C0nTAc+ \$E++1NGS";
$lang['forumanonymity'] = "fORUM 4nOnyM1+Y SeT+1NGS";
$lang['birthdayanddateofbirth'] = "b1rTHD4y @Nd D4+3 OF BirTH D1spL@Y";
$lang['includeadminfilter'] = "iNCLUd3 4DM1N w0rD PH1L+3R 1N mY lI\$T.";
$lang['setforallforums'] = "s3+ ph0R @LL PH0RUm\$?";
$lang['containsinvalidchars'] = "%s coNt41N\$ 1nv4LID CH@r@c+eR\$!";
$lang['homepageurlmustincludeschema'] = "hom3p4gE URL mu\$+ 1NCLuD3 H++p:// scH3MA.";
$lang['pictureurlmustincludeschema'] = "pIcTURE uRL mUS+ 1NclUdE H+TP:// SCh3m4.";
$lang['avatarurlmustincludeschema'] = "aVa+Ar UrL Must 1NCluD3 H++p:// SCh3MA.";
$lang['postpage'] = "pOsT PAge";
$lang['nohtmltoolbar'] = "n0 h+mL +00LbaR";
$lang['displaysimpletoolbar'] = "d1\$pL@Y s1MPLe HTmL +oOLb4r";
$lang['displaytinymcetoolbar'] = "di\$pL4Y Wy\$1WYg HTmL +00l8AR";
$lang['displayemoticonspanel'] = "dISpl4Y 3M0+1C0NS p4n3L";
$lang['displaysignature'] = "d15PL4Y 5igNa+ur3";
$lang['disableemoticonsinpostsbydefault'] = "d1S@8LE 3m0+1CONS IN m3sS@Ges 8Y deF4uLt";
$lang['automaticallyparseurlsbydefault'] = "aU+0M4+1C4LlY p4r\$3 URL5 In M3SS@9ES By D3FAUl+";
$lang['postinplaintextbydefault'] = "p0st 1N Pl41n TexT 8Y d3pH4uL+";
$lang['postinhtmlwithautolinebreaksbydefault'] = "p0sT 1N hTML w1TH 4u+o-LIne-bR3@Ks 8y D3F4UL+";
$lang['postinhtmlbydefault'] = "p0sT 1N hTMl by DepH@uLT";
$lang['postdefaultquick'] = "uS3 Qu1cK RePlY 8Y DefAULt. (PHuLL rePLY IN MENU)";
$lang['privatemessageoptions'] = "pRiVAt3 M3sS493 OPt10n\$";
$lang['privatemessageexportoptions'] = "pR1v4T3 ME\$SAG3 3xPoR+ 0pTIOns";
$lang['savepminsentitems'] = "s4v3 4 COPy 0PH 3aCh PM 1 SENd IN MY sEN+ 1+3M5 F0LD3R";
$lang['includepminreply'] = "iNclUde m3ssA9E 8ODy WheN r3pLy1NG To PM";
$lang['autoprunemypmfoldersevery'] = "aU+0 PRUn3 MY Pm PH0Ld3r\$ eVERy:";
$lang['friendsonly'] = "fRi3Nds 0NLY?";
$lang['globalstyles'] = "gLoB@L \$+Yle\$";
$lang['forumstyles'] = "f0rUM 5+ylES";
$lang['youmustenteryourcurrentpasswd'] = "j00 Mus+ 3NT3R y0uR CurR3NT p@5sW0RD";
$lang['youmustenteranewpasswd'] = "j00 MU\$+ 3N+3R @ N3W P@sSWORd";
$lang['youmustconfirmyournewpasswd'] = "j00 MU\$+ C0NFIRm Y0UR nEw p4\$swoRD";
$lang['profileentriesmustnotincludehtml'] = "proFIL3 EN+r13\$ mUST nOT 1NcLUD3 H+ML";
$lang['failedtoupdateuserprofile'] = "f41leD TO UPD4T3 US3R pROF1LE";

// Polls (create_poll.php, poll_results.php) ---------------------------------------------

$lang['mustprovideanswergroups'] = "j00 MU\$T pROVid3 50ME 4n\$wER 9R0uPS";
$lang['mustprovidepolltype'] = "j00 MUST pROVIdE 4 P0Ll TyPE";
$lang['mustprovidepollresultsdisplaytype'] = "j00 mUST pROViDE r3sUL+S D1sPl4y +yPE";
$lang['mustprovidepollvotetype'] = "j00 MU\$T PR0V1DE 4 POll VO+3 TYp3";
$lang['mustprovidepollguestvotetype'] = "j00 MU\$+ SP3CIFy IPH 9uEST\$ \$hOUlD 83 4LLOwED +O VO+3";
$lang['mustprovidepolloptiontype'] = "j00 mu5+ pR0VIde 4 P0LL 0PtION +Yp3";
$lang['mustprovidepollchangevotetype'] = "j00 musT pROV1D3 @ POLl ChAN9E VO+3 TYpE";
$lang['pollquestioncontainsinvalidhtml'] = "onE OR m0R3 oPH YoUR poLl QUEstI0N\$ cON+aiNS 1NVAl1d H+ML.";
$lang['pleaseselectfolder'] = "pl34sE \$eLEc+ @ PH0LD3R";
$lang['mustspecifyvalues1and2'] = "j00 MUst SP3C1Phy V4Lu3s F0R ansW3R\$ 1 AND 2";
$lang['tablepollmusthave2groups'] = "ta8UL@R PHoRM@T p0LL\$ musT H4v3 PreC1\$3lY +Wo VOt1n9 9R0uP\$";
$lang['nomultivotetabulars'] = "t48UL4R FOrM4T p0LLs C4NNO+ bE mUl+1-VO+E";
$lang['nomultivotepublic'] = "pu8L1C B4ll0T\$ C@Nn0T 8E MUlt1-vo+E";
$lang['abletochangevote'] = "j00 WIlL be 48LE +o CH4Nge YOUr VOTe.";
$lang['abletovotemultiple'] = "j00 wIll BE 48L3 +0 v0+E MuLT1PlE +1ME\$.";
$lang['notabletochangevote'] = "j00 WILl N0T 83 4Ble T0 CH4n9e YOUr VO+E.";
$lang['pollvotesrandom'] = "no+3: POLl VO+3s 4RE R@nDOmLY GeneR4+3D F0R prEV1EW onLy.";
$lang['pollquestion'] = "pOll QUesTI0N";
$lang['possibleanswers'] = "po\$s1BLE 4NSW3Rs";
$lang['enterpollquestionexp'] = "entER +He @nsWERs Ph0R yOUR p0LL QU3S+10N.. iF y0uR P0lL 15 4 &quot;yES/n0&quot; qu3S+10N, \$ImPLy 3N+3R &quot;Yes&quot; PH0R aN\$w3R 1 @nD &quot;N0&quot; pHOR 4nsw3r 2.";
$lang['numberanswers'] = "no. 4nsWERS";
$lang['answerscontainHTML'] = "aN5WErS CONtA1N htMl (NOt InCLUd1n9 S19N4TUr3)";
$lang['optionsdisplay'] = "anSWER5 DI\$pLAY +YP3";
$lang['optionsdisplayexp'] = "h0w 5HOUlD +h3 4N\$w3r\$ BE pREseN+3D?";
$lang['dropdown'] = "a\$ dROP-dowN L1\$+(S)";
$lang['radios'] = "a\$ @ seR13\$ 0F R@D10 bU+TOns";
$lang['votechanging'] = "v0+3 CH4N9iN9";
$lang['votechangingexp'] = "c4n 4 PErsON cH@Nge Hi\$ 0r h3R voTe?";
$lang['guestvoting'] = "gUe\$+ voTInG";
$lang['guestvotingexp'] = "caN gU3sTS V0+E IN ThI\$ POLl?";
$lang['allowmultiplevotes'] = "aLlOW Mul+1PL3 VO+3s";
$lang['pollresults'] = "p0lL r35ULTS";
$lang['pollresultsexp'] = "hOw WOUld J00 L1K3 +0 DI\$pL4Y +H3 RESUl+s 0F YOUr P0LL?";
$lang['pollvotetype'] = "p0LL v0+1N9 TypE";
$lang['pollvotesexp'] = "hOW SHOUld +H3 POll 83 C0NDUC+3d?";
$lang['pollvoteanon'] = "aNOnyMOUSly";
$lang['pollvotepub'] = "pUbLIc 8@LLO+";
$lang['horizgraph'] = "h0r1ZONT4L gR@Ph";
$lang['vertgraph'] = "v3rTIC4L 9r4ph";
$lang['tablegraph'] = "t48uLAR pHOrm@+";
$lang['polltypewarning'] = "<b>w4RN1n9</b>: THIS IS @ PUblIc 8@Llo+. YOUr N4M3 WiLL Be Vi\$1BLe NEX+ +O T3H 0P+10N j00 Vo+3 F0R.";
$lang['expiration'] = "eXPIR4TiOn";
$lang['showresultswhileopen'] = "d0 J00 w@NT +o sHOw R3\$UL+\$ wh1L3 THe P0LL i\$ op3N?";
$lang['whenlikepollclose'] = "wH3N WOULd J00 l1kE y0UR P0lL +0 AU+0m4+1C@lLY cLO\$3?";
$lang['oneday'] = "oNE D4Y";
$lang['threedays'] = "tHRee D4Y\$";
$lang['sevendays'] = "sev3n d@ys";
$lang['thirtydays'] = "thIRTy D4YS";
$lang['never'] = "n3veR";
$lang['polladditionalmessage'] = "add1+10N@l Me\$S@ge (0PT10n4l)";
$lang['polladditionalmessageexp'] = "do J00 W4N+ +0 1NClUD3 4N 4dDItI0N4L pO\$t 4PHtER +3H pOLL?";
$lang['mustspecifypolltoview'] = "j00 MUST SpECIFy A P0LL t0 VIeW.";
$lang['pollconfirmclose'] = "aRe J00 SUr3 J00 wAN+ +0 cl0\$3 tEH f0LLOWiN9 PoLL?";
$lang['endpoll'] = "eND p0LL";
$lang['nobodyvotedclosedpoll'] = "n080DY voT3D";
$lang['votedisplayopenpoll'] = "%s @ND %s h4vE V0t3d.";
$lang['votedisplayclosedpoll'] = "%s 4nd %s VOt3d.";
$lang['nousersvoted'] = "n0 USErs";
$lang['oneuservoted'] = "1 u53R";
$lang['xusersvoted'] = "%s usER\$";
$lang['noguestsvoted'] = "no 9u3sTS";
$lang['oneguestvoted'] = "1 9U3\$T";
$lang['xguestsvoted'] = "%s 9U3\$tS";
$lang['pollhasended'] = "pOlL h4\$ 3NDed";
$lang['youvotedforpolloptionsondate'] = "j00 VO+3d PH0R %s 0N %s";
$lang['thisisapoll'] = "tH1\$ 1s 4 P0LL. CL1ck T0 VI3w RE\$ULTS.";
$lang['editpoll'] = "eDI+ poLL";
$lang['results'] = "re\$UL+s";
$lang['resultdetails'] = "rE\$ULt D3T@1L5";
$lang['changevote'] = "chan9e VO+E";
$lang['pollshavebeendisabled'] = "polL\$ H4VE 83EN d1S4BLeD 8Y t3h phoRum 0WNeR.";
$lang['answertext'] = "aN\$W3R +3xt";
$lang['answergroup'] = "aN5w3R 9ROuP";
$lang['previewvotingform'] = "pR3VIew V0+1n9 PHorM";
$lang['viewbypolloption'] = "vI3w bY P0LL OP+1oN";
$lang['viewbyuser'] = "vI3W 8Y U\$3r";

// Profiles (profile.php) ----------------------------------------------

$lang['editprofile'] = "edi+ pr0fIl3";
$lang['profileupdated'] = "pR0PHIle UPD4+3d.";
$lang['profilesnotsetup'] = "thE PH0ruM OwN3R H@s n0+ \$e+ uP pr0f1L3\$.";
$lang['ignoreduser'] = "i9n0REd USEr";
$lang['lastvisit'] = "l4s+ VISi+";
$lang['userslocaltime'] = "uS3r'S loC@l +1mE";
$lang['userstatus'] = "sT4+uS";
$lang['useractive'] = "onlIne";
$lang['userinactive'] = "iNaCT1VE / 0PHFlINe";
$lang['totaltimeinforum'] = "t0+4L +1mE";
$lang['longesttimeinforum'] = "l0n93\$t s3\$S1ON";
$lang['sendemail'] = "senD 3MAiL";
$lang['sendpm'] = "sEnD pM";
$lang['visithomepage'] = "v1SIT h0mEp49E";
$lang['age'] = "aGe";
$lang['aged'] = "ag3D";
$lang['birthday'] = "bIr+Hd@Y";
$lang['registered'] = "re91\$T3r3D";
$lang['findpostsmadebyuser'] = "f1nd P0\$Ts m4D3 By %s";
$lang['findpostsmadebyme'] = "f1nD PO\$tS m4d3 by M3";
$lang['findthreadsstartedbyuser'] = "f1nD tHR34D\$ S+ARTEd By %s";
$lang['findthreadsstartedbyme'] = "fIND +HRE@DS ST4R+3d 8Y me";
$lang['profilenotavailable'] = "pR0f1lE NO+ 4V@1L4BLE.";
$lang['userprofileempty'] = "tHIS US3r H4s Not F1LL3D In TheIR Pr0fIL3 0R 1T 1S \$E+ +0 PRIV4T3.";

// Registration (register.php) -----------------------------------------

$lang['newuserregistrationsarenotpermitted'] = "s0rRY, NEW USer REG1\$+R4T1ON\$ @R3 n0+ @Ll0WED RIGH+ noW. PL34S3 Ch3ck 84cK L4+3R.";
$lang['usernameinvalidchars'] = "u\$eRN4M3 C@N ONly C0N+@In @-Z, 0-9, _ - Ch4r@cTERs";
$lang['usernametooshort'] = "uSERn4m3 MUSt B3 @ M1N1MUM 0f 2 CH@R@c+3R\$ loNG";
$lang['usernametoolong'] = "u\$ERn4m3 MUSt 83 @ M4xIMUm OF 15 cH4r4cTErs LOn9";
$lang['usernamerequired'] = "a lo90N n4m3 1\$ reQUiR3D";
$lang['passwdmustnotcontainHTML'] = "p4ssW0RD mUS+ N0+ coNT@1N H+mL +@G\$";
$lang['passwordinvalidchars'] = "p@sSW0RD cAn oNLy Con+@1n 4-z, 0-9, _ - CH4R4C+3RS";
$lang['passwdtooshort'] = "p@SsWORd MUS+ 8E 4 MInIMUM of 6 ch4R@CT3rs L0N9";
$lang['passwdrequired'] = "a P@\$\$w0RD 1s R3qU1r3D";
$lang['confirmationpasswdrequired'] = "a c0NPHiRM4T1oN P4sSW0Rd is REqu1R3D";
$lang['nicknamerequired'] = "a NIckN4M3 Is R3QUir3D";
$lang['emailrequired'] = "aN EMaIL @DDR3SS is rEQu1r3D";
$lang['passwdsdonotmatch'] = "p4ssW0RD\$ Do NO+ M4TCh";
$lang['usernamesameaspasswd'] = "userN4M3 4ND p@\$sW0RD mUS+ BE d1FFErENT";
$lang['usernameexists'] = "sorRY, 4 U\$3R WitH TH@T NamE 4LR3@dy EX1S+S";
$lang['successfullycreateduseraccount'] = "suCc35sFULly cR34T3D US3R 4CC0unT";
$lang['useraccountcreatedconfirmfailed'] = "yOuR U\$3R 4CC0UNT H4S BE3N cRE4T3d Bu+ Teh R3QUIr3d C0NphIrM4+10N 3M@1L WAS N0T S3NT. PleA\$E CONT4C+ +h3 F0RUM oWN3R +o r3cTifY th1S. in +h1\$ Me4n+Im3 PLe@\$3 CliCK tHe C0NT1NUE 8u+TOn TO l09IN.";
$lang['useraccountcreatedconfirmsuccess'] = "yOur US3r @cC0UNT h4\$ BeeN CR34t3d BU+ beF0R3 J00 C@n St4r+ POST1N9 J00 MUST ConFIRM YOur emAIl @dDRESS. PL3ASE CH3CK YOUR 3m@Il Ph0R a L1NK tH4t W1Ll 4LLOw J00 +O C0NPhIRm Y0UR 4dDREss.";
$lang['useraccountcreated'] = "y0ur US3R @CcouNT H4s B3EN CRE4T3D SucCe5sPhULlY! cLiCK THE cON+1NU3 BuT+ON BEl0w TO l091N";
$lang['errorcreatinguserrecord'] = "eRr0R CrE@TiN9 U5ER r3cORd";
$lang['userregistration'] = "u53R RE915+R4TI0N";
$lang['registrationinformationrequired'] = "r39iS+Ra+1ON 1NPHORMAti0N (R3QUIRed)";
$lang['profileinformationoptional'] = "pR0pHIL3 InPHOrM4+1oN (0PTI0N4L)";
$lang['preferencesoptional'] = "pR3pHer3nCE\$ (Opt10N4L)";
$lang['register'] = "rE91ST3R";
$lang['rememberpasswd'] = "reMEmBER pa\$SWOrD";
$lang['birthdayrequired'] = "d4t3 0F 81R+H 1\$ Requ1RED or 1S InV4l1D";
$lang['alwaysnotifymeofrepliestome'] = "n0+iFY 0N RePLY t0 m3";
$lang['notifyonnewprivatemessage'] = "nOt1fY ON neW priV4T3 M3sS@ge";
$lang['popuponnewprivatemessage'] = "pop UP 0N N3W Pr1v4T3 M3\$S@gE";
$lang['automatichighinterestonpost'] = "aUt0M@+1c hIGh IN+erESt 0N PosT";
$lang['confirmpassword'] = "c0npH1Rm P4SSW0Rd";
$lang['invalidemailaddressformat'] = "inv4L1D EMaIL 4DDRe\$S PhORM@t";
$lang['moreoptionsavailable'] = "m0RE pROF1L3 ANd PR3PHER3NC3 OPtI0NS aR3 4V@1L48L3 0NC3 J00 R39I\$T3R";
$lang['textcaptchaconfirmation'] = "c0nF1RM4T10N";
$lang['textcaptchaexplain'] = "tO TEh R19H+ i\$ 4 +3XT-cAPtCHa IM49E. pL3A\$3 tYPe +Eh c0d3 J00 CAn \$3e iN +H3 1M49E iN+0 TeH InpUT PHIeLD 8ELow 1T.";
$lang['textcaptchaimgtip'] = "th1\$ IS 4 C@pTCH@-PIcTURE. 1+ i\$ u5ed +O pr3V3n+ 4UT0M4+1c R39IS+Ra+I0N";
$lang['textcaptchamissingkey'] = "a c0NF1RM4T1ON cODE I\$ R3qu1RED.";
$lang['textcaptchaverificationfailed'] = "teX+-C4P+cH4 V3RIF1C4+i0N coDe w4\$ 1NCOrrECT. PleA53 R3-en+3R 1+.";
$lang['forumrules'] = "forUM RUL35";
$lang['forumrulesnotification'] = "in oRD3R TO pr0c3ED, J00 MUST 4grE3 Wi+H Teh FOLL0W1N9 RUL3\$";
$lang['forumrulescheckbox'] = "i h4v3 R34D, 4ND aGR33 TO @bIDE 8Y +Eh Ph0rUm Rul3s.";
$lang['youmustagreetotheforumrules'] = "j00 MUST aGr33 T0 t3h F0RUM RULES 8eF0RE j00 C4N con+1NUe.";

// Recent visitors list  (visitor_log.php) -----------------------------

$lang['member'] = "meM83r";
$lang['searchforusernotinlist'] = "sEARCh FOR 4 USEr NO+ 1N Lis+";
$lang['yoursearchdidnotreturnanymatches'] = "yOur S3ArCH D1D N0T r3+uRN @Ny MA+chEs. trY sIMPLIpHYIng YOUR \$34rCH pAR4METERS anD +ry AGaiN.";
$lang['hiderowswithemptyornullvalues'] = "h1dE R0WS w1+H emPty 0r NUll v4lUE5 In \$3L3CT3d COlUMNs";
$lang['showregisteredusersonly'] = "sH0w R3G1\$T3R3D US3r5 oNLy (h1d3 9UES+S)";

// Relationships (user_rel.php) ----------------------------------------

$lang['relationships'] = "rEL@T10N\$HIPS";
$lang['userrelationship'] = "us3r R3LA+1on\$HIP";
$lang['userrelationships'] = "u53R REL4t10n5hIP\$";
$lang['failedtoremoveselectedrelationships'] = "f4il3d +0 REMOvE S3L3C+3D R3l4t10N\$H1P";
$lang['friends'] = "fri3NDs";
$lang['ignoredcompletely'] = "iGN0REd c0MPL3+ELy";
$lang['relationship'] = "rel@+10nSHIP";
$lang['restorenickname'] = "r3s+OR3 US3R'S n1ckN4ME";
$lang['friend_exp'] = "us3R'S p0sTS m@RkeD w1+H 4 &quot;PHRieND&quot; 1CON.";
$lang['normal_exp'] = "useR's P0\$T\$ App3@R a\$ NORm@L.";
$lang['ignore_exp'] = "uS3r'5 P0\$TS 4rE HidD3N.";
$lang['ignore_completely_exp'] = "thr3aDs aND POSTs +0 0R Fr0m US3r W1lL 4pP3@R D3LeT3d.";
$lang['display'] = "d1\$pL@y";
$lang['displaysig_exp'] = "u\$Er'S S1GN4Ture IS d1spLay3D oN +h31R P0\$TS.";
$lang['hidesig_exp'] = "u\$ER'S S19N4+URe I\$ HIdDen 0N +hEIr p0S+\$.";
$lang['cannotignoremod'] = "j00 C4NNO+ IGN0R3 +HIS U\$3r, A\$ +H3y 4RE a M0dER@+0r.";
$lang['previewsignature'] = "pR3vIEW sIGNa+UR3";

// Search (search.php) -------------------------------------------------

$lang['searchresults'] = "se4Rch r3sULTs";
$lang['usernamenotfound'] = "thE us3RN4m3 j00 \$PEc1pHIED 1N T3H +0 OR PhR0M F13lD W@S NO+ F0UND.";
$lang['notexttosearchfor'] = "oNe OR 4lL OF yOUR s34RCH kEYWorDS W3R3 InvAliD. s34RCH K3YW0RD\$ MUs+ 8e N0 ShoRt3r +h4n %d CH4R4C+3RS, NO l0nGEr +H4N %d ch4raCT3R\$ 4ND mUSt N0+ 4pPe4r 1N +he %s";
$lang['keywordscontainingerrors'] = "kEYWOrD\$ COnt4IN1Ng 3RRorS: %s";
$lang['mysqlstopwordlist'] = "mY5qL STOPW0rd LI\$t";
$lang['foundzeromatches'] = "fOuND: 0 M4+CheS";
$lang['found'] = "f0unD";
$lang['matches'] = "m@+cHES";
$lang['prevpage'] = "pReVI0uS P@ge";
$lang['findmore'] = "fInD MOr3";
$lang['searchmessages'] = "s34rCH m3\$549ES";
$lang['searchdiscussions'] = "s34rCH Di\$CU\$sioNS";
$lang['find'] = "f1nd";
$lang['additionalcriteria'] = "aDDi+10N4L Cri+3R14";
$lang['searchbyuser'] = "sE4rCH 8y U5ER (0pTIOn4l)";
$lang['folderbrackets_s'] = "f0LDER(s)";
$lang['postedfrom'] = "posT3D FROm";
$lang['postedto'] = "p0\$tED +0";
$lang['today'] = "t0d4Y";
$lang['yesterday'] = "y3\$+3rD4Y";
$lang['daybeforeyesterday'] = "d@Y BEPHor3 YesT3RdaY";
$lang['weekago'] = "%s w3eK 490";
$lang['weeksago'] = "%s w3ek\$ Ag0";
$lang['monthago'] = "%s m0nTH 490";
$lang['monthsago'] = "%s m0nTH\$ AG0";
$lang['yearago'] = "%s yE4R @9o";
$lang['beginningoftime'] = "bEGInn1N9 0PH tiME";
$lang['now'] = "nOw";
$lang['lastpostdate'] = "l4s+ po\$T D4TE";
$lang['numberofreplies'] = "nuM83R of R3Pl1eS";
$lang['foldername'] = "f0LD3R n4m3";
$lang['authorname'] = "au+HOr N4ME";
$lang['decendingorder'] = "n3WESt fIRST";
$lang['ascendingorder'] = "oldes+ PHiRS+";
$lang['keywords'] = "keyWORDs";
$lang['sortby'] = "s0r+ By";
$lang['sortdir'] = "sor+ D1R";
$lang['sortresults'] = "sORT R3sulT\$";
$lang['groupbythread'] = "gRoUP bY thr3@D";
$lang['postsfromuser'] = "p0sTS PhROM u\$ER";
$lang['threadsstartedbyuser'] = "thrEAD\$ \$+@R+3D BY USER";
$lang['searchfrequencyerror'] = "j00 C4N 0NLy \$E4RCH 0nC3 EV3Ry %s \$3CONDs. PlE4sE TrY @9@iN l4ter.";
$lang['searchsuccessfullycompleted'] = "se4rcH SUcC3sSFULlY coMpl3+3D. %s";
$lang['clickheretoviewresults'] = "cLICK h3rE TO v1EW rE5UL+s.";

// Search Popup (search_popup.php) -------------------------------------

$lang['select'] = "selEC+";
$lang['searchforthread'] = "s34rCH pHOR +HREAd";
$lang['mustspecifytypeofsearch'] = "j00 MU5+ sPEC1Fy TYp3 Oph 5eARCh +O PErF0rM";
$lang['unkownsearchtypespecified'] = "uNkNOwn S3ARcH tYP3 SpECif13D";
$lang['mustentersomethingtosearchfor'] = "j00 MUST 3N+3R sOM3+H1NG TO s34RCh Ph0r";

// Start page (start_left.php) -----------------------------------------

$lang['recentthreads'] = "r3ceNt ThR3AD\$";
$lang['startreading'] = "s+4RT rE@DinG";
$lang['threadoptions'] = "tHr3@D OpT10NS";
$lang['editthreadoptions'] = "eD1t +HRE4D oP+10NS";
$lang['morevisitors'] = "m0r3 vI\$1tORS";
$lang['forthcomingbirthdays'] = "f0rTHC0M1N9 81RtHD4Y5";

// Start page (start_main.php) -----------------------------------------

$lang['editstartpage_help'] = "j00 C4N 3D1T +h1\$ P@g3 FR0M +HE @DMin 1N+3rpH4CE";

// Thread navigation (thread_list.php) ---------------------------------

$lang['newdiscussion'] = "n3w D1SCUss1oN";
$lang['createpoll'] = "cR34+3 P0LL";
$lang['search'] = "s34RCh";
$lang['searchagain'] = "se4rCH AG41N";
$lang['alldiscussions'] = "alL DIscUSS10Ns";
$lang['unreaddiscussions'] = "uNr3@D dISCU\$5i0nS";
$lang['unreadtome'] = "unre4D &quot;tO: m3&quot;";
$lang['todaysdiscussions'] = "t0d@Y'\$ DI\$Cu\$s1oNS";
$lang['2daysback'] = "2 d@YS bACk";
$lang['7daysback'] = "7 D4YS b4cK";
$lang['highinterest'] = "hI9h 1nt3R3\$+";
$lang['unreadhighinterest'] = "unr34d hIGH in+ErEST";
$lang['iverecentlyseen'] = "i'v3 REc3nTly S3EN";
$lang['iveignored'] = "i'v3 IGn0r3D";
$lang['byignoredusers'] = "by 19NOR3D US3R5";
$lang['ivesubscribedto'] = "i'v3 SUBScrI8ED +0";
$lang['startedbyfriend'] = "sTaRT3d 8Y PhR1END";
$lang['unreadstartedbyfriend'] = "uNrE@D s+D by pHRIENd";
$lang['startedbyme'] = "sT4RTeD 8y M3";
$lang['unreadtoday'] = "uNr3aD +oDaY";
$lang['deletedthreads'] = "dEL3+3D thR3@DS";
$lang['goexcmark'] = "g0!";
$lang['folderinterest'] = "foldER 1nT3RE\$T";
$lang['postnew'] = "p0st N3W";
$lang['currentthread'] = "curRENT thR3AD";
$lang['highinterest'] = "h1gH in+3R3ST";
$lang['markasread'] = "m@RK 45 RE@d";
$lang['next50discussions'] = "nex+ 50 DI\$cuSS10N5";
$lang['visiblediscussions'] = "v1SIBlE Di\$CUSs10n5";
$lang['selectedfolder'] = "sEL3C+ED pH0lD3r";
$lang['navigate'] = "nAv1g4+3";
$lang['couldnotretrievefolderinformation'] = "tHeR3 4R3 N0 pHOLDeRs @v4IL4BLE.";
$lang['nomessagesinthiscategory'] = "no M3ss@935 1n +H1S c4+390RY. plE@\$3 \$3leC+ 4NOTHEr, 0R %s FOr ALl THrE4d\$";
$lang['clickhere'] = "cl1ck HERe";
$lang['prev50threads'] = "pR3V10Us 50 ThR34D5";
$lang['next50threads'] = "nExt 50 +HreADs";
$lang['nextxthreads'] = "nex+ %s +HREAd\$";
$lang['threadstartedbytooltip'] = "tHrE4d #%s S+4R+3d By %s. vIEW3d %s";
$lang['threadviewedonetime'] = "1 +1ME";
$lang['threadviewedtimes'] = "%d +iM3s";
$lang['unreadthread'] = "unR34D THr3@D";
$lang['readthread'] = "re4d +HrE4D";
$lang['unreadmessages'] = "uNre4D M3SS49E\$";
$lang['subscribed'] = "su8\$CRIbED";
$lang['stickythreads'] = "s+iCKY thR34dS";
$lang['mostunreadposts'] = "m0st UNr3@d PO\$ts";
$lang['onenew'] = "%d New";
$lang['manynew'] = "%d nEW";
$lang['onenewoflength'] = "%d n3W 0F %d";
$lang['manynewoflength'] = "%d neW of %d";
$lang['confirmmarkasread'] = "aRE J00 \$urE j00 W4N+ +O M@rK THe \$3l3c+3D thr34DS 4s r3AD?";
$lang['successfullymarkreadselectedthreads'] = "succ3\$5fULLY M@rkEd \$3L3c+3D ThREAd\$ 4s R3AD";
$lang['failedtomarkselectedthreadsasread'] = "f41L3d +O m@RK SELecteD +hrE4dS A\$ RE@D";
$lang['gotofirstpostinthread'] = "gO +O PHIR5+ pO\$T 1N +hR34D";
$lang['gotolastpostinthread'] = "go TO l@sT P05T In ThRE4D";
$lang['viewmessagesinthisfolderonly'] = "v13W M3sS@G3S IN THi5 FOld3R OnLY";
$lang['shownext50threads'] = "show NEXt 50 ThR3AD\$";
$lang['showprev50threads'] = "sh0w PReVI0US 50 +HrE4DS";
$lang['createnewdiscussioninthisfolder'] = "cRe4+3 NEw D1SCUSS1on In ThIS Ph0LDER";
$lang['nomessages'] = "no m3sSAGes";

// HTML toolbar (htmltools.inc.php) ------------------------------------
$lang['bold'] = "boLd";
$lang['italic'] = "i+4LIc";
$lang['underline'] = "undERL1NE";
$lang['strikethrough'] = "sTRIkeThROU9H";
$lang['superscript'] = "supeRSCRiP+";
$lang['subscript'] = "su8\$CriPt";
$lang['leftalign'] = "lepH+-4l19N";
$lang['center'] = "c3n+3R";
$lang['rightalign'] = "ri9h+-aL1GN";
$lang['numberedlist'] = "nUM83r3D L1s+";
$lang['list'] = "l1s+";
$lang['indenttext'] = "iNd3N+ +3xt";
$lang['code'] = "c0D3";
$lang['quote'] = "qUo+3";
$lang['unquote'] = "uNQU0TE";
$lang['spoiler'] = "sp01lER";
$lang['horizontalrule'] = "h0rIzoN+al ruLe";
$lang['image'] = "im49e";
$lang['hyperlink'] = "hYPERlINk";
$lang['noemoticons'] = "dI548L3 3M0T1CON\$";
$lang['fontface'] = "fOnT ph@c3";
$lang['size'] = "s1Z3";
$lang['colour'] = "c0L0uR";
$lang['red'] = "r3d";
$lang['orange'] = "or@N93";
$lang['yellow'] = "yelloW";
$lang['green'] = "gre3n";
$lang['blue'] = "bLu3";
$lang['indigo'] = "iNdiG0";
$lang['violet'] = "vIoL3T";
$lang['white'] = "wHiTe";
$lang['black'] = "bl@CK";
$lang['grey'] = "gR3y";
$lang['pink'] = "p1nK";
$lang['lightgreen'] = "lIGHT 9r3EN";
$lang['lightblue'] = "l19HT 8LU3";

// Forum Stats --------------------------------

$lang['forumstats'] = "f0rUM 5+@ts";
$lang['userstats'] = "u53R St4+5";

$lang['usersactiveinthepasttimeperiod'] = "%s 4CTiv3 1N +3H pAST %s. %s";

$lang['numactiveguests'] = "<b>%s</b> GUe\$+5";
$lang['oneactiveguest'] = "<b>1</b> guE\$t";
$lang['numactivemembers'] = "<b>%s</b> M3m8Er\$";
$lang['oneactivemember'] = "<b>1</b> MeM83R";
$lang['numactiveanonymousmembers'] = "<b>%s</b> 4nONYm0uS MembeR\$";
$lang['oneactiveanonymousmember'] = "<b>1</b> 4N0NYm0uS meMb3R";

$lang['numthreadscreated'] = "<b>%s</b> THrE@D\$";
$lang['onethreadcreated'] = "<b>1</b> tHR3@D";
$lang['numpostscreated'] = "<b>%s</b> p0\$TS";
$lang['onepostcreated'] = "<b>1</b> po\$T";

$lang['younormal'] = "j00";
$lang['youinvisible'] = "j00 (1nVISi8lE)";
$lang['viewcompletelist'] = "v1ew coMpLEt3 l1\$T";
$lang['ourmembershavemadeatotalofnumthreadsandnumposts'] = "our MEMB3Rs h4VE m@DE 4 TO+4l OF %s 4ND %s.";
$lang['longestthreadisthreadnamewithnumposts'] = "loN93s+ +HRE4D 1\$ <b>%s</b> WitH %s.";
$lang['therehavebeenxpostsmadeinthelastsixtyminutes'] = "th3re H4V3 B3eN <b>%s</b> PO\$+s m@DE 1n +eH L4ST 60 MiNU+es.";
$lang['therehasbeenonepostmadeinthelastsxityminutes'] = "ther3 H4S 8E3N <b>1</b> Po\$T M4D3 1N tHE L@S+ 60 MiNU+3\$.";
$lang['mostpostsevermadeinasinglesixtyminuteperiodwasnumposts'] = "mo\$+ PO\$tS 3VER MADe In 4 \$IngL3 60 MInUTE peRI0D is <b>%s</b> 0N %s.";
$lang['wehavenumregisteredmembersandthenewestmemberismembername'] = "wE H@VE <b>%s</b> RE9IST3r3d M3MBer\$ 4ND +h3 N3W3S+ MEMb3R is <b>%s</b>.";
$lang['wehavenumregisteredmember'] = "wE HAV3 %s R3g15+3REd M3M8ER\$.";
$lang['wehaveoneregisteredmember'] = "wE H4VE onE r39I\$T3reD MEMbeR.";
$lang['mostuserseveronlinewasnumondate'] = "m0st U\$3R5 Ev3r Onl1NE W4S <b>%s</b> 0n %s.";
$lang['statsdisplaychanged'] = "sta+S D1spL4Y ch@n93D";

$lang['viewtop20'] = "v1ew +0P 20";

$lang['folderstats'] = "fOLD3R \$+4T\$";
$lang['threadstats'] = "thrE@D s+@+\$";
$lang['poststats'] = "po\$+ S+@t\$";
$lang['pollstats'] = "pOLL s+4+S";
$lang['attachmentsstats'] = "att@CHM3NTS \$+@tS";
$lang['userpreferencesstats'] = "u\$3R pREPH3REnCE5 St4tS";
$lang['visitorstats'] = "v15i+or \$t@TS";
$lang['sessionstats'] = "sE\$s10N St@T\$";
$lang['profilestats'] = "pr0PHiL3 5+4TS";
$lang['signaturestats'] = "sI9nA+uR3 5+A+s";
$lang['ageandbirthdaystats'] = "age 4ND biR+hDAy \$T@TS";
$lang['relationshipstats'] = "r3l@T10N\$H1P S+@TS";
$lang['wordfilterstats'] = "w0RD fILtER st@TS";

$lang['numberoffolders'] = "nUmbER 0PH pH0LDErS";
$lang['folderwithmostthreads'] = "f0lDEr w1+H m0ST +hR34DS";
$lang['folderwithmostposts'] = "fOlDER w1+H Mo\$t PO\$+s";
$lang['totalnumberofthreads'] = "tO+4l numB3R Oph +HR34ds";
$lang['longestthread'] = "lONGE\$T +HR3AD";
$lang['mostreadthread'] = "mOs+ R3@D THr34d";
$lang['threadviews'] = "vI3wS";
$lang['averagethreadcountperfolder'] = "aV3R4GE tHR3@D coUn+ P3R pHOLdER";
$lang['totalnumberofthreadsubscriptions'] = "t0t4L Numb3R OF THRe4d \$uBSCr1p+1ON\$";
$lang['mostpopularthreadbysubscription'] = "mOsT p0PUL@r Thr34D 8Y SUb\$cRIpT10N";
$lang['totalnumberofposts'] = "t0+@L NUmb3R 0f POSts";
$lang['numberofpostsmadeinlastsixtyminutes'] = "num83R 0PH p0S+S m4d3 IN l45+ 60 m1nuT3S";
$lang['mostpostsmadeinasinglesixtyminuteperiod'] = "moSt P0ST\$ M4D3 In ONE 60 M1NUtE PerIOD";
$lang['averagepostsperuser'] = "aVER4G3 POSts Per US3r";
$lang['topposter'] = "tOp P0\$t3r";
$lang['totalnumberofpolls'] = "tOT4l nUM8ER oPh P0LL\$";
$lang['totalnumberofpolloptions'] = "tot4l nuMb3r 0f p0lL opT1ONs";
$lang['averagevotesperpoll'] = "av3RG3 vo+3S PEr P0Ll";
$lang['totalnumberofpollvotes'] = "t0T@L nuMber oPH p0ll V0+35";
$lang['totalnumberofattachments'] = "tO+@L nuM83R 0ph 4TT4chMEn+S";
$lang['averagenumberofattachmentsperpost'] = "aV3r4G3 @++AChmeN+ C0uNT PEr POS+";
$lang['mostdownloadedattachment'] = "m0S+ DOWnLO@dED 4+t@CHM3n+";
$lang['mostusedforumstyle'] = "m0\$+ u\$3D ForUm STYl3";
$lang['mostusedlanguuagefile'] = "m0St U\$3D L@ngU@gE F1LE";
$lang['mostusedtimezone'] = "m0\$T uS3d tim3Z0N3";
$lang['mostusedemoticonpack'] = "m0ST u\$3D 3MOTic0N PacK";

$lang['numberofusers'] = "nUm8eR OF US3Rs";
$lang['newestuser'] = "nEWES+ US3R";
$lang['numberofcontributingusers'] = "nUMB3R of C0N+rIBUt1N9 US3RS";
$lang['numberofnoncontributingusers'] = "numbEr 0f noN-c0N+rIBUTiNG U\$3RS";
$lang['subscribers'] = "subsCr183r\$";

$lang['numberofvisitorstoday'] = "numb3r OF VI\$1toRS +OD@Y";
$lang['numberofvisitorsthisweek'] = "numb3R OF V1S1T0R\$ +h1\$ w3EK (PER1OD: %s +0 %s)";
$lang['numberofvisitorsthismonth'] = "nUM8eR 0F Vi\$1+0Rs +h1\$ MOn+H";
$lang['numberofvisitorsthisyear'] = "nUMB3R OF VI\$1+0RS +hIS Y3AR";

$lang['totalnumberofactiveusers'] = "t0T4L num83R 0F @C+1V3 USeR\$";
$lang['numberofactiveregisteredusers'] = "num83r OF @C+1VE r39i\$t3RED us3r\$";
$lang['numberofactiveguests'] = "nUMbeR 0F 4c+1V3 GueS+s";
$lang['mostuserseveronline'] = "mOST U\$ER\$ eV3R 0NLInE";
$lang['mostactiveuser'] = "m0sT 4C+1VE USer";
$lang['numberofuserswithprofile'] = "nUm83r Of UsER\$ wiTH pROF1l3";
$lang['numberofuserswithoutprofile'] = "nUmB3R OPh USEr\$ W1TH0UT PR0PHiLE";
$lang['numberofuserswithsignature'] = "nuM8eR 0F US3r5 WITh S1GN4TUre";
$lang['numberofuserswithoutsignature'] = "num83r OF us3RS W1+hoUT s1gN4tUrE";
$lang['averageage'] = "aVER49E 4G3";
$lang['mostpopularbirthday'] = "mo5+ p0pUL4R 81RThD4Y";
$lang['nobirthdaydataavailable'] = "nO B1RTHd4y d@+4 AvaIl48l3";
$lang['numberofusersusingwordfilter'] = "nUmBEr OF uSEr\$ U51Ng WOrD Ph1l+ER";
$lang['numberofuserreleationships'] = "nUmB3R Of US3R rEL3@T10nsHiPS";
$lang['averageage'] = "avER49E 49E";
$lang['averagerelationshipsperuser'] = "aV3RAG3 r3l4+10NSH1PS peR US3r";

$lang['numberofusersnotusingwordfilter'] = "numB3R 0f US3RS noT u\$InG w0RD pHIlT3R";
$lang['averagewordfilterentriesperuser'] = "aV3R493 WOrD phILt3R 3NtRIEs P3R us3R";

$lang['mostuserseveronlinedetail'] = "%s ON %s";

// Thread Options (thread_options.php) ---------------------------------

$lang['updatessavedsuccessfully'] = "uPD4tE\$ S4V3D \$uCC3S5fULlY";
$lang['useroptions'] = "us3R OPTIONS";
$lang['markedasread'] = "m4rk3d 4s READ";
$lang['postsoutof'] = "p05+S 0UT 0pH";
$lang['interest'] = "in+3reS+";
$lang['closedforposting'] = "cl0sED PHOr P0ST1NG";
$lang['locktitleandfolder'] = "lOCK Ti+L3 @nD pH0LDer";
$lang['deletepostsinthreadbyuser'] = "d3l3tE pO\$+s IN ThR34D bY Us3r";
$lang['deletethread'] = "d3le+3 ThR3@D";
$lang['permenantlydelete'] = "perm@NEN+LY D3l3TE";
$lang['movetodeleteditems'] = "m0v3 T0 Del3+3D +hREAds";
$lang['undeletethread'] = "undeL3+3 +hrE4D";
$lang['markasunread'] = "m4rK @S UNRe4D";
$lang['makethreadsticky'] = "m4k3 THR3@d STiCKy";
$lang['threareadstatusupdated'] = "tHreAD r34d St4+U\$ uPd@T3D 5ucc3\$SFulLy";
$lang['interestupdated'] = "thrEAd IN+3r3st S+@tUS uPD4+3D \$uccEs5phuLly";
$lang['failedtoupdatethreadreadstatus'] = "f41l3d +0 UPD4+E +HreAd R3@D ST4TUS";
$lang['failedtoupdatethreadinterest'] = "fA1l3D T0 uPD4T3 +hR34D 1N+erES+";
$lang['failedtorenamethread'] = "f41l3D +O RENamE +hRE4D";
$lang['failedtomovethread'] = "f41l3D +0 m0v3 +hre4D +o SPeCIFIED F0LD3R";
$lang['failedtoupdatethreadstickystatus'] = "f@1L3D +0 UPd4t3 THR34d S+1CkY \$T@+Us";
$lang['failedtoupdatethreadclosedstatus'] = "f@1lED +O UpdaTE tHr34D cl0\$3d \$+@Tus";
$lang['failedtoupdatethreadlockstatus'] = "f@1l3d +o UPd@TE +HrE4D LOck ST4+us";
$lang['failedtodeletepostsbyuser'] = "f@1LED +0 DEL3T3 P0\$Ts 8Y \$3LecTEd USEr";
$lang['failedtodeletethread'] = "f4iLED +o D3lE+3 +HrEAD.";
$lang['failedtoundeletethread'] = "f4iL3D +0 UN-deLe+3 tHr34d";

// Folder Options (folder_options.php) ---------------------------------

$lang['folderoptions'] = "fOlDer 0p+10N\$";
$lang['foldercouldnotbefound'] = "tHe REqu3stED PhoLdeR C0Uld NO+ BE FOUnD OR 4cCESS WA\$ d3n13D.";
$lang['failedtoupdatefolderinterest'] = "f4IL3D +0 UPda+E f0LD3R In+ERe\$T";

// Dictionary (dictionary.php) -----------------------------------------

$lang['dictionary'] = "d1c+10NARy";
$lang['spellcheck'] = "sP3lL cH3CK";
$lang['notindictionary'] = "nO+ 1n d1cT10N@ry";
$lang['changeto'] = "chAn93 T0";
$lang['restartspellcheck'] = "r35+@rt";
$lang['cancelchanges'] = "c4NC3L chANGes";
$lang['initialisingdotdotdot'] = "ini+14lISin9...";
$lang['spellcheckcomplete'] = "sP3LL chEcK i\$ COmpLE+e. To R3S+@r+ sPEll CH3Ck Cl1cK RES+@r+ bU++oN bELow.";
$lang['spellcheck'] = "speLL cH3CK";
$lang['noformobj'] = "n0 F0rM 08jEC+ \$PECifIEd F0R Re+uRn t3xt";
$lang['bodytext'] = "b0dY +ex+";
$lang['ignore'] = "ignoR3";
$lang['ignoreall'] = "i9n0R3 4LL";
$lang['change'] = "cH4NGe";
$lang['changeall'] = "cH@NGe 4lL";
$lang['add'] = "aDd";
$lang['suggest'] = "su99es+";
$lang['nosuggestions'] = "(no 5UGGe\$t10n\$)";
$lang['cancel'] = "c@NC3L";
$lang['dictionarynotinstalled'] = "nO DIc+10n4rY H4s b33n INs+All3D. pLE4S3 Con+@C+ +3H Ph0rUM 0wN3R +O REm3dY +HIS.";

// Permissions keys ----------------------------------------------------

$lang['postreadingallowed'] = "p0ST rE4dINg @LL0Wed";
$lang['postcreationallowed'] = "p0\$t crE4+I0N ALl0wED";
$lang['threadcreationallowed'] = "tHrE4D Cr3@Ti0n @llOWED";
$lang['posteditingallowed'] = "p0st 3DI+1NG 4llOW3D";
$lang['postdeletionallowed'] = "pO\$t D3L3TIOn 4LL0WEd";
$lang['attachmentsallowed'] = "aT+4ChmeN+S 4LLOwED";
$lang['htmlpostingallowed'] = "htmL p0sTinG 4lLOWed";
$lang['signatureallowed'] = "sIgN4+Ur3 4lL0w3d";
$lang['guestaccessallowed'] = "gu3S+ aCCESS @LLOW3D";
$lang['postapprovalrequired'] = "pOST 4pPR0v@l r3QuIReD";

// RSS feeds gubbins

$lang['rssfeed'] = "rS\$ FE3D";
$lang['every30mins'] = "ev3RY 30 mInu+3\$";
$lang['onceanhour'] = "once 4N h0uR";
$lang['every6hours'] = "ev3rY 6 H0ur\$";
$lang['every12hours'] = "eVERY 12 HOurS";
$lang['onceaday'] = "onc3 4 DaY";
$lang['onceaweek'] = "oNcE 4 We3K";
$lang['rssfeeds'] = "rss F3EDS";
$lang['feedname'] = "f3eD NAme";
$lang['feedfoldername'] = "feED f0LD3R n4M3";
$lang['feedlocation'] = "f3ed L0C4T10N";
$lang['threadtitleprefix'] = "tHR3@D t1+Le PRepHIx";
$lang['feednameandlocation'] = "fe3D n@M3 4nd LOc4+IOn";
$lang['feedsettings'] = "f3eD 5E+TINgs";
$lang['updatefrequency'] = "upd@TE pHR3QUEnCY";
$lang['rssclicktoreadarticle'] = "cL1cK H3R3 tO r34d ThIs @R+icL3";
$lang['addnewfeed'] = "add N3W pHEed";
$lang['editfeed'] = "eDI+ f33d";
$lang['feeduseraccount'] = "feed us3r 4cC0UNT";
$lang['noexistingfeeds'] = "n0 EX15+iN9 Rss PH33D5 fouND. t0 AdD 4 Fe3D CLiCK +HE 'ADd New' Bu++0N bEl0W";
$lang['rssfeedhelp'] = "hER3 J00 C4n S3+up SOME RSS F33D\$ PhoR aUT0M@t1C Pr0p4GAti0N 1Nt0 Y0UR phORuM. TEH i+EMS phROm TH3 Rs\$ fEED\$ J00 Add wiLL BE CRE@t3D 4S +hREADS WH1CH uSErs c4n R3Ply T0 4S iF THey weR3 N0RM@L pOSTs. +h3 RSS pH33d musT 83 4Cc3ssI8L3 Vi@ HttP 0R iT w1LL NO+ W0RK.";
$lang['mustspecifyrssfeedname'] = "mus+ SPec1PHY RSS pH33d N4Me";
$lang['mustspecifyrssfeeduseraccount'] = "mu\$+ SPeC1PHY rSS Ph3eD U\$3R Acc0UNT";
$lang['mustspecifyrssfeedfolder'] = "must SP3C1fy RSS f3ED F0LD3R";
$lang['mustspecifyrssfeedurl'] = "mu5+ sP3CIfy R\$s F33D UrL";
$lang['mustspecifyrssfeedupdatefrequency'] = "mUS+ sPEC1PHy RSs F33D Upd4+3 FReQU3NCy";
$lang['unknownrssuseraccount'] = "uNkN0WN R\$S u\$eR @cCOUn+";
$lang['rssfeedsupportshttpurlsonly'] = "r\$\$ PhEEd SUPporTS Ht+P uRLs 0NLy. S3CURe F3EDS (HtTPS://) ARE n0T suPP0RT3D.";
$lang['rssfeedurlformatinvalid'] = "r\$S FE3D urL PHorM4+ 1s 1NV4l1D. urL mUs+ 1NCluDE sCh3M3 (e.G. H++P://) 4nd 4 Ho\$tn@ME (3.9. wWW.HO\$+n@M3.COm).";
$lang['rssfeeduserauthentication'] = "rsS PH3ed do3\$ N0+ \$UPP0R+ hTtP u\$3R au+H3N+1c@+i0N";
$lang['successfullyremovedselectedfeeds'] = "sucCESSphULLY R3MOVEd S3LEc+ED FE3Ds";
$lang['successfullyaddedfeed'] = "sUcC3\$sPhULLy @ddED nEW feEd";
$lang['successfullyeditedfeed'] = "succE5sfULly 3D1TED FE3d";
$lang['failedtoremovefeeds'] = "f4il3D TO remOVE SOME 0r 4LL Oph +hE \$3L3C+3d Ph3eD\$";
$lang['failedtoaddnewrssfeed'] = "f41leD t0 4DD nEW RSS f3ED";
$lang['failedtoupdaterssfeed'] = "f41L3D +o UPd4+3 RSS f3eD";
$lang['rssstreamworkingcorrectly'] = "r\$\$ S+reAm 4PPE4Rs tO 83 w0rK1N9 c0rRECtLY";
$lang['rssstreamnotworkingcorrectly'] = "rS\$ S+rEAM wA\$ EMPty 0R C0Uld N0+ be Ph0uND";
$lang['invalidfeedidorfeednotfound'] = "iNv@LID pHe3D ID OR PHeeD noT PH0UND";

// PM Export Options

$lang['pmexportastype'] = "exPor+ @S TYPE";
$lang['pmexporthtml'] = "h+ML";
$lang['pmexportxml'] = "xml";
$lang['pmexportplaintext'] = "pl41n T3xT";
$lang['pmexportmessagesas'] = "eXPOrt M3SS@93s 4S";
$lang['pmexportonefileforallmessages'] = "on3 PHIl3 F0R @lL m3\$sAGes";
$lang['pmexportonefilepermessage'] = "on3 PHILE P3R M3ss4gE";
$lang['pmexportattachments'] = "eXp0RT a+T@ChmEN+S";
$lang['pmexportincludestyle'] = "iNCLUDE phorUm S+YLe \$H33+";
$lang['pmexportwordfilter'] = "apPLY woRD f1L+3r t0 M3\$S@geS";

// Thread merge / split options

$lang['threadhasbeensplit'] = "tHRE@d Ha\$ b3en SPLI+";
$lang['threadhasbeenmerged'] = "thr3@D Has B3EN m3rGEd";
$lang['mergesplitthread'] = "mer93 / \$PLi+ +hrEAD";
$lang['mergewiththreadid'] = "mEr93 W1+h +HR34d 1D:";
$lang['postsinthisthreadatstart'] = "p0STS 1N +H1\$ +HrEAd 4+ \$+4RT";
$lang['postsinthisthreadatend'] = "poST\$ In THi\$ +hr3AD 4+ 3Nd";
$lang['reorderpostsintodateorder'] = "r3-oRD3R PO\$ts 1n+0 D@te ORDEr";
$lang['splitthreadatpost'] = "sPL1T ThR3@D @T POST:";
$lang['selectedpostsandrepliesonly'] = "seleC+3D poST @ND R3pl1E\$ 0nLy";
$lang['selectedandallfollowingposts'] = "sEl3cTed 4nD @lL pH0LL0WIn9 P0s+S";

$lang['threadmovedhere'] = "h3r3";

$lang['thisthreadhasmoved'] = "<b>tHRE4Ds MERGED:</b> thi\$ +HR34D H@s movED %s";
$lang['thisthreadwasmergedfrom'] = "<b>tHRE@D\$ MEr9ed:</b> TH1\$ thR3@d W@S M3RGed FROM %s";
$lang['somepostsinthisthreadhavebeenmoved'] = "<b>thR34D SplI+:</b> \$0ME po\$+S 1N TH1S thR34D H4Ve 833N m0V3D %s";
$lang['somepostsinthisthreadweremovedfrom'] = "<b>tHrEAD \$PLI+:</b> \$Ome p0sts 1N Thi\$ +HREaD WeRE moVed FR0M %s";

$lang['thisposthasbeenmoved'] = "<b>tHR3@D \$pLI+:</b> THi\$ po\$t h@\$ bE3n M0VED %s";

$lang['invalidfunctionarguments'] = "inv4l1D FUNctION @RGUM3Nts";
$lang['couldnotretrieveforumdata'] = "c0uLD NO+ r3+R1Eve F0RUM d4T@";
$lang['cannotmergepolls'] = "on3 0R M0R3 +HrE4ds IS @ PolL. j00 C@NNO+ MeRGE pOLL\$";
$lang['couldnotretrievethreaddatamerge'] = "couLD Not RetR13Ve +Hr34d D4+4 Phr0M 0N3 0R M0R3 +HrE4DS";
$lang['couldnotretrievethreaddatasplit'] = "cOUld No+ R3+r1EV3 tHR3@d DA+A FROm SOUrc3 THrEAD";
$lang['couldnotretrievepostdatamerge'] = "cOULD n0+ R3+RI3VE p0\$+ D4t@ PHR0M onE 0r MOr3 +hrE@d5";
$lang['couldnotretrievepostdatasplit'] = "c0ulD n0t r3+R13V3 P0\$+ D@t@ FR0m \$0URC3 ThREAd";
$lang['failedtocreatenewthreadformerge'] = "f4IL3D +o Cre4+3 NEw THr34D PhOr MeRGe";
$lang['failedtocreatenewthreadforsplit'] = "f41leD +0 cr3@T3 New ThRE4D FOR 5pL1+";

// Thread subscriptions

$lang['threadsubscriptions'] = "thrE@D sU8scR1pTi0N\$";
$lang['couldnotupdateinterestonthread'] = "cOuLD N0T UpdATe InTEr3sT 0N thReAD '%s'";
$lang['threadinterestsupdatedsuccessfully'] = "thre4D In+Ere\$ts UpD@+3D sUcCES5PhulLy";
$lang['nothreadsubscriptions'] = "j00 @Re NOT SUBScrI8ed T0 @nY +hRE4d\$.";
$lang['nothreadsignored'] = "j00 @rE nOT 19NORiNG @nY +HrEAD\$.";
$lang['nothreadsonhighinterest'] = "j00 h@V3 N0 H19H iN+ErE\$t +HREAds.";
$lang['resetselected'] = "reSET S3L3CTeD";
$lang['ignoredthreads'] = "i9noR3D ThRE4d\$";
$lang['highinterestthreads'] = "hi9H In+3R3sT +HREAd\$";
$lang['subscribedthreads'] = "su8\$CriBED +HR3aD\$";
$lang['currentinterest'] = "curRENt 1NT3R3ST";

// Folder subscriptions

$lang['foldersubscriptions'] = "foLd3R su85CR1P+1OnS";
$lang['couldnotupdateinterestonfolder'] = "c0ulD NO+ Upd4+3 In+3RE\$+ 0N FolD3R '%s'";
$lang['folderinterestsupdatedsuccessfully'] = "f0lD3r INteRE\$TS uPD@tED \$uCC3sSFULLY";
$lang['nofoldersubscriptions'] = "j00 4RE N0+ \$UbsCR183D +O 4NY pHOLD3R\$.";
$lang['nofoldersignored'] = "j00 @R3 NOT 19n0r1NG 4Ny FOLDerS.";
$lang['resetselected'] = "rE\$3+ \$3L3C+3D";
$lang['ignoredfolders'] = "iGNOr3d F0LD3R\$";
$lang['subscribedfolders'] = "sub\$cR1B3D ph0lD3R\$";

// Browseable user profiles

$lang['youcanonlyaddthreecolumns'] = "j00 C4N 0Nly 4DD 3 coLUMnS. T0 4DD 4 nEw C0LUMn CLo\$e 4N EXisT1NG 0n3";
$lang['columnalreadyadded'] = "j00 H@ve 4LR3ADy 4DD3D +h1\$ c0lUMN. 1PH J00 w@Nt TO reM0VE i+ Cl1cK 1tS cl0\$3 8u+TOn";

?>