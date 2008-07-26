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

/* $Id: x-hacker.inc.php,v 1.289 2008-07-26 21:12:42 decoyduck Exp $ */

// British English language file

// Language character set and text direction options -------------------

$lang['_isocode'] = "en-gb";
$lang['_textdir'] = "ltr";

// Months --------------------------------------------------------------

$lang['month'][1]  = "j@nuArY";
$lang['month'][2]  = "f3BRU4rY";
$lang['month'][3]  = "m4Rch";
$lang['month'][4]  = "aPriL";
$lang['month'][5]  = "m4y";
$lang['month'][6]  = "jUN3";
$lang['month'][7]  = "juLy";
$lang['month'][8]  = "aU9ust";
$lang['month'][9]  = "s3P+3MB3r";
$lang['month'][10] = "oC+O8ER";
$lang['month'][11] = "noVemB3r";
$lang['month'][12] = "d3C3m8eR";

$lang['month_short'][1]  = "jAn";
$lang['month_short'][2]  = "f38";
$lang['month_short'][3]  = "m@R";
$lang['month_short'][4]  = "apr";
$lang['month_short'][5]  = "mAY";
$lang['month_short'][6]  = "jUN";
$lang['month_short'][7]  = "juL";
$lang['month_short'][8]  = "au9";
$lang['month_short'][9]  = "seP";
$lang['month_short'][10] = "oCt";
$lang['month_short'][11] = "nOV";
$lang['month_short'][12] = "dEc";

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

$lang['date_periods']['year']   = "%s ye4r";
$lang['date_periods']['month']  = "%s MonTH";
$lang['date_periods']['week']   = "%s wE3k";
$lang['date_periods']['day']    = "%s d@y";
$lang['date_periods']['hour']   = "%s h0uR";
$lang['date_periods']['minute'] = "%s MInutE";
$lang['date_periods']['second'] = "%s \$eConD";

// As above but plurals (2 years vs. 1 year, etc.)

$lang['date_periods_plural']['year']   = "%s Y3@R\$";
$lang['date_periods_plural']['month']  = "%s m0NTHs";
$lang['date_periods_plural']['week']   = "%s W33k5";
$lang['date_periods_plural']['day']    = "%s d4y5";
$lang['date_periods_plural']['hour']   = "%s HouR5";
$lang['date_periods_plural']['minute'] = "%s m1nu+E\$";
$lang['date_periods_plural']['second'] = "%s sECOnD5";

// Short hand periods (example: 1y, 2m, 3w, 4d, 5hr, 6min, 7sec)

$lang['date_periods_short']['year']   = "%sY";    // 1y
$lang['date_periods_short']['month']  = "%sM";    // 2m
$lang['date_periods_short']['week']   = "%sW";    // 3w
$lang['date_periods_short']['day']    = "%sd";    // 4d
$lang['date_periods_short']['hour']   = "%sHr";   // 5hr
$lang['date_periods_short']['minute'] = "%sm1n";  // 6min
$lang['date_periods_short']['second'] = "%ss3c";  // 7sec

// Common words --------------------------------------------------------

$lang['percent'] = "p3RCeNt";
$lang['average'] = "aV3R4Ge";
$lang['approve'] = "aPpr0vE";
$lang['banned'] = "b4NNED";
$lang['locked'] = "l0ckeD";
$lang['add'] = "add";
$lang['advanced'] = "adv4nc3D";
$lang['active'] = "aCt1ve";
$lang['style'] = "stYle";
$lang['go'] = "go";
$lang['folder'] = "foLdER";
$lang['ignoredfolder'] = "i9n0r3d f0LD3r";
$lang['subscribedfolder'] = "su8SCribeD FOLD3r";
$lang['folders'] = "f0lDeRs";
$lang['thread'] = "tHre4d";
$lang['threads'] = "thr34d\$";
$lang['threadlist'] = "tHre4d lis+";
$lang['message'] = "m3ssa9E";
$lang['from'] = "fRom";
$lang['to'] = "tO";
$lang['all_caps'] = "aLl";
$lang['of'] = "oF";
$lang['reply'] = "rePly";
$lang['forward'] = "forw@rD";
$lang['replyall'] = "r3PlY to @lL";
$lang['quickreply'] = "qU1ck r3PLY";
$lang['quickreplyall'] = "qu1ck ReplY to 4Ll";
$lang['pm_reply'] = "r3ply aS pM";
$lang['delete'] = "del3+3";
$lang['deleted'] = "d3L3+3d";
$lang['edit'] = "eDIT";
$lang['privileges'] = "pr1V1le9e\$";
$lang['ignore'] = "i9n0rE";
$lang['normal'] = "n0rM4l";
$lang['interested'] = "iNtER3\$TED";
$lang['subscribe'] = "sU8\$CRi8E";
$lang['apply'] = "appLy";
$lang['download'] = "dowNlo4d";
$lang['save'] = "sav3";
$lang['update'] = "upD@+E";
$lang['cancel'] = "c4NCEL";
$lang['continue'] = "c0NTInu3";
$lang['attachment'] = "at+4cHMENT";
$lang['attachments'] = "at+4CHM3N+S";
$lang['imageattachments'] = "iM4g3 4+t4CHmEnT\$";
$lang['filename'] = "f1l3N4mE";
$lang['dimensions'] = "d1MenS1on\$";
$lang['downloadedxtimes'] = "dOwNLO4D3D: %d Time\$";
$lang['downloadedonetime'] = "d0wNlo4dED: 1 +im3";
$lang['size'] = "s1z3";
$lang['viewmessage'] = "vIeW ME\$5@9E";
$lang['deletethumbnails'] = "d3L3T3 +HUMBn4iLS";
$lang['logon'] = "lOG0N";
$lang['more'] = "m0r3";
$lang['recentvisitors'] = "rEC3N+ vi\$1+0R5";
$lang['username'] = "uS3rn@Me";
$lang['clear'] = "cLE4R";
$lang['reset'] = "r3S3t";
$lang['action'] = "ac+i0n";
$lang['unknown'] = "uNkNown";
$lang['none'] = "noN3";
$lang['preview'] = "pr3v1ew";
$lang['post'] = "pO\$+";
$lang['posts'] = "poS+5";
$lang['change'] = "cH4NGE";
$lang['yes'] = "y3S";
$lang['no'] = "nO";
$lang['signature'] = "sI9n4tUr3";
$lang['signaturepreview'] = "si9nA+urE Pr3VieW";
$lang['signatureupdated'] = "si9n@TurE upD4T3d";
$lang['signatureupdatedforallforums'] = "sIgN@tUr3 uPD@+ED ph0r @ll ph0rum5";
$lang['back'] = "b4CK";
$lang['subject'] = "su8j3Ct";
$lang['close'] = "cL0se";
$lang['name'] = "n4M3";
$lang['description'] = "deSCR1p+1On";
$lang['date'] = "d4te";
$lang['view'] = "v13W";
$lang['enterpasswd'] = "eNT3r p4s\$woRD";
$lang['passwd'] = "p45\$WOrD";
$lang['ignored'] = "iGNoreD";
$lang['guest'] = "gues+";
$lang['next'] = "nEx+";
$lang['prev'] = "preV1ous";
$lang['others'] = "o+h3Rs";
$lang['nickname'] = "n1ckn4M3";
$lang['emailaddress'] = "eM41l 4dDrES\$";
$lang['confirm'] = "cOnPh1RM";
$lang['email'] = "em@IL";
$lang['poll'] = "p0LL";
$lang['friend'] = "fr1eNd";
$lang['success'] = "sucC3sS";
$lang['error'] = "eRror";
$lang['warning'] = "w@rnIn9";
$lang['guesterror'] = "s0RrY, j00 N3ed To 8e L0g93d IN To uS3 +HI5 ph34ture.";
$lang['loginnow'] = "lO91n N0w";
$lang['unread'] = "uNr3AD";
$lang['all'] = "aLl";
$lang['allcaps'] = "alL";
$lang['permissions'] = "p3rmi\$SiONS";
$lang['type'] = "tYp3";
$lang['print'] = "prin+";
$lang['sticky'] = "sTIcKy";
$lang['polls'] = "pOLL\$";
$lang['user'] = "us3R";
$lang['enabled'] = "eN4bL3d";
$lang['disabled'] = "diSA8l3d";
$lang['options'] = "oPTION5";
$lang['emoticons'] = "emOTiCON\$";
$lang['webtag'] = "w38t@9";
$lang['makedefault'] = "m@K3 D3ph4ul+";
$lang['unsetdefault'] = "uNS3T d3phaUl+";
$lang['rename'] = "ren@m3";
$lang['pages'] = "p@9E5";
$lang['used'] = "useD";
$lang['days'] = "d4y5";
$lang['usage'] = "u\$ag3";
$lang['show'] = "sHOW";
$lang['hint'] = "hIN+";
$lang['new'] = "n3w";
$lang['referer'] = "r3ph3Rer";
$lang['thefollowingerrorswereencountered'] = "t3h FoLl0wiN9 ERr0R\$ w3R3 eNc0UnteRED:";

// Admin interface (admin*.php) ----------------------------------------

$lang['admintools'] = "aDm1n +00ls";
$lang['forummanagement'] = "forum m4n4G3mEnt";
$lang['accessdeniedexp'] = "j00 Do n0T H@vE pErm1Ssion t0 u\$3 TH1s 5Ec+10N.";
$lang['managefolders'] = "mAnAge f0Ld3rs";
$lang['manageforums'] = "m@n@gE fORumS";
$lang['manageforumpermissions'] = "m@N493 phOrum P3rm1\$sions";
$lang['foldername'] = "fOLDeR n4M3";
$lang['move'] = "m0V3";
$lang['closed'] = "cl05ed";
$lang['open'] = "oP3N";
$lang['restricted'] = "rE\$tr1C+3d";
$lang['forumiscurrentlyclosed'] = "%s 1s Curr3N+LY CL05Ed";
$lang['youdonothaveaccesstoforum'] = "j00 D0 n0+ H4Ve 4CCE\$S TO %s";
$lang['toapplyforaccessplease'] = "tO 4pPLy FoR 4cc355 plEAs3 COn+@C+ +He %s.";
$lang['forumowner'] = "foRUM OwN3r";
$lang['adminforumclosedtip'] = "iph J00 W4nT TO CH4N93 \$0ME s3T+InGS 0N Y0Ur FoRuM cliCk TeH 4Dm1N L1nK in +3H nAVI9@+10n b4R 480ve.";
$lang['newfolder'] = "n3W F0lD3R";
$lang['nofoldersfound'] = "nO Ex1\$t1N9 fOlDeR\$ F0unD. T0 @DD 4 phOld3r cl1cK ThE '4dD NeW' BuTt0N BELOw.";
$lang['forumadmin'] = "f0rUM @dM1n";
$lang['adminexp_1'] = "u53 Th3 m3NU 0N +HE lEPH+ +o M4n4g3 +hin9\$ In y0uR F0rUM.";
$lang['adminexp_2'] = "<b>uS3r\$</b> 4lL0wS j00 t0 SE+ 1NdIvIdU4L U\$3r peRM1SS10NS, INCLUD1Ng 4PP01n+1Ng m0dEr4+Or\$ @ND 949G1ng pe0pl3.";
$lang['adminexp_3'] = "<b>us3R GROUPS</b> @lLOWS j00 t0 CR3@+e UsER gr0UP\$ +0 45\$iGN p3RMiSS10n5 +O 4S M4ny OR 4\$ Ph3W u53R\$ qu1CkLy @ND 3451lY.";
$lang['adminexp_4'] = "<b>b4N c0ntR0ls</b> 4Ll0ws +eH BaNNiNg 4ND un-84nN1n9 0ph 1P 4DDR35SeS, h++p r3pH3r3rs, UseRN4mE5, 3M4iL @ddR3\$sE5 @nD niCkN4mes.";
$lang['adminexp_5'] = "<b>f0lD3R\$</b> 4lLow5 thE Cre@+1on, m0d1phIC4tioN 4nd D3lE+i0n of ph0LD3r\$.";
$lang['adminexp_6'] = "<b>r\$S ph33dS</b> @llOWs j00 +0 M@N4gE rs5 PheEds For pr0P49@tioN 1n+o Y0ur Ph0rum.";
$lang['adminexp_7'] = "<b>pR0F1l3\$</b> L3+S J00 CUS+0M1se TEH 1+Em\$ tHaT 4PpE@r 1n THE U5ER Pr0F1les.";
$lang['adminexp_8'] = "<b>forum s3+TIN9S</b> 4llow\$ j00 +o CUst0m1se y0UR F0RUm's name, APp3@ranC3 @nD m4nY otheR +hin9\$.";
$lang['adminexp_9'] = "<b>s+4Rt P4G3</b> Le+5 j00 Cu5+0M1se YOUr PHOrUm'S s+4r+ P493.";
$lang['adminexp_10'] = "<b>foRUm 5+YL3</b> aLlowS J00 +0 9en3r4te r4ND0m 5+Yle\$ fOR Y0ur PH0rum meM83RS t0 u\$3.";
$lang['adminexp_11'] = "<b>worD filt3r</b> 4ll0wS J00 to Ph1L+er w0rd\$ j00 D0n'+ w4n+ +O B3 us3d 0n y0Ur foruM.";
$lang['adminexp_12'] = "<b>pOsT1n9 5t@+S</b> 93n3raTeS @ r3POr+ L1\$+iN9 +He toP 10 P0st3rs in 4 DEph1N3d pERiod.";
$lang['adminexp_13'] = "<b>f0rUM liNKS</b> L3T5 J00 M@n49E TH3 Link\$ drOpdOwn 1N Th3 N@v1g4Tion b4R.";
$lang['adminexp_14'] = "<b>v1Ew Lo9</b> L15t5 rEC3nt 4ct1Ons bY T3h f0ruM moDer4+ORs.";
$lang['adminexp_15'] = "<b>mAn@ge f0RUmS</b> le+5 J00 crE@+3 4nD D3L3te @Nd CLoSe oR rEoPEN FoRuM5.";
$lang['adminexp_16'] = "<b>gl084l fORUM s3T+iN9S</b> AllOwS J00 To mod1PHy 5e+T1nGs WHich 4PhfeCT 4ll F0RUMS.";
$lang['adminexp_17'] = "<b>pOS+ @pPR0v@L QU3u3</b> @ll0w5 j00 +0 v1Ew aNY P05+5 4w4it1n9 4Pprov4L 8Y 4 MOdEr4+oR.";
$lang['adminexp_18'] = "<b>vi\$it0r l09</b> 4lL0WS J00 To V1ew 4n exT3NdED L1S+ 0F V1\$i+oR\$ incLud1n9 +H31R H++p R3pHER3rS.";
$lang['createforumstyle'] = "crE@T3 4 FoRuM 5tyL3";
$lang['newstylesuccessfullycreated'] = "n3W \$+Yl3 5uCC3s5PhUlly CRE@T3D.";
$lang['stylealreadyexists'] = "a \$+YlE Wi+H +H4T pH1L3N@ME @lr34dY ExI\$+5.";
$lang['stylenofilename'] = "j00 D1d No+ 3nT3R 4 pH1Len4M3 +O \$4v3 THe \$+yl3 wi+H.";
$lang['stylenodatasubmitted'] = "c0uld not r3@D pHorUM s+yL3 d@+4.";
$lang['styleexp'] = "uSe th15 p493 +O help CrE4te @ Rand0MlY 9eN3r4+3d S+ylE f0R your f0RUm.";
$lang['stylecontrols'] = "c0NTrOl\$";
$lang['stylecolourexp'] = "cl1CK on 4 c0Lour +0 m4k3 4 N3w \$+yL3 ShEE+ B4\$3D on Th4T Col0Ur. cUrR3NT 84SE col0UR is phirst 1N lI\$T.";
$lang['standardstyle'] = "s+aNd4Rd STYl3";
$lang['rotelementstyle'] = "r0T4+3D 3l3men+ S+yLe";
$lang['randstyle'] = "r4ND0M S+ylE";
$lang['thiscolour'] = "tH1\$ c0l0Ur";
$lang['enterhexcolour'] = "oR EnT3r 4 HeX c0LOur +O 8@se 4 nEw \$tylE sh3et 0n";
$lang['savestyle'] = "s@ve th1S \$+YL3";
$lang['styledesc'] = "sTYLe dE\$cRiPti0N";
$lang['stylefilenamemayonlycontain'] = "s+YLE filen@Me m@y onlY C0n+@in LOW3rC4s3 le+tEr\$ (4-Z), nuMBEr5 (0-9) @Nd unDErsC0r3.";
$lang['stylepreview'] = "styl3 pR3v1ew";
$lang['welcome'] = "wELC0m3";
$lang['messagepreview'] = "meSs493 pReV1ew";
$lang['users'] = "uS3rs";
$lang['usergroups'] = "u\$3r 9rOUPs";
$lang['mustentergroupname'] = "j00 mu\$+ 3N+3r @ grOuP n4mE";
$lang['profiles'] = "pr0PHIL35";
$lang['manageforums'] = "m4n493 foRuM\$";
$lang['forumsettings'] = "f0rUm 5ettinGS";
$lang['globalforumsettings'] = "gl0B4L ph0RuM 5e+tings";
$lang['settingsaffectallforumswarning'] = "<b>n0tE:</b> +hesE \$e+t1nGS 4fPHEc+ 4Ll phORUM\$. WH3r3 +3H S3tT1N9 1s dUPL1c4t3d 0n +h3 inD1V1dU@l f0rum'5 5E++iNg\$ PaG3 +h4+ wILl t4K3 PR3c3deNC3 ov3R +hE se+t1ngs j00 ch4ngE h3r3.";
$lang['startpage'] = "s+4RT p4Ge";
$lang['startpageerror'] = "yOUr \$T4rt p@9e C0uld no+ 83 saVEd loc4LLy +O +He S3rver 83c4u\$E perm1\$5i0n w45 d3n1Ed.</p><p>t0 cHAnge y0ur \$+@Rt p@93 pL34S3 cl1ck +EH dowNlOaD bu++0N 8El0w wh1CH w1ll PR0mp+ j00 tO \$av3 +eH f1le to Y0ur h4rd drIV3. j00 C@n +hEn upl0AD +h1s phil3 t0 y0ur seRv3R 1n+o +H3 fOllow1Ng PhOldeR, 1ph NEc3\$s4ry cRe4TIn9 t3h fOLD3R sTruc+Ur3 1n +h3 Pr0CE5s.</p><p><b>%s</b></p><p>pLe@SE NOT3 th4T Som3 brOW5eRs m4y cHANG3 the n4ME OF TH3 Phil3 upOn DOWNl04D. WhEN upl04d1n9 +eh file pL34sE MaK3 \$uR3 +H@+ 1t 1S n@Med s+@R+_M4in.pHp 0th3rW1\$3 youR \$+4rt p@g3 wilL 4ppE4R uNch4NgEd.";
$lang['uploadcssfile'] = "uPlo4D CSS \$+YlE \$h3e+";
$lang['uploadcssfilefailed'] = "y0uR Css 5+yle SHEet CoulD n0t Be UpL0@DEd T0 Teh S3rVeR 83c4US3 PErmi5\$iOn w@S dEnieD.</p><p>tO ch@nge y0uR sT4RT Pag3 csS s+Yl3 SH3ET plE4se 3N\$ure TH3 fOLlOW1ng foldEr\$ 3xi\$+ 4nd 4rE writ@BLE: </p><p><b>%s</b></p>";
$lang['invalidfiletypeerror'] = "iNV4lid f1L3 TYP3, j00 c4n only upL04D C\$s 5tYl3 sh33t PHiLe5";
$lang['failedtoopenmasterstylesheet'] = "yOUr F0Rum \$+yle C0uLd not 83 54ved beC4Us3 +hE m4\$+3R STyl3 \$hE3+ c0uld n0T B3 l04d3d. to S@ve yOur 5tyl3 th3 m4\$+3r \$tYlE \$H3ET (M@K3_S+yl3.css) mUst 8e Loc@teD 1n t3h s+yl3\$ D1RECToRY oph y0ur 8e3H1V3 F0Rum 1nSt4lL4+1ON.";
$lang['makestyleerror'] = "y0Ur foRUm 5TYlE c0Uld N0+ BE s@vEd l0c@lLy +0 Teh \$eRvEr B3c4u53 P3rm1\$S10N W45 dEn13d.</p><p>t0 s4vE y0ur PH0rum \$+yl3 pl34\$E CliCk thE D0wnLo4D 8U+tON 83LoW WhiCH will Prompt j00 +o S@v3 +3h PHil3 +o y0ur H4RD driV3. J00 c4n Th3N UpL0@D th1\$ F1lE t0 Y0uR s3RveR 1n+0 +h3 FOLloWIn9 PH0Ld3R, 1pH N3c3\$s4ry CRe4TIN9 +eH foLd3R StRuCtuR3 1n +HE pRoC3S5.</p><p><b>%s</b></p><p>plE4Se NOte +H@+ 5OME BR0W\$eR\$ M4Y ch@Nge tH3 n4Me 0Ph tH3 F1LE uPon DOWnL04d. WH3N upLo4D1N9 th3 fIl3 pLe@Se M4Ke sur3 th4+ 1+ 1S naM3D \$tYlE.C5s 0Th3rwis3 tHe ph0RUm S+YLe wIll 83 un4v41l4blE.";
$lang['forumstyle'] = "f0RUm \$Tyl3";
$lang['wordfilter'] = "wOrd filT3R";
$lang['forumlinks'] = "f0ruM LiNkS";
$lang['viewlog'] = "v13W Lo9";
$lang['noprofilesectionspecified'] = "no pR0pH1L3 sectIoN \$P3ciph1Ed.";
$lang['itemname'] = "i+Em n@mE";
$lang['moveto'] = "m0v3 To";
$lang['manageprofilesections'] = "m4N49e PRoF1LE s3C+10n\$";
$lang['sectionname'] = "s3C+1on N4M3";
$lang['items'] = "it3m\$";
$lang['mustspecifyaprofilesectionid'] = "muSt 5pECIPhY @ ProPhIle sEc+10n 1d";
$lang['mustsepecifyaprofilesectionname'] = "mUSt 5pecIpHY 4 propH1Le 53C+i0n n4M3";
$lang['noprofilesectionsfound'] = "n0 3x1\$+1Ng pr0PH1L3 SEct1ons f0und. +0 4DD 4 Pr0phiL3 5ec+10n cL1Ck +hE '@Dd N3W' bu++oN BElOw.";
$lang['addnewprofilesection'] = "add new pR0ph1Le 53c+I0n";
$lang['successfullyaddedprofilesection'] = "sucCEssPHuLlY 4DD3d PROPhIle \$ECTIOn";
$lang['successfullyeditedprofilesection'] = "sUCCe\$sFUlLy 3d1teD Pr0phILE 5EC+1on";
$lang['addnewprofilesection'] = "aDd nEw PROf1L3 s3cT10n";
$lang['mustsepecifyaprofilesectionname'] = "mu\$t \$P3C1Fy 4 PRoPH1l3 s3C+iOn n4m3";
$lang['successfullyremovedselectedprofilesections'] = "suCC3ssphUlLY rEMoVED 53LECt3D pROFilE \$Ec+10N5";
$lang['failedtoremoveprofilesections'] = "f4iLeD +0 R3MOVe PROPHILE \$ect1oNS";
$lang['viewitems'] = "vi3w 1+3Ms";
$lang['successfullyaddednewprofileitem'] = "sUccESSPHuLlY @DD3d n3W Pr0F1le IteM";
$lang['successfullyeditedprofileitem'] = "sUCC3s\$FULlY 3dItED pR0Ph1lE I+em";
$lang['successfullyremovedselectedprofileitems'] = "sUcc3sSFULLy REMoVED 53L3c+3d pR0pH1L3 i+3Ms";
$lang['failedtoremoveprofileitems'] = "fA1L3D T0 Rem0VE PropH1l3 1T3ms";
$lang['noexistingprofileitemsfound'] = "th3RE aRE n0 ex1\$+1n9 Proph1L3 iT3ms 1n TH1\$ \$Ec+i0n. T0 adD 4N i+3m CL1CK +3H '@DD nEw' 8uT+ON BELOw.";
$lang['edititem'] = "eDi+ it3m";
$lang['invalidprofilesectionid'] = "inv4liD pRophILe 53ct10n iD 0R s3C+1ON N0T f0uNd";
$lang['invalidprofileitemid'] = "inv@L1D pRoF1L3 itEM 1d oR It3M N0+ FoUnD";
$lang['addnewitem'] = "aDD nEw 1+3m";
$lang['youmustenteraprofileitemname'] = "j00 Mu\$+ ENT3R 4 PRofil3 iTeM N@m3";
$lang['invalidprofileitemtype'] = "inV4Lid pR0f1l3 1t3M TypE s3lEC+ED";
$lang['youmustenteroptionsforselectedprofileitemtype'] = "j00 mU\$T EntEr SomE OPT10nS for 5eleCT3d prOpH1lE 1t3M +YpE";
$lang['youmustentermorethanoneoptionforitem'] = "j00 mUsT 3N+er m0Re +h4n 0NE 0pT10N pHor 5eL3CTed PR0phIlE 1tem +yp3";
$lang['profileitemhyperlinkssupportshttpurlsonly'] = "pRofiL3 i+3M HypErl1NKs Suppor+ http url\$ only";
$lang['profileitemhyperlinkformatinvalid'] = "pr0f1lE 1+Em HypeRL1nK f0rM4+ iNv4liD";
$lang['youmustincludeprofileentryinhyperlinks'] = "j00 must InCluDE <i>%s</i> in t3H uRL of cL1Ck@8LE hYp3RLInKs";
$lang['failedtocreatenewprofileitem'] = "f@Il3d t0 CR34tE nEw pR0FIL3 1t3m";
$lang['failedtoupdateprofileitem'] = "f@ileD +0 upD4+3 PR0fiLe 1+eM";
$lang['startpageupdated'] = "sT4r+ P@G3 UPd4+3d. %s";
$lang['cssfileuploaded'] = "css S+yle sh3e+ UPL0@DED. %s";
$lang['viewupdatedstartpage'] = "v1EW uPDA+3d s+@r+ P@9e";
$lang['editstartpage'] = "eD1t \$T4R+ p@G3";
$lang['nouserspecified'] = "n0 usEr 5peCiph13d.";
$lang['manageuser'] = "maN@9E uS3R";
$lang['manageusers'] = "m4n493 u53RS";
$lang['userstatusforforum'] = "uSer St4tu\$ phOr %s";
$lang['userdetails'] = "us3r D3t4iLS";
$lang['edituserdetails'] = "edI+ u\$er dE+@1ls";
$lang['warning_caps'] = "w4RnIn9";
$lang['userdeleteallpostswarning'] = "aR3 j00 \$UrE J00 W@Nt t0 Dele+E 4LL OF t3h \$3L3C+ED u\$3R'\$ poSTS? ONc3 +He POs+S 4re Del3+ed tHEy c4NNo+ 8e R3tr13V3d anD W1Ll BE L0\$T foReVer.";
$lang['postssuccessfullydeleted'] = "posts wEr3 5uCc3sspHully del3+3d.";
$lang['folderaccess'] = "f0Ld3R 4cCe\$\$";
$lang['possiblealiases'] = "poSSIBLE 4l14se\$";
$lang['ipaddressmatches'] = "ip 4DDr3SS M@tche5";
$lang['emailaddressmatches'] = "em4Il 4ddrE\$\$ matCh3\$";
$lang['passwdmatches'] = "pASSWoRd m@tcH35";
$lang['httpreferermatches'] = "h++p rEferEr Ma+Ch3S";
$lang['userhistory'] = "u53r hI\$+0ry";
$lang['nohistory'] = "nO histoRY R3cord\$ s4V3d";
$lang['userhistorychanges'] = "ch4nGEs";
$lang['clearuserhistory'] = "cL34r u53R hisT0RY";
$lang['changedlogonfromto'] = "ch@n9ed L0GON phroM %s t0 %s";
$lang['changednicknamefromto'] = "cH@N9ed niCkN4ME phR0m %s +0 %s";
$lang['changedemailfromto'] = "cHang3D 3m@Il frOM %s t0 %s";
$lang['successfullycleareduserhistory'] = "suCce5\$fulLy ClE@r3d uS3R hI5+ORY";
$lang['failedtoclearuserhistory'] = "faIled to CLear uS3r Hi\$t0ry";
$lang['successfullychangedpassword'] = "sUCcE\$\$fully Chan93d p4S\$worD";
$lang['failedtochangepasswd'] = "f@iled +0 chAng3 p45\$W0rd";
$lang['approveuser'] = "appR0v3 U\$3r";
$lang['viewuserhistory'] = "v1eW u\$3r hisT0rY";
$lang['viewuseraliases'] = "vieW u\$3r 4l1@\$E\$";
$lang['searchreturnednoresults'] = "se4RCH re+uRneD n0 r3\$ults";
$lang['deleteposts'] = "deL3t3 p0St5";
$lang['deleteuser'] = "d3le+3 uS3r";
$lang['alsodeleteusercontent'] = "alS0 delE+3 ALl oph +3h c0n+3n+ crE4TED By +h1s USer";
$lang['userdeletewarning'] = "ar3 j00 Sure j00 w4N+ t0 d3l3+e +3H \$3l3c+3D u\$3r @CcoUN+? 0NC3 teh @CCouNt h4s Be3n Dele+3d it C@nNo+ Be r3+r13V3d @nd wIlL 8E losT PHor3v3r.";
$lang['usersuccessfullydeleted'] = "us3R succ3\$SpHullY d3l3+3D";
$lang['failedtodeleteuser'] = "f4IL3D to delE+3 U5Er";
$lang['forgottenpassworddesc'] = "if +hi5 U\$ER H@\$ f0r90++3n th31r P@\$SwoRD j00 C@n R3\$3+ 1+ Phor them heRe.";
$lang['failedtoupdateuserstatus'] = "faileD +O UpDa+3 uSEr \$+4+uS";
$lang['failedtoupdateglobaluserpermissions'] = "f41led T0 UpdaT3 9lo84L user p3RmI5S10nS";
$lang['failedtoupdatefolderaccesssettings'] = "f4Il3d t0 upD4+3 f0lDer aCCesS \$3++1nG5";
$lang['manageusersexp'] = "th1\$ l1St 5h0ws a \$el3c+ioN 0ph uSER5 wh0 h4V3 Lo9g3d 0n t0 y0uR f0rUm, 5or+3d 8Y %s. +o ALT3R @ u\$3r'S PeRm1SS1on\$ CLiCK +heir naM3.";
$lang['userfilter'] = "uS3R filT3r";
$lang['onlineusers'] = "onl1N3 Users";
$lang['offlineusers'] = "oPHphlin3 U5ErS";
$lang['usersawaitingapproval'] = "uS3r\$ @w4ITing 4PProV@L";
$lang['bannedusers'] = "b4nned USers";
$lang['lastlogon'] = "lA\$+ l0g0n";
$lang['sessionreferer'] = "s3SS1ON reph3rer";
$lang['signupreferer'] = "s1GN-UP rEPHer3r:";
$lang['nouseraccountsmatchingfilter'] = "nO US3r 4cCoun+\$ MaTch1N9 f1l+eR";
$lang['searchforusernotinlist'] = "s34RCh phor @ us3r no+ IN li\$T";
$lang['adminaccesslog'] = "adMIn @CC3sS LO9";
$lang['adminlogexp'] = "th1s L1ST 5hoWS +he L4S+ @ct10NS 54NCt10n3d 8y u\$3r5 w1+h @dm1n pRIVil39e\$.";
$lang['datetime'] = "d4te/+im3";
$lang['unknownuser'] = "uNKn0WN u\$3R";
$lang['unknownuseraccount'] = "unKN0wn USEr 4cC0uNT";
$lang['unknownfolder'] = "unkn0WN f0ld3r";
$lang['ip'] = "ip";
$lang['lastipaddress'] = "laST ip aDdresS";
$lang['hostname'] = "hoSTn@Me";
$lang['unknownhostname'] = "uNkn0wn ho5+n4ME";
$lang['logged'] = "l0g93D";
$lang['notlogged'] = "nOt log9Ed";
$lang['addwordfilter'] = "aDd W0RD fil+3r";
$lang['addnewwordfilter'] = "aDd nEw w0rD phIL+3R";
$lang['wordfilterupdated'] = "worD Phil+3r UpdA+3d";
$lang['wordfilterisfull'] = "j00 c@nn0T @Dd any Mor3 WorD f1L+3rs. rEm0v3 S0M3 uNUs3d one\$ oR EdI+ TH3 3x1\$+1ng ON35 f1rS+.";
$lang['filtername'] = "fILteR N@M3";
$lang['filtertype'] = "filTer TypE";
$lang['filterenabled'] = "fILTEr 3n48lED";
$lang['editwordfilter'] = "ed1t WORD f1LtEr";
$lang['nowordfilterentriesfound'] = "no 3XI\$tin9 word f1LT3R 3NtR13s F0unD. To 4Dd 4 pH1LT3R CLiCk +He '4Dd nEw' 8UttoN BELow.";
$lang['mustspecifyfiltername'] = "j00 mu\$+ sp3cipHY @ F1LT3R name";
$lang['mustspecifymatchedtext'] = "j00 MUS+ SPECiphy mATCH3d tex+";
$lang['mustspecifyfilteroption'] = "j00 mus+ 5P3c1FY a phILter oP+iOn";
$lang['mustspecifyfilterid'] = "j00 Mu5+ sPEC1PHy 4 ph1LT3R 1d";
$lang['invalidfilterid'] = "iNV@lid F1LT3r id";
$lang['failedtoupdatewordfilter'] = "f@1Led To UPD@+E w0rd ph1lter. ch3ck +h4t th3 PH1lt3r \$+iLl 3xiSt\$.";
$lang['allow'] = "alL0W";
$lang['block'] = "blOcK";
$lang['normalthreadsonly'] = "nORm@l thre4D\$ Only";
$lang['pollthreadsonly'] = "poLL +HRE4DS 0Nly";
$lang['both'] = "bO+H +hR34d typ3\$";
$lang['existingpermissions'] = "ex1\$t1ng p3rm15s10NS";
$lang['nousershavebeengrantedpermission'] = "n0 3Xi\$TING US3r\$ p3rM1Ss1ons Phound. t0 GraN+ perM1\$5ioN +o u\$3r\$ \$earch ph0R +h3m 83L0W.";
$lang['successfullyaddedpermissionsforselectedusers'] = "suCC3s5FUlLy ADD3D p3rmisS1onS FOr s3l3c+3d U\$eR\$";
$lang['successfullyremovedpermissionsfromselectedusers'] = "sUcc3\$\$Phully remoV3d permIss1on\$ PHrOm \$EL3C+ed US3R5";
$lang['failedtoaddpermissionsforuser'] = "f@1l3D to @dd p3rm1sSions Ph0R us3R '%s'";
$lang['failedtoremovepermissionsfromuser'] = "f@1l3d TO R3m0Ve perm1Ss10nS fR0m USer '%s'";
$lang['searchforuser'] = "se4RCh Ph0R u\$ER";
$lang['browsernegotiation'] = "br0W53r NEg0+14+Ed";
$lang['textfield'] = "tEXT PhielD";
$lang['multilinetextfield'] = "mul+i-lin3 +3xt f13ld";
$lang['radiobuttons'] = "r@di0 bU++oN\$";
$lang['dropdownlist'] = "dROP d0wN lI\$+";
$lang['clickablehyperlink'] = "cl1ck48le hyp3Rl1nk";
$lang['threadcount'] = "tHre4d Coun+";
$lang['clicktoeditfolder'] = "cLICK +0 ed1+ ph0lD3R";
$lang['fieldtypeexample1'] = "t0 cr3Ate R4D10 buT+On5 0R 4 dr0p d0wn li\$t j00 Need +O 3n+eR e4CH ind1VIDu4L v4lue 0n a \$Epar4+e line 1N T3h 0PT10ns pHI3lD.";
$lang['fieldtypeexample2'] = "tO cr34TE CL1cK48l3 LiNKs ENt3r th3 uRL In tEH opt1ONS fi3lD @nD uS3 <i>%1\$\$</i> WH3R3 teh 3n+ry from tHe u\$3r's pr0ph1l3 should 4PP34R. ex4mpl3s: <p>mY5P4ce: <i>h+tp://www.mysp4ce.c0m/%1\$S</i><br />x80X live: <i>hTTP://pr0PhIL3.MyG4M3rc@RD.N3+/%1\$s</i>";
$lang['editedwordfilter'] = "eD1+ED w0rd f1LTeR";
$lang['editedforumsettings'] = "eDi+ed fORum sett1ngS";
$lang['successfullyendedusersessionsforselectedusers'] = "suCCe\$\$phUlLY 3nd3D s3Ss10N\$ fOR s3L3cted us3r\$";
$lang['failedtoendsessionforuser'] = "f@Il3D T0 3ND se5\$I0N foR U53r %s";
$lang['successfullyapproveduser'] = "suCce\$\$Phully 4pPr0ved us3R";
$lang['successfullyapprovedselectedusers'] = "succ3sSphuLly 4ppr0Ved \$eLEC+Ed u\$erS";
$lang['matchedtext'] = "m4tch3d tEXT";
$lang['replacementtext'] = "r3Pl4c3mEN+ tExT";
$lang['preg'] = "pRE9";
$lang['wholeword'] = "whOle word";
$lang['word_filter_help_1'] = "<b>alL</b> M@+Ch3\$ 494in\$+ tHE Whol3 +EX+ \$O philtEr1n9 Mom +o mum will @LSo Ch@n93 M0m3nt to mumeN+.";
$lang['word_filter_help_2'] = "<b>wH0l3 word</b> mA+Ch3s 49@in5+ Wh0l3 w0rd5 0nLY S0 f1L+eR1nG mom to mum wiLl n0T Ch@n93 MomEN+ to mum3N+.";
$lang['word_filter_help_3'] = "<b>pRe9</b> 4LloWS j00 T0 u\$3 p3rL r39uL4R expR3s\$IoNs To m4tch teXt.";
$lang['nameanddesc'] = "n4mE and de\$cr1p+ION";
$lang['movethreads'] = "m0V3 thre4D\$";
$lang['movethreadstofolder'] = "m0ve +hRE4DS tO F0ld3r";
$lang['failedtomovethreads'] = "failEd t0 M0Ve tHR3ADs to 5p3c1fiEd FolDEr";
$lang['resetuserpermissions'] = "r3SE+ Us3r PErmis\$10NS";
$lang['failedtoresetuserpermissions'] = "fAilED to rese+ UseR pErM1Ss1ons";
$lang['allowfoldertocontain'] = "aLLOW foldER To C0Nt41n";
$lang['addnewfolder'] = "add nEW PH0LDER";
$lang['mustenterfoldername'] = "j00 muS+ ENt3r A PHolDEr n@m3";
$lang['nofolderidspecified'] = "n0 f0lDeR 1d \$peCif13d";
$lang['invalidfolderid'] = "iNVaLId f0ldEr 1D. ch3ck +h4t a pHOLDeR Wi+h th1s 1D 3X1\$T5!";
$lang['successfullyaddednewfolder'] = "suCC3ssphulLy 4dd3D neW ph0LD3r";
$lang['successfullyremovedselectedfolders'] = "sucC3sSfULLY rem0v3d s3lect3D f0ld3Rs";
$lang['successfullyeditedfolder'] = "sUCc35sfuLLY 3dITEd pHolder";
$lang['failedtocreatenewfolder'] = "f@iLed +0 Cr34+e neW F0LD3r";
$lang['failedtodeletefolder'] = "f41L3D +0 D3l3t3 fOLD3R.";
$lang['failedtoupdatefolder'] = "f@1l3D t0 uPD4tE pHolD3r";
$lang['cannotdeletefolderwiththreads'] = "c4Nn0+ d3let3 FOlderS +h@+ STill cOn+41n +hr3@d5.";
$lang['forumisnotrestricted'] = "foRUm 1\$ nOT re\$TRiCt3d";
$lang['groups'] = "gRoup\$";
$lang['nousergroups'] = "no US3R gR0uP\$ h4vE 8e3n set uP. t0 4dd @ gR0up cLICK +eh '@Dd new' 8u++0n below.";
$lang['suppliedgidisnotausergroup'] = "sUppL1ed 91D 1s n0+ @ U5eR 9rOUP";
$lang['manageusergroups'] = "m4n4g3 Us3r Gr0uPs";
$lang['groupstatus'] = "gR0Up S+4+us";
$lang['addusergroup'] = "add usER gRoUp";
$lang['addemptygroup'] = "adD 3MpTy grOuP";
$lang['adduserstogroup'] = "adD USeR5 t0 9RouP";
$lang['addremoveusers'] = "aDd/rEmOv3 u53RS";
$lang['nousersingroup'] = "th3Re @RE NO U5er5 In tHi5 GRoup. 4DD U53R\$ +0 thI\$ Gr0uP 8Y sE@rCHINg ph0r Th3M 8ELoW.";
$lang['groupaddedaddnewuser'] = "sUCcEssfULly 4ddED 9r0UP. 4DD US3rs To +hi\$ 9rOuP 8y \$E4Rch1n9 foR +heM 83lOW.";
$lang['nousersingroupaddusers'] = "tHEr3 @Re NO U\$eR5 in THi5 9R0up. +0 @dD U53rs cL1CK tHe '4dD/RemOv3 usEr\$' Bu++On 83l0w.";
$lang['useringroups'] = "tHi5 u\$Er i\$ @ Mem8ER 0ph +h3 phOll0w1ng 9r0Up\$";
$lang['usernotinanygroups'] = "th1s U\$eR 1\$ n0T IN 4NY USeR 9R0uPS";
$lang['usergroupwarning'] = "n0+3: +hi\$ Us3R M4Y B3 InH3r1t1NG @ddiT1ONal P3rmI\$51on\$ Fr0m 4Ny UseR Gr0up5 L1sTEd 83LoW.";
$lang['successfullyaddedgroup'] = "sUcC35sFULly 4DdEd GRoup";
$lang['successfullyeditedgroup'] = "sUcceSsfUlLy 3di+3d 9r0UP";
$lang['successfullydeletedselectedgroups'] = "sUcCEs5PhUlLY Del3T3d s3lECTeD 9R0UP\$";
$lang['failedtodeletegroupname'] = "f@il3d t0 D3lete 9R0Up %s";
$lang['usercanaccessforumtools'] = "us3R c4N @CCE\$\$ Ph0RUm tO0ls 4nD C4n CReAt3, dEL3TE AND 3D1+ FoRUM5";
$lang['usercanmodallfoldersonallforums'] = "u53r c4n mOd3r4+3 <b>aLL pH0LdERs</b> ON <b>alL phorUms</b>";
$lang['usercanmodlinkssectiononallforums'] = "u53r C@N MoDeR4+3 LInKs \$ECt1on oN <b>alL F0RuMS</b>";
$lang['emailconfirmationrequired'] = "em@il c0NphIRM4T1on R3qUiR3D";
$lang['userisbannedfromallforums'] = "us3r is B4nNeD PHRoM <b>aLl f0ruMs</b>";
$lang['cancelemailconfirmation'] = "c4nC3l 3m4iL coNf1rm4+1oN 4nD 4Llow u\$ER +0 5t4Rt Po5t1ng";
$lang['resendconfirmationemail'] = "rE5end cONPH1Rm4T1on eM41l T0 u\$3R";
$lang['failedtosresendemailconfirmation'] = "f41LED T0 RE5end eM4il C0NF1rm4T1on +0 U\$ER.";
$lang['donothing'] = "d0 No+HiNg";
$lang['usercanaccessadmintools'] = "uS3r h@s @CCES\$ t0 FOrum @dM1n +00l\$";
$lang['usercanaccessadmintoolsonallforums'] = "u53r h4\$ 4cCe55 +0 @dM1n t00LS <b>on 4lL foRUm5</b>";
$lang['usercanmoderateallfolders'] = "u53R C4N MOD3R4tE 4LL pHoldeR5";
$lang['usercanmoderatelinkssection'] = "u\$3R C@N m0d3r4t3 linKs \$ec+1On";
$lang['userisbanned'] = "u53r I5 84nNED";
$lang['useriswormed'] = "u\$3r IS Worm3d";
$lang['userispilloried'] = "us3R I5 piLL0RI3D";
$lang['usercanignoreadmin'] = "uS3r C4N 19nore 4Dm1ni5tR@+0RS";
$lang['groupcanaccessadmintools'] = "grOUp C@n 4CcES\$ @DM1n to0L5";
$lang['groupcanmoderateallfolders'] = "group c4n m0DER@T3 @ll folD3R\$";
$lang['groupcanmoderatelinkssection'] = "grOUp Can moDeR@TE LinKS 53ctIoNs";
$lang['groupisbanned'] = "gR0uP I5 B4nN3d";
$lang['groupiswormed'] = "gr0up 1s worm3D";
$lang['readposts'] = "rE@d p0sT\$";
$lang['replytothreads'] = "r3PLY to +HrE4d\$";
$lang['createnewthreads'] = "cr34tE n3W THRe@d5";
$lang['editposts'] = "eD1T pOS+S";
$lang['deleteposts'] = "d3LET3 Po5ts";
$lang['postssuccessfullydeleted'] = "pO\$ts 5ucCESSPhuLly d3le+Ed";
$lang['failedtodeleteusersposts'] = "f41LED +0 dElEtE user'\$ Po5ts";
$lang['uploadattachments'] = "upL04D @T+@ChM3nt\$";
$lang['moderatefolder'] = "m0D3R4TE phOlD3r";
$lang['postinhtml'] = "p0sT 1n HTmL";
$lang['postasignature'] = "po5+ a SIgNa+Ur3";
$lang['editforumlinks'] = "ed1+ Ph0ruM LiNK5";
$lang['linksaddedhereappearindropdown'] = "lInK5 4ddEd hER3 4pp3@r iN @ DRop down 1n +EH +op r1GH+ oph T3h Phr4M3 \$3t.";
$lang['linksaddedhereappearindropdownaddnew'] = "lInK\$ 4Dded hER3 @Pp34r 1n 4 DROP DowN iN tEH t0P Ri9hT opH tH3 fr@mE \$ET. +o 4dD @ lInK click thE '4dD N3W' Bu+t0N BElOw.";
$lang['failedtoremoveforumlink'] = "f4iLED +o rem0vE PhorUM lINk '%s'";
$lang['failedtoaddnewforumlink'] = "f@il3d To 4dd New Ph0rum lInK '%s'";
$lang['failedtoupdateforumlink'] = "f@1leD TO uPD@+E Ph0ruM L1Nk '%s'";
$lang['notoplevellinktitlespecified'] = "no ToP L3v3l l1nK ti+l3 \$peC1pHIed";
$lang['youmustenteralinktitle'] = "j00 MU5t en+3r A l1nk +1TLE";
$lang['alllinkurismuststartwithaschema'] = "aLL L1Nk Ur1s mU5t 5+4rt w1+h @ sch3m4 (1.e. HtTp://, f+p://, 1rC://)";
$lang['editlink'] = "ed1T liNk";
$lang['addnewforumlink'] = "add NeW PhorUm l1NK";
$lang['forumlinktitle'] = "fORUm l1NK titlE";
$lang['forumlinklocation'] = "fOrUM l1nK loC4+I0N";
$lang['successfullyaddednewforumlink'] = "sucC3ssphuLlY 4DDED nEw ForuM liNk";
$lang['successfullyeditedforumlink'] = "sucC3s5phulLY 3Dit3D FoRuM l1Nk";
$lang['invalidlinkidorlinknotfound'] = "iNv@l1d liNK id Or LiNk n0+ F0unD";
$lang['successfullyremovedselectedforumlinks'] = "succES\$fUlLy r3m0V3D sEL3c+3D LiNkS";
$lang['toplinkcaption'] = "tOp lInk C4pt1on";
$lang['allowguestaccess'] = "aLLow gU3S+ 4CC3ss";
$lang['searchenginespidering'] = "s34RCh En91n3 5p1dER1n9";
$lang['allowsearchenginespidering'] = "aLl0w \$3@rcH 3Ng1NE 5p1DErIng";
$lang['sitemapenabled'] = "eN48lE \$1TEM@P";
$lang['sitemapupdatefrequency'] = "s1t3M4p uPd4+E PhR3QueNcy";
$lang['sitemappathnotwritable'] = "siTEM@P Direct0ry mUs+ bE wR1+48lE BY THe w3B 5eRveR / PHP Pr0c3\$\$!";
$lang['newuserregistrations'] = "n3w u\$ER ReGisTr@+1ONs";
$lang['preventduplicateemailaddresses'] = "preV3nT dupliCate 3ma1L 4dDRES5Es";
$lang['allownewuserregistrations'] = "aLloW N3w u\$er r39is+R@+10NS";
$lang['requireemailconfirmation'] = "r3quIr3 em41L c0NF1rMat10n";
$lang['usetextcaptcha'] = "usE +3xt-CAp+CH4";
$lang['textcaptchafonterror'] = "tEx+-c4p+Cha H4S BE3N dI\$4bLeD @UToM4T1C4LLy 83C@US3 +H3Re 4rE N0 +ru3 +YP3 PH0NTS @v4Il4blE F0r 1t t0 U\$e. pLE@se UPLO4d 5OME tRUe tYPE F0N+S TO <b>t3XT_C4P+CH@/PHOn+S</b> on Y0ur S3RV3R.";
$lang['textcaptchadirerror'] = "teXt-c4p+CH4 h@s 83EN dis48L3d B3c4U\$3 tH3 T3xT_C4P+ch@ DIR3CT0RY 4Nd 5U8-DIREC+oRI3S 4R3 n0t wRi+@8l3 By +eH W3B \$ERv3R / PHp PrOC355.";
$lang['textcaptchagderror'] = "tEx+-cAPtCh4 h4s bE3N D1\$48l3d 8EC4U\$e y0uR s3rVER'\$ PHP \$e+UP D03s N0t PrOV1de SUPPor+ F0r gD 1M49e m4N1puLaTiON 4ND / 0r Ttph phON+ suPpORt. Bo+h arE r3QUiR3D phoR tExt-CaPTCh4 SUPP0r+.";
$lang['newuserpreferences'] = "n3w US3R PrEf3renceS";
$lang['sendemailnotificationonreply'] = "em4iL no+1fiC4t10N 0n rEpLy t0 us3r";
$lang['sendemailnotificationonpm'] = "em41L N0t1pHic4t10N ON pM +O Us3r";
$lang['showpopuponnewpm'] = "sH0w PoPuP WHen r3C3IvIn9 neW Pm";
$lang['setautomatichighinterestonpost'] = "s3+ @U+Om@+1C HiGh iN+3re\$+ 0n pos+";
$lang['postingstats'] = "p0S+1n9 5t@t\$";
$lang['postingstatsforperiod'] = "po5+1N9 \$T@+\$ PHoR PEriOD %s To %s";
$lang['nopostdatarecordedforthisperiod'] = "n0 po\$+ D4+4 R3C0RD3D PhOR +h1\$ p3Ri0d.";
$lang['totalposts'] = "t0+4l POsTs";
$lang['totalpostsforthisperiod'] = "tOT@L p05TS FoR +H1s p3R1Od";
$lang['mustchooseastartday'] = "mus+ Ch0osE @ \$+@rt d4Y";
$lang['mustchooseastartmonth'] = "mu5t CHO0S3 @ 5+4rT m0n+H";
$lang['mustchooseastartyear'] = "must chO0\$3 @ ST@rt y34R";
$lang['mustchooseaendday'] = "mUs+ CH00\$3 @ eND D4Y";
$lang['mustchooseaendmonth'] = "mUSt CH005e 4 3nD Mon+H";
$lang['mustchooseaendyear'] = "mus+ chOOSE @ enD yE@r";
$lang['startperiodisaheadofendperiod'] = "st@R+ p3rIOd 1s @H34d 0pH 3nD P3RIOD";
$lang['bancontrols'] = "b4n COn+Rol\$";
$lang['addban'] = "aDd B4N";
$lang['checkban'] = "cHecK BaN";
$lang['editban'] = "eD1t b4N";
$lang['bantype'] = "b4n tYpe";
$lang['bandata'] = "b4n D4T4";
$lang['bancomment'] = "c0MmEn+";
$lang['ipban'] = "iP B4n";
$lang['logonban'] = "loGOn 84n";
$lang['nicknameban'] = "n1cKN@m3 b4N";
$lang['emailban'] = "em41l B4n";
$lang['refererban'] = "rePh3rER 84N";
$lang['invalidbanid'] = "inV4L1D B@n Id";
$lang['affectsessionwarnadd'] = "tH1S B4n m4y 4ff3Ct t3H F0llOw1NG 4ctiVE U53R \$es5iOns";
$lang['noaffectsessionwarn'] = "th1S b4n 4PHFect5 n0 4c+1vE SE\$5I0N5";
$lang['mustspecifybantype'] = "j00 mUs+ spECify @ 84n +yp3";
$lang['mustspecifybandata'] = "j00 MU\$+ 5PeCIFy \$oM3 8@N d4t@";
$lang['successfullyremovedselectedbans'] = "sUCCE55pHullY R3m0vED \$3l3CTED B4NS";
$lang['failedtoaddnewban'] = "f@il3d +O 4dd new b4n";
$lang['failedtoremovebans'] = "f4ILed t0 R3MOv3 50ME oR 4LL Of +3H 5eL3c+Ed 8@n5";
$lang['duplicatebandataentered'] = "duplIC@t3 b@N D4T@ ENTEREd. Pl3@\$E CHEcK YoUR wILDC4RD5 T0 S3E 1PH TH3Y @Lre4dy m@tch t3h d4T4 eNt3reD";
$lang['successfullyaddedban'] = "suCc35spHully 4Dd3d b4n";
$lang['successfullyupdatedban'] = "succ355PHulLy uPD4t3D 8@N";
$lang['noexistingbandata'] = "theR3 is N0 3xI5+InG B@n D@T4. +o @dd @ B@n CLiCk th3 '4dd NEW' bu+T0n 83l0W.";
$lang['youcanusethepercentwildcard'] = "j00 c@N Us3 +H3 p3rC3NT (%) W1ldC4Rd 5Ym80L 1N ANY OpH Y0Ur 8@n L15ts +0 o8+41N p4rT1@l m4+cH35, I.e. '192.168.0.%' wOULD 84n 4LL IP @Ddr355E5 1n th3 r4n9E 192.168.0.1 +hRoU9H 192.168.0.254";
$lang['cannotusewildcardonown'] = "j00 c4Nn0+ 4Dd % 4S a wiLdc4Rd m4tCh on 1Ts owN!";
$lang['requirepostapproval'] = "r3QUIRE Po5+ @PPROv4L";
$lang['adminforumtoolsusercounterror'] = "th3r3 MU5+ 83 4+ lE@sT 1 U\$er W1+h 4dM1N T00L5 4nd phoRuM T00L\$ 4cC3s\$ ON 4Ll PhOrUMS!";
$lang['postcount'] = "p0s+ CoUNt";
$lang['resetpostcount'] = "re53t p05+ C0uNT";
$lang['failedtoresetuserpostcount'] = "f@IleD +0 rEsEt post COUn+";
$lang['failedtochangeuserpostcount'] = "f41l3D +O CH@N93 UsEr p0s+ C0UN+";
$lang['postapprovalqueue'] = "p0\$+ 4pPR0V4l QUeU3";
$lang['nopostsawaitingapproval'] = "n0 p0sT\$ @R3 4w@1t1N9 4pprOv@l";
$lang['approveselected'] = "appr0vE 5eL3CTED";
$lang['failedtoapproveuser'] = "f41L3D +O 4ppr0v3 U\$eR %s";
$lang['kickselected'] = "k1cK SEL3c+ED";
$lang['visitorlog'] = "v1\$1t0R lOg";
$lang['novisitorslogged'] = "nO visI+0R\$ LoGGed";
$lang['addselectedusers'] = "add \$elec+Ed u\$er5";
$lang['removeselectedusers'] = "r3m0V3 \$El3C+3D u53Rs";
$lang['addnew'] = "aDd n3W";
$lang['deleteselected'] = "d3LETE S3leC+3d";
$lang['forumrulesmessage'] = "<p><b>f0ruM ruL3S</b></p><p>\nRE9iStR4t10N tO %1\$\$ i5 PhR33! W3 D0 INS1S+ +H4+ j00 aBId3 BY +3h RUl3s aND P0lIC1Es DE+41led 8El0W. 1ph J00 49r3e TO TeH TERms, pLe4\$E chEcK +Eh 'I 4grE3' CHeCK8oX 4nD Pr3sS +eH 'R3g1\$+ER' 8ut+0n 8El0W. IpH J00 w0Uld LIK3 t0 c4Nc3L +h3 REgI5trAtI0N, cLiCk %2\$\$ T0 Re+urn +o tH3 ph0ruM5 1ndex.</p><p>\n4l+hOugh THe adM1n1\$+R4+or\$ @Nd mOdEr@T0rs Oph %1\$s WILl at+3mPT +O k3eP 4lL O8j3CTIOn@bL3 MeS\$4g3s 0Phph +HI\$ pHoRum, 1t 1S impOs\$i8LE F0r us +o r3v1Ew 4LL mEs\$a9eS. 4lL m3ss4GEs eXPreSs The vi3Ws 0ph th3 4utHOR, 4nD n3ith3R th3 0wNeRs 0ph %1\$\$, n0r pR0J3c+ B3eH1V3 FoRUm 4nD 1T'\$ 4phfili4+3S w1Ll be heLd re5p0NSIBLe f0r tH3 c0nTent of 4nY mEs54g3.</p><p>\nBy @9REeiNg t0 ThESe RULe5, J00 W4rrant +h@+ J00 w1LL N0t P05+ 4nY MeSs@9e5 tHat 4re 0b5c3n3, Vul94r, \$EXU4lLY-0RIeN+ateD, h4TEfuL, THR34t3n1n9, or 0THErW15E vi0L@+1vE Oph 4NY l4w\$.</p><p>tH3 0wN3r\$ 0f %1\$\$ rESErve t3H RIghT T0 rEMov3, ED1+, mOV3 or ClOsE @nY ThRE4d fOR 4nY RE450n.</p>";
$lang['cancellinktext'] = "h3r3";
$lang['failedtoupdateforumsettings'] = "f@Il3D +o UPD4+3 PH0ruM 5Ett1N9s. pLe4S3 +RY 49@1N L@+3R.";
$lang['moreadminoptions'] = "mor3 4DM1n Op+iOn\$";

// Admin Log data (admin_viewlog.php) --------------------------------------------

$lang['changedstatusforuser'] = "cH4n9Ed u\$er 5+@Tu\$ PhOR '%s'";
$lang['changedpasswordforuser'] = "ch4n93d P4s5w0rD Ph0r '%s'";
$lang['changedforumaccess'] = "ch@n93d ph0rum 4cC3ss p3rm155ions fOR '%s'";
$lang['deletedallusersposts'] = "d3L3+Ed @Ll Po5+s f0R '%s'";

$lang['createdusergroup'] = "cR34+eD us3r 9R0up '%s'";
$lang['deletedusergroup'] = "delet3d u\$er GROuP '%s'";
$lang['updatedusergroup'] = "uPd4+3d u\$3r 9r0up '%s'";
$lang['addedusertogroup'] = "add3d us3r '%s' T0 9RouP '%s'";
$lang['removeduserfromgroup'] = "rEMOvE U\$er '%s' From 9RoUP '%s'";

$lang['addedipaddresstobanlist'] = "addEd iP '%s' +0 8@N Li\$T";
$lang['removedipaddressfrombanlist'] = "rEm0v3D 1p '%s' FROM 84n lIs+";

$lang['addedlogontobanlist'] = "aDDED L0g0N '%s' +O 84N L1ST";
$lang['removedlogonfrombanlist'] = "rEm0V3D L09oN '%s' PhRoM b4N lI\$T";

$lang['addednicknametobanlist'] = "adD3d NiCKN@me '%s' TO B4n lis+";
$lang['removednicknamefrombanlist'] = "r3moVed niCKN@m3 '%s' pHR0M b4N LiST";

$lang['addedemailtobanlist'] = "add3d Em4Il @ddRe5\$ '%s' To 8@N l1\$+";
$lang['removedemailfrombanlist'] = "r3MOVEd 3M@1L @ddr3\$5 '%s' fr0m ban LiS+";

$lang['addedreferertobanlist'] = "adDed r3F3r3R '%s' +O 8@N LIs+";
$lang['removedrefererfrombanlist'] = "r3M0VED R3F3rer '%s' PHr0m 84N L1ST";

$lang['editedfolder'] = "edIt3D PhOld3R '%s'";
$lang['movedallthreadsfromto'] = "m0V3d @LL THr3@DS Fr0m '%s' t0 '%s'";
$lang['creatednewfolder'] = "cRE@t3d nEW pHoLDER '%s'";
$lang['deletedfolder'] = "deLETED F0LD3r '%s'";

$lang['changedprofilesectiontitle'] = "ch@nG3d PR0pH1L3 \$ec+1oN +iTLE pHROm '%s' +o '%s'";
$lang['addednewprofilesection'] = "added n3w pR0F1LE sECT10N '%s'";
$lang['deletedprofilesection'] = "d3l3+3D pr0PHIl3 SEC+10N '%s'";

$lang['addednewprofileitem'] = "aDDeD N3w pRof1L3 1+3M '%s' +O sEC+10n '%s'";
$lang['changedprofileitem'] = "ch4ng3d ProfIlE 1+3M '%s'";
$lang['deletedprofileitem'] = "dEleTeD proPH1l3 i+Em '%s'";

$lang['editedstartpage'] = "eDit3D 5+4rT P@Ge";
$lang['savednewstyle'] = "s4v3D nEw \$tYLE '%s'";

$lang['movedthread'] = "moveD +HrE@D '%s' pHr0M '%s' to '%s'";
$lang['closedthread'] = "clO\$ed thRE4D '%s'";
$lang['openedthread'] = "oPENED thRE@D '%s'";
$lang['renamedthread'] = "rEn4m3d tHr3@D '%s' +0 '%s'";

$lang['deletedthread'] = "deL3+3d tHr3@D '%s'";
$lang['undeletedthread'] = "und3Le+ED +hrE4D '%s'";

$lang['lockedthreadtitlefolder'] = "lockED tHrE4d 0P+IoN\$ 0N '%s'";
$lang['unlockedthreadtitlefolder'] = "uNl0CK3d +HR34d OPt1oNS 0n '%s'";

$lang['deletedpostsfrominthread'] = "dele+3D P0\$+s FrOm '%s' iN tHRE4D '%s'";
$lang['deletedattachmentfrompost'] = "d3le+3d a++4chmEn+ '%s' PHr0M pOs+ '%s'";

$lang['editedforumlinks'] = "eDI+ED f0rum LiNKs";
$lang['editedforumlink'] = "eDitEd F0rUm lINK: '%s'";

$lang['addedforumlink'] = "aDd3D F0rUm L1NK: '%s'";
$lang['deletedforumlink'] = "d3let3D Ph0RuM lInK: '%s'";
$lang['changedtoplinkcaption'] = "cH4nGED +Op l1nk CAPt10N PhR0M '%s' t0 '%s'";

$lang['deletedpost'] = "dElE+3d p0\$+ '%s'";
$lang['editedpost'] = "eDItED PoSt '%s'";

$lang['madethreadsticky'] = "mAdE +hR34D '%s' 5TiCkY";
$lang['madethreadnonsticky'] = "m4de tHRe4d '%s' NoN-\$T1Cky";

$lang['endedsessionforuser'] = "eND3D \$E\$51on F0r uS3r '%s'";

$lang['approvedpost'] = "aPPR0v3d po\$T '%s'";

$lang['editedwordfilter'] = "eDi+3D W0rD PH1L+3r";

$lang['addedrssfeed'] = "addeD r5S FeED '%s'";
$lang['editedrssfeed'] = "ed1+ED R\$5 pH33D '%s'";
$lang['deletedrssfeed'] = "d3l3+3D rSs PHE3d '%s'";

$lang['updatedban'] = "uPd@+3d 84N '%s'. CH4ng3D TyP3 PHrOm '%s' t0 '%s', ch4N9Ed Dat@ pHr0m '%s' TO '%s'.";

$lang['splitthreadatpostintonewthread'] = "spL1T +HrE4d '%s' @T pos+ %s  1nto New ThR34d '%s'";
$lang['mergedthreadintonewthread'] = "mEr9Ed +hre4d5 '%s' 4nd '%s' 1nt0 new thr34D '%s'";

$lang['ipaddressbanhit'] = "uSer '%s' 15 b4NNEd. Ip @DdRe55 '%s' m4Tched 84n D4+4 '%s'";
$lang['logonbanhit'] = "u5er '%s' 15 banN3d. LogOn '%s' m4Tch3d 8@N d4+4 '%s'";
$lang['nicknamebanhit'] = "us3r '%s' 1s 8@nNed. N1Ckn@mE '%s' M@+ch3D 8@n D4t@ '%s'";
$lang['emailbanhit'] = "u\$3r '%s' 1\$ 8@nn3d. 3m@1l @dDR3\$\$ '%s' m4+ched 84N D4+a '%s'";
$lang['refererbanhit'] = "us3R '%s' iS 84NneD. HT+p rEph3rer '%s' M@+ch3d b@n da+4 '%s'";

$lang['modifiedpermsforuser'] = "mOD1fiEd perM\$ F0R us3r '%s'";
$lang['modifiedfolderpermsforuser'] = "modipH1ED f0ld3r p3rm5 Ph0r us3R '%s'";

$lang['userpermfoldermoderate'] = "f0LDER Moder@+0r";

$lang['adminlogempty'] = "admin l09 i\$ emp+y";

$lang['youmustspecifyanactiontypetoremove'] = "j00 mus+ SP3CIfy 4n @ctIon +YPE +0 R3m0ve";

$lang['alllogentries'] = "aLl L09 3n+r135";
$lang['userstatuschanges'] = "u5eR S+4tU\$ CH4n9e\$";
$lang['forumaccesschanges'] = "f0rum 4CC3SS ch4ngES";
$lang['usermasspostdeletion'] = "u\$Er Ma\$S pO5t D3L3+1oN";
$lang['ipaddressbanadditions'] = "iP aDDR3ss 84n 4DD1TioNs";
$lang['ipaddressbandeletions'] = "ip @DDrEsS B4n DeL3T10n\$";
$lang['threadtitleedits'] = "thR34d titlE 3D1+s";
$lang['massthreadmoves'] = "m@Ss tHR3@d movE5";
$lang['foldercreations'] = "f0LDEr Cr3@t1oNs";
$lang['folderdeletions'] = "foLD3r D3L3+i0N\$";
$lang['profilesectionchanges'] = "pROPHile \$ECt1On CH4Nge5";
$lang['profilesectionadditions'] = "pr0FIl3 53Ct10n 4ddi+10ns";
$lang['profilesectiondeletions'] = "prOfil3 \$Ect10n del3t10ns";
$lang['profileitemchanges'] = "pR0Ph1l3 1tem cH4nGe\$";
$lang['profileitemadditions'] = "pRof1L3 1tem @ddi+10n\$";
$lang['profileitemdeletions'] = "pR0PhIl3 I+em dEl3+10Ns";
$lang['startpagechanges'] = "sT4Rt p493 ch4ng3S";
$lang['forumstylecreations'] = "forum s+yl3 Cre@Ti0NS";
$lang['threadmoves'] = "tHr3@d move\$";
$lang['threadclosures'] = "tHrE@d CLO5ur3s";
$lang['threadopenings'] = "thR3@d Op3n1n9\$";
$lang['threadrenames'] = "tHRe4d r3N4m3\$";
$lang['postdeletions'] = "po\$+ D3l3t1On\$";
$lang['postedits'] = "p0st 3d1Ts";
$lang['wordfilteredits'] = "wORd pH1lt3r 3DiTs";
$lang['threadstickycreations'] = "tHR3@d S+Icky CRE4tiON\$";
$lang['threadstickydeletions'] = "tHr3@d \$ticky deLe+1On\$";
$lang['usersessiondeletions'] = "us3r S3s\$1ON D3lETi0ns";
$lang['forumsettingsedits'] = "fORum SE+TiN95 3d1+S";
$lang['threadlocks'] = "tHR34d lockS";
$lang['threadunlocks'] = "tHr34D unloCK\$";
$lang['usermasspostdeletionsinathread'] = "us3R m4\$s post delEti0nS IN @ thr34d";
$lang['threaddeletions'] = "tHRE4d dEletI0N5";
$lang['attachmentdeletions'] = "a+T@cHmen+ d3le+i0N\$";
$lang['forumlinkedits'] = "f0rUm L1NK 3diT\$";
$lang['postapprovals'] = "pO5+ 4PPR0V4l5";
$lang['usergroupcreations'] = "us3R grouP CRE4T1ons";
$lang['usergroupdeletions'] = "u53r GR0Up d3leTi0N\$";
$lang['usergroupuseraddition'] = "us3R gRoup U\$er 4dd1tI0N";
$lang['usergroupuserremoval'] = "u53r grouP U\$er rEM0V4L";
$lang['userpasswordchange'] = "u\$eR P4\$\$w0Rd cH4N9e";
$lang['usergroupchanges'] = "u\$3r 9r0up ch4n93\$";
$lang['ipaddressbanadditions'] = "ip 4DDr3Ss 84n 4ddi+ion5";
$lang['ipaddressbandeletions'] = "iP adDre55 b@N dEl3TI0N\$";
$lang['logonbanadditions'] = "l0Gon 84n @DDi+10n5";
$lang['logonbandeletions'] = "l0g0n 8@N delEtioNs";
$lang['nicknamebanadditions'] = "nickn4m3 B4n @DD1tI0Ns";
$lang['nicknamebanadditions'] = "nIcknam3 b4N @DdI+Ion\$";
$lang['e-mailbanadditions'] = "e-m41l 84N 4DDI+1on\$";
$lang['e-mailbandeletions'] = "e-m@1l B4N delE+10Ns";
$lang['rssfeedadditions'] = "rSS f33d @dD1+i0Ns";
$lang['rssfeedchanges'] = "r\$s phE3D Ch4n93\$";
$lang['threadundeletions'] = "thRe4D undEL3+ion5";
$lang['httprefererbanadditions'] = "h+tP R3f3rer 8@n @dD1+i0N5";
$lang['httprefererbandeletions'] = "h++p R3f3r3r 84n deL3+1ON5";
$lang['rssfeeddeletions'] = "rsS fEeD del3+I0ns";
$lang['banchanges'] = "bAn Ch@N9e\$";
$lang['threadsplits'] = "tHRE4d Spl1+\$";
$lang['threadmerges'] = "thr34d m3R935";
$lang['forumlinkadditions'] = "f0Rum l1nk @dd1+10nS";
$lang['forumlinkdeletions'] = "f0rum l1nK DeLet10N\$";
$lang['forumlinktopcaptionchanges'] = "f0RuM l1nk +op c4P+10n ch@N935";
$lang['folderedits'] = "f0LDER EdItS";
$lang['userdeletions'] = "u5Er d3Le+i0Ns";
$lang['userdatadeletions'] = "u\$Er d4+4 d3l3t10ns";
$lang['usergroupchanges'] = "u53r GrOuP CHaNg3s";
$lang['ipaddressbancheckresults'] = "iP 4DdRE55 8an Ch3Ck rE\$ul+s";
$lang['logonbancheckresults'] = "lO9ON 8@N ChECK RE5ULt\$";
$lang['nicknamebancheckresults'] = "nIckn4M3 b4n ch3ck result5";
$lang['emailbancheckresults'] = "eM4il B4n ChECk r35ult\$";
$lang['httprefererbancheckresults'] = "ht+P ReFerer baN cH3ck resul+s";

$lang['removeentriesrelatingtoaction'] = "r3M0Ve Entri3S r3L4tIng +0 ACt1ON";
$lang['removeentriesolderthandays'] = "r3m0ve ENTR13\$ older +h4n (D@ys)";

$lang['successfullyprunedadminlog'] = "sUcC3s5pHulLy pRuned adM1n l0g";
$lang['failedtopruneadminlog'] = "faIL3d to prun3 4dm1N L09";

$lang['successfullyprunedvisitorlog'] = "suCce5\$fully pRun3d V1\$1T0R l09";
$lang['failedtoprunevisitorlog'] = "f41L3D TO prun3 vi\$1+Or l0G";

$lang['prunelog'] = "pRuNe l0g";

// Admin Forms (admin_forums.php) ------------------------------------------------

$lang['noexistingforums'] = "no 3X1st1ng foRuMs ph0UND. +0 cR3@T3 a n3w F0RUm cl1ck teh '4dd new' 8U++0n BeLOw.";
$lang['webtaginvalidchars'] = "we8+49 caN onLy C0nT4In upP3Rc@s3 4-z, 0-9 @nd Und3rsc0r3 ch4R4c+Ers";
$lang['databasenameinvalidchars'] = "datAB@s3 N4M3 C4n oNlY c0nt41n @-Z, a-Z, 0-9 @nD unDersC0RE char@c+3Rs";
$lang['invalidforumidorforumnotfound'] = "iNV4l1D forUm F1d 0r foRUM N0t f0unD";
$lang['successfullyupdatedforum'] = "suCCeS5fUlly uPDA+ed ph0rum";
$lang['failedtoupdateforum'] = "f41Led TO Upd@t3 f0rum: '%s'";
$lang['successfullycreatednewforum'] = "suCc3\$sPhully CR34+ed N3W ph0rum";
$lang['selectedwebtagisalreadyinuse'] = "the \$ELEc+ed w38+@9 is 4lrE4dY IN uS3. ple4\$3 Cho0S3 @n0tHeR.";
$lang['selecteddatabasecontainsconflictingtables'] = "tHe \$3LeCT3d d@t@b@\$3 c0Nt41N\$ COnpHliCtin9 +48les. confliC+IN9 +4bl3 NAMeS 4R3:";
$lang['forumdeleteconfirmation'] = "are j00 5Ure j00 w4n+ T0 DEl3TE @Ll oF +h3 sel3CTeD f0rUM\$?";
$lang['forumdeletewarning'] = "plE45E n0T3 +H4+ j00 C4Nno+ reC0v3r dEL3+3D f0rUm5. oNCE D3l3TED @ FoRUm 4Nd 4lL 0pH THE @\$5oci4T3D d4t@ iS p3RM4N3n+lY R3MOV3d fR0M TeH DA+@84se. 1pH j00 Do n0+ W1\$h t0 DeLe+3 TeH 5El3CTeD f0ruM5 PL34\$e CliCK C4nCeL.";
$lang['successfullyremovedselectedforums'] = "sucC35sfUlLY D3LE+3d s3L3ct3D f0ruM5";
$lang['failedtodeleteforum'] = "faileD To dELe+eD ForuM: '%s'";
$lang['addforum'] = "add PhORuM";
$lang['editforum'] = "eD1+ PhOrUM";
$lang['visitforum'] = "vIsiT PHorUm: %s";
$lang['accesslevel'] = "acceS5 l3V3l";
$lang['forumleader'] = "forUm Le4deR";
$lang['usedatabase'] = "uS3 Da+@B453";
$lang['unknownmessagecount'] = "unkn0wn";
$lang['forumwebtag'] = "fOrUm wEBT4g";
$lang['defaultforum'] = "dEFaulT FoRUM";
$lang['forumdatabasewarning'] = "pLe45E 3nsUre j00 53L3ct teh C0rREC+ D@T4b4S3 WhEn cRe@+iN9 @ nEw forUM. OnC3 CR3AT3d 4 n3W f0ruM C4nNOt 83 m0veD BE+wE3N @v4Il48le d4T@B4SES.";

// Admin Global User Permissions

$lang['globaluserpermissions'] = "glO84l u\$3R P3rMISsi0Ns";

// Admin Forum Settings (admin_forum_settings.php) -------------------------------

$lang['mustsupplyforumwebtag'] = "j00 MU\$+ suppLy 4 PHORum w3b+49";
$lang['mustsupplyforumname'] = "j00 mu5+ sUppLy @ Forum n@Me";
$lang['mustsupplyforumemail'] = "j00 Mu5+ 5upPlY @ pHORuM 3maIL 4DdRESs";
$lang['mustchoosedefaultstyle'] = "j00 mUs+ choO\$3 4 d3phaUlt F0rum \$TYLe";
$lang['mustchoosedefaultemoticons'] = "j00 Mu5+ CHo05e def4Ul+ forUM em0t1C0nS";
$lang['mustsupplyforumaccesslevel'] = "j00 Mu\$T suPplY 4 fORUm AcC35S L3Vel";
$lang['mustsupplyforumdatabasename'] = "j00 mUST suPPLY 4 f0RuM D4t4bAS3 N@ME";
$lang['unknownemoticonsname'] = "unkn0Wn 3mOt1COnS N4mE";
$lang['mustchoosedefaultlang'] = "j00 MU5+ Ch00s3 @ D3f4UL+ f0Rum L@NgU4G3";
$lang['activesessiongreaterthansession'] = "aC+iv3 s3\$5i0n +1M3ou+ c@Nn0t b3 gRe@t3r Th@n \$35S1oN T1M3oUt";
$lang['attachmentdirnotwritable'] = "a++4chm3N+ dIrEC+0Ry 4nd sy5+em +3MP0R4rY DIrec+0RY / pHp.iNi 'uPlo4D_+Mp_d1R' mU5+ Be WriT48le BY +He w38 S3rveR / pHp Pr0cess!";
$lang['attachmentdirblank'] = "j00 mus+ supPLY 4 dIr3C+0ry +O \$4v3 4+TaChm3NtS in";
$lang['mainsettings'] = "m@in 53tTiNgs";
$lang['forumname'] = "f0Rum N4m3";
$lang['forumemail'] = "forum em@IL";
$lang['forumnoreplyemail'] = "no-rePly 3m@Il";
$lang['forumdesc'] = "f0RUm D3scR1PtI0n";
$lang['forumkeywords'] = "f0RUM k3YworD5";
$lang['defaultstyle'] = "d3ph4ULt s+Yle";
$lang['defaultemoticons'] = "dEf4ult em0TiCONs";
$lang['defaultlanguage'] = "d3Ph4uLt l4ngU493";
$lang['forumaccesssettings'] = "f0rUm 4cc3Ss SEt+1n9\$";
$lang['forumaccessstatus'] = "f0RuM aCC3s5 5TaTu\$";
$lang['changepermissions'] = "ch4nge p3rmiSS1ONS";
$lang['changepassword'] = "cHan9e p@55W0RD";
$lang['passwordprotected'] = "pA\$SWORD pro+EC+3D";
$lang['passwordprotectwarning'] = "j00 H4ve no+ s3T 4 PhoRUM p@\$\$worD. iF J00 dO NOT s3t 4 p@ssw0rD thE P@sSw0Rd prO+3C+1On fUnc+I0naL1+y w1LL 8E @U+0M4+iC4lly Di54bleD!";
$lang['postoptions'] = "p0S+ 0P+Ion5";
$lang['allowpostoptions'] = "aLl0w p0\$T EdI+iN9";
$lang['postedittimeout'] = "p0St EdIT +Im3Ou+";
$lang['posteditgraceperiod'] = "pO5t Ed1t 9R4C3 p3RIOD";
$lang['wikiintegration'] = "wIk1w1ki 1N+39r@T1On";
$lang['enablewikiintegration'] = "en48l3 WiK1WiKi iNtE9R4+I0n";
$lang['enablewikiquicklinks'] = "eN4bL3 WIk1wIk1 qU1Ck l1nk\$";
$lang['wikiintegrationuri'] = "wiK1W1ki LoCati0n";
$lang['maximumpostlength'] = "m@XimuM po5+ LEngTh";
$lang['postfrequency'] = "p0sT fREQuenCy";
$lang['enablelinkssection'] = "eN4ble l1nKS 53C+Ion";
$lang['allowcreationofpolls'] = "aLL0w CRE4+1ON of POlls";
$lang['allowguestvotesinpolls'] = "aLl0w 9Ue\$t\$ T0 V0+E In P0lL5";
$lang['unreadmessagescutoff'] = "unr3@D m3\$\$4935 cu+-oFf";
$lang['disableunreadmessages'] = "d1S48L3 unrEaD m3\$S49E\$";
$lang['thirtynumberdays'] = "30 DAy5";
$lang['sixtynumberdays'] = "60 daY5";
$lang['ninetynumberdays'] = "90 d@ys";
$lang['hundredeightynumberdays'] = "180 d@Ys";
$lang['onenumberyear'] = "1 YE4R";
$lang['unreadcutoffchangewarning'] = "dePenD1n9 0N seRVER p3RpHORm4nc3 4nD +3h nuMb3r 0f +hr34d\$ y0uR pHoRum\$ CoN+A1N, Ch@nG1n9 +3h UnRE@D CU+-0pHPH m4Y +4K3 sEveR4l minUT3\$ +0 ComPLETe. f0r +H1\$ R34son i+ IS REC0mm3Nded tha+ J00 @vO1d CH4n91ng ThiS s3tt1ng wH1l3 yOur pH0rUms are 8usy.";
$lang['unreadcutoffincreasewarning'] = "iNcRe4\$in9 the unR3@d Cu+-0fph will Re\$uLT in tHR3aD5 oLD3r +H@N tH3 CuRR3Nt cUt-0ff 4pp3@r1NG @s unre@D pH0R 4ll U\$3R5.";
$lang['confirmunreadcutoff'] = "aR3 J00 \$ure J00 w@Nt To CH4ngE tH3 Unr34D cu+-ophPh?";
$lang['otherchangeswillstillbeapplied'] = "cLIckin9 'no' wiLL only CanCel +he UnR34D cUT-Ophph Ch4ng3S. 0tH3r Chan93S you'v3 m4D3 wIll 5t1Ll Be s@V3d.";
$lang['searchoptions'] = "sE4RcH 0p+iOnS";
$lang['searchfrequency'] = "sE4rCh fr3qu3NCy";
$lang['sessions'] = "se5\$I0Ns";
$lang['sessioncutoffseconds'] = "s3S\$ioN CuT 0pHf (seconDs)";
$lang['activesessioncutoffseconds'] = "aCT1v3 sE\$s10N Cut 0fF (sEcoNdS)";
$lang['stats'] = "s+@TS";
$lang['hide_stats'] = "hiD3 St@+S";
$lang['show_stats'] = "sHOw \$+@+s";
$lang['enablestatsdisplay'] = "eN@BL3 \$T@ts DI5pL4Y";
$lang['personalmessages'] = "p3rs0NAl mEs\$@93s";
$lang['enablepersonalmessages'] = "eN48l3 p3rsOn@l M3S5@gE\$";
$lang['pmusermessages'] = "pM M3s\$@GeS p3r Us3r";
$lang['allowpmstohaveattachments'] = "allow per50nAl MESS@9E5 +0 H@V3 4T+4chM3n+s";
$lang['autopruneuserspmfoldersevery'] = "auto PRUnE U\$ER's pM FoldER\$ 3V3ry";
$lang['userandguestoptions'] = "user 4Nd GUe\$t 0pTiOn5";
$lang['enableguestaccount'] = "eN4Bl3 Gu3\$t 4CCOUn+";
$lang['listguestsinvisitorlog'] = "lIST 9Ue5+5 iN v1S1+0R Lo9";
$lang['allowguestaccess'] = "alLOw Gu3S+ @CC3ss";
$lang['userandguestaccesssettings'] = "u\$3r @nD 9U35T 4Cc3S5 s3++1n9s";
$lang['allowuserstochangeusername'] = "aLLOw u\$ErS +0 ch4ng3 u\$ERn4me";
$lang['requireuserapproval'] = "rEQUIRE usEr ApPr0v@L 8y 4dMiN";
$lang['requireforumrulesagreement'] = "r3Qu1R3 us3r +o @9rEE +O pHoRuM Rul35";
$lang['sendnewuseremailnotifications'] = "sEnd n0+1Ph1C4t10n T0 glo84L Ph0rUM oWn3R";
$lang['enableattachments'] = "en48le @+t4ChmENt\$";
$lang['attachmentdir'] = "aTT4CHM3nt D1R";
$lang['userattachmentspace'] = "a++@CHM3nt 5PaCE pER UsEr";
$lang['allowembeddingofattachments'] = "alloW 3m8EddinG opH @+t@cHM3N+S";
$lang['usealtattachmentmethod'] = "uSe @L+ERn4Tiv3 4T+@CHMeN+ m3+HoD";
$lang['allowgueststoaccessattachments'] = "aLLOw 9Ue5+S To @CCESs 4T+4CHmEnt\$";
$lang['forumsettingsupdated'] = "fOrum 5e++in9s \$uCc3\$5fullY uPD@+ED";
$lang['forumstatusmessages'] = "foRUM 5+@TU\$ me\$54G3s";
$lang['forumclosedmessage'] = "foRUM CLO5Ed m35S@GE";
$lang['forumrestrictedmessage'] = "f0rum ReSTr1c+3D MeS54G3";
$lang['forumpasswordprotectedmessage'] = "f0RuM p455w0rD PROT3ctEd m3S\$@gE";

// Admin Forum Settings Help Text (admin_forum_settings.php) ------------------------------

$lang['forum_settings_help_10'] = "<b>p0St 3d1t tiME0U+</b> is T3H +1M3 1n MINUt3s 4ft3R P0st1n9 Th4t A u\$Er CAn EdiT the1r p05+. 1f SeT To 0 tH3Re 1s No LIm1T.";
$lang['forum_settings_help_11'] = "<b>m4x1mum pos+ len9th</b> Is tH3 m4ximuM numB3r oph cH@r4CT3Rs +h4t wiLl 83 D1spl4y3D 1N 4 P0\$t. 1Ph @ po\$+ 1s l0NG3R Th4N +H3 nuMB3R 0ph ch4R4Ct3R5 DEFIn3d heRe 1+ W1Ll 83 cut \$H0R+ 4nd @ l1nk 4DDEd +o TEh 8OT+0m to allow us3r5 t0 r3AD +HE WH0l3 posT 0N 4 \$ep4r4te p@g3.";
$lang['forum_settings_help_12'] = "if j00 DoN't Want y0Ur Users +0 8E 4blE to cRE4te p0lLs j00 c4n D1S48L3 thE 4B0ve op+1on.";
$lang['forum_settings_help_13'] = "the lINKS seCT1on 0f BEehiV3 pr0vId3\$ 4 pl4C3 F0r youR u\$3r\$ t0 m@1N+a1n a lIsT 0ph \$It3\$ TH3y fR3qU3n+lY vis1+ +haT o+hEr u\$er\$ m4y pH1Nd US3PHuL. L1Nk5 C4N 8e d1v1DED inTo C@+3gOR135 by Ph0ldeR 4Nd 4llOw f0R comm3nt5 @ND R@tin9S to B3 gIVEn. iN 0Rd3r to MOD3R4te +H3 Links S3ct10N 4 uS3R MUS+ 8E RAnt3D Gl08al mOD3R4tor \$+a+uS.";
$lang['forum_settings_help_15'] = "<b>s3s5i0n cu+ 0phPH</b> I\$ +he M@x1MUm +IMe 83F0r3 @ u\$3r'S seSsi0N 1\$ D33MEd d3Ad @nd +hey 4Re lOG93D oUT. by d3pH4uLT +Hi5 IS 24 Hours (86400 53conDS).";
$lang['forum_settings_help_16'] = "<b>aC+IVE \$e\$sion cuT 0pHph</b> I\$ t3h m4XiMUm t1M3 B3PHor3 @ u\$Er's 53\$510n i\$ d33M3D 1NAC+iv3 @+ Wh1ch pO1nT TH3y 3n+3r 4n 1Dl3 ST4TE. in +hi\$ S+4t3 +3h useR R3M@1n\$ lOgg3d in, 8Ut +hEY 4r3 REm0v3d fr0m +h3 4C+1V3 uSERs l1ST in +3h \$+4Ts D15PL4Y. oNce +H3Y Becom3 Ac+1VE 494IN +H3Y WilL B3 r3-@dd3d +0 +H3 l1\$T. by d3f4ul+ Thi\$ S3+T1N9 i\$ \$3+ t0 15 minU+3S (900 s3C0nds).";
$lang['forum_settings_help_17'] = "eN@8l1N9 +his 0Pt1oN @Llow5 B3EhIv3 +0 INCLUD3 4 ST@ts D15PL4y 4+ th3 80+t0M 0pH t3h m3\$\$Age5 p4NE s1m1l4r +o +he onE USED 8Y m4nY ForUm softW4r3 +1+L3\$. oNce Ena8LEd +H3 d1spL4y oPH +eH St@+S P49E c@N Be to9gLEd 1nD1viDu4lLy bY 3@cH u\$eR. If +hEY D0N'+ w4n+ +0 \$33 I+ +h3Y C4N H1d3 i+ pHrom vi3w.";
$lang['forum_settings_help_18'] = "pER\$0N4L mes\$4g35 4r3 1nv4Lu@bl3 4S 4 W4y 0f t4k1NG M0R3 PR1v@+3 M4tter\$ 0ut oPh vI3W OPH +H3 0THER mEM83r5. hoW3vER 1ph J00 dON'+ W@N+ y0ur us3rS To BE @8L3 T0 53nd 3aCh oTH3R P3R\$on4l m3\$S@9e5 J00 c4N D1s@BL3 this 0pt10N.";
$lang['forum_settings_help_19'] = "p3R50N4l ME\$5ageS C4N 4l\$o CON+@In 4TT@ChM3NTS WHIch c4n BE U53PhUl F0r exch4N9inG F1l3S betWeEN U5eRs.";
$lang['forum_settings_help_20'] = "<b>nOte:</b> THE sp4c3 @lLOC4ti0n pH0r pM 4T+aCHM3N+\$ 15 +4k3n fR0m e@cH U\$3rS' m41N Att4cHmEN+ 4llOC@+10n @nD 1s nOt In AddiT10n +o.";
$lang['forum_settings_help_21'] = "<b>eN@8le Gu35+ @CcOUNT</b> 4LLOWS vI\$i+0Rs t0 8rOwS3 y0UR f0ruM 4Nd Re@d P0\$t\$ WITH0uT r3G1\$+3RiNg 4 U5ER @Cc0UnT. 4 U5eR 4cC0UNT 15 \$+1ll R3Qu1r3d IF +hey wISh tO p0\$+ Or CH@n9E U\$3R pR3Ph3R3nce5.";
$lang['forum_settings_help_22'] = "<b>lisT 9u3S+5 1N VIs1+0R lo9</b> @LLOw5 j00 +o sP3CifY wHe+h3r or n0+ uNregI5+3R3d U\$3r\$ 4Re liStEd on +h3 V151tOr l0g 4l0NG51De r39iS+Ered usErs.";
$lang['forum_settings_help_23'] = "b3EHiv3 4lL0wS a+t4Chmen+5 t0 b3 UpL0@d3d T0 m35\$493S wh3n P0\$T3d. IPh J00 H4VE lim1+Ed W3b sp@c3 j00 MAY whICh t0 D1\$a8Le @++4chMeN+s by Cl3Ar1N9 TEh B0x 480ve.";
$lang['forum_settings_help_24'] = "<b>att4ChmEnt d1R</b> 1S +H3 LOC@+1On 83Eh1V3 Sh0uLd S+oRE 4Tt4chm3n+S in. th1\$ dIr3c+ORY mU\$+ 3XiS+ 0n y0ur web SPACe 4nd mUst B3 wRi+4ble 8Y tHE WE8 S3rv3R / PhP prOc3s5 0TherWIS3 upl04Ds WIll F4il.";
$lang['forum_settings_help_25'] = "<b>a++achMeN+ \$PAce per u\$3r</b> i\$ +HE M4x1MUM @m0uN+ 0F disk 5p4c3 4 u5Er h4\$ phor aTtACHM3N+\$. 0NcE +Hi5 Sp4ce i\$ u53D uP t3h u53r C@nn0+ uPLo@d @Ny mor3 @Tt4chments. 8y deph@ul+ +HIS i\$ 1m8 OF sPac3.";
$lang['forum_settings_help_26'] = "<b>alL0W Em8EDD1ng OF 4t+4chm3nts 1N M3S\$4GE\$ / SI9N4+ur35</b> 4lLoW\$ UserS +O 3MbeD @Tt4chm3NTs iN P0\$+s. 3n@8l1n9 +H15 0p+i0N Whil3 U53FuL CaN incrE4\$e Y0UR 84ndwiDTH u\$@gE Dr45+Ic4LLy undER c3rta1n C0nf1gura+10NS OF php. 1PH J00 H@v3 L1MI+ed 8@ndW1d+h it i5 R3cOmMeND3d +H4+ j00 disA8LE TH1\$ oP+10N.";
$lang['forum_settings_help_27'] = "<b>use 4lTeRN4t1v3 A++@chmeN+ m3+hod</b> PhORCe\$ BE3hiV3 T0 US3 4n alT3Rn@+IV3 r3tRI3v4l M3+Hod f0r 4tt4cHM3n+\$. 1F j00 REc31ve 404 errOR MEs54g35 WhEN try1NG t0 D0wNL04d 4+t@cHm3N+\$ FrOM me\$S@93s +ry 3n48L1ng +his op+1On.";
$lang['forum_settings_help_28'] = "tH353 S3tTing\$ @LLOws y0ur phOruM +O B3 Sp1D3rEd 8y \$e4rcH eN9in3\$ L1K3 9O09l3, 4l+@v1st4 @nd y@HO0. IPh j00 Sw1+ch TH1\$ OPTi0n 0ff y0uR forum w1Ll N0t 8e 1nclUd3d 1n th3s3 sE4RCH 3N9IN3S R3\$ul+s.";
$lang['forum_settings_help_29'] = "<b>alLOw N3W U\$3R R3g1\$+r@t1On5</b> @LL0ws 0R dis4lLow5 t3h CR3@+10N 0f nEw user @CcouN+\$. SEt+Ing +he Op+I0n to No c0MPL3t3lY dI\$48Le5 tH3 R391StR@TIoN ph0rm.";
$lang['forum_settings_help_30'] = "<b>eNAble w1k1w1ki 1N+39R@TiON</b> pROvIde5 W1kIWoRd SUPp0rT 1n yOUr forUM pOs+\$. 4 W1kiW0rD 1\$ M@d3 Up 0PH +w0 0r mor3 c0NC4+3n@+3d W0rDs WIth upp3Rc@sE L3T+3Rs (0ph+3n REpHErred t0 4s C@melc4S3). 1f j00 wriT3 4 w0rd +h15 w4y it w1ll 4utOm@t1c@Lly 8e Ch4N93d in+0 @ hYp3Rl1nK PoiN+1NG To y0ur Ch0\$3n W1KIw1k1.";
$lang['forum_settings_help_31'] = "<b>en4ble WIkiw1ki quiCk Link\$</b> En@8L35 tHE u\$3 0F m\$9:1.1 4nd u53r:l090n s+yLe eX+3nDEd w1KILink\$ wh1ch cr34+3 HYPerliNK5 +o tHE \$Pec1F1ed mes54ge / u53r propHiL3 0f +3h 5p3c1F1eD Us3r.";
$lang['forum_settings_help_32'] = "<b>wikIW1ki L0c4TIon</b> I5 U\$eD t0 \$pecify +he urI 0f y0Ur WikiwiK1. WHEN 3N+er1N9 +h3 Ur1 u53 <i>%1\$\$</i> +o iND1c4T3 wH3r3 iN +H3 ur1 +he WIkIw0Rd SHoUlD 4ppe4R, i.E.: <i>hT+P://EN.w1kiPEDI4.Or9/WiKi/%1\$S</i> W0uLd l1nk y0UR w1kIWords To %s";
$lang['forum_settings_help_33'] = "<b>foRUm @cc355 \$+4+Us</b> c0n+rol5 How us3R\$ m4y ACC3Ss youR forum.";
$lang['forum_settings_help_34'] = "<b>op3N</b> w1ll 4lL0w 4ll us3R\$ @nd gU35tS @cC3S\$ +o Y0ur phorUm With0uT R3S+R1ction.";
$lang['forum_settings_help_35'] = "<b>cL053D</b> pr3V3NTs 4cCe55 F0r @Ll uS3r5, w1tH th3 ExC3pT10n oF the 4dm1N WHo M4y s+1Ll 4cC3S\$ +3H 4dmIN p4n3l.";
$lang['forum_settings_help_36'] = "<b>rE\$Tric+ed</b> 4ll0w5 t0 s3+ @ LIs+ of uSers wH0 4r3 4LLOwEd 4CCE\$s +0 yOur F0ruM.";
$lang['forum_settings_help_37'] = "<b>pas\$w0rD pRo+3cT3d</b> 4LLOwS j00 T0 SET @ p@5\$wORD +o 91V3 0uT +0 U\$ers \$O +Hey C4N 4cC3Ss y0uR pHoRUM.";
$lang['forum_settings_help_38'] = "wh3n 53t+1ng Re5TricTed 0r p@ssW0rd Pr0teCteD Mod3 J00 wiLL n33d +0 s4ve your ch4n93s 8eF0r3 J00 C4n Ch@n9e +h3 uS3R 4cc3sS priv1Le9Es oR p@\$sw0rd.";
$lang['forum_settings_help_39'] = "<b>Search Frequency</b> defines how long a user must wait before performing another search. Searches place a high demand on the database so it is recommended that you set this to at least 30 seconds to prevent \"search spamming\"fR0M K1lL1NG teh \$erv3R.";
$lang['forum_settings_help_40'] = "<b>p05t FREQuEnCY</b> Is +H3 m1n1mUm t1me @ uS3r mu5+ W41+ 83ph0RE +HEy c4n P0S+ 4G@1N. th1s \$3+t1NG al\$0 @ffeCtS tEh crea+ion OpH poll5. 53+ +O 0 +o d1s48le the r35Tr1cti0N.";
$lang['forum_settings_help_41'] = "th3 a8ov3 opt1ons CH4ng3 t3H deF4ul+ v4LU3s for TH3 us3R r39is+R4+i0N f0RM. wh3RE 4ppl1c4Bl3 O+H3r se+t1ng\$ w1ll us3 t3h forum's owN d3FauLt \$3T+ing5.";
$lang['forum_settings_help_42'] = "<b>prEV3Nt U5e 0ph dUpl1c@tE 3m@1l 4DdrE\$s35</b> phoRc3\$ B3eHIV3 to CheCK +3H u\$er 4cCOUN+S @g41nsT tHe 3MAiL 4DdrEss tH3 us3r is ReGis+ERin9 w1+h @nD proMp+S +h3M T0 U\$e 4no+h3r ipH 1t i\$ AlrEady IN US3.";
$lang['forum_settings_help_43'] = "<b>rEqu1rE Em4il c0nF1rm4+iOn</b> WH3n En4bL3d W1lL s3ND 4N 3m41l +0 EACH n3w U\$ER WiTh 4 lInK +h@t c@n 8e US3D to cOnF1rm +HEiR 3m@iL @DDres5. UnTiL +h3y C0nf1rm tHe1r 3m41L @DDrEs\$ Th3Y w1ll N0t 83 4bLE T0 po5+ UnL35S +heir u5eR permis5i0N5 @r3 ch@ng3D m4NU4Lly by @n @Dm1n.";
$lang['forum_settings_help_44'] = "<b>usE +ex+-C@P+ch4</b> prE\$3n+S t3H n3W USER W1tH A M@n9l3d im4g3 WhiCh ThEY mUst C0pY A nUmB3r phr0m inTo @ +ext pHi3LD 0N +HE reG15+r4tI0n phORm. Us3 th1\$ opT10n +o preveNT 4Utom4+3d 5IgN-up vi4 scr1p+S.";
$lang['forum_settings_help_47'] = "<b>poST 3Dit gR@CE P3rI0D</b> @ll0ws j00 +0 Deph1Ne 4 p3R10D 1n minUTe\$ wherE Us3Rs M@y 3Di+ po\$+\$ W1+hout +eh 'EDiT3d By' tex+ @PpE4r1ng 0N th31R P0st\$. 1f 5e+ tO 0 tH3 '3d1+eD 8Y' T3xt WILl ALw@Y\$ 4ppe4r.";
$lang['forum_settings_help_48'] = "<b>unre4D me\$s49Es CUt-0PHF</b> \$P3c1f13S how loN9 M3\$5@9es rEm@1n unrE4d. tHre4d\$ MoD1F13D no l@+3r +H4n +Eh p3R1OD \$3L3c+ED w1ll 4uTOm4+icAlly appe4r 4s Re4D.";
$lang['forum_settings_help_49'] = "choosing <b>d1sabLe UnRe@D m3SS@gE5</b> will complEt3ly R3mOvE uNrE4d mESs@9E\$ \$UPp0rt 4nd rEm0v3 +3H Rel3v@Nt 0p+I0ns phR0m thE diSCu5\$ion typ3 DrOp Down 0n THE +HR34d LI\$T.";
$lang['forum_settings_help_50'] = "<b>reQU1r3 us3r 4PpRov4L BY @Dm1n</b> 4LLow5 j00 +o r3\$TRiCT 4cC3\$5 BY NeW useR5 uN+1l +heY H4Ve 83EN 4ppr0v3d By 4 m0dER4+0r 0R 4dmin. W1ThOu+ 4PproVAl @ us3R C4nn0t 4cCEss 4NY @r34 0F +eH 83EhIv3 forUm ins+@LL@t10N 1NcLuD1nG 1NDiviDu4L PhoRums, pm in80x @nD mY PH0rum\$ \$ECt1oN5.";
$lang['forum_settings_help_51'] = "u\$E <b>clo\$eD me\$S4gE</b>, <b>r3\$Tr1ct3d M3s\$@9e</b> @nD <b>p@sSWOrD pro+3ct3d m3\$54ge</b> to CU\$TOm1s3 teh me\$S@ge D1Spl4YED wh3N u\$ERs 4cCEss your forUm iN +HE v4ri0U\$ St4Te\$.";
$lang['forum_settings_help_52'] = "j00 C@N usE h+ML in y0ur M3\$S4G3\$. hypErL1nk5 @Nd 3maiL 4dDr3sSEs w1ll 4Ls0 83 AuTom4tic@llY conV3rt3d +0 l1nks. +O u\$3 +h3 D3ph4ulT B3eh1Ve phOrum m3\$\$A93S Cl34R +h3 ph13lds.";
$lang['forum_settings_help_53'] = "<b>aLl0w us3Rs +o cH4ngE us3RNaMe</b> P3rm1+S 4Lr34DY reG1STereD us3Rs +O Ch@n9e tHe1R u5erN@m3. wheN 3N4blED j00 c@n tR4Ck +h3 CH@N9e\$ 4 U5eR M@k35 t0 tH3iR u\$3Rn@Me Vi@ +He 4dm1n us3R t00Ls.";
$lang['forum_settings_help_54'] = "uSE <b>fORuM rUlEs</b> +O enT3R 4n 4CCEPT4bLE us3 p0lIcY THA+ 34Ch useR mu5T @9r3e to BephoRE R3g15ter1n9 on Your Ph0rum.";
$lang['forum_settings_help_55'] = "j00 C4n Us3 htMl 1n Y0UR pHorum RUl3\$. hyP3rl1Nk\$ @ND 3M4IL 4DdRES53\$ W1ll 4L\$O 83 4uToM4TIC4lLY cONvertEd t0 lINk\$. t0 usE +H3 deF@uLT BeEhIvE fORum 4up cL34r Teh fI3LD.";
$lang['forum_settings_help_56'] = "uSE <b>n0-r3pLy Em@1l</b> +o sp3c1Fy aN 3M@1l 4dDR3\$S th@T doe\$ nOT eXis+ or w1lL n0+ 83 m0N1+oreD F0r r3pliE5. This 3M4Il 4DdrEs\$ WIll bE U\$ed 1n +h3 he@d3R5 f0r @Ll eM@1L5 sen+ From y0ur Ph0rUm includIN9 8u+ No+ L1M1TED t0 po\$+ 4nD pm nO+1F1c@+10ns, User eMA1lS 4nd pA\$swOrd rem1NDers.";
$lang['forum_settings_help_57'] = "it 1S R3CoMm3nd3D th@+ J00 usE 4N 3m4IL 4Ddre\$s tH4+ d0eS n0+ 3XiS+ tO h3lp cuT Down on 5pAM +H4+ m@y bE d1RECt3d 4+ Y0UR Main pHoRum 3M4il 4dDrE\$S";
$lang['forum_settings_help_58'] = "in @dd1+1oN +0 simPl3 \$pID3r1ng, 8E3H1Ve C4n al\$O 93N3r4tE 4 5iT3M4p f0r teH F0RuM +0 m4K3 IT E4\$13r foR S3@rcH 3Ng1NE\$ t0 f1nD anD 1ndEX +eh mess4gE\$ PosTED 8y y0Ur U\$3RS.";
$lang['forum_settings_help_59'] = "s1Tem@ps are @utoM@+1c4lly \$@v3d to th3 SI+3m4pS Su8-D1rect0ry 0ph y0uR BEEHiv3 f0rum 1n\$T4LLAtion. 1PH tH1s DiR3C+0ry doesN't 3X1\$t j00 MuSt cR34t3 It @nD 3nSur3 +H4+ 1t i\$ Wr1+@8lE BY t3H S3Rv3r / php pr0C3\$\$. +o 4llow SE4rCh en91nEs to finD yOUR s1TEM4p j00 mu\$t 4dd Teh url tO yOuR r080+s.Txt.";
$lang['forum_settings_help_60'] = "dePeNDING 0n s3rV3R perfORm4NcE 4nD t3h Num8er oPH phorum\$ @nd +hrEads yoUr 8e3h1V3 1n\$+4ll@t10N C0nT@in5, G3n3RA+Ing 4 5it3m4p m4y TAKE sEV3R@L Minut3\$ to Complete. iph p3rph0rm4nC3 Of Y0UR \$3rver iS ADV3R5elY 4fFEc+ed 1T 1\$ R3cOMm3nD J00 di\$aBl3 gener@+1ON Of +eh \$1T3m@p.";
$lang['forum_settings_help_61'] = "<b>s3ND Em41L nOtiphIC4t1On +o 9L08Al 4dm1n</b> wH3N en@8LED W1ll \$EnD AN 3m4Il +0 th3 9LO8@l F0RuM oWN3r\$ whEn 4 nEw u53R @CC0Un+ i\$ cR3A+3d.";

// Attachments (attachments.php, get_attachment.php) ---------------------------------------

$lang['aidnotspecified'] = "a1D N0+ speCiph13D.";
$lang['upload'] = "upL0ad";
$lang['uploadnewattachment'] = "uplo4d NEw at+@ChM3NT";
$lang['waitdotdot'] = "w@1+..";
$lang['successfullyuploaded'] = "suCC3\$\$PHully upL04ded: %s";
$lang['failedtoupload'] = "f@1l3D +o Upl04D: %s. CHEck Phre3 4++@chm3n+ sp4ce!";
$lang['complete'] = "cOMpl3te";
$lang['uploadattachment'] = "upLO@d 4 filE FOr 4++4chmen+ tO +He MEs\$@9E";
$lang['enterfilenamestoupload'] = "eN+ER fiL3n4m3(\$) +o upl04D";
$lang['attachmentsforthismessage'] = "a++4ChM3NTs f0r this m3sSagE";
$lang['otherattachmentsincludingpm'] = "otheR 4tt4chm3nt\$ (iNClUd1n9 pM m3sS@93S 4nd Other f0RUms)";
$lang['totalsize'] = "t0T@l sizE";
$lang['freespace'] = "fre3 5p4c3";
$lang['attachmentproblem'] = "th3re W@s a pR0bLeM downl04d1n9 THIs 4+T4chMEnt. PL3AS3 try @9@1N l@t3r.";
$lang['attachmentshavebeendisabled'] = "a+T4cHm3Nt\$ H@Ve B3En D1548leD By +He Ph0rum 0wn3r.";
$lang['canonlyuploadmaximum'] = "j00 C4n 0nlY Uplo4D 4 M4X1mum 0ph 10 F1lE\$ 4t 4 tim3";
$lang['deleteattachments'] = "d3le+3 4++4Chments";
$lang['deleteattachmentsconfirm'] = "aR3 J00 sur3 J00 w4N+ +0 D3l3+E Th3 s3L3c+ED 4TtaChmEnTS?";
$lang['deletethumbnailsconfirm'] = "ar3 j00 \$UrE J00 W4n+ T0 d3Le+3 tHe s3lEC+3D 4++4ChM3N+\$ THUmbn@1L5?";

// Changing passwords (change_pw.php) ----------------------------------

$lang['passwdchanged'] = "p4S\$WOrD CH4N93d";
$lang['passedchangedexp'] = "y0Ur P@sSw0rd hAS 8e3n ch@n9Ed.";
$lang['updatefailed'] = "upD4Te f4ILed";
$lang['passwdsdonotmatch'] = "p4sswords do No+ m4tcH.";
$lang['newandoldpasswdarethesame'] = "n3W 4ND OLD p@55w0Rd5 4r3 tH3 54ME.";
$lang['requiredinformationnotfound'] = "r3qUIr3d INph0RM4+10n NOt PhOUnd";
$lang['forgotpasswd'] = "for9O+ P@5Sw0Rd";
$lang['resetpassword'] = "r353t P4S\$w0rd";
$lang['resetpasswordto'] = "r3S3+ pASSw0Rd t0";
$lang['invaliduseraccount'] = "iNv4LID us3R 4cc0un+ 5P3c1phi3d. Ch3ck Em@iL F0r cORr3c+ l1nK";
$lang['invaliduserkeyprovided'] = "iNv4l1D u\$3r K3y pr0VidEd. ChEck eM41L pHor CorREC+ L1nk";

// Deleting messages (delete.php) --------------------------------------

$lang['nomessagespecifiedfordel'] = "n0 Mes5493 \$peC1phIEd phor D3L3tI0n";
$lang['deletemessage'] = "d3l3+e mess49E";
$lang['successfullydeletedpost'] = "sucCe\$\$PHUlly dELeteD pO\$T %s";
$lang['errordelpost'] = "eRr0r d3l3TInG POST";
$lang['cannotdeletepostsinthisfolder'] = "j00 c4NnO+ deL3te p0\$+5 1N THIs f0LDeR";

// Editing things (edit.php, edit_poll.php) -----------------------------------------

$lang['nomessagespecifiedforedit'] = "no mE5s4ge SPecIphiED pH0r 3d1+1N9";
$lang['cannoteditpollsinlightmode'] = "caNn0+ 3dit p0Ll\$ In li9HT M0D3";
$lang['editedbyuser'] = "eDI+3D: %s 8y %s";
$lang['successfullyeditedpost'] = "sUCCESsfully EDI+eD pOs+ %s";
$lang['errorupdatingpost'] = "erR0r Upd4T1n9 pOst";
$lang['editmessage'] = "edi+ M3Ss493 %s";
$lang['editpollwarning'] = "<b>n0t3</b>: eDIT1nG c3r+@in 4speC+\$ OF 4 P0Ll W1lL v01d 4ll +hE CUrrEn+ V0T35 @Nd ALLow p3opl3 +0 Vo+3 49@1n.";
$lang['hardedit'] = "h4RD 3d1+ 0pT1Ons (VoT35 wIll 83 R35E+):";
$lang['softedit'] = "s0PhT eD1t 0p+ion5 (Vo+es w1ll 83 Ret4In3d):";
$lang['changewhenpollcloses'] = "ch@ngE WH3n +Eh PoLL Cl05e\$?";
$lang['nochange'] = "n0 cH@n9E";
$lang['emailresult'] = "em41l r35ult";
$lang['msgsent'] = "m3\$s493 53n+";
$lang['msgsentsuccessfully'] = "m3S\$@9e s3n+ SuCC3\$sfully.";
$lang['mailsystemfailure'] = "m41L 5y5+3M f@1lUR3. m35\$@93 N0+ S3nT.";
$lang['nopermissiontoedit'] = "j00 @re no+ p3rm1+teD +0 3dit th1S m3\$549e.";
$lang['cannoteditpostsinthisfolder'] = "j00 c4nno+ 3DIT p0S+S iN +hI\$ FOld3r";
$lang['messagewasnotfound'] = "mESSAG3 %s w@s n0t fOUnd";

// Email (email.php) ---------------------------------------------------

$lang['sendemailtouser'] = "send 3M@1L +O %s";
$lang['nouserspecifiedforemail'] = "n0 u\$er speC1fi3d ph0r ema1Lin9.";
$lang['entersubjectformessage'] = "en+3r @ suBJEc+ f0r tH3 m355493";
$lang['entercontentformessage'] = "en+3R Some C0nTeNt pH0r +h3 mEsS4g3";
$lang['msgsentfromby'] = "tH1s mEsS49e W@\$ S3Nt from %s BY %s";
$lang['subject'] = "su8J3cT";
$lang['send'] = "s3ND";
$lang['userhasoptedoutofemail'] = "%s h@\$ 0p+3d 0UT oF EM@Il Con+@c+";
$lang['userhasinvalidemailaddress'] = "%s h45 4N 1Nv4l1D Em@1l @DDRe5\$";

// Message nofificaiton ------------------------------------------------

$lang['msgnotification_subject'] = "m3s54ge no+1PhiC4t10n frOm %s";
$lang['msgnotificationemail'] = "h3ll0 %s,\n\n%s po\$teD @ Me\$\$@G3 +o j00 on %s.\n\nthe 5u8J3c+ iS: %s.\n\nTo r34d +hAT m3S5@g3 4nd other\$ 1n +3h s4Me di\$cuS\$1ON, go +0:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nN0TE: 1PH j00 do NOt w1SH +o REC31v3 3M@1L nO+1PhIcaT10N\$ Oph F0ruM m35\$4G3\$ p0\$+3D +O you, g0 t0: %s cl1cK 0N my controLs THen 3Mail 4Nd pr1V4cY, unS3LeC+ the 3m41L nO+iFIc@+10n ch3ckb0X anD PRe5s SU8mit.";

// Thread Subscription notification ------------------------------------

$lang['threadsubnotification_subject'] = "sub\$Cr1p+1ON n0tifiC4+I0n phR0m %s";
$lang['threadsubnotification'] = "h3lLo %s,\n\n%s Po5TEd @ M355@GE 1n @ thREAd J00 4RE SU8SCriB3D t0 0N %s.\n\nthe 5u8j3c+ 1\$: %s.\n\n+O r3AD +h4+ mEsS49e 4nd 0+H3rS 1N +h3 sam3 D1sCu\$si0n, g0 TO:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nn0T3: iPH j00 d0 N0t w1Sh +O R3Ceive 3m4IL NO+ific@t1On\$ 0Ph n3W M3\$Sa93S 1N +h1S ThreAD, go t0: %s 4nd @djus+ Y0ur 1N+3r3\$+ LEV3l @+ THe 80+tom OF ThE pAge.";

// Folder Subscription notification ------------------------------------

$lang['foldersubnotification_subject'] = "sUB5Cr1ption n0+iph1C4ti0n Fr0M %s";
$lang['foldersubnotification'] = "h3LlO %s,\n\n%s p0\$+3d 4 ME\$\$@G3 in 4 F0Ld3r J00 arE SUb\$crIb3d +O 0n %s.\n\nth3 suBJ3ct i5: %s.\n\n+0 R34d th4+ mes\$4g3 4ND 0TH3r5 1n Th3 s@me Di5CuSS1oN, go to:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nNOt3: IPH J00 d0 N0T w1\$h +o rece1v3 3M@1l no+1fic4+ION\$ of N3W mE\$S4935 1n +hIs THr3ad, gO +0: %s @nd @Dju5T Y0ur 1n+3re\$+ lev3L By cl1cK1n9 on teh F0LD3r's 1Con 4+ teh +0p OF p493.";

// PM notification -----------------------------------------------------

$lang['pmnotification_subject'] = "pM no+1FiCAT1On PhRom %s";
$lang['pmnotification'] = "h3ll0 %s,\n\n%s pOs+3D 4 PM +O j00 on %s.\n\n+HE subJ3c+ iS: %s.\n\n+O re4d +eh M3\$S493 g0 to:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nnot3: 1F j00 D0 N0t wi\$h +0 R3cE1ve 3m41L n0+iF1c@Ti0n5 Of nEW pm m3S\$@93s p0\$+ed T0 Y0u, Go +O: %s CL1ck MY c0n+ROlS +H3n 3m4IL 4ND pr1V4cY, uNs3l3ct +he Pm n0+If1c4TiON cHECk8Ox 4nd PreSs sU8Mit.";

// Password change notification ----------------------------------------

$lang['passwdchangenotification'] = "p@SsworD cH4Nge N0t1f1c4tioN fr0m %s";
$lang['pwchangeemail'] = "hElLO %s,\n\n+h1S 4 not1F1c@+iON 3m41l tO 1NphoRm j00 tH4+ y0uR P@ssWORD on %s H4\$ 833n ch4nGed.\n\n1+ h@5 8e3n ch4n93d +o: %s @nd w4S Ch4ngeD by: %s.\n\nIpH j00 h4v3 R3CeiveD ThI5 ema1l 1n erroR oR weR3 nOT 3xP3C+ing 4 cH@n9e to yoUr p@\$SworD pL3a53 COnTact +he ph0ruM Own3r oR @ mod3r4+OR 0n %s 1mM3dI4TElY tO coRR3ct 1t.";

// Email confirmation notification -------------------------------------

$lang['emailconfirmationrequiredsubject'] = "eM4il C0nPH1Rm@+i0N REqu1rEd Phor %s";
$lang['confirmemail'] = "h3ll0 %s,\n\nYou RECeNTlY cr34+3d 4 n3w uSEr 4ccOUnt 0N %s.\n\nBEphore J00 c@N \$+4r+ p0STing w3 N3Ed +o c0Nf1Rm Your eM@1L 4Ddr3S\$. d0N'T w0RRy this 1s qu1+3 E@5Y. ALl J00 n3Ed +0 d0 IS cliCk THE Link 8ELoW (0r C0PY 4Nd p45te i+ 1nt0 Y0uR 8r0ws3r):\n\n%s\n\nonce cONPH1rmAT10n 15 c0mpl3t3 j00 m4y L091N 4ND S+@RT poS+1NG Immedi4teLY.\n\n1f J00 Did n0t cRE4te 4 uSer @CCOun+ On %s PLe@Se @cCep+ 0uR @p0l09IeS ANd ph0Rw@RD +H1s ema1l +0 %s 5o th4t +3H SOUrCe 0ph i+ m4Y b3 inveS+i9@ted.";
$lang['confirmchangedemail'] = "hEll0 %s,\n\nYOu reCEntly Ch@ngEd y0Ur Em4il ON %s.\n\nB3ph0RE J00 c@n ST4Rt poS+1n9 @g4IN wE N33d +o conPhirm Y0UR NEw 3mail @dDR3\$5. d0n'+ w0Rry +his i\$ qui+3 E4SY. @Ll j00 ne3d +0 D0 IS Cl1ck +3H l1nk Bel0w (0R C0Py 4nd p4STe it 1n+0 yOUr 8rows3r):\n\n%s\n\nONc3 ConF1rm4tioN 1s coMpLEte J00 m@y cOnt1nue to uS3 +3h ph0RUm aS norm4L.\n\n1PH J00 W3Re n0+ 3Xp3ctin9 Thi\$ em4il fr0m %s PLe4\$E 4cc3p+ OuR 4p0logie5 @nD f0Rw@rd +hI\$ eM41L +o %s 5o tH@+ +He 50urc3 0F 1t M4Y 83 1nVEs+i94+ed.";

// Forgotten password notification -------------------------------------

$lang['forgotpwemail'] = "h3lLO %s,\n\nYOu r3que\$t3d +hIs 3-M4il froM %s 83C4uS3 J00 h@Ve f0rGoT+EN Y0ur p@\$Sw0rd.\n\ncl1cK +Eh LInK 83l0w (0r copy 4ND P4s+3 iT iN+o yoUr 8roWSER) T0 r3seT YOur P@5\$WOrD:\n\n%s";

// Admin New User Approval notification -----------------------------------------

$lang['newuserapprovalsubject'] = "new u\$3R @PPr0Val nO+iPH1c4t10n fOR %s";
$lang['newuserapprovalemail'] = "Hello %s,\n\nA new user account has been created on %s.\n\nAs you are an Administrator of this forum you are required to approve this user account before it can be used by it's owner.\n\nTo approve this account please visit the Admin Users section and change the filter type to \"Users Awaiting Approval\"oR CLiCk t3h LinK Bel0w:\n\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nnot3: 0THEr @Dm1n1S+rAT0r\$ oN Thi\$ Ph0RUM w1ll 4ls0 rEce1v3 +his noTiphIC4+1on ANd m4y h4ve @LreAdY @C+3d Upon TH1s rEque\$t.";

// Admin New User notification -----------------------------------------

$lang['newuserregistrationsubject'] = "nEW USer @CCoUN+ n0+1fIC4+1oN F0r %s";
$lang['newuserregistrationemail'] = "heLl0 %s,\n\n4 n3W US3R @CCoun+ h@s b33n cr3a+eD on %s.\n\n+0 v13w +hIs us3R 4cCOUN+ pl3@S3 vI5i+ tH3 @dMin useRs sEC+i0n @Nd cliCk on +EH n3w us3R Or cl1CK ThE liNK B3l0W:\n\n%s";

// User Approved notification ------------------------------------------

$lang['useraccountapprovedsubject'] = "us3R 4ppr0v4l not1PHic@Tion f0R %s";
$lang['useraccountapprovedemail'] = "h3Llo %s,\n\ny0Ur u\$er 4cCoun+ 4T %s h4s B3En @pPr0v3d. J00 CAN lO9In 4Nd \$T4Rt pos+INg immED14T3lY 8y CliCK1n9 tHE l1Nk B3low:\n\n%s\n\nipH j00 WErE N0t ExpeCtiNG +H1s 3m41L Phr0m %s PLe@S3 4CcEp+ ouR apol0G13s @Nd fOrWaRd tH15 em4il T0 %s \$O th4T th3 sourCe Of 1+ m4y Be iNveSTi94+3D.";

// Admin Post Approval notification -----------------------------------------

$lang['newpostapprovalsubject'] = "p0St 4ppr0V4l n0T1PhiC@+10N PHOr %s";
$lang['newpostapprovalemail'] = "hEll0 %s,\n\na n3W pOSt h4\$ b33N cRE@+Ed 0N %s.\n\n@5 j00 4r3 4 m0dEr4t0r 0n +h15 PH0rUM J00 4rE r3qUiR3D +0 4pProvE +H1S pos+ B3FOR3 iT c@N b3 r3ad By 0th3R u\$3Rs.\n\nYOu c4n 4ppR0ve +h1S pos+ @Nd 4Ny o+h3R5 PeND1ng @pProV4l bY Vi\$ItIn9 +h3 4DM1N P0s+ appr0v4L \$3cT10n Of your f0rum 0R by cl1CK1ng tHE link 83LOw:\n\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nn0T3: 0tH3r 4DmInI\$+R@+OR\$ oN tH1s PH0Rum W1ll 4Ls0 REc3ive +h1s N0+1fIC4+i0N 4ND M4y h4ve @lre@Dy @c+3d Upon THi\$ R3que5+.";

// Forgotten password form.

$lang['passwdresetrequest'] = "yOUr P4\$sW0rd r3Se+ r3quE5+ phR0M %s";
$lang['passwdresetemailsent'] = "p4\$sWoRD R3s3t 3-M@1L 5eN+";
$lang['passwdresetexp'] = "j00 5H0ulD 5H0rTlY RECEIvE AN e-Ma1l c0NT41niN9 InsTruct1onS phOr Re53tt1n9 yoUr p4SSwoRd.";
$lang['validusernamerequired'] = "a V@liD U5ERN4m3 i5 r3quiR3d";
$lang['forgottenpasswd'] = "f0R9o+ p@S5WOrd";
$lang['couldnotsendpasswordreminder'] = "coULd nOT 53ND P4\$5w0rD r3minD3r. PLE@SE coNt4c+ +h3 fOrUM oWnER.";
$lang['request'] = "reqU3S+";

// Email confirmation (confirm_email.php) ------------------------------

$lang['emailconfirmation'] = "em41l c0nPhIRMation";
$lang['emailconfirmationcomplete'] = "th@Nk j00 pHor COnPH1RMiNG Y0UR em4iL @DDREsS. J00 M4y nOw LOg1n 4Nd ST4RT pOsT1Ng IMmEDI@+3Ly.";
$lang['emailconfirmationfailed'] = "eM41l C0NphIRM@T10n h4s F@IL3D, pLE@53 +ry @G41n l@+er. 1Ph j00 ENc0uN+3r +h15 Error MUL+1pLe T1ME\$ Ple4\$e cON+4Ct +h3 f0rUM 0WN3r 0R @ M0DerA+0R PhOR @\$5I\$T@NC3.";

// Links database (links*.php) -----------------------------------------

$lang['toplevel'] = "top L3V3l";
$lang['maynotaccessthissection'] = "j00 m@Y n0+ Acces5 th1\$ \$ECT1oN.";
$lang['toplevel'] = "tOP L3v3L";
$lang['links'] = "liNks";
$lang['externallink'] = "eXTErn@l l1NK";
$lang['viewmode'] = "vI3w moDe";
$lang['hierarchical'] = "h13r4Rch1C4L";
$lang['list'] = "li\$+";
$lang['folderhidden'] = "th1\$ f0lDEr is hiDd3N";
$lang['hide'] = "hidE";
$lang['unhide'] = "uNH1d3";
$lang['nosubfolders'] = "no SU8FOldEr\$ 1n +H15 c@+3gOry";
$lang['1subfolder'] = "1 SuBpH0LDEr in tH1s C4+e9orY";
$lang['subfoldersinthiscategory'] = "su8ph0ld3rs in Th1\$ C4te9ORY";
$lang['linksdelexp'] = "eN+ries In 4 d3leT3D F0ldEr w1LL 83 m0VEd +o +h3 P4ren+ F0ldEr. 0nly F0lD3r\$ whiCH dO Not Con+4iN 5u8F0ldeR5 M4Y Be dEl3t3d.";
$lang['listview'] = "li5t ViEw";
$lang['listviewcannotaddfolders'] = "c4nNo+ 4dd phold3rs in thIs VI3w. SHoWIn9 20 en+RI3s @T 4 time.";
$lang['rating'] = "r4t1ng";
$lang['nolinksinfolder'] = "no l1NKS 1N Th1s f0Lder.";
$lang['addlinkhere'] = "aDd liNk her3";
$lang['notvalidURI'] = "thAT 1\$ N0T 4 v4l1d urI!";
$lang['mustspecifyname'] = "j00 mu\$t spEc1pHY 4 n4m3!";
$lang['mustspecifyvalidfolder'] = "j00 MU5t \$p3C1FY 4 V4liD ph0lDer!";
$lang['mustspecifyfolder'] = "j00 MU\$t 5P3c1phY @ f0LDeR!";
$lang['successfullyaddedlinkname'] = "sUcCESsfULlY 4dDeD L1nk '%s'";
$lang['failedtoaddlink'] = "f@iLEd +0 4dd L1nK";
$lang['failedtoaddfolder'] = "f41Led +O 4Dd PhoLD3R";
$lang['addlink'] = "aDD 4 link";
$lang['addinglinkin'] = "aDd1n9 l1nk 1n";
$lang['addressurluri'] = "addreSs";
$lang['addnewfolder'] = "adD @ NeW foLd3R";
$lang['addnewfolderunder'] = "aDd1ng neW PholDeR unDeR";
$lang['editfolder'] = "edi+ FOLDER";
$lang['editingfolder'] = "ed1T1N9 f0Ld3r";
$lang['mustchooserating'] = "j00 Mus+ ch00\$3 @ r4t1n9!";
$lang['commentadded'] = "y0Ur CommeNt W4s @DD3d.";
$lang['commentdeleted'] = "c0MmEN+ w4s DELEt3d.";
$lang['commentcouldnotbedeleted'] = "cOmm3nt c0ULD No+ 8e d3l3+3d.";
$lang['musttypecomment'] = "j00 mU5t Typ3 @ c0MM3nt!";
$lang['mustprovidelinkID'] = "j00 Mu\$+ PrOV1D3 a lInK Id!";
$lang['invalidlinkID'] = "iNV4l1d l1nk 1d!";
$lang['address'] = "adDre55";
$lang['submittedby'] = "sUbmi++3d 8y";
$lang['clicks'] = "cl1CK\$";
$lang['rating'] = "rAtin9";
$lang['vote'] = "v0TE";
$lang['votes'] = "v0+3\$";
$lang['notratedyet'] = "noT r4+Ed BY 4NYonE Y3T";
$lang['rate'] = "r4+E";
$lang['bad'] = "b4d";
$lang['good'] = "gOod";
$lang['voteexcmark'] = "v0+e!";
$lang['clearvote'] = "cL34r v0t3";
$lang['commentby'] = "cOMM3nT BY %s";
$lang['addacommentabout'] = "adD 4 COMmen+ @BOu+";
$lang['modtools'] = "m0dEr4TIOn T00l5";
$lang['editname'] = "eDi+ n4ME";
$lang['editaddress'] = "edi+ 4ddr355";
$lang['editdescription'] = "ed1t De\$Cr1PTIOn";
$lang['moveto'] = "mOve tO";
$lang['linkdetails'] = "lINK D3t@ils";
$lang['addcomment'] = "add COMM3Nt";
$lang['voterecorded'] = "yOuR v0+e Ha\$ be3n R3cORDED";
$lang['votecleared'] = "y0uR vo+e H4s 83eN CLE@r3d";
$lang['linknametoolong'] = "l1NK N@ME t0O LoNg. M@x1Mum 15 %s CH4r@ctER5";
$lang['linkurltoolong'] = "l1NK uRL +00 LoN9. M@X1muM is %s ch4r4Ct3R\$";
$lang['linkfoldernametoolong'] = "fOLd3R N@M3 +0o loN9. M@X1muM L3NGtH iS %s CH4RACT3r5";

// Login / logout (llogon.php, logon.php, logout.php) -----------------------------------------

$lang['loggedinsuccessfully'] = "j00 lo993d 1n 5uCC35sFuLLy.";
$lang['presscontinuetoresend'] = "pR3S\$ Cont1nUE T0 r3s3Nd pH0Rm DAT4 oR C@NC3L +o Rel04D P493.";
$lang['usernameorpasswdnotvalid'] = "tHE USeRn4Me 0R P45\$woRD J00 \$upPl13D IS N0t v@L1d.";
$lang['rememberpasswds'] = "r3m3M8er P4Ssw0rDs";
$lang['rememberpassword'] = "rem3M8ER p45\$w0rD";
$lang['enterasa'] = "eNt3r @s @ %s";
$lang['donthaveanaccount'] = "dOn'+ h@v3 @n 4cC0UNt? %s";
$lang['registernow'] = "reGISTeR N0W";
$lang['problemsloggingon'] = "pr08L3Ms LO9Ging on?";
$lang['deletecookies'] = "deL3Te c0OkiE\$";
$lang['cookiessuccessfullydeleted'] = "c0ok13s SuCC3SSfuLlY D3l3+eD";
$lang['forgottenpasswd'] = "fOr9Otten youR Pa\$sWord?";
$lang['usingaPDA'] = "usiN9 @ pD4?";
$lang['lightHTMLversion'] = "l19h+ HtMl VER\$10n";
$lang['youhaveloggedout'] = "j00 h@vE L09GeD OUt.";
$lang['currentlyloggedinas'] = "j00 Ar3 cURR3ntlY lOgGed iN 45 %s";
$lang['logonbutton'] = "lo90n";
$lang['otherdotdotdot'] = "o+HEr...";
$lang['yoursessionhasexpired'] = "yOur \$3S\$10n h4\$ 3xp1ReD. J00 W1LL nEed +o L09IN @G41N +0 c0N+iNu3.";

// My Forums (forums.php) ---------------------------------------------------------

$lang['myforums'] = "my Ph0RuMs";
$lang['allavailableforums'] = "aLl @V4iL48l3 f0ruM5";
$lang['favouriteforums'] = "f4v0Uri+3 Ph0ruMs";
$lang['ignoredforums'] = "iGnoRED f0RuMs";
$lang['ignoreforum'] = "ignoRE f0rUM";
$lang['unignoreforum'] = "uNiGn0R3 ph0rum";
$lang['lastvisited'] = "l4\$+ V1si+3D";
$lang['forumunreadmessages'] = "%s UnRe@D mE5S@9Es";
$lang['forummessages'] = "%s M3S\$4g35";
$lang['forumunreadtome'] = "%s unR34D &quot;To: ME&quot;";
$lang['forumnounreadmessages'] = "n0 UnRe4d m3\$\$@gE5";
$lang['removefromfavourites'] = "rEmove fROM f@v0uR1+E5";
$lang['addtofavourites'] = "aDD T0 Ph@vourI+e\$";
$lang['availableforums'] = "aV@1l48le foRUMS";
$lang['noforumsofselectedtype'] = "th3re 4r3 NO ForUm\$ 0Ph ThE 53L3cTed +Yp3 4v4IL48l3. PlE4s3 sEL3c+ 4 D1pHph3r3Nt TyPe.";
$lang['successfullyaddedforumtofavourites'] = "sUCC355fully 4dD3D F0rUM tO fAvoURiTEs.";
$lang['successfullyremovedforumfromfavourites'] = "suCCE\$5fUlly R3m0V3D phorum from pH@v0uRITe5.";
$lang['successfullyignoredforum'] = "sUcCeSsfUlLY 1Gn0red PH0ruM.";
$lang['successfullyunignoredforum'] = "sUcCE\$SPHULLy UN19noR3D PhoRUm.";
$lang['failedtoupdateforuminterestlevel'] = "f41leD tO upDA+E f0RUM 1NtEr3s+ LEvEl";
$lang['noforumsavailablelogin'] = "tHer3 @r3 N0 Ph0Rum\$ @vAil4bLe. pLE@5E LoG1n TO V13w Y0UR FOrUmS.";
$lang['passwdprotectedforum'] = "p45SwOrD ProTeCT3D ForuM";
$lang['passwdprotectedwarning'] = "th1\$ F0rum I\$ P4\$\$WOrd pr0TEcTed. TO 9@IN ACCe5S 3N+3R +he P45SWoRd B3L0W.";

// Message composition (post.php, lpost.php) --------------------------------------

$lang['postmessage'] = "pO5T MeS54g3";
$lang['selectfolder'] = "s3LEC+ PHOlD3R";
$lang['mustenterpostcontent'] = "j00 Mu5+ 3n+3r s0m3 C0NT3n+ F0r +h3 p05+!";
$lang['messagepreview'] = "m3\$S@93 pREVIEW";
$lang['invalidusername'] = "inv4l1D uSErN@ME!";
$lang['mustenterthreadtitle'] = "j00 must En+3r 4 tI+le pHOr tHe tHre4D!";
$lang['pleaseselectfolder'] = "ple4\$E s3l3C+ 4 FOld3R!";
$lang['errorcreatingpost'] = "eRr0r cr34tiN9 p0\$+! PL34\$3 +RY AGain 1N @ FEW m1nU+35.";
$lang['createnewthread'] = "cRE4+3 New tHR34d";
$lang['postreply'] = "p0\$T R3ply";
$lang['threadtitle'] = "thr34D +1+L3";
$lang['foldertitle'] = "f0ldER T1tLe";
$lang['messagehasbeendeleted'] = "mEss493 N0+ PHOuNd. CH3Ck +H4T 1+ h@\$N't 8E3n dElETeD.";
$lang['messagenotfoundinselectedfolder'] = "m3s54g3 nOT PHOuND in sElEc+3D phoLD3r. ch3CK +h4+ 1t h45n'+ be3n M0VED Or DEL3+3D.";
$lang['cannotpostthisthreadtypeinfolder'] = "j00 C4NnOT pOst +HiS +hRE4d +yPE 1N tH4T Ph0lD3R!";
$lang['cannotpostthisthreadtype'] = "j00 C4NNot p0s+ +hI\$ ThREad TyP3 a\$ th3re @R3 N0 4v4IL48lE f0ldEr\$ +H4+ 4llOW i+.";
$lang['cannotcreatenewthreads'] = "j00 C4NnOt CrE4+3 nEw tHr34d\$.";
$lang['threadisclosedforposting'] = "tHis tHr34d 1\$ ClOS3D, J00 C@NNO+ p0\$t IN I+!";
$lang['moderatorthreadclosed'] = "w@Rn1n9: Thi5 ThR3aD i\$ CL0\$3D fOR p05+1nG +0 NOrM4l uSeRs.";
$lang['usersinthread'] = "u\$ErS 1N Thr34D";
$lang['correctedcode'] = "cOrrECtED c0D3";
$lang['submittedcode'] = "sUBm1T+3d CODe";
$lang['htmlinmessage'] = "h+ml 1N m3\$s49e";
$lang['disableemoticonsinmessage'] = "d1\$48l3 3mo+1COn\$ IN MES\$4g3";
$lang['automaticallyparseurls'] = "aUt0m4TiC4Lly p4r\$3 UrL5";
$lang['automaticallycheckspelling'] = "aU+0M@T1C@LLY chEck SP3LliNG";
$lang['setthreadtohighinterest'] = "s3t thR34d T0 h19h 1NteReST";
$lang['enabledwithautolinebreaks'] = "eN4BleD wI+H 4UT0-LIn3-BrE4ks";
$lang['fixhtmlexplanation'] = "tH15 Ph0rum USeS HTMl Ph1L+3r1n9. YOuR SubM1TT3d h+ML h4\$ BE3n mOD1PH1Ed 8y Th3 pH1L+3rS IN S0mE w4Y.\\n\\n+O VI3w yOUr OR1Gin4L CoD3, SEl3ct Th3 \\'5u8M1+tED C0D3\\' R4Dio bUT+oN.\\nt0 vI3W +hE Mod1F13D C0d3, seLeCt +eh \\'c0rR3CT3d C0D3\\' R4D10 BuT+on.";
$lang['messageoptions'] = "m3Ss@g3 0pT10Ns";
$lang['notallowedembedattachmentpost'] = "j00 @Re n0+ 4LL0w3D +0 EM83d @++@ChMeN+s iN y0uR p05+\$.";
$lang['notallowedembedattachmentsignature'] = "j00 4r3 N0+ All0WEd TO 3M8ED A+T@cHM3N+\$ 1N yoUr S1Gn@tUR3.";
$lang['reducemessagelength'] = "mE\$s4g3 l3ngTH mU\$+ b3 uNdEr 65,535 ch@r4cTeRs (CurREN+LY: %s)";
$lang['reducesiglength'] = "si9N@+uR3 L3N9tH MU5+ 8e Under 65,535 CH4r@C+3r\$ (CURrENtLy: %s)";
$lang['cannotcreatethreadinfolder'] = "j00 c@Nno+ cre4TE NEw +hrE@d\$ 1N +h1S f0Ld3r";
$lang['cannotcreatepostinfolder'] = "j00 cANn0t r3plY +0 pO\$TS In +HIs F0ldER";
$lang['cannotattachfilesinfolder'] = "j00 C@Nn0+ Po\$+ 4t+4CHM3nts 1n +his F0Ld3r. REMOvE 4tt@ChmEntS +0 cONT1NUe.";
$lang['postfrequencytoogreat'] = "j00 c@N 0nLY P0ST onCe 3v3ry %s 53c0Nd\$. PLE4\$E +rY 49Ain l4+3r.";
$lang['emailconfirmationrequiredbeforepost'] = "eMAiL c0nph1rM4t1ON is REqu1red BEf0rE j00 c4N P05+. 1pH j00 h4V3 N0+ r3C31vEd 4 CoNf1RM@T10n 3m@Il pl345e ClICk +he 8uttoN 8Elow @ND 4 new one WiLl B3 s3N+ tO Y0u. If y0Ur 3m4il 4ddrEss nE3ds cHaN91nG pL3453 d0 \$0 B3F0rE r3QU3st1ng @ neW c0NF1rm4+10n emAil. j00 m4y cH@n93 YoUr 3m4Il @ddR3s\$ bY CL1CK MY C0ntr0LS 4boV3 @nD th3N us3r d3+@ils";
$lang['emailconfirmationfailedtosend'] = "cONPhirm@+1On Em41l f41leD to sEnd. plE4se C0nt@cT TEh forUM 0wn3R t0 r3C+ify +h1\$.";
$lang['emailconfirmationsent'] = "conf1rm4+ioN 3M41L h4\$ Be3N RES3N+.";
$lang['resendconfirmation'] = "r3sENd Conf1RM4tiON";
$lang['userapprovalrequiredbeforeaccess'] = "yOUR u\$3r 4CcOuNt ne3DS +O 83 @ppr0veD BY 4 foRuM 4DM1n 83phOr3 j00 c@n 4ccess +EH rEqu3StED FOrUM.";
$lang['reviewthread'] = "rEVi3w +hr3@d";
$lang['reviewthreadinnewwindow'] = "r3V13w EntIrE +hre4d In n3w WINd0w";

// Message display (messages.php & messages.inc.php) --------------------------------------

$lang['inreplyto'] = "in r3ply +0";
$lang['showmessages'] = "sHOW m3s\$49e5";
$lang['ratemyinterest'] = "rA+E MY InT3R3\$+";
$lang['adjtextsize'] = "aDjU\$+ +3x+ s1ze";
$lang['smaller'] = "sm@ll3R";
$lang['larger'] = "l@R93r";
$lang['faq'] = "fAq";
$lang['docs'] = "d0cs";
$lang['support'] = "sUpp0rt";
$lang['donateexcmark'] = "d0n@Te!";
$lang['fontsizechanged'] = "f0NT \$1Ze CH4nG3D. %s";
$lang['framesmustbereloaded'] = "fR@mEs MUs+ be r3l04ded m4nuallY to 5eE ChanGes.";
$lang['threadcouldnotbefound'] = "th3 R3qu35+3D +hr3aD CouLD n0+ B3 FOUNd 0r 4CC3\$S w45 d3ni3D.";
$lang['mustselectpolloption'] = "j00 mUst sELec+ @n 0pT1on to v0t3 f0R!";
$lang['mustvoteforallgroups'] = "j00 musT v0+3 in eV3ry 9roup.";
$lang['keepreading'] = "k3ep Re@d1N9";
$lang['backtothreadlist'] = "b@ck T0 thrE4d lI5+";
$lang['postdoesnotexist'] = "th4+ p0St Do3\$ n0T 3xis+ 1n +hIS +HrE@d!";
$lang['clicktochangevote'] = "cL1Ck T0 ChAn93 V0t3";
$lang['youvotedforoption'] = "j00 Vo+3D ph0R op+1on";
$lang['youvotedforoptions'] = "j00 V0+3D PHor Op+ioN\$";
$lang['clicktovote'] = "clICk +0 v0+E";
$lang['youhavenotvoted'] = "j00 h4v3 NO+ v0+eD";
$lang['viewresults'] = "v1Ew ResulT5";
$lang['msgtruncated'] = "m3\$S493 +Runc@+Ed";
$lang['viewfullmsg'] = "vieW FuLl me5S4Ge";
$lang['ignoredmsg'] = "iGN0R3D m35S@ge";
$lang['wormeduser'] = "w0Rmed u53r";
$lang['ignoredsig'] = "igN0REd \$19N4TUR3";
$lang['messagewasdeleted'] = "mEsS@ge %s.%s W4S DeleT3d";
$lang['stopignoringthisuser'] = "s+oP I9noR1N9 +hI5 u5ER";
$lang['renamethread'] = "r3N@M3 tHr34d";
$lang['movethread'] = "move tHRe@D";
$lang['torenamethisthreadyoumusteditthepoll'] = "tO ren@me +hIs +hre@d j00 muS+ 3d1t TEh p0ll.";
$lang['closeforposting'] = "cL05e for p0S+1n9";
$lang['until'] = "uNT1l 00:00 U+C";
$lang['approvalrequired'] = "approv4L reQuir3d";
$lang['messageawaitingapprovalbymoderator'] = "mEss49E %s.%s 1S 4w@i+ing 4PPROV4L 8Y 4 M0d3R4+or";
$lang['successfullyapprovedpost'] = "sUCCESSphuLly 4PProved pos+ %s";
$lang['postapprovalfailed'] = "poS+ 4pprOVal ph@iL3D.";
$lang['postdoesnotrequireapproval'] = "p0S+ d03s n0+ reqU1re 4ppr0v@l";
$lang['approvepost'] = "aPPrOV3 Pos+";
$lang['approvedbyuser'] = "appr0veD: %s BY %s";
$lang['makesticky'] = "mAK3 s+1CkY";
$lang['messagecountdisplay'] = "%s 0ph %s";
$lang['linktothread'] = "pErm@n3N+ L1nk to th1S +Hr3Ad";
$lang['linktopost'] = "link +O pO5T";
$lang['linktothispost'] = "l1Nk +O th15 P05t";
$lang['imageresized'] = "th1\$ iMAg3 h4\$ B33N r3s1zEd (or19iNal SIz3 %1\$5x%2\$\$). +o v13w +3h phUll-51ze im4g3 CLiCK h3R3.";
$lang['messagedeletedbyuser'] = "m3S\$4G3 %s.%s dEL3+3d %s BY %s";
$lang['messagedeleted'] = "mEss49e %s.%s w4s D3Le+3d";
$lang['viewinframeset'] = "v13w 1n fr4m3\$3+";
$lang['pressctrlentertoquicklysubmityourpost'] = "pRE\$s ctRl+ent3r to qU1ckLy 5UBM1+ your p05t";

// Moderators list (mods_list.php) -------------------------------------

$lang['cantdisplaymods'] = "c@Nno+ D15Pl@Y folder m0deR4tORs";
$lang['moderatorlist'] = "mOd3ra+or l1St:";
$lang['modsforfolder'] = "mOd3r4+0Rs f0R f0lDEr";
$lang['nomodsfound'] = "n0 M0d3r4t0RS f0UnD";
$lang['forumleaders'] = "f0ruM L34DEr5:";
$lang['foldermods'] = "foLdEr mOD3r4+oR\$:";

// Navigation strip (nav.php) ------------------------------------------

$lang['start'] = "sT4Rt";
$lang['messages'] = "mE\$549Es";
$lang['pminbox'] = "inBoX";
$lang['startwiththreadlist'] = "s+4rT P493 w1tH tHr34d l15+";
$lang['pmsentitems'] = "sEnt it3MS";
$lang['pmoutbox'] = "oU+Box";
$lang['pmsaveditems'] = "s4V3D 1+3Ms";
$lang['pmdrafts'] = "drAPh+\$";
$lang['links'] = "lInK5";
$lang['admin'] = "aDMin";
$lang['login'] = "log1N";
$lang['logout'] = "lOg0u+";

// PM System (pm.php, pm_write.php, pm.inc.php) ------------------------

$lang['privatemessages'] = "pR1V4+E M3s\$AG3S";
$lang['recipienttiptext'] = "s3P4R4+e rec1p13nTS By S3Mi-c0Lon or comM@";
$lang['maximumtenrecipientspermessage'] = "th3re is 4 L1m1t Oph 10 rEcipi3N+5 p3R m3s54g3. Pl3@s3 @MENd Your Rec1piEnt l1St.";
$lang['mustspecifyrecipient'] = "j00 mU\$t \$P3Cify aT le4St 0nE ReCipi3n+.";
$lang['usernotfound'] = "us3R %s noT ph0und";
$lang['sendnewpm'] = "s3nD n3W pm";
$lang['savemessage'] = "s@v3 mE5\$493";
$lang['nosubject'] = "nO \$u8j3C+";
$lang['norecipients'] = "n0 r3c1PieNT\$";
$lang['timesent'] = "tiM3 Sen+";
$lang['notsent'] = "not \$3nt";
$lang['errorcreatingpm'] = "errOR Cre@ting Pm! ple@\$3 tRY 49@1n 1N 4 pheW miNutes";
$lang['writepm'] = "writE mEsSA9e";
$lang['editpm'] = "eDIT m3\$s@Ge";
$lang['cannoteditpm'] = "c4nNOT eDi+ +H15 pm. it Has 4lrE@Dy bEen v13w3d 8Y THE rEcIPi3nT 0r +h3 Me\$s49E d035 nO+ 3X1St oR 1T 1s iN@cc3ss1bl3 BY j00";
$lang['cannotviewpm'] = "c@nnot vi3W pm. ME\$549e Do3\$ nO+ ex1ST or 1+ 1s 1NaCC3sS1blE 8y J00";
$lang['pmmessagenumber'] = "me5S4g3 %s";

$lang['youhavexnewpm'] = "j00 H@vE %d n3W MEsS493s. W0uld j00 liKe +o 9O to y0ur 1nbOx now?";
$lang['youhave1newpm'] = "j00 h4v3 1 NEw M3ssag3. woUld J00 liK3 +o 90 +o y0ur in8ox n0w?";
$lang['youhave1newpmand1waiting'] = "j00 H4v3 1 New me\$\$@g3.\n\nyou 4Ls0 hAve 1 ME5\$4G3 4w41tin9 DEl1v3RY. +o R3ceIv3 tH1s me\$\$493 Plea\$3 cL3AR soME 5p4cE 1n y0ur inB0X.\n\nw0uld J00 like t0 G0 to yoUr inB0x N0w?";
$lang['youhave1pmwaiting'] = "j00 h@vE 1 m3s\$@93 4W41tiNg D3l1v3Ry. +0 R3Ce1ve +hi\$ mes54g3 PlEasE Cle4R s0m3 \$p@Ce iN yoUr InBox.\n\nW0UlD j00 L1Ke t0 G0 +O yoUR inB0x n0w?";
$lang['youhavexnewpmand1waiting'] = "j00 h@Ve %d neW m3S\$49E\$.\n\nY0u 4L5o H4v3 1 M3Ss493 4W@it1N9 D3lIv3Ry. T0 R3Ceiv3 +h1s m3ssaG3 Pl3@sE CleaR 5ome \$p@C3 1N yoUr 1nB0x.\n\nW0uld j00 Lik3 +0 go +O your 1nBox now?";
$lang['youhavexnewpmandxwaiting'] = "j00 haVE %d New MEss4Ges.\n\ny0U Al50 H4V3 %d M3sS4gE\$ @W41+1nG d3L1v3ry. +o R3c3ivE +h3\$E me\$s49E PLeas3 CL34R \$Ome spaCE in your 1nBoX.\n\nW0ulD j00 lIke +o g0 to Y0Ur inbOx n0W?";
$lang['youhave1newpmandxwaiting'] = "j00 hAVe 1 n3w m3\$\$4g3.\n\ny0U 4lso h4v3 %d m3\$S@9es @w@1tIng DeLIV3rY. t0 rECE1v3 th3s3 M3\$549es PLe4se Cle4r S0Me 5P@CE iN y0ur 1Nb0x.\n\nWOulD j00 LiK3 +0 go +O YoUr 1n80x now?";
$lang['youhavexpmwaiting'] = "j00 Hav3 %d Mess49es @wAIT1nG dEL1V3rY. +o R3CEiVE +h3Se M3ss4g3s Pl3@53 CLE4r somE 5P4cE 1n Your 1n80x.\n\nw0UlD j00 LIK3 +o 9O To YouR IN80X NOw?";

$lang['youdonothaveenoughfreespace'] = "j00 d0 No+ h4vE 3N0uGh fR33 spaCe +0 s3nD +hIS MEssa9e.";
$lang['userhasoptedoutofpm'] = "%s H@s OPtEd 0uT 0f r3C3Ivin9 P3R\$On4L mEss49es";
$lang['pmfolderpruningisenabled'] = "pM folDeR Prun1NG i\$ 3N@8led!";
$lang['pmpruneexplanation'] = "th15 ph0rUm us35 pm PholD3r PrunIng. +3h M3S\$@9es j00 h4vE \$T0Red 1N yOUR In8Ox @nD s3nt i+3M\$\\nph0lD3r5 @R3 SU8jeC+ to @Ut0M@+iC Del3+10n. Any m3\$S493\$ j00 w1SH +o KEeP 5HOulD be mOV3d +0\\nyOUr \\'\$4V3D iTeMS\\' f0lder 5o TH4+ +h3Y 4R3 Not Dele+3d.";
$lang['yourpmfoldersare'] = "y0Ur Pm fold3rS 4re %s pHUll";
$lang['currentmessage'] = "cuRr3NT me\$S@gE";
$lang['unreadmessage'] = "unreaD ME5\$49E";
$lang['readmessage'] = "rE4d me\$\$@93";
$lang['pmshavebeendisabled'] = "pEr50n@l meSS4ge5 h4VE BEen d1s@8LED 8y +h3 fORum own3r.";
$lang['adduserstofriendslist'] = "add us3r\$ +0 yOuR fr13Nd\$ l15t +0 HAvE +h3M 4PPE4r 1n 4 droP D0wn 0n tHE Pm Wri+3 mEs\$@93 P4g3.";

$lang['messagewassuccessfullysavedtodraftsfolder'] = "m3S\$49e w@\$ 5UCCE5SFUlly s4ved To 'dR4fts' F0lD3r";
$lang['couldnotsavemessage'] = "cOULd no+ S4Ve MeSs49e. m4k3 \$ure j00 Hav3 EN0uGH 4v@Il4bLE fre3 \$P4C3.";
$lang['pmtooltipxmessages'] = "%s MES5@93\$";
$lang['pmtooltip1message'] = "1 me\$S@Ge";

$lang['allowusertosendpm'] = "alL0w useR t0 \$eNd p3r\$0n@l meSs49es +o M3";
$lang['blockuserfromsendingpm'] = "bLoCK u\$3R pHrom \$3nD1n9 P3rs0N4l M3sS49ES to mE";
$lang['yourfoldernamefolderisempty'] = "yOur %s ph0LD3r is emP+y";
$lang['successfullydeletedselectedmessages'] = "sucC3\$sFully DEL3+ed \$eL3c+eD mess49E5";
$lang['successfullyarchivedselectedmessages'] = "suCcEs5phuLly 4RChIveD 53L3cTEd m3\$S4ge5";
$lang['failedtodeleteselectedmessages'] = "f4ILed +o dele+3 53LeCT3d me\$54G3\$";
$lang['failedtoarchiveselectedmessages'] = "f4il3d To 4rChIve s3l3c+ed mEsSA9E\$";

// Preferences / Profile (user_*.php) ---------------------------------------------

$lang['mycontrols'] = "mY c0N+R0Ls";
$lang['myforums'] = "my Ph0ruM\$";
$lang['menu'] = "m3NU";
$lang['userexp_1'] = "u\$E +3H m3nU oN tEH l3f+ to M4N@9e y0ur \$3T+1n9\$.";
$lang['userexp_2'] = "<b>us3r det41L\$</b> @LL0Ws j00 +0 ch4NG3 y0uR N4m3, eM4IL @dDre5\$ @nD PasSwORd.";
$lang['userexp_3'] = "<b>u\$3r pROphiL3</b> 4LL0w\$ j00 to eDi+ Y0ur u\$Er pR0pHil3.";
$lang['userexp_4'] = "<b>cHANge pa\$5w0rD</b> ALlOW\$ J00 to ch4ngE YOUR P@5SW0RD";
$lang['userexp_5'] = "<b>em4Il &amp; pr1vacy</b> Let\$ J00 cH@Ng3 h0w j00 c4N 8e COntact3d 0n 4ND off teh phoRUm.";
$lang['userexp_6'] = "<b>fORUM OP+i0Ns</b> L3t\$ j00 cHAnGE H0W thE FOruM l0oKS @nd W0rk5.";
$lang['userexp_7'] = "<b>at+4CHments</b> 4ll0WS j00 T0 3dI+/D3lE+3 y0ur @Tt@cHm3Nts.";
$lang['userexp_8'] = "<b>s1GN4+uRe</b> L3t\$ j00 3DIt Y0Ur \$19n@TuRe.";
$lang['userexp_9'] = "<b>r3L@tI0nsh1p\$</b> l3t5 j00 M4n49E youR rEl@+10nsh1P W1+h 0tHER U\$3rs 0n TeH PhorUM.";
$lang['userexp_9'] = "<b>wOrd F1l+3R</b> l3t5 j00 3D1T y0UR Per\$on@l wOrD PhiL+3R.";
$lang['userexp_10'] = "<b>tHr34d su8ScRiPTi0n\$</b> ALlOw\$ j00 To M4nAG3 your ThRE@D sUB\$cR1pti0ns.";
$lang['userdetails'] = "uS3r DE+4ILS";
$lang['userprofile'] = "u53r pr0fil3";
$lang['emailandprivacy'] = "eM4il &amp; pRiV4Cy";
$lang['editsignature'] = "ed1+ si9n@tUr3";
$lang['norelationshipssetup'] = "j00 h@v3 no UseR rEl4tioN5hip\$ se+ Up. 4dd 4 N3w U\$3r 8y \$3@rCHIn9 83l0w.";
$lang['editwordfilter'] = "eDIT W0Rd pH1L+3R";
$lang['userinformation'] = "user 1NF0rm4+10n";
$lang['changepassword'] = "cH4nGE p4\$\$w0rD";
$lang['currentpasswd'] = "cUrReN+ p45sW0rd";
$lang['newpasswd'] = "n3W Pa55wOrd";
$lang['confirmpasswd'] = "cONPhiRm p@s5w0rd";
$lang['passwdsdonotmatch'] = "pa\$Sword5 Do N0T m4TCH!";
$lang['nicknamerequired'] = "nIckN4mE 1S R3quIrEd!";
$lang['emailaddressrequired'] = "eMa1l 4dDR3S5 1s REquirEd!";
$lang['logonnotpermitted'] = "l090n N0T p3rm1++eD. Ch00SE 4n0+H3r!";
$lang['nicknamenotpermitted'] = "nIckn4m3 n0+ p3RM1++Ed. cHO0se ano+H3r!";
$lang['emailaddressnotpermitted'] = "em4il @DdRE55 N0+ P3rM1tTed. ch0ose 4n0tHER!";
$lang['emailaddressalreadyinuse'] = "em@1l 4ddr3sS @lR34Dy in u53. Cho0se 4NOTH3r!";
$lang['relationshipsupdated'] = "r3L@+10n5H1Ps upD@+eD!";
$lang['relationshipupdatefailed'] = "rEl4tIon\$hIP upD4t3d f@IL3D!";
$lang['preferencesupdated'] = "pR3PHER3nce\$ w3Re 5uccES5phuLly uPd4+ED.";
$lang['userdetails'] = "u\$er d3+4il\$";
$lang['memberno'] = "m3M8eR no.";
$lang['firstname'] = "f1R\$+ n@me";
$lang['lastname'] = "l4ST N4m3";
$lang['dateofbirth'] = "d4+3 0pH b1rth";
$lang['homepageURL'] = "h0MEP@9e url";
$lang['profilepicturedimensions'] = "proFIlE p1CtuRe (m4X 95x95Px)";
$lang['avatarpicturedimensions'] = "aV4T4R p1c+urE (m@X 15X15px)";
$lang['invalidattachmentid'] = "inVal1d @++4chm3nT. cH3ck tH4t 1s H@\$N'+ B33n DElE+3d.";
$lang['unsupportedimagetype'] = "un\$uPpoR+eD 1magE 4+t4Chm3n+. J00 C4n 0nly U\$3 jP9, G1f 4Nd PN9 1m493 4tt4chMeN+\$ Phor y0UR 4vat4r 4nD pRophiLe P1CtUr3.";
$lang['selectattachment'] = "sElec+ @T+@CHm3nT";
$lang['pictureURL'] = "p1cTur3 uRl";
$lang['avatarURL'] = "aV4+4R Url";
$lang['profilepictureconflict'] = "t0 usE @n 4++4ChM3NT F0r y0uR PR0PH1l3 p1CTUr3 +Eh p1ctUrE UrL PHIEld MU5T BE 8L@NK.";
$lang['avatarpictureconflict'] = "t0 U\$e 4n 4T+4chm3nt pHOr YoUR 4v4+4r Pic+Ur3 +h3 4v4T4r uRL ph1elD MUsT 83 8L4nk.";
$lang['attachmenttoolargeforprofilepicture'] = "seLeC+Ed 4tt4CHM3n+ I\$ t0o l4r93 pHor proFil3 p1C+Ur3. M@x1muM D1mEn\$1oN5 @rE %s";
$lang['attachmenttoolargeforavatarpicture'] = "sel3C+Ed 4t+4chM3n+ iS tOo L4rg3 f0r 4V4T4r p1Ctur3. m4XImUm DiM3n\$10N5 4rE %s";
$lang['failedtoupdateuserdetails'] = "some 0r 4LL 0f YOUR USER 4cC0uN+ DEt@iL\$ coulD N0+ B3 uPD@t3D. pLE@S3 +ry 494IN l4TeR.";
$lang['failedtoupdateuserpreferences'] = "sOME OR @LL 0ph Your USer pr3PHErenC35 c0uld n0+ B3 upD@+3d. pLe@\$3 +rY 4g@iN L4T3r.";
$lang['emailaddresschanged'] = "em41l 4ddrE\$5 H45 8E3n cH4NGED";
$lang['newconfirmationemailsuccess'] = "your eM4il 4ddREss h4\$ 83en CH4NgeD 4nD @ nEW conpHIrM4+i0N 3MAIl H4\$ 8eEn S3n+. Pl34\$3 checK 4nd R34d teh 3mAIL pHoR pHurTh3r 1N\$trUC+1ons.";
$lang['newconfirmationemailfailure'] = "j00 H4VE CH4n93D Y0UR 3M41l 4dDr3Ss, BU+ WE W3R3 uN48lE t0 5enD A CoNFIRm@TioN REQUe\$t. pLE45E C0nT4Ct +He FOrUm oWneR For 4\$s1st4NCe.";
$lang['forumoptions'] = "f0ruM oPt10ns";
$lang['notifybyemail'] = "nOt1FY BY 3m@1l oF p0\$+5 +o me";
$lang['notifyofnewpm'] = "nO+iPhY BY p0PUp of N3W PM M3S54gEs to M3";
$lang['notifyofnewpmemail'] = "n0T1Phy 8y EMAil 0F n3w pm m3Ss@93\$ +O Me";
$lang['daylightsaving'] = "aDju5+ f0r D@Yl1gh+ 54Vin9";
$lang['autohighinterest'] = "auT0mat1c@LLY M4Rk +hR34d\$ 1 p05T 1n 4s hiGH inTEr3St";
$lang['convertimagestolinks'] = "aU+om4+1CAlLY CoNV3r+ 3m8eDd3d 1M49e\$ In Po\$+\$ iNTO LINk\$";
$lang['thumbnailsforimageattachments'] = "tHUMbn@iLs for iM49E @++4ChMEN+s";
$lang['smallsized'] = "sM4LL \$izeD";
$lang['mediumsized'] = "m3dIuM siZED";
$lang['largesized'] = "l@R93 siz3D";
$lang['globallyignoresigs'] = "gL084LLy 1GNOre UsEr \$IgN4+uR3\$";
$lang['allowpersonalmessages'] = "alLOW 0theR U5ERS +0 SEnD M3 P3RS0n4l m3s\$493s";
$lang['allowemails'] = "aLLOw OTh3r u5eR5 +0 SEND m3 3M4ILs vi@ mY profIl3";
$lang['timezonefromGMT'] = "t1m3 Zone";
$lang['postsperpage'] = "p0stS p3r p@g3";
$lang['fontsize'] = "f0n+ SiZE";
$lang['forumstyle'] = "f0Rum 5+yLe";
$lang['forumemoticons'] = "fORUm em0+ic0nS";
$lang['startpage'] = "s+4RT p4Ge";
$lang['signaturecontainshtmlcode'] = "sIGN@+Ur3 Con+aIn5 HTml coDe";
$lang['savesignatureforuseonallforums'] = "s4ve Si9N4+ure pHOr u5e on alL f0rUmS";
$lang['preferredlang'] = "preFeRr3d L4n9u4g3";
$lang['donotshowmyageordobtoothers'] = "d0 Not SHow my 49e 0R d@t3 OPH 81R+h t0 oTh3R\$";
$lang['showonlymyagetoothers'] = "show only my 4Ge +O 0+h3rs";
$lang['showmyageanddobtoothers'] = "shOw 80th my 493 4ND D4te opH bir+h +O 0theRS";
$lang['showonlymydayandmonthofbirthytoothers'] = "sH0w only My D@y 4nd Mon+h 0F b1R+h T0 0thErs";
$lang['listmeontheactiveusersdisplay'] = "l1\$+ Me on +3h aC+IvE U\$ERs D1\$PL@Y";
$lang['browseanonymously'] = "brOW\$3 forum 4n0nYm0u\$Ly";
$lang['allowfriendstoseemeasonline'] = "bRow5e @nOnYm0u5LY, 8Ut @LlOw fR13Nd5 to 5e3 M3 4s 0nL1N3";
$lang['revealspoileronmouseover'] = "reVE4l sP0iL3R5 0n m0U5E Ov3R";
$lang['showspoilersinlightmode'] = "alw4y\$ shoW 5p01L3rs 1N LigHt M0d3 (U5E5 lI9hTer f0n+ CoL0UR)";
$lang['resizeimagesandreflowpage'] = "r3s1Z3 1M@9es @nd R3fL0w P4Ge T0 pREV3nT h0RIZ0n+4l \$croLLiNg.";
$lang['showforumstats'] = "sHoW FoRUm 5+4t\$ 4+ 8o+T0m 0PH M3554G3 P4nE";
$lang['usewordfilter'] = "eN4Bl3 w0rD F1lter.";
$lang['forceadminwordfilter'] = "fOrC3 uSe of 4dm1N wOrd PHiLTEr oN 4lL US3R\$ (iNC. 9uES+\$)";
$lang['timezone'] = "tIm3 ZOn3";
$lang['language'] = "l4nGu4ge";
$lang['emailsettings'] = "eM@iL @ND cOnt@CT S3TTin9S";
$lang['forumanonymity'] = "f0ruM 4nonYm1+y s3tt1nG5";
$lang['birthdayanddateofbirth'] = "bir+HD@Y @nD D4TE oF BIr+H DiSpL4Y";
$lang['includeadminfilter'] = "inCLUdE @DM1N W0RD f1lTER 1n mY l1s+.";
$lang['setforallforums'] = "s3t f0R 4ll ForUM\$?";
$lang['containsinvalidchars'] = "%s cOnT@in\$ INV4lid CH@R4C+3rS!";
$lang['homepageurlmustincludeschema'] = "h0M3P@9E Url Mu5+ iNCLuD3 H++P:// sCHeM4.";
$lang['pictureurlmustincludeschema'] = "piCTUrE UrL MuSt iNCLUD3 ht+P:// \$cH3m4.";
$lang['avatarurlmustincludeschema'] = "aV4tAr uRl MUS+ incLUdE H++p:// 5CH3M4.";
$lang['postpage'] = "p0\$T p@93";
$lang['nohtmltoolbar'] = "n0 hTmL TO0l84r";
$lang['displaysimpletoolbar'] = "d1\$PL4Y sIMpL3 h+ML +o0L84R";
$lang['displaytinymcetoolbar'] = "dI5pl4y WY\$1WYg h+Ml t0ol8@r";
$lang['displayemoticonspanel'] = "d1sPl@Y 3M0t1C0n5 p@nEl";
$lang['displaysignature'] = "dIsPl4Y S19n4tURE";
$lang['disableemoticonsinpostsbydefault'] = "d1S48le 3MOT1CON\$ 1n M3s54G3s BY def4uLt";
$lang['automaticallyparseurlsbydefault'] = "autOmA+1c@LLY p@R5e URLs iN Me\$5@9E5 bY DEf4UlT";
$lang['postinplaintextbydefault'] = "p0S+ 1N pl41N t3X+ 8y def4ULt";
$lang['postinhtmlwithautolinebreaksbydefault'] = "poSt 1N HtML W1+H @UT0-l1n3-8rE@Ks BY dEF4uLT";
$lang['postinhtmlbydefault'] = "p0S+ 1N H+Ml BY DEpH4ult";
$lang['postdefaultquick'] = "u\$e quIck rePlY BY D3Ph4uLt. (fUlL r3plY in MeNu)";
$lang['privatemessageoptions'] = "pr1vA+E M3\$5@9E 0P+10n5";
$lang['privatemessageexportoptions'] = "pR1V4+E MEss@9E 3XP0rt 0ptI0Ns";
$lang['savepminsentitems'] = "s@v3 4 c0py Of 34ch pM I S3nd in My SENt iT3M\$ FOLDEr";
$lang['includepminreply'] = "iNClUD3 mess@g3 8ODY WhEN R3PLyIN9 T0 Pm";
$lang['autoprunemypmfoldersevery'] = "au+0 prunE MY Pm PholD3rS EV3RY:";
$lang['friendsonly'] = "fRI3ND5 ONLY?";
$lang['globalstyles'] = "gL084L 5tyL35";
$lang['forumstyles'] = "f0Rum 5TyL3\$";
$lang['youmustenteryourcurrentpasswd'] = "j00 mus+ ENteR Y0uR cuRrEnT P4\$sWOrD";
$lang['youmustenteranewpasswd'] = "j00 muS+ 3N+3r @ nEW P@5Sw0rd";
$lang['youmustconfirmyournewpasswd'] = "j00 mU5t C0NF1RM y0ur n3w p@sSW0rD";
$lang['profileentriesmustnotincludehtml'] = "pr0PHIlE EnTRi3\$ MUSt NO+ 1NCLUdE Html";
$lang['failedtoupdateuserprofile'] = "f41L3d +0 uPd4+3 USER PR0filE";

// Polls (create_poll.php, poll_results.php) ---------------------------------------------

$lang['mustprovideanswergroups'] = "j00 mUs+ Prov1d3 \$oMe 4NSWer 9R0upS";
$lang['mustprovidepolltype'] = "j00 MUs+ pR0V1d3 @ Poll +yP3";
$lang['mustprovidepollresultsdisplaytype'] = "j00 MUs+ pROvIDE rE\$UlTs d1sPl@y tyP3";
$lang['mustprovidepollvotetype'] = "j00 must PrOv1D3 4 poLl v0TE tyPe";
$lang['mustprovidepollguestvotetype'] = "j00 MU5t spECipHy iPH 9u3s+\$ sh0uLD 83 4LLOW3d +0 v0+3";
$lang['mustprovidepolloptiontype'] = "j00 mu\$+ PROv1d3 4 P0Ll OpTiOn +yP3";
$lang['mustprovidepollchangevotetype'] = "j00 mU5t PR0v1de 4 P0Ll CH@ng3 v0+3 +YPe";
$lang['pollquestioncontainsinvalidhtml'] = "oN3 0r Mor3 of yOUr POLl QUe\$Ti0ns cont41ns inV@LiD H+ml.";
$lang['pleaseselectfolder'] = "pLe@53 SElEc+ a pH0lD3r";
$lang['mustspecifyvalues1and2'] = "j00 Mus+ spECIfy vAlu35 Ph0r 4N\$w3rs 1 4nd 2";
$lang['tablepollmusthave2groups'] = "t48ular PH0rm@+ P0LLS mU\$t h4V3 PREc153ly TW0 V0+1Ng 9R0ups";
$lang['nomultivotetabulars'] = "t4bul@r f0RM4T p0ll\$ c4nN0+ bE mul+i-VO+3";
$lang['nomultivotepublic'] = "pU8LIC 84ll0t\$ c@Nn0T b3 MuLTI-Vo+e";
$lang['abletochangevote'] = "j00 will 8e @8lE +0 Ch4N93 Y0Ur v0te.";
$lang['abletovotemultiple'] = "j00 w1ll bE 4bl3 +o votE mUl+IpL3 +1M35.";
$lang['notabletochangevote'] = "j00 W1LL n0+ 83 48L3 +0 CH@nG3 Y0uR v0Te.";
$lang['pollvotesrandom'] = "n0+E: PoLL vo+Es 4r3 r4nD0mly 9en3ratEd pHOR pr3vi3W onlY.";
$lang['pollquestion'] = "p0ll QuEsTiOn";
$lang['possibleanswers'] = "po\$5IbLe 4nSwer\$";
$lang['enterpollquestionexp'] = "eNTER +He AN5WERs F0r yOUr PoLl QUE\$+IOn.. iPh YOur p0ll Is 4 &quot;YE5/no&quot; QuEs+I0n, SimpLy 3NteR &quot;Ye5&quot; fOr 4N5WeR 1 ANd &quot;nO&quot; PH0r 4Nsw3r 2.";
$lang['numberanswers'] = "nO. @nsw3r5";
$lang['answerscontainHTML'] = "aN\$W3r\$ C0N+@iN h+ml (NOT 1NCLuD1n9 sI9na+ur3)";
$lang['optionsdisplay'] = "an5w3rs dI\$pL4Y +Yp3";
$lang['optionsdisplayexp'] = "hOw \$h0Uld the 4N5W3r5 83 pR3\$3NTed?";
$lang['dropdown'] = "aS DrOP-dowN L1\$t(5)";
$lang['radios'] = "a5 4 5eR13s OF RaD10 8ut+oN5";
$lang['votechanging'] = "vot3 chan9in9";
$lang['votechangingexp'] = "c@n 4 per\$oN cH@ngE HI\$ 0r H3r v0t3?";
$lang['guestvoting'] = "gu3\$T v0+ING";
$lang['guestvotingexp'] = "cAN gues+5 vOTE iN +h1\$ P0ll?";
$lang['allowmultiplevotes'] = "alL0w mult1pL3 Vote\$";
$lang['pollresults'] = "pOLL R35ul+\$";
$lang['pollresultsexp'] = "hOw w0uld j00 l1KE +o DI5Pl4Y +h3 r3\$ult\$ 0F your P0ll?";
$lang['pollvotetype'] = "poll v0+1N9 Typ3";
$lang['pollvotesexp'] = "h0W ShOuld +hE p0Ll 8e C0nDuct3d?";
$lang['pollvoteanon'] = "aNoNYm0USLy";
$lang['pollvotepub'] = "pUbL1c ball0t";
$lang['horizgraph'] = "h0RIZ0nt4l 9R4ph";
$lang['vertgraph'] = "v3R+1C4L gr@ph";
$lang['tablegraph'] = "t@BulaR FORm4+";
$lang['polltypewarning'] = "<b>w4RNIn9</b>: +H1\$ 1\$ 4 pu8l1c 84ll0+. your nAm3 wiLl B3 vI\$i8l3 neXT +0 +EH 0PTion j00 V0+3 pHOR.";
$lang['expiration'] = "expIR4+10n";
$lang['showresultswhileopen'] = "do j00 w4nt t0 \$how rE5ultS wH1l3 +H3 poll 1S Op3N?";
$lang['whenlikepollclose'] = "wh3N would J00 Like yOUr Poll T0 autom4tIc@lly Cl05E?";
$lang['oneday'] = "oN3 d@y";
$lang['threedays'] = "tHr33 day\$";
$lang['sevendays'] = "seven D@ys";
$lang['thirtydays'] = "thirty d@ys";
$lang['never'] = "n3Ver";
$lang['polladditionalmessage'] = "aDD1+10n4l m3\$\$@G3 (Op+I0n@l)";
$lang['polladditionalmessageexp'] = "dO J00 W4Nt To 1nCLuDe 4N 4dD1ti0n@l p05t 4fTEr +h3 P0Ll?";
$lang['mustspecifypolltoview'] = "j00 muS+ SP3ciFY A poLl +O viEW.";
$lang['pollconfirmclose'] = "aRE j00 sur3 j00 w@N+ +0 Cl0s3 thE phOLL0wiNg polL?";
$lang['endpoll'] = "enD p0Ll";
$lang['nobodyvotedclosedpoll'] = "nOb0dy vo+3d";
$lang['votedisplayopenpoll'] = "%s 4nd %s H4Ve VOTED.";
$lang['votedisplayclosedpoll'] = "%s 4nd %s V0+Ed.";
$lang['nousersvoted'] = "n0 U\$ER\$";
$lang['oneuservoted'] = "1 U53r";
$lang['xusersvoted'] = "%s Us3rS";
$lang['noguestsvoted'] = "no 9ueSTs";
$lang['oneguestvoted'] = "1 9Uest";
$lang['xguestsvoted'] = "%s 9UE\$+S";
$lang['pollhasended'] = "p0ll h@s eNdEd";
$lang['youvotedforpolloptionsondate'] = "j00 VOTeD for %s on %s";
$lang['thisisapoll'] = "thI\$ i\$ @ p0ll. cL1cK +O Vi3W r35ulTs.";
$lang['editpoll'] = "eD1t P0Ll";
$lang['results'] = "r3Sul+5";
$lang['resultdetails'] = "r35ul+ d3t41L5";
$lang['changevote'] = "ch4n9e v0T3";
$lang['pollshavebeendisabled'] = "p0lls H4Ve 8e3N D1548l3d by Teh f0rum oWn3r.";
$lang['answertext'] = "aN5w3r t3X+";
$lang['answergroup'] = "aN\$w3R 9r0up";
$lang['previewvotingform'] = "pR3VIEw vo+1n9 ph0Rm";
$lang['viewbypolloption'] = "vI3w by poll 0p+ioN";
$lang['viewbyuser'] = "view 8Y uS3R";

// Profiles (profile.php) ----------------------------------------------

$lang['editprofile'] = "eDI+ pRof1L3";
$lang['profileupdated'] = "pr0FIl3 uPd4tEd.";
$lang['profilesnotsetup'] = "teH Ph0RUM oWner HaS not \$et up prOF1l35.";
$lang['ignoreduser'] = "i9N0REd Us3R";
$lang['lastvisit'] = "l4st Vi5it";
$lang['userslocaltime'] = "u\$3R's L0c4L +1mE";
$lang['userstatus'] = "st@TU\$";
$lang['useractive'] = "oNL1n3";
$lang['userinactive'] = "in4Ct1v3 / 0FPhLIn3";
$lang['totaltimeinforum'] = "toT4l +1ME";
$lang['longesttimeinforum'] = "l0Ng3\$t S3Ssion";
$lang['sendemail'] = "s3ND em41L";
$lang['sendpm'] = "sEnd pm";
$lang['visithomepage'] = "v1s1T h0mEp493";
$lang['age'] = "agE";
$lang['aged'] = "a9ed";
$lang['birthday'] = "b1rThdAY";
$lang['registered'] = "rEgis+Er3d";
$lang['findpostsmadebyuser'] = "fiNd Po\$+\$ m@de by %s";
$lang['findpostsmadebyme'] = "f1ND P0s+5 mad3 by m3";
$lang['findthreadsstartedbyuser'] = "f1Nd +hr34d\$ s+@rTED by %s";
$lang['findthreadsstartedbyme'] = "fInD +hR3adS s+4RTed by me";
$lang['profilenotavailable'] = "prOFil3 n0+ Av4Il@blE.";
$lang['userprofileempty'] = "tH1s u\$ER H4\$ nOt FiLled 1N +He1R PR0fIl3 0r 1+ 15 se+ +0 Pr1V@+e.";

// Registration (register.php) -----------------------------------------

$lang['newuserregistrationsarenotpermitted'] = "s0rry, neW us3r rEg1\$+R4+IonS 4r3 No+ 4LlOWED RI9Ht NOw. pl345E checK b@Ck L@t3R.";
$lang['usernameinvalidchars'] = "us3RN4m3 C4N 0Nly c0Nt4in 4-z, 0-9, _ - CH4R@C+3r\$";
$lang['usernametooshort'] = "usErN@ME MuST Be @ mINimuM 0ph 2 cHar4C+3r\$ L0ng";
$lang['usernametoolong'] = "uSERN@M3 mUst 83 @ M4xIMuM 0ph 15 CH4R4Ct3rs L0ng";
$lang['usernamerequired'] = "a L0GOn N@M3 Is R3qu1Red";
$lang['passwdmustnotcontainHTML'] = "p4\$\$WORD mu5T N0t CoN+4In HtML +49s";
$lang['passwordinvalidchars'] = "p@Ssw0Rd C4N onLy COnT41n 4-Z, 0-9, _ - CH4raCT3rS";
$lang['passwdtooshort'] = "p4\$\$W0Rd mU5+ B3 4 miNiMUm oPh 6 ch4R4cT3rS L0NG";
$lang['passwdrequired'] = "a P4\$5word I\$ REQu1r3d";
$lang['confirmationpasswdrequired'] = "a ConF1rm4+10n P4sswOrD 15 R3QU1r3D";
$lang['nicknamerequired'] = "a n1CKn4m3 iS REQU1r3D";
$lang['emailrequired'] = "aN 3M41L @DDRES\$ Is reQu1REd";
$lang['passwdsdonotmatch'] = "p4\$sw0rD\$ do n0T m4tcH";
$lang['usernamesameaspasswd'] = "u\$3RN@ME @Nd p@S\$WOrD mUsT 8e D1PHfERENT";
$lang['usernameexists'] = "sorRY, 4 U\$3r w1TH tH4+ N4ME 4LRE4DY 3x1st\$";
$lang['successfullycreateduseraccount'] = "sUCc3\$SPhULlY CrE@TED uS3r @CCOuNt";
$lang['useraccountcreatedconfirmfailed'] = "yOUR U\$ER 4Cc0uN+ HA5 833N Cr3at3D 8uT +h3 R3qU1rED C0nf1rm4+10N EM4Il W4s n0t s3nt. PLE@\$E cont4c+ +EH FoRuM 0wNEr t0 REC+ify thI\$. 1n tH1S M34n+IM3 pl34s3 clicK T3h c0Nt1nU3 buTt0n +0 lO9in.";
$lang['useraccountcreatedconfirmsuccess'] = "y0UR u\$3R 4cCOUnT H4\$ 8E3N CR34+3d 8U+ 8ePh0Re J00 C4n \$+4r+ PosTING J00 MUs+ conPHIRM YoUr EmA1L 4dDR3sS. pL34s3 CH3cK yOuR Em4iL f0r @ L1nK +h4T W1LL @Ll0W j00 +0 Conf1RM Y0UR 4DdREss.";
$lang['useraccountcreated'] = "youR USeR 4cC0UN+ H4S bEeN cre4t3d sUCce\$\$FullY! Cl1Ck +Eh CoN+1nUe 8UtToN 83L0W +O l091n";
$lang['errorcreatinguserrecord'] = "eRRor cRE@T1n9 u5er R3C0rd";
$lang['userregistration'] = "us3r rE9IsTr4+iOn";
$lang['registrationinformationrequired'] = "r3GIStR4+10N 1NpH0RM4T10N (r3QUiRED)";
$lang['profileinformationoptional'] = "pROFIlE Inph0RmA+10N (0PT10n4l)";
$lang['preferencesoptional'] = "pRepHEREncEs (oPt10n4l)";
$lang['register'] = "regi5T3r";
$lang['rememberpasswd'] = "rEm3MBER P4\$SWoRd";
$lang['birthdayrequired'] = "d4+3 oPh BIr+H Is R3Qu1r3D 0r iS InV4l1D";
$lang['alwaysnotifymeofrepliestome'] = "n0+1pHY on rEplY +0 M3";
$lang['notifyonnewprivatemessage'] = "noTIFy 0N NEW priv4T3 M35\$493";
$lang['popuponnewprivatemessage'] = "p0p uP 0n n3w pRIV4TE MES54gE";
$lang['automatichighinterestonpost'] = "aUtoM@+iC h1Gh iN+ER3st on p0s+";
$lang['confirmpassword'] = "cOnf1RM p4\$Sw0rD";
$lang['invalidemailaddressformat'] = "iNV@L1d EM41l @ddR35s fOrM4T";
$lang['moreoptionsavailable'] = "mOR3 pRoPHIL3 @nD pR3ph3REncE 0pT1ON\$ 4r3 @V@1lA8l3 0NC3 J00 RE91\$+ER";
$lang['textcaptchaconfirmation'] = "c0NfIRM4+ioN";
$lang['textcaptchaexplain'] = "to tEh R19H+ 1\$ 4 +eX+-c@PtcH4 iM49E. PL3@5e +YPE +HE C0d3 j00 c4n sEe 1n tEh im4G3 InT0 t3h INPu+ Ph13Ld BeLOw 1t.";
$lang['textcaptchaimgtip'] = "thI\$ I5 @ C4pTch4-pIc+Ure. 1T I\$ usEd tO PreVENT 4ut0M4T1c r3GIStR4ti0N";
$lang['textcaptchamissingkey'] = "a C0nPH1Rm@+i0n COdE 1\$ reqUiR3D.";
$lang['textcaptchaverificationfailed'] = "t3X+-C4p+Ch@ V3R1phiC4t10n C0d3 was Inc0rR3c+. pl34\$3 re-3N+3r iT.";
$lang['forumrules'] = "foruM rULe5";
$lang['forumrulesnotification'] = "in 0RD3r +0 pr0ce3D, j00 mU\$+ 49rEe wi+H +3H foLL0WiN9 rul3S";
$lang['forumrulescheckbox'] = "i h4V3 RE@D, @ND @9rE3 +0 48Id3 8y thE f0ruM ruLes.";
$lang['youmustagreetotheforumrules'] = "j00 Mu5+ @9R3e To +hE F0rum rule\$ b3PHORE j00 Can C0ntinUe.";

// Recent visitors list  (visitor_log.php) -----------------------------

$lang['member'] = "mem83R";
$lang['searchforusernotinlist'] = "s34rCh ph0r 4 U53r nOT in li5t";
$lang['yoursearchdidnotreturnanymatches'] = "y0ur se@rch diD N0T r3+UrN @ny m4+cheS. TrY \$Impliphyin9 y0ur \$34RCh p4ram3+er5 4nd +Ry @941N.";
$lang['hiderowswithemptyornullvalues'] = "h1dE rOwS with EmptY or null v@lu3S 1n selEct3d CoLumn\$";
$lang['showregisteredusersonly'] = "sh0W re91\$+Er3D u5Ers oNly (H1dE Gu3S+s)";

// Relationships (user_rel.php) ----------------------------------------

$lang['relationships'] = "r3l4TIoNSH1p\$";
$lang['userrelationship'] = "u\$3r rel@Ti0N\$H1p";
$lang['userrelationships'] = "us3R R3l4t10n5HIPs";
$lang['failedtoremoveselectedrelationships'] = "f4IL3D +0 rEM0v3 s3l3c+ED reL@+1ON\$HIP";
$lang['friends'] = "frIeNd\$";
$lang['ignoredcompletely'] = "iGnOrED COMpletEly";
$lang['relationship'] = "reL4ti0NshIp";
$lang['restorenickname'] = "r35+0R3 u\$3R'5 niCKn@m3";
$lang['friend_exp'] = "u5Er'S P0ST5 m@rK3d wiTH 4 &quot;PHRi3ND&quot; 1CON.";
$lang['normal_exp'] = "u\$3r'S PoS+S @PpE@R 45 n0RM@l.";
$lang['ignore_exp'] = "uSEr's po\$+\$ @r3 hIDDEN.";
$lang['ignore_completely_exp'] = "tHRE4ds 4ND POsts T0 oR Fr0M us3r W1LL @PpE@r DEL3Ted.";
$lang['display'] = "dISpl4y";
$lang['displaysig_exp'] = "uS3r's s1gNa+uR3 1\$ dISpL@Yed oN TH3ir P0S+\$.";
$lang['hidesig_exp'] = "u5er's \$I9N@TUrE Is h1DDEN On THeiR Po5ts.";
$lang['cannotignoremod'] = "j00 c4nnot 1gnOre +HI\$ U5ER, @5 +H3Y 4r3 @ M0D3R4toR.";
$lang['previewsignature'] = "pr3V1ew 51gnATurE";

// Search (search.php) -------------------------------------------------

$lang['searchresults'] = "s34rCH RE5Ul+s";
$lang['usernamenotfound'] = "tHE u5ErN4mE J00 spEc1Ph1ED 1N Th3 t0 or from fI3Ld W4S N0+ found.";
$lang['notexttosearchfor'] = "one 0R 4Ll oF yOuR \$E@rcH K3Yw0Rd\$ wERE INV@lid. \$3@RCH kEYW0rd\$ mUST 8e N0 5H0RTER tH4n %d Ch@R4CTeR5, nO loN93r th4n %d CH@r4cTEr\$ ANd mu5+ nO+ @Pp34R 1N +3H %s";
$lang['keywordscontainingerrors'] = "keyWOrdS c0N+41nIN9 erR0r\$: %s";
$lang['mysqlstopwordlist'] = "mySQL st0pWoRD l1sT";
$lang['foundzeromatches'] = "fOuNd: 0 M@+Che\$";
$lang['found'] = "fOUNd";
$lang['matches'] = "mAtch3s";
$lang['prevpage'] = "pREv1oUs p@G3";
$lang['findmore'] = "f1nD MORe";
$lang['searchmessages'] = "se4rCH meS\$4g3\$";
$lang['searchdiscussions'] = "sE4rCH D1\$cu\$s10NS";
$lang['find'] = "f1nD";
$lang['additionalcriteria'] = "add1+i0n4l CR1Ter14";
$lang['searchbyuser'] = "sE@rcH 8Y U53R (oPt10N4l)";
$lang['folderbrackets_s'] = "f0LD3R(\$)";
$lang['postedfrom'] = "p05+Ed frOM";
$lang['postedto'] = "p0sTEd t0";
$lang['today'] = "todaY";
$lang['yesterday'] = "yE\$+3rd4Y";
$lang['daybeforeyesterday'] = "daY 83PhORe yE5terd4Y";
$lang['weekago'] = "%s WEek 4go";
$lang['weeksago'] = "%s w3Ek\$ 4GO";
$lang['monthago'] = "%s M0nTh 4g0";
$lang['monthsago'] = "%s M0NTh5 a90";
$lang['yearago'] = "%s y3@R @GO";
$lang['beginningoftime'] = "be91nning oF t1ME";
$lang['now'] = "nOw";
$lang['lastpostdate'] = "l@5+ Pos+ d@t3";
$lang['numberofreplies'] = "nuM83r Of repL1e5";
$lang['foldername'] = "fOldeR n4m3";
$lang['authorname'] = "aU+hoR n4m3";
$lang['decendingorder'] = "n3W3ST f1rs+";
$lang['ascendingorder'] = "oldes+ f1Rst";
$lang['keywords'] = "k3Yw0rd\$";
$lang['sortby'] = "s0RT 8Y";
$lang['sortdir'] = "soR+ Dir";
$lang['sortresults'] = "sOrt r3SUL+\$";
$lang['groupbythread'] = "gROup 8y tHR3Ad";
$lang['postsfromuser'] = "pOsTs from U53r";
$lang['threadsstartedbyuser'] = "thr3@DS s+@r+eD 8Y User";
$lang['searchfrequencyerror'] = "j00 CAN 0nly 534rCh oNCE 3v3ry %s 53C0nds. pl34\$3 tRy @Ga1n la+3r.";
$lang['searchsuccessfullycompleted'] = "s34RCh \$ucC3\$SfUlly CoMpLEt3D. %s";
$lang['clickheretoviewresults'] = "cL1Ck HER3 +0 vi3w R3suLt5.";

// Search Popup (search_popup.php) -------------------------------------

$lang['select'] = "s3LeCT";
$lang['searchforthread'] = "seArcH phoR THr34D";
$lang['mustspecifytypeofsearch'] = "j00 MU5t sp3CiphY tYPe 0f \$3@Rch +o pErfoRM";
$lang['unkownsearchtypespecified'] = "uNkn0Wn S3@rCh Typ3 \$PEc1ph1eD";
$lang['mustentersomethingtosearchfor'] = "j00 mU5t entER som3+hiN9 To 53ARCh ph0r";

// Start page (start_left.php) -----------------------------------------

$lang['recentthreads'] = "r3CeN+ thr34d\$";
$lang['startreading'] = "s+4r+ rE@d1n9";
$lang['threadoptions'] = "tHRE4D 0P+ions";
$lang['editthreadoptions'] = "eD1t +hr3aD 0p+10n\$";
$lang['morevisitors'] = "m0r3 v1\$I+0r\$";
$lang['forthcomingbirthdays'] = "foR+hC0m1n9 8ir+HD@Y\$";

// Start page (start_main.php) -----------------------------------------

$lang['editstartpage_help'] = "j00 c4n eDI+ +h1s p4g3 FRoM +3h @Dm1n int3Rph4ce";

// Thread navigation (thread_list.php) ---------------------------------

$lang['newdiscussion'] = "n3W di\$cu5\$Ion";
$lang['createpoll'] = "cr3@T3 poLL";
$lang['search'] = "s34RCh";
$lang['searchagain'] = "sEarch a941n";
$lang['alldiscussions'] = "aLL Discu\$sI0n5";
$lang['unreaddiscussions'] = "uNR34D d1scU55i0ns";
$lang['unreadtome'] = "uNr34D &quot;+0: m3&quot;";
$lang['todaysdiscussions'] = "tOD4Y's D15cUS51ONs";
$lang['2daysback'] = "2 d@Y5 84ck";
$lang['7daysback'] = "7 D4y5 b@Ck";
$lang['highinterest'] = "h1GH 1N+3r3ST";
$lang['unreadhighinterest'] = "uNr34d H19H 1NTErEs+";
$lang['iverecentlyseen'] = "i'v3 ReC3n+Ly s33n";
$lang['iveignored'] = "i'v3 iGN0r3d";
$lang['byignoredusers'] = "by 1gnor3d u\$3RS";
$lang['ivesubscribedto'] = "i've \$U8scR183D TO";
$lang['startedbyfriend'] = "s+4rT3D 8y fR1ENd";
$lang['unreadstartedbyfriend'] = "uNre4D s+d 8y frI3ND";
$lang['startedbyme'] = "st@r+3d 8Y M3";
$lang['unreadtoday'] = "uNr34d t0d@y";
$lang['deletedthreads'] = "d3Le+eD +HR34dS";
$lang['goexcmark'] = "g0!";
$lang['folderinterest'] = "folD3r inT3r35+";
$lang['postnew'] = "po5t N3W";
$lang['currentthread'] = "curr3N+ Thr34d";
$lang['highinterest'] = "hI9h inTER35+";
$lang['markasread'] = "m@RK 45 RE4D";
$lang['next50discussions'] = "n3X+ 50 dIsCu\$S10nS";
$lang['visiblediscussions'] = "v15ibL3 d1\$cU5s1OnS";
$lang['selectedfolder'] = "sEl3c+eD f0lD3r";
$lang['navigate'] = "n4V19@tE";
$lang['couldnotretrievefolderinformation'] = "tH3Re @re n0 phoLD3r\$ 4v41l4BL3.";
$lang['nomessagesinthiscategory'] = "no m3\$\$4ges 1n +h1s C@+Eg0ry. pl3A\$3 SEl3c+ @N0tH3r, 0r %s pHOR 4ll THRE@d\$";
$lang['clickhere'] = "cliCk Her3";
$lang['prev50threads'] = "pr3v1OuS 50 thr3@d5";
$lang['next50threads'] = "n3xT 50 thrE4d\$";
$lang['nextxthreads'] = "next %s +HR3@Ds";
$lang['threadstartedbytooltip'] = "tHr34d #%s ST4RtED by %s. VI3wed %s";
$lang['threadviewedonetime'] = "1 TIm3";
$lang['threadviewedtimes'] = "%d +1m3s";
$lang['unreadthread'] = "uNR3@d +hRe4d";
$lang['readthread'] = "re4d +hr34d";
$lang['unreadmessages'] = "unR34d mEsS@GE5";
$lang['subscribed'] = "sub\$cr18eD";
$lang['stickythreads'] = "sTIckY +HR3@ds";
$lang['mostunreadposts'] = "m0S+ unr3@D P05+\$";
$lang['onenew'] = "%d n3W";
$lang['manynew'] = "%d nEW";
$lang['onenewoflength'] = "%d n3w OPh %d";
$lang['manynewoflength'] = "%d New OF %d";
$lang['confirmmarkasread'] = "aRe J00 \$urE J00 w4n+ +o m@RK THE \$3l3C+ED THRe4dS 4s re@D?";
$lang['successfullymarkreadselectedthreads'] = "succE5sFULLY M4rk3D \$3l3c+eD THR3@D5 4\$ R34d";
$lang['failedtomarkselectedthreadsasread'] = "f@iL3d T0 M4rK 5EL3ct3d +HR3@DS @5 R34D";
$lang['gotofirstpostinthread'] = "go tO F1R5+ pOs+ 1n +hrE@D";
$lang['gotolastpostinthread'] = "g0 +O L@s+ Post 1n +Hr34D";
$lang['viewmessagesinthisfolderonly'] = "viEW MESs4935 1n tH1\$ PHolD3R 0nLy";
$lang['shownext50threads'] = "sHOW n3XT 50 Thr3@D\$";
$lang['showprev50threads'] = "shOw PrEV1Ous 50 +hR3@D\$";
$lang['createnewdiscussioninthisfolder'] = "cre@T3 nEW DiSCu\$si0N in +H1S PhOldeR";
$lang['nomessages'] = "nO ME\$\$4935";

// HTML toolbar (htmltools.inc.php) ------------------------------------
$lang['bold'] = "b0ld";
$lang['italic'] = "i+@L1C";
$lang['underline'] = "und3rl1nE";
$lang['strikethrough'] = "striK3tHR0u9h";
$lang['superscript'] = "suPeR\$cRiP+";
$lang['subscript'] = "su8sCRIP+";
$lang['leftalign'] = "l3ph+-4lIGN";
$lang['center'] = "c3NT3R";
$lang['rightalign'] = "righT-4li9n";
$lang['numberedlist'] = "nUmBERED L1\$+";
$lang['list'] = "li5T";
$lang['indenttext'] = "inDENT T3X+";
$lang['code'] = "c0dE";
$lang['quote'] = "qu0te";
$lang['unquote'] = "unQuo+3";
$lang['spoiler'] = "sP0il3r";
$lang['horizontalrule'] = "h0R1Z0N+@l rule";
$lang['image'] = "im4G3";
$lang['hyperlink'] = "hYpERliNK";
$lang['noemoticons'] = "dIS4BLe Em0+ICONs";
$lang['fontface'] = "f0N+ pH@ce";
$lang['size'] = "sIZE";
$lang['colour'] = "coloUr";
$lang['red'] = "r3d";
$lang['orange'] = "oR4NG3";
$lang['yellow'] = "y3llOw";
$lang['green'] = "gR3EN";
$lang['blue'] = "blU3";
$lang['indigo'] = "inD1gO";
$lang['violet'] = "v1OLE+";
$lang['white'] = "wH1t3";
$lang['black'] = "bL4ck";
$lang['grey'] = "gR3y";
$lang['pink'] = "p1NK";
$lang['lightgreen'] = "l19HT gr33n";
$lang['lightblue'] = "lIGHT BlU3";

// Forum Stats --------------------------------

$lang['forumstats'] = "f0RUM \$t4+S";
$lang['userstats'] = "uS3R 5T4+s";

$lang['usersactiveinthepasttimeperiod'] = "%s @ctIv3 1N tH3 p@\$+ %s. %s";

$lang['numactiveguests'] = "<b>%s</b> 9u3st5";
$lang['oneactiveguest'] = "<b>1</b> 9u3sT";
$lang['numactivemembers'] = "<b>%s</b> m3m8eR5";
$lang['oneactivemember'] = "<b>1</b> M3mB3R";
$lang['numactiveanonymousmembers'] = "<b>%s</b> @n0nyM0us MeMb3Rs";
$lang['oneactiveanonymousmember'] = "<b>1</b> aNONymoU\$ M3mb3r";

$lang['numthreadscreated'] = "<b>%s</b> +hrE4D\$";
$lang['onethreadcreated'] = "<b>1</b> +Hr3Ad";
$lang['numpostscreated'] = "<b>%s</b> Po\$+S";
$lang['onepostcreated'] = "<b>1</b> pO5+";

$lang['younormal'] = "j00";
$lang['youinvisible'] = "j00 (1nviSIBl3)";
$lang['viewcompletelist'] = "viEW ComPLe+E lis+";
$lang['ourmembershavemadeatotalofnumthreadsandnumposts'] = "our memBErs h4v3 M4d3 4 toT@L oF %s 4nd %s.";
$lang['longestthreadisthreadnamewithnumposts'] = "l0ng35+ tHr34d 1s <b>%s</b> WI+h %s.";
$lang['therehavebeenxpostsmadeinthelastsixtyminutes'] = "th3R3 h4Ve 833N <b>%s</b> P0\$TS M@De iN Th3 l@\$+ 60 miNUt35.";
$lang['therehasbeenonepostmadeinthelastsxityminutes'] = "tHer3 Has B3en <b>1</b> P0\$+ m@DE In TH3 L45+ 60 MINUtEs.";
$lang['mostpostsevermadeinasinglesixtyminuteperiodwasnumposts'] = "mo5+ pOs+\$ 3v3r m4d3 iN 4 s1N9LE 60 MinuT3 p3r1oD is <b>%s</b> 0N %s.";
$lang['wehavenumregisteredmembersandthenewestmemberismembername'] = "w3 h4V3 <b>%s</b> RE9i5TEr3d m3M8ers @nD +Eh N3w3St M3m83r Is <b>%s</b>.";
$lang['wehavenumregisteredmember'] = "w3 H4v3 %s r3g1\$terEd m3mB3r\$.";
$lang['wehaveoneregisteredmember'] = "w3 h4v3 0ne rEgISt3R3D m3M83R.";
$lang['mostuserseveronlinewasnumondate'] = "m0\$t us3rS Ev3R onl1n3 w4S <b>%s</b> 0n %s.";
$lang['statsdisplaychanged'] = "sT@Ts DI5PLaY Ch4nG3D";

$lang['viewtop20'] = "vi3w t0p 20";

$lang['folderstats'] = "f0LD3R s+@TS";
$lang['threadstats'] = "thR34d \$t@+s";
$lang['poststats'] = "p0St S+4Ts";
$lang['pollstats'] = "p0lL s+4ts";
$lang['attachmentsstats'] = "a++4chM3ntS st4T\$";
$lang['userpreferencesstats'] = "user pR3pH3rEnc3\$ \$T4T5";
$lang['visitorstats'] = "visit0R 5+4+s";
$lang['sessionstats'] = "sEssi0N st4+s";
$lang['profilestats'] = "prOf1l3 \$t4+s";
$lang['signaturestats'] = "sIgn4+ur3 St4T\$";
$lang['ageandbirthdaystats'] = "aGE 4nD 8iR+hd4y \$+4Ts";
$lang['relationshipstats'] = "r3l4+IoNsh1p 5t@+s";
$lang['wordfilterstats'] = "woRD PhILtER s+4T5";

$lang['numberoffolders'] = "nUmB3r oph ph0ldErs";
$lang['folderwithmostthreads'] = "fOld3r W1th m0S+ tHR34d\$";
$lang['folderwithmostposts'] = "f0LD3R W1+H mo\$+ PO\$TS";
$lang['totalnumberofthreads'] = "tOt@l num83r Of tHreAD\$";
$lang['longestthread'] = "lONgEs+ +Hr34d";
$lang['mostreadthread'] = "m0S+ re4d +hr3@D";
$lang['threadviews'] = "v13W5";
$lang['averagethreadcountperfolder'] = "aV3r49e +HR34d COun+ P3r f0LD3r";
$lang['totalnumberofthreadsubscriptions'] = "t0+aL nUmBER OF thrE4d subsCRip+1On\$";
$lang['mostpopularthreadbysubscription'] = "m0\$+ p0PuL4R ThrE@D 8y su8\$CRiPTION";
$lang['totalnumberofposts'] = "tOtAl numBeR 0ph p0\$TS";
$lang['numberofpostsmadeinlastsixtyminutes'] = "nuM8ER 0PH pOst\$ M4de 1N L@s+ 60 MiNu+35";
$lang['mostpostsmadeinasinglesixtyminuteperiod'] = "mo\$t p0\$Ts mAdE 1n 0n3 60 m1nu+3 p3Riod";
$lang['averagepostsperuser'] = "aveR@GE p0S+\$ P3r U53r";
$lang['topposter'] = "tOp p0S+3r";
$lang['totalnumberofpolls'] = "tO+4L nUmb3r OPh pOLL\$";
$lang['totalnumberofpolloptions'] = "tot@L NUmber 0F P0LL 0P+10n5";
$lang['averagevotesperpoll'] = "av3r93 v0T35 p3R P0ll";
$lang['totalnumberofpollvotes'] = "t0+4l nUm83r oF p0LL v0+3\$";
$lang['totalnumberofattachments'] = "t0+4l Num83r oPh 4+t4ChMeNTS";
$lang['averagenumberofattachmentsperpost'] = "aVer@9E 4++4ChmeNt C0un+ p3R po\$+";
$lang['mostdownloadedattachment'] = "m05t dOWnl04Ded 4tT@ChMeNt";
$lang['mostusedforumstyle'] = "mos+ uS3d F0rum \$+YlE";
$lang['mostusedlanguuagefile'] = "m0s+ u\$ED l4ngU@93 Ph1le";
$lang['mostusedtimezone'] = "m0\$+ u\$Ed TIm3zoN3";
$lang['mostusedemoticonpack'] = "mosT useD Em0tic0N P4cK";

$lang['numberofusers'] = "nUm83R Oph uSeR5";
$lang['newestuser'] = "neWE5t Us3R";
$lang['numberofcontributingusers'] = "num8eR OF ConTrI8uTiNg U\$eRS";
$lang['numberofnoncontributingusers'] = "nUMB3R OpH NoN-C0ntrIBU+1ng U\$3R\$";
$lang['subscribers'] = "sUbScRI83r\$";

$lang['numberofvisitorstoday'] = "nuMB3r 0PH V151+0r5 +od4Y";
$lang['numberofvisitorsthisweek'] = "nUMBEr 0pH v151toR\$ +hI5 We3k (P3r1oD: %s T0 %s)";
$lang['numberofvisitorsthismonth'] = "num8er Of Vi\$I+orS Th1\$ m0NTh";
$lang['numberofvisitorsthisyear'] = "nuM8er OF V15IT0Rs TH15 Ye@r";

$lang['totalnumberofactiveusers'] = "tO+4l NUM83R oF 4C+1vE U\$erS";
$lang['numberofactiveregisteredusers'] = "numB3r 0Ph 4C+1Ve rEG1\$+er3D u53rs";
$lang['numberofactiveguests'] = "num83r 0pH ACTIV3 9UES+s";
$lang['mostuserseveronline'] = "m0S+ u\$eR5 ev3R oNLIn3";
$lang['mostactiveuser'] = "m0\$+ @CTIVE uS3R";
$lang['numberofuserswithprofile'] = "numBEr OF U\$3r\$ w1+h pR0F1Le";
$lang['numberofuserswithoutprofile'] = "nUmb3R 0Ph U5Er\$ WItHOuT proFIlE";
$lang['numberofuserswithsignature'] = "nUmB3r OPh U\$3R5 w1+h s19N@+Ur3";
$lang['numberofuserswithoutsignature'] = "nUmB3r 0f U\$3R\$ W1+h0U+ s1gN4+URE";
$lang['averageage'] = "avER@9e 49E";
$lang['mostpopularbirthday'] = "mo\$T pOpul@r b1RtHD4Y";
$lang['nobirthdaydataavailable'] = "no 81r+hD4Y DaT@ 4v@ILaBL3";
$lang['numberofusersusingwordfilter'] = "nuM8ER 0pH U5ErS U\$iNG W0Rd ph1lT3r";
$lang['numberofuserreleationships'] = "nUm83R Oph U5er R3l3@+1oNsH1ps";
$lang['averageage'] = "aV3R@9E 4g3";
$lang['averagerelationshipsperuser'] = "aVeR49E REl4T1On\$hIps PER U\$Er";

$lang['numberofusersnotusingwordfilter'] = "nuM83r 0ph Us3R\$ nO+ USIN9 w0rd f1L+ER";
$lang['averagewordfilterentriesperuser'] = "aV3R@9E worD PhIl+eR 3n+rIE5 Per U\$3r";

$lang['mostuserseveronlinedetail'] = "%s 0n %s";

// Thread Options (thread_options.php) ---------------------------------

$lang['updatessavedsuccessfully'] = "uPd@+3S 5@V3d 5ucC3sspHUlly";
$lang['useroptions'] = "us3r 0p+1ons";
$lang['markedasread'] = "m4RKEd 45 R3@D";
$lang['postsoutof'] = "postS out 0pH";
$lang['interest'] = "iNteR3s+";
$lang['closedforposting'] = "cLo5ed f0r po\$+ING";
$lang['locktitleandfolder'] = "l0ck +i+l3 4nd phoLdER";
$lang['deletepostsinthreadbyuser'] = "d3L3+3 p05+\$ 1N +hRE@D 8y U\$Er";
$lang['deletethread'] = "d3le+e +HRE4d";
$lang['permenantlydelete'] = "peRm4nENTLY DeL3+E";
$lang['movetodeleteditems'] = "mOv3 +o D3l3t3D tHr34DS";
$lang['undeletethread'] = "uNDEleT3 ThREAD";
$lang['markasunread'] = "m4RK 4s UnRE@D";
$lang['makethreadsticky'] = "m4K3 ThRE@d StiCKy";
$lang['threareadstatusupdated'] = "thre4d r3@D s+@TU\$ UPd4+3d \$ucc3sSphULlY";
$lang['interestupdated'] = "tHR34d 1n+3ReS+ 5+4+U\$ uPD@tEd sUCcessFUllY";
$lang['failedtoupdatethreadreadstatus'] = "f41L3D To UpD4+e +hre4D R34d \$+4tu\$";
$lang['failedtoupdatethreadinterest'] = "f4iL3d +0 uPd@TE THr34d 1nt3ReS+";
$lang['failedtorenamethread'] = "fAiL3d +O reN4ME +hR3@D";
$lang['failedtomovethread'] = "faIL3D +o m0V3 +HR34D T0 sPeCIf13d FoLD3R";
$lang['failedtoupdatethreadstickystatus'] = "f4IlEd +o uPD@Te tHR34D \$+iCkY sT4+Us";
$lang['failedtoupdatethreadclosedstatus'] = "f@1Led +0 UpD4+3 +hRe4d ClOS3d \$+4+U\$";
$lang['failedtoupdatethreadlockstatus'] = "failEd +o uPd4+3 ThR34D LOCK S+4+U5";
$lang['failedtodeletepostsbyuser'] = "faiL3d to d3leTe p0S+S 8Y SeLected U\$Er";
$lang['failedtodeletethread'] = "f@ilEd +0 DEl3+3 THREAd.";
$lang['failedtoundeletethread'] = "failEd +0 Un-d3leT3 +Hr3@d";

// Folder Options (folder_options.php) ---------------------------------

$lang['folderoptions'] = "fOLd3r opT1oNs";
$lang['foldercouldnotbefound'] = "thE R3Qu35t3D FOLder c0ULD n0t 83 F0UND 0r 4CCeS\$ w4s DEnIED.";
$lang['failedtoupdatefolderinterest'] = "f@1L3d +o UpD4t3 pH0Ld3R 1nTER3S+";

// Dictionary (dictionary.php) -----------------------------------------

$lang['dictionary'] = "d1c+1on@ry";
$lang['spellcheck'] = "sp3lL cHECK";
$lang['notindictionary'] = "n0t IN D1cT1on@Ry";
$lang['changeto'] = "cH@Ng3 t0";
$lang['restartspellcheck'] = "r35+aRt";
$lang['cancelchanges'] = "caNCEl Ch@n9Es";
$lang['initialisingdotdotdot'] = "iN1+i@L1\$1n9...";
$lang['spellcheckcomplete'] = "sPelL CheCk Is coMPLETE. t0 r35+4R+ \$P3lL CHEck cl1cK RES+4RT BUt+oN 83l0w.";
$lang['spellcheck'] = "sp3Ll cH3ck";
$lang['noformobj'] = "nO ForM O8j3C+ \$pEcIpH13d pHOR R3tURn +3x+";
$lang['bodytext'] = "b0Dy +3XT";
$lang['ignore'] = "i9n0R3";
$lang['ignoreall'] = "i9n0Re ALl";
$lang['change'] = "ch4NG3";
$lang['changeall'] = "ch@nGe 4ll";
$lang['add'] = "adD";
$lang['suggest'] = "sU9g3\$T";
$lang['nosuggestions'] = "(N0 \$U9GE\$+1On5)";
$lang['cancel'] = "c4nC3l";
$lang['dictionarynotinstalled'] = "no dIcT1ON4ry h4\$ 83en 1ns+@llED. Pl3@53 C0n+4C+ +He phoruM OWnEr +0 rEm3dy tHiS.";

// Permissions keys ----------------------------------------------------

$lang['postreadingallowed'] = "p0S+ R34d1ng @LloWeD";
$lang['postcreationallowed'] = "pO\$+ CRE@ti0n @LlowEd";
$lang['threadcreationallowed'] = "tHr34d Cr34tion 4ll0weD";
$lang['posteditingallowed'] = "pO\$T ED1+1nG 4LloWed";
$lang['postdeletionallowed'] = "p05+ D3LE+10N 4LLoW3d";
$lang['attachmentsallowed'] = "a+T@CHMeN+5 4ll0W3d";
$lang['htmlpostingallowed'] = "h+ml Po5Tin9 4lL0W3D";
$lang['signatureallowed'] = "sI9n4ture 4llowEd";
$lang['guestaccessallowed'] = "gU3s+ @ccEs\$ 4lLowED";
$lang['postapprovalrequired'] = "pos+ @PpRov@l R3quiReD";

// RSS feeds gubbins

$lang['rssfeed'] = "r5\$ FeEd";
$lang['every30mins'] = "eV3rY 30 MINUTE\$";
$lang['onceanhour'] = "once 4N hoUr";
$lang['every6hours'] = "ev3ry 6 HoUr5";
$lang['every12hours'] = "eV3ry 12 hOURs";
$lang['onceaday'] = "oNcE 4 D4y";
$lang['onceaweek'] = "oNCE A W3Ek";
$lang['rssfeeds'] = "r\$s pH3eD\$";
$lang['feedname'] = "fe3d n4m3";
$lang['feedfoldername'] = "f33d phOLDER NAM3";
$lang['feedlocation'] = "f33d L0c4+i0n";
$lang['threadtitleprefix'] = "tHRe4D T1+l3 PR3FIX";
$lang['feednameandlocation'] = "fE3D NAm3 4nD l0C@T1oN";
$lang['feedsettings'] = "f3ED S3T+1NGs";
$lang['updatefrequency'] = "uPD@+3 FReQuenCY";
$lang['rssclicktoreadarticle'] = "cL1Ck HeR3 T0 R3Ad th1\$ @RTicle";
$lang['addnewfeed'] = "aDd n3w Ph3Ed";
$lang['editfeed'] = "eDi+ F33d";
$lang['feeduseraccount'] = "fE3D U5eR 4CC0un+";
$lang['noexistingfeeds'] = "n0 ex1STIn9 rs\$ F3EdS FounD. +0 @dD 4 f33d cLiCK +h3 '4dD n3W' Bu+TOn b3low";
$lang['rssfeedhelp'] = "h3R3 J00 c4n s3tUP S0Me r5s PhE3dS f0R @u+oM@+1c Pr0p@94+ION iN+o y0Ur pH0rUm. T3H IT3m5 frOM +HE rsS Ph3eDs J00 4dD w1Ll b3 Cre4t3D 45 THRE@d5 WhICH u5eR5 c@n r3pLy T0 4\$ ipH +H3y W3rE N0RM4L p0s+\$. +he r5\$ pH33D Mu5T B3 4CC3ssI8Le v1@ HTtP Or i+ w1Ll n0T WoRK.";
$lang['mustspecifyrssfeedname'] = "mU\$+ sPec1fy RSs PhEEd n@Me";
$lang['mustspecifyrssfeeduseraccount'] = "muS+ sPEC1FY RsS pH33D uSER 4cc0UNT";
$lang['mustspecifyrssfeedfolder'] = "mus+ \$peC1Phy Rs\$ f3eD F0lDEr";
$lang['mustspecifyrssfeedurl'] = "mu\$t 5p3C1PhY rs\$ PHEed uRL";
$lang['mustspecifyrssfeedupdatefrequency'] = "mus+ SpEcIPhY R\$s pHeed uPD4+3 FR3Qu3nCY";
$lang['unknownrssuseraccount'] = "uNknOwN R5\$ UsEr 4cCoUnT";
$lang['rssfeedsupportshttpurlsonly'] = "rss FEeD SuPP0R+S hT+P UrL\$ OnLy. SEcuRE ph33ds (h++P5://) 4r3 nO+ \$UPpOrT3d.";
$lang['rssfeedurlformatinvalid'] = "r5S Fe3d uRl phorM@t i\$ 1nV@lId. Url MUs+ 1NCLud3 \$Ch3M3 (e.9. Http://) and a hOstn4M3 (3.G. wWW.h0stN4M3.coM).";
$lang['rssfeeduserauthentication'] = "rs5 Fe3d DOE\$ Not 5upp0r+ hTtp U\$3r @u+H3NTIc4+1On";
$lang['successfullyremovedselectedfeeds'] = "sUcCE\$SPHULly REM0V3d Sel3ct3D f3eds";
$lang['successfullyaddedfeed'] = "sucCESSphULlY 4ddED N3w FE3d";
$lang['successfullyeditedfeed'] = "sucCe5SPhULlY Ed1+3D pH33D";
$lang['failedtoremovefeeds'] = "f4ilEd +0 r3M0v3 5omE 0r 4LL 0pH +He sElECT3D pH3ed\$";
$lang['failedtoaddnewrssfeed'] = "f4il3d +0 ADD n3W rss ph3eD";
$lang['failedtoupdaterssfeed'] = "f4il3d t0 UPd4+3 Rs\$ f3Ed";
$lang['rssstreamworkingcorrectly'] = "rs5 5+Re4m 4ppE4rs +0 8e worK1ng corR3cTly";
$lang['rssstreamnotworkingcorrectly'] = "rss s+Re4M WA\$ EmP+Y 0r C0uLD nOt B3 pHouNd";
$lang['invalidfeedidorfeednotfound'] = "iNV4lId ph3Ed 1d Or PhEed NoT PHoUND";

// PM Export Options

$lang['pmexportastype'] = "expOR+ a5 tyP3";
$lang['pmexporthtml'] = "h+mL";
$lang['pmexportxml'] = "xmL";
$lang['pmexportplaintext'] = "pl41n teX+";
$lang['pmexportmessagesas'] = "eXp0r+ mESS@9e\$ 4s";
$lang['pmexportonefileforallmessages'] = "on3 FIL3 FOR @Ll m3ss4g3S";
$lang['pmexportonefilepermessage'] = "oNE PH1l3 P3R m3\$54ge";
$lang['pmexportattachments'] = "exp0rt @+TaChm3nts";
$lang['pmexportincludestyle'] = "iNclud3 pHoruM STYLe sHE3+";
$lang['pmexportwordfilter'] = "appLY worD PH1lTER +o mE\$SA9E\$";

// Thread merge / split options

$lang['threadhasbeensplit'] = "tHr34D H4s 8eeN \$pl1t";
$lang['threadhasbeenmerged'] = "thR34D H@s 8eeN m3R9ed";
$lang['mergesplitthread'] = "mER9e / split tHr34D";
$lang['mergewiththreadid'] = "mERG3 wI+h +hR34d ID:";
$lang['postsinthisthreadatstart'] = "po\$TS in +h1s thr3@d at st4r+";
$lang['postsinthisthreadatend'] = "p0\$Ts 1N +hI\$ ThRe4d 4T ENd";
$lang['reorderpostsintodateorder'] = "re-0rD3r p0sts 1N+0 dA+3 0Rd3r";
$lang['splitthreadatpost'] = "sPL1+ Thr34D 4t p0\$T:";
$lang['selectedpostsandrepliesonly'] = "s3lEC+ed pOs+ And R3pli3\$ 0NLy";
$lang['selectedandallfollowingposts'] = "s3l3CTed 4Nd @Ll f0LlOW1n9 PoS+\$";

$lang['threadmovedhere'] = "hER3";

$lang['thisthreadhasmoved'] = "<b>thReAD\$ merg3d:</b> +h15 ThRead H@s Moved %s";
$lang['thisthreadwasmergedfrom'] = "<b>thr34D\$ M3rg3D:</b> +HI5 tHrE4d w4\$ MER9ed PHRom %s";
$lang['somepostsinthisthreadhavebeenmoved'] = "<b>tHR34D SPl1T:</b> \$OME Po\$+S 1n +h1\$ ThR34d h@VE 8EeN M0VED %s";
$lang['somepostsinthisthreadweremovedfrom'] = "<b>thREAD sPli+:</b> s0mE Po\$+5 iN +H15 +hR3@D WERe mOV3d fRoM %s";

$lang['thisposthasbeenmoved'] = "<b>tHre4d \$plI+:</b> Th15 PO\$+ H@s 8e3n MovED %s";

$lang['invalidfunctionarguments'] = "iNv@lID FuNCT10N 4r9uM3nt\$";
$lang['couldnotretrieveforumdata'] = "c0UlD N0+ Re+r1ev3 PhOrUm D4+4";
$lang['cannotmergepolls'] = "oN3 OR m0RE +hRe4D5 is @ poLl. J00 c@nnoT MEr9E polL\$";
$lang['couldnotretrievethreaddatamerge'] = "cOULD No+ RetrIEvE THrE@D d4+4 fRom ON3 OR m0r3 THRe4dS";
$lang['couldnotretrievethreaddatasplit'] = "c0uLD n0+ rEtR13Ve +hr34D D@+4 FR0M S0urCE thre4D";
$lang['couldnotretrievepostdatamerge'] = "cOulD n0+ R3+rIev3 p0\$t d4t4 fR0m on3 0r m0r3 +hRe4dS";
$lang['couldnotretrievepostdatasplit'] = "c0UlD not r3+r1evE pO5+ D@t4 fR0m \$0URCe +hrE@D";
$lang['failedtocreatenewthreadformerge'] = "f4IL3D to CRE4T3 n3w tHreaD pHoR MerG3";
$lang['failedtocreatenewthreadforsplit'] = "f@iLED +O crE@+3 New +HR3@d phor 5pliT";

// Thread subscriptions

$lang['threadsubscriptions'] = "tHrE4d \$u8sCr1p+i0Ns";
$lang['couldnotupdateinterestonthread'] = "cOULD n0+ uPD4+E 1nT3rES+ on thRE4d '%s'";
$lang['threadinterestsupdatedsuccessfully'] = "tHre4d 1n+3R3\$+s UPd@+3d sUCCES5pHUlly";
$lang['nothreadsubscriptions'] = "j00 4RE not sUBScr1B3d To any tHreAd\$.";
$lang['nothreadsignored'] = "j00 ArE N0t iGN0r1ng 4ny Thr3@dS.";
$lang['nothreadsonhighinterest'] = "j00 H4Ve N0 HIgh In+3R35+ +Hr34d5.";
$lang['resetselected'] = "rESET sEl3cted";
$lang['ignoredthreads'] = "igN0Red +hr3@d\$";
$lang['highinterestthreads'] = "h19H 1nt3r3\$+ +Hr34ds";
$lang['subscribedthreads'] = "sUb\$CRiB3d thre@D\$";
$lang['currentinterest'] = "cURR3N+ in+3R35t";

// Folder subscriptions

$lang['foldersubscriptions'] = "folD3r 5ub5cRIpTi0NS";
$lang['couldnotupdateinterestonfolder'] = "cOuLd noT Upd@Te 1NT3R3St oN phOLd3R '%s'";
$lang['folderinterestsupdatedsuccessfully'] = "foLder IN+er35ts upD@teD \$UCCe5\$PHUlly";
$lang['nofoldersubscriptions'] = "j00 4R3 N0+ subSCr1B3d +o aNY ph0LD3rS.";
$lang['nofoldersignored'] = "j00 4re no+ 19n0R1ng @Ny f0ldeRs.";
$lang['resetselected'] = "rE53t 53lec+3d";
$lang['ignoredfolders'] = "i9N0RED fOLdErs";
$lang['subscribedfolders'] = "sUb\$cRiB3D f0ldErs";

// Browseable user profiles

$lang['youcanonlyaddthreecolumns'] = "j00 c4N 0Nly 4dd 3 c0lumnS. +o Add a N3w C0lumn clo53 4n 3xi5+in9 On3";
$lang['columnalreadyadded'] = "j00 havE @lR34dY @dDed +H1\$ C0LUmN. iph J00 w@N+ t0 reMovE 1t Cl1CK ItS clos3 bUT+0N";

?>