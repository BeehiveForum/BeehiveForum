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

/* $Id$ */

// British English language file

// Language character set and text direction options -------------------

$lang['_isocode'] = "en-gb";
$lang['_textdir'] = "ltr";

// Months --------------------------------------------------------------

$lang['month'][1]  = "j4nU4Ry";
$lang['month'][2]  = "fe8RuArY";
$lang['month'][3]  = "m4rCh";
$lang['month'][4]  = "apR1l";
$lang['month'][5]  = "m@y";
$lang['month'][6]  = "juN3";
$lang['month'][7]  = "jUlY";
$lang['month'][8]  = "aUgu\$+";
$lang['month'][9]  = "sepT3Mb3r";
$lang['month'][10] = "ocTober";
$lang['month'][11] = "nOv3m83r";
$lang['month'][12] = "d3cEm8eR";

$lang['month_short'][1]  = "j@N";
$lang['month_short'][2]  = "f38";
$lang['month_short'][3]  = "m@r";
$lang['month_short'][4]  = "aPR";
$lang['month_short'][5]  = "m4y";
$lang['month_short'][6]  = "jUN";
$lang['month_short'][7]  = "jUL";
$lang['month_short'][8]  = "aUg";
$lang['month_short'][9]  = "sEp";
$lang['month_short'][10] = "ocT";
$lang['month_short'][11] = "n0V";
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

$lang['date_periods']['year']   = "%s yEAr";
$lang['date_periods']['month']  = "%s mOn+H";
$lang['date_periods']['week']   = "%s we3K";
$lang['date_periods']['day']    = "%s d4Y";
$lang['date_periods']['hour']   = "%s HoUr";
$lang['date_periods']['minute'] = "%s M1NuTE";
$lang['date_periods']['second'] = "%s s3conD";

// As above but plurals (2 years vs. 1 year, etc.)

$lang['date_periods_plural']['year']   = "%s y34rS";
$lang['date_periods_plural']['month']  = "%s mONTH5";
$lang['date_periods_plural']['week']   = "%s WEEks";
$lang['date_periods_plural']['day']    = "%s d4y\$";
$lang['date_periods_plural']['hour']   = "%s H0URs";
$lang['date_periods_plural']['minute'] = "%s M1NUteS";
$lang['date_periods_plural']['second'] = "%s 53c0Nd5";

// Short hand periods (example: 1y, 2m, 3w, 4d, 5hr, 6min, 7sec)

$lang['date_periods_short']['year']   = "%sY";    // 1y
$lang['date_periods_short']['month']  = "%sm";    // 2m
$lang['date_periods_short']['week']   = "%sW";    // 3w
$lang['date_periods_short']['day']    = "%sD";    // 4d
$lang['date_periods_short']['hour']   = "%shR";   // 5hr
$lang['date_periods_short']['minute'] = "%sM1N";  // 6min
$lang['date_periods_short']['second'] = "%s\$3C";  // 7sec

// Common words --------------------------------------------------------

$lang['percent'] = "p3RC3N+";
$lang['average'] = "aV3R49E";
$lang['approve'] = "aPPRoV3";
$lang['banned'] = "b4NNed";
$lang['locked'] = "l0CK3D";
$lang['add'] = "aDd";
$lang['advanced'] = "aDv4nc3d";
$lang['active'] = "aC+1V3";
$lang['style'] = "sTYL3";
$lang['go'] = "g0";
$lang['folder'] = "foLdER";
$lang['ignoredfolder'] = "i9N0R3D ph0ld3R";
$lang['subscribedfolder'] = "su85cRIB3d Ph0lD3R";
$lang['folders'] = "f0lDeR\$";
$lang['thread'] = "thre@d";
$lang['threads'] = "tHR34DS";
$lang['threadlist'] = "tHRe@d LI5+";
$lang['message'] = "mEs\$@93";
$lang['from'] = "fR0M";
$lang['to'] = "to";
$lang['all_caps'] = "all";
$lang['of'] = "of";
$lang['reply'] = "rEPlY";
$lang['forward'] = "fOrw4RD";
$lang['replyall'] = "rePly t0 4lL";
$lang['quickreply'] = "quICK R3Ply";
$lang['quickreplyall'] = "quICK rEPLY +O 4LL";
$lang['pm_reply'] = "rEPly 4\$ Pm";
$lang['delete'] = "dEl3+3";
$lang['deleted'] = "d3le+ED";
$lang['edit'] = "ed1+";
$lang['export'] = "exp0R+";
$lang['privileges'] = "pRIv1le93s";
$lang['ignore'] = "i9N0r3";
$lang['normal'] = "n0rm4L";
$lang['interested'] = "in+ER3S+ed";
$lang['subscribe'] = "sU8\$cRi83";
$lang['apply'] = "appLy";
$lang['enable'] = "en4ble";
$lang['download'] = "d0WNLO4d";
$lang['save'] = "s4V3";
$lang['update'] = "upD4+E";
$lang['cancel'] = "c4nc3L";
$lang['continue'] = "c0nt1nUE";
$lang['attachment'] = "aT+4cHMENT";
$lang['attachments'] = "a++4cHMEN+S";
$lang['imageattachments'] = "iMAGe @+T4ChMENTs";
$lang['filename'] = "fiLEN4M3";
$lang['dimensions'] = "d1men\$10n\$";
$lang['downloadedxtimes'] = "d0WNl04D3d: %d TIMes";
$lang['downloadedonetime'] = "d0wNL04DEd: 1 T1ME";
$lang['size'] = "s1Z3";
$lang['viewmessage'] = "vIEW M3S549E";
$lang['deletethumbnails'] = "d3lEtE ThumBn41lS";
$lang['logon'] = "l0GOn";
$lang['more'] = "morE";
$lang['recentvisitors'] = "r3cEnT VI51t0Rs";
$lang['username'] = "u53Rn@me";
$lang['clear'] = "cLE4R";
$lang['reset'] = "r3S3T";
$lang['action'] = "ac+i0n";
$lang['unknown'] = "unkNoWn";
$lang['none'] = "non3";
$lang['preview'] = "prEvieW";
$lang['post'] = "poST";
$lang['posts'] = "poS+\$";
$lang['change'] = "ch@N9E";
$lang['yes'] = "ye\$";
$lang['no'] = "n0";
$lang['signature'] = "sI9N4TUR3";
$lang['signaturepreview'] = "sI9N4TURE Pr3ViEw";
$lang['signatureupdated'] = "sIgn4TUR3 UPD4T3d";
$lang['signatureupdatedforallforums'] = "s19N4TUR3 UPD4+3d F0R @lL F0RUMs";
$lang['back'] = "b@Ck";
$lang['subject'] = "suBJ3CT";
$lang['close'] = "cloS3";
$lang['name'] = "n@ME";
$lang['description'] = "dE\$CRiPT10n";
$lang['date'] = "d4+3";
$lang['view'] = "vI3W";
$lang['enterpasswd'] = "eN+3r P45\$wORD";
$lang['passwd'] = "p@55WOrd";
$lang['ignored'] = "igN0REd";
$lang['guest'] = "gu35+";
$lang['next'] = "n3x+";
$lang['prev'] = "pr3V1ouS";
$lang['others'] = "otHER5";
$lang['nickname'] = "nickN4me";
$lang['emailaddress'] = "eM41L 4DDResS";
$lang['confirm'] = "c0nf1RM";
$lang['email'] = "em4IL";
$lang['poll'] = "poll";
$lang['friend'] = "fR1End";
$lang['success'] = "sUcCe\$5";
$lang['error'] = "erRoR";
$lang['warning'] = "w@RNIn9";
$lang['guesterror'] = "sOrRY, J00 n3ed t0 83 l0gGED 1N t0 us3 Th15 f34+uRe.";
$lang['loginnow'] = "l091N Now";
$lang['unread'] = "uNR34d";
$lang['all'] = "alL";
$lang['allcaps'] = "all";
$lang['permissions'] = "p3rMIssI0NS";
$lang['type'] = "typ3";
$lang['print'] = "pr1N+";
$lang['sticky'] = "stICKy";
$lang['polls'] = "p0lLs";
$lang['user'] = "us3R";
$lang['enabled'] = "en48l3D";
$lang['disabled'] = "d1s4bL3d";
$lang['options'] = "oP+1ONs";
$lang['emoticons'] = "em0TIC0n\$";
$lang['webtag'] = "w38+4G";
$lang['makedefault'] = "m@K3 DEPh4UL+";
$lang['unsetdefault'] = "uNSet d3pH4uLT";
$lang['rename'] = "r3N4Me";
$lang['pages'] = "pAG3s";
$lang['used'] = "u\$3D";
$lang['days'] = "d@y\$";
$lang['usage'] = "u5493";
$lang['show'] = "sH0W";
$lang['hint'] = "hIn+";
$lang['new'] = "nEw";
$lang['referer'] = "ref3Rer";
$lang['thefollowingerrorswereencountered'] = "t3h fOll0w1N9 3RRor5 W3R3 ENcOunT3rEd:";

// Admin interface (admin*.php) ----------------------------------------

$lang['admintools'] = "aDM1N +OOLS";
$lang['forummanagement'] = "fORum M4N@93MeN+";
$lang['accessdeniedexp'] = "j00 D0 N0T H4VE P3rm1\$\$1on T0 US3 TH1S \$EC+Ion.";
$lang['managefolder'] = "man4G3 f0Ld3R";
$lang['managefolders'] = "man4G3 F0ldEr5";
$lang['manageforums'] = "maNaG3 PHorUm5";
$lang['manageforumpermissions'] = "m4n4G3 PHoruM P3RM1\$51On5";
$lang['foldername'] = "foldeR N4M3";
$lang['move'] = "m0VE";
$lang['closed'] = "cl0S3d";
$lang['open'] = "oPEN";
$lang['restricted'] = "rEsTR1cTED";
$lang['forumiscurrentlyclosed'] = "%s I\$ CUrrEnTly cLo5ED";
$lang['youdonothaveaccesstoforum'] = "j00 dO N0+ H@ve 4cc3Ss +0 %s. %s";
$lang['toapplyforaccessplease'] = "t0 @pplY fOr 4CceS\$ pL3@S3 CONT4C+ +3h %s.";
$lang['forumowner'] = "f0Rum OWnER";
$lang['adminforumclosedtip'] = "if j00 w4N+ +0 cH4n93 Som3 sEtT1N9S ON y0ur PH0RuM cL1cK +H3 @Dm1n L1NK 1n THE N4V194t10N b4r 48oV3.";
$lang['newfolder'] = "n3W FOldeR";
$lang['nofoldersfound'] = "n0 EX1sT1N9 FoldERS f0uNd. T0 4dD 4 PhoLd3r ClICk Th3 '@Dd NEW' 8u++0N 83L0w.";
$lang['forumadmin'] = "fOrUm 4dM1n";
$lang['adminexp_1'] = "u\$3 THE M3nU 0N teh L3PHT To M4n4G3 THIN9S In Y0ur PH0ruM.";
$lang['adminexp_2'] = "<b>u\$3rS</b> 4llOW\$ J00 +0 SeT iNd1vIdU4L U\$3r P3rMIS\$10n\$, incLuDIn9 4PP01n+iNG modER4T0rS 4Nd 94gG1n9 PE0PLE.";
$lang['adminexp_3'] = "<b>u53R 9rOuPS</b> @Ll0W5 J00 t0 cRE4+E USER 9rOUP\$ tO 4\$5Ign PeRmiS\$10N\$ +o A\$ m4nY or 4s PH3w U53r5 qUIcKLY 4ND e4s1Ly.";
$lang['adminexp_4'] = "<b>b4n CONTR0LS</b> 4LlOW\$ +EH b@NN1N9 @ND Un-84NN1N9 0f 1P 4DDR3S\$3s, H++p REF3rERs, UseRn@m3\$, 3M@Il 4ddRESs3S 4nD NicKn4MES.";
$lang['adminexp_5'] = "<b>f0ldeR\$</b> 4LlOw\$ +H3 cR3a+10N, m0DiphIc4t10N 4ND D3l3t10N Oph PH0Ld3r5.";
$lang['adminexp_6'] = "<b>rs\$ fe3Ds</b> @llOW\$ J00 +O m4naGE R\$S ph33Ds FOR pr0p4g4+1ON 1NT0 Y0UR PhoRUM.";
$lang['adminexp_7'] = "<b>prOphIL3S</b> l3+\$ J00 Cu5+omIS3 TH3 1+3mS +h4+ 4ppe@R 1N Teh uSER pROf1LES.";
$lang['adminexp_8'] = "<b>f0Rum \$e++1NG\$</b> @ll0w\$ J00 t0 Cu5+omISE y0Ur PhOruM's N@ME, 4Pp34R4ncE @ND M@ny 0+H3R +HIn9S.";
$lang['adminexp_9'] = "<b>st4R+ P493</b> L3+s j00 cU5+OMIs3 Y0Ur F0RUM'5 \$+4Rt p4g3.";
$lang['adminexp_10'] = "<b>f0Rum S+yLE</b> 4LLoW\$ J00 +O G3N3R@+e R@NDom \$tYL3s PH0R Y0UR Ph0Rum M3m83r5 t0 uSe.";
$lang['adminexp_11'] = "<b>w0RD phIL+er</b> 4LloWS J00 t0 Fil+3R WOrdS j00 d0N'T w4nT +0 bE U\$3d 0n Y0UR PH0RUM.";
$lang['adminexp_12'] = "<b>p05+in9 5+4t5</b> 93NeR@T3S @ REPOrt L1S+1N9 +H3 t0P 10 P0\$T3Rs 1N @ d3pHiNED p3Ri0D.";
$lang['adminexp_13'] = "<b>f0RUm l1nKS</b> L3+s j00 m4N493 Th3 L1NK5 DrOPD0Wn 1N thE n4VigAt10N B@R.";
$lang['adminexp_14'] = "<b>v1Ew lOg</b> L1S+5 REC3NT ac+10NS 8y +HE FORUM M0d3r4+OR\$.";
$lang['adminexp_15'] = "<b>m4n49e FOruMS</b> LET\$ J00 cRE@Te 4nd DeL3+3 @ND CL0SE oR R3Op3N Ph0RUM\$.";
$lang['adminexp_16'] = "<b>gL084L PHORum \$3T+inGS</b> 4lLOws J00 T0 m0dIpHy SE++1N95 whICH @PHPh3CT 4LL PhoRUMS.";
$lang['adminexp_17'] = "<b>po\$T @PPr0V4L QUEUE</b> aLL0WS j00 T0 VIEW 4ny PoS+\$ 4w4I+inG 4pPR0V4L BY @ MOD3r@Tor.";
$lang['adminexp_18'] = "<b>v151T0r l0G</b> @Ll0W\$ J00 +O ViEw @n ExTenDEd L1S+ OPH vIS1T0R\$ 1NCLUdIn9 +hE1R HTtp REPheR3r\$.";
$lang['createforumstyle'] = "cRE4+3 4 pHOruM \$+YL3";
$lang['newstylesuccessfullycreated'] = "neW 5TyLe \$uCCE5\$fuLLy cRe4+3D.";
$lang['stylealreadyexists'] = "a \$tyL3 WI+H +H4T pHILEN@ME 4lRE4Dy eX1S+\$.";
$lang['stylenofilename'] = "j00 D1D No+ ENTEr @ pHileN4m3 T0 S@v3 Th3 S+ylE w1TH.";
$lang['stylenodatasubmitted'] = "c0ULD NO+ R34D ForuM S+yLe D4+4.";
$lang['stylecontrols'] = "c0N+rOLs";
$lang['stylecolourexp'] = "cl1cK 0N a c0lOUR t0 M@ke 4 N3w StyLe \$H3Et 8@S3d 0N th@t COl0uR. cUrren+ b@S3 c0l0Ur 1\$ FIr\$+ 1n l1\$+.";
$lang['standardstyle'] = "s+@Nd4Rd 5tYLE";
$lang['rotelementstyle'] = "r0+4t3d eL3mEnt \$tYLE";
$lang['randstyle'] = "r4ND0M s+YL3";
$lang['thiscolour'] = "tH1S Col0Ur";
$lang['enterhexcolour'] = "oR 3N+eR 4 h3x COLOUr To 84\$E 4 N3W s+YLE \$he3+ ON";
$lang['savestyle'] = "s4V3 +h1\$ \$tYl3";
$lang['styledesc'] = "stYl3 de\$cr1pT10N";
$lang['stylefilenamemayonlycontain'] = "stYL3 PHILEN@m3 M4Y 0NLY CoNt@1n l0werc4SE l3tteR\$ (4-Z), nUMBeR\$ (0-9) @ND UNDer\$CoRe.";
$lang['stylepreview'] = "s+Yle PREvieW";
$lang['welcome'] = "wElc0me";
$lang['messagepreview'] = "m3Ss4G3 Pr3VieW";
$lang['users'] = "u53RS";
$lang['usergroups'] = "u53R 9rouPs";
$lang['mustentergroupname'] = "j00 MU5+ 3NTER @ 9rOup N4ME";
$lang['profiles'] = "propHIL35";
$lang['manageforums'] = "maN4G3 FoRUM\$";
$lang['forumsettings'] = "foRuM 5e+T1NG\$";
$lang['globalforumsettings'] = "gl0B@L foRUM s3TtIn95";
$lang['settingsaffectallforumswarning'] = "<b>n0t3:</b> TH353 S3++INg\$ @PHPHEC+ 4Ll PHORUMs. WHere +HE s3tt1n9 I\$ dUPL1c@+ED oN +he 1NdIV1dU4L ForUm's \$e++1NG5 P@9e +h4t wIll T4kE PR3C3DeNC3 0V3R +H3 \$3++1N9\$ J00 CH@nGE H3RE.";
$lang['startpage'] = "s+4r+ P4G3";
$lang['startpageerror'] = "yOUR s+4R+ P4G3 COUlD no+ 83 S4VEd LOC4llY to +3h SErV3R 83C4U\$3 pErm1SS1ON W@S d3N1ED.</p><p>to Ch@Ng3 y0Ur 5T4r+ p4G3 pL3@S3 cLICK +H3 d0WNL04d 8utt0N 83L0W WhiCh W1lL pRoMPT J00 T0 SAV3 +H3 f1L3 T0 YOUR H@rd dRIVE. j00 C@n Th3n UPlO@d +hiS FIl3 To YOUr S3RVER 1N+O +h3 f0LL0W1NG pH0LDER, iPh NEC3S54Ry CRE4T1Ng THE f0ld3r \$TRUCTuRe 1N +h3 PR0CEs\$.</p><p><b>%s</b></p><p>pl34\$e NOt3 Th@T som3 8Row\$3rS M4Y Ch4nG3 +3H n4ME oF T3H pHILE uPOn dowNl04d. Wh3n uPl04D1n9 The fIl3 pL34\$3 m@k3 5UR3 TH@+ It is n4M3d S+4r+_M4In.PhP 0+hERW1Se yOur 5+4R+ P4gE wiLL 4Pp3@r UNCH@N9eD.";
$lang['uploadcssfile'] = "uPlo4d CSs S+Yle 5h3Et";
$lang['uploadcssfilefailed'] = "y0uR CS\$ S+yLE she3+ C0uLd no+ Be UPL0@d3d tO +H3 \$3RVer bec4uS3 PERMIsSi0n W4S DENIED.</p><p>tO CH4NG3 Y0uR S+4Rt P493 CSs 5tyl3 Sheet PL3AS3 EN\$uR3 +3H F0ll0wIN9 FOLDerS 3x1St 4ND 4R3 WR1T@8L3: </p><p><b>%s</b></p>";
$lang['invalidfiletypeerror'] = "iNv@L1D PHILe tYP3, J00 C4N ONly uPLO4D c5S s+yLE \$h3ET FILES";
$lang['failedtoopenmasterstylesheet'] = "y0uR f0rUM 5tYL3 C0ULD nO+ 83 \$4ved 83c4US3 TEH m4St3R S+yL3 sH3eT COulD N0+ 8e l04D3d. +O \$4Ve YOur 5+yL3 +HE m@S+3r s+YLE Sh33t (m4k3_S+yl3.cs\$) muST BE l0C@Ted IN +h3 5+yl3S DIRectORY opH YOur 83EhiV3 F0RUm INs+4ll4T1On.";
$lang['makestyleerror'] = "yOUr F0rUm S+YL3 COULd nOT 83 S4VED loc@LLy +O +H3 S3RVEr 8eC4USE perM1SSI0N W4S d3N13d.</p><p>tO S4v3 y0uR F0RUM s+Yl3 pLe4\$3 cL1ck tH3 dOwnL04D bu+T0N 83l0w wH1cH W1LL ProMP+ J00 +O S4v3 The PHil3 t0 y0Ur H@RD dRive. J00 C@N th3n uPlO4d +Hi\$ Ph1LE t0 YOUR S3RVER InT0 TEh PH0llOW1N9 FolDEr, 1F n3CEsS@Ry CR34+1N9 thE Ph0LD3R 5+ruCTURE 1n T3H PR0C3Ss.</p><p><b>%s</b></p><p>plE@s3 n0te +h4t Som3 8ROw\$ER\$ M@y Ch@Nge +h3 N4M3 OPh +H3 PhIL3 uPOn D0WnLo@d. WH3N UpLO4d1NG +3H ph1lE PL34\$3 M@Ke suR3 +h4+ 1T i\$ N4M3D s+Yl3.cSs OTheRW1s3 +H3 pH0RUm 5+YLE W1LL 83 un4V41l@8L3.";
$lang['forumstyle'] = "f0rUM \$TYL3";
$lang['wordfilter'] = "w0Rd PH1LTER";
$lang['forumlinks'] = "fOrUM LinkS";
$lang['viewlog'] = "vIEW lo9";
$lang['noprofilesectionspecified'] = "n0 pR0pH1l3 SEC+i0N \$p3C1PHied.";
$lang['itemname'] = "i+eM N4M3";
$lang['moveto'] = "mOV3 TO";
$lang['manageprofilesections'] = "m4n@93 PROF1Le s3cT1oNs";
$lang['sectionname'] = "seCTI0N n4M3";
$lang['items'] = "i+EMs";
$lang['mustspecifyaprofilesectionid'] = "mu5T 5P3c1PHY @ PrOf1Le 53cTI0n ID";
$lang['mustsepecifyaprofilesectionname'] = "mu\$+ 5PeC1fY 4 PR0PHIl3 53cTI0N n@Me";
$lang['noprofilesectionsfound'] = "n0 eX1\$+1N9 PRoPh1LE 53CTi0Ns pHouNd. To 4dd 4 PR0PH1le 53ct10N ClicK +He '4dD nEW' BUTT0N 83L0W.";
$lang['addnewprofilesection'] = "aDD n3W pr0PHilE 5ECt1ON";
$lang['successfullyaddedprofilesection'] = "sUcceS5FuLlY 4dDED Pr0fILE SEC+10N";
$lang['successfullyeditedprofilesection'] = "sUcce\$sPHUllY ED1+ed PROPhiL3 S3CT1oN";
$lang['addnewprofilesection'] = "adD nEw PRoF1l3 sEC+I0n";
$lang['mustsepecifyaprofilesectionname'] = "mU\$T \$Pec1Fy 4 pR0PHile S3ct1ON N@me";
$lang['successfullyremovedselectedprofilesections'] = "suCCe55PHuLly R3mOvEd 53l3cT3d pR0pH1lE SEC+10Ns";
$lang['failedtoremoveprofilesections'] = "f41L3D +O reMOV3 PR0PHiLE S3cTI0N5";
$lang['viewitems'] = "v1eW 1+eM\$";
$lang['successfullyaddednewprofileitem'] = "sUcc3\$\$fuLLy 4Dded NEW pROphiLe it3M";
$lang['successfullyeditedprofileitem'] = "sUcc3S\$fULLY eD1+3D PR0FIL3 IT3M";
$lang['successfullyremovedselectedprofileitems'] = "suCc3SSphULLy r3m0vEd SEL3CT3d PRophILE 1T3M5";
$lang['failedtoremoveprofileitems'] = "fAIled tO R3m0v3 PROPH1LE 1+3mS";
$lang['noexistingprofileitemsfound'] = "tH3Re @RE NO 3xiStiN9 pR0PHILE 1+3m\$ In TH15 Sec+10N. +O 4DD @N it3M CLICK T3H '4DD NeW' butTon b3LoW.";
$lang['edititem'] = "eD1+ iTeM";
$lang['invalidprofilesectionid'] = "iNv@LID pr0f1L3 \$3ctI0n ID Or \$3ct10N NOT pH0uND";
$lang['invalidprofileitemid'] = "iNv@LID PrOfIle 1+3M 1D OR 1T3M NoT PHound";
$lang['addnewitem'] = "adD N3W i+3m";
$lang['youmustenteraprofileitemname'] = "j00 mu5+ 3N+3R 4 Pr0fiL3 1tEm N4M3";
$lang['invalidprofileitemtype'] = "inV4l1d proPHIle 1+3M tyP3 53lecTED";
$lang['youmustenteroptionsforselectedprofileitemtype'] = "j00 mU\$t ENTER s0m3 OP+10N\$ PhoR \$3lEct3d pr0Ph1l3 i+Em +Yp3";
$lang['youmustentermorethanoneoptionforitem'] = "j00 MUst En+eR MoRe +Han 0nE 0Pt10N Ph0R sELEcT3D PROfIL3 i+3m +Yp3";
$lang['profileitemhyperlinkssupportshttpurlsonly'] = "prOf1le iT3M HYP3rL1NKs \$upP0rT h++P URLs 0Nly";
$lang['profileitemhyperlinkformatinvalid'] = "proPHIL3 1+3m Hyp3rLiNK fORM4+ INValID";
$lang['youmustincludeprofileentryinhyperlinks'] = "j00 Mu5T 1NCLUDE <i>%s</i> 1N +3H uRl 0PH cL1cK@8L3 hYp3RL1NKS";
$lang['failedtocreatenewprofileitem'] = "f4iL3D TO cR3@+E NEW pRoPH1LE 1+3M";
$lang['failedtoupdateprofileitem'] = "f4iL3D +o uPD4TE prOPHIle 1+Em";
$lang['startpageupdated'] = "st4Rt p4GE upD@T3D. %s";
$lang['cssfileuploaded'] = "c5\$ 5+YlE ShEet UPL04D3d. %s";
$lang['viewupdatedstartpage'] = "vIEw UPD4T3d s+4R+ p4G3";
$lang['editstartpage'] = "eD1t \$t4RT P493";
$lang['nouserspecified'] = "n0 uS3R sp3ciF1ed.";
$lang['manageuser'] = "m@n493 U53R";
$lang['manageusers'] = "m4n4g3 U53r5";
$lang['userstatusforforum'] = "u\$3R ST4+U\$ F0R %s";
$lang['userdetails'] = "uS3R de+@1l\$";
$lang['edituserdetails'] = "ed1T UsEr D3T41lS";
$lang['warning_caps'] = "w4rN1n9";
$lang['userdeleteallpostswarning'] = "aR3 j00 Sur3 J00 w4nT +0 DELe+3 4lL Of +he 5eL3CtED U\$ER'\$ p05+\$? once TEH PO\$T5 4re deLE+ED +HEy c@NNOt be re+R13vEd @nd wIll 83 L0S+ phOr3vER.";
$lang['folderaccess'] = "f0LdER @cCeS\$";
$lang['possiblealiases'] = "p05S18L3 @Li4S3S";
$lang['ipaddressmatches'] = "iP 4ddRE\$5 M4TCh3\$";
$lang['emailaddressmatches'] = "em@1L 4DdRE55 M4+cHE5";
$lang['passwdmatches'] = "p4sSw0rd M@TCH3S";
$lang['httpreferermatches'] = "h+tP r3Fer3R Ma+che\$";
$lang['userhistory'] = "u53r H1\$t0rY";
$lang['nohistory'] = "n0 HIs+0rY REC0RDS s@VEd";
$lang['userhistorychanges'] = "ch4n93s";
$lang['clearuserhistory'] = "cL34R U\$3R hi5T0rY";
$lang['changedlogonfromto'] = "ch4n93d LOgoN phR0M %s T0 %s";
$lang['changednicknamefromto'] = "ch4NG3d N1CKN4ME Phr0M %s +O %s";
$lang['changedemailfromto'] = "cH4N93D 3M@1L Fr0M %s tO %s";
$lang['successfullycleareduserhistory'] = "sUcc3SSPhuLLY cle4Red U\$ER h1StOrY";
$lang['failedtoclearuserhistory'] = "f41l3D t0 cL34R uS3r H1stORY";
$lang['successfullychangedpassword'] = "sUcc3s\$fULLY ch4nG3d P4ssWOrd";
$lang['failedtochangepasswd'] = "fa1L3D +0 CH4NG3 p@s\$Word";
$lang['approveuser'] = "aPpr0VE User";
$lang['viewuserhistory'] = "v13W usEr hi5+0ry";
$lang['viewuseraliases'] = "vIEw U\$eR 4Li4s3s";
$lang['searchreturnednoresults'] = "s34rCh r3tURn3d nO RESul+S";
$lang['deleteposts'] = "dEL3Te p0\$+S";
$lang['deleteuser'] = "del3T3 uS3R";
$lang['alsodeleteusercontent'] = "als0 d3L3t3 @lL 0PH +h3 cON+3NT cR34TEd BY THI5 uSer";
$lang['userdeletewarning'] = "aRE J00 sUR3 J00 w4N+ tO DeLE+E +3H 53LEcTED uSeR @CC0uNT? 0NC3 TH3 @CCOun+ H@s beeN deleT3d 1t CANn0+ 83 REtrI3vEd 4Nd w1Ll 83 L0st pHoR3vEr.";
$lang['usersuccessfullydeleted'] = "uSer \$uCce\$\$fuLLY deLE+ED";
$lang['failedtodeleteuser'] = "f41l3d TO d3leT3 U5eR";
$lang['forgottenpassworddesc'] = "ipH TH1S U\$3R h@S phOrGo++3n +heIR P455WOrd J00 c4N resET 1T foR +H3m h3re.";
$lang['failedtoupdateuserstatus'] = "f@Il3D +O upd@TE USer S+4TU\$";
$lang['failedtoupdateglobaluserpermissions'] = "fail3D +O UPD@t3 9Lob@l U\$eR p3RM1S\$10n\$";
$lang['failedtoupdatefolderaccesssettings'] = "faILED +0 UPd@t3 F0ldeR 4cceSs s3++in9\$";
$lang['manageusersexp'] = "tHIs L1\$t 5HOW\$ 4 SeLecT1ON OF US3RS wHO h4V3 l0Gg3d 0N +0 YouR ForuM, \$oR+Ed by %s. +o 4lTEr 4 U5ER's P3rMIssI0N\$ clICk THEIR n4M3.";
$lang['userfilter'] = "uS3r f1L+3R";
$lang['withselected'] = "wi+h seL3c+3d";
$lang['onlineusers'] = "oNL1Ne US3Rs";
$lang['offlineusers'] = "oPhfL1N3 U\$eR\$";
$lang['usersawaitingapproval'] = "u53rS 4W41+IN9 4PPr0V4L";
$lang['bannedusers'] = "b4nN3D uS3r\$";
$lang['lastlogon'] = "l4\$t lOgoN";
$lang['sessionreferer'] = "sEsS1On R3fEr3R";
$lang['signupreferer'] = "s1gN-Up R3FEr3R:";
$lang['nouseraccountsmatchingfilter'] = "no uS3r @CcOun+\$ M4tcHIn9 pHIL+ER";
$lang['searchforusernotinlist'] = "s34rch FOR 4 uS3r N0+ IN l15T";
$lang['adminaccesslog'] = "adM1N 4cces\$ l09";
$lang['adminlogexp'] = "thIS LIS+ 5hoW\$ +3H L@s+ @c+I0n\$ \$@NC+IoN3d bY u53rs W1+H @dMiN pRiVile9ES.";
$lang['datetime'] = "d4te/Tim3";
$lang['unknownuser'] = "unKnOWn u53R";
$lang['unknownuseraccount'] = "uNKn0wn U\$eR 4cc0UN+";
$lang['unknownfolder'] = "unKn0Wn PHOLD3R";
$lang['ip'] = "iP";
$lang['lastipaddress'] = "l@5+ iP 4ddR3Ss";
$lang['logged'] = "log93D";
$lang['notlogged'] = "n0+ L0GG3d";
$lang['addwordfilter'] = "adD woRD F1L+eR";
$lang['addnewwordfilter'] = "add n3W w0Rd PHilt3r";
$lang['wordfilterupdated'] = "wORD pHiLTER UpdATED";
$lang['wordfilterisfull'] = "j00 C4nNOt 4dd 4nY More WOrd FIL+ER\$. r3M0V3 S0M3 UNU5ED 0NeS 0R Ed1+ +H3 3XI\$+IN9 0NE\$ f1R\$+.";
$lang['filtername'] = "filtER n4m3";
$lang['filtertype'] = "f1L+ER +yp3";
$lang['filterenabled'] = "f1lTER 3N4bLed";
$lang['editwordfilter'] = "edi+ wORD F1LTER";
$lang['nowordfilterentriesfound'] = "n0 EX1\$TiN9 WOrd PHILTER 3NTR1ES phOUND. +O 4dd 4 PHIl+eR cL1cK TH3 '@DD N3W' BuTt0N 83l0W.";
$lang['mustspecifyfiltername'] = "j00 mu\$T \$P3CIPhy @ F1LTER n4m3";
$lang['mustspecifymatchedtext'] = "j00 muS+ \$P3cIPHy M4+cH3D +3X+";
$lang['mustspecifyfilteroption'] = "j00 MU\$T 5P3c1pHy 4 fiL+ER 0P+10n";
$lang['mustspecifyfilterid'] = "j00 MuSt speciPHY @ pHIL+er id";
$lang['invalidfilterid'] = "iNv@l1D f1l+3r 1d";
$lang['failedtoupdatewordfilter'] = "f4IleD T0 Upd4Te WORD F1L+3R. CHECK +H4T +3h F1LTER S+1Ll eXi5+\$.";
$lang['allow'] = "aLLoW";
$lang['block'] = "blOcK";
$lang['normalthreadsonly'] = "n0rM4L +hreAdS 0NlY";
$lang['pollthreadsonly'] = "p0Ll +HR3@D5 0nLY";
$lang['both'] = "bO+h thRe4d +YP3S";
$lang['existingpermissions'] = "ex1St1n9 pERMiS\$10N\$";
$lang['nousershavebeengrantedpermission'] = "nO eX1s+IN9 UseR\$ P3RmISsI0n\$ PhOuND. To GR@N+ peRMI\$s10n +0 uS3r5 \$E4rcH F0R TH3M 83l0W.";
$lang['successfullyaddedpermissionsforselectedusers'] = "sUCcEs\$fUlly 4dDED PeRmI5S1On\$ FOr S3LEC+Ed u\$3rS";
$lang['successfullyremovedpermissionsfromselectedusers'] = "suCc3S\$FULLy r3MoVed p3RMi5SiOnS pHroM \$eL3ct3D U\$3rS";
$lang['failedtoaddpermissionsforuser'] = "f4Iled tO 4dd PeRmIs\$10NS F0r us3R '%s'";
$lang['failedtoremovepermissionsfromuser'] = "f@1Led t0 REm0Ve pErmIsS1ON\$ FRom u5eR '%s'";
$lang['searchforuser'] = "s34RcH fOR U\$Er";
$lang['browsernegotiation'] = "brOW\$eR N3G0+1@+eD";
$lang['textfield'] = "teXt FielD";
$lang['multilinetextfield'] = "muL+1-L1NE Tex+ F1ELD";
$lang['radiobuttons'] = "raD10 bu+Ton\$";
$lang['dropdownlist'] = "dR0p dOWn lIs+";
$lang['clickablehyperlink'] = "cl1cK48l3 Hyp3rlINk";
$lang['threadcount'] = "thR34d cOun+";
$lang['clicktoeditfolder'] = "cL1Ck TO EDi+ pHoLdER";
$lang['fieldtypeexample1'] = "to cR34t3 r@d1O 8UT+ON\$ OR @ dR0P d0wN LIs+ J00 NE3d +0 eNT3R 34ch INdIVidu4l V4luE 0N @ s3P4R4t3 L1Ne 1N THE Op+iON5 PH1ELD.";
$lang['fieldtypeexample2'] = "t0 cr34+3 cL1cK@bL3 l1NkS 3NTER +h3 uRL in THE Op+10N\$ FieLd 4Nd US3 <i>%1\$s</i> wHeR3 THE 3Ntry PHR0M TH3 U53R'5 PR0F1le sH0ULD @Ppe4r. EXamPLe5: <p>mysp4C3: <i>h+TP://wWW.My\$p4c3.COm/%1\$\$</i><br />xBOx LiVE: <i>hTtp://PRoF1l3.my94M3rC4Rd.N3T/%1\$S</i></p>";
$lang['editedwordfilter'] = "ediTED W0RD f1l+3r";
$lang['editedforumsettings'] = "ed1+Ed FoRum SE+t1N95";
$lang['successfullyendedusersessionsforselectedusers'] = "suCCe\$SFULLy End3D seS\$10Ns F0r S3LeC+Ed USErS";
$lang['failedtoendsessionforuser'] = "f@1L3d t0 3ND \$3sS1On FOr US3R %s";
$lang['successfullyapproveduser'] = "suCC35SFuLlY 4PPr0v3d U\$3R";
$lang['successfullyapprovedselectedusers'] = "suCC355phuLLY @ppRov3D S3LecTED USErs";
$lang['matchedtext'] = "m@+CH3D T3x+";
$lang['replacementtext'] = "r3PL@CemeNT +Ex+";
$lang['preg'] = "pReG";
$lang['wholeword'] = "wH0Le WOrd";
$lang['word_filter_help_1'] = "<b>aLL</b> M4tcH3S 4G41nsT THE WhoLe +Ext 5O F1LTErIn9 MOm +O Mum WiLL 4L5O CH4N9e M0MENT +o MuMEnt.";
$lang['word_filter_help_2'] = "<b>wh0LE woRD</b> m4+chE5 494InS+ WHOle W0RdS OnLY 5O pH1lT3R1N9 MoM +O mUM w1LL NO+ Ch@NG3 M0mENT TO MUmeNT.";
$lang['word_filter_help_3'] = "<b>prEg</b> @lL0W\$ J00 to u\$E P3RL R39uL4r 3xpR3S5i0n\$ t0 M@TCH +3X+.";
$lang['nameanddesc'] = "n4me @ND DESCR1PtI0N";
$lang['movethreads'] = "m0Ve +Hr34d\$";
$lang['movethreadstofolder'] = "moVE +hR34D\$ +o PH0ld3R";
$lang['failedtomovethreads'] = "f41lEd +o MOve +HR3@DS t0 sP3c1f13D F0LDER";
$lang['resetuserpermissions'] = "rE\$3+ Us3R peRMiS\$10nS";
$lang['failedtoresetuserpermissions'] = "f4iled +0 rE53T U\$3r PERm1s\$1onS";
$lang['allowfoldertocontain'] = "aLL0W phOLD3r +O COn+41N";
$lang['addnewfolder'] = "adD NEW fOLD3R";
$lang['mustenterfoldername'] = "j00 mUs+ 3NTeR @ pHoldeR n4m3";
$lang['nofolderidspecified'] = "no pHolder 1d sP3c1f1ED";
$lang['invalidfolderid'] = "inv@lID FOLDER 1D. cHECk TH4+ @ F0ldeR WI+H THIs id EX1\$+\$!";
$lang['folderdisplayorderthreadsbyfolderview'] = "f0ldeR OrdeR onlY @PPl13S wh3N User H45 3n@bL3d 's0R+ +hRE4d l1S+ by PHOLDEr\$' 1n F0rUm opT10Ns.";
$lang['successfullyaddednewfolder'] = "suCCe\$\$FULLy 4DD3d NEw PHOLDER";
$lang['successfullyremovedselectedfolders'] = "sUcce55phULLy rEM0VeD seL3cTED FoldeR\$";
$lang['successfullyeditedfolder'] = "sUcc3s\$FulLY ed1+3d PhoLdeR";
$lang['failedtocreatenewfolder'] = "f4Iled +o cr34T3 neW FoldEr";
$lang['failedtodeletefolder'] = "f41L3D +0 DELe+3 PH0lD3r.";
$lang['failedtoupdatefolder'] = "f41L3D +0 upd@t3 PHolder";
$lang['cannotdeletefolderwiththreads'] = "c4nn0T dELET3 ph0lDer5 +H@T \$t1LL cOn+41n THR34dS.";
$lang['forumisnotsettorestrictedmode'] = "fORum Is N0+ Set T0 REstR1cteD mOde. D0 J00 W4NT +o 3n4BL3 1+ nOw?";
$lang['forumisnotsettopasswordprotectedmode'] = "fOruM 1\$ NoT SeT +O P45SWORD PROt3C+eD MODE. DO j00 W@N+ +O 3nABL3 iT n0W?";
$lang['groups'] = "gr0UPs";
$lang['nousergroups'] = "n0 U53R GroUp5 H4VE 83en \$3t Up. +o 4dd 4 9ROUP CL1cK +3H 'Add N3W' 8U+T0N Bel0W.";
$lang['suppliedgidisnotausergroup'] = "sUPplI3d 91D iS No+ 4 uS3R 9ROUP";
$lang['manageusergroups'] = "m@n@9e user GRouPS";
$lang['groupstatus'] = "gR0UP St4+U\$";
$lang['addusergroup'] = "add u\$3R grOUp";
$lang['addemptygroup'] = "aDd 3MPTy GRoUp";
$lang['adduserstogroup'] = "aDd uS3Rs +O GroUp";
$lang['addremoveusers'] = "aDD/R3M0V3 Us3Rs";
$lang['nousersingroup'] = "thERE 4RE N0 Us3rS 1N Th15 GroUp. add U\$3rs +O +hiS GRoup 8y \$3@rcH1N9 FOR +H3m bEl0w.";
$lang['groupaddedaddnewuser'] = "suCc355PHUlly 4dD3d GRoup. @DD u\$3Rs +o +hIs GrOUP By \$3@rChin9 phOr +HEM Bel0w.";
$lang['nousersingroupaddusers'] = "tH3rE @re No uS3r\$ 1N thI\$ GRouP. t0 4dd USerS CL1cK t3H '@dd/rem0V3 u\$eR\$' Bu++oN B3L0W.";
$lang['useringroups'] = "tHiS u\$3R Is 4 M3M83R OpH tH3 PH0LLOWinG 9r0uPS";
$lang['usernotinanygroups'] = "thI\$ U\$3R Is n0T In 4nY U53r GroUPS";
$lang['usergroupwarning'] = "n0t3: THi\$ u\$Er M4Y B3 1NHErit1N9 4ddI+iONAL Perm1S\$1ON\$ PhrOM 4NY uS3r 9ROUp5 liST3d 83L0W.";
$lang['successfullyaddedgroup'] = "sUCC3\$sPHULly @Dd3d 9ROUP";
$lang['successfullyeditedgroup'] = "suCcESSfULLY 3DITED GRouP";
$lang['successfullydeletedselectedgroups'] = "suCc355PhuLlY deLET3d 53LecT3D Gr0UP5";
$lang['failedtodeletegroupname'] = "f@iled +O d3LetE GrOuP %s";
$lang['usercanaccessforumtools'] = "usER C4N 4CCESs FoRum +OOlS 4ND c@N cR3@TE, d3lET3 4ND EDIt PHorUM\$";
$lang['usercanmodallfoldersonallforums'] = "u\$Er c4n M0dEr4tE <b>alL FoLD3R5</b> 0n <b>aLl FORUMs</b>";
$lang['usercanmodlinkssectiononallforums'] = "usEr c@N M0D3R4TE L1NKS \$3cT1ON oN <b>alL Ph0RUm\$</b>";
$lang['emailconfirmationrequired'] = "eM41L c0NpHiRm4+Ion REQU1REd";
$lang['userisbannedfromallforums'] = "u\$eR 1\$ 84NN3D PHrOm <b>all Ph0RUMs</b>";
$lang['cancelemailconfirmation'] = "caNc3L Em41L COnf1rM4+10n 4ND 4LL0W Us3r To 5+4rt P05+1N9";
$lang['resendconfirmationemail'] = "reS3ND C0NF1RM4TI0N EM@1L +O USER";
$lang['failedtosresendemailconfirmation'] = "f41lED +O re53nD eM41l CONPh1Rm@T1ON T0 Us3R.";
$lang['donothing'] = "dO N0+h1N9";
$lang['usercanaccessadmintools'] = "u\$3r H@\$ 4CCES\$ +o PhOruM @Dm1N T0Ols";
$lang['usercanaccessadmintoolsonallforums'] = "useR h45 4CCES\$ +0 4DM1N T0Ol\$ <b>oN 4LL phORUMs</b>";
$lang['usercanmoderateallfolders'] = "u\$3R c4n m0dER4TE 4LL ph0lD3rS";
$lang['usercanmoderatelinkssection'] = "u5ER c@n mODEr4TE l1NK5 sec+Ion";
$lang['userisbanned'] = "uS3R IS baNN3D";
$lang['useriswormed'] = "u\$3R 1\$ WOrmeD";
$lang['userispilloried'] = "u\$3R iS PIlL0r1Ed";
$lang['usercanignoreadmin'] = "u53R C@n iGn0re ADM1nIstR4t0RS";
$lang['groupcanaccessadmintools'] = "gr0UP C4N 4Cc3SS 4dm1n T00L\$";
$lang['groupcanmoderateallfolders'] = "gR0Up c4n M0DER4t3 4lL PH0LDeR\$";
$lang['groupcanmoderatelinkssection'] = "grOUP c4N mOd3R4T3 L1nKS \$3Ct1oN\$";
$lang['groupisbanned'] = "gr0UP 1S 84NNED";
$lang['groupiswormed'] = "gr0Up 15 woRM3d";
$lang['readposts'] = "r34d P05+\$";
$lang['replytothreads'] = "r3pLy +0 +hrE@D5";
$lang['createnewthreads'] = "cR34Te NeW +hR34d5";
$lang['editposts'] = "edIT PoS+\$";
$lang['deleteposts'] = "dEl3Te P0st5";
$lang['postssuccessfullydeleted'] = "p0sTS weRE 5UCCE5\$fULLy dEL3TED";
$lang['failedtodeleteusersposts'] = "f4IL3D +O D3LE+3 U\$ER'\$ Po5+\$";
$lang['uploadattachments'] = "upLO4D 4T+4CHMEN+S";
$lang['moderatefolder'] = "mOd3r@Te foLDer";
$lang['postinhtml'] = "p0\$T IN H+mL";
$lang['postasignature'] = "poSt 4 Si9N4TURE";
$lang['editforumlinks'] = "ed1t f0RUm l1Nk5";
$lang['linksaddedhereappearindropdown'] = "l1NkS 4dD3d H3RE aPPe4R IN a dR0p dOWN iN +H3 Top R1gHt OF +h3 phR@ME \$e+.";
$lang['linksaddedhereappearindropdownaddnew'] = "linKS 4DDED HER3 @PPe4r iN @ dRop d0wN In t3H T0P RI9H+ Oph +HE phR@mE \$3t. To 4dd @ L1Nk ClICK +H3 '@Dd N3w' bUt+oN BELow.";
$lang['failedtoremoveforumlink'] = "f41LEd To REM0ve FOruM L1nK '%s'";
$lang['failedtoaddnewforumlink'] = "f4iL3d T0 aDd n3W F0Rum L1Nk '%s'";
$lang['failedtoupdateforumlink'] = "f41LeD +0 UpD4+e PHoRum l1nK '%s'";
$lang['notoplevellinktitlespecified'] = "n0 +0p L3V3L LINK +itlE SpecIpHIEd";
$lang['youmustenteralinktitle'] = "j00 mUST 3n+ER 4 LiNk t1+lE";
$lang['alllinkurismuststartwithaschema'] = "alL l1nK UR1S MUs+ ST@RT wiTh @ schEM4 (1.e. h++p://, ftp://, 1Rc://)";
$lang['editlink'] = "eDI+ LINK";
$lang['addnewforumlink'] = "aDd n3W ph0RUm lINK";
$lang['forumlinktitle'] = "f0Rum L1NK Ti+LE";
$lang['forumlinklocation'] = "f0RUM L1Nk L0c4+10N";
$lang['successfullyaddednewforumlink'] = "sUCcE55PhuLLY 4dd3D New ForuM LInk";
$lang['successfullyeditedforumlink'] = "sUCC3\$sPHulLY eD1+3D F0RUM l1Nk";
$lang['invalidlinkidorlinknotfound'] = "iNV@LiD LinK ID 0R LINk n0+ PHOund";
$lang['successfullyremovedselectedforumlinks'] = "sucC355PhULly R3m0v3d \$3Lec+3d L1Nk5";
$lang['toplinkcaption'] = "top LINK C4P+10n";
$lang['allowguestaccess'] = "aLloW 9uE\$t 4ccE5\$";
$lang['searchenginespidering'] = "sEaRCH 3N91Ne \$p1deRin9";
$lang['allowsearchenginespidering'] = "aLL0W sE4RcH eNG1N3 5PID3riNG";
$lang['sitemapenabled'] = "en48LE s1tem4P";
$lang['sitemapupdatefrequency'] = "siT3M@P uPd4T3 pHREQueNcY";
$lang['sitemappathnotwritable'] = "s1t3M4P DirEctOry MUs+ B3 Wr1+48LE 8Y +Eh web \$3rVeR / phP PR0CeSs!";
$lang['newuserregistrations'] = "new U\$3R re91sTr4+1OnS";
$lang['preventduplicateemailaddresses'] = "pr3V3N+ duPLIC4TE 3M4IL AddRE\$53S";
$lang['allownewuserregistrations'] = "aLloW New U\$3R rE915+R4+10nS";
$lang['requireemailconfirmation'] = "r3qU1RE EM4Il cONpH1Rm@Ti0n";
$lang['usetextcaptcha'] = "usE +eXT-c4p+Ch4";
$lang['textcaptchafonterror'] = "tEx+-c4ptcH4 H4s B3En d1S4bLeD 4UTOm4+IC4LLY BEc4use +h3RE 4RE n0 TRU3 TYpe pH0NTs 4v41L@8L3 PH0R I+ T0 Us3. pL3@s3 UPlo4d \$OM3 TRU3 +Yp3 f0n+\$ TO <b>t3X+_C4P+CH@/f0Nt5</b> 0N YOUR \$3RVER.";
$lang['textcaptchadirerror'] = "tEX+-c4P+CH@ H@s beeN d1s4BLEd BEc4uS3 +H3 teX+_C@ptcha DIREc+ORY 4nd I+'s SUb-DiREC+ORIE5 4re N0+ WRI+@8l3 by T3H W38 \$3Rver / PHP PR0cES\$.";
$lang['textcaptchagderror'] = "tExT-C4P+ch4 h@S BeeN DIsA8L3d 83C4U\$3 yOuR \$3RVER'\$ pHP 53TUP Do3\$ No+ pROVIDE SUPP0RT phOR 9D IM4GE M@Nipul4T10N 4ND / or +TPH F0N+ supP0R+. B0+h @RE R3QUIREd ph0r text-c@PtcH4 sUPPOr+.";
$lang['newuserpreferences'] = "n3W U\$ER pR3phEreNceS";
$lang['sendemailnotificationonreply'] = "em41L n0+1PHIC4T10n 0N rEPLY +o uS3R";
$lang['sendemailnotificationonpm'] = "eM@1l No+1f1c@T10n ON pM T0 U53r";
$lang['showpopuponnewpm'] = "sH0w p0pUp Wh3N r3CE1V1n9 n3W PM";
$lang['setautomatichighinterestonpost'] = "s3+ 4UT0M@T1c H1GH 1NT3RES+ ON P0\$t";
$lang['postingstats'] = "pOs+1N9 \$+4+s";
$lang['postingstatsforperiod'] = "pO\$TiN9 5+4tS ph0r P3r1od %s t0 %s";
$lang['nopostdatarecordedforthisperiod'] = "n0 POs+ D4+A RECoRDEd FOr +HIs peRi0D.";
$lang['totalposts'] = "t0T4L P0\$+\$";
$lang['totalpostsforthisperiod'] = "tOT@l pO\$TS pH0r +HIS peR1OD";
$lang['mustchooseastartday'] = "mUsT ChoO\$3 @ s+ar+ D@Y";
$lang['mustchooseastartmonth'] = "mU5t cHOo\$3 @ s+@R+ m0Nth";
$lang['mustchooseastartyear'] = "muS+ chO0SE 4 \$+4R+ YE4R";
$lang['mustchooseaendday'] = "mU5T cHoOS3 @ 3Nd D@Y";
$lang['mustchooseaendmonth'] = "muS+ cH0OSe 4 3nd MON+h";
$lang['mustchooseaendyear'] = "mU5T chOO\$3 @ End ye4R";
$lang['startperiodisaheadofendperiod'] = "s+4r+ PER1OD Is 4h34D 0PH 3nD P3R10D";
$lang['bancontrols'] = "b@N c0NTR0L5";
$lang['addban'] = "aDd bAN";
$lang['checkban'] = "cH3CK b4N";
$lang['editban'] = "ed1+ b4N";
$lang['bantype'] = "b4n TYPE";
$lang['bandata'] = "bAn D4+4";
$lang['banexpires'] = "b4n 3XPIReS";
$lang['bancomment'] = "c0mm3NT";
$lang['optionalbrackets'] = "(oP+Ion4L)";
$lang['ipban'] = "iP B@N";
$lang['logonban'] = "l09oN B4N";
$lang['nicknameban'] = "nIcKn4M3 B4n";
$lang['emailban'] = "em4IL 84N";
$lang['refererban'] = "r3pHERER b4n";
$lang['invalidbanid'] = "inv@l1D B4N ID";
$lang['affectsessionwarnadd'] = "thi\$ 84N M4y 4FPH3cT +H3 F0LL0WIN9 4c+1vE U\$eR \$3SSi0NS";
$lang['noaffectsessionwarn'] = "th1\$ b4N 4FF3CT5 N0 @ct1ve \$e\$\$1oNS";
$lang['mustspecifybantype'] = "j00 mU5+ Sp3C1Phy @ B4n +yPE";
$lang['mustspecifybandata'] = "j00 mUSt SPEcIFY sOM3 84n D4+4";
$lang['expirydateisinvalid'] = "exPIry D4+e 1\$ 1NV@L1d";
$lang['successfullyremovedselectedbans'] = "suCcE\$\$pHULLY reMOv3D 5EL3c+3D 84n\$";
$lang['failedtoaddnewban'] = "f4iLeD +0 @dd N3W 8@N";
$lang['failedtoremovebans'] = "f41lEd +0 R3mov3 \$0M3 0R 4LL 0F +HE \$3l3Cted b4n\$";
$lang['duplicatebandataentered'] = "dUplIC4T3 84n d4+4 3nTER3D. PLE@s3 ch3cK YouR W1Ldc4rdS +0 S3e 1ph tHEy 4lrE@DY M4TCh THE d4+4 3Nt3RED";
$lang['successfullyaddedban'] = "sUCc355pHULLy 4DDED b4n";
$lang['successfullyupdatedban'] = "suCCe\$5fUlLy UPd4+3d bAN";
$lang['noexistingbandata'] = "th3RE I5 n0 3Xi5+1NG b4N D@T@. +0 @dd 4 b@N CLICK Th3 '4dD NEW' BUTTon bel0W.";
$lang['youcanusethepercentwildcard'] = "j00 cAn us3 Th3 perc3NT (%) W1LdC4rd 5ymb0l iN @NY oF Y0uR B4N L1\$+\$ T0 0b+@1N P4r+1@L m@tcH35, i.3. '192.168.0.%' woULD 84N alL 1p 4ddRE5\$eS IN TEh r4nG3 192.168.0.1 +hR0uGH 192.168.0.254";
$lang['selecteddateisinthepast'] = "s3L3CT3D D@T3 I\$ in TEH P45t";
$lang['cannotusewildcardonown'] = "j00 C@NnOt 4Dd % AS 4 WILDc@rd m4tcH 0N I+S Own!";
$lang['requirepostapproval'] = "r3qu1r3 pOS+ 4Ppr0v4l";
$lang['adminforumtoolsusercounterror'] = "tHeRe Mu\$t be 4t LE@5+ 1 uS3R W1+H 4dM1N +o0l5 4ND phOrUM tO0LS 4ccE\$5 on 4LL Ph0RUM\$!";
$lang['postcount'] = "pOST coUN+";
$lang['changepostcount'] = "cH4n93 PO5+ C0Un+";
$lang['resetpostcount'] = "r3\$ET PO\$T COunT";
$lang['successfullyresetpostcount'] = "suCC3SSphULLY r3s3T pOSt c0Un+";
$lang['successfullyupdatedpostcount'] = "suCc35SFULLy uPd4+Ed poST COUNt";
$lang['failedtoresetuserpostcount'] = "f41LED +0 r353t P0\$T coUNt";
$lang['failedtochangeuserpostcount'] = "f4ILed T0 CH4n9e U\$3r Pos+ c0UN+";
$lang['postapprovalqueue'] = "pos+ 4PPrOv4L qUeU3";
$lang['nopostsawaitingapproval'] = "nO P05+\$ ARE 4W@1+IN9 4pPR0V4L";
$lang['failedtoapproveuser'] = "f@1LED +o 4PprOve U\$3r %s";
$lang['endsession'] = "eNd sesSIoN (K1Ck)";
$lang['visitorlog'] = "v1s1T0R l09";
$lang['novisitorslogged'] = "no v1\$1+orS LOgg3D";
$lang['addselectedusers'] = "adD s3Lec+3D U\$3rS";
$lang['removeselectedusers'] = "rEm0Ve 5El3CT3D u\$3rS";
$lang['addnew'] = "aDD NeW";
$lang['deleteselected'] = "d3l3tE 53Lec+3d";
$lang['forumrulesmessage'] = "<p><b>foRUM rUL3S</b></p><p>R391S+R4+10n +0 %1\$s IS pHr3e! W3 D0 INS15+ TH4+ J00 @81d3 8Y +He RUL3S 4ND p0L1c13s DET@1LeD B3LOW. iPh J00 @9r3e t0 +Eh TeRm\$, PLE453 CH3cK T3h '1 49ree' cH3CkBOX @nd preS\$ +EH 'R3g1S+3R' 8u++oN bELow. IPh j00 w0uLd l1K3 +O C4NCEL tHe r3g15tr@t1oN, CLick %2\$s T0 r3+URn T0 Th3 PhOrUm\$ IndeX.</p><p>@L+hoUGh +EH 4DmInISTR4T0R5 4ND mOD3R4TORS OPh %1\$S w1lL @++3MPt +o KE3P @lL objecT1On@8L3 Me5S4GEs 0Ff +H1S f0RuM, 1T 15 1mPo\$5ibL3 PHoR U5 +o r3VI3w @Ll me\$S4Ge\$. 4LL mESs4g3s expRES\$ THE V13w\$ Of T3H 4UTHOr, @nd nEI+H3r +EH 0WNEr\$ 0f %1\$\$, NOR pROj3C+ beEH1v3 F0RUM 4ND 1T5 4FF1LI4TEs W1lL 83 h3ld R3Sp0N\$1BLE pHoR +H3 C0n+3n+ OPH 4nY meS\$@GE.</p><p>BY 49r33Ing +0 +HeS3 rUlEs, J00 W4Rr@N+ +H4+ J00 WiLL Not Po5+ 4nY MEs\$a9ES th4t 4R3 O8\$C3N3, VUL9AR, s3xu4LLy-OR1eN+4teD, H4TEPhuL, tHREA+eNIN9, 0r OTheRW1\$3 In v10l@ti0N 0F 4nY L4WS.</p><p>tHe 0wN3R\$ of %1\$\$ RE53RV3 +3H riGHt t0 R3M0Ve, 3dI+, M0VE oR CL0\$E @Ny +Hr34d phOR 4nY R34\$0n.</p>";
$lang['cancellinktext'] = "hER3";
$lang['failedtoupdateforumsettings'] = "f41L3d T0 UPDATE FOrUm S3T+ING\$. Ple@53 TRy 4Gain L4tER.";
$lang['moreadminoptions'] = "mOr3 @dM1N 0p+10NS";

// Admin Log data (admin_viewlog.php) --------------------------------------------

$lang['changedstatusforuser'] = "ch4ng3d u\$3R s+4+u\$ FOR '%s'";
$lang['changedpasswordforuser'] = "ch@n93d P4S5wOrd F0r '%s'";
$lang['changedforumaccess'] = "ch4N9Ed pHoRuM 4cc3SS PERMISs1oN\$ PHOR '%s'";
$lang['deletedallusersposts'] = "dELE+3d alL po\$+\$ f0R '%s'";

$lang['createdusergroup'] = "crE4T3d USEr GrOup '%s'";
$lang['deletedusergroup'] = "dEl3+ed u\$3R 9R0uP '%s'";
$lang['updatedusergroup'] = "upD@+3D Us3R GROUP '%s'";
$lang['addedusertogroup'] = "aDDED US3r '%s' +O GroUP '%s'";
$lang['removeduserfromgroup'] = "rEm0vE USer '%s' FROm GR0up '%s'";

$lang['addedipaddresstobanlist'] = "addED Ip '%s' +O B@N L1S+";
$lang['removedipaddressfrombanlist'] = "rEmovED 1P '%s' FRom 8AN l1\$T";

$lang['addedlogontobanlist'] = "aDded lOgon '%s' TO 84N li\$+";
$lang['removedlogonfrombanlist'] = "reMov3d LO90n '%s' pHr0M b@N L1ST";

$lang['addednicknametobanlist'] = "adDED NICkn4me '%s' To b@N L1ST";
$lang['removednicknamefrombanlist'] = "r3M0v3d NICKn@M3 '%s' PHRoM B@N L1St";

$lang['addedemailtobanlist'] = "adD3D 3M4IL 4dDRE\$5 '%s' +o 84n L1St";
$lang['removedemailfrombanlist'] = "r3mOved 3m4iL 4dDRes\$ '%s' FROm B@n L15+";

$lang['addedreferertobanlist'] = "adD3d R3F3reR '%s' +O b@n l1st";
$lang['removedrefererfrombanlist'] = "reM0v3d R3PH3reR '%s' fr0m b4n LIs+";

$lang['editedfolder'] = "eDiTED fOLD3r '%s'";
$lang['movedallthreadsfromto'] = "mOV3D 4LL thRE4D\$ FROm '%s' t0 '%s'";
$lang['creatednewfolder'] = "cR34T3d NEw FOlDEr '%s'";
$lang['deletedfolder'] = "d3L3+3D f0LD3r '%s'";

$lang['changedprofilesectiontitle'] = "ch4ngEd prOphIl3 \$Ec+10n +I+Le Phrom '%s' +0 '%s'";
$lang['addednewprofilesection'] = "aDd3D nEw proF1l3 5Ec+Ion '%s'";
$lang['deletedprofilesection'] = "d3l3+3d PRophIle 53cTI0N '%s'";

$lang['addednewprofileitem'] = "aDD3D nEw PR0F1LE 1TEM '%s' +O \$3ct10N '%s'";
$lang['changedprofileitem'] = "cH4n93D prOPHiLe IT3M '%s'";
$lang['deletedprofileitem'] = "deL3+ed PROFile IT3M '%s'";

$lang['editedstartpage'] = "eDi+ED 5+4RT P4G3";
$lang['savednewstyle'] = "sAV3D N3W stYLE '%s'";

$lang['movedthread'] = "m0VED +HREAD '%s' PHrOm '%s' +O '%s'";
$lang['closedthread'] = "cl0\$3D THr34d '%s'";
$lang['openedthread'] = "opENed ThRE@d '%s'";
$lang['renamedthread'] = "rEn4m3d THr3@D '%s' T0 '%s'";

$lang['deletedthread'] = "dEl3t3d THR3@D '%s'";
$lang['undeletedthread'] = "uNDEl3TEd +HrE@D '%s'";

$lang['lockedthreadtitlefolder'] = "lOCk3d +HrE4D 0P+I0N\$ ON '%s'";
$lang['unlockedthreadtitlefolder'] = "unLOCKED +Hre@d Op+i0nS 0n '%s'";

$lang['deletedpostsfrominthread'] = "deL3ted P05tS FrOm '%s' IN Thr3@d '%s'";
$lang['deletedattachmentfrompost'] = "d3l3+3d 4++4ChMEN+ '%s' PHR0M POS+ '%s'";

$lang['editedforumlinks'] = "ed1+3d phORUM l1NK5";
$lang['editedforumlink'] = "edIted f0rUM l1NK: '%s'";

$lang['addedforumlink'] = "adD3D PH0rUM linK: '%s'";
$lang['deletedforumlink'] = "deLe+ED FORUM l1Nk: '%s'";
$lang['changedtoplinkcaption'] = "cH@N9ed +Op LiNK C4p+10N pHr0m '%s' +0 '%s'";

$lang['deletedpost'] = "d3le+eD PO\$+ '%s'";
$lang['editedpost'] = "eDi+ED P0\$+ '%s'";

$lang['madethreadsticky'] = "m@d3 +hRE@d '%s' st1Cky";
$lang['madethreadnonsticky'] = "m4D3 +HRE4d '%s' n0n-S+1CKY";

$lang['endedsessionforuser'] = "eND3D seSsi0n PHOr uSER '%s'";

$lang['approvedpost'] = "apPr0V3D Po\$t '%s'";

$lang['editedwordfilter'] = "eD1+3d wOrd PHIltER";

$lang['addedrssfeed'] = "aDdEd R\$5 PH3ED '%s'";
$lang['editedrssfeed'] = "eDITEd rS5 pH3ED '%s'";
$lang['deletedrssfeed'] = "dELE+ED R\$5 FE3d '%s'";

$lang['updatedban'] = "uPd4Ted B@N '%s'. cH@N93d TYpe pHR0M '%s' TO '%s', Ch4N93D d4T4 frOm '%s' T0 '%s'.";

$lang['splitthreadatpostintonewthread'] = "sPlIt THre4d '%s' @t Po\$t %s  In+O n3w +HR34d '%s'";
$lang['mergedthreadintonewthread'] = "m3Rg3d THRE4D5 '%s' @nd '%s' 1nT0 N3W +hr3@D '%s'";

$lang['ipaddressbanhit'] = "u\$Er '%s' 15 bANned. 1P @ddRES\$ '%s' M4TcH3D 84n d4+4 '%s'";
$lang['logonbanhit'] = "u53R '%s' 1S 84nN3d. L0GON '%s' M@TCh3d B@N d@t4 '%s'";
$lang['nicknamebanhit'] = "u53r '%s' 1S B4nN3D. N1CkN@M3 '%s' M4tcHeD b4N D@t@ '%s'";
$lang['emailbanhit'] = "u53r '%s' 1S b@nN3d. EM@iL ADDR3\$\$ '%s' m@TcHEd b@n D4t4 '%s'";
$lang['refererbanhit'] = "uS3R '%s' 1S 84Nn3d. ht+P rEph3r3R '%s' M4+CHed B4n D@TA '%s'";

$lang['modifiedpermsforuser'] = "mOdIF13d PERm5 PhOR US3R '%s'";
$lang['modifiedfolderpermsforuser'] = "moD1F1ED PHOld3R P3Rm5 fOr USEr '%s'";

$lang['deleteduseraccount'] = "d3Leted US3R @CCOun+ '%s'";
$lang['deletedalluserdataforaccount'] = "d3LEted 4lL U53r dAt4 pH0R 4cC0uN+ '%s'";

$lang['userpermfoldermoderate'] = "fold3R MOD3R4t0r";

$lang['adminlogempty'] = "aDM1n L0G 1\$ EMP+Y";

$lang['youmustspecifyanactiontypetoremove'] = "j00 MuS+ spEC1pHY 4n 4c+i0N +YpE T0 REM0v3";

$lang['alllogentries'] = "alL l09 3N+RI3s";
$lang['userstatuschanges'] = "uSeR \$+4TU\$ Ch4N9e\$";
$lang['forumaccesschanges'] = "fORum 4cc3SS ch@N9E\$";
$lang['usermasspostdeletion'] = "uS3R M@s\$ PoSt d3le+10n";
$lang['ipaddressbanadditions'] = "iP 4dDrE5S 84n 4DD1TI0N5";
$lang['ipaddressbandeletions'] = "iP 4DDr3s5 b4n dELE+1ONs";
$lang['threadtitleedits'] = "tHr34D +ItLE 3d1Ts";
$lang['massthreadmoves'] = "m@5s +HRE4D MovE5";
$lang['foldercreations'] = "fOld3R crE@T1OnS";
$lang['folderdeletions'] = "f0lDER d3let1ON\$";
$lang['profilesectionchanges'] = "pR0Ph1LE s3ct10n CH4n93s";
$lang['profilesectionadditions'] = "pRoPhiL3 SeC+i0n @dd1T1On\$";
$lang['profilesectiondeletions'] = "pr0pHIL3 sec+10N deleT10N\$";
$lang['profileitemchanges'] = "pR0f1L3 1TEM CH4Ng35";
$lang['profileitemadditions'] = "pRoPH1L3 1TeM 4DDITI0Ns";
$lang['profileitemdeletions'] = "pR0PhiLe i+Em deLE+IonS";
$lang['startpagechanges'] = "s+4rT P49e CH4Ng3s";
$lang['forumstylecreations'] = "f0RuM \$TYl3 cr3@+I0N\$";
$lang['threadmoves'] = "tHr34D mOVE\$";
$lang['threadclosures'] = "tHr34D CL0\$UR3S";
$lang['threadopenings'] = "tHrE@D opEN1N9S";
$lang['threadrenames'] = "thre4d REN@m3\$";
$lang['postdeletions'] = "po\$t D3LE+10N\$";
$lang['postedits'] = "p0s+ 3D1+\$";
$lang['wordfilteredits'] = "word F1Lter 3dIT5";
$lang['threadstickycreations'] = "thRE4D S+1CKY cr34T10nS";
$lang['threadstickydeletions'] = "tHr34D sT1CkY deleT10N\$";
$lang['usersessiondeletions'] = "user se5S10N DeLETiON\$";
$lang['forumsettingsedits'] = "fORuM \$3++1N9\$ 3dITS";
$lang['threadlocks'] = "thRe@d locKS";
$lang['threadunlocks'] = "thre4D UNLOCK\$";
$lang['usermasspostdeletionsinathread'] = "u\$3R m4\$\$ POs+ DEl3Ti0N\$ 1N 4 THre4d";
$lang['threaddeletions'] = "thre@D DEL3Ti0N\$";
$lang['attachmentdeletions'] = "a+t4cHMENt DeLEt1onS";
$lang['forumlinkedits'] = "f0RUM lINK eD1+\$";
$lang['postapprovals'] = "pos+ 4PpR0V4l\$";
$lang['usergroupcreations'] = "usER gROup CRE@T1ON\$";
$lang['usergroupdeletions'] = "uS3R 9R0Up d3LeT1On5";
$lang['usergroupuseraddition'] = "uS3r GR0UP U\$Er @Dd1+I0N";
$lang['usergroupuserremoval'] = "u53R 9roUP us3r r3Mov@L";
$lang['userpasswordchange'] = "u\$3r P455WOrd CH@NG3";
$lang['usergroupchanges'] = "us3R 9R0UP Ch4Ng3s";
$lang['ipaddressbanadditions'] = "iP 4DdRES\$ 8@N @DD1+IOn\$";
$lang['ipaddressbandeletions'] = "iP ADdre55 b4n DEL3TI0Ns";
$lang['logonbanadditions'] = "lo90N 84N 4ddI+i0NS";
$lang['logonbandeletions'] = "l09ON b@N D3lET1Ons";
$lang['nicknamebanadditions'] = "n1CKN4M3 84n 4dDI+iON\$";
$lang['nicknamebanadditions'] = "nIcKN4M3 b4N @DDI+I0Ns";
$lang['e-mailbanadditions'] = "e-m@iL ban 4ddI+1oNS";
$lang['e-mailbandeletions'] = "e-MAil 84n D3L3+IOn\$";
$lang['rssfeedadditions'] = "r\$\$ PHe3D @dD1tI0Ns";
$lang['rssfeedchanges'] = "r\$\$ FE3D CH4NG3S";
$lang['threadundeletions'] = "thr34D UNd3Let1On\$";
$lang['httprefererbanadditions'] = "hT+p r3PheRER B4N @DDI+i0n\$";
$lang['httprefererbandeletions'] = "h++P RephERER B4N dEL3+I0N\$";
$lang['rssfeeddeletions'] = "rSs pH33d deLET1Ons";
$lang['banchanges'] = "baN CH@nG3S";
$lang['threadsplits'] = "thR3@d 5pLi+\$";
$lang['threadmerges'] = "thre@D M3R93s";
$lang['forumlinkadditions'] = "f0Rum L1NK 4dd1+I0N\$";
$lang['forumlinkdeletions'] = "f0RUM l1nK DEL3+10nS";
$lang['forumlinktopcaptionchanges'] = "f0ruM L1Nk +0p c4P+IOn CH@Ng3s";
$lang['userdeletions'] = "u\$3r DelE+I0N\$";
$lang['userdatadeletions'] = "us3R d@T@ D3lET10N5";
$lang['usergroupchanges'] = "useR grOUP ch4nG3S";
$lang['ipaddressbancheckresults'] = "iP 4ddRe55 b4n cHECK R3sulTS";
$lang['logonbancheckresults'] = "l09on b@N cHEck R3SUL+s";
$lang['nicknamebancheckresults'] = "nIcKn4M3 84n cHEcK R3SUL+\$";
$lang['emailbancheckresults'] = "eM@1l b@N CH3cK r3sUL+\$";
$lang['httprefererbancheckresults'] = "h++P rEPHereR B4N ChEck R3SUL+s";

$lang['removeentriesrelatingtoaction'] = "rEmOV3 En+r13S reL4T1n9 +o 4c+IOn";
$lang['removeentriesolderthandays'] = "r3m0Ve enTR1eS OLDER +H4N (Day\$)";

$lang['successfullyprunedadminlog'] = "suCc355PHulLy pruNEd 4DM1N l09";
$lang['failedtopruneadminlog'] = "f4iL3d T0 PruNE 4DM1N L0G";

$lang['successfullyprunedvisitorlog'] = "suCc3\$sPHUllY PRUned VI51tOR lO9";
$lang['failedtoprunevisitorlog'] = "fa1LEd To PRUn3 VIsI+0R LOG";

$lang['prunelog'] = "prUN3 l0G";

// Admin Forms (admin_forums.php) ------------------------------------------------

$lang['noexistingforums'] = "n0 3XIsT1n9 fOruM\$ PHouND. T0 Cr34+3 @ N3w PH0RUm cl1cK t3H '4dd N3W' 8U++0n 83L0w.";
$lang['webtaginvalidchars'] = "w38T4G C4n oNlY COnt41n UPp3RC@sE @-Z, 0-9 @Nd UNDER\$cOR3 CH@R4C+ERs";
$lang['invalidforumidorforumnotfound'] = "iNV4L1d PhoRUM pHID 0R phoRuM noT FOUND";
$lang['successfullyupdatedforum'] = "sUccE5\$fuLLY UPD@+ED PH0RUM";
$lang['failedtoupdateforum'] = "f4IleD T0 UPD4T3 PHOruM: '%s'";
$lang['successfullycreatednewforum'] = "sUCCE\$\$fuLly crE4+3d n3W fORUM";
$lang['selectedwebtagisalreadyinuse'] = "t3H \$3lEcT3D WEB+a9 1\$ 4lR3@dY 1n USE. pL3@s3 ch0o\$3 @n0+HER.";
$lang['selecteddatabasecontainsconflictingtables'] = "t3h s3lEcT3D D4+4b45E COn+41Ns cOnpHLic+InG +48L35. c0NFL1c+1N9 +48L3 N4MES @RE:";
$lang['forumdeleteconfirmation'] = "aR3 J00 SurE j00 W4n+ +O deLEt3 4LL opH +h3 \$eL3CT3d foRUMS?";
$lang['forumdeletewarning'] = "plE4S3 n0+e TH4T J00 C4NNO+ r3C0V3R D3leted PHorUM5. OncE d3le+eD 4 PH0rUM @ND 4ll 0F +EH @S\$OCi@ted D@T@ 1\$ P3Rm4n3n+lY R3M0ved FROM TEH D4+4B@S3. 1pH J00 DO N0+ WISh +O Del3+3 T3H 53lEcTed ForuM\$ Ple@S3 ClICK C4nc3L.";
$lang['successfullyremovedselectedforums'] = "suCce55PHUlLy D3LET3D 53leC+3D PhORuMs";
$lang['failedtodeleteforum'] = "f4iL3d +O D3Le+3d FOruM: '%s'";
$lang['addforum'] = "add pH0RuM";
$lang['editforum'] = "ed1T f0rUm";
$lang['visitforum'] = "v1si+ PhOrum: %s";
$lang['accesslevel'] = "acC3S\$ L3VEL";
$lang['forumleader'] = "f0rum le@d3R";
$lang['usedatabase'] = "uS3 D4t48@\$3";
$lang['unknownmessagecount'] = "uNKn0WN";
$lang['forumwebtag'] = "fORUM w38+4G";
$lang['defaultforum'] = "d3ph4UL+ fORum";
$lang['forumdatabasewarning'] = "plE4s3 ENsuRe j00 53Lec+ +3h CorR3c+ D4+4bA5E WH3N CR34+1ng 4 n3W f0rUm. onCe CR34+Ed 4 N3W ForuM c4NNO+ BE M0vED b3Tw3EN @v@1l48LE D4+484\$3s.";

// Admin Global User Permissions

$lang['globaluserpermissions'] = "gLob4l Us3R PeRM1ss10n5";

// Admin Forum Settings (admin_forum_settings.php) -------------------------------

$lang['mustsupplyforumwebtag'] = "j00 MUs+ \$UPPLY @ PH0RuM w3bt49";
$lang['mustsupplyforumname'] = "j00 MUsT 5UPPly 4 F0RuM n@mE";
$lang['mustsupplyforumemail'] = "j00 Mu\$t 5UpPly @ F0RUM 3M@Il AdDRE5S";
$lang['mustchoosedefaultstyle'] = "j00 MU5+ CHo0\$3 4 dEF4UlT f0rUM 5+YL3";
$lang['mustchoosedefaultemoticons'] = "j00 Mu\$T CH0O\$3 D3PH@ULT f0RUm 3MO+icOn5";
$lang['mustsupplyforumaccesslevel'] = "j00 mUs+ \$uPPLy 4 PH0RUM 4CCE55 LEV3L";
$lang['mustsupplyforumdatabasename'] = "j00 MusT \$UPPLY @ pH0RUm d4+4b4\$3 N@mE";
$lang['unknownemoticonsname'] = "uNkn0WN 3m0T1CONs N4M3";
$lang['mustchoosedefaultlang'] = "j00 mUSt cHOO\$3 4 DEF4UL+ fORUM L4nGu@G3";
$lang['activesessiongreaterthansession'] = "aCt1vE \$E\$SioN +imEouT C4NNo+ 8E Gr3@TeR Th4N \$3S\$1oN tiME0u+";
$lang['attachmentdirnotwritable'] = "a+T@cHM3N+ DIr3cTOry 4ND sY5+Em +3MPoR4rY D1reC+0Ry / phP.1nI 'uPL04d_+MP_DiR' MUS+ b3 wR1tAbLE 8Y +h3 w3B s3RV3R / pHp pR0cE\$\$!";
$lang['attachmentdirblank'] = "j00 mU5+ sUpPLy @ dIReCTOry +O S4Ve 4TT4chMeNtS In";
$lang['mainsettings'] = "m41n S3T+1NG\$";
$lang['forumname'] = "f0ruM n4M3";
$lang['forumemail'] = "fORuM EM4IL";
$lang['forumnoreplyemail'] = "n0-R3pLY eM@1L";
$lang['forumdesc'] = "f0rUM D3SCRip+I0N";
$lang['forumkeywords'] = "f0rUM k3Yw0rdS";
$lang['forumcontentrating'] = "f0RUm C0NtENt R4+1n9";
$lang['defaultstyle'] = "dEph4uLt \$tYL3";
$lang['defaultemoticons'] = "d3f@ulT 3M0+IC0N\$";
$lang['defaultlanguage'] = "dePH4UL+ L@ngu493";
$lang['forumaccesssettings'] = "f0RuM @cc3S\$ 53+T1NGS";
$lang['forumaccessstatus'] = "fOrUM 4CCe\$\$ 5+4+U\$";
$lang['changepermissions'] = "cH4n9e P3RmIs5IOnS";
$lang['changepassword'] = "ch4Ng3 P4S\$WORD";
$lang['passwordprotected'] = "p4\$5worD PR0+3C+ED";
$lang['passwordprotectwarning'] = "j00 H4V3 N0+ \$3+ @ PHoruM paSswORd. iPH J00 d0 n0T \$3t @ p@SSWorD TH3 P4\$\$wOrd PrOt3CT1On PHuncT10N4LI+y WiLl be @UT0M@tIc4lLY dIs48l3d!";
$lang['postoptions'] = "pOS+ OPTIonS";
$lang['allowpostoptions'] = "aLl0w P0St 3DiT1N9";
$lang['postedittimeout'] = "po\$+ 3diT +1Me0U+";
$lang['posteditgraceperiod'] = "pO\$+ 3DIT Gr4C3 PER10d";
$lang['wikiintegration'] = "wIKiW1KI Int39R@T1ON";
$lang['enablewikiintegration'] = "en4BLE w1KIW1KI 1N+39R4+10N";
$lang['enablewikiquicklinks'] = "eN4bL3 WikIWIK1 QUick L1NKs";
$lang['wikiintegrationuri'] = "w1k1w1K1 L0C4+10n";
$lang['maximumpostlength'] = "m@x1mUM P0\$+ LEn9+H";
$lang['postfrequency'] = "p0St FR3qU3NCy";
$lang['enablelinkssection'] = "en4bLE LInkS 53cT10n";
$lang['allowcreationofpolls'] = "alL0W cr34ti0n 0pH Poll\$";
$lang['allowguestvotesinpolls'] = "all0W 9ue5+5 +O v0+3 1N P0LL5";
$lang['unreadmessagescutoff'] = "uNReaD Mess4G35 CuT-0FPH";
$lang['disableunreadmessages'] = "d1S@8LE uNR34d MESs4gES";
$lang['thirtynumberdays'] = "30 D4y5";
$lang['sixtynumberdays'] = "60 D4Y\$";
$lang['ninetynumberdays'] = "90 d4y\$";
$lang['hundredeightynumberdays'] = "180 D@y\$";
$lang['onenumberyear'] = "1 ye4r";
$lang['unreadcutoffchangewarning'] = "depeND1ng On \$3RveR PErfORM4nC3 4ND +H3 NUMB3r OPH +hRE@DS y0uR f0RUm5 C0N+4IN, ch4Ng1N9 +h3 UNr34D cU+-OFF m4y T4Ke \$3V3R4L MinUTE5 T0 c0MPLetE. F0R +hI\$ RE@5On 1t 1\$ r3COmm3nDeD +H4T j00 AV0ID cH4NGIN9 TH1\$ SeTt1N9 WHILE y0ur ForUmS 4Re bu5y.";
$lang['unreadcutoffincreasewarning'] = "iNcRe@SIN9 the UNread cuT-0Fph WILL M4K3 THR34ds M4rK3D 4s mod1PhIED \$1nc3 4Nd thr34D\$ older +h@n +H3 Pr3Vi0Us cUT-0PHF @ppe@R 4S uNr34D +o 4Ll us3RS";
$lang['confirmunreadcutoff'] = "arE j00 suR3 J00 W4n+ +o Ch4N9E TH3 unR34d cu+-0PHPh?";
$lang['otherchangeswillstillbeapplied'] = "cLickIn9 'No' W1Ll ONly CaNC3L THE unR3@d Cu+-ofPH cH@ng3s. O+H3r cH4n9es Y0U'V3 M@D3 W1lL s+ilL be S4VeD.";
$lang['searchoptions'] = "se4RCH oP+10n5";
$lang['searchfrequency'] = "se@RCh PhR3QUency";
$lang['sessions'] = "s35\$1oNS";
$lang['sessioncutoffseconds'] = "s3S\$1ON cuT opHf (s3c0ndS)";
$lang['activesessioncutoffseconds'] = "ac+iV3 S3S\$1On cu+ 0fF (\$3C0NDS)";
$lang['stats'] = "st4+5";
$lang['hide_stats'] = "h1D3 St4T5";
$lang['show_stats'] = "sh0W sT@T5";
$lang['enablestatsdisplay'] = "en4bLE S+4+\$ dI\$PL4y";
$lang['personalmessages'] = "pEr\$0n4l ME554G35";
$lang['enablepersonalmessages'] = "en4bLE p3r50N4L ME\$54gE5";
$lang['pmusermessages'] = "pm m3S54g3s PER u\$3R";
$lang['allowpmstohaveattachments'] = "aLL0W P3RSoN4L M3Ss493\$ tO H4V3 A++4ChmeN+\$";
$lang['autopruneuserspmfoldersevery'] = "auto pRune U\$3r'S PM Ph0lD3rS 3VEry";
$lang['userandguestoptions'] = "u53R @Nd GueS+ oP+ioNS";
$lang['enableguestaccount'] = "eN@bLE 9U3ST 4CCOUnT";
$lang['listguestsinvisitorlog'] = "l15T 9u3\$+S 1n v1\$1+oR L0G";
$lang['allowguestaccess'] = "aLlOW 9u3sT 4CCES\$";
$lang['userandguestaccesssettings'] = "usER 4Nd Gu3s+ 4ccEs\$ \$3+t1N9\$";
$lang['allowuserstochangeusername'] = "aLl0w U5eR\$ +0 CH@n93 U53RN4Me";
$lang['requireuserapproval'] = "r3qU1R3 User @PPr0v4l bY 4Dm1N";
$lang['requireforumrulesagreement'] = "reQU1R3 US3R tO @gr3E tO FOrum ruL3\$";
$lang['sendnewuseremailnotifications'] = "s3ND nO+1PHIC@T1ON t0 gLo84L FoRUM 0WN3r";
$lang['enableattachments'] = "enA8L3 @Tt4CHM3NT5";
$lang['attachmentdir'] = "at+4cHm3nt D1R";
$lang['userattachmentspace'] = "atT@cHM3N+ sP4c3 PER U\$3r";
$lang['userattachmentspaceperpost'] = "aT+4chM3nT sP4ce P3R P0\$t";
$lang['allowembeddingofattachments'] = "aLl0W 3M8eDd1N9 OPh 4+T4ChMEn+S";
$lang['usealtattachmentmethod'] = "u\$3 @L+Ern@T1VE 4tT4cHMEnt mE+hoD";
$lang['allowgueststoaccessattachments'] = "alLoW 9U35+\$ +0 @cc3s\$ 4TT@chM3nT5";
$lang['forumsettingsupdated'] = "fOrUM se++1N9S sUcc3\$\$fuLLY uPd@TED";
$lang['forumstatusmessages'] = "fOrUm St4+US mES\$4935";
$lang['forumclosedmessage'] = "f0rUm cLO53D m3s\$49e";
$lang['forumrestrictedmessage'] = "f0rUM R3\$+R1CTEd meS\$49e";
$lang['forumpasswordprotectedmessage'] = "fOruM P4s\$wORD Pr0T3C+3d M3S\$493";
$lang['googleanalytics'] = "gO0GL3 4N4LYT1cS";
$lang['enablegoogleanalytics'] = "en@8L3 Goo9L3 4n4ly+1c5";
$lang['allowforumgoogleanalytics'] = "aLl0w 9O0GLE 4NALyt1Cs ON e4CH FOruM";
$lang['googleanalyticsaccountid'] = "g0oGLE 4NALYTic\$ 4cc0Un+ Id";

$lang['googleadsense'] = "gOo9L3 4D\$3ns3";
$lang['adsensepublisherid'] = "aDS3N53 pUBLI\$h3r 1D";
$lang['adsensemediumadid'] = "m3D1UM s1zed (468X60) @D 5l0+ id";
$lang['adsensesmalladid'] = "sM4lL S1Z3D (234x60) @d 5lO+ ID";
$lang['adsenseallusers'] = "alL USER5";
$lang['adsenseguestsonly'] = "gu3s+\$ 0nLy";
$lang['adsensenoone'] = "nO-On3 (D1\$4bL3d)";
$lang['adsensedisplayadsforusers'] = "d1SpL4Y 4d53N53 4Ds PhOr";
$lang['adsensedisplayadsonpages'] = "d1sPl4y 4d\$3Ns3 4d5 oN";
$lang['adsenseallpages'] = "t0p 0PH EV3rY P4g3";
$lang['adsensetopofmessages'] = "toP 0F M3S\$493S";
$lang['adsenseafterfirstmessage'] = "apHteR 1S+ M3S\$49E";
$lang['adsenseafterthirdmessage'] = "aFt3R 3Rd MEsS4G3";
$lang['adsenseafterfifthmessage'] = "af+3R 5TH ME\$54g3";
$lang['adsenseaftertenthmessage'] = "af+3R 10tH M35549E";
$lang['adsenseafterrandommessage'] = "aPhTeR 4 R4ND0m M3SS4GE";
$lang['registertoremoveadverts'] = "rE9IS+3R T0 REMOv3 tH3s3 4dv3rTS.";

// Admin Forum Settings Help Text (admin_forum_settings.php) ------------------------------

$lang['forum_settings_help_10'] = "<b>pO5t EDI+ +iME0U+</b> Is +EH T1mE 1N mINU+35 4f+3R pOS+iN9 TH4T @ U\$eR c4n 3dI+ +H3IR Po\$t. 1PH s3+ tO 0 tH3RE 1S no Lim1+.";
$lang['forum_settings_help_11'] = "<b>m4X1MUM p0\$+ L3N9+H</b> 1s TEH M@XIMUM num83R 0PH ch@R4cT3r5 +H4+ W1Ll b3 d1\$Pl4Y3D 1N @ p0\$+. IPH @ p0\$+ 1S L0N93r +h4N teH Num83R 0PH CH@R4cT3RS dePhIned H3Re 1T w1ll 83 cU+ sHOR+ 4ND a lINk @dDed t0 TH3 8OT+0m t0 4lLOW uS3rS +o R34d THE whOL3 P05+ 0N 4 \$eP4r@Te p493.";
$lang['forum_settings_help_12'] = "iF J00 Don'T W@n+ Your U53Rs T0 b3 48lE T0 CR3@+E PolL\$ j00 C@n dI54Ble +H3 @8OV3 OP+10N.";
$lang['forum_settings_help_13'] = "tH3 lInKs \$3ctIOn 0ph 83eh1ve Pr0viDeS 4 PL4cE FOR Y0Ur US3R\$ TO M4IN+@1n @ L1\$+ 0PH 51TE\$ +h3Y fR3QUEntLY Vi\$1T th4+ o+h3r UseR\$ M4Y PH1ND U53phUL. liNkS c@N b3 DIv1DED Int0 c@+E9Or1e\$ 8Y foLDER 4ND 4Ll0W Phor COmM3N+S @nd R4+1N95 +0 8e G1VEn. 1n 0rdeR t0 MOdeR@te +3H liNkS \$3cTi0n 4 USeR MUs+ 83 R4N+3d GL084l M0DEr@T0R \$t@+uS.";
$lang['forum_settings_help_15'] = "<b>se5S1On cUT oFpH</b> IS Th3 M4ximUM T1ME 83FoR3 @ US3r'\$ 53s\$10N IS D33M3d DE@D 4ND +h3y 4rE Lo9Ged 0u+. 8Y D3F4uL+ +HI\$ 15 24 hOURs (86400 s3c0nD\$).";
$lang['forum_settings_help_16'] = "<b>ac+iVe \$eSs1on Cu+ OPhf</b> Is +3H M@x1mum t1ME B3PH0r3 @ USEr'S seS\$1oN is deEM3d In4C+1VE 4T Which POiNt TH3Y ENT3r 4N 1dLE 5+4T3. iN +h1S 5+4Te +HE UseR R3M41nS LOg9ED IN, 8Ut tH3Y @re r3M0v3d PhrOm +3H 4C+1V3 US3RS Li\$+ iN TEH st4TS d1SPL4y. oNCE tHEY B3COMe 4c+1ve @941N +h3Y w1LL BE rE-4Dd3D t0 +3h L1\$t. 8Y DeF4UL+ +H1S 53T+in9 1S SET +0 15 MInUTE\$ (900 53C0NDS).";
$lang['forum_settings_help_17'] = "eN48lIN9 +H1s Op+I0n 4LL0WS B3EHIve +O inClUDE 4 5+4+S DIspL@Y 4T Th3 8O+T0M 0F TEh m3s\$@geS P@n3 S1mIL4r To +3H 0NE U53d BY M4NY PHorUm s0f+W4rE T1+LE5. 0NCE 3N@8L3D +H3 D1SPL@y 0pH THE 5+4+S P49e C4n 83 t0G9L3d 1Nd1V1dU4llY 8Y 3@CH uSeR. IPH +heY d0n'+ w4NT +O \$33 1+ tH3Y C4N H1dE 1T FrOM vIEw.";
$lang['forum_settings_help_18'] = "p3rSON@l M3sSa93\$ 4r3 iNV4Lu@8l3 @S 4 W4Y Oph t4KING MOr3 PRiv4+e M4+t3R5 0UT of VIEW oF +3H 0+H3R MEMBeR\$. HOw3V3R 1f J00 d0n'T w4N+ Y0ur U53rS +0 8E 4BL3 tO \$3nd 34cH 0+heR P3RSon4l M3S\$@93s J00 c4n dI5@bL3 THIs 0Pt1ON.";
$lang['forum_settings_help_19'] = "p3R\$0N4L meSs4G3S C@n @LS0 C0nT41n 4+T4cHMENTs wHICH cAn 83 u53PhuL Ph0R ExcH4ng1N9 Ph1LE\$ 83Twe3N U\$3RS.";
$lang['forum_settings_help_20'] = "<b>n0+E:</b> +3h sp4c3 4Ll0C4+IOn FOR pm 4++4ChM3N+\$ 1s +4kEN FroM 3@CH u\$3rs' m4IN @tT@CHM3n+ 4lLOC4+IOn 4ND 1S n0+ 1N 4DD1+10n +O.";
$lang['forum_settings_help_21'] = "<b>en48L3 9u3S+ 4CCOUN+</b> 4LLOW\$ V1\$1T0R\$ +O BR0W5e Y0uR pH0rum ANd Re4d Po\$ts WitH0uT R39i5T3r1ng 4 USER 4cc0UN+. 4 u\$eR 4ccOUn+ is \$+1LL REquiR3d 1f th3y W1Sh +o pO\$+ OR Ch@N93 UseR PREF3ReNC3S.";
$lang['forum_settings_help_22'] = "<b>li5T gU3s+\$ IN v1s1+or l0G</b> 4LlOW\$ J00 TO sp3cIPHy WH3+HEr 0r N0+ UNRE91st3reD U\$3Rs 4r3 l1\$t3D oN T3H V1\$1+Or L0G 4LonG\$1de R3gIs+3red U\$3Rs.";
$lang['forum_settings_help_23'] = "bE3hIV3 4LL0Ws A++4chMEN+5 +0 8E UPLo4DED TO m3ss4G35 WhEN po\$t3d. 1Ph j00 H4V3 L1MITED WE8 sp4ce J00 m@Y WHicH TO di54bL3 4tt4chMeNTS by cLE4RIN9 TEH b0X 48ov3.";
$lang['forum_settings_help_24'] = "<b>aT+4CHM3NT DIR</b> 1S +3h L0c@TI0N 83ehIV3 \$h0UlD st0r3 4+t4cHmen+\$ 1N. TH1S DIREC+Ory Mu5+ 3xiS+ On y0UR web SP4Ce @nD muS+ B3 wRI+4blE 8y TEH W38 \$3RVER / php PROC3SS 0THERW1SE UPL04D\$ wIll F41l.";
$lang['forum_settings_help_25'] = "<b>a+t@chM3nT 5P4Ce pEr US3r</b> i\$ +3H m4X1mUm 4MoUn+ 0F DISk \$p4cE @ U53R H4\$ f0R 4Tt4cHM3N+5. once +H15 5p@CE I\$ US3d up tHE uS3R C4Nno+ UPL04D @NY m0re 4++4chMENT\$. by D3F4uLt +H15 1S 1MB 0PH \$p4c3.";
$lang['forum_settings_help_26'] = "<b>aLL0W 3MBEddIng 0f 4tT4ChMEN+5 IN me\$5@g3S / \$19N4+Ur3s</b> @lL0W5 U53RS +o 3M8ed @tt@cHMENTS In P0\$tS. en48liN9 +h1s Op+1oN WH1LE U\$eFUL c@N 1NCRE@s3 y0uR B4ndWIDTH uS@93 dR45+IC4LLY und3r c3rT4iN cONFIGUR@ti0Ns oF PHP. iF J00 H4V3 L1MI+ED 84ndW1d+H 1t 1S r3C0Mm3nd3d +h@T j00 D1s@bL3 tH1\$ 0P+10n.";
$lang['forum_settings_help_27'] = "<b>u\$3 @L+erN@tiV3 @t+@CHMEn+ M3+h0D</b> F0RCES 83eH1V3 To u\$3 4n 4L+3Rna+iV3 r3+rIeV4L M3+HOD PH0r 4TT4cHM3Nt5. 1F j00 r3CE1V3 404 erR0R M3554Ge5 wh3n Try1n9 +O d0WNlO4D 4++4CHm3ntS pHr0M m3S\$493s Try 3N48l1nG TH1s Op+IOn.";
$lang['forum_settings_help_28'] = "tH3se \$eTT1N95 4lLOw\$ yOUR F0RuM +0 8E \$pID3red BY 53@rCh 3N91nE5 LIKe 9OOGLe, 4lT4ViS+4 4nd Y4H0O. 1Ph J00 5w1TCH +His op+10n 0pHf y0uR PH0RUM WilL n0+ BE 1ncLUDEd 1N Th3S3 SE4RCH 3NGIne5 resUl+s.";
$lang['forum_settings_help_29'] = "<b>aLLOW neW u\$3R RE915+r4+10Ns</b> 4LLow\$ 0R dIS4LLowS +EH cR3@+I0N 0f NEw u\$3R @ccOUn+s. \$3t+IN9 +3h 0ptiON +O N0 cOMPL3+eLY di\$@bl3S +H3 REgI\$+R4t10N ph0rM.";
$lang['forum_settings_help_30'] = "<b>en@8l3 wIK1WIKI 1NTEGr4T10n</b> pR0v1DE5 W1K1W0RD supP0R+ In Y0Ur pH0ruM P0S+s. 4 w1KIWorD 1S M4DE UP of tWO oR M0R3 cOnC4+3n4T3d WOrdS WI+h uPP3RcAs3 l3+teR5 (opHteN RePH3rr3d +0 45 c4m3LC4se). IPh J00 WR1+3 4 W0RD TH1s WAY 1+ WiLL AUt0m@+IC4LLY 83 CH@n9Ed Int0 4 hYP3rLInk PoiN+In9 T0 y0UR ch053N W1kiWIki.";
$lang['forum_settings_help_31'] = "<b>eN48lE WikIW1K1 Qu1Ck l1Nk5</b> eN48LeS +3h u53 0PH Msg:1.1 4ND U\$3R:l090N S+Yle ExTEND3D W1KIL1NKS WHICh CRE4+E HypeRLInKs T0 +HE sp3C1Phied M3\$54G3 / u\$3r PRoph1LE of +3H SPEcIPHIED Us3r.";
$lang['forum_settings_help_32'] = "<b>wikiwIk1 l0C4+IOn</b> 15 Us3D T0 Sp3CIFY tH3 UR1 0F yoUR W1KIWIki. WH3N 3N+ER1NG +eh uRi u\$3 <i>%1\$5</i> T0 Ind1C4+E Wh3re IN t3H uR1 +He W1K1WOrd SHOULd 4PPE4R, 1.3.: <i>h+Tp://EN.wIkIPEd1@.0rG/WIKI/%1\$S</i> w0Uld lINK yoUR wiKiWOrdS To %s";
$lang['forum_settings_help_33'] = "<b>foruM 4CCe5\$ 5+4+US</b> con+rOlS hOw u53rS M@Y 4cc3SS yOuR PHOrum.";
$lang['forum_settings_help_34'] = "<b>oP3n</b> w1ll 4lLoW 4ll Us3R5 4ND GU3S+s 4cc3sS +O y0uR PhorUM W1TH0u+ r35+R1cT10n.";
$lang['forum_settings_help_35'] = "<b>cloS3D</b> pRev3N+S 4CCeSs FoR 4Ll UseR5, WI+h THE 3XCEPT1On 0pH +3H 4DM1N WH0 M4Y sTILL @cc3sS +h3 4Dm1N p4neL.";
$lang['forum_settings_help_36'] = "<b>re\$TR1cT3d</b> @lLOWs +0 53T 4 L1\$T 0ph U53rS Who 4r3 4lL0wED 4cceS\$ TO yoUR PH0RUM.";
$lang['forum_settings_help_37'] = "<b>p4sSwoRd PR0+3cT3D</b> 4Ll0W\$ J00 T0 \$3+ @ P4S\$word +o 9iV3 Out +0 Us3R5 5o +H3Y c4N 4CCE\$5 YOUR f0RUM.";
$lang['forum_settings_help_38'] = "when 53Tt1nG R3\$tr1ct3d 0r P4\$\$W0RD ProT3cT3D m0D3 J00 WiLL n3ED T0 S4V3 Y0uR CHang3S 83pHoR3 j00 c@N CH4nG3 +H3 US3r 4ccE\$5 PRIv1LE9e\$ 0r p4\$5WOrD.";
$lang['forum_settings_help_39'] = "<b>Search Frequency</b> defines how long a user must wait before performing another search. Searches place a high demand on the database so it is recommended that you set this to at least 30 seconds to prevent \"search spamming\"from k1LLiN9 +3H 53rVER.";
$lang['forum_settings_help_40'] = "<b>poSt fR3qU3ncY</b> i5 TEH M1NIMUm TIME @ uSER mus+ w4It 83pH0R3 THEY C@N P0\$+ 49@IN. TH1S \$3++iN9 4l5O 4FPH3cTs tHE CRe4tI0N 0Ph pOLLs. \$3+ +o 0 t0 di\$4bL3 +H3 Re\$TR1c+ION.";
$lang['forum_settings_help_41'] = "t3h A8OVE 0P+Ion\$ chANG3 +3h d3F4uLT V4Lu3\$ F0R TH3 USER re9I\$+r4t1On pHorM. WH3rE 4PPLIC@8lE o+HER \$3++In9\$ W1lL U\$3 ThE F0RuM'\$ 0Wn d3Ph4ULT s3tT1n9\$.";
$lang['forum_settings_help_42'] = "<b>pr3VEn+ USe Oph dUPliC@+E eM@Il @DDREs53S</b> Ph0rc3s B3eH1VE To cHeck T3H U\$ER 4CC0UNt5 4941n\$T +3H eM4Il 4ddRE\$s T3H Us3r 1\$ R391s+3R1N9 w1+H @nd PR0mPTs +HEM T0 U\$E @N0+H3r 1ph IT IS 4lR34Dy 1N U\$3.";
$lang['forum_settings_help_43'] = "<b>rEQUiRe eM@iL cOnpHiRM@+iON</b> Wh3N En48LED WILl \$eND 4n Em@1L t0 e4cH n3W UseR W1+H 4 LINk THA+ c@N b3 USed TO CONFirM TH31r 3m@1L @ddR3s5. UN+il +H3Y ConpH1rM Th3Ir Em41l 4ddRe55 +H3Y W1Ll n0+ be 48le +0 P0\$+ UNles\$ tH3ir U5eR PErmi5S1OnS 4r3 cHaNg3d M@nU4LLy 8Y 4N 4DM1N.";
$lang['forum_settings_help_44'] = "<b>u\$3 +3xT-C4PTcH4</b> pR3S3N+s +h3 neW U\$3r w1+h 4 m@n9l3d 1M4g3 WH1cH +h3Y mU\$t C0Py 4 NUM83r FR0m Int0 4 +eX+ FIELD ON tHe REG1S+R4+IOn pHORM. u5E +HIs OpT10N +o PREVEN+ 4uT0m4+3D sI9N-Up VI4 SCRIPT5.";
$lang['forum_settings_help_47'] = "<b>p0St ed1+ 9r@C3 PER1Od</b> 4LLow5 J00 +O D3F1NE @ peR1OD 1n miNuTes WHER3 Us3rs M@Y ed1T P0\$t5 WITH0U+ +HE 'edI+3D BY' tExT 4pP3@RIN9 ON +h31R p0\$t\$. 1pH SE+ +O 0 t3h 'EDITED by' TEx+ W1LL 4LW4y5 4pP3AR.";
$lang['forum_settings_help_48'] = "<b>unrE4D ME554gE\$ CUT-oPhPh</b> Sp3CifIes How L0NG m3s\$@GE\$ R3m@In UNr3@D. +HR3@D5 m0D1FI3d no L4+3R tH@N teH P3R1OD s3l3cTED W1LL @uT0m4+1C@LLy 4pP3@R 4S R34d.";
$lang['forum_settings_help_49'] = "cHoOS1ng <b>dIs48Le UNR34d ME5S@935</b> WiLL cOmpLEt3lY R3M0Ve uNre4d ME\$\$4geS SupPORt 4ND reM0ve the R3LeV4NT op+10N\$ PHroM +HE D1ScUs510N +YPE DROp dOWN 0N tEH +Hr34d LIS+.";
$lang['forum_settings_help_50'] = "<b>r3quIR3 User @Ppr0v@L 8Y 4dMin</b> 4llOW\$ J00 +0 R3S+r1C+ @cceS\$ bY NeW Users un+1l THey H@Ve b33n @PPr0V3D bY @ M0deR4+OR 0R 4DM1N. W1THOu+ 4pPR0V4L 4 US3R C@nn0t 4cceSS @NY 4R3@ 0F +H3 83EH1VE foRUM INs+4LL@+ioN 1NClUD1NG 1nD1VIDU4L ForumS, Pm inbOX 4nd My PHoruM\$ \$3CtI0N\$.";
$lang['forum_settings_help_51'] = "u\$E <b>cl0S3D M3\$s493</b>, <b>r3S+R1cTeD m3s\$4G3</b> 4nd <b>pAS\$w0Rd Pr0T3cTed M3S\$@g3</b> tO cU5toM1\$e TEH m3S\$4g3 D1SpL4y3D wheN U\$er5 @cc3s\$ YoUr ph0ruM in +EH v4r10u\$ \$T4T3S.";
$lang['forum_settings_help_52'] = "j00 c4N u5e hTMl IN y0ur ME554G3s. HyPeRl1NKS 4ND EM@1L 4DDRE553s WIll 4l5O Be 4UtoM4t1cAlLy cONveRTED +O lINK5. T0 u\$e +H3 DEf@uLt B3Eh1ve F0RUM m3S\$@G3s cL3@R TH3 pHi3ld5.";
$lang['forum_settings_help_53'] = "<b>aLloW Us3r5 +0 cH@N93 uSErn4me</b> p3rmIt5 4Lr34DY re91\$+3RED U\$ER5 +o ch@N9E +h3IR u53RN4M3. When 3n@8L3D j00 c@n tR@CK tHe CH@n9E\$ @ U53R m@ke\$ T0 THE1R us3rN4me V1@ +hE AdM1N U\$3r TO0l\$.";
$lang['forum_settings_help_54'] = "uSE <b>forum ruL35</b> T0 3nT3r 4n 4ccEPT48l3 U\$3 PoLiCY +h@T 34cH U5ER muST 49r3e t0 83phOR3 Reg1sTeR1NG 0N YouR F0RUM.";
$lang['forum_settings_help_55'] = "j00 c@N u\$3 H+mL 1n YOuR ForUM ruLe5. HYP3Rl1nkS 4nD 3M4IL 4DDRE5SE\$ W1LL 4LSo 8e 4UT0M4+1c@lLy cONVERT3D tO LInkS. t0 U\$3 tHE DEF4UL+ b3EhiV3 pHOruM @UP CLE4R +3H phIeld.";
$lang['forum_settings_help_56'] = "us3 <b>n0-rePLy 3M4Il</b> +0 specIphY 4N EM@1L 4dDR3S\$ +H4+ dO3S nO+ 3Xis+ 0R WILL NoT B3 moN1t0R3d PhOr rePL1ES. +hiS 3m4iL 4dDR3Ss W1Ll 83 US3D 1N Th3 HE@d3R5 F0R 4Ll eM@Il5 \$3NT phR0m YOUR PHoRum 1NcLUDIn9 8U+ nO+ LImit3d t0 P0ST @Nd PM nO+Ific@t1Ons, u\$er 3M4IL\$ 4ND p455WorD R3MinD3rS.";
$lang['forum_settings_help_57'] = "i+ i5 R3c0mMEND3d th4+ J00 u\$e 4N EM4IL 4DDr3SS TH4+ doeS No+ EXIs+ +o H3lP CUt dOWN 0n \$P4M th@T M4y BE D1rec+3d 4t YOur M@IN ph0rUM EM41l 4ddRE5\$";
$lang['forum_settings_help_58'] = "in 4dd1t10N +o \$1MplE spId3r1nG, 83eH1ve C4N 4LS0 9EN3r4+E @ \$i+eM@p FOr +H3 F0RUM T0 M4Ke 1T E@SIer FOr \$e4RcH 3Ng1NEs +O fIND 4ND 1NDEx T3h meS\$493s Po\$t3d 8y Y0UR useRs.";
$lang['forum_settings_help_59'] = "sitem@P\$ 4RE @UTOM4T1c@lLy \$@v3d T0 +h3 s1teM4p\$ sUB-d1R3cT0rY of Your 83eH1V3 PH0RUM in\$T4LL4+1ON. 1PH tHiS d1RecTORY D03SN'T 3xIS+ J00 MU\$T cR3@+e iT 4ND EN\$uRE tH@T 1+ Is WRI+4BLE 8Y +he S3RveR / PHp PRoc3ss. To 4LlOW SE@rch 3NGINE\$ T0 FIND YOUr \$iTEm4p J00 MU\$t @DD t3H Url to YoUr rOB0T5.+xT.";
$lang['forum_settings_help_60'] = "d3pEND1NG 0N \$erV3r PERfoRM4Nce 4Nd TH3 NUmbEr OF PHORUM5 @ND +HR3@D\$ YOUR be3HIVE 1NS+aLL4+10n c0n+41Ns, g3neR4+1n9 4 \$1teM4P M4y +4K3 SeVER4L MInu+3\$ t0 COMpl3+e. 1pH PErpH0rm4nce 0pH Y0UR S3Rver 1S 4dvERS3LY 4PhPh3CT3d 1+ Is R3c0Mm3ND J00 dIS48L3 93n3r@+IOn 0F +h3 \$1TeM@P.";
$lang['forum_settings_help_61'] = "<b>s3ND 3M@1L N0+1F1c4+i0N T0 9L0b4L @DMIn</b> wHEN 3N@8L3d W1LL 5ENd 4N EM@1L +0 +H3 9l084L ForUm 0wNERs wHEN 4 n3W uSER 4Cc0uN+ iS cR34Ted.";
$lang['forum_settings_help_61'] = "en+eR y0ur <b>g0ogL3 @NAlY+1cS acc0un+ 1d</b> h3Re +0 3N@bl3 90OgLe 4N@LYtic +R4cKin9 0ph Y0UR phorUm. 9oO9Le @N@lY+icS w1Ll TR@ck VI\$1T0R\$ +O yOuR SI+3 4ND R3c0RD H0W L0nG +H3Y 5+4Y 4ND wH1Ch P@93S tH3Y v1\$1+. 8Y VI\$1T1nG +hE G009Le 4N4Ly+ic5 5I+3 y0uR c@N 5E3 4n 0V3RV13W 0F HOW YOUR PH0Rum Is U\$3d.";
$lang['forum_settings_help_62'] = "If you do not have a Google Analytics Account you will need to sign up for one by clicking <a href=\"https://www.google.com/analytics/\" target=\"_blank\">here</@ >.";
$lang['forum_settings_help_63'] = "If you do not have a Google AdSense Account you will need to sign up for one by clicking <a href=\"https://www.google.com/adsense/\" target=\"_blank\">here</4 >.";
$lang['forum_settings_help_64'] = "ipH j00 wiSH +O 3N@8Le 0R D1\$4BL3 G00gL3 4dS3Nse 4d5 oN @ P4RTICul4r pH0rUM J00 C@n D0 \$0 bY vI\$I+IN9 +H4+ ForUM's ForUM S3+tiNG\$ p4ge.";
$lang['forum_settings_help_65'] = "t0 CH4N93 G0OGL3 4d53NS3 4cC0uNT D3t@1lS 4ND OTHer S3tT1n9\$ Pl34S3 s3E GlOB@L F0RUM S3TT1n9s";
$lang['forum_settings_help_66'] = "yOuR bEEH1vE PhORuM sUpPor+\$ 2 dIPHPH3rEn+ Siz3S opH <b>go09le 4d\$3N\$3</b> 4dverT5. 3NTER tHe \$LO+ 1dS 0Ph THE R3l3v4Nt \$1z3d 4d\$ 1nt0 +eH bOx3s 48Ov3 4ND B3Eh1VE WILL @UTOm4T1c@LLY ch0o\$e +he coRRECT @D pHOR 34CH P4g3.";

// Attachments (attachments.php, get_attachment.php) ---------------------------------------

$lang['aidnotspecified'] = "a1D n0+ \$p3c1f1ED.";
$lang['upload'] = "upL04D";
$lang['uploadnewattachment'] = "uPlO@D N3W @tt@CHM3NT";
$lang['waitdotdot'] = "W4I+..";
$lang['successfullyuploaded'] = "sUCC355PHulLY upL04D3D: %s";
$lang['failedtoupload'] = "f41L3d t0 uPL04d: %s. ch3cK fre3 @Tt4Chm3nT \$PACE!";
$lang['complete'] = "comPlE+E";
$lang['uploadattachment'] = "uPl0Ad 4 PhIlE f0r @TTACHM3Nt TO +h3 m3S54G3";
$lang['enterfilenamestoupload'] = "enT3R PhIleN4m3(S) +o uPL04d";
$lang['attachmentsforthismessage'] = "a++4CHM3NTS fOR +h1s MeSs@9e";
$lang['otherattachmentsincludingpm'] = "o+h3r 4tT4ChM3NT5 (1nCLUd1N9 PM m3\$54G3s 4Nd 0+heR ph0rUM5)";
$lang['totalsize'] = "to+@l \$iZ3";
$lang['freespace'] = "fr3E \$P4CE";
$lang['attachmentproblem'] = "thErE W45 4 PR0bLEM DOWnL0@d1n9 THIS 4+t@cHM3N+. PLE@se +RY A941N L@TEr.";
$lang['attachmentshavebeendisabled'] = "aT+4cHmEnT5 HAv3 8E3n dIS4bL3D 8Y tHe pHORum 0Wn3r.";
$lang['canonlyuploadmaximum'] = "j00 C4n oNLy UPL0AD @ m4x1mUm 0PH 10 ph1L35 4+ @ tIMe";
$lang['deleteattachments'] = "dEl3+3 @TT4CHMENT\$";
$lang['deleteattachmentsconfirm'] = "aRe J00 Sur3 j00 W@n+ +o d3L3+3 tH3 SElEc+3D 4+t@cHm3Nt\$?";
$lang['deletethumbnailsconfirm'] = "arE j00 sURE J00 W@n+ To DEL3+3 +h3 S3LeC+Ed @tT@CHM3NTs tHuM8n41LS?";
$lang['failedtodeleteallselectedattachments'] = "f41LeD +0 D3LE+E 4Ll 0pH TH3 53l3ct3d @t+4cHm3NT\$";
$lang['failedtodeleteallselectedattachmentthumbnails'] = "f@Il3d t0 dEl3+3 4lL 0F +h3 SELEcT3d 4++4CHM3n+ +HUM8n41L\$";

// Changing passwords (change_pw.php) ----------------------------------

$lang['passwdchanged'] = "p@sSWord CH4N93d";
$lang['passedchangedexp'] = "yoUr P455Word H@5 b3EN ch@nG3d.";
$lang['updatefailed'] = "uPd4+3 PH@iLed";
$lang['passwdsdonotmatch'] = "p@55wORD\$ dO No+ M4+cH.";
$lang['newandoldpasswdarethesame'] = "nEW @ND old P4\$\$wORD\$ 4R3 +eh 54Me.";
$lang['requiredinformationnotfound'] = "r3qU1ReD INfoRM@t1on N0+ PhOuND";
$lang['forgotpasswd'] = "forgOt P4S\$w0RD";
$lang['resetpassword'] = "r3s3t Pas\$wORD";
$lang['resetpasswordto'] = "re\$3+ P4S5Word To";
$lang['invaliduseraccount'] = "inv@l1d Us3R 4cc0uN+ \$PECif1ED. cHeCK eM@1L pH0r C0rr3ct L1NK";
$lang['invaliduserkeyprovided'] = "iNV4L1d U\$eR K3y pR0vIDED. chECK EM41L PHOr cORrec+ LInk";

// Deleting messages (delete.php) --------------------------------------

$lang['nomessagespecifiedfordel'] = "n0 MeS\$4GE sP3c1PhIEd phOr DELE+i0N";
$lang['deletemessage'] = "deL3+E Me\$5@93";
$lang['successfullydeletedpost'] = "succE\$SPHULLy deL3t3d Po\$t %s";
$lang['errordelpost'] = "errOr DEL3T1Ng poST";
$lang['cannotdeletepostsinthisfolder'] = "j00 c4NNO+ d3LE+e p05+S IN +H1\$ foLDer";

// Editing things (edit.php, edit_poll.php) -----------------------------------------

$lang['nomessagespecifiedforedit'] = "nO m3s\$@G3 SP3c1F13d PH0r 3d1T1n9";
$lang['cannoteditpollsinlightmode'] = "c@Nnot eD1+ poLlS 1N li9h+ M0d3";
$lang['editedbyuser'] = "eD1+3D: %s 8Y %s";
$lang['successfullyeditedpost'] = "suCC3SspHuLly 3dI+Ed P0\$t %s";
$lang['errorupdatingpost'] = "eRR0r UPd4T1NG pO\$T";
$lang['editmessage'] = "ed1+ M3S\$a9E %s";
$lang['editpollwarning'] = "<b>n0t3</b>: ed1+1nG CErt@1n @Sp3CtS 0PH 4 PoLl W1LL v01d 4lL +H3 cuRREnt V0+es 4nd 4lL0W PE0pLE T0 VOte 4941n.";
$lang['hardedit'] = "hard ED1+ op+IONS (v0t3S WiLL be rESET):";
$lang['softedit'] = "sOPh+ 3D1+ 0p+10n\$ (VOTE\$ W1lL b3 re+4In3d):";
$lang['changewhenpollcloses'] = "ch4N93 wH3N TH3 P0lL clO\$3S?";
$lang['nochange'] = "no CH@n93";
$lang['emailresult'] = "em41l R3\$ulT";
$lang['msgsent'] = "m3554G3 s3NT";
$lang['msgsentsuccessfully'] = "m35s@93 S3N+ SUCcEsSpHulLY.";
$lang['mailsystemfailure'] = "ma1L sYSTEM Ph4ILUr3. meSs4g3 noT \$en+.";
$lang['nopermissiontoedit'] = "j00 Ar3 n0+ P3RMI+t3d T0 ED1t tH1S m3s\$493.";
$lang['cannoteditpostsinthisfolder'] = "j00 c4NnOT edi+ Po\$+\$ iN THIS f0LdeR";
$lang['messagewasnotfound'] = "me\$54GE %s w45 nO+ Ph0Und";

// Email (email.php) ---------------------------------------------------

$lang['sendemailtouser'] = "send 3M@1L +0 %s";
$lang['nouserspecifiedforemail'] = "n0 u53r SP3c1FI3d pHoR 3M@Il1N9.";
$lang['entersubjectformessage'] = "en+3R @ SU8J3c+ FoR +h3 M3S\$493";
$lang['entercontentformessage'] = "enT3R sOm3 COnT3N+ phOR Th3 ME55AGE";
$lang['msgsentfromby'] = "tHI\$ M3s\$4G3 w@S \$3N+ fR0m %s BY %s";
$lang['subject'] = "su8JECT";
$lang['send'] = "s3nd";
$lang['userhasoptedoutofemail'] = "%s H4s OP+3D Ou+ of EM@1L C0N+4c+";
$lang['userhasinvalidemailaddress'] = "%s h@S 4n 1NV@l1D eM@1L @DDR3Ss";

// Message nofificaiton ------------------------------------------------

$lang['msgnotification_subject'] = "mE\$54G3 Not1pHiC@T1ON frOM %s";
$lang['msgnotificationemail'] = "heLl0 %s,\n\n%s PoS+Ed 4 meSsa9e t0 J00 On %s.\n\nTHE sU8j3ct 15: %s.\n\nTO r3@D tH4+ M3s\$493 @Nd 0tHeR\$ 1N th3 S@m3 DI5cUs\$1on, Go +O:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nNo+3: 1PH J00 d0 N0+ WisH +o REc3IVE eM@1L No+1Phic@ti0N\$ of pH0rUM M3S54GE\$ po\$tEd +o yOU, 90 +0: %s cL1Ck 0N mY C0N+r0L\$ Th3n Em@1L 4Nd PR1V@cY, UN\$3L3ct TEH 3m@1L n0t1Fic4+10n Ch3Ck8OX aND Pr3S\$ SubMIt.";

// Thread Subscription notification ------------------------------------

$lang['threadsubnotification_subject'] = "sUbScriPti0N N0TiPhic4T1ON fr0m %s";
$lang['threadsubnotification'] = "hELL0 %s,\n\n%s pO\$t3d A Me5\$493 1N @ tHre4d J00 H@v3 5UB\$cRi83D To 0N %s.\n\n+H3 SUbjec+ 15: %s.\n\n+0 re@D +H4+ m3554G3 4ND o+h3R5 1N teH 54m3 d1SCusS1ON, 9o +0:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nnO+3: 1PH J00 Do NO+ WIsH +o R3CeIVE 3M4IL N0T1fIC@Ti0Ns 0PH N3w m3Ssa9E5 1n thIs +hR34d, 90 +O: %s 4nD 4djU\$T y0Ur 1nt3rEs+ LeV3L @+ +h3 8O+TOM 0ph +3H P@9E.";

// Folder Subscription notification ------------------------------------

$lang['foldersubnotification_subject'] = "subScRipT1ON no+1F1c4+10N FroM %s";
$lang['foldersubnotification'] = "heLlO %s,\n\n%s pOsT3d 4 MeSS4G3 In 4 PHolDer j00 4R3 Sub5CRIB3D T0 oN %s.\n\n+h3 \$ubj3Ct I\$: %s.\n\nT0 re4D tH@+ MeS\$4Ge @ND o+H3rS 1N The \$@ME d15cu\$\$i0n, 9O +0:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nNOte: IF j00 dO NO+ WiSh t0 REC3IV3 EM41L nO+1pH1C@+iON5 oF N3W mES\$@93S 1N +H1s +HRE4D, 9o To: %s 4ND @dJU5T Y0uR InTeReS+ l3v3L By cLicK1nG ON +H3 phOLD3R's IC0N 4t TH3 ToP 0PH P4g3.";

// PM notification -----------------------------------------------------

$lang['pmnotification_subject'] = "pm n0tIFICA+Ion pHRom %s";
$lang['pmnotification'] = "h3lL0 %s,\n\n%s p0s+ED 4 PM +0 j00 0N %s.\n\n+H3 su8j3c+ 1S: %s.\n\nTO R3@D T3H ME\$S4g3 GO +0:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nn0+e: 1PH J00 DO n0+ WISh +O R3cE1ve 3m4IL n0+1F1c4+I0N5 OF n3W Pm m3S\$493S P0Sted +0 YOu, GO +O: %s cLICK mY C0NTR0L\$ TH3n EM@1L 4nd PRiV@CY, uN\$3LEC+ +H3 Pm N0+1PHic@+ioN ch3cK8OX 4nd Pr3SS \$uBmIT.";

// Password change notification ----------------------------------------

$lang['passwdchangenotification'] = "p@s\$WOrd CH@Nge No+1F1c@TI0n phrOM %s";
$lang['pwchangeemail'] = "helL0 %s,\n\ntHIs 4 NO+1pHIC4+I0N 3M@iL t0 1NfoRM j00 +H@+ Y0UR P@S\$w0Rd ON %s H4\$ beEN ch4nGED.\n\ni+ h4s 83En cH4NgED +0: %s 4Nd wa\$ cH4Nged 8Y: %s.\n\n1PH j00 h4VE rEc3iVED +h1\$ 3M@il 1n 3rrOR 0R werE NoT 3XPEC+ing 4 CH@N93 T0 YouR P@sSWOrd PLE@se cOnT@CT +EH f0rUm 0wn3R 0R 4 m0D3r4+oR On %s 1MMED14+3Ly T0 C0RR3c+ i+.";

// Email confirmation notification -------------------------------------

$lang['emailconfirmationrequiredsubject'] = "eM@1L C0NPH1RMA+i0n REQU1R3d F0R %s";
$lang['confirmemail'] = "h3LlO %s,\n\nyOU REc3n+lY cr3@TED 4 new U5ER 4CCOun+ 0N %s.\n\nbePHore J00 c@n S+4r+ P0\$tIn9 w3 NE3d to C0NPH1RM yOUR EM41L @DDRE\$s. dOn'+ W0Rry TH15 1S Qu1Te E45y. @LL J00 nEED +o D0 1S CL1CK tH3 L1NK B3L0W (0r cOpY 4ND P@STE It 1nT0 Y0uR bR0wS3R):\n\n%s\n\noNcE C0NPhIRm4+1ON iS cOmpLEte j00 MAy L0G1N 4Nd \$t4rT p0St1n9 1mm3D14T3LY.\n\n1F j00 d1d n0t Cre@Te @ us3r 4Cc0UNt On %s PLE@\$3 4CcEPT 0uR 4PoLoG1ES 4nd PHorw4RD Th1\$ 3m41l T0 %s \$0 +H4T tHE 50uRc3 OpH i+ M4y 8e InVesTI94tED.";
$lang['confirmchangedemail'] = "hell0 %s,\n\nY0U REC3nTLY CH4NG3D Y0Ur 3M4IL 0N %s.\n\nb3PHoRe j00 C4N 5+4r+ POsT1N9 494In WE n3ED +o c0NPHirM Y0uR N3W em41L 4DDr3S\$. DOn'T WOrRY +hiS I\$ Qu1te 3@SY. @Ll j00 need +o dO Is cL1Ck T3H link 83l0w (0R c0PY @ND P4st3 1+ 1NTO y0uR bR0WSER):\n\n%s\n\n0NC3 c0NPh1rM4+1on I\$ cOMpL3+3 J00 MAy C0N+1nuE t0 u\$3 +h3 pH0RuM a\$ NOrm4L.\n\niPH j00 w3RE n0T eXPec+1Ng +H1S EM41L pHR0m %s PL34\$E 4CC3P+ 0UR 4pOLoGIE\$ @ND f0rW4RD +H1S eM@1l +O %s 50 Th4+ +3H s0URC3 0F 1+ m4y 83 1Nv3sT19@+ed.";

// Forgotten password notification -------------------------------------

$lang['forgotpwemail'] = "heLlO %s,\n\nyOU r3QU3S+3D tHi5 e-MaIl PHr0M %s b3c4U5E J00 H@ve ForGO+T3N Y0UR P4SSw0Rd.\n\ncl1cK +H3 LINK b3lOw (oR C0pY @ND P45+e 1t 1nT0 Y0ur BR0wSER) +O REs3t Y0uR P4s\$wORD:\n\n%s";

// Admin New User Approval notification -----------------------------------------

$lang['newuserapprovalsubject'] = "neW u\$3R 4PpR0V4L n0+IpH1c@t1oN F0r %s";
$lang['newuserapprovalemail'] = "Hello %s,\n\nA new user account has been created on %s.\n\nAs you are an Administrator of this forum you are required to approve this user account before it can be used by it's owner.\n\nTo approve this account please visit the Admin Users section and change the filter type to \"Users Awaiting Approval\"oR cLICK TEH LinK b3L0w:\n\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nnO+3: 0+h3r 4DM1nIs+R4+OrS 0N +hIS FoRuM W1Ll 4l\$0 REcE1V3 +hIs nO+IPh1C4T10N 4ND m4y H@V3 ALr34dY 4C+3D Up0N ThiS R3QUE5+.";

// Admin New User notification -----------------------------------------

$lang['newuserregistrationsubject'] = "n3w u53r @cc0uNt NO+ipHICATI0N PHor %s";
$lang['newuserregistrationemail'] = "h3LLo %s,\n\n4 N3W UseR @CCOUNT H@S 8eeN CR34+Ed oN %s.\n\nTo VI3W +h1s uS3R 4CC0Un+ pl34s3 V1\$1+ +EH @dMIN U\$3RS \$3cT1ON 4ND CLICK ON +H3 N3w U\$eR 0r CLICK +H3 L1nk 83loW:\n\n%s";

// User Approved notification ------------------------------------------

$lang['useraccountapprovedsubject'] = "u5eR 4PpRoV4l N0+1PH1C@+i0n pHoR %s";
$lang['useraccountapprovedemail'] = "h3Ll0 %s,\n\ny0ur User @cc0UN+ 4+ %s h4\$ 8eeN 4pProV3d. J00 C@N lOg1N 4ND 5+4rT P05+1n9 1mMeDI4+3LY 8Y Cl1CK1nG tEH L1NK b3L0W:\n\n%s\n\niPH J00 WER3 N0+ ExPECT1NG +hIs 3M@1L pHrom %s Ple@S3 accepT 0Ur @P0lo913S 4ND ph0Rw4Rd +hiS 3Mail T0 %s \$0 +H4+ +3H sOurCe oF 1+ M4Y b3 INVE\$tI9@TED.";

// Admin Post Approval notification -----------------------------------------

$lang['newpostapprovalsubject'] = "p0\$t @Ppr0v@l nOt1F1c@tI0N phOr %s";
$lang['newpostapprovalemail'] = "h3lLo %s,\n\n@ N3W p0\$+ h4s 83EN crEA+3d oN %s.\n\n45 J00 4r3 a M0DER@tOR oN +HIS pH0RUM j00 4R3 ReQu1RED +O 4PPR0VE +HiS p0\$T b3FoR3 1+ C@n 83 re4d BY O+h3R usEr5.\n\nY0U c@n @PPROv3 tH1\$ PO\$t 4Nd @NY 0+HerS PENdiNG apPR0V@l 8y V1\$1+iN9 +EH @DMIn P0\$t @pPr0v4L \$3Ct10N 0pH YOUr F0ruM oR 8Y ClIcK1N9 tEH L1nk BEl0w:\n\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nNo+E: 0THer 4DM1N15+R@T0R\$ 0n Th1\$ FOruM wILl 4l\$O r3C31V3 tHIs No+1f1C@t1on 4ND m4Y H@vE @LRE@Dy 4cTeD UpON Th1\$ REquE5+.";

// Forgotten password form.

$lang['passwdresetrequest'] = "youR p4S\$w0RD R3se+ REqu35+ PHrOM %s";
$lang['passwdresetemailsent'] = "p4sswORD ReS3t e-m41L s3nT";
$lang['passwdresetexp'] = "j00 shOuLD SHOrTlY R3cE1ve 4N 3-M@il cOn+41N1n9 INStrUCt1ON\$ PHor RES3+T1NG y0Ur P@S\$WoRd.";
$lang['validusernamerequired'] = "a v4LID u53RN@me 1\$ r3Qu1REd";
$lang['forgottenpasswd'] = "f0rGOt p4\$5WOrd";
$lang['couldnotsendpasswordreminder'] = "coUld N0T S3ND P@s\$w0RD reMINd3R. pLe453 c0N+4cT +h3 phOrum 0wN3R.";
$lang['request'] = "r3qU3S+";

// Email confirmation (confirm_email.php) ------------------------------

$lang['emailconfirmation'] = "eM41L c0NphIRM@t1on";
$lang['emailconfirmationcomplete'] = "tH4Nk j00 phOR c0NfIrMIng Y0UR 3M@1l @ddr3Ss. J00 M4y n0W Lo91N 4Nd s+4r+ PO\$+iNG IMM3DI4TElY.";
$lang['emailconfirmationfailed'] = "em4Il c0nfIRm@T1ON H4S f41LEd, Ple4S3 +RY @941N L@+eR. 1F j00 EncOuN+3r tH1s 3rR0r muLt1pL3 T1ME5 pL3@SE c0Nt4CT t3H f0rUm 0WNER 0R @ M0dEr@+0R pHOr 4\$51S+4NCE.";

// Links database (links*.php) -----------------------------------------

$lang['toplevel'] = "t0p LEVel";
$lang['maynotaccessthissection'] = "j00 M4y N0T acc3S\$ +H15 53cTI0n.";
$lang['toplevel'] = "t0P l3VeL";
$lang['links'] = "l1nkS";
$lang['externallink'] = "eXteRN4L l1nK";
$lang['viewmode'] = "v1eW mOdE";
$lang['hierarchical'] = "h1er@RCH1C@l";
$lang['list'] = "l1st";
$lang['folderhidden'] = "tH1\$ PHoldEr I5 HIdd3N";
$lang['hide'] = "h1DE";
$lang['unhide'] = "uNhID3";
$lang['nosubfolders'] = "no Su8PHOld3r\$ 1N +h1s c4+3GORY";
$lang['1subfolder'] = "1 5UbFolD3r 1n THIS c@+E9oRY";
$lang['subfoldersinthiscategory'] = "suBph0ld3Rs 1n TH1S C4+E9OrY";
$lang['linksdelexp'] = "eNtRIE5 in 4 D3L3+Ed f0LDER wIlL 83 M0VED +O +H3 P@REN+ fOLd3R. OnlY PHolDeR\$ wH1cH Do nO+ c0nT41N \$u8fOLD3r\$ M@Y 83 deL3TEd.";
$lang['listview'] = "lI\$T V1ew";
$lang['listviewcannotaddfolders'] = "c4NnO+ 4DD fold3RS iN +HIs V1eW. ShOwIn9 20 3n+rI3s 4+ 4 T1Me.";
$lang['rating'] = "r4+IN9";
$lang['nolinksinfolder'] = "no L1Nk\$ 1n tH1\$ F0LD3r.";
$lang['addlinkhere'] = "aDd l1Nk heR3";
$lang['notvalidURI'] = "th@+ iS no+ @ v4lId URi!";
$lang['mustspecifyname'] = "j00 mU5+ \$p3CIphY 4 N@M3!";
$lang['mustspecifyvalidfolder'] = "j00 muS+ \$pECIPHY @ v@l1D F0LDER!";
$lang['mustspecifyfolder'] = "j00 MU\$t 5PECiFy a PhoLd3R!";
$lang['successfullyaddedlinkname'] = "sUcc3SsfuLly @dD3d l1NK '%s'";
$lang['failedtoaddlink'] = "f4Il3D +0 @DD lInk";
$lang['failedtoaddfolder'] = "fAIl3d T0 4dD PHOLder";
$lang['addlink'] = "aDD 4 l1Nk";
$lang['addinglinkin'] = "aDd1n9 L1NK in";
$lang['addressurluri'] = "aDdREs\$";
$lang['addnewfolder'] = "aDD 4 N3W Ph0LDER";
$lang['addnewfolderunder'] = "aDdiN9 NEW ph0lD3r uNDER";
$lang['editfolder'] = "ed1+ FolD3r";
$lang['editingfolder'] = "edI+1N9 FOldeR";
$lang['mustchooserating'] = "j00 mu\$t CHo0\$E 4 Ra+In9!";
$lang['commentadded'] = "y0uR cOmm3NT W45 4DD3D.";
$lang['commentdeleted'] = "cOmM3nT W@\$ d3LeT3D.";
$lang['commentcouldnotbedeleted'] = "coMMen+ COULD N0+ Be deL3TED.";
$lang['musttypecomment'] = "j00 MU\$T tYP3 4 cOMmen+!";
$lang['mustprovidelinkID'] = "j00 MUS+ pR0vIDE 4 L1NK 1D!";
$lang['invalidlinkID'] = "iNv@L1D lInk ID!";
$lang['address'] = "addRE\$s";
$lang['submittedby'] = "sU8mi+TEd BY";
$lang['clicks'] = "cl1ck5";
$lang['rating'] = "r4+1nG";
$lang['vote'] = "vOTe";
$lang['votes'] = "voT3s";
$lang['notratedyet'] = "n0+ R4+3D BY @NYOn3 yeT";
$lang['rate'] = "r4te";
$lang['bad'] = "b4D";
$lang['good'] = "g0od";
$lang['voteexcmark'] = "v0+E!";
$lang['clearvote'] = "clEar V0T3";
$lang['commentby'] = "c0Mm3N+ by %s";
$lang['addacommentabout'] = "add 4 c0MM3Nt @bOU+";
$lang['modtools'] = "mODer4t1On +0OLS";
$lang['editname'] = "ed1+ n4M3";
$lang['editaddress'] = "eD1T 4DDR3S5";
$lang['editdescription'] = "eD1T de5crIP+i0N";
$lang['moveto'] = "moV3 +o";
$lang['linkdetails'] = "l1nK D3T@IlS";
$lang['addcomment'] = "adD COMMENt";
$lang['voterecorded'] = "y0uR V0+3 h@5 b3En R3cORD3D";
$lang['votecleared'] = "y0UR vO+3 h@s BeeN CLE4RED";
$lang['linknametoolong'] = "liNk NAME t0o LONg. M@x1muM I5 %s Ch4r4C+ERS";
$lang['linkurltoolong'] = "l1Nk URL +0O l0N9. M4x1muM Is %s CH@r@c+eRs";
$lang['linkfoldernametoolong'] = "f0LD3R n4Me +oo Long. m4xIMUM LEN9+H i\$ %s cHaR4C+3rs";

// Login / logout (llogon.php, logon.php, logout.php) -----------------------------------------

$lang['loggedinsuccessfully'] = "j00 L0993d 1N SuCce\$5phuLly.";
$lang['presscontinuetoresend'] = "pr3\$S COn+iNue T0 R3S3ND fORM D4+4 0r c@NcEL tO r3l04D P4G3.";
$lang['usernameorpasswdnotvalid'] = "tHe u53rN@me OR P4sSwOrd j00 \$UPplI3d 1S NO+ v@lID.";
$lang['youhavesuccessfullyloggedout'] = "j00 H4V3 sUcCesSfULly L0G93d 0u+.";
$lang['rememberpasswds'] = "r3MembER p4s\$wORd\$";
$lang['rememberpassword'] = "rEmEM83r P@s\$w0Rd";
$lang['logmeinautomatically'] = "lo9 mE 1N 4U+0M@tic4LLy";
$lang['enterasa'] = "en+Er @s 4 %s";
$lang['donthaveanaccount'] = "don'T h4ve 4N 4cCOUNt? %s";
$lang['registernow'] = "r3915+3R n0w";
$lang['problemsloggingon'] = "pR08LeM5 loG91Ng oN?";
$lang['deletecookies'] = "d3L3+3 C0OKiES";
$lang['cookiessuccessfullydeleted'] = "co0K13S \$ucceS\$PhUlLy d3Le+eD";
$lang['forgottenpasswd'] = "f0RgO++3N yoUR p45SwORD?";
$lang['usingaPDA'] = "us1Ng 4 pD4?";
$lang['lightHTMLversion'] = "li9hT H+mL veRS10n";
$lang['logonbutton'] = "l090N";
$lang['otherdotdotdot'] = "o+h3R...";
$lang['yoursessionhasexpired'] = "your 53\$\$1On H4\$ 3XP1R3D. j00 wiLL NE3D t0 L0G1N @g41n TO c0Nt1Nue.";

// My Forums (forums.php) ---------------------------------------------------------

$lang['myforums'] = "mY PHoRUMS";
$lang['allavailableforums'] = "all 4V@1L48Le f0rUMS";
$lang['favouriteforums'] = "f4VouRI+3 PHoRUMs";
$lang['ignoredforums'] = "ignoRED Ph0ruM\$";
$lang['ignoreforum'] = "iGnORE f0ruM";
$lang['unignoreforum'] = "uniGN0R3 phORum";
$lang['lastvisited'] = "l4\$t V1S1TED";
$lang['forumunreadmessages'] = "%s UnRe@D m3s54ge\$";
$lang['forummessages'] = "%s M3S\$@GES";
$lang['forumunreadtome'] = "%s unRE@D &quot;+0: ME&quot;";
$lang['forumnounreadmessages'] = "no Unre4D meS54G3s";
$lang['removefromfavourites'] = "reM0VE phR0M F4v0URitE\$";
$lang['addtofavourites'] = "aDd to f4V0URIte\$";
$lang['availableforums'] = "aVa1L48l3 f0RUmS";
$lang['noforumsofselectedtype'] = "tHeR3 @rE n0 f0RUMs OF +3h S3Lec+ED +YPE 4V41l@Bl3. PLe4Se S3LeC+ 4 D1fPHEReNt +yP3.";
$lang['successfullyaddedforumtofavourites'] = "sUCCE5SFULlY 4dd3d PH0rUM t0 Ph4VOUrI+3S.";
$lang['successfullyremovedforumfromfavourites'] = "sUCc3\$spHULLy ReM0VED PH0rUM phR0m f4VOURIteS.";
$lang['successfullyignoredforum'] = "suCCE\$SPhuLLY IGnorED F0ruM.";
$lang['successfullyunignoredforum'] = "suCC3S5FULLy UNI9N0R3d fORUM.";
$lang['failedtoupdateforuminterestlevel'] = "f4ilED +o UPD@T3 Ph0RuM 1NTeRE\$t L3VEL";
$lang['noforumsavailablelogin'] = "tH3re 4re n0 Ph0rum\$ 4V41l@8lE. Pl34\$3 lOG1N to V1eW YOUR Ph0RUM\$.";
$lang['passwdprotectedforum'] = "p4s5W0rD PR0t3cTEd PH0RUM";
$lang['passwdprotectedwarning'] = "tH1s PH0rUM iS P45SWord Pr0+3cT3D. t0 941N 4cC3sS enT3R TeH P4sSWOrd 8ELoW.";

// Message composition (post.php, lpost.php) --------------------------------------

$lang['postmessage'] = "po\$t M3S\$@93";
$lang['selectfolder'] = "seL3CT F0lder";
$lang['mustenterpostcontent'] = "j00 MU5T 3NTEr 5oME cOn+3Nt F0R +he Po\$t!";
$lang['messagepreview'] = "m3S\$@G3 PrevIEW";
$lang['invalidusername'] = "iNv4LID u53Rn4ME!";
$lang['mustenterthreadtitle'] = "j00 MUsT Ent3r @ +itlE FoR +H3 THr34D!";
$lang['pleaseselectfolder'] = "pL3453 s3lec+ 4 f0LDER!";
$lang['errorcreatingpost'] = "eRr0r cR34+1nG Po\$+! Pl34S3 TRy 4g41N 1N @ PHEW m1NuteS.";
$lang['createnewthread'] = "cR3@+E NEW +HR3AD";
$lang['postreply'] = "pO5+ r3PlY";
$lang['threadtitle'] = "tHre4D T1+le";
$lang['foldertitle'] = "f0LdEr T1tLe";
$lang['messagehasbeendeleted'] = "m3554G3 n0+ FouND. ch3Ck TH4T it H45n'+ b33N del3tED.";
$lang['messagenotfoundinselectedfolder'] = "me\$54g3 n0+ FoUNd 1N sEl3c+ED ph0LD3R. CHECk +H4+ 1T H4SN't 83En MOV3d 0r D3LE+ED.";
$lang['cannotpostthisthreadtypeinfolder'] = "j00 c@NNoT PO\$T th1S +Hr34D TYPe 1n TH4T FOld3R!";
$lang['cannotpostthisthreadtype'] = "j00 C4nN0+ P05+ +His +Hre4D +Yp3 4s +H3R3 AR3 No 4v41L48L3 PHold3RS Th4+ 4LLow iT.";
$lang['cannotcreatenewthreads'] = "j00 c@NNO+ CrE4TE n3w THR3@ds.";
$lang['threadisclosedforposting'] = "tHIS Thre@D 1S cLO\$Ed, j00 c@NN0+ p0St IN 1+!";
$lang['moderatorthreadclosed'] = "w@rN1N9: THi\$ +Hr3@D 15 Cl0\$3d For p0\$tIN9 tO nOrM4L UsErS.";
$lang['usersinthread'] = "u53Rs IN +hR34d";
$lang['correctedcode'] = "c0rRec+3D CODE";
$lang['submittedcode'] = "su8MITt3d c0d3";
$lang['htmlinmessage'] = "html In MeSs4ge";
$lang['disableemoticonsinmessage'] = "d1S4BLE EMo+1c0nS 1N Me554ge";
$lang['automaticallyparseurls'] = "au+0M4+1C4LlY p4Rs3 URl5";
$lang['automaticallycheckspelling'] = "aU+0M4t1calLy cH3ck \$p3LLIN9";
$lang['setthreadtohighinterest'] = "s3t THR34d +o hI9H 1Ntere5+";
$lang['enabledwithautolinebreaks'] = "eN4BL3D W1+H 4U+0-l1n3-8R3@K5";
$lang['fixhtmlexplanation'] = "th1S pH0rUM Us3S H+Ml f1lt3r1Ng. y0uR \$u8mI++3D H+ML h4\$ b33n M0D1pHIeD 8Y t3H f1LtErS In \$oME W4Y.\n\n+0 VI3w y0Ur 0r19iN4l c0dE, 53lEc+ +h3 '5UbM1T+3d cOdE' r@D1o 8U+ton.\n+o VI3W +EH M0DIFIED C0de, 53l3Ct +h3 'COrR3cTED C0D3' r4D1O 8Ut+On.";
$lang['messageoptions'] = "mE\$sA93 OPT1OnS";
$lang['notallowedembedattachmentpost'] = "j00 @r3 n0+ 4LLOW3D To eMBEd 4++4cHMENts iN YouR P0S+S.";
$lang['notallowedembedattachmentsignature'] = "j00 are N0+ 4lL0W3d +o 3m8ed @T+4cHM3NT\$ 1N Y0UR s19N4+UR3.";
$lang['reducemessagelength'] = "m3s\$4g3 LENG+h MUST be UND3R 65,535 CH4R4C+3R5 (CuRR3NTly: %s)";
$lang['reducesiglength'] = "s19n4Tur3 leNG+H mUSt b3 uNDeR 65,535 cH4R4cTER5 (CURREN+lY: %s)";
$lang['cannotcreatethreadinfolder'] = "j00 cANNo+ CrE4T3 N3W +hre4dS in tH1\$ FOLDEr";
$lang['cannotcreatepostinfolder'] = "j00 c@nNO+ r3pLy To p0\$T5 in ThI5 fOLD3r";
$lang['cannotattachfilesinfolder'] = "j00 C4NNO+ pO5+ 4+T4cHm3NT\$ 1N Th1\$ PHOlder. r3M0V3 4++4cHM3nT\$ T0 c0N+Inu3.";
$lang['postfrequencytoogreat'] = "j00 C4N onLY p0sT Once eV3RY %s 53C0NdS. pLE453 TrY 494IN L@tEr.";
$lang['emailconfirmationrequiredbeforepost'] = "em4IL cONPhiRM4+10n Is R3qU1R3D B3F0R3 j00 C@N p0ST. 1PH j00 H4ve nO+ R3ce1ved 4 C0nF1RM4+i0N 3m41L ple@S3 CLick TH3 BUt+0n 83l0w 4ND 4 NEw 0ne WILL be \$eNt +O YoU. 1f y0Ur 3m41L 4DDrE55 N33d\$ ch4nG1n9 PLe@S3 d0 \$O 8EpH0r3 ReQU3St1n9 4 n3W c0nPHIrM@TI0N 3m@iL. J00 M@y CH4N93 Y0UR 3m41L 4ddR3S\$ 8y cL1Ck MY cOnTr0lS 48OV3 4nd Th3n u53R DET4ils";
$lang['emailconfirmationfailedtosend'] = "conph1RM@+1On 3m@1L ph41L3D +0 SENd. Ple4S3 CON+4C+ +h3 fORUM owneR TO R3cT1PHY TH1S.";
$lang['emailconfirmationsent'] = "cOnf1RM4t1On EM4iL h4s 8E3N R3S3Nt.";
$lang['resendconfirmation'] = "re53Nd C0NPhiRM4+ION";
$lang['userapprovalrequiredbeforeaccess'] = "yoUR U53R @CC0Un+ N3eDs +O BE @PprOV3D by 4 pH0RUM 4DM1n 83pH0re J00 C4n 4CC3S\$ Th3 r3QUEs+3D pHORUM.";
$lang['reviewthread'] = "r3viEW Thr34D";
$lang['reviewthreadinnewwindow'] = "rEV13W EnT1R3 ThRe4d in nEW Wind0w";

// Message display (messages.php & messages.inc.php) --------------------------------------

$lang['inreplyto'] = "in R3PLY +0";
$lang['showmessages'] = "sHow M3\$\$4Ge\$";
$lang['ratemyinterest'] = "r@Te MY 1N+3R3S+";
$lang['adjtextsize'] = "aDjU\$+ TEXt \$1z3";
$lang['smaller'] = "sM@lL3R";
$lang['larger'] = "l@rg3r";
$lang['faq'] = "faQ";
$lang['docs'] = "d0C5";
$lang['support'] = "sUPp0rt";
$lang['donateexcmark'] = "d0n4+3!";
$lang['fontsizechanged'] = "f0nt S1Ze cH4nG3D. %s";
$lang['framesmustbereloaded'] = "fR4ME\$ MU\$t BE RELo4d3d m4Nu4LLY T0 S33 cH4N9e5.";
$lang['threadcouldnotbefound'] = "th3 reQU3St3D thR3@d cOULd N0+ BE FouNd 0R 4CceSs W4\$ D3n13D.";
$lang['mustselectpolloption'] = "j00 muST sEL3c+ 4N oP+1ON +0 vOt3 F0r!";
$lang['mustvoteforallgroups'] = "j00 mUST vo+3 1N EverY GRouP.";
$lang['keepreading'] = "kEEp RE4DIN9";
$lang['backtothreadlist'] = "b4Ck +O +hR34d L1S+";
$lang['postdoesnotexist'] = "tH4T p0sT D0e\$ nO+ 3xIst IN th1S thR34D!";
$lang['clicktochangevote'] = "cL1CK t0 CH@N93 V0Te";
$lang['youvotedforoption'] = "j00 V0T3D F0R 0p+10N";
$lang['youvotedforoptions'] = "j00 v0+ed f0R Op+10Ns";
$lang['clicktovote'] = "cliCk +O vo+3";
$lang['youhavenotvoted'] = "j00 h@vE No+ V0T3D";
$lang['viewresults'] = "vieW r3sUL+5";
$lang['msgtruncated'] = "m3S\$493 TRUNC@+ed";
$lang['viewfullmsg'] = "viEW pHuLL Me\$54g3";
$lang['ignoredmsg'] = "iGnOr3D mE\$5493";
$lang['wormeduser'] = "woRm3d u\$eR";
$lang['ignoredsig'] = "i9n0red 5IGN4+uRe";
$lang['messagewasdeleted'] = "m3S\$49E %s.%s w4\$ d3lE+3d";
$lang['stopignoringthisuser'] = "s+0P 19NOr1n9 +HIS uSER";
$lang['renamethread'] = "r3n@Me thr34D";
$lang['movethread'] = "moVE tHr3AD";
$lang['torenamethisthreadyoumusteditthepoll'] = "to r3N@ME +h1\$ +HR3@D J00 Mus+ eDI+ +H3 P0LL.";
$lang['closeforposting'] = "cl0\$3 PHOR p0\$+1n9";
$lang['until'] = "uN+iL 00:00 u+c";
$lang['approvalrequired'] = "aPPrOV@L rEQU1RED";
$lang['messageawaitingapprovalbymoderator'] = "m3554ge %s.%s IS 4w41Ting 4PPRov@l BY @ M0deR@toR";
$lang['successfullyapprovedpost'] = "sUcc3\$spHULlY 4PPR0v3d po\$+ %s";
$lang['postapprovalfailed'] = "poS+ 4pPR0V@l PH@iLED.";
$lang['postdoesnotrequireapproval'] = "p0\$T DO3s NO+ ReQU1RE @ppROVAL";
$lang['approvepost'] = "apPr0Ve p0st";
$lang['approvedbyuser'] = "appr0vEd: %s by %s";
$lang['makesticky'] = "m4K3 S+ICkY";
$lang['messagecountdisplay'] = "%s OpH %s";
$lang['linktothread'] = "p3rM4NENt LINk TO tH1S +hR34D";
$lang['linktopost'] = "l1Nk T0 P0\$t";
$lang['linktothispost'] = "liNk TO +HIs PoS+";
$lang['imageresized'] = "thI\$ 1m49e h4\$ b3eN R3SIz3D (0RI91N4L s1z3 %1\$\$x%2\$s). +0 view +h3 fuLL-S1zE 1M@ge CL1cK heRe.";
$lang['messagedeletedbyuser'] = "m3s\$493 %s.%s d3l3+eD %s 8Y %s";
$lang['messagedeleted'] = "mE5\$4gE %s.%s w4s d3l3+3d";
$lang['viewinframeset'] = "vi3W in FR4ME\$3+";
$lang['pressctrlentertoquicklysubmityourpost'] = "pRE5s C+RL+3NteR t0 QU1CKLY \$u8M1+ Y0UR P0\$+";
$lang['invalidmsgidornomessageidspecified'] = "inV4L1d Me5s@9e ID 0R N0 mesS4G3 1D SP3C1PHIED.";

// Moderators list (mods_list.php) -------------------------------------

$lang['cantdisplaymods'] = "c@nN0T diSPl4y pHOld3R ModER4T0RS";
$lang['moderatorlist'] = "moDEr4ToR Li5t:";
$lang['modsforfolder'] = "moDER4T0Rs F0r FolD3r";
$lang['nomodsfound'] = "n0 m0DER4T0RS fOuND";
$lang['forumleaders'] = "f0RuM L34dER5:";
$lang['foldermods'] = "foLd3R M0dER4TOr5:";

// Navigation strip (nav.php) ------------------------------------------

$lang['start'] = "s+@r+";
$lang['messages'] = "me5\$4g3S";
$lang['pminbox'] = "inb0X";
$lang['startwiththreadlist'] = "s+4R+ p@93 WITH THr34d L1st";
$lang['pmsentitems'] = "sEN+ i+3M\$";
$lang['pmoutbox'] = "oU+B0X";
$lang['pmsaveditems'] = "s@vED I+3Ms";
$lang['pmdrafts'] = "dR4Ph+5";
$lang['links'] = "l1nkS";
$lang['admin'] = "aDM1N";
$lang['login'] = "l091N";
$lang['logout'] = "l090U+";

// PM System (pm.php, pm_write.php, pm.inc.php) ------------------------

$lang['privatemessages'] = "prIV4te M3sS@93S";
$lang['recipienttiptext'] = "s3P4R@+e rEC1P13Nts 8Y \$EM1-C0LoN Or cOMM4";
$lang['maximumtenrecipientspermessage'] = "tHeR3 iS 4 liMIT 0PH 10 R3CiP13n+S PeR M3554G3. pL3@s3 4M3nd Y0uR R3c1PI3nT LiS+.";
$lang['mustspecifyrecipient'] = "j00 MU5+ sp3CifY 4+ le4St ON3 ReCIP13N+.";
$lang['usernotfound'] = "u\$3R %s No+ phOUND";
$lang['sendnewpm'] = "sEnD NEw Pm";
$lang['saveselectedmessages'] = "s4V3 S3LECt3D me\$54GE5";
$lang['deleteselectedmessages'] = "deL3TE \$eLEC+3D M3s54g3s";
$lang['exportselectedmessages'] = "eXPoR+ seL3CTEd meS\$@93\$";
$lang['nosubject'] = "n0 SuBjeCT";
$lang['norecipients'] = "n0 reC1pi3NTs";
$lang['timesent'] = "tiME \$En+";
$lang['notsent'] = "nO+ \$3nT";
$lang['errorcreatingpm'] = "eRR0R cR3@+1N9 pM! pl34\$E +rY @g4In iN a PH3W m1nUTE5";
$lang['writepm'] = "wriT3 m3554ge";
$lang['editpm'] = "edI+ ME554g3";
$lang['cannoteditpm'] = "c4nN0+ edI+ +hI\$ pM. 1T h4\$ 4lr34dY 8eEn Vi3wED bY +H3 REC1PiEn+ OR +h3 ME5S@93 d03s NO+ eXi\$+ Or IT 1\$ 1N4Cc3S518l3 8Y J00";
$lang['cannotviewpm'] = "c4Nn0t vI3W pM. ME5\$493 D03\$ N0+ 3X1\$T 0r 1T 1S in4Cce5S18L3 8Y j00";
$lang['pmmessagenumber'] = "m35\$@9E %s";

$lang['youhavexnewpm'] = "j00 h4v3 %d N3w Me5\$4GeS. W0uld j00 liKe tO 9O +0 YouR InB0x Now?";
$lang['youhave1newpm'] = "j00 h4V3 1 n3W MEsS@Ge. w0uLd J00 L1KE To g0 +0 YouR 1N8oX NoW?";
$lang['youhave1newpmand1waiting'] = "j00 h4vE 1 N3W MESs4Ge.\n\ny0u @Lso h4V3 1 mEsS@GE 4W@I+1n9 DEL1VERy. To R3c3iVe +h1s ME\$\$49E Ple4\$3 cle4R s0ME sP@c3 IN yoUR 1NB0X.\n\nw0UlD j00 LIke TO Go +o YOUR 1NBOx N0w?";
$lang['youhave1pmwaiting'] = "j00 h@VE 1 M3S\$493 @w41T1N9 deL1v3RY. T0 REceIV3 THIs m35s@93 pL3@s3 ClE@R 5oM3 5P4C3 1n Y0UR in80X.\n\nW0ULD J00 lIK3 t0 9o TO yOUR 1N8OX N0W?";
$lang['youhavexnewpmand1waiting'] = "j00 H4V3 %d nEw m3sS4G3S.\n\nyOU 4L5O H4V3 1 M3S\$@G3 @WAi+iN9 D3lIv3RY. tO r3C31ve +hi\$ m3S\$4GE Ple@s3 cL3@R soM3 5P4c3 1N y0uR 1N80X.\n\nwOUld J00 LIKE t0 9o +0 Y0uR 1NboX n0w?";
$lang['youhavexnewpmandxwaiting'] = "j00 H4V3 %d n3W Me\$549E\$.\n\ny0U 4LsO H4Ve %d M3S\$4G3S 4w4It1nG DEl1verY. T0 REC31ve Th3S3 Me\$\$@93 Ple4s3 ClE4R SOme Sp4C3 in YOUr 1nb0X.\n\nw0uLD J00 lIkE +o 90 +o yOUr 1n8Ox N0W?";
$lang['youhave1newpmandxwaiting'] = "j00 H4V3 1 NEW M3Ss@93.\n\nyOU 4L5O h4v3 %d meS\$493S @w41t1ng DeL1V3RY. +O r3C3IVE th3S3 ME5\$493s pLE@s3 cLe4R \$oM3 sP4cE 1N YoUr IN8OX.\n\nwoULD J00 L1k3 t0 9O T0 Y0UR 1NB0X NOW?";
$lang['youhavexpmwaiting'] = "j00 h4v3 %d MEsS4G3S 4w41T1N9 D3LIVerY. +0 REce1Ve TH3S3 me5S@93s pLe4se CL3@R 50mE sP4cE 1n Y0uR in80X.\n\nw0Uld J00 L1K3 T0 9o +o YOur 1N8OX NOw?";

$lang['youdonothaveenoughfreespace'] = "j00 d0 nOT H4V3 3NoU9H FR3E sp4c3 +0 5End TH1S m3SS@93.";
$lang['userhasoptedoutofpm'] = "%s h@s 0Pt3d 0U+ oF r3C31V1Ng PeRsON4L m3SS@93S";
$lang['pmfolderpruningisenabled'] = "pm Ph0lDER pruN1N9 Is eN@8L3D!";
$lang['pmpruneexplanation'] = "tHIs FOrum UsES Pm PhoLdER prUNIN9. +3H M3s\$@gE\$ J00 H4V3 S+or3D 1N y0uR IN8Ox 4ND \$3nT 1+3Ms\nPhoLdeR5 4R3 suBJEc+ +O 4u+oM4T1c D3L3+I0N. 4Ny M3SS@9E\$ j00 WIsH +o KEEP \$HOuld 8e m0v3D +o\nYOuR 'sAV3d I+3MS' pHoLDER \$0 TH@t tH3Y @RE No+ DElET3d.";
$lang['yourpmfoldersare'] = "y0UR pM PH0LD3RS 4R3 %s PhulL";
$lang['currentmessage'] = "cURRENt m3SS4GE";
$lang['unreadmessage'] = "unRE4d M3S\$49e";
$lang['readmessage'] = "r34d Me\$54GE";
$lang['pmshavebeendisabled'] = "p3rS0N@L M3sS493S h4v3 83EN dIS4bLED BY TEH FOrUM OWneR.";
$lang['adduserstofriendslist'] = "adD uS3Rs +o YOur Fr13nd\$ L15+ +O h4V3 +H3M 4Ppe4R 1n 4 dR0p D0Wn ON +h3 pm WRI+e M3S\$49E P@9e.";

$lang['messagewassuccessfullysavedtodraftsfolder'] = "me554G3 W@\$ 5UCCe5\$FuLLY 54vEd To 'DR4f+\$' Ph0LD3R";
$lang['couldnotsavemessage'] = "cOulD N0+ \$4v3 me5\$4G3. M4K3 surE J00 h4Ve ENougH @V@1LABLE FR3E Sp4C3.";
$lang['pmtooltipxmessages'] = "%s m3sS493S";
$lang['pmtooltip1message'] = "1 Me\$5@93";

$lang['allowusertosendpm'] = "aLL0W uS3R T0 \$3nd P3RSon4l ME554G3S T0 m3";
$lang['blockuserfromsendingpm'] = "bL0Ck u53r FR0m s3nd1N9 P3Rs0n4l MESs4ge\$ tO Me";
$lang['yourfoldernamefolderisempty'] = "yoUR %s FolD3r 1S 3MPTy";
$lang['successfullydeletedselectedmessages'] = "suCCE\$SPhUlLY D3lEt3D sElec+3D M3Ss@935";
$lang['successfullyarchivedselectedmessages'] = "suCc3SspHULly 4rcHiVeD SELEc+3d ME\$s49E5";
$lang['failedtodeleteselectedmessages'] = "f4il3D TO d3Let3 s3lec+3d ME5\$4g3s";
$lang['failedtoarchiveselectedmessages'] = "fa1lEd TO 4rcHIVE 5El3Cted M3554G3s";
$lang['deletemessagesconfirmation'] = "are J00 \$uRE j00 W4n+ t0 deLETe 4lL oF +he S3L3CTEd mess493S?";
$lang['youmustselectsomemessages'] = "j00 mu\$T 53lEct 5OM3 me5s@935 +0 pROC3Ss";
$lang['successfullyrenamedfolder'] = "suCC3\$SFULlY R3N@MEd FOldeR";

// Preferences / Profile (user_*.php) ---------------------------------------------

$lang['mycontrols'] = "my cON+r0L5";
$lang['myforums'] = "mY FOrum\$";
$lang['menu'] = "meNu";
$lang['userexp_1'] = "u53 +3H MEnu On THe lEPH+ +O m4N4G3 Y0UR s3++ING\$.";
$lang['userexp_2'] = "<b>usER d3+41lS</b> 4LL0W\$ j00 T0 cH@N93 Y0UR NamE, 3M4Il 4dDR3SS 4ND p4SSWord.";
$lang['userexp_3'] = "<b>uSEr pr0phILE</b> 4lLoW\$ j00 t0 3d1+ YOUR U\$3r prOF1LE.";
$lang['userexp_4'] = "<b>cH4N93 p@s\$w0RD</b> 4llOw\$ J00 +O cH@N9E Y0uR P4SswOrd";
$lang['userexp_5'] = "<b>eM41L &amp; pR1v@cY</b> LET\$ j00 Ch@Ng3 H0w J00 c4N b3 C0nT@CtED On @ND oFf +h3 F0RuM.";
$lang['userexp_6'] = "<b>f0RUM 0Pt10N\$</b> LEt5 J00 ch@N9E hOW +H3 PHoRuM lOOk\$ 4nD WOrkS.";
$lang['userexp_7'] = "<b>a++4cHm3ntS</b> 4lL0Ws J00 tO EDIT/D3LETE yoUR 4TT@CHM3nTs.";
$lang['userexp_8'] = "<b>siGN4TURE</b> l3+S j00 ed1+ Y0UR S1gN@+URE.";
$lang['userexp_9'] = "<b>reL4T1On\$H1Ps</b> Le+s J00 m4N4G3 y0uR R3L@+10N\$hIp W1+H o+HeR u\$3rS ON +H3 F0RUm.";
$lang['userexp_9'] = "<b>w0rd PHILTER</b> lEts J00 ED1T Y0UR p3Rs0nAL W0rD PhiLT3R.";
$lang['userexp_10'] = "<b>thrE@D 5UBSCRIpTi0NS</b> @LL0wS j00 +o M4N493 YouR THRE4D 5UbSCRIP+I0Ns.";
$lang['userdetails'] = "u\$eR Det41L\$";
$lang['userprofile'] = "u\$eR pR0F1L3";
$lang['emailandprivacy'] = "eM@1L & PR1V4cY";
$lang['editsignature'] = "eDIt S1GN4TURe";
$lang['norelationshipssetup'] = "j00 h4VE N0 User REL@TI0nSH1P5 \$e+ uP. 4DD 4 N3w U\$3R 8Y SE@rCHin9 beL0W.";
$lang['editwordfilter'] = "edI+ Word fIl+3r";
$lang['userinformation'] = "us3R Inf0rm@T10N";
$lang['changepassword'] = "ch4nG3 P@s\$wOrd";
$lang['currentpasswd'] = "cUrR3nT P4S\$WOrd";
$lang['newpasswd'] = "n3w P4S\$WORD";
$lang['confirmpasswd'] = "c0NPHirM P4S\$w0Rd";
$lang['currentpasswdrequired'] = "cUrReN+ p455w0RD I\$ REQu1R3D";
$lang['newpasswdrequired'] = "nEW P4SSwORD is R3Qu1R3d";
$lang['confirmpasswordrequired'] = "cONpH1rm P455WoRd I5 r3QUired";
$lang['currentpasswddoesnotmatch'] = "cUrr3N+ P4S\$wORD D035 no+ M4TCh s@V3d P@sSwORD";
$lang['nicknamerequired'] = "n1CKN4M3 IS R3QU1r3d!";
$lang['emailaddressrequired'] = "em4Il 4ddRESS 1s R3QUIReD!";
$lang['logonnotpermitted'] = "lO9on n0+ p3Rm1++3d. ch0053 @N0+H3R!";
$lang['nicknamenotpermitted'] = "nICkn4m3 N0+ P3RMi++3d. Ch0o\$3 ANo+Her!";
$lang['emailaddressnotpermitted'] = "em4IL 4Ddre55 nO+ p3rm1++ED. chO053 @n0+h3R!";
$lang['emailaddressalreadyinuse'] = "eM41L @DDreS\$ 4lr34Dy 1n u\$3. cHoO\$3 4N0TH3R!";
$lang['relationshipsupdated'] = "rEL4t10N5H1pS UPD4+3d!";
$lang['relationshipupdatefailed'] = "r3l4+IOnSH1p UPD4+ed PH41l3D!";
$lang['preferencesupdated'] = "pr3PhERencES w3RE \$ucC3S\$fUlly UPD4+3d.";
$lang['userdetails'] = "u53R DE+4iL\$";
$lang['memberno'] = "mEmb3R N0.";
$lang['firstname'] = "f1Rs+ N4ME";
$lang['lastname'] = "l4st n4m3";
$lang['dateofbirth'] = "d4+e 0F 8IRth";
$lang['homepageURL'] = "h0meP@93 URl";
$lang['profilepicturedimensions'] = "pR0PHiL3 P1c+UR3 (MaX 95X95Px)";
$lang['avatarpicturedimensions'] = "av4T4R picTuR3 (m4x 15x15Px)";
$lang['invalidattachmentid'] = "inv4Lid a++@chM3nT. CH3cK TH@+ 1\$ H4\$n'+ B3EN D3L3+Ed.";
$lang['unsupportedimagetype'] = "unsUPPOr+3D 1M@9e 4TT@CHm3n+. J00 C4n 0nLY U\$E jpG, 91f 4nD pn9 1m4g3 @T+4ChM3NT\$ FOr YOUR 4V@taR @nd pRopHiL3 p1CTURE.";
$lang['selectattachment'] = "sEl3cT @tt@cHM3Nt";
$lang['pictureURL'] = "p1CtUr3 Url";
$lang['avatarURL'] = "aV4T4R uRL";
$lang['profilepictureconflict'] = "to u53 @n @tT4ChM3N+ For y0UR PROF1lE P1cTUR3 TEh Pic+UR3 uRl PhIELD Mu\$t be bL@NK.";
$lang['avatarpictureconflict'] = "to u\$3 4n 4+T4cHM3nT Ph0R y0Ur 4V@t@R pictuR3 Th3 @V@T4R URl F13LD muST Be 8L4nK.";
$lang['attachmenttoolargeforprofilepicture'] = "s3lec+3d 4++4cHMEn+ 1\$ +Oo L@RGE pH0R PRofILE p1C+Ur3. M4X1MUM DImENSiONS @RE %s";
$lang['attachmenttoolargeforavatarpicture'] = "s3l3cTED 4Tt4CHM3Nt 1\$ +oo L@r9e PhoR @v@T@r pIcTUR3. M@x1Mum d1M3n\$1ONS 4R3 %s";
$lang['failedtoupdateuserdetails'] = "some 0r 4lL oPh yOur U\$3R @CCOUN+ DeT41lS c0ULd N0+ bE Upd4+ED. Ple4s3 tRy 4G41N L@T3R.";
$lang['failedtoupdateuserpreferences'] = "sOmE 0r 4LL 0F YOUR u53R pr3pH3r3nc3S C0ULD N0+ be UPD4+ED. Pl34SE tRY 4GA1N L4+3r.";
$lang['emailaddresschanged'] = "eM4IL 4DdReS\$ H45 83eN CH@N93D";
$lang['newconfirmationemailsuccess'] = "yOuR 3M4iL 4ddRESs H45 BeEN ch4NGeD 4ND @ nEw C0nPHIRm4+10n 3M@1L h4\$ 8Een \$3N+. PL3@s3 CH3cK @ND R34d TH3 eM41l PHOr fURTH3r 1nSTRUcT1ON\$.";
$lang['newconfirmationemailfailure'] = "j00 H@VE CH4N9Ed Y0uR em41l ADDRES5, BU+ w3 WeR3 UN4bl3 To SeND @ C0NpHIRmA+1ON reqU3sT. PLE4S3 COn+4C+ +h3 FOrum 0wNER F0r @Ss1\$+4nc3.";
$lang['forumoptions'] = "f0ruM 0P+IONs";
$lang['notifybyemail'] = "no+1PHy 8Y 3M41l 0f P0S+S +O m3";
$lang['notifyofnewpm'] = "n0+1Fy bY P0pUP 0PH N3W pM ME\$5a9E5 +O m3";
$lang['notifyofnewpmemail'] = "no+IPhy bY 3M4IL 0Ph N3W PM m3s\$@g3s +o M3";
$lang['daylightsaving'] = "aDJuS+ PHOr D@YLIgh+ \$@v1N9";
$lang['autohighinterest'] = "aU+Om4t1C@LLy M4rK Thr3@d5 1 P0\$+ 1n 4\$ H1gH 1NteRe\$+";
$lang['sortthreadlistbyfolders'] = "s0r+ +Hre@d LI\$+ By F0LDer\$";
$lang['convertimagestolinks'] = "aUTOm4+1C4LLY c0NV3Rt EmbEDD3D 1M4g3S IN p0\$+5 1nT0 lINk5";
$lang['thumbnailsforimageattachments'] = "tHUm8n41Ls fOr Im@ge 4tT4cHM3N+s";
$lang['smallsized'] = "sM@lL siZeD";
$lang['mediumsized'] = "mEDIum \$1z3d";
$lang['largesized'] = "l@rge \$1z3d";
$lang['globallyignoresigs'] = "gLO84lLY 19NOrE US3R sI9n4TuR3S";
$lang['allowpersonalmessages'] = "alloW 0+h3R U\$er\$ +O \$END mE p3RsON4L me5s@93S";
$lang['allowemails'] = "aLl0W o+H3R U53rs +0 53ND ME 3M4IL\$ VI4 MY pROf1Le";
$lang['timezonefromGMT'] = "t1mE ZOn3";
$lang['postsperpage'] = "po\$+s pEr P4g3";
$lang['fontsize'] = "foNT S1ZE";
$lang['forumstyle'] = "f0RUm 5+yl3";
$lang['forumemoticons'] = "fOruM 3mO+IcOn\$";
$lang['startpage'] = "s+4RT p49E";
$lang['signaturecontainshtmlcode'] = "si9N4TUR3 cON+4INS hTmL C0DE";
$lang['savesignatureforuseonallforums'] = "s@VE 519n4tur3 pHoR U53 ON ALL PH0RUMs";
$lang['preferredlang'] = "prEPH3RREd l@N9u4g3";
$lang['donotshowmyageordobtoothers'] = "d0 nO+ \$hoW My @93 or D4+3 0pH BIRTH +o O+HEr5";
$lang['showonlymyagetoothers'] = "sHoW 0NLY My AG3 T0 O+herS";
$lang['showmyageanddobtoothers'] = "sHOW bo+H my 4GE 4Nd DA+3 0F BIRTH +O O+H3Rs";
$lang['showonlymydayandmonthofbirthytoothers'] = "sh0W OnLy MY d@y @ND M0Nth OF BIrtH T0 0+H3RS";
$lang['listmeontheactiveusersdisplay'] = "l1s+ M3 0n +3h @Ct1V3 US3R5 d15Pl@Y";
$lang['browseanonymously'] = "brow\$3 f0RUM @n0NYM0u\$lY";
$lang['allowfriendstoseemeasonline'] = "bRow53 4NoNYMOUsLy, 8u+ @ll0w FR13nd\$ +0 sE3 m3 @5 OnLInE";
$lang['revealspoileronmouseover'] = "rEve4L \$po1Ler5 0N M0us3 0VER";
$lang['showspoilersinlightmode'] = "aLW4Y\$ 5hOw 5PoiL3Rs in l19Ht mODE (U\$3s liGHTER F0nT COlouR)";
$lang['resizeimagesandreflowpage'] = "rES1zE 1m4g3s 4ND refLOw P49E +0 pR3VENT HOR1z0N+4L \$cROLLin9.";
$lang['showforumstats'] = "sHoW F0rUm S+4+\$ @T 80tTom Oph mE55493 p4n3";
$lang['usewordfilter'] = "eNA8l3 w0rD fiL+eR.";
$lang['forceadminwordfilter'] = "fORC3 Us3 0Ph 4dMIN W0RD FIL+er On @LL U\$3rS (INC. gUes+5)";
$lang['timezone'] = "tIm3 Z0n3";
$lang['language'] = "l@ngU@GE";
$lang['emailsettings'] = "eM41L 4nd Con+4Ct S3tT1n9\$";
$lang['forumanonymity'] = "f0rUm @N0nYmi+Y S3T+in95";
$lang['birthdayanddateofbirth'] = "b1RTHD4Y 4ND D@t3 OPh b1r+H d1\$pl4y";
$lang['includeadminfilter'] = "iNClud3 @DM1N w0rD PHil+3r IN my LIs+.";
$lang['setforallforums'] = "sE+ PH0r 4LL pHORUm5?";
$lang['containsinvalidchars'] = "%s CONt41N\$ 1nV@L1d CH4r@CTERS!";
$lang['homepageurlmustincludeschema'] = "h0m3p@9e URL Mu5T 1ncLUDE h++P:// ScHEM@.";
$lang['pictureurlmustincludeschema'] = "p1cTuRE uRL MUSt INCLUD3 H+tP:// SCHEM4.";
$lang['avatarurlmustincludeschema'] = "aV4+@R URl mus+ 1NCLUDE H++p:// \$cH3M@.";
$lang['postpage'] = "pO5+ p@GE";
$lang['nohtmltoolbar'] = "no HtmL T0OLB4R";
$lang['displaysimpletoolbar'] = "d15Pl4y S1MPLE htML +oOLb@r";
$lang['displaytinymcetoolbar'] = "dISPL4y wY\$1Wy9 hTmL +oOLB@R";
$lang['displayemoticonspanel'] = "d1sPL4Y 3MOticOn\$ p4n3l";
$lang['displaysignature'] = "d1spLAy SIgn4+uR3";
$lang['disableemoticonsinpostsbydefault'] = "diS48le EM0+1COn\$ 1n ME5\$@935 BY D3PH4UL+";
$lang['automaticallyparseurlsbydefault'] = "aUTOM4T1c4lLY P4RS3 URL\$ IN me\$54G3S BY D3Ph4ulT";
$lang['postinplaintextbydefault'] = "p0S+ In pl4in +3Xt 8y deF4UlT";
$lang['postinhtmlwithautolinebreaksbydefault'] = "p05T 1N htML W1tH 4U+0-L1NE-8r3@K5 by DEF4Ul+";
$lang['postinhtmlbydefault'] = "pOSt 1N htmL bY d3Ph4uL+";
$lang['postdefaultquick'] = "u53 Quick R3Ply bY D3PH4UL+. (Full REPLy 1n M3nU)";
$lang['privatemessageoptions'] = "pRiv4TE M3Ss4g3 0P+IONs";
$lang['privatemessageexportoptions'] = "pR1vA+E m3s\$@GE ExpORt 0pTi0N\$";
$lang['savepminsentitems'] = "s@vE 4 coPY 0F 3@CH pm I \$3Nd iN MY SenT I+EMS PHOLD3R";
$lang['includepminreply'] = "incLud3 M35\$@93 8ODY wh3N R3PLyin9 tO pM";
$lang['autoprunemypmfoldersevery'] = "au+0 pRunE my pM Ph0LDERS 3V3RY:";
$lang['friendsonly'] = "fR1End\$ OnLY?";
$lang['globalstyles'] = "glob4L 5+Yl3S";
$lang['forumstyles'] = "foRUM S+Yl3s";
$lang['youmustenteryourcurrentpasswd'] = "j00 mU5t eN+3R y0uR CUrr3NT p4\$5w0rd";
$lang['youmustenteranewpasswd'] = "j00 mu5+ 3NTER 4 n3w P4\$5woRD";
$lang['youmustconfirmyournewpasswd'] = "j00 Mu5+ cONphIrM y0UR New P45SwOrd";
$lang['profileentriesmustnotincludehtml'] = "pROPHilE EntR1es MusT nO+ incLuD3 HTml";
$lang['failedtoupdateuserprofile'] = "f4iLED +0 updA+3 U\$Er pr0f1Le";

// Polls (create_poll.php, poll_results.php) ---------------------------------------------

$lang['mustprovideanswergroups'] = "j00 Mu\$t prOvIdE 50mE @n5w3R 9r0Up5";
$lang['mustprovidepolltype'] = "j00 MUs+ Pr0ViDe @ poLL +ypE";
$lang['mustprovidepollresultsdisplaytype'] = "j00 MU\$T pROvidE r3suLTs dIsPL@y tYP3";
$lang['mustprovidepollvotetype'] = "j00 Mu5t pRovIdE @ p0LL vOT3 TYP3";
$lang['mustprovidepollguestvotetype'] = "j00 mUSt \$p3cIphy 1PH 9u35+S ShOuld b3 @llOW3D TO vOTe";
$lang['mustprovidepolloptiontype'] = "j00 MuSt PRoViDE 4 PolL 0PT1ON TyP3";
$lang['mustprovidepollchangevotetype'] = "j00 muS+ pR0V1dE 4 poLL cH4Ng3 V0TE tYp3";
$lang['pollquestioncontainsinvalidhtml'] = "oNe 0R morE OPH yOuR pOlL QuEsT10Ns c0N+4iN\$ 1nV@Lid hTml.";
$lang['pleaseselectfolder'] = "pL3@s3 53lec+ 4 PhOlD3R";
$lang['mustspecifyvalues1and2'] = "j00 MU5+ sPeC1phY v@LU3S fOr 4n\$W3Rs 1 4nd 2";
$lang['tablepollmusthave2groups'] = "t48UL4r pHorM@+ P0LlS MusT H4V3 PR3Cis3Ly +W0 VoT1n9 gROUPs";
$lang['nomultivotetabulars'] = "t@Bul@R F0rM@T P0Lls c@Nn0T 83 MuLti-V0+3";
$lang['nomultivotepublic'] = "pu8l1c b4lL0+\$ C4nnO+ b3 muL+1-v0+E";
$lang['abletochangevote'] = "j00 w1Ll 83 @8LE +0 CH4n93 YOUR v0TE.";
$lang['abletovotemultiple'] = "j00 W1lL BE 48LE T0 V0+3 MUL+IPLE t1m3\$.";
$lang['notabletochangevote'] = "j00 WIlL NO+ bE A8L3 T0 CH4NG3 Y0Ur V0+3.";
$lang['pollvotesrandom'] = "no+3: poLL vO+3S 4R3 r4NDOmlY 93n3r4t3d PH0R Pr3vIew 0nLY.";
$lang['pollquestion'] = "pOll QUes+10n";
$lang['possibleanswers'] = "pOs518l3 4N\$w3Rs";
$lang['enterpollquestionexp'] = "eN+eR +H3 4NSW3RS pH0R Y0UR poLl QUEs+1oN.. If YOUR pOLL IS 4 &quot;y3S/No&quot; QueS+I0N, s1mPLY 3n+eR &quot;Y3S&quot; pHOR 4n\$w3R 1 @nD &quot;N0&quot; PhOr 4Nsw3r 2.";
$lang['numberanswers'] = "n0. @n\$w3Rs";
$lang['answerscontainHTML'] = "an\$weR\$ cOn+4iN H+mL (no+ 1NcLUD1N9 \$1gnA+URE)";
$lang['optionsdisplay'] = "aNsw3R5 DI\$PL4y TYPe";
$lang['optionsdisplayexp'] = "hoW 5H0ULD +eh 4n5W3r\$ 8e pR353N+ED?";
$lang['dropdown'] = "a\$ DroP-D0WN lIs+(S)";
$lang['radios'] = "as 4 s3R1Es 0F R4D10 BUT+0Ns";
$lang['votechanging'] = "v0+e ch4NGIng";
$lang['votechangingexp'] = "c4n 4 PERsoN Ch4Nge HIs 0r H3r vO+E?";
$lang['guestvoting'] = "gu3S+ V0tiNg";
$lang['guestvotingexp'] = "c4N GuE\$+S vo+3 IN +HI\$ P0LL?";
$lang['allowmultiplevotes'] = "aLL0W mUL+iPle voT3S";
$lang['pollresults'] = "p0LL R3SuL+S";
$lang['pollresultsexp'] = "h0W woUld j00 L1KE T0 D1SPL4Y +3h RE\$UL+\$ Of Y0uR P0LL?";
$lang['pollvotetype'] = "p0lL V0+1N9 tyP3";
$lang['pollvotesexp'] = "hoW shOuld TEH p0lL B3 CONdUCTED?";
$lang['pollvoteanon'] = "anOnyM0U\$lY";
$lang['pollvotepub'] = "pUbL1c 84lLo+";
$lang['horizgraph'] = "h0riZ0N+4L GR4Ph";
$lang['vertgraph'] = "ver+1C@l Gr4PH";
$lang['tablegraph'] = "t@8UL@R F0rMA+";
$lang['polltypewarning'] = "<b>w4rNIn9</b>: TH1\$ 1S 4 Pu8lIc B@Ll0T. Y0UR n4M3 wIlL 83 VI5IBLE nex+ T0 Teh OP+iON J00 v0+e fOr.";
$lang['expiration'] = "exP1R4+IOn";
$lang['showresultswhileopen'] = "dO J00 W4NT t0 \$how REsuL+S WHILE TH3 P0LL Is OPEN?";
$lang['whenlikepollclose'] = "wHEn W0uLD j00 liKe Y0Ur P0LL t0 4UtoM4+IcalLY cL0\$e?";
$lang['oneday'] = "one d4y";
$lang['threedays'] = "thr33 D@y5";
$lang['sevendays'] = "s3veN d4Y5";
$lang['thirtydays'] = "tH1rtY d@yS";
$lang['never'] = "n3vEr";
$lang['polladditionalmessage'] = "adDITIoN@L Me\$5493 (0P+1on@l)";
$lang['polladditionalmessageexp'] = "d0 j00 w@nT t0 iNCLUD3 @n 4dd1T1ON4L P0\$t 4PHt3R tH3 PolL?";
$lang['mustspecifypolltoview'] = "j00 MUs+ SP3c1FY 4 P0LL +O V13W.";
$lang['pollconfirmclose'] = "ar3 j00 SuRe j00 W4NT t0 Cl0\$e +h3 pH0llOW1N9 p0ll?";
$lang['endpoll'] = "eND POll";
$lang['nobodyvotedclosedpoll'] = "n08OdY Vot3d";
$lang['votedisplayopenpoll'] = "%s 4ND %s H4V3 V0+3d.";
$lang['votedisplayclosedpoll'] = "%s @nd %s V0TED.";
$lang['nousersvoted'] = "no uS3RS";
$lang['oneuservoted'] = "1 u\$eR";
$lang['xusersvoted'] = "%s U\$3Rs";
$lang['noguestsvoted'] = "n0 9u3s+\$";
$lang['oneguestvoted'] = "1 9u3s+";
$lang['xguestsvoted'] = "%s GUE5Ts";
$lang['pollhasended'] = "p0Ll H4S 3ND3d";
$lang['youvotedforpolloptionsondate'] = "j00 V0+3D FoR %s 0n %s";
$lang['thisisapoll'] = "tH1\$ 1S 4 POLl. ClICK tO V1EW r3sul+\$.";
$lang['editpoll'] = "edIT P0LL";
$lang['results'] = "re\$ULT5";
$lang['resultdetails'] = "r35uL+ deT@1L\$";
$lang['changevote'] = "ch@n9e V0tE";
$lang['pollshavebeendisabled'] = "p0lLS h4v3 83EN DIs@bl3D By th3 PhOrum OWN3R.";
$lang['answertext'] = "aN\$wer +3xt";
$lang['answergroup'] = "answER 9RouP";
$lang['previewvotingform'] = "pr3vi3w vOt1N9 fOrM";
$lang['viewbypolloption'] = "v13w 8y pOll 0p+1ON";
$lang['viewbyuser'] = "viEw bY US3R";

// Profiles (profile.php) ----------------------------------------------

$lang['editprofile'] = "ed1+ PR0f1LE";
$lang['profileupdated'] = "pR0pHIL3 upD@+3D.";
$lang['profilesnotsetup'] = "th3 F0Rum 0wneR h@S N0+ \$3+ uP ProFiLES.";
$lang['ignoreduser'] = "i9nOr3D u\$Er";
$lang['lastvisit'] = "l4sT V1S1+";
$lang['userslocaltime'] = "u\$ER's L0cAL +1m3";
$lang['userstatus'] = "s+4TU5";
$lang['useractive'] = "onLInE";
$lang['userinactive'] = "in4cTiV3 / 0FfLiNE";
$lang['totaltimeinforum'] = "t0t4L tIM3";
$lang['longesttimeinforum'] = "lON93s+ 5E\$51on";
$lang['sendemail'] = "send 3M@Il";
$lang['sendpm'] = "sEnD PM";
$lang['visithomepage'] = "visI+ hoM3P49e";
$lang['age'] = "ag3";
$lang['aged'] = "a9eD";
$lang['birthday'] = "biR+Hd4Y";
$lang['registered'] = "r391\$+eR3d";
$lang['findpostsmadebyuser'] = "f1nD pO5+\$ M4d3 8y %s";
$lang['findpostsmadebyme'] = "find PO\$TS M@DE 8Y Me";
$lang['findthreadsstartedbyuser'] = "f1nD +Hr3@Ds \$t4r+3d 8Y %s";
$lang['findthreadsstartedbyme'] = "f1nd +hR34D5 5+4Rt3d BY M3";
$lang['profilenotavailable'] = "pROPhIl3 No+ 4V@1L4bLE.";
$lang['userprofileempty'] = "tHI\$ U\$3R H@S nO+ PhiLLED in THE1R PR0PhilE 0r IT 1\$ 5E+ +O PRIV4T3.";

// Registration (register.php) -----------------------------------------

$lang['newuserregistrationsarenotpermitted'] = "s0rRY, New US3R REG1S+r4+10N\$ 4R3 N0+ 4LL0WED r1GhT Now. Pl34\$3 cH3cK b@ck l4+er.";
$lang['usernametooshort'] = "u53Rn4ME mU5+ 83 4 M1N1MUM 0F 2 CH@R4CTER\$ lONg";
$lang['usernametoolong'] = "u\$ERN@M3 MuS+ b3 4 M4X1MUM 0F 15 Ch@R@CT3rS LON9";
$lang['usernamerequired'] = "a l0gON N4M3 1\$ rEQU1R3d";
$lang['passwdmustnotcontainHTML'] = "p455W0RD MUs+ N0T cOn+AIN hTmL t4g5";
$lang['passwdtooshort'] = "p@sSW0RD MUs+ 83 @ M1nIMuM 0PH 6 ch@R4CT3RS LoN9";
$lang['passwdrequired'] = "a P@\$SWorD is Requ1red";
$lang['confirmationpasswdrequired'] = "a ConPh1Rm@t1ON p@S\$W0RD 1S R3qU1R3D";
$lang['nicknamerequired'] = "a n1cKn4ME iS rEQU1R3d";
$lang['emailrequired'] = "aN eM@IL 4DDREs\$ 1s r3QUir3d";
$lang['passwdsdonotmatch'] = "pA5SWoRdS D0 NO+ M4tcH";
$lang['usernamesameaspasswd'] = "u\$3rN@mE 4ND P4\$\$w0Rd MU\$t be diPHphEreNt";
$lang['usernameexists'] = "sOrrY, 4 u\$3r WI+H +H4+ N4M3 4lR34Dy 3X1s+S";
$lang['successfullycreateduseraccount'] = "sUcceSSPhuLLy CrE4+3D UseR 4cCouN+";
$lang['useraccountcreatedconfirmfailed'] = "yoUR U53r @ccOUN+ H4S 83En cre4+eD BuT TH3 Requ1R3d c0NPH1RM4T1oN EM@IL W45 NO+ \$3N+. Pl3@S3 ConT4c+ +3H f0rum OWn3R tO R3cT1fY tHI5. In +hIs M3@NT1me PLE45e CL1cK +hE c0n+INUE BUtT0N +o L0gIN.";
$lang['useraccountcreatedconfirmsuccess'] = "yoUR uS3R 4cCouNt h4\$ b3EN CRE@teD BUT bePh0R3 j00 c4N \$t4rT PO\$+InG j00 MUs+ CoNf1rM y0Ur eM4IL 4DDRE55. Ple4sE CH3cK Y0Ur 3m41L F0R 4 LiNK TH@T W1Ll @ll0w J00 +O c0NpH1rM Y0UR @dDR3S5.";
$lang['useraccountcreated'] = "yOur usEr 4cc0uN+ H4\$ 8een CrE4+eD 5uCc3S\$pHULLY! clICk +3H coNtINu3 BUTT0N 83l0w +O lo91N";
$lang['errorcreatinguserrecord'] = "erR0r cr34+1nG U5ER ReC0RD";
$lang['userregistration'] = "u\$3R REg1\$tR4t10N";
$lang['registrationinformationrequired'] = "r391\$+R4t1oN inPhorm4+10N (reQu1r3D)";
$lang['profileinformationoptional'] = "pR0PHIL3 1NPH0RM4T10N (0pT1ON4L)";
$lang['preferencesoptional'] = "pREf3R3NC3S (OP+10N4l)";
$lang['register'] = "r3g1s+eR";
$lang['rememberpasswd'] = "r3mEm8Er p4SSWOrd";
$lang['birthdayrequired'] = "d@Te oPH Bir+H 15 reQU1R3d Or iS iNVALid";
$lang['alwaysnotifymeofrepliestome'] = "noTIphY ON rePLY tO ME";
$lang['notifyonnewprivatemessage'] = "n0t1Fy oN N3W prIv4+3 M3S5493";
$lang['popuponnewprivatemessage'] = "p0p up On N3W PRiV4+3 Mes\$49E";
$lang['automatichighinterestonpost'] = "aU+0maTic H19h 1N+3R3ST ON PoS+";
$lang['confirmpassword'] = "c0npHiRm p@S\$wORD";
$lang['invalidemailaddressformat'] = "iNV4L1D EMaIl 4DdRE55 pHoRm@+";
$lang['moreoptionsavailable'] = "m0RE PrOF1lE 4ND PREfeR3nce 0P+I0N5 4R3 aV4IL48L3 0nc3 j00 R391S+3R";
$lang['textcaptchaconfirmation'] = "c0nPHirM4T1ON";
$lang['textcaptchaexplain'] = "t0 pREVEN+ 4UTOM4T3D RE91STR4T1ONs TH1S PhORUM REQU1R3S J00 3nt3r 4 c0nPHIRM@T1On Code. t3H cod3 iS diSPL4Y3D 1N +h3 1M@93 j00 T0 THE r1Gh+. 1F J00 4R3 V1SU4LLY iMp@ired or c4nNo+ O+H3RW1\$3 Re@D t3h cOD3 PLE@SE COn+4c+ +h3 %s.";
$lang['textcaptchaimgtip'] = "tH15 i\$ 4 C4PtCH4-picTUR3. 1+ 1S uS3d To pR3VENt 4U+OM4+1c R3GIS+r4+10N";
$lang['textcaptchamissingkey'] = "a coNPhiRM4+10n c0d3 1\$ r3qUIR3d.";
$lang['textcaptchaverificationfailed'] = "t3xT-c4P+Ch4 v3R1FIC4+10N C0De W4S INCOrr3ct. PL3@se R3-3NTEr 1t.";
$lang['forumrules'] = "f0RUm RULE5";
$lang['forumrulesnotification'] = "in ORD3R +O Pr0CEED, J00 MUS+ 4gR3e W1+H +H3 FOll0wIn9 RUleS";
$lang['forumrulescheckbox'] = "i h4Ve R3@D, 4ND 4GR3e +0 481dE 8Y T3H PHOrUm ruleS.";
$lang['youmustagreetotheforumrules'] = "j00 MUST 4GR3e T0 +3H Ph0rUM Rul3s bEpHorE j00 c4n cOn+iNuE.";

// Recent visitors list  (visitor_log.php) -----------------------------

$lang['member'] = "m3m8eR";
$lang['searchforusernotinlist'] = "s3@rCH fOR 4 USER nO+ 1N L1\$+";
$lang['yoursearchdidnotreturnanymatches'] = "youR 53@RcH D1d N0+ RETUrn 4Ny M@TCH3S. +RY 51mPl1PHY1n9 YOUR s3@Rch P4R4M3tER\$ 4nd TRy @941N.";
$lang['hiderowswithemptyornullvalues'] = "hId3 R0W\$ W1TH 3MPTy oR NuLl V4lU3S iN s3LEctEd C0LuMNS";
$lang['showregisteredusersonly'] = "sHoW reg1st3REd U53r5 0nLy (h1d3 9UE\$+\$)";

// Relationships (user_rel.php) ----------------------------------------

$lang['relationships'] = "reL4TION\$hIPs";
$lang['userrelationship'] = "u\$ER r3l4+ioNShip";
$lang['userrelationships'] = "usEr REL4T1ON\$HIPs";
$lang['failedtoremoveselectedrelationships'] = "f4IlEd +o R3MOv3 s3lEc+3D R3LA+1On5hiP";
$lang['friends'] = "fr1EnD\$";
$lang['ignoredcompletely'] = "iGNorED COmpleT3LY";
$lang['relationship'] = "rEL@+10N\$H1p";
$lang['restorenickname'] = "re5+Or3 uSER's nICKN4M3";
$lang['friend_exp'] = "u53R'\$ P0ST5 M4RKEd W1+H @ &quot;fR13nd&quot; 1c0N.";
$lang['normal_exp'] = "u\$er'5 P05+\$ 4PP34r 4\$ nOrm@l.";
$lang['ignore_exp'] = "us3R'S pO\$+\$ 4Re hidd3n.";
$lang['ignore_completely_exp'] = "thR34DS 4ND po\$+\$ TO Or phR0m UseR W1Ll 4pPe@r deLE+ED.";
$lang['display'] = "dI\$pL4Y";
$lang['displaysig_exp'] = "u\$3R'S \$19N4TUR3 1\$ d1sPL4YeD ON +h31r P0\$t\$.";
$lang['hidesig_exp'] = "u\$3R's \$19N4+URE iS Hidd3N oN Th3IR po\$+5.";
$lang['youcannotchangeuserrelationshipforownaccount'] = "j00 C4NNO+ ch4nG3 Us3r R3l@TioN\$h1P F0R y0ur OWN uS3r 4cc0Un+";
$lang['cannotignoremod'] = "j00 C4NNo+ 19nORE tH1\$ uS3r, @s +H3Y 4RE @ MOD3R@ToR.";
$lang['previewsignature'] = "pr3VI3W s19N4+UR3";

// Search (search.php) -------------------------------------------------

$lang['searchresults'] = "s3@RCH r3suL+s";
$lang['usernamenotfound'] = "tEH US3RN@me J00 \$P3c1pHI3D 1N +3H tO Or PHRom f1ELD W4\$ NOt FoUND.";
$lang['notexttosearchfor'] = "on3 0R 4LL oF Y0UR sE@RCH K3yWOrd\$ w3re 1Nv4lid. s3@rcH K3YW0RD\$ MU\$T 8E n0 5HoR+3r th4N %d cH@R@Ct3rS, N0 Lon93r TH4N %d cH4R4cTERs 4nD Mus+ NO+ 4pPE4R 1N +hE %s";
$lang['keywordscontainingerrors'] = "kEyw0RDS coNT41niN9 3RR0R\$: %s";
$lang['mysqlstopwordlist'] = "mY\$ql 5+0PW0Rd liS+";
$lang['foundzeromatches'] = "fouNd: 0 M4+cH3S";
$lang['found'] = "fOUND";
$lang['matches'] = "m4+cHES";
$lang['prevpage'] = "pReVIoUS p493";
$lang['findmore'] = "fiND mORe";
$lang['searchmessages'] = "s3@rch m3s\$@93S";
$lang['searchdiscussions'] = "sE4rCH diSCUs\$1onS";
$lang['find'] = "fInd";
$lang['additionalcriteria'] = "adD1+i0n4l CRI+3R14";
$lang['searchbyuser'] = "se4RCH by U\$3R (0p+1ON@l)";
$lang['folderbrackets_s'] = "f0LD3R(S)";
$lang['postedfrom'] = "posT3D PHR0m";
$lang['postedto'] = "p0s+3d +0";
$lang['today'] = "t0d@Y";
$lang['yesterday'] = "ye5T3rD@Y";
$lang['daybeforeyesterday'] = "d@Y b3PH0R3 YE\$Terd4y";
$lang['weekago'] = "%s WEEK @g0";
$lang['weeksago'] = "%s W3eks 49o";
$lang['monthago'] = "%s M0NTh 4gO";
$lang['monthsago'] = "%s m0n+H\$ 49O";
$lang['yearago'] = "%s ye4R @9o";
$lang['beginningoftime'] = "be91NNIN9 OF +1me";
$lang['now'] = "noW";
$lang['lastpostdate'] = "l4\$T PO5+ d4+3";
$lang['numberofreplies'] = "nUm83R 0Ph REpLI35";
$lang['foldername'] = "f0ld3r N@m3";
$lang['authorname'] = "aU+H0R N@M3";
$lang['relevancy'] = "rEl3v4nCy";
$lang['decendingorder'] = "n3w3S+ f1rS+";
$lang['ascendingorder'] = "oLD3\$+ f1Rs+";
$lang['keywords'] = "kEyw0RD5";
$lang['sortby'] = "s0RT 8Y";
$lang['sortdir'] = "s0R+ d1R";
$lang['sortresults'] = "s0rT Re\$Ult5";
$lang['groupbythread'] = "grOUP bY THrE4D";
$lang['postsfromuser'] = "po\$tS FrOM U\$3R";
$lang['threadsstartedbyuser'] = "tHre@d5 5+4rt3d bY UsER";
$lang['searchfrequencyerror'] = "j00 c@n 0NLY 5E4RCH 0NcE EV3RY %s s3CoNDS. pLe@\$e +Ry 4G41n L4TER.";
$lang['searchsuccessfullycompleted'] = "sEARCH SuCc3S\$FUlLy C0mPL3+Ed. %s";
$lang['clickheretoviewresults'] = "cl1Ck h3R3 +0 VIEW reSuLt\$.";

// Search Popup (search_popup.php) -------------------------------------

$lang['select'] = "sElecT";
$lang['currentselection'] = "cUrr3NT 53Lec+Ion";
$lang['addtoselection'] = "adD TO SelecT10N";
$lang['searchforthread'] = "sE4RcH PH0r +Hre4d";
$lang['mustspecifytypeofsearch'] = "j00 muSt sP3C1FY +YPE 0pH s3@rcH +o PeRPh0RM";
$lang['unkownsearchtypespecified'] = "uNkn0Wn se4RcH TYP3 sp3C1pHIed";
$lang['maximumselectionoftenlimitreached'] = "m4xIMuM \$eL3cT1On l1M1t Of 10 H4\$ b3eN Re@ch3D";

// Start page (start_left.php) -----------------------------------------

$lang['recentthreads'] = "reC3nT thR3AdS";
$lang['startreading'] = "s+4R+ r3@d1N9";
$lang['threadoptions'] = "thRe4D oPTIonS";
$lang['editthreadoptions'] = "ed1t Thre4d OPT10N\$";
$lang['morevisitors'] = "mORe vI5I+Or\$";
$lang['forthcomingbirthdays'] = "fOrtHC0mIn9 BiRtHd4Y5";

// Start page (start_main.php) -----------------------------------------

$lang['editstartpage_help'] = "j00 C4N eD1+ +hI\$ P4G3 fRoM T3H 4DM1N 1N+3Rf4CE";

// Thread navigation (thread_list.php) ---------------------------------

$lang['newdiscussion'] = "n3w DisCUss1ON";
$lang['createpoll'] = "cR34+E poLL";
$lang['search'] = "sE@RCh";
$lang['searchagain'] = "s3@rcH 4G41N";
$lang['alldiscussions'] = "aLl d1SCU\$51ONs";
$lang['unreaddiscussions'] = "unr3@d dI5cUsS1ONs";
$lang['unreadtome'] = "unr34d &quot;tO: me&quot;";
$lang['todaysdiscussions'] = "tOd@Y'S d1\$Cu\$\$1OnS";
$lang['2daysback'] = "2 DayS b4cK";
$lang['7daysback'] = "7 D@yS B4cK";
$lang['highinterest'] = "h1Gh 1n+3RE5+";
$lang['unreadhighinterest'] = "uNRe4d H1gH 1N+3re5+";
$lang['iverecentlyseen'] = "i'Ve r3C3n+LY s3en";
$lang['iveignored'] = "i'v3 i9N0reD";
$lang['byignoredusers'] = "by iGNor3D U\$3Rs";
$lang['ivesubscribedto'] = "i'vE \$Ub\$CrI83d To";
$lang['startedbyfriend'] = "s+4R+ed BY Fr13Nd";
$lang['unreadstartedbyfriend'] = "unRe4d 5TD 8y fRI3ND";
$lang['startedbyme'] = "sT4rT3D BY me";
$lang['unreadtoday'] = "uNr34D +od4Y";
$lang['deletedthreads'] = "dElETED +hr34D5";
$lang['goexcmark'] = "g0!";
$lang['folderinterest'] = "fOLD3r INTEr3s+";
$lang['postnew'] = "p0sT N3W";
$lang['currentthread'] = "cUrRENT +HRE4d";
$lang['highinterest'] = "h19h INTEr3sT";
$lang['markasread'] = "m@Rk 45 re@d";
$lang['next50discussions'] = "n3X+ 50 d1\$CuS51ON5";
$lang['visiblediscussions'] = "v1\$i8l3 dIscU5510N\$";
$lang['selectedfolder'] = "sEleC+ED PhOlDER";
$lang['navigate'] = "n4V194t3";
$lang['couldnotretrievefolderinformation'] = "th3RE 4RE NO PHoLD3RS 4V41L@8l3.";
$lang['nomessagesinthiscategory'] = "nO Me5\$@93s in THIS caTEgOrY. PLe453 S3LEc+ 4no+HER, Or %s pHor 4lL THR34dS";
$lang['clickhere'] = "clICK heRe";
$lang['prev50threads'] = "pR3V1OU\$ 50 tHRE@D\$";
$lang['next50threads'] = "nExT 50 +hre@dS";
$lang['nextxthreads'] = "nexT %s tHR34dS";
$lang['threadstartedbytooltip'] = "thRE@d #%s \$t@RT3D 8Y %s. V1Ewed %s";
$lang['threadviewedonetime'] = "1 +1m3";
$lang['threadviewedtimes'] = "%d +1M35";
$lang['readthread'] = "rE4D THR3@D";
$lang['unreadmessages'] = "unRE@D MES\$@93S";
$lang['subscribed'] = "su8SCR1b3d";
$lang['stickythreads'] = "s+ICKY +hR3@Ds";
$lang['mostunreadposts'] = "mOSt UNR3@D P0\$+S";
$lang['onenew'] = "%d N3W";
$lang['manynew'] = "%d N3W";
$lang['onenewoflength'] = "%d neW 0F %d";
$lang['manynewoflength'] = "%d NEW OPH %d";
$lang['confirmmarkasread'] = "ar3 J00 SUr3 J00 w4Nt T0 M4rK +H3 \$el3ct3D +HR3@D5 4\$ r34D?";
$lang['successfullymarkreadselectedthreads'] = "sUCC3S\$fULLY m4rK3d 53Lect3D THR3@d5 4\$ R3@D";
$lang['failedtomarkselectedthreadsasread'] = "f@1LED to M4RK S3L3C+Ed +HR34D\$ 4\$ r3@d";
$lang['gotofirstpostinthread'] = "go +o Ph1rs+ POST 1N ThR3@d";
$lang['gotolastpostinthread'] = "gO TO l@St P05t 1n THR34d";
$lang['viewmessagesinthisfolderonly'] = "vIEw mEs5@93S in +HIs F0ldER 0NlY";
$lang['shownext50threads'] = "show n3xt 50 THre4d\$";
$lang['showprev50threads'] = "sH0w PREVi0u\$ 50 +HR3@D5";
$lang['createnewdiscussioninthisfolder'] = "cr34T3 N3W D15CuSSIon IN Th1\$ fOLdeR";
$lang['nomessages'] = "n0 mES\$4GES";

// HTML toolbar (htmltools.inc.php) ------------------------------------
$lang['bold'] = "b0ld";
$lang['italic'] = "iT4liC";
$lang['underline'] = "uNDerL1NE";
$lang['strikethrough'] = "sTRiKeTHr0u9h";
$lang['superscript'] = "sUPeR\$crIpt";
$lang['subscript'] = "sUBScrIP+";
$lang['leftalign'] = "lEpHT-@liGN";
$lang['center'] = "c3NT3r";
$lang['rightalign'] = "r1ght-4L1GN";
$lang['numberedlist'] = "nuM83RED l1sT";
$lang['list'] = "l1\$t";
$lang['indenttext'] = "inDen+ t3x+";
$lang['code'] = "coD3";
$lang['quote'] = "quote";
$lang['unquote'] = "uNqUO+3";
$lang['spoiler'] = "sp0ILer";
$lang['horizontalrule'] = "horIz0nT4l RUle";
$lang['image'] = "iM4g3";
$lang['hyperlink'] = "hYp3rLINK";
$lang['noemoticons'] = "dI\$48L3 em0+IC0Ns";
$lang['fontface'] = "f0Nt PH4cE";
$lang['size'] = "s1ZE";
$lang['colour'] = "c0l0UR";
$lang['red'] = "r3D";
$lang['orange'] = "oRAnGe";
$lang['yellow'] = "y3llOW";
$lang['green'] = "gR3En";
$lang['blue'] = "blue";
$lang['indigo'] = "indIGo";
$lang['violet'] = "v1Ol3T";
$lang['white'] = "whIte";
$lang['black'] = "bL4cK";
$lang['grey'] = "grEY";
$lang['pink'] = "piNK";
$lang['lightgreen'] = "l1GH+ 9r3eN";
$lang['lightblue'] = "li9H+ blu3";

// Forum Stats --------------------------------

$lang['forumstats'] = "f0rUM \$+4+5";
$lang['userstats'] = "us3R S+4+\$";

$lang['usersactiveinthepasttimeperiod'] = "%s @c+1vE 1N +eh P@s+ %s.";

$lang['numactiveguests'] = "<b>%s</b> GuES+\$";
$lang['oneactiveguest'] = "<b>1</b> 9u3S+";
$lang['numactivemembers'] = "<b>%s</b> m3m83Rs";
$lang['oneactivemember'] = "<b>1</b> MEm83R";
$lang['numactiveanonymousmembers'] = "<b>%s</b> 4NonYmOU\$ m3m83Rs";
$lang['oneactiveanonymousmember'] = "<b>1</b> @n0NYMouS M3M83R";

$lang['numthreadscreated'] = "<b>%s</b> +hRE@D5";
$lang['onethreadcreated'] = "<b>1</b> tHRE4D";
$lang['numpostscreated'] = "<b>%s</b> p0STs";
$lang['onepostcreated'] = "<b>1</b> P0\$+";

$lang['younormal'] = "j00";
$lang['youinvisible'] = "j00 (inV151bL3)";
$lang['viewcompletelist'] = "v13w COmpL3TE LISt";
$lang['ourmembershavemadeatotalofnumthreadsandnumposts'] = "ouR m3M8eRs H4V3 M@d3 4 t0+4l 0pH %s @Nd %s.";
$lang['longestthreadisthreadnamewithnumposts'] = "l0n9e\$T thR34D 1s <b>%s</b> w1tH %s.";
$lang['therehavebeenxpostsmadeinthelastsixtyminutes'] = "tHerE H4VE 83EN <b>%s</b> p05+\$ m@d3 IN TeH L45+ 60 M1NUTE5.";
$lang['therehasbeenonepostmadeinthelastsixtyminutes'] = "tH3Re h@S beeN <b>1</b> POs+ M4d3 1N +H3 L4\$+ 60 M1NUTe\$.";
$lang['mostpostsevermadeinasinglesixtyminuteperiodwasnumposts'] = "mosT P0\$T5 3vER M4D3 1n 4 \$1ngLE 60 M1NUT3 P3RI0D IS <b>%s</b> 0N %s.";
$lang['wehavenumregisteredmembersandthenewestmemberismembername'] = "w3 H@VE <b>%s</b> re91S+ER3D M3M83R5 @ND +h3 N3W3\$+ M3M83r 1s <b>%s</b>.";
$lang['wehavenumregisteredmember'] = "we H4V3 %s R3G1\$t3Red MEM83r\$.";
$lang['wehaveoneregisteredmember'] = "w3 h4V3 0N3 R391St3red M3MB3r.";
$lang['mostuserseveronlinewasnumondate'] = "m0\$+ User\$ 3VeR OnLiNE w4s <b>%s</b> oN %s.";
$lang['statsdisplaychanged'] = "sT4Ts d1\$PL4Y ch4Ng3d";

$lang['viewtop20'] = "v1eW +0p 20";

$lang['folderstats'] = "foLD3R S+4t5";
$lang['threadstats'] = "tHRe4D 5T4T5";
$lang['poststats'] = "p0\$+ STatS";
$lang['pollstats'] = "p0Ll S+4tS";
$lang['attachmentsstats'] = "aT+4cHm3nTS \$+4T5";
$lang['userpreferencesstats'] = "u\$3R preF3R3nc3S \$t4+\$";
$lang['visitorstats'] = "vi5ITor 5+4t5";
$lang['sessionstats'] = "s3s5IOn S+4T5";
$lang['profilestats'] = "prOfiL3 5t4+\$";
$lang['signaturestats'] = "si9N4+URE S+a+\$";
$lang['ageandbirthdaystats'] = "ag3 4Nd 81RthD4Y \$T4+\$";
$lang['relationshipstats'] = "rElATI0NsH1P S+4+\$";
$lang['wordfilterstats'] = "w0RD pHiLter 5+4t5";

$lang['numberoffolders'] = "nUmbeR Of PHolDER5";
$lang['folderwithmostthreads'] = "f0LDer W1+H mOS+ thR34d5";
$lang['folderwithmostposts'] = "fold3R w1+h Mo\$t Po\$T5";
$lang['totalnumberofthreads'] = "t0t4L nuM83r Of +hR3@D5";
$lang['longestthread'] = "loN9Es+ +hre4d";
$lang['mostreadthread'] = "mos+ r34d THr34D";
$lang['threadviews'] = "vIeWS";
$lang['averagethreadcountperfolder'] = "aV3R49E THr34D CouN+ peR F0LD3R";
$lang['totalnumberofthreadsubscriptions'] = "t0T4L Num8er 0Ph THre4D \$ub\$crIpTi0Ns";
$lang['mostpopularthreadbysubscription'] = "m0sT POpul4R +hRe@D BY sU85CriP+I0N";
$lang['totalnumberofposts'] = "toT4L nuMB3r 0pH P0\$t\$";
$lang['numberofpostsmadeinlastsixtyminutes'] = "num8eR 0f pO\$+S m@d3 iN L@S+ 60 M1NUT3S";
$lang['mostpostsmadeinasinglesixtyminuteperiod'] = "mo5T Po5t\$ m@D3 1n On3 60 M1NuT3 peR10d";
$lang['averagepostsperuser'] = "aVeR@g3 p05T\$ P3R U53r";
$lang['topposter'] = "t0p Po\$TeR";
$lang['totalnumberofpolls'] = "tOT4l Num83R OpH PollS";
$lang['totalnumberofpolloptions'] = "t0t4l nUM83R OF pOLl 0ptI0n\$";
$lang['averagevotesperpoll'] = "aVEr49E Vo+3S P3R PolL";
$lang['totalnumberofpollvotes'] = "t0T4l nUmBER 0PH p0ll V0T3S";
$lang['totalnumberofattachments'] = "t0+4L nUM83r 0pH 4+tacHM3NTs";
$lang['averagenumberofattachmentsperpost'] = "avEr49E 4T+4ChM3nT c0Unt PER po5+";
$lang['mostdownloadedattachment'] = "m0s+ DOWnl04D3d @Tt4cHM3N+";
$lang['mostusedforumstyle'] = "m0\$+ u\$3D f0RuM S+YlE";
$lang['mostusedlanguuagefile'] = "mo\$T USed L4NGU4G3 F1Le";
$lang['mostusedtimezone'] = "mO\$+ USED +1me Z0NE";
$lang['mostusedemoticonpack'] = "m05t U\$ed 3M0+Ic0N p4CK";

$lang['numberofusers'] = "nuM83R 0F u\$3Rs";
$lang['newestuser'] = "n3we\$+ U\$3r";
$lang['numberofcontributingusers'] = "numb3r 0Ph c0n+r18uTiN9 Us3R\$";
$lang['numberofnoncontributingusers'] = "nUMbeR Of NOn-c0N+r18U+In9 UsErS";
$lang['subscribers'] = "su8ScRi83Rs";

$lang['numberofvisitorstoday'] = "nUm83r 0F v1sI+0Rs TOd4Y";
$lang['numberofvisitorsthisweek'] = "nuM83R 0F VI51t0r\$ TH1s wEEK";
$lang['numberofvisitorsthismonth'] = "nUm8eR OpH v1s1+0r5 +H15 MON+h";
$lang['numberofvisitorsthisyear'] = "nUm83r 0f Vis1+ORs +H1S ye4r";

$lang['totalnumberofactiveusers'] = "tO+4L NUmB3R oF 4cTIve u\$3r\$";
$lang['numberofactiveregisteredusers'] = "nuM8Er OPh 4C+1ve R391sT3red U53rS";
$lang['numberofactiveguests'] = "nuM83r Oph 4c+IVE gU3s+s";
$lang['mostuserseveronline'] = "mOs+ u\$3rs eV3R oNLINe";
$lang['mostactiveuser'] = "m05T @CT1vE U\$3R";
$lang['numberofuserswithprofile'] = "numb3R 0ph US3R5 W1+H prOF1LE";
$lang['numberofuserswithoutprofile'] = "numBer OF uSER\$ WI+HoU+ Pr0File";
$lang['numberofuserswithsignature'] = "nuM83R 0F US3RS w1th 519N4tUrE";
$lang['numberofuserswithoutsignature'] = "nuM8ER OF Us3Rs W1+H0uT \$1gN@+ure";
$lang['averageage'] = "aVeR4g3 4g3";
$lang['mostpopularbirthday'] = "mo5+ p0PuL4R 8IR+hD@Y";
$lang['nobirthdaydataavailable'] = "nO BIRThD4Y D4T4 4VAIL4BLE";
$lang['numberofusersusingwordfilter'] = "num8Er Of US3RS u\$1n9 wORD PhIL+Er";
$lang['numberofuserreleationships'] = "nUM83r 0pH Us3r R3L4T10nSh1Ps";
$lang['averageage'] = "aV3RAg3 @93";
$lang['averagerelationshipsperuser'] = "avEr@93 reL@tiON5H1PS P3r usER";

$lang['numberofusersnotusingwordfilter'] = "nuMBER 0F USER\$ NO+ u\$1n9 w0Rd F1LTEr";
$lang['averagewordfilterentriesperuser'] = "aV3R@93 W0RD PhiL+Er ENTR1ES p3R uS3R";

$lang['mostuserseveronlinedetail'] = "%s oN %s";

// Thread Options (thread_options.php) ---------------------------------

$lang['updatessavedsuccessfully'] = "upd4T3S S4VeD 5ucce55pHUllY";
$lang['useroptions'] = "u\$Er 0P+1onS";
$lang['markedasread'] = "maRK3D a\$ r34d";
$lang['postsoutof'] = "posTS Ou+ Oph";
$lang['interest'] = "inT3RES+";
$lang['closedforposting'] = "cLoS3d PhOR P05t1N9";
$lang['locktitleandfolder'] = "l0Ck +1+LE 4Nd pH0Ld3R";
$lang['deletepostsinthreadbyuser'] = "d3l3+3 P0\$+5 IN +HRE@d 8Y Us3R";
$lang['deletethread'] = "d3L3+3 thR3@d";
$lang['permenantlydelete'] = "p3RM4N3NTLY d3Le+E";
$lang['movetodeleteditems'] = "m0Ve +0 DEleTed tHrE4D\$";
$lang['undeletethread'] = "uNd3leT3 +HR34D";
$lang['markasunread'] = "m@Rk 45 UNre4D";
$lang['makethreadsticky'] = "m4K3 tHR34d sT1cKY";
$lang['threareadstatusupdated'] = "tHrE@D r3@D s+4tu5 UpD4+eD suCc3s\$phULLy";
$lang['interestupdated'] = "thRe4D iN+ERE5+ s+4+us uPD@ted \$UCC3S\$fULly";
$lang['threadwassuccessfullydeleted'] = "tHr34D w45 5UCC3S\$FULly dELE+ED";
$lang['threadwassuccessfullyundeleted'] = "tHr34D w4\$ SUCCE\$\$fuLly UND3LE+3D";
$lang['failedtoupdatethreadreadstatus'] = "f@1L3D T0 UPD4+3 +HrE@d R34d S+4Tu5";
$lang['failedtoupdatethreadinterest'] = "f4Iled +O uPD4+E thR34d INT3R3S+";
$lang['failedtorenamethread'] = "f4ILEd tO r3N@me +hr34d";
$lang['failedtomovethread'] = "f41l3D T0 M0V3 tHR34d T0 5PEc1FIED fOldER";
$lang['failedtoupdatethreadstickystatus'] = "f41LED +0 UPd@T3 Thr34d \$+1ckY \$T4TU5";
$lang['failedtoupdatethreadclosedstatus'] = "f4IlED +0 UPD4TE +Hr3AD CL0SED \$T4+U\$";
$lang['failedtoupdatethreadlockstatus'] = "fAiLED +o Upd@Te +Hr34d L0cK S+4Tu5";
$lang['failedtodeletepostsbyuser'] = "f41L3D +0 DELET3 p0\$T5 bY SELEC+3d U53r";
$lang['failedtodeletethread'] = "f@1lEd +0 DeL3+3 tHr34D.";
$lang['failedtoundeletethread'] = "f@1L3D t0 uN-DEL3TE tHR3@D";

// Folder Options (folder_options.php) ---------------------------------

$lang['folderoptions'] = "fOLDER oP+1on\$";
$lang['foldercouldnotbefound'] = "tEh R3QueS+ED pHoLDER cOuLD NoT b3 PH0uND 0R 4CCES\$ W4\$ D3nIED.";
$lang['failedtoupdatefolderinterest'] = "f41Led T0 Upd4+e pH0LD3R inTER3S+";

// Dictionary (dictionary.php) -----------------------------------------

$lang['dictionary'] = "d1CTI0N4RY";
$lang['spellcheck'] = "sPeLL CHeck";
$lang['notindictionary'] = "n0t 1n d1c+iON@RY";
$lang['changeto'] = "cH@n93 t0";
$lang['restartspellcheck'] = "rE\$t@R+";
$lang['cancelchanges'] = "c@NcEL CH4nge\$";
$lang['initialisingdotdotdot'] = "iNi+I4Li51N9...";
$lang['spellcheckcomplete'] = "sP3ll CHECk I\$ cOmPLETE. +O r3s+4R+ \$PeLl cHECK CL1Ck re5+4Rt BUT+oN bELOW.";
$lang['spellcheck'] = "sP3Ll cHeCK";
$lang['noformobj'] = "no PhORm 08J3c+ \$PEc1PH13d FoR RETurN +3xt";
$lang['ignore'] = "i9NorE";
$lang['ignoreall'] = "i9NoR3 4ll";
$lang['change'] = "ch@n93";
$lang['changeall'] = "cH4nG3 @LL";
$lang['add'] = "aDd";
$lang['suggest'] = "suGGEst";
$lang['nosuggestions'] = "(no \$u9G3S+10N\$)";
$lang['cancel'] = "c4nceL";
$lang['dictionarynotinstalled'] = "nO dIcTI0N4RY h4s B3En 1NS+4LL3d. pLE4\$3 CONt@Ct +H3 F0rUm 0wN3R +O R3M3dy +H1S.";

// Permissions keys ----------------------------------------------------

$lang['postreadingallowed'] = "p0s+ Re4DIn9 4llOW3d";
$lang['postcreationallowed'] = "p0\$T cR3@Ti0N 4LLoW3D";
$lang['threadcreationallowed'] = "tHre4d CR34ti0n 4LL0W3d";
$lang['posteditingallowed'] = "p05+ ed1T1N9 @LloW3d";
$lang['postdeletionallowed'] = "p0\$+ d3L3+Ion 4lLoW3d";
$lang['attachmentsallowed'] = "uPlO@d1NG 4t+4chM3NtS 4lLow3d";
$lang['htmlpostingallowed'] = "hTmL P05+1N9 @ll0WeD";
$lang['usersignatureallowed'] = "u53r S1Gn4+ure @lL0wEd";
$lang['guestaccessallowed'] = "gU3s+ 4CcESS 4LlOw3D";
$lang['postapprovalrequired'] = "poS+ 4ppR0v@L reQUIR3d";

// RSS feeds gubbins

$lang['rssfeed'] = "rS\$ F3ED";
$lang['every30mins'] = "eV3Ry 30 m1NUtES";
$lang['onceanhour'] = "oNc3 4n hOur";
$lang['every6hours'] = "eV3rY 6 H0URS";
$lang['every12hours'] = "evEry 12 h0UrS";
$lang['onceaday'] = "oNc3 4 d4Y";
$lang['onceaweek'] = "onCE @ WeEK";
$lang['rssfeeds'] = "rs5 FEED5";
$lang['feedname'] = "f3ED n4M3";
$lang['feedfoldername'] = "fe3d phOLDEr n@ME";
$lang['feedlocation'] = "f33d l0C4+10n";
$lang['threadtitleprefix'] = "thR34d ti+L3 PreF1x";
$lang['feednameandlocation'] = "f3ed N4m3 4nD l0c4t1on";
$lang['feedsettings'] = "f3eD \$Et+1n95";
$lang['updatefrequency'] = "uPD@tE FREqu3ncY";
$lang['rssclicktoreadarticle'] = "clIcK H3R3 T0 RE4D Th1S @R+ICLE";
$lang['addnewfeed'] = "aDd N3w fe3d";
$lang['editfeed'] = "ed1+ F3ED";
$lang['feeduseraccount'] = "f3ed U\$3R @ccOun+";
$lang['noexistingfeeds'] = "n0 EXiS+IN9 R5s FEED\$ found. To 4dd 4 Phe3d CL1Ck +3H '@dd N3w' BU++oN BEL0W";
$lang['rssfeedhelp'] = "hER3 J00 c4N SetuP \$OM3 R5S ph3Ed5 pHOR 4U+OM4TIC prOP4G4+10N In+O Your PH0rUM. +hE 1tEM5 PhROM The R\$5 pHe3dS J00 4dd w1LL B3 cR34+eD @s +hR34d5 wHicH USER5 c@N R3Ply +0 4\$ 1F THEY W3RE NoRM@L pO5+S. teH R\$\$ FE3d MUSt b3 4cceSs18L3 V1@ H+tp OR i+ WILl N0+ wOrK.";
$lang['mustspecifyrssfeedname'] = "mu5T 5PeC1pHy R5S F33d N4M3";
$lang['mustspecifyrssfeeduseraccount'] = "mu\$+ 5P3C1pHy RS\$ f3ed USEr 4ccOUN+";
$lang['mustspecifyrssfeedfolder'] = "mu\$+ \$P3C1PHY rS5 pH3eD Fold3R";
$lang['mustspecifyrssfeedurl'] = "mu\$+ 5p3cIPHY RS5 F3Ed urL";
$lang['mustspecifyrssfeedupdatefrequency'] = "mUsT 5p3c1Fy R55 Phe3d uPD@TE Fr3QUENCY";
$lang['unknownrssuseraccount'] = "unKnOwn Rs\$ Us3r @Cc0UNT";
$lang['rssfeedsupportshttpurlsonly'] = "rSs F3ed 5uPp0RTs H++P URLs 0Nly. 53CUR3 ph33dS (hTTP5://) @RE NO+ \$upPOR+3D.";
$lang['rssfeedurlformatinvalid'] = "r\$\$ PHEED URL F0RM@T 15 INV4LID. URL Mu5+ InclUDe SCH3M3 (3.g. HTTP://) 4ND @ H0\$TnAMe (e.9. Www.h0S+N4mE.com).";
$lang['rssfeeduserauthentication'] = "rSS PH33d dOES nOT SuPpORT hT+P u53R @UTHen+iC@T1ON";
$lang['successfullyremovedselectedfeeds'] = "suCces\$pHUllY REm0V3D seLEC+3D F33dS";
$lang['successfullyaddedfeed'] = "sUcc3SsPhUllY 4DdED NEW f3ed";
$lang['successfullyeditedfeed'] = "sUccE\$5fulLy eD1TeD F3ED";
$lang['failedtoremovefeeds'] = "f@1l3D +0 REMoV3 s0ME or 4lL 0F THE S3LEc+3D F3ED5";
$lang['failedtoaddnewrssfeed'] = "fAiLeD T0 @dd n3w Rss f3eD";
$lang['failedtoupdaterssfeed'] = "fa1L3d t0 uPD4+3 rs\$ Fe3D";
$lang['rssstreamworkingcorrectly'] = "rs\$ \$+rE@M 4PP34RS tO 8e WoRkIN9 C0RR3C+ly";
$lang['rssstreamnotworkingcorrectly'] = "r5\$ s+R34m W4S EMp+Y or C0Uld N0+ 8E F0UNd";
$lang['invalidfeedidorfeednotfound'] = "iNV4LID ph3Ed ID Or PH3ed No+ PHouNd";

// PM Export Options

$lang['pmexportastype'] = "eXp0r+ 4S +yPE";
$lang['pmexporthtml'] = "h+Ml";
$lang['pmexportxml'] = "xMl";
$lang['pmexportplaintext'] = "pL@1N +3X+";
$lang['pmexportmessagesas'] = "eXpOR+ m3sS4GES 4\$";
$lang['pmexportonefileforallmessages'] = "on3 PHIle pH0R @ll m3sS4geS";
$lang['pmexportonefilepermessage'] = "oNE F1L3 p3R me5\$@93";
$lang['pmexportattachments'] = "expor+ 4++4cHm3n+5";
$lang['pmexportincludestyle'] = "inCLUdE f0ruM s+YLE sheeT";
$lang['pmexportwordfilter'] = "apPLY w0rD F1Lter +0 meSS@G3s";
$lang['failedtoexportmessages'] = "f4IL3D +O 3XpoR+ m3SS4G3S";

// Thread merge / split options

$lang['threadhasbeensplit'] = "thR34D H4S 83EN \$Pl1T";
$lang['threadhasbeenmerged'] = "thR34d H4\$ B3eN MEr93D";
$lang['mergesplitthread'] = "merGE / SplI+ +Hr34d";
$lang['mergewiththreadid'] = "mEr93 w1th +Hre@d 1d:";
$lang['postsinthisthreadatstart'] = "pO5+s In Th1S tHR3@d @T 5+4R+";
$lang['postsinthisthreadatend'] = "pO\$T5 in +hiS THr3@d @T END";
$lang['reorderpostsintodateorder'] = "r3-OrD3r pO5+5 1N+0 D@Te ORDER";
$lang['splitthreadatpost'] = "spLiT +hReAD 4+ P05+:";
$lang['selectedpostsandrepliesonly'] = "s3lecTED P0\$t 4ND rePL1ES Only";
$lang['selectedandallfollowingposts'] = "s3l3C+3D 4ND @LL f0Ll0WIn9 poS+s";

$lang['threadmovedhere'] = "h3r3";

$lang['thisthreadhasmoved'] = "<b>tHre@D5 m3r9eD:</b> +Hi\$ +HR3aD h4S MoV3d %s";
$lang['thisthreadwasmergedfrom'] = "<b>tHrE4d\$ M3R93D:</b> +h1s +HR3@D w45 m3Rged pHROm %s";
$lang['somepostsinthisthreadhavebeenmoved'] = "<b>thr34d \$pl1t:</b> SOMe P05+\$ iN +h1S +Hr3@d H@V3 BeeN moV3d %s";
$lang['somepostsinthisthreadweremovedfrom'] = "<b>thr34D spL1T:</b> \$oM3 P05+\$ 1N thIS +hr3@D W3R3 MOv3D pHR0M %s";

$lang['thisposthasbeenmoved'] = "<b>thrE4D 5PLi+:</b> +H1S pO\$T H4\$ 8e3N M0Ved %s";

$lang['invalidfunctionarguments'] = "iNV4l1d PHUNCt1oN @r9Um3nTS";
$lang['couldnotretrieveforumdata'] = "couLd NOt RE+RieVE f0ruM D4T4";
$lang['cannotmergepolls'] = "on3 0R mORE ThR34Ds IS 4 POll. J00 c@NN0+ m3rgE PolLS";
$lang['couldnotretrievethreaddatamerge'] = "coULD no+ r3+rIEV3 thR34D d4t@ FrOm ON3 Or mOR3 thRE4D\$";
$lang['couldnotretrievethreaddatasplit'] = "cOuld n0+ R3TrieV3 thrE4d D4T4 FROM S0URc3 +hreAD";
$lang['couldnotretrievepostdatamerge'] = "coUld NoT R3+ri3V3 P0\$+ D4t4 FR0M 0ne or MOre THRE4D\$";
$lang['couldnotretrievepostdatasplit'] = "cOULD n0+ RETR13Ve poS+ d@T4 FR0M SouRce ThrE4d";
$lang['failedtocreatenewthreadformerge'] = "f4IlEd +O crE@+e N3W thR34D F0r mEr93";
$lang['failedtocreatenewthreadforsplit'] = "fAil3d +o cR34+3 n3W +hR34D For \$pLIT";
$lang['nopermissiontomergethreads'] = "j00 @r3 n0+ P3RMI+T3d T0 meR93 tH3 sEL3c+3d THR3@D\$";

// Thread subscriptions

$lang['threadsubscriptions'] = "tHRe@D 5ub\$cRIp+I0nS";
$lang['couldnotupdateinterestonthread'] = "coULD N0+ uPD4+e 1NTere5t on +hre4d '%s'";
$lang['threadinterestsupdatedsuccessfully'] = "thr34D iNteRE\$+\$ UPD4+3D \$UcCe\$5pHuLLy";
$lang['nothreadsubscriptions'] = "j00 4R3 n0+ \$ub\$CrI83d +o @NY +hrE@D\$.";
$lang['nothreadsignored'] = "j00 @R3 nO+ iGN0R1N9 4nY thR34d5.";
$lang['nothreadsonhighinterest'] = "j00 H4Ve NO H19H INteRE5+ +HR34D\$.";
$lang['resetselected'] = "re\$3+ sEl3cTED";
$lang['ignoredthreads'] = "igN0RED THr34d\$";
$lang['highinterestthreads'] = "h1gh 1NTEre\$t ThR3@D\$";
$lang['subscribedthreads'] = "sUBscrI83d +Hr3@d5";
$lang['currentinterest'] = "cUrREN+ INTERe\$+";

// Folder subscriptions

$lang['foldersubscriptions'] = "f0ldER \$u8SCRiP+10NS";
$lang['couldnotupdateinterestonfolder'] = "c0UlD N0+ UPD4+E 1NT3R3S+ ON FoLd3R '%s'";
$lang['folderinterestsupdatedsuccessfully'] = "fold3R INteR3ST5 UPD4T3D sUcc3S\$PHULLy";
$lang['nofoldersubscriptions'] = "j00 4r3 n0t \$uBSCrI83d +0 4NY pHOLDER\$.";
$lang['nofoldersignored'] = "j00 4R3 n0+ IgN0R1NG @ny FOld3RS.";
$lang['resetselected'] = "r3\$3+ \$3Lect3d";
$lang['ignoredfolders'] = "i9n0Red FOlderS";
$lang['subscribedfolders'] = "su8\$cr1bEd PHolDERS";

// Browseable user profiles

$lang['youcanonlyaddthreecolumns'] = "j00 C@n ONlY 4DD 3 c0LUMN\$. +0 @dD 4 neW ColUmN cL0\$3 4n 3xi\$+1N9 ONe";
$lang['columnalreadyadded'] = "j00 h4V3 4lR3@DY 4DD3D Thi5 ColuMN. 1f J00 W4N+ tO reM0VE 1+ cLICk 1+s CLO\$e bU+tON";

?>