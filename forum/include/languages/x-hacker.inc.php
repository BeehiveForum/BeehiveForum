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

/* $Id: x-hacker.inc.php,v 1.283 2008-06-05 19:59:15 decoyduck Exp $ */

// British English language file

// Language character set and text direction options -------------------

$lang['_isocode'] = "en-gb";
$lang['_textdir'] = "ltr";

// Months --------------------------------------------------------------

$lang['month'][1]  = "j4nU@Ry";
$lang['month'][2]  = "fe8RUarY";
$lang['month'][3]  = "m4RCH";
$lang['month'][4]  = "aPR1l";
$lang['month'][5]  = "m4Y";
$lang['month'][6]  = "jUnE";
$lang['month'][7]  = "juLY";
$lang['month'][8]  = "au9Ust";
$lang['month'][9]  = "sePT3M83R";
$lang['month'][10] = "oC+Ob3R";
$lang['month'][11] = "n0v3MBER";
$lang['month'][12] = "d3C3mbeR";

$lang['month_short'][1]  = "j4n";
$lang['month_short'][2]  = "fEb";
$lang['month_short'][3]  = "m@r";
$lang['month_short'][4]  = "apR";
$lang['month_short'][5]  = "m4y";
$lang['month_short'][6]  = "jun";
$lang['month_short'][7]  = "jUl";
$lang['month_short'][8]  = "aug";
$lang['month_short'][9]  = "sEp";
$lang['month_short'][10] = "oCt";
$lang['month_short'][11] = "n0v";
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
$lang['date_periods']['month']  = "%s m0N+H";
$lang['date_periods']['week']   = "%s W3eK";
$lang['date_periods']['day']    = "%s dAY";
$lang['date_periods']['hour']   = "%s hoUR";
$lang['date_periods']['minute'] = "%s M1nut3";
$lang['date_periods']['second'] = "%s \$EC0ND";

// As above but plurals (2 years vs. 1 year, etc.)

$lang['date_periods_plural']['year']   = "%s y34R\$";
$lang['date_periods_plural']['month']  = "%s MON+hs";
$lang['date_periods_plural']['week']   = "%s WE3K5";
$lang['date_periods_plural']['day']    = "%s dAYS";
$lang['date_periods_plural']['hour']   = "%s HOUrs";
$lang['date_periods_plural']['minute'] = "%s minu+3s";
$lang['date_periods_plural']['second'] = "%s S3CondS";

// Short hand periods (example: 1y, 2m, 3w, 4d, 5hr, 6min, 7sec)

$lang['date_periods_short']['year']   = "%sy";    // 1y
$lang['date_periods_short']['month']  = "%sm";    // 2m
$lang['date_periods_short']['week']   = "%sw";    // 3w
$lang['date_periods_short']['day']    = "%sD";    // 4d
$lang['date_periods_short']['hour']   = "%sHR";   // 5hr
$lang['date_periods_short']['minute'] = "%sM1N";  // 6min
$lang['date_periods_short']['second'] = "%s\$eC";  // 7sec

// Common words --------------------------------------------------------

$lang['percent'] = "p3RC3N+";
$lang['average'] = "aVeR@Ge";
$lang['approve'] = "apProVE";
$lang['banned'] = "b4NNEd";
$lang['locked'] = "lockEd";
$lang['add'] = "adD";
$lang['advanced'] = "aDv4nCED";
$lang['active'] = "aCTIVE";
$lang['style'] = "sTyLE";
$lang['go'] = "go";
$lang['folder'] = "f0ld3R";
$lang['ignoredfolder'] = "i9N0R3d PH0LD3R";
$lang['folders'] = "fold3R\$";
$lang['thread'] = "thrE@d";
$lang['threads'] = "tHR34dS";
$lang['threadlist'] = "thr3aD L1s+";
$lang['message'] = "mEss49e";
$lang['from'] = "fROM";
$lang['to'] = "tO";
$lang['all_caps'] = "alL";
$lang['of'] = "of";
$lang['reply'] = "r3plY";
$lang['forward'] = "fOrW4RD";
$lang['replyall'] = "replY +0 @LL";
$lang['quickreply'] = "qu1CK rePlY";
$lang['quickreplyall'] = "qUICK rEPlY To 4lL";
$lang['pm_reply'] = "r3pLY 4s pM";
$lang['delete'] = "dEl3t3";
$lang['deleted'] = "d3l3+3D";
$lang['edit'] = "ed1+";
$lang['privileges'] = "pRiV1LE93s";
$lang['ignore'] = "ign0RE";
$lang['normal'] = "n0rM4l";
$lang['interested'] = "intER3S+3d";
$lang['subscribe'] = "sUBSCr1bE";
$lang['apply'] = "aPPLy";
$lang['download'] = "d0WNL04D";
$lang['save'] = "s@V3";
$lang['update'] = "upD@T3";
$lang['cancel'] = "canCEL";
$lang['continue'] = "c0ntInuE";
$lang['attachment'] = "a+t4CHmenT";
$lang['attachments'] = "aT+4CHMen+s";
$lang['imageattachments'] = "im@GE @T+4ChM3NtS";
$lang['filename'] = "f1lEN@M3";
$lang['dimensions'] = "d1mENS10N\$";
$lang['downloadedxtimes'] = "d0wNLO4D3D: %d TIm3s";
$lang['downloadedonetime'] = "d0WNlO@d3d: 1 +1mE";
$lang['size'] = "sIZ3";
$lang['viewmessage'] = "vI3w M3SS@g3";
$lang['deletethumbnails'] = "d3l3+3 THUm8n41LS";
$lang['logon'] = "l090n";
$lang['more'] = "mor3";
$lang['recentvisitors'] = "rec3NT V1SITOrs";
$lang['username'] = "us3Rn@Me";
$lang['clear'] = "cL34r";
$lang['reset'] = "r3\$3+";
$lang['action'] = "aCt10N";
$lang['unknown'] = "uNkNOwn";
$lang['none'] = "n0NE";
$lang['preview'] = "preVieW";
$lang['post'] = "p0sT";
$lang['posts'] = "pos+S";
$lang['change'] = "cH4nGe";
$lang['yes'] = "y3\$";
$lang['no'] = "no";
$lang['signature'] = "si9N@tuRE";
$lang['signaturepreview'] = "sIGN4tURE PR3V1EW";
$lang['signatureupdated'] = "sIGN4TUre UPda+3d";
$lang['signatureupdatedforallforums'] = "s1gNA+Ur3 UPd@TeD F0R 4LL F0RUmS";
$lang['back'] = "back";
$lang['subject'] = "su8J3ct";
$lang['close'] = "close";
$lang['name'] = "n@m3";
$lang['description'] = "de\$cRiP+10n";
$lang['date'] = "d4tE";
$lang['view'] = "vIEW";
$lang['enterpasswd'] = "en+3R pasSw0rD";
$lang['passwd'] = "p4SsW0RD";
$lang['ignored'] = "i9nOR3d";
$lang['guest'] = "gu3\$+";
$lang['next'] = "nEx+";
$lang['prev'] = "pr3Vi0US";
$lang['others'] = "oTh3rS";
$lang['nickname'] = "n1CKNaME";
$lang['emailaddress'] = "em@IL 4ddR3\$S";
$lang['confirm'] = "c0NpHIRM";
$lang['email'] = "em@IL";
$lang['poll'] = "poll";
$lang['friend'] = "frI3ND";
$lang['success'] = "sucCESs";
$lang['error'] = "eRROR";
$lang['warning'] = "w4RN1N9";
$lang['guesterror'] = "sorRY, j00 NeEd +0 B3 lo99ED in TO us3 THi\$ pH3A+urE.";
$lang['loginnow'] = "lo91n N0W";
$lang['unread'] = "unr3@D";
$lang['all'] = "aLl";
$lang['allcaps'] = "all";
$lang['permissions'] = "p3rMIs5i0Ns";
$lang['type'] = "typE";
$lang['print'] = "pR1NT";
$lang['sticky'] = "sTiCkY";
$lang['polls'] = "p0lL5";
$lang['user'] = "u53r";
$lang['enabled'] = "eN4bLEd";
$lang['disabled'] = "dIsaBLeD";
$lang['options'] = "op+1ON\$";
$lang['emoticons'] = "em0+1COn\$";
$lang['webtag'] = "wEbt@9";
$lang['makedefault'] = "m@KE d3Ph4uLt";
$lang['unsetdefault'] = "un\$3T D3pH@Ul+";
$lang['rename'] = "rEN4M3";
$lang['pages'] = "p@93\$";
$lang['used'] = "u\$ED";
$lang['days'] = "d4y\$";
$lang['usage'] = "uS49E";
$lang['show'] = "shOW";
$lang['hint'] = "hInT";
$lang['new'] = "n3w";
$lang['referer'] = "refER3R";
$lang['thefollowingerrorswereencountered'] = "th3 F0Ll0wINg erR0RS WER3 3ncOUN+ERed:";

// Admin interface (admin*.php) ----------------------------------------

$lang['admintools'] = "aDM1N T0Ols";
$lang['forummanagement'] = "f0ruM M4n4g3M3NT";
$lang['accessdeniedexp'] = "j00 D0 NO+ h@V3 P3RmISS1oN +O USE +H1S SecT10N.";
$lang['managefolders'] = "m4N@93 FOlDERs";
$lang['manageforums'] = "m4N49E foRuMS";
$lang['manageforumpermissions'] = "m4N@9E F0RUm P3RM1\$S1ON\$";
$lang['foldername'] = "f0ld3R n@M3";
$lang['move'] = "mov3";
$lang['closed'] = "cLO\$3D";
$lang['open'] = "open";
$lang['restricted'] = "rEs+rICtED";
$lang['forumiscurrentlyclosed'] = "%s i\$ CUrREN+LY clO\$3D";
$lang['youdonothaveaccesstoforum'] = "j00 d0 No+ H@V3 @cCess To %s";
$lang['toapplyforaccessplease'] = "t0 4PPlY PH0R 4CCe\$s pL34s3 coN+4c+ +h3 %s.";
$lang['forumowner'] = "fOruM oWN3R";
$lang['adminforumclosedtip'] = "iph J00 W4N+ To CH4N9e SOmE s3++1n9s 0N y0uR FORuM cl1CK t3H 4DMiN link 1N +H3 nAViGA+1on 8@r 480ve.";
$lang['newfolder'] = "new PHOldER";
$lang['nofoldersfound'] = "no eXI5+1N9 F0LD3r\$ f0UND. tO @DD a Ph0lD3R ClICK tHE '4dd N3W' BUTT0N 8elOW.";
$lang['forumadmin'] = "forUM adM1N";
$lang['adminexp_1'] = "u\$3 +HE m3nU oN THE l3PHT +O m@N493 +h1n95 IN YOUr FORuM.";
$lang['adminexp_2'] = "<b>u53R\$</b> 4LLOwS J00 +O \$3T 1NDiVIdU@L uSEr perM1SS10N\$, 1nclUD1Ng 4pPoIN+iNG m0DER@toR\$ aND 949G1Ng P30PLE.";
$lang['adminexp_3'] = "<b>us3r gR0UP\$</b> ALl0W\$ j00 +0 crE@+E US3R 9ROUps +0 @5\$i9n P3Rm1sS10N\$ +0 4\$ M@Ny 0R 4s PhEW u5ER\$ QuiCKlY @ND 3@SILy.";
$lang['adminexp_4'] = "<b>b4N c0NtROLS</b> 4ll0W\$ THe B4nnIN9 And UN-BANn1Ng OF IP aDDre\$s3\$, HTTp REFereRS, U\$ern4MES, 3M41L ADdRESsE5 4ND N1CKN4M3s.";
$lang['adminexp_5'] = "<b>f0ld3R\$</b> 4lL0WS THe cRe@ti0N, mODiPH1C@TI0N 4Nd D3L3+10N OF fOLDErs.";
$lang['adminexp_6'] = "<b>r55 FE3DS</b> @LL0W\$ j00 +0 m@N49E Rss FeeDS phoR PR0P49A+1oN iN+0 YouR f0rUM.";
$lang['adminexp_7'] = "<b>pR0PH1l35</b> L3TS j00 CustOmI5E +H3 I+3MS +hA+ 4pPe4r 1n +H3 uS3r PRoFILe\$.";
$lang['adminexp_8'] = "<b>forUM \$3+TInG\$</b> 4lL0ws J00 +0 CU\$toM1S3 YOUR Ph0rUM'S n@M3, @PP3AR4NCE @ND m4NY O+hER tHIN9\$.";
$lang['adminexp_9'] = "<b>s+4rT p@9E</b> L3+S J00 CUSt0mis3 Y0Ur PhorUm'S S+@R+ PAgE.";
$lang['adminexp_10'] = "<b>fOrUM s+Yle</b> 4Ll0WS j00 +O 93NEr@+3 rANDom s+Yle\$ FOR YOuR FOrUM M3mb3R\$ +0 uS3.";
$lang['adminexp_11'] = "<b>w0RD PHilTER</b> 4lLOWS j00 +0 fiLt3r WOrDS j00 D0N't W4N+ +0 83 UseD 0N YouR FORUm.";
$lang['adminexp_12'] = "<b>p05+1n9 \$+@t\$</b> 9EN3RA+3\$ @ r3pORt Li\$+1N9 thE TOP 10 PostER5 in a dEPHIn3d P3RiOd.";
$lang['adminexp_13'] = "<b>fOrUM l1nKS</b> l3tS J00 mANA93 tHE l1nK5 dROpDOWN In THe n@VI94+10N 84R.";
$lang['adminexp_14'] = "<b>vi3W L09</b> LIstS r3C3N+ ActI0NS 8y tHE FOruM MOdeR@t0RS.";
$lang['adminexp_15'] = "<b>m@n493 FORUMS</b> L3tS j00 cR34t3 AND D3lE+3 4ND cl0sE 0r R30P3N PHORUMS.";
$lang['adminexp_16'] = "<b>gL084L phorUM \$e++in9\$</b> 4LLOWs j00 +0 m0DipHY s3+tINgS wh1cH @FPhEC+ 4ll F0RUm5.";
$lang['adminexp_17'] = "<b>poS+ APpROV4L Queu3</b> 4lLOwS J00 t0 vIEw @ny PO\$+s @W4ITiN9 @pPROvaL By 4 M0DER4t0R.";
$lang['adminexp_18'] = "<b>vI\$ITOR l0G</b> @lLOws J00 +0 Vi3W an 3xT3NdeD l1\$t oF viSItoR5 1NCluDIng TH3IR H++p rEFErERS.";
$lang['createforumstyle'] = "cr34t3 @ f0RUm S+yL3";
$lang['newstylesuccessfullycreated'] = "n3w STYLe \$uCc3\$sPHUlLY Cr34+3d.";
$lang['stylealreadyexists'] = "a sTYLe W1TH +H4T phiL3n4m3 4Lr3@dy 3x1S+S.";
$lang['stylenofilename'] = "j00 DiD N0+ 3NTeR @ ph1L3N4me tO 54V3 +h3 S+yL3 WI+H.";
$lang['stylenodatasubmitted'] = "cOULD nO+ RE@D f0RuM \$+YlE D@t4.";
$lang['styleexp'] = "uS3 +h1S Pa9e tO hELP cRE@T3 A R@NDOmlY g3NEr4+Ed S+YlE PHOr YOUr FOrUM.";
$lang['stylecontrols'] = "c0ntROL\$";
$lang['stylecolourexp'] = "cliCK ON @ c0LOUR t0 M4kE 4 NeW STyLe SheE+ B4S3D 0N +H4T c0LOuR. cURr3N+ Ba\$3 cOLoUr I\$ Ph1r\$T 1N l1\$T.";
$lang['standardstyle'] = "stANDArd STYlE";
$lang['rotelementstyle'] = "rOT4t3D 3L3Ment STyLE";
$lang['randstyle'] = "r@nDOM \$+ylE";
$lang['thiscolour'] = "th1s C0LouR";
$lang['enterhexcolour'] = "or 3NTEr 4 Hex C0L0uR TO 8@SE @ New \$tYlE 5H3E+ 0n";
$lang['savestyle'] = "s@VE tHI\$ \$+YLe";
$lang['styledesc'] = "s+yLE DE5CRIp+I0N";
$lang['stylefilenamemayonlycontain'] = "sTYle PH1Len@m3 m@Y 0NlY cONt41N loWeRCa\$3 L3+t3rS (4-z), NUM83RS (0-9) 4ND uND3RSc0r3.";
$lang['stylepreview'] = "s+yl3 PR3VieW";
$lang['welcome'] = "welC0mE";
$lang['messagepreview'] = "m3sS49E PreV1Ew";
$lang['users'] = "u53r\$";
$lang['usergroups'] = "u53R 9ROups";
$lang['mustentergroupname'] = "j00 mUS+ eNTEr 4 9R0UP n4M3";
$lang['profiles'] = "pR0phIL3S";
$lang['manageforums'] = "m4n@93 F0RUm5";
$lang['forumsettings'] = "foRUm S3+T1N9S";
$lang['globalforumsettings'] = "gLoB@l pHoRUM SEt+IN9S";
$lang['settingsaffectallforumswarning'] = "<b>notE:</b> THes3 S3+T1N9s @FPH3C+ 4Ll F0RUM\$. WherE +H3 S3+TIn9 I\$ DUPl1c4T3D 0n THe InDIV1DU4L f0rUM'\$ S3+T1ngs Pa9e th4t WiLl T@KE PREceD3nCE 0V3R tHE s3tTINg\$ J00 Ch4N93 HeR3.";
$lang['startpage'] = "sT4r+ p@9E";
$lang['startpageerror'] = "y0UR ST4R+ p493 C0ULD N0+ b3 S4V3D l0c@llY To +h3 S3RV3r BeCAU\$3 PErmISS1ON w4s D3N1Ed.</p><p>t0 cH@N93 Y0UR \$t@R+ P4g3 Pl34s3 Cl1cK The DOwNLO4D BU++0n 83L0W wH1CH w1lL ProMPT j00 TO s@v3 T3H f1L3 +0 yOUR h4RD dRIVe. J00 C4N +HEN uPLO@d Thi\$ f1lE t0 YOUR s3rVEr 1N+0 +h3 PH0LloWIn9 FOLdeR, 1f N3CESS4RY cR3A+1nG +eH F0LD3R stRuC+UR3 1N t3H pR0c3ss.</p><p><b>%s</b></p><p>pleAS3 NO+e TH@T soME BRoW\$Ers M@Y Ch4N9e +3H N4M3 0f tEH f1l3 UPON d0wnL0@D. WhEN Upl0@DinG T3H PHil3 PL34s3 M4kE \$uR3 TH4+ 1T 1S N4M3D ST4rt_MAin.pHP O+H3rw1\$3 YoUr 5+@rT P4ge WIlL 4pPEAR unCh4nGED.";
$lang['failedtoopenmasterstylesheet'] = "y0UR PhORum S+YLE coUlD nOT 83 \$aV3D 83CAUs3 +h3 M@s+ER STYLe \$H3et coULd N0T 8E lO4D3D. tO S@ve Y0Ur 5+yle TH3 m4STEr 5+Yl3 SH3E+ (m4k3_\$+YlE.Css) mUS+ b3 LOc4+3D 1N +eh s+YLes d1rEC+0rY 0f yoUR b3EH1Ve F0RUm In\$T@lL4+1ON.";
$lang['makestyleerror'] = "y0Ur PHORUM S+Yl3 c0ULD nO+ BE \$4V3D l0c@LLy +O +EH sERveR B3C@Us3 p3RM1SS1oN wA\$ D3NieD.</p><p>t0 s@VE yoUR Ph0RUM sTYle plEasE clICk T3H D0wnLo4d 8U++ON 83l0w WHIch W1LL prOMpt J00 To \$4v3 +3H fiLE tO Y0Ur H@rd DriVe. J00 C4n +h3N uPLOaD +h1s PHiL3 T0 Y0UR S3RveR 1N+0 +h3 F0LL0WINg F0LD3r, IPh N3CESSAry CreA+1Ng +H3 PH0LDer S+ruC+Ur3 1N T3H pR0cESS.</p><p><b>%s</b></p><p>plE4S3 NO+3 TH4T \$0ME bROW\$3rs M@y CH4N9E teH N4M3 0Ph THE Fil3 UPON doWNLo4d. WheN UPlo4d1nG +HE f1Le PL34s3 M4KE \$UR3 TH4+ 1T 1\$ NAMED styL3.CSS o+H3rW15e TH3 PHOrUM \$+YLE W1lL B3 UnAVA1l@8l3.";
$lang['forumstyle'] = "f0rUM StYLe";
$lang['wordfilter'] = "wOrD Ph1l+3R";
$lang['forumlinks'] = "f0ruM liNKS";
$lang['viewlog'] = "v13W L09";
$lang['noprofilesectionspecified'] = "no PROph1lE \$3C+1oN \$PECIF1ED.";
$lang['itemname'] = "it3M n@M3";
$lang['moveto'] = "moV3 t0";
$lang['manageprofilesections'] = "m@N4GE pr0fIlE S3C+1ONS";
$lang['sectionname'] = "sECTI0N n4Me";
$lang['items'] = "iT3mS";
$lang['mustspecifyaprofilesectionid'] = "mU\$+ SpeCIPhY 4 pROF1LE s3CTi0n 1D";
$lang['mustsepecifyaprofilesectionname'] = "mU5T SPEcIPHy 4 PRopHILe S3CT10N N4Me";
$lang['noprofilesectionsfound'] = "no EXI5+inG Pr0pHIl3 seCTi0n5 F0UND. tO @dd 4 ProF1LE S3cti0N CliCK tHe '@dd new' buTtoN 8El0w.";
$lang['addnewprofilesection'] = "add N3W Pr0FiL3 \$3CTIOn";
$lang['successfullyaddedprofilesection'] = "sUcCE\$spHUlLY 4DD3D Pr0fIL3 S3CTI0N";
$lang['successfullyeditedprofilesection'] = "sucC3\$sphUllY EDi+3D Pr0f1L3 s3ctI0N";
$lang['addnewprofilesection'] = "aDd N3W pROPH1LE sECt10n";
$lang['mustsepecifyaprofilesectionname'] = "mUST SpecIpHy a PROfiL3 S3CTI0N nAm3";
$lang['successfullyremovedselectedprofilesections'] = "sUcCEs\$pHULlY R3MOVed s3lEC+3d PR0fIl3 \$3c+10NS";
$lang['failedtoremoveprofilesections'] = "f@iLEd +O rEMOve pR0PH1L3 s3CT1oN\$";
$lang['viewitems'] = "v13W i+Ems";
$lang['successfullyaddednewprofileitem'] = "succE5SPHUlLY @dDED N3w pROF1L3 I+3m";
$lang['successfullyeditedprofileitem'] = "sUcc3\$5FULlY 3D1TEd ProF1lE 1+EM";
$lang['successfullyremovedselectedprofileitems'] = "succESSFULLY REM0V3D S3LEC+ED PR0f1L3 I+3MS";
$lang['failedtoremoveprofileitems'] = "f@iLEd T0 Rem0V3 Prof1L3 I+EmS";
$lang['noexistingprofileitemsfound'] = "tH3rE 4R3 No 3xIStiNG PR0PhIL3 1T3MS 1n ThI\$ SecTI0N. +O @DD 4n 1TEm CliCk THe '4DD NEw' 8U+toN 8eL0W.";
$lang['edititem'] = "edi+ i+3M";
$lang['invalidprofilesectionid'] = "inv@L1D prOF1L3 s3C+10N 1D 0r sEc+I0N n0t foUNd";
$lang['invalidprofileitemid'] = "inv4LID pR0F1l3 1+Em 1D OR i+3M n0T PH0uNd";
$lang['addnewitem'] = "add NEW iTEM";
$lang['youmustenteraprofileitemname'] = "j00 Mu5+ EN+3R @ pR0F1LE 1+3M n4ME";
$lang['invalidprofileitemtype'] = "iNv4L1D Pr0pHiLE i+3M +Ype \$eLEct3D";
$lang['youmustenteroptionsforselectedprofileitemtype'] = "j00 MU\$+ 3Nt3r \$0mE 0P+i0N5 F0R \$3lEctED PR0FilE 1T3M +YPE";
$lang['youmustentermorethanoneoptionforitem'] = "j00 MU5+ eNT3R MorE +hAN 0nE 0PTiON fOR seLeCTeD Pr0f1LE 1t3m +yp3";
$lang['profileitemhyperlinkssupportshttpurlsonly'] = "pr0FIle It3M hYPerL1NK\$ SUpP0RT htTP URLS ONly";
$lang['profileitemhyperlinkformatinvalid'] = "pRof1LE 1+em hYP3RL1nk f0rM4T 1NV4L1D";
$lang['youmustincludeprofileentryinhyperlinks'] = "j00 MUS+ InCLUde <i>%s</i> 1n THE urL 0ph CLIck48L3 Hyp3Rl1nKS";
$lang['failedtocreatenewprofileitem'] = "f@1L3D +0 crEA+e N3W PROf1l3 I+3M";
$lang['failedtoupdateprofileitem'] = "f@1l3D +0 UPDat3 PR0f1l3 1+3M";
$lang['startpageupdated'] = "sT4RT Pa9e UPD@+3D. %s";
$lang['viewupdatedstartpage'] = "v13W updA+3d S+aR+ P49E";
$lang['editstartpage'] = "edi+ ST@r+ p4g3";
$lang['nouserspecified'] = "nO u\$3R \$peCIF1Ed.";
$lang['manageuser'] = "m4n@G3 USER";
$lang['manageusers'] = "m4n493 U\$Er\$";
$lang['userstatusforforum'] = "u5er 5+4+U\$ F0r %s";
$lang['userdetails'] = "u\$eR De+4iLS";
$lang['edituserdetails'] = "eD1T Us3R dET41LS";
$lang['warning_caps'] = "w@RNInG";
$lang['userdeleteallpostswarning'] = "ar3 J00 \$ure J00 w@Nt TO deLE+3 4lL 0F +hE S3L3c+3D US3r'\$ P0\$TS? 0nce +3H po5T5 4R3 DelE+3D +h3y c4nN0+ be REtR1EVeD 4ND WIlL bE L0\$T PhOR3VER.";
$lang['postssuccessfullydeleted'] = "p0S+S WERE SUcC3SsFulLy D3L3+3D.";
$lang['folderaccess'] = "folDER @CC3\$S";
$lang['possiblealiases'] = "p0s\$1BLE Al1@S35";
$lang['userhistory'] = "useR Hi\$+ORY";
$lang['nohistory'] = "no h1S+ORy REc0rDS \$@v3d";
$lang['userhistorychanges'] = "ch4n93s";
$lang['clearuserhistory'] = "cl3AR u\$3R hI\$+0rY";
$lang['changedlogonfromto'] = "ch4N9eD L090n Phr0M %s +0 %s";
$lang['changednicknamefromto'] = "cH4NGED nICkn4M3 Phr0M %s To %s";
$lang['changedemailfromto'] = "cH4ng3D EM41L PHroM %s +0 %s";
$lang['successfullycleareduserhistory'] = "sUCC3\$SPHULlY CL34R3D US3R hIsTORY";
$lang['failedtoclearuserhistory'] = "f@ilED +o cle4r US3R hI5TOrY";
$lang['successfullychangedpassword'] = "sucCe\$sPHuLLy Ch@N93D P@SSW0RD";
$lang['failedtochangepasswd'] = "f41l3D To ch4N9e pasSWORd";
$lang['viewuserhistory'] = "v13W u53R h1s+0Ry";
$lang['viewuseraliases'] = "vi3w USer @L14sES";
$lang['searchreturnednoresults'] = "s34rCh r3+urN3D no rESulTS";
$lang['deleteposts'] = "d3l3+3 P0ST5";
$lang['deleteuser'] = "dEl3TE US3R";
$lang['alsodeleteusercontent'] = "aL\$O D3le+E 4Ll OF TEh Con+3N+ Cr3@TEd 8Y thI5 US3R";
$lang['userdeletewarning'] = "arE J00 \$uRE j00 W4N+ To dEl3T3 +h3 S3leCTeD usEr 4CCOunt? onc3 TEh 4CCoUNt H4\$ 8e3N dEL3TED i+ C4nn0T 83 r3tR13VEd 4ND W1LL 83 LOSt PhoR3V3R.";
$lang['usersuccessfullydeleted'] = "u\$er SuCCESSFulLy D3L3+3d";
$lang['failedtodeleteuser'] = "f41led TO DEleTe US3R";
$lang['forgottenpassworddesc'] = "if THIS US3R h4s f0R90+T3N +He1R P@sSW0Rd j00 C4n REse+ I+ foR thEM heRe.";
$lang['failedtoupdateuserstatus'] = "f@1leD T0 Upd@+3 usEr St@+US";
$lang['failedtoupdateglobaluserpermissions'] = "f@IL3D +O Upd4tE GL0b4L USer P3RM1S\$1ONS";
$lang['failedtoupdatefolderaccesssettings'] = "fa1L3D to Upd4T3 F0LDER 4cCES\$ SETTiNGS";
$lang['manageusersexp'] = "th1S LiST Sh0W\$ 4 SELEctI0N 0F U5ERs WHO h4VE LogGed On T0 Y0UR PH0RUm, SoR+3D By %s. +0 @L+3R 4 usER'S peRM1ssiON\$ CliCK THeIR nAMe.";
$lang['userfilter'] = "u\$3R F1lt3r";
$lang['onlineusers'] = "onl1N3 US3R\$";
$lang['offlineusers'] = "oPhPhL1NE u\$eRS";
$lang['usersawaitingapproval'] = "uS3R\$ 4W41tIng 4pPROV4L";
$lang['bannedusers'] = "b@nNEd U\$3R\$";
$lang['lastlogon'] = "l4\$+ LOg0N";
$lang['sessionreferer'] = "s3\$S10n R3PHeR3R";
$lang['signupreferer'] = "s19n-UP rePHerER:";
$lang['nouseraccountsmatchingfilter'] = "no u\$3R 4CCOuN+S M4TCh1NG fiLTer";
$lang['searchforusernotinlist'] = "s3@rCH PhoR A UseR N0T 1N L1\$T";
$lang['adminaccesslog'] = "admIN 4CC3SS l09";
$lang['adminlogexp'] = "tH1S L1ST sh0W\$ +H3 La\$+ @c+10Ns s4Nc+10N3D bY u\$3R\$ WI+h @dM1n PR1VIL3Ges.";
$lang['datetime'] = "datE/tiME";
$lang['unknownuser'] = "unknOWN uS3R";
$lang['unknownuseraccount'] = "uNKNOwN U\$3r ACc0uN+";
$lang['unknownfolder'] = "unKNOWn PHolDer";
$lang['ip'] = "ip";
$lang['lastipaddress'] = "l@sT 1P aDDrESS";
$lang['hostname'] = "h0stN4m3";
$lang['unknownhostname'] = "uNknown HO\$+n4M3";
$lang['logged'] = "lO99eD";
$lang['notlogged'] = "noT l0GG3D";
$lang['addwordfilter'] = "aDD worD fIlT3R";
$lang['addnewwordfilter'] = "add NeW w0Rd F1L+3R";
$lang['wordfilterupdated'] = "wOrD F1LTER uPd@Ted";
$lang['wordfilterisfull'] = "j00 C@nno+ 4dD @NY moR3 W0rd FiL+3R5. REMoVE soME UnuSEd 0NES oR 3dIt +hE EX1\$t1N9 On3s FIrsT.";
$lang['filtername'] = "fiL+3R N@ME";
$lang['filtertype'] = "f1lt3r TYP3";
$lang['filterenabled'] = "f1l+3R EN48LEd";
$lang['editwordfilter'] = "edi+ W0RD PHiLTeR";
$lang['nowordfilterentriesfound'] = "no EXI\$+1Ng WORd F1LTeR 3NTr1ES F0UNd. +o @Dd @ f1L+3R CL1CK +3H 'aDD N3W' 8uT+on 83LOW.";
$lang['mustspecifyfiltername'] = "j00 MusT sP3C1PHy 4 F1L+3R N4M3";
$lang['mustspecifymatchedtext'] = "j00 mUS+ \$peCipHY M4Tch3D +3XT";
$lang['mustspecifyfilteroption'] = "j00 MUs+ \$peC1pHY @ FIL+3r 0p+10n";
$lang['mustspecifyfilterid'] = "j00 mU\$t \$p3C1PHY 4 pH1L+3r 1d";
$lang['invalidfilterid'] = "inv4lId FIltER 1D";
$lang['failedtoupdatewordfilter'] = "f@iLEd +O UpD4TE woRd PhiLtER. Ch3CK th4+ +3H pHIlTER s+1LL 3xI\$+s.";
$lang['allow'] = "alloW";
$lang['block'] = "blocK";
$lang['normalthreadsonly'] = "n0rm@L tHrE4D\$ 0NLy";
$lang['pollthreadsonly'] = "p0LL +hR34DS 0NLY";
$lang['both'] = "botH Thr3AD tYPeS";
$lang['existingpermissions'] = "ex1s+1N9 perM1S\$10N\$";
$lang['nousershavebeengrantedpermission'] = "nO EXISTiN9 us3rs p3rMI\$s1on5 PHouND. +o 9R4N+ pERmIs51On t0 uS3rs \$3ArcH pHOR +H3M B3l0W.";
$lang['successfullyaddedpermissionsforselectedusers'] = "sUcC3s5FULlY AdD3D pERmi\$S10N\$ PH0R 5elEC+3d US3RS";
$lang['successfullyremovedpermissionsfromselectedusers'] = "sucCESSPhULly ReMOV3D PErMI\$s10N\$ PhR0M Sel3CTed US3R\$";
$lang['failedtoaddpermissionsforuser'] = "f41lED +O @dD p3rM1\$51ON\$ FOr USeR '%s'";
$lang['failedtoremovepermissionsfromuser'] = "f41LeD +0 R3M0VE P3RMi\$S10N\$ PhrOm uSER '%s'";
$lang['searchforuser'] = "se4RCh F0R usEr";
$lang['browsernegotiation'] = "bROW\$3R n3g0TI4TED";
$lang['largetextfield'] = "l4RG3 teXT PHI3LD";
$lang['mediumtextfield'] = "m3diUM +3X+ FieLd";
$lang['smalltextfield'] = "sm@lL +Ext PhIELd";
$lang['multilinetextfield'] = "mul+1-l1N3 +3xT PhiELd";
$lang['radiobuttons'] = "r@di0 BUtTOn\$";
$lang['dropdownlist'] = "dr0P D0WN LIST";
$lang['clickablehyperlink'] = "cLICK48lE HYp3rLINK";
$lang['threadcount'] = "tHrE4D C0UNt";
$lang['clicktoeditfolder'] = "cl1CK +O 3D1T PhoLdeR";
$lang['fieldtypeexample1'] = "tO CR3AtE R@DI0 8U+TOns 0R a DroP Down l1\$+ J00 NeeD t0 3Nt3r 3ACh 1Nd1v1dU4L V4LU3 ON 4 \$3P4R4TE LiN3 In THe 0P+i0N\$ F1ElD.";
$lang['fieldtypeexample2'] = "t0 cRE4T3 CliCK@8l3 L1Nks EN+ER teh URL 1N ThE 0P+10NS F13LD @nD U\$3 <i>%1\$\$</i> Wh3re TEH 3nTrY Fr0m +h3 uSER's PROphIl3 SHOUld @pp34R. eX@mPLES: <p>mY\$p4CE: <i>hTTp://wwW.my\$p4cE.cOM/%1\$s</i><br />x80X l1v3: <i>hT+P://PROPHIl3.MYG@M3rCarD.N3+/%1\$\$</i>";
$lang['editedwordfilter'] = "edI+3D w0rD PH1l+3R";
$lang['editedforumsettings'] = "eD1+3D ForUM S3++1n95";
$lang['successfullyendedusersessionsforselectedusers'] = "sUcc3s\$pHULLy 3ND3D Se\$510Ns PH0R \$3L3C+3d U5eRS";
$lang['failedtoendsessionforuser'] = "f41LEd To eNd \$3\$SI0N F0R u\$3r %s";
$lang['successfullyapprovedselectedusers'] = "sucCE\$SPHuLLy @PpROVEd \$3LEc+ED US3R\$";
$lang['matchedtext'] = "m@+CH3D +3x+";
$lang['replacementtext'] = "r3pL4C3M3N+ +3xT";
$lang['preg'] = "pR3G";
$lang['wholeword'] = "wHoL3 WOrD";
$lang['word_filter_help_1'] = "<b>alL</b> M4TCHes 49A1N\$T TeH Wh0l3 +3Xt sO pH1L+ErINg MOm T0 Mum wiLL 4L\$0 Ch@NgE moMENt +0 mUMEn+.";
$lang['word_filter_help_2'] = "<b>wh0LE w0rD</b> m4TCHes 49AInst wH0L3 W0RD\$ Only S0 fiLT3RInG mOM +O Mum W1Ll N0+ CH4n9E M0Men+ +O MuM3N+.";
$lang['word_filter_help_3'] = "<b>pr39</b> aLL0WS J00 +o U\$3 pERL r3GUl@R EXPRe\$S1ONS +O M4+CH +3xT.";
$lang['nameanddesc'] = "n@ME 4nD DesCrIPtiON";
$lang['movethreads'] = "m0V3 +Hr3@DS";
$lang['movethreadstofolder'] = "mOVE THR3@ds +0 pH0LD3r";
$lang['failedtomovethreads'] = "f41LeD tO M0VE +HR34DS +O \$peCIF1ED F0LD3R";
$lang['resetuserpermissions'] = "r3\$3+ UsER pERmi\$SI0Ns";
$lang['failedtoresetuserpermissions'] = "f41leD +0 R3SET U\$3R PerMISS1On\$";
$lang['allowfoldertocontain'] = "allOW foLDer +o COn+@1N";
$lang['addnewfolder'] = "add N3W ph0LDEr";
$lang['mustenterfoldername'] = "j00 muST 3nTEr 4 PHolDer n@ME";
$lang['nofolderidspecified'] = "n0 PhoLDEr 1D \$PEciPH1ED";
$lang['invalidfolderid'] = "iNV@l1d pHOLD3R 1d. cHEck Th@+ 4 FOlDER w1+H THi\$ 1D ex1\$ts!";
$lang['successfullyaddednewfolder'] = "sUCCE\$SPHUllY @DD3D n3W PHolDEr";
$lang['successfullyremovedselectedfolders'] = "sucCEssFUllY R3MOvED s3LEc+3D PhOLDerS";
$lang['successfullyeditedfolder'] = "succ3S5FULly 3D1TEd fOLd3r";
$lang['failedtocreatenewfolder'] = "f41LEd +O CR3@tE NEw FOlDER";
$lang['failedtodeletefolder'] = "f41leD +0 DELET3 PHOLDer.";
$lang['failedtoupdatefolder'] = "fA1l3D +O uPd4tE F0ld3R";
$lang['cannotdeletefolderwiththreads'] = "c4nN0T dELeTE FOLD3R\$ +h4+ STiLL coN+4In ThR3@D\$.";
$lang['forumisnotrestricted'] = "f0rUM 1s NO+ R3\$tRIcTEd";
$lang['groups'] = "gRoUPs";
$lang['nousergroups'] = "nO U\$3R 9rOUps HaV3 8EEN SEt UP. +O @DD 4 GrOUP CL1cK +EH '4DD n3W' 8u++oN 8ELOw.";
$lang['suppliedgidisnotausergroup'] = "suppL1ED g1D IS n0t @ USer 9r0UP";
$lang['manageusergroups'] = "m4na9E US3R 9ROups";
$lang['groupstatus'] = "grOUP ST4+US";
$lang['addusergroup'] = "aDD U\$3R 9R0uP";
$lang['addemptygroup'] = "aDd 3mPTY 9roUP";
$lang['adduserstogroup'] = "adD U\$3Rs to GRoUP";
$lang['addremoveusers'] = "add/R3m0VE us3r\$";
$lang['nousersingroup'] = "theRE aR3 no u\$3RS 1n Th1s 9ROup. 4dD usER5 +o +Hi\$ 9R0Up by SEArCHinG f0R +h3m bELOw.";
$lang['groupaddedaddnewuser'] = "sucCE\$sPHuLLy ADd3d 9ROUp. 4dD u\$3r\$ +0 thi\$ GR0Up 8Y \$3aRchING FOr +H3M 8EL0W.";
$lang['nousersingroupaddusers'] = "therE ARe N0 u\$Er\$ iN +His GRouP. to @dD US3R\$ cL1Ck +3H '@dd/R3MoVE US3R\$' 8U+ToN 83LOw.";
$lang['useringroups'] = "tH15 u\$3R is 4 Mem8eR 0F tH3 pHOLloWInG 9R0uPS";
$lang['usernotinanygroups'] = "tHIS uS3R is N0T 1N 4ny usEr 9R0UPS";
$lang['usergroupwarning'] = "nO+3: tHI\$ U\$3R m4y 8E inH3R1+1Ng 4DDiTI0N4L p3RM15SI0Ns FROm ANy U\$3R 9RouPS l1sT3D bEL0W.";
$lang['successfullyaddedgroup'] = "sucC3\$SPHULlY 4DD3D 9r0uP";
$lang['successfullyeditedgroup'] = "sUcC3\$sfULly 3DI+3d gROUp";
$lang['successfullydeletedselectedgroups'] = "sucCeSSPhullY D3LeT3D Sel3CTEd 9ROuP5";
$lang['failedtodeletegroupname'] = "f4IL3d +0 dELe+3 GrOUP %s";
$lang['usercanaccessforumtools'] = "useR C4N @ccESS F0RUm +00LS 4nD C4N CRe4t3, dEL3T3 4nd 3D1T pH0rUMS";
$lang['usercanmodallfoldersonallforums'] = "uS3r C4N m0d3r4+3 <b>aLL F0LderS</b> on <b>aLL F0RUms</b>";
$lang['usercanmodlinkssectiononallforums'] = "u\$ER c@N m0DER4te L1Nks S3CTi0n On <b>alL ph0rUMs</b>";
$lang['emailconfirmationrequired'] = "em4iL c0NF1RM4Ti0N R3Qu1rED";
$lang['userisbannedfromallforums'] = "u\$ER IS b@NN3D PhR0M <b>all FOruMS</b>";
$lang['cancelemailconfirmation'] = "c@Nc3l EM@il C0NF1RM4+1oN 4ND @LLow US3R to s+@rT Po\$+1NG";
$lang['resendconfirmationemail'] = "rESEND cONpHirM4TIOn 3M@1L tO US3R";
$lang['failedtosresendemailconfirmation'] = "f41LED +O Res3ND EmaIL C0NFiRM4TIoN t0 usER.";
$lang['donothing'] = "d0 N0+HIN9";
$lang['usercanaccessadmintools'] = "uSeR H4\$ 4CceSS +0 FORuM aDmIN TO0Ls";
$lang['usercanaccessadmintoolsonallforums'] = "u\$ER h@\$ ACC3s\$ +0 4DmiN +O0LS <b>on aLL fORuMS</b>";
$lang['usercanmoderateallfolders'] = "u53R c4n M0DEr4t3 4lL fOLDEr\$";
$lang['usercanmoderatelinkssection'] = "us3R c4n M0dER4+3 linK\$ s3C+i0n";
$lang['userisbanned'] = "u\$er Is BANN3d";
$lang['useriswormed'] = "uSeR 1S w0rM3D";
$lang['userispilloried'] = "u\$3r I5 P1lL0R1ED";
$lang['usercanignoreadmin'] = "uS3R c4n 1GN0RE 4dMinIS+rA+oRS";
$lang['groupcanaccessadmintools'] = "gR0uP caN 4CcE5S 4DMin t0olS";
$lang['groupcanmoderateallfolders'] = "gR0Up C@n MoD3R4+3 4ll F0LdER\$";
$lang['groupcanmoderatelinkssection'] = "grouP C4N m0d3R4T3 L1NKS S3CtI0NS";
$lang['groupisbanned'] = "gROUP 1s B4NN3d";
$lang['groupiswormed'] = "gR0up 1\$ WOrm3d";
$lang['readposts'] = "rE@D P0\$t5";
$lang['replytothreads'] = "replY +o +HRE4d\$";
$lang['createnewthreads'] = "cr34tE nEW +hrEAD5";
$lang['editposts'] = "ed1t P0STS";
$lang['deleteposts'] = "dEL3T3 POSts";
$lang['postssuccessfullydeleted'] = "poSTS sUcc3\$sFULlY d3L3+3d";
$lang['failedtodeleteusersposts'] = "f41L3d T0 DeL3T3 Us3r'S PO\$+S";
$lang['uploadattachments'] = "uplO@D 4++4CHm3N+\$";
$lang['moderatefolder'] = "mOD3R4+3 Ph0LDeR";
$lang['postinhtml'] = "pOst 1N H+Ml";
$lang['postasignature'] = "p0\$T 4 \$1Gn@TuR3";
$lang['editforumlinks'] = "eDi+ pHORuM LiNKS";
$lang['linksaddedhereappearindropdown'] = "l1NKS @dD3D heRe 4PPeAR 1n 4 DR0p d0wN 1N +h3 +OP R1GH+ 0PH +H3 Fr4m3 S3+.";
$lang['linksaddedhereappearindropdownaddnew'] = "l1NKS aDDED H3Re 4PPE4R 1N 4 Dr0p doWn IN +H3 +0P rI9H+ oPH +H3 phr@ME \$3+. To 4DD 4 L1Nk cL1CK TEh 'aDD n3w' 8U+toN b3LOW.";
$lang['failedtoremoveforumlink'] = "f41lEd T0 REm0VE f0RUM L1NK '%s'";
$lang['failedtoaddnewforumlink'] = "f4iL3D +0 4DD NEw PHORum L1Nk '%s'";
$lang['failedtoupdateforumlink'] = "f41L3D +o UPd4TE F0RUM L1NK '%s'";
$lang['notoplevellinktitlespecified'] = "no T0P L3v3l LiNK +i+Le \$peC1PH1ed";
$lang['youmustenteralinktitle'] = "j00 mUSt 3N+3R @ l1nk TiTl3";
$lang['alllinkurismuststartwithaschema'] = "all L1Nk URis Mu\$T \$taRt W1+H 4 SChEM@ (1.3. hTTp://, Ph+P://, IRC://)";
$lang['editlink'] = "edIt L1Nk";
$lang['addnewforumlink'] = "aDd N3W Ph0rUM l1nK";
$lang['forumlinktitle'] = "forUm lINK +1tL3";
$lang['forumlinklocation'] = "f0ruM LInk L0CA+10N";
$lang['successfullyaddednewforumlink'] = "sucC3sspHULly ADD3D new F0Rum L1NK";
$lang['successfullyeditedforumlink'] = "sucCESspHuLLY EDI+ED pH0RUm L1NK";
$lang['invalidlinkidorlinknotfound'] = "iNvALID L1NK ID 0r LiNk N0T pHOUNd";
$lang['successfullyremovedselectedforumlinks'] = "sUCCEs\$phULLy ReM0V3D SeLEct3D LiNK5";
$lang['toplinkcaption'] = "t0p L1Nk C4P+1oN";
$lang['allowguestaccess'] = "alloW 9U3S+ 4Cc3ss";
$lang['searchenginespidering'] = "sE4RCH 3nGIN3 sPID3RING";
$lang['allowsearchenginespidering'] = "aLLOw S3ARch en91NE sPIdeRiNG";
$lang['sitemapenabled'] = "eN4BL3 \$I+3m@P";
$lang['sitemapupdatefrequency'] = "si+3M4P UPd4+3 FR3QuENcy";
$lang['sitemappathnotwritable'] = "si+3M4P DIr3c+ORy MUS+ B3 wRI+AbL3 8Y +HE WEb \$3RVeR / PHp Pr0C3sS!";
$lang['newuserregistrations'] = "n3w U5Er Re915+R4Ti0ns";
$lang['preventduplicateemailaddresses'] = "pRev3NT DUpLIc4T3 3M@il aDDr3ssES";
$lang['allownewuserregistrations'] = "aLL0W n3W Us3r RE9I\$+r4T10N\$";
$lang['requireemailconfirmation'] = "r3QUIRE EMA1l CONPh1RM4+10N";
$lang['usetextcaptcha'] = "us3 TEx+-caPTCH4";
$lang['textcaptchafonterror'] = "tex+-C4PtCH@ H4S bEEn dIs4BL3D @U+0M4+Ic@LLY B3C4u53 +H3r3 4Re nO TruE TyPE F0NTS 4V41L4Bl3 F0R 1T to u53. PLe4se UPl0@D S0Me +ru3 +YP3 f0Nt\$ T0 <b>tEX+_C4P+ch4/F0N+\$</b> 0n YOuR \$3RVeR.";
$lang['textcaptchadirerror'] = "t3xt-c@PTCH4 H@S b33n d1S4Bl3d BEc4us3 +H3 +3xT_c4P+ch@ DIr3c+Ory 4ND 1+'S SuB-d1rEC+0rIE\$ aRe N0T wrI+48Le bY t3H w3B \$3RVEr / phP PROCE5s.";
$lang['textcaptchagderror'] = "tex+-CaP+ch4 h4\$ 8E3N d1s4BLeD b3C4USE YOUr SErVEr'S phP sEtUP D03S noT pR0V1D3 5upPOrT PhOR 9d Im@93 M@N1PuL4+i0N 4Nd / OR ++Ph FONt SUpPOR+. 80+h 4R3 r3qUiR3D pH0R +eX+-C@pTCha \$UPpoRT.";
$lang['newuserpreferences'] = "new U\$3R PR3PHEr3NCe\$";
$lang['sendemailnotificationonreply'] = "eM@iL noT1PH1C4T10N On REplY To US3R";
$lang['sendemailnotificationonpm'] = "eM4il NOTIFic4Ti0n On Pm +0 Us3r";
$lang['showpopuponnewpm'] = "shOw P0PUp WHeN rECEiVIN9 n3w PM";
$lang['setautomatichighinterestonpost'] = "s3t @UtoM4TIc H1GH iN+3R3\$+ On P0\$+";
$lang['postingstats'] = "pO\$+1n9 ST@+s";
$lang['postingstatsforperiod'] = "pOs+1n9 5+@ts FOR peRI0D %s TO %s";
$lang['nopostdatarecordedforthisperiod'] = "nO P0ST D4t@ REC0RDED pH0R TH1s p3R1OD.";
$lang['totalposts'] = "to+@L po\$ts";
$lang['totalpostsforthisperiod'] = "tOt@L P0sT\$ PHOR thIS P3ri0D";
$lang['mustchooseastartday'] = "mus+ Ch0OS3 4 \$t4R+ D4Y";
$lang['mustchooseastartmonth'] = "mUsT choOSE A \$t@RT mONTh";
$lang['mustchooseastartyear'] = "mU5t cH0O\$3 4 s+@rT y34R";
$lang['mustchooseaendday'] = "mU\$+ CH005e a 3ND d@Y";
$lang['mustchooseaendmonth'] = "mus+ CH0O\$3 @ End MOntH";
$lang['mustchooseaendyear'] = "mUst CH0oS3 4 3ND Ye4r";
$lang['startperiodisaheadofendperiod'] = "sT@RT PERI0D 1\$ 4h3@D of END P3RI0D";
$lang['bancontrols'] = "b4N C0NTrOL\$";
$lang['addban'] = "aDD b4n";
$lang['checkban'] = "cHECk b4N";
$lang['editban'] = "eDI+ 84n";
$lang['bantype'] = "b4n +yPe";
$lang['bandata'] = "b@N D@+A";
$lang['bancomment'] = "cOmm3nt";
$lang['ipban'] = "iP B4N";
$lang['logonban'] = "lOgON b4N";
$lang['nicknameban'] = "niCkN@m3 Ban";
$lang['emailban'] = "eMAIL 8@n";
$lang['refererban'] = "r3fERER 8@n";
$lang['invalidbanid'] = "iNv4l1d BAN ID";
$lang['affectsessionwarnadd'] = "tHis b4N M@y 4PHpH3C+ +H3 phOLloWInG 4C+1Ve US3r SEssi0NS";
$lang['noaffectsessionwarn'] = "thi\$ 8aN 4fFEcTS N0 AC+1VE s3sS1ONS";
$lang['mustspecifybantype'] = "j00 MU5t sP3c1fy 4 BAN TYPE";
$lang['mustspecifybandata'] = "j00 MuST SP3c1pHY 50ME B@n D4T4";
$lang['successfullyremovedselectedbans'] = "sucCE5SPHuLLY r3m0v3D S3LeC+Ed BAns";
$lang['failedtoaddnewban'] = "f41Led T0 @DD N3W bAn";
$lang['failedtoremovebans'] = "f4il3d +0 R3MoV3 S0ME 0r 4LL oPh THe \$ELEcT3D 8An\$";
$lang['duplicatebandataentered'] = "duplIc4tE B4n dA+@ 3N+3ReD. PLe4s3 CH3ck YOUr W1LdCARd\$ +0 \$33 1pH tH3Y aLR34DY M4TCh +H3 d4T@ 3N+3ReD";
$lang['successfullyaddedban'] = "sUcC3\$SPhuLLy @dd3D bAN";
$lang['successfullyupdatedban'] = "sUcce\$spHUllY UPD@T3D 84N";
$lang['noexistingbandata'] = "th3rE 1\$ N0 3x1st1NG 84N DA+a. +O @DD @ 8@n CL1CK +he 'ADD nEW' 8UTTON BEL0w.";
$lang['youcanusethepercentwildcard'] = "j00 C@N u\$3 +H3 PERC3NT (%) wILDC@RD SYmB0l 1n ANY OF Y0uR Ban lI\$+S To 08T41n P@R+14L m4TChes, I.E. '192.168.0.%' W0ULD b4n aLL iP 4dDR3ss3S iN +he r4Nge 192.168.0.1 tHR0U9H 192.168.0.254";
$lang['cannotusewildcardonown'] = "j00 C4Nn0+ 4DD % 4s A WIlDC@RD m4TCH 0n It'S 0Wn!";
$lang['requirepostapproval'] = "rEqU1RE pO\$t 4PPr0v@L";
$lang['adminforumtoolsusercounterror'] = "th3R3 mu5+ b3 4T L3A\$T 1 U\$3R w1+H @DmiN +0oLs 4nd pHorUM +0oLS @CC3SS 0N 4lL PhORUms!";
$lang['postcount'] = "poST c0Un+";
$lang['resetpostcount'] = "r3\$e+ post c0uN+";
$lang['failedtoresetuserpostcount'] = "f41LED +o ResET P0S+ cOUN+";
$lang['failedtochangeuserpostcount'] = "f41LEd +O CH4nge US3r pOS+ CouN+";
$lang['postapprovalqueue'] = "p0ST @PPrOVAL QUEue";
$lang['nopostsawaitingapproval'] = "n0 P0\$ts @R3 4W41+1NG aPPr0V4L";
$lang['approveselected'] = "aPpr0VE \$3l3CTed";
$lang['failedtoapproveuser'] = "f41l3D T0 4ppR0VE uSEr %s";
$lang['kickselected'] = "kicK S3l3c+3D";
$lang['visitorlog'] = "v1S1t0r LO9";
$lang['novisitorslogged'] = "no VISI+oRS L09GED";
$lang['addselectedusers'] = "aDD 5ELEcT3D U5ER\$";
$lang['removeselectedusers'] = "rem0v3 \$3LEc+3D u\$ERS";
$lang['addnew'] = "add N3w";
$lang['deleteselected'] = "d3L3t3 \$elECt3d";
$lang['forumrulesmessage'] = "<p><b>fOrUm rUL3\$</b></p><p>\nrEG1\$+RA+10N +o %1\$\$ 1\$ PHreE! w3 D0 1NS1st Th@+ j00 @bIDE bY TH3 RulES 4Nd POl1cIES d3+4iL3D BELOW. IF j00 AGR33 +0 +3H t3rM\$, PL3@S3 CHeCK +Eh 'I @9rEE' chECKBOX AnD PR3SS tHE 'rE9ISTEr' bUTTon 83LOW. 1F j00 w0uLd LiKE T0 c4nCEL +H3 RE9IS+R4+10N, clIcK %2\$S +o R3TurN +O +H3 f0RUMS 1nd3x.</p><p>\n4L+H0U9h +H3 4DM1N1\$TR4tORs aND m0deR4+Ors 0f %1\$S W1lL @tT3MP+ +0 KEep @Ll O8J3cTi0n@8l3 ME\$s49eS 0PHF +h1\$ f0rUM, 1+ 1s 1MPOS51BL3 PHOR US +O rEV13W @LL M3Ss@9Es. 4lL M3\$5493\$ 3XPR3\$5 thE v13Ws 0ph +EH au+hor, 4Nd n3itHer +h3 0WNERS of %1\$s, n0R pRojEc+ 8eeHIVE PH0rUM AND I+'\$ @fpHILiA+3s WILL bE h3lD rEsP0nsI8l3 pHor +HE CONtEN+ of 4Ny meS\$@gE.</p><p>\nby AgRE31nG To ThesE RUle\$, J00 w@RR@n+ TH4T J00 WIll No+ posT @NY M3Ss@gEs +h4t @R3 0bscENE, VUl94R, \$3xu4lly-ORI3n+4teD, HA+EfUL, +Hr3@teN1n9, Or 0+hERW1se V1oLa+1v3 0f 4ny LAWS.</p><p>th3 ownErs 0f %1\$s rEs3Rv3 +H3 r19HT T0 Remov3, 3di+, M0v3 0r CLos3 any +HRE4D PH0r @NY R3asoN.</p>";
$lang['cancellinktext'] = "h3rE";
$lang['failedtoupdateforumsettings'] = "f4Il3d +O Upd4t3 F0RUM \$3T+1n9s. plE4s3 +Ry aG41N lA+3R.";
$lang['moreadminoptions'] = "morE 4DmIN OPtIONS";

// Admin Log data (admin_viewlog.php) --------------------------------------------

$lang['changedstatusforuser'] = "chANGEd USER S+@TUs PhoR '%s'";
$lang['changedpasswordforuser'] = "cH4NGEd P@SSWoRD pHOR '%s'";
$lang['changedforumaccess'] = "ch@nGEd PhoRuM 4CCESS p3RM1s\$10n\$ PhoR '%s'";
$lang['deletedallusersposts'] = "dEl3TEd 4LL pOSTS PHOR '%s'";

$lang['createdusergroup'] = "crEa+3d U\$3r 9r0uP '%s'";
$lang['deletedusergroup'] = "d3LET3D US3R 9roUP '%s'";
$lang['updatedusergroup'] = "upda+3D U\$3R GROUP '%s'";
$lang['addedusertogroup'] = "aDDED Us3r '%s' T0 9ROUP '%s'";
$lang['removeduserfromgroup'] = "r3m0VE us3r '%s' fr0M gR0UP '%s'";

$lang['addedipaddresstobanlist'] = "adD3D ip '%s' T0 B4N l1\$+";
$lang['removedipaddressfrombanlist'] = "r3MOvED IP '%s' FROM 8@n l1S+";

$lang['addedlogontobanlist'] = "aDD3d lo9ON '%s' TO 84N L1\$T";
$lang['removedlogonfrombanlist'] = "r3MOVED LO9oN '%s' PHrom B4N li\$+";

$lang['addednicknametobanlist'] = "aDd3d n1CKn4m3 '%s' +o 8@N lI\$t";
$lang['removednicknamefrombanlist'] = "r3mOV3D n1cKN4M3 '%s' PHroM 8@n L1\$T";

$lang['addedemailtobanlist'] = "add3d 3m@1L 4DDrESS '%s' t0 B@N liS+";
$lang['removedemailfrombanlist'] = "r3M0v3d eM@1L @Ddr3s5 '%s' PhroM B4N L1s+";

$lang['addedreferertobanlist'] = "adDED REFeREr '%s' +0 B@n L1\$t";
$lang['removedrefererfrombanlist'] = "rEM0vEd R3pHERER '%s' fR0M 8@n L1\$+";

$lang['editedfolder'] = "ed1+3d PHOLDEr '%s'";
$lang['movedallthreadsfromto'] = "moveD aLL thR3@D\$ FR0M '%s' +O '%s'";
$lang['creatednewfolder'] = "cr3a+3D NEw pHOLD3R '%s'";
$lang['deletedfolder'] = "d3l3tED F0ld3R '%s'";

$lang['changedprofilesectiontitle'] = "cH4nGED PR0ph1l3 S3c+1on +1Tl3 fr0M '%s' +0 '%s'";
$lang['addednewprofilesection'] = "addED New pr0F1L3 S3CTi0n '%s'";
$lang['deletedprofilesection'] = "deLE+3D Pr0f1L3 \$3CTI0n '%s'";

$lang['addednewprofileitem'] = "aDDEd nEW Pr0ph1LE ITeM '%s' to \$3CTion '%s'";
$lang['changedprofileitem'] = "ch@NGED Pr0fILE I+3m '%s'";
$lang['deletedprofileitem'] = "dEl3tED Prof1L3 I+3M '%s'";

$lang['editedstartpage'] = "ed1+3d ST4R+ p49E";
$lang['savednewstyle'] = "s@v3d n3W S+Yl3 '%s'";

$lang['movedthread'] = "mov3d +HRE@d '%s' PhrOM '%s' to '%s'";
$lang['closedthread'] = "cL0SED +HrE4D '%s'";
$lang['openedthread'] = "op3NED +HREAd '%s'";
$lang['renamedthread'] = "r3n@MED +HRe4D '%s' +O '%s'";

$lang['deletedthread'] = "delEt3d thR3AD '%s'";
$lang['undeletedthread'] = "undeLE+3D +hRE@d '%s'";

$lang['lockedthreadtitlefolder'] = "lOCK3D ThRE4D OPt1oNS on '%s'";
$lang['unlockedthreadtitlefolder'] = "uNL0CK3D +HR3AD 0PTi0n\$ 0n '%s'";

$lang['deletedpostsfrominthread'] = "d3LE+3d P0\$+s Phr0M '%s' In +HR34D '%s'";
$lang['deletedattachmentfrompost'] = "deL3+3D 4TT4ChM3n+ '%s' FROm po\$+ '%s'";

$lang['editedforumlinks'] = "edi+ED phORUM lInkS";
$lang['editedforumlink'] = "eDiT3D ForuM l1nK: '%s'";

$lang['addedforumlink'] = "aDd3D f0rUm l1NK: '%s'";
$lang['deletedforumlink'] = "del3TED F0RUM LInK: '%s'";
$lang['changedtoplinkcaption'] = "ch@NGeD +oP liNK C4P+1oN pHR0M '%s' +0 '%s'";

$lang['deletedpost'] = "d3L3t3d PO\$T '%s'";
$lang['editedpost'] = "edi+3D po\$+ '%s'";

$lang['madethreadsticky'] = "m4dE THreAd '%s' S+1CKY";
$lang['madethreadnonsticky'] = "m4d3 +hRE@D '%s' N0N-5+1CKy";

$lang['endedsessionforuser'] = "end3d S3SS10N f0R us3R '%s'";

$lang['approvedpost'] = "aPPROVED p0sT '%s'";

$lang['editedwordfilter'] = "edI+3D WOrd PhILteR";

$lang['addedrssfeed'] = "add3D R5s phEEd '%s'";
$lang['editedrssfeed'] = "edI+3D RSS F33D '%s'";
$lang['deletedrssfeed'] = "dele+3D RSs PHEED '%s'";

$lang['updatedban'] = "upd4T3D B4N '%s'. CHAng3d TypE fROm '%s' +0 '%s', cH4NGeD D4T4 Fr0M '%s' TO '%s'.";

$lang['splitthreadatpostintonewthread'] = "sPl1T thR3@D '%s' 4+ POSt %s  1NT0 NEw ThR34D '%s'";
$lang['mergedthreadintonewthread'] = "m3RgeD +HRE4dS '%s' and '%s' 1nT0 n3w +Hread '%s'";

$lang['approveduser'] = "aPPROv3d uSER '%s'";

$lang['forumautoupdatestats'] = "f0Rum 4UT0 upD4TE: \$t@t\$ UpD@+eD";
$lang['forumautocleanthreadunread'] = "forUm 4Ut0 uPD4+3: +HrE4d UNr3@d d@T4 ClE@neD";

$lang['ipaddressbanhit'] = "u5er '%s' 1\$ 8@NNEd. iP @dDrE5s '%s' M4tCH3d b@N D@ta '%s'";
$lang['logonbanhit'] = "u\$3r '%s' IS baNN3D. LOG0N '%s' m4+ChED B4N d@t4 '%s'";
$lang['nicknamebanhit'] = "us3r '%s' I\$ B4NN3D. N1CKn4M3 '%s' Ma+CHed 8@n Da+@ '%s'";
$lang['emailbanhit'] = "u\$3r '%s' is B4Nned. 3M@1L 4dDRESS '%s' m4TCh3d B4N D4t4 '%s'";
$lang['refererbanhit'] = "u\$3R '%s' i5 B4NNEd. ht+P rEPh3rER '%s' M4+CH3d BAN DA+A '%s'";

$lang['modifiedpermsforuser'] = "m0dIPh1ed PeRMS f0r U\$eR '%s'";
$lang['modifiedfolderpermsforuser'] = "moDIF1ED PHOldER PErmS F0r US3r '%s'";

$lang['userpermfoldermoderate'] = "f0lD3r moDERa+0R";

$lang['adminlogempty'] = "aDmIN L0g 15 3MP+Y";

$lang['youmustspecifyanactiontypetoremove'] = "j00 muS+ sPEciPhy 4N aCTIon +yPE t0 R3M0VE";

$lang['alllogentries'] = "aLl L0g 3NTR13S";
$lang['userstatuschanges'] = "u\$Er \$t4tu\$ CH4n9ES";
$lang['forumaccesschanges'] = "foruM 4Cc3sS ChaNg3s";
$lang['usermasspostdeletion'] = "uS3r M4sS POst dEL3T1oN";
$lang['ipaddressbanadditions'] = "ip 4dDResS b@N 4DdITi0ns";
$lang['ipaddressbandeletions'] = "ip @DdR3sS bAn DElE+10NS";
$lang['threadtitleedits'] = "thRe4d TItl3 ED1t\$";
$lang['massthreadmoves'] = "m@\$\$ +HRe@D MOVes";
$lang['foldercreations'] = "folDeR cR3A+10N\$";
$lang['folderdeletions'] = "f0LD3R D3lE+10NS";
$lang['profilesectionchanges'] = "pRofILE \$3CTIoN ChanG3s";
$lang['profilesectionadditions'] = "pr0PHILE \$3C+10N @dd1TI0NS";
$lang['profilesectiondeletions'] = "pr0f1Le \$3C+1ON del3TI0NS";
$lang['profileitemchanges'] = "pr0PHILe it3M Ch4NGes";
$lang['profileitemadditions'] = "pR0pHILE i+3M 4dDITi0Ns";
$lang['profileitemdeletions'] = "pR0pHil3 i+3M dELE+10nS";
$lang['startpagechanges'] = "s+4RT P49E cH4N93\$";
$lang['forumstylecreations'] = "f0rUM \$+YLE crEA+Ion\$";
$lang['threadmoves'] = "thre4d moVES";
$lang['threadclosures'] = "thr34D cL0SUREs";
$lang['threadopenings'] = "thrE4d op3NIN9S";
$lang['threadrenames'] = "tHr34d ren4M3\$";
$lang['postdeletions'] = "p0\$t D3lE+10NS";
$lang['postedits'] = "pOST 3D1+S";
$lang['wordfilteredits'] = "w0rd f1lT3R 3D1+S";
$lang['threadstickycreations'] = "thr3@D StickY Cr34tioNS";
$lang['threadstickydeletions'] = "thRE@d stICKY d3L3+10N\$";
$lang['usersessiondeletions'] = "uS3r SE\$S1ON d3LE+1Ons";
$lang['forumsettingsedits'] = "fORUM sE+T1ngS 3DIts";
$lang['threadlocks'] = "threAD loCk\$";
$lang['threadunlocks'] = "thr3@D unL0CKS";
$lang['usermasspostdeletionsinathread'] = "uS3r m4sS PO\$+ D3L3+10N5 IN A ThRE4D";
$lang['threaddeletions'] = "tHr3@D dELE+1ONS";
$lang['attachmentdeletions'] = "a++AChM3N+ D3lEtI0N\$";
$lang['forumlinkedits'] = "f0Rum LiNK 3DiTS";
$lang['postapprovals'] = "po\$+ 4PPR0V4L\$";
$lang['usergroupcreations'] = "uSER 9ROUP CRe4tI0Ns";
$lang['usergroupdeletions'] = "u53R grouP DELetI0N\$";
$lang['usergroupuseraddition'] = "us3R Gr0uP uS3R @dd1Ti0N";
$lang['usergroupuserremoval'] = "us3r 9R0uP us3r R3MOV4L";
$lang['userpasswordchange'] = "uSER p4\$SW0RD cH4NGE";
$lang['usergroupchanges'] = "u\$er GroUP cH4ngES";
$lang['ipaddressbanadditions'] = "iP 4DDRESs 8AN 4DDi+1oN\$";
$lang['ipaddressbandeletions'] = "iP @DDr3\$s B4n D3L3Ti0nS";
$lang['logonbanadditions'] = "l090N 84N @ddi+1ONS";
$lang['logonbandeletions'] = "lO90n BAN DelE+10NS";
$lang['nicknamebanadditions'] = "n1ckN@mE 8@n @ddI+1On\$";
$lang['nicknamebanadditions'] = "n1cKN4M3 b4n 4DD1+10nS";
$lang['e-mailbanadditions'] = "e-m@1L 8@n 4DD1+1on\$";
$lang['e-mailbandeletions'] = "e-mAIl 84N D3Le+I0N\$";
$lang['rssfeedadditions'] = "rSs Ph33D 4Dd1tI0NS";
$lang['rssfeedchanges'] = "rsS Feed CH4N93s";
$lang['threadundeletions'] = "tHre4d Und3l3TI0N\$";
$lang['httprefererbanadditions'] = "h++P REph3R3R B4N 4Ddi+10NS";
$lang['httprefererbandeletions'] = "h+tP reFER3R B4N d3LE+10N5";
$lang['rssfeeddeletions'] = "r\$s F33D D3LE+10nS";
$lang['banchanges'] = "b4n CH4N93s";
$lang['threadsplits'] = "tHRE4d \$Pl1+s";
$lang['threadmerges'] = "tHrE4D meRGe\$";
$lang['userapprovals'] = "u\$er @PPr0v@LS";
$lang['forumlinkadditions'] = "fORUm l1NK 4Dd1Ti0nS";
$lang['forumlinkdeletions'] = "fORUM lINK DEl3ti0N\$";
$lang['forumlinktopcaptionchanges'] = "f0ruM l1NK +op c4P+10N ch@Nge\$";
$lang['folderedits'] = "fOlDEr 3DITS";
$lang['userdeletions'] = "user D3lE+10NS";
$lang['userdatadeletions'] = "us3R D4+a dEL3+I0NS";
$lang['forumstatsautoupdates'] = "f0rUm sTA+S AU+O UPDa+3s";
$lang['forumautothreadunreaddataupdates'] = "fOrUm 4UT0 +HR34D UNR34D d@+a UPd4+3\$";
$lang['usergroupchanges'] = "uS3r GR0uP CH4n93S";
$lang['ipaddressbancheckresults'] = "ip aDDR3\$\$ BaN Ch3ck R3Sult\$";
$lang['logonbancheckresults'] = "lo90n B4N CHecK RESUlTS";
$lang['nicknamebancheckresults'] = "n1CKn4M3 b4N ch3CK r3\$uLTS";
$lang['emailbancheckresults'] = "eMA1L b4n ChECK RESuLT\$";
$lang['httprefererbancheckresults'] = "httP r3fEr3R 8@N cHEck R3SUl+S";

$lang['removeentriesrelatingtoaction'] = "reM0Ve EN+rIEs R3L4+1Ng T0 4C+I0N";
$lang['removeentriesolderthandays'] = "rem0VE eNtr135 OldER TH@N (d4YS)";

$lang['successfullyprunedadminlog'] = "sUCCE5SPhuLLY PRUneD @dm1N LO9";
$lang['failedtopruneadminlog'] = "f41LEd tO pRUnE 4DMIn LoG";

$lang['successfullyprunedvisitorlog'] = "sUcc3s\$PHULLY PRUNED V1siTOR L09";
$lang['failedtoprunevisitorlog'] = "f41LEd +O PRUne VisIToR Log";

$lang['prunelog'] = "pRUn3 L0g";

// Admin Forms (admin_forums.php) ------------------------------------------------

$lang['noexistingforums'] = "n0 eX1STiNg F0RUm5 F0UNd. To CrEA+3 a New FOrUM CLicK TEh '4DD nEw' bUTTon 83LOw.";
$lang['webtaginvalidchars'] = "we8T4G C4N 0nLY c0NT41N uPP3RC@5E A-Z, 0-9 @ND UND3RsC0R3 Ch4r4C+3Rs";
$lang['databasenameinvalidchars'] = "d4+@8@s3 N4M3 c4n 0NLY C0N+@1N a-Z, @-Z, 0-9 4nD uNDErSC0Re CHAr@Ct3r\$";
$lang['invalidforumidorforumnotfound'] = "inv4lID F0RUm f1D OR ph0RUm NoT phOUnD";
$lang['successfullyupdatedforum'] = "sUcC3\$\$pHuLLY UPDa+Ed PhoRUm";
$lang['failedtoupdateforum'] = "f41LED +o UPdA+e FORuM: '%s'";
$lang['successfullycreatednewforum'] = "sUcCe5SpHULlY cr34TEd N3W PHOrUM";
$lang['selectedwebtagisalreadyinuse'] = "tH3 S3L3C+eD W3b+@G IS @LreaDY IN US3. PL34\$3 Ch0o\$3 4NOTHeR.";
$lang['selecteddatabasecontainsconflictingtables'] = "t3h 53L3CTeD D4TAb4sE c0N+41N5 CoNPhLIcTIN9 +4bLES. CONfLIcTIng +aBLe n@m3\$ 4RE:";
$lang['forumdeleteconfirmation'] = "aR3 J00 SURE j00 W4Nt TO d3lE+3 4LL oF t3h \$3l3CTed PH0RuMS?";
$lang['forumdeletewarning'] = "pLe4\$e NOTe ThA+ J00 C4Nno+ r3C0Ver D3LEtED fORUms. Onc3 D3L3+3D 4 pH0rUM 4ND ALL 0f 1+'\$ @SSOC14+3D d@Ta I\$ P3RMaNENTLy R3M0vED FR0M +hE D4t4B4SE. 1f J00 D0 NOT wI\$H tO d3lE+3 +h3 \$3LEc+ED PHoRUms pL3A\$3 cLICK C4NcEL.";
$lang['successfullyremovedselectedforums'] = "sucCE5SPHUllY DeLE+3D SELEc+3d ForuMS";
$lang['failedtodeleteforum'] = "f4iL3D +0 DeLE+3d F0RuM: '%s'";
$lang['addforum'] = "aDD F0rUM";
$lang['editforum'] = "eD1+ ForUM";
$lang['visitforum'] = "v151T F0RUm: %s";
$lang['accesslevel'] = "aCC3\$S LEvel";
$lang['forumleader'] = "fOruM L34DEr";
$lang['usedatabase'] = "u\$e D@t4B@S3";
$lang['unknownmessagecount'] = "unkn0WN";
$lang['forumwebtag'] = "forUM WeBT@9";
$lang['defaultforum'] = "d3f4uL+ F0rum";
$lang['forumdatabasewarning'] = "pl3@SE 3NSUR3 J00 S3L3Ct T3H CoRR3C+ DA+aBA\$e WhEN cR3@Tin9 A NEw PhorUm. oNC3 CR3At3d a New phORuM c4NNo+ B3 MOVEd b3+W33N 4V@iL4BLE d4T@B4s3s.";

// Admin Global User Permissions

$lang['globaluserpermissions'] = "gLo8@L u\$3r peRMi\$s1oNs";

// Admin Forum Settings (admin_forum_settings.php) -------------------------------

$lang['mustsupplyforumwebtag'] = "j00 MUSt \$UPPLy 4 F0RUM weB+Ag";
$lang['mustsupplyforumname'] = "j00 mUsT SUPpLY @ pH0RUm N4ME";
$lang['mustsupplyforumemail'] = "j00 Mus+ \$UPPlY 4 F0RUM eM@1l @DdRE\$\$";
$lang['mustchoosedefaultstyle'] = "j00 Must CHO0\$3 4 DEF4uLT PHOrum STYlE";
$lang['mustchoosedefaultemoticons'] = "j00 mU\$T ch00sE DepH4UL+ F0RUm EM0+1CON\$";
$lang['mustsupplyforumaccesslevel'] = "j00 MusT 5UPPly 4 FoRUM 4CCesS leV3L";
$lang['mustsupplyforumdatabasename'] = "j00 MuST SUppLY 4 Ph0rUM D4+4B4S3 n4m3";
$lang['unknownemoticonsname'] = "unkNOWn EM0TIcONS n4m3";
$lang['mustchoosedefaultlang'] = "j00 MUS+ Ch0o5e A D3F4ULt PH0RUm LAN9u@GE";
$lang['activesessiongreaterthansession'] = "aC+IV3 5ESs10n TIMeoUT C4nNOT 8E 9R3@t3r tH4N s3SS10N t1MEOU+";
$lang['attachmentdirnotwritable'] = "a++@ChmeN+ D1R3CT0RY @Nd SYS+3M +emPOR@ry dIR3CT0rY / pHp.IN1 'uPLo4d_TmP_DIR' Mus+ b3 wRIt4BLe By TEH w38 S3RV3r / PhP PR0c3S5!";
$lang['attachmentdirblank'] = "j00 MU5+ \$UPpLY A diREC+0rY TO \$@VE 4tt4CHM3NTS 1N";
$lang['mainsettings'] = "m@1N S3Tt1n9S";
$lang['forumname'] = "foruM NAm3";
$lang['forumemail'] = "fORUM 3m@Il";
$lang['forumnoreplyemail'] = "n0-R3pLY em@iL";
$lang['forumdesc'] = "forUM D3SCRIPT10N";
$lang['forumkeywords'] = "f0rUM kEYWORD\$";
$lang['defaultstyle'] = "dePHAULT stYL3";
$lang['defaultemoticons'] = "dEph4uL+ Em0+IcoN\$";
$lang['defaultlanguage'] = "d3ph4ULT laNGu49e";
$lang['forumaccesssettings'] = "f0rUM aCC3Ss S3++1NG5";
$lang['forumaccessstatus'] = "foruM 4CC3SS s+@+us";
$lang['changepermissions'] = "cH4N93 pERM1SSI0n\$";
$lang['changepassword'] = "cH4Nge P@S\$worD";
$lang['passwordprotected'] = "p@ssWORD Pr0teCTeD";
$lang['passwordprotectwarning'] = "j00 HAVE n0T S3+ 4 pHorUm P@\$SW0Rd. 1F j00 D0 n0+ \$3+ 4 p@SSw0rD tH3 pA\$\$w0RD pr0T3C+10n FUnCTiON4LI+Y WiLL 83 auT0m@T1C@lLY DIs4BL3D!";
$lang['postoptions'] = "p05+ OP+1on\$";
$lang['allowpostoptions'] = "aLLOW P0ST 3DItINg";
$lang['postedittimeout'] = "p0ST ED1T +IME0U+";
$lang['posteditgraceperiod'] = "po\$T 3DI+ 9R4CE P3Ri0d";
$lang['wikiintegration'] = "w1KIw1k1 INtEGR4T1ON";
$lang['enablewikiintegration'] = "eN4Bl3 WIkIW1K1 1NT39R4TIOn";
$lang['enablewikiquicklinks'] = "eN48Le WIkIW1KI Qu1cK LInks";
$lang['wikiintegrationuri'] = "wik1Wik1 L0C@tI0N";
$lang['maximumpostlength'] = "m@xIMUM p0\$+ LEng+H";
$lang['postfrequency'] = "p0St pHR3QUeNCY";
$lang['enablelinkssection'] = "eN4bL3 LiNKS sECtI0N";
$lang['allowcreationofpolls'] = "aLLoW cRE4TI0N Of PoLL\$";
$lang['allowguestvotesinpolls'] = "alloW GU3\$T5 to V0TE 1n poLl\$";
$lang['unreadmessagescutoff'] = "unr3@D M3sS@GEs cU+-OFph";
$lang['disableunreadmessages'] = "dIs4bl3 UNRe4D mE\$s@9e\$";
$lang['thirtynumberdays'] = "30 DAY\$";
$lang['sixtynumberdays'] = "60 d@YS";
$lang['ninetynumberdays'] = "90 D4YS";
$lang['hundredeightynumberdays'] = "180 d4ys";
$lang['onenumberyear'] = "1 y34r";
$lang['unreadcutoffchangewarning'] = "d3p3nDing On S3rVER PerF0RM@Nce @ND tHe NumBER 0f +hREADS yoUR f0rUMS CON+aIN, CH4N91NG thE Unr3AD CU+-0fPH M4Y t4k3 SEVeRAL m1nUTE\$ +o COMPl3+3. pH0R THi\$ rE4SON i+ I5 r3c0MM3ND3D +H@t J00 @voId CH@NGiNG +H1S s3T+1NG WH1LE YOUR fORuMS 4RE 8uSY.";
$lang['unreadcutoffincreasewarning'] = "inCREas1N9 T3H uNr34d cuT-ofF W1ll REsuLt 1N +HRE4DS oLDeR tH@n THE CUrREnt Cu+-oFPh 4PP34R1NG 4s uNRE4d fOR @ll US3R5.";
$lang['confirmunreadcutoff'] = "aRe J00 \$uRE J00 W4nt TO CH4N9E +HE UnR3@d CuT-0FPh?";
$lang['otherchangeswillstillbeapplied'] = "cLicK1n9 'nO' W1lL OnlY CAnc3l +h3 uNRe4D cUT-OPHF cH@nGE\$. o+Her CH4N93S yOu'v3 M4dE WiLl \$+1Ll B3 5@veD.";
$lang['searchoptions'] = "s3@RCH 0p+10N\$";
$lang['searchfrequency'] = "se@RCH fREqU3nCY";
$lang['sessions'] = "s3S\$I0N\$";
$lang['sessioncutoffseconds'] = "se\$s10n cuT 0FPH (\$3CONDs)";
$lang['activesessioncutoffseconds'] = "aC+ive \$ESs10n CUt oPhF (s3CONdS)";
$lang['stats'] = "sT@ts";
$lang['hide_stats'] = "h1D3 5T@+\$";
$lang['show_stats'] = "sh0W sTa+5";
$lang['enablestatsdisplay'] = "eN4bL3 ST@t\$ d1SpL4y";
$lang['personalmessages'] = "p3r5oN4l MEs\$4g3s";
$lang['enablepersonalmessages'] = "eN@blE P3RSOn@L m3sS49ES";
$lang['pmusermessages'] = "pm Me\$s@93S p3r Us3R";
$lang['allowpmstohaveattachments'] = "aLLOw PErsoN@l M3ss4geS +0 hAV3 @T+AChMentS";
$lang['autopruneuserspmfoldersevery'] = "au+o PRune U5eR'5 Pm fOLdeRS 3V3RY";
$lang['userandguestoptions'] = "uSer @nD gu3\$t OPti0n\$";
$lang['enableguestaccount'] = "enaBL3 Gu3\$+ Acc0UN+";
$lang['listguestsinvisitorlog'] = "l1\$T gu3\$T\$ iN vIsITor L0g";
$lang['allowguestaccess'] = "all0w 9u3sT acC355";
$lang['userandguestaccesssettings'] = "u\$3r @ND gue\$t 4cC35S \$e++Ing\$";
$lang['allowuserstochangeusername'] = "aLloW us3Rs tO ch4n93 U\$3rN@ME";
$lang['requireuserapproval'] = "r3qU1RE us3R 4Ppr0V4L By 4dMiN";
$lang['requireforumrulesagreement'] = "reqU1RE US3R +O 4GReE To PhoRUM RUle5";
$lang['sendnewuseremailnotifications'] = "s3nD noTIF1c@TiON t0 9Lo8@L ph0RUm 0Wn3R";
$lang['enableattachments'] = "eN4bLe 4+T@cHM3N+S";
$lang['attachmentdir'] = "a+t@Chm3NT D1R";
$lang['userattachmentspace'] = "a+t@CHM3nt Sp4cE pER u\$3R";
$lang['allowembeddingofattachments'] = "allOW EMbeDDinG 0PH 4t+AchMeN+S";
$lang['usealtattachmentmethod'] = "u5e 4lTERNAT1V3 4T+4CHM3nT mE+HOd";
$lang['allowgueststoaccessattachments'] = "allOW GU3\$TS +O aCC3s5 4TT4ChM3N+s";
$lang['forumsettingsupdated'] = "foRum \$3+tIn9s \$uCcESSFulLy UpD@T3D";
$lang['forumstatusmessages'] = "fORUM \$+@tUS M3SsAGes";
$lang['forumclosedmessage'] = "fORUM cl0\$3D m3\$S493";
$lang['forumrestrictedmessage'] = "fORUM RESTricTEd ME\$S4G3";
$lang['forumpasswordprotectedmessage'] = "f0rUM pAsSWORD PRO+ec+3D m3\$s@Ge";

// Admin Forum Settings Help Text (admin_forum_settings.php) ------------------------------

$lang['forum_settings_help_10'] = "<b>p0\$t 3DIt T1M30UT</b> i\$ +H3 +1mE iN m1nUte\$ 4F+er P0\$+1N9 th@+ 4 US3r c4N eD1T thE1R poS+. 1PH s3+ +0 0 TheR3 IS n0 Lim1T.";
$lang['forum_settings_help_11'] = "<b>m@X1MUm PO\$+ LeN9+H</b> 1\$ th3 M4X1muM nUMbER 0f CH@R4C+3R\$ Th4+ w1LL B3 Di\$PL4Y3D 1n @ P0St. IpH 4 p0sT 1s LONgER tH@n T3H NUmBEr OPH CHar4C+3R\$ D3F1NEd HERe 1T WilL BE Cu+ sH0Rt @ND A l1nK 4DDEd +0 +H3 8oTtoM T0 4LLOW us3r\$ +0 R34D t3h wh0LE pOST oN @ s3p4R4+3 P4G3.";
$lang['forum_settings_help_12'] = "iph J00 D0n'+ WAN+ YOUR Us3R\$ T0 83 48LE +0 CRE4T3 POlLS J00 c@N D1sA8L3 THe 480VE opt10N.";
$lang['forum_settings_help_13'] = "tHe LINk\$ 5EC+1oN 0F BEeh1VE pR0V1D3S 4 Pl@Ce PhOR Y0UR uS3R\$ TO M41N+a1N 4 L1ST 0f \$1+3s ThEY fr3QU3NtLY VI\$1t tH4T 0+h3r US3R\$ m4Y F1ND US3PHul. lINk\$ C4N b3 D1VId3d INtO c4t390R1ES By F0LDer @Nd 4LLoW foR comm3N+\$ 4ND RA+1ngS tO 83 G1v3N. 1n OrDER to m0D3R4TE tHe LInk\$ s3C+10N 4 uSER mU5+ B3 R4ntED GL08AL M0dER4TOr S+4+US.";
$lang['forum_settings_help_15'] = "<b>s3ssIOn CUt 0FPh</b> 1s ThE m4X1MUm +1m3 83FOR3 4 US3R's s3\$S10N i5 DeeM3D D34D aND THEy 4R3 lOG93D 0Ut. by D3Ph4UL+ ThIS 1S 24 HOurS (86400 s3C0Nd\$).";
$lang['forum_settings_help_16'] = "<b>aCt1VE \$3\$S1oN cU+ 0pHPH</b> 1S +hE MaX1MUM +1M3 B3PHOr3 4 USER'5 SES\$10N 1\$ d33m3D 1N4C+1V3 4+ wH1CH p0iN+ +h3Y ent3R @n IdLE \$+4+3. 1n +His ST4+3 tH3 U\$3R R3m4iNS loGGEd In, 8U+ THEY 4rE r3m0VEd pHR0m TEH @Ct1vE US3RS LISt 1N +3h ST4+S diSPl@y. 0nC3 +h3Y 8EC0ME aCt1v3 4941n +HEY wILl 83 R3-4DD3D to T3h LISt. 8Y deFAUl+ +h1s 5E++1nG I\$ SE+ +0 15 M1NUte\$ (900 S3C0ND\$).";
$lang['forum_settings_help_17'] = "eN4bLInG +h15 OPt1oN 4LloW\$ beEHiVE +0 InCLUde @ sT@TS d1\$PL@Y 4T the B0Tt0M OPh +3h mE\$s@9ES P@Ne sIm1LAr +o TH3 0ne US3D bY m4NY F0RUm \$OPHTWar3 +i+LES. oNc3 Ena8L3D +HE d1spL4Y oF +EH \$T@tS P493 C4N 8E +OgGL3D 1Nd1VIdU4LLy 8y E4Ch US3R. 1PH THeY DOn'+ wAN+ +O s3E i+ thEY CAn HidE I+ FroM view.";
$lang['forum_settings_help_18'] = "pERSoNAl MesS493\$ 4r3 1NV@lu@8LE 4s 4 WAY 0F t4kiN9 MOR3 PR1V4+3 Mat+ER\$ oUT OF VIEW 0f tHE oTHer MemB3RS. h0W3V3R if J00 D0N'+ w4NT yoUR U53R\$ +0 83 @8LE tO SEnD E4Ch 0+H3R pER\$0N@L M3ssAG3S J00 C@n DI\$ABle THi\$ 0P+10N.";
$lang['forum_settings_help_19'] = "p3rsoNAL mEs\$@gE\$ c4n 4LSo C0N+aIN a+T@cHMEN+s wHICH C4N 83 US3FUl phoR 3XChANGiN9 pHIL3S bE+W3EN uS3R\$.";
$lang['forum_settings_help_20'] = "<b>nOt3:</b> +3h Sp4cE AlL0C@+10n F0r PM @tt4cHM3NTS 1s +@K3N PHr0m 34CH US3R\$' M41n 4t+ACHM3NT @LloC4TIoN 4nD 1\$ NOT 1N 4ddI+10n TO.";
$lang['forum_settings_help_21'] = "<b>en@bL3 gu3\$t @cc0UNT</b> 4lL0WS v1\$1t0rs T0 8rowS3 Y0ur FoRUM 4ND R34d po\$TS W1+hOUT RE91ST3R1Ng 4 U5ER @Cc0UNt. 4 useR 4cC0UNt 1\$ S+1LL rEQUiRED IF +H3Y w1SH +0 PO5+ 0r Ch4N93 uS3R pr3PHErENc3\$.";
$lang['forum_settings_help_22'] = "<b>l1S+ gUE5Ts 1N vi51TOr Log</b> 4LLoWS j00 T0 SpECify wH3+h3R 0R nOT unREg1\$+3rED Us3r\$ 4RE li\$+3D 0N +3H V1SiT0R l0g 4L0N9 \$1d3 REgISTeR3D u\$ER\$.";
$lang['forum_settings_help_23'] = "beEH1VE @lL0W\$ 4+T4Chm3N+S +o 8E uPLO4D3d +0 m3\$Sag3S WHen Po5+Ed. 1Ph J00 haVE L1MI+3D wEB \$P@CE J00 m@Y wHIcH TO dI54BLe 4TT@Chm3N+S 8y CLEaRInG th3 b0x @Bov3.";
$lang['forum_settings_help_24'] = "<b>a++@CHmeNt D1R</b> I\$ Teh LOc@TiON 83EH1Ve \$HOUld STOR3 I+'5 4+T@ChmeNt\$ in. tH1\$ d1R3C+0Ry MUsT 3XIS+ 0n Y0UR w3B Sp4c3 4nD Mu\$T 8E WriT4BlE 8Y teH wEB \$3RV3R / PhP pr0C3\$s 0TheRwIS3 uPL0@ds WiLL PH@1l.";
$lang['forum_settings_help_25'] = "<b>att4cHmENt 5P4C3 PEr US3R</b> Is tH3 M@xImUM @moUN+ 0f diSk \$p4ce 4 US3r H4S phOR a++aCHmen+S. 0NC3 +His SP4ce 1S USed Up +3H uS3R C4NNO+ UPlo4D 4NY M0R3 @Tt4cHm3nTS. 8Y dEF@ul+ tHI\$ 1S 1MB of SPaCE.";
$lang['forum_settings_help_26'] = "<b>alLOW 3m8eDD1N9 0F 4+T4ChM3NTs 1N M3\$S@GE\$ / \$19n@Tur3S</b> ALlOWS US3R\$ T0 3M8eD @Tt4cHm3nT5 In POSTs. 3N48LInG +hI\$ 0p+10n wHIle USEphUl C@n 1Ncr34S3 YouR b@NDw1DTh U5AG3 DrAST1cALlY Und3R C3R+@1N C0Nph19uR4TI0NS oPH pHp. if J00 h4V3 LiM1+3D bANdwIdtH 1t i\$ REc0MMeND3D +H4+ j00 DI\$@BL3 +h1\$ OP+I0N.";
$lang['forum_settings_help_27'] = "<b>use 4LT3Rn4+iV3 4tT4ChMEN+ me+Hod</b> F0RCES b33HIV3 To USE an 4L+3rn4+1v3 R3+R1EV4L m3THod PH0R @++AChm3NTs. IF J00 r3cE1VE 404 ERR0r MESSAG3s wHEN +rY1NG +0 dOWNlo4D a++@CHMentS PhrOM M3ssAGes +Ry EN4BLinG tHIS 0PT1ON.";
$lang['forum_settings_help_28'] = "tHeSE \$3+T1NGS 4Ll0WS Y0Ur FORUm +o 83 5pIDErED 8Y se4RCh EN9INE\$ l1K3 90OGL3, @L+4V1st4 4Nd Y@hO0. if J00 5wi+ch +H1\$ 0pTI0N 0fF YouR F0Rum wILL N0+ B3 iNCluDEd In TheSE sE4RCh EN9iNE\$ R3sULts.";
$lang['forum_settings_help_29'] = "<b>allOW N3w U5ER r3GI\$Tr4tI0NS</b> @lLOWS 0r dISaLL0W\$ +HE CReA+10N Of NEW uS3r @Cc0UNt\$. SEttIn9 ThE 0Pti0N To NO C0MPl3+3LY D1\$@8Les +h3 ReG1sTr4t1ON phORM.";
$lang['forum_settings_help_30'] = "<b>eN4blE w1KIW1K1 inTeGR4TIOn</b> PR0VId3s W1K1WoRD sUpp0R+ iN YOUR f0RUM P0\$Ts. @ WIk1w0RD i\$ m4dE Up OF tW0 Or m0r3 C0NcAT3NA+3D W0RDS WI+h UPpERc@\$E lEtTERs (0F+3n r3PHeRReD to @s C4MeLCa\$3). 1f J00 WRi+e 4 WoRD ThI\$ W@Y i+ WilL @UTomAtiCaLlY 83 Ch4n9ED 1NTo @ hYPeRLinK POiN+1N9 +o YOur Ch0s3N w1k1WIKi.";
$lang['forum_settings_help_31'] = "<b>en@blE W1k1WIK1 qUICK l1NKS</b> 3n@BLES TeH U\$3 0ph M\$9:1.1 AnD Us3R:L0G0N \$+YlE 3x+3ND3D w1KIL1nkS wH1CH Cr3@TE hYPeRL1Nks +o T3H sp3cipH13D m3\$\$@g3 / USER PROPhiLE OF +H3 \$PEcIPhIEd US3R.";
$lang['forum_settings_help_32'] = "<b>w1k1WIK1 L0C@+10N</b> I\$ usED tO \$P3CIfy tHE URI of yoUR w1K1WIk1. wh3N enTerINg +EH uRI Us3 <i>%1\$S</i> TO 1nD1C@t3 WH3R3 1N TH3 Ur1 Th3 Wik1W0RD sHouLd 4pP3@R, I.3.: <i>h++P://EN.w1KIP3diA.OR9/wiki/%1\$s</i> W0Uld L1NK yoUR wikIWoRDS t0 %s";
$lang['forum_settings_help_33'] = "<b>f0Rum ACc3\$S s+A+Us</b> C0n+ROLS HOW U5ERs m@Y 4CCe\$S YOUR f0rUM.";
$lang['forum_settings_help_34'] = "<b>oPen</b> W1LL 4llOW 4ll U\$3R\$ AnD gU3s+S aCC3sS +0 Y0UR f0rUM Wi+HOuT RE5tr1C+10N.";
$lang['forum_settings_help_35'] = "<b>cLos3D</b> PR3V3NTS 4cCesS foR 4LL US3R\$, WitH thE EXcePti0N 0F +3H 4dM1N wh0 M4Y sTILl @cCESs THe 4dM1n p@n3l.";
$lang['forum_settings_help_36'] = "<b>r35+RIctED</b> @LL0ws +0 \$E+ @ l1s+ 0PH u\$3RS Wh0 4R3 4LloweD 4Cc3ss +0 Y0Ur FoRUm.";
$lang['forum_settings_help_37'] = "<b>p4SSwoRD PROteC+3d</b> ALLOws J00 +0 5e+ @ P4ssWORD TO GIVE 0UT +0 usER\$ 50 theY CAN 4CCeSs YoUR F0rUM.";
$lang['forum_settings_help_38'] = "wH3n S3TTiNG resTRiCtED 0R p4sSW0Rd PR0t3c+3D M0d3 j00 WiLL nEEd +O S4V3 y0uR cH4N9ES b3fOR3 j00 C@n ch4N9E Teh US3R @Cc3sS pR1VilE9Es 0r P@SsWOrd.";
$lang['forum_settings_help_39'] = "<b>Search Frequency</b> defines how long a user must wait before performing another search. Searches place a high demand on the database so it is recommended that you set this to at least 30 seconds to prevent \"search spamming\"fr0m KiLLIn9 THE s3RVer.";
$lang['forum_settings_help_40'] = "<b>pO5+ FreqUENcY</b> 1s +h3 M1NImum +1mE a US3R mUST W4I+ b3fORE +HeY C4N p05+ 49AIn. +h1\$ S3+TiN9 AL50 @pHFEctS tHE Cr34+10N oF POLl\$. \$3+ TO 0 TO dIS4BLE +3H ResTr1CtI0N.";
$lang['forum_settings_help_41'] = "th3 48oVe 0P+I0n\$ ch4N9E +EH dEPh@Ul+ V@lu35 For tHe uSER RE91sTr4+10n pH0Rm. wh3R3 4ppLIc@8L3 O+h3r SEtTInGS wILl u\$3 Teh F0RuM'S 0WN DEPh@UL+ \$3+TiNG\$.";
$lang['forum_settings_help_42'] = "<b>pr3v3n+ U\$3 OF dUPLiC@+3 3M41L 4DDR3SS3\$</b> PHorC3s BeEH1VE +0 CH3CK TEH usER ACcOUN+s 4G@InsT th3 3MA1L 4ddR3SS +h3 USEr IS rEgIST3R1N9 w1+H 4ND prOMPt5 THEM +0 US3 4NotHER 1f I+ Is aLr3aDY iN US3.";
$lang['forum_settings_help_43'] = "<b>reQU1R3 3m@1L c0NFiRM4T10N</b> WHEN 3n4BL3D w1lL \$3ND AN eM41L to 3ACH NeW us3R wiTh @ lInK +h@T CAn Be U\$3D TO c0NF1rm +H31R eM@il 4DdR3S\$. UnT1l +HeY conFiRm TH31r EmAiL AdDre5s tHEy W1Ll N0+ B3 48Le to P0\$+ UnlE\$s +HE1R U\$3R PErMI\$SI0N\$ 4Re CH4ng3D M4nU4Lly bY @n 4DM1N.";
$lang['forum_settings_help_44'] = "<b>uSe +3xT-cAptcH4</b> PR3\$3Nts +He NEW uSer w1+H 4 MangLED iM493 WhICH TH3Y muST COPy A numBER pHr0m InTO 4 T3XT pHiELd 0N teH R3Gis+R4TION PH0Rm. US3 +h1s OpT10N TO PRevENT aUT0m@T3d S1GN-up v1@ ScRIp+\$.";
$lang['forum_settings_help_47'] = "<b>p0st 3dIT 9r4c3 p3r1OD</b> 4LL0W\$ j00 TO d3PH1Ne @ pERioD in MiNU+3S wHERE uS3R\$ May 3DIt P0\$+s W1Thou+ +H3 '3D1+3d BY' T3xT APp34RIN9 ON THE1r PO\$tS. iF SeT +0 0 +3h '3D1+3D By' +3xT W1ll 4LW@YS 4PpEaR.";
$lang['forum_settings_help_48'] = "<b>unREaD M3SsaGE5 cuT-oFf</b> \$p3cIf1e\$ H0W l0NG me\$saGES R3M@1N uNR3AD. THR3AdS M0DIfiEd N0 l4tER +h4N thE P3R10d S3L3C+3D W1LL AUt0m@tic4LLY @Pp3AR 4\$ RE4D.";
$lang['forum_settings_help_49'] = "cH00s1N9 <b>d1\$@8Le uNR3Ad Me\$S49E5</b> WIll comPLE+3LY R3mOV3 uNR3Ad MES5@Ges SUPp0r+ 4ND RemoV3 +h3 R3LEv4nT OP+1OnS PHr0M tHE d1sCuSs10N +yP3 DROP dOWN oN th3 +Hre4d lIS+.";
$lang['forum_settings_help_50'] = "<b>r3quIR3 US3R APpr0V4L by @dMIn</b> 4lLOw5 J00 +O RES+RIc+ 4CC3ss 8Y nEW U\$3RS uNTil Th3Y h4vE B3EN appROVed bY @ MOdeR4+0R oR 4DmIN. w1tH0U+ @PpR0V4L @ uS3R CaNN0t @Cce\$\$ @nY 4R34 0F +He 83EH1vE FOrUM 1N\$+@lLa+10n InCLuDInG iND1VIdu4L Ph0rUm\$, pM 1nb0x 4Nd My F0Rums S3C+10NS.";
$lang['forum_settings_help_51'] = "use <b>cLosED MesS49E</b>, <b>r35tR1CT3d MESSAge</b> 4ND <b>p@\$SWorD Pro+3CT3D m3\$S4G3</b> T0 CUs+OMI\$3 +eh M3\$S@93 DI\$pL4YED whEN uS3R5 4CC3SS y0uR ph0rUM IN +H3 V4r10US S+a+3S.";
$lang['forum_settings_help_52'] = "j00 C4N USE H+mL 1N y0uR me\$s@9ES. HYp3RL1NKS 4nD 3m@1L 4DDr3ss3S WilL 4L\$O 8E 4U+om@+IC4LLY CONv3rTED +0 LiNKS. +0 U\$3 +H3 DEph@uL+ bE3H1Ve FORuM Me5\$@Ge5 CL34R +HE phIELD\$.";
$lang['forum_settings_help_53'] = "<b>aLLOW u\$3R\$ +0 CHaNG3 us3RN@mE</b> P3RM1T\$ 4lR3@dY r39I\$T3r3d usER5 t0 CH4N9E +He1R us3RN4M3. Wh3N En48L3D j00 C4N +R4Ck THe Ch@NgE\$ A U\$3R m4kES +0 Th31R u\$3rN@ME VI4 Th3 Adm1N usER TOOls.";
$lang['forum_settings_help_54'] = "u\$3 <b>fORUm RULes</b> +O 3n+3R 4N ACc3P+48Le Us3 P0L1CY +h4T 34CH USEr mU\$+ 4gR3E +0 b3pH0r3 r3G1\$+3RinG oN yoUR fORuM.";
$lang['forum_settings_help_55'] = "j00 c@N U\$3 HtmL iN yOUR foRUm RuLES. HYPERLiNK5 4Nd 3MAiL @DdrE\$sES wiLL 4LS0 83 4U+om4TiC@lLy c0nVeRTEd +0 l1NKS. TO USE tHe D3Ph4UL+ 83EH1ve F0RuM @UP cLe4R teH fIELd.";
$lang['forum_settings_help_56'] = "u\$e <b>n0-RepLy EMa1l</b> T0 Sp3C1PHy @n 3M@iL @DDrESS THa+ DOe\$ No+ exI\$T oR wILl N0T 83 m0Ni+OReD F0R rePLieS. tH1\$ eM41L ADDR3Ss W1LL 8e U\$eD 1N +h3 H3@derS pHoR 4lL EM@IL\$ S3NT PHRom yOUR forUm 1NCLUdIN9 bU+ noT L1m1+3D +o p0sT @nD Pm N0TIF1c@TIonS, US3R 3M4Il\$ And pa\$SWORD r3M1ND3R\$.";
$lang['forum_settings_help_57'] = "iT 1\$ R3C0mM3ND3D TH4T j00 US3 @N 3M41L @dDR3\$S +h4T doE\$ nOT 3x1ST tO HelP cU+ doWN ON SPaM +H@+ maY 83 DirECTeD 4T y0uR M@In F0RUm 3MA1L 4Ddr3SS";
$lang['forum_settings_help_58'] = "in ADDitI0N to \$1MPL3 \$PID3RIng, 8E3HIv3 C@n 4L\$0 G3NEr4T3 A \$1tEM4P FOR teH F0rUM +O m4k3 IT 3As13R PHor S34RCH En9iN3\$ +O Ph1nd 4ND 1nd3x +h3 m3\$s@g35 POS+3D by YOUr USEr5.";
$lang['forum_settings_help_59'] = "sI+3M@p\$ 4R3 4U+0M@TiC4lLY S@v3d +o TEh SItEM4PS su8-D1REC+ORY 0f YOUr B3EHIv3 PHORUM 1n\$T@LL@ti0N. 1PH tHIS D1RECtoRY d03sN'+ 3x1sT j00 MUST CRE@+3 I+ 4ND ENSURe +H4T it I\$ wr1+4BL3 BY +HE 53RVER / PHP PROC3ss. +O 4LLOW SE4rcH 3N91N3\$ To F1nD Y0UR SI+eM@P J00 mu\$T @DD +3H UrL +O Y0uR ROBOt5.tXT.";
$lang['forum_settings_help_60'] = "d3p3NDInG 0N s3RV3R pERpH0Rm4nC3 4nD +H3 NuMB3R oF foRUM\$ And ThR34DS y0UR bE3H1V3 IN\$T@Ll4+1ON c0N+4In\$, 9EN3R4T1Ng 4 SI+EM4P m@y T4K3 Sev3r4L M1nuT3S +0 cOMpL3T3. IF pERf0rM4NC3 0ph yoUR S3RVer 1S 4DV3R\$lY @FF3C+3D 1+ iS reC0MmEnd J00 diS48L3 g3nER4TI0N OF tHE s1+3M4p.";
$lang['forum_settings_help_61'] = "<b>s3ND 3m@1L N0pH1tiC4TIon +o 9L08@L 4DMin</b> WH3n En@BlED w1lL sEnD an EM41L to ThE 9L084L FOrUM 0WN3RS WHeN 4 New USeR @CC0UNT I\$ CR34+3D.";

// Attachments (attachments.php, get_attachment.php) ---------------------------------------

$lang['aidnotspecified'] = "aid NO+ specipH13D.";
$lang['upload'] = "uPL0AD";
$lang['uploadnewattachment'] = "uPlO4d NeW aTT4CHm3nT";
$lang['waitdotdot'] = "w4iT..";
$lang['successfullyuploaded'] = "sUCC3\$SPhULlY Upl04DED: %s";
$lang['failedtoupload'] = "f4ILEd +O UpLO4D: %s";
$lang['complete'] = "cOmPLeT3";
$lang['uploadattachment'] = "uPl04d 4 F1L3 PhoR A+T@cHMeN+ +0 tHe ME\$sAG3";
$lang['enterfilenamestoupload'] = "en+ER fiLEN@mE(S) TO UpLO@d";
$lang['attachmentsforthismessage'] = "atT4CHm3NT\$ PHOr ThIs M3S\$493";
$lang['otherattachmentsincludingpm'] = "oTH3R 4TT4cHmENts (1NcLUd1NG pM MesS4G3S 4ND 0tHer PhORUm\$)";
$lang['totalsize'] = "toT4l \$1ZE";
$lang['freespace'] = "fR3e SP@cE";
$lang['attachmentproblem'] = "tHere w4S 4 PRObL3m DOwNL0@D1NG +HI5 4T+4ChmEN+. PLEASe +RY @G4IN l4+3R.";
$lang['attachmentshavebeendisabled'] = "at+ACHM3NT\$ hAvE bE3N dI\$@8l3D 8y +3H pHORuM 0WN3R.";
$lang['canonlyuploadmaximum'] = "j00 C4N OnlY UPlo4D 4 M4XiMUM of 10 f1l3s 4T @ t1Me";
$lang['deleteattachments'] = "d3l3+E 4T+4CHm3N+S";
$lang['deleteattachmentsconfirm'] = "aRE j00 SUR3 J00 WaN+ +0 D3L3T3 +HE S3L3CTEd @t+4ChmENT\$?";
$lang['deletethumbnailsconfirm'] = "aR3 J00 \$ur3 J00 W4Nt TO DElETE tEH \$3L3C+3D @tTachM3N+s +HUMbn41L5?";

// Changing passwords (change_pw.php) ----------------------------------

$lang['passwdchanged'] = "p4\$SWoRD ChanG3d";
$lang['passedchangedexp'] = "y0ur P4SSW0rd H4S b3eN cHAnG3D.";
$lang['updatefailed'] = "upd@+3 FAIleD";
$lang['passwdsdonotmatch'] = "p4\$sW0RD\$ D0 nO+ M4Tch.";
$lang['newandoldpasswdarethesame'] = "neW @ND 0lD PASSwoRDS 4re +H3 S@mE.";
$lang['requiredinformationnotfound'] = "rEQU1RED INphoRm4TIOn n0+ PH0uND";
$lang['forgotpasswd'] = "f0rGOT p@S\$W0RD";
$lang['resetpassword'] = "r3\$3T P4\$SWORD";
$lang['resetpasswordto'] = "r3\$3+ P45\$WOrd TO";
$lang['invaliduseraccount'] = "iNV4LID u\$3R 4CCOuNT sPecIF1ED. CHeCK 3M@Il f0R CorR3C+ L1nk";
$lang['invaliduserkeyprovided'] = "iNV@L1D U\$er k3Y PROV1D3D. cHECk EM4IL FOR cORr3cT l1NK";

// Deleting messages (delete.php) --------------------------------------

$lang['nomessagespecifiedfordel'] = "n0 M3\$S4g3 \$pEC1fi3D F0R d3LETI0N";
$lang['deletemessage'] = "dEL3+e m3554gE";
$lang['successfullydeletedpost'] = "sUCC3\$SphullY d3l3+3D p0sT %s";
$lang['errordelpost'] = "eRr0R D3le+1N9 po\$+";
$lang['cannotdeletepostsinthisfolder'] = "j00 CaNN0T D3L3+3 P0\$t5 1N ThIS f0ldEr";

// Editing things (edit.php, edit_poll.php) -----------------------------------------

$lang['nomessagespecifiedforedit'] = "no Me\$sA93 \$pECiPHI3d PHOR 3d1+In9";
$lang['cannoteditpollsinlightmode'] = "c@nNO+ 3D1T P0LL\$ 1N l1GH+ m0DE";
$lang['editedbyuser'] = "edi+3D: %s By %s";
$lang['successfullyeditedpost'] = "sucCE\$SPHUlLY eDI+3D PO\$t %s";
$lang['errorupdatingpost'] = "err0r upD@tIN9 p0sT";
$lang['editmessage'] = "ed1+ M3SS@GE %s";
$lang['editpollwarning'] = "<b>noTe</b>: EDI+IN9 CeRTa1n 4\$P3c+s 0PH 4 P0LL WIlL vo1D @LL THe CURrEN+ V0T3S 4ND @LlOW pE0PLe +O Vo+3 4941N.";
$lang['hardedit'] = "h4rd ED1+ OPTI0N\$ (V0TES wILL 8e r3sET):";
$lang['softedit'] = "soph+ eDIT OPTiOn5 (V0T3S W1lL 8E re+a1NEd):";
$lang['changewhenpollcloses'] = "chaN9E wH3N +He POLl cL0\$3\$?";
$lang['nochange'] = "nO Ch4nGE";
$lang['emailresult'] = "em4Il ResULt";
$lang['msgsent'] = "mEss4G3 S3nT";
$lang['msgsentsuccessfully'] = "m3S\$4G3 \$enT SucC3SSphULLy.";
$lang['mailsystemfailure'] = "m4iL \$ysT3M Ph@ilURE. meSS4GE N0T s3nT.";
$lang['nopermissiontoedit'] = "j00 4RE noT p3RMi+T3D tO 3D1+ tHI\$ mEsS4GE.";
$lang['cannoteditpostsinthisfolder'] = "j00 C@nN0+ edi+ p0\$TS 1n +H1\$ foLD3R";
$lang['messagewasnotfound'] = "m3S\$@93 %s w4s Not FoUnD";

// Email (email.php) ---------------------------------------------------

$lang['sendemailtouser'] = "sEnd 3M4Il TO %s";
$lang['nouserspecifiedforemail'] = "n0 USer \$peC1PH13D f0r eM41Lin9.";
$lang['entersubjectformessage'] = "ent3R 4 SuBJ3cT pHOR TEh MeSS@ge";
$lang['entercontentformessage'] = "entER soME CON+3N+ PHoR thE m3\$s@9E";
$lang['msgsentfromby'] = "tH1\$ Me\$s@93 W4S S3N+ PHr0m %s 8Y %s";
$lang['subject'] = "suBJ3C+";
$lang['send'] = "send";
$lang['userhasoptedoutofemail'] = "%s ha\$ OPt3D ouT of eM@IL c0n+4C+";
$lang['userhasinvalidemailaddress'] = "%s H4S An INVaLiD Em@1L @dDr3sS";

// Message nofificaiton ------------------------------------------------

$lang['msgnotification_subject'] = "m3SS@GE noTIF1C@tI0N FroM %s";
$lang['msgnotificationemail'] = "h3lLO %s,\n\n%s P0\$teD A M3\$S@GE +0 J00 oN %s.\n\ntH3 Su8j3C+ 1\$: %s.\n\nto r3AD +h@T mE\$s49E 4ND OtHERS IN T3H S4M3 d1\$Cu\$sIoN, 90 +o:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nn0+3: 1PH j00 D0 n0+ W1\$H to r3cEiv3 3M41L n0TIphIc@+1ON\$ OPH PH0ruM meSSA9ES pO\$tED to y0u, 9o T0: %s ClICK on mY cONTroL\$ +H3N 3m@Il 4ND PRIv@CY, UN\$3L3CT tHE 3Mail n0tIPH1C4T1ON CH3CKb0x 4ND prESS sU8m1T.";

// Thread Subscription notification ------------------------------------

$lang['subnotification_subject'] = "sU8SCR1ptION N0TIPhic@TI0N pHROM %s";
$lang['subnotification'] = "h3lLO %s,\n\n%s PostEd 4 M3\$s493 IN 4 +HR3@d J00 H4v3 SUbsCr1B3D +0 0N %s.\n\n+H3 \$UBj3cT 1s: %s.\n\nt0 RE4D +h@T ME\$s@G3 aND oTh3r\$ 1N +3H \$@Me D1SCusSI0N, GO T0:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nnoTe: 1PH j00 Do Not wiSH TO r3ceiVE Em@Il N0+1PHiC4TI0N\$ OF NEw M3\$S@gES 1N +HiS ThrE4D, GO +O: %s 4ND 4DjU\$T y0uR 1N+3RESt L3veL 4T TEH B0+toM opH t3h P49E.";

// PM notification -----------------------------------------------------

$lang['pmnotification_subject'] = "pM no+1F1C4+I0N frOM %s";
$lang['pmnotification'] = "h3ll0 %s,\n\n%s P0st3d @ pM +O j00 0N %s.\n\n+H3 SUbJEC+ 1\$: %s.\n\n+O rE4d +3H m3sSA93 9o t0:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nno+3: 1pH J00 D0 n0t wisH +o r3cE1VE Ema1l N0T1F1C4t1Ons 0F NEW PM mESSAg3S P0\$t3d T0 Y0u, 90 To: %s CL1Ck My COntroL\$ +H3N ema1L 4nD PrIv4CY, unSEL3ct TeH pm n0+1F1C4tiON CH3ckb0X @nd pr3sS SU8M1+.";

// Password change notification ----------------------------------------

$lang['passwdchangenotification'] = "p@s\$WORD cH@Ng3 N0+1PHiC4TIoN FR0M %s";
$lang['pwchangeemail'] = "helLO %s,\n\n+hI\$ A N0T1FIc4tIon Em@iL +O Inf0RM j00 +h4+ YOur PasSWOrd On %s H4s 8E3n cHAN9ED.\n\ni+ HA\$ 833N cH@Ng3d +o: %s @Nd w4S ChANg3d by: %s.\n\n1f j00 H@ve R3C3IveD THis 3M@IL 1n ERROr 0r Wer3 N0+ 3XP3ctin9 4 CH4N9e +O Y0ur P4sSW0RD pL3A\$3 CONT@cT t3H PH0RUM 0WN3R OR 4 MOdeR4TOR 0N %s IMm3d1A+ELy tO CORr3Ct it.";

// Email confirmation notification -------------------------------------

$lang['emailconfirmationrequiredsubject'] = "eM@Il C0NF1Rm4tIOn REqu1R3D f0r %s";
$lang['confirmemail'] = "heLlo %s,\n\nYOU REcEN+lY cR3@tED a NEw U\$3R aCcoUN+ On %s.\n\n8Eph0RE J00 C4N sT@RT p0\$t1N9 We NEEd +o c0nFIrM YouR 3Ma1l @DDrEsS. doN'T WORry tHI5 i\$ QUi+E e@\$Y. @LL j00 NEEd T0 D0 1\$ cLIck +H3 LinK 83LOW (oR COpy @nd p@S+E 1T 1N+O YOuR 8R0WSER):\n\n%s\n\nOnC3 C0NF1RM4+1oN I5 comPL3T3 J00 M@y LOG1n @ND \$+@R+ P0sTIn9 IMMEd14t3LY.\n\nIF j00 D1D no+ crE4TE A US3r 4CCOUn+ ON %s PLe4S3 4CCEPt 0uR 4POLO91Es 4ND f0rW4RD ThI\$ 3mA1L +O %s S0 +H4T tHE SOuRCE oF i+ m4Y 8e INv3s+IGA+3d.";
$lang['confirmchangedemail'] = "hello %s,\n\ny0u R3CeNTly chANG3D yoUR 3M@iL oN %s.\n\nbePhoRE J00 C@N \$T4R+ p0s+1N9 49A1N we Ne3d t0 c0nPHIRm yoUR neW 3Ma1L @DdRESS. DOn'+ W0RRy THi\$ I\$ Qu1TE E@\$Y. @lL j00 N3ED +O DO Is CLicK thE L1nk 83LOW (0R CopY And p4s+3 It 1N+O yoUR BR0WSer):\n\n%s\n\nONCe c0nPH1RM4TIOn 1s Compl3+3 J00 M@y CONt1nUE +o US3 +He pHorUm 4S N0RMal.\n\nIPh J00 W3R3 No+ EXPEctIn9 Th1\$ eM@iL pHR0M %s pL3as3 4CCep+ ouR 4P0L0G13s 4ND PH0Rw4RD tHI\$ EM@1L +O %s SO Th@T tEh sOURce OF i+ M@y 83 INv3s+19@Ted.";

// Forgotten password notification -------------------------------------

$lang['forgotpwemail'] = "h3ll0 %s,\n\nY0u R3QUES+3d tHIS 3-Ma1l PhrOM %s B3C4U\$3 j00 H4v3 FOR90++3n yOUR P4S\$W0Rd.\n\nclIcK T3h LINK 8elOW (0r C0PY 4Nd P@\$Te It IN+O Y0Ur BR0W\$3r) t0 REs3+ y0uR p@\$sW0Rd:\n\n%s";

// Admin New User Approval notification -----------------------------------------

$lang['newuserapprovalsubject'] = "neW u\$3r 4PPr0V4L noTIphIC4+10n F0R %s";
$lang['newuserapprovalemail'] = "Hello %s,\n\nA new user account has been created on %s.\n\nAs you are an Administrator of this forum you are required to approve this user account before it can be used by it's owner.\n\nTo approve this account please visit the Admin Users section and change the filter type to \"Users Awaiting Approval\"oR cLicK +3h LiNK B3LOW:\n\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nNOt3: 0ThER aDMiNIsTRa+0rS oN +H1s F0Rum W1lL aL\$o R3C3IV3 tH1S n0+1F1C4t10n 4ND M4Y h4VE 4LR3AdY 4C+3D UpON +H1S R3quES+.";

// Admin New User notification -----------------------------------------

$lang['newuserregistrationsubject'] = "n3w U\$3R 4CCOuNT No+1F1c4+i0N fOR %s";
$lang['newuserregistrationemail'] = "hElL0 %s,\n\nA NeW U\$3r 4CCOuN+ H@S b33N Cre4t3d 0N %s.\n\n+o VIeW +HiS us3R @CC0Un+ PLe@\$e V1\$1+ +H3 @Dm1n UseRS s3c+10N 4Nd ClICk 0N +h3 NeW u\$3R 0r CL1ck TEh LinK 8eLOw:\n\n%s";

// User Approved notification ------------------------------------------

$lang['useraccountapprovedsubject'] = "u\$eR @PProV@L NOtIPhiC@+10N FoR %s";
$lang['useraccountapprovedemail'] = "h3ll0 %s,\n\ny0uR U5eR @CCOunT @t %s H4S B33N 4PPR0V3D. j00 c4n L091n 4ND sT@r+ P0\$TIn9 iMm3dIA+LY 8Y clICK1N9 tEH l1nK 8ELOW:\n\n%s\n\nif J00 WerE N0+ 3xP3C+1ng ThIS 3M@iL PhROM %s PLeas3 4CCEP+ 0UR 4P0LO91ES 4ND fORw4rD +h1\$ 3M@1L to %s 50 ThA+ thE \$OURCE oF 1T M4Y 83 INvESTIg4T3D.";

// Admin Post Approval notification -----------------------------------------

$lang['newpostapprovalsubject'] = "p05+ Appr0V@L n0TIFic4TIon FOr %s";
$lang['newpostapprovalemail'] = "hELLo %s,\n\n4 New P0\$T h4s 8E3n cR3@Ted 0n %s.\n\n@s j00 @R3 @ m0der4+Or oN th1\$ f0RUm J00 4r3 r3qu1R3d t0 @PPRovE +h1\$ P0\$t 8epHorE i+ C4N 8E R3aD bY 0TheR uS3r5.\n\nyOu CAN 4PPr0VE +H1\$ POs+ anD 4Ny 0+H3R\$ PENdINg 4pprOv@l by V1\$1+1n9 TEh @dm1N p0\$+ ApPR0V4L SectIoN 0F y0Ur FORUm 0r 8Y clICk1N9 Teh LInk BEL0w:\n\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nn0t3: o+Her 4DMinI\$TR@+OR\$ 0n thIS F0rUM W1LL 4LSo R3C31VE tH1\$ no+1f1C@+10N 4ND m4Y H4V3 4Lre@dy @C+3d upOn Th1\$ Reque\$+.";

// Forgotten password form.

$lang['passwdresetrequest'] = "yOuR p4\$5W0RD r35eT r3qu3s+ FR0M %s";
$lang['passwdresetemailsent'] = "p4SSWorD rE\$3+ 3-M41L seN+";
$lang['passwdresetexp'] = "j00 5HOULd SHorTLy R3C31V3 4N 3-M@1L C0N+A1NiN9 InSTruC+10n5 pHoR R3S3TT1N9 y0UR p4SSWOrD.";
$lang['validusernamerequired'] = "a v@L1D usERN@m3 1\$ ReQU1R3D";
$lang['forgottenpasswd'] = "f0rG0T pASSw0rD";
$lang['couldnotsendpasswordreminder'] = "coulD n0+ SeND P4\$SWOrD r3M1Nd3R. pL3A\$3 cOn+4C+ +hE phORUm OwNer.";
$lang['request'] = "rEqU35T";

// Email confirmation (confirm_email.php) ------------------------------

$lang['emailconfirmation'] = "eM@IL c0NPhIRm4tI0N";
$lang['emailconfirmationcomplete'] = "th4NK J00 FOr C0Nf1rMiNG your 3mA1L @DDrE\$S. J00 m4y nOW LOgiN aND S+ar+ p0S+1Ng imMeD14+3Ly.";
$lang['emailconfirmationfailed'] = "eMa1L C0NPH1rm@ti0N H4\$ FAIlED, PL345E tRY 49AiN L4Ter. 1F j00 3nC0uN+er ThIS ERror muLTipL3 +1M3\$ pLEAS3 CONt4c+ The f0RUM oWNER or @ MOD3R4+OR phoR @551s+4NC3.";

// Links database (links*.php) -----------------------------------------

$lang['toplevel'] = "tOP leVel";
$lang['maynotaccessthissection'] = "j00 M4Y n0T 4CC3\$5 ThI\$ S3C+1ON.";
$lang['toplevel'] = "tOp L3V3l";
$lang['links'] = "l1nkS";
$lang['externallink'] = "eX+3RN4L liNK";
$lang['viewmode'] = "vI3w MODe";
$lang['hierarchical'] = "h13R@Rch1C@L";
$lang['list'] = "list";
$lang['folderhidden'] = "thi\$ PhoLDeR I5 h1dDEn";
$lang['hide'] = "hidE";
$lang['unhide'] = "uNHID3";
$lang['nosubfolders'] = "n0 sU8PH0lD3RS In Th1s c4T390RY";
$lang['1subfolder'] = "1 sU8Ph0lD3R in +H1S c4te9ORY";
$lang['subfoldersinthiscategory'] = "subFoLD3r\$ 1N +H1\$ C4tEgorY";
$lang['linksdelexp'] = "en+R13\$ 1N a D3L3tED fOld3R WiLL 8E mOV3D +O +h3 P@R3Nt PholdER. 0NlY FOLD3Rs Wh1CH DO n0T c0nt41N \$u8PhoLdeR\$ M4Y b3 D3lEt3d.";
$lang['listview'] = "lI\$+ VIEw";
$lang['listviewcannotaddfolders'] = "c4Nn0+ 4DD PhoLdERS In +HIS V1EW. sH0w1N9 20 eNtR13\$ @t 4 +1M3.";
$lang['rating'] = "r4+1nG";
$lang['nolinksinfolder'] = "n0 l1NKS 1N +H1s PhOLd3r.";
$lang['addlinkhere'] = "aDD L1NK h3rE";
$lang['notvalidURI'] = "th@T i\$ nO+ a VaL1D UrI!";
$lang['mustspecifyname'] = "j00 mU\$t SP3CIphy @ n@ME!";
$lang['mustspecifyvalidfolder'] = "j00 mu5+ sPECIpHy 4 V@LiD f0lD3R!";
$lang['mustspecifyfolder'] = "j00 MUSt SP3C1FY 4 F0LD3R!";
$lang['successfullyaddedlinkname'] = "sucCeSsFULLY 4DD3d l1nk '%s'";
$lang['failedtoaddlink'] = "f@iLEd +0 @Dd L1NK";
$lang['failedtoaddfolder'] = "f@iLED T0 @dd Ph0LD3R";
$lang['addlink'] = "aDD @ l1nK";
$lang['addinglinkin'] = "add1n9 L1Nk In";
$lang['addressurluri'] = "addR3\$\$";
$lang['addnewfolder'] = "aDD @ new F0LDer";
$lang['addnewfolderunder'] = "aDdINg NEW PhoLDER uNDER";
$lang['editfolder'] = "ed1+ PholDER";
$lang['editingfolder'] = "eDi+IN9 F0LDEr";
$lang['mustchooserating'] = "j00 MU5+ CH0OSE @ RA+1NG!";
$lang['commentadded'] = "y0ur COMm3nt w@S @dD3d.";
$lang['commentdeleted'] = "c0MMEN+ WAS DELEted.";
$lang['commentcouldnotbedeleted'] = "c0MmeN+ C0ULD N0T 83 D3LE+3D.";
$lang['musttypecomment'] = "j00 mUST tYP3 4 coMMEN+!";
$lang['mustprovidelinkID'] = "j00 musT PROV1d3 4 LINk ID!";
$lang['invalidlinkID'] = "inV@l1d L1NK 1d!";
$lang['address'] = "adDR3Ss";
$lang['submittedby'] = "subM1++3D bY";
$lang['clicks'] = "cLiCKS";
$lang['rating'] = "r@T1N9";
$lang['vote'] = "vOTE";
$lang['votes'] = "vO+E\$";
$lang['notratedyet'] = "nO+ R4TEd 8Y 4NY0Ne Ye+";
$lang['rate'] = "r4Te";
$lang['bad'] = "b4d";
$lang['good'] = "go0d";
$lang['voteexcmark'] = "voTE!";
$lang['clearvote'] = "cL3AR VOT3";
$lang['commentby'] = "c0mm3N+ bY %s";
$lang['addacommentabout'] = "aDd @ cOMmeNt @boU+";
$lang['modtools'] = "m0d3rA+10N +0oL\$";
$lang['editname'] = "eD1+ Nam3";
$lang['editaddress'] = "eD1+ 4DDRESs";
$lang['editdescription'] = "edi+ D3SCRipT10N";
$lang['moveto'] = "mOve +0";
$lang['linkdetails'] = "liNK d3+@iLS";
$lang['addcomment'] = "add COmm3NT";
$lang['voterecorded'] = "y0uR v0t3 H@\$ B3En reC0Rded";
$lang['votecleared'] = "your v0+E haS B3En cLE4R3D";
$lang['linknametoolong'] = "l1nk NaM3 +OO loN9. m4x1MUM i\$ %s ch@r@C+3RS";
$lang['linkurltoolong'] = "l1nK urL +O0 L0Ng. M4XimUM 1\$ %s ChAR4C+3r\$";
$lang['linkfoldernametoolong'] = "fold3R nAM3 t00 L0Ng. m4x1MUm L3N9Th I\$ %s cH4RAc+Er5";

// Login / logout (llogon.php, logon.php, logout.php) -----------------------------------------

$lang['loggedinsuccessfully'] = "j00 L099ED 1N \$uCC3SSPhULLy.";
$lang['presscontinuetoresend'] = "pr3ss c0N+1NUe TO RESeND ph0RM Dat@ Or c4nC3L +o rEL04D p4GE.";
$lang['usernameorpasswdnotvalid'] = "tEh U\$3RnAM3 Or Pa\$SWOrD J00 SUppLiED is NO+ v@LId.";
$lang['rememberpasswds'] = "remeM8ER P@SswORd\$";
$lang['rememberpassword'] = "rEmEMb3r P@sSWOrD";
$lang['enterasa'] = "eNTEr @s A %s";
$lang['donthaveanaccount'] = "dON'T h4V3 4N @Cc0uNT? %s";
$lang['registernow'] = "rE9IST3R n0W";
$lang['problemsloggingon'] = "prO8LEms L09G1Ng 0N?";
$lang['deletecookies'] = "d3L3Te cO0KI3S";
$lang['cookiessuccessfullydeleted'] = "c0ok13s SUccE\$sFUllY D3L3TED";
$lang['forgottenpasswd'] = "f0r9oT+eN y0UR P@SSWoRD?";
$lang['usingaPDA'] = "uS1Ng 4 Pd4?";
$lang['lightHTMLversion'] = "lIgH+ h+ml VERS1ON";
$lang['youhaveloggedout'] = "j00 H4Ve L0GGed 0UT.";
$lang['currentlyloggedinas'] = "j00 4Re cURreNTlY l0G9ED IN 4S %s";
$lang['logonbutton'] = "lO90N";
$lang['otherdotdotdot'] = "o+H3R...";
$lang['yoursessionhasexpired'] = "yOUR s3sS1ON h@S 3XPirEd. j00 w1LL NEEd +0 l0GIn 4941N +o C0N+1nuE.";

// My Forums (forums.php) ---------------------------------------------------------

$lang['myforums'] = "mY pH0RUMS";
$lang['allavailableforums'] = "aLl 4V41l@BLe PH0RUM\$";
$lang['favouriteforums'] = "f4VOURi+E pHORuM\$";
$lang['ignoredforums'] = "i9n0R3D FOrUM\$";
$lang['ignoreforum'] = "ign0RE f0rUm";
$lang['unignoreforum'] = "unigN0R3 FoRUM";
$lang['lastvisited'] = "l4s+ V1S1+3D";
$lang['forumunreadmessages'] = "%s UNRE4D M3\$\$493\$";
$lang['forummessages'] = "%s m3sSAg3s";
$lang['forumunreadtome'] = "%s uNRE4d &quot;T0: me&quot;";
$lang['forumnounreadmessages'] = "n0 uNre4D meSs@Ges";
$lang['removefromfavourites'] = "r3moV3 Fr0M FAv0uR1T3S";
$lang['addtofavourites'] = "add +O Ph4vOuRITES";
$lang['availableforums'] = "aV@1LABLE PhoRUM\$";
$lang['noforumsofselectedtype'] = "th3RE 4R3 nO pHORum\$ 0F +EH \$3LEc+ED +YpE aVAIla8L3. pL3@5E s3lEc+ a DIpHPH3R3NT +YPe.";
$lang['successfullyaddedforumtofavourites'] = "sucC3sSPhULlY 4DdED f0rUM +O f4VOUr1+3\$.";
$lang['successfullyremovedforumfromfavourites'] = "sUcC3\$5FuLLy R3MOv3d PH0Rum PHroM FAvoUR1TE\$.";
$lang['successfullyignoredforum'] = "sUCCe\$SPhULly I9N0reD PhORUm.";
$lang['successfullyunignoredforum'] = "sUCC3\$SPHUllY UNI9NOR3D pH0RUM.";
$lang['failedtoupdateforuminterestlevel'] = "f4il3D T0 uPd4+3 Ph0rUm 1NT3RE\$t l3V3l";
$lang['noforumsavailablelogin'] = "th3RE ar3 N0 F0RUms 4V@iL@8L3. pL3@SE l0G1N +o V13W YOUr forUMs.";
$lang['passwdprotectedforum'] = "p4\$SWOrd PrO+EC+ED pHOrUM";
$lang['passwdprotectedwarning'] = "tHIS fORUM 1s P4SSW0rD PRO+3C+3d. +O 9AIN 4CC35S ENT3R +EH P4ssW0rD 8ELOW.";

// Message composition (post.php, lpost.php) --------------------------------------

$lang['postmessage'] = "pO\$+ mE\$S49E";
$lang['selectfolder'] = "sELECT PH0LDER";
$lang['mustenterpostcontent'] = "j00 Mu5+ 3N+3R sOMe Conten+ F0r +hE poST!";
$lang['messagepreview'] = "mEssaG3 PR3v1EW";
$lang['invalidusername'] = "iNv4l1D US3RnaM3!";
$lang['mustenterthreadtitle'] = "j00 mUST 3NTER 4 T1+l3 PhoR ThE +HReAD!";
$lang['pleaseselectfolder'] = "pL34\$3 \$3L3Ct @ PH0LD3r!";
$lang['errorcreatingpost'] = "eRroR CR3@+1NG p0\$t! Pl345E +rY aGAIn IN 4 pHEw MInuT3\$.";
$lang['createnewthread'] = "cR3A+3 NeW tHR3@d";
$lang['postreply'] = "pO\$T rEPlY";
$lang['threadtitle'] = "thrEAD +1+l3";
$lang['messagehasbeendeleted'] = "me\$5493 NoT pH0UNd. ChECk +h@T 1+ H4SN'+ b3EN DelE+3d.";
$lang['messagenotfoundinselectedfolder'] = "m3ssAGE nOT Ph0UND 1n S3L3C+3D FOld3r. CH3Ck +h@T I+ HA\$N't B3EN m0VED 0r dELE+3d.";
$lang['cannotpostthisthreadtypeinfolder'] = "j00 C4NNO+ P0sT tHIS +HR34d tYP3 iN +h4+ F0lDeR!";
$lang['cannotpostthisthreadtype'] = "j00 C4NNO+ P0s+ +H1\$ +HrE@D typ3 4s Th3re 4R3 N0 @V4ILAbLE F0lDERs THaT 4LL0W I+.";
$lang['cannotcreatenewthreads'] = "j00 C4nN0+ cR34TE neW +HR3@d\$.";
$lang['threadisclosedforposting'] = "th1s +hR34D i\$ Clo\$3d, j00 c@NnO+ poSt 1N 1t!";
$lang['moderatorthreadclosed'] = "w4rN1NG: +h1\$ +hR3@D 1s cl0\$3D f0R POStING +O norM4L us3R\$.";
$lang['usersinthread'] = "u\$erS IN +HR3AD";
$lang['correctedcode'] = "c0rREC+3d CODe";
$lang['submittedcode'] = "su8mIttED COD3";
$lang['htmlinmessage'] = "hTmL iN mESS@93";
$lang['disableemoticonsinmessage'] = "dI\$@8LE 3MOT1cONS 1N MESS@GE";
$lang['automaticallyparseurls'] = "aUt0M@tIC4LlY P4RS3 UrL\$";
$lang['automaticallycheckspelling'] = "aUtoM4Tic@LLY Ch3ck SPelL1NG";
$lang['setthreadtohighinterest'] = "sET tHR34D t0 HiGh IN+eResT";
$lang['enabledwithautolinebreaks'] = "en4BLEd WI+h @uTO-l1n3-BR34K\$";
$lang['fixhtmlexplanation'] = "tHi\$ phOruM U\$3S H+ML F1LT3rIN9. y0uR sU8M1++3D hTML h@\$ BE3n m0DIF13D By TEh FiL+3R\$ 1N soME W4Y.\\n\\n+0 ViEW Y0Ur 0RIgIN@l C0DE, S3LEcT +3H \\'SUBm1t+3D CoD3\\' raD10 BUT+0N.\\nTO vIEw +hE m0DIF1Ed COde, seL3CT THe \\'c0rr3C+3d coD3\\' R@d1O Bu+Ton.";
$lang['messageoptions'] = "m3\$\$493 OPtI0N\$";
$lang['notallowedembedattachmentpost'] = "j00 @re nO+ 4Ll0WED +O 3Mb3d a+T@CHM3nts 1N y0uR PO\$+5.";
$lang['notallowedembedattachmentsignature'] = "j00 4R3 N0+ 4Ll0w3D To 3m8ED 4Tt4cHmenTS 1n yoUR SIGNa+UrE.";
$lang['reducemessagelength'] = "m3\$S49E L3nG+h MUS+ B3 UnD3R 65,535 cH@R4c+3R\$ (curReN+ly: %s)";
$lang['reducesiglength'] = "s1GNA+URE LEnG+H mUST 83 UNdER 65,535 CH4R4cT3R\$ (cURR3N+LY: %s)";
$lang['cannotcreatethreadinfolder'] = "j00 C4NN0+ cR3A+3 NeW +HRE4D\$ 1n thiS PH0ld3R";
$lang['cannotcreatepostinfolder'] = "j00 C4NNot R3Ply t0 pO\$tS 1n th1\$ FOlD3R";
$lang['cannotattachfilesinfolder'] = "j00 C4NNoT p0sT 4+T4Chm3NTS 1n THi\$ foLD3R. R3M0V3 4t+AChM3N+S +o C0N+1nUE.";
$lang['postfrequencytoogreat'] = "j00 C@n 0NLy p0ST onc3 EvERy %s s3c0NDS. PLE4s3 TrY 4941N l4TeR.";
$lang['emailconfirmationrequiredbeforepost'] = "em@1L C0NPhiRMA+10n is R3QU1R3D 83FOrE J00 C@n po\$+. IpH J00 H4V3 n0T r3cE1V3D A cONF1RM@tI0N EM@IL Ple4\$3 Cl1cK +h3 8U++ON b3lOW @ND @ n3w ON3 WiLL 8E \$3Nt TO You. 1F Y0UR 3M41L @DDr3sS N33DS chan91n9 PL3AS3 do 50 83fOR3 ReqUe\$tIN9 4 N3w CONpHIRm4tIon 3MA1L. J00 M4Y cHAN93 youR 3M41L 4Ddr35s BY CL1Ck MY coN+r0ls 4BOvE And thEN us3R D3T4ILS";
$lang['emailconfirmationfailedtosend'] = "cONFIRm4+1On 3M4IL Ph4Il3D T0 s3Nd. pl34s3 COn+@ct t3h foRUM owNEr +O r3C+iPHy +Hi\$.";
$lang['emailconfirmationsent'] = "conPH1Rm4+I0N EM41L h45 8e3N reS3nt.";
$lang['resendconfirmation'] = "res3Nd C0NFiRM4T10N";
$lang['userapprovalrequiredbeforeaccess'] = "y0ur US3R 4cC0uNT n33dS +0 8E @pPR0V3D 8Y @ F0RUm @DmiN b3ph0R3 j00 c@N acC355 T3H R3ques+3D F0Rum.";
$lang['reviewthread'] = "reVI3W tHR34D";
$lang['reviewthreadinnewwindow'] = "r3VIEw eN+1RE +HR3@D 1N N3W W1NDOW";

// Message display (messages.php & messages.inc.php) --------------------------------------

$lang['inreplyto'] = "in R3pLy +O";
$lang['showmessages'] = "sH0w m3S\$@ges";
$lang['ratemyinterest'] = "r4+e my IN+ER3\$+";
$lang['adjtextsize'] = "aDju\$T TExt S1Z3";
$lang['smaller'] = "sm@Ll3R";
$lang['larger'] = "l@r9eR";
$lang['faq'] = "f4Q";
$lang['docs'] = "d0c5";
$lang['support'] = "suPP0r+";
$lang['donateexcmark'] = "d0n@+3!";
$lang['fontsizechanged'] = "f0N+ Siz3 cH@ng3D. %s";
$lang['framesmustbereloaded'] = "fR4m3S MU\$t 8E R3l04deD m4Nu4Lly t0 5eE Ch4ng3s.";
$lang['threadcouldnotbefound'] = "th3 rEQuesT3d ThR34D cOUld nO+ 83 Ph0und Or @cceS\$ W4s DEn13D.";
$lang['mustselectpolloption'] = "j00 muST s3L3C+ 4N opt10N +o VoT3 PhoR!";
$lang['mustvoteforallgroups'] = "j00 MU5+ vO+3 In evEry 9RouP.";
$lang['keepreading'] = "k3ep REaD1NG";
$lang['backtothreadlist'] = "b@cK to thRE4D l1s+";
$lang['postdoesnotexist'] = "that p0\$T doE\$ N0+ 3x1sT In +H1\$ +hR3@d!";
$lang['clicktochangevote'] = "cL1CK to cH4Nge vo+e";
$lang['youvotedforoption'] = "j00 vo+3D foR 0P+iON";
$lang['youvotedforoptions'] = "j00 v0TEd Ph0r op+10N\$";
$lang['clicktovote'] = "cLiCK to v0tE";
$lang['youhavenotvoted'] = "j00 H4VE NOT V0TEd";
$lang['viewresults'] = "vIEW reSUl+S";
$lang['msgtruncated'] = "m3SS493 TRunC@TEd";
$lang['viewfullmsg'] = "vIeW FuLL MESSaG3";
$lang['ignoredmsg'] = "ign0R3d m3s\$@93";
$lang['wormeduser'] = "w0rmED U\$3R";
$lang['ignoredsig'] = "i9nOR3D S19NA+uRE";
$lang['messagewasdeleted'] = "meS\$4GE %s.%s W@\$ DeL3T3D";
$lang['stopignoringthisuser'] = "s+oP IGN0RIn9 TH15 U\$3R";
$lang['renamethread'] = "r3N4ME tHr34D";
$lang['movethread'] = "m0vE +hR3Ad";
$lang['torenamethisthreadyoumusteditthepoll'] = "t0 ren@ME +H1S ThR3AD j00 MusT 3D1T +3H pOLl.";
$lang['closeforposting'] = "cl0S3 foR P0\$+1N9";
$lang['until'] = "un+1L 00:00 utC";
$lang['approvalrequired'] = "aPpR0V@l ReQU1REd";
$lang['messageawaitingapprovalbymoderator'] = "me5S@93 %s.%s I\$ 4W41+1N9 4Ppr0v4L 8y @ MOD3R@+0r";
$lang['successfullyapprovedpost'] = "sUcC3s\$PHULly 4PpR0V3D p0s+ %s";
$lang['postapprovalfailed'] = "p0sT 4pPROV4L fa1LED.";
$lang['postdoesnotrequireapproval'] = "p0ST dOES n0+ r3QUiR3 4PPrOVAl";
$lang['approvepost'] = "aPPR0V3 Po\$T";
$lang['approvedbyuser'] = "aPpR0vED: %s bY %s";
$lang['makesticky'] = "m4K3 st1cKy";
$lang['messagecountdisplay'] = "%s OF %s";
$lang['linktothread'] = "perM4NEN+ L1Nk +O +H1\$ +hR34D";
$lang['linktopost'] = "link +O p0s+";
$lang['linktothispost'] = "l1NK +O +Hi\$ POSt";
$lang['imageresized'] = "this iMAg3 H4S B3en R3\$iZEd (ORiGInAl sIZe %1\$5X%2\$s). +O viEw +3H FulL-\$1Z3 1MAg3 Cl1Ck H3RE.";
$lang['messagedeletedbyuser'] = "mEssag3 %s.%s d3lEteD %s 8Y %s";
$lang['messagedeleted'] = "m3s\$4GE %s.%s W4S deleT3D";
$lang['viewinframeset'] = "vi3w 1N pHr4MES3+";
$lang['pressctrlentertoquicklysubmityourpost'] = "pR3sS CTrl+en+3R +o QU1CkLY 5uBmIT Y0ur p0\$t";

// Moderators list (mods_list.php) -------------------------------------

$lang['cantdisplaymods'] = "c4nnOT DI\$pL4Y FOLd3R m0DER4t0rS";
$lang['moderatorlist'] = "m0deR@t0R lisT:";
$lang['modsforfolder'] = "m0dER@+0R5 F0R PHOLder";
$lang['nomodsfound'] = "n0 moDEr4t0RS foUnD";
$lang['forumleaders'] = "forUM LE4DEr5:";
$lang['foldermods'] = "f0lD3R m0DEr4+OR\$:";

// Navigation strip (nav.php) ------------------------------------------

$lang['start'] = "s+4rT";
$lang['messages'] = "m3\$54G3S";
$lang['pminbox'] = "iNb0x";
$lang['startwiththreadlist'] = "s+4RT p4Ge W1TH +HrE4D l15+";
$lang['pmsentitems'] = "s3N+ 1+3Ms";
$lang['pmoutbox'] = "oU+bOX";
$lang['pmsaveditems'] = "s@VEd I+3mS";
$lang['pmdrafts'] = "dRaPH+s";
$lang['links'] = "l1nKS";
$lang['admin'] = "aDm1N";
$lang['login'] = "l0GIN";
$lang['logout'] = "lo90u+";

// PM System (pm.php, pm_write.php, pm.inc.php) ------------------------

$lang['privatemessages'] = "priv4T3 mess@GE5";
$lang['recipienttiptext'] = "sep@R4+3 recIPiEn+S 8y SEMi-C0L0N 0R C0Mm@";
$lang['maximumtenrecipientspermessage'] = "tH3r3 iS 4 l1Mit 0Ph 10 rECiPIEn+S PER MESS@9e. pL34S3 4M3nd Y0ur R3CiPiEN+ lIsT.";
$lang['mustspecifyrecipient'] = "j00 mUST sp3C1pHy 4+ LeaS+ ONe R3C1P13NT.";
$lang['usernotfound'] = "u5ER %s N0+ Ph0uNd";
$lang['sendnewpm'] = "s3nD N3W pM";
$lang['savemessage'] = "s@vE ME\$s@GE";
$lang['nosubject'] = "nO SU8JecT";
$lang['norecipients'] = "n0 REc1PI3N+s";
$lang['timesent'] = "t1mE sENt";
$lang['notsent'] = "noT S3NT";
$lang['errorcreatingpm'] = "err0R Cr3aT1Ng pM! pL3@SE +Ry @gAIn 1N 4 PHEw m1NU+3S";
$lang['writepm'] = "wriT3 MesSaG3";
$lang['editpm'] = "eDi+ m3s\$@Ge";
$lang['cannoteditpm'] = "c@nN0T 3DI+ +H1\$ PM. I+ h4\$ Alr34dY 833N v1eW3D bY tEH r3c1PI3N+ 0R +3H m3sS4G3 d03\$ NoT 3xISt 0R 1+ IS IN@ccESSiBLe BY J00";
$lang['cannotviewpm'] = "c@NN0T vIEw Pm. mesS4GE D0ES nOT 3xIsT 0R 1+ I\$ 1n4CC3SS1Bl3 8Y j00";
$lang['pmmessagenumber'] = "m3S\$493 %s";

$lang['youhavexnewpm'] = "j00 H4V3 %d n3W m3s5493\$. w0UlD J00 L1K3 TO 9o +o YOUR 1N8OX N0W?";
$lang['youhave1newpm'] = "j00 H@vE 1 n3W M35S4G3. wouLD J00 lIkE TO G0 TO Y0uR Inb0x N0W?";
$lang['youhave1newpmand1waiting'] = "j00 H4V3 1 n3w m3s\$4gE.\n\nYOU 4LSO h4vE 1 M3SS4GE 4w41+1N9 DELIv3RY. +0 REceIV3 +hiS M35S493 PlE@\$e CL3@r S0ME Sp4C3 In Y0UR iN80x.\n\nW0ULD j00 l1kE +0 G0 t0 YOUr 1NB0X N0W?";
$lang['youhave1pmwaiting'] = "j00 H4ve 1 M3\$s@Ge 4WAitiNg DeL1VErY. To REcE1VE ThiS meSS@ge Pl3@SE CL34R sOME sP4C3 1n YOUr 1Nb0x.\n\nwOULd J00 Lik3 +0 9O to youR 1NbOX n0W?";
$lang['youhavexnewpmand1waiting'] = "j00 h4VE %d n3W MESSa9eS.\n\ny0u AL\$O h4v3 1 m3\$s@Ge 4W@I+inG D3LiV3RY. +O r3C31VE +h1\$ m3\$S@Ge PlEAsE CLeAR SOMe Sp4cE iN y0uR iN80X.\n\nw0ULd J00 L1KE +0 90 T0 Y0UR 1N8OX NoW?";
$lang['youhavexnewpmandxwaiting'] = "j00 H4VE %d nEW m3ssA9ES.\n\nYOu @L5O haV3 %d me\$SAG3S 4WA1+iNG DEl1v3RY. +o ReCE1Ve +H3SE M3SS4GE pLE4S3 cL3AR SOM3 \$P4C3 in YoUR 1Nb0x.\n\nW0ULd J00 L1Ke T0 90 +o YOUR 1Nb0x noW?";
$lang['youhave1newpmandxwaiting'] = "j00 H4V3 1 n3w m3sS4G3.\n\ny0u 4LS0 H4v3 %d MEssaGes 4W4It1Ng D3LivErY. +0 R3ceIVE +h3S3 m3ss@93\$ PLe@S3 CL34R 50ME SP4C3 IN YOUR iNB0X.\n\nw0uLD j00 L1KE +0 GO +0 Y0UR InB0x N0W?";
$lang['youhavexpmwaiting'] = "j00 H4VE %d me\$S@93S 4W@i+IN9 deLIv3rY. +o r3c3iV3 +H3s3 m3ss@ge\$ PLEas3 cleAR SomE sP@c3 1N yoUR InB0X.\n\nW0UlD J00 L1K3 +o 90 TO Y0UR iN80x NOw?";

$lang['youdonothaveenoughfreespace'] = "j00 Do NOT H@VE ENOU9H PhREE \$P4C3 +O s3ND +hI\$ MEssaGE.";
$lang['userhasoptedoutofpm'] = "%s h4s 0PTeD 0UT Of R3Ce1vIN9 PeRS0NAl MeSSaG3\$";
$lang['pmfolderpruningisenabled'] = "pM FOLDeR PrUN1NG iS EN@8l3D!";
$lang['pmpruneexplanation'] = "this PhoRuM US3S pM f0LDER pRuNIn9. the MesS493s J00 h4v3 \$TOr3d 1N yOUR 1nB0x 4ND \$3Nt 1TEMs\\nPHOlDERS ar3 SUbjEC+ TO @U+0m4TIC D3lET1ON. ANy M3\$s@Ge5 J00 W1\$h +O kE3p Sh0Uld Be M0V3D +0\\nYOur \\'\$@VEd I+3MS\\' f0lDEr SO tHA+ +H3Y 4R3 N0T DELE+3D.";
$lang['yourpmfoldersare'] = "y0ur pM phOldER\$ @Re %s pHULl";
$lang['currentmessage'] = "cURRen+ M3sS4GE";
$lang['unreadmessage'] = "uNrE4D me\$S@ge";
$lang['readmessage'] = "re4d m3\$S@ge";
$lang['pmshavebeendisabled'] = "p3rsON@l m3ss@93S haV3 8EEn DIsabl3d 8y tH3 PhoRum OwN3R.";
$lang['adduserstofriendslist'] = "add US3rs TO YOUr FriENdS Li\$T +o H@vE tH3M @PPeAR 1n @ DR0P dOWN oN +hE PM wrIt3 M3\$SAgE P@Ge.";

$lang['messagewassuccessfullysavedtodraftsfolder'] = "m3SS@GE W4\$ SUCC3SsFUllY S@VED +o 'dRafT\$' foLD3R";
$lang['couldnotsavemessage'] = "cOULD n0t S4Ve mE\$S@Ge. MAk3 sURE j00 HAv3 3N0U9H @v41L@8l3 fREe SP4Ce.";
$lang['pmtooltipxmessages'] = "%s mEsS49ES";
$lang['pmtooltip1message'] = "1 mEsS49E";

$lang['allowusertosendpm'] = "allOW Us3r T0 SEnd pEr50N4L MesS4G3\$ T0 ME";
$lang['blockuserfromsendingpm'] = "bl0CK U\$3r FRom \$eNd1nG PEr\$0n@l M3SS@g3s to ME";
$lang['yourfoldernamefolderisempty'] = "y0ur %s PHOLdER 1\$ 3mp+Y";
$lang['successfullydeletedselectedmessages'] = "sUCC3sSFULlY d3lE+3D s3l3C+3D m3\$S@gE\$";
$lang['successfullyarchivedselectedmessages'] = "sUCC3\$SFUllY @Rch1VEd \$3LEc+eD m3\$S@G3S";
$lang['failedtodeleteselectedmessages'] = "f@1lED to d3LEt3 \$EL3CT3d MESSAgES";
$lang['failedtoarchiveselectedmessages'] = "f4ILeD +0 4RCh1vE \$EL3CTeD m3SSA9es";

// Preferences / Profile (user_*.php) ---------------------------------------------

$lang['mycontrols'] = "mY CONtROLS";
$lang['myforums'] = "mY FORUMS";
$lang['menu'] = "m3NU";
$lang['userexp_1'] = "usE T3H mENU 0n ThE LePH+ T0 M4N493 Y0UR \$3tT1N9S.";
$lang['userexp_2'] = "<b>usER dETA1L5</b> 4lLOWS j00 t0 cH4N93 Y0Ur N@mE, 3m@iL aDDR3\$5 4ND pa\$SWORd.";
$lang['userexp_3'] = "<b>u53r PRof1L3</b> 4lLOws j00 +0 ED1t Your U\$ER pROF1LE.";
$lang['userexp_4'] = "<b>cHANG3 p4ssWOrD</b> ALlOWS j00 tO cH4N93 Y0UR P@SSw0rD";
$lang['userexp_5'] = "<b>eM4iL &amp; pr1v4CY</b> l3T\$ J00 Ch4N9E HoW j00 C4N 8e coN+@C+3D 0N 4nd 0pHf Th3 PhoRUM.";
$lang['userexp_6'] = "<b>f0rUM OPti0nS</b> LE+\$ J00 CH4n93 H0W +H3 F0RUm L00KS 4nD W0Rks.";
$lang['userexp_7'] = "<b>a+T@chMENt\$</b> 4lL0WS j00 +O 3D1T/deLeTe YOUR a+T4CHM3NTS.";
$lang['userexp_8'] = "<b>sign@TUR3</b> LET\$ J00 ED1+ YOUR S19N@+URE.";
$lang['userexp_9'] = "<b>r3l4tION\$h1P\$</b> lET5 J00 M@N493 y0uR r3L4Tion\$hIP w1TH 0+HeR UseRS on +h3 PhoRUm.";
$lang['userexp_9'] = "<b>wOrD pH1L+3R</b> L3TS J00 3D1T y0UR p3RS0N4L w0RD pHIl+3R.";
$lang['userexp_10'] = "<b>tHrE@d suB\$cr1P+1Ons</b> @Ll0WS j00 TO MAnA9E yoUR +Hr3AD \$U8\$crIPt10Ns.";
$lang['userdetails'] = "u53r De+A1LS";
$lang['userprofile'] = "uS3R PRof1l3";
$lang['emailandprivacy'] = "eM4iL &amp; PR1V4CY";
$lang['editsignature'] = "eD1t \$i9n4TUR3";
$lang['norelationshipssetup'] = "j00 h@V3 No US3R reL4+10N\$hIPS S3T up. 4DD 4 N3W u\$Er 8Y S34RCH1N9 8ELOW.";
$lang['editwordfilter'] = "eD1T word F1LT3R";
$lang['userinformation'] = "u\$er 1NFORMa+10N";
$lang['changepassword'] = "ch4n9E P45SwORD";
$lang['currentpasswd'] = "cUrR3N+ P4ssW0RD";
$lang['newpasswd'] = "n3W p4s5W0RD";
$lang['confirmpasswd'] = "coNf1rm pA\$swoRd";
$lang['passwdsdonotmatch'] = "p@s5wORdS DO no+ m4+CH!";
$lang['nicknamerequired'] = "nIckN@ME i\$ R3QUIr3D!";
$lang['emailaddressrequired'] = "eMaIL 4DDrESS 1\$ ReQUIr3D!";
$lang['logonnotpermitted'] = "l0g0n no+ PErm1++3D. Cho0\$3 4NOth3R!";
$lang['nicknamenotpermitted'] = "nIcKNam3 NO+ P3RmIT+3D. cHO0\$3 4nO+H3r!";
$lang['emailaddressnotpermitted'] = "em@iL 4DDR3sS N0t p3rmI++ED. CHO0s3 ANOTHEr!";
$lang['emailaddressalreadyinuse'] = "em41l @DdR3SS aLREaDY 1N u\$3. cHO0\$3 4NOtHER!";
$lang['relationshipsupdated'] = "rel@+1On\$HIP\$ UPd4TEd!";
$lang['relationshipupdatefailed'] = "rEl@tIONSHIp UPD@+3D fA1LeD!";
$lang['preferencesupdated'] = "pr3fER3Nce\$ W3r3 SUcC3SSPhULlY UPd4t3D.";
$lang['userdetails'] = "uS3r de+A1LS";
$lang['memberno'] = "m3M8ER N0.";
$lang['firstname'] = "f1r\$+ naM3";
$lang['lastname'] = "lAsT N@ME";
$lang['dateofbirth'] = "d@t3 0F biR+h";
$lang['homepageURL'] = "hOm3paG3 URl";
$lang['profilepicturedimensions'] = "pr0pH1l3 pICtUR3 (m4x 95x95PX)";
$lang['avatarpicturedimensions'] = "av4+AR P1CTUr3 (Max 15x15PX)";
$lang['invalidattachmentid'] = "invALid 4T+4chmeNT. CH3ck +H4+ 1s H@SN'+ bEEn D3LeteD.";
$lang['unsupportedimagetype'] = "un5upPORt3D iM493 @+T@cHmENt. j00 C4N ONLy USe Jpg, G1F 4ND PN9 1MaG3 4TtACHMeN+s foR y0uR @V4+4R 4nd PRoFIlE piCTuRE.";
$lang['selectattachment'] = "s3L3CT @Tt4CHm3nT";
$lang['pictureURL'] = "p1ctUR3 UrL";
$lang['avatarURL'] = "ava+AR uRL";
$lang['profilepictureconflict'] = "t0 u\$e 4N 4TT4CHm3nT PhoR YOur prOFiLE picTur3 +3H PIctUR3 UrL PH13LD mU\$T 83 BL4NK.";
$lang['avatarpictureconflict'] = "t0 U\$3 aN @T+4CHM3Nt PhoR Y0uR 4v@TaR pIC+urE tHE 4v@t4r URL F1eLd Mu\$+ 83 8L@Nk.";
$lang['attachmenttoolargeforprofilepicture'] = "sEl3C+3D A+t@CHMEN+ 1S To0 L4R9e pH0R ProF1L3 PiCTUrE. M4xImuM dIM3N\$1ONs @R3 %s";
$lang['attachmenttoolargeforavatarpicture'] = "s3l3C+3D @+t@ChM3Nt I5 +00 l4RG3 F0R 4VA+@r PIcTUR3. MAX1MUm Dim3NS1oNS @R3 %s";
$lang['failedtoupdateuserdetails'] = "s0m3 0R 4Ll 0PH yOUR USEr @cc0UN+ D3+@iLS C0ULd NOT 83 uPd@teD. Pl34s3 TrY 49@1N l@TeR.";
$lang['failedtoupdateuserpreferences'] = "soME 0R @LL oPh Y0Ur US3R pR3F3R3NC3\$ c0UlD N0T BE upd4teD. plea\$3 +ry AgA1N L@t3r.";
$lang['emailaddresschanged'] = "em41L aDDr3ss HA\$ B3EN CH4N9ED";
$lang['newconfirmationemailsuccess'] = "y0uR eM41L 4DDr3SS h@S B3EN CH4N9ED AND @ N3W CONphIrM@tION 3m@iL hAs 83EN \$3nT. Ple4sE cHEck 4Nd R3AD +3H 3MaiL pH0R fUr+H3R IN5+rUCtI0N5.";
$lang['newconfirmationemailfailure'] = "j00 Hav3 CHAN9Ed y0UR EmaIl 4DDR3Ss, BU+ W3 W3Re UNaBLe TO \$3Nd @ C0NFIRm4+10n rEQueST. PlE453 C0NT4C+ +h3 Ph0RUM 0WN3R f0r @Ssi\$+4nC3.";
$lang['forumoptions'] = "forUM Op+IOns";
$lang['notifybyemail'] = "nOt1fY bY 3M@1L opH po\$T5 t0 ME";
$lang['notifyofnewpm'] = "notIPHy 8Y P0pUp OF n3w PM Me\$5493\$ to Me";
$lang['notifyofnewpmemail'] = "n0+IPhy 8Y Em4iL Of NeW pm M3SS@g3s T0 M3";
$lang['daylightsaving'] = "aDJus+ FOr D4YlIGhT S4Vin9";
$lang['autohighinterest'] = "aUTOM4TIc@LlY M4Rk THrE4D\$ i PO\$T 1N 4S h1gh In+3RES+";
$lang['convertimagestolinks'] = "autOM4TiC@llY c0nVeR+ emBeDD3D 1MaG3s iN p0\$TS 1n+0 LINkS";
$lang['thumbnailsforimageattachments'] = "thuM8N41L\$ for 1MAg3 4T+4CHmEN+s";
$lang['smallsized'] = "sm4LL 5IzeD";
$lang['mediumsized'] = "mEDIUM sIZ3D";
$lang['largesized'] = "l@rG3 \$iZ3D";
$lang['globallyignoresigs'] = "gLo84LLy IgNOR3 U5ER \$1GN@tURES";
$lang['allowpersonalmessages'] = "aLl0W Oth3R Us3r\$ +o SenD Me pERSOn4l M3SS4G3\$";
$lang['allowemails'] = "aLlow O+h3R Us3rS +o S3ND ME EMa1LS v1A My Pr0ph1L3";
$lang['timezonefromGMT'] = "timE Z0N3";
$lang['postsperpage'] = "p05+5 P3R p4gE";
$lang['fontsize'] = "fon+ \$1ZE";
$lang['forumstyle'] = "f0rum STYlE";
$lang['forumemoticons'] = "foruM eM0TIc0nS";
$lang['startpage'] = "s+4RT P@93";
$lang['signaturecontainshtmlcode'] = "siGN4+Ure cONT@INS H+ml COdE";
$lang['savesignatureforuseonallforums'] = "s@VE 5iGn@+Ur3 PhOR usE 0N 4LL Ph0rUMs";
$lang['preferredlang'] = "prEPH3RREd lAn9uaGE";
$lang['donotshowmyageordobtoothers'] = "dO N0t \$hOW mY AGE 0r d4tE 0PH 81R+H +O othEr5";
$lang['showonlymyagetoothers'] = "show ONly My 4G3 T0 o+H3R\$";
$lang['showmyageanddobtoothers'] = "sHOW 80tH mY 49E @nD d4t3 OF 81r+H to OtHErs";
$lang['showonlymydayandmonthofbirthytoothers'] = "sH0w ONLy mY DaY @ND M0N+h 0F b1rTh TO 0+h3R\$";
$lang['listmeontheactiveusersdisplay'] = "l1S+ Me 0N Teh 4C+1V3 u\$3RS d1\$PL4y";
$lang['browseanonymously'] = "bROWs3 PH0RUM 4N0NYm0usLY";
$lang['allowfriendstoseemeasonline'] = "br0WSE AN0Nym0USLy, bU+ ALLOW pHrI3NDS TO 5EE M3 4S 0NlIN3";
$lang['revealspoileronmouseover'] = "rEV3@L sP0ILERS 0N m0uS3 0V3R";
$lang['showspoilersinlightmode'] = "alw4Y\$ \$HOW sP0ILeR\$ 1n L1GHt MODe (Us3\$ L19HTeR FOn+ CoL0UR)";
$lang['resizeimagesandreflowpage'] = "re\$1Z3 1M@gE\$ 4ND rEPhL0W p49e t0 PreV3nT hoR1Z0ntaL SCR0Ll1N9.";
$lang['showforumstats'] = "sH0W f0rUm \$T@ts @T 8o+toM OF M3s\$@GE P4n3";
$lang['usewordfilter'] = "enaBl3 w0RD PHiLTeR.";
$lang['forceadminwordfilter'] = "f0rcE USe OPh 4dM1n W0RD PH1ltER ON 4lL u\$3RS (INc. 9U35+S)";
$lang['timezone'] = "t1ME ZOne";
$lang['language'] = "l@N9u4G3";
$lang['emailsettings'] = "emA1L @ND coN+@CT s3+TiN9\$";
$lang['forumanonymity'] = "f0RUM 4n0NYM1+Y SE+tINgs";
$lang['birthdayanddateofbirth'] = "b1RThD4Y 4ND d4+3 OF b1R+H DISpl4Y";
$lang['includeadminfilter'] = "iNcLUDE @DM1N W0RD PH1L+3R iN My LIst.";
$lang['setforallforums'] = "se+ FOR @Ll F0RUm\$?";
$lang['containsinvalidchars'] = "%s CON+4iNS INv@L1D Ch4RActER\$!";
$lang['homepageurlmustincludeschema'] = "h0m3PAg3 URl MUSt 1NClUD3 Ht+P:// sch3M@.";
$lang['pictureurlmustincludeschema'] = "p1ctUR3 URl Mu5+ InCLUdE htTP:// sCheM4.";
$lang['avatarurlmustincludeschema'] = "aV4T@R URL Mu5+ 1NCLud3 H+tP:// SCh3m@.";
$lang['postpage'] = "pO5+ p493";
$lang['nohtmltoolbar'] = "n0 HTmL T0OL8@R";
$lang['displaysimpletoolbar'] = "di\$pL4Y 51Mpl3 HTml t00L8@R";
$lang['displaytinymcetoolbar'] = "dI\$PL4Y WY\$1Wyg h+Ml +O0LB4R";
$lang['displayemoticonspanel'] = "diSpl@y eMOTiC0NS p4N3L";
$lang['displaysignature'] = "d1\$PL4Y s19NATur3";
$lang['disableemoticonsinpostsbydefault'] = "d1\$4BLE 3MOtICon\$ 1N M3\$s@GE\$ BY D3pH@ULT";
$lang['automaticallyparseurlsbydefault'] = "autOM4T1C4Lly pAR\$3 uRLS IN m3\$SA9ES bY d3PH4UL+";
$lang['postinplaintextbydefault'] = "pOst 1N pL41N +3xT 8Y dEpH4UL+";
$lang['postinhtmlwithautolinebreaksbydefault'] = "po\$+ 1N H+Ml WiTH 4U+O-l1NE-BRE4K\$ By D3Fault";
$lang['postinhtmlbydefault'] = "pO\$T 1N hTmL 8Y d3F4UL+";
$lang['postdefaultquick'] = "u\$e qU1CK r3pLy 8Y d3pH@UlT. (FulL REpLy In M3NU)";
$lang['privatemessageoptions'] = "pR1V4+E m3sS@Ge 0pTi0NS";
$lang['privatemessageexportoptions'] = "priv4TE meSS@93 EXPOR+ 0P+I0ns";
$lang['savepminsentitems'] = "s4vE a C0PY 0F E4CH PM 1 S3ND 1n MY S3N+ I+3MS f0lDer";
$lang['includepminreply'] = "iNCLUd3 mESS493 8ODY wHEN REplY1nG TO PM";
$lang['autoprunemypmfoldersevery'] = "au+o PrUNe MY pM PhOLd3rS eVEry:";
$lang['friendsonly'] = "fri3NDS oNLY?";
$lang['globalstyles'] = "gloB@L styleS";
$lang['forumstyles'] = "f0rUM s+yLE\$";
$lang['youmustenteryourcurrentpasswd'] = "j00 Mu\$T 3nTer Y0UR CURREn+ Pa\$\$W0RD";
$lang['youmustenteranewpasswd'] = "j00 MUSt 3NT3R @ N3W p4sSWOrd";
$lang['youmustconfirmyournewpasswd'] = "j00 MU\$t CoNf1rM Y0UR nEW p4ssWOrd";
$lang['profileentriesmustnotincludehtml'] = "pROphilE EnTRies mUST N0+ 1ncLUD3 H+mL";
$lang['failedtoupdateuserprofile'] = "f41l3d To UPDaT3 U\$3R pROF1L3";

// Polls (create_poll.php, poll_results.php) ---------------------------------------------

$lang['mustprovideanswergroups'] = "j00 MU\$t Pr0vId3 sOM3 4nsWER 9r0uP\$";
$lang['mustprovidepolltype'] = "j00 mU\$t PROV1D3 4 P0Ll TyPE";
$lang['mustprovidepollresultsdisplaytype'] = "j00 MUST pROViDE ResUL+s DI\$pL4Y +YPE";
$lang['mustprovidepollvotetype'] = "j00 mUS+ PRov1DE 4 pOlL vo+3 TYpE";
$lang['mustprovidepollguestvotetype'] = "j00 MUST \$p3cIfy IF gUESTS shOULD 83 4lL0Wed t0 VO+e";
$lang['mustprovidepolloptiontype'] = "j00 MuSt pROV1DE 4 PoLL 0p+I0N +YpE";
$lang['mustprovidepollchangevotetype'] = "j00 mu5+ pRov1DE 4 P0Ll CH4N93 vo+3 TYpE";
$lang['pollquestioncontainsinvalidhtml'] = "on3 OR m0rE OPh Y0UR POlL qu3sTIons c0n+A1NS 1nV@l1d HTmL.";
$lang['pleaseselectfolder'] = "pLe4s3 S3lEc+ 4 Ph0lDEr";
$lang['mustspecifyvalues1and2'] = "j00 MU5+ SPEciPhY v4LU3S for 4N\$weRS 1 4ND 2";
$lang['tablepollmusthave2groups'] = "t4buL4R pHORM4+ p0lLs Mu\$T H4V3 pREc1\$Ely +wO V0+iN9 9R0UPS";
$lang['nomultivotetabulars'] = "t@8UL4R pH0RM4+ poLls C@nnOT 8E mULtI-v0tE";
$lang['nomultivotepublic'] = "pu8LIc B4LL0T\$ C4NNot 83 Mul+1-V0te";
$lang['abletochangevote'] = "j00 W1LL b3 48LE +O Ch@N9E yOUr v0t3.";
$lang['abletovotemultiple'] = "j00 W1LL B3 @8l3 T0 vo+E MULtIpl3 +1M3\$.";
$lang['notabletochangevote'] = "j00 wIlL no+ b3 AblE to CHan9e yoUR V0T3.";
$lang['pollvotesrandom'] = "nO+e: P0LL VO+3S @R3 R4nD0mlY g3nERAt3d Ph0r Pr3v1EW onLy.";
$lang['pollquestion'] = "p0LL qu3sTi0n";
$lang['possibleanswers'] = "pOSs1BL3 4NSW3rS";
$lang['enterpollquestionexp'] = "eN+3R tEH 4N\$WeRS pH0R yOUr P0Ll qu3ST10N.. 1F yoUr POll 1S a &quot;y3s/N0&quot; qUEsTI0N, \$ImPLy En+3R &quot;yeS&quot; F0R 4NsWEr 1 4Nd &quot;N0&quot; pHOR 4NSW3R 2.";
$lang['numberanswers'] = "n0. 4NSWeR\$";
$lang['answerscontainHTML'] = "an5W3R\$ COnT@iN h+Ml (nOT 1NClUD1N9 Si9N@tur3)";
$lang['optionsdisplay'] = "an\$w3Rs D1\$pL4Y +Yp3";
$lang['optionsdisplayexp'] = "how sH0ULD tHE aNSw3r\$ B3 PR3SEN+3d?";
$lang['dropdown'] = "as dR0p-DowN LIsT(\$)";
$lang['radios'] = "aS @ \$3rIES oF R4D10 Bu++On\$";
$lang['votechanging'] = "vOTE CH@NgING";
$lang['votechangingexp'] = "c@n @ persON ch4N93 His OR h3r VoT3?";
$lang['guestvoting'] = "guEs+ V0TIN9";
$lang['guestvotingexp'] = "c@n Gue\$+S vO+E IN +hI\$ POLL?";
$lang['allowmultiplevotes'] = "aLlOW MULtIPl3 V0Te\$";
$lang['pollresults'] = "pOll R3\$UL+s";
$lang['pollresultsexp'] = "h0w WOULd j00 LiKE +O d1sPL4y ThE rESUlt\$ 0f Y0ur P0LL?";
$lang['pollvotetype'] = "polL vO+1N9 tYP3";
$lang['pollvotesexp'] = "h0w \$houLd ThE poLl B3 c0NDuC+eD?";
$lang['pollvoteanon'] = "an0NYMOusLY";
$lang['pollvotepub'] = "publ1c B4LLO+";
$lang['horizgraph'] = "h0r1zOnT@L 9r4PH";
$lang['vertgraph'] = "vEr+iC@l Gr4pH";
$lang['tablegraph'] = "t@bUL4R fORM@t";
$lang['polltypewarning'] = "<b>w4RN1N9</b>: TH1S I\$ a Pu8LIC b4LlOT. YOur n4M3 wILl 83 V1siBLe N3xT +0 THe Op+1ON J00 vo+E F0R.";
$lang['expiration'] = "exPIR4t1oN";
$lang['showresultswhileopen'] = "dO J00 w@N+ to SHOw R3SulT\$ WH1lE +H3 poLl IS OP3N?";
$lang['whenlikepollclose'] = "wheN WouLD J00 L1K3 YouR pOLL +o @u+0M4TiC@LLy cL05e?";
$lang['oneday'] = "oNe D@Y";
$lang['threedays'] = "thrEE d@Y5";
$lang['sevendays'] = "s3V3N daY\$";
$lang['thirtydays'] = "thIrTY d@YS";
$lang['never'] = "nev3r";
$lang['polladditionalmessage'] = "adDI+1oN4L m3\$5@GE (oP+1oN4l)";
$lang['polladditionalmessageexp'] = "d0 J00 w4N+ +0 inCLUd3 An 4DD1ti0N4L p0sT @F+3R t3h PoLL?";
$lang['mustspecifypolltoview'] = "j00 MusT sP3cIFy 4 poLL +0 VIEw.";
$lang['pollconfirmclose'] = "aR3 J00 SUr3 J00 W@n+ +O clOSE tHE F0LLOW1NG P0ll?";
$lang['endpoll'] = "eNd P0Ll";
$lang['nobodyvotedclosedpoll'] = "nOBOdy VOTeD";
$lang['votedisplayopenpoll'] = "%s 4Nd %s h@VE votED.";
$lang['votedisplayclosedpoll'] = "%s @nD %s v0tEd.";
$lang['nousersvoted'] = "n0 U53RS";
$lang['oneuservoted'] = "1 u\$ER";
$lang['xusersvoted'] = "%s u53R\$";
$lang['noguestsvoted'] = "no GUeSTS";
$lang['oneguestvoted'] = "1 9U3ST";
$lang['xguestsvoted'] = "%s 9U3sT\$";
$lang['pollhasended'] = "p0lL H@s ENdeD";
$lang['youvotedforpolloptionsondate'] = "j00 v0+3D for %s oN %s";
$lang['thisisapoll'] = "thi5 1s 4 poll. cL1CK tO V1ew R3SUl+S.";
$lang['editpoll'] = "eDIT P0LL";
$lang['results'] = "r3SULt\$";
$lang['resultdetails'] = "re\$Ul+ d3+41L\$";
$lang['changevote'] = "cH4NgE V0TE";
$lang['pollshavebeendisabled'] = "pOLL\$ hAV3 83EN dIS4BL3D BY tEH F0RuM 0WneR.";
$lang['answertext'] = "anSW3R tEX+";
$lang['answergroup'] = "aN5w3r 9R0uP";
$lang['previewvotingform'] = "pRevIeW voTINg pHORm";
$lang['viewbypolloption'] = "vieW By P0LL 0p+1ON";
$lang['viewbyuser'] = "view bY US3R";

// Profiles (profile.php) ----------------------------------------------

$lang['editprofile'] = "ed1T Pr0fILE";
$lang['profileupdated'] = "pR0pHIl3 UPD@TEd.";
$lang['profilesnotsetup'] = "t3h FOrUM 0WNER h@S nO+ \$3+ Up ProfIlES.";
$lang['ignoreduser'] = "i9N0r3D U\$eR";
$lang['lastvisit'] = "l4s+ v1sIT";
$lang['userslocaltime'] = "uS3R's loCAL TiM3";
$lang['userstatus'] = "s+4Tu\$";
$lang['useractive'] = "onl1N3";
$lang['userinactive'] = "inaC+1Ve / ofPhLIn3";
$lang['totaltimeinforum'] = "tot@L +imE";
$lang['longesttimeinforum'] = "lON93sT S3SSI0N";
$lang['sendemail'] = "s3nD EM@1l";
$lang['sendpm'] = "sEND Pm";
$lang['visithomepage'] = "v151t H0MEP4G3";
$lang['age'] = "ag3";
$lang['aged'] = "a93D";
$lang['birthday'] = "b1RTHd4y";
$lang['registered'] = "re9iS+3REd";
$lang['findpostsmadebyuser'] = "f1Nd po\$ts M@dE bY %s";
$lang['findpostsmadebyme'] = "f1nd po\$TS m4DE 8Y m3";
$lang['findthreadsstartedbyuser'] = "find +Hr3ADS 5T4R+3D 8Y %s";
$lang['findthreadsstartedbyme'] = "f1nD ThR34DS s+aR+eD 8Y mE";
$lang['profilenotavailable'] = "pR0PHIl3 N0T 4V@1l48l3.";
$lang['userprofileempty'] = "this US3R h4s NO+ fill3D 1n +HE1r ProF1L3 0R i+ Is \$3+ TO pR1v4T3.";

// Registration (register.php) -----------------------------------------

$lang['newuserregistrationsarenotpermitted'] = "s0RRY, n3W usEr R39IStR@+1ONS 4R3 N0+ 4LL0weD r1GH+ NOw. Ple4\$3 CH3Ck BaCK L4+3R.";
$lang['usernameinvalidchars'] = "u\$3RN@ME c@N ONlY C0n+a1N 4-Z, 0-9, _ - CH4r4CT3Rs";
$lang['usernametooshort'] = "u53rnAM3 muST BE 4 Min1MUm Of 2 CH4R4Ct3R\$ L0n9";
$lang['usernametoolong'] = "u\$eRN@Me muS+ 83 4 M4XImUM oF 15 Ch4r4C+3rS LONg";
$lang['usernamerequired'] = "a lO9oN NAm3 I\$ ReqUIrEd";
$lang['passwdmustnotcontainHTML'] = "p@ssW0Rd mU\$T N0+ CONt41N h+mL +@G5";
$lang['passwordinvalidchars'] = "p4sswORd C@N OnLY c0nT41N 4-z, 0-9, _ - CH4RACTeR\$";
$lang['passwdtooshort'] = "p4\$SWOrd mUS+ B3 4 miNImUm OF 6 Ch4R4C+3Rs L0Ng";
$lang['passwdrequired'] = "a p4s5WORd is ReQUIreD";
$lang['confirmationpasswdrequired'] = "a c0Nf1rMA+10N PAssW0RD Is REquIr3d";
$lang['nicknamerequired'] = "a n1CKn4ME IS r3QU1R3D";
$lang['emailrequired'] = "an EM@1l @DDREss 1S ReqUIr3D";
$lang['passwdsdonotmatch'] = "p4SSw0rDs do NO+ m4+Ch";
$lang['usernamesameaspasswd'] = "uSeRN4ME 4ND P@\$sWORD MUST 8E D1pHFER3NT";
$lang['usernameexists'] = "s0rrY, @ uSEr W1+H +H@+ NAMe aLR34Dy EXI5+S";
$lang['successfullycreateduseraccount'] = "sucCES5fULly cRE4T3D U\$eR 4CcoUN+";
$lang['useraccountcreatedconfirmfailed'] = "y0UR U53R acCOUN+ H4S 833N CR3@tED 8u+ t3h R3quiR3D c0NPhIrM4TION eM@1L w@\$ N0+ s3N+. PLe4sE coNt@CT tEH F0rUm 0WN3R t0 ReC+IFy +his. In +HiS m3aNTiM3 plE@5E cL1CK TEh C0N+1NUE 8uT+oN to LOg1n.";
$lang['useraccountcreatedconfirmsuccess'] = "y0ur usER ACCOuN+ H4S Be3n cR34TEd Bu+ B3PhoRE j00 c@N ST4R+ P0STiN9 J00 mU5+ c0NF1Rm YOur 3MAiL 4DdR3sS. Pl3a\$3 ChEcK YOuR 3M@1L f0r 4 LInK +H4+ W1Ll 4LL0W j00 TO CONF1Rm yoUr 4DDR3Ss.";
$lang['useraccountcreated'] = "y0UR USeR 4CcouNt H4S b3eN CRE4TEd SUcc3sSPhuLLY! Cl1Ck T3h C0N+1NU3 8u+T0N 83l0w tO Log1N";
$lang['errorcreatinguserrecord'] = "eRr0R CrE4T1n9 u5ER r3CORd";
$lang['userregistration'] = "uS3r REgISTR@TIon";
$lang['registrationinformationrequired'] = "r3G1s+RaT10N iNFOrM4TI0N (R3QU1R3D)";
$lang['profileinformationoptional'] = "pr0FILe INPHORM4T10N (OptI0N4L)";
$lang['preferencesoptional'] = "pr3PH3r3nCES (op+10N4L)";
$lang['register'] = "r3g1\$TEr";
$lang['rememberpasswd'] = "r3m3MB3R P@\$swOrD";
$lang['birthdayrequired'] = "d@te 0pH bIR+h 1S REqu1Red 0R IS InVALId";
$lang['alwaysnotifymeofrepliestome'] = "nO+IFy 0N R3Ply +O m3";
$lang['notifyonnewprivatemessage'] = "no+1PHY oN n3W PRIv4+3 m35s4Ge";
$lang['popuponnewprivatemessage'] = "pOP Up 0n NEW pr1V4+3 me\$S4G3";
$lang['automatichighinterestonpost'] = "aU+0M4+1C HiGH Int3REST 0N P0\$T";
$lang['confirmpassword'] = "conFIrm p4sSWORd";
$lang['invalidemailaddressformat'] = "iNv@lID eM@Il 4dDR3\$S pH0RM4T";
$lang['moreoptionsavailable'] = "more Pr0pHILE @Nd PrePHerENcE 0P+I0NS 4RE 4V41L@8L3 ONcE J00 R39I\$T3R";
$lang['textcaptchaconfirmation'] = "c0npHirM4TI0n";
$lang['textcaptchaexplain'] = "t0 +3H r19H+ iS @ tEXT-c4P+CH@ 1ma9E. pL34S3 Typ3 tH3 COd3 J00 c@n sE3 1n +3H 1M493 iNt0 +3H 1NpU+ ph1ELd 8EL0w I+.";
$lang['textcaptchaimgtip'] = "tHIS 1S a C4PtCH4-piCTuRE. 1T I\$ u\$3D tO pREV3nt 4U+0m4tIc r3G1s+r@Ti0N";
$lang['textcaptchamissingkey'] = "a C0NF1RM4+10n CoDE i\$ rEQUiR3D.";
$lang['textcaptchaverificationfailed'] = "t3XT-cAP+cH@ v3RIpH1C4T10N code W45 InC0RR3CT. Pl3@SE r3-EN+3R iT.";
$lang['forumrules'] = "f0ruM rULE\$";
$lang['forumrulesnotification'] = "in ORDeR +o ProCE3D, j00 MU\$+ 49RE3 wI+h +h3 F0Ll0WINg RUlES";
$lang['forumrulescheckbox'] = "i H4vE rE4D, 4Nd 4GRe3 +0 481D3 8Y +EH FORum rUL3S.";
$lang['youmustagreetotheforumrules'] = "j00 MusT @9R3E T0 tHE f0RUm RuleS bEPhoRE j00 C@n coN+1NU3.";

// Recent visitors list  (visitor_log.php) -----------------------------

$lang['member'] = "m3m8ER";
$lang['searchforusernotinlist'] = "s34rCH pH0R A u\$3R No+ iN l1ST";
$lang['yoursearchdidnotreturnanymatches'] = "y0uR 53ARCH d1D N0T r3TURn ANY m4tCh3s. +Ry SIMPl1PHy1n9 YouR S3arCH p4r@m3T3r\$ 4ND +Ry 4GAin.";
$lang['hiderowswithemptyornullvalues'] = "h1dE R0WS WIth 3Mp+Y 0R nuLL v@lUE\$ 1N \$3lEC+3d coLuMNS";
$lang['showregisteredusersonly'] = "sHow REg1\$TER3d US3RS onLY (H1DE 9uES+s)";

// Relationships (user_rel.php) ----------------------------------------

$lang['relationships'] = "r3l@+1oNSh1p5";
$lang['userrelationship'] = "uSeR r3L4Ti0N\$Hip";
$lang['userrelationships'] = "u\$ER reL4T1onsH1ps";
$lang['failedtoremoveselectedrelationships'] = "f41LEd +O R3M0V3 5El3C+3D R3L4TIOn5H1P";
$lang['friends'] = "fR1ENDS";
$lang['ignoredcompletely'] = "ign0r3d cOmplET3LY";
$lang['relationship'] = "rEL4TI0N\$hIp";
$lang['restorenickname'] = "r3s+oR3 U53R'S NICkn@M3";
$lang['friend_exp'] = "u53R'S po\$tS M4RK3D w1tH 4 &quot;FR1end&quot; Ic0n.";
$lang['normal_exp'] = "user'\$ P0\$Ts @pPE@r @S N0RM4l.";
$lang['ignore_exp'] = "u\$eR'S p0\$+5 4R3 H1dd3N.";
$lang['ignore_completely_exp'] = "tHR3@DS 4nD PO\$+5 T0 or PHr0m U\$3R WILL @PpeaR dELE+3D.";
$lang['display'] = "dI\$pL4Y";
$lang['displaysig_exp'] = "u\$ER'5 SIgN@tUR3 IS d1\$Pl4YED oN theIR p0sTS.";
$lang['hidesig_exp'] = "uS3r'5 SiGNA+UR3 is HiDDeN on +H3Ir P0\$+\$.";
$lang['cannotignoremod'] = "j00 C4Nn0+ 19NOr3 TH1s U\$3R, A\$ TH3y 4RE 4 MOdERa+OR.";
$lang['previewsignature'] = "prEV1EW S1GN@TUR3";

// Search (search.php) -------------------------------------------------

$lang['searchresults'] = "s3arch RESUL+s";
$lang['usernamenotfound'] = "the US3rN@M3 J00 SPeC1PHI3D IN +3h To oR fROM PhI3ld w4s No+ PHouND.";
$lang['notexttosearchfor'] = "onE OR 4lL 0PH Y0uR S3ARCH kEYWORDS wERE 1NV@L1d. SEARch K3YW0Rd\$ muST 83 N0 sHoRT3r +H@n %d cHaraC+ER\$, N0 LoNGER +h@N %d CHarAC+3R\$ 4ND Mus+ N0T App3aR IN +h3 %s";
$lang['keywordscontainingerrors'] = "k3ywords CON+a1n1nG ERroR5: %s";
$lang['mysqlstopwordlist'] = "mYsqL \$T0PWOrD Lis+";
$lang['foundzeromatches'] = "fOUND: 0 M4TcH3\$";
$lang['found'] = "founD";
$lang['matches'] = "m@tch3S";
$lang['prevpage'] = "prEVIOu5 P493";
$lang['findmore'] = "f1Nd M0R3";
$lang['searchmessages'] = "s34RCh MESS49ES";
$lang['searchdiscussions'] = "sE@RCh Di\$CusS10N\$";
$lang['find'] = "f1nd";
$lang['additionalcriteria'] = "add1TIOn@L Cr1+3RIA";
$lang['searchbyuser'] = "sE4rCH by USEr (0PT1ON4L)";
$lang['folderbrackets_s'] = "f0ld3R(s)";
$lang['postedfrom'] = "pOsTED fR0M";
$lang['postedto'] = "p0\$T3D +O";
$lang['today'] = "t0dAY";
$lang['yesterday'] = "y3STErdAY";
$lang['daybeforeyesterday'] = "d@y BePHOrE y3\$TERdAy";
$lang['weekago'] = "%s WEEK 490";
$lang['weeksago'] = "%s WEEKS 490";
$lang['monthago'] = "%s moN+H @G0";
$lang['monthsago'] = "%s moNTH5 4g0";
$lang['yearago'] = "%s y3@R @G0";
$lang['beginningoftime'] = "bE91Nn1nG of T1M3";
$lang['now'] = "n0w";
$lang['lastpostdate'] = "l4ST P0\$t D4+3";
$lang['numberofreplies'] = "numB3R Of R3PL13\$";
$lang['foldername'] = "f0LD3R n@M3";
$lang['authorname'] = "aUtH0R N@me";
$lang['decendingorder'] = "n3WE\$+ PhIR5+";
$lang['ascendingorder'] = "oldEST Ph1R\$T";
$lang['keywords'] = "keyW0rd\$";
$lang['sortby'] = "s0Rt 8Y";
$lang['sortdir'] = "s0rt dIR";
$lang['sortresults'] = "sOrT R3sulT\$";
$lang['groupbythread'] = "gR0uP 8Y +HRE@d";
$lang['postsfromuser'] = "pOst\$ fr0M uS3R";
$lang['threadsstartedbyuser'] = "thr34ds S+arTED bY US3R";
$lang['searchfrequencyerror'] = "j00 C4N onLy S34RCh 0Nc3 EVEry %s SECONDS. PLe4sE TRy AGAiN L4TEr.";
$lang['searchsuccessfullycompleted'] = "sEARCh \$UcC3SsphULLy coMpl3T3D. %s";
$lang['clickheretoviewresults'] = "cLiCK hErE +o VIeW rE\$UL+S.";

// Search Popup (search_popup.php) -------------------------------------

$lang['select'] = "sEL3cT";
$lang['searchforthread'] = "s34rcH fOr THr34d";
$lang['mustspecifytypeofsearch'] = "j00 MU\$t sP3CIPhy TyP3 0F \$3aRch TO p3RF0Rm";
$lang['unkownsearchtypespecified'] = "uNKNOwn SeaRCh +yP3 Sp3CIpH1ED";
$lang['mustentersomethingtosearchfor'] = "j00 mu5+ 3NT3R \$0MEtH1Ng TO sE4Rch f0r";

// Start page (start_left.php) -----------------------------------------

$lang['recentthreads'] = "rEcENt +hREAds";
$lang['startreading'] = "s+4r+ R34D1Ng";
$lang['threadoptions'] = "thr34D 0P+10N\$";
$lang['editthreadoptions'] = "edi+ thr3@d oP+1ON\$";
$lang['morevisitors'] = "m0RE V1S1T0RS";
$lang['forthcomingbirthdays'] = "f0r+HcoM1N9 81RThD4YS";

// Start page (start_main.php) -----------------------------------------

$lang['editstartpage_help'] = "j00 CAn EdIT thI\$ P4ge fr0m +eH @dM1n In+3RPh4c3";

// Thread navigation (thread_list.php) ---------------------------------

$lang['newdiscussion'] = "n3w D1\$CUSs10n";
$lang['createpoll'] = "cre4+E p0lL";
$lang['search'] = "sE4rCH";
$lang['searchagain'] = "seaRch Ag41N";
$lang['alldiscussions'] = "aLl diSCU\$s10nS";
$lang['unreaddiscussions'] = "uNre4d DisCusS10NS";
$lang['unreadtome'] = "uNr3Ad &quot;+0: m3&quot;";
$lang['todaysdiscussions'] = "t0d4y'S DIScuSSIoN5";
$lang['2daysback'] = "2 d4ys b4Ck";
$lang['7daysback'] = "7 d@yS 8@cK";
$lang['highinterest'] = "hI9h 1n+3reST";
$lang['unreadhighinterest'] = "uNRe@D HI9H 1n+Er3\$T";
$lang['iverecentlyseen'] = "i've ReC3nTLy \$3en";
$lang['iveignored'] = "i'V3 1gn0reD";
$lang['byignoredusers'] = "bY 19n0ReD U5Er5";
$lang['ivesubscribedto'] = "i'vE \$ubsCRiBED TO";
$lang['startedbyfriend'] = "s+4rTED 8y PhRIeNd";
$lang['unreadstartedbyfriend'] = "unr34D Std BY FR13ND";
$lang['startedbyme'] = "s+4R+3D BY me";
$lang['unreadtoday'] = "uNrE4d +0d4Y";
$lang['deletedthreads'] = "d3L3+3D tHRE4D\$";
$lang['goexcmark'] = "g0!";
$lang['folderinterest'] = "f0ld3R 1NtER3ST";
$lang['postnew'] = "p0St N3W";
$lang['currentthread'] = "cURR3NT THR34D";
$lang['highinterest'] = "higH In+3rE\$T";
$lang['markasread'] = "m4rK A\$ RE4d";
$lang['next50discussions'] = "n3X+ 50 di\$Cu\$s1oNs";
$lang['visiblediscussions'] = "v1SIBL3 D1SCusS10NS";
$lang['selectedfolder'] = "seL3c+3D phOLder";
$lang['navigate'] = "n4v1gA+E";
$lang['couldnotretrievefolderinformation'] = "th3RE 4rE no F0LdeR5 Av4IL4Bl3.";
$lang['nomessagesinthiscategory'] = "n0 M3s\$@GES 1n TH1S c4T390RY. PlEas3 \$3LEc+ 4N0+HeR, oR %s FoR aLL +HR3Ads";
$lang['clickhere'] = "cl1ck H3RE";
$lang['prev50threads'] = "prev1oUS 50 +hRe4dS";
$lang['next50threads'] = "n3X+ 50 THR3@ds";
$lang['nextxthreads'] = "n3XT %s +HRE4DS";
$lang['threadstartedbytooltip'] = "tHRE@d #%s s+Ar+3D BY %s. ViEW3d %s";
$lang['threadviewedonetime'] = "1 +1M3";
$lang['threadviewedtimes'] = "%d +iME\$";
$lang['unreadthread'] = "unr3AD +HrEAD";
$lang['readthread'] = "re4d +hR3Ad";
$lang['unreadmessages'] = "uNr3@D MES\$@Ges";
$lang['subscribed'] = "sUB\$CRIb3d";
$lang['ignorethisfolder'] = "iGn0r3 Th1s PholDEr";
$lang['stopignoringthisfolder'] = "s+0P igN0RiNG +His F0LDeR";
$lang['stickythreads'] = "s+iCKy THre4D\$";
$lang['mostunreadposts'] = "mOs+ UnR34D P0\$+s";
$lang['onenew'] = "%d nEW";
$lang['manynew'] = "%d nEW";
$lang['onenewoflength'] = "%d nEW 0F %d";
$lang['manynewoflength'] = "%d n3W 0F %d";
$lang['ignorefolderconfirm'] = "aRE j00 \$urE J00 w4nT +O iGN0R3 th1S FOlDER?";
$lang['unignorefolderconfirm'] = "ar3 J00 SUre J00 w@N+ +O St0P iGNOR1Ng +HIS foLd3R?";
$lang['confirmmarkasread'] = "aR3 J00 SUr3 J00 W@NT t0 M4Rk Th3 SEL3CteD +HR3ADs 4\$ r3@d?";
$lang['successfullymarkreadselectedthreads'] = "succe\$SPHULLy M@rKED \$3LEc+3d +hR3@dS 4s r3aD";
$lang['failedtomarkselectedthreadsasread'] = "f4il3d +0 M4Rk SELeC+3D +hR3Ad5 @S reAD";
$lang['gotofirstpostinthread'] = "gO +O pHIr\$+ pO5+ 1N +HrEAd";
$lang['gotolastpostinthread'] = "go TO L@\$+ p0\$+ 1n +HREAd";
$lang['viewmessagesinthisfolderonly'] = "v1eW M3S\$4G3\$ 1N +hIS PHOlDEr ONLy";
$lang['shownext50threads'] = "show N3XT 50 THr34D\$";
$lang['showprev50threads'] = "sh0w Pr3v10uS 50 +hRe4ds";
$lang['createnewdiscussioninthisfolder'] = "cr34+3 New Di\$Cuss1ON 1n th1\$ F0LdeR";
$lang['nomessages'] = "nO m3Ss49e5";

// HTML toolbar (htmltools.inc.php) ------------------------------------
$lang['bold'] = "b0Ld";
$lang['italic'] = "i+4LiC";
$lang['underline'] = "undeRLiN3";
$lang['strikethrough'] = "s+rIK3+hroUGh";
$lang['superscript'] = "sUPerscRIP+";
$lang['subscript'] = "sU8ScR1PT";
$lang['leftalign'] = "l3pH+-4L19N";
$lang['center'] = "c3n+3R";
$lang['rightalign'] = "ri9hT-4lIGN";
$lang['numberedlist'] = "numb3RED li5+";
$lang['list'] = "lI5+";
$lang['indenttext'] = "iNd3nT T3Xt";
$lang['code'] = "c0d3";
$lang['quote'] = "qU0tE";
$lang['unquote'] = "uNQUO+E";
$lang['spoiler'] = "sPoiL3R";
$lang['horizontalrule'] = "h0rIZ0N+@L Rul3";
$lang['image'] = "iM4g3";
$lang['hyperlink'] = "hYpERL1Nk";
$lang['noemoticons'] = "d1s@BL3 3MOTIcONS";
$lang['fontface'] = "f0n+ PH@c3";
$lang['size'] = "sIZ3";
$lang['colour'] = "cOlOUR";
$lang['red'] = "r3d";
$lang['orange'] = "oR4nGE";
$lang['yellow'] = "yELL0W";
$lang['green'] = "gR33n";
$lang['blue'] = "bLU3";
$lang['indigo'] = "iND1G0";
$lang['violet'] = "v1olE+";
$lang['white'] = "whi+3";
$lang['black'] = "bL@ck";
$lang['grey'] = "grey";
$lang['pink'] = "p1nk";
$lang['lightgreen'] = "li9H+ GReEN";
$lang['lightblue'] = "l1gh+ BlUE";

// Forum Stats (messages.inc.php - messages_forum_stats()) -------------

$lang['forumstats'] = "f0rUM 5T@t\$";
$lang['usersactiveinthepasttimeperiod'] = "%s Ac+1VE iN +H3 p@s+ %s. %s";

$lang['numactiveguests'] = "<b>%s</b> 9U3\$+5";
$lang['oneactiveguest'] = "<b>1</b> 9U3S+";
$lang['numactivemembers'] = "<b>%s</b> M3M8ERS";
$lang['oneactivemember'] = "<b>1</b> meM8ER";
$lang['numactiveanonymousmembers'] = "<b>%s</b> 4N0nYMOu\$ m3m8ER\$";
$lang['oneactiveanonymousmember'] = "<b>1</b> 4nONYmoU\$ m3Mb3R";

$lang['numthreadscreated'] = "<b>%s</b> THRe4Ds";
$lang['onethreadcreated'] = "<b>1</b> thR3@D";
$lang['numpostscreated'] = "<b>%s</b> p0st\$";
$lang['onepostcreated'] = "<b>1</b> POs+";

$lang['younormal'] = "j00";
$lang['youinvisible'] = "j00 (INviS18L3)";
$lang['viewcompletelist'] = "v13W c0mPL3+3 li5+";
$lang['ourmembershavemadeatotalofnumthreadsandnumposts'] = "oUr MemB3R\$ h@Ve m4DE 4 +OT4L 0F %s 4ND %s.";
$lang['longestthreadisthreadnamewithnumposts'] = "longeS+ THR3aD I5 <b>%s</b> W1TH %s.";
$lang['therehavebeenxpostsmadeinthelastsixtyminutes'] = "tH3r3 H4V3 8E3N <b>%s</b> p0\$+s M4De IN tEh l@ST 60 M1NU+3s.";
$lang['therehasbeenonepostmadeinthelastsxityminutes'] = "th3R3 H@\$ B3EN <b>1</b> P0\$T m@De 1N +H3 L4ST 60 M1nU+e\$.";
$lang['mostpostsevermadeinasinglesixtyminuteperiodwasnumposts'] = "most pO\$+s 3V3R m@D3 1N @ 5inGl3 60 MiNU+E p3rIOD 1s <b>%s</b> ON %s.";
$lang['wehavenumregisteredmembersandthenewestmemberismembername'] = "w3 h4vE <b>%s</b> r391\$+3R3D M3M8ERs AnD +H3 N3W3\$T MEm83R I\$ <b>%s</b>.";
$lang['wehavenumregisteredmember'] = "wE HAV3 %s R3G1\$teREd MeM8ER\$.";
$lang['wehaveoneregisteredmember'] = "w3 H4Ve 0NE r39IS+3rEd MEmBEr.";
$lang['mostuserseveronlinewasnumondate'] = "m0\$t USerS ev3R OnLiNE w4S <b>%s</b> on %s.";
$lang['statsdisplaychanged'] = "s+4t\$ Di\$PL4y Ch4NGeD";

// Thread Options (thread_options.php) ---------------------------------

$lang['updatessavedsuccessfully'] = "updA+3s SAVEd \$ucCE5SPhULLY";
$lang['useroptions'] = "u53r OPTiONS";
$lang['markedasread'] = "m@RK3D @\$ rE4d";
$lang['postsoutof'] = "pOST\$ OuT Of";
$lang['interest'] = "in+3RE5+";
$lang['closedforposting'] = "clo\$3d PhOR PO\$+1n9";
$lang['locktitleandfolder'] = "lOck +1+LE And PH0LD3r";
$lang['deletepostsinthreadbyuser'] = "dEl3+3 P0S+S iN +Hr34d 8Y u\$er";
$lang['deletethread'] = "dEL3TE +hr3AD";
$lang['permenantlydelete'] = "p3RM4N3NTlY d3lE+3";
$lang['movetodeleteditems'] = "m0VE +O DElET3D Thr3AD5";
$lang['undeletethread'] = "uNd3LET3 +Hr3aD";
$lang['markasunread'] = "m4rk 4s unREAd";
$lang['makethreadsticky'] = "m@KE tHre@d \$tICKy";
$lang['threareadstatusupdated'] = "thR34D re@d \$+@tUS UPd4TEd \$uCCESsphULlY";
$lang['interestupdated'] = "thr3@D 1n+3rES+ s+4Tus upD4TEd SUcC3sSPhULly";
$lang['failedtoupdatethreadreadstatus'] = "f41L3D +o UpdAT3 +hR34D Re@D sTA+US";
$lang['failedtoupdatethreadinterest'] = "f@1Led +O UPd@TE +HR3Ad 1N+3R3sT";
$lang['failedtorenamethread'] = "f4ILEd +O r3N@ME +HR3AD";
$lang['failedtomovethread'] = "f@iLED to moVE +Hr3aD +0 \$pecIF1Ed F0LDEr";
$lang['failedtoupdatethreadstickystatus'] = "f4iLED +0 UpdA+3 ThR3@d stIcKY s+4TUS";
$lang['failedtoupdatethreadclosedstatus'] = "f4iLED +O upD@+e ThRE4d CL053D \$t4tUS";
$lang['failedtoupdatethreadlockstatus'] = "f41lEd +0 UpD4T3 tHrEAD l0CK \$+4+U\$";
$lang['failedtodeletepostsbyuser'] = "f41LEd +O dElE+3 PO\$+S 8Y \$3LeC+Ed U\$3R";
$lang['failedtodeletethread'] = "f41l3D +0 d3l3TE ThR3@D.";
$lang['failedtoundeletethread'] = "f@1leD +O uN-d3l3+3 +hRE4D";

// Dictionary (dictionary.php) -----------------------------------------

$lang['dictionary'] = "d1CTi0n4RY";
$lang['spellcheck'] = "sPeLL cHEck";
$lang['notindictionary'] = "nOT 1N diCTI0N@Ry";
$lang['changeto'] = "ch4NG3 +o";
$lang['restartspellcheck'] = "r3\$+@rT";
$lang['cancelchanges'] = "c4ncEL CH@nGES";
$lang['initialisingdotdotdot'] = "iNIT14l1\$1NG...";
$lang['spellcheckcomplete'] = "sp3LL CH3CK IS c0MPL3tE. To REst@rT \$pElL cHEcK cL1Ck R3St@R+ bu+toN 8EL0W.";
$lang['spellcheck'] = "spell CH3ck";
$lang['noformobj'] = "n0 PH0RM O8J3CT sP3CIf1eD PhoR r3+URn +3xT";
$lang['bodytext'] = "b0dy Tex+";
$lang['ignore'] = "iGN0Re";
$lang['ignoreall'] = "iGN0R3 @LL";
$lang['change'] = "cH@N93";
$lang['changeall'] = "cH4nGe 4LL";
$lang['add'] = "add";
$lang['suggest'] = "su9GEST";
$lang['nosuggestions'] = "(No 5UG935T10NS)";
$lang['cancel'] = "c4nCEl";
$lang['dictionarynotinstalled'] = "n0 DiCTi0NAry h4s 83En 1NSt4LleD. Pl3@S3 c0n+@ct ThE forum oWn3R t0 R3M3Dy +hIS.";

// Permissions keys ----------------------------------------------------

$lang['postreadingallowed'] = "pOsT Re4d1nG 4LL0w3D";
$lang['postcreationallowed'] = "p0st cre@+1ON 4lLOw3d";
$lang['threadcreationallowed'] = "thr3aD CRe@Ti0N @LL0W3D";
$lang['posteditingallowed'] = "p0ST 3DItIng 4LL0w3d";
$lang['postdeletionallowed'] = "p0sT DeLe+10N 4lLOwED";
$lang['attachmentsallowed'] = "a++4CHm3Nt\$ @lL0WeD";
$lang['htmlpostingallowed'] = "h+Ml PO\$+INg 4LL0WED";
$lang['signatureallowed'] = "s19N4TURe AlL0W3D";
$lang['guestaccessallowed'] = "gu3sT 4CC3SS 4LloW3D";
$lang['postapprovalrequired'] = "pOs+ APpr0VAL r3qU1REd";

// RSS feeds gubbins

$lang['rssfeed'] = "r\$s FE3D";
$lang['every30mins'] = "ev3Ry 30 MinU+3\$";
$lang['onceanhour'] = "onc3 4N H0ur";
$lang['every6hours'] = "ev3ry 6 HoURS";
$lang['every12hours'] = "eveRY 12 H0uRs";
$lang['onceaday'] = "onC3 A D@y";
$lang['onceaweek'] = "oNC3 A WEek";
$lang['rssfeeds'] = "r\$\$ PhE3dS";
$lang['feedname'] = "f33D N@mE";
$lang['feedfoldername'] = "f3ed F0LdER N4ME";
$lang['feedlocation'] = "f3ED l0C4TI0N";
$lang['threadtitleprefix'] = "tHREAD TItL3 Pr3pHIX";
$lang['feednameandlocation'] = "fEED n@Me 4nD L0C4Ti0n";
$lang['feedsettings'] = "fE3d S3TTingS";
$lang['updatefrequency'] = "upD4+3 FReqUenCY";
$lang['rssclicktoreadarticle'] = "cl1cK H3RE +0 R3AD +HI\$ 4R+1cL3";
$lang['addnewfeed'] = "aDd N3W pH33D";
$lang['editfeed'] = "edi+ PHeED";
$lang['feeduseraccount'] = "f3ED u\$3r 4CcoUn+";
$lang['noexistingfeeds'] = "no Ex1S+InG rsS PH33D\$ PhoUnD. +O @DD 4 Ph33D cl1CK +h3 '4Dd N3w' 8UTton 8EL0w";
$lang['rssfeedhelp'] = "hEr3 J00 CAN \$3+UP 50ME rsS pHeEDS foR 4U+om4+IC pROP@G4tIoN In+O Y0UR f0RUM. +3H 1+3MS PHr0M +h3 Rss F33D\$ J00 aDD w1LL b3 CRea+3D 4S +Hr34D\$ wH1CH UsERS C4N r3pLy T0 @s iF +H3Y wErE N0Rm4l P0\$+\$. tEH rSS PhE3d mUST b3 4CCeSS1BLE V14 hTTP OR I+ W1lL n0+ woRK.";
$lang['mustspecifyrssfeedname'] = "mu\$t SP3CIFy RSS phE3d nAM3";
$lang['mustspecifyrssfeeduseraccount'] = "mu\$+ SP3CiPHy R5S pHEED US3R 4CcoUn+";
$lang['mustspecifyrssfeedfolder'] = "mu\$+ SP3cIPHy R\$S PH3ED FolD3R";
$lang['mustspecifyrssfeedurl'] = "mUsT \$PEcipHY r\$S F3ED uRL";
$lang['mustspecifyrssfeedupdatefrequency'] = "mUsT sP3CipHy RSs Fe3D UPd4T3 FreQUeNCy";
$lang['unknownrssuseraccount'] = "uNkN0WN r\$s USer 4CC0UN+";
$lang['rssfeedsupportshttpurlsonly'] = "r55 F3ED SuPPoR+\$ H+tP uRLS ONly. SEcUR3 pHE3Ds (hTTpS://) 4R3 n0T suPPoR+3D.";
$lang['rssfeedurlformatinvalid'] = "r\$s PhEED uRl PhORM4t IS INv@L1D. URL mUst 1nCLudE \$Ch3M3 (3.9. hT+p://) @ND 4 h0\$TN@mE (3.G. Www.HOS+N@m3.C0M).";
$lang['rssfeeduserauthentication'] = "rs\$ fe3D dOES n0T SuPPOrt h+TP u\$eR AUTh3nT1C4TioN";
$lang['successfullyremovedselectedfeeds'] = "suCCessPHULlY r3moVED s3LEc+3D pHE3ds";
$lang['successfullyaddedfeed'] = "sucCESSFullY @dDeD NeW phEED";
$lang['successfullyeditedfeed'] = "sUccE\$SFULLY 3dI+3D pHEEd";
$lang['failedtoremovefeeds'] = "f41L3D tO R3MOve SOmE oR @Ll 0f +3H \$3lEc+3D F3EDS";
$lang['failedtoaddnewrssfeed'] = "f41LeD +o @dD n3w R\$S Ph33D";
$lang['failedtoupdaterssfeed'] = "f4ILEd +O UPd4+3 R5\$ F33D";
$lang['rssstreamworkingcorrectly'] = "r\$\$ STR3am 4PPe4RS tO 8E WORk1NG C0RReC+lY";
$lang['rssstreamnotworkingcorrectly'] = "r\$s S+r34M W45 emp+Y 0r c0uLd NO+ B3 foUND";
$lang['invalidfeedidorfeednotfound'] = "iNV4l1d PH33D 1D 0R pH33D n0T pH0UND";

// PM Export Options

$lang['pmexportastype'] = "expoR+ AS +Ype";
$lang['pmexporthtml'] = "h+mL";
$lang['pmexportxml'] = "xml";
$lang['pmexportplaintext'] = "pl41N +3x+";
$lang['pmexportmessagesas'] = "eXPoR+ M3SS493s @\$";
$lang['pmexportonefileforallmessages'] = "on3 F1L3 FOr 4LL mESS@93S";
$lang['pmexportonefilepermessage'] = "one FiL3 PEr MEssaGe";
$lang['pmexportattachments'] = "exp0r+ 4+t4CHM3N+s";
$lang['pmexportincludestyle'] = "incLUDe PHoRUM sTyLE Sh33+";
$lang['pmexportwordfilter'] = "aPply W0rd Ph1lT3R t0 MESS493s";

// Thread merge / split options

$lang['threadhasbeensplit'] = "thre@D H4\$ Be3N spL1t";
$lang['threadhasbeenmerged'] = "thR3ad H@\$ B3eN m3Rg3d";
$lang['mergesplitthread'] = "meRGE / 5PlI+ +HRe@D";
$lang['mergewiththreadid'] = "mergE w1TH +hr3AD 1d:";
$lang['postsinthisthreadatstart'] = "p05+\$ 1n +h15 +hR34D 4+ 5t@rT";
$lang['postsinthisthreadatend'] = "posT\$ In +HIs +Hr34d 4+ eND";
$lang['reorderpostsintodateorder'] = "r3-ORDeR Pos+s IN+0 d4+e 0rdeR";
$lang['splitthreadatpost'] = "sPlIt +hr3AD 4T P05t:";
$lang['selectedpostsandrepliesonly'] = "s3l3CT3D p0st 4nD rEpl1E\$ Only";
$lang['selectedandallfollowingposts'] = "s3lec+3D 4nd 4Ll Ph0lLOwiNG POsTS";

$lang['threadmovedhere'] = "hEre";

$lang['thisthreadhasmoved'] = "<b>tHrE@d\$ m3Rg3D:</b> tH1\$ +HR3@d H4s M0VeD %s";
$lang['thisthreadwasmergedfrom'] = "<b>thRe@Ds m3R93D:</b> +HI\$ Thr34D W4s mER93D fROm %s";
$lang['somepostsinthisthreadhavebeenmoved'] = "<b>thR3@D sPL1T:</b> \$0ME p0\$Ts 1n +hi\$ +Hr3@d H4Ve B3EN MOveD %s";
$lang['somepostsinthisthreadweremovedfrom'] = "<b>tHr3Ad \$pL1+:</b> soME POS+\$ in +h1S +HrEAd w3R3 M0veD fROM %s";

$lang['thisposthasbeenmoved'] = "<b>tHrE@d SPli+:</b> TH15 PO\$t H4s b3EN MOV3d %s";

$lang['invalidfunctionarguments'] = "iNv4L1D PHUnC+1ON @R9UM3Nts";
$lang['couldnotretrieveforumdata'] = "c0Uld NO+ Re+R1evE pHORuM D4T@";
$lang['cannotmergepolls'] = "on3 OR M0R3 ThR34D\$ IS A pOLL. J00 C4nn0+ MeRg3 PoLLS";
$lang['couldnotretrievethreaddatamerge'] = "c0uLD n0t REtR1EVe +hR3Ad D@t4 PHr0m 0N3 0r MoR3 ThR3@D\$";
$lang['couldnotretrievethreaddatasplit'] = "c0ULD nO+ RETR1ev3 THRe4d D4+4 fR0M sOuRCe +hRE@D";
$lang['couldnotretrievepostdatamerge'] = "cOULD n0+ Re+Ri3VE Post d4t@ pHR0M oNe 0R m0re +Hr34DS";
$lang['couldnotretrievepostdatasplit'] = "c0uLD n0+ R3+r1EV3 poS+ D@T4 PhrOM \$OUrcE +HR34D";
$lang['failedtocreatenewthreadformerge'] = "f4ilED +O Cre@T3 N3w +hRE4D pH0R mERge";
$lang['failedtocreatenewthreadforsplit'] = "fAiL3D t0 Cre@Te NeW +hRe@D PH0R spLiT";

// Thread subscriptions

$lang['threadsubscriptions'] = "thr34D SubSCRiP+10NS";
$lang['couldnotupdateinterestonthread'] = "cOULD NoT UpDA+3 In+3RESt ON THrE4D '%s'";
$lang['threadinterestsupdatedsuccessfully'] = "tHr34D 1N+3rESTs UPd4TED SUcc3sSPhULlY";
$lang['nothreadsubscriptions'] = "j00 @r3 n0t \$u8\$CRIbEd +o @nY thrE4DS.";
$lang['resetselected'] = "r3s3+ SELEc+3D";
$lang['allthreadtypes'] = "all +HrEAd TYpeS";
$lang['ignoredthreads'] = "ignOR3D ThrE4DS";
$lang['highinterestthreads'] = "hIgH 1N+3R3\$t tHR3@d\$";
$lang['subscribedthreads'] = "sU8\$Cr1B3D thR34D\$";
$lang['currentinterest'] = "cURR3n+ 1N+3RESt";

// Browseable user profiles

$lang['youcanonlyaddthreecolumns'] = "j00 c@N oNLY 4dD 3 CoLUmns. +O aDD A NEw C0LuMN cL0SE 4n 3X1S+1N9 On3";
$lang['columnalreadyadded'] = "j00 H4VE @LR3aDY @Dd3d +hI\$ COluMn. IPH j00 W@N+ +o ReM0V3 1T CLiCK i+s cL0\$3 8UTt0n";

?>