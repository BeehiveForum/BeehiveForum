<?php

/*======================================================================
Copyright Project BeehiveForum 2002

This file is part of BeehiveForum.

BeehiveForum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

BeehiveForum is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
USA
======================================================================*/

/* $Id: x-hacker.inc.php,v 1.247 2007-09-10 12:36:20 decoyduck Exp $ */

// British English language file

// Language character set and text direction options -------------------

$lang['_isocode'] = "en";
$lang['_textdir'] = "ltr";

// Months --------------------------------------------------------------

$lang['month'][1]  = "j@NuarY";
$lang['month'][2]  = "f38RU@RY";
$lang['month'][3]  = "m4rCh";
$lang['month'][4]  = "apR1l";
$lang['month'][5]  = "maY";
$lang['month'][6]  = "jun3";
$lang['month'][7]  = "juLy";
$lang['month'][8]  = "auGU\$t";
$lang['month'][9]  = "s3pt3M8eR";
$lang['month'][10] = "oc+083r";
$lang['month'][11] = "nOvem83R";
$lang['month'][12] = "dEc3MBEr";

$lang['month_short'][1]  = "j@N";
$lang['month_short'][2]  = "feb";
$lang['month_short'][3]  = "m@R";
$lang['month_short'][4]  = "apR";
$lang['month_short'][5]  = "m@Y";
$lang['month_short'][6]  = "jUN";
$lang['month_short'][7]  = "jUl";
$lang['month_short'][8]  = "aUg";
$lang['month_short'][9]  = "s3p";
$lang['month_short'][10] = "oCT";
$lang['month_short'][11] = "n0v";
$lang['month_short'][12] = "d3c";

// Dates ---------------------------------------------------------------

// Various date and time formats as used by BeehiveForum. All times are
// expressed as 24 hour time format.

$lang['daymonthyear'] = "%s %s %s";                  // 1 Jan 2005
$lang['monthyear'] = "%s %s";                        // Jan 2005
$lang['daymonthyearhourminute'] = "%s %s %s %s:%s";  // 1 Jan 2005 12:00
$lang['daymonthhourminute'] = "%s %s %s:%s";         // 1 Jan 12:00
$lang['daymonth'] = "%s %s";                         // 1 Jan
$lang['hourminute'] = "%s:%s";                       // 12:00

// Periods -------------------------------------------------------------

// Various time periods as used by BeehiveForum.

$lang['date_periods']['year']   = "%s Y34r";
$lang['date_periods']['month']  = "%s m0Nth";
$lang['date_periods']['week']   = "%s w3ek";
$lang['date_periods']['day']    = "%s d4y";
$lang['date_periods']['hour']   = "%s Hour";
$lang['date_periods']['minute'] = "%s minutE";
$lang['date_periods']['second'] = "%s 5ecoND";

// As above but plurals (2 years vs. 1 year, etc.)

$lang['date_periods_plural']['year']   = "%s ye@rs";
$lang['date_periods_plural']['month']  = "%s MON+h\$";
$lang['date_periods_plural']['week']   = "%s w33Ks";
$lang['date_periods_plural']['day']    = "%s D4ys";
$lang['date_periods_plural']['hour']   = "%s h0Ur\$";
$lang['date_periods_plural']['minute'] = "%s MInUtEs";
$lang['date_periods_plural']['second'] = "%s S3C0NDs";

// Short hand periods (example: 1y, 2m, 3w, 4d, 5hr, 6min, 7sec)

$lang['date_periods_short']['year']   = "%sY";    // 1y
$lang['date_periods_short']['month']  = "%sM";    // 2m
$lang['date_periods_short']['week']   = "%sw";    // 3w
$lang['date_periods_short']['day']    = "%sd";    // 4d
$lang['date_periods_short']['hour']   = "%shr";   // 5hr
$lang['date_periods_short']['minute'] = "%sMIN";  // 6min
$lang['date_periods_short']['second'] = "%s\$Ec";  // 7sec

// Common words --------------------------------------------------------

$lang['percent'] = "p3RC3nt";
$lang['average'] = "aV3r@gE";
$lang['approve'] = "approvE";
$lang['banned'] = "b4NNeD";
$lang['locked'] = "lOck3D";
$lang['add'] = "aDd";
$lang['advanced'] = "advaNc3D";
$lang['active'] = "activ3";
$lang['style'] = "s+YLe";
$lang['go'] = "g0";
$lang['folder'] = "fOlD3R";
$lang['ignoredfolder'] = "igNOred f0LD3R";
$lang['folders'] = "f0ldEr5";
$lang['thread'] = "thR34D";
$lang['threads'] = "thR3@Ds";
$lang['threadlist'] = "thr34D LI\$+";
$lang['message'] = "m3S\$@gE";
$lang['messagenumber'] = "m3Ss493 NUm8er";
$lang['from'] = "fR0M";
$lang['to'] = "t0";
$lang['all_caps'] = "aLL";
$lang['of'] = "of";
$lang['reply'] = "r3ply";
$lang['forward'] = "fORW4rd";
$lang['replyall'] = "r3ply To 4ll";
$lang['pm_reply'] = "repLY as pm";
$lang['delete'] = "d3LEte";
$lang['deleted'] = "d3LEtED";
$lang['edit'] = "edi+";
$lang['privileges'] = "pRiv1LEgEs";
$lang['ignore'] = "i9nore";
$lang['normal'] = "normal";
$lang['interested'] = "inT3r3s+3D";
$lang['subscribe'] = "su8ScR18E";
$lang['apply'] = "aPpLY";
$lang['download'] = "d0WnLo@D";
$lang['save'] = "s@v3";
$lang['update'] = "uPD@+3";
$lang['cancel'] = "cANC3L";
$lang['retry'] = "r3TrY";
$lang['continue'] = "coNT1nu3";
$lang['attachment'] = "a+t4chm3nT";
$lang['attachments'] = "a++@ChM3N+5";
$lang['imageattachments'] = "iM493 @TT4CHM3nts";
$lang['filename'] = "f1lEn@mE";
$lang['dimensions'] = "dIM3ns10NS";
$lang['downloadedxtimes'] = "d0WnL04ded: %d +1m3s";
$lang['downloadedonetime'] = "dOwnlo@D3D: 1 +1m3";
$lang['size'] = "sIZE";
$lang['viewmessage'] = "vI3w m3s\$a9E";
$lang['deletethumbnails'] = "dEl3t3 +HUm8n@iL\$";
$lang['logon'] = "lOg0n";
$lang['more'] = "m0r3";
$lang['recentvisitors'] = "rEcent vI\$1+Ors";
$lang['username'] = "u5erN@m3";
$lang['clear'] = "cL34R";
$lang['action'] = "aC+10N";
$lang['unknown'] = "uNknOWN";
$lang['none'] = "nON3";
$lang['preview'] = "prevIEw";
$lang['post'] = "pOs+";
$lang['posts'] = "p0s+5";
$lang['change'] = "cH4N9e";
$lang['yes'] = "yES";
$lang['no'] = "n0";
$lang['signature'] = "s1Gn4+UrE";
$lang['signaturepreview'] = "sI9n4tuRe pRev13W";
$lang['signatureupdated'] = "s19n4tUr3 upD4+ED";
$lang['signatureupdatedforallforums'] = "s19N4+UrE UpD4+3D Ph0r 4lL PhOrUm\$";
$lang['back'] = "b4ck";
$lang['subject'] = "subJeC+";
$lang['close'] = "cLOS3";
$lang['name'] = "nAme";
$lang['description'] = "de\$CriP+ion";
$lang['date'] = "d4t3";
$lang['view'] = "view";
$lang['enterpasswd'] = "enteR PaS5W0rD";
$lang['passwd'] = "p@5sword";
$lang['ignored'] = "i9n0R3D";
$lang['guest'] = "gu35t";
$lang['next'] = "n3Xt";
$lang['prev'] = "pR3V1ous";
$lang['others'] = "o+h3r\$";
$lang['nickname'] = "n1ckn4m3";
$lang['emailaddress'] = "em41L 4DdRE\$\$";
$lang['confirm'] = "coNF1rm";
$lang['email'] = "em41L";
$lang['poll'] = "p0LL";
$lang['friend'] = "friend";
$lang['success'] = "sUcc3Ss";
$lang['error'] = "erROr";
$lang['warning'] = "w4rnIng";
$lang['guesterror'] = "s0RrY, J00 NEED +0 8e l09g3D IN T0 UsE +H1s PH3@+urE.";
$lang['loginnow'] = "lOg1n n0w";
$lang['unread'] = "uNRead";
$lang['all'] = "alL";
$lang['allcaps'] = "aLl";
$lang['permissions'] = "p3RmI\$SI0n5";
$lang['type'] = "tYpe";
$lang['print'] = "pR1N+";
$lang['sticky'] = "st1CKy";
$lang['polls'] = "pOll5";
$lang['user'] = "u\$3R";
$lang['enabled'] = "eN@BleD";
$lang['disabled'] = "d1s4BL3d";
$lang['options'] = "oPTI0Ns";
$lang['emoticons'] = "eM0t1C0N\$";
$lang['webtag'] = "wE8t49";
$lang['makedefault'] = "m@k3 d3f4ULt";
$lang['unsetdefault'] = "uNSEt D3ph4ul+";
$lang['rename'] = "r3N4me";
$lang['pages'] = "pA93s";
$lang['used'] = "uSed";
$lang['days'] = "d4Y\$";
$lang['usage'] = "uS493";
$lang['show'] = "sH0W";
$lang['hint'] = "hInt";
$lang['new'] = "n3W";
$lang['referer'] = "rePhEr3r";
$lang['thefollowingerrorswereencountered'] = "th3 F0llowIn9 3rROrs w3r3 3NCOuntEr3D:";

// Admin interface (admin*.php) ----------------------------------------

$lang['admintools'] = "aDMIn +o0l5";
$lang['forummanagement'] = "fORUm mAn49EMEn+";
$lang['accessdeniedexp'] = "j00 DO nOt h4v3 P3RmI\$Si0n T0 u53 +HIs sECT10N.";
$lang['managefolders'] = "mAn4g3 F0ld3RS";
$lang['manageforums'] = "m@N493 f0ruMs";
$lang['manageforumpermissions'] = "m4n493 F0RuM P3RmissI0N5";
$lang['foldername'] = "f0LD3r naMe";
$lang['move'] = "mOVe";
$lang['closed'] = "cL0\$ed";
$lang['open'] = "oP3N";
$lang['restricted'] = "rE\$+RictED";
$lang['forumiscurrentlyclosed'] = "%s I\$ cUrreN+lY CL0SeD";
$lang['youdonothaveaccesstoforum'] = "j00 D0 N0T h4vE @CC35\$ T0 %s";
$lang['toapplyforaccessplease'] = "to 4PPly f0r 4CC3S\$ pl34S3 ConT@CT +he PHoRuM OwneR.";
$lang['adminforumclosedtip'] = "iph J00 wANT +0 cH@Ng3 somE sE++1Ngs 0N Y0Ur f0rUm Cl1ck tH3 @DmIn liNk IN T3H N@V194T1on 8@r 4BoVe.";
$lang['newfolder'] = "new phoLDEr";
$lang['forumadmin'] = "fOrUm @DmiN";
$lang['adminexp_1'] = "u\$3 +h3 M3NU oN +HE l3pht +0 M@NAGe Th1NG\$ 1N Y0ur foRum.";
$lang['adminexp_2'] = "<b>user\$</b> 4Ll0wS j00 +O \$3T 1nD1VIDu4l u\$er p3rMi\$sioN\$, 1nCLuding 4pP0inT1n9 m0dEr4+0rS @nD G49gInG Pe0PLe.";
$lang['adminexp_3'] = "<b>us3r Groups</b> 4Ll0ws J00 t0 CrE4t3 Us3r 9R0ups +0 @S\$I9N pERm1\$5i0ns +0 4s M@NY 0r 4s F3w u53R\$ QU1cklY 4nD E4s1lY.";
$lang['adminexp_4'] = "<b>b4N C0NTR0l\$</b> @LL0Ws +HE b4nnIng 4nD uN-B4NnInG opH 1P ADDre5se\$, hTTP REPhErer\$, Us3rn4M3s, 3m41l 4Ddr3\$s3s @ND N1cKn4mes.";
$lang['adminexp_5'] = "<b>f0LD3R\$</b> 4llOw\$ teh CrE4T1ON, M0d1pHICA+1oN @nD D3LE+1on 0pH PH0LDers.";
$lang['adminexp_6'] = "<b>r5S pH3eD\$</b> 4lL0W\$ J00 +0 MAN493 Rss Ph3eds PHoR Pr0p49@+I0n 1nTo y0ur f0rum.";
$lang['adminexp_7'] = "<b>pRoph1L3s</b> L3Ts j00 Cus+oMi\$e +3h I+Ems +h@+ @PPE@R 1n +H3 Us3R pRoph1l35.";
$lang['adminexp_8'] = "<b>f0RUm sE++1n9s</b> @Ll0Ws j00 To Cus+0Mi\$3 Y0ur f0RUm'S n4me, 4pPE4R4nC3 @ND M4NY Oth3r +h1n9S.";
$lang['adminexp_9'] = "<b>s+4Rt P@G3</b> Lets J00 CUs+0m15E yOur phorUM's \$+4R+ P4g3.";
$lang['adminexp_10'] = "<b>foRum styl3</b> 4LLows J00 t0 9En3r@+3 R4nD0m 5TYLe\$ pHor yoUr PhOrum mEm8eR5 To Us3.";
$lang['adminexp_11'] = "<b>w0Rd pH1l+Er</b> 4LL0wS j00 +0 f1lTer WoRds j00 Don't W4NT +0 B3 UseD 0n Y0UR pHoRuM.";
$lang['adminexp_12'] = "<b>pO\$t1ng 5+4+S</b> 93NEr@+3s @ rEPort l1St1n9 ThE +0p 10 Po\$ters iN @ DefiN3d PEr1od.";
$lang['adminexp_13'] = "<b>f0rum L1NKs</b> l3TS j00 M4N@9E +eh L1nk\$ dr0pD0Wn 1N tEh n4V1G4+1oN B4r.";
$lang['adminexp_14'] = "<b>v1Ew lOg</b> lI\$ts R3ceN+ Ac+i0nS 8y +3h Ph0rum M0der4t0rs.";
$lang['adminexp_15'] = "<b>m4n49E ph0rUm\$</b> l3t5 J00 cr3@T3 4nD D3le+E anD clo\$E or r3OpEn ph0ruM\$.";
$lang['adminexp_16'] = "<b>gL0B4L F0Rum \$e++1n9\$</b> @Ll0w\$ j00 t0 m0d1Fy se+T1n9s WHich @Ff3C+ 4Ll F0RUm5.";
$lang['adminexp_17'] = "<b>p0st 4ppr0v4L QUEu3</b> @LL0wS j00 T0 v1ew 4ny PO5+s @W@1+Ing APPRov4l 8y @ MODeR4TOr.";
$lang['adminexp_18'] = "<b>v1\$1t0r Log</b> 4lL0Ws j00 +0 v13W @N 3xtEND3d L1\$+ oF V15I+0rS InCLud1n9 +HE1r hTTp REFeR3R5.";
$lang['createforumstyle'] = "cRE4t3 @ Forum \$+yle";
$lang['newstylesuccessfullycreated'] = "n3w sTyl3 %s 5UcCEs\$fully CrE4t3d.";
$lang['stylealreadyexists'] = "a styLe wI+h thAT FiLeN4ME 4lR34Dy 3xis+\$.";
$lang['stylenofilename'] = "j00 DiD N0+ 3nTEr 4 PHIL3N4Me +0 S@V3 +EH \$+ylE wI+H.";
$lang['stylenodatasubmitted'] = "c0uld N0t R34d f0rum s+YLe d@+4.";
$lang['styleexp'] = "u5E +hIs p49E +O hElp CrE4TE 4 R@NDomly 93NEr@+ed sTYlE f0R yoUr Forum.";
$lang['stylecontrols'] = "cONTr0l\$";
$lang['stylecolourexp'] = "clICK 0n A Col0UR t0 m4K3 4 n3W 5+yLE sH3eT bas3D 0n Th4+ COloUr. cUrr3nT 84\$E cOLouR i\$ fIR\$+ In LIS+.";
$lang['standardstyle'] = "sT4nD4rd sTYl3";
$lang['rotelementstyle'] = "rOT4+3d 3l3men+ sTYl3";
$lang['randstyle'] = "r@NDom style";
$lang['thiscolour'] = "tHi\$ colOUR";
$lang['enterhexcolour'] = "or en+er 4 hex c0l0UR +0 84se @ N3W S+yLe 5he3+ ON";
$lang['savestyle'] = "s@Ve tH1\$ \$+yle";
$lang['styledesc'] = "sTYL3 D3SCRiPT1oN";
$lang['fileallowedchars'] = "(LowERc4\$e lEtTeR5 (4-z), NUm8ER\$ (0-9) @ND UndER\$cOr3S (_) 0NLy)";
$lang['stylepreview'] = "s+Yle pREvIeW";
$lang['welcome'] = "w3Lc0M3";
$lang['messagepreview'] = "m3s\$@9E PrEviEW";
$lang['users'] = "usERS";
$lang['usergroups'] = "u\$3r GrOups";
$lang['mustentergroupname'] = "j00 mU\$+ 3n+3r 4 9RoUp N@mE";
$lang['profiles'] = "pR0FilE\$";
$lang['manageforums'] = "m@N4g3 FORuMS";
$lang['forumsettings'] = "foruM s3TtiN9S";
$lang['globalforumsettings'] = "gl084l F0rUm \$3+T1NGS";
$lang['settingsaffectallforumswarning'] = "<b>no+E:</b> +H3sE sEt+INgs AfPhECt 4ll pH0RuM\$. WHErE ThE S3+TIN9 15 dUpl1c4+3d 0n +Eh 1nd1viDU4L FOruM'\$ \$e++1N95 pAG3 th4+ wILL +4k3 PrEC3d3nc3 oV3r T3H \$e++INGS J00 CH4n93 H3rE.";
$lang['startpage'] = "sT4R+ P@Ge";
$lang['startpageerror'] = "y0Ur s+4RT P@93 C0UlD noT bE \$@v3d l0c4LLY +0 TEH \$ErV3R 8eC4use peRMIssi0N W4S D3N1ED.</p><p>tO cH4N93 YoUr st4r+ p4g3 PlE4\$3 Cl1CK the DownlOaD bu++0N BELow wh1CH wiLl pRomp+ j00 To s4VE +3h fil3 +0 your H4Rd dr1v3. J00 c4N tHeN upl0@D thi5 Fil3 +0 y0uR s3rV3r in+0 tH3 PHollOWin9 f0ld3r, 1pH N3c3ss4rY Cr3atIN9 +3H FoLDer \$TruC+ur3 in +he pRoc3S5.</p><p><b>%s</b></p><p>pLease no+e +H4t soM3 8Row\$Er\$ M4Y cH@nge +h3 n@me 0pH Th3 f1L3 up0N Downl04d.  whEn upl04Ding teh f1L3 PLE4\$e m@k3 \$uRE tHaT 1+ is N4M3D 5t4R+_m41N.Php 0tH3Rw1\$E Y0Ur STArt P@GE wiLL apPe4R unCh4NgEd.";
$lang['failedtoopenmasterstylesheet'] = "y0ur f0rUm \$+YL3 coULD n0t B3 s@Ved b3CAu\$e TH3 m4S+3r \$+Yl3 \$h3ET c0ulD n0+ Be lO4D3d. +0 s4vE YOuR styLe tHe m@\$+3r \$+yL3 5h33t (m@K3_\$+yLe.Css) MUs+ 8E Loc@tED 1n +h3 5+YlEs d1rEC+0ry 0f YOur 833h1v3 f0rUm 1NST4ll@+10n.";
$lang['makestyleerror'] = "yOUR foruM s+Yl3 CoUlD n0+ 83 s4veD LoC4Lly to TEh \$erv3r bEC4usE P3RM1\$S1oN W45 D3nI3D. to S4Ve YoUr ph0rUm 5+Yle pLe4se CliCk +hE DownL04D 8ut+on 83Low Wh1Ch w1lL pR0MPT j00 +0 s4v3 +3H fil3 To y0ur h4rd Dr1ve. J00 caN +Hen uPlO@d +hi\$ pH1LE +0 y0Ur \$erv3r in+o %s F0lDER, 1F Necess4Ry cr3atinG +he ph0lDeR StrucTur3 1n tHE prOC3ss. J00 SH0uld no+3 Th4T som3 bRow\$3rs m@y Chan9e +he n4M3 of Th3 PHiLe uPon downlo@D. whEn upL04d1N9 TH3 ph1LE ple4\$e m4KE 5ur3 +H4T i+ 15 n4mEd \$Tyl3.CS\$ o+h3Rwi\$E +he ph0rUm s+yl3 Will 8E uNU\$48L3.";
$lang['uploadfailed'] = "yOur n3w St4R+ P49E CoUld not 83 Upl0@d3d To +Eh \$3rvEr 8eC@Use P3RM1\$si0N W@\$ d3niED. pLe4se cheCk TH4T +3H WE8 \$Erv3R / PHp Pr0CE5\$ 1s A8Le to wRI+E +0 +3H %s phOlder on YoUr s3rv3R.";
$lang['forumstyle'] = "f0ruM stYl3";
$lang['wordfilter'] = "w0rD f1lter";
$lang['forumlinks'] = "fORUm lInKs";
$lang['viewlog'] = "vIEw lo9";
$lang['noprofilesectionspecified'] = "no pROPhiLE 53CTIoN sp3C1pHI3d.";
$lang['itemname'] = "i+Em n@Me";
$lang['moveto'] = "mOve T0";
$lang['manageprofilesections'] = "m@NA93 PR0Ph1l3 S3CTI0NS";
$lang['sectionname'] = "sEc+10n N4mE";
$lang['items'] = "i+ems";
$lang['mustspecifyaprofilesectionid'] = "mu\$+ \$P3C1FY 4 PR0f1Le s3ct1on 1D";
$lang['mustsepecifyaprofilesectionname'] = "mu\$+ 5P3C1fy 4 PRoFiLe s3ctioN n@Me";
$lang['noprofilesectionsfound'] = "th3Re @R3 no 3x1S+inG pR0f1le 53CTions. +o @Dd 4 pR0pH1l3 \$3C+I0N pl3453 CL1cK +H3 8u+T0N BEloW.";
$lang['addnewprofilesection'] = "add New Pr0pHILE seC+10N";
$lang['successfullyaddedprofilesection'] = "sUccE\$SFUllY @DDeD pR0F1L3 \$ec+1on";
$lang['successfullyeditedprofilesection'] = "sucCE\$SfUllY eDi+3D PR0F1le \$eCt1on";
$lang['addnewprofilesection'] = "add n3W pR0phiLE \$eCt1on";
$lang['mustsepecifyaprofilesectionname'] = "mu5+ Sp3C1Fy @ PRoPhiL3 \$EcT1on N4ME";
$lang['successfullyremovedselectedprofilesections'] = "succE5\$PHulLy R3MovED sEl3c+3d Pr0F1L3 S3cti0n\$";
$lang['failedtoremoveprofilesections'] = "f4ilEd +0 R3m0VE prOpH1l3 SecTioNs";
$lang['viewitems'] = "vi3w I+Ems";
$lang['successfullyaddednewprofileitem'] = "succ3\$SfUllY 4Dd3d n3W PrOfile I+3m";
$lang['successfullyeditedprofileitem'] = "succe\$sfUlly 3D1+3d Prof1l3 I+3m";
$lang['successfullyremovedselectedprofileitems'] = "succe\$\$fullY R3MoVeD sEl3ctED PR0F1l3 1+Ems";
$lang['failedtoremoveprofileitems'] = "f4iL3D +o reM0VE pR0PH1l3 I+EmS";
$lang['noexistingprofileitemsfound'] = "tHer3 4Re No Exi5+1N9 pR0f1l3 1+3ms 1N +HI\$ seCt10n. +0 ADd 4 PrOpH1L3 ItEm cl1ck TH3 BU++0n b3L0W.";
$lang['edititem'] = "ed1+ i+3M";
$lang['invalidprofilesectionid'] = "inv4L1d pRofIl3 53Ct10n ID 0R \$3C+i0N n0T f0UnD";
$lang['invalidprofileitemid'] = "iNV@L1D PRoPhil3 i+Em 1D Or 1+3m NOt f0unD";
$lang['addnewitem'] = "aDd NeW i+Em";
$lang['youmustenteraprofileitemname'] = "j00 mU5+ 3NtEr A PRoPh1l3 1+em N4m3";
$lang['invalidprofileitemtype'] = "iNV4lid Pr0Ph1L3 1+3M +yP3 S3lEC+3d";
$lang['failedtocreatenewprofileitem'] = "f4il3D +o Cr34tE n3w pR0F1lE I+EM";
$lang['failedtoupdateprofileitem'] = "f@IL3d +O UpD4TE Pr0filE I+3m";
$lang['startpageupdated'] = "sT@r+ PagE UpD@tED. %s";
$lang['viewupdatedstartpage'] = "vI3w UpD@+3d s+4r+ P49E";
$lang['editstartpage'] = "eD1+ \$+4rT PAg3";
$lang['nouserspecified'] = "nO USEr spEC1F1eD.";
$lang['manageuser'] = "m@na93 uSeR";
$lang['manageusers'] = "m4N@93 u\$3Rs";
$lang['userstatusforforum'] = "us3r \$t4TUs phoR %s";
$lang['userdetails'] = "u\$3R dEt41ls";
$lang['warning_caps'] = "w4rn1n9";
$lang['userdeleteallpostswarning'] = "are J00 sUr3 j00 W4NT +O DeL3+3 @LL 0Ph +eh \$3L3C+3d U\$ER's p0s+s? 0nce +HE P0s+s Ar3 d3le+3D +H3y C@nN0T 8E RetRI3V3D @ND w1lL 83 L0s+ pH0r3Ver.";
$lang['postssuccessfullydeleted'] = "poS+S W3r3 SUCC3s\$PHUlLy DEl3tED.";
$lang['folderaccess'] = "f0lD3R @CCEss";
$lang['possiblealiases'] = "pO\$Si8lE @l1@s3s";
$lang['userhistory'] = "u5Er hi\$+0RY";
$lang['nohistory'] = "n0 HI\$+0ry R3CorDs \$4vED";
$lang['userhistorychanges'] = "cH@ng3s";
$lang['clearuserhistory'] = "cL34R U\$ER hI\$+0RY";
$lang['changedlogonfromto'] = "ch4n93D lo90N froM %s +0 %s";
$lang['changednicknamefromto'] = "ch@NgED NiCkn4m3 phROm %s +0 %s";
$lang['changedemailfromto'] = "cHangeD Em4il fRom %s to %s";
$lang['successfullycleareduserhistory'] = "succE\$SfulLy ClEar3D uSer Hi\$+0Ry";
$lang['failedtoclearuserhistory'] = "faIlED to ClE4R useR his+0rY";
$lang['successfullychangedpassword'] = "succe\$Sfully CH4n9ED p4\$\$W0RD";
$lang['failedtochangepasswd'] = "f@il3D +0 ChAnge P@Ssw0rd";
$lang['viewuserhistory'] = "v13W U\$3R H1st0rY";
$lang['viewuseraliases'] = "v1ew us3r aL1As3s";
$lang['nomatches'] = "no M@+ChEs";
$lang['deleteposts'] = "d3let3 p0s+5";
$lang['deleteuser'] = "d3l3+3 User";
$lang['alsodeleteusercontent'] = "aL\$0 d3lEtE @lL 0PH tHe C0NtEn+ CRE4tED bY tH1S Us3r";
$lang['userdeletewarning'] = "aR3 j00 suR3 J00 w4N+ TO d3lete +H3 53LEC+ED U\$er aCCouNt? onCE tH3 4CCouNt h4s BEeN D3l3+3D i+ C4Nn0+ 83 r3Tr13vED @ND will 8E lost Ph0reVEr.";
$lang['usersuccessfullydeleted'] = "u53r sucC3SSFullY Del3+Ed";
$lang['failedtodeleteuser'] = "f41L3D +o D3l3te u\$eR";
$lang['forgottenpassworddesc'] = "iPh +H1\$ U\$3R H45 phOrg0t+3n TH3IR p4ssw0RD j00 C@n R353+ IT PHoR thEM hEr3.";
$lang['manageusersexp'] = "tH1\$ l1S+ \$H0Ws @ sel3C+I0N 0pH UsErs wh0 H4vE lOgg3D On To Y0Ur fOruM, 50RTED by %s. +0 4ltEr A us3r'\$ p3rm15\$1ON\$ CLiCk ThE1R N4m3.";
$lang['userfilter'] = "uSer f1L+3r";
$lang['onlineusers'] = "oNliN3 U\$3R\$";
$lang['offlineusers'] = "oPhfl1ne Us3R\$";
$lang['usersawaitingapproval'] = "u5er5 aw41+ING @PPRov@L";
$lang['bannedusers'] = "b@nnED u\$ERS";
$lang['lastlogon'] = "l4s+ Lo90n";
$lang['sessionreferer'] = "se5\$1On R3FER3r";
$lang['signupreferer'] = "s19N-up rEF3R3r:";
$lang['nouseraccountsmatchingfilter'] = "n0 usEr @CCoUnts m4+Ch1ng PhiLter";
$lang['searchforusernotinlist'] = "sE4rCh f0r 4 Us3r NOt In L15+";
$lang['adminaccesslog'] = "aDm1n 4Cc3ss lO9";
$lang['adminlogexp'] = "th1s l1\$t sh0ws +H3 L4s+ @Ct10ns \$4NCt10NED 8y uS3Rs Wi+h @DM1N Pr1viL3ge\$.";
$lang['datetime'] = "d4+3/+ImE";
$lang['unknownuser'] = "unKnOwn Us3R";
$lang['unknownuseraccount'] = "uNKnoWn U\$er 4CCouN+";
$lang['unknownfolder'] = "uNkNOWn phoLDEr";
$lang['ip'] = "iP";
$lang['lastipaddress'] = "l@St 1p 4ddR3\$s";
$lang['logged'] = "l0g93d";
$lang['notlogged'] = "nOt l0G93d";
$lang['addwordfilter'] = "aDd WoRd PhILtER";
$lang['addnewwordfilter'] = "aDd nEw WorD fiL+3r";
$lang['wordfilterupdated'] = "word fIlT3R UpD4+3D";
$lang['filtername'] = "f1L+Er N4M3";
$lang['filtertype'] = "fiL+3r TYP3";
$lang['filterenabled'] = "fIL+Er 3n4bLeD";
$lang['editwordfilter'] = "ed1+ w0rD PhIlTer";
$lang['nowordfilterentriesfound'] = "n0 ex1\$t1ng wOrd PHILTEr 3ntRIE\$ phOunD. To 4dD @ Word PHILTeR cl1Ck TeH Bu++0n B3l0w.";
$lang['mustspecifyfiltername'] = "j00 MUst Sp3c1fy 4 F1L+Er nAme";
$lang['mustspecifymatchedtext'] = "j00 mUs+ Sp3C1PHY MA+CH3D TExt";
$lang['mustspecifyfilteroption'] = "j00 must sPec1fY a Fil+3r oPt10n";
$lang['mustspecifyfilterid'] = "j00 MU\$t \$P3Ciphy 4 pH1lTEr ID";
$lang['invalidfilterid'] = "inV4l1D PH1lt3r 1D";
$lang['failedtoupdatewordfilter'] = "fA1l3d T0 UPD@+E W0RD pH1lter. CH3ck +H4T +Eh Fil+3R S+1ll 3x15+S.";
$lang['allow'] = "alLoW";
$lang['block'] = "bl0Ck";
$lang['normalthreadsonly'] = "norm4l +Hr34ds onlY";
$lang['pollthreadsonly'] = "p0Ll +HRe4ds onLy";
$lang['both'] = "bOth +Hr34D typEs";
$lang['existingpermissions'] = "exIs+1N9 peRmis\$i0Ns";
$lang['nousers'] = "n0 USEr\$";
$lang['searchforuser'] = "se@rch pHoR UsEr";
$lang['browsernegotiation'] = "bR0WsEr Neg0t1@+ED";
$lang['largetextfield'] = "lArge +3xt FI3lD";
$lang['mediumtextfield'] = "m3diuM +3x+ fielD";
$lang['smalltextfield'] = "sm4LL +Ex+ fi3ld";
$lang['multilinetextfield'] = "mul+1-L1n3 +3Xt pH13Ld";
$lang['radiobuttons'] = "r@d1O bU++0nS";
$lang['dropdown'] = "dR0P down";
$lang['threadcount'] = "thr3@D C0un+";
$lang['fieldtypeexample1'] = "f0R R4d1O 8utTons @Nd dR0P DowN PhIeld\$ J00 N33d +0 s3P@R4+3 +HE phi3LDnam3 4ND tEH VAlu3\$ W1+H 4 ColOn 4nd 34CH V@LU3 sh0uLd 8E \$3P@R@+ED 8Y \$emi-Colons.";
$lang['fieldtypeexample2'] = "ex4mPle: +0 Cr3a+3 4 8@siC 93ND3r r4d10 8U++0ns, Wi+H +W0 sel3ct10ns ph0r M@lE 4nd Fem4lE, J00 W0UlD 3nT3R: <b>g3nder:mAl3;F3MAl3</b> 1N Th3 1+3m N4mE pH13Ld.";
$lang['editedwordfilter'] = "edItEd woRD pH1L+Er";
$lang['editedforumsettings'] = "eD1+ED pHorUM se++1Ng\$";
$lang['successfullyendedusersessionsforselectedusers'] = "sucC3\$SfUlly ENDEd \$e\$5I0n5 f0R s3l3C+3d Us3Rs";
$lang['failedtoendsessionforuser'] = "fa1L3D To End \$e\$5I0N F0R us3r %s";
$lang['successfullyapprovedselectedusers'] = "succe\$\$PHULlY 4PpRov3d sEl3CT3d U\$ers";
$lang['matchedtext'] = "m4tch3d +Ex+";
$lang['replacementtext'] = "rEPL@C3M3Nt Tex+";
$lang['preg'] = "pRe9";
$lang['wholeword'] = "wHOlE W0rD";
$lang['word_filter_help_1'] = "<b>aLl</b> m4+CheS 49@iN\$+ +h3 wH0l3 +Ext S0 F1ltEriNg mom +O mUm w1ll 4l\$o ch4N93 mOm3nT +0 MUM3nt.";
$lang['word_filter_help_2'] = "<b>wH0lE Word</b> m4tCh3S @G4iNs+ Wh0Le wOrds onLy S0 Fil+Ering Mom +O mUm W1LL N0T chanGe M0mEnT +0 mumEnT.";
$lang['word_filter_help_3'] = "<b>pRE9</b> @Ll0w\$ J00 +0 us3 P3Rl r3gUl4r 3Xpr3ssi0ns +o m@+Ch Tex+.";
$lang['nameanddesc'] = "n4M3 @ND dEscr1p+i0N";
$lang['movethreads'] = "m0V3 thr34Ds";
$lang['movethreadstofolder'] = "movE +hR34ds +0 F0LDeR";
$lang['failedtomovethreads'] = "fa1L3D tO m0v3 +HR34Ds To sp3CipHi3d pHoLdEr";
$lang['resetuserpermissions'] = "reS3t usEr PeRmi\$S10NS";
$lang['failedtoresetuserpermissions'] = "f@il3d To Res3T u53R PErmi\$\$1on\$";
$lang['allowfoldertocontain'] = "aLL0w F0ldEr to COnt41N";
$lang['addnewfolder'] = "aDD nEW f0lD3R";
$lang['mustenterfoldername'] = "j00 mU5T 3N+3R A pH0lD3R NaM3";
$lang['nofolderidspecified'] = "n0 foLd3r id \$p3cipHi3d";
$lang['invalidfolderid'] = "iNV4l1d pHoLd3r 1d. Ch3cK tH@+ A pHoLDEr w1+H tH1\$ id 3XI5+s!";
$lang['successfullyaddednewfolder'] = "sUCC3\$SPhUlLY aDDEd n3w pHolDer";
$lang['successfullyremovedselectedfolders'] = "sUcc3sSFulLy REmov3d \$el3c+3d Ph0lDers";
$lang['successfullyeditedfolder'] = "sucC3ssfUlLy EDi+3d PHoldEr";
$lang['failedtocreatenewfolder'] = "f@1lED to crE4tE n3w fOld3R";
$lang['failedtodeletefolder'] = "fA1led +o D3L3+3 F0lD3r.";
$lang['failedtoupdatefolder'] = "f41led t0 Upda+E ph0LD3r";
$lang['cannotdeletefolderwiththreads'] = "c4nno+ DElE+e ph0LD3R\$ th@+ \$+1ll C0n+@1N +hR34DS.";
$lang['forumisnotrestricted'] = "f0rum iS no+ RES+riCTEd";
$lang['groups'] = "gr0ups";
$lang['nousergroups'] = "n0 UseR Gr0Ups h@V3 B3en s3t Up";
$lang['suppliedgidisnotausergroup'] = "suppL13D 9ID is No+ A useR 9roUp";
$lang['manageusergroups'] = "mAn493 u\$ER gr0upS";
$lang['groupstatus'] = "gR0up s+4tUs";
$lang['addusergroup'] = "add 9Roup";
$lang['addremoveusers'] = "add/rEm0vE useR5";
$lang['nousersingroup'] = "th3R3 4rE N0 us3R5 iN tH1\$ gr0Up";
$lang['useringroups'] = "tHIS User 1\$ 4 mEM83r oPh th3 PHoll0win9 9roUp\$";
$lang['usernotinanygroups'] = "th1\$ UseR i\$ NOT in @Ny U53R 9roUps";
$lang['usergroupwarning'] = "n0T3: +HIs usEr m4y 8E 1nhEri+InG aDdI+ioN@L P3RMi\$Si0ns pHroM 4ny UseR 9R0ups Li\$+3D 8el0w.";
$lang['successfullyaddedgroup'] = "sucCe\$SfulLy 4dDEd gRouP";
$lang['successfullyeditedgroup'] = "suCC3sSFulLy 3d1+3D 9r0UP";
$lang['successfullydeletedgroup'] = "succ3S5phulLy DEl3t3d 9ROUp";
$lang['usercanaccessforumtools'] = "u\$3R C@N @cCEss pHorum +o0Ls 4nd C4N CrEa+E, Del3tE @nD 3di+ PH0RuM\$";
$lang['usercanmodallfoldersonallforums'] = "u5er c@n mOD3R@+3 <b>aLL F0LD3r\$</b> on <b>alL PhorumS</b>";
$lang['usercanmodlinkssectiononallforums'] = "uSEr c@n moDEr4te l1nkS \$3C+i0n 0N <b>aLl Ph0rUm5</b>";
$lang['emailconfirmationrequired'] = "eM4IL cOnfIRm4+IOn Requ1R3d";
$lang['userisbannedfromallforums'] = "u\$3r 1s BAnNEd pHr0m <b>aLl F0RUm5</b>";
$lang['cancelemailconfirmation'] = "c@nc3l Em41l ConPhirm4+I0n 4Nd 4LL0w UsEr tO s+4rT Po\$+1N9";
$lang['resendconfirmationemail'] = "r3SEnD C0NFiRm4+I0n 3Mail +0 u53R";
$lang['donothing'] = "dO N0Th1ng";
$lang['usercanaccessadmintools'] = "us3r h@\$ 4cC3SS +o pH0RUm 4dmiN T0ols";
$lang['usercanaccessadmintoolsonallforums'] = "uS3r h@s @CCEsS to 4dmIn Tools <b>on 4LL pHoRuM\$</b>";
$lang['usercanmoderateallfolders'] = "uS3R C4N mOdEr4+3 4lL PHolD3rs";
$lang['usercanmoderatelinkssection'] = "u\$ER CaN m0d3R4Te L1nKs sEc+10n";
$lang['userisbanned'] = "u53R I\$ 84NNeD";
$lang['useriswormed'] = "usEr is W0rM3D";
$lang['userispilloried'] = "uS3R 1\$ p1lL0r13D";
$lang['usercanignoreadmin'] = "u\$3r C4N 1gn0R3 @DM1Ni5+R4+0rs";
$lang['groupcanaccessadmintools'] = "gR0Up C4n AccEss 4DM1N TooLs";
$lang['groupcanmoderateallfolders'] = "group C@n m0deR4Te 4lL F0ld3rs";
$lang['groupcanmoderatelinkssection'] = "gR0Up C@N MoD3RA+3 L1nkS \$3c+i0nS";
$lang['groupisbanned'] = "gr0Up 1s 84nn3D";
$lang['groupiswormed'] = "gROUP 1\$ WoRm3d";
$lang['readposts'] = "r3@D p05T\$";
$lang['replytothreads'] = "r3plY +O tHrE4Ds";
$lang['createnewthreads'] = "cRe4TE n3w +HR34dS";
$lang['editposts'] = "edIt Po5t\$";
$lang['deleteposts'] = "d3l3TE Po\$+s";
$lang['postssuccessfullydeleted'] = "pOs+s \$UCCEs5fuLlY D3L3tEd";
$lang['failedtodeleteusersposts'] = "f@il3d +0 Del3+3 User'\$ P0Sts";
$lang['uploadattachments'] = "uPL04D 4t+@CHmEnTs";
$lang['moderatefolder'] = "m0d3r@Te F0LD3r";
$lang['postinhtml'] = "po\$T IN H+mL";
$lang['postasignature'] = "p05+ @ S1Gn4TUr3";
$lang['editforumlinks'] = "eD1t f0rum L1NK\$";
$lang['editforumlinks_exp'] = "use tH1\$ p@g3 +0 4DD L1nk\$ +0 TEh DroP-D0WN lI\$+ di\$play3D In t3H Top-r1ght 0pH TEh f0RUm pHr4mEsEt. 1pH No lInk\$ @r3 set, +h3 Drop-D0wn L1\$t w1lL n0t Be DispL4Y3d.";
$lang['failedtoremoveforumlink'] = "f@il3D +0 r3m0VE f0rum lInK '%s'";
$lang['failedtoaddnewforumlink'] = "fail3d to 4Dd N3w F0rum L1NK '%s'";
$lang['failedtoupdateforumlink'] = "f4il3d +0 upD4te F0rum LiNk '%s'";
$lang['notoplevellinktitlespecified'] = "no Top LEvel link +1+L3 \$p3cipHi3d";
$lang['youmustenteralinktitle'] = "j00 mu\$t 3n+3R 4 LINk +I+L3";
$lang['alllinkurismuststartwithaschema'] = "aLl l1nK Uri\$ muS+ 5+@R+ WI+H @ sChem@ (1.E. H++P://, fTp://, irC://)";
$lang['noexistingforumlinksfound'] = "tH3rE @R3 N0 ExI5+1N9 f0ruM liNk5. TO adD @ FoRum l1NK Cl1ck tHE buT+0N Bel0W.";
$lang['editlink'] = "edi+ LiNK";
$lang['addnewforumlink'] = "aDd n3W F0rum LiNk";
$lang['forumlinktitle'] = "f0RuM l1nk tI+l3";
$lang['forumlinklocation'] = "f0ruM L1NK LoC4t10N";
$lang['successfullyaddednewforumlink'] = "succe\$SFuLly 4ddED nEW Forum l1nK";
$lang['successfullyeditedforumlink'] = "succ3\$sfUlLy eDi+ED F0RUm LiNk";
$lang['invalidlinkidorlinknotfound'] = "iNv@liD LiNk 1d Or linK n0t f0unD";
$lang['successfullyremovedselectedforumlinks'] = "succE\$sfULLy REm0VED \$El3c+ED L1Nk\$";
$lang['toplinkcaption'] = "toP LiNk CAp+1on";
$lang['allowguestaccess'] = "alL0w GUEST 4cCes\$";
$lang['searchenginespidering'] = "s3@RCh 3N9INE \$piD3R1ng";
$lang['allowsearchenginespidering'] = "aLLoW \$e4RCh EngiN3 \$pID3rinG";
$lang['newuserregistrations'] = "neW us3r Re9i\$TR@+I0ns";
$lang['preventduplicateemailaddresses'] = "pRev3nt DupLiC4+3 3m@iL @ddrE\$S3s";
$lang['allownewuserregistrations'] = "aLL0w nEw Us3R R39is+R@Tion\$";
$lang['requireemailconfirmation'] = "requ1R3 em41l C0nPh1rm4+I0N";
$lang['usetextcaptcha'] = "u\$E +EXt-C@PTch4";
$lang['textcaptchadir'] = "t3Xt-C@P+Ch@ D1R3CtorY";
$lang['textcaptchakey'] = "tEx+-caP+Cha K3Y";
$lang['textcaptchafonterror'] = "teX+-c@PtCh4 H4\$ B33N Di\$48leD @uTom4t1c4Lly 8eC4use +h3R3 @R3 N0 +RuE Type pH0Nts @V41LA8LE PhoR I+ To us3. Pl34se upLoaD 5OMe tRu3 +yPe F0Nts +0 <b>%s</b> 0N Y0ur s3RvEr.";
$lang['textcaptchadirerror'] = "t3X+-c4PtCh4 h45 8e3N Dis@8L3d 8eC4usE +h3 +Ext_C4ptCh4 DiR3CTorY @Nd 1t's \$UB-DiR3C+OriEs 4rE n0t Wri+48LE By +3h W38 SeRvEr / PHP PR0C3s\$.";
$lang['textcaptchagderror'] = "tex+-C4P+Ch4 hAs beEn Di\$@bl3d 8ec4us3 yOuR \$3rv3r'\$ php SetUp D0eS No+ pR0v1d3 \$UPp0r+ f0R gd 1M@G3 m@NIpUl@+i0n 4ND / or ++Ph PHont sUppoRt. 8oTH 4re rEqUirEd Ph0r +3Xt-CAptch@ sUpp0r+.";
$lang['textcaptchadirblank'] = "tEXt-CAp+ChA diR3cT0Ry 15 BL4nK!";
$lang['newuserpreferences'] = "n3w u53r pR3PH3R3NC3S";
$lang['sendemailnotificationonreply'] = "ema1L n0t1fiCAti0n 0n rEpLy t0 usEr";
$lang['sendemailnotificationonpm'] = "em4iL no+iFIc4+10N on Pm T0 U5ER";
$lang['showpopuponnewpm'] = "show p0pUp Wh3n R3cEivin9 N3W pM";
$lang['setautomatichighinterestonpost'] = "s3+ 4UT0m@+1c H1gH INTEr3\$+ on P0S+";
$lang['postingstats'] = "pOS+ing S+ats";
$lang['postingstatsforperiod'] = "p0\$+iNG s+4+s pHor p3ri0D %s tO %s";
$lang['nodata'] = "n0 d@+@";
$lang['totalposts'] = "t0+4L pOsts";
$lang['totalpostsforthisperiod'] = "total pos+S ph0r +HI\$ P3R10d";
$lang['mustchooseastartday'] = "mU\$+ ChOo53 4 \$+4rt D@Y";
$lang['mustchooseastartmonth'] = "mu\$+ ch0o\$3 4 s+@r+ MoNtH";
$lang['mustchooseastartyear'] = "muS+ chO0\$3 4 s+4r+ YE4R";
$lang['mustchooseaendday'] = "mu\$+ Choose @ 3nD Day";
$lang['mustchooseaendmonth'] = "mU\$T CH00\$3 4 3Nd M0NTH";
$lang['mustchooseaendyear'] = "mU\$t cHoo\$e @ EnD y34R";
$lang['startperiodisaheadofendperiod'] = "s+@RT p3ri0D I5 AhE4d 0f 3ND p3r10D";
$lang['bancontrols'] = "b4N c0ntR0ls";
$lang['addban'] = "add bAn";
$lang['checkban'] = "check B@N";
$lang['editban'] = "eDi+ 84N";
$lang['bantype'] = "b4N TYp3";
$lang['bandata'] = "b4n D@+@";
$lang['bancomment'] = "commEnt";
$lang['ipban'] = "ip b@n";
$lang['logonban'] = "loGoN 84N";
$lang['nicknameban'] = "nickN4M3 8@N";
$lang['emailban'] = "eM@IL B4N";
$lang['refererban'] = "refER3r B4n";
$lang['invalidbanid'] = "inv4L1d 84N 1d";
$lang['affectsessionwarnadd'] = "tH1s Ban M@Y 4fpheC+ +HE phOlLowInG @C+iV3 usEr 53s510ns";
$lang['noaffectsessionwarn'] = "thIs B@N AffEcTs no 4ct1v3 se5SI0n5";
$lang['mustspecifybantype'] = "j00 Mus+ SpEcIPHy @ Ban +Ype";
$lang['mustspecifybandata'] = "j00 Mus+ \$p3CIphY s0me 84N D4ta";
$lang['successfullyremovedselectedbans'] = "sUcC3\$SFulLy R3MovED 53l3CTEd 8@Ns";
$lang['failedtoaddnewban'] = "f@1lEd tO @DD n3w 84n";
$lang['failedtoremovebans'] = "f41l3D +o rEm0VE \$0Me 0r @ll oPh tEh \$3L3c+3D B4NS";
$lang['duplicatebandataentered'] = "dUpl1c4t3 B4N D4+4 3N+3REd. PLe4se ch3ck y0Ur W1LdC@rDs +o se3 1ph ThEy @lR34DY M4TCH TEh D@+4 en+3red";
$lang['successfullyaddedban'] = "sUcCE5\$fuLlY @dDEd B4N";
$lang['successfullyupdatedban'] = "suCC3ssphulLy uPD@teD BAn";
$lang['noexistingbandata'] = "thER3 I5 n0 Exi5+1nG B4n d4T4. +0 4DD 5om3 84n D4+@ Pl34\$3 CL1ck thE BU++0n B3l0W.";
$lang['youcanusethepercentwildcard'] = "j00 c4n Use tHE perCENt (%) WiLDC@RD sYmB0l In @Ny 0ph Y0ur B4n l1\$+S +0 0Bt41N P4rti4L MAtCH3S, 1.3. '192.168.0.%' WoulD B4N 4lL 1p 4Ddr3s53s iN ThE RaNg3 192.168.0.1 +hRoUgh 192.168.0.254";
$lang['cannotusewildcardonown'] = "j00 C@nn0t 4Dd % 45 a WIlDC@rd m4tch 0N i+'\$ 0WN!";
$lang['requirepostapproval'] = "r3Qu1rE p0st 4pProv4l";
$lang['adminforumtoolsusercounterror'] = "tHere mUst 8e 4t L34St 1 uSer W1th 4Dm1n +0ol5 4Nd phOrUm +0ols @CC3s5 0n 4lL f0ruM\$!";
$lang['postcount'] = "po\$+ CouNt";
$lang['resetpostcount'] = "rEs3+ P0st C0UNt";
$lang['failedtoresetuserpostcount'] = "f41lED +0 r3seT po\$+ c0Unt";
$lang['failedtochangeuserpostcount'] = "f@IleD +0 Ch@nG3 UsEr po\$+ C0unt";
$lang['postapprovalqueue'] = "p0St 4pPR0V4l qu3u3";
$lang['nopostsawaitingapproval'] = "n0 Pos+\$ @R3 @w@I+IN9 APPR0VAL";
$lang['approveselected'] = "aPPR0ve \$el3ctEd";
$lang['failedtoapproveuser'] = "f4ILED to 4pPR0ve u\$ER %s";
$lang['kickselected'] = "k1ck \$El3c+3D";
$lang['visitorlog'] = "vI5i+0R lOg";
$lang['novisitorslogged'] = "n0 v1\$I+oRs LoG9ED";
$lang['addselectedusers'] = "add \$el3ct3d Us3R5";
$lang['removeselectedusers'] = "r3m0ve \$el3c+3D UseRs";
$lang['addnew'] = "add nEw";
$lang['deleteselected'] = "dELete s3L3ctED";
$lang['forumrulesmessage'] = "<p><b>f0Rum rUl3s</b></p><p>\nRE9i\$TR4+i0N T0 %1\$\$ iS phR33! w3 Do in\$15+ TH4+ J00 @81DE 8y +h3 rUl3S @ND Pol1C13S D3T4il3d B3L0w. IpH j00 @gR33 +0 ThE tErm\$, Pl3453 CheCk Teh 'i aGR3e' ChEck8oX and pRes5 +He 'ReG1S+Er' Bu++0N BEl0W. iPh J00 W0UlD likE t0 c4ncel th3 R39istr4+i0n, CliCk %2\$s t0 R3Turn t0 +Eh pH0rums inD3x.</p><p>\n@l+hOUgh +eh 4dm1Nis+r4tor5 aNd m0der@t0r\$ 0f %1\$s WIlL a+T3MPt To ke3P all 08JeC+i0N@BlE mesS493\$ 0PhF this PH0ruM, 1+ Is impoS\$1BLe f0R us +0 r3VI3w @Ll mEsS@gES. @lL m3Ss4G3S 3xpr3ss thE vi3wS 0ph th3 4uthor, 4Nd ne1+her +Eh 0Wn3Rs 0F %1\$\$, noR pr0j3CT 833H1V3f0Rum 4Nd 1+'\$ aphf1li4+3S wiLl 8e h3LD REsp0N518l3 PH0r +3H CON+en+ 0PH 4Ny M3Ss4gE.</p><p>\nbY 49R3Eing +0 THese rul3S, J00 wArR4N+ +hAt J00 wiLl n0t P05+ 4Ny mess49es +H4+ @R3 OBSC3NE, vul94r, \$eXu4LlY-ori3nT4+3d, H@tEPhUl, Thre4+eNIn9, or OtHErwI\$e v1Olat1VE 0pH @Ny l4wS.</p><p>tHe 0WNers Of %1\$S r3S3rve +He r19Ht To R3m0V3, 3dit, M0Ve or cl0Se @Ny +hR34d Ph0r 4NY re4Son.</p>";
$lang['cancellinktext'] = "h3R3";
$lang['failedtoupdateforumsettings'] = "f41L3d tO Upd@+3 FORum s3Tt1nG\$. pL34Se try 4g41N L4T3R.";
$lang['moreadminoptions'] = "mORE @DM1N Opt1oNs";

// Admin Log data (admin_viewlog.php) --------------------------------------------

$lang['changedstatusforuser'] = "ch4N9ed Us3r \$+4Tu\$ foR '%s'";
$lang['changedpasswordforuser'] = "ch@Ng3D p@\$\$wORD phoR '%s'";
$lang['changedforumaccess'] = "cH4N9Ed pHorUM @Cc3ss PeRmI\$SIon\$ pHor '%s'";
$lang['deletedallusersposts'] = "d3L3t3d aLl Po\$+S phoR '%s'";

$lang['createdusergroup'] = "cRe@+3d u\$3R 9r0up '%s'";
$lang['deletedusergroup'] = "deL3teD U\$ER 9r0uP '%s'";
$lang['updatedusergroup'] = "uPd4ted UsER 9roUp '%s'";
$lang['addedusertogroup'] = "add3D User '%s' T0 GRouP '%s'";
$lang['removeduserfromgroup'] = "r3mOvE U53r '%s' pHr0M 9R0Up '%s'";

$lang['addedipaddresstobanlist'] = "add3D Ip '%s' To bAN Li5+";
$lang['removedipaddressfrombanlist'] = "r3m0v3D ip '%s' PhROm B4n lis+";

$lang['addedlogontobanlist'] = "aDDED l090N '%s' to 8@n LIs+";
$lang['removedlogonfrombanlist'] = "rEM0v3d Log0n '%s' phR0m 8@n L1\$T";

$lang['addednicknametobanlist'] = "aDdeD NiCKn4m3 '%s' +O Ban li\$+";
$lang['removednicknamefrombanlist'] = "r3M0Ved nICkn@m3 '%s' fRom B4n lIs+";

$lang['addedemailtobanlist'] = "addEd 3m41L 4ddRe\$s '%s' +0 8AN LI5+";
$lang['removedemailfrombanlist'] = "rEMoV3D 3mA1l 4dDrEs\$ '%s' Fr0M 84N LIS+";

$lang['addedreferertobanlist'] = "adDeD rEfer3R '%s' +O b4n L1\$t";
$lang['removedrefererfrombanlist'] = "r3m0V3d r3phEr3R '%s' fRom B4N l15+";

$lang['editedfolder'] = "eDi+eD pH0LDer '%s'";
$lang['movedallthreadsfromto'] = "m0VeD 4ll +Hr34d5 pHr0M '%s' to '%s'";
$lang['creatednewfolder'] = "cr3@+ED N3W folDEr '%s'";
$lang['deletedfolder'] = "deL3t3d Pholder '%s'";

$lang['changedprofilesectiontitle'] = "cH@NG3D PRoph1lE \$eCTion T1+L3 PHROm '%s' +0 '%s'";
$lang['addednewprofilesection'] = "add3D n3w PRoph1l3 sEC+I0N '%s'";
$lang['deletedprofilesection'] = "dEL3+3d pROph1lE \$3C+I0n '%s'";

$lang['addednewprofileitem'] = "adDEd N3w pRof1lE i+em '%s' +0 S3c+i0n '%s'";
$lang['changedprofileitem'] = "ch@NGEd pR0PHile 1+3M '%s'";
$lang['deletedprofileitem'] = "delet3D pR0pH1L3 1+3M '%s'";

$lang['editedstartpage'] = "ed1+3D s+@r+ P493";
$lang['savednewstyle'] = "s4VeD n3W S+ylE '%s'";

$lang['movedthread'] = "mOV3d +HrE4D '%s' froM '%s' +o '%s'";
$lang['closedthread'] = "cL0sED thRE4D '%s'";
$lang['openedthread'] = "open3d Thr34d '%s'";
$lang['renamedthread'] = "r3nam3D thR3AD '%s' +0 '%s'";

$lang['deletedthread'] = "d3L3+eD +hreaD '%s'";
$lang['undeletedthread'] = "und3l3t3d ThRE4D '%s'";

$lang['lockedthreadtitlefolder'] = "l0CKed thrE4d op+I0n\$ On '%s'";
$lang['unlockedthreadtitlefolder'] = "unlOCK3d thRE@D 0P+I0ns 0n '%s'";

$lang['deletedpostsfrominthread'] = "d3LetED Pos+5 phR0m '%s' iN +HR34D '%s'";
$lang['deletedattachmentfrompost'] = "d3l3+Ed 4ttAChMenT '%s' from P0st '%s'";

$lang['editedforumlinks'] = "ed1teD pH0RUm liNKs";
$lang['editedforumlink'] = "ed1+ED f0RUm liNK: '%s'";

$lang['addedforumlink'] = "aDDED Ph0rum link: '%s'";
$lang['deletedforumlink'] = "del3+3d F0ruM l1Nk: '%s'";
$lang['changedtoplinkcaption'] = "ch4n93d +0P LiNK C4ptioN FroM '%s' tO '%s'";

$lang['deletedpost'] = "deleteD pO5+ '%s'";
$lang['editedpost'] = "ediTED P05+ '%s'";

$lang['madethreadsticky'] = "m4d3 +Hr34d '%s' StiCky";
$lang['madethreadnonsticky'] = "m4DE +hR34D '%s' noN-s+1cKy";

$lang['endedsessionforuser'] = "eNd3D \$eS5I0N f0r uS3R '%s'";

$lang['approvedpost'] = "apPR0ved Post '%s'";

$lang['editedwordfilter'] = "edItEd word fiL+3r";

$lang['addedrssfeed'] = "aDd3d rSs fE3d '%s'";
$lang['editedrssfeed'] = "eDi+eD Rss ph3eD '%s'";
$lang['deletedrssfeed'] = "del3+ED rsS pH33d '%s'";

$lang['updatedban'] = "uPd4T3d B4N '%s'. CH@nG3d +YpE From '%s' +0 '%s', Ch@N9ED D@+@ phroM '%s' tO '%s'.";

$lang['splitthreadatpostintonewthread'] = "sPLI+ tHreAd '%s' @t pO5T %s  iN+O n3w +HR34D '%s'";
$lang['mergedthreadintonewthread'] = "m3r93D thRE@D\$ '%s' 4nD '%s' in+0 NEw +Hr34d '%s'";

$lang['approveduser'] = "aPPR0veD UsEr '%s'";

$lang['adminlogempty'] = "aDMIn lO9 I\$ 3Mp+Y";
$lang['clearlog'] = "cle@r l09";

// Admin Forms (admin_forums.php) ------------------------------------------------

$lang['noexistingforums'] = "n0 3x1\$+1nG pH0RUm5 pHound. T0 Cr3@TE @ NeW pHorUm pl34\$e ClICk tEh 8U+Ton 83LOw.";
$lang['webtaginvalidchars'] = "wEb+@G CaN 0NLy C0NT41N UppErC4S3 4-Z, 0-9 4nD und3R\$corE Ch4r4C+3r\$";
$lang['databasenameinvalidchars'] = "d4t4BaS3 N@M3 C4N 0NLy c0n+A1N 4-Z, 4-Z, 0-9 @ND Und3r\$c0RE Ch@r4CtEr\$";
$lang['invalidforumidorforumnotfound'] = "inV4liD pH0rum pHiD FoR Ph0rum n0t Found";
$lang['successfullyupdatedforum'] = "succ3\$sfulLy Upd@ted ForUm";
$lang['failedtoupdateforum'] = "f41l3d +o uPd@+3 pHorum: '%s'";
$lang['successfullycreatednewforum'] = "sucC35\$phuLly CrE4TED n3w ph0RUM";
$lang['selectedwebtagisalreadyinuse'] = "tH3 \$elECted W3Bt4G 1\$ alRE4Dy 1N Use. PlE4S3 ChO0s3 4no+h3r.";
$lang['selecteddatabasecontainsconflictingtables'] = "th3 \$el3c+3d DA+4b4se C0N+@iN\$ C0NPhl1CT1Ng t4BlEs. ConphL1c+1ng T48LE N@mE\$ 4Re:";
$lang['forumdeleteconfirmation'] = "aRe j00 sUr3 j00 W@nT +0 DeL3+3 4ll oF +H3 SeL3CtED F0RUms?";
$lang['forumdeletewarning'] = "plEASe N0te +H4+ j00 C@nnot R3cOveR Del3TEd Ph0ruM5. 0nC3 D3l3TED 4 fORuM @Nd All 0ph 1+'\$ 4SS0cI4tED D@+4 iS perM4n3n+LY R3M0v3D From t3h d@t4baSE. Iph J00 d0 n0T w1\$H +o dEl3TE +Eh \$3leCtED foRum\$ pL34SE Cl1Ck C4Nc3L.";
$lang['successfullyremovedselectedforums'] = "sUcCeSSPhUlLy dElET3d s3LeC+3D F0Rums";
$lang['failedtodeleteforum'] = "f41l3d to dEl3tED FOrUM: '%s'";
$lang['addforum'] = "add ph0rUM";
$lang['editforum'] = "ed1+ F0Rum";
$lang['visitforum'] = "vi5I+ pHorUm: %s";
$lang['accesslevel'] = "acc3ss lEvEl";
$lang['forumleader'] = "f0rum le4d3r";
$lang['usedatabase'] = "uSE D@+@8453";
$lang['unknownmessagecount'] = "uNknOwn";
$lang['forumwebtag'] = "f0rum w3B+49";
$lang['defaultforum'] = "dEf4Ul+ PHorum";
$lang['forumdatabasewarning'] = "pLE4se 3NsuRe J00 \$El3Ct +hE c0rrEC+ D4+4b4\$3 Wh3n CrE4T1ng a new phOrum. oncE Cr3@+Ed 4 n3w fOrum C4nn0t 8E M0vEd b3+We3n @V@1l4Ble D@+48@\$e\$.";

// Admin Global User Permissions

$lang['globaluserpermissions'] = "glOB4L U\$3R pErmi5si0Ns";

// Admin Forum Settings (admin_forum_settings.php) -------------------------------

$lang['mustsupplyforumwebtag'] = "j00 MUst supPly 4 f0rum W38T4g";
$lang['mustsupplyforumname'] = "j00 Mus+ \$upply 4 Forum N4mE";
$lang['mustsupplyforumemail'] = "j00 MuS+ \$UPply 4 F0rum 3M41L 4dDR3s5";
$lang['mustchoosedefaultstyle'] = "j00 muS+ cH00S3 4 dePh@UlT f0ruM stYl3";
$lang['mustchoosedefaultemoticons'] = "j00 mUsT ChO0\$3 D3f4ul+ pHOruM 3M0T1C0ns";
$lang['mustsupplyforumaccesslevel'] = "j00 MUst sUppLy 4 ph0RUm aCC3s\$ l3vEl";
$lang['mustsupplyforumdatabasename'] = "j00 MUst \$upPly @ PhOruM d4t48453 nAM3";
$lang['unknownemoticonsname'] = "uNknOwn Em0tIC0ns n4me";
$lang['mustchoosedefaultlang'] = "j00 MUst Cho053 @ dEF4ULt f0rUm L4N9U4G3";
$lang['activesessiongreaterthansession'] = "aCt1v3 5e\$sioN +1M30u+ C4nNo+ 83 9r34tEr THan S35\$1On Tim30u+";
$lang['attachmentdirnotwritable'] = "aT+4chMEN+ d1rEC+0Ry AnD sys+3M TemPor4rY D1r3ctorY / PhP.1nI 'UpLo4d_+MP_dIr' MUst 8e wRI+4bl3 BY +3H We8 5Erv3r / PHP Pr0cE\$S!";
$lang['attachmentdirblank'] = "j00 mUst \$uppLy a direct0rY To s@Ve A+T4chMeN+\$ in";
$lang['mainsettings'] = "m@1n S3+T1n9s";
$lang['forumname'] = "fORUm n@M3";
$lang['forumemail'] = "fORum Em41l";
$lang['forumnoreplyemail'] = "nO-R3Ply eM41L";
$lang['forumdesc'] = "fOrum De5Cr1PTIoN";
$lang['forumkeywords'] = "fORum keYw0rD\$";
$lang['defaultstyle'] = "dEF4uL+ sTyL3";
$lang['defaultemoticons'] = "d3ph@Ul+ emo+iC0N\$";
$lang['defaultlanguage'] = "d3Ph@Ult L@ngU@G3";
$lang['forumaccesssettings'] = "f0rum aCC3Ss \$e++1ng\$";
$lang['forumaccessstatus'] = "fOrum @CCEss \$T4+us";
$lang['changepermissions'] = "chANge p3rmIss10ns";
$lang['changepassword'] = "ch4N9E PaSsw0RD";
$lang['passwordprotected'] = "p4Ssw0rD pRo+3c+3d";
$lang['passwordprotectwarning'] = "j00 H4vE No+ set 4 pH0RuM p@ssw0rD. 1ph J00 Do N0+ Se+ @ P@SsW0rD +h3 pa5\$w0RD Pro+3c+i0n funCtioN4l1+y w1LL 8e 4U+0m4+IC4lly DIs4bleD!";
$lang['postoptions'] = "pos+ Opt10N\$";
$lang['allowpostoptions'] = "allow p05+ ED1+iNg";
$lang['postedittimeout'] = "p0St EdI+ t1m30U+";
$lang['posteditgraceperiod'] = "p0\$T 3d1T 9r@CE pErI0d";
$lang['wikiintegration'] = "wikiwiK1 1N+E9r@+1on";
$lang['enablewikiintegration'] = "eN4ble w1kiWiki 1n+39r4t10N";
$lang['enablewikiquicklinks'] = "eN4blE WiKIwiKi quICk LiNk\$";
$lang['wikiintegrationuri'] = "wik1wiKi l0C@+i0N";
$lang['maximumpostlength'] = "m4XImum P0st l3nGth";
$lang['postfrequency'] = "p0\$T phrequenCy";
$lang['enablelinkssection'] = "en@8lE l1nk\$ \$3CtIon";
$lang['allowcreationofpolls'] = "aLlow CrEa+1oN Oph pOlls";
$lang['allowguestvotesinpolls'] = "aLLow gUests t0 vo+3 1n Poll\$";
$lang['unreadmessagescutoff'] = "unR34D me\$s4Ges Cu+-ophph";
$lang['unreadcutoffseconds'] = "s3C0ND5";
$lang['disableunreadmessages'] = "di\$4bL3 UnrE4d Me\$S493\$";
$lang['nocutoffdefault'] = "no cu+-0PHPH (D3phAult)";
$lang['1month'] = "1 moN+h";
$lang['6months'] = "6 months";
$lang['1year'] = "1 y3@R";
$lang['customsetbelow'] = "cuSt0m V4lUe (\$3+ B3l0w)";
$lang['searchoptions'] = "s3@Rch 0pT10Ns";
$lang['searchfrequency'] = "s3@rCh freqU3NCY";
$lang['sessions'] = "sE\$s1On\$";
$lang['sessioncutoffseconds'] = "se\$sI0n cU+ 0pHpH (seCoNds)";
$lang['activesessioncutoffseconds'] = "acT1V3 \$e5Si0n cut 0PhPh (seCoNdS)";
$lang['stats'] = "sT4+\$";
$lang['hide_stats'] = "h1D3 s+4T\$";
$lang['show_stats'] = "sh0W sta+s";
$lang['enablestatsdisplay'] = "eN48L3 \$+4t\$ D15pL4y";
$lang['personalmessages'] = "p3Rs0nal M3S5@g3s";
$lang['enablepersonalmessages'] = "eN48l3 P3rsOnAl m35\$49E\$";
$lang['pmusermessages'] = "pM m3s\$49es pEr U\$3R";
$lang['allowpmstohaveattachments'] = "aLl0w p3RSon4l M3sS@gE\$ +0 h4Ve @t+4ChM3nTs";
$lang['autopruneuserspmfoldersevery'] = "auT0 pRunE UsEr's Pm f0lDeRs ev3RY";
$lang['userandguestoptions'] = "uSer 4nD guEst 0pT1oN5";
$lang['enableguestaccount'] = "eN@8LE 9U3S+ @CCoUnT";
$lang['listguestsinvisitorlog'] = "l1St 9u3stS In VI\$i+OR L09";
$lang['allowguestaccess'] = "alLow 9u3\$+ @CCEss";
$lang['userandguestaccesssettings'] = "us3r 4ND gU3\$t 4cCes\$ 53++1N95";
$lang['allowuserstochangeusername'] = "all0W User5 To Ch@ng3 U\$3RN@Me";
$lang['requireuserapproval'] = "r3QU1r3 Us3r @PProv@l 8y aDmIn";
$lang['requireforumrulesagreement'] = "rEQU1re USEr +0 49R3E To F0RuM RuLEs";
$lang['enableattachments'] = "eNA8le @TtaChmEnts";
$lang['attachmentdir'] = "att4CHMenT DIr";
$lang['userattachmentspace'] = "a+T@ChmEnT \$P@ce p3r User";
$lang['allowembeddingofattachments'] = "aLlOw Emb3DdIn9 opH 4++4ChmEnts";
$lang['usealtattachmentmethod'] = "u\$3 4lTErn@+1v3 4++@cHmEnt M3+HOd";
$lang['allowgueststoaccessattachments'] = "aLLOw 9u3sts To 4cC35S a+TAChMEnts";
$lang['forumsettingsupdated'] = "f0RUm sEt+1nG\$ \$uCCEssfUlly upD4tED";
$lang['forumstatusmessages'] = "f0rum st4Tu\$ mEs5@ge\$";
$lang['forumclosedmessage'] = "foRum Cl0sED m3S\$493";
$lang['forumrestrictedmessage'] = "foRum r3s+r1cTEd ME\$\$49E";
$lang['forumpasswordprotectedmessage'] = "f0RUm p4ssword pro+3cTEd M3S\$493";

// Admin Forum Settings Help Text (admin_forum_settings.php) ------------------------------

$lang['forum_settings_help_10'] = "<b>p0s+ eD1+ t1MEOut</b> i\$ +He t1m3 1N MiNu+3s 4ftEr p0sT1n9 th4T 4 U53R c@n 3diT +hEir pos+. 1Ph \$3+ +0 0 +H3r3 1s no l1m1+.";
$lang['forum_settings_help_11'] = "<b>m4XImuM pOSt l3Ng+H</b> IS +3H M4x1MuM NUm83R 0f Ch4r4c+3RS +H4+ WiLL 8E Di\$PL@yed in 4 p0ST. 1f a p05+ 1S l0N9er thAN +H3 NumbER oph CH@r@c+3R5 dePH1n3D HEr3 1+ w1ll BE cU+ sh0RT 4nD 4 link aDdEd +0 TH3 Bo++0m to 4Ll0W u\$3Rs +o r34D +He wH0l3 p0St on @ SepaR4Te p@GE.";
$lang['forum_settings_help_12'] = "if J00 d0N'+ w4Nt Y0ur U53Rs t0 b3 48le +0 cr34Te Poll5 J00 c4n D1S@8l3 th3 a8OvE 0p+I0N.";
$lang['forum_settings_help_13'] = "t3h lInK\$ \$3c+i0N oF b33H1v3 pR0v1D3S a PL4c3 PH0r yoUr U53r\$ +0 M41Nt4iN 4 l15+ 0ph s1+3s thEy pHrEqU3n+lY visi+ Th4t 0thEr U53r\$ m4y PhinD us3Ful. L1NK5 c4N 83 d1VID3D 1N+0 c4+3Gor1e\$ by FolDEr 4nd 4Ll0w PhoR CommeNTS @ND r4t1ng\$ +0 8e 9Iv3n. 1N 0rd3R +0 MODer4T3 +3H l1NKs \$ectiON a u53R must 8E r@N+Ed 9Lo84l ModEr4+0r 5T4+us.";
$lang['forum_settings_help_15'] = "<b>s3Ss1ON cU+ Ophf</b> 1s +Eh m@ximUm T1m3 8ef0re @ UsEr's S3ssi0N 1\$ d33meD DEad And +h3y 4r3 Lo9GeD ou+. 8y DEf4ul+ tHis I5 24 h0uR\$ (86400 seConD\$).";
$lang['forum_settings_help_16'] = "<b>aC+ivE \$es5i0n CU+ 0ff</b> 1s T3h M@X1MUm +IME BEF0re A U53r'5 53ssi0n i\$ D33m3D 1n4Ctiv3 @+ WHICH p01N+ +HEy Enter 4N 1dl3 \$+4+E. in Th1\$ \$+a+3 thE USEr r3m4IN5 l0GGED iN, 8u+ +HeY 4rE r3mOV3D fr0M the @CtIvE u\$3R\$ L1s+ In +H3 \$+a+s d1Splay. onCe tH3Y BEcom3 @CTiv3 @G41n +Hey wILl 8e R3-4dd3D +0 Th3 L1s+. bY DeFault +H1s 53T+1N9 is Se+ +0 15 m1nu+3s (900 \$econds).";
$lang['forum_settings_help_17'] = "eN4Bling ThIs 0p+I0N 4Ll0W\$ b33h1V3 +0 INcLUDe @ 5tATs d1\$pl4y @T TH3 8Ot+om oph +H3 M3s\$49E5 p@N3 \$imiL@r To the oNE u\$3D 8Y M4NY f0rUm s0ftwar3 +I+L3\$. 0NCE 3n4Bl3d +hE D1\$pLaY 0Ph TEh S+4+s pagE C4N BE +09GL3d iND1ViDualLy 8y 34cH Us3R. 1F +Hey don'T w@N+ +0 see i+ +Hey C@n h1D3 1+ PHr0m vI3w.";
$lang['forum_settings_help_18'] = "p3r\$0N4l Mes54GE\$ 4R3 Inv@LU48LE @\$ @ W4Y 0pH T4K1n9 Mor3 PRiv4te M4tteR5 0u+ OpH v13W Of th3 o+h3r m3m8Er5. H0w3V3r 1F j00 Don'T W4NT YOUr uSER\$ +0 8e @8l3 +o \$enD e4ch 0tHEr peR\$0N4L MEs54ges j00 C4N Di\$@8L3 +H15 Opt1on.";
$lang['forum_settings_help_19'] = "p3r50N4L ME\$S@G3S C@N 4l\$0 Cont41N @tTaChM3n+\$ Wh1Ch C4n BE usEPHUl pH0R 3xch@N91n9 pHiL3S 83+WEeN UseRS.";
$lang['forum_settings_help_20'] = "<b>n0+E:</b> +hE \$P4c3 4lLoc4t10N pHoR pM @++4cHm3nTs i\$ T@Ken from eAcH us3r\$' m@IN 4++AChM3Nt 4lL0c4+I0n 4Nd i5 nO+ 1n 4dDi+i0n T0.";
$lang['forum_settings_help_21'] = "<b>en48L3 9UEs+ @CCoUn+</b> 4Ll0wS vi\$i+0RS +o Br0WsE y0uR PHorum 4nD r34d PO5t\$ wiTHou+ re9i5+3RIng 4 US3r 4cC0uN+. 4 User 4ccOun+ 1S s+1lL R3QU1R3d 1f +H3y w1\$h +0 Post 0R Ch4ngE U53r pr3f3R3nC3s.";
$lang['forum_settings_help_22'] = "<b>lI5+ 9UEsts iN v1s1+Or l09</b> AlL0W\$ j00 +0 sp3ciFy wh3th3r 0R not unr39I5+3reD us3R\$ 4r3 l1S+3d 0N Th3 v15i+0r lo9 @long s1D3 RegI\$+3rEd User5.";
$lang['forum_settings_help_23'] = "b33h1VE @lLows 4TTACHmEnTs t0 B3 UPl04D3D T0 ME\$S493s WHen P0STEd. 1f J00 H@V3 l1mi+ED wE8 sp4cE J00 m@Y wH1ch +O Di5@8l3 @t+4cHMen+s 8y Cl34r1N9 +HE 80x 4b0V3.";
$lang['forum_settings_help_24'] = "<b>a+t4ChmEn+ Dir</b> 1s +Eh lOcAt10n b3ehIvE sHoulD s+0RE I+'s @++4CHmentS In. +h1\$ d1R3CtorY Must EXI\$+ 0n Y0uR w38 sp@cE 4ND mu\$+ 83 wr1+4BLE By +H3 w38 ServeR / PhP PRoce\$S 0+H3rwIs3 uPloaDS will F@iL.";
$lang['forum_settings_help_25'] = "<b>aT+@CHm3nt \$p@cE P3R UseR</b> 1\$ +H3 M4X1mUm 4mOunt 0f Disk \$P4c3 4 User H4s Ph0r 4+t4chmEn+s. 0Nc3 +H1S spAc3 is U\$ED Up tEh us3R C4nn0+ Upl04D 4ny M0r3 @+t4cHm3nT\$. 8Y D3f@ul+ Th1\$ I\$ 1M8 0f \$p4C3.";
$lang['forum_settings_help_26'] = "<b>alLow 3M8eDDinG 0PH 4T+@ChmEn+s in mEss@9es / \$1Gn@Tur3\$</b> allow\$ us3rs +0 Em8ed @+t4cHm3nTS in P0Sts. 3n@8lIng tH1S 0P+i0n wh1LE u\$3phuL c4n incRe4s3 yOur B4ndw1d+h Us493 DraS+Ic4LlY Und3r C3R+41N C0nPHI9Ur4+i0nS 0F php. 1f J00 H@V3 L1M1+3d 84nDw1dTh It 1S Recomm3nd3d th4t j00 di\$4Bl3 +hiS Opt10n.";
$lang['forum_settings_help_27'] = "<b>usE @L+3RnAT1V3 @++4cHmEnt m3tHoD</b> phorC3s 83Eh1V3 +o USE @N @LTErN4+iVE r3Tri3v4l M3TH0D for 4tt4chm3nts. 1f j00 ReCeiv3 404 3rR0R MES5@93s wH3n tRyInG To D0Wnlo@d 4ttAcHm3Nts phr0m m3S\$49e\$ +ry en@8L1ng TH1\$ oPt10n.";
$lang['forum_settings_help_28'] = "this \$et+1NG 4Ll0w\$ Y0ur f0ruM To 8E \$p1D3r3D By 53@rCH 3n9in3S lik3 G00gle, 4L+4v15+4 4ND y4Ho0. 1f J00 \$Wi+ch tHI5 0p+1on opHph y0uR f0rUM wilL N0t 8e iNClUdEd 1n +he\$3 sE4RCh EnG1n35 R3sults.";
$lang['forum_settings_help_29'] = "<b>alLow New u5er r391S+r@T1on\$</b> 4lLOws or DI\$@llOWS +h3 crE4T10N 0pH NeW u53r @CC0unTs. 53TT1N9 +H3 0P+I0N t0 no CompL3tely Dis@BLes +H3 RE9I\$+R@tI0n f0rm.";
$lang['forum_settings_help_30'] = "<b>en4blE wiKiwiki In+39r4T1on</b> Pr0VId3s w1kIW0rd SuPp0R+ In your phoRum posTs. @ wIkIWoRD Is m@d3 Up oPh twO 0r m0Re ConC@TEn4TED Words w1+H Upp3rc4sE l3++eR5 (0pH+3N rEphErrED t0 4\$ C@melCasE). If j00 Wri+3 @ w0rD +hI\$ W@y 1+ W1LL @Utom@tic4lly 8e Ch4N93D inT0 4 HypeRlink poin+1NG to y0ur Chosen wik1wiki.";
$lang['forum_settings_help_31'] = "<b>en4bLE wikIwiKI qU1ck lInKs</b> 3n48lEs +H3 Use 0Ph ms9:1.1 anD usEr:Log0N s+ylE ExTEnD3D wiK1LinKs whicH Cr3@t3 hYpErlink\$ +0 THE 5pECIfi3d M3Ss@g3 / Us3R pR0phIle 0ph +He spEC1Ph1ed Us3R.";
$lang['forum_settings_help_32'] = "<b>w1kiwiKI LoC4t10N</b> 1\$ U\$ED +0 sp3C1fy THe uRi 0f YoUr W1KiWIk1. whEn En+3R1n9 TeH Ur1 U\$e [W1K1worD] +0 1NDiC4tE whEr3 1N +He ur1 Teh wIkiW0RD SHouLd 4PP34R, I.3.: <i>h++P://3n.WiK1P3d1A.0R9/wikI/[W1KiW0RD]</i> W0uld LiNk YoUr w1kIworDS +O %s";
$lang['forum_settings_help_33'] = "<b>f0rum aCC3ss \$+ATu\$</b> c0nTR0L\$ how UsErs m4Y ACC3s\$ YOur ph0Rum.";
$lang['forum_settings_help_34'] = "<b>opeN</b> w1Ll @LLow 4Ll users AnD 9Ues+\$ 4cc3sS To y0UR f0rUm w1+h0U+ R3s+RiCtion.";
$lang['forum_settings_help_35'] = "<b>cL0sed</b> pr3VeNts @CC3ss Phor @Ll us3rs, Wi+h tH3 ExcEpt1oN oph +H3 @dMin who maY 5+1ll @CC3ss +h3 @dmin p4N3L.";
$lang['forum_settings_help_36'] = "<b>reStRiC+3D</b> 4Ll0ws +O \$3T 4 lI\$+ oph UsErs wH0 4RE @LloW3D 4cC3Ss t0 y0ur Ph0Rum.";
$lang['forum_settings_help_37'] = "<b>p4S\$WOrd Pr0T3ctEd</b> AlLows J00 tO \$3+ @ p45\$W0rD +o g1vE OuT +0 u\$eRS s0 tHEy c4n @cC3Ss y0Ur f0ruM.";
$lang['forum_settings_help_38'] = "when s3ttin9 rEStrICteD or p@\$SW0rd Pro+3c+3D M0d3 J00 W1ll Ne3d tO S4V3 your Ch4n9e\$ b3FoRE J00 c@N cH4NgE thE User @Cc3Ss Pr1ViLE93s or p4\$Sw0Rd.";
$lang['forum_settings_help_39'] = "<b>Search Frequency</b> defines how long a user must wait before performing another search. Searches place a high demand on the database so it is recommended that you set this to at least 30 seconds to prevent \"search spamming\"frOM K1LLing tHe \$3rVEr.";
$lang['forum_settings_help_40'] = "<b>p0s+ Fr3Qu3nCy</b> 1s TH3 mInIMUm +iM3 @ U\$er mus+ W@1+ 8ephorE +HEy C4N p0St 4gaiN. ThI\$ \$3TT1ng 4L\$0 aFf3c+\$ +h3 Cre4T1on 0pH p0ll\$. set To 0 tO dis4BL3 tEh rES+rIcTi0n.";
$lang['forum_settings_help_41'] = "teH 4Bove 0PtI0n5 Ch4nge tH3 D3ph@uL+ VAluEs phOr t3H Us3R r3g1\$+R4t1oN F0rM. Wher3 4PPliC4BLE 0tHER 53+T1ng5 WILl Use th3 ForuM'S 0wn DEf4ulT SE++INgS.";
$lang['forum_settings_help_42'] = "<b>pR3VeNt U\$E 0pH DUpLiC@+e 3m41l ADdres5E\$</b> PhoRC3s 8eEhiv3 +0 ch3ck tEh U\$3r 4ccoUnts 4941Nst +eH 3m4IL 4ddre\$S TH3 u53r i\$ rEgi5+3RInG WiTh AnD pr0MP+\$ +h3m tO u53 @N0Th3r 1f i+ 15 AlR34dY 1n usE.";
$lang['forum_settings_help_43'] = "<b>r3QUirE 3m4Il COnf1rM@TI0n</b> wh3N 3NA8l3D WILl \$End @N 3M4iL t0 e4cH n3w useR With 4 lInK tH@t c@n 8e Us3d T0 cONF1RM +H31R 3MA1l aDDr35\$. UntIl +h3Y C0npH1RM +H31R 3M4il 4dDr3SS +heY wILL nOt 8e @8l3 t0 P05+ UnLESS thEIR US3r perM15s1ONs @r3 chAnGEd M@nu4lLY By 4n 4dm1N.";
$lang['forum_settings_help_44'] = "<b>uSE +Ex+-C@Ptch4</b> preS3ntS t3h NeW U\$3r wI+h 4 MAn9l3d IM4gE wh1ch tH3y Mus+ copY 4 NuMB3r Phr0M 1Nt0 4 T3Xt Phi3lD on tHe R3gIS+R@+10n phOrm. u53 +H1s oP+10n TO pr3V3nt @u+0ma+eD \$igN-up vi4 sCR1PT\$.";
$lang['forum_settings_help_45'] = "<b>t3X+-C4ptcH@ D1R3ctorY</b> SpeCIphIes +3H lOC4T10N +H4+ 8eEhive will \$TOre I+'\$ tEX+-c@ptCh4 1M@9es @nd foN+\$ iN. +H1\$ d1rec+0rY Mu\$+ 8e WrITa8Le bY teH w38 s3Rv3R / PHp pRoCeSs @nD mu\$+ 8e 4CC3ssi8le v1A H+tp. 4PHt3r j00 HAvE 3N4bLed +EX+-CaptCh@ j00 Must UPl04D s0m3 tRU3 +yPE ph0nt\$ In+0 teh FoN+S suB-d1REC+0rY of YOur m4IN +eX+-c4p+ch4 d1R3c+0ry 0ThErw1\$3 bEehiv3 w1Ll 5kiP teh +3x+-c4Ptch4 DUrin9 u53r rE9iStr4+I0n.";
$lang['forum_settings_help_46'] = "<b>Text Captcha key</b> allows you to change the key used by Beehive for generating the text captcha code that appears in the image. The more unique you make the key the harder it will be for automated processes to \"guess\"tHe c0dE.";
$lang['forum_settings_help_47'] = "<b>p0St Edi+ gr4c3 p3r1OD</b> 4lL0ws j00 To DepHin3 4 P3RIod 1n m1NU+es WHEr3 uSErs m@y eD1+ p0S+s wi+h0U+ +3h 'EDi+3d bY' +Ex+ @ppe4r1nG oN The1R Po5+\$. iF \$E+ To 0 +Eh 'EDi+Ed bY' tExt will @Lw4y\$ @ppeaR.";
$lang['forum_settings_help_48'] = "<b>uNRE4D MEss@gEs cUt-OpHph</b> Sp3cIphi3s h0w L0N9 UnrE4D m3sS49E\$ 4re r3t41neD. j00 may Ch0o\$E PhR0m V4rIoU\$ PRese+ v@LUe\$ 0r 3nT3r Y0ur own CU+-ophpH PeRioD in \$3COnD\$. +hr3aDs moD1FieD 34RlIer Than thE D3FinEd CU+-oFpH PEri0d W1LL 4U+0M@T1c4LLy 4PP3ar @\$ R34d.";
$lang['forum_settings_help_49'] = "cHo0S1ng <b>d1\$48LE UnrE4D mE\$5@G3s</b> WIlL C0Mpl3tEly rem0vE unre4d mEs\$493s SuppoRT 4nd rEm0v3 The r3l3v@N+ oP+I0Ns fr0m T3h dIsCuSs1on tYp3 DR0p d0wn 0n TEH +hRE4D L1\$+.";
$lang['forum_settings_help_50'] = "<b>r3QuiRE usEr ApPr0v4l BY 4dM1N</b> 4Ll0wS j00 to R3sTriC+ 4cC3s\$ 8Y N3W U\$3Rs un+1L tH3y H4v3 Been 4PpROvEd By 4 MoD3r@+Or Or 4Dmin. w1+H0ut @pProVal @ U\$er C@nN0+ 4cC3Ss 4ny 4r3a 0F tHE Beeh1v3 PHoruM iN5+4LL@+I0n INcLuDin9 inD1V1Du4l f0rum5, Pm 1nbox anD mY phOrums 5Ect10n\$.";
$lang['forum_settings_help_51'] = "uSE <b>cl0S3d M3ss4gE</b>, <b>res+R1c+3d M3s\$@ge</b> and <b>p4\$\$w0RD pr0+3c+3D M3sS@ge</b> To CU\$+0m1\$3 Th3 ME5\$49e D1\$pl@y3D wh3n Us3rs 4CC3\$s youR forUm IN Teh v4R10u\$ s+@tE\$.";
$lang['forum_settings_help_52'] = "j00 C4N U\$e H+Ml 1n Y0Ur M3Ss493\$. hyPErLinKs 4nD 3m4Il AdDrE\$ses WiLl @l\$0 B3 4u+0M@+1c@llY C0nv3r+ed +O l1nk\$. +0 U\$e +hE DepH4ul+ 8eEhiV3 Ph0ruM mes\$493s clE4R +hE phI3LDs.";
$lang['forum_settings_help_53'] = "<b>aLLOw u5ers +O cH@ng3 usErn@M3</b> perMi+S 4LRE4Dy REg1stEred us3r\$ +O Ch4NGe +HEir Us3RN@M3. Wh3n 3n4bLeD j00 c4N Tr4Ck thE Ch4n93s @ us3R M@K3s +0 +H3IR U\$eRn4M3 vI4 +EH aDm1N Us3R +0ols.";
$lang['forum_settings_help_54'] = "usE <b>f0rUm Rul3\$</b> +0 EnT3R @N 4cC3p+4BL3 UsE Pol1cy Th4+ 3ach U5Er mU\$t 49REe +o 8EPhore RegI\$TEr1ng 0N y0ur PhorUm.";
$lang['forum_settings_help_55'] = "j00 C4n U5E H+mL 1n YouR pHorum rUlEs. hyp3RLINk\$ 4nD 3m41L 4dDresses will @l50 8e 4U+0m@+IC4LlY C0Nv3r+3D To l1Nk\$. +o UsE thE D3PhaUlT 833hiVE pHorum @Up CLE4R +H3 phIElD.";
$lang['forum_settings_help_56'] = "uSE <b>nO-repLy 3MA1l</b> +0 spEcIfy @N 3m41L 4Ddre5\$ +h4t D0Es n0+ 3X1\$t 0r W1ll No+ Be m0ni+or3D F0r r3PLies. +His 3M41L 4DdR3\$S WiLl 8e u\$3D In +3h H34D3r\$ Phor AlL Em41l\$ S3Nt Fr0M y0uR pHOrUM inCluD1NG 8U+ N0+ L1m1+3D to p05+ 4nd pm n0t1Fic@+i0n\$, U\$Er 3m41l\$ @nD passw0rD reMINd3rS.";
$lang['forum_settings_help_57'] = "it IS REc0MmeND3D +h@+ j00 U5E @n 3M4Il 4dDr3s5 +h4T D0Es no+ 3X1\$+ +O h3Lp cUt d0Wn 0n 5PAM +h4T m4y 8e D1R3C+3d @T YOur m@in pHorum Em41L @Ddr3\$S";

// Attachments (attachments.php, get_attachment.php) ---------------------------------------

$lang['aidnotspecified'] = "a1d Not sP3CiPhI3D.";
$lang['upload'] = "uPl04D";
$lang['uploadnewattachment'] = "uPL04D NeW 4ttAchMenT";
$lang['waitdotdot'] = "w@1+..";
$lang['successfullyuploaded'] = "sucCe5\$FUllY upLo4D3d: %s";
$lang['failedtoupload'] = "fa1LeD +0 Upl04d: %s";
$lang['complete'] = "coMPL3TE";
$lang['uploadattachment'] = "upL04d @ PHiL3 ph0r @t+@chMenT +0 tEh M3ss@g3";
$lang['enterfilenamestoupload'] = "enter fIl3n4M3(\$) To upLo4D";
$lang['attachmentsforthismessage'] = "a+t@cHm3N+s PhoR Thi5 mE\$s@g3";
$lang['otherattachmentsincludingpm'] = "o+h3R 4++4chmeNts (1ncLuD1Ng pm mEsS4935 @Nd OThEr PHorumS)";
$lang['totalsize'] = "totaL \$1Ze";
$lang['freespace'] = "fRE3 \$p4c3";
$lang['attachmentproblem'] = "th3re W4\$ @ PR0bl3m DowNlo4diN9 TH1\$ @T+4chm3nt. PLe4\$3 TrY AG41n L4+3r.";
$lang['attachmentshavebeendisabled'] = "at+4ChMeN+s h4v3 b33N Di\$4bleD By The f0rUm OwNer.";
$lang['canonlyuploadmaximum'] = "j00 c@n onLy upL04D @ m@x1MuM 0PH 10 fIl3S 4t 4 T1Me";
$lang['deleteattachments'] = "dEl3te 4tT4chm3nTS";
$lang['deleteattachmentsconfirm'] = "arE j00 SurE j00 W@nT +o DeL3+e +H3 sEl3CtED @++4chm3n+s?";
$lang['deletethumbnailsconfirm'] = "aR3 j00 SUre J00 w4nt +0 DEl3+3 +HE SEl3cTeD @++4chmEnTs ThumbN4ils?";

// Changing passwords (change_pw.php) ----------------------------------

$lang['passwdchanged'] = "p@SSW0RD Ch4n9ed";
$lang['passedchangedexp'] = "y0Ur P@SsworD h@5 8eeN Ch4N93D.";
$lang['updatefailed'] = "upd4t3 Ph41LEd";
$lang['passwdsdonotmatch'] = "p45\$W0rdS DO not m4+cH.";
$lang['newandoldpasswdarethesame'] = "nEw @nD olD P@\$\$w0RDs Ar3 tEh 5@mE.";
$lang['requiredinformationnotfound'] = "requ1rED INformat1on nOt PhouNd";
$lang['forgotpasswd'] = "fOrg0T p@\$SW0RD";
$lang['resetpassword'] = "reS3t p@ssw0rd";
$lang['resetpasswordto'] = "re\$eT p@\$SW0RD To";
$lang['invaliduseraccount'] = "inV@lId usEr aCC0Unt \$p3C1f13D. Ch3ck 3m41L For Correct l1nK";
$lang['invaliduserkeyprovided'] = "iNv@l1d U53R KEy ProviD3d. ChEck Em41L For CoRr3c+ L1nK";

// Deleting messages (delete.php) --------------------------------------

$lang['nomessagespecifiedfordel'] = "n0 ME5s4g3 5P3C1pH1ed F0R d3l3+IoN";
$lang['deletemessage'] = "del3tE m3S\$49E";
$lang['postdelsuccessfully'] = "poS+ deL3TED \$uCc3ssfully";
$lang['errordelpost'] = "erR0r Del3t1n9 P0\$+";
$lang['cannotdeletepostsinthisfolder'] = "j00 Canno+ D3lEtE p0st5 IN tH15 pHoLdEr";

// Editing things (edit.php, edit_poll.php) -----------------------------------------

$lang['nomessagespecifiedforedit'] = "no mESS493 5P3c1phi3D f0r 3di+In9";
$lang['cannoteditpollsinlightmode'] = "c@nno+ 3di+ PoLls in l1gH+ moDe";
$lang['editedbyuser'] = "edi+Ed: %s 8Y %s";
$lang['editappliedtomessage'] = "ed1t 4pPlIED To mE\$s4g3";
$lang['errorupdatingpost'] = "eRr0R upD4+1ng P0St";
$lang['editmessage'] = "eDI+ mEs54GE %s";
$lang['editpollwarning'] = "<b>n0te</b>: edi+ING C3r+41n AsP3C+\$ 0pH 4 P0lL w1Ll Vo1D 4lL +HE cuRrEn+ vOt3s aNd aLl0W Pe0plE tO VO+E @941N.";
$lang['hardedit'] = "h4rd 3Dit 0PT10ns (votEs w1ll B3 REs3+):";
$lang['softedit'] = "soft Ed1t 0pT1Ons (vOtEs w1LL 8e r3t@1n3D):";
$lang['changewhenpollcloses'] = "ch@NgE Wh3n TH3 polL Clo535?";
$lang['nochange'] = "no ChaNgE";
$lang['emailresult'] = "em4il R3Sult";
$lang['msgsent'] = "m3\$\$a93 \$enT";
$lang['msgsentsuccessfully'] = "mes\$49E \$en+ 5uCC3SsPhUlly.";
$lang['mailsystemfailure'] = "m@il sY\$TEm F41luR3. M3s54g3 No+ \$3Nt.";
$lang['nopermissiontoedit'] = "j00 4rE n0t peRm1++Ed +O EDIt +hI\$ me\$5@Ge.";
$lang['cannoteditpostsinthisfolder'] = "j00 c4nNo+ 3D1t Po\$+s 1N +HiS pHolDEr";
$lang['messagewasnotfound'] = "m35s@Ge %s w4S NOt f0UNd";

// Email (email.php) ---------------------------------------------------

$lang['nouserspecifiedforemail'] = "nO u\$Er 5PECIfiED f0r 3m@ILIn9.";
$lang['entersubjectformessage'] = "eNter @ \$uBjEc+ pHOr THE m3sS4gE";
$lang['entercontentformessage'] = "ent3R \$0Me ConTenT f0r +H3 M3ss493";
$lang['msgsentfromby'] = "tHIS m3s\$49E w@\$ \$EN+ froM %s 8y %s";
$lang['subject'] = "suBjeCt";
$lang['send'] = "s3nd";
$lang['userhasoptedoutofemail'] = "%s hA5 oPteD out Oph 3M@Il ConT4Ct";
$lang['userhasinvalidemailaddress'] = "%s h4s 4N InV@LiD Em41L AdDreS5";

// Message nofificaiton ------------------------------------------------

$lang['msgnotification_subject'] = "m3\$S493 N0t1fIC4tion PhroM %s";
$lang['msgnotificationemail'] = "heLlO %s,\n\n%s pOst3d A MEssag3 T0 j00 0N %s.\n\n+HE \$ubjeC+ 1\$: %s.\n\n+0 R34d thA+ MeS\$@gE @nd 0+H3R5 IN +h3 s4me DiscUss10n, 9o To:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nno+E: 1ph J00 D0 N0t wi\$h +0 R3c31v3 3MAIl NotiphiCa+i0N\$ oF pHorUm mE\$S49Es p0StEd +0 y0u, 90 tO: %s Cl1Ck on my Con+roLS +hen 3m@Il 4Nd Pr1v4Cy, unseLEC+ th3 Ema1L n0T1phic@+i0N Ch3Ck80x @nD pr3ss SUBm1+.";

// Thread Subscription notification ------------------------------------

$lang['subnotification_subject'] = "su8sCr1pTIOn n0tiPH1cati0n PhRom %s";
$lang['subnotification'] = "h3llo %s,\n\n%s P0\$ted 4 MEs\$4Ge 1n 4 tHRE4D J00 H4vE \$uBscrI8Ed To 0N %s.\n\n+h3 Su8j3C+ I\$: %s.\n\nTO r34d +HAT Me5S@ge @ND otHer\$ in +H3 5@M3 D1\$cussi0N, g0 +o:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nNO+e: 1ph J00 DO n0+ WI5H +0 REcE1V3 Em@1L n0+iF1C4TIOnS 0f N3W Mess493\$ 1N th1\$ +hre4D, go +0: %s 4ND 4dju\$T y0Ur 1NteR3st lEvel A+ +Eh b0++0M oph +h3 p@Ge.";

// PM notification -----------------------------------------------------

$lang['pmnotification_subject'] = "pM no+IfiC4+I0n FR0M %s";
$lang['pmnotification'] = "hELLo %s,\n\n%s po\$+Ed A Pm TO j00 0N %s.\n\n+hE \$u8JEc+ 15: %s.\n\n+O r34d tEh mEss@g3 90 +0:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nN0+e: 1pH J00 d0 N0t W1SH to rEC31V3 3M41l N0T1phiCA+ioN\$ 0f nEw pm mEsS493S Po\$+Ed +0 y0U, 90 to: %s clICK my con+RoLs THen em41L aNd pr1v@Cy, unselECt the Pm N0T1fic@+i0N cHeCkBox AND preSS sUBmi+.";

// Password change notification ----------------------------------------

$lang['passwdchangenotification'] = "p@Ssw0rd CH4N93 nO+iFiC4+ioN pHr0m %s";
$lang['pwchangeemail'] = "h3ll0 %s,\n\nThi5 4 n0t1FIc4tIon EMa1l +0 iNpHoRm j00 Th@t Y0uR p@ssw0Rd 0n %s H4S B33n Ch4NG3D.\n\n1t h4S 8EEN ch4N93d +0: %s 4ND WAs cHangeD By: %s.\n\niph J00 H4V3 r3C3IVeD Th1S Em@iL 1n 3rrOr oR w3R3 noT expeCt1nG a Ch@N9e +0 y0ur p4S5W0rD Pl34se C0Nt4C+ thE PH0rum owneR or @ moDer@t0R 0n %s 1mm3d14tEly to correC+ I+.";

// Email confirmation notification -------------------------------------

$lang['emailconfirmationrequired'] = "eMA1l C0nfIrm4+i0n R3qU1RED PHor %s";
$lang['confirmemail'] = "hElLo %s,\n\ny0U rECen+lY CrEateD 4 N3w Us3r @CCoUn+ on %s.\nBEF0re j00 c4n \$+@r+ pOst1ng we ne3d +0 ConPhirm y0UR em4iL 4DDr3\$S. D0N'T WoRry +H15 1\$ qUi+E 34Sy. 4ll J00 n3ed T0 Do 15 ClIck Th3 l1Nk BeLow (0r coPY 4ND p4stE i+ In+o y0uR 8r0ws3R):\n\n%s\n\noNCE confirM@+i0N 1\$ C0mPle+E j00 M4Y login @nd s+@r+ po\$TinG iMM3Di4+3ly.\n\n1ph j00 did n0+ Cre4te a usEr 4CC0Unt 0N %s plE4\$3 4ccEp+ 0ur ap0l09Ies @ND ph0RW4Rd +H1\$ 3Ma1l T0 %s S0 tH@t T3H 50UrcE oph i+ m4y b3 Inve\$T1G4t3d.";
$lang['confirmchangedemail'] = "h3LlO %s,\n\nyOu reC3NtLy Ch@ng3d YouR Em@Il 0n %s.\n8Eph0Re J00 C@n s+4rt Po5+iNG a94iN we NeEd to C0NPHirm y0uR n3w 3m41L @DDrEss. Don't W0rry +H1s iS qui+3 345y. @LL J00 N3ED To DO 1\$ ClICk thE l1nk BEl0w (or C0PY @nD p@\$+e I+ 1nT0 Y0Ur Br0W\$3r):\n\n%s\n\n0nC3 C0NPHiRM4T10n 1S C0mplEt3 j00 m@y C0nt1nu3 +o Use +H3 foRum @\$ N0Rm4l.\n\nIph J00 WerE no+ expeC+inG +h1\$ 3M4il pHrom %s PL34\$e @cCept our 4POlogie\$ 4ND phorW4rD thi\$ eM41l +0 %s s0 +h4t +3H s0Urc3 0f i+ M4Y 8E 1NV3st1G4TEd.";


// Forgotten password notification -------------------------------------

$lang['forgotpwemail'] = "hEllO %s,\n\ny0u rEqUEstEd +HI5 3-M4IL Fr0m %s 83caU\$e j00 H4V3 pHor90tt3N Y0ur P@ssW0Rd.\n\ncl1CK thE l1Nk 8eLow (0r Copy aND Pas+e It 1nT0 y0UR BroW53r) +O R3SE+ Your p4s5W0rD:\n\n%s";

// Forgotten password form.

$lang['passwdresetrequest'] = "yOUr p4SsworD R3S3+ REqU3s+ From %s";
$lang['passwdresetemailsent'] = "p4S\$W0Rd r3S3t E-M41L sEn+";
$lang['passwdresetexp'] = "j00 sh0ULD sh0rtlY recEivE 4n 3-M@Il C0N+@in1N9 1nstRuC+1oNs Ph0R re53+t1Ng yoUR p@\$Sw0RD.";
$lang['validusernamerequired'] = "a val1D usERN4m3 1\$ REquireD";
$lang['forgottenpasswd'] = "forg0+ Passw0RD";
$lang['couldnotsendpasswordreminder'] = "coULd n0+ 53Nd P@55w0RD rEm1nd3r. pl34se con+@C+ +h3 F0Rum owner.";
$lang['request'] = "r3Que5+";

// Email confirmation (confirm_email.php) ------------------------------

$lang['emailconfirmation'] = "eM4iL C0nPhIrM4+i0n";
$lang['emailconfirmationcomplete'] = "tH4NK J00 pH0r ConFirm1NG youR 3m4Il 4dDress. J00 M@Y n0w lOgin @nD \$+4rt po\$+1ng 1mmeDi@+3ly.";
$lang['emailconfirmationfailed'] = "em41l cOnfirM@+I0n h4s Ph@IL3d, PL34se tRY a9@in L4TEr. 1pH j00 3NCounTER +hIs 3Rror mult1pL3 +IM3s Pl34sE C0n+@Ct +He phorUm owN3r or 4 m0d3r@+0r For 4\$\$1\$+@nc3.";

// Links database (links*.php) -----------------------------------------

$lang['toplevel'] = "t0p l3veL";
$lang['maynotaccessthissection'] = "j00 m4y nOt aCC35s THis 5ect10N.";
$lang['toplevel'] = "t0P levEl";
$lang['links'] = "liNKs";
$lang['viewmode'] = "vIew mOde";
$lang['hierarchical'] = "hIEr4RCH1C4l";
$lang['list'] = "lIs+";
$lang['folderhidden'] = "this pholDeR 15 H1DD3n";
$lang['hide'] = "h1de";
$lang['unhide'] = "unhiD3";
$lang['nosubfolders'] = "n0 SuBF0LD3R\$ 1N +HI\$ cA+Eg0RY";
$lang['1subfolder'] = "1 5uBph0ld3R In th1s C4+390ry";
$lang['subfoldersinthiscategory'] = "su8f0LD3Rs 1n TH1\$ C4T3g0RY";
$lang['linksdelexp'] = "eNTR1Es iN @ DEl3tEd Ph0LdEr wilL BE m0v3D t0 teH p@r3Nt foLDeR. only f0LDEr5 wHIch d0 N0+ c0N+@In \$ubfolD3r\$ m@Y 83 D3l3TED.";
$lang['listview'] = "l15+ VIew";
$lang['listviewcannotaddfolders'] = "c@nno+ aDD folDeRs 1N TH1\$ viEw. sh0win9 20 3NTR13s @T A +ImE.";
$lang['rating'] = "rATIN9";
$lang['nolinksinfolder'] = "n0 l1Nks In +HI5 PHoLd3r.";
$lang['addlinkhere'] = "adD l1Nk HeR3";
$lang['notvalidURI'] = "th@+ 1\$ n0T 4 V4l1D Ur1!";
$lang['mustspecifyname'] = "j00 mus+ \$P3c1phy @ N4m3!";
$lang['mustspecifyvalidfolder'] = "j00 MUst sP3C1Fy 4 v@LID F0LDER!";
$lang['mustspecifyfolder'] = "j00 mUs+ \$p3c1fY 4 f0ldEr!";
$lang['successfullyaddedlinkname'] = "sucCEs\$PHully 4dDeD LinK '%s'";
$lang['failedtoaddlink'] = "f41l3D To adD l1nk";
$lang['failedtoaddfolder'] = "f41L3D +0 4Dd PhOlDeR";
$lang['addlink'] = "adD 4 l1nk";
$lang['addinglinkin'] = "aDD1N9 LiNk iN";
$lang['addressurluri'] = "adDRes5";
$lang['addnewfolder'] = "add @ N3w f0lD3R";
$lang['addnewfolderunder'] = "add1Ng N3w pHolD3r Under";
$lang['editfolder'] = "ed1+ F0LD3r";
$lang['editingfolder'] = "eDIT1Ng PhoLDer";
$lang['mustchooserating'] = "j00 mUs+ CHoo\$E 4 r4+iNG!";
$lang['commentadded'] = "yOUR ComM3N+ W4s 4dDEd.";
$lang['commentdeleted'] = "c0Mm3n+ w4s D3LEteD.";
$lang['commentcouldnotbedeleted'] = "comm3n+ c0UlD N0T 8e D3L3tED.";
$lang['musttypecomment'] = "j00 mU\$t +yPe @ CommEn+!";
$lang['mustprovidelinkID'] = "j00 mUst PRov1D3 @ LiNK ID!";
$lang['invalidlinkID'] = "invaLiD liNk ID!";
$lang['address'] = "addr3ss";
$lang['submittedby'] = "su8M1++eD By";
$lang['clicks'] = "clICk\$";
$lang['rating'] = "r@t1Ng";
$lang['vote'] = "voT3";
$lang['votes'] = "vOT3S";
$lang['notratedyet'] = "noT ratED BY 4ny0NE y3t";
$lang['rate'] = "r4+3";
$lang['bad'] = "b4d";
$lang['good'] = "gOod";
$lang['voteexcmark'] = "vOte!";
$lang['clearvote'] = "cle@R v0t3";
$lang['commentby'] = "c0MmEnt 8y %s";
$lang['addacommentabout'] = "aDD a Comm3N+ 4boUt";
$lang['modtools'] = "m0dEr4+i0N +0oLs";
$lang['editname'] = "eDI+ n@m3";
$lang['editaddress'] = "ed1t 4dDre5s";
$lang['editdescription'] = "ed1+ DescR1PT1on";
$lang['moveto'] = "mOV3 to";
$lang['linkdetails'] = "l1Nk D3+4ilS";
$lang['addcomment'] = "aDd c0MMEn+";
$lang['voterecorded'] = "yOur Vot3 H4S Be3n r3CoRdEd";
$lang['votecleared'] = "y0ur voTe has 8e3N CL3ArEd";

// Login / logout (llogon.php, logon.php, logout.php) -----------------------------------------

$lang['loggedinsuccessfully'] = "j00 Lo9G3D iN \$UCC3sSFUlly.";
$lang['presscontinuetoresend'] = "pr3Ss C0n+1NUE +o Res3nD phorm Da+4 or C4nC3l +o rELo4d p4g3.";
$lang['usernameorpasswdnotvalid'] = "tEH Us3Rn4me Or P4sSW0rd J00 suppLi3d 1\$ nO+ V@L1d.";
$lang['rememberpasswds'] = "r3meM8Er PAs5w0rd\$";
$lang['rememberpassword'] = "rEm3MBER p45SwoRd";
$lang['enterasa'] = "en+er @\$ 4 %s";
$lang['donthaveanaccount'] = "doN'T h4V3 @N ACC0Unt? %s";
$lang['registernow'] = "r3G1\$+3r N0W.";
$lang['problemsloggingon'] = "pr0bl3M5 l0991NG 0n?";
$lang['deletecookies'] = "d3LEtE C0OK13S";
$lang['cookiessuccessfullydeleted'] = "cOOki3s 5uCCEsSPhUlLy Del3+eD";
$lang['forgottenpasswd'] = "f0rg0+t3n yoUr P@5sw0Rd?";
$lang['usingaPDA'] = "uS1ng @ pd@?";
$lang['lightHTMLversion'] = "l19HT h+Ml VeR\$i0n";
$lang['youhaveloggedout'] = "j00 H4v3 L09G3d out.";
$lang['currentlyloggedinas'] = "j00 Ar3 cuRren+Ly log9eD 1n @s %s";
$lang['logonbutton'] = "lO90n";
$lang['otherbutton'] = "o+H3r";
$lang['yoursessionhasexpired'] = "yoUr sEs\$10n h@\$ 3xp1R3d. J00 W1ll NE3D To L09IN @G@In To C0Nt1NU3.";

// My Forums (forums.php) ---------------------------------------------------------

$lang['myforums'] = "mY F0Rum\$";
$lang['allavailableforums'] = "aLl 4v41L4bl3 f0rUm\$";
$lang['favouriteforums'] = "f4vouRi+3 phOrumS";
$lang['ignoredforums'] = "iGn0rED f0RuMs";
$lang['ignoreforum'] = "ignOR3 PH0ruM";
$lang['unignoreforum'] = "un-19N0r3 F0rUm";
$lang['lastvisited'] = "l@\$+ VisI+3D";
$lang['forumunreadmessages'] = "%s Unr34d m35\$493s";
$lang['forummessages'] = "%s M3ss4ges";
$lang['forumunreadtome'] = "%s unr3Ad &quot;To: m3&quot;";
$lang['forumnounreadmessages'] = "no unrE4D M3sS493\$";
$lang['removefromfavourites'] = "rEM0vE from PH4voURi+3s";
$lang['addtofavourites'] = "add +O ph@v0Uri+3S";
$lang['availableforums'] = "aV41l4blE fOrums";
$lang['noforumsofselectedtype'] = "tH3r3 @r3 No F0RuMs 0f TH3 s3LECTEd +Ype 4vA1lA8lE. pLE4\$3 \$eleC+ a D1Phph3rEn+ tyPE.";
$lang['noforumsavailablelogin'] = "thErE @r3 nO pH0RUm\$ 4v4ila8LE. PlE4SE loG1N t0 V1Ew Your PhoRums.";
$lang['passwdprotectedforum'] = "p@ssw0RD pr0teC+3d PhorUm";
$lang['passwdprotectedwarning'] = "tHIs PhorUm i\$ Pas\$WOrD pRoTec+3d. T0 9@iN @CCE5s En+Er teH p4\$Sw0Rd 8eL0W.";

// Message composition (post.php, lpost.php) --------------------------------------

$lang['postmessage'] = "p0St ME\$S@GE";
$lang['selectfolder'] = "s3LEC+ PhOlDer";
$lang['mustenterpostcontent'] = "j00 MUS+ 3n+3r \$0M3 c0n+3nT Ph0r TEh Post!";
$lang['messagepreview'] = "m3\$S493 pR3V13W";
$lang['invalidusername'] = "iNV4LId uSernAmE!";
$lang['mustenterthreadtitle'] = "j00 Mus+ en+3r 4 Ti+lE F0r +H3 +hR34d!";
$lang['pleaseselectfolder'] = "pl34\$e sel3Ct 4 F0LD3r!";
$lang['errorcreatingpost'] = "err0r cr3@+Ing P0\$t! pLE4s3 +Ry 49A1N 1n 4 ph3w M1nUt3s.";
$lang['createnewthread'] = "cR34+3 new +HR3@D";
$lang['postreply'] = "pOst r3Ply";
$lang['threadtitle'] = "thr34D +1+L3";
$lang['messagehasbeendeleted'] = "mE\$s493 No+ f0uNd. Ch3Ck TH4+ 1T H@\$N't 8EEN d3leted.";
$lang['messagenotfoundinselectedfolder'] = "m3Ss4g3 no+ PhoUnD in \$el3ctED pHolDEr. Ch3Ck +H@+ I+ H@\$N'T Be3N M0v3D or dEl3+ED.";
$lang['cannotpostthisthreadtypeinfolder'] = "j00 CaNnO+ p0\$+ +H1S thRe4d +YpE in +H4t f0lder!";
$lang['cannotpostthisthreadtype'] = "j00 c@Nn0t P0st +H1\$ THREad +YPe @s +H3r3 4r3 N0 4va1L4bl3 PHolD3R5 TH@+ 4Ll0w I+.";
$lang['cannotcreatenewthreads'] = "j00 C4nn0T CR3@+E n3W +Hr34Ds.";
$lang['threadisclosedforposting'] = "thI\$ ThR34D 1s CL0seD, j00 C4nn0+ P0st IN 1t!";
$lang['moderatorthreadclosed'] = "w4rNIn9: th1\$ +HrE@D 1\$ Cl0sEd F0R p05+iNG t0 N0rm4L usErs.";
$lang['usersinthread'] = "uSeR5 In THrE4d";
$lang['correctedcode'] = "c0rRECt3d C0d3";
$lang['submittedcode'] = "su8mI++ed cOd3";
$lang['htmlinmessage'] = "h+ML 1n ME\$S@Ge";
$lang['disableemoticonsinmessage'] = "dI\$a8lE 3mot1conS 1N M3S54GE";
$lang['automaticallyparseurls'] = "aU+0Ma+1c4LlY par\$E url\$";
$lang['automaticallycheckspelling'] = "aUT0M@+IcaLly ChECk sP3llinG";
$lang['setthreadtohighinterest'] = "s3+ +Hr34d +0 hIgH 1NtEre\$t";
$lang['enabledwithautolinebreaks'] = "en48L3D w1+h 4u+O-l1N3-BrE4Ks";
$lang['fixhtmlexplanation'] = "tHi\$ ph0rUm Use\$ H+ml Ph1l+3rIn9. Y0ur Subm1++3d H+Ml Ha5 8E3n m0d1f13D 8Y teH f1LT3rs in \$OmE w4y.\\n\\nt0 V1ew y0ur 0Ri91N@L coD3, sEl3CT +hE \\'\$uBm1+TeD c0d3\\' R4dio Bu+t0n.\\nto VI3W +Eh m0d1pHIED C0DE, \$eL3CT ThE \\'corr3ctEd c0d3\\' r4DI0 bu++0N.";
$lang['messageoptions'] = "m3s\$@ge Op+Ions";
$lang['notallowedembedattachmentpost'] = "j00 @re n0t 4ll0w3D +o 3M8ed 4+T4Chm3NTs iN Your pOSTs.";
$lang['notallowedembedattachmentsignature'] = "j00 @Re N0t ALLow3D T0 Em83D 4T+@chm3n+5 IN Y0ur si9n@+ure.";
$lang['reducemessagelength'] = "m3SS@G3 L3ngTh mu\$t bE uNdEr 65,535 Ch@r4Cter\$ (cUrR3n+ly: %s)";
$lang['reducesiglength'] = "s1GN@tUr3 lEn9+h Must BE unD3r 65,535 Ch@r@C+Er\$ (CUrrEn+lY: %s)";
$lang['cannotcreatethreadinfolder'] = "j00 c4nnOt Cr34+3 N3w +HR34Ds in +HIs f0ldER";
$lang['cannotcreatepostinfolder'] = "j00 CanNo+ r3pLy +0 p0s+5 IN TH15 PHOLDer";
$lang['cannotattachfilesinfolder'] = "j00 C4Nno+ Po\$+ @++4cHM3Nts iN +Hi\$ FOlD3R. Rem0ve @T+@Chments +0 Con+1NUe.";
$lang['postfrequencytoogreat'] = "j00 Can 0nly Pos+ 0ncE 3very %s sEConDS. pLe4se TRY @941n L4+3R.";
$lang['emailconfirmationrequiredbeforepost'] = "em41l cONF1rM4T1on Is R3quirED 8Ef0re j00 C4N Post. IPh J00 HavE n0+ R3C31v3D @ C0NPHirm4T10N Em4Il pLeasE Cl1Ck TEh 8U++0N Below @ND a n3w 0n3 wiLL BE 53NT +0 Y0U. 1f yoUR Em41l 4DdRe\$S n3eds CH4Ng1nG Pl34\$E Do s0 B3forE reqU35+IN9 4 n3w C0npH1rMa+10N eM4il. j00 M4y CH4N93 Y0ur em4il 4ddr3ss 8Y CLiCk my ContROls @8ov3 4nD +Hen u53r deta1l\$";
$lang['emailconfirmationfailedtosend'] = "cOnF1Rm4t1on 3m41l Ph@1lED +0 senD. PLe4se C0nt4c+ +eh pHorUm ownEr +o rECt1phY TH1S.";
$lang['emailconfirmationsent'] = "c0NPhIrm@+I0n EmA1L h@s BeEn rEseN+.";
$lang['resendconfirmation'] = "r3send ConpHiRm4+i0N";
$lang['userapprovalrequiredbeforeaccess'] = "y0Ur User aCC0un+ NEeD\$ TO 83 4PPR0ved BY 4 phorUm 4dMin b3For3 j00 C@n 4cCE\$S +H3 R3qu3steD phorUm.";

// Message display (messages.php & messages.inc.php) --------------------------------------

$lang['inreplyto'] = "in R3PlY +0";
$lang['showmessages'] = "sHoW Mes5@gE\$";
$lang['ratemyinterest'] = "r@+3 MY inT3r3sT";
$lang['adjtextsize'] = "aDjust tEx+ 5IZ3";
$lang['smaller'] = "sm4Ll3r";
$lang['larger'] = "l@rg3r";
$lang['faq'] = "f4Q";
$lang['docs'] = "dOC\$";
$lang['support'] = "supp0r+";
$lang['donateexcmark'] = "dOn4+E!";
$lang['threadcouldnotbefound'] = "t3h rEqu3s+Ed thrE4d CouLd n0+ 83 pHOUnd 0r @CCess w4S d3NiED.";
$lang['mustselectpolloption'] = "j00 Mu\$+ \$el3Ct 4n 0pT1On tO vote For!";
$lang['mustvoteforallgroups'] = "j00 mUst V0+3 IN 3v3rY gR0UP.";
$lang['keepreading'] = "ke3p rE4D1nG";
$lang['backtothreadlist'] = "b4ck tO ThrE4d lI\$+";
$lang['postdoesnotexist'] = "th4T p0\$+ dO3S No+ Ex1\$+ IN +hi\$ +Hr34d!";
$lang['clicktochangevote'] = "cl1Ck to ch4N93 VO+E";
$lang['youvotedforoption'] = "j00 Vot3D PhOr 0p+1on";
$lang['youvotedforoptions'] = "j00 v0+3D phor oP+1On\$";
$lang['clicktovote'] = "cL1Ck To v0+3";
$lang['youhavenotvoted'] = "j00 H@vE nOt VoTed";
$lang['viewresults'] = "vIew R3SulT5";
$lang['msgtruncated'] = "mE\$S493 +RUnc@+ED";
$lang['viewfullmsg'] = "v1ew Full Mes\$4GE";
$lang['ignoredmsg'] = "ignorEd mEs\$493";
$lang['wormeduser'] = "w0rmeD u\$Er";
$lang['ignoredsig'] = "ignOr3d S1Gn@tUrE";
$lang['messagewasdeleted'] = "m3s\$49e %s.%s w4s d3l3+3D";
$lang['stopignoringthisuser'] = "st0p iGnOriNG Th1\$ UsEr";
$lang['renamethread'] = "reN@Me +hR34D";
$lang['movethread'] = "m0v3 +hr34D";
$lang['editthepolltorenamethisthread'] = "ed1+ Th3 Poll to ReN4m3 +Hi5 ThRE4D";
$lang['closeforposting'] = "cL0se PH0r p05+iNG";
$lang['until'] = "uNT1l 00:00 utc";
$lang['approvalrequired'] = "approv4l REqu1red";
$lang['messageawaitingapprovalbymoderator'] = "m3ss493 %s.%s Is @w@i+Ing 4pPr0vaL BY @ moD3R@+Or";
$lang['postapprovedsuccessfully'] = "pOST 4PProV3d sUCCEs\$phUlly";
$lang['postapprovalfailed'] = "p0St 4PPr0v4l PH4iL3D.";
$lang['postdoesnotrequireapproval'] = "poST d0es nO+ REqU1R3 4Ppr0vaL";
$lang['approvepost'] = "aPpRoVe po\$+ F0R D1SpL4Y";
$lang['approvedbyuser'] = "apprOvED: %s By %s";
$lang['makesticky'] = "mAKE StiCkY";
$lang['messagecountdisplay'] = "%s 0f %s";
$lang['linktothread'] = "pERM4nen+ L1Nk To +H1\$ +Hr34D";
$lang['linktopost'] = "liNK To p0ST";
$lang['linktothispost'] = "l1Nk +o tH1S p0s+";
$lang['imageresized'] = "tHi\$ iM4ge H@5 B33n RESiz3d (Or19iN4l \$Iz3 %1\$SX%2\$\$). +0 v1ew +3h FULl-5IZ3 im493 cliCk HeR3.";
$lang['messagedeletedbyuser'] = "m3Ss493 %s.%s D3l3teD %s 8Y %s";
$lang['messagedeleted'] = "me\$s4G3 %s.%s W4s d3LEted";

// Moderators list (mods_list.php) -------------------------------------

$lang['cantdisplaymods'] = "c@nn0t D1\$pl4y f0lD3r Mod3r@+0R\$";
$lang['moderatorlist'] = "m0der@+Or Lis+:";
$lang['modsforfolder'] = "mOD3R@+0r5 PhoR f0lDer";
$lang['nomodsfound'] = "no m0d3R@+0rs FOuNd";
$lang['forumleaders'] = "f0rum L3@D3RS:";
$lang['foldermods'] = "f0LDEr M0der@t0rS:";

// Navigation strip (nav.php) ------------------------------------------

$lang['start'] = "s+4R+";
$lang['messages'] = "m3Ss4935";
$lang['pminbox'] = "in8OX";
$lang['startwiththreadlist'] = "s+4r+ P4G3 wI+H Thre4d LIs+";
$lang['pmsentitems'] = "s3n+ I+3MS";
$lang['pmoutbox'] = "oUt80X";
$lang['pmsaveditems'] = "s4vED i+3ms";
$lang['pmdrafts'] = "dr4Ph+\$";
$lang['links'] = "l1Nks";
$lang['admin'] = "adm1N";
$lang['login'] = "l0giN";
$lang['logout'] = "l0gou+";

// PM System (pm.php, pm_write.php, pm.inc.php) ------------------------

$lang['privatemessages'] = "pr1V4T3 m3\$S4geS";
$lang['recipienttiptext'] = "sep@R@+E r3cipI3NTs By s3mi-C0l0N 0r cOmm@";
$lang['maximumtenrecipientspermessage'] = "tH3R3 1\$ 4 L1mI+ Oph 10 r3c1p13ntS p3R mE5s@G3. PL34sE @MEnD y0ur rEc1Pi3nt Li\$T.";
$lang['mustspecifyrecipient'] = "j00 Mu\$t SP3c1Fy a+ L34St 0NE r3c1PIEnt.";
$lang['usernotfound'] = "u5er %s No+ PHoUND";
$lang['sendnewpm'] = "sEND n3w Pm";
$lang['savemessage'] = "s4VE mE5S@GE";
$lang['timesent'] = "t1M3 sen+";
$lang['nomessages'] = "no MEs\$4gE5";
$lang['errorcreatingpm'] = "erRoR Cr34TIN9 pM! PL3@S3 +RY @G41n In a Ph3w M1nute\$";
$lang['writepm'] = "wr1t3 Mess@g3";
$lang['editpm'] = "ed1t mEs\$49E";
$lang['cannoteditpm'] = "cANno+ 3di+ THiS Pm. 1+ h@5 4Lr3adY 8e3N VIeW3D By teH r3cIp13NT 0r +hE m3S\$49e Do35 No+ 3x15+ oR 1+ 1s 1n@cCEs5IBlE BY j00";
$lang['cannotviewpm'] = "c@NN0T V13w PM. M3Ss49E Do3\$ no+ 3Xi\$+ oR 1+ Is 1n@CC3Ssi8l3 8y J00";
$lang['pmmessagenumber'] = "meSs493 %s";

$lang['youhavexnewpm'] = "j00 h4v3 %d New Me\$S@Ge\$. WoulD j00 L1KE t0 G0 To YouR inBox noW?";
$lang['youhave1newpm'] = "j00 h@VE 1 neW mEss4GE. WOuld J00 lIK3 To g0 +o yoUr 1n80x n0W?";
$lang['youhave1newpmand1waiting'] = "j00 hav3 1 nEw m3sS@ge.\\n\\ny0u @lso h4vE 1 ME5\$ag3 4W41+InG d3liVery. t0 reC3Iv3 +h1\$ m3s5493 PlE4\$e Cl34r \$0Me sPACE in your 1n80X.\\n\\nwoUld J00 L1KE +O 90 +O y0uR 1nb0X nOw?";
$lang['youhave1pmwaiting'] = "j00 H4v3 1 m3\$\$4GE @W@I+ING D3LIv3ry. T0 R3cEIvE TH1s M3ss493 Ple453 Cl34R s0me sPac3 in YoUr In80x.\\n\\nW0uLD j00 LIke to 9O +0 YOur in8Ox Now?";
$lang['youhavexnewpmand1waiting'] = "j00 H@Ve %d nEw mEss@g3S.\\n\\nY0u 4l\$0 h4v3 1 M3\$S493 @w41+ING D3LIV3Ry. +0 R3c3iV3 +H15 mess493 PLe4se Cl34R s0m3 5pac3 1N y0ur 1N8oX.\\n\\nWoUlD j00 Lik3 +0 G0 to y0ur 1n80X noW?";
$lang['youhavexnewpmandxwaiting'] = "j00 have %d N3W m3s\$@ge\$.\\n\\ny0u @Ls0 H4V3 %d M3SS@93s @W@i+InG d3LIverY. To R3C3iVE tHese m3s\$4G3 PLE4\$e Cl3aR \$0m3 sp@C3 iN Y0ur inBox.\\n\\nw0uld J00 L1k3 +o g0 +0 yoUr inBox n0w?";
$lang['youhave1newpmandxwaiting'] = "j00 h@ve 1 nEw mes\$493.\\n\\ny0U @lso HavE %d m3s\$4935 @w41+1Ng D3Liv3ry. +0 r3ce1V3 th3Se m3s5@Ge\$ pL34\$3 cL34r soM3 sp@Ce 1n y0UR inB0X.\\n\\nwoUlD j00 l1k3 +0 Go +0 y0UR in80X now?";
$lang['youhavexpmwaiting'] = "j00 H@VE %d mE\$\$A93\$ 4W41+1ng D3Liv3Ry. To reCe1ve +h3se mEss@gE\$ Ple4sE cle4r 50ME \$PaC3 1N Y0Ur 1n80x.\\n\\nW0ULD j00 L1K3 TO 90 T0 youR InBox n0w?";

$lang['youdonothaveenoughfreespace'] = "j00 Do no+ H@Ve En0UgH fR3E \$p@ce To s3ND this M35s49E.";
$lang['userhasoptedoutofpm'] = "%s H45 opted 0u+ Oph rECe1vInG pEr\$0N4L ME\$\$4Ges";
$lang['pmfolderpruningisenabled'] = "pM fOLD3R prUnIn9 is 3N@BlEd!";
$lang['pmpruneexplanation'] = "th1\$ f0rUm u\$e\$ PM fOlD3r pruN1NG. tHE M3s\$493\$ j00 h4vE \$TOred in Your inBox 4nD sEnt 1+3MS\\nPHolDEr\$ 4r3 SuBj3c+ +o 4utom@+1C d3lEt1on. @NY m3ss@93\$ J00 WI\$h t0 Keep sh0uld BE MoVeD t0\\nYoUr \\'S@v3d 1+3ms\\' pholdeR so +h4t +HeY @r3 N0t D3LE+eD.";
$lang['yourpmfoldersare'] = "yOur pm Ph0LDEr5 @R3 %s phUll";
$lang['currentmessage'] = "cURr3Nt mEss493";
$lang['unreadmessage'] = "unre4D Mess4GE";
$lang['readmessage'] = "r34D m3s\$49e";
$lang['pmshavebeendisabled'] = "p3Rson@l mEs5@G3S H@V3 B33N Di5@BleD by +h3 phOrUm 0wnER.";
$lang['adduserstofriendslist'] = "add u\$er5 To y0Ur FriEnD\$ li\$+ To h4v3 Th3m @PPE4R iN a Drop D0Wn on ThE pm wr1+3 m3s\$493 pA93.";

$lang['messagesaved'] = "me\$S@g3 5@VED";
$lang['messagewassuccessfullysavedtodraftsfolder'] = "me\$s@g3 w4S SucCessFulLy 5@veD +0 'dR4pH+5' pHoldEr";
$lang['couldnotsavemessage'] = "c0ulD no+ \$@vE m3\$S493. M@K3 suRe j00 H@V3 3nOugH 4v41l4blE PhREe spaC3.";
$lang['pmtooltipxmessages'] = "%s M3ss@G3S";
$lang['pmtooltip1message'] = "1 M3ss493";

$lang['allowusertosendpm'] = "aLLoW user t0 sEnD pEr\$0n4L Mess4GE\$ +0 mE";
$lang['blockuserfromsendingpm'] = "bLock UsEr Phr0m senDIng pEr\$0nAL M3S\$4G3\$ +O m3";

// Preferences / Profile (user_*.php) ---------------------------------------------

$lang['mycontrols'] = "my c0ntR0Ls";
$lang['myforums'] = "mY foruMS";
$lang['menu'] = "mENu";
$lang['userexp_1'] = "use teh m3Nu ON T3h LEpH+ T0 mAn493 y0UR SE+t1NGs.";
$lang['userexp_2'] = "<b>u5er D3t41L5</b> 4LlOWs J00 t0 cH4n93 y0Ur N@m3, 3m41l aDDress 4Nd P@Ssword.";
$lang['userexp_3'] = "<b>u53r PR0F1l3</b> 4Ll0W\$ j00 To eDI+ YOur u5er Pr0f1Le.";
$lang['userexp_4'] = "<b>cH@N9e PaSsWOrD</b> @Ll0WS j00 +0 cH@N93 Y0ur p4S\$W0Rd";
$lang['userexp_5'] = "<b>em4il &amp; pRiV4Cy</b> Le+s J00 CH4ngE how j00 c@n bE C0N+4cTeD 0N aND 0fph the F0Rum.";
$lang['userexp_6'] = "<b>f0ruM 0PTi0ns</b> l3+s j00 Ch4N93 H0w +H3 F0ruM l0oks 4nd w0rks.";
$lang['userexp_7'] = "<b>at+@CHm3nts</b> @LL0wS J00 +0 Edi+/d3l3+3 YoUr @+T4ChM3N+s.";
$lang['userexp_8'] = "<b>s19N4TUrE</b> le+s j00 3d1+ yOur s19N4tUre.";
$lang['userexp_9'] = "<b>rEl4+1on\$h1Ps</b> LEt5 J00 M4na93 yoUr ReL@+ioN\$HiP Wi+h O+h3r Users 0n +3h f0RUm.";
$lang['userexp_9'] = "<b>w0rD F1lter</b> le+s j00 EDit yoUr pEr5on@l w0rd PHIlt3R.";
$lang['userexp_10'] = "<b>thR34D suBscr1pT1oN5</b> 4lLow5 j00 +0 m4n@g3 Y0UR thRe4d \$uBscr1p+I0ns.";
$lang['userdetails'] = "u53R DE+4ils";
$lang['userprofile'] = "uSer pr0f1l3";
$lang['emailandprivacy'] = "em@1l &amp; PriVAcy";
$lang['editsignature'] = "eD1+ 5IGn4+Ur3";
$lang['norelationships'] = "j00 HAVe nO u\$er r3l4+1on\$h1ps \$e+ Up";
$lang['editwordfilter'] = "ed1+ Word Ph1lTeR";
$lang['userinformation'] = "u\$3r 1NF0rm4T10n";
$lang['changepassword'] = "cHAn93 P@Ssw0RD";
$lang['currentpasswd'] = "cURr3nt p4ssword";
$lang['newpasswd'] = "n3W p4S5w0rD";
$lang['confirmpasswd'] = "cOnphirm p@\$sw0RD";
$lang['passwdsdonotmatch'] = "p45\$w0rDs Do n0+ M4+CH!";
$lang['nicknamerequired'] = "n1ckn4me i\$ r3qu1reD!";
$lang['emailaddressrequired'] = "eM4il @DDres\$ is rEqU1RED!";
$lang['logonnotpermitted'] = "lOGon N0+ PeRmi++ED. Ch0o\$E @No+H3R!";
$lang['nicknamenotpermitted'] = "n1cKn4M3 No+ PErMit+3d. ChOo\$3 4n0th3R!";
$lang['emailaddressnotpermitted'] = "eM4IL aDDre5s Not P3rmI++3d. CHoo\$3 4n0+H3r!";
$lang['emailaddressalreadyinuse'] = "eM4il 4ddR3Ss @lRe4dY 1N UsE. cHoo53 4nothEr!";
$lang['relationshipsupdated'] = "relati0N5hiP5 UpD4+3D!";
$lang['relationshipupdatefailed'] = "r3LaT1on5hIp UpD4TEd Ph@Il3d!";
$lang['preferencesupdated'] = "prefEr3NCEs WeR3 sUCC3\$SFUlly Upd4+3d.";
$lang['userdetails'] = "u5eR Det41l5";
$lang['memberno'] = "mEM8Er No.";
$lang['firstname'] = "f1rST n4mE";
$lang['lastname'] = "l4ST N@m3";
$lang['dateofbirth'] = "d4T3 0ph B1r+H";
$lang['homepageURL'] = "h0m3P4G3 Url";
$lang['profilepicturedimensions'] = "prOf1l3 P1ctuR3 (M@X 95x95px)";
$lang['avatarpicturedimensions'] = "av4T4r P1CTurE (m@X 15X15PX)";
$lang['invalidattachmentid'] = "iNv4LID @++@CHm3n+. ch3Ck +H4+ i5 H45n'+ 83en dEl3tED.";
$lang['unsupportedimagetype'] = "un\$uPp0R+ED iM@GE @++@ChMeNt. j00 C@N oNly Use jP9, 9iPH @ND Png 1m493 @Tt4Chm3n+\$ Phor y0ur Av4T@R 4ND pROph1le PiCTure.";
$lang['selectattachment'] = "s3leCt 4++4Chm3nt";
$lang['pictureURL'] = "pictur3 uRl";
$lang['avatarURL'] = "aV4T4R UrL";
$lang['profilepictureconflict'] = "t0 u\$e 4N @++@CHm3n+ pH0r Y0ur pr0pHiLe p1c+uR3 +HE pIC+UrE url f13Ld Must 8E 8L4Nk.";
$lang['avatarpictureconflict'] = "t0 uSE An @++4Chm3N+ f0r your Av4+@R p1C+UrE +H3 @V4tar url F1Eld mUsT B3 8L4nk.";
$lang['attachmenttoolargeforprofilepicture'] = "s3L3c+3D @++4ChM3NT I\$ +0o L@R9e pHor pR0ph1lE p1cTuRE. M@x1mum DiM3n\$10N\$ 4rE 95X95px";
$lang['attachmenttoolargeforavatarpicture'] = "s3LectED 4+T4chmen+ I\$ +0O l4r93 f0r @V@+4r p1CtuR3. M4XimUm D1MeN5I0ns @R3 15X15px";
$lang['failedtoupdateuserdetails'] = "s0mE 0r 4lL of yOuR User 4cCouNt D3T41L\$ C0uld NoT B3 UpD4+3D. PlE4S3 +rY 4G@1n l@+3r.";
$lang['failedtoupdateuserpreferences'] = "s0m3 OR 4ll oF y0ur u\$er PRePherENc3s C0uld n0t 8e upD@+ED. pLe4SE +Ry @g@In LaTer.";
$lang['emailaddresschanged'] = "eM@il adDr3ss h45 B33N CH4N93D";
$lang['newconfirmationemailsuccess'] = "y0ur em41l 4ddrE\$s h4s Been Ch4n93D @Nd @ N3w C0NPhiRM4T10N Em41L hAs B3en \$Ent. plE4se CHeck AnD R3@D tHe 3m4il For pHur+her In\$TRuc+ion5.";
$lang['newconfirmationemailfailure'] = "j00 h4vE Ch@ng3d YoUr 3m@1l 4DDrEs5, BuT wE wER3 Una8lE +0 S3nd 4 COnPh1rm@+i0n reqU3st. PlEase c0n+@CT +hE f0rum oWn3R FoR 4ssis+4ncE.";
$lang['forumoptions'] = "fOrum 0PT1On\$";
$lang['notifybyemail'] = "nOT1fY BY 3M4Il 0f Po\$+s +O mE";
$lang['notifyofnewpm'] = "n0T1fy BY PoPup opH NEw pm Me\$s4gE\$ +O m3";
$lang['notifyofnewpmemail'] = "n0+1PhY 8y 3m@Il 0f n3w Pm mEss@G3S to Me";
$lang['daylightsaving'] = "adJu5+ F0r D4yl19h+ 5@VinG";
$lang['autohighinterest'] = "aUT0m@+IC@Lly M4rk +HR34ds 1 pO\$+ iN @\$ H1gh iNt3R3s+";
$lang['convertimagestolinks'] = "aU+0m4TIc4lLy ConV3r+ 3M8EddEd 1mAgEs in p0st\$ IN+0 lINKs";
$lang['thumbnailsforimageattachments'] = "tHum8N@ils F0R iM@gE a+T4Chmen+\$";
$lang['smallsized'] = "sM@LL s1Z3d";
$lang['mediumsized'] = "m3dIum siZ3d";
$lang['largesized'] = "l@Rge \$1ZeD";
$lang['globallyignoresigs'] = "glo84lLy 1gN0RE User S19n4+ur3s";
$lang['allowpersonalmessages'] = "all0w 0tH3R U\$ers +O s3ND M3 P3rsOnal m35sA935";
$lang['allowemails'] = "allOw 0thEr U53rS to \$3nd m3 eM@il5 v14 mY PR0phIL3";
$lang['timezonefromGMT'] = "t1m3 ZOne";
$lang['postsperpage'] = "posts pEr P493";
$lang['fontsize'] = "f0Nt siz3";
$lang['forumstyle'] = "f0RuM s+yl3";
$lang['forumemoticons'] = "fORUm Em0t1c0ns";
$lang['startpage'] = "sT4Rt p4ge";
$lang['signaturecontainshtmlcode'] = "si9NaturE Cont@In5 H+Ml CoD3";
$lang['savesignatureforuseonallforums'] = "s4VE si9n@Tur3 f0r Us3 On 4lL pH0rUms";
$lang['preferredlang'] = "prepheRRED l4ngU4g3";
$lang['donotshowmyageordobtoothers'] = "dO no+ 5h0w My @GE or d@+E OpH 81r+h To 0thER\$";
$lang['showonlymyagetoothers'] = "sh0W onlY mY @g3 +0 O+hEr5";
$lang['showmyageanddobtoothers'] = "sH0w 8o+H mY @GE AnD da+E OPh 81RTH +0 0tHeRs";
$lang['showonlymydayandmonthofbirthytoothers'] = "sH0w 0nLy My D@y AnD montH 0PH BIrTh T0 OthEr\$";
$lang['listmeontheactiveusersdisplay'] = "li5+ Me 0n thE 4C+IV3 User\$ d1SPl4y";
$lang['browseanonymously'] = "br0wSe forUm @N0nym0u\$ly";
$lang['allowfriendstoseemeasonline'] = "bRowsE 4NonymoU\$ly, 8u+ @LLow FrI3ND\$ t0 s3e m3 @\$ 0Nl1ne";
$lang['revealspoileronmouseover'] = "r3VE4L Spo1Ler\$ On Mou\$E oV3R";
$lang['resizeimagesandreflowpage'] = "r3\$1Z3 IM@9e\$ @ND rEPhlOw p49e to Pr3ven+ Hor1zoN+@l sCr0lLIng.";
$lang['showforumstats'] = "sh0w Forum \$+ATs @+ 8otTOM 0f M3s5493 PaNe";
$lang['usewordfilter'] = "eN@8lE Word PhIL+3R.";
$lang['forceadminwordfilter'] = "f0Rc3 Use Oph admIn w0rD pH1ltEr on 4lL Users (1NC. Gu3S+s)";
$lang['timezone'] = "tIme zoNe";
$lang['language'] = "l@n9u@gE";
$lang['emailsettings'] = "em4il 4nD Con+4CT \$ett1N9\$";
$lang['forumanonymity'] = "fORUm @N0NyM1+y 53++1n9s";
$lang['birthdayanddateofbirth'] = "bIRThD4Y @nD D4+3 0f 81RTh D1SPl4y";
$lang['includeadminfilter'] = "incLud3 @DMin wOrd pHil+3r 1n My l1s+.";
$lang['setforallforums'] = "s3t f0r @ll Ph0rUms?";
$lang['containsinvalidchars'] = "%s coN+ain5 Inv4lId Ch4r4cteRs!";
$lang['homepageurlmustincludeschema'] = "hoM3p493 Url mUs+ 1nClUDe h++P:// \$ch3M4.";
$lang['pictureurlmustincludeschema'] = "p1c+uRe urL MU5+ 1nCluDE h++P:// sCH3M@.";
$lang['avatarurlmustincludeschema'] = "aV4TAR url mUs+ IncLuD3 hTtp:// sCH3m4.";
$lang['postpage'] = "p0s+ P493";
$lang['nohtmltoolbar'] = "n0 h+Ml t00Lb4r";
$lang['displaysimpletoolbar'] = "d15Pl4Y siMple HtMl +O0L84r";
$lang['displaytinymcetoolbar'] = "d1\$pl4Y Wy5Iwy9 H+ML +0olb4r";
$lang['displayemoticonspanel'] = "d15Pl4Y 3m0tIC0n\$ P4n3l";
$lang['displaysignature'] = "d15PlAY s1gn@+urE";
$lang['disableemoticonsinpostsbydefault'] = "d1\$4bL3 EM0+1coN\$ IN mEss@g3s 8y D3f4UlT";
$lang['automaticallyparseurlsbydefault'] = "auT0m4tIC@lLy p@Rse Url5 in M35s@g3s By Def4UlT";
$lang['postinplaintextbydefault'] = "p0St 1N pL41n tEx+ 8Y DEf@Ul+";
$lang['postinhtmlwithautolinebreaksbydefault'] = "p0St iN HTmL wI+H 4u+O-l1n3-8R34kS 8y d3f4ULT";
$lang['postinhtmlbydefault'] = "p0St 1N H+mL 8Y DeF4Ult";
$lang['privatemessageoptions'] = "pR1v4te M3S\$49e 0pTiOn\$";
$lang['privatemessageexportoptions'] = "priv4+3 mesS@gE 3XPor+ oPt1on\$";
$lang['savepminsentitems'] = "s@v3 @ c0pY OpH 34ch pm 1 s3nD 1N my \$3Nt I+3MS f0LD3r";
$lang['includepminreply'] = "iNClud3 M3s\$49e B0dy whEn RepLy1ng +0 Pm";
$lang['autoprunemypmfoldersevery'] = "au+o PRune My PM Fold3R\$ 3veRy:";
$lang['friendsonly'] = "fR1EnDs onlY?";
$lang['globalstyles'] = "gL084l \$TyLes";
$lang['forumstyles'] = "forum \$+Yl3S";
$lang['youmustenteryourcurrentpasswd'] = "j00 MU\$T En+3r Y0ur CUrr3nT P4SsW0RD";
$lang['youmustenteranewpasswd'] = "j00 MU5+ eNtEr 4 neW P45\$w0RD";
$lang['youmustconfirmyournewpasswd'] = "j00 MuS+ C0nPH1rM YouR n3w P4\$\$worD";
$lang['failedtoupdateuserprofile'] = "f4IL3d t0 UpD4tE usEr PR0PHiLe";

// Polls (create_poll.php, poll_results.php) ---------------------------------------------

$lang['mustprovideanswergroups'] = "j00 Mu\$t proVIDe s0m3 4n\$w3r 9r0UPS";
$lang['mustprovidepolltype'] = "j00 MU5+ Pr0v1d3 4 p0LL TYp3";
$lang['mustprovidepollresultsdisplaytype'] = "j00 mUst ProvIdE ReSults Di5pl4Y +yPE";
$lang['mustprovidepollvotetype'] = "j00 mus+ ProvidE @ PolL vot3 +YpE";
$lang['mustprovidepollguestvotetype'] = "j00 Mu\$t \$PECiPhY 1pH Gu3\$+s \$H0uLD 8E 4lL0w3d T0 vo+3";
$lang['mustprovidepolloptiontype'] = "j00 Must ProV1D3 @ PolL option +YP3";
$lang['mustprovidepollchangevotetype'] = "j00 MUst PrOv1D3 @ P0LL Ch4nGE v0Te +yPE";
$lang['pleaseselectfolder'] = "pl3aSE s3l3C+ A PHolDER";
$lang['mustspecifyvalues1and2'] = "j00 Mu5+ \$p3CiPhY v4lu3s F0R @NsweR\$ 1 4nD 2";
$lang['tablepollmusthave2groups'] = "t@BulAr pHoRm4t P0LL\$ muST h4ve pR3ciselY TW0 v0+1NG 9R0uP\$";
$lang['nomultivotetabulars'] = "t@buL@r f0rmA+ POlls c4nNO+ BE Mult1-VOtE";
$lang['nomultivotepublic'] = "pU8lIc 8alLO+s C@Nn0+ BE MulTi-V0tE";
$lang['abletochangevote'] = "j00 W1lL 83 @Bl3 +0 CH@nge yOur V0t3.";
$lang['abletovotemultiple'] = "j00 W1Ll 8e @8le +0 V0tE muLt1plE +Ime5.";
$lang['notabletochangevote'] = "j00 WiLL N0+ 83 48LE +O Ch4n9E yoUR vOt3.";
$lang['pollvotesrandom'] = "n0t3: P0lL V0t3\$ @R3 rANDomly GEn3R@+3D F0r pR3V13w 0nly.";
$lang['pollquestion'] = "poLl qU3s+1on";
$lang['possibleanswers'] = "p0ssI8l3 @nsW3r\$";
$lang['enterpollquestionexp'] = "eN+ER th3 4N\$wer\$ F0r your PolL quest1on.. 1ph YoUr p0ll 1s @ &quot;Ye5/no&quot; Qu3st10N, \$1mPly En+er &quot;yEs&quot; pHor 4n\$w3r 1 4nD &quot;n0&quot; ph0r 4N\$W3r 2.";
$lang['numberanswers'] = "nO. AnsWer\$";
$lang['answerscontainHTML'] = "aNsw3R\$ C0n+@In h+Ml (No+ 1nclUD1N9 5iGN@+Ure)";
$lang['optionsdisplay'] = "aNSWErs d1\$PL@y +yPE";
$lang['optionsdisplayexp'] = "how \$h0UlD ThE @nSwErs BE pR35EN+3d?";
$lang['dropdown'] = "a5 Dr0p-d0wN L1\$+(S)";
$lang['radios'] = "aS 4 seriE\$ 0PH r4Di0 8u++0n\$";
$lang['votechanging'] = "v0Te Ch4N91ng";
$lang['votechangingexp'] = "c4n A p3r\$0n cHAnGE h1S oR h3R vo+3?";
$lang['guestvoting'] = "gu3\$+ VO+iNg";
$lang['guestvotingexp'] = "c4n GU3StS vo+3 in THiS p0ll?";
$lang['allowmultiplevotes'] = "alLOw muL+iplE VO+3S";
$lang['pollresults'] = "polL R3sul+\$";
$lang['pollresultsexp'] = "h0W W0Uld j00 l1K3 To d15pl4y +h3 r3SUL+\$ 0Ph Y0uR p0ll?";
$lang['pollvotetype'] = "pOLl Vo+IN9 +yPe";
$lang['pollvotesexp'] = "hOw \$H0ULd Th3 P0lL be CONdUc+3d?";
$lang['pollvoteanon'] = "anONymousLy";
$lang['pollvotepub'] = "puBl1c 8@ll0t";
$lang['horizgraph'] = "h0r1Z0NtaL 9r4Ph";
$lang['vertgraph'] = "v3rtIc4L 9R@PH";
$lang['tablegraph'] = "t@buL4R Form4t";
$lang['polltypewarning'] = "<b>w@RnIng</b>: thI\$ is @ PuBLiC 84LL0+. yoUr N4M3 W1lL 8e vI518lE n3xt T0 The 0PT1on j00 voTe For.";
$lang['expiration'] = "eXp1r4TIoN";
$lang['showresultswhileopen'] = "dO j00 w4N+ T0 sH0W r3SUL+5 wh1Le +he pOll iS opEn?";
$lang['whenlikepollclose'] = "wh3N w0ulD j00 L1K3 YouR P0lL t0 4UT0m4+IC4Lly Cl0sE?";
$lang['oneday'] = "oNE d4Y";
$lang['threedays'] = "threE d4YS";
$lang['sevendays'] = "s3v3n D@y\$";
$lang['thirtydays'] = "tH1R+y D4Y5";
$lang['never'] = "nEver";
$lang['polladditionalmessage'] = "aDdi+I0Nal M3S\$4gE (0pt10N4l)";
$lang['polladditionalmessageexp'] = "dO j00 w4n+ t0 1ncluDE @n @dDIt1On@L p0st 4ftEr Th3 p0ll?";
$lang['mustspecifypolltoview'] = "j00 Mu\$+ sPeCifY 4 POll +O vI3W.";
$lang['pollconfirmclose'] = "aRe J00 \$uR3 j00 W4n+ To Cl0\$3 +eH pH0ll0w1ng Poll?";
$lang['endpoll'] = "end p0ll";
$lang['nobodyvotedclosedpoll'] = "nobOdy vo+3D";
$lang['votedisplayopenpoll'] = "%s 4nD %s H@v3 v0tEd.";
$lang['votedisplayclosedpoll'] = "%s 4nd %s v0TED.";
$lang['nousersvoted'] = "n0 USErs";
$lang['oneuservoted'] = "1 us3R";
$lang['xusersvoted'] = "%s u53RS";
$lang['noguestsvoted'] = "nO 9U3s+s";
$lang['oneguestvoted'] = "1 GUesT";
$lang['xguestsvoted'] = "%s guesTs";
$lang['pollhasended'] = "poLl Has eND3D";
$lang['youvotedforpolloptionsondate'] = "j00 V0tED for %s on %s";
$lang['thisisapoll'] = "tHIs 1S @ P0lL. CLick T0 V1ew R3SUL+s.";
$lang['editpoll'] = "eD1t Poll";
$lang['results'] = "r3SUlts";
$lang['resultdetails'] = "rE\$ULt dE+@Il\$";
$lang['changevote'] = "cH4nG3 V0te";
$lang['pollshavebeendisabled'] = "p0llS h4v3 8eEn Di\$@8L3D BY +3h f0ruM 0wn3r.";
$lang['answertext'] = "an\$w3R +Ex+";
$lang['answergroup'] = "an\$w3r 9R0UP";
$lang['previewvotingform'] = "pr3vI3W v0t1NG PhOrm";
$lang['viewbypolloption'] = "v13W 8Y P0lL opti0n";
$lang['viewbyuser'] = "v1ew 8y u\$er";

// Profiles (profile.php) ----------------------------------------------

$lang['editprofile'] = "eD1t pr0phil3";
$lang['profileupdated'] = "pROph1l3 Upd@t3d.";
$lang['profilesnotsetup'] = "tEH f0rUm owN3R Has n0T 5e+ Up PR0PH1l3\$.";
$lang['ignoreduser'] = "i9n0RED U5er";
$lang['lastvisit'] = "l45T v1\$1+";
$lang['userslocaltime'] = "u5Er'\$ LoC4l tiM3";
$lang['userstatus'] = "s+4tu\$";
$lang['useractive'] = "onlinE";
$lang['userinactive'] = "iN4ct1V3 / 0PhPhL1nE";
$lang['totaltimeinforum'] = "t0Tal +1M3";
$lang['longesttimeinforum'] = "lon9ESt s3SSI0N";
$lang['sendemail'] = "s3ND 3M4iL";
$lang['sendpm'] = "s3nd pm";
$lang['visithomepage'] = "v151T HomeP493";
$lang['age'] = "a93";
$lang['aged'] = "aG3D";
$lang['birthday'] = "bir+hD@Y";
$lang['registered'] = "r391\$+er3d";
$lang['findpostsmadebyuser'] = "fiND pOs+s M@De By %s";
$lang['findpostsmadebyme'] = "f1ND pO5+\$ m@D3 bY ME";
$lang['profilenotavailable'] = "pRof1l3 No+ Av41L@BL3.";
$lang['userprofileempty'] = "th1s USEr H4\$ no+ ph1lLeD In tHeIr Pr0PH1lE 0R I+ I\$ SE+ tO pR1v@+3.";

// Registration (register.php) -----------------------------------------

$lang['newuserregistrationsarenotpermitted'] = "sORry, n3w Us3R R39i\$+r4+10ns @R3 N0T 4lL0W3D RIgHT NoW. pLEase CheCk 8ack l@TeR.";
$lang['usernameinvalidchars'] = "u\$ern4m3 c4n ONLY COnt@iN @-z, 0-9, _ - Ch@RaCtEr\$";
$lang['usernametooshort'] = "u5erN4Me mUst B3 @ M1nIMUM 0f 2 ch4r4c+3r\$ L0N9";
$lang['usernametoolong'] = "uSern4ME mUs+ 8e @ M4XiMuM 0PH 15 Ch4r4C+eR\$ L0ng";
$lang['usernamerequired'] = "a log0n n4m3 i\$ r3qu1R3D";
$lang['passwdmustnotcontainHTML'] = "pas\$woRD mUst N0T COn+@iN Html +@G\$";
$lang['passwordinvalidchars'] = "p@SSword C4n 0nlY CoNt4IN 4-Z, 0-9, _ - CH4R4cTErs";
$lang['passwdtooshort'] = "p455wOrd mU5+ BE 4 MiNImum 0pH 6 Ch4r4ctEr\$ lon9";
$lang['passwdrequired'] = "a p4\$sw0Rd 1\$ REquIrED";
$lang['confirmationpasswdrequired'] = "a C0Nf1rM4t1on p4SSw0rD 1s R3quiReD";
$lang['nicknamerequired'] = "a NiCknAm3 Is r3quiReD";
$lang['emailrequired'] = "aN Em4il 4dDRess is ReQUiR3D";
$lang['passwdsdonotmatch'] = "p45swoRd\$ do nOT m4tcH";
$lang['usernamesameaspasswd'] = "uSERn@ME 4nd p4\$sw0rd MuS+ 8e D1FF3R3Nt";
$lang['usernameexists'] = "sORRy, 4 u\$Er W1+H +H4+ n4mE @LRe4Dy 3Xis+\$";
$lang['successfullycreateduseraccount'] = "sucC3ssFulLy CrE4+3d Us3R 4cCoUN+";
$lang['useraccountcreatedconfirmfailed'] = "yOur u\$Er 4cC0uNt h4s 8EEn cR34teD 8u+ +HE reqU1R3D C0Nf1rmA+I0N 3MA1l w4s n0t s3N+. pLE4sE C0NTact +H3 F0RUM 0Wn3r to ReC+1PHY tHi\$. 1n +h1\$ me4N+1me pL34\$E cl1cK the Cont1NU3 8u+T0N To L0gin 1N.";
$lang['useraccountcreatedconfirmsuccess'] = "y0UR us3r ACC0Unt H@5 8E3N cRe4TED 8ut B3FOre j00 C4N 5tARt p0st1NG j00 Mu5+ Confirm yoUr Em41l @dDr35s. PL3@s3 Ch3ck y0uR 3m41L F0r 4 L1nK tH4+ WiLl 4lL0W J00 +0 conphIRm y0uR 4DDrE\$S.";
$lang['useraccountcreated'] = "yOUr uS3R @Cc0Unt hAs 8e3n Cr34tED \$ucC3sspHullY! CLiCk teH C0n+Inue BUttON 8el0W to l0g1N";
$lang['errorcreatinguserrecord'] = "erR0R Cr34+1n9 UsEr rECorD";
$lang['userregistration'] = "u\$3r rE9is+r4+I0N";
$lang['registrationinformationrequired'] = "r3915TR@T10N 1nPhorm4tiOn (r3quIr3d)";
$lang['profileinformationoptional'] = "prOPhilE 1nF0rM4T1on (0pT10N4l)";
$lang['preferencesoptional'] = "pr3Fer3ncEs (oPt1on@l)";
$lang['register'] = "r3915teR";
$lang['rememberpasswd'] = "r3mEm8Er p4ssW0RD";
$lang['birthdayrequired'] = "y0ur D@+E 0ph Bir+H i\$ R3qU1RED 0r 1\$ inv@l1d";
$lang['alwaysnotifymeofrepliestome'] = "n0T1fy on R3ply +0 ME";
$lang['notifyonnewprivatemessage'] = "noT1phy 0n NEw pr1v@+3 mE5s@Ge";
$lang['popuponnewprivatemessage'] = "p0P Up on new Pr1V4+e me\$\$493";
$lang['automatichighinterestonpost'] = "aU+0M4T1c H19H 1NtErEst 0n Po\$t";
$lang['confirmpassword'] = "cONphiRm P@\$SW0rd";
$lang['invalidemailaddressformat'] = "iNV4LiD Em41L 4Ddr3S\$ PH0rm4+";
$lang['moreoptionsavailable'] = "m0re pR0PH1L3 @ND pR3pheR3NCE Opt10Ns 4RE 4v41LABl3 oNcE J00 r3g1\$+Er";
$lang['textcaptchaconfirmation'] = "c0nph1rm4T10N";
$lang['textcaptchaexplain'] = "t0 tH3 ri9h+ I\$ @ +3xt-C4p+CHa im493. Pl34sE tYp3 +eH C0dE J00 Can se3 1N tH3 iM493 In+0 tEh inpUt F1ElD 8Elow I+.";
$lang['textcaptchaimgtip'] = "tH1\$ 15 A CAp+CHa-p1c+uRe. 1+ i\$ us3d +0 pREvEnt @Ut0M@+1c REg15+r4+Ion";
$lang['textcaptchamissingkey'] = "a c0nph1rm4tIon c0d3 1\$ reQu1r3d.";
$lang['textcaptchaverificationfailed'] = "tEx+-c4pTCh@ V3rif1C@tioN C0DE W4S INC0RrEct. pL34Se Re-En+3r IT.";
$lang['forumrules'] = "f0RUm ruLes";
$lang['forumrulesnotification'] = "iN 0RD3R to ProCe3D, j00 MUs+ @9r3e w1+h tHE pH0ll0W1N9 RuLe\$";
$lang['forumrulescheckbox'] = "i H4V3 r34D, @ND @9r33 +0 4B1de 8y +H3 F0RUm RuL3s.";
$lang['youmustagreetotheforumrules'] = "j00 Mu\$t 49R33 +0 TEh pHorum rUl3s Bef0rE J00 C@n C0nt1NU3.";

// Recent visitors list  (visitor_log.php) -----------------------------

$lang['member'] = "mEMB3r";
$lang['searchforusernotinlist'] = "s34rCh PH0r 4 u53R not iN L15+";
$lang['yoursearchdidnotreturnanymatches'] = "y0ur sE@rCh DiD Not re+uRn @NY M@+Ch3S. +rY siMpl1fy1n9 YOur S34RCh p4R@METEr5 AnD +Ry 49@In.";
$lang['hiderowswithemptyornullvalues'] = "h1DE roW5 Wi+H EmP+y 0R null V4LU3\$ In sEl3c+3d C0lumNs";
$lang['showregisteredusersonly'] = "sHOW rE9I5+eR3D UseR\$ onLY (HIdE GU3\$ts)";

// Relationships (user_rel.php) ----------------------------------------

$lang['relationships'] = "r3la+I0nsh1pS";
$lang['userrelationship'] = "u53R r3l4+i0nsh1p";
$lang['userrelationships'] = "u5er REl4+10nshIps";
$lang['failedtoremoveselectedrelationships'] = "f41L3d +o rEmOv3 seLEC+3d ReL@+1OnshIp";
$lang['friends'] = "fR1end\$";
$lang['ignoredcompletely'] = "iGn0ReD c0mpl3tely";
$lang['relationship'] = "rEl@+i0nsh1p";
$lang['restorenickname'] = "rE\$+0rE uSer's nIckN4me";
$lang['friend_exp'] = "u\$er'\$ po\$ts M@rKED W1+h @ &quot;FrIeND&quot; icon.";
$lang['normal_exp'] = "u\$3r'\$ P05+s aPp34r AS norM4L.";
$lang['ignore_exp'] = "user's Po5+5 4rE H1dd3n.";
$lang['ignore_completely_exp'] = "tHr34dS 4nD postS to oR PhROm u\$er will 4pP34R DEl3+3D.";
$lang['display'] = "dIspl4Y";
$lang['displaysig_exp'] = "u\$3r'\$ 5i9n@+uRe 1\$ D1spL4y3D 0N +hEir P0Sts.";
$lang['hidesig_exp'] = "u\$3r'\$ 519N@+Ur3 1\$ hIdDeN 0n +heir P0st5.";
$lang['cannotignoremod'] = "j00 c4nNot I9Nor3 +hIS us3R, 4s +HEy 4re @ MoD3r4+Or.";
$lang['previewsignature'] = "pRev13W \$1gN4TURE";

// Search (search.php) -------------------------------------------------

$lang['searchresults'] = "sE4rcH rEsuLtS";
$lang['usernamenotfound'] = "th3 usErn4me J00 \$p3CipHI3d in +H3 +0 0r PHrOm f1elD W@\$ N0+ f0UND.";
$lang['notexttosearchfor'] = "on3 or @Ll 0f yoUR \$3@rCH k3yWORds w3r3 1nV@lID. sE4rCh k3yWorDS MUst B3 N0 sh0rt3R thaN %d CH4R4c+3R\$, no l0n9Er +H4N %d Ch@r4C+er\$ AnD mUst n0t 4PPeaR iN tH3 %s";
$lang['keywordscontainingerrors'] = "k3yWOrds ConT41NiN9 Errors: %s";
$lang['mysqlstopwordlist'] = "mysql s+oPw0RD l1s+";
$lang['foundzeromatches'] = "fOund: 0 M@+Ch3s";
$lang['found'] = "f0unD";
$lang['matches'] = "m@tches";
$lang['prevpage'] = "pr3Vi0Us Pa93";
$lang['findmore'] = "fIND m0rE";
$lang['searchmessages'] = "se@RcH mE5S493s";
$lang['searchdiscussions'] = "se4rCh D1ScUs\$1oN\$";
$lang['find'] = "f1nd";
$lang['additionalcriteria'] = "adD1+I0N4l CRi+3rIA";
$lang['searchbyuser'] = "sE@rch By User (0P+1on4L)";
$lang['folderbrackets_s'] = "fOlder(s)";
$lang['postedfrom'] = "p05+3D From";
$lang['postedto'] = "poS+3D +0";
$lang['today'] = "t0D4Y";
$lang['yesterday'] = "ye\$tErday";
$lang['daybeforeyesterday'] = "d4Y B3fOre y35+3RD4y";
$lang['weekago'] = "%s w3Ek 4g0";
$lang['weeksago'] = "%s we3k\$ 4go";
$lang['monthago'] = "%s mon+H @Go";
$lang['monthsago'] = "%s m0NTH\$ a90";
$lang['yearago'] = "%s y3@R 4g0";
$lang['beginningoftime'] = "bEGinNing 0ph t1m3";
$lang['now'] = "noW";
$lang['lastpostdate'] = "l4sT p0St datE";
$lang['numberofreplies'] = "nuM8Er OpH R3PL1E5";
$lang['foldername'] = "foLDEr n@M3";
$lang['authorname'] = "aUTh0r N4ME";
$lang['decendingorder'] = "n3w3ST phirsT";
$lang['ascendingorder'] = "old3St f1rst";
$lang['keywords'] = "kEyw0rD5";
$lang['sortby'] = "sOR+ 8y";
$lang['sortdir'] = "s0R+ d1R";
$lang['sortresults'] = "soR+ rE5ULT\$";
$lang['groupbythread'] = "gRoup 8y tHRE4D";
$lang['postsfromuser'] = "pOS+s pHr0m US3R";
$lang['poststouser'] = "poS+s +0 U\$3R";
$lang['poststoandfromuser'] = "p0\$TS +0 4nD froM U5Er";
$lang['searchfrequencyerror'] = "j00 C4N oNly S3@RCh 0NC3 eveRy %s \$EConDs. PL3453 +ry 4G41N l4+3R.";
$lang['searchsuccessfullycompleted'] = "s34Rch suCCE\$sFULly coMpL3TeD. %s";
$lang['clickheretoviewresults'] = "clICk h3re to vieW r3\$ul+5.";

// Search Popup (search_popup.php) -------------------------------------

$lang['select'] = "s3LeCt";
$lang['searchforthread'] = "s3@RCh pHor +Hre4d";
$lang['mustspecifytypeofsearch'] = "j00 mU5T sP3CIpHY +YPE 0PH Se@Rch t0 P3Rf0rm";
$lang['unkownsearchtypespecified'] = "uNKn0Wn \$3Arch +Yp3 sP3C1fi3D";

// Start page (start_left.php) -----------------------------------------

$lang['recentthreads'] = "r3CEN+ +hr34D5";
$lang['startreading'] = "sT4RT re4dIng";
$lang['threadoptions'] = "tHRE4d 0pTIonS";
$lang['editthreadoptions'] = "edi+ +Hr34d OpT1On\$";
$lang['morevisitors'] = "mOre vIs1T0r\$";
$lang['forthcomingbirthdays'] = "for+HC0MIng B1rthD4Ys";

// Start page (start_main.php) -----------------------------------------

$lang['editstartpage_help'] = "j00 cAN 3DI+ tHis p4g3 pHrom thE @DMin 1N+3rf4cE";
$lang['uploadstartpage'] = "upL0@D \$+4R+ P493 (%s)";
$lang['invalidfiletypeerror'] = "f1Le +Yp3 Not \$uPp0rt3d. J00 Can 0nLy u53 %s phiLes as yOUr st4rt P@Ge.";

// Thread navigation (thread_list.php) ---------------------------------

$lang['newdiscussion'] = "new D1\$cUs5i0n";
$lang['createpoll'] = "cRea+e POLl";
$lang['search'] = "s3@rCh";
$lang['searchagain'] = "sEArCh @941N";
$lang['alldiscussions'] = "aLl disCussI0Ns";
$lang['unreaddiscussions'] = "unr3@D DisCus510N\$";
$lang['unreadtome'] = "uNR3@d &quot;+0: M3&quot;";
$lang['todaysdiscussions'] = "tOd@y's Di\$cu\$51On\$";
$lang['2daysback'] = "2 d4Ys B4Ck";
$lang['7daysback'] = "7 daY5 84Ck";
$lang['highinterest'] = "hI9H in+Er3\$T";
$lang['unreadhighinterest'] = "uNREAD h1gH In+3res+";
$lang['iverecentlyseen'] = "i'V3 reC3Ntly s3En";
$lang['iveignored'] = "i'v3 Ign0ReD";
$lang['byignoredusers'] = "by igNoR3D Us3RS";
$lang['ivesubscribedto'] = "i'vE sU8\$cr1bED to";
$lang['startedbyfriend'] = "s+@R+3d 8y pHR13ND";
$lang['unreadstartedbyfriend'] = "uNr3AD \$+d By PHr13nD";
$lang['startedbyme'] = "st4Rt3D 8y Me";
$lang['unreadtoday'] = "unr34d +0d4y";
$lang['deletedthreads'] = "d3L3TEd +HR34Ds";
$lang['goexcmark'] = "g0!";
$lang['folderinterest'] = "fOLDer 1N+Er3\$T";
$lang['postnew'] = "p0sT n3w";
$lang['currentthread'] = "cuRR3n+ tHRe4d";
$lang['highinterest'] = "hi9h INtEr3st";
$lang['markasread'] = "maRK @5 r34D";
$lang['next50discussions'] = "neX+ 50 DisCU5si0ns";
$lang['visiblediscussions'] = "v1\$18l3 Di\$cuSsi0Ns";
$lang['selectedfolder'] = "s3Lec+3d F0ld3R";
$lang['navigate'] = "nav194t3";
$lang['couldnotretrievefolderinformation'] = "ther3 4re n0 f0ld3r5 Av4iL4bl3.";
$lang['nomessagesinthiscategory'] = "nO MEss@Ge\$ in tHis C4te90RY. pl34se \$3l3C+ An0th3r, 0r";
$lang['clickhere'] = "cl1Ck herE";
$lang['forallthreads'] = "fOr 4Ll tHrE4DS";
$lang['prev50threads'] = "prEvIous 50 +Hr3@ds";
$lang['next50threads'] = "nEXt 50 ThRE4ds";
$lang['nextxthreads'] = "nExt %s thrE4ds";
$lang['threadstartedbytooltip'] = "tHre@D #%s S+4r+eD BY %s. v1ewEd %s";
$lang['threadviewedonetime'] = "1 tiMe";
$lang['threadviewedtimes'] = "%d Times";
$lang['unreadthread'] = "uNRE4D +HrEAd";
$lang['readthread'] = "rE@d Thre4d";
$lang['unreadmessages'] = "uNr3Ad M3S\$4gEs";
$lang['subscribed'] = "sub\$cr183d";
$lang['ignorethisfolder'] = "ign0rE +hI5 pHoLdER";
$lang['stopignoringthisfolder'] = "s+Op iGnoR1Ng +H15 PhoLDEr";
$lang['stickythreads'] = "s+1cky +hR34Ds";
$lang['mostunreadposts'] = "m0St Unre4d P0S+s";
$lang['onenew'] = "%d New";
$lang['manynew'] = "%d nEw";
$lang['onenewoflength'] = "%d new 0f %d";
$lang['manynewoflength'] = "%d n3w 0pH %d";
$lang['ignorefolderconfirm'] = "aRe J00 sUre J00 W@N+ T0 19NorE +hIs f0ld3r?";
$lang['unignorefolderconfirm'] = "ar3 J00 SuRe j00 W4nt T0 sT0P 1gN0r1N9 th15 PH0ld3r?";
$lang['gotofirstpostinthread'] = "go to phiRst Po\$+ 1N tHrEaD";
$lang['gotolastpostinthread'] = "go t0 L@St post IN THrE4d";
$lang['viewmessagesinthisfolderonly'] = "vI3W M3ss4gE5 In tH1S phOlD3R oNly";
$lang['shownext50threads'] = "sh0W n3x+ 50 tHr3@D\$";
$lang['showprev50threads'] = "sh0w preV1oU\$ 50 +HRe4d5";
$lang['createnewdiscussioninthisfolder'] = "cR34te nEw d1\$cus\$I0N 1N Th1s F0lD3r";

// HTML toolbar (htmltools.inc.php) ------------------------------------
$lang['bold'] = "boLd";
$lang['italic'] = "i+Alic";
$lang['underline'] = "uNderl1N3";
$lang['strikethrough'] = "sTrikE+hR0uGh";
$lang['superscript'] = "suP3RScrip+";
$lang['subscript'] = "sUB\$CRip+";
$lang['leftalign'] = "left-@L19n";
$lang['center'] = "ceN+3r";
$lang['rightalign'] = "r19h+-4lIGN";
$lang['numberedlist'] = "nuMB3REd l1\$+";
$lang['list'] = "l1st";
$lang['indenttext'] = "indEn+ tEXT";
$lang['code'] = "c0d3";
$lang['quote'] = "quOTe";
$lang['spoiler'] = "sPO1L3r";
$lang['horizontalrule'] = "horiz0N+@l Rul3";
$lang['image'] = "im493";
$lang['hyperlink'] = "hYp3RliNk";
$lang['noemoticons'] = "dIsa8le 3MoT1c0NS";
$lang['fontface'] = "f0N+ Ph4ce";
$lang['size'] = "s1Ze";
$lang['colour'] = "c0lour";
$lang['red'] = "r3d";
$lang['orange'] = "orAn9e";
$lang['yellow'] = "y3llOw";
$lang['green'] = "gre3N";
$lang['blue'] = "bLu3";
$lang['indigo'] = "iNdig0";
$lang['violet'] = "vioL3t";
$lang['white'] = "wH1+e";
$lang['black'] = "blACk";
$lang['grey'] = "gR3y";
$lang['pink'] = "piNk";
$lang['lightgreen'] = "lI9HT gr33N";
$lang['lightblue'] = "lIGHt BlUe";

// Forum Stats (messages.inc.php - messages_forum_stats()) -------------

$lang['forumstats'] = "fORuM \$+@+s";
$lang['usersactiveinthepasttimeperiod'] = "%s @C+1ve In +Eh p4\$+ %s.";

$lang['numactiveguests'] = "<b>%s</b> gU3s+s";
$lang['oneactiveguest'] = "<b>1</b> Gu3sT";
$lang['numactivemembers'] = "<b>%s</b> M3Mb3r5";
$lang['oneactivemember'] = "<b>1</b> mem8er";
$lang['numactiveanonymousmembers'] = "<b>%s</b> Anonymous MEmbEr\$";
$lang['oneactiveanonymousmember'] = "<b>1</b> 4nonYmoUs m3m8er";

$lang['numthreadscreated'] = "<b>%s</b> +hR34Ds";
$lang['onethreadcreated'] = "<b>1</b> ThrE@D";
$lang['numpostscreated'] = "<b>%s</b> Po5t\$";
$lang['onepostcreated'] = "<b>1</b> P0\$t";

$lang['younormal'] = "j00";
$lang['youinvisible'] = "j00 (INV1sI8Le)";
$lang['viewcompletelist'] = "vIew c0MPL3te l1s+";
$lang['ourmembershavemadeatotalofnumthreadsandnumposts'] = "oUR M3MBErs h4ve M4D3 4 +0t4L 0f %s 4ND %s.";
$lang['longestthreadisthreadnamewithnumposts'] = "l0N93st +HRE@D i5 <b>%s</b> With %s.";
$lang['therehavebeenxpostsmadeinthelastsixtyminutes'] = "ther3 h4v3 BEEn <b>%s</b> Po5+S m@D3 1N th3 LaS+ 60 MInU+3s.";
$lang['therehasbeenonepostmadeinthelastsxityminutes'] = "ther3 h@\$ b33n <b>1</b> P0ST m4de In +H3 LAs+ 60 MINutE5.";
$lang['mostpostsevermadeinasinglesixtyminuteperiodwasnumposts'] = "moST po\$+S Ev3R m4d3 IN 4 S1n9L3 60 MiNutE peRioD Is <b>%s</b> oN %s.";
$lang['wehavenumregisteredmembersandthenewestmemberismembername'] = "w3 H4Ve <b>%s</b> R3gis+3reD meM83Rs 4ND tH3 N3wE\$+ M3M83R i\$ <b>%s</b>.";
$lang['wehavenumregisteredmember'] = "w3 H@V3 %s regi\$+3reD mEmB3r5.";
$lang['wehaveoneregisteredmember'] = "w3 h4v3 oNe RE9i\$+3R3d m3mB3r.";
$lang['mostuserseveronlinewasnumondate'] = "m0S+ U\$er5 3VEr 0nl1n3 W@\$ <b>%s</b> On %s.";
$lang['statsdisplayenabled'] = "s+@ts Di\$pL4y 3n4bl3d";

// Thread Options (thread_options.php) ---------------------------------

$lang['updatessavedsuccessfully'] = "uPd4+Es 5@V3d \$UCCEs\$fUlly";
$lang['useroptions'] = "user opt10ns";
$lang['markedasread'] = "m4rkeD @\$ R3@D";
$lang['postsoutof'] = "postS Out 0PH";
$lang['interest'] = "in+erE\$+";
$lang['closedforposting'] = "cl0SeD pHoR pO\$+1N9";
$lang['locktitleandfolder'] = "l0ck +1+lE @nd PholDeR";
$lang['deletepostsinthreadbyuser'] = "dEle+E P05tS iN ThRE@D BY Us3R";
$lang['deletethread'] = "d3L3+E +HR3@d";
$lang['permenantlydelete'] = "perm4NEntLy DEl3te";
$lang['movetodeleteditems'] = "m0Ve t0 DeL3TEd Thr34Ds";
$lang['undeletethread'] = "uNd3L3+3 tHR34D";
$lang['threaddeletedpermenantly'] = "tHRE4d Del3+3d p3Rm4n3N+ly. C4nn0t Und3lEtE.";
$lang['markasunread'] = "m4rk 4s Unr34D";
$lang['makethreadsticky'] = "mAK3 thRE4D 5tICky";
$lang['threareadstatusupdated'] = "thr34d Re4d 5+@+u\$ UpD@tED sUCCEssfully";
$lang['interestupdated'] = "thRE4D 1N+3r3s+ 5+@+Us uPd4TeD SUcCE\$SphUllY";
$lang['failedtoupdatethreadreadstatus'] = "f@1lEd To UpD4+3 +Hr3@D rE4d \$T4tu\$";
$lang['failedtoupdatethreadinterest'] = "f4il3d T0 UPd4te ThR3AD 1n+3r3St";
$lang['failedtorenamethread'] = "f41l3d t0 ren@M3 tHRE@D";
$lang['failedtomovethread'] = "f41L3d +0 moVE +hr34D t0 sp3c1FI3D PhOld3r";
$lang['failedtoupdatethreadstickystatus'] = "f4ilED +o upD4+E +hr34D stiCkY s+4+us";
$lang['failedtoupdatethreadlockstatus'] = "f@1l3d tO uPD4T3 ThRe4D LoCk stA+us";
$lang['failedtodeletepostsbyuser'] = "f4IL3d t0 DEl3+3 poSts 8Y 53lECtEd u5er";
$lang['failedtodeletethread'] = "f@Il3D To DelE+E +HR3@d.";
$lang['failedtoundeletethread'] = "f41L3D +o uN-D3L3+E +hr3@D";

// Dictionary (dictionary.php) -----------------------------------------

$lang['dictionary'] = "dIcti0n@ry";
$lang['spellcheck'] = "sPell cHecK";
$lang['notindictionary'] = "n0+ iN DiC+1On@rY";
$lang['changeto'] = "ch@ng3 t0";
$lang['restartspellcheck'] = "rest4R+";
$lang['cancelchanges'] = "c@NCel Ch4Ng3s";
$lang['initialisingdotdotdot'] = "in1t14LI\$1N9...";
$lang['spellcheckcomplete'] = "sp3ll cheCk iS C0mpl3T3. t0 Res+4R+ \$p3LL Ch3cK Cl1ck Res+@rt BU++0n BElow.";
$lang['spellcheck'] = "sPEll Ch3CK";
$lang['noformobj'] = "no F0rm 0Bj3CT \$p3ciphI3D PHor R3+UrN +3x+";
$lang['bodytext'] = "boDy +3Xt";
$lang['ignore'] = "igN0rE";
$lang['ignoreall'] = "i9NOr3 4ll";
$lang['change'] = "cH4ng3";
$lang['changeall'] = "cHan9E @Ll";
$lang['add'] = "add";
$lang['suggest'] = "sU993st";
$lang['nosuggestions'] = "(No 5UgGes+1ON\$)";
$lang['cancel'] = "cAnC3L";
$lang['dictionarynotinstalled'] = "n0 DiCtion@RY H4\$ Been 1nS+4lLeD. pLe4sE c0n+@CT +H3 ForUm own3r +o rEm3dy tHi\$.";

// Permissions keys ----------------------------------------------------

$lang['postreadingallowed'] = "p0s+ R34D1n9 alL0w3D";
$lang['postcreationallowed'] = "poSt Cr3@T1On 4ll0W3D";
$lang['threadcreationallowed'] = "thre4D Cr34+1on 4LLow3D";
$lang['posteditingallowed'] = "pO\$t 3d1+ING aLLOwED";
$lang['postdeletionallowed'] = "p0St D3LE+1on 4lL0wed";
$lang['attachmentsallowed'] = "a++@Chm3n+s alloW3D";
$lang['htmlpostingallowed'] = "html p05+InG @LL0W3d";
$lang['signatureallowed'] = "si9n4Tur3 AlL0WED";
$lang['guestaccessallowed'] = "gU35+ 4CC3SS @LLOwED";
$lang['postapprovalrequired'] = "p0S+ AppRov@l R3quir3D";

// RSS feeds gubbins

$lang['rssfeed'] = "r\$\$ PH3ed";
$lang['every30mins'] = "eVery 30 MiNU+3s";
$lang['onceanhour'] = "once 4n HoUr";
$lang['every6hours'] = "evERy 6 h0ur\$";
$lang['every12hours'] = "ev3ry 12 H0uRs";
$lang['onceaday'] = "oNc3 @ DAy";
$lang['rssfeeds'] = "rss f3ED\$";
$lang['feedname'] = "fE3D n4M3";
$lang['feedfoldername'] = "f33D ph0lDEr Nam3";
$lang['feedlocation'] = "f3eD LocA+1on";
$lang['threadtitleprefix'] = "thr34D t1+l3 pR3f1x";
$lang['feednameandlocation'] = "fE3D n@M3 4nd L0C@+I0N";
$lang['feedsettings'] = "f3Ed 5eT+1NG\$";
$lang['updatefrequency'] = "upda+E pHreQuEnCY";
$lang['rssclicktoreadarticle'] = "clIck h3R3 t0 R34D +HIs @RT1Cl3";
$lang['addnewfeed'] = "add NEw F3ED";
$lang['editfeed'] = "edi+ F3Ed";
$lang['feeduseraccount'] = "f33D u\$3R @CCoUnT";
$lang['noexistingfeeds'] = "nO 3x1S+1N9 Rss phEED\$ fouNd. To 4dd @ FEeD pLe4SE CliCk thE BU++0N BEl0w";
$lang['rssfeedhelp'] = "h3R3 J00 C@n \$EtUp s0mE r5\$ phe3d5 pHor aU+0m4+iC proP494t10N 1n+0 Y0UR pHorum. tH3 I+Ems phrom tHE r5\$ phe3DS j00 @DD wIlL 8E crE4+3D As +Hr3@dS WhicH usEr5 can r3ply +0 as iF +h3y w3r3 n0rm4L pO\$+s. Th3 R\$S F3eD mUSt BE 4CCEs51Ble v14 HtTp 0r i+ W1ll no+ Work.";
$lang['mustspecifyrssfeedname'] = "mUS+ \$P3C1FY Rs5 pHEEd n4m3";
$lang['mustspecifyrssfeeduseraccount'] = "mU\$+ 5p3Ciphy r\$S FE3D U53R 4CCoUnt";
$lang['mustspecifyrssfeedfolder'] = "musT sP3C1pHy Rs5 Ph3ed pHoLdEr";
$lang['mustspecifyrssfeedurl'] = "mu\$+ Sp3c1fY r\$S ph3eD uRl";
$lang['mustspecifyrssfeedupdatefrequency'] = "mU\$+ \$p3ciphy r\$\$ Ph3eD UPD4+3 FrEqU3NCy";
$lang['unknownrssuseraccount'] = "uNKnowN r\$\$ U\$3r ACC0UnT";
$lang['rssfeedsupportshttpurlsonly'] = "rSS FeEd 5upp0rTs htTp urls only. SECurE f3eDs (hTtp\$://) AR3 N0t sUpP0RteD.";
$lang['rssfeedurlformatinvalid'] = "r\$5 ph3eD uRl F0Rma+ I\$ InV@L1D. URl MUs+ inCLuDE \$chEMe (E.g. H+Tp://) @ND 4 HO5TN4m3 (3.9. wWW.Ho5+n@ME.COM).";
$lang['rssfeeduserauthentication'] = "rs\$ ph3Ed Do3\$ no+ \$uPpoRT h++P uS3R aU+H3NtICa+1on";
$lang['successfullyremovedselectedfeeds'] = "succES\$PHUllY r3m0V3d sEl3cteD pH3eD\$";
$lang['successfullyaddedfeed'] = "sUcc3s\$phullY 4dDeD N3w F3ED";
$lang['successfullyeditedfeed'] = "sucC3s\$fuLLY ED1T3D phEeD";
$lang['failedtoremovefeeds'] = "f4il3d +0 R3m0v3 \$OmE or all 0f Teh sEl3C+eD ph3ed5";
$lang['failedtoaddnewrssfeed'] = "f41l3d +O @DD NEw Rss PH3eD";
$lang['failedtoupdaterssfeed'] = "f4il3D to UpD4t3 r\$S pH3eD";
$lang['rssstreamworkingcorrectly'] = "r5s \$+Re4m @PPE4Rs +0 8E W0rk1nG CorRECtly";
$lang['rssstreamnotworkingcorrectly'] = "r\$\$ \$+r34M W4\$ 3mPtY 0R CoulD N0T 8e Ph0Und";
$lang['invalidfeedidorfeednotfound'] = "iNV4l1d FeEd 1d or FeED nOt f0UND";

// PM Export Options

$lang['pmexportastype'] = "exP0Rt 4\$ +yp3";
$lang['pmexporthtml'] = "htML";
$lang['pmexportxml'] = "xML";
$lang['pmexportplaintext'] = "pLA1N T3Xt";
$lang['pmexportmessagesas'] = "exPOR+ MeSs@g3s @\$";
$lang['pmexportonefileforallmessages'] = "oNe fIl3 F0r @Ll M3\$s4GES";
$lang['pmexportonefilepermessage'] = "oN3 F1l3 peR M3\$s493";
$lang['pmexportattachments'] = "expor+ A+T4ChmEN+s";
$lang['pmexportincludestyle'] = "inclUd3 f0RUM \$+YlE shE3+";
$lang['pmexportwordfilter'] = "aPPLy w0rD PhiL+3R To mes5@GE\$";

// Thread merge / split options

$lang['threadhasbeensplit'] = "thre4d H4\$ 8eEn \$pli+";
$lang['threadhasbeenmerged'] = "tHR3ad H@\$ beEN M3rg3D";
$lang['mergesplitthread'] = "meR9E / spl1+ THR3@D";
$lang['mergewiththreadid'] = "m3R9e wi+H +hR3ad Id:";
$lang['postsinthisthreadatstart'] = "p0\$TS 1N THIs thr34d 4t st4Rt";
$lang['postsinthisthreadatend'] = "pOSTs in +his +hre4D A+ 3ND";
$lang['reorderpostsintodateorder'] = "r3-0RDer pOST5 1N+0 D4tE orD3r";
$lang['splitthreadatpost'] = "spl1+ +hr34D aT P0St:";
$lang['selectedpostsandrepliesonly'] = "s3l3c+3d p0st @ND rEpl13\$ 0nLY";
$lang['selectedandallfollowingposts'] = "s3lECTed @ND 4ll phoLl0w1Ng po\$+\$";

$lang['threadmovedhere'] = "h3re";

$lang['thisthreadhasmoved'] = "<b>thr3@DS m3r93d:</b> th1S Thr34D H@\$ m0Ved %s";
$lang['thisthreadwasmergedfrom'] = "<b>tHR34d5 MErgEd:</b> TH1\$ +HR34D W4s MEr93d FRom %s";
$lang['somepostsinthisthreadhavebeenmoved'] = "<b>thre@D SplIt:</b> Som3 P0st5 1N +hI\$ +HR3@D H@v3 8EeN moV3D %s";
$lang['somepostsinthisthreadweremovedfrom'] = "<b>tHr34D spl1+:</b> S0me Po\$ts 1N +Hi5 tHrE4d W3re m0vED pHrom %s";

$lang['thisposthasbeenmoved'] = "<b>thre4D 5plI+:</b> +H1\$ post H4s B3EN M0ved %s";

$lang['invalidfunctionarguments'] = "iNV4l1d phuNCtioN 4R9umEnTs";
$lang['couldnotretrieveforumdata'] = "cOUld not r3tR1eVE PHoRum D4T@";
$lang['cannotmergepolls'] = "oNE or m0RE tHr34Ds i\$ @ p0lL. J00 C4NNot MErg3 P0LL\$";
$lang['couldnotretrievethreaddatamerge'] = "cOUld nO+ REtri3ve +Hr34d d4tA Phr0M 0ne 0r moR3 tHrE4Ds";
$lang['couldnotretrievethreaddatasplit'] = "cOUlD N0T R3TR13VE +HR34d d4Ta PHrom s0urC3 +Hr34d";
$lang['couldnotretrievepostdatamerge'] = "c0ulD N0t r3trIEve P05+ Da+4 Fr0m 0Ne 0R m0r3 Thr34DS";
$lang['couldnotretrievepostdatasplit'] = "cOULd n0+ RE+r1EVe P05+ Dat4 fr0M S0UrC3 thR3@D";
$lang['failedtocreatenewthreadformerge'] = "f@1l3D to Cr3@+3 neW +Hr3@D f0r mEr93";
$lang['failedtocreatenewthreadforsplit'] = "f@Il3D +0 crE4+3 New +Hr3@d phoR spl1+";

// Thread subscriptions

$lang['threadsubscriptions'] = "tHr3AD 5uBsCr1Pt1on\$";
$lang['couldnotupdateinterestonthread'] = "c0ULd noT UpD4TE IntEr3S+ On +hRe4D '%s'";
$lang['threadinterestsupdatedsuccessfully'] = "tHRE4D 1nTEr3sTs UpD@+3d suCC3\$sfuLly";
$lang['resetselected'] = "rESEt s3L3C+3D";
$lang['allthreadtypes'] = "aLl +hr34D +YpEs";
$lang['ignoredthreads'] = "i9nor3d ThREaD\$";
$lang['highinterestthreads'] = "hi9H iN+Er3\$+ +hR34Ds";
$lang['subscribedthreads'] = "sU8sCr1Bed THRE4Ds";
$lang['currentinterest'] = "curr3N+ 1nTerE5+";

// Browseable user profiles

$lang['youcanonlyaddthreecolumns'] = "j00 C4n onlY 4dD 3 C0lumns. T0 4Dd A New C0lUmn Clo\$3 4n Exis+inG 0nE";
$lang['columnalreadyadded'] = "j00 H4v3 4Lr34DY aDdEd +H1\$ C0LUmn. iF J00 WAN+ +0 RemovE i+ Click i+'\$ cl0se Button";

?>