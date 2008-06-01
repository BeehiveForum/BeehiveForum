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

/* $Id: x-hacker.inc.php,v 1.282 2008-06-01 15:24:15 decoyduck Exp $ */

// British English language file

// Language character set and text direction options -------------------

$lang['_isocode'] = "en-gb";
$lang['_textdir'] = "ltr";

// Months --------------------------------------------------------------

$lang['month'][1]  = "janU4Ry";
$lang['month'][2]  = "fe8Ru4rY";
$lang['month'][3]  = "m4RcH";
$lang['month'][4]  = "aPR1l";
$lang['month'][5]  = "m@y";
$lang['month'][6]  = "jUN3";
$lang['month'][7]  = "juLY";
$lang['month'][8]  = "au9u5t";
$lang['month'][9]  = "sEP+eMb3r";
$lang['month'][10] = "oc+0BER";
$lang['month'][11] = "n0vEMb3r";
$lang['month'][12] = "d3C3m83R";

$lang['month_short'][1]  = "j4n";
$lang['month_short'][2]  = "feB";
$lang['month_short'][3]  = "m4r";
$lang['month_short'][4]  = "aPR";
$lang['month_short'][5]  = "m4y";
$lang['month_short'][6]  = "jun";
$lang['month_short'][7]  = "jUL";
$lang['month_short'][8]  = "aUg";
$lang['month_short'][9]  = "s3p";
$lang['month_short'][10] = "oCt";
$lang['month_short'][11] = "n0V";
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
$lang['date_periods']['month']  = "%s MON+h";
$lang['date_periods']['week']   = "%s w3ek";
$lang['date_periods']['day']    = "%s D4y";
$lang['date_periods']['hour']   = "%s HoUr";
$lang['date_periods']['minute'] = "%s mInUt3";
$lang['date_periods']['second'] = "%s 5econd";

// As above but plurals (2 years vs. 1 year, etc.)

$lang['date_periods_plural']['year']   = "%s YE4r\$";
$lang['date_periods_plural']['month']  = "%s moNtH\$";
$lang['date_periods_plural']['week']   = "%s WEeks";
$lang['date_periods_plural']['day']    = "%s d@YS";
$lang['date_periods_plural']['hour']   = "%s hOUR\$";
$lang['date_periods_plural']['minute'] = "%s M1NU+e\$";
$lang['date_periods_plural']['second'] = "%s S3c0nD5";

// Short hand periods (example: 1y, 2m, 3w, 4d, 5hr, 6min, 7sec)

$lang['date_periods_short']['year']   = "%sy";    // 1y
$lang['date_periods_short']['month']  = "%sm";    // 2m
$lang['date_periods_short']['week']   = "%sw";    // 3w
$lang['date_periods_short']['day']    = "%sD";    // 4d
$lang['date_periods_short']['hour']   = "%shR";   // 5hr
$lang['date_periods_short']['minute'] = "%sm1N";  // 6min
$lang['date_periods_short']['second'] = "%sSEC";  // 7sec

// Common words --------------------------------------------------------

$lang['percent'] = "p3RcEnt";
$lang['average'] = "aVeR49e";
$lang['approve'] = "aPpROVe";
$lang['banned'] = "b@nnEd";
$lang['locked'] = "l0Ck3D";
$lang['add'] = "adD";
$lang['advanced'] = "aDv@nC3D";
$lang['active'] = "aC+1V3";
$lang['style'] = "sTYL3";
$lang['go'] = "go";
$lang['folder'] = "f0lDER";
$lang['ignoredfolder'] = "i9N0ReD ph0Ld3r";
$lang['folders'] = "folDErs";
$lang['thread'] = "thR3@d";
$lang['threads'] = "thR3@dS";
$lang['threadlist'] = "tHrE4D LiST";
$lang['message'] = "meSs4g3";
$lang['from'] = "fR0M";
$lang['to'] = "to";
$lang['all_caps'] = "alL";
$lang['of'] = "oF";
$lang['reply'] = "r3PlY";
$lang['forward'] = "f0rW4Rd";
$lang['replyall'] = "r3pLY t0 4ll";
$lang['quickreply'] = "qU1CK rEPly";
$lang['quickreplyall'] = "qu1CK rEPlY +O 4ll";
$lang['pm_reply'] = "rEpLY 4S Pm";
$lang['delete'] = "d3l3TE";
$lang['deleted'] = "dEl3tEd";
$lang['edit'] = "eDi+";
$lang['privileges'] = "pRIVil3G3\$";
$lang['ignore'] = "i9n0R3";
$lang['normal'] = "n0RM4L";
$lang['interested'] = "iNTeR3sT3D";
$lang['subscribe'] = "sU85cR183";
$lang['apply'] = "aPpLy";
$lang['download'] = "d0wnL04D";
$lang['save'] = "s@V3";
$lang['update'] = "upd@+3";
$lang['cancel'] = "c@nCeL";
$lang['continue'] = "conT1nu3";
$lang['attachment'] = "at+4chM3N+";
$lang['attachments'] = "att4ChmENt\$";
$lang['imageattachments'] = "im@93 @+t4cHM3n+s";
$lang['filename'] = "f1LEn4Me";
$lang['dimensions'] = "dIMEn510N5";
$lang['downloadedxtimes'] = "d0wNl04D3D: %d +ImeS";
$lang['downloadedonetime'] = "dOWNlO4D3D: 1 T1ME";
$lang['size'] = "s1z3";
$lang['viewmessage'] = "v13w Me\$s493";
$lang['deletethumbnails'] = "dElE+3 +HuMBn41Ls";
$lang['logon'] = "l0G0N";
$lang['more'] = "m0R3";
$lang['recentvisitors'] = "r3c3n+ vIs1toRS";
$lang['username'] = "u\$eRN4ME";
$lang['clear'] = "cL3@r";
$lang['reset'] = "rE53t";
$lang['action'] = "ac+I0n";
$lang['unknown'] = "unkNown";
$lang['none'] = "nOn3";
$lang['preview'] = "preV13w";
$lang['post'] = "po\$+";
$lang['posts'] = "p0st5";
$lang['change'] = "cH4n9E";
$lang['yes'] = "yES";
$lang['no'] = "no";
$lang['signature'] = "s1GN4TurE";
$lang['signaturepreview'] = "s19NA+UR3 pr3viEw";
$lang['signatureupdated'] = "s1GN4TUrE upD4T3D";
$lang['signatureupdatedforallforums'] = "siGn@TuRE UPD@TEd PhoR 4LL PH0RUms";
$lang['back'] = "b4CK";
$lang['subject'] = "sUBJeCT";
$lang['close'] = "clo\$3";
$lang['name'] = "n4m3";
$lang['description'] = "d35cRipT10n";
$lang['date'] = "d@TE";
$lang['view'] = "vieW";
$lang['enterpasswd'] = "en+3r p4SSw0rD";
$lang['passwd'] = "p@5\$w0rd";
$lang['ignored'] = "igN0r3D";
$lang['guest'] = "gu3\$+";
$lang['next'] = "neX+";
$lang['prev'] = "pR3vi0Us";
$lang['others'] = "o+H3r5";
$lang['nickname'] = "nICKn4m3";
$lang['emailaddress'] = "eM41l @DDrE\$S";
$lang['confirm'] = "c0nfIrM";
$lang['email'] = "em@iL";
$lang['poll'] = "poLL";
$lang['friend'] = "fR13nD";
$lang['success'] = "suCC3sS";
$lang['error'] = "erRor";
$lang['warning'] = "w@Rn1ng";
$lang['guesterror'] = "soRrY, J00 NE3D TO 83 lOg9ED 1n +o U\$e +H1S phea+ure.";
$lang['loginnow'] = "lOG1n N0W";
$lang['unread'] = "unr34D";
$lang['all'] = "aLl";
$lang['allcaps'] = "aLl";
$lang['permissions'] = "pErMISSIOn\$";
$lang['type'] = "tYp3";
$lang['print'] = "prIN+";
$lang['sticky'] = "st1Cky";
$lang['polls'] = "poll\$";
$lang['user'] = "uS3r";
$lang['enabled'] = "eN4bL3D";
$lang['disabled'] = "d1s4BlEd";
$lang['options'] = "op+10ns";
$lang['emoticons'] = "eM0+IcONs";
$lang['webtag'] = "w38+49";
$lang['makedefault'] = "m@Ke D3pH4ul+";
$lang['unsetdefault'] = "uns3t DeF@uLT";
$lang['rename'] = "rEN4ME";
$lang['pages'] = "p4gES";
$lang['used'] = "u\$eD";
$lang['days'] = "d4Ys";
$lang['usage'] = "us@GE";
$lang['show'] = "shoW";
$lang['hint'] = "hiN+";
$lang['new'] = "new";
$lang['referer'] = "rEpHEr3r";
$lang['thefollowingerrorswereencountered'] = "the FolLoWInG eRROrS w3rE eNC0Unt3RED:";

// Admin interface (admin*.php) ----------------------------------------

$lang['admintools'] = "aDm1n +00ls";
$lang['forummanagement'] = "forUM M@N@gEMeNT";
$lang['accessdeniedexp'] = "j00 dO noT H4VE pERm1SsIon +o uS3 THiS 53C+10N.";
$lang['managefolders'] = "m@n49e pH0LD3R\$";
$lang['manageforums'] = "m4N4ge PH0rUM\$";
$lang['manageforumpermissions'] = "m@nA9e ph0RUm P3rMiSs1oNS";
$lang['foldername'] = "folDer n@Me";
$lang['move'] = "mOv3";
$lang['closed'] = "cLo\$3d";
$lang['open'] = "oPEN";
$lang['restricted'] = "re5+R1Ct3d";
$lang['forumiscurrentlyclosed'] = "%s 1\$ cURr3ntLY CLo5Ed";
$lang['youdonothaveaccesstoforum'] = "j00 Do n0+ h4v3 aCc35\$ tO %s";
$lang['toapplyforaccessplease'] = "tO 4pPLY F0R 4Cce\$s PlEAs3 C0NT@c+ tEh %s.";
$lang['forumowner'] = "f0rUm OWNeR";
$lang['adminforumclosedtip'] = "iph j00 W@n+ tO CH4n9E \$0M3 \$3T+IN95 0N y0UR PHorUM cl1CK tH3 4Dm1N l1nK iN +He N@V1G4+10n B4R A8OVe.";
$lang['newfolder'] = "new F0LD3R";
$lang['nofoldersfound'] = "nO EX1S+1N9 F0LdERs FoUNd. T0 aDd A pHOLd3R CL1CK +3h '4Dd NEw' bUTt0n 83l0w.";
$lang['forumadmin'] = "fOrUm 4DM1n";
$lang['adminexp_1'] = "u5E +He MeNu On ThE LeFT +0 M@n493 Th1n95 In yoUr FORuM.";
$lang['adminexp_2'] = "<b>u\$eR5</b> 4LLOw\$ J00 +O s3T Ind1v1dU@L u53r PERMI5\$10n5, inCluDIn9 aPP01NTING M0D3R@+oRS 4ND 9aG9iNg PeOPL3.";
$lang['adminexp_3'] = "<b>user 9r0UP\$</b> 4LLowS j00 +O creATE US3R GrOUp\$ To 4\$\$19N P3RMI\$\$1ON\$ t0 4\$ M4Ny OR @S pHEw U5Er5 Qu1cKLy 4nD eA\$1LY.";
$lang['adminexp_4'] = "<b>b4N CONtRolS</b> 4Ll0w5 +H3 84NN1n9 @nD uN-84nN1N9 OPh Ip ADDREss35, H++P R3FEr3Rs, U\$3Rn@MES, 3M4iL 4dDre5S35 4nD n1CKn4Me\$.";
$lang['adminexp_5'] = "<b>fOlD3rS</b> @Llows th3 crE@t10n, MOd1f1C4t1on ANd D3Le+I0N 0F foLd3rs.";
$lang['adminexp_6'] = "<b>rs5 pHE3DS</b> 4ll0w5 J00 t0 m@N49e R5\$ fE3D\$ PHOR PR0P4G@tIon iN+O y0uR PH0RuM.";
$lang['adminexp_7'] = "<b>pRoph1L3S</b> lEt\$ j00 CuS+0m15E +he 1+3ms +H4+ 4PP34r IN +He US3R Pr0pH1lE\$.";
$lang['adminexp_8'] = "<b>f0rUM Se++1NG\$</b> @LL0W5 J00 +0 cU5T0MI\$3 y0ur PH0rum'\$ N4Me, 4PPe@R4nCe @nD m@ny oTH3R +HiN95.";
$lang['adminexp_9'] = "<b>st4RT P49E</b> le+S j00 cU\$+0mIS3 YOuR fORUm'\$ 5+4RT p4g3.";
$lang['adminexp_10'] = "<b>foruM S+YLE</b> 4LLOw\$ j00 +O gEN3R@Te RaND0M 5+yL3s FoR Y0uR fOrUM MEmB3RS +O uSE.";
$lang['adminexp_11'] = "<b>w0rD pH1LTeR</b> @LloWS j00 +O f1l+ER woRdS j00 D0N'+ W@nt T0 be US3d On Y0UR f0ruM.";
$lang['adminexp_12'] = "<b>p0\$+INg St@t\$</b> 9eneR@t3S 4 R3P0R+ LIStIN9 tEh +0P 10 POS+ER\$ 1N 4 D3f1N3D pER10d.";
$lang['adminexp_13'] = "<b>f0ruM L1Nk\$</b> L3t\$ J00 M4N49E The L1nKs dROPd0wn In +3H n@V194TIOn 8@R.";
$lang['adminexp_14'] = "<b>v13W l09</b> L15ts R3C3n+ actI0n5 8Y +3h FoRUM m0dER@+0R\$.";
$lang['adminexp_15'] = "<b>m@n49E f0RUm5</b> lE+\$ j00 CrE@tE 4Nd Del3tE AND CloSE 0R ReoP3N PhORUm\$.";
$lang['adminexp_16'] = "<b>gL084L foRum sE++1n95</b> @Ll0W\$ j00 T0 m0diFy sE++1Ng\$ wH1Ch 4PHPHeC+ 4ll FORUm5.";
$lang['adminexp_17'] = "<b>po5+ 4pPR0val Qu3U3</b> 4ll0wS j00 TO VI3w @nY p0sTS @w41+1n9 @ppR0V4l BY 4 MOd3r@t0r.";
$lang['adminexp_18'] = "<b>v1sit0r lO9</b> @ll0ws j00 +0 vieW an eXTEndED L1\$+ OF VIsiT0R\$ 1ncLUd1n9 +hEIr HTtP rEPhEreR5.";
$lang['createforumstyle'] = "cRe4+3 @ FoRUm 5TYlE";
$lang['newstylesuccessfullycreated'] = "nEw 5+yL3 SucC35\$phuLLY cRE4+3D.";
$lang['stylealreadyexists'] = "a s+Yl3 WI+H +HAt PH1L3Name 4LR34DY EX1\$+5.";
$lang['stylenofilename'] = "j00 Did NOt 3N+3R @ f1l3n4m3 TO 54vE tEH \$tYl3 w1TH.";
$lang['stylenodatasubmitted'] = "c0uLd NO+ Re4D PhORuM \$TYlE DA+@.";
$lang['styleexp'] = "us3 This P@9e to h3lp CR34+3 4 r4nDoMLy 93n3R4t3D \$+YLe phor YOUR phOrum.";
$lang['stylecontrols'] = "controLS";
$lang['stylecolourexp'] = "cLiCK on a CoL0UR +o M@K3 4 nEW 5+yl3 sHeEt 8453D On Th4t CoLouR. CuRreNt 84se COl0uR iS pHIRs+ In l15t.";
$lang['standardstyle'] = "s+4Ndard 5+yL3";
$lang['rotelementstyle'] = "r0+aTeD eL3M3N+ \$tYl3";
$lang['randstyle'] = "r4NDoM \$tYL3";
$lang['thiscolour'] = "thi\$ C0l0ur";
$lang['enterhexcolour'] = "oR 3Nt3R 4 Hex cOL0UR +O bAS3 4 N3W \$TYlE SHE3t On";
$lang['savestyle'] = "s@VE +Hi5 S+yLe";
$lang['styledesc'] = "s+YL3 d3scrIp+1oN";
$lang['stylefilenamemayonlycontain'] = "s+yLE PH1l3NAmE mAY 0nly cOn+4IN LOwERc@sE Le+t3rs (4-Z), nUM83R\$ (0-9) 4nd uND3RSc0rE.";
$lang['stylepreview'] = "s+yle PRev1EW";
$lang['welcome'] = "w3Lc0m3";
$lang['messagepreview'] = "mE\$S@G3 PReVIEW";
$lang['users'] = "uSER\$";
$lang['usergroups'] = "u53R Gr0UPs";
$lang['mustentergroupname'] = "j00 Mu\$+ en+eR 4 grOuP n4ME";
$lang['profiles'] = "pR0ph1Les";
$lang['manageforums'] = "m@N@9E phorUM\$";
$lang['forumsettings'] = "forUM 53T+1N9S";
$lang['globalforumsettings'] = "gl0bal FOrUM \$3++iNG\$";
$lang['settingsaffectallforumswarning'] = "<b>n0+E:</b> +He\$3 \$3tT1N9S afpHEC+ 4LL FoRuMS. WHER3 +3H \$E+T1NG 15 DuPLiCA+3D 0N +h3 iNDiVIDUAL PHorUm'\$ s3t+INg\$ Pa9E Th@+ WilL t@KE PR3C3D3Nce 0Ver tH3 5e+TIn9\$ J00 ch@NG3 h3r3.";
$lang['startpage'] = "s+4R+ P4gE";
$lang['startpageerror'] = "yoUr \$+4rT p49E coUlD nOT 83 5@v3d LOcALly t0 +3h SErV3r B3C@u5e pERmiSS1ON w4\$ dEN13d.</p><p>t0 Ch4n9E y0ur s+@R+ PaG3 PlE@sE cL1CK tEH doWnL04d BUT+oN 8ELow WhIch wILl PR0MP+ J00 tO 54Ve Th3 FILe To YoUR hArD dRIV3. J00 c4n +HeN uPL04d tH1\$ fIlE TO yoUR S3rVEr 1N+0 T3H Ph0Ll0wIN9 FOLdER, iF nEc3\$5@rY CRe@+in9 TH3 PholDeR S+rUC+UrE 1n Th3 ProCeS5.</p><p><b>%s</b></p><p>pLe4SE n0+E +H4+ 50M3 BRowS3r5 m4y ch4n9e +hE N4M3 oF T3H Fil3 UPOn DownL0@D. WHen UPlo4D1n9 +h3 F1le PL3@S3 M4KE suRE +h4t 1+ 15 n4MEd \$TARt_M@1N.Php OTh3rwI5E Y0ur S+@rT P@9E W1ll 4pP34R uNCH4N9ED.";
$lang['failedtoopenmasterstylesheet'] = "yOUR f0rUm S+YL3 cOULD N0T b3 S4veD b3caU5E +h3 mA\$+3r S+ylE ShE3T c0ULd No+ b3 Lo4D3D. T0 \$@vE Y0UR \$+Yl3 ThE m4STeR s+Yl3 5He3T (MAk3_s+ylE.cs5) Mu\$+ 83 LoC@t3d 1n ThE StyL35 D1R3C+ORy 0F y0uR 8e3h1vE FOrUM 1n\$t4lL@t10n.";
$lang['makestyleerror'] = "y0ur F0RUm stYLE c0uLD N0+ 8E S@V3D l0C4LLy +o Th3 \$3RV3R 83C@USe p3rmI\$\$1oN w4s d3Ni3d.</p><p>to s@V3 YOUR pH0RUm S+YL3 plE4\$E ClICk +h3 DOwNL04D 8U++On 83lOW wH1ch w1lL prOmP+ j00 +o 5AV3 +h3 PhIL3 +0 YOuR h4rD dRIv3. J00 C4N Th3N UpL04D +his FiLE TO Y0ur s3rveR inT0 +3H FOLlOwin9 FOLd3r, 1f N3CES5aRy Cr34tin9 thE FOLD3r 5+RuC+UrE in Teh PRoC3\$s.</p><p><b>%s</b></p><p>ple4se n0tE tHAT S0mE 8r0WSers m4Y cH4n9E THe N4ME of +hE Ph1l3 UPon doWNLo4d. wH3n UplO4d1N9 +3H FIl3 pLE@\$e m@KE Sur3 +h4t i+ 15 N4mEd 5+yl3.csS oth3rWISe +3H Phorum styLE w1ll 83 un4v@1l@bL3.";
$lang['forumstyle'] = "f0rUm 5TYl3";
$lang['wordfilter'] = "w0RD pH1LT3R";
$lang['forumlinks'] = "f0rum LInK\$";
$lang['viewlog'] = "vIeW lOg";
$lang['noprofilesectionspecified'] = "nO Pr0ph1l3 \$eCT1on \$pECipH13D.";
$lang['itemname'] = "it3M N4Me";
$lang['moveto'] = "mOV3 +o";
$lang['manageprofilesections'] = "m4N49e pROph1Le \$3Ct1ON\$";
$lang['sectionname'] = "sECT10n N@m3";
$lang['items'] = "i+Ems";
$lang['mustspecifyaprofilesectionid'] = "mU5+ Sp3cIphY @ PRoF1l3 \$3C+IOn 1d";
$lang['mustsepecifyaprofilesectionname'] = "mUS+ \$pEcIfY @ PrOpH1l3 S3C+ION naM3";
$lang['noprofilesectionsfound'] = "n0 3x1S+inG PROpH1Le S3CT1on\$ PHounD. T0 4Dd @ PRoF1L3 \$3C+i0n clICK +He 'Add N3W' bUTt0n 8ELow.";
$lang['addnewprofilesection'] = "adD NeW pR0FILE 53Ct1on";
$lang['successfullyaddedprofilesection'] = "succ3s\$PHULLY 4ddeD pR0FILe \$3C+10n";
$lang['successfullyeditedprofilesection'] = "sucCe\$\$phuLly Edi+Ed PR0pH1LE S3cti0N";
$lang['addnewprofilesection'] = "aDD n3W ProPH1L3 53c+I0N";
$lang['mustsepecifyaprofilesectionname'] = "mU5+ \$pEc1FY 4 PRopHILe \$3c+10n N4M3";
$lang['successfullyremovedselectedprofilesections'] = "sucCe\$\$phuLly REMOv3d \$3L3CTeD PR0PHiL3 \$3CT10N\$";
$lang['failedtoremoveprofilesections'] = "fAIlEd +o R3m0ve Pr0fiLE 5EcTioNs";
$lang['viewitems'] = "v13w i+3M\$";
$lang['successfullyaddednewprofileitem'] = "sUCCES\$PHUlLY 4dD3D nEW prOph1lE I+3M";
$lang['successfullyeditedprofileitem'] = "sUccE\$\$pHulLy 3d1+3d pR0fIle i+3M";
$lang['successfullyremovedselectedprofileitems'] = "suCcE\$\$PHUlLY r3MOv3d \$el3c+3D ProFIle 1T3M\$";
$lang['failedtoremoveprofileitems'] = "f41l3D t0 R3M0ve PR0Ph1L3 I+3m\$";
$lang['noexistingprofileitemsfound'] = "tHER3 4re NO eX1\$+Ing prOFIlE i+3M\$ 1n tH1s \$ECtIOn. +o aDd 4n iTEm cliCK +hE '@dD nEW' 8UT+ON B3L0W.";
$lang['edititem'] = "eDi+ 1+3m";
$lang['invalidprofilesectionid'] = "inv@LiD PR0Ph1lE SECTi0n id 0r sEC+1ON NO+ Ph0uND";
$lang['invalidprofileitemid'] = "inv4l1D ProPH1LE 1t3m 1D Or 1+3m n0t fOuND";
$lang['addnewitem'] = "aDD N3W ITem";
$lang['youmustenteraprofileitemname'] = "j00 MuSt EN+3R @ pROf1l3 I+eM nAmE";
$lang['invalidprofileitemtype'] = "inV4LiD PR0File 1+em +YPe SelECT3d";
$lang['youmustenteroptionsforselectedprofileitemtype'] = "j00 muS+ ENT3r S0Me 0P+ioN\$ f0R 53LEcT3D pROFiL3 1Tem TYPe";
$lang['youmustentermorethanoneoptionforitem'] = "j00 MU\$t enT3R morE tH4N 0n3 0pT1ON f0R S3L3C+3d ProFIl3 1+EM +YpE";
$lang['profileitemhyperlinkssupportshttpurlsonly'] = "proph1l3 i+3m HYp3RLiNKs sUppOr+ ht+P uRl\$ oNLY";
$lang['profileitemhyperlinkformatinvalid'] = "proph1l3 1+3M hYPeRLiNK PHoRM4T 1NV4LiD";
$lang['youmustincludeprofileentryinhyperlinks'] = "j00 mUS+ 1NClUd3 <i>%s</i> 1N tH3 UrL oPH clIcK4Bl3 HYP3rLInK5";
$lang['failedtocreatenewprofileitem'] = "faIl3d T0 CrE@tE n3w pR0fIlE 1Tem";
$lang['failedtoupdateprofileitem'] = "faIl3D t0 Upd@Te PRofILe 1+3M";
$lang['startpageupdated'] = "s+4rT p49E UPD4t3d. %s";
$lang['viewupdatedstartpage'] = "vieW UpD@t3d sT4R+ p493";
$lang['editstartpage'] = "eD1+ \$+4R+ PA9e";
$lang['nouserspecified'] = "n0 us3r \$pECIf13D.";
$lang['manageuser'] = "m4n49E US3R";
$lang['manageusers'] = "m@nag3 US3R\$";
$lang['userstatusforforum'] = "uS3r \$+@tu\$ Ph0r %s";
$lang['userdetails'] = "uS3r dE+4IL\$";
$lang['edituserdetails'] = "eD1t UsER DE+4il5";
$lang['warning_caps'] = "warN1n9";
$lang['userdeleteallpostswarning'] = "aRE J00 \$UR3 J00 W4NT +0 d3lE+e 4LL 0PH ThE SeL3CT3D US3R's p0st5? ONcE +H3 poSt5 4rE D3L3t3D tH3Y c4nnOt b3 r3Tri3VeD 4Nd W1Ll 83 lO5T pHOR3VeR.";
$lang['postssuccessfullydeleted'] = "pO5+S W3Re SuCc3ssPHuLLy deL3T3D.";
$lang['folderaccess'] = "f0LDER 4CCe5s";
$lang['possiblealiases'] = "p0\$S1Bl3 AL1@Se\$";
$lang['userhistory'] = "u5ER hi\$+oRY";
$lang['nohistory'] = "n0 HIStORY reC0RDS S4v3D";
$lang['userhistorychanges'] = "ch@n9E\$";
$lang['clearuserhistory'] = "cLe@R u\$ER HIs+ORy";
$lang['changedlogonfromto'] = "ch@N93D LOgON pHR0M %s to %s";
$lang['changednicknamefromto'] = "ch4NGeD nIcKN@Me PhROm %s T0 %s";
$lang['changedemailfromto'] = "cHan9eD 3m41l FrOM %s tO %s";
$lang['successfullycleareduserhistory'] = "sucCESspHuLLy Cl3aR3D US3R HiS+orY";
$lang['failedtoclearuserhistory'] = "f@Il3d t0 cl34r UsEr HisT0ry";
$lang['successfullychangedpassword'] = "sUcC3SSFuLLy ch@nG3D pa\$\$w0RD";
$lang['failedtochangepasswd'] = "f41LEd tO CH4NGe P45SW0Rd";
$lang['viewuserhistory'] = "viEw USEr H1\$+ORy";
$lang['viewuseraliases'] = "vIEW US3R 4L1@s3\$";
$lang['searchreturnednoresults'] = "s3@rCH R3TuRnED N0 R3sul+\$";
$lang['deleteposts'] = "dEletE P0sTS";
$lang['deleteuser'] = "deL3t3 USeR";
$lang['alsodeleteusercontent'] = "alS0 DeL3T3 4Ll 0f +EH C0N+3n+ cr34TEd bY tHis us3R";
$lang['userdeletewarning'] = "are J00 suRE j00 W4N+ T0 d3lE+e THe SeLEc+3D u\$3r 4CCOuNT? 0NcE TH3 4CC0Un+ h4S 83eN D3L3T3D 1t c@NnOt 8e Re+R13v3D @ND W1LL 8E l0\$t pHOr3vER.";
$lang['usersuccessfullydeleted'] = "uS3r \$uCc3ssPhULlY d3leTeD";
$lang['failedtodeleteuser'] = "f@1LeD +0 DeLe+e us3R";
$lang['forgottenpassworddesc'] = "iph THIS U\$3r h4S foRGOt+3N tH31r p4\$sW0Rd J00 c4n rESe+ 1+ foR +HeM hERe.";
$lang['failedtoupdateuserstatus'] = "f@1l3D +O UPd4te U\$eR 5+@+U5";
$lang['failedtoupdateglobaluserpermissions'] = "f@1l3d +o UpD4tE 9LO8@l U5Er PeRM1\$\$10nS";
$lang['failedtoupdatefolderaccesssettings'] = "f4ilEd +O UpD4TE pHOlD3r 4Cce\$s S3+T1Ng\$";
$lang['manageusersexp'] = "tH1s L1\$+ 5H0WS 4 SeL3C+IoN oPH Us3r5 Wh0 H@Ve l099Ed 0n T0 Y0Ur ForUm, 50R+3D 8y %s. T0 4L+3r @ us3R'\$ P3rmi5\$10N5 cL1Ck +HeiR n4Me.";
$lang['userfilter'] = "useR fIl+3R";
$lang['onlineusers'] = "oNL1n3 Us3r\$";
$lang['offlineusers'] = "ophPHL1n3 uSeRS";
$lang['usersawaitingapproval'] = "u\$eR\$ 4waIt1n9 4PProVaL";
$lang['bannedusers'] = "b4NNeD u5eRS";
$lang['lastlogon'] = "l@\$+ l090n";
$lang['sessionreferer'] = "s35\$10N RePHeR3R";
$lang['signupreferer'] = "s1gN-up R3f3R3R:";
$lang['nouseraccountsmatchingfilter'] = "n0 usEr 4CC0UN+5 M4TcHInG fIlT3R";
$lang['searchforusernotinlist'] = "s3@rCH F0R 4 u53r NoT iN l1s+";
$lang['adminaccesslog'] = "aDM1N @ccE\$\$ LO9";
$lang['adminlogexp'] = "th1\$ Li\$t \$hOW\$ ThE l4s+ 4Ct1onS \$4NC+10n3d BY u\$ERS witH 4Dm1n PR1VIL3G35.";
$lang['datetime'] = "d@T3/TIme";
$lang['unknownuser'] = "unkN0WN usER";
$lang['unknownuseraccount'] = "unkn0WN uSEr 4Cc0UN+";
$lang['unknownfolder'] = "uNkN0WN f0LDer";
$lang['ip'] = "ip";
$lang['lastipaddress'] = "l4\$+ 1p 4DdREs\$";
$lang['hostname'] = "h0sTN4M3";
$lang['unknownhostname'] = "unKN0wn hO5tNamE";
$lang['logged'] = "l0gGED";
$lang['notlogged'] = "n0t L0G93d";
$lang['addwordfilter'] = "aDD w0Rd FiLTeR";
$lang['addnewwordfilter'] = "adD NEW w0rD pHilT3r";
$lang['wordfilterupdated'] = "wOrD fIltEr UPd4TEd";
$lang['wordfilterisfull'] = "j00 c@NN0T @dd 4NY mORe W0RD F1L+eR\$. ReMOvE SOM3 unU\$eD 0N3s Or Ed1+ t3h Ex1ST1NG 0n3s fIr5+.";
$lang['filtername'] = "fil+3R n4m3";
$lang['filtertype'] = "filTer tYP3";
$lang['filterenabled'] = "f1lTER EN@bl3D";
$lang['editwordfilter'] = "edi+ WoRd Fil+3R";
$lang['nowordfilterentriesfound'] = "nO exi\$+iNG W0RD fiL+3r 3n+r1E\$ phouNd. T0 @dD 4 FIlt3r cLIcK +Eh '4Dd NEW' 8U++0n b3l0W.";
$lang['mustspecifyfiltername'] = "j00 MUS+ \$P3CiFY 4 PhIl+3r N4Me";
$lang['mustspecifymatchedtext'] = "j00 MU5+ SpEc1fY Ma+ch3D TExT";
$lang['mustspecifyfilteroption'] = "j00 mu5+ 5PEciPhY a pHILT3R op+ION";
$lang['mustspecifyfilterid'] = "j00 mU\$T SPEcipHY A phil+3r 1d";
$lang['invalidfilterid'] = "inv@lid f1lTER 1d";
$lang['failedtoupdatewordfilter'] = "f@il3d t0 UPDA+3 w0rD pH1LTEr. CHECK tH4T T3H phiL+Er 5t1ll 3X1\$tS.";
$lang['allow'] = "aLLOw";
$lang['block'] = "bLock";
$lang['normalthreadsonly'] = "n0RM4L ThR34DS oNLy";
$lang['pollthreadsonly'] = "p0LL +Hr34D\$ ONly";
$lang['both'] = "bo+H tHr34D +Yp35";
$lang['existingpermissions'] = "exis+1N9 P3RM1S\$1oNs";
$lang['nousershavebeengrantedpermission'] = "nO Exis+1n9 u\$3r5 p3rMiSs1onS F0UNd. tO GR4Nt P3Rm1\$sI0N +0 U\$3rs \$e@rCh PHor +h3m 8ELOw.";
$lang['successfullyaddedpermissionsforselectedusers'] = "suCCE5SFUlly 4DDED p3rM15\$10Ns PH0r \$el3CTeD U53rS";
$lang['successfullyremovedpermissionsfromselectedusers'] = "suCcES\$FUlLY r3m0vED PErM1\$SiON\$ fRom SeL3CTed U53r\$";
$lang['failedtoaddpermissionsforuser'] = "f4iL3D t0 4dD P3Rm1S\$IOn5 PH0R U5ER '%s'";
$lang['failedtoremovepermissionsfromuser'] = "f41LEd T0 R3M0VE p3RM1\$\$I0N5 PhrOm U5ER '%s'";
$lang['searchforuser'] = "s3@rcH F0R U53r";
$lang['browsernegotiation'] = "broWs3R n390TI4+3D";
$lang['largetextfield'] = "larGE TEXt ph1ElD";
$lang['mediumtextfield'] = "m3D1Um T3x+ ph1elD";
$lang['smalltextfield'] = "sM4ll +exT Fi3LD";
$lang['multilinetextfield'] = "mUl+1-L1n3 +3xT PH13lD";
$lang['radiobuttons'] = "r4Di0 8UT+onS";
$lang['dropdownlist'] = "drOP dOwn l1St";
$lang['clickablehyperlink'] = "cL1cK@BL3 HYPeRLiNK";
$lang['threadcount'] = "thrE4D CoUN+";
$lang['clicktoeditfolder'] = "clIck +O ed1T pHOLDer";
$lang['fieldtypeexample1'] = "t0 CRE4+e R4D1o 8utTOns or 4 dROp d0WN lISt J00 Ne3d T0 3nt3r 34CH 1nDIv1dU@l V4LuE 0N 4 5EP4R4+E LInE 1N THE OPtIOn\$ pH13lD.";
$lang['fieldtypeexample2'] = "tO Cr3@TE CLiCka8Le liNk\$ ENTeR Teh uRL 1n +eh oP+Ion\$ fIELd @Nd U\$e <i>%1\$s</i> WhEr3 thE ENTrY fr0M +eH u\$3r's PR0fIlE SHOuld @ppEar. 3X@mPLe\$: <p>mySp4c3: <i>h++P://WWW.MYsp@C3.cOM/%1\$5</i><br />x80X L1vE: <i>hTtP://PrOFilE.MY9AM3Rc4rD.n3T/%1\$s</i>";
$lang['editedwordfilter'] = "eD1+3D w0rD phiL+ER";
$lang['editedforumsettings'] = "eD1tED PH0rUm sE++1N95";
$lang['successfullyendedusersessionsforselectedusers'] = "sUCc3s\$fULly 3Nd3d 53ss1oNS foR \$3l3C+3D uSer5";
$lang['failedtoendsessionforuser'] = "f@1l3D tO eND S3S510n Ph0r UsER %s";
$lang['successfullyapprovedselectedusers'] = "suCCeSSfUllY 4PpROvED 53lEc+3D U\$3r\$";
$lang['matchedtext'] = "m@+ch3D +ext";
$lang['replacementtext'] = "r3pL@C3MEn+ +3XT";
$lang['preg'] = "pREg";
$lang['wholeword'] = "whoLE w0rD";
$lang['word_filter_help_1'] = "<b>aLl</b> m4+CHeS @941nST t3h wHOL3 T3X+ so pHIl+ERiNG mOm T0 mUM wILl 4l\$o Ch4N9E m0m3NT +0 MuM3nT.";
$lang['word_filter_help_2'] = "<b>wH0le W0RD</b> M4+cH3s 494INst Wh0LE WoRdS oNLy \$O fIL+3RING M0m +0 mUM w1lL no+ CH4NgE m0m3nT To MuM3N+.";
$lang['word_filter_help_3'] = "<b>pr3g</b> 4Ll0w\$ J00 T0 UsE pERl ReguL@r 3XPRe\$\$I0N5 T0 MaTch +3x+.";
$lang['nameanddesc'] = "n4M3 4ND dEScRIp+IOn";
$lang['movethreads'] = "m0ve Thre4ds";
$lang['movethreadstofolder'] = "m0v3 +hRE@D5 T0 foLdEr";
$lang['failedtomovethreads'] = "f@iL3D +0 M0v3 thREaDS +0 SP3CIPh13D phOlDer";
$lang['resetuserpermissions'] = "rE\$3T u5Er P3rMI\$\$ioN5";
$lang['failedtoresetuserpermissions'] = "f4IlED +o r3SE+ UsER P3rMis5I0N5";
$lang['allowfoldertocontain'] = "alLoW f0lD3R t0 C0N+4In";
$lang['addnewfolder'] = "adD N3w fOlDer";
$lang['mustenterfoldername'] = "j00 MusT ENTER 4 FOlDer NAMe";
$lang['nofolderidspecified'] = "n0 Ph0lDeR iD spEc1F1ED";
$lang['invalidfolderid'] = "iNV@liD PHoLDeR 1D. CHecK +H4T 4 pH0Ld3r W1TH THIs Id 3XIs+5!";
$lang['successfullyaddednewfolder'] = "sUCcES5PHuLLy @dDeD n3W PhOLdeR";
$lang['successfullyremovedselectedfolders'] = "suCCeSSPhULly r3m0v3d SEL3CtED FOlDer5";
$lang['successfullyeditedfolder'] = "sUCCESSfULly 3Dit3d Ph0lD3r";
$lang['failedtocreatenewfolder'] = "f41l3D T0 Cr34+E nEw fOlDEr";
$lang['failedtodeletefolder'] = "f4iLEd T0 Del3te FoLDeR.";
$lang['failedtoupdatefolder'] = "fAiLeD +0 UPd4t3 f0lDER";
$lang['cannotdeletefolderwiththreads'] = "c4nN0+ d3lE+e FoLD3RS +H@t \$+1Ll CoN+4IN THRE@d\$.";
$lang['forumisnotrestricted'] = "f0Rum iS noT RE\$+ric+3D";
$lang['groups'] = "gROupS";
$lang['nousergroups'] = "n0 U\$3R gR0UP\$ H@vE 83EN \$E+ Up. +O @Dd 4 Gr0uP cL1ck +h3 '4DD N3w' bu++ON B3l0w.";
$lang['suppliedgidisnotausergroup'] = "suPpLIeD gId 1\$ no+ 4 uSEr GrOUp";
$lang['manageusergroups'] = "m4n49E uS3r 9R0Up\$";
$lang['groupstatus'] = "grOup s+4+Us";
$lang['addusergroup'] = "adD us3R 9R0UP";
$lang['addemptygroup'] = "aDd 3mp+Y GRoUP";
$lang['adduserstogroup'] = "adD u\$3RS T0 gR0UP";
$lang['addremoveusers'] = "aDD/R3M0V3 Us3r\$";
$lang['nousersingroup'] = "ther3 Ar3 N0 Us3r5 1N +H1\$ 9ROUp. @Dd u5eRS T0 +H1\$ GR0Up 8Y \$34rCh1NG f0r +hEM 83l0w.";
$lang['groupaddedaddnewuser'] = "succ3ssFUllY @dDeD 9R0Up. 4DD U\$3R\$ T0 +h1s 9r0UP 8y \$EARcH1n9 phoR TH3M b3l0w.";
$lang['nousersingroupaddusers'] = "there @Re No UsERs 1N Th1\$ 9rOUp. +O 4Dd Us3rs cLIcK tEh '4dD/r3m0v3 Us3rs' 8u++on b3LOw.";
$lang['useringroups'] = "tH1\$ u\$3R iS 4 m3m8er OPH tHe Ph0llOw1n9 9R0UP\$";
$lang['usernotinanygroups'] = "tH15 U5ER iS NOt 1N @Ny U53r grOuP\$";
$lang['usergroupwarning'] = "nOte: +H1s USER M@y 8E 1nher1+inG 4dD1+10nAL PERM15s10ns phR0M @nY u\$er gROuP\$ L15+3d 83loW.";
$lang['successfullyaddedgroup'] = "sucCeS\$fUlLY 4DdEd Gr0UP";
$lang['successfullyeditedgroup'] = "sucCeSspHUlLY ed1+3D gR0UP";
$lang['successfullydeletedselectedgroups'] = "sUCCeS\$pHUlLY D3le+eD \$3L3C+eD 9rOuP5";
$lang['failedtodeletegroupname'] = "f@iL3D +O d3l3TE GROuP %s";
$lang['usercanaccessforumtools'] = "u53r c@N acC35\$ FOrUm TOOl\$ 4nD C@n crE4T3, DElE+3 @ND EDI+ F0Rum\$";
$lang['usercanmodallfoldersonallforums'] = "usER C@N mOdER4+e <b>alL PhOLdERs</b> oN <b>aLL PHORuM\$</b>";
$lang['usercanmodlinkssectiononallforums'] = "uS3r c4n mod3r@+E L1NKS \$3C+iON oN <b>aLL ph0RUmS</b>";
$lang['emailconfirmationrequired'] = "eM4iL cONF1Rm4ti0N R3QUiREd";
$lang['userisbannedfromallforums'] = "u53R iS b4NN3D fR0M <b>aLl F0ruM5</b>";
$lang['cancelemailconfirmation'] = "c4NceL 3m4iL C0NFiRMaTIoN and 4lLoW uSEr TO ST4R+ p0St1N9";
$lang['resendconfirmationemail'] = "rE\$end c0nFiRMa+10N 3MAIL +O U53r";
$lang['failedtosresendemailconfirmation'] = "f4iLEd +0 R35eND 3m41L C0NFiRM4TIoN +0 U\$Er.";
$lang['donothing'] = "d0 n0+H1N9";
$lang['usercanaccessadmintools'] = "usER h4s 4CcE\$\$ +0 pHorUm 4DMiN to0L\$";
$lang['usercanaccessadmintoolsonallforums'] = "u\$er H@s 4CcE\$S To 4DM1n +00lS <b>on 4Ll pHoRUm\$</b>";
$lang['usercanmoderateallfolders'] = "u\$Er c4n mOD3r4tE 4lL pH0lders";
$lang['usercanmoderatelinkssection'] = "uS3r c4N moD3R@tE liNk\$ sectI0n";
$lang['userisbanned'] = "uS3R Is b4nned";
$lang['useriswormed'] = "u5ER 1\$ WORm3D";
$lang['userispilloried'] = "u53R Is P1LloRi3d";
$lang['usercanignoreadmin'] = "uSER C4N I9NORe 4DM1N1\$+r4t0r5";
$lang['groupcanaccessadmintools'] = "gRoup c4n 4CC3sS 4DMiN +0Ol\$";
$lang['groupcanmoderateallfolders'] = "gROUp C4N m0D3r4te aLL f0lD3RS";
$lang['groupcanmoderatelinkssection'] = "gR0UP c4n ModER4Te LiNk\$ sEcT1ON5";
$lang['groupisbanned'] = "gr0uP I5 b@nN3d";
$lang['groupiswormed'] = "grOuP is w0rm3D";
$lang['readposts'] = "rE4d P0\$t5";
$lang['replytothreads'] = "r3pLY +O +HRe@D5";
$lang['createnewthreads'] = "cre4Te New +HR34d5";
$lang['editposts'] = "edi+ P0s+\$";
$lang['deleteposts'] = "d3L3t3 P05TS";
$lang['postssuccessfullydeleted'] = "pOs+S SUcC3\$\$pHUlLY D3L3+3d";
$lang['failedtodeleteusersposts'] = "f4il3D T0 d3l3t3 Us3r'\$ P0s+5";
$lang['uploadattachments'] = "uPL04d 4+t@cHMeNT\$";
$lang['moderatefolder'] = "mODer@te Ph0lDEr";
$lang['postinhtml'] = "pO\$+ 1N hTMl";
$lang['postasignature'] = "p05t 4 \$i9n@TUr3";
$lang['editforumlinks'] = "ed1+ pHORum lINk5";
$lang['linksaddedhereappearindropdown'] = "lINks aDdEd H3re @PpE4R in @ DrOP D0WN 1n t3h T0P R1GH+ of +Eh Fr@M3 s3t.";
$lang['linksaddedhereappearindropdownaddnew'] = "l1nK\$ @DdED HeRE @pP34R IN @ dR0p D0WN 1n ThE t0P r1gH+ OF t3h pHR4mE 5e+. +o 4Dd A lInK cLICK +hE '4dD n3w' bUTt0N b3l0W.";
$lang['failedtoremoveforumlink'] = "f41lEd +0 R3M0V3 FORuM lINk '%s'";
$lang['failedtoaddnewforumlink'] = "f@1l3d +0 aDD N3W foRuM LiNK '%s'";
$lang['failedtoupdateforumlink'] = "f@ILED To UPd@t3 FoRUm L1NK '%s'";
$lang['notoplevellinktitlespecified'] = "no t0P L3v3l lINk TitL3 5pec1ph1eD";
$lang['youmustenteralinktitle'] = "j00 MUs+ 3NtER @ LINK TItl3";
$lang['alllinkurismuststartwithaschema'] = "all L1NK uRIs Mu\$+ s+@r+ wITH 4 \$CH3M4 (1.e. H++p://, F+P://, 1Rc://)";
$lang['editlink'] = "eDIT L1nK";
$lang['addnewforumlink'] = "aDD n3w pH0RUm L1Nk";
$lang['forumlinktitle'] = "f0RUM LiNK TItl3";
$lang['forumlinklocation'] = "f0rum L1NK l0c4T1On";
$lang['successfullyaddednewforumlink'] = "suCc3sSfUlLY 4DdED New f0Rum l1nK";
$lang['successfullyeditedforumlink'] = "succEs\$PHulLY 3D1TED F0Rum LInK";
$lang['invalidlinkidorlinknotfound'] = "iNV@LiD l1nk 1D Or L1NK nOT pH0UnD";
$lang['successfullyremovedselectedforumlinks'] = "sUCCES\$pHUlly r3moV3D \$EL3C+ED lINk\$";
$lang['toplinkcaption'] = "tOP lINk c4pTioN";
$lang['allowguestaccess'] = "allOW 9U3s+ 4CcE\$\$";
$lang['searchenginespidering'] = "s3@RCH En9INE SP1der1NG";
$lang['allowsearchenginespidering'] = "alloW sE@rch 3N9INe 5PIdErINg";
$lang['sitemapenabled'] = "eN4BL3 51tEM@p";
$lang['sitemapupdatefrequency'] = "s1+3MAp UPD@tE PHReQU3Ncy";
$lang['sitemappathnotwritable'] = "siT3m4p d1r3C+oRY mUSt 8e wRIt@8L3 8Y +3h WE8 53RV3r / PhP pR0c3SS!";
$lang['newuserregistrations'] = "n3w USEr ReGISTR4TIOnS";
$lang['preventduplicateemailaddresses'] = "pr3V3N+ DuPLiC@TE Em@1l aDdr3sSE\$";
$lang['allownewuserregistrations'] = "alL0W nEW uS3r ReG1\$TRA+10N\$";
$lang['requireemailconfirmation'] = "rEqu1r3 Em@Il ConPh1rm@TioN";
$lang['usetextcaptcha'] = "u5E +3XT-c4P+cH4";
$lang['textcaptchafonterror'] = "tEXT-C@Ptch@ h4\$ b33N dI\$48LED @uT0M@+1C4llY 83C4U\$3 +HeRe @rE NO TRUe +YP3 f0n+\$ 4vAil48Le PhOR 1t T0 u\$3. Ple4Se uPLo4D \$om3 TrU3 +yP3 FoNTs T0 <b>t3x+_c4p+ch@/PhoN+5</b> 0n yoUr 53RV3r.";
$lang['textcaptchadirerror'] = "tEX+-c4p+CH@ HA\$ 83EN DI54BL3D b3cAUsE TeH +3x+_c@PtCh4 D1RECT0RY 4nd 1+'S \$ub-dIREC+Or135 4rE n0t wrI+4BLE BY tEH weB s3RVEr / PHp pROcES5.";
$lang['textcaptchagderror'] = "tExT-c4pTCH4 H4s B3en dIS@8Led 8Ec4uSE Y0UR 53rV3R'\$ Php SE+UP D0ES N0+ Pr0viDe 5UPpoRt for 9D 1m49e M4NIpUl@+iON @Nd / Or +tpH Ph0N+ \$UPP0Rt. 8otH 4Re ReQu1ReD fOR +3x+-c4p+ChA sUPP0rT.";
$lang['newuserpreferences'] = "neW Us3r Pr3pHeR3ncE\$";
$lang['sendemailnotificationonreply'] = "em4IL NoTIpH1c@T1on 0N RePLy To U\$er";
$lang['sendemailnotificationonpm'] = "emaIL nOT1ph1c4TIon oN pM +0 U\$Er";
$lang['showpopuponnewpm'] = "sH0w pOPuP WhEN ReCeIViNg N3W PM";
$lang['setautomatichighinterestonpost'] = "s3T 4UTOm4tIc H19H in+eR35+ 0n PO5+";
$lang['postingstats'] = "p0S+1n9 \$+@TS";
$lang['postingstatsforperiod'] = "p0STIn9 \$T4t\$ ph0R PeR10D %s +O %s";
$lang['nopostdatarecordedforthisperiod'] = "nO POsT D4T@ rEcorDeD foR +HIs p3R1OD.";
$lang['totalposts'] = "tO+@l Po5+s";
$lang['totalpostsforthisperiod'] = "t0t4l post\$ pH0R +HIs pERioD";
$lang['mustchooseastartday'] = "mu5T cH0O\$3 4 \$+4RT dAY";
$lang['mustchooseastartmonth'] = "mU\$+ ChooS3 4 5+ART MON+h";
$lang['mustchooseastartyear'] = "mUS+ CHO0SE 4 stArt y34R";
$lang['mustchooseaendday'] = "mU\$+ chO0se @ 3nD d@Y";
$lang['mustchooseaendmonth'] = "mU\$+ cH0053 a 3ND M0NTh";
$lang['mustchooseaendyear'] = "mu5+ ChO0sE 4 eND YE@r";
$lang['startperiodisaheadofendperiod'] = "st4R+ P3R1Od 1\$ 4H3@D OPh 3Nd PERIoD";
$lang['bancontrols'] = "b4n C0n+R0L5";
$lang['addban'] = "aDd 8aN";
$lang['checkban'] = "cH3Ck b4n";
$lang['editban'] = "eDIT 84n";
$lang['bantype'] = "b4N +YPe";
$lang['bandata'] = "b@N d4+@";
$lang['bancomment'] = "comM3NT";
$lang['ipban'] = "iP 84N";
$lang['logonban'] = "l0gOn 84N";
$lang['nicknameban'] = "nicKnaM3 84n";
$lang['emailban'] = "em@IL BAN";
$lang['refererban'] = "rePHEr3R ban";
$lang['invalidbanid'] = "inV4L1D 8@N 1D";
$lang['affectsessionwarnadd'] = "thiS B@n M4Y @PhF3CT thE FOLLOWInG 4C+iVe U53R sE\$si0n5";
$lang['noaffectsessionwarn'] = "tH1s 84n 4PHf3c+S No AcTIve \$E\$SIoNs";
$lang['mustspecifybantype'] = "j00 MU\$+ 5pEC1pHY a bAN Typ3";
$lang['mustspecifybandata'] = "j00 Mu\$+ 5pEC1PHy \$OmE 84N d@T@";
$lang['successfullyremovedselectedbans'] = "suCcES\$phULlY rEM0ved \$elEc+3D b@NS";
$lang['failedtoaddnewban'] = "f41l3d T0 4Dd N3W B4N";
$lang['failedtoremovebans'] = "f@ILeD +0 R3M0V3 \$0M3 0R @lL oPH TH3 S3L3CtED 84N5";
$lang['duplicatebandataentered'] = "dUpl1CA+3 8An D4TA 3ntERED. Pl3453 cH3CK Y0UR w1lDc4rDs +O \$3e Iph +hey 4lRE@DY m4+CH +H3 d4t4 EnTErEd";
$lang['successfullyaddedban'] = "sUCcES\$fULly 4DdEd 8@N";
$lang['successfullyupdatedban'] = "succ3s\$phULly Upd@T3D 84N";
$lang['noexistingbandata'] = "tHeRe 1s N0 Exi5T1nG B@n D4TA. TO 4dD @ b@n cLIcK tEH '@DD n3W' BU+TOn b3l0W.";
$lang['youcanusethepercentwildcard'] = "j00 caN uS3 +He P3rCent (%) WildC4rd \$ym80l In AnY oPH Y0UR 8@n L1\$+S t0 Obt41N pARTI4L M4tCHeS, I.3. '192.168.0.%' wOUlD ban AlL iP @Ddr3\$5e\$ iN tHe r4n93 192.168.0.1 +HR0U9H 192.168.0.254";
$lang['cannotusewildcardonown'] = "j00 c4nNOT @Dd % 4\$ 4 W1lDC4Rd M@tCH 0n 1+'S 0wn!";
$lang['requirepostapproval'] = "r3QuIr3 p0St @PPr0V@L";
$lang['adminforumtoolsusercounterror'] = "theRe MusT 8E 4+ l345+ 1 u\$3R w1+h aDmIN +O0LS 4Nd ph0rum +O0l5 4CcES\$ 0N @LL pH0RuM\$!";
$lang['postcount'] = "p05+ cOUN+";
$lang['resetpostcount'] = "r353t p0ST COun+";
$lang['failedtoresetuserpostcount'] = "f@1L3D T0 R3sE+ POS+ C0UNt";
$lang['failedtochangeuserpostcount'] = "fAil3D +o cH@N93 UsER pO5+ COuNT";
$lang['postapprovalqueue'] = "pos+ 4ppr0V4L qU3U3";
$lang['nopostsawaitingapproval'] = "no Po\$T5 4rE 4W41+1N9 4PPr0v4L";
$lang['approveselected'] = "aPPROv3 53LeCT3D";
$lang['failedtoapproveuser'] = "f@1lEd to 4pPR0V3 u\$eR %s";
$lang['kickselected'] = "k1ck 5El3C+ED";
$lang['visitorlog'] = "vIsI+oR L09";
$lang['clearvisitorlog'] = "cl34r Vi\$1+0r Log";
$lang['novisitorslogged'] = "n0 v1S1+0rs Lo9G3D";
$lang['addselectedusers'] = "add \$3L3C+3d uS3R5";
$lang['removeselectedusers'] = "r3mov3 \$3lec+3D u53r\$";
$lang['addnew'] = "adD New";
$lang['deleteselected'] = "deLETe \$3LEcT3D";
$lang['forumrulesmessage'] = "<p><b>f0RUM rUl3s</b></p><p>\nrEg1STr4tioN +0 %1\$\$ I\$ phREe! WE Do 1n51s+ Th4t J00 @bIdE bY +3h rULe\$ 4nD POlICi35 d3t@1L3d 83L0w. 1ph J00 4GRe3 TO T3H +3RM\$, PlE@s3 CHeCk +3H '1 @9rE3' cH3CKb0x 4Nd Pr35\$ +hE 'r3GIStER' 8UT+0n bELoW. IPh J00 W0UlD LikE +O C4Nc3L +h3 R391STra+ION, CliCk %2\$\$ t0 RE+uRN +o t3H f0ruMS 1ND3x.</p><p>\naLtH0uGH THe 4dmin15TR4t0R5 4nd MOD3r4+ORS 0PH %1\$S wILL @++EmpT +O kE3p alL OBJ3C+10N48LE ME\$\$49ES OPhF +h1\$ PH0RUm, 1+ 15 1MPos518L3 fOr US t0 R3v13w @Ll m35\$4G35. 4LL me\$\$@9es 3xpR3Ss +H3 V1EWS 0pH th3 4U+HOR, @nD n31+h3r +He OWN3rS Oph %1\$s, NOR pROJ3CT 8E3h1V3 FORum @Nd 1t'\$ 4pHph1Li4+35 W1lL 83 HElD R3SpONSI8l3 phOr +eh C0NTEn+ 0pH 4nY m35\$@9e.</p><p>\n8Y 49r331NG TO tHes3 RulE5, j00 wArr4nT Th@+ j00 WIlL N0+ P0S+ 4NY m35\$A9e\$ Th@t 4re 0BscENE, VULG4R, 53xUALly-0R1EnT@TeD, h4TEPHuL, THr34+3N1NG, 0r 0+HErw1\$3 vIOL4T1v3 Oph @Ny L4w\$.</p><p>tEh 0WNers 0Ph %1\$\$ r3sERV3 Teh RI9H+ t0 REM0V3, eDiT, moV3 0R Cl0\$3 4Ny THr34d F0r @ny re@S0n.</p>";
$lang['cancellinktext'] = "hER3";
$lang['failedtoupdateforumsettings'] = "f4ILEd +0 UPDA+e Ph0rUM sETtINgS. Pl34se TRy @9Ain l4tER.";
$lang['moreadminoptions'] = "mor3 4DM1N 0ptIoNs";

// Admin Log data (admin_viewlog.php) --------------------------------------------

$lang['changedstatusforuser'] = "cH4nG3d USEr S+4tU\$ phOr '%s'";
$lang['changedpasswordforuser'] = "ch@n93D P4\$5W0Rd PHOr '%s'";
$lang['changedforumaccess'] = "cH@N93D PhORuM 4Ccess PERmIS\$1ONS FOR '%s'";
$lang['deletedallusersposts'] = "deLe+3d 4ll p0\$T\$ pH0R '%s'";

$lang['createdusergroup'] = "cr3@+3d Us3r 9r0UP '%s'";
$lang['deletedusergroup'] = "d3l3T3D usER 9ROUp '%s'";
$lang['updatedusergroup'] = "uPd4t3D usEr GrOUP '%s'";
$lang['addedusertogroup'] = "adDed uSER '%s' +O gROup '%s'";
$lang['removeduserfromgroup'] = "remOV3 us3R '%s' phROM 9r0up '%s'";

$lang['addedipaddresstobanlist'] = "add3d IP '%s' T0 84n LIST";
$lang['removedipaddressfrombanlist'] = "r3MoV3D 1P '%s' fROm 84n LisT";

$lang['addedlogontobanlist'] = "aDD3d L090n '%s' t0 84N l1s+";
$lang['removedlogonfrombanlist'] = "r3M0vED L090n '%s' frOm baN LI5+";

$lang['addednicknametobanlist'] = "add3D N1CkNAmE '%s' +O 8@n L1sT";
$lang['removednicknamefrombanlist'] = "rEmOV3D n1cKn4ME '%s' fROM 8@N lI5+";

$lang['addedemailtobanlist'] = "add3D 3MAIl @ddr3S5 '%s' T0 8@n L1s+";
$lang['removedemailfrombanlist'] = "rEMOV3D 3m4il @DDR3S\$ '%s' FroM 8@n l1\$+";

$lang['addedreferertobanlist'] = "aDD3D r3PHeREr '%s' +O B4n lI5+";
$lang['removedrefererfrombanlist'] = "remOV3D R3PhER3r '%s' PHr0M b@n L1\$t";

$lang['editedfolder'] = "edIT3D ph0lD3R '%s'";
$lang['movedallthreadsfromto'] = "moVED @Ll ThR34dS FrOM '%s' t0 '%s'";
$lang['creatednewfolder'] = "cre4TEd NeW PhOLdER '%s'";
$lang['deletedfolder'] = "del3+ED FolDEr '%s'";

$lang['changedprofilesectiontitle'] = "cH4NG3D pRofIl3 5EctI0N +itL3 FR0M '%s' tO '%s'";
$lang['addednewprofilesection'] = "aDd3d New pR0FIlE 5EcTIOn '%s'";
$lang['deletedprofilesection'] = "delE+eD pR0pH1Le S3c+i0n '%s'";

$lang['addednewprofileitem'] = "adDEd n3w ProFiLE 1+3m '%s' +0 \$EcTION '%s'";
$lang['changedprofileitem'] = "ch4ng3D pR0fil3 1+EM '%s'";
$lang['deletedprofileitem'] = "d3L3T3D Pr0FILe 1+3M '%s'";

$lang['editedstartpage'] = "eDitEd S+4R+ P49e";
$lang['savednewstyle'] = "s@V3D nEw 5TYl3 '%s'";

$lang['movedthread'] = "m0vED +HRe4d '%s' From '%s' +o '%s'";
$lang['closedthread'] = "clo\$3d +hR34D '%s'";
$lang['openedthread'] = "op3n3D thRE@d '%s'";
$lang['renamedthread'] = "reN@MEd +hR34d '%s' t0 '%s'";

$lang['deletedthread'] = "dEL3t3D +Hr34d '%s'";
$lang['undeletedthread'] = "unD3L3+3D +hrE@d '%s'";

$lang['lockedthreadtitlefolder'] = "l0cKEd +hre@d OP+iON\$ 0n '%s'";
$lang['unlockedthreadtitlefolder'] = "unLOcK3D ThREaD 0P+10nS oN '%s'";

$lang['deletedpostsfrominthread'] = "del3tED POS+s Fr0m '%s' In +HrE4D '%s'";
$lang['deletedattachmentfrompost'] = "d3le+3D 4TTAcHmENt '%s' FrOm p0St '%s'";

$lang['editedforumlinks'] = "edI+3d fOrUM l1NK5";
$lang['editedforumlink'] = "eDiT3d PH0rUm L1nk: '%s'";

$lang['addedforumlink'] = "aDDeD f0RUm L1NK: '%s'";
$lang['deletedforumlink'] = "d3l3tEd PhoruM L1NK: '%s'";
$lang['changedtoplinkcaption'] = "cH4n9ed +Op L1Nk C4Pt1oN Phr0M '%s' t0 '%s'";

$lang['deletedpost'] = "d3L3tED P0ST '%s'";
$lang['editedpost'] = "edit3D pO5T '%s'";

$lang['madethreadsticky'] = "m4DE +Hr3aD '%s' \$+ICkY";
$lang['madethreadnonsticky'] = "m4d3 tHrEAd '%s' N0n-s+IcKY";

$lang['endedsessionforuser'] = "enD3D \$35\$10n pHor UsER '%s'";

$lang['approvedpost'] = "apPROv3d PO\$+ '%s'";

$lang['editedwordfilter'] = "ed1+3D W0Rd FilT3R";

$lang['addedrssfeed'] = "aDd3d r5s F3Ed '%s'";
$lang['editedrssfeed'] = "edi+ed R\$\$ PHe3D '%s'";
$lang['deletedrssfeed'] = "d3lET3D rss F3ed '%s'";

$lang['updatedban'] = "uPD@tEd bAN '%s'. CH4NG3D +YPe FroM '%s' t0 '%s', Ch4nG3D d@t4 phR0M '%s' tO '%s'.";

$lang['splitthreadatpostintonewthread'] = "spLiT +Hr3@d '%s' 4T PosT %s  INto n3w +Hr3@d '%s'";
$lang['mergedthreadintonewthread'] = "m3rgEd ThrE4D\$ '%s' @nd '%s' in+0 n3w +HRe4D '%s'";

$lang['approveduser'] = "aPPR0V3D uS3R '%s'";

$lang['forumautoupdatestats'] = "foruM @Ut0 Upd4t3: \$+4T5 UPd@TED";
$lang['forumautocleanthreadunread'] = "f0RUM @Uto uPD4te: Thr34d Unr34D d@t4 CL34NEd";

$lang['ipaddressbanhit'] = "useR '%s' 1\$ bANn3d. 1p 4DdRE\$\$ '%s' M@tCH3D B@n D@t@ '%s'";
$lang['logonbanhit'] = "u53r '%s' 1s B4NNeD. LogOn '%s' M@tchEd b@n d4+@ '%s'";
$lang['nicknamebanhit'] = "us3r '%s' 15 b@NNED. NIckn4M3 '%s' mA+cH3D B@n d4t4 '%s'";
$lang['emailbanhit'] = "us3r '%s' iS B@NnEd. 3maIl 4DDR3\$\$ '%s' m4TcHeD BAN dat4 '%s'";
$lang['refererbanhit'] = "u\$eR '%s' I\$ 8aNNED. h+Tp R3feR3R '%s' M@+cH3D 8@N d4Ta '%s'";

$lang['modifiedpermsforuser'] = "mOd1FIeD pERm\$ PH0R U\$3R '%s'";
$lang['modifiedfolderpermsforuser'] = "m0dIFI3D PH0Lder PeRMs PhOR U53R '%s'";

$lang['userpermbanned'] = "b@nN3D";
$lang['userpermwormed'] = "w0rm3D";
$lang['userpermfoldermoderate'] = "f0LDeR M0D3R4T0r";
$lang['userpermadmintools'] = "adM1N +O0LS";
$lang['userpermforumtools'] = "f0RUM To0l\$";
$lang['userpermlinksmod'] = "links MoDEr4t0r";
$lang['userpermignoreadmin'] = "i9noR3 AdM1N";
$lang['userpermpilloried'] = "pILLorI3D";

$lang['adminlogempty'] = "adM1N log 1\$ EMpTy";

$lang['youmustspecifyanactiontypetoremove'] = "j00 mU\$+ SP3CIpHy @N @c+10n TyPe +o ReMOv3";

$lang['alllogentries'] = "aLL loG eN+r13S";
$lang['userstatuschanges'] = "u\$eR 5+4+us cH@nG3S";
$lang['forumaccesschanges'] = "f0RuM @CcE\$S cH4NG3s";
$lang['usermasspostdeletion'] = "u53R m4\$S pO5+ dEL3ti0N";
$lang['ipaddressbanadditions'] = "iP 4Ddr35\$ B@N 4DDIti0n5";
$lang['ipaddressbandeletions'] = "iP @dDRe\$\$ BaN dEl3tIonS";
$lang['threadtitleedits'] = "thrE@d T1+lE 3D1+\$";
$lang['massthreadmoves'] = "m4S\$ +hrE4D MoV3\$";
$lang['foldercreations'] = "fOLdEr cReATioNs";
$lang['folderdeletions'] = "f0lD3r D3L3TIoN\$";
$lang['profilesectionchanges'] = "pROPh1l3 Sec+IOn cH4NgE5";
$lang['profilesectionadditions'] = "proF1Le S3C+10n 4DDiTiOns";
$lang['profilesectiondeletions'] = "pr0filE SECT1ON DeLE+10n\$";
$lang['profileitemchanges'] = "pR0ph1lE 1+3M cH@Ng35";
$lang['profileitemadditions'] = "pr0ph1l3 iTEM 4Dd1+10nS";
$lang['profileitemdeletions'] = "pR0ph1Le I+3m d3lE+10N\$";
$lang['startpagechanges'] = "s+4RT p@93 CH4Nge\$";
$lang['forumstylecreations'] = "foRum \$tYLe cr34T1Ons";
$lang['threadmoves'] = "thR34d Mov35";
$lang['threadclosures'] = "thr34d Cl0sUR3S";
$lang['threadopenings'] = "thrE@d 0PEN1Ngs";
$lang['threadrenames'] = "thr34D ReN@MEs";
$lang['postdeletions'] = "p0S+ D3L3+10nS";
$lang['postedits'] = "p05t 3D1T5";
$lang['wordfilteredits'] = "woRD f1l+3R 3DI+5";
$lang['threadstickycreations'] = "tHRE@D s+1cKy cRe@T10Ns";
$lang['threadstickydeletions'] = "thrEAd \$ticKY DElE+10n\$";
$lang['usersessiondeletions'] = "u53R 535\$10N D3Le+10NS";
$lang['forumsettingsedits'] = "forUM sEt+In9\$ 3D1+\$";
$lang['threadlocks'] = "thREAd LoCKs";
$lang['threadunlocks'] = "tHRe@D UNl0cK\$";
$lang['usermasspostdeletionsinathread'] = "u\$ER ma\$\$ P0St dElET1oN\$ 1N @ THREAd";
$lang['threaddeletions'] = "tHR3@D Del3TIOnS";
$lang['attachmentdeletions'] = "at+4chm3N+ dEL3T1ONS";
$lang['forumlinkedits'] = "f0RUm L1NK 3DiT5";
$lang['postapprovals'] = "p0\$+ 4PProv4l5";
$lang['usergroupcreations'] = "usER gROuP cR34TION5";
$lang['usergroupdeletions'] = "us3r gr0UP D3LE+1ON\$";
$lang['usergroupuseraddition'] = "u\$3R gR0up U\$3R @Dd1+I0N";
$lang['usergroupuserremoval'] = "uSER 9ROuP U53r REm0VAl";
$lang['userpasswordchange'] = "u5eR P@sSWOrD cH4N93";
$lang['usergroupchanges'] = "u\$3r gr0UP chanG35";
$lang['ipaddressbanadditions'] = "iP @DdRess 84n 4DD1+10n5";
$lang['ipaddressbandeletions'] = "ip 4DDR35\$ B4N D3L3TI0N\$";
$lang['logonbanadditions'] = "lOGOn b@n @DD1+I0nS";
$lang['logonbandeletions'] = "logon b@N D3L3TION\$";
$lang['nicknamebanadditions'] = "nIckN@mE B@N @dD1+ionS";
$lang['nicknamebanadditions'] = "nickn4m3 8@N AdDITiONS";
$lang['e-mailbanadditions'] = "e-M@iL bAN 4DdITiONS";
$lang['e-mailbandeletions'] = "e-mAiL 84n dEl3tiOn\$";
$lang['rssfeedadditions'] = "rS5 PHe3d 4dD1+IoN\$";
$lang['rssfeedchanges'] = "r5\$ FeEd ch4ngES";
$lang['threadundeletions'] = "thr3@D UnDElEtION\$";
$lang['httprefererbanadditions'] = "h++P r3fEr3R 8@N @DDiTION\$";
$lang['httprefererbandeletions'] = "h++P rEF3R3r B4N d3l3tIonS";
$lang['rssfeeddeletions'] = "r5\$ f3eD dEL3tioNs";
$lang['banchanges'] = "b4N ch4ng3S";
$lang['threadsplits'] = "tHR3@D \$PL1T\$";
$lang['threadmerges'] = "thR34D MergE\$";
$lang['userapprovals'] = "u\$eR 4PProVaLs";
$lang['forumlinkadditions'] = "f0rUM lINk @dDI+IOns";
$lang['forumlinkdeletions'] = "f0rUm L1nk D3l3tiON\$";
$lang['forumlinktopcaptionchanges'] = "fORUM l1nK TOP c4PTion cH4NG35";
$lang['folderedits'] = "foLDEr Ed1+s";
$lang['userdeletions'] = "u\$eR D3LEt1oNs";
$lang['userdatadeletions'] = "usER d4ta dEL3+10n\$";
$lang['forumstatsautoupdates'] = "f0rUM \$+@+S @U+o UpD@T3S";
$lang['forumautothreadunreaddataupdates'] = "f0rUM 4UT0 +hrE4d UnR34D D4T@ uPD@TE\$";
$lang['usergroupchanges'] = "u53R Gr0UP cHang35";
$lang['ipaddressbancheckresults'] = "ip @dDr3Ss 84N cH3Ck R3SULt\$";
$lang['logonbancheckresults'] = "l0GoN 84N cHeCK RE\$ulTs";
$lang['nicknamebancheckresults'] = "nicKn@M3 8@N CHeCK r3sULT\$";
$lang['emailbancheckresults'] = "eM41L 8an cH3cK r35uLT\$";
$lang['httprefererbancheckresults'] = "hTtP REPhERer b@N CH3Ck r3sUl+\$";

$lang['removeentriesrelatingtoaction'] = "rEm0v3 eN+R135 R3l4TIn9 TO Act10n";
$lang['removeentriesolderthandays'] = "r3mOVE ENtr1E\$ 0LdER +H4N (D4y\$)";

$lang['successfullyprunedadminlog'] = "suCcESsfULLY pRUn3d @dM1N lo9";
$lang['failedtopruneadminlog'] = "f41L3D +0 PrUN3 4dM1N L0G";

$lang['prune_log'] = "pruN3 Lo9";

// Admin Forms (admin_forums.php) ------------------------------------------------

$lang['noexistingforums'] = "n0 3xIST1N9 Ph0rUM\$ PH0UnD. tO CRE@T3 4 N3W PHORum cL1ck +H3 'ADD nEW' bU+t0N bEl0w.";
$lang['webtaginvalidchars'] = "w38T@9 c4n OnLY C0N+4In UPpErC4s3 @-z, 0-9 4Nd UnDersC0Re cH4R4C+3r\$";
$lang['databasenameinvalidchars'] = "d4TAb453 N@m3 C4N 0NLY c0Nt@1N 4-Z, 4-Z, 0-9 4ND UNDER\$C0Re ch@R4CT3R\$";
$lang['invalidforumidorforumnotfound'] = "iNv@l1d F0RUM F1D oR pH0RUM NO+ Ph0unD";
$lang['successfullyupdatedforum'] = "sUCC3\$\$PHUlLY UPd4T3D pHOrUM";
$lang['failedtoupdateforum'] = "f4ilED +o UpD4+e Ph0rUm: '%s'";
$lang['successfullycreatednewforum'] = "sUCcEs\$pHULLy cr34+Ed n3w F0RuM";
$lang['selectedwebtagisalreadyinuse'] = "teH SEl3cTeD w3Bt49 1\$ 4lR34DY 1N U5e. pLe4S3 ChO0\$E 4N0Th3r.";
$lang['selecteddatabasecontainsconflictingtables'] = "tEh \$3LEC+3D d4T484s3 coN+@1Ns CoNPhL1C+1N9 t4bL35. cONfL1ctING TA8LE nAm3\$ @R3:";
$lang['forumdeleteconfirmation'] = "arE j00 sUr3 j00 W@nT +O D3lE+3 @Ll Of Th3 \$3L3ct3D Ph0RUMs?";
$lang['forumdeletewarning'] = "pLE4sE NOTE +H4t J00 c4nN0+ ReC0v3r dele+ED PH0RUMs. oNCe d3L3TeD @ PhORUm And 4LL 0pH iT'\$ 45\$0c1@t3D d@T4 IS P3RM4NenTLy R3Mov3D phRom th3 d4t484s3. 1F J00 do nOt WisH +o DELe+E +eh 53l3CT3D PH0RumS ple@SE clIcK c@ncEL.";
$lang['successfullyremovedselectedforums'] = "suCc35\$phULlY D3L3TeD \$EL3C+3D FOrUM\$";
$lang['failedtodeleteforum'] = "f4iL3D +O dElE+3D PH0RuM: '%s'";
$lang['addforum'] = "adD ForUm";
$lang['editforum'] = "eD1+ PhORUm";
$lang['visitforum'] = "v1\$i+ pH0Rum: %s";
$lang['accesslevel'] = "acC3\$\$ l3VEl";
$lang['forumleader'] = "f0rUM lEaD3r";
$lang['usedatabase'] = "usE d@T4B@se";
$lang['unknownmessagecount'] = "unkN0wn";
$lang['forumwebtag'] = "fORUm WeBT@9";
$lang['defaultforum'] = "d3f4ul+ FORUm";
$lang['forumdatabasewarning'] = "ple4S3 eN\$ur3 j00 53LEcT +He C0RrEcT d4TAB@\$3 Wh3n creA+1N9 @ nEw F0Rum. oNCE CrE@t3d @ nEw f0RUM C4NNo+ 83 Mov3D b3tW33N 4V4IL@bl3 D4T484535.";

// Admin Global User Permissions

$lang['globaluserpermissions'] = "gl0B@l u\$er peRmiS5i0n5";

// Admin Forum Settings (admin_forum_settings.php) -------------------------------

$lang['mustsupplyforumwebtag'] = "j00 muST 5Upply a phoRUM W3Btag";
$lang['mustsupplyforumname'] = "j00 musT \$uPPlY 4 f0Rum N4M3";
$lang['mustsupplyforumemail'] = "j00 mu\$t 5UppLy 4 F0ruM EM4IL @DdReSs";
$lang['mustchoosedefaultstyle'] = "j00 MuS+ ch00sE 4 d3pH@uL+ f0RuM s+Yl3";
$lang['mustchoosedefaultemoticons'] = "j00 MuST cH0o\$3 DEph4Ul+ PHorUM 3MOTiCoNs";
$lang['mustsupplyforumaccesslevel'] = "j00 mUsT \$upply 4 PhoRUm @ccE\$s LEV3L";
$lang['mustsupplyforumdatabasename'] = "j00 mus+ sUPpLY 4 FORum D4T4B@SE N4M3";
$lang['unknownemoticonsname'] = "unknoWN EMOtic0NS N@Me";
$lang['mustchoosedefaultlang'] = "j00 MUsT cHOoS3 4 dEF@ULt F0RuM l4n9u49E";
$lang['activesessiongreaterthansession'] = "activE 53sS10n +1M3oUT C@NNOT B3 Gr3a+3r +h@N \$E55Ion +IM30U+";
$lang['attachmentdirnotwritable'] = "a++4cHMent D1R3CtoRY aND \$YS+eM t3mpoR4RY DIReC+oRY / pHP.1ni 'UPL0@d_TmP_d1r' MU5+ 83 wr1+@bLe by TH3 w3B \$ErvEr / PHP pRoC35s!";
$lang['attachmentdirblank'] = "j00 Mu5+ SuPpLY @ d1r3Ct0ry t0 s@V3 4T+@ChMEnT5 1N";
$lang['mainsettings'] = "m@1n 53tTinGS";
$lang['forumname'] = "forUM NAm3";
$lang['forumemail'] = "fORUM Em@Il";
$lang['forumnoreplyemail'] = "no-rePLY 3M@1l";
$lang['forumdesc'] = "f0rUm dE5Cr1p+10n";
$lang['forumkeywords'] = "fOrUM K3YW0rdS";
$lang['defaultstyle'] = "dEph4ulT \$+YL3";
$lang['defaultemoticons'] = "d3f@UlT 3mo+1C0N5";
$lang['defaultlanguage'] = "d3fAUl+ l4nGU@gE";
$lang['forumaccesssettings'] = "fOrUm 4CCe\$S se+t1n9\$";
$lang['forumaccessstatus'] = "fORUm Acc35\$ stA+Us";
$lang['changepermissions'] = "cH@nG3 PeRM1SS1oNS";
$lang['changepassword'] = "chaN9e p4ssw0RD";
$lang['passwordprotected'] = "p4\$\$w0rD PR0+3C+eD";
$lang['passwordprotectwarning'] = "j00 HaV3 not \$3t 4 PH0RUM p4\$sw0RD. If J00 DO NoT \$e+ 4 P@ssW0Rd TEH P@SSW0Rd PROT3ct1On phuNCtIOn@L1TY w1ll 83 4u+0m4+Ic@LlY diS48l3D!";
$lang['postoptions'] = "pOST oP+10ns";
$lang['allowpostoptions'] = "allOW p0ST 3DITiN9";
$lang['postedittimeout'] = "p0s+ eD1+ TimE0Ut";
$lang['posteditgraceperiod'] = "pO5+ ED1+ Gr4c3 pER1oD";
$lang['wikiintegration'] = "w1k1w1k1 1nT39r@+10n";
$lang['enablewikiintegration'] = "eN48lE wIk1wik1 1NT39R@t10n";
$lang['enablewikiquicklinks'] = "enA8l3 W1K1W1k1 qUIcK L1NK5";
$lang['wikiintegrationuri'] = "wIk1WIKI lOC@TioN";
$lang['maximumpostlength'] = "m4x1mUm P0ST l3n9th";
$lang['postfrequency'] = "p05t PHrEQuENCy";
$lang['enablelinkssection'] = "en48le lINk5 \$EcT10n";
$lang['allowcreationofpolls'] = "aLL0W cR3@TIoN 0f P0LLS";
$lang['allowguestvotesinpolls'] = "aLL0w 9UesTs +O vot3 1N PoLLS";
$lang['unreadmessagescutoff'] = "uNR34d mE\$\$@9ES cu+-0phF";
$lang['disableunreadmessages'] = "dI\$a8lE uNR34D meS\$493s";
$lang['thirtynumberdays'] = "30 D4YS";
$lang['sixtynumberdays'] = "60 DAY\$";
$lang['ninetynumberdays'] = "90 D@y\$";
$lang['hundredeightynumberdays'] = "180 D4Y5";
$lang['onenumberyear'] = "1 y34R";
$lang['unreadcutoffchangewarning'] = "dEpEnDIng On SerVeR pERPhORm4nCE 4nD t3h nUMB3R OPh ThrE@D\$ y0ur PhoRum\$ coN+4in, CH@n9IN9 Th3 unR34D cU+-oFPH m@Y +4kE 53VER@L m1nU+35 +O cOMPlE+e. fOR tHI5 RE4\$oN 1T 1\$ R3C0MM3ND3D +H4+ j00 AVO1D CH4nGinG Th1\$ SE++1N9 WH1L3 yoUr Ph0rUM\$ @RE BUsY.";
$lang['unreadcutoffincreasewarning'] = "iNcr34siNg THe uNREaD cu+-Off w1ll R35uL+ in +Hr34D\$ OLdEr +h4n +EH CuRRen+ CU+-ofPh 4pP3@r1n9 4\$ unreAD pHOR 4LL u53r\$.";
$lang['confirmunreadcutoff'] = "ar3 J00 5UR3 j00 w@Nt t0 Ch@Ng3 T3H unRe@D cuT-oFF?";
$lang['otherchangeswillstillbeapplied'] = "cL1ckING 'NO' W1ll 0nLy C4NCEL +HE UNReAd CU+-0FPH chAn93s. oTh3r cH4ng35 y0u'V3 madE W1LL 5t1lL 83 5@VED.";
$lang['searchoptions'] = "se4RCh 0P+ioN\$";
$lang['searchfrequency'] = "sE4rCH FR3qUeNcy";
$lang['sessions'] = "se\$\$10n5";
$lang['sessioncutoffseconds'] = "s3ss1ON CUT 0FPH (S3COnDS)";
$lang['activesessioncutoffseconds'] = "acT1V3 \$3sS10N cUt 0FPh (\$ecoNd\$)";
$lang['stats'] = "s+4+5";
$lang['hide_stats'] = "h1De ST4T\$";
$lang['show_stats'] = "shOw \$+4T5";
$lang['enablestatsdisplay'] = "eN4bl3 5+4t5 D15PLaY";
$lang['personalmessages'] = "peRs0N4L mE\$\$@9e\$";
$lang['enablepersonalmessages'] = "eN4blE PErSON@l MEs\$49e\$";
$lang['pmusermessages'] = "pM mEs\$aGEs PeR u\$ER";
$lang['allowpmstohaveattachments'] = "aLl0W p3r\$0NAl M3sS493s t0 h@V3 4T+@chMenT\$";
$lang['autopruneuserspmfoldersevery'] = "aU+0 PrUN3 Us3R'\$ PM PH0ldErs eV3RY";
$lang['userandguestoptions'] = "uSER 4nD 9u3\$+ 0p+ION5";
$lang['enableguestaccount'] = "eN4BL3 GuE5t @CcouNT";
$lang['listguestsinvisitorlog'] = "lIS+ 9U35+s 1N Vi5IT0r LO9";
$lang['allowguestaccess'] = "alloW 9uE\$+ 4CCESS";
$lang['userandguestaccesssettings'] = "u53r ANd 9U3ST @Cc3s5 Se++1n95";
$lang['allowuserstochangeusername'] = "aLLow Us3RS tO Ch4N9E U53RN@ME";
$lang['requireuserapproval'] = "r3qUir3 u\$eR 4PPRovAl 8Y 4Dm1n";
$lang['requireforumrulesagreement'] = "r3Qu1rE us3r +O 49rEe +O ForUm ruLEs";
$lang['sendnewuseremailnotifications'] = "seNd NOtIpH1C@T1ON +0 gLO8@L ForUM OWnEr";
$lang['enableattachments'] = "eN48lE @tT@CHmENTS";
$lang['attachmentdir'] = "a++4chM3n+ D1R";
$lang['userattachmentspace'] = "aT+@cHMenT 5pAcE peR u\$3r";
$lang['allowembeddingofattachments'] = "aLl0w 3MbEDdINg Of 4+TACHMeNt5";
$lang['usealtattachmentmethod'] = "u53 4LT3Rn@TiV3 4T+4ChmENT mEtH0D";
$lang['allowgueststoaccessattachments'] = "aLL0w 9U3sTS +o AccE\$\$ 4T+4chM3n+S";
$lang['forumsettingsupdated'] = "f0Rum \$3T+INg\$ SuCc35\$fULlY uPd4T3D";
$lang['forumstatusmessages'] = "f0rum S+4tU5 M3sS49E\$";
$lang['forumclosedmessage'] = "f0RUM CLosEd m35s@93";
$lang['forumrestrictedmessage'] = "fORUm RE\$+RIC+3D m35\$@93";
$lang['forumpasswordprotectedmessage'] = "f0RUm p4\$sW0Rd pR0T3C+3d M35s@93";

// Admin Forum Settings Help Text (admin_forum_settings.php) ------------------------------

$lang['forum_settings_help_10'] = "<b>pO\$t ed1+ +1me0ut</b> Is +3h time 1N M1nu+3S 4pHtER pOsTInG tH4T a u5er c@N Ed1+ ThEIr Pos+. 1F \$3T +0 0 ThERe 1s N0 LImIT.";
$lang['forum_settings_help_11'] = "<b>m4X1mum P0ST l3ngTh</b> i\$ +He M@x1mUm NUm8er 0pH CH4r4C+3r\$ th4+ wILl B3 dIspL4YEd 1N A P0sT. 1F 4 POs+ is L0N9ER +h4N +HE NUM8Er 0f cH@rACt3r\$ D3Ph1n3D H3R3 I+ w1LL 83 cU+ 5h0r+ 4Nd 4 LInk @DDeD +O +3h bOT+0m t0 @LloW USeRs +o r34D +Eh Wh0lE p0sT oN 4 \$3P@R4tE P@9E.";
$lang['forum_settings_help_12'] = "iPh J00 DOn'T W@n+ y0uR u\$3r\$ T0 83 48lE tO cR34tE p0llS j00 c4N d15able +eH 4BOv3 OPt1ON.";
$lang['forum_settings_help_13'] = "the L1NK5 SeCt1oN of B33hIvE pr0vIdE\$ 4 Pl@C3 f0r YOUr Us3rS +0 M@iN+41n 4 l1\$+ 0pH \$1+35 THeY fR3QU3NTly V1\$1t thA+ othEr USERS M@Y fINd U53FUL. LinK5 c@N 83 D1v1DEd 1NT0 c4t390riE\$ By FolD3R 4nD @lLoW Ph0r c0mM3n+s 4nd R4+1N9\$ T0 bE 9IVEN. 1n 0RD3r T0 M0D3R4+3 +3h liNK5 53c+ION @ useR MusT 83 r4n+Ed 9l0B4l moD3r4+OR 5T4+US.";
$lang['forum_settings_help_15'] = "<b>s35\$IoN CUt 0FPh</b> iS tHE m4X1MUm +1M3 83f0r3 4 Us3r'\$ \$35\$1ON 1\$ D3eM3D D3@D @Nd THeY 4Re L0993D OUt. 8Y d3f@UL+ Th1S iS 24 H0UR\$ (86400 \$3C0nd5).";
$lang['forum_settings_help_16'] = "<b>ac+1v3 \$3ss10N cU+ 0phpH</b> 1\$ t3h M4x1mum +IM3 83FORe 4 U\$eR'5 seSS1ON i5 d33M3D 1n@c+1V3 A+ wh1cH p01nt +H3Y 3N+3r AN IDL3 \$+4tE. 1n +hIs St4tE tEH u\$3R REM41NS Lo9g3D iN, 8uT ThEy 4r3 r3m0v3D phR0M TeH 4Ct1vE U\$3R\$ lIst IN +He 5+4+\$ dISPl@Y. ONcE +HEy b3cOME @C+iVE 4G41n +HEy WILl Be R3-4Dd3d +O +eH LIst. bY DeFaulT TH1S Se++INg IS 53t t0 15 M1nUte5 (900 53CONDs).";
$lang['forum_settings_help_17'] = "eN4bl1N9 +H1S OP+iON 4llOw\$ B33HIv3 +0 iNcLUde 4 st4ts D1\$PLAy 4T th3 b0+T0m 0PH +3H ME\$S49E\$ P4n3 51M1L@R +O +He OnE Us3d 8y M@nY ph0RUm S0F+W4R3 +1TL35. 0ncE eN@bL3D +3H d1spl4y Of +H3 ST4TS p49E CAn 83 +O9glED ind1v1DU@LLy by E@cH UsER. Iph +hEY DOn'T WAN+ t0 SE3 1+ +h3Y c4N HiDE 1+ PHR0M VIew.";
$lang['forum_settings_help_18'] = "pERS0N4L mEs\$a9E5 ar3 Inv4LU@8L3 @S @ w@Y 0F t4kIng m0r3 prIv4Te M4Tt3RS oUT 0ph VI3W 0F The 0+HeR M3M83R\$. h0WEvER IPh j00 D0N'+ w@N+ y0UR uSER\$ +o 83 @bl3 +o \$3Nd 3@ch 0Th3r pER5On@l Me\$\$49es j00 c@N DIs@8LE tHIS op+10n.";
$lang['forum_settings_help_19'] = "p3RSOn4l Me\$s4gES c4n alSo C0N+@IN A+tAcHmENT\$ WH1Ch C4N bE uSepHUL pH0R 3xcHAn9iNg Ph1lE\$ 8ETw3eN u5Ers.";
$lang['forum_settings_help_20'] = "<b>n0+E:</b> th3 5P4Ce @lLOcA+i0N pH0r pm A++4CHm3n+s 1\$ TAken FrOM 34CH U\$eR\$' M41N 4T+@CHm3n+ 4LLOca+10n ANd 1\$ nOT 1N @DD1T1ON +0.";
$lang['forum_settings_help_21'] = "<b>eN@8le GUeST 4cC0UNt</b> 4LLOW5 ViSIt0r\$ T0 8ROW\$e y0ur pH0rUm AnD rE4D Po5Ts WItHOuT r3giSTeRIn9 @ u\$3R 4cC0UN+. a U5ER 4cc0unT 1\$ 5+1LL R3Qu1r3D 1F +HEY WIsH +o poST oR Ch@Ng3 USeR Pr3F3R3Nc3s.";
$lang['forum_settings_help_22'] = "<b>li\$T Gu3S+\$ 1n vis1+or lO9</b> 4lloWs j00 T0 \$PEc1PHy WH3tH3r Or NO+ uNRe91s+EreD US3rs 4RE L1STED On Th3 VI51+0R l09 @l0nG S1DE rE91\$+erED USeRs.";
$lang['forum_settings_help_23'] = "bEeHIV3 4LLOws @T+@cHM3N+S +0 8E UPL04DEd T0 mE\$\$a93S wH3N po\$+Ed. IPh J00 H4Ve Lim1TEd WeB sP@C3 J00 M4y wHIcH t0 D1\$a8LE 4++4chMEnTS BY CLeAR1N9 Th3 8ox @BoVe.";
$lang['forum_settings_help_24'] = "<b>aT+4CHmeN+ D1R</b> iS t3h L0C4+I0N bE3HivE 5h0ulD \$+oR3 It'\$ 4Tt@chmENt\$ 1N. tHI5 diR3CtoRY mU\$+ ex1\$+ 0n yOUr W38 5p4C3 AnD mu\$+ 8e wRI+4BlE by t3h W38 5eRVEr / PHp PrOC35\$ 0tH3rwi5E uPLO4D\$ wIll pH41l.";
$lang['forum_settings_help_25'] = "<b>a++4cHm3N+ SPaCE per u5er</b> 1\$ +HE M4xIMuM 4M0UNT 0F dISK SpaCe @ USeR h4s PHOr @T+@cHMeNt\$. 0NcE ThIS \$p4C3 1s US3D uP tH3 usEr C@NN0+ uPLo4d 4nY M0RE @T+@CHmENt5. by d3PH4uLt TH1\$ 1s 1MB Of Sp4cE.";
$lang['forum_settings_help_26'] = "<b>aLL0w eM8EDd1N9 of @TT4CHmEnT\$ In MeSs49Es / S1Gn4tuR3S</b> @ll0wS u\$ERS t0 Em83D A+t4Chm3N+S 1N pOstS. EN48lIn9 TH1s 0pt10N WhIlE uS3pHuL c@N iNcRe4\$e YouR 84Ndw1dth Us@9E dR4\$+1C4llY uNdER CerTaiN C0NFi9urAtiONs OPH PHp. 1pH j00 H4vE liM1+3D 8@NdWiDth 1+ 1s reC0mMEnDED tH4+ J00 D154blE +h15 op+Ion.";
$lang['forum_settings_help_27'] = "<b>u\$E 4LT3RN@+IVE 4+tachmEN+ M3tHoD</b> PHORCe5 B3ehivE To Us3 4N 4LT3Rn@TiV3 R3TriEv4l M3ThoD f0R 4+T@CHmENtS. iF j00 r3c31VE 404 3RRoR m3SS4G3\$ wH3n tRY1N9 +o dOWnL0@d @t+4CHm3n+S FR0M mE\$\$49Es tRY 3n48L1N9 +HiS 0P+1on.";
$lang['forum_settings_help_28'] = "theS3 SEt+1n9s @lLowS y0uR Ph0rUm +o bE spID3reD by sE@RCh 3N9INe\$ Lik3 9oO9Le, 4ltAV1\$t4 @nD y4H0o. 1F J00 Sw1+CH +Hi\$ 0pTioN oFPh YoUR f0RUM WIlL n0+ 83 inclUDEd iN Th3Se S34rCH 3NG1Ne5 R3suLt5.";
$lang['forum_settings_help_29'] = "<b>aLl0W N3W U5Er Re9i\$+R4TIOnS</b> ALL0W\$ 0R dIS4LL0w\$ +He CrE@+I0n oF NeW u\$3R @CC0UN+5. 5ET+1nG t3h 0PTIoN T0 N0 c0mPL3T3Ly D154BL3s ThE r3gi5+r4tION PH0RM.";
$lang['forum_settings_help_30'] = "<b>eN4bL3 WiK1W1KI 1NTE9RA+10n</b> pR0V1D3S WikIw0RD \$uPporT 1n Y0UR FoRUm posT\$. a wiK1wORd IS m@d3 UP 0f +wo 0r mOR3 c0nC4tEn4teD W0Rd5 w1TH uPpERc@\$E lE+TER5 (0F+en r3pHerrED +0 AS c@M3LC@\$3). 1Ph J00 WR1+E @ WoRD th15 wAy It W1LL aUT0mA+1C4LLy 83 CH@N9ED 1N+0 A hyp3Rl1nK po1n+Ing T0 Y0Ur ch053n WIk1wikI.";
$lang['forum_settings_help_31'] = "<b>eNa8Le W1K1W1K1 Qu1CK l1nKs</b> En@bL35 +hE US3 0pH m\$9:1.1 4ND US3R:L09oN 5+yL3 exTEnD3D wikIL1NKS wHiCH CRE@+e HYp3RL1nK5 T0 +3H \$PEcIph13d Me\$s4gE / uSER pRopH1L3 0F +h3 \$p3CiPHI3D useR.";
$lang['forum_settings_help_32'] = "<b>w1kiwiK1 L0C4T1ON</b> 1\$ u5ed T0 \$P3CIPhY th3 Ur1 0F y0uR w1k1w1ki. whEn En+3RIn9 +EH URi Us3 <i>%1\$S</i> +o iNDiC@tE wh3R3 1N T3H uRI +H3 WikIwOrd SH0ULd 4PP34R, i.3.: <i>h++p://3n.W1KIp3dI@.0RG/WiKI/%1\$s</i> w0uld L1nK YoUR wik1words +O %s";
$lang['forum_settings_help_33'] = "<b>foRum 4cCeSs \$+4tUs</b> c0NTrOL5 HoW USeRS m4Y 4Cc35\$ YOur FORUM.";
$lang['forum_settings_help_34'] = "<b>oP3N</b> W1LL 4Ll0w @ll uS3r\$ 4Nd GuESts 4CCESS +o YoUR fORum w1thOu+ r3S+rIC+10n.";
$lang['forum_settings_help_35'] = "<b>cL0S3d</b> pr3VEn+5 4CCeS\$ FOR @Ll Us3RS, W1TH t3H 3xCePTioN oF t3h 4DM1N Who m@y St1lL 4CC3\$s TH3 @dm1n p@Nel.";
$lang['forum_settings_help_36'] = "<b>r35+R1CT3D</b> 4lLowS +0 53T @ l15+ Oph UsErS wHO @R3 4lLoWEd @cc3SS +o yOUr ForUm.";
$lang['forum_settings_help_37'] = "<b>pa5\$WORd Pr0teC+3d</b> aLl0w5 J00 T0 \$e+ 4 p45SW0RD T0 G1V3 0U+ +0 uSERs \$O +hEY c@N 4cC35s y0ur f0rUM.";
$lang['forum_settings_help_38'] = "wheN sE++1NG r35tRIc+eD 0r p4SswoRd PR0T3C+3D m0De J00 WIll nE3D T0 54Ve Y0Ur CHaN93s B3PH0RE j00 c4n Ch4Ng3 +HE U\$eR 4cCE5\$ PR1V1L393\$ 0R p4sSWORD.";
$lang['forum_settings_help_39'] = "<b>Search Frequency</b> defines how long a user must wait before performing another search. Searches place a high demand on the database so it is recommended that you set this to at least 30 seconds to prevent \"search spamming\"fRoM k1lL1NG tH3 \$3rV3R.";
$lang['forum_settings_help_40'] = "<b>pO\$+ frEqU3NCy</b> Is +Eh min1mUM TIm3 @ Us3r muSt W4it BePh0r3 +H3Y can P0S+ 49aIN. +hiS 5et+1nG @LSO 4phFec+\$ +h3 CR34+1oN OPh PolLs. \$3t +O 0 TO d1s4BlE T3h r3sTriC+I0N.";
$lang['forum_settings_help_41'] = "the @80v3 0PTi0ns ChAN9e +3H d3f4ulT V4LU3\$ F0R +H3 USeR r391\$+r@+1on PhORM. wheR3 4PPLicAblE OtheR \$e+t1n9\$ wIll u\$E +3H pHORUm'5 0wn dEph4Ul+ Sett1N9S.";
$lang['forum_settings_help_42'] = "<b>pr3V3n+ U5e oph dUPL1C4TE 3M@Il 4Ddre\$\$e5</b> PhoRCe\$ 833H1v3 to cHeck +H3 US3R @cC0Un+s @G41Nst +hE Em4Il 4ddr3sS +HE u5Er 1s RE91\$+er1NG w1th 4Nd PROMP+\$ TH3M T0 U5E @n0+hEr ipH 1+ 1\$ 4LR34dY 1n U\$E.";
$lang['forum_settings_help_43'] = "<b>reQuiRe EM4IL C0NFIrM4+1oN</b> WhEn En48lEd W1LL \$3Nd 4N em@iL tO e@Ch N3W us3R wI+h @ L1NK +hA+ c4n 83 U\$3D t0 C0NfIrM THeIR 3mAIl @DDR35\$. UnT1L +hEy C0NfIrM THeIR 3M41L adDReS\$ TH3Y WiLL N0T b3 @BL3 +o Post UnlES5 +HEIR U5Er PErm15510n\$ 4r3 CH4N93D MANu4LLy 8y 4N 4dm1n.";
$lang['forum_settings_help_44'] = "<b>use +3xT-c4PtCH@</b> prE\$3N+S tEh NeW usEr WItH 4 M@nGLeD 1MA93 wh1CH +HEy Mu5+ coPY 4 nUmbER fROm 1n+O 4 tExT pH13lD ON +He R391sTra+10n pH0RM. us3 +H1s opT1oN t0 PR3veN+ 4UTOm@+eD s1gn-uP V1@ ScR1pT5.";
$lang['forum_settings_help_47'] = "<b>p0S+ EDi+ 9R4C3 P3R10D</b> @LL0WS j00 +0 DePH1N3 @ p3rIOd 1N MINu+35 wHer3 U53rs m@Y 3d1t PO\$+s WIth0U+ +hE '3diTED BY' +Ex+ 4pPe4riN9 ON TH31R po5+s. IPh \$3t T0 0 Th3 '3diTeD BY' +Ex+ W1LL 4lW4Y\$ @pP34r.";
$lang['forum_settings_help_48'] = "<b>unr34D M35s49eS cUT-0fPH</b> \$P3CIPh13S H0W l0N9 mE\$S@G3\$ R3MAin uNRe@D. +hR34D\$ M0D1FI3D nO l4TEr ThAN tHE PErIOd \$el3ct3d W1Ll @uTOM4TiCAlLY 4pP34r @\$ R34d.";
$lang['forum_settings_help_49'] = "cHO0sIN9 <b>dI\$@bLE uNR34d Me\$S4gE\$</b> w1ll CoMPlE+elY REm0v3 UnRE4d Me55@9E\$ SuppoRt @Nd REMovE +Eh R3leV4NT op+10N5 fRom TH3 d15Cu\$\$Ion TYpE dr0P D0WN 0n +HE tHR34d L1\$+.";
$lang['forum_settings_help_50'] = "<b>r3qU1R3 U53R 4pPr0v@L by 4DMIN</b> @LLOwS j00 T0 R35TRICT acC355 By N3W u53R\$ UNtIl +hEY h4VE B3EN 4PPRoV3D bY @ M0D3rA+0r Or 4DM1n. w1+h0U+ 4pPR0vaL 4 u\$eR C@NnoT 4cC3S\$ 4NY 4Re@ 0F Th3 83EH1VE pH0rUm In5t4LL4t1ON iNcLUdINg 1ND1VIdUAl Ph0rum5, Pm INb0X @Nd My foruM\$ sECt10n5.";
$lang['forum_settings_help_51'] = "u\$E <b>cl0\$3d mE\$\$@93</b>, <b>rEs+R1CTED m35\$@93</b> @nD <b>p@5\$w0rD prOT3c+Ed M3sS49E</b> t0 cU\$t0mI\$3 +hE MeS\$493 D1sPL4YEd WHEn U\$3R5 4CcES\$ y0UR fORuM 1N +hE v4r10u5 5+4+E\$.";
$lang['forum_settings_help_52'] = "j00 C4N u\$3 HtML 1n YouR m3sS493S. hYP3Rl1nks @Nd em@1L 4dDReSse\$ WiLL @l\$O 8E @UT0M@T1c4lLy CoNVErTED +o L1nks. +0 U\$E +EH d3PH@uL+ 83eH1v3 PhoRuM mE\$\$493s cle@R +3H Ph13Ld5.";
$lang['forum_settings_help_53'] = "<b>all0w U53Rs t0 ch4n93 us3rN4me</b> pERmi+s AlrE4DY R39I\$+ErED USeR5 tO CHaN93 tHeIR U5ErNAM3. WH3N 3N4BL3D j00 c@N +r@cK T3H CHaN9E5 4 us3R mAK35 +o tHEiR U\$eRNaM3 V1@ tEH 4dM1n u\$ER to0LS.";
$lang['forum_settings_help_54'] = "u53 <b>fOrUM rUL3S</b> +0 3n+3R @N AcC3P+4bLe U5E PolIcy +h4t EaCH U\$3r mu\$+ 49r33 T0 8ephOR3 ReGI5+Er1n9 0n y0uR f0rUm.";
$lang['forum_settings_help_55'] = "j00 C4N uS3 HtML 1N Y0Ur PHoruM rULE\$. HyP3rLINk\$ 4nD 3m41L @DdrE\$ses w1Ll AlsO B3 Au+0M@+IC4LLy c0Nv3Rt3d t0 liNks. +0 USe Th3 D3pH@Ul+ B3EH1V3 foRum 4UP ClE4R +eH fi3lD.";
$lang['forum_settings_help_56'] = "u53 <b>nO-REPLY 3M@iL</b> to 5pEc1pHy 4N 3M41L 4DDrESs Th4t Do3s NOt 3xIST 0r W1lL n0t bE mON1+0ReD f0r r3pL13s. +HIs Em41L 4dDr3S\$ WiLl b3 U\$eD 1N +HE H3@D3r5 fOR @LL EMA1L5 53N+ pHRom yoUR fOrUM inClUdin9 BUt n0T L1M1t3d TO pOS+ @Nd PM NOTIpH1c4+iOns, USer em@1l\$ 4nD p4s\$w0rd R3m1ndERS.";
$lang['forum_settings_help_57'] = "i+ IS RecOMm3NdEd +H4+ j00 us3 @n Em4il aDDRe\$\$ Th4+ D0E\$ nO+ ExiSt TO H3lP cU+ DoWN 0N Sp@M +H4+ MaY 83 DIrEct3D @T YOUR m4in fOruM eM@1l @DDrES\$";
$lang['forum_settings_help_58'] = "in adDi+10n +0 51MPLE SP1D3RIn9, 8e3HIvE C4n 4l5o G3n3rA+3 @ 5itEm4p phOR tH3 foRuM +o MaKE IT 34S13r pHOr \$e4rCH 3ngInEs to fINd 4ND 1nDEx T3h mES\$493s pO5TEd 8Y YoUr UsEr5.";
$lang['forum_settings_help_59'] = "siteM4ps 4RE @UTom4tIc@LLy S4VEd +0 Th3 Si+Em4ps \$U8-DirEc+ORy Oph your 8eeHIV3 FOrUM 1nS+4lL@t1oN. 1f ThiS dir3ctOry D0E\$n't 3xIST j00 mUst cRE4+E IT @nd ENSur3 +H4+ 1+ 15 WRI+a8le 8Y +h3 53RV3R / pHP Pr0CES\$. +o 4lLOW \$34RCh 3N9iNeS T0 FInD yoUR s1+3M4P j00 MU\$+ 4dd tHE urL T0 yOur ROboTs.TX+.";
$lang['forum_settings_help_60'] = "dePeNdiNg On \$ERVeR PeRForM4Nce 4nD +H3 NUM83R 0F f0rum5 4ND tHRe4d\$ Y0UR 83EhIV3 1NST@LL@T1On CON+@1n\$, G3NeR4T1NG 4 5I+3M4P m@Y T4KE S3Ver4L M1NUtES T0 coMpl3TE. IpH P3rPhoRm4nc3 0pH y0UR S3Rv3r 1\$ 4DV3R\$ly @PHpH3C+3D 1+ 15 R3C0mmENd J00 dIs@bl3 g3ner@T10n 0Ph +Eh \$iT3m@P.";
$lang['forum_settings_help_61'] = "<b>seNd 3MA1L n0FI+1C4Ti0n T0 9LO8@L @dmiN</b> wHeN 3n48leD wILl SeNd @N 3M41l T0 tHE 9loB@l F0rUm OWNeR5 Wh3n @ N3W USer 4cCOUnT i5 CR34t3d.";

// Attachments (attachments.php, get_attachment.php) ---------------------------------------

$lang['aidnotspecified'] = "a1d NOt \$PeC1pH1Ed.";
$lang['upload'] = "upl04D";
$lang['uploadnewattachment'] = "uPL04D NeW 4T+@chmEnT";
$lang['waitdotdot'] = "waiT..";
$lang['successfullyuploaded'] = "sUCcES5pHuLLy UplO4d3D: %s";
$lang['failedtoupload'] = "f41leD tO UpLO4D: %s";
$lang['complete'] = "cOMPL3+3";
$lang['uploadattachment'] = "uPL0aD 4 FIle F0R 4+t@ChMENt TO tH3 M35s49e";
$lang['enterfilenamestoupload'] = "eNT3R fILeN@mE(5) +o uPL04D";
$lang['attachmentsforthismessage'] = "a+T4CHMEn+\$ F0r +hI\$ m3SS49e";
$lang['otherattachmentsincludingpm'] = "oTHER 4tt@cHM3n+s (InCLud1N9 PM MESS@9es 4ND 0th3R PH0ruMs)";
$lang['totalsize'] = "t0t@L \$iZE";
$lang['freespace'] = "fReE SP4C3";
$lang['attachmentproblem'] = "tH3re W4S 4 pRo8lEM dOWnLOaDIn9 +h15 4T+4CHMeNT. PlEAS3 +rY A941n La+3r.";
$lang['attachmentshavebeendisabled'] = "aTTAChMEn+S h4Ve b3EN D1\$ableD 8Y +hE PH0rUM Own3r.";
$lang['canonlyuploadmaximum'] = "j00 C@n oNLY UPl04D a M4x1muM OF 10 F1L3S 4t 4 +ImE";
$lang['deleteattachments'] = "d3lE+E 4TtacHmENTs";
$lang['deleteattachmentsconfirm'] = "ar3 j00 5ur3 J00 W@nT T0 DelE+e TH3 S3L3C+ED 4++4cHMeN+S?";
$lang['deletethumbnailsconfirm'] = "arE J00 suR3 J00 W4n+ T0 DeLe+e +HE SeLEct3d 4T+@ChM3NT\$ tHUm8N41l\$?";

// Changing passwords (change_pw.php) ----------------------------------

$lang['passwdchanged'] = "pA5\$w0rd CH4nG3D";
$lang['passedchangedexp'] = "yOUR p4\$sw0RD H4s 83EN CH4n9Ed.";
$lang['updatefailed'] = "uPD4+E PH@1LEd";
$lang['passwdsdonotmatch'] = "pa5sW0Rds dO noT m4+ch.";
$lang['newandoldpasswdarethesame'] = "n3W 4ND OlD p4sSWOrDS 4R3 Th3 s@mE.";
$lang['requiredinformationnotfound'] = "reQU1r3D inFoRM@+Ion N0T PhOUnD";
$lang['forgotpasswd'] = "fOR9OT p4ssw0Rd";
$lang['resetpassword'] = "r353T P4\$SW0rd";
$lang['resetpasswordto'] = "r3s3t p4s5w0RD T0";
$lang['invaliduseraccount'] = "inVALiD u\$3r @CcOuN+ \$PEcIf13d. CHecK 3M@iL pH0R cORrEcT l1NK";
$lang['invaliduserkeyprovided'] = "iNV@l1D u\$3R k3Y Pr0vId3D. CHECK 3m41l pH0R cORr3C+ l1NK";

// Deleting messages (delete.php) --------------------------------------

$lang['nomessagespecifiedfordel'] = "nO m35\$4g3 spEc1f1eD PH0R dele+10N";
$lang['deletemessage'] = "d3L3T3 MeSs493";
$lang['successfullydeletedpost'] = "sUCCESSPhULlY dEL3TeD pO5T %s";
$lang['errordelpost'] = "erR0r d3l3+1NG pOSt";
$lang['cannotdeletepostsinthisfolder'] = "j00 c4Nnot dElET3 po\$TS iN +h1\$ FolD3R";

// Editing things (edit.php, edit_poll.php) -----------------------------------------

$lang['nomessagespecifiedforedit'] = "no M3S\$4GE SpEc1PH13D pHOR 3Di+1N9";
$lang['cannoteditpollsinlightmode'] = "c4nNoT Ed1T P0lls 1N l1Gh+ MoDe";
$lang['editedbyuser'] = "ed1+3D: %s BY %s";
$lang['successfullyeditedpost'] = "suCC35\$pHulLy EdI+ED POST %s";
$lang['errorupdatingpost'] = "errOr UPD@+1n9 PoST";
$lang['editmessage'] = "eDIT m35s49e %s";
$lang['editpollwarning'] = "<b>nO+e</b>: eD1+Ing CeRT41n 45PECTS OF 4 pOll WiLL VO1D 4LL +He cuRr3NT v0t3s @Nd 4lL0W pEopLe T0 v0+3 4g@iN.";
$lang['hardedit'] = "h4rD 3dIt opTiOnS (v0+35 wiLl b3 Re53T):";
$lang['softedit'] = "s0F+ eD1+ oPT1ONS (v0+35 W1LL B3 R3t41NEd):";
$lang['changewhenpollcloses'] = "ch4N93 WhEN +3H p0lL CL0\$E\$?";
$lang['nochange'] = "no Ch4n9e";
$lang['emailresult'] = "eM@1L r3suLt";
$lang['msgsent'] = "meSs@g3 53nT";
$lang['msgsentsuccessfully'] = "m35S@gE sEN+ \$UcC35\$PhULly.";
$lang['mailsystemfailure'] = "m4Il \$y5+EM f41LUR3. me\$\$49e N0T \$3n+.";
$lang['nopermissiontoedit'] = "j00 4R3 not PErMiTt3d To eDi+ th1\$ M35\$@93.";
$lang['cannoteditpostsinthisfolder'] = "j00 C4NnoT 3d1t Po5t5 1n +HIS f0ldER";
$lang['messagewasnotfound'] = "m3ss493 %s wa\$ noT pH0uNd";

// Email (email.php) ---------------------------------------------------

$lang['sendemailtouser'] = "senD em@1L tO %s";
$lang['nouserspecifiedforemail'] = "no U\$3r 5pec1ph1ed FoR 3M41l1N9.";
$lang['entersubjectformessage'] = "enT3r @ sU8J3C+ Ph0r +He MEsS49E";
$lang['entercontentformessage'] = "enT3r \$0m3 cON+3N+ f0r tEH M35s@G3";
$lang['msgsentfromby'] = "tHiS M35\$4gE W@\$ 53N+ FrOM %s 8Y %s";
$lang['subject'] = "subJeCT";
$lang['send'] = "sENd";
$lang['userhasoptedoutofemail'] = "%s h4\$ op+3D 0u+ 0pH EM41l cONtACt";
$lang['userhasinvalidemailaddress'] = "%s HA\$ 4N InV4lId 3mAIL @DDR35\$";

// Message nofificaiton ------------------------------------------------

$lang['msgnotification_subject'] = "mE5\$@9E noT1PH1C4TioN FR0m %s";
$lang['msgnotificationemail'] = "h3lL0 %s,\n\n%s P0sT3D A ME\$5@9E T0 j00 on %s.\n\nTHe \$u8ject 15: %s.\n\nt0 r34d +ha+ M3Ss49E @nd 0tH3RS 1N TH3 \$4Me DiscUS510n, 90 +o:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nN0T3: If J00 do N0+ WisH +O r3C3IV3 3mail N0TIPh1C@TIoNS OF fORuM ME\$\$@9eS P0\$+ED To YOu, 90 T0: %s clIck 0N MY cOnTROLS tH3n Em@IL 4nd pR1V@Cy, un\$ELECt tEh Em41l N0+1FICA+iON cHEcK8ox 4nd Pr3\$s \$u8M1+.";

// Thread Subscription notification ------------------------------------

$lang['subnotification_subject'] = "su8\$crIpTiON n0tIPHiCA+10N Fr0m %s";
$lang['subnotification'] = "h3ll0 %s,\n\n%s P0S+Ed 4 m3Ss49E 1N 4 +HrE@d j00 H4v3 SUb\$CRi8eD +0 ON %s.\n\n+He SU8J3Ct I\$: %s.\n\nt0 R34D th4t m3SS493 AnD OTh3r\$ 1N t3h \$@M3 DiScUSS10N, 90 +o:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nn0t3: IPh J00 do NOt wi\$h t0 R3CEiv3 3M4iL N0TIfiC@+10nS of New meS\$4gE5 1n th1s +HRe4d, go +0: %s @nD @dJUS+ yOUR Int3Re5+ Lev3l 4+ +H3 Bott0m 0ph +3h p4g3.";

// PM notification -----------------------------------------------------

$lang['pmnotification_subject'] = "pM NO+IPhic4TIoN PHr0m %s";
$lang['pmnotification'] = "heLlo %s,\n\n%s P05+ED 4 Pm To J00 ON %s.\n\nTHe sUBjEc+ 15: %s.\n\nt0 R34D th3 M3S5a9E 9O t0:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nn0t3: ipH j00 D0 N0T W1SH +O rEC31VE 3M4IL nOT1F1C@+1ON\$ Of nEW Pm Me\$\$@93\$ p0\$tEd +0 YOu, go +0: %s CLiCK my c0NtRols tH3n em4il 4Nd prIVAcY, unS3LEct +eh Pm nOT1pH1C@+1ON cH3Ckb0X 4nd pr3\$\$ sUBm1t.";

// Password change notification ----------------------------------------

$lang['passwdchangenotification'] = "p@5\$W0Rd Ch4N93 Not1FIc@+10N fROM %s";
$lang['pwchangeemail'] = "h3LlO %s,\n\n+H15 4 N0tiPHiC4TIOn 3MAIl +O iNfORM j00 +H4T yOuR p@SSWOrd 0n %s H45 B3EN CH@N93D.\n\n1+ hAs bE3N cH4ng3d T0: %s 4nd WA\$ CH4NG3D By: %s.\n\n1Ph J00 H@v3 R3C31VEd +hI\$ Em@Il 1n 3rR0R 0r W3RE N0T ExP3C+in9 @ CH4n9E T0 yoUR p4sSW0RD PLe@Se C0NT4C+ +He FORum 0wn3R 0R 4 M0d3r4+OR 0N %s 1mM3DI@TelY T0 COrr3c+ I+.";

// Email confirmation notification -------------------------------------

$lang['emailconfirmationrequiredsubject'] = "eM4IL C0Nfirm@+iON R3QU1ReD f0r %s";
$lang['confirmemail'] = "helLO %s,\n\nyOu ReCeNTLy cr3@T3D a nEW U\$Er 4Cc0uN+ On %s.\n\n8EPH0re J00 c4N 5+@Rt P05+1N9 We NeEd T0 cONphIrM yOUR EM41l 4DdRES5. don'T woRRY +H1\$ 1s Qu1+E EAsy. 4ll J00 N3Ed +o Do I\$ cl1Ck TEh lINk 83l0W (oR COpy anD p4S+3 1T Int0 Y0Ur 8ROW\$Er):\n\n%s\n\n0NC3 c0NFirM4T10N I\$ c0mpl3TE J00 M4y L0gIN @ND \$t4RT POs+IN9 IMM3D1AT3Ly.\n\nipH j00 d1d N0+ CR34t3 A U53r 4CCOunt 0N %s PLE@\$e @cC3pT 0uR 4P0L091eS @Nd PHORw4Rd +HIS 3M4iL T0 %s \$0 THa+ TEH sOURce OpH 1+ M4Y b3 1NV3s+19A+3d.";
$lang['confirmchangedemail'] = "hEllo %s,\n\nyoU REcEnTLy chaN93d yOUr 3m41L On %s.\n\n8EphOr3 J00 C4N s+@Rt P0sTIN9 4941N W3 NEEd +O c0nfiRM Y0UR nEw 3MAil @DDrE\$\$. d0n'+ wORrY +H1S i5 QuI+e E45Y. ALL J00 N3ED +O do 15 Cl1Ck +eH lINK B3L0w (0R c0pY AND P4\$tE 1+ 1n+0 YOuR bROw\$ER):\n\n%s\n\nonCe C0nFirM4T1On is c0mple+3 J00 M@Y C0n+1nU3 T0 US3 +he PH0RuM 4\$ N0rM4l.\n\n1F j00 w3Re N0+ Exp3C+INg TH1S eMa1l Phr0M %s PLe@sE aCc3p+ ouR 4P0L09ie\$ @Nd pH0RWARd +H15 3m41L t0 %s \$0 Th4+ T3h 5ouRcE OF It m@y 83 1nvEs+1g@tEd.";

// Forgotten password notification -------------------------------------

$lang['forgotpwemail'] = "h3lLO %s,\n\nYOU REqUe\$Ted +hI\$ E-m41l fR0M %s 83C@U\$3 J00 H4vE PHoRGo++3N YoUr P@s5w0Rd.\n\ncL1CK TEh L1nK Bel0W (Or C0PY 4Nd P@S+3 1t 1nT0 YOuR 8ROW\$eR) t0 r35e+ y0ur P@s\$w0rD:\n\n%s";

// Admin New User Approval notification -----------------------------------------

$lang['newuserapprovalsubject'] = "n3W U\$eR 4ppRovaL nOTiPHic4t1On PH0R %s";
$lang['newuserapprovalemail'] = "Hello %s,\n\nA new user account has been created on %s.\n\nAs you are an Administrator of this forum you are required to approve this user account before it can be used by it's owner.\n\nTo approve this account please visit the Admin Users section and change the filter type to \"Users Awaiting Approval\"Or CL1cK +HE lInK b3l0W:\n\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nnoTe: otHEr 4Dm1nI5+r@Tor\$ oN +H1s Ph0rUM W1LL 4ls0 R3C31V3 tHIs N0+1PH1C@+1ON aND M@Y H4v3 4lR3@dY @ct3D uP0N tH1\$ ReQUes+.";

// Admin New User notification -----------------------------------------

$lang['newuserregistrationsubject'] = "n3w USer 4cC0Un+ NOtIPh1c4tioN phOr %s";
$lang['newuserregistrationemail'] = "hELL0 %s,\n\n@ N3W UsER @Cc0unt h4s b3eN cRea+3d 0N %s.\n\n+O vI3W +Hi\$ U\$3r @Cc0uN+ PL3453 V1\$1t TeH 4DmiN U\$3r\$ sEctIOn 4Nd cl1ck 0n +hE N3w u5eR OR Cl1cK +hE LInK bEL0W:\n\n%s";

// User Approved notification ------------------------------------------

$lang['useraccountapprovedsubject'] = "u\$ER aPPROV4l n0TIpH1C4TioN PH0R %s";
$lang['useraccountapprovedemail'] = "h3Ll0 %s,\n\ny0UR u\$eR @CCoUN+ 4+ %s h45 b33n @pProVeD. j00 c@N L0gin @nD \$+@R+ PO\$+1n9 1mMEd1@tLY BY CLICKInG tEH L1NK B3LOW:\n\n%s\n\niPh J00 WeRe N0T 3XPect1N9 ThiS EM41L PhROm %s PLe4\$E @Cc3pT 0ur 4PoLo9135 4ND pHOrW@rD tHis 3M4IL t0 %s \$0 +h4t T3h \$OURce 0ph 1+ m@Y B3 1nv35+i94+ed.";

// Admin Post Approval notification -----------------------------------------

$lang['newpostapprovalsubject'] = "p0S+ @pPRov4L nOT1fIcA+i0N For %s";
$lang['newpostapprovalemail'] = "h3LLO %s,\n\n@ N3W p0\$+ h@S 833n crE4T3D On %s.\n\n4S J00 4rE A mOD3R4T0r oN THI\$ fOrUM J00 4rE r3qU1R3D +0 4PPr0vE tH1s pO\$+ 83Ph0rE 1+ c@N bE rE4D bY OtH3R us3rS.\n\nyOu C@N aPPr0vE ThIS pOS+ 4nd @nY OtHErs pENdINg 4PPr0v4L BY v1siT1N9 +eH 4dMIn P05+ 4pProV4L 5ECt10N 0F YOur f0RUm oR 8Y CLIckIn9 +3H Link 83l0w:\n\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nn0Te: 0+hER 4DM1nIS+R4+Ors 0n +h15 Ph0RUM wILL 4LS0 REceive +H1\$ nOT1pH1C@T10n @Nd M4Y HAVe 4lREADy 4C+3d uP0n +His REqUE5+.";

// Forgotten password form.

$lang['passwdresetrequest'] = "yOUR P45\$w0rd Re\$E+ r3qUEs+ frOM %s";
$lang['passwdresetemailsent'] = "p4sSW0RD R353T 3-M@1l 53NT";
$lang['passwdresetexp'] = "j00 \$h0ulD \$hOrTly reCeiV3 4n 3-m41L cONt4iNIng 1nSTrUct1oNS phOr re\$E+t1ng y0uR Pa\$sWord.";
$lang['validusernamerequired'] = "a v4L1d USeRN@ME 1\$ r3qUIrEd";
$lang['forgottenpasswd'] = "forg0+ p45sw0rD";
$lang['couldnotsendpasswordreminder'] = "cOULd NOt \$ENd P4\$5WOrD rEM1NdER. PL345e CoNTACT TH3 foRUm OwNEr.";
$lang['request'] = "rEQU3\$t";

// Email confirmation (confirm_email.php) ------------------------------

$lang['emailconfirmation'] = "em4IL c0nFIrm4+1ON";
$lang['emailconfirmationcomplete'] = "tH@Nk J00 For c0nPh1rM1n9 YouR 3M@Il 4dDrE\$s. J00 m@y Now l0gIN 4nD \$+4RT p0s+1NG 1MmEd14+eLY.";
$lang['emailconfirmationfailed'] = "eM4IL COnpH1rm4+1on h@S FaILed, pl34sE tRY 4G@iN l4TEr. 1F J00 3NCOuN+3R +hIs ERR0R Mul+1pL3 t1m3\$ pl34SE C0nt4Ct T3H PH0rUM 0Wn3r or A M0D3rA+oR ph0r a\$\$1\$+4nc3.";

// Links database (links*.php) -----------------------------------------

$lang['toplevel'] = "top L3V3L";
$lang['maynotaccessthissection'] = "j00 M@y no+ ACcEs\$ THI5 5Ec+10N.";
$lang['toplevel'] = "tOp LeV3L";
$lang['links'] = "l1Nks";
$lang['externallink'] = "eXTERN4L lINk";
$lang['viewmode'] = "v13W MoDe";
$lang['hierarchical'] = "hIER4RchiC@L";
$lang['list'] = "liSt";
$lang['folderhidden'] = "tHiS FOlD3r Is H1DdEN";
$lang['hide'] = "h1d3";
$lang['unhide'] = "unH1DE";
$lang['nosubfolders'] = "n0 \$U8folD3R\$ 1N TH1S c4T390rY";
$lang['1subfolder'] = "1 5uBPhOLd3r In +h1s C@T3GORy";
$lang['subfoldersinthiscategory'] = "suBpHolDERS 1n Th1\$ c@+EGORy";
$lang['linksdelexp'] = "enTR13s 1n A D3l3T3D PH0ld3r WILl BE MoV3D t0 TH3 p4rEnT pH0LDer. Only pholDeRS wH1Ch D0 nOT C0N+@1N SUbfoLdErs m@Y 8e D3Le+Ed.";
$lang['listview'] = "l1s+ ViEW";
$lang['listviewcannotaddfolders'] = "cANNO+ @DD fOLdEr\$ In ThIS vI3W. 5hOwiNg 20 3n+R13s 4T @ +1m3.";
$lang['rating'] = "r4TiN9";
$lang['nolinksinfolder'] = "n0 l1nKs 1N tH1\$ Ph0Ld3r.";
$lang['addlinkhere'] = "adD l1nK HeRe";
$lang['notvalidURI'] = "tH4+ 1S N0T 4 V4L1D uRI!";
$lang['mustspecifyname'] = "j00 Mu\$+ sPec1fY @ n4mE!";
$lang['mustspecifyvalidfolder'] = "j00 mu\$+ 5p3CiPHY @ vAL1D FOlDER!";
$lang['mustspecifyfolder'] = "j00 mUs+ 5PeciPhY A PHold3R!";
$lang['successfullyaddedlinkname'] = "sUCc35spHuLLY 4dD3d L1Nk '%s'";
$lang['failedtoaddlink'] = "fa1LEd To 4Dd L1NK";
$lang['failedtoaddfolder'] = "f4il3D +0 4dd fOlDeR";
$lang['addlink'] = "aDD a LinK";
$lang['addinglinkin'] = "add1Ng LiNK 1n";
$lang['addressurluri'] = "aDdrE5\$";
$lang['addnewfolder'] = "add 4 nEW pHOlDeR";
$lang['addnewfolderunder'] = "aDDinG N3w pH0LD3R UNDER";
$lang['editfolder'] = "eD1+ f0lD3R";
$lang['editingfolder'] = "edIT1N9 PhOLdEr";
$lang['mustchooserating'] = "j00 mUst CH0oSE 4 r4Tin9!";
$lang['commentadded'] = "yOuR C0MMENT w4s 4DdeD.";
$lang['commentdeleted'] = "coMm3n+ W@s dElE+3D.";
$lang['commentcouldnotbedeleted'] = "coMM3nT C0uLd N0+ 8e D3L3+ED.";
$lang['musttypecomment'] = "j00 Mu5t TyP3 4 commen+!";
$lang['mustprovidelinkID'] = "j00 mUst pROV1De 4 LINk 1D!";
$lang['invalidlinkID'] = "inv@L1d link 1d!";
$lang['address'] = "aDDR3SS";
$lang['submittedby'] = "sUBMiT+3D bY";
$lang['clicks'] = "cL1cK\$";
$lang['rating'] = "r4tINg";
$lang['vote'] = "vOT3";
$lang['votes'] = "votE\$";
$lang['notratedyet'] = "n0+ r4TeD By 4NYonE YE+";
$lang['rate'] = "r4+3";
$lang['bad'] = "bAd";
$lang['good'] = "g00D";
$lang['voteexcmark'] = "v0+E!";
$lang['clearvote'] = "cl3@R V0te";
$lang['commentby'] = "comMeN+ 8Y %s";
$lang['addacommentabout'] = "aDd 4 COMm3n+ 4B0U+";
$lang['modtools'] = "m0d3R@T1ON +o0l5";
$lang['editname'] = "ed1+ n@Me";
$lang['editaddress'] = "eD1+ AdDrE\$s";
$lang['editdescription'] = "edIt DE\$CrIptIoN";
$lang['moveto'] = "mOv3 T0";
$lang['linkdetails'] = "linK D3t4ILS";
$lang['addcomment'] = "aDD cOMM3N+";
$lang['voterecorded'] = "yoUr Vot3 H45 83en rECoRdED";
$lang['votecleared'] = "yOUR v0+E h@\$ beEN cL34rEd";
$lang['linknametoolong'] = "l1Nk N4Me T0O LON9. m4x1Mum 1S %s Ch4r4C+3r\$";
$lang['linkurltoolong'] = "l1nK UrL +oO LOn9. M4X1MUM 15 %s Ch@r4C+3rS";
$lang['linkfoldernametoolong'] = "f0LdER n@m3 T00 loNG. M@x1MUm L3n9+h 1s %s ChAr4C+3R\$";

// Login / logout (llogon.php, logon.php, logout.php) -----------------------------------------

$lang['loggedinsuccessfully'] = "j00 L09gEd 1N SuCc3s5phULLy.";
$lang['presscontinuetoresend'] = "pr3s\$ coN+1nuE t0 r3sEnD pH0RM DA+4 0R C4ncEl To r3L04d p@93.";
$lang['usernameorpasswdnotvalid'] = "t3H usERn4mE 0R P4s5wORd J00 \$upPL13D Is NOT V4lID.";
$lang['rememberpasswds'] = "r3M3M8ER p@5\$WORdS";
$lang['rememberpassword'] = "reMemb3r P@ssWorD";
$lang['enterasa'] = "ent3r 4s 4 %s";
$lang['donthaveanaccount'] = "d0n'+ h4vE 4N acCoUN+? %s";
$lang['registernow'] = "r39I\$+er nOW";
$lang['problemsloggingon'] = "pr08L3M5 L09G1N9 0n?";
$lang['deletecookies'] = "dElE+3 C0oKie5";
$lang['cookiessuccessfullydeleted'] = "cO0K13s SUcc35\$pHuLLY DeLEtED";
$lang['forgottenpasswd'] = "f0RG0TT3N YoUR P@s\$woRD?";
$lang['usingaPDA'] = "u\$1ng 4 PD@?";
$lang['lightHTMLversion'] = "l1gH+ htMl VeR\$10n";
$lang['youhaveloggedout'] = "j00 haV3 Lo9g3d OuT.";
$lang['currentlyloggedinas'] = "j00 @r3 cuRReN+ly L09g3D IN AS %s";
$lang['logonbutton'] = "l09on";
$lang['otherdotdotdot'] = "otH3r...";
$lang['yoursessionhasexpired'] = "y0UR 53\$s10n H@5 3XP1ReD. J00 WIlL N33D T0 L091n A9@1n t0 cON+1Nu3.";

// My Forums (forums.php) ---------------------------------------------------------

$lang['myforums'] = "mY ForUms";
$lang['allavailableforums'] = "aLl av@IL48lE PH0rums";
$lang['favouriteforums'] = "fAV0uRi+E PhoRuMs";
$lang['ignoredforums'] = "i9norEd PHOrUM5";
$lang['ignoreforum'] = "igN0RE PHOrUM";
$lang['unignoreforum'] = "uNIGN0rE PhoRUM";
$lang['lastvisited'] = "l@5t v1SItEd";
$lang['forumunreadmessages'] = "%s uNRe@d MeSs49E\$";
$lang['forummessages'] = "%s Me\$5@9E\$";
$lang['forumunreadtome'] = "%s uNr34D &quot;t0: mE&quot;";
$lang['forumnounreadmessages'] = "no UNR34D M3Ss49E\$";
$lang['removefromfavourites'] = "r3MoV3 phR0M f4V0URItES";
$lang['addtofavourites'] = "aDD To F@vouR1+35";
$lang['availableforums'] = "av41lABLE PHoRUm\$";
$lang['noforumsofselectedtype'] = "tH3re @RE N0 PHORUm5 oF +He SeL3CTed +YP3 4V@Il@bLe. pLE45E SeL3CT @ d1ffEReNT +YPe.";
$lang['successfullyaddedforumtofavourites'] = "sUCCEs\$pHUlLY 4Dd3D Ph0rUM +0 F4vouR1+35.";
$lang['successfullyremovedforumfromfavourites'] = "sUCc35\$phUlLY REm0veD f0rum fROM PH4V0URi+3s.";
$lang['successfullyignoredforum'] = "suCcE\$\$PHuLLy 1GNOr3D PhORuM.";
$lang['successfullyunignoredforum'] = "suCc3s5PHUlLY unI9noR3D PhORuM.";
$lang['failedtoupdateforuminterestlevel'] = "f@1l3D t0 UPd@T3 F0rum 1N+3R3S+ L3V3L";
$lang['noforumsavailablelogin'] = "ther3 4rE N0 foRum5 4V@1L4Bl3. pL34S3 L09in TO vIew y0UR fORumS.";
$lang['passwdprotectedforum'] = "p45\$w0rD PR0+eC+eD FORum";
$lang['passwdprotectedwarning'] = "tH1S F0ruM Is P@\$sWord prO+Ec+3D. TO 941n 4cCESs EnT3R tH3 P@SSW0Rd 83lOW.";

// Message composition (post.php, lpost.php) --------------------------------------

$lang['postmessage'] = "pO\$+ mESS493";
$lang['selectfolder'] = "seL3CT pH0LDER";
$lang['mustenterpostcontent'] = "j00 mU\$+ EN+ER \$oM3 c0n+3n+ PH0R +H3 pO5+!";
$lang['messagepreview'] = "m3s\$49e pREvI3W";
$lang['invalidusername'] = "inVALiD u\$eRN4mE!";
$lang['mustenterthreadtitle'] = "j00 MU5+ 3n+Er 4 +i+L3 ph0R +hE +hR3ad!";
$lang['pleaseselectfolder'] = "pl34s3 SeLECt 4 PhoLdEr!";
$lang['errorcreatingpost'] = "error cREaT1NG P0st! PLeAs3 +RY @941N 1N @ F3W m1Nu+35.";
$lang['createnewthread'] = "crE4TE n3W +hR34d";
$lang['postreply'] = "p0\$+ r3PLy";
$lang['threadtitle'] = "thr34D +1+lE";
$lang['messagehasbeendeleted'] = "mES\$@93 N0T PhoUnD. CHecK +ha+ 1t HASN'T b33n d3LE+3d.";
$lang['messagenotfoundinselectedfolder'] = "mES\$49e NOT foUnd 1N sELeCt3d PhOLdER. chECK tH4T i+ H4sN'+ B3eN mOVed OR D3lE+3d.";
$lang['cannotpostthisthreadtypeinfolder'] = "j00 c4NNoT po5T +h1\$ tHrEAd TyP3 1N +h4+ Fold3r!";
$lang['cannotpostthisthreadtype'] = "j00 c4nNot p0st +h1\$ +hrE@D tYP3 @S tHErE 4re n0 AV@Il4BLe PhoLdEr5 Th4t @lL0W i+.";
$lang['cannotcreatenewthreads'] = "j00 c4NN0+ CRE4+e N3w THR3@D\$.";
$lang['threadisclosedforposting'] = "thi\$ tHrEAd 1S cl0sEd, J00 c@nN0+ pO\$T In It!";
$lang['moderatorthreadclosed'] = "w@Rn1n9: this ThRe4d I5 cLoseD FOr P0s+InG +o N0Rm@L U\$3r\$.";
$lang['usersinthread'] = "uSER\$ IN thR3@d";
$lang['correctedcode'] = "c0rr3CteD cOd3";
$lang['submittedcode'] = "su8mi+tED C0D3";
$lang['htmlinmessage'] = "h+mL iN M3s\$493";
$lang['disableemoticonsinmessage'] = "d1s@blE EmOT1C0NS 1n ME\$s4GE";
$lang['automaticallyparseurls'] = "auTOm4t1C4lly P@R5e uRLS";
$lang['automaticallycheckspelling'] = "aut0M4+Ic4llY chEcK SpeLL1nG";
$lang['setthreadtohighinterest'] = "se+ ThrE4D +O HiGH 1ntEREST";
$lang['enabledwithautolinebreaks'] = "eN4bL3D wI+H 4UTo-Line-bR34k\$";
$lang['fixhtmlexplanation'] = "tH1s FORuM U\$3S HtmL FIlt3riNG. YOuR \$u8mi+tED HTmL H4S 8EEn M0D1FIeD BY T3H PhIL+3rs 1n 5oM3 W@Y.\\n\\n+O v1eW YOUr 0R191n4l C0D3, \$3L3Ct TH3 \\'\$u8Mi+TeD c0D3\\' r4dIO 8utTON.\\n+0 V13W +hE mOD1PH1Ed c0dE, 53L3C+ +H3 \\'C0Rr3C+3d C0d3\\' r4D1o 8u++On.";
$lang['messageoptions'] = "m3s\$49E oPtION\$";
$lang['notallowedembedattachmentpost'] = "j00 4r3 n0+ @lLOW3D t0 3m83D 4+t4CHm3NTS 1n YoUR pOSt\$.";
$lang['notallowedembedattachmentsignature'] = "j00 ar3 NOT @LLowEd +0 Em83d 4+T@CHM3N+S iN YOur S1GNA+UR3.";
$lang['reducemessagelength'] = "mE5\$@9e lENg+H mUS+ b3 UnDEr 65,535 CH4R4C+3R5 (cUrrently: %s)";
$lang['reducesiglength'] = "si9N4tURe l3nGth mU5+ 8E unD3R 65,535 CH4R@CT3r5 (CURRENtLY: %s)";
$lang['cannotcreatethreadinfolder'] = "j00 C4NnoT CR34TE nEW THrEAd\$ 1N +hIs PHoLD3R";
$lang['cannotcreatepostinfolder'] = "j00 C@NNot rEPLy T0 poSt5 1n Th1\$ f0lDER";
$lang['cannotattachfilesinfolder'] = "j00 C4NN0t pos+ 4TT@CHM3N+\$ In +h1S F0lD3R. ReMOVe 4++4CHM3Nts +o cONT1NUE.";
$lang['postfrequencytoogreat'] = "j00 C4N 0NLy POSt 0NcE EV3RY %s 5EC0NDS. pL3@53 +ry @941N l@T3r.";
$lang['emailconfirmationrequiredbeforepost'] = "eM41L c0nFiRMa+10n 15 r3QuIR3D 8EPH0R3 j00 c@N P0S+. 1pH j00 H4V3 n0t R3C31v3D 4 cONfIRm4+ION 3M@Il PlE4\$3 clIcK tHe bUTT0N BeL0W @Nd 4 N3W oNE WIlL b3 S3N+ T0 YOu. if yOUr EM4Il 4DDr35\$ N33D5 ch4ngINg PL34s3 Do \$O 83PH0r3 R3Qu35+1Ng @ N3W c0nPh1rm4TiOn 3m41L. j00 M4y chAN9E Y0UR 3M41L 4dDRe\$\$ by cLIck my cON+R0lS 4b0ve 4nD +h3n USEr D3+4iLS";
$lang['emailconfirmationfailedtosend'] = "cOnFIRM@T1on 3m41L phA1L3D tO s3nD. PL34sE c0n+AcT +He PH0rum 0WNeR T0 ReCtiPhY tHIS.";
$lang['emailconfirmationsent'] = "cOnF1Rm4tiOn 3M4il H4S 83eN R35EN+.";
$lang['resendconfirmation'] = "rE\$EnD C0NfIRm@TiON";
$lang['userapprovalrequiredbeforeaccess'] = "youR uSER 4Cc0UN+ n3eds +o 83 @Ppr0V3D by 4 F0rUm @dMIn B3F0r3 j00 c4n aCc35\$ +he RequESTeD PHOrUM.";
$lang['reviewthread'] = "r3VI3W tHrEAD";
$lang['reviewthreadinnewwindow'] = "r3vIEW ENTirE thre@D 1n new w1ND0w";

// Message display (messages.php & messages.inc.php) --------------------------------------

$lang['inreplyto'] = "iN r3pLy T0";
$lang['showmessages'] = "sH0w m3SS4Ge\$";
$lang['ratemyinterest'] = "r@+e My 1NTeR3s+";
$lang['adjtextsize'] = "adjU5+ T3Xt \$1Ze";
$lang['smaller'] = "sM@Ll3r";
$lang['larger'] = "l4Rg3r";
$lang['faq'] = "f4Q";
$lang['docs'] = "dOcs";
$lang['support'] = "suPPort";
$lang['donateexcmark'] = "d0N4+e!";
$lang['fontsizechanged'] = "fonT S1Ze ChAN93D. %s";
$lang['framesmustbereloaded'] = "fr4m3S MUS+ 83 R3lO4DeD m4nu4LLy +o s33 CH@NG3S.";
$lang['threadcouldnotbefound'] = "t3h ReQUEst3D +HrE4D c0ULd N0+ be pHoUnD OR @CcES\$ W4s d3n1ED.";
$lang['mustselectpolloption'] = "j00 MU\$+ 53leCT 4n 0P+iON t0 voTe FOr!";
$lang['mustvoteforallgroups'] = "j00 mU5+ VotE IN 3vERy 9R0UP.";
$lang['keepreading'] = "kE3P R3@diN9";
$lang['backtothreadlist'] = "bacK +O tHR3Ad L1\$T";
$lang['postdoesnotexist'] = "tH4+ P0sT D0ES N0T 3X1\$+ in Th15 THREAd!";
$lang['clicktochangevote'] = "cL1cK T0 cH4NGE V0+E";
$lang['youvotedforoption'] = "j00 v0tEd PHor op+iON";
$lang['youvotedforoptions'] = "j00 vOTEd fOR OP+I0N5";
$lang['clicktovote'] = "cLIck to v0t3";
$lang['youhavenotvoted'] = "j00 H4V3 n0t V0+3D";
$lang['viewresults'] = "v1EW R3sUL+S";
$lang['msgtruncated'] = "m3\$s4g3 +rUNcA+3d";
$lang['viewfullmsg'] = "vI3w fULl me5\$49e";
$lang['ignoredmsg'] = "iGn0rEd Me\$\$49E";
$lang['wormeduser'] = "w0rMeD U\$ER";
$lang['ignoredsig'] = "i9NOrED 5I9N@tUr3";
$lang['messagewasdeleted'] = "m35s49E %s.%s W@s dEL3+eD";
$lang['stopignoringthisuser'] = "s+oP IGn0r1n9 +H1\$ U\$3r";
$lang['renamethread'] = "ren@M3 +hr3@D";
$lang['movethread'] = "m0v3 THrE@d";
$lang['torenamethisthreadyoumusteditthepoll'] = "tO REN@M3 ThIs tHR34D J00 Mu\$+ eDIt +h3 POll.";
$lang['closeforposting'] = "cl0s3 PhOR p0ST1N9";
$lang['until'] = "untIl 00:00 UtC";
$lang['approvalrequired'] = "aPpROV@l R3qu1REd";
$lang['messageawaitingapprovalbymoderator'] = "m3S\$49E %s.%s IS 4WaIT1n9 4PPrOV@l bY 4 mod3R@t0R";
$lang['successfullyapprovedpost'] = "suCcES5PhULlY @pPRov3D p0S+ %s";
$lang['postapprovalfailed'] = "pos+ 4PprOv@L PH41LEd.";
$lang['postdoesnotrequireapproval'] = "poSt D0Es N0+ r3qUIre @pPR0V4l";
$lang['approvepost'] = "aPpr0v3 POSt";
$lang['approvedbyuser'] = "apPr0VEd: %s by %s";
$lang['makesticky'] = "m@k3 STiCKy";
$lang['messagecountdisplay'] = "%s OpH %s";
$lang['linktothread'] = "pERM4Nent L1Nk +O +Hi\$ +hrE@d";
$lang['linktopost'] = "l1nK to P0st";
$lang['linktothispost'] = "liNk +o +h1s POST";
$lang['imageresized'] = "tHiS 1m4GE h@s b3eN r3s1z3d (oRig1n4l \$1z3 %1\$Sx%2\$S). to VI3w T3H fUlL-sizE 1m493 Cl1CK h3re.";
$lang['messagedeletedbyuser'] = "m3Ss493 %s.%s DElE+3d %s 8Y %s";
$lang['messagedeleted'] = "mes54g3 %s.%s wA\$ d3l3TED";
$lang['viewinframeset'] = "v1eW 1n Phr@mE\$ET";
$lang['pressctrlentertoquicklysubmityourpost'] = "presS C+RL+en+3r To qU1CKlY SU8M1T yoUr PO5+";

// Moderators list (mods_list.php) -------------------------------------

$lang['cantdisplaymods'] = "c4nN0T D1\$pLAY PHOLDER m0D3r4t0r\$";
$lang['moderatorlist'] = "m0dER@tOR LiST:";
$lang['modsforfolder'] = "moD3R4toRs Ph0r FoLD3R";
$lang['nomodsfound'] = "no M0D3r4TOr5 pH0UNd";
$lang['forumleaders'] = "fORUm LeAD3RS:";
$lang['foldermods'] = "f0Ld3r MoDEr@Tor\$:";

// Navigation strip (nav.php) ------------------------------------------

$lang['start'] = "s+4RT";
$lang['messages'] = "m3\$\$49E5";
$lang['pminbox'] = "iN8OX";
$lang['startwiththreadlist'] = "stART P49E W1+H +HR34D l1ST";
$lang['pmsentitems'] = "sENT IT3m5";
$lang['pmoutbox'] = "oU+8oX";
$lang['pmsaveditems'] = "sAVEd 1TEmS";
$lang['pmdrafts'] = "dR4ph+S";
$lang['links'] = "l1nK\$";
$lang['admin'] = "aDMIN";
$lang['login'] = "loGiN";
$lang['logout'] = "l0g0U+";

// PM System (pm.php, pm_write.php, pm.inc.php) ------------------------

$lang['privatemessages'] = "pR1V4tE m3S\$49e\$";
$lang['recipienttiptext'] = "sEP4R@tE REC1P13NT\$ BY S3M1-coloN 0R C0mM@";
$lang['maximumtenrecipientspermessage'] = "th3rE Is 4 LImIT oPh 10 r3c1pI3N+\$ P3R m35\$4Ge. pL34s3 4menD Y0uR R3CIP1ENt L1S+.";
$lang['mustspecifyrecipient'] = "j00 MUSt 5P3C1fY 4T lEA\$t 0NE R3CIP13NT.";
$lang['usernotfound'] = "u53r %s N0T Ph0unD";
$lang['sendnewpm'] = "s3ND n3W Pm";
$lang['savemessage'] = "sav3 m35s49E";
$lang['nosubject'] = "n0 \$UBjEct";
$lang['norecipients'] = "n0 reC1PIEn+5";
$lang['timesent'] = "t1m3 \$EN+";
$lang['notsent'] = "n0+ \$eNT";
$lang['errorcreatingpm'] = "erRoR CReA+1n9 pm! PLE4S3 TRy Ag@1N 1N A phEw MiNU+E\$";
$lang['writepm'] = "wR1tE M3sS4GE";
$lang['editpm'] = "ediT m3\$\$4GE";
$lang['cannoteditpm'] = "c4nNot 3DIT +Hi5 pM. IT h45 4LR34DY B3EN VI3wED 8y +HE REc1p1EN+ 0R t3h MeS54ge D0ES NO+ EX1sT 0R I+ 1s 1N4Cce\$\$18Le by j00";
$lang['cannotviewpm'] = "c@nNOT V1EW pm. mE55@93 DO3\$ N0T 3X1\$t 0r 1T 1\$ 1n@CCe\$S1BL3 8y J00";
$lang['pmmessagenumber'] = "mESS49E %s";

$lang['youhavexnewpm'] = "j00 H@vE %d NEw M35\$@ges. WOUlD j00 lIk3 T0 GO +O yoUR 1nbox nOw?";
$lang['youhave1newpm'] = "j00 h4V3 1 New M3S\$49e. W0UlD j00 lIKE +0 go tO yoUR 1Nb0x N0w?";
$lang['youhave1newpmand1waiting'] = "j00 H@vE 1 N3W me\$S49E.\n\nyOu 4l5o H@v3 1 mESS@9e 4W4IT1N9 dEl1v3Ry. +o R3C3IVe THis m35\$4gE pL3453 ClE4R \$0m3 5p4c3 iN y0ur INbOX.\n\nwOuld j00 l1k3 t0 GO tO YOur 1NbOx n0W?";
$lang['youhave1pmwaiting'] = "j00 haVE 1 mE\$S49e 4W41+1N9 DEl1vErY. t0 R3CeIVe thIS m3\$s4ge plE4s3 clE4r \$ome 5P4C3 iN YOur 1n8oX.\n\nWOulD J00 lIKE T0 GO +o YouR InbOX n0W?";
$lang['youhavexnewpmand1waiting'] = "j00 h@vE %d N3W mEs\$49E\$.\n\nyOu @l5O h@Ve 1 MeS\$493 Aw41+INg d3l1V3RY. +O rEcEIv3 tH15 M35\$@Ge Pl34sE CL34r \$OM3 5P4C3 In YoUR Inb0X.\n\nw0uld j00 L1kE +O GO t0 YOuR 1nb0x N0w?";
$lang['youhavexnewpmandxwaiting'] = "j00 H4v3 %d n3W m3ss4gE\$.\n\nyOU @L5O H4VE %d mE5\$@93S 4W@1ting d3L1vERY. t0 r3C31V3 +He\$E Me\$s@93 PLea\$3 CLeaR \$OME SP4C3 1N YOur 1nBOX.\n\nWouLD j00 LIk3 t0 G0 +O youR 1nb0x N0w?";
$lang['youhave1newpmandxwaiting'] = "j00 H4V3 1 NEw M3sS493.\n\nyOU Also h4VE %d MEss49ES 4W41+IN9 D3LivERY. To R3C31vE TH3se ME\$s4gE\$ PLe@Se Cl34r s0m3 \$p4cE 1N YOUR 1NbOx.\n\nwOULd J00 Lik3 +O Go +0 Y0uR INb0x Now?";
$lang['youhavexpmwaiting'] = "j00 H@VE %d M35\$4g3\$ @w4itIn9 DEl1vErY. T0 R3C31VE tH35E mE\$5@9E\$ Pl3aS3 cl3@R som3 5P4Ce 1n yoUr 1NBoX.\n\nw0ulD j00 L1KE t0 GO To YoUr 1Nb0X n0W?";

$lang['youdonothaveenoughfreespace'] = "j00 Do N0+ hAvE eNOuGH pHRe3 sp4cE T0 5EnD +HIs M3s5@gE.";
$lang['userhasoptedoutofpm'] = "%s ha\$ oPt3d Ou+ 0Ph R3C31v1NG P3RS0n@l Me\$s@93S";
$lang['pmfolderpruningisenabled'] = "pM PhoLder PRUN1N9 IS EN4Bl3d!";
$lang['pmpruneexplanation'] = "tH1S F0Rum uS35 pm fOLD3R pRuNIn9. +H3 Mes\$A9E\$ j00 H4VE s+orEd iN yoUr INB0x 4nD S3n+ 1+3m\$\\nfoLD3rs 4r3 subjEC+ tO 4U+oMa+1C d3lEt1oN. @ny meS\$493S J00 Wi\$H +O k3EP SH0uLd b3 M0ved +O\\nY0uR \\'s@vEd 1tEMS\\' FOLd3r s0 +h4T th3Y 4Re NOT d3lE+3D.";
$lang['yourpmfoldersare'] = "yOur pm pH0LdERs 4RE %s FUlL";
$lang['currentmessage'] = "cuRrEn+ mE\$s@Ge";
$lang['unreadmessage'] = "unr3@d meSs493";
$lang['readmessage'] = "r3aD MeSSagE";
$lang['pmshavebeendisabled'] = "p3Rs0NAL m3sS4GE\$ H4V3 83en DI5@BLEd 8Y +3h PHOrUM 0wnEr.";
$lang['adduserstofriendslist'] = "adD UsERs TO yOUr FR13ND\$ LIst +o h4vE thEM Appe@r In @ dR0p d0WN ON THe PM wR1+3 Me\$\$493 P@gE.";

$lang['messagesaved'] = "mE\$\$@9E s4v3d";
$lang['messagewassuccessfullysavedtodraftsfolder'] = "m3s\$4Ge W4S SuCc3\$\$pHuLLy S4veD +o 'dRApH+5' FOLd3R";
$lang['couldnotsavemessage'] = "coUld NoT \$@V3 M35\$@93. M4Ke SuRE j00 h4v3 en0UGH 4VA1L@bL3 PhreE \$P4ce.";
$lang['pmtooltipxmessages'] = "%s m3sS4GES";
$lang['pmtooltip1message'] = "1 me\$\$a9E";

$lang['allowusertosendpm'] = "aLL0w u53r +O 5EnD PERSON4L mE\$\$493\$ +o M3";
$lang['blockuserfromsendingpm'] = "bloCK US3R PhROm \$enDInG PERSoNAl Mes5@G35 T0 Me";
$lang['yourfoldernamefolderisempty'] = "y0uR %s PhOlDeR i\$ emP+Y";
$lang['successfullydeletedselectedmessages'] = "sUCC3sSPHuLLy d3lEtEd S3L3C+ED M3sS49Es";
$lang['successfullyarchivedselectedmessages'] = "sUcC35SPHuLLy 4RCH1VeD s3L3c+Ed M3s54gE\$";
$lang['failedtodeleteselectedmessages'] = "fAILeD +0 DEl3t3 \$3Lect3D m35\$49e\$";
$lang['failedtoarchiveselectedmessages'] = "f41l3D to @rch1Ve \$elEctED Me\$s49es";

// Preferences / Profile (user_*.php) ---------------------------------------------

$lang['mycontrols'] = "mY c0NTrol5";
$lang['myforums'] = "my fOrUM\$";
$lang['menu'] = "m3nU";
$lang['userexp_1'] = "u\$E +3h M3Nu 0N tH3 L3ft T0 M4N@93 Y0UR sEt+1N95.";
$lang['userexp_2'] = "<b>usER D3t41LS</b> 4Llows j00 T0 cHAn93 yoUr n@mE, 3m@Il @dDR3sS aNd P4S5WORD.";
$lang['userexp_3'] = "<b>us3R pR0PH1Le</b> 4LL0W5 J00 +o 3D1+ yOUR US3R Pr0fIL3.";
$lang['userexp_4'] = "<b>cH@N9E p@sSwoRd</b> 4LLOws j00 T0 Ch4NGE YOuR p45\$wORd";
$lang['userexp_5'] = "<b>em4Il &amp; pR1v4Cy</b> l3t\$ J00 Ch4nG3 h0w j00 c4N B3 cON+@C+Ed on @nD opHPH THe ForUM.";
$lang['userexp_6'] = "<b>foRUM OpTIoNs</b> L3tS j00 cH@NgE HOw th3 ForUm Lo0Ks @nD w0rkS.";
$lang['userexp_7'] = "<b>aTt4ChmEnTS</b> 4llow\$ J00 T0 3D1T/DEl3TE yOUr @+tAChM3N+\$.";
$lang['userexp_8'] = "<b>s19N@tUr3</b> LeT5 J00 Ed1+ Y0UR 5i9N4+ur3.";
$lang['userexp_9'] = "<b>rEL4+1oNSH1P\$</b> Le+S j00 m4N49E Y0UR REL4t1oNsh1P w1+h 0TH3R uS3Rs 0N th3 phOrUM.";
$lang['userexp_9'] = "<b>w0Rd FilT3r</b> leTs j00 eD1t yoUr P3rS0n4l w0RD pH1LTeR.";
$lang['userexp_10'] = "<b>tHRE@D SUbScRIp+10n5</b> 4LL0W5 J00 TO M@n493 YOuR +HReAd \$Ub\$CR1P+10nS.";
$lang['userdetails'] = "uS3r D3T@iL5";
$lang['userprofile'] = "uS3r PRoF1L3";
$lang['emailandprivacy'] = "em41l &amp; PriV4Cy";
$lang['editsignature'] = "ed1+ SI9N@tURe";
$lang['norelationshipssetup'] = "j00 H4Ve N0 u\$Er ReL4T1ON\$H1PS sE+ Up. @dD 4 N3W usER 8Y 53aRchINg b3LOw.";
$lang['editwordfilter'] = "ed1+ w0rD pH1Lt3R";
$lang['userinformation'] = "us3R iNfORm@+1ON";
$lang['changepassword'] = "ch4N9E p45\$w0rd";
$lang['currentpasswd'] = "curR3n+ P4s5W0RD";
$lang['newpasswd'] = "n3W Pa\$\$WORd";
$lang['confirmpasswd'] = "c0NFirm P4sSW0rd";
$lang['passwdsdonotmatch'] = "p@5\$w0RDs DO N0T m4+ch!";
$lang['nicknamerequired'] = "nIckn4M3 1s REqU1ReD!";
$lang['emailaddressrequired'] = "em4IL @DDrE\$S 1\$ R3QUIr3d!";
$lang['logonnotpermitted'] = "l09On Not p3rMIT+3d. cH0O53 4N0Th3r!";
$lang['nicknamenotpermitted'] = "niCKN4Me n0T P3Rm1++3D. cH00Se AN0Th3r!";
$lang['emailaddressnotpermitted'] = "emAIL 4DdRE\$s N0+ PERm1TT3D. CHo0S3 @N0Th3r!";
$lang['emailaddressalreadyinuse'] = "em@Il @ddRES\$ 4lRE4Dy 1n u5e. ChO0sE @N0TH3R!";
$lang['relationshipsupdated'] = "r3L@t1on5hIP\$ Upd4T3D!";
$lang['relationshipupdatefailed'] = "r3lA+ioN\$h1p uPd@t3d PH@1l3D!";
$lang['preferencesupdated'] = "pRefERENCE5 W3rE SUcc3\$5PhULLy UPD4t3D.";
$lang['userdetails'] = "u\$ER DE+4iL\$";
$lang['memberno'] = "mEmB3R no.";
$lang['firstname'] = "fiR5+ n4M3";
$lang['lastname'] = "l45+ N4mE";
$lang['dateofbirth'] = "d@+3 OPH 8irTH";
$lang['homepageURL'] = "h0M3p4gE URl";
$lang['profilepicturedimensions'] = "pR0F1Le P1CtuR3 (m@X 95x95pX)";
$lang['avatarpicturedimensions'] = "aVA+4R pIc+Ur3 (M@X 15X15PX)";
$lang['invalidattachmentid'] = "inv4LId A+T4CHmEN+. ChEcK +H4T is H@Sn't B33n DElE+3D.";
$lang['unsupportedimagetype'] = "unSuPp0RTEd 1M4GE @T+@CHmEnt. J00 C4N oNLy UsE jp9, gIF @nD PN9 1m@93 @tT4Chm3N+S pH0R YoUr 4v4taR 4nD PrOFilE P1ctURe.";
$lang['selectattachment'] = "s3L3C+ 4+t4CHmENt";
$lang['pictureURL'] = "p1c+urE URl";
$lang['avatarURL'] = "av@T4r uRL";
$lang['profilepictureconflict'] = "t0 uSe @n 4+T4Chment FOr Y0UR pROph1LE P1CTUr3 th3 PIC+uRe UrL ph1ELd Must 83 8l4nk.";
$lang['avatarpictureconflict'] = "to U53 AN 4T+@CHm3N+ fOR Y0UR 4V4Tar pic+uRE THE 4v4+4r UrL pHI3Ld MUs+ 83 8L4NK.";
$lang['attachmenttoolargeforprofilepicture'] = "sELEcT3D @TT@ChM3n+ 1\$ tO0 L@r93 F0R Pr0filE pIcTURE. m@x1muM DiMEnS10nS @rE %s";
$lang['attachmenttoolargeforavatarpicture'] = "seLeC+eD 4T+@ChmEn+ 1s T0o L4r93 FOR @V4t@r p1cTUrE. m@X1Mum d1m3n\$10Ns 4re %s";
$lang['failedtoupdateuserdetails'] = "s0m3 0r @LL OF Y0Ur U\$3R @cc0un+ D3T@iL\$ cOuld nOT B3 UPd@TeD. PL34sE +Ry 494IN l@TeR.";
$lang['failedtoupdateuserpreferences'] = "s0m3 OR 4Ll 0f Y0UR Us3R pReFeREnC3\$ CoULd No+ b3 UpD@+Ed. pL34\$3 +rY 4941N L4T3R.";
$lang['emailaddresschanged'] = "em4iL AdDrES\$ H@S b3en ChAN9ED";
$lang['newconfirmationemailsuccess'] = "y0Ur 3M@il ADDR3SS H4S 8eEN chAn9eD 4nd 4 NEW conFIrMA+ION 3m41L H@s 8e3n \$3n+. plE4S3 Ch3cK 4ND Re@d tEH em@Il foR fUr+hEr 1nstRUC+1On\$.";
$lang['newconfirmationemailfailure'] = "j00 HAv3 CHan93D Your eM41L 4DdrE\$5, 8UT We W3R3 uN4BLe +0 sEND @ c0nfIRM@+ION reqUe\$+. Pl34S3 c0nt4c+ thE PHORum oWN3r f0r 45\$I5+4Nc3.";
$lang['forumoptions'] = "fORUM 0p+I0N\$";
$lang['notifybyemail'] = "n0tIFY 8Y 3mA1L 0f POS+S tO m3";
$lang['notifyofnewpm'] = "noTiPHy 8Y p0pUP opH NEw pm m35\$493S +0 ME";
$lang['notifyofnewpmemail'] = "n0tIPhy 8Y 3m@IL OF n3w Pm M35\$4g35 +o Me";
$lang['daylightsaving'] = "adJu\$t f0r D4yL19hT \$4V1N9";
$lang['autohighinterest'] = "aU+0M4t1C4LLY m@rk ThRE4DS I po5+ 1n 45 HIgH 1nT3Re5+";
$lang['convertimagestolinks'] = "au+0M4TiC4lLy CoNVEr+ 3mBedDeD 1M4Ge\$ In P05+\$ iN+o L1NKs";
$lang['thumbnailsforimageattachments'] = "thUMbN@ILs For Im@GE 4+TaCHm3n+5";
$lang['smallsized'] = "sm4LL S1Z3D";
$lang['mediumsized'] = "m3DIUm sIz3D";
$lang['largesized'] = "lar9E 5iZeD";
$lang['globallyignoresigs'] = "gloB4Lly iGN0r3 Us3r \$1GN4Ture\$";
$lang['allowpersonalmessages'] = "allOW oTH3R UsERs +0 \$eNd M3 P3R5On@L M35\$@GES";
$lang['allowemails'] = "allOW 0+h3r U53rs +O s3nD M3 eM41lS Vi4 MY PR0pHiLE";
$lang['timezonefromGMT'] = "t1mE zONe";
$lang['postsperpage'] = "pOSt\$ pEr p4g3";
$lang['fontsize'] = "foN+ siz3";
$lang['forumstyle'] = "f0rUm s+YlE";
$lang['forumemoticons'] = "f0rUM eMoT1C0N5";
$lang['startpage'] = "s+4r+ P49E";
$lang['signaturecontainshtmlcode'] = "s19N@TUR3 CoN+4IN\$ h+Ml C0De";
$lang['savesignatureforuseonallforums'] = "s4V3 sI9N@tUrE ph0R uS3 0N @ll foRumS";
$lang['preferredlang'] = "pr3f3rr3d l4N9U@93";
$lang['donotshowmyageordobtoothers'] = "do N0+ Sh0W My A93 Or Da+e OpH 8irTH +0 0+HeRS";
$lang['showonlymyagetoothers'] = "sh0w onLy My 493 +o 0THeRS";
$lang['showmyageanddobtoothers'] = "shoW 8oTh My 49e 4ND D@te 0PH 8IrTH +0 OtH3Rs";
$lang['showonlymydayandmonthofbirthytoothers'] = "sHoW 0NLy My d4y @ND mON+H 0F bIrtH to 0+h3R\$";
$lang['listmeontheactiveusersdisplay'] = "l15+ mE on +3h 4C+iVE USeRS DI\$PLaY";
$lang['browseanonymously'] = "bR0wS3 PHorUm 4N0NYmoUSly";
$lang['allowfriendstoseemeasonline'] = "broWS3 4nonYMouSlY, BUT 4Ll0W frI3nd5 to S33 Me 4s 0NLIN3";
$lang['revealspoileronmouseover'] = "r3ve@L sP01L3R5 0N MoU\$3 0V3R";
$lang['showspoilersinlightmode'] = "alW4ys ShoW \$pOiLERs 1n lI9Ht MOd3 (usE\$ LI9H+er F0N+ COL0Ur)";
$lang['resizeimagesandreflowpage'] = "r3SizE 1M49e\$ 4Nd ReFLow PAgE T0 pr3V3N+ H0RizOnTAl \$CrOLl1n9.";
$lang['showforumstats'] = "sh0W pHOrUM \$t4T\$ 4+ 8OT+0M 0F MeS\$493 p@N3";
$lang['usewordfilter'] = "en@bL3 WoRD FILT3R.";
$lang['forceadminwordfilter'] = "foRC3 u\$3 0pH aDMIn WoRD F1LT3R oN 4Ll u\$3r\$ (iNC. GUE\$t5)";
$lang['timezone'] = "t1Me ZONE";
$lang['language'] = "l@n9u49e";
$lang['emailsettings'] = "eM4Il @Nd c0nT@C+ 53++1N9S";
$lang['forumanonymity'] = "f0RuM 4N0nyM1+y sE+TiN9\$";
$lang['birthdayanddateofbirth'] = "biRthD4y @nd d4+e 0ph b1R+H dISpL@Y";
$lang['includeadminfilter'] = "inCLuDe @DmIn WOrd Ph1l+3r 1N mY LisT.";
$lang['setforallforums'] = "sET FOR alL PhoRumS?";
$lang['containsinvalidchars'] = "%s ConT41N\$ inV4l1D cH@r4c+3R\$!";
$lang['homepageurlmustincludeschema'] = "hOm3p493 urL MUST 1ncLUd3 H+tP:// \$CHeM4.";
$lang['pictureurlmustincludeschema'] = "p1cturE uRl must iNCLuD3 H+tp:// \$CheM@.";
$lang['avatarurlmustincludeschema'] = "aVAt@r Url mU5+ iNcLuD3 ht+P:// 5ChEM4.";
$lang['postpage'] = "p05+ P@g3";
$lang['nohtmltoolbar'] = "n0 htML T00Lb4r";
$lang['displaysimpletoolbar'] = "dispL4y S1MPL3 H+mL +o0lb4R";
$lang['displaytinymcetoolbar'] = "dI5pL4Y Wys1WYG h+mL +o0L8@r";
$lang['displayemoticonspanel'] = "dISplAY 3moTIC0N5 PAn3l";
$lang['displaysignature'] = "dISPl@Y si9n@tUR3";
$lang['disableemoticonsinpostsbydefault'] = "di5@BLE 3M0TIc0N\$ 1N m3SS49E\$ bY DePH4UL+";
$lang['automaticallyparseurlsbydefault'] = "aU+OmAT1C4Lly P@r\$3 UrlS 1n M3s5@93s bY dEph4UL+";
$lang['postinplaintextbydefault'] = "p0st IN PL41n tEXt 8Y dEpH@ul+";
$lang['postinhtmlwithautolinebreaksbydefault'] = "pO5+ 1N H+mL WI+h 4ut0-l1N3-8Re4ks 8Y DEpH4uL+";
$lang['postinhtmlbydefault'] = "po5+ iN htMl 8Y dEPh4uL+";
$lang['postdefaultquick'] = "u\$E Qu1CK r3PLY by dEPh4uL+. (PhULl R3ply In M3Nu)";
$lang['privatemessageoptions'] = "pRiV@+3 mE\$\$493 oPtiOns";
$lang['privatemessageexportoptions'] = "pRiv@Te MEs54GE EXpOR+ 0PTi0n5";
$lang['savepminsentitems'] = "sAVE 4 CopY OF 34Ch Pm 1 SEnd 1n mY 53N+ 1+3mS F0LD3r";
$lang['includepminreply'] = "inclUdE ME\$\$49e 8Ody wH3N rEPlyIng T0 pm";
$lang['autoprunemypmfoldersevery'] = "aU+0 PRuN3 MY pM fOLd3r\$ 3V3RY:";
$lang['friendsonly'] = "fR1ENds 0nlY?";
$lang['globalstyles'] = "gl08@L 5tyL3s";
$lang['forumstyles'] = "fORUM \$tYlES";
$lang['youmustenteryourcurrentpasswd'] = "j00 mU5T 3n+3R Y0Ur cUrR3NT P4\$5woRd";
$lang['youmustenteranewpasswd'] = "j00 mUS+ Ent3r @ N3W p@S\$W0Rd";
$lang['youmustconfirmyournewpasswd'] = "j00 MUs+ c0nF1RM y0ur NeW P4SSW0Rd";
$lang['profileentriesmustnotincludehtml'] = "pROFIlE eNtrIE\$ MUsT noT iNcLuDE hTmL";
$lang['failedtoupdateuserprofile'] = "f@Il3D t0 UPd@Te u\$Er PRoFIle";

// Polls (create_poll.php, poll_results.php) ---------------------------------------------

$lang['mustprovideanswergroups'] = "j00 mU\$+ PrOViD3 5om3 4NSw3r 9ROuP\$";
$lang['mustprovidepolltype'] = "j00 MU5+ PrOViDE 4 POll TYpE";
$lang['mustprovidepollresultsdisplaytype'] = "j00 mUst Pr0vIDE Re\$UL+s dISpl@Y +YpE";
$lang['mustprovidepollvotetype'] = "j00 Mus+ pr0v1dE 4 P0LL VoTE TYpe";
$lang['mustprovidepollguestvotetype'] = "j00 Mus+ SpeCiFY iPh 9Uest5 5h0uld b3 4LLowEd +O VOtE";
$lang['mustprovidepolloptiontype'] = "j00 MU5+ Pr0V1DE 4 POll op+iOn +YP3";
$lang['mustprovidepollchangevotetype'] = "j00 MUS+ Pr0viD3 A P0LL CH@nG3 V0T3 tyPe";
$lang['pollquestioncontainsinvalidhtml'] = "onE or moRE 0pH Y0UR P0LL qU3S+IoN\$ coN+@1N\$ 1NV4liD h+Ml.";
$lang['pleaseselectfolder'] = "pl3@s3 53leC+ 4 PH0LD3r";
$lang['mustspecifyvalues1and2'] = "j00 MU\$t SpEc1FY V@lU35 PH0R @N5weRS 1 4Nd 2";
$lang['tablepollmusthave2groups'] = "t48UL4r foRm@T P0Ll\$ Mu5+ H@VE prEcIS3ly +Wo VotIn9 9R0UPS";
$lang['nomultivotetabulars'] = "t@8UL4R phorM@T PolLS c4nN0+ B3 MuL+I-V0t3";
$lang['nomultivotepublic'] = "pUBL1C 8@LL0+S C@Nn0t b3 MUl+1-Vot3";
$lang['abletochangevote'] = "j00 WilL 8E @BL3 To chaN9E Y0UR VOTe.";
$lang['abletovotemultiple'] = "j00 W1LL b3 48l3 to V0Te MuLT1plE tiM3s.";
$lang['notabletochangevote'] = "j00 W1ll n0t B3 4bLE T0 Ch@Ng3 YoUR VOTe.";
$lang['pollvotesrandom'] = "n0+e: poLL V0+Es @rE ranDomLY g3n3r4TeD FoR pr3VI3W only.";
$lang['pollquestion'] = "pOll qUE5+10n";
$lang['possibleanswers'] = "p0\$\$iblE @NSwER\$";
$lang['enterpollquestionexp'] = "eN+3r Teh 4N\$w3r5 PH0R YoUR pOLL QU3sTION.. 1F YoUr p0LL 15 4 &quot;yE\$/N0&quot; Qu35+10N, siMPlY 3NTeR &quot;YES&quot; PhoR 4nsW3R 1 4ND &quot;NO&quot; PH0r anSW3R 2.";
$lang['numberanswers'] = "nO. 4nSWer5";
$lang['answerscontainHTML'] = "answ3RS CONtA1N h+Ml (n0+ INCLUD1N9 51GN4tUR3)";
$lang['optionsdisplay'] = "an5W3RS DI5pLay +yPe";
$lang['optionsdisplayexp'] = "how SHoULd T3h @N5WErs 8E pRe\$eN+ED?";
$lang['dropdown'] = "a\$ DR0P-dOWn LiST(s)";
$lang['radios'] = "a5 4 SErIe\$ Of rADIO 8uttOnS";
$lang['votechanging'] = "voTE CH4n9IN9";
$lang['votechangingexp'] = "c@n 4 Per\$ON CH4n93 hI\$ oR HeR voT3?";
$lang['guestvoting'] = "guesT Vot1n9";
$lang['guestvotingexp'] = "can 9U35+S v0t3 1N th1\$ P0LL?";
$lang['allowmultiplevotes'] = "all0w MULT1PLe v0tes";
$lang['pollresults'] = "pOll RE5UL+S";
$lang['pollresultsexp'] = "hOW w0ulD J00 l1k3 +o d1\$pL4Y +he Re\$ul+s oPh Y0Ur PolL?";
$lang['pollvotetype'] = "p0lL VoT1n9 +YpE";
$lang['pollvotesexp'] = "hoW SH0UlD +h3 p0lL 83 cOndUc+3D?";
$lang['pollvoteanon'] = "aN0NYMou\$LY";
$lang['pollvotepub'] = "pU8L1C 8@Ll0t";
$lang['horizgraph'] = "hoRiz0nTAL gR4Ph";
$lang['vertgraph'] = "vER+ICAL 9RAPH";
$lang['tablegraph'] = "t48ULar fORm4+";
$lang['polltypewarning'] = "<b>w4rNinG</b>: thIs Is 4 Pu8lIc b4lLot. Y0UR N4m3 WIlL B3 V1SI8l3 n3xt T0 +Eh Op+1oN j00 v0te FOr.";
$lang['expiration'] = "exPiR4T1On";
$lang['showresultswhileopen'] = "dO J00 WANt +o Show r3SUl+\$ wH1L3 +He POLl IS 0PeN?";
$lang['whenlikepollclose'] = "wH3N WoULd J00 LiKE y0UR poLl To 4U+0M4+1C4Lly CL0\$3?";
$lang['oneday'] = "oN3 D4Y";
$lang['threedays'] = "tHr3E d@Y\$";
$lang['sevendays'] = "seV3n d@Ys";
$lang['thirtydays'] = "thiR+y d@Y\$";
$lang['never'] = "n3v3r";
$lang['polladditionalmessage'] = "aDDI+1oN4L M3S\$49e (0p+I0N4L)";
$lang['polladditionalmessageexp'] = "do J00 wAn+ +0 InCLUDE 4N 4DD1+10nAl PosT 4Pht3r +he p0ll?";
$lang['mustspecifypolltoview'] = "j00 MuST \$p3C1PhY A P0ll t0 v1ew.";
$lang['pollconfirmclose'] = "ar3 J00 5URE j00 WAnt +o cL0se Th3 FOllOwiN9 P0LL?";
$lang['endpoll'] = "end p0LL";
$lang['nobodyvotedclosedpoll'] = "nO8ody V0T3D";
$lang['votedisplayopenpoll'] = "%s @Nd %s HAvE voTeD.";
$lang['votedisplayclosedpoll'] = "%s @ND %s Vot3D.";
$lang['nousersvoted'] = "n0 USeRs";
$lang['oneuservoted'] = "1 U\$er";
$lang['xusersvoted'] = "%s u\$eR\$";
$lang['noguestsvoted'] = "no GUe\$t5";
$lang['oneguestvoted'] = "1 guEs+";
$lang['xguestsvoted'] = "%s guE5+S";
$lang['pollhasended'] = "poLl h@S 3nDEd";
$lang['youvotedforpolloptionsondate'] = "j00 VotED FoR %s oN %s";
$lang['thisisapoll'] = "tHIS 1\$ 4 P0lL. cLiCK to V1Ew rE\$UL+\$.";
$lang['editpoll'] = "edit pOlL";
$lang['results'] = "rEsUL+S";
$lang['resultdetails'] = "rESUlT D3tA1l\$";
$lang['changevote'] = "ch4NGe VoTE";
$lang['pollshavebeendisabled'] = "pOlLS h@V3 83eN DI548lED 8y +hE fOrUM 0wn3R.";
$lang['answertext'] = "aN5W3R +3XT";
$lang['answergroup'] = "ansWer 9roUp";
$lang['previewvotingform'] = "pr3v1Ew Vo+In9 PhoRM";
$lang['viewbypolloption'] = "v13W by POlL 0PTI0N";
$lang['viewbyuser'] = "vIEW BY U\$3r";

// Profiles (profile.php) ----------------------------------------------

$lang['editprofile'] = "edIt PRoF1l3";
$lang['profileupdated'] = "pR0pH1l3 UpD@tEd.";
$lang['profilesnotsetup'] = "teH f0rUM oWN3R H4s N0T s3t UP prOpH1lEs.";
$lang['ignoreduser'] = "i9NOR3D uSEr";
$lang['lastvisit'] = "l4St V1sIT";
$lang['userslocaltime'] = "uSER's L0CAL TImE";
$lang['userstatus'] = "s+@tUS";
$lang['useractive'] = "onLINE";
$lang['userinactive'] = "in4c+IVe / oFpHL1ne";
$lang['totaltimeinforum'] = "t0T@L +1m3";
$lang['longesttimeinforum'] = "lon9E\$T \$3s\$10N";
$lang['sendemail'] = "senD 3maIL";
$lang['sendpm'] = "sEnD Pm";
$lang['visithomepage'] = "v1siT h0MEp49E";
$lang['age'] = "ag3";
$lang['aged'] = "aGEd";
$lang['birthday'] = "bIR+hD@y";
$lang['registered'] = "r3giST3reD";
$lang['findpostsmadebyuser'] = "fINd POSts M@D3 8Y %s";
$lang['findpostsmadebyme'] = "f1nD p0stS M@d3 bY m3";
$lang['profilenotavailable'] = "pR0ph1l3 n0T 4v41l48l3.";
$lang['userprofileempty'] = "thI\$ U\$3r hAs NO+ Ph1lleD 1n tHEiR pR0Ph1le 0R 1t 1\$ Se+ +0 PrIV4t3.";

// Registration (register.php) -----------------------------------------

$lang['newuserregistrationsarenotpermitted'] = "sOrRY, N3W us3r rE9Is+R4TIONS Ar3 nOT @lLOW3D r1GHt Now. PleAS3 CheCK 8@CK L4T3R.";
$lang['usernameinvalidchars'] = "u\$ErN4M3 c@N 0nLY C0NT4In 4-Z, 0-9, _ - cH4r4CtEr5";
$lang['usernametooshort'] = "useRNAM3 Mu\$+ 83 4 MiN1MUM 0f 2 Ch4RACt3rS lONG";
$lang['usernametoolong'] = "u53Rn@Me MuST Be 4 M@XIMuM OF 15 ch4RaCT3R5 L0NG";
$lang['usernamerequired'] = "a L0g0n n4m3 1s Requ1ReD";
$lang['passwdmustnotcontainHTML'] = "p@sSWoRD mUSt N0+ con+4IN H+ML T4G\$";
$lang['passwordinvalidchars'] = "pa\$\$w0rD C@N 0nLY C0NTaIN a-Z, 0-9, _ - ChaR4Ct3R5";
$lang['passwdtooshort'] = "p4\$\$w0RD mUS+ 8E @ M1nImUM OPh 6 Ch4r@C+3RS l0n9";
$lang['passwdrequired'] = "a P4SSW0RD 1\$ RequIReD";
$lang['confirmationpasswdrequired'] = "a c0nfIrM4t10N p@Ssw0RD 15 reQu1rED";
$lang['nicknamerequired'] = "a n1CkN4m3 1\$ rEqU1REd";
$lang['emailrequired'] = "an 3M41l 4DdR3\$S 15 R3quIR3D";
$lang['passwdsdonotmatch'] = "p4s\$w0RDs do noT M4Tch";
$lang['usernamesameaspasswd'] = "usERN@ME 4nD p45sw0rD MUsT 83 d1fPh3r3nT";
$lang['usernameexists'] = "sorrY, 4 U\$3R wItH +h4T N4M3 4LR34Dy 3xIS+s";
$lang['successfullycreateduseraccount'] = "sUCcEsspHuLlY CRE@T3D UseR acCOUNT";
$lang['useraccountcreatedconfirmfailed'] = "your Us3r 4CC0UN+ H@S b3en CR34+3D 8Ut +hE r3qUir3D C0NFIrM@tiON 3Ma1L WA\$ n0T \$enT. Pl34sE C0NT@C+ tH3 phOruM oWn3r t0 r3ct1FY +HI5. 1N tH1s mE@nTIMe PLeA\$3 CLiCK TEh C0NTinU3 8UttoN +O lOgiN.";
$lang['useraccountcreatedconfirmsuccess'] = "y0UR Us3R @Cc0uN+ h@S B3EN cr34+ED 8UT b3phoR3 J00 C@N \$+@Rt PosTinG j00 mU\$+ cONf1rM y0uR 3m41L 4Ddr35\$. pLe453 cH3CK YOUr Em4il FoR @ LINk th4+ WilL 4Ll0W J00 +0 c0nfIrm Y0UR 4DdRE\$s.";
$lang['useraccountcreated'] = "yoUr UsER 4CCoUnt h45 B3En Cr3@T3D \$UCc35SpHuLLY! cLIck TH3 cON+1NuE butT0N B3LOW T0 Lo9in";
$lang['errorcreatinguserrecord'] = "eRR0r CR3@TIN9 U5Er Rec0rd";
$lang['userregistration'] = "u\$eR r391S+r4t1ON";
$lang['registrationinformationrequired'] = "rE9i\$+R4TIoN 1Nph0RM@t1on (r3QUiReD)";
$lang['profileinformationoptional'] = "pr0FiL3 1NPHoRM4+10N (0p+Ion@L)";
$lang['preferencesoptional'] = "pRef3rEnC3S (0p+10N@l)";
$lang['register'] = "re9i\$+Er";
$lang['rememberpasswd'] = "r3mEmB3R p45sW0Rd";
$lang['birthdayrequired'] = "d4+3 Oph 8Ir+h i\$ rEqU1R3D 0r iS iNV@lID";
$lang['alwaysnotifymeofrepliestome'] = "nOTipHy 0N rEpLY +o M3";
$lang['notifyonnewprivatemessage'] = "no+IFY On N3W pRiv@+E M3S\$49e";
$lang['popuponnewprivatemessage'] = "pop Up On N3W Pr1v4te M3s\$49e";
$lang['automatichighinterestonpost'] = "au+0M@tIc H1Gh 1N+eRe\$+ 0N P0\$T";
$lang['confirmpassword'] = "cONpH1RM PA5\$W0rD";
$lang['invalidemailaddressformat'] = "inV4L1D Em4il 4DdR35S pHoRm4t";
$lang['moreoptionsavailable'] = "morE pR0pHiLE @Nd PrEPhER3nc3 0PTi0nS Are @V@1L4Bl3 oNcE J00 REG1\$t3r";
$lang['textcaptchaconfirmation'] = "coNpH1RM4TioN";
$lang['textcaptchaexplain'] = "t0 TeH Ri9H+ 1s @ +EX+-C4PTcH@ iM49E. pLe4sE TyPE THe c0D3 J00 c4N \$E3 1n +3H 1M@93 INtO th3 InPUT PH13lD 83l0W iT.";
$lang['textcaptchaimgtip'] = "tHi\$ 1\$ @ c4PTch4-PIcTurE. I+ 1S uSEd +O PReV3N+ 4u+0M@tIC r3GIStrA+10n";
$lang['textcaptchamissingkey'] = "a ConF1RM4t1oN c0De 1\$ R3qUiReD.";
$lang['textcaptchaverificationfailed'] = "tex+-c@ptch@ vErIPh1C4ti0n C0D3 w@S 1nC0RRect. pLE4SE Re-3N+eR I+.";
$lang['forumrules'] = "fORum rUL3s";
$lang['forumrulesnotification'] = "iN 0Rd3r +o pR0CeEd, J00 Mus+ 4grE3 wiTh Teh Ph0ll0wInG rULes";
$lang['forumrulescheckbox'] = "i H4vE rE@D, 4nd 49R3E t0 A8Id3 8Y +h3 f0ruM rUL3S.";
$lang['youmustagreetotheforumrules'] = "j00 MuS+ 4GR33 T0 +HE PhOruM rULE\$ 8EPH0Re J00 C4N C0NT1NuE.";

// Recent visitors list  (visitor_log.php) -----------------------------

$lang['member'] = "mEMbER";
$lang['searchforusernotinlist'] = "se4rcH FOr 4 U\$3r Not 1n lIST";
$lang['yoursearchdidnotreturnanymatches'] = "y0Ur se4rCh DiD NOT Re+uRn 4ny M@tCHES. +Ry \$1mPlIFYiN9 Y0Ur S3arCH P@RAM3T3rS aNd +rY 4941N.";
$lang['hiderowswithemptyornullvalues'] = "hId3 RoW\$ WiTh EMP+y 0R NUlL V@LU35 In 5eL3C+Ed C0LuMNs";
$lang['showregisteredusersonly'] = "sH0w r39i\$+3R3d U\$3r5 0nLY (HiD3 9UE\$+5)";

// Relationships (user_rel.php) ----------------------------------------

$lang['relationships'] = "rel@+iOn\$HipS";
$lang['userrelationship'] = "u\$3R r3L4TIOn\$H1P";
$lang['userrelationships'] = "u\$ER r3l@+1OnsHipS";
$lang['failedtoremoveselectedrelationships'] = "f@1leD T0 R3M0v3 SeleCtED REL@TIoN\$h1P";
$lang['friends'] = "fri3NDS";
$lang['ignoredcompletely'] = "igN0ReD comPL3+eLY";
$lang['relationship'] = "rel4TION\$H1p";
$lang['restorenickname'] = "rES+Or3 U\$3R'S NIcKN4m3";
$lang['friend_exp'] = "u\$3R'5 poSt5 m@rK3D W1+H 4 &quot;FRiENd&quot; 1Con.";
$lang['normal_exp'] = "u\$3R'S P0sTS aPpE@r 4\$ N0Rm@L.";
$lang['ignore_exp'] = "u53r'\$ p0ST\$ 4rE hIdD3N.";
$lang['ignore_completely_exp'] = "thr34d\$ @Nd PO5T5 T0 0R PHrOM USEr WilL 4pP34r DelE+3D.";
$lang['display'] = "d1\$pL4y";
$lang['displaysig_exp'] = "u53R's \$I9NA+ur3 is DI5pl@YeD 0N th31r POST5.";
$lang['hidesig_exp'] = "us3R'5 S1GN4TURe I\$ HIdDen 0N +HeIR p05+s.";
$lang['cannotignoremod'] = "j00 c@nnOt I9norE tH1\$ U\$er, @\$ TH3Y 4RE 4 M0DEr4t0r.";
$lang['previewsignature'] = "pR3V13W \$i9n@TuRE";

// Search (search.php) -------------------------------------------------

$lang['searchresults'] = "sEARcH R3SULts";
$lang['usernamenotfound'] = "th3 U\$3rn@mE j00 SP3ciFiEd 1N +hE +O 0R FrOM FIeLD W@s N0t phOuND.";
$lang['notexttosearchfor'] = "one 0R @lL oF YOuR \$34RcH K3YWOrD\$ WeR3 1NV4L1D. s34rcH K3YwoRd5 MUsT 8E N0 \$hoR+ER th4n %d cH4R4C+3rs, nO LONG3R tH@n %d cH4r4C+3r\$ @Nd Mu5+ n0+ 4pPE@R IN +He %s";
$lang['keywordscontainingerrors'] = "k3YwOrDS COn+4INiN9 ERr0rs: %s";
$lang['mysqlstopwordlist'] = "mYSQl 5+OpWORd L15+";
$lang['foundzeromatches'] = "f0uND: 0 M@tch3s";
$lang['found'] = "f0UNd";
$lang['matches'] = "m4tcHE\$";
$lang['prevpage'] = "preV1oU5 p@9E";
$lang['findmore'] = "f1nD m0r3";
$lang['searchmessages'] = "se@RCh M3\$\$4Ge\$";
$lang['searchdiscussions'] = "sE4rch d1sCu\$\$1OnS";
$lang['find'] = "finD";
$lang['additionalcriteria'] = "aDdI+10N@L crI+ER1@";
$lang['searchbyuser'] = "s34RcH 8y U\$eR (0p+10n@L)";
$lang['folderbrackets_s'] = "fold3r(\$)";
$lang['postedfrom'] = "pO\$+Ed Fr0M";
$lang['postedto'] = "p0St3D +o";
$lang['today'] = "t0D@y";
$lang['yesterday'] = "y3s+3RD4Y";
$lang['daybeforeyesterday'] = "d4y b3pHOR3 y35teRd@y";
$lang['weekago'] = "%s w3EK 490";
$lang['weeksago'] = "%s WeeK5 49o";
$lang['monthago'] = "%s moN+h A9O";
$lang['monthsago'] = "%s M0N+H\$ 4GO";
$lang['yearago'] = "%s YE4r 490";
$lang['beginningoftime'] = "b3g1nN1N9 OPh +1M3";
$lang['now'] = "nOW";
$lang['lastpostdate'] = "l4st P0ST D@+E";
$lang['numberofreplies'] = "num83r oF rEPLIeS";
$lang['foldername'] = "fOldER n@ME";
$lang['authorname'] = "aUtHOr N4m3";
$lang['decendingorder'] = "newEst PH1R\$+";
$lang['ascendingorder'] = "olde\$t f1rs+";
$lang['keywords'] = "k3yW0RDS";
$lang['sortby'] = "soR+ bY";
$lang['sortdir'] = "sORT d1r";
$lang['sortresults'] = "soR+ rEsUL+S";
$lang['groupbythread'] = "gR0Up 8y thR34d";
$lang['postsfromuser'] = "p0s+S PHROm U\$eR";
$lang['threadsstartedbyuser'] = "thR34ds ST4R+3d 8Y us3R";
$lang['searchfrequencyerror'] = "j00 C4n OnlY 534RcH ONCe EvERy %s 5ECoNDs. pl34se trY 4G@in l4teR.";
$lang['searchsuccessfullycompleted'] = "s3arCh SuCcES5PhULlY cOMpL3TeD. %s";
$lang['clickheretoviewresults'] = "cL1cK Her3 +O v13w R35uL+\$.";

// Search Popup (search_popup.php) -------------------------------------

$lang['select'] = "selEcT";
$lang['searchforthread'] = "s34RCh fOR +hR3@d";
$lang['mustspecifytypeofsearch'] = "j00 mUs+ 5PECiFy +YP3 0F Se@RcH +0 P3RForM";
$lang['unkownsearchtypespecified'] = "unknOWN SEArch +YPe SpEC1PH13D";
$lang['mustentersomethingtosearchfor'] = "j00 mU5T En+3r \$oM3TH1N9 +0 sEARCh FOr";

// Start page (start_left.php) -----------------------------------------

$lang['recentthreads'] = "recEnT thRe@d\$";
$lang['startreading'] = "sT@Rt ReAd1Ng";
$lang['threadoptions'] = "thr3ad OPti0NS";
$lang['editthreadoptions'] = "edIT +hRE4D 0p+10N\$";
$lang['morevisitors'] = "m0R3 viS1+Or5";
$lang['forthcomingbirthdays'] = "fOrTHcOmiN9 bIRThd4YS";

// Start page (start_main.php) -----------------------------------------

$lang['editstartpage_help'] = "j00 C@N 3Dit +hiS P@93 FroM tH3 4dM1N 1N+3Rf4cE";

// Thread navigation (thread_list.php) ---------------------------------

$lang['newdiscussion'] = "nEW d1\$cuS510n";
$lang['createpoll'] = "cRe@TE P0LL";
$lang['search'] = "s3arCH";
$lang['searchagain'] = "se4RcH 4G41N";
$lang['alldiscussions'] = "alL D1\$cUs\$10N\$";
$lang['unreaddiscussions'] = "uNrE@D dIScUS\$iONs";
$lang['unreadtome'] = "unr3@D &quot;T0: mE&quot;";
$lang['todaysdiscussions'] = "todAy's D15CUSS10nS";
$lang['2daysback'] = "2 D4YS b4Ck";
$lang['7daysback'] = "7 D4YS 84CK";
$lang['highinterest'] = "h1GH iNt3rEs+";
$lang['unreadhighinterest'] = "unr34D h1gH 1NtER3sT";
$lang['iverecentlyseen'] = "i'v3 rEC3NTly s3en";
$lang['iveignored'] = "i'vE i9Nor3D";
$lang['byignoredusers'] = "bY 1gN0ReD us3r\$";
$lang['ivesubscribedto'] = "i've SU8\$CR183d +0";
$lang['startedbyfriend'] = "sT@rt3D 8Y PhRi3Nd";
$lang['unreadstartedbyfriend'] = "uNR34d stD by phRiEND";
$lang['startedbyme'] = "s+4RT3D 8y Me";
$lang['unreadtoday'] = "uNReAD +Od@Y";
$lang['deletedthreads'] = "del3+3D Thre4d\$";
$lang['goexcmark'] = "g0!";
$lang['folderinterest'] = "folD3r INT3RE5T";
$lang['postnew'] = "pOst NEw";
$lang['currentthread'] = "curREn+ ThRE@D";
$lang['highinterest'] = "higH 1n+ErE\$+";
$lang['markasread'] = "m@RK 4S Re4D";
$lang['next50discussions'] = "nEXT 50 DI5Cu\$S10nS";
$lang['visiblediscussions'] = "v1\$18LE DI\$cUsSiON\$";
$lang['selectedfolder'] = "seL3c+ED FoLDeR";
$lang['navigate'] = "n4VI94TE";
$lang['couldnotretrievefolderinformation'] = "th3R3 4re N0 phOLDERs 4VAiL4BLe.";
$lang['nomessagesinthiscategory'] = "n0 m3ss49e\$ 1n THis C4+eGOrY. pLe@Se 53LEC+ 4N0+H3R, 0r %s F0r aLL THrE4DS";
$lang['clickhere'] = "cLiCk H3RE";
$lang['prev50threads'] = "prEv1oU\$ 50 ThRE@D\$";
$lang['next50threads'] = "n3xT 50 THr34dS";
$lang['nextxthreads'] = "nExT %s ThrE@dS";
$lang['threadstartedbytooltip'] = "tHRE4D #%s 5t4R+3D 8y %s. V13w3D %s";
$lang['threadviewedonetime'] = "1 TIMe";
$lang['threadviewedtimes'] = "%d TIm3S";
$lang['unreadthread'] = "uNre@d +HrE4D";
$lang['readthread'] = "r3@D +Hr34D";
$lang['unreadmessages'] = "uNRe4D M3\$s493S";
$lang['subscribed'] = "sUBsCRi83d";
$lang['ignorethisfolder'] = "i9Nor3 TH15 FOlD3R";
$lang['stopignoringthisfolder'] = "sToP i9n0rIng +Hi5 PHOLDER";
$lang['stickythreads'] = "s+1CKy thr34D\$";
$lang['mostunreadposts'] = "m0\$+ uNReAD P0\$t5";
$lang['onenew'] = "%d New";
$lang['manynew'] = "%d nEw";
$lang['onenewoflength'] = "%d n3w 0Ph %d";
$lang['manynewoflength'] = "%d N3w 0F %d";
$lang['ignorefolderconfirm'] = "aR3 J00 SUrE j00 W4nT T0 I9N0R3 TH1\$ pH0LDER?";
$lang['unignorefolderconfirm'] = "aR3 j00 sURe j00 W4N+ T0 \$+oP 1GNOR1N9 +H15 FolD3R?";
$lang['confirmmarkasread'] = "aRe J00 suRE J00 W@n+ +o MArK +He 53l3c+3D tHre@D\$ 4\$ R34D?";
$lang['successfullymarkreadselectedthreads'] = "sUccE5\$PHuLLY M4RK3D 53L3C+3d thRE4dS @S R34D";
$lang['failedtomarkselectedthreadsasread'] = "f@ilED +O m@Rk 53LeCT3D THrE4DS 45 R3@d";
$lang['gotofirstpostinthread'] = "g0 TO pH1R\$T pOSt 1n tHRe@d";
$lang['gotolastpostinthread'] = "gO TO l@ST pO5+ In +hR34d";
$lang['viewmessagesinthisfolderonly'] = "viEW m3S54gE\$ IN TH1\$ F0LdEr 0Nly";
$lang['shownext50threads'] = "shOw NEx+ 50 +hre@d\$";
$lang['showprev50threads'] = "show pR3V1OuS 50 +HrE4DS";
$lang['createnewdiscussioninthisfolder'] = "creA+E neW DI\$CuSS10N 1N Th1\$ phOlDer";
$lang['nomessages'] = "n0 ME5s@93s";

// HTML toolbar (htmltools.inc.php) ------------------------------------
$lang['bold'] = "b0LD";
$lang['italic'] = "i+@lIc";
$lang['underline'] = "uNDeRLiNE";
$lang['strikethrough'] = "str1k3THR0UGh";
$lang['superscript'] = "sUperScRIP+";
$lang['subscript'] = "sUb5cripT";
$lang['leftalign'] = "l3pH+-4l1gn";
$lang['center'] = "c3NT3R";
$lang['rightalign'] = "right-@L19N";
$lang['numberedlist'] = "nuMbEReD l1st";
$lang['list'] = "lI\$+";
$lang['indenttext'] = "indEn+ t3X+";
$lang['code'] = "coDE";
$lang['quote'] = "quo+E";
$lang['unquote'] = "unQU0tE";
$lang['spoiler'] = "sp01l3R";
$lang['horizontalrule'] = "hoR1z0nt4L rUL3";
$lang['image'] = "im4ge";
$lang['hyperlink'] = "hYPErL1NK";
$lang['noemoticons'] = "d1s4BL3 Em0+1c0N5";
$lang['fontface'] = "fon+ f@cE";
$lang['size'] = "s1ZE";
$lang['colour'] = "c0louR";
$lang['red'] = "rED";
$lang['orange'] = "or4n9E";
$lang['yellow'] = "yElLow";
$lang['green'] = "gr3eN";
$lang['blue'] = "blue";
$lang['indigo'] = "ind19o";
$lang['violet'] = "viOL3+";
$lang['white'] = "wH1t3";
$lang['black'] = "bLacK";
$lang['grey'] = "grey";
$lang['pink'] = "p1nK";
$lang['lightgreen'] = "liGHt GrE3N";
$lang['lightblue'] = "lIght bLuE";

// Forum Stats (messages.inc.php - messages_forum_stats()) -------------

$lang['forumstats'] = "f0RUm \$+4+S";
$lang['usersactiveinthepasttimeperiod'] = "%s 4cT1ve 1N t3H p4\$t %s. %s";

$lang['numactiveguests'] = "<b>%s</b> gU3s+s";
$lang['oneactiveguest'] = "<b>1</b> gUE\$+";
$lang['numactivemembers'] = "<b>%s</b> M3m83r5";
$lang['oneactivemember'] = "<b>1</b> mEMb3r";
$lang['numactiveanonymousmembers'] = "<b>%s</b> 4N0NYM0U5 m3m83R\$";
$lang['oneactiveanonymousmember'] = "<b>1</b> 4n0nYm0US M3M8eR";

$lang['numthreadscreated'] = "<b>%s</b> +hR3@dS";
$lang['onethreadcreated'] = "<b>1</b> +hrEaD";
$lang['numpostscreated'] = "<b>%s</b> Po5t\$";
$lang['onepostcreated'] = "<b>1</b> pO\$+";

$lang['younormal'] = "j00";
$lang['youinvisible'] = "j00 (InVi\$1BL3)";
$lang['viewcompletelist'] = "v13W C0MPLe+E LI\$t";
$lang['ourmembershavemadeatotalofnumthreadsandnumposts'] = "oUr M3m8eRS H@VE M4D3 4 +Ot4l OPh %s @nD %s.";
$lang['longestthreadisthreadnamewithnumposts'] = "lonGe\$+ +HRe@d 1s <b>%s</b> WItH %s.";
$lang['therehavebeenxpostsmadeinthelastsixtyminutes'] = "ther3 HAvE b33n <b>%s</b> p0STs M4D3 1n tH3 L@5+ 60 M1nU+3\$.";
$lang['therehasbeenonepostmadeinthelastsxityminutes'] = "tHeR3 h@5 8E3N <b>1</b> p0sT M4D3 1n ThE L4sT 60 M1NUtE5.";
$lang['mostpostsevermadeinasinglesixtyminuteperiodwasnumposts'] = "mOS+ P05+S EVeR m4D3 in 4 s1n9l3 60 mInutE Per10D 1\$ <b>%s</b> 0N %s.";
$lang['wehavenumregisteredmembersandthenewestmemberismembername'] = "w3 h4VE <b>%s</b> R39I\$TerEd m3M8ERs @ND +H3 NeWEst mEMb3r iS <b>%s</b>.";
$lang['wehavenumregisteredmember'] = "wE H4V3 %s ReGI5+3R3D M3M83r5.";
$lang['wehaveoneregisteredmember'] = "wE H4v3 0N3 ReG1S+3red MEm8Er.";
$lang['mostuserseveronlinewasnumondate'] = "m0s+ uS3RS 3V3R ONlINe wAs <b>%s</b> 0n %s.";
$lang['statsdisplaychanged'] = "s+@TS dI\$Pl4y ChAN9ED";

// Thread Options (thread_options.php) ---------------------------------

$lang['updatessavedsuccessfully'] = "uPda+35 5@VeD sUcCE\$SPhuLLy";
$lang['useroptions'] = "u53R op+10NS";
$lang['markedasread'] = "m4rk3d @S R34d";
$lang['postsoutof'] = "p0st5 Out oF";
$lang['interest'] = "intERe\$T";
$lang['closedforposting'] = "clO5eD pH0R p0sTInG";
$lang['locktitleandfolder'] = "l0Ck t1+lE @Nd foLd3R";
$lang['deletepostsinthreadbyuser'] = "d3LE+3 Po5t5 1n THRE@d by U5ER";
$lang['deletethread'] = "d3LE+3 +HrE@d";
$lang['permenantlydelete'] = "perM4N3NTlY d3l3+E";
$lang['movetodeleteditems'] = "mov3 T0 d3LETEd Thr34DS";
$lang['undeletethread'] = "uNd3lE+3 +HRe4d";
$lang['markasunread'] = "m@RK 4S UnR34d";
$lang['makethreadsticky'] = "m4K3 THrE@d SticKy";
$lang['threareadstatusupdated'] = "thr3aD R34d st4Tus UPD@+3D sucC3S\$pHuLLY";
$lang['interestupdated'] = "thR3@d In+3RE\$T ST4TUs UPD4TeD SUcC35sPHULLy";
$lang['failedtoupdatethreadreadstatus'] = "f41l3D +o uPD4+3 +hRE@D r3ad 5+4Tu\$";
$lang['failedtoupdatethreadinterest'] = "f4IlEd +O UPd4te ThReAd iNT3rE\$+";
$lang['failedtorenamethread'] = "fAilEd +o rEn@ME tHRE@D";
$lang['failedtomovethread'] = "f@1L3D tO MOvE THr3@D T0 5PEC1PH13D F0LDeR";
$lang['failedtoupdatethreadstickystatus'] = "fAiLEd t0 UPdA+3 +hrEad stICkY ST4tU\$";
$lang['failedtoupdatethreadclosedstatus'] = "f@1l3D +o uPd4t3 +Hr34D CL0s3D sT4tu5";
$lang['failedtoupdatethreadlockstatus'] = "f4iL3D +0 UpdA+3 +hr3@d l0cK st4TU\$";
$lang['failedtodeletepostsbyuser'] = "f4iL3D t0 D3lET3 P0s+\$ by \$3l3cT3D Us3r";
$lang['failedtodeletethread'] = "f4Il3D T0 d3lEt3 +hRE@d.";
$lang['failedtoundeletethread'] = "f41L3D +O un-D3L3T3 thReAD";

// Dictionary (dictionary.php) -----------------------------------------

$lang['dictionary'] = "d1CTiOnaRy";
$lang['spellcheck'] = "spELL CHeck";
$lang['notindictionary'] = "no+ In D1C+10n@RY";
$lang['changeto'] = "ch@n93 T0";
$lang['restartspellcheck'] = "r3st4RT";
$lang['cancelchanges'] = "c4nC3L cHANgE\$";
$lang['initialisingdotdotdot'] = "iN1+I4L1s1N9...";
$lang['spellcheckcomplete'] = "spEll cH3CK IS COmPLeTE. T0 R3ST4R+ 5pELl cheCk CL1Ck R35+4Rt 8U+t0n b3LOW.";
$lang['spellcheck'] = "spEll chECK";
$lang['noformobj'] = "n0 PhORM o8jeC+ \$P3CifI3D pH0R r3TURn TeX+";
$lang['bodytext'] = "b0dY +3XT";
$lang['ignore'] = "i9nOrE";
$lang['ignoreall'] = "i9NORE @Ll";
$lang['change'] = "cH@N93";
$lang['changeall'] = "cHaN9E 4LL";
$lang['add'] = "adD";
$lang['suggest'] = "suGG3s+";
$lang['nosuggestions'] = "(NO 5uGG3s+10n\$)";
$lang['cancel'] = "c4nC3L";
$lang['dictionarynotinstalled'] = "nO D1CT1on4ry Ha\$ 8E3n in\$+4Ll3d. pLE@s3 c0nT@CT t3h Phorum owN3r T0 r3M3DY +Hi5.";

// Permissions keys ----------------------------------------------------

$lang['postreadingallowed'] = "po\$+ RE4D1N9 @LlOWeD";
$lang['postcreationallowed'] = "p05T cR34+10N aLL0WeD";
$lang['threadcreationallowed'] = "tHr34d Cr34+10n AlL0W3D";
$lang['posteditingallowed'] = "p0st 3d1+iNg 4LL0w3D";
$lang['postdeletionallowed'] = "p0s+ D3lE+I0n 4Ll0w3D";
$lang['attachmentsallowed'] = "aTT4CHm3ntS @lloW3D";
$lang['htmlpostingallowed'] = "h+mL PO5+1nG 4llOwEd";
$lang['signatureallowed'] = "sI9nA+Ur3 4lLoWED";
$lang['guestaccessallowed'] = "guE\$+ 4Cc35\$ 4LLow3D";
$lang['postapprovalrequired'] = "pos+ 4pPROv@L R3QUiReD";

// RSS feeds gubbins

$lang['rssfeed'] = "r\$s F33d";
$lang['every30mins'] = "ev3ry 30 M1Nu+3s";
$lang['onceanhour'] = "oNCE @N HOuR";
$lang['every6hours'] = "ev3RY 6 h0uR\$";
$lang['every12hours'] = "ev3Ry 12 H0URs";
$lang['onceaday'] = "oncE 4 day";
$lang['onceaweek'] = "onC3 4 wEEK";
$lang['rssfeeds'] = "r5\$ phE3DS";
$lang['feedname'] = "feED N@Me";
$lang['feedfoldername'] = "fE3d pH0LD3R n4ME";
$lang['feedlocation'] = "fE3D loc4tI0N";
$lang['threadtitleprefix'] = "tHR3@D TI+LE PR3fIX";
$lang['feednameandlocation'] = "feed N@ME 4Nd L0C@T10n";
$lang['feedsettings'] = "f33d s3Tt1Ngs";
$lang['updatefrequency'] = "upd4T3 FR3Qu3nCY";
$lang['rssclicktoreadarticle'] = "clICk HEr3 +0 rE@d ThI\$ 4R+iClE";
$lang['addnewfeed'] = "add n3w PH33D";
$lang['editfeed'] = "ed1+ f33d";
$lang['feeduseraccount'] = "f33D uSEr AcC0uNt";
$lang['noexistingfeeds'] = "no exI5+IN9 R5s PH33d\$ F0uND. +o 4Dd 4 F33D cLIcK Th3 '@Dd N3W' 8UT+ON 8ELOw";
$lang['rssfeedhelp'] = "her3 J00 C@N Se+Up S0M3 R\$S f3ed5 FOR @UtOM@+1C Pr0P4G4TI0N inTo Y0Ur PHorUm. +3h 1TEm\$ FrOm tH3 r\$s F3ED5 J00 @dD W1LL 8e cR3@Ted @5 thRe4DS Wh1CH uS3RS C@n R3PLY +O 45 If THey W3r3 n0rm4L Po5t5. +3H R5S F3Ed MusT B3 4CcE\$\$18LE v1@ H+TP Or IT w1LL noT WorK.";
$lang['mustspecifyrssfeedname'] = "mUS+ \$pEc1fY rSS f3Ed N4Me";
$lang['mustspecifyrssfeeduseraccount'] = "mUs+ \$p3c1fy rss pHe3d u5er @CC0UNt";
$lang['mustspecifyrssfeedfolder'] = "mU\$+ sPeC1phy r\$s PhE3d F0lDEr";
$lang['mustspecifyrssfeedurl'] = "mu\$+ \$pEc1PHY RS5 PhE3d URL";
$lang['mustspecifyrssfeedupdatefrequency'] = "mus+ \$Pec1FY r\$S phe3d UpD@+E phreQu3nCy";
$lang['unknownrssuseraccount'] = "unKN0wN RSS u5ER 4ccOunT";
$lang['rssfeedsupportshttpurlsonly'] = "r5\$ PHe3d SUPP0RTS HT+p URL5 0nlY. S3CURE pHeeDs (ht+ps://) @R3 NO+ suPP0r+3d.";
$lang['rssfeedurlformatinvalid'] = "rs\$ PHE3D uRL fORma+ 1\$ 1NV4LId. uRL mUS+ 1NclUDE sCH3mE (E.g. h+Tp://) @nd 4 Ho5+N4M3 (3.G. WwW.ho\$+naM3.c0M).";
$lang['rssfeeduserauthentication'] = "rS\$ PHe3d D0e\$ N0+ suppOr+ H++p US3r @UthEnT1C@+10n";
$lang['successfullyremovedselectedfeeds'] = "sUCcESspHuLLy R3M0VED S3L3C+3D pH33DS";
$lang['successfullyaddedfeed'] = "suCcE5\$phuLly 4DD3D nEW F3Ed";
$lang['successfullyeditedfeed'] = "sucCEsSpHUlLY Ed1T3D pH33D";
$lang['failedtoremovefeeds'] = "faILED +0 R3m0V3 soM3 0R @lL oF +Eh 53leCt3d PhE3Ds";
$lang['failedtoaddnewrssfeed'] = "f4iLeD +o 4dd N3W r55 pHE3D";
$lang['failedtoupdaterssfeed'] = "f41LEd +0 UPD4tE r5\$ f3eD";
$lang['rssstreamworkingcorrectly'] = "r5s STR34M 4PPe4R\$ T0 8e W0RKiNG COrR3ctLY";
$lang['rssstreamnotworkingcorrectly'] = "r\$s 5tR34M W@s eMp+Y 0r C0UlD nOT B3 foUnD";
$lang['invalidfeedidorfeednotfound'] = "iNVAL1D f3eD ID OR ph3ED nOt Ph0UNd";

// PM Export Options

$lang['pmexportastype'] = "eXPoR+ 4\$ TyPE";
$lang['pmexporthtml'] = "hTML";
$lang['pmexportxml'] = "xML";
$lang['pmexportplaintext'] = "pl41N TEXT";
$lang['pmexportmessagesas'] = "exP0rt M3s54g3\$ @s";
$lang['pmexportonefileforallmessages'] = "on3 PH1Le PH0R alL M35s@93s";
$lang['pmexportonefilepermessage'] = "oN3 ph1L3 P3R m35\$49e";
$lang['pmexportattachments'] = "eXP0RT @T+@cHmEnT\$";
$lang['pmexportincludestyle'] = "inCLuDE F0rUM 5+yL3 \$HE3+";
$lang['pmexportwordfilter'] = "aPpLy WORd pHilTEr +0 mE5s@93s";

// Thread merge / split options

$lang['threadhasbeensplit'] = "thr3@D H@S 83en spli+";
$lang['threadhasbeenmerged'] = "thrE4D H4S B3En M3rg3d";
$lang['mergesplitthread'] = "m3R9E / SpLIt ThRE4D";
$lang['mergewiththreadid'] = "m3R93 wi+h +hREaD 1D:";
$lang['postsinthisthreadatstart'] = "p0\$+S 1n thI\$ tHr3@d @t \$+4RT";
$lang['postsinthisthreadatend'] = "p05+\$ 1N THI\$ +Hr34D @t ENd";
$lang['reorderpostsintodateorder'] = "r3-oRdER P0sT\$ int0 DATe 0rd3r";
$lang['splitthreadatpost'] = "sPL1t thRe@d @t P0St:";
$lang['selectedpostsandrepliesonly'] = "s3l3C+3D p05+ 4ND REPlI35 0NLY";
$lang['selectedandallfollowingposts'] = "sELECT3D 4Nd 4LL PH0Ll0wIn9 PO5T\$";

$lang['threadmovedhere'] = "h3r3";

$lang['thisthreadhasmoved'] = "<b>tHReAds m3rgeD:</b> TH15 +hRE@D H4S Mov3d %s";
$lang['thisthreadwasmergedfrom'] = "<b>tHR34DS MER93D:</b> +H1\$ ThrE@D wA5 M3rg3d PHr0m %s";
$lang['somepostsinthisthreadhavebeenmoved'] = "<b>thre@d \$PLiT:</b> SOMe p0\$+s 1N th1\$ THrE@d h4V3 b3en m0v3d %s";
$lang['somepostsinthisthreadweremovedfrom'] = "<b>threAD SPl1+:</b> 5OM3 P0s+S 1N th1\$ tHrE4D WERE M0V3D phR0M %s";

$lang['thisposthasbeenmoved'] = "<b>thRe4D SPlI+:</b> +HIS poSt H45 8E3N MoVED %s";

$lang['invalidfunctionarguments'] = "inV@L1D pHuNctiON @rGUM3nTS";
$lang['couldnotretrieveforumdata'] = "c0UlD Not rE+r13v3 F0RuM D4T4";
$lang['cannotmergepolls'] = "oN3 0R M0R3 THre4ds 15 4 PolL. J00 c@Nn0+ Mer9e POLLs";
$lang['couldnotretrievethreaddatamerge'] = "could NOt R3+r13Ve ThRe4D D4+4 frOm On3 0r M0Re +HreADS";
$lang['couldnotretrievethreaddatasplit'] = "c0ULD NOt R3+R13v3 +HrE@D d4t4 PhRoM \$0URC3 tHR34D";
$lang['couldnotretrievepostdatamerge'] = "c0Uld N0T r3tRi3v3 poSt D@+@ fr0m on3 0R m0rE +hRE@D\$";
$lang['couldnotretrievepostdatasplit'] = "c0ULd N0T R3TRi3v3 PosT D4t4 fROm \$ourcE tHRe4D";
$lang['failedtocreatenewthreadformerge'] = "f4Il3D t0 cr3@Te N3W ThR34D phor Merg3";
$lang['failedtocreatenewthreadforsplit'] = "f41lEd T0 cR34+e N3W +HR34D fOR sPliT";

// Thread subscriptions

$lang['threadsubscriptions'] = "tHR3@d \$U8\$CRiPTIoN\$";
$lang['couldnotupdateinterestonthread'] = "c0uLD nOt UpD4+3 In+3Re\$+ 0N +Hr34D '%s'";
$lang['threadinterestsupdatedsuccessfully'] = "thRE4D 1NT3Re\$t5 UpDA+3d sUcC3\$\$pHuLLy";
$lang['nothreadsubscriptions'] = "j00 Ar3 n0+ sU8scr1BeD +O @Ny +HrE4D5.";
$lang['resetselected'] = "rE\$3T \$eL3C+3D";
$lang['allthreadtypes'] = "aLL +HR34d +yp3S";
$lang['ignoredthreads'] = "i9nOR3D THrE4ds";
$lang['highinterestthreads'] = "hI9H 1N+3rE\$+ thRe4D\$";
$lang['subscribedthreads'] = "sUb5crIb3D +hR34D5";
$lang['currentinterest'] = "curR3n+ 1N+3Re\$+";

// Browseable user profiles

$lang['youcanonlyaddthreecolumns'] = "j00 c4n 0nlY 4Dd 3 C0LuMN\$. To 4dD A n3w c0luMn CLO53 AN ex1s+1N9 0n3";
$lang['columnalreadyadded'] = "j00 h4VE 4LrE4DY 4DdEd +hIS cOLuMN. IpH J00 W@NT T0 R3m0v3 1+ cL1Ck IT\$ cLosE bUT+oN";

?>