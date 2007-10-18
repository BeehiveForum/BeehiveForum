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

/* $Id: x-hacker.inc.php,v 1.256 2007-10-18 14:42:29 decoyduck Exp $ */

// British English language file

// Language character set and text direction options -------------------

$lang['_isocode'] = "en";
$lang['_textdir'] = "ltr";

// Months --------------------------------------------------------------

$lang['month'][1]  = "j@NU4RY";
$lang['month'][2]  = "fe8ru4Ry";
$lang['month'][3]  = "maRCH";
$lang['month'][4]  = "aPr1l";
$lang['month'][5]  = "m@y";
$lang['month'][6]  = "jUne";
$lang['month'][7]  = "july";
$lang['month'][8]  = "au9u\$T";
$lang['month'][9]  = "s3Pt3mBER";
$lang['month'][10] = "ocToBer";
$lang['month'][11] = "n0vEm8er";
$lang['month'][12] = "d3CemBER";

$lang['month_short'][1]  = "j@N";
$lang['month_short'][2]  = "f38";
$lang['month_short'][3]  = "m4R";
$lang['month_short'][4]  = "aPR";
$lang['month_short'][5]  = "m4Y";
$lang['month_short'][6]  = "jUn";
$lang['month_short'][7]  = "jUl";
$lang['month_short'][8]  = "aUG";
$lang['month_short'][9]  = "sEp";
$lang['month_short'][10] = "oc+";
$lang['month_short'][11] = "n0v";
$lang['month_short'][12] = "dec";

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

$lang['date_periods']['year']   = "%s ye@r";
$lang['date_periods']['month']  = "%s MOn+h";
$lang['date_periods']['week']   = "%s w3Ek";
$lang['date_periods']['day']    = "%s d4y";
$lang['date_periods']['hour']   = "%s H0ur";
$lang['date_periods']['minute'] = "%s M1nu+e";
$lang['date_periods']['second'] = "%s 5ecoND";

// As above but plurals (2 years vs. 1 year, etc.)

$lang['date_periods_plural']['year']   = "%s YE@rs";
$lang['date_periods_plural']['month']  = "%s M0N+Hs";
$lang['date_periods_plural']['week']   = "%s we3K5";
$lang['date_periods_plural']['day']    = "%s d@y\$";
$lang['date_periods_plural']['hour']   = "%s H0URs";
$lang['date_periods_plural']['minute'] = "%s minu+3s";
$lang['date_periods_plural']['second'] = "%s S3c0NDs";

// Short hand periods (example: 1y, 2m, 3w, 4d, 5hr, 6min, 7sec)

$lang['date_periods_short']['year']   = "%sy";    // 1y
$lang['date_periods_short']['month']  = "%sm";    // 2m
$lang['date_periods_short']['week']   = "%sW";    // 3w
$lang['date_periods_short']['day']    = "%sd";    // 4d
$lang['date_periods_short']['hour']   = "%sHr";   // 5hr
$lang['date_periods_short']['minute'] = "%sm1n";  // 6min
$lang['date_periods_short']['second'] = "%s\$3c";  // 7sec

// Common words --------------------------------------------------------

$lang['percent'] = "p3RcEn+";
$lang['average'] = "aVER4g3";
$lang['approve'] = "apPR0VE";
$lang['banned'] = "b4Nn3d";
$lang['locked'] = "lOCK3D";
$lang['add'] = "adD";
$lang['advanced'] = "adVAnC3d";
$lang['active'] = "aC+1Ve";
$lang['style'] = "styl3";
$lang['go'] = "go";
$lang['folder'] = "f0ld3r";
$lang['ignoredfolder'] = "iGn0RED f0lder";
$lang['folders'] = "fold3Rs";
$lang['thread'] = "tHrE4D";
$lang['threads'] = "thr34Ds";
$lang['threadlist'] = "tHre4D l1\$+";
$lang['message'] = "me\$s49e";
$lang['messagenumber'] = "m3\$s4g3 nUm8er";
$lang['from'] = "fROm";
$lang['to'] = "tO";
$lang['all_caps'] = "aLL";
$lang['of'] = "oF";
$lang['reply'] = "r3Ply";
$lang['forward'] = "f0rW4rd";
$lang['replyall'] = "r3plY +0 all";
$lang['pm_reply'] = "r3ply 4\$ PM";
$lang['delete'] = "d3lEt3";
$lang['deleted'] = "d3LE+eD";
$lang['edit'] = "edi+";
$lang['privileges'] = "pR1v1l393s";
$lang['ignore'] = "iGNORE";
$lang['normal'] = "nOrm4L";
$lang['interested'] = "in+ER3s+3d";
$lang['subscribe'] = "sub\$Cr18E";
$lang['apply'] = "apPly";
$lang['download'] = "d0WnlO4D";
$lang['save'] = "s4ve";
$lang['update'] = "uPD4T3";
$lang['cancel'] = "c4NCEL";
$lang['retry'] = "rE+RY";
$lang['continue'] = "c0N+InU3";
$lang['attachment'] = "aTt4ChMeNt";
$lang['attachments'] = "aT+ACHm3NtS";
$lang['imageattachments'] = "im@GE 4t+@CHM3ntS";
$lang['filename'] = "fILEN4Me";
$lang['dimensions'] = "dIM3NSiOns";
$lang['downloadedxtimes'] = "d0Wnlo4d3D: %d t1m3s";
$lang['downloadedonetime'] = "doWnLo@d3d: 1 t1m3";
$lang['size'] = "s1zE";
$lang['viewmessage'] = "vI3w m3ss493";
$lang['deletethumbnails'] = "dElete +HUmBN41l5";
$lang['logon'] = "l090n";
$lang['more'] = "mor3";
$lang['recentvisitors'] = "r3c3N+ Vi\$i+0r5";
$lang['username'] = "uS3rN4m3";
$lang['clear'] = "cLe@r";
$lang['action'] = "acTi0n";
$lang['unknown'] = "unKN0wn";
$lang['none'] = "nOn3";
$lang['preview'] = "pREVi3w";
$lang['post'] = "p0S+";
$lang['posts'] = "p0ST5";
$lang['change'] = "cH4N93";
$lang['yes'] = "y3\$";
$lang['no'] = "no";
$lang['signature'] = "s19n@+UrE";
$lang['signaturepreview'] = "si9n4+urE pREv1ew";
$lang['signatureupdated'] = "sI9N4TUr3 upD4+3D";
$lang['signatureupdatedforallforums'] = "sIgn4+Ure UpD@T3D PHOr 4ll phORUmS";
$lang['back'] = "b@cK";
$lang['subject'] = "su8j3C+";
$lang['close'] = "cLo\$E";
$lang['name'] = "n4m3";
$lang['description'] = "d3scr1p+I0n";
$lang['date'] = "d4T3";
$lang['view'] = "v1ew";
$lang['enterpasswd'] = "eNt3r paSsw0RD";
$lang['passwd'] = "p@5\$w0rD";
$lang['ignored'] = "ignored";
$lang['guest'] = "gUe\$T";
$lang['next'] = "n3X+";
$lang['prev'] = "pR3vIOu\$";
$lang['others'] = "oThEr5";
$lang['nickname'] = "nIcknamE";
$lang['emailaddress'] = "eM41L @dDREss";
$lang['confirm'] = "c0Nph1RM";
$lang['email'] = "eMA1l";
$lang['poll'] = "polL";
$lang['friend'] = "fRiEnd";
$lang['success'] = "sucC3\$s";
$lang['error'] = "eRROr";
$lang['warning'] = "warn1ng";
$lang['guesterror'] = "soRry, j00 nEED +0 8E logg3D in T0 u\$e tH1S F34+URE.";
$lang['loginnow'] = "l09in noW";
$lang['unread'] = "unRE4D";
$lang['all'] = "aLL";
$lang['allcaps'] = "aLl";
$lang['permissions'] = "p3RmIssi0n5";
$lang['type'] = "tYpe";
$lang['print'] = "pRint";
$lang['sticky'] = "s+1Cky";
$lang['polls'] = "p0ll\$";
$lang['user'] = "user";
$lang['enabled'] = "eN@BlED";
$lang['disabled'] = "dI5@8LeD";
$lang['options'] = "op+1On5";
$lang['emoticons'] = "eM0+1C0N5";
$lang['webtag'] = "w38t@9";
$lang['makedefault'] = "m@K3 D3phaUlT";
$lang['unsetdefault'] = "uN\$E+ d3f@UL+";
$lang['rename'] = "r3NAMe";
$lang['pages'] = "pAG3s";
$lang['used'] = "uS3d";
$lang['days'] = "d@YS";
$lang['usage'] = "u5@93";
$lang['show'] = "shOw";
$lang['hint'] = "hIn+";
$lang['new'] = "neW";
$lang['referer'] = "rEPH3rer";
$lang['thefollowingerrorswereencountered'] = "tH3 phOll0W1n9 eRrOrs wer3 eNC0Un+3RED:";

// Admin interface (admin*.php) ----------------------------------------

$lang['admintools'] = "adM1n to0L5";
$lang['forummanagement'] = "f0RUm mAnagEm3Nt";
$lang['accessdeniedexp'] = "j00 do not h@v3 p3rm1Ss10N T0 us3 +hIs \$3C+I0N.";
$lang['managefolders'] = "m4n493 PhoLDER5";
$lang['manageforums'] = "m4n4g3 F0RUMs";
$lang['manageforumpermissions'] = "m4N@G3 F0rum P3RMi\$si0N5";
$lang['foldername'] = "fOld3R n4M3";
$lang['move'] = "move";
$lang['closed'] = "cL053d";
$lang['open'] = "oP3N";
$lang['restricted'] = "re\$TriCT3D";
$lang['forumiscurrentlyclosed'] = "%s is cuRrEn+ly Clo\$3d";
$lang['youdonothaveaccesstoforum'] = "j00 Do n0+ H@V3 acC3\$\$ +0 %s";
$lang['toapplyforaccessplease'] = "t0 4pplY F0r 4CCESs pLE453 c0n+@CT +hE ph0rum 0WNER.";
$lang['adminforumclosedtip'] = "iF j00 w@n+ +o CHAn93 S0m3 \$e++iNgS on yOUR PhOrUm CL1CK +HE ADMIN l1NK 1n +h3 N4V1G4t1oN b4r A8ovE.";
$lang['newfolder'] = "n3W ph0ld3R";
$lang['nofoldersfound'] = "n0 EXIS+1NG pHoLdeR\$ FOUnD. +o 4dd 4 PhOlDEr CL1ck +HE 'ADd NEW' BU++0N bEL0W.";
$lang['forumadmin'] = "f0RUM aDM1N";
$lang['adminexp_1'] = "u\$E the m3nU oN +3h l3F+ t0 m4N493 th1ng\$ IN y0Ur Phorum.";
$lang['adminexp_2'] = "<b>uS3r\$</b> 4LLow5 J00 To s3T 1nD1VIDU4l usER PeRmI\$SI0nS, 1nclUD1nG 4ppo1N+1ng mODER4tors 4ND g@G9ING PE0pl3.";
$lang['adminexp_3'] = "<b>u\$Er 9r0Ups</b> 4ll0w\$ J00 +0 CR3@+E Us3R Gr0ups t0 4\$\$19N p3rmi\$SI0Ns T0 45 m4NY or @\$ f3w U\$3r\$ QU1ckly 4Nd E4\$1ly.";
$lang['adminexp_4'] = "<b>b4n c0NTr0ls</b> 4ll0W\$ The 84NNIn9 @ND UN-84Nn1ng OpH 1P 4dDrEs5e\$, HtTp REf3rer5, USErn4meS, 3m41l aDDREs\$e\$ @ND NICKnaM3S.";
$lang['adminexp_5'] = "<b>f0LDERS</b> @Ll0W\$ +3H CR3atIon, MoD1PhIC4+i0n @ND d3Le+i0n 0Ph F0LDER5.";
$lang['adminexp_6'] = "<b>r5S feeD\$</b> AlL0W\$ j00 +o m@N@Ge rss ph3eD\$ phOr pr0P@G@+ion in+o yOUr pHorUM.";
$lang['adminexp_7'] = "<b>pR0f1l3S</b> LeTs j00 CUs+0m1s3 +H3 1+3MS +h@t @pPE4r 1n +3h U\$3r Pr0phiLES.";
$lang['adminexp_8'] = "<b>f0RuM S3T+inG\$</b> 4ll0W\$ j00 t0 CUSToMisE y0uR PH0rum'S n@M3, app34r4Nce 4ND M4ny 0Th3r th1n9S.";
$lang['adminexp_9'] = "<b>s+ART p493</b> LETs J00 customIS3 Y0ur pHorUm'5 \$+@RT P493.";
$lang['adminexp_10'] = "<b>fOrUm s+YlE</b> AlLOwS J00 +o gEn3r4TE r@nDOM s+yL3s pH0R YOUr pH0RUm mEMbER\$ TO U53.";
$lang['adminexp_11'] = "<b>woRD F1Lt3r</b> 4ll0w\$ j00 +0 f1Lter woRD5 j00 dOn'+ w4nt +0 83 UseD On Y0ur PHoruM.";
$lang['adminexp_12'] = "<b>p05+ing 5taTs</b> 93n3r@+3s 4 R3P0rt Li\$+1nG TEH +0p 10 pOsteR\$ in a D3f1N3D PERIOD.";
$lang['adminexp_13'] = "<b>foRUm lInKs</b> Lets j00 M4NAgE TEH L1NK\$ droPD0wn iN +3h N4vi94+I0N b4r.";
$lang['adminexp_14'] = "<b>vI3W lO9</b> L1\$+5 r3C3nt 4c+i0ns By +H3 F0ruM MoDEr@+orS.";
$lang['adminexp_15'] = "<b>m4N49E Forum\$</b> l3Ts j00 CRe4+3 @nd DEL3Te @nd ClOs3 0R R30PEn F0RUM\$.";
$lang['adminexp_16'] = "<b>gL0bAl Ph0rum se++1N9S</b> 4LL0w\$ J00 +0 mODIPhy sE++InGs wh1cH 4PhpHEC+ 4ll phoruMS.";
$lang['adminexp_17'] = "<b>pO\$+ @PpR0V4L Qu3uE</b> @LL0ws j00 +0 VIEw 4ny pO\$+\$ @w@I+In9 4pprov4l 8Y @ MoD3r4+0R.";
$lang['adminexp_18'] = "<b>vIS1+0R l0g</b> @LLows j00 +o viEw 4N ExTENDED L1\$+ opH v1SI+Ors 1NCLUd1n9 +hEiR htTp REF3rEr5.";
$lang['createforumstyle'] = "cRe4+3 4 Phorum \$+yle";
$lang['newstylesuccessfullycreated'] = "n3w STYL3 \$UCc3ssFUlLY CRE4T3D.";
$lang['stylealreadyexists'] = "a 5tyl3 w1+h TH4+ pH1LEN4M3 4LR34dy 3X1s+\$.";
$lang['stylenofilename'] = "j00 DiD not EnT3r 4 f1leN4m3 +0 S4V3 th3 \$tyl3 wi+h.";
$lang['stylenodatasubmitted'] = "c0uld n0T re4d f0RUM stYl3 D@+@.";
$lang['styleexp'] = "us3 +h1\$ P4g3 +0 H3LP CR34+3 A R4ndomLy g3nEr@+3D \$+ylE F0R yoUr pH0rum.";
$lang['stylecontrols'] = "conTR0ls";
$lang['stylecolourexp'] = "cl1ck 0N a C0LOUR +o m@K3 @ n3w \$+yl3 sh33t 8@\$3D on +h@t C0l0Ur. CurR3nt 8as3 COLoUr 1\$ FiR\$+ 1N L1\$+.";
$lang['standardstyle'] = "st4nDarD \$+YlE";
$lang['rotelementstyle'] = "ro+4+3D 3lEMEN+ \$tyl3";
$lang['randstyle'] = "raNDOM sTyl3";
$lang['thiscolour'] = "th1s c0lour";
$lang['enterhexcolour'] = "oR ENTER 4 hEx C0L0ur tO 84sE @ nEw \$+yl3 5h3e+ 0N";
$lang['savestyle'] = "s@V3 th1s \$TYl3";
$lang['styledesc'] = "sTyl3 DEsCrIp+i0n";
$lang['stylefilenamemayonlycontain'] = "s+yle PhilEn4m3 M4y onLy C0NTAiN LoW3rC@s3 l3++3RS (@-Z), NUm8er\$ (0-9) 4ND UNDER\$c0RE.";
$lang['stylepreview'] = "sTyl3 PrEv13W";
$lang['welcome'] = "welc0me";
$lang['messagepreview'] = "m3ss4Ge pReV13w";
$lang['users'] = "uSer5";
$lang['usergroups'] = "uSer GroUP\$";
$lang['mustentergroupname'] = "j00 mu\$T 3ntEr @ gR0uP N@m3";
$lang['profiles'] = "prOF1l3s";
$lang['manageforums'] = "m4N493 ForUm5";
$lang['forumsettings'] = "f0rum S3+T1N9s";
$lang['globalforumsettings'] = "gL08@L pHorUM \$3tT1ng\$";
$lang['settingsaffectallforumswarning'] = "<b>n0Te:</b> +H3SE sET+ings @pHpH3c+ All F0RUm\$. wHEr3 +3h s3t+1N9 i\$ Dupl1cA+3d 0n +hE InD1vidUAl PHORUm's sE++in9S P@9e +h@t wIlL +4KE PrECEdenC3 OvER tHE \$e++iNg5 j00 CH@ng3 Her3.";
$lang['startpage'] = "sT4rt P4GE";
$lang['startpageerror'] = "yoUr st4rt p4g3 CoULD No+ 8e 5@v3d loC4lly +0 TEH 53Rv3r 8EC4u\$e permI\$5i0n W4s d3N13d.</p><p>to CHANge YOUR 5+@Rt p49E pLE4SE clIck +3H d0wnL0AD 8U+T0N 8eL0w wH1CH WiLl pROmpt j00 TO 54vE +H3 F1LE +o yOUr h4rd dR1V3. j00 C4n th3n uPlO@d Th1\$ phIL3 +0 Y0ur \$Erv3R 1Nt0 +he f0Llow1N9 FoldEr, 1F n3CEss@ry crea+1ng tEh phOldeR \$tructuR3 iN +hE ProcEs\$.</p><p><b>%s</b></p><p>ple4\$E N0tE +h4+ \$0M3 8r0ws3R\$ m4y CH@ng3 +H3 N@mE 0ph The f1L3 up0n Downlo4d.  whEn uPl0@D1n9 +h3 Ph1L3 PleasE M4kE surE +h4+ i+ i\$ n4M3d st4Rt_ma1N.Php 0TH3rwIse yOur \$T4RT P@ge wilL 4pp3@r UnCh@N9ED.";
$lang['failedtoopenmasterstylesheet'] = "your PhOruM sTYl3 coULD NoT B3 s@V3D 8eC@USE tH3 m45t3r sTYl3 5H3et C0uld No+ BE l0@D3D. To S4vE Your 5+YLE +3h M@s+Er StyLE SHE3t (m@k3_5+YL3.CSS) MUS+ Be l0c4+3D in +3h sTyl35 DIR3ctOrY OPh yOUr 8eehiV3 F0RUM iN\$+@lla+1ON.";
$lang['makestyleerror'] = "yoUR PhoRUm 5+YL3 coULD N0+ be \$AV3d l0C@LlY To teH \$eRV3R beC4use pERm1s\$i0N w4S D3n13d. tO s4V3 YoUR PhOrUm 5+yl3 ple4se cl1ck tH3 DoWnLoAD 8u+TOn B3low wH1CH wIll prOmpT j00 t0 s4v3 +3h f1lE +0 y0ur h4RD DRiVE. j00 C4n theN UpL04d tH1\$ filE T0 Y0UR sErvEr 1n+o %s folDEr, 1f n3C3ss4ry cr34t1n9 +h3 folder \$+ruc+ur3 in +3h proCess. j00 sh0ULD nO+3 +H4t some 8R0wS3R5 m4Y ch@ngE +eh n4M3 0F the f1L3 up0n D0Wnl0@D. Wh3n Upl0aD1ng +hE phiL3 pl3a53 M4k3 sur3 +ha+ it 15 N@m3D styl3.C\$S o+H3rw1s3 the phorUm \$Tyl3 w1LL 83 unus4BlE.";
$lang['uploadfailed'] = "y0ur nEw 5+@RT P@gE C0ulD No+ bE UpL04DED +O +h3 s3RvEr beC4usE p3RMi\$s10N W4s DEN1eD. Ple4\$e Ch3ck tH@+ The wEb \$erver / PHp Pr0Ce5s i\$ 48LE tO wRI+E to ThE %s phoLDEr 0N y0ur \$3rvER.";
$lang['forumstyle'] = "fORUm \$+yl3";
$lang['wordfilter'] = "w0RD PhIlt3R";
$lang['forumlinks'] = "f0RUm L1Nk5";
$lang['viewlog'] = "v1eW l09";
$lang['noprofilesectionspecified'] = "nO pR0F1lE s3C+IOn sp3cIphi3d.";
$lang['itemname'] = "i+Em n4M3";
$lang['moveto'] = "m0v3 +o";
$lang['manageprofilesections'] = "m4N@g3 proPhIl3 \$EC+1on\$";
$lang['sectionname'] = "s3CT10n n4M3";
$lang['items'] = "iTems";
$lang['mustspecifyaprofilesectionid'] = "mU\$+ \$p3C1FY @ pr0ph1L3 s3c+I0N 1d";
$lang['mustsepecifyaprofilesectionname'] = "mUst spECIPhY 4 pROFilE s3C+i0n N4m3";
$lang['noprofilesectionsfound'] = "nO EXI\$t1nG pr0ph1l3 \$ect1Ons fOUnD. +o @Dd 4 Proph1L3 s3C+i0n CLICK +EH 'ADd nEw' 8U+t0N bElow.";
$lang['addnewprofilesection'] = "aDd New Pr0FiL3 5ECT1on";
$lang['successfullyaddedprofilesection'] = "suCc3\$SfULly 4DDed Prof1l3 \$Ect10n";
$lang['successfullyeditedprofilesection'] = "sUcCE\$SPHUlly ed1+3D pr0Ph1l3 secT10n";
$lang['addnewprofilesection'] = "aDD nEw pr0PHIL3 sEC+i0n";
$lang['mustsepecifyaprofilesectionname'] = "mu\$+ specIFy A pr0pHIL3 seC+1On naME";
$lang['successfullyremovedselectedprofilesections'] = "succeS\$fully rEm0V3D \$3l3c+3d Pr0FiLE s3c+i0Ns";
$lang['failedtoremoveprofilesections'] = "fA1l3D +0 R3m0v3 proPhIL3 \$eC+1ON\$";
$lang['viewitems'] = "v1ew 1+3ms";
$lang['successfullyaddednewprofileitem'] = "sUcc3S\$PHUlly @DDED N3w propHiLE i+3m";
$lang['successfullyeditedprofileitem'] = "succEs\$Phully 3d1+3D Pr0f1LE i+3M";
$lang['successfullyremovedselectedprofileitems'] = "sucCE\$SFULly rEmoV3D 5el3c+3d proPh1l3 I+3m\$";
$lang['failedtoremoveprofileitems'] = "f4Il3d T0 rEMove Proph1l3 iT3mS";
$lang['noexistingprofileitemsfound'] = "tHere @R3 n0 eXI\$+ing pRof1l3 I+3Ms 1n Th1\$ \$ec+1on. TO 4DD 4n I+3M cL1CK +3H '4DD nEW' BU+tOn 8eloW.";
$lang['edititem'] = "eDIT I+Em";
$lang['invalidprofilesectionid'] = "iNV@l1D pR0Ph1l3 s3c+i0N 1d OR 5ect1on nO+ ph0UND";
$lang['invalidprofileitemid'] = "inV4L1d pr0Ph1l3 iTEm id 0R i+3M n0+ PH0und";
$lang['addnewitem'] = "aDd nEW 1tEM";
$lang['youmustenteraprofileitemname'] = "j00 mU\$t entER 4 profIlE I+3M N4ME";
$lang['invalidprofileitemtype'] = "iNV@liD profil3 i+3m +ype sEl3C+ED";
$lang['failedtocreatenewprofileitem'] = "f@IL3d +0 CrE4+3 nEW PR0PhILE 1+3M";
$lang['failedtoupdateprofileitem'] = "f41leD +O upDatE Pr0phile i+3m";
$lang['startpageupdated'] = "st4Rt p49E UpD@t3D. %s";
$lang['viewupdatedstartpage'] = "vi3w upDa+3D s+4rT P@gE";
$lang['editstartpage'] = "ed1t St4Rt p@9E";
$lang['nouserspecified'] = "no u5Er sP3cifiED.";
$lang['manageuser'] = "m4N493 u\$Er";
$lang['manageusers'] = "m@n@g3 u\$ER5";
$lang['userstatusforforum'] = "user S+4+us F0r %s";
$lang['userdetails'] = "uSer dETa1ls";
$lang['warning_caps'] = "w@RN1ng";
$lang['userdeleteallpostswarning'] = "aR3 j00 sur3 J00 w4nt +o DEl3te @lL oph tEH s3lecteD UsEr's po5+\$? OnC3 +he P0\$+5 @r3 D3L3+3D tH3Y c4nno+ BE rEtr13veD @ND wiLL 83 l0\$+ PH0reVEr.";
$lang['postssuccessfullydeleted'] = "poS+5 weRE \$uCCESSfullY DELE+eD.";
$lang['folderaccess'] = "folD3r @CC3SS";
$lang['possiblealiases'] = "p0Ssi8Le @l1@s3s";
$lang['userhistory'] = "user h1\$TOry";
$lang['nohistory'] = "n0 h1\$TORy r3C0rDs s@vED";
$lang['userhistorychanges'] = "cH4N93s";
$lang['clearuserhistory'] = "cle@R Us3r h1\$+0ry";
$lang['changedlogonfromto'] = "ch4ng3D log0N phR0M %s +0 %s";
$lang['changednicknamefromto'] = "ch@n9ED nICKn4me fR0M %s +0 %s";
$lang['changedemailfromto'] = "cH4n93d 3M4il fr0M %s +o %s";
$lang['successfullycleareduserhistory'] = "succEssfUlLy cle4RED UsER HiS+0rY";
$lang['failedtoclearuserhistory'] = "f4Il3D t0 ClEar U\$er h15+0ry";
$lang['successfullychangedpassword'] = "succ3\$SFuLLy Ch4N93d P4ssw0rD";
$lang['failedtochangepasswd'] = "f4il3D tO cH4N93 p@\$\$w0Rd";
$lang['viewuserhistory'] = "vi3W UsEr h1s+0ry";
$lang['viewuseraliases'] = "view us3r @l14\$3S";
$lang['searchreturnednoresults'] = "sE@RCH R3TUrN3d no rEsUlTs";
$lang['deleteposts'] = "d3LE+3 po5ts";
$lang['deleteuser'] = "dEle+e uS3r";
$lang['alsodeleteusercontent'] = "alS0 DeL3t3 @LL 0ph THe COntENt Cre4+3D By +His UsEr";
$lang['userdeletewarning'] = "ar3 j00 \$URE J00 w@N+ +0 d3LE+E TH3 \$eL3CT3D UsEr aCC0UnT? onc3 tEH @CCOUN+ h45 B3en D3L3TEd i+ C4nno+ Be r3+ri3v3D AnD wIll 8E lOs+ pH0REVER.";
$lang['usersuccessfullydeleted'] = "u53r suCC3\$\$fUlly DEL3T3d";
$lang['failedtodeleteuser'] = "fA1l3D +O DEL3+3 u\$3r";
$lang['forgottenpassworddesc'] = "iF +H1S UsEr hAs PH0RgOtTen +H31r P4\$\$W0rD j00 CAn r3SE+ I+ f0R +H3m h3Re.";
$lang['manageusersexp'] = "thI\$ l1s+ \$h0W5 A \$el3ct10n 0ph u\$eRS wh0 h4VE lOg9Ed 0N +o your pHOrum, s0RTED BY %s. to 4lTER A usEr's p3rmis\$1on\$ clICK +hEIr n4me.";
$lang['userfilter'] = "u5ER pHilt3r";
$lang['onlineusers'] = "oNline U\$3r\$";
$lang['offlineusers'] = "oPhphl1NE usEr\$";
$lang['usersawaitingapproval'] = "u5Er5 @w41t1N9 4PPrOv4l";
$lang['bannedusers'] = "b4NN3D Us3rS";
$lang['lastlogon'] = "last LOG0n";
$lang['sessionreferer'] = "s3ss10n rephER3R";
$lang['signupreferer'] = "si9n-up r3phEr3R:";
$lang['nouseraccountsmatchingfilter'] = "n0 u\$Er @ccount\$ m4+CH1NG pHiL+3R";
$lang['searchforusernotinlist'] = "se4rCh PhoR A usEr no+ in lIs+";
$lang['adminaccesslog'] = "adm1n aCC3sS LO9";
$lang['adminlogexp'] = "thIs L1sT \$h0ws +3H L@\$+ @C+1ON\$ \$@nCTiOnED BY US3R\$ WI+H aDM1n pRIv1l3G3s.";
$lang['datetime'] = "d4t3/+ime";
$lang['unknownuser'] = "unknown U53R";
$lang['unknownuseraccount'] = "unKNown u\$3r 4CcOUNT";
$lang['unknownfolder'] = "uNKn0wn ph0ldeR";
$lang['ip'] = "ip";
$lang['lastipaddress'] = "l4\$t ip 4dDres\$";
$lang['logged'] = "l09geD";
$lang['notlogged'] = "n0+ l09g3D";
$lang['addwordfilter'] = "add wOrD pH1L+3R";
$lang['addnewwordfilter'] = "aDd n3W w0RD PHiLtER";
$lang['wordfilterupdated'] = "word Fil+Er upD@+3d";
$lang['filtername'] = "f1L+er N4M3";
$lang['filtertype'] = "filTER tYp3";
$lang['filterenabled'] = "f1lter 3N4bl3D";
$lang['editwordfilter'] = "eDit w0rD PhIl+3R";
$lang['nowordfilterentriesfound'] = "n0 3XI\$+Ing WorD fIl+3r 3ntRiEs f0unD. to 4DD 4 FiL+3R CLICK Th3 '4DD n3w' bU++0n 83loW.";
$lang['mustspecifyfiltername'] = "j00 MUs+ \$PECIFY 4 pH1L+3r nAmE";
$lang['mustspecifymatchedtext'] = "j00 must spEC1Fy maTCH3D t3XT";
$lang['mustspecifyfilteroption'] = "j00 mu\$t SP3C1fy a f1LTer oPtion";
$lang['mustspecifyfilterid'] = "j00 MuST SP3cIfY 4 Ph1l+3R 1d";
$lang['invalidfilterid'] = "inV4L1d PhIltER iD";
$lang['failedtoupdatewordfilter'] = "f41LeD T0 upD4+3 w0rd PhIlter. CH3cK +H@+ +eh ph1Lt3R \$T1lL Ex15+5.";
$lang['allow'] = "allOw";
$lang['block'] = "bLOCK";
$lang['normalthreadsonly'] = "n0Rm4L +hr34Ds 0nly";
$lang['pollthreadsonly'] = "p0ll +hR34d5 0nly";
$lang['both'] = "b0TH tHr3@D tyP3S";
$lang['existingpermissions'] = "eXIStiNg p3rm1\$sIONs";
$lang['nousershavebeengrantedpermission'] = "no 3X1st1N9 USERs PErm1\$\$1on\$ phouND. to 9R4N+ PErm1S\$10n +0 Us3r\$ \$34RCH Phor +hEM 8EloW.";
$lang['successfullyaddedpermissionsforselectedusers'] = "sUCC3\$SFULLy 4dD3D p3rmi\$SI0ns fOr sel3ctEd US3rs";
$lang['successfullyremovedpermissionsfromselectedusers'] = "succEssfUllY remoVED P3RmIssi0ns fr0M sel3c+3d Users";
$lang['failedtoaddpermissionsforuser'] = "f@Il3D to 4dd P3RMiss10n\$ PhoR U\$er '%s'";
$lang['failedtoremovepermissionsfromuser'] = "f4IL3d +0 r3mOVE p3rm1Ss10ns froM U5ER '%s'";
$lang['searchforuser'] = "sE@rch F0R UsEr";
$lang['browsernegotiation'] = "br0w53r n390ti@+3d";
$lang['largetextfield'] = "l@r93 Text FiELD";
$lang['mediumtextfield'] = "medIUM tExT F13lD";
$lang['smalltextfield'] = "sMAlL +3x+ ph1elD";
$lang['multilinetextfield'] = "mUlti-lin3 +ExT FiELD";
$lang['radiobuttons'] = "r4di0 8UT+on\$";
$lang['dropdown'] = "dROp d0WN";
$lang['threadcount'] = "tHR3ad C0unt";
$lang['clicktoeditfolder'] = "cLick to EDI+ f0ld3R";
$lang['fieldtypeexample1'] = "f0R R4diO BU++0nS @nD DRop D0wn f1ElD\$ j00 n3ED tO s3P4r4+3 +h3 fi3lDN@ME 4nD +3h v4LU3s wi+H 4 C0l0n @ND E4CH VaLUE sh0ULD 83 \$3p@r4+ED By \$emI-C0l0N\$.";
$lang['fieldtypeexample2'] = "ex4mplE: +o Cr34+3 4 84siC 93ndER R@D1o bU+T0Ns, WI+H TW0 sEl3cti0n5 phOR M4L3 4ND pHEM4L3, J00 w0ulD Ent3r: <b>g3nD3R:M4lE;Ph3m4L3</b> 1N +HE 1+3m naM3 f13lD.";
$lang['editedwordfilter'] = "eD1teD WorD Fil+3r";
$lang['editedforumsettings'] = "eD1TeD F0Rum \$3t+1Ngs";
$lang['successfullyendedusersessionsforselectedusers'] = "sucCEs\$fUllY 3nd3D 5EsSI0n\$ PHoR s3leC+3d Us3Rs";
$lang['failedtoendsessionforuser'] = "f@Il3d t0 EnD s3ss1ON F0r USEr %s";
$lang['successfullyapprovedselectedusers'] = "sUCC3s\$fuLlY 4ppr0VED 5el3C+3d us3rS";
$lang['matchedtext'] = "m4+cH3d t3xt";
$lang['replacementtext'] = "rePlAC3MENT TExt";
$lang['preg'] = "pRE9";
$lang['wholeword'] = "wh0le W0rD";
$lang['word_filter_help_1'] = "<b>aLL</b> m4tCh3s @g4in\$+ +H3 WH0le +3Xt s0 F1l+3Ring MoM +o mUm WiLl @l\$0 CH4Ng3 M0menT t0 mUmen+.";
$lang['word_filter_help_2'] = "<b>wHoL3 w0RD</b> M@+CHES 49@inst wh0lE W0rDs 0nly so PhIlTEring MoM t0 mum wIlL NOt CH@nG3 m0meN+ +0 MUM3n+.";
$lang['word_filter_help_3'] = "<b>pR3G</b> 4llow\$ j00 +o usE PErl reGUl4r 3xpR3S51On\$ to M4+ch tEx+.";
$lang['nameanddesc'] = "n4m3 anD DESCR1ption";
$lang['movethreads'] = "movE +hr34D5";
$lang['movethreadstofolder'] = "mOve thrE4DS +0 fOlDER";
$lang['failedtomovethreads'] = "f41l3d +0 mOvE +hr34Ds +0 5pEciPhI3D pHoLD3R";
$lang['resetuserpermissions'] = "re53T U5Er pERmi\$SI0NS";
$lang['failedtoresetuserpermissions'] = "f4Il3D +0 R3sEt u\$3r perMIs5i0ns";
$lang['allowfoldertocontain'] = "alL0w PhoLDER to con+41n";
$lang['addnewfolder'] = "aDD n3w f0LDER";
$lang['mustenterfoldername'] = "j00 mU\$T ENteR 4 PHOldER n4M3";
$lang['nofolderidspecified'] = "n0 f0lD3R 1d 5PECIpHi3d";
$lang['invalidfolderid'] = "iNvaLiD pHolDeR 1D. ch3CK tH4+ @ PhOldER w1+h +his iD EXi5+s!";
$lang['successfullyaddednewfolder'] = "suCC3ssfullY @DD3d neW PhoLder";
$lang['successfullyremovedselectedfolders'] = "sUCc3\$SfullY Rem0vED 53leC+3D FOld3R\$";
$lang['successfullyeditedfolder'] = "suCcEs\$phULlY edi+3d FOLD3r";
$lang['failedtocreatenewfolder'] = "f@il3D to cRE4t3 n3w folD3R";
$lang['failedtodeletefolder'] = "f4IlED T0 DEL3+3 PholDER.";
$lang['failedtoupdatefolder'] = "f41lED T0 UpD4tE f0LDER";
$lang['cannotdeletefolderwiththreads'] = "c@nn0+ d3l3t3 ph0LD3rs +h@+ \$+1ll c0nT@In ThRE4ds.";
$lang['forumisnotrestricted'] = "foRUm I\$ N0t R3str1CT3d";
$lang['groups'] = "gRoup5";
$lang['nousergroups'] = "n0 U5eR 9R0Up\$ h4V3 8E3n 53T Up. +O adD 4 9r0UP CL1CK +h3 '4DD new' BU+Ton bELoW.";
$lang['suppliedgidisnotausergroup'] = "sUPpLi3D giD is not 4 us3r 9r0Up";
$lang['manageusergroups'] = "m@na93 u\$ER 9rouP\$";
$lang['groupstatus'] = "gROUp st4+U\$";
$lang['addusergroup'] = "add U53R gR0UP";
$lang['addemptygroup'] = "add 3mp+y 9r0up";
$lang['adduserstogroup'] = "adD USeR\$ +0 gR0Up";
$lang['addremoveusers'] = "add/REm0v3 U\$3r\$";
$lang['nousersingroup'] = "tHER3 @R3 N0 us3R\$ IN +h1\$ GRoup. 4dd Us3rs +o +h1s 9Roup BY se4RCH1ng ph0R +h3m B3LOW.";
$lang['groupaddedaddnewuser'] = "sUcC3sSFUllY 4dDEd GR0up. 4DD U\$3r\$ +o +hI5 9roUp 8y \$E@rCHInG PhOr th3m B3l0w.";
$lang['nousersingroupaddusers'] = "tH3re 4re n0 UsEr\$ iN thi\$ 9rouP. TO 4dd u\$3r5 CLick +3H '@dD/R3movE usER\$' bU++0N 8eL0W.";
$lang['useringroups'] = "th1\$ USer I\$ 4 mEM83r OpH Teh phOlL0w1nG 9roup5";
$lang['usernotinanygroups'] = "thiS UseR 1S N0t IN @NY UsEr 9RoUPs";
$lang['usergroupwarning'] = "no+E: +Hi\$ us3R M@y BE InH3ri+1N9 4ddi+1OnaL PERmIsSi0nS Fr0m 4NY uS3R GR0ups lI5+3D 8el0w.";
$lang['successfullyaddedgroup'] = "succ3ssfULlY 4ddED gRoUp";
$lang['successfullyeditedgroup'] = "succ3ssphUlLy 3d1+ED Gr0up";
$lang['successfullydeletedselectedgroups'] = "sucC3\$SFuLly d3l3+Ed 53LEC+3d gR0Ups";
$lang['failedtodeletegroupname'] = "fAil3D +0 D3LETE gRoUp %s";
$lang['usercanaccessforumtools'] = "uS3r C@n 4CCess pH0RUm t0oLs 4ND c4n CR34te, D3L3TE @nd ed1+ pHorUM\$";
$lang['usercanmodallfoldersonallforums'] = "u\$Er C@N moD3raTE <b>all ph0LD3rs</b> on <b>aLl f0rum\$</b>";
$lang['usercanmodlinkssectiononallforums'] = "u5ER C@n m0DER4te L1nks 5ec+10N 0n <b>all PhORumS</b>";
$lang['emailconfirmationrequired'] = "em@1l coNPhirm4+i0N reQUiRED";
$lang['userisbannedfromallforums'] = "uS3R 15 8ann3D Fr0M <b>aLl Ph0RUm\$</b>";
$lang['cancelemailconfirmation'] = "cAnC3l 3M4iL C0NPhIRM4T1on 4nD 4ll0w U\$Er +o staRt POS+INg";
$lang['resendconfirmationemail'] = "r3S3Nd coNphiRm@ti0n eM@iL tO usEr";
$lang['donothing'] = "d0 n0+HIng";
$lang['usercanaccessadmintools'] = "us3r H4\$ @cce5S tO f0Rum 4dM1n tO0l5";
$lang['usercanaccessadmintoolsonallforums'] = "u5Er H@\$ @CceSs +o @dmiN TooLs <b>oN 4ll F0rUM\$</b>";
$lang['usercanmoderateallfolders'] = "u5Er C4N M0DERaTE @ll pH0ld3Rs";
$lang['usercanmoderatelinkssection'] = "u5er C4N M0D3ra+E l1nks \$3c+i0N";
$lang['userisbanned'] = "uS3R is B@nnED";
$lang['useriswormed'] = "u\$3r Is W0RmED";
$lang['userispilloried'] = "u5eR 1s PillOr1ED";
$lang['usercanignoreadmin'] = "user C4n i9NorE @DMINis+r4+0Rs";
$lang['groupcanaccessadmintools'] = "gROuP c4N @cC3\$\$ aDM1n +00l5";
$lang['groupcanmoderateallfolders'] = "gROup c4n m0der4t3 4LL Ph0ld3r\$";
$lang['groupcanmoderatelinkssection'] = "gR0UP C4N moDEratE l1nk\$ 5eCtions";
$lang['groupisbanned'] = "gr0up 1S B4nN3D";
$lang['groupiswormed'] = "gr0uP 1\$ w0RmED";
$lang['readposts'] = "r3Ad pOs+S";
$lang['replytothreads'] = "replY TO +HR34D\$";
$lang['createnewthreads'] = "cr3@+3 n3w +Hr3@DS";
$lang['editposts'] = "ediT p0sts";
$lang['deleteposts'] = "del3+e P0S+s";
$lang['postssuccessfullydeleted'] = "po5+\$ \$uCCEsSPHULLY D3LETeD";
$lang['failedtodeleteusersposts'] = "f41led +0 del3+3 uSer's Po\$Ts";
$lang['uploadattachments'] = "uPLo@D @++4cHMen+s";
$lang['moderatefolder'] = "mODerA+e f0LD3r";
$lang['postinhtml'] = "post iN html";
$lang['postasignature'] = "p05+ @ \$19nA+ure";
$lang['editforumlinks'] = "ed1+ pH0RUm l1nks";
$lang['linksaddedhereappearindropdown'] = "l1NKs 4dd3D h3r3 4Pp3@r 1N 4 DR0P DOWN 1N TH3 +0P RI9HT 0F +3h fr@m3 SE+.";
$lang['linksaddedhereappearindropdownaddnew'] = "lINK\$ 4ddED HEr3 ApP3ar 1N 4 dR0P d0wN IN +3H TOP ri9hT 0PH tH3 PhR4mE Set. T0 @Dd 4 LINK cL1cK t3h '@dD nEW' bU++0n B3LOw.";
$lang['failedtoremoveforumlink'] = "f41l3d TO rem0v3 forum lInK '%s'";
$lang['failedtoaddnewforumlink'] = "f4ILED +0 ADD N3W pH0RUM l1nk '%s'";
$lang['failedtoupdateforumlink'] = "f4Il3d t0 uPd4+e pHOrum l1nk '%s'";
$lang['notoplevellinktitlespecified'] = "nO toP LEVEl l1nK t1tl3 5peciPhi3d";
$lang['youmustenteralinktitle'] = "j00 must 3nT3r 4 L1nk +i+L3";
$lang['alllinkurismuststartwithaschema'] = "aLl l1NK ur1\$ MUs+ \$+@RT w1th @ \$Ch3M4 (1.E. ht+p://, Ph+p://, iRC://)";
$lang['editlink'] = "eD1+ lInK";
$lang['addnewforumlink'] = "adD nEW F0RUm L1NK";
$lang['forumlinktitle'] = "f0RUM L1nK +i+L3";
$lang['forumlinklocation'] = "f0RUm l1nK lOC@t10n";
$lang['successfullyaddednewforumlink'] = "sUCCE\$sFULLy 4DDED n3w f0RUm liNK";
$lang['successfullyeditedforumlink'] = "sucC3\$SFUlLy EDITEd pHoRUm l1nk";
$lang['invalidlinkidorlinknotfound'] = "inV4L1d l1NK iD oR L1nk n0T f0unD";
$lang['successfullyremovedselectedforumlinks'] = "sUcC3\$SfULly rEm0V3d \$el3C+3D l1nks";
$lang['toplinkcaption'] = "t0P l1Nk c4p+i0N";
$lang['allowguestaccess'] = "aLLow 9ue5+ 4cC3SS";
$lang['searchenginespidering'] = "sE@rCH 3n9inE sp1D3ring";
$lang['allowsearchenginespidering'] = "alL0W 534Rch EN9in3 spiD3RiNG";
$lang['newuserregistrations'] = "new usEr rE91\$+R4t1on\$";
$lang['preventduplicateemailaddresses'] = "pR3V3n+ DUpLic4+3 3m@1l @DdrEss3S";
$lang['allownewuserregistrations'] = "aLl0W new Us3R R391\$+r4+1on5";
$lang['requireemailconfirmation'] = "r3QU1r3 Em41l C0nfirm@+10n";
$lang['usetextcaptcha'] = "u\$e tEx+-c4PTCH4";
$lang['textcaptchadir'] = "t3Xt-C@p+Ch@ DireC+OrY";
$lang['textcaptchakey'] = "t3x+-Cap+CH@ kEY";
$lang['textcaptchafonterror'] = "teX+-c@pTCH4 h@\$ B33n dis@8l3d 4U+0m4+iC4lly bec@UsE +H3RE @R3 n0 +rUE +Ype F0N+5 av4ILA8le PH0R I+ +o Us3. PL34s3 UpL04d s0m3 +rUE +YpE FoN+S to <b>%s</b> on YOUR \$ervEr.";
$lang['textcaptchadirerror'] = "tex+-C4p+CH@ HAs B33N DiS@8LED 8ecaU\$e th3 +3xT_C@PtCH4 d1rEc+0Ry 4ND 1+'s sU8-dir3ct0R13s @R3 N0T WrI+@8L3 8Y +hE W38 \$erv3r / phP proc3ss.";
$lang['textcaptchagderror'] = "t3x+-cap+ch@ h4s B33n dis@8led BEc@USE Y0ur \$erv3R'\$ PHp s3+up D03s N0+ Pr0v1DE sUpPor+ F0R 9d Im4G3 M4n1pUL4+I0n 4ND / or +Tf pH0Nt sUpP0rT. 8O+h @R3 rEqUIr3d phor +Ext-CAPtCH4 supPoR+.";
$lang['textcaptchadirblank'] = "t3x+-C@p+CH4 Dir3c+oRy i5 bl4nk!";
$lang['newuserpreferences'] = "n3w u53r pr3PHER3ncEs";
$lang['sendemailnotificationonreply'] = "eM4IL n0t1f1CA+I0N On r3PLY +o U\$3r";
$lang['sendemailnotificationonpm'] = "em4il No+ifiC@+10n on pm to U\$3r";
$lang['showpopuponnewpm'] = "sH0W PopUp Wh3N R3C31vING nEw Pm";
$lang['setautomatichighinterestonpost'] = "s3+ 4uT0m@tiC HiGh In+3re\$+ 0n Po\$+";
$lang['postingstats'] = "p0StiNg st@Ts";
$lang['postingstatsforperiod'] = "po5+1n9 s+4t\$ ph0R pER10D %s +0 %s";
$lang['nopostdatarecordedforthisperiod'] = "n0 P0s+ d@+@ rECOrDED phOr +H15 peRi0d.";
$lang['totalposts'] = "t0tAL p0\$+5";
$lang['totalpostsforthisperiod'] = "t0t4l pos+s phOr +hIs perI0D";
$lang['mustchooseastartday'] = "mus+ Cho0Se @ 5+@rT D4y";
$lang['mustchooseastartmonth'] = "mU\$+ CH0o\$3 4 sT4rt mOn+h";
$lang['mustchooseastartyear'] = "mU\$+ CHoo\$e @ stAr+ Y34r";
$lang['mustchooseaendday'] = "mUSt Choo\$3 a 3nd D@Y";
$lang['mustchooseaendmonth'] = "mUST choo53 4 EnD mon+h";
$lang['mustchooseaendyear'] = "mUs+ choO53 4 End YE4R";
$lang['startperiodisaheadofendperiod'] = "st4rt P3r1oD i5 ahE4D opH End pErI0D";
$lang['bancontrols'] = "b4N C0n+ROls";
$lang['addban'] = "add B4n";
$lang['checkban'] = "cH3Ck 8AN";
$lang['editban'] = "edI+ baN";
$lang['bantype'] = "b4n +yP3";
$lang['bandata'] = "b@n d4+4";
$lang['bancomment'] = "cOmm3Nt";
$lang['ipban'] = "ip 8an";
$lang['logonban'] = "lO90n 84n";
$lang['nicknameban'] = "n1cknaME 8@n";
$lang['emailban'] = "eM@il B4N";
$lang['refererban'] = "r3feR3r 8an";
$lang['invalidbanid'] = "inV4l1D B4N 1D";
$lang['affectsessionwarnadd'] = "th1S 8an m4Y 4phphEC+ +3h folLOwIn9 @ct1VE USER sE\$SI0ns";
$lang['noaffectsessionwarn'] = "th1\$ 8an @fFECTS n0 4C+1v3 \$3sSI0ns";
$lang['mustspecifybantype'] = "j00 mU5+ \$p3CipHy 4 BAn +ype";
$lang['mustspecifybandata'] = "j00 mU5+ \$P3CiPhY s0m3 b@N D4+@";
$lang['successfullyremovedselectedbans'] = "sUcCEssfuLlY R3m0v3D s3l3C+3D 8An\$";
$lang['failedtoaddnewban'] = "f@Il3d +0 aDD n3w B@n";
$lang['failedtoremovebans'] = "f@1l3D +0 REM0V3 \$0me 0r 4Ll 0PH +H3 s3lEC+3d BAns";
$lang['duplicatebandataentered'] = "dupliC4te 84n D@+4 entEr3d. plEas3 Ch3Ck Your wiLDC4rD5 T0 s3e iPh +h3y 4lR3@dy M4TCh +H3 D@+4 ENTER3d";
$lang['successfullyaddedban'] = "sUcCE\$SphULly ADD3d 84n";
$lang['successfullyupdatedban'] = "sUCc35\$fuLlY UPDatED 8AN";
$lang['noexistingbandata'] = "tHEr3 1s n0 Ex1\$t1ng B4n d4+4. +0 4DD 4 b4N Cl1ck tHe 'aDD NEW' 8UT+0N 8ELoW.";
$lang['youcanusethepercentwildcard'] = "j00 C4N u53 tEh p3rCEn+ (%) w1lDc@RD sYmb0L In @nY 0Ph y0ur 84n lI\$+\$ +o obT41N P@rt14l m@+CHES, 1.3. '192.168.0.%' w0UlD 84N all 1p 4DDRE5s3s in +h3 r@NGE 192.168.0.1 THR0ugh 192.168.0.254";
$lang['cannotusewildcardonown'] = "j00 C@Nn0+ @DD % 4\$ @ w1lDc4rD M4tch 0N I+'\$ 0Wn!";
$lang['requirepostapproval'] = "r3QUirE po\$+ 4Pprov4l";
$lang['adminforumtoolsusercounterror'] = "th3Re mU5+ 8E @T L3As+ 1 usEr w1+H 4dm1N Tools @ND foruM ToOls 4CCe\$s 0n 4lL ph0RUMs!";
$lang['postcount'] = "pOs+ c0uNT";
$lang['resetpostcount'] = "re\$Et pO\$+ coUN+";
$lang['failedtoresetuserpostcount'] = "f4Il3D +0 R353+ po5+ C0unT";
$lang['failedtochangeuserpostcount'] = "f41l3D +0 Ch@Ng3 U\$3r pOst cOuNt";
$lang['postapprovalqueue'] = "pO5+ 4pProv4L quEU3";
$lang['nopostsawaitingapproval'] = "no p0\$+S 4R3 4wa1+iNg @ppr0v4L";
$lang['approveselected'] = "apPrOv3 s3lECTED";
$lang['failedtoapproveuser'] = "f@1led +0 4PprOv3 UsEr %s";
$lang['kickselected'] = "k1ck \$3lEC+3d";
$lang['visitorlog'] = "vi5It0R Log";
$lang['clearvisitorlog'] = "cle4R visi+0R l0G";
$lang['novisitorslogged'] = "nO v1si+0rS logg3D";
$lang['addselectedusers'] = "aDd \$EL3c+3D Users";
$lang['removeselectedusers'] = "r3M0V3 \$EL3c+3D USErS";
$lang['addnew'] = "aDd n3W";
$lang['deleteselected'] = "d3le+E \$3lEctED";
$lang['forumrulesmessage'] = "<p><b>fOrUm rulEs</b></p><p>\nRe91\$TR4T10N T0 %1\$\$ 1\$ PhReE! w3 DO 1NSi\$+ +h4T j00 @b1D3 8Y +EH RULE\$ @nD P0L1c13S D3t4iL3D B3LOW. 1ph j00 @gR3E +O +3H TERm\$, PLEas3 CH3cK +H3 'I @9R3e' ChECKbox 4ND Pr3S5 +eH 'R39is+3r' BU+t0n 8El0w. 1Ph j00 would Lik3 to C4nCEl +h3 rE9i\$+R4TION, cl1Ck %2\$\$ +0 retURN +o +H3 Phorums inD3x.</p><p>\nAlthoUGH the @Dmin1\$+r4+or\$ @nd MODEr4+0rs 0ph %1\$S w1ll 4++emp+ +0 kEEp 4Ll obj3C+10Na8lE Mes5@93s 0fph +h1\$ F0RUm, 1+ is imP0Ss18le F0r uS to rEv1ew 4Ll M3sSAGes. @ll mes\$49es expr3Ss +Eh v13Ws 0ph th3 4uthor, @nD n31+her +He 0wN3rS 0Ph %1\$\$, nor proj3Ct 8eEh1v3 phorum 4nD 1t's 4phph1L14+es will 8e held rEsp0ns18le F0r th3 c0n+En+ 0ph @ny mESs@ge.</p><p>\n8Y a9r331ng +0 th3S3 rul35, j00 WArr4n+ +h4+ j00 W1ll N0+ Po\$+ 4ny m3ss@g3\$ +h4+ 4r3 085C3ne, vul94r, \$EXu4Lly-or1entateD, h4+3pHUL, Thre4+en1ng, 0R 0therw1S3 v10laT1v3 Oph @ny laws.</p><p>tHE oWNers 0ph %1\$S re53RVe +3h r1Ght t0 remov3, 3d1+, move 0r cLOse 4ny thre@d phor 4ny re450N.</p>";
$lang['cancellinktext'] = "hEr3";
$lang['failedtoupdateforumsettings'] = "fa1lED +0 upD@+3 f0RUm 53+t1n9s. pl3@53 +RY 49@In LatEr.";
$lang['moreadminoptions'] = "m0R3 @DmIn Op+10ns";

// Admin Log data (admin_viewlog.php) --------------------------------------------

$lang['changedstatusforuser'] = "cH4N93d User s+4TUs F0R '%s'";
$lang['changedpasswordforuser'] = "ch@ng3d p4\$SW0RD phOr '%s'";
$lang['changedforumaccess'] = "cH4n9eD F0RUm 4CC3s5 p3rMI\$SIon\$ phor '%s'";
$lang['deletedallusersposts'] = "d3l3+eD 4Ll pos+s phor '%s'";

$lang['createdusergroup'] = "cr34+3d Us3r 9R0up '%s'";
$lang['deletedusergroup'] = "deL3t3d usER gr0UP '%s'";
$lang['updatedusergroup'] = "uPD@teD uSER 9roup '%s'";
$lang['addedusertogroup'] = "aDDED user '%s' to 9Roup '%s'";
$lang['removeduserfromgroup'] = "remoV3 u53r '%s' phroM 9RoUP '%s'";

$lang['addedipaddresstobanlist'] = "add3D 1p '%s' +o 84n l1\$+";
$lang['removedipaddressfrombanlist'] = "r3MOvED Ip '%s' pHrom BAn lIst";

$lang['addedlogontobanlist'] = "aDd3d L0g0n '%s' TO b4n l1\$+";
$lang['removedlogonfrombanlist'] = "r3M0V3d lO90n '%s' froM B@N lis+";

$lang['addednicknametobanlist'] = "addeD n1ckN4M3 '%s' +o 8AN lis+";
$lang['removednicknamefrombanlist'] = "r3M0v3d n1CKn@mE '%s' Phr0m b4N l15+";

$lang['addedemailtobanlist'] = "aDdeD 3m@iL 4DDREss '%s' +o 84n L15+";
$lang['removedemailfrombanlist'] = "rEMOvED EM41l @DDRES\$ '%s' Fr0M 84n l1\$+";

$lang['addedreferertobanlist'] = "aDDEd R3f3r3R '%s' +O b4n L1\$T";
$lang['removedrefererfrombanlist'] = "remOV3D rEPh3R3R '%s' from B4n l15t";

$lang['editedfolder'] = "edi+Ed pH0LD3R '%s'";
$lang['movedallthreadsfromto'] = "moV3d 4ll Thre4d5 Phr0M '%s' +0 '%s'";
$lang['creatednewfolder'] = "cRE@+ED n3w f0LD3r '%s'";
$lang['deletedfolder'] = "d3LE+3d f0lder '%s'";

$lang['changedprofilesectiontitle'] = "cH4ngED PR0FIlE s3c+ion t1+l3 fr0m '%s' t0 '%s'";
$lang['addednewprofilesection'] = "addeD N3w pR0F1le S3C+i0n '%s'";
$lang['deletedprofilesection'] = "deL3T3d prOfiL3 SECT1On '%s'";

$lang['addednewprofileitem'] = "adD3d N3W Prof1L3 1+EM '%s' +0 \$eC+10N '%s'";
$lang['changedprofileitem'] = "chANgEd pR0PHil3 1+eM '%s'";
$lang['deletedprofileitem'] = "d3Le+ED ProPHiL3 1T3m '%s'";

$lang['editedstartpage'] = "eD1T3d \$T4r+ P4g3";
$lang['savednewstyle'] = "s@VeD nEW STYL3 '%s'";

$lang['movedthread'] = "mOveD +HRe4D '%s' phRom '%s' To '%s'";
$lang['closedthread'] = "clO5ED +hR34d '%s'";
$lang['openedthread'] = "op3n3D +hr34d '%s'";
$lang['renamedthread'] = "r3n4M3d +hR3@d '%s' +0 '%s'";

$lang['deletedthread'] = "deLE+3d tHr34D '%s'";
$lang['undeletedthread'] = "unD3l3TED +Hr34d '%s'";

$lang['lockedthreadtitlefolder'] = "l0cK3d ThRE4d OptIoNs on '%s'";
$lang['unlockedthreadtitlefolder'] = "uNLoCK3d tHr34D oPt10ns On '%s'";

$lang['deletedpostsfrominthread'] = "delEtEd P0s+S fr0m '%s' 1N +HrEAD '%s'";
$lang['deletedattachmentfrompost'] = "dELE+ED 4+t@ChM3Nt '%s' Phr0M P05+ '%s'";

$lang['editedforumlinks'] = "eDItEd FOrUM L1NkS";
$lang['editedforumlink'] = "edI+3d fORum L1nk: '%s'";

$lang['addedforumlink'] = "aDDeD f0Rum L1NK: '%s'";
$lang['deletedforumlink'] = "del3+3d Ph0rum liNk: '%s'";
$lang['changedtoplinkcaption'] = "cH4Ng3D +0P L1Nk C4P+ioN fR0M '%s' To '%s'";

$lang['deletedpost'] = "d3L3t3D Po5+ '%s'";
$lang['editedpost'] = "edI+ED pOst '%s'";

$lang['madethreadsticky'] = "m4DE +hr34d '%s' s+iCky";
$lang['madethreadnonsticky'] = "m4d3 ThrE4d '%s' non-sT1CKY";

$lang['endedsessionforuser'] = "eNdED s3ssi0n pHor U\$3r '%s'";

$lang['approvedpost'] = "apPRoveD Po5+ '%s'";

$lang['editedwordfilter'] = "edi+ED wOrD fil+Er";

$lang['addedrssfeed'] = "aDdeD r\$S f33D '%s'";
$lang['editedrssfeed'] = "eD1t3d rsS F33d '%s'";
$lang['deletedrssfeed'] = "d3L3+3d Rss F33D '%s'";

$lang['updatedban'] = "upd@+3D b4n '%s'. CH4N9ED +ypE pHrom '%s' to '%s', cHAN9ED D@+@ phroM '%s' to '%s'.";

$lang['splitthreadatpostintonewthread'] = "sPl1T +Hr3@d '%s' 4T p0ST %s  1nt0 new Thr34D '%s'";
$lang['mergedthreadintonewthread'] = "mErg3D ThrE4D5 '%s' @nD '%s' in+o N3W +HR34D '%s'";

$lang['approveduser'] = "aPPr0ved U\$3r '%s'";

$lang['forumautoupdatestats'] = "fOrum aU+0 UpD@+3: 5+atS Upd@+3D";
$lang['forumautoprunepm'] = "f0RuM @utO UpD4T3: Pm f0LdeR5 PrUN3D";
$lang['forumautoprunesessions'] = "f0RUm 4UTo UPD@t3: se5sI0Ns prUN3D";
$lang['forumautocleanthreadunread'] = "fORum 4u+o UPD@+3: +HrEAD UnREAD D4+4 CLEAN3d";
$lang['forumautocleancaptcha'] = "f0rum 4U+O Upd4te: +Ex+-CaP+CHA Im4g3s CLe4n3D";

$lang['adminlogempty'] = "admiN lOg 1S 3mpTY";

$lang['youmustspecifyanactiontypetoremove'] = "j00 mu\$t sp3CipHy 4N @cT1oN +ypE T0 rEM0V3";

$lang['removeentriesrelatingtoaction'] = "r3M0V3 3ntr13S R3L4T1ng to 4CT10n";
$lang['removeentriesolderthandays'] = "reMov3 3n+r13s 0ldeR Th4n (d@Y5)";

$lang['successfullyprunedadminlog'] = "sUcCESsfuLLy pRUNEd 4dmiN L09";
$lang['failedtopruneadminlog'] = "f4il3D +0 prun3 4DM1N Lo9";

$lang['prune_log'] = "pruN3 log";

// Admin Forms (admin_forums.php) ------------------------------------------------

$lang['noexistingforums'] = "n0 ex1S+iNg FoRUmS F0UnD. TO CrE4TE @ nEW F0RUM CLICK +hE '4DD nEw' BU++0n 8ELow.";
$lang['webtaginvalidchars'] = "w38t@9 CAn 0nly c0nt41n UPPeRc4\$3 4-z, 0-9 4ND UnD3rsC0RE CHar4c+3Rs";
$lang['databasenameinvalidchars'] = "d4+4B4\$3 n4m3 C@N only CON+4In 4-z, 4-z, 0-9 AnD UNDER\$CORE CHAR4C+ERs";
$lang['invalidforumidorforumnotfound'] = "inv@L1D F0rum F1D Or F0rUM nOT PhOUnD";
$lang['successfullyupdatedforum'] = "sUCC3\$sFulLy UPd@+3D F0RUM";
$lang['failedtoupdateforum'] = "fa1L3d t0 UpD@+E Ph0ruM: '%s'";
$lang['successfullycreatednewforum'] = "sucCEs\$FuLlY CR34+ED NEW phOrUM";
$lang['selectedwebtagisalreadyinuse'] = "t3h \$el3C+ED WE8T4g is 4LrE4dy 1N U\$3. PlE4\$3 cHOOSe @N0ThEr.";
$lang['selecteddatabasecontainsconflictingtables'] = "th3 sel3CTED D4+4B4S3 conT4In5 c0nphl1ct1n9 +4BL3s. C0nfL1CT1ng t@bLE N@M3S @r3:";
$lang['forumdeleteconfirmation'] = "are j00 \$urE J00 w@N+ to DEL3+E @Ll 0F +hE sEL3cTED F0RUm\$?";
$lang['forumdeletewarning'] = "plEaSE n0t3 +H4T j00 C4nnO+ reCOv3r DEL3teD pHoRUM5. oNcE D3l3tED @ phorUM 4ND @LL 0f 1+'s 4\$\$0Ci4TED d4+a is PErm4nENTLY reMOveD PhRoM The D@+@8as3. iPh j00 Do no+ W1Sh tO DEL3+3 TEH s3L3cTED pHoRuMs PlE453 CLiCK C@NCEl.";
$lang['successfullyremovedselectedforums'] = "sUcC3\$sfUlLy DelE+ED s3LEC+3D pH0RUM5";
$lang['failedtodeleteforum'] = "f4IlED To dELE+ED F0rum: '%s'";
$lang['addforum'] = "aDd F0rUm";
$lang['editforum'] = "eDi+ ph0rum";
$lang['visitforum'] = "vi\$1t PHorum: %s";
$lang['accesslevel'] = "access l3V3l";
$lang['forumleader'] = "fOrum L3@D3r";
$lang['usedatabase'] = "us3 D4tAB45e";
$lang['unknownmessagecount'] = "uNknown";
$lang['forumwebtag'] = "fORUM WEbTA9";
$lang['defaultforum'] = "d3f4Ult f0RUm";
$lang['forumdatabasewarning'] = "pL3@\$e 3n\$ur3 J00 s3lEC+ tH3 COrR3C+ D4T48@s3 WH3n crE4+inG @ n3w pH0RUm. 0ncE CRE@T3D 4 n3W Ph0RUM C@Nn0t 83 mOv3D 8etw3en 4V41L4Ble D4+@84se5.";

// Admin Global User Permissions

$lang['globaluserpermissions'] = "glo84l U\$3r p3RmIs5I0N5";

// Admin Forum Settings (admin_forum_settings.php) -------------------------------

$lang['mustsupplyforumwebtag'] = "j00 mus+ suppLy 4 f0Rum w3B+4G";
$lang['mustsupplyforumname'] = "j00 mus+ 5Upply 4 F0rUm NaME";
$lang['mustsupplyforumemail'] = "j00 mUsT sUppLy @ Ph0RuM EMa1L 4dDrEs\$";
$lang['mustchoosedefaultstyle'] = "j00 mUst CH0Ose 4 DEF4ul+ pHoruM \$+Yle";
$lang['mustchoosedefaultemoticons'] = "j00 musT CH0os3 D3faUlT pH0RUm Emo+iC0N5";
$lang['mustsupplyforumaccesslevel'] = "j00 MU\$+ \$UpPlY 4 phoRuM 4Cc35S l3V3l";
$lang['mustsupplyforumdatabasename'] = "j00 mUst SupplY 4 phoRuM da+4b4\$3 n4m3";
$lang['unknownemoticonsname'] = "unKN0wn eMot1CON\$ n4ME";
$lang['mustchoosedefaultlang'] = "j00 MUSt CH0OSe @ DEPH4ul+ Ph0rUm L4NGuA93";
$lang['activesessiongreaterthansession'] = "acT1V3 5es510N T1M3OuT C4nn0+ be gr34+3R Th@N \$3ssi0N T1M3out";
$lang['attachmentdirnotwritable'] = "at+4CHmEnT D1rec+0RY 4nd \$y\$+3m tEMp0r4rY DIR3CToRY / phP.1n1 'UPL0@D_TmP_D1r' mU5+ 8E wr1+4BLe BY +3h wE8 servER / Php Pr0cES\$!";
$lang['attachmentdirblank'] = "j00 mUst SUPpLy @ D1r3C+oRy +0 s@vE @++4CHM3nts IN";
$lang['mainsettings'] = "m41n s3++InG\$";
$lang['forumname'] = "f0rum n4M3";
$lang['forumemail'] = "fOrum EM41L";
$lang['forumnoreplyemail'] = "n0-Reply Em4IL";
$lang['forumdesc'] = "f0RUm D3SCrIp+i0n";
$lang['forumkeywords'] = "f0Rum KEyW0rDS";
$lang['defaultstyle'] = "dEf4uL+ s+YL3";
$lang['defaultemoticons'] = "deF4ul+ 3MotiC0ns";
$lang['defaultlanguage'] = "dEf4Ul+ lan9UA93";
$lang['forumaccesssettings'] = "f0RUm @CC3Ss s3++1ngs";
$lang['forumaccessstatus'] = "fOruM 4CCesS \$+4tus";
$lang['changepermissions'] = "ch4nge p3rmissI0Ns";
$lang['changepassword'] = "ch4nG3 p4\$SW0RD";
$lang['passwordprotected'] = "p4\$sw0rD prOtEC+3D";
$lang['passwordprotectwarning'] = "j00 havE n0+ 53T 4 forum P4\$\$worD. 1F j00 dO Not s3t 4 p@s\$W0rD +HE p4ssw0RD Pr0t3CT10n fUnction4l1+y wIlL BE 4u+0M4+Ic4llY DI5@BLED!";
$lang['postoptions'] = "pOs+ 0p+10ns";
$lang['allowpostoptions'] = "all0w po5+ 3dI+InG";
$lang['postedittimeout'] = "p0St ED1+ T1ME0ut";
$lang['posteditgraceperiod'] = "pOST EDIT 9R4cE PEriOD";
$lang['wikiintegration'] = "wIk1w1k1 iNtEGR4T10n";
$lang['enablewikiintegration'] = "eN@8LE w1k1w1K1 INTEGR@+i0n";
$lang['enablewikiquicklinks'] = "eNaBLE WiKIwIk1 qu1ck lInks";
$lang['wikiintegrationuri'] = "w1KiwiK1 l0C@t1ON";
$lang['maximumpostlength'] = "m4XimUM P05+ lEN9+h";
$lang['postfrequency'] = "p0s+ pHr3QuENCy";
$lang['enablelinkssection'] = "eNa8LE lInK\$ \$EC+1ON";
$lang['allowcreationofpolls'] = "alloW CrEAt10n opH p0Ll\$";
$lang['allowguestvotesinpolls'] = "aLlow 9U3s+s +0 voTe iN poll5";
$lang['unreadmessagescutoff'] = "uNr34d mE5\$@9es Cu+-0fph";
$lang['unreadcutoffseconds'] = "s3ConD\$";
$lang['disableunreadmessages'] = "dIS4bl3 unr34D mess@gE\$";
$lang['nocutoffdefault'] = "no CU+-opHf (d3f4Ul+)";
$lang['1month'] = "1 M0n+H";
$lang['6months'] = "6 m0n+h\$";
$lang['1year'] = "1 ye4R";
$lang['customsetbelow'] = "cu5+om V4lU3 (\$e+ B3LOw)";
$lang['searchoptions'] = "sE@rCh 0p+10ns";
$lang['searchfrequency'] = "s34rCH fr3QU3ncY";
$lang['sessions'] = "s3Ssi0Ns";
$lang['sessioncutoffseconds'] = "s3s\$10N cUt 0FpH (sECONDS)";
$lang['activesessioncutoffseconds'] = "aC+1V3 sE\$SIoN CUt 0PhPh (\$eConDS)";
$lang['stats'] = "sT4+\$";
$lang['hide_stats'] = "hIdE 5+4+S";
$lang['show_stats'] = "show st4+\$";
$lang['enablestatsdisplay'] = "eN@8lE st@tS D1spl4y";
$lang['personalmessages'] = "person@l m3s\$49Es";
$lang['enablepersonalmessages'] = "en@blE p3r\$0n4L m3ss493s";
$lang['pmusermessages'] = "pm m3\$\$493s P3r uS3R";
$lang['allowpmstohaveattachments'] = "aLl0w p3R\$0n4L MEsS4Ge5 t0 h@v3 @+T@chm3NTs";
$lang['autopruneuserspmfoldersevery'] = "auTO pRUNE US3R'\$ pm PhOlDER\$ Ev3ry";
$lang['userandguestoptions'] = "u\$3r @nD GUEst 0P+I0ns";
$lang['enableguestaccount'] = "enA8l3 gUEs+ 4cCoUn+";
$lang['listguestsinvisitorlog'] = "li5t guEsTs In vi\$1+oR L09";
$lang['allowguestaccess'] = "all0w 9U3st 4CCESs";
$lang['userandguestaccesssettings'] = "u5eR 4nd 9u3St @cC3sS S3+t1N9s";
$lang['allowuserstochangeusername'] = "alLow U\$er5 +0 Ch@Ng3 u\$3rn4m3";
$lang['requireuserapproval'] = "rEquiR3 U\$3r 4ppr0VaL By 4dm1n";
$lang['requireforumrulesagreement'] = "requ1R3 u\$3r +0 4GR3e +0 F0rum rUlES";
$lang['enableattachments'] = "eNa8L3 4tt4CHm3N+S";
$lang['attachmentdir'] = "aT+AchM3nT d1R";
$lang['userattachmentspace'] = "a++4chmEn+ \$p4C3 p3r UsEr";
$lang['allowembeddingofattachments'] = "aLl0w EMb3dDiNg 0pH 4T+@CHm3n+s";
$lang['usealtattachmentmethod'] = "u5E @L+3rn4+1v3 4tt4CHM3nt ME+H0d";
$lang['allowgueststoaccessattachments'] = "alLOw gUE5+5 +0 @CC3ss @++4chm3nt\$";
$lang['forumsettingsupdated'] = "foruM sETt1ngS suCc3ssfULlY upd4tED";
$lang['forumstatusmessages'] = "fOruM s+4+Us m3Ss4G3s";
$lang['forumclosedmessage'] = "fOrum ClOsED m3S\$49E";
$lang['forumrestrictedmessage'] = "f0rum rEstRicTED m3s5@gE";
$lang['forumpasswordprotectedmessage'] = "f0RuM Passw0rD pR0+3C+ED mEsS@93";

// Admin Forum Settings Help Text (admin_forum_settings.php) ------------------------------

$lang['forum_settings_help_10'] = "<b>pOsT EDIt tImE0u+</b> 1\$ tEH +Im3 In mInutEs 4FtER P05+inG tH@+ a U53r C4N EDIt tH31r PoSt. iPh \$3t to 0 THERe i\$ NO LimI+.";
$lang['forum_settings_help_11'] = "<b>m4XimUM P0st L3N9TH</b> 1\$ +3H m4x1mUm NUm83r oPh CH4r4C+3r\$ +H4+ WIlL B3 D1\$plAy3D In a Po\$+. 1PH 4 pos+ i\$ l0n9Er th4N tEh numb3R 0f CH4r4C+Er\$ DEF1N3D h3RE 1+ wILL be Cut SH0Rt @nD 4 l1nK 4ddED T0 tH3 BotTom t0 4ll0w u\$ers +0 rE4d +he WhOlE po\$+ 0n a \$EP@r4+3 P49e.";
$lang['forum_settings_help_12'] = "ipH j00 d0n't w@n+ yoUr Us3rs +o b3 4bLE +0 cr3a+E Poll\$ J00 CaN D1s@BLE +3H 4BOVE Op+1On.";
$lang['forum_settings_help_13'] = "teh l1nk\$ 5eCt10n 0Ph B33hiV3 proviD3S 4 plaC3 F0R Y0UR Users +0 ma1N+@In @ l1\$t 0Ph si+Es +HEy fr3Qu3nTLY vi5i+ Th@+ oTh3R u\$ers m4Y ph1nd Us3FuL. liNkS c@N B3 D1viD3d Int0 C@+eG0RIEs BY PhOlDEr 4nD @LloW phor COmM3N+s @nD r4tin9s tO 83 givEN. In 0RDER +o M0d3r@tE +eh l1NkS sect10n @ uSER mus+ 83 r4nted 9L0bal m0Der@+0R \$Tatus.";
$lang['forum_settings_help_15'] = "<b>seS5i0n CUT 0fph</b> iS TEh m4XIMuM +iM3 BeF0RE @ US3R'\$ \$3ssi0N 1\$ D3em3d dE4d 4ND +H3Y @RE L09G3d 0u+. by DePH4ul+ +h1\$ 1\$ 24 houR\$ (86400 s3cond\$).";
$lang['forum_settings_help_16'] = "<b>aCt1vE \$e\$SIOn cU+ OpHPh</b> 1\$ +h3 m4XimUM +im3 8eph0RE @ UsER's S3ssIon i\$ DeEm3d in@CT1VE 4t wh1ch pOiN+ +hEy En+3r 4n iDLE \$+4+3. In th1\$ 5+@+e tHE u\$3r rEM4In\$ lo993d iN, 8Ut +HEy ar3 r3mOVEd frOm tHE 4c+ive UsERS Li\$T in t3H st@ts D1spl4y. 0nC3 +hey 8EC0m3 @Ctiv3 49A1n +HEy w1Ll be r3-4ddeD +0 th3 l1ST. 8Y DEph4ul+ +h1\$ S3T+inG is \$E+ +o 15 m1nu+3S (900 SEConD\$).";
$lang['forum_settings_help_17'] = "eN@8L1Ng +H1\$ opt10n 4LLoW\$ B33hiVE +o 1NCLUD3 @ s+@+5 d1SPL4y 4T +HE 80TtOm 0ph tEH M3ss493s pan3 s1m1L4r t0 +3h 0N3 u\$3D 8y M4Ny PhOrUm \$0phtwAR3 T1+l3S. oNC3 eN@8led tH3 DI\$pl4Y 0F tEH \$+4T5 P493 c@n BE +09GL3D ind1VIDU@LlY BY E4ch Us3R. 1f +H3y don'+ w4nt t0 \$3e i+ +hEy C4N hiD3 1+ FROm viEw.";
$lang['forum_settings_help_18'] = "p3R\$0n@l mEs5@gEs 4r3 iNv@luA8le @\$ @ w4y 0F t4kiNg m0r3 PriV@+3 m4tt3r\$ out 0F vI3W Oph tEH OThER M3M8ERs. hOw3v3r IF j00 DOn't w4nt Y0UR uSEr5 To 83 4BlE tO 53nD 34CH 0+hER pERs0N@L mesS@G3S J00 caN DI5@8LE +Hi5 0p+I0N.";
$lang['forum_settings_help_19'] = "pers0n@l mEs5@gEs C4N 4lsO CoNt41n aTt4cHmEnts WhICh CaN 83 Us3fUL f0r 3XCh4nGINg phIlE5 BEtw33n UseR\$.";
$lang['forum_settings_help_20'] = "<b>nOt3:</b> ThE sp@CE @lLoC@+Ion Phor pm ATt4ChMEnts 1\$ +4k3n Phr0m 3aCh Us3R\$' Ma1n att4chm3nt @lloC4T10n @ND i\$ no+ 1N @DD1+i0N t0.";
$lang['forum_settings_help_21'] = "<b>eN@8l3 guE\$+ @CC0un+</b> ALLoW\$ v15i+0rs +0 bRow\$3 y0ur fOrUM 4ND R34D pO\$+S wi+h0u+ r3g1sTErIng @ USEr 4Cc0un+. 4 Us3r 4ccouNT I5 \$t1LL r3qu1r3D IPh +h3y wi5h +0 pOs+ OR CH4n93 U\$3r PrePh3r3nCE5.";
$lang['forum_settings_help_22'] = "<b>l15t GUEsTs in vIs1+0r Log</b> 4lloWs j00 +o \$P3cIpHy wh3+HEr or NoT UNr3g1\$+3Red U5er5 @r3 LisTED on tEH V1sItOr l0g 4Lon9 \$1d3 r39is+ER3d U\$eR5.";
$lang['forum_settings_help_23'] = "be3hiv3 4llows @++4chm3N+5 to 83 UPL0AD3D +0 MEss@g3S Wh3n p0\$TeD. 1Ph J00 h@V3 LImI+3d W38 spACE J00 m4Y which t0 DIs@BLE 4ttACHm3NTs 8Y CL3aRINg +h3 8ox 4b0v3.";
$lang['forum_settings_help_24'] = "<b>at+4cHmENt DIR</b> I\$ +3h L0C@+i0n 833h1V3 \$HoUlD \$+orE I+'s 4++4chmeNTs IN. Thi5 D1REC+0rY MUS+ 3xIST 0n yOUR WE8 sp4Ce @ND mUsT 83 WR1+4bl3 8y +h3 WEb s3rVER / phP PR0c3SS o+H3rwis3 UPl0aD5 W1LL PH@IL.";
$lang['forum_settings_help_25'] = "<b>a++@ChMen+ \$p@ce pER USER</b> I\$ +H3 m4XimUM @M0un+ opH D15k sp4cE @ u\$Er h4\$ pHOr 4+t4chmENT5. onCE +HI5 5pAC3 i\$ UsED UP ThE us3R canN0t upL04d AnY mORE @++4CHM3Nts. BY DEph4UL+ +hi5 Is 1M8 0Ph sP@cE.";
$lang['forum_settings_help_26'] = "<b>allOW 3m8eDD1n9 0f 4TtACHMentS In mE5S4g3s / si9N@+UrEs</b> AlLow\$ USer5 To eM83D 4+t@CHm3n+s In p0ST5. 3NA8l1n9 Th1S 0PT10n wHiLE U\$EFUL CAN iNcr3As3 yOUr B@nDWIDTH us4g3 DrAs+iC@LlY uNDER CER+41N CONfiGUR4+i0Ns 0f pHp. If J00 h4VE lImi+3D B@NDW1DTH 1+ i\$ r3C0mM3nDED +h4+ j00 D1\$4BLE +hIS 0P+10n.";
$lang['forum_settings_help_27'] = "<b>uSE 4LtERn4TIV3 4++4chM3N+ m3thOD</b> ph0RCES 8e3HiV3 TO U5e @n AlTERN4+1v3 r3tR1EV4l mE+H0D F0r @Tt4chmEN+s. 1F J00 REC31V3 404 ERroR M3ss4ges wH3N TrYInG to DOwNlO4D @++4Chm3nt\$ PhRoM Mes\$493S +ry En4bL1Ng thIS 0Pt10n.";
$lang['forum_settings_help_28'] = "tH1\$ 53tt1Ng 4Ll0ws youR pH0rum tO BE \$PID3r3d 8Y s34RCh 3n9In3s liK3 G0O9l3, 4lt4v1s+4 4nd y@Ho0. IF J00 5WI+Ch ThIs 0p+i0n OFPH Y0UR PHoRUM WiLl NO+ BE INCLUD3d In ThEse 534RCH EN9IN3S rESUlTs.";
$lang['forum_settings_help_29'] = "<b>alloW NEw U\$Er REGiSTR4+IoN\$</b> 4lloWs 0R DI\$@lloWs +h3 crE4+i0n 0f neW UsER 4ccOUNtS. seTt1Ng +H3 0p+1ON TO N0 C0mplE+ELy DIS4bles +3h RE91stR@T1ON FOrM.";
$lang['forum_settings_help_30'] = "<b>en4Ble wIkIw1k1 1N+39R@+i0n</b> PR0v1D3\$ W1k1w0rD supP0R+ iN Y0UR PhOrUM P05t\$. 4 w1k1W0rd I\$ M@dE UP 0ph TW0 or m0re C0nc4+3N4t3D w0rds wI+h Upp3rcAs3 L3++3rs (OpHtEN r3ferRED +0 @5 CAM3lC4\$3). If J00 WrI+3 4 woRD tHi\$ waY 1+ WILl @UtOM@+iC4lly 83 chaNgeD in+0 4 HYp3Rl1nk p01N+1ng +0 y0ur Ch053n w1KiwikI.";
$lang['forum_settings_help_31'] = "<b>en4blE wikiWiKi qUiCk LInK5</b> eNA8l3s +hE u\$e Oph msg:1.1 4ND U\$3r:l09oN s+yL3 3xteND3d Wik1linkS WhIcH CRE4t3 hYpERL1NKs To the sP3C1FiED mEs\$493 / us3R proPH1L3 0PH thE Sp3c1f1ED U\$3R.";
$lang['forum_settings_help_32'] = "<b>w1kiWikI LoC4t10n</b> I\$ u53d +0 sp3cIphy ThE UrI of Y0ur w1K1WIkI. wH3n EnTERiNG thE UR1 U\$e [W1k1W0rd] TO 1ND1ca+E wH3RE In +3H UrI TEh WiK1w0RD \$houlD @pPE4r, 1.3.: <i>h++P://3n.w1k1P3d1@.org/W1KI/[w1k1WoRD]</i> WOUlD L1Nk y0ur wIkIworDs +0 %s";
$lang['forum_settings_help_33'] = "<b>f0RUm 4ccEss s+@+u\$</b> c0ntR0Ls h0w us3R\$ M4y 4cCEss y0ur phOrUM.";
$lang['forum_settings_help_34'] = "<b>oPen</b> W1ll 4LLow 4LL UsEr\$ 4nD gUeS+s @cC3ss +o YoUr phorUm wI+H0U+ r3S+rict1on.";
$lang['forum_settings_help_35'] = "<b>cl0seD</b> PR3V3nts 4CC3ss pHoR 4ll UseR5, W1+h +H3 3xCEP+I0n 0Ph the 4DM1n whO May 5+1ll @cC3SS +eh 4DMIN P4N3l.";
$lang['forum_settings_help_36'] = "<b>rES+rICTED</b> 4ll0w\$ to sE+ 4 L1s+ 0PH u\$3rs Who 4r3 @LlOw3d 4CC3ss +o yOur pHorUM.";
$lang['forum_settings_help_37'] = "<b>pA\$sw0rD Pr0tec+3D</b> @lloW\$ j00 +0 SET 4 p4\$\$W0rd +0 9iV3 0u+ +0 u\$3rs \$0 theY C4n 4cC3sS YouR PH0RUm.";
$lang['forum_settings_help_38'] = "wHeN s3++INg Res+rICtED or p4ssw0rd pr0+3c+3d m0D3 j00 w1LL n3ed +0 s@vE yoUr chANGeS B3ph0R3 j00 c@n Ch4N9E +3h USEr acces\$ PR1VIl3GE\$ 0R P4S5w0rD.";
$lang['forum_settings_help_39'] = "<b>Search Frequency</b> defines how long a user must wait before performing another search. Searches place a high demand on the database so it is recommended that you set this to at least 30 seconds to prevent \"search spamming\"fr0m k1ll1nG tEH serVEr.";
$lang['forum_settings_help_40'] = "<b>p0S+ fR3quency</b> 1s +h3 m1nIMUM TiM3 @ UseR MU\$+ w@I+ BeF0re Th3y c4n P0ST 49@In. tH1\$ SetT1NG AL\$0 4phph3Cts +3H CRE4tIoN 0f polLs. \$3t T0 0 +0 Dis@BLE T3h r3str1ct1ON.";
$lang['forum_settings_help_41'] = "teh @BOv3 0PT10ns CH4n93 +He D3F4ul+ v4lu3S PhoR tHe Us3R R3g1\$+R@ti0n f0Rm. WhERE 4ppl1C4bl3 OTHer 53+tings wIlL Us3 +h3 f0rum'S 0Wn Def4ULt seTT1Ng\$.";
$lang['forum_settings_help_42'] = "<b>preveNt usE OpH DUpL1c4+3 ema1L 4dDrE5\$3s</b> Ph0rcEs 8eeHive +0 CH3ck tH3 U53r @Cc0uNts @g41NS+ tEh EM@IL 4dDRE\$S thE U\$3r i\$ REG1\$+eRin9 wi+h @ND PRomp+S +H3m +0 U\$3 4N0thER 1F i+ is ALrE4Dy in Us3.";
$lang['forum_settings_help_43'] = "<b>rEQuIr3 3m41l ConpHiRm4+i0N</b> WH3N 3n4BL3d w1LL \$3nD @n 3m41L +0 e@CH NEw UsER W1+H @ l1nk +h4t C@N BE U53d to coNfIrM Th31r 3M41l adDRE5s. Un+iL Th3y C0nphirM +H3ir em4il 4dDr3sS They W1ll NoT 8E 48l3 +O p0sT UNLES\$ +h31r Us3R PErmi5si0Ns 4RE ch4N93d m4NU4LLY By @n 4dm1n.";
$lang['forum_settings_help_44'] = "<b>u5e +3xt-c4ptCh@</b> PrESENtS +H3 nEw U\$ER W1+H 4 m@ngL3D ImA93 whiCH TH3Y MUs+ C0py @ NUm8eR phRom 1n+0 4 TExt fI3LD 0N TEH rE9i\$+R@+i0n ph0Rm. Us3 thI5 opt10N to pREVEnT au+0M4+3d 5IGn-uP ViA 5cr1pT5.";
$lang['forum_settings_help_45'] = "<b>tEXT-C4p+ch@ DIR3Ct0ry</b> Spec1phI3s +hE loC@+iOn tHa+ 8EEH1v3 will sToR3 i+'\$ +3xt-C@PTCH4 iM49es @ND FoNts iN. +h15 d1r3c+ory MU\$+ bE wRI+@8L3 8y +H3 WE8 s3RvEr / pHp PrOC3ss 4nD MU5+ Be 4CCeS51Bl3 V1@ h++p. 4ph+3r J00 h4v3 en48l3D +Ex+-c4ptCh4 j00 mus+ UPlo@D \$0m3 +ruE +yp3 f0N+s in+0 tEh phONT\$ \$uB-Dir3Ct0ry 0ph y0Ur m41N t3X+-C4p+cH4 Dir3C+Ory oth3Rw15e beEh1v3 W1ll SK1p tH3 +ex+-CAptCH4 DuriNg Us3r R391\$Tr4ti0n.";
$lang['forum_settings_help_46'] = "<b>Text Captcha key</b> allows you to change the key used by Beehive for generating the text captcha code that appears in the image. The more unique you make the key the harder it will be for automated processes to \"guess\"tH3 CoD3.";
$lang['forum_settings_help_47'] = "<b>p0sT ED1T 9r@cE p3ri0d</b> @Ll0ws J00 t0 DEf1n3 4 perIoD 1n M1nUTE\$ wh3R3 u\$Er\$ mAY 3di+ P05+5 wi+h0u+ +h3 '3D1+3D By' +3XT 4pPe4rinG 0n +h3Ir p0sts. 1F \$3t +0 0 teh '3D1+3D By' +3XT w1LL @lW4Y\$ ApP3aR.";
$lang['forum_settings_help_48'] = "<b>unre4D mess@gE5 CU+-0ff</b> \$p3CipHi3s h0w lonG unRE4d m3S\$@ge5 @rE rE+41n3d. j00 may Ch0O\$3 fr0M V4r10u\$ PreS3T V4LU3\$ OR eN+3R yOUr owN Cut-Ophf p3Ri0D In seCOnDs. Thre4dS M0d1PHI3d 34rlieR tH4N TEh D3f1n3d CUt-ophPh peRioD wIll 4UTOma+1C4lly 4PPe4R 45 R34d.";
$lang['forum_settings_help_49'] = "ch00s1ng <b>d1S@8le uNr34D mES\$@GE\$</b> W1ll COMPL3tEly r3m0V3 unrE4D m3SS4GEs \$upport 4ND rEmovE thE REl3v4Nt 0Pt10NS FRoM ThE D1Scu\$5i0N +yp3 Dr0P D0WN 0n tEH +hReaD LIs+.";
$lang['forum_settings_help_50'] = "<b>r3quiRE UsER @pPrOV4L 8y aDm1n</b> 4ll0w\$ j00 +0 r3StriCt 4CceSs by n3w U\$3r\$ UnTiL TH3Y H4vE b33n appr0V3D BY @ moDER@+0R Or 4dmIn. w1ThoUt @PpR0V4L 4 Us3r C@nN0T 4cCE\$S 4Ny Ar3@ Oph thE B33H1V3 f0RUm 1n\$t4lL@ti0N InCLUD1n9 1ND1viDU4L f0RUMs, pm in8Ox aND my ph0RUm\$ \$eC+i0N\$.";
$lang['forum_settings_help_51'] = "u5E <b>clo5eD M3ss@gE</b>, <b>re5tr1CtED M3ss@ge</b> and <b>p45\$w0rD pR0TEC+3d me\$S@G3</b> +0 CUS+0M1s3 +EH M3SS@ge D1spl4yed Wh3n u\$3r\$ 4cCEs\$ y0Ur phorUm 1n +3H V4R10us 5+@Te\$.";
$lang['forum_settings_help_52'] = "j00 C@N u\$e h+ml In yOUR M3ss49E\$. hyPERLiNks @ND EM41l aDDr3sSE\$ W1LL 4ls0 8e @UTOm@t1c4LLy C0nvER+3d +0 l1nks. tO Us3 teH DEF4ul+ B3eh1v3 fOrUM M3Ss493S CL3@r +HE PHI3ld\$.";
$lang['forum_settings_help_53'] = "<b>alL0W usErS +0 ch@ng3 u\$erN@M3</b> permi+s 4LR34Dy r3g1\$+ER3d UsErs +o cHAn93 thE1R U\$3rn4mE. when 3n4BL3D j00 C4n tR4CK th3 CH4N9es 4 US3R mAke\$ +0 tHE1r U\$3rn4M3 Vi4 tEh @DMiN Us3R tooLs.";
$lang['forum_settings_help_54'] = "u53 <b>fOrUm rUl3S</b> T0 en+3R @n aCCEp+48l3 uSE POl1CY +h4T e4ch UsEr mUs+ 49r33 +0 83f0rE rE9is+Er1nG on y0uR phoRUM.";
$lang['forum_settings_help_55'] = "j00 C4N Us3 H+ML IN YoUR f0rum RUL3S. hYPERl1nK\$ AnD EM@il 4DdrE\$S3s will 4LS0 83 @UToMatiC@LLY C0nv3RTED T0 l1NK\$. t0 usE tH3 DEPH4ul+ 8eehIvE PhorUm 4up CLE4r tH3 pH13lD.";
$lang['forum_settings_help_56'] = "usE <b>n0-rEpLy 3mail</b> TO 5peCIPHY 4N EM@1l 4DDr3ss +H@+ D03S N0t ex15t or wIlL N0+ 8E mON1+0r3D F0r r3pL13\$. thi\$ em@iL 4dDRE\$S w1ll 8E U5eD 1n +he H3ADERS f0r @LL 3m@ILs 53N+ FrOM yOUr f0rUm 1NcluDiNg BU+ not LIM1+3d +0 Po5+ @Nd pM n0t1ph1c@t1on\$, user 3Ma1L\$ @nD passw0rD r3m1Nd3Rs.";
$lang['forum_settings_help_57'] = "it is rEC0mm3nd3d tH4t J00 u\$e @N 3m4iL 4Ddre\$s +H@+ DoE5 nOt Ex1\$+ +O h3lP cu+ D0wn 0N Sp4m tH4+ m@Y 8e Dir3c+3D At YoUR M@1n ph0rUm Ema1l aDDRE\$s";

// Attachments (attachments.php, get_attachment.php) ---------------------------------------

$lang['aidnotspecified'] = "a1D N0T SpEC1phi3D.";
$lang['upload'] = "uPlo4D";
$lang['uploadnewattachment'] = "uPl04d N3W 4tt4ChMENt";
$lang['waitdotdot'] = "w@1t..";
$lang['successfullyuploaded'] = "sUcC3\$SFUlLy UpL0@D3d: %s";
$lang['failedtoupload'] = "f@IL3D +0 UPLo4d: %s";
$lang['complete'] = "cOmpL3te";
$lang['uploadattachment'] = "upL04D 4 PhIL3 pH0r 4+t4ChMEnT +0 tH3 MEss493";
$lang['enterfilenamestoupload'] = "en+er ph1l3naME(\$) +o UPLo@D";
$lang['attachmentsforthismessage'] = "aT+4chmEn+s pH0r +hi\$ M3S5@gE";
$lang['otherattachmentsincludingpm'] = "other 4T+@CHmENtS (1ncluD1ng pm mE\$S@G3S @nD other pHoRUm\$)";
$lang['totalsize'] = "toTAl s1z3";
$lang['freespace'] = "fRE3 \$P4c3";
$lang['attachmentproblem'] = "th3r3 w4\$ A ProBL3M D0wnlO4d1ng +hIs AtTaChm3n+. pL34\$3 +rY 4941N LA+ER.";
$lang['attachmentshavebeendisabled'] = "a+TACHM3N+s H4v3 B3EN D1\$@8LEd by +H3 F0RUM 0wn3R.";
$lang['canonlyuploadmaximum'] = "j00 c4N onLy uPlo@D 4 m@ximUM oPh 10 fiL3s @T 4 timE";
$lang['deleteattachments'] = "d3l3te 4t+@ChMEnTs";
$lang['deleteattachmentsconfirm'] = "aRe j00 sUr3 J00 w@n+ +0 d3lE+e +h3 SEl3cT3D @++4chm3N+s?";
$lang['deletethumbnailsconfirm'] = "arE j00 5UrE J00 w4Nt t0 DELEtE tEH seleCTED @++4cHm3n+\$ +HUmbN4ils?";

// Changing passwords (change_pw.php) ----------------------------------

$lang['passwdchanged'] = "p4Ssw0Rd CH@n9ed";
$lang['passedchangedexp'] = "y0UR p4s\$w0RD h@5 B3eN CH4ngED.";
$lang['updatefailed'] = "upda+e PH@1led";
$lang['passwdsdonotmatch'] = "p4\$sw0rDs d0 n0t m4+Ch.";
$lang['newandoldpasswdarethesame'] = "nEw @nd OlD P@5\$w0rds @R3 +EH \$@Me.";
$lang['requiredinformationnotfound'] = "reQUiR3D 1NPh0rM4t10n not f0unD";
$lang['forgotpasswd'] = "fOR90T p4\$sw0rd";
$lang['resetpassword'] = "r3SET p4SSw0rd";
$lang['resetpasswordto'] = "rEset p4\$SW0rd TO";
$lang['invaliduseraccount'] = "iNv@liD Us3r @cCOunt sP3CIPhIED. CHeCK EM41l phOr COrr3c+ L1Nk";
$lang['invaliduserkeyprovided'] = "inV4L1d Us3r KEY pr0v1D3d. Ch3cK 3M41l pH0R c0rrECT l1Nk";

// Deleting messages (delete.php) --------------------------------------

$lang['nomessagespecifiedfordel'] = "no messagE \$p3CiPhi3d F0r d3L3t10n";
$lang['deletemessage'] = "d3l3t3 M3\$\$@g3";
$lang['postdelsuccessfully'] = "p0St DEL3TED \$uCc3\$SFUlLY";
$lang['errordelpost'] = "eRror d3leTinG pos+";
$lang['cannotdeletepostsinthisfolder'] = "j00 C@Nn0T DEL3T3 P0\$+s In +Hi\$ PhOlDER";

// Editing things (edit.php, edit_poll.php) -----------------------------------------

$lang['nomessagespecifiedforedit'] = "n0 me5\$49E \$p3C1ph1ED phOr eD1+Ing";
$lang['cannoteditpollsinlightmode'] = "c@Nno+ 3D1+ poll\$ 1N l19h+ M0DE";
$lang['editedbyuser'] = "eDIT3D: %s bY %s";
$lang['editappliedtomessage'] = "eDIT @Pplied T0 m3sS4G3";
$lang['errorupdatingpost'] = "erRor upD4T1n9 P05+";
$lang['editmessage'] = "eD1+ me\$sag3 %s";
$lang['editpollwarning'] = "<b>nOtE</b>: 3D1t1Ng C3r+@in @sPeC+s opH 4 poLl wiLL vOID 4ll Th3 CURrEn+ VO+3S @nd 4llow p30PlE +0 v0+3 @G41n.";
$lang['hardedit'] = "h4rD EDIT 0P+1on\$ (vo+3S will 83 r3SET):";
$lang['softedit'] = "s0FT 3di+ op+i0nS (vOtES will b3 r3Ta1n3D):";
$lang['changewhenpollcloses'] = "ch4ngE wH3N +HE pOll cLo\$E\$?";
$lang['nochange'] = "n0 CH4NGE";
$lang['emailresult'] = "eM4IL REsUlt";
$lang['msgsent'] = "m3Ss@GE S3NT";
$lang['msgsentsuccessfully'] = "m3s\$4g3 s3nt sUCC3ssphUlLY.";
$lang['mailsystemfailure'] = "m41L sy5+EM f41LUr3. m3Ss49e N0t \$EN+.";
$lang['nopermissiontoedit'] = "j00 ARE n0+ PeRmI+TED T0 ed1+ +hi\$ m3ss49e.";
$lang['cannoteditpostsinthisfolder'] = "j00 C4nn0T 3d1T po5+\$ In +hI\$ FolDER";
$lang['messagewasnotfound'] = "m3ss@gE %s was no+ pHouND";

// Email (email.php) ---------------------------------------------------

$lang['sendemailtouser'] = "send 3m41l T0 %s";
$lang['nouserspecifiedforemail'] = "nO U\$er \$P3c1F13D FoR EM41LING.";
$lang['entersubjectformessage'] = "en+3r @ 5UBJ3c+ PH0r +3h mES\$49e";
$lang['entercontentformessage'] = "eNt3R some CoN+3nT F0R thE m3ss@G3";
$lang['msgsentfromby'] = "tH1S m3\$S493 W4\$ \$3n+ Fr0m %s by %s";
$lang['subject'] = "subj3ct";
$lang['send'] = "s3nd";
$lang['userhasoptedoutofemail'] = "%s h4S 0pted OuT oph Em4il C0nt4CT";
$lang['userhasinvalidemailaddress'] = "%s has 4n 1NV@l1d eM@iL 4ddrEs5";

// Message nofificaiton ------------------------------------------------

$lang['msgnotification_subject'] = "m3Ss4GE n0+1ph1cAt10n fR0m %s";
$lang['msgnotificationemail'] = "heLlo %s,\n\n%s p0\$TED @ Mess493 +o j00 on %s.\n\n+HE 5uBj3c+ 1s: %s.\n\nTo re4d +H@T m3SS493 @nd o+hERs IN The 54M3 di\$CU5Si0n, 90 +o:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nN0t3: 1f j00 D0 N0+ wi5h +O rEC31v3 Em@1L notifiC4+10ns oph phorUm mess49es pO\$TED +0 Y0u, 90 +0: %s cliCk on my Contr0Ls +hen Em4il 4ND priv@CY, unselECt ThE ema1L N0+IF1c4+ion Ch3CK8oX @nD pr3ss suBmi+.";

// Thread Subscription notification ------------------------------------

$lang['subnotification_subject'] = "su85Cripti0n n0+IphIC4+i0n fR0M %s";
$lang['subnotification'] = "h3Llo %s,\n\n%s pO5+ed @ M3s\$493 1N A +hR3AD J00 h@v3 \$UB5Cr18ed +0 0n %s.\n\n+h3 SUbJ3c+ I\$: %s.\n\n+0 re4d +H4+ MEsS@9E @nD OThEr5 in +3H 5@mE d1scU5\$1on, g0 t0:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nNOtE: 1F j00 do not wi\$H +0 Rec31v3 Ema1L no+iphicAt10n5 oph new M3Ss4g3s In +h15 +hr34d, 90 to: %s 4ND @DjU\$T y0Ur intEr3st lEvel @+ +Eh 8ot+0m 0f +h3 p4g3.";

// PM notification -----------------------------------------------------

$lang['pmnotification_subject'] = "pM noTIPhic4+I0N PhR0M %s";
$lang['pmnotification'] = "hELLo %s,\n\n%s P0\$teD 4 pM To J00 oN %s.\n\n+HE suBjEc+ 1\$: %s.\n\n+o RE4D +HE m3SS@G3 g0 +o:\n%s\n\n~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~\n\nN0+3: iF j00 D0 n0+ wi\$H To rec31V3 3Ma1l N0TiPhICa+1oN\$ 0f nEW pm MEss49es Po\$+ED +0 Y0u, g0 to: %s CliCK mY COntr0LS +hen eM41l @ND pR1V@Cy, unsEl3C+ +Eh pm no+iphiC@+i0n CHeCkBOX @nd pr3\$S \$Ubmit.";

// Password change notification ----------------------------------------

$lang['passwdchangenotification'] = "p4S\$woRD chaNge n0+iPHiC4+i0n PHrOM %s";
$lang['pwchangeemail'] = "heLlo %s,\n\nthI\$ @ nO+IFiCATiOn EM4IL T0 INfoRm j00 Th4t Y0ur P4SSw0rd 0N %s HaS 8een CH4ngeD.\n\n1+ h4s B33n cHaNgED To: %s @nD W45 cH4N9ed bY: %s.\n\n1ph j00 H4v3 r3ce1V3d this Em4il 1n 3rror 0r wER3 n0+ ExPECT1NG a CH4nGE +0 yoUR passWorD Ple453 C0n+@CT th3 F0RUm 0WN3r or @ mod3R4t0R 0n %s 1Mm3D14t3ly t0 C0rReC+ i+.";

// Email confirmation notification -------------------------------------

$lang['emailconfirmationrequired'] = "eM41l C0npH1rM@+I0N rEQUir3d phor %s";
$lang['confirmemail'] = "hEllo %s,\n\ny0u reC3N+Ly CRE4+3d @ N3w user @CCOUn+ 0N %s.\n83F0re j00 cAN s+4R+ post1NG wE n3ed +0 C0NpHIrM y0uR 3m41l aDdREs\$. doN'T WoRry Th1S Is qU1+3 E45Y. @ll j00 nE3d t0 do 1\$ clICK +h3 l1nk BEl0w (0R C0py 4nD p4s+E i+ 1nt0 Y0UR BR0w\$3r):\n\n%s\n\nONC3 C0nph1RMa+10N 1S c0MPLEte j00 m4Y l09in 4ND 5+4rt p0stin9 imMeD14+ely.\n\niph j00 D1D N0+ CrE4t3 4 USEr aCC0Unt oN %s pLE@53 4CCEp+ oUr 4pol0giE\$ 4nD phorW@rD tH1s 3m4IL +o %s so th@+ +3h s0urCe 0Ph 1+ m4Y 8e INVest1g@+3D.";
$lang['confirmchangedemail'] = "h3Llo %s,\n\nyou r3C3ntLy CH4n93d yOur EM41L 0N %s.\nB3ph0RE j00 C4N sT4Rt POs+inG a94In wE N3ED T0 c0nF1rM y0Ur NEW emA1L 4ddR3SS. d0N't WorRY +His 1S qUiT3 3@sy. 4ll j00 ne3D +0 d0 1s CLicK +eH liNK beL0w (0r C0py 4nD pAS+e it into yOUr bR0w\$3r):\n\n%s\n\n0nC3 conPh1rmatION i\$ C0MPl3+e J00 May C0nt1NUe T0 us3 TH3 F0rum @\$ N0rm@l.\n\n1ph j00 weRe no+ Expec+1Ng +hIs 3m41l PHr0m %s PL34\$E 4CCEp+ oUR 4polO913S 4nD f0rw4rD +h1s em4il t0 %s s0 +H4+ t3h sourc3 0Ph i+ m4y 83 inVEst1g4tEd.";


// Forgotten password notification -------------------------------------

$lang['forgotpwemail'] = "h3Llo %s,\n\ny0u r3qu3sTED +Hi\$ 3-m41L phR0m %s 83Cau\$e j00 H4V3 Ph0rg0++3N YoUR P4SsworD.\n\ncl1cK +hE Link 8el0W (0r C0Py 4ND P@\$+E i+ 1N+0 Y0Ur 8rOW53r) T0 rE\$e+ y0Ur P4S\$worD:\n\n%s";

// Forgotten password form.

$lang['passwdresetrequest'] = "yoUR P4\$sw0RD reSet rEQU3S+ FrOm %s";
$lang['passwdresetemailsent'] = "p4Ssw0rD rEs3+ 3-m@iL \$EN+";
$lang['passwdresetexp'] = "j00 sh0ULD sH0rtly rEC3Iv3 4n E-m41l COn+@Inin9 1NstrUCT10ns pHor r3SEtT1Ng y0ur p45\$W0rd.";
$lang['validusernamerequired'] = "a v@lid uS3rNAmE is REqUIR3D";
$lang['forgottenpasswd'] = "f0r9Ot p@5SW0RD";
$lang['couldnotsendpasswordreminder'] = "cOuld n0+ 5END paSSW0rd REMiND3r. PL34sE COn+4ct tHE F0RUM Own3r.";
$lang['request'] = "requEsT";

// Email confirmation (confirm_email.php) ------------------------------

$lang['emailconfirmation'] = "eMA1l c0NPhirm@+I0N";
$lang['emailconfirmationcomplete'] = "tH4nk j00 phOr c0nf1rm1nG your 3M4il 4dDRE\$s. J00 M4y n0W login @ND 5+@R+ p0\$+1N9 imMedI4+elY.";
$lang['emailconfirmationfailed'] = "em4il C0NphIrm@+i0n H4s ph41l3D, Pl3453 +rY 494In L@TEr. If j00 EnCoUntER tH1s ErRoR mulT1PlE +iM3s pLe453 c0N+@CT +H3 phorUm own3r or 4 mod3R4tor f0R @s\$1\$tanc3.";

// Links database (links*.php) -----------------------------------------

$lang['toplevel'] = "t0P Level";
$lang['maynotaccessthissection'] = "j00 may noT @CCESs +hiS \$ecti0N.";
$lang['toplevel'] = "tOp l3V3l";
$lang['links'] = "l1nkS";
$lang['viewmode'] = "v13w m0D3";
$lang['hierarchical'] = "h13r4rChIC4l";
$lang['list'] = "lI5+";
$lang['folderhidden'] = "tHIs F0LD3r iS H1dd3N";
$lang['hide'] = "hId3";
$lang['unhide'] = "uNHID3";
$lang['nosubfolders'] = "no su8phOldEr\$ in tH1\$ C4te90RY";
$lang['1subfolder'] = "1 \$UBFOLD3R 1n this cAtEGoRY";
$lang['subfoldersinthiscategory'] = "sU8ph0LDER\$ in Th1s C@t3GorY";
$lang['linksdelexp'] = "eN+riE\$ iN @ D3L3teD f0LD3r W1ll BE m0veD +0 TH3 p@r3NT f0lD3R. 0NLY ph0LD3r\$ whICH Do N0+ C0n+@In \$UbphOlDers M4y bE DEl3TED.";
$lang['listview'] = "l15+ v13w";
$lang['listviewcannotaddfolders'] = "c@NN0T 4dd Fold3rs in th1S v13W. 5H0wIn9 20 EN+r1e5 @+ 4 T1m3.";
$lang['rating'] = "r@tin9";
$lang['nolinksinfolder'] = "n0 Links 1n tHis pHOlDeR.";
$lang['addlinkhere'] = "adD l1nk HEr3";
$lang['notvalidURI'] = "thAT 1S noT a v@l1D URi!";
$lang['mustspecifyname'] = "j00 mUs+ sPECifY 4 n4M3!";
$lang['mustspecifyvalidfolder'] = "j00 mU\$t \$P3ciPhY 4 valiD F0lDEr!";
$lang['mustspecifyfolder'] = "j00 mUst \$P3Ciphy 4 foLDer!";
$lang['successfullyaddedlinkname'] = "succ3SSfulLY ADDED l1NK '%s'";
$lang['failedtoaddlink'] = "fA1l3d T0 aDD L1NK";
$lang['failedtoaddfolder'] = "f41lED +o @dd Fold3R";
$lang['addlink'] = "add 4 liNk";
$lang['addinglinkin'] = "add1n9 L1nk in";
$lang['addressurluri'] = "addr3\$S";
$lang['addnewfolder'] = "adD 4 nEW f0ldeR";
$lang['addnewfolderunder'] = "aDd1NG new phOlDER UND3r";
$lang['editfolder'] = "edI+ f0ld3r";
$lang['editingfolder'] = "edIT1Ng Ph0ld3r";
$lang['mustchooserating'] = "j00 mu\$t Choo\$3 4 r4T1N9!";
$lang['commentadded'] = "y0ur c0mm3Nt W4\$ @Dded.";
$lang['commentdeleted'] = "c0MM3nT w4s D3LETED.";
$lang['commentcouldnotbedeleted'] = "c0MMEnT coulD n0t BE D3LETED.";
$lang['musttypecomment'] = "j00 MU5t +YPE A COmM3Nt!";
$lang['mustprovidelinkID'] = "j00 mU\$+ pRoViD3 4 liNk iD!";
$lang['invalidlinkID'] = "inv4l1d liNK iD!";
$lang['address'] = "aDDr3s5";
$lang['submittedby'] = "su8mi+t3D 8y";
$lang['clicks'] = "cL1ck\$";
$lang['rating'] = "r@T1ng";
$lang['vote'] = "v0+e";
$lang['votes'] = "v0T3s";
$lang['notratedyet'] = "nOt r4+ED BY 4NyoNE Y3T";
$lang['rate'] = "rAte";
$lang['bad'] = "b@D";
$lang['good'] = "gOod";
$lang['voteexcmark'] = "vOte!";
$lang['clearvote'] = "cl34r v0+3";
$lang['commentby'] = "coMmENt BY %s";
$lang['addacommentabout'] = "aDd @ c0Mm3nt 4BOUT";
$lang['modtools'] = "modEr@ti0n +O0ls";
$lang['editname'] = "eDi+ n4M3";
$lang['editaddress'] = "edi+ 4DDRE\$s";
$lang['editdescription'] = "ed1+ d3SCr1P+i0n";
$lang['moveto'] = "move +0";
$lang['linkdetails'] = "l1Nk dEt41L\$";
$lang['addcomment'] = "aDd COmM3Nt";
$lang['voterecorded'] = "y0UR vO+3 h@s 8eEn rEC0rdED";
$lang['votecleared'] = "y0ur vo+E Has 8E3n Clear3d";
$lang['linknametoolong'] = "lInk N@m3 +0o l0n9. M@xImum 1\$ %s Ch4r4C+eRs";
$lang['linkurltoolong'] = "l1nK URl Too l0n9. m4XImUM 1S %s CHARAC+3rs";
$lang['linkfoldernametoolong'] = "f0ldeR NaME too l0n9. m4XImUM L3n9Th I5 %s CH4r4C+ER\$";

// Login / logout (llogon.php, logon.php, logout.php) -----------------------------------------

$lang['loggedinsuccessfully'] = "j00 loggED 1N \$uCcESsFUlLy.";
$lang['presscontinuetoresend'] = "pr3ss Con+inu3 +0 R3SEND pHorM D4+4 0r C4nceL To REloaD p@9E.";
$lang['usernameorpasswdnotvalid'] = "tH3 u53rn4M3 0r P@5\$W0rD j00 \$UppLi3D 1S nO+ V4l1d.";
$lang['rememberpasswds'] = "r3Mem83r pasSW0rd\$";
$lang['rememberpassword'] = "rem3mBEr P45\$W0rD";
$lang['enterasa'] = "enter @s a %s";
$lang['donthaveanaccount'] = "doN'T h4v3 4n 4CC0un+? %s";
$lang['registernow'] = "r3g1\$t3r n0W.";
$lang['problemsloggingon'] = "pro8l3ms Lo9G1ng oN?";
$lang['deletecookies'] = "deL3te COoKi3S";
$lang['cookiessuccessfullydeleted'] = "coOK1ES \$uCCESsfuLlY D3LETED";
$lang['forgottenpasswd'] = "f0Rg0+TEn y0ur passW0RD?";
$lang['usingaPDA'] = "u51ng 4 pDA?";
$lang['lightHTMLversion'] = "l19hT hTMl V3R\$i0N";
$lang['youhaveloggedout'] = "j00 H4v3 LoggED 0ut.";
$lang['currentlyloggedinas'] = "j00 4R3 CuRrEn+ly l0g93d in @\$ %s";
$lang['logonbutton'] = "lOg0N";
$lang['otherbutton'] = "other";
$lang['yoursessionhasexpired'] = "yOUr \$3s\$I0n h4\$ 3XP1r3D. j00 W1LL n3eD +0 l091N 4941n to COn+iNu3.";

// My Forums (forums.php) ---------------------------------------------------------

$lang['myforums'] = "my phOrUms";
$lang['allavailableforums'] = "alL 4V@IlABL3 ForUM5";
$lang['favouriteforums'] = "f4v0urI+3 f0rUM5";
$lang['ignoredforums'] = "i9N0ReD F0RUm5";
$lang['ignoreforum'] = "i9N0RE pH0RUm";
$lang['unignoreforum'] = "unigN0R3 pH0RUM";
$lang['lastvisited'] = "l@5+ vi5i+ED";
$lang['forumunreadmessages'] = "%s Unre4D m3sS49e\$";
$lang['forummessages'] = "%s mEss4G35";
$lang['forumunreadtome'] = "%s unR3@D &quot;t0: m3&quot;";
$lang['forumnounreadmessages'] = "nO unr34d M3s\$49E\$";
$lang['removefromfavourites'] = "r3m0V3 PhR0M pH4V0URI+3s";
$lang['addtofavourites'] = "add +0 phaV0UriTE5";
$lang['availableforums'] = "av@IL@bl3 ph0rUM\$";
$lang['noforumsofselectedtype'] = "tHer3 ar3 n0 pHoruMs of TEH sEL3c+3D +ypE @V41l@8LE. pL34\$3 sel3cT @ D1phfeRENT +yp3.";
$lang['successfullyaddedforumtofavourites'] = "sUcC3\$SFUlLy aDD3D f0rUM +0 f4V0ur1TEs.";
$lang['successfullyremovedforumfromfavourites'] = "sUCC3sSFULLy rem0V3D pHoRUM phrOm f4vOUR1t3S.";
$lang['successfullyignoredforum'] = "sUcCE\$sfullY 1gN0RED pHoRUm.";
$lang['successfullyunignoredforum'] = "sucC3sspHully UnIGnor3D FOrUM.";
$lang['failedtoupdateforuminterestlevel'] = "fA1LED +O uPD@t3 f0RUm 1NtER3s+ L3vEl";
$lang['noforumsavailablelogin'] = "th3RE 4R3 no foRum5 av4Ila8lE. PL3A5e Lo9In +o vI3W yOUr pHoRUM\$.";
$lang['passwdprotectedforum'] = "p45\$w0RD PrO+3C+3d PhOrUM";
$lang['passwdprotectedwarning'] = "tHi5 pHorUm 1S p45SWorD pR0TECTED. to 9A1n @CC3s5 3n+er tEH p4S\$w0rD 8ELOw.";

// Message composition (post.php, lpost.php) --------------------------------------

$lang['postmessage'] = "p0s+ m3ssa93";
$lang['selectfolder'] = "s3LECt f0LDER";
$lang['mustenterpostcontent'] = "j00 mu5+ 3N+3r \$0mE COntenT pH0R +H3 P0ST!";
$lang['messagepreview'] = "m3\$S49E PReViEW";
$lang['invalidusername'] = "iNv@lid usERn@mE!";
$lang['mustenterthreadtitle'] = "j00 mU\$t ENtER A +1+l3 pH0R +He tHRE4D!";
$lang['pleaseselectfolder'] = "ple4s3 \$eL3c+ 4 F0ldeR!";
$lang['errorcreatingpost'] = "erROr CR3@+iNg po\$+! pL34\$e tRy @g41N in 4 PH3W m1NUtes.";
$lang['createnewthread'] = "cRe4TE nEw +hrEAD";
$lang['postreply'] = "pOst r3PLy";
$lang['threadtitle'] = "thR3@d T1tl3";
$lang['messagehasbeendeleted'] = "mess49E N0t F0unD. CH3ck th4+ I+ H@\$n't B3en DEL3ted.";
$lang['messagenotfoundinselectedfolder'] = "mEsS49E n0T F0UND In sEl3c+3D F0ld3R. CH3CK +H@T i+ h@\$N'+ Been m0VED 0r D3l3TED.";
$lang['cannotpostthisthreadtypeinfolder'] = "j00 C4nN0t pO\$+ +hI\$ +HrE4d +yP3 in tH@+ PholDER!";
$lang['cannotpostthisthreadtype'] = "j00 c@Nno+ Po\$+ +his +hr34d tyP3 4s +h3RE @R3 no @V@IlaBL3 PH0ld3rs +H4+ @LLOW I+.";
$lang['cannotcreatenewthreads'] = "j00 CanNo+ cRE4TE NEw +hR3@Ds.";
$lang['threadisclosedforposting'] = "th1\$ thre4D I5 clos3D, J00 c4nno+ p0ST iN i+!";
$lang['moderatorthreadclosed'] = "w4RnInG: tHiS +hr34D 1\$ Cl0seD phor p0\$+1N9 +0 norM4l user\$.";
$lang['usersinthread'] = "uSER\$ iN +hr34d";
$lang['correctedcode'] = "coRr3c+ED C0dE";
$lang['submittedcode'] = "su8m1+Ted CoD3";
$lang['htmlinmessage'] = "hTML 1N m3ss49E";
$lang['disableemoticonsinmessage'] = "d1\$4blE 3m0tIC0n\$ IN MEs\$@GE";
$lang['automaticallyparseurls'] = "auTom4t1CaLlY P@r53 Url\$";
$lang['automaticallycheckspelling'] = "aUt0m@+ic@lLY CH3ck SP3LL1n9";
$lang['setthreadtohighinterest'] = "s3T +Hr34d To h1gh 1NtER3S+";
$lang['enabledwithautolinebreaks'] = "en@8L3d wi+h 4U+0-lInE-BR3AKs";
$lang['fixhtmlexplanation'] = "tHI5 foruM uS3s h+mL Ph1l+3RIng. Y0UR sU8m1++3d H+mL HAS b3EN m0dipHI3D by +h3 FiL+3R\$ in \$0mE W4Y.\\n\\nTo v13w y0uR 0R1G1n@L CODE, \$3l3C+ +HE \\'\$u8M1++3d CODe\\' r4D10 8u++on.\\n+0 vieW +h3 m0D1phIED CODe, \$3L3c+ +HE \\'CoRR3c+eD coDE\\' RADio BU+T0n.";
$lang['messageoptions'] = "m35\$49E 0PT1onS";
$lang['notallowedembedattachmentpost'] = "j00 Are n0T 4ll0w3D to 3M8ed @t+4CHM3NTs 1n y0ur p0St5.";
$lang['notallowedembedattachmentsignature'] = "j00 @rE nOt 4LL0w3D +o eM8eD 4++4chmEn+s 1n y0UR sIGn4tur3.";
$lang['reducemessagelength'] = "mE\$S4g3 l3n9tH MUs+ 8e UNDEr 65,535 Ch@R@CtER\$ (cUrRENTlY: %s)";
$lang['reducesiglength'] = "sIgn4TURe LEng+h MUst 8E uND3r 65,535 chaR4c+ER5 (CURRENtLY: %s)";
$lang['cannotcreatethreadinfolder'] = "j00 c4NNOT cR3ATe N3w tHrE4ds IN THI\$ PhOlDER";
$lang['cannotcreatepostinfolder'] = "j00 C@NnoT repLy +0 p05+\$ iN +hi\$ pHoldEr";
$lang['cannotattachfilesinfolder'] = "j00 c4nN0t p0ST 4tt4CHM3NTs iN th1S f0ld3R. REm0ve 4++4chmEN+\$ +0 coNt1nUE.";
$lang['postfrequencytoogreat'] = "j00 C4N OnLy po5+ 0NC3 3V3ry %s \$ecoNDS. pLE4SE +rY 4g@in lAt3r.";
$lang['emailconfirmationrequiredbeforepost'] = "eM@IL Conf1rm@+10n 1\$ rEQUIr3d BEF0re J00 C4n post. IF J00 H@V3 n0t r3cEiV3d @ C0nPH1rm@+iOn 3M41L pl34SE CLICK TEH 8u++0n 83lOw 4ND a N3W OnE WIll 83 \$EN+ +0 yOU. iPH Y0ur eM4Il 4dDRE\$\$ n3Eds Ch4n91N9 PlE4se D0 5O BEF0rE REQuE\$+1ng 4 nEw CONPh1rm@+i0n eM4il. j00 may ChangE your 3M4il @ddR3ss 8Y cliCk My c0Ntr0l5 a8OV3 4nD +h3n U5er dEt4IL5";
$lang['emailconfirmationfailedtosend'] = "c0Nph1rm@+10n 3m41l f4ILED +0 sEnd. PL34se cont4ct +HE phoRUm OwNER +0 R3Ct1Fy thI\$.";
$lang['emailconfirmationsent'] = "c0NPhIRm@+i0n Em4il h4\$ 833N R3SEN+.";
$lang['resendconfirmation'] = "rEsenD C0nf1RMAt1on";
$lang['userapprovalrequiredbeforeaccess'] = "y0Ur u53r @cc0Unt n3ed5 +O 8e @pPr0vED 8y @ Ph0rum 4DM1n B3phoR3 j00 c4n aCC3ss +3H R3QU3steD pHorUM.";

// Message display (messages.php & messages.inc.php) --------------------------------------

$lang['inreplyto'] = "iN reply T0";
$lang['showmessages'] = "sH0w m3ss4GEs";
$lang['ratemyinterest'] = "r4+3 mY in+ER3s+";
$lang['adjtextsize'] = "adjUST tExt sIz3";
$lang['smaller'] = "sm4Ll3R";
$lang['larger'] = "l4r9er";
$lang['faq'] = "faq";
$lang['docs'] = "dOc\$";
$lang['support'] = "sUPPoR+";
$lang['donateexcmark'] = "dONat3!";
$lang['fontsizechanged'] = "fON+ \$ize ch4NGeD. %s";
$lang['framesmustbereloaded'] = "fr@ME\$ musT B3 r3l04d3D m4NU@LLy To S3E CH@N93\$.";
$lang['threadcouldnotbefound'] = "thE ReQu3\$+3D thRE4d c0ULD N0+ b3 Ph0UnD or 4cCe\$5 w4\$ D3niED.";
$lang['mustselectpolloption'] = "j00 muSt s3LEC+ 4n OPT1on To V0tE ph0R!";
$lang['mustvoteforallgroups'] = "j00 Mus+ vO+3 iN Ev3rY GR0up.";
$lang['keepreading'] = "k33p R3aDing";
$lang['backtothreadlist'] = "back +o +Hr3Ad L15t";
$lang['postdoesnotexist'] = "tH4+ p0\$+ Doe5 nOT eX1ST 1n TH1s thrE@D!";
$lang['clicktochangevote'] = "cLIck tO cHAnGE V0te";
$lang['youvotedforoption'] = "j00 vo+3D FoR op+10N";
$lang['youvotedforoptions'] = "j00 VO+eD pHOr optIonS";
$lang['clicktovote'] = "cl1ck t0 vOT3";
$lang['youhavenotvoted'] = "j00 H@v3 n0t voTED";
$lang['viewresults'] = "v1ew r3SUl+s";
$lang['msgtruncated'] = "mes\$49E trunC@+3d";
$lang['viewfullmsg'] = "v13W fuLl mE\$\$@G3";
$lang['ignoredmsg'] = "iGn0r3D M3ss@93";
$lang['wormeduser'] = "worMeD uS3r";
$lang['ignoredsig'] = "igN0reD \$iGN@+Ur3";
$lang['messagewasdeleted'] = "me\$S49E %s.%s W45 DeL3t3D";
$lang['stopignoringthisuser'] = "sTOP iGN0R1Ng +h15 us3R";
$lang['renamethread'] = "r3n4M3 ThrE4d";
$lang['movethread'] = "mOv3 +hrE4D";
$lang['torenamethisthreadyoumusteditthepoll'] = "tO reNAmE Th1\$ thR3aD j00 mUs+ 3d1+ +Eh pOlL.";
$lang['closeforposting'] = "cl0\$e F0r po\$+1n9";
$lang['until'] = "uNT1l 00:00 utC";
$lang['approvalrequired'] = "appr0VAl r3quir3d";
$lang['messageawaitingapprovalbymoderator'] = "m3S\$4ge %s.%s 1S @w@I+1n9 4PPRov@l 8y 4 moD3R4+or";
$lang['postapprovedsuccessfully'] = "p0ST 4pPrOv3d SUcCEssPhulLY";
$lang['postapprovalfailed'] = "p0ST 4pPRoV4L f41l3d.";
$lang['postdoesnotrequireapproval'] = "poS+ Do3s n0T rEqU1R3 4PProv4L";
$lang['approvepost'] = "aPPR0ve pO5+ ph0r di5PL4y";
$lang['approvedbyuser'] = "apPR0vED: %s 8y %s";
$lang['makesticky'] = "m4k3 \$T1CKy";
$lang['messagecountdisplay'] = "%s 0f %s";
$lang['linktothread'] = "p3rM@nen+ lInK tO TH1s +hr34d";
$lang['linktopost'] = "liNK +o po\$+";
$lang['linktothispost'] = "l1Nk To This p0ST";
$lang['imageresized'] = "tH1S 1m@g3 h4\$ bEEn r3S1zED (oR1G1n@L s1ze %1\$sx%2\$s). TO ViEw +HE PhUlL-\$1zE iM493 cL1ck heR3.";
$lang['messagedeletedbyuser'] = "mE\$s49E %s.%s D3lEtED %s BY %s";
$lang['messagedeleted'] = "me5\$49e %s.%s W4s DEL3+eD";

// Moderators list (mods_list.php) -------------------------------------

$lang['cantdisplaymods'] = "c4Nn0+ Di5plAY Ph0LDER moDER@+0Rs";
$lang['moderatorlist'] = "mODer4TOR Li5+:";
$lang['modsforfolder'] = "modEr@+0rs F0r ph0ld3r";
$lang['nomodsfound'] = "n0 modeR4Tors pH0UnD";
$lang['forumleaders'] = "f0RUm lEADeR\$:";
$lang['foldermods'] = "fOlD3R MoD3r@+0RS:";

// Navigation strip (nav.php) ------------------------------------------

$lang['start'] = "s+AR+";
$lang['messages'] = "mEs\$@gEs";
$lang['pminbox'] = "iNB0x";
$lang['startwiththreadlist'] = "s+4r+ P4G3 W1+h +hR34d l1\$+";
$lang['pmsentitems'] = "s3n+ items";
$lang['pmoutbox'] = "out80X";
$lang['pmsaveditems'] = "s@V3d iteM5";
$lang['pmdrafts'] = "dr4ft\$";
$lang['links'] = "liNK\$";
$lang['admin'] = "adMiN";
$lang['login'] = "l0G1n";
$lang['logout'] = "l090ut";

// PM System (pm.php, pm_write.php, pm.inc.php) ------------------------

$lang['privatemessages'] = "pr1v4+e m3ss@gE\$";
$lang['recipienttiptext'] = "sEp@r@+3 R3cipi3ntS BY \$3mi-C0L0N or COmm4";
$lang['maximumtenrecipientspermessage'] = "th3r3 Is 4 LImI+ 0ph 10 RECIPI3Nts PEr M3SS@g3. PLE4se @m3nD youR REc1P1EN+ l15+.";
$lang['mustspecifyrecipient'] = "j00 mu\$t \$P3cIfY At L345T oNE R3c1PiEN+.";
$lang['usernotfound'] = "u\$3R %s n0t phounD";
$lang['sendnewpm'] = "sEnd N3W pM";
$lang['savemessage'] = "s@v3 meS\$49E";
$lang['timesent'] = "t1ME 5En+";
$lang['errorcreatingpm'] = "err0r Cr3aT1Ng pm! PlE4sE +Ry 4941n iN 4 pHEW MiNUtes";
$lang['writepm'] = "wr1te Mess@gE";
$lang['editpm'] = "ed1+ m3Ss49E";
$lang['cannoteditpm'] = "c4NnO+ 3D1+ THi\$ pm. i+ H@\$ alR34dY B33N V13wED BY +h3 REcipI3nT 0R +hE m3s5@gE doEs n0t Exi5+ or i+ 1\$ in@CC3S51BLE 8Y J00";
$lang['cannotviewpm'] = "c@Nn0+ VI3w pm. ME\$S493 D03\$ no+ 3x1\$+ 0r 1T i5 inACCEs\$i8L3 BY J00";
$lang['pmmessagenumber'] = "m3SS49e %s";

$lang['youhavexnewpm'] = "j00 h4vE %d n3w mE\$5@gE\$. woulD J00 Lik3 +0 G0 +o y0ur iNB0X N0w?";
$lang['youhave1newpm'] = "j00 h4V3 1 nEW me\$S@G3. wOUlD j00 l1kE +o 90 t0 Y0Ur 1n80x n0W?";
$lang['youhave1newpmand1waiting'] = "j00 H@VE 1 n3W mEss4gE.\\n\\nYoU 4Ls0 H4v3 1 M35s@g3 4WA1+1n9 DeL1V3ry. T0 ReCE1v3 th1\$ M3S5493 ple453 Cl34R sOme sp4c3 iN Y0UR In8ox.\\n\\nW0ulD j00 l1k3 +0 90 +0 Y0ur 1n80x nOW?";
$lang['youhave1pmwaiting'] = "j00 h@V3 1 m3sS49E Aw4i+ing D3L1veRy. +o reCe1VE Th1\$ m3\$\$4G3 pLE453 Cl34R s0ME sPAc3 in YoUr 1NBOx.\\n\\nwOULD j00 L1k3 +0 90 +O YoUr In80X n0W?";
$lang['youhavexnewpmand1waiting'] = "j00 h4v3 %d nEw mEss49E\$.\\n\\nYOU 4ls0 h4v3 1 mes\$49E @W@I+In9 D3l1v3rY. +0 r3C31vE Th1s m3Ss493 pl3@\$e CL34r s0mE Sp4CE 1N Y0UR 1n8ox.\\n\\nw0UlD J00 l1K3 t0 G0 to Y0UR IN8Ox n0W?";
$lang['youhavexnewpmandxwaiting'] = "j00 haVe %d n3w me\$S493S.\\n\\nYOU 4ls0 H4V3 %d mEss@g35 AW4i+ING DELIv3ry. +o r3CE1v3 TH3SE MesS@G3 pl3@\$e cL34r s0mE spAC3 1n yOuR in80x.\\n\\nWOUld J00 lik3 +0 go +o yOur In80X Now?";
$lang['youhave1newpmandxwaiting'] = "j00 H4Ve 1 N3w m3SS@ge.\\n\\nYoU 4lsO H4v3 %d mEss493S 4w4i+Ing D3LIv3rY. +o r3C31vE tH3Se m3Ss493s pLE4Se cLE4r \$0m3 sp4CE in yOuR in8OX.\\n\\nw0uld J00 lik3 +o g0 TO y0UR 1N8Ox now?";
$lang['youhavexpmwaiting'] = "j00 h4v3 %d m3SS493s @w41tIng D3lIvEry. +o rEC31V3 tHe\$3 me5S@GE\$ Ple4se cl34r s0me Sp@CE IN Y0UR In80x.\\n\\nw0ulD J00 l1k3 tO G0 +0 y0ur iN8Ox nOw?";

$lang['youdonothaveenoughfreespace'] = "j00 Do nO+ h4VE 3NoUGH phr33 sp4c3 +0 seND +hI\$ M3ss4gE.";
$lang['userhasoptedoutofpm'] = "%s h@5 op+3d 0Ut 0PH rEC31Ving pEr\$0n@L m3ss493S";
$lang['pmfolderpruningisenabled'] = "pM f0LDER PRUN1NG I\$ 3NaBL3D!";
$lang['pmpruneexplanation'] = "tHis Ph0rum Us3S pM PhOlD3r pruNING. ThE M3Ss49E\$ J00 H4v3 \$+0reD 1N YoUR 1N8oX 4Nd sENT i+3m5\\nph0LDER\$ @RE 5UbjeCT T0 4UtoMa+iC d3LET1ON. 4NY ME\$5@93s J00 w1sh TO kE3P \$hoULD 8e m0VED TO\\nYOUr \\'S@VeD 1+3ms\\' pH0ld3r SO TH4t +h3Y 4R3 noT D3lEtEd.";
$lang['yourpmfoldersare'] = "yOUr pM FoLD3Rs 4R3 %s phULl";
$lang['currentmessage'] = "current mE\$S@Ge";
$lang['unreadmessage'] = "unR34D mEsS49e";
$lang['readmessage'] = "r3@d m3Ss49e";
$lang['pmshavebeendisabled'] = "pErs0N@L mess493\$ h4v3 8eeN DI\$@8LeD 8y ThE f0rum owNEr.";
$lang['adduserstofriendslist'] = "aDd u53r\$ +0 youR pHr1end\$ l1s+ tO H4V3 +H3m 4pPE4R In a DrOP DOWN 0n +3H pm Wr1+E MEss493 p493.";

$lang['messagesaved'] = "m3Ss4G3 s4V3d";
$lang['messagewassuccessfullysavedtodraftsfolder'] = "me\$S4g3 W4\$ 5UCC3\$5FUlly s4VED +0 'DR4FTs' FoLD3R";
$lang['couldnotsavemessage'] = "cOulD n0T S4V3 M3\$\$@g3. m@kE \$UR3 j00 H4ve 3N0u9H @v@ila8le Fr3e 5PaC3.";
$lang['pmtooltipxmessages'] = "%s M3\$\$@GE\$";
$lang['pmtooltip1message'] = "1 M3Ss4g3";

$lang['allowusertosendpm'] = "alLoW User To SENd PERSoN@L M3s\$49e\$ +0 ME";
$lang['blockuserfromsendingpm'] = "bLoCK UsER PhRom sEnDINg per50N@l mEss@g3S +o mE";
$lang['yourfoldernamefolderisempty'] = "y0ur %s ph0lDER Is emP+Y";
$lang['successfullydeletedselectedmessages'] = "sucCEssfullY DEL3TED 53lec+3D M3ss49e\$";
$lang['successfullyarchivedselectedmessages'] = "sUcC3ssfUlLy 4rch1V3d \$El3C+3D MEss@g3S";
$lang['failedtodeleteselectedmessages'] = "f@1L3D T0 D3LETE 53L3c+3D mesS@gE\$";
$lang['failedtoarchiveselectedmessages'] = "f4il3D t0 4RCH1V3 \$EL3ct3D MEs5@ge\$";

// Preferences / Profile (user_*.php) ---------------------------------------------

$lang['mycontrols'] = "my Con+Rols";
$lang['myforums'] = "my foruMs";
$lang['menu'] = "m3nu";
$lang['userexp_1'] = "u\$3 TEh m3NU On Th3 l3F+ +0 m4Na93 y0UR SEt+ings.";
$lang['userexp_2'] = "<b>user d3T@Ils</b> @lL0w\$ j00 +0 CH@NGE yOUr n4ME, 3M4IL 4dDR3Ss @ND P4Ssw0rD.";
$lang['userexp_3'] = "<b>us3r propHiL3</b> 4lloW\$ J00 +O eDIt YoUr useR PrOpHiLe.";
$lang['userexp_4'] = "<b>cH4n93 P4ssw0rD</b> 4ll0w\$ J00 +0 ch@NGE YOUr pAssworD";
$lang['userexp_5'] = "<b>eM41L &amp; pRIV4cy</b> L3t\$ j00 CH@n9E H0W J00 C@n 8E C0nt@C+eD On aND ophPh tEH ph0ruM.";
$lang['userexp_6'] = "<b>fORUM 0Pt1ONS</b> lets j00 CH4nge h0w thE F0RUm LoOk\$ 4nD WoRks.";
$lang['userexp_7'] = "<b>a++acHm3nt\$</b> 4LL0ws J00 t0 3Di+/DelE+e yoUr @+T4Chm3NTS.";
$lang['userexp_8'] = "<b>s1GN@tUR3</b> leTs j00 edIt YoUr \$IGN4+Ure.";
$lang['userexp_9'] = "<b>r3L@tiOnSh1p5</b> L3t\$ J00 M@n@gE Y0UR rel4t10NSh1p wi+H 0ThER Us3rs 0N Th3 f0RUM.";
$lang['userexp_9'] = "<b>w0RD fIl+3R</b> LETs j00 eDI+ YoUr Pers0N4l w0RD Philt3r.";
$lang['userexp_10'] = "<b>tHrEAD 5uBsCR1p+10N\$</b> 4ll0W5 J00 to m4n4g3 y0ur thr3@d su8scR1P+10n\$.";
$lang['userdetails'] = "u\$3r d3T4ils";
$lang['userprofile'] = "uS3r pROPh1L3";
$lang['emailandprivacy'] = "em41L &amp; priV4cy";
$lang['editsignature'] = "ed1+ sign4TUR3";
$lang['norelationshipssetup'] = "j00 h4v3 no U\$er rEL@+i0n\$HIPs s3T up. @DD A neW UsER BY \$E@RCHING BEL0w.";
$lang['editwordfilter'] = "ed1t W0rD Ph1ltER";
$lang['userinformation'] = "u\$3R iNF0rm@+10n";
$lang['changepassword'] = "cHAn93 P45sWord";
$lang['currentpasswd'] = "cUrr3Nt P@s\$W0rd";
$lang['newpasswd'] = "n3w p4sSw0rd";
$lang['confirmpasswd'] = "c0NPh1rM P45\$w0rD";
$lang['passwdsdonotmatch'] = "paSsw0rDs DO No+ maTCh!";
$lang['nicknamerequired'] = "n1CKnaME i5 rEquiR3D!";
$lang['emailaddressrequired'] = "eM@Il 4DDR3ss I\$ rEqUiR3D!";
$lang['logonnotpermitted'] = "l090N not p3rm1++3d. CHoOse @No+H3R!";
$lang['nicknamenotpermitted'] = "n1cknam3 No+ p3rm1t+3D. CHOo53 4noTH3r!";
$lang['emailaddressnotpermitted'] = "em41l @ddR3s\$ n0T P3Rm1++ED. CHo0s3 @n0th3R!";
$lang['emailaddressalreadyinuse'] = "em41l 4DdR3ss aLr34DY in UsE. CH0ose 4No+hEr!";
$lang['relationshipsupdated'] = "rEl@T10N\$h1ps Upd4+3D!";
$lang['relationshipupdatefailed'] = "reL4TIon5h1p UpD4+3d F41l3d!";
$lang['preferencesupdated'] = "pr3phEr3Nc3\$ WEr3 SUcC3sspHULlY upD@+3D.";
$lang['userdetails'] = "u\$er d3+@ils";
$lang['memberno'] = "mem8Er no.";
$lang['firstname'] = "fiRs+ N4M3";
$lang['lastname'] = "l@St n@M3";
$lang['dateofbirth'] = "d4+e oPh BIrth";
$lang['homepageURL'] = "hoM3P493 urL";
$lang['profilepicturedimensions'] = "prOF1LE piCTUre (M4X 95x95px)";
$lang['avatarpicturedimensions'] = "av4+@r piCTUr3 (M4X 15x15px)";
$lang['invalidattachmentid'] = "inv4l1D @++4CHMEnT. ChECK tHa+ i\$ hASN'T 833N DEL3ted.";
$lang['unsupportedimagetype'] = "unSupPOrTED ImA9e aTt4cHmeNt. J00 C4n oNly UsE Jp9, 9iF @nD PnG 1m4g3 4++4CHm3n+s F0r y0ur 4V4+@r 4ND pRoPhIL3 P1C+URE.";
$lang['selectattachment'] = "selEC+ @++4CHM3n+";
$lang['pictureURL'] = "pICtUr3 uRl";
$lang['avatarURL'] = "ava+4R Url";
$lang['profilepictureconflict'] = "tO U53 aN 4++@CHMEnT F0R y0ur pROphilE PIC+URe TH3 Pic+Ur3 uRL PhI3lD MuS+ 8E 8l4nk.";
$lang['avatarpictureconflict'] = "t0 usE @N @++4Chm3nt phor yOUR aV4TaR p1cturE TEH @v@+@r URl F13lD mus+ 8E 8l4NK.";
$lang['attachmenttoolargeforprofilepicture'] = "sEl3C+3d 4t+@CHMENT I\$ +OO l4r93 F0R PR0F1l3 P1cTuR3. m@xiMUm D1m3nSi0ns 4r3 %s";
$lang['attachmenttoolargeforavatarpicture'] = "s3l3cTeD 4Tt4chMEN+ I\$ +o0 l4R9e ph0r @v@+@r pICTUR3. m@xIMUm d1MEn51ON\$ @r3 %s";
$lang['failedtoupdateuserdetails'] = "s0m3 or @LL opH YoUr U\$er @CC0unT DET4ils C0uLD N0+ 83 UPD4tED. pLE4\$3 TRY 4941N L@TER.";
$lang['failedtoupdateuserpreferences'] = "some or AlL oph Y0Ur USEr Pr3f3REnC3s C0uLD not b3 UpD@t3d. pL3453 try 494in L@TER.";
$lang['emailaddresschanged'] = "eM41l 4dDr3s\$ H4\$ BE3n Ch@ng3d";
$lang['newconfirmationemailsuccess'] = "your Em4il 4DDr3sS H@s BE3n CH@N9Ed 4nd 4 n3w CoNf1rMA+1on em41l HAs 8E3n S3NT. PLE4\$3 CHeCK 4nd r34D THE 3m4Il F0R FUR+h3r iN\$TrUC+1ON\$.";
$lang['newconfirmationemailfailure'] = "j00 h4V3 chaNgED YoUr EM41l 4dDRE5S, BU+ We wER3 un4bl3 +o 5END @ C0nf1rm4+I0N R3Qu3s+. plE@5E C0n+@c+ +h3 f0rum owNEr F0R 4Ss1S+4nce.";
$lang['forumoptions'] = "f0RUM 0P+1ON\$";
$lang['notifybyemail'] = "nOT1fy By 3Ma1L 0ph p0s+5 T0 m3";
$lang['notifyofnewpm'] = "n0tiphy by p0PUP oPH n3w pm M3s\$49e\$ +0 mE";
$lang['notifyofnewpmemail'] = "not1Fy bY 3m4il OpH N3W pM mE\$S493s +0 me";
$lang['daylightsaving'] = "aDjus+ PhoR D4yl19Ht \$avIng";
$lang['autohighinterest'] = "aUtom@t1C4lLy M4rK +HREAD\$ i p05+ in as h19h 1N+Er3St";
$lang['convertimagestolinks'] = "aUt0M4T1caLLy c0nvErT 3m83DDEd 1M@G3s iN Post5 IN+o l1Nks";
$lang['thumbnailsforimageattachments'] = "tHUm8n@il\$ F0r im493 4++4chm3nts";
$lang['smallsized'] = "sM4lL S1Z3D";
$lang['mediumsized'] = "med1um \$IZ3d";
$lang['largesized'] = "lArge \$1zED";
$lang['globallyignoresigs'] = "glo84llY i9NOre usER s1gN@+uRE5";
$lang['allowpersonalmessages'] = "aLl0w 0ThER UsER\$ TO \$3nD m3 P3rson@l MESs@GE\$";
$lang['allowemails'] = "aLL0W Oth3r uS3Rs +0 sEnd mE 3Ma1ls v1@ mY PrOPhilE";
$lang['timezonefromGMT'] = "t1M3 Z0n3";
$lang['postsperpage'] = "poS+s peR pA9e";
$lang['fontsize'] = "fon+ \$izE";
$lang['forumstyle'] = "fOrum s+YlE";
$lang['forumemoticons'] = "foRUM emOt1cOn5";
$lang['startpage'] = "sT4RT p493";
$lang['signaturecontainshtmlcode'] = "sI9n4+uRE CONT4IN\$ H+ML CoDE";
$lang['savesignatureforuseonallforums'] = "s@V3 5ign@Tur3 F0r us3 0n 4LL ph0rum\$";
$lang['preferredlang'] = "prEph3RR3D L@N9U49e";
$lang['donotshowmyageordobtoothers'] = "do No+ \$h0w My 493 0r D4+3 0ph BIR+h +O o+H3Rs";
$lang['showonlymyagetoothers'] = "sHow 0NLy my 49e t0 0+h3r\$";
$lang['showmyageanddobtoothers'] = "sh0w BOtH mY 49E @nD DAte OPH BIR+h +0 0+H3Rs";
$lang['showonlymydayandmonthofbirthytoothers'] = "shOw OnlY My Day AnD MoNTH 0ph B1rtH T0 O+h3rs";
$lang['listmeontheactiveusersdisplay'] = "l1\$T mE 0N +EH @CT1v3 U\$ER\$ DI\$pl4y";
$lang['browseanonymously'] = "bR0Ws3 f0RUm @n0NyM0USlY";
$lang['allowfriendstoseemeasonline'] = "br0w53 an0NyMoUslY, 8u+ ALlOw pHRI3NDS +o seE m3 4\$ 0nLiN3";
$lang['revealspoileronmouseover'] = "reV3al sp0il3R\$ 0n m0use ov3R";
$lang['showspoilersinlightmode'] = "alW4Y\$ 5how spoIlER5 In L1GHT mOd3 (useS L1Gh+3R PH0NT colour)";
$lang['resizeimagesandreflowpage'] = "rEs1z3 Im49Es AnD R3Fl0W P49E +o pR3V3n+ h0RiZ0nt4l sCr0ll1ng.";
$lang['showforumstats'] = "sH0W phorUM \$+4T\$ at 8O++0m 0PH MEss493 p4NE";
$lang['usewordfilter'] = "eN48L3 WorD filt3R.";
$lang['forceadminwordfilter'] = "fOrcE Us3 0F 4dmiN W0RD F1L+3r oN AlL usERS (iNC. gu3STS)";
$lang['timezone'] = "tIm3 zOne";
$lang['language'] = "l4N9u@ge";
$lang['emailsettings'] = "em41l 4ND C0nt4c+ 53++1Ngs";
$lang['forumanonymity'] = "fOrum @n0nym1+Y S3+t1ngs";
$lang['birthdayanddateofbirth'] = "b1rthDay @nD DatE oPh BIR+h D1spl@Y";
$lang['includeadminfilter'] = "incLUD3 4dmin wOrD pHiL+3r iN My liSt.";
$lang['setforallforums'] = "s3+ for 4Ll ForUm\$?";
$lang['containsinvalidchars'] = "%s con+@in\$ 1nv4l1D CH4r4CTEr5!";
$lang['homepageurlmustincludeschema'] = "hom3p4Ge UrL mUS+ 1NCLUDE H++P:// \$Chem4.";
$lang['pictureurlmustincludeschema'] = "p1C+uRE Url MU\$+ inCLUDe H+TP:// sCHEM4.";
$lang['avatarurlmustincludeschema'] = "aV4+4r URL Mus+ 1NCLUD3 H++p:// sCHEma.";
$lang['postpage'] = "p05+ p4ge";
$lang['nohtmltoolbar'] = "no h+Ml TooLB4r";
$lang['displaysimpletoolbar'] = "dIspl@y 5IMplE H+ML +0Ol84r";
$lang['displaytinymcetoolbar'] = "d15play Wys1wy9 html t00l8ar";
$lang['displayemoticonspanel'] = "dI\$PL4y 3m0tIC0ns p@n3L";
$lang['displaysignature'] = "d1sPL4y sIGN@+urE";
$lang['disableemoticonsinpostsbydefault'] = "d1SaBLE 3M0+icoN\$ 1n M3ss@ge\$ bY D3F@ULT";
$lang['automaticallyparseurlsbydefault'] = "aUT0m4+1C4LlY P4RsE url\$ In m3Ss@gE\$ bY D3f4uL+";
$lang['postinplaintextbydefault'] = "p05+ in pL4In tExt 8Y D3ph4UL+";
$lang['postinhtmlwithautolinebreaksbydefault'] = "p0ST in htMl wIth 4u+o-l1N3-8re@k\$ 8Y D3PH4ULT";
$lang['postinhtmlbydefault'] = "p05+ iN h+mL bY DEPH4ul+";
$lang['privatemessageoptions'] = "prIV4+e mE\$s@ge opT1on\$";
$lang['privatemessageexportoptions'] = "pr1v@te M3Ss@g3 exp0Rt 0pT1ONS";
$lang['savepminsentitems'] = "s4vE @ C0PY oPh 34CH pm i \$3nD IN my s3Nt 1+3Ms ph0LD3r";
$lang['includepminreply'] = "iNClud3 ME\$\$493 80Dy wH3n R3PLy1n9 +0 PM";
$lang['autoprunemypmfoldersevery'] = "auT0 prUn3 My pM fOldErS EvERY:";
$lang['friendsonly'] = "fRi3nD5 oNlY?";
$lang['globalstyles'] = "gL08aL 5+yL3s";
$lang['forumstyles'] = "f0rum STyl3S";
$lang['youmustenteryourcurrentpasswd'] = "j00 mus+ 3nT3r yoUr CUrr3NT P@5sw0RD";
$lang['youmustenteranewpasswd'] = "j00 mUst eN+3R 4 nEw p@\$5w0rD";
$lang['youmustconfirmyournewpasswd'] = "j00 musT C0NphiRm y0uR N3w P@\$SW0rd";
$lang['failedtoupdateuserprofile'] = "f@il3D T0 UPD@+3 UsEr pR0FiL3";

// Polls (create_poll.php, poll_results.php) ---------------------------------------------

$lang['mustprovideanswergroups'] = "j00 mu\$t pr0v1D3 s0mE 4n\$W3r 9R0up\$";
$lang['mustprovidepolltype'] = "j00 MU\$+ pRov1D3 4 P0ll typE";
$lang['mustprovidepollresultsdisplaytype'] = "j00 MUst pRoViDE R3sUl+s d1spl4y +YpE";
$lang['mustprovidepollvotetype'] = "j00 MUs+ Pr0viDE @ poll vO+3 +yPE";
$lang['mustprovidepollguestvotetype'] = "j00 mUs+ \$P3c1fy iPh 9u3STs \$H0uld BE @LL0W3d tO VotE";
$lang['mustprovidepolloptiontype'] = "j00 mus+ pR0vID3 4 poll 0P+1On tYp3";
$lang['mustprovidepollchangevotetype'] = "j00 must pRoVIDe @ PoLl CHanGE Vo+3 +Yp3";
$lang['pollquestioncontainsinvalidhtml'] = "oNe 0R M0re 0F yoUr POLl quES+I0Ns con+@iN\$ inv@L1D HtML.";
$lang['pleaseselectfolder'] = "pl34SE \$ELEc+ a f0LD3r";
$lang['mustspecifyvalues1and2'] = "j00 mU\$t SP3ciphy vAlUEs f0R 4nsWER\$ 1 4nD 2";
$lang['tablepollmusthave2groups'] = "taBul@r F0RM@+ Polls mUs+ H4VE PR3CI\$3lY Two VO+ING GRoUPs";
$lang['nomultivotetabulars'] = "t4buL@R F0RM4+ p0LLS C4nn0T 8e mUl+1-vOt3";
$lang['nomultivotepublic'] = "pU8l1C B4llot\$ C4Nn0t 8E mULT1-vo+3";
$lang['abletochangevote'] = "j00 w1ll bE 4blE t0 ch4ngE Your Vo+3.";
$lang['abletovotemultiple'] = "j00 w1ll Be 4bL3 t0 votE MUlt1PL3 t1m3s.";
$lang['notabletochangevote'] = "j00 WilL n0t 8E 4blE +0 CHAN9e yOur VOtE.";
$lang['pollvotesrandom'] = "nOt3: Poll V0TES @r3 R@NDOMLY 93n3r4+3D PHoR PrEVI3w oNLY.";
$lang['pollquestion'] = "poLL qu3s+10N";
$lang['possibleanswers'] = "pOss18L3 4n5W3R5";
$lang['enterpollquestionexp'] = "eN+er +3h 4N5W3rs phoR Y0UR P0Ll qU3S+1on.. If yOUR P0lL I5 @ &quot;Y3S/N0&quot; qUES+1On, siMplY 3ntER &quot;y3s&quot; PHor aNsWER 1 4ND &quot;n0&quot; f0r 4NsWer 2.";
$lang['numberanswers'] = "nO. 4N\$WER\$";
$lang['answerscontainHTML'] = "anSw3r\$ C0n+@In H+mL (nO+ InclUD1ng 51Gn4+UrE)";
$lang['optionsdisplay'] = "anSw3r\$ D1\$pl@y TyPE";
$lang['optionsdisplayexp'] = "hOw \$H0ulD +3H 4n\$W3rs b3 prEsENTed?";
$lang['dropdown'] = "a5 DRoP-D0wN lIs+(5)";
$lang['radios'] = "aS 4 S3R1es of r4D10 8U+t0n\$";
$lang['votechanging'] = "votE Ch4n9iNg";
$lang['votechangingexp'] = "c@n @ PEr\$0n CH4n9E His OR H3R Vo+e?";
$lang['guestvoting'] = "gU3\$t VOt1NG";
$lang['guestvotingexp'] = "c4N 9U35+\$ vo+3 1N +his p0ll?";
$lang['allowmultiplevotes'] = "alL0W mUL+ipLE Vo+e\$";
$lang['pollresults'] = "pOLL r3\$Ults";
$lang['pollresultsexp'] = "h0W WoulD j00 likE +0 D1\$pl4y +H3 resUlTs 0ph y0ur p0LL?";
$lang['pollvotetype'] = "p0lL v0Tin9 +yPE";
$lang['pollvotesexp'] = "h0w sh0uLD TeH P0ll bE C0NDUCT3d?";
$lang['pollvoteanon'] = "an0nyMousLy";
$lang['pollvotepub'] = "pu8liC B4ll0+";
$lang['horizgraph'] = "h0riz0n+@l 9R@pH";
$lang['vertgraph'] = "v3R+iC4L 9R4ph";
$lang['tablegraph'] = "t4bUlaR pHormat";
$lang['polltypewarning'] = "<b>w@Rn1ng</b>: Th1\$ I\$ 4 pUBL1c baLLO+. y0ur n@m3 w1Ll 8e v1\$i8lE n3XT +0 ThE op+IoN j00 Vo+E pHor.";
$lang['expiration'] = "exP1R@+i0n";
$lang['showresultswhileopen'] = "d0 j00 W@N+ +o shOw RE\$ULTs WhIl3 +Eh pOlL i\$ oPen?";
$lang['whenlikepollclose'] = "wHen w0UlD j00 l1K3 Y0UR p0lL To aU+oM@+1C4lly CL0SE?";
$lang['oneday'] = "oN3 d4Y";
$lang['threedays'] = "tHr3E D4Ys";
$lang['sevendays'] = "sEV3n D4ys";
$lang['thirtydays'] = "thIR+y D4y\$";
$lang['never'] = "n3V3r";
$lang['polladditionalmessage'] = "addI+10nal mEss@G3 (0pti0naL)";
$lang['polladditionalmessageexp'] = "dO j00 wanT T0 1NCLUD3 @N @Dd1+ION@l p0ST 4pH+3r +h3 Poll?";
$lang['mustspecifypolltoview'] = "j00 MUS+ \$p3C1phy 4 p0LL +0 vi3w.";
$lang['pollconfirmclose'] = "ar3 j00 sur3 J00 W4NT +O CLOse TH3 pHoLl0w1Ng poLl?";
$lang['endpoll'] = "end poLL";
$lang['nobodyvotedclosedpoll'] = "nob0DY v0teD";
$lang['votedisplayopenpoll'] = "%s 4ND %s haV3 VoTED.";
$lang['votedisplayclosedpoll'] = "%s 4nd %s V0+3D.";
$lang['nousersvoted'] = "nO u53rs";
$lang['oneuservoted'] = "1 Us3R";
$lang['xusersvoted'] = "%s U\$ERs";
$lang['noguestsvoted'] = "no gu3\$+S";
$lang['oneguestvoted'] = "1 GUESt";
$lang['xguestsvoted'] = "%s GUEsts";
$lang['pollhasended'] = "pOll h@s 3Nded";
$lang['youvotedforpolloptionsondate'] = "j00 vo+3D F0R %s on %s";
$lang['thisisapoll'] = "tHIS 1\$ @ poll. CLICK to vI3w R3SUlTs.";
$lang['editpoll'] = "eDi+ poll";
$lang['results'] = "r3SULTs";
$lang['resultdetails'] = "r3SuL+ D3+4ils";
$lang['changevote'] = "cH@NGE V0TE";
$lang['pollshavebeendisabled'] = "poLl5 h4VE 8eEN D1\$@BLEd BY +h3 f0rUm 0wn3r.";
$lang['answertext'] = "an\$wer +3x+";
$lang['answergroup'] = "aN\$WEr 9r0uP";
$lang['previewvotingform'] = "previEW V0T1n9 pHoRm";
$lang['viewbypolloption'] = "v13W 8Y p0Ll 0p+I0N";
$lang['viewbyuser'] = "vI3W 8y u53r";

// Profiles (profile.php) ----------------------------------------------

$lang['editprofile'] = "edIt pRoPhILE";
$lang['profileupdated'] = "prOfIle UpD4t3D.";
$lang['profilesnotsetup'] = "th3 foRuM Own3r h@\$ not SET UP PR0ph1l3s.";
$lang['ignoreduser'] = "i9N0RED U\$3r";
$lang['lastvisit'] = "laST v1\$i+";
$lang['userslocaltime'] = "user'\$ loC4l +1m3";
$lang['userstatus'] = "st@+U5";
$lang['useractive'] = "onl1ne";
$lang['userinactive'] = "iN4C+1V3 / OphPhL1N3";
$lang['totaltimeinforum'] = "tOtaL TIm3";
$lang['longesttimeinforum'] = "l0n93\$+ \$E\$S10n";
$lang['sendemail'] = "s3ND 3MA1L";
$lang['sendpm'] = "send pm";
$lang['visithomepage'] = "vi\$1t HOm3p4G3";
$lang['age'] = "a93";
$lang['aged'] = "a93D";
$lang['birthday'] = "bIr+hD@y";
$lang['registered'] = "r3g15+Er3D";
$lang['findpostsmadebyuser'] = "f1nD P0\$+s M@D3 BY %s";
$lang['findpostsmadebyme'] = "f1ND pOsts m4DE 8y m3";
$lang['profilenotavailable'] = "pR0PhiL3 N0T 4V@IL48LE.";
$lang['userprofileempty'] = "tH15 US3r h4\$ no+ PH1LL3D 1n TH3IR PROpH1l3 0r i+ I5 s3t +0 PRIV@+3.";

// Registration (register.php) -----------------------------------------

$lang['newuserregistrationsarenotpermitted'] = "s0rry, n3w U53r RE9is+R@+I0ns 4rE No+ AlLOW3D R1ght Now. PlE4sE ChEck b@CK LAtEr.";
$lang['usernameinvalidchars'] = "u5ern4ME C@N Only C0n+@IN A-Z, 0-9, _ - CH@R@C+3rs";
$lang['usernametooshort'] = "uSern@ME MUst 8e 4 M1niMum OpH 2 CH@R4CTERS l0n9";
$lang['usernametoolong'] = "useRN4m3 mU5+ b3 @ m@X1MUM 0f 15 ChAR@cter\$ l0NG";
$lang['usernamerequired'] = "a l090n n4m3 1\$ r3QU1R3D";
$lang['passwdmustnotcontainHTML'] = "p@Ssword mUst n0+ COn+41N h+ML T4G\$";
$lang['passwordinvalidchars'] = "p@5SW0rd CAN ONLy COnTA1N a-z, 0-9, _ - CH@RaC+3r\$";
$lang['passwdtooshort'] = "p4\$Sw0rd mU\$+ 8E @ minImUM 0ph 6 CH@r@c+ER\$ l0n9";
$lang['passwdrequired'] = "a P@S\$w0RD I\$ R3qu1r3D";
$lang['confirmationpasswdrequired'] = "a conFirma+1On p4sswOrd i\$ rEQU1R3d";
$lang['nicknamerequired'] = "a nickN@m3 i\$ R3QU1r3D";
$lang['emailrequired'] = "an em4Il 4ddRE\$s iS REqUIR3D";
$lang['passwdsdonotmatch'] = "p4SSW0rD5 DO NoT M4TCH";
$lang['usernamesameaspasswd'] = "usERn4M3 4ND p45sworD mu5t B3 DifPhER3N+";
$lang['usernameexists'] = "s0rry, @ U\$3R wItH th4+ nAm3 4LR34Dy Ex1StS";
$lang['successfullycreateduseraccount'] = "succ3ssfullY CrEA+3d u\$er acC0unT";
$lang['useraccountcreatedconfirmfailed'] = "yoUr U\$ER ACcOUN+ h@s BEEN cRE4+3D 8U+ +3h r3QUir3d C0nphiRM@T10n Ema1l w4S n0t SEN+. Pl3ase C0n+@ct +h3 phoruM oWN3R +0 REct1phy th15. 1n +His m34nt1m3 plE@5e CL1ck +hE COn+iNu3 8Utton To lO91n iN.";
$lang['useraccountcreatedconfirmsuccess'] = "y0UR Us3R 4ccOUnT h@5 8eEn CrE4teD bU+ B3f0Re j00 Can 5+@R+ PosT1N9 j00 mus+ CONpHirM Y0UR 3M4il 4dDrE\$S. pL3453 ChECK y0Ur 3M41L Phor 4 LInK +H@T W1Ll 4Ll0w j00 +o CONfirM Y0UR aDDR35s.";
$lang['useraccountcreated'] = "y0UR u\$ER @cCount H4\$ 8E3N cREa+3d sUCCEssFUllY! cl1CK TEH c0N+InU3 8UTton 83low +0 l0g1N";
$lang['errorcreatinguserrecord'] = "eRROr CrEat1NG U\$3r REc0RD";
$lang['userregistration'] = "uS3r r3915Tr4t1On";
$lang['registrationinformationrequired'] = "r391S+r4t1on InPh0RMaT1ON (rEQUiR3D)";
$lang['profileinformationoptional'] = "pR0fil3 1NFOrM4+i0N (oPt10nal)";
$lang['preferencesoptional'] = "pRepheR3nC3S (Opt1on4l)";
$lang['register'] = "rEg1s+er";
$lang['rememberpasswd'] = "rEMEm8eR P@\$\$w0RD";
$lang['birthdayrequired'] = "y0ur D4Te 0F 8ir+h is rEquIRED OR Is 1nv4Lid";
$lang['alwaysnotifymeofrepliestome'] = "n0T1fy on r3ply tO mE";
$lang['notifyonnewprivatemessage'] = "n0+1phy 0N n3w PR1V@+3 m3SS49E";
$lang['popuponnewprivatemessage'] = "p0p up On n3w pr1v4TE mE\$s@ge";
$lang['automatichighinterestonpost'] = "aUT0m@+Ic H19h inTEr3ST 0n Po\$+";
$lang['confirmpassword'] = "c0NpH1RM p45\$w0RD";
$lang['invalidemailaddressformat'] = "inV4L1D ema1L 4ddR3Ss pH0rM4t";
$lang['moreoptionsavailable'] = "mOre pr0PhIlE 4Nd pr3FErEnCE 0pti0N5 Ar3 4VA1L48lE 0NC3 j00 r3GIS+3R";
$lang['textcaptchaconfirmation'] = "c0NF1rma+1On";
$lang['textcaptchaexplain'] = "t0 tH3 rIgH+ 1\$ @ +3XT-C@p+CH4 1Ma93. PlE4s3 tYpE Th3 C0d3 j00 C4n se3 1N Th3 im@gE 1n+0 thE INPUT ph1elD 8ELOW iT.";
$lang['textcaptchaimgtip'] = "th1s 1S @ c4pTch4-piCTuR3. I+ 1\$ useD +o Pr3VENT 4utoM@TiC re91S+R4+ion";
$lang['textcaptchamissingkey'] = "a c0nFiRM4TIoN COD3 i5 REQUIRED.";
$lang['textcaptchaverificationfailed'] = "teXT-C@pTCh4 vEr1phiC4+ION C0DE w@\$ INC0rrEcT. PLE4SE R3-EnTER 1+.";
$lang['forumrules'] = "foRUM rUl35";
$lang['forumrulesnotification'] = "iN 0RD3r +o PR0cE3D, j00 Mus+ @9R3e WITh +h3 F0ll0W1ng rUl3s";
$lang['forumrulescheckbox'] = "i H@V3 r34D, @ND 4GR3e t0 4b1D3 8Y th3 F0rum rUL3S.";
$lang['youmustagreetotheforumrules'] = "j00 must 49r3E +0 ThE ph0rum rUlE5 83F0RE J00 C4n C0N+InuE.";

// Recent visitors list  (visitor_log.php) -----------------------------

$lang['member'] = "mEm8ER";
$lang['searchforusernotinlist'] = "sE@RCH pHor @ UsEr no+ iN l1\$t";
$lang['yoursearchdidnotreturnanymatches'] = "yOuR 53arCH DID No+ rETUrN Any m@+CHES. try \$1mpliFYing YoUR se4rCh p4RaMEtER\$ 4nd tRy ag41n.";
$lang['hiderowswithemptyornullvalues'] = "hIdE roW\$ w1th Emp+y 0r nUll v@lU3S In s3l3c+3D COlUMn5";
$lang['showregisteredusersonly'] = "sHow R3g1\$TER3d Users 0NlY (h1d3 9u3Sts)";

// Relationships (user_rel.php) ----------------------------------------

$lang['relationships'] = "reLAT10n\$hIp\$";
$lang['userrelationship'] = "u5ER REL@+i0nSHIP";
$lang['userrelationships'] = "uSer REL@+10nship5";
$lang['failedtoremoveselectedrelationships'] = "f41l3D +0 rEMOVE sEL3c+eD rEL@ti0n5HiP";
$lang['friends'] = "fr13NDs";
$lang['ignoredcompletely'] = "iGNOR3D ComPL3TELY";
$lang['relationship'] = "relat10N\$HIp";
$lang['restorenickname'] = "rESToRE UsER's niCKN@m3";
$lang['friend_exp'] = "u\$3r'\$ poS+s m@rkED WI+h @ &quot;Fr13nD&quot; 1CON.";
$lang['normal_exp'] = "u\$Er'\$ P0st5 apP34r 45 nOrM4L.";
$lang['ignore_exp'] = "u5er'5 p0sT5 AR3 hIDD3n.";
$lang['ignore_completely_exp'] = "threaDs @nD p0\$+S T0 0R fr0m U53R will @ppe4R D3le+ED.";
$lang['display'] = "dIspl@y";
$lang['displaysig_exp'] = "u\$er'S 5i9n@+UrE Is D1spl4YED 0n THEIR p0S+5.";
$lang['hidesig_exp'] = "u5ER'\$ 5ign4+URE 1s HIDDEN 0N Th31r p0STs.";
$lang['cannotignoremod'] = "j00 C4nn0+ i9n0RE +h1\$ UseR, 4\$ +H3y 4r3 @ m0DERAtor.";
$lang['previewsignature'] = "prev13W \$19n4+uRE";

// Search (search.php) -------------------------------------------------

$lang['searchresults'] = "s3ArCh resul+\$";
$lang['usernamenotfound'] = "t3H U53rn4mE j00 \$pecIpHiED iN +hE To 0r phrom fIELd W4S not pHouND.";
$lang['notexttosearchfor'] = "oN3 0r 4ll oF yOur \$34Rch K3ywOrDS W3r3 Inv4l1D. 534rCH k3YWORDS MUst 8e No \$hortER ThAn %d CH4r4C+3r\$, no L0N9er tH4N %d CH4R@C+ER\$ @ND MU\$+ nO+ apP34r IN +3h %s";
$lang['keywordscontainingerrors'] = "k3Yw0RDs con+@InIng 3RROr\$: %s";
$lang['mysqlstopwordlist'] = "mY\$QL 5+0pW0RD LiSt";
$lang['foundzeromatches'] = "f0unD: 0 M4tcHes";
$lang['found'] = "f0UnD";
$lang['matches'] = "m4+CH3s";
$lang['prevpage'] = "pRevIous p49e";
$lang['findmore'] = "fInd More";
$lang['searchmessages'] = "se4rCH mes\$@ge\$";
$lang['searchdiscussions'] = "se4rCh D1\$Cu\$S1on5";
$lang['find'] = "fiND";
$lang['additionalcriteria'] = "aDd1T1on@l Cr1+eRi@";
$lang['searchbyuser'] = "s3@rCh 8Y U\$3r (optiOn4L)";
$lang['folderbrackets_s'] = "fOLDER(s)";
$lang['postedfrom'] = "p0S+ED phR0M";
$lang['postedto'] = "pOstEd +O";
$lang['today'] = "t0d4Y";
$lang['yesterday'] = "yE\$terD4Y";
$lang['daybeforeyesterday'] = "d4Y BeForE yES+3rd4Y";
$lang['weekago'] = "%s we3k 4G0";
$lang['weeksago'] = "%s W3Eks @G0";
$lang['monthago'] = "%s MOn+h 4Go";
$lang['monthsago'] = "%s mon+H\$ 490";
$lang['yearago'] = "%s ye4r @g0";
$lang['beginningoftime'] = "bEginning Of t1ME";
$lang['now'] = "noW";
$lang['lastpostdate'] = "laS+ post D@+3";
$lang['numberofreplies'] = "numB3R Of r3PL1E5";
$lang['foldername'] = "f0LD3R N4me";
$lang['authorname'] = "aU+hOR nAME";
$lang['decendingorder'] = "n3w3ST PH1RsT";
$lang['ascendingorder'] = "oLD3ST F1r\$+";
$lang['keywords'] = "k3YW0rd\$";
$lang['sortby'] = "s0R+ 8Y";
$lang['sortdir'] = "sOR+ DIR";
$lang['sortresults'] = "s0Rt rE\$ul+5";
$lang['groupbythread'] = "gR0up 8y +HR3ad";
$lang['postsfromuser'] = "p0S+S PhRom U5er";
$lang['poststouser'] = "pOsts +0 u\$er";
$lang['poststoandfromuser'] = "pOS+5 +0 4nD phr0m US3r";
$lang['searchfrequencyerror'] = "j00 C4n ONLy \$3arCH oNC3 evEry %s 53conD\$. Pl3453 +ry 494in l4+3R.";
$lang['searchsuccessfullycompleted'] = "se4rcH \$uCce5\$FUlLy C0MpL3+3D. %s";
$lang['clickheretoviewresults'] = "cl1Ck HEre +0 vI3w rE\$ulTS.";

// Search Popup (search_popup.php) -------------------------------------

$lang['select'] = "s3l3Ct";
$lang['searchforthread'] = "se@rcH f0r +HRe4d";
$lang['mustspecifytypeofsearch'] = "j00 mu\$T sP3CIFy typ3 0Ph sE4RCH +o PErf0rm";
$lang['unkownsearchtypespecified'] = "unKN0wN sE4Rch typ3 SP3ciphI3D";
$lang['mustentersomethingtosearchfor'] = "j00 MusT EN+Er 5OM3th1NG +o \$34RCH pH0r";

// Start page (start_left.php) -----------------------------------------

$lang['recentthreads'] = "r3cen+ thRE4D5";
$lang['startreading'] = "s+4r+ ReaDINg";
$lang['threadoptions'] = "tHrEad oPt10n\$";
$lang['editthreadoptions'] = "eDit thrE4D 0pt10n\$";
$lang['morevisitors'] = "more vI\$1+ors";
$lang['forthcomingbirthdays'] = "f0RThC0miNg B1r+hd@yS";

// Start page (start_main.php) -----------------------------------------

$lang['editstartpage_help'] = "j00 c4n Ed1+ +HIs p4G3 fr0M ThE aDM1n 1N+ErPh@c3";
$lang['uploadstartpage'] = "uplo4D st4rt P@g3 (%s)";
$lang['invalidfiletypeerror'] = "f1l3 Typ3 N0t supPoRtED. j00 C4N oNlY UsE %s PHILEs @\$ YOUR \$+4rt p@g3.";

// Thread navigation (thread_list.php) ---------------------------------

$lang['newdiscussion'] = "neW DIsCUsS10n";
$lang['createpoll'] = "cR3@TE P0Ll";
$lang['search'] = "s34RCh";
$lang['searchagain'] = "se4Rch 4G41n";
$lang['alldiscussions'] = "all d1SCussi0N\$";
$lang['unreaddiscussions'] = "unre4D d1\$cus\$1on\$";
$lang['unreadtome'] = "unR34D &quot;tO: me&quot;";
$lang['todaysdiscussions'] = "t0d@y'S DI\$cussi0Ns";
$lang['2daysback'] = "2 Days 84Ck";
$lang['7daysback'] = "7 D4Ys 84cK";
$lang['highinterest'] = "h19H 1N+3RE\$t";
$lang['unreadhighinterest'] = "unR3ad higH iN+3REst";
$lang['iverecentlyseen'] = "i've rEC3ntly \$3EN";
$lang['iveignored'] = "i've 1gn0RED";
$lang['byignoredusers'] = "by 1gnoreD UsER5";
$lang['ivesubscribedto'] = "i'V3 \$u8SCr1b3D +0";
$lang['startedbyfriend'] = "s+4r+eD BY PHrIend";
$lang['unreadstartedbyfriend'] = "unR34d stD 8y fr1ENd";
$lang['startedbyme'] = "sT@r+ED BY m3";
$lang['unreadtoday'] = "uNrE4d +OD@y";
$lang['deletedthreads'] = "d3LEt3d Thre4d5";
$lang['goexcmark'] = "go!";
$lang['folderinterest'] = "f0LD3r in+ER3s+";
$lang['postnew'] = "pOst n3w";
$lang['currentthread'] = "cUrrEN+ thRE4D";
$lang['highinterest'] = "hI9H iN+3REs+";
$lang['markasread'] = "mARK as READ";
$lang['next50discussions'] = "n3XT 50 D1\$CUS\$i0Ns";
$lang['visiblediscussions'] = "vis1bLe dI\$CUs\$1on\$";
$lang['selectedfolder'] = "seLECTED phoLDER";
$lang['navigate'] = "n@vig4tE";
$lang['couldnotretrievefolderinformation'] = "th3r3 @r3 n0 f0lD3R\$ @V@il@bl3.";
$lang['nomessagesinthiscategory'] = "nO M3S\$493s in +hIs c4t3G0ry. pL3@\$3 s3LECT 4no+h3r, or %s FOr 4Ll +Hr34Ds";
$lang['clickhere'] = "cL1Ck hER3";
$lang['prev50threads'] = "pr3v10u5 50 +hR34d\$";
$lang['next50threads'] = "n3xt 50 +hr34D5";
$lang['nextxthreads'] = "n3xt %s tHrE4ds";
$lang['threadstartedbytooltip'] = "thRE4d #%s S+4rtED 8Y %s. VI3weD %s";
$lang['threadviewedonetime'] = "1 +im3";
$lang['threadviewedtimes'] = "%d +1m3s";
$lang['unreadthread'] = "uNr3@D thr3@D";
$lang['readthread'] = "re4d thRE4d";
$lang['unreadmessages'] = "unr34d mess@Ge\$";
$lang['subscribed'] = "sU8\$criBed";
$lang['ignorethisfolder'] = "i9noR3 th1\$ f0LDER";
$lang['stopignoringthisfolder'] = "st0p 1gn0rInG +his ph0lD3R";
$lang['stickythreads'] = "s+Icky thre4ds";
$lang['mostunreadposts'] = "most unr34d p0ST5";
$lang['onenew'] = "%d new";
$lang['manynew'] = "%d nEw";
$lang['onenewoflength'] = "%d N3W 0PH %d";
$lang['manynewoflength'] = "%d new 0ph %d";
$lang['ignorefolderconfirm'] = "aRe J00 \$ur3 J00 w@n+ +0 1gN0Re +hI\$ f0lD3r?";
$lang['unignorefolderconfirm'] = "are J00 \$urE j00 W4N+ +O \$+0p 1Gn0R1Ng +hI\$ folDer?";
$lang['confirmmarkasread'] = "aR3 j00 sur3 J00 w4Nt to m4rk TEH \$3l3ctED ThrE4d\$ AS r34D?";
$lang['successfullymarkreadselectedthreads'] = "sUCCE\$SFULly m4rked \$3l3C+3d +hr3ADs 4\$ reAD";
$lang['failedtomarkselectedthreadsasread'] = "f41l3d T0 mark \$3l3C+ED ThRE4D\$ as r3@D";
$lang['gotofirstpostinthread'] = "g0 +o ph1R5+ Po\$+ 1n ThR3AD";
$lang['gotolastpostinthread'] = "g0 +0 l45+ po\$+ 1n +Hr34d";
$lang['viewmessagesinthisfolderonly'] = "vI3W meS\$49ES 1n TH1\$ pHolDER 0NlY";
$lang['shownext50threads'] = "sHow N3xt 50 thrE@D\$";
$lang['showprev50threads'] = "sh0w pr3vious 50 +hr34DS";
$lang['createnewdiscussioninthisfolder'] = "cReatE n3w D15cus\$1on 1N +HiS pHoldER";
$lang['nomessages'] = "n0 MES\$49es";

// HTML toolbar (htmltools.inc.php) ------------------------------------
$lang['bold'] = "b0LD";
$lang['italic'] = "i+4liC";
$lang['underline'] = "uNDErL1NE";
$lang['strikethrough'] = "s+R1KE+hR0ugh";
$lang['superscript'] = "sup3rsCr1P+";
$lang['subscript'] = "sUbscr1PT";
$lang['leftalign'] = "l3f+-4L19N";
$lang['center'] = "c3n+Er";
$lang['rightalign'] = "rI9hT-4l1Gn";
$lang['numberedlist'] = "nUmB3reD Li\$+";
$lang['list'] = "l1\$+";
$lang['indenttext'] = "inden+ +3x+";
$lang['code'] = "c0de";
$lang['quote'] = "qU0TE";
$lang['spoiler'] = "sPo1L3r";
$lang['horizontalrule'] = "h0r1ZON+@l rULE";
$lang['image'] = "iM49e";
$lang['hyperlink'] = "hYp3RLInK";
$lang['noemoticons'] = "dI\$4BLE 3MO+1con\$";
$lang['fontface'] = "f0N+ ph@CE";
$lang['size'] = "s1ZE";
$lang['colour'] = "cOLOUr";
$lang['red'] = "r3D";
$lang['orange'] = "oR4N9e";
$lang['yellow'] = "yeLL0w";
$lang['green'] = "grEEN";
$lang['blue'] = "bLU3";
$lang['indigo'] = "iNd1g0";
$lang['violet'] = "v1oL3+";
$lang['white'] = "wHi+3";
$lang['black'] = "bL4Ck";
$lang['grey'] = "gr3y";
$lang['pink'] = "pINK";
$lang['lightgreen'] = "l19h+ 9RE3n";
$lang['lightblue'] = "l1GHt BlUe";

// Forum Stats (messages.inc.php - messages_forum_stats()) -------------

$lang['forumstats'] = "f0RUM 5t4+\$";
$lang['usersactiveinthepasttimeperiod'] = "%s 4C+iV3 in +HE Pas+ %s.";

$lang['numactiveguests'] = "<b>%s</b> 9uEs+5";
$lang['oneactiveguest'] = "<b>1</b> 9U3st";
$lang['numactivemembers'] = "<b>%s</b> mem83r\$";
$lang['oneactivemember'] = "<b>1</b> m3Mb3r";
$lang['numactiveanonymousmembers'] = "<b>%s</b> @n0NYm0uS M3mbErs";
$lang['oneactiveanonymousmember'] = "<b>1</b> @n0Nym0us M3mBeR";

$lang['numthreadscreated'] = "<b>%s</b> +hre4ds";
$lang['onethreadcreated'] = "<b>1</b> +hre4D";
$lang['numpostscreated'] = "<b>%s</b> Pos+S";
$lang['onepostcreated'] = "<b>1</b> post";

$lang['younormal'] = "j00";
$lang['youinvisible'] = "j00 (1NvI\$IBLE)";
$lang['viewcompletelist'] = "v1ew COmpl3+3 LisT";
$lang['ourmembershavemadeatotalofnumthreadsandnumposts'] = "ouR m3M8ERs h@vE M4D3 a +o+@l oph %s 4nd %s.";
$lang['longestthreadisthreadnamewithnumposts'] = "l0n9est thr3@D 1\$ <b>%s</b> w1+h %s.";
$lang['therehavebeenxpostsmadeinthelastsixtyminutes'] = "th3re h4v3 8EEN <b>%s</b> pO5+s M@D3 1n +He laS+ 60 m1NuT3S.";
$lang['therehasbeenonepostmadeinthelastsxityminutes'] = "ther3 H45 8eeN <b>1</b> P0st m4DE in thE l@5+ 60 minUtES.";
$lang['mostpostsevermadeinasinglesixtyminuteperiodwasnumposts'] = "mOs+ Po\$+s EvER m4de iN @ \$INGL3 60 m1nutE per10D i5 <b>%s</b> ON %s.";
$lang['wehavenumregisteredmembersandthenewestmemberismembername'] = "w3 h4v3 <b>%s</b> r3gIs+Er3d M3mb3R\$ 4nD +h3 N3w3ST m3M83r 1s <b>%s</b>.";
$lang['wehavenumregisteredmember'] = "w3 h@V3 %s r3G15+3rED meM83R5.";
$lang['wehaveoneregisteredmember'] = "we H@V3 oN3 r3GIStEr3d meM83r.";
$lang['mostuserseveronlinewasnumondate'] = "m0ST uSERS Ev3R 0nLin3 w@\$ <b>%s</b> 0n %s.";
$lang['statsdisplayenabled'] = "s+4TS d1sPL4y en4bLED";

// Thread Options (thread_options.php) ---------------------------------

$lang['updatessavedsuccessfully'] = "upd4+3\$ s4vEd \$UCcESSpHuLLy";
$lang['useroptions'] = "u5er 0pt10nS";
$lang['markedasread'] = "m4rK3D @s R3@d";
$lang['postsoutof'] = "p0\$t\$ OUT 0F";
$lang['interest'] = "in+ErESt";
$lang['closedforposting'] = "cl053d f0R po\$+INg";
$lang['locktitleandfolder'] = "l0ck +i+LE 4ND pHOldER";
$lang['deletepostsinthreadbyuser'] = "d3L3T3 Post5 IN thRe4d 8Y UsEr";
$lang['deletethread'] = "d3l3t3 +Hr3AD";
$lang['permenantlydelete'] = "p3RMan3N+Ly D3L3+3";
$lang['movetodeleteditems'] = "mov3 to deL3TED +Hr3@d\$";
$lang['undeletethread'] = "undelE+E ThrE4d";
$lang['threaddeletedpermenantly'] = "tHre4d DeL3tED pERm@n3NTLY. cAnn0+ UnDEL3TE.";
$lang['markasunread'] = "m4rK 4S unRE4D";
$lang['makethreadsticky'] = "m@k3 +hr34d st1cKy";
$lang['threareadstatusupdated'] = "threAd r34D s+4Tus upD4t3D 5uCCES\$FULly";
$lang['interestupdated'] = "threaD iN+3RE\$+ s+@TU\$ upD@+3d sUCC3s5fUlLy";
$lang['failedtoupdatethreadreadstatus'] = "f4Il3D t0 upD@+E thrE4D r34D \$+@+U\$";
$lang['failedtoupdatethreadinterest'] = "f4il3D +0 UPD@tE tHrE@D intEr3St";
$lang['failedtorenamethread'] = "f@IL3d +0 R3name +Hr34D";
$lang['failedtomovethread'] = "f@il3D +0 move ThR34d +0 sP3CIpHi3d Ph0ld3r";
$lang['failedtoupdatethreadstickystatus'] = "f4Il3d +0 UpDA+3 thrE4D stICKy s+4TUs";
$lang['failedtoupdatethreadclosedstatus'] = "f4il3D t0 UPD@+3 +hR3AD CL0S3d ST@tU\$";
$lang['failedtoupdatethreadlockstatus'] = "fail3D +0 UpDAte +Hr34d l0ck \$+4+Us";
$lang['failedtodeletepostsbyuser'] = "f4il3d +0 D3lETE Po5+s BY s3l3c+eD us3r";
$lang['failedtodeletethread'] = "f@ILED to d3L3te +HR34D.";
$lang['failedtoundeletethread'] = "f@1L3d t0 un-d3L3+e tHrE4d";

// Dictionary (dictionary.php) -----------------------------------------

$lang['dictionary'] = "d1CT10n4ry";
$lang['spellcheck'] = "sPEll cH3ck";
$lang['notindictionary'] = "n0+ in DIC+i0n@ry";
$lang['changeto'] = "cH4ng3 tO";
$lang['restartspellcheck'] = "r3\$TAR+";
$lang['cancelchanges'] = "c@nC3L Ch4Ng3S";
$lang['initialisingdotdotdot'] = "in1t1@LI\$1ng...";
$lang['spellcheckcomplete'] = "sp3Ll ch3cK 1s C0mpl3+3. tO RE\$t4Rt spelL CH3CK CliCk REstArT bUttOn 8EL0W.";
$lang['spellcheck'] = "sp3ll ch3ck";
$lang['noformobj'] = "no F0rm 0BJEct sp3CIpH1ED F0R R3+UrN tEX+";
$lang['bodytext'] = "b0dy T3XT";
$lang['ignore'] = "iGn0rE";
$lang['ignoreall'] = "ignORE @lL";
$lang['change'] = "cH@ng3";
$lang['changeall'] = "chANgE @Ll";
$lang['add'] = "aDd";
$lang['suggest'] = "sU9gest";
$lang['nosuggestions'] = "(No suGgEsTi0N5)";
$lang['cancel'] = "c4nCEl";
$lang['dictionarynotinstalled'] = "n0 D1c+10nAry H@\$ b33N 1N\$+4llED. Pl3@\$3 COn+@CT +EH F0rum OwN3R tO REM3dy tH1s.";

// Permissions keys ----------------------------------------------------

$lang['postreadingallowed'] = "pOst r34ding 4ll0WED";
$lang['postcreationallowed'] = "pOS+ CRE4Ti0n 4Ll0w3D";
$lang['threadcreationallowed'] = "tHrE4D CR3At10N 4lloweD";
$lang['posteditingallowed'] = "pOst EDiTing @lL0WED";
$lang['postdeletionallowed'] = "p0st DEl3+10n @lL0w3d";
$lang['attachmentsallowed'] = "a+T4CHM3nTS 4Ll0W3d";
$lang['htmlpostingallowed'] = "hTml p0s+iNG AlLow3d";
$lang['signatureallowed'] = "s19NAtur3 4ll0w3D";
$lang['guestaccessallowed'] = "gUe\$+ 4CCESs @ll0W3D";
$lang['postapprovalrequired'] = "pOST @ppr0V@l r3QU1R3D";

// RSS feeds gubbins

$lang['rssfeed'] = "r5\$ FeED";
$lang['every30mins'] = "evERy 30 M1nutEs";
$lang['onceanhour'] = "once 4n h0Ur";
$lang['every6hours'] = "ev3ry 6 h0ur\$";
$lang['every12hours'] = "eVery 12 hoUrs";
$lang['onceaday'] = "oNC3 @ DaY";
$lang['rssfeeds'] = "rS\$ feeD\$";
$lang['feedname'] = "fEed n4ME";
$lang['feedfoldername'] = "fe3d pholD3R n4m3";
$lang['feedlocation'] = "f3ed loc4t1ON";
$lang['threadtitleprefix'] = "tHr3ad T1+l3 pr3fix";
$lang['feednameandlocation'] = "fe3d n4M3 @ND L0c4tiOn";
$lang['feedsettings'] = "f33D S3++iNg\$";
$lang['updatefrequency'] = "uPd@te fR3QU3nCY";
$lang['rssclicktoreadarticle'] = "cL1ck h3re t0 rE4D tH1s @rtICL3";
$lang['addnewfeed'] = "add n3w pH3ed";
$lang['editfeed'] = "eDi+ fEeD";
$lang['feeduseraccount'] = "fe3d u\$Er aCCOunt";
$lang['noexistingfeeds'] = "n0 3XIS+iN9 rSs f3eD\$ Ph0und. +o @dD a PH3ED CLiCk The '@DD N3W' 8UtT0N bElow";
$lang['rssfeedhelp'] = "hEr3 J00 C@N 5etUp s0m3 r\$S ph3ed5 phoR 4ut0M@+iC PRoP@G@+i0n 1nTo Y0UR phoRuM. +h3 1t3ms phrom tH3 RSs F3EDS J00 4dD wIll 83 CR34+3D @s +hr34D5 WH1CH u\$er\$ C4n rEPly To 4S 1Ph tH3y wERE nOrm@l P0s+\$. Th3 R\$S Ph3eD mUst 8E 4CceSsI8Le vI4 h+tP Or 1+ W1lL not work.";
$lang['mustspecifyrssfeedname'] = "mU5T sp3cify Rss Ph3ed n4me";
$lang['mustspecifyrssfeeduseraccount'] = "mUS+ sP3C1FY rsS FEED US3r @cCoUNt";
$lang['mustspecifyrssfeedfolder'] = "mU5t sp3CiPHy Rss ph3ed PhOlDEr";
$lang['mustspecifyrssfeedurl'] = "mu\$+ sp3C1PhY rS\$ PHe3d UrL";
$lang['mustspecifyrssfeedupdatefrequency'] = "mU5T Sp3c1phy r\$\$ FE3d uPD4t3 fR3QU3ncy";
$lang['unknownrssuseraccount'] = "uNkn0Wn rSs u\$3r @ccounT";
$lang['rssfeedsupportshttpurlsonly'] = "r\$\$ f3ED \$UPPor+s h+tp URLs ONlY. SEcUR3 FE3ds (h++Ps://) @r3 no+ 5upp0RtED.";
$lang['rssfeedurlformatinvalid'] = "r\$\$ FEED Url F0Rm4T i\$ inv@l1d. Url MU5+ iNCLUD3 \$CH3me (E.g. ht+p://) 4ND 4 h05+n4me (3.G. wWw.hOstN4m3.C0m).";
$lang['rssfeeduserauthentication'] = "rSS fe3d D03s N0t suPP0rT HTtP Us3r 4U+HENT1C4+i0n";
$lang['successfullyremovedselectedfeeds'] = "sucCE5\$FULlY r3MOVED 5El3cT3D Ph3ED5";
$lang['successfullyaddedfeed'] = "sUCCEs\$PHULLy @Dded nEW PHEED";
$lang['successfullyeditedfeed'] = "sucCEssfUlly ED1+3D pH3ed";
$lang['failedtoremovefeeds'] = "f41l3D +o REm0VE s0ME 0R @Ll 0pH TH3 \$EL3ctED PH3EDS";
$lang['failedtoaddnewrssfeed'] = "f41l3d T0 4dD n3w r\$\$ FE3d";
$lang['failedtoupdaterssfeed'] = "f4il3D +o UpD4te rss F33D";
$lang['rssstreamworkingcorrectly'] = "r\$5 s+r34M app3ar\$ +0 8e w0RK1ng C0rr3c+ly";
$lang['rssstreamnotworkingcorrectly'] = "rs5 strE4M WAs 3MpTY 0r coULD NO+ 8e foUnD";
$lang['invalidfeedidorfeednotfound'] = "iNv4LiD ph3eD iD Or feed nO+ phOUnD";

// PM Export Options

$lang['pmexportastype'] = "expor+ 4s +Ype";
$lang['pmexporthtml'] = "html";
$lang['pmexportxml'] = "xMl";
$lang['pmexportplaintext'] = "pl41N +3X+";
$lang['pmexportmessagesas'] = "exPOrT mess49Es @\$";
$lang['pmexportonefileforallmessages'] = "oN3 phiLE f0r @Ll meS549e\$";
$lang['pmexportonefilepermessage'] = "on3 f1l3 p3r m3SS@ge";
$lang['pmexportattachments'] = "expORT 4TT@CHmenTs";
$lang['pmexportincludestyle'] = "iNClUDe F0RUM \$+YL3 Sh3e+";
$lang['pmexportwordfilter'] = "apply w0Rd Ph1L+3r +0 mEs\$49es";

// Thread merge / split options

$lang['threadhasbeensplit'] = "tHR3@d h4s BEen \$Pl1+";
$lang['threadhasbeenmerged'] = "tHre4D h@\$ 8EEn M3rGEd";
$lang['mergesplitthread'] = "mErg3 / 5Pl1+ thR3@d";
$lang['mergewiththreadid'] = "mEr9e w1+H +hREaD ID:";
$lang['postsinthisthreadatstart'] = "pos+s 1n +his +HR34d 4+ \$+aRT";
$lang['postsinthisthreadatend'] = "pO\$TS In +h15 +HreaD At EnD";
$lang['reorderpostsintodateorder'] = "rE-0rd3R po5+S in+0 D4+3 0RdER";
$lang['splitthreadatpost'] = "spl1+ +HrEaD @+ PO5+:";
$lang['selectedpostsandrepliesonly'] = "s3L3C+3D p0st @nD repl13S onLy";
$lang['selectedandallfollowingposts'] = "seleCTEd 4nD 4Ll F0ll0W1NG po5+\$";

$lang['threadmovedhere'] = "her3";

$lang['thisthreadhasmoved'] = "<b>tHRE4D5 m3RGEd:</b> +h1\$ THreaD h4\$ M0ved %s";
$lang['thisthreadwasmergedfrom'] = "<b>tHrE4D5 m3RGED:</b> +h1\$ THre4D w4\$ m3R9eD phRoM %s";
$lang['somepostsinthisthreadhavebeenmoved'] = "<b>tHr3@D 5pl1+:</b> S0M3 po\$+s in Th1s +hrEAD HaVE 833N M0veD %s";
$lang['somepostsinthisthreadweremovedfrom'] = "<b>thRE4D \$PL1+:</b> \$0M3 p0STs 1N ThiS ThR34D WER3 M0VEd pHrom %s";

$lang['thisposthasbeenmoved'] = "<b>thre@D \$PLI+:</b> TH1S P0\$+ h4S B33n m0V3D %s";

$lang['invalidfunctionarguments'] = "iNv@l1D PhUnC+1On 4R9UM3nts";
$lang['couldnotretrieveforumdata'] = "c0UlD nO+ R3+rI3Ve f0rUM D@+@";
$lang['cannotmergepolls'] = "oN3 0R mOr3 thRE4ds 1\$ A poLl. j00 C4nnO+ m3rg3 PoLL\$";
$lang['couldnotretrievethreaddatamerge'] = "c0uLD N0+ RETr1evE tHrEad DAT4 pHR0M On3 or More +hR3ADS";
$lang['couldnotretrievethreaddatasplit'] = "coULD n0T r3+r13Ve +hr34d D4+@ fR0M s0urCE tHr3@D";
$lang['couldnotretrievepostdatamerge'] = "cOULD NoT RETri3VE Po\$+ D4+4 pHR0M oNE 0r m0re +hR34ds";
$lang['couldnotretrievepostdatasplit'] = "c0ULD Not re+rI3V3 po\$+ DAT4 fr0m SOuRCE +hR34d";
$lang['failedtocreatenewthreadformerge'] = "fA1l3D To CREA+E N3W +hR34D foR M3R9e";
$lang['failedtocreatenewthreadforsplit'] = "f@1leD +0 CrE4T3 n3W tHre4d f0R \$pl1+";

// Thread subscriptions

$lang['threadsubscriptions'] = "thr34d 5UBsCR1pt10N\$";
$lang['couldnotupdateinterestonthread'] = "coUlD no+ UPD4+3 iNtER3S+ On +Hre4d '%s'";
$lang['threadinterestsupdatedsuccessfully'] = "tHre4d 1N+er3S+S upD@+3d \$UCcEssfUlly";
$lang['nothreadsubscriptions'] = "j00 4re not sUBsCr18eD +0 4NY THrE4ds.";
$lang['resetselected'] = "re\$et \$EL3c+3D";
$lang['allthreadtypes'] = "alL thRE4D +yP3S";
$lang['ignoredthreads'] = "i9n0rED +hr3@ds";
$lang['highinterestthreads'] = "hI9h In+3ResT +Hr34Ds";
$lang['subscribedthreads'] = "sU8SCR18ED +Hr34Ds";
$lang['currentinterest'] = "cuRrEN+ 1n+3re5+";

// Browseable user profiles

$lang['youcanonlyaddthreecolumns'] = "j00 C@n 0Nly 4DD 3 COlumN\$. +o @DD 4 nEw COlUMn Cl0SE @N 3X1\$+1n9 0N3";
$lang['columnalreadyadded'] = "j00 have 4lr3@DY 4dDED +his c0lUMn. 1f J00 w4Nt To r3mov3 i+ CliCK 1+'\$ clo\$3 8UTtoN";

?>
