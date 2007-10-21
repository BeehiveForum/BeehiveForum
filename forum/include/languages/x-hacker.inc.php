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

/* $Id: x-hacker.inc.php,v 1.257 2007-10-21 18:41:07 decoyduck Exp $ */

// British English language file

// Language character set and text direction options -------------------

$lang['_isocode'] = "en";
$lang['_textdir'] = "ltr";

// Months --------------------------------------------------------------

$lang['month'][1]  = "j@Nu@ry";
$lang['month'][2]  = "febrU4Ry";
$lang['month'][3]  = "m4RcH";
$lang['month'][4]  = "aPr1L";
$lang['month'][5]  = "m@y";
$lang['month'][6]  = "juNE";
$lang['month'][7]  = "jULy";
$lang['month'][8]  = "au9us+";
$lang['month'][9]  = "s3P+em83R";
$lang['month'][10] = "oc+O8Er";
$lang['month'][11] = "nOVEMBer";
$lang['month'][12] = "d3c3mBER";

$lang['month_short'][1]  = "j4N";
$lang['month_short'][2]  = "feb";
$lang['month_short'][3]  = "m4r";
$lang['month_short'][4]  = "aPr";
$lang['month_short'][5]  = "m4Y";
$lang['month_short'][6]  = "jUn";
$lang['month_short'][7]  = "jUL";
$lang['month_short'][8]  = "au9";
$lang['month_short'][9]  = "sEp";
$lang['month_short'][10] = "oCT";
$lang['month_short'][11] = "nov";
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

$lang['date_periods']['year']   = "%s YE4r";
$lang['date_periods']['month']  = "%s moN+H";
$lang['date_periods']['week']   = "%s W3ek";
$lang['date_periods']['day']    = "%s day";
$lang['date_periods']['hour']   = "%s HoUr";
$lang['date_periods']['minute'] = "%s M1nu+3";
$lang['date_periods']['second'] = "%s \$3c0ND";

// As above but plurals (2 years vs. 1 year, etc.)

$lang['date_periods_plural']['year']   = "%s YE4R5";
$lang['date_periods_plural']['month']  = "%s M0n+h5";
$lang['date_periods_plural']['week']   = "%s W3Ek\$";
$lang['date_periods_plural']['day']    = "%s DAys";
$lang['date_periods_plural']['hour']   = "%s HoUr5";
$lang['date_periods_plural']['minute'] = "%s minu+3\$";
$lang['date_periods_plural']['second'] = "%s \$eC0nDs";

// Short hand periods (example: 1y, 2m, 3w, 4d, 5hr, 6min, 7sec)

$lang['date_periods_short']['year']   = "%sy";    // 1y
$lang['date_periods_short']['month']  = "%sM";    // 2m
$lang['date_periods_short']['week']   = "%sw";    // 3w
$lang['date_periods_short']['day']    = "%sd";    // 4d
$lang['date_periods_short']['hour']   = "%sHR";   // 5hr
$lang['date_periods_short']['minute'] = "%sM1n";  // 6min
$lang['date_periods_short']['second'] = "%s5EC";  // 7sec

// Common words --------------------------------------------------------

$lang['percent'] = "pERC3Nt";
$lang['average'] = "aV3R4G3";
$lang['approve'] = "apprOV3";
$lang['banned'] = "b@nn3D";
$lang['locked'] = "l0ck3d";
$lang['add'] = "aDd";
$lang['advanced'] = "adV4ncED";
$lang['active'] = "aCt1v3";
$lang['style'] = "s+YL3";
$lang['go'] = "gO";
$lang['folder'] = "f0ld3R";
$lang['ignoredfolder'] = "ign0rED pHolD3R";
$lang['folders'] = "f0ldEr\$";
$lang['thread'] = "tHRE4d";
$lang['threads'] = "thr34Ds";
$lang['threadlist'] = "tHre4d Lis+";
$lang['message'] = "m3S\$@gE";
$lang['messagenumber'] = "m3S\$@gE nUmBeR";
$lang['from'] = "frOM";
$lang['to'] = "to";
$lang['all_caps'] = "aLl";
$lang['of'] = "of";
$lang['reply'] = "rEPly";
$lang['forward'] = "f0rw4rD";
$lang['replyall'] = "rePly +0 AlL";
$lang['pm_reply'] = "r3PLY @s pm";
$lang['delete'] = "d3l3+E";
$lang['deleted'] = "d3l3teD";
$lang['edit'] = "ed1T";
$lang['privileges'] = "pR1vil39eS";
$lang['ignore'] = "i9N0RE";
$lang['normal'] = "norm4l";
$lang['interested'] = "inT3REstED";
$lang['subscribe'] = "su8scrIbE";
$lang['apply'] = "aPpLY";
$lang['download'] = "d0Wnl0@d";
$lang['save'] = "s4v3";
$lang['update'] = "uPD@tE";
$lang['cancel'] = "c4NCEL";
$lang['retry'] = "rE+ry";
$lang['continue'] = "cOn+1NUE";
$lang['attachment'] = "aT+4cHmEnT";
$lang['attachments'] = "a+TaCHMen+s";
$lang['imageattachments'] = "iM49e @++4chMEnTs";
$lang['filename'] = "f1l3n@m3";
$lang['dimensions'] = "d1mEN\$I0ns";
$lang['downloadedxtimes'] = "d0WNL0@d3D: %d +iM3S";
$lang['downloadedonetime'] = "dOWNLo4dED: 1 +1M3";
$lang['size'] = "s1z3";
$lang['viewmessage'] = "v13w m3Ss4ge";
$lang['deletethumbnails'] = "d3lE+3 +humBNa1Ls";
$lang['logon'] = "l0g0n";
$lang['more'] = "mOR3";
$lang['recentvisitors'] = "r3c3nt Vis1+or\$";
$lang['username'] = "u\$3rn4M3";
$lang['clear'] = "cL34R";
$lang['action'] = "acTion";
$lang['unknown'] = "unknown";
$lang['none'] = "nOn3";
$lang['preview'] = "pR3viEw";
$lang['post'] = "poST";
$lang['posts'] = "pO5+s";
$lang['change'] = "ch4n9E";
$lang['yes'] = "yeS";
$lang['no'] = "no";
$lang['signature'] = "s19n4+urE";
$lang['signaturepreview'] = "s19N4TUr3 pr3V13w";
$lang['signatureupdated'] = "sI9n@+Ur3 upD4+3d";
$lang['signatureupdatedforallforums'] = "s19n4tur3 upDAtED PhOr 4ll ph0RUm5";
$lang['back'] = "b4ck";
$lang['subject'] = "sU8j3C+";
$lang['close'] = "cLOs3";
$lang['name'] = "n4m3";
$lang['description'] = "d3SCR1P+i0N";
$lang['date'] = "dAte";
$lang['view'] = "v13W";
$lang['enterpasswd'] = "eN+3r p@5Sw0RD";
$lang['passwd'] = "paSsw0rd";
$lang['ignored'] = "i9n0rED";
$lang['guest'] = "gue\$+";
$lang['next'] = "n3X+";
$lang['prev'] = "pR3v1ous";
$lang['others'] = "oThEr5";
$lang['nickname'] = "n1cknAmE";
$lang['emailaddress'] = "em@1L 4Ddres\$";
$lang['confirm'] = "coNpHirM";
$lang['email'] = "em@il";
$lang['poll'] = "p0lL";
$lang['friend'] = "fRi3ND";
$lang['success'] = "sUcc3ss";
$lang['error'] = "err0R";
$lang['warning'] = "w4rning";
$lang['guesterror'] = "s0rry, J00 nE3D To Be log9ED 1N To use tH1s F3@tuR3.";
$lang['loginnow'] = "lo91N nOw";
$lang['unread'] = "unRE4d";
$lang['all'] = "aLl";
$lang['allcaps'] = "aLL";
$lang['permissions'] = "p3RM1\$si0NS";
$lang['type'] = "tyPe";
$lang['print'] = "pr1N+";
$lang['sticky'] = "s+1ckY";
$lang['polls'] = "pOll5";
$lang['user'] = "uSer";
$lang['enabled'] = "eN@8leD";
$lang['disabled'] = "dis4BleD";
$lang['options'] = "opT1ON\$";
$lang['emoticons'] = "eMot1C0ns";
$lang['webtag'] = "webt49";
$lang['makedefault'] = "m@K3 d3ph@uL+";
$lang['unsetdefault'] = "un\$ET D3PH4Ul+";
$lang['rename'] = "rEn@m3";
$lang['pages'] = "p49es";
$lang['used'] = "uSEd";
$lang['days'] = "d@YS";
$lang['usage'] = "uS493";
$lang['show'] = "shOW";
$lang['hint'] = "h1N+";
$lang['new'] = "nEW";
$lang['referer'] = "rEf3rEr";
$lang['thefollowingerrorswereencountered'] = "tHe f0ll0win9 ErRoRs wER3 3Nc0UNtER3d:";

// Admin interface (admin*.php) ----------------------------------------

$lang['admintools'] = "aDmin +0ols";
$lang['forummanagement'] = "foRUM man4g3mEnT";
$lang['accessdeniedexp'] = "j00 do N0T h@vE pErMi\$Si0n t0 U\$3 tH1\$ \$3CT1ON.";
$lang['managefolders'] = "m4n@gE Ph0ld3RS";
$lang['manageforums'] = "m4N@g3 f0rums";
$lang['manageforumpermissions'] = "m@NA9e phorUM p3rMIS\$1on\$";
$lang['foldername'] = "f0LD3r n4M3";
$lang['move'] = "mOve";
$lang['closed'] = "clO53D";
$lang['open'] = "oPEn";
$lang['restricted'] = "re5+riCTEd";
$lang['forumiscurrentlyclosed'] = "%s 15 CuRr3NtlY CL0sED";
$lang['youdonothaveaccesstoforum'] = "j00 d0 nO+ h@V3 4cC3s5 +0 %s";
$lang['toapplyforaccessplease'] = "t0 @pplY for 4cC3S\$ PL34\$E C0nt@Ct tEH pHoRUM 0wn3R.";
$lang['adminforumclosedtip'] = "ipH J00 w4nt To CHAn93 s0ME s3Tt1NGs 0N Your F0rUM cl1Ck the aDM1N LiNk In th3 n@V19At1On B4r @80v3.";
$lang['newfolder'] = "neW f0lDer";
$lang['nofoldersfound'] = "nO 3xi\$+ing f0LDER5 ph0und. +o 4dD 4 PholDer ClICK THE 'adD N3W' 8u++0n 83L0W.";
$lang['forumadmin'] = "f0Rum @DMiN";
$lang['adminexp_1'] = "use +eH menU oN tEH leFt +0 m4n493 THIN9S 1N YoUr Ph0RUm.";
$lang['adminexp_2'] = "<b>uS3rs</b> 4lloW5 j00 tO s3+ 1nDiviDU4l U\$3r p3rMI\$\$1ons, 1nclUDIN9 @Ppo1ntiNg mODER4ToRs @nD gagG1n9 P30PL3.";
$lang['adminexp_3'] = "<b>u\$ER 9R0Up\$</b> Allow\$ J00 +o CRE4TE U53r gRoUp5 +O @5sIGN p3rMI5s1on5 tO 45 M@nY or 45 pheW U\$3r\$ quickLY @nD EAs1ly.";
$lang['adminexp_4'] = "<b>b@N CoN+r0ls</b> @llOw\$ TEH 84nN1ng 4ND uN-B@Nn1ng 0f iP 4dDr35S3s, h+Tp r3F3r3Rs, U5erN4M3S, 3M41L 4DDRESs3s @nD n1cknamE\$.";
$lang['adminexp_5'] = "<b>fOld3rS</b> ALloWs t3h crE4t10n, M0diFic4+I0n 4nD d3le+I0n 0PH FoLdEr\$.";
$lang['adminexp_6'] = "<b>rsS feED\$</b> 4llOw\$ J00 +0 m4Na93 r\$\$ FE3ds FOR PrOp@94t1ON in+o y0ur ph0rum.";
$lang['adminexp_7'] = "<b>pR0fil3s</b> lETS j00 cU\$tom1\$E tEH 1t3m\$ +h4t 4PP3Ar 1n +H3 UsER PRoph1l3S.";
$lang['adminexp_8'] = "<b>forum \$3t+1nGs</b> 4llows j00 +0 CUsTom1\$e y0ur pHOrUM's n4ME, @Pp34r4nCE @ND m4ny 0thER th1NG\$.";
$lang['adminexp_9'] = "<b>s+@r+ p4g3</b> l3TS j00 CU\$+0misE yOUr Phorum'\$ \$+@Rt p49E.";
$lang['adminexp_10'] = "<b>fOrum s+ylE</b> @LL0W\$ J00 to 93n3R4te r4nDOm STyL3s phor y0ur f0rUm M3M8eR\$ +0 UsE.";
$lang['adminexp_11'] = "<b>w0RD pHil+3r</b> AlloW5 J00 +o f1lT3R worD\$ j00 DOn't w@n+ +0 8e uS3D 0N y0ur phOrUm.";
$lang['adminexp_12'] = "<b>p0St1N9 s+4t\$</b> 93NEr4tes 4 rEPort lI5t1ng TH3 +0P 10 po\$ter5 IN 4 dEPH1N3D P3ri0D.";
$lang['adminexp_13'] = "<b>fORUm LiNks</b> LETS j00 m4n4gE +h3 LINkS DRoPD0WN 1n +EH n@vIG4T10N B4r.";
$lang['adminexp_14'] = "<b>v1Ew l09</b> Lis+\$ rEC3Nt 4C+I0ns 8y Teh phoRUM m0der4ToRs.";
$lang['adminexp_15'] = "<b>m4N@g3 F0RUM\$</b> LEts j00 crE4t3 4nD DELE+3 4nD CL0\$3 or rE0pen f0RUm5.";
$lang['adminexp_16'] = "<b>gloB@L ForUm \$3tt1ng\$</b> 4LLow5 J00 To m0d1phy sE+T1Ngs wHiCh @PhF3c+ @ll F0RUM\$.";
$lang['adminexp_17'] = "<b>pO5+ 4PProvaL qUEU3</b> @lLoWS j00 +o V13w aNy po\$+s aw4i+iNg @Ppr0v4L 8Y @ M0DER@+0R.";
$lang['adminexp_18'] = "<b>vis1t0r L0g</b> @llOw\$ J00 +o vIEW 4n EX+enD3d lI5+ oF v1\$i+ors 1nclUDInG +HEIr htTp rEpHer3RS.";
$lang['createforumstyle'] = "cRe@TE @ pH0RUm s+Yl3";
$lang['newstylesuccessfullycreated'] = "n3W styl3 \$Ucc3SsfULly Cre4+ED.";
$lang['stylealreadyexists'] = "a 5TyL3 W1+h tH4T phILeN4M3 4Lr3adY 3xiSts.";
$lang['stylenofilename'] = "j00 did nO+ 3NTER @ pH1L3N4M3 T0 \$@v3 +H3 s+YL3 WI+H.";
$lang['stylenodatasubmitted'] = "coULD Not RE@D foRum \$tyL3 D4t4.";
$lang['styleexp'] = "u5e +h1\$ P4g3 T0 h3LP cRe4+3 4 r4nD0MlY gENEr@+3D 5+yLE foR yOUR Ph0rUM.";
$lang['stylecontrols'] = "con+ROls";
$lang['stylecolourexp'] = "cl1ck 0n A cOloUR +O maKE 4 neW \$tyl3 5h3E+ B453d 0n +H4+ COlOUR. cURr3NT 8@\$3 c0Lour Is pH1rst 1N L1\$+.";
$lang['standardstyle'] = "s+4NDArD s+YLe";
$lang['rotelementstyle'] = "r0+4+3d EleM3NT StYl3";
$lang['randstyle'] = "r@nD0m S+ylE";
$lang['thiscolour'] = "thiS c0L0UR";
$lang['enterhexcolour'] = "oR 3n+3R a heX c0L0uR T0 b@\$3 @ n3W s+yle \$hE3t on";
$lang['savestyle'] = "s4Ve +h1\$ s+YlE";
$lang['styledesc'] = "s+yL3 d3ScrIp+IOn";
$lang['stylefilenamemayonlycontain'] = "s+yle fIl3N4M3 may onLy C0nt@IN l0W3rC@se LE++Ers (4-Z), nUmBer\$ (0-9) @nD UND3RsCoRE.";
$lang['stylepreview'] = "stYLE pREV13w";
$lang['welcome'] = "welC0M3";
$lang['messagepreview'] = "m3S\$49E pr3VI3W";
$lang['users'] = "usERs";
$lang['usergroups'] = "u\$Er gR0Up\$";
$lang['mustentergroupname'] = "j00 musT EnTEr a grOUP N@m3";
$lang['profiles'] = "pR0PH1LEs";
$lang['manageforums'] = "m@n4g3 phorUms";
$lang['forumsettings'] = "f0rum setT1NG\$";
$lang['globalforumsettings'] = "gLOBAL Ph0RUm 53tt1Ngs";
$lang['settingsaffectallforumswarning'] = "<b>n0tE:</b> tHESE 53+t1n9s @Ff3C+ aLL PhOruMs. WhER3 +HE se++iNg 1s DUpliC4TED On +h3 InDIviDU4L F0rUm'5 se++1Ng\$ pA9E +H@+ w1ll +@kE pr3c3DeNC3 0ver +hE sE+Ting5 J00 CHangE h3r3.";
$lang['startpage'] = "start p4g3";
$lang['startpageerror'] = "yoUr St4r+ p4g3 CouLD nOt 83 s@VED l0c@LlY +0 th3 5Erv3R B3c@us3 p3rm1S\$i0N WAs D3nieD.</p><p>to CH@ngE YoUR s+@rT p49E PlE4se ClICK THE D0wnl0aD 8u+T0n BEL0W Wh1Ch wILL pR0MPT j00 TO \$@vE +3h f1lE T0 y0UR H@rD DRIve. j00 C4n +h3N UPl0@D Th1\$ phIlE t0 your \$ERveR 1nto +hE f0ll0wiNg ph0lDEr, 1Ph nEC3Ss4rY Cr3@t1N9 +eh F0Ld3r \$TRUCtUr3 1n +HE process.</p><p><b>%s</b></p><p>pL34SE noT3 +h@+ s0M3 Br0W\$3Rs M4y Ch4ngE +hE n@m3 0Ph +3H Phil3 Up0n Downl04d.  wh3N upLo@D1n9 TH3 f1lE plE4s3 m4K3 sur3 th@+ it 1S n4M3d st4R+_m@1N.php Oth3rw1s3 y0UR s+4RT page w1Ll 4PP34R uNCh@n9ED.";
$lang['failedtoopenmasterstylesheet'] = "yoUR phOrUM \$tyl3 CoULD nO+ BE s4veD B3C@Us3 tH3 M@\$TER \$+yLe sh33+ CoULD nO+ 83 lo4D3d. +0 \$@v3 yoUr \$tylE +EH M@\$+3R 5+YL3 sH3Et (m@k3_\$TYL3.css) mU\$T 8e l0c4TED in +H3 styL3s DiR3CT0ry 0ph y0UR BeEHivE f0RUm iN\$T4ll4tion.";
$lang['makestyleerror'] = "yoUR f0RUM stYL3 C0ulD No+ 8E S@VEd loC4LLY To tHE sERveR 8eCaUS3 P3Rm1\$SI0n w4\$ DEN13D. +0 s4VE yoUR pHORUM \$tyl3 pL34\$e cl1Ck +3H DoWnLo@D 8UTTon 83L0w wh1CH WiLl PrOmpt J00 to S4v3 +H3 Ph1l3 tO Y0UR H4rD dr1v3. j00 CaN THEn UpLo4d +hIs Fil3 t0 Y0UR \$ERvEr in+0 %s FolDeR, 1f n3C3sS4ry crE4+1Ng +Eh ph0LD3r s+rUc+urE 1n thE procE5S. j00 shoUlD n0T3 Th4t Som3 8row\$er\$ m4Y Ch@nGE +eh naMe opH +3h f1l3 upon downl04d. wHeN upl0@D1ng +he F1L3 Pl3@5E Make SUr3 tHAT it 1s n4mEd StyLE.C\$\$ 0+herwIse +3H ph0Rum sTyl3 w1ll 83 unu5@Bl3.";
$lang['uploadfailed'] = "y0UR N3W st4R+ pA93 COUlD NoT B3 upL04D3d to +3H \$3Rver BEcau\$e p3rmi\$\$I0n w4\$ D3n13D. pl3453 ChECK th4+ TEH w38 sErV3R / pHp pRocE\$s is 4bl3 t0 wRi+3 +O tH3 %s f0ldeR oN Y0UR sERv3R.";
$lang['forumstyle'] = "f0rUm s+yLe";
$lang['wordfilter'] = "woRD PhILt3R";
$lang['forumlinks'] = "forum L1nkS";
$lang['viewlog'] = "vI3w loG";
$lang['noprofilesectionspecified'] = "n0 pR0FiL3 SECT10N sp3CiFi3D.";
$lang['itemname'] = "iTEM n@m3";
$lang['moveto'] = "mOVe +0";
$lang['manageprofilesections'] = "m4N@Ge pr0pHILE sECTions";
$lang['sectionname'] = "s3C+i0n n4M3";
$lang['items'] = "i+3ms";
$lang['mustspecifyaprofilesectionid'] = "mUST SP3C1phy 4 PrOphiL3 \$ect10N 1d";
$lang['mustsepecifyaprofilesectionname'] = "muSt \$p3cIfY 4 pR0F1L3 \$ecT10n n4m3";
$lang['noprofilesectionsfound'] = "n0 3XI\$+ing pR0FIlE 53c+ion\$ fOUnd. To 4DD @ Pr0f1L3 \$eC+1oN CLIcK +3h '4DD N3W' 8U+t0n B3LOW.";
$lang['addnewprofilesection'] = "aDD nEw prOph1L3 \$eCT1on";
$lang['successfullyaddedprofilesection'] = "sUCC3\$sFULlY 4Dd3D pRoF1L3 \$eCT1ON";
$lang['successfullyeditedprofilesection'] = "suCCES\$FULLy EDItED pR0F1L3 5ECT10n";
$lang['addnewprofilesection'] = "aDd n3w Pr0F1L3 \$Ect10n";
$lang['mustsepecifyaprofilesectionname'] = "mU5t sPECIFY @ pR0Ph1l3 \$eCT10n N4mE";
$lang['successfullyremovedselectedprofilesections'] = "sucC3SsFULlY Rem0v3D 53L3C+ED PR0PH1L3 s3C+I0nS";
$lang['failedtoremoveprofilesections'] = "fAIl3D +o rEMoVE pRopHiL3 sECT10ns";
$lang['viewitems'] = "v1eW 1+3ms";
$lang['successfullyaddednewprofileitem'] = "sUcC3S\$pHuLLy 4Dded n3w PRofiL3 i+3M";
$lang['successfullyeditedprofileitem'] = "sUcCEs\$fully EDIteD PR0FilE iTEM";
$lang['successfullyremovedselectedprofileitems'] = "sUcCE\$SFulLy rEm0v3D S3l3C+3d pR0ph1L3 ItEmS";
$lang['failedtoremoveprofileitems'] = "f41l3d t0 rEm0v3 Pr0PhIl3 i+3MS";
$lang['noexistingprofileitemsfound'] = "tH3r3 aR3 N0 eX1\$+1n9 pRoPh1le 1+3Ms 1n +His \$ECT10n. tO aDD 4n iT3m cLicK +H3 '@DD NEW' Bu++0n 83low.";
$lang['edititem'] = "eD1t 1Tem";
$lang['invalidprofilesectionid'] = "iNV4l1d PR0f1l3 \$eCt10n 1d 0R sECt10n nOt F0UND";
$lang['invalidprofileitemid'] = "inV4l1D pr0f1L3 i+Em Id or It3M n0+ F0Und";
$lang['addnewitem'] = "add n3W 1+3m";
$lang['youmustenteraprofileitemname'] = "j00 musT Enter a PrOpHilE 1+3m n4ME";
$lang['invalidprofileitemtype'] = "inVAl1d pr0F1le 1teM +YPE \$el3CTED";
$lang['youmustenteroptionsforselectedprofileitemtype'] = "j00 mu\$+ En+3R sOm3 0ptiOns F0R s3lEC+3d Pr0pH1L3 1t3m +yp3";
$lang['youmustentermorethanoneoptionforitem'] = "j00 MUs+ 3NtEr MoR3 +h4N 0n3 0pt10n F0R sEL3C+3d proFil3 1+3m tYP3";
$lang['profileitemhyperlinkssupportshttpurlsonly'] = "pROFIlE i+eM HyPERl1nk\$ 5upPoRt htTp uRL\$ onlY";
$lang['profileitemhyperlinkformatinvalid'] = "proF1l3 I+Em hyp3RL1nk f0rm4+ 1nv@liD";
$lang['youmustincludeprofileentryinhyperlinks'] = "j00 musT InCLUd3 <i>[Pr0F1L3entRy]</i> 1n th3 uRL 0PH Cl1cK48l3 HYperLiNk\$";
$lang['failedtocreatenewprofileitem'] = "f4IL3D +0 CRE4t3 n3W pR0f1L3 i+Em";
$lang['failedtoupdateprofileitem'] = "fa1l3D T0 uPD@+3 pRoPhIle ITEm";
$lang['startpageupdated'] = "sTArt p@g3 uPD4+3d. %s";
$lang['viewupdatedstartpage'] = "vIew UpD4+ed st4rt p@gE";
$lang['editstartpage'] = "edIt \$+4rt p@93";
$lang['nouserspecified'] = "nO Us3R \$P3cipHi3d.";
$lang['manageuser'] = "m@N@93 UsEr";
$lang['manageusers'] = "m4NA93 U\$3rs";
$lang['userstatusforforum'] = "uSEr s+@+U5 phor %s";
$lang['userdetails'] = "u5er DeTa1ls";
$lang['warning_caps'] = "w4rn1ng";
$lang['userdeleteallpostswarning'] = "aRe J00 \$uRE J00 WANt T0 DEL3t3 4ll oPh TEH s3lECTeD UseR's p0stS? onCE +3h P0STs @R3 D3let3d +h3y c4NN0+ 8e r3+r1evED @ND w1ll 8e LO5+ pHOR3VEr.";
$lang['postssuccessfullydeleted'] = "p0\$+S WEr3 sUCC3ssFULlY DEl3Ted.";
$lang['folderaccess'] = "folder aCCESS";
$lang['possiblealiases'] = "p0Ss1BLE 4L14ses";
$lang['userhistory'] = "u5ER h1ST0rY";
$lang['nohistory'] = "no h1S+orY R3c0rD\$ 54V3d";
$lang['userhistorychanges'] = "ch4NG3\$";
$lang['clearuserhistory'] = "clear u53r hi\$+0Ry";
$lang['changedlogonfromto'] = "cH4n9ED lO90n fr0m %s t0 %s";
$lang['changednicknamefromto'] = "ch4n9ED niCKN4ME Fr0m %s t0 %s";
$lang['changedemailfromto'] = "cHANGEd 3ma1L Fr0M %s +0 %s";
$lang['successfullycleareduserhistory'] = "sUcce\$SFUlLy CLear3d U\$3r HI\$+0ry";
$lang['failedtoclearuserhistory'] = "f4il3d +o clE4r UsEr H1s+0rY";
$lang['successfullychangedpassword'] = "sucC3S\$fully Ch@nGED passwoRD";
$lang['failedtochangepasswd'] = "f@1l3d To CHAn93 p4SSW0RD";
$lang['viewuserhistory'] = "view User H1STorY";
$lang['viewuseraliases'] = "v1Ew U5er alI@\$e5";
$lang['searchreturnednoresults'] = "s34RCh r3turn3d n0 r3\$ul+s";
$lang['deleteposts'] = "deL3te po5+s";
$lang['deleteuser'] = "dEL3+3 usER";
$lang['alsodeleteusercontent'] = "al\$O DEL3T3 4ll oF tEH C0NTEnT crE4+3D by +hI\$ User";
$lang['userdeletewarning'] = "aR3 j00 5ure J00 w4N+ To Dele+3 tEH \$EL3c+3d UsER @CCOUNt? oNCe +3h 4CcOUnT H4s b33n D3l3T3D 1+ C4NN0t bE rETRi3ved @nD W1Ll 8e Lo\$+ f0rev3R.";
$lang['usersuccessfullydeleted'] = "u53R suCCesSPHUllY D3l3TED";
$lang['failedtodeleteuser'] = "f4IL3d to D3LETE U53r";
$lang['forgottenpassworddesc'] = "ipH THi\$ useR h4S FoR9O++3n tH31r p4ssw0RD J00 c4n rEs3t 1+ phoR tH3M hER3.";
$lang['manageusersexp'] = "tH1s l1sT \$h0w5 a \$el3CTI0N Of u\$3rs Wh0 h4ve loGg3d 0n to Y0UR PhOrUM, s0RtED 8Y %s. T0 4l+3R @ UsEr's pErm1\$SI0NS cl1ck +hE1r n4M3.";
$lang['userfilter'] = "u5eR Ph1LtER";
$lang['onlineusers'] = "onL1n3 UseRs";
$lang['offlineusers'] = "ophfL1n3 U\$3rS";
$lang['usersawaitingapproval'] = "uSEr\$ 4w@1t1Ng @PpRoV@l";
$lang['bannedusers'] = "b4nn3D user5";
$lang['lastlogon'] = "l4S+ lO9On";
$lang['sessionreferer'] = "s35s1On REFEr3r";
$lang['signupreferer'] = "s19n-Up r3feR3R:";
$lang['nouseraccountsmatchingfilter'] = "nO u\$3r aCC0UNts m4tCHInG phIl+3R";
$lang['searchforusernotinlist'] = "se4rch f0R 4 usER No+ iN LiS+";
$lang['adminaccesslog'] = "aDM1N 4cC3Ss log";
$lang['adminlogexp'] = "thIs lI\$+ sh0WS The L4\$t 4C+i0n5 s4NCT10N3D BY User5 w1+h @DM1n pr1v1L393S.";
$lang['datetime'] = "d4+E/+im3";
$lang['unknownuser'] = "uNKn0wn Us3r";
$lang['unknownuseraccount'] = "uNkn0wN U\$3r 4cC0Un+";
$lang['unknownfolder'] = "uNkn0wn PhoLDEr";
$lang['ip'] = "iP";
$lang['lastipaddress'] = "l@5+ Ip 4DDRESs";
$lang['logged'] = "l09geD";
$lang['notlogged'] = "noT l0G9ED";
$lang['addwordfilter'] = "aDd wOrD fIl+3R";
$lang['addnewwordfilter'] = "aDd nEW W0Rd pHiLter";
$lang['wordfilterupdated'] = "woRD fIl+3R Upd4+3D";
$lang['filtername'] = "f1lt3R n@me";
$lang['filtertype'] = "fILTEr +yP3";
$lang['filterenabled'] = "fIlteR 3na8LED";
$lang['editwordfilter'] = "ed1t W0Rd PHiL+3r";
$lang['nowordfilterentriesfound'] = "no 3XI5t1ng woRD Fil+3R 3ntr13s pH0Und. tO @DD @ F1L+3r ClICK thE '4Dd nEw' bU++0N 83l0w.";
$lang['mustspecifyfiltername'] = "j00 mu\$t \$P3c1PHY @ pHiLtER n4m3";
$lang['mustspecifymatchedtext'] = "j00 mU\$t SPECIFY MaTCHEd +3XT";
$lang['mustspecifyfilteroption'] = "j00 mu\$t speC1phy 4 f1l+3R opT10n";
$lang['mustspecifyfilterid'] = "j00 MUS+ \$P3CIPHy 4 FILtER id";
$lang['invalidfilterid'] = "inV@lID f1LT3r 1D";
$lang['failedtoupdatewordfilter'] = "f@IL3D +o UpDatE w0rD PhilTER. cH3Ck tH4t tHE fiL+3r 5+iLl 3x1s+s.";
$lang['allow'] = "alLow";
$lang['block'] = "bL0cK";
$lang['normalthreadsonly'] = "n0RMAl tHre4ds oNlY";
$lang['pollthreadsonly'] = "p0ll THrE4D\$ oNlY";
$lang['both'] = "bo+h +hr3ad +YPEs";
$lang['existingpermissions'] = "ex1s+ing pErM1\$\$1on\$";
$lang['nousershavebeengrantedpermission'] = "n0 3Xi\$T1ng usER5 pErMi\$SI0Ns pH0UnD. +o gr@n+ PErMi5Si0n T0 useRs s3arCH phoR THEm 8el0W.";
$lang['successfullyaddedpermissionsforselectedusers'] = "sUCCEs\$FULlY 4Dd3D p3RmI\$5i0NS f0r \$el3c+3D U53R\$";
$lang['successfullyremovedpermissionsfromselectedusers'] = "sUcCE\$SFULlY R3m0v3D P3Rmi\$SI0NS pHr0m sEL3c+3D UseR\$";
$lang['failedtoaddpermissionsforuser'] = "f4Il3D T0 4DD p3rM1\$\$1on\$ Phor U\$3r '%s'";
$lang['failedtoremovepermissionsfromuser'] = "f@ILED To r3MoVE PErMi\$SI0nS FROm uSER '%s'";
$lang['searchforuser'] = "se4rCh f0R usER";
$lang['browsernegotiation'] = "br0ws3R nEg0+14+3D";
$lang['largetextfield'] = "l4RG3 tEx+ Ph1eld";
$lang['mediumtextfield'] = "m3DIum tExT F13lD";
$lang['smalltextfield'] = "sm4lL +ex+ F1ElD";
$lang['multilinetextfield'] = "mUL+I-L1N3 tex+ fI3ld";
$lang['radiobuttons'] = "r@dIO BU++0N\$";
$lang['dropdownlist'] = "dROp D0wN l15+";
$lang['clickablehyperlink'] = "cL1Ck@8lE hYpeRL1Nk";
$lang['threadcount'] = "thR3@D COUnT";
$lang['clicktoeditfolder'] = "click +0 EDIt f0ldEr";
$lang['fieldtypeexample1'] = "t0 Cr34+E r@DI0 BU++0Ns 0r 4 dr0p D0WN l1\$+ J00 n3ED +0 enTEr 34ch 1ND1V1dU4L v4lu3 0n a s3P4r4+E l1ne 1n +HE 0pt10ns fIEld.";
$lang['fieldtypeexample2'] = "tO cR3ate CLiCK@BLE liNk5 3nteR +H3 url iN +Eh 0p+ions Ph1eld AnD USE <i>[PR0Fil3entRy]</i> WH3rE tEH EN+ry FroM +he Us3r'5 pR0Ph1L3 SH0UlD App3@R. ex4mplEs: <p>mYsp4C3: <i>hTtP://www.mY\$p@cE.com/[PropH1L3enTRY]</i><br />xB0X livE: <i>h+tp://pR0f1L3.mygaMERc@rD.n3t/[pR0phil3EnTry]</i>";
$lang['editedwordfilter'] = "eD1teD w0RD pHiLteR";
$lang['editedforumsettings'] = "eD1T3d phORuM SE++1ng\$";
$lang['successfullyendedusersessionsforselectedusers'] = "sUcC3\$SPhULlY eND3D \$e\$sI0n5 pHOR sel3C+3d u\$3r5";
$lang['failedtoendsessionforuser'] = "f41l3d +0 EnD 53ssi0N F0R USER %s";
$lang['successfullyapprovedselectedusers'] = "sUCCEssfully @PpR0VED 53l3C+3d u\$ers";
$lang['matchedtext'] = "m4tcheD +3x+";
$lang['replacementtext'] = "r3plac3MEnT +3X+";
$lang['preg'] = "pR3g";
$lang['wholeword'] = "wh0lE w0RD";
$lang['word_filter_help_1'] = "<b>aLL</b> M4tChEs @G@IN\$T +H3 wHoLE T3xt s0 FiL+3ring M0m +O mum w1Ll aL50 Ch@nG3 M0m3n+ +0 MuM3Nt.";
$lang['word_filter_help_2'] = "<b>wh0l3 wOrD</b> MaTCH3\$ @G@iNst wH0LE w0rD\$ 0NlY \$0 F1lT3RinG mOm +0 muM wIll no+ CH4N93 momeNt t0 mumEn+.";
$lang['word_filter_help_3'] = "<b>pREG</b> @LLow\$ j00 +0 UsE P3Rl rE9ul4r exprE\$SI0ns to m4+CH tex+.";
$lang['nameanddesc'] = "n4M3 4nD DEsCr1PT10N";
$lang['movethreads'] = "m0VE +hr34Ds";
$lang['movethreadstofolder'] = "m0V3 +hr3@dS +o f0LDeR";
$lang['failedtomovethreads'] = "f41l3D t0 Mov3 THr3@d\$ +0 sp3CIf1ED F0LDER";
$lang['resetuserpermissions'] = "rE\$et U\$Er PErm1SSI0ns";
$lang['failedtoresetuserpermissions'] = "f4Il3D +0 R3SEt U\$3r p3rm1SSi0NS";
$lang['allowfoldertocontain'] = "alLow pH0lDER +O C0nt@in";
$lang['addnewfolder'] = "add n3w F0Ld3r";
$lang['mustenterfoldername'] = "j00 mUs+ 3NtER a f0LD3r n@mE";
$lang['nofolderidspecified'] = "no f0ld3R id Sp3CIFI3D";
$lang['invalidfolderid'] = "iNv4LiD F0LDER 1d. Ch3cK +h4T @ FOlDER w1+h +hI5 iD 3X1\$+s!";
$lang['successfullyaddednewfolder'] = "sUcCE\$SfULlY @DDED n3w f0LDER";
$lang['successfullyremovedselectedfolders'] = "sUCCEssFULly rEMoVED s3LECTeD fOlDER\$";
$lang['successfullyeditedfolder'] = "sUcCE\$sfULLY 3diTED pHolDEr";
$lang['failedtocreatenewfolder'] = "faIl3D To cR34+3 NEw ph0ldeR";
$lang['failedtodeletefolder'] = "fA1leD +0 deL3TE F0LDEr.";
$lang['failedtoupdatefolder'] = "f@1l3D T0 uPDATe Ph0LD3r";
$lang['cannotdeletefolderwiththreads'] = "cAnno+ DElE+E f0ldeR5 +H@+ \$+ILL CONtA1N THrE4Ds.";
$lang['forumisnotrestricted'] = "f0rum 15 n0T rEs+RiCTED";
$lang['groups'] = "gr0ups";
$lang['nousergroups'] = "nO useR 9R0UPS h4V3 83En sE+ Up. to adD @ 9R0UP CLiCK TEh '4DD nEW' bu++0N BEL0w.";
$lang['suppliedgidisnotausergroup'] = "sUppliED G1D 1\$ no+ @ User 9RouP";
$lang['manageusergroups'] = "m4n49e u\$3r grouPs";
$lang['groupstatus'] = "gROUp st4+us";
$lang['addusergroup'] = "aDd usEr 9r0uP";
$lang['addemptygroup'] = "add Emp+y 9r0Up";
$lang['adduserstogroup'] = "aDd u\$ER5 +0 9roUp";
$lang['addremoveusers'] = "add/rEm0v3 users";
$lang['nousersingroup'] = "there @r3 n0 us3Rs IN thI\$ grouP. 4DD U53r\$ +0 Th1\$ GRouP BY \$e4rCH1n9 F0R +hEM B3loW.";
$lang['groupaddedaddnewuser'] = "successfUlly 4DDED GroUP. ADD us3R\$ +0 +his gR0up 8Y sEarCh1Ng For +hEM b3low.";
$lang['nousersingroupaddusers'] = "tHerE @R3 n0 u5ers 1n tHis gR0UP. +0 4dD U\$ERs cl1CK +3h '@DD/REMOv3 U53R\$' BU++0n bel0W.";
$lang['useringroups'] = "tH15 user I5 @ mEMber oPH THe F0llOwIn9 9RoUPs";
$lang['usernotinanygroups'] = "tHis uS3r is n0t iN @ny UsEr 9roup\$";
$lang['usergroupwarning'] = "n0T3: thI\$ useR M4Y BE 1nhEri+INg ADDI+iOn@l P3RmIssi0ns phrOm 4ny u\$3r 9r0upS Li\$+3D 8El0w.";
$lang['successfullyaddedgroup'] = "sUCc3sSFULlY adD3D GrOuP";
$lang['successfullyeditedgroup'] = "sUCC3\$SFUlLy 3D1+3D GroUp";
$lang['successfullydeletedselectedgroups'] = "sUcce\$SFUlLY DEL3TED 5el3CTED 9R0UP\$";
$lang['failedtodeletegroupname'] = "fAil3D +0 d3letE gRoUp %s";
$lang['usercanaccessforumtools'] = "u\$3R C@n 4cC3SS PHORUm +0Ols @ND c@N CR34+3, D3letE @ND 3DI+ F0RUm5";
$lang['usercanmodallfoldersonallforums'] = "us3r c4n moD3r4+E <b>aLl pH0lDER\$</b> on <b>aLL f0RUm5</b>";
$lang['usercanmodlinkssectiononallforums'] = "uSer C@n MoDER@+E l1nK\$ \$eCt1oN 0N <b>aLL fOrUM\$</b>";
$lang['emailconfirmationrequired'] = "eM4Il c0nph1RM@+i0n REqUiREd";
$lang['userisbannedfromallforums'] = "uS3r is B4nn3D pHrom <b>aLL f0RUMs</b>";
$lang['cancelemailconfirmation'] = "cANCEL EMa1l c0NPHiRm@t10n 4ND 4LL0W Us3R To s+4Rt pO\$+1N9";
$lang['resendconfirmationemail'] = "r3SEND C0nfirmAtIoN 3ma1L T0 UsER";
$lang['donothing'] = "d0 nothIn9";
$lang['usercanaccessadmintools'] = "us3r h4\$ @CC3SS to pHoRuM @dM1N +0olS";
$lang['usercanaccessadmintoolsonallforums'] = "uS3r has 4CcESS +0 4DM1n +O0ls <b>on @ll FoRUms</b>";
$lang['usercanmoderateallfolders'] = "uSer C@n mOD3R4te 4Ll f0lDEr5";
$lang['usercanmoderatelinkssection'] = "u5er c@n moD3r4tE lInK\$ \$3C+ioN";
$lang['userisbanned'] = "u\$Er I5 84Nn3d";
$lang['useriswormed'] = "uSeR Is W0RM3D";
$lang['userispilloried'] = "u\$3r 1S p1Ll0R1ed";
$lang['usercanignoreadmin'] = "u\$3R C4N IgnOr3 4dm1N1str@t0rs";
$lang['groupcanaccessadmintools'] = "gROUp C4N ACCES\$ 4dm1N tools";
$lang['groupcanmoderateallfolders'] = "gR0uP Can m0dEr@TE @ll F0Ld3Rs";
$lang['groupcanmoderatelinkssection'] = "gR0up C4N m0d3R4TE LInK\$ \$3CtI0N\$";
$lang['groupisbanned'] = "group 1s BAnNeD";
$lang['groupiswormed'] = "gR0up 1\$ Worm3d";
$lang['readposts'] = "rE4D P0S+s";
$lang['replytothreads'] = "rEPLy t0 thR3@D5";
$lang['createnewthreads'] = "cRe@te N3W Thr34d5";
$lang['editposts'] = "eD1t po\$tS";
$lang['deleteposts'] = "d3lete po5T5";
$lang['postssuccessfullydeleted'] = "poS+5 5UccesSfUlly DElE+3D";
$lang['failedtodeleteusersposts'] = "f41l3D +0 D3leTE usEr'\$ pO\$+\$";
$lang['uploadattachments'] = "upl04d @++4cHmEnT\$";
$lang['moderatefolder'] = "moDER@+3 f0LD3r";
$lang['postinhtml'] = "poS+ in HtmL";
$lang['postasignature'] = "p0St 4 S1gn4tur3";
$lang['editforumlinks'] = "eD1t F0rum L1nk\$";
$lang['linksaddedhereappearindropdown'] = "l1NK\$ 4dDED H3R3 4PP34r 1n 4 drop D0wN In +3h tOP R1gh+ oF +H3 fr4M3 5E+.";
$lang['linksaddedhereappearindropdownaddnew'] = "l1nk5 @DD3D h3r3 4PP3AR In 4 DrOp d0wn In tHe t0p r1ght 0ph THE phR4mE s3t. t0 4DD 4 L1Nk cL1CK tHE '@Dd n3W' 8UTton 8EL0w.";
$lang['failedtoremoveforumlink'] = "f4Il3D tO rEMove PHorUm link '%s'";
$lang['failedtoaddnewforumlink'] = "f@Il3d TO aDd n3W F0rUm L1Nk '%s'";
$lang['failedtoupdateforumlink'] = "f41l3d T0 UpD@TE forum lInK '%s'";
$lang['notoplevellinktitlespecified'] = "n0 +0p l3VEL LiNk tITle 5p3C1fIeD";
$lang['youmustenteralinktitle'] = "j00 musT En+Er 4 L1nk +I+LE";
$lang['alllinkurismuststartwithaschema'] = "alL l1nk Uris mUst sT4Rt W1+h @ \$cheM@ (1.3. h++P://, ph+p://, 1rc://)";
$lang['editlink'] = "ed1+ LiNk";
$lang['addnewforumlink'] = "add n3w F0RUM l1nk";
$lang['forumlinktitle'] = "f0RUM l1nk T1+l3";
$lang['forumlinklocation'] = "f0rum L1nk loc4+i0n";
$lang['successfullyaddednewforumlink'] = "sUcC3SsFUlLy 4DD3d NEw phOrUM l1nk";
$lang['successfullyeditedforumlink'] = "sucCEssFullY 3d1+3d f0ruM linK";
$lang['invalidlinkidorlinknotfound'] = "inV@l1d link ID or liNk no+ Ph0uNd";
$lang['successfullyremovedselectedforumlinks'] = "sUCC3s\$FUllY REmOv3d s3l3c+3d LInks";
$lang['toplinkcaption'] = "tOP l1Nk c4ptIoN";
$lang['allowguestaccess'] = "aLl0W Gu3sT ACCESs";
$lang['searchenginespidering'] = "s34RCH EN9in3 \$PID3rinG";
$lang['allowsearchenginespidering'] = "all0W \$34rCH EN9In3 \$PID3r1N9";
$lang['newuserregistrations'] = "nEw usER R3giS+r4T10n\$";
$lang['preventduplicateemailaddresses'] = "pR3V3Nt DUpLic4+E 3m@iL 4dDR3SsEs";
$lang['allownewuserregistrations'] = "aLlow NEW US3R r39Is+r4+1oN\$";
$lang['requireemailconfirmation'] = "r3QU1r3 Em@il C0NPh1Rm@+I0N";
$lang['usetextcaptcha'] = "u\$e +eX+-CAPtCH@";
$lang['textcaptchadir'] = "t3xT-C@p+CH4 D1r3C+0ry";
$lang['textcaptchakey'] = "tEXT-CAPtCH@ k3y";
$lang['textcaptchafonterror'] = "teX+-C4p+ch4 h@\$ bEEN D1S48leD @UtOm@+iCally b3C@U53 tH3RE @r3 n0 TrU3 TyPE Ph0Nt\$ 4va1l@bLE phOr 1+ +0 U\$e. Pl34sE UpLo@D \$0m3 +RuE +ypE ph0nts +0 <b>%s</b> 0n y0Ur \$erv3R.";
$lang['textcaptchadirerror'] = "t3X+-CapTCH@ hAs 8een D1\$4BL3D 83C4u\$3 tHE +Ex+_C4PTCh4 d1reCTOry @ND iT's \$U8-diR3C+or1es @rE nOt WRi+48L3 8y +H3 WE8 seRV3R / phP pRoCEss.";
$lang['textcaptchagderror'] = "tExt-c4ptCh4 H4\$ 8EEn Di\$@BLed bEC@UsE YoUr \$3rvER'S pHp se+Up DO35 n0T ProvID3 \$upp0R+ f0r GD iM@9E m@nIPUL@ti0N 4nd / Or +tF ph0nt sUpP0rT. BOth 4R3 r3qU1r3D Phor TExt-c@pTCh4 5upP0r+.";
$lang['textcaptchadirblank'] = "t3X+-capTCH@ DIr3CToRy i\$ 8l@nk!";
$lang['newuserpreferences'] = "n3w U\$ER pRepHEr3nCEs";
$lang['sendemailnotificationonreply'] = "em@1l n0+IF1c4TiOn on r3PlY T0 Us3R";
$lang['sendemailnotificationonpm'] = "eM4il No+IPhiCAt10n 0n PM +0 u\$er";
$lang['showpopuponnewpm'] = "sHOw pOpUp Wh3N R3CEIV1n9 n3W pm";
$lang['setautomatichighinterestonpost'] = "sE+ @utOm4t1C h19H in+ER3S+ oN Post";
$lang['postingstats'] = "pO5T1N9 s+4t\$";
$lang['postingstatsforperiod'] = "po\$+1N9 S+4ts f0R pERi0D %s to %s";
$lang['nopostdatarecordedforthisperiod'] = "n0 pOST d@t@ r3coRdeD F0R +His peri0D.";
$lang['totalposts'] = "tOt4L Po5tS";
$lang['totalpostsforthisperiod'] = "tOt4l p0s+5 f0R +his perI0d";
$lang['mustchooseastartday'] = "muS+ ChOo53 4 S+4Rt d4Y";
$lang['mustchooseastartmonth'] = "mu5+ ch00se 4 st4rt m0N+H";
$lang['mustchooseastartyear'] = "mu\$+ CHoo\$3 a 5T4r+ y3@R";
$lang['mustchooseaendday'] = "mu5t CHo0sE 4 3nD D@y";
$lang['mustchooseaendmonth'] = "mu5t CH0o53 a 3ND moNTh";
$lang['mustchooseaendyear'] = "mu\$+ Cho0S3 4 EnD Y34r";
$lang['startperiodisaheadofendperiod'] = "s+4Rt p3Ri0D i\$ 4HE4D opH END P3ri0D";
$lang['bancontrols'] = "b4n c0N+rols";
$lang['addban'] = "aDd 8@N";
$lang['checkban'] = "ch3cK BaN";
$lang['editban'] = "ed1t 8an";
$lang['bantype'] = "b4N +ype";
$lang['bandata'] = "b@N D@+@";
$lang['bancomment'] = "c0mmeNt";
$lang['ipban'] = "iP B@n";
$lang['logonban'] = "l0gon B4N";
$lang['nicknameban'] = "nICkN4m3 8an";
$lang['emailban'] = "eM@1L 8@n";
$lang['refererban'] = "rEFEr3r 84n";
$lang['invalidbanid'] = "inV@l1D 8aN iD";
$lang['affectsessionwarnadd'] = "tHIs b@n M@y 4Phf3CT tEH pHOll0W1N9 aCtiVe u5eR s3S5I0ns";
$lang['noaffectsessionwarn'] = "tH1s b4N 4PHf3c+\$ no @Ct1V3 SEssi0n5";
$lang['mustspecifybantype'] = "j00 mus+ \$P3C1PHy @ 8an +Yp3";
$lang['mustspecifybandata'] = "j00 Mus+ \$P3C1pHY S0mE 8@N D4+A";
$lang['successfullyremovedselectedbans'] = "sUCC35sfully R3M0v3D \$3l3CTED b4nS";
$lang['failedtoaddnewban'] = "f@IL3D +0 4dD N3W B4n";
$lang['failedtoremovebans'] = "fail3d t0 Rem0v3 \$0M3 or 4LL of tEH \$EL3c+3d 84n5";
$lang['duplicatebandataentered'] = "dUPL1c@+3 B4n D4+@ 3nTEr3d. PLE@\$e chEck YouR W1ldc4RDS TO s3e 1Ph +h3Y 4lr34dy MA+CH thE D4TA ENTER3D";
$lang['successfullyaddedban'] = "sUcc3SSphUlly 4DD3d B4n";
$lang['successfullyupdatedban'] = "sUcC35sfullY Upd4+Ed B4N";
$lang['noexistingbandata'] = "thErE 1s No ExI5+1n9 84N d4t4. +o 4dD 4 B4N CLiCK th3 '4DD n3w' BU++0n 8EL0W.";
$lang['youcanusethepercentwildcard'] = "j00 c@n U\$3 tEH PeRCENT (%) W1LDC4rD 5ymB0l 1N @nY 0ph Y0ur 84N Lists +0 0bt41n PAR+i@L M4tCHeS, 1.E. '192.168.0.%' WoULD B4n alL iP 4DDRE\$s3s 1N TEH R@n9E 192.168.0.1 THr0ugH 192.168.0.254";
$lang['cannotusewildcardonown'] = "j00 caNn0t 4dd % 45 @ w1LDC4rd m@+CH on 1+'S 0wN!";
$lang['requirepostapproval'] = "r3quir3 pos+ @pPr0val";
$lang['adminforumtoolsusercounterror'] = "tHerE mU\$+ 8E @+ lEAs+ 1 UsER W1+H @DmiN Tools @ND FoRum +0Ols 4Cces\$ 0n 4LL fOrUmS!";
$lang['postcount'] = "p0s+ C0Un+";
$lang['resetpostcount'] = "r3sEt Po\$+ c0UNt";
$lang['failedtoresetuserpostcount'] = "f41L3D t0 rE\$et pO\$+ C0unt";
$lang['failedtochangeuserpostcount'] = "f@Il3d +0 CH@Ng3 U\$3r pos+ coun+";
$lang['postapprovalqueue'] = "p0st 4Ppr0v4l qUeU3";
$lang['nopostsawaitingapproval'] = "nO P0s+5 @r3 4w4i+ing @pPR0VaL";
$lang['approveselected'] = "approv3 s3LECTED";
$lang['failedtoapproveuser'] = "fAILED +o 4PpRoV3 U\$3r %s";
$lang['kickselected'] = "kICk 53lec+3D";
$lang['visitorlog'] = "v1S1+0R log";
$lang['clearvisitorlog'] = "cL3ar vi\$1tor l09";
$lang['novisitorslogged'] = "nO v1\$i+0Rs Lo9GEd";
$lang['addselectedusers'] = "adD sel3CT3d U53r\$";
$lang['removeselectedusers'] = "rEMOVE \$3lECTEd UsER\$";
$lang['addnew'] = "adD New";
$lang['deleteselected'] = "dele+3 \$ELECtED";
$lang['forumrulesmessage'] = "<p><b>forum ruLEs</b></p><p>\nR3G1\$TR4+10n To %1\$S is fR33! w3 Do 1nS1st thAT j00 4B1dE 8Y TH3 RUles 4ND pOl1C1es D3+@iL3D 83l0W. iPH j00 a9r3E t0 tEH +3rms, pL3asE ch3cK +H3 'i @Gr33' CH3ck8ox 4nD PRE5s +H3 'rE91ster' buT+0n 83Low. If j00 w0ulD LIk3 to canCEl +h3 R391s+rA+10N, cliCK %2\$s +o re+urn t0 Th3 ph0RUm\$ 1ndex.</p><p>\n4L+hou9h +hE 4dm1NI\$TR4toR\$ AnD m0D3r4tor\$ 0pH %1\$5 w1ll a+tEMp+ t0 kEep 4Ll o8j3C+ion@8L3 M3s54g3\$ 0phPH +his PHorum, 1t i\$ 1mp05s18L3 for us t0 r3V13w 4ll m3s\$@93\$. 4ll mE5s4Ges expres\$ +3h View5 0PH +hE 4U+hor, 4ND nEither tEh ownErs 0Ph %1\$s, nor proj3cT 8e3h1vE ph0Rum 4nD 1T's 4phfIl14+es W1ll 8E helD resPONS1BlE ph0R t3h C0n+En+ 0ph 4NY m35sa93.</p><p>\n8Y 49REe1n9 to +HE\$3 rulEs, j00 wARr4N+ th@T J00 will no+ P0St @Ny m3S5@9es tha+ 4R3 08sCen3, vulg4r, \$3Xu4Lly-0r1en+a+ed, ha+3pHUl, +HR34tenIn9, 0r o+hErw1se vi0lativE oph @Ny l4Ws.</p><p>tH3 own3r\$ of %1\$\$ REserv3 thE ri9h+ +o REMove, eD1t, movE or cl0\$3 @NY thr3AD ph0r 4nY rE4Son.</p>";
$lang['cancellinktext'] = "hEre";
$lang['failedtoupdateforumsettings'] = "fa1l3D +0 upDA+E ph0RUm 53+T1ngs. Pl3AsE TrY @94in L4+3r.";
$lang['moreadminoptions'] = "moR3 ADM1n oPt10n\$";

// Admin Log data (admin_viewlog.php) --------------------------------------------

$lang['changedstatusforuser'] = "cH4NGED uSER 5+4tUs f0R '%s'";
$lang['changedpasswordforuser'] = "ch4N93D p@\$sw0RD F0R '%s'";
$lang['changedforumaccess'] = "cH4N93d ForUm 4cC3Ss p3rmi\$sI0ns f0R '%s'";
$lang['deletedallusersposts'] = "del3tEd @Ll po\$+5 ph0r '%s'";

$lang['createdusergroup'] = "cRe@+3D u\$3r 9R0UP '%s'";
$lang['deletedusergroup'] = "del3teD usER GrOup '%s'";
$lang['updatedusergroup'] = "uPD@+ED USEr 9ROUp '%s'";
$lang['addedusertogroup'] = "add3D u53r '%s' +0 GR0Up '%s'";
$lang['removeduserfromgroup'] = "r3M0v3 uSeR '%s' PHRom gR0UP '%s'";

$lang['addedipaddresstobanlist'] = "adD3D iP '%s' T0 8@N l1\$+";
$lang['removedipaddressfrombanlist'] = "r3m0v3D Ip '%s' phR0m B4n lis+";

$lang['addedlogontobanlist'] = "aDDEd l090n '%s' +O 84n L1st";
$lang['removedlogonfrombanlist'] = "rEmoveD L09oN '%s' fRom b4n l1\$+";

$lang['addednicknametobanlist'] = "aDd3d NICKn4m3 '%s' to 8@n L1\$t";
$lang['removednicknamefrombanlist'] = "rEM0v3D nIckn4me '%s' pHROM B4N l1\$+";

$lang['addedemailtobanlist'] = "aDd3D 3Ma1l @DDR3SS '%s' To B4n l1\$+";
$lang['removedemailfrombanlist'] = "r3M0V3d 3M4il 4DDr3ss '%s' fRoM 84n lI5T";

$lang['addedreferertobanlist'] = "addED REfER3R '%s' +0 8@n l1S+";
$lang['removedrefererfrombanlist'] = "r3M0v3d REph3r3r '%s' from b4n l1s+";

$lang['editedfolder'] = "ed1+3d fOlDER '%s'";
$lang['movedallthreadsfromto'] = "m0VED 4LL tHr3@Ds FRom '%s' T0 '%s'";
$lang['creatednewfolder'] = "cReated N3w foLD3r '%s'";
$lang['deletedfolder'] = "d3L3TED Ph0LD3r '%s'";

$lang['changedprofilesectiontitle'] = "ch4nG3D ProPHiLE 5ECT10n T1+l3 froM '%s' +o '%s'";
$lang['addednewprofilesection'] = "addeD n3W PR0f1l3 sECT10n '%s'";
$lang['deletedprofilesection'] = "d3l3+Ed pr0pHIL3 sEc+10n '%s'";

$lang['addednewprofileitem'] = "addeD n3W PRopHiL3 I+3M '%s' TO s3ctiOn '%s'";
$lang['changedprofileitem'] = "cH@ng3D Pr0f1le 1+3m '%s'";
$lang['deletedprofileitem'] = "dELETED pR0FilE 1+3m '%s'";

$lang['editedstartpage'] = "eDi+ED 5T4rt p49e";
$lang['savednewstyle'] = "s@v3D n3W \$+YLE '%s'";

$lang['movedthread'] = "m0VED +HrE@d '%s' From '%s' T0 '%s'";
$lang['closedthread'] = "cl0\$ED +hR34d '%s'";
$lang['openedthread'] = "oPENed THrE@D '%s'";
$lang['renamedthread'] = "r3n@Med +hreAD '%s' +0 '%s'";

$lang['deletedthread'] = "d3LET3d +hr34d '%s'";
$lang['undeletedthread'] = "uNd3l3+3d +hr34d '%s'";

$lang['lockedthreadtitlefolder'] = "l0ckeD +hr34d 0ptIon\$ 0n '%s'";
$lang['unlockedthreadtitlefolder'] = "unL0CK3d +hR3AD 0p+I0ns 0n '%s'";

$lang['deletedpostsfrominthread'] = "dELETED p05+5 Phrom '%s' 1N +Hr3@d '%s'";
$lang['deletedattachmentfrompost'] = "dEL3+3D @t+4chMENt '%s' phRom p05+ '%s'";

$lang['editedforumlinks'] = "eDI+ED fOrUm linKs";
$lang['editedforumlink'] = "eDI+ED phOrUM L1Nk: '%s'";

$lang['addedforumlink'] = "aDd3D Ph0RuM link: '%s'";
$lang['deletedforumlink'] = "d3LeteD pHorum l1nk: '%s'";
$lang['changedtoplinkcaption'] = "cH4ng3D t0P L1nK C@Pt10n fR0M '%s' t0 '%s'";

$lang['deletedpost'] = "d3L3tED po5+ '%s'";
$lang['editedpost'] = "eD1+3d po\$+ '%s'";

$lang['madethreadsticky'] = "m4de thrE4d '%s' \$t1CkY";
$lang['madethreadnonsticky'] = "m4d3 +hr34d '%s' n0N-St1cKy";

$lang['endedsessionforuser'] = "end3d \$e5s1ON pHor U\$er '%s'";

$lang['approvedpost'] = "aPpr0V3d P0st '%s'";

$lang['editedwordfilter'] = "edITED Word fIlT3R";

$lang['addedrssfeed'] = "aDDEd rSs FE3D '%s'";
$lang['editedrssfeed'] = "ed1ted rss f3ED '%s'";
$lang['deletedrssfeed'] = "d3LE+3d r5\$ Ph3ED '%s'";

$lang['updatedban'] = "uPD4t3D B4n '%s'. CH@N9eD +yp3 from '%s' +0 '%s', Ch4n9ED d@+@ Phrom '%s' t0 '%s'.";

$lang['splitthreadatpostintonewthread'] = "sPli+ +hr34D '%s' 4+ PO5+ %s  int0 n3w +Hr34D '%s'";
$lang['mergedthreadintonewthread'] = "m3r9ED +HrEaDS '%s' 4nd '%s' in+0 nEw +hR34D '%s'";

$lang['approveduser'] = "apProV3D u\$3r '%s'";

$lang['forumautoupdatestats'] = "fORUm 4u+0 UpD@+3: statS UpD4t3D";
$lang['forumautoprunepm'] = "f0RUm aUt0 upd@TE: pM ph0LDER5 PRUn3d";
$lang['forumautoprunesessions'] = "forum aUt0 UpD@+3: 5E\$\$10Ns pRUN3D";
$lang['forumautocleanthreadunread'] = "foruM @u+O UpD4te: +hrE4D UNr34d D4t4 CL34n3D";
$lang['forumautocleancaptcha'] = "f0RUm 4UtO UpD4+E: tExT-CAp+chA iM493s Cl3@N3d";

$lang['adminlogempty'] = "adMiN log 1S 3mpTy";

$lang['youmustspecifyanactiontypetoremove'] = "j00 mUst sp3CIPhy 4n @Ct10N typ3 +0 r3m0V3";

$lang['removeentriesrelatingtoaction'] = "rem0ve En+ri3S r3L@tiN9 T0 @C+1ON";
$lang['removeentriesolderthandays'] = "r3M0v3 Entr13s 0LDEr th4n (D4ys)";

$lang['successfullyprunedadminlog'] = "sucC3s\$fully PrUn3D @DmIn l09";
$lang['failedtopruneadminlog'] = "f41LEd +O pRUnE 4DMin l0g";

$lang['prune_log'] = "prun3 l09";

// Admin Forms (admin_forums.php) ------------------------------------------------

$lang['noexistingforums'] = "n0 3XI\$+1n9 f0rum\$ FoUnD. +o CR3a+e 4 nEw phorUM CL1CK +H3 '4DD nEw' Bu+t0n 83loW.";
$lang['webtaginvalidchars'] = "wE8ta9 C4n onlY CON+@iN UPp3RCAsE @-Z, 0-9 @nD UNDERsC0re Ch4r4CtER\$";
$lang['databasenameinvalidchars'] = "d4+48ase NAMe CAN 0NLy C0n+@In 4-Z, @-z, 0-9 aND UnDEr5coRE CH4r4CtER\$";
$lang['invalidforumidorforumnotfound'] = "inv4l1D ph0rum f1D 0R F0rUm n0T F0UnD";
$lang['successfullyupdatedforum'] = "sUCc3s\$phUlLy uPd@+ED PhoRum";
$lang['failedtoupdateforum'] = "f41l3D T0 UpD4TE F0rum: '%s'";
$lang['successfullycreatednewforum'] = "sUCC3ssfUlLy CrEA+ED n3W Ph0rum";
$lang['selectedwebtagisalreadyinuse'] = "tHE s3LECT3d Webt49 i\$ 4lR34dy In use. PLE4\$e CH0O\$3 4NotH3R.";
$lang['selecteddatabasecontainsconflictingtables'] = "tH3 \$el3C+3d D@+@BAse C0NT@iNs COnPHl1CT1ng t48LEs. ConPHlICT1N9 +@BlE n@mE\$ @R3:";
$lang['forumdeleteconfirmation'] = "aRE j00 sure J00 W4nt +o DEL3+3 4lL oF TEh sEl3CTED Ph0ruMs?";
$lang['forumdeletewarning'] = "pl345e N0TE +h4+ J00 C@Nnot r3cOvER dEl3teD pHorums. onCE dEL3+3d 4 PHOrum @ND @LL 0Ph it's @ssoc1@TED DA+4 1\$ p3rm@n3ntly rEmov3d phrom tEH D@+@84\$E. 1ph J00 Do n0+ w1Sh +o DEL3TE th3 seL3CTED f0rum5 plE4S3 cl1ck C@nCEl.";
$lang['successfullyremovedselectedforums'] = "sUCCEs\$fULly D3LE+3D \$3l3C+3d FoRUM\$";
$lang['failedtodeleteforum'] = "fa1l3D +0 DEL3teD f0rum: '%s'";
$lang['addforum'] = "aDd F0RUM";
$lang['editforum'] = "eDit f0RUm";
$lang['visitforum'] = "v1\$IT foruM: %s";
$lang['accesslevel'] = "acce5\$ L3v3l";
$lang['forumleader'] = "f0RUm lEAD3r";
$lang['usedatabase'] = "u\$e d4+@B@\$3";
$lang['unknownmessagecount'] = "uNknowN";
$lang['forumwebtag'] = "foRUm wE8+@G";
$lang['defaultforum'] = "d3F4ul+ phoRuM";
$lang['forumdatabasewarning'] = "plE@sE 3nSUR3 j00 5el3c+ +H3 COrR3cT D@+@8@\$e wH3N CRE4+ing A nEW pHorUm. OnCE CR3aTed A neW PHoRUm C4nn0T 83 M0VEd 83twE3n 4V4IlA8LE D@+484S3s.";

// Admin Global User Permissions

$lang['globaluserpermissions'] = "glo84l u\$3r p3rm1SSi0N5";

// Admin Forum Settings (admin_forum_settings.php) -------------------------------

$lang['mustsupplyforumwebtag'] = "j00 Mu5T sUppLy 4 FOrUM W38+@g";
$lang['mustsupplyforumname'] = "j00 mU\$+ SUpplY 4 phorUM N@ME";
$lang['mustsupplyforumemail'] = "j00 mu5+ \$upply 4 phOrUm 3M@Il 4DDR3ss";
$lang['mustchoosedefaultstyle'] = "j00 mUst Choo\$e @ DEFAULt forUM \$+yl3";
$lang['mustchoosedefaultemoticons'] = "j00 mus+ Cho0\$3 DEf4uL+ f0ruM EMoT1COn\$";
$lang['mustsupplyforumaccesslevel'] = "j00 mUs+ supPlY a Forum aCC3sS L3vEL";
$lang['mustsupplyforumdatabasename'] = "j00 must suPpLy @ phorUm D@+@BasE N4M3";
$lang['unknownemoticonsname'] = "uNKN0wN EMoT1CON5 n@M3";
$lang['mustchoosedefaultlang'] = "j00 MUst Ch00SE 4 DEf4ult PhoRUm l4ngu49E";
$lang['activesessiongreaterthansession'] = "act1v3 SESs1On t1ME0U+ C4NnoT 8e gR34teR +h@n \$e\$\$10n t1M30u+";
$lang['attachmentdirnotwritable'] = "at+4ChMEnt DIR3c+0Ry @ND \$Y\$+eM +3Mp0RArY DIr3c+oRY / phP.InI 'UPl0@d_Tmp_dIR' muST 83 Wr1+@8le 8y +h3 w38 sERvER / php PR0C3ss!";
$lang['attachmentdirblank'] = "j00 mUst suppLY 4 d1R3c+0Ry T0 s4V3 4++4chm3N+\$ IN";
$lang['mainsettings'] = "m41N s3T+1nGs";
$lang['forumname'] = "forum nAmE";
$lang['forumemail'] = "fORUm 3m@iL";
$lang['forumnoreplyemail'] = "nO-r3PLy Em41L";
$lang['forumdesc'] = "f0rum DE\$crip+1On";
$lang['forumkeywords'] = "f0RUm KeyWOrD\$";
$lang['defaultstyle'] = "d3f@ULt STyl3";
$lang['defaultemoticons'] = "d3ph@uL+ EM0+1cons";
$lang['defaultlanguage'] = "d3f@ulT l4N9U@GE";
$lang['forumaccesssettings'] = "f0rUM @CC3sS set+INgS";
$lang['forumaccessstatus'] = "fOruM aCc35s S+@+U\$";
$lang['changepermissions'] = "ch4NG3 p3Rmi5S1oNs";
$lang['changepassword'] = "ch@Nge P45sW0Rd";
$lang['passwordprotected'] = "pA\$sW0RD pr0+3c+eD";
$lang['passwordprotectwarning'] = "j00 H@VE N0T SEt 4 ph0rum P4s\$W0rD. If J00 do N0t s3+ @ PaSsw0RD Th3 p@ssw0rD pRot3c+I0N PHUnc+1on@l1+y w1ll 8E 4UtOm@+iC4lly DIS4BLEd!";
$lang['postoptions'] = "pO5+ 0pt10ns";
$lang['allowpostoptions'] = "aLlow p05+ 3D1T1n9";
$lang['postedittimeout'] = "poS+ 3diT +imeoU+";
$lang['posteditgraceperiod'] = "po5+ 3D1+ 9R4cE PER1OD";
$lang['wikiintegration'] = "wiK1w1K1 IntEGR4tioN";
$lang['enablewikiintegration'] = "en4BlE wikiW1Ki 1NTEGr4tion";
$lang['enablewikiquicklinks'] = "eN48le WikiWiKI QU1CK lInK\$";
$lang['wikiintegrationuri'] = "w1K1w1k1 loc4+I0n";
$lang['maximumpostlength'] = "m@ximum p0\$+ lEN9+H";
$lang['postfrequency'] = "p0st FREqU3NCy";
$lang['enablelinkssection'] = "en48LE lInks \$ecT1ON";
$lang['allowcreationofpolls'] = "aLLOW CR3At1on 0f P0lls";
$lang['allowguestvotesinpolls'] = "aLlow 9U3sts +o v0tE in P0LLs";
$lang['unreadmessagescutoff'] = "uNre4D m3SS49Es CU+-oFPh";
$lang['unreadcutoffseconds'] = "s3c0nDs";
$lang['disableunreadmessages'] = "d15@BLe UnREaD m3SS49e\$";
$lang['nocutoffdefault'] = "nO cUt-0PhPh (DeF4UL+)";
$lang['1month'] = "1 Mon+h";
$lang['6months'] = "6 m0n+H\$";
$lang['1year'] = "1 ye@r";
$lang['customsetbelow'] = "cu\$+0m vAlu3 (53+ 83Low)";
$lang['searchoptions'] = "s34rCH 0P+1ON\$";
$lang['searchfrequency'] = "sEarCh PhreQU3NCy";
$lang['sessions'] = "se\$s10NS";
$lang['sessioncutoffseconds'] = "sE\$SI0N CUT 0fpH (sECONDs)";
$lang['activesessioncutoffseconds'] = "aCtiv3 SEssi0N CU+ OpHpH (seC0nD\$)";
$lang['stats'] = "s+at\$";
$lang['hide_stats'] = "h1d3 \$+ats";
$lang['show_stats'] = "sh0w \$+4t5";
$lang['enablestatsdisplay'] = "enABL3 St4+\$ dI\$pl4Y";
$lang['personalmessages'] = "perSON4L M3ss@gE\$";
$lang['enablepersonalmessages'] = "en48lE p3r\$0n4L m3SS4G3s";
$lang['pmusermessages'] = "pm mE5S493\$ p3R U5er";
$lang['allowpmstohaveattachments'] = "alloW P3RS0N4L M3ss@ge\$ +0 h4v3 4T+@CHmEnts";
$lang['autopruneuserspmfoldersevery'] = "aU+O pRUn3 uSER'5 pm pHOLDEr5 3VEry";
$lang['userandguestoptions'] = "u\$3r @nD 9U3sT 0p+1on5";
$lang['enableguestaccount'] = "eN4BLE gUesT 4cCOuNT";
$lang['listguestsinvisitorlog'] = "l1\$+ gUEst5 1N vI\$i+0R LOG";
$lang['allowguestaccess'] = "aLlow 9u3st ACCe\$S";
$lang['userandguestaccesssettings'] = "uS3r 4nD gU3st @CCE5s 53+t1ng5";
$lang['allowuserstochangeusername'] = "aLlow Users to CH4nge UsErN4M3";
$lang['requireuserapproval'] = "reQU1R3 us3R @ppr0v4L BY @Dm1n";
$lang['requireforumrulesagreement'] = "rEqUIR3 u\$er +o @9R3e +o F0rUm RUl3S";
$lang['enableattachments'] = "en@8lE @t+4chmENts";
$lang['attachmentdir'] = "a++4ChMEnT DIR";
$lang['userattachmentspace'] = "a++4ChMEnt Spac3 p3R Us3r";
$lang['allowembeddingofattachments'] = "all0w Em8EDDiNG 0F 4tT@Chments";
$lang['usealtattachmentmethod'] = "uSE 4ltErn4t1v3 4++@CHm3NT me+h0d";
$lang['allowgueststoaccessattachments'] = "aLL0w 9UE5+\$ +0 @CCeS5 @++4cHM3n+\$";
$lang['forumsettingsupdated'] = "f0Rum s3TT1NGs sUcCESsfUlLY upDaTeD";
$lang['forumstatusmessages'] = "foRUM \$+@+Us m3SS493s";
$lang['forumclosedmessage'] = "f0rum cl0s3D ME\$5@g3";
$lang['forumrestrictedmessage'] = "fOrum r3sTR1ctED M3s\$4g3";
$lang['forumpasswordprotectedmessage'] = "f0Rum p4\$sw0rD pro+3CT3d m3SS@g3";

// Admin Forum Settings Help Text (admin_forum_settings.php) ------------------------------

$lang['forum_settings_help_10'] = "<b>p0S+ 3DiT +imE0U+</b> 1\$ TH3 +Im3 1n M1nutEs 4pHtER p05+iNg +h4t 4 U\$ER C@n EDI+ +H31r P05+. 1F 53+ +0 0 +h3RE 1S No l1mi+.";
$lang['forum_settings_help_11'] = "<b>m4x1MUM P0\$+ L3Ng+h</b> 1s +3H max1muM NUm8er 0F CH4r4CTERs +H4+ WiLL 83 DI5pL4yeD 1n 4 P0st. IPH @ post is L0n93R tH4N +HE NUm8Er 0F CH@r4ctERs d3fiN3D h3rE It WiLL 8E CU+ \$h0Rt 4Nd 4 LiNk 4Dd3D +o teH B0t+Om t0 4LL0W USEr\$ to R3@D teH wH0LE PO5+ on @ \$ep@R@t3 p49e.";
$lang['forum_settings_help_12'] = "iPh j00 Don't w@n+ Y0Ur U\$3rs +o 8E @8le +0 CRE4+3 POlL5 J00 c4N di\$@8le T3h 4B0v3 0P+1On.";
$lang['forum_settings_help_13'] = "tEh lInKs \$Ect10n 0ph B33h1v3 Pr0v1DE\$ @ Pl@Ce Ph0R yoUR U\$erS +o m41N+41N 4 L15+ OpH s1+3s +H3y phREQUEn+Ly v1\$i+ thAt 0thER Us3rs m@Y FiNd UsEPHUL. L1nk\$ C4n 83 DIvID3D 1nT0 c4+eg0r1Es 8y PholDer @nD 4Ll0W f0R ComMEnts @nD R4t1Ngs +0 B3 GIV3n. IN ordEr +o m0d3r4te +he lInks s3c+Ion 4 User mUs+ BE r@n+3D Glob4L modEr4Tor st4tUs.";
$lang['forum_settings_help_15'] = "<b>s3\$S1on cu+ OfPh</b> 1s +3H m4XiMuM +iME 8EF0RE 4 u53r'\$ \$E\$SI0n 1\$ dEEM3D D34d 4nD tHEy ar3 lo9G3D 0ut. by D3F4ulT TH15 i\$ 24 houRs (86400 5EC0nd\$).";
$lang['forum_settings_help_16'] = "<b>ac+1VE sE5sion CUt 0pHph</b> 1\$ +h3 M4ximum +IM3 8EF0re a u\$3r'\$ 5e5Si0n 1\$ d3EMEd 1n4Ct1v3 4t whiCH p0in+ +hEy eNtER aN 1DLE S+@+E. 1n +HI\$ \$t4+3 +He UsEr rEmA1N\$ lO993D iN, bUt tH3y 4re R3MovEd phroM ThE 4c+iv3 us3Rs li\$+ iN +H3 st4+5 D1spL4y. 0nC3 +heY 83com3 4c+IVE 494in +H3y wiLl BE r3-ADDed +0 t3h lIst. by DEphAul+ +h1\$ SEtTing 1\$ sEt tO 15 m1nu+Es (900 secoNDs).";
$lang['forum_settings_help_17'] = "en@8l1n9 thI\$ opt10n 4Ll0WS 8e3hIV3 +0 1nClUD3 @ s+@+\$ Di\$PL4y a+ +H3 8ottoM 0f teH M3ss49E\$ P@N3 S1M1l4R +0 +eh oN3 UsED BY m@ny f0rum 5oph+w@rE t1+les. OnCE 3n4BL3D thE D1Spl4y 0Ph tEH \$+@TS p@9e C4N 83 +099LED iNDIviDU4LLY BY E4CH U\$3r. 1ph +h3Y Don't w4nt +0 53e it +hey C4n h1D3 iT fr0M vi3w.";
$lang['forum_settings_help_18'] = "peRs0n@l M3ss@g3S 4r3 INv@LU4ble @\$ @ W4Y 0f t4k1Ng mor3 Pr1v4TE m@++3rs 0ut opH Vi3w 0ph tHE 0+h3R M3M83Rs. HoW3VER 1f j00 D0N't W4Nt y0UR U\$ers +o 8E 4BlE +0 sEnD E4CH 0TH3R pER50N4l MES549ES j00 C4n DIs@8LE +h1s 0P+1oN.";
$lang['forum_settings_help_19'] = "pEr\$0n4L m3sS@Ge\$ c4n Al\$0 C0nt4IN at+@CHMenTs WhICH c4n 8E U\$3phUl pHoR 3XCH4n91Ng pHiL35 8EtwE3N U5ers.";
$lang['forum_settings_help_20'] = "<b>nO+e:</b> +3h sp4CE @lL0C4+i0N PhoR pM ATtAchmEN+5 i\$ +@k3n From 3Ach USERs' M@In @tt4CHm3NT 4lL0c@t10n 4nD 1\$ n0t 1N @DD1+I0n to.";
$lang['forum_settings_help_21'] = "<b>eN@8l3 9U3s+ @CC0unt</b> 4llow5 V1sI+0Rs +0 8rowsE yOUR phoRUm @ND r3@d P0StS wItH0u+ rEG1\$+3rInG @ UsEr aCC0uNt. A usER aCCOUnT i5 5+Ill R3QU1r3d If +h3y w1\$h +0 p0\$+ oR ChAn9E UsEr pREphERENCeS.";
$lang['forum_settings_help_22'] = "<b>l1\$t gU3sts 1n v1si+OR l09</b> @Ll0W\$ j00 +0 5P3c1Fy wHETHEr or N0t UnrE9IS+eR3d UsER\$ 4r3 LI5+Ed 0n teh V1\$i+oR L09 @LoN9 51d3 Reg1\$+ER3d USEr\$.";
$lang['forum_settings_help_23'] = "be3h1V3 4llow5 aTtaCHMEnTs t0 BE UpLO@d3d +O MEss4ge5 when Po\$+3D. 1F j00 h@VE lImi+3d wE8 sp4C3 j00 m@y WhiCH t0 D1\$48Le 4tt4CHm3nts bY Cl34R1n9 th3 80X @BOVE.";
$lang['forum_settings_help_24'] = "<b>aT+aCHm3nt d1r</b> Is +3H LoC4t10n 8EEH1V3 \$H0ulD st0re I+'5 @++4cHm3NtS in. tH1\$ dirEC+0ry mU\$+ exi\$+ 0N y0ur WE8 sp@C3 @nD mUs+ B3 wr1+4BlE BY +3H w3b 53rVER / php PRoC3sS 0th3rwi\$3 upLoADs will PH@IL.";
$lang['forum_settings_help_25'] = "<b>a+t@ChmeNt sP@CE p3r usER</b> Is +EH m4X1mUm @moUnT 0ph D1\$k sP4CE @ usEr h@\$ PHor 4++4CHM3NTs. 0nC3 +H1\$ 5Pac3 1\$ usED UP TEH u\$3r CANN0+ UPL04D 4nY MoRE @++4chM3n+\$. by D3f4UlT +his I5 1MB OF \$paC3.";
$lang['forum_settings_help_26'] = "<b>alLow EM83dDiNg oPh atT4chMEn+\$ iN ME5S4g3S / s1GN@tuRES</b> AllowS U53r\$ t0 emb3D 4Tt4cHmEntS In P05+5. 3n4BLInG THIs 0Pt10n WH1LE usEPhUl C4n 1NCRe4\$3 yOUr 84NDW1d+h US4G3 dRaS+iC4lly UNDER c3r+41N coNF1GUr4+10n\$ of phP. if j00 h@VE l1mi+3d 84NDwid+h it Is r3CommendEd +h@T J00 d1s4BLE thIS opt10n.";
$lang['forum_settings_help_27'] = "<b>uSE 4l+3rn4+1VE 4t+@CHMENt m3tHOD</b> Ph0RC3s 8E3hiv3 t0 UsE @n al+ERnATIvE reTrIEv4l M3Th0d F0R 4ttacHmENtS. 1f j00 REC31V3 404 3RrOR M3ss4g3s WH3N +RyIN9 +0 D0WnL04D @++4chm3ntS PhROM m3SS493\$ +Ry 3N4bl1NG tH15 0p+i0n.";
$lang['forum_settings_help_28'] = "tHis s3++1ng 4LLOws yOUr pH0RUm To 8E 5pid3r3D 8y se4rCh EN9ine\$ l1K3 g00Gl3, Al+@viStA 4ND YaH0o. 1ph j00 sWi+CH +h1\$ OpT1On opHpH Y0UR PhoRUM w1LL n0t b3 1nclUDeD 1n th35E se4RCH eNGinE5 r3sUltS.";
$lang['forum_settings_help_29'] = "<b>aLLoW NEW u\$3r RE9i\$TR4t10n\$</b> 4ll0WS 0r di\$@llows +h3 CRE@TiOn oPh nEW User 4cC0unTS. \$3tT1NG Th3 opT10n +0 n0 c0MPL3teLY D15@BlEs +3H rE9is+r@+I0N PhOrM.";
$lang['forum_settings_help_30'] = "<b>en48le W1k1wikI 1N+EGR@T10n</b> ProV1d3\$ WIKiWOrD sUPp0r+ In yOUr pHOrUm pOsTs. @ wik1WORd 15 M4DE UP 0F TW0 oR MOr3 conc4tEn4+3D w0RD\$ witH uPP3rC453 l3+tEr\$ (of+3n R3PhERr3d +0 4s c4MELCAsE). IF J00 wrI+3 4 word +hi5 w@y i+ wILl 4Ut0m4+iC4lly b3 Ch4Nged Int0 4 hyp3rlInk po1Nt1ng t0 y0ur cho\$eN wik1wik1.";
$lang['forum_settings_help_31'] = "<b>en@8LE W1KIWiKI qUICK l1nkS</b> en@bL3s th3 US3 0ph Ms9:1.1 4nD u\$er:l0G0n stYL3 3XT3nD3d wikIL1nK5 wH1cH cRE4+3 hYPeRLINk5 +0 ThE \$P3cIpH13d M3Ss49E / Us3R pR0Ph1Le 0F +He \$PEcifi3d Us3R.";
$lang['forum_settings_help_32'] = "<b>wIKiWIkI loC4tion</b> 1s Us3d +0 SpEC1fY +3H UR1 0PH Y0ur WiKIw1ki. whEn 3n+3r1Ng t3H UR1 u53 [wIkiw0RD] +0 1ND1ca+3 WHEr3 IN +h3 ur1 tHE w1k1w0rD sH0uLD 4PPe4R, 1.E.: <i>h+tP://En.wiKIp3D1@.OR9/WIK1/[w1kiword]</i> WOuLD l1nk Y0uR w1K1words T0 %s";
$lang['forum_settings_help_33'] = "<b>forUm 4CcEss St@TuS</b> c0N+r0Ls H0w U\$eRs m4Y @cC3s\$ YOuR PhOruM.";
$lang['forum_settings_help_34'] = "<b>op3N</b> wiLL 4Ll0W aLl Us3R\$ AND 9uEs+\$ AcC3sS tO y0Ur Ph0rum wi+hOUt r3s+R1ct10N.";
$lang['forum_settings_help_35'] = "<b>cL0sED</b> PR3v3nts 4CCEs\$ FoR 4ll U\$3rs, w1th +3h exC3PT1on Of +h3 4DM1N WhO M4y sT1LL 4cCESS +hE @DM1N P@n3l.";
$lang['forum_settings_help_36'] = "<b>re\$+riCTeD</b> 4llow\$ +o \$et 4 li\$+ opH Us3r5 Who 4RE 4LLoW3D @CC3ss tO Y0UR PHorum.";
$lang['forum_settings_help_37'] = "<b>pas\$WorD Pr0+3c+3d</b> AlLow\$ j00 to set a p@5sW0RD +0 9Iv3 0U+ +0 u\$3rs \$0 tHEy C4N 4ccEss Y0Ur ph0ruM.";
$lang['forum_settings_help_38'] = "wheN SEtT1NG R35+R1cted oR P4s\$w0rd pR0+3cTED m0dE J00 wiLL n33D to s4V3 youR CH4n93S 8EFORe j00 C@N CH4nge +3H u53R acCE\$s pr1v1l3ges oR p4sSW0rD.";
$lang['forum_settings_help_39'] = "<b>Search Frequency</b> defines how long a user must wait before performing another search. Searches place a high demand on the database so it is recommended that you set this to at least 30 seconds to prevent \"search spamming\"fR0M k1ll1NG The sERVER.";
$lang['forum_settings_help_40'] = "<b>poSt PhREqU3ncy</b> 1s +3h MINImUm T1M3 4 USer MU\$+ w41+ 8EF0RE +hEY c@N p05+ 49A1n. thIs \$ettINg @L\$O @pHpH3CT\$ +h3 crE4t10n 0PH pOlL\$. SEt +0 0 +o DIs@Bl3 +HE rEStrICTI0n.";
$lang['forum_settings_help_41'] = "thE 4BOvE OptI0N5 CH4ng3 +he Deph@UlT V@LuEs F0r +3h U\$3r RE9i\$+R4T10N F0Rm. WH3R3 4ppl1c@BLE 0ThEr sEtT1ngs W1LL Us3 tEH F0RuM'\$ 0wN D3ph4UlT \$E++1nG\$.";
$lang['forum_settings_help_42'] = "<b>pR3vent U\$3 oF duPliC4TE 3ma1l 4DDRE\$S3s</b> ph0rCE5 beEH1v3 +0 chECk teh U\$3r @CC0unts 49@iN\$T +hE 3M4il 4DDrEs\$ +h3 U\$3r I\$ r39ISTer1N9 wi+H @nD PrompTs tH3M t0 usE @N0Th3r 1F iT I\$ @lrE4dy iN Use.";
$lang['forum_settings_help_43'] = "<b>reQu1Re EM4Il CONphIRM@+i0n</b> Wh3N EN4BLED W1ll 5END 4N 3m@il to e4ch nEw Us3r Wi+h @ l1nk +h4+ C4n bE UsED +O c0nph1Rm TH3Ir EM4IL 4dDRE\$s. Un+iL THEy Conf1RM TH31R 3m41l adDR3S\$ +h3Y WiLL nO+ BE 4blE To p05+ UnLE\$S +h31R u5er PERmI5Si0Ns 4RE CHAn9ED m4NU@llY 8y @n 4DMiN.";
$lang['forum_settings_help_44'] = "<b>u5E +ext-c4p+Ch@</b> pr3sEnts +3H nEW usER w1+H @ MAnGL3D iM493 wh1CH +hEy MUs+ coPy @ NUm8ER Fr0m in+0 4 texT fi3lD 0n +hE rE9is+R4+1oN pHorm. USE +H1\$ OpT1oN to pr3v3nT 4U+oM4TED 5ign-Up VI@ \$CR1pts.";
$lang['forum_settings_help_45'] = "<b>t3Xt-C@Ptch4 DIR3Ctory</b> SP3CIFi3S tH3 L0CAT1on +H4t BEEHIV3 w1ll \$TOre 1t's +3xt-C4P+CH4 1M4g3S 4nd F0NT\$ In. +h1\$ D1r3C+0ry MUSt 83 wr1+48Le 8y t3H w38 sErV3R / pHP procEs5 4nd mUsT 8E 4Cc3ssiBLE vi4 H+Tp. @ph+3R j00 h4vE 3n4Bled +3XT-c@PtCH4 j00 mu\$t upLO4d 5ome +ruE typ3 f0n+s in+0 tEh fon+s \$uB-D1R3C+0rY oF yOUr m41n +3Xt-C4ptCh4 d1r3c+0ry 0tH3Rw15e 8E3hive w1ll sk1P +h3 text-captch@ Dur1ng User r3G1s+r4tioN.";
$lang['forum_settings_help_46'] = "<b>Text Captcha key</b> allows you to change the key used by Beehive for generating the text captcha code that appears in the image. The more unique you make the key the harder it will be for automated processes to \"guess\"tHe coDE.";
$lang['forum_settings_help_47'] = "<b>p0St eDI+ 9R4c3 p3Ri0d</b> 4llow\$ J00 +o d3FInE 4 P3r10D iN mInUtes Wh3R3 u53rs m@y ED1+ p0\$+s w1Th0UT +Eh 'ED1+ED By' TExt 4Pp34r1ng On ThE1r po\$+s. iph sEt +0 0 TH3 '3ditED BY' tex+ wILl 4lw4Ys 4pp34r.";
$lang['forum_settings_help_48'] = "<b>unR3@D mEss493s cUt-0pHpH</b> SpeCIpHIEs h0w l0N9 UnRE4D MEss@gE\$ @r3 reTa1N3d. j00 M4y Ch0O\$3 fr0M V4ri0U\$ PrEsE+ v@lUEs 0R EnteR y0ur 0Wn Cu+-ophf p3RI0D 1n s3C0nds. ThR3aD\$ m0D1PhIeD E@rl13R +h@n +h3 d3ph1n3D CU+-0fF P3ri0D wIll 4u+0Mat1c4LlY @ppear @\$ r34D.";
$lang['forum_settings_help_49'] = "cH0Os1nG <b>dis4BlE Unr34d mEss@g3s</b> W1ll coMPL3TelY r3mov3 uNrE4d m3sS@G3S \$uPP0rt 4ND r3m0V3 +h3 R3l3V4N+ OpT1On\$ pHrom thE DI\$CU5si0N typE DRop D0WN 0N TEh +Hr3@D L1\$T.";
$lang['forum_settings_help_50'] = "<b>r3quiRE UsEr 4Ppr0VAL By @DMIn</b> @llOwS J00 tO r3str1CT 4ccES5 BY n3w U5ERs UNtil +h3y h4VE b33N 4ppRoV3D BY @ m0d3r4+oR or 4DM1n. w1+hoUt 4ppRoV@L 4 u\$er c4nnOt 4CcesS @NY 4rea 0f tEH BEEHIVE PhorUM In\$+4lL@ti0N 1nclUDING 1Ndiv1DU@l pHorUMs, Pm 1NBOx @nd my F0rUms s3C+10ns.";
$lang['forum_settings_help_51'] = "us3 <b>cl0seD m3ss4G3</b>, <b>r3s+rictED Mess@G3</b> @Nd <b>p@\$Sw0RD Pr0TEC+3D mE5S@GE</b> t0 Cus+oM1S3 +eh M3sS@GE D1\$PLay3d Wh3n U\$3rs 4CCEs\$ YOUr PhoRum 1n t3H v4ri0U\$ \$+@Te\$.";
$lang['forum_settings_help_52'] = "j00 c4n use H+mL 1N yoUR m3SSaGEs. hYperL1NKs @ND 3maIl 4DDR3ss3\$ WIll @l\$O 8E @Ut0m4+IC@lLY C0NV3r+3d +0 liNks. tO US3 +h3 DEPh4ulT b3eh1vE PhoruM MES\$49E\$ Cl34R teh f13lDs.";
$lang['forum_settings_help_53'] = "<b>aLl0w u\$3r5 to Ch@Ng3 U5ErNaME</b> PERmI+S aLr34Dy r39i\$+3rED U53rs +o Ch4N9e +heir U\$ern@m3. wh3N 3na8LED j00 C4n tr4Ck +Eh ch4N9Es @ usEr mAkes +0 Th31R us3RN4me vI4 Th3 4Dm1n us3r +O0ls.";
$lang['forum_settings_help_54'] = "u5E <b>f0rum rUl3S</b> T0 en+3R @N @CC3pt@8LE Use pOl1cy +h@t 34CH UsEr mU5+ @gR3e +0 83F0r3 r39iS+3r1Ng 0n YOUr PHorUM.";
$lang['forum_settings_help_55'] = "j00 C@N u\$e h+ml 1n yoUR phOrUM rUlE5. hYp3rl1NKs 4ND 3MA1L 4ddR3ss3S w1ll AL\$0 83 4UT0m4T1c4LlY c0nv3R+3d +0 linKs. To u\$e +H3 DEF4ul+ 833h1v3 PhorUM @Up Cl3@r tEh Fi3lD.";
$lang['forum_settings_help_56'] = "us3 <b>no-r3pLy 3M4Il</b> +0 sp3cipHy 4N EM41l @DDREs\$ +H@+ DOES No+ 3X1\$+ oR w1lL N0t 83 moniTor3d For r3plIE\$. THis 3ma1l aDDRE5s wiLL 8e U\$3D In +3h h3@d3r\$ f0r @lL 3ma1Ls s3n+ PhR0m yOUr ph0ruM INCLUD1n9 BU+ N0t liMi+3d +0 p0sT 4nD PM N0T1fic4+i0n\$, User 3M4il\$ @nD p4Ssw0RD reminDErs.";
$lang['forum_settings_help_57'] = "it 1s r3CommEND3d +h4t j00 us3 4n Em41l 4DDREss +H@+ DoEs N0t ex1\$+ +0 hElP CUt DowN 0n sp4m TH4+ m4Y 83 DiReC+ED 4+ yOUr m4in phorUM 3ma1l 4dDr3\$\$";

// Attachments (attachments.php, get_attachment.php) ---------------------------------------

$lang['aidnotspecified'] = "aid NO+ \$p3CifI3D.";
$lang['upload'] = "uPL04D";
$lang['uploadnewattachment'] = "uPlO4D n3W 4T+@CHMEN+";
$lang['waitdotdot'] = "w@i+..";
$lang['successfullyuploaded'] = "sUcc3\$sphUlly Upl0@d3D: %s";
$lang['failedtoupload'] = "faiL3d +0 uplO4D: %s";
$lang['complete'] = "cOMPlETe";
$lang['uploadattachment'] = "uPlo4D 4 PhiL3 PH0r @t+4chMEn+ +0 +EH M3\$\$49E";
$lang['enterfilenamestoupload'] = "en+Er pH1L3n4mE(s) +0 Upl0@D";
$lang['attachmentsforthismessage'] = "at+4cHmenTs f0r +His Mess493";
$lang['otherattachmentsincludingpm'] = "o+H3r 4++4chm3N+s (1NCluD1ng pm ME\$S493S 4Nd 0+h3R phoRUMs)";
$lang['totalsize'] = "t0Tal size";
$lang['freespace'] = "fr33 sP4CE";
$lang['attachmentproblem'] = "th3RE W4S 4 PROBlem dOwNloaD1ng +HI\$ 4+t4CHmEN+. pL34se tRy 4G41N L4+3r.";
$lang['attachmentshavebeendisabled'] = "a+TACHm3nt\$ H@v3 8eEn D1\$4BlED BY +he pHOrUM 0wn3R.";
$lang['canonlyuploadmaximum'] = "j00 C4n 0NlY UPLo@D 4 m@xImUm of 10 phiL3S @+ 4 TiME";
$lang['deleteattachments'] = "dELETE 4+t@CHM3N+s";
$lang['deleteattachmentsconfirm'] = "arE j00 5Ur3 J00 w4N+ to DELE+E teh sEl3cteD @+T4CHm3nts?";
$lang['deletethumbnailsconfirm'] = "ar3 j00 \$UR3 j00 w4N+ +0 d3LeTE +H3 sEl3C+3d @++4CHmENtS thuMBN41ls?";

// Changing passwords (change_pw.php) ----------------------------------

$lang['passwdchanged'] = "pA5\$WORD CH4ngeD";
$lang['passedchangedexp'] = "your P4ssW0RD hAS 8EEN CH@N9ED.";
$lang['updatefailed'] = "uPD4+3 F4ileD";
$lang['passwdsdonotmatch'] = "p@S\$W0rD\$ d0 No+ m@TCH.";
$lang['newandoldpasswdarethesame'] = "n3W anD 0LD p45Sw0rd\$ 4r3 +3H s4me.";
$lang['requiredinformationnotfound'] = "rEqu1r3D 1NPH0RM4+ion NoT PHOunD";
$lang['forgotpasswd'] = "f0R90+ P45\$w0rD";
$lang['resetpassword'] = "reSE+ p45SW0RD";
$lang['resetpasswordto'] = "rE\$eT p@\$sw0Rd to";
$lang['invaliduseraccount'] = "iNVaLiD UsEr 4cC0unt \$P3c1PH13D. CH3CK 3m4Il PhOr coRR3C+ l1NK";
$lang['invaliduserkeyprovided'] = "iNV4l1D Us3r KEY ProViDEd. chECK EM4Il pHor cOrRECT Link";

// Deleting messages (delete.php) --------------------------------------

$lang['nomessagespecifiedfordel'] = "n0 m3S\$@GE spECIPhi3d f0R d3l3Tion";
$lang['deletemessage'] = "d3L3t3 ME\$s4g3";
$lang['postdelsuccessfully'] = "po5T D3l3+3D SUcCEssPhUlLy";
$lang['errordelpost'] = "erRor dEl3t1Ng po\$+";
$lang['cannotdeletepostsinthisfolder'] = "j00 c4NN0t dEL3Te pO\$+\$ in +hi5 Ph0LDER";

// Editing things (edit.php, edit_poll.php) -----------------------------------------

$lang['nomessagespecifiedforedit'] = "n0 mEss@GE 5p3C1Ph13D For EDITing";
$lang['cannoteditpollsinlightmode'] = "c4NN0t 3DI+ p0LLS in L19H+ m0D3";
$lang['editedbyuser'] = "edI+eD: %s 8Y %s";
$lang['editappliedtomessage'] = "eD1+ 4PPLIEd +O mESs49e";
$lang['errorupdatingpost'] = "erROr uPD@+Ing post";
$lang['editmessage'] = "ed1t me\$S49E %s";
$lang['editpollwarning'] = "<b>noTe</b>: eD1+1n9 c3R+@in @\$p3Ct\$ oph 4 p0ll wIlL v0id 4ll +HE cURrEnT v0tEs @nD 4lLOW PE0PL3 +0 V0te 4G41N.";
$lang['hardedit'] = "h@RD EDI+ 0pt10NS (v0te\$ will B3 r3sE+):";
$lang['softedit'] = "s0fT EDI+ op+iOn\$ (votES W1Ll B3 rEt41nED):";
$lang['changewhenpollcloses'] = "cH4nGE Wh3n TEH PoLl cL0s3S?";
$lang['nochange'] = "n0 ch@n93";
$lang['emailresult'] = "eMa1l R3\$UL+";
$lang['msgsent'] = "mEsS49e 5en+";
$lang['msgsentsuccessfully'] = "m3s5@G3 seN+ sUCCEsspHULLY.";
$lang['mailsystemfailure'] = "ma1l system f41luR3. ME\$s4g3 n0T seN+.";
$lang['nopermissiontoedit'] = "j00 @Re N0+ pERMi+tED +o 3di+ THi\$ M3ss4g3.";
$lang['cannoteditpostsinthisfolder'] = "j00 C4NNO+ 3D1+ Po\$+s iN Th1s f0ldEr";
$lang['messagewasnotfound'] = "mE\$S4g3 %s W@S no+ pHoUnD";

// Email (email.php) ---------------------------------------------------

$lang['sendemailtouser'] = "send 3m41l TO %s";
$lang['nouserspecifiedforemail'] = "nO u\$3r \$PECIpH13d phoR EMa1L1ng.";
$lang['entersubjectformessage'] = "en+Er 4 \$ubJeC+ pHoR tHE m3S\$@G3";
$lang['entercontentformessage'] = "en+3R \$OM3 CoN+3nT F0r th3 mEsS@ge";
$lang['msgsentfromby'] = "tHIs m3SS493 w4S 5en+ PHrOm %s 8y %s";
$lang['subject'] = "subJeCt";
$lang['send'] = "send";
$lang['userhasoptedoutofemail'] = "%s H4s 0pTed 0UT 0f 3M@il CON+@CT";
$lang['userhasinvalidemailaddress'] = "%s H@s 4N 1nv4l1D 3M41L @DDrE\$S";

// Message nofificaiton ------------------------------------------------

$lang['msgnotification_subject'] = "meS\$49e n0+1f1ca+1On PHrOm %s";
$lang['msgnotificationemail'] = "h3lLO %s,\n\n%s pos+3d @ ME\$S493 t0 j00 0n %s.\n\ntHE 5u8J3c+ i\$: %s.\n\nto rE@D +H@+ m3SS493 4nD 0+h3r5 1n +h3 s@mE D1\$cussi0n, g0 tO:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nN0+e: iPh j00 Do n0t w15h to r3c31v3 Em4Il n0+1PHiC4+10Ns 0ph phorUm mEss4gEs pos+ed T0 you, G0 to: %s CL1cK 0n MY ContR0ls +h3N em41l 4ND pr1V4Cy, UnsEl3Ct t3H 3m41l no+IFIC@+1On ch3CkBox @nd pr3Ss sUBM1t.";

// Thread Subscription notification ------------------------------------

$lang['subnotification_subject'] = "sUbsCr1p+i0n n0T1F1c4TIOn phr0m %s";
$lang['subnotification'] = "heLlo %s,\n\n%s pos+ED @ m3sS493 1n @ tHRE4D J00 havE \$u8SCrI8ED +0 on %s.\n\n+HE 5Ubj3C+ i\$: %s.\n\nto rE4D +H4T MEss@gE @nD 0+HErS 1N ThE s@mE d1scu\$s10n, g0 +O:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nNote: IpH J00 D0 No+ wi5H +0 rECE1ve EM@1l notificat1Ons OF new m3s\$@ge5 in tH1\$ +hr3@D, g0 +o: %s @ND 4djU\$T your 1ntEr3\$+ l3vEl @t +3h Bo++0m oPH +H3 p49E.";

// PM notification -----------------------------------------------------

$lang['pmnotification_subject'] = "pm Not1f1c4+i0n FR0m %s";
$lang['pmnotification'] = "hELlo %s,\n\n%s p0\$+3d 4 PM +0 j00 0N %s.\n\ntHE \$ubj3C+ I\$: %s.\n\nt0 RE4d +hE MEss493 g0 +o:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nn0+3: Iph J00 do noT w1\$h +0 rECE1v3 3ma1l NotIPhIC4+i0Ns 0F nEW pm m3Ss4g3s p0steD +o y0U, g0 to: %s CliCk mY c0n+r0lS +h3N em4il AnD priv@cY, un\$3leC+ +eh Pm n0+1Ph1C@+i0N Ch3Ck8ox 4Nd preS\$ Su8M1t.";

// Password change notification ----------------------------------------

$lang['passwdchangenotification'] = "p4\$sWORD CH4NG3 nOT1phiCa+1on Fr0M %s";
$lang['pwchangeemail'] = "heLlO %s,\n\n+hi5 @ N0t1F1C4+IoN eM41L to 1nphORm J00 th4+ y0ur P45\$W0rD on %s H4S 8EEN CH4ngeD.\n\nI+ H4\$ be3N Ch@N9eD +o: %s 4nD W@\$ ch4N9ED BY: %s.\n\n1PH J00 h@V3 rEC31v3D th1S EM@Il 1N 3rroR or W3RE noT ExPECT1Ng 4 CH4N9e +0 y0ur P@Ssw0rd Pl34\$3 COnt4Ct thE f0Rum 0WN3R or a m0D3r4tor 0N %s IMmed1@+3Ly +o corR3Ct I+.";

// Email confirmation notification -------------------------------------

$lang['emailconfirmationrequired'] = "eM@1l COnFirm@+i0n rEqUir3d f0r %s";
$lang['confirmemail'] = "h3LL0 %s,\n\nY0u R3C3ntLy CR34+3D @ nEw U\$er acc0Unt 0N %s.\n8epHor3 J00 CAN s+4r+ pO\$t1NG we nE3D +0 CONF1Rm Y0UR 3M41L aDDrE5s. DOn'+ w0rry +HI\$ i5 Qu1t3 345Y. 4ll j00 nE3d to D0 1S cLiCK +3H l1nk B3l0w (0R C0Py @nd p4sTE i+ iN+0 yoUr 8roW\$er):\n\n%s\n\nonc3 ConphIRM@+i0N i\$ c0mPLET3 j00 m4y lO91n @ND starT pos+1ng 1Mm3D14tely.\n\nif j00 diD n0T crE@+3 a UseR @CC0Unt on %s pl345e @CC3p+ 0ur @poLOGie\$ 4ND phorw@rD thi\$ 3m@il +0 %s so th@+ Th3 5ourc3 oph 1T m@y BE inv3St19AT3D.";
$lang['confirmchangedemail'] = "h3llO %s,\n\nY0u REC3n+ly CH4n93D Y0ur Em4il On %s.\n8EF0RE j00 C4n \$t4rt p0ST1n9 49@in wE NE3d +0 CONphiRm y0ur New 3m4Il 4ddRE\$\$. DOn't W0RRy +Hi\$ I\$ QU1+3 34\$y. 4LL J00 nE3D tO D0 is cliCK +he l1nk b3lOw (or C0py @ND p@ste 1t iN+0 your BrOwSEr):\n\n%s\n\noNCE ConfIRM4tion 15 C0mplEtE j00 m@y C0ntinU3 t0 Us3 +3h phorUm 4S norm@l.\n\niPH j00 WEr3 No+ 3Xp3c+1N9 +hi\$ Em@1L phr0m %s Ple4s3 4CC3pt 0ur ap0l0g13S 4nD f0rw@rD Thi\$ ema1l t0 %s s0 th@+ +3h \$0urc3 0ph 1T m@y B3 invest19@teD.";


// Forgotten password notification -------------------------------------

$lang['forgotpwemail'] = "h3LL0 %s,\n\nyoU ReqUeSted +hI5 3-m41L phRoM %s b3C@Us3 j00 haVE f0R9ot+eN YoUr PAssworD.\n\nCl1ck +hE link Bel0w (0r Copy 4nD P@stE i+ int0 yoUr BROw\$Er) To R3s3+ y0ur p@\$\$W0RD:\n\n%s";

// Forgotten password form.

$lang['passwdresetrequest'] = "y0Ur p4sSWoRD RE53+ r3qu3St pHr0m %s";
$lang['passwdresetemailsent'] = "p4S\$W0rd reseT 3-m4Il s3Nt";
$lang['passwdresetexp'] = "j00 \$HOUlD 5Hor+lY r3c31v3 4n 3-m@il CoN+@inin9 INs+rUC+1on\$ phor r3SE++1NG youR p4SsW0RD.";
$lang['validusernamerequired'] = "a v4l1D Us3RN@me I\$ reqUIr3D";
$lang['forgottenpasswd'] = "fOrg0+ P4\$SW0rD";
$lang['couldnotsendpasswordreminder'] = "c0Uld n0t s3nD p45sw0RD R3M1nd3R. Pl34Se cont4CT +3h FOrUM own3R.";
$lang['request'] = "requEst";

// Email confirmation (confirm_email.php) ------------------------------

$lang['emailconfirmation'] = "em@il c0nph1rm4T1on";
$lang['emailconfirmationcomplete'] = "tH4NK J00 ph0r ConpH1rMING YoUr 3M4iL 4dDr3S\$. j00 M@y n0w loG1N AND \$+4rT po5+1N9 ImM3D1@tElY.";
$lang['emailconfirmationfailed'] = "eM41l C0nph1rm@t1ON H@\$ F@il3D, pl34\$3 +ry 4G41n l4T3R. IpH j00 3NCOUNt3R TH1s 3rRor mULt1PLE T1m3s PlE4SE C0n+@C+ +HE pH0RUM 0WnER oR a M0d3R4+0R f0r @\$SI5+4ncE.";

// Links database (links*.php) -----------------------------------------

$lang['toplevel'] = "top l3Vel";
$lang['maynotaccessthissection'] = "j00 m4y noT 4Ccess tHis sEC+1ON.";
$lang['toplevel'] = "top L3VEl";
$lang['links'] = "lInk\$";
$lang['viewmode'] = "vi3w MoDE";
$lang['hierarchical'] = "h13R4RChIC4l";
$lang['list'] = "lI\$+";
$lang['folderhidden'] = "tHI\$ F0LDER is H1ddeN";
$lang['hide'] = "h1d3";
$lang['unhide'] = "unH1d3";
$lang['nosubfolders'] = "n0 \$UBPholDER5 in tH1\$ c4+390Ry";
$lang['1subfolder'] = "1 SUBFOlDEr 1N Th1\$ C4TEGory";
$lang['subfoldersinthiscategory'] = "suBF0lDEr\$ IN th1S C4T3Gory";
$lang['linksdelexp'] = "enTrI3s 1N @ del3+3d pHoLDER wIll 8E MOvEd to TEH P4R3nt f0ldeR. 0nly pH0ld3rS Wh1cH D0 n0+ C0n+@In \$uBF0ldER5 M4y 8E DEL3+3D.";
$lang['listview'] = "li\$+ vi3w";
$lang['listviewcannotaddfolders'] = "c4Nno+ aDD PH0LD3rs iN tH1S V1Ew. sHoWiN9 20 eN+rI3S 4T 4 T1m3.";
$lang['rating'] = "ra+INg";
$lang['nolinksinfolder'] = "n0 l1Nks IN Th1S pHolDEr.";
$lang['addlinkhere'] = "add L1Nk H3R3";
$lang['notvalidURI'] = "th@t 1S n0T 4 valID UrI!";
$lang['mustspecifyname'] = "j00 musT 5P3CIFy @ N4M3!";
$lang['mustspecifyvalidfolder'] = "j00 mU5+ \$p3cipHy 4 v4l1D pHoLD3r!";
$lang['mustspecifyfolder'] = "j00 mus+ sp3c1PHy 4 PH0ld3R!";
$lang['successfullyaddedlinkname'] = "sUcces\$phuLlY 4dD3d l1nk '%s'";
$lang['failedtoaddlink'] = "f4IL3d +o @DD LInk";
$lang['failedtoaddfolder'] = "f4Il3D to @dD pHolDeR";
$lang['addlink'] = "add A liNk";
$lang['addinglinkin'] = "aDD1Ng link 1n";
$lang['addressurluri'] = "addre\$S";
$lang['addnewfolder'] = "aDd 4 n3W pholdEr";
$lang['addnewfolderunder'] = "aDd1n9 New f0lDER UnDER";
$lang['editfolder'] = "eDI+ F0lDER";
$lang['editingfolder'] = "eDItiNg Ph0LDEr";
$lang['mustchooserating'] = "j00 mUst Choo\$3 4 r4+ING!";
$lang['commentadded'] = "y0ur ComMEn+ w4S 4ddED.";
$lang['commentdeleted'] = "c0mmeN+ w4s DeL3tED.";
$lang['commentcouldnotbedeleted'] = "c0Mm3n+ COULd no+ BE D3l3T3d.";
$lang['musttypecomment'] = "j00 mU\$+ tYp3 4 COmm3NT!";
$lang['mustprovidelinkID'] = "j00 mU5+ pR0VID3 4 lInK ID!";
$lang['invalidlinkID'] = "iNV4LId LiNk iD!";
$lang['address'] = "addr3ss";
$lang['submittedby'] = "suBmi+TED By";
$lang['clicks'] = "clICK\$";
$lang['rating'] = "r4+1n9";
$lang['vote'] = "v0te";
$lang['votes'] = "v0tEs";
$lang['notratedyet'] = "n0t R4+3D BY 4ny0n3 y3t";
$lang['rate'] = "r@T3";
$lang['bad'] = "b@D";
$lang['good'] = "goOd";
$lang['voteexcmark'] = "v0T3!";
$lang['clearvote'] = "cLe@r vOtE";
$lang['commentby'] = "c0MmEnt By %s";
$lang['addacommentabout'] = "add 4 c0mM3nt 4b0ut";
$lang['modtools'] = "m0derat10n tools";
$lang['editname'] = "eD1+ n@M3";
$lang['editaddress'] = "eD1+ @DDress";
$lang['editdescription'] = "eDI+ D3sCR1PT10n";
$lang['moveto'] = "moVE +0";
$lang['linkdetails'] = "lINk DEt@Il\$";
$lang['addcomment'] = "aDD C0mM3nt";
$lang['voterecorded'] = "yoUR vo+E H@\$ BEEn r3C0rd3d";
$lang['votecleared'] = "y0Ur VotE h45 83en ClE4RED";
$lang['linknametoolong'] = "l1NK name t0O l0n9. m@xiMUm I\$ %s ch4R4C+er\$";
$lang['linkurltoolong'] = "lInk uRl t0o L0n9. m@ximum 1s %s Ch4R4C+3R\$";
$lang['linkfoldernametoolong'] = "fOlDeR N4ME +0o l0n9. M4X1mum LEnGtH 1S %s ch4RAC+3R\$";

// Login / logout (llogon.php, logon.php, logout.php) -----------------------------------------

$lang['loggedinsuccessfully'] = "j00 lo993D 1n 5ucCEssfULly.";
$lang['presscontinuetoresend'] = "pRe5S conT1Nu3 +o REsEnd pHoRm DAt4 0r C4nCEL +o r3l0AD P@G3.";
$lang['usernameorpasswdnotvalid'] = "t3H uSErn4m3 0r p@\$\$W0rd j00 \$uppl1eD i5 n0t v4L1d.";
$lang['rememberpasswds'] = "r3mem83r p45sw0RD5";
$lang['rememberpassword'] = "rEm3Mb3r P@\$\$w0RD";
$lang['enterasa'] = "eN+3r @s @ %s";
$lang['donthaveanaccount'] = "d0N'+ h4V3 4n 4CCOUnT? %s";
$lang['registernow'] = "r3g1\$+er N0W.";
$lang['problemsloggingon'] = "proBlEm\$ l099Ing 0N?";
$lang['deletecookies'] = "deL3+3 C0oki3S";
$lang['cookiessuccessfullydeleted'] = "cOoki3s sUCc3s\$FUlly dEL3TED";
$lang['forgottenpasswd'] = "forg0T+3N Y0UR p4SSw0rD?";
$lang['usingaPDA'] = "u\$1n9 @ pD4?";
$lang['lightHTMLversion'] = "l19ht hTmL V3R\$ion";
$lang['youhaveloggedout'] = "j00 h4vE l09G3D oUt.";
$lang['currentlyloggedinas'] = "j00 @RE cUrREN+LY lo9geD 1n 4s %s";
$lang['logonbutton'] = "lOG0N";
$lang['otherbutton'] = "oTh3r";
$lang['yoursessionhasexpired'] = "y0UR 5essi0n haS 3Xp1R3d. j00 w1Ll nE3D +0 L0g1N @94iN to C0NT1nu3.";

// My Forums (forums.php) ---------------------------------------------------------

$lang['myforums'] = "my FOruMs";
$lang['allavailableforums'] = "aLL 4V@IlaBl3 Ph0RUm\$";
$lang['favouriteforums'] = "f4v0Ur1TE f0rum5";
$lang['ignoredforums'] = "igN0RED F0rUm5";
$lang['ignoreforum'] = "igNoR3 ph0ruM";
$lang['unignoreforum'] = "unIGN0re pH0rUm";
$lang['lastvisited'] = "l@ST v15i+ED";
$lang['forumunreadmessages'] = "%s unr34d m3sS@g3S";
$lang['forummessages'] = "%s M355@g3s";
$lang['forumunreadtome'] = "%s Unre4d &quot;+0: m3&quot;";
$lang['forumnounreadmessages'] = "nO unRE4D MEssaG3s";
$lang['removefromfavourites'] = "reMov3 Fr0M PH@V0UrI+3S";
$lang['addtofavourites'] = "add +0 Ph4VoUr1+es";
$lang['availableforums'] = "av41L48L3 F0RUM\$";
$lang['noforumsofselectedtype'] = "tHer3 4r3 no pH0rUMs 0PH ThE \$3l3C+ED TYP3 4v@1L4blE. pl34\$e \$3LEC+ @ DIpHPhEr3n+ TYP3.";
$lang['successfullyaddedforumtofavourites'] = "sucC3s5FuLlY @DD3d Forum +0 FaV0UrI+3S.";
$lang['successfullyremovedforumfromfavourites'] = "succE\$5fulLy R3MoV3d Ph0rUm Phrom pHAVOURITE\$.";
$lang['successfullyignoredforum'] = "sUcc3SSPHULLy 19norED PHorUM.";
$lang['successfullyunignoredforum'] = "sUCCe\$SFULLy UN19N0RED F0RUM.";
$lang['failedtoupdateforuminterestlevel'] = "f@1LeD +0 UPD4TE F0ruM 1n+3rEs+ levEL";
$lang['noforumsavailablelogin'] = "tHerE 4r3 no pH0Rums 4V4il@BlE. PLe@s3 login to viEw yoUr FORUMs.";
$lang['passwdprotectedforum'] = "p4SSWORD pROTEC+3D PH0rUM";
$lang['passwdprotectedwarning'] = "tHis phoruM I\$ P4SsW0RD PR0T3cted. +0 G4in 4CCEss Ent3R +H3 P@S\$w0RD 8el0w.";

// Message composition (post.php, lpost.php) --------------------------------------

$lang['postmessage'] = "pOst mE\$s4g3";
$lang['selectfolder'] = "sEL3c+ pHolDER";
$lang['mustenterpostcontent'] = "j00 MU\$+ en+Er \$omE COntent phoR Th3 P0\$+!";
$lang['messagepreview'] = "m3s\$49E pReV13W";
$lang['invalidusername'] = "inv4L1D u5Ern4me!";
$lang['mustenterthreadtitle'] = "j00 Mu5t en+Er 4 +1+le F0R +Eh tHRE4D!";
$lang['pleaseselectfolder'] = "pLE4s3 \$El3c+ A phoLDEr!";
$lang['errorcreatingpost'] = "err0R Cr3at1NG Pos+! pL34se try a9@iN in 4 fEw m1nu+3s.";
$lang['createnewthread'] = "cR3@+3 N3w thR3AD";
$lang['postreply'] = "pOSt R3Ply";
$lang['threadtitle'] = "thR3ad ti+Le";
$lang['messagehasbeendeleted'] = "m35s49E n0t f0UnD. CHECk +hAt 1+ H4SN'+ bEEN Del3+3D.";
$lang['messagenotfoundinselectedfolder'] = "mEsS4g3 NOt PhOUnD 1N s3l3c+3D pHOlDEr. CHECK +h4t it h@\$n'+ 8e3N MOv3d 0R D3lE+3D.";
$lang['cannotpostthisthreadtypeinfolder'] = "j00 c@Nno+ post TH1\$ +hR34d TYp3 1n tHat F0lDER!";
$lang['cannotpostthisthreadtype'] = "j00 C4Nn0+ p0s+ th1s tHRE@D +YpE @5 +h3re @R3 No 4V41L4ble f0lDEr5 thaT @Ll0w i+.";
$lang['cannotcreatenewthreads'] = "j00 cAnnO+ CR34+3 NEw +Hr34Ds.";
$lang['threadisclosedforposting'] = "tH1S +hr34D 1\$ CL0seD, j00 C@nn0t PO\$t In I+!";
$lang['moderatorthreadclosed'] = "w4RniN9: +Hi\$ thRe4D Is Cl0s3D FoR pOs+ing +0 n0rmal UsErs.";
$lang['usersinthread'] = "u\$3rS iN +HR34d";
$lang['correctedcode'] = "c0rr3Ct3D cOdE";
$lang['submittedcode'] = "sUBmi+TED C0d3";
$lang['htmlinmessage'] = "h+ml 1N m3\$\$@g3";
$lang['disableemoticonsinmessage'] = "di\$@8Le Em0+iC0ns 1N M3S\$493";
$lang['automaticallyparseurls'] = "au+oM@T1c4LlY paR\$e urL\$";
$lang['automaticallycheckspelling'] = "aUt0M@+iCALlY CHECk \$p3lL1n9";
$lang['setthreadtohighinterest'] = "sE+ +hr3aD +o high In+3r3st";
$lang['enabledwithautolinebreaks'] = "eN48led w1Th 4Ut0-L1n3-8re4K\$";
$lang['fixhtmlexplanation'] = "thIs pH0Rum UsES h+mL pH1L+3RInG. Y0UR \$uBM1++eD H+ML h4\$ b33N m0d1F1ed 8Y +3h f1ltErs In S0m3 w4y.\\n\\nT0 V1Ew y0UR or1G1n@l CODE, SEl3ct ThE \\'sUBM1++3D CODE\\' R4d10 8U++0n.\\n+O V13w tH3 modiPHIED coDE, sEL3c+ +H3 \\'COrREC+3D C0dE\\' r4D10 BU++0N.";
$lang['messageoptions'] = "m3Ss49E 0P+1on\$";
$lang['notallowedembedattachmentpost'] = "j00 4rE N0T @lL0W3d +O 3m8ED 4+t4ChmEN+\$ in y0ur pOsts.";
$lang['notallowedembedattachmentsignature'] = "j00 @re n0t 4lloWeD +0 EM8eD @++4Chm3nts IN your \$19N@+UR3.";
$lang['reducemessagelength'] = "mE\$s4g3 l3ng+h mU\$+ 83 UnDEr 65,535 ChAr4CTer5 (CURrEN+ly: %s)";
$lang['reducesiglength'] = "sIgn4+UR3 l3nG+H mUs+ 8E UnDER 65,535 ch@R4C+3R\$ (CURrENtLy: %s)";
$lang['cannotcreatethreadinfolder'] = "j00 C@nnOt CR34+3 nEW +HrE4ds 1n TH1s f0LDEr";
$lang['cannotcreatepostinfolder'] = "j00 C4nn0t r3ply +O P0stS 1n +his pH0LDER";
$lang['cannotattachfilesinfolder'] = "j00 c4nno+ p0\$+ @t+4chmEnts 1n +h1S F0LD3r. r3MOVE @+T@chM3n+\$ To COn+1nUE.";
$lang['postfrequencytoogreat'] = "j00 C@n 0nLy pos+ oNCE eVERy %s 53C0nDs. pl345e +ry Ag41n l@TER.";
$lang['emailconfirmationrequiredbeforepost'] = "eM4Il conFIrm@+10n 1\$ rEquiRED 8eF0RE J00 C4N PoSt. Iph j00 H@V3 N0+ rEC31V3d A C0nPhirm@t10N EM41L Pl34\$3 ClIcK +3H 8u++0N B3l0W 4nd 4 n3w 0N3 wiLL 83 \$en+ TO Y0U. 1PH y0ur 3M41l @DDRE\$S NEeD5 CH4ng1n9 pLE4SE DO \$O BEPHoRE R3QUESt1n9 4 nEw C0npHiRm4+I0n 3M4il. j00 M4Y cH4N9e yoUR em4IL 4DDrE5s 8y CliCK My con+ROl\$ 4BoVE 4nd th3N user D3+@il5";
$lang['emailconfirmationfailedtosend'] = "cOnf1Rmation EM41l PH@IlED +0 S3nd. PLE4sE cont4CT tH3 phOrUM owN3R +O rEc+1FY +H1\$.";
$lang['emailconfirmationsent'] = "coNphIrm4+I0n 3m41l h4\$ 8EEN r3s3Nt.";
$lang['resendconfirmation'] = "r3SEND COnpH1rMa+10n";
$lang['userapprovalrequiredbeforeaccess'] = "yOur U\$3r 4CCOUnT n3eds +0 8E 4pproV3D 8y @ phoRUM @Dmin B3f0re j00 CaN 4CC3sS +3h r3QU3steD Ph0rum.";

// Message display (messages.php & messages.inc.php) --------------------------------------

$lang['inreplyto'] = "in rEply +0";
$lang['showmessages'] = "sh0W m3ss@GE\$";
$lang['ratemyinterest'] = "r4TE my in+er3ST";
$lang['adjtextsize'] = "adJU\$t +Ext s1ZE";
$lang['smaller'] = "sm4llEr";
$lang['larger'] = "l@R9er";
$lang['faq'] = "f4Q";
$lang['docs'] = "doC\$";
$lang['support'] = "sUppoR+";
$lang['donateexcmark'] = "doN@+3!";
$lang['fontsizechanged'] = "f0n+ SIz3 CH4ngED. %s";
$lang['framesmustbereloaded'] = "fR@me5 mU\$t b3 r3l04d3D M4NU@LlY +0 s3E CH@NG3s.";
$lang['threadcouldnotbefound'] = "tHe REqUES+eD ThrE4d CouLd no+ 83 f0UND 0r @cc3\$S W45 D3n1Ed.";
$lang['mustselectpolloption'] = "j00 mu\$t sel3c+ aN 0Pt1ON to V0+3 f0R!";
$lang['mustvoteforallgroups'] = "j00 must V0+3 iN 3VEry 9roup.";
$lang['keepreading'] = "k3ep R3@ding";
$lang['backtothreadlist'] = "b4cK to +hr34D lis+";
$lang['postdoesnotexist'] = "tH4T P0\$+ DoE5 nOt 3X1\$+ In +hIs +hr3@d!";
$lang['clicktochangevote'] = "cl1ck T0 CH@Ng3 vOTE";
$lang['youvotedforoption'] = "j00 v0+3d FoR 0p+10n";
$lang['youvotedforoptions'] = "j00 vo+ED phor 0pt1On\$";
$lang['clicktovote'] = "cl1cK +0 vOt3";
$lang['youhavenotvoted'] = "j00 h4ve N0T vOtEd";
$lang['viewresults'] = "v13w r3sULTs";
$lang['msgtruncated'] = "m3Ss49e +RUnC@+3D";
$lang['viewfullmsg'] = "vIew fUlL Mes\$49E";
$lang['ignoredmsg'] = "iGNOr3d m3ss4G3";
$lang['wormeduser'] = "wORMED Us3R";
$lang['ignoredsig'] = "iGnor3D 5ign@tur3";
$lang['messagewasdeleted'] = "me\$S49e %s.%s was d3l3+3d";
$lang['stopignoringthisuser'] = "s+op 19Nor1N9 tH1\$ usEr";
$lang['renamethread'] = "ren@mE +HR34d";
$lang['movethread'] = "m0ve thR34d";
$lang['torenamethisthreadyoumusteditthepoll'] = "t0 r3n4me tH1s +Hr34D J00 mUsT ED1t teH P0ll.";
$lang['closeforposting'] = "cloS3 f0r po\$+1N9";
$lang['until'] = "unT1l 00:00 utC";
$lang['approvalrequired'] = "aPProv4L r3Qu1r3D";
$lang['messageawaitingapprovalbymoderator'] = "mes\$Ag3 %s.%s i\$ 4w4i+ing @pPrOv@l 8y 4 mODER@T0R";
$lang['postapprovedsuccessfully'] = "poSt 4PpR0VED \$uCC3S\$fully";
$lang['postapprovalfailed'] = "poSt approv@L F41L3d.";
$lang['postdoesnotrequireapproval'] = "poSt doES Not rEqUir3 4PpROv@L";
$lang['approvepost'] = "approve Po\$+ ph0r di\$pl4y";
$lang['approvedbyuser'] = "aPpr0VED: %s BY %s";
$lang['makesticky'] = "m4K3 st1CKy";
$lang['messagecountdisplay'] = "%s oph %s";
$lang['linktothread'] = "perm@nEn+ LInk tO tHi5 +hr34D";
$lang['linktopost'] = "lInk to P05+";
$lang['linktothispost'] = "l1NK +O +hI5 POs+";
$lang['imageresized'] = "tH1\$ Im@gE H4s 8E3n rEsiz3D (0Rig1N@L siz3 %1\$Sx%2\$s). +0 v13w thE phUlL-s1ZE Im493 CL1CK hER3.";
$lang['messagedeletedbyuser'] = "mEss49e %s.%s DEL3TED %s By %s";
$lang['messagedeleted'] = "mESS4G3 %s.%s W@\$ DEL3T3d";

// Moderators list (mods_list.php) -------------------------------------

$lang['cantdisplaymods'] = "c@Nn0t D1\$PL4y pH0LD3R moD3R4tor\$";
$lang['moderatorlist'] = "m0D3ratoR Li\$+:";
$lang['modsforfolder'] = "modEr@+0Rs F0r f0ldEr";
$lang['nomodsfound'] = "no M0Der@t0RS F0UnD";
$lang['forumleaders'] = "f0RUm LE4DER5:";
$lang['foldermods'] = "fOLDer M0Der4TORs:";

// Navigation strip (nav.php) ------------------------------------------

$lang['start'] = "st4rT";
$lang['messages'] = "m3S\$@ge\$";
$lang['pminbox'] = "iN80X";
$lang['startwiththreadlist'] = "sT4rt p@GE Wi+h +hRE4D Li\$+";
$lang['pmsentitems'] = "sen+ i+3ms";
$lang['pmoutbox'] = "ou+Box";
$lang['pmsaveditems'] = "s4V3D i+Ems";
$lang['pmdrafts'] = "dRAph+\$";
$lang['links'] = "l1nK\$";
$lang['admin'] = "aDmIN";
$lang['login'] = "l0G1n";
$lang['logout'] = "l0g0Ut";

// PM System (pm.php, pm_write.php, pm.inc.php) ------------------------

$lang['privatemessages'] = "pRIV@+3 me\$S493S";
$lang['recipienttiptext'] = "sEp4R4te r3C1piEn+\$ 8y \$3mi-C0L0n or COmM@";
$lang['maximumtenrecipientspermessage'] = "th3re is @ l1Mi+ oF 10 r3C1pieN+5 PeR M3S5493. Ple4\$3 4MEnD YoUR rECip13NT lis+.";
$lang['mustspecifyrecipient'] = "j00 mus+ sP3C1fy @+ L3@ST 0n3 rEciPiENt.";
$lang['usernotfound'] = "u\$Er %s n0t F0und";
$lang['sendnewpm'] = "send N3w pM";
$lang['savemessage'] = "s4Ve m3ss4G3";
$lang['timesent'] = "tIm3 s3n+";
$lang['errorcreatingpm'] = "erR0r crEa+1nG Pm! Pl3453 TrY 494IN in @ fEW m1nuTes";
$lang['writepm'] = "wR1t3 m3SS4G3";
$lang['editpm'] = "ed1+ M3ss49e";
$lang['cannoteditpm'] = "cAnno+ 3d1+ ThIs pM. 1+ H@\$ alr3ADY beEn V13weD 8Y TEh reCiPi3nt 0r +h3 Me\$S493 D0ES n0t ex1\$+ 0r 1+ IS 1n@Cce5S18l3 8y J00";
$lang['cannotviewpm'] = "c@nn0+ vi3w pM. m3\$\$49e D03s nOt Ex1s+ oR 1T 1\$ INaCC3Ss1Ble bY J00";
$lang['pmmessagenumber'] = "me\$S@gE %s";

$lang['youhavexnewpm'] = "j00 hAve %d nEw mE5S4g3s. WOuLD j00 lIK3 +0 9o +0 yoUr iN8Ox nOw?";
$lang['youhave1newpm'] = "j00 h4VE 1 nEW M3sS@G3. W0ulD j00 l1k3 t0 90 to yoUr in80x n0w?";
$lang['youhave1newpmand1waiting'] = "j00 H4ve 1 N3w m3SS@ge.\\n\\nY0u 4Lso h4V3 1 m3S5493 aw41+inG DEliV3RY. to RECEIVE tH15 m3SS@gE pl34\$E CL3@R 50mE \$P4C3 iN Your 1n8ox.\\n\\nWOUlD j00 l1K3 +0 90 t0 y0ur 1n8OX now?";
$lang['youhave1pmwaiting'] = "j00 hAv3 1 MEs\$4g3 AW@i+1n9 DEL1very. +0 r3C31v3 +hIs M3ss493 PL34sE CL3@R soMe sp4cE iN y0ur 1n80x.\\n\\nw0ULD J00 lIK3 to g0 t0 yoUR iN8Ox N0W?";
$lang['youhavexnewpmand1waiting'] = "j00 h4v3 %d NEw M3ss49es.\\n\\nY0u Al\$0 h4v3 1 MEss4ge aW41+1ng dElIV3ry. t0 rEC3ive +Hi5 m3ss49e plE@s3 ClE4R 50m3 \$p@CE iN Your in8OX.\\n\\nWoUlD J00 l1kE tO 90 To Your iNB0x n0W?";
$lang['youhavexnewpmandxwaiting'] = "j00 h@v3 %d N3W MEs\$4ge\$.\\n\\nYOU aL\$0 hav3 %d m3SS49Es @W@i+InG D3lIV3rY. T0 r3C31v3 +h3sE M3ss@GE pl3@\$3 cl34R s0ME sP@CE in Y0Ur Inbox.\\n\\nw0ULD J00 l1ke to 90 t0 y0ur 1N8ox N0w?";
$lang['youhave1newpmandxwaiting'] = "j00 h4v3 1 nEw Mes\$Ag3.\\n\\nyOU 4LS0 h4V3 %d mEs5493s 4W4i+1n9 d3lIV3ry. t0 rEC3IV3 +hes3 mE5s@gE\$ PLE4SE CLE4R 5OM3 sp4cE 1n y0UR inB0X.\\n\\nWoUld J00 like to 90 TO your In80X n0w?";
$lang['youhavexpmwaiting'] = "j00 H4vE %d m3SS@ge\$ @W@i+inG deLiv3ry. T0 ReC3iVE +HEs3 Me\$S@G3s Pl3as3 CLE4R soM3 5P4c3 In YouR 1n80X.\\n\\nW0uld J00 l1KE t0 Go +o Your In80x nOw?";

$lang['youdonothaveenoughfreespace'] = "j00 DO not H@V3 EnOUgH phr3e \$P4ce T0 SenD +his me\$\$@93.";
$lang['userhasoptedoutofpm'] = "%s h4\$ 0pt3D OUt 0F rEC31V1n9 P3rson@L m3S549E\$";
$lang['pmfolderpruningisenabled'] = "pM foLD3R pruN1nG i\$ 3n@8led!";
$lang['pmpruneexplanation'] = "tH1S f0rum Us35 pm F0LDEr prUn1nG. +HE MEs\$493S j00 H@V3 5+oR3D In Y0UR Inb0x @ND seN+ ItEmS\\nf0ldERs 4r3 sUBjEC+ T0 4utoM@+IC deL3+10n. @Ny me\$S493s j00 w1sH +0 k3ep sh0UlD 8e M0v3d to\\ny0Ur \\'\$@veD 1TEm5\\' phOld3R \$O +H4+ +heY Ar3 noT D3lEtED.";
$lang['yourpmfoldersare'] = "yoUr pM f0ld3R\$ are %s FuLl";
$lang['currentmessage'] = "cUrren+ MEss@g3";
$lang['unreadmessage'] = "unr3@D me5S4g3";
$lang['readmessage'] = "rE@D m3ss493";
$lang['pmshavebeendisabled'] = "peRs0n4l M3ss@G3S h4VE b3en DIs@BLEd By +3h pHoRUm oWn3R.";
$lang['adduserstofriendslist'] = "aDd U\$er\$ +0 yoUr fRi3nDs li\$+ +0 h4vE Th3M 4PpE4R 1N A DR0P Down On tHE pm wR1+E mE5\$@G3 p4ge.";

$lang['messagesaved'] = "m3\$S@G3 S4veD";
$lang['messagewassuccessfullysavedtodraftsfolder'] = "m3SS49e W4s \$uCcEsSFUllY 5@v3d To 'DR@pH+S' phOlDER";
$lang['couldnotsavemessage'] = "c0ulD N0+ 54Ve ME\$S@ge. M@k3 \$ure j00 h4VE EN0ugH 4v4IlA8LE Fr3e spac3.";
$lang['pmtooltipxmessages'] = "%s mE5s@gE5";
$lang['pmtooltip1message'] = "1 M3Ss493";

$lang['allowusertosendpm'] = "allow UseR to s3ND P3RS0n@l mEss@9es +0 mE";
$lang['blockuserfromsendingpm'] = "bLOCK U\$eR PhR0m 53nd1ng p3r\$0n4L MEss493\$ +o m3";
$lang['yourfoldernamefolderisempty'] = "yoUR %s FOlDER Is 3MptY";
$lang['successfullydeletedselectedmessages'] = "sUCCEssfulLy DElE+eD s3LEC+3d m3ssAgE\$";
$lang['successfullyarchivedselectedmessages'] = "suCCEsspHUlLy 4rCHiVED sel3CTED M3Ss49e\$";
$lang['failedtodeleteselectedmessages'] = "fAIl3D +0 D3LEtE \$3lEC+3D M3ss493\$";
$lang['failedtoarchiveselectedmessages'] = "f4Il3D +0 4rChIv3 sel3c+3D m35S@g3s";

// Preferences / Profile (user_*.php) ---------------------------------------------

$lang['mycontrols'] = "my C0ntr0Ls";
$lang['myforums'] = "my PHOrums";
$lang['menu'] = "mENu";
$lang['userexp_1'] = "u\$E th3 MeNU on Th3 l3ft t0 maNa93 youR \$3t+1N9\$.";
$lang['userexp_2'] = "<b>u\$eR D3t4IL5</b> 4LL0w\$ j00 +0 ch@nGe youR n4mE, Em41L @DDrE5S 4nd P@\$\$W0rd.";
$lang['userexp_3'] = "<b>u5ER pr0ph1L3</b> AlLoWs j00 +O 3dI+ yoUR us3r prOfiL3.";
$lang['userexp_4'] = "<b>cH@Nge p4SSw0RD</b> allOW5 j00 to cH@nG3 YoUr p@\$\$w0RD";
$lang['userexp_5'] = "<b>em41l &amp; priv4cy</b> L3T5 j00 CH4n9e h0w j00 C@N 83 coN+@cTED 0N aND 0FF +3h forUm.";
$lang['userexp_6'] = "<b>foRUm 0P+i0ns</b> lE+S j00 Ch@n9E h0W th3 f0RUm looks 4nd W0Rks.";
$lang['userexp_7'] = "<b>a++@ChM3N+s</b> 4lL0w\$ J00 +o 3dI+/D3letE YoUr @++4CHMEnTs.";
$lang['userexp_8'] = "<b>s1gn4+Ure</b> l3+s j00 3D1+ yoUr \$1gn@tUr3.";
$lang['userexp_9'] = "<b>r3Lat1on5H1P5</b> l3ts J00 m4N4G3 Your r3l4t1ON\$hiP with otH3R U\$erS 0n teh f0RUm.";
$lang['userexp_9'] = "<b>woRD PhIl+3R</b> lets j00 ED1+ y0Ur P3r\$0n4L w0rD F1L+3R.";
$lang['userexp_10'] = "<b>thRE4d subsCR1P+i0ns</b> 4ll0W\$ J00 +0 MAn493 Y0ur ThRE4d suBSCR1PT10N\$.";
$lang['userdetails'] = "u\$3r D3t4iL\$";
$lang['userprofile'] = "us3r pr0fIL3";
$lang['emailandprivacy'] = "em@il &amp; Pr1v@CY";
$lang['editsignature'] = "eD1T 5iGn@+UrE";
$lang['norelationshipssetup'] = "j00 H4v3 no UseR REL@+i0n\$HIPs \$E+ UP. @DD 4 nEW U\$ER BY sE4Rching BEL0w.";
$lang['editwordfilter'] = "eDi+ W0RD FIl+3R";
$lang['userinformation'] = "uSer Inphorm@+10n";
$lang['changepassword'] = "cH4ngE p4\$sw0rD";
$lang['currentpasswd'] = "cURR3NT p45\$W0rd";
$lang['newpasswd'] = "n3w p@\$sw0rD";
$lang['confirmpasswd'] = "coNPh1RM p4SSW0rd";
$lang['passwdsdonotmatch'] = "p4SSw0rDs d0 not M4tCH!";
$lang['nicknamerequired'] = "n1CKn@M3 is R3qU1r3D!";
$lang['emailaddressrequired'] = "eMA1l 4DDREsS i5 r3QU1R3D!";
$lang['logonnotpermitted'] = "l090n N0+ permi++3d. CH0O53 4NOtH3R!";
$lang['nicknamenotpermitted'] = "n1Ckn4m3 n0+ PErM1TTEd. cH0053 4No+h3r!";
$lang['emailaddressnotpermitted'] = "eMa1L AdDr3SS noT PERm1tteD. CH00\$e @noth3r!";
$lang['emailaddressalreadyinuse'] = "em@1L adDREss 4Lr3@DY iN UsE. Ch0OSe 4notH3R!";
$lang['relationshipsupdated'] = "r3lat10Nsh1pS UpD4+3D!";
$lang['relationshipupdatefailed'] = "r3lat10nsh1p uPd@t3d Ph41lED!";
$lang['preferencesupdated'] = "pr3f3rEnCes WEr3 sUCc3sSPHUlLY UPd4+3d.";
$lang['userdetails'] = "usER D3+@IL5";
$lang['memberno'] = "m3m83r n0.";
$lang['firstname'] = "fIrsT nam3";
$lang['lastname'] = "l@ST n4M3";
$lang['dateofbirth'] = "d4t3 of b1r+h";
$lang['homepageURL'] = "hoMEP@GE URL";
$lang['profilepicturedimensions'] = "pr0f1l3 PicTUr3 (M4x 95x95px)";
$lang['avatarpicturedimensions'] = "av4t4r p1ctur3 (m@x 15x15Px)";
$lang['invalidattachmentid'] = "iNV4L1d atTaCHm3nt. check th4+ is H45n'+ BEEN D3L3teD.";
$lang['unsupportedimagetype'] = "uN\$uppOrteD Im@gE @++4CHmEnt. j00 c@n 0nly USE Jp9, 91Ph 4nD pn9 im@gE 4T+4CHmENtS F0R yoUR 4v4+4r 4nd pr0f1l3 p1CTUR3.";
$lang['selectattachment'] = "seleC+ @++4CHMeNT";
$lang['pictureURL'] = "pIc+uR3 UrL";
$lang['avatarURL'] = "aV4tar url";
$lang['profilepictureconflict'] = "tO U\$e @n Att4cHm3Nt f0r youR PR0phIlE PicturE ThE piCTUr3 UrL F13ld mU\$+ 8E 8l4nk.";
$lang['avatarpictureconflict'] = "to U53 AN @t+4CHM3nt pHOr Your @V@+@R piC+URE +H3 4V4+4R Url pHi3LD MusT b3 8L4Nk.";
$lang['attachmenttoolargeforprofilepicture'] = "s3L3c+3D 4++4CHM3nt 15 +00 lArg3 F0r prOpHil3 PICTUr3. m@x1MUm DIm3ns1on\$ @R3 %s";
$lang['attachmenttoolargeforavatarpicture'] = "s3l3C+ED @++4chm3nt 1s +o0 l4RgE pH0R @V@+@R piC+UrE. Max1mUM D1M3Nsi0ns 4r3 %s";
$lang['failedtoupdateuserdetails'] = "s0Me 0r 4Ll opH yoUr UsER aCC0unT de+@il\$ c0uLD N0T B3 UpD@t3d. pl3ase tRy @G41n l4+eR.";
$lang['failedtoupdateuserpreferences'] = "s0me 0R 4Ll Oph y0ur Us3r PR3pher3nC3s COUlD n0t B3 upd4teD. Pl3asE +rY 49AiN l4+3R.";
$lang['emailaddresschanged'] = "eMA1l 4DDREss h4\$ 8eEn CH4N93d";
$lang['newconfirmationemailsuccess'] = "yOur EMa1L 4DDR3s5 H@5 B3EN CH4N9eD 4Nd 4 NEw C0nf1Rm@+i0n EM41l hAs BE3n s3N+. pLEAs3 CH3Ck 4nD rE4d +h3 em41l f0r FURThER iN5+ruC+i0ns.";
$lang['newconfirmationemailfailure'] = "j00 h4VE CHaNgEd yoUR 3M4IL adDR3SS, bu+ w3 w3rE UN4blE t0 s3ND @ C0nph1RM@ti0n R3quE\$+. PlE453 C0N+@CT T3H pH0RUM owN3R pH0R Assis+4NCE.";
$lang['forumoptions'] = "f0rUm opt1On\$";
$lang['notifybyemail'] = "nOt1fy by 3m4Il Of po\$+\$ +0 me";
$lang['notifyofnewpm'] = "noT1fy by poPUP of n3W Pm m3SS49Es +0 m3";
$lang['notifyofnewpmemail'] = "n0t1fy 8Y EM41L oPH nEW Pm m35s@GE\$ +0 me";
$lang['daylightsaving'] = "aDjust F0R D4ylIgHt s4ViN9";
$lang['autohighinterest'] = "au+om4+iC@LlY mArK +hR34ds i Po\$+ in @\$ H1Gh 1Nt3R3st";
$lang['convertimagestolinks'] = "auTom4+1c4Lly C0NV3rt eMBEDDed Im@gES in p0ST\$ in+O l1Nks";
$lang['thumbnailsforimageattachments'] = "tHum8NA1ls for im493 4+t4chM3NTs";
$lang['smallsized'] = "sm4ll S1zed";
$lang['mediumsized'] = "m3DiUm \$iz3D";
$lang['largesized'] = "l@R9e s1ZeD";
$lang['globallyignoresigs'] = "gL0b4Lly 1GNORe U\$3r s19n4+uRE\$";
$lang['allowpersonalmessages'] = "aLL0w 0Th3R Us3rS +0 senD ME Person@L M3ssa93\$";
$lang['allowemails'] = "allow O+h3r u\$3rs +0 s3ND ME Em@iL\$ v14 mY Pr0ph1l3";
$lang['timezonefromGMT'] = "t1ME zonE";
$lang['postsperpage'] = "p0STs p3R p@9E";
$lang['fontsize'] = "foNT siZ3";
$lang['forumstyle'] = "forum \$+ylE";
$lang['forumemoticons'] = "f0RUM 3mo+icONs";
$lang['startpage'] = "sT4rt P@ge";
$lang['signaturecontainshtmlcode'] = "sIgn4+UR3 conT@iN\$ HTMl C0d3";
$lang['savesignatureforuseonallforums'] = "s@v3 S19N@tURE F0r usE oN @lL f0ruM5";
$lang['preferredlang'] = "pR3phERReD l4NgU493";
$lang['donotshowmyageordobtoothers'] = "do no+ 5h0w mY 493 0R D4te 0PH B1rth t0 0+H3R\$";
$lang['showonlymyagetoothers'] = "sh0w Only My 4g3 +0 0+H3Rs";
$lang['showmyageanddobtoothers'] = "sh0w 8o+h my 4G3 4ND DatE 0PH B1rth T0 0+H3r5";
$lang['showonlymydayandmonthofbirthytoothers'] = "sH0W Only my D4Y 4ND mOn+H 0Ph b1rtH T0 0+HerS";
$lang['listmeontheactiveusersdisplay'] = "lIst ME On +h3 4ctiVE UsER5 d1\$PLAy";
$lang['browseanonymously'] = "brOw\$3 F0rUM @nonyMoUsLY";
$lang['allowfriendstoseemeasonline'] = "bR0w5e 4NoNymOUsly, 8Ut 4ll0W PHr13nD\$ +o \$3E Me as 0nl1N3";
$lang['revealspoileronmouseover'] = "rEV34L sP01l3R5 on mOUsE 0VEr";
$lang['showspoilersinlightmode'] = "alWay\$ \$H0w sp01LErS 1N lI9Ht m0de (U\$e\$ l1gh+3r Ph0nt CoLoUR)";
$lang['resizeimagesandreflowpage'] = "r3\$iz3 1m4g3s 4nd rEFL0w p49E t0 pr3veNt h0R1z0n+@L ScRollInG.";
$lang['showforumstats'] = "shOw PhOrum \$+4+5 4t B0++0M OpH MEs5493 p4NE";
$lang['usewordfilter'] = "eNa8Le w0rd fIl+3R.";
$lang['forceadminwordfilter'] = "f0RC3 U53 0ph 4DmIn worD FiL+3r on @Ll UsEr\$ (1nC. GUEsts)";
$lang['timezone'] = "tIme zON3";
$lang['language'] = "l4NGUa93";
$lang['emailsettings'] = "eM@il 4ND C0n+@CT sE++1Ng\$";
$lang['forumanonymity'] = "foruM @nonym1+y seT+1NG\$";
$lang['birthdayanddateofbirth'] = "b1RthDay @ND D4TE 0ph b1RTh di\$Pl@y";
$lang['includeadminfilter'] = "incluD3 @DMiN W0RD PhIlT3r 1n mY lIs+.";
$lang['setforallforums'] = "seT F0r 4ll ph0RUm5?";
$lang['containsinvalidchars'] = "%s c0Nt41N\$ inv4lid Char4C+Er5!";
$lang['homepageurlmustincludeschema'] = "h0m3pa93 urL mU\$+ InCLuDE H++p:// sChEM4.";
$lang['pictureurlmustincludeschema'] = "pic+urE Url Mu\$+ iNclUD3 h+tP:// 5chEM4.";
$lang['avatarurlmustincludeschema'] = "av4tar Url mUsT iNCLUdE H+Tp:// 5CH3M4.";
$lang['postpage'] = "p0S+ P4G3";
$lang['nohtmltoolbar'] = "n0 H+ml toOl8@r";
$lang['displaysimpletoolbar'] = "d15pl4Y s1MpLE h+mL +O0L8@R";
$lang['displaytinymcetoolbar'] = "di\$PL@y wY5iWyG h+mL tOoLB4R";
$lang['displayemoticonspanel'] = "d1\$PL@Y EmotiC0n\$ p@n3L";
$lang['displaysignature'] = "di\$pl4y s1gN4+UrE";
$lang['disableemoticonsinpostsbydefault'] = "d15@8LE 3motiCoN\$ 1N mE\$\$493s BY DeF@Ul+";
$lang['automaticallyparseurlsbydefault'] = "auT0Mat1CALlY P4rs3 URl\$ iN mesS493S 8Y D3phaULt";
$lang['postinplaintextbydefault'] = "p0S+ 1n PlA1N TExt BY dEF@UlT";
$lang['postinhtmlwithautolinebreaksbydefault'] = "poST 1n HTML wi+H au+0-LIn3-8Re4ks 8Y d3f4UL+";
$lang['postinhtmlbydefault'] = "p0ST in h+ml 8Y D3F4ul+";
$lang['privatemessageoptions'] = "pr1v4tE meSs@GE oP+1onS";
$lang['privatemessageexportoptions'] = "pr1v4tE mE\$S49E 3XPort 0pt1on\$";
$lang['savepminsentitems'] = "s4v3 4 C0Py opH 34ch Pm 1 \$3nD In my sEN+ I+eM5 F0ld3R";
$lang['includepminreply'] = "iNclUD3 mE\$S49E 80dy wH3N r3plyINg TO pM";
$lang['autoprunemypmfoldersevery'] = "au+O Prun3 my pM f0ldER\$ 3VErY:";
$lang['friendsonly'] = "fR13NDs onlY?";
$lang['globalstyles'] = "gloB4L sTyL3S";
$lang['forumstyles'] = "foRUM \$+yL35";
$lang['youmustenteryourcurrentpasswd'] = "j00 Mu\$+ En+3r yOUr CUrr3nt p@\$5w0rd";
$lang['youmustenteranewpasswd'] = "j00 must EntER 4 n3W P4SSw0rD";
$lang['youmustconfirmyournewpasswd'] = "j00 MU\$t coNph1rm your N3W P4SSword";
$lang['profileentriesmustnotincludehtml'] = "prOpH1LE 3ntriE5 mU\$+ n0T 1nclUD3 h+Ml";
$lang['failedtoupdateuserprofile'] = "f@il3D +0 uPD4+3 us3r PrOf1l3";

// Polls (create_poll.php, poll_results.php) ---------------------------------------------

$lang['mustprovideanswergroups'] = "j00 musT pR0v1D3 \$0mE 4n\$weR 9R0up\$";
$lang['mustprovidepolltype'] = "j00 musT pr0Vide 4 POll Typ3";
$lang['mustprovidepollresultsdisplaytype'] = "j00 mUST PRovIDE r3SuL+\$ DI\$PL4y typ3";
$lang['mustprovidepollvotetype'] = "j00 must ProV1d3 A POll v0T3 +yP3";
$lang['mustprovidepollguestvotetype'] = "j00 MU\$T sp3ciFy ipH 9ueSt\$ 5h0ulD 8e AlLOw3d to v0+3";
$lang['mustprovidepolloptiontype'] = "j00 mu5+ PRoviD3 @ poll 0P+I0n TYp3";
$lang['mustprovidepollchangevotetype'] = "j00 mU\$+ pR0viD3 @ poLl CHangE vOtE type";
$lang['pollquestioncontainsinvalidhtml'] = "oNE oR mOR3 oF YoUR P0ll QU3S+10n\$ C0n+@in\$ iNV@L1D hTmL.";
$lang['pleaseselectfolder'] = "pL34\$e \$eleC+ @ pHold3R";
$lang['mustspecifyvalues1and2'] = "j00 mu\$T spEc1Phy VaLueS foR @nsw3R\$ 1 4nd 2";
$lang['tablepollmusthave2groups'] = "t48Ul4R phoRM@+ poLl5 Mus+ H4V3 prEc15eLY two V0tiN9 GrOuPS";
$lang['nomultivotetabulars'] = "t@8UL@r phOrM4T P0Ll\$ C4NnoT BE muLti-voTE";
$lang['nomultivotepublic'] = "pU8L1c 84Ll0+S CAnn0+ BE MULti-vOT3";
$lang['abletochangevote'] = "j00 w1lL be 4BlE TO CH@n9e yoUr v0+3.";
$lang['abletovotemultiple'] = "j00 wiLl B3 A8lE +0 V0+e mUl+Ipl3 +ImE\$.";
$lang['notabletochangevote'] = "j00 w1Ll nOt b3 A8le +0 Ch@Ng3 Y0ur VotE.";
$lang['pollvotesrandom'] = "nOT3: pOll vo+E\$ ar3 R4ndomLY 9ENER@t3d Ph0r pr3v13w 0Nly.";
$lang['pollquestion'] = "pOll QU3sT1on";
$lang['possibleanswers'] = "p05si8lE 4nSw3R\$";
$lang['enterpollquestionexp'] = "en+Er t3h @nsW3R5 Phor Y0UR P0LL qU35TioN.. IpH y0ur pOlL 1s @ &quot;yEs/nO&quot; qU3sTiOn, sImplY 3nt3r &quot;y3S&quot; For @N\$W3r 1 4nd &quot;no&quot; F0r @nsw3R 2.";
$lang['numberanswers'] = "n0. 4NSwer\$";
$lang['answerscontainHTML'] = "anSwER5 CONT41N htmL (nO+ iNcLUD1ng s1gn@TUrE)";
$lang['optionsdisplay'] = "an5w3Rs D1spl4Y typ3";
$lang['optionsdisplayexp'] = "h0W shoULD +H3 @nsW3Rs BE pR3SEN+3d?";
$lang['dropdown'] = "a\$ DRop-DOwN L1\$+(\$)";
$lang['radios'] = "a5 4 seri3S 0ph r@D10 BUt+onS";
$lang['votechanging'] = "voT3 cHaNg1nG";
$lang['votechangingexp'] = "c4N @ Per5on CH4NG3 hIS 0r h3r vOtE?";
$lang['guestvoting'] = "gU3S+ V0t1ng";
$lang['guestvotingexp'] = "can 9u3Sts v0TE in Th1S pOlL?";
$lang['allowmultiplevotes'] = "all0W mUlT1pLE votE\$";
$lang['pollresults'] = "p0ll resUl+5";
$lang['pollresultsexp'] = "h0W w0UlD j00 l1ke +0 d1SPL@Y Th3 r3SUL+s oPh y0ur P0ll?";
$lang['pollvotetype'] = "p0ll VO+inG +yPE";
$lang['pollvotesexp'] = "h0W \$H0uld +HE p0LL 83 C0NDUC+3d?";
$lang['pollvoteanon'] = "aNonYm0uSLY";
$lang['pollvotepub'] = "publiC 84ll0+";
$lang['horizgraph'] = "hoRIZon+@l gRapH";
$lang['vertgraph'] = "vertIC4l gr@Ph";
$lang['tablegraph'] = "t4bul@r phorm4+";
$lang['polltypewarning'] = "<b>w@Rn1ng</b>: THI\$ Is 4 Publ1C 8Allo+. y0uR N4M3 wilL 83 vIsI8L3 N3X+ +o +3h 0pT1ON j00 V0Te F0R.";
$lang['expiration'] = "exP1R@+10n";
$lang['showresultswhileopen'] = "d0 j00 w4N+ to \$h0W rE\$Ults wHiL3 +HE poll is 0peN?";
$lang['whenlikepollclose'] = "wh3n woulD j00 lik3 y0Ur pOll +0 4Ut0M4t1CAlLY CLos3?";
$lang['oneday'] = "oN3 d4y";
$lang['threedays'] = "thre3 d4ys";
$lang['sevendays'] = "s3v3n D4Ys";
$lang['thirtydays'] = "tHIRtY D@Ys";
$lang['never'] = "never";
$lang['polladditionalmessage'] = "aDd1+i0n@L mEss493 (Opt10n4L)";
$lang['polladditionalmessageexp'] = "d0 j00 w@n+ +o inCLuDE @N 4dDI+1oN4L Po5+ 4Pht3R tEh PolL?";
$lang['mustspecifypolltoview'] = "j00 MuSt Spec1fy @ Poll tO v13w.";
$lang['pollconfirmclose'] = "aR3 j00 suR3 J00 w@n+ +O CLo\$E tEH fOlLow1ng pOlL?";
$lang['endpoll'] = "end poll";
$lang['nobodyvotedclosedpoll'] = "n0b0dy votED";
$lang['votedisplayopenpoll'] = "%s 4nD %s h4VE v0+3D.";
$lang['votedisplayclosedpoll'] = "%s @ND %s v0T3D.";
$lang['nousersvoted'] = "no U53rs";
$lang['oneuservoted'] = "1 us3r";
$lang['xusersvoted'] = "%s uS3Rs";
$lang['noguestsvoted'] = "nO gu3S+s";
$lang['oneguestvoted'] = "1 guesT";
$lang['xguestsvoted'] = "%s gueSTS";
$lang['pollhasended'] = "poll h@S 3nd3D";
$lang['youvotedforpolloptionsondate'] = "j00 V0+3D f0r %s ON %s";
$lang['thisisapoll'] = "th1\$ iS @ p0LL. Cl1ck +0 v13w r3SUL+5.";
$lang['editpoll'] = "eDi+ poLl";
$lang['results'] = "re\$UlTs";
$lang['resultdetails'] = "r3\$ult DE+41l5";
$lang['changevote'] = "ch4N93 v0+3";
$lang['pollshavebeendisabled'] = "p0ll\$ H4V3 B33N dis4bL3D 8Y tEh phOruM 0wnER.";
$lang['answertext'] = "aNswEr t3XT";
$lang['answergroup'] = "aN\$w3R gr0UP";
$lang['previewvotingform'] = "prEViEW vO+1ng form";
$lang['viewbypolloption'] = "view By poLl opT10n";
$lang['viewbyuser'] = "vi3w 8Y U53R";

// Profiles (profile.php) ----------------------------------------------

$lang['editprofile'] = "eDI+ pr0FiL3";
$lang['profileupdated'] = "pr0fil3 upD4+ED.";
$lang['profilesnotsetup'] = "t3h f0rUm Own3R H4S n0T S3T Up propHiL3S.";
$lang['ignoreduser'] = "i9N0REd UsER";
$lang['lastvisit'] = "l@s+ V1S1+";
$lang['userslocaltime'] = "u5ER'\$ LoC4L +imE";
$lang['userstatus'] = "s+4tu\$";
$lang['useractive'] = "onLinE";
$lang['userinactive'] = "in4Ctiv3 / ophphl1n3";
$lang['totaltimeinforum'] = "t0+4l t1M3";
$lang['longesttimeinforum'] = "l0NGEst 5E\$si0n";
$lang['sendemail'] = "s3ND 3M4il";
$lang['sendpm'] = "send Pm";
$lang['visithomepage'] = "viS1t h0m3p49e";
$lang['age'] = "a93";
$lang['aged'] = "a93d";
$lang['birthday'] = "b1RtHD4Y";
$lang['registered'] = "r3GIStEr3D";
$lang['findpostsmadebyuser'] = "fIND p0sts m4de 8Y %s";
$lang['findpostsmadebyme'] = "find P0\$+S m4dE 8Y m3";
$lang['profilenotavailable'] = "pr0f1l3 N0T 4v@ilaBL3.";
$lang['userprofileempty'] = "tHIS UsEr ha5 NOt ph1LLeD iN ThE1R ProPh1l3 0r i+ 15 5E+ +O pRiV4TE.";

// Registration (register.php) -----------------------------------------

$lang['newuserregistrationsarenotpermitted'] = "sORRY, nEW U\$3r RE91\$+R4+1on\$ 4RE NoT AlLow3d r19ht n0w. Pl34sE CH3ck 8@Ck L@+ER.";
$lang['usernameinvalidchars'] = "u\$ERName C4N OnlY C0N+41n @-Z, 0-9, _ - CH@R@C+ER\$";
$lang['usernametooshort'] = "us3Rn4M3 mU\$+ 8E 4 mInimUm oPh 2 ch@r@c+er\$ lon9";
$lang['usernametoolong'] = "us3rn4m3 mU\$t 8E 4 max1MUm oPH 15 Ch4r4ct3r\$ l0ng";
$lang['usernamerequired'] = "a Lo90n n4M3 IS requIr3D";
$lang['passwdmustnotcontainHTML'] = "p4\$Sw0rD mU\$+ no+ C0N+@in h+mL t4g\$";
$lang['passwordinvalidchars'] = "p@\$Sw0rD C@N oNly COnT@In @-z, 0-9, _ - ChAr4CtErs";
$lang['passwdtooshort'] = "p@5sworD must B3 4 m1n1mUM 0pH 6 chaR4c+Er5 l0ng";
$lang['passwdrequired'] = "a p4\$Sw0Rd i5 r3Qu1R3d";
$lang['confirmationpasswdrequired'] = "a conFirM4+i0n P4sswoRD I\$ rEQU1ReD";
$lang['nicknamerequired'] = "a niCknamE 1S r3QU1r3D";
$lang['emailrequired'] = "aN 3m@il 4DDR3SS is r3qu1R3D";
$lang['passwdsdonotmatch'] = "p4ssW0rDs D0 n0t Ma+CH";
$lang['usernamesameaspasswd'] = "us3rn4mE 4ND P4\$\$w0RD mUs+ BE DIfpH3R3n+";
$lang['usernameexists'] = "soRrY, 4 U\$er w1+h Th4t n4m3 @lrEaDY 3xistS";
$lang['successfullycreateduseraccount'] = "sUcC3\$sphULLy Cr3AtED UsER aCC0unt";
$lang['useraccountcreatedconfirmfailed'] = "yoUR u\$3r 4cCoUnt h4s 8EEN CR34+3D 8u+ +H3 R3qUIrED C0nphirMaTIoN Em@iL Was n0T sEn+. pL3453 C0NT4ct tH3 PHOrUM 0wn3r +O rEct1PhY th1\$. 1N +hI\$ m34n+1M3 PlE4Se ClICK +h3 COn+iNUE 8U++0N +0 L09In In.";
$lang['useraccountcreatedconfirmsuccess'] = "y0UR Us3R 4cc0un+ h@s 83En cR34+3D 8uT BEfoRE J00 C4n \$t@R+ pOsT1N9 j00 musT CONpHIRM Y0ur eMa1l aDDR35\$. PLe4se ChECk your 3M41l phoR 4 lInK +H@T wiLl 4lLoW j00 T0 C0NpH1RM y0ur @DDREs\$.";
$lang['useraccountcreated'] = "y0Ur u\$3r @Cc0Unt h4s B3En Cr34+3d sUCcESSfULlY! CL1ck tHE COn+InuE 8UttOn 83LoW +0 log1n";
$lang['errorcreatinguserrecord'] = "eRr0r cr3@+ing useR REC0RD";
$lang['userregistration'] = "uS3r r39I\$+R4t10N";
$lang['registrationinformationrequired'] = "r3gistR4+10n iNpHorM4+i0N (REqUiR3D)";
$lang['profileinformationoptional'] = "pROph1l3 inf0rm4TioN (Op+i0N4L)";
$lang['preferencesoptional'] = "pR3pHEr3nc3\$ (oPtI0NAL)";
$lang['register'] = "rEgis+3r";
$lang['rememberpasswd'] = "r3mem83r p4SsworD";
$lang['birthdayrequired'] = "y0UR D@te OpH B1r+h 1S rEQuir3d 0R i\$ inv4LID";
$lang['alwaysnotifymeofrepliestome'] = "nOT1phy On R3plY TO M3";
$lang['notifyonnewprivatemessage'] = "n0+iphy oN nEw pr1v4Te mEs\$493";
$lang['popuponnewprivatemessage'] = "p0P Up 0n n3w pr1v4T3 m3SS@93";
$lang['automatichighinterestonpost'] = "aUt0m4+iC h19h IntER3st 0n p0s+";
$lang['confirmpassword'] = "cOnf1rm p4\$SW0rd";
$lang['invalidemailaddressformat'] = "inv4l1d eM4il 4dDr35\$ f0rMA+";
$lang['moreoptionsavailable'] = "mOr3 pr0phiLE 4nd pR3fEr3NCE 0ptI0N5 @r3 4V4IL4blE 0NC3 j00 re91\$+3r";
$lang['textcaptchaconfirmation'] = "cOnfirm@+i0n";
$lang['textcaptchaexplain'] = "t0 +Eh r1GH+ I\$ a +3xt-C4p+Ch4 1m493. pl345E typ3 +3h coD3 j00 C4n se3 1N thE iM493 in+0 +He inpU+ Phi3LD B3LoW 1+.";
$lang['textcaptchaimgtip'] = "tHis i\$ @ C4ptch@-piCTUre. i+ I\$ USED To PrEv3nT 4Ut0M@t1c r39is+r@Ti0N";
$lang['textcaptchamissingkey'] = "a c0nf1rm@t1ON c0de I5 REqUiR3D.";
$lang['textcaptchaverificationfailed'] = "t3x+-C@p+CHA V3RiPHic4ti0N CODE w45 1nc0rRec+. pL345e RE-entER 1+.";
$lang['forumrules'] = "f0rum rUl3\$";
$lang['forumrulesnotification'] = "iN 0RDEr To Pr0cE3D, J00 mu\$+ 49REE Wi+h TEh f0ll0W1nG Rul3s";
$lang['forumrulescheckbox'] = "i H@v3 r3AD, @nD 4Gr3e +0 4b1D3 8y t3H Ph0RUm rULE\$.";
$lang['youmustagreetotheforumrules'] = "j00 mU5+ 4gr3E t0 thE Ph0ruM rULEs 8EPHoRE j00 CaN Con+InUE.";

// Recent visitors list  (visitor_log.php) -----------------------------

$lang['member'] = "m3Mb3r";
$lang['searchforusernotinlist'] = "se4rCh pHOr 4 user N0+ In LIs+";
$lang['yoursearchdidnotreturnanymatches'] = "your sE4rCh D1d No+ reTUrN @NY ma+ch3s. tRy \$imPl1FyiNG y0ur \$e4RCH p4r4m3tErs aND +rY @94In.";
$lang['hiderowswithemptyornullvalues'] = "h1DE row5 wi+h 3mPTY or nUlL v@lu3s IN seL3C+3d C0LuMns";
$lang['showregisteredusersonly'] = "sHoW RE9IStEr3d u\$3r\$ 0nlY (HiD3 GU3sts)";

// Relationships (user_rel.php) ----------------------------------------

$lang['relationships'] = "r3L@t10Nships";
$lang['userrelationship'] = "u\$Er R3l4tioN\$HIp";
$lang['userrelationships'] = "u5Er r3l4T10Nsh1p5";
$lang['failedtoremoveselectedrelationships'] = "f4Il3d t0 rEm0V3 \$el3CT3D REl@+I0Nsh1p";
$lang['friends'] = "fR1end5";
$lang['ignoredcompletely'] = "igN0rED Compl3t3Ly";
$lang['relationship'] = "rEL4+10nsh1P";
$lang['restorenickname'] = "rE\$ToR3 Us3R's NiCkN4M3";
$lang['friend_exp'] = "u53R'\$ Po\$+s M@Rk3D Wi+h @ &quot;FrI3ND&quot; iCON.";
$lang['normal_exp'] = "uSeR'S p0\$+s 4PP3ar @\$ normAL.";
$lang['ignore_exp'] = "user'S pOs+5 @R3 hIDD3N.";
$lang['ignore_completely_exp'] = "thr34DS 4ND pO\$+s +0 OR fRom U5ER w1lL 4pp3ar DEL3teD.";
$lang['display'] = "displ@y";
$lang['displaysig_exp'] = "u\$3r'\$ \$i9n@+Ure i5 d1SPl4y3D 0n +hEIr posTs.";
$lang['hidesig_exp'] = "u\$3r'S si9N@+urE Is HIDdeN 0N ThEiR p0STs.";
$lang['cannotignoremod'] = "j00 C@Nn0t 1gN0re +hIs UseR, 45 th3Y aR3 A m0deR@+0r.";
$lang['previewsignature'] = "pREv13W si9n@+uRE";

// Search (search.php) -------------------------------------------------

$lang['searchresults'] = "se@RCH R3sULT\$";
$lang['usernamenotfound'] = "teh us3rN4M3 j00 \$PECIfI3d in ThE +0 0r phR0M fI3LD W@s nOt f0UnD.";
$lang['notexttosearchfor'] = "oNe 0R 4LL 0F yOUr s3@rCH kEyWoRDs w3r3 1nv@lId. 534rcH K3YwOrDS MU\$+ 8e n0 SH0rteR th4N %d CH@R@cTEr\$, n0 L0ng3r +H4n %d CH4R@C+ER\$ @ND MUs+ N0T apP34r 1N THE %s";
$lang['keywordscontainingerrors'] = "k3yw0rDs C0n+@Ining 3RROrs: %s";
$lang['mysqlstopwordlist'] = "mY\$Ql s+opW0RD l1\$+";
$lang['foundzeromatches'] = "found: 0 m4+CHES";
$lang['found'] = "f0und";
$lang['matches'] = "maTCH3s";
$lang['prevpage'] = "pRev10us Pa93";
$lang['findmore'] = "fInD M0Re";
$lang['searchmessages'] = "se4rcH M3sS493s";
$lang['searchdiscussions'] = "se4rCh DIscUS\$1on\$";
$lang['find'] = "f1nd";
$lang['additionalcriteria'] = "aDd1+i0n4l CR1+eR1@";
$lang['searchbyuser'] = "se4rch BY uSEr (0Pt1on@L)";
$lang['folderbrackets_s'] = "foLD3r(5)";
$lang['postedfrom'] = "postED phroM";
$lang['postedto'] = "poS+3d +0";
$lang['today'] = "tod@Y";
$lang['yesterday'] = "yeS+3rd4Y";
$lang['daybeforeyesterday'] = "d@Y 83f0re yE\$+erD@Y";
$lang['weekago'] = "%s W3ek 49o";
$lang['weeksago'] = "%s w33kS @G0";
$lang['monthago'] = "%s M0N+H @G0";
$lang['monthsago'] = "%s M0n+h5 490";
$lang['yearago'] = "%s Y34R 490";
$lang['beginningoftime'] = "beginniN9 0ph t1M3";
$lang['now'] = "n0W";
$lang['lastpostdate'] = "la5+ po5+ DaTE";
$lang['numberofreplies'] = "nUMB3r oF rEpLiEs";
$lang['foldername'] = "fold3R N@ME";
$lang['authorname'] = "aU+h0R n4Me";
$lang['decendingorder'] = "newe\$+ F1rSt";
$lang['ascendingorder'] = "oLdEst f1RSt";
$lang['keywords'] = "k3yw0rDs";
$lang['sortby'] = "s0r+ BY";
$lang['sortdir'] = "sOrt DiR";
$lang['sortresults'] = "s0r+ R3SultS";
$lang['groupbythread'] = "grOUP 8Y +hRe4d";
$lang['postsfromuser'] = "p05+5 From UsEr";
$lang['poststouser'] = "poSt5 to U53r";
$lang['poststoandfromuser'] = "p0S+s t0 4nd pHr0m u\$er";
$lang['searchfrequencyerror'] = "j00 C@n 0nLy s3aRCh oNCE ev3ry %s \$EC0NdS. plE4SE TrY @G41n L4+ER.";
$lang['searchsuccessfullycompleted'] = "sE@rCh sUCCEssPHuLLy ComPl3+3D. %s";
$lang['clickheretoviewresults'] = "click H3rE t0 v13W r3sULTS.";

// Search Popup (search_popup.php) -------------------------------------

$lang['select'] = "seL3c+";
$lang['searchforthread'] = "sE4rch F0R +Hr34D";
$lang['mustspecifytypeofsearch'] = "j00 mus+ \$P3cipHy TyP3 oPH \$34RCH to pERPhoRm";
$lang['unkownsearchtypespecified'] = "unKNoWn \$3arCh typE sP3cIphI3D";
$lang['mustentersomethingtosearchfor'] = "j00 mU5+ 3NTEr 5OMeTh1n9 t0 se4rCh ph0r";

// Start page (start_left.php) -----------------------------------------

$lang['recentthreads'] = "r3c3n+ +Hr3ad\$";
$lang['startreading'] = "stAr+ rE4dinG";
$lang['threadoptions'] = "thRE4D 0P+10ns";
$lang['editthreadoptions'] = "ed1t thR34d 0Pt10ns";
$lang['morevisitors'] = "mOre V1\$1+0rS";
$lang['forthcomingbirthdays'] = "f0R+hC0M1n9 81r+hd@ys";

// Start page (start_main.php) -----------------------------------------

$lang['editstartpage_help'] = "j00 C4N EDi+ +hI\$ Pa93 frOM t3h 4Dm1N In+3rf@C3";
$lang['uploadstartpage'] = "upLo4d st@r+ p@G3 (%s)";
$lang['invalidfiletypeerror'] = "file tyP3 N0+ sUpporTED. j00 C4N OnLY UsE %s PHIl35 4S YoUR \$+4rt p4g3.";

// Thread navigation (thread_list.php) ---------------------------------

$lang['newdiscussion'] = "n3w d1\$cU\$SIOn";
$lang['createpoll'] = "cRE4tE Poll";
$lang['search'] = "sE4RCH";
$lang['searchagain'] = "s3@rCH 4941n";
$lang['alldiscussions'] = "alL D1Scu\$\$i0Ns";
$lang['unreaddiscussions'] = "uNR3@D D1Scu\$sI0N5";
$lang['unreadtome'] = "unRE4D &quot;+o: me&quot;";
$lang['todaysdiscussions'] = "t0D4y's D1sCUssi0ns";
$lang['2daysback'] = "2 d@ys 8aCK";
$lang['7daysback'] = "7 d@y\$ 84Ck";
$lang['highinterest'] = "h19H 1n+3rES+";
$lang['unreadhighinterest'] = "uNr34d h1Gh iNterE5+";
$lang['iverecentlyseen'] = "i'v3 R3CEnTlY \$33n";
$lang['iveignored'] = "i'V3 1GNor3D";
$lang['byignoredusers'] = "by i9N0red U53r\$";
$lang['ivesubscribedto'] = "i'VE sUBSCrI83D To";
$lang['startedbyfriend'] = "st@R+3D 8Y PhrI3ND";
$lang['unreadstartedbyfriend'] = "unRE4d 5+d BY phr1enD";
$lang['startedbyme'] = "st4RTED 8y M3";
$lang['unreadtoday'] = "uNr3AD Tod4y";
$lang['deletedthreads'] = "dEl3t3d thrEAd\$";
$lang['goexcmark'] = "g0!";
$lang['folderinterest'] = "f0ld3R In+3R3\$+";
$lang['postnew'] = "pO\$t nEw";
$lang['currentthread'] = "cUrr3Nt THrE4D";
$lang['highinterest'] = "h1gh in+Er3S+";
$lang['markasread'] = "m4rk 4s RE4D";
$lang['next50discussions'] = "n3xT 50 di5CUssI0n\$";
$lang['visiblediscussions'] = "v1\$1ble DIsCUss1onS";
$lang['selectedfolder'] = "sEleCTED Fold3R";
$lang['navigate'] = "nAVi94+E";
$lang['couldnotretrievefolderinformation'] = "th3re @r3 n0 F0LDERs aV4IlA8LE.";
$lang['nomessagesinthiscategory'] = "nO M3s\$49Es in +His C@+39ory. plE4\$3 sel3ct 4No+h3r, Or %s F0r 4Ll +HrEaDS";
$lang['clickhere'] = "cLICK HErE";
$lang['prev50threads'] = "pR3v1Ou\$ 50 ThRE4ds";
$lang['next50threads'] = "n3x+ 50 +hr34d5";
$lang['nextxthreads'] = "nExT %s +hreaDS";
$lang['threadstartedbytooltip'] = "tHrE4D #%s \$t4Rt3d BY %s. V13wEd %s";
$lang['threadviewedonetime'] = "1 TimE";
$lang['threadviewedtimes'] = "%d TIm3S";
$lang['unreadthread'] = "unrE4D tHr34D";
$lang['readthread'] = "rE4D tHrE4d";
$lang['unreadmessages'] = "uNRE4d M35\$49E\$";
$lang['subscribed'] = "sub\$Cr183D";
$lang['ignorethisfolder'] = "igN0RE +H15 phOlDER";
$lang['stopignoringthisfolder'] = "sT0p I9n0R1Ng tHi\$ pholdER";
$lang['stickythreads'] = "s+1CKy ThrE4d\$";
$lang['mostunreadposts'] = "m0ST Unr3@D p0s+S";
$lang['onenew'] = "%d NEW";
$lang['manynew'] = "%d NEW";
$lang['onenewoflength'] = "%d n3W oph %d";
$lang['manynewoflength'] = "%d new of %d";
$lang['ignorefolderconfirm'] = "aR3 j00 5ure j00 wANt +o 19nOre ThIs pHoLD3R?";
$lang['unignorefolderconfirm'] = "arE j00 \$ur3 j00 w4n+ +O s+op IgNoR1Ng +h1S F0LDer?";
$lang['confirmmarkasread'] = "are j00 \$Ur3 j00 w4NT +o mArK TEh sEl3c+3d +hR3adS @\$ R3@d?";
$lang['successfullymarkreadselectedthreads'] = "sUCCE\$SFUlly m4Rk3D 53l3C+3D tHrE4Ds @\$ reaD";
$lang['failedtomarkselectedthreadsasread'] = "fa1lEd +0 m4RK sEl3C+3D +Hr34ds 4\$ r3@D";
$lang['gotofirstpostinthread'] = "go +O fir\$+ Po\$+ iN THrE4d";
$lang['gotolastpostinthread'] = "gO t0 l@st pO\$+ iN +hRE4d";
$lang['viewmessagesinthisfolderonly'] = "v13w mE5\$@GE\$ iN +Hi5 f0LdEr OnlY";
$lang['shownext50threads'] = "sHow N3xt 50 +Hr34d\$";
$lang['showprev50threads'] = "shOw Pr3v1ou\$ 50 tHrE4ds";
$lang['createnewdiscussioninthisfolder'] = "cRe4t3 n3W D1\$cus\$10N in +h1s pholdEr";
$lang['nomessages'] = "no m3ssa93s";

// HTML toolbar (htmltools.inc.php) ------------------------------------
$lang['bold'] = "b0LD";
$lang['italic'] = "iT@l1c";
$lang['underline'] = "uNderlIN3";
$lang['strikethrough'] = "strIK3+hrou9H";
$lang['superscript'] = "suPEr\$cRip+";
$lang['subscript'] = "sU8scr1p+";
$lang['leftalign'] = "l3F+-4l19n";
$lang['center'] = "c3nt3r";
$lang['rightalign'] = "r19ht-4l1gn";
$lang['numberedlist'] = "nUMber3D li\$+";
$lang['list'] = "l1\$t";
$lang['indenttext'] = "indEN+ +Ex+";
$lang['code'] = "c0de";
$lang['quote'] = "qu0tE";
$lang['spoiler'] = "sP0iL3r";
$lang['horizontalrule'] = "h0rIZOn+4L RUl3";
$lang['image'] = "iM4g3";
$lang['hyperlink'] = "hyPeRl1nk";
$lang['noemoticons'] = "d1\$4BLe 3M0+1c0Ns";
$lang['fontface'] = "fon+ ph4C3";
$lang['size'] = "sIzE";
$lang['colour'] = "c0LoUr";
$lang['red'] = "r3d";
$lang['orange'] = "oR4n93";
$lang['yellow'] = "yElloW";
$lang['green'] = "gRE3N";
$lang['blue'] = "blu3";
$lang['indigo'] = "iNdi90";
$lang['violet'] = "v1ol3t";
$lang['white'] = "wh1tE";
$lang['black'] = "bL4Ck";
$lang['grey'] = "grEy";
$lang['pink'] = "p1nk";
$lang['lightgreen'] = "l19h+ gR3En";
$lang['lightblue'] = "liGH+ 8LU3";

// Forum Stats (messages.inc.php - messages_forum_stats()) -------------

$lang['forumstats'] = "fOrum 5+@tS";
$lang['usersactiveinthepasttimeperiod'] = "%s 4c+ivE In t3h p4st %s.";

$lang['numactiveguests'] = "<b>%s</b> guesT\$";
$lang['oneactiveguest'] = "<b>1</b> GUest";
$lang['numactivemembers'] = "<b>%s</b> M3mbEr\$";
$lang['oneactivemember'] = "<b>1</b> m3m8er";
$lang['numactiveanonymousmembers'] = "<b>%s</b> @nonyM0Us m3MBER5";
$lang['oneactiveanonymousmember'] = "<b>1</b> AnonymOu5 m3m83R";

$lang['numthreadscreated'] = "<b>%s</b> thrE4D\$";
$lang['onethreadcreated'] = "<b>1</b> +HR34d";
$lang['numpostscreated'] = "<b>%s</b> PO5ts";
$lang['onepostcreated'] = "<b>1</b> p0st";

$lang['younormal'] = "j00";
$lang['youinvisible'] = "j00 (1NVI\$1BlE)";
$lang['viewcompletelist'] = "vI3w CoMpLEte L1s+";
$lang['ourmembershavemadeatotalofnumthreadsandnumposts'] = "oUr mEmBER\$ H4v3 maD3 4 +0t@l 0Ph %s anD %s.";
$lang['longestthreadisthreadnamewithnumposts'] = "l0N9Es+ +HrE4D 1\$ <b>%s</b> Wi+h %s.";
$lang['therehavebeenxpostsmadeinthelastsixtyminutes'] = "tH3rE H4v3 8E3n <b>%s</b> Posts M@d3 iN +3h l@\$+ 60 mInutES.";
$lang['therehasbeenonepostmadeinthelastsxityminutes'] = "th3r3 h4S 8EEN <b>1</b> P0\$+ M@D3 in th3 L@\$+ 60 M1nut35.";
$lang['mostpostsevermadeinasinglesixtyminuteperiodwasnumposts'] = "m0s+ PO\$+s 3ver mAD3 1n @ 5In9LE 60 m1NU+3 p3RI0d 1S <b>%s</b> 0n %s.";
$lang['wehavenumregisteredmembersandthenewestmemberismembername'] = "w3 h4v3 <b>%s</b> r39i5+ER3D M3MBers 4nd +EH N3w3st M3M83R 1s <b>%s</b>.";
$lang['wehavenumregisteredmember'] = "we HAVE %s rEG1\$+Er3d mEMBEr\$.";
$lang['wehaveoneregisteredmember'] = "wE H@V3 0N3 r3g15+er3D m3M8er.";
$lang['mostuserseveronlinewasnumondate'] = "moSt U\$3rs ev3r oNL1N3 W45 <b>%s</b> ON %s.";
$lang['statsdisplayenabled'] = "s+@+\$ di\$pl4y en4bLeD";

// Thread Options (thread_options.php) ---------------------------------

$lang['updatessavedsuccessfully'] = "upd@+3s s4VED \$ucCESsFUlLy";
$lang['useroptions'] = "usER opT10n\$";
$lang['markedasread'] = "m@rkEd 4s READ";
$lang['postsoutof'] = "p0Sts oUt 0Ph";
$lang['interest'] = "iN+ER3ST";
$lang['closedforposting'] = "cLoS3d foR po\$+INg";
$lang['locktitleandfolder'] = "lOCk +1TlE @nD F0LD3R";
$lang['deletepostsinthreadbyuser'] = "d3L3TE pO5+S iN thrE4d BY U\$ER";
$lang['deletethread'] = "deLEtE +hr34D";
$lang['permenantlydelete'] = "p3RM4n3n+Ly d3le+E";
$lang['movetodeleteditems'] = "m0VE +0 DEl3ted THrE4d5";
$lang['undeletethread'] = "undEl3+3 +hR34d";
$lang['threaddeletedpermenantly'] = "tHRE4D D3l3T3D pERm@n3nTLY. c@Nn0t uND3LE+E.";
$lang['markasunread'] = "m4RK 45 unrE4d";
$lang['makethreadsticky'] = "m@k3 +hR34d sTiCKY";
$lang['threareadstatusupdated'] = "thR34d rE4d st4+us UPD4t3D 5Ucc3sSFULLY";
$lang['interestupdated'] = "tHr3aD 1N+3RE\$t \$+4TU5 UpD@+3D \$ucCESsFULly";
$lang['failedtoupdatethreadreadstatus'] = "f41l3D t0 upD@+E +hR34D r3AD s+4tus";
$lang['failedtoupdatethreadinterest'] = "f4IlED t0 uPd@+E THre4d 1N+3RE\$+";
$lang['failedtorenamethread'] = "f@il3D +0 R3naME Thr3ad";
$lang['failedtomovethread'] = "f@1L3d T0 moVE +hR34d T0 sPEC1fi3d f0lDER";
$lang['failedtoupdatethreadstickystatus'] = "f@IL3D +0 upD4+3 +hR3AD 5+iCKY \$+4tus";
$lang['failedtoupdatethreadclosedstatus'] = "f41lED +0 upD4te tHrE4d Cl0seD StA+U5";
$lang['failedtoupdatethreadlockstatus'] = "f4il3D +0 upD4+3 thr34D lOCK st4tus";
$lang['failedtodeletepostsbyuser'] = "f@1l3D t0 dEL3T3 p0\$+s by 53L3C+3d U\$3r";
$lang['failedtodeletethread'] = "f41L3D t0 dEL3TE +hREAd.";
$lang['failedtoundeletethread'] = "f4IlEd +0 UN-DEL3TE +hR34d";

// Dictionary (dictionary.php) -----------------------------------------

$lang['dictionary'] = "dic+10narY";
$lang['spellcheck'] = "sP3ll Ch3CK";
$lang['notindictionary'] = "n0+ 1n D1CT1oN4ry";
$lang['changeto'] = "ch@ng3 to";
$lang['restartspellcheck'] = "re\$+4r+";
$lang['cancelchanges'] = "c@nC3L CH4NgEs";
$lang['initialisingdotdotdot'] = "in1t1@L1sinG...";
$lang['spellcheckcomplete'] = "spell CH3ck 1\$ C0mpLE+E. t0 rE5t4rt Sp3Ll cheCk CL1CK R3sT4R+ 8u++0n B3l0W.";
$lang['spellcheck'] = "sp3ll Ch3cK";
$lang['noformobj'] = "no ph0rm 0BJeCT Sp3cIphi3d pH0R rETUrN TExt";
$lang['bodytext'] = "bODy +ex+";
$lang['ignore'] = "i9Nor3";
$lang['ignoreall'] = "iGnor3 4lL";
$lang['change'] = "cH4n93";
$lang['changeall'] = "cH4ngE @LL";
$lang['add'] = "aDd";
$lang['suggest'] = "sU9Ge5T";
$lang['nosuggestions'] = "(nO \$U993St10ns)";
$lang['cancel'] = "c4NCel";
$lang['dictionarynotinstalled'] = "n0 DiCT10nary H4\$ 8eEn 1Ns+@lLEd. PlE4SE C0n+4C+ +HE PhoruM owN3R To rEMEdY Th1S.";

// Permissions keys ----------------------------------------------------

$lang['postreadingallowed'] = "p0St R34d1nG 4lloW3d";
$lang['postcreationallowed'] = "p0sT Cre4T10N @LL0W3D";
$lang['threadcreationallowed'] = "threaD CRE@+i0n ALloW3D";
$lang['posteditingallowed'] = "p0S+ eD1+ing @lLowED";
$lang['postdeletionallowed'] = "p0\$t DEl3TIon 4llowED";
$lang['attachmentsallowed'] = "a+TAChm3Nt\$ ALlow3D";
$lang['htmlpostingallowed'] = "h+Ml P0S+1NG 4lLow3D";
$lang['signatureallowed'] = "si9natUr3 @lloWED";
$lang['guestaccessallowed'] = "gUe\$t 4CC3SS @LLoW3d";
$lang['postapprovalrequired'] = "pOS+ @Ppr0V4L r3QU1reD";

// RSS feeds gubbins

$lang['rssfeed'] = "r\$\$ F3ED";
$lang['every30mins'] = "eVery 30 m1NU+3S";
$lang['onceanhour'] = "oNCE 4N hOur";
$lang['every6hours'] = "eVery 6 hour\$";
$lang['every12hours'] = "eV3RY 12 hOur\$";
$lang['onceaday'] = "oNC3 4 D@y";
$lang['rssfeeds'] = "r\$\$ F3EDs";
$lang['feedname'] = "fe3D n4ME";
$lang['feedfoldername'] = "f33d F0lD3R n4m3";
$lang['feedlocation'] = "f33D loC4+1on";
$lang['threadtitleprefix'] = "tHre4d T1+l3 pREf1X";
$lang['feednameandlocation'] = "feeD n@me @nd l0c4tIon";
$lang['feedsettings'] = "fe3d s3TT1nGs";
$lang['updatefrequency'] = "uPd4+3 fr3QU3nCY";
$lang['rssclicktoreadarticle'] = "cL1cK H3rE +0 r34D thIs 4Rt1CL3";
$lang['addnewfeed'] = "aDD N3W fE3d";
$lang['editfeed'] = "edI+ F33d";
$lang['feeduseraccount'] = "f33d Us3r @CCoUnT";
$lang['noexistingfeeds'] = "n0 3xIS+1Ng rss f3eds phouND. +0 4DD @ ph3eD ClICK tEh 'aDD N3W' 8utton 83l0w";
$lang['rssfeedhelp'] = "h3R3 j00 CaN sE+up somE r55 ph3eD5 pH0R 4Ut0m4+Ic proP4GaT1On 1N+0 y0uR phoRUM. +Eh 1tem5 fR0M thE Rss PhE3ds j00 4dD w1Ll 8E crE4t3D @5 +hR34D\$ WHiCH U\$3rs c4N rEPLy to 4\$ iph thEY W3rE n0rm4L po5+S. teh R\$\$ FE3d Mus+ BE 4cCEss1blE vI4 hTtp or 1+ wIlL no+ w0RK.";
$lang['mustspecifyrssfeedname'] = "must sp3cIfY r\$S F3eD N@m3";
$lang['mustspecifyrssfeeduseraccount'] = "mUSt sp3C1phy Rs\$ PH3eD usEr acc0UNt";
$lang['mustspecifyrssfeedfolder'] = "mu\$+ \$p3C1fy Rss f3eD pH0LDER";
$lang['mustspecifyrssfeedurl'] = "mu\$+ \$p3CiFy Rss f3ed uRl";
$lang['mustspecifyrssfeedupdatefrequency'] = "muSt 5P3ciphY r\$S F3ed UpD@+e PhREqU3nCy";
$lang['unknownrssuseraccount'] = "uNKnown r5\$ UsER @CCOUNt";
$lang['rssfeedsupportshttpurlsonly'] = "rS\$ f33D 5upporT\$ H+TP URls only. \$eCURE fE3DS (h++p\$://) Ar3 n0t suPp0rt3d.";
$lang['rssfeedurlformatinvalid'] = "r5S f33d UrL phoRm4+ I\$ INV4liD. URl musT IncluD3 \$Ch3mE (E.G. Ht+p://) 4ND 4 h05+N4Me (E.9. wWw.hos+n4m3.COm).";
$lang['rssfeeduserauthentication'] = "r\$s PhE3d d0es NO+ \$UPP0rt H+Tp UseR AU+HEN+iC4T1on";
$lang['successfullyremovedselectedfeeds'] = "sucCEssFUlLy rEM0V3d \$3Lec+3D Ph3EdS";
$lang['successfullyaddedfeed'] = "sucC3S\$fulLy @DDeD n3w fEED";
$lang['successfullyeditedfeed'] = "succ3ssfuLly 3DItED PhE3D";
$lang['failedtoremovefeeds'] = "f@1L3d t0 REM0v3 50m3 0r 4lL oph TEh \$EL3ctED F3eDs";
$lang['failedtoaddnewrssfeed'] = "f41l3D +0 4DD n3W R5\$ FE3d";
$lang['failedtoupdaterssfeed'] = "f41l3D t0 uPDA+e Rss f3eD";
$lang['rssstreamworkingcorrectly'] = "r5S s+rE4m 4pp3ar\$ +0 8e w0rkINg c0rrECTlY";
$lang['rssstreamnotworkingcorrectly'] = "rS5 \$tr34m w4\$ EmP+y oR cOUlD N0T 8e F0UND";
$lang['invalidfeedidorfeednotfound'] = "inv4L1D F3ED ID 0r phE3D N0t f0unD";

// PM Export Options

$lang['pmexportastype'] = "eXp0Rt 45 +ype";
$lang['pmexporthtml'] = "hTML";
$lang['pmexportxml'] = "xML";
$lang['pmexportplaintext'] = "pLa1n +3x+";
$lang['pmexportmessagesas'] = "exPOr+ m3Ss@g3S 4\$";
$lang['pmexportonefileforallmessages'] = "oNe FiL3 F0R 4ll m3Ss493s";
$lang['pmexportonefilepermessage'] = "on3 f1L3 P3R m3s\$49E";
$lang['pmexportattachments'] = "exP0RT 4+t4CHmEN+s";
$lang['pmexportincludestyle'] = "iNCLUDE F0RUm \$+yL3 \$H33+";
$lang['pmexportwordfilter'] = "apPLy w0RD pH1l+3r +0 mEss@gE\$";

// Thread merge / split options

$lang['threadhasbeensplit'] = "tHre4d h4S bE3N Spli+";
$lang['threadhasbeenmerged'] = "tHreaD h@s BEEN m3r9ED";
$lang['mergesplitthread'] = "m3rg3 / splI+ ThRe4d";
$lang['mergewiththreadid'] = "mEr93 w1+H ThrEAD ID:";
$lang['postsinthisthreadatstart'] = "p0\$t5 1N +hI\$ tHR34d at \$tar+";
$lang['postsinthisthreadatend'] = "pOSts in +HiS +HrE4d @t EnD";
$lang['reorderpostsintodateorder'] = "r3-0RDEr p0S+5 inTo DA+3 oRD3r";
$lang['splitthreadatpost'] = "sPL1t tHRe4d @t po\$T:";
$lang['selectedpostsandrepliesonly'] = "seLEC+ED posT 4nd rEPL13S 0nly";
$lang['selectedandallfollowingposts'] = "sel3c+ED and 4Ll PhoLlOwIn9 pos+s";

$lang['threadmovedhere'] = "h3R3";

$lang['thisthreadhasmoved'] = "<b>thREADs m3Rg3D:</b> +HIS +hR34D h4\$ M0VED %s";
$lang['thisthreadwasmergedfrom'] = "<b>thr34Ds m3R93D:</b> +Hi\$ +hr34d w4\$ m3rGED fr0m %s";
$lang['somepostsinthisthreadhavebeenmoved'] = "<b>thRE4D \$pl1+:</b> \$0m3 p0STs 1N Th1\$ +hr34D h4V3 8E3n M0Ved %s";
$lang['somepostsinthisthreadweremovedfrom'] = "<b>tHRE4d spL1T:</b> 5OM3 PO\$+\$ In +hi\$ thr34D w3R3 Mov3d PhROm %s";

$lang['thisposthasbeenmoved'] = "<b>thRE@D SpLiT:</b> +H1\$ p0\$t h@5 B3En m0vED %s";

$lang['invalidfunctionarguments'] = "inV4lid PhUNC+iOn @R9UM3Nts";
$lang['couldnotretrieveforumdata'] = "c0uLD not rE+rIEve Ph0ruM D4+4";
$lang['cannotmergepolls'] = "onE 0r m0re +hr34ds Is @ poll. j00 C4nnot MER9E Polls";
$lang['couldnotretrievethreaddatamerge'] = "cOulD n0+ ReTrIeve +Hr34d D4+@ pHrOm 0n3 0r m0Re thrE4D\$";
$lang['couldnotretrievethreaddatasplit'] = "could N0+ REtr13v3 +hR3@d D4+4 fr0m s0URcE thrE4D";
$lang['couldnotretrievepostdatamerge'] = "c0uld n0T rE+Ri3V3 p05+ d@t4 PHroM 0n3 0r mor3 +hr34d\$";
$lang['couldnotretrievepostdatasplit'] = "cOuLD N0T rE+rIev3 po\$+ daTA PhR0m \$0urCe Thr34D";
$lang['failedtocreatenewthreadformerge'] = "f4il3d +o cR34+3 n3w +hr34d For mERgE";
$lang['failedtocreatenewthreadforsplit'] = "f41l3D +o cR3atE n3W THr34D ph0R 5PL1+";

// Thread subscriptions

$lang['threadsubscriptions'] = "tHr34d suBsCript10ns";
$lang['couldnotupdateinterestonthread'] = "c0uld nO+ uPD@+E 1nT3r3s+ 0N +hr3ad '%s'";
$lang['threadinterestsupdatedsuccessfully'] = "tHR34d in+erEsts UPd@TED \$uCcesSpHulLY";
$lang['nothreadsubscriptions'] = "j00 4r3 N0T sUbSCr183D +o 4ny +hre4D\$.";
$lang['resetselected'] = "r35e+ sEl3CtED";
$lang['allthreadtypes'] = "aLl +hr3@D Typ35";
$lang['ignoredthreads'] = "iGnor3D +Hr34d\$";
$lang['highinterestthreads'] = "h1gH In+Er3ST tHR3Ad\$";
$lang['subscribedthreads'] = "su8sCr183d +hr34d\$";
$lang['currentinterest'] = "cuRR3n+ 1n+3R3s+";

// Browseable user profiles

$lang['youcanonlyaddthreecolumns'] = "j00 C4n OnlY 4dD 3 C0lumns. +0 @dD @ nEW COlUMn CLo5e @n ExIst1N9 0n3";
$lang['columnalreadyadded'] = "j00 h4V3 @lrE4DY 4ddED thI\$ C0luMn. 1f J00 w4NT t0 REM0V3 i+ cl1cK i+'\$ CL0s3 8UttOn";

?>
