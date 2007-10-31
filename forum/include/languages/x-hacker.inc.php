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

/* $Id: x-hacker.inc.php,v 1.258 2007-10-31 17:10:05 decoyduck Exp $ */

// British English language file

// Language character set and text direction options -------------------

$lang['_isocode'] = "en";
$lang['_textdir'] = "ltr";

// Months --------------------------------------------------------------

$lang['month'][1]  = "j4nU@Ry";
$lang['month'][2]  = "f38rU4RY";
$lang['month'][3]  = "m4rCh";
$lang['month'][4]  = "april";
$lang['month'][5]  = "m4y";
$lang['month'][6]  = "jUn3";
$lang['month'][7]  = "juLy";
$lang['month'][8]  = "auGU\$T";
$lang['month'][9]  = "sEp+3mB3r";
$lang['month'][10] = "oC+OBEr";
$lang['month'][11] = "noVEmb3R";
$lang['month'][12] = "d3c3MB3R";

$lang['month_short'][1]  = "j@n";
$lang['month_short'][2]  = "f38";
$lang['month_short'][3]  = "m4R";
$lang['month_short'][4]  = "apR";
$lang['month_short'][5]  = "mAY";
$lang['month_short'][6]  = "juN";
$lang['month_short'][7]  = "juL";
$lang['month_short'][8]  = "au9";
$lang['month_short'][9]  = "s3P";
$lang['month_short'][10] = "oc+";
$lang['month_short'][11] = "nOv";
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

$lang['date_periods']['year']   = "%s Y3@r";
$lang['date_periods']['month']  = "%s MoN+H";
$lang['date_periods']['week']   = "%s wE3K";
$lang['date_periods']['day']    = "%s d4y";
$lang['date_periods']['hour']   = "%s H0uR";
$lang['date_periods']['minute'] = "%s m1nu+3";
$lang['date_periods']['second'] = "%s 53c0ND";

// As above but plurals (2 years vs. 1 year, etc.)

$lang['date_periods_plural']['year']   = "%s yE@rs";
$lang['date_periods_plural']['month']  = "%s m0Nths";
$lang['date_periods_plural']['week']   = "%s w33ks";
$lang['date_periods_plural']['day']    = "%s days";
$lang['date_periods_plural']['hour']   = "%s H0ur\$";
$lang['date_periods_plural']['minute'] = "%s m1nu+3s";
$lang['date_periods_plural']['second'] = "%s \$3c0nD\$";

// Short hand periods (example: 1y, 2m, 3w, 4d, 5hr, 6min, 7sec)

$lang['date_periods_short']['year']   = "%sy";    // 1y
$lang['date_periods_short']['month']  = "%sM";    // 2m
$lang['date_periods_short']['week']   = "%sW";    // 3w
$lang['date_periods_short']['day']    = "%sd";    // 4d
$lang['date_periods_short']['hour']   = "%shr";   // 5hr
$lang['date_periods_short']['minute'] = "%sM1n";  // 6min
$lang['date_periods_short']['second'] = "%sSeC";  // 7sec

// Common words --------------------------------------------------------

$lang['percent'] = "p3rc3N+";
$lang['average'] = "aVer4g3";
$lang['approve'] = "appr0vE";
$lang['banned'] = "b4NN3d";
$lang['locked'] = "l0CkeD";
$lang['add'] = "add";
$lang['advanced'] = "aDVANCED";
$lang['active'] = "aCTIv3";
$lang['style'] = "sTyl3";
$lang['go'] = "gO";
$lang['folder'] = "f0ld3r";
$lang['ignoredfolder'] = "i9n0rED PhoLDER";
$lang['folders'] = "f0Ld3rs";
$lang['thread'] = "tHreaD";
$lang['threads'] = "thre4DS";
$lang['threadlist'] = "tHr34d lI5+";
$lang['message'] = "m3Ss493";
$lang['messagenumber'] = "me\$\$49E nUM83R";
$lang['from'] = "fR0m";
$lang['to'] = "t0";
$lang['all_caps'] = "alL";
$lang['of'] = "opH";
$lang['reply'] = "r3Ply";
$lang['forward'] = "foRW4RD";
$lang['replyall'] = "r3ply +0 4Ll";
$lang['pm_reply'] = "rePLy @5 Pm";
$lang['delete'] = "d3L3t3";
$lang['deleted'] = "deLETEd";
$lang['edit'] = "edi+";
$lang['privileges'] = "pR1v1LE93s";
$lang['ignore'] = "i9NORe";
$lang['normal'] = "n0rM4l";
$lang['interested'] = "inteR3steD";
$lang['subscribe'] = "sub\$Cr1bE";
$lang['apply'] = "aPPLY";
$lang['download'] = "downl0aD";
$lang['save'] = "s4ve";
$lang['update'] = "uPDate";
$lang['cancel'] = "c4NC3l";
$lang['retry'] = "retry";
$lang['continue'] = "coN+InU3";
$lang['attachment'] = "a+t4ChmEnT";
$lang['attachments'] = "aT+4CHm3nTS";
$lang['imageattachments'] = "im@gE @++@CHM3n+s";
$lang['filename'] = "f1L3N@M3";
$lang['dimensions'] = "diMENs1ON\$";
$lang['downloadedxtimes'] = "d0WNL04d3D: %d t1m3s";
$lang['downloadedonetime'] = "d0WNlO4D3D: 1 T1m3";
$lang['size'] = "s1Ze";
$lang['viewmessage'] = "vi3w mEss493";
$lang['deletethumbnails'] = "d3L3te +hUM8n41L\$";
$lang['logon'] = "lo9on";
$lang['more'] = "m0RE";
$lang['recentvisitors'] = "r3ceNt vI51+0R5";
$lang['username'] = "usERN@m3";
$lang['clear'] = "cl34R";
$lang['action'] = "acti0n";
$lang['unknown'] = "uNKnown";
$lang['none'] = "nOne";
$lang['preview'] = "pr3v1ew";
$lang['post'] = "p0S+";
$lang['posts'] = "pOSTs";
$lang['change'] = "cH@nGE";
$lang['yes'] = "yE5";
$lang['no'] = "n0";
$lang['signature'] = "s19n4tUR3";
$lang['signaturepreview'] = "sI9n4+Ur3 pR3ViEW";
$lang['signatureupdated'] = "sI9n4+ur3 upD4+3d";
$lang['signatureupdatedforallforums'] = "s19n4tURE UPDatED F0r @lL F0rUM\$";
$lang['back'] = "bAck";
$lang['subject'] = "subj3Ct";
$lang['close'] = "cl0s3";
$lang['name'] = "n4m3";
$lang['description'] = "de\$cr1P+i0N";
$lang['date'] = "d4t3";
$lang['view'] = "vIew";
$lang['enterpasswd'] = "eNTER P4\$\$W0rd";
$lang['passwd'] = "p4ssw0rD";
$lang['ignored'] = "i9N0rEd";
$lang['guest'] = "gue\$T";
$lang['next'] = "nEXT";
$lang['prev'] = "prev10us";
$lang['others'] = "o+h3rS";
$lang['nickname'] = "nicKn4m3";
$lang['emailaddress'] = "em4iL adDR3SS";
$lang['confirm'] = "cOnpH1rM";
$lang['email'] = "eM@1l";
$lang['poll'] = "p0LL";
$lang['friend'] = "frI3ND";
$lang['success'] = "sUcCe\$s";
$lang['error'] = "eRr0r";
$lang['warning'] = "w4RNing";
$lang['guesterror'] = "s0RRY, j00 N33d TO B3 l09g3d in +O USe tH1\$ PH34tur3.";
$lang['loginnow'] = "login n0w";
$lang['unread'] = "unr34D";
$lang['all'] = "alL";
$lang['allcaps'] = "aLl";
$lang['permissions'] = "p3Rmi5Si0N5";
$lang['type'] = "tyPE";
$lang['print'] = "pr1nt";
$lang['sticky'] = "stICKy";
$lang['polls'] = "p0ll\$";
$lang['user'] = "u\$Er";
$lang['enabled'] = "eN4BlED";
$lang['disabled'] = "dIs@blED";
$lang['options'] = "oPTI0n\$";
$lang['emoticons'] = "eMO+icoNs";
$lang['webtag'] = "weB+49";
$lang['makedefault'] = "m4KE D3faUlt";
$lang['unsetdefault'] = "unSE+ D3FaULt";
$lang['rename'] = "r3NAME";
$lang['pages'] = "p4ge5";
$lang['used'] = "u5ed";
$lang['days'] = "d4ys";
$lang['usage'] = "u\$493";
$lang['show'] = "sh0w";
$lang['hint'] = "h1Nt";
$lang['new'] = "n3W";
$lang['referer'] = "r3ph3REr";
$lang['thefollowingerrorswereencountered'] = "tH3 f0ll0W1ng 3RrOr\$ w3r3 EnCOUNtER3D:";

// Admin interface (admin*.php) ----------------------------------------

$lang['admintools'] = "adMiN Tools";
$lang['forummanagement'] = "fORUM m4n493M3Nt";
$lang['accessdeniedexp'] = "j00 D0 n0+ h@V3 PErM1ss1ON +0 usE +H1\$ s3Ct10n.";
$lang['managefolders'] = "m@N@93 f0lDer\$";
$lang['manageforums'] = "m@n4ge foRUms";
$lang['manageforumpermissions'] = "m@N@gE phoRUm PERMis5i0N5";
$lang['foldername'] = "f0lD3r n4M3";
$lang['move'] = "mOve";
$lang['closed'] = "cLosed";
$lang['open'] = "op3n";
$lang['restricted'] = "rES+R1C+ED";
$lang['forumiscurrentlyclosed'] = "%s 1s CurREn+LY CL0S3D";
$lang['youdonothaveaccesstoforum'] = "j00 DO Not h@V3 4cc35S +o %s";
$lang['toapplyforaccessplease'] = "to 4pplY PHOr 4cc3SS ple4SE cont4C+ +3h F0rum OwN3R.";
$lang['adminforumclosedtip'] = "iF j00 w4N+ T0 ChAn93 s0M3 \$e++inGs On Y0UR pH0ruM cLiCK +EH @DMIn l1nK in Th3 n@VI94+i0n 84R 4Bov3.";
$lang['newfolder'] = "neW ph0LD3R";
$lang['nofoldersfound'] = "n0 eX1S+1ng pholder5 Ph0uND. To @Dd @ f0LD3r cl1CK +eh '4Dd nEW' 8u++0n BEl0w.";
$lang['forumadmin'] = "forum 4dm1N";
$lang['adminexp_1'] = "u5e +HE m3nu on TH3 L3ft +0 m4n4GE +Hing\$ 1n yoUR pH0RUM.";
$lang['adminexp_2'] = "<b>uSeRS</b> @lLoW\$ J00 +0 s3T iNDIVIdu4l UsER peRmISsi0Ns, INCLUd1n9 4ppoin+InG M0d3R@t0Rs @nD g49GiNG pE0pL3.";
$lang['adminexp_3'] = "<b>uS3r gr0up\$</b> 4llow\$ j00 t0 CR3@tE user 9r0up\$ to As\$ign P3RM1\$\$1on\$ to 45 M4Ny or 45 pHEW U\$ER5 quICKLy 4nd 3@5ily.";
$lang['adminexp_4'] = "<b>b4N C0n+roL5</b> 4ll0Ws +hE 84nn1Ng @ND Un-84nNin9 0f iP 4DDrEsse5, H+tp R3Fer3Rs, Us3Rn@mE\$, 3m4il 4DDR3s\$Es @ND N1CKn4m3S.";
$lang['adminexp_5'] = "<b>folD3RS</b> @lLOW\$ tH3 crE4T1ON, M0d1Ph1c4+1on anD DEL3t10n 0Ph F0ldEr\$.";
$lang['adminexp_6'] = "<b>r\$\$ f3EDs</b> 4LLOw\$ J00 To M4n@G3 R5\$ FE3D5 PHOr pr0p4G@+10n 1NTO yOUr pH0rum.";
$lang['adminexp_7'] = "<b>pR0fiL3S</b> LE+s J00 cUST0misE +H3 1+3Ms +H4+ ApP34R IN +h3 u\$3r pR0PH1l3\$.";
$lang['adminexp_8'] = "<b>foRuM \$e++iNG5</b> 4ll0ws J00 T0 CUST0m1sE YouR F0rum's n4m3, @PpE@R4NC3 4ND m@NY 0ThER +H1ngS.";
$lang['adminexp_9'] = "<b>start p@g3</b> Let5 J00 CUS+om1\$E YoUr PHorum'5 5+4R+ p4g3.";
$lang['adminexp_10'] = "<b>f0RUM \$+YL3</b> AlLoWs j00 +0 93nER4tE r4ndom s+YleS PhOr Y0ur F0ruM MEm8ERs to uS3.";
$lang['adminexp_11'] = "<b>w0RD Ph1l+3R</b> ALlOwS J00 +0 Ph1lTeR woRDs J00 don't W4NT +0 8E u\$3D on Y0ur pHOrUm.";
$lang['adminexp_12'] = "<b>po\$+1ng s+@+5</b> 93nEr4TES A R3P0RT l1S+InG +He T0p 10 p0\$TER\$ In 4 DEFIN3d p3r10d.";
$lang['adminexp_13'] = "<b>f0rum lInKs</b> LET\$ J00 M@n@GE tEh lInKs Dr0pdowN 1N +HE n4Vi94+10n 84r.";
$lang['adminexp_14'] = "<b>v13w l09</b> LisTs R3C3nt 4c+1oN\$ By +he pH0rUm MoD3R4tors.";
$lang['adminexp_15'] = "<b>m4N493 f0rUm5</b> L3+5 j00 cr3A+3 4Nd DEL3+3 4Nd CLO53 0R R30Pen PHoRUMs.";
$lang['adminexp_16'] = "<b>gl084l foRuM se+T1N9s</b> 4LlOw\$ j00 +0 m0d1phy sE++in9s WhiCH @FF3C+ @lL f0rUM\$.";
$lang['adminexp_17'] = "<b>poST 4pPR0v4L qUEu3</b> allOW\$ J00 T0 vi3W 4ny Po5+s 4w4I+1n9 4pPRoV4L 8y 4 m0dER@t0r.";
$lang['adminexp_18'] = "<b>vi\$I+0r Log</b> 4ll0Ws j00 T0 V13W 4N ex+ENDED L1\$+ opH V15It0R5 inClUD1ng thEIr HtTp RepHER3rs.";
$lang['createforumstyle'] = "crE4+3 @ F0Rum STYl3";
$lang['newstylesuccessfullycreated'] = "neW \$tyl3 \$UcCEsSFuLlY crEaTEd.";
$lang['stylealreadyexists'] = "a S+yLE wI+H +Hat fIL3N4m3 @lrE4dy EXi5+S.";
$lang['stylenofilename'] = "j00 D1D N0T 3nteR a F1len4M3 +0 S4ve TEH \$+ylE Wi+h.";
$lang['stylenodatasubmitted'] = "c0uld N0+ re4D f0rum s+YlE D@+4.";
$lang['styleexp'] = "uS3 TH1S P@93 +o heLp CRE4te 4 r@nDOMLy 93N3R4+3d s+YLE F0r youR F0ruM.";
$lang['stylecontrols'] = "cOn+rOls";
$lang['stylecolourexp'] = "cLick 0N 4 c0L0ur to M4ke @ n3w \$+ylE \$h3E+ 8aS3D 0N +H4+ C0l0uR. CURrEnT 84se COL0ur is pH1rst iN lis+.";
$lang['standardstyle'] = "sTAND4RD S+YlE";
$lang['rotelementstyle'] = "r0TAtEd el3meNT 5+yl3";
$lang['randstyle'] = "ranD0M stYLE";
$lang['thiscolour'] = "th15 C0louR";
$lang['enterhexcolour'] = "oR ent3r @ HeX ColouR t0 8A5e @ n3W \$tyl3 \$hE3+ On";
$lang['savestyle'] = "s@V3 +his styL3";
$lang['styledesc'] = "sTYlE D3SCR1P+10n";
$lang['stylefilenamemayonlycontain'] = "s+Yl3 pHiLen4M3 M4Y OnLy CoN+41N low3rC45e L3+TerS (a-Z), NuM8ER5 (0-9) 4ND uNDER\$c0rE.";
$lang['stylepreview'] = "s+YL3 PR3v13w";
$lang['welcome'] = "weLCOm3";
$lang['messagepreview'] = "m3\$S493 Pr3v13w";
$lang['users'] = "u53RS";
$lang['usergroups'] = "u\$ER 9r0Up\$";
$lang['mustentergroupname'] = "j00 must 3ntER @ 9r0UP n4M3";
$lang['profiles'] = "pRof1l3s";
$lang['manageforums'] = "m4N@G3 F0rum\$";
$lang['forumsettings'] = "fOrUM sEtTiNGs";
$lang['globalforumsettings'] = "gLob4L F0rum 53t+1ngs";
$lang['settingsaffectallforumswarning'] = "<b>nOte:</b> tH3se sEtT1Ng\$ aPhfEC+ aLl f0RUMs. wH3rE +3h \$e++1NG 15 DUpliC4TED 0n +EH iND1viduAl PhOrum'\$ \$3tt1nG\$ P4g3 tH4T WIlL t4K3 prEC3D3nc3 0V3R ThE \$ett1N9S j00 Ch4nge H3rE.";
$lang['startpage'] = "sTar+ p@g3";
$lang['startpageerror'] = "your \$t4Rt p@GE COUlD NoT B3 s4V3D loc@llY t0 t3h 53Rver BecaU\$e pErMI\$\$1on wAs D3n13D.</p><p>to Ch4n93 y0uR St4rt P@G3 pLE4Se CliCK TEH DOwnlo4d BU+T0N 83l0W Wh1CH wiLL PromP+ J00 +o \$@V3 +He PhiL3 +0 Y0ur h4RD DR1v3. J00 c4n TH3n upL0@D th1\$ PHiLE +o y0uR Serv3r intO +h3 F0lloWing ph0LDEr, Iph n3C3Ss4ry CRE4+iN9 +h3 PholDER s+RUC+Ur3 1n t3H procEss.</p><p><b>%s</b></p><p>pLe4s3 NOT3 +h4+ soME 8rowSErs m@y CH4NgE +he N@mE oF +he fIl3 upoN D0wnloaD.  wh3N Uplo4Din9 +Eh f1l3 pl34\$e m@ke suRe that it 1\$ N4m3d s+4r+_m4In.php 0+HErwis3 y0ur 5+@r+ p@Ge will 4ppE4r unCH4N9ed.";
$lang['failedtoopenmasterstylesheet'] = "your pHorum S+Yl3 C0uld n0+ BE s@VED 83C4u\$e +H3 m4\$+3r 5+Yl3 \$h33+ CoULD nOT B3 l04D3d. t0 \$@VE Y0ur StYL3 +eh m@\$+3R \$TYl3 5H3et (M@K3_S+YlE.C5\$) MUs+ 8E LOCATED IN +EH StYl3s D1r3c+0RY opH Y0UR b3ehIV3 PhoRUM in\$+4lL4T10N.";
$lang['makestyleerror'] = "yOUR pHoRuM Styl3 cOUlD no+ Be \$AV3D l0c@llY To +HE \$erv3R BEC@UsE pERmiss1on W4S D3n13D. +0 \$4v3 yoUR pH0RUM s+yl3 pL3@s3 CL1ck THE D0wNl04d BUT+On b3low wH1CH w1ll Pr0mPT j00 TO s4V3 +h3 fil3 t0 y0Ur H@RD DRIV3. J00 C4n +Hen uPL04d +HiS Ph1l3 +0 y0UR serveR 1nto %s pholDEr, 1F neC35s4ry crE4+iN9 T3H f0lD3r \$+ructUrE 1N the pR0C3sS. j00 sh0ulD not3 +h4T sOM3 Br0wSERs m@Y Ch4Ng3 th3 n4M3 of The f1L3 Upon Downlo4D. wh3N upL0@Ding +Eh f1L3 pl34\$3 makE 5Ur3 th4+ i+ is n@Med 5+YL3.c5\$ 0thErw15e +H3 phorUm styl3 W1ll 83 unu5@BlE.";
$lang['uploadfailed'] = "y0UR nEw 5+4RT p@GE C0ulD No+ BE UpLo4d3d T0 TEH S3RVER 8EC4u\$e peRMI\$si0N W4\$ DEN1eD. PL34sE ChECK TH4T +HE W3b 53rv3R / pHP proC3ss I\$ @8L3 to wRi+3 +0 +h3 %s phoLDER On y0ur \$3rver.";
$lang['forumstyle'] = "f0rum s+yl3";
$lang['wordfilter'] = "wOrD philTER";
$lang['forumlinks'] = "fOrum links";
$lang['viewlog'] = "v13w l09";
$lang['noprofilesectionspecified'] = "n0 pr0phIl3 \$eCt10n sp3C1pH13D.";
$lang['itemname'] = "iTem n@m3";
$lang['moveto'] = "mOve +0";
$lang['manageprofilesections'] = "m@na93 ProfiLE s3C+1On\$";
$lang['sectionname'] = "sEc+10n N4M3";
$lang['items'] = "iTems";
$lang['mustspecifyaprofilesectionid'] = "mu\$+ SP3ciphY 4 PR0f1l3 \$3c+i0n ID";
$lang['mustsepecifyaprofilesectionname'] = "mU\$+ \$P3C1PHY @ ProFiL3 \$3C+Ion n@m3";
$lang['noprofilesectionsfound'] = "no 3XI5+1ng Pr0pHilE 5ECT10ns phOuND. t0 4Dd 4 proF1l3 \$ect10n cL1ck Th3 '4dD N3w' 8U++0n 83L0w.";
$lang['addnewprofilesection'] = "add N3w proph1L3 sec+1oN";
$lang['successfullyaddedprofilesection'] = "sUcC3\$SfULly 4dd3d pR0Ph1l3 \$3c+iOn";
$lang['successfullyeditedprofilesection'] = "sUCCESsFUlLy 3DI+ED proFiL3 s3c+I0n";
$lang['addnewprofilesection'] = "add NEw pR0PH1l3 SEC+1on";
$lang['mustsepecifyaprofilesectionname'] = "mUsT \$P3cifY @ Pr0file s3C+i0n n4m3";
$lang['successfullyremovedselectedprofilesections'] = "sUcCESsFUlly rEMOvED S3l3C+3d proPh1L3 s3CTiOn\$";
$lang['failedtoremoveprofilesections'] = "f@iL3D to REM0V3 prOFiL3 sEC+10ns";
$lang['viewitems'] = "v1Ew 1+3m\$";
$lang['successfullyaddednewprofileitem'] = "succ3ssFullY ADD3D n3W prOFil3 i+3m";
$lang['successfullyeditedprofileitem'] = "sUcC3\$sphuLlY 3D1+eD pRofILE I+3m";
$lang['successfullyremovedselectedprofileitems'] = "successFUlLY reM0V3d \$el3CtED propHiL3 i+EMs";
$lang['failedtoremoveprofileitems'] = "f4Il3D tO rEMoVe Pr0ph1L3 itEMs";
$lang['noexistingprofileitemsfound'] = "th3R3 @r3 n0 3x1\$+1ng Pr0Ph1L3 Item5 in +Hi\$ \$ecT1ON. +o 4DD 4n iTEM Cl1ck t3H '@DD NEW' BU++0n BEL0W.";
$lang['edititem'] = "ed1t itEm";
$lang['invalidprofilesectionid'] = "iNv4lId PR0PHil3 s3C+i0n 1d 0R sECT10N NoT FounD";
$lang['invalidprofileitemid'] = "iNv4L1d pr0philE 1+3m id oR ItEm nO+ PhOuNd";
$lang['addnewitem'] = "aDd N3W 1tEm";
$lang['youmustenteraprofileitemname'] = "j00 mUSt ENtER a pr0FiL3 i+3m NAmE";
$lang['invalidprofileitemtype'] = "iNv4LId Pr0F1lE item +YP3 \$elect3D";
$lang['youmustenteroptionsforselectedprofileitemtype'] = "j00 MU5+ 3N+3R som3 op+ioN\$ PhOR \$EL3c+ED Pr0pH1lE 1t3M tyPE";
$lang['youmustentermorethanoneoptionforitem'] = "j00 mus+ 3nter MOrE +H@n One OpTIon PHor sElec+Ed prOFiLE I+3m +yPE";
$lang['profileitemhyperlinkssupportshttpurlsonly'] = "pRoFile IT3m hyPERLInk5 5upp0RT ht+p urls 0Nly";
$lang['profileitemhyperlinkformatinvalid'] = "pR0PHIl3 I+EM hypErl1Nk f0rm4+ Inv@L1d";
$lang['youmustincludeprofileentryinhyperlinks'] = "j00 mU5+ iNCLUde <i>[pR0f1l3En+Ry]</i> 1n TEh uRl oF CL1ck4BLE hYpERLInK\$";
$lang['failedtocreatenewprofileitem'] = "fa1l3D t0 CR34t3 NEw pr0ph1L3 1+EM";
$lang['failedtoupdateprofileitem'] = "f4Il3D +0 uPD4+3 PRoPhIl3 it3m";
$lang['startpageupdated'] = "st4R+ P4GE UpD@+3D. %s";
$lang['viewupdatedstartpage'] = "v13w UpD4+3D \$+@Rt P493";
$lang['editstartpage'] = "ed1T 5T4RT P@G3";
$lang['nouserspecified'] = "no U5Er sp3ciFi3d.";
$lang['manageuser'] = "m4NA93 u5ER";
$lang['manageusers'] = "man493 u\$3rs";
$lang['userstatusforforum'] = "u\$3r \$+4tus F0r %s";
$lang['userdetails'] = "u\$3r dEta1lS";
$lang['warning_caps'] = "w4rn1Ng";
$lang['userdeleteallpostswarning'] = "aRE j00 sure J00 W4N+ +O DEL3t3 @LL 0f TEH \$el3C+3d User'5 p0\$+s? Onc3 tEH P0s+5 4re D3Le+3d Th3y CaNN0+ 8e rETR13VED 4nD Will 8E l0ST F0rev3r.";
$lang['postssuccessfullydeleted'] = "p0sts weR3 \$uCC3sspHULLY DELe+3D.";
$lang['folderaccess'] = "fOldER 4cc3SS";
$lang['possiblealiases'] = "poSs18le 4L14S3S";
$lang['userhistory'] = "usER h1S+0Ry";
$lang['nohistory'] = "nO h1s+0Ry REC0rd\$ \$@v3D";
$lang['userhistorychanges'] = "ch@ng3S";
$lang['clearuserhistory'] = "cl3@R UsER H15+0Ry";
$lang['changedlogonfromto'] = "cH@NGED l0GOn FRoM %s tO %s";
$lang['changednicknamefromto'] = "ch@NG3D N1CKn4m3 Fr0m %s to %s";
$lang['changedemailfromto'] = "cH4ngED 3m4iL Fr0m %s +O %s";
$lang['successfullycleareduserhistory'] = "sUcCe\$SpHUllY CLe4r3D u\$eR H1\$t0rY";
$lang['failedtoclearuserhistory'] = "f4IlED to CL3Ar Us3R Hi\$+0rY";
$lang['successfullychangedpassword'] = "sucC3ssfUlLy cH4NG3D pAssworD";
$lang['failedtochangepasswd'] = "fAIL3D +o ch@n9e paSsw0RD";
$lang['viewuserhistory'] = "v13w u\$er h1s+0rY";
$lang['viewuseraliases'] = "vIew UsEr alI4\$3s";
$lang['searchreturnednoresults'] = "s3@rch r3tURnED n0 rE5Ult\$";
$lang['deleteposts'] = "d3l3t3 Po5+s";
$lang['deleteuser'] = "deLEtE U\$3r";
$lang['alsodeleteusercontent'] = "alS0 D3le+3 @Ll opH +3h c0n+En+ Cr3@+3d 8Y thi\$ US3R";
$lang['userdeletewarning'] = "are j00 SUR3 j00 w4n+ tO Del3+3 +h3 SELEc+eD us3R 4ccOunT? oNcE tH3 4cC0UN+ ha\$ 83En D3L3teD i+ C@nN0T b3 r3TR13v3d 4ND w1lL 8e l0St phOr3VEr.";
$lang['usersuccessfullydeleted'] = "u5Er \$ucCESsPHullY DELE+Ed";
$lang['failedtodeleteuser'] = "f@1LED +o DElE+E useR";
$lang['forgottenpassworddesc'] = "iF +hIS us3r H4s phor90++EN +h3ir p45\$W0rD j00 C@n reSET 1+ f0R Th3m h3RE.";
$lang['manageusersexp'] = "tHIS L1st \$h0W5 @ \$EL3c+iOn 0f u\$3Rs WHO havE lo993D 0N +o youR F0RUm, s0RTED BY %s. T0 4LtER 4 US3r'\$ pERM1ss1oN\$ CLiCk +HE1r n4m3.";
$lang['userfilter'] = "us3r phiLtER";
$lang['onlineusers'] = "oNLIN3 u53Rs";
$lang['offlineusers'] = "oFPhL1n3 u\$ER5";
$lang['usersawaitingapproval'] = "u5er\$ @W41tinG @ppROv4l";
$lang['bannedusers'] = "baNn3d Us3rs";
$lang['lastlogon'] = "l4S+ l0Gon";
$lang['sessionreferer'] = "sE\$S10N R3pheR3r";
$lang['signupreferer'] = "s1GN-up rEPhErER:";
$lang['nouseraccountsmatchingfilter'] = "nO u53R 4ccoUNts M4+Ching pH1LtER";
$lang['searchforusernotinlist'] = "s34rCh pH0R 4 UsEr nO+ in l1ST";
$lang['adminaccesslog'] = "aDMIn 4cCEs5 lOg";
$lang['adminlogexp'] = "tHIs l1ST \$HOWs +Eh l@\$+ @CtiON\$ \$4NC+10NED BY U53R\$ Wi+H 4DM1n PriVIl3ge5.";
$lang['datetime'] = "d@TE/+iM3";
$lang['unknownuser'] = "uNknoWn us3R";
$lang['unknownuseraccount'] = "unKNowN U\$eR ACc0uNt";
$lang['unknownfolder'] = "uNkn0Wn F0LDER";
$lang['ip'] = "iP";
$lang['lastipaddress'] = "l4St 1p @dDREsS";
$lang['logged'] = "lOggED";
$lang['notlogged'] = "not LoGgEd";
$lang['addwordfilter'] = "aDD worD FiL+Er";
$lang['addnewwordfilter'] = "add n3W wOrD ph1LTeR";
$lang['wordfilterupdated'] = "w0RD PH1L+3r uPD@+3d";
$lang['filtername'] = "f1L+eR n4ME";
$lang['filtertype'] = "fIlt3R Typ3";
$lang['filterenabled'] = "f1LT3R 3nabl3D";
$lang['editwordfilter'] = "eD1t W0RD Phil+3R";
$lang['nowordfilterentriesfound'] = "n0 3XI\$t1ng worD phIlTER 3n+riEs F0unD. tO ADD @ F1LtEr CliCK +EH 'adD NEw' BUT+0n B3l0W.";
$lang['mustspecifyfiltername'] = "j00 MUst \$p3cifY @ F1Lt3R n@m3";
$lang['mustspecifymatchedtext'] = "j00 mu5T sPECIFY M4+CHED t3xT";
$lang['mustspecifyfilteroption'] = "j00 MUst \$p3cIphY @ FIL+3r 0PtiOn";
$lang['mustspecifyfilterid'] = "j00 MU\$T \$p3CiPhy 4 fIlTEr iD";
$lang['invalidfilterid'] = "inV4l1d phiL+ER 1D";
$lang['failedtoupdatewordfilter'] = "f4Il3d +o upD@t3 w0rD philtER. CH3CK +h@+ +3H F1lt3R S+1LL 3x1\$+s.";
$lang['allow'] = "alL0w";
$lang['block'] = "bl0Ck";
$lang['normalthreadsonly'] = "n0RM4l +hrE4ds 0NLy";
$lang['pollthreadsonly'] = "p0ll +hRe4ds onlY";
$lang['both'] = "b0TH tHR3@d +YPEs";
$lang['existingpermissions'] = "eXis+1N9 p3rMissi0N5";
$lang['nousershavebeengrantedpermission'] = "nO Ex15+1n9 useR\$ perMi5SI0ns F0UnD. t0 gr4N+ pErmis\$1on tO U\$ER5 53@rCh f0r tH3M b3loW.";
$lang['successfullyaddedpermissionsforselectedusers'] = "sUCC3SSFUllY 4dD3d p3RmI\$SI0Ns F0r \$3lECTEd US3rs";
$lang['successfullyremovedpermissionsfromselectedusers'] = "succ35\$FULLy r3mov3d pErMI\$SI0ns fr0M s3lECTED UseR\$";
$lang['failedtoaddpermissionsforuser'] = "f4IL3d +0 4DD p3rm15S1ONS Phor U\$er '%s'";
$lang['failedtoremovepermissionsfromuser'] = "f41leD +o rEm0v3 p3rmIssI0nS froM Us3R '%s'";
$lang['searchforuser'] = "s3@rCh Phor U5ER";
$lang['browsernegotiation'] = "br0w\$3r ne90+i@+3d";
$lang['largetextfield'] = "l@R93 tExt F13lD";
$lang['mediumtextfield'] = "m3dIUM +3xt F13lD";
$lang['smalltextfield'] = "smaLL +3x+ Fi3ld";
$lang['multilinetextfield'] = "mULT1-L1ne tEX+ pH13lD";
$lang['radiobuttons'] = "r4dio bU++0n5";
$lang['dropdownlist'] = "dr0P DoWn l1S+";
$lang['clickablehyperlink'] = "cl1ckA8lE hyPerL1NK";
$lang['threadcount'] = "tHre4D C0UNt";
$lang['clicktoeditfolder'] = "cL1Ck t0 edi+ F0LD3r";
$lang['fieldtypeexample1'] = "t0 Cr34TE R4di0 8U+t0n\$ 0r a dR0P DOwn lIs+ j00 n33D to eNtER EACH 1nd1V1du4L V@lUE 0N A \$Ep@r@+3 L1NE iN th3 0p+10ns Ph1ELD.";
$lang['fieldtypeexample2'] = "t0 Cr3ATe CL1CKA8l3 L1nKs 3nter TH3 UrL 1n +h3 0PT10ns fi3LD 4nD U\$3 <i>[propHiL3En+rY]</i> Wh3R3 TH3 en+rY from +3h usER's pr0PH1l3 sH0UlD 4PpE4r. 3x4mples: <p>mY\$p@CE: <i>h+Tp://www.mY\$p4CE.C0m/[pR0fIl3EN+Ry]</i><br />x8ox l1v3: <i>htTP://pR0phil3.my9@mErc4RD.net/[proF1l3ENTry]</i>";
$lang['editedwordfilter'] = "eDi+3D woRD Ph1ltEr";
$lang['editedforumsettings'] = "eDi+3D pH0RUM sET+1NGs";
$lang['successfullyendedusersessionsforselectedusers'] = "succE5\$PHuLLy 3NDEd \$3ssi0Ns phOr s3lEC+3D Us3Rs";
$lang['failedtoendsessionforuser'] = "f41l3d tO END \$3ssi0N f0r UsER %s";
$lang['successfullyapprovedselectedusers'] = "sUCce\$SFULLy 4PprOvED \$3leCTED Us3Rs";
$lang['matchedtext'] = "maTCHED TEXt";
$lang['replacementtext'] = "rEPl4CEMEN+ +3x+";
$lang['preg'] = "prEG";
$lang['wholeword'] = "wH0L3 w0rD";
$lang['word_filter_help_1'] = "<b>aLL</b> M@TCHE5 @g41n\$+ +h3 wH0le +3XT s0 fil+3ring mom +o mum WIlL @Ls0 CH4N9E m0meN+ +O muM3NT.";
$lang['word_filter_help_2'] = "<b>wh0l3 w0RD</b> MAtCH3S @g@in\$+ Whol3 WOrDs OnLy \$O PhiLtERiNg mom +o MUm will NoT CH@ng3 M0ment +0 mUm3N+.";
$lang['word_filter_help_3'] = "<b>prEG</b> 4ll0W5 J00 to U\$e pErL R39Ular 3XPr3SS10n5 To m4+CH TExt.";
$lang['nameanddesc'] = "nAM3 @ND D35CRiP+IoN";
$lang['movethreads'] = "m0V3 +hR3AD\$";
$lang['movethreadstofolder'] = "mOV3 +hr3ADS +0 f0ldER";
$lang['failedtomovethreads'] = "f4iLED +0 MOVE +Hr34ds +0 spEC1ph13d F0lD3R";
$lang['resetuserpermissions'] = "reS3t U\$3r p3rm1\$\$1On\$";
$lang['failedtoresetuserpermissions'] = "f4IL3D +0 RE\$E+ UsEr peRmIs5i0Ns";
$lang['allowfoldertocontain'] = "aLL0W F0LdER +O C0nta1n";
$lang['addnewfolder'] = "aDd n3W foLD3r";
$lang['mustenterfoldername'] = "j00 musT eNTEr 4 PHOlDER NaME";
$lang['nofolderidspecified'] = "n0 pHOLDER iD sp3c1PHi3d";
$lang['invalidfolderid'] = "iNv4l1d pHoLDEr iD. CHECK tHAt 4 FoLDER wITh +His ID 3X1\$+s!";
$lang['successfullyaddednewfolder'] = "sUcC3s\$fully 4DDeD n3W fOldER";
$lang['successfullyremovedselectedfolders'] = "sUcc3\$sfUlLy REm0V3D \$electEd F0ldER\$";
$lang['successfullyeditedfolder'] = "succesSfUllY 3D1+3D F0LD3r";
$lang['failedtocreatenewfolder'] = "fa1l3D t0 CRea+E N3W F0LDER";
$lang['failedtodeletefolder'] = "f4Il3d +0 dEl3+3 folDeR.";
$lang['failedtoupdatefolder'] = "fa1l3D +0 UPDAtE PhOldER";
$lang['cannotdeletefolderwiththreads'] = "c@nn0T DEl3t3 pH0ld3r5 +h4T sT1Ll COnT4in Thre4Ds.";
$lang['forumisnotrestricted'] = "f0RUM I\$ N0t r3Str1CtED";
$lang['groups'] = "gROUp5";
$lang['nousergroups'] = "nO Us3R Gr0up\$ h4VE 83eN 5Et Up. To 4dd 4 9r0UP cl1ck tH3 '4dD nEW' BUT+on b3l0W.";
$lang['suppliedgidisnotausergroup'] = "sUPPLI3D G1d 1\$ no+ @ usER 9roUP";
$lang['manageusergroups'] = "mAn@ge UsER 9R0UP\$";
$lang['groupstatus'] = "gR0up \$ta+US";
$lang['addusergroup'] = "aDd usEr 9ROUp";
$lang['addemptygroup'] = "add Emp+y groUp";
$lang['adduserstogroup'] = "add users to 9rOup";
$lang['addremoveusers'] = "aDD/rEMovE U\$ER\$";
$lang['nousersingroup'] = "ther3 arE nO Us3rS In TH1\$ 9r0uP. 4dd U\$ers +0 +HiS 9r0UP BY \$34rching PhOr +hEm BelOW.";
$lang['groupaddedaddnewuser'] = "sUcc35\$FULlY 4dd3d gr0Up. 4DD User\$ +0 th1S 9r0UP bY 534rchINg PH0R +h3m 8EL0w.";
$lang['nousersingroupaddusers'] = "tHeRE @r3 no u\$3rs IN +h1\$ gr0up. +0 4dd U\$eRS Cl1ck ThE '@dD/R3M0ve UsER5' 8utton B3l0W.";
$lang['useringroups'] = "th1S usEr 1S 4 MEM8er opH thE fOlL0w1ng GroUp\$";
$lang['usernotinanygroups'] = "thI\$ USER 1S No+ IN 4ny us3R 9r0Up\$";
$lang['usergroupwarning'] = "n0TE: +His UsER M4Y BE InHerI+iNG @Dd1+i0NaL pERm155i0Ns pHrOm 4NY Us3r 9R0UPs lIs+3D B3l0w.";
$lang['successfullyaddedgroup'] = "sUCC3\$SPHuLLy @DD3d Gr0Up";
$lang['successfullyeditedgroup'] = "sucCessfUllY 3DItED GrouP";
$lang['successfullydeletedselectedgroups'] = "succE\$sfullY D3l3tED sel3c+3D GRoup\$";
$lang['failedtodeletegroupname'] = "fA1LED tO DelE+e 9R0Up %s";
$lang['usercanaccessforumtools'] = "u5ER C@N @cCE\$S pH0RUm T00ls aND Can cre4te, DEL3TE 4nD 3dI+ f0RUM5";
$lang['usercanmodallfoldersonallforums'] = "uS3r c4N m0d3rA+E <b>alL FOldER\$</b> 0N <b>aLl f0RUMS</b>";
$lang['usercanmodlinkssectiononallforums'] = "u5Er C4N MoDER@+3 lINk\$ \$ECT10N 0n <b>aLL Ph0rum5</b>";
$lang['emailconfirmationrequired'] = "eM4il C0NPh1RM@+10n rEQU1R3d";
$lang['userisbannedfromallforums'] = "uS3r 1\$ B@NNED From <b>alL PhoRUMs</b>";
$lang['cancelemailconfirmation'] = "c@nCel em@IL C0nf1Rm@t10N And 4LLow U\$er t0 stAr+ po5+ING";
$lang['resendconfirmationemail'] = "re\$END C0nph1rm@+i0n 3mA1L T0 Us3r";
$lang['donothing'] = "d0 n0+hING";
$lang['usercanaccessadmintools'] = "u5eR h4S @cC3ss +o pHoRUm 4dm1N +0oLS";
$lang['usercanaccessadmintoolsonallforums'] = "uS3r h4\$ aCCE\$s +0 4DM1N +o0Ls <b>oN @lL PH0RUms</b>";
$lang['usercanmoderateallfolders'] = "u\$3r caN m0DEr@+3 4LL phoLDErs";
$lang['usercanmoderatelinkssection'] = "u5er C@N mod3r@+3 link5 \$3C+i0n";
$lang['userisbanned'] = "uSer 1\$ 8AnneD";
$lang['useriswormed'] = "u\$ER i5 woRmED";
$lang['userispilloried'] = "u53R 1S piLloR13d";
$lang['usercanignoreadmin'] = "u\$3r c4n 19n0rE @Dmini5+r4TorS";
$lang['groupcanaccessadmintools'] = "grOuP C4n @cC3S\$ 4Dm1n ToOl5";
$lang['groupcanmoderateallfolders'] = "gR0up C4N m0d3R4+3 AlL f0LDER\$";
$lang['groupcanmoderatelinkssection'] = "gR0Up C@N M0d3R4+3 l1NK\$ \$eC+1ON\$";
$lang['groupisbanned'] = "grOUP 1s 8annED";
$lang['groupiswormed'] = "gRoUp iS wORmEd";
$lang['readposts'] = "r34D p05tS";
$lang['replytothreads'] = "rEPly +o +Hr34Ds";
$lang['createnewthreads'] = "cr34+E nEw +hR3@dS";
$lang['editposts'] = "eDIT Po\$t\$";
$lang['deleteposts'] = "deLE+E pO5+s";
$lang['postssuccessfullydeleted'] = "p0s+S \$UCcesSphuLLy D3le+eD";
$lang['failedtodeleteusersposts'] = "f4Il3d +o D3LE+e us3R's p0S+S";
$lang['uploadattachments'] = "uPLO@D 4t+aChmENt\$";
$lang['moderatefolder'] = "moDer@+E pHOld3r";
$lang['postinhtml'] = "p0S+ 1n H+mL";
$lang['postasignature'] = "p0St @ sI9n@+uRE";
$lang['editforumlinks'] = "eDi+ ph0rUm L1nk\$";
$lang['linksaddedhereappearindropdown'] = "l1NkS @DDeD H3r3 4ppe4r in 4 droP d0Wn 1N T3H TOp rI9H+ 0F +He Phr4M3 53+.";
$lang['linksaddedhereappearindropdownaddnew'] = "l1Nks aDded h3RE @pP3@r 1n @ dR0p DOWn In thE tOP r19h+ of t3H pHR4m3 se+. +0 Add 4 LinK cL1Ck +H3 '@dD N3W' 8utTon B3l0w.";
$lang['failedtoremoveforumlink'] = "f41led To REMOve pHOrum L1nK '%s'";
$lang['failedtoaddnewforumlink'] = "f4il3D +O 4dd new PH0ruM l1Nk '%s'";
$lang['failedtoupdateforumlink'] = "f4iLED tO uPD@+3 phOrUM L1Nk '%s'";
$lang['notoplevellinktitlespecified'] = "nO +0p L3Vel Link t1tLE spEc1PhI3d";
$lang['youmustenteralinktitle'] = "j00 MU\$T 3nT3r 4 l1Nk t1tl3";
$lang['alllinkurismuststartwithaschema'] = "aLl l1nK Ur1S mU5T 5+4Rt w1+h A \$cH3M4 (I.3. H++p://, F+p://, iRC://)";
$lang['editlink'] = "ediT LinK";
$lang['addnewforumlink'] = "add nEw f0RuM l1nk";
$lang['forumlinktitle'] = "fORUM LiNk +1+l3";
$lang['forumlinklocation'] = "f0RUM l1nk loC4T10N";
$lang['successfullyaddednewforumlink'] = "sucC3SsFUlLY AdD3d n3w F0RUM l1nk";
$lang['successfullyeditedforumlink'] = "sUCCe\$SFUlLy EDITeD FoRUM L1nk";
$lang['invalidlinkidorlinknotfound'] = "iNvalid L1nk iD Or L1NK n0+ phoUnD";
$lang['successfullyremovedselectedforumlinks'] = "sUcCE5\$fully rEMOvED sELECTED LinK\$";
$lang['toplinkcaption'] = "tOp liNK CAPTi0n";
$lang['allowguestaccess'] = "aLLow 9u3St @Cce\$\$";
$lang['searchenginespidering'] = "sE@RCh 3NGin3 spIDER1N9";
$lang['allowsearchenginespidering'] = "all0w \$3aRCH eN9IN3 spiDERInG";
$lang['newuserregistrations'] = "nEW usER RE9I5+r4+10n\$";
$lang['preventduplicateemailaddresses'] = "pR3V3Nt DUPLiC@+e 3M4il 4DDR3ss3S";
$lang['allownewuserregistrations'] = "aLlow New U5Er r3915+r4t10N\$";
$lang['requireemailconfirmation'] = "requ1RE 3m4Il CONphIrM4+i0n";
$lang['usetextcaptcha'] = "u53 texT-CApTcHa";
$lang['textcaptchadir'] = "tEx+-C4P+CHa DIREC+0ry";
$lang['textcaptchakey'] = "teXT-C@PTCH@ K3Y";
$lang['textcaptchafonterror'] = "t3xt-c@pTCH4 H45 B3en DiS48lED @uToM4+iC@Lly b3C4UsE +h3r3 aR3 N0 +RU3 +yPE f0nts 4v4il4blE pHOR 1T +0 u53. PLE4\$E UPlO@D S0M3 +RUE +Yp3 pHoN+s To <b>%s</b> on Y0Ur \$erV3R.";
$lang['textcaptchadirerror'] = "t3xt-C@P+Ch4 h4S B33N D1\$48l3D bEC4usE +3h t3xt_C4p+cH4 D1R3C+0ry 4ND 1+'\$ \$ub-D1reC+0ri3\$ Ar3 nOt wR1+48lE 8y +EH w38 SErV3r / phP pR0C3s\$.";
$lang['textcaptchagderror'] = "tEXt-C4ptCH@ Has 8EEN D1\$@8LED BEc@U53 YoUR \$3rvEr's pHP sE+UP d0e5 nOt pR0ViD3 suPp0rt F0R GD 1m49E m4niPUL4TiOn AND / 0R T+F F0n+ \$uppoRt. BO+h @RE R3qu1r3D F0R +EX+-cAp+CHA 5upp0r+.";
$lang['textcaptchadirblank'] = "t3X+-C4PTCH@ D1r3CTORY 1\$ bl4NK!";
$lang['newuserpreferences'] = "n3w us3r PR3PhER3Nc3s";
$lang['sendemailnotificationonreply'] = "em4il n0+ific4+i0n oN REpLy t0 u\$er";
$lang['sendemailnotificationonpm'] = "em4il no+ifIC4+i0N On PM To UsEr";
$lang['showpopuponnewpm'] = "sHow p0puP WH3N rECEIV1ng n3w Pm";
$lang['setautomatichighinterestonpost'] = "sE+ @Utom4+ic h19H in+3RE\$+ 0n P0st";
$lang['postingstats'] = "pos+1Ng 5+4ts";
$lang['postingstatsforperiod'] = "p0St1NG 5+@TS pHoR p3r10d %s +O %s";
$lang['nopostdatarecordedforthisperiod'] = "n0 p0S+ D4t4 REcOrDEd f0R +his pERiOD.";
$lang['totalposts'] = "t0+@l P05+s";
$lang['totalpostsforthisperiod'] = "t0t4L po5+S ph0r +hI\$ P3r10d";
$lang['mustchooseastartday'] = "mu5t Choo\$3 4 sT4rt d4Y";
$lang['mustchooseastartmonth'] = "mUST CHoO\$3 4 S+4Rt m0n+h";
$lang['mustchooseastartyear'] = "mU\$T ch00\$E @ st4R+ yE@r";
$lang['mustchooseaendday'] = "muST Ch00se @ END D4Y";
$lang['mustchooseaendmonth'] = "mU5+ ch00SE a END Mon+h";
$lang['mustchooseaendyear'] = "mUSt Cho0sE 4 3nD y34r";
$lang['startperiodisaheadofendperiod'] = "s+4r+ pER1OD I\$ @He4d oPh EnD pERIoD";
$lang['bancontrols'] = "b4N CoNtR0Ls";
$lang['addban'] = "adD 8@n";
$lang['checkban'] = "ch3Ck BaN";
$lang['editban'] = "eDit 8aN";
$lang['bantype'] = "b4N tyPE";
$lang['bandata'] = "b@n Da+4";
$lang['bancomment'] = "c0mm3nt";
$lang['ipban'] = "ip 84n";
$lang['logonban'] = "lO90N B4n";
$lang['nicknameban'] = "niCKN4me 8@n";
$lang['emailban'] = "eM4IL 8@N";
$lang['refererban'] = "rEf3rEr B4n";
$lang['invalidbanid'] = "iNv@L1D 8an ID";
$lang['affectsessionwarnadd'] = "tH1\$ 84N m4Y @fph3c+ +H3 f0ll0wiN9 @C+iV3 u5er sEss10ns";
$lang['noaffectsessionwarn'] = "tHI5 8an 4PhphECts no 4CT1v3 sE\$SI0ns";
$lang['mustspecifybantype'] = "j00 mUst sp3cifY @ B4n typ3";
$lang['mustspecifybandata'] = "j00 must sp3c1phy \$0me 84n d4+@";
$lang['successfullyremovedselectedbans'] = "sucC3ssFuLlY Rem0Ved \$el3CTED 84N5";
$lang['failedtoaddnewban'] = "f@1l3D t0 4dD New 84N";
$lang['failedtoremovebans'] = "fa1LEd +O r3moVE \$0m3 0R 4ll OF TEh sEl3c+Ed 8@n\$";
$lang['duplicatebandataentered'] = "dUpl1C@t3 8an D4t@ eN+3r3D. pLE@s3 CHeCK yOUr W1lDC4rD\$ +0 s33 iF Th3y 4LrE4dy m4+Ch +He D4+4 3nterEd";
$lang['successfullyaddedban'] = "sucCES5FuLly 4DD3d B@n";
$lang['successfullyupdatedban'] = "sUCC3ssfuLly uPDATED 84n";
$lang['noexistingbandata'] = "theR3 Is n0 Ex1\$+1ng 8@N DA+4. to 4DD 4 84n clICK tHE 'adD n3W' BU++0n 83Low.";
$lang['youcanusethepercentwildcard'] = "j00 Can usE tH3 p3RCENT (%) w1lDC4rD \$ymBOl iN @ny 0ph Y0ur B4N l1\$ts +0 0BTa1n P4Rt14l M@+cH35, i.3. '192.168.0.%' w0uLD B4n 4ll Ip @DDRE\$sE\$ IN ThE ran93 192.168.0.1 +HR0u9H 192.168.0.254";
$lang['cannotusewildcardonown'] = "j00 C4nn0t @DD % 4s A wildC4RD M4+CH on 1+'\$ 0wn!";
$lang['requirepostapproval'] = "rEqu1R3 pos+ @ppRoV@L";
$lang['adminforumtoolsusercounterror'] = "ther3 mU5t 8E @t lE4ST 1 u53R Wi+H @DM1N +00ls aND Ph0rum +00ls 4CCESs oN All pHorUm\$!";
$lang['postcount'] = "p0st coUNt";
$lang['resetpostcount'] = "r3\$E+ p0ST coUN+";
$lang['failedtoresetuserpostcount'] = "f@1l3D +0 rEs3+ P05t C0unt";
$lang['failedtochangeuserpostcount'] = "f@1leD +0 CH@n9e u\$3r pOsT coUnT";
$lang['postapprovalqueue'] = "p0St 4Ppr0v4l QUEU3";
$lang['nopostsawaitingapproval'] = "no pos+s 4re @W@I+ing 4pProvaL";
$lang['approveselected'] = "approvE \$3lECt3d";
$lang['failedtoapproveuser'] = "f@1lEd +o @PpRoV3 u\$Er %s";
$lang['kickselected'] = "k1CK 5EL3cteD";
$lang['visitorlog'] = "vis1+0R Log";
$lang['clearvisitorlog'] = "cL34r VI\$I+0r LOG";
$lang['novisitorslogged'] = "no v1\$IT0rs lO993D";
$lang['addselectedusers'] = "adD \$3lEC+3D UsERs";
$lang['removeselectedusers'] = "reMOvE sEl3CtED user5";
$lang['addnew'] = "add NEW";
$lang['deleteselected'] = "d3Le+e sel3c+3D";
$lang['forumrulesmessage'] = "<p><b>f0RUm ruLEs</b></p><p>\nRe9Is+r4+10N To %1\$S 15 PHrEE! w3 DO 1Nsi\$t +h4t j00 a8ID3 8y +3H RUlEs @nD p0LiC1e\$ d3t4Il3D BelOw. 1Ph j00 @Gr33 to TEH +3RmS, pL34\$e chECK +He 'I a9rE3' CH3ck8ox And Pr3ss +h3 'R3gis+3r' bu+ToN 83l0w. if j00 woULD l1k3 to C@nC3l +h3 R39istR4tiON, Cl1Ck %2\$\$ +0 returN +o +eh ph0rUms inD3x.</p><p>\n@l+h0U9H teh @Dmin1\$+R4+or\$ @nD m0DEr@+Or\$ 0F %1\$S wiLl aT+3mp+ t0 k3Ep 4LL objECTionablE m3Ss49es 0phpH thI\$ F0RUm, it 1\$ Imp0\$\$1ble f0r us +0 rEv13W 4LL m3s\$@Ges. @lL Mes549es 3xprEss t3h v13wS Of t3h author, @nD ne1TH3r tEh own3r5 0F %1\$5, n0R pr0j3C+ b3eHIVe forUm 4ND i+'s 4Ff1l14+Es w1ll bE h3LD rEsp0ns1bL3 for T3h C0N+en+ oph 4ny m3\$\$4ge.</p><p>\n8Y 49R3eing to +hesE rUl3\$, J00 w4rr4NT th@+ j00 W1ll no+ P0\$+ 4ny messa9Es th4T ar3 085C3nE, Vulgar, s3xu4Lly-0riENtatED, h4+Eful, thRE4tEninG, or o+HERWi\$3 V1ol4+1ve opH 4Ny law\$.</p><p>tHE 0wn3RS 0ph %1\$S r3serv3 ThE r1ght +0 r3MOVe, 3D1t, mOVE 0r cl0\$3 @nY +hre@D Ph0R @ny re4\$0n.</p>";
$lang['cancellinktext'] = "h3r3";
$lang['failedtoupdateforumsettings'] = "f4Il3d +o UPD4+3 F0RUm \$e++1n9s. plE4SE +ry 4941n L4+3R.";
$lang['moreadminoptions'] = "m0RE 4dm1N op+IOn\$";

// Admin Log data (admin_viewlog.php) --------------------------------------------

$lang['changedstatusforuser'] = "cH@n93d us3r \$t4tUs F0r '%s'";
$lang['changedpasswordforuser'] = "ch@NgED pAssw0rd Ph0r '%s'";
$lang['changedforumaccess'] = "ch4n93D f0rUm acCe\$5 p3rmissions f0r '%s'";
$lang['deletedallusersposts'] = "dElE+3d 4ll po\$+s f0r '%s'";

$lang['createdusergroup'] = "cr34+3D user 9RoUp '%s'";
$lang['deletedusergroup'] = "d3l3T3d usER 9r0Up '%s'";
$lang['updatedusergroup'] = "uPd4+ED U5ER 9roUp '%s'";
$lang['addedusertogroup'] = "addED UsER '%s' TO 9rouP '%s'";
$lang['removeduserfromgroup'] = "rem0V3 Us3r '%s' phr0m 9r0uP '%s'";

$lang['addedipaddresstobanlist'] = "add3d ip '%s' to b4n lIs+";
$lang['removedipaddressfrombanlist'] = "remov3D 1P '%s' phRoM B4n liS+";

$lang['addedlogontobanlist'] = "aDdED Lo9On '%s' To 84N li\$+";
$lang['removedlogonfrombanlist'] = "reM0v3D Lo90n '%s' Fr0m 8@n lIS+";

$lang['addednicknametobanlist'] = "added NiCKn4m3 '%s' +0 8an l1ST";
$lang['removednicknamefrombanlist'] = "rEmoveD nICKn4me '%s' fr0m 8@N L1\$+";

$lang['addedemailtobanlist'] = "aDD3D Em4Il 4dDREs5 '%s' +o 8@n lIs+";
$lang['removedemailfrombanlist'] = "rEm0v3d 3m41L 4dDR3Ss '%s' fr0m B4n Li\$+";

$lang['addedreferertobanlist'] = "aDd3D r3fer3R '%s' To B4n L1\$+";
$lang['removedrefererfrombanlist'] = "rEm0veD REFER3R '%s' FROm B4n l15+";

$lang['editedfolder'] = "edi+ED pH0LD3r '%s'";
$lang['movedallthreadsfromto'] = "m0VeD @ll +HR3AD\$ phroM '%s' tO '%s'";
$lang['creatednewfolder'] = "creaTeD N3W f0lD3R '%s'";
$lang['deletedfolder'] = "del3tED F0LDER '%s'";

$lang['changedprofilesectiontitle'] = "ch4n9ed pR0PhIlE sECt1on +i+L3 froM '%s' to '%s'";
$lang['addednewprofilesection'] = "aDd3D NEw pRoPhIl3 seCt1ON '%s'";
$lang['deletedprofilesection'] = "d3l3+eD pr0F1L3 \$ect10n '%s'";

$lang['addednewprofileitem'] = "add3d n3w PropH1L3 i+EM '%s' +0 sECT1on '%s'";
$lang['changedprofileitem'] = "ch4ngED pr0ph1L3 1+3m '%s'";
$lang['deletedprofileitem'] = "del3+ED pr0PH1l3 1+3m '%s'";

$lang['editedstartpage'] = "edi+3D s+@r+ pA93";
$lang['savednewstyle'] = "s@v3D N3W sTyL3 '%s'";

$lang['movedthread'] = "m0VED +hr34D '%s' fr0M '%s' tO '%s'";
$lang['closedthread'] = "cL0seD +HrEaD '%s'";
$lang['openedthread'] = "oP3nED +hR34d '%s'";
$lang['renamedthread'] = "reN4m3D thrE4d '%s' T0 '%s'";

$lang['deletedthread'] = "d3lETED ThRE4d '%s'";
$lang['undeletedthread'] = "uND3leteD tHrE4d '%s'";

$lang['lockedthreadtitlefolder'] = "lOCk3D thR3Ad 0pti0n\$ 0n '%s'";
$lang['unlockedthreadtitlefolder'] = "uNlock3D +hr34D 0pt1Ons on '%s'";

$lang['deletedpostsfrominthread'] = "dEleteD P0s+5 PhrOm '%s' 1n +hR34d '%s'";
$lang['deletedattachmentfrompost'] = "dEl3t3d ATt4chmEN+ '%s' fRoM P05+ '%s'";

$lang['editedforumlinks'] = "ed1tED f0rum l1nKs";
$lang['editedforumlink'] = "eD1+eD pHoruM LInk: '%s'";

$lang['addedforumlink'] = "aDdeD pHORUm lInk: '%s'";
$lang['deletedforumlink'] = "dEL3TEd f0RUM l1NK: '%s'";
$lang['changedtoplinkcaption'] = "ch4ngeD top linK C4ption PhRom '%s' To '%s'";

$lang['deletedpost'] = "dEL3T3d Pos+ '%s'";
$lang['editedpost'] = "eDi+eD p0\$+ '%s'";

$lang['madethreadsticky'] = "m@d3 ThR34D '%s' st1Cky";
$lang['madethreadnonsticky'] = "m@d3 +hR34D '%s' N0N-5+IckY";

$lang['endedsessionforuser'] = "enD3D \$3SsION pHOR u\$er '%s'";

$lang['approvedpost'] = "aPPR0VED po\$+ '%s'";

$lang['editedwordfilter'] = "eDitED w0RD F1lt3R";

$lang['addedrssfeed'] = "aDd3d R\$\$ FE3D '%s'";
$lang['editedrssfeed'] = "edI+ED RsS phe3d '%s'";
$lang['deletedrssfeed'] = "d3l3t3D Rss PhEED '%s'";

$lang['updatedban'] = "uPD@+3d Ban '%s'. CH4ng3D +Yp3 from '%s' +0 '%s', CH4ngeD D4+@ phrOm '%s' +0 '%s'.";

$lang['splitthreadatpostintonewthread'] = "spli+ +hR34d '%s' @+ p05+ %s  1n+0 n3W ThrE4d '%s'";
$lang['mergedthreadintonewthread'] = "mERg3D THr3ads '%s' anD '%s' 1NT0 n3W +hREAD '%s'";

$lang['approveduser'] = "apPrOvEd uSEr '%s'";

$lang['forumautoupdatestats'] = "fOrum au+0 UpD4+3: \$T@Ts upD@tED";
$lang['forumautoprunepm'] = "f0RUM 4uto UpD4+3: PM pHOldER5 pRun3d";
$lang['forumautoprunesessions'] = "foRUm 4UtO UPD@T3: sESsi0ns prUn3D";
$lang['forumautocleanthreadunread'] = "f0RUM 4U+O UpD4te: thRE4D UnREAD d@+@ CL34n3d";
$lang['forumautocleancaptcha'] = "f0rum @U+0 UpD4+3: +3Xt-c@ptCH4 im4G3\$ Cle4n3D";

$lang['adminlogempty'] = "adMIN lO9 IS 3mpTy";

$lang['youmustspecifyanactiontypetoremove'] = "j00 must \$p3CIpHy 4N AC+IoN TYp3 +o R3MovE";

$lang['removeentriesrelatingtoaction'] = "r3move 3N+r13s r3L4+In9 to 4ct1oN";
$lang['removeentriesolderthandays'] = "rEMove En+RI3S 0lDER Th4n (D@Y5)";

$lang['successfullyprunedadminlog'] = "sUccE5\$FULLY PRUNED 4DMIN L0G";
$lang['failedtopruneadminlog'] = "f@1leD +o pRUn3 4dm1n lO9";

$lang['prune_log'] = "prun3 Lo9";

// Admin Forms (admin_forums.php) ------------------------------------------------

$lang['noexistingforums'] = "no 3xi\$T1ng PHorUms PhOUnD. +0 crE4T3 @ N3W F0ruM CLiCK the 'ADD n3w' 8ut+on 8el0w.";
$lang['webtaginvalidchars'] = "w38t49 C@N 0nlY c0nta1n UppErCAsE @-z, 0-9 anD UnD3rsC0re CH4r4C+3r\$";
$lang['databasenameinvalidchars'] = "daTA84se naME C4n onlY CONtA1N @-z, a-z, 0-9 @ND UNDErsC0RE CH@RACTER5";
$lang['invalidforumidorforumnotfound'] = "inV4LID F0RUM FiD Or fOrUM n0+ fouND";
$lang['successfullyupdatedforum'] = "succe\$SFuLlY upD4+ED pHorUM";
$lang['failedtoupdateforum'] = "fa1leD +0 UPD4+3 F0RUm: '%s'";
$lang['successfullycreatednewforum'] = "suCc3ssFUllY CR34t3D n3w PHorUM";
$lang['selectedwebtagisalreadyinuse'] = "tHE \$eL3C+3d wEBT4G I\$ alr3ADY 1n u53. Pl3@s3 ChoO\$3 4n0ThER.";
$lang['selecteddatabasecontainsconflictingtables'] = "teH \$el3C+3D D@+@bAs3 C0nt4IN\$ C0nfLiC+1ng +@8le\$. C0nphlic+inG +@8L3 n4mES 4rE:";
$lang['forumdeleteconfirmation'] = "aRE J00 5urE j00 wAN+ +o DELET3 @LL oPh +h3 s3leCtED F0rums?";
$lang['forumdeletewarning'] = "pLe4se No+3 tH@t J00 C4nnot R3C0v3r d3LETED F0ruM\$. oNC3 D3l3+ED @ PH0rum @ND @LL of 1t's 45\$0C1@tED D@+4 1S p3rm4NEN+LY r3movED FRoM TEH d4t4b@53. iPH J00 D0 no+ wi\$h +0 D3l3TE TEh sEl3cTED ph0RUMS pLE4\$3 cLiCK C@NC3L.";
$lang['successfullyremovedselectedforums'] = "sUcCe\$\$fullY DELE+3d \$el3ctED FOrUms";
$lang['failedtodeleteforum'] = "f4IlED +0 Del3TED PHoRUm: '%s'";
$lang['addforum'] = "add FOrUM";
$lang['editforum'] = "edIT F0RUM";
$lang['visitforum'] = "v1\$1t f0rum: %s";
$lang['accesslevel'] = "aCc3s5 l3vEl";
$lang['forumleader'] = "f0RUM LE4DER";
$lang['usedatabase'] = "uS3 D4+@B@\$3";
$lang['unknownmessagecount'] = "unKNoWn";
$lang['forumwebtag'] = "fORUM wE8ta9";
$lang['defaultforum'] = "d3Ph@UL+ phOrUm";
$lang['forumdatabasewarning'] = "pL3453 3N5ur3 J00 s3L3c+ +3h CORr3c+ D4+4B4\$3 wH3N CRE4+iNg a NEW pHoruM. OnCE CR3a+3D 4 neW F0rUm C4nno+ B3 m0Ved BETWE3n 4V41L4BLE D@+@8ase\$.";

// Admin Global User Permissions

$lang['globaluserpermissions'] = "gl08@L u\$3r p3rm1ss10Ns";

// Admin Forum Settings (admin_forum_settings.php) -------------------------------

$lang['mustsupplyforumwebtag'] = "j00 MUst suPplY 4 forum W38t4G";
$lang['mustsupplyforumname'] = "j00 mus+ 5uppLY 4 f0RUm n@M3";
$lang['mustsupplyforumemail'] = "j00 mus+ sUpPly 4 f0RUm 3m41l 4DDR3sS";
$lang['mustchoosedefaultstyle'] = "j00 mu5+ cHoOsE @ DEpH4ul+ pH0RUM 5+yle";
$lang['mustchoosedefaultemoticons'] = "j00 mU\$T CHO0Se D3f4UlT PHoRUm 3mot1COn5";
$lang['mustsupplyforumaccesslevel'] = "j00 mu\$+ \$UPPly 4 F0rum @CC3Ss LEvEL";
$lang['mustsupplyforumdatabasename'] = "j00 mUsT sUpplY @ FORUm D4t@84se n4mE";
$lang['unknownemoticonsname'] = "uNKNoWn Em0+1CoN\$ N@m3";
$lang['mustchoosedefaultlang'] = "j00 MU\$+ ch00se @ DEF4ul+ f0ruM L@N9U4G3";
$lang['activesessiongreaterthansession'] = "aCtivE \$es5I0N +1m3OUT c@nN0t 83 gre4+Er tHan sE\$S1on t1me0u+";
$lang['attachmentdirnotwritable'] = "at+4CHmEN+ d1r3ctoRY @Nd SySt3M +EMPoR@Ry diR3Ctory / PHp.1N1 'UPL0@D_TMP_D1r' mu5+ 83 wR1+@BL3 8Y tEH W38 s3RVER / php pRoCE\$\$!";
$lang['attachmentdirblank'] = "j00 mU\$+ \$uppLy 4 D1r3CToRY To 5@v3 4T+@CHMEN+s iN";
$lang['mainsettings'] = "m@1N s3t+1nGs";
$lang['forumname'] = "fOrum N@Me";
$lang['forumemail'] = "fOruM 3M4IL";
$lang['forumnoreplyemail'] = "n0-r3ply Em41l";
$lang['forumdesc'] = "fORUM D3sCrip+IOn";
$lang['forumkeywords'] = "f0rUm keYwOrDS";
$lang['defaultstyle'] = "d3PH4ul+ 5TyL3";
$lang['defaultemoticons'] = "deF4Ul+ EMoTicOns";
$lang['defaultlanguage'] = "d3f4uL+ L4NgU493";
$lang['forumaccesssettings'] = "f0Rum 4Cce\$S \$e++inG5";
$lang['forumaccessstatus'] = "f0rUM aCCes\$ \$+4tUs";
$lang['changepermissions'] = "chANG3 p3rMi5SI0Ns";
$lang['changepassword'] = "ch@NG3 p4ssworD";
$lang['passwordprotected'] = "p4\$\$w0rD Pr0t3CTED";
$lang['passwordprotectwarning'] = "j00 H4V3 N0+ \$3t 4 pHoruM P4ssW0RD. 1PH J00 DO n0+ 53+ 4 P@\$sw0rD tEH P4ssW0rd pr0teC+1On phuncT1ON4lity w1LL 8E @uTom@t1c4Lly D1\$4Bl3D!";
$lang['postoptions'] = "p0ST 0pt10n\$";
$lang['allowpostoptions'] = "alLow p0S+ EDi+ing";
$lang['postedittimeout'] = "poSt EDiT T1m3ouT";
$lang['posteditgraceperiod'] = "poST EDIt gRac3 p3R10D";
$lang['wikiintegration'] = "w1kiWIKI inTE9R@+I0N";
$lang['enablewikiintegration'] = "eN@8le wIkIWiKi iN+3Gr@+I0N";
$lang['enablewikiquicklinks'] = "eN4ble WikiWiKi qUiCK L1Nk\$";
$lang['wikiintegrationuri'] = "w1K1W1KI loc4t10n";
$lang['maximumpostlength'] = "m@xIMUM P0ST l3N9+H";
$lang['postfrequency'] = "pO5+ Phr3qu3NCY";
$lang['enablelinkssection'] = "enaBl3 LiNK\$ \$ect10n";
$lang['allowcreationofpolls'] = "allow CR34+10N oph p0lLs";
$lang['allowguestvotesinpolls'] = "alL0W GUe\$+s +0 voTE 1n P0ll\$";
$lang['unreadmessagescutoff'] = "uNre4D mESs493s cUt-0PhPH";
$lang['unreadcutoffseconds'] = "sEconDs";
$lang['disableunreadmessages'] = "dIS4BLE UnREAD m3Ss4G3S";
$lang['nocutoffdefault'] = "no CU+-0PhPh (DEF4ult)";
$lang['1month'] = "1 m0n+H";
$lang['6months'] = "6 mon+h\$";
$lang['1year'] = "1 Y34r";
$lang['customsetbelow'] = "cu5t0M v4lUE (\$E+ B3low)";
$lang['searchoptions'] = "sE@rCH 0pT10ns";
$lang['searchfrequency'] = "s3ArCH PhreQUENCY";
$lang['sessions'] = "s3ssI0ns";
$lang['sessioncutoffseconds'] = "se\$si0n CUT 0pHPH (s3C0ND\$)";
$lang['activesessioncutoffseconds'] = "acTiVE \$3ss1on CU+ oFPh (sEConDs)";
$lang['stats'] = "sT4+\$";
$lang['hide_stats'] = "h1DE 5+4+\$";
$lang['show_stats'] = "sH0w st4+s";
$lang['enablestatsdisplay'] = "en4BlE 5+@ts D1SPL4Y";
$lang['personalmessages'] = "p3R\$on@l m3Ss@g3s";
$lang['enablepersonalmessages'] = "enABl3 PER50n4l m3\$5493S";
$lang['pmusermessages'] = "pM mEssag3S p3R us3R";
$lang['allowpmstohaveattachments'] = "aLl0W peRS0nAl MEs\$A93s t0 havE 4TT@CHMEnTs";
$lang['autopruneuserspmfoldersevery'] = "auT0 pruN3 U5Er's Pm phOlDer\$ 3v3RY";
$lang['userandguestoptions'] = "u5er anD gU3st 0Pt10n5";
$lang['enableguestaccount'] = "eN48le GU3st 4CCoUnT";
$lang['listguestsinvisitorlog'] = "l1St 9u3sts 1n V1SIT0r L09";
$lang['allowguestaccess'] = "alLoW GU3sT 4Cce\$S";
$lang['userandguestaccesssettings'] = "u\$er @nD 9U3s+ aCces5 \$ett1ng5";
$lang['allowuserstochangeusername'] = "all0w U\$ers +o CHaNgE UsErN@ME";
$lang['requireuserapproval'] = "rEquirE UsEr 4PpR0V4L bY @DMiN";
$lang['requireforumrulesagreement'] = "r3Qu1r3 u\$3r +0 4GrEE +0 foRUm rUlE\$";
$lang['enableattachments'] = "enabl3 4t+@chm3N+\$";
$lang['attachmentdir'] = "a++@ChM3Nt DIR";
$lang['userattachmentspace'] = "att4Chm3nt sP4CE pEr uSEr";
$lang['allowembeddingofattachments'] = "aLL0w eM8EdD1NG 0f @++4CHM3NT\$";
$lang['usealtattachmentmethod'] = "us3 @l+3rn4t1VE ATtaChmEnt mE+H0d";
$lang['allowgueststoaccessattachments'] = "aLL0w 9UEs+s +0 4cce5\$ 4+t4chmEn+\$";
$lang['forumsettingsupdated'] = "f0RUM 53tt1N9s SUcCEsSFulLy UPDA+Ed";
$lang['forumstatusmessages'] = "foRUM s+a+Us MEss493s";
$lang['forumclosedmessage'] = "f0rum clO\$eD ME5s493";
$lang['forumrestrictedmessage'] = "fOrum REsTrICT3D M3s\$493";
$lang['forumpasswordprotectedmessage'] = "fORUM p4s\$worD PRo+3C+3d m3sS493";

// Admin Forum Settings Help Text (admin_forum_settings.php) ------------------------------

$lang['forum_settings_help_10'] = "<b>p0\$t EdI+ +1M30UT</b> I\$ +Eh +1M3 1n M1NU+3S apH+Er pO5+iNg th@+ A U53R c4n 3di+ +he1r pO5+. IPH \$3+ +0 0 +heR3 i5 n0 liM1+.";
$lang['forum_settings_help_11'] = "<b>m@ximUm p05+ l3Ng+h</b> 1s +he M@xiMUm nUm83r Of Ch@R@CteR\$ +h@T wIll 8e DI5pl4YED 1n 4 P0st. IPh 4 po\$+ 1S lon93R +h@N +hE NUmb3r 0Ph CH@R@Ct3rS D3fin3d hER3 i+ WiLl 83 CU+ sh0R+ @ND @ L1NK @DDED +0 tH3 BO++0m t0 4LL0W UsEr5 +0 R34D +3H wHol3 po\$+ 0N a \$ep4R4+3 P49E.";
$lang['forum_settings_help_12'] = "if J00 DoN'+ w4N+ yoUR UsER5 tO 83 4bL3 +0 CrE4t3 PolLs j00 CAN dI5@8le +3h 4B0v3 oP+iOn.";
$lang['forum_settings_help_13'] = "teh linKS \$eCT10n opH beeHiV3 pRov1d3s 4 pl@Ce F0R yOuR UsEr\$ +0 m4IN+41n @ L15+ 0Ph s1+3S +heY phrEQU3NTLy vI\$i+ +h4t 0Th3r u\$ers m@Y pH1nd u\$3pHUL. Link5 c4n BE diVIDEd 1ntO C@+390RIes BY PhOlDer @ND @lL0W PHoR coMm3n+5 4ND r@+InG5 +0 83 gIv3N. In OrD3R +0 MoDer4+3 +eh lInks 5ECtion 4 Us3r mu\$+ 83 r@N+3d 9lo8al m0dER@t0R st@+U\$.";
$lang['forum_settings_help_15'] = "<b>se\$\$IOn CU+ 0fph</b> Is +3H m4XImUm t1ME B3f0rE @ U\$3r's se\$SI0N 1\$ D3em3D D3@d 4nD thEY @rE Log93d out. 8y D3f4uLt +Hi\$ is 24 HoUR\$ (86400 sECONds).";
$lang['forum_settings_help_16'] = "<b>ac+1vE sEs510N CUT 0phpH</b> 1S +3h M4ximum +1ME 8ef0RE 4 U\$er'\$ \$3ss1on I\$ D3eMED 1N4c+IVE @+ wHICh poIn+ th3y 3n+ER 4n iDLE \$+4t3. 1n thiS \$T4tE t3H UsEr rEM@1nS lo9g3D 1N, 8U+ +heY ArE removeD PhRom th3 Ac+iVE usErS Li5+ in TEH sT@Ts di5Pl@y. OnCe +h3Y 83C0M3 4C+1v3 4941N theY wiLL 83 r3-4DD3d T0 +h3 LIst. by DEf4Ul+ +H1s 53t+ING 1\$ S3t TO 15 M1NU+3s (900 s3Cond\$).";
$lang['forum_settings_help_17'] = "en4Bl1n9 Th1\$ 0pTIon AlLOw5 Be3h1V3 t0 1NClUDE @ \$+4tS dI5pl4Y 4+ the 8Ot+0m 0ph thE m3sS4ges P4n3 S1M1l4r +0 thE on3 USEd by m4NY PHoRuM sopH+w@R3 tI+l3s. onCE 3NaBl3d +3h di5PL@y 0PH thE \$t@ts p4g3 C@N B3 +oggL3D iND1v1Du4LlY BY E@CH U\$3r. 1Ph +h3y DoN't W4nt +0 53e iT +hEy C@N h1d3 1t PHrom vI3w.";
$lang['forum_settings_help_18'] = "p3R\$0n@l Mess@G3s @R3 Inv4lu@BL3 4s 4 w4Y 0ph t4KIn9 morE Pr1v@Te M4ttEr5 0ut 0f vI3w 0PH teH o+h3r M3M8er5. howEV3R 1PH J00 D0n'+ w4n+ Your US3Rs To BE @8l3 +0 sEND E4ch O+H3R pERs0N4L m3sS493s J00 C4n DI5@8LE Th15 0P+I0n.";
$lang['forum_settings_help_19'] = "p3r\$0n@l m3SS49E5 C4n 4L\$0 CoN+41N a+T4CHMEN+\$ wHiCh C@N Be UsEFUL F0r ExCH4N91n9 PHiLEs 83+w33n u\$3rs.";
$lang['forum_settings_help_20'] = "<b>note:</b> T3H spacE @LLoc@+10N FoR Pm 4t+@chMEntS I5 +@K3N fR0m E4ch usERS' m4iN ATtACHmENT 4Ll0c@+i0N 4nd 1\$ NOt iN 4Ddi+ion tO.";
$lang['forum_settings_help_21'] = "<b>en4ble 9u3S+ acC0uNt</b> 4llow\$ v1s1+ors +0 BR0WSE yoUr F0RUm AnD r34D P0\$+5 wI+H0U+ r3g15+3RinG @ Us3r @CC0un+. 4 u\$ER 4Cc0unt 1\$ 5+IlL R3qU1r3d 1F +H3Y W1SH +0 po\$+ or CH4ngE u5er pREPhEr3nc3S.";
$lang['forum_settings_help_22'] = "<b>li5+ gUEs+s In vI5I+0r lO9</b> 4ll0w\$ j00 +o \$P3ciphY WhE+hER oR No+ UnrE91stER3d U53r\$ @R3 l1\$TeD on TEH viS1+0r lO9 @lONg \$IDe reg1\$+3RED user\$.";
$lang['forum_settings_help_23'] = "beEH1VE @lL0w\$ 4tt4CHmeN+s +0 B3 UplO4D3D +O m35s@ge\$ WH3n P0StEd. 1F j00 HAvE LiMI+3d w38 sP@cE J00 m4y WHICH t0 d1\$48l3 4+t4chmEn+\$ 8y CL34r1N9 Teh 8ox 48ov3.";
$lang['forum_settings_help_24'] = "<b>at+4chMEnT Dir</b> is TH3 loC4+I0N 8e3hIvE SHoUld sT0RE I+'5 aTtaCHmENT5 1N. Th1s D1reC+0ry mUS+ 3X1\$+ ON y0ur W38 sp@ce @Nd mu5+ 8e wri+@BLE 8y th3 WEb s3rv3r / PhP pR0C3ss 0+h3rwIs3 UpLO4D\$ wiLL F@Il.";
$lang['forum_settings_help_25'] = "<b>a++@CHMENT sp4ce pER Us3r</b> 1\$ +hE M4xImUM 4m0UN+ opH D1\$K \$p4CE 4 U\$3r hAs foR a+tACHMen+5. 0ncE +hI\$ \$P@Ce 15 us3d uP +HE usER c4Nn0+ upl04D 4ny M0re @T+4chMENt5. bY D3f4ULt Th1\$ i\$ 1mB 0ph sP4C3.";
$lang['forum_settings_help_26'] = "<b>alL0W 3M83DdInG oF 4++@chm3N+s 1N M3ss@gE\$ / S1GN@+URE\$</b> @ll0w\$ UsErs To EM83d a+t4chMENtS In po5+s. EN4bl1nG Th1S 0p+i0n WhIl3 us3pHUL C4n iNCRE4\$E YOUr 8ANDW1DTH Us@GE DR4\$+1c@LLY UND3r C3rtAIn c0nph1gUr4T1ONs opH PhP. ipH J00 H@V3 L1M1+3D B@ndwID+h It 1\$ reCommEnDeD Th@T j00 di54bl3 th1s oPt10N.";
$lang['forum_settings_help_27'] = "<b>uS3 4LteRN@+Iv3 4Tt@CHM3Nt m3thOD</b> Forc3s B3eh1v3 +0 Us3 4N @L+3rn4T1V3 reTrI3VAL MEtH0d f0R 4++4CHM3n+s. 1f j00 REC31V3 404 ERRoR m3SS493s wH3N tRy1ng to DoWNlO4D A+taCHmENTs FrOm Mess@G3S +rY En4Bling +HI5 OpTIoN.";
$lang['forum_settings_help_28'] = "tH1s sE++1NG AlLow\$ y0Ur pH0RUm +0 b3 sp1D3reD 8Y sE4rCh eN9iNE\$ L1k3 90o9LE, 4l+4v1\$T4 anD YaH0O. 1PH J00 swi+CH tH1S OpT1On 0FF YOUr pHoRUM wIlL No+ B3 inCLUDED In +H3\$e 5e4rch EnGInES ResUl+\$.";
$lang['forum_settings_help_29'] = "<b>alL0W new U53r rE9i\$tr4T10n\$</b> 4ll0W\$ 0r DI\$@LL0w5 T3h CR3at1On oPh n3w u\$er 4cc0uN+S. s3tt1nG +h3 0P+1on to n0 COmPLETEly DIs@bles tH3 R391\$+r@T10n F0Rm.";
$lang['forum_settings_help_30'] = "<b>enA8L3 w1KIw1kI 1nt3gR@+ioN</b> pR0v1D3s wIkiwOrD \$uPP0rt 1N Y0ur Ph0rUm PosTs. 4 WIKIwOrD 1S M4dE Up 0f tw0 oR M0RE COnC@+3n4TED W0rds Wi+H UPP3Rc4sE L3+tERs (0f+3n rEPhERr3d +O @5 C4m3LC4\$E). If j00 wRi+3 4 wOrD thi\$ w@y 1+ wILl 4U+0m4+ic4Lly BE CH4n9ED inT0 4 hyPERlInk p01n+1Ng +0 Y0ur chO53N w1Kiwik1.";
$lang['forum_settings_help_31'] = "<b>en@8le wiKIwIkI QuiCK LiNk\$</b> EN48LE\$ +3h u\$3 0F mSG:1.1 4nD u\$eR:l090n stylE 3XTEND3D WiKil1nk\$ whiCH CR34+3 Hyp3RL1nkS To tHe \$p3CIPHi3d m3S\$49E / USER pR0PHILE 0f +HE \$P3c1fI3D usEr.";
$lang['forum_settings_help_32'] = "<b>w1k1w1Ki LoC4t10n</b> 1\$ uSED +0 sPEcipHy +EH URi 0f y0ur wIKiW1KI. wHen ENtERiN9 +h3 uR1 UsE [wiKIW0RD] +o 1nD1c4+3 WhERE 1n THE Ur1 +3H w1K1w0RD \$HoULD 4pp3@r, 1.3.: <i>hTTp://En.wiK1p3D1A.0RG/WikI/[wIkIworD]</i> W0ulD L1Nk YoUr wik1WORD\$ +0 %s";
$lang['forum_settings_help_33'] = "<b>fOruM 4cc3sS \$T4+Us</b> cONTr0ls h0W uS3Rs m@Y 4cCeS\$ yOUR foRUm.";
$lang['forum_settings_help_34'] = "<b>oP3n</b> w1ll 4Ll0W ALl us3r5 4ND 9uE\$+S 4cc3\$s +o y0ur pHorUM withou+ rES+RiCt10n.";
$lang['forum_settings_help_35'] = "<b>cLO53D</b> Pr3V3nts @Cc3ss F0r @LL U\$3rs, wi+h +H3 3XCEP+I0N 0ph tH3 4dm1N WhO mAy 5+ill 4cc3ss +h3 4DM1N pANEL.";
$lang['forum_settings_help_36'] = "<b>r3S+r1cted</b> @LlOw\$ +o sE+ 4 l1S+ 0PH u\$ers Wh0 4rE 4ll0W3d @cc3ss +0 y0ur forUm.";
$lang['forum_settings_help_37'] = "<b>pAssw0rD pRotEC+ED</b> 4ll0w\$ j00 +0 se+ A P@\$SW0rd TO G1V3 0u+ to Us3R\$ 50 thEY C4n 4cC3Ss YOUR FoRUm.";
$lang['forum_settings_help_38'] = "when se++1NG resTriCT3d Or P@\$sw0RD PR0+3c+3D M0d3 j00 w1ll N3Ed +0 S@v3 YOUR CH4ng3s 8EF0Re j00 c4n ch4N93 +HE uS3R 4cCEs\$ pR1VIl3gE\$ 0r p4\$\$w0rd.";
$lang['forum_settings_help_39'] = "<b>Search Frequency</b> defines how long a user must wait before performing another search. Searches place a high demand on the database so it is recommended that you set this to at least 30 seconds to prevent \"search spamming\"fr0m K1llInG +h3 serv3r.";
$lang['forum_settings_help_40'] = "<b>poST fr3QU3ncY</b> i\$ ThE MInImUm +IM3 4 UsEr MU5+ w41+ BEF0RE TH3Y Can P0st @G@In. +HI5 53+tInG 4l50 4pHpH3c+\$ +He CR34+ioN OpH pOll5. s3T tO 0 +0 dis@8le +h3 R3sTr1cTI0N.";
$lang['forum_settings_help_41'] = "tHe 480V3 oPt10ns CH@NG3 +HE D3FAULT v4lu3s phoR ThE U\$3r rE9i\$+r@+I0n f0rm. Wh3re @pPlIC4blE OtH3R \$et+iNGs wilL U\$3 tHE f0rum's 0wN dEPh@UlT s3+T1Ng\$.";
$lang['forum_settings_help_42'] = "<b>pR3ven+ Us3 0Ph DUPL1C4+3 eM@il @DDRE5s3s</b> PH0rcEs 8eEH1V3 +0 cH3cK Teh U53r @cCounT5 @G41n\$+ +h3 3Ma1l AdDR3s5 tH3 U53r 15 re9Is+3rinG wiTh @ND pRoMPts +hEM To U53 4No+h3r 1PH i+ 1S 4lre4DY in USE.";
$lang['forum_settings_help_43'] = "<b>reQUiR3 3m4iL C0NF1rm4+ioN</b> WhEn EN@8LED Will 53ND @N 3m4il +0 E4ch n3W U5ER wIth 4 LInk +h@+ C4n b3 u\$ed T0 C0nph1Rm tH31R 3M@IL 4DDR3ss. UNT1l +hEY C0nph1rm THE1r Em41l @DDRE\$S tH3Y wIlL n0T B3 a8LE +0 p0\$+ UnLE5S +h31R user PERm1SS1oN\$ 4rE cH@ng3D m4NU@lly 8Y 4n ADmin.";
$lang['forum_settings_help_44'] = "<b>uSE +3XT-C@p+CH4</b> PResEnts +3h N3W U\$3r w1+H @ M4NGL3d im@g3 whICH th3y mUsT c0py 4 nUmB3r pHr0M 1n+0 4 T3xt f13lD on thE RE9is+r4+i0N pHoRm. us3 th1\$ opTi0N to pr3veNt 4u+0m@+3D 5IGN-UP Vi@ \$CRIp+\$.";
$lang['forum_settings_help_45'] = "<b>tExt-C@PTCH@ dIrEc+ory</b> \$pEC1fi3s +h3 l0C4t10N +H4+ b3eh1v3 wILl \$+0RE i+'S tEX+-c4ptCh4 1m@gES 4nD f0NTS 1n. TH15 DiR3c+0Ry mUst 8E Wr1+@BLE BY the W38 53rvER / pHP pROC3SS 4nD mu\$+ 83 4CCES\$i8L3 V14 http. @pH+3r j00 H4vE EN4BLED +3x+-C4ptCh4 j00 mU\$T upl0@D \$0m3 trU3 +yP3 phon+s into TH3 f0N+s \$U8-D1r3C+0ry 0f y0UR m41n +3X+-CaptCh@ dir3C+0ry o+HErwis3 bEEh1V3 W1ll skip th3 +ext-C@p+CH@ dUr1ng U53r r391\$+r4Tion.";
$lang['forum_settings_help_46'] = "<b>Text Captcha key</b> allows you to change the key used by Beehive for generating the text captcha code that appears in the image. The more unique you make the key the harder it will be for automated processes to \"guess\"teH CODE.";
$lang['forum_settings_help_47'] = "<b>p0st eDit 9R4CE PER1OD</b> @llow\$ j00 +o DEpH1N3 4 P3ri0D iN m1NU+3s wh3R3 useR\$ m@y 3DI+ p0STs WItH0U+ +3h '3dITEd By' tEx+ @ppE4r1n9 0N th31r P0Sts. Iph set +0 0 +3h '3DIt3d BY' +3Xt wilL 4lwAY\$ @Pp3@r.";
$lang['forum_settings_help_48'] = "<b>uNr3aD M3ss4g3s CU+-oPhph</b> 5p3CIpH1Es H0W L0N9 uNrE4d mEss4GES aR3 R3t4inED. J00 may CHO053 FR0m v@R10us PRE\$e+ VAluEs OR ENT3r y0ur OWn CuT-0PHPh P3ri0D iN 53ConDS. ThRe4ds M0DIFI3D E4rl13r +h@n +3h d3Fin3D CUt-ophph p3R10D Will @U+0ma+1c4llY 4pP3AR @5 r34D.";
$lang['forum_settings_help_49'] = "chOo5ing <b>dis@ble unRE4D MESs@G3\$</b> WILl COMpLEt3ly REMoVE UnRE4d mES\$@GE\$ 5upp0R+ @ND REMOvE +H3 r3lEV4nt 0Pt10NS froM tHE DI\$cuSsi0n tyP3 Dr0p doWN On tEH +Hr34D l1\$+.";
$lang['forum_settings_help_50'] = "<b>rEQU1Re U\$eR 4ppR0v4l 8Y 4dm1N</b> AlLows J00 +o restR1ct 4CCEs\$ 8Y NEW U\$3rs un+1L +h3Y H@v3 83en AppRovED 8Y @ ModEr4tor Or 4dm1N. w1+hout 4pPR0v4L 4 UsEr C4nn0t 4CCE\$s @NY @rE4 oph thE 8E3hiv3 ph0ruM iN\$T4lL4+1ON iNClUD1n9 iNDiVidU4L F0ruMS, pM 1n8OX @nD mY foRUmS \$3C+1On5.";
$lang['forum_settings_help_51'] = "us3 <b>cL0\$3D M3ss@G3</b>, <b>r3S+r1CT3d m3S549E</b> @nd <b>pas\$W0Rd pr0T3c+3D me5s@9E</b> +o CU\$t0MIse TH3 M3sS4g3 D1\$pL@y3d whEN us3RS @CCess YOur FoRuM iN teH V4RioUS \$T@T3\$.";
$lang['forum_settings_help_52'] = "j00 Can usE hTml 1N YoUr mEss@G3S. hYp3rl1nk5 4nD EM4iL ADDR3SsE\$ W1LL 4ls0 B3 4Ut0MAt1C4LLy C0nv3r+ED +o lINKs. To uSE +h3 DEPh4ult 833h1vE ph0rUM M35\$49E5 CL3@R +Eh Fi3ld\$.";
$lang['forum_settings_help_53'] = "<b>alLOw u\$3rS +o CH4Ng3 u\$3rN4M3</b> P3rm1+5 4lr3@dY R39i5+Er3D UsEr\$ +o ch4N9e +HEiR u\$3rn@mE. WhEn En@BLED J00 C4N Tr4ck th3 cH4N9es 4 u53R M4K3s +0 tHEir Us3Rn4ME Vi@ +H3 4DM1n us3R +0OLs.";
$lang['forum_settings_help_54'] = "u\$3 <b>fORUM RUlES</b> TO 3ntEr aN 4CcePT@8l3 U53 pOl1CY +H4T E4cH USER MUsT 49r3E +o 8EPh0re REg1\$+3R1ng 0n y0uR pH0rum.";
$lang['forum_settings_help_55'] = "j00 C4n u\$3 HtML In y0ur PhoRuM rULE5. hYp3rl1NKs 4nd 3M4il 4DdrE\$SE\$ w1ll 4ls0 Be @UTOm@+IC4llY c0NvEr+ED TO linK5. tO U5e +3H DEF4UL+ BE3hIvE F0rum @UP CL34R Th3 f13lD.";
$lang['forum_settings_help_56'] = "u\$3 <b>nO-R3PlY 3MA1L</b> t0 sP3C1phY 4n Em@il 4dDRESs tha+ D0e5 n0t Ex1\$+ 0R will nO+ 8E MoNiToreD pHoR r3pliE\$. +h1s 3M4il 4DDREs5 wIlL 8e U\$3D iN TEh h3AdeR\$ phoR alL em41l\$ \$3nT FroM YoUr pHorUm 1nClUDin9 8u+ no+ L1mI+3d +o Post 4ND pM noT1Ph1C4+i0ns, user 3m@ils aND PassW0rd r3M1ND3RS.";
$lang['forum_settings_help_57'] = "iT is reCoMmEND3d +h4+ j00 U53 4n Em4il aDDr3sS ThAT DO3S No+ EX1St +0 H3LP CU+ DOWn 0n 5Pam +H@+ m@y 8e DiR3CTED 4+ Y0UR M@In foRUm 3m4IL 4ddrE\$s";

// Attachments (attachments.php, get_attachment.php) ---------------------------------------

$lang['aidnotspecified'] = "a1D n0T sp3cIfi3d.";
$lang['upload'] = "uPL04d";
$lang['uploadnewattachment'] = "upL04d N3W at+@ChMen+";
$lang['waitdotdot'] = "w41t..";
$lang['successfullyuploaded'] = "sUcCEssfUlly UPl0@D3d: %s";
$lang['failedtoupload'] = "f@Il3D +0 Upl04D: %s";
$lang['complete'] = "c0mpl3te";
$lang['uploadattachment'] = "upl04d @ fiL3 f0r 4++4CHm3nT T0 +3h mes5493";
$lang['enterfilenamestoupload'] = "en+3R F1Len4M3(s) to uPl0ad";
$lang['attachmentsforthismessage'] = "a++4ChmENTs F0r +his M3s\$@GE";
$lang['otherattachmentsincludingpm'] = "o+h3r 4tt@ChmEN+5 (1nClUDING pm MEs\$@g3S 4ND 0Th3r PH0RUMs)";
$lang['totalsize'] = "t0T4l siZ3";
$lang['freespace'] = "fre3 SP4c3";
$lang['attachmentproblem'] = "theR3 w4S 4 pRoBLEM d0wNLOaDInG +h1s @++4CHM3N+. pLE4sE +rY AG4In L4TEr.";
$lang['attachmentshavebeendisabled'] = "a+tACHM3nt\$ h@v3 B3en D1\$4bl3d 8y Th3 pH0RUM OWNEr.";
$lang['canonlyuploadmaximum'] = "j00 c4n 0NLy UpL04d A M4xiMUm 0pH 10 f1L3S 4T 4 t1M3";
$lang['deleteattachments'] = "d3L3+e @Tt4CHmEN+\$";
$lang['deleteattachmentsconfirm'] = "aRe J00 suR3 j00 w@N+ +0 d3LE+E +3h 53lEc+3d @++4ChMEnts?";
$lang['deletethumbnailsconfirm'] = "aRe j00 \$ur3 J00 w4n+ +o DEL3+3 +HE \$3lECTEd @++4cHm3NtS +hUM8n4ilS?";

// Changing passwords (change_pw.php) ----------------------------------

$lang['passwdchanged'] = "p@5SW0RD CH4n93d";
$lang['passedchangedexp'] = "yoUR p@\$sW0rD h4S 8e3N Ch4NgEd.";
$lang['updatefailed'] = "uPdAtE F@il3d";
$lang['passwdsdonotmatch'] = "p@s\$WOrDs D0 n0T ma+CH.";
$lang['newandoldpasswdarethesame'] = "n3w @ND olD P4Ssw0RDs 4re +H3 s4ME.";
$lang['requiredinformationnotfound'] = "r3QUIr3d INForm4t10n not PHounD";
$lang['forgotpasswd'] = "foR90+ P45\$w0rD";
$lang['resetpassword'] = "r353t p@\$sw0rD";
$lang['resetpasswordto'] = "r3Se+ P@\$sw0RD To";
$lang['invaliduseraccount'] = "inV@L1D U53R 4cC0un+ \$pecIFi3d. ChEck eM41l f0R CORREcT LiNk";
$lang['invaliduserkeyprovided'] = "iNv4l1d uSeR kEy ProVID3D. CHECK EM@il pHoR CORr3c+ l1Nk";

// Deleting messages (delete.php) --------------------------------------

$lang['nomessagespecifiedfordel'] = "n0 mEss49e \$p3CiPhI3d ph0r d3l3T1ON";
$lang['deletemessage'] = "del3t3 Me\$\$49e";
$lang['postdelsuccessfully'] = "pOst dEl3TED \$ucC3\$5fullY";
$lang['errordelpost'] = "eRR0R D3letiNg pO\$+";
$lang['cannotdeletepostsinthisfolder'] = "j00 C4NN0T D3LETE posts iN +Hi\$ PhoLDER";

// Editing things (edit.php, edit_poll.php) -----------------------------------------

$lang['nomessagespecifiedforedit'] = "n0 MEss4g3 spECIPhi3d f0r EDI+1ng";
$lang['cannoteditpollsinlightmode'] = "c4nNO+ 3di+ pOLls in lIgH+ Mod3";
$lang['editedbyuser'] = "ed1+ed: %s BY %s";
$lang['editappliedtomessage'] = "ediT 4ppLIED +o mESs493";
$lang['errorupdatingpost'] = "eRRor upD@tInG po\$+";
$lang['editmessage'] = "ed1+ m3Ss4G3 %s";
$lang['editpollwarning'] = "<b>nOte</b>: ediTiNg Cert@iN @sP3C+\$ 0F 4 p0Ll will V01d 4ll +Eh cUrrEN+ vO+3S @nd AlLoW PEopl3 +0 v0t3 @g@1N.";
$lang['hardedit'] = "h4RD 3d1+ OPt10N\$ (V0+3s w1ll 8e rE\$E+):";
$lang['softedit'] = "s0FT EDIt 0p+I0ns (V0+3s WILl B3 REtA1N3d):";
$lang['changewhenpollcloses'] = "ch4ngE wh3N +eh pOll CLo\$ES?";
$lang['nochange'] = "n0 CH4ngE";
$lang['emailresult'] = "eM41l R35uLT";
$lang['msgsent'] = "m3S\$@93 SEN+";
$lang['msgsentsuccessfully'] = "meSs493 s3n+ 5UCCESSfUlly.";
$lang['mailsystemfailure'] = "m4il 5Y5+3m f4IlUr3. m3ss493 nOt sEnT.";
$lang['nopermissiontoedit'] = "j00 @rE N0T P3RM1++ED T0 Edit +Hi\$ M3ss493.";
$lang['cannoteditpostsinthisfolder'] = "j00 C4NnO+ 3D1+ Po5+s iN THi\$ PhoLDER";
$lang['messagewasnotfound'] = "m3sS49E %s w@\$ no+ Ph0Und";

// Email (email.php) ---------------------------------------------------

$lang['sendemailtouser'] = "s3ND 3MA1l +o %s";
$lang['nouserspecifiedforemail'] = "no U\$3r sP3cipHi3D F0r 3m@il1NG.";
$lang['entersubjectformessage'] = "en+Er 4 SUBJ3c+ Ph0r +hE m3SS49E";
$lang['entercontentformessage'] = "en+3R som3 CoN+3N+ f0r +EH m3ss@ge";
$lang['msgsentfromby'] = "thi\$ M3Ss493 W4s sEN+ pHr0m %s 8Y %s";
$lang['subject'] = "sUBJEC+";
$lang['send'] = "sEnd";
$lang['userhasoptedoutofemail'] = "%s H@s 0p+ED OuT 0F 3m4IL C0n+@CT";
$lang['userhasinvalidemailaddress'] = "%s H@s @N Inv4LId Em@1L 4dDRess";

// Message nofificaiton ------------------------------------------------

$lang['msgnotification_subject'] = "meS\$4g3 not1FiCAt1ON PhROm %s";
$lang['msgnotificationemail'] = "h3ll0 %s,\n\n%s P05+eD 4 M3s5@gE +0 J00 On %s.\n\nTH3 su8J3ct 1\$: %s.\n\ntO R34d thA+ m35S@g3 4ND 0tHer5 in thE S@M3 D1sCUSsiOn, 9O +o:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nNOTE: 1f J00 Do No+ WISH T0 r3C31V3 3Ma1l notIphicaTion5 of ph0rUm M3S\$49Es Po\$TeD +0 you, 90 to: %s cl1CK 0n MY coN+rOl\$ +HEn 3ma1L and PriV@Cy, un\$3lECt th3 3ma1l No+IF1c4tion CHeck8OX and prEss suBm1+.";

// Thread Subscription notification ------------------------------------

$lang['subnotification_subject'] = "sub\$cr1p+i0n n0T1ph1c4+10n pHr0m %s";
$lang['subnotification'] = "h3LlO %s,\n\n%s pO\$+ED @ M3S5@ge iN @ thRE4D J00 HAvE \$uBSCr1b3d +O 0N %s.\n\nTH3 su8JECT 1\$: %s.\n\nTo r34D Th4+ m3S\$493 AnD oTh3r\$ IN th3 \$4M3 di5cU\$S1ON, 9O +0:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nNO+3: iph j00 d0 not wI5h +o r3C31v3 ema1l nOT1f1c4+i0Ns 0F n3W M35S49es in +h1\$ ThrE4D, g0 to: %s 4nD 4Djust y0ur IN+er3St lev3L 4t t3H 8O++0m oF th3 p49E.";

// PM notification -----------------------------------------------------

$lang['pmnotification_subject'] = "pM notifIC@+i0n fr0m %s";
$lang['pmnotification'] = "h3LL0 %s,\n\n%s P0st3D a Pm +0 j00 0N %s.\n\n+h3 sU8j3c+ I\$: %s.\n\nT0 re4d +HE mesS@GE 9O To:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nN0te: IF j00 DO no+ W1\$h +0 r3C3iv3 Em4IL N0t1FiCATIons 0ph NEW pm mEss@g3S p0sted t0 you, go t0: %s CL1ck My C0Ntr0ls +hEn 3m@1L 4Nd PriV4CY, UnsEleCT t3h Pm N0tIfICat10n cHECkbox @nD pre\$S 5UbMi+.";

// Password change notification ----------------------------------------

$lang['passwdchangenotification'] = "p@ssw0RD Ch4NGE N0+ipHiC4tion PHr0m %s";
$lang['pwchangeemail'] = "h3llo %s,\n\n+his 4 n0t1F1c4+10N 3m41l t0 1nFoRm j00 tHA+ Y0ur P4ssW0rD On %s h4S 8e3n cH@N93D.\n\n1+ h4S 8een CH4n9ED tO: %s 4nd W@\$ ch4n9ED by: %s.\n\n1pH j00 h4VE R3cE1ved +h1\$ 3mA1L 1n 3rror 0r w3R3 n0T ExP3C+iNG @ CH4n9E +0 Y0ur p4Ssw0rD plE45e C0n+@CT the F0RUm own3R or 4 m0d3R@t0r 0n %s ImMED14+3Ly t0 C0rrECt 1+.";

// Email confirmation notification -------------------------------------

$lang['emailconfirmationrequired'] = "eM@1l coNfIrm@+I0N R3QU1R3d pHoR %s";
$lang['confirmemail'] = "hell0 %s,\n\nyou reC3ntLy cR3A+ED @ N3W U53R @cc0UNT 0n %s.\n8ef0re J00 CAn s+@r+ P0\$+1n9 wE N3ED +0 CoNpHirM Y0ur 3M4Il aDDr3s\$. DoN'T W0rry th1\$ i\$ qui+3 EasY. @ll J00 NEED +o DO 1s CLICK TEH L1NK 8El0w (0r COpy @nD PaS+E i+ InT0 y0ur BR0W\$3r):\n\n%s\n\nonc3 conPh1Rm4+I0n 15 Complete j00 may Lo91N @nd \$+4rt p0stinG 1Mm3D14T3ly.\n\niPh J00 d1D N0+ cR3@+3 4 user 4CC0Un+ on %s Ple4SE 4CCept 0Ur @p0l0gi3s 4nd ph0rw4rd +H15 3M41l to %s 5O +h4T t3H s0urCE of 1+ m4y B3 1NVEst1G4+3D.";
$lang['confirmchangedemail'] = "heLl0 %s,\n\nY0U R3c3nTly CH4N93D Y0UR EM4Il 0N %s.\n83f0RE J00 CAN 5+@R+ Post1n9 49@IN W3 N33d t0 CoNfiRm Y0Ur n3w 3m4Il 4Ddr3ss. DOn't w0rrY Th1\$ Is qUItE e4sY. 4ll J00 n33d to D0 1s CLICK tH3 l1nk 8eLOW (Or COpY @nd P45+3 it 1NtO YoUr 8RowS3r):\n\n%s\n\n0nCe COnphiRM@t10n 1\$ compl3+3 j00 MAy coNt1nu3 TO use the f0rum 4s nORm@l.\n\nif j00 w3R3 n0+ 3Xp3Ct1ng +h1\$ 3m@IL from %s pl34se @CC3PT 0ur @pol09i3\$ @ND f0RW4RD thi\$ 3m@il T0 %s \$0 +h@T the 50uRCE OPh 1t M4y 83 inv3S+1g4+3D.";


// Forgotten password notification -------------------------------------

$lang['forgotpwemail'] = "heLl0 %s,\n\nyOu R3QU3sTED ThI\$ 3-ma1L FroM %s 83CaUS3 J00 haVe f0r90t+3N Y0Ur p4\$SW0RD.\n\nCl1cK TEh liNK BEL0w (or COPy 4ND P@5+E I+ in+0 Y0UR Br0w\$3r) tO reSe+ yoUR P45\$w0RD:\n\n%s";

// Forgotten password form.

$lang['passwdresetrequest'] = "yoUR P@sSW0RD rE53+ r3QU3sT pHR0m %s";
$lang['passwdresetemailsent'] = "p4\$sW0Rd ReSE+ 3-mA1L \$ent";
$lang['passwdresetexp'] = "j00 sh0ULd SH0R+LY R3ceive aN e-M@iL c0Nt@1NiNG in5+RuC+i0N\$ pH0R re\$e++iNg yOUr PaS\$W0rD.";
$lang['validusernamerequired'] = "a V@lid U\$Ern4ME 1\$ ReQUiR3D";
$lang['forgottenpasswd'] = "fOrg0+ pA5sW0RD";
$lang['couldnotsendpasswordreminder'] = "c0uLD N0+ sENd p@\$SW0rD REmiNd3R. Pl3@S3 C0N+4CT teh FOrUM OWn3R.";
$lang['request'] = "r3qU3ST";

// Email confirmation (confirm_email.php) ------------------------------

$lang['emailconfirmation'] = "emAIl COnfIRm@T1oN";
$lang['emailconfirmationcomplete'] = "th@nk j00 FoR COnpH1rminG yOUR 3M@1l adDRE\$S. J00 MAy NOw LOGIn 4nd S+4R+ P0\$T1ng 1mm3DI4+3Ly.";
$lang['emailconfirmationfailed'] = "em41l conPH1rM4+i0N h4S pH41L3d, ple453 +ry 4941n L@+3R. 1Ph J00 ENCOUN+3R tHIs 3Rr0R mUl+iPl3 +1M3S pLEa5e COnt4C+ +3h fOrum own3R 0R A mod3r@+0R f0R @5S1sT4nc3.";

// Links database (links*.php) -----------------------------------------

$lang['toplevel'] = "t0p l3VEl";
$lang['maynotaccessthissection'] = "j00 M4y N0t 4ccESs This \$3C+iOn.";
$lang['toplevel'] = "top LEVEL";
$lang['links'] = "liNk\$";
$lang['viewmode'] = "v1ew mODE";
$lang['hierarchical'] = "h1er4RChIC@l";
$lang['list'] = "lI\$+";
$lang['folderhidden'] = "th1s ph0LD3r 1s hiDD3N";
$lang['hide'] = "h1de";
$lang['unhide'] = "uNH1D3";
$lang['nosubfolders'] = "n0 SUBFoLDEr\$ iN tH1S c4+390RY";
$lang['1subfolder'] = "1 Su8FoLD3R 1n this CA+EG0ry";
$lang['subfoldersinthiscategory'] = "sUBf0ldEr\$ in +Hi5 C4teG0Ry";
$lang['linksdelexp'] = "en+RI3s 1n @ D3LE+Ed pholDER WIlL 8e mOv3D +0 +HE par3nt F0LDER. 0NLy f0lD3Rs wHicH DO NOt C0n+4IN \$uBF0ldEr5 M@Y 8e D3LETED.";
$lang['listview'] = "li\$+ VI3w";
$lang['listviewcannotaddfolders'] = "c4nN0t 4DD F0LD3rs in +h1S vIEW. \$HOW1n9 20 3N+rI3s 4+ @ +IM3.";
$lang['rating'] = "r@ting";
$lang['nolinksinfolder'] = "n0 Links IN +h1\$ f0ldER.";
$lang['addlinkhere'] = "aDD linK heR3";
$lang['notvalidURI'] = "tHAt is N0t 4 v@lID UR1!";
$lang['mustspecifyname'] = "j00 must sp3c1pHy @ n4m3!";
$lang['mustspecifyvalidfolder'] = "j00 Mu\$t sP3CiFY a v4liD Ph0ldEr!";
$lang['mustspecifyfolder'] = "j00 must sp3ciphY 4 pholDEr!";
$lang['successfullyaddedlinkname'] = "sUcC3S\$fully 4DDED L1Nk '%s'";
$lang['failedtoaddlink'] = "f4il3D +0 4DD l1Nk";
$lang['failedtoaddfolder'] = "f41L3d +0 aDD folDER";
$lang['addlink'] = "add 4 LiNk";
$lang['addinglinkin'] = "aDdiNg l1Nk In";
$lang['addressurluri'] = "adDREss";
$lang['addnewfolder'] = "add 4 NeW F0lder";
$lang['addnewfolderunder'] = "adding N3W fOlder Und3r";
$lang['editfolder'] = "eDi+ pholDER";
$lang['editingfolder'] = "ed1t1ng F0ld3r";
$lang['mustchooserating'] = "j00 mU5+ CHo0SE @ r4+ing!";
$lang['commentadded'] = "your COmM3Nt W4s aDD3d.";
$lang['commentdeleted'] = "c0MM3nt w@\$ d3L3tEd.";
$lang['commentcouldnotbedeleted'] = "c0mm3NT c0ulD N0+ BE d3l3teD.";
$lang['musttypecomment'] = "j00 mu\$+ +Yp3 4 C0mm3NT!";
$lang['mustprovidelinkID'] = "j00 mU5+ pr0v1d3 @ l1nk 1d!";
$lang['invalidlinkID'] = "iNV4liD l1Nk 1d!";
$lang['address'] = "addr3ss";
$lang['submittedby'] = "sU8m1+TED 8y";
$lang['clicks'] = "clIcks";
$lang['rating'] = "r4+iNg";
$lang['vote'] = "v0te";
$lang['votes'] = "vo+3s";
$lang['notratedyet'] = "nOT r@+3D 8y 4Ny0n3 YeT";
$lang['rate'] = "rAtE";
$lang['bad'] = "b@d";
$lang['good'] = "gOoD";
$lang['voteexcmark'] = "voTE!";
$lang['clearvote'] = "cL3@r VotE";
$lang['commentby'] = "c0MM3nt 8Y %s";
$lang['addacommentabout'] = "aDD @ COmmeNt 480ut";
$lang['modtools'] = "moDER@+10N tOoLs";
$lang['editname'] = "eD1T n4M3";
$lang['editaddress'] = "eDIT 4DDr3ss";
$lang['editdescription'] = "edI+ D3sCR1PT1on";
$lang['moveto'] = "move +0";
$lang['linkdetails'] = "l1Nk D3+4ils";
$lang['addcomment'] = "adD CoMM3nt";
$lang['voterecorded'] = "yOur v0+3 hA\$ 8E3N rEC0rdeD";
$lang['votecleared'] = "y0ur vOt3 h@\$ b33n Cl34ReD";
$lang['linknametoolong'] = "l1nK Name +00 l0ng. mAx1MuM Is %s cHAr4cteRs";
$lang['linkurltoolong'] = "l1nK urL tOo l0N9. m4XImum Is %s ch@r@CTEr5";
$lang['linkfoldernametoolong'] = "fOlDeR n@m3 T0O Lon9. m4x1muM l3n9+h Is %s CH@R@C+3R\$";

// Login / logout (llogon.php, logon.php, logout.php) -----------------------------------------

$lang['loggedinsuccessfully'] = "j00 lo99ED 1n sUCc3ssfULLy.";
$lang['presscontinuetoresend'] = "pr35\$ contiNu3 t0 rEs3ND f0RM Data 0r c4nCel t0 rELo4d P493.";
$lang['usernameorpasswdnotvalid'] = "th3 u\$Ern4m3 0r p4S\$w0rD J00 \$UPpL1eD I5 no+ VaLID.";
$lang['rememberpasswds'] = "r3m3m83R p4sSW0RD5";
$lang['rememberpassword'] = "rem3mBEr p@\$SW0rd";
$lang['enterasa'] = "eN+3r @s 4 %s";
$lang['donthaveanaccount'] = "d0N't h4VE 4n 4CC0unT? %s";
$lang['registernow'] = "rE91S+er noW.";
$lang['problemsloggingon'] = "pr08l3MS l09G1Ng on?";
$lang['deletecookies'] = "d3lete CooKi3s";
$lang['cookiessuccessfullydeleted'] = "c00ki35 5UCC3SsfullY D3l3T3d";
$lang['forgottenpasswd'] = "fOrg0+ten YoUr pASsw0Rd?";
$lang['usingaPDA'] = "u\$Ing @ pD@?";
$lang['lightHTMLversion'] = "liGht hTml V3Rs1oN";
$lang['youhaveloggedout'] = "j00 h@Ve l09G3D 0Ut.";
$lang['currentlyloggedinas'] = "j00 4r3 cUrReN+Ly l09G3d 1N @s %s";
$lang['logonbutton'] = "l0Gon";
$lang['otherbutton'] = "oTH3r";
$lang['yoursessionhasexpired'] = "y0ur S3ssion h@\$ 3XP1R3d. j00 w1lL n33D +0 L0Gin 494In +o C0n+inuE.";

// My Forums (forums.php) ---------------------------------------------------------

$lang['myforums'] = "my phoRUms";
$lang['allavailableforums'] = "all @v41l48le pH0RUMs";
$lang['favouriteforums'] = "f@VoUR1TE F0RuM\$";
$lang['ignoredforums'] = "i9N0red F0RUm\$";
$lang['ignoreforum'] = "i9nor3 phOrUm";
$lang['unignoreforum'] = "uN19n0rE F0RUM";
$lang['lastvisited'] = "l4\$+ vI\$1+3D";
$lang['forumunreadmessages'] = "%s UnR34D M3Ss4G3s";
$lang['forummessages'] = "%s m3s549es";
$lang['forumunreadtome'] = "%s UNR34d &quot;+o: m3&quot;";
$lang['forumnounreadmessages'] = "nO unr34d m3SS493s";
$lang['removefromfavourites'] = "r3M0V3 fr0M f4voUR1+3s";
$lang['addtofavourites'] = "adD to ph@VoUr1t3s";
$lang['availableforums'] = "av4il@BLE ForuMs";
$lang['noforumsofselectedtype'] = "thER3 4re n0 PhorumS 0PH tEH s3L3C+3d +YpE 4v4il@BLE. pl3@\$3 5El3c+ @ DIfphEr3N+ TYp3.";
$lang['successfullyaddedforumtofavourites'] = "sUCCE5\$fUlLy @Dded pHorUM +0 F4v0Ur1TE\$.";
$lang['successfullyremovedforumfromfavourites'] = "succE\$SFULLy r3MOVEd Ph0RUm fR0M Ph4v0uR1+Es.";
$lang['successfullyignoredforum'] = "succ3\$sFUlly 1gn0rED f0rum.";
$lang['successfullyunignoredforum'] = "sucC3SsphullY UN19n0r3d phOrUm.";
$lang['failedtoupdateforuminterestlevel'] = "f4iL3D +o uPD@TE phorUm In+3RES+ levEl";
$lang['noforumsavailablelogin'] = "th3re 4rE No Ph0rum\$ @V@ilabl3. plE4S3 l0giN +0 v13w yoUR F0rum5.";
$lang['passwdprotectedforum'] = "p4\$SW0rD pR0TEC+3D FoRUm";
$lang['passwdprotectedwarning'] = "tH1S PhorUm 1s P4S5w0RD pR0+3Ct3D. to Ga1n ACCE\$s 3N+Er tEh P4SSw0rd 8El0W.";

// Message composition (post.php, lpost.php) --------------------------------------

$lang['postmessage'] = "pOs+ mes\$@GE";
$lang['selectfolder'] = "s3leC+ f0ldeR";
$lang['mustenterpostcontent'] = "j00 mU5+ 3n+3R \$0mE Con+3NT F0R teh post!";
$lang['messagepreview'] = "me\$s4GE pr3v13w";
$lang['invalidusername'] = "inVALiD Us3Rn4m3!";
$lang['mustenterthreadtitle'] = "j00 MU\$+ 3n+3r @ +I+L3 FoR +EH +Hr3@d!";
$lang['pleaseselectfolder'] = "pLEase \$el3C+ 4 f0ldER!";
$lang['errorcreatingpost'] = "erRoR crEAT1Ng PoSt! Pl3@s3 +ry 4G41N iN 4 pH3W mInU+3\$.";
$lang['createnewthread'] = "cR34tE N3W tHR34d";
$lang['postreply'] = "poST r3ply";
$lang['threadtitle'] = "tHr34D t1+L3";
$lang['messagehasbeendeleted'] = "m3\$S493 noT phouND. CH3ck th@+ I+ h4\$N'+ b33N DEL3TED.";
$lang['messagenotfoundinselectedfolder'] = "m3ss@G3 n0t PHOunD In 53l3c+3D f0lDER. ChECK tH4+ iT H45n'T 83eN MoV3D 0R D3l3+ED.";
$lang['cannotpostthisthreadtypeinfolder'] = "j00 c4NN0+ P05+ +hIs thr3@d tYp3 in +H4T FoLDER!";
$lang['cannotpostthisthreadtype'] = "j00 C4Nno+ post +hI5 +hr34D tYp3 4\$ +H3re aRE No @v@IL@ble PholdER\$ +ha+ 4LL0W 1+.";
$lang['cannotcreatenewthreads'] = "j00 C4NN0T CRE4+3 NEw +Hr34Ds.";
$lang['threadisclosedforposting'] = "this +hr34d 1\$ cL0sED, j00 Cann0+ POSt 1N I+!";
$lang['moderatorthreadclosed'] = "w@rn1ng: +hi5 THrE4d 1\$ CLo\$ED Ph0r po\$+iNg to n0RM4l usEr\$.";
$lang['usersinthread'] = "user5 in +hrE4d";
$lang['correctedcode'] = "correCtED C0d3";
$lang['submittedcode'] = "suBm1+TeD code";
$lang['htmlinmessage'] = "h+mL 1n m3SS4G3";
$lang['disableemoticonsinmessage'] = "di\$@8l3 eM0+ic0n\$ in m3s5493";
$lang['automaticallyparseurls'] = "aut0m4t1CAlLY P4R\$e uRl5";
$lang['automaticallycheckspelling'] = "au+Om4+iC4lly CH3CK sp3llin9";
$lang['setthreadtohighinterest'] = "sE+ +Hr34d To h1gh IN+Er3S+";
$lang['enabledwithautolinebreaks'] = "eN48LED Wi+h 4U+o-L1NE-BR3AKs";
$lang['fixhtmlexplanation'] = "tHis phorUM U\$3s hTml PhIL+3RiNG. Y0ur 5uBm1+tED hTML h@\$ B33N MoD1fieD 8y tH3 f1L+3R\$ in \$om3 w4y.\\n\\n+0 viEw YoUR or1gIn@l C0DE, \$3leCT ThE \\'5uBm1++3d c0dE\\' R4di0 BU++0n.\\n+O vi3W +HE MoD1fieD COD3, 53l3C+ +3h \\'C0rr3c+3D CODE\\' R4d10 8UTt0N.";
$lang['messageoptions'] = "m3S5a9e 0pt10Ns";
$lang['notallowedembedattachmentpost'] = "j00 4r3 not 4LloWED +0 em8ed 4t+@CHm3n+s IN Y0UR p0\$+5.";
$lang['notallowedembedattachmentsignature'] = "j00 4rE n0+ @Ll0W3d +o 3M8ed 4+t@CHmenTs In your s1gn@+Ur3.";
$lang['reducemessagelength'] = "m3s\$49e lenG+h Mus+ bE UnDER 65,535 Ch4R4C+Er\$ (cUrrEN+lY: %s)";
$lang['reducesiglength'] = "sI9n4tur3 l3n9+H MUst 8E UndEr 65,535 Char4c+Er\$ (CUrrENtLY: %s)";
$lang['cannotcreatethreadinfolder'] = "j00 C4Nno+ CR3a+E N3w +hR34d\$ iN +hi\$ FOldEr";
$lang['cannotcreatepostinfolder'] = "j00 C4NNoT r3PlY t0 po\$+5 in tH1\$ FOlDER";
$lang['cannotattachfilesinfolder'] = "j00 C4Nnot p0\$+ 4Tt4CHM3N+s in th1\$ pHolDer. R3M0v3 4T+@CHmEnts +0 CoN+inU3.";
$lang['postfrequencytoogreat'] = "j00 c@n onLy po5T 0nc3 3VEry %s SEc0nds. PLe453 +RY 4941N l@+3r.";
$lang['emailconfirmationrequiredbeforepost'] = "eM@Il ConPH1rm4TiOn i\$ r3Qu1R3d BEF0RE J00 C@N PoSt. iF j00 H@V3 n0t RECe1V3d 4 c0NpHiRM4+10n eM4iL PlE@\$3 CL1CK tH3 buttON B3l0w @Nd 4 NEW 0nE will 83 s3N+ tO y0u. iPh yoUR 3Ma1l 4DDRES\$ ne3DS CH4n91n9 PLE4sE DO 5o BEPhorE R3qu3st1N9 A nEW C0nphIrm4t10n emA1l. j00 m4y CH4nGe YouR 3M4Il @dDR3ss by cliCk my COn+R0Ls @8ov3 4nD Th3n u\$3r d3+@IL5";
$lang['emailconfirmationfailedtosend'] = "c0nF1rm4+10n Em41l Ph4ilEd t0 SEnD. pLE4SE C0nt4C+ +hE ForuM 0wNEr +0 R3C+ify +h1s.";
$lang['emailconfirmationsent'] = "cOnph1rM4t10N EM4Il Ha5 8EEn r3sEN+.";
$lang['resendconfirmation'] = "r3s3nD COnPhirMaT1on";
$lang['userapprovalrequiredbeforeaccess'] = "y0Ur u\$er 4CC0uNt n3eds +O 8e @ppRoV3D BY @ phoRUM @dM1N b3F0RE j00 C@n @Cc3ss +3h r3QUe5+3D F0rum.";

// Message display (messages.php & messages.inc.php) --------------------------------------

$lang['inreplyto'] = "iN rePly +o";
$lang['showmessages'] = "sHoW MEsS49e\$";
$lang['ratemyinterest'] = "r4+3 my InTEr3ST";
$lang['adjtextsize'] = "adju\$T TEx+ sIz3";
$lang['smaller'] = "sM4ll3r";
$lang['larger'] = "l@R9er";
$lang['faq'] = "f4Q";
$lang['docs'] = "doc\$";
$lang['support'] = "sUpPor+";
$lang['donateexcmark'] = "doN@+3!";
$lang['fontsizechanged'] = "font s1ZE Ch4n9ED. %s";
$lang['framesmustbereloaded'] = "fR@m3s mUsT B3 r3l0ADEd m@nuALlY +0 sE3 ChAN93s.";
$lang['threadcouldnotbefound'] = "t3H rEQU3stED ThRe4d coulD No+ 83 f0unD oR 4ccESs Was D3N13D.";
$lang['mustselectpolloption'] = "j00 musT S3LEC+ @n OpTioN T0 VotE f0r!";
$lang['mustvoteforallgroups'] = "j00 mU\$t vO+3 iN eveRy gRoup.";
$lang['keepreading'] = "k3Ep re4DInG";
$lang['backtothreadlist'] = "b4ck to ThrE4d lis+";
$lang['postdoesnotexist'] = "tH4t P0\$+ doeS n0t eX1\$T in +Hi5 +hr34D!";
$lang['clicktochangevote'] = "cLiCK T0 CH4N93 V0+3";
$lang['youvotedforoption'] = "j00 voteD phOr 0pt10N";
$lang['youvotedforoptions'] = "j00 voTED Ph0R 0p+1oN\$";
$lang['clicktovote'] = "cLick tO V0+3";
$lang['youhavenotvoted'] = "j00 h4ve NO+ vo+Ed";
$lang['viewresults'] = "vIew r3\$ULts";
$lang['msgtruncated'] = "m3\$s@g3 TRunC4teD";
$lang['viewfullmsg'] = "v13w fUll m3S\$@gE";
$lang['ignoredmsg'] = "i9nor3D m3S\$49E";
$lang['wormeduser'] = "wormED usER";
$lang['ignoredsig'] = "igNoReD sigN4Tur3";
$lang['messagewasdeleted'] = "m3\$S493 %s.%s W@\$ d3l3teD";
$lang['stopignoringthisuser'] = "s+op i9Nor1n9 tH1S uSEr";
$lang['renamethread'] = "r3n4m3 +hr34D";
$lang['movethread'] = "m0VE +hR34d";
$lang['torenamethisthreadyoumusteditthepoll'] = "to r3namE +hiS +HREaD J00 MUsT 3d1+ +3h polL.";
$lang['closeforposting'] = "cL0sE F0R p05tin9";
$lang['until'] = "uN+IL 00:00 UtC";
$lang['approvalrequired'] = "aPpr0V@l r3qU1R3D";
$lang['messageawaitingapprovalbymoderator'] = "meS\$@GE %s.%s is 4wa1+Ing 4Ppr0VAL 8y 4 m0d3r4+0R";
$lang['postapprovedsuccessfully'] = "pO\$T ApProv3D sucC3sSFUlLY";
$lang['postapprovalfailed'] = "poS+ aPpRov@l ph@iL3D.";
$lang['postdoesnotrequireapproval'] = "p0St Do3S n0T REquir3 4ppR0v4l";
$lang['approvepost'] = "aPPr0Ve pO\$+ F0R DiSPl4y";
$lang['approvedbyuser'] = "apPROv3d: %s 8y %s";
$lang['makesticky'] = "m4K3 S+ICKY";
$lang['messagecountdisplay'] = "%s OF %s";
$lang['linktothread'] = "peRm4n3nt LinK +o +hI5 +Hr34d";
$lang['linktopost'] = "l1nk TO p05+";
$lang['linktothispost'] = "l1Nk t0 th1s po5+";
$lang['imageresized'] = "tH1\$ Im@gE h4s BEEN r3S1zeD (OrI91n@l sIZ3 %1\$\$x%2\$\$). t0 viEW +HE PhUll-s1z3 iM493 CL1ck hEr3.";
$lang['messagedeletedbyuser'] = "meSS49e %s.%s DEL3teD %s 8Y %s";
$lang['messagedeleted'] = "me\$S@gE %s.%s w45 DEl3tEd";

// Moderators list (mods_list.php) -------------------------------------

$lang['cantdisplaymods'] = "c4NN0t d1\$PL@Y pHoLDER mod3r4TORs";
$lang['moderatorlist'] = "m0d3R4tor lI\$+:";
$lang['modsforfolder'] = "mOd3R4+0rs phor pHoLDEr";
$lang['nomodsfound'] = "n0 MOD3r4+ors pHoUnD";
$lang['forumleaders'] = "f0ruM Le4d3R\$:";
$lang['foldermods'] = "fOLD3r m0DER@T0Rs:";

// Navigation strip (nav.php) ------------------------------------------

$lang['start'] = "s+@rt";
$lang['messages'] = "me\$s4G3S";
$lang['pminbox'] = "iNbox";
$lang['startwiththreadlist'] = "s+@rT pA93 w1+h thr34d liS+";
$lang['pmsentitems'] = "sEn+ itEMs";
$lang['pmoutbox'] = "out8ox";
$lang['pmsaveditems'] = "s@v3D i+ems";
$lang['pmdrafts'] = "dr4pH+5";
$lang['links'] = "l1NKs";
$lang['admin'] = "admin";
$lang['login'] = "lOgin";
$lang['logout'] = "lO9ou+";

// PM System (pm.php, pm_write.php, pm.inc.php) ------------------------

$lang['privatemessages'] = "pr1v4tE mEss@ge\$";
$lang['recipienttiptext'] = "s3P4raTE R3C1piEn+S bY 5EMI-C0l0N or C0mm4";
$lang['maximumtenrecipientspermessage'] = "tHerE i\$ 4 lImit opH 10 r3CIP1EN+s p3r mESs493. PlE4\$3 4mEnd yoUR rEC1pI3nt li5+.";
$lang['mustspecifyrecipient'] = "j00 musT \$p3ciphY @+ l345+ onE R3c1PiEN+.";
$lang['usernotfound'] = "user %s no+ FoUnD";
$lang['sendnewpm'] = "s3nd n3w Pm";
$lang['savemessage'] = "s@v3 mEss493";
$lang['timesent'] = "t1ME 53n+";
$lang['errorcreatingpm'] = "eRror cR3@+IN9 pm! Pl34\$3 try 4941n in @ Ph3w minU+3S";
$lang['writepm'] = "wR1+e m3SS49e";
$lang['editpm'] = "eDi+ m3SS@gE";
$lang['cannoteditpm'] = "c@nnot EDi+ +hi5 pm. 1+ H@\$ @LRe4dy 833n vIEW3d 8y +hE RECIP13Nt 0R +3H mEs\$49E DO3S No+ 3x1\$+ 0r i+ 1S iN@Cc3s\$1Bl3 by j00";
$lang['cannotviewpm'] = "c@nn0+ vi3W pM. Mess49e do3s nO+ 3x1S+ 0r 1t iS in4CC3\$\$18L3 8Y J00";
$lang['pmmessagenumber'] = "m3ss@gE %s";

$lang['youhavexnewpm'] = "j00 H@VE %d nEw M3\$5@gE\$. WoUlD J00 l1k3 +O 90 +o y0Ur InBox NOw?";
$lang['youhave1newpm'] = "j00 h@v3 1 n3W mESs@GE. W0ULD J00 like to 90 T0 y0UR iNBOx now?";
$lang['youhave1newpmand1waiting'] = "j00 hav3 1 n3w m3ss493.\\n\\nY0u @l5o H@V3 1 M3s549e @W41+INg DEL1v3Ry. +0 r3c31v3 thIs m3SS@gE plE4se cl34r s0m3 \$P@CE IN yOUr 1N80X.\\n\\nwoULD j00 Lik3 t0 90 T0 yOUr 1NBOx N0w?";
$lang['youhave1pmwaiting'] = "j00 H4ve 1 mESS@GE @W@i+inG DEL1VERy. +0 r3C31vE tHis mes\$4gE Pl34sE CL3@r S0m3 \$P@CE 1n y0ur 1n8ox.\\n\\nwoUlD j00 lIk3 +0 9O to y0Ur 1N8ox NOW?";
$lang['youhavexnewpmand1waiting'] = "j00 h4V3 %d N3w M3Ss@ge\$.\\n\\nY0u @ls0 h4V3 1 m3SS493 4W@I+Ing D3LIV3Ry. T0 reCE1v3 +h1\$ ME5s4G3 pLE4s3 cLE4r s0ME sP@CE IN your 1N8oX.\\n\\nWOUlD J00 liKE +o 90 +o YoUr 1N80x now?";
$lang['youhavexnewpmandxwaiting'] = "j00 h4VE %d nEW m3s5@g3s.\\n\\nY0U aLS0 H4ve %d MESs@GE\$ @w@i+INg DEl1very. +o r3ce1V3 +h3SE MESs493 pl34sE CL3@r SOme SPACE IN yOUr in8OX.\\n\\nwOULD j00 lIK3 T0 go +0 y0ur iNBOx now?";
$lang['youhave1newpmandxwaiting'] = "j00 h4V3 1 n3w m3SS49E.\\n\\nYOU 4lS0 haVE %d mEss493s 4W@i+iNg DElIv3rY. to r3cEIv3 thEs3 me\$s493\$ pL3453 CLE4r \$0me sp4c3 1N Y0ur iNBOx.\\n\\nWOULd J00 l1K3 t0 90 t0 y0Ur 1N8oX Now?";
$lang['youhavexpmwaiting'] = "j00 h4VE %d M3ssag3s @W@i+1NG Deliv3rY. t0 rECE1v3 +hE\$e m3Ss493S PLE4SE CL34r s0mE spaC3 in YOUR iN8ox.\\n\\nw0ulD J00 l1K3 +0 90 +o yoUR iNBOx now?";

$lang['youdonothaveenoughfreespace'] = "j00 dO nOt h4v3 ENougH fr33 sp@C3 +0 SEnd Th1S m3S\$49e.";
$lang['userhasoptedoutofpm'] = "%s h4s 0pted oUT 0PH r3C31vIng pEr50n@l m3SS4g3S";
$lang['pmfolderpruningisenabled'] = "pM f0LDEr pRUnInG i\$ EN48lEd!";
$lang['pmpruneexplanation'] = "th1s f0rum UsE\$ pm FoLd3r PRUNIn9. Th3 M35s@GE\$ J00 h@v3 \$+0REd iN Y0ur INB0x 4Nd s3NT 1+3Ms\\nPHOldER5 ar3 5UBj3c+ +o @UTom4+1c dEL3+i0N. @Ny mES\$493S J00 w1\$h +o kEEp \$H0uld 83 mOv3D +0\\nYOUr \\'S4VED 1+3M5\\' f0lder so th4t thEy ar3 n0t D3LEtEd.";
$lang['yourpmfoldersare'] = "y0uR PM F0LDEr5 @r3 %s fulL";
$lang['currentmessage'] = "curreN+ m3SS@g3";
$lang['unreadmessage'] = "unRE4d m3ss@g3";
$lang['readmessage'] = "re4d M3Ss49e";
$lang['pmshavebeendisabled'] = "p3R\$0n@L mEsS@g3s H@VE bEEN D1\$4BL3d 8Y +h3 f0RUm oWN3R.";
$lang['adduserstofriendslist'] = "add U53rs +o yOur pHR13nD\$ L1\$t +O H4v3 +heM @PpE4r in @ DR0P D0wn 0N TH3 PM WR1+3 m3ss493 p@GE.";

$lang['messagesaved'] = "m3ss@GE s@v3d";
$lang['messagewassuccessfullysavedtodraftsfolder'] = "m3Ss4G3 w4s 5uCC3ssfUlLy 5@ved t0 'DR4Ft\$' f0LD3r";
$lang['couldnotsavemessage'] = "coulD not s4v3 mess493. M4k3 \$uR3 j00 H4v3 enoUgh @v41l48LE phr3e \$p4C3.";
$lang['pmtooltipxmessages'] = "%s Mess49es";
$lang['pmtooltip1message'] = "1 MEs\$AG3";

$lang['allowusertosendpm'] = "aLLoW U53r +0 seND p3R\$0N4L M3SSa93s +0 Me";
$lang['blockuserfromsendingpm'] = "bLOCK UsER PHrom \$3nD1NG PER\$0n@L m3SS49es +O mE";
$lang['yourfoldernamefolderisempty'] = "y0UR %s pholD3r 1s 3Mp+y";
$lang['successfullydeletedselectedmessages'] = "sucC3s\$FUllY DElE+3D s3leCtED M3ss@gE\$";
$lang['successfullyarchivedselectedmessages'] = "sUCC3ssPhULly 4rChIv3d \$el3CT3D m3SS@Ge\$";
$lang['failedtodeleteselectedmessages'] = "f@1lEd tO Del3TE \$el3cTEd M3S\$49Es";
$lang['failedtoarchiveselectedmessages'] = "f4iled to aRCh1v3 sEl3cTeD mE5\$@Ge\$";

// Preferences / Profile (user_*.php) ---------------------------------------------

$lang['mycontrols'] = "my C0ntroLs";
$lang['myforums'] = "mY forUms";
$lang['menu'] = "m3Nu";
$lang['userexp_1'] = "us3 tH3 menU On tEH L3Ft +0 m4n@g3 y0UR sETt1ngs.";
$lang['userexp_2'] = "<b>uSEr D3tA1ls</b> 4LLOws j00 +0 ch@NG3 y0Ur n4m3, EM4IL 4dDRE\$S And PaS5W0rd.";
$lang['userexp_3'] = "<b>u\$er PrOphILE</b> ALloW\$ J00 to eDI+ YouR U5er Proph1l3.";
$lang['userexp_4'] = "<b>cH@ng3 p4ssW0RD</b> @LloWs j00 tO CH@nG3 YOuR passW0RD";
$lang['userexp_5'] = "<b>em4il &amp; priV4CY</b> l3t\$ J00 changE hOw j00 C4N b3 C0N+@ct3D 0n 4ND oPhF TEH ph0rum.";
$lang['userexp_6'] = "<b>foRUm 0PtIoNs</b> L3+S j00 Ch@ng3 H0w th3 F0ruM LOOk5 anD w0rks.";
$lang['userexp_7'] = "<b>atT4chM3n+s</b> 4ll0ws J00 T0 Edit/D3L3te yoUr 4Tt4CHMENts.";
$lang['userexp_8'] = "<b>s19nA+UrE</b> LET\$ J00 3D1+ y0UR sIgN4TUr3.";
$lang['userexp_9'] = "<b>r3l4t1Onship\$</b> lETs j00 m4n@93 y0ur rEl4+10N\$HIP W1+H o+h3r UsER5 on +h3 f0RUm.";
$lang['userexp_9'] = "<b>word PhiL+3r</b> lEts j00 eDIt YoUR p3r\$0n4L worD pHiL+3r.";
$lang['userexp_10'] = "<b>thR34D sU8sCR1P+I0ns</b> @lL0w\$ j00 t0 m4n493 y0uR +hR34d sU8SCR1p+i0Ns.";
$lang['userdetails'] = "user D3+@il5";
$lang['userprofile'] = "u53r pr0PhIl3";
$lang['emailandprivacy'] = "eM@1L &amp; priVACy";
$lang['editsignature'] = "edI+ \$19N4+uRE";
$lang['norelationshipssetup'] = "j00 h4v3 n0 u\$ER Rel@tI0nsH1P5 set Up. @DD 4 neW u\$3r 8Y 5E4Rch1N9 bEl0w.";
$lang['editwordfilter'] = "eD1+ w0rd PhILt3R";
$lang['userinformation'] = "uS3r InF0RmA+1On";
$lang['changepassword'] = "cH@ng3 P4Ssw0RD";
$lang['currentpasswd'] = "cURREn+ p4ssw0rD";
$lang['newpasswd'] = "nEw p45\$W0rd";
$lang['confirmpasswd'] = "conph1Rm P4\$sw0RD";
$lang['passwdsdonotmatch'] = "p4\$SW0RdS DO not m4+CH!";
$lang['nicknamerequired'] = "n1ckN4m3 1S R3qu1rEd!";
$lang['emailaddressrequired'] = "eM4IL ADdr3SS 1\$ r3qUiRED!";
$lang['logonnotpermitted'] = "lOg0n noT perMI++3d. Ch00s3 4notH3R!";
$lang['nicknamenotpermitted'] = "n1ckn4m3 NOt P3rmi+tED. CHo0S3 4n0th3R!";
$lang['emailaddressnotpermitted'] = "eM@1l 4DDR3\$\$ n0t p3rm1++Ed. Cho0SE @n0thEr!";
$lang['emailaddressalreadyinuse'] = "eMa1L @dDR3S5 4lR3@DY 1N UsE. CHOO\$3 4nOthER!";
$lang['relationshipsupdated'] = "r3L4t10NShIp\$ UPD4t3d!";
$lang['relationshipupdatefailed'] = "r3lat10N\$hip UPda+3D F41LED!";
$lang['preferencesupdated'] = "pREFeR3NC3s wEr3 \$ucCEssFULly UpDATED.";
$lang['userdetails'] = "uS3r dEt@Il\$";
$lang['memberno'] = "mEmB3r n0.";
$lang['firstname'] = "f1Rs+ n@ME";
$lang['lastname'] = "l@s+ n@m3";
$lang['dateofbirth'] = "d@T3 0Ph B1R+H";
$lang['homepageURL'] = "h0mep@Ge UrL";
$lang['profilepicturedimensions'] = "pRofilE pIC+URe (M4X 95x95px)";
$lang['avatarpicturedimensions'] = "av@t@R pIC+Ure (mAx 15X15px)";
$lang['invalidattachmentid'] = "inV@L1d 4tTachMENt. ch3CK Th4+ I\$ h@sn'T b3En D3l3T3d.";
$lang['unsupportedimagetype'] = "uNsuppOrTED 1M49e @++@CHM3N+. j00 C4n 0NlY uSe Jp9, GiF @nD PN9 1m@93 a+t4CHmEN+s F0r y0ur 4v4T4r 4ND pRopHIl3 p1CtUr3.";
$lang['selectattachment'] = "seleC+ @+t@ChM3nt";
$lang['pictureURL'] = "p1c+URE Url";
$lang['avatarURL'] = "aV4+aR URL";
$lang['profilepictureconflict'] = "tO usE @N @++4chm3n+ Phor Y0Ur pRoPhILe PICTUR3 tHE piCTUR3 URL PHi3LD MU\$+ 83 8L4nk.";
$lang['avatarpictureconflict'] = "t0 Us3 4n 4T+aChM3NT F0R Y0ur 4v@+4R PicTUr3 +h3 @v4tar Url f1elD mu\$+ BE 8l4NK.";
$lang['attachmenttoolargeforprofilepicture'] = "sEl3C+ED @++@CHM3N+ I5 +00 l4r93 for PrOf1l3 P1cTURE. M@ximUM DIMEN\$IOn\$ 4r3 %s";
$lang['attachmenttoolargeforavatarpicture'] = "s3L3C+ED @++@ChMEn+ Is Too l4rGE F0R aV4+@R PICTUR3. m4XIMUm DIMEN\$I0ns 4RE %s";
$lang['failedtoupdateuserdetails'] = "s0me 0R 4LL oPh Y0Ur UsEr @CCoUNT D3ta1Ls COULd N0+ 83 uPd@+eD. pl34SE trY @941n latER.";
$lang['failedtoupdateuserpreferences'] = "some or 4lL 0F y0UR UsEr pR3F3R3ncE\$ cOulD No+ 8e Upd4tEd. pl3453 tRY AG41N L4+3r.";
$lang['emailaddresschanged'] = "eMa1L aDDr3SS H4S 8e3N CHanGED";
$lang['newconfirmationemailsuccess'] = "yoUR EMa1l 4DDR3ss H@\$ 83eN ch4n93d 4ND 4 NEW COnF1RM@+i0n 3ma1L h@5 B33n s3nt. pLE4\$e CH3ck 4nd R34D +hE 3m41l pHor FURth3R InstrUC+I0n5.";
$lang['newconfirmationemailfailure'] = "j00 H@VE CH4NGED Y0UR 3m41L aDDRESs, 8UT w3 w3re Una8lE to \$enD 4 C0nfiRm@+1on r3qU3st. pl34\$3 C0n+4c+ tHE PH0RUm oWN3r pHOr 4ssi5+4NC3.";
$lang['forumoptions'] = "f0RUm opt10ns";
$lang['notifybyemail'] = "nOt1Fy BY 3M4IL oF pO\$+5 +0 mE";
$lang['notifyofnewpm'] = "noT1fy BY p0PUp OF n3w Pm me\$s493S +o M3";
$lang['notifyofnewpmemail'] = "no+IpHy by 3M4Il 0ph N3w pm mESs49e\$ t0 ME";
$lang['daylightsaving'] = "adJUst phoR d4YLIgH+ sAv1ng";
$lang['autohighinterest'] = "aut0m4t1cAlLy m4rk thrE4ds 1 P0ST 1n aS hIGh 1n+Er3st";
$lang['convertimagestolinks'] = "aU+om4+1CaLly conv3R+ 3m8EDD3d im4G3\$ 1n Po\$+\$ In+0 LinK5";
$lang['thumbnailsforimageattachments'] = "tHumBN4il\$ PhOr 1m@GE @+t4cHmENTs";
$lang['smallsized'] = "sM4ll 5iz3d";
$lang['mediumsized'] = "mediuM s1Z3D";
$lang['largesized'] = "l4r9e s1Z3D";
$lang['globallyignoresigs'] = "gl0bALLY i9n0rE UseR s19n4TuR3S";
$lang['allowpersonalmessages'] = "aLlow 0+h3r u\$ers t0 \$3nd mE p3r\$0n@l mEss@G3S";
$lang['allowemails'] = "allow 0+her U5ER\$ +o \$3nd m3 Em@IL\$ V1@ my PRoph1l3";
$lang['timezonefromGMT'] = "t1m3 zOnE";
$lang['postsperpage'] = "po5+s peR p4g3";
$lang['fontsize'] = "f0NT s1z3";
$lang['forumstyle'] = "forum 5+yl3";
$lang['forumemoticons'] = "f0RUm em0+iC0n\$";
$lang['startpage'] = "s+4r+ pag3";
$lang['signaturecontainshtmlcode'] = "sign4+Ur3 cont41Ns h+ML CoDE";
$lang['savesignatureforuseonallforums'] = "s@V3 si9n@+urE F0R U\$3 0N 4ll PH0rum\$";
$lang['preferredlang'] = "pRepH3RR3d l@N9U49E";
$lang['donotshowmyageordobtoothers'] = "do n0+ SH0W My 493 0R D4te 0ph B1rth t0 Oth3r\$";
$lang['showonlymyagetoothers'] = "show ONly mY AgE +o 0TH3rs";
$lang['showmyageanddobtoothers'] = "sh0W 80+h My 493 and DATE Of b1r+H tO 0+her5";
$lang['showonlymydayandmonthofbirthytoothers'] = "shOW 0nly mY dAy @ND M0n+h 0ph B1rTh tO 0+hER\$";
$lang['listmeontheactiveusersdisplay'] = "l1\$+ Me oN +H3 @Ct1v3 U5er5 DI\$PL@Y";
$lang['browseanonymously'] = "bR0w5e forUM 4NoNyMoUsly";
$lang['allowfriendstoseemeasonline'] = "bR0wsE @nonyMoUsLY, 8u+ @lLow fRiENDs tO s33 M3 4s 0nlIN3";
$lang['revealspoileronmouseover'] = "reve4L \$P01L3R\$ 0n m0use ov3r";
$lang['showspoilersinlightmode'] = "alway5 sh0w spo1LEr5 IN l1ght MoDE (u\$3s lI9HtER F0Nt COLOUr)";
$lang['resizeimagesandreflowpage'] = "r3s1ze iM@gE\$ @nd REfL0w p@93 to Pr3veN+ H0R1ZoN+@l 5croll1n9.";
$lang['showforumstats'] = "sh0w PHORum s+4Ts 4T 8o++0M opH MEss@gE P4N3";
$lang['usewordfilter'] = "en@8lE w0rD phiLTER.";
$lang['forceadminwordfilter'] = "f0RCE Us3 0f 4DM1n WoRD F1lt3R On 4ll US3r\$ (1NC. GUE5T\$)";
$lang['timezone'] = "t1ME zOne";
$lang['language'] = "l@n9u@GE";
$lang['emailsettings'] = "emA1l 4nd C0nt4ct se+t1N9S";
$lang['forumanonymity'] = "foRUM 4NONym1+y Se+T1n9S";
$lang['birthdayanddateofbirth'] = "biRthDaY @nd dat3 opH B1RTH DI\$pl@y";
$lang['includeadminfilter'] = "inclUD3 4DM1n worD F1LTEr IN my lI\$+.";
$lang['setforallforums'] = "se+ phoR @ll f0rUm5?";
$lang['containsinvalidchars'] = "%s c0nt4in\$ INV4liD ch4R4CT3r\$!";
$lang['homepageurlmustincludeschema'] = "h0M3p49e Url Must 1NCLudE HT+P:// \$chem4.";
$lang['pictureurlmustincludeschema'] = "p1Ctur3 url mU\$+ 1nclUd3 hT+p:// sCH3ma.";
$lang['avatarurlmustincludeschema'] = "av4+4r UrL MUst 1ncLUD3 h+tp:// sCHEM4.";
$lang['postpage'] = "p0s+ p@93";
$lang['nohtmltoolbar'] = "n0 html +0OLb4r";
$lang['displaysimpletoolbar'] = "dI\$play \$1mpLE h+mL toOlB4r";
$lang['displaytinymcetoolbar'] = "d15pl4Y Wy\$1wy9 H+ml T0olB4R";
$lang['displayemoticonspanel'] = "dIspl4y em0T1CON\$ P4n3l";
$lang['displaysignature'] = "d15pl4y s1gn@+URE";
$lang['disableemoticonsinpostsbydefault'] = "di5@8le 3Mot1cOn\$ 1n m3SS@g3s by D3FaUL+";
$lang['automaticallyparseurlsbydefault'] = "auTOm@+IcALlY p@RsE UrLs in M3Ss@GE\$ by D3faULt";
$lang['postinplaintextbydefault'] = "pOst iN PL4in +3XT BY DEPH4ULt";
$lang['postinhtmlwithautolinebreaksbydefault'] = "p0S+ in h+Ml W1+h 4UTO-lIN3-8rE4K\$ 8y DEPH@ULt";
$lang['postinhtmlbydefault'] = "p0S+ 1N h+Ml 8Y DEph4ul+";
$lang['privatemessageoptions'] = "pr1v4+3 me5S493 opT10ns";
$lang['privatemessageexportoptions'] = "pR1v@+3 MEss493 EXpOrT 0Pt10N5";
$lang['savepminsentitems'] = "s@v3 a Copy oF E4CH Pm 1 \$3nD 1N My SEN+ 1t3Ms F0LD3r";
$lang['includepminreply'] = "iNcluDE M3Ss49E 80dy wh3n REPlY1n9 +0 PM";
$lang['autoprunemypmfoldersevery'] = "aUt0 PRUn3 my Pm F0LDER5 3v3Ry:";
$lang['friendsonly'] = "fr13nd5 0NLY?";
$lang['globalstyles'] = "gl08@l S+yl3S";
$lang['forumstyles'] = "foRUM s+ylES";
$lang['youmustenteryourcurrentpasswd'] = "j00 Mu\$t 3nTer youR CuRrEN+ P4s\$W0rD";
$lang['youmustenteranewpasswd'] = "j00 Mus+ enT3R A n3W P4ssWORD";
$lang['youmustconfirmyournewpasswd'] = "j00 mu\$t ConpHirm y0ur nEW p@\$SW0RD";
$lang['profileentriesmustnotincludehtml'] = "pr0F1L3 entrIEs Must n0+ iNCLUd3 htMl";
$lang['failedtoupdateuserprofile'] = "f41l3d +0 uPDATe us3R ProF1L3";

// Polls (create_poll.php, poll_results.php) ---------------------------------------------

$lang['mustprovideanswergroups'] = "j00 mus+ pR0v1D3 s0me 4n\$w3R Gr0UPs";
$lang['mustprovidepolltype'] = "j00 Mu\$T pRoViDE 4 P0Ll Typ3";
$lang['mustprovidepollresultsdisplaytype'] = "j00 mu\$T prOviDE r3SULts d1\$PLay +Ype";
$lang['mustprovidepollvotetype'] = "j00 mu\$t prov1d3 4 poLl V0t3 +yPE";
$lang['mustprovidepollguestvotetype'] = "j00 mUsT SP3cifY 1F gUEsTs 5H0ulD 83 4LLoW3D To v0+3";
$lang['mustprovidepolloptiontype'] = "j00 mUsT Prov1d3 @ P0LL 0p+1ON typ3";
$lang['mustprovidepollchangevotetype'] = "j00 mU5T proViD3 4 p0ll ch4N93 V0+3 +yp3";
$lang['pollquestioncontainsinvalidhtml'] = "onE or mOr3 0f yOUR pOll qU3stioN5 COn+41ns Inv4l1D H+ml.";
$lang['pleaseselectfolder'] = "pl3@sE \$ELECT a f0LD3R";
$lang['mustspecifyvalues1and2'] = "j00 Mu5+ \$P3CiphY ValUES for 4nswER\$ 1 4ND 2";
$lang['tablepollmusthave2groups'] = "t48ul@r Phorm4+ PolLs mUs+ H4V3 PrECISelY +w0 v0T1Ng gROUp\$";
$lang['nomultivotetabulars'] = "tABuLar f0rm4+ p0Lls C4NN0T 83 MULt1-VO+3";
$lang['nomultivotepublic'] = "publ1C 8@Ll0+S C4NnO+ 83 muLTi-vo+e";
$lang['abletochangevote'] = "j00 wILL 83 @8le +0 CH@NG3 Y0ur voT3.";
$lang['abletovotemultiple'] = "j00 will b3 4bL3 t0 v0+3 mulTipL3 +Im3S.";
$lang['notabletochangevote'] = "j00 w1ll N0t BE 4ble to CH@ngE Y0Ur vo+3.";
$lang['pollvotesrandom'] = "n0+e: p0lL Vo+3s 4r3 r4nDoMly 9ener@+3d F0R PrEVIEW 0nlY.";
$lang['pollquestion'] = "p0lL QU3st10n";
$lang['possibleanswers'] = "po5\$1BlE 4N5W3rs";
$lang['enterpollquestionexp'] = "eN+3r +3H 4N\$w3rs f0R YOUR pOlL qUEs+i0n.. 1Ph yOUr P0Ll I\$ @ &quot;yEs/N0&quot; qUEsTiOn, siMplY 3n+3r &quot;y3s&quot; F0r 4N\$w3R 1 @ND &quot;No&quot; F0r 4N5w3r 2.";
$lang['numberanswers'] = "no. @N5W3Rs";
$lang['answerscontainHTML'] = "anSwEr\$ con+41n h+Ml (No+ INCLuD1nG 519n@+Ure)";
$lang['optionsdisplay'] = "anSwER\$ di5pl@Y +Ype";
$lang['optionsdisplayexp'] = "hOW sh0uld Th3 @N\$wer\$ BE PrEs3ntED?";
$lang['dropdown'] = "aS DROp-d0wn lI5+(\$)";
$lang['radios'] = "a5 @ \$Eri3S 0f R4di0 8UttoNs";
$lang['votechanging'] = "v0t3 CH4N91n9";
$lang['votechangingexp'] = "c4N 4 P3rS0n cH4ng3 His or HeR v0+3?";
$lang['guestvoting'] = "guE\$+ v0+1N9";
$lang['guestvotingexp'] = "c@n 9u3s+s V0+3 iN +h1\$ p0Ll?";
$lang['allowmultiplevotes'] = "aLLOw MUl+IpLe Vo+3s";
$lang['pollresults'] = "poll r3\$ULTs";
$lang['pollresultsexp'] = "h0W wouLD j00 L1K3 +0 D1spl4Y the r3suLts 0f yOUr poLL?";
$lang['pollvotetype'] = "p0ll v0t1ng +ypE";
$lang['pollvotesexp'] = "h0W \$h0ULD The PoLl bE conDUCteD?";
$lang['pollvoteanon'] = "anonYmously";
$lang['pollvotepub'] = "pu8l1c 8@llOt";
$lang['horizgraph'] = "h0riz0N+4L Gr@pH";
$lang['vertgraph'] = "vER+1C4l 9r4Ph";
$lang['tablegraph'] = "t48UL4R F0Rm4+";
$lang['polltypewarning'] = "<b>waRNing</b>: tH1\$ i5 @ pU8LiC 8@LL0T. y0ur N4M3 Will 83 Vi51BlE n3XT +o thE oPt1On j00 v0TE pHor.";
$lang['expiration'] = "eXPir@+I0N";
$lang['showresultswhileopen'] = "d0 J00 w4nT +O Sh0W rEsUlTs WHil3 +HE pOll i\$ oP3n?";
$lang['whenlikepollclose'] = "wh3n w0UlD j00 l1ke YoUr P0LL +o 4U+om@TiC@LlY cLo\$e?";
$lang['oneday'] = "on3 Day";
$lang['threedays'] = "tHRee D4Y\$";
$lang['sevendays'] = "s3V3n D@Ys";
$lang['thirtydays'] = "tHirty D4ys";
$lang['never'] = "neV3r";
$lang['polladditionalmessage'] = "addi+1on@l MES5@g3 (0pT1ON@l)";
$lang['polladditionalmessageexp'] = "d0 j00 w4nT To 1nClUDE 4n 4DD1+ion@l P0ST 4pH+3r tEh P0LL?";
$lang['mustspecifypolltoview'] = "j00 mu\$t SPEc1fy @ PoLl +o V13w.";
$lang['pollconfirmclose'] = "ar3 j00 SUR3 j00 w@n+ +0 CL053 th3 PHoLl0w1N9 p0LL?";
$lang['endpoll'] = "end POLL";
$lang['nobodyvotedclosedpoll'] = "n0Body Vo+ED";
$lang['votedisplayopenpoll'] = "%s 4ND %s H4V3 v0TED.";
$lang['votedisplayclosedpoll'] = "%s anD %s Vo+ED.";
$lang['nousersvoted'] = "n0 us3r5";
$lang['oneuservoted'] = "1 U5er";
$lang['xusersvoted'] = "%s us3rs";
$lang['noguestsvoted'] = "nO gu3st5";
$lang['oneguestvoted'] = "1 guEst";
$lang['xguestsvoted'] = "%s guEs+s";
$lang['pollhasended'] = "p0Ll h@\$ 3ndED";
$lang['youvotedforpolloptionsondate'] = "j00 v0+3D F0R %s ON %s";
$lang['thisisapoll'] = "thIs i\$ @ poLL. CL1CK To vIEW R3sulTs.";
$lang['editpoll'] = "ed1+ P0ll";
$lang['results'] = "rE5ulTs";
$lang['resultdetails'] = "r3\$ULt dE+4IL\$";
$lang['changevote'] = "cH4nGe V0TE";
$lang['pollshavebeendisabled'] = "p0Lls h4v3 b33n D1\$@8leD BY TEH phorUM oWNer.";
$lang['answertext'] = "an5w3r +3x+";
$lang['answergroup'] = "aNsWer Gr0up";
$lang['previewvotingform'] = "pR3ViEW Vo+iNg PH0RM";
$lang['viewbypolloption'] = "v1EW 8y PoLl 0PtIon";
$lang['viewbyuser'] = "v13w 8Y u\$3r";

// Profiles (profile.php) ----------------------------------------------

$lang['editprofile'] = "ed1+ propH1L3";
$lang['profileupdated'] = "pRof1l3 upd4t3d.";
$lang['profilesnotsetup'] = "the f0RUm OWNER h4S No+ 53+ Up pROf1les.";
$lang['ignoreduser'] = "iGn0reD U\$3r";
$lang['lastvisit'] = "l@5t VI\$1t";
$lang['userslocaltime'] = "u5er'S L0c4l tIM3";
$lang['userstatus'] = "s+4+uS";
$lang['useractive'] = "onLInE";
$lang['userinactive'] = "in4ctiV3 / opHpHL1n3";
$lang['totaltimeinforum'] = "toT4L +1m3";
$lang['longesttimeinforum'] = "lONGEst \$e\$SI0n";
$lang['sendemail'] = "s3ND 3ma1l";
$lang['sendpm'] = "s3ND pm";
$lang['visithomepage'] = "vI\$i+ h0Mep49E";
$lang['age'] = "a9E";
$lang['aged'] = "ag3d";
$lang['birthday'] = "b1RthD4Y";
$lang['registered'] = "re91\$tER3D";
$lang['findpostsmadebyuser'] = "fInd p05+5 m@D3 by %s";
$lang['findpostsmadebyme'] = "fiND po5+s m4d3 BY m3";
$lang['profilenotavailable'] = "pr0Ph1LE no+ @V@iLa8le.";
$lang['userprofileempty'] = "th1s u\$er h4\$ noT pH1LlED IN thE1r pRofiL3 Or i+ 1s \$3+ +0 PRIv@+E.";

// Registration (register.php) -----------------------------------------

$lang['newuserregistrationsarenotpermitted'] = "s0rry, N3w user r3915+r@+I0Ns @r3 n0+ @ll0W3D ri9H+ now. Pl3@s3 Ch3ck B4ck L4+3r.";
$lang['usernameinvalidchars'] = "useRN4me C@n Only C0n+@1N @-Z, 0-9, _ - Ch4r4C+3r\$";
$lang['usernametooshort'] = "u53rn4m3 mU\$T B3 @ miNiMUM 0f 2 CH@r@CTEr\$ lon9";
$lang['usernametoolong'] = "usern4me mU\$+ 83 4 m4ximUM Oph 15 CH@r4c+ER5 loN9";
$lang['usernamerequired'] = "a lo9on N4ME 1\$ REQU1R3d";
$lang['passwdmustnotcontainHTML'] = "p4SSwoRD MUs+ n0+ c0n+@iN HtMl +49s";
$lang['passwordinvalidchars'] = "p45\$W0rd C@n onLy coN+A1n a-z, 0-9, _ - ch4R4cter5";
$lang['passwdtooshort'] = "p4\$sworD mUst 83 4 mInIMUm oph 6 CH4R4c+Er5 l0N9";
$lang['passwdrequired'] = "a P@S\$W0Rd I\$ REqUiRED";
$lang['confirmationpasswdrequired'] = "a conPhirma+1oN P@\$SW0RD I\$ r3Qu1r3D";
$lang['nicknamerequired'] = "a niCkNaME iS REqUiR3d";
$lang['emailrequired'] = "an EM4il 4DDREs5 i\$ r3QU1R3D";
$lang['passwdsdonotmatch'] = "pa5\$W0rds DO No+ M@Tch";
$lang['usernamesameaspasswd'] = "uSErnAmE 4ND p@s5W0RD MU5+ b3 D1FFER3Nt";
$lang['usernameexists'] = "s0RRY, @ U53r wi+h tHaT n4M3 @lr3aDy Ex1\$T5";
$lang['successfullycreateduseraccount'] = "sUcC3\$SfULLy CR34+3D U53r aCC0Unt";
$lang['useraccountcreatedconfirmfailed'] = "y0ur us3r 4CCoUnT h@\$ 8eEn CR3@+3d 8U+ +3H ReQUIr3D C0NphirM4+IOn 3M4iL w4S n0+ \$En+. pl3aS3 Con+@C+ +hE phOrUM owneR tO r3c+iphY th1\$. 1n +hi5 meAN+im3 PL34\$3 CLiCk Teh coN+INU3 bu+t0N To LO91N 1N.";
$lang['useraccountcreatedconfirmsuccess'] = "y0uR u\$er acc0UnT H@s 833n Cre@TeD BU+ b3phOR3 J00 CAn 5T4r+ p0ST1n9 j00 muST COnPH1rM yOUr em4il 4DdrEss. pLe4Se ch3Ck YOUR 3m41L FOr 4 Link THA+ wILL 4Llow j00 +0 coNfirm yoUR @DDrE5\$.";
$lang['useraccountcreated'] = "yoUR u5Er acC0UNt h@s B3En CRE4+3D 5ucCESsPhULlY! CLiCK +3h cOnT1NU3 8U+toN 8eLoW +o l09in";
$lang['errorcreatinguserrecord'] = "erRoR CR3atINg U53R reCOrD";
$lang['userregistration'] = "u\$3r re9I\$+r@t1on";
$lang['registrationinformationrequired'] = "r3GistR4T1on INphorMAT1oN (r3qu1reD)";
$lang['profileinformationoptional'] = "prOf1l3 inFoRm4t10n (op+I0n@l)";
$lang['preferencesoptional'] = "prEfEr3nC3S (opT10nAl)";
$lang['register'] = "reg1\$+eR";
$lang['rememberpasswd'] = "rememB3R p455word";
$lang['birthdayrequired'] = "yoUR D4T3 0Ph B1RTH 1\$ r3qU1R3D or 15 inv4LID";
$lang['alwaysnotifymeofrepliestome'] = "n0tIPHy On R3PlY +0 mE";
$lang['notifyonnewprivatemessage'] = "no+1phy 0n nEW pr1V@TE M3SS49e";
$lang['popuponnewprivatemessage'] = "p0p Up on n3W Pr1V4tE mE\$s@gE";
$lang['automatichighinterestonpost'] = "au+om4t1C h1gh 1NTeR35+ 0n p0sT";
$lang['confirmpassword'] = "c0NPh1rm p4\$5w0RD";
$lang['invalidemailaddressformat'] = "inV@L1d 3M4il 4DDRESs f0rm4+";
$lang['moreoptionsavailable'] = "mOre prOpH1l3 4ND PR3F3R3nc3 0PT10Ns 4r3 4v@il@8LE 0Nc3 j00 r3GiS+3r";
$lang['textcaptchaconfirmation'] = "cOnphIrM4+i0N";
$lang['textcaptchaexplain'] = "t0 +eh r1gh+ is @ +3xt-C@PtCH4 iM49E. pl3453 +yP3 +h3 coDe J00 c4N S3e in +3H iM49e iNTo +3h inPu+ FiELd 83low i+.";
$lang['textcaptchaimgtip'] = "tHiS I\$ 4 C@PtcH4-PICTUR3. I+ 1\$ USED +0 pREvEnt 4ut0M4+iC R39i5+r4+1on";
$lang['textcaptchamissingkey'] = "a COnphiRM@+I0N C0dE Is rEqUiR3D.";
$lang['textcaptchaverificationfailed'] = "tExt-c4p+CHa ver1fIC@TiOn C0d3 w@5 InC0rrECt. Pl3453 R3-3nTER 1+.";
$lang['forumrules'] = "f0RUM RUl3s";
$lang['forumrulesnotification'] = "iN 0RD3r tO proCEED, j00 mUsT 49r3E w1+h TEh phoLl0wiNg rUl3S";
$lang['forumrulescheckbox'] = "i H4v3 R34d, 4ND 4GR3e +0 a8idE 8y +H3 phOrUm rUlE5.";
$lang['youmustagreetotheforumrules'] = "j00 mUst 49r33 +o th3 pH0RUm rUleS 8EF0r3 J00 c4n C0nt1nUe.";

// Recent visitors list  (visitor_log.php) -----------------------------

$lang['member'] = "m3M8ER";
$lang['searchforusernotinlist'] = "s3Arch foR 4 Us3R N0T In lIsT";
$lang['yoursearchdidnotreturnanymatches'] = "your \$3@rcH D1d n0T r3turn ANY M@+CH3S. try s1MpL1PHyin9 y0UR sE4RCH PAr4MEt3r\$ @ND try @94iN.";
$lang['hiderowswithemptyornullvalues'] = "h1D3 r0ws W1+h EmP+Y 0r nulL v@LUEs in \$3l3C+3d ColuMn\$";
$lang['showregisteredusersonly'] = "shOW RE9IsT3RED Us3rs oNlY (h1D3 gu3STs)";

// Relationships (user_rel.php) ----------------------------------------

$lang['relationships'] = "rel4t10n5hIp\$";
$lang['userrelationship'] = "us3r REl@+1ONSH1p";
$lang['userrelationships'] = "u\$3r R3L4T1oNsHiPs";
$lang['failedtoremoveselectedrelationships'] = "f@1L3D T0 rEm0v3 \$3l3ctED R3L4T10N\$HIp";
$lang['friends'] = "frI3NDs";
$lang['ignoredcompletely'] = "i9nored COMpLE+3ly";
$lang['relationship'] = "rEl4t10nshIP";
$lang['restorenickname'] = "r3sT0re U53r'S N1cknamE";
$lang['friend_exp'] = "uSer's P05+5 M4RK3d w1+h 4 &quot;FR1enD&quot; 1con.";
$lang['normal_exp'] = "u5ER'\$ PO5+S aPp3ar As n0rm4l.";
$lang['ignore_exp'] = "user'S P0\$+\$ @R3 HiDD3n.";
$lang['ignore_completely_exp'] = "thREADs @nD PosTs +o 0r fr0m U\$3R w1ll aPp34r D3lEtED.";
$lang['display'] = "d1\$Pl@y";
$lang['displaysig_exp'] = "user'\$ \$19N4+urE 1\$ D1SPl4yeD 0n tH31r P0\$+S.";
$lang['hidesig_exp'] = "u5Er'\$ 5igN@Tur3 1s h1ddEN 0n thEIr p0STs.";
$lang['cannotignoremod'] = "j00 C@nnoT I9NoR3 tHiS Us3r, @5 ThEY 4R3 4 MOD3ra+0R.";
$lang['previewsignature'] = "prev1Ew 5I9n@+Ure";

// Search (search.php) -------------------------------------------------

$lang['searchresults'] = "sE4rCH RESulTs";
$lang['usernamenotfound'] = "t3H Us3Rn@m3 j00 \$P3cifi3d 1N +h3 t0 oR pHRoM Ph13lD W@\$ no+ phOUnD.";
$lang['notexttosearchfor'] = "onE 0R @lL oF YoUR s34RCH k3yWorDS W3RE 1nv@liD. s34rCH K3YwOrDs mUs+ 8e n0 sh0r+eR Th4n %d Ch4r4C+ER\$, No l0n93r +H4n %d ch@r4CTEr\$ anD mUst n0t 4pp3@R In +h3 %s";
$lang['keywordscontainingerrors'] = "k3Ywords C0N+@inIng 3RroRs: %s";
$lang['mysqlstopwordlist'] = "mYSQl \$topw0RD l1ST";
$lang['foundzeromatches'] = "f0und: 0 m@+CHES";
$lang['found'] = "fOunD";
$lang['matches'] = "m@tCh3S";
$lang['prevpage'] = "previ0Us p@93";
$lang['findmore'] = "fInD morE";
$lang['searchmessages'] = "s34rCh M3ss@gE\$";
$lang['searchdiscussions'] = "s34rch D1SCU\$s1oN5";
$lang['find'] = "fInd";
$lang['additionalcriteria'] = "addITI0n@l Cr1+3Ri4";
$lang['searchbyuser'] = "sE4RCH 8y uSEr (0Pt10nal)";
$lang['folderbrackets_s'] = "f0Ld3r(\$)";
$lang['postedfrom'] = "p0STeD phRoM";
$lang['postedto'] = "pO5ted tO";
$lang['today'] = "tOd4y";
$lang['yesterday'] = "y3s+3rD4Y";
$lang['daybeforeyesterday'] = "d4y 83F0RE yE\$+ErD@y";
$lang['weekago'] = "%s w3Ek 4go";
$lang['weeksago'] = "%s w3eks 490";
$lang['monthago'] = "%s M0Nth 4Go";
$lang['monthsago'] = "%s MOn+H5 49o";
$lang['yearago'] = "%s YE@r a90";
$lang['beginningoftime'] = "b3ginniNg 0F T1M3";
$lang['now'] = "n0w";
$lang['lastpostdate'] = "laS+ P05+ Date";
$lang['numberofreplies'] = "nUmB3R of rEpl13s";
$lang['foldername'] = "folDer NAME";
$lang['authorname'] = "auTh0r naME";
$lang['decendingorder'] = "n3wEsT phIr5+";
$lang['ascendingorder'] = "oLd3\$+ phir\$+";
$lang['keywords'] = "k3yW0rD5";
$lang['sortby'] = "soR+ 8y";
$lang['sortdir'] = "s0r+ dir";
$lang['sortresults'] = "s0R+ r3sUlTs";
$lang['groupbythread'] = "gR0up by +HrE@d";
$lang['postsfromuser'] = "pOSTs Fr0m U\$3r";
$lang['poststouser'] = "pO\$+S t0 usEr";
$lang['poststoandfromuser'] = "pos+5 to 4ND Fr0M UsER";
$lang['searchfrequencyerror'] = "j00 C@N oNly se4rCH oNCE 3v3Ry %s s3coND\$. plE4\$3 tRY a9@IN l@+ER.";
$lang['searchsuccessfullycompleted'] = "sE4RCH 5UCcesspHULLy COMpl3tED. %s";
$lang['clickheretoviewresults'] = "cLIck HER3 t0 View r3suL+\$.";

// Search Popup (search_popup.php) -------------------------------------

$lang['select'] = "s3L3C+";
$lang['searchforthread'] = "s34rCH Phor ThR34d";
$lang['mustspecifytypeofsearch'] = "j00 musT \$P3cipHy tYp3 0Ph SE4rCh TO PERphoRM";
$lang['unkownsearchtypespecified'] = "uNKN0wn 534RCH +YpE \$P3CifiED";
$lang['mustentersomethingtosearchfor'] = "j00 mU\$+ 3n+3r sOmetHiNg to se4rch PHOr";

// Start page (start_left.php) -----------------------------------------

$lang['recentthreads'] = "rec3nT Thr3@ds";
$lang['startreading'] = "s+@R+ rE4D1n9";
$lang['threadoptions'] = "thr34D OptionS";
$lang['editthreadoptions'] = "eD1t Thr3ad opt10N\$";
$lang['morevisitors'] = "mOr3 V1SI+0Rs";
$lang['forthcomingbirthdays'] = "f0R+hCOminG 81r+HD@ys";

// Start page (start_main.php) -----------------------------------------

$lang['editstartpage_help'] = "j00 caN eD1+ Thi\$ p4g3 fR0M TEh 4DM1N InTErF4C3";
$lang['uploadstartpage'] = "uPlO4d 5+@RT p49E (%s)";
$lang['invalidfiletypeerror'] = "f1l3 +yPE n0+ SUPP0r+ed. J00 C@N 0NLY UsE %s f1L3s 4S Your \$+@R+ Pa93.";

// Thread navigation (thread_list.php) ---------------------------------

$lang['newdiscussion'] = "n3W D1scUS\$10N";
$lang['createpoll'] = "cr3@TE poll";
$lang['search'] = "s34rCh";
$lang['searchagain'] = "se4rCh 49@iN";
$lang['alldiscussions'] = "all di\$cus\$10ns";
$lang['unreaddiscussions'] = "unr3ad D1SCUS\$1ON\$";
$lang['unreadtome'] = "unREaD &quot;t0: ME&quot;";
$lang['todaysdiscussions'] = "t0D@y's DisCUs\$10NS";
$lang['2daysback'] = "2 D4YS 84CK";
$lang['7daysback'] = "7 d@y\$ 8aCk";
$lang['highinterest'] = "hI9H in+3rEst";
$lang['unreadhighinterest'] = "uNR34d h19H 1n+3resT";
$lang['iverecentlyseen'] = "i've R3C3ntly 53En";
$lang['iveignored'] = "i'VE 1gn0RED";
$lang['byignoredusers'] = "by I9norED Users";
$lang['ivesubscribedto'] = "i'V3 su8sCrI83d To";
$lang['startedbyfriend'] = "s+@r+3d 8y pHrIEnd";
$lang['unreadstartedbyfriend'] = "unR3@D 5+d by phR13nD";
$lang['startedbyme'] = "s+@RT3D BY M3";
$lang['unreadtoday'] = "uNRe4D t0d@y";
$lang['deletedthreads'] = "dEl3t3D Thre@D5";
$lang['goexcmark'] = "g0!";
$lang['folderinterest'] = "f0LD3r 1NTER3s+";
$lang['postnew'] = "poS+ N3w";
$lang['currentthread'] = "curr3Nt +hrE@D";
$lang['highinterest'] = "h19h intER3sT";
$lang['markasread'] = "m4RK as R34d";
$lang['next50discussions'] = "n3xt 50 DisCuS\$i0Ns";
$lang['visiblediscussions'] = "vI\$i8LE DI\$cus5I0ns";
$lang['selectedfolder'] = "s3L3c+ED ph0LD3r";
$lang['navigate'] = "n@V1G4+3";
$lang['couldnotretrievefolderinformation'] = "ther3 4R3 n0 f0LDEr5 @v@il4Bl3.";
$lang['nomessagesinthiscategory'] = "no m3ss493s iN +hI\$ C4+390ry. pLE4\$3 sEl3Ct @n0thER, or %s phor 4ll +hREad\$";
$lang['clickhere'] = "cLiCk H3RE";
$lang['prev50threads'] = "pREV1ous 50 ThrEADs";
$lang['next50threads'] = "n3Xt 50 +hr34d\$";
$lang['nextxthreads'] = "nEX+ %s +hr34Ds";
$lang['threadstartedbytooltip'] = "thR3@d #%s ST4rteD BY %s. V13WED %s";
$lang['threadviewedonetime'] = "1 +1ME";
$lang['threadviewedtimes'] = "%d T1m3s";
$lang['unreadthread'] = "uNre@D tHR34d";
$lang['readthread'] = "re@D thRe4d";
$lang['unreadmessages'] = "unr34d m3SS49e\$";
$lang['subscribed'] = "su85cri8ED";
$lang['ignorethisfolder'] = "i9N0RE tH1\$ foLDER";
$lang['stopignoringthisfolder'] = "s+op 1gn0r1nG +hi\$ PHOlDER";
$lang['stickythreads'] = "st1CKy +hrEaD\$";
$lang['mostunreadposts'] = "moSt Unr34D P0\$+s";
$lang['onenew'] = "%d new";
$lang['manynew'] = "%d N3W";
$lang['onenewoflength'] = "%d N3w 0F %d";
$lang['manynewoflength'] = "%d neW 0ph %d";
$lang['ignorefolderconfirm'] = "are j00 \$ur3 J00 w4NT +0 1GN0re +Hi\$ pHOLDER?";
$lang['unignorefolderconfirm'] = "aRe j00 \$ure j00 w4N+ +o s+op 19n0R1ng +His PholDEr?";
$lang['confirmmarkasread'] = "are j00 sur3 J00 w@N+ +o m4rK T3H s3leC+ED tHRE4DS @s RE4D?";
$lang['successfullymarkreadselectedthreads'] = "sUCCE\$\$FULLy m4rk3d \$3lEcTEd +HR34D\$ 4s REAd";
$lang['failedtomarkselectedthreadsasread'] = "f@1l3D +O m4rk S3l3C+ED ThRE4DS 45 rE4D";
$lang['gotofirstpostinthread'] = "g0 +o PHIR5+ P0\$t In +hRE4D";
$lang['gotolastpostinthread'] = "g0 +o L4\$+ post 1N tHrE4d";
$lang['viewmessagesinthisfolderonly'] = "vi3w M3ss4g3s In +Hi\$ PhoLDER oNlY";
$lang['shownext50threads'] = "sH0w n3xt 50 +HR34Ds";
$lang['showprev50threads'] = "sh0W prEvi0Us 50 ThRE4d5";
$lang['createnewdiscussioninthisfolder'] = "cRe4+3 nEw DIsCU\$S1on in +h1S fOlDER";
$lang['nomessages'] = "nO ME\$S493S";

// HTML toolbar (htmltools.inc.php) ------------------------------------
$lang['bold'] = "b0LD";
$lang['italic'] = "i+4l1C";
$lang['underline'] = "uNderlin3";
$lang['strikethrough'] = "stRiK3+hRoU9H";
$lang['superscript'] = "sUpeR5CRiP+";
$lang['subscript'] = "sUBsCR1P+";
$lang['leftalign'] = "l3F+-4L1gn";
$lang['center'] = "c3n+3r";
$lang['rightalign'] = "ri9ht-4l19n";
$lang['numberedlist'] = "nUm8ErED Lis+";
$lang['list'] = "lIsT";
$lang['indenttext'] = "iNdEnt +Ext";
$lang['code'] = "cODE";
$lang['quote'] = "qUote";
$lang['spoiler'] = "spO1LER";
$lang['horizontalrule'] = "hOr1zon+@l RUl3";
$lang['image'] = "im4GE";
$lang['hyperlink'] = "hyP3rlink";
$lang['noemoticons'] = "d1S48L3 Em0+iC0n\$";
$lang['fontface'] = "f0nT PhaC3";
$lang['size'] = "sIZe";
$lang['colour'] = "c0L0ur";
$lang['red'] = "r3d";
$lang['orange'] = "oR4n93";
$lang['yellow'] = "y3lLow";
$lang['green'] = "gr33n";
$lang['blue'] = "bLu3";
$lang['indigo'] = "indig0";
$lang['violet'] = "v1ol3T";
$lang['white'] = "wHI+3";
$lang['black'] = "bl@ck";
$lang['grey'] = "gR3Y";
$lang['pink'] = "p1NK";
$lang['lightgreen'] = "li9ht gr33n";
$lang['lightblue'] = "l19ht 8LU3";

// Forum Stats (messages.inc.php - messages_forum_stats()) -------------

$lang['forumstats'] = "f0rum s+@+S";
$lang['usersactiveinthepasttimeperiod'] = "%s AC+1v3 iN +h3 P@\$T %s.";

$lang['numactiveguests'] = "<b>%s</b> Gu3\$+S";
$lang['oneactiveguest'] = "<b>1</b> GU3St";
$lang['numactivemembers'] = "<b>%s</b> M3m8Er5";
$lang['oneactivemember'] = "<b>1</b> mem83r";
$lang['numactiveanonymousmembers'] = "<b>%s</b> 4N0NyM0us m3MbEr\$";
$lang['oneactiveanonymousmember'] = "<b>1</b> @n0nym0Us MEM8ER";

$lang['numthreadscreated'] = "<b>%s</b> +hR34DS";
$lang['onethreadcreated'] = "<b>1</b> +hr3@d";
$lang['numpostscreated'] = "<b>%s</b> pos+5";
$lang['onepostcreated'] = "<b>1</b> po5+";

$lang['younormal'] = "j00";
$lang['youinvisible'] = "j00 (1nv1\$i8le)";
$lang['viewcompletelist'] = "v1EW C0mpLE+e l1ST";
$lang['ourmembershavemadeatotalofnumthreadsandnumposts'] = "oUr memBER\$ h4Ve m4d3 @ +o+4L 0f %s 4ND %s.";
$lang['longestthreadisthreadnamewithnumposts'] = "l0N93s+ Thre4d is <b>%s</b> WI+h %s.";
$lang['therehavebeenxpostsmadeinthelastsixtyminutes'] = "thERE Have 83en <b>%s</b> P0\$ts m@D3 iN TEH l4S+ 60 m1NUT3s.";
$lang['therehasbeenonepostmadeinthelastsxityminutes'] = "th3r3 H@s 8E3n <b>1</b> po5+ M4DE iN +3H l4\$+ 60 M1nu+3S.";
$lang['mostpostsevermadeinasinglesixtyminuteperiodwasnumposts'] = "mo\$+ p05+S 3v3r m4D3 in @ \$iNGL3 60 M1Nute PEr10D Is <b>%s</b> 0n %s.";
$lang['wehavenumregisteredmembersandthenewestmemberismembername'] = "we H@v3 <b>%s</b> R39is+ER3D m3mB3rs @ND teh n3WEst mEm8er i\$ <b>%s</b>.";
$lang['wehavenumregisteredmember'] = "w3 h@v3 %s rEGis+3R3d M3m8er5.";
$lang['wehaveoneregisteredmember'] = "wE HaVE 0N3 r3gis+Er3d m3MB3r.";
$lang['mostuserseveronlinewasnumondate'] = "m0s+ u5Ers 3VEr oNl1ne was <b>%s</b> on %s.";
$lang['statsdisplayenabled'] = "s+@+s D1SPl4Y EN@8led";

// Thread Options (thread_options.php) ---------------------------------

$lang['updatessavedsuccessfully'] = "uPd4+3S s4VED 5UCcEssphuLlY";
$lang['useroptions'] = "u\$3r oP+I0Ns";
$lang['markedasread'] = "m4RKED 4\$ r34d";
$lang['postsoutof'] = "pOs+\$ out 0PH";
$lang['interest'] = "inter3\$+";
$lang['closedforposting'] = "cLosed pHor po\$+1n9";
$lang['locktitleandfolder'] = "l0Ck +I+L3 4Nd F0lDEr";
$lang['deletepostsinthreadbyuser'] = "deletE p0Sts iN +hr34D 8Y Us3R";
$lang['deletethread'] = "deLEtE +HR34d";
$lang['permenantlydelete'] = "p3rm4nEn+LY d3l3T3";
$lang['movetodeleteditems'] = "m0ve +0 dEl3T3d thR34d5";
$lang['undeletethread'] = "unDel3Te THR34d";
$lang['threaddeletedpermenantly'] = "tHr34D DEL3TEd p3Rm4NentLy. C@nn0+ UnDeLET3.";
$lang['markasunread'] = "m4RK a5 UnR34D";
$lang['makethreadsticky'] = "m4Ke Thre4d S+Icky";
$lang['threareadstatusupdated'] = "tHR3Ad RE4d st@tu5 updA+3d \$ucCEssFuLLy";
$lang['interestupdated'] = "thrE4d 1Nt3RES+ 5+a+U5 upD4ted SuCc3SSFully";
$lang['failedtoupdatethreadreadstatus'] = "fA1Led +0 upD4+E thREAd rE4d \$T4+uS";
$lang['failedtoupdatethreadinterest'] = "f4ILeD T0 uPDa+E +hrE4d InTer3st";
$lang['failedtorenamethread'] = "f@1L3d +o r3n4m3 thr34D";
$lang['failedtomovethread'] = "faIl3D +0 movE tHr3ad +0 sPeCIpHI3d foLdER";
$lang['failedtoupdatethreadstickystatus'] = "f41l3D TO UPd@+3 thR34d sticKY S+a+Us";
$lang['failedtoupdatethreadclosedstatus'] = "f4iL3d To UpD@+3 tHR34d cLo\$eD \$t4TU5";
$lang['failedtoupdatethreadlockstatus'] = "fa1LEd TO UpD@tE thre4D LoCk S+@+U\$";
$lang['failedtodeletepostsbyuser'] = "f4ILEd T0 DEL3tE PoSts 8Y \$EL3c+eD U\$3r";
$lang['failedtodeletethread'] = "fa1L3d T0 dEL3T3 thr34d.";
$lang['failedtoundeletethread'] = "f4il3D tO uN-DEL3+3 +hRe4d";

// Dictionary (dictionary.php) -----------------------------------------

$lang['dictionary'] = "d1C+ionAry";
$lang['spellcheck'] = "sp3ll Ch3CK";
$lang['notindictionary'] = "n0+ in D1C+I0N@rY";
$lang['changeto'] = "ch@n93 to";
$lang['restartspellcheck'] = "r3\$+4RT";
$lang['cancelchanges'] = "c@nCEl cH4NG3S";
$lang['initialisingdotdotdot'] = "in1T1ALIs1N9...";
$lang['spellcheckcomplete'] = "spell ChEcK Is C0mPl3+3. T0 rESt@R+ \$p3lL cheCk CL1Ck R3s+4rT 8UTton 83low.";
$lang['spellcheck'] = "sp3Ll CHECK";
$lang['noformobj'] = "no form 0bJEct sp3c1fi3D Ph0r retURn +3XT";
$lang['bodytext'] = "b0DY +3X+";
$lang['ignore'] = "i9n0RE";
$lang['ignoreall'] = "iGnorE 4lL";
$lang['change'] = "ch4ngE";
$lang['changeall'] = "ch@nGE 4Ll";
$lang['add'] = "adD";
$lang['suggest'] = "sUg9Es+";
$lang['nosuggestions'] = "(n0 SuGg3s+1on\$)";
$lang['cancel'] = "c4nceL";
$lang['dictionarynotinstalled'] = "nO d1CTi0n4rY H4s 8EEN iN5+4lL3D. PlE4\$3 C0n+@Ct +HE ph0rum oWN3R To rEm3dy th1s.";

// Permissions keys ----------------------------------------------------

$lang['postreadingallowed'] = "p0sT re4d1NG @LlOweD";
$lang['postcreationallowed'] = "pOs+ CR34+1on @lL0W3D";
$lang['threadcreationallowed'] = "tHr3Ad cRE4+1on @lL0w3d";
$lang['posteditingallowed'] = "p0S+ eD1tiN9 4llOw3d";
$lang['postdeletionallowed'] = "pO\$+ D3L3tiOn aLlOw3d";
$lang['attachmentsallowed'] = "a++4ChMEnTs @lLoW3D";
$lang['htmlpostingallowed'] = "hTml P0\$+inG 4LlOw3D";
$lang['signatureallowed'] = "s19nATUR3 4ll0wED";
$lang['guestaccessallowed'] = "gu3s+ 4CCEss @lLow3d";
$lang['postapprovalrequired'] = "pOst 4PpRoV@L r3qu1R3d";

// RSS feeds gubbins

$lang['rssfeed'] = "r\$\$ fE3D";
$lang['every30mins'] = "everY 30 miNUTEs";
$lang['onceanhour'] = "oNCE @N hoUR";
$lang['every6hours'] = "every 6 h0UR\$";
$lang['every12hours'] = "eV3ry 12 H0ur\$";
$lang['onceaday'] = "onc3 @ D4y";
$lang['rssfeeds'] = "r\$\$ fE3Ds";
$lang['feedname'] = "fE3D n@ME";
$lang['feedfoldername'] = "f33D pholD3R N4m3";
$lang['feedlocation'] = "f33d l0C4+10N";
$lang['threadtitleprefix'] = "tHR34D T1Tl3 pr3fix";
$lang['feednameandlocation'] = "f33d n4ME 4nd L0C4tiON";
$lang['feedsettings'] = "f3eD \$3tt1NG\$";
$lang['updatefrequency'] = "upd4+E FrEqU3nCy";
$lang['rssclicktoreadarticle'] = "clICK HER3 to R3@D tH1\$ @rT1cLE";
$lang['addnewfeed'] = "add neW Ph3eD";
$lang['editfeed'] = "ed1t FEeD";
$lang['feeduseraccount'] = "f3ED USEr 4Ccount";
$lang['noexistingfeeds'] = "n0 Ex1s+1n9 rss F33d\$ PHoUnd. +0 4dD 4 fEED ClICK TEh '4DD NEw' but+on BeL0w";
$lang['rssfeedhelp'] = "h3R3 j00 C@n \$3tuP soME rs\$ FEEd5 pHoR 4UToM4tiC pR0paG4+10N 1N+0 y0ur phoRUm. ThE i+3ms FRoM +h3 r\$s fE3DS j00 4dD WiLl 83 CRE4T3D as +Hr34DS WhICH U\$ers C@N REPly +0 4s IF +h3y wEr3 noRM@L p05+5. th3 rSs f3ed mU5+ bE 4Cces51BLE v14 HTtP 0r I+ wIll N0T w0rk.";
$lang['mustspecifyrssfeedname'] = "mU\$t Sp3ciphY Rss Ph3ed N@ME";
$lang['mustspecifyrssfeeduseraccount'] = "mU\$+ \$p3CiPHy R\$S Ph3eD us3R @CCOUNt";
$lang['mustspecifyrssfeedfolder'] = "mU5t sp3ciphY rSs F3ed pH0LD3r";
$lang['mustspecifyrssfeedurl'] = "musT \$P3ciFY Rss f3ed URl";
$lang['mustspecifyrssfeedupdatefrequency'] = "mUST sp3CIFy rsS F3ED UPD4+3 Fr3QU3nCy";
$lang['unknownrssuseraccount'] = "uNkn0wn rss U\$3r @cCOUNt";
$lang['rssfeedsupportshttpurlsonly'] = "rSs ph3eD suPpOrTs HT+p UrLs 0nLY. S3CURE FE3DS (htTps://) @re N0+ 5UPPor+3d.";
$lang['rssfeedurlformatinvalid'] = "rSS fE3d Url Phorm@+ iS iNv4l1D. uRl mUS+ inCLUDE \$ch3ME (E.9. HTTp://) @nD @ ho\$+n4m3 (3.g. wWW.H0StN4m3.COm).";
$lang['rssfeeduserauthentication'] = "r\$S F33D do3\$ n0T sUpP0Rt H+tP UsEr 4uthENt1c4+i0N";
$lang['successfullyremovedselectedfeeds'] = "sUcCEs\$fullY R3M0v3D s3L3C+ED f3eDs";
$lang['successfullyaddedfeed'] = "sUCCES\$fUlly 4ddeD NEW Ph3ed";
$lang['successfullyeditedfeed'] = "sucC3\$SFUlly 3diTED FEED";
$lang['failedtoremovefeeds'] = "fail3D to rEM0V3 \$Om3 0r 4Ll oPh tEH \$el3CTeD F3ED5";
$lang['failedtoaddnewrssfeed'] = "f4Il3d +0 4DD N3W Rs5 ph3eD";
$lang['failedtoupdaterssfeed'] = "f4IL3d +o UpD@+3 R\$s f33D";
$lang['rssstreamworkingcorrectly'] = "rSS stRE4m 4pP34rs TO 8e worKiNg c0rr3C+lY";
$lang['rssstreamnotworkingcorrectly'] = "r\$s sTrE4M WAs 3MPTy or C0ulD n0+ Be f0und";
$lang['invalidfeedidorfeednotfound'] = "iNv4L1D ph3eD 1D oR fEED n0t pH0unD";

// PM Export Options

$lang['pmexportastype'] = "eXport 4s tyP3";
$lang['pmexporthtml'] = "h+ml";
$lang['pmexportxml'] = "xml";
$lang['pmexportplaintext'] = "pL4IN +3xt";
$lang['pmexportmessagesas'] = "eXp0r+ M3Ss4gEs 4S";
$lang['pmexportonefileforallmessages'] = "oN3 PH1l3 f0r @lL mesS49E\$";
$lang['pmexportonefilepermessage'] = "on3 ph1l3 p3r m3S\$4gE";
$lang['pmexportattachments'] = "exP0R+ aT+@CHMEN+5";
$lang['pmexportincludestyle'] = "iNclUd3 phoRUm \$+Yl3 sH3E+";
$lang['pmexportwordfilter'] = "apply wOrD Fil+3r +0 MES\$4ges";

// Thread merge / split options

$lang['threadhasbeensplit'] = "tHR34D H4S B33N sPlI+";
$lang['threadhasbeenmerged'] = "thr34D hAs bEEn mer9eD";
$lang['mergesplitthread'] = "mEr9e / splIT ThRE4D";
$lang['mergewiththreadid'] = "m3RGE Wi+h +hr34D iD:";
$lang['postsinthisthreadatstart'] = "pOsts In +hi\$ tHr3ad @+ 5+4rt";
$lang['postsinthisthreadatend'] = "p0S+s In th1\$ +Hr34d at eND";
$lang['reorderpostsintodateorder'] = "re-orD3r po\$+s int0 Da+3 orDER";
$lang['splitthreadatpost'] = "sPL1+ +hR3aD @+ po\$+:";
$lang['selectedpostsandrepliesonly'] = "s3LECTEd p05+ 4nd R3Pl13s 0NLy";
$lang['selectedandallfollowingposts'] = "sEl3C+3D 4nd 4Ll pH0llOWIng posts";

$lang['threadmovedhere'] = "h3R3";

$lang['thisthreadhasmoved'] = "<b>tHR34D5 M3rg3D:</b> +h1S thre4D h4s m0VED %s";
$lang['thisthreadwasmergedfrom'] = "<b>thre4D\$ mERG3D:</b> +hi\$ THre4d w4s m3R93D PHrom %s";
$lang['somepostsinthisthreadhavebeenmoved'] = "<b>thre4d spl1+:</b> SomE Po5+s In th1S +hrEaD H@V3 83en m0veD %s";
$lang['somepostsinthisthreadweremovedfrom'] = "<b>thRE4D spLI+:</b> \$0m3 pO\$+s IN Th1\$ +Hr34D wER3 m0v3D PhR0M %s";

$lang['thisposthasbeenmoved'] = "<b>tHRE4d spli+:</b> +HIs p05+ h@\$ 8EEN m0v3D %s";

$lang['invalidfunctionarguments'] = "iNvalID PhUNC+ioN aRgUM3NTS";
$lang['couldnotretrieveforumdata'] = "c0ulD N0T r3+R13ve f0rUm D4+4";
$lang['cannotmergepolls'] = "oN3 0R morE +hR34ds 1\$ @ P0LL. J00 C4nn0t MErge PoLl\$";
$lang['couldnotretrievethreaddatamerge'] = "cOuLD no+ rETRI3vE thre4D D4+@ phROm On3 or mORe tHR3@Ds";
$lang['couldnotretrievethreaddatasplit'] = "c0uld NoT R3TrI3Ve +hrE@D D4+@ pHROm S0UrCE +HR34D";
$lang['couldnotretrievepostdatamerge'] = "c0ULD NO+ rETrIEV3 P0ST D@+4 Fr0M 0n3 or mOrE +hR3AD\$";
$lang['couldnotretrievepostdatasplit'] = "c0ulD NoT Re+Ri3vE Po\$+ d@+@ PhR0M 50urC3 +hR34D";
$lang['failedtocreatenewthreadformerge'] = "f4IL3D +o cr34+3 nEw +HrEad F0R m3rg3";
$lang['failedtocreatenewthreadforsplit'] = "f@il3D t0 CR34+3 n3W +hR34D F0R SPL1+";

// Thread subscriptions

$lang['threadsubscriptions'] = "thre4D \$u8\$CRIP+iOn\$";
$lang['couldnotupdateinterestonthread'] = "c0ULD nOt UpDA+E InTEr3S+ oN tHre@D '%s'";
$lang['threadinterestsupdatedsuccessfully'] = "thre4D 1ntEr3S+s UPD@+ED sUCcessfULly";
$lang['nothreadsubscriptions'] = "j00 4r3 n0+ \$uBSCr18eD t0 ANy +Hr34D\$.";
$lang['resetselected'] = "rEsE+ \$3lEC+3D";
$lang['allthreadtypes'] = "alL +HR34D typ3S";
$lang['ignoredthreads'] = "igN0r3d thrE4ds";
$lang['highinterestthreads'] = "hI9h InTER3St +HrE4ds";
$lang['subscribedthreads'] = "su8sCr183D ThRe4ds";
$lang['currentinterest'] = "curr3n+ In+3REs+";

// Browseable user profiles

$lang['youcanonlyaddthreecolumns'] = "j00 C4n only @DD 3 coLUMNs. +o 4dd @ NEW COLUMn CLo\$3 4N Ex1\$+iNG oN3";
$lang['columnalreadyadded'] = "j00 h@ve 4Lr3adY 4DD3d +hIs coLUmN. 1F J00 w4N+ +O REMoVE i+ ClICK 1+'\$ cl0SE BU++0n";

?>
